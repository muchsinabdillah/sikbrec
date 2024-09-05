<?php
class Department extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Department';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('datamaster/department/Department_View',$data);
        $this->View('templates/footer');
       
    }
    public function getAllDepartment()
    {
        echo json_encode($this->model('Department_Model')->getAllDepartment());
    }
    public function viewDepartment($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Department';
        $data['judul_child'] = 'Input';
        $this->View('templates/header', $session);
        $this->View('datamaster/department/Department', $data);
        $this->View('templates/footer');
    }
    public function addDepartment()
    {
        echo json_encode($this->model('Department_Model')->insert($_POST));
    }
    public function getDepartmentId(){
        echo json_encode($this->model('Department_Model')->getDepartmentId($_POST['id']));
    }
}