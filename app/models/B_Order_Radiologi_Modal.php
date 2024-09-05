<?php

class B_Order_Radiologi_Modal
{
    private $db;


    public function __construct()
    {
        $this->db = new Database;
    }
    public function CreateOrderRadiologi($data, $createOrderNumber, $datashowregistrasibyMR)
    {
        try {

            $nourutfixReg = $createOrderNumber['nourutfixReg'];
            $TRIGGER_DTTM = $datashowregistrasibyMR['TRIGGER_DTTM'];
            //var_dump($TRIGGER_DTTM,'sss');exit;
            $Accession_No = $createOrderNumber['Accession_No'];
            $uid = $createOrderNumber['uid'];
            $Date_of_birth_replace = $datashowregistrasibyMR['Date_of_birth_replace'];
            $Gander = $datashowregistrasibyMR['Gander'];
            //$NoRegistrasi = $datashowregistrasibyMR['NoRegistrasi'];
            $NoRegistrasi = $data['Rad_NORegistrasi'];
            
            if ($data['is_approved'] == '1'){
                $paymentstatus = '3';
            }else{
                $paymentstatus = '0';
            }



            $this->db->transaksi();
            //$datenowcreate = Utils::seCurrentDateTime();
            $datenowcreate = Utils::seCurrentDateTime();
            //$datenowcreate = $data['Rad_TglKunjungan'];

            $NoMR = $data['Rad_NoMR'];
            $NoEpisode = $data['Rad_NoEpisode'];

            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $operator =  $session->IDEmployee;

            if ($data['Rad_NoMR'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. MR Kosong !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($data['Rad_NoEpisode'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. Episode Kosong !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($data['Rad_NORegistrasi'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. Registrasi Pasien Kosong !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($data['Rad_NamaPasien'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Nama Pasien Kosong !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($data['Rad_IdDokter'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'ID Dokter Kosong !',
                );
                echo json_encode($callback);
                exit;
            }

            if ($data['Rad_NamaDokter'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Nama Dokter Kosong !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($data['Rad_IdPoli'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Nama Poli Kosong !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($data['Rad_Nama_Poli'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Nama Poli Kosong !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($data['Rad_Kode_Tarif'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode Pemeriksaan Kosong !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($data['Rad_Nama_Tarif'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Nama Pemeriksaan Kosong !',
                );
                echo json_encode($callback);
                exit;
            }

            if ($data['Rad_ModalityCodes'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Modality Code Kosong !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($data['Rad_ActionCodes'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Action Codes Kosong !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($data['Rad_Nilai'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Nilai Pemeriksaan Kosong !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($data['Rad_Daignosa'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Diagnosa Kosong !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($data['Rad_Keterangan_Klinik'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Keterangan Klinik Kosong !',
                );
                echo json_encode($callback);
                exit;
            }
            // if ($data['Rad_iscito'] == "") {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => 'Urgensi Kosong !',
            //     );
            //     echo json_encode($callback);
            //     exit;
            // }
            if ($data['Rad_Acc_Number'] != "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Edit Tidak Diizinkan, Silahkan Batalkan Lalu Order Ulang!',
                );
                echo json_encode($callback);
                exit;
            }
            $nulable = '';
            $nol = "0";


            // WO_RADIOLOGI
            $this->db->query(" INSERT INTO  RadiologiSQL.DBO.WO_RADIOLOGY  
                          (SCHEDULED_DTTM,TRIGGER_DTTM,PROC_PLACER_ORDER_NO,Accession_No,PATIENT_ID,
                          PATIENT_NAME,PATIENT_LOCATION,OrderCode,MRN,
                          EPISODE_NUMBER,
                          NoRegistrasi,Order_Date,REQUEST_BY,SCHEDULED_MODALITY,
                          SCHEDULED_STATION,SCHEDULED_LOCATION,SCHEDULED_PROC_ID,SCHEDULED_PROC_DESC,
                          SCHEDULED_ACTION_CODES,REQUESTED_PROC_ID,REQUESTED_PROC_DESC,Posisition,
                          Side,REQUESTED_PROC_CODES,REQUEST_DEPARTMENT,Diagnosis, 
                          Service_Charge,StatusID,PaymentStatus,
                          Batal,Note,Tarif,DokterRadiologi,cito) VALUES 
                          (:TRIGGER_DTTM,:TRIGGER_DTTM2,:Accession_No2,:Accession_No,:nourutfixReg,
                            :Rad_NamaPasien,:Rad_Patient_Loc,:Rad_Kode_Tarif,:Rad_NoMR,
                            :Rad_NoEpisode,
                            :Rad_NORegistrasi,:datenowcreate,:Rad_IdDokter,:Rad_ModalityCodes,
                            :Rad_ModalityCodes2,:Rad_ModalityCodes3,:Rad_Kode_Tarif3,:Rad_Nama_Tarif,
                            :Rad_ActionCodes,:Rad_Kode_Tarif2,:Rad_Nama_Tarif2,:Rad_Position,
                            :nulable,:Rad_ActionCodes2,:Rad_Department_req,:Rad_Daignosa,
                            :Rad_Nilai2,:nol,:nol2,:nol3,:Rad_Keterangan_Klinik,
                            :Rad_Nilai, :Rad_DokterRadiologi,:Rad_iscito )");
            $this->db->bind('TRIGGER_DTTM', $TRIGGER_DTTM);
            $this->db->bind('TRIGGER_DTTM2', $TRIGGER_DTTM);
            $this->db->bind('Accession_No2', $Accession_No);
            $this->db->bind('Accession_No', $Accession_No);
            $this->db->bind('nourutfixReg', $nourutfixReg);
            $this->db->bind('Rad_NamaPasien', $data['Rad_NamaPasien']);
            $this->db->bind('Rad_Patient_Loc', $data['Rad_Patient_Loc']);
            $this->db->bind('Rad_Kode_Tarif', $data['Rad_Kode_Tarif']);
            $this->db->bind('Rad_NoMR', $data['Rad_NoMR']);
            $this->db->bind('Rad_NoEpisode', $data['Rad_NoEpisode']);
            $this->db->bind('Rad_NORegistrasi', $data['Rad_NORegistrasi']);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('Rad_IdDokter', $data['Rad_IdDokter']);
            $this->db->bind('Rad_ModalityCodes', $data['Rad_ModalityCodes']);
            $this->db->bind('Rad_ModalityCodes2', $data['Rad_ModalityCodes']);
            $this->db->bind('Rad_ModalityCodes3', $data['Rad_ModalityCodes']);
            $this->db->bind('Rad_Kode_Tarif3', $data['Rad_Kode_Tarif']);
            $this->db->bind('Rad_Nama_Tarif', $data['Rad_Nama_Tarif']);
            $this->db->bind('Rad_ActionCodes', $data['Rad_ActionCodes']);
            $this->db->bind('Rad_Kode_Tarif2', $data['Rad_Kode_Tarif']);
            $this->db->bind('Rad_Nama_Tarif2', $data['Rad_Nama_Tarif']);
            $this->db->bind('Rad_Position', $data['Rad_Position']);
            $this->db->bind('nulable', $nulable);
            $this->db->bind('Rad_ActionCodes2', $data['Rad_ActionCodes']);
            $this->db->bind('Rad_Department_req', $data['Rad_Department_req']);
            $this->db->bind('Rad_Daignosa', $data['Rad_Daignosa']);
            $this->db->bind('Rad_Nilai', $data['Rad_Nilai']);
            $this->db->bind('nol', $nol);
            $this->db->bind('nol2', $paymentstatus);
            $this->db->bind('nol3', $nol);
            $this->db->bind('Rad_Keterangan_Klinik', $data['Rad_Keterangan_Klinik']);
            $this->db->bind('Rad_Nilai2', $data['Rad_Nilai']);
            $this->db->bind('Rad_DokterRadiologi', $data['Rad_DokterRadiologi']);
            $this->db->bind('Rad_iscito', $data['Rad_iscito']);
            $this->db->execute();
            $woid = $this->db->GetLastID();


            $isAny = "ANY";
            $ISO_IR = "ISO_IR 100";
            $timx = "120";
            if ($data['is_approved'] == '1'){
                $this->db->query("INSERT INTO  RadiologiSQL.DBO.MWLWL (TRIGGER_DTTM,REPLICA_DTTM,EVENT_TYPE,CHARACTER_SET, 
                            SCHEDULED_AETITLE,SCHEDULED_DTTM,SCHEDULED_MODALITY,SCHEDULED_STATION,
                            SCHEDULED_LOCATION,SCHEDULED_PROC_ID,SCHEDULED_PROC_DESC,SCHEDULED_ACTION_CODES,
                            SCHEDULED_PROC_STATUS,REQUESTED_PROC_ID,REQUESTED_PROC_DESC,REQUESTED_PROC_CODES,  
                            STUDY_INSTANCE_UID,PROC_PLACER_ORDER_NO,REFER_DOCTOR,REQUEST_DEPARTMENT,  
                            PATIENT_LOCATION,PATIENT_NAME,Patient_ID,PATIENT_BIRTH_DATE,
                            PATIENT_SEX,DIAGNOSIS,ACCESSION_NO,OTHER_PATIENT_ID) VALUES 
                            (:TRIGGER_DTTM,:isAny,:nulable,:ISO_IR,
                            :isAny2,:TRIGGER_DTTM2,:Rad_ModalityCodes,:Rad_ModalityCodes2,
                            :Rad_ModalityCodes3,:Rad_Kode_Tarif,:Rad_Nama_Tarif,:Rad_ActionCodes,
                                :timx,:Rad_Kode_Tarif2,:Rad_Nama_Tarif2,:Rad_ActionCodes2, 
                            :uidx,:Accession_No,:Rad_IdDokter,:Rad_Department_req,
                            :Rad_Patient_Loc,:Rad_NamaPasien,:nourutfixReg,:Date_of_birth_replace,
                            :Gander,:Rad_Daignosa ,:Accession_No2,:NoRegistrasi) ");
                $this->db->bind('TRIGGER_DTTM', $TRIGGER_DTTM);
                $this->db->bind('isAny', $isAny);
                $this->db->bind('nulable', $nulable);
                $this->db->bind('ISO_IR', $ISO_IR);
                $this->db->bind('isAny2', $isAny);
                $this->db->bind('TRIGGER_DTTM2', $TRIGGER_DTTM);
                $this->db->bind('Rad_ModalityCodes', $data['Rad_ModalityCodes']);
                $this->db->bind('Rad_ModalityCodes2', $data['Rad_ModalityCodes']);
                $this->db->bind('Rad_ModalityCodes3', $data['Rad_ModalityCodes']);
                $this->db->bind('Rad_Kode_Tarif', $data['Rad_Kode_Tarif']);
                $this->db->bind('Rad_Nama_Tarif', $data['Rad_Nama_Tarif']);
                $this->db->bind('Rad_ActionCodes', $data['Rad_ActionCodes']);
                $this->db->bind('timx', $timx);
                $this->db->bind('Rad_Kode_Tarif2', $data['Rad_Kode_Tarif']);
                $this->db->bind('Rad_Nama_Tarif2', $data['Rad_Nama_Tarif']);
                $this->db->bind('Rad_ActionCodes2', $data['Rad_ActionCodes']);
                $this->db->bind('uidx', $uid);
                $this->db->bind('Accession_No', $Accession_No);
                $this->db->bind('Rad_IdDokter', $data['Rad_IdDokter']);
                $this->db->bind('Rad_Department_req', $data['Rad_Department_req']);
                $this->db->bind('Rad_Patient_Loc', $data['Rad_Patient_Loc']);
                $this->db->bind('Rad_NamaPasien', $data['Rad_NamaPasien']);
                $this->db->bind('nourutfixReg', $nourutfixReg);
                $this->db->bind('Date_of_birth_replace', $Date_of_birth_replace);
                $this->db->bind('Gander', $Gander);
                $this->db->bind('Rad_Daignosa', $data['Rad_Daignosa']);
                $this->db->bind('Accession_No2', $Accession_No);
                $this->db->bind('NoRegistrasi', $NoRegistrasi);
                $this->db->execute(); 
            }

            $pesan = 'Approve Radiologi Baru ' . $data['Rad_NORegistrasi'] . ' / ' . $data['Rad_NoMR'] . ' / ' . $data['Rad_NamaPasien'];
            $this->db->query(" INSERT INTO  MasterdataSQL.dbo.A_NOTIFIKASI
                          (jam_transaksi,tgl_transaksi,unit_tujuan,pesan,
                          sudahbaca,flag_notif_show,reff_no) VALUES 
                          (:jam_transaksi,:tgl_transaksi,:unit_tujuan,:pesan,
                            :sudahbaca,:flag_notif_show,:Accession_No )");
            $this->db->bind('jam_transaksi', date('H:i:s', strtotime($datenowcreate)));
            $this->db->bind('tgl_transaksi', date('d/m/Y', strtotime($datenowcreate)));
            $this->db->bind('unit_tujuan', '9');
            $this->db->bind('pesan', $pesan);
            $this->db->bind('sudahbaca', 'N');
            $this->db->bind('flag_notif_show', '1');
            $this->db->bind('Accession_No', $Accession_No);
            $this->db->execute();




            //Generate no trs billing

            $datenowx = Utils::datenowcreateNotFull();
            $datenow = date('dmy', strtotime($datenowcreate));

            $this->db->query("SELECT  TOP 1 NO_TRS_BILLING,right( REPLACE(NO_TRS_BILLING,'-','0')  ,5) as urut
            FROM Billing_Pasien.dbo.FO_T_BILLING  WHERE  
            replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-')=:datenow2  ORDER BY urut DESC");
            $this->db->bind('datenow2', $datenowx);
            $datax =  $this->db->single();
            //no urut reg
            $nexturut = $datax['urut'];
            $nexturut++;

            $nourutfix = Utils::generateAutoNumber($nexturut);
            $kodeawal = "BIL";
            $notrsbill = $kodeawal . $datenow . $nourutfix;

            //GET Data from tabel visit
            $this->db->query("SELECT  Unit,PatientType,case when PatientType='2' then Asuransi else Perusahaan end as perusahaanid
            FROM PerawatanSQL.dbo.Visit  WHERE  
            NoRegistrasi=:NoRegistrasi");
            $this->db->bind('NoRegistrasi', $NoRegistrasi);
            $datax =  $this->db->single();
            $IdGrupPerawatan = $datax['Unit'];
            $JenisBayar = $datax['PatientType'];
            $perusahaanid = $datax['perusahaanid'];

            // insert ke tabel FO_T_Billing
            $this->db->query("INSERT INTO Billing_Pasien.dbo.FO_T_BILLING
                ([NO_TRS_BILLING],[TGL_BILLING],[PETUGAS_ENTRY],[NO_MR],[NO_EPISODE],[NO_REGISTRASI],[UNIT],[GROUP_JAMINAN],[KODE_JAMINAN],[TOTAL_TARIF],[TOTAL_QTY],[SUBTOTAL],[TOTAL_DISCOUNT],[TOTAL_DISCOUNT_RP],[SUBTOTAL_2],[GRANDTOTAL],[BATAL],[FB_CLOSE_KEUANGAN],[FB_VERIF_JURNAL])
          VALUES
                (:notrsbill,:datenowx,:namauserx,:NoMrfix,:NoEpisode,:nofixReg,:IdGrupPerawatan,:JenisBayar,:perusahaanid,:totaltarif,:totalqty,:subtotal,:totaldiscount,:totaldiscountrp,:subtotal2,:grandtotal,:batal,:closekeuangan,:verifkeuangan)");

            $this->db->bind('notrsbill', $notrsbill);
            $this->db->bind('datenowx', $datenowx);
            $this->db->bind('namauserx', $namauserx);
            $this->db->bind('NoMrfix', $NoMR);
            $this->db->bind('NoEpisode', $NoEpisode);
            $this->db->bind('nofixReg', $NoRegistrasi);
            $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
            $this->db->bind('JenisBayar', $JenisBayar);
            $this->db->bind('perusahaanid', $perusahaanid);
            $this->db->bind('totaltarif', 0);
            $this->db->bind('totalqty', 0);
            $this->db->bind('subtotal', 0);
            $this->db->bind('totaldiscount', 0);
            $this->db->bind('totaldiscountrp', 0);
            $this->db->bind('subtotal2', 0);
            $this->db->bind('grandtotal', 0);
            $this->db->bind('batal', 0);
            $this->db->bind('closekeuangan', 0);
            $this->db->bind('verifkeuangan', 0);
            $this->db->execute();


            // insert ke tabel FO_T_Billing_1
            // Insert Radiologi
            $this->db->query("INSERT INTO  Billing_Pasien.dbo.FO_T_BILLING_1
                (ID_BILL,[NO_TRS_BILLING],[TGL_BILLING] ,[PETUGAS_ENTRY],[NO_MR],[NO_EPISODE],[NO_REGISTRASI],[KODE_TARIF],[UNIT],[GROUP_JAMINAN],[KODE_JAMINAN],
                [NAMA_TARIF],[GROUP_TARIF],[KD_KELAS],[QTY],[NILAI_TARIF],[SUB_TOTAL],[DISC],[DISC_RP],[SUB_TOTAL_2],[GRANDTOTAL],[KODE_REF],[KD_DR],[NM_DR],
                [BATAL],[PETUGAS_BATAL],[GROUP_ENTRI])
                SELECT '$Accession_No','$notrsbill' , '$datenowcreate' as datenow,'$namauserx' as namauserx,'$NoMR' AS NoMR, '$NoEpisode' AS xNoEpisode,'$NoRegistrasi' as NoReg,:Rad_Kode_Tarif as kodetarif,
                UNIT,GROUP_JAMINAN,KODE_JAMINAN, :Rad_Nama_Tarif as namatarif,'Radiologi' as rad, null as kdkelas, 1 as Qty, :Rad_Nilai as nilai, :Rad_Nilai2 as nilai2, 0, 
                0, :Rad_Nilai3 as nilai3, :Rad_Nilai4 as nilai4,'$woid', :Rad_DokterRadiologi, null as namadokter, 0 as batal,null as petugasbatal,'RADIOLOGI'
                FROM Billing_Pasien.dbo.FO_T_BILLING
                WHERE NO_TRS_BILLING=:notrsbill AND Batal='0'");
            $this->db->bind('notrsbill', $notrsbill);
            $this->db->bind('Rad_Kode_Tarif', $data['Rad_Kode_Tarif']);
            $this->db->bind('Rad_Nama_Tarif', $data['Rad_Nama_Tarif']);
            $this->db->bind('Rad_Nilai', $data['Rad_Nilai']);
            $this->db->bind('Rad_Nilai2', $data['Rad_Nilai']);
            $this->db->bind('Rad_Nilai3', $data['Rad_Nilai']);
            $this->db->bind('Rad_Nilai4', $data['Rad_Nilai']);
            $this->db->bind('Rad_DokterRadiologi', $data['Rad_DokterRadiologi']);
            $this->db->execute();

            //Insert ke tabel FO_T_Billing_2
            $this->db->query("INSERT INTO Billing_Pasien.DBO.FO_T_BILLING_2
                SELECT '$Accession_No',A.NO_TRS_BILLING AS NO_TRS_BILLING,A1.KODE_TARIF,B.KD_TIPE_PDP as Kode_komponen,A1.UNIT AS UNIT, A1.GROUP_JAMINAN AS GROUP_JAMINAN, A1.KODE_JAMINAN AS KODE_JAMINAN, 
                A1.NAMA_TARIF AS NAMA_TARIF, 
                A1.GROUP_TARIF AS GROUP_TARIF, A1.KD_KELAS as KELAS,A1.QTY AS QTY, 
                A1.NILAI_TARIF AS NILAI_TARIF  ,
                A1.NILAI_TARIF*A1.QTY  AS SUBTOTAL,
                A1.DISC AS DISC,
                (A1.NILAI_TARIF-((A1.NILAI_TARIF*A1.DISC)/100)) AS DISC_RP,
                ((A1.NILAI_TARIF*A1.QTY)-(((A1.NILAI_TARIF*A1.QTY)*A1.DISC)/100))   SUB_TOTAL_PDP_2,
                (CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN ((((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' THEN ((b.NILAI_FIX*A1.QTY*DISC)/100)*A1.QTY END ) NILAI_DISKON_PDP,
                (CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN (((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY)-(((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' THEN (b.NILAI_FIX*A1.QTY)-((b.NILAI_FIX*A1.QTY*DISC)/100)*A1.QTY END ) as NILAI_PDP,
                A1.KD_DR AS KD_DR, '' NM_DR,b.NILAI_PROSEN,'0' AS BATAL,'' PETUGAS_BATAL, '' AS JAM_BATAL, B.KD_POSTING AS KD_POSTING, b.KD_POSTING_DISC as kd_posting_diskon,'' as idtarifpaket
                 FROM Billing_Pasien.DBO.FO_T_BILLING A
                 inner join Billing_Pasien.dbo.FO_T_BILLING_1 A1
                 ON A.NO_TRS_BILLING = A1.NO_TRS_BILLING
                 INNER JOIN RadiologiSQL.dbo.ProcedureRadiology CC 
                 ON CC.Proc_Code collate SQL_Latin1_General_CP1_CI_AS= A1.KODE_TARIF collate SQL_Latin1_General_CP1_CI_AS
                 INNER JOIN Keuangan.DBO.BO_M_PDP2 B
                ON CC.KD_PDP collate SQL_Latin1_General_CP1_CI_AS = B.KD_PDP collate SQL_Latin1_General_CP1_CI_AS
                INNER JOIN Keuangan.DBO.BO_M_PDP CX
                ON CX.KD_PDP = B.KD_PDP
                 WHERE A1.GROUP_ENTRI='RADIOLOGI' and a.BATAL='0' and A1.BATAL='0' and B.KD_TIPE_PDP='RS01' and a.NO_TRS_BILLING=:notrsbill");
            $this->db->bind('notrsbill', $notrsbill);
            $this->db->execute();


            /*/ insert ke tabel FO_T_Billing_1
                // Insert Radiologi
                $this->db->query("INSERT INTO  Billing_Pasien.dbo.FO_T_BILLING_1
                ([NO_TRS_BILLING],[TGL_BILLING] ,[PETUGAS_ENTRY],[NO_MR],[NO_EPISODE],[NO_REGISTRASI],[KODE_TARIF],[UNIT],[GROUP_JAMINAN],[KODE_JAMINAN],[NAMA_TARIF],[GROUP_TARIF],[KD_KELAS],[QTY],[NILAI_TARIF],[SUB_TOTAL],[DISC],[DISC_RP],[SUB_TOTAL_2],[GRANDTOTAL],[KODE_REF],[KD_DR],[NM_DR],[BATAL],[PETUGAS_BATAL])
                SELECT NO_TRS_BILLING , '$datenowcreate' as datenow,'$namauserx' as namauserx,'$data[Rad_NoMR]' AS NoMR, '$data[Rad_NoEpisode]' AS xNoEpisode,'$data[Rad_NORegistrasi]' as NoReg,d.ID,
                UNIT,c.GROUP_JAMINAN,KODE_JAMINAN, REQUESTED_PROC_DESC,'Radiologi' as rad, null as kdkelas, 1 as Qty, Service_Charge, Service_Charge, 0 as Disc, 0 as disc2, Service_Charge, Service_Charge,a.WOID, a.DokterRadiologi, e.First_Name, 0 as batal,null as petugasbatal
                FROM RadiologiSQL.dbo.WO_RADIOLOGY a
                INNER JOIN Billing_Pasien.dbo.FO_T_BILLING c on a.NOREGISTRASI collate SQL_Latin1_General_CP1_CI_AS=c.NO_REGISTRASI collate SQL_Latin1_General_CP1_CI_AS
                INNER JOIN RadiologiSQL.dbo.ProcedureRadiology d ON a.REQUESTED_PROC_ID = d.Proc_Code
                LEFT JOIN MasterDataSQL.dbo.Doctors e on a.DokterRadiologi=e.ID
                WHERE NOREGISTRASI=:noreg and a.WOID=:woid");
                $this->db->bind('noreg', $data['Rad_NORegistrasi']); 
                $this->db->bind('woid', $woid); 
                $this->db->execute();
                */

            //UPDATE TOTAL KE FO_T_BILLING
            $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_BILLING
                    SET TOTAL_TARIF=B.SUM_NILAI_TARIF,TOTAL_QTY=B.SUM_QTY,SUBTOTAL=B.SUM_SUB_TOTAL,SUBTOTAL_2=B.SUM_SUB_TOTAL_2,GRANDTOTAL=B.SUM_GRANDTOTAL
                    FROM Billing_Pasien.DBO.FO_T_BILLING A 
                    INNER JOIN
                    (
                        SELECT  NO_TRS_BILLING,SUM(NILAI_TARIF) AS SUM_NILAI_TARIF,SUM(QTY) AS SUM_QTY,SUM(SUB_TOTAL) AS SUM_SUB_TOTAL,SUM(SUB_TOTAL_2) AS SUM_SUB_TOTAL_2,
                        SUM(GRANDTOTAL) AS SUM_GRANDTOTAL
                        FROM Billing_Pasien.DBO.FO_T_BILLING_1
                        WHERE NO_REGISTRASI=:noreg and Batal='0'
                        GROUP BY NO_TRS_BILLING
                    ) B
                    ON A.NO_TRS_BILLING = B.NO_TRS_BILLING
                    WHERE A.NO_REGISTRASI=:noreg2 AND A.NO_TRS_BILLING=:notrsbill
                    ");
            $this->db->bind('noreg', $NoRegistrasi);
            $this->db->bind('noreg2', $NoRegistrasi);
            $this->db->bind('notrsbill', $notrsbill);
            $this->db->execute();

            /*/UPDATE TOTAL KE FO_T_BILLING
                $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_BILLING
                SET TOTAL_TARIF=B.SUM_NILAI_TARIF,TOTAL_QTY=B.SUM_QTY,SUBTOTAL=B.SUM_SUB_TOTAL,SUBTOTAL_2=B.SUM_SUB_TOTAL_2,GRANDTOTAL=B.SUM_GRANDTOTAL
                FROM Billing_Pasien.DBO.FO_T_BILLING A 
                INNER JOIN
                (
                    SELECT  NO_TRS_BILLING,SUM(NILAI_TARIF) AS SUM_NILAI_TARIF,SUM(QTY) AS SUM_QTY,SUM(SUB_TOTAL) AS SUM_SUB_TOTAL,SUM(SUB_TOTAL_2) AS SUM_SUB_TOTAL_2,
                    SUM(GRANDTOTAL) AS SUM_GRANDTOTAL
                    FROM Billing_Pasien.DBO.FO_T_BILLING_1
                    WHERE NO_REGISTRASI=:noreg and batal='0'
                    GROUP BY NO_TRS_BILLING
                ) B
                ON A.NO_TRS_BILLING = B.NO_TRS_BILLING
                WHERE A.NO_REGISTRASI=:noreg2");
                $this->db->bind('noreg', $data['Rad_NORegistrasi']);
                $this->db->bind('noreg2', $data['Rad_NORegistrasi']);
                $this->db->execute();
                */

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Order Berhasil Di Buat !'
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
    public function getListOrderRadiologi($data)
    {
        try {
            $searchbox = $data['searchbox'];
            $this->db->query(
                "SELECT c.PatientName, CASE WHEN c.Gander='L' then 'M' ELSE 'F' END AS Gander, 
                                               replace(CONVERT(VARCHAR(11), c.Date_of_birth, 111), '/','-') as Date_of_birth,c.Address,
                                          case when a.PatientType='1' THEN 'PRIBADI' WHEN a.PatientType='2' THEN 'ASURANSI' WHEN a.PatientType='5' THEN 'PERUSAHAAN' END 
                                          AS  PatientType,d.CODEUNIT,d.NamaUnit,a.Doctor_1,e.First_Name, a.NoMR,a.NoEpisode,a.NoRegistrasi,b.WOID,b.OrderCode,
                                       replace(CONVERT(VARCHAR(11), b.ORDER_DATE, 111), '/','-') as ORDER_DATE,b.ACCESSION_NO
                                          from PerawatanSQL.dbo.Visit a
                                          inner join RadiologiSQL.DBO.WO_RADIOLOGY  b
                                          on a.NoRegistrasi = b.NOREGISTRASI
                                          inner join MasterdataSQL.dbo.Admision c
                                          on c.NoMR = a.NoMR
                                          inner join MasterdataSQL.dbo.MstrUnitPerwatan d
                                          on d.ID=a.Unit
                                          inner join MasterdataSQL.dbo.Doctors e
                                          on e.ID=a.Doctor_1
                                          where a.NoRegistrasi=:searchbox and b.Batal='0'
                                          union all
                      SELECT c.PatientName, CASE WHEN c.Gander='L' then 'M' ELSE 'F' END AS Gander, 
                                               replace(CONVERT(VARCHAR(11), c.Date_of_birth, 111), '/','-') as Date_of_birth,c.Address,
                                          case when a.TypePatient='1' THEN 'PRIBADI' WHEN a.TypePatient='2' THEN 'ASURANSI' WHEN a.TypePatient='5' THEN 'PERUSAHAAN' END 
                                          AS  PatientType,'RI' as CodeUnit,a.JenisRawat, a.drPenerima,e.First_Name, a.NoMR,a.NoEpisode,a.NoRegRI,b.WOID,b.OrderCode,
                                       replace(CONVERT(VARCHAR(11), b.ORDER_DATE, 111), '/','-') as ORDER_DATE,b.ACCESSION_NO
                                          from RawatInapSQL.dbo.Inpatient a
                                          inner join RadiologiSQL.DBO.WO_RADIOLOGY  b
                                          on a.NoRegRI = b.NOREGISTRASI
                                          inner join MasterdataSQL.dbo.Admision c
                                          on c.NoMR = a.NoMR
                                          inner join MasterdataSQL.dbo.Doctors e
                                          on e.ID=a.drPenerima
                                          where a.NoRegRI=:searchbox2 and b.Batal='0'"
            );
            $this->db->bind('searchbox',   $searchbox);
            $this->db->bind('searchbox2',   $searchbox);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $row) {
                $pasing['NoMR'] = $row['NoMR'];
                $pasing['PatientName'] = $row['PatientName'];
                $pasing['NoEpisode'] =  $row['NoEpisode'];
                $pasing['NamaUnit'] = $row['NamaUnit'];
                $pasing['ACCESSION_NO'] = $row['ACCESSION_NO'];
                $pasing['First_Name'] = $row['First_Name'];
                $pasing['ID'] = $row['WOID'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    function showregistrasibyMR($dtReg, $datapost)
    {
        date_default_timezone_set('Asia/Jakarta');
        $callback = array(
            'status' => 'success',
            'PatientName' => $dtReg['PatientName'],
            'Gander' => $dtReg['Gander'],
            'Date_of_birth' => $dtReg['Date_of_birth'],
            'Address' => $dtReg['Address'],
            'PatientType' => $dtReg['PatientType'],
            'CODEUNIT' => $dtReg['CODEUNIT'],
            'NamaUnit' => $dtReg['NamaUnit'],
            'Doctor_1' => $dtReg['Doctor_1'],
            'First_Name' => $dtReg['First_Name'],
            'NoMR' => $dtReg['NoMR'],
            'NoEpisode' => $dtReg['NoEpisode'],
            'NoRegistrasi' => $dtReg['NoRegistrasi'],
            'Date_of_birth_replace' => str_replace("-", "", $dtReg['Date_of_birth']),
            'datenowcreate' => Utils::seCurrentDateTime(),
            'TRIGGER_DTTM' => Utils::idtrsByDatetime(),
            //'TRIGGER_DTTM' => date('YmdHis', strtotime($datapost['Rad_TglKunjungan'])) ,
            //'datenowcreate' => date('Y-m-d H:i:s', strtotime($datapost['Rad_TglKunjungan'])) ,
            'DOB' => date('Ymd', strtotime($dtReg['Date_of_birth'])),
        );
        return $callback;
    }
    function createOrderNumber($TRIGGER_DTTM, $NoMR)
    {
        $this->db->query("SELECT max(WOID) as WOID from RadiologiSQL.DBO.WO_RADIOLOGY order by 1 desc");
        $data =  $this->db->single();
        $WOID = $data['WOID'];
        $WOID++;

        $WOIDx = substr($WOID, -2);
        $Accession_No = $TRIGGER_DTTM . $WOIDx;
        $uid = "1.2.410.2000010.82.111." . $Accession_No;
        $nomrx = str_replace("-", "", $NoMR);
        if (strlen($nomrx) == 6) {
            $nourutfixReg = "00" . $nomrx;
        } else if (strlen($nomrx) == 7) {
            $nourutfixReg = "0" . $nomrx;
        } else if (strlen($nomrx) == 8) {
            $nourutfixReg = $nomrx;
        }
        $callback = array(
            'status' => 'success',
            'nourutfixReg' => $nourutfixReg,
            'WOID' => $WOID,
            'Accession_No' => $Accession_No,
            'uid' => $uid,
        );
        return $callback;
    }

    public function getDataTblHeader($data)
    {
        try {
            $this->db->query("SELECT  WOID,SCHEDULED_DTTM,TRIGGER_DTTM,PROC_PLACER_ORDER_NO,Accession_No,PATIENT_ID,
            PATIENT_NAME,PATIENT_LOCATION,OrderCode,MRN,
            EPISODE_NUMBER,
            NoRegistrasi,Order_Date,REQUEST_BY,SCHEDULED_MODALITY,
            SCHEDULED_STATION,SCHEDULED_LOCATION,SCHEDULED_PROC_ID,SCHEDULED_PROC_DESC,
            SCHEDULED_ACTION_CODES,REQUESTED_PROC_ID,REQUESTED_PROC_DESC,Posisition,
            Side,REQUESTED_PROC_CODES,REQUEST_DEPARTMENT,Diagnosis, 
            Service_Charge,StatusID,PaymentStatus,
            Batal,Note,Tarif,DokterRadiologi,First_Name,Ket_hasildiambil,
            replace(CONVERT(VARCHAR(11), ORDER_DATE, 111), '/','-')as ORDER_DATE,cito
            FROM RadiologiSQL.DBO.WO_RADIOLOGY a
            left join MasterdataSQL.dbo.Doctors b on a.DokterRadiologi=b.ID
            WHERE WOID =:woid");
            $this->db->bind('woid',   $data['woid']);
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success', // Set array status dengan success
                'WOID' => $data['WOID'], // Set array status dengan success
                'Accession_No' => $data['Accession_No'], // Set array status dengan success
                'SCHEDULED_PROC_ID' => $data['SCHEDULED_PROC_ID'], // Set array status dengan success
                'SCHEDULED_PROC_DESC' => $data['SCHEDULED_PROC_DESC'], // Set array status dengan success
                'SCHEDULED_MODALITY' => $data['SCHEDULED_MODALITY'], // Set array status dengan success
                'SCHEDULED_ACTION_CODES' => $data['SCHEDULED_ACTION_CODES'], // Set array status dengan success
                'Posisition' => $data['Posisition'], // Set array status dengan successDate_of_birth  
                'Tarif' => $data['Tarif'], // Set array status dengan successDate_of_birth 
                'Diagnosis' => $data['Diagnosis'], // Set array status dengan successDate_of_birth  
                'Note' => $data['Note'], // Set array status dengan successDate_of_birth 
                'ORDER_DATE' => $data['ORDER_DATE'], // Set array status dengan successDate_of_birth 
                'DokterRadiologi' => $data['DokterRadiologi'], // Set array status dengan successDate_of_birth
                'NamaDokterRadiologi' => $data['First_Name'],
                'Ket_hasildiambil' => $data['Ket_hasildiambil'],
                'cito' => $data['cito'],
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function VoidOrderRadiologi($data)
    {
        try {
            $datasatu = "1";
            $this->db->transaksi();
            $accession_no = $data['Rad_Acc_Number'];
            $woid = $data['noregbatalHdr'];
            $noreg = $data['Rad_NORegistrasi'];
            $datenowcreate = Utils::seCurrentDateTime();
            $TRIGGER_DTTM = date('YmdHis');
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $namauserx = $session->name;

            if ($accession_no == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Accession No Invalid, silahkan periksa kembali !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($data['alasanbatalOrder'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Alasan Batal Invalid, silahkan periksa kembali !',
                );
                echo json_encode($callback);
                exit;
            }
            // CEK APAKAH SAMPLE SUDAH adahasil ATAU BELUM
            $sql = "SELECT *from RadiologiSQL.DBO.WO_RADIOLOGY where StatusID ='3' and WOID=:woid";
            $this->db->query($sql);
            $this->db->bind("woid", $woid);
            $this->db->execute();
            $getData = $this->db->resultSet();
            $productCount = count($getData);
            if ($productCount > 0) {
                // Send notif warning
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Order Sudah di Bayar, anda tidak bisa membatalkan !',
                );
                echo json_encode($callback);
                exit;
            }
            //#END CEK------------------

            // CEK APAKAH BILLINGNYA SUDAH DICLOSE ATAU BELUM---------------
            $substr = substr($noreg, 0, 2);
            if ($substr == 'RI') {
                $tsql = "SELECT StatusID from RawatInapSQL.dbo.Inpatient
            where NoRegRI=:noreg and StatusID='4' ";
            } else if ($substr == 'RJ') {
                $tsql = "SELECT [Status ID] from PerawatanSQL.dbo.Visit
            where NoRegistrasi=:noreg and [Status ID] = '4' ";
            } else {
                // Send notif warning
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No Registrasi tidak ditemukan!',
                );
                echo json_encode($callback);
                exit;
            }

            $this->db->query($tsql);
            $this->db->bind("noreg", $noreg);
            $this->db->execute();
            $getData = $this->db->resultSet();
            $productCount = count($getData);
            if ($productCount > 0) {
                // Send notif warning
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Batal Gagal! Billing Sudah Diclose, Mohon Konfirmasi Ke Bagian Billing!',
                );
                echo json_encode($callback);
                exit;
            }
            //#END CEK------------------

            // INSERT TZ LOG
            $keterangan = "Batal Radiologi Dari Web";
            $this->db->query("INSERT INTO  SysLog.dbo.TZ_Log_Button 
                            (idtrs,noregistrasi,nama_biling,petugas_batal,tgl_batal,alasan_batal) VALUES
                            (:woid,:noreg,:keterangan,:namauserx,:datenowcreate,:alasanbatal)");
            $this->db->bind('namauserx', $namauserx);
            $this->db->bind('woid', $woid);
            $this->db->bind('noreg', $noreg);
            $this->db->bind('alasanbatal', $data['alasanbatalOrder']);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('keterangan', $keterangan);
            $this->db->execute();

            // WO_RADIOLOGY
            $this->db->query(" UPDATE  RadiologiSQL.DBO.WO_RADIOLOGY SET Batal = 1, 
            TglBatal =:datenowcreate , PetugasBatal = :namauserx
            WHERE WOID=:woid");
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('namauserx', $namauserx);
            $this->db->bind('woid', $woid);
            $this->db->execute();

            // MWLWL
            $this->db->query("UPDATE RadiologiSQL.DBO.MWLWL 
            SET REPLICA_DTTM = 'ANY', SCHEDULED_PROC_STATUS ='0'
            WHERE  ACCESSION_NO=:accession_no ");
            $this->db->bind('accession_no', $accession_no);
            $this->db->execute();

            // INSERT 
            $this->db->query("INSERT INTO RadiologiSQL.DBO.MWLWL ( TRIGGER_DTTM, REPLICA_DTTM, EVENT_TYPE, CHARACTER_SET, SCHEDULED_AETITLE, SCHEDULED_DTTM, SCHEDULED_MODALITY, SCHEDULED_STATION, SCHEDULED_LOCATION, SCHEDULED_PROC_ID, SCHEDULED_PROC_DESC, SCHEDULED_ACTION_CODES, SCHEDULED_PROC_STATUS, PREMEDICATION, CONTRAST_AGENT, REQUESTED_PROC_ID, REQUESTED_PROC_DESC, REQUESTED_PROC_CODES, REQUESTED_PROC_PRIORITY, REQUESTED_PROC_REASON, REQUESTED_PROC_COMMENTS, STUDY_INSTANCE_UID, PROC_PLACER_ORDER_NO, PROC_FILLER_ORDER_NO, ACCESSION_NO, ATTEND_DOCTOR, PERFORM_DOCTOR, CONSULT_DOCTOR, REQUEST_DOCTOR, REFER_DOCTOR, REQUEST_DEPARTMENT, IMAGING_REQUEST_REASON, IMAGING_REQUEST_COMMENTS, IMAGING_REQUEST_DTTM, ISR_PLACER_ORDER_NO, ISR_FILLER_ORDER_NO, ADMISSION_ID, PATIENT_TRANSPORT, PATIENT_LOCATION, PATIENT_RESIDENCY, PATIENT_NAME, PATIENT_ID, OTHER_PATIENT_NAME, OTHER_PATIENT_ID, PATIENT_BIRTH_DATE, PATIENT_SEX, PATIENT_WEIGHT, PATIENT_SIZE, PATIENT_STATE, CONFIDENTIALITY, PREGNANCY_STATUS, MEDICAL_ALERTS, CONTRAST_ALLERGIES, SPECIAL_NEEDS, SPECIALTY, DIAGNOSIS, ADMIT_DTTM, REGISTER_DTTM, [Match], ORDERCODE, EXPERTISE )
            SELECT '$TRIGGER_DTTM', 'ANY' AS REPLICA_DTTM, EVENT_TYPE, CHARACTER_SET, SCHEDULED_AETITLE, SCHEDULED_DTTM, SCHEDULED_MODALITY, SCHEDULED_STATION, SCHEDULED_LOCATION, SCHEDULED_PROC_ID, SCHEDULED_PROC_DESC, SCHEDULED_ACTION_CODES, '120'AS SCHEDULED_PROC_STATUS, PREMEDICATION, CONTRAST_AGENT, REQUESTED_PROC_ID, REQUESTED_PROC_DESC, REQUESTED_PROC_CODES, REQUESTED_PROC_PRIORITY, REQUESTED_PROC_REASON, REQUESTED_PROC_COMMENTS, STUDY_INSTANCE_UID, PROC_PLACER_ORDER_NO, PROC_FILLER_ORDER_NO, ACCESSION_NO, ATTEND_DOCTOR, PERFORM_DOCTOR, CONSULT_DOCTOR, REQUEST_DOCTOR, REFER_DOCTOR, REQUEST_DEPARTMENT, IMAGING_REQUEST_REASON, IMAGING_REQUEST_COMMENTS, IMAGING_REQUEST_DTTM, ISR_PLACER_ORDER_NO, ISR_FILLER_ORDER_NO, ADMISSION_ID, PATIENT_TRANSPORT, PATIENT_LOCATION, PATIENT_RESIDENCY, PATIENT_NAME, PATIENT_ID, OTHER_PATIENT_NAME, OTHER_PATIENT_ID, PATIENT_BIRTH_DATE, PATIENT_SEX, PATIENT_WEIGHT, PATIENT_SIZE, PATIENT_STATE, CONFIDENTIALITY, PREGNANCY_STATUS, MEDICAL_ALERTS, CONTRAST_ALLERGIES, SPECIAL_NEEDS, SPECIALTY, DIAGNOSIS, ADMIT_DTTM, REGISTER_DTTM, Match, ORDERCODE, EXPERTISE
            FROM RadiologiSQL.DBO.MWLWL
            WHERE ACCESSION_NO=:accession_no");
            $this->db->bind('accession_no', $accession_no);
            $this->db->execute();

            //update fo_t_billing
            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 set 
             PETUGAS_BATAL=:namauserx,BATAL='1',JAM_BATAL=:datenowcreate
             where KODE_REF =:woid");
            $this->db->bind('woid', $woid);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('namauserx', $namauserx);
            $this->db->execute();

            //update fo_t_billing_2
            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_2 set 
           PETUGAS_BATAL=:namauserx,BATAL='1',JAM_BATAL=:datenowcreate
           FROM Billing_Pasien.dbo.FO_T_BILLING_2 c 
           inner join Billing_Pasien.dbo.FO_T_BILLING_1 d on c.NO_TRS_BILLING=d.NO_TRS_BILLING
           where KODE_REF =:woid
           ");
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('namauserx', $namauserx);
            $this->db->bind('woid', $woid);
            $this->db->execute();

            //update fo_t_billing
            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING set 
           PETUGAS_BATAL=:namauserx,BATAL='1',JAM_BATAL=:datenowcreate,FB_VERIF_JURNAL='0'
           FROM Billing_Pasien.dbo.FO_T_BILLING c 
           inner join Billing_Pasien.dbo.FO_T_BILLING_1 d on c.NO_TRS_BILLING=d.NO_TRS_BILLING
           where KODE_REF = :woid
           ");
            $this->db->bind('woid', $woid);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('namauserx', $namauserx);
            $this->db->execute();

            $this->db->commit();
            $this->db->closeCon();
            $callback = array(
                'status' => 'success',
            );

            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
}