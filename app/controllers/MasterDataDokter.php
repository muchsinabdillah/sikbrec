<?php
class MasterDataDokter extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Data Dokter';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('datamaster/MasterDataDokter/MasterDataDokter_Table', $data);
        $this->View('templates/footer');
    }
    public function getAllDataDokter()
    {
        echo json_encode($this->model('MasterDataDokter_Model')->getAllDataDokter());
    }
    public function getAllDataDokterAktif()
    {
        echo json_encode($this->model('MasterDataDokter_Model')->getAllDataDokterAktif());
    }
    public function viewDokter($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Dokter';
        $data['judul_child'] = 'Input';
        $this->View('templates/header', $session);
        $this->View('datamaster/MasterDataDokter/MasterDataDokter_View', $data);
        $this->View('templates/footer');
    }
    public function addDokter()
    {
        echo json_encode($this->model('MasterDataDokter_Model')->insert($_POST));
    }
    public function getDokterId()
    {
        echo json_encode($this->model('MasterDataDokter_Model')->getDokterId($_POST['id']));
    }
    public function getJobTitle()
    {
        echo json_encode($this->model('MasterDataDokter_Model')->getJobTitle());
    }
    public function getGrupPerawatan()
    {
        echo json_encode($this->model('MasterDataDokter_Model')->getGrupPerawatan());
    }
    public function viewDokterLayanan($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Layanan Dokter';
        $data['judul_child'] = 'Input';
        $this->View('templates/header', $session);
        $this->View('datamaster/MasterDataDokter/MasterDataDokter_Layanan', $data);
        $this->View('templates/footer');
    }
    public function getDataLayanan()
    {
        echo json_encode($this->model('MasterDataDokter_Model')->getDataLayanan($_POST['id']));
    }
    public function addDokterLayanan()
    {
        echo json_encode($this->model('MasterDataDokter_Model')->insert_layanan($_POST));
    }
    public function DeleteDokterLayanan()
    {
        echo json_encode($this->model('MasterDataDokter_Model')->delete_layanan($_POST['id']));
    }
    public function getDokterLaboratorium()
    {
        echo json_encode($this->model('MasterDataDokter_Model')->getDokterLaboratorium());
    }
    public function getDataGroupSpesialis()
    {
        echo json_encode($this->model('MasterDataDokter_Model')->getDataGroupSpesialis());
    }

    //Badrul

    public function uploadFotoDokter($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Dokumen Dokter';
        $data['judul_child'] = 'Upload';
        $this->View('templates/header', $session);
        $this->View('datamaster/MasterDataDokter/MasterDataDokter_Image', $data);
        $this->View('templates/footer');
    }
    public function uploadFotoDokte2($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Dokumen Dokter';
        $data['judul_child'] = 'Upload';
        $this->View('templates/header', $session);
        $this->View('datamaster/MasterDataDokter/MasterDataDokter_Image_fix', $data);
        $this->View('templates/footer');
    }
    public function uploadDataImage()
    {
        echo json_encode($this->model('MasterDataDokter_Model')->uploadDataImage($_POST));
    }

    public function updateDataLanjutanDokter()
    {
        echo json_encode($this->model('MasterDataDokter_Model')->UpdateDataLanjutan($_POST));
    }

    public function uploadFotoDokterx($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Foto Dokter';
        $data['judul_child'] = 'Upload';
        $this->View('templates/header', $session);
        $this->View('datamaster/MasterDataDokter/MasterDataDokter_Image2', $data);
        $this->View('templates/footer');
    }

    public function uploadDataImagex()
    {
        echo json_encode($this->model('MasterDataDokter_Model')->uploadDataImagex($_POST));
    }

    public function getDataTableImage()
    {
        echo json_encode($this->model('MasterDataDokter_Model')->getDataTableImage($_POST));
    }
    public function PostPractitioners(){
        echo json_encode($this->model('MasterDataDokter_Model')->PostPractitioners($_POST));
    }
    public function Savewithout_Image_Dokter(){
        echo json_encode($this->model('MasterDataDokter_Model')->Savewithout_Image_Dokter($_POST));
    }
    
    public function list()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Data Dokter';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('datamaster/MasterDataDokter/DataListDokter', $data);
        $this->View('templates/footer');
    }

}
