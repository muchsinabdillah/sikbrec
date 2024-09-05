<?php
 
class MasterIPUnitFarmasi extends Controller
{
    public function index($id = null)
    {
        $data['id'] =  Utils::setDecode($id); 
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Data View Printer Label';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/masteripunitfarmasi/MasterIPUnitFarmasi_View', $data);
        $this->View('templates/footer');
    }

    public function List()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Data List Printer Label';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/masteripunitfarmasi/MasterIPUnitFarmasi_List', $data);
        $this->View('templates/footer');
    }
    
    public function showAll(){
        echo json_encode($this->model('I_MasterIPUnitFarmasi_Model')->showAll());
    }
    public function getData(){
        echo json_encode($this->model('I_MasterIPUnitFarmasi_Model')->getData($_POST));
    }
    public function addData(){
        echo json_encode($this->model('I_MasterIPUnitFarmasi_Model')->addData($_POST));
    }
    public function editData(){
        echo json_encode($this->model('I_MasterIPUnitFarmasi_Model')->editData($_POST));
    }
} 