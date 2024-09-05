<?php
class MasterGolongan extends Controller
{
    
    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Transaksi Master Golongan';
        $data['judul_child'] = 'Input View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/golongan/MasterGolongan_View', $data);
        $this->View('templates/footer');
    }
    public function list()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Master Golongan';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/golongan/MasterGolongan_List', $data);
        $this->View('templates/footer');
    }

    public function addGolongan(){
        echo json_encode($this->model('I_Masterdata_Golongan_Model')->addGolongan($_POST));
    }

    public function showGolonganAll(){
        echo json_encode($this->model('I_Masterdata_Golongan_Model')->showGolonganAll());
    }

    public function getGolonganbyId(){
        echo json_encode($this->model('I_Masterdata_Golongan_Model')->getGolonganbyId($_POST));
    }

    public function editGolongan(){
        echo json_encode($this->model('I_Masterdata_Golongan_Model')->editGolongan($_POST));
    }
}
