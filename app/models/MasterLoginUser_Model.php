<?php

use \Ramsey\Uiid\Uuid;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;

class MasterLoginUser_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getAllUserLogin($data)
    {
        try {
            $this->db->query("SELECT ID,NoPIN as Username,[First Name] as NamaLengkap, 
                            CASE WHEN Administrator='1' THEN 'YA' ELSE 'TIDAK' END AS IsAdmin
                            FROM MasterdataSQL.DBO.Employees order by ID desc"); 
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = "1";
            foreach ($data as $key) {
                $pasing['Username'] = $key['Username'];
                $pasing['NamaLengkap'] = $key['NamaLengkap'];
                $pasing['ID'] = $key['ID'];
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    //edit badrul
    
    public function getDatapegawaiTTD($data)
    {

        try {
            $IDs = $data['id'];
            $this->db->query("SELECT ID, NoPIN, username, TTD_Pegawai 
                            FROM MasterdataSQL.dbo.Employees where ID=:ID_Data ");
                            $this->db->bind('ID_Data', $IDs);
                            $data =  $this->db->single();
                            // $six_digit_random_number = random_int(100000, 999999);
            $callback = array(
                'status' => 'success', // Set array status dengan success    
                'ID' => $data['ID'], // Set array status dengan success    
                'NoPIN' => $data['NoPIN'], // Set array status dengan success 
                'username' => $data['username'], // Set array status dengan success
                'TTD_Pegawai' => $data['TTD_Pegawai'] // Set array status dengan success 
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->closeCon();
            die($e->getMessage());
        }
    }  
    public function sendotpVerifikasiSign($data){
            $pinTTD = $data['Mst_PinTTD'];
            $Mst_Username = $data['Mst_Username'];
            if ($pinTTD == "") {
                $callback = array(
                    'status' => 'warning',
                    'message' => 'Masukkan data Pin TTD !'
                );
                return $callback;
                exit;
            }

            $this->db->query("SELECT TTD_Pegawai,Verified_PIN,Otp_Pin_verified ,
                                ID, [First Name] as NamaLengkap , NoPIN as Username,Administrator , BatalTransaksi,
                                [Mobile Phone] AS NoHp 
                                FROM MasterdataSQL.dbo.Employees where TTD_Pegawai=:TTD_Pegawai and  NoPIN <> :username");
            $this->db->bind('TTD_Pegawai', $pinTTD);
            $this->db->bind('username', $Mst_Username);
            $datax =  $this->db->single();
            $cek = $datax['TTD_Pegawai']; 
            if ($cek!=null) {
                $callback = array(
                    'status' => 'warning',
                    'message' => 'No PIN Sudah Terpakai !'
                );
                return $callback;
                exit;
            }

            $this->db->query("SELECT TTD_Pegawai,Verified_PIN,Otp_Pin_verified ,
            ID, [First Name] as NamaLengkap , NoPIN as Username,Administrator , BatalTransaksi,
            [Mobile Phone] AS NoHp 
            FROM MasterdataSQL.dbo.Employees where   NoPIN = :username"); 
            $this->db->bind('username', $Mst_Username);
            $dataUser =  $this->db->single();
            $cek = $datax['TTD_Pegawai']; 

           
           
            if($dataUser["NoHp"] == null || $dataUser["NoHp"] == ""){
                $callback = array(
                    'status' => 'warning', // Set array status dengan success   
                    'errorname' => 'Nomor Handphone Kosong !',
                );
                return $callback;
        }

        try {
            $this->db->transaksi();
            $replacenumberhp = Utils::hp($dataUser["NoHp"]);
            $six_digit_random_number = Utils::genOTP();
            $this->db->query("  UPDATE MasterdataSQL.DBO.Employees SET Otp_Pin_verified=:six_digit_random_number,Verified_PIN='0'
                                WHERE NoPin=:Mst_Username"); 
                            $this->db->bind('six_digit_random_number', $six_digit_random_number);
                            $this->db->bind('Mst_Username', $Mst_Username);
                            $this->db->execute();

            $sukses = $this->db->Commit();

            if($sukses){
                $gettoken = $this->getTokenWapin(); 
                $sendwa = $this->sendOTPWapin($gettoken, $replacenumberhp, $six_digit_random_number);
                                
                $JsonData = json_encode($sendwa);
                $convert = json_decode($JsonData,TRUE);
                $callback = array(
                    'status' => 'success', // Set array status dengan success   
                    'errorname' => 'Silahkan Verifikasi Otp Anda !', // Set array status dengan success    
                );
                return $callback;
            }else{
                            $callback = array(
                                'status' => 'warning', // Set array status dengan success   
                                'errorname' => 'Failed !', // Set array status dengan success    
                            );
                            return $callback;
            }

        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }

    }
    public function getverifiedOtpSign($data){
        try {
            $this->db->transaksi();
            $NoOTP = $data['Mst_PinTTD'];
            $UserId = $data['Mst_Username'];
            $otp_verify  = $data['otp_verify'];
            if ($data['Mst_Username'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Username !',
                );
                return $callback;
                exit;
            }
            if ($data['Mst_PinTTD'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Kode OTP !',
                );
                return $callback;
                exit;
            }
            if ($data['otp_verify'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Masukan Kode OTP Verifikasi!',
                );
                return $callback;
                exit;
            }
            $this->db->query("SELECT KODE_OTP,ID, [First Name] as NamaLengkap , NoPIN as Username,Administrator , BatalTransaksi,
                                [Mobile Phone] AS NoHp , Verified_PIN, Otp_Pin_verified
                                FROM MasterdataSQL.DBO.Employees 
                                where NoPIN=:UserId"); 
            $this->db->bind('UserId', $UserId);
            $this->db->execute();
            $row = $this->db->single();
            if($row){
                if($row['Otp_Pin_verified'] == $otp_verify ){
                    $getdatenowx = Utils::seCurrentDateTime();
                    $encodedSignature = Utils::encryptBase64($getdatenowx); 
                     
                    $this->db->query("  UPDATE MasterdataSQL.DBO.Employees SET Verified_PIN='1'
                    WHERE NoPin=:UserId");
                    $this->db->bind('UserId', $UserId); 
                    $this->db->execute();
                        $this->db->commit();

                        $callback = array(
                            'status' => 'success', // Set array status dengan success   
                            'message' => 'Verifikasi Berhasil !', // Set array status dengan success    
                        );
                        return $callback;
                     
                }else{
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Kode OTP Invalid !',
                    );
                }
            }else{
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode OTP Tidak Ditemukan !',
                );
            }
             
            
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'errorname' => $e
            );
            return $callback;
        }
    }
    public function getTokenWapin(){ 
        $curl = curl_init();
        $wapinx = "YXBpbW9iaWxlOmlickFZRmxvc1YwIw==";
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.chat.wappin.app/v1/users/login",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Basic ' . $wapinx
            ),
        ));
        $response = curl_exec($curl);
        $JsonData = json_decode($response, TRUE);
        curl_close($curl); 
        return $JsonData['users']['0']['token'];
}
public function sendOTPWapin($token,$NoHandphone,$kodeotp)
{
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.chat.wappin.app/v1/messages",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_SSL_VERIFYPEER => FALSE,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "to": "'.$NoHandphone.'",
    "type": "template",
    "template": {
        "name": "auth_login_temp",
        "namespace": "700eb891_fb62_4d15_8d30_d493e38bbfc9", 
        "language": {
            "policy": "deterministic",
            "code": "id"
        },
        "components": [
            {
                "type": "body",
                "parameters": [
                    {
                        "type": "text",
                        "text": "'.$kodeotp.'"
                    } 
                ]
            },
            {
                 "type": "button",
                "sub_type": "url",
                "index": 0,
                "parameters": [
                    {
                        "type": "text",
                        "text": "'.$kodeotp.'"
                    }
                ]
            }
        ]
    }
}',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer '.$token,
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);
$JsonData = json_decode($response, TRUE);
curl_close($curl); 
  return $JsonData;

 
}
    public function uploadDataTTD($data)
{
    $pinTTD = $data['Mst_PinTTD'];

    $this->db->query("SELECT TTD_Pegawai,Verified_PIN,Otp_Pin_verified FROM MasterdataSQL.dbo.Employees where TTD_Pegawai=:TTD_Pegawai ");
    $this->db->bind('TTD_Pegawai', $pinTTD);
    $datax =  $this->db->single();
    $cek = $datax['TTD_Pegawai'];
    
    $doc_nomr = $data['IdTranasksiAuto'];

    $ext = 'png'; // Ambil ekstensi filenya apa
    $namafile = $data['file'];
    // var_dump($namafile);
    // exit;
    
    if ($pinTTD == "") {
        $callback = array(
            'status' => 'warning',
            'message' => 'Masukkan data Pin TTD !'
        );
        return $callback;
        exit;
    }
    if ($datax['Verified_PIN'] == "0") {
        $callback = array(
            'status' => 'warning',
            'message' => 'Silahkan Verifikasi OTP terlebih dahulu !'
        );
        return $callback;
        exit;
    }
    //kondisi harus 6 digit character
    if (strlen($pinTTD) <> 6) {
        $callback = array(
            'status' => 'warning',
            'message' => 'Masukkan data Pin TTD Sesuai Format ! Hint: 6 Digit Angka !'
        );
        return $callback;
        exit;
    }

    if ($namafile == "") {
        $callback = array(
            'status' => 'warning',
            'message' => ' Pastikan file input TTD pada sudah diisi !'
        );
        return $callback;
        exit;
    }
   

    if ($cek!=null) {
        $callback = array(
            'status' => 'warning',
            'message' => 'No PIN Sudah Terpakai !'
        );
        return $callback;
        exit;
    }

        $bytes = random_bytes(20);
        $nama_file_baru  =     $doc_nomr . bin2hex($bytes) . "-" . date("YmdHis") . '.' . $ext;
      

            /// AWS
            // Create an S3Client
            $s3Client = new S3Client([
                'version' => 'latest',
                'region'  => 'ap-southeast-1',
                'http'    => ['verify' => false],
                'credentials' => [
                    'key'    => 'AKIAYV2M6ERJGUKK4QWQ',
                    'secret' => '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'
                ]
            ]);

            $file_name = $namafile;
            

            $source =   $file_name;
            $awsImages = '';
            try {
                $bucket = 'rsuyarsibucket';
                $key = basename($file_name);
                $result = $s3Client->putObject([
                    'Bucket' => $bucket,
                    'Key'    => 'masterdata/dataTTD/' . $key,
                    'Body'   => fopen($source, 'r'),
                    'ACL'    => 'public-read', // make file 'public', 
                ]);
                $awsImages = $result->get('ObjectURL');
                
                
                return $this->SaveTTD_TTD($data,  $nama_file_baru, $awsImages, $ext);
            } catch (MultipartUploadException $e) {

                return $e->getMessage();
            }

            $callback = array(
                'status' => 'warning',
                'message' => 'Upload Failed.',
            );
            return $callback;

        return $callback;

    
}

public function SaveTTD_TTD($data,  $nama_file_baru, $awsImages, $ext)
    {
        // var_dump($pinTTD);
        // exit;
        $query = "UPDATE MasterdataSQL.dbo.Employees SET
        TTD_Pegawai=:TTD_Pegawai,FileDocument=:FileDocument,Extension=:EXTENSION,date_update=:date_update,user_update=:user_update,
        Provider=:Provider where ID = :ID " ;
        try {
            
            
            $this->db->transaksi();
            $ro = "aws";
            $six_digit_random_number = random_int(100000, 999999);
            $pinTTD = $data['Mst_PinTTD'];
            $datetime = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $operator =  $session->IDEmployee;
            $this->db->query($query);
            
            $this->db->bind('ID', $data['IdTranasksiAuto']);
            

            // var_dump($data['IdTranasksiAuto']);
            $this->db->bind('TTD_Pegawai', $pinTTD);

            $this->db->bind('FileDocument', $awsImages);

            $this->db->bind('Provider', $ro);
             $this->db->bind('date_update', $datetime);
             $this->db->bind('user_update', $namauserx);
            $this->db->bind('EXTENSION', $ext);
            $this->db->execute();
            $this->db->Commit();
            $callback = array(
                'status' => 'success',
                'message' => ' Upload Data Succesfully.',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => 'warning',
                'message' => $e,
            );
            return $callback;
        }
    
    }

    public function getDataListTTD($data)
    {
        try {

            $query = "SELECT Id_trs,Id_data,Tgl_Awal, No_SIP, Tgl_Akhir, JenisDocument,FileDocument,Extension,date_update,user_update
            FROM HRDYARSI.dbo.TTDPegawai1
            WHERE Id_data=:ID_Data";

            $query = "SELECT ID, username, NoPIN, TTD_Pegawai, FileDocument 
            FROM MasterdataSQL.dbo.Employees where ID=:ID_Data";
            $this->db->query($query);
            $this->db->bind('ID_Data', $data['doc_nomr']);

            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {
                // $pasing['NO'] = $No++;
                $pasing['IdTranasksiAuto'] = $row['ID'];
                $pasing['Mst_NamaPegawai'] = $row['username'];
                $pasing['Mst_Username'] = $row['NoPIN'];
                $pasing['Mst_PinTTD'] = $row['TTD_Pegawai'];
                $pasing['URL'] = $row['FileDocument'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


//edit badrul
    
    public function createUserLogin($data)
    {  
        try {
            $IdTranasksiAuto = $data['IdTranasksiAuto'];
            $Mst_ID_Pegawai = $data['Mst_ID_Pegawai'];
            $Mst_NamaPegawai = $data['Mst_NamaPegawai'];
            $Mst_Username = $data['Mst_Username'];
            $Mst_Password = $data['Mst_Password'];
            $encodeXMst_Password = Utils::encryptSha256($Mst_Password);
            $Mst_Status = $data['Mst_Status'];
            $Mst_Admin = $data['Mst_Admin'];
            $Mst_JobTitle = $data['Mst_JobTitle'];
            $Mst_GroupUser = $data['Mst_GroupUser'];
            $Mst_DesignationID = $data['Mst_DesignationID'];
            $Mst_Menu1 = $data['Mst_Menu1'];
            $Mst_Menu2 = $data['Mst_Menu2'];
            $Mst_NIKKTP = $data['Mst_NIKKTP'];


            if ($Mst_Username == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Username !',
                );
                return $callback;
                exit;
            }
            if ($Mst_NamaPegawai == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Nama Invalid, Validasi Nama Karyawan !',
                );
                return $callback;
                exit;
            }

            if ($Mst_Password == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Password !',
                );
                return $callback;
                exit;
            }
            if ($Mst_Status == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Status Aktif !',
                );
                return $callback;
                exit;
            }
            if ($Mst_Admin == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Is Adminstrator YES/NO !',
                );
                return $callback;
                exit;
            }
            //
            if ($Mst_JobTitle == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Job Title !',
                );
                return $callback;
                exit;
            }
            if ($Mst_GroupUser == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Group User !',
                );
                return $callback;
                exit;
            }
            if ($Mst_DesignationID == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Designation ID !',
                );
                return $callback;
                exit;
            }
            if ($Mst_Menu1 == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Menu 1 !',
                );
                return $callback;
                exit;
            }
            if ($Mst_Menu2 == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Menu 2 !',
                );
                return $callback;
                exit;
            } 
            $this->db->transaksi(); 
            $company="RS. YARSI";
            if ($data['IdTranasksiAuto'] == "") {
                $this->db->query("SELECT *FROM MasterdataSQL.dbo.Employees where NoPIN=:Mst_Username");
                $this->db->bind('Mst_Username', $Mst_Username);
                $this->db->execute();
                $datarow = $this->db->rowCount();
                if ($datarow) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Username ini sudah ada, Gunakan Username Lain !',
                    );
                    return $callback;
                    exit;
                }
                $this->db->query("INSERT INTO MasterdataSQL.dbo.Employees 
                                (Company,[First Name],NIK,[Job Title],
                                Password,Password_V2,GroupUser,
                                DesignationID,Menu,Menu2,NoPIN,Administrator,UserStatus,NIK_KTP) VALUES 
                                (:Company,:FirstName,:NIK,:JobTitle,
                                :Password,:Password_V2,:GroupUser,
                                :DesignationID,:Menu,:Menu2,:NoPIN,:Administrator,:UserStatus,:Mst_NIKKTP)");
                $this->db->bind('Company', $company);
                $this->db->bind('FirstName', $data['Mst_NamaPegawai']);
                $this->db->bind('NIK', $data['Mst_ID_Pegawai']);
                $this->db->bind('JobTitle', $data['Mst_JobTitle']); 
                $this->db->bind('Password_V2', $encodeXMst_Password);
                $this->db->bind('Password', $data['Mst_Password']);
                $this->db->bind('GroupUser', $data['Mst_GroupUser']);
                $this->db->bind('DesignationID', $data['Mst_DesignationID']);
                $this->db->bind('Menu', $data['Mst_Menu1']);
                $this->db->bind('Menu2', $data['Mst_Menu2']);
                $this->db->bind('NoPIN', $data['Mst_Username']);
                $this->db->bind('Administrator', $data['Mst_Admin']);
                $this->db->bind('UserStatus', $data['Mst_Status']); 
                $this->db->bind('Mst_NIKKTP', $data['Mst_NIKKTP']); 
            } else {
                $this->db->query("UPDATE MasterdataSQL.dbo.Employees set  
                                [First Name]=:FirstName,[Job Title]=:JobTitle,
                                GroupUser=:GroupUser,
                                DesignationID=:DesignationID,Menu=:Menu,Menu2=:Menu2,
                                Administrator=:Mst_Admin,UserStatus=:Mst_Status,NIK_KTP=:Mst_NIKKTP
                                WHERE ID=:IdTranasksiAuto ");
                $this->db->bind('IdTranasksiAuto', $data['IdTranasksiAuto']);
                $this->db->bind('Mst_Admin', $data['Mst_Admin']);
                $this->db->bind('Mst_Status', $data['Mst_Status']);
                $this->db->bind('Menu', $data['Mst_Menu1']);
                $this->db->bind('Menu2', $data['Mst_Menu2']);
                $this->db->bind('GroupUser', $data['Mst_GroupUser']);
                $this->db->bind('DesignationID', $data['Mst_DesignationID']);
                $this->db->bind('FirstName', $data['Mst_NamaPegawai']);
                $this->db->bind('JobTitle', $data['Mst_JobTitle']);  
                $this->db->bind('Mst_NIKKTP', $data['Mst_NIKKTP']);  
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
    public function getUserLoginbyId($data)
    {
        try { 
            $this->db->query("SELECT * from MasterdataSQL.dbo.Employees  where ID=:userId");
            $this->db->bind('userId', $data['id']);
            $data =  $this->db->single();
            $pasing['username'] = $data['username'];
            $pasing['NoPIN'] = $data['NoPIN'];
            $callback = array(
                'status' => 'success', // Set array status dengan success    
                'ID' => $data['ID'], // Set array status dengan success    
                'Company' => $data['Company'], // Set array status dengan success 
                'Nama' => $data['First Name'], // Set array status dengan success 
                'NIK' => $data['NIK'], // Set array status dengan success 
                'Jobtitle' => $data['Job Title'], // Set array status dengan success 
                'username' => $data['username'], // Set array status dengan success 
                'Password' => $data['Password'], // Set array status dengan success 
                'GroupUser' => $data['GroupUser'], // Set array status dengan success 
                'DesignationID' => $data['DesignationID'], // Set array status dengan success 
                'Menu' => $data['Menu'], // Set array status dengan success 
                'Menu2' => $data['Menu2'], // Set array status dengan success 
                'NoPIN' => $data['NoPIN'], // Set array status dengan success   
                'Administrator' => $data['Administrator'], // Set array status dengan success  
                'UserStatus' => $data['UserStatus'], // Set array status dengan success  
                'NIK_KTP' => $data['NIK_KTP'], // Set array status dengan success  
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function ShowListHakAkses($data)
    {
        try {
            $this->db->query("SELECT A.id,B.nama_submenu,c.nama_menu,
                            CASE WHEN A.Is_Create='1' then 'YA' ELSE 'NO' END AS Is_Create,
                            CASE WHEN A.Is_Delete='1' then 'YA' ELSE 'NO' END AS Is_Delete
                              FROM MasterdataSQL.dbo.Employees_2_V2 a
                              INNER JOIN MasterdataSQL.dbo.A_SUBMENU_USER_V2 B
                              ON A.id_submenu=B.id_submenu
                              INNER JOIN MasterdataSQL.dbo.A_MENU_USER_V2 C 
                              ON B.id_menu = C.id_menu
                          where a.user_id=:IdTranasksiAuto ");
            $this->db->bind('IdTranasksiAuto', $data['IdTranasksiAuto']);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = "1";
            foreach ($data as $row) {
                $pasing['id'] = $row['id'];
                $pasing['nama_submenu'] = $row['nama_submenu'];
                $pasing['nama_menu'] = $row['nama_menu'];
                $pasing['Is_Create'] = $row['Is_Create'];
                $pasing['Is_Delete'] = $row['Is_Delete'];
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDataSubMenu($data)
    {
        try {
            $this->db->query("SELECT id_submenu,nama_submenu FROM A_SUBMENU_USER"); 
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = "1";
            foreach ($data as $row) {
                $pasing['id_submenu'] = $row['id_submenu'];
                $pasing['nama_submenu'] = $row['nama_submenu'];
                $rows[] = $pasing;
                $array['getSubmenu'] = $rows; 
            }
            return $array;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function CreateHakAksesbyUserID($data)
    {
 
        $IdTranasksiAuto = $data['IdTranasksiAuto']; 
        $Mst_Create = $data['Mst_Create'];
        $Mst_Delete = $data['Mst_Delete'];
        $Mst_ID_Hak_Akses = $data['Mst_ID_Hak_Akses'];

        
        try {
            $this->db->transaksi(); 
            if ($Mst_ID_Hak_Akses == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Hak Akses !',
                );
                return $callback;
                exit;
            }
            if ($Mst_Create == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Akses Create Transaksi !',
                );
                return $callback;
                exit;
            }
            if ($Mst_Delete == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Akses Delete Transaksi !',
                );
                return $callback;
                exit;
            }
            $this->db->query("SELECT *FROM MasterdataSQL.dbo.Employees_2_V2 where user_id=:IdTranasksi 
                            and id_submenu=:Mst_ID_Hak_Akses");
            $this->db->bind('IdTranasksi', $IdTranasksiAuto);
            $this->db->bind('Mst_ID_Hak_Akses', $Mst_ID_Hak_Akses);
            $this->db->execute();
            $datarow = $this->db->rowCount();
            if ($datarow) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Username ini sudah ada Hak Aksesnya, Gunakan Hak Akses Lain !',
                );
                return $callback;
                exit;
            }

            $this->db->query("INSERT INTO MasterdataSQL.dbo.Employees_2_V2
                                (user_id,id_submenu,Is_Create,Is_Delete)
                                values
                                (:IdTranasksi,:Mst_ID_Hak_Akses,:Is_Create,:Is_Delete) ");
            $this->db->bind('IdTranasksi', $IdTranasksiAuto);
            $this->db->bind('Mst_ID_Hak_Akses', $Mst_ID_Hak_Akses);
            $this->db->bind('Is_Create', $Mst_Create);
            $this->db->bind('Is_Delete', $Mst_Delete); 
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
    public function DeleteHakAksesbyUserID($data)
    {
        try {
            $this->db->transaksi();
            $IdTranasksi = $data['q'];  
            $this->db->query("DELETE   MasterdataSQL.dbo.Employees_2_V2 WHERE id=:IdTranasksi  ");
            $this->db->bind('IdTranasksi', $IdTranasksi); 
            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Dihapus !', // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function getGroupUser($data)
    {
        try {
            $this->db->query("SELECT GroupUser from MasterdataSQL.dbo.Employees  group by GroupUser");
            $data =  $this->db->resultSet();
            $this->db->closeCon();
            $rows = array(); 
            $no = "1";
            foreach ($data as $key) {
                $pasing['GroupUser'] = $key['GroupUser']; 
                $rows[] = $pasing; 
            }
            return $rows;
        } catch (PDOException $e) {
            $this->db->closeCon();
            die($e->getMessage());
        }
    }
    public function getMenu($data)
    {
        try {
            $this->db->query("SELECT Menu from MasterdataSQL.dbo.Employees  group by Menu");
            $data =  $this->db->resultSet();
            $this->db->closeCon();
            $rows = array();
            $no = "1";
            foreach ($data as $key) {
                $pasing['Menu'] = $key['Menu'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            $this->db->closeCon();
            die($e->getMessage());
        }
    }
    public function getMenu2($data)
    {
        try {
            $this->db->query("SELECT Menu2 from MasterdataSQL.dbo.Employees  group by Menu2");
            $data =  $this->db->resultSet();
            $this->db->closeCon();
            $rows = array();
            $no = "1";
            foreach ($data as $key) {
                $pasing['Menu2'] = $key['Menu2'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            $this->db->closeCon();
            die($e->getMessage());
        }
    }
    public function getDataPegawai($data)
    {
        try {
            $this->db->query("SELECT ID_Data, NIP, Nama
                            FROM HRDYARSI.DBO.[Data Pegawai] where Status_Aktif='1'
                            order by ID_Data desc");
            $data =  $this->db->resultSet();
            $this->db->closeCon();
            $rows = array();
            $no = "1";
            foreach ($data as $key) {
                $pasing['ID_Data'] = $key['ID_Data'];
                $pasing['NIP'] = $key['NIP'];
                $pasing['Nama'] = $key['Nama'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            $this->db->closeCon();
            die($e->getMessage());
        }
    }
    public function getLastPINID($data)
    {
        try {
            $LPin=$data['params'];
            $this->db->query("SELECT max(NoPIN) as urut from MasterdataSQL.dbo.Employees where left(nopin,2)=:params");
            $this->db->bind('params', $LPin);
            $data =  $this->db->single();
            $maxID = substr("000" . $data['urut'], -3);
            $datapin = "DY" . $maxID;
            $datapin++;
            $callback = array(
                'status' => 'success', 
                'urut' => $datapin, 
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function GoupdateCreate($data)
    {
        try {
            $this->db->transaksi();
            $id = $data['id'];
            $isDelete = $data['isDelete'];
            if($isDelete =="NO"){
                $isdel="1";
                $this->db->query("UPDATE MasterdataSQL.dbo.Employees_2_V2 SET Is_Create=:isdel WHERE id=:IdTranasksi  ");
                $this->db->bind('IdTranasksi', $id);
                $this->db->bind('isdel', $isdel);
                $this->db->execute();
            } else  if ($isDelete == "YA") {
                $isdel = "0";
                $this->db->query("UPDATE MasterdataSQL.dbo.Employees_2_V2 SET Is_Create=:isdel WHERE id=:IdTranasksi  ");
                $this->db->bind('IdTranasksi', $id);
                $this->db->bind('isdel', $isdel);
                $this->db->execute();
            }
            
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Dihapus !', // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function GoupdateDelete($data)
    {
        try {
            $this->db->transaksi();
            $id = $data['id'];
            $isDelete = $data['isDelete'];
            if ($isDelete == "NO") {
                $isdel = "1";
                $this->db->query("UPDATE MasterdataSQL.dbo.Employees_2_V2 SET Is_Delete=:isdel WHERE id=:IdTranasksi  ");
                $this->db->bind('IdTranasksi', $id);
                $this->db->bind('isdel', $isdel);
                $this->db->execute();
            } else  if ($isDelete == "YA") {
                $isdel = "0";
                $this->db->query("UPDATE MasterdataSQL.dbo.Employees_2_V2 SET Is_Delete=:isdel WHERE id=:IdTranasksi  ");
                $this->db->bind('IdTranasksi', $id);
                $this->db->bind('isdel', $isdel);
                $this->db->execute();
            }

            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Dihapus !', // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function GetHakAksesUser($data)
    {
        try {
            $idSubmenu = $data['id'];
            $session = SessionManager::getCurrentSession();
            $useridRole = $session->role;
            $userlogin = $session->username;
            if ($useridRole == "1") {
                $this->db->query("SELECT url FROM MasterdataSQL.DBO.A_SUBMENU_USER_V2 where id_submenu=:idSubmenu");
                $this->db->bind('idSubmenu', $idSubmenu);
                $data =  $this->db->single();
                if ($data) {
                    $pasing['url'] = $data['url'];
                    $callback = array(
                        'message' => "success", // Set array nama 
                        'data' => $pasing,
                        'admin' => $useridRole,
                        'issuper' => "superadmin"
                    );
                } else {
                    $pasing['pesan'] = "Id Menu Tidak Ditemukan/Belum ada di Master ! ";
                    $callback = array(
                        'message' => "warning", // Set array nama  
                        'data' => $pasing,
                        'admin' => $useridRole
                    );
                }
            } else if ($useridRole == "0") {
                $this->db->query("SELECT B.url
                            FROM MasterdataSQL.DBO.Employees_2_V2 A 
                            INNER JOIN MasterdataSQL.DBO.A_SUBMENU_USER_V2 B 
                            ON A.id_submenu = B.id_submenu
                            inner join MasterdataSQL.DBO.Employees C 
                            ON A.user_id = C.ID
                            WHERE c.NOPIN=:userlogin
                            and a.id_submenu=:idSubmenu and a.batal='0'");
                $this->db->bind('idSubmenu', $idSubmenu);
                $this->db->bind('userlogin', $userlogin);
                $data =  $this->db->single();
                if ($data) {
                    $pasing['url'] = $data['url'];
                    //Tutup menu
                    if (strpos( $data['url'], 'Information' )){
                        //setelah jam 13
                        date_default_timezone_set('Asia/Jakarta');
                        if (date('H') <= 12){
                            $pasing['pesan'] = 'Maaf, sementara menu ini hanya bisa diakses setelah jam 13:00';
                            $callback = array(
                                'message' => "warning", // Set array nama 
                                'data' => $pasing,
                                'admin' => $useridRole
                            );
                        }else{
                            $callback = array(
                                'message' => "success", // Set array nama 
                                'data' => $pasing,
                                'admin' => $useridRole
                            );
                        }
                        
                        //pengecualian menu
                        if ($data['url'] == '/bInformationLma' || $data['url'] == '/bInformationBPJS'){
                            $callback = array(
                                'message' => "success", // Set array nama 
                                'data' => $pasing,
                                'admin' => $useridRole
                            );
                        }

                        //pengecualian user (pakai nopin)
                        //$userlogin = nopin
                        if ($userlogin == '0110'){
                            $callback = array(
                                'message' => "success", // Set array nama 
                                'data' => $pasing,
                                'admin' => $useridRole
                            );
                        }
                    }else{
                        $callback = array(
                            'message' => "success", // Set array nama 
                            'data' => $pasing,
                            'admin' => $useridRole
                        );
                    }

                   
                } else {
                    $pasing['pesan'] = "Anda Tidak Memiliki Hak Akses ! ";
                    $callback = array(
                        'message' => "warning", // Set array nama  
                        'data' => $pasing,
                        'admin' => $useridRole,
                        'idSubmenu' => $idSubmenu,
                        'userlogin' => $userlogin
                    );
                }
            }

            return $callback;
            $this->db->closeCon();
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
    public function saveCopiHakAkses($data)
    {

        $IdTranasksiAuto = $data['IdTranasksiAuto'];
        $Mst_UserCopi_Hak_Akses = $data['Mst_UserCopi_Hak_Akses']; 


        try {
            $this->db->transaksi();
            if ($IdTranasksiAuto == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Id User Utama Kosong !',
                );
                return $callback;
                exit;
            }
            if ($Mst_UserCopi_Hak_Akses == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Id User Copy Kosong !',
                );
                return $callback;
                exit;
            }
            $this->db->query("DELETE FROM MasterdataSQL.DBO.Employees_2_V2 WHERE user_id=:IdTranasksiAuto");
            // $this->db->bind('IdTranasksi', $IdTranasksiAuto);
            $this->db->bind('IdTranasksiAuto', $IdTranasksiAuto);
            $this->db->execute();

            $this->db->query("INSERT INTO MasterdataSQL.DBO.Employees_2_V2 
                            (user_id,id_menu,id_submenu,batal,Is_Create,Is_delete)
                            SELECT '$IdTranasksiAuto',id_menu,id_submenu,batal,Is_Create,Is_delete
                            FROM MasterdataSQL.DBO.Employees_2_V2 where USER_Id=:Mst_UserCopi_Hak_Akses");
            // $this->db->bind('IdTranasksi', $IdTranasksiAuto);
            $this->db->bind('Mst_UserCopi_Hak_Akses', $Mst_UserCopi_Hak_Akses);
            $this->db->execute();
            $go = $this->db->commit();
            if($go){
                $callback = array(
                    'status' => 'success', // Set array status dengan success   
                    'message' => 'Copi Hak Akses Berhasil Dilakukan !', // Set array status dengan success    
                );
            }
            
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function UploadSignature($data)
    {


        // Jika user telah mengklik tombol Preview

        //$ip = ; // Ambil IP Address dari User 
        $doc_nomr = $data['nikPegawai'];

        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png", "pdf" => "application/pdf");
        $filetype = $_FILES["text"]["type"];
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
        $tmp_file = $_FILES['file']['tmp_name'];

        // Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
        if (in_array($filetype, $allowed)) {
            $bytes = random_bytes(20);
            $nama_file_baru  =     $doc_nomr . bin2hex($bytes) . "-" . date("YmdHis") . '.' . $ext;
            if (move_uploaded_file($tmp_file,  __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru)) {

                /// AWS
                // Create an S3Client
                $s3Client = new S3Client([
                    'version' => 'latest',
                    'region'  => 'ap-southeast-1',
                    'http'    => ['verify' => false],
                    'credentials' => [
                        'key'    => 'AKIAYV2M6ERJGUKK4QWQ',
                        'secret' => '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'
                    ]
                ]);
                $file_name = __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru;
                $source =   $file_name;
                $awsImages = '';
                try {
                    $bucket = 'rsuyarsibucket';
                    $key = basename($file_name);
                    $result = $s3Client->putObject([
                        'Bucket' => $bucket,
                        'Key'    => 'hrd/datakeluarga/' . $key,
                        'Body'   => fopen($source, 'r'),
                        'ACL'    => 'public-read', // make file 'public', 
                    ]);
                    $awsImages = $result->get('ObjectURL');

                    //return $this->SaveTTD($data,  $nama_file_baru, $awsImages, $ext);
                } catch (MultipartUploadException $e) {

                    return $e->getMessage();
                }
            } else {
                $callback = array(
                    'status' => 'warning',
                    'message' => 'Upload Failed.',
                );
                return $callback;
            }
        } else { // Jika file yang diupload bukan File Excel 2007 (.xlsx)
            // Munculkan pesan validasi 
            $callback = array(
                'status' => 'warning',
                'message' => ' File Tidak Support.',
                '$ext' => $ext,
                ' $allowed' =>  $allowed,
            );
            return $callback;
        }
    }
}