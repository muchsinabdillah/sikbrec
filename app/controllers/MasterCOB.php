<?php
class MasterCOB extends Controller{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Data Master COB';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('datamaster/COB/MasterDataCOB_Table', $data);
        $this->View('templates/footer');
    }
    public function getAllDataCOB()
    {
        echo json_encode($this->model('MasterDataCOB_Model')->getAllDataCOB());
    }
    public function viewCOB($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Master COB';
        $data['judul_child'] = 'Input';
        $this->View('templates/header', $session);
        $this->View('datamaster/COB/MasterDataCOB_Entri', $data);
        $this->View('templates/footer');
    }
    public function addCOB(){
        echo json_encode($this->model('MasterDataCOB_Model')->insert($_POST));
    }
    public function getCOBId()
    {
        echo json_encode($this->model('MasterDataCOB_Model')->getCOBId($_POST['id']));
    }

    public function getCOBAktif()
    {
        echo json_encode($this->model('MasterDataCOB_Model')->getCOBAktif());
    }

    public function getCOBAktif_Inacbg()
    {
        echo json_encode($this->model('MasterDataCOB_Model')->getCOBAktif_Inacbg());
    }

    public function GetAdministrasibyGroupJaminan(){
        echo json_encode($this->model('MasterDataKarcis_Model')->GetAdministrasibyGroupJaminan($_POST)); 
    }
    public function GetAdministrasiById()
    {
        echo json_encode($this->model('MasterDataKarcis_Model')->GetAdministrasiById($_POST));
    }
}