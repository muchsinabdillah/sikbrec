<?php
class Shift extends Controller{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Shift';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('datamaster/Shift/Shift_View', $data);
        $this->View('templates/footer');
    }
    public function viewShift($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Shift';
        $data['judul_child'] = 'Input';
        $this->View('templates/header', $session);
        $this->View('datamaster/Shift/Shift', $data);
        $this->View('templates/footer');
    }
    public function getAllShifts()
    {
        echo json_encode($this->model('Shift_Model')->getAllShift());
    }
    public function addShift()
    {
        echo json_encode($this->model('Shift_Model')->insert($_POST));
    }
    public function getShiftById()
    {
        echo json_encode($this->model('Shift_Model')->getShiftById($_POST['id']));
    }
}