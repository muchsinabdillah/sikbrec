<?php
// use hari; 
class bInfoOrderDarah extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Order Darah';
        $data['judul_child'] = 'View Informasi';
        // $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('informasi/registration/ODC/ListOrderDarah', $data);
        $this->View('templates/footer');
    }

    public function viewOrderDarah($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['iduseblood'] =  null;
        $data['judul'] = 'Bank Darah'; 
        $data['judul_child'] = 'Form Input'; 
        $data['session'] = $session; 
        // $data['hari'] = $this->hari_ini(); 
        $this->View('templates/header', $session);
        $this->View('informasi/registration/ODC/viewOrderDarah', $data);
        $this->View('templates/footer');
    }

    //badrul
    public function reviewOrderDarah($id = null) 
    { 
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['iduseblood'] =  null;
        $data['judul'] = 'Review Order Darah'; 
        $data['judul_child'] = 'Form Input'; 
        $data['session'] = $session;
        // $data['hari'] = $this->hari_ini(); 
        $this->View('templates/header', $session); 
        $this->View('informasi/registration/ODC/reviewOrderDarah', $data); 
        $this->View('templates/footer'); 
    }
    
    public function getDataListOrderDarahDetail()
    {
        echo json_encode($this->model('aListOrderDarah_Model')->getDataListOrderDarahDetail($_POST));
    }

    public function UpdateQtyOrderDarah()
    {
        echo json_encode($this->model('aListOrderDarah_Model')->UpdateQtyOrderDarah($_POST));
    }

    public function updateHeaderReviewQTYOrder()
    {
        echo json_encode($this->model('aListOrderDarah_Model')->updateHeaderReviewQTYOrder($_POST));
    }

    //badrul

    public function getDataListOrderDarah()
    {
        echo json_encode($this->model('aListOrderDarah_Model')->getDataListOrderDarah($_POST));
    }

    public function getOrderData()
    {
        echo json_encode($this->model('aListOrderDarah_Model')->getOrderDataByID($_POST['id']));
    }

    //fiqri 09-04-2023
    public function createHeaderTrs_UseBlood()
    {
        echo json_encode($this->model('aListOrderDarah_Model')->createHeaderTrs_UseBlood($_POST));
    }
    public function GetListNamaOrderDetail()
    {
        echo json_encode($this->model('aListOrderDarah_Model')->GetListNamaOrderDetail($_POST));
    }
    public function GetNamaOrderDetail()
    {
        echo json_encode($this->model('aListOrderDarah_Model')->GetNamaOrderDetail($_POST));
    }
    public function createDetailTrs_UseBlood()
    {
        echo json_encode($this->model('aListOrderDarah_Model')->createDetailTrs_UseBlood($_POST));
    }
    public function createDetailTrs_UseBlood2()
    {
        echo json_encode($this->model('aListOrderDarah_Model')->createDetailTrs_UseBlood2($_POST));
    }
    public function getDataListUseBloodDetail()
    {
        echo json_encode($this->model('aListOrderDarah_Model')->getDataListUseBloodDetail($_POST));
    }
    public function voidUseBloodbyID()
    {
        echo json_encode($this->model('aListOrderDarah_Model')->voidUseBloodbyID($_POST));
    }
    public function getDataListUseDarah()
    {
        echo json_encode($this->model('aListOrderDarah_Model')->getDataListUseDarah($_POST));
    }
    public function viewOrderDarahbyID($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['iduseblood'] =  Utils::setDecode($id);
        $data['id'] =  null;
        $data['judul'] = 'Bank Darah'; 
        $data['judul_child'] = 'Form Input'; 
        $data['session'] = $session; 
        $this->View('templates/header', $session); 
        $this->View('informasi/registration/ODC/viewOrderDarah', $data); 
        $this->View('templates/footer'); 
    } 
    public function getDataPakaiDarah()
    {
        echo json_encode($this->model('aListOrderDarah_Model')->getDataPakaiDarah($_POST['id']));
    }
    public function updateHeaderTrs()
    {
        echo json_encode($this->model('aListOrderDarah_Model')->updateHeaderTrs($_POST));
    }
    public function BatalHeaderUseBlood()
    {
        echo json_encode($this->model('aListOrderDarah_Model')->BatalHeaderUseBlood($_POST));
    }
    public function viewReturDarah($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['iduseblood'] =  null;
        $data['judul'] = 'Retur Bank Darah'; 
        $data['judul_child'] = 'Form Input'; 
        $data['session'] = $session; 
        // $data['hari'] = $this->hari_ini(); 
        $this->View('templates/header', $session);
        $this->View('informasi/registration/ODC/viewReturDarah', $data);
        $this->View('templates/footer');
    }
    public function getDataListOrderBloodDetail()
    {
        echo json_encode($this->model('aListOrderDarah_Model')->getDataListOrderBloodDetail($_POST));
    }
    public function ReturOrderBlood()
    {
        echo json_encode($this->model('aListOrderDarah_Model')->ReturOrderBlood($_POST));
    }
    public function PrintLabelPasien($id = '')
    {
        // var_dump($id);
        // exit;
        $data['notrs'] =  Utils::setDecode($id);
        $session = SessionManager::getCurrentSession();
        $data['listdata1'] = $this->model('aListOrderDarah_Model')->PrintLabelPasien($data);
        $this->View('print/registration/print_label_pasienBankDarah', $data);
    }
    public function goHandOver()
    {
        echo json_encode($this->model('aListOrderDarah_Model')->goHandOver($_POST));
    }
    public function goshowHandover()
    {
        echo json_encode($this->model('aListOrderDarah_Model')->goshowHandover($_POST));
    }
    public function goSaveTTDNoPIN()
    {
        echo json_encode($this->model('aListOrderDarah_Model')->goSaveTTDNoPIN($_POST));
    }
    public function AddPemeriksaan($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Tambah Pemeriksaan'; 
        $data['judul_child'] = 'Form Input'; 
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('informasi/registration/ODC/viewAddPemeriksaan', $data); 
        $this->View('templates/footer');
    } 
    public function getDataPemeriksaan()
    {
        echo json_encode($this->model('aListOrderDarah_Model')->getDataPemeriksaan($_POST));
    }
    public function goAddPemeriksaan()
    {   
        $namadokter = $this->model('MasterDataDokter_Model')->getDokterId($_POST['dokterpemeriksa']);
        echo json_encode($this->model('aListOrderDarah_Model')->goAddPemeriksaan($_POST,$namadokter['data']['First_Name']));
    }
    public function gogetBarcode()
    {
        echo json_encode($this->model('aListOrderDarah_Model')->gogetBarcode($_POST));
    }
    public function showBarcodeList()
    {
        echo json_encode($this->model('aListOrderDarah_Model')->showBarcodeList($_POST));
    }
    public function getDataTranfusibyNoMR()
    {
        echo json_encode($this->model('aListOrderDarah_Model')->getDataTranfusibyNoMR($_POST));
    }
}
