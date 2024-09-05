<?php
class KunjunganSEPInternal extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Monitoring Data SEP Internal';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('bridgingbpjs/monitoring/monitoringsepinternal', $data);
        $this->View('templates/footer');
    }
    public function GoMonitoringDataSEPInernalBPJS()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->GoMonitoringDataSEPInernalBPJS($_POST));
    }
}
 