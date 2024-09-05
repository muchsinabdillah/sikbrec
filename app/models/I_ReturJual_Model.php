<?php

class I_ReturJual_Model
{
    private $db;
    use ApiRsyarsi;


    public function __construct()
    {
        $this->db = new Database;
    }

    public function getReturJualbyDateUser()
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
            $urlAddKelompok = "transaction/returjual/getReturJualbyDateUser/";
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

    public function getReturJualbyID($data)
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
                "TransactionCode" : "' . $TransasctionCode . '" 
            }';
            $urlAddKelompok = "transaction/returjual/getReturJualbyID/";
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

    public function addReturJualHeader($data)
    {
        try {
            $NoOrderTransaksi = $data['NoOrderTransaksi'];
            $NoRegistrasi = $data['NoRegistrasi'];
            $TglTransaksi = $data['TglTransaksi'];
            $NamaPasien = $data['NamaPasien'];
            $NoMR = $data['NoMR'];
            $NoEpisode = $data['NoEpisode'];
            $JenisKelamin = $data['JenisKelamin'];
            $UnitCode = $data['UnitCode'];
            $UnitCodex = $data['UnitCode'];
            $UnitSales = $data['UnitSales'];
            $UnitSalesx = $data['UnitSales'];
            $Alamat = $data['Alamat'];
            $Notes = $data['Notes'];
            $Jaminan = $data['Jaminan'];
            $KodeJaminan = $data['KodeJaminan'];
            $TipePasien = $data['TipePasien'];
            $KodeKelas = $data['KodeKelas'];
            $TransasctionDate = $data['TransasctionDate'];
            $NoResep = $data['NoResep'];
            $TransactionCodeReff = $data['TransactionCodeReff'];
            
            if ($TransasctionDate == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Tgl Transaksi Kosong !',
                );
                return $callback;
                exit;
            }

            if ($UnitCodex == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Unit Code Kosong !',
                );
                return $callback;
                exit;
            }

            if ($UnitSales == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Unit Sales Kosong !',
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

            if ($NoResep == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No Resep Kosong !',
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
                "TransactionDate" : "'.$TransasctionDate.'",
                "UserCreate" : "'.$UserCreate.'",
                "UnitCode" : "'.$UnitCodex.'", 
                "UnitSales" : "'.$UnitSales.'", 
                "NoResep" : "'.$NoResep.'", 
                "Group_Transaksi" : "RESEP", 
                "SalesCode" : "'.$TransactionCodeReff.'" , 
                "NoRegistrasi" : "'.$NoRegistrasi.'" ,  
                "Notes" : "'.$Notes.'" 
            }
            
            ';
            $urlAddKelompok = "transaction/returjual/addReturJualHeader/";
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

    public function getReturJualDetailbyID($data)
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
            $urlAddKelompok = "transaction/returjual/getReturJualDetailbyID/";
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

    public function addReturJualFinish($data)
    {
        try {
            // var_dump($data);exit;

            $NoOrderTransaksi = $data['NoOrderTransaksi'];
            $TransactionCodeReff = $data['TransactionCodeReff'];
            $NamaPasien = $data['NamaPasien'];
            $NoMR = $data['NoMR'];
            $NoEpisode = $data['NoEpisode'];
            $JenisKelamin = $data['JenisKelamin'];
            //$UnitCode = $data['UnitCode'];
            $UnitCodex = $data['UnitCode'];
            $Alamat = $data['Alamat'];
            $UnitSales = $data['UnitSales'];
            $UnitSalesx = $data['UnitSales'];
            $Jaminan = $data['Jaminan'];
            $KodeJaminan = $data['KodeJaminan'];
            $TipePasien = $data['TipePasien'];
            $KodeKelas = $data['KodeKelas'];
            $Notes = $data['Notes'];
            $NoResep = $data['NoResep'];
            $NoRegistrasi = $data['NoRegistrasi'];

            $hidden_kode_barang = $data['hidden_kode_barang'];
            $hidden_nama_barang_ = $data['hidden_nama_barang_'];
            $hidden_satuan_barang_ = $data['hidden_satuan_barang_'];
            $hidden_min_barang_ = $data['hidden_min_barang_'];
            $hidden_qty_barang_ = $data['hidden_qty_barang_'];
            $hidden_harga_barang_ = $data['hidden_harga_barang_'];
            $KonversiQty = $data['KonversiQty'];
            $Satuan_Konversi = $data['Satuan_Konversi'];
            $hidden_subtotal_ = $data['hidden_subtotal_'];
            $grandtotalqty = $data['grandtotalqty'];
            $totalrow = $data['totalrow'];
            $grandtotalxl = $data['grandtotalxl'];
            $TransasctionDate = $data['TransasctionDate'];

            $TransasctionDate = $data['TransasctionDate'];
            
            if ($TransasctionDate == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Tgl Transaksi Kosong !',
                );
                return $callback;
                exit;
            }

            if ($UnitCodex == "") {
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
            $hargatotal =0;
            $nourut=0;
            $rows = array();
            for($x=0;$x<$jumlah_dipilih;$x++){
                
                //END CEK
                    $nourut++;
                    $qtytotal += $hidden_qty_barang_[$x];
                    $hargatotal += $hidden_harga_barang_[$x];
                    
                    $pasing['ProductCode'] =  $hidden_kode_barang[$x];
                    $pasing['ProductSatuan'] = $hidden_satuan_barang_[$x];
                    $pasing['Satuan_Konversi'] = $hidden_satuan_barang_[$x];
                    $pasing['KonversiQty'] = $KonversiQty[$x];
                    $pasing['Konversi_QtyTotal'] =  $hidden_qty_barang_[$x]*$KonversiQty[$x];
                    $pasing['ProductName'] = $hidden_nama_barang_[$x];
                    $pasing['QtySales'] = $hidden_min_barang_[$x];
                    $pasing['QtyReturJual'] = $hidden_qty_barang_[$x];
                    $pasing['ReturPrice'] = $hidden_harga_barang_[$x];
                    $pasing['TotalReturJual'] = $hidden_subtotal_[$x];
                    $pasing['SatuanBeli'] = $Satuan_Konversi[$x];
                    $pasing['UserAdd'] = $userid;
                    $pasing['DateAdd'] = $datenowcreate;

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
                "SalesCode" : "'.$TransactionCodeReff.'",
                "NoResep" : "'.$NoResep.'",
                "UnitCode" : "'.$UnitCodex.'", 
                "UnitSales" : "'.$UnitSales.'", 
                "Group_Transaksi" : "RESEP",  
                "Notes" : "'.$Notes.'",
                "NoRegistrasi" : "'.$NoRegistrasi.'",
                "TotalQtyReturJual" : "'.$qtytotal.'" ,
                "TotalQtysales" : "'.$qtytotal.'",
                "TotalRow" : "'.$jumlah_dipilih.'",
                "TotalReturJualRp" : "'.$hargatotal.'",
                "TransactionDate" : "'.$TransasctionDate.'", 
                "UserCreate" : "'.$userid.'",
                "Items":  ' . $list . '
            }
            ';
            $urlAddKelompok = "transaction/returjual/addReturJualFinish/";
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

    public function voidReturJual($data)
    {
        try {
            $No_Transaksi = $data['NoOrderTransaksi'];
            $UnitCodex = $data['UnitCode'];
            $NoRegistrasi = $data['NoRegistrasi'];
            $AlasanBatal = $data['AlasanBatal'];
            $TransactionCodeReff = $data['TransactionCodeReff'];
            
            if ($No_Transaksi == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No Transaksi Kosong !',
                );
                return $callback;
                exit;
            }

            if ($UnitCodex == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Lokasi Kosong !',
                );
                return $callback;
                exit;
            }

            if ($TransactionCodeReff == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No Sales Code Kosong !',
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
                "SalesCode" : "'.$TransactionCodeReff.'" ,
                "NoRegistrasi" : "'.$NoRegistrasi.'" ,
                "UnitCode" : "'.$UnitCodex.'" ,
                "DateVoid" : "'.$datenowcreate.'",
                "UserVoid" : "'.$UserCreate.'",
                "Void" : "1" ,
                "ReasonVoid" : "'.$AlasanBatal.'"
            }
            ';
            $urlAddKelompok = "transaction/returjual/voidReturJual/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, 
                                            $postData, $urlAddKelompok);
            return $addSatuan;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function voidReturJualDetailbyItem($data)
    {
        try {
            $No_Transaksi = $data['NoOrderTransaksi'];
            $UnitCode = $data['UnitCode'];
            $AlasanBatal = $data['AlasanBatal'];
            $NoRegistrasi = $data['NoRegistrasi'];
            $TransactionCodeReff = $data['TransactionCodeReff'];
            $product_code = $data['product_code'];
            // $product_name = $data['product_name'];
            // $konversi_qty = $data['konversi_qty'];
            // $konversi_qty_total = $data['qty_barang']*$data['konversi_qty'];;
            
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
                "SalesCode" : "'.$TransactionCodeReff.'",
                "ProductCode" : "'.$product_code.'",
                "UnitCode" : "'.$UnitCode.'",
                "NoRegistrasi" : "'.$NoRegistrasi.'",
                "DateVoid" : "'.$datenowcreate.'",
                "UserVoid" : "'.$UserCreate.'",
                "Void" : "1",
                "ReasonVoid" : "'.$AlasanBatal.'"
            }
            ';
            $urlAddKelompok = "transaction/returjual/voidReturJualDetailbyItem/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, 
                                            $postData, $urlAddKelompok);
            return $addSatuan;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    
    public function addReturJualHeaderbyNoReg($data)
    {
        try {
            $NoOrderTransaksi = $data['NoOrderTransaksi'];
            $NoRegistrasi = $data['NoRegistrasi'];
            $TglTransaksi = $data['TglTransaksi'];
            $NamaPasien = $data['NamaPasien'];
            $NoMR = $data['NoMR'];
            $NoEpisode = $data['NoEpisode'];
            $JenisKelamin = $data['JenisKelamin'];
            $UnitCode = $data['UnitCode'];
            $UnitCodex = $data['UnitCode'];
            $UnitSales = $data['UnitSales'];
            $UnitSalesx = $data['UnitSales'];
            $Alamat = $data['Alamat'];
            $Notes = $data['Notes'];
            $Jaminan = $data['Jaminan'];
            $KodeJaminan = $data['KodeJaminan'];
            $TipePasien = $data['TipePasien'];
            $KodeKelas = $data['KodeKelas'];
            $TransasctionDate = $data['TransasctionDate'];
            //$NoResep = $data['NoResep'];
            //$TransactionCodeReff = $data['TransactionCodeReff'];
            
            if ($TransasctionDate == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Tgl Transaksi Kosong !',
                );
                return $callback;
                exit;
            }

            if ($UnitCodex == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Unit Code Kosong !',
                );
                return $callback;
                exit;
            }

            if ($UnitSales == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Unit Sales Kosong !',
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

            // if ($NoResep == "") {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => 'No Resep Kosong !',
            //     );
            //     return $callback;
            //     exit;
            // }

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
                "TransactionDate" : "'.$TransasctionDate.'",
                "UserCreate" : "'.$UserCreate.'",
                "UnitCode" : "'.$UnitCodex.'", 
                "UnitSales" : "'.$UnitSales.'", 
                "Group_Transaksi" : "RESEP", 
                "NoRegistrasi" : "'.$NoRegistrasi.'" ,  
                "Notes" : "'.$Notes.'" ,
                "SalesCode" : "-" ,  
                "NoResep" : "-" 
            }
            
            ';
            $urlAddKelompok = "transaction/returjual/addReturJualHeaderbyNoReg/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, 
                                            $postData, $urlAddKelompok);
            return $addSatuan;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function addReturJualFinishbyReg($data)
    {
        try {
            $NoOrderTransaksi = $data['NoOrderTransaksi'];
            //$TransactionCodeReff = $data['TransactionCodeReff'];
            $NamaPasien = $data['NamaPasien'];
            $NoMR = $data['NoMR'];
            $NoEpisode = $data['NoEpisode'];
            $JenisKelamin = $data['JenisKelamin'];
            //$UnitCode = $data['UnitCode'];
            $UnitCodex = $data['UnitCode'];
            $Alamat = $data['Alamat'];
            $UnitSales = $data['UnitSales'];
            $UnitSalesx = $data['UnitSales'];
            $Jaminan = $data['Jaminan'];
            $KodeJaminan = $data['KodeJaminan'];
            $TipePasien = $data['TipePasien'];
            $KodeKelas = $data['KodeKelas'];
            $Notes = $data['Notes'];
            //$NoResep = $data['NoResep'];
            $NoRegistrasi = $data['NoRegistrasi'];

            $hidden_kode_barang = $data['hidden_kode_barang'];
            $hidden_nama_barang_ = $data['hidden_nama_barang_'];
            $hidden_satuan_barang_ = $data['hidden_satuan_barang_'];
            $hidden_min_barang_ = $data['hidden_min_barang_'];
            $hidden_qty_barang_ = $data['hidden_qty_barang_'];
            $hidden_harga_barang_ = $data['hidden_harga_barang_'];
            $KonversiQty = $data['KonversiQty'];
            $Satuan_Konversi = $data['Satuan_Konversi'];
            $hidden_subtotal_ = $data['hidden_subtotal_'];
            $grandtotalqty = $data['grandtotalqty'];
            $totalrow = $data['totalrow'];
            $grandtotalxl = $data['grandtotalxl'];
            $TransasctionDate = $data['TransasctionDate'];

            $TransasctionDate = $data['TransasctionDate'];
            
            if ($TransasctionDate == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Tgl Transaksi Kosong !',
                );
                return $callback;
                exit;
            }

            if ($UnitCodex == "") {
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

            $hidden_id_detail = $data['hidden_id_detail'];
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
            $hargatotal =0;
            $nourut=0;
            $rows = array();
            for($x=0;$x<$jumlah_dipilih;$x++){
                
                //END CEK
                    $nourut++;
                    $qtytotal += $hidden_qty_barang_[$x];
                    $hargatotal += $hidden_harga_barang_[$x];
                    
                    $pasing['IDDetail'] =  $hidden_id_detail[$x];
                    $pasing['ProductCode'] =  $hidden_kode_barang[$x];
                    $pasing['ProductSatuan'] = $hidden_satuan_barang_[$x];
                    $pasing['Satuan_Konversi'] = $hidden_satuan_barang_[$x];
                    $pasing['KonversiQty'] = $KonversiQty[$x];
                    $pasing['Konversi_QtyTotal'] =  $hidden_qty_barang_[$x]*$KonversiQty[$x];
                    $pasing['ProductName'] = $hidden_nama_barang_[$x];
                    $pasing['QtySales'] = $hidden_min_barang_[$x];
                    $pasing['QtyReturJual'] = $hidden_qty_barang_[$x];
                    $pasing['ReturPrice'] = $hidden_harga_barang_[$x];
                    $pasing['TotalReturJual'] = $hidden_subtotal_[$x];
                    $pasing['SatuanBeli'] = $Satuan_Konversi[$x];
                    $pasing['UserAdd'] = $userid;
                    $pasing['DateAdd'] = $datenowcreate;

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
                "UnitCode" : "'.$UnitCodex.'", 
                "UnitSales" : "'.$UnitSales.'", 
                "Group_Transaksi" : "RESEP",  
                "Notes" : "'.$Notes.'",
                "NoRegistrasi" : "'.$NoRegistrasi.'",
                "TotalQtyReturJual" : "'.$qtytotal.'" ,
                "TotalQtysales" : "'.$qtytotal.'",
                "TotalRow" : "'.$jumlah_dipilih.'",
                "TotalReturJualRp" : "'.$hargatotal.'",
                "TransactionDate" : "'.$TransasctionDate.'", 
                "UserCreate" : "'.$userid.'",
                "Items":  ' . $list . '
            }
            ';
            $urlAddKelompok = "transaction/returjual/addReturJualFinishbyReg/";
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
    

     
}