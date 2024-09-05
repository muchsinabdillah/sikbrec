<?php
class Login extends Controller
{
    public function index()
    {
        try {
            $session = SessionManager::getCurrentSession();
            header('Location: ' . BASEURL);
        } catch (exception $exception) { 
            $this->View('templates/header_login');
            $this->View('login/index');
            $this->View('templates/footer_login');
        }
    }
    public function cekLogin(){
        echo json_encode($this->model('Login_Model')->cekLogin($_POST)); 
    }
    public function sendVerification()
    {
        echo json_encode($this->model('Login_Model')->sendVerification($_POST));
    }
    public function verifyOTP(){
        echo json_encode($this->model('Login_Model')->verifyOTP($_POST));
    }
    public function getTokenWapin()
    {
        echo json_encode($this->model('Login_Model')->getTokenWapin($_POST));
    }
}
