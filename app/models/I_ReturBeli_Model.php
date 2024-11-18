<?php

class I_ReturBeli_Model
{
    private $db;
    use ApiRsyarsi;


    public function __construct()
    {
        $this->db = new Database;
    }

    public function getReturBelibyDateUser()
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
            $urlAddKelompok = "transaction/returbeli/getReturBelibyDateUser/";
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

    public function getReturBelibyID($data)
    {
        try {
            $session = SessionManager::getCurrentSession();
            $UserCreate = $session->username;
            $TransasctionCode = $data['TransactionCode'];
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
            $urlAddKelompok = "transaction/returbeli/getReturBelibyID/";
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

    public function addReturBeliHeader($data)
    {
        try {
            $TransasctionDate = $data['TransasctionDate'];
            $LokasiStok = $data['LokasiStok'];
            $KodeSupplier = $data['KodeSupplier'];
            $NoDeliveryOrder = $data['NoDeliveryOrder'];
            $Notes = $data['Notes'];
            
            if ($TransasctionDate == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Tgl Transaksi Kosong !',
                );
                return $callback;
                exit;
            }

            if ($LokasiStok == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Lokasi Stok Mutasi Kosong !',
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
                "UnitCode" : "'.$LokasiStok.'" ,
                "DeliveryCode" : "'.$NoDeliveryOrder.'",
                "Notes" : "'.$Notes.'",
                "SupplierCode" : "'.$KodeSupplier.'"
            }
            
            ';
            $urlAddKelompok = "transaction/returbeli/addReturBeliHeader/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, 
                                            $postData, $urlAddKelompok);
            return $addSatuan;
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
            $Satuan_Konversi = $data['Satuan_Konversi'];
            $Konversi_satuan = $data['Konversi_satuan'];
            $Konversi_QtyTotal = $Konversi_satuan*$QtyOrder;
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

    public function getReturBeliDetailbyID($data)
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
                "TransactionCode" : "' . $TransasctionCode . '" 
            }';
            $urlAddKelompok = "transaction/returbeli/getReturBeliDetailbyID/";
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

    public function addReturBeliFinish($data)
    {
        try {
            $TransasctionDate = $data['TransasctionDate'];
            $UnitCode = $data['LokasiStok'];
            $Notes = $data['Notes'];
            $NoDeliveryOrder = $data['NoDeliveryOrder'];
            $KodeSupplier = $data['KodeSupplier'];
            
            if ($TransasctionDate == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Tgl Transaksi Kosong !',
                );
                return $callback;
                exit;
            }

            if ($UnitCode == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Lokasi Awal Order Mutasi Kosong !',
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


            $TransactionCode = $data['NoOrderTransaksi'];

            $hidden_kode_barang =$data['hidden_kode_barang'];
            $hidden_nama_barang_ = $data['hidden_nama_barang_'];
            $hidden_satuan_barang_ = $data['hidden_satuan_barang_'];
            $hidden_min_barang_ =  str_replace(".", "", $data['hidden_min_barang_']) ;
            $hidden_qty_barang_ =  str_replace(".", "", $data['hidden_qty_barang_']) ;
            $grandtotalqty =  str_replace(".", "", $data['grandtotalqty']) ;
            $hidden_harga_barang_ =  str_replace(".", "", $data['hidden_harga_barang_']) ;
            $hidden_subtotal_ =  str_replace(".", "", $data['hidden_subtotal_']) ;
            $totalrow =  str_replace(".", "", $data['totalrow']) ;

            $hidden_min_barang_ =   str_replace(",", ".", $hidden_min_barang_) ;
            $hidden_qty_barang_ =   str_replace(",", ".", $hidden_qty_barang_) ;
            $grandtotalqty =   str_replace(",", ".", $grandtotalqty) ;
            $hidden_harga_barang_ =   str_replace(",", ".", $hidden_harga_barang_) ;
            $hidden_subtotal_ =   str_replace(",", ".", $hidden_subtotal_) ;
            $totalrow =   str_replace(",", ".", $totalrow) ;
            
            
            $Satuan_Konversi = $data['Satuan_Konversi'];
            $KonversiQty = $data['KonversiQty'];
           // $totalrow = $data['totalrow'];

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

                    $qtytotal += $hidden_qty_barang_[$x];
                    $pasing['TransactionCode'] =   $hidden_kode_barang[$x];
                    $pasing['ProductCode'] =    $hidden_kode_barang[$x];
                    $pasing['ProductName'] = $hidden_nama_barang_[$x];
                    $pasing['ProductSatuan'] = $Satuan_Konversi[$x];
                    $pasing['HargaRetur'] = $hidden_harga_barang_[$x];
                    $pasing['HargaBeli'] =    $hidden_harga_barang_[$x];
                    $pasing['QtyDeliveryRemain'] =   $hidden_min_barang_[$x];
                    $pasing['QtyRetur'] =   $hidden_qty_barang_[$x];
                    $pasing['KonversiQty'] =   $KonversiQty[$x];
                    $pasing['Satuan'] =   $hidden_satuan_barang_[$x];
                    $pasing['TotalHargaRetur'] =   $hidden_subtotal_[$x];
                    $pasing['UserAdd'] =    $userid;
                    $pasing['Konversi_QtyTotal'] =   $hidden_qty_barang_[$x]*$KonversiQty[$x];//------
                    $pasing['Satuan_Konversi'] =   $Satuan_Konversi[$x];

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
                "DeliveryCode" : "'.$NoDeliveryOrder.'",
                "UnitCode" : "'.$UnitCode.'",
                "SupplierCode" : "'.$KodeSupplier.'",
                "Notes" : "'.$Notes.'" ,
                "TotalQtyReturBeli" : "'.$grandtotalqty.'" ,
                "TotalRow" : "'.$totalrow.'",
                "TotalQtyReturBeli" : "'.$TransasctionDate.'",
                "TransactionDate" : "'.$TransasctionDate.'",
                "UserCreate" : "'.$userid.'",
                "Items":  ' . $list . '
            }
            ';
            $urlAddKelompok = "transaction/returbeli/addReturBeliFinish/";
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

    public function voidReturBeli($data)
    {
        try {
            $No_Transaksi = $data['NoOrderTransaksi'];
            $UnitCode = $data['LokasiStok'];
            $AlasanBatal = $data['AlasanBatal'];
            $NoDeliveryOrder = $data['NoDeliveryOrder'];
            
            if ($No_Transaksi == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No Transaksi Kosong !',
                );
                return $callback;
                exit;
            }

            if ($UnitCode == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Lokasi Kosong !',
                );
                return $callback;
                exit;
            }

            if ($NoDeliveryOrder == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No Delivery Code Kosong !',
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
                "DeliveryCode" : "'.$NoDeliveryOrder.'" ,
                "UnitCode" : "'.$UnitCode.'" ,
                "DateVoid" : "'.$datenowcreate.'",
                "UserVoid" : "'.$UserCreate.'",
                "Void" : "1" ,
                "ReasonVoid" : "'.$AlasanBatal.'"
            }
            ';
            $urlAddKelompok = "transaction/returbeli/voidReturBeli/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, 
                                            $postData, $urlAddKelompok);
            return $addSatuan;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function voidReturBeliDetailbyItem($data)
    {
        try {
            $No_Transaksi = $data['NoOrderTransaksi'];
            $UnitCode = $data['LokasiStok'];
            $AlasanBatal = $data['AlasanBatal'];
            $NoDeliveryOrder = $data['NoDeliveryOrder'];
            $product_code = $data['product_code'];
            $product_name = $data['product_name'];
            $konversi_qty = $data['konversi_qty'];
            $konversi_qty_total = $data['qty_barang']*$data['konversi_qty'];;
            
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
                "TransactionCode" : "'.$No_Transaksi.'", 
                "DeliveryCode" : "'.$NoDeliveryOrder.'", 
                "ProductCode" : "'.$product_code.'",
                "ProductName" : "'.$product_name.'",
                "UnitCode" : "'.$UnitCode.'",
                "DateVoid" : "'.$datenowcreate.'",
                "UserVoid" : "'.$UserCreate.'",
                "Void" : "1",
                "ReasonVoid" : "'.$AlasanBatal.'",
                "KonversiQty" : "'.$konversi_qty.'",
                "Konversi_QtyTotal" : "'.$konversi_qty_total.'"
            }
            ';
            $urlAddKelompok = "transaction/returbeli/voidReturBeliDetailbyItem/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, 
                                            $postData, $urlAddKelompok);
            return $addSatuan;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    

    

     
}