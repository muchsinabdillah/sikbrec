<?php
class Farmasi extends Controller
{
    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
       $data['judul'] = 'Details';
       // $data['judul_child'] = 'Data Pasien';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/RiwayatTransaksi/RiwayatTransaksi_View', $data);
        $this->View('templates/footer');
    }
    public function RiwayatTransaksi()
    {
        $session = SessionManager::getCurrentSession(); 
        $data['judul'] = 'Riwayat Transaksi Order';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/RiwayatTransaksi/RiwayatTransaksi_List', $data);
        $this->View('templates/footer');
    }

    public function getListDataOrder()
    {
        echo json_encode($this->model('B_Farmasi')->getListDataOrder($_POST));
    }

    public function goSelesaiAll()
    {
        echo json_encode($this->model('B_Farmasi')->goSelesaiAll($_POST));
    }

    public function getDataPasien(){
        echo json_encode($this->model('B_Farmasi')->getDataPasien($_POST));
    }

    public function getListDataOrderDetails(){
        echo json_encode($this->model('B_Farmasi')->getListDataOrderDetails($_POST));
    }

    public function CetakResep($notrs = '')
    {
        $data['NoOrder'] = $notrs; 
        $data['judul'] = 'Resep';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        $data['listdata'] = $this->model('B_Farmasi')->getPrintDetail($data); 
        $data['getFooterRacikan'] = $this->model('B_Farmasi')->getFooterRacikan($data); 
        $data['hdr'] = $this->model('B_Farmasi')->getDataPasien($data); 
        $this->View('print/farmasi/print_cetak_resep', $data);
    }

    public function CopyResep($notrs = '')
    {
        $data['NoOrder'] = $notrs; 
        $data['judul'] = 'Salinan Resep';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        $data['listdata'] = $this->model('B_Farmasi')->getPrintDetail($data); 
        $data['getFooterRacikan'] = $this->model('B_Farmasi')->getFooterRacikan($data); 
        $data['hdr'] = $this->model('B_Farmasi')->getDataPasien($data); 
        $this->View('print/farmasi/print_copy_resep', $data);
    }

    public function CetakLabel($notrs = '')
    {
        $data['notrs'] = $notrs; 
        $data['judul'] = 'Resep';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        $data['listdata1'] = $this->model('B_Farmasi')->getLabelResep($data); 
        $data['getSignaObat'] = $this->model('B_Farmasi')->getSignaObat($data); 
        $this->View('print/farmasi/print_label_resep', $data);
    }

    // public function CetakLabel($notrs = '')
    // {
    //     $data['notrs'] = $_POST['iddetail']; 
    //     $data['judul'] = 'Resep';
    //     $data['judul_child'] = 'View Informasi';
    //     $session = SessionManager::getCurrentSession();
    //     $data['listdata1'] = $this->model('B_Farmasi')->getLabelResep($data); 
    //     $data['getSignaObat'] = $this->model('B_Farmasi')->getSignaObat($data); 
    //     //$this->model('B_Farmasi')->printBarcode($data); 
    //     echo json_encode($this->model('B_Farmasi')->printBarcode($data));
    //    // $this->View('print/farmasi/print_label_resep', $data);
    // }

    public function CetakLabelAll($notrs = '')
    {
        $data['NoOrder'] = $_POST['orderid']; 
        $data['judul'] = 'Resep';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        $data['listdata'] = $this->model('B_Farmasi')->getPrintDetail($data); 
        foreach ($data['listdata'] as $row) {
            $data['notrs'] = $row['ID']; 
            $data['listdata1'] = $this->model('B_Farmasi')->getLabelResep($data); 
            $data['getSignaObat'] = $this->model('B_Farmasi')->getSignaObat($data); 
            $this->model('B_Farmasi')->printBarcode($data);
        }
    }

    public function EditSigna()
    {
        echo json_encode($this->model('B_Farmasi')->EditSigna($_POST));
    }

    public function EditSignaNew()
    {
        echo json_encode($this->model('B_Farmasi')->EditSignaNew($_POST));
    }

    public function CetakLabelAll_New($notrs = '')
    {
        $data['OrderID'] = $_POST['orderid']; 
        $data['judul'] = 'Resep';
        $data['judul_child'] = 'View Informasi';
        $data['NoRegistrasi'] = 'RJUM220324-0001';
        $data['KodeKelas'] = '3';
        $session = SessionManager::getCurrentSession();
        $data['listdata'] = $this->model('B_Farmasi')->getOrderResepDetail($data); 
        foreach ($data['listdata'] as $row) {
            if ($row['Racik'] == 0 || ($row['Header'] == 1 && $row['Racik'] <> 0)){
            $data['KodeBarang'] = $row['KodeBarang']; 
            $data['notrs'] = $row['ID']; 
            $data['listdata1'] = $this->model('B_Farmasi')->viewprintLabelbyID($data);
            $data['getSignaObat'] = $this->model('B_Farmasi')->getSignaObat_New($data);  
            $data['getPrinterLabel'] = $this->model('B_Farmasi')->getPrinterLabel($data); 
            if ($data['getPrinterLabel']['status'] == false){
                echo json_encode($data['getPrinterLabel']);
                exit;
            }
            echo json_encode($this->model('B_Farmasi')->printLabelAll($data));
          }
        }
    }

    public function CetakLabelAll_NewTanpaResep($notrs = '')
    {
        $data['TransactionCode'] = $_POST['TransactionCode']; 
        $data['TransasctionCode'] = $_POST['TransactionCode'];
        $data['judul'] = 'Resep';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        $data_header = $this->model('B_Farmasi')->getSalesbyID($data);
        $data['listdata'] = $this->model('B_Farmasi')->getSalesDetailbyID($data); 
        $data['listdata1'][0]['dob'] = $data_header['data'][0]['TglLahirPembeli'];
        $data['listdata1'][0]['TglResep'] = $data_header['data'][0]['TransactionDate'];
        $data['listdata1'][0]['PatientName'] = $data_header['data'][0]['NamaPembeli'];
        $data['listdata1'][0]['NoMR'] = '';
        $data['listdata1'][0]['NoRegistrasi'] = '';
        foreach ($data['listdata'] as $row) {
            
            $data['listdata1'][0]['IDDetail'] = $row['ID'];
            $data['listdata1'][0]['NamaBarang'] = $row['ProductName'];
            $data['listdata1'][0]['QryRealisasi'] = $row['Qty'];
            $data['listdata1'][0]['UnitSatuan'] = $row['Satuan'];
            $data['listdata1'][0]['Composisi'] = '';
            $data['listdata1'][0]['SignaTerjemahan'] = $row['AturanPakai'];
            // if ($row['Racik'] == 0 || ($row['Header'] == 1 && $row['Racik'] <> 0)){
             $data['KodeBarang'] = $row['ProductCode']; 
            // //$data['notrs'] = $row['ID']; 
            //$data['listdata1'] = $data;
             $data['getSignaObat'] = $this->model('B_Farmasi')->getSignaObat_New($data);  
            $data['getPrinterLabel'] = $this->model('B_Farmasi')->getPrinterLabel($data); 
            if ($data['getPrinterLabel']['status'] == false){
                echo json_encode($data['getPrinterLabel']);
                exit;
            }
            echo json_encode($this->model('B_Farmasi')->printLabelAll($data));
          //}
        }
    }

    /*
    public function getListResepRanapSingle()
    {
        echo json_encode($this->model('B_Udd_Model')->getListResepRanapSingle($_POST));
    }
    public function CreateHeaderUdd(){
        echo json_encode($this->model('B_Udd_Model')->CreateHeaderUdd($_POST));
    }
    public function getListResepDetilByNoresep()
    {
        echo json_encode($this->model('B_Udd_Model')->getListResepDetilByNoresep($_POST));
    }
    public function CreateDetilUdd(){
        echo json_encode($this->model('B_Udd_Model')->CreateDetilUdd($_POST));
    }
    public function loaddataUddDetailById(){
        echo json_encode($this->model('B_Udd_Model')->loaddataUddDetailById($_POST));
    }
    public function voidTransaksiUDD(){
        echo json_encode($this->model('B_Udd_Model')->voidTransaksiUDD($_POST));
    }
    public function deleteUddDetil()
    {
        echo json_encode($this->model('B_Udd_Model')->deleteUddDetil($_POST));
    }
    public function getDataUddHeaderbyTrsid()
    {
        echo json_encode($this->model('B_Udd_Model')->getDataUddHeaderbyTrsid($_POST));
    }
    public function PrintLabelUDD($nomr = '')
    {
        $data['IdTransaksi'] =  Utils::setDecode($nomr);
        $session = SessionManager::getCurrentSession();
        $data['listdata1'] = $this->model('B_Udd_Model')->getDataUddHeaderbyTrsid($data);
        $data['listdata2'] = $this->model('B_Udd_Model')->loaddataUddDetailById($data);
        // var_dump($data['listdata2']);exit;
        $this->View('print/farmasi/print_label_udd', $data);
    }
    public function getlistDataUddAll()
    {
        echo json_encode($this->model('B_Udd_Model')->getlistDataUddAll());
    }
    */
}
