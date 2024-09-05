<?php
class B_Cuti_Dokter_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllCutiDokter()
    {
        try {
            // $this->db->query("SELECT ID,periode_awal,periode_akhir,keterangan 
            //                     from MasterdataSQL.dbo.TR_CUTI_DOKTER 
            //                     where batal='0'");
            $this->db->query(" SELECT a.ID,periode_awal,periode_akhir,keterangan ,b.First_Name as NamaDokter
                                from MasterdataSQL.dbo.TR_CUTI_DOKTER  a
                                inner join MasterdataSQL.dbo.Doctors b on a.id_dokter=b.ID
                                where batal='0'");
           
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['periode_awal'] = $key['periode_awal'];
                $pasing['periode_akhir'] = $key['periode_akhir'];
                $pasing['keterangan'] = $key['keterangan']; 
                $pasing['NamaDokter'] = $key['NamaDokter']; 
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getAllMasterCutiDokter()
    {
        try {
            $this->db->query("SELECT id_jenis_cuti,nama_jenis_cuti from MasterdataSQL.dbo.JENIS_CUTI"); 
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['id_jenis_cuti'];
                $pasing['nama_jenis_cuti'] = $key['nama_jenis_cuti'];
                $rows[] = $pasing;
            }
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $rows
            );
            return $callback;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function getDataDokterbyPoliklinikID($id)
    {
        try {
            $this->db->query("SELECT a.ID, a.First_Name, a.GroupPerawatan,b.NamaUnit
                            FROM MasterdataSQL.dbo.Doctors a
                            inner join MasterdataSQL.dbo.MstrUnitPerwatan b
                            on a.GroupPerawatan = b.ID
                            where a.GroupPerawatan=:idPoliklinik and a.active='1'");
            $this->db->bind('idPoliklinik', $id);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['First_Name'] = $key['First_Name'];
                $rows[] = $pasing;
            }
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $rows
            );
            return $callback;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    // INSERT
    public function insert($data)
    {
        try {
            $this->db->transaksi();
            if ($data['NamaPoliklinik'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Pilih Poliklinik !',
                );
                return $callback;
                exit;
            }
            if ($data['NamaDokter'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Pilih Dokter !',
                );
                return $callback;
                exit;
            }
            
            if ($data['JenisCuti'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Pilih Jenis Cuti !',
                );
                return $callback;
                exit;
            }
            if ($data['TglAwal'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Tanggal Awal !',
                );
                return $callback;
                exit;
            }
            if ($data['TglAkhir'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Tanggal Akhir !',
                );
                return $callback;
                exit;
            }
            if ($data['note'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Catatan Cuti !',
                );
                return $callback;
                exit;
            }
            $IdAuto = $data['IdAuto'];
            $NamaPoliklinik = $data['NamaPoliklinik'];
            $NamaDokter = $data['NamaDokter'];
            $NamaDokterFull = $data['NamaDokterFull'];
            $NamaDokter = $data['NamaDokter'];
            $NamaFullPoli = $data['NamaFullPoli'];
            $JenisCuti = $data['JenisCuti'];
            $TglAkhir = $data['TglAkhir'];
            $TglAwal = $data['TglAwal'];
            $note = $data['note'];
            $datex = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $useridRole = $session->role;
            $userid = $session->username; 


            if ($data['IdAuto'] == "") {

                $this->db->query("INSERT INTO MasterdataSQL.dbo.TR_CUTI_DOKTER 
                                (id_dokter,id_poli,periode_awal,periode_akhir,
                                keterangan,id_jenis_cuti,User_Input,Tgl_Input) 
                                VALUES 
                                (:NamaDokter,:NamaPoliklinik,:TglAwal,:TglAkhir,
                                :note,:JenisCuti,:userid,:datex)");
                $this->db->bind('NamaPoliklinik', $NamaPoliklinik);
                $this->db->bind('NamaDokter', $NamaDokter);
                $this->db->bind('TglAwal', $TglAwal);
                $this->db->bind('TglAkhir', $TglAkhir);
                $this->db->bind('note', $note);
                $this->db->bind('JenisCuti', $JenisCuti);
                $this->db->bind('userid', $userid);
                $this->db->bind('datex', $datex);
            } else {
                $this->db->query("UPDATE MasterdataSQL.dbo.TR_CUTI_DOKTER 
                            set  
                            id_dokter=:NamaDokter,id_poli=:NamaPoliklinik,periode_awal=:TglAwal,
                            periode_akhir=:TglAkhir,keterangan=:note,id_jenis_cuti=:JenisCuti,User_Edit=:userid,Tgl_Edit=:datex
                            WHERE ID=:IdAuto");
                $this->db->bind('NamaPoliklinik', $NamaPoliklinik);
                $this->db->bind('NamaDokter', $NamaDokter);
                $this->db->bind('TglAwal', $TglAwal);
                $this->db->bind('TglAkhir', $TglAkhir);
                $this->db->bind('note', $note);
                $this->db->bind('JenisCuti', $JenisCuti);
                $this->db->bind('userid', $userid);
                $this->db->bind('datex', $datex);
                $this->db->bind('IdAuto', $IdAuto);
            }

            $data = $this->sendNotifWebsite($NamaDokterFull, $NamaFullPoli,$TglAwal,$TglAkhir,$note);
            $this->sendFirebase($NamaDokterFull, $NamaFullPoli,$TglAwal,$TglAkhir,$note);
            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success    
                'data' => $data
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function getDataDetilTransaksiCuti($id)
    {

        try {
            $this->db->query("SELECT replace(CONVERT(VARCHAR(11),periode_awal, 111), '/','-') as periode_awalx ,
                                replace(CONVERT(VARCHAR(11),periode_akhir, 111), '/','-') as periode_akhirx ,
                                *from MasterdataSQL.dbo.TR_CUTI_DOKTER where id=:id");
            $this->db->bind('id', $id);
            $data =  $this->db->single();
            $pasing['ID'] = $data['id'];
            $pasing['id_dokter'] = $data['id_dokter'];
            $pasing['id_poli'] = $data['id_poli'];
            $pasing['periode_awalx'] = $data['periode_awalx'];
            $pasing['periode_akhirx'] = $data['periode_akhirx'];
            $pasing['keterangan'] = $data['keterangan'];
            $pasing['id_jenis_cuti'] = $data['id_jenis_cuti'];
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function sendNotifWebsite($NamaDokter, $NamaPoliklinik,$TglAwal,$TglAkhir,$note){
        
        $curl = curl_init();
        $title = "Informasi Dokter Cuti";
        $body = $NamaPoliklinik." - " . $NamaDokter . " Sedang Cuti. Tanggal : " . date("d-m-Y",strtotime($TglAwal))  . " sd " . date("d-m-Y",strtotime($TglAkhir))  . " Bagi Anda yang sudah terdaftar pada hari tersebut. di Mohon Konfirmasi ke RS YARSI untuk di lakukan perubahan Jadwal."; 
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apimobile.rsyarsi.co.id/api/addNotifications',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_SSL_VERIFYHOST => FALSE,
            CURLOPT_SSL_VERIFYPEER => FALSE, 
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "Id_User" : "",
                "Title" : "'.$title.'",
                "Body" : "'.$body.'",
                "ReadData" : 1,
                "Flag" : 1
            }',
          CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczpcL1wvYXBpbW9iaWxlLnJzeWFyc2kuY28uaWRcL2FwaVwvbG9naW4iLCJpYXQiOjE2NjA3Mjk0MjMsIm5iZiI6MTY2MDcyOTQyMywianRpIjoiZ3I4QXNvWE5TSHpKaDBYRiIsInN1YiI6MSwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.mjd72IQKuAlK8NR9uUhPxcJUO_7WOOsoBq_QKCTp05s'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }
    public function sendFirebase($NamaDokter, $NamaPoliklinik,$TglAwal,$TglAkhir,$note){
        
        $curl = curl_init();
        $title = "Informasi Dokter Cuti";
        $body = $NamaPoliklinik." - " . $NamaDokter . "Sedang Cuti. Tanggal : " . date("d-m-Y",strtotime($TglAwal))  . " sd " . date("d-m-Y",strtotime($TglAkhir))  . " Bagi Anda yang sudah terdaftar pada hari tersebut. di Mohon Konfirmasi ke RS YARSI untuk di lakukan perubahan Jadwal."; 
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_SSL_VERIFYHOST => FALSE,
            CURLOPT_SSL_VERIFYPEER => FALSE, 
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
            "to":
            "/topics/tester",
            "data":{
                "extra_information": "'.$title.'"
            },
            "notification" : {
              "title" : "'.$title.'",
              "body" : "'.$body.'"
               
            }
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-type: application/json',
            'Authorization: key=AAAAWSFUTsk:APA91bF3Gwttu-sgQIwXPYzArbRzOgzkx8JKKIj2RsdQMDf0aONGJ-ZfWSf5WwkLkTf7V701uvgTlLsThb-FocQwBp8OOUlV2wF7hRfoyqi399mFYzGJBSk27lu3UhOJ8q48OJICVVrB'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
    }
}
