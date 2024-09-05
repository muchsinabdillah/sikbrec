<?php
class DashboardAntrianBPJS extends Controller
{
    public function dashboardpertgl()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Dashboard per Tanggal';
        $data['judul_child'] = 'Dashboard per Tanggal';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('bridgingbpjs/antrianonline/dashboardper_tanggal', $data);
        $this->View('templates/footer');
    }
    public function dashboardperbulan()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Dashboard per Bulan';
        $data['judul_child'] = 'Dashboard per Bulan';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('bridgingbpjs/antrianonline/dashboardper_bulan', $data);
        $this->View('templates/footer');
    }
    public function Dashboardper_Tanggal()
    {
        echo json_encode($this->model('B_Bridging_Antrian_Online_Model')->Dashboardper_Tanggal($_POST));
    }
    public function Dashboardper_Bulan()
    {
        echo json_encode($this->model('B_Bridging_Antrian_Online_Model')->Dashboardper_Bulan($_POST));
    }
    public function antreanBelumDilayani()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Dashboard Antrean Belum Dilayani BPJS Kesehatan';
        $data['judul_child'] = 'Dashboard Antrean Belum Dilayani BPJS Kesehatan';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('bridgingbpjs/antrianonline/antreanBelumDilayani', $data);
        $this->View('templates/footer');
    }
    public function antreanPertanggal()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Dashboard Antrean Per Tanggal BPJS Kesehatan';
        $data['judul_child'] = 'Dashboard Antrean Per Tanggal BPJS Kesehatan';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('bridgingbpjs/antrianonline/antreanPertanggal', $data);
        $this->View('templates/footer');
    }
    public function get_antreanPertanggal()
    {
        echo json_encode($this->model('B_Bridging_Antrian_Online_Model')->get_antreanPertanggal($_POST));
    }
    public function Dashboardper_Bulan_belumdilayani(){
        echo json_encode($this->model('B_Bridging_Antrian_Online_Model')->get_antreanBulanBelumdilayani($_POST));
    }
}
