<?php
class MasterDataPabrik extends Controller
{
    public function list()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Master Data Pabrik';
        $data['judul_child'] = 'list';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('inventory/barang/Pabrik_list', $data);
        $this->View('templates/footer');
    }
    public function viewMasterPabrik($id = null)
    {
        // var_dump("ssss");
        // exit;
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);

        $data['judul'] = 'Master Data Pabrik ';
        $data['judul_child'] = 'Input';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('inventory/barang/Pabrik_view', $data);
        $this->View('templates/footer');
    }
    public function addPabrik()
    {
        echo json_encode($this->model('I_Masterdata_Pabrik_Model')->addPabrik($_POST));
    }
    public function showPabrikAll()
    {
        echo json_encode($this->model('I_Masterdata_Pabrik_Model')->showPabrikAll());
    }
    public function getPabrikbyId()
    {
        echo json_encode($this->model('I_Masterdata_Pabrik_Model')->getPabrikbyId($_POST));
    }
    public function editPabrik()
    {
        echo json_encode($this->model('I_Masterdata_Pabrik_Model')->editPabrik($_POST));
    }
}
