<?php
class MasterDataKarcis extends Controller{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Data Karcis Administrasi';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('datamaster/MasterDataKarcis/MasterDataKarcis_Table', $data);
        $this->View('templates/footer');
    }
    public function getAllDataKarcis()
    {
        echo json_encode($this->model('MasterDataKarcis_Model')->getAllDataKarcis());
    }
    public function viewKarcis($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Karcis Administrasi';
        $data['judul_child'] = 'Input';
        $this->View('templates/header', $session);
        $this->View('datamaster/MasterDataKarcis/MasterDataKarcis_View', $data);
        $this->View('templates/footer');
    }
    public function addKarcis(){
        echo json_encode($this->model('MasterDataKarcis_Model')->insert($_POST));
    }
    public function getKarcisId()
    {
        echo json_encode($this->model('MasterDataKarcis_Model')->getKarcisId($_POST['id']));
    }
    public function GetAdministrasibyGroupJaminan(){
        echo json_encode($this->model('MasterDataKarcis_Model')->GetAdministrasibyGroupJaminan($_POST)); 
    }
    public function GetAdministrasiById()
    {
        echo json_encode($this->model('MasterDataKarcis_Model')->GetAdministrasiById($_POST));
    }
}