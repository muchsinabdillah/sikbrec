<?php
class aHutang extends Controller
{
    public function OrderHutang($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Order Hutang';
        $data['judul_child'] = 'Entri';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/hutang/OrderHutang', $data);
        $this->View('templates/footer');
    }
    public function PelunasanHutang($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Pelunasan Hutang';
        $data['judul_child'] = 'Entri';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/hutang/pelunasanHutang', $data);
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

    public function CetakPO($ID = '')
    {
        $data['noregistrasi'] =  Utils::setDecode($ID);
        $session = SessionManager::getCurrentSession();
        $data['listdata1'] = $this->model('BonSementara_Model')->CetakBon($ID);
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
}