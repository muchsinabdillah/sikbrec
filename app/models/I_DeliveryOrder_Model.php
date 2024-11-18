<?php

class I_DeliveryOrder_Model
{
    private $db;
    use ApiRsyarsi;


    public function __construct()
    {
        $this->db = new Database;
    }
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
            $Unit = $data['Unit'];

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
                "PurchaseOrderCode" : "'.$No_Request.'" ,
                "UnitCode" : "'.$Unit.'" 
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
    public function goFinishDeliveryOrder($data)
    {
        try {

            $TransactionCode = $data['No_Transaksi'];
            //$TransactionCode = 'TPO150720220008';
            $No_Request = $data['No_PurchasingOrder'];
            $JenisDelivery = $data['JenisDelivery'];
            $axPO_JenisPurchase = $data['axPO_JenisPurchase'];
            //xxx
            $hidden_kode_barang =$data['hidden_kode_barang'];
            $hidden_nama_barang_ = $data['hidden_nama_barang_'];
            $hidden_satuan_barang_ = $data['hidden_satuan_barang_'];
            $hidden_qty_barang_ = str_replace(".", "", $data['hidden_qty_barang_']);
            $hidden_harga_barang_ = str_replace(".", "", $data['hidden_harga_barang_']);
            $hidden_discpros_barang_ = str_replace(".", "", $data['hidden_discpros_barang_']);
            $hidden_discrp_barang_ = str_replace(".", "", $data['hidden_discrp_barang_']);
            $hidden_subtotal_ = str_replace(".", "", $data['hidden_subtotal_']);
            $hidden_taxprosen_ = str_replace(".", "", $data['hidden_taxprosen_']);
            $hidden_taxrp_ = str_replace(".", "", $data['hidden_taxrp_']);
            $hidden_grandtotal_ = str_replace(".", "", $data['hidden_grandtotal_']);
            $hidden_min_barang_ = str_replace(".", "", $data['hidden_min_barang_']);
            $hidden_ed_ = $data['hidden_ed_'];
            $hidden_nobatch_ = $data['hidden_nobatch_'];
            $TransasctionDate = $data['TransasctionDate'];
            $hidden_taxrp2_ = str_replace(".", "", $data['hidden_taxrp2_']);
            $hidden_discrpttl_barang_ = str_replace(".", "", $data['hidden_discrpttl_barang_']);

            $hidden_qty_barang_ = str_replace(",", ".", $hidden_qty_barang_);
            $hidden_harga_barang_ = str_replace(",", ".", $hidden_harga_barang_);
            $hidden_discpros_barang_ = str_replace(",", ".", $hidden_discpros_barang_);
            $hidden_discrp_barang_ = str_replace(",", ".", $hidden_discrp_barang_);
            $hidden_subtotal_ = str_replace(",", ".", $hidden_subtotal_);
            $hidden_taxprosen_ = str_replace(",", ".", $hidden_taxprosen_);
            $hidden_taxrp_ = str_replace(",", ".", $hidden_taxrp_);
            $hidden_grandtotal_ = str_replace(",", ".", $hidden_grandtotal_);
            $hidden_min_barang_ = str_replace(",", ".", $hidden_min_barang_);
            $hidden_taxrp2_ = str_replace(",", ".", $hidden_taxrp2_);
            $hidden_discrpttl_barang_ = str_replace(",", ".", $hidden_discrpttl_barang_);
            
            $unitsatuan = $data['satuan_konversi_'];
            $KonversiSatuan = $data['konversi_qty_'];

            $diskonxRp = $data['diskonxRp'];
            $taxxRp = $data['taxxRp'];

            $Unit = $data['Unit'];

            $jumlah_dipilih = count($hidden_kode_barang);

            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;


            //var_dump($data);

            
            

            $nourut=0;
            $rows = array();
            for($x=0;$x<$jumlah_dipilih;$x++){
                if ($hidden_qty_barang_[$x] <> 0 ){
                    // var_dump($KonversiSatuan[$x]);exit;
                $nomor = $x +1 ;
                
                //CEK
                if ($hidden_qty_barang_[$x] == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Kolom Qty DO Nomor '.$nomor.' Kosong !',
                    );
                    return $callback;
                    exit;
                } 

                if ($hidden_ed_[$x] == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Kolom Expired Date Nomor '.$nomor.' Kosong !',
                    );
                    return $callback;
                    exit;
                } 

                if ($hidden_nobatch_[$x] == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Kolom No Batch Nomor '.$nomor.' Kosong !',
                    );
                    return $callback;
                    exit;
                } 
                //END CEK
                $nourut++;

            $listprice = 0;


                 $qyt_remain =   $hidden_qty_barang_[$x] - $hidden_min_barang_[$x];

                 
            if ($KonversiSatuan[$x] > 1){
                $konversiqty_total = $KonversiSatuan[$x] * $hidden_qty_barang_[$x];
            }else{
                $konversiqty_total = 1;
            }


                    $pasing['ProductCode'] =   $hidden_kode_barang[$x];
                    $pasing['ProductSatuan'] =    $hidden_satuan_barang_[$x];
                    $pasing['ProductName'] =    $hidden_nama_barang_[$x];
                    $pasing['LastPrice'] =   $listprice;
                    $pasing['Price'] =   $hidden_harga_barang_[$x];
                    $pasing['DiscountProsen'] =    $hidden_discpros_barang_[$x];
                    $pasing['DiscountRp'] =    $hidden_discrp_barang_[$x];
                    $pasing['DiscountRpTTL'] =    $hidden_discrpttl_barang_[$x];
                    $pasing['QtyPurchase'] =    $hidden_min_barang_[$x];
                    $pasing['QtyDelivery'] =    $hidden_qty_barang_[$x];
                    $pasing['QtyDeliveryRemain'] =  $hidden_qty_barang_[$x];
                    $pasing['SubtotalDeliveryOrder'] =    $hidden_subtotal_[$x];
                    $pasing['TaxProsen'] =    $hidden_taxprosen_[$x];
                    $pasing['TaxRp'] =    $hidden_taxrp2_[$x];
                    $pasing['TaxRpTTL'] =    $hidden_taxrp_[$x];
                    $pasing['TotalDeliveryOrder'] =    $hidden_grandtotal_[$x];
                    $pasing['ExpiredDate'] =    $hidden_ed_[$x];
                    $pasing['NoBatch'] =    $hidden_nobatch_[$x];
                    $pasing['Hpp'] =    ($hidden_harga_barang_[$x]-$hidden_discrp_barang_[$x])/$KonversiSatuan[$x];//(price/koversiqty)-diskonn
                    $pasing['HppTax'] =    ($hidden_harga_barang_[$x]/$KonversiSatuan[$x]) + ($hidden_taxrp2_[$x]/$KonversiSatuan[$x]);//(price/koversiqty)+tax
                    $pasing['KonversiQty'] =    $KonversiSatuan[$x];
                    $pasing['Konversi_QtyTotal'] =    $KonversiSatuan[$x]*$hidden_qty_barang_[$x];//( KonversiQty * QtyPurchase )
                    $pasing['Satuan_Konversi'] =    $unitsatuan[$x];
                    $pasing['UserEntry'] =    $userid;
                    $pasing['DateEntry'] =    $datenowcreate;


                    $rows[] = $pasing;  
                    }
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
            "PurchaseCode" : "'.$No_Request.'",
            "UnitCode" : "'.$Unit.'",
            "TransactionDate" : "'.$TransasctionDate.'",
            "UserCreate" : "'.$userid.'", 
            "JenisDeliveryOrder" : "'.$JenisDelivery.'",
            "JenisPurchase" : "'.$axPO_JenisPurchase.'",
            "Items":   ' . $list . '
              }
            ';
            //var_dump($postData);exit;
            $urlAddKelompok = "transaction/deliveryorder/addDeliveryOrderDetails/";
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
            // var_dump($addSatuan);exit;
            return $addSatuan['data'];
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function goFinishEditDeliveryOrder($data)
    {
        try {
            //$no_purchaseorder = $createOrderNumber['no_purchaseorder']; 

            $No_Transaksi = $data['No_Transaksi'];
            $Keterangan = $data['Keterangan_PO'];
            $PO_KodeSupplier = $data['PO_KodeSupplier'];
            $No_Request = $data['No_PurchasingOrder'];
            $TransasctionDate = $data['TransasctionDate'];
            
            // $grandtotalqty = $data['grandtotalqty'];
            // $subtotalttlrp = $data['subtotalttlrp'];
            // $taxxRp = $data['taxxRp'];
            // $grandtotalxl = $data['grandtotalxl'];
            // $totalrow = $data['totalrow'];

            $grandtotalqty = str_replace(".", "", $data['grandtotalqty']);
            $subtotalttlrp = str_replace(".", "", $data['subtotalttlrp']);
            $taxxRp = str_replace(".", "", $data['taxxRp']);
            $grandtotalxl = str_replace(".", "", $data['grandtotalxl']);
            $totalrow = str_replace(".", "", $data['totalrow']);

            $grandtotalqty = str_replace(",", ".", $grandtotalqty);
            $subtotalttlrp = str_replace(",", ".", $subtotalttlrp);
            $taxxRp = str_replace(",", ".", $taxxRp);
            $grandtotalxl = str_replace(",", ".", $grandtotalxl);
            $totalrow = str_replace(",", ".", $totalrow);

            $Unit = $data['Unit'];
            
            $JenisDelivery = $data['JenisDelivery'];
            $JenisPembayaran = $data['JenisPembayaran'];
            $DateTempo = $data['DateTempo'];

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
            if ($JenisPembayaran == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Jenis Pembayaran Kosong !',
                );
                return $callback;
                exit;
            }
            if ($JenisPembayaran == "KREDIT" && $DateTempo == '') {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Tgl Jatuh Tempo Kosong !',
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
                "JenisDelivery" : "'.$JenisDelivery.'" ,
                "UnitCode" : "'.$Unit.'",
                "JenisPembayaran" : "'.$JenisPembayaran.'",
                "DateTempo" : "'.$DateTempo.'"
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
            $No_PurchasingOrder = $data['No_PurchasingOrder'];

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
                            "PurchaseCode" : "'.$No_PurchasingOrder.'",
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

    public function voidDeliveryOrderDetailbyItem($data)
    {
        try {

            $No_Transaksi = $data['No_Transaksi'];
            $AlasanBatal = $data['AlasanBatal'];
            $product_code = $data['product_code'];
            $Unit = $data['Unit'];
            $No_PurchasingOrder = $data['No_PurchasingOrder'];

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
                "PurchaseCode" : "'.$No_PurchasingOrder.'" ,
                "ProductCode" : "'.$product_code.'" ,
                "UnitCode" : "'.$Unit.'" ,
                "DateVoid" : "'.$datenowcreate.'",
                "UserVoid" : "'.$userid.'",
                "Void" : "1",
                "ReasonVoid" : "'.$AlasanBatal.'"
            }';
            //"PurchaseCode" : "'.$No_PurchasingOrder.'"
            $urlAddKelompok = "transaction/deliveryorder/voidDeliveryOrderDetailbyItem/";
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

    public function getDeliveryOrderbyPeriode($data)
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
            $urlAddKelompok = "transaction/deliveryorder/getDeliveryOrderbyPeriode/";
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

    public function getCalculateDateTempobyIDSupplier($data)
    {
        try { 
            $IDSupplier = $data['IDSupplier'];
            $TransasctionDate = $data['TransasctionDate'];
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '
            {
                "TransasctionDate" : "'.$TransasctionDate.'" ,
                "IDSupplier" : "'.$IDSupplier.'" 
            }
            ';
            $urlAddKelompok = "transaction/deliveryorder/getCalculateDateTempobyIDSupplier/";
            $addSatuan = $this->curl_request(
                GenerateTokenRS::headers_api_token($token['access_token']),
                $method_getgroup,
                $postData,
                $urlAddKelompok
            );
            //var_dump($addSatuan['status']);exit;
           if ($addSatuan['status'] == 1){
                $callback = [
                    'status' => 'success',
                    'message' => $addSatuan['message'],
                    'data' => $addSatuan['data'],
                ];
           }else{
            $callback = [
                'status' => 'danger',
                'message' => $addSatuan['message'],
            ];
           }
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    

     
}