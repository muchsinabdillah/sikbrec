<?php
class MasterDataAsuransi extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Data Asuransi';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('datamaster/MasterDataAsuransi/MasterDataAsuransi_Table', $data);
        $this->View('templates/footer');
    }
    public function getAllDataAsuransi()
    {
        echo json_encode($this->model('MasterDataAsuransi_Model')->getAllDataAsuransi());
    }
    public function viewAsuransi($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Asuransi';
        $data['judul_child'] = 'Input';
        $this->View('templates/header', $session);
        $this->View('datamaster/MasterDataAsuransi/MasterDataAsuransi_View', $data);
        $this->View('templates/footer');
    }
    public function addAsuransi()
    {
        echo json_encode($this->model('MasterDataAsuransi_Model')->insert($_POST));
    }
    public function getAsuransiId()
    {
        echo json_encode($this->model('MasterDataAsuransi_Model')->getAsuransiId($_POST['id']));
    }
}
