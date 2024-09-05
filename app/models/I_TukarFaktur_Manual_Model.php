<?php

class I_TukarFaktur_Manual_Model
{
    private $db;
    use ApiRsyarsi;


    public function __construct()
    {
        $this->db = new Database;
    }

    public function getFakturManualbyDateUser()
    {
        try { 
            $session = SessionManager::getCurrentSession();
            $UserCreate = $session->username;
            
            $this->db->query("SELECT A.TransactionCode, A.TransactionDate, A.UserCreate, 
                            A.SupplierCode, B.Company as NamaSupplier, A.Keterangan, 
                            A.NoFakturPBF, A.DateFakturPBF, A.NoFakturPajak, A.TotalRow, 
                            A.TotalNilaiFaktur, 
                            REPLACE(CONVERT(VARCHAR(11), A.TglJatuhTempo, 111), '/', '-') AS TglJatuhTempo, 
                            A.TipeHutang, A.TotalDiskon, A.TotalTax, A.Subtotal, A.DiskonLain, A.BiayaLain, 
                            A.Grandtotal, D.[First Name] AS NamaUser, 
                            REPLACE(CONVERT(VARCHAR(11), A.TransactionDate, 111), '/', '-') AS TglPeriode, 
                            A.UnitPembelian, G.NamaUnit, A.DeliveryCode
            FROM            [Apotik_V1.1SQL].dbo.FakturManuals a
            INNER JOIN [Apotik_V1.1SQL].dbo.Suppliers   B ON A.SupplierCode = B.ID 
            INNER JOIN MasterdataSQL.dbo.Employees   D ON D.NoPIN COLLATE SQL_Latin1_General_CP1_CI_AS = A.UserCreate 
            INNER JOIN MasterdataSQL.dbo.MstrUnitPerwatan   G ON G.ID = A.UnitPembelian
            WHERE A.Void = '0' and a.UserCreate=:UserCreate ");
            $this->db->bind('UserCreate', $UserCreate); 
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['NamaSupplier'] = $key['NamaSupplier'];
                $pasing['TransactionCode'] = $key['TransactionCode']; 
                $pasing['TransactionDate'] = $key['TransactionDate'];
                $pasing['NamaUser'] = $key['NamaUser'];
                $pasing['Keterangan'] = $key['Keterangan']; 
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function createFakturManual($data)
    {
        try {
            $this->db->transaksi();

            $TransactionCode = $data['No_Transaksi'];
            $PO_KodeSupplier = $data['PO_KodeSupplier'];
            $No_Purchase_Order = $data['No_Purchase_Order'];
            $No_Delivery_Order = $data['No_Delivery_Order'];
            $PO_KodeSupplierx = $data['PO_KodeSupplierx'];
            $TransasctionDate = $data['TransasctionDate'];
            $Unit = $data['Unit'];
            $TglJatuhTempo = $data['TglJatuhTempo'];
            
            $NoFakturPBF = $data['NoFakturPBF'];
            $TglFakturPBF = $data['TglFakturPBF'];
            $TipeHutang = $data['TipeHutang'];
            $NoFakturPajak = $data['NoFakturPajak'];
            $IncludePPN = $data['IncludePPN'];
            $Keterangan = $data['Keterangan'];
            $RekeningSupplier = $data['RekeningSupplier'];
            $RekeningBank = $data['RekeningBank'];
  

            $NilaiFakturReal = $data['NilaiFakturReal'];
            $NilaiDiskonReal = $data['NilaiDiskonReal'];
            $NilaiPPNReal = $data['NilaiPPNReal'];
            $NilaiBiayaLainReal = $data['NilaiBiayaLainReal'];
            $NilaiGrandTotalReal = $data['NilaiGrandTotalReal'];
            $NilaiPph23 = $data['NilaiPph23'];
            $NilaiSubtotalReal = 0;

            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;

            if ($TransasctionDate == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Tanggal Transaksi Kosong !',
                );
                return $callback;
                exit;
            } 
            if ($No_Purchase_Order == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. Purchase Order Rumah Sakit Kosong !',
                );
                return $callback;
                exit;
            } 
            if ($No_Delivery_Order == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. Delivery Order Rumah Sakit Kosong !',
                );
                return $callback;
                exit;
            } 
            if ($PO_KodeSupplierx == "") {
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
                    'errorname' => 'Unit Pembelian Kosong !',
                );
                return $callback;
                exit;
            } 
            if ($NoFakturPBF == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. Faktur PBF Kosong !',
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
            if ($NoFakturPajak == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. Faktur Pajak Kosong !',
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
            if ($Keterangan == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Keterangan Kosong !',
                );
                return $callback;
                exit;
            } 
            if ($RekeningBank == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. Rekening Bank Kosong !',
                );
                return $callback;
                exit;
            } 
            if ($RekeningSupplier == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. Rekening Supplier Kosong !',
                );
                return $callback;
                exit;
            } 
            if ($NilaiFakturReal == "0") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Nilai Faktur Kosong !',
                );
                return $callback;
                exit;
            } 
            // if ($NilaiPph23 == "0") {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => 'Nilai Pph 23 Kosong !',
            //     );
            //     return $callback;
            //     exit;
            // } 
            if ($NilaiGrandTotalReal == "0") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Nilai Grandtotal Faktur Kosong !',
                );
                return $callback;
                exit;
            } 
           
            if ($TipeHutang == "1") {  
                $this->db->query("SELECT rekening
                FROM Keuangan.DBO.TZ_Parameter_Keu WHERE parameter=:rek_fk_hutang_medis");
                $this->db->bind('rek_fk_hutang_medis', 'rek_fk_hutang_medis'); 
                $this->db->execute();
                $data =  $this->db->single();
                $rekeningHutang = $data['rekening'];
                if ($rekeningHutang == null) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Rekening Hutang Medis Kosong !',
                    );
                    return $callback;
                    exit;
                } 
            } else { 
                $this->db->query("SELECT rekening
                FROM Keuangan.DBO.TZ_Parameter_Keu WHERE parameter=:rek_fk_hutang_non_medis");
                $this->db->bind('rek_fk_hutang_non_medis', 'rek_fk_hutang_non_medis'); 
                $this->db->execute();
                $data =  $this->db->single();
                $rekeningHutang = $data['rekening'];
                if ($rekeningHutang == null) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Rekening Hutang Non Medis Kosong !',
                    );
                    return $callback;
                    exit;
                } 
            }


                $this->db->query("SELECT rekening
                FROM Keuangan.DBO.TZ_Parameter_Keu WHERE parameter=:rek_fk_hutang_barang");
                $this->db->bind('rek_fk_hutang_barang', 'rek_hutang_barang'); 
                $this->db->execute();
                $data =  $this->db->single();
                $rekhutangbarang = $data['rekening'];
                if ($rekhutangbarang == null) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Rekening Hutang Barang Kosong !',
                    );
                    return $callback;
                    exit;
                }  

                $this->db->query("SELECT rekening
                FROM Keuangan.DBO.TZ_Parameter_Keu WHERE parameter=:rek_fk_ppn_masukan");
                $this->db->bind('rek_fk_ppn_masukan', 'rek_ppn_masukan'); 
                $this->db->execute();
                $data =  $this->db->single();
                $rekppn = $data['rekening'];
                if ($rekppn == null) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Rekening PPN Kosong !',
                    );
                    return $callback;
                    exit;
                }

                $this->db->query("SELECT rekening
                FROM Keuangan.DBO.TZ_Parameter_Keu WHERE parameter=:rek_fk_diskon");
                $this->db->bind('rek_fk_diskon', 'rek_diskon_pembelian_detil'); 
                $this->db->execute();
                $data =  $this->db->single();
                $rekdiskon = $data['rekening'];
                if ($rekdiskon == null) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Rekening Diskon Kosong !',
                    );
                    return $callback;
                    exit;
                } 

                $this->db->query("SELECT rekening
                FROM Keuangan.DBO.TZ_Parameter_Keu WHERE parameter=:rek_fk_biayalain");
                $this->db->bind('rek_fk_biayalain', 'rek_biaya_pembelian_lain'); 
                $this->db->execute();
                $data =  $this->db->single();
                $rekbiayalain = $data['rekening'];
                if ($rekbiayalain == null) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Rekening Biaya Lain Kosong !',
                    );
                    return $callback;
                    exit;
                } 

            if($TransactionCode == ""){
                // generate auto number
                $AWAL = 'TFM';
                $ddatedmy = date("dmY", strtotime($TransasctionDate));
                $this->db->query("SELECT SUBSTRING(TransactionCode,12,4) as urut 
                 from [Apotik_V1.1SQL].dbo.FakturManuals
                where  ReffDateTrs = :ReffDateTrs order by 1 desc");
                $this->db->bind('ReffDateTrs', $ddatedmy);
                $data =  $this->db->single();
                $no_pass = $data['urut']; 
                $id = $no_pass;
                $id++;
                $nourutfixReg = Utils::generateAutoNumberFourDigit($id);
                $nofakturTrs=$AWAL.$ddatedmy.$nourutfixReg;

                // INSERT FAKTUR
                $this->db->query("INSERT INTO [Apotik_V1.1SQL].dbo.FakturManuals 
                                ( TransactionCode,DeliveryCode,PurchaseOrderCode,
                                TransactionDate, UserCreate, UnitPembelian, SupplierCode, 
                                NoFakturPBF, DateFakturPBF, NoFakturPajak, Keterangan, 
                                TotalNilaiFaktur,TglJatuhTempo,TipeHutang,TotalDiskon,
                                TotalTax, Subtotal, DiskonLain, BiayaLain, Grandtotal, 
                                UseCreateReal, DateCreateReal, ReffDateTrs, IncludePPN,TotalRow,TotalQty,Void,UserVoid 
                                ,UserCreateLast,TransactionDateLast
                                ,Pph23,NoRekeningSupplier,NamaNBank
                                ) VALUES (:TransactionCode,:DeliveryCode,:PurchaseOrderCode,
                                :TransactionDate,:UserCreate,:UnitPembelian,:SupplierCode,
                                :NoFakturPBF,:DateFakturPBF,:NoFakturPajak,:Keterangan,
                                :TotalNilaiFaktur,:TglJatuhTempo,:TipeHutang,:TotalDiskon,
                                :TotalTax,:Subtotal,:DiskonLain,:BiayaLain,:Grandtotal,
                                :UseCreateReal,:DateCreateReal,:ReffDateTrs,:IncludePPN,:TotalRow,:TotalQty
                                ,:Void,:UserVoid,:UserCreateLast,:TransactionDateLast
                                ,:Pph23,:NoRekeningSupplier,:NamaNBank)");
                                $this->db->bind('Pph23', $NilaiPph23); 
                                $this->db->bind('NoRekeningSupplier', $RekeningSupplier);
                                $this->db->bind('NamaNBank', $RekeningBank);
                                $this->db->bind('UserVoid', '');
                                $this->db->bind('Void', '0');
                                $this->db->bind('TotalRow', '0');
                                $this->db->bind('TotalQty', '0');
                                $this->db->bind('TransactionCode', $nofakturTrs);
                                $this->db->bind('DeliveryCode', $No_Delivery_Order);
                                $this->db->bind('PurchaseOrderCode', $No_Purchase_Order);
                                $this->db->bind('TransactionDate', $TransasctionDate);
                                $this->db->bind('UserCreate', $userid);
                                $this->db->bind('UnitPembelian', $Unit); 
                                $this->db->bind('SupplierCode', $PO_KodeSupplierx); 
                                $this->db->bind('NoFakturPBF', $NoFakturPBF); 
                                $this->db->bind('DateFakturPBF', $TglFakturPBF); 
                                $this->db->bind('NoFakturPajak', $NoFakturPBF); 
                                $this->db->bind('Keterangan', $Keterangan); 
                                $this->db->bind('TotalNilaiFaktur', $NilaiFakturReal); 
                                $this->db->bind('TglJatuhTempo', $TglJatuhTempo); 
                                $this->db->bind('TipeHutang', $TipeHutang); 
                                $this->db->bind('TotalDiskon', $NilaiDiskonReal); 
                                $this->db->bind('TotalTax', $NilaiPPNReal); 
                                $this->db->bind('Subtotal', $NilaiSubtotalReal); 
                                $this->db->bind('DiskonLain', $NilaiDiskonReal); 
                                $this->db->bind('BiayaLain', $NilaiBiayaLainReal); 
                                $this->db->bind('Grandtotal', $NilaiGrandTotalReal); 
                                $this->db->bind('UseCreateReal', $userid); 
                                $this->db->bind('UserCreateLast', $userid);  
                                $this->db->bind('DateCreateReal', $datenowcreate); 
                                $this->db->bind('TransactionDateLast', $datenowcreate);  
                                $this->db->bind('ReffDateTrs', $ddatedmy); 
                                $this->db->bind('IncludePPN', $IncludePPN);  
                                $this->db->execute();

                // tabel hutang
                // generate auto number
                $AWAL = 'HT';
                $ddatedmy = date("dmy", strtotime($TransasctionDate));
                $this->db->query("SELECT SUBSTRING(KD_HUTANG,10,3) as urut 
                 from Keuangan.DBO.HUTANG_REKANAN
                where  SUBSTRING(KD_HUTANG,3,6) = :ReffDateTrs order by 1 desc");
                $this->db->bind('ReffDateTrs', $ddatedmy);
                $data =  $this->db->single();
                $no_pass = $data['urut']; 
                $id = $no_pass;
                $id++;
                if (strlen($id) == 1) {
                    $noUrutJurnal = "00" . $id;
                } else if (strlen($id) == 2) {
                    $noUrutJurnal = "0" . $id;
                } else {
                    $noUrutJurnal = $id;
                }
                $numberHutang =   $AWAL  . $ddatedmy .'-'.$noUrutJurnal;
                $notehtg = 'Faktur Pembelian No. : ' . $nofakturTrs . ' , No Purchase Order Barang : ' . $No_Purchase_Order.' , No Penerimaan Barang : ' . $No_Delivery_Order;
                
                // insert hutang header
                $this->db->query("INSERT INTO Keuangan.DBO.HUTANG_REKANAN
                ( 
                        KD_HUTANG,KD_REKANAN,TGL_HUTANG,PETUGAS,
                        NILAI_HUTANG,SISA_HUTANG,KET,KET2,KET3,TGL_TEMPO,TGL_FAKTUR
                        ,NO_FAKTUR,NO_PO,FS_TGL_VOID,FS_KD_PETUGAS_VOID,KD_ORDER
                        ,NO_REKENING_SUPPLIER,NAMA_BANK_SUPPLIER,PPN_23
                ) VALUES (:KD_HUTANG,:KD_REKANAN,:TGL_HUTANG,:PETUGAS,
                        :NILAI_HUTANG,:SISA_HUTANG,:KET,
                        :KET2,:KET3,:TGL_TEMPO,:TGL_FAKTUR,:NO_FAKTUR,:NO_PO,:FS_TGL_VOID,:FS_KD_PETUGAS_VOID,:KD_ORDER
                        ,:NO_REKENING_SUPPLIER,:NAMA_BANK_SUPPLIER,:PPN_23)"); 
                $this->db->bind('PPN_23', $NilaiPph23); 
                $this->db->bind('NO_REKENING_SUPPLIER', $RekeningSupplier);
                $this->db->bind('NAMA_BANK_SUPPLIER', $RekeningBank);
                $this->db->bind('NO_PO', $No_Purchase_Order); 
                $this->db->bind('KD_HUTANG', $numberHutang); 
                $this->db->bind('KD_REKANAN', $PO_KodeSupplierx); 
                $this->db->bind('TGL_HUTANG', $TransasctionDate); 
                $this->db->bind('PETUGAS', $userid); 
                $this->db->bind('NILAI_HUTANG', $NilaiGrandTotalReal); 
                $this->db->bind('SISA_HUTANG', $NilaiGrandTotalReal); 
                $this->db->bind('KET', $notehtg); 
                $this->db->bind('KET2', $nofakturTrs); 
                $this->db->bind('KET3', $rekeningHutang); 
                $this->db->bind('TGL_TEMPO', $TglJatuhTempo); 
                $this->db->bind('TGL_FAKTUR', $TglFakturPBF); 
                $this->db->bind('NO_FAKTUR', $NoFakturPBF); 
                $this->db->bind('FS_TGL_VOID', '1900-01-01 00:00:00.000'); 
                $this->db->bind('FS_KD_PETUGAS_VOID', ''); 
                $this->db->bind('KD_ORDER', ''); 
                $this->db->execute();


                // insert hutang detil
                $this->db->query("  INSERT INTO Keuangan.DBO.HUTANG_REKANAN_2
                                    ( KD_HUTANG,KD_JURNAL ) 
                                    VALUES (:KD_HUTANG,:KD_JURNAL)"); 
                $this->db->bind('KD_HUTANG', $numberHutang); 
                $this->db->bind('KD_JURNAL', $nofakturTrs);  
                $this->db->execute(); 
                 
                // INSEERT JURNAL HDR
                $this->db->query("  INSERT INTO Keuangan.DBO.TA_JURNAL_HDR
                ( FS_KD_JURNAL,FD_TGL_JURNAL,FN_DEBET,FN_KREDIT,
                FN_JURNAL,FS_KD_PETUGAS,FS_KET_REFF,FS_KET,FS_KET2,FS_KET3,FB_SELESAI ) 
                VALUES (:FS_KD_JURNAL,:FD_TGL_JURNAL,:FN_DEBET,:FN_KREDIT,
                :FN_JURNAL,:FS_KD_PETUGAS,:FS_KET_REFF,:FS_KET,:FS_KET2,:FS_KET3,:FB_SELESAI)"); 
                $this->db->bind('FS_KD_JURNAL', $numberHutang); 
                $this->db->bind('FD_TGL_JURNAL', $TransasctionDate);  
                $this->db->bind('FN_DEBET', $NilaiGrandTotalReal);  
                $this->db->bind('FN_KREDIT', $NilaiGrandTotalReal);  
                $this->db->bind('FN_JURNAL', $NilaiGrandTotalReal);  
                $this->db->bind('FS_KD_PETUGAS', $userid);  
                $this->db->bind('FS_KET_REFF', $No_Delivery_Order);  
                $this->db->bind('FS_KET', $notehtg);  
                $this->db->bind('FS_KET2', '');  
                $this->db->bind('FS_KET3', '');  
                $this->db->bind('FB_SELESAI','1');  
                $this->db->execute(); 

                    
               

                //addJurnalDetailKreditHutangFaktur
                $this->db->query("  INSERT INTO Keuangan.DBO.TA_JURNAL_DTL
                ( FS_KD_JURNAL,FS_KET_REFF,FN_DEBET,FN_KREDIT,
                FB_VOID,FS_REK,FS_KD_REFF,FS_KD_REG,FS_KD_UNIT,FB_UNIT_USAHA,FB_LEDGER,
                BP_TIPE,BP_SOURCE_TRS,FS_KD_REF_OUT ) 
                VALUES (:FS_KD_JURNAL,:FS_KET_REFF,:FN_DEBET,:FN_KREDIT,
                :FB_VOID,:FS_REK,:FS_KD_REFF,:FS_KD_REG,:FS_KD_UNIT,:FB_UNIT_USAHA,:FB_LEDGER,
                :BP_TIPE,:BP_SOURCE_TRS,:FS_KD_REF_OUT)"); 
                $this->db->bind('FS_KD_JURNAL', $numberHutang); 
                $this->db->bind('FS_KET_REFF','Hutang Faktur Pembelian, No. Faktur : ' . $nofakturTrs . " No. Delivery Order : " . $No_Delivery_Order);
                $this->db->bind('FN_DEBET', '0');    
                $this->db->bind('FN_KREDIT', $NilaiGrandTotalReal);    
                $this->db->bind('FB_VOID', '0');  
                $this->db->bind('FS_REK', $rekeningHutang);   
                $this->db->bind('FS_KD_REFF', $No_Delivery_Order);  
                $this->db->bind('FS_KD_REG', $No_Delivery_Order);    
                $this->db->bind('FS_KD_UNIT', '');  
                $this->db->bind('FB_UNIT_USAHA', '0');   
                $this->db->bind('FB_LEDGER', '1');   
                $this->db->bind('BP_TIPE', $TipeHutang);   
                $this->db->bind('BP_SOURCE_TRS', $numberHutang);   
                $this->db->bind('FS_KD_REF_OUT', '');   
                $this->db->execute(); 

                //addJurnalDetailDebetHutangBarang
                $this->db->query("  INSERT INTO Keuangan.DBO.TA_JURNAL_DTL
                ( FS_KD_JURNAL,FS_KET_REFF,FN_DEBET,FN_KREDIT,
                FB_VOID,FS_REK,FS_KD_REFF,FS_KD_REG,FS_KD_UNIT,FB_UNIT_USAHA,FB_LEDGER,
                BP_TIPE,BP_SOURCE_TRS,FS_KD_REF_OUT ) 
                VALUES (:FS_KD_JURNAL,:FS_KET_REFF,:FN_DEBET,:FN_KREDIT,
                :FB_VOID,:FS_REK,:FS_KD_REFF,:FS_KD_REG,:FS_KD_UNIT,:FB_UNIT_USAHA,:FB_LEDGER,
                :BP_TIPE,:BP_SOURCE_TRS,:FS_KD_REF_OUT)"); 
                $this->db->bind('FS_KD_JURNAL', $numberHutang); 
                $this->db->bind('FS_KET_REFF','Hutang Barang Faktur Pembelian, No. Faktur : ' . $nofakturTrs . " No. Delivery Order : " . $No_Delivery_Order);
                $this->db->bind('FN_KREDIT', '0');    
                $this->db->bind('FN_DEBET', $NilaiGrandTotalReal);    
                $this->db->bind('FB_VOID', '0');  
                $this->db->bind('FS_REK', $rekhutangbarang);   
                $this->db->bind('FS_KD_REFF', $No_Delivery_Order);  
                $this->db->bind('FS_KD_REG', $No_Delivery_Order);    
                $this->db->bind('FS_KD_UNIT', '');  
                $this->db->bind('FB_UNIT_USAHA', '0');   
                $this->db->bind('FB_LEDGER', '1');   
                $this->db->bind('BP_TIPE', '');   
                $this->db->bind('BP_SOURCE_TRS', $numberHutang);   
                $this->db->bind('FS_KD_REF_OUT', '');   
                $this->db->execute(); 

                //addJurnalDetailDebetPPNMasukan
                $this->db->query("  INSERT INTO Keuangan.DBO.TA_JURNAL_DTL
                ( FS_KD_JURNAL,FS_KET_REFF,FN_DEBET,FN_KREDIT,
                FB_VOID,FS_REK,FS_KD_REFF,FS_KD_REG,FS_KD_UNIT,FB_UNIT_USAHA,FB_LEDGER,
                BP_TIPE,BP_SOURCE_TRS,FS_KD_REF_OUT ) 
                VALUES (:FS_KD_JURNAL,:FS_KET_REFF,:FN_DEBET,:FN_KREDIT,
                :FB_VOID,:FS_REK,:FS_KD_REFF,:FS_KD_REG,:FS_KD_UNIT,:FB_UNIT_USAHA,:FB_LEDGER,
                :BP_TIPE,:BP_SOURCE_TRS,:FS_KD_REF_OUT)"); 
                $this->db->bind('FS_KD_JURNAL', $numberHutang); 
                $this->db->bind('FS_KET_REFF','PPN Masukan Pembelian, No. Faktur : ' . $nofakturTrs . " No. Delivery Order : " . $No_Delivery_Order);
                $this->db->bind('FN_KREDIT', '0');    
                $this->db->bind('FN_DEBET', $NilaiPPNReal);    
                $this->db->bind('FB_VOID', '0');  
                $this->db->bind('FS_REK', $rekppn);   
                $this->db->bind('FS_KD_REFF', $No_Delivery_Order);  
                $this->db->bind('FS_KD_REG', $No_Delivery_Order);    
                $this->db->bind('FS_KD_UNIT', '');  
                $this->db->bind('FB_UNIT_USAHA', '0');   
                $this->db->bind('FB_LEDGER', '1');   
                $this->db->bind('BP_TIPE', '');   
                $this->db->bind('BP_SOURCE_TRS', $numberHutang);   
                $this->db->bind('FS_KD_REF_OUT', '');   
                $this->db->execute(); 

                //addJurnalDetailDebetDiskonDetil
                $this->db->query("  INSERT INTO Keuangan.DBO.TA_JURNAL_DTL
                ( FS_KD_JURNAL,FS_KET_REFF,FN_DEBET,FN_KREDIT,
                FB_VOID,FS_REK,FS_KD_REFF,FS_KD_REG,FS_KD_UNIT,FB_UNIT_USAHA,FB_LEDGER,
                BP_TIPE,BP_SOURCE_TRS,FS_KD_REF_OUT ) 
                VALUES (:FS_KD_JURNAL,:FS_KET_REFF,:FN_DEBET,:FN_KREDIT,
                :FB_VOID,:FS_REK,:FS_KD_REFF,:FS_KD_REG,:FS_KD_UNIT,:FB_UNIT_USAHA,:FB_LEDGER,
                :BP_TIPE,:BP_SOURCE_TRS,:FS_KD_REF_OUT)"); 
                $this->db->bind('FS_KD_JURNAL', $numberHutang); 
                $this->db->bind('FS_KET_REFF','Diskon Barang Pembelian, No. Faktur : ' . $nofakturTrs . " No. Delivery Order : " . $No_Delivery_Order);
                $this->db->bind('FN_KREDIT', '0');    
                $this->db->bind('FN_DEBET', $NilaiDiskonReal);    
                $this->db->bind('FB_VOID', '0');  
                $this->db->bind('FS_REK', $rekdiskon);   
                $this->db->bind('FS_KD_REFF', $No_Delivery_Order);  
                $this->db->bind('FS_KD_REG', $No_Delivery_Order);    
                $this->db->bind('FS_KD_UNIT', '');  
                $this->db->bind('FB_UNIT_USAHA', '0');   
                $this->db->bind('FB_LEDGER', '1');   
                $this->db->bind('BP_TIPE', '');   
                $this->db->bind('BP_SOURCE_TRS', $numberHutang);   
                $this->db->bind('FS_KD_REF_OUT', '');   
                $this->db->execute(); 

                //addJurnalDetailDebetBiayaPembelianLain
                $this->db->query("  INSERT INTO Keuangan.DBO.TA_JURNAL_DTL
                ( FS_KD_JURNAL,FS_KET_REFF,FN_DEBET,FN_KREDIT,
                FB_VOID,FS_REK,FS_KD_REFF,FS_KD_REG,FS_KD_UNIT,FB_UNIT_USAHA,FB_LEDGER,
                BP_TIPE,BP_SOURCE_TRS,FS_KD_REF_OUT ) 
                VALUES (:FS_KD_JURNAL,:FS_KET_REFF,:FN_DEBET,:FN_KREDIT,
                :FB_VOID,:FS_REK,:FS_KD_REFF,:FS_KD_REG,:FS_KD_UNIT,:FB_UNIT_USAHA,:FB_LEDGER,
                :BP_TIPE,:BP_SOURCE_TRS,:FS_KD_REF_OUT)"); 
                $this->db->bind('FS_KD_JURNAL', $numberHutang); 
                $this->db->bind('FS_KET_REFF','BIaya Lain-Lain Pembelian, No. Faktur : ' . $nofakturTrs . " No. Delivery Order : " . $No_Delivery_Order);
                $this->db->bind('FN_KREDIT', '0');    
                $this->db->bind('FN_DEBET', $NilaiBiayaLainReal);    
                $this->db->bind('FB_VOID', '0');  
                $this->db->bind('FS_REK', $rekbiayalain);   
                $this->db->bind('FS_KD_REFF', $No_Delivery_Order);  
                $this->db->bind('FS_KD_REG', $No_Delivery_Order);    
                $this->db->bind('FS_KD_UNIT', '');  
                $this->db->bind('FB_UNIT_USAHA', '0');   
                $this->db->bind('FB_LEDGER', '1');   
                $this->db->bind('BP_TIPE', '');   
                $this->db->bind('BP_SOURCE_TRS', $numberHutang);   
                $this->db->bind('FS_KD_REF_OUT', '');   
                $this->db->execute(); 
               
            }else{
                $this->db->query("SELECT KD_HUTANG
                FROM Keuangan.DBO.HUTANG_REKANAN WHERE KET2=:KET2
                 and FS_KD_PETUGAS_VOID=:FS_KD_PETUGAS_VOID and FS_TGL_VOID=:FS_TGL_VOID");
                $this->db->bind('KET2', $TransactionCode);
                $this->db->bind('FS_KD_PETUGAS_VOID', '');
                $this->db->bind('FS_TGL_VOID', '1900-01-01 00:00:00.000');
                $this->db->execute();
                $data =  $this->db->single();

                $kodehutang = $data['KD_HUTANG'];
                

                 // validasi sudah di buat order belum
                 $this->db->query("SELECT  *FROM Keuangan.dbo.HUTANG_REKANAN 
                                    where KD_ORDER<>'' and KD_HUTANG=:KD_HUTANG");
                $this->db->bind('KD_HUTANG', $kodehutang); 
                $this->db->execute();
                $cutidokter =  $this->db->rowCount(); 
                if ($cutidokter) { 
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Faktur sudah di Order Hutang, tidak bisa di edit.',
                    );
                    return $callback;
                    exit;
                }

                 // UPDATE FAKTUR
                 $this->db->query("UPDATE [Apotik_V1.1SQL].dbo.FakturManuals SET DeliveryCode=:DeliveryCode,PurchaseOrderCode=:PurchaseOrderCode,
                 TransactionDate=:TransactionDate,UserCreate=:UserCreate,UnitPembelian=:UnitPembelian,SupplierCode=:SupplierCode,
                 NoFakturPBF=:NoFakturPBF,DateFakturPBF=:DateFakturPBF,NoFakturPajak=:NoFakturPajak,Keterangan=:Keterangan,
                 TotalNilaiFaktur=:TotalNilaiFaktur,TglJatuhTempo=:TglJatuhTempo,TipeHutang=:TipeHutang,TotalDiskon=:TotalDiskon,
                 TotalTax=:TotalTax,Subtotal=:Subtotal,DiskonLain=:DiskonLain,BiayaLain=:BiayaLain,Grandtotal=:Grandtotal,
                 UserCreateLast=:UserCreateLast,TransactionDateLast=:TransactionDateLast, IncludePPN=:IncludePPN 
                 ,Pph23=:Pph23,NoRekeningSupplier=:NoRekeningSupplier,NamaNBank=:NamaNBank 
                 WHERE TransactionCode=:TransactionCodex"); 
                 $this->db->bind('Pph23', $NilaiPph23); 
                 $this->db->bind('NoRekeningSupplier', $RekeningSupplier);
                 $this->db->bind('NamaNBank', $RekeningBank);
                 $this->db->bind('TransactionCodex', $TransactionCode);
                 $this->db->bind('DeliveryCode', $No_Delivery_Order);
                 $this->db->bind('PurchaseOrderCode', $No_Purchase_Order);
                 $this->db->bind('TransactionDate', $TransasctionDate);
                 $this->db->bind('UserCreate', $userid);
                 $this->db->bind('UnitPembelian', $Unit); 
                 $this->db->bind('SupplierCode', $PO_KodeSupplierx); 
                 $this->db->bind('NoFakturPBF', $NoFakturPBF); 
                 $this->db->bind('DateFakturPBF', $TglFakturPBF); 
                 $this->db->bind('NoFakturPajak', $NoFakturPBF); 
                 $this->db->bind('Keterangan', $Keterangan); 
                 $this->db->bind('TotalNilaiFaktur', $NilaiFakturReal); 
                 $this->db->bind('TglJatuhTempo', $TglJatuhTempo); 
                 $this->db->bind('TipeHutang', $TipeHutang); 
                 $this->db->bind('TotalDiskon', $NilaiDiskonReal); 
                 $this->db->bind('TotalTax', $NilaiPPNReal); 
                 $this->db->bind('Subtotal', $NilaiSubtotalReal); 
                 $this->db->bind('DiskonLain', $NilaiDiskonReal); 
                 $this->db->bind('BiayaLain', $NilaiBiayaLainReal); 
                 $this->db->bind('Grandtotal', $NilaiGrandTotalReal);  
                 $this->db->bind('UserCreateLast', $userid);   
                 $this->db->bind('TransactionDateLast', $datenowcreate);   
                 $this->db->bind('IncludePPN', $IncludePPN);  
                 $this->db->execute();
                
 
                 // UPDATE HUTANG
                 $notehtg = 'Faktur Pembelian No. : ' . $TransactionCode . ' , No Purchase Order Barang : ' . $No_Purchase_Order.' , No Penerimaan Barang : ' . $No_Delivery_Order;
                 $this->db->query("UPDATE Keuangan.DBO.HUTANG_REKANAN SET 
                 KD_REKANAN=:KD_REKANAN,TGL_HUTANG=:TGL_HUTANG,NILAI_HUTANG=:NILAI_HUTANG,SISA_HUTANG=:SISA_HUTANG,
                 KET=:KET,TGL_TEMPO=:TGL_TEMPO,
                 TGL_FAKTUR=:TGL_FAKTUR,NO_FAKTUR=:NO_FAKTUR,NO_PO=:NO_PO
                 ,NO_REKENING_SUPPLIER=:NO_REKENING_SUPPLIER,NAMA_BANK_SUPPLIER=:NAMA_BANK_SUPPLIER,PPN_23=:PPN_23
                 WHERE KET2=:TransactionCodex and FS_KD_PETUGAS_VOID=:FS_KD_PETUGAS_VOID and FS_TGL_VOID=:FS_TGL_VOID ");  
                 $this->db->bind('PPN_23', $NilaiPph23); 
                 $this->db->bind('NO_REKENING_SUPPLIER', $RekeningSupplier);
                 $this->db->bind('NAMA_BANK_SUPPLIER', $RekeningBank); 
                 $this->db->bind('TransactionCodex', $TransactionCode); 
                 $this->db->bind('NO_PO', $No_Purchase_Order);
                 $this->db->bind('TGL_HUTANG', $TransasctionDate);  
                 $this->db->bind('KD_REKANAN', $PO_KodeSupplierx); 
                 $this->db->bind('NO_FAKTUR', $NoFakturPBF); 
                 $this->db->bind('TGL_FAKTUR', $TglFakturPBF);  
                 $this->db->bind('KET', $notehtg);  
                 $this->db->bind('FS_KD_PETUGAS_VOID', '');  
                 $this->db->bind('FS_TGL_VOID', '1900-01-01 00:00:00.000');  
                 $this->db->bind('TGL_TEMPO', $TglJatuhTempo);  
                 $this->db->bind('NILAI_HUTANG', $NilaiGrandTotalReal);  
                 $this->db->bind('SISA_HUTANG', $NilaiGrandTotalReal);  
                 $this->db->execute();

                
            
                // DELETE KODE HUTANG
                $this->db->query("DELETE FROM  Keuangan.dbo.TA_JURNAL_HDR where FS_KD_JURNAL=:FS_KD_JURNAL"); 
                $this->db->bind('FS_KD_JURNAL', $kodehutang);  
                $this->db->execute();

                $this->db->query("DELETE FROM  Keuangan.dbo.TA_JURNAL_DTL where FS_KD_JURNAL=:FS_KD_JURNAL2"); 
                $this->db->bind('FS_KD_JURNAL2', $kodehutang);  
                $this->db->execute();

                // insert lagi jurnal
                 // INSEERT JURNAL HDR
                 $this->db->query("  INSERT INTO Keuangan.DBO.TA_JURNAL_HDR
                 ( FS_KD_JURNAL,FD_TGL_JURNAL,FN_DEBET,FN_KREDIT,
                 FN_JURNAL,FS_KD_PETUGAS,FS_KET_REFF,FS_KET,FS_KET2,FS_KET3,FB_SELESAI ) 
                 VALUES (:FS_KD_JURNAL,:FD_TGL_JURNAL,:FN_DEBET,:FN_KREDIT,
                 :FN_JURNAL,:FS_KD_PETUGAS,:FS_KET_REFF,:FS_KET,:FS_KET2,:FS_KET3,:FB_SELESAI)"); 
                 $this->db->bind('FS_KD_JURNAL', $kodehutang); 
                 $this->db->bind('FD_TGL_JURNAL', $TransasctionDate);  
                 $this->db->bind('FN_DEBET', $NilaiGrandTotalReal);  
                 $this->db->bind('FN_KREDIT', $NilaiGrandTotalReal);  
                 $this->db->bind('FN_JURNAL', $NilaiGrandTotalReal);  
                 $this->db->bind('FS_KD_PETUGAS', $userid);  
                 $this->db->bind('FS_KET_REFF', $No_Delivery_Order);  
                 $this->db->bind('FS_KET', $notehtg);  
                 $this->db->bind('FS_KET2', '');  
                 $this->db->bind('FS_KET3', '');  
                 $this->db->bind('FB_SELESAI','1');  
                 $this->db->execute();  
                  
                 //addJurnalDetailKreditHutangFaktur
                 $this->db->query("  INSERT INTO Keuangan.DBO.TA_JURNAL_DTL
                 ( FS_KD_JURNAL,FS_KET_REFF,FN_DEBET,FN_KREDIT,
                 FB_VOID,FS_REK,FS_KD_REFF,FS_KD_REG,FS_KD_UNIT,FB_UNIT_USAHA,FB_LEDGER,
                 BP_TIPE,BP_SOURCE_TRS,FS_KD_REF_OUT ) 
                 VALUES (:FS_KD_JURNAL,:FS_KET_REFF,:FN_DEBET,:FN_KREDIT,
                 :FB_VOID,:FS_REK,:FS_KD_REFF,:FS_KD_REG,:FS_KD_UNIT,:FB_UNIT_USAHA,:FB_LEDGER,
                 :BP_TIPE,:BP_SOURCE_TRS,:FS_KD_REF_OUT)"); 
                 $this->db->bind('FS_KD_JURNAL', $kodehutang); 
                 $this->db->bind('FS_KET_REFF','Hutang Faktur Pembelian, No. Faktur : ' . $TransactionCode . " No. Delivery Order : " . $No_Delivery_Order);
                 $this->db->bind('FN_DEBET', '0');    
                 $this->db->bind('FN_KREDIT', $NilaiGrandTotalReal);    
                 $this->db->bind('FB_VOID', '0');  
                 $this->db->bind('FS_REK', $rekeningHutang);   
                 $this->db->bind('FS_KD_REFF', $No_Delivery_Order);  
                 $this->db->bind('FS_KD_REG', $No_Delivery_Order);    
                 $this->db->bind('FS_KD_UNIT', '');  
                 $this->db->bind('FB_UNIT_USAHA', '0');   
                 $this->db->bind('FB_LEDGER', '1');   
                 $this->db->bind('BP_TIPE', $TipeHutang);   
                 $this->db->bind('BP_SOURCE_TRS', $kodehutang);   
                 $this->db->bind('FS_KD_REF_OUT', '');   
                 $this->db->execute(); 
 
                 //addJurnalDetailDebetHutangBarang
                 $this->db->query("  INSERT INTO Keuangan.DBO.TA_JURNAL_DTL
                 ( FS_KD_JURNAL,FS_KET_REFF,FN_DEBET,FN_KREDIT,
                 FB_VOID,FS_REK,FS_KD_REFF,FS_KD_REG,FS_KD_UNIT,FB_UNIT_USAHA,FB_LEDGER,
                 BP_TIPE,BP_SOURCE_TRS,FS_KD_REF_OUT ) 
                 VALUES (:FS_KD_JURNAL,:FS_KET_REFF,:FN_DEBET,:FN_KREDIT,
                 :FB_VOID,:FS_REK,:FS_KD_REFF,:FS_KD_REG,:FS_KD_UNIT,:FB_UNIT_USAHA,:FB_LEDGER,
                 :BP_TIPE,:BP_SOURCE_TRS,:FS_KD_REF_OUT)"); 
                 $this->db->bind('FS_KD_JURNAL', $kodehutang); 
                 $this->db->bind('FS_KET_REFF','Hutang Barang Faktur Pembelian, No. Faktur : ' . $TransactionCode . " No. Delivery Order : " . $No_Delivery_Order);
                 $this->db->bind('FN_KREDIT', '0');    
                 $this->db->bind('FN_DEBET', $NilaiGrandTotalReal);    
                 $this->db->bind('FB_VOID', '0');  
                 $this->db->bind('FS_REK', $rekhutangbarang);   
                 $this->db->bind('FS_KD_REFF', $No_Delivery_Order);  
                 $this->db->bind('FS_KD_REG', $No_Delivery_Order);    
                 $this->db->bind('FS_KD_UNIT', '');  
                 $this->db->bind('FB_UNIT_USAHA', '0');   
                 $this->db->bind('FB_LEDGER', '1');   
                 $this->db->bind('BP_TIPE', '');   
                 $this->db->bind('BP_SOURCE_TRS', $kodehutang);   
                 $this->db->bind('FS_KD_REF_OUT', '');   
                 $this->db->execute(); 
 
                 //addJurnalDetailDebetPPNMasukan
                 $this->db->query("  INSERT INTO Keuangan.DBO.TA_JURNAL_DTL
                 ( FS_KD_JURNAL,FS_KET_REFF,FN_DEBET,FN_KREDIT,
                 FB_VOID,FS_REK,FS_KD_REFF,FS_KD_REG,FS_KD_UNIT,FB_UNIT_USAHA,FB_LEDGER,
                 BP_TIPE,BP_SOURCE_TRS,FS_KD_REF_OUT ) 
                 VALUES (:FS_KD_JURNAL,:FS_KET_REFF,:FN_DEBET,:FN_KREDIT,
                 :FB_VOID,:FS_REK,:FS_KD_REFF,:FS_KD_REG,:FS_KD_UNIT,:FB_UNIT_USAHA,:FB_LEDGER,
                 :BP_TIPE,:BP_SOURCE_TRS,:FS_KD_REF_OUT)"); 
                 $this->db->bind('FS_KD_JURNAL', $kodehutang); 
                 $this->db->bind('FS_KET_REFF','PPN Masukan Pembelian, No. Faktur : ' . $TransactionCode . " No. Delivery Order : " . $No_Delivery_Order);
                 $this->db->bind('FN_KREDIT', '0');    
                 $this->db->bind('FN_DEBET', $NilaiPPNReal);    
                 $this->db->bind('FB_VOID', '0');  
                 $this->db->bind('FS_REK', $rekppn);   
                 $this->db->bind('FS_KD_REFF', $No_Delivery_Order);  
                 $this->db->bind('FS_KD_REG', $No_Delivery_Order);    
                 $this->db->bind('FS_KD_UNIT', '');  
                 $this->db->bind('FB_UNIT_USAHA', '0');   
                 $this->db->bind('FB_LEDGER', '1');   
                 $this->db->bind('BP_TIPE', '');   
                 $this->db->bind('BP_SOURCE_TRS', $kodehutang);   
                 $this->db->bind('FS_KD_REF_OUT', '');   
                 $this->db->execute(); 
 
                 //addJurnalDetailDebetDiskonDetil
                 $this->db->query("  INSERT INTO Keuangan.DBO.TA_JURNAL_DTL
                 ( FS_KD_JURNAL,FS_KET_REFF,FN_DEBET,FN_KREDIT,
                 FB_VOID,FS_REK,FS_KD_REFF,FS_KD_REG,FS_KD_UNIT,FB_UNIT_USAHA,FB_LEDGER,
                 BP_TIPE,BP_SOURCE_TRS,FS_KD_REF_OUT ) 
                 VALUES (:FS_KD_JURNAL,:FS_KET_REFF,:FN_DEBET,:FN_KREDIT,
                 :FB_VOID,:FS_REK,:FS_KD_REFF,:FS_KD_REG,:FS_KD_UNIT,:FB_UNIT_USAHA,:FB_LEDGER,
                 :BP_TIPE,:BP_SOURCE_TRS,:FS_KD_REF_OUT)"); 
                 $this->db->bind('FS_KD_JURNAL', $kodehutang); 
                 $this->db->bind('FS_KET_REFF','Diskon Barang Pembelian, No. Faktur : ' . $TransactionCode . " No. Delivery Order : " . $No_Delivery_Order);
                 $this->db->bind('FN_KREDIT', '0');    
                 $this->db->bind('FN_DEBET', $NilaiDiskonReal);    
                 $this->db->bind('FB_VOID', '0');  
                 $this->db->bind('FS_REK', $rekdiskon);   
                 $this->db->bind('FS_KD_REFF', $No_Delivery_Order);  
                 $this->db->bind('FS_KD_REG', $No_Delivery_Order);    
                 $this->db->bind('FS_KD_UNIT', '');  
                 $this->db->bind('FB_UNIT_USAHA', '0');   
                 $this->db->bind('FB_LEDGER', '1');   
                 $this->db->bind('BP_TIPE', '');   
                 $this->db->bind('BP_SOURCE_TRS', $kodehutang);   
                 $this->db->bind('FS_KD_REF_OUT', '');   
                 $this->db->execute(); 
 
                 //addJurnalDetailDebetBiayaPembelianLain
                 $this->db->query("  INSERT INTO Keuangan.DBO.TA_JURNAL_DTL
                 ( FS_KD_JURNAL,FS_KET_REFF,FN_DEBET,FN_KREDIT,
                 FB_VOID,FS_REK,FS_KD_REFF,FS_KD_REG,FS_KD_UNIT,FB_UNIT_USAHA,FB_LEDGER,
                 BP_TIPE,BP_SOURCE_TRS,FS_KD_REF_OUT ) 
                 VALUES (:FS_KD_JURNAL,:FS_KET_REFF,:FN_DEBET,:FN_KREDIT,
                 :FB_VOID,:FS_REK,:FS_KD_REFF,:FS_KD_REG,:FS_KD_UNIT,:FB_UNIT_USAHA,:FB_LEDGER,
                 :BP_TIPE,:BP_SOURCE_TRS,:FS_KD_REF_OUT)"); 
                 $this->db->bind('FS_KD_JURNAL', $kodehutang); 
                 $this->db->bind('FS_KET_REFF','BIaya Lain-Lain Pembelian, No. Faktur : ' . $TransactionCode . " No. Delivery Order : " . $No_Delivery_Order);
                 $this->db->bind('FN_KREDIT', '0');    
                 $this->db->bind('FN_DEBET', $NilaiBiayaLainReal);    
                 $this->db->bind('FB_VOID', '0');  
                 $this->db->bind('FS_REK', $rekbiayalain);   
                 $this->db->bind('FS_KD_REFF', $No_Delivery_Order);  
                 $this->db->bind('FS_KD_REG', $No_Delivery_Order);    
                 $this->db->bind('FS_KD_UNIT', '');  
                 $this->db->bind('FB_UNIT_USAHA', '0');   
                 $this->db->bind('FB_LEDGER', '1');   
                 $this->db->bind('BP_TIPE', '');   
                 $this->db->bind('BP_SOURCE_TRS', $kodehutang);   
                 $this->db->bind('FS_KD_REF_OUT', '');   
                 $this->db->execute(); 

            }
            $this->db->commit();
            $callback = array(
                'status' => 'success', 
            );
            return $callback;
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
    public function getTukarFakturHeaderManual($data)
    {
        try { 
            $NoTrs = $data['NoTrs']; 
            $this->db->query(" SELECT TransactionCode,PurchaseOrderCode,
            DeliveryCode,
            replace(CONVERT(VARCHAR(11), TransactionDate, 111), '/','-')  as TransactionDate,UnitPembelian,
            SupplierCode,
            NoFakturPBF,
            replace(CONVERT(VARCHAR(11), DateFakturPBF, 111), '/','-')  as DateFakturPBF,NoFakturPajak,Keterangan,
            CONVERT(decimal(18,0), TotalNilaiFaktur) as   TotalNilaiFaktur,
            replace(CONVERT(VARCHAR(11), TglJatuhTempo, 111), '/','-')  as  TglJatuhTempo,
            TipeHutang,
            CONVERT(decimal(18,0), TotalDiskon) as TotalDiskon,
            CONVERT(decimal(18,0), TotalTax) as TotalTax,
            CONVERT(decimal(18,0), Subtotal) as Subtotal,
            CONVERT(decimal(18,0), DiskonLain) as DiskonLain,
            CONVERT(decimal(18,0), BiayaLain) as BiayaLain,
            CONVERT(decimal(18,0), Grandtotal) as Grandtotal,
            IncludePPN,NamaNBank,NoRekeningSupplier,CONVERT(decimal(18,0), Pph23) as Pph23
            FROM [Apotik_V1.1SQL].DBO.FakturManuals
            WHERE TransactionCode=:TransactionCode and Void='0' ");
            $this->db->bind('TransactionCode', $NoTrs); 
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success', // Set array status dengan success
                'TransactionCode' => $data['TransactionCode'], // Set array status dengan success
                'IncludePPN' => $data['IncludePPN'], // Set array status dengan success
                'PurchaseOrderCode' => $data['PurchaseOrderCode'], // Set array status dengan success
                'DeliveryCode' => $data['DeliveryCode'], // Set array status dengan success
                'TransactionDate' => $data['TransactionDate'], // Set array status dengan success
                'UnitPembelian' => $data['UnitPembelian'], // Set array status dengan success
                'SupplierCode' => $data['SupplierCode'], // Set array status dengan success
                'NoFakturPBF' => $data['NoFakturPBF'], // Set array status dengan success
                'DateFakturPBF' => $data['DateFakturPBF'], // Set array status dengan success
                'NoFakturPajak' => $data['NoFakturPajak'], // Set array status dengan success
                'Keterangan' => $data['Keterangan'], // Set array status dengan success
                'TotalNilaiFaktur' => $data['TotalNilaiFaktur'], // Set array status dengan success
                'TglJatuhTempo' => $data['TglJatuhTempo'], // Set array status dengan success
                'TipeHutang' => $data['TipeHutang'], // Set array status dengan success
                'TotalDiskon' => $data['TotalDiskon'], // Set array status dengan success
                'TotalTax' => $data['TotalTax'], // Set array status dengan success
                'Subtotal' => $data['Subtotal'], // Set array status dengan success 
                'BiayaLain' => $data['BiayaLain'], // Set array status dengan success
                'NoRekeningSupplier' => $data['NoRekeningSupplier'], // Set array status dengan success
                'NamaNBank' => $data['NamaNBank'], // Set array status dengan success
                'Pph23' => $data['Pph23'], // Set array status dengan success
                'Grandtotal' => $data['Grandtotal'], // Set array status dengan success
              
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function goVoidHeaderManual($data)
    {
        try {
            $this->db->transaksi();
            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;

            $TransactionCode = $data['No_Transaksi'];
            $AlasanBatal = $data['AlasanBatal'];
            
            $this->db->query("SELECT KD_HUTANG
            FROM Keuangan.DBO.HUTANG_REKANAN WHERE KET2=:KET2
             and FS_KD_PETUGAS_VOID=:FS_KD_PETUGAS_VOID and FS_TGL_VOID=:FS_TGL_VOID");
            $this->db->bind('KET2', $TransactionCode);
            $this->db->bind('FS_KD_PETUGAS_VOID', '');
            $this->db->bind('FS_TGL_VOID', '1900-01-01 00:00:00.000');
            $this->db->execute();
            $data =  $this->db->single();

            $kodehutang = $data['KD_HUTANG'];
            

  
                 // validasi sudah di buat order belum
                 $this->db->query("SELECT  *FROM Keuangan.dbo.HUTANG_REKANAN 
                                    where KD_ORDER<>'' and KD_HUTANG=:KD_HUTANG");
                $this->db->bind('KD_HUTANG', $kodehutang); 
                $this->db->execute();
                $cutidokter =  $this->db->rowCount(); 
                if ($cutidokter) { 
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Faktur sudah di Order Hutang, tidak bisa di edit.',
                    );
                    return $callback;
                    exit;
                }
            // DELETE JURNAL
            $this->db->query("DELETE FROM  Keuangan.dbo.TA_JURNAL_HDR where FS_KD_JURNAL=:FS_KD_JURNAL"); 
            $this->db->bind('FS_KD_JURNAL', $kodehutang);  
            $this->db->execute();

            $this->db->query("DELETE FROM  Keuangan.dbo.TA_JURNAL_DTL where FS_KD_JURNAL=:FS_KD_JURNAL2"); 
            $this->db->bind('FS_KD_JURNAL2', $kodehutang);  
            $this->db->execute();

            $this->db->query("DELETE FROM  Keuangan.dbo.HUTANG_REKANAN where KD_HUTANG=:FS_KD_JURNAL"); 
            $this->db->bind('FS_KD_JURNAL', $kodehutang);  
            $this->db->execute();

            $this->db->query("DELETE FROM  Keuangan.dbo.HUTANG_REKANAN_2 where KD_HUTANG=:FS_KD_JURNAL"); 
            $this->db->bind('FS_KD_JURNAL', $kodehutang);  
            $this->db->execute();

            $this->db->query("UPDATE [Apotik_V1.1SQL].DBO.FakturManuals   
                            SET ReasonVoid=:ReasonVoid,UserVoid=:UserVoid, DateVoid=:DateVoid,Void=:Void
             where TransactionCode=:TransactionCode"); 
            $this->db->bind('TransactionCode', $TransactionCode);  
            $this->db->bind('ReasonVoid', $AlasanBatal);  
            $this->db->bind('UserVoid', $userid);  
            $this->db->bind('DateVoid', $datenowcreate);  
            $this->db->bind('Void', '1');  
            $this->db->execute();
            
            $this->db->commit();
            $callback = array(
                'status' => 'success', 
            );
            return $callback;
            
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