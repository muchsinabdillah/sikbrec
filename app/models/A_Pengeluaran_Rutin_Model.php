<?php
class A_Pengeluaran_Rutin_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function CreateRealisasi($data){
            try {
                $this->db->transaksi();  
                if ($data['TglPenyelesaian'] == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Silahkan Masukan Tanggal Pengeluaran Rutin Anda !',
                    );
                    return $callback;
                    exit;
                }
               
                if ($data['Keterangan'] == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Silahkan Masukan Keterangan Pengeluaran Rutin Anda !',
                    );
                    return $callback;
                    exit;
                }
                $NoTrsPencairan = $data['IDNoTrs']; 
                $Keterangan = $data['Keterangan'];
                $TglPenyelesaian = $data['TglPenyelesaian'];  

                $session = SessionManager::getCurrentSession();
                $userid = $session->username;
                $token = $session->token;
                $namauserx = $session->name;
                $TGLENTRI = Utils::seCurrentDateTime();  

               
                date_default_timezone_set('Asia/Jakarta');
                $tahun = Utils::datenowcreateYearOnly();
                $bulan = Utils::datenowcreateMonthOnly(); 
                $notrs = Utils::idtrsByDateOnly();

                //cek rekening kas Pengeluaran
                $idRekPengeluaran = "rek_kas_pengeluaran";
                $this->db->query('SELECT rekening FROM Keuangan.DBO.TZ_Parameter_Keu WHERE parameter=:rek_kas_pengeluaran');
                $this->db->bind('rek_kas_pengeluaran', $idRekPengeluaran);
                $this->db->execute();
                $data =  $this->db->single();
                $val_rekening = $data['rekening'];
                if ($val_rekening === null || $val_rekening === "") { 
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Rekening Kas Pengeluaran Kosong, Cek Parameter Sistem !',
                    );
                    return $callback;
                    exit;
                } else {
                    $val_rekening = $data['rekening'];
                }
                
                    // auto number
                    $this->db->query("SELECT  TOP 1 No_Transaksi,right(No_Transaksi,4) as nourut
                                    FROM Keuangan.dbo.T_Kas_Keluar  WHERE  
                                substring(No_Transaksi,3,6)=:No_Transaksi ORDER BY id DESC");
                    $this->db->bind('No_Transaksi', $notrs); 
                    $this->db->execute();
                    $data =  $this->db->single();
                    $nourut = $data['nourut'];
    
                    if (empty($nourut)) {
                        //jika gk ada record
                        $nourut = "0001";
                    } else {
                        //jika ada record
                        $nourut++;
                    } 
                    $nourutfix = Utils::generateAutoNumberFourDigit($nourut);
                    $romawi = Utils::createMonthRomawi($bulan);
                    $idxt = Utils::idtrsByDateOnly();
                    $nokasbonAuto = $idxt;
                    $notransaksi = 'KB' . $nokasbonAuto . '-' . $nourutfix;
                    $tgl_trs = $TglPenyelesaian;
                    $this->db->query("INSERT INTO Keuangan.dbo.T_Kas_Keluar 
                                    (No_Transaksi,Tgl_Transaksi,
                                    Keterangan,Tgl_Input_First,Petugas_Input_First,Rekening_Kas_Pengeluaran) VALUES
                                    (:notransaksi,:tgl_trs,
                                    :keterangan,:tgl_trss,:operator,:val_rekening)");
                    $this->db->bind('notransaksi', $notransaksi);
                    $this->db->bind('tgl_trs', $tgl_trs);
                    $this->db->bind('keterangan', $Keterangan);
                    $this->db->bind('tgl_trss', $TGLENTRI);
                    $this->db->bind('operator', $userid);
                    $this->db->bind('val_rekening', $val_rekening);
                    $this->db->execute();
                    $last = $this->db->GetLastID();
               

                // //jurnal
                // $this->db->query("INSERT INTO Keuangan.dbo.TA_JURNAL_HDR
                //                 (FS_KD_JURNAL,FD_TGL_JURNAL,FS_KD_PETUGAS,
                //                 FN_DEBET,FN_KREDIT,fn_jurnal,FB_SELESAI, FS_KET) values
                //                 (:notransaksi,:tgl_trs,:operator,
                //                 :nominal,:nominal2,:nominal3,:sts,:keterangan)");
                // $this->db->bind('notransaksi', $notransaksi);
                // $this->db->bind('tgl_trs', $tgl_trs);
                // $this->db->bind('nominal', $NilaiPencairan);
                // $this->db->bind('nominal2', $NilaiPencairan);
                // $this->db->bind('nominal3', $NilaiPencairan);
                // $this->db->bind('keterangan', $KeteranganPencairan);
                // $this->db->bind('sts', '1');
                // $this->db->bind('operator', $userid);
                // $this->db->execute();

                // $this->db->query("INSERT INTO Keuangan.dbo.TA_JURNAL_DTL
                //                 ( FS_KD_JURNAL,FS_KET_REFF,FN_DEBET,
                //                     FN_KREDIT,FB_VOID,FS_REK,FS_KD_UNIT,FB_LEDGER,FS_KD_REFF) values
                //                 (:notransaksi,:KeteranganJurnal,:nominal,
                //                     :nominal2,:nominal3,:val_rekening,:FS_KD_UNIT,:FB_LEDGER,:notransaksi2)");
                // $this->db->bind('notransaksi', $notransaksi);
                // $this->db->bind('notransaksi2', $notransaksi);
                // $this->db->bind('val_rekening', $val_rekening);
                // $this->db->bind('nominal', $NilaiPencairan);
                // $this->db->bind('nominal2', '0');
                // $this->db->bind('nominal3', '0');
                // $this->db->bind('KeteranganJurnal', $KeteranganPencairan);
                // $this->db->bind('FB_LEDGER', '0');
                // $this->db->bind('FS_KD_UNIT', ''); 
                // $this->db->execute();
                // //KREDIT
                // $this->db->query("INSERT INTO Keuangan.dbo.TA_JURNAL_DTL
                //                 ( FS_KD_JURNAL,FS_KET_REFF,FN_DEBET,
                //                     FN_KREDIT,FB_VOID,FS_REK,FS_KD_UNIT,FB_LEDGER,FS_KD_REFF) values
                //                 (:notransaksi,:KeteranganJurnal,:nominal2,
                //                     :nominal,:nominal3,:val_rekening_Kas,:FS_KD_UNIT,:FB_LEDGER,:notransaksi2)");
                // $this->db->bind('notransaksi', $notransaksi);
                // $this->db->bind('KeteranganJurnal', $KeteranganPencairan);
                // $this->db->bind('nominal2', '0');
                // $this->db->bind('notransaksi2', $notransaksi);
                // $this->db->bind('val_rekening_Kas', $val_rekening_Kas);
                // $this->db->bind('nominal', $NilaiPencairan);
                // $this->db->bind('nominal3', '0');
                // $this->db->bind('FB_LEDGER', '0');
                // $this->db->bind('FS_KD_UNIT', '');
                // $this->db->execute();

                // if($NoTrsOrder <> ""){
                //     $this->db->query(" UPDATE Keuangan.DBO.T_Order_Kasbon 
                //                 SET No_Transaksi_Kasbon=:notransaksi,
                //                 STATUS=:Realisasi
                //                 WHERE No_Transaksi=:NoTranSaksiOrderAuto");
                //     $this->db->bind('notransaksi', $notransaksi);
                //     $this->db->bind('Realisasi', 'Realisasi');
                //     $this->db->bind('NoTranSaksiOrderAuto', $NoTrsOrder);
                //     $this->db->execute();
                // }

                $this->db->commit();
            
                $this->db->closeCon();
                $callback = array(
                    'status' => 'success', // Set array status dengan success   
                    'message' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success 
                    'id' => $last,
                    'notransaksi' => $notransaksi,  
                );
                return $callback;
            } catch (PDOException $e) {
                $this->db->rollback();
                $this->db->closeCon();
                $callback = array(
                    'status' => "error", // Set array nama  
                    'message' => $e
                );
                return $callback;
            }
        }

    public function CreateDetil($data)
    {
        try {
            $this->db->transaksi();

            if ($data['IDNoTrsPencairan'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input No. Pencairan !',
                );
                return $callback;
                exit;
            } 
            if ($data['TglPenyelesaian'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Tgl Penyesuaian !',
                );
                return $callback;
                exit;
            }
            if ($data['NilaiBiaya'] == "" || $data['NilaiBiaya'] == "0") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Nilai Biaya !',
                );
                return $callback;
                exit;
            }
              
            if ($data['GroupBebanBiaya'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Group Beban !',
                );
                return $callback;
                exit;
            }
            if ($data['Unit'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Unit Beban !',
                );
                return $callback;
                exit;
            }
            if ($data['KeteranganBiaya'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Keterangan Biaya !',
                );
                return $callback;
                exit;
            }
            $IDNoTrsPencairan = $data['IDNoTrsPencairan']; 
            $TglPenyelesaian = $data['TglPenyelesaian']; 
            $GroupBebanBiaya = $data['GroupBebanBiaya']; 
            $NilaiBiaya = $data['NilaiBiaya'];  
            $KeteranganBiaya = $data['KeteranganBiaya'];  
            $kodeunit = $data['Unit'];
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $TGLENTRI = Utils::seCurrentDateTime();  
            //cek rekening
            $IDrek_kasbon = "rek_kasbon";
            $this->db->query('SELECT KODE_COA FROM Keuangan.DBO.BO_M_BEBAN_HARIAN WHERE ID=:ID');
            $this->db->bind('ID', $GroupBebanBiaya);
            $this->db->execute();
            $data =  $this->db->single();
            $KODE_COAX = $data['KODE_COA'];
            if ($KODE_COAX === null || $KODE_COAX === "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Rekening Kasbon Kosong, Cek Parameter Sistem !',
                );
                return $callback;
                exit;
            } else {
                $KODE_COAXX = $data['KODE_COA'];
            }

            //cek unit 
            // cek jika total detil yang ada melebihi total nilai penyelesaian
            $this->db->query("SELECT isnull(SUM(b.Nilai),0) as nilai
                    FROM Keuangan.DBO.T_Kas_Keluar A INNER JOIN Keuangan.DBO.T_Kas_Keluar_2 B
                    ON A.id = B.ID_Transaksi where a.id=:IDNoTrsPencairan and b.Batal='0'");
            $this->db->bind('IDNoTrsPencairan', $IDNoTrsPencairan);
            $this->db->execute();
            $dttotal =  $this->db->single();
            $totalx = $dttotal['nilai']; 
            $ttlbeban = $totalx+ $NilaiBiaya;
            
            //detail
            $this->db->query("INSERT INTO Keuangan.dbo.T_Kas_Keluar_2
                            (ID_Transaksi,Nilai,ID_Unit,RekeningBiaya,Batal,ID_Group_Beban,
                            Tgl_Entri,Petugas_Entri,KeteranganBiaya) values
                            (:IDNoTrsPencairan,:NilaiBiaya,:kodeUnit,:KODE_COAXX,:batal,:ID_Group_Beban,
                            :Tgl_Entri,:Petugas_Entri,:KeteranganBiaya)");
            $this->db->bind('IDNoTrsPencairan', $IDNoTrsPencairan);
            $this->db->bind('NilaiBiaya', $NilaiBiaya);
            $this->db->bind('KODE_COAXX', $KODE_COAXX);
            $this->db->bind('kodeUnit', $kodeunit);
            $this->db->bind('ID_Group_Beban', $GroupBebanBiaya); 
            $this->db->bind('Tgl_Entri', $TGLENTRI); 
            $this->db->bind('Petugas_Entri', $namauserx); 
            $this->db->bind('KeteranganBiaya', $KeteranganBiaya); 
            
            $this->db->bind('batal', '0'); 
            $this->db->execute();
 
            $this->db->commit(); 
            $this->db->closeCon();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success  
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function ShowDetail($data)
    {
        try {
            $iddata = $data['IDNoTrsPencairan'];
            $this->db->query("SELECT a.*,b.NamaUnit,c.FS_NM_REKENING , d.NAMA_GROUP_BEBAN
                                FROM Keuangan.dbo.T_Kas_Keluar_2 a
                                inner join MasterDataSQL.dbo.MstrUnitPerwatan b on a.ID_Unit=b.ID
                                INNER JOIN Keuangan.dbo.TM_REKENING c ON A.RekeningBiaya = c.FS_KD_REKENING
                                inner join Keuangan.dbo.BO_M_BEBAN_HARIAN d on d.ID = a.ID_Group_Beban
                                WHERE ID_Transaksi=:iddata and Batal='0'
                                order by a.ID desc");
            $this->db->bind('iddata', $iddata);
            $data =  $this->db->resultSet();
            $rows = array(); 
            $no = 0;
            foreach ($data as $key) {
                $no++; 
                $pasing['no'] = $no;
                $pasing['ID'] = $key['ID'];
                $pasing['Nilai'] = $key['Nilai'];
                $pasing['ID_Kas'] = $key['RekeningBiaya'];
                $pasing['KeteranganBiaya'] = $key['KeteranganBiaya'];
                $pasing['FS_NM_REKENING'] = $key['FS_NM_REKENING'];
                $pasing['NAMA_GROUP_BEBAN'] = $key['NAMA_GROUP_BEBAN']; 
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function deleteIdDetail($data)
    {
        try {
            $this->db->transaksi();

            if ($data['IDDetails'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Id tidak ditemukan !',
                );
                return $callback;
                exit;
            }

            $IDDetails = $data['IDDetails'];
   
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $TGLENTRI = Utils::seCurrentDateTime();

             
            //jurnal
            $this->db->query("UPDATE Keuangan.DBO.T_Kas_Keluar_2 set 
                            Batal=:BATAL , Tgl_Batal=:TGLENTRI, Petugas_Batal=:userid
                            where ID=:IDDetails"); 
            $this->db->bind('IDDetails', $IDDetails);
            $this->db->bind('userid', $userid);
            $this->db->bind('TGLENTRI', $TGLENTRI);
            $this->db->bind('BATAL', '1');
            $this->db->execute();

            $this->db->query("DELETE Keuangan.DBO.TA_JURNAL_DTL  
                            where FS_KD_REG=:IDDetails"); 
            $this->db->bind('IDDetails', $IDDetails); 
            $this->db->execute();

            $this->db->query("DELETE Keuangan.DBO.TA_JURNAL_HDR  
                            where FS_KET_REFF=:IDDetails"); 
            $this->db->bind('IDDetails', $IDDetails); 
            $this->db->execute();

            $this->db->commit();
            $this->db->closeCon();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Id Berhasil DiHapus !', // Set array status dengan success  
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function FinishTrs($data)
    {
        try {
            $this->db->transaksi();

            if ($data['IDNoTrsPencairan'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input No. Pencairan !',
                );
                return $callback;
                exit;
            }
            if ($data['TglPenyelesaian'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Tgl Pengeluaran Rutin !',
                );
                return $callback;
                exit;
            } 
              

            $IDNoTrsPencairan = $data['IDNoTrsPencairan']; 
            $TglPenyelesaian = $data['TglPenyelesaian']; 
         

            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $TGLENTRI = Utils::seCurrentDateTime();
 
            // cek jika total detil yang ada melebihi total nilai penyelesaian
            $this->db->query("SELECT isnull(SUM(b.Nilai),0) as nilai
                    FROM Keuangan.DBO.T_Kas_Keluar A INNER JOIN Keuangan.DBO.T_Kas_Keluar_2 B
                    ON A.id = B.ID_Transaksi where a.id=:IDNoTrsPencairan and b.Batal='0'");
            $this->db->bind('IDNoTrsPencairan', $IDNoTrsPencairan);
            $this->db->execute();
            $dttotal =  $this->db->single();
            $totalx = $dttotal['nilai']; 
            if ($totalx < 0) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Total Biaya 0. Periksa Kembali Data Anda !',
                );
                return $callback;
                exit;
            }

            $rek_kas_pengeluaran = "rek_kas_pengeluaran";
            $this->db->query('SELECT rekening FROM Keuangan.DBO.TZ_Parameter_Keu WHERE parameter=:rek_kas_pengeluaran');
            $this->db->bind('rek_kas_pengeluaran', $rek_kas_pengeluaran);
            $this->db->execute();
            $data =  $this->db->single();
            $val_rekening_Kas = $data['rekening'];
            if ($val_rekening_Kas === null || $val_rekening_Kas === "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Rekening Kas Pengeluaran Kosong, Cek Parameter Sistem !',
                );
                return $callback;
                exit;
            } else {
                $val_rekening_Kas = $data['rekening'];
            }
            $this->db->query("SELECT a.ID AS detailid, *from Keuangan.dbo.T_Kas_Keluar_2 a INNER JOIN Keuangan.dbo.T_Kas_Keluar B 
            on a.ID_Transaksi = b.id
            where a.Batal='0' and b.ID=:idJurnal
            order by 1 desc");  
            $this->db->bind('idJurnal', $IDNoTrsPencairan);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 0;
             
            $Tgl_Input_Finish = Utils::seCurrentDateTime();
            foreach ($data as $key) {
                $no++;
                // $pasing['no'] = $no;
                // $pasing['ID'] = $key['Nilai'];
                $kodeRegAwal = "PN";
                        $datenow2 = date('Y-m-d');
                        $formatDateJurnal =  Utils::idtrsByDateOnly();
                        //auto number jurnal
                        $this->db->query("SELECT  TOP 1 FS_KD_JURNAL,right(FS_KD_JURNAL,4) as urutregx,right(FS_KD_JURNAL,4)+1 as urutregxplus
                                        FROM Keuangan.dbo.TA_JURNAL_HDR  WHERE  
                                        SUBSTRING(FS_KD_JURNAL,3,6)=:formatDateJurnal AND LEFT(FS_KD_JURNAL,2)=:kodeRegAwal  
                                        ORDER BY FS_KD_JURNAL DESC");
                        $this->db->bind('formatDateJurnal', $formatDateJurnal);
                        $this->db->bind('kodeRegAwal', $kodeRegAwal); 
                        $this->db->execute();
                        $data =  $this->db->single();
                        $nourut = $data['urutregx'];
                        if (empty($nourut)) {
                            //jika gk ada record
                            $nourut = "0001";
                        } else {
                            //jika ada record
                            // $nourut++;
                            $nourut = $data['urutregxplus'];
                        }
                        $nourutfix = Utils::generateAutoNumberFourDigit($nourut); 
                        $idxt = Utils::idtrsByDateOnly();
                        $nokasbonAuto = $idxt;
                        $notransaksiJurnal = $kodeRegAwal  . $nokasbonAuto . '-' . $no.$nourutfix;

                        //UPDATE SELESAI TABEL KASBON
                        $this->db->query("UPDATE Keuangan.dbo.T_Kas_Keluar 
                                        SET Nominal=:totalx,
                                        Tgl_Transaksi=:tgl_penyelesaian,
                                        Petugas_Input_Finish=:operator,Status_Finish=:Status_Finish 
                                        ,Tgl_Input_Finish=:Tgl_Input_Finish 
                                        WHERE id=:id");
                        $this->db->bind('totalx', $totalx);
                        $this->db->bind('tgl_penyelesaian', $TglPenyelesaian);
                        $this->db->bind('operator', $userid);
                        $this->db->bind('Status_Finish', '1');
                        $this->db->bind('id', $IDNoTrsPencairan); 
                        $this->db->bind('Tgl_Input_Finish', $Tgl_Input_Finish); 
                        $this->db->execute();

                        //INSERT TABEL TA_JURNAL_HDR
                        $this->db->query("INSERT INTO Keuangan.dbo.TA_JURNAL_HDR
                                        (FS_KD_JURNAL,FD_TGL_JURNAL,FS_KD_PETUGAS,
                                        FN_DEBET,FN_KREDIT,fn_jurnal,FB_SELESAI,FS_KET_REFF) values
                                        (:NoJurnalFix,:tgl_penyelesaian,:userid,
                                        :nilai_penyelesaian,:nilai_penyelesaian2,:nilai_penyelesaian3,:FB_SELESAI,:FS_KET_REFF)");
                        $this->db->bind('NoJurnalFix', $notransaksiJurnal);
                        $this->db->bind('tgl_penyelesaian', $TglPenyelesaian);
                        $this->db->bind('userid', $userid);
                        $this->db->bind('FS_KET_REFF', $key['detailid']);
                        $this->db->bind('nilai_penyelesaian', $key['Nilai']);
                        $this->db->bind('nilai_penyelesaian2', $key['Nilai']);
                        $this->db->bind('nilai_penyelesaian3', $key['Nilai']); 
                        $this->db->bind('FB_SELESAI', '1'); 
                        $this->db->execute();

                        //INSERT TABEL TA_JURNAL_DTL BIAYA
                        $KeteranganJurnal = $key['KeteranganBiaya'];
                        $this->db->query("INSERT INTO Keuangan.dbo.TA_JURNAL_DTL
                                        (FS_KD_JURNAL,FS_KET_REFF,FN_DEBET,
                                        FN_KREDIT,FB_VOID,FS_REK,FS_KD_UNIT,FB_LEDGER,FS_KD_REFF,FS_KD_REG)
                                        VALUES 
                                        (:FS_KD_JURNAL,:FS_KET_REFF,:FN_DEBET,
                                        :FN_KREDIT,:FB_VOID,:FS_REK,:FS_KD_UNIT,:FB_LEDGER,:FS_KD_REFF,:FS_KD_REG)"); 
                        $this->db->bind('FS_KD_JURNAL', $notransaksiJurnal); 
                        $this->db->bind('FS_KET_REFF', $KeteranganJurnal); 
                        $this->db->bind('FN_DEBET', $key['Nilai']); 
                        $this->db->bind('FN_KREDIT', '0'); 
                        $this->db->bind('FB_VOID', '0'); 
                        $this->db->bind('FS_REK', $key['RekeningBiaya']); 
                        $this->db->bind('FS_KD_REG', $key['detailid']);
                        $this->db->bind('FS_KD_UNIT', $key['ID_Unit']); 
                        $this->db->bind('FB_LEDGER', '0'); 
                        $this->db->bind('FS_KD_REFF', $key['No_Transaksi']);  
                        $this->db->execute();

                        // JURNAL KAS  
                        $this->db->query("INSERT INTO Keuangan.dbo.TA_JURNAL_DTL
                                        ( FS_KD_JURNAL,FS_KET_REFF,FN_DEBET,
                                        FN_KREDIT,FB_VOID,FS_REK,FS_KD_UNIT,FB_LEDGER,FS_KD_REFF,FS_KD_REG) VALUES 
                                        (:NoJurnalFix,:KeteranganJurnal,:FN_DEBET,
                                        :FN_KREDIT,:FB_VOID,:val_rekening_Kas,:FS_KD_UNIT,:FB_LEDGER,:No_Transaksi,:FS_KD_REG)");
                        $this->db->bind('NoJurnalFix', $notransaksiJurnal);
                        $this->db->bind('KeteranganJurnal', $KeteranganJurnal);
                        $this->db->bind('FN_DEBET', '0');
                        $this->db->bind('FN_KREDIT', $key['Nilai']);
                        $this->db->bind('FS_KD_REG', $key['detailid']);
                        $this->db->bind('FB_VOID', '0');
                        $this->db->bind('FB_LEDGER', '0');
                        $this->db->bind('val_rekening_Kas', $val_rekening_Kas);
                        $this->db->bind('No_Transaksi', $key['No_Transaksi']);
                        $this->db->bind('FS_KD_UNIT', '');
                        $this->db->execute(); 
                       
            }
                        

            $this->db->commit();
            $this->db->closeCon();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success  
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function showlistPengeluaranRutin($data)
    {
        try {
            $this->db->query("SELECT a.*, c.[First Name],
            replace(CONVERT(VARCHAR(11), a.Tgl_Transaksi, 111), '/','-') as tgltransaksi  
            from Keuangan.dbo.T_Kas_Keluar a 
            inner join MasterDataSQL.dbo.Employees c on a.Petugas_Input_First collate Latin1_General_CI_AS =c.Nopin collate Latin1_General_CI_AS 
            where Batal='0' 
            order by replace(CONVERT(VARCHAR(11), a.Tgl_Transaksi, 111), '/','-')");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = 0;
            foreach ($data as $key) {
                $no++;
                $pasing['no'] = $no;
                $pasing['ID'] = $key['id'];
                $pasing['No_Transaksi'] = $key['No_Transaksi']; 
                $pasing['TglPencairan'] = date('d/m/Y H:i:s', strtotime($key['Tgl_Transaksi']));
                $pasing['Keterangan'] = $key['Keterangan'];
                $pasing['NominalPencairan'] = $key['Nominal'];   
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    } 
    public function getHeader($data)
    {
        try {
            $iddata = $data['IDNoTrsPencairan'];
            $this->db->query("SELECT ID,No_Transaksi,Tgl_Transaksi,Keterangan,Rekening_Kas_Pengeluaran
                            FROM Keuangan.dbo.T_Kas_Keluar where id=:iddata");
            $this->db->bind('iddata', $iddata);
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
}