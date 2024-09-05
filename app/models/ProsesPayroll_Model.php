<?php


class ProsesPayroll_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function genHdrPayroll($data)
    {
        try {
            $this->db->transaksi();
             
            $kodeRegAwal = "PRL";
            $formatDateJurnal = Utils::idtrsByDateOnly();
            $Payroll_IDtrs = $data['Payroll_IDtrs'];
            $Payroll_Lokasi = $data['Payroll_Lokasi'];
            $Payroll_Pegawai = $data['Payroll_Pegawai'];
            $Payroll_Periode = $data['Payroll_Periode'];
   
            $this->db->query("SELECT  TOP 1 KODE_TRANSAKSI,right(KODE_TRANSAKSI,3) as urutregx
                                FROM HR_Trs_Payroll  WHERE  
                                SUBSTRING(KODE_TRANSAKSI,4,6)= :formatDateJurnal
                                AND LEFT(KODE_TRANSAKSI,3)=:kodeRegAwal  ORDER BY KODE_TRANSAKSI DESC");
            $this->db->bind('kodeRegAwal', $kodeRegAwal);
            $this->db->bind('formatDateJurnal', $formatDateJurnal);
            $data =  $this->db->single();
            if ($data) {
                $no_reg =  $data['urutregx'];
                $idReg = $no_reg;
                $idReg++;
            } else {
                $idReg = '1';
            }
            // GENERATE NO REGISTRASI
            $noUrutJurnal = Utils::generateAutoNumberFourDigit($idReg);
            $NoJurnalFix = $kodeRegAwal . $formatDateJurnal . '-' . $noUrutJurnal;
            $datenowcreateFull = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userlogin = $session->username; 
            $this->db->query("INSERT INTO HR_Trs_Payroll
                      (KODE_TRANSAKSI,TGL_ENTRY,PETUGAS_ENTRY) values
                      (:NoJurnalFix,:datenowcreateFull,:userid)");
            $this->db->bind('NoJurnalFix', $NoJurnalFix);
            $this->db->bind('datenowcreateFull', $datenowcreateFull);
            $this->db->bind('userid', $userlogin); 
            $this->db->execute();
 
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'NoTRS' => $NoJurnalFix, // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function genDtlPayroll($data)
    {
        try {
            $this->db->transaksi();
            $Payroll_IDtrs = $data['Payroll_IDtrs'];
            $Payroll_Lokasi = $data['Payroll_Lokasi'];
            $Payroll_Pegawai = $data['Payroll_Pegawai'];
            $Payroll_Periode = $data['Payroll_Periode'];
            if ($Payroll_IDtrs == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode Transaksi Kosong, Silahkan cek Kembali Transaksi Anda !',
                );
                return $callback;
                exit;
            }
            if ($Payroll_Lokasi == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Lokasi !',
                );
                return $callback;
                exit;
            }
            if ($Payroll_Pegawai == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Nama Pegawai !',
                );
                return $callback;
                exit;
            }
            if ($Payroll_Periode == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Periode !',
                );
                return $callback; 
            }
            // cek sudah ada generate belum  and ='$Payroll_IDtrs'
            $globalnull="";
            $aktif="1";
            $this->db->query("SELECT *FROM HR_Trs_Payroll 
                            where PETUGAS_BATAL=:globalnull and PERIODE=:Payroll_Periode 
                            AND KODE_PEGAWAI=:Payroll_Pegawai 
                            AND KODE_LOKASI=:Payroll_Lokasi 
                            and KODE_TRANSAKSI<>:Payroll_IDtrs ");
            $this->db->bind('globalnull', $globalnull);
            $this->db->bind('Payroll_Periode', $Payroll_Periode);
            $this->db->bind('Payroll_Pegawai', $Payroll_Pegawai);
            $this->db->bind('Payroll_Lokasi', $Payroll_Lokasi);
            $this->db->bind('Payroll_IDtrs', $Payroll_IDtrs);
            $this->db->execute(); 
            $datarowGen =  $this->db->rowCount();
            if($datarowGen){
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Sudah ada Generate Gaji di Bulan ini !',
                    );
                    return $callback;
                    exit;
            }
            // cek jadwal 
            $this->db->query("SELECT  *from HR_Mst_JADWAL_SHIFT_KERJA 
                            where KODE_PEGAWAI=:Payroll_Pegawai 
                            and PERIODE=:Payroll_Periode "); 
            $this->db->bind('Payroll_Periode', $Payroll_Periode);
            $this->db->bind('Payroll_Pegawai', $Payroll_Pegawai);
            $this->db->execute(); 
            $datarowGen =  $this->db->rowCount();
            if($datarowGen === false){
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Jadwal Pegawai Belum Di Input Pada bulan ' . $Payroll_Periode . ', Cek Data Jadwal !',
                    );
                    return $callback;
                    exit;
            }
           // cek apakah ada komponen payrolnya atau ada tambahan
            $this->db->query("SELECT *FROM HR_Mst_KOMPONEN_PAYROL where  id not in (
                            SELECT kode_komponen 
                            FROM HR_Data_Pegawai_Komp 
                            where kode_pegawai=:Payroll_Pegawai)");  
            $this->db->bind('Payroll_Pegawai', $Payroll_Pegawai);
            $this->db->execute(); 
            $datarowGen =  $this->db->rowCount();
            if($datarowGen){
                    $this->db->query("  INSERT INTO HR_Data_Pegawai_Komp (kode_pegawai,kode_komponen,nilai)
                                        SELECT '$Payroll_Pegawai',ID,'0' FROM HR_Mst_KOMPONEN_PAYROL where  id not in (
                                        SELECT kode_komponen 
                                        FROM HR_Data_Pegawai_Komp 
                                        where kode_pegawai=:Payroll_Pegawai) and AKTIF=:aktif");
                    $this->db->bind('aktif', $aktif);
                    $this->db->bind('Payroll_Pegawai', $Payroll_Pegawai);
                    $this->db->execute();
            }
            // GENERATE NO REGISTRASI 
            $session = SessionManager::getCurrentSession();
            $DateFunc = Utils::datenowcreateNotFull(); 
            $this->db->query("EXEC GeneratePayroll 
                            @ID_DATA=:Payroll_Pegawai,@Periode=:Payroll_Periode,
                            @DateNow=:DateFunc,@IdTransaksi=:Payroll_IDtrs,
                            @IdLokasi=:Payroll_Lokasi");
            $this->db->bind('Payroll_Pegawai', $Payroll_Pegawai);
            $this->db->bind('Payroll_Periode', $Payroll_Periode);
            $this->db->bind('DateFunc', $DateFunc);
            $this->db->bind('Payroll_IDtrs', $Payroll_IDtrs);
            $this->db->bind('Payroll_Lokasi', $Payroll_Lokasi);
            $this->db->execute(); 
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success       
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function getKomponenImbalan($data)
    {
        try {
            $Payroll_IDtrs = $data['Payroll_IDtrs']; 
            $jeniskomponen = "KOMPONEN IMBALAN";
            $this->db->query("SELECT b.NO_URUT,b.NAMA_KOMPONEN,a.NILAI,a.KODE_KOMPONEN
                          FROM HR_Trs_Payroll_2 a
                          inner join HR_Mst_KOMPONEN_PAYROL b
                          on a.KODE_KOMPONEN = b.ID
                          where a.KODE_TRANSAKSI=:Payroll_IDtrs and b.JENIS_KOMPONEN=:jeniskomponen
                          order by b.NO_URUT asc");
            $this->db->bind('Payroll_IDtrs', $Payroll_IDtrs);
            $this->db->bind('jeniskomponen', $jeniskomponen);
            $data =  $this->db->resultSet();
            $rows = array(); 
            foreach ($data as $key) {
                $pasing['NO_URUT'] = $key['NO_URUT'];
                $pasing['NAMA_KOMPONEN'] = $key['NAMA_KOMPONEN'];
                $pasing['KODE_KOMPONEN'] = $key['KODE_KOMPONEN'];
                $pasing['NILAI'] = $key['NILAI'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getKomponenPotongan($data)
    {
        try {
            $Payroll_IDtrs = $data['Payroll_IDtrs'];
            $jeniskomponen = "POTONGAN";
            $this->db->query("SELECT b.NO_URUT,b.NAMA_KOMPONEN,a.NILAI,a.KODE_KOMPONEN
                          FROM HR_Trs_Payroll_2 a
                          inner join HR_Mst_KOMPONEN_PAYROL b
                          on a.KODE_KOMPONEN = b.ID
                          where a.KODE_TRANSAKSI=:Payroll_IDtrs and b.JENIS_KOMPONEN=:jeniskomponen
                          and a.KODE_KOMPONEN NOT IN ('23','25')
                          order by b.NO_URUT asc");
            $this->db->bind('Payroll_IDtrs', $Payroll_IDtrs);
            $this->db->bind('jeniskomponen', $jeniskomponen);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['NO_URUT'] = $key['NO_URUT'];
                $pasing['NAMA_KOMPONEN'] = $key['NAMA_KOMPONEN'];
                $pasing['KODE_KOMPONEN'] = $key['KODE_KOMPONEN'];
                $pasing['NILAI'] = $key['NILAI'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function GeHdrPayrollByIDtrs($data)
    {
        try {
            $Payroll_IDtrs = $data['Payroll_IDtrs'];
            $this->db->query("  SELECT TOTAL_TUNJANGAN,TOTAL_POT,SUB_TOTAL,PPH21,KASBON,GRAND_TOTAL  
                                ,PERIODE,ID,KODE_TRANSAKSI,KODE_PEGAWAI,KODE_LOKASI
                                FROM HR_Trs_Payroll
                                where KODE_TRANSAKSI=:Payroll_IDtrs");
            $this->db->bind('Payroll_IDtrs', $Payroll_IDtrs);
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success',
                'ID' => $data['ID'],
                'KODE_TRANSAKSI' => $data['KODE_TRANSAKSI'],
                'KODE_PEGAWAI' => $data['KODE_PEGAWAI'],
                'KODE_LOKASI' => $data['KODE_LOKASI'],
                'PERIODE' => $data['PERIODE'],   
                'TOTAL_TUNJANGAN' =>   number_format($data['TOTAL_TUNJANGAN'], 2),
                'TOTAL_POTONGAN' =>   number_format($data['TOTAL_POT'], 2),
                'SUB_TOTAL' =>   number_format($data['SUB_TOTAL'], 2),
                'PPH21' =>   number_format($data['PPH21'], 2),
                'KASBON' =>   number_format($data['KASBON'], 2),
                'GRANTOTAL_GAJI' =>   number_format($data['GRAND_TOTAL'], 2),
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function GeHdrPayrollByIDtrsAuto($data)
    {
        try {
            $Payroll_IDtrs = $data['Payroll_IDtrs'];
            $this->db->query("  SELECT TOTAL_TUNJANGAN,TOTAL_POT,SUB_TOTAL,PPH21,KASBON,GRAND_TOTAL  
                                ,PERIODE,ID,KODE_TRANSAKSI,KODE_PEGAWAI,KODE_LOKASI
                                FROM HR_Trs_Payroll
                                where ID=:Payroll_IDtrs");
            $this->db->bind('Payroll_IDtrs', $Payroll_IDtrs);
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success',
                'ID' => $data['ID'],
                'KODE_TRANSAKSI' => $data['KODE_TRANSAKSI'],
                'KODE_PEGAWAI' => $data['KODE_PEGAWAI'],
                'KODE_LOKASI' => $data['KODE_LOKASI'],
                'PERIODE' => $data['PERIODE'],
                'TOTAL_TUNJANGAN' =>   number_format($data['TOTAL_TUNJANGAN'], 2),
                'TOTAL_POTONGAN' =>   number_format($data['TOTAL_POT'], 2),
                'SUB_TOTAL' =>   number_format($data['SUB_TOTAL'], 2),
                'PPH21' =>   number_format($data['PPH21'], 2),
                'KASBON' =>   number_format($data['KASBON'], 2),
                'GRANTOTAL_GAJI' =>   number_format($data['GRAND_TOTAL'], 2),
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDetailPayrolById($data)
    {
        try {
            $Payroll_IDtrs = $data['Payroll_IDtrs'];
            $Id = $data['Id'];
            if ($Payroll_IDtrs == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode Transaksi Kosong, Silahkan cek Kembali Transaksi Anda !',
                );
                return $callback;
                exit;
            }
            if ($Id == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input ID !',
                );
                return $callback;
                exit;
            }  
            $this->db->query("  SELECT b.NO_URUT,b.NAMA_KOMPONEN,a.NILAI
                                FROM HR_Trs_Payroll_2 a
                                inner join HR_Mst_KOMPONEN_PAYROL b
                                on a.KODE_KOMPONEN = b.ID
                                where a.KODE_TRANSAKSI=:Payroll_IDtrs and a.KODE_KOMPONEN=:Id");
            $this->db->bind('Payroll_IDtrs', $Payroll_IDtrs);
            $this->db->bind('Id', $Id);
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success',
                'NAMA_KOMPONEN' => $data['NAMA_KOMPONEN'],
                'NILAI' => $data['NILAI'],
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function updateValueKomponenPayrollbyID($data)
    {
        try {
            $this->db->transaksi();
            $JM_ID = $data['JM_ID'];
            $xNOTransaksi = $data['xNOTransaksi'];
            $xNamaKomponen = $data['xNamaKomponen'];
            $xNIlaiKomponen = $data['xNIlaiKomponen'];
            if ($JM_ID == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode Invalid !',
                );
                return $callback;
                exit;
            }
            if ($xNOTransaksi == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. Transaksi Invalid !',
                );
                return $callback;
                exit;
            }
            if ($xNIlaiKomponen == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Nilai Komponen Invalid !',
                );
                return $callback;
                exit;
            } 


            $this->db->query("  UPDATE HR_Trs_Payroll_2 
                                SET NILAI=:xNIlaiKomponen
                                where KODE_TRANSAKSI=:xNOTransaksi and KODE_KOMPONEN=:JM_ID");
            $this->db->bind('xNIlaiKomponen', $xNIlaiKomponen);
            $this->db->bind('xNOTransaksi', $xNOTransaksi);
            $this->db->bind('JM_ID', $JM_ID);
            $this->db->execute();

            // cari total komponen imbalan
            $namagrupkom= 'KOMPONEN IMBALAN';
            $this->db->query("  SELECT sum(a.NILAI) as IMBALAN
                                FROM HR_Trs_Payroll_2 a
                                inner join HR_Mst_KOMPONEN_PAYROL b
                                on a.KODE_KOMPONEN = b.ID
                                where a.KODE_TRANSAKSI=:xNOTransaksi and b.JENIS_KOMPONEN=:namagrupkom");
            $this->db->bind('xNOTransaksi', $xNOTransaksi);
            $this->db->bind('namagrupkom', $namagrupkom); 
            $this->db->execute();
            $data = $this->db->single();
            $IMBALAN = $data['IMBALAN'];

            // cari total komponen potongan   22 dan 24
            $namagrupkomPOTONGAN = 'POTONGAN';
            $this->db->query("  SELECT sum(a.NILAI)  as POTONGAN
                                FROM HR_Trs_Payroll_2 a
                                inner join HR_Mst_KOMPONEN_PAYROL b
                                on a.KODE_KOMPONEN = b.ID
                                where a.KODE_TRANSAKSI=:xNOTransaksi and 
                                b.JENIS_KOMPONEN=:namagrupkomPOTONGAN and a.KODE_KOMPONEN not in('23','25')");
            $this->db->bind('xNOTransaksi', $xNOTransaksi);
            $this->db->bind('namagrupkomPOTONGAN', $namagrupkomPOTONGAN);
            $this->db->execute();
            $dataPot = $this->db->single();
            $TOTAL_POT = $dataPot['POTONGAN'];
            $SUB_TOTAL = $IMBALAN - $TOTAL_POT;
            // cari total komponen 23
            $this->db->query("  SELECT sum(a.NILAI)  as POTONGAN
                            FROM HR_Trs_Payroll_2 a
                            inner join HR_Mst_KOMPONEN_PAYROL b
                            on a.KODE_KOMPONEN = b.ID
                            where a.KODE_TRANSAKSI=:xNOTransaksi
                            and b.JENIS_KOMPONEN=:namagrupkomPOTONGAN and a.KODE_KOMPONEN  in('23')");
            $this->db->bind('xNOTransaksi', $xNOTransaksi);
            $this->db->bind('namagrupkomPOTONGAN', $namagrupkomPOTONGAN);
            $this->db->execute();
            $datapph21 = $this->db->single();
            $TOTAL_POTPPH21 = $datapph21['POTONGAN'];

            // cari total komponen 25
            $this->db->query("SELECT sum(a.NILAI)  as POTONGAN
                            FROM HR_Trs_Payroll_2 a
                            inner join HR_Mst_KOMPONEN_PAYROL b
                            on a.KODE_KOMPONEN = b.ID
                            where a.KODE_TRANSAKSI=:xNOTransaksi
                            and b.JENIS_KOMPONEN=:namagrupkomPOTONGAN and a.KODE_KOMPONEN  in('25')");
            $this->db->bind('xNOTransaksi', $xNOTransaksi);
            $this->db->bind('namagrupkomPOTONGAN', $namagrupkomPOTONGAN);
            $this->db->execute();
            $dataKasbon = $this->db->single();
            $TOTAL_Kasbon = $dataKasbon['POTONGAN'];

            $GRAND_TOTAL = $SUB_TOTAL - ($TOTAL_POTPPH21 + $TOTAL_Kasbon);

            $this->db->query("UPDATE HR_Trs_Payroll 
                            SET TOTAL_TUNJANGAN=:IMBALAN,
                            TOTAL_POT=:TOTAL_POT,SUB_TOTAL=:SUB_TOTAL,
                            PPH21=:TOTAL_POTPPH21,KASBON=:TOTAL_Kasbon,
                            GRAND_TOTAL=:GRAND_TOTAL 
                            WHERE KODE_TRANSAKSI=:xNOTransaksi");
            $this->db->bind('IMBALAN', $IMBALAN);
            $this->db->bind('TOTAL_POT', $TOTAL_POT);
            $this->db->bind('SUB_TOTAL', $SUB_TOTAL);
            $this->db->bind('TOTAL_POTPPH21', $TOTAL_POTPPH21);
            $this->db->bind('TOTAL_Kasbon', $TOTAL_Kasbon); 
            $this->db->bind('GRAND_TOTAL', $GRAND_TOTAL);
            $this->db->bind('xNOTransaksi', $xNOTransaksi);
            $this->db->execute();

            $this->db->Commit();
            $callback = array(
                'status' => 'success',
            );
            return $callback;
             
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function goFinish($data)
    {
        try {
            $this->db->transaksi();
            $Payroll_IDtrs = $data['Payroll_IDtrs'];  
            if ($Payroll_IDtrs == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan ID Transaksi !',
                );
                return $callback;
                exit;
            } 
            $finish = "1";
            $this->db->query("UPDATE HR_Trs_Payroll SET FINISH=:finish
                            WHERE KODE_TRANSAKSI=:Payroll_IDtrs ");
            $this->db->bind('finish', $finish);
            $this->db->bind('Payroll_IDtrs', $Payroll_IDtrs); 
            $this->db->execute();
            $this->db->Commit();
            $callback = array(
                'status' => 'success',
                'notrs' => 'Transkasi Berhasil Selesai !', // Set array status dengan success   
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function ShowDataListPayroll($data)
    {
        try {
            $Hr_Periode = $_POST['SrcPeriodeBln'];
            $Hr_Lokasi = $_POST['SrcKodeJO'];
            $this->db->query("SELECT a.ID,KODE_TRANSAKSI,KODE_LOKASI,TOTAL_TUNJANGAN,TOTAL_POT,GRAND_TOTAL,
                            PERIODE,KODE_PEGAWAI,b.Nama
                            , case when FINISH='1' THEN 'SELESAI' else 'BELUM SELESAI' end as statustransaksi
                            FROM HR_Trs_Payroll a
                            inner join [HR_Data Pegawai] b on a.KODE_PEGAWAI = b.ID_Data
                            where PETUGAS_BATAL='' and PERIODE=:Hr_Periode and KODE_LOKASI=:Hr_Lokasi");
            $this->db->bind('Hr_Periode', $Hr_Periode);
            $this->db->bind('Hr_Lokasi', $Hr_Lokasi);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $row) {
                $pasing['ID'] = $row['ID'];
                $pasing['KODE_TRANSAKSI'] = $row['KODE_TRANSAKSI'];
                $pasing['PERIODE'] = date('m-Y', strtotime($row['PERIODE']));
                $pasing['KODE_LOKASI'] = $row['KODE_LOKASI'];
                $pasing['TOTAL_TUNJANGAN'] = $row['TOTAL_TUNJANGAN'];
                $pasing['TOTAL_POTONGAN'] = $row['TOTAL_POT'];
                $pasing['GRANTOTAL_GAJI'] = $row['GRAND_TOTAL'];
                $pasing['KODE_PEGAWAI'] = $row['KODE_PEGAWAI'];
                $pasing['Nama'] = $row['Nama'];
                $pasing['statustransaksi'] = $row['statustransaksi'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function goVoidProsesPayroll($data)
    {
        try {
            $this->db->transaksi();
            $Payroll_IDtrs = $data['Payroll_IDtrs'];
            if ($Payroll_IDtrs == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan ID Transaksi !',
                );
                return $callback;
                exit;
            }
            $finish = "1";
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $datenowcreateFull = Utils::seCurrentDateTime();
            $this->db->query("UPDATE HR_Trs_Payroll
                             SET PETUGAS_BATAL=:userid,TGL_BATAL=:datenowcreateFull
                             WHERE KODE_TRANSAKSI=:Payroll_IDtrs  ");
            $this->db->bind('userid', $userid);
            $this->db->bind('Payroll_IDtrs', $Payroll_IDtrs);
            $this->db->bind('datenowcreateFull', $datenowcreateFull);
            $this->db->execute();
            $this->db->Commit();
            $callback = array(
                'status' => 'success',
                'notrs' => 'Transkasi Berhasil Dihapus !', // Set array status dengan success   
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getInfoPayroll($data)
    {
        try {
            $Hr_LokasiProject_Updt = $data['Hr_LokasiProject_Updt'];
            $Hr_Periode = $data['Hr_Periode'];

            if ($Hr_LokasiProject_Updt == "") {
                $this->db->query("SELECT KODE_TRANSAKSI,KODE_PEGAWAI,Nama, KODE_LOKASI, 
                              isnull([19],0) as TUNJANGAN_POKOK,isnull([20],0) as UPAH_POKOK,
                              isnull([21],0) as LEMBUR,isnull([22],0) as POTONGAN_ABSENSI,
                              isnull([23],0) as PPH21,isnull([24],0) as POTONGAN_TL_PSW,isnull([25],0) as KASBON,
                              ((isnull([19],0)+isnull([20],0)+isnull([21],0))  -  (isnull([22],0)+isnull([24],0)) ) - (isnull([23],0)+isnull([25],0))  as TotalGaji
                              FROM (
                                SELECT  a.KODE_TRANSAKSI,a.KODE_PEGAWAI,d.Nama,
                                a.KODE_LOKASI,a.TOTAL_TUNJANGAN,a.TOTAL_POT as TOTAL_POTONGAN,a.GRAND_TOTAL as GRANTOTAL_GAJI,a.PERIODE,b.KODE_KOMPONEN [Quarter],
                                 b.NILAI  as  [REGISTRASI Count]
                                FROM HR_Trs_Payroll a
                                inner join HR_Trs_Payroll_2 b
                                on a.KODE_TRANSAKSI = b.KODE_TRANSAKSI
                                inner join HR_Mst_KOMPONEN_PAYROL c on c.ID = b.KODE_KOMPONEN
                                inner join [HR_Data Pegawai] d on d.ID_Data = a.KODE_PEGAWAI
                                where PETUGAS_BATAL='' and a.PERIODE=:Hr_Periode 
                                ) AS QuarterlyData
                                PIVOT( SUM([REGISTRASI Count])   
                                        FOR Quarter IN ( [19],[20],[21],[22],[23],[24],[25],
                                        [grandtotal])) AS QPivot");
                $this->db->bind('Hr_Periode', $Hr_Periode); 

            }else{
                $this->db->query("SELECT KODE_TRANSAKSI,KODE_PEGAWAI,Nama, KODE_LOKASI, 
                              isnull([19],0) as TUNJANGAN_POKOK,isnull([20],0) as UPAH_POKOK,
                              isnull([21],0) as LEMBUR,isnull([22],0) as POTONGAN_ABSENSI,
                              isnull([23],0) as PPH21,isnull([24],0) as POTONGAN_TL_PSW,isnull([25],0) as KASBON,
                              ((isnull([19],0)+isnull([20],0)+isnull([21],0))  -  (isnull([22],0)+isnull([24],0)) ) - (isnull([23],0)+isnull([25],0))  as TotalGaji
                              FROM (
                                SELECT  a.KODE_TRANSAKSI,a.KODE_PEGAWAI,d.Nama,
                                a.KODE_LOKASI,a.TOTAL_TUNJANGAN,a.TOTAL_POT as TOTAL_POTONGAN,a.GRAND_TOTAL as GRANTOTAL_GAJI,a.PERIODE,b.KODE_KOMPONEN [Quarter],
                                 b.NILAI  as  [REGISTRASI Count]
                                FROM HR_Trs_Payroll a
                                inner join HR_Trs_Payroll_2 b
                                on a.KODE_TRANSAKSI = b.KODE_TRANSAKSI
                                inner join HR_Mst_KOMPONEN_PAYROL c on c.ID = b.KODE_KOMPONEN
                                inner join [HR_Data Pegawai] d on d.ID_Data = a.KODE_PEGAWAI
                                where PETUGAS_BATAL='' and a.PERIODE=:Hr_Periode and a.KODE_LOKASI=:Hr_LokasiProject_Updt
                                ) AS QuarterlyData
                                PIVOT( SUM([REGISTRASI Count])   
                                        FOR Quarter IN ( [19],[20],[21],[22],[23],[24],[25],
                                        [grandtotal])) AS QPivot");
                $this->db->bind('Hr_Periode', $Hr_Periode);
                $this->db->bind('Hr_LokasiProject_Updt', $Hr_LokasiProject_Updt);

            }

            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $row) {
                $pasing['KODE_TRANSAKSI'] = $row['KODE_TRANSAKSI'];
                $pasing['Nama'] = $row['Nama'];
                $pasing['KODE_LOKASI'] = $row['KODE_LOKASI'];
                $pasing['TUNJANGAN_POKOK'] = $row['TUNJANGAN_POKOK'];
                $pasing['UPAH_POKOK'] = $row['UPAH_POKOK'];
                $pasing['LEMBUR'] = $row['LEMBUR'];
                $pasing['POTONGAN_ABSENSI'] = $row['POTONGAN_ABSENSI'];
                $pasing['PPH21'] = $row['PPH21'];
                $pasing['TL_PSW'] = $row['POTONGAN_TL_PSW'];
                $pasing['KASBON'] = $row['KASBON'];
                $pasing['TotalGaji'] = $row['TotalGaji'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}