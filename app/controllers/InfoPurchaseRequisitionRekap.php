<?php

class InfoPurchaseRequisitionRekap extends Controller
{

    public function ViewInfoPurchaseRequisitionRekap()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Info Purchase Requisition Rekap';
        $data['judul_child'] = 'View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/InfoPurchase/InfoPurchaseRequisitionRekap_View', $data);
        $this->View('templates/footer');
    }

    public function getDataListInfoPurchaseRequisitionRekap()
    {
        echo json_encode($this->model('A_InfoPurchaseRequisitionRekap_Model')->getDataListInfoPurchaseRequisitionRekap($_POST));
    }
}
