<?php
class LogOut 
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function index()
    {
        $getIPuser = Utils::get_client_ip();
        $browseruser = Utils::get_client_browser();
        $session = SessionManager::getCurrentSession();
        $username = $session->username;
        $token= $session->token;
        $this->db->query('DELETE from  MasterdataSQL.dbo.A_Login_Session WHERE Token=:token
        --and  User_IP_User=:getIPuser 
        and  User_Browser=:browseruser and 
         Username=:Usernamex2  ');
        $this->db->bind('Usernamex2', $username); 
        $this->db->bind('token', $token);
        //$this->db->bind('getIPuser', $getIPuser);
        $this->db->bind('browseruser', $browseruser);
        $this->db->execute(); 
       
        unset($_COOKIE['X-RSY-SESID']); 
        setcookie("X-RSY-SESID",null, -1, '/' );
        header('Location: '.BASEURL.'/Login');
    }
  
}
