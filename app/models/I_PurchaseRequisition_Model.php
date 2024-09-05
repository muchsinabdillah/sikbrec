<?php
class I_PurchaseRequisition_Model
{
    private $db;
    use ApiRsyarsi;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function createHeaderTrs($data)
    {
        try {
            $TransasctionDate = $data['TransasctionDate'];
            $Type = $data['Type'];
            $Unit = $data['Unit'];
            $Notes = $data['Notes'];

            if ($TransasctionDate == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Tgl Transaksi Kosong !',
                );
                return $callback;
                exit;
            }

            if ($Type == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Jenis Transaksi Kosong !',
                );
                return $callback;
                exit;
            }

            if ($Unit == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Unit Transaksi Kosong !',
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
            $postData = '{ 
                "TransasctionDate" : "' . $TransasctionDate . '",
                "UserCreate" : "' . $UserCreate . '",
                "Type" : "' . $Type . '",
                "Unit" : "' . $Unit . '",
                "Notes" : "' . $Notes . '"
            }';
            $urlAddKelompok = "transaction/purchaserequisition/addPurchaseRequisition/";
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
    public function getDataBarangbyName($data)
    {
        try {
            $name = $data['searchTerm'];
            if (isset($data['grupBarang'])){
                $grupBarang = $data['grupBarang'];
            }else{
                $grupBarang ='1';
            }

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '{ 
                "name" : "' . $name . '" ,
                "groupBarang" : "' . $grupBarang .'" 
            }';
            $urlAddKelompok = "masterdata/apotek/getBarangbyNameLike/";
            $addSatuan = $this->curl_request(
                GenerateTokenRS::headers_api_token($token['access_token']),
                $method_getgroup,
                $postData,
                $urlAddKelompok
            );
            if ($addSatuan['status'] == true){
                foreach ($addSatuan['data'] as $key => $jsons) { // This will search in the 2 jsons
                    $pasing['id'] = $jsons['ID'];
                    $pasing['label'] = $jsons['Product Name'];
                    $datas[] = $pasing;
                }
            }else{
                $pasing['id'] = null;
                $pasing['label'] = ' -- Data Tidak Ditemukan ! -- ';
                $datas[] = $pasing;
            }
            return $datas;
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
            $QtyPR = str_replace(",", ".", $data['QtyPR']);
            $SatuanBarang = $data['SatuanBarang'];
            $SatuanBarang_Konversi = $data['SatuanBarang_Konversi'];
            $Konversi_Satuan = $data['Konversi_Satuan'];
            // non aktifin bentar
            // $Konversi_QtyTotal = $Konversi_Satuan * $QtyPR;
            $Konversi_QtyTotal =  $QtyPR;
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
                "TransasctionCode" : "' . $TransasctionCode . '",
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
            $urlAddKelompok = "transaction/purchaserequisition/addPurchaseRequisitionDetil/";
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
    public function getPurchaseRequisitionDetailbyID($data)
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
            $urlAddKelompok = "transaction/purchaserequisition/getPurchaseRequisitionDetailbyID/";
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
    public function editPurchaseRequisition($data)
    {
        try {
            $TransasctionDate = $data['TransasctionDate'];
            $TransasctionCode = $data['TransasctionCode'];
            $TotalQty = $data['TotalQty'];
            $TotalRow = $data['TotalRow'];
            $Notes = $data['Notes'];
            if ($TransasctionCode == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. Transaksi Kosong !',
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

            if ($Notes == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Keterangan Kosong !',
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
                "TransactionDate" : "' . $TransasctionDate . '",
                "UserCreate" : "' . $UserCreate . '",
                "TransasctionCode" : "' . $TransasctionCode . '",
                "TotalQty" : "' . $TotalQty . '",
                "TotalRow" : "' . $TotalRow . '",
                "Notes" : "' . $Notes . '"
            }';
            $urlAddKelompok = "transaction/purchaserequisition/editPurchaseRequisition/";
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
    public function getPurchaseRequisitionbyDateUser($data)
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
            $urlAddKelompok = "transaction/purchaserequisition/getPurchaseRequisitionbyDateUser/";
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
    public function getPurchaseRequisitionbyID($data)
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
            $urlAddKelompok = "transaction/purchaserequisition/getPurchaseRequisitionbyID/";
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
    public function voidPurchaseRequisition($data)
    {
        try {
            $TransasctionCode = $data['TransasctionCode'];
            $AlasanBatal = $data['AlasanBatal'];
            $Void = $data['Void'];
            if ($TransasctionCode == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. Transaksi Kosong !',
                );
                return $callback;
                exit;
            }

            if ($Void == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Status Void Kosong !',
                );
                return $callback;
                exit;
            }

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
                "DateVoid" : "' . $DateVoid . '",
                "UserVoid" : "' . $UserCreate . '",
                "TransasctionCode" : "' . $TransasctionCode . '",
                "Void" : "' . $Void . '" ,
                "ReasonVoid" : "' . $AlasanBatal . '"
            }';
            $urlAddKelompok = "transaction/purchaserequisition/voidPurchaseRequisition/";
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

    public function getPurchaseRequisitionbyPeriode($data)
    {
        try {
            $tglawal = $data['tglawal_pr'];
            $tglakhir = $data['tglakhir_pr'];
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '
            {
                "StartPeriode" : "' . $tglawal . '" ,
                "EndPeriode" : "' . $tglakhir . '" 
            }
            ';
            $urlAddKelompok = "transaction/purchaserequisition/getPurchaseRequisitionbyPeriode/";
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

    public function getBarangbyId($data)
    {
        try {
            $id = $data['IDbarang'];

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "GET";
            $urlAddKelompok = "masterdata/apotek/getBarangbyId/" . $id;
            $getGroupbyId = $this->curl_request(
                GenerateTokenRS::headers_api_token($token['access_token']),
                $method_getgroup,
                [],
                $urlAddKelompok
            );
            if (
                $getGroupbyId['status'] == 1
            ) {
                $callback = array(
                    'status' => 'success',
                    'message' => $getGroupbyId['message'],
                    'data' => $getGroupbyId['data']
                );
            } else {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => "Data Kosong",

                );
            }
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function SaveApprovePR($data)
    {
        try {
            $nopin = $data['nopin_ext'];
            $no_trs = $data['no_trs'];
            $datenowcreate = Utils::seCurrentDateTime();

            if ($nopin == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No PIN Kosong !',
                );
                return $callback;
            }

           // 1. Gen Token
           $method = "POST";
           $URL = "genToken";
           $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

           // 2. add Data Group Barang 
           $method_getgroup = "POST";
           // 2. add Data Golongan
           $postData = '{
                            "DateApprove" : "'.$datenowcreate.'",
                            "UserApprove" : "'.$nopin.'",
                            "PurchaseRequisitonCode" : "'.$no_trs.'" 
                        }';
           $urlAddKelompok = "transaction/purchaserequisition/approval/";
           $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, 
                                           $postData, $urlAddKelompok);       
           return $addSatuan;
        } catch (PDOException $e) { 
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function GetApproveName($data)
    {
        try {
            $nopin = $data['nopin'];
            $session = SessionManager::getCurrentSession();
            $IDEmployee = $session->IDEmployee;

            if ($nopin == "") {
                $callback = array(
                    'status' => 'danger',
                    'message' => 'No PIN Kosong !',
                );
                return $callback;
                exit;
            }

            $this->db->query("SELECT ID,NoPIN,username,NoPIN,FileDocument FROM MasterDataSQL.dbo.Employees WHERE TTD_Pegawai=:nopin
             ");
            $this->db->bind('nopin', $nopin);
            $key =  $this->db->single();
            $pasing['ID'] = $key['ID'];
            $pasing['username'] = $key['username'];
            $pasing['NoPIN'] = $key['NoPIN'];
            $pasing['FileDocument'] = $key['FileDocument'];

            // if ($key['ID'] != $IDEmployee) {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => 'No PIN Anda Salah, Silahkan Dicoba Lagi !',
            //     );
            //     return $callback;
            //     exit;
            // }
                
            if ($key['ID'] == null ){
                $callback = array(
                    'status' => "danger", // Set array nama 
                    'message' => "Data Tidak Ditemukan !",
                    'data' => $pasing
                );
                return $callback;
            }
            // }else{
            $callback = array(
                'status' => "success", // Set array nama 
                //'message' => "Data Berhasil Ditemukan !",
                'data' => $pasing
            );

            //}
            //var_dump($callback);
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    //APPROVE PO
    public function SaveApprovePO($data)
    {
        try { 
            $nopin = $data['nopin_ext'];
            $no_trs = $data['no_trs'];
            $approve_ke = $data['approve_ke'];
            $datenowcreate = Utils::seCurrentDateTime();

            if ($nopin == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No PIN Kosong !',
                );
                return $callback;
            }

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);
            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            if ($approve_ke == '1') {
                // 2. add Data Golongan
                $postData = '{
                            "DateApprove" : "'.$datenowcreate.'",
                            "UserApprove" : "'.$nopin.'",
                            "PurchaseCode" : "'.$no_trs.'" 
                }';
                $urlAddKelompok = "transaction/purchaseorder/approvalFirst/";
                $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, 
                                        $postData, $urlAddKelompok);
            } else if ($approve_ke == '2') {
                // 2. add Data Golongan
                $postData = '{
                    "DateApprove" : "'.$datenowcreate.'",
                    "UserApprove" : "'.$nopin.'",
                    "PurchaseCode" : "'.$no_trs.'" 
                }';
                $urlAddKelompok = "transaction/purchaseorder/approvalSecond/";
                $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, 
                                        $postData, $urlAddKelompok);
            } else if ($approve_ke == '3') {
                // 2. add Data Golongan
                $postData = '{
                    "DateApprove" : "'.$datenowcreate.'",
                    "UserApprove" : "'.$nopin.'",
                    "PurchaseCode" : "'.$no_trs.'" 
                }';
                $urlAddKelompok = "transaction/purchaseorder/approvalThirth/";
                $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, 
                                        $postData, $urlAddKelompok);
            }
                return $addSatuan;
        } catch (PDOException $e) { 
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function SaveApproveOM($data)
    {
        try { 

            $nopin = $data['nopin_ext'];
            $no_trs = $data['no_trs'];
            $datenowcreate = Utils::seCurrentDateTime();

            if ($nopin == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No PIN Kosong !',
                );
                return $callback;
            }

            // 1. Gen Token
           $method = "POST";
           $URL = "genToken";
           $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

           // 2. add Data Group Barang 
           $method_getgroup = "POST";
           // 2. add Data Golongan
           $postData = '{
                            "DateApprove" : "'.$datenowcreate.'",
                            "UserApprove" : "'.$nopin.'",
                            "TransactionCode" : "'.$no_trs.'" 
                        }';
           $urlAddKelompok = "transaction/ordermutasi/approval/";
           $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, 
                                           $postData, $urlAddKelompok);       
           return $addSatuan; 
        } catch (PDOException $e) { 
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function voidPurchaseRequisitionDetailbyItem($data)
    {
        try {

            $No_Transaksi = $data['No_Transaksi'];
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
            $postData = '
            {
                "TransasctionCode" : "'.$No_Transaksi.'" ,
                "ProductCode" : "'.$product_code.'" ,
                "DateVoid" : "'.$datenowcreate.'",
                "UserVoid" : "'.$userid.'",
                "Void" : "1"
            }';
            //"PurchaseCode" : "'.$No_PurchasingOrder.'"
            $urlAddKelompok = "transaction/purchaserequisition/voidPurchaseRequisitionDetailbyItem/";
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
