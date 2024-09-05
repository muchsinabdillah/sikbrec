<?php

class I_MutasiBarang_Model
{
    private $db;
    use ApiRsyarsi;


    public function __construct()
    {
        $this->db = new Database;
    }

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
                "UnitTujuan" : "'.$LayananOrderMutasi.'" ,
                "UnitOrder" : "'.$LayananTujuanMutasi.'",
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
            $QtyStok = str_replace(",", ".", $data['QtyStok']);
            $QtyOrder = str_replace(",", ".", $data['QtyOrder']);
            $SatuanBarang = $data['SatuanBarang'];
            $Satuan_Konversi = $data['Satuan_Konversi'];
            $Konversi_satuan = $data['Konversi_satuan'];
            //$Konversi_QtyTotal = $Konversi_satuan*$QtyOrder;
            $Konversi_QtyTotal = $QtyOrder;
            $QtySisaMutasi = -$QtyOrder;

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
                "Satuan_Konversi": "'.$Satuan_Konversi.'",
                "KonversiQty": "'.$Konversi_satuan.'", 
                "Konversi_QtyTotal": "'.$Konversi_QtyTotal.'",
                "QtyStok": "'.$QtyStok.'",
                "QtyOrderMutasi": "'.$QtyOrder.'",
                "QtySisaMutasi": "'.$QtyOrder.'",
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
            $urlAddKelompok = "transaction/ordermutasi/getOrderMutasiDetailRemainbyID/";
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
                "UnitOrder" : "'.$LayananTujuanMutasi.'",
                "UnitTujuan" : "'.$LayananOrderMutasi.'",
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

    public function getOrderMutasibyPeriode($data)
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
            $urlAddKelompok = "transaction/ordermutasi/getOrderMutasibyPeriode/";
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
                "UnitOrder" : "'.$LokasiTujuanStok.'" ,
                "UnitTujuan" : "'.$LokasiAwalOrder.'" ,
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

    public function goSaveMutasiBarang($data)
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
            $hidden_min_barang_ = str_replace(".", "", $data['hidden_min_barang_']);
            $hidden_qty_barang_ = str_replace(".", "", $data['hidden_qty_barang_']);
            $hidden_total_barang_ = str_replace(".", "", $data['hidden_total_barang_']);
            $hidden_hpp_barang_ = str_replace(".", "", $data['hidden_hpp_barang_']);
            

            $hidden_min_barang_ = str_replace(",", ".", $hidden_min_barang_);
            $hidden_qty_barang_ = str_replace(",", ".", $hidden_qty_barang_);
            $hidden_total_barang_ = str_replace(",", ".", $hidden_total_barang_);
            
            $Satuan_Konversi = $data['Satuan_Konversi'];
            $KonversiQty = $data['KonversiQty'];
            $totalrow = $data['totalrow'];
            //$Konversi_QtyTotal = $data['Konversi_QtyTotal'];
            //$Konversi_QtyTotal = $data['KonversiQty']*$data['hidden_qty_barang_'];

            $jumlah_dipilih = count($hidden_kode_barang);

            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;

            //var_dump($data);
            $qtytotal = 0;
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
                    $qtytotal += $hidden_qty_barang_[$x];
                    $pasing['ProductCode'] =   $hidden_kode_barang[$x];
                    $pasing['ProductSatuan'] =    $hidden_satuan_barang_[$x];
                    $pasing['Satuan_Konversi'] = $Satuan_Konversi[$x];
                    $pasing['KonversiQty'] = $KonversiQty[$x];
                    //$pasing['Konversi_QtyTotal'] = $KonversiQty[$x]*$hidden_qty_barang_[$x];
                    $pasing['Konversi_QtyTotal'] = $hidden_qty_barang_[$x];
                    $pasing['ProductName'] =    $hidden_nama_barang_[$x];
                    $pasing['QtyStok'] =   $hidden_min_barang_[$x];
                    $pasing['QtyOrderMutasi'] =   $hidden_min_barang_[$x];
                    $pasing['QtyMutasi'] =   $hidden_qty_barang_[$x];
                    $pasing['Hpp'] =   $hidden_hpp_barang_[$x];
                    $pasing['Persediaan'] =   $hidden_qty_barang_[$x];//------
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
                "UnitOrder" : "'.$LokasiAwalOrder.'" , 
                "UnitTujuan" : "'.$LokasiTujuanStok.'" ,
                "JenisMutasi" : "'.$jenistransaksi.'" ,
                "JenisStok" : "'.$JenisStok.'" ,
                "Notes" : "'.$Notes.'",
                "TransactionDate" : "'.$TransasctionDate.'",
                "UserCreate" : "'.$userid.'",
                "TotalQtyOrder" : "'.$qtytotal.'",
                "TotalRow" : "'.$totalrow.'",
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

    public function voidMutasi($data)
    {
        try {
            $No_Transaksi = $data['No_Transaksi'];
            $LokasiAwalOrder = $data['LokasiAwalOrder'];
            $LokasiTujuanStok = $data['LokasiTujuanStok'];
            $AlasanBatal = $data['AlasanBatal'];
            $TransactionOrderCode = $data['NoOrderMutasi'];
            $JenisStok = $data['JenisStok'];
            
            if ($No_Transaksi == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No Transaksi Kosong !',
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
                "UnitOrder" : "'.$LokasiTujuanStok.'" ,
                "UnitTujuan" : "'.$LokasiAwalOrder.'" ,
                "DateVoid" : "'.$datenowcreate.'",
                "UserVoid" : "'.$UserCreate.'",
                "Void" : "1" ,
                "ReasonVoid" : "'.$AlasanBatal.'",
                "TransactionOrderCode" : "' . $TransactionOrderCode . '",
                "JenisStok" : "' . $JenisStok . '"
            }
            ';
            $urlAddKelompok = "transaction/mutasi/voidMutasi/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, 
                                            $postData, $urlAddKelompok);
            return $addSatuan;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function voidMutasiDetailbyItem($data)
    {
        try {
            $No_Transaksi = $data['No_Transaksi'];
            $ProductCode = $data['product_code'];
            $LokasiAwalOrder = $data['LokasiAwalOrder'];
            $LokasiTujuanStok = $data['LokasiTujuanStok'];
            $AlasanBatal = $data['AlasanBatal'];
            $TransactionOrderCode = $data['NoOrderMutasi'];
            
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
                "UnitOrder" : "'.$LokasiTujuanStok.'" ,
                "UnitTujuan" : "'.$LokasiAwalOrder.'" ,
                "DateVoid" : "'.$datenowcreate.'",
                "UserVoid" : "'.$UserCreate.'",
                "Void" : "1" ,
                "ReasonVoid" : "'.$AlasanBatal.'",
                "TransactionOrderCode" : "' . $TransactionOrderCode . '"
            }
            ';
            $urlAddKelompok = "transaction/mutasi/voidMutasiDetailbyItem/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, 
                                            $postData, $urlAddKelompok);
            return $addSatuan;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function addOrderMutasiDetailPaket($data)
    {
        try {

            $TransasctionCode = $data['TransasctionCode'];
            //$TransasctionCode = 'TOM260620240005';
            $UnitOrder = $data['UnitOrder'];
            $IdPaket = $data['IdPaket'];

            
            if ($UnitOrder == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Unit Kosong !',
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
                "UserAdd" : "'.$UserCreate.'",
                "UnitOrder" : "'.$UnitOrder.'",
                "IdPaket" : "'.$IdPaket.'"
            }
            ';
            $urlAddKelompok = "transaction/ordermutasi/addOrderMutasiDetailPaket/";
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