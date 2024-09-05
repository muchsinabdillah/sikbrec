<?php


class LogBook_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getEntrylogBookbyCurrentDay($data)
    {
        try {
            $session = SessionManager::getCurrentSession();
            $useridRole = $session->role;
            $userlogin = $session->username;
            $batal  = "0";
                $this->db->query("SELECT g.ID as detil,A.ID,A.KD_TRS,A.KD_JO,A.FS_REFF_PEGAWAI,g.FS_KEGIATAN,A.ID_WBS,b.NM_WBS
                                ,a.TIME_START,a.TIME_END , d.Nama as SPVName,E.Nama AS NamaPegawai,g.TIME_START_JADWAL,g.TIME_END_JADWAL
                                from P_T_LB_DETIL g
                                inner join P_T_LB a ON A.KD_TRS = G.KD_TRS
                                INNER JOIN P_P_WBS_BOQ B
                                ON g.ID_WBS = B.ID
                                INNER JOIN P_P_WBS_HDR C
                                ON C.KODE_TRANSAKSI  = B.KODE_TRANSAKSI
                                INNER JOIN [HR_Data Pegawai] D 
                                ON D.ID_Data = A.KD_PEG_SPV
                                inner join [HR_Data Pegawai] E
                                ON G.KD_PEG = E.ID_Data
                                WHERE A.BATAL=:abatal AND c.BATAL=:cbatal and a.KD_MOU=:lb_IdMOu and g.BATAL=:gbatal 
                                and a.KD_TRS=:lb_IDTransaksi    order by a.TIME_START asc");
                $this->db->bind('lb_IdMOu',$data['lb_IdMOu']);
                $this->db->bind('lb_IDTransaksi',  $data['lb_IDTransaksi']);
                $this->db->bind('gbatal', $batal);
                $this->db->bind('cbatal', $batal);
                $this->db->bind('abatal', $batal);
                $data =  $this->db->resultSet();    
                $rows = array();
                $array = array();
                foreach ($data as $key) {
                    $pasing['ID'] = $key['KD_TRS'];
                    $pasing['IDx'] = $key['ID'];
                    $pasing['KD_JO'] = $key['KD_JO'];
                    $pasing['FS_REFF_PEGAWAI'] = $key['NamaPegawai'];
                    $pasing['FS_KEGIATAN'] = $key['FS_KEGIATAN'];
                    $pasing['ID_WBS'] = $key['ID_WBS'];
                    $pasing['NM_WBS'] = $key['NM_WBS'];
                    $pasing['TIME_START'] = $key['TIME_START'];
                    $pasing['TIME_END'] = $key['TIME_END'];
                    $pasing['SPVName'] = $key['SPVName'];
                    $pasing['detil'] = $key['detil'];
                    $pasing['TIME_END_JADWAL'] = $key['TIME_END_JADWAL'];
                    $pasing['TIME_START_JADWAL'] = $key['TIME_START_JADWAL'];
                    $rows[] = $pasing;  
                }
                return $rows;
             
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getMoubyIDAktif($id){
        try {
            $this->db->query("SELECT a.ID,a.ID_MOU,a.KODE_TRANSAKSI,a.NM_PROJECT,a.LOKASI_KERJA,
                            replace(CONVERT(VARCHAR(11), a.DATE_START, 111), '/','-') DATE_START,
                            replace(CONVERT(VARCHAR(11), a.DATE_END, 111), '/','-')  DATE_END,a.FN_DURASI,a.KD_JO
                            ,B.NM_PROJECT,b.NM_KEGIATAN,b.ALAMAT,b.NM_CLIENT,d.Nama as Sm_name
                            FROM P_P_WBS_HDR a
                            inner join P_M_LOKASI b on a.KD_JO  = b.KD_LOKASI
							inner join P_P_WBS_HDR_PEG c on c.KODE_TRANSAKSI = a.KODE_TRANSAKSI
							inner join [HR_Data Pegawai] d on d.ID_Data = c.KD_PEG
                            where a.KODE_TRANSAKSI= :id   and c.TIPE_PEG='SITE_MANAGER'");
            $this->db->bind('id', $id);
            $data =  $this->db->single();
            $pasing['ID'] = $data['ID'];
            $pasing['NM_PROJECT'] = $data['NM_PROJECT'];
            $pasing['LOKASI_KERJA'] = $data['LOKASI_KERJA'];
            $pasing['DATE_START'] = $data['DATE_START'];
            $pasing['DATE_END'] = $data['DATE_END'];
            $pasing['KD_JO'] = $data['KD_JO'];
            $pasing['ALAMAT'] = $data['ALAMAT'];
            $pasing['NM_PROJECT'] = $data['NM_PROJECT'];
            $pasing['NM_KEGIATAN'] = $data['NM_KEGIATAN'];
            $pasing['NM_CLIENT'] = $data['NM_CLIENT'];
            $pasing['Sm_name'] = $data['Sm_name'];
            $pasing['ID_MOU'] = $data['ID_MOU'];
            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getAllSPVbyKontrak($data)
    {
        try {
            $iifSPV  = "1"; 
            $this->db->query("SELECT b.Nama,a.ID_Data 
                            FROM P_P_WBS_TIM a
                            inner join [HR_Data Pegawai] b 
                            on a.ID_Data  = b.ID_Data
                            inner join P_M_TIM c on c.ID = a.KD_TIM
                            WHERE KODE_TRANSAKSI=:lb_IdMOu AND FB_SPV=:iifSPV 
                            group by  b.Nama,a.ID_Data ");
            $this->db->bind('lb_IdMOu', $data['id']);
            $this->db->bind('iifSPV', $iifSPV);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['Nama'] = $key['Nama'];
                $pasing['ID_Data'] = $key['ID_Data'];
                $rows[] = $pasing;
                $array['getSPVbyKontrak'] = $rows; 
            }
            return $array;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getAllSPVbyMou($data)
    {
        try {
            $fbspv = "1";
            $this->db->query("SELECT c.ID as kodetim,c.NAMA_TIM  ,a.TIM_DESCRIPTION
                                FROM P_P_WBS_TIM a 
                                inner join P_M_TIM c on c.ID = a.KD_TIM
                                WHERE KODE_TRANSAKSI=:lb_IdMOu  and a.ID_Data=:kodespv and FB_SPV=:fbspv
                                group by  c.ID  ,c.NAMA_TIM  ,a.TIM_DESCRIPTION");
            $this->db->bind('lb_IdMOu', $data['lb_IdMOu']);
            $this->db->bind('kodespv', $data['kodespv']);
            $this->db->bind('fbspv', $fbspv);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID_Data'] = $key['kodetim'];
                $pasing['NAMA_TIM'] = $key['NAMA_TIM'];
                $pasing['TIM_DESCRIPTION'] = $key['TIM_DESCRIPTION'];
                $rows[] = $pasing;
                $array['getTeamBySPVbyKontrak'] = $rows; 
            }
            return $array;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getPersonelOtherTeam($data)
    {
        try {
            $fbspv = "1";
            $iifSPVNon="0";
            $this->db->query("SELECT a.ID as kodetim,c.NAMA_TIM  ,a.TIM_DESCRIPTION,a.ID_Data, d.Nama
                                FROM P_P_WBS_TIM a 
                                inner join P_M_TIM c on c.ID = a.KD_TIM
                                inner join [HR_Data Pegawai] d on d.ID_Data = a.ID_Data
                                WHERE KODE_TRANSAKSI=:idMOu and a.KD_TIM not in (
                                select KD_TIM from P_P_WBS_TIM  WHERE KODE_TRANSAKSI=:idMOu2
                                and ID_Data=:IDSpv and FB_SPV=:iifSPV
                                ) and a.FB_SPV=:iifSPVNon");
            $this->db->bind('idMOu', $data['lb_IdMOu']);
            $this->db->bind('idMOu2', $data['lb_IdMOu']);
            $this->db->bind('IDSpv', $data['lb_SPV']);
            $this->db->bind('iifSPV', $fbspv);
            $this->db->bind('iifSPVNon', $iifSPVNon);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID_Data'] = $key['kodetim'];
                $pasing['NAMA_TIM'] = $key['NAMA_TIM'];
                $pasing['Nama'] = $key['Nama'];
                $rows[] = $pasing;
                $array['getTeamBySPVbyKontrak'] = $rows; 
            }
            return $array;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function AddTempLBByIDByLuar($data)
    {
        try {
            $this->db->transaksi(); 
                $this->db->query("INSERT INTO _temp_LB_DETIL (KODE_LB,ID_Data,KD_TIM_AWAL,
                                    FB_SPV,TIM_DESCRIPTION,Date_Start,Date_End,NIP,Id_Tim_Reff,IsPermanen,KD_TIM_TUJUAN)
                                    SELECT :kdlbadd, a.ID_Data,KD_TIM,
                                    A.FB_SPV,A.TIM_DESCRIPTION,A.Time_Start,A.Time_End,a.Nip,:lb_fleksibel_timLuar2
                                    ,:Status,:lb_fleksibel_tim
                                    FROM P_P_WBS_TIM A
                                    INNER JOIN P_M_TIM B ON A.KD_TIM = B.ID
                                    inner join [HR_Data Pegawai] C ON C.ID_Data = A.ID_Data
                                    where  a.ID=:lb_fleksibel_timLuar");
            $this->db->bind('lb_fleksibel_timLuar', $data['lb_fleksibel_timLuar']);
            $this->db->bind('lb_fleksibel_timLuar2', $data['lb_fleksibel_timLuar']);
            $this->db->bind('kdlbadd', $data['kodeLB']);
            $this->db->bind('Status', $data['Status']);
            $this->db->bind('lb_fleksibel_tim', $data['lb_fleksibel_tim']);
            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function ShowlistTeamsBySPV($data)
    {
        try {
            $session = SessionManager::getCurrentSession();
            $useridRole = $session->role;
            $userlogin = $session->username;
            $batal  = "0";
            $this->db->query("SELECT a.id,a.KODE_LB KODE_TRANSAKSI,
                            a.ID_Data,C.Nama,a.Nip,a.TIM_DESCRIPTION,a.Date_Start Time_Start ,a.Date_End Time_End
                            ,b.NAMA_TIM,CASE WHEN a.FB_SPV='1' THEN 'SUPERVISOR' ELSE 'STAFF' END as StatusKaryawan
                            ,a.IsPermanen
                            FROM _temp_LB_DETIL A
                            INNER JOIN P_M_TIM B 
                            ON A.KD_TIM_AWAL = B.ID
                            inner join [HR_Data Pegawai] C ON C.ID_Data = A.ID_Data where  a.KODE_LB = :kodelb2");
            $this->db->bind('kodelb2',  $data['kodeLB']); 
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['id'] = $key['id'];
                $pasing['KODE_TRANSAKSI'] = $key['KODE_TRANSAKSI'];
                $pasing['ID_Data'] = $key['ID_Data'];
                $pasing['Nama'] = $key['Nama'];
                $pasing['Nip'] = $key['Nip'];
                $pasing['TIM_DESCRIPTION'] = $key['TIM_DESCRIPTION'];
                $pasing['Time_Start'] = $key['Time_Start'];
                $pasing['Time_End'] = $key['Time_End'];
                $pasing['NAMA_TIM'] = $key['NAMA_TIM'];
                $pasing['StatusKaryawan'] = $key['StatusKaryawan'];
                $pasing['IsPermanen'] = $key['IsPermanen'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function AddTempLBByID($data)
    {
        try {
            $this->db->transaksi();
            $this->db->query( "DELETE FROM _temp_LB_DETIL WHERE KODE_LB = :kodelb ");
            $this->db->bind('kodelb', $data['kodeLB']);
            $this->db->execute();

            $this->db->query("INSERT INTO _temp_LB_DETIL (KODE_LB,ID_Data,KD_TIM_AWAL,
                                FB_SPV,TIM_DESCRIPTION,Date_Start,Date_End,NIP)
                                SELECT :kdlbadd, a.ID_Data,KD_TIM,
                                A.FB_SPV,A.TIM_DESCRIPTION,A.Time_Start,A.Time_End,a.Nip
                                FROM P_P_WBS_TIM A
                                INNER JOIN P_M_TIM B ON A.KD_TIM = B.ID
                                inner join [HR_Data Pegawai] C ON C.ID_Data = A.ID_Data
                                where A.KODE_TRANSAKSI=:VerifwbS_Kodeadd and   KD_TIM=:kdtimadd");
            $this->db->bind('VerifwbS_Kodeadd', $data['IdMou']);
            $this->db->bind('kdtimadd', $data['lb_SPV']);
            $this->db->bind('kdlbadd', $data['kodeLB']); 
            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function genHdrLogBook($data)
    {
        try {
            $this->db->transaksi();

            if ($data['lb_tgl_logbook'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Tanggal Log Book Harus Diisi !',
                );
                return $callback;
                exit;
            }
            if ($data['lb_IdMOu'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan ID Kontrak !',
                );
               return $callback;
                exit;
            }
            if ($data['dr_Lokasi'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Kode JO !',
                );
                return $callback;
                exit;
            }
            if ($data['dr_kode_peg_SPV'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Kode Pegawai Supervisor !',
                );
                return $callback;
                exit;
            }
            $kodeRegAwal = "TLB";
            $formatDateJurnal = Utils::idtrsByDateOnly();
            $lb_tgl_logbook = $data['lb_tgl_logbook'];
            $dr_kode_peg_SPV = $data['dr_kode_peg_SPV'];
            $dr_Lokasi = $data['dr_Lokasi'];
            $lb_IdMOu = $data['lb_IdMOu'];
            $this->db->query("SELECT  TOP 1 KD_TRS,right(KD_TRS,3) as urutregx
                            FROM P_T_LB  WHERE  
                            SUBSTRING(KD_TRS,4,6)=:formatDateJurnal
                            AND LEFT(KD_TRS,3)=:kodeRegAwal ORDER BY KD_TRS DESC ");
            $this->db->bind('kodeRegAwal', $kodeRegAwal);
            $this->db->bind('formatDateJurnal', $formatDateJurnal);
            $data =  $this->db->single();  
            if($data){
                $no_reg =  $data['urutregx'];
                $idReg = $no_reg;
                $idReg++;
            }else{
                $idReg = '1';  
            }
            // GENERATE NO REGISTRASI
            $noUrutJurnal = Utils::generateAutoNumberFourDigit($idReg);
            $NoLoogBook = $kodeRegAwal . $formatDateJurnal . '-' . $noUrutJurnal;
            $datenowcreateFull = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession(); 
            $userlogin = $session->username;
            $this->db->query("INSERT INTO P_T_LB
                                (KD_TRS,TGL_ENTRY,PETUGAS_ENTRY,TGL_LOG_BOOK,
                                KD_PEG_SPV,KD_JO,KD_MOU) 
                                values
                                (:NoLoogBook,:datenowcreateFull,:userid,:lb_tgl_logbook,
                                :dr_kode_peg_SPV,:dr_Lokasi,:lb_IdMOu)");
            $this->db->bind('NoLoogBook', $NoLoogBook);
            $this->db->bind('datenowcreateFull', $datenowcreateFull);
            $this->db->bind('userid', $userlogin);
            $this->db->bind('lb_tgl_logbook', $lb_tgl_logbook);
            $this->db->bind('dr_kode_peg_SPV', $dr_kode_peg_SPV);
            $this->db->bind('dr_Lokasi', $dr_Lokasi);
            $this->db->bind('lb_IdMOu', $lb_IdMOu);
            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'NoTRS' => $NoLoogBook, // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function getWBSbyMouJo($data){
        try {
            $iifnull = "0";
            $groupID = "1";
            $qty = "0";
            $this->db->query("SELECT a.KODE_TRANSAKSI,b.ID,b.ID_MOU,b.ID_WBS,b.NM_WBS,a.KD_JO
                                FROM P_P_WBS_HDR A
                                INNER JOIN P_P_WBS_BOQ B 
                                ON A.KODE_TRANSAKSI = B.KODE_TRANSAKSI
                                where a.BATAL= :iifnull and a.KD_JO= :zlb_Lokasi  
                                and b.KODE_TRANSAKSI=:lb_IdMOu  and FB_GRUP=:groupID and qty > :qty
                                and b.NM_WBS like  '%' + :searchTerm  + '%' ");
            $this->db->bind('iifnull',  $iifnull);
            $this->db->bind('zlb_Lokasi',  $data['zlb_Lokasi']);
            $this->db->bind('lb_IdMOu',  $data['lb_IdMOu']);
            $this->db->bind('groupID',  $groupID);
            $this->db->bind('qty',  $qty);
            $this->db->bind('searchTerm',  $data['searchTerm']);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['id'] = $key['ID'];
                $pasing['text'] = $key['NM_WBS'];
                $data[] = $pasing;  
            }
            return $data;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function SaveAddtools($data)
    {
        try {
            $this->db->transaksi();
            $ep_lb_personel  = $data['ep_lb_personel'];

            $lb_IDTransaksi = $data['lb_IDTransaksi'];
            $lb_Lokasi =  $data['lb_Lokasi'];
            $lb_tgl_logbook =   $data['lb_tgl_logbook'];
            $lb_kode_wbsid =   $data['lb_kode_wbsid'];
            $ep_lb_kegiatan =   $data['ep_lb_kegiatan'];
            $ep_lb_timestart_jadwal =   $data['ep_lb_timestart_jadwal'];
            $ep_lb_timeend_jadwal =   $data['ep_lb_timeend_jadwal'];
            $ep_lb_timestart =  $data['ep_lb_timestart'];
            $ep_lb_timeend =   $data['ep_lb_timeend'];
            $lb_IdMOu = $data['lb_IdMOu'];
            $lb_spv = $data['lb_spv'];
            
            $IsPermanen = "1";
            $FB_LOCK = "1";
            $this->db->query("SELECT  b.Nama,a.ID_Data , c.NAMA_TIM,a.FB_SPV,a.IsPermanen
                    FROM _temp_LB_DETIL a
                    inner join [HR_Data Pegawai] b 
                    on a.ID_Data  = b.ID_Data
                    inner join P_M_TIM c on c.ID = a.KD_TIM_AWAL
                    WHERE KODE_LB=:lb_IDTransaksi");
            $this->db->bind('lb_IDTransaksi', $data['lb_IDTransaksi']);
            $data =  $this->db->resultSet();
            $rows = array(); 
            foreach ($data as $key) {
                $this->db->query("INSERT INTO P_T_LB_DETIL  (KD_TRS,KD_PEG , KODE_JO, TGL_LOG_BOOK
                                        ,ID_WBS,FS_KEGIATAN,TIME_START_JADWAL,TIME_END_JADWAL,
                                        TIME_START,TIME_END,FB_PINJAM)
                                        VALUES
                                        (:lb_IDTransaksi,:idpeg,:dr_Lokasi,:lb_tgl_logbook,:ID_WBS, :FS_KEGIATAN,
                                        :TIME_START_JADWAL,:TIME_END_JADWAL,:TIME_START ,:TIME_END,:IsPermanen) ");
                $this->db->bind('lb_IDTransaksi', $lb_IDTransaksi);
                $this->db->bind('idpeg', $key['ID_Data']);
                $this->db->bind('dr_Lokasi', $lb_Lokasi);
                $this->db->bind('lb_tgl_logbook', $lb_tgl_logbook);
                $this->db->bind('ID_WBS', $lb_kode_wbsid);
                $this->db->bind('FS_KEGIATAN', $ep_lb_kegiatan);
                $this->db->bind('IsPermanen', $key['IsPermanen']);
                $this->db->bind('TIME_START_JADWAL', $ep_lb_timestart_jadwal);
                $this->db->bind('TIME_END_JADWAL', $ep_lb_timeend_jadwal);
                $this->db->bind('TIME_START', $ep_lb_timestart);
                $this->db->bind('TIME_END', $ep_lb_timeend);
                $this->db->execute();
            }

            $this->db->query("SELECT    b.Nama,a.ID_Data , c.NAMA_TIM,a.FB_SPV,a.KD_TIM_TUJUAN,
                    a.TIM_DESCRIPTION,A.NIP,A.Date_start,a.Date_End,A.Id_Tim_reff
                    FROM _temp_LB_DETIL a
                    inner join [HR_Data Pegawai] b 
                    on a.ID_Data  = b.ID_Data
                    inner join P_M_TIM c on c.ID = a.KD_TIM_AWAL
                    WHERE KODE_LB=:lb_IDTransaksi and IsPermanen=:IsPermanen ");
            $this->db->bind('IsPermanen', $IsPermanen);
            $this->db->bind('lb_IDTransaksi', $lb_IDTransaksi);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $row) {
                $this->db->query("INSERT INTO P_P_WBS_TIM (KODE_TRANSAKSI,ID_Data,Nip,
                                    FB_SPV,KD_TIM,Time_Start,Time_End,TIM_DESCRIPTION)
                                    values
                                    (:aKODE_TRANSAKSI,:aID_Data,:aNip,
                                    :aFB_SPV,:aKD_TIM,:aTime_Start,:aTime_End,:aTIM_DESCRIPTION) "); 

                $this->db->bind('aKODE_TRANSAKSI', $lb_IdMOu);
                $this->db->bind('aID_Data', $row['ID_Data']);
                $this->db->bind('aNip', $row['NIP']);
                $this->db->bind('aFB_SPV', $row['ID_Data']);
                $this->db->bind('aKD_TIM', $lb_spv);
                $this->db->bind('aTime_Start', $row['Date_start']);
                $this->db->bind('aTime_End', $row['Date_End']);
                $this->db->bind('aTIM_DESCRIPTION', $row['TIM_DESCRIPTION']);
                $this->db->execute();

                $this->db->query("DELETE P_P_WBS_TIM  where ID=:Id_Tim_reff  ");
                $this->db->bind('Id_Tim_reff', $row['Id_Tim_reff']);
                $this->db->execute();
            }

            $this->db->query("UPDATE P_T_LB SET ID_WBS=:lb_kode_wbsid, FS_KEGIATAN=:ep_lb_kegiatan
                            ,TIME_START=:ep_lb_timestart, TIME_END=:ep_lb_timeend ,
                            TGL_LOG_BOOK=:lb_tgl_logbook , KD_TIM=:KD_TIMX,FB_LOCK=:FB_LOCK,
                            TIME_START_JADWAL=:TIME_START_JADWAL,TIME_END_JADWAL=:TIME_END_JADWAL
                            where KD_TRS=:lb_IDTransaksi");

            $this->db->bind('lb_kode_wbsid', $lb_kode_wbsid);
            $this->db->bind('ep_lb_kegiatan', $ep_lb_kegiatan);
            $this->db->bind('ep_lb_timestart', $ep_lb_timestart);
            $this->db->bind('ep_lb_timeend', $ep_lb_timeend);
            $this->db->bind('lb_tgl_logbook', $lb_tgl_logbook);
            $this->db->bind('lb_IDTransaksi', $lb_IDTransaksi);
            $this->db->bind('KD_TIMX', $lb_spv);
            $this->db->bind('TIME_START_JADWAL', $ep_lb_timestart_jadwal);
            $this->db->bind('TIME_END_JADWAL', $ep_lb_timeend_jadwal);
            $this->db->bind('FB_LOCK', $FB_LOCK);
            $this->db->execute();


            
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success     
                'notrs' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success    
            );
            return $callback;

        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getEntrylogBookHistory($data)
    {
        try {
            $session = SessionManager::getCurrentSession();
            $useridRole = $session->role;
            $userlogin = $session->username;
            $batal  = "0";
            $this->db->query("SELECT  D.NAMA_TIM,g.FS_KEGIATAN,A.ID_WBS,b.NM_WBS
                            ,a.TIME_START,a.TIME_END  ,g.TIME_START_JADWAL,g.TIME_END_JADWAL
                            from P_T_LB_DETIL g
                            inner join P_T_LB a ON A.KD_TRS = G.KD_TRS
                            INNER JOIN P_P_WBS_BOQ B
                            ON g.ID_WBS = B.ID
                            INNER JOIN P_P_WBS_HDR C
                            ON C.KODE_TRANSAKSI  = B.KODE_TRANSAKSI 
                            inner join P_M_TIM D 
                            ON D.ID = A.KD_TIM
                            WHERE A.BATAL=:abatal AND c.BATAL=:cbatal  and g.BATAL=:gbatal
                            and a.KD_TRS<>:lb_IDTransaksi
                            and  replace(CONVERT(VARCHAR(11),a.TGL_LOG_BOOK, 111), '/','-')  =:lb_tgl_logbook
                            group by  A.ID,A.KD_TRS,A.KD_JO,A.FS_REFF_PEGAWAI,g.FS_KEGIATAN,A.ID_WBS,b.NM_WBS
                            ,a.TIME_START,a.TIME_END  ,D.NAMA_TIM,g.TIME_START_JADWAL,g.TIME_END_JADWAL
                            order by D.NAMA_TIM asc,  a.TIME_START asc");
            $this->db->bind('lb_tgl_logbook',  $data['lb_tgl_logbook']);
            $this->db->bind('lb_IDTransaksi',  $data['lb_IDTransaksi']);
            $this->db->bind('abatal',  $batal);
            $this->db->bind('cbatal',  $batal);
            $this->db->bind('gbatal',  $batal);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['NAMA_TIM'] = $key['NAMA_TIM'];
                $pasing['FS_KEGIATAN'] = $key['FS_KEGIATAN'];
                $pasing['NM_WBS'] = $key['NM_WBS'];
                $pasing['TIME_START'] = $key['TIME_START'];
                $pasing['TIME_END'] = $key['TIME_END'];
                $pasing['TIME_START_JADWAL'] = $key['TIME_START_JADWAL'];
                $pasing['TIME_END_JADWAL'] = $key['TIME_END_JADWAL'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function finishLogBookTrs($data)
    {
        try {
            $this->db->transaksi();
            $lb_IDTransaksi = $data['lb_IDTransaksi'];
            if ($lb_IDTransaksi == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode Transaksi Log Book Invalid !',
                );
                return $callback;
                exit;
            } 
                $this->db->query("DELETE _temp_LB_DETIL  where KODE_LB=:lb_IDTransaksi ");
                $this->db->bind('lb_IDTransaksi', $lb_IDTransaksi); 
                $this->db->execute();
                $this->db->commit();
                $callback = array(
                    'status' => 'success', // Set array status dengan success     
                    'notrs' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success    
                );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function delTempLBByID($data)
    {
        try {
            $this->db->transaksi();
            $idTemp = $data['q'];
            $kodeLB = $data['kodeLB'];
            if ($idTemp == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Id Tim Invalid !',
                );
                return $callback;
                exit;
            }
            if ($kodeLB == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Id Log Book Invalid !',
                );
                return $callback;
                exit;
            }
            // Tentuin row
            $FB_LOCK = "1";
            $this->db->query("SELECT KD_TRS FROM P_T_LB WHERE KD_TRS=:kodeLB AND FB_LOCK=:FB_LOCK");
            $this->db->bind('FB_LOCK', $FB_LOCK);
            $this->db->bind('kodeLB', $kodeLB);
            $this->db->execute(); 
            $CountCol = $this->db->rowCount(); 
            if ($CountCol) {
                $callback = array(
                    'status' => 'warning',  
                    'errorname' => 'Status Transaksi Sudah Ada Kegiatan yang Entry, Hapus Data Pegawai dibatalkan !',
                );
                return $callback; 
                exit;
            } else {
                $this->db->query("DELETE _temp_LB_DETIL  where ID=:idTemp ");
                $this->db->bind('idTemp', $idTemp);
                $this->db->execute();
            }
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success     
                'notrs' => 'Transkasi Berhasil DiHapus !', // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function DeleteLogBookdetil($data)
    {
        try {
            $this->db->transaksi();
            $JM_ID = $data['ID_logNookDel'];
            $alasan = $data['alasan_delLogbook'];

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
            $batal = '1';
                $this->db->query("UPDATE P_T_LB_DETIL SET BATAL=:batal ,ALASAN=:alasan
                            where ID=:JM_ID");
                $this->db->bind('JM_ID', $JM_ID);
                $this->db->bind('batal', $batal);
                $this->db->bind('alasan', $alasan);
                $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success     
                'notrs' => 'Transkasi Berhasil DiHapus !', // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function showLogBookCurrentDate($data)
    {
        try {
            $session = SessionManager::getCurrentSession();
            $useridRole = $session->role;
            $userlogin = $session->username;
            $batal  = "0";
            $this->db->query("SELECT a.ID,KD_TRS,a.KD_JO,a.KD_MOU,a.FS_REFF_PEGAWAI,a.FS_KEGIATAN,a.TIME_START,a.TIME_END,
                            CONVERT(VARCHAR(11),a.TGL_LOG_BOOK, 111) TGL_LOG_BOOK,D.Nama  AS SPVName
                            FROM P_T_LB  a
                            INNER JOIN [HR_Data Pegawai] D ON D.ID_Data = A.KD_PEG_SPV
                            where 
                            replace(CONVERT(VARCHAR(11),a.TGL_LOG_BOOK, 111), '/','-') 
                            between :SrcLbDate1 and :SrcLbDate2 AND a.BATAL='0' ");
            $this->db->bind('SrcLbDate1',  $data['SrcLbDate1']);
            $this->db->bind('SrcLbDate2',  $data['SrcLbDate1']); 
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['KD_TRS'] = $key['KD_TRS'];
                $pasing['KD_JO'] = $key['KD_JO'];
                $pasing['FS_REFF_PEGAWAI'] = $key['FS_REFF_PEGAWAI'];
                $pasing['FS_KEGIATAN'] = $key['FS_KEGIATAN'];
                $pasing['TIME_START'] = $key['TIME_START'];
                $pasing['TIME_END'] = $key['TIME_END'];
                $pasing['TGL_LOG_BOOK'] = $key['TGL_LOG_BOOK'];
                $pasing['KD_MOU'] = $key['KD_MOU'];
                $pasing['SPVName'] = $key['SPVName'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function ShowDataTRsLogBookbyID($data)
    {
        try {
            $this->db->query("SELECT ID,KD_TRS,KD_JO,KD_MOU,FS_REFF_PEGAWAI,FS_KEGIATAN,TIME_START,TIME_END,
                CONVERT(VARCHAR(11),TGL_LOG_BOOK, 111) TGL_LOG_BOOK,KD_PEG_SPV,KD_TIM FROM P_T_LB  
                where KD_TRS = :params ");
            $this->db->bind('params', $data['q']);
            $data =  $this->db->single();
            $pasing['KD_TRS'] = $data['KD_TRS'];
            $pasing['KD_JO'] = $data['KD_JO'];
            $pasing['KD_MOU'] = $data['KD_MOU'];
            $pasing['KD_PEG_SPV'] = $data['KD_PEG_SPV'];
            $pasing['KD_TIM'] = $data['KD_TIM']; 
            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function DeleteLogBookTransaction($data)
    {
        
        try {
            $this->db->transaksi();
            $lb_IDTransaksi = $data['lb_IDTransaksi'];
            $batalLogbook = "1";
            $datenowcreateFull = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;

            if ($lb_IDTransaksi == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode Invalid !',
                );
                return $callback;
                exit;
            }

            $this->db->query("UPDATE P_T_LB SET BATAL=:batalLogbook, PETUGAS_BATAL=:userid, TGL_BATAL=:datenowcreateFull
                            WHERE KD_TRS=:lb_IDTransaksi");
            $this->db->bind('batalLogbook', $batalLogbook);
            $this->db->bind('userid', $userid);
            $this->db->bind('datenowcreateFull', $datenowcreateFull);
            $this->db->bind('lb_IDTransaksi', $lb_IDTransaksi);
            $this->db->execute(); 
            
            $this->db->query(" UPDATE P_T_LB_DETIL SET BATAL=:batalLogbook 
                                WHERE KD_TRS=:lb_IDTransaksi");
            $this->db->bind('lb_IDTransaksi', $lb_IDTransaksi);
            $this->db->bind('batalLogbook', $batalLogbook); 
            $this->db->execute(); 
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success
                'message' => 'Data Berhasil dihapus !',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            return $e;
            exit;
        }
    }
}