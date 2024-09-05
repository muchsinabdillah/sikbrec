<?php

class aMatchingRadiologi extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Matching Order Radiologi';
        $data['judul_child'] = 'View Informasi';
        // $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('informasi/matching/radiologi/listMatchingOrder_Rad', $data);
        $this->View('templates/footer');
    }

    public function getDataListMatchOrderRad()
    {
        echo json_encode($this->model('aMatchingRadiologi_Model')->getDataListMatchOrderRad($_POST));
    }
    public function getDataListMatchingRad()
    {
        echo json_encode($this->model('aMatchingRadiologi_Model')->getDataListMatchingRad($_POST));
    }
    public function goUpdateWORad()
    {
        echo json_encode($this->model('aMatchingRadiologi_Model')->goUpdateWORad($_POST));
    }
}
