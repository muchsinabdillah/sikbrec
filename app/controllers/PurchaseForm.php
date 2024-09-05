<?php
class PurchaseForm extends Controller
{
    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Purchase Requestion Form Entri';
        $data['judul_child'] = 'Input View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/purchase/PurchasingForm_View', $data);
        $this->View('templates/footer');
    }
    public function list()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Purchase Requestion Table List';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/purchase/PurchasingForm_List', $data);
        $this->View('templates/footer');
    }
    public function createHeaderTrs()
    {
        echo json_encode($this->model('I_PurchaseRequisition_Model')->createHeaderTrs($_POST));
    }
    public function getDataBarangbyName()
    {
        echo json_encode($this->model('I_PurchaseRequisition_Model')->getDataBarangbyName($_POST));
    }
    public function createDtlTrs()
    {
        echo json_encode($this->model('I_PurchaseRequisition_Model')->createDtlTrs($_POST));
    }
    public function getPurchaseRequisitionDetailbyID()
    {
        echo json_encode($this->model('I_PurchaseRequisition_Model')->getPurchaseRequisitionDetailbyID($_POST));
    }
    public function editPurchaseRequisition()
    {
        echo json_encode($this->model('I_PurchaseRequisition_Model')->editPurchaseRequisition($_POST));
    }
    public function getPurchaseRequisitionbyDateUser()
    {
        echo json_encode($this->model('I_PurchaseRequisition_Model')->getPurchaseRequisitionbyDateUser($_POST));
    }
    public function getPurchaseRequisitionbyID()
    {
        echo json_encode($this->model('I_PurchaseRequisition_Model')->getPurchaseRequisitionbyID($_POST));
    }
    public function voidPurchaseRequisition()
    {
        echo json_encode($this->model('I_PurchaseRequisition_Model')->voidPurchaseRequisition($_POST));
    }
    public function getPurchaseRequisitionbyPeriode()
    {
        echo json_encode($this->model('I_PurchaseRequisition_Model')->getPurchaseRequisitionbyPeriode($_POST));
    }

    public function getBarangbyId()
    {
        echo json_encode($this->model('I_PurchaseRequisition_Model')->getBarangbyId($_POST));
    }
    public function PrintBuktiPR($notrs = '')
    {

        $data['TransasctionCode'] =  Utils::setDecode($notrs);
        $session = SessionManager::getCurrentSession();
        $data['listdata1'] = $this->model('I_PurchaseRequisition_Model')->getPurchaseRequisitionbyID($data);
        $data['listdata2'] = $this->model('I_PurchaseRequisition_Model')->getPurchaseRequisitionDetailbyID($data);
        // $data['listdata3'] = $this->model('I_PurchaseRequisition_Model')->getPurchaseRequisitionbyID($data);
        // $data['listdata4'] = $this->model('I_PurchaseRequisition_Model')->getListPurchaseOrderData($data);

        $this->View('print/Purchase/PurchaseRequisition', $data);
    }

    public function voidPurchaseRequisitionDetailbyItem()
    {
        echo json_encode($this->model('I_PurchaseRequisition_Model')->voidPurchaseRequisitionDetailbyItem($_POST));
    }
}
