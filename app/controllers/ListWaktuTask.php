<?php
class ListWaktuTask extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Waktu Task Antrian';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('bridgingbpjs/antrianonline/listwaktutask', $data);
        $this->View('templates/footer');
    }
    public function GoListWaktuTask()
    {
        echo json_encode($this->model('B_Bridging_Antrian_Online_Model')->GoListWaktuTask($_POST));
    }
    public function GetReferensiDokter()
    {
        echo json_encode($this->model('B_Bridging_Antrian_Online_Model')->GetReferensiDokter($_POST));
    }
}
