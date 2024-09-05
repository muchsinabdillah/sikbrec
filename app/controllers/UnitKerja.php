<?php
class UnitKerja extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Unit Kerja';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('datamaster/UnitKerja/UnitKerja_View', $data);
        $this->View('templates/footer');
    }
    public function getAllUnitKerja()
    {
        echo json_encode($this->model('UnitKerja_Model')->getAllUnitKerja());
    }
    public function viewUnitKerja($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Unit Kerja';
        $data['judul_child'] = 'Input';
        $this->View('templates/header', $session);
        $this->View('datamaster/UnitKerja/UnitKerja', $data);
        $this->View('templates/footer');
    }
    public function addUnitKerja()
    {
        echo json_encode($this->model('UnitKerja_Model')->insert($_POST));
    }
    public function getUnitKerjaId()
    {
        echo json_encode($this->model('UnitKerja_Model')->getUnitKerjaId($_POST['id']));
    }
}
