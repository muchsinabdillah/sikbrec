<?php

class TukarFaktur extends Controller
{

    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Input Data Faktur';
        $data['judul_child'] = 'Input';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/Delivery/TukarFaktur_view', $data);
        $this->View('templates/footer');
    }
    public function list()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Tukar Faktur';
        $data['judul_child'] = 'List';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/Delivery/TukarFaktur_List', $data);
        $this->View('templates/footer');
    }
    public function manuallist()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Tukar Faktur';
        $data['judul_child'] = 'List';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/Delivery/TukarFaktur_Manual_List', $data);
        $this->View('templates/footer');
    }
    public function createmanual($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Input Data Faktur ';
        $data['judul_child'] = 'Input';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/Delivery/TukarFakturManual_view', $data);
        $this->View('templates/footer');
    }
    public function getFakturbyPeriode(){
        echo json_encode($this->model('I_TukarFaktur_Model')->getFakturbyPeriode($_POST));
    }

    public function createHeaderTukarFaktur(){
        echo json_encode($this->model('I_TukarFaktur_Model')->createHeaderTukarFaktur($_POST));
    }
    
    public function goFinishTukarFaktur()
    {
        echo json_encode($this->model('I_TukarFaktur_Model')->goFinishTukarFaktur($_POST));
    }

    public function goFinishEditTukarFaktur()
    {
        echo json_encode($this->model('I_TukarFaktur_Model')->goFinishEditTukarFaktur($_POST));
    }

    public function getFakturbyDateUser()
    {
        echo json_encode($this->model('I_TukarFaktur_Model')->getFakturbyDateUser($_POST));
    }

    public function getTukarFakturHeader()
    {
        echo json_encode($this->model('I_TukarFaktur_Model')->getTukarFakturHeader($_POST));
    }

    public function getFakturDetailbyID()
    {
        echo json_encode($this->model('I_TukarFaktur_Model')->getFakturDetailbyID($_POST));
    }

    public function goVoidHeader()
    {
        echo json_encode($this->model('I_TukarFaktur_Model')->goVoidHeader($_POST));
    }
    public function voidFakturDetailbyItem()
    {
        echo json_encode($this->model('I_TukarFaktur_Model')->voidFakturDetailbyItem($_POST));
    }

    // faktur manual
    public function getFakturManualbyDateUser()
    {
        echo json_encode($this->model('I_TukarFaktur_Manual_Model')->getFakturManualbyDateUser($_POST));
    }
    public function createFakturManual()
    {
        echo json_encode($this->model('I_TukarFaktur_Manual_Model')->createFakturManual($_POST));
    }
    public function getTukarFakturHeaderManual()
    {
        echo json_encode($this->model('I_TukarFaktur_Manual_Model')->getTukarFakturHeaderManual($_POST));
    }
    public function goVoidHeaderManual()
    {
        echo json_encode($this->model('I_TukarFaktur_Manual_Model')->goVoidHeaderManual($_POST));
    }
}
