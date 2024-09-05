<?php
class StatusPegawai extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Status Pegawai';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('datamaster/StatusPegawai/StatusPegawai_View',$data);
        $this->View('templates/footer');
       
    }
    public function getAllStatusPegawai()
    {
        echo json_encode($this->model('StatusPegawai_Model')->getAllStatusPegawai());
    }
    public function viewStatusPegawai($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Status Pegawai';
        $data['judul_child'] = 'Input';
        $this->View('templates/header', $session);
        $this->View('datamaster/StatusPegawai/StatusPegawai', $data);
        $this->View('templates/footer');
    }
    public function addStatusPegawai()
    {
        echo json_encode($this->model('StatusPegawai_Model')->insert($_POST));
    }
    public function getStatusPegawaiId()
    {
        echo json_encode($this->model('StatusPegawai_Model')->getStatusPegawaiId($_POST['id']));
    }
}