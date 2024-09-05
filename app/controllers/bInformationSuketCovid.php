<?php
class bInformationSuketCovid extends Controller 
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Surat Keterangan Covid-19 Pasien';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/registration/SuketCovid/InformationSuketCovid', $data);
        $this->View('templates/footer');
    }
    public function getDataListSuketCovidPasien(){
        echo json_encode($this->model('B_InformationSuketCovid_Model')->getDataListPasien($_POST));
    }
}
