<?php

class InfoBuku extends Controller
{

    public function ViewInfobuku()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Info Buku';
        $data['judul_child'] = 'View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/InfoPurchase/InfoBuku_View', $data);
        $this->View('templates/footer');
    }

    public function getDataListInfoBuku()
    {
        echo json_encode($this->model('A_InfoBuku_Model')->getDataListInfoBuku($_POST));
    }
    public function getBarangAll()
    {
        echo json_encode($this->model('A_InfoBuku_Model')->getBarangAll($_POST));
    }
}
