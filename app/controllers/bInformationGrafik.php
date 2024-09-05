<?php
class bInformationGrafik extends Controller 
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Grafik BPJS';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/grafik/InfoGrafikBPJS', $data);
        $this->View('templates/footer');
    }
    public function getDataListPasien(){
        echo json_encode($this->model('B_InformationRekapPasien_Model')->getDataListPasien($_POST));
    }

    public function ShowGrafikPoliBPJS(){
        echo json_encode($this->model('B_InformationGrafik_Model')->ShowGrafikPoliBPJS($_POST));
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
