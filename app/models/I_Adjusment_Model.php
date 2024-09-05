<?php
class I_Adjusment_Model
{
    use ApiRsyarsi; 
    private $db; 
    public function __construct()
    {
        $this->db = new Database;
    }
    public function showAdjusmentAll(){
        try {
            
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $postSatuanData = '{ 
                "UserCreate" : "'. $userid .'" 
            }';
            $method_getsatuan = "POST";
            $urlAddSatuan = "transaction/adjusment/getAdjusmentbyDateUser/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getsatuan, $postSatuanData, $urlAddSatuan); 
            return $addSatuan['data'];
        
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function addHeader($data)
    {
        try { 
            $TransasctionDate = $data['TransasctionDate'];
            $Unit = $data['Unit'];

            $Keterangan = $data['Notes']; 

            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $name = $session->name;

            
            if ($TransasctionDate == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Tgl Transaksi Kosong !',
                );
                return $callback;
                exit;
            }

            if ($Keterangan == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Keterangan Kosong !',
                );
                return $callback;
                exit;
            }

            if ($Unit == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Unit Kosong !',
                );
                return $callback;
                exit;
            }
 
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            
            // 2. add Data Golongan
            $postData = '
            {
                "TransactionDate" : "'.$TransasctionDate.'",
                "UserCreate" : "'.$userid.'", 
                "UnitCode" : "'.$Unit.'" ,
                "Notes" : "'.$Keterangan.'"  
            }';


            $urlAddKelompok = "transaction/adjusment/addAdjusmentHeader/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, 
                                            $postData, $urlAddKelompok);
            return $addSatuan;


           // return $this->db->execute();
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon(); 
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e,
                
            );
            return $callback; 
        }
    }
    public function finishAdjusment($data)
    {
        try { 
            $TransasctionCode = $data['No_Transaksi'];
            $Unit = $data['Unit'];
            $TransasctionDate = $data['TransasctionDate'];
            $Keterangan = $data['Notes'];
           
     
            
            $TotalQty = $data['TotalQty'];
            $TotalRow = $data['TotalRow'];
            $grandtotalxl = $data['Grandtotal'];
            
            $kode_barang = $data['kode_barang'];
            $nama_barang_ = $data['nama_barang_'];
            $satuan_barang_ = $data['satuan_barang_'];
            $qty_stok_barang_ = $data['qty_stok_barang_'];
            $qty_adj_barang_ = $data['qty_adj_barang_'];
            $qty_barang_ = $data['qty_barang_'];
            $hpp_barang_ = $data['hpp_barang_'];
            $total_barang_ = $data['total_barang_'];
            $batch_number_ = $data['batch_number_'];
            $expired_ = $data['expired_'];

            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $UserCreate = $session->username;

            $jumlah_dipilih = count($kode_barang);

            $qtytotal = 0;
            $nourut=0;
            $rows = array();
            for($x=0;$x<$jumlah_dipilih;$x++){
                
                //END CEK
                $nourut++;
                    if($qty_stok_barang_[$x] > $qty_barang_[$x] ){
                        $JenisAdjusment = "MINUS";
                    }elseif($qty_stok_barang_[$x] < $qty_barang_[$x] ){
                        $JenisAdjusment = "PLUS";
                    }
                    $qtytotal += $qty_barang_[$x];
                    $pasing['ProductCode'] =   $kode_barang[$x];
                    $pasing['ProductSatuan'] =    $satuan_barang_[$x];
                    $pasing['ProductName'] =    $nama_barang_[$x];
                    $pasing['Satuan_Konversi'] = $satuan_barang_[$x];
                    $pasing['QtyStok'] = $qty_stok_barang_[$x];
                    $pasing['QtyAdjusment'] = $qty_adj_barang_[$x]; 
                    $pasing['QtyAkhir'] =   $qty_barang_[$x];
                    $pasing['Hpp'] =   $hpp_barang_[$x];
                    $pasing['JenisAdjusment'] =   $JenisAdjusment;
                    $pasing['ExpiredDate'] =   $expired_[$x];//------
                    $pasing['Batchnumber'] =    $batch_number_[$x];
                    $pasing['DateAdd'] =    $datenowcreate;
                    $pasing['Total'] =    $total_barang_[$x];

                    $rows[] = $pasing;  
                }
                $list = json_encode($rows);

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $DateVoid = Utils::seCurrentDateTime();
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '
            {
                "TransactionCode" : "'.$TransasctionCode.'", 
                "UnitCode" : "'.$Unit.'",   
                "Notes" : "'.$Keterangan.'",
                "TotalQty" : "'.$TotalQty.'",
                "TotalRow" : "'.$TotalRow.'",
                "TotalPersediaan" : "'.$grandtotalxl.'",
                "TransactionDate" : "'.$TransasctionDate.'",
                "UserCreate" : "'.$UserCreate.'",
                "Items":  '.$list.'
            }
            '; 
            $urlAddKelompok = "transaction/adjusment/addAdjusmentFinish/";
            $addSatuan = $this->curl_request(
                GenerateTokenRS::headers_api_token($token['access_token']),
                $method_getgroup,
                $postData,
                $urlAddKelompok
            );
            return $addSatuan;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}