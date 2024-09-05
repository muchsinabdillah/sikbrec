<?php
class GroupShift extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Group Shift';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('datamaster/GroupShift/Group_Shift_View',$data);
        $this->View('templates/footer');
       
    }
    public function viewGroupShift($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Group Shift';
        $data['judul_child'] = 'Input';
        $this->View('templates/header', $session);
        $this->View('datamaster/GroupShift/Group_Shift', $data);
        $this->View('templates/footer');
    }
    public function addGroupShift()
    {
        echo json_encode($this->model('GroupShift_Model')->insert($_POST)); 
    }
    public function getAllGroupShifts(){
        echo json_encode($this->model('GroupShift_Model')->getAllGroupShift());
    }
    public function getGroupShiftById(){
        echo json_encode($this->model('GroupShift_Model')->getGroupShiftById($_POST['id']));
    }
    public function getGroupShiftCombo()
    { 
        echo json_encode(["status" => "success", "data" => $this->model('GroupShift_Model')->getGroupShiftCombo()], 200); 
    }
    
}
