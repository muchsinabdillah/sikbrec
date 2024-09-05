<?php
class MasterKelompokBarang extends Controller
{
    public function list()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Master Kelompok Barang';
        $data['judul_child'] = 'list';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('inventory/barang/MasterKelompok_List', $data);
        $this->View('templates/footer');
    }
    public function viewMasterKelompokBarang($id = null)
    {
        // var_dump("ssss");
        // exit;
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);

        $data['judul'] = 'Master Kelompok Barang ';
        $data['judul_child'] = 'Input';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('inventory/barang/MasterKelompok_view', $data);
        $this->View('templates/footer');
    }
    public function showkelompokBarangAll()
    {
        echo json_encode($this->model('I_Masterdata_Kelompok_Model')->showkelompokBarangAll());
    }
    public function GetKelompokbyID()
    {
        echo json_encode($this->model('I_Masterdata_Kelompok_Model')->GetKelompokbyID($_POST));
    }
    public function addKelompok()
    {
        echo json_encode($this->model('I_Masterdata_Kelompok_Model')->addKelompok($_POST));
    }
    public function editKelompok()
    {
        echo json_encode($this->model('I_Masterdata_Kelompok_Model')->editKelompok($_POST));
    }
}
