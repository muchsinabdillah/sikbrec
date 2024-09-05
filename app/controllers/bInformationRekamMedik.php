<?php
class bInformationRekamMedik extends Controller 
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Rekam Medik';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/registration/RekamMedik/InformationRekamMedik', $data);
        $this->View('templates/footer');
    }
    public function getDataListRekamMedikPasien(){
        echo json_encode($this->model('B_InformationRekamMedik_Model')->getDataListPasien($_POST));
    }
    public function getIDDokter()
    {
        echo json_encode($this->model('B_InformationRekamMedik_Model')->getIDDokter());
    }
}
