<?php
class Lembur extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Lembur Pegawai';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('hrd/absensi/LemburList', $data);
        $this->View('templates/footer');
    }
    public function viewForm($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Lembur Pegawai';
        $data['judul_child'] = 'Input Lembur Pegawai';
        $this->View('templates/header', $session);
        $this->View('hrd/absensi/LemburForm', $data);
        $this->View('templates/footer');
    } 
    public function showDataTrsLemburAll(){
        echo json_encode($this->model('Lembur_Model')->showDataTrsLemburAll($_POST)); 
    }
    public function ShowDatalemburByID(){
        echo json_encode($this->model('Lembur_Model')->ShowDatalemburByID($_POST)); 
    }
    public function CreateLembur(){
        echo json_encode($this->model('Lembur_Model')->CreateLembur($_POST)); 
    }
    public function BatalLembur(){
        echo json_encode($this->model('Lembur_Model')->BatalLembur($_POST)); 
    }
    public function showDataTrsLemburAllbyJO()
    {
        echo json_encode($this->model('Lembur_Model')->showDataTrsLemburAllbyJO($_POST));
    }
    public function showDataTrsLemburAllbyJOPeg(){
        echo json_encode($this->model('Lembur_Model')->showDataTrsLemburAllbyJOPeg($_POST));
    }
    public function getDataJamLemburDefault()
    {
        echo json_encode($this->model('Lembur_Model')->getDataJamLemburDefault($_POST));
    }
}
