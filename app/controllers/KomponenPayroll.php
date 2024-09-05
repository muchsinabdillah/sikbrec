<?php
class KomponenPayroll extends Controller{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Komponen Payroll';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('datamaster/KomponenPayroll/KomponenPayroll_View', $data);
        $this->View('templates/footer');
    }
    public function getAllKomponenPayroll()
    {
        echo json_encode($this->model('KomponenPayroll_Model')->getAllKomponenPayroll());
    }
    public function viewKomponenPayroll($id = null){
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Komponen Payroll';
        $data['judul_child'] = 'Input';
        $this->View('templates/header', $session);
        $this->View('datamaster/KomponenPayroll/KomponenPayroll', $data);
        $this->View('templates/footer');
    }
    public function addKomponenPayroll(){
        echo json_encode($this->model('KomponenPayroll_Model')->insert($_POST));
    }
    public function getKomponenPayrollById()
    {
        echo json_encode($this->model('KomponenPayroll_Model')->getKomponenPayrollById($_POST['id']));
    }
}