<?php
class GenerateAbsensi extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Generate Absensi Pegawai';
        $data['judul_child'] = 'Input';
        $this->View('templates/header', $session);
        $this->View('hrd/absensi/GenerateAbsensi', $data);
        $this->View('templates/footer');
    }
    public function GenrateAbsensiAll()
    {
        echo json_encode($this->model('GenerateAbsensi_Model')->GenrateAbsensiAll($_POST));
    }
    public function ShowDataAfterGenerate()
    {
        echo json_encode($this->model('GenerateAbsensi_Model')->ShowDataAfterGenerate($_POST));
    }
    public function ShowDataAfterGeneratebyIdPegawai()
    {
        echo json_encode($this->model('GenerateAbsensi_Model')->ShowDataAfterGeneratebyIdPegawai($_POST));
    }

    
    
}