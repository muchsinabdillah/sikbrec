<?php
class TarifKamar extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Data Tarif Kamar';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('datamaster/MasterTarifKamar/MasterDataTarifKamr_Table', $data);
        $this->View('templates/footer');
    }
    public function getAllTarifKamar()
    {
        echo json_encode($this->model('TarifKamar_Model')->getAllTarifKamar());
    }
    public function getAllTarifKamarByGroupTarif()
    {
        echo json_encode($this->model('TarifKamar_Model')->getAllTarifKamarByGroupTarif($_POST));
    }
    public function viewTarifKamar($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Tarif Kamar';
        $data['judul_child'] = 'Input';
        $this->View('templates/header', $session);
        $this->View('datamaster/MasterTarifKamar/MasterDataTarifKamar_View', $data);
        $this->View('templates/footer');
    }
    public function addTarifRoom()
    {
        echo json_encode($this->model('TarifKamar_Model')->insert($_POST));
    }
    public function getTarifRoomId()
    {
        echo json_encode($this->model('TarifKamar_Model')->getTarifRoomId($_POST['id']));
    }
    public function GosendBPJS()
    {
        echo json_encode($this->model('TarifKamar_Model')->GosendBPJS($_POST));
    }
    public function GosendBPJSBatal()
    {
        echo json_encode($this->model('TarifKamar_Model')->GosendBPJSBatal($_POST));
    }
}
