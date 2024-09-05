<?php
class bInformationKomplain extends Controller 
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Komplain Pasien';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/registration/Komplain/InformationKomplain', $data);
        $this->View('templates/footer');
    }
    public function getDataListKomplainPasien(){
        echo json_encode($this->model('B_InformationKomplain_Model')->getDataListPasien($_POST));
    }
}
