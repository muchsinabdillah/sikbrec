<?php

class B_Order_MCU_Model
{
    private $db;


    public function __construct()
    {
        $this->db = new Database;
    }

    public function getPaketMCU()
    {

        try {
                $datenowcreate = Utils::datenowcreateNotFull();
                //var_dump($datenowcreate);
                $query = "SELECT IDMCU,NamaPaket,Tarif from PerawatanSQL.dbo.Tarif_MCU 
                where '$datenowcreate' between AwalMasaBerlaku and AkhirMasaBerlaku and Header='1' and Discontinue='0'
                ORDER BY 1 DESC ";
            //$this->db->bind('datenowcreate', $datenowcreate);
            $this->db->query($query);
            $this->db->execute();
            $data = $this->db->resultSet();
            $rows = array();

            foreach ($data as $key) {
                $pasing['ID'] = $key['IDMCU'];
                $pasing['NamaPaket'] = $key['NamaPaket'];
                $pasing['Tarif'] = $key['Tarif'];
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

    public function getPaketMCUbyNoreg($data)
    {
        try {
                //$this->db->transaksi();
                $noreg = $data['NoRegistrasi'];
                $query = "SELECT * from MedicalRecord.dbo.MR_PaketMCU 
                where NoRegistrasi=:noreg ";

            $this->db->query($query);
            $this->db->bind('noreg', $noreg);
            $this->db->execute();
            $data = $this->db->single();

            $callback = array(
                'message' => "success", // Set array nama 
                'IDPaket' => $data['IDPaket'],
                'NamaPaket' => $data['NamaPaket'],   
                'Tarif' => $data['Harga'], 
                'Lock' => $data['Lock'], 
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

    public function getPaketMCUbyID($data)
    {
        try {
            $this->db->transaksi();
                $IDMCU = $data['IDMCU'];
                $query = "SELECT * FROM PerawatanSQL.dbo.Tarif_MCU  
                where IDMCU=:IDMCU ";
            $this->db->query($query);
            $this->db->bind('IDMCU', $IDMCU);
            $this->db->execute();
            $data = $this->db->single();

            $pasing['IDMCU'] = $data['IDMCU'];
            $pasing['NamaPaket'] = $data['NamaPaket'];
            $pasing['Tarif'] = $data['Tarif'];

            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
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

    public function getDataMCUDetail($data)
    {
        try {
            $namapaket = $data['namapaket'];
            $this->db->query("SELECT * FROM PerawatanSQL.dbo.Tarif_MCU where NamaPaket =:namapaket AND Header='0'
             "); 
             $this->db->bind('namapaket', $namapaket);
                            $data =  $this->db->resultSet();
                            $rows = array();
                            $no = 1;
                            foreach ($data as $row) {
                                $pasing['No'] = $no++;
                                $pasing['Pemeriksaan'] = $row['Pemeriksaan'];
                                $pasing['LokasiPemeriksaan'] = $row['LokasiPemeriksaan'];
                                $pasing['Keterangan'] = $row['Keterangan'];
                                $pasing['IdTes'] = $row['IdTes'];
                                $pasing['Tarif'] = number_format($row['Tarif'],0,",",".");
                                $rows[] = $pasing;
                            }
                            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function goCreateOrderMCU($data)
    {

        // cek apakah show jasa sudah di seting
        $this->db->query("SELECT count(IDMCU) as total 
        from PerawatanSQL.dbo.Tarif_MCU where NamaPaket=:NamaPaket
        and ShowCetakanKonsul=:ShowCetakanKonsul ");
        $this->db->bind('ShowCetakanKonsul', '1');
        $this->db->bind('NamaPaket', $data['namapaket']);
        $datashowcetakan =  $this->db->single(); 
        $totaldataShowCetakan = $datashowcetakan['total']; 
        if ($totaldataShowCetakan < 1) {

            $pasingdata = array(
                'status' => 'warning',
                'errorname' => "Nama Paket Pemeriksaan MCU ini belum diSetingkan Show Cetakan Dokter. Silahkan Konfirmasi ke Bagian IT untuk di Mapingkan !", // Set array nama 
                'idmax_labid' => '' , 
                'namapaketmcutext' =>  '' , 
                'idno_urutantbllablis' =>  '' , 
            ); 
            return $pasingdata;
            exit;
        }


        try {
                 $this->db->transaksi();
                 date_default_timezone_set('Asia/Jakarta');
                 $idpaketmcutext =$data['IDPemeriksaan'];
                 $namapaketmcutext =$data['namapaket'];
                 $tarifpakettext =$data['HargaPaket'];
                 $noMrPaketMCU =$data['nomr'];
                 $noepisodePaketMCU =$data['NoEpisode'];
                 $noregistrasipaketmcu =$data['NoRegistrasi'];
                 $IdDokterMCUx =$data['IDDokter'];//IdDokter
                 $namadokterMCUx =$data['dokternamxe'];
               
                 $NamapasienMCUxx =$data['NamaPasien'];
                 $jeniskelaminxx =$data['JenisKelamin'];//jk
                 $tgllahirxx =$data['DOB'];//dob
                 $alamatxx =$data['Alamat'];//a
                 $jaminanxx =$data['NamaPenjamin']; //IDJPK/IDAUSRANSI
                 $jenisbayarMCUx =$data['PatientType']; //patienttype
                 $idpoliMCUx =$data['IDUnit'];//IDNUIT
                 $namapolimcux =$data['poliklinikname'];
                // $num_rad =$data['num_rad'];
               
               $datenowcreate=$data['TglRegistrasi'];
               $datenowlis= date('dmy', strtotime($datenowcreate));
               

               $idmax_labid = '';
               $idno_urutantbllablis = '';
            //    $xhrFirstName=$_SESSION['xhrFirstName'];
            //    $NoPIN=$_SESSION['xhrNoPIN'];
               
                if($jeniskelaminxx=="L"){
                     $jeniskelaminxxD="M";
                }elseif($jeniskelaminxx=="P"){
                     $jeniskelaminxxD="F";
                }
               
                if($jenisbayarMCUx=="1"){
                     $jenisbayarMCUxxd="PRIBADI";
                }elseif($jenisbayarMCUx=="2"){
                     $jenisbayarMCUxxd="ASURANSI";
                }elseif($jenisbayarMCUx=="5"){
                     $jenisbayarMCUxxd="PERUSAHAAN";
                }

                $session = SessionManager::getCurrentSession();
                $useridx = $session->username;
                $token = $session->token;
                $namauserx = $session->name;

                

                $sqlx = " INSERT INTO MedicalRecord.dbo.MR_PaketMCU (   NoMR, NoEpisode, NoRegistrasi, IDPaket, 
                NamaPaket, UserName,StatusMCU,Harga,Lock) values 
                (:noMrPaketMCU,:noepisodePaketMCU,:noregistrasipaketmcu,:idpaketmcutext,
                :namapaketmcutext,:useridx,'New',:tarifpakettext,'1'
                )";
                $this->db->query($sqlx);
                $this->db->bind('noMrPaketMCU', $noMrPaketMCU);
                $this->db->bind('noepisodePaketMCU', $noepisodePaketMCU);
                $this->db->bind('noregistrasipaketmcu', $noregistrasipaketmcu); 
                $this->db->bind('idpaketmcutext', $idpaketmcutext); 
                $this->db->bind('namapaketmcutext', $namapaketmcutext); 
                $this->db->bind('useridx', $useridx);  
                $this->db->bind('tarifpakettext', $tarifpakettext);  
                $this->db->execute();
                $idmax_mcu = $this->db->GetLastID();
                $TempIDMCu = "MCU".$idmax_mcu;

                $query = " INSERT INTO MedicalRecord.dbo.MR_PemeriksaanMCU ( IDMCU, NamaPaket, Pemeriksaan, LokasiPemeriksaan, 
                Keterangan, NoMR, NoEpisode, NoRegistrasi,IdDokter,NamaDokter,Group_Spesialis,ShowCetakanKonsul,AliasDokter )
                SELECT '$idmax_mcu' as idno_urutantrian, NamaPaket, Pemeriksaan, LokasiPemeriksaan, Keterangan, 
                '$noMrPaketMCU' as noMrPaketMCU ,
                '$noepisodePaketMCU' as noepisodePaketMCU, '$noregistrasipaketmcu' as noregistrasipaketmcu,
                '$IdDokterMCUx' as IdDokterMCUx, '$namadokterMCUx' as namadokterMCUx,Group_Spesialis,ShowCetakanKonsul,AliasDokter
                FROM PerawatanSQL.dbo.Tarif_MCU
                WHERE NamaPaket=:namapaketmcutext";
                $this->db->query($query);
                $this->db->bind('namapaketmcutext', $namapaketmcutext); 
                $this->db->execute();

                $query = "INSERT INTO PerawatanSQL.DBO.[Visit Details] ( NoMR, NoEpisode, 
                NoRegistrasi, NamaUnit, Tanggal,   
                ProductID, NamaProduct, Quantity, Tarif, TotalTarif, KategoriTarif,Dokter,NamaDokter,StatusID ,UserInput)
                SELECT '$noMrPaketMCU' as noMrPaketMCU, '$noepisodePaketMCU' as noepisodePaketMCU, 
                '$noregistrasipaketmcu' as noregistrasipaketmcu, LokasiPemeriksaan, '$datenowcreate' AS Tanggal, IdTes, 
                NamaPaket, '1' AS Qty, Tarif, Tarif AS Total, 'Paket MCU' AS CategoryProduct,
                '$IdDokterMCUx' as IdDokterMCUx, '$namadokterMCUx' as namadokterMCUx,'1' as StatusID,'$useridx' as useridx
                FROM PerawatanSQL.dbo.Tarif_MCU 
                WHERE NamaPaket=:namapaketmcutext AND Header='True'
                ";
                $this->db->query($query);
                $this->db->bind('namapaketmcutext', $namapaketmcutext); 
                $this->db->execute();

                //INSERT LAB-----------------
                $query = "SELECT  max(LabID) as urutantbllab, max(RecID) as urutantbllabRecID from LaboratoriumSQL.dbo.tblLab ";
                $this->db->query($query);
                $this->db->execute();
                $data = $this->db->single();
                $no_urutantbllabRecID = $data['urutantbllabRecID'];  
                $no_urutantbllabRecID++;

                $query = "SELECT  max(NoLab) as urutantbllablis from LaboratoriumSQL.dbo.tblLab WHERE left([NoLAB],6)=:datenowlis ";
                $this->db->query($query);
                $this->db->bind('datenowlis', $datenowlis); 
                $this->db->execute();
                $data = $this->db->single();
                // no urut lab
                $no_urutantbllablis = $data['urutantbllablis'];  
                $substringlis = substr($no_urutantbllablis,6);
                if ($substringlis == null){
                    $substringlis=0;
                }
                $substringlis++;
                if(strlen($substringlis)==1)
                {
                    $nourutfixLis = "000".$substringlis;
                }
                else if(strlen($substringlis)==2)
                {
                    $nourutfixLis = "00".$substringlis;
                }
                else if(strlen($substringlis)==3)
                {
                    $nourutfixLis = "0".$substringlis;
                }else if(strlen($substringlis)==4)
                {
                    $nourutfixLis = $substringlis;
                }
                $idno_urutantbllablis = $datenowlis.$nourutfixLis;

                $query = "  INSERT INTO LaboratoriumSQL.dbo.tblLab (  [OrderCode], RecID, NoLAB, LabDate, Dokter,
                NoMR, NoEpisode , NoRegRI , KelasID, Operator,StatusID, [JenisOrder],JamOrder) VALUES
              ( '$TempIDMCu','$no_urutantbllabRecID','$idno_urutantbllablis','$datenowcreate','$IdDokterMCUx',
                '$noMrPaketMCU','$noepisodePaketMCU','$noregistrasipaketmcu','3','1','3','BIASA','$datenowcreate'
              )";
                $this->db->query($query);
                $this->db->execute();
               //$idmax_labid = $this->db->GetLastID();

               $query = "SELECT max(LabID) as LabID from LaboratoriumSQL.dbo.tblLab order by 1 desc";
                $this->db->query($query);
                $this->db->execute();
                $data = $this->db->single();
                $idmax_labid = $data['LabID']; 

                // $query = "   INSERT INTO LaboratoriumSQL.dbo.tblLabDetail ( LabID, IdTes, Tarif, Rate, TarifKelas,kode_test )
                //                                         SELECT '$idmax_labid' AS LabID, a.IdTes, 0 AS Tarif, 0 AS Rate, 0 AS TarifKelas,b.KodeKelompok
                //                                         FROM PerawatanSQL.dbo.Tarif_MCU a
                //             left join LaboratoriumSQL.dbo.tblGrouping b on a.IdTes=b.IDTes
                //                                         WHERE LokasiPemeriksaan Like '%Laboratorium%' AND NamaPaket=:namapaketmcutext";
                // $this->db->query($query);
                // $this->db->bind('namapaketmcutext', $namapaketmcutext); 
                // $this->db->execute();

                //--LIS
                $query = "INSERT INTO LaboratoriumSQL.dbo.LIS_Order (NoMR,NoEpisode,NoRegistrasi,NoLAB,
                Title,pname,sex,birth_dt,Address,ptype,
                locid,locname,clinician_id,
                clinician_name,request_dt, user_order,asuransi) VALUES
               ( '$noMrPaketMCU','$noepisodePaketMCU','$noregistrasipaketmcu','$idno_urutantbllablis',
                 '','$NamapasienMCUxx','$jeniskelaminxxD','$tgllahirxx','$alamatxx','$jenisbayarMCUxxd',
                 '$idpoliMCUx','$namapolimcux','$IdDokterMCUx', 
                 '$namadokterMCUx' ,'$datenowcreate', '$useridx','$jaminanxx'
               )";
                $this->db->query($query);
                $this->db->execute();

                //--LIS DETAIL
                // $query = "INSERT INTO LaboratoriumSQL.dbo.LIS_Order_detail ( NoMR, NoEpisode, NoLAB, kode_test, nama_test, is_cito ) 
                // SELECT tblLab.NoMR, tblLab.NoEpisode, tblLab.NoLAB, tblGrouping.KodeKelompok, tblGrouping.NamaTes, 
                // 'BIASA' AS iscito
                // FROM LaboratoriumSQL.dbo.tblLabDetail 
                // INNER JOIN LaboratoriumSQL.dbo.tblLab ON tblLabDetail.LabID = tblLab.LabID
                // INNER JOIN LaboratoriumSQL.dbo.tblGrouping ON tblLabDetail.idTes = tblGrouping.IDTes
                // WHERE NoLAB=:idno_urutantbllablis AND tblGrouping.KodeKelompok Is Not Null
                // ORDER BY tblLab.NoLAB
                // ";
                // $this->db->query($query);
                // $this->db->bind('idno_urutantbllablis', $idno_urutantbllablis); 
                // $this->db->execute();

                //#END ORDER LAB----------------------------

                 //FOR RADIOLOGI---------------------------------------
                 

                $query = "SELECT *
                from PerawatanSQL.dbo.Tarif_MCU a
               inner join RadiologiSQL.dbo.ProcedureRadiology b on a.IdTes=b.ID
               where a.LokasiPemeriksaan='RADIOLOGI' and NamaPaket=:namapaketmcutext ";
                $this->db->query($query);
                $this->db->bind('namapaketmcutext', $namapaketmcutext);
                $this->db->execute();
                $datax = $this->db->resultSet();

                foreach ($datax as $key) {
                    $datenowcreateqx = date("His");
                    $TRIGGER_DTTMx = date('Ymd', strtotime($datenowcreate));
                    $TRIGGER_DTTM = $TRIGGER_DTTMx . $datenowcreateqx;
                    $timecreate = date(" H:i:s");
                    $datecreate = date('Y-m-d', strtotime($datenowcreate));
                    $datetimecreate = $datecreate . $timecreate;
                    $DOB = date('Ymd', strtotime($tgllahirxx));

                    $query = "SELECT max(WOID) as WOID from RadiologiSQL.DBO.WO_RADIOLOGY order by 1 desc";
                    $this->db->query($query);
                    $this->db->execute();
                    $data = $this->db->single();
                    $WOID = $data['WOID'];
                    $WOID++;

                    $WOIDx = substr($WOID, -2);
                    $Accession_No = $TRIGGER_DTTM . $WOIDx;
                    $uid = "1.2.410.2000010.82.111." . $Accession_No;
                    $nomrx = str_replace("-", "", $noMrPaketMCU);
                    if (strlen($nomrx) == 6) {
                        $nourutfixReg = "00" . $nomrx;
                    } else if (strlen($nomrx) == 7) {
                        $nourutfixReg = "0" . $nomrx;
                    } else if (strlen($nomrx) == 8) {
                        $nourutfixReg = $nomrx;
                    }

                    $query_wo = "  INSERT INTO  RadiologiSQL.DBO.WO_RADIOLOGY  
                    (SCHEDULED_DTTM, TRIGGER_DTTM,PROC_PLACER_ORDER_NO,Accession_No, PATIENT_ID,
                    PATIENT_NAME,  PATIENT_LOCATION, OrderCode, MRN,EPISODE_NUMBER,NoRegistrasi,Order_Date,REQUEST_BY, SCHEDULED_MODALITY,  SCHEDULED_STATION,  SCHEDULED_LOCATION, SCHEDULED_PROC_ID,  SCHEDULED_PROC_DESC,
                    SCHEDULED_ACTION_CODES, REQUESTED_PROC_ID, REQUESTED_PROC_DESC,Posisition,
                    Side, REQUESTED_PROC_CODES,  REQUEST_DEPARTMENT, Diagnosis, 
                    Service_Charge, StatusID, PaymentStatus,Batal,  Note, Tarif) 
                    SELECT '$TRIGGER_DTTM','$TRIGGER_DTTM','$TRIGGER_DTTM','$Accession_No',
                    '$nourutfixReg','$NamapasienMCUxx','MCU',Proc_Code,'$noMrPaketMCU',
                    '$noepisodePaketMCU','$noregistrasipaketmcu','$datetimecreate','$IdDokterMCUx',Modality_Code,Modality_Code,Modality_Code,Proc_Code,
                    Proc_Description,Proc_ActionCode,Proc_Code,Proc_Description,position,'',
                    Proc_ActionCode,'YARSI',null,0,'0','0','0',null,0
                    from PerawatanSQL.dbo.Tarif_MCU a
                    inner join RadiologiSQL.dbo.ProcedureRadiology b on a.IdTes=b.ID
                    where a.LokasiPemeriksaan='RADIOLOGI' and NamaPaket=:namapaketmcutext and b.ID=:IdTes_rad
                    ";
                    $this->db->query($query_wo);
                    $this->db->bind('namapaketmcutext', $namapaketmcutext);
                    $this->db->bind('IdTes_rad', $key['IdTes']);
                    $this->db->execute();
                    $query_mwlwl = "INSERT INTO  RadiologiSQL.DBO.MWLWL (TRIGGER_DTTM,REPLICA_DTTM,EVENT_TYPE,CHARACTER_SET, 
                    SCHEDULED_AETITLE,SCHEDULED_DTTM,SCHEDULED_MODALITY,SCHEDULED_STATION,
                    SCHEDULED_LOCATION,SCHEDULED_PROC_ID,SCHEDULED_PROC_DESC,SCHEDULED_ACTION_CODES,
                    SCHEDULED_PROC_STATUS,REQUESTED_PROC_ID,REQUESTED_PROC_DESC,REQUESTED_PROC_CODES,  
                    STUDY_INSTANCE_UID,PROC_PLACER_ORDER_NO,REFER_DOCTOR,REQUEST_DEPARTMENT,  
                    PATIENT_LOCATION,PATIENT_NAME,Patient_ID,PATIENT_BIRTH_DATE,
                    PATIENT_SEX,DIAGNOSIS,ACCESSION_NO) 
                    SELECT '$TRIGGER_DTTM','ANY','','ISO_IR 100',
                    'ANY','$TRIGGER_DTTM',Modality_Code,Modality_Code,Modality_Code,Proc_Code,Proc_Description,Proc_ActionCode,'120',Proc_Code,Proc_Description,Proc_ActionCode,'$uid','$Accession_No','$IdDokterMCUx','YARSI','MCU','$NamapasienMCUxx','$nourutfixReg','$DOB','$jeniskelaminxxD','','$Accession_No'
                    from PerawatanSQL.dbo.Tarif_MCU a
                    inner join RadiologiSQL.dbo.ProcedureRadiology b on a.IdTes=b.ID
                    where a.LokasiPemeriksaan='RADIOLOGI' and NamaPaket=:namapaketmcutext and b.ID=:IdTes_rad
                    "; 
                    $this->db->query($query_mwlwl);
                    $this->db->bind('namapaketmcutext', $namapaketmcutext); 
                    $this->db->bind('IdTes_rad', $key['IdTes']); 
                    $this->db->execute();

                    sleep(1);
                }

                //#END FOR RADIOLOGI ------------------
                


                 //FOR UNIT MCU WITH PACSORDER---------------------------------------
                

                 

                $query = "SELECT *
                from PerawatanSQL.dbo.Tarif_MCU a
                inner join PerawatanSQL.dbo.Tarif_RJ_UGD b on a.IdTes=b.ID
                where a.LokasiPemeriksaan='Unit MCU' and NamaPaket=:namapaketmcutext and IdTes is not null
                and b.PacsOrder='1' ";
                $this->db->query($query);
                $this->db->bind('namapaketmcutext', $namapaketmcutext);
                $this->db->execute();
                $datax = $this->db->resultSet();

                foreach ($datax as $key) {
                    $datenowcreateqx=date("His");
                    $TRIGGER_DTTMx = date('Ymd', strtotime($datenowcreate));
                    $TRIGGER_DTTM = $TRIGGER_DTTMx.$datenowcreateqx;
                    $timecreate=date(" H:i:s");
                    $datecreate = date('Y-m-d', strtotime($datenowcreate));
                    $datetimecreate = $datecreate.$timecreate;
                    $DOB = date('Ymd', strtotime($tgllahirxx));

                $query = "SELECT max(WOID) as WOID from RadiologiSQL.DBO.WO_RADIOLOGY order by 1 desc";
                $this->db->query($query);
                $this->db->execute();
                $data = $this->db->single();
                $WOID = $data['WOID'];
                $WOID++;

                $WOIDxx = substr($WOID, -2);
                $Accession_No = $TRIGGER_DTTM . $WOIDxx;
                // $uid="1.2.410.2000010.82.111.".$Accession_No;
                $nomrx = str_replace("-", "", $noMrPaketMCU);
                if (strlen($nomrx) == 6) {
                    $nourutfixReg = "00" . $nomrx;
                } else if (strlen($nomrx) == 7) {
                    $nourutfixReg = "0" . $nomrx;
                } else if (strlen($nomrx) == 8) {
                    $nourutfixReg = $nomrx;
                }

                        $query_wo = " INSERT INTO  RadiologiSQL.DBO.WO_RADIOLOGY  
                        (SCHEDULED_DTTM, TRIGGER_DTTM,PROC_PLACER_ORDER_NO,Accession_No, PATIENT_ID,
                        PATIENT_NAME,  PATIENT_LOCATION, OrderCode, MRN,EPISODE_NUMBER,NoRegistrasi,Order_Date,REQUEST_BY, SCHEDULED_MODALITY,  SCHEDULED_STATION,  SCHEDULED_LOCATION, SCHEDULED_PROC_ID,  SCHEDULED_PROC_DESC,
                        SCHEDULED_ACTION_CODES, REQUESTED_PROC_ID, REQUESTED_PROC_DESC,Posisition,
                        Side, REQUESTED_PROC_CODES,  REQUEST_DEPARTMENT, Diagnosis, 
                        Service_Charge, StatusID, PaymentStatus,Batal,  Note, Tarif) 
             SELECT '$TRIGGER_DTTM','$TRIGGER_DTTM','$TRIGGER_DTTM','$Accession_No',
            '$nourutfixReg','$NamapasienMCUxx','MCU',[Product Code],'$noMrPaketMCU',
            '$noepisodePaketMCU','$noregistrasipaketmcu','$datetimecreate','$IdDokterMCUx',Modality_Code,Modality_Code,Modality_Code,[Product Code],
            [Product Name],Proc_ActionCode,[Product Code],[Product Name],'','',
            Proc_ActionCode,'YARSI',null,0,'0','0','0',null,0
                         from PerawatanSQL.dbo.Tarif_MCU a
                        inner join PerawatanSQL.dbo.Tarif_RJ_UGD b on a.IdTes=b.ID
                        where a.LokasiPemeriksaan='Unit MCU' and NamaPaket=:namapaketmcutext and IdTes is not null
            and b.PacsOrder='1' and b.ID=:IdTes_rad
                        ";
                $this->db->query($query_wo);
                $this->db->bind('namapaketmcutext', $namapaketmcutext);
                $this->db->bind('IdTes_rad', $key['IdTes']);
                $this->db->execute();

                        $query_mwlwl = "INSERT INTO  RadiologiSQL.DBO.MWLWL (TRIGGER_DTTM,REPLICA_DTTM,EVENT_TYPE,CHARACTER_SET, 
                        SCHEDULED_AETITLE,SCHEDULED_DTTM,SCHEDULED_MODALITY,SCHEDULED_STATION,
                        SCHEDULED_LOCATION,SCHEDULED_PROC_ID,SCHEDULED_PROC_DESC,SCHEDULED_ACTION_CODES,
                        SCHEDULED_PROC_STATUS,REQUESTED_PROC_ID,REQUESTED_PROC_DESC,REQUESTED_PROC_CODES,  
                        STUDY_INSTANCE_UID,PROC_PLACER_ORDER_NO,REFER_DOCTOR,REQUEST_DEPARTMENT,  
                        PATIENT_LOCATION,PATIENT_NAME,Patient_ID,PATIENT_BIRTH_DATE,
                        PATIENT_SEX,DIAGNOSIS,ACCESSION_NO) 
                         SELECT '$TRIGGER_DTTM','ANY','','ISO_IR 100',
                         'ANY','$TRIGGER_DTTM',Modality_Code,Modality_Code,Modality_Code,[Product Code],[Product Name],Proc_ActionCode,
             '120',[Product Code],[Product Name],Proc_ActionCode,Proc_Instance_UID+'.'+'$Accession_No','$Accession_No','$IdDokterMCUx',
             'YARSI','MCU',
             '$NamapasienMCUxx','$nourutfixReg','$DOB','$jeniskelaminxxD','','$Accession_No'
                         from PerawatanSQL.dbo.Tarif_MCU a
                        inner join PerawatanSQL.dbo.Tarif_RJ_UGD b on a.IdTes=b.ID
                        where a.LokasiPemeriksaan='Unit MCU' and NamaPaket=:namapaketmcutext and IdTes is not null
            and b.PacsOrder='1' and b.ID=:IdTes_rad
                        ";

                    $this->db->query($query_mwlwl);
                    $this->db->bind('namapaketmcutext', $namapaketmcutext); 
                    $this->db->bind('IdTes_rad', $key['IdTes']); 
                    $this->db->execute();

                    sleep(1);
                }

                //#END UNIT MCU WITH PACSORDER------------------
                $this->db->commit();

               


            $callback = array(
                'message' => "Paket ".$namapaketmcutext." berhasil Diorder !", // Set array nama 
                'NoEpisode' => $noepisodePaketMCU , 
                'namapaketmcutext' =>$namapaketmcutext ,
                'NolisOrder' =>$idno_urutantbllablis , 
            );
            return $callback;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }finally {
            $pasingdata = array(
                'message' => "passing", // Set array nama 
                'idmax_labid' => $idmax_labid , 
                'namapaketmcutext' =>$namapaketmcutext ,
                'idno_urutantbllablis' =>$idno_urutantbllablis , 
            );
            $this->goCreateLabDetail($pasingdata);

        }

    }

     function goCreateLabDetail($data)
    {
        try {
                 //$this->db->transaksi();

                $namapaketmcutext =$data['namapaketmcutext'];
                $idno_urutantbllablis = $data['idno_urutantbllablis'];
                $idmax_labid = $data['idmax_labid'];

                //tbllabdetail
                $query = "   INSERT INTO LaboratoriumSQL.dbo.tblLabDetail ( LabID, IdTes, Tarif, Rate, TarifKelas,kode_test )
                                                        SELECT '$idmax_labid' AS LabID, a.IdTes, 0 AS Tarif, 0 AS Rate, 0 AS TarifKelas,b.KodeKelompok
                                                        FROM PerawatanSQL.dbo.Tarif_MCU a
                            left join LaboratoriumSQL.dbo.tblGrouping b on a.IdTes=b.IDTes
                                                        WHERE LokasiPemeriksaan Like '%Laboratorium%' AND NamaPaket=:namapaketmcutext";
                $this->db->query($query);
                $this->db->bind('namapaketmcutext', $namapaketmcutext); 
                $this->db->execute();

                //--LIS DETAIL
                $query = "INSERT INTO LaboratoriumSQL.dbo.LIS_Order_detail ( NoMR, NoEpisode, NoLAB, kode_test, nama_test, is_cito ) 
                SELECT tblLab.NoMR, tblLab.NoEpisode, tblLab.NoLAB, tblGrouping.KodeKelompok, tblGrouping.NamaTes, 
                'BIASA' AS iscito
                FROM LaboratoriumSQL.dbo.tblLabDetail 
                INNER JOIN LaboratoriumSQL.dbo.tblLab ON tblLabDetail.LabID = tblLab.LabID
                INNER JOIN LaboratoriumSQL.dbo.tblGrouping ON tblLabDetail.idTes = tblGrouping.IDTes
                WHERE NoLAB=:idno_urutantbllablis AND tblGrouping.KodeKelompok Is Not Null
                ORDER BY tblLab.NoLAB
                ";
                $this->db->query($query);
                $this->db->bind('idno_urutantbllablis', $idno_urutantbllablis); 
                $this->db->execute();

                //#END ORDER LAB----------------------------

                //#END UNIT MCU WITH PACSORDER------------------
                $this->db->commit();
                //var_dump($data);

                
            $callback = array(
                'message' => "success", // Set array nama 
                'namapaketmcutext' =>$namapaketmcutext ,
                'NolisOrder' =>$idno_urutantbllablis , 
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

    public function getLisTube($data)
    {
        try {
                $noregistrasi = $data['NoRegistrasi'];
                $query = " SELECT a.*,b.pname,b.sex,b.locid,replace(CONVERT(VARCHAR(11), birth_dt, 111), '/','-') as birth_dt,b.NoMR 
                from LaboratoriumSQL.dbo.LIS_TUBE a
                inner join LaboratoriumSQL.dbo.LIS_Order b on a.NOLAB=b.NoLab
                inner join LaboratoriumSQL.dbo.tblLab d on b.NoLab=d.NoLAB and d.Batal='0'
                where  b.NoRegistrasi=:noregistrasi";
            $this->db->query($query);
            $this->db->bind('noregistrasi', $noregistrasi); 
            $this->db->execute();
            $data = $this->db->resultSet();
            $rows = array();

            foreach ($data as $key) {
                $pasing['NOLAB'] = $key['NOLAB'];
                $pasing['TUBENAME'] = $key['TUBENAME'];
                $pasing['TUBENUMBER'] = $key['TUBENUMBER'];
                $pasing['NOLIS'] = $key['NOLIS'];
                $pasing['TESTCODE'] = $key['TESTCODE'];
                $pasing['pname'] = $key['pname'];
                $pasing['sex'] = $key['sex'];
                $pasing['locid'] = $key['locid'];
                $pasing['birth_dt'] = $key['birth_dt'];
                $pasing['NoMR'] = $key['NoMR'];
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

    public function getPrinterLabelLab($data)
    {
        try {
            $judul=$data['TUBENUMBER'];
            $text = 'MR :'.$data['NoMR'].' | '.$data['birth_dt'];
                  
                    $download_name ='';
                    $txtjudul=$judul.'.txt';
                    $x = '"';
                    $handle =fopen("C:\\\\xampp\\htdocs\\SIKBREC\\public\\".$judul.".txt","w+");
                    
                    $nama = $x.$data['pname'].$x; // nama
                    $Teks = $x.$text.$x; // text
                    $sex = $x.$data['sex'].$x; // sex
                    $TUBENUMBERx = $x.$data['TUBENUMBER'].$x; //ok
                    $locidx = $x.$data['locid'].$x; //ok
                    $TUBENAMEx = $x.$data['TUBENAME'].$x; //ok
                    $TESTCODxE = $x.$data['TESTCODE'].$x; // tes code
                    $NOLISx = $x.$data['NOLIS'].$x;
                    $TUBENUMBER = $x.$data['TUBENAME'].$x;

$isi = "
[
N
OD
q400
Q224,24+0
I8,A,001
D10
A49,3,0,3,1,1,N,".$nama."
A60,27,0,2,1,1,N,".$Teks."
A60,50,0,2,1,1,N,".$sex."
B130,50,0,1,2,8,90,N,".$TUBENUMBERx."
A350,50,5,3,1,1,N,".$TUBENUMBERx.   "
A60,80,0,2,1,1,N,".$locidx."
A60,145,0,2,1,1,N,".$TUBENAMEx.     "
A60,170,0,1,1,1,N," .$TESTCODxE.  "
A230,190,0,2,1,1,N,".$NOLISx.   "
A50,195,0,1,1,1,N,".$TUBENUMBERx."
P1
]
";

							    fwrite($handle, $isi);
							    fclose($handle);
                  $judul2=$judul.'.txt';
                  $filename=$judul.'.txt';
                  $printer = '\\\\172.16.40.134\\BlueprintPrinter';

                   //$output = shell_exec('copy C:\\\\xampp\\htdocs\\SIKBREC\\public\\tmp\\'.$judul2.' /B \\\\172.16.40.134\\Blueprint'); 
                   $cmd = exec('COPY C:\\\\xampp\\htdocs\\SIKBREC\\public\\'.$filename.' /B '.$printer);
                   //var_dump($output);

                   $callback = [
                        'status' => 'success',
                        'message' => $cmd,
                   ];
                   return $callback;

        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

}
