<?php
// use hari; 
class bInfoBankDarah extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Order Bank Darah';
        $data['judul_child'] = 'Informasi Bank Darah';
        // $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('informasi/registration/ODC/InfoBankDarah', $data);
        $this->View('templates/footer');
    }
    public function getDataInfoIndikatorWaktu()
    {
        echo json_encode($this->model('aInfoBankDarah_Model')->getDataInfoIndikatorWaktu($_POST));
    }
    public function getDataInfoIndikatorQTY()
    {
        echo json_encode($this->model('aInfoBankDarah_Model')->getDataInfoIndikatorQTY($_POST));
    }
}
