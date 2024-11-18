<?php

class InventoryCharged extends Controller
{
    public function index($notrs =null)
    {
        $session = SessionManager::getCurrentSession(); 
        $data['notrs'] =  Utils::setDecode($notrs);
        $data['judul'] = 'Form Data Consumable Charged';
        $data['judul_child'] = 'Input';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/consumablecharged/entry', $data);
        $this->View('templates/footer');
    }
    public function list()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Data Consumable Charged';
        $data['judul_child'] = 'List';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/consumablecharged/list', $data);
        $this->View('templates/footer');
    }

    public function addSalesHeader()
    {
        echo json_encode($this->model('B_Farmasi')->addSalesHeader($_POST));
    }
    public function getSalesbyDateUser()
    {
        echo json_encode($this->model('B_Farmasi')->getSalesbyDateUser());
    }

    public function getSalesbyID()
    {
        echo json_encode($this->model('B_Farmasi')->getSalesbyID($_POST));
    }

    public function getSalesDetailbyID()
    {
        echo json_encode($this->model('B_Farmasi')->getSalesDetailbyID($_POST));
    }
    public function getSalesbyPeriode()
    {
        echo json_encode($this->model('B_Farmasi')->getSalesbyPeriode($_POST));
    }
    public function getDataKaryawan()
    {
        echo json_encode($this->model('B_Farmasi')->getDataKaryawan($_POST));
    }
    public function getKaryawanbyID()
    {
        echo json_encode($this->model('B_Farmasi')->getKaryawanbyID($_POST));
    }
    public function getUnitbyIP()
    {
        echo json_encode($this->model('B_Farmasi')->getUnitbyIP($_POST));
    }
    public function getNoregistrasibyNoreg(){
        echo json_encode($this->model('B_Farmasi')->getNoregistrasibyNoreg($_POST));
    }
    // public function viewInventoryChargedbyDatePeriode()
    // {
    //     echo json_encode($this->model('B_Farmasi')->viewOrderResepbyDatePeriode($_POST));
    // }
    public function viewInventoryChargedbyDatePeriode()
    {
        echo json_encode($this->model('B_Farmasi')->viewInventoryChargedbyDatePeriode($_POST));
    }
    public function viewInventoryChargeddetail()
    {
        echo json_encode($this->model('B_Farmasi')->viewInventoryChargeddetail($_POST));
    }
    public function gogetHargaJualFix()
    {
        echo json_encode($this->model('B_Farmasi')->gogetHargaJualFix($_POST));
    }
    public function addConsumableChargedDetailv2()
    {
        echo json_encode($this->model('B_Farmasi')->addConsumableChargedDetailv2($_POST));
    }
    
}
