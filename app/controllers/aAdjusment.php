<?php

class aAdjusment extends Controller
{

    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id); 
        $data['judul'] = 'Adjusment';
        $data['judul_child'] = 'Input View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/adjusment/Adjusment_View', $data);
        $this->View('templates/footer');
    }
    public function list()
    {
        $session = SessionManager::getCurrentSession(); 
        $data['judul'] = 'Adjusment';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/adjusment/Adjusment_List', $data);
        $this->View('templates/footer');
    }
    public function addHeader(){
        echo json_encode($this->model('I_Adjusment_Model')->addHeader($_POST));
    }
    public function showAdjusmentAll(){
        echo json_encode($this->model('I_Adjusment_Model')->showAdjusmentAll());
    }
    public function finishAdjusment(){
        echo json_encode($this->model('I_Adjusment_Model')->finishAdjusment($_POST));
    }
    public function getAdjusmentbyID(){
        echo json_encode($this->model('I_Adjusment_Model')->getAdjusmentbyID($_POST));
    }
    public function getAdjusmentDetailbyID(){
        echo json_encode($this->model('I_Adjusment_Model')->getAdjusmentDetailbyID($_POST));
    }
//     public function editSatuan(){
//         echo json_encode($this->model('I_Masterdata_Satuan_Model')->editSatuan($_POST));
//     }
}