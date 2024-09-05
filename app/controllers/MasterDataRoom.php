<?php
class MasterDataRoom extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Data Kamar';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('datamaster/MasterDataBed/MasterDataRoom_Table', $data);
        $this->View('templates/footer');
    }
    public function getAllDataRoom()
    {
        echo json_encode($this->model('MasterDataRoom_Model')->getAllDataRoom());
    }
    public function getAllDataRoomByLantai()
    {
        echo json_encode($this->model('MasterDataRoom_Model')->getAllDataRoomByLantai($_POST));
    }
    public function GosendBPJSReset()
    {
        echo json_encode($this->model('MasterDataRoom_Model')->GosendBPJSReset($_POST));
    }
    public function GosendBPJSAddAll($laintai)
    {
        echo json_encode($this->model('MasterDataRoom_Model')->GosendBPJSAddAll($laintai));
    }
    public function viewRoom($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Kamar';
        $data['judul_child'] = 'Input';
        $this->View('templates/header', $session);
        $this->View('datamaster/MasterDataBed/MasterDataRoom_View', $data);
        $this->View('templates/footer');
    }
    public function addRoom()
    {
        echo json_encode($this->model('MasterDataRoom_Model')->insert($_POST));
    }
    public function getRoomId()
    {
        echo json_encode($this->model('MasterDataRoom_Model')->getRoomId($_POST['id']));
    }
    public function GosendBPJS()
    {
        echo json_encode($this->model('MasterDataRoom_Model')->GosendBPJS($_POST));
    }
    public function GosendBPJSBatal(){
        echo json_encode($this->model('MasterDataRoom_Model')->GosendBPJSBatal($_POST));
    }
    public function GosendBPJSUpdate(){
        echo json_encode($this->model('MasterDataRoom_Model')->GosendBPJSUpdate($_POST));
    }
}