<?php
class BPJS_WaktuAntrian extends Controller
{
    public function WaktuAntrian($noreg = '',$taskid = '')
    {
        //$session = SessionManager::getCurrentSession();
        $data['noreg'] = $noreg; 
        $data['taskid'] = $taskid; 
        // $data['judul'] = 'Monitoring Kunjungan Pasien BPJS Kesehatan';
        // $data['judul_child'] = 'List View';
       // $data['session'] = $session;
        $this->View('templates/header_login',null);
        $this->View('bridgingbpjs/waktu_antrian/waktuantrian_v2', $data);
        $this->View('templates/footer');
    }

    public function UpdateWaktuAntrian()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->UpdateWaktuAntrian($_POST));
    }
}
