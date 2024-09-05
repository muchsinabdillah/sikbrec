<?php

class aReturBeli extends Controller
{

    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id); 
        $data['judul'] = 'Retur Beli';
        $data['judul_child'] = 'Input View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/retur-beli/ReturBeli_View', $data);
        $this->View('templates/footer');
    }
    public function list()
    {
        $session = SessionManager::getCurrentSession(); 
        $data['judul'] = 'Retur Beli';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/adjusment/Adjusment_List', $data);
        $this->View('templates/footer');
    }
    public function addSatuan(){
        echo json_encode($this->model('I_Masterdata_Satuan_Model')->addSatuan($_POST));
    }
    public function showSatuanAll(){
        echo json_encode($this->model('I_Masterdata_Satuan_Model')->showSatuanAll());
    }
    public function getSatuanbyId(){
        echo json_encode($this->model('I_Masterdata_Satuan_Model')->getSatuanbyId($_POST));
    }
    public function editSatuan(){
        echo json_encode($this->model('I_Masterdata_Satuan_Model')->editSatuan($_POST));
    }
}