<?php

class InfoStok extends Controller
{

    public function ViewInfostok()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Info Stock';
        $data['judul_child'] = 'View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/InfoPurchase/InfoStok_View', $data);
        $this->View('templates/footer');
    }

    public function getDataListInfoStok()
    {
        echo json_encode($this->model('A_InfoStok_Model')->getDataListInfoStok($_POST));
    }

    public function getNamaUnit()
    {
        echo json_encode($this->model('A_InfoStok_Model')->getNamaUnit($_POST));
    }
    public function getStokBarangbyUnitNameLike()
    {
        echo json_encode($this->model('A_InfoStok_Model')->getStokBarangbyUnitNameLike($_POST));
    }
   
}
