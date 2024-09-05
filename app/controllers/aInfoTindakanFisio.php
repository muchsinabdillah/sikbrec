<?php
class aInfoTindakanFisio extends Controller 
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Info Tindakan Fisio';
        $data['judul_child'] = 'View Informasi';
        // $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('InfoTindakanFisio/InfoTindakanFisio', $data);
        $this->View('templates/footer');
    }

    // public function getDataSensusPPI()
    // {
    //     echo json_encode($this->model('aPPI_Model')->getDataSensusPPI());
    // }

    public function getDataListInfoTindakanFisio(){
        echo json_encode($this->model('aInfoTindakanFisio_Model')->getDataListInfoTindakanFisio($_POST));
    }
    
}