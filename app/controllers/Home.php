<?php
class Home extends Controller{
    public function index(){
        try{
            $session = SessionManager::getCurrentSession();
            //$cek =  $this->model('Login_Model')->checkToken($session->username,$session->role,$session->name,$session->token);
            if($session){
                $this->view('templates/header', $session);
                $this->View('home/index', $session);
                $this->view('templates/footer', $session);
            }else{
                header('Location: '.BASEURL.'/Login');
            }
        }catch(exception $exception){ 
            header('Location: ' . BASEURL . '/Login');
        }
    }
    public function chartReporting(){
        echo json_encode($this->model('Grafik_Model')->testGrafik($_POST));
    }
}