<?php

class aAntrianCaller extends Controller
{

    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id); 
        $data['judul'] = 'Adjusment';
        $data['judul_child'] = 'Input View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/adjusment/Adjusment_View', $data);
        $this->View('templates/footer');
    }
    public function pendaftaran()
    {
        $session = SessionManager::getCurrentSession(); 
        $data['judul'] = 'Antrian Pendaftaran';
        $data['judul_child'] = 'List Antrian Pendaftaran';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('antriancaller/pendaftaran/list', $data);
        $this->View('templates/footer');
    }
    public function getIpCounter(){
        echo json_encode($this->model('A_AntrianCaller_Model')->getIpCounter($_POST));
    }
    public function getListAntrian(){
        echo json_encode($this->model('A_AntrianCaller_Model')->getListAntrian($_POST));
    }
    public function gocallantrian(){
        echo json_encode($this->model('A_AntrianCaller_Model')->gocallantrian($_POST));
    }
    public function goholdAntrian(){
        echo json_encode($this->model('A_AntrianCaller_Model')->goholdAntrian($_POST));
    }
    public function goproccessAntrian(){
        echo json_encode($this->model('A_AntrianCaller_Model')->goproccessAntrian($_POST));
    }
    public function goFinishAntrian(){
        echo json_encode($this->model('A_AntrianCaller_Model')->goFinishAntrian($_POST));
    }
    
}