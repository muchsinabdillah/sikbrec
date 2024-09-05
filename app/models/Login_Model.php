<?php


class Login_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // INSERT
    public function cekLogin($data)
    {

        if ($data['UserId'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Username !',
            );
            return $callback;
            exit;
        }
        if ($data['Password'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Password !',
            );
            return $callback;
            exit;
        }
         
        try {
            $this->db->transaksi();
            /// MAEN LOGIN
                $aktif = "1"; 
                $password = $data['Password'];
                $encodeXMst_Password = Utils::encryptSha256($password); 
                $getdatenowx = Utils::seCurrentDateTime();
                $encodedSignature = Utils::encryptBase64($getdatenowx);
                $getIPuser = Utils::get_client_ip();
                $browseruser = Utils::get_client_browser(); 
                $token = $encodedSignature;
                $this->db->query('SELECT ID, [First Name] as NamaLengkap , NoPIN as Username,Administrator , BatalTransaksi,
                                    [Mobile Phone] AS NoHp ,ID_Master_Dokter, Group_User_EMR
										  from MasterdataSQL.dbo.Employees
										  where  NoPIN=:Usernamex and password=:passwordx');
                $this->db->bind('Usernamex', $data['UserId']);
                $this->db->bind('passwordx', $password ); 
                $this->db->execute(); 
                $row = $this->db->single();
                if($row){  
                    $getdatenowx = Utils::seCurrentDateTime();
                    $encodedSignature = Utils::encryptBase64($getdatenowx);
                    $getIPuser = Utils::get_client_ip();
                    $browseruser = Utils::get_client_browser();
                    $token = $encodedSignature;
                    if (SessionManager::login($row["Username"], $row["Administrator"], $row["NamaLengkap"], $token, $row["BatalTransaksi"], $row["ID"], $row["ID_Master_Dokter"], $row["Group_User_EMR"])) {
                        $this->db->query("INSERT INTO MasterdataSQL.dbo.A_Login_Session
                                            (Username,Token,User_IP_User,User_Browser)
                                            VALUES
                                            (:Usernamex2,:token,:getIPuser,:browseruser)");
                        $this->db->bind('Usernamex2', $row["Username"]);
                        $this->db->bind('getIPuser', $getIPuser);
                        $this->db->bind('browseruser', $browseruser);
                        $this->db->bind('token', $token);
                        $this->db->execute();
                        $this->db->commit();

                        $callback = array(
                            'status' => 'success', // Set array status dengan success   
                            'message' => 'Login Berhasil !', // Set array status dengan success    
                        );
                        return $callback;
                    } else {
                        $callback = array(
                            'status' => 'warning', // Set array status dengan success   
                            'errorname' => 'Login Failed !', // Set array status dengan success    
                        );
                        return $callback;
                    }  
                }else{
                    $callback = array(
                        'status' => 'warning', // Set array status dengan success   
                        'errorname' => 'Login Failed !',    
                    );
                    return $callback;
                } 
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function getAllGroupShift()
    {
        try {
            $this->db->query('SELECT *FROM  HR_Mst_MASTER_SHIFT_GROUP');
            return $this->db->resultSet();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getGroupShiftById($id)
    {
        $this->db->query('SELECT *FROM HR_Mst_MASTER_SHIFT_GROUP where id =:id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }
    public function getGroupShiftCombo()
    {
        $this->db->query('SELECT *FROM HR_Mst_MASTER_SHIFT_GROUP');
        return $this->db->resultSet();
    }
    public function errormessage()
    {

        echo json_encode("Failed");
    }
    public function checkToken($username, $role, $name,$token){
        try {
            $this->db->transaksi();
            /// MAEN LOGIN
            $aktif = "1";
            $this->db->query('SELECT NamaLengkap,Admin, Username, ID, a.ID_Data 
                          from A_Login_User a
                          inner join [HR_Data Pegawai] b
                          on a.ID_Data = b.ID_Data 
                          WHERE a.Username=:Usernamex and Aktif=:Aktifx 
                          and token=:token');
            $this->db->bind('Usernamex', $username);
            $this->db->bind('Aktifx', $aktif);
            $this->db->bind('token', $token);
            $this->db->execute();
            $row = $this->db->single();
            if ($row) {
                 return true;
            } else {
                return true;
            }
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function sendVerification($data){
        try {
            $this->db->transaksi();
            $UserId = $data['UserId'];
            $NoHandphone = $data['NoHandphone'];
            $six_digit_random_number = Utils::genOTP();
            $replacenumberhp = Utils::hp($NoHandphone);
            $this->db->query("UPDATE MasterdataSQL.DBO.Employees SET [Mobile Phone]=:NoHandphone,KODE_OTP=:six_digit_random_number
                                WHERE NoPIN=:UserId");
            $this->db->bind('NoHandphone', $NoHandphone);
            $this->db->bind('UserId', $UserId);
            $this->db->bind('six_digit_random_number', $six_digit_random_number); 
            $this->db->execute();

            
            $data = $this->db->commit();
            if($data){ 
               // $gettoken = $this->getTokenWapin();

                $sendwa = $this->sendOTPWapin("", $replacenumberhp, $six_digit_random_number);
                $JsonData = json_encode($sendwa);
                $convert = json_decode($JsonData, TRUE);

               // if ($convert['status'] == "200") { 
                    $callback = array(
                        'status' => 'success',
                        'UserId' => $UserId,
                        'nohp' => $replacenumberhp
                    );
                    return $callback;
                //} 
                // $url = "https://sms.mysmsmasking.com/masking/send_post.php";
                // $rows = array(
                //     'username' => 'rsuyarsi',
                //     'password' => '20220111',
                //     'hp' => $replacenumberhp,
                //     'message' => 'JANGAN BERI TAHU KODE OTP KE SIAPAPUN. INI ADALAH KODE OTP UNTUK LOGIN KE APLIKASI SIMRS RSYARSI : ' . $six_digit_random_number
                // );
                // $curl = curl_init();
                // curl_setopt($curl, CURLOPT_URL, $url);
                // curl_setopt($curl, CURLOPT_POST, TRUE);
                // curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
                // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
                // curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($rows));
                // curl_setopt($curl, CURLOPT_HEADER, FALSE);
                // curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 60);
                // curl_setopt($curl, CURLOPT_TIMEOUT, 60);
                // $htm = curl_exec($curl);
                // if (
                //     curl_errno($curl) !== 0
                // ) {
                //     error_log('cURL error when connecting to ' . $url . ': ' . curl_error($curl));
                // }
                // curl_close($curl);
                // $callback = array(
                //     'status' => 'success',
                //     'UserId' => $UserId,
                //     'nohp' => $replacenumberhp
                // );
                // return $callback;
            }
            

        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'errorname' => $e
            );
            return $callback;
        }
    }
    public function verifyOTP($data)
    {
        try {
            $this->db->transaksi();
            $UserId = $data['UserId'];
            $NoOTP = $data['NoOTP'];
            if ($data['UserId'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Username !',
                );
                return $callback;
                exit;
            }
            if ($data['NoOTP'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Kode OTP !',
                );
                return $callback;
                exit;
            }
            $this->db->query("SELECT KODE_OTP,ID, [First Name] as NamaLengkap , NoPIN as Username,Administrator , BatalTransaksi,
                                    [Mobile Phone] AS NoHp FROM MasterdataSQL.DBO.Employees 
                            where 
                            NoPIN=:UserId"); 
            $this->db->bind('UserId', $UserId);
            $this->db->execute();
            $row = $this->db->single();
            if($row){
                if($row['KODE_OTP'] == $NoOTP ){
                    $getdatenowx = Utils::seCurrentDateTime();
                    $encodedSignature = Utils::encryptBase64($getdatenowx);
                    $getIPuser = Utils::get_client_ip();
                    $browseruser = Utils::get_client_browser();
                    $token = $encodedSignature;
                    if (SessionManager::login($row["Username"], $row["Administrator"], $row["NamaLengkap"], $token, $row["BatalTransaksi"], $row["ID"])) {
                        $this->db->query("INSERT INTO MasterdataSQL.dbo.A_Login_Session
                                             (Username,Token,User_IP_User,User_Browser)
                                            VALUES
                                            (:Usernamex2,:token,:getIPuser,:browseruser)");
                        $this->db->bind('Usernamex2', $row["Username"]);
                        $this->db->bind('getIPuser', $getIPuser);
                        $this->db->bind('browseruser', $browseruser);
                        $this->db->bind('token', $token);
                        $this->db->execute();
                        $this->db->commit();

                        $callback = array(
                            'status' => 'success', // Set array status dengan success   
                            'message' => 'Login Berhasil !', // Set array status dengan success    
                        );
                        return $callback;
                    } else {
                        $callback = array(
                            'status' => 'warning', // Set array status dengan success   
                            'errorname' => 'Login Failed !', // Set array status dengan success    
                        );
                        return $callback;
                    }
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
        $url = "https://api.kirimpesan.net/api/sendText?token=66b5ace5c302c5956a66b6f3&phone=".$NoHandphone."&message=".$kodeotp."%20adalah%20kode%20Verifikasi%20Login%20Anda.%20Jangan%20Berikan%20Kepada%20Siapapun.%20Terima%20Kasih.";
        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_SSL_VERIFYPEER => FALSE,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET', 
          CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Content-Type: application/json'
          ),
        ));
        
        $response = curl_exec($curl);
        $JsonData = json_decode($response, TRUE);
        curl_close($curl); 
          return $JsonData;

         
    }
}
