<?php
class bInformationLma extends Controller 
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi LMA Pasien';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/registration/lma/InformationLma', $data);
        $this->View('templates/footer');
    }
    public function getDataListLmaPasien(){
        echo json_encode($this->model('B_InformationLma_Model')->getDataListLmaPasien($_POST));
    }
    public function PrintLMA($notrs = '')
    {
        $data['notrs'] = $notrs; 
        $data['judul'] = 'Informasi LMA';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        $data['listdata1'] = $this->model('B_InformationLma_Model')->printShowDataLMA($data); 
        $this->View('print/information/lma/printLma', $data);
    }
}
