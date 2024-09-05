<?php

class I_Order_Hutang_Model
{
    private $db;
    use ApiRsyarsi;


    public function __construct()
    {
        $this->db = new Database;
    }

    public function getHutangJatuhTempo($data)
    {
        try {  
            
            $this->db->query("SELECT KD_HUTANG,replace(CONVERT(VARCHAR(11), TGL_HUTANG, 111), '/','-') as TGL_HUTANG
            ,NILAI_HUTANG, KET,KD_DOKTER
            FROM Keuangan.dbo.HUTANG_REKANAN
            WHERE replace(CONVERT(VARCHAR(11), FS_TGL_VOID, 111), '/','-') ='1900-01-01' 
            AND FS_KD_PETUGAS_VOID=''
            AND KD_REKANAN=:NamaSupplier 
            and replace(CONVERT(VARCHAR(11), TGL_TEMPO, 111), '/','-') between :tglperiode1 and :tglperiode2
            and KD_ORDER=''");
            $this->db->bind('tglperiode1', $data['Periode1']); 
            $this->db->bind('tglperiode2', $data['Periode2']); 
            $this->db->bind('NamaSupplier', $data['NamaSupplier']); 
            $data =  $this->db->resultSet();
            $rows = array(); 
            foreach ($data as $key) 
            {
                        $pasing['KD_HUTANG'] = $key['KD_HUTANG'];
                        $pasing['NILAI_HUTANG'] = $key['NILAI_HUTANG']; 
                        $pasing['TGL_HUTANG'] = date('d/m/Y', strtotime($key['TGL_HUTANG'])); 
                        $pasing['NILAI_HUTANG'] = $key['NILAI_HUTANG'];
                        $pasing['KET'] =$key['KET']; 
                        $rows[] = $pasing;
            }
            return $rows;
            
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function createOrderHutang($data)
    {
        try {
            $this->db->transaksi();
            $TransactionCode = $data['NoTransaksi']; 
            $Periode1 = $data['Periode1'];
            $Periode2 = $data['Periode2'];
            $TotalHutang = $data['TotalHutang'];
            $NamaSupplier = $data['NamaSupplier'];
            $TransasctionDate = $data['TransasctionDate'];

            if ($TransasctionDate == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Tanggal Transaksi Kosong !',
                );
                return $callback;
                exit;
            }   
            if ($Periode1 == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Periode Jatuh Tempo Awal Kosong !',
                );
                return $callback;
                exit;
            } 
            if ($Periode2 == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Periode Jatuh Tempo Akhir Kosong !',
                );
                return $callback;
                exit;
            } 
            if ($NamaSupplier == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Nama Supplier Kosong !',
                );
                return $callback;
                exit;
            } 
            if ($TotalHutang == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Total Transaksi Kosong !',
                );
                return $callback;
                exit;
            } 
           

            if($TransactionCode == ""){

                 

                    $tod = json_decode(json_encode((object) $data['iddetail']), FALSE);
                        foreach ($tod as $kd_hutang) {
                         

                            // validasi hutang udh di buat order belum
                            $this->db->query("SELECT  KD_ORDER
                            FROM Keuangan.DBO.HUTANG_REKANAN
                            where FS_KD_PETUGAS_VOID='' and KD_ORDER<>'' and KD_HUTANG = :KD_HUTANG");
                            $this->db->bind('KD_HUTANG', $kd_hutang); 
                            $this->db->execute();
                            $datas =  $this->db->single(); 
                            if($datas)
                            {
                                $KD_ORDER = $datas['KD_ORDER'];
                                $callback = array(
                                    'status' => 'warning',
                                    'errorname' => 'Hutang ini sudah di buatkan No. Order Hutang '. $KD_ORDER. ". Silahkan Cek Data Hutang.",
                                );
                                return $callback;
                                exit;
                            }
                        }  

                $AWAL = 'OJM';
                $tahun = Utils::datenowcreateYearOnly();
                $bulan = Utils::datenowcreateMonthOnly2();
                $ddatedmy = date("mY", strtotime($TransasctionDate));
                $this->db->query("SELECT  TOP 1 KD_TRS_ORDER,right(KD_TRS_ORDER,4) as nourut
                FROM Keuangan.dbo.ORDER_H_REKANAN   WHERE  
                SUBSTRING(KD_TRS_ORDER,4,6) = :ddatedmy ORDER BY KD_TRS_ORDER DESC");
                $this->db->bind('ddatedmy', $ddatedmy);
                $datax =  $this->db->single();
                $no_pass = $datax['nourut'];  
                $id = $no_pass;
                $id++;
                $nourutfixReg = Utils::generateAutoNumberFourDigit($id);
                $nofakturTrs=$AWAL.$ddatedmy.'-'.$nourutfixReg;

                $datenowcreate = Utils::seCurrentDateTime();
                $session = SessionManager::getCurrentSession();
                $userid = $session->username;

                            $this->db->query(" INSERT INTO Keuangan.dbo.ORDER_H_REKANAN 
                                (KD_TRS_ORDER,TGL_ORDER,PETUGAS,
                                KD_REKANAN,TOTAL,BATAL,PeriodeHutangAwal,PeriodeHutangAkhir) 
                                VALUES 
                                (:KD_TRS_ORDER,:TGL_ORDER,:PETUGAS,
                                :KD_REKANAN,:TOTAL,:BATAL,:Periode1,:Periode2)"); 
                                $this->db->bind('KD_TRS_ORDER', $nofakturTrs);
                                $this->db->bind('TGL_ORDER', $TransasctionDate);
                                $this->db->bind('PETUGAS', $userid);
                                $this->db->bind('KD_REKANAN', $NamaSupplier);
                                $this->db->bind('Periode1', $Periode1);
                                $this->db->bind('Periode2', $Periode2);
                                $this->db->bind('TOTAL', $TotalHutang); 
                                $this->db->bind('BATAL','0');  
                                $this->db->execute();
                
                        $tod = json_decode(json_encode((object) $data['iddetail']), FALSE);
                        foreach ($tod as $kd_hutang) {
                            $this->db->query("UPDATE Keuangan.dbo.HUTANG_REKANAN 
                                        set KD_ORDER=:KD_TRS_ORDER  
                                        where replace(CONVERT(VARCHAR(11), TGL_TEMPO, 111), '/','-') between :tglperiode1 and :tglperiode2
                                        and KD_ORDER='' and KD_REKANAN=:KD_REKANAN and KD_HUTANG=:kd_hutang "); 
                            $this->db->bind('KD_TRS_ORDER', $nofakturTrs);  
                            $this->db->bind('KD_REKANAN', $NamaSupplier); 
                            $this->db->bind('tglperiode1', $Periode1);
                            $this->db->bind('tglperiode2', $Periode2);
                            $this->db->bind('kd_hutang', $kd_hutang);
                            $this->db->execute();   
                        }  


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
    public function getListOrderHutangJatuhTempo($data)
    {
        try {  
            
            $this->db->query("SELECT a.ID,KD_TRS_ORDER,replace(CONVERT(VARCHAR(11), TGL_ORDER, 111), '/','-') as
                            TGL_ORDER,B.Company,C.[First Name] AS NamaUser,sum(d.NILAI_HUTANG) as NILAI_HUTANG,
							sum(d.SISA_HUTANG) as SISA_HUTANG
                            FROM Keuangan.dbo.ORDER_H_REKANAN A
                            INNER JOIN [Apotik_V1.1SQL].DBO.Suppliers B 
                            ON A.KD_REKANAN = B.ID
                            INNER JOIN MasterdataSQL.DBO.Employees C
                            ON C.NoPIN collate SQL_Latin1_General_CP1_CI_AS = A.PETUGAS collate SQL_Latin1_General_CP1_CI_AS
                            inner join Keuangan.dbo.HUTANG_REKANAN d
							on d.KD_ORDER = a.KD_TRS_ORDER
                            where batal='0' 
                            and  SUBSTRING(replace(CONVERT(VARCHAR(11), TGL_ORDER, 111), '/','-'),1,7)=:tglperiode
                            GROUP BY  a.ID,KD_TRS_ORDER,replace(CONVERT(VARCHAR(11), TGL_ORDER, 111), '/','-'),
							B.Company,C.[First Name] 
							HAVING sum(SISA_HUTANG)  > 0");
            $this->db->bind('tglperiode', $data['Periode']); 
            $data =  $this->db->resultSet();
            $rows = array(); 
            foreach ($data as $row) 
            {
                        $pasing['ID'] = $row['ID']; 
                        $pasing['KD_TRS_ORDER'] = $row['KD_TRS_ORDER']; 
                        $pasing['TGL_ORDER'] = date('d/m/Y', strtotime($row['TGL_ORDER'])); 
                        $pasing['Company'] = $row['Company'];
                        $pasing['NamaUser'] =$row['NamaUser']; 
                        $pasing['NILAI_HUTANG'] =$row['NILAI_HUTANG']; 
                        $pasing['SISA_HUTANG'] =$row['SISA_HUTANG']; 
                        $rows[] = $pasing;
            }
            return $rows;
            
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getOrderHutangbyId($data)
    {
        try { 
            $NoTrs = $data['NoTrs']; 
            $this->db->query(" SELECT  replace(CONVERT(VARCHAR(11), PeriodeHutangAwal, 111), '/','-') as PeriodeHutangAwalx, 
                                    replace(CONVERT(VARCHAR(11), PeriodeHutangAkhir, 111), '/','-') as PeriodeHutangAkhirx, 
                                     *FROM Keuangan.DBO.ORDER_H_REKANAN WHERE ID=:TransactionCode ");
            $this->db->bind('TransactionCode', $NoTrs); 
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success', // Set array status dengan success
                'ID' => $data['ID'], // Set array status dengan success
                'KD_TRS_ORDER' => $data['KD_TRS_ORDER'], // Set array status dengan success
                'PeriodeHutangAwal' => $data['PeriodeHutangAwalx'], // Set array status dengan success
                'PeriodeHutangAkhir' => $data['PeriodeHutangAkhirx'], // Set array status dengan success
                'KD_REKANAN' => $data['KD_REKANAN'], // Set array status dengan success 
                'KD_REKANAN' => $data['KD_REKANAN'], // Set array status dengan success 
                'TGL_ORDER' => $data['TGL_ORDER'], // Set array status dengan success 
                'TOTALHUTANG' => $data['TOTAL'], // Set array status dengan success 
              
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getOrderHutangDetailbyIdOrder($data)
    {
        try { 
            $NoTrs = $data['NoTrs']; 
            $this->db->query(" SELECT  replace(CONVERT(VARCHAR(11), PeriodeHutangAwal, 111), '/','-') as PeriodeHutangAwalx, 
                                    replace(CONVERT(VARCHAR(11), PeriodeHutangAkhir, 111), '/','-') as PeriodeHutangAkhirx, 
                                     *FROM Keuangan.DBO.ORDER_H_REKANAN WHERE ID=:TransactionCode ");
            $this->db->bind('TransactionCode', $NoTrs); 
            $data =  $this->db->single();
            $idorder =  $data['KD_TRS_ORDER'];
            $this->db->query("SELECT KD_HUTANG,TGL_HUTANG,KET,NILAI_HUTANG,
							SISA_HUTANG, NO_PO,NO_FAKTUR,TGL_TEMPO,TGL_FAKTUR
							FROM Keuangan.dbo.HUTANG_REKANAN WHERE KD_ORDER =:idorder ");
            $this->db->bind('idorder', $idorder); 
            $data =  $this->db->resultSet();
            $rows = array(); 
            foreach ($data as $row) 
            {
                $pasing['KD_HUTANG'] = $row['KD_HUTANG'];
                $pasing['KET'] = $row['KET']; 
                $pasing['TGL_HUTANG'] = date('d/m/Y', strtotime($row['TGL_HUTANG'])); 
                $pasing['TGL_TEMPO'] = date('d/m/Y', strtotime($row['TGL_TEMPO'])); 
                $pasing['TGL_FAKTUR'] = date('d/m/Y', strtotime($row['TGL_FAKTUR'])); 
                $pasing['NILAI_HUTANG'] = $row['NILAI_HUTANG'];
                $pasing['SISA_HUTANG'] = $row['SISA_HUTANG'];
                $pasing['NO_PO'] = $row['NO_PO'];
                $pasing['NO_FAKTUR'] = $row['NO_FAKTUR'];
                $pasing['NILAI_HUTANG'] = $row['NILAI_HUTANG']; 
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getOrderHutangDetailbyId($data)
    {
        try {  
            
            $this->db->query("SELECT KD_HUTANG,replace(CONVERT(VARCHAR(11), TGL_HUTANG, 111), '/','-') as TGL_HUTANG
                            ,NILAI_HUTANG, KET,KD_DOKTER
                            FROM Keuangan.dbo.HUTANG_REKANAN a
                            INNER JOIN Keuangan.DBO.ORDER_H_REKANAN B 
                            ON A.KD_ORDER = B.KD_TRS_ORDER
                            WHERE  B.ID=:IdTRS ");
            $this->db->bind('IdTRS', $data['IdTRS']); 
            $data =  $this->db->resultSet();
            $rows = array(); 
            foreach ($data as $row) 
            {
                    $pasing['KD_HUTANG'] = $row['KD_HUTANG'];
                    $pasing['NILAI_HUTANG'] = $row['NILAI_HUTANG']; 
                    $pasing['TGL_HUTANG'] = date('d/m/Y', strtotime($row['TGL_HUTANG'])); 
                    $pasing['NILAI_HUTANG'] = $row['NILAI_HUTANG'];
                    $pasing['KET'] =$row['KET']; 
                    $rows[] = $pasing;
            }
            return $rows;
            
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function goVoidOrderHutang($data)
    {
        try {
            $this->db->transaksi();
            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;

            $TransactionCode = $data['No_Transaksi'];
            $AlasanBatal = $data['AlasanBatal'];
            
            // $this->db->query("SELECT KD_HUTANG
            // FROM Keuangan.DBO.HUTANG_REKANAN WHERE KET2=:KET2
            //  and FS_KD_PETUGAS_VOID=:FS_KD_PETUGAS_VOID and FS_TGL_VOID=:FS_TGL_VOID");
            // $this->db->bind('KET2', $TransactionCode);
            // $this->db->bind('FS_KD_PETUGAS_VOID', '');
            // $this->db->bind('FS_TGL_VOID', '1900-01-01 00:00:00.000');
            // $this->db->execute();
            // $data =  $this->db->single();

            // $kodehutang = $data['KD_HUTANG'];
            

  
                 // validasi sudah di buat order belum
                //  $this->db->query("SELECT  *FROM Keuangan.dbo.HUTANG_REKANAN 
                //                     where KD_ORDER<>'' and KD_HUTANG=:KD_HUTANG");
                // $this->db->bind('KD_HUTANG', $kodehutang); 
                // $this->db->execute();
                // $cutidokter =  $this->db->rowCount(); 
                // if ($cutidokter) { 
                //     $callback = array(
                //         'status' => 'warning',
                //         'errorname' => 'Faktur sudah di Order Hutang, tidak bisa di edit.',
                //     );
                //     return $callback;
                //     exit;
                // }

 
            $this->db->query("UPDATE Keuangan.dbo.ORDER_H_REKANAN 
                            SET  BATAL=:Void,PETUGAS_BATAL=:PETUGAS_BATAL, TGL_BATAL=:TGL_BATAL,ALASAN_BATAL=:ALASAN_BATAL
                            where KD_TRS_ORDER=:TransactionCode"); 
            $this->db->bind('TransactionCode', $TransactionCode);  
            $this->db->bind('ALASAN_BATAL', $AlasanBatal);  
            $this->db->bind('PETUGAS_BATAL', $userid);  
            $this->db->bind('TGL_BATAL', $datenowcreate);  
            $this->db->bind('Void', '1');  
            $this->db->execute();

            $this->db->query("UPDATE Keuangan.dbo.HUTANG_REKANAN 
            SET  KD_ORDER=:KD_ORDER 
            where KD_ORDER=:TransactionCode"); 
            $this->db->bind('TransactionCode', $TransactionCode);   
            $this->db->bind('KD_ORDER', '');  
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
                'status' => "error", 
                'message' => $e,
                
            );
            return $callback; 
        }
    }
    public function getInfoPengajuanHutangRekap($data)
    {
        try {

            $TglAwal = $data['TglAwal'];
            $TglAkhir = $data['TglAkhir'];
            // var_dump($TglAwal, $TglAkhir, $optJenisInfo);
            // exit;
            $this->db->query("SELECT KD_TRS_ORDER,TGL_ORDER,[First Name] as FirstName,Company,PeriodeHutangAwal,PeriodeHutangAkhir,sum(nilai_hutang) as total
            FROM Keuangan.dbo.v_order_pelunasan_Hutang where replace(CONVERT(VARCHAR(11), TGL_ORDER, 111), '/','-') BETWEEN :TglAwal and :TglAkhir
            group by KD_TRS_ORDER,TGL_ORDER,[First Name],Company,PeriodeHutangAwal,PeriodeHutangAkhir
            order by 4 asc");
            $this->db->bind('TglAwal', $TglAwal);
            $this->db->bind('TglAkhir', $TglAkhir);

            $data =  $this->db->resultSet();

            $rows = array();
            $no = 1;

            foreach ($data as $row) {
                $pasing['no'] = $no++;
                $pasing['KD_TRS_ORDER'] = $row['KD_TRS_ORDER'];
                $pasing['TGL_ORDER'] = $row['TGL_ORDER'];
                $pasing['FirstName'] = $row['FirstName'];
                $pasing['Company'] = $row['Company'];
                $pasing['total'] = $row['total'];
                $pasing['PeriodeHutangAwal'] = $row['PeriodeHutangAwal'];
                $pasing['PeriodeHutangAkhir'] = $row['PeriodeHutangAkhir'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getInfoPengajuanHutangRekap1($data)
    {
        try {

            $TglAwal = $data['TglAwal'];
            $TglAkhir = $data['TglAkhir'];
            // var_dump($TglAwal, $TglAkhir, $optJenisInfo);
            // exit;
            $this->db->query("SELECT KD_TRS_ORDER,TGL_ORDER,[First Name] as FirstName,Company,PeriodeHutangAwal,PeriodeHutangAkhir,sum(nilai_hutang) as total
            FROM Keuangan.dbo.v_order_pelunasan_Hutang where replace(CONVERT(VARCHAR(11), TGL_ORDER, 111), '/','-') BETWEEN :TglAwal and :TglAkhir
            group by KD_TRS_ORDER,TGL_ORDER,[First Name],Company,PeriodeHutangAwal,PeriodeHutangAkhir
            order by 4 asc");
            $this->db->bind('TglAwal', $TglAwal);
            $this->db->bind('TglAkhir', $TglAkhir);

            $data =  $this->db->resultSet();

            $rows = array();
            $no = 1;

            foreach ($data as $row) {
                $pasing['no'] = $no++;
                $pasing['KD_TRS_ORDER'] = $row['KD_TRS_ORDER'];
                $pasing['TGL_ORDER'] = $row['TGL_ORDER'];
                $pasing['FirstName'] = $row['FirstName'];
                $pasing['Company'] = $row['Company'];
                $pasing['total'] = $row['total'];
                $pasing['PeriodeHutangAwal'] = $row['PeriodeHutangAwal'];
                $pasing['PeriodeHutangAkhir'] = $row['PeriodeHutangAkhir'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}