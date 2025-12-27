<?php
class GrafikKunjunganPasien extends Controller{
    public function index(){
        try{
            $session = SessionManager::getCurrentSession();
            //$cek =  $this->model('Laogin_Model')->checkToken($session->username,$session->role,$session->name,$session->token);
            if($session){
                $this->view('templates/header', $session);
                $this->View('grafik/kunjunganpasien/data', $session);
                $this->view('templates/footer', $session);
            }else{
                header('Location: '.BASEURL.'/Login');
            }
        }catch(exception $exception){ 
            header('Location: ' . BASEURL . '/Login');
        }
    }
    public function RekapBulan(){
        echo json_encode($this->model('Grafik_KunjuganPasien_Model')->RekapBulan($_POST));
    }
    public function Harian(){
        echo json_encode($this->model('Grafik_KunjuganPasien_Model')->Harian($_POST));
    }
    public function yearly(){
        try{
            $session = SessionManager::getCurrentSession();
            //$cek =  $this->model('Laogin_Model')->checkToken($session->username,$session->role,$session->name,$session->token);
            if($session){
                $this->view('templates/header', $session);
                $this->View('grafik/kunjunganpasien/yearly', $session);
                $this->view('templates/footer', $session);
            }else{
                header('Location: '.BASEURL.'/Login');
            }
        }catch(exception $exception){ 
            header('Location: ' . BASEURL . '/Login');
        }
    }
    public function RekapTahun(){
        echo json_encode($this->model('Grafik_KunjuganPasien_Model')->RekapTahun($_POST));
    }
    public function Bulanan(){
        echo json_encode($this->model('Grafik_KunjuganPasien_Model')->Bulanan($_POST));
    }

    
}