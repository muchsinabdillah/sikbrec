<?php

class InventoryApprove extends Controller
{
    //APPROVE PR---------------------------------
    public function ListApprovePR()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Approve Purchase Requestion';
        $data['judul_child'] = 'List';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/Approve/list/PurchaseRequest_list_approve', $data);
        $this->View('templates/footer');
    }

    public function ViewApprovePR($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Approve Purchase Requestion';
        $data['judul_child'] = 'List';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/Approve/view/PurchaseRequest_view_approve', $data);
        $this->View('templates/footer');
    }

    public function SaveApprovePR()
    {
        echo json_encode($this->model('I_PurchaseRequisition_Model')->SaveApprovePR($_POST));
    }

    public function GetApproveName()
    {
        echo json_encode($this->model('I_PurchaseRequisition_Model')->GetApproveName($_POST));
    }
    //#END APPROVE PR----------------------------

    //APPROVE PO---------------------------------
    public function ListApprovePO()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Approve Purchase Order';
        $data['judul_child'] = 'List';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/Approve/list/PurchaseOrder_list_approve', $data);
        $this->View('templates/footer');
    }

    public function ViewApprovePO($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Approve Purchase Order';
        $data['judul_child'] = 'List';
        $data['approve_ke'] = '1';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/Approve/view/PurchaseOrder_view_approve', $data);
        $this->View('templates/footer');
    }

    public function ViewApprovePO2($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Approve Purchase Order';
        $data['approve_ke'] = '2';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/Approve/view/PurchaseOrder_view_approve', $data);
        $this->View('templates/footer');
    }

    public function ViewApprovePO3($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Approve Purchase Order';
        $data['judul_child'] = 'List';
        $data['approve_ke'] = '3';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/Approve/view/PurchaseOrder_view_approve', $data);
        $this->View('templates/footer');
    }

    public function SaveApprovePO()
    {
        echo json_encode($this->model('I_PurchaseRequisition_Model')->SaveApprovePO($_POST));
    }
    //#END APPROVE PO----------------------------

    //APPROVE Order Mutasi---------------------------------
    public function ListApproveOM()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Approve Order Mutasi';
        $data['judul_child'] = 'List';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/Approve/list/OrderMutasi_list_approve', $data);
        $this->View('templates/footer');
    }

    public function ViewApproveOM($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Approve Order Mutasi';
        $data['judul_child'] = 'List';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/Approve/view/OrderMutasi_view_approve', $data);
        $this->View('templates/footer');
    }

    public function SaveApproveOM()
    {
        echo json_encode($this->model('I_PurchaseRequisition_Model')->SaveApproveOM($_POST));
    }
    //#END APPROVE Order Mutasi----------------------------

   

    
    
}
