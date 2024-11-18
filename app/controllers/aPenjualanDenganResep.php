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

    public function ViewOrder($id = null,$notrs =null)
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
    
    public function listRJ()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Data Penjualan Dengan Resep Rawat Jalan';
        $data['judul_child'] = 'List';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/Penjualan/PenjualanDenganResep_List_RJ', $data);
        $this->View('templates/footer');
    }

    public function listRI()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Data Penjualan Dengan Resep Rawat Inap';
        $data['judul_child'] = 'List';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/Penjualan/PenjualanDenganResep_List_RI', $data);
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
        $data_proses = $this->model('A_AntrianCaller_Model')->getStatusAntrian($_POST);
        if ($data_proses['data']['DateProcessed'] == '' || $data_proses['data']['DateProcessed'] == null){
            $data['NoRegistrasi'] = $_POST['NoRegistrasi'];
            $data['NoResep'] = $_POST['No_Order'];
            $data['StatusResep'] = 'PROCESSED';
            $this->model('A_AntrianCaller_Model')->UpdateAntrianFarmasi($data);
        }
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
    
    public function getSalesbyPeriodeResep()
    {
        echo json_encode($this->model('B_Farmasi')->getSalesbyPeriodeResep($_POST));
    }

    public function getSalesbyIDandNoResep()
    {
        echo json_encode($this->model('B_Farmasi')->getSalesbyIDandNoResep($_POST));
    }
    public function CetakLabelPdf($notrs = '')
    {
        $jsondata= json_decode(Utils::setDecode($notrs));

        $data['NoResep'] = $jsondata->notrs; 
        $data['judul'] = 'Resep';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        // //$data['notrs'] = $_POST['']; 
        $data['NamaPasien'] = $jsondata->PatientName; 
        $data['NoMR'] = $jsondata->NoMR; 
        $data['NoRegistrasi'] = $jsondata->NoRegistrasi; 
        $data['tglResep'] = $jsondata->TglResep; 
        $data['Date_of_birth'] = $jsondata->dob; 
        $data['KodeBarang'] = $jsondata->productcode; 
        $data['IDbarang'] = $jsondata->productcode; 
        $data['IDDetail'] = $jsondata->productcode.$jsondata->NoRegistrasi; 
        $data['Signa'] = $jsondata->signa;
        $data['QtyRealisasi'] = $jsondata->qty;
    
        $data['getdataproduct'] = $this->model('I_PurchaseRequisition_Model')->getBarangbyId($data);
        $data['ProductName'] = $data['getdataproduct']['data'][0]['Product Name'];
        $data['Composisi'] = $data['getdataproduct']['data'][0]['Composisi'];
        $data['UnitSatuan'] = $data['getdataproduct']['data'][0]['Unit Satuan'];
        $data['SignaObat'] = $data['getdataproduct']['data'][0]['Signa'];
        $data['ED'] = '-';
        $data['Note2'] = '-';
        
        // $data['listdata1'] = $this->model('I_PurchaseRequisition_Model')->getBarangbyId($data);
        // $data['getSignaObat'] = $this->model('B_Farmasi')->getSignaObat_New($data);  
        // $data['getPrinterLabel'] = $this->model('B_Farmasi')->getPrinterLabel($data);
        //$data['listdata1'] = $this->model('B_Farmasi')->getLabelResep($data); 
      

        $this->View('print/farmasi/print_label_pejualan_dgn_resep', $data);

    }
    public function CetakLabelPerItem()
    {
        $session = SessionManager::getCurrentSession();
        $data['PatientName'] = $_POST['PatientName']; 
        $data['NoMR'] = $_POST['NoMR']; 
        $data['NoRegistrasi'] = $_POST['NoRegistrasi']; 
        $data['TglResep'] = $_POST['TglResep']; 
        $data['dob'] = $_POST['dob']; 
        $data['KodeBarang'] = $_POST['ProductCode']; 
        $data['IDbarang'] = $_POST['ProductCode']; 
        $data['IDDetail'] = $_POST['ProductCode'].$_POST['NoRegistrasi']; 
        //$data['notrs'] = $_POST['']; 
        $data['signaterjemahan'] = $_POST['SignaTerjemahan'];
        $data['QryRealisasi'] = $_POST['QtyReal'];
        $data['listdata1'] = $this->model('I_PurchaseRequisition_Model')->getBarangbyId($data);
        $data['getSignaObat'] = $this->model('B_Farmasi')->getSignaObat_New($data);  
        $data['getPrinterLabel'] = $this->model('B_Farmasi')->getPrinterLabel($data);
        //var_dump($data['listdata1']['data'][0]);exit; 
        if ($data['getPrinterLabel']['status'] == false){
            echo json_encode($data['getPrinterLabel']);
            exit;
        }
        echo json_encode($this->model('B_Farmasi')->printLabelPerItem($data));
    }

    public function getSalesDetailbyIDandNoResep()
    {
        echo json_encode($this->model('B_Farmasi')->getSalesDetailbyIDandNoResep($_POST));
    }
    
    public function getSalesbyPeriodeResepRajal()
    {
        echo json_encode($this->model('B_Farmasi')->getSalesbyPeriodeResepRajal($_POST));
    }
    
    public function getSalesbyPeriodeResepRanap()
    {
        echo json_encode($this->model('B_Farmasi')->getSalesbyPeriodeResepRanap($_POST));
    }
    
    public function viewOrderResepbyDatePeriodeRajal()
    {
        echo json_encode($this->model('B_Farmasi')->viewOrderResepbyDatePeriodeRajal($_POST));
    }
    
    public function viewOrderResepbyDatePeriodeRanap()
    {
        echo json_encode($this->model('B_Farmasi')->viewOrderResepbyDatePeriodeRanap($_POST));
    }

   
}
