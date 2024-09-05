<?php

class aMatchingLaboratorium extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Matching Order Laboratorium';
        $data['judul_child'] = 'View Informasi';
        // $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('informasi/matching/laboratorium/listMatchingOrder_Lab', $data);
        $this->View('templates/footer');
    }

    public function getDataListMatchOrderLab()
    {
        echo json_encode($this->model('aMatchingLaboratorium_Model')->getDataListMatchOrderLab($_POST));
    }
    public function getDataListMatchingLab()
    {
        echo json_encode($this->model('aMatchingLaboratorium_Model')->getDataListMatchingLab($_POST));
    }
    public function goUpdatetblLab()
    {
        echo json_encode($this->model('aMatchingLaboratorium_Model')->goUpdatetblLab($_POST));
    }

    // public function ListRegOrderRadiologi()
    // {
    //     $session = SessionManager::getCurrentSession();
    //     $data['judul'] = 'New Order Radiologi';
    //     $data['judul_child'] = 'View Informasi';
    //     // $data['session'] = $session;
    //     $this->View('templates/header', $session);
    //     $this->View('informasi/registration/Radiologi/ListRegOrderRadiologi', $data);
    //     $this->View('templates/footer');
    // }
}
