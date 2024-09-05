<?php

class aTukarFaktur extends Controller
{

    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id); 
        $data['judul'] = 'Tukar Faktur';
        $data['judul_child'] = 'Input View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/tukar-faktur/TukarFaktur_View', $data);
        $this->View('templates/footer');
    }
    public function list()
    {
        $session = SessionManager::getCurrentSession(); 
        $data['judul'] = 'Tukar Faktur';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/tukar-faktur/TukarFaktur_List', $data);
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