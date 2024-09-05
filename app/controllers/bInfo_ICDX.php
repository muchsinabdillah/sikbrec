<?php
class bInfo_ICDX extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi ICD 10';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/icd/infoicdX', $data);
        $this->View('templates/footer');
    }
    public function getListPoli()
    {
        echo json_encode($this->model('B_Info_ICD_Model')->getListPoli($_POST));
    }
    public function getDokter()
    {
        echo json_encode($this->model('B_Info_ICD_Model')->getDokter($_POST));
    }
    public function getDataRekap()
    {
        echo json_encode($this->model('B_Info_ICD_Model')->getDataRekap($_POST));
    }
}
