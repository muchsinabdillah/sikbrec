<?php

class Purchase extends Controller
{

    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Transaksi Purchase Order';
        $data['judul_child'] = 'Input';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/Purchase/PurchaseOrder_view', $data);
        $this->View('templates/footer');
    }
    public function list()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Purchase Order';
        $data['judul_child'] = 'List';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/Purchase/PurchaseOrder_list', $data);
        $this->View('templates/footer');
    }

    public function showPurchaseOrderAll()
    {
        echo json_encode($this->model('B_Purchase_Order_Model')->getPurchaseOrderbyDateUser($_POST));
    }

    public function getPurchaseOrderHeader()
    {
        echo json_encode($this->model('B_Purchase_Order_Model')->getPurchaseOrderbyID($_POST));
    }

    public function getPurchaseOrderDetailbyID()
    {
        echo json_encode($this->model('B_Purchase_Order_Model')->getPurchaseOrderDetailbyID($_POST));
    }

    public function goFinishEditPurchaseOrder()
    {
        echo json_encode($this->model('B_Purchase_Order_Model')->goFinishEditPurchaseOrder($_POST));
    }

    public function goFinishPurchaseOrder()
    {
        echo json_encode($this->model('B_Purchase_Order_Model')->goFinishPurchaseOrder($_POST));
    }

    public function goVoidPurchaseOrder()
    {
        echo json_encode($this->model('B_Purchase_Order_Model')->goVoidPurchaseOrder($_POST));
    }

    public function goVoidPurchaseOrderDetails()
    {
        echo json_encode($this->model('B_Purchase_Order_Model')->goVoidPurchaseOrderDetails($_POST));
    }

    public function createHeaderPurchaseOrder()
    {
        echo json_encode($this->model('B_Purchase_Order_Model')->createHeaderPurchaseOrder($_POST));
    }

    public function list_approve()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Approve Purchase Order';
        $data['judul_child'] = 'List';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/Purchase/PurchaseOrder_list_approve', $data);
        $this->View('templates/footer');
    }

    public function CetakPO($notrs = '')
    {
        $data['PO_NoTrs'] =  Utils::setDecode($notrs);
        //$data['PO_NoTrs'] =  'TPO140920220001';
        //$data['TransasctionCode'] =  'TPO140920220001';
        $data['TransasctionCode'] =  Utils::setDecode($notrs);
        $session = SessionManager::getCurrentSession();
        $data['dataheader'] = $this->model('B_Purchase_Order_Model')->getPurchaseOrderbyID($data);
        $data['datadetail'] = $this->model('B_Purchase_Order_Model')->getPurchaseOrderDetailbyID($data);
        $data['approve_1'] = $this->model('B_Purchase_Order_Model')->getEmployeeByNoPIN($data['dataheader']['data'][0]['UserApproved_1']);
        $data['approve_2'] = $this->model('B_Purchase_Order_Model')->getEmployeeByNoPIN($data['dataheader']['data'][0]['UserApproved_2']);
        $data['approve_3'] = $this->model('B_Purchase_Order_Model')->getEmployeeByNoPIN($data['dataheader']['data'][0]['UserApproved_3']);
        $this->View('print/Purchase/PurchaseOrder', $data);
    }

    public function getPurchaseOrderbyPeriode()
    {
        echo json_encode($this->model('B_Purchase_Order_Model')->getPurchaseOrderbyPeriode($_POST));
    }
    public function PrintPR($ID = '')
    {
        $data['noregistrasi'] =  Utils::setDecode($ID);
        $session = SessionManager::getCurrentSession();
        // $data['listdata1'] = $this->model('BonSementara_Model')->CetakBon($ID);
        $this->View('print/Purchase/PurchaseRequisition', $data);
    }

    public function goClosePurchaseOrder()
    {
        echo json_encode($this->model('B_Purchase_Order_Model')->goClosePurchaseOrder($_POST));
    }
    public function getBarangKonversibyId()
    {
        echo json_encode($this->model('I_Masterdata_Barang_Model')->getBarangKonversibyId($_POST));
    }
    public function getBarangKonversibyIdDetail()
    {
        echo json_encode($this->model('I_Masterdata_Barang_Model')->getBarangKonversibyIdDetail($_POST));
    }
    public function createupdatekonversisatuanPo()
    {
        echo json_encode($this->model('B_Purchase_Order_Model')->createupdatekonversisatuanPo($_POST));
    }
}