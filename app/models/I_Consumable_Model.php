<?php

class I_Consumable_Model
{
    private $db;
    use ApiRsyarsi;


    public function __construct()
    {
        $this->db = new Database;
    }

    public function getConsumablebyDateUser()
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
            $urlAddKelompok = "transaction/consumable/getConsumablebyDateUser/";
            $addSatuan = $this->curl_request(
                GenerateTokenRS::headers_api_token($token['access_token']),
                $method_getgroup,
                $postData,
                $urlAddKelompok
            );
            if ($addSatuan['status'] == true){
                $callback = $addSatuan['data'];
            }else{
                $callback = [];
            }
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getConsumablebyPeriode($data)
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
            $urlAddKelompok = "transaction/consumable/getConsumablebyPeriode/";
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

    public function getConsumablebyID($data)
    {
        try { 
            $session = SessionManager::getCurrentSession();
            $UserCreate = $session->username;
            $TransactionCode = $data['TransasctionCode'];
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
            $urlAddKelompok = "transaction/consumable/getConsumablebyID/";
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

    public function getConsumableDetailbyID($data)
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
            $urlAddKelompok = "transaction/consumable/getConsumableDetailbyID/";
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

    public function voidConsumable($data)
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
            $postData = '
            {
                "TransactionCode" : "'.$No_Transaksi.'" ,
                "UnitCode" : "'.$Unit.'",
                "DateVoid" : "'.$datenowcreate.'",
                "UserVoid" :"'.$userid.'",
                "Void" : "1",
                "ReasonVoid" : "'.$AlasanBatal.'"
            }
            ';
            $urlAddKelompok = "transaction/consumable/voidConsumable/";
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

    public function voidConsumableDetailbyItem($data)
    {
        try { 
            $TransasctionCode = $data['No_Transaksi'];
            $ProductCode = $data['ProductCode'];
            $AlasanBatal = $data['AlasanBatal'];
            $Unit = $data['Unit'];
 
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
                "TransactionCode" : "'.$TransasctionCode.'" ,
                "ProductCode" : "'.$ProductCode.'",
                "UnitCode" : "'.$Unit.'",
                "DateVoid" : "'.$DateVoid.'",
                "UserVoid" : "'.$UserCreate.'",
                "Void" : "1",
                "ReasonVoid" : "'.$AlasanBatal.'" 
            }
            ';
            $urlAddKelompok = "transaction/consumable/voidConsumableDetailbyItem/";
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
    //---

    public function addConsumableHeader($data)
    {
        try {
            $Group_Transaksi = $data['Group_Transaksi'];
            $TransasctionDate = $data['TransasctionDate'];
            $Unit = $data['Unit'];

            $Keterangan = $data['Notes'];
            $NoRegistrasi = $data['NoRegistrasi'];

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

            if ($Group_Transaksi == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Group Transaksi Kosong !',
                );
                return $callback;
                exit;
            }
            
            // if ($NoRegistrasi == "") {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => 'Nomor Registrasi Kosong !',
            //     );
            //     return $callback;
            //     exit;
            // } 
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
                "Group_Transaksi" : "'.$Group_Transaksi.'",
                "UnitCode" : "'.$Unit.'" ,
                "Notes" : "'.$Keterangan.'" ,
                "NoRegistrasi" : "'.$NoRegistrasi.'"
            }';


            $urlAddKelompok = "transaction/consumable/addConsumableHeader/";
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
    public function addConsumableDetailv2($data)
    {
        try { 

            $TransasctionCode = $data['No_Transaksi'];
            $kode_barang = $data['kode_barang'];
            $nama_barang = $data['nama_barang'];
            $satuanbesar = $data['satuanbesar'];
            $qtypakai = $data['qtypakai'];
            $UnitTujuan = $data['UnitTujuan']; 
            $satuankecil = $data['satuankecil'];
            $nilaikonversisatuan = $data['nilaikonversisatuan'];
            $hpp_barang = $data['hpp_barang'];
            $persediaan = $data['persediaan'];
            $totalpakai = $data['totalpakai'];
            //$Konversi_QtyTotal = $qtypakai*$nilaikonversisatuan;
            $Konversi_QtyTotal = $qtypakai;
            $TransactionDate = $data['TransasctionDate'];
            $datenowcreate = Utils::seCurrentDateTime();
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
                "TransactionCode" : "'.$TransasctionCode.'", 
                "ProductCode" : "'.$kode_barang.'",   
                "ProductName" : "'.$nama_barang.'",
                "ProductSatuan" : "'.$satuankecil.'",
                "Qty" : "'.$qtypakai.'",
                "KonversiQty" : "'.$nilaikonversisatuan.'",
                "Konversi_QtyTotal" : "'.$Konversi_QtyTotal.'", 
                "Satuan_Konversi" : "'.$satuankecil.'", 
                "Hpp" : "'.$hpp_barang.'",
                "Persediaan" : "'.$persediaan.'", 
                "UnitTujuan" : "'.$UnitTujuan.'",  
                "UserCreate" : "'.$UserCreate.'",
                "Total" : "'.$totalpakai.'" ,
                "TransactionDate" : "'.$TransactionDate.'"
            }
            ';
                $urlAddKelompok = "transaction/consumable/addConsumableDetailv2/";
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
    public function addConsumableDetail($data)
    {
        try { 
            $TransasctionCode = $data['No_Transaksi'];
            $Unit = $data['Unit'];
            $TransasctionDate = $data['TransasctionDate'];

            $Keterangan = $data['Notes'];
            $NoRegistrasi = $data['NoRegistrasi'];
            $Group_Transaksi = $data['Group_Transaksi'];
            
            $TotalQty = $data['TotalQty'];
            $TotalRow = $data['TotalRow'];

            $kode_barang = $data['kode_barang'];
            $nama_barang_ = $data['nama_barang_'];
            $satuan_barang_ = $data['satuan_barang_'];
            $qty_barang_ = $data['qty_barang_'];
            $hpp_barang_ = $data['hpp_barang_'];
            $total_barang_ = $data['total_barang_'];
            $satuan_konversi_ = $data['satuan_konversi_'];
            $satuan_qty_ = $data['satuan_qty_'];

            $qty_barang_ = str_replace(".", "", $data['qty_barang_']);
            $hpp_barang_ = str_replace(".", "", $data['hpp_barang_']);
            $total_barang_ = str_replace(".", "", $data['total_barang_']);

            $qty_barang_ = str_replace(",", ".", $qty_barang_);
            $hpp_barang_ = str_replace(",", ".", $hpp_barang_);
            $total_barang_ = str_replace(",", ".", $total_barang_);

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

                    $qtytotal += $qty_barang_[$x];
                    $pasing['ProductCode'] =   $kode_barang[$x];
                    $pasing['ProductSatuan'] =    $satuan_barang_[$x];
                    $pasing['Satuan_Konversi'] = $satuan_konversi_[$x];
                    $pasing['KonversiQty'] = $satuan_qty_[$x];
                    $pasing['Konversi_QtyTotal'] = $qty_barang_[$x];
                    $pasing['ProductName'] =    $nama_barang_[$x];
                    $pasing['Qty'] =   $qty_barang_[$x];
                    $pasing['Hpp'] =   $hpp_barang_[$x];
                    $pasing['Persediaan'] =   $qty_barang_[$x];//------
                    $pasing['UserAdd'] =    $UserCreate;
                    $pasing['DateAdd'] =    $datenowcreate;
                    $pasing['Total'] =    $total_barang_[$x];

                    $rows[] = $pasing;  
                }
                $list = json_encode($rows);


            // //GET FROM TABLE PRODUCT
            // $this->db->query("  SELECT * from [Apotik_V1.1SQL].dbo.TempConsumableDetails
            // where TransactionCode=:TransasctionCode");
            // $this->db->bind('TransasctionCode',   $TransasctionCode); 
            // $datas =  $this->db->resultSet();
            // $rows = array();
            // foreach ($datas as $key) {
            //     $pasing['ProductCode'] = $key['ProductCode'];
            //     $pasing['ProductSatuan'] = $key['ProductSatuan'];
            //     $pasing['Satuan_Konversi'] = $key['Satuan_Konversi'];
            //     $pasing['KonversiQty'] = $key['KonversiQty'];
            //     $pasing['Konversi_QtyTotal'] = $key['Konversi_QtyTotal'];
            //     $pasing['ProductName'] = $key['ProductName'];
            //     $pasing['QtyStok'] = $key['QtyStok'];
            //     $pasing['Qty'] = $key['Qty'];
            //     $pasing['Hpp'] = $key['Hpp'];
            //     $pasing['Persediaan'] = $key['Persediaan'];
            //     $pasing['UserAdd'] = $key['UserAdd'];
            //     $pasing['DateAdd'] = $key['DateAdd'];

            // $rows[] = $pasing; 

            // }

            // $list = json_encode($rows);
 
            
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
                "UnitTujuan" : "'.$Unit.'",   
                "Notes" : "'.$Keterangan.'",
                "Group_Transaksi" : "'.$Group_Transaksi.'",
                "TotalQtyOrder" : "'.$TotalQty.'",
                "TotalRow" : "'.$TotalRow.'",
                "TransactionDate" : "'.$TransasctionDate.'",
                "UserCreate" : "'.$UserCreate.'",
                "NoRegistrasi" : "'.$NoRegistrasi.'",
                "Items":  '.$list.'
            }
            ';
            $urlAddKelompok = "transaction/consumable/addConsumableDetail/";
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

    public function addConsumableDetails($data)
    {
        try {
            $TransasctionCode = $data['TransasctionCode'];
            $ProductCode = $data['ProductCode'];
            $ProductName = $data['ProductName'];
            $Qty = $data['QtyOrder'];
            $SatuanBarang = $data['SatuanBarang'];
            $SatuanBarang_Konversi = $data['Satuan_Konversi'];
            $Konversi_Satuan = $data['Konversi_satuan'];
            $Konversi_QtyTotal = $Konversi_Satuan * $Qty;
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

            // if ($SatuanBarang_Konversi == "") {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => 'Satuan Barang Konversi Kosong ! Silahkan Cek Kembali Di Master Barang !',
            //     );
            //     return $callback;
            //     exit;
            // }

            if ($Konversi_Satuan == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Konversi Satuan Kosong ! Silahkan Cek Kembali Di Master Barang !',
                );
                return $callback;
                exit;
            }

            if ($Qty == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Qty Kosong !',
                );
                return $callback;
                exit;
            }

            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $UserCreate = $session->username;

            $this->db->query("INSERT INTO [dbo].[TempConsumableDetails]
           (
            [TransactionCode]
           ,[ProductCode]
           ,[ProductSatuan]
           ,[Satuan_Konversi]
           ,[KonversiQty]
           ,[Konversi_QtyTotal]
           ,[ProductName]
           ,[QtyStok]
           ,[Qty]
           ,[Hpp]
           ,[Persediaan]
           ,[UserAdd]
           ,[DateAdd]
           )
           values (
            :TransactionCode
           ,:ProductCode
           ,:ProductSatuan
           ,:Satuan_Konversi
           ,:KonversiQty
           ,:Konversi_QtyTotal
           ,:ProductName
           ,:QtyStok
           ,:Qty
           ,:Hpp
           ,:Persediaan
           ,:UserAdd
           ,:DateAdd
           )
            ");
                $this->db->bind('TransactionCode', $TransasctionCode);
                $this->db->bind('ProductCode', $ProductCode);
                $this->db->bind('ProductSatuan', $SatuanBarang);
                $this->db->bind('Satuan_Konversi', $SatuanBarang_Konversi);
                $this->db->bind('KonversiQty', $Konversi_Satuan);
                $this->db->bind('Konversi_QtyTotal', $Konversi_QtyTotal);
                $this->db->bind('ProductName', $ProductName);
                $this->db->bind('QtyStok', $Qty);
                $this->db->bind('Qty', $Qty);
                $this->db->bind('Hpp', 0);
                $this->db->bind('Persediaan', 0);
                $this->db->bind('UserAdd', $UserCreate);
                $this->db->bind('DateAdd', $datenowcreate);
                $this->db->execute();

               // $this->db->commit();
               $callback = array(
                'message' => "success",
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getConsumableDetailbyIDs($data)
    {
        try {
            $TransasctionCode = $data['TransasctionCode'];
            $this->db->query("SELECT * from [Apotik_V1.1SQL].dbo.TempConsumableDetails WHERE TransactionCode=:TransasctionCode");
            $this->db->bind('TransasctionCode', $TransasctionCode);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['TransactionCode'] = $key['TransactionCode'];
                $pasing['ProductCode'] = $key['ProductCode'];
                $pasing['ProductSatuan'] = $key['ProductSatuan'];
                $pasing['Satuan_Konversi'] = $key['Satuan_Konversi'];
                $pasing['KonversiQty'] = $key['KonversiQty'];
                $pasing['Konversi_QtyTotal'] = $key['Konversi_QtyTotal'];
                $pasing['ProductName'] = $key['ProductName'];
                $pasing['QtyStok'] = $key['QtyStok'];
                $pasing['Qty'] = $key['Qty'];
                $pasing['Hpp'] = $key['Hpp'];
                $pasing['Persediaan'] = $key['Persediaan'];
                $pasing['UserAdd'] = $key['UserAdd'];
                $pasing['DateAdd'] = $key['DateAdd'];
                $rows[] = $pasing; 
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function addOrderMutasiDetailPaket($data)
    {
        try {

            $TransasctionCode = $data['TransasctionCode'];
            //$TransasctionCode = 'TOM260620240005';
            $UnitTujuan = $data['UnitTujuan'];
            $IdPaket = $data['IdPaket'];
            $NoRegistrasi = $data['NoRegistrasi'];

            
            if ($UnitTujuan == "") {
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
                "UnitTujuan" : "'.$UnitTujuan.'",
                "IdPaket" : "'.$IdPaket.'",
                "NoRegistrasi" : "'.$NoRegistrasi.'"
            }
            ';
            $urlAddKelompok = "transaction/consumable/addConsumableDetailPaket/";
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