<?php
class bInformationPasienRanap extends Controller 
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Pasien Rawat Inap';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/registration/PasienRanap/InformationPasienRanap', $data);
        $this->View('templates/footer');
    }
    public function getDataListPasienRanapPasien(){
        echo json_encode($this->model('B_InformationPasienRanap_Model')->getDataListPasien($_POST));
    }
}
