<?php
class bInfo_Outstanding_icd extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi OutStanding ICD';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/icd/infoOutstanding', $data);
        $this->View('templates/footer');
    }
    public function getDataOutStanding()
    {
        echo json_encode($this->model('B_Info_ICD_Model')->getDataOutStanding($_POST));
    }
}
