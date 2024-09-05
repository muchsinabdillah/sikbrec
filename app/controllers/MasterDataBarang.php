<?php
class MasterDataBarang extends Controller
{
    public function list()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Master Data Barang';
        $data['judul_child'] = 'list';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('inventory/barang/MasterBarang_list', $data);
        $this->View('templates/footer');
    }
    public function viewMasterDataBarang($id = null)
    {
        // var_dump("ssss");
        // exit;
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Master Data Barang ';
        $data['judul_child'] = 'Input';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('inventory/barang/MasterBarang_view', $data);
        $this->View('templates/footer');
    }
    public function getBarangAll()
    {
        echo json_encode($this->model('I_Masterdata_Barang_Model')->getBarangAll());
    }
    public function getKelompokBarang()
    {
        echo json_encode($this->model('I_Masterdata_Barang_Model')->getKelompokBarang());
    }
    public function showkelompokBarangAll()
    {
        echo json_encode($this->model('I_Masterdata_Kelompok_Model')->showkelompokBarangAll());
    }
    public function showFormulariumBarangAll()
    {
        echo json_encode($this->model('I_MasterData_Formularium_Model')->showFormulariumBarangAll());
    }
    public function showSupplierAll()
    {
        echo json_encode($this->model('I_MasterData_Supplier_Model')->showSupplierAll());
    }
    public function getBarangbyId()
    {
        echo json_encode($this->model('I_Masterdata_Barang_Model')->getBarangbyId($_POST));
    }

    public function addBarang()
    {
        echo json_encode($this->model('I_Masterdata_Barang_Model')->addBarang($_POST));
    }

    public function editBarang()
    {
        echo json_encode($this->model('I_Masterdata_Barang_Model')->editBarang($_POST));
    }

    public function addBarangSupplier()
    {
        echo json_encode($this->model('I_Masterdata_Barang_Model')->addBarangSupplier($_POST));
    }

    public function getBarangbySuppliers()
    {
        echo json_encode($this->model('I_Masterdata_Barang_Model')->getBarangbySuppliers($_POST));
    }

    public function addBarangFormularium()
    {
        echo json_encode($this->model('I_Masterdata_Barang_Model')->addBarangFormularium($_POST));
    }

    public function getBarangbyFormulariums()
    {
        echo json_encode($this->model('I_Masterdata_Barang_Model')->getBarangbyFormulariums($_POST));
    }

    public function deleteBarangSupplier()
    {
        echo json_encode($this->model('I_Masterdata_Barang_Model')->deleteBarangSupplier($_POST));
    }

    public function deleteBarangFormularium()
    {
        echo json_encode($this->model('I_Masterdata_Barang_Model')->deleteBarangFormularium($_POST));
    }

    public function getHistoryHargaBeli()
    {
        echo json_encode($this->model('I_Masterdata_Barang_Model')->getHistoryHargaBeli($_POST));
    }

    public function getHistoryHargaJual()
    {
        echo json_encode($this->model('I_Masterdata_Barang_Model')->getHistoryHargaJual($_POST));
    }
    
    public function getDataPaketbyNameLike()
    {
        echo json_encode($this->model('I_Masterdata_Barang_Model')->getDataPaketbyNameLike($_POST));
    }
    
    public function getDataPaketDetailbyIDHdr()
    {
        echo json_encode($this->model('I_Masterdata_Barang_Model')->getDataPaketDetailbyIDHdr($_POST));
    }

    
}
