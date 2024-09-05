<?php


class JobOrder_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllJobOrder()
    {
        try {
            $this->db->query("SELECT *FROM GUT.dbo.P_M_LOKASI");
            return $this->db->resultSet();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function insert($data)
    {

        if ($data['Mst_NamaClient'] == "") {
            $callback = array(
                'status' => 'warning',  'errorname' => 'Silahkan Input Nama Client !',
            );
            return $callback;
            exit;
        }

        if ($data['Mst_UMK'] == "") {
            $callback = array(
                'status' => 'warning',  'errorname' => 'Silahkan Input UMK !',
            );
            return $callback;
            exit;
        }

        if ($data['Mst_NamaProject'] == "") {
            $callback = array(
                'status' => 'warning',  'errorname' => 'Silahkan Input Nama Project !',
            );
            return $callback;
            exit;
        }
        if ($data['Mst_Kegiatan'] == "") {
            $callback = array(
                'status' => 'warning',  'errorname' => 'Silahkan Input Nama Kegiatan !',
            );
            return $callback;
            exit;
        } 

        $userid = "asd";
        //date_default_timezone_set('Asia/Jakarta');
        $tgl_input = Utils::seCurrentDateTime();

        try {
            $this->db->transaksi();
            if ($data['IdTranasksiAuto'] == "") {
                $this->db->query("INSERT into P_M_LOKASI(KD_LOKASI, NM_LOKASI, KD_GRUP_LOKASI, 
                                UMK_LOKASI,NM_CLIENT,ALAMAT,NM_PROJECT,NM_KEGIATAN) 
                                values(:IdTranasksi,:Mst_NamaLokasi,:Mst_KdGroup, 
                                :Mst_UMK,:Mst_NamaClient,:Mst_Alamat,:Mst_NamaProject,:Mst_Kegiatan)");
                $this->db->bind('IdTranasksi', $data['IdTranasksi']);
                $this->db->bind('Mst_NamaLokasi', $data['Mst_NamaLokasi']);
                $this->db->bind('Mst_KdGroup', $data['Mst_KdGroup']);
                $this->db->bind('Mst_UMK', $data['Mst_UMK']);
                $this->db->bind('Mst_NamaClient', $data['Mst_NamaClient']);
                $this->db->bind('Mst_Alamat', $data['Mst_Alamat']);
                $this->db->bind('Mst_NamaProject', $data['Mst_NamaProject']);
                $this->db->bind('Mst_Kegiatan', $data['Mst_Kegiatan']);
            } else {
                $this->db->query("UPDATE P_M_LOKASI SET KD_LOKASI = :IdTranasksi, 
                                    NM_LOKASI = :Mst_NamaLokasi, KD_GRUP_LOKASI = :Mst_KdGroup, 
                                    UMK_LOKASI = :Mst_UMK, NM_CLIENT = :Mst_NamaClient,ALAMAT = :Mst_Alamat ,
                                    NM_PROJECT = :Mst_NamaProject,NM_KEGIATAN = :Mst_Kegiatan
                                    WHERE ID = :IdTranasksiAuto ");
                $this->db->bind('IdTranasksi', $data['IdTranasksi']);
                $this->db->bind('Mst_NamaLokasi', $data['Mst_NamaLokasi']);
                $this->db->bind('Mst_KdGroup', $data['Mst_KdGroup']);
                $this->db->bind('Mst_UMK', $data['Mst_UMK']);
                $this->db->bind('Mst_NamaClient', $data['Mst_NamaClient']);
                $this->db->bind('Mst_Alamat', $data['Mst_Alamat']);
                $this->db->bind('Mst_NamaProject', $data['Mst_NamaProject']);
                $this->db->bind('Mst_Kegiatan', $data['Mst_Kegiatan']);
                $this->db->bind('IdTranasksiAuto', $data['IdTranasksiAuto']);
            }
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
    public function getJobOrderById($id)
    {
        $this->db->query('SELECT *FROM GUT.dbo.P_M_LOKASI where ID = :id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }
    public function getAllJobOrderbyHakAkses()
    {
        try {
            $session = SessionManager::getCurrentSession();
            $useridRole = $session->role;
            $userlogin = $session->username; 
            if($useridRole =="1"){
                $this->db->query("SELECT KD_LOKASI,NM_LOKASI,NM_CLIENT,KD_LOKASI
                              FROM P_M_LOKASI ");
                $data =  $this->db->resultSet();
                $rows = array();
                $array = array();
                foreach ($data as $key) {
                    $pasing['ID_Data'] = $key['KD_LOKASI'];
                    $pasing['NM_LOKASI'] = $key['NM_LOKASI'];
                    $pasing['NM_CLIENT'] = $key['NM_CLIENT'];
                    $pasing['KD_LOKASI'] = $key['KD_LOKASI'];
                    $rows[] = $pasing;
                    $array['dataJoAll'] = $rows;
                }
                return $array;     
            }else{
                $session = SessionManager::getCurrentSession();
                $useridRole = $session->role;
                $userlogin = $session->username;
                $this->db->query("SELECT A.id,b.KD_LOKASI,B.NM_LOKASI,b.NM_CLIENT,B.KD_LOKASI 
                              FROM A_Login_User_JO a
                              INNER JOIN P_M_LOKASI B
                              ON A.kode_lokasi=B.KD_LOKASI 
                              INNER JOIN A_Login_User C 
							  ON C.ID = A.user_id
                              WHERE C.Username= ?  ");
                $this->db->bind(1, $userlogin);
                $data =  $this->db->resultSet();
                $rows = array();
                $array = array();
                foreach ($data as $key) {
                    $pasing['ID_Data'] = $key['KD_LOKASI'];
                    $pasing['NM_LOKASI'] = $key['NM_LOKASI'];
                    $pasing['NM_CLIENT'] = $key['NM_CLIENT'];
                    $pasing['KD_LOKASI'] = $key['KD_LOKASI'];
                    $rows[] = $pasing;
                    $array['dataJoAll'] = $rows;
                }
                return $array;     
            }
            
            
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDataJobyId($id)
    {
        try {
            $this->db->query("SELECT ID,KD_LOKASI,KD_GRUP_LOKASI,NM_LOKASI,
                            NM_CLIENT,ALAMAT,NM_PROJECT,NM_KEGIATAN
                            FROM P_M_LOKASI
                            WHERE KD_LOKASI = :id ");
            $this->db->bind('id', $id);
            $data =  $this->db->single();
                $pasing['ID'] = $data['ID'];
                $pasing['KD_LOKASI'] = $data['KD_LOKASI'];
                $pasing['KD_GRUP_LOKASI'] = $data['KD_GRUP_LOKASI'];
                $pasing['NM_LOKASI'] = $data['NM_LOKASI'];
                $pasing['NM_CLIENT'] = $data['NM_CLIENT'];
                $pasing['ALAMAT'] = $data['ALAMAT'];
                $pasing['NM_PROJECT'] = $data['NM_PROJECT'];
                $pasing['NM_KEGIATAN'] = $data['NM_KEGIATAN'];
            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDataMouAktif()
    {
        try {
            $session = SessionManager::getCurrentSession();
            $useridRole = $session->role;
            $userlogin = $session->username;
            $iifBatal  = "0";
                $this->db->query("SELECT KD_JO,ID,ID_MOU,KODE_TRANSAKSI,NM_PROJECT,LOKASI_KERJA,
                                replace(CONVERT(VARCHAR(11), DATE_START, 111), '/','-') DATE_START,
                                replace(CONVERT(VARCHAR(11), DATE_END, 111), '/','-')  DATE_END,FN_DURASI,KD_JO
                                FROM P_P_WBS_HDR where BATAL= ? ");
                $this->db->bind(1, $iifBatal);
                $data =  $this->db->resultSet();
                $rows = array();
                $array = array();
                foreach ($data as $key) {
                    $pasing['KODE_TRANSAKSI'] = $key['KODE_TRANSAKSI'];
                    $pasing['NM_PROJECT'] = $key['NM_PROJECT'];
                    $pasing['ID_MOU'] = $key['ID_MOU'];
                    $pasing['KD_JO'] = $key['KD_JO'];
                    $rows[] = $pasing;
                    $array['getMou'] = $rows; 
                }
                return $array;
             
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
