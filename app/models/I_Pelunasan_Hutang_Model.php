<?php

class I_Pelunasan_Hutang_Model
{
    private $db;
    use ApiRsyarsi;


    public function __construct()
    {
        $this->db = new Database;
    }

    public function createPelunasanHUtangHeader($data)
    {
        try {
            $this->db->transaksi();
            $TglTransaksi = $data['TglTransaksi'];
            $NoOrder = $data['NoOrder'];
            $RekeningPelunasan = $data['RekeningPelunasan'];
            $TransactionCode = $data['NoPelunasan'];
            $Periode1 = $data['Periode1'];
            $Periode2 = $data['Periode2'];
            $KodeSupplier = $data['KodeSupplier'];
            if ($TglTransaksi == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Tanggal Transaksi Kosong !',
                );
                return $callback;
                exit;
            }
            if ($NoOrder == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. Order Hutang Kosong !',
                );
                return $callback;
                exit;
            }
            if ($RekeningPelunasan == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Rekening Pelunasan Kosong !',
                );
                return $callback;
                exit;
            }
            if ($Periode1 == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Periode Hutang Awal Kosong !',
                );
                return $callback;
                exit;
            }
            if ($Periode2 == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Periode Hutang Akhir Kosong !',
                );
                return $callback;
                exit;
            }
            if ($KodeSupplier == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Supplier Transaksi Kosong !',
                );
                return $callback;
                exit;
            }

            if ($TransactionCode == "") {

                // validasi hutang udh di buat order belum
                $this->db->query("SELECT KD_TRS_ORDER from Keuangan.dbo.ORDER_H_REKANAN   
                                    where KD_TRS_ORDER=:NoOrder and BATAL=:BATAL");
                $this->db->bind('NoOrder', $NoOrder);
                $this->db->bind('BATAL', '0');
                $this->db->execute();
                $data =  $this->db->single();

                $KD_TRS_ORDER = $data['KD_TRS_ORDER'];

                if ($KD_TRS_ORDER == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => "Kode Order Hutang Invalid." . $KD_TRS_ORDER,
                    );
                    return $callback;
                    exit;
                }


                $AWAL = 'OHL';
                $tahun = Utils::datenowcreateYearOnly();
                $bulan = Utils::datenowcreateMonthOnly2();
                $ddatedmy = date("Y-m", strtotime($TglTransaksi));
                $this->db->query("SELECT  TOP 1 KD_TRS_PAY,right(KD_TRS_PAY,3) as urutregx
                FROM Keuangan.dbo.PAY_HUTANG_REKANAN  WHERE  
                SUBSTRING(replace(CONVERT(VARCHAR(11), TGL_PAY, 111), '/','-'),1,7) =:tglperiode  
                ORDER BY ID DESC");
                $this->db->bind('tglperiode', $ddatedmy);
                $data =  $this->db->single();
                $no_pass = $data['urutregx'];
                $id = $no_pass;
                $id++;
                $nourutfixReg = Utils::generateAutoNumberFourDigit($id);
                $nofakturTrs = $AWAL . $bulan . $tahun . '-' . $nourutfixReg;

                $datenowcreate = Utils::seCurrentDateTime();
                $session = SessionManager::getCurrentSession();
                $userid = $session->username;


                $this->db->query("  INSERT INTO Keuangan.DBO.PAY_HUTANG_REKANAN 
                                                (KD_TRS_PAY,KD_TRS_ORDER,TGL_PAY,
                                                PETUGAS,KD_REKANAN,TOTAL,
                                                BATAL,PeriodeHutangAwal,PeriodeHutangAkhir) 
                                                VALUES
                                                (:KD_TRS_PAY,:KD_TRS_ORDER,:TGL_PAY,
                                                :PETUGAS,:REKANAN,:TOTAL,
                                                :BATAL,:PeriodeHutangAwal,:PeriodeHutangAkhir)");
                $this->db->bind('KD_TRS_PAY', $nofakturTrs);
                $this->db->bind('KD_TRS_ORDER', $NoOrder);
                $this->db->bind('TGL_PAY', $TglTransaksi);
                $this->db->bind('PETUGAS', $userid);
                $this->db->bind('REKANAN', $KodeSupplier);
                $this->db->bind('PeriodeHutangAwal', $Periode1);
                $this->db->bind('PeriodeHutangAkhir', $Periode2);
                $this->db->bind('TOTAL', '0');
                $this->db->bind('BATAL', '0');
                $this->db->execute();

                $this->db->query("DELETE FROM  Keuangan.DBO.PAY_HUTANG_REKANAN_2  WHERE KD_TRS_PAY=:KD_TRS_PAY ");
                $this->db->bind('KD_TRS_PAY', $nofakturTrs);
                $this->db->execute();

                $this->db->query("INSERT INTO Keuangan.DBO.PAY_HUTANG_REKANAN_2 
                                                (KD_TRS_PAY,KD_TRS_ORDER,KD_HUTANG,SISA_HUTANG,NILAI_PAY,FB_BATAL,KET,KD_DR)
                                                SELECT '$nofakturTrs' , KD_ORDER,KD_HUTANG,SISA_HUTANG,'0','0' ,KET,KD_DOKTER
                                                FROM Keuangan.DBO.HUTANG_REKANAN WHERE KD_ORDER=:KD_ORDER_TRS AND SISA_HUTANG<>:SISA_HUTANG");
                $this->db->bind('SISA_HUTANG', '0');
                $this->db->bind('KD_ORDER_TRS', $NoOrder);
                $this->db->execute();
            } else {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => "Transaksi Pelunasan Sudah terbentuk. Tidak Bisa buat Pelunasan baru.",
                );
                return $callback;
                exit;
            }

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'notransaksi' => $nofakturTrs,
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e,

            );
            return $callback;
        }
    }
    public function loadDetilPelunasanHutang($data)
    {
        try {

            $this->db->query("SELECT *from Keuangan.dbo.PAY_HUTANG_REKANAN_2 WHERE KD_TRS_PAY=:IdTRS AND FB_BATAL='0' ");
            $this->db->bind('IdTRS', $data['notransaksi']);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $row) {
                $pasing['ID'] = $row['ID'];
                $pasing['KD_TRS_ORDER'] = $row['KD_TRS_ORDER'];
                $pasing['KD_HUTANG'] = $row['KD_HUTANG'];
                $pasing['KET'] = $row['KET'];
                $pasing['SISA_HUTANG'] = $row['SISA_HUTANG'];
                $pasing['NILAI_PAY'] = $row['NILAI_PAY'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getPelunasanHutanfDetailbyID($data)
    {
        try {
            $NoTrs = $data['NoTrs'];
            $this->db->query("SELECT KD_TRS_PAY,KET,SISA_HUTANG,NILAI_PAY from Keuangan.dbo.PAY_HUTANG_REKANAN_2 where id=:TransactionCode");
            $this->db->bind('TransactionCode', $NoTrs);
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success', // Set array status dengan success
                'KD_TRS_PAY' => $data['KD_TRS_PAY'], // Set array status dengan success    
                'KET' => $data['KET'], // Set array status dengan success    
                'SISA_HUTANG' => $data['SISA_HUTANG'], // Set array status dengan success    
                'NILAI_PAY' => $data['NILAI_PAY'], // Set array status dengan success     

            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function goEditHutangDetailPelunasan($data)
    {
        try {
            $this->db->transaksi();
            $JM_ID = $data['JM_ID'];
            $JM_Keterangan = $data['JM_Keterangan'];
            $JM_NIlaiSisa = $data['JM_NIlaiSisa'];
            $JM_NilaiVerif = $data['JM_NilaiVerif'];

            if ($JM_ID == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'ID Transaksi Kosong !',
                );
                return $callback;
                exit;
            }

            if ($JM_NilaiVerif == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Niali Pelunasan Kosong !',
                );
                return $callback;
                exit;
            }
 
            $this->db->query("UPDATE Keuangan.dbo.PAY_HUTANG_REKANAN_2 
                                                SET NILAI_PAY=:JM_NilaiVerif
                                                where id=:JM_ID");
            $this->db->bind('JM_ID', $JM_ID);
            $this->db->bind('JM_NilaiVerif', $JM_NilaiVerif);
            $this->db->execute();

            $this->db->commit();
            $callback = array(
                'status' => 'success',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e,

            );
            return $callback;
        }
    }
    public function goVerifikasiPelunasanHutangFinish($data)
    {
        try {
            $this->db->transaksi();
            $NoTranSaksiPelunasan = $_POST['NoTranSaksiPelunasan'];
            $NoTranSaksiOrder = $_POST['NoTranSaksiOrder'];
            $kdrekanan = $_POST['kdrekanan'];
            $Periode1 = $_POST['Periode1'];
            $Periode2 = $_POST['Periode2'];
            $RkeningKas = $_POST['RkeningKas'];

            if ($NoTranSaksiPelunasan == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. Transaksi Pelunasan Kosong !',
                );
                return $callback;
                exit;
            }

            if ($NoTranSaksiOrder == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. Transaksi Order Pelunasan Kosong !',
                );
                return $callback;
                exit;
            }
            if ($kdrekanan == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode Rekanan Pelunasan Kosong !',
                );
                return $callback;
                exit;
            }
            if ($Periode1 == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Periode Pelunasan Awal Kosong !',
                );
                return $callback;
                exit;
            }
            if ($Periode2 == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Periode Pelunasan Akhir Kosong !',
                );
                return $callback;
                exit;
            }
            if ($RkeningKas == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Rekening Pelunasan Kosong !',
                );
                return $callback;
                exit;
            }
            // verifikasi pelunasan tidak noll
            $this->db->query("SELECT sum(isnull(NILAI_PAY,0)) as NILAI_PAY FROM Keuangan.DBO.PAY_HUTANG_REKANAN_2
            where FB_BATAL=:BATAL and KD_TRS_PAY=:NoTranSaksiPelunasan");
            $this->db->bind('NoTranSaksiPelunasan', $NoTranSaksiPelunasan);
            $this->db->bind('BATAL', '0');
            $this->db->execute();
            $data =  $this->db->single();
            $NILAI_PAY = $data['NILAI_PAY'];
            if ($NILAI_PAY === null || $NILAI_PAY === "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Nilai Pay Kosong !',
                );
                echo json_encode($callback);
                exit;
            } else {
                $NILAI_PAY = $data['NILAI_PAY'];
            }
            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;

            //delete jurnal 
            $this->db->query("DELETE Keuangan.DBO.TA_JURNAL_HDR WHERE FS_KD_JURNAL=:FS_KD_JURNAL");
            $this->db->bind('FS_KD_JURNAL', $NoTranSaksiPelunasan);
            $this->db->execute();

            $this->db->query("DELETE Keuangan.DBO.TA_JURNAL_DTL WHERE FS_KD_JURNAL=:FS_KD_JURNAL");
            $this->db->bind('FS_KD_JURNAL', $NoTranSaksiPelunasan);
            $this->db->execute();

            $this->db->query("INSERT INTO Keuangan.DBO.TA_JURNAL_HDR 
                            (FS_KD_JURNAL,FD_TGL_JURNAL,FN_DEBET,
                            FN_KREDIT,FN_JURNAL,FS_KD_PETUGAS,FB_SELESAI)
                            VALUES
                            (:NoTranSaksiPelunasan,:datenowcreate,:NILAI_PAY,:NILAI_PAYK,
                            :NILAI_PAYj,:userid,:FB_SELESAI)");
            $this->db->bind('NoTranSaksiPelunasan', $NoTranSaksiPelunasan);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('NILAI_PAY', $NILAI_PAY);
            $this->db->bind('NILAI_PAYK', $NILAI_PAY);
            $this->db->bind('NILAI_PAYj', $NILAI_PAY);
            $this->db->bind('userid', $userid);
            $this->db->bind('FB_SELESAI', '1');
            $this->db->execute();

            $this->db->query("INSERT INTO Keuangan.DBO.TA_JURNAL_DTL 
            (FS_KD_JURNAL,FS_KET_REFF,FN_DEBET,FN_KREDIT,FS_REK,FS_KD_REFF,FS_KD_REF_OUT,FS_KD_REG)
            select a.KD_TRS_PAY,'Pelunasan : '+a.KET,a.NILAI_PAY,'0',b.KET3 as FS_REK,a.KD_HUTANG, a.KD_TRS_ORDER,
            isnull(KD_DR,'') as KD_DR
            from Keuangan.dbo.PAY_HUTANG_REKANAN_2 a
            INNER JOIN Keuangan.DBO.HUTANG_REKANAN b on a.KD_HUTANG = b.KD_HUTANG
            WHERE KD_TRS_PAY=:NoTranSaksiPelunasan and NILAI_PAY<>:NILAI_PAY");
            $this->db->bind('NoTranSaksiPelunasan', $NoTranSaksiPelunasan);
            $this->db->bind('NILAI_PAY', '0');
            $this->db->execute();

            $this->db->query("INSERT INTO Keuangan.DBO.TA_JURNAL_DTL (FS_KD_JURNAL,FS_KET_REFF,FN_DEBET,FN_KREDIT,FS_REK,FS_KD_REFF,FS_KD_REF_OUT)
            select KD_TRS_PAY,'Pelunasan : '+KET,'0',NILAI_PAY,$RkeningKas as FS_REK,KD_HUTANG, KD_TRS_ORDER 
            from Keuangan.dbo.PAY_HUTANG_REKANAN_2 
            WHERE KD_TRS_PAY=:NoTranSaksiPelunasan and NILAI_PAY<>:NILAI_PAY");
            $this->db->bind('NoTranSaksiPelunasan', $NoTranSaksiPelunasan);
            $this->db->bind('NILAI_PAY', '0');
            $this->db->execute();

            $this->db->query("SELECT * FROM Keuangan.DBO.PAY_HUTANG_REKANAN_2
            where FB_BATAL='0' and KD_TRS_PAY=:NoTranSaksiPelunasan 
            and NILAI_PAY<>'0'");
            $this->db->bind('NoTranSaksiPelunasan', $NoTranSaksiPelunasan);
            $this->db->execute();
            $data =  $this->db->resultSet();
            foreach ($data as $key) { 

                $this->db->query("SELECT  isnull(sum(nilai_pay),0) as totalbayar 
                            FROM Keuangan.DBO.PAY_HUTANG_REKANAN_2 
                            where KD_HUTANG=:xKD_HUTANG
                            and FB_BATAL='0'");
                $this->db->bind('xKD_HUTANG', $key['KD_HUTANG']);
                $this->db->execute();
                $datax =  $this->db->single(); 
                $totalbayar = $datax['totalbayar']; 

                $this->db->query("UPDATE Keuangan.dbo.HUTANG_REKANAN 
                set SISA_HUTANG=NILAI_HUTANG-$totalbayar
                where KD_HUTANG='$key[KD_HUTANG]'");
                $this->db->execute();
            }

            $this->db->query("UPDATE Keuangan.dbo.PAY_HUTANG_REKANAN
            SET KD_TRS_ORDER=:NoTranSaksiOrder, KD_REKANAN=:kdrekanan,
            PeriodeHutangAwal=:Periode1,TOTAL=:NILAI_PAY,PeriodeHutangAkhir=:Periode2,REK_PELUNASAN=:REK_PELUNASAN
            WHERE KD_TRS_PAY=:NoTranSaksiPelunasan");
            $this->db->bind('NoTranSaksiPelunasan', $NoTranSaksiPelunasan);
            $this->db->bind('REK_PELUNASAN', $RkeningKas);
            $this->db->bind('NoTranSaksiOrder', $NoTranSaksiOrder);
            $this->db->bind('kdrekanan', $kdrekanan);
            $this->db->bind('Periode1', $Periode1);
            $this->db->bind('Periode2', $Periode2);
            $this->db->bind('NILAI_PAY', $NILAI_PAY);
            $this->db->execute();


            $this->db->commit();
            $callback = array(
                'status' => 'success',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e,

            );
            return $callback;
        }
    }
    public function informasiHutangDetail($data)
    {
        try {
            $JenisInfo = $_POST['JenisInfo'];
            $PeriodeAwal = $_POST['PeriodeAwal'];
            $PeriodeAkhir = $_POST['PeriodeAkhir'];
            if ($JenisInfo == "1") {
                $this->db->query("SELECT A.KD_HUTANG,b.Company,
                a.KET,a.NO_FAKTUR,replace(CONVERT(VARCHAR(11), TGL_HUTANG, 111), '/','-') AS TGL_HUTANG,
                replace(CONVERT(VARCHAR(11), a.TGL_TEMPO, 111), '/','-') AS TGL_TEMPO,
                a.NILAI_HUTANG,a.SISA_HUTANG,a.KET3
                FROM Keuangan.dbo.HUTANG_REKANAN A
                INNER JOIN [Apotik_V1.1SQL].DBO.Suppliers B
                ON A.KD_REKANAN = B.ID
                where FS_TGL_VOID='1900-01-01 00:00:00.000' AND 
                replace(CONVERT(VARCHAR(11), a.TGL_TEMPO, 111), '/','-') BETWEEN :tglawal AND :tglakhir");
                $this->db->bind('tglawal', $data['PeriodeAwal']);
                $this->db->bind('tglakhir', $data['PeriodeAkhir']);
                $data =  $this->db->resultSet();
                $rows = array();
            } else {
                $this->db->query("SELECT A.KD_HUTANG,b.Company,
                a.KET,a.NO_FAKTUR,replace(CONVERT(VARCHAR(11), TGL_HUTANG, 111), '/','-') AS TGL_HUTANG,
                replace(CONVERT(VARCHAR(11), a.TGL_TEMPO, 111), '/','-') AS TGL_TEMPO,
                a.NILAI_HUTANG,a.SISA_HUTANG,a.KET3
                FROM Keuangan.dbo.HUTANG_REKANAN A
                INNER JOIN [Apotik_V1.1SQL].DBO.Suppliers B
                ON A.KD_REKANAN = B.ID
                where FS_TGL_VOID='1900-01-01 00:00:00.000' AND 
                replace(CONVERT(VARCHAR(11), TGL_HUTANG, 111), '/','-') BETWEEN :tglawal AND :tglakhir");
                $this->db->bind('tglawal', $data['PeriodeAwal']);
                $this->db->bind('tglakhir', $data['PeriodeAkhir']);
                $data =  $this->db->resultSet();
                $rows = array();
            }


            foreach ($data as $row) {
                $pasing['KD_HUTANG'] = $row['KD_HUTANG'];
                $pasing['Company'] = $row['Company'];
                $pasing['TGL_HUTANG'] = date('d/m/Y', strtotime($row['TGL_HUTANG']));
                $pasing['TGL_TEMPO'] = date('d/m/Y', strtotime($row['TGL_TEMPO']));
                $pasing['KET'] = $row['KET'];
                $pasing['NO_FAKTUR'] = $row['NO_FAKTUR'];
                $pasing['NILAI_HUTANG'] = $row['NILAI_HUTANG'];
                $pasing['SISA_HUTANG'] = $row['SISA_HUTANG'];
                $pasing['KET3'] = $row['KET3'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function informasiHutangRekapSisa($data)
    {
        try {
            $PeriodeAwal = $_POST['PeriodeAwal'];
            $PeriodeAkhir = $_POST['PeriodeAkhir'];

            $this->db->query(" SELECT a.KD_REKANAN,d.Company,sum(a.NILAI_HUTANG) fn_piutang,
                sum(isnull(b.NILAI_PAY,0)) nilai_pay,sum(isnull(a.NILAI_HUTANG,0))- sum(isnull(b.NILAI_PAY,0)) SISA_SEKARANG
                FROM Keuangan.DBO.HUTANG_REKANAN A
                LEFT JOIN Keuangan.DBO.PAY_HUTANG_REKANAN_2 B
                ON A.KD_HUTANG = B.KD_HUTANG
                left JOIN Keuangan.DBO.PAY_HUTANG_REKANAN C
                ON C.KD_TRS_ORDER = B.KD_TRS_ORDER
                left join [Apotik_V1.1SQL].dbo.Suppliers d
                on d.ID = a.KD_REKANAN 
                where a.FS_KD_PETUGAS_VOID='' 
                and replace(CONVERT(VARCHAR(11),a.TGL_HUTANG, 111), '/','-')  between :tglawal and :tglakhir
                group by a.KD_REKANAN,d.Company");
            $this->db->bind('tglawal', $data['PeriodeAwal']);
            $this->db->bind('tglakhir', $data['PeriodeAkhir']);
            $data =  $this->db->resultSet();
            $rows = array();

            foreach ($data as $row) {
                $pasing['KD_REKANAN'] = $row['KD_REKANAN'];
                $pasing['Company'] = $row['Company'];
                $pasing['fn_piutang'] = $row['fn_piutang'];
                $pasing['nilai_pay'] = $row['nilai_pay'];
                $pasing['SISA_SEKARANG'] = $row['SISA_SEKARANG'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function goEditHutangDetailPelunasanChecklist($data)
    {
        try {
            $this->db->transaksi();

            $tod = json_decode(json_encode((object) $data['iddetail']), FALSE);
            foreach ($tod as $data) {
                $this->db->query("UPDATE Keuangan.dbo.PAY_HUTANG_REKANAN_2 
                                                SET NILAI_PAY=SISA_HUTANG
                                                where id=:JM_ID");
                $this->db->bind('JM_ID', $data);
                $this->db->execute();
            }

            $this->db->commit();
            $callback = array(
                'status' => 'success',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e,

            );
            return $callback;
        }
    }

    public function getListPelunasanHutang($data)
    {
        try {

            $this->db->query("SELECT *from Keuangan.dbo.PAY_HUTANG_REKANAN Where BATAL='0' order by ID DESC");
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $row) {
                $pasing['ID'] = $row['ID'];
                $pasing['KD_TRS_PAY'] = $row['KD_TRS_PAY'];
                $pasing['KD_TRS_ORDER'] = $row['KD_TRS_ORDER'];
                $pasing['TGL_PAY'] = $row['TGL_PAY'];
                $pasing['PETUGAS'] = $row['PETUGAS'];
                $pasing['KD_REKANAN'] = $row['KD_REKANAN'];
                $pasing['PERIODE'] = $row['PERIODE'];
                $pasing['TOTAL'] = $row['TOTAL'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getTukarFakturHeader($data)
    {
        try {
            $NoPelunasan = $data['NoPelunasan'];
            $this->db->query("SELECT a.*,b.FS_REK,
                            replace(CONVERT(VARCHAR(11), a.PeriodeHutangAwal, 111), '/','-') as PeriodeHutangAwalx, 
                            replace(CONVERT(VARCHAR(11), a.PeriodeHutangAkhir, 111), '/','-') as PeriodeHutangAkhirx 
                            from Keuangan.dbo.PAY_HUTANG_REKANAN a
            left join Keuangan.dbo.TA_JURNAL_DTL b on a.KD_TRS_PAY=b.FS_KD_REFF
             where KD_TRS_PAY=:NoPelunasan");
            $this->db->bind('NoPelunasan', $NoPelunasan);
            $data =  $this->db->single();
            $callback = [
                'status' => 'success',
                'data' => $data,
            ];
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getInfoOrderPelunasanHutang($data)
    {
        try {

            $TglAwal = $data['TglAwal'];
            $TglAkhir = $data['TglAkhir'];
            // var_dump($TglAwal, $TglAkhir, $optJenisInfo);
            // exit;
            $this->db->query("SELECT KD_TRS_ORDER,TGL_ORDER,PETUGAS,[First Name] as First_Name,KD_REKANAN,Company,PeriodeHutangAwal,PeriodeHutangAkhir,KET,NILAI_HUTANG FROM Keuangan.DBO.v_order_pelunasan_Hutang
            WHERE replace(CONVERT(VARCHAR(11), TGL_ORDER, 111), '/','-') BETWEEN :TglAwal AND :TglAkhir ");
            $this->db->bind('TglAwal', $TglAwal);
            $this->db->bind('TglAkhir', $TglAkhir);

            $data =  $this->db->resultSet();

            $rows = array();
            $no = 1;

            foreach ($data as $row) {
                $pasing['no'] = $no++;
                $pasing['KD_TRS_ORDER'] = $row['KD_TRS_ORDER'];
                $pasing['TGL_ORDER'] = $row['TGL_ORDER'];
                $pasing['PETUGAS'] = $row['PETUGAS'];
                $pasing['First_Name'] = $row['First_Name'];
                $pasing['KD_REKANAN'] = $row['KD_REKANAN'];
                $pasing['Company'] = $row['Company'];
                $pasing['PeriodeHutangAwal'] = $row['PeriodeHutangAwal'];
                $pasing['PeriodeHutangAkhir'] = $row['PeriodeHutangAkhir'];
                $pasing['KET'] = $row['KET'];
                $pasing['NILAI_HUTANG'] = $row['NILAI_HUTANG'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getInfoOrderPelunasanHutang1($data)
    {
        try {

            $TglAwal = $data['TglAwal'];
            $TglAkhir = $data['TglAkhir'];
            // var_dump($TglAwal, $TglAkhir, $optJenisInfo);
            // exit;
            $this->db->query("SELECT KD_TRS_ORDER,TGL_ORDER,PETUGAS,[First Name] as First_Name,KD_REKANAN,Company,PeriodeHutangAwal,PeriodeHutangAkhir,KET,NILAI_HUTANG FROM Keuangan.DBO.v_order_pelunasan_Hutang
            WHERE replace(CONVERT(VARCHAR(11), TGL_ORDER, 111), '/','-') BETWEEN :TglAwal AND :TglAkhir ");
            $this->db->bind('TglAwal', $TglAwal);
            $this->db->bind('TglAkhir', $TglAkhir);

            $data =  $this->db->resultSet();

            $rows = array();
            $no = 1;

            foreach ($data as $row) {
                $pasing['no'] = $no++;
                $pasing['KD_TRS_ORDER'] = $row['KD_TRS_ORDER'];
                $pasing['TGL_ORDER'] = $row['TGL_ORDER'];
                $pasing['PETUGAS'] = $row['PETUGAS'];
                $pasing['First_Name'] = $row['First_Name'];
                $pasing['KD_REKANAN'] = $row['KD_REKANAN'];
                $pasing['Company'] = $row['Company'];
                $pasing['PeriodeHutangAwal'] = $row['PeriodeHutangAwal'];
                $pasing['PeriodeHutangAkhir'] = $row['PeriodeHutangAkhir'];
                $pasing['KET'] = $row['KET'];
                $pasing['NILAI_HUTANG'] = $row['NILAI_HUTANG'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getInfoPelunasanHutangRekap($data)
    {
        try {

            $TglAwal = $data['TglAwal'];
            $TglAkhir = $data['TglAkhir'];
            // var_dump($TglAwal, $TglAkhir, $optJenisInfo);
            // exit;
            $this->db->query("SELECT A.KD_TRS_PAY,A.KD_TRS_ORDER,A.TGL_PAY,d.[First Name] as First_Name,A.TOTAL, replace(CONVERT(VARCHAR(11), a.PeriodeHutangAwal, 111), '/','-') as PeriodeHutangAwal,
            replace(CONVERT(VARCHAR(11), a.PeriodeHutangAkhir, 111), '/','-') as PeriodeHutangAkhir,a.REK_PELUNASAN,C.FS_NM_REKENING
            FROM Keuangan.dbo.PAY_HUTANG_REKANAN A
            INNER JOIN [Apotik_V1.1SQL].DBO.Suppliers B ON A.KD_REKANAN = B.ID
            INNER JOIN Keuangan.DBO.TM_REKENING C ON C.FS_KD_REKENING = A.REK_PELUNASAN
            inner join MasterdataSQL.dbo.Employees d on a.PETUGAS collate Latin1_General_CI_AS= d.NoPIN
            where a.BATAL='0' and replace(CONVERT(VARCHAR(11), TGL_PAY, 111), '/','-') BETWEEN :TglAwal AND :TglAkhir ");
            $this->db->bind('TglAwal', $TglAwal);
            $this->db->bind('TglAkhir', $TglAkhir);

            $data =  $this->db->resultSet();

            $rows = array();
            $no = 1;

            foreach ($data as $row) {
                $pasing['no'] = $no++;
                $pasing['KD_TRS_PAY'] = $row['KD_TRS_PAY'];
                $pasing['KD_TRS_ORDER'] = $row['KD_TRS_ORDER'];
                $pasing['TGL_PAY'] = $row['TGL_PAY'];
                $pasing['First_Name'] = $row['First_Name'];
                $pasing['TOTAL'] = $row['TOTAL'];
                $pasing['PeriodeHutangAwal'] = $row['PeriodeHutangAwal'];
                $pasing['PeriodeHutangAkhir'] = $row['PeriodeHutangAkhir'];
                $pasing['REK_PELUNASAN'] = $row['REK_PELUNASAN'];
                $pasing['FS_NM_REKENING'] = $row['FS_NM_REKENING'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getInfoPelunasanHutangRekap1($data)
    {
        try {

            $TglAwal = $data['TglAwal'];
            $TglAkhir = $data['TglAkhir'];
            // var_dump($TglAwal, $TglAkhir, $optJenisInfo);
            // exit;
            $this->db->query("SELECT A.KD_TRS_PAY,A.KD_TRS_ORDER,A.TGL_PAY,d.[First Name] as First_Name,A.TOTAL, replace(CONVERT(VARCHAR(11), a.PeriodeHutangAwal, 111), '/','-') as PeriodeHutangAwal,
            replace(CONVERT(VARCHAR(11), a.PeriodeHutangAkhir, 111), '/','-') as PeriodeHutangAkhir,a.REK_PELUNASAN,C.FS_NM_REKENING
            FROM Keuangan.dbo.PAY_HUTANG_REKANAN A
            INNER JOIN [Apotik_V1.1SQL].DBO.Suppliers B ON A.KD_REKANAN = B.ID
            INNER JOIN Keuangan.DBO.TM_REKENING C ON C.FS_KD_REKENING = A.REK_PELUNASAN
            inner join MasterdataSQL.dbo.Employees d on a.PETUGAS collate Latin1_General_CI_AS= d.NoPIN
            where a.BATAL='0' and replace(CONVERT(VARCHAR(11), TGL_PAY, 111), '/','-') BETWEEN :TglAwal AND :TglAkhir ");
            $this->db->bind('TglAwal', $TglAwal);
            $this->db->bind('TglAkhir', $TglAkhir);

            $data =  $this->db->resultSet();

            $rows = array();
            $no = 1;

            foreach ($data as $row) {
                $pasing['no'] = $no++;
                $pasing['KD_TRS_PAY'] = $row['KD_TRS_PAY'];
                $pasing['KD_TRS_ORDER'] = $row['KD_TRS_ORDER'];
                $pasing['TGL_PAY'] = $row['TGL_PAY'];
                $pasing['First_Name'] = $row['First_Name'];
                $pasing['TOTAL'] = $row['TOTAL'];
                $pasing['PeriodeHutangAwal'] = $row['PeriodeHutangAwal'];
                $pasing['PeriodeHutangAkhir'] = $row['PeriodeHutangAkhir'];
                $pasing['REK_PELUNASAN'] = $row['REK_PELUNASAN'];
                $pasing['FS_NM_REKENING'] = $row['FS_NM_REKENING'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getInfoPelunasanHutangDetail($data)
    {
        try {

            $TglAwal = $data['TglAwal'];
            $TglAkhir = $data['TglAkhir'];
            // var_dump($TglAwal, $TglAkhir, $optJenisInfo);
            // exit;
            $this->db->query("SELECT A.KD_TRS_PAY,A.KD_TRS_ORDER,A.TGL_PAY,e.[First Name] as First_Name,b.Company,d.NILAI_PAY,
            d.SISA_HUTANG, replace(CONVERT(VARCHAR(11), a.PeriodeHutangAwal, 111), '/','-') as PeriodeHutangAwal,
            replace(CONVERT(VARCHAR(11), a.PeriodeHutangAkhir, 111), '/','-') as PeriodeHutangAkhir,a.REK_PELUNASAN,C.FS_NM_REKENING
            FROM Keuangan.dbo.PAY_HUTANG_REKANAN A
            INNER JOIN [Apotik_V1.1SQL].DBO.Suppliers B ON A.KD_REKANAN = B.ID
            INNER JOIN Keuangan.DBO.TM_REKENING C ON C.FS_KD_REKENING = A.REK_PELUNASAN
            inner join Keuangan.dbo.PAY_HUTANG_REKANAN_2 d on d.KD_TRS_PAY = a.KD_TRS_PAY
            inner join MasterdataSQL.dbo.Employees e on a.PETUGAS collate Latin1_General_CI_AS= e.NoPIN
            where a.BATAL='0' and replace(CONVERT(VARCHAR(11), TGL_PAY, 111), '/','-') BETWEEN :TglAwal AND :TglAkhir ");
            $this->db->bind('TglAwal', $TglAwal);
            $this->db->bind('TglAkhir', $TglAkhir);

            $data =  $this->db->resultSet();

            $rows = array();
            $no = 1;

            foreach ($data as $row) {
                $pasing['no'] = $no++;
                $pasing['KD_TRS_PAY'] = $row['KD_TRS_PAY'];
                $pasing['KD_TRS_ORDER'] = $row['KD_TRS_ORDER'];
                $pasing['TGL_PAY'] = $row['TGL_PAY'];
                $pasing['First_Name'] = $row['First_Name'];
                $pasing['Company'] = $row['Company'];
                $pasing['NILAI_PAY'] = $row['NILAI_PAY'];
                $pasing['SISA_HUTANG'] = $row['SISA_HUTANG'];
                $pasing['PeriodeHutangAwal'] = $row['PeriodeHutangAwal'];
                $pasing['PeriodeHutangAkhir'] = $row['PeriodeHutangAkhir'];
                $pasing['REK_PELUNASAN'] = $row['REK_PELUNASAN'];
                $pasing['FS_NM_REKENING'] = $row['FS_NM_REKENING'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getInfoPelunasanHutangDetail1($data)
    {
        try {

            $TglAwal = $data['TglAwal'];
            $TglAkhir = $data['TglAkhir'];
            // var_dump($TglAwal, $TglAkhir, $optJenisInfo);
            // exit;
            $this->db->query("SELECT A.KD_TRS_PAY,A.KD_TRS_ORDER,A.TGL_PAY,e.[First Name] as First_Name,b.Company,d.NILAI_PAY,
            d.SISA_HUTANG, replace(CONVERT(VARCHAR(11), a.PeriodeHutangAwal, 111), '/','-') as PeriodeHutangAwal,
            replace(CONVERT(VARCHAR(11), a.PeriodeHutangAkhir, 111), '/','-') as PeriodeHutangAkhir,a.REK_PELUNASAN,C.FS_NM_REKENING
            FROM Keuangan.dbo.PAY_HUTANG_REKANAN A
            INNER JOIN [Apotik_V1.1SQL].DBO.Suppliers B ON A.KD_REKANAN = B.ID
            INNER JOIN Keuangan.DBO.TM_REKENING C ON C.FS_KD_REKENING = A.REK_PELUNASAN
            inner join Keuangan.dbo.PAY_HUTANG_REKANAN_2 d on d.KD_TRS_PAY = a.KD_TRS_PAY
            inner join MasterdataSQL.dbo.Employees e on a.PETUGAS collate Latin1_General_CI_AS= e.NoPIN
            where a.BATAL='0' and replace(CONVERT(VARCHAR(11), TGL_PAY, 111), '/','-') BETWEEN :TglAwal AND :TglAkhir ");
            $this->db->bind('TglAwal', $TglAwal);
            $this->db->bind('TglAkhir', $TglAkhir);

            $data =  $this->db->resultSet();

            $rows = array();
            $no = 1;

            foreach ($data as $row) {
                $pasing['no'] = $no++;
                $pasing['KD_TRS_PAY'] = $row['KD_TRS_PAY'];
                $pasing['KD_TRS_ORDER'] = $row['KD_TRS_ORDER'];
                $pasing['TGL_PAY'] = $row['TGL_PAY'];
                $pasing['First_Name'] = $row['First_Name'];
                $pasing['Company'] = $row['Company'];
                $pasing['NILAI_PAY'] = $row['NILAI_PAY'];
                $pasing['SISA_HUTANG'] = $row['SISA_HUTANG'];
                $pasing['PeriodeHutangAwal'] = $row['PeriodeHutangAwal'];
                $pasing['PeriodeHutangAkhir'] = $row['PeriodeHutangAkhir'];
                $pasing['REK_PELUNASAN'] = $row['REK_PELUNASAN'];
                $pasing['FS_NM_REKENING'] = $row['FS_NM_REKENING'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function goVoidPelunasanHutang($data)
    {
        try {
            $this->db->transaksi();
            $datenowcreate = Utils::seCurrentDateTime();
            $datenowx = Utils::datenowcreateNotFull();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $namauser = $session->name;

            $NoPelunasan = $data['NoPelunasan']; 
            $AlasanBatal = $data['AlasanBatal'];

            // var_dump($datenowcreate,$userid,$NoPelunasan,$AlasanBatal,$namauser);exit;

           

            $this->db->query("SELECT * FROM Keuangan.DBO.PAY_HUTANG_REKANAN_2
            where FB_BATAL='0' and KD_TRS_PAY=:NoTranSaksiPelunasan 
            and NILAI_PAY<>'0'");
            $this->db->bind('NoTranSaksiPelunasan', $NoPelunasan);
            $this->db->execute();
            $data =  $this->db->resultSet();
            foreach ($data as $key) { 
                $this->db->query("UPDATE Keuangan.dbo.HUTANG_REKANAN 
                set SISA_HUTANG=SISA_HUTANG+$key[NILAI_PAY] 
                where KD_HUTANG='$key[KD_HUTANG]'");
                $this->db->execute();
            }

            $this->db->query("UPDATE Keuangan.dbo.PAY_HUTANG_REKANAN
            SET  BATAL=:Void,PETUGAS_BATAL=:PETUGAS_BATAL, TGL_BATAL=:TGL_BATAL
            where KD_TRS_PAY=:NoPelunasan");
$this->db->bind('NoPelunasan', $NoPelunasan);
// $this->db->bind('ALASAN_BATAL', $AlasanBatal);  
$this->db->bind('PETUGAS_BATAL', $namauser);
$this->db->bind('TGL_BATAL', $datenowcreate);
$this->db->bind('Void', '1');
$this->db->execute();


$this->db->query("UPDATE Keuangan.dbo.PAY_HUTANG_REKANAN_2 
SET  FB_BATAL='1',KET=:AlasanBatal 
where KD_TRS_PAY=:NoPelunasan");
$this->db->bind('NoPelunasan', $NoPelunasan);
$this->db->bind('AlasanBatal', $AlasanBatal);
$this->db->execute();

            $this->db->commit();
            $callback = array(
                'status' => 'success',
            );

            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error",
                'message' => $e,

            );
            return $callback;
        }
    }
}
