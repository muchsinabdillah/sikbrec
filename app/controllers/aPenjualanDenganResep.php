<?php

class aPenjualanDenganResep extends Controller
{
    public function index($id = null, $notrs =null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['notrs'] =  Utils::setDecode($notrs);
        $data['judul'] = 'Form Penjualan Dengan Resep';
        $data['judul_child'] = 'Input';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/Penjualan/PenjualanDenganResep_View', $data);
        $this->View('templates/footer');
    }
    public function list()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Data Penjualan Dengan Resep';
        $data['judul_child'] = 'List';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/Penjualan/PenjualanDenganResep_List', $data);
        $this->View('templates/footer');
    }

    public function viewOrderResepbyDatePeriode()
    {
        echo json_encode($this->model('B_Farmasi')->viewOrderResepbyDatePeriode($_POST));
    }

    public function viewOrderResepbyOrderIDV2()
    {
        echo json_encode($this->model('B_Farmasi')->viewOrderResepbyOrderIDV2($_POST));
    }

    public function addSalesHeader()
    {
        echo json_encode($this->model('B_Farmasi')->addSalesHeader($_POST));
    }

    public function addSalesDetail()
    {
        echo json_encode($this->model('B_Farmasi')->addSalesDetail($_POST));
    }

    public function getOrderResepDetail()
    {
        echo json_encode($this->model('B_Farmasi')->getOrderResepDetail($_POST));
    }

    public function finishSalesTransaction()
    {
        echo json_encode($this->model('B_Farmasi')->finishSalesTransaction($_POST));
    }

    public function voidSales()
    {
        echo json_encode($this->model('B_Farmasi')->voidSales($_POST));
    }


    // public function getConsumablebyDateUser()
    // {
    //     echo json_encode($this->model('I_Consumable_Model')->getConsumablebyDateUser());
    // }

    public function CetakResepv2($notrs = '')
    {
        $data['NoOrder'] = $notrs; 
        $data['judul'] = 'Resep';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        $data['listdata'] = $this->model('B_Farmasi')->getPrintDetailv2($data); 
        //$data['getFooterRacikan'] = $this->model('B_Farmasi')->getFooterRacikan($data); 
        $data['hdr'] = $this->model('B_Farmasi')->getDataPasienv2($data); 
        $this->View('print/farmasi/print_cetak_resep_new', $data);
    }

    public function CopyResepv2($notrs = '')
    {
        $data['NoOrder'] = $notrs; 
        $data['judul'] = 'Salinan Resep';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        $data['listdata'] = $this->model('B_Farmasi')->getPrintDetailv2($data); 
        //$data['getFooterRacikan'] = $this->model('B_Farmasi')->getFooterRacikan($data); 
        $data['hdr'] = $this->model('B_Farmasi')->getDataPasienv2($data); 
        $this->View('print/farmasi/print_copy_resep_new', $data);
    }

   
}
