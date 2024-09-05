<?php
class aPurchaseOrder extends Controller
{
    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Purchase Order';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/purchaseorder/input/aPurchaseOrderInput', $data);
        $this->View('templates/footer');
    }
    public function list()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Daftar Purchase Order';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/purchaseorder/list/aPurchaseOrderList', $data);
        $this->View('templates/footer');
    }
    public function getSuppliers(){
        echo json_encode($this->model('A_Suppliers_Model')->getSuppliers());
    }
    public function createHeaderPurchaseOrder(){
        $B_Purchase_Order_Model = $this->model('B_Purchase_Order_Model');
        $PurchaseOrderService = new PurchaseOrder_Service($B_Purchase_Order_Model);
        echo json_encode($PurchaseOrderService->createHeaderPurchaseOrder($_POST));
    }
    public function getBarangBySupplierId(){
        echo json_encode($this->model('A_Master_Barang_Model')->getBarangBySupplierId($_POST));
    }
    public function getBarangById()
    {
        echo json_encode($this->model('A_Master_Barang_Model')->getBarangById($_POST));
    }
    public function addDetilPurchaseOrder(){
        $B_Purchase_Order_Model = $this->model('B_Purchase_Order_Model');
        $PurchaseOrderService = new PurchaseOrder_Service($B_Purchase_Order_Model);
        echo json_encode($PurchaseOrderService->addDetilPurchaseOrder($_POST));
    }
    public function showDetilPurchaseOrder(){
        echo json_encode($this->model('B_Purchase_Order_Model')->showDetilPurchaseOrder($_POST));
    }
    public function getPurchaseOrderHeader(){
        echo json_encode($this->model('B_Purchase_Order_Model')->getPurchaseOrderHeader($_POST));
    }
    public function goFinishPurchaseOrder()
    {
        $B_Purchase_Order_Model = $this->model('B_Purchase_Order_Model');
        $PurchaseOrderService = new PurchaseOrder_Service($B_Purchase_Order_Model);
        echo json_encode($PurchaseOrderService->goFinishPurchaseOrder($_POST));
    }
    public function getListPurchaseOrderData()
    {
        echo json_encode($this->model('B_Purchase_Order_Model')->getListPurchaseOrderData($_POST));
    }
    public function goBatalPOHeader(){
 
        $B_Purchase_Order_Model = $this->model('B_Purchase_Order_Model');
        $PurchaseOrderService = new PurchaseOrder_Service($B_Purchase_Order_Model);
        echo json_encode($PurchaseOrderService->goBatalPOHeader($_POST));
    }
}
