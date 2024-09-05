<?php
class bInformationRadiologiGigi extends Controller 
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Radiologi Gigi Pasien';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/registration/radiologigigi/InformationRadGigi', $data);
        $this->View('templates/footer');
    }
    public function getListData(){
        echo json_encode($this->model('B_InformationRadGigi_Model')->getListData($_POST));
    }
}
