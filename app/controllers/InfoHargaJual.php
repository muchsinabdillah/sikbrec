<?php

class InfoHargaJual extends Controller
{

    public function ViewInfoPurchaseRequisition()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Info Purchase Requisition';
        $data['judul_child'] = 'View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/InfoPurchase/InfoPurchaseRequisition_View', $data);
        $this->View('templates/footer');
    }

    public function getDataListInfoPurchaseRequisition()
    {
        echo json_encode($this->model('A_InfoPurchaseRequisition_Model')->getDataListInfoPurchaseRequisition($_POST));
    }
}
