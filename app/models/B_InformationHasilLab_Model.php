<?php
use Aws\Exception\MultipartUploadException;
use Aws\S3\S3Client;

class  B_InformationHasilLab_Model  
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getDataList($data)
    {
        try {
            $tglawal = $data['TglAwal'];
            $tglakhir = $data['TglAkhir'];
            $this->db->query(" SELECT a.NoMR,a.pname,a.request_dt as tglorder,a.birth_dt,a.NoLab,a.NoRegistrasi,a.asuransi,a.Result,
            replace(CONVERT(VARCHAR(11), a.DT_Validasi, 111), '/','-') as DT_Validasix,SUBSTRING(x.nama_test,1, LEN(x.nama_test) - 1) NamaTest,d.[E-mail Address] as email,d.[Mobile Phone] as nohp
                 FROM LaboratoriumSQL.dbo.LIS_ORDER a
                 join LaboratoriumSQL.dbo.tbllab c on a.NoLab=c.NoLab
                 inner join MasterDataSQL.dbo.Admision d on a.NoMR=d.NoMR
                 outer apply (
                 SELECT nama_test + ', ' 
                 FROM LaboratoriumSQL.dbo.LIS_Order_detail
                 WHERE NoLab=a.NoLab and status_ts='0'
                 FOR XML PATH('')
                 ) x (nama_test)
                 where c.Batal='0'  AND replace(CONVERT(VARCHAR(11), a.request_dt, 111), '/','-')  
                 between :TglAwal and :TglAkhir
                 UNION ALL
                 SELECT a.NoMR,a.pname,a.request_dt as tglorder,a.birth_dt,a.NoLab,a.NoRegistrasi,a.asuransi,a.Result,
            replace(CONVERT(VARCHAR(11), a.DT_Validasi, 111), '/','-') as DT_Validasix,SUBSTRING(x.nama_test,1, LEN(x.nama_test) - 1) NamaTest,d.[E-mail Address] as email,d.[Mobile Phone] as nohp
                 FROM LaboratoriumSQL.dbo.LIS_ORDER a
                 join LaboratoriumSQL.dbo.tbllab c on a.NoLab=c.NoLab
                 inner join MasterDataSQL.dbo.Admision_walkin d on a.NoMR=d.NoMR
                 outer apply (
                 SELECT nama_test + ', ' 
                 FROM LaboratoriumSQL.dbo.LIS_Order_detail
                 WHERE NoLab=a.NoLab and status_ts='0'
                 FOR XML PATH('')
                 ) x (nama_test)
                 where c.Batal='0'  AND replace(CONVERT(VARCHAR(11), a.request_dt, 111), '/','-')  
                 between :TglAwal2 and :TglAkhir2
     
             "); 
             $this->db->bind('TglAwal', $tglawal);
             $this->db->bind('TglAkhir', $tglakhir);
             $this->db->bind('TglAwal2', $tglawal);
             $this->db->bind('TglAkhir2', $tglakhir);
                            $data =  $this->db->resultSet();
                            $rows = array();
                            foreach ($data as $row) {
                                $pasing['NoMR'] = $row['NoMR'];
                                $pasing['NamaPasien'] = $row['pname'];
                                $pasing['birth_dt'] = date('d/m/Y', strtotime($row['birth_dt']));
                                $pasing['tglorder'] = date('d/m/Y', strtotime($row['tglorder']));
                                $pasing['NoLab'] = $row['NoLab'];
                                $pasing['NoRegistrasi'] =$row['NoRegistrasi'];
                                $pasing['asuransi'] = $row['asuransi'];
                                $pasing['Result'] = $row['Result'];
                                $pasing['ID'] = $row['NoLab']; 
                                //$pasing['email'] = $row['email']; 
                                $pasing['DT_Validasi'] = $row['DT_Validasix']; 
                                $pasing['email'] = $row['email']; 
                                $pasing['nohp'] = $row['nohp']; 

                                $pasing['NamaTes'] = $row['NamaTest'];   
                                $rows[] = $pasing;
                            }
                            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function PrintHasil($data)
    {
        try { 
            $this->db->query("SELECT LIS_Order.NoMR, LIS_Order.NoEpisode, 
            LIS_Order.NoRegistrasi, LIS_Order.NoLab, LIS_Order.title, LIS_Order.pname, LIS_Order.sex, LIS_Order.birth_dt, LIS_Order.address, 
            LIS_Order.kota, LIS_Order.mobile_nb, LIS_Order.ptype, LIS_Order.locid, LIS_Order.locname, LIS_Order.loctype, LIS_Order.room_nb, LIS_Order.docid, 
            LIS_Order.docname, LIS_Order.clinician_id, LIS_Order.clinician_name, LIS_Order.request_dt, LIS_Order.lantai, LIS_Order.order_st, LIS_Order.is_taken,
            LIS_Order.pdf_send, LIS_Order.diag_klinik, LIS_Order.asuransi, LIS_Order.user_order, LIS_RESULT.REQUESTID, LIS_RESULT.NOINDEX, LIS_RESULT.DEPTH, LIS_RESULT.TESTTYPE, 
            LIS_CHAPTER.IndexChapter, LIS_RESULT.CHAPTER, LIS_RESULT.TESTCODE, LIS_RESULT.TESTNAME, Space(5*([DEPTH])) + [TESTNAME] AS [Nama Tes], LIS_RESULT.FLAG, LIS_RESULT.HASIL,
            LIS_RESULT.KOMENTAR_HASIL, LIS_RESULT.NILAI_RUJUKAN, LIS_RESULT.SATUAN ,pcr
            from LaboratoriumSQL.dbo.LIS_Order
              inner join LaboratoriumSQL.dbo.LIS_RESULT on LIS_Order.NoLab=LIS_RESULT.NOLAB
              LEFT JOIN LaboratoriumSQL.dbo.LIS_CHAPTER ON LIS_RESULT.CHAPTER = LIS_CHAPTER.CHAPTER
              inner join LaboratoriumSQL.dbo.tblLab x on LIS_Order.NoLab=x.NoLAB
              left join LaboratoriumSQL.dbo.tblLabDetail xx on x.LabID=xx.LabID and LIS_RESULT.TESTCODE=xx.kode_test
              left join LaboratoriumSQL.dbo.LIS_Order_detail c on LIS_RESULT.TESTCODE=c.kode_test and LIS_Order.NoLab=c.NoLab
              left join LaboratoriumSQL.dbo.tblGrouping d on c.kode_test=d.KodeKelompok and xx.idTes=d.IDTes
              where LIS_Order.NoLab=:nolab and x.Batal='0' and (xx.Batal='0' or xx.Batal is null) and LIS_Order.status_ts='0' and (c.status_ts='0' or c.status_ts is null)
              ORDER BY LIS_RESULT.NOINDEX");
            $this->db->bind('nolab', $data['notrs']);
            $data =  $this->db->resultSet();
            $rows = array();

            foreach ($data as $key) {

                $pasing['CHAPTER'] = $key['CHAPTER'];
                $pasing['NamaTes'] = $key['Nama Tes'];
                $pasing['FLAG'] = $key['FLAG'];
                $pasing['HASIL'] = $key['HASIL'];
                $pasing['SATUAN'] = $key['SATUAN'];
                $pasing['NILAI_RUJUKAN'] = $key['NILAI_RUJUKAN'];
                $pasing['KOMENTAR_HASIL'] = $key['KOMENTAR_HASIL'];
                $pasing['pcr'] = $key['pcr'];
                $pasing['KOMENTAR_HASIL'] = $key['KOMENTAR_HASIL'];
                $pasing['NoLab'] = $key['NoLab'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintHasilHDR($data)
    {
        try { 
            date_default_timezone_set('Asia/Jakarta');
            $datenow   = new DateTime('today');
            $this->db->query("SELECT DISTINCT a.*,b.NOLIS, replace(CONVERT(VARCHAR(11), a.birth_dt, 111), '/','-') as birth_dtx,c.[Mobile Phone] as nohp,c.Tipe_Idcard,c.ID_Card_number
            FROM LaboratoriumSQL.dbo.LIS_ORDER a
            join LaboratoriumSQL.dbo.LIS_RESULT b on a.NoLab=b.NoLab
            inner join MasterDataSQL.dbo.Admision c on a.NoMR=c.NoMR
      Where a.NoLab=:nolab
      UNION ALL
      SELECT DISTINCT a.*,b.NOLIS, replace(CONVERT(VARCHAR(11), a.birth_dt, 111), '/','-') as birth_dtx,c.[Mobile Phone] as nohp,c.Tipe_Idcard,c.ID_Card_number
            FROM LaboratoriumSQL.dbo.LIS_ORDER a
            join LaboratoriumSQL.dbo.LIS_RESULT b on a.NoLab=b.NoLab
            inner join MasterDataSQL.dbo.Admision_walkin c on a.NoMR=c.NoMR
      Where a.NoLab=:nolab2");
            $this->db->bind('nolab', $data['notrs']);
            $this->db->bind('nolab2', $data['notrs']);
            $data =  $this->db->single();

            $dob   = new DateTime($data['birth_dtx']);
            $age = $dob->diff($datenow)->y;

            if ($data['sex']=='M'){
                $gender = 'Male';
              }else{
                $gender = 'Female';
              }

             //Identitas Pasien
            $pasing['pname'] = $data['pname'];
            $pasing['NoLab'] = $data['NoLab'];
            $pasing['NOLIS'] = $data['NOLIS'];
            $pasing['NoMR'] = $data['NoMR'];
            $pasing['birth_dt'] = date('d/m/Y', strtotime($data['birth_dt']));
            $pasing['clinician_name'] = $data['clinician_name'];
            $pasing['locname'] = $data['locname'];
            $pasing['gender'] = $gender;
            $pasing['age'] = $age;
            $pasing['asuransi'] = $data['asuransi'];
            $pasing['address'] = $data['address'];
            $pasing['request_dt'] = date('d/m/Y', strtotime($data['request_dt']));
            $pasing['nohp'] = $data['nohp'];
            $pasing['Tipe_Idcard'] = $data['Tipe_Idcard'];
            $pasing['ID_Card_number'] = $data['ID_Card_number'];

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintHasilFooter($data)
    {
        try { 
            $this->db->query("SELECT DISTINCT Validate_by FROM LaboratoriumSQL.dbo.LIS_RESULT WHERE NoLab=:nolab");
            $this->db->bind('nolab', $data['notrs']);
            $data =  $this->db->single();

            $pasing['Validate_by'] = $data['Validate_by'];

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintHasilTglSampling($data)
    {
        try { 
            $this->db->query("SELECT DISTINCT b.NOLIS,b.DT_Terima,b.DT_Validasi,a.pname,a.NoLab FROM LaboratoriumSQL.dbo.LIS_ORDER a
            join LaboratoriumSQL.dbo.LIS_RESULT b on a.NoLab=b.NoLab
      Where a.NoLab=:nolab");
            $this->db->bind('nolab', $data['notrs']);
            $data =  $this->db->single();

            $pasing['DT_Terima'] = date('d/m/Y', strtotime($data['DT_Terima']));
            $pasing['DT_Terima_jam'] = date('H:i:s', strtotime($data['DT_Terima']));
            $pasing['DT_Validasi'] = date('d/m/Y', strtotime($data['DT_Validasi']));
            $pasing['DT_Validasi_jam'] = date('H:i:s', strtotime($data['DT_Validasi']));

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function SendmailHasilLab($data)
    {
        try { 
            $this->db->query("SELECT [E-Mail Address] as email FROM MasterDataSQL.dbo.Admision a
            join LaboratoriumSQL.dbo.tbllab b on a.NoMR=b.NoMR
                Where b.NoLab=:nolab
                UNION ALL
                SELECT [E-Mail Address] as email FROM MasterDataSQL.dbo.Admision_walkin a
            join LaboratoriumSQL.dbo.tbllab b on a.NoMR=b.NoMR
                Where b.NoLab=:nolab2");
            $this->db->bind('nolab', $data['notrs']);
            $this->db->bind('nolab2', $data['notrs']);
            $data =  $this->db->single();

            $pasing['email'] = $data['email'];

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function InsertLog($data)
    {
        try {
            $this->db->transaksi();
            $datenowcreate= Utils::seCurrentDateTime();

            $nolab = $data['nolab'];
            $status = $data['status'];
            $email = $data['email'];

            $session = SessionManager::getCurrentSession();
            $namauserx = $session->name;


            // INSERT TZ_LOG
            $sqlx = " INSERT INTO Syslog.dbo.TZ_Log_EmailSent ( 
                NoLAB,EmailSent,UserKirim,TanggalKirim,Status) VALUES
                (:nolab,:emailsent,:userkirim,:tglkirim,:status)";
                $this->db->query($sqlx);
                $this->db->bind('nolab', $nolab);
                $this->db->bind('emailsent', $email);
                $this->db->bind('userkirim', $namauserx); 
                $this->db->bind('tglkirim', $datenowcreate); 
                $this->db->bind('status', $status); 
                $this->db->execute();

            $this->db->commit();
            $callback = array(
                'status' => 'success', 
               // 'message' => $return_message, 
            );
            return $callback;

        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'errorname' => $e
            );
            return $callback;
        }
    }

    public function InsertLogWhatsapp($data)
    {
        try {
            $this->db->transaksi();
            $datenowcreate= Utils::seCurrentDateTime();

            $nolab = $data['nolab'];
            $status = $data['status'];
            $nohp = Utils::hp($data['nohp']);

            $session = SessionManager::getCurrentSession();
            $namauserx = $session->name;


            // INSERT TZ_LOG
            $sqlx = " INSERT INTO Syslog.dbo.TZ_Log_WhatsappSent ( 
                NoLAB,NoHP,UserKirim,TanggalKirim,Status) VALUES
                (:nolab,:nohp,:userkirim,:tglkirim,:status)";
                $this->db->query($sqlx);
                $this->db->bind('nolab', $nolab);
                $this->db->bind('nohp', $nohp);
                $this->db->bind('userkirim', $namauserx); 
                $this->db->bind('tglkirim', $datenowcreate); 
                $this->db->bind('status', $status); 
                $this->db->execute();

            $this->db->commit();
            $callback = array(
                'status' => 'success', 
               // 'message' => $return_message, 
            );
            return $callback;

        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'errorname' => $e
            );
            return $callback;
        }
    }
    public function InsertLogWhatsappKritis($nolab, $status, $nohp)
    {
        try {
            $this->db->transaksi();
            $datenowcreate= Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $namauserx = $session->name;


            // INSERT TZ_LOG
            $sqlx = " INSERT INTO Syslog.dbo.TZ_Log_WhatsappSent ( 
                NoLAB,NoHP,UserKirim,TanggalKirim,Status) VALUES
                (:nolab,:nohp,:userkirim,:tglkirim,:status)";
                $this->db->query($sqlx);
                $this->db->bind('nolab', $nolab);
                $this->db->bind('nohp', $nohp);
                $this->db->bind('userkirim', $namauserx); 
                $this->db->bind('tglkirim', $datenowcreate); 
                $this->db->bind('status', $status); 
                $this->db->execute();

            $this->db->commit();
            $callback = array(
                'status' => 'success', 
               // 'message' => $return_message, 
            );
            return $callback;

        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'errorname' => $e
            );
            return $callback;
        }
    }
    public function CekPernahKirim($data)
    {
        try {
            $this->db->transaksi();
             $nolab = $data['nolab'];

             if($data['viakirim'] == 'EMAIL'){
                $table = 'SysLog.dbo.TZ_Log_EmailSent';
             }else{
                $table = 'SysLog.dbo.TZ_Log_WhatsappSent';
             }


            //Cek Jika sudah pernah kirim atau belum atas no lab tersebut
            $this->db->query("SELECT TOP 1 *
            FROM $table
            WHERE NoLAB=:nolab AND Status=:status");
            $this->db->bind('nolab', $nolab);
            $this->db->bind('status', 'TERKIRIM');
            $this->db->execute();
            $dtCekPernah =  $this->db->rowCount();
            // var_dump($dtCekPernah);exit;
            if($dtCekPernah){
                $callback = array(
                    'status' => "warningx",
                    'errorname' => "HASIL SUDAH PERNAH DIKIRIM VIA " . $data['viakirim'] . ", KIRIM HASIL KEMBALI ?"
                );
                return $callback; 
                exit;
            }else{
                $callback = array(
                    'status' => "success", // Set array nama
                );
                return $callback;
            } 
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }

    }

    public function SendWaHasilLab($token,$fileName)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.wappin.id/v1/message/do-send-hsm-with-media',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('media'=> new CurlFile($_SERVER["DOCUMENT_ROOT"].'SIKBREC/public/'.$fileName, 'application/pdf', $fileName),'client_id' => '0410','project_id' => '2805','type' => 'hasil_lab_rsyarsi','recipient_number' => '6281318985367','language_code' => 'id','params' => '{"1":"Name","2":"80001810
                08192601"}
                '),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token
            ),
        ));
        $response = curl_exec($curl);
        $JsonData = json_decode($response, TRUE);
        return $JsonData;
    }

    public function SendWaHasilLabKritis($data)
    {
        try {
            $this->db->transaksi();
            $nolab = $data['nolab'];
            //$nolab = "2105190014";
            $gettoken = $this->getTokenWapin();
            //Cek Jika sudah pernah kirim atau belum atas no lab tersebut
            $this->db->query("select 
            'Nama: '+l.pname+'|No. Medrec :' + l.NoMR  + ' |Waktu Sampling: '
            + replace(CONVERT(VARCHAR(11),  r.DT_Order, 111), '/','-')   +
            + ' ' + 
            + convert(char(8), r.DT_Order, 108) +
            ' |Unit Pelayanan :'+l.locname+' |Hasil Kritis '+r.TESTNAME+' : '+r.HASIL		 as hasil
            from LaboratoriumSQL.dbo.LIS_RESULT r
            left join LaboratoriumSQL.dbo.LIS_Order l on r.NOLAB=l.NoLab --collate Latin1_General_CI_AS 
            where r.FLAG in ('LL','HH') and r.NOLAB=:nolab");
            $this->db->bind('nolab', $nolab); 
            $this->db->execute();
            $dtCekPernah =  $this->db->rowCount();
            $datakriis = $this->db->single();
            $hasil = $datakriis['hasil']; 

            if ($dtCekPernah > 0) {
                $callback = array(
                    'status' => "warningx",
                    'errorname' => "Data Hasil Nilai Kritis Tidak Ada."
                );
                return $callback;
                exit;
            } else {
                 // cek nama dokter order
                    $this->db->query("SELECT top 1 b.First_Name as NamaDokter, b.Mob_Phone,a.NoRegRI
                    FROM LaboratoriumSQL.DBO.tblLab a
                    inner join MasterdataSQL.dbo.Doctors b
                    on a.Dokter = b.ID
                    WHERE NoLAB=:nolab");
                    $this->db->bind('nolab', $nolab); 
                    $this->db->execute(); 
                    $datadokterKritis = $this->db->single();
                    $NamaDokter = $datadokterKritis['NamaDokter']; 
                    $NoRegRI = $datadokterKritis['NoRegRI']; 
                    $Mob_Phone = Utils::hp($datadokterKritis['Mob_Phone']);  
                    $kirimdpjp = $this->SendWaHasilLabKritisDokterGP($gettoken,$Mob_Phone,$hasil,$NamaDokter); 
                    if($kirimdpjp['message'] == "Success"){
                        $this->InsertLogWhatsappKritis($nolab, $kirimdpjp['message'], $Mob_Phone );
                        // cari dokter dpjp
                        $this->db->query("SELECT  top 1 b.First_Name as NamaDokter, b.Mob_Phone
                        from RawatInapSQL.dbo.Inpatient a
                        inner join MasterdataSQL.dbo.Doctors b
                        on a.drPenerima = b.ID
                        where NoRegRI=:NoRegRI
                        UNION ALL
                        SELECT top 1 b.First_Name as NamaDokter, b.Mob_Phone
                        from PerawatanSQL.dbo.Visit a
                        inner join MasterDataSQL.dbo.Doctors b on a.Doctor_1=b.ID
                        where NoRegistrasi=:NoRegRI2
                        ");
                        $this->db->bind('NoRegRI', $NoRegRI); 
                        $this->db->bind('NoRegRI2', $NoRegRI); 
                        $this->db->execute(); 
                        $datadpjp = $this->db->single();
                        $NamaDokter_DPJP = $datadpjp['NamaDokter']; 
                        $Mob_Phone_DPJP = Utils::hp($datadpjp['Mob_Phone']); 
                        $kirimdpjp2 = $this->SendWaHasilLabKritisDokterGP($gettoken,$Mob_Phone_DPJP,$hasil,$NamaDokter_DPJP); 
                        $this->InsertLogWhatsappKritis($nolab, $kirimdpjp['message'], $Mob_Phone );
                        if($kirimdpjp2['message'] == "Success"){
                            $callback = array(
                                'status' => "success",
                                'errorname' => "Data Berhasil dikirim ke Whatsapp Dokter." 
                            );
                            return $callback;
                        }else{
                            $callback = array(
                                'status' => "warning",
                                'errorname' => "Data Gagal dikirim ke Whatsapp dokter yang Order DPJP : " . $NamaDokter_DPJP . " , No. Handphone : " . $Mob_Phone_DPJP
                            );
                            return $callback;
                        }
                    }else{
                        $callback = array(
                            'status' => "warning",
                            'errorname' => "Data Gagal dikirim ke Whatsapp dokter yang Order : " .  $NamaDokter . " , No. Handphone : " . $Mob_Phone
                        );
                        return $callback;
                    } 
            }
            
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                    'status' => "warning", // Set array nama  
                    'message' => $e
                );
            return $callback;
        }
    }
    public function SendWaHasilLabKritisDokterGP($token,$noHp,$hasil,$dokter)
    {
            
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.wappin.id/v1/message/do-send-hsm',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "client_id": "0410",
                "project_id": "2805",
                "type": "nilai_kritis_baru",
                "recipient_number": "'. $noHp . '",
                "language_code": "id",
                "params": {
                    "1": "' . $dokter . '",
                    "2": "' . $hasil . '" 
                } 
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token
            ),
        ));
        $response = curl_exec($curl);
        $JsonData = json_decode($response, TRUE);
        curl_close($curl); 
        return $JsonData;
    }
    public function getTokenWapin(){ 
        $curl = curl_init();
        $wapinx = base64_encode("0410:59bae544f683769ea73951ac0d483ea6e60f65e5");
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.wappin.id/v1/token/get',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Basic ' . $wapinx
            ),
        ));
        $response = curl_exec($curl);
        $JsonData = json_decode($response, TRUE);
        curl_close($curl); 
        return $JsonData['data']['access_token'];
}

public function getDataListbyNoMR($data)
    {
        try {
            $no_MR = $data['no_MR'];
            $this->db->query(" SELECT a.NoMR,a.pname,a.request_dt as tglorder,a.birth_dt,a.NoLab,a.NoRegistrasi,a.asuransi,a.Result,
            replace(CONVERT(VARCHAR(11), a.DT_Validasi, 111), '/','-') as DT_Validasix,SUBSTRING(x.nama_test,1, LEN(x.nama_test) - 1) NamaTest,d.[E-mail Address] as email,d.[Mobile Phone] as nohp
                 FROM LaboratoriumSQL.dbo.LIS_ORDER a
                 join LaboratoriumSQL.dbo.tbllab c on a.NoLab=c.NoLab
                 inner join MasterDataSQL.dbo.Admision d on a.NoMR=d.NoMR
                 outer apply (
                 SELECT nama_test + ', ' 
                 FROM LaboratoriumSQL.dbo.LIS_Order_detail
                 WHERE NoLab=a.NoLab and status_ts='0'
                 FOR XML PATH('')
                 ) x (nama_test)
                 where c.Batal='0'  AND a.NoMR=:no_MR
                 UNION ALL
                 SELECT a.NoMR,a.pname,a.request_dt as tglorder,a.birth_dt,a.NoLab,a.NoRegistrasi,a.asuransi,a.Result,
            replace(CONVERT(VARCHAR(11), a.DT_Validasi, 111), '/','-') as DT_Validasix,SUBSTRING(x.nama_test,1, LEN(x.nama_test) - 1) NamaTest,d.[E-mail Address] as email,d.[Mobile Phone] as nohp
                 FROM LaboratoriumSQL.dbo.LIS_ORDER a
                 join LaboratoriumSQL.dbo.tbllab c on a.NoLab=c.NoLab
                 inner join MasterDataSQL.dbo.Admision_walkin d on a.NoMR=d.NoMR
                 outer apply (
                 SELECT nama_test + ', ' 
                 FROM LaboratoriumSQL.dbo.LIS_Order_detail
                 WHERE NoLab=a.NoLab and status_ts='0'
                 FOR XML PATH('')
                 ) x (nama_test)
                 where c.Batal='0'  AND a.NoMR=:no_MR2
     
             "); 
             $this->db->bind('no_MR', $no_MR);
             $this->db->bind('no_MR2', $no_MR);
                            $data =  $this->db->resultSet();
                            $rows = array();
                            foreach ($data as $row) {
                                $pasing['NoMR'] = $row['NoMR'];
                                $pasing['NamaPasien'] = $row['pname'];
                                $pasing['birth_dt'] = date('d/m/Y', strtotime($row['birth_dt']));
                                $pasing['tglorder'] = date('d/m/Y', strtotime($row['tglorder']));
                                $pasing['NoLab'] = $row['NoLab'];
                                $pasing['NoRegistrasi'] =$row['NoRegistrasi'];
                                $pasing['asuransi'] = $row['asuransi'];
                                $pasing['Result'] = $row['Result'];
                                $pasing['ID'] = $row['NoLab']; 
                                //$pasing['email'] = $row['email']; 
                                $pasing['DT_Validasi'] = $row['DT_Validasix']; 
                                $pasing['email'] = $row['email']; 
                                $pasing['nohp'] = $row['nohp']; 

                                $pasing['NamaTes'] = $row['NamaTest'];   
                                $rows[] = $pasing;
                            }
                            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function uploadAWS($data)
    {
        $notrs = $data['notrs'];

            $bytes = random_bytes(20);
            $nama_file_baru  =     $notrs . bin2hex($bytes) . "-" . date("YmdHis");
            $nama_file = $data['GrupTransaksi'].'-'.$notrs.'.pdf';

                /// AWS
                // Create an S3Client
                $s3Client = new S3Client([
                    'version' => 'latest',
                    'region'  => 'ap-southeast-1',
                    'http'    => ['verify' => false],
                    'credentials' => [
                        'key'    => 'AKIAYV2M6ERJGUKK4QWQ',
                        'secret' => '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'
                    ]
                ]);
                //$file_name = __DIR__ . '/../../public' . '/tmp/' . $nama_file;
                $file_name = $_SERVER['DOCUMENT_ROOT'].'SIKBREC/public/tmp/'.$nama_file;
                $source =   $file_name;
                $awsImages = '';
                $handle = fopen($source, 'r');
                try {
                    $bucket = 'rsuyarsibucket';
                    $key = basename($nama_file_baru);
                    $result = $s3Client->putObject([
                        'Bucket' => $bucket,
                        //'Key'    => 'digitalfiles/akadijaroh/' . $key,
                        'Key'    => 'digitalfiles/laboratorium/' . $key,
                        'Body'   => $handle,
                        'ACL'    => 'public-read', // make file 'public', 
                    ]);
                    $awsImages = $result->get('ObjectURL');

                    //close filenya
                    fclose($handle);
                    //hapus filenya 
                    unlink($_SERVER["DOCUMENT_ROOT"].'SIKBREC/public/tmp/'.$nama_file);

                    return $this->SaveFile($data, $awsImages);
                } catch (MultipartUploadException $e) {

                    return $e->getMessage();
                }
    }

    public function SaveFile($data, $awsImages)
    {
        try {
            $this->db->transaksi();
            $session = SessionManager::getCurrentSession();
            $userlogin = $session->IDEmployee;
            $usernamelogin = $session->name;

            $datenowcreate= Utils::seCurrentDateTime();
            $uuid = $data['uuid4'];
            $DocumentType = $data['GrupTransaksi'];
            $NoRegistrasi = $data['NoRegistrasi'];
            $notrs = $data['notrs'];

              $query = "UPDATE a
              SET Active='0' 
              FROM Billing_Pasien.dbo.TDocumentMasters a
              inner join Billing_Pasien.dbo.TDocumentLaboratoriumResults b on a.Uuid=b.DocTransactionID
              WHERE NoTrs_Reff=:id --and NoRegistrasi=:NoRegistrasi
              ";
                $this->db->query($query);
                $this->db->bind('id', $notrs);
                $this->db->execute();

            $query = "INSERT INTO Billing_Pasien.dbo.TDocumentMasters (Uuid,DateCreate,UserCreate,DocumentType,AwsUrlDocuments)
                Values
            (:uuid,:datenowcreate,:userlogin,:DocumentType,:AWS_URL)";
                $this->db->query($query);
                $this->db->bind('uuid', $uuid);
                $this->db->bind('datenowcreate', $datenowcreate);
                $this->db->bind('userlogin', $userlogin);
                $this->db->bind('DocumentType', $DocumentType);
                $this->db->bind('AWS_URL', $awsImages);
                $this->db->execute();

                $query = "UPDATE Billing_Pasien.dbo.TDocumentLaboratoriumResults SET ActiveDocument='0' WHERE NoTrs_Reff=:id";
                $this->db->query($query);
                $this->db->bind('id', $notrs);
                $this->db->execute();

                    $query = "INSERT INTO  Billing_Pasien.dbo.TDocumentLaboratoriumResults (DocTransactionID,NoTrs_Reff,NoRegistrasi,AwsUrlDocuments,TglCreate,UserCreate)
                Values
            (:uuid,:id,:NoRegistrasi,:AWS_URL,:datenowcreate,:userlogin)";
                $this->db->query($query);
                $this->db->bind('uuid', $uuid);
                $this->db->bind('id', $notrs);
                $this->db->bind('NoRegistrasi', $NoRegistrasi);
                $this->db->bind('AWS_URL', $awsImages);
                $this->db->bind('datenowcreate', $datenowcreate);
                $this->db->bind('userlogin', $userlogin);
                $this->db->execute();
                $getID = $this->db->GetLastID();

           
            $this->db->Commit();
            $callback = array(
                'status' => 200,
                'message' => 'Generate Upload Data Succesfully.',
                'data' =>  $getID,
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => 'warning',
                'message' => $e,
            );
            return $callback;
        }
    }

    public function getAWSURL($data)
    {
        try {
                $query = "SELECT AwsUrlDocuments,ID
                FROM Billing_Pasien.dbo.TDocumentLaboratoriumResults
                where ID=:notrs and ActiveDocument='1'";
            $this->db->query($query);
            $this->db->bind('notrs', $data['param_id']);
            $datas =  $this->db->single();

            $pasing['AwsUrlDocuments'] = $datas['AwsUrlDocuments'];
            $pasing['ID'] = $datas['ID'];

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
