<?php

class InfoPurchaseOrder extends Controller
{

    public function ViewInfoPurchaseOrder()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Info Purchase Order';
        $data['judul_child'] = 'View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/InfoPurchase/InfoPurchaseOrder_View', $data);
        $this->View('templates/footer');
    }

    public function getDataListInfoPurchaseOrder()
    {
        echo json_encode($this->model('A_InfoPurchaseOrder_Model')->getDataListInfoPurchaseOrder($_POST));
    }
}
