<?php
class I_MasterPaketInventory_Model
{
    use ApiRsyarsi; 
    private $db; 
    public function __construct()
    {
        $this->db = new Database;
    }
    public function addPaketInventory($data)
    {
        try {
            $nama_paket = $data['nama_paket'];

            if ($nama_paket == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Nama Paket Kosong !',
                );
                return $callback;
                exit;
            }

            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);
            
            // 2. add Data Golongan
            $postSatuanData = '{ 
                "nama_paket" : "'. $nama_paket .'",
                "user_create" : "'. $userid .'"
            }';
            $urlAddSatuan = "masterdata/apotek/addPaketInventory/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method, $postSatuanData, $urlAddSatuan);
            //var_dump($addSatuan['status']);
            if ($addSatuan['status'] == 1) {
                $callback = array(
                    'status' => 'success',
                    'message' => $addSatuan['message'],
                    'data' => $addSatuan['data'],
                );
            } else {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => $addSatuan['message'],
                    'data' => null,
                );
            }
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    } 
    public function showall(){
        try {
            
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getsatuan = "GET";
            $urlAddSatuan = "masterdata/apotek/getPaketInventoryAll/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getsatuan, [], $urlAddSatuan); 
            return $addSatuan['data'];
        
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getPaketInventorybyId($data){
        try {

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getsatuan = "GET";
            $urlAddSatuan = "masterdata/apotek/getPaketInventorybyId/".$data['id'];
            $getSatuanbyId = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getsatuan, [], $urlAddSatuan);
            if ($getSatuanbyId['status'] == 1) {
                $callback = array(
                    'status' => 'success',
                    'message' => $getSatuanbyId['message'],
                    'data' => $getSatuanbyId['data']
                );
            } else {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => $getSatuanbyId['message'],

                );
            }
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function editPaketInventory($data)
    {
        try {
            $ID = $data['IdAuto'];
            $status = $data['status'];
            $nama_paket = $data['nama_paket'];
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang
            $postSatuanData = '{ 
                "ID" : "'. $ID .'",
                "nama_paket" : "'. $nama_paket .'",
                "user_update" : "'. $userid .'",
                "status" : "'. $status .'"

            }';
            $urlAddSatuan = "masterdata/apotek/editPaketInventory/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method, $postSatuanData, $urlAddSatuan);
            if ($addSatuan['status'] == 1) {

                $callback = array(
                    'status' => 'success',
                    'message' => $addSatuan['message'],
                );
            } else {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => $addSatuan['message'],

                );
            }
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    } 

    public function addDetailPaketInventory($data)
    {
        try {
            $IDHeader = $data['IDHeader'];
            $ProductCode = $data['ProductCode'];
            $ProductName = $data['ProductName'];
            $QtyPR = str_replace(",", ".", $data['QtyPR']);
            $SatuanBarang = $data['SatuanBarang'];
            $SatuanBarang_Konversi = $data['SatuanBarang_Konversi'];
            $Konversi_Satuan = $data['Konversi_Satuan'];
            // non aktifin bentar
            // $Konversi_QtyTotal = $Konversi_Satuan * $QtyPR;
            $Konversi_QtyTotal =  $QtyPR;
            if ($IDHeader == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. Transaksi Kosong !',
                );
                return $callback;
                exit;
            }

            if ($ProductCode == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode Produk Kosong !',
                );
                return $callback;
                exit;
            }

            if ($ProductName == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Produk Name Kosong !',
                );
                return $callback;
                exit;
            }

            if ($SatuanBarang == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Satuan Barang Kosong ! Silahkan Cek Kembali Di Master Barang !',
                );
                return $callback;
                exit;
            }

            if ($SatuanBarang_Konversi == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Satuan Barang Konversi Kosong ! Silahkan Cek Kembali Di Master Barang !',
                );
                return $callback;
                exit;
            }

            if ($Konversi_Satuan == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Konversi Satuan Kosong ! Silahkan Cek Kembali Di Master Barang !',
                );
                return $callback;
                exit;
            }

            if ($QtyPR == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Qty PR Kosong !',
                );
                return $callback;
                exit;
            }

            $session = SessionManager::getCurrentSession();
            $UserCreate = $session->username;
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            // ialngin dulu satuan terbesar
            // "Satuan": "' . $SatuanBarang . '",
            $postData = '{ 
                "IDHeader" : "' . $IDHeader . '",
                "ProductCode" : "' . $ProductCode . '",
                "ProductName" : "' . $ProductName . '",
                "QtyStok" : "0",
                "QtyPR" : "' . $QtyPR . '",
                "UserAdd" : "' . $UserCreate . '",
                "Satuan": "' . $SatuanBarang_Konversi . '",
                "Satuan_Konversi": "' . $SatuanBarang_Konversi . '",
                "KonversiQty": "' . $Konversi_Satuan . '",
                "Konversi_QtyTotal": "' . $Konversi_QtyTotal . '"
            }';
            //QtyStok, KonversiQty, Konversi_QtyTotal
            $urlAddKelompok = "masterdata/apotek/addDetailPaketInventory/";
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
    public function getDetailPaketInventory($data){
        try {
            $IDHeader = $data['IDHeader'];
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getsatuan = "GET";
            $urlAddSatuan = "masterdata/apotek/getDetailPaketInventory/".$IDHeader;
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getsatuan, [], $urlAddSatuan); 
            if ($addSatuan['status'] == false){
                return [];
            }else{
                return $addSatuan['data'];
            }
        
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function deleteDetailPaketInventory($data)
    {
        try {

            $IDHeader = $data['IDHeader'];
            $product_code = $data['product_code'];

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '
            {
                "IDHeader" : "'.$IDHeader.'" ,
                "ProductCode" : "'.$product_code.'" 
            }';
            //"PurchaseCode" : "'.$No_PurchasingOrder.'"
            $urlAddKelompok = "masterdata/apotek/deleteDetailPaketInventory/";
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
}
