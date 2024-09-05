<?php


class DailyReport_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function ShowDailyReportCurrentDate($data)
    {
        try {
            $session = SessionManager::getCurrentSession();
            $useridRole = $session->role;
            $userlogin = $session->username;
            $SrcLbDate1 = $data['SrcLbDate1'];
            $SrcLbDate2 = $data['SrcLbDate2'];
            $ptgbtl = "";

            $this->db->query("SELECT A.ID,A.KD_MOU,KD_TRS,a.KD_JO,B.NM_CLIENT,c.ID_MOU,B.ALAMAT,C.NM_PROJECT,
                            replace(CONVERT(VARCHAR(11),FD_TGL, 111), '/','-') FD_TGL 
                            ,KD_PEG_SM,D.Nama AS SPVName,b.NM_KEGIATAN
                            FROM P_T_DR A 
                            INNER JOIN P_M_LOKASI B 
                            ON A.KD_JO = B.KD_LOKASI
                            INNER JOIN P_P_WBS_HDR C
                            ON C.KODE_TRANSAKSI=A.KD_MOU
                            INNER JOIN [HR_Data Pegawai] D ON D.ID_Data = A.KD_PEG_SPV
                            where 
                            replace(CONVERT(VARCHAR(11),FD_TGL, 111), '/','-') between :SrcLbDate1 and :SrcLbDate2 
                            AND a.PETUGAS_BATAL=:ptgbtl");
            $this->db->bind('SrcLbDate1',  $data['SrcLbDate1']);
            $this->db->bind('SrcLbDate2',  $data['SrcLbDate1']);
            $this->db->bind('ptgbtl',  $ptgbtl);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['ID_MOU'] = $key['ID_MOU'];
                $pasing['KD_TRS'] = $key['KD_TRS'];
                $pasing['KD_JO'] = $key['KD_JO'];
                $pasing['NM_CLIENT'] = $key['NM_CLIENT'];
                $pasing['ALAMAT'] = $key['ALAMAT'];
                $pasing['NM_PROJECT'] = $key['NM_PROJECT'];
                $pasing['FD_TGL'] = $key['FD_TGL'];
                $pasing['SPVName'] = $key['SPVName'];
                $pasing['NM_KEGIATAN'] = $key['NM_KEGIATAN'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function genHdrDailyReport($data){
        try {
            $this->db->transaksi();
            if ($data['dr_Lokasi'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Kode Lokasi !',
                );
                return $callback;
                exit;
            }
            if ($data['dr_kode_peg_SM'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Nama Pegawai SM !',
                );
                return $callback;
                exit;
            }
            if ($data['dr_kode_peg_SPV'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Nama Supervisor !',
                );
                return $callback;
                exit;
            }
            if ($data['lb_tgl_logbook'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Tanggal Daily Report !',
                );
                return $callback;
                exit;
            }
            if ($data['lb_IdMOu'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan ID MOU !',
                );
                return $callback;
                exit;
            }
            if ($data['dr_timLBDate'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan ID TIM !',
                );
                return $callback;
                exit;
            }
            $kodeRegAwal = "DRP";
            $formatDateJurnal = Utils::idtrsByDateOnly();
            $IsPurchase = $data['IsPurchase'];
            $dr_Lokasi = $data['dr_Lokasi'];
            $dr_kode_peg_SM = $data['dr_kode_peg_SM'];
            $dr_kode_peg_SPV = $data['dr_kode_peg_SPV'];
            $lb_tgl_logbook = $data['lb_tgl_logbook'];
            $lb_IdMOu = $data['lb_IdMOu'];
            $dr_timLBDate = $data['dr_timLBDate'];
            $this->db->query("SELECT  TOP 1 KD_TRS,right(KD_TRS,3) as urutregx
                            FROM P_T_DR  WHERE  
                            SUBSTRING(KD_TRS,4,6)=:formatDateJurnal
                            AND LEFT(KD_TRS,3)=:kodeRegAwal  ORDER BY KD_TRS DESC ");
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
            $NoTrsDailyReport = $kodeRegAwal . $formatDateJurnal . '-' . $noUrutJurnal;
            $datenowcreateFull = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userlogin = $session->username;
            $fbspv = "1";
            $this->db->query("INSERT INTO P_T_DR
                      (KD_TRS,TGL_ENTRY,PETUGAS_ENTRY
                      ,KD_JO,KD_PEG_SPV,FB_SUPERVISOR,KD_PEG_SM,FD_TGL,KD_MOU,FB_PURCHASE,KD_TIM) values
                      (:NoTrsDailyReport,:datenowcreateFull,:userid
                      ,:dr_Lokasi,:dr_kode_peg_SPV,:fbspv,:dr_kode_peg_SM,:lb_tgl_logbook,:lb_IdMOu,:IsPurchase,:dr_timLBDate)");
            $this->db->bind('NoTrsDailyReport', $NoTrsDailyReport); 
            $this->db->bind('datenowcreateFull', $datenowcreateFull);
            $this->db->bind('userid', $userlogin);
            $this->db->bind('dr_Lokasi', $dr_Lokasi);
            $this->db->bind('dr_kode_peg_SPV', $dr_kode_peg_SPV);
            $this->db->bind('fbspv', $fbspv);
            $this->db->bind('dr_kode_peg_SM', $dr_kode_peg_SM);
            $this->db->bind('lb_tgl_logbook', $lb_tgl_logbook);
            $this->db->bind('lb_IdMOu', $lb_IdMOu);
            $this->db->bind('IsPurchase', $IsPurchase);
            $this->db->bind('dr_timLBDate', $dr_timLBDate); 
            $this->db->execute(); 
            $this->db->query("INSERT INTO P_T_DR_WEATHER
                        (KODE_TRANSAKSI) values
                        (:NoTrsDailyReport)");
            $this->db->bind('NoTrsDailyReport', $NoTrsDailyReport);
            $this->db->execute();    

            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'NoTRS' => $NoTrsDailyReport, // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function getEntryWeather($data)
    {
        try {
            $this->db->transaksi();
            $dr_IDTransaksi = $data['dr_IDTransaksi']; 
            $this->db->query("SELECT JAM_00,JAM_001,JAM_002,JAM_003,JAM_004,JAM_005,
                      JAM_006,JAM_007,JAM_008,JAM_009,JAM_0010,JAM_0011
                      ,JAM_0012,JAM_0013,JAM_0014,JAM_0015,JAM_0016,JAM_0017
                      ,JAM_0018,JAM_0019,JAM_0020,JAM_0021,JAM_0022,JAM_0023,JAM_0024 FROM P_T_DR_WEATHER
                WHERE KODE_TRANSAKSI= :dr_IDTransaksi");
            $this->db->bind('dr_IDTransaksi', $dr_IDTransaksi);
            $data =  $this->db->resultSet();
            $rows = array(); 
            foreach ($data as $key) {
                $pasing['JAM_00'] = $key['JAM_00'];
                $pasing['JAM_001'] = $key['JAM_001'];
                $pasing['JAM_002'] = $key['JAM_002'];
                $pasing['JAM_002'] = $key['JAM_002'];
                $pasing['JAM_003'] = $key['JAM_003'];
                $pasing['JAM_004'] = $key['JAM_004'];
                $pasing['JAM_005'] = $key['JAM_005'];
                $pasing['JAM_006'] = $key['JAM_006'];
                $pasing['JAM_007'] = $key['JAM_007'];
                $pasing['JAM_008'] = $key['JAM_008'];
                $pasing['JAM_009'] = $key['JAM_009'];
                $pasing['JAM_0010'] = $key['JAM_0010'];
                $pasing['JAM_0011'] = $key['JAM_0011'];
                $pasing['JAM_0012'] = $key['JAM_0012'];
                $pasing['JAM_0013'] = $key['JAM_0013'];
                $pasing['JAM_0014'] = $key['JAM_0014'];
                $pasing['JAM_0015'] = $key['JAM_0015'];
                $pasing['JAM_0016'] = $key['JAM_0016'];
                $pasing['JAM_0017'] = $key['JAM_0017'];
                $pasing['JAM_0018'] = $key['JAM_0018'];
                $pasing['JAM_0019'] = $key['JAM_0019'];
                $pasing['JAM_0020'] = $key['JAM_0020'];
                $pasing['JAM_0021'] = $key['JAM_0021'];
                $pasing['JAM_0022'] = $key['JAM_0022'];
                $pasing['JAM_0023'] = $key['JAM_0023'];
                $pasing['JAM_0024'] = $key['JAM_0024'];
                $rows[] = $pasing;
            }
            return $rows;

            } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function EditWeather($data)
    {
        try {
            $this->db->transaksi();
            $field = $data['field'];
            $datavalue = $data['datavalue'];
            $dr_IDTransaksi = $data['dr_IDTransaksi'];

            if ($datavalue == "0") {
                $datavaluefix = "1";
            } else {
                $datavaluefix = "0";
            }

            if ($field == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode Jam Kosong !',
                );
                return $callback;
                exit;
            }
            if ($dr_IDTransaksi == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode Transaksi Kosong !',
                );
                return $callback;
                exit;
            }
            if ($field == "0") {
                $this->db->query("UPDATE P_T_DR_WEATHER SET JAM_00=:datavaluefix
                WHERE KODE_TRANSAKSI=:dr_IDTransaksi ");
            } else if ($field == "1") {
                $this->db->query("UPDATE P_T_DR_WEATHER SET JAM_001=:datavaluefix
                WHERE KODE_TRANSAKSI=:dr_IDTransaksi ");
            } else  if ($field == "2") {
                $this->db->query("UPDATE P_T_DR_WEATHER SET JAM_002=:datavaluefix
                WHERE KODE_TRANSAKSI=:dr_IDTransaksi ");
            } else if ($field == "3") {
                $this->db->query("UPDATE P_T_DR_WEATHER SET JAM_003=:datavaluefix
                WHERE KODE_TRANSAKSI=:dr_IDTransaksi ");
            } else if ($field == "4") {
                $this->db->query("UPDATE P_T_DR_WEATHER SET JAM_004=:datavaluefix
                WHERE KODE_TRANSAKSI=:dr_IDTransaksi ");
            } else  if ($field == "5") {
                $this->db->query("UPDATE P_T_DR_WEATHER SET JAM_005=:datavaluefix
                WHERE KODE_TRANSAKSI=:dr_IDTransaksi ");
            } else if ($field == "6") {
                $this->db->query("UPDATE P_T_DR_WEATHER SET JAM_006=:datavaluefix
                WHERE KODE_TRANSAKSI=:dr_IDTransaksi ");
            } else if ($field == "7") {
                $this->db->query("UPDATE P_T_DR_WEATHER SET JAM_007=:datavaluefix
                WHERE KODE_TRANSAKSI=:dr_IDTransaksi ");
            } else  if ($field == "8") {
                $this->db->query("UPDATE P_T_DR_WEATHER SET JAM_008=:datavaluefix
                WHERE KODE_TRANSAKSI=:dr_IDTransaksi ");
            } else if ($field == "9") {
                $this->db->query("UPDATE P_T_DR_WEATHER SET JAM_009=:datavaluefix
                WHERE KODE_TRANSAKSI=:dr_IDTransaksi ");
            } else if ($field == "10") {
                $this->db->query("UPDATE P_T_DR_WEATHER SET JAM_0010=:datavaluefix
                WHERE KODE_TRANSAKSI=:dr_IDTransaksi ");
            } else  if ($field == "11") {
                $this->db->query("UPDATE P_T_DR_WEATHER SET JAM_0011=:datavaluefix
                WHERE KODE_TRANSAKSI=:dr_IDTransaksi ");
            } else if ($field == "12") {
                $this->db->query("UPDATE P_T_DR_WEATHER SET JAM_0012=:datavaluefix
                WHERE KODE_TRANSAKSI=:dr_IDTransaksi ");
            } else if ($field == "13") {
                $this->db->query("UPDATE P_T_DR_WEATHER SET JAM_0013=:datavaluefix
                WHERE KODE_TRANSAKSI=:dr_IDTransaksi ");
            } else  if ($field == "14") {
                $this->db->query("UPDATE P_T_DR_WEATHER SET JAM_0014=:datavaluefix
                WHERE KODE_TRANSAKSI=:dr_IDTransaksi ");
            } else if ($field == "15") {
                $this->db->query("UPDATE P_T_DR_WEATHER SET JAM_0015=:datavaluefix
                WHERE KODE_TRANSAKSI=:dr_IDTransaksi ");
            } else if ($field == "16") {
                $this->db->query("UPDATE P_T_DR_WEATHER SET JAM_0016=:datavaluefix
                WHERE KODE_TRANSAKSI=:dr_IDTransaksi ");
            } else  if ($field == "17") {
                $this->db->query("UPDATE P_T_DR_WEATHER SET JAM_0017=:datavaluefix
                WHERE KODE_TRANSAKSI=:dr_IDTransaksi ");
            } else if ($field == "18") {
                $this->db->query("UPDATE P_T_DR_WEATHER SET JAM_0018=:datavaluefix
                WHERE KODE_TRANSAKSI=:dr_IDTransaksi ");
            } else if ($field == "19") {
                $this->db->query("UPDATE P_T_DR_WEATHER SET JAM_0019=:datavaluefix
                WHERE KODE_TRANSAKSI=:dr_IDTransaksi ");
            } else if ($field == "20") {
                $this->db->query("UPDATE P_T_DR_WEATHER SET JAM_0020=:datavaluefix
                WHERE KODE_TRANSAKSI=:dr_IDTransaksi ");
            } else if ($field == "21") {
                $this->db->query("UPDATE P_T_DR_WEATHER SET JAM_0021=:datavaluefix
                WHERE KODE_TRANSAKSI=:dr_IDTransaksi ");
            } else if ($field == "22") {
                $this->db->query("UPDATE P_T_DR_WEATHER SET JAM_0022=:datavaluefix
                WHERE KODE_TRANSAKSI=:dr_IDTransaksi ");
            } else if ($field == "23") {
                $this->db->query("UPDATE P_T_DR_WEATHER SET JAM_0023=:datavaluefix
                WHERE KODE_TRANSAKSI=:dr_IDTransaksi ");
            } else if ($field == "24") {
                $this->db->query("UPDATE P_T_DR_WEATHER SET JAM_0024=:datavaluefix
                WHERE KODE_TRANSAKSI=:dr_IDTransaksi ");
            } 
            $this->db->bind('dr_IDTransaksi', $dr_IDTransaksi);
            $this->db->bind('datavaluefix', $datavaluefix); 
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

    public function showWBSAllAktifFilterPurchase($data)
    {
        try {
            $this->db->transaksi();
            $zlb_Lokasi = $data['zlb_Lokasi'];
            $lb_IdMOu = $data['lb_IdMOu'];
            $lb_tgl_logbook = $data['lb_tgl_logbook'];
            $isPurchase = $data['isPurchase'];
            $iifnull = "0";
            $iifnull2 = "1";
             
            if ($isPurchase == "0") {
                $this->db->query("SELECT a.ID as IDLogBookTrs,a.ID_WBS, d.NM_WBS,d.QTY
                        from  
                        ( select a.ID,a.KD_MOU,b.ID_WBS from  P_T_LB a
                        inner join P_T_LB_DETIL b on a.KD_TRS = b.KD_TRS
                        where a.BATAL=:iifnull and   
                        replace(CONVERT(VARCHAR(11),a.TGL_LOG_BOOK, 111), '/','-')  =:lb_tgl_logbook
                        and a.batal=0 and KD_MOU=:lb_IdMOu and KD_JO=:zlb_Lokasi
                        group by a.KD_MOU,b.ID_WBS,a.ID) a 
                        inner join P_P_WBS_BOQ d on a.KD_MOU=d.KODE_TRANSAKSI and a.ID_WBS=d.id");
                $this->db->bind('iifnull', $iifnull);
                $this->db->bind('lb_tgl_logbook', $lb_tgl_logbook);
                $this->db->bind('zlb_Lokasi', $zlb_Lokasi);
                $this->db->bind('lb_IdMOu', $lb_IdMOu); 
            } else  {
                $this->db->query("SELECT '0' as IDLogBookTrs, ID as ID_WBS, NM_WBS,QTY
                        FROM P_P_WBS_BOQ where KODE_TRANSAKSI=:lb_IdMOu
                        AND UNIT_MATERIAL > :iifnull AND TASK_STATUS=:iifnull2 ");
                $this->db->bind('iifnull', $iifnull);
                $this->db->bind('iifnull2', $iifnull2);
                $this->db->bind('lb_IdMOu', $lb_IdMOu); 
            }

            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['IDLogBookTrs'] = $key['IDLogBookTrs'];
                $pasing['NM_WBS'] = $key['NM_WBS'];
                $pasing['ID_WBS'] = $key['ID_WBS'];
                $pasing['QTY'] = $key['QTY']; 
                $rows[] = $pasing;
                $array['getMou'] = $rows; 
            }
            return $array;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function calculateProgressAwl($data)
    {
        try {
            $this->db->transaksi();
            $lb_IdMOu = $data['lb_IdMOu'];
            $wbsid = $data['wbsid'];
            $lb_SPV = $data['lb_SPV'];
            $lb_tgl_logbook = $data['lb_tgl_logbook'];
            $xbtl = "0";
 
                $this->db->query("SELECT *,  
                case when QTY_PLAN=0 then 0
                when QTY_PROGRESS=0 then 0 
                else (QTY_PROGRESS/QTY_PLAN)*100.00 end  PROC_RUNNING FROM (
                select KD_PEG_SPV,A.KD_MOU,a.ID_WBS, d.NM_WBS,d.QTY QTY_PLAN,ISNULL(QTY_PROGRESS,0) QTY_PROGRESS
                from  
                      ( select KD_PEG_SPV,KD_MOU,ID_WBS from  P_T_LB where BATAL=0 and
                       TGL_LOG_BOOK =:lb_tgl_logbook and 
                       batal=:xbtl and 
                       KD_MOU=:lb_IdMOu and 
                       ID_WBS=:wbsid and 
                       KD_PEG_SPV=:lb_SPV
                        group by kd_peg_spv,KD_MOU,ID_WBS) a 
                left join P_P_WBS_BOQ d on a.KD_MOU=d.KODE_TRANSAKSI and a.ID_WBS=d.id
                left join  (  select KD_MOU,ID_WBS,sum(QTY) QTY_PROGRESS from  P_T_DR_ACTIVITY 
                where BATAL=0 group by KD_MOU,id_wbs ) c on c.kd_mou=a.kd_mou and c.id_wbs=a.id_wbs
                ) X"); 
                $this->db->bind('lb_IdMOu', $lb_IdMOu);
                $this->db->bind('wbsid', $wbsid);
                $this->db->bind('lb_SPV', $lb_SPV);
                $this->db->bind('lb_tgl_logbook', $lb_tgl_logbook);
                $this->db->bind('xbtl', $xbtl); 
                $data =  $this->db->single();
                $count = $this->db->rowCount();
                $dataaku = $data['PROC_RUNNING']; 
                if ($dataaku === 0 || $dataaku === null) {
                    $datax = 0;
                } else {
                    $datax = $data['PROC_RUNNING'];
                }
                $callback = array(
                    'status' => 'success',
                    'PROC_RUNNING' => $datax,
                );
                return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function calculateProgressAkr($data)
    {
        try {
            $this->db->transaksi();
            $lb_IdMOu = $data['lb_IdMOu'];
            $wbsid = $data['wbsid'];
            $lb_SPV = $data['lb_SPV'];
            $lb_tgl_logbook = $data['lb_tgl_logbook'];
            $xbtl = "0";
            $ep_dr3_qty = $data['ep_dr3_qty'];

            $this->db->query("SELECT *,
                case when QTY_PLAN=0 then 0
                   when QTY_PROGRESS=0 then 0 ELSE 
                (QTY_AKHIR/QTY_PLAN)*100.00  END PROC_AKHIR FROM (
                SELECT *,QTY_PROGRESS+QTY_INPUT QTY_AKHIR  FROM (
                SELECT *,  
                case when QTY_PLAN=0 then 0
                   when QTY_PROGRESS=0 then 0 
                 else (QTY_PROGRESS/QTY_PLAN)*100.00 end  PROC_RUNNING,:ep_dr3_qty QTY_INPUT FROM (
                select KD_PEG_SPV,A.KD_MOU,a.ID_WBS, d.NM_WBS,d.QTY QTY_PLAN,ISNULL(QTY_PROGRESS,0) QTY_PROGRESS
                from  
                      ( select KD_PEG_SPV,KD_MOU,ID_WBS from  P_T_LB where 
                        BATAL=:xbtl and
                       TGL_LOG_BOOK =:lb_tgl_logbook and
                        batal=:xbtl2 and 
                        KD_MOU=:lb_IdMOu and 
                        ID_WBS=:wbsid and 
                        KD_PEG_SPV=:lb_SPV 
                        group by KD_PEG_SPV,KD_MOU,ID_WBS) a 
                left join P_P_WBS_BOQ d on a.KD_MOU=d.KODE_TRANSAKSI and a.ID_WBS=d.id
                left join  (  select KD_MOU,ID_WBS,sum(QTY) QTY_PROGRESS from  P_T_DR_ACTIVITY where BATAL=0 group by KD_MOU,id_wbs ) c on c.kd_mou=a.kd_mou and c.id_wbs=a.id_wbs
                ) X
                ) X
                ) X "); 
            $this->db->bind('lb_IdMOu', $lb_IdMOu);
            $this->db->bind('wbsid', $wbsid);
            $this->db->bind('lb_SPV', $lb_SPV);
            $this->db->bind('lb_tgl_logbook', $lb_tgl_logbook);
            $this->db->bind('xbtl', $xbtl);
            $this->db->bind('xbtl2', $xbtl);
            $this->db->bind('ep_dr3_qty', $ep_dr3_qty);
            $data =  $this->db->single();
            $count = $this->db->rowCount();
            $dataaku = $data['PROC_AKHIR'];
            if ($dataaku === 0 || $dataaku === null) {
                $datax = 0;
            } else {
                $datax = $data['PROC_AKHIR'];
            }
            $callback = array(
                'status' => 'success',
                'PROC_AKHIR' => $datax,
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function addkegiatan($data)
    {
        try {
            $this->db->transaksi();
            $dr_IDTransaksi = $data['dr_IDTransaksi'];
            $ep_dr3_kegiatan = $data['ep_dr3_kegiatan'];
            $ep_dr3_wbslog  = $data['ep_dr3_wbslog'];
            $lb_IdMOu = $data['lb_IdMOu'];
            $ep_dr3_qty = $data['ep_dr3_qty'];
            $ep_dr3_tim = $data['dr_timLBDate'];
            $batal = "0";

            if ($dr_IDTransaksi == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode Transaksi Kosong !',
                );
                return $callback;
                exit;
            }
            if ($ep_dr3_kegiatan == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Kegiatan !',
                );
                return $callback;
                exit;
            }
            if ($ep_dr3_wbslog == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Wbs Name !',
                );
                return $callback;
                exit;
            }
            if ($lb_IdMOu == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan ID MOU!',
                );
                return $callback;
                exit;
            }
            if ($ep_dr3_qty == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Qty Kegiatan !',
                );
                return $callback;
                exit;
            } 

            $this->db->query("INSERT INTO P_T_DR_ACTIVITY
                            (KD_TRS,TIM,KEGIATAN,Batal,ID_WBS,KD_MOU,QTY) values
                            (?,?,?,?,?,?,?)"); 
            $this->db->bind(1, $dr_IDTransaksi);
            $this->db->bind(2, $ep_dr3_tim);
            $this->db->bind(3, $ep_dr3_kegiatan);
            $this->db->bind(4, $batal);
            $this->db->bind(5, $ep_dr3_wbslog);
            $this->db->bind(6, $lb_IdMOu);
            $this->db->bind(7, $ep_dr3_qty); 
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
    public function getEntryActivity($data)
    {
        try {
            $dr_IDTransaksi = $data['dr_IDTransaksi'];
            $batal = "0";
            $this->db->query("SELECT ID,TIM,KEGIATAN FROM P_T_DR_ACTIVITY WHERE KD_TRS=:dr_IDTransaksi and Batal=:batal");
            $this->db->bind('dr_IDTransaksi',  $dr_IDTransaksi);
            $this->db->bind('batal',  $batal); 
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['TIM'] = $key['TIM'];
                $pasing['KEGIATAN'] = $key['KEGIATAN'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function updateBatalEntryKegiatan($data)
    {
        try {
            $this->db->transaksi();
            $JM_ID = $data['JM_ID_Activity'];
            $alasan = $data['alasan_Activity'];
            $batal = "1";
            if ($JM_ID == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode Invalid !',
                );
                return $callback;
                exit;
            }
            if ($alasan == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Alasan Invalid !',
                );
                return $callback;
                exit;
            }  

            $this->db->query("UPDATE P_T_DR_ACTIVITY SET Batal=:batal ,Alasan=:alasan
                            where ID=:JM_ID"); 
            $this->db->bind('JM_ID', $JM_ID);
            $this->db->bind('batal', $batal);
            $this->db->bind('alasan', $alasan); 
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
    public function uploadFotoDailyReport($data){
        $filename = $_FILES['file']['name'];
        $ep_dr3_img_caption = $data['ep_dr3_img_caption'];
        $dr_IDTransaksi = $data['dr_IDTransaksi'];
        // Valid extension
        $valid_ext = array('png', 'jpeg', 'jpg');

        // Location
        $location = __DIR__ . '/../../public' . '/upload/' . $filename;
        $locationfake = __DIR__ . '/../../public' . '/upload/' . $filename;
        $thumbnail_location = __DIR__ . '/../../public' . "/upload/thumbnail/" . $filename;
        $thumbnail_locationfake = "/upload/thumbnail/" . $filename;
        // file extension
        $file_extension = pathinfo($location, PATHINFO_EXTENSION);
        $file_extension = strtolower($file_extension);
        try {
            $this->db->transaksi();
            // Check extension
            if (in_array($file_extension, $valid_ext)) {

                // Upload file
                if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {

                    // Compress Image
                    Utils::compressImage($_FILES['file']['type'], $location, $thumbnail_location, 60);
                    // save to db
                    $this->db->query("INSERT into P_T_DR_IMAGES(ID_TRANSAKSI,CAPTION,images_location,images) 
                                    values(?, ?, ?, ?)"); 
                    $this->db->bind(1, $dr_IDTransaksi);
                    $this->db->bind(2, $ep_dr3_img_caption);
                    $this->db->bind(3, $thumbnail_locationfake);
                    $this->db->bind(4, $filename); 
                    $this->db->execute();
                    $this->db->commit();
                    $callback = array(
                        'status' => 'sukses',
                        'errorname' => 'Sukses !',
                    );
                    return $callback;
                    unlink(__DIR__ . '/../../public' . '/upload/' . $filename);
                } else {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Gagal Upload !',
                    );
                    return $callback;
                }
            } else {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Format invalid, Harus png,jpeg,jpg !',
                );
                return $callback;
            }
        } catch (PDOException $e) {
           // $koneksi->rollBack();
            $callback = array(
                'status' => 'error', // Set array status dengan success   
                'errormessage' => $e, // Set array status dengan success    
            );
            return $callback;
        }





    }
    public function showfotoDailyReport($data)
    {
        try {
            
            $dr_IDTransaksi = $data['dr_IDTransaksi'];  
                $this->db->query("SELECT id, CAPTION  , images_location , images  
                FROM P_T_DR_IMAGES  where ID_TRANSAKSI=:dr_IDTransaksi ");
                $this->db->bind('dr_IDTransaksi', $dr_IDTransaksi);  
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['id'] = $key['id'];
                $pasing['images_location'] = $key['images_location'];
                $pasing['images'] = $key['images'];
                $pasing['CAPTION'] = $key['CAPTION'];
                $rows[] = $pasing; 
            }
            return $rows;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function getdataTools($data)
    {
        try { 
            $this->db->query("SELECT   ID,NAMA_BARANG  from P_M_TOOLS where Status_Aktif='1' "); 
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['NAMA_BARANG'] = $key['NAMA_BARANG'];
                $rows[] = $pasing;
                $array['getdataTools'] = $rows; 
            }
            return $array;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function SaveAddtools($data)
    {
        try {
            $this->db->transaksi();
            $AddToolsNama = $_POST['AddToolsNama'];
            $AddToolsSat = $_POST['AddToolsSat'];
            $aktif = "1";
            if ($AddToolsNama == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Nama Tools Kosong !',
                );
                return $callback;
                exit;
            }
            if ($AddToolsSat == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Satuan Tools Kosong !',
                );
                return $callback;
                exit;
            }  


            $this->db->query("INSERT INTO P_M_TOOLS  (NAMA_BARANG,SATUAN,Status_Aktif) VALUES
                            (:AddToolsNama,:AddToolsSat,:aktif)");
            $this->db->bind('AddToolsNama', $AddToolsNama);
            $this->db->bind('AddToolsSat', $AddToolsSat);
            $this->db->bind('aktif', $aktif); 
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
    public function addDRTools($data)
    {
        try {
            $this->db->transaksi();
            $dr_IDTransaksi = $data['dr_IDTransaksi'];
            $ep_dr2_tools = $data['ep_dr2_tools'];
            $ep_dr2_qty = $data['ep_dr2_qty'];
            if ($dr_IDTransaksi == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode Transaksi Kosong !',
                );
                return $callback;
                exit;
            }
            if ($ep_dr2_tools == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Tools !',
                );
                return $callback;
                exit;
            }
            if ($ep_dr2_qty == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Qty !',
                );
                return $callback;
                exit;
            } 
   
            $nol="0";
            $this->db->query("INSERT INTO P_T_DR_EQUIP
                      (KD_TRS,ID_Data,QTY,Batal) values
                      (:dr_IDTransaksi,:ep_dr2_tools,:ep_dr2_qty,:nol)");
            $this->db->bind('dr_IDTransaksi', $dr_IDTransaksi);
            $this->db->bind('ep_dr2_tools', $ep_dr2_tools);
            $this->db->bind('ep_dr2_qty', $ep_dr2_qty);
            $this->db->bind('nol', $nol);  
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
    public function getEntryTools($data)
    {
        try {
            $dr_IDTransaksi = $data['dr_IDTransaksi'];
            $batal = "0";
            $this->db->query("SELECT A.ID,A.KD_TRS,A.ID_Data,B.NAMA_BARANG AS Nama,B.SATUAN,A.QTY ,A.Batal,a.alasan
                    FROM P_T_DR_EQUIP A
                    INNER JOIN P_M_TOOLS B
                    on a.ID_Data = b.ID
                    where a.KD_TRS=:dr_IDTransaksi and a.Batal=:batal ");
            $this->db->bind('dr_IDTransaksi', $dr_IDTransaksi);
            $this->db->bind('batal', $batal);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['Nama'] = $key['Nama'];
                $pasing['QTY'] = $key['QTY'];
                $pasing['SATUAN'] = $key['SATUAN'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function UpdateBatalDataTools($data)
    {
        try {
            $this->db->transaksi();
            $JM_ID = $data['JM_ID_Tools'];
            $alasan = $data['alasan_tools'];

            if ($JM_ID == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode Invalid !',
                );
                return $callback;
                exit;
            }
            if ($alasan == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Alasan Invalid !',
                );
                return $callback;
                exit;
            }
            $batal = "1";
            $this->db->query("UPDATE P_T_DR_EQUIP SET Batal=:batal ,Alasan=:alasan
                            where ID=:JM_ID");
            $this->db->bind('JM_ID', $JM_ID);
            $this->db->bind('batal', $batal);
            $this->db->bind('alasan', $alasan);
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
    public function addDRTools_Rencana($data)
    {
        try {
            $this->db->transaksi();
            $ep_dr5_rencanan_keg = $data['ep_dr5_rencanan_keg'];
            $ep_dr5_TIM = $data['ep_dr5_TIM'];
            $dr_IDTransaksi = $data['dr_IDTransaksi'];

            if ($dr_IDTransaksi == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode Transaksi Kosong !',
                );
                return $callback;
                exit;
            }
            if ($ep_dr5_rencanan_keg == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Rencana Kegiatan !',
                );
                return $callback;
                exit;
            } 

            $this->db->query("INSERT INTO P_T_DR_PLANNING
                            ( KODE_TRANSAKSI,PLANNING,NAMA_TIM) 
                                values
                            ( ?,?,?)"); 
            $this->db->bind(1, $dr_IDTransaksi);
            $this->db->bind(2, $ep_dr5_rencanan_keg);
            $this->db->bind(3, $ep_dr5_TIM); 
            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success    
                'NoTRS' => $dr_IDTransaksi, 
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function getEntryTools_Rencana($data)
    {
        try {
            $dr_IDTransaksi = $data['dr_IDTransaksi'];
            $batal = "0";
            $this->db->query("SELECT  ID,KODE_TRANSAKSI,PLANNING,TIM ,NAMA_TIM
                            FROM P_T_DR_PLANNING  
                            WHERE Batal= :batal AND  KODE_TRANSAKSI= :dr_IDTransaksi ");
            $this->db->bind('dr_IDTransaksi', $dr_IDTransaksi);
            $this->db->bind('batal', $batal);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['PLANNING'] = $key['PLANNING'];
                $pasing['NAMA_TIM'] = $key['NAMA_TIM']; 
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function UpdateBatalDataRencanaKeg($data)
    {
        try {
            $this->db->transaksi();
            $JM_ID = $data['JM_ID_Toolsx'];
            $alasan = $data['alasan_tools'];

            if ($JM_ID == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode Invalid !',
                );
                return $callback;
                exit;
            }
            if ($alasan == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Alasan Invalid !',
                );
                return $callback;
                exit;
            }
            $batal = "1";
            $this->db->query("UPDATE P_T_DR_PLANNING SET Batal=:batal ,Alasan=:alasan
                            where ID=:JM_ID");
            $this->db->bind('JM_ID', $JM_ID);
            $this->db->bind('batal', $batal);
            $this->db->bind('alasan', $alasan);
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

    public function batalTrsDR($data)
    {
        try {
            $this->db->transaksi();
            $dr_Lokasi = $_POST['dr_Lokasi'];
            $dr_kode_peg_SM = $_POST['dr_kode_peg_SM'];
            $dr_kode_peg_SPV = $_POST['dr_kode_peg_SPV'];
            $dr_IDTransaksi = $_POST['dr_IDTransaksi'];

            if ($dr_IDTransaksi == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode Invalid !',
                );
                return $callback;
                exit;
            }
            if ($dr_Lokasi == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode JO Invalid !',
                );
                return $callback;
                exit;
            }
            if ($dr_kode_peg_SPV == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode SPV Invalid !',
                );
                return $callback;
                exit;
            }
            $fbbatal = "1";


            $datenowcreateFull = Utils::seCurrentDateTime();
            $datenowcreateNotFull = Utils::datenowcreateNotFull();
            $session = SessionManager::getCurrentSession(); 
            $userid = $session->username;


            $this->db->query("UPDATE P_T_DR SET  TGL_BATAL=:datenowcreateFull,PETUGAS_BATAL=:userid 
                            where KD_TRS=:dr_IDTransaksi"); 
            $this->db->bind('datenowcreateFull', $datenowcreateFull);
            $this->db->bind('userid', $userid);
            $this->db->bind('dr_IDTransaksi', $dr_IDTransaksi); 
            $this->db->execute();

            //batal activity
            $this->db->query("UPDATE P_T_DR_ACTIVITY SET  BATAL=:fbbatal
                            where KD_TRS=:dr_IDTransaksi"); 
            $this->db->bind('fbbatal', $fbbatal); 
            $this->db->bind('dr_IDTransaksi', $dr_IDTransaksi);
            $this->db->execute();

            //batal tools
            $this->db->query("UPDATE P_T_DR_EQUIP SET  BATAL=:fbbatal3
                            where KD_TRS=:dr_IDTransaksi");
            $this->db->bind('fbbatal3', $fbbatal);
            $this->db->bind('dr_IDTransaksi', $dr_IDTransaksi);
            $this->db->execute();

            //batal planing
            $this->db->query("UPDATE P_T_DR_PLANNING SET  BATAL=:fbbatal4
                            where KODE_TRANSAKSI=:dr_IDTransaksi");
            $this->db->bind('fbbatal4', $fbbatal);
            $this->db->bind('dr_IDTransaksi', $dr_IDTransaksi);
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
    public function ShowDataTRsDRbyID($data)
    {
        try {
            $this->db->query("SELECT A.ID,A.KD_MOU,KD_TRS,a.KD_JO,B.NM_CLIENT,c.ID_MOU,B.ALAMAT,C.NM_PROJECT,CONVERT(VARCHAR(11),FD_TGL, 111) FD_TGL 
                ,KD_PEG_SM,FD_TGL,a.KD_PEG_SPV,a.KD_TIM,a.FB_PURCHASE
                FROM P_T_DR A 
                INNER JOIN P_M_LOKASI B 
                ON A.KD_JO = B.KD_LOKASI
                INNER JOIN P_P_WBS_HDR C
                ON C.KODE_TRANSAKSI=A.KD_MOU
                where a.ID = :params");
            $this->db->bind('params', $data['q']);
            $data =  $this->db->single(); 
            $pasing['KD_TRS'] = $data['KD_TRS'];  
            $pasing['KD_JO'] = $data['KD_JO'];
            $pasing['KD_MOU'] = $data['KD_MOU'];
            $pasing['FD_TGL'] = $data['FD_TGL'];
            $pasing['KD_PEG_SM'] = $data['KD_PEG_SM'];
            $pasing['KD_PEG_SPV'] = $data['KD_PEG_SPV'];
            $pasing['KD_TIM'] = $data['KD_TIM'];
            $pasing['FB_PURCHASE'] = $data['FB_PURCHASE']; 
            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function FinishTRansaksi($data){ 
        
        try {
            $this->db->transaksi();
            $dr_Lokasi = $data['dr_Lokasi'];
            $dr_kode_peg_SM = $data['dr_kode_peg_SM'];
            $dr_kode_peg_SPV = $data['dr_kode_peg_SPV'];
            $dr_IDTransaksi = $data['dr_IDTransaksi'];

            if ($dr_IDTransaksi == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode Invalid !',
                );
                return $callback;
                exit;
            }
            if ($dr_Lokasi == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode JO Invalid !',
                );
                return $callback;
                exit;
            }
            if ($dr_kode_peg_SPV == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode SPV Invalid !',
                );
                return $callback;
                exit;
            }
            $fbbatal = "1";
            $selesa = "1";
            $batalx = "0";
            $datenowcreateFull = Utils::seCurrentDateTime();
            $datenowcreateNotFull = Utils::datenowcreateNotFull();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $this->db->query("UPDATE P_T_DR SET SELESAI=:selesa ,
                            TGL_SELESAI=:datenowcreateFull,PETUGAS_SELESAI=:userid 
                            where KD_TRS=:dr_IDTransaksi");

            $this->db->bind('datenowcreateFull', $datenowcreateFull);
            $this->db->bind('userid', $userid);
            $this->db->bind('dr_IDTransaksi', $dr_IDTransaksi);
            $this->db->bind('selesa', $selesa);
            $this->db->execute();
            $this->db->query("UPDATE P_T_LB SET KD_TRS_DR=:dr_IDTransaksi2
                            WHERE TGL_LOG_BOOK=:datenowcreateFull2 
                            AND KD_PEG_SPV=:dr_kode_peg_SPV2 and BATAL=:batalx ");

            $this->db->bind('datenowcreateFull2', $datenowcreateNotFull);
            $this->db->bind('dr_kode_peg_SPV2', $dr_kode_peg_SPV);
            $this->db->bind('dr_IDTransaksi2', $dr_IDTransaksi);
            $this->db->bind('batalx', $batalx);
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
}