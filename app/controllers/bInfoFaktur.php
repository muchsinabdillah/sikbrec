<?php

class bInfoFaktur extends Controller
{

    public function ViewInfoFaktur()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Faktur';
        $data['judul_child'] = 'View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/tukar-faktur/InfoFaktur', $data);
        $this->View('templates/footer');
    }

    public function getDataListInfoFaktur()
    {
        echo json_encode($this->model('A_InfoFaktur_Model')->getDataListInfoFaktur($_POST));
    }
}
