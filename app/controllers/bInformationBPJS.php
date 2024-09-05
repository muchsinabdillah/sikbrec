<?php
class bInformationBPJS extends Controller 
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi BPJS';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/registration/BPJS/InformationBPJS', $data);
        $this->View('templates/footer');
    }
    public function getDataListRekamMedikPasien(){
        echo json_encode($this->model('B_InformationBPJS_Model')->getDataListPasien($_POST));
    }
    public function getIDDokter()
    {
        echo json_encode($this->model('B_InformationRekamMedik_Model')->getIDDokter());
    }

    public function InfoMonitoringBPJS()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Monitoring BPJS';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/registration/BPJS/InformationMonitoringBPJS', $data);
        $this->View('templates/footer');
    }
    public function getDataMonitoringBPJS(){
        echo json_encode($this->model('B_InformationBPJS_Model')->getDataMonitoringBPJS($_POST));
    }
}
