<?php

class DeliveryOrder extends Controller
{

    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Transaksi Delivery';
        $data['judul_child'] = 'Input';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/Delivery/DeliveryOrder_view', $data);
        $this->View('templates/footer');
    }
    public function list()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Delivery Order';
        $data['judul_child'] = 'List';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/Delivery/DeliveryOrder_List', $data);
        $this->View('templates/footer');
    }

    public function showDeliveryOrderbyUser()
    {
        echo json_encode($this->model('I_DeliveryOrder_Model')->showDeliveryOrderbyUser($_POST));
    }

    public function getDeliveryOrderDetailbyID(){
        echo json_encode($this->model('I_DeliveryOrder_Model')->getDeliveryOrderDetailbyID($_POST));
    }

    public function createHeaderDeliveryOrder(){
        echo json_encode($this->model('I_DeliveryOrder_Model')->createHeaderDeliveryOrder($_POST));
    }

    public function goFinishEditDeliveryOrder()
    {
        echo json_encode($this->model('I_DeliveryOrder_Model')->goFinishEditDeliveryOrder($_POST));
    }

    public function goFinishDeliveryOrder()
    {
        echo json_encode($this->model('I_DeliveryOrder_Model')->goFinishDeliveryOrder($_POST));
    }

    public function getDeliveryOrderHeader(){
        echo json_encode($this->model('I_DeliveryOrder_Model')->getDeliveryOrderbyID($_POST));
    }

    public function goVoidDeliveryOrder(){
        echo json_encode($this->model('I_DeliveryOrder_Model')->goVoidDeliveryOrder($_POST));
    }

    public function getDeliveryOrderbyPeriode(){
        echo json_encode($this->model('I_DeliveryOrder_Model')->getDeliveryOrderbyPeriode($_POST));
    }

    public function voidDeliveryOrderDetailbyItem(){
        echo json_encode($this->model('I_DeliveryOrder_Model')->voidDeliveryOrderDetailbyItem($_POST));
    }

    public function CetakDO($ID = '')
    {
        $data['NoTrs'] =  Utils::setDecode($ID);
        //$data['NoTrs'] =  'TDO140920220001';
        //$data['TransasctionCode'] =  'TDO140920220001';
        $data['TransasctionCode'] =  Utils::setDecode($ID);
        $session = SessionManager::getCurrentSession();
        $data['dataheader'] = $this->model('I_DeliveryOrder_Model')->getDeliveryOrderbyID($data);
        $data['datadetail'] = $this->model('I_DeliveryOrder_Model')->getDeliveryOrderDetailbyID($data);
         $data['ttd'] = $this->model('B_Purchase_Order_Model')->getEmployeeByNoPIN($data['dataheader']['data'][0]['UserCreate']);
        // $data['approve_2'] = $this->model('B_Purchase_Order_Model')->getEmployeeByNoPIN($data['dataheader']['data'][0]['UserApproved_2']);
        // $data['approve_3'] = $this->model('B_Purchase_Order_Model')->getEmployeeByNoPIN($data['dataheader']['data'][0]['UserApproved_3']);
        $this->View('print/Purchase/DeliveryOrder', $data);
    }

    public function getCalculateDateTempobyIDSupplier(){
        echo json_encode($this->model('I_DeliveryOrder_Model')->getCalculateDateTempobyIDSupplier($_POST));
    }
}
