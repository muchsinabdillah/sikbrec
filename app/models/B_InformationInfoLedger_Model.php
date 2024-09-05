<?php
class  B_InformationInfoLedger_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getDataListInfoLedger($data)
    {

        try {
            // pengakuan saldo awal laporan keu
            $this->db->query("SELECT PERIODE
                            from Keuangan.DBO.T_SALDO "); 
            $xxxx =  $this->db->single();
            $PERIODE_SALDO = $xxxx['PERIODE']; 

            // var_dump($xxxx['PERIODE'] );exit;
            if($xxxx['PERIODE'] === null){
                $callback = array(
                    'status' => 'warning',
                    'errorname' => "Data Kosong",

                );
                return $callback;
            }

            $tglawal = $data['PeriodeAwal']; //(kanan view)
            $tglakhir = $data['PeriodeAkhir'];
            $REKENING = $data['REKENING'];
            $periode = date("Y-m",strtotime($tglawal));
            $periode2 = date("Y-m-d", strtotime($tglawal));
            $monthbefore = date("Y-m", strtotime($periode2 . ' - 1 months'));
 
            $xx = date_diff( date_create($tglawal) , date_create($PERIODE_SALDO))->m;
           
            $monthAfterSaldo = date("Y-m", strtotime($PERIODE_SALDO . ' + 1 months'));
            //var_dump($monthAfterSaldo);exit;
            if($xx == "1"){
                $bulancarihari = date("m", strtotime($PERIODE_SALDO . ' - 1 months'));
                $tahuncarihari = date("Y", strtotime($PERIODE_SALDO . ' - 1 months'));
                $jumHari = cal_days_in_month(CAL_GREGORIAN, $bulancarihari, $tahuncarihari);
                $datestartbefore = $PERIODE_SALDO . $jumHari;
                $dateEndbefore = $PERIODE_SALDO . $jumHari;
            }else{
                $datestartbefore = $monthAfterSaldo . '-01';
                $dateEndbefore = date("Y-m-d", strtotime($tglawal . ' - 1 days'));
            }
           // var_dump(' - Periode awal Berjalan : '.$tglawal.' - Periode akhir berjalan : '.$tglakhir.' - Rekening : '.$REKENING.' - Periode Start before : '.$datestartbefore.' - Periode End Before : '.$dateEndbefore.' - Periode Berjalan : '.$periode.' - Priode saldo :'.$PERIODE_SALDO);exit;
            $this->db->query("EXEC  Keuangan.dbo.infojurnal 
            @PeriodeAwal='$tglawal',
            @PeriodeAkhir='$tglakhir',
            @Rekening='$REKENING',
            @PeriodeAwalBerjalan='$datestartbefore',
            @PeriodeAkhirBerjalan='$dateEndbefore',
            @Periode='$periode',
            @periodeSaldo='$PERIODE_SALDO'");

            $data =  $this->db->resultSet();
            $rows = array();

            foreach ($data as $row) {
                $pasing['REKENING'] = $row['FS_KD_REKENING']; //(kiri view/JS 'KANAN QUERY')

                if ($row['Tgl'] == '1900-01-01 00:00:00.000' || $row['Tgl'] == '1990-01-01 00:00:00.000') {
                    $Tgl = "";
                } else {
                    $Tgl = $row['Tgl'];
                }
                $pasing['Tgl'] = $Tgl;
                $pasing['Keterangan'] = $row['Keterangan'];
                $pasing['SaldoAwal'] = number_format($row['SaldoAwal'], 2, ',', '.');
                $pasing['Debet'] = number_format($row['Debet'], 2, ',', '.');
                $pasing['kodejurnal'] = $row['kodejurnal'];
                $pasing['FS_NM_REKENING'] = $row['FS_NM_REKENING'];
                $pasing['Kredit'] = number_format($row['Kredit'], 2, ',', '.');
                $pasing['SaldoAkhir'] = number_format($row['SaldoAkhir'], 2, ',', '.');
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    // public function getDataListInfoLedger1($data)
    // {

    //     try {
    //         $tglawal = $data['PeriodeAwal']; //(kanan view)
    //         $tglakhir = $data['PeriodeAkhir'];
    //         $REKENING = $data['REKENING'];
    //         $periode = date("Y-m",strtotime($tglawal));
    //         $periode2 = date("Y-m-d", strtotime($tglawal));
    //         $monthbefore = date("Y-m", strtotime($periode2 . ' - 1 months'));

    //         $bulancarihari = date("m", strtotime($periode2 . ' - 1 months'));
    //         $tahuncarihari = date("Y", strtotime($periode2 . ' - 1 months'));
            
    //         $jumHari = cal_days_in_month(CAL_GREGORIAN, $bulancarihari, $tahuncarihari);
    //         $datestartbefore = $monthbefore . '-01';
    //         $dateEndbefore = $monthbefore . '-'.$jumHari ; 
            
             
    //         //$monthbeforefix = date("Y-m",strtotime($monthbefore));
    //         $this->db->query("EXEC  Keuangan.dbo.infojurnal 
    //         @PeriodeAwal='$tglawal',
    //         @PeriodeAkhir='$tglakhir',
    //         @Rekening='$REKENING',
    //         @PeriodeAwalBerjalan='$datestartbefore',
    //         @PeriodeAkhirBerjalan='$dateEndbefore',
    //         @Periode='$periode',
    //         @periodeSaldo='2023-05'");


    //         // $this->db->bind('tglawal', $tglawal);
    //         // $this->db->bind('tglakhir', $tglakhir);
    //         // $this->db->bind('REKENING', $REKENING);

    //         $data =  $this->db->resultSet();
    //         $rows = array();

    //         foreach ($data as $row) {
    //             $pasing['REKENING'] = $row['FS_KD_REKENING']; //(kiri view/JS 'KANAN QUERY')

    //             if ($row['Tgl'] == '1900-01-01 00:00:00.000' || $row['Tgl'] == '1990-01-01 00:00:00.000') {
    //                 $Tgl = "";
    //             } else {
    //                 $Tgl = $row['Tgl'];
    //             }
    //             $pasing['Tgl'] = $Tgl;
    //             $pasing['Keterangan'] = $row['Keterangan'];
    //             $pasing['SaldoAwal'] = number_format($row['SaldoAwal'], 2, ',', '.');
    //             $pasing['Debet'] = number_format($row['Debet'], 2, ',', '.');
    //             $pasing['kodejurnal'] = $row['kodejurnal'];
    //             $pasing['Kredit'] = number_format($row['Kredit'], 2, ',', '.');
    //             $pasing['SaldoAkhir'] = number_format($row['SaldoAkhir'], 2, ',', '.');
    //             $rows[] = $pasing;
    //         }
    //         return $data;
    //     } catch (PDOException $e) {
    //         die($e->getMessage());
    //     }
    // }
    public function Gogeneratejurnal($data){
        try {
            $this->db->transaksi();
            $datenowcreate = Utils::seCurrentDateTime();
            $PeriodeSaldo = $data['PeriodeSaldo']; // ok
            $PeriodeAwal = $data['PeriodeAwal']; // ok 
            // TRIGER SEBELUM SIMPAN DATA
            // 1. TRIGER PASIEN JIKA JENIS BELUM DIISI  
            if ($PeriodeSaldo == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Periode Saldo Kosong !',
                );
                echo json_encode($callback);
                exit;
            }
            // 1. TRIGER PASIEN JIKA ALASAN
            if ($PeriodeAwal == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Periode Awal berjalan kosong !',
                );
                echo json_encode($callback);
                exit;
            } 
            $month = date("m", strtotime($PeriodeAwal));
            $year = date("Y", strtotime($PeriodeAwal));
            $this->db->query("DELETE Keuangan.DBO.LEDGER where FS_PERIODE=:PeriodeAwal");
            $this->db->bind('PeriodeAwal', $PeriodeAwal); 
            $this->db->execute();

            $this->db->query("INSERT INTO Keuangan.DBO.LEDGER
                        SELECT a.FS_REK,sum(a.FN_DEBET) FN_DEBET,sum(a.FN_KREDIT) FN_KREDIT,'$month','$year','','$PeriodeAwal'
                        FROM Keuangan.dbo.TM_REKENING f 
                        left join 
                        Keuangan.dbo.TA_JURNAL_DTL a
                        on f.FS_KD_REKENING = a.FS_REK
                        inner join Keuangan.dbo.TA_JURNAL_HDR b
                        on a.FS_KD_JURNAL= b.FS_KD_JURNAL
                        where substring(replace(CONVERT(VARCHAR(11),  b.FD_TGL_JURNAL, 111), '/','-'),1,7) =:Periodeawal
                        and  B.FS_KD_PETUGAS_VOID = ''
                        group by a.FS_REK");
            $this->db->bind('Periodeawal', $PeriodeAwal); 
            $this->db->execute();
 

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Generate Jurnal berhasil !'
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
    public function GetUser()
    {
        try {
            $this->db->query("SELECT NoPIN,[First Name] as Nama FROM MasterdataSQL.DBO.Employees");
            $data =  $this->db->resultSet();
            $rows = array();
            $no = "1";
            foreach ($data as $key) {
                $pasing['NoPIN'] = $key['NoPIN'];
                $pasing['Nama'] = $key['Nama']; 
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function GetDataLedgerHarian($data)
    {
        try {
            $periodeawal = $data['PeriodeAwal'];
            $periodeakhir = $data['PeriodeAkhir'];
            $pin = $data['Nopin'];
            $rekening = $data['rekening'];
            $this->db->query("SELECT a.FS_REK,a.FS_KD_JURNAL AS kodejurnal,
                            f.FS_NM_REKENING,b.FD_TGL_JURNAL as Tgl,a.FS_KET_REFF  as Keterangan,
                            '0'  as SaldoAwal,a.FN_DEBET as Debet,a.FN_KREDIT as Kredit, '0' as SaldoAkhir
                            FROm Keuangan.dbo.TA_JURNAL_DTL a
                            inner join 
                            Keuangan.dbo.TM_REKENING f 
                            on f.FS_KD_REKENING = a.FS_REK
                            inner join Keuangan.dbo.TA_JURNAL_HDR b
                            on a.FS_KD_JURNAL= b.FS_KD_JURNAL
                            where replace(CONVERT(VARCHAR(11),  b.FD_TGL_JURNAL, 111), '/','-')  
                            between '$periodeawal' and '$periodeakhir' and  B.FS_KD_PETUGAS_VOID = ''
                            and b.FS_KD_PETUGAS='$pin' 
                            and  a.FS_REK='$rekening' 
                            order by b.FD_TGL_JURNAL asc , a.FS_KD_JURNAL asc");
            $data =  $this->db->resultSet();
            $rows = array();
            $no = "1";
            foreach ($data as $key) {
                $pasing['REKENING'] = $key['FS_REK'];
                $pasing['FS_NM_REKENING'] = $key['FS_NM_REKENING'];
                $pasing['Tgl'] = $key['Tgl'];
                $pasing['Keterangan'] = $key['Keterangan'];
                $pasing['SaldoAwal'] = $key['SaldoAwal'];
                $pasing['Debet'] = $key['Debet'];
                $pasing['Kredit'] = $key['Kredit'];
                $pasing['kodejurnal'] = $key['kodejurnal'];
                $pasing['SaldoAkhir'] = $key['SaldoAkhir'];
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    // public function GetDataLedgerHarian1($data)
    // {
    //     try {
    //         $periodeawal = $data['PeriodeAwal'];
    //         $periodeakhir = $data['PeriodeAkhir'];
    //         $pin = $data['Nopin'];
    //         $this->db->query("SELECT a.FS_REK,a.FS_KD_JURNAL AS kodejurnal,
    //                         f.FS_NM_REKENING,b.FD_TGL_JURNAL as Tgl,a.FS_KET_REFF  as Keterangan,
    //                         '0'  as SaldoAwal,a.FN_DEBET as Debet,a.FN_KREDIT as Kredit, '0' as SaldoAkhir
    //                         FROm Keuangan.dbo.TA_JURNAL_DTL a
    //                         inner join 
    //                         Keuangan.dbo.TM_REKENING f 
    //                         on f.FS_KD_REKENING = a.FS_REK
    //                         inner join Keuangan.dbo.TA_JURNAL_HDR b
    //                         on a.FS_KD_JURNAL= b.FS_KD_JURNAL
    //                         where replace(CONVERT(VARCHAR(11),  b.FD_TGL_JURNAL, 111), '/','-')  
    //                         between '$periodeawal' and '$periodeakhir' and  B.FS_KD_PETUGAS_VOID = ''
    //                         and b.FS_KD_PETUGAS='$pin' order by b.FD_TGL_JURNAL asc , a.FS_KD_JURNAL asc");
    //         $data =  $this->db->resultSet();
    //         $rows = array();
    //         $no = "1";
    //         foreach ($data as $key) {
    //             $pasing['REKENING'] = $key['FS_REK'];
    //             $pasing['FS_NM_REKENING'] = $key['FS_NM_REKENING'];
    //             $pasing['Tgl'] = $key['Tgl'];
    //             $pasing['Keterangan'] = $key['Keterangan'];
    //             $pasing['SaldoAwal'] = $key['SaldoAwal'];
    //             $pasing['Debet'] = $key['Debet'];
    //             $pasing['Kredit'] = $key['Kredit'];
    //             $pasing['kodejurnal'] = $key['kodejurnal'];
    //             $pasing['SaldoAkhir'] = $key['SaldoAkhir'];
    //             $rows[] = $pasing;
    //             $no++;
    //         }
    //         return $data;
    //     } catch (PDOException $e) {
    //         die($e->getMessage());
    //     }
    // }
    public function getDataListInfoLedgerRekap($data)
    {

        try {

            $tglawal = $data['PeriodeAwal']; //(kanan view)
            $tglakhir = $data['PeriodeAkhir']; 

            
            // pengakuan saldo awal laporan keu
            $this->db->query("SELECT PERIODE
                            from Keuangan.DBO.T_SALDO "); 
            $xxxx =  $this->db->single();
            $PERIODE_SALDO = $xxxx['PERIODE']; 

            // var_dump($xxxx['PERIODE'] );exit;
            if($xxxx['PERIODE'] === null){
                $callback = array(
                    'status' => 'warning',
                    'errorname' => "Data Kosong",

                );
                return $callback;
            }

            // show rekening
            $this->db->query(" SELECT FS_KD_REKENING,FS_NM_REKENING
            FROM Keuangan.DBO.TM_REKENING WHERE AKTIF=:AKTIF AND GROUP_REK=:GROUP_REK  ");
            $this->db->bind('AKTIF', '1'); 
            $this->db->bind('GROUP_REK', '4'); 
            $datarek =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($datarek as $key) {

                $periode = date("Y-m",strtotime($tglawal));
                $periode2 = date("Y-m-d", strtotime($tglawal));
                $monthbefore = date("Y-m", strtotime($periode2 . ' - 1 months'));
                $xx = date_diff( date_create($tglawal) , date_create($PERIODE_SALDO))->m;
                $monthAfterSaldo = date("Y-m", strtotime($PERIODE_SALDO . ' + 1 months'));
                if($xx == "1"){
                    $bulancarihari = date("m", strtotime($PERIODE_SALDO . ' - 1 months'));
                    $tahuncarihari = date("Y", strtotime($PERIODE_SALDO . ' - 1 months'));
                    $jumHari = cal_days_in_month(CAL_GREGORIAN, $bulancarihari, $tahuncarihari);
                    $datestartbefore = $PERIODE_SALDO . $jumHari;
                    $dateEndbefore = $PERIODE_SALDO . $jumHari;
                }else{
                    $datestartbefore = $monthAfterSaldo . '-01';
                    $dateEndbefore = date("Y-m-d", strtotime($tglawal . ' - 1 days'));
                }
               // var_dump($tglawal.' tglakhir : '.$tglakhir. ' ,datestartbefore : ' . $datestartbefore. ' , dateEndbefore : ' . $dateEndbefore, ' , periode : ' . $periode . ' , PERIODE_SALDO : ' .$PERIODE_SALDO);
                ini_set('max_execution_time', '300');
                $this->db->query("EXEC  Keuangan.dbo.infojurnal_rekap_saldo_perrekening 
                @PeriodeAwal='$tglawal',
                @PeriodeAkhir='$tglakhir',
                @Rekening='$key[FS_KD_REKENING]',
                @PeriodeAwalBerjalan='$datestartbefore',
                @PeriodeAkhirBerjalan='$dateEndbefore',
                @Periode='$periode',
                @periodeSaldo='$PERIODE_SALDO'");
                $datasaldo =  $this->db->single(); 
                $SALDO_AWAL = $datasaldo['SaldoAwal']; 

                //cari rekap
                $this->db->query("SELECT f.FS_KD_REKENING,f.FS_NM_REKENING,'$periode' as Periode,'$SALDO_AWAL' as SaldoAwal,  
                    sum(isnull(a.FN_DEBET,0)) as Debet, sum( isnull(a.FN_KREDIT,0)) as Kredit 
                    FROM Keuangan.dbo.TM_REKENING f 
                    inner join 
                    Keuangan.dbo.TA_JURNAL_DTL a
                    on f.FS_KD_REKENING = a.FS_REK
                    inner join Keuangan.dbo.TA_JURNAL_HDR b
                    on a.FS_KD_JURNAL= b.FS_KD_JURNAL
                    where replace(CONVERT(VARCHAR(11),  b.FD_TGL_JURNAL, 111), '/','-')  
                    between '$tglawal'  and '$tglakhir'
                    and FS_REK='$key[FS_KD_REKENING]'  AND B.FS_KD_PETUGAS_VOID = ''
                    group by f.FS_KD_REKENING,f.FS_NM_REKENING "); 
                    
                $datarekap =  $this->db->single(); 

                $DEBET = $datarekap['Debet']; 
                $KREDIT = $datarekap['Kredit']; 
                $SALDO_AKHIR = ($SALDO_AWAL+$datarekap['Debet'])-$datarekap['Kredit'];

                $pasing['FS_KD_REKENING'] = $key['FS_KD_REKENING'];
                $pasing['FS_NM_REKENING'] = $key['FS_NM_REKENING'];  
                $pasing['SALDO_AWAL'] = $SALDO_AWAL;  
                $pasing['DEBET'] = $DEBET;  
                $pasing['KREDIT'] = $KREDIT;  
                $pasing['SALDO_AKHIR'] = $SALDO_AKHIR;  
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
