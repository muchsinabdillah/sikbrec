<?php
class MasterDataJadwalDokter extends Controller{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Data Jadwal Dokter';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('datamaster/MasterDataJadwalDokter/MasterDataJadwalDokter_Table', $data);
        $this->View('templates/footer');
    }

    
    public function getAllDataJadwalDokter()
    {
        echo json_encode($this->model('MasterDataJadwalDokter_Model')->getAllDataJadwalDokter());
    }
    public function getAllDataJadwalDokterr()
    {
        echo json_encode($this->model('MasterDataJadwalDokter_Model')->getAllDataJadwalDokterr($_POST));
    }
    public function viewJadwalDokter($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Jadwal Dokter';
        $data['judul_child'] = 'Input';
        $this->View('templates/header', $session);
        $this->View('datamaster/MasterDataJadwalDokter/MasterDataJadwalDokter_View', $data);
        $this->View('templates/footer');
    }
    public function addJadwalDokter(){
        $headerdo = $this->model('MasterDataJadwalDokter_Model');
        $jadwalService = new JadwalAbsensi_Service($headerdo);
        echo json_encode($jadwalService->addJadwalDokter($_POST));
    }
    public function getJadwalDokterId()
    {
        echo json_encode($this->model('MasterDataJadwalDokter_Model')->getJadwalDokterId($_POST['id']));
    }
    public function getIDDokter()
    {
        echo json_encode($this->model('MasterDataJadwalDokter_Model')->getIDDokter($_POST['idpoli']));
    }
    public function getSession()
    {
        echo json_encode($this->model('MasterDataJadwalDokter_Model')->getSession($_POST['jam']));
    }
    public function getShift()
    {
        echo json_encode($this->model('MasterDataJadwalDokter_Model')->getShift());
    }

    public function getSessionDokter()
    {
        echo json_encode($this->model('MasterDataJadwalDokter_Model')->getJamDokterPraktekRegistrasi($_POST));
    }

    public function getNamaSessionDokter()
    {
        echo json_encode($this->model('MasterDataJadwalDokter_Model')->getNamaSessionDokter($_POST));
    }
    public function listgen2()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Data Jadwal Dokter';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('datamaster/MasterDataJadwalDokter/MasterDataJadwalDokter_table_gen2', $data);
        $this->View('templates/footer');
    }

    
}
