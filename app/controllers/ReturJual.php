<?php
class ReturJual extends Controller
{
    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id); 
        $data['judul'] = 'Retur Jual Form Entri';
        $data['judul_child'] = 'Input View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/returjual/ReturJual_View', $data);
        $this->View('templates/footer');
    }
    public function list()
    {
        $session = SessionManager::getCurrentSession(); 
        $data['judul'] = 'Retur Jual Table List';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/returjual/ReturJual_List', $data);
        $this->View('templates/footer');
    }

    public function getReturJualbyDateUser(){
        echo json_encode($this->model('I_ReturJual_Model')->getReturJualbyDateUser($_POST));
    }

    public function addReturJualHeader(){
        echo json_encode($this->model('I_ReturJual_Model')->addReturJualHeader($_POST));
    }

    public function addReturJualFinish(){
        echo json_encode($this->model('I_ReturJual_Model')->addReturJualFinish($_POST));
    }

    public function getReturJualbyID(){
        echo json_encode($this->model('I_ReturJual_Model')->getReturJualbyID($_POST));
    }

    public function getReturJualDetailbyID(){
        echo json_encode($this->model('I_ReturJual_Model')->getReturJualDetailbyID($_POST));
    }

    public function voidReturJual(){
        echo json_encode($this->model('I_ReturJual_Model')->voidReturJual($_POST));
    }

    public function voidReturJualDetailbyItem(){
        echo json_encode($this->model('I_ReturJual_Model')->voidReturJualDetailbyItem($_POST));
    }

    public function listreg()
    {
        $session = SessionManager::getCurrentSession(); 
        $data['judul'] = 'Retur Jual Table Per Registrasi List';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/returjual/ReturJualReg_List', $data);
        $this->View('templates/footer');
    }

    public function ViewReg($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id); 
        $data['judul'] = 'Retur Jual Per Registrasi Form Entri';
        $data['judul_child'] = 'Input View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/returjual/ReturJualReg_View', $data);
        $this->View('templates/footer');
    }

    public function getSalesDetailbyNoReg(){
        echo json_encode($this->model('B_Farmasi')->getSalesDetailbyNoReg($_POST));
    }

    public function addReturJualHeaderbyNoReg(){
        echo json_encode($this->model('I_ReturJual_Model')->addReturJualHeaderbyNoReg($_POST));
    }

    public function addReturJualFinishbyReg(){
        echo json_encode($this->model('I_ReturJual_Model')->addReturJualFinishbyReg($_POST));
    }

    public function voidReturJualPerRegister(){
        echo json_encode($this->model('I_ReturJual_Model')->voidReturJualPerRegister($_POST));
    }

    
    
}
