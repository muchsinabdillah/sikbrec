<?php

class InfoDeliveryOrder extends Controller
{

    public function ViewInfoDeliveryOrder()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Info Delivery Order ';
        $data['judul_child'] = 'View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/InfoPurchase/InfoDeliveryOrder_View', $data);
        $this->View('templates/footer');
    }

    public function getDataListInfoDeliveryOrder()
    {
        echo json_encode($this->model('A_InfoDeliveryOrder_Model')->getDataListInfoDeliveryOrder($_POST));
    }
}
