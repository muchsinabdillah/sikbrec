<?php
class bInformationMPP extends Controller 
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi MPP';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/registration/MPP/InformationMPP', $data);
        $this->View('templates/footer');
    }

    public function getDataListA(){
        echo json_encode($this->model('B_InformationMPP_Model')->getDataListA($_POST));
    }

    public function getDataListB(){
        echo json_encode($this->model('B_InformationMPP_Model')->getDataListB($_POST));
    }
}
