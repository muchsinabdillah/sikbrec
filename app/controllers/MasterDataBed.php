<?php
class MasterDataBed extends Controller{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Data Bed';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('datamaster/MasterDataBed/MasterDataBed_Table', $data);
        $this->View('templates/footer');
    }
    public function getAllDataBed()
    {
        echo json_encode($this->model('MasterDataBed_Model')->getAllDataBed());
    }
    public function getAllDataBedbyLantai(){
        echo json_encode($this->model('MasterDataBed_Model')->getAllDataBedbyLantai($_POST));
    }
    public function viewBed($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Bed';
        $data['judul_child'] = 'Input';
        $this->View('templates/header', $session);
        $this->View('datamaster/MasterDataBed/MasterDataBed_View', $data);
        $this->View('templates/footer');
    }
    public function addBed(){
        echo json_encode($this->model('MasterDataBed_Model')->insert($_POST));
    }
    public function getBedId()
    {
        echo json_encode($this->model('MasterDataBed_Model')->getBedId($_POST['id']));
    }
    public function getClass()
    {
        echo json_encode($this->model('MasterDataBed_Model')->getClass());
    }public function getKDPDP()
    {
        echo json_encode($this->model('MasterDataBed_Model')->getKDPDP());
    }
    public function getRoom()
    {
        echo json_encode($this->model('MasterDataBed_Model')->getRoom());
    }
    public function getJenisRawat()
    {
        echo json_encode($this->model('MasterDataBed_Model')->getJenisRawat());
    }
}