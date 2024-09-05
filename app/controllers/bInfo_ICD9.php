<?php
class bInfo_ICD9 extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi ICD 9';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/icd/infoicd9', $data);
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
    public function getDataRekap9()
    {
        echo json_encode($this->model('B_Info_ICD_Model')->getDataRekap9($_POST));
    }
}