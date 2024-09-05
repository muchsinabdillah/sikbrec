<?php
class Jabatan extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Jabatan';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('datamaster/Jabatan/Jabatan_View', $data);
        $this->View('templates/footer');
    }
    public function getAllJabatan()
    {
        echo json_encode($this->model('Jabatan_Model')->getAllJabatan());
    }
    public function viewJabatan($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Jabatan';
        $data['judul_child'] = 'Input';
        $this->View('templates/header', $session);
        $this->View('datamaster/Jabatan/Jabatan', $data);
        $this->View('templates/footer');
    }
    public function addJabatan()
    {
        echo json_encode($this->model('Jabatan_Model')->insert($_POST));
    }
    public function getJabatanId()
    {
        echo json_encode($this->model('Jabatan_Model')->getJabatanId($_POST['id']));
    }
}
