<?php

class Session{

    public function  __construct(
        $username, 
        $role,
        $name,
        $token,
        $BatalTransaksi,
        $IDEmployee)
    {
        $this->username = $username;
        $this->role = $role;
        $this->name = $name;
        $this->token = $token;
        $this->BatalTransaksi = $BatalTransaksi;
        $this->IDEmployee = $IDEmployee;
    } 
}

class SessionManager{
    public static  $SECRET_KEY = "aslejlj3454350sdjopj#30%%((%(345345l3545rttertt049566546546";
    public static function login( $username,  $role, $name, $token, $BatalTransaksi, $IDEmployee ) {
             $payload = [
                "username" => $username,
                "role" => $role,
                "name" => $name,
                "token" => $token,
                "BatalTransaksi" => $BatalTransaksi,
                "IDEmployee" => $IDEmployee
             ];
            
             $jwt = \Firebase\JWT\JWT::encode($payload, SessionManager::$SECRET_KEY,'HS256' );
             setcookie("X-RSY-SESID",$jwt, strtotime('+1 year'), '/'); 
            return true;
    }

    public  static function getCurrentSession(): Session
    {
        if(isset($_COOKIE['X-RSY-SESID'])){
            $jwt = $_COOKIE['X-RSY-SESID'];
            try{ 
                $aktif="1";
                $getIPuser = Utils::get_client_ip();
                $browseruser = Utils::get_client_browser(); 
                $db = new PDO("sqlsrv:Server=" .DB_HOST.";Database=".DB_NAME, DB_USER, DB_PASSWORD);
                $payload = \Firebase\JWT\JWT::decode($jwt, SessionManager::$SECRET_KEY, ['HS256']);
                $query= "SELECT *FROM  MasterdataSQL.dbo.A_Login_Session 
                        WHERE Username=:Usernamex 
                      --  and User_IP_User=:User_IP_User 
                        and token=:token and User_Browser=:User_Browser  ";
                $statement = $db->prepare($query);
                $statement->bindParam('Usernamex', $payload->username);
                //$statement->bindParam('User_IP_User', $getIPuser);
                $statement->bindParam('token', $payload->token);
                $statement->bindParam('User_Browser', $browseruser);
                $statement->execute();
                $products = $statement->fetch(PDO::FETCH_ASSOC); 
                $statement = null;
                if ($products) {
                    return new Session($payload->username,  $payload->role, $payload->name, $payload->token,$payload->BatalTransaksi,$payload->IDEmployee);
                } else {
                    header('Location: ' . BASEURL . '/NotPage');
                }   
            }catch(Exception $exception) {
                throw new Exception("User is not login");
            }
        } else{
            throw new Exception("User is not login");
        }
 
    }
}