<?php
class ReturBeli extends Controller
{
    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id); 
        $data['judul'] = 'Retur Form Entri';
        $data['judul_child'] = 'Input View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/returbeli/ReturBeli_View', $data);
        $this->View('templates/footer');
    }
    public function list()
    {
        $session = SessionManager::getCurrentSession(); 
        $data['judul'] = 'Retur Table List';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/returbeli/ReturBeli_List', $data);
        $this->View('templates/footer');
    }

    public function getReturBelibyDateUser(){
        echo json_encode($this->model('I_ReturBeli_Model')->getReturBelibyDateUser($_POST));
    }

    public function addReturBeliHeader(){
        echo json_encode($this->model('I_ReturBeli_Model')->addReturBeliHeader($_POST));
    }

    public function addReturBeliFinish(){
        echo json_encode($this->model('I_ReturBeli_Model')->addReturBeliFinish($_POST));
    }

    public function getReturBelibyID(){
        echo json_encode($this->model('I_ReturBeli_Model')->getReturBelibyID($_POST));
    }

    public function getReturBeliDetailbyID(){
        echo json_encode($this->model('I_ReturBeli_Model')->getReturBeliDetailbyID($_POST));
    }

    public function voidReturBeli(){
        echo json_encode($this->model('I_ReturBeli_Model')->voidReturBeli($_POST));
    }

    public function voidReturBeliDetailbyItem(){
        echo json_encode($this->model('I_ReturBeli_Model')->voidReturBeliDetailbyItem($_POST));
    }

    
    
}
