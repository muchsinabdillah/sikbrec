<?php

class InventoryConsumable extends Controller
{

    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Transaksi Pakai Barang';
        $data['judul_child'] = 'Input';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/Consumable/Consumable_view', $data);
        $this->View('templates/footer');
    }
    public function list()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Pakai Barang';
        $data['judul_child'] = 'List';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/Consumable/Consumable_List', $data);
        $this->View('templates/footer');
    }

    public function getConsumablebyDateUser()
    {
        echo json_encode($this->model('I_Consumable_Model')->getConsumablebyDateUser());
    }

    public function getConsumablebyPeriode()
    {
        echo json_encode($this->model('I_Consumable_Model')->getConsumablebyPeriode($_POST));
    }

    public function getConsumablebyID()
    {
        echo json_encode($this->model('I_Consumable_Model')->getConsumablebyID($_POST));
    }

    public function getConsumableDetailbyID()
    {
        echo json_encode($this->model('I_Consumable_Model')->getConsumableDetailbyID($_POST));
    }

    public function getConsumableDetailbyIDs()
    {
        echo json_encode($this->model('I_Consumable_Model')->getConsumableDetailbyIDs($_POST));
    }

    public function voidConsumable()
    {
        echo json_encode($this->model('I_Consumable_Model')->voidConsumable($_POST));
    }

    public function voidConsumableDetailbyItem()
    {
        echo json_encode($this->model('I_Consumable_Model')->voidConsumableDetailbyItem($_POST));
    }

    public function addConsumableHeader()
    {
        echo json_encode($this->model('I_Consumable_Model')->addConsumableHeader($_POST));
    }

    public function addConsumableDetail()
    {
        echo json_encode($this->model('I_Consumable_Model')->addConsumableDetail($_POST));
    }

    public function addConsumableDetails()
    {
        echo json_encode($this->model('I_Consumable_Model')->addConsumableDetails($_POST));
    }

    public function createDtlTrsPaket()
    {
        echo json_encode($this->model('I_Consumable_Model')->addOrderMutasiDetailPaket($_POST));
    }
    public function addConsumableDetailv2()
    {
        echo json_encode($this->model('I_Consumable_Model')->addConsumableDetailv2($_POST));
    }
    // public function CetakDO($ID = '')
    // {
    //     $data['NoTrs'] =  Utils::setDecode($ID);
    //     //$data['NoTrs'] =  'TDO140920220001';
    //     //$data['TransasctionCode'] =  'TDO140920220001';
    //     $data['TransasctionCode'] =  Utils::setDecode($ID);
    //     $session = SessionManager::getCurrentSession();
    //     $data['dataheader'] = $this->model('I_DeliveryOrder_Model')->getDeliveryOrderbyID($data);
    //     $data['datadetail'] = $this->model('I_DeliveryOrder_Model')->getDeliveryOrderDetailbyID($data);
    //      $data['ttd'] = $this->model('B_Purchase_Order_Model')->getEmployeeByNoPIN($data['dataheader']['data'][0]['UserCreate']);
    //     // $data['approve_2'] = $this->model('B_Purchase_Order_Model')->getEmployeeByNoPIN($data['dataheader']['data'][0]['UserApproved_2']);
    //     // $data['approve_3'] = $this->model('B_Purchase_Order_Model')->getEmployeeByNoPIN($data['dataheader']['data'][0]['UserApproved_3']);
    //     $this->View('print/Purchase/DeliveryOrder', $data);
    // }
}
