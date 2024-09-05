<?php

class B_Purchase_Order_Model
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
    public function createHeaderPurchaseOrder($data)
    {
        try {
            //$no_purchaseorder = $createOrderNumber['no_purchaseorder']; 

            $Keterangan = $data['PO_Keterangan'];
            $PO_KodeSupplier = $data['PO_KodeSupplier'];
            $No_Request = $data['No_Request'];
            $TransasctionDate = $data['TransasctionDate'];
            $PO_JenisPurchase = $data['Jenis_Request']; 
            $nulldata = "";
            //$this->db->transaksi();
            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $name = $session->name;
            // // WO_RADIOLOGI
            // $this->db->query("INSERT INTO [Apotik_V1.1SQL].DBO.TB_TRS_PO_HDR 
            //                 (  FS_KD_TRS,FS_TGL_TRS, FS_KD_PETUGAS,FS_KD_SUPPLIER,
            //                     FS_KET,FS_KD_PETUGAS_FIRST,FS_TGL_FIRST, TIPE_PO) 
            //                 VALUES
            //                 ( :no_purchaseorder,:datenowcreate,:userid,:PO_KodeSupplier,
            //                 :nulldata,:userid2,:datenowcreate2,:PO_JenisPurchase )");
            // $this->db->bind('no_purchaseorder', $no_purchaseorder);
            // $this->db->bind('datenowcreate', $datenowcreate);
            // $this->db->bind('datenowcreate2', $datenowcreate);
            // $this->db->bind('userid', $userid); 
            // $this->db->bind('PO_KodeSupplier', $data['PO_KodeSupplier']);
            // $this->db->bind('nulldata', $nulldata);
            // $this->db->bind('userid2', $userid);
            // $this->db->bind('PO_JenisPurchase', $data['PO_JenisPurchase']);
            // //$this->db->bind('Keterangan', $Keterangan); 

            
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

            // if ($Notes == "") {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => 'Note Transaksi Kosong !',
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
            $postData = '{ 
                "PurchaseDate" : "' . $TransasctionDate . '",
                "UserCreate" : "' . $userid . '",
                "SupplierCode" : "' . $PO_KodeSupplier . '",
                "Notes" : "' . $Keterangan . '",
                "PurchaseReqCode" : "' . $No_Request . '",  
                "TipePO" : "' . $PO_JenisPurchase . '" 
            }';
            $urlAddKelompok = "transaction/purchaseorder/addPurchaseOrder/";
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
    public function goaddDetilPurchaseOrder($data)
    {
       
            $nulldata = ""; 
            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $name = $session->name;
            // WO_RADIOLOGI
            $batal = "0";
            $qty = $data['PO_Qty'];
            $harga = $data['PO_Harga'];
            $diskonProsen = $data['PO_DiscProsen'];
            $diskonRp = ($harga*$diskonProsen)/100;  
            $subtotal1 = ($harga-$diskonRp)*$qty;
            $taxprosen = $data['PO_TaxProsen'];
            $taxRp = ($taxprosen* $subtotal1)/100; 
            $total = ($subtotal1+$taxRp);
            $this->db->query("INSERT INTO [Apotik_V1.1SQL].dbo.TB_TRS_PO_DTL
                            (FS_KD_TRS,FS_KD_BARANG,FN_HARGA,FN_DISKON,FN_DISKON_RP,FN_QTY_PO,FN_SISA_PO,FS_KD_SATUAN,
                            FN_SUB_TOTAL,FN_TAX,FN_TAX_RP,FN_TOTAL,FS_PETUGAS_ENTRY,FD_TGL_ENTRY)
                            VALUES
                            (:FS_KD_TRS,:FS_KD_BARANG,:FN_HARGA,:FN_DISKON,:FN_DISKON_RP,:FN_QTY_PO,:FN_SISA_PO,:FS_KD_SATUAN,
                            :FN_SUB_TOTAL,:FN_TAX,:FN_TAX_RP,:FN_TOTAL,:FS_PETUGAS_ENTRY,:FD_TGL_ENTRY)");
            $this->db->bind('FS_KD_TRS', $data['PO_NoTrs']);
            $this->db->bind('FS_KD_BARANG', $data['Po_SrcBarang']);
            $this->db->bind('FN_HARGA', $data['PO_Harga']);
            $this->db->bind('FN_DISKON', $data['PO_DiscProsen']);
            $this->db->bind('FN_DISKON_RP', $diskonRp);
            $this->db->bind('FN_QTY_PO', $data['PO_Qty']);
            $this->db->bind('FN_SISA_PO', $data['PO_Qty']);
            $this->db->bind('FS_KD_SATUAN', $data['PO_Satuan']);
            $this->db->bind('FN_SUB_TOTAL', $subtotal1);
            $this->db->bind('FN_TAX', $data['PO_TaxProsen']);
            $this->db->bind('FN_TAX_RP', $taxRp);
            $this->db->bind('FN_TOTAL', $total);
            $this->db->bind('FS_PETUGAS_ENTRY', $userid);
            $this->db->bind('FD_TGL_ENTRY', $datenowcreate);
            $this->db->execute(); 
            return $this->db->RowCount();
  
    }
    public function sumTotalHeaderPO($data)
    { 
        $session = SessionManager::getCurrentSession();
        $userid = $session->username;
        $name = $session->name;
        $batal = "0";
        // cari total
        $this->db->query("SELECT  SUM(FN_QTY_PO) FN_QTY_PO ,SUM(FN_SUB_TOTAL) FN_SUB_TOTAL, 
                            SUM(FN_TAX_RP) FN_TAX_RP,SUM(FN_TOTAL) FN_TOTAL
                            FROM [Apotik_V1.1SQL].DBO.TB_TRS_PO_DTL
                            WHERE FS_KD_TRS=:FS_KD_TRS and FB_VOID=:batal");
        $this->db->bind('FS_KD_TRS', $data['PO_NoTrs']);
        $this->db->bind('batal', $batal);
        $this->db->execute();
        $dataSUM =  $this->db->single();
        $callback = array(
            'status' => 'success', // Set array status dengan success
            'FN_QTY_PO' => $dataSUM['FN_QTY_PO'], // Set array status dengan success
            'FN_SUB_TOTAL' => $dataSUM['FN_SUB_TOTAL'], // Set array status dengan success
            'FN_TAX_RP' => $dataSUM['FN_TAX_RP'], // Set array status dengan success
            'FN_TOTAL' => $dataSUM['FN_TOTAL'], // Set array status dengan sucess 
        );
        return $callback; 
    }
    public function goUpdateHeaderNilai($data, $dataSUmHeader)
    { 
         try {
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $name = $session->name; 
            $batal = "0"; 
            // cari total

            $FN_QTY_PO = $dataSUmHeader['FN_QTY_PO'];
            $FN_SUB_TOTAL = $dataSUmHeader['FN_SUB_TOTAL'];
            $FN_TAX_RP = $dataSUmHeader['FN_TAX_RP'];
            $FN_TOTAL = $dataSUmHeader['FN_TOTAL']; 
            $this->db->query("UPDATE [Apotik_V1.1SQL].DBO.TB_TRS_PsO_HDR 
                            SET FN_TTL_QTY_PO=:FN_TTL_QTY_PO,FN_SUBTOTAL=:FN_SUBTOTAL,FN_TAX_RP=:FN_TAX_RP,
                            FN_TOTAL=:FN_TOTAL
                            WHERE FS_KD_TRS=:FS_KD_TRS ");
            $this->db->bind('FN_TTL_QTY_PO', $FN_QTY_PO);
            $this->db->bind('FN_SUBTOTAL', $FN_SUB_TOTAL);
            $this->db->bind('FN_TAX_RP', $FN_TAX_RP);
            $this->db->bind('FN_TOTAL', $FN_TOTAL);
            $this->db->bind('FS_KD_TRS', $data['PO_NoTrs']);
            $this->db->execute();
            return $this->db->RowCount();
        } catch (PDOException $e) { 
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function showDetilPurchaseOrder($data)
    {
        try {
            
            $this->db->query("SELECT a.FS_KD_TRS,a.FS_KD_MR,a.fs_tgl_trs,D.COMPANY,
                            a.FS_KET,b.fs_KD_barang, c.[Product Name] AS Namabarang,b.FN_HARGA,b.FN_DISKON,b.FN_DISKON_RP,
                            b.fn_qty_po,b.FN_SISA_PO,b.fn_qty_mr,b.FS_KD_SATUAN,
                            b.FN_SUB_TOTAL,b.fn_tax,b.fn_tax_rp,b.FN_TOTAL
                            from [Apotik_V1.1SQL].dbo.TB_TRS_PO_HDR a 
                            inner join [Apotik_V1.1SQL].dbo.TB_TRS_PO_DTL b on a.fs_KD_trs=b.fs_KD_trs
                            inner join [Apotik_V1.1SQL].dbo.Products c on c.id = b.fs_KD_barang
                            inner join [Apotik_V1.1SQL].dbo.Suppliers d on d.id = a.FS_KD_SUPPLIER
                            where a.FS_KD_PETUGAS_VOID='' and b.FB_VOID='0' AND A.FS_KD_PETUGAS_VOID=''
                            and a.FS_KD_TRS=:PO_NoTrs
                            order by  a.fs_KD_trs asc, b.fs_no_urut asc ");
            $this->db->bind('PO_NoTrs',   $data['PO_NoTrs']); 
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $row) {
                $pasing['No'] = $no;
                $pasing['FS_KD_TRS'] = $row['FS_KD_TRS'];
                $pasing['fs_KD_barang'] = $row['fs_KD_barang'];
                $pasing['Namabarang'] =  $row['Namabarang'];
                $pasing['FN_HARGA'] =  $row['FN_HARGA'];
                $pasing['FN_DISKON'] =  $row['FN_DISKON'];
                $pasing['FN_DISKON_RP'] =  $row['FN_DISKON_RP'];
                $pasing['fn_qty_po'] =  $row['fn_qty_po'];
                $pasing['FN_SISA_PO'] =  $row['FN_SISA_PO'];
                $pasing['FS_KD_SATUAN'] =  $row['FS_KD_SATUAN'];
                $pasing['FN_SUB_TOTAL'] =  $row['FN_SUB_TOTAL'];
                $pasing['fn_tax'] =  $row['fn_tax'];
                $pasing['fn_tax_rp'] =  $row['fn_tax_rp'];
                $pasing['FN_TOTAL'] =  $row['FN_TOTAL']; 
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    function getPurchaseOrderHeader($data)
    {
        try {
            //cek do
            $this->db->query("SELECT * from [Apotik_V1.1SQL].dbo.TB_TRS_DO_HDR where FS_KD_PETUGAS_VOID='' 
				            and FS_KD_PO=:PO_NoTrs");
            $this->db->bind('PO_NoTrs',   $data['PO_NoTrs']);
           // $data =  $this->db->single();
            $datarow = $this->db->rowCount();
            if($datarow){
                $this->db->query("SELECT a.FS_KD_TRS,b.[First Name] AS Namapetugas,replace(CONVERT(VARCHAR(11),a.FS_TGL_TRS, 111), '/','-') FS_TGL_TRS,
                                    a.FS_KD_SUPPLIER,
                                    a.fs_ket,a.FN_TTL_QTY_PO,a.FN_SUBTOTAL,a.FN_TAX_RP,a.FN_TOTAL,c.Company,a.FS_KD_MR,a.FS_KD_PETUGAS_FIRST
                                    ,A.TIPE_PO
                                    from [Apotik_V1.1SQL].dbo.TB_TRS_PO_HDR a 
                                    inner join MasterdataSQL.dbo.Employees b 
                                    on a.FS_KD_PETUGAS collate  Latin1_General_CS_AS = b.NoPIN collate  Latin1_General_CS_AS
                                    inner join [Apotik_V1.1SQL].dbo.Suppliers c on c.ID = a.FS_KD_SUPPLIER
                                    where a.FS_KD_PETUGAS_VOID=''  and a.FS_KD_TRS=:PO_NoTrs");
                $this->db->bind('PO_NoTrs',   $data['PO_NoTrs']);
                $data =  $this->db->single();
                $callback = array(
                    'status' => 'successDo', // Set array status dengan success
                    'FS_KD_TRS' => $data['FS_KD_TRS'], // Set array status dengan success
                    'Namapetugas' => $data['Namapetugas'], // Set array status dengan success
                    'FS_TGL_TRS' => $data['FS_TGL_TRS'], // Set array status dengan success
                    'FS_KD_SUPPLIER' => $data['FS_KD_SUPPLIER'], // Set array status dengan sucess
                    'fs_ket' => $data['fs_ket'], // Set array status dengan sucess
                    'FN_TTL_QTY_PO' => $data['FN_TTL_QTY_PO'], // Set array status dengan sucess
                    'FN_SUBTOTAL' => $data['FN_SUBTOTAL'], // Set array status dengan sucess
                    'FN_TAX_RP' => $data['FN_TAX_RP'], // Set array status dengan sucess
                    'FN_TOTAL' => $data['FN_TOTAL'], // Set array status dengan sucess
                    'Company' => $data['Company'], // Set array status dengan sucess
                    'FS_KD_MR' => $data['FS_KD_MR'], // Set array status dengan sucess
                    'FS_KD_PETUGAS_FIRST' => $data['FS_KD_PETUGAS_FIRST'], // Set array status dengan sucess
                    'TIPE_PO' => $data['TIPE_PO'], // Set array status dengan sucess
                    'Pesan' => 'Sudah ada Transaksi Delivery Order ! ', // Set array status dengan success
                );
                return $callback;
            }else{
                $this->db->query("SELECT a.FS_KD_TRS,b.[First Name] AS Namapetugas,replace(CONVERT(VARCHAR(11),a.FS_TGL_TRS, 111), '/','-') FS_TGL_TRS,
                                    a.FS_KD_SUPPLIER,
                                    a.fs_ket,a.FN_TTL_QTY_PO,a.FN_SUBTOTAL,a.FN_TAX_RP,a.FN_TOTAL,c.Company,a.FS_KD_MR,a.FS_KD_PETUGAS_FIRST
                                    ,A.TIPE_PO
                                    from [Apotik_V1.1SQL].dbo.TB_TRS_PO_HDR a 
                                    inner join MasterdataSQL.dbo.Employees b 
                                    on a.FS_KD_PETUGAS collate  Latin1_General_CS_AS = b.NoPIN collate  Latin1_General_CS_AS
                                    inner join [Apotik_V1.1SQL].dbo.Suppliers c on c.ID = a.FS_KD_SUPPLIER
                                    where a.FS_KD_PETUGAS_VOID=''  and a.FS_KD_TRS=:PO_NoTrs");
                $this->db->bind('PO_NoTrs',   $data['PO_NoTrs']);
                $data =  $this->db->single();
                $callback = array(
                    'status' => 'success', // Set array status dengan success
                    'FS_KD_TRS' => $data['FS_KD_TRS'], // Set array status dengan success
                    'Namapetugas' => $data['Namapetugas'], // Set array status dengan success
                    'FS_TGL_TRS' => $data['FS_TGL_TRS'], // Set array status dengan success
                    'FS_KD_SUPPLIER' => $data['FS_KD_SUPPLIER'], // Set array status dengan sucess
                    'fs_ket' => $data['fs_ket'], // Set array status dengan sucess
                    'FN_TTL_QTY_PO' => $data['FN_TTL_QTY_PO'], // Set array status dengan sucess
                    'FN_SUBTOTAL' => $data['FN_SUBTOTAL'], // Set array status dengan sucess
                    'FN_TAX_RP' => $data['FN_TAX_RP'], // Set array status dengan sucess
                    'FN_TOTAL' => $data['FN_TOTAL'], // Set array status dengan sucess
                    'Company' => $data['Company'], // Set array status dengan sucess
                    'FS_KD_PETUGAS_FIRST' => $data['FS_KD_PETUGAS_FIRST'], // Set array status dengan sucess
                    'FS_KD_MR' => $data['FS_KD_MR'], // Set array status dengan sucess
                    'TIPE_PO' => $data['TIPE_PO'], // Set array status dengan sucess
                );
                return $callback;
            }

                    
           
        } catch (PDOException $e) {


            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
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
    public function goFinishPurchaseOrder($data)
    {
        try {
            // $no_purchaseorder = $data['PO_NoTrs'];
            // $nulldata = "";
            // $this->db->transaksi();
            // $datenowcreate = Utils::seCurrentDateTime();
            // $session = SessionManager::getCurrentSession();
            // $userid = $session->username;
            // $name = $session->name;
            // // WO_RADIOLOGI
            // $this->db->query("INSERT INTO [Apotik_V1.1SQL].DBO.TB_TRS_PO_HDR 
            //                 (  FS_KD_TRS,FS_TGL_TRS, FS_KD_PETUGAS,FS_KD_SUPPLIER,
            //                     FS_KET,FS_KD_PETUGAS_FIRST,FS_TGL_FIRST, TIPE_PO) 
            //                 VALUES
            //                 ( :no_purchaseorder,:datenowcreate,:userid,:PO_KodeSupplier,
            //                 :nulldata,:userid2,:datenowcreate2,:PO_JenisPurchase )");
            // $this->db->bind('no_purchaseorder', $no_purchaseorder);
            // $this->db->bind('datenowcreate', $datenowcreate);
            // $this->db->bind('datenowcreate2', $datenowcreate);
            // $this->db->bind('userid', $userid);
            // $this->db->bind('PO_KodeSupplier', $data['PO_KodeSupplier']);
            // $this->db->bind('nulldata', $nulldata);
            // $this->db->bind('userid2', $userid);
            // $this->db->bind('PO_JenisPurchase', $data['PO_JenisPurchase']);
            // $this->db->execute();
            // $this->db->commit();
            // $this->db->closeCon();
            // $callback = array(
            //     'status' => 'success',
            //     'no_purchaseorder' => $no_purchaseorder,
            //     'no_purchaseorder' => $no_purchaseorder,
            //     'userid' => $userid,
            //     'name' => $name,
            // );
            // return $callback;

            $TransactionCode = $data['No_Transaksi'];
            //$TransactionCode = 'TPO150720220008';
            $No_Request = $data['No_Request'];

            $hidden_kode_barang =$data['hidden_kode_barang'];
            $hidden_nama_barang_ = $data['hidden_nama_barang_'];
            $hidden_satuan_barang_ = $data['hidden_satuan_barang_'];
            $hidden_Satuan_Konversi_ = $data['hidden_Satuan_Konversi_'];
            $hidden_KonversiQty_ = $data['hidden_KonversiQty_'];
            
            $hidden_qty_barang_ = str_replace(".", "", $data['hidden_qty_barang_']);
            $hidden_harga_barang_ = str_replace(".", "", $data['hidden_harga_barang_']);
            $hidden_discpros_barang_ = str_replace(".", "", $data['hidden_discpros_barang_']);
            $hidden_discrp_barang_ = str_replace(".", "", $data['hidden_discrp_barang_']);
            $hidden_subtotal_ = str_replace(".", "", $data['hidden_subtotal_']);
            $hidden_taxprosen_ = str_replace(".", "", $data['hidden_taxprosen_']);
            $hidden_taxrp_ = str_replace(".", "", $data['hidden_taxrp_']);
            $hidden_grandtotal_ = str_replace(".", "", $data['hidden_grandtotal_']);
            $hidden_min_barang_ = str_replace(".", "", $data['hidden_min_barang_']);
            $hidden_discrpttl_barang_ = str_replace(".", "", $data['hidden_discrpttl_barang_']);
            $hidden_taxrp2_ = str_replace(".", "", $data['hidden_taxrp2_']); 

            $hidden_qty_barang_ = str_replace(",", ".", $hidden_qty_barang_);
            $hidden_harga_barang_ = str_replace(",", ".", $hidden_harga_barang_);
            $hidden_discpros_barang_ = str_replace(",", ".", $hidden_discpros_barang_);
            $hidden_discrp_barang_ = str_replace(",", ".", $hidden_discrp_barang_);
            $hidden_subtotal_ = str_replace(",", ".", $hidden_subtotal_);
            $hidden_taxprosen_ = str_replace(",", ".", $hidden_taxprosen_);
            $hidden_taxrp_ = str_replace(",", ".", $hidden_taxrp_);
            $hidden_grandtotal_ = str_replace(",", ".", $hidden_grandtotal_);
            $hidden_min_barang_ = str_replace(",", ".", $hidden_min_barang_);
            $hidden_discrpttl_barang_ = str_replace(",", ".", $hidden_discrpttl_barang_);
            $hidden_taxrp2_ = str_replace(",", ".", $hidden_taxrp2_); 
            

            $jumlah_dipilih = count($hidden_kode_barang);

            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;

            
            

            $nourut=0;
            $rows = array();
            for($x=0;$x<$jumlah_dipilih;$x++){

                $nomor = $x +1 ;
                
                //CEK
                if ($hidden_qty_barang_[$x] == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Kolom Qty PO Nomor '.$nomor.' Kosong !',
                    );
                    return $callback;
                    exit;
                } 

                if ($hidden_harga_barang_[$x] == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Kolom Harga Nomor '.$nomor.' Kosong !',
                    );
                    return $callback;
                    exit;
                } 

                if ($hidden_discpros_barang_[$x] == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Kolom Diskon Prosen Nomor '.$nomor.' Kosong !',
                    );
                    return $callback;
                    exit;
                } 

                if ($hidden_taxprosen_[$x] == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Kolom Tax Prosen Nomor '.$nomor.' Kosong !',
                    );
                    return $callback;
                    exit;
                } 


                $nourut++;

                //GET NAMA PRODUCT
            $this->db->query("  SELECT isnull([Quantity Per Unit],0) as qtystok,isnull([List Price],0) as listprice from [Apotik_V1.1SQL].dbo.Products 
            where ID=:id");
            $this->db->bind('id',   $hidden_kode_barang[$x]); 
            $datax =  $this->db->single();
            $qtystok = $datax['qtystok'];
            if ($qtystok == ''){
                $qtystok = 0;
            }
            $listprice = $datax['listprice'];

              $qyt_remain =   $hidden_qty_barang_[$x] - $hidden_min_barang_[$x];
                                $pasing['ProductCode'] =   $hidden_kode_barang[$x];
                                $pasing['ProductSatuan'] =    $hidden_satuan_barang_[$x];
                                $pasing['ProductName'] =    $hidden_nama_barang_[$x];
                                $pasing['LastPrice'] =   '0';
                                $pasing['Price'] =   $hidden_harga_barang_[$x];
                                $pasing['DiscountProsen'] =    $hidden_discpros_barang_[$x];
                                $pasing['DiscountRp'] =    $hidden_discrp_barang_[$x];
                                $pasing['DiscountRpTTL'] =    $hidden_discrpttl_barang_[$x];//------------
                                $pasing['QtyPurchase'] =    $hidden_qty_barang_[$x];
                                $pasing['QtyPurchaseRemain'] =  $qyt_remain;
                                $pasing['ProductSatuan'] =    $hidden_satuan_barang_[$x];
                                $pasing['SubtotalPurchase'] =    $hidden_subtotal_[$x];
                                $pasing['TaxProsen'] =    $hidden_taxprosen_[$x];
                                $pasing['TaxRp'] =    $hidden_taxrp2_[$x];
                                $pasing['TaxRpTTL'] =    $hidden_taxrp_[$x];//--------------
                                $pasing['TotalPurchase'] =    $hidden_grandtotal_[$x];
                                $pasing['QtyStok'] =  $qtystok  ;
                                $pasing['QtyPR'] =    $hidden_min_barang_[$x];
                                $pasing['KonversiQty'] =    $hidden_KonversiQty_[$x];
                                $pasing['Satuan_Konversi'] =    $hidden_Satuan_Konversi_[$x];
                                $pasing['KonversiQty_Total'] =    $hidden_KonversiQty_[$x]*$hidden_qty_barang_[$x];
                                $pasing['UserEntry'] =    $userid;
                                $pasing['DateEntry'] =    $datenowcreate;
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
            "PurchaseCode" : "'.$TransactionCode.'",
            "PurchaseReqCode" : "'.$No_Request.'",
            "Items":   ' . $list . '
        }
            ';
            //var_dump($postData);
            $urlAddKelompok = "transaction/purchaseorder/addPurchaseOrderDetails/";
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

    public function getPurchaseOrderbyDateUser($data)
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
            $urlAddKelompok = "transaction/purchaseorder/getPurchaseOrderbyDateUser/";
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

    public function getPurchaseOrderbyID($data)
    {
        try {
            $session = SessionManager::getCurrentSession();
            $UserCreate = $session->username;
            $PO_NoTrs = $data['PO_NoTrs'];
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '{ 
                "PurchaseCode" : "' . $PO_NoTrs . '" 
            }';
            $urlAddKelompok = "transaction/purchaseorder/getPurchaseOrderbyID/";
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

    public function getPurchaseOrderDetailbyID($data)
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
                "PurchaseCode" : "' . $TransasctionCode . '" 
            }';
            $urlAddKelompok = "transaction/purchaseorder/getPurchaseOrderDetailbyID/";
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

    public function goFinishEditPurchaseOrder($data)
    {
        try {
            //$no_purchaseorder = $createOrderNumber['no_purchaseorder']; 

            $No_Transaksi = $data['No_Transaksi'];
            $Keterangan = $data['PO_Keterangan'];
            $PO_KodeSupplier = $data['PO_KodeSupplier'];
            $No_Request = $data['No_Request'];  
            $PO_JenisPurchase = $data['Jenis_Request']; 
            $TransasctionDate = $data['TransasctionDate'];
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
            if ($grandtotalxl == "") {
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
                "PurchaseDate" : "'.$TransasctionDate.'",
                "UserCreate" : "'.$userid.'",
                "UserEdit" : "'.$userid.'",
                "PurchaseCode" : "'.$No_Transaksi.'" ,    
                "Notes" : "'.$Keterangan.'",
                "Notes1" : "notes1",
                "Notes2" : "notes2",
                "TotalQtyPurchase" : "'.$grandtotalqty.'",
                "SubtotalPurchase" : "'.$subtotalttlrp.'",
                "TaxPurchase" : "'.$taxxRp.'",
                "GrandtotalPurchase" : "'.$grandtotalxl.'",
                "PurchaseReqCode" : "'.$No_Request.'",
                "Close_PO" : "0",
                "TotalRowPO" : "'.$totalrow.'",
                "TotalQtyPO" : "'.$grandtotalqty.'",
                "TipePO" : "'.$PO_JenisPurchase.'"
            }';
            //var_dump($postData);
            $urlAddKelompok = "transaction/purchaseorder/editPurchaseOrder/";
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

    public function goVoidPurchaseOrder($data)
    {
        try {

            $PurchaseRequisitonCode = $data['PurchaseRequisitonCode'];
            $No_Transaksi = $data['No_Transaksi'];
            $AlasanBatal = $data['AlasanBatal'];

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
                            "DateVoid" : "'.$datenowcreate.'",
                            "UserVoid" : "'.$userid.'",
                            "PurchaseRequisitonCode" :  "'.$PurchaseRequisitonCode.'",
                            "Void" : "1",
                            "ReasonVoid" : "'.$AlasanBatal.'"
                        }';
            $urlAddKelompok = "transaction/purchaseorder/voidPurchaseOrder/";
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
            $PurchaseRequisitonCode = $data['PurchaseRequisitonCode'];
            $QtyPurchase = $data['QtyPurchase'];
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
                "PurchaseRequisitonCode" : "'.$PurchaseRequisitonCode.'",
                "QtyPurchase" : "'.$QtyPurchase.'",
                "UserVoid" : "'.$userid.'",
                "Void" : "1",
                "ReasonVoid" : "'.$AlasanBatal.'"
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

    public function getPurchaseOrderbyPeriode($data)
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
                "StartPeriode" : "'.$tglawal.'" ,
                "EndPeriode" : "'.$tglakhir.'" 
            }
            ';
            $urlAddKelompok = "transaction/purchaseorder/getPurchaseOrderbyPeriode/";
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

    //-----------------
    public function getEmployeeByNoPIN($data)
    {
        try {
            $NoPIN = $data;

            $this->db->query("SELECT username,NoPIN,FileDocument FROM MasterDataSQL.dbo.Employees WHERE NoPIN=:NoPIN");
            $this->db->bind('NoPIN', $NoPIN);
            $data =  $this->db->single(); 
                $callback = array(
                    'status' => 'success', 
                    'NoPIN' => $data['NoPIN'], 
                    'FileDocument' => $data['FileDocument'], 
                    'username' => $data['username'], 
                );
                return $callback;

        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function goClosePurchaseOrder($data)
    {
        try {
            $No_Transaksi = $data['No_Transaksi'];
            $AlasanBatal = $data['AlasanBatal'];

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
                            "DateClose" : "'.$datenowcreate.'",
                            "UserClose" : "'.$userid.'",
                            "Close" : "1",
                            "ReasonClose" : "'.$AlasanBatal.'"
                        }';
            $urlAddKelompok = "transaction/purchaseorder/closePurchaseOrder/";
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
    public function createupdatekonversisatuanPo($data)
    {
        try {

            $Kon_Detailid = $data['Kon_Detailid'];
            $PilihKonversikode = $data['PilihKonversikode'];
            $Kon_DataSatBesar = $data['Kon_DataSatBesar'];
            $Kon_DataSatKecil = $data['Kon_DataSatKecil'];
            $Kon_KonversiDatasatuan = $data['Kon_KonversiDatasatuan'];
            $Kon_EntriQty = $data['Kon_EntriQty'];
            $Kon_EntriQtyTotal = $data['Kon_EntriQtyTotal'];

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
                            "Kon_Detailid" : "'.$Kon_Detailid.'" ,
                            "PilihKonversikode" : "'.$PilihKonversikode.'",
                            "Kon_DataSatBesar" : "'.$Kon_DataSatBesar.'", 
                            "Kon_DataSatKecil" : "'.$Kon_DataSatKecil.'", 
                            "Kon_KonversiDatasatuan" : "'.$Kon_KonversiDatasatuan.'", 
                            "Kon_EntriQty" : "'.$Kon_EntriQty.'", 
                            "Kon_EntriQtyTotal" : "'.$Kon_EntriQtyTotal.'" 
                        }';
            $urlAddKelompok = "transaction/purchaserequisition/updateDetailKonversiPoPR/";
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