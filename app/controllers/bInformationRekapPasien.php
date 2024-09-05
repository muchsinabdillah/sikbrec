<?php
class bInformationRekapPasien extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Rekap Pasien';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/registration/RekapPasien/InformationRekapPasien', $data);
        $this->View('templates/footer');
    }
    public function getDataListPasien()
    {
        echo json_encode($this->model('B_InformationRekapPasien_Model')->getDataListPasien($_POST));
    }
    public function InfoPasienCB()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Pasien CB/CT';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/registration/RekapPasien/InformationPasienCB_CT', $data);
        $this->View('templates/footer');
    }
    public function getDataPasien()
    {
        echo json_encode($this->model('B_InformationRekapPasien_Model')->getDataPasien($_POST));
    }
    /*
    public function PrintLMA($notrs = '')
    {
        $data['notrs'] = $notrs; 
        $data['judul'] = 'Informasi LMA';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        $data['listdata1'] = $this->model('B_InformationLma_Model')->printShowDataLMA($data); 
        $this->View('print/information/lma/printLma', $data);
    }
    */
}