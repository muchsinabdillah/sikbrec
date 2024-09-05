<?php
class B_JurnalUmum_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getDataListDataJurnalUmum()
    {

        try {
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;


            $this->db->query("SELECT a.*,b.username FROM Keuangan.DBO.TA_JURNAL_HDR a 
            left join MasterdataSQL.dbo.Employees b on a.FS_KD_PETUGAS collate Latin1_General_CS_AS=b.NoPIN collate Latin1_General_CS_AS
            where FS_KD_PETUGAS_VOID ='' and FS_KD_PETUGAS=:xhrNoPIN AND FS_KD_JURNAL like 'JU%' ORDER BY 1 DESC
    ");
            $this->db->bind('xhrNoPIN', $userid);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $row) {
                $pasing['No_Jurnal'] = $row['FS_KD_JURNAL'];
                $pasing['Tanggal'] = date('d/m/Y H.i.s', strtotime($row['FD_TGL_JURNAL']));
                $pasing['Jumlah'] = number_format($row['FN_JURNAL'], 0, ",", ".");
                $pasing['Keperluan'] = $row['FS_KET'];
                $pasing['Petugas'] = $row['username'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function CreateHdrJurnal($data)
    {
        try {
            $this->db->transaksi();
            //$NoJurnal = $data['No_Jurnal'];

            //PASSING VARIABLE FROM FORM

            //GET DATE NOW
            $datenowcreate = Utils::seCurrentDateTime();

            //GET SESSION USER LOGIN
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;


            //GET LAST NUMBER-----------------

            //GET KODE AWAL
            $kodeRegAwal = "JU";

            //KODE TENGAH
            $formatDateJurnal = date('dmy');

            //QUERY GET LAST NUMBER
            $this->db->query("SELECT  TOP 1 FS_KD_JURNAL,right(FS_KD_JURNAL,3) as urutregx
                FROM Keuangan.dbo.TA_JURNAL_HDR  WHERE  
                SUBSTRING(FS_KD_JURNAL,3,6)=:formatDateJurnal
                AND LEFT(FS_KD_JURNAL,2)=:kodeRegAwal  ORDER BY FS_KD_JURNAL DESC");
            $this->db->bind('formatDateJurnal', $formatDateJurnal);
            $this->db->bind('kodeRegAwal', $kodeRegAwal);
            $data =  $this->db->single();

            //no urut
            $no_reg = $data['urutregx'];
            $idReg = $no_reg;
            $idReg++;

            // GENERATE NO JURNAL (LAST 3 DIGIT)
            if (strlen($idReg) == 1) {
                $noUrutJurnal = "00" . $idReg;
            } else if (strlen($idReg) == 2) {
                $noUrutJurnal = "0" . $idReg;
            } else if (strlen($idReg) == 3) {
                $noUrutJurnal = $idReg;
            }
            //NO FINAL JURNAL
            $NoJurnalFix = $kodeRegAwal . $formatDateJurnal . '-' . $noUrutJurnal;

            //INSERT INTO TA_JURNAL_HDR
            $this->db->query("INSERT INTO Keuangan.dbo.TA_JURNAL_HDR
                                        (FS_KD_JURNAL,FD_TGL_JURNAL,FS_KD_PETUGAS) values
                                        (:NoJurnalFix,:datenowcreate,:userid)");
            $this->db->bind('NoJurnalFix', $NoJurnalFix);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('userid', $userid);

            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi success !', // Set array status dengan success 
                'NoJurnal' => $NoJurnalFix
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function CreateDtlJurnal($data)
    {
        try {
            $this->db->transaksi();
            //PASSING VARIABLE FROM FORM

            $REKENING = $data['REKENING'];
            $tgljurnal = $data['tgljurnal'];
            $D_K = $data['DebetK'];
            $Keterangan = $data['Keterangan'];
            $NamaUnit = $data['NamaUnit'];
            $NominalJurnal = $data['NominalJurnal'];

            $PassLedgerTgl = $data['PassLedgerTgl'];
            $PassLedgerKode = $data['PassLedgerKode'];
            $PassLedgerKet = $data['PassLedgerKet'];
            // $FB_LEDGER_P = $data['FB_LEDGER_P'];
            // $FB_LEDGER_H = $data['FB_LEDGER_H'];
            $tipepembayaran =  $data['PassjenisAsuransi'];
            $PassKodeFaktur =  $data['PassKodeFaktur'];
            $PassTipePasien = $data['PassTipePasien'];
            $PassLedgerPNoRekening = $data['PassLedgerPNoRekening'];
            $PassLedgerPNoPO = $data['PassLedgerPNoPO'];
            $PassLedgerPNanamBank = $data['PassLedgerPNanamBank'];

            $NoJurnal = $data['Nojurnal'];
            if ($NoJurnal == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. Jurnal Invalid !',
                );
                return $callback;
                exit;
            }
            if ($tgljurnal == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Tgl. Jurnal Invalid !',
                );
                return $callback;
                exit;
            }
            if ($D_K == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'DebetK Jurnal Invalid !',
                );
                return $callback;
                exit;
            }
            if ($Keterangan == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Keterangan Jurnal Invalid !',
                );
                return $callback;
                exit;
            }
            if ($NamaUnit == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Nama Unit Invalid !',
                );
                return $callback;
                exit;
            }
            if ($NominalJurnal == "" || $NominalJurnal == "0") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Nominal Jurnal Invalid !',
                );
                return $callback;
                exit;
            }

            $this->db->query("SELECT FB_LEDGER_P,FB_LEDGER_H  from Keuangan.dbo.TM_REKENING
            where FS_KD_REKENING=:koderekening");
            $this->db->bind('koderekening', $REKENING);
            $datas =  $this->db->single();
            $FB_LEDGER_P = $datas['FB_LEDGER_P'];
            $FB_LEDGER_H = $datas['FB_LEDGER_H'];

            //GET DATE NOW
            $datenowcreate = Utils::seCurrentDateTime();

            //GET SESSION USER LOGIN
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;

            if ($D_K == 'DEBET') {
                $this->db->query("SELECT  * from  Keuangan.dbo.TA_JURNAL_DTL where FS_REK =:koderekening and FB_VOID='0' and 
                FS_KD_JURNAL=:NoJurnal");
                $this->db->bind('koderekening', $REKENING);
                $this->db->bind('NoJurnal', $NoJurnal);
                $data1 =  $this->db->single();
                $ID = $data1['ID'];

                if ($ID == True) {
                    $callback = array(
                        'status' => "warning",
                        'errorname' => "Rekening ini sudah ada di Debet Jurnal !",
                    );
                    return $callback;
                }
            } else {

                $this->db->query("SELECT  * from  Keuangan.dbo.TA_JURNAL_DTL where FS_REK =:koderekening and FB_VOID='0' and 
                FS_KD_JURNAL=:NoJurnal");
                $this->db->bind('koderekening', $REKENING);
                $this->db->bind('NoJurnal', $NoJurnal);
                $data1 =  $this->db->single();
                $ID = $data1['ID'];

                if ($ID == True) {
                    $callback = array(
                        'status' => "warning",
                        'errorname' => "Rekening ini sudah ada di Kredit Jurnal !",
                    );
                    return $callback;
                }
            }

            $datenowglobal = Utils::datenowcreateNotFull();

            if ($D_K == 'DEBET') {
                if ($FB_LEDGER_P == '1') {
                    $TglTrs = date('Y-m-d', strtotime($tgljurnal));
                    $JamNow = date('H:m:s');
                    $dateTransaksi = $TglTrs . ' ' . $JamNow;
                    $formatDateJurnal = date('dmy');
                    $kodeHT = "PU";
                    //QUERY GET LAST NUMBER

                    $this->db->query("SELECT  TOP 1 KD_PIUTANG,right(KD_PIUTANG,3) as urutregx
                    FROM Keuangan.dbo.PIUTANG_PASIEN  WHERE  
                    replace(CONVERT(VARCHAR(11), fd_tgL_piutang, 111), '/','-')=:datenowglobal 
                    AND LEFT(KD_PIUTANG,2)=:kodeHT  
                    ORDER BY KD_PIUTANG DESC");
                    $this->db->bind('kodeHT', $kodeHT);
                    $this->db->bind('datenowglobal', $datenowglobal);
                    $data2 =  $this->db->single();


                    //no urut
                    $no_reg = $data2['urutregx'];
                    $idReg = $no_reg;
                    $idReg++;
                    // GENERATE NO REGISTRASI
                    if (strlen($idReg) == 1) {
                        $noUrutJurnal = "000" . $idReg;
                    } else if (strlen($idReg) == 2) {
                        $noUrutJurnal = "00" . $idReg;
                    } else if (strlen($idReg) == 3) {
                        $noUrutJurnal = "0" . $idReg;
                    } else if (strlen($idReg) == 4) {
                        $noUrutJurnal = $idReg;
                    }
                    $nofinalpiutang = $kodeHT . $formatDateJurnal . '-' . $noUrutJurnal;

                    $this->db->query("INSERT INTO Keuangan.dbo.TA_JURNAL_DTL
                    ( FS_KD_JURNAL,FS_KET_REFF,FN_DEBET,
                    FN_KREDIT,FB_VOID,FS_REK,FS_KD_UNIT,FB_LEDGER,FS_KD_REFF,BP_SOURCE_TRS) values
                    (:NoJurnal,:KeteranganJurnal,:NominalJurnal,
                   '0','0',:koderekening,:kodeUnit,'1',:PassLedgerKode,:nofinalpiutang)");
                    $this->db->bind('NoJurnal', $NoJurnal);
                    $this->db->bind('KeteranganJurnal', $Keterangan);
                    $this->db->bind('NominalJurnal', $NominalJurnal);
                    $this->db->bind('koderekening', $REKENING);
                    $this->db->bind('kodeUnit', $NamaUnit);
                    $this->db->bind('PassLedgerKode', $PassLedgerKode);
                    $this->db->bind('nofinalpiutang', $nofinalpiutang);
                    $this->db->execute();

                    if ($tipepembayaran == "2") {
                        $this->db->query(" INSERT INTO Keuangan.dbo.PIUTANG_PASIEN (KD_PIUTANG,fd_tgL_piutang,NO_TRANSAKSI,kode_jaminan,
                        fn_piutang,fn_sisa,fs_kd_petugas,PAYMENT_NO,TipePiutang,fs_rekening,TipeJaminan)
                        VALUES
                        (:nofinalpiutang,:TglTrs,:NoJurnal,:PassLedgerKode,
                        :NominalJurnal,:NominalJurnal2,:userid,'',:PassTipePasien,:koderekening,
                        'Asuransi')");
                        $this->db->bind('NoJurnal', $NoJurnal);
                        $this->db->bind('TglTrs', $TglTrs);
                        $this->db->bind('koderekening', $REKENING);
                        $this->db->bind('NominalJurnal', $NominalJurnal);
                        $this->db->bind('NominalJurnal2', $NominalJurnal);
                        $this->db->bind('PassLedgerKode', $PassLedgerKode);
                        $this->db->bind('nofinalpiutang', $nofinalpiutang);
                        $this->db->bind('userid', $userid);
                        $this->db->bind('PassTipePasien', $PassTipePasien);
                        $this->db->execute();
                        $this->db->query("INSERT INTO Keuangan.dbo.PIUTANG_PASIEN_2 (kd_piutang,fn_piutang)
                        VALUES
                        (:nofinalpiutang,:NominalJurnal)");
                        $this->db->bind('nofinalpiutang', $nofinalpiutang);
                        $this->db->bind('NominalJurnal', $NominalJurnal);
                        $this->db->execute();
                    } else {

                        $this->db->query("INSERT INTO Keuangan.dbo.PIUTANG_PASIEN (KD_PIUTANG,fd_tgL_piutang,NO_TRANSAKSI,kode_jaminan,
                        fn_piutang,fn_sisa,fs_kd_petugas,PAYMENT_NO,TipePiutang,fs_rekening,TipeJaminan)
                        VALUES
                        (:nofinalpiutang,:TglTrs,:NoJurnal,:PassLedgerKode,
                        :NominalJurnal,:NominalJurnal2,:userid,'',:PassTipePasien,:koderekening,
                        'NonAsuransi')");
                        $this->db->bind('nofinalpiutang', $nofinalpiutang);
                        $this->db->bind('TglTrs', $TglTrs);
                        $this->db->bind('NoJurnal', $NoJurnal);
                        $this->db->bind('PassLedgerKode', $PassLedgerKode);
                        $this->db->bind('NominalJurnal', $NominalJurnal);
                        $this->db->bind('NominalJurnal2', $NominalJurnal);
                        $this->db->bind('userid', $userid);
                        $this->db->bind('PassTipePasien', $PassTipePasien);
                        $this->db->bind('koderekening', $REKENING);
                        $this->db->execute();
                        $this->db->query("INSERT INTO Keuangan.dbo.PIUTANG_PASIEN_2 (kd_piutang,fn_piutang)
                         VALUES
                         (:nofinalpiutang,:NominalJurnal)");
                        $this->db->bind('nofinalpiutang', $nofinalpiutang);
                        $this->db->bind('NominalJurnal', $NominalJurnal);
                        $this->db->execute();
                    }
                } else {
                    //INSERT INTO TA_JURNAL_DTL
                    $this->db->query("INSERT INTO Keuangan.dbo.TA_JURNAL_DTL
                    ( FS_KD_JURNAL,FS_KET_REFF,FN_DEBET,
                    FN_KREDIT,FB_VOID,FS_REK,FS_KD_UNIT,FB_LEDGER,FS_KD_REFF) values
                    (:NoJurnal,:KeteranganJurnal,:NominalJurnal,
                   '0','0',:REKENING,:NamaUnit,'0','')");
                    $this->db->bind('NoJurnal', $NoJurnal);
                    $this->db->bind('KeteranganJurnal', $Keterangan);
                    $this->db->bind('NominalJurnal', $NominalJurnal);
                    $this->db->bind('REKENING', $REKENING);
                    $this->db->bind('NamaUnit', $NamaUnit);
                    $this->db->execute();
                }
            } elseif ($D_K == 'KREDIT') {
                if ($FB_LEDGER_H == '1') {
                    //PENDING
                    $TglTrs = date('Y-m-d', strtotime($tgljurnal));
                    $JamNow = date('H:m:s');
                    $dateTransaksi = $TglTrs . ' ' . $JamNow;
                    $formatDateJurnal = date('dmy');
                    $kodeHT = "HT";

                    $this->db->query("SELECT  TOP 1 KD_HUTANG,right(KD_HUTANG,3) as urutregx
                    FROM Keuangan.dbo.HUTANG_REKANAN  WHERE  
                    SUBSTRING(KD_HUTANG,3,6)=:formatDateJurnal 
                    AND LEFT(KD_HUTANG,2)=:kodeHT 
                    ORDER BY KD_HUTANG DESC");
                    $this->db->bind('formatDateJurnal', $formatDateJurnal);
                    $this->db->bind('kodeHT', $kodeHT);


                    $data2 =  $this->db->single();

                    $no_reg = $data2['urutregx'];
                    $idReg = $no_reg;
                    $idReg++;
                    // GENERATE NO REGISTRASI
                    if (strlen($idReg) == 1) {
                        $noUrutJurnal = "000" . $idReg;
                    } else if (strlen($idReg) == 2) {
                        $noUrutJurnal = "00" . $idReg;
                    } else if (strlen($idReg) == 3) {
                        $noUrutJurnal = "0" . $idReg;
                    } else if (strlen($idReg) == 4) {
                        $noUrutJurnal = $idReg;
                    }
                    $NOHutangFix = $kodeHT . $formatDateJurnal . '-' . $noUrutJurnal;


                    $this->db->query("INSERT INTO Keuangan.dbo.HUTANG_REKANAN (KD_HUTANG,KET2,TGL_HUTANG,KD_REKANAN,
                            NILAI_HUTANG,SISA_HUTANG,PETUGAS,TGL_TEMPO,TGL_FAKTUR,
                            no_faktur,KET3,FS_TGL_VOID,FS_KD_PETUGAS_VOID,KD_ORDER,KET
                            ,NO_PO,NO_REKENING_SUPPLIER,NAMA_BANK_SUPPLIER)
                            VALUES
                            (:NOHutangFix,:NoJurnal,:TglTrs,:PassLedgerKode,
                            :NominalJurnal,:NominalJurnal2,:userid,:PassLedgerTgl,:datenowcreate,
                            :PassKodeFaktur,:koderekening,'1900-01-01','','',:KeteranganJurnal
                            ,:PassLedgerPNoPO,:PassLedgerPNoRekening,:PassLedgerPNanamBank)");

                    $this->db->bind('NOHutangFix', $NOHutangFix);
                    $this->db->bind('NoJurnal', $NoJurnal);
                    $this->db->bind('TglTrs', $TglTrs);
                    $this->db->bind('PassLedgerKode', $PassLedgerKode);
                    $this->db->bind('NominalJurnal', $NominalJurnal);
                    $this->db->bind('NominalJurnal2', $NominalJurnal);
                    $this->db->bind('userid', $userid);
                    $this->db->bind('PassLedgerTgl', $PassLedgerTgl);
                    $this->db->bind('datenowcreate', $datenowcreate);
                    $this->db->bind('PassKodeFaktur', $PassKodeFaktur);
                    $this->db->bind('koderekening', $REKENING);
                    $this->db->bind('KeteranganJurnal', $Keterangan);
                    $this->db->bind('PassLedgerPNoPO', $PassLedgerPNoPO);
                    $this->db->bind('PassLedgerPNoRekening', $PassLedgerPNoRekening);
                    $this->db->bind('PassLedgerPNanamBank', $PassLedgerPNanamBank);
                    $this->db->execute();

                    $this->db->query("INSERT INTO Keuangan.dbo.TA_JURNAL_DTL
                            (FS_KD_JURNAL,FS_KET_REFF,FN_DEBET,
                            FN_KREDIT,FB_VOID,FS_REK,FS_KD_UNIT,FS_KD_REFF,FB_LEDGER,BP_SOURCE_TRS) values
                            (:NoJurnal,:KeteranganJurnal,'0',
                           :NominalJurnal,'0',:koderekening,:kodeUnit,:PassLedgerKode,'1',:NOHutangFix)");
                    $this->db->bind('NoJurnal', $NoJurnal);
                    $this->db->bind('KeteranganJurnal', $Keterangan);
                    $this->db->bind('NominalJurnal', $NominalJurnal);
                    $this->db->bind('koderekening', $REKENING);
                    $this->db->bind('kodeUnit', $NamaUnit);
                    $this->db->bind('PassLedgerKode', $PassLedgerKode);
                    $this->db->bind('NOHutangFix', $NOHutangFix);
                    $this->db->execute();
                } else {
                    //INSERT INTO TA_JURNAL_DTL
                    $this->db->query("INSERT INTO Keuangan.dbo.TA_JURNAL_DTL
                    (FS_KD_JURNAL,FS_KET_REFF,FN_DEBET,
                    FN_KREDIT,FB_VOID,FS_REK,FS_KD_UNIT,FS_KD_REFF,FB_LEDGER) values
                    (:NoJurnal,:KeteranganJurnal,'0',
                    :NominalJurnal,'0',:REKENING,:NamaUnit,'','0')");
                    $this->db->bind('NoJurnal', $NoJurnal);
                    $this->db->bind('KeteranganJurnal', $Keterangan);
                    $this->db->bind('NominalJurnal', $NominalJurnal);
                    $this->db->bind('REKENING', $REKENING);
                    $this->db->bind('NamaUnit', $NamaUnit);
                }
            }


            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi success !' // Set array status dengan success 
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function SaveJurnalUmum($data)
    {
        try {
            $session = SessionManager::getCurrentSession();
            $datenowcreate = Utils::seCurrentDateTime();
            $this->db->transaksi();
            $NoJurnal = $data['Nojurnal'];
            // $NominalJurnal = $data['NominalJurnal'];
            // $NominalJurnal1 = $data['NominalJurnal'];
            $Kredit2 = $data['NominalJurnal'];
            // $Keterangan = $data['Keterangan'];
            $JamNow = date('H:m:s');
            $tgljurnal = $data['tgljurnal'];
            $TglTrs = date('Y-m-d', strtotime($data['tgljurnal']));
            $dateTransaksi = $TglTrs . ' ' . $JamNow;
            $Keterangan = $data['Keterangan'];

            //TOTAL DEBET DI TABEL JURNAL DETAIL
            $this->db->query("SELECT SUM(A.FN_DEBET) as TOTAL_DEBET
			from Keuangan.dbo.TA_JURNAL_DTL A
			INNER JOIN Keuangan.dbo.TM_REKENING B ON A.FS_REK = B.FS_KD_REKENING
			WHERE A.FS_KD_JURNAL=:NoJurnal and a.FB_VOID='0'");
            $this->db->bind('NoJurnal', $NoJurnal);
            $datas =  $this->db->single();
            $NominalJurnal = $datas['TOTAL_DEBET'];

            //TOTAL KREDIT DI TABEL JURNAL DETAIL
            $this->db->query("SELECT SUM(A.FN_KREDIT) as TOTAL_KREDIT
             from Keuangan.dbo.TA_JURNAL_DTL A
             INNER JOIN Keuangan.dbo.TM_REKENING B ON A.FS_REK = B.FS_KD_REKENING
             WHERE A.FS_KD_JURNAL=:NoJurnal and a.FB_VOID='0'");
            $this->db->bind('NoJurnal', $NoJurnal);
            $datas =  $this->db->single();
            $NominalJurnal1 = $datas['TOTAL_KREDIT'];

            if ($NoJurnal == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. Jurnal Invalid !',
                );
                return $callback;
                exit;
            }

            if ($NominalJurnal <> $NominalJurnal1) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'jurnal Transaksi tidak Balance !',
                );
                return $callback;
                exit;
            }

            $this->db->query("SELECT *FROM Keuangan.DBO.HUTANG_REKANAN
                      WHERE replace(CONVERT(VARCHAR(11), FS_TGL_VOID, 111), '/','-')='1900-01-01' 
                      and KET2=:NoJurnal and KD_ORDER <> ''  AND FS_KD_PETUGAS_VOID='' ");
            $this->db->bind('NoJurnal', $NoJurnal);

            //UPDATE TA_JURNAL_HDR
            // $NoJurnal = $data['Nojurnal'];
            $this->db->query("UPDATE Keuangan.dbo.TA_JURNAL_HDR set FB_SELESAI='1',
                        FN_DEBET=:DEBET,FN_KREDIT=:Kredit,
                       FN_JURNAL=:Kredit2,FS_KET=:KeteranganJurnal,FD_TGL_JURNAL=:dateTransaksi
                       where FS_KD_JURNAL=:NoJurnal");

            $this->db->bind('DEBET', $NominalJurnal);
            $this->db->bind('Kredit', $NominalJurnal1);
            $this->db->bind('Kredit2', $NominalJurnal1);
            $this->db->bind('NoJurnal', $NoJurnal);
            $this->db->bind('dateTransaksi', $dateTransaksi);
            $this->db->bind('KeteranganJurnal', $Keterangan);
            // var_dump('ssss');
            // exit;
            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi success !', // Set array status dengan success 
                // 'NoJurnal' => $NoJurnal

            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function getNamaUnit()
    {
        try {
            $this->db->query("SELECT ID,NamaUnit FROM MasterdataSQL.DBO.MstrUnitPerwatan ");
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['NamaUnit'] = $key['NamaUnit'];
                $pasing['ID'] = $key['ID'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getRekeningAllAktif()
    {
        try {
            $this->db->query("SELECT FS_KD_REKENING,FS_NM_REKENING  from Keuangan.dbo.TM_REKENING
                            where AKTIF='1' and GROUP_REK='4' ");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['FS_KD_REKENING'] = $key['FS_KD_REKENING'];
                $pasing['FS_NM_REKENING'] = $key['FS_NM_REKENING'];
                $rows[] = $pasing;
            }
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $rows
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


    public function getDataJurnalUmumTransaksi($data)
    {

        try {
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;

            $this->db->query("SELECT  A.ID, A.FS_KD_JURNAL, A.FS_KET_REFF, A.FN_DEBET, A.FN_KREDIT, A.FS_REK,B.FS_NM_REKENING
			from Keuangan.dbo.TA_JURNAL_DTL A
			INNER JOIN Keuangan.dbo.TM_REKENING B ON A.FS_REK = B.FS_KD_REKENING
			WHERE A.FS_KD_JURNAL=:NoJurnal and a.FB_VOID='0'
    ");
            $this->db->bind('NoJurnal', $data['NoJurnal']);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = "1";
            foreach ($data as $key) {
                $pasing['NO'] = $no++;

                $pasing['ID'] = $key['ID'];
                $pasing['Kode_Rekening'] = $key['FS_REK'];
                $pasing['REKENING'] = $key['FS_NM_REKENING'];
                $pasing['Debet'] = $key['FN_DEBET'];
                $pasing['Kredit'] = $key['FN_KREDIT'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function goShowDataJurnal($data)
    {
        try {
            // var_dump($data);
            $this->db->transaksi();
            $Nojurnal = $data['Nojurnal'];
            $this->db->query("SELECT *,replace(CONVERT(VARCHAR(11), FD_TGL_JURNAL, 111), '/','-') AS tgl_jurnal FROM Keuangan.DBO.TA_JURNAL_HDR Where FS_KD_JURNAL=:Nojurnal");
            $this->db->bind('Nojurnal', $Nojurnal);
            $data =  $this->db->single();

            $pasing['FS_KD_JURNAL'] = $data['FS_KD_JURNAL'];
            $pasing['tgl_jurnal'] = $data['tgl_jurnal'];
            $pasing['FS_KET'] = $data['FS_KET'];
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
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
    public function VoidHdr($data)
    {
        try {
            $session = SessionManager::getCurrentSession();
            $datenowcreate = Utils::seCurrentDateTime();
            $alasanbatal = $data['AlasanBatal'];
            $noregbatal = $data['Nojurnal'];
            $userid = $session->username;
            $this->db->transaksi();
            $this->db->query("UPDATE Keuangan.dbo.TA_JURNAL_HDR set 
            FS_KD_PETUGAS_VOID=:userid ,FD_TGL_VOID=:datenowcreate,
           FS_ALASAN=:alasanbatal
           where FS_KD_JURNAL=:noregbatal");
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('userid', $userid);
            $this->db->bind('alasanbatal', $alasanbatal);
            $this->db->bind('noregbatal', $noregbatal);
            $this->db->execute();
            $this->db->query("UPDATE Keuangan.dbo.TA_JURNAL_DTL set 
            FB_VOID='1', FS_KD_PETUGAS_VOID=:userid,FS_JAM_VOID=:datenowcreate,FS_ALASAN=:alasanbatal
            where FS_KD_JURNAL=:noregbatal");
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('userid', $userid);
            $this->db->bind('alasanbatal', $alasanbatal);
            $this->db->bind('noregbatal', $noregbatal);
            $this->db->execute();
            $this->db->query("UPDATE Keuangan.dbo.HUTANG_REKANAN set 
            FS_KD_PETUGAS_VOID=:userid,FS_TGL_VOID=:datenowcreate 
            where KET2=:noregbatal");
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('userid', $userid);
            $this->db->bind('noregbatal', $noregbatal);
            $this->db->execute();
            $this->db->query("UPDATE Keuangan.dbo.PIUTANG_PASIEN set FB_BATAL='1'  
            where NO_TRANSAKSI=:noregbatal");
            $this->db->bind('noregbatal', $noregbatal);

            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi success !', // Set array status dengan success 

            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function VoidDtl($data)
    {
        try {
            $session = SessionManager::getCurrentSession();
            $datenowcreate = Utils::seCurrentDateTime();
            $alasanbatal = $data['AlasanBatal'];
            $noregbatal = $data['ID'];
            $userid = $session->username;
            $this->db->transaksi();

            $this->db->query("SELECT ID,FS_KD_JURNAL,FS_REK,FS_KD_REFF FROM Keuangan.DBO.TA_JURNAL_DTL 
            WHERE ID=:noregbatal AND FB_LEDGER='1' AND FB_VOID='0'");
            $this->db->bind('noregbatal', $noregbatal);
            $data =  $this->db->single();

            $FS_KD_JURNAL = $data['FS_KD_JURNAL'];
            $FS_KD_REFF = $data['FS_KD_REFF'];

            $this->db->query("SELECT *FROM [Apotik_V1.1SQL].dbo.TA_HUTANG_HDR WHERE 
            FS_KD_DO=:FS_KD_JURNAL and FS_KD_SUPPLIER=:FS_KD_REFF and fn_hutang <> fn_sisa");
            $this->db->bind('FS_KD_JURNAL', $FS_KD_JURNAL);
            $this->db->bind('FS_KD_REFF', $FS_KD_REFF);

            $this->db->execute();

            $this->db->query("UPDATE Keuangan.dbo.TA_JURNAL_DTL set 
            FB_VOID='1', FS_KD_PETUGAS_VOID=:userid,FS_JAM_VOID=:datenowcreate,FS_ALASAN=:alasanbatal
            where ID=:noregbatal");
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('userid', $userid);
            $this->db->bind('alasanbatal', $alasanbatal);
            $this->db->bind('noregbatal', $noregbatal);
            $this->db->execute();

            $this->db->query("UPDATE Keuangan.dbo.HUTANG_REKANAN set 
                     FS_KD_PETUGAS_VOID=:userid,FS_TGL_VOID=:datenowcreate 
                     where KD_HUTANG IN (SELECT BP_SOURCE_TRS 
                      FROM Keuangan.dbo.TA_JURNAL_DTL WHERE ID=:noregbatal)");
            $this->db->bind('userid', $userid);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('noregbatal', $noregbatal);
            $this->db->execute();

            $this->db->query("UPDATE Keuangan.dbo.PIUTANG_PASIEN set FB_BATAL='1'  
            where KD_PIUTANG IN (SELECT BP_SOURCE_TRS 
             FROM Keuangan.dbo.TA_JURNAL_DTL WHERE ID=:noregbatal)");
            $this->db->bind('noregbatal', $noregbatal);

            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi success !', // Set array status dengan success 

            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function ShowDataJurnal($data)
    {
        try {

            $kd_jurnal = $data['kd_jurnal'];

            $this->db->transaksi();
            $this->db->query("SELECT *,replace(CONVERT(VARCHAR(11), FD_TGL_JURNAL, 111), '/','-') AS tgl_jurnal FROM Keuangan.DBO.TA_JURNAL_HDR Where FS_KD_JURNAL=:kd_jurnal");

            $this->db->bind('kd_jurnal', $kd_jurnal);

            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi success !', // Set array status dengan success 

            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function ShowDataJurnalOrderHTG($data)
    {
        try {

            $kd_jurnal = $data['kd_jurnal'];

            $this->db->transaksi();
            $this->db->query("SELECT *FROM Keuangan.DBO.HUTANG_REKANAN
            WHERE replace(CONVERT(VARCHAR(11), FS_TGL_VOID, 111), '/','-')='1900-01-01' 
            and KET2=:kd_jurnal and KD_ORDER <> ''  AND FS_KD_PETUGAS_VOID=''");

            $this->db->bind('kd_jurnal', $kd_jurnal);

            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi success !', // Set array status dengan success 

            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function getRekeningbyID($data)
    {
        try {
            $this->db->transaksi();
            $ID = $data['ID'];
            $this->db->query("SELECT FB_LEDGER_H,FB_LEDGER_P  from Keuangan.dbo.TM_REKENING
            where FS_KD_REKENING=:ID");
            $this->db->bind('ID', $ID);
            $data =  $this->db->single();

            $pasing['FB_LEDGER_H'] = $data['FB_LEDGER_H'];
            $pasing['FB_LEDGER_P'] = $data['FB_LEDGER_P'];
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
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
}
