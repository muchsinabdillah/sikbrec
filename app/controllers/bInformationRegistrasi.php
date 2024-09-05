<?php
class bInformationRegistrasi extends Controller 
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Registrasi';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/registration/Registrasi/InformationRegistrasi', $data);
        $this->View('templates/footer');
    }
    public function getDataListRegistrasiPasien(){
        echo json_encode($this->model('B_InformationRegistrasi_Model')->getDataListPasien($_POST));
    }
}
