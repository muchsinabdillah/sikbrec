<?php

class aInfoEklaim extends Controller 
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Info Eklaim';
        $data['judul_child'] = 'List Informasi';
        // $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('Eklaim/InfoEklaim_View', $data);
        $this->View('templates/footer');
    }

    public function getDataListInfo(){
        echo json_encode($this->model('aInfoEklaim_Model')->getDataListInfo($_POST));
    }

    public function detail()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Detail Rekap';
        $data['judul_child'] = 'List Informasi';
        // $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('Eklaim/detailEklaim_View', $data);
        $this->View('templates/footer');
    }

    public function getDataListInfoDetail(){
        echo json_encode($this->model('aInfoEklaim_Model')->getDataListInfoDetail($_POST));
    }


}