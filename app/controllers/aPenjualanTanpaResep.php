<?php

class aPenjualanTanpaResep extends Controller
{
    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'FORM PENJUALAN TANPA RESEP';
        $data['judul_child'] = 'Input';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/Penjualan/PenjualanTanpaResep_View', $data);
        $this->View('templates/footer');
    }
    public function list()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'LIST RESEP PENJUALAN TANPA RESEP';
        $data['judul_child'] = 'List';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/Penjualan/PenjualanTanpaResep_List', $data);
        $this->View('templates/footer');
    }

    public function addSalesHeaderTanpaResep()
    {
        echo json_encode($this->model('B_Farmasi')->addSalesHeaderTanpaResep($_POST));
    }

    public function getSalesbyDateUser()
    {
        echo json_encode($this->model('B_Farmasi')->getSalesbyDateUser());
    }

    public function getSalesbyID()
    {
        echo json_encode($this->model('B_Farmasi')->getSalesbyID($_POST));
    }

    public function getSalesDetailbyID()
    {
        echo json_encode($this->model('B_Farmasi')->getSalesDetailbyID($_POST));
    }
    public function getSalesbyPeriode()
    {
        echo json_encode($this->model('B_Farmasi')->getSalesbyPeriode($_POST));
    }
    public function getDataKaryawan()
    {
        echo json_encode($this->model('B_Farmasi')->getDataKaryawan($_POST));
    }
    public function getKaryawanbyID()
    {
        echo json_encode($this->model('B_Farmasi')->getKaryawanbyID($_POST));
    }
    public function getUnitbyIP()
    {
        echo json_encode($this->model('B_Farmasi')->getUnitbyIP($_POST));
    }

}
