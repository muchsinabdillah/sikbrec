<?php
class bInfoHargaJual extends Controller 
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Harga Jual';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/hargajual/info', $data);
        $this->View('templates/footer');
    }
    public function getDataList(){ 
        echo json_encode($this->model('B_info_harga_Jual')->getDataList($_POST));
    }
}