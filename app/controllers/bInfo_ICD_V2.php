<?php
class bInfo_ICD_V2 extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi ICD Detail V2';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/icd/infoicdDetail', $data);
        $this->View('templates/footer');
    }
    public function getDataICDDetail()
    {
        echo json_encode($this->model('B_Info_ICD_Model')->getDataICDDetail($_POST));
    }
}
