<?php

class InfoPurchaseOrderRekap extends Controller
{

    public function ViewInfoPurchaseOrderRekap()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Info Purchase Order Rekap';
        $data['judul_child'] = 'View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/InfoPurchase/InfoPurchaseOrderRekap_View', $data);
        $this->View('templates/footer');
    }

    public function getDataListInfoPurchaseOrderRekap()
    {
        echo json_encode($this->model('A_InfoPurchaseOrderRekap_Model')->getDataListInfoPurchaseOrderRekap($_POST));
    }
}
