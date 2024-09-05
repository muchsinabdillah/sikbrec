<?php

class InfoDeliveryOrderRekap extends Controller
{

    public function ViewInfoDeliveryOrderRekap()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Info Delivery Order Rekap ';
        $data['judul_child'] = 'View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/InfoPurchase/InfoDeliveryOrderRekap_View', $data);
        $this->View('templates/footer');
    }

    public function getDataListInfoDeliveryOrderRekap()
    {
        echo json_encode($this->model('A_InfoDeliveryOrderRekap_Model')->getDataListInfoDeliveryOrderRekap($_POST));
    }
}
