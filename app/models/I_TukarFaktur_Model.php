<?php

class I_TukarFaktur_Model
{
    private $db;
    use ApiRsyarsi;


    public function __construct()
    {
        $this->db = new Database;
    }

    public function createHeaderTukarFaktur($data)
    {
        try {

            $PO_KodeSupplier = $data['PO_KodeSupplier'];
            $No_Request = $data['No_Request'];
            $TransasctionDate = $data['TransasctionDate'];
            $Unit = $data['Unit'];

            $NoFakturPBF = $data['NoFakturPBF'];
            $TglFakturPBF = $data['TglFakturPBF'];
            $TipeHutang = $data['TipeHutang'];
            $NoFakturPajak = $data['NoFakturPajak'];
            $Keterangan = $data['Keterangan'];

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

            if ($NoFakturPBF == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No Faktur PBF Kosong !',
                );
                return $callback;
                exit;
            }

            if ($TglFakturPBF == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Tanggal Faktur PBF Kosong !',
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

            if ($PO_KodeSupplier == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Supplier Kosong !',
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

            if ($NoFakturPajak == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No Faktur Pajak Kosong !',
                );
                return $callback;
                exit;
            }

            if ($TipeHutang == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Tipe Hutang Kosong !',
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
                "SupplierCode" : "'.$PO_KodeSupplier.'" ,
                "Keterangan" : "'.$Keterangan.'" ,
                "DeliveryCode" : "'.$No_Request.'" ,
                "TipeHutang" : "'.$TipeHutang.'" , 
                "NoFakturPBF" : "'.$NoFakturPBF.'",
                "DateFakturPBF" : "'.$TglFakturPBF.'",
                "NoFakturPajak" : "'.$NoFakturPajak.'", 
                "UnitPembelian" : "'.$Unit.'" 
            }';

            $urlAddKelompok = "transaction/faktur/addFaktur/";
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

    public function getFakturbyDateUser()
    {
        try { 
            $session = SessionManager::getCurrentSession();
            $UserCreate = $session->username;
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '{ 
                "UserCreate" : "' . $UserCreate . '" 
            }';
            $urlAddKelompok = "transaction/faktur/getFakturbyDateUser/";
            $addSatuan = $this->curl_request(
                GenerateTokenRS::headers_api_token($token['access_token']),
                $method_getgroup,
                $postData,
                $urlAddKelompok
            );
            return $addSatuan['data'];
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getTukarFakturHeader($data)
    {
        try { 
            $session = SessionManager::getCurrentSession();
            $UserCreate = $session->username;
            $TransactionCode = $data['NoTrs'];
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '{
                "TransactionCode" : "'.$TransactionCode.'" 
            }';
            $urlAddKelompok = "transaction/faktur/getFakturbyID/";
            $addSatuan = $this->curl_request(
                GenerateTokenRS::headers_api_token($token['access_token']),
                $method_getgroup,
                $postData,
                $urlAddKelompok
            );
            return $addSatuan['data'];
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getFakturDetailbyID($data)
    {
        try {
            $session = SessionManager::getCurrentSession();
            $UserCreate = $session->username;
            $NoTrs = $data['TransasctionCode'];
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '{ 
                "TransactionCode" : "' . $NoTrs . '" 
            }';
            $urlAddKelompok = "transaction/faktur/getFakturDetailbyID/";
            $addSatuan = $this->curl_request(
                GenerateTokenRS::headers_api_token($token['access_token']),
                $method_getgroup,
                $postData,
                $urlAddKelompok
            );
            return $addSatuan['data'];
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function goVoidHeader($data)
    {
        try {

            $No_Transaksi = $data['No_Transaksi'];
            $AlasanBatal = $data['AlasanBatal'];
            $Unit = $data['Unit'];
            $No_Request = $data['No_Request'];

            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $name = $session->name;

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '
            {
                "TransactionCode" : "'.$No_Transaksi.'" ,
                "DeliveryCode" : "'.$No_Request.'" ,
                "DateVoid" : "'.$datenowcreate.'",
                "UserVoid" :"'.$userid.'",
                "Void" : "1",
                "ReasonVoid" : "'.$AlasanBatal.'",
                "UnitCode" : "'.$Unit.'"
            }
            ';
            $urlAddKelompok = "transaction/faktur/voidFaktur/";
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

    public function voidFakturDetailbyItem($data)
    {
        try {
            $No_Transaksi = $data['No_Transaksi'];
            $ProductCode = $data['product_code'];
            $AlasanBatal = $data['AlasanBatal'];
            $DeliveryCode = $data['No_Request'];
            $UnitCode = $data['UnitCode'];
            
            if ($No_Transaksi == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No Transaksi Kosong !',
                );
                return $callback;
                exit;
            }

            $session = SessionManager::getCurrentSession();
            $UserCreate = $session->username;
            $datenowcreate = Utils::seCurrentDateTime();
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '
            {

                "TransactionCode" : "' . $No_Transaksi . '",
                "ProductCode" : "'.$ProductCode.'" ,
                "UnitCode" : "'.$UnitCode.'" ,
                "DateVoid" : "'.$datenowcreate.'",
                "UserVoid" : "'.$UserCreate.'",
                "Void" : "1" ,
                "ReasonVoid" : "'.$AlasanBatal.'",
                "DeliveryCode" : "' . $DeliveryCode . '"
            }
            ';
            $urlAddKelompok = "transaction/faktur/voidFakturDetailbyItem/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, 
                                            $postData, $urlAddKelompok);
            return $addSatuan;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    ///-------------------------------------------------------------------------

    public function getOrderMutasibyDateUser()
    {
        try { 
            $session = SessionManager::getCurrentSession();
            $UserCreate = $session->username;
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '{ 
                "UserCreate" : "' . $UserCreate . '" 
            }';
            $urlAddKelompok = "transaction/ordermutasi/getOrderMutasibyDateUser/";
            $addSatuan = $this->curl_request(
                GenerateTokenRS::headers_api_token($token['access_token']),
                $method_getgroup,
                $postData,
                $urlAddKelompok
            );
            return $addSatuan['data'];
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getOrderMutasibyID($data)
    {
        try {
            $session = SessionManager::getCurrentSession();
            $UserCreate = $session->username;
            $TransasctionCode = $data['TransasctionCode'];
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '{ 
                "TransasctionCode" : "' . $TransasctionCode . '" 
            }';
            $urlAddKelompok = "transaction/ordermutasi/getOrderMutasibyID/";
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

    public function createHeaderTrs($data)
    {
        try {
            $TransasctionDate = $data['TransasctionDate'];
            $LayananOrderMutasi = $data['LayananOrderMutasi'];
            $LayananTujuanMutasi = $data['LayananTujuanMutasi'];
            $jenistransaksi = $data['jenistransaksi'];
            $JenisStok = $data['JenisStok'];
            $Notes = $data['Notes'];
            
            if ($TransasctionDate == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Tgl Transaksi Kosong !',
                );
                return $callback;
                exit;
            }

            if ($LayananOrderMutasi == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Layanan Order Mutasi Kosong !',
                );
                return $callback;
                exit;
            }

            if ($LayananTujuanMutasi == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Layanan Tujuan Mutasi Kosong !',
                );
                return $callback;
                exit;
            }

            if ($jenistransaksi == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Jenis Order Mutasi Kosong !',
                );
                return $callback;
                exit;
            }

            if ($Notes == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Note Transaksi Kosong !',
                );
                return $callback;
                exit;
            } 

            if ($JenisStok == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Jenis Stok Kosong !',
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
            $postData = '
            {
                "TransactionDate" : "' . $TransasctionDate . '",
                "UserCreate" : "' . $UserCreate . '",
                "UnitTujuan" : "'.$LayananTujuanMutasi.'" ,
                "UnitOrder" : "'.$LayananOrderMutasi.'",
                "Notes" : "'.$Notes.'",
                "JenisMutasi" : "'.$jenistransaksi.'",
                "JenisStok" : "'.$JenisStok.'"
            }
            
            ';
            $urlAddKelompok = "transaction/ordermutasi/addOrderMutasi/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, 
                                            $postData, $urlAddKelompok);
            return $addSatuan['data'];
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function createDtlTrs($data)
    {
        try {

            $TransasctionCode = $data['TransasctionCode'];
            $ProductCode = $data['ProductCode'];
            $ProductName = $data['ProductName'];
            $QtyStok = $data['QtyStok'];
            $QtyOrder = $data['QtyOrder'];
            $SatuanBarang = $data['SatuanBarang'];
            // $SatuanBarang_Konversi = $data['SatuanBarang_Konversi'];
            // $Konversi_Satuan = $data['Konversi_Satuan'];
            $QtySisaMutasi = $QtyStok-$QtyOrder;

            if ($TransasctionCode == "") {
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

            if ($QtyStok == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Qty Stok Kosong !',
                );
                return $callback;
                exit;
            }

            if ($QtyOrder == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Qty Order Kosong !',
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
            $postData = '
            {
                "TransactionCode" : "' . $TransasctionCode . '",
                "ProductCode": "' . $ProductCode . '",
                "ProductName": "' . $ProductName . '",
                "Satuan": "'.$SatuanBarang.'",
                "QtyStok": "'.$QtyStok.'",
                "QtyOrderMutasi": "'.$QtyOrder.'",
                "QtySisaMutasi": "'.$QtySisaMutasi.'",
                "UserAdd" : "'.$UserCreate.'"
            }
            ';
            $urlAddKelompok = "transaction/ordermutasi/addOrderMutasiDetail/";
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

    public function getOrderMutasiDetailbyID($data)
    {
        try {
            $TransasctionCode = $data['TransasctionCode'];  
            $session = SessionManager::getCurrentSession();
            $UserCreate = $session->username;
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '{ 
                "TransasctionCode" : "' . $TransasctionCode . '" 
            }';
            $urlAddKelompok = "transaction/ordermutasi/getOrderMutasiDetailbyID/";
            $addSatuan = $this->curl_request(
                GenerateTokenRS::headers_api_token($token['access_token']),
                $method_getgroup,
                $postData,
                $urlAddKelompok
            );
            return $addSatuan['data'];
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function editOrderMutasi($data)
    {
        try {
            $TransasctionDate = $data['TransasctionDate'];
            $TransasctionCode = $data['IdAuto'];

            $LayananOrderMutasi = $data['LayananOrderMutasi'];
            $LayananTujuanMutasi = $data['LayananTujuanMutasi'];
            $jenistransaksi = $data['jenistransaksi'];
            $JenisStok = $data['JenisStok'];
            $Notes = $data['Notes'];

            $TotalQty = $data['TotalQty'];
            $TotalRow = $data['TotalRow'];

            if ($TransasctionCode == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode Transaksi Kosong !',
                );
                return $callback;
                exit;
            }

            if ($TransasctionDate == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Tgl Transaksi Kosong !',
                );
                return $callback;
                exit;
            }

            if ($LayananOrderMutasi == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Layanan Order Mutasi Kosong !',
                );
                return $callback;
                exit;
            }

            if ($LayananTujuanMutasi == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Layanan Tujuan Mutasi Kosong !',
                );
                return $callback;
                exit;
            }

            if ($jenistransaksi == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Jenis Order Mutasi Kosong !',
                );
                return $callback;
                exit;
            }

            if ($Notes == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Note Transaksi Kosong !',
                );
                return $callback;
                exit;
            } 

            if ($JenisStok == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Jenis Stok Kosong !',
                );
                return $callback;
                exit;
            }

            if ($TotalQty == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Total Qty Kosong !',
                );
                return $callback;
                exit;
            }

            if ($TotalRow == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Total Row Kosong !',
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
            $postData = '
            {
                "TransactionDate" : "' . $TransasctionDate . '",
                "UserCreate" :"' . $UserCreate . '",
                "TransasctionCode" : "' . $TransasctionCode . '",    
                "UnitOrder" : "'.$LayananOrderMutasi.'",
                "UnitTujuan" : "'.$LayananTujuanMutasi.'",
                "TotalQtyOrder" :  "' . $TotalQty . '",
                "TotalRow" : "' . $TotalRow . '",
                "JenisMutasi" : "'.$jenistransaksi.'",
                "JenisStok" : "'.$JenisStok.'",
                "Notes" : "' . $Notes . '"
            }
            
            ';
            $urlAddKelompok = "transaction/ordermutasi/editOrderMutasi/";
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

    public function getFakturbyPeriode($data)
    {
        try { 
            $tglawal = $data['tglawal'];
            $tglakhir = $data['tglakhir'];
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '
            {
                "StartPeriode" : "'.$tglawal.'" ,
                "EndPeriode" : "'.$tglakhir.'" 
            }
            ';
            $urlAddKelompok = "transaction/faktur/getFakturbyPeriode/";
            $addSatuan = $this->curl_request(
                GenerateTokenRS::headers_api_token($token['access_token']),
                $method_getgroup,
                $postData,
                $urlAddKelompok
            );
            return $addSatuan['data'];
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function voidOrderMutasi($data)
    {
        try { 
            $TransasctionCode = $data['No_Transaksi'];
            $AlasanBatal = $data['AlasanBatal'];
 
            $session = SessionManager::getCurrentSession();
            $UserCreate = $session->username;
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $DateVoid = Utils::seCurrentDateTime();
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '{
                "TransactionCode" : "'.$TransasctionCode.'" ,
                "DateVoid" : "'.$DateVoid.'",
                "UserVoid" : "'.$UserCreate.'",
                "Void" : "1",
                "ReasonVoid" : "'.$AlasanBatal.'" 
            }';
            $urlAddKelompok = "transaction/ordermutasi/voidOrderMutasi/";
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

    public function voidOrderDetailsMutasi($data)
    {
        try { 
            $TransasctionCode = $data['No_Transaksi'];
            $ProductCode = $data['ProductCode'];
 
            $session = SessionManager::getCurrentSession();
            $UserCreate = $session->username;
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
                "TransasctionCode" : "'.$TransasctionCode.'" ,
                "ProductCode" : "'.$ProductCode.'",
                "DateVoid" : "'.$DateVoid.'",
                "UserVoid" : "'.$UserCreate.'",
                "Void" : "1" 
            }
            ';
            $urlAddKelompok = "transaction/ordermutasi/voidOrderMutasiDetailbyItem/";
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

    //--------------MUTASI
    public function getMutasibyDateUser()
    {
        try { 
            $session = SessionManager::getCurrentSession();
            $UserCreate = $session->username;
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '{ 
                "UserCreate" : "' . $UserCreate . '" 
            }';
            $urlAddKelompok = "transaction/mutasi/getMutasibyDateUser/";
            $addSatuan = $this->curl_request(
                GenerateTokenRS::headers_api_token($token['access_token']),
                $method_getgroup,
                $postData,
                $urlAddKelompok
            );
            return $addSatuan['data'];
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getMutasibyID($data)
    {
        try {
            $session = SessionManager::getCurrentSession();
            $UserCreate = $session->username;
            $TransasctionCode = $data['TransasctionCode'];
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '{ 
                "TransasctionCode" : "' . $TransasctionCode . '" 
            }';
            $urlAddKelompok = "transaction/mutasi/getMutasibyID/";
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

    public function createHeaderTrs_Mutasi($data)
    {
        try {
            $TransasctionDate = $data['TransasctionDate'];
            $LokasiAwalOrder = $data['LokasiAwalOrder'];
            $LokasiTujuanStok = $data['LokasiTujuanStok'];
            $jenistransaksi = $data['jenistransaksi'];
            $JenisStok = $data['JenisStok'];
            $Notes = $data['Notes'];
            $NoOrderMutasi = $data['NoOrderMutasi'];
            
            if ($TransasctionDate == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Tgl Transaksi Kosong !',
                );
                return $callback;
                exit;
            }

            if ($LokasiAwalOrder == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Lokasi Awal Order Mutasi Kosong !',
                );
                return $callback;
                exit;
            }

            if ($LokasiTujuanStok == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Lokasi Tujuan Stok Mutasi Kosong !',
                );
                return $callback;
                exit;
            }

            if ($jenistransaksi == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Jenis Order Mutasi Kosong !',
                );
                return $callback;
                exit;
            }

            if ($Notes == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Note Transaksi Kosong !',
                );
                return $callback;
                exit;
            } 

            if ($JenisStok == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Jenis Stok Kosong !',
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
            $postData = '
            {
                "TransactionDate" : "' . $TransasctionDate . '",
                "UserCreate" : "' . $UserCreate . '",
                "UnitOrder" : "'.$LokasiAwalOrder.'" ,
                "UnitTujuan" : "'.$LokasiTujuanStok.'" ,
                "JenisMutasi" : "'.$jenistransaksi.'",
                "JenisStok" : "'.$JenisStok.'",
                "Notes" : "'.$Notes.'",
                "TransactionOrderCode" : "'.$NoOrderMutasi.'" 
            }
            ';
            $urlAddKelompok = "transaction/mutasi/addMutasi/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, 
                                            $postData, $urlAddKelompok);
            return $addSatuan;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function goSaveMutasi($data)
    {
        try {
            $TransasctionDate = $data['TransasctionDate'];
            $LokasiAwalOrder = $data['LokasiAwalOrder'];
            $LokasiTujuanStok = $data['LokasiTujuanStok'];
            $jenistransaksi = $data['jenistransaksi'];
            $JenisStok = $data['JenisStok'];
            $Notes = $data['Notes'];
            
            if ($TransasctionDate == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Tgl Transaksi Kosong !',
                );
                return $callback;
                exit;
            }

            if ($LokasiAwalOrder == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Lokasi Awal Order Mutasi Kosong !',
                );
                return $callback;
                exit;
            }

            if ($LokasiTujuanStok == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Lokasi Tujuan Stok Mutasi Kosong !',
                );
                return $callback;
                exit;
            }

            if ($jenistransaksi == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Jenis Order Mutasi Kosong !',
                );
                return $callback;
                exit;
            }

            if ($Notes == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Note Transaksi Kosong !',
                );
                return $callback;
                exit;
            } 

            if ($JenisStok == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Jenis Stok Kosong !',
                );
                return $callback;
                exit;
            }

            $TransactionCode = $data['NoOrderTransaksi'];
            $No_Request = $data['NoOrderMutasi'];

            $hidden_kode_barang =$data['hidden_kode_barang'];
            $hidden_nama_barang_ = $data['hidden_nama_barang_'];
            $hidden_satuan_barang_ = $data['hidden_satuan_barang_'];
            $hidden_min_barang_ = $data['hidden_min_barang_'];
            $hidden_qty_barang_ = $data['hidden_qty_barang_'];
            $hidden_total_barang_ = $data['hidden_total_barang_'];
            

            $diskonxRp = $data['diskonxRp'];
            $taxxRp = $data['taxxRp'];

            $jumlah_dipilih = count($hidden_kode_barang);

            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;

            //var_dump($data);

            $nourut=0;
            $rows = array();
            for($x=0;$x<$jumlah_dipilih;$x++){
                
                //END CEK
                $nourut++;

            // //GET FROM TABLE PRODUCT
            // $this->db->query("  SELECT isnull([Quantity Per Unit],0) as qtystok,isnull([List Price],0) as listprice,isnull(Konversi_satuan,0) as KonversiSatuan,Satuan_Beli from [Apotik_V1.1SQL].dbo.Products 
            // where ID=:id");
            // $this->db->bind('id',   $hidden_kode_barang[$x]); 
            // $datax =  $this->db->single();
            // $qtystok = $datax['qtystok'];
            // if ($qtystok == ''){
            //     $qtystok = 0;
            // }
            // $listprice = $datax['listprice'];
            // $KonversiSatuan = $datax['KonversiSatuan'];
            // $Satuan_Beli = $datax['Satuan_Beli'];

            // if ($KonversiSatuan == 0){

            // }

                    $pasing['ProductCode'] =   $hidden_kode_barang[$x];
                    $pasing['ProductSatuan'] =    $hidden_satuan_barang_[$x];
                    $pasing['ProductName'] =    $hidden_nama_barang_[$x];
                    $pasing['QtyStok'] =   $hidden_min_barang_[$x];
                    $pasing['QtyOrderMutasi'] =   $hidden_min_barang_[$x];
                    $pasing['QtyMutasi'] =   $hidden_qty_barang_[$x];
                    $pasing['Hpp'] =   $hidden_total_barang_[$x];
                    $pasing['Persediaan'] =   $hidden_qty_barang_[$x];
                    $pasing['UserAdd'] =    $userid;
                    $pasing['DateAdd'] =    $datenowcreate;


                    $rows[] = $pasing;  
                }
                $list = json_encode($rows);

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '
            {
                "TransactionCode" : "'.$TransactionCode.'",
                "TransactionOrderCode" : "'.$No_Request.'",
                "UnitOrder" : "'.$LokasiAwalOrder.'",
                "UnitTujuan" : "'.$LokasiTujuanStok.'",
                "JenisMutasi" : "'.$jenistransaksi.'" ,
                "JenisStok" : "'.$JenisStok.'" ,
                "Notes" : "'.$Notes.'",
                "TransactionDate" : "'.$TransasctionDate.'",
                "UserCreate" : "'.$userid.'",
                "Items":  ' . $list . '
            }
            ';
            $urlAddKelompok = "transaction/mutasi/addMutasiWithOrderDetail/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, 
                                            $postData, $urlAddKelompok);
            return $addSatuan;


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

    public function getMutasiDetailbyID($data)
    {
        try {
            $TransasctionCode = $data['TransasctionCode'];  
            $session = SessionManager::getCurrentSession();
            $UserCreate = $session->username;
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '{ 
                "TransasctionCode" : "' . $TransasctionCode . '" 
            }';
            $urlAddKelompok = "transaction/mutasi/getMutasiDetailbyID/";
            $addSatuan = $this->curl_request(
                GenerateTokenRS::headers_api_token($token['access_token']),
                $method_getgroup,
                $postData,
                $urlAddKelompok
            );
            return $addSatuan['data'];
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    //----------------------------------------------------------------
    function createNumberPurchaseOrder($data)
    {
        try {
            
            //if($data['PO_JenisPurchase'] =="1"){ $jenisPo = "FARMASI";  }else{ $jenisPo = "UMUM"; }
            $tgltrs = date('dmY', strtotime($data['Tgl_Transaksi']));
            $yearOnly = Utils::datenowcreateYearOnly();
            $monthOnly = Utils::datenowcreateMonthOnly();
            $this->db->query("SELECT  top 1 substring(FS_KD_TRS,1,6) AS NUMBERLAST 
                            from [Apotik_V1.1SQL].DBO.TB_TRS_PO_HDR
                            where FORMAT (fs_tgl_first,'yyyy')=$yearOnly
                            order by 1 desc");
            $data =  $this->db->single(); 
            $NUMBERLAST = $data['NUMBERLAST'];
            $NUMBERLAST++;
            $numberfix = Utils::generateAutoNumberMedicalRecord($NUMBERLAST);
            $monthRomawi = Utils::createMonthRomawi($monthOnly);
            //$idno_urutantbllablis = $numberfix.'/RSYRS-'.$jenisPo.'/PROC/'.$monthRomawi.'/'. $yearOnly;
            $idno_urutantbllablis = 'TPO'.$tgltrs.$numberfix;
            $callback = array(
                'status' => 'success', 
                'no_purchaseorder' => $idno_urutantbllablis,
            );
            return $callback;
        } catch (PDOException $e) {
             
            
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function createHeaderDeliveryOrder($data)
    {
        try {
            //$no_purchaseorder = $createOrderNumber['no_purchaseorder']; 

            $Keterangan = $data['Keterangan_PO'];
            $PO_KodeSupplier = $data['PO_KodeSupplier'];
            $No_Request = $data['No_PurchasingOrder'];
            $TransasctionDate = $data['TransasctionDate'];
            $JenisDelivery = $data['JenisDelivery'];

            $nulldata = "";
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

            if ($PO_KodeSupplier == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Supplier Kosong !',
                );
                return $callback;
                exit;
            }

            if ($JenisDelivery == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Jenis Delivery Kosong !',
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
            $postData = '{
                "DeliveryOrderDate" : "'.$TransasctionDate.'",
                "UserCreate" : "'.$userid.'",
                "SupplierCode" : "'.$PO_KodeSupplier.'" ,
                "Notes" : "'.$Keterangan.'",
                "JenisDelivery" : "'.$JenisDelivery.'",
                "PurchaseOrderCode" : "'.$No_Request.'" 
            }';
            $urlAddKelompok = "transaction/deliveryorder/addDeliveryOrder/";
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
    function validasiSudahDo($data)
    {
        try { 
            $this->db->query("  SELECT * from [Apotik_V1.1SQL].dbo.TB_TRS_DO_HDR 
                                where FS_KD_PETUGAS_VOID='' 
				                and FS_KD_PO=:PO_NoTrs");
            $this->db->bind('PO_NoTrs',   $data['PO_NoTrs']); 
            $data =  $this->db->single();
            $kodepos=$data['FS_KD_PO'];
            $rowsdata = $this->db->rowCount();
            if ($rowsdata > 1) {
                $callback = array(
                    'status' => 'warningreceive',
                    'errorname' => 'Sudah ada DO, buat Trs Baru untuk entri Pemeriksaan Lainnya !',
                    'FS_KD_PO' => $kodepos
                );
                return $callback;
                exit;
            }else{
                $callback = array(
                    'status' => 'warningreceive2',
                    'errorname' => 'Sudah ada DO, buat Trs Baru untuk entri Pemeriksaan Lainnya !',
                    'FS_KD_PO' => $kodepos
                );
                return $callback;
                exit;
            }
        } catch (PDOException $e) {
             
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function goFinishTukarFaktur($data)
    {
        try {

            $TransactionCode = $data['No_Transaksi'];
            $PO_KodeSupplier = $data['PO_KodeSupplier'];
            $NoPurchaseOrder = $data['NoPurchaseOrder'];
            $No_Request = $data['No_Request'];
            $TransasctionDate = $data['TransasctionDate'];
            $Unit = $data['Unit'];
            $TglJatuhTempo = $data['TglJatuhTempo'];

            $NoFakturPBF = $data['NoFakturPBF'];
            $TglFakturPBF = $data['TglFakturPBF'];
            $TipeHutang = $data['TipeHutang'];
            $NoFakturPajak = $data['NoFakturPajak'];
            $Keterangan = $data['Keterangan'];

            $hidden_kode_barang =$data['hidden_kode_barang'];
            $hidden_nama_barang_ = $data['hidden_nama_barang_'];
            $hidden_satuan_barang_ = $data['hidden_satuan_barang_'];
            $hidden_qty_barang_ = str_replace(".", "", $data['hidden_qty_barang_']);
            $hidden_harga_barang_ = str_replace(".", "", $data['hidden_harga_barang_']);
           // $hidden_discpros_barang_ = $data['hidden_discpros_barang_'];
            $hidden_discrp_barang_ = str_replace(".", "", $data['hidden_discrp_barang_']);
            $hidden_subtotal_ = str_replace(".", "", $data['hidden_subtotal_']);
            //$hidden_taxprosen_ = $data['hidden_taxprosen_'];
            $hidden_taxrp_ = str_replace(".", "", $data['hidden_taxrp_']);
            $hidden_grandtotal_ = str_replace(".", "", $data['hidden_grandtotal_']);
            $hidden_min_barang_ = str_replace(".", "", $data['hidden_min_barang_']);
            
            $hidden_discrpttl_barang_ = str_replace(".", "", $data['hidden_discrpttl_barang_']);
            $hidden_taxrp2_ = str_replace(".", "", $data['hidden_taxrp2_']);

            $diskonxRp = str_replace(".", "", $data['diskonxRp']);
            $taxxRp = str_replace(".", "", $data['taxxRp']);
            $totalrow = str_replace(".", "", $data['totalrow']);
            $grandtotalxl = str_replace(".", "", $data['grandtotalxl']);
            $subtotalttlrp = str_replace(".", "", $data['subtotalttlrp']);

            $DiskonLain = str_replace(".", "", $data['DiskonLain']);
            $BiayaLain = str_replace(".", "", $data['BiayaLain']);
            $Pph23 = str_replace(".", "", $data['Pph23']);
            $GrandTotal = str_replace(".", "", $data['GrandTotal']);
            $grandtotalqty = str_replace(".", "", $data['grandtotalqty']);

            //convert koma
            $hidden_qty_barang_ = str_replace(",",".", $hidden_qty_barang_);
            $hidden_harga_barang_ = str_replace(",",".", $hidden_harga_barang_);
            $hidden_discrp_barang_ = str_replace(",",".", $hidden_discrp_barang_);
            $hidden_subtotal_ = str_replace(",",".", $hidden_subtotal_);
            $hidden_taxrp_ = str_replace(",",".", $hidden_taxrp_);
            $hidden_grandtotal_ = str_replace(",",".", $hidden_grandtotal_);
            $hidden_min_barang_ = str_replace(",",".", $hidden_min_barang_);
            $hidden_discrpttl_barang_ = str_replace(",",".", $hidden_discrpttl_barang_);
            $hidden_taxrp2_ = str_replace(",",".", $hidden_taxrp2_);
            $diskonxRp = str_replace(",",".", $diskonxRp);
            $taxxRp = str_replace(",",".", $taxxRp);
            $totalrow = str_replace(",",".", $totalrow);
            $grandtotalxl = str_replace(",",".", $grandtotalxl);
            $subtotalttlrp = str_replace(",",".", $subtotalttlrp);
            $DiskonLain = str_replace(",",".", $DiskonLain);
            $BiayaLain = str_replace(",",".", $BiayaLain);
            $Pph23 = str_replace(",",".", $Pph23);
            $GrandTotal = str_replace(",",".", $GrandTotal);
            $grandtotalqty = str_replace(",",".", $grandtotalqty);

            $jumlah_dipilih = count($hidden_kode_barang);

            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;

            if ($TglJatuhTempo == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Tanggal Jatuh Tempo Kosong !',
                );
                return $callback;
                exit;
            } 

            $nourut=0;
            $rows = array();
            for($x=0;$x<$jumlah_dipilih;$x++){

                $nourut++;

            // //GET FROM TABLE PRODUCT
            // $this->db->query("  SELECT isnull([Quantity Per Unit],0) as qtystok,isnull([List Price],0) as listprice,isnull(Konversi_satuan,0) as KonversiSatuan,Satuan_Beli from [Apotik_V1.1SQL].dbo.Products 
            // where ID=:id");
            // $this->db->bind('id',   $hidden_kode_barang[$x]); 
            // $datax =  $this->db->single();
            // $qtystok = $datax['qtystok'];
            // if ($qtystok == ''){
            //     $qtystok = 0;
            // }
            // $listprice = $datax['listprice'];
            // $KonversiSatuan = $datax['KonversiSatuan'];
            // $Satuan_Beli = $datax['Satuan_Beli'];

                 //$qyt_remain =   $hidden_qty_barang_[$x] - $hidden_min_barang_[$x];
                 
                 $pasing['ProductCode'] =   $hidden_kode_barang[$x];
                 $pasing['ProductSatuan'] =    $hidden_satuan_barang_[$x];
                 $pasing['ProductName'] =    $hidden_nama_barang_[$x];
                 $pasing['Harga'] =   $hidden_harga_barang_[$x];
                 $pasing['Diskon'] =    $hidden_discrpttl_barang_[$x];
                 $pasing['Diskon2'] =    $hidden_discrp_barang_[$x];
                 $pasing['Tax'] =    $hidden_taxrp_[$x];
                 $pasing['Tax2'] =    $hidden_taxrp2_[$x];
                 $pasing['Total'] =    $hidden_grandtotal_[$x];
                 $pasing['QtyFaktur'] =    $hidden_qty_barang_[$x];
                 $pasing['QtyFakturSisa'] =  $hidden_qty_barang_[$x];
                 $pasing['UserAdd'] =    $datenowcreate;
                 $pasing['DateAdd'] =    $userid;


                    $rows[] = $pasing;  
                }
                $list = json_encode($rows);

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '
            {
                "TransactionCode" : "'.$TransactionCode.'",
                "DeliveryCode" : "'.$No_Request.'",
                "NoPurchaseOrder" : "'.$NoPurchaseOrder.'", 
                "Pph23" : "'.$Pph23.'", 
                "UnitPembelian" : "'.$Unit.'",
                "TransactionDate" : "'.$TransasctionDate.'",
                "UserCreate" : "'.$userid.'",
                "SupplierCode" : "'.$PO_KodeSupplier.'",
                "NoFakturPBF" : "'.$NoFakturPBF.'",
                "DateFakturPBF" : "'.$TglFakturPBF.'",
                "Keterangan" : "'.$Keterangan.'",
                "TotalRow" : "'.$totalrow.'",
                "TotalQty" : "'.$grandtotalqty.'",
                "TotalNilaiFaktur" : "'.$grandtotalxl.'",
                "TglJatuhTempo" : "'.$TglJatuhTempo.'",
                "TipeHutang" : "'.$TipeHutang.'",
                "TotalDiskon" : "'.$diskonxRp.'",
                "TotalTax" : "'.$taxxRp.'",
                "Subtotal" : "'.$subtotalttlrp.'",
                "DiskonLain" : "'.$DiskonLain.'", 
                "BiayaLain" : "'.$BiayaLain.'", 
                "Grandtotal" : "'.$GrandTotal.'", 
                "NoFakturPajak":   "'.$NoFakturPajak.'",
                "Items":   ' . $list . '
            }
            ';
            $urlAddKelompok = "transaction/faktur/addFakturDetail/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, 
                                            $postData, $urlAddKelompok);
            return $addSatuan;


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
    public function getListPurchaseOrderData($data)
    {
        try {
            $TglPeriodeAwal = $data['TglPeriodeAwal'];
            $TglPeriodeAkhir = $data['TglPeriodeAkhir'];
            $KodeSupplier = $data['KodeSupplier'];
            if($KodeSupplier == ""){
                $this->db->query("SELECT a.FS_KD_TRS,b.[First Name] AS Namapetugas,a.FS_TGL_TRS,a.FS_KD_SUPPLIER,
                                a.fs_ket,a.FN_TTL_QTY_PO,a.FN_SUBTOTAL,a.FN_TAX_RP,a.FN_TOTAL,c.Company
                                from [Apotik_V1.1SQL].dbo.TB_TRS_PO_HDR a 
                                inner join MasterdataSQL.dbo.Employees b 
                                on a.FS_KD_PETUGAS collate Latin1_General_CI_AS = b.NoPIN collate Latin1_General_CI_AS
                                inner join [Apotik_V1.1SQL].dbo.Suppliers c on c.ID = a.FS_KD_SUPPLIER
                                where a.FS_KD_PETUGAS_VOID='' 
                                and replace(CONVERT(VARCHAR(11), a.FS_TGL_TRS, 111), '/','-') between :TglPeriodeAwal
                                and :TglPeriodeAkhir  ORDER BY 1 DESC");
                $this->db->bind('TglPeriodeAwal', $TglPeriodeAwal);
                $this->db->bind('TglPeriodeAkhir', $TglPeriodeAkhir); 
                $data =  $this->db->resultSet();
            }else{
                $this->db->query("SELECT a.FS_KD_TRS,b.[First Name] AS Namapetugas,a.FS_TGL_TRS,a.FS_KD_SUPPLIER,
                                a.fs_ket,a.FN_TTL_QTY_PO,a.FN_SUBTOTAL,a.FN_TAX_RP,a.FN_TOTAL,c.Company
                                from [Apotik_V1.1SQL].dbo.TB_TRS_PO_HDR a 
                                inner join MasterdataSQL.dbo.Employees b 
                                on a.FS_KD_PETUGAS collate Latin1_General_CI_AS = b.NoPIN collate Latin1_General_CI_AS
                                inner join [Apotik_V1.1SQL].dbo.Suppliers c on c.ID = a.FS_KD_SUPPLIER
                                where a.FS_KD_PETUGAS_VOID='' 
                                and replace(CONVERT(VARCHAR(11), a.FS_TGL_TRS, 111), '/','-') between :TglPeriodeAwal
                                and :TglPeriodeAkhir
                                and a.FS_KD_SUPPLIER=:KodeSupplier ORDER BY 1 DESC");
                $this->db->bind('TglPeriodeAwal', $TglPeriodeAwal);
                $this->db->bind('TglPeriodeAkhir', $TglPeriodeAkhir);
                $this->db->bind('KodeSupplier', $KodeSupplier);
                $data =  $this->db->resultSet();
            }
            
            $rows = array();
            $array = array();
            $no = 0;
            foreach ($data as $key) {
                $no++; 
                $pasing['no'] = $no;
                $pasing['FS_KD_TRS'] = $key['FS_KD_TRS'];
                $pasing['Namapetugas'] = $key['Namapetugas'];
                $pasing['FS_TGL_TRS'] = $key['FS_TGL_TRS'];
                $pasing['fs_ket'] = $key['fs_ket'];
                $pasing['FN_TOTAL'] = $key['FN_TOTAL'];
                $pasing['Company'] = $key['Company']; 
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function showDeliveryOrderbyUser($data)
    {
        try { 
            $session = SessionManager::getCurrentSession();
            $UserCreate = $session->username;
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '{ 
                "UserCreate" : "' . $UserCreate . '" 
            }';
            $urlAddKelompok = "transaction/deliveryorder/getDeliveryOrderbyDateUser/";
            $addSatuan = $this->curl_request(
                GenerateTokenRS::headers_api_token($token['access_token']),
                $method_getgroup,
                $postData,
                $urlAddKelompok
            );
            return $addSatuan['data'];
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDeliveryOrderbyID($data)
    {
        try {
            $session = SessionManager::getCurrentSession();
            $UserCreate = $session->username;
            $NoTrs = $data['NoTrs'];
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '{ 
                "TransactionCode" : "' . $NoTrs . '" 
            }';
            $urlAddKelompok = "transaction/deliveryorder/getDeliveryOrderbyID/";
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

    public function getDeliveryOrderDetailbyID($data)
    {
        try {
            $session = SessionManager::getCurrentSession();
            $UserCreate = $session->username;
            $TransasctionCode = $data['TransasctionCode'];
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '{ 
                "TransactionCode" : "' . $TransasctionCode . '" 
            }';
            $urlAddKelompok = "transaction/deliveryorder/getDeliveryOrderDetailbyID/";
            $addSatuan = $this->curl_request(
                GenerateTokenRS::headers_api_token($token['access_token']),
                $method_getgroup,
                $postData,
                $urlAddKelompok
            );
            return $addSatuan['data'];
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function goFinishEditTukarFaktur($data)
    {
        try {
            //$no_purchaseorder = $createOrderNumber['no_purchaseorder']; 

            $No_Transaksi = $data['No_Transaksi'];
            $Keterangan = $data['Keterangan_PO'];
            $PO_KodeSupplier = $data['PO_KodeSupplier'];
            $No_Request = $data['No_PurchasingOrder'];
            $TransasctionDate = $data['TransasctionDate'];
            $grandtotalqty = str_replace(".", "", $data['grandtotalqty']);
            $subtotalttlrp = str_replace(".", "", $data['subtotalttlrp']);
            $taxxRp = str_replace(".", "", $data['taxxRp']);
            $grandtotalxl = str_replace(".", "", $data['grandtotalxl']);
            $totalrow = str_replace(".", "", $data['totalrow']);
            $Unit = $data['Unit'];

            $grandtotalqty = str_replace(",", ".", $grandtotalqty);
            $subtotalttlrp = str_replace(",", ".", $subtotalttlrp);
            $taxxRp = str_replace(",", ".", $taxxRp);
            $grandtotalxl = str_replace(",", ".", $grandtotalxl);
            $totalrow = str_replace(",", ".", $totalrow);
            
            $JenisDelivery = $data['JenisDelivery'];

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

            if ($JenisDelivery == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Jenis Delivery Kosong !',
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
            
            if ($grandtotalqty == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Hitung Data Barang Terlebih Dahulu ! (Tekan Tab Di Setiap Kolom Untuk Menghitung)',
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
            $postData = '{
                "DeliveryOrderDate" : "'.$TransasctionDate.'",
                "UserCreate" : "'.$userid.'",
                "UserEdit" : "'.$userid.'",
                "TransactionCode" : "'.$No_Transaksi.'" ,    
                "Notes" : "'.$Keterangan.'",
                "Notes1" : "notes2",
                "Notes2" : "notes3",
                "TotalQtyDelivery" : "'.$grandtotalqty.'",
                "SubtotalDelivery" : "'.$subtotalttlrp.'",
                "TaxDelivery" : "'.$taxxRp.'",
                "GrandtotalDelivery" : "'.$grandtotalxl.'",
                "PurchaseOrderCode" : "'.$No_Request.'",
                "TotalRowDO" : "'.$totalrow.'",
                "TotalQtyDO" : "'.$grandtotalqty.'",
                "JenisDelivery" : "'.$JenisDelivery.'" 
            }';
            $urlAddKelompok = "transaction/deliveryorder/editDeliveryOrder/";
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

    public function goVoidDeliveryOrder($data)
    {
        try {

            $No_Transaksi = $data['No_Transaksi'];
            $AlasanBatal = $data['AlasanBatal'];
            $Unit = $data['Unit'];

            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $name = $session->name;

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '{
                            "TransactionCode" : "'.$No_Transaksi.'" ,
                            "DateVoid" : "'.$datenowcreate.'",
                            "UserVoid" : "'.$userid.'",
                            "Void" : "1",
                            "ReasonVoid" : "'.$AlasanBatal.'",
                            "UnitCode" : "'.$Unit.'"
                        }';
            $urlAddKelompok = "transaction/deliveryorder/voidDeliveryOrder/";
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

    public function goVoidPurchaseOrderDetails($data)
    {
        try {

            $No_Transaksi = $data['No_Transaksi'];
            $AlasanBatal = $data['AlasanBatal'];
            $product_code = $data['product_code'];

            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $name = $session->name;

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '{
                "PurchaseCode" : "'.$No_Transaksi.'" ,
                "ProductCode" : "'.$product_code.'" ,
                "DateVoid" : "'.$datenowcreate.'",
                "UserVoid" : "'.$userid.'",
                "Void" : "1",
                "ReasonVoid" : "'.$product_code.'"
                        }';
            $urlAddKelompok = "transaction/purchaseorder/voidPurchaseOrderDetailbyItem/";
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