<?php
// use hari; 
class dataRumahSakit extends Controller
{
    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['ID'] =  null;

        $data['judul'] = 'Data Rumah Sakit';
        // $data['judul_child'] = 'Rawat inap';
        // $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('datars/DataRSListInput', $data);
        $this->View('templates/footer');
    }
    public function list()
    {
        $session = SessionManager::getCurrentSession();

        $data['judul'] = 'Data Rumah Sakit';
        $data['judul_child'] = 'Data Rumah Sakit List';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('datars/DataRSList', $data);
        $this->View('templates/footer');
    }
    public function viewOrderDarah($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['iduseblood'] =  null;
        $data['judul'] = 'Bank Darah';
        $data['judul_child'] = 'Form Input';
        $data['session'] = $session;
        // $data['hari'] = $this->hari_ini(); 
        $this->View('templates/header', $session);
        $this->View('informasi/registration/ODC/viewOrderDarah', $data);
        $this->View('templates/footer');
    }
    public function GetDataRumahSakit()
    {
        echo json_encode($this->model('B_dataRs_Model')->GetDataRumahSakit($_POST['id']));
    }
    public function getDataListRS()
    {
        echo json_encode($this->model('B_dataRs_Model')->getDataListRS($_POST));
    }
    public function getProvinsi()
    {
        echo json_encode($this->model('B_dataRs_Model')->getProvinsi());
    }
    public function GetKabupaten()
    {
        echo json_encode($this->model('B_dataRs_Model')->GetKabupaten($_POST));
    }
    public function GetKecamatan()
    {
        echo json_encode($this->model('B_dataRs_Model')->GetKecamatan($_POST));
    }
    public function GetKelurahan()
    {
        echo json_encode($this->model('B_dataRs_Model')->GetKelurahan($_POST));
    }
    public function GetKodepos()
    {
        echo json_encode($this->model('B_dataRs_Model')->GetKodepos($_POST));
    }
    public function updateDataRS()
    {
        echo json_encode($this->model('B_dataRs_Model')->updateDataRS($_POST));
    }
}
