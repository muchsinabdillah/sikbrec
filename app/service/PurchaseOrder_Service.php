<?php
class PurchaseOrder_Service
{
    private $B_Purchase_Order_Model;
    private $koneksi;
    public function __construct(
        B_Purchase_Order_Model $B_Purchase_Order_Model
    ) {
        $this->B_Purchase_Order_Model = $B_Purchase_Order_Model;
        $this->koneksi = new Database();
    }
    function createHeaderPurchaseOrder($data)
    {
        try {
            $this->koneksi->transaksi();
            if ($data['PO_KodeSupplier'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Supplier Harus Diisi !',
                );
                echo json_encode($callback);
                exit;
            }
           
            if ($data['PO_JenisPurchase'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Jenis Purchase Harus Diisi !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($data['PO_Keterangan'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'keterangan Harus Diisi !',
                );
                echo json_encode($callback);
                exit;
            }
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $name = $session->name;
            $createOrderNumber = $this->B_Purchase_Order_Model->createNumberPurchaseOrder($data);
            $createPurchaseOrder = $this->B_Purchase_Order_Model->createHeaderPurchaseOrder($data, $createOrderNumber);
            $this->koneksi->commit();
            $this->koneksi->closeCon();
            $callback = array(
                'status' => 'success',
                'no_purchaseorder' => $createOrderNumber['no_purchaseorder'],
                'no_purchaseorder' =>$createOrderNumber['no_purchaseorder'],
                'userid' => $userid,
                'name' => $name,
            );
            return $callback;
            return $createPurchaseOrder;
        } catch (PDOException $e) {
            $this->koneksi->Rollback();
            $this->koneksi->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function addDetilPurchaseOrder($data)
    {
        try {
            $query = null;
            $this->koneksi->transaksi();
            if ($data['Po_SrcBarang'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode Barang Harus Diisi !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($data['PO_Qty'] == "" || $data['PO_Qty'] == "0") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Qty Purchase Harus Diisi !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($data['PO_Harga'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Harga Purchase Harus Diisi !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($data['PO_DiscProsen'] == "" ) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Diskon Purchase Harus Diisi !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($data['PO_TaxProsen'] == "" ) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Tax Purchase Harus Diisi !',
                );
                echo json_encode($callback);
                exit;
            }
            
            if ($data['PO_Qty'] == "" || $data['PO_Qty'] == "0") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Qty Purchase Harus Diisi !',
                );
                echo json_encode($callback);
                exit;
            }
            //$this->B_Purchase_Order_Model->goaddDetilPurchaseOrder($data);
            //$this->B_Purchase_Order_Model->goaddDetilPurchaseOrder($data);
            //$this->B_Purchase_Order_Model->goUpdateHeaderNilai($data, $dataSUmHeader);
            //$this->insertPODetil2($data);
            //$dataSUmHeader = $this->B_Purchase_Order_Model->sumTotalHeaderPO($data);
            //$this->updateRekapHeader($data, $dataSUmHeader);
            //return $query;

            // query bener
            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $batal = "0";
            $qty = $data['PO_Qty'];
            $harga = $data['PO_Harga'];
            $diskonProsen = $data['PO_DiscProsen'];
            $diskonRp = ($harga * $diskonProsen) / 100;
            $subtotal1 = ($harga - $diskonRp) * $qty;
            $taxprosen = $data['PO_TaxProsen'];
            $taxRp = ($taxprosen * $subtotal1) / 100;
            $total = ($subtotal1 + $taxRp);
            $this->koneksi->query("INSERT INTO [Apotik_V1.1SQL].dbo.TB_TRS_PO_DTL
                            (FS_KD_TRS,FS_KD_BARANG,FN_HARGA,FN_DISKON,FN_DISKON_RP,FN_QTY_PO,FN_SISA_PO,FS_KD_SATUAN,
                            FN_SUB_TOTAL,FN_TAX,FN_TAX_RP,FN_TOTAL,FS_PETUGAS_ENTRY,FD_TGL_ENTRY)
                            VALUES
                            (:FS_KD_TRS,:FS_KD_BARANG,:FN_HARGA,:FN_DISKON,:FN_DISKON_RP,:FN_QTY_PO,:FN_SISA_PO,:FS_KD_SATUAN,
                            :FN_SUB_TOTAL,:FN_TAX,:FN_TAX_RP,:FN_TOTAL,:FS_PETUGAS_ENTRY,:FD_TGL_ENTRY)");
            $this->koneksi->bind('FS_KD_TRS', $data['PO_NoTrs']);
            $this->koneksi->bind('FS_KD_BARANG', $data['Po_SrcBarang']);
            $this->koneksi->bind('FN_HARGA', $data['PO_Harga']);
            $this->koneksi->bind('FN_DISKON', $data['PO_DiscProsen']);
            $this->koneksi->bind('FN_DISKON_RP', $diskonRp);
            $this->koneksi->bind('FN_QTY_PO', $data['PO_Qty']);
            $this->koneksi->bind('FN_SISA_PO', $data['PO_Qty']);
            $this->koneksi->bind('FS_KD_SATUAN', $data['PO_Satuan']);
            $this->koneksi->bind('FN_SUB_TOTAL', $subtotal1);
            $this->koneksi->bind('FN_TAX', $data['PO_TaxProsen']);
            $this->koneksi->bind('FN_TAX_RP', $taxRp);
            $this->koneksi->bind('FN_TOTAL', $total);
            $this->koneksi->bind('FS_PETUGAS_ENTRY', $userid);
            $this->koneksi->bind('FD_TGL_ENTRY', $datenowcreate);
            $this->koneksi->execute();

            $this->koneksi->query("SELECT SUM(FN_QTY_PO) FN_QTY_PO ,SUM(FN_SUB_TOTAL) FN_SUB_TOTAL,
                                SUM(FN_TAX_RP) FN_TAX_RP,SUM(FN_TOTAL) FN_TOTAL,count(FS_kd_TRS) AS TOTALROW
                                FROM [Apotik_V1.1SQL].DBO.TB_TRS_PO_DTL
                                WHERE FS_KD_TRS=:FS_KD_TRS and FB_VOID=:batal");
            $this->koneksi->bind('FS_KD_TRS', $data['PO_NoTrs']);
            $this->koneksi->bind('batal', $batal);
            $this->koneksi->execute();
            $dataSUmHeader = $this->koneksi->single();
            $FN_QTY_PO = $dataSUmHeader['FN_QTY_PO'];
            $FN_SUB_TOTAL = $dataSUmHeader['FN_SUB_TOTAL'];
            $FN_TAX_RP = $dataSUmHeader['FN_TAX_RP'];
            $FN_TOTAL = $dataSUmHeader['FN_TOTAL'];
            $TotalRow = $dataSUmHeader['TOTALROW'];

            $this->koneksi->query("UPDATE [Apotik_V1.1SQL].DBO.TB_TRS_PO_HDR
                                SET FN_TTL_QTY_PO=:FN_TTL_QTY_PO,FN_SUBTOTAL=:FN_SUBTOTAL,
                                FN_TAX_RP=:FN_TAX_RP,FN_TOTAL=:FN_TOTAL,Total_row=:TotalRow
                                WHERE FS_KD_TRS=:FS_KD_TRS ");
            $this->koneksi->bind('FN_TTL_QTY_PO', $FN_QTY_PO);
            $this->koneksi->bind('FN_SUBTOTAL', $FN_SUB_TOTAL);
            $this->koneksi->bind('FN_TAX_RP', $FN_TAX_RP);
            $this->koneksi->bind('FN_TOTAL', $FN_TOTAL);
            $this->koneksi->bind('TotalRow', $TotalRow);
            $this->koneksi->bind('FS_KD_TRS', $data['PO_NoTrs']);
            $this->koneksi->execute();

            $this->koneksi->commit();
            $this->koneksi->closeCon();
            $callback = array(
                'status' => 'success',
            );
            return $callback;
            
        } catch (PDOException $e) {
            $this->koneksi->Rollback();
            $this->koneksi->closeCon();
         
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function updateRekapHeader($data, $dataSUmHeader){
        return $this->B_Purchase_Order_Model->goUpdateHeaderNilai($data, $dataSUmHeader);
    }
    public function insertPODetil2($data){
        return $this->B_Purchase_Order_Model->goaddDetilPurchaseOrder($data);
    }
    function goFinishPurchaseOrder($data)
    {
        try {
            $this->koneksi->transaksi();
            if ($data['PO_NoTrs'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. Transaksi Harus Diisi !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($data['PO_Keterangan'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Keterangan Harus Diisi !',
                );
                echo json_encode($callback);
                exit;
            }
            $asdasd= $data['PO_Keterangan'];
            // VALIDASI SUDAH DI RECEIVE
            $this->koneksi->query("  SELECT * from [Apotik_V1.1SQL].dbo.TB_TRS_DO_HDR 
                                where FS_KD_PETUGAS_VOID='' 
				                and FS_KD_PO=:PO_NoTrs");
            $this->koneksi->bind('PO_NoTrs',   $data['PO_NoTrs']);
            $this->koneksi->execute();
            $dataValidate =  $this->koneksi->single();
            $kodepos = $dataValidate['FS_KD_PO'];
            $rowsdata = $this->koneksi->rowCount();
            if ($rowsdata > 1) {
                $callback = array(
                    'status' => 'warningreceive',
                    'errorname' => 'Sudah ada DO, buat Trs Baru untuk entri Pemeriksaan Lainnya !',
                    'FS_KD_PO' => $kodepos
                );
                return $callback;
                exit;
            } 
            $batal="0";
            $this->koneksi->query("SELECT SUM(FN_QTY_PO) FN_QTY_PO ,SUM(FN_SUB_TOTAL) FN_SUB_TOTAL,
                                SUM(FN_TAX_RP) FN_TAX_RP,SUM(FN_TOTAL) FN_TOTAL,count(FS_kd_TRS) AS TOTALROW
                                FROM [Apotik_V1.1SQL].DBO.TB_TRS_PO_DTL
                                WHERE FS_KD_TRS=:FS_KD_TRS and FB_VOID=:batal");
            $this->koneksi->bind('FS_KD_TRS', $data['PO_NoTrs']);
            $this->koneksi->bind('batal', $batal);
            $this->koneksi->execute();
            $dataSUmHeader = $this->koneksi->single();
            $FN_QTY_PO = $dataSUmHeader['FN_QTY_PO'];
            $FN_SUB_TOTAL = $dataSUmHeader['FN_SUB_TOTAL'];
            $FN_TAX_RP = $dataSUmHeader['FN_TAX_RP'];
            $FN_TOTAL = $dataSUmHeader['FN_TOTAL'];
            $TotalRow = $dataSUmHeader['TOTALROW'];

            $this->koneksi->query("UPDATE [Apotik_V1.1SQL].DBO.TB_TRS_PO_HDR
                                SET FN_TTL_QTY_PO=:FN_TTL_QTY_PO,FN_SUBTOTAL=:FN_SUBTOTAL,
                                FN_TAX_RP=:FN_TAX_RP,FN_TOTAL=:FN_TOTAL,Total_row=:TotalRow,FS_KET=:asdasd
                                WHERE FS_KD_TRS=:FS_KD_TRS ");
            $this->koneksi->bind('FN_TTL_QTY_PO', $FN_QTY_PO);
            $this->koneksi->bind('FN_SUBTOTAL', $FN_SUB_TOTAL);
            $this->koneksi->bind('FN_TAX_RP', $FN_TAX_RP);
            $this->koneksi->bind('FN_TOTAL', $FN_TOTAL);
            $this->koneksi->bind('TotalRow', $TotalRow);
            $this->koneksi->bind('FS_KD_TRS', $data['PO_NoTrs']);
            $this->koneksi->bind('asdasd', $asdasd);
            $this->koneksi->execute();
            $this->koneksi->commit();
            $this->koneksi->closeCon();
            $callback = array(
                'status' => 'success',
                'a' => $asdasd,

            );
            return $callback;
            
           // $createOrderNumber = $this->B_Purchase_Order_Model->createNumberPurchaseOrder($data);
           // $createPurchaseOrder = $this->B_Purchase_Order_Model->goFinishPurchaseOrder($data, $createOrderNumber);

//            return $createPurchaseOrder;
        } catch (PDOException $e) {
            $this->koneksi->Rollback();
            $this->koneksi->closeCon();

            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    function goBatalPOHeader($data)
    {
        try {
            $this->koneksi->transaksi();
            $no_purchaseorder = $data['noPoBatalHdr'];
            $AlasanBtlPoHdr = $data['AlasanBtlPoHdr'];
            if ($data['noPoBatalHdr'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. Transaksi Harus Diisi !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($data['AlasanBtlPoHdr'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Keterangan Batal Harus Diisi !',
                );
                echo json_encode($callback);
                exit;
            }
            // VALIDASI SUDAH DI RECEIVE
            $this->koneksi->query("  SELECT * from [Apotik_V1.1SQL].dbo.TB_TRS_DO_HDR 
                                where FS_KD_PETUGAS_VOID='' 
				                and FS_KD_PO=:PO_NoTrs");
            $this->koneksi->bind('PO_NoTrs',   $data['noPoBatalHdr']);
            $this->koneksi->execute();
            $dataValidate =  $this->koneksi->single();
            $kodepos = $dataValidate['FS_KD_PO'];
            $rowsdata = $this->koneksi->rowCount();
            if ($rowsdata > 1) {
                $callback = array(
                    'status' => 'warningreceive',
                    'errorname' => 'Sudah ada DO, buat Trs Baru untuk entri Pemeriksaan Lainnya !',
                    'FS_KD_PO' => $kodepos
                );
                return $callback;
                exit;
            }
            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $this->koneksi->query("UPDATE [Apotik_V1.1SQL].DBO.TB_TRS_PO_HDR
                                SET FS_KD_PETUGAS_VOID=:userid,FD_TGL_VOID=:datenowcreate,FS_ALASAN_BATAL=:FS_ALASAN_BATAL
                                WHERE FS_KD_TRS=:no_purchaseorder ");
            $this->koneksi->bind('userid', $userid);
            $this->koneksi->bind('datenowcreate', $datenowcreate);
            $this->koneksi->bind('FS_ALASAN_BATAL', $AlasanBtlPoHdr); 
            $this->koneksi->bind('no_purchaseorder', $no_purchaseorder); 
            $this->koneksi->execute();
            $this->koneksi->commit();
            $this->koneksi->closeCon();
            $callback = array(
                'status' => 'success',
                'pesan' => 'Transaksi Berhasil Dibatalkan !',

            );
            return $callback;

            // $createOrderNumber = $this->B_Purchase_Order_Model->createNumberPurchaseOrder($data);
            // $createPurchaseOrder = $this->B_Purchase_Order_Model->goFinishPurchaseOrder($data, $createOrderNumber);

            //            return $createPurchaseOrder;
        } catch (PDOException $e) {
            $this->koneksi->Rollback();
            $this->koneksi->closeCon();

            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
}