<?php

class GroupBarang extends Controller
{

    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Transaksi Group Barang';
        $data['judul_child'] = 'Input View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/group-barang/GroupBarang_View', $data);
        $this->View('templates/footer');
    }
    public function list()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Group Barang';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/group-barang/GroupBarang_List', $data);
        $this->View('templates/footer');
    }
    public function addGroupBarang()
    {
        echo json_encode($this->model('I_Masterdata_Kelompok_Model')->addGroupBarang($_POST));
    }
    public function showGroupBarangAll()
    {
        echo json_encode($this->model('I_Masterdata_Kelompok_Model')->showGroupBarangAll());
    }
    public function getGroupbarangbyId()
    {
        echo json_encode($this->model('I_Masterdata_Kelompok_Model')->getGroupbarangbyId($_POST));
    }
    public function editGroupBarang()
    {
        echo json_encode($this->model('I_Masterdata_Kelompok_Model')->editGroupBarang($_POST));
    }
}
