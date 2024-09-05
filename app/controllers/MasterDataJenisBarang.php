<?php
class MasterDataJenisBarang extends Controller
{
    public function list()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Master Data Jenis Barang';
        $data['judul_child'] = 'list';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('inventory/barang/JenisBarang_list', $data);
        $this->View('templates/footer');
    }
    public function viewMasterJenisBarang($id = null)
    {
        // var_dump("ssss");
        // exit;
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);

        $data['judul'] = 'Master Data Jenis Barang ';
        $data['judul_child'] = 'Input';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('inventory/barang/JenisBarang_view', $data);
        $this->View('templates/footer');
    }
    public function addJenis()
    {
        echo json_encode($this->model('I_Masterdata_Jenis_Model')->addJenis($_POST));
    }
    public function showJenisAll()
    {
        echo json_encode($this->model('I_Masterdata_Jenis_Model')->showJenisAll());
    }
    public function getJenisbyId()
    {
        echo json_encode($this->model('I_Masterdata_Jenis_Model')->getJenisbyId($_POST));
    }
    public function editJenis()
    {
        echo json_encode($this->model('I_Masterdata_Jenis_Model')->editJenis($_POST));
    }
}
