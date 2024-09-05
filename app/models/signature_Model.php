<?php

use Ramsey\Uuid\Uuid;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;
date_default_timezone_set('Asia/Jakarta');

class signature_Model
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    // public function Save($data)
    // {
         
    //     $result     = array();
    //     $imagedata  = base64_decode($data['img_data']);
    //     $filename   = md5(date("dmYhisA"));
    //     $bytes = random_bytes(20);

    //     // $uuid = UniversalIdentifier::uniqueImage($filename);
    //     $uuid = bin2hex($bytes) . "-" . date("YmdHis");
    //     // $file_name  =  'images/signature/' . bin2hex($bytes) . "-" . date("YmdHis") . ".jpg";
    //     $file_name  =  'images/signature/' . bin2hex($bytes) . "-" . date("YmdHis") . ".png";
    //     file_put_contents($file_name, $imagedata);
    //     $result['status']     = 1;
    //     $result['file_name']  = $file_name;

    //     /// AWS
    //     // Create an S3Client
    //     $s3Client = new S3Client([
    //         'version' => 'latest',
    //         'region'  => 'ap-southeast-1',
    //          'http'    => ['verify' => false],
    //         'credentials' => [
    //             'key'    => 'key',
    //             'secret' => 'secret'
    //         ]
    //     ]); 
    //     $source =   $file_name;
    //     $awsImages = '';
    //      try {
    //         $bucket = 'rsuyarsibucket'; 
    //         $key = basename($file_name);
    //         $result = $s3Client->putObject([
    //             'Bucket' => $bucket,
    //             'Key'    => $key,
    //             'Body'   => fopen($source, 'r'), 
    //             'ACL'    => 'public-read', // make file 'public', 
    //         ]);
    //         $awsImages = $result->get('ObjectURL');
    //         return $this->SaveTTD($data, $uuid, $file_name, $awsImages);
    //      } catch (MultipartUploadException $e) {
            
    //         return $e->getMessage();
    //      }
    //     return $this->SaveTTD($data, $uuid, $file_name, $awsImages);
    // }
    // simpan tanda tangan ke database
    // public function SaveTTD($data, $uuid, $path, $awsImages)
    // {
    //     // var_dump($data);
    //     $query = "INSERT INTO Billing_Pasien.[dbo].[T_SIGNATURE]
           
    //        ([NAMA_PARAM_1]
    //        ,[IMAGE_PATH]
    //        ,[GROUP_TRANSAKSI]
    //        ,[NO_TRANSAKSI]
    //        ,[TGL_CREATE]
    //        ,[USER_CREATE]
    //        ,[NO_REGISTRASI]
    //        ,[AWS_URL])
    //  VALUES
    //        (
    //     :namaparam
    //     ,:imagepath
    //     ,:gruptransaksi
    //     ,:nomortransaksi
    //     ,:tglcreate
    //     ,:usercreate
    //     ,:noregistrasi
    //     ,:AWS_URL
    //     )
    //     "; 
    //     try {
    //         $this->db->transaksi();
    //         if ($this->ceknotransaksi($data)) {
    //             return $this->response(201, 'tanda tangan transaksi ini sudah pernah dibuat');;
    //         }
    //         $this->db->query($query); 
    //         $this->db->bind('namaparam', $data['namaparam']);
    //         $this->db->bind('imagepath', $path);
    //         $this->db->bind('gruptransaksi', 'BPJS');
    //         $this->db->bind('nomortransaksi', $data['nomortransaksi']);
    //         $this->db->bind('tglcreate', date("Y-m-d H:i:s"));
    //         $this->db->bind('usercreate', $data['usercreate']);
    //         $this->db->bind('noregistrasi', $data['noregistrasi']);
    //         $this->db->bind('AWS_URL', $awsImages);
    //         $this->db->execute();
    //         $this->db->Commit();
    //         return $this->response(200, 'Tanda Tangan Berhasi di simpan');
    //     } catch (PDOException $e) {
    //         $this->db->rollback();
    //         return $this->response(400, $e);
    //     }
    // }
    public function SaveTTDDigital($data, $uuid, $path, $awsImages,$awsImages2,$group)
    {
        // var_dump($data);
        $query = "INSERT INTO Billing_Pasien.[dbo].[T_SIGNATURE]
           
           (
            [NAMA_PARAM_1]
           ,[IMAGE_PATH]
           ,[NAMA_PARAM_2]
           ,[IMAGE_PATH2]
           ,[GROUP_TRANSAKSI]
           ,[NO_TRANSAKSI]
           ,[TGL_CREATE]
           ,[USER_CREATE]
           ,[NO_REGISTRASI]
           ,[REFF_ID] )
     VALUES
           (
        :namaparam
        ,:imagepath
        ,:namaparam2
        ,:imagepath2
        ,:gruptransaksi
        ,:nomortransaksi
        ,:tglcreate
        ,:usercreate
        ,:noregistrasi
        ,:reffid
        )
        "; 
        try {
            $this->db->transaksi();
            // if ($this->ceknotransaksi($data)) {
            //     return $this->response(201, 'tanda tangan transaksi ini sudah pernah dibuat');;
            // }
            $this->db->query($query); 
            $this->db->bind('namaparam', $data['usercreate']);
            $this->db->bind('imagepath', null);
            $this->db->bind('namaparam2', $data['namaparam1']);
            $this->db->bind('imagepath2', $awsImages2);
            $this->db->bind('gruptransaksi', $group);
            $this->db->bind('nomortransaksi', $data['nomortransaksi']);
            $this->db->bind('tglcreate', date("Y-m-d H:i:s"));
            $this->db->bind('usercreate', $data['usercreate']);
            $this->db->bind('noregistrasi', $data['noregistrasi']);
            $this->db->bind('reffid', $data['reffid']);

            $this->db->execute();
            $this->db->Commit();
            //return $this->response(200, 'Tanda Tangan Berhasi di simpan');
            $callback = [
                'status' => 200,
                'message' => 'Tanda Tangan Berhasi di simpan',
                'ttd_aws' => $awsImages2
            ];
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            return $this->response(400, $e);
        }
    }
    public function ceknotransaksi($data)
    {
        $query = "SELECT * from Billing_Pasien.dbo.T_SIGNATURE where NO_TRANSAKSI=:notransaksi AND NO_REGISTRASI=:NO_REGISTRASI";
        $this->db->query($query);
        $this->db->bind('notransaksi', $data['nomortransaksi']);
        $this->db->bind('NO_REGISTRASI', $data['noregistrasi']);
        $this->db->execute();
        return $this->db->single();
    }

    public function response($status, $message)
    {
        $callback = [
            'status' => $status,
            'message' => $message
        ];
        return $callback;
    }
    // double ttd
    // public function DoubleSignature($data)
    // {
    //     // var_dump($data);
    //     $query = "INSERT INTO Billing_Pasien.[dbo].[T_SIGNATURE]
    //             ([UID]
    //             ,[NAMA_PARAM_1]
    //             ,[IMAGE_PATH]
    //             ,[NAMA_PARAM_2]
    //             ,[IMAGE_PATH2]
    //             ,[GROUP_TRANSAKSI]
    //             ,[NO_TRANSAKSI]
    //             ,[TGL_CREATE]
    //             ,[USER_CREATE])
    //       VALUES
    //             (
    //              :UUID
    //          ,:namaparam
    //          ,:imagepath
    //          ,:namaparam2
    //          ,:imagepath2
    //          ,:gruptransaksi
    //          ,:nomortransaksi
    //          ,:tglcreate
    //          ,:usercreate
    //          )
    //          ";

    //     try {
    //         $this->db->transaksi();
    //         if ($this->ceknotransaksi($data)) {
    //             return $this->response(201, 'tanda tangan transaksi ini sudah pernah dibuat');;
    //         }
    //         $this->db->query($query);
    //         $this->db->bind('UUID', $data['uuid1']);
    //         $this->db->bind('namaparam', $data['usercreate']);
    //         $this->db->bind('imagepath', $data['path1']);
    //         $this->db->bind('namaparam2', $data['namaparam2']);
    //         $this->db->bind('imagepath2', $data['path2']);
    //         $this->db->bind('gruptransaksi', 'AKADIJAROH');
    //         $this->db->bind('nomortransaksi', $data['nomortransaksi']);
    //         $this->db->bind('tglcreate', date("Y-m-d H:i:s"));
    //         $this->db->bind('usercreate', $data['usercreate']);
    //         $this->db->execute();
    //         $this->db->Commit();
    //         return $this->response(200, 'Tanda Tangan Berhasi di simpan');
    //     } catch (PDOException $e) {
    //         $this->db->rollback();
    //         return $this->response(400, $e);
    //     }
    // }
    public function AkadIjaroh($data,$ttdpasien_aws)
    {
        try {
            $this->db->transaksi();
            $session = SessionManager::getCurrentSession();
            $userlogin = $session->IDEmployee;
            $datenowcreate= Utils::seCurrentDateTime();
            $uuid = Utils::uuid4str();
            $DocumentType = 'AKAD_IJAROH';

            $query = "UPDATE a
              SET Active='0' 
              FROM Billing_Pasien.dbo.TDocumentMasters a
              inner join Billing_Pasien.dbo.TDocumentIjarohAgreements b on a.Uuid=b.DocTransactionID
              WHERE NoRegistrasi=:NoRegistrasi and a.DocumentType=:DocumentType
              ";
                $this->db->query($query);
                $this->db->bind('NoRegistrasi', $data['noregistrasi']); 
                $this->db->bind('DocumentType', $DocumentType); 
                $this->db->execute();

            $query = "INSERT INTO Billing_Pasien.dbo.TDocumentMasters (Uuid,DateCreate,UserCreate,DocumentType,NamaTTD1,NamaTTD2)
                Values
            (:uuid,:datenowcreate,:userlogin,:DocumentType,:namaparam,:namaparam2)";
                $this->db->query($query);
                $this->db->bind('uuid', $uuid);
                $this->db->bind('datenowcreate', $datenowcreate);
                $this->db->bind('userlogin', $userlogin);
                $this->db->bind('DocumentType', $DocumentType);
                $this->db->bind('namaparam', $data['usercreate']);
                $this->db->bind('namaparam2', $data['namaparam1']);
                $this->db->execute();

            $query = "UPDATE Billing_Pasien.dbo.TDocumentIjarohAgreements SET ActiveDocument='0' WHERE NoRegistrasi=:NoRegistrasi
            ";
            $this->db->query($query);
            $this->db->bind('NoRegistrasi', $data['noregistrasi']); 
            $this->db->execute();

            $query = "INSERT INTO Billing_Pasien.[dbo].[TDocumentIjarohAgreements]
                (   DocTransactionID,
                    NoEpisode,
                    NoRegistrasi,
                    TglCreate,
                    Petugas,
                    Divisi,
                    NamaPenanggungJawab,
                    AlamatPenanggungJawab,
                    NoKtp,
                    Pekerjaan,
                    NoHandphone,
                    NamaPasien,
                    NoRM,
                    JenisKelamin,
                    TangalLahir,
                    LokasiPasien,
                    NIKPasien,
                    AwsUrlDocuments,
                    NamaJenisPenanngungJawab,
                    PetugasTTD_ID,
                    TTD_PasienWali,
                    EmailSend,
                    NoHPSend
                    )
          VALUES
                (
                    :uuid,
                    :NoEpisode,
                    :NoRegistrasi,
                    :TglCreate,
                    :Petugas,
                    :Divisi,
                    :NamaPenanggungJawab,
                    :AlamatPenanggungJawab,
                    :NoKtp,
                    :Pekerjaan,
                    :NoHandphone,
                    :NamaPasien,
                    :NoRM,
                    :JenisKelamin,
                    :TangalLahir,
                    :LokasiPasien,
                    :NIKPasien,
                    :AwsUrlDocuments,
                    :NamaJenisPenanngungJawab,
                    :idpetugas_ext,
                    :ttdpasien_aws,
                    :email_send,
                    :nohp_send
             )
             ";
            $this->db->query($query); 
            $this->db->bind('uuid', $uuid); 
            $this->db->bind('NoRegistrasi', $data['noregistrasi']); 
            $this->db->bind('NoEpisode', $data['NoEpisode']);
            $this->db->bind('TglCreate', date("Y-m-d H:i:s"));
            $this->db->bind('Petugas', $data['namapetugas_ext']);
            $this->db->bind('Divisi', "Staff Admission & Billing");
            $this->db->bind('NamaPenanggungJawab', $data['namaparam1']);
            $this->db->bind('AlamatPenanggungJawab', $data['pnj_alamat']);
            $this->db->bind('NoKtp', $data['pnj_noKTP']);
            $this->db->bind('Pekerjaan', $data['pnj_pekerjaan']);
            $this->db->bind('NoHandphone', $data['pnj_noHP']);
            $this->db->bind('NamaPasien', $data['namapasien']);
            $this->db->bind('NoRM', $data['norm']);
            $this->db->bind('JenisKelamin', $data['jeniskelasmin']);
            $this->db->bind('TangalLahir', $data['tgllahir']);
            $this->db->bind('LokasiPasien', $data['kamar']);
            $this->db->bind('NIKPasien', $data['nikpasien']);
            $this->db->bind('AwsUrlDocuments', null);
            $this->db->bind('NamaJenisPenanngungJawab', $data['pnj_JenisOrang']);
            $this->db->bind('idpetugas_ext', $data['idpetugas_ext']);
            $this->db->bind('nohp_send', $data['nohp_send']); 
            $this->db->bind('email_send', $data['email_send']); 
            $this->db->bind('ttdpasien_aws', $ttdpasien_aws); 
            $this->db->execute();

            $this->db->Commit();
            $getID = $this->db->GetLastID();
            //return $this->response(200, 'Tanda Tangan Berhasi di simpan');
            $callback = [
                'status' => 200,
                'message' => 'Tanda Tangan Berhasi di simpan',
                'data' => $getID,
            ];
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            return $this->response(400, $e);
        }
    }
    public function uploadToAwsSign($data)
    {
        $s3Client = new S3Client([
            'version' => 'latest',
            'region'  => 'ap-southeast-1',
            'http'    => ['verify' => false],
            'credentials' => [
                'key'    => 'AKIAYV2M6ERJGUKK4QWQ',
                'secret' => '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'
            ]
        ]);
            // $filename1 = __DIR__ . '/../../public' . '/images/signature/' . $data['uuid1']. '.png';
            // $source1 =   $filename1;
            // $awsImages = '';
            // $handle = fopen($source1, 'r');

            $awsImages = $data['path1'];
            $filename1 = null;

            $filename2 = __DIR__ . '/../../public' . '/images/signature/' . $data['uuid2']. '.png';
            $source2 =   $filename2;
            $awsImages2 = '';
            $handle2 = fopen($source2, 'r');

         try {
                // // TTD 1
                //     $bucket = 'rsuyarsibucket';
                //     $key = basename($filename1);
                //     $result = $s3Client->putObject([
                //         'Bucket' => $bucket,
                //         'Key'    => 'digitalfiles/dgitalSignPatient/' . $key,
                //         'Body'   => $handle,
                //         'ACL'    => 'public-read', // make file 'public', 
                //     ]);
                //     $awsImages = $result->get('ObjectURL');
                //     fclose($handle);
                    

                    // TTD 2
                    $bucket2 = 'rsuyarsibucket';
                    $key2 = basename($filename2);
                    $result2 = $s3Client->putObject([
                        'Bucket' => $bucket2,
                        'Key'    => 'digitalfiles/dgitalSignPatient/' . $key2,
                        'Body'   => $handle2,
                        'ACL'    => 'public-read', // make file 'public', 
                    ]);
                    $awsImages2 = $result2->get('ObjectURL');
                    fclose($handle2);
                    unlink($_SERVER["DOCUMENT_ROOT"].'SIKBREC/public/images/signature/'.$data['uuid2']. '.png');
                    // unlink($_SERVER["DOCUMENT_ROOT"].'SIKBREC/public/images/signature/'.$data['uuid1']. '.png');
                    return $this->SaveTTDDigital($data, $data['uuid2'], $filename1, $awsImages,$awsImages2,"AKAD IJAROH");

         } catch (MultipartUploadException $e) {
            return $e->getMessage();
         } 
    }
    
    public function Path($data)
    {
        $result     = array();
        $imagedata  = base64_decode($data['img_data']);
        $filename   = md5(date("dmYhisA"));
        $bytes = random_bytes(20);

        // $uuid = UniversalIdentifier::uniqueImage($filename);
        $uuid = bin2hex($bytes) . "-" . date("YmdHis");
        $file_name  = $_SERVER['DOCUMENT_ROOT'] . 'SIKBREC/public/images/signature/' . $uuid . ".png";
        file_put_contents($file_name, $imagedata);
        $result['status']     = 1;
        $result['file_name']  = $file_name;
        // $result['nama'] = $data['nama'];
        return $calback = [
            'uuid' => $uuid,
            'path' => $file_name
        ];
    }
    public function CountCetak($data)
    {
        $notrs  = $data['notrs'];
        $signAlasanCetak  = $data['signAlasanCetak'];
        $jeniscetakan  = $data['jeniscetakan'];
        $noreg  = $data['noreg'];
        if ($notrs == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'NO. SEP kosong !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($signAlasanCetak == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Alasan Cetak kosong !',
            );
            echo json_encode($callback);
            exit;
        }
        $datenow = Utils::seCurrentDateTime();
         if (!isset($data['is_login'])){
            $namauserx = 'Administrator';

         }else{
            $session = SessionManager::getCurrentSession(); 
            $namauserx = $session->name;
         }
        
        // var_dump($data);
        

        try {
            $this->db->transaksi();
            if($jeniscetakan == "SEP"){
                if ($noreg == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'No. Registrasi kosong !',
                    );
                    echo json_encode($callback);
                    exit;
                }
                $fixjeniscetakan = $jeniscetakan;
                $this->db->query("UPDATE PerawatanSQL.DBO.BPJS_T_SEP  SET 
                CETAKAN_KE=CETAKAN_KE+1,TGL_LAST_CETAK=:datenow
                WHERE NO_SEP=:NoSep and NO_REGISTRASI=:NO_REGISTRASI");
                $this->db->bind('NoSep', $notrs);
                $this->db->bind('datenow', $datenow);
                $this->db->bind('NO_REGISTRASI', $noreg);
                $this->db->execute();
            }else if($jeniscetakan == "SPRI"){
                if (isset($data['isbayi'])){
                    $isbayi = $data['isbayi'];
                }else{
                    $isbayi = '';
                }

                if($isbayi == 'BY_SPRI'){

                }else{
                    if ($noreg == "") {
                        $callback = array(
                            'status' => 'warning',
                            'errorname' => 'No. Registrasi kosong !',
                        );
                        echo json_encode($callback);
                        exit;
                    }
                }
                
                $fixjeniscetakan = $jeniscetakan;
                $this->db->query("UPDATE PerawatanSQL.DBO.BPJS_T_SPRI  SET 
                CETAKAN_KE=CETAKAN_KE+1,TGL_LAST_CETAK=:datenow
                WHERE NO_SPRI=:NoSep and  NO_REGISTRASI=:NO_REGISTRASI");
                $this->db->bind('NoSep', $notrs);
                $this->db->bind('datenow', $datenow);
                $this->db->bind('NO_REGISTRASI', $noreg);
                $this->db->execute();
            } else if ($jeniscetakan == "RENCANAKONTROL") {
                $fixjeniscetakan = $jeniscetakan;
                $this->db->query("UPDATE PerawatanSQL.DBO.BPJS_T_SPRI  SET 
                CETAKAN_KE=CETAKAN_KE+1,TGL_LAST_CETAK=:datenow
                WHERE NO_SPRI=:NoSep ");
                $this->db->bind('NoSep', $notrs);
                $this->db->bind('datenow', $datenow);
                $this->db->execute();
            } else if ($jeniscetakan == "RUJUKAN") {
                $fixjeniscetakan = $jeniscetakan;
                $this->db->query("UPDATE PerawatanSQL.DBO.BPJS_T_Rujukan  SET 
                CETAKAN_KE=CETAKAN_KE+1,TGL_LAST_CETAK=:datenow
                WHERE idRujukan=:NoSep     ");
                $this->db->bind('NoSep', $notrs);
                $this->db->bind('datenow', $datenow); 
                $this->db->execute();
            }
            $query = "INSERT INTO SysLog.[dbo].TZ_LOG_PRINT
           (NO_TRS_REFF
           ,ALASAN_CETAK
           ,DATE_CREATE
           ,USER_CREATE
           ,JENIS_CETAK )
            VALUES
                (
                :UUID
                ,:namaparam
                ,:imagepath
                ,:gruptransaksi
                ,:nomortransaksi 
                )
                ";

            $this->db->query($query);
            $this->db->bind('UUID', $notrs);
            $this->db->bind('namaparam', $signAlasanCetak);
            $this->db->bind('imagepath', $datenow);
            $this->db->bind('gruptransaksi', $namauserx);
            $this->db->bind('nomortransaksi', $fixjeniscetakan); 
            $this->db->execute();
            $this->db->Commit();
            return $this->response(200, 'History Cetak Berhasil di Simpan !!!');
            
        } catch (PDOException $e) {
            $this->db->rollback();
            return $this->response(400, $e);
        }
    }
    public function insertGeneralConsen($data,$ttdpasien_aws)
    {

        if ($data['jaminan'] == '1'){
            $jaminan_pribadi = '1';
            $jaminan_perusahaan = '0';
            $jaminan_asuransi = '0';
            $jaminan_bpjs = '0';
            $jaminan_bpjs_cob = null;
            $jaminan_bpjs_kelas = null;
        }else if ($data['jaminan'] == '2'){
            $jaminan_pribadi = '0';
            $jaminan_perusahaan = '0';
            $jaminan_asuransi = '1';
            $jaminan_bpjs = '0';
            $jaminan_bpjs_cob = null;
            $jaminan_bpjs_kelas = null;
        }else if ($data['jaminan'] == '3'){
            $jaminan_pribadi = '0';
            $jaminan_perusahaan = '0';
            $jaminan_asuransi = '0';
            $jaminan_bpjs = '1';
            $jaminan_bpjs_cob = $data['jaminan_bpjs_cob'];
            $jaminan_bpjs_kelas = $data['jaminan_bpjs_kelas'];
        }else if ($data['jaminan'] == '5'){
            $jaminan_pribadi = '0';
            $jaminan_perusahaan = '1';
            $jaminan_asuransi = '0';
            $jaminan_bpjs = '0';
            $jaminan_bpjs_cob = null;
            $jaminan_bpjs_kelas = null;
        }
        
        // var_dump($data);
        $querys = "INSERT INTO Billing_Pasien.[dbo].[TDocumentGeneralConsents]
                (   DocTransactionID,
                    NoEpisode,
                    NoRegistrasi,
                    TglCreate,
                    Petugas,
                    Divisi,
                    NamaJenisPenanngungJawab,
                    NamaPenanggungJawab,
                    AlamatPenanggungJawab,
                    NoKtp,
                    Pekerjaan,
                    NoHandphone,
                    JenisKelamin,
                    Tahun,
                    NamaPasien,
                    NoRMPasien,
                    JenisKelaminPasien,
                    TangalLahirPasien,
                    AgamaPasien,
                    NIKPasien,
                    JenisPengenalPasien,
                    AlamatPasien,
                    jaminan_bpjs,
                    jaminan_perusahaan,
                    jaminan_asuransi,
                    jaminan_pribadi,
                    jaminan_namaPerusahaan,
                    consen_kuasa,
                    consen_kondisiPasien,
                    consen_aksesKeluarga,
                    consen_privasiKhusus,
                    consen_privasiKhusus_add,
                    consen_nilaikepercayaan,
                    consen_nilaikepercayaan_add,
                    NoHPPasien,
                    PetugasTTD_ID,
                    jaminan_bpjs_cob,
                    jaminan_bpjs_cob_kelas,
                    TTD_PasienWali,
                    EmailSend,
                    NoHPSend
                    )
          VALUES
                (
                    :uuid,
                    :NoEpisode,
                    :NoRegistrasi,
                    :TglCreate,
                    :Petugas,
                    :Divisi,
                    :NamaJenisPenanngungJawab,
                    :NamaPenanggungJawab,
                    :AlamatPenanggungJawab,
                    :NoKtp,
                    :Pekerjaan,
                    :NoHandphone,
                    :JenisKelamin,
                    :Tahun,
                    :NamaPasien,
                    :NoRMPasien,
                    :JenisKelaminPasien,
                    :TangalLahirPasien,
                    :AgamaPasien,
                    :NIKPasien,
                    :JenisPengenalPasien,
                    :AlamatPasien,
                    :jaminan_bpjs,
                    :jaminan_perusahaan,
                    :jaminan_asuransi,
                    :jaminan_pribadi,
                    :jaminan_namaPerusahaan,
                    :consen_kuasa,
                    :consen_kondisiPasien,
                    :consen_aksesKeluarga,
                    :consen_privasiKhusus,
                    :consen_privasiKhusus_add,
                    :consen_nilaikepercayaan,
                    :consen_nilaikepercayaan_add,
                    :pasien_nohp,
                    :idpetugas_ext,
                    :jaminan_bpjs_cob,
                    :jaminan_bpjs_kelas,
                    :ttdpasien_aws,
                    :email_send,
                    :nohp_send
             )
             ";

        try {
            $this->db->transaksi();

            $session = SessionManager::getCurrentSession();
            $userlogin = $session->IDEmployee;
            $datenowcreate= Utils::seCurrentDateTime();
            $uuid = Utils::uuid4str();
            $DocumentType = 'GENERAL_CONSEN';

            $query = "UPDATE a
              SET Active='0' 
              FROM Billing_Pasien.dbo.TDocumentMasters a
              inner join Billing_Pasien.dbo.TDocumentGeneralConsents b on a.Uuid=b.DocTransactionID
              WHERE NoRegistrasi=:NoRegistrasi and a.DocumentType=:DocumentType
              ";
                $this->db->query($query);
                $this->db->bind('NoRegistrasi', $data['noregistrasi']); 
                $this->db->bind('DocumentType', $DocumentType); 
                $this->db->execute();

            $query = "INSERT INTO Billing_Pasien.dbo.TDocumentMasters (Uuid,DateCreate,UserCreate,DocumentType,NamaTTD1,NamaTTD2)
                Values
            (:uuid,:datenowcreate,:userlogin,:DocumentType,:namaparam,:namaparam2)";
                $this->db->query($query);
                $this->db->bind('uuid', $uuid);
                $this->db->bind('datenowcreate', $datenowcreate);
                $this->db->bind('userlogin', $userlogin);
                $this->db->bind('DocumentType', $DocumentType);
                $this->db->bind('namaparam', $data['usercreate']);
                $this->db->bind('namaparam2', $data['namaparam1']);
                $this->db->execute();

            $query = "UPDATE Billing_Pasien.dbo.TDocumentGeneralConsents SET ActiveDocument='0' WHERE NoRegistrasi=:NoRegistrasi
            ";
            $this->db->query($query);
            $this->db->bind('NoRegistrasi', $data['noregistrasi']); 
            $this->db->execute();

            $this->db->query($querys);  
            $this->db->bind('uuid', $uuid); 
            $this->db->bind('NoRegistrasi', $data['noregistrasi']); 
            $this->db->bind('NoEpisode', $data['NoEpisode']);
            $this->db->bind('TglCreate', date("Y-m-d H:i:s"));
            $this->db->bind('Petugas', $data['namapetugas_ext']); 
            $this->db->bind('Divisi', 'Admission & Billing');
            $this->db->bind('NamaJenisPenanngungJawab', $data['pnj_JenisOrang']);
            $this->db->bind('NamaPenanggungJawab', $data['namaparam1']);
            $this->db->bind('AlamatPenanggungJawab', $data['pnj_alamat']);
            $this->db->bind('NoKtp', $data['pnj_noKTP']);
            $this->db->bind('Pekerjaan', $data['pnj_pekerjaan']);
            $this->db->bind('NoHandphone', $data['pnj_noHP']);
            $this->db->bind('JenisKelamin', $data['pnj_kelamin']);

            $this->db->bind('Tahun', $data['pnj_umur']);
            $this->db->bind('NamaPasien', $data['namapasien']);
            $this->db->bind('NoRMPasien', $data['norm']);
            $this->db->bind('JenisKelaminPasien', $data['jeniskelasmin']);
            $this->db->bind('TangalLahirPasien', $data['tgllahir']);
            $this->db->bind('AgamaPasien', $data['pasien_agama']);
            $this->db->bind('NIKPasien', $data['pasien_notandapengenal']);
            $this->db->bind('JenisPengenalPasien', $data['pasien_jenistandapengenal']);
            $this->db->bind('AlamatPasien', $data['pasien_alamat']);
            $this->db->bind('jaminan_bpjs', $jaminan_bpjs);
            $this->db->bind('jaminan_perusahaan', $jaminan_perusahaan);
            $this->db->bind('jaminan_asuransi', $jaminan_asuransi);
            $this->db->bind('jaminan_pribadi', $jaminan_pribadi);
            $this->db->bind('jaminan_namaPerusahaan', $data['jaminan_namaPerusahaan']);
            $this->db->bind('consen_kuasa', $data['consen_kuasa']);
            $this->db->bind('consen_kondisiPasien', $data['consen_kondisiPasien']);
            $this->db->bind('consen_aksesKeluarga', $data['consen_aksesKeluarga']);
            $this->db->bind('consen_privasiKhusus', $data['consen_privasiKhusus']);
            $this->db->bind('consen_privasiKhusus_add', $data['consen_privasiKhusus_add']);
            $this->db->bind('consen_nilaikepercayaan', $data['consen_nilaikepercayaan']);
            $this->db->bind('consen_nilaikepercayaan_add', $data['consen_nilaikepercayaan_add']); 
            $this->db->bind('pasien_nohp', $data['pasien_nohp']); 
            $this->db->bind('idpetugas_ext', $data['idpetugas_ext']); 
            $this->db->bind('jaminan_bpjs_cob', $jaminan_bpjs_cob);
            $this->db->bind('jaminan_bpjs_kelas', $jaminan_bpjs_kelas);
            $this->db->bind('nohp_send', $data['nohp_send']); 
            $this->db->bind('email_send', $data['email_send']); 
            $this->db->bind('ttdpasien_aws', $ttdpasien_aws); 

            $this->db->execute();
            $getID = $this->db->GetLastID();
            //return $this->response(200, 'Tanda Tangan Berhasi di simpan');
            if (isset($data['consen_kondisiPasien_suami'])){
                if ($data['consen_kondisiPasien'] == 'MENGIZINKAN'){
                        $consen_kondisiPasien_suami = $data['consen_kondisiPasien_suami'];
                        $consen_kondisiPasien_istri = $data['consen_kondisiPasien_istri'];
                        $consen_kondisiPasien_anak = $data['consen_kondisiPasien_anak'];
                        $consen_kondisiPasien_saudarakandung = $data['consen_kondisiPasien_saudarakandung'];
                        $consen_kondisiPasien_orangtua = $data['consen_kondisiPasien_orangtua'];
                        $jumlah_dipilih = count($consen_kondisiPasien_suami);
                        $rows = array();
                        for($x=0;$x<$jumlah_dipilih;$x++){

                        $this->db->query("INSERT INTO Billing_Pasien.dbo.TDocumentGeneralConsents_FamilyDetails (ID_Header,Keluarga_Suami,Keluarga_Istri,Keluarga_Anak,Keluarga_SaudaraKandung,Keluarga_Orangtua) VALUES(
                            :getID
                            ,:consen_kondisiPasien_suami
                            ,:consen_kondisiPasien_istri
                            ,:consen_kondisiPasien_anak
                            ,:consen_kondisiPasien_saudarakandung
                            ,:consen_kondisiPasien_orangtua
                        )");  
                        $this->db->bind('getID', $getID); 
                        $this->db->bind('consen_kondisiPasien_suami', $consen_kondisiPasien_suami[$x]); 
                        $this->db->bind('consen_kondisiPasien_istri', $consen_kondisiPasien_istri[$x]); 
                        $this->db->bind('consen_kondisiPasien_anak', $consen_kondisiPasien_anak[$x]); 
                        $this->db->bind('consen_kondisiPasien_saudarakandung', $consen_kondisiPasien_saudarakandung[$x]); 
                        $this->db->bind('consen_kondisiPasien_orangtua', $consen_kondisiPasien_orangtua[$x]); 
                        $this->db->execute();
                    }
                }
            }
            
            $this->db->Commit();
            $callback = [
                'status' => 200,
                'message' => 'Tanda Tangan Berhasi di simpan',
                'data' => $getID,
            ];
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            return $this->response(400, $e);
        }
    }
    public function uploadToAwsSign_New($data)
    {
        if ($data['idpetugas_ext'] == '' || $data['idpetugas_ext'] == null){
            $callback = [
                'status' => 400,
                'message' => 'Petugas Belum Melakukan Tanda Tangan !',
            ];
            return $callback;
            exit;
        }

        $jenisdoc = $data['jenisdoc'];
        
        $s3Client = new S3Client([
            'version' => 'latest',
            'region'  => 'ap-southeast-1',
            'http'    => ['verify' => false],
            'credentials' => [
                'key'    => 'AKIAYV2M6ERJGUKK4QWQ',
                'secret' => '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'
            ]
        ]);
            // $filename1 = __DIR__ . '/../../public' . '/images/signature/' . $data['uuid1']. '.png';
            // $source1 =   $filename1;
            //  $awsImages = $data['path1'];
            //  $filename1 = null;
            // $handle = fopen($source1, 'r');

            $filename2 = __DIR__ . '/../../public' . '/images/signature/' . $data['uuid2']. '.png';
            $source2 =   $filename2;
            $awsImages2 = '';
            $handle2 = fopen($source2, 'r');

         try {
                // // TTD 1
                //     $bucket = 'rsuyarsibucket';
                //     $key = basename($filename1);
                //     $result = $s3Client->putObject([
                //         'Bucket' => $bucket,
                //         'Key'    => 'digitalfiles/dgitalSignPatient/' . $key,
                //         'Body'   => $handle,
                //         'ACL'    => 'public-read', // make file 'public', 
                //     ]);
                //     $awsImages = $result->get('ObjectURL');
                //     fclose($handle);
                    

                    // TTD 2
                    $bucket2 = 'rsuyarsibucket';
                    $key2 = basename($filename2);
                    $result2 = $s3Client->putObject([
                        'Bucket' => $bucket2,
                        'Key'    => 'digitalfiles/dgitalSignPatient/' . $key2,
                        'Body'   => $handle2,
                        'ACL'    => 'public-read', // make file 'public', 
                    ]);
                    $awsImages2 = $result2->get('ObjectURL');
                    fclose($handle2);
                    unlink($_SERVER["DOCUMENT_ROOT"].'SIKBREC/public/images/signature/'.$data['uuid2']. '.png');
                    // unlink($_SERVER["DOCUMENT_ROOT"].'SIKBREC/public/images/signature/'.$data['uuid1']. '.png');
                    // return $this->SaveTTDDigital($data, $data['uuid2'], $filename1, $awsImages,$awsImages2,"GENERAL CONSEN");
                    return $this->$jenisdoc($data,$awsImages2);

         } catch (MultipartUploadException $e) {
            return $e->getMessage();
         } 
    }

    public function uploadToAwsSignHakKewajiban($data)
    {
        $s3Client = new S3Client([
            'version' => 'latest',
            'region'  => 'ap-southeast-1',
            'http'    => ['verify' => false],
            'credentials' => [
                'key'    => 'AKIAYV2M6ERJGUKK4QWQ',
                'secret' => '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'
            ]
        ]);
            // $filename1 = __DIR__ . '/../../public' . '/images/signature/' . $data['uuid1']. '.png';
            // $source1 =   $filename1;
            // $awsImages = '';
            // $handle = fopen($source1, 'r');

            $awsImages = $data['path1'];
            $filename1 = null;

            $filename2 = __DIR__ . '/../../public' . '/images/signature/' . $data['uuid2']. '.png';
            $source2 =   $filename2;
            $awsImages2 = '';
            $handle2 = fopen($source2, 'r');

         try {
                // // TTD 1
                //     $bucket = 'rsuyarsibucket';
                //     $key = basename($filename1);
                //     $result = $s3Client->putObject([
                //         'Bucket' => $bucket,
                //         'Key'    => 'digitalfiles/dgitalSignPatient/' . $key,
                //         'Body'   => $handle,
                //         'ACL'    => 'public-read', // make file 'public', 
                //     ]);
                //     $awsImages = $result->get('ObjectURL');
                //     fclose($handle);
                    

                    // TTD 2
                    $bucket2 = 'rsuyarsibucket';
                    $key2 = basename($filename2);
                    $result2 = $s3Client->putObject([
                        'Bucket' => $bucket2,
                        'Key'    => 'digitalfiles/dgitalSignPatient/' . $key2,
                        'Body'   => $handle2,
                        'ACL'    => 'public-read', // make file 'public', 
                    ]);
                    $awsImages2 = $result2->get('ObjectURL');
                    fclose($handle2);
                    unlink($_SERVER["DOCUMENT_ROOT"].'SIKBREC/public/images/signature/'.$data['uuid2']. '.png');
                    // unlink($_SERVER["DOCUMENT_ROOT"].'SIKBREC/public/images/signature/'.$data['uuid1']. '.png');
                    return $this->SaveTTDDigital($data, $data['uuid2'], $filename1, $awsImages,$awsImages2,"HAK DAN KEWAJIBAN");

         } catch (MultipartUploadException $e) {
            return $e->getMessage();
         } 
    }

    public function saveHakdanKewajiban($data,$ttdpasien_aws)
    {
        
        $querys = "INSERT INTO Billing_Pasien.[dbo].[TDocumentRightsandObligations]
        (
        DocTransactionID,
        [NoRegistrasi]
        ,[NoEpisode]
        ,[NoMR]
        ,[NamaPasien]
        ,[TglCreate]
        ,[NamaWaliPasien]
        ,[NIK]
        ,[Petugas]
        ,[Divisi]
        ,PetugasTTD_ID
        ,TTD_PasienWali
        ,EmailSend
        ,NoHPSend
        )
  VALUES
        (
        :uuid, 
        :NoRegistrasi, 
        :NoEpisode, 
        :NoRMPasien, 
        :NamaPasien, 
        :TglCreate,
        :namawali,
        :nik,
        :petugas, 
        :divisi,
        :idpetugas_ext,
        :ttdpasien_aws,
        :email_send,
        :nohp_send
        )
             ";

        try {
            $this->db->transaksi();

            $session = SessionManager::getCurrentSession();
            $namauserx = $session->name;
            $userlogin = $session->IDEmployee;
            $datenowcreate= Utils::seCurrentDateTime();
            $uuid = Utils::uuid4str();
            $DocumentType = 'HAK_DAN_KEWAJIBAN';

            $query = "UPDATE a
              SET Active='0' 
              FROM Billing_Pasien.dbo.TDocumentMasters a
              inner join Billing_Pasien.dbo.TDocumentRightsandObligations b on a.Uuid=b.DocTransactionID
              WHERE NoRegistrasi=:NoRegistrasi and a.DocumentType=:DocumentType
              ";
                $this->db->query($query);
                $this->db->bind('NoRegistrasi', $data['noregistrasi']); 
                $this->db->bind('DocumentType', $DocumentType); 
                $this->db->execute();

            $query = "INSERT INTO Billing_Pasien.dbo.TDocumentMasters (Uuid,DateCreate,UserCreate,DocumentType,NamaTTD1,NamaTTD2)
                Values
            (:uuid,:datenowcreate,:userlogin,:DocumentType,:namaparam,:namaparam2)";
                $this->db->query($query);
                $this->db->bind('uuid', $uuid);
                $this->db->bind('datenowcreate', $datenowcreate);
                $this->db->bind('userlogin', $userlogin);
                $this->db->bind('DocumentType', $DocumentType);
                $this->db->bind('namaparam', $data['usercreate']);
                $this->db->bind('namaparam2', $data['namaparam1']);
                $this->db->execute();

            $query = "UPDATE Billing_Pasien.dbo.TDocumentRightsandObligations SET ActiveDocument='0' WHERE NoRegistrasi=:NoRegistrasi
            ";
            $this->db->query($query);
            $this->db->bind('NoRegistrasi', $data['noregistrasi']); 
            $this->db->execute();

            $this->db->query($querys);  
            $this->db->bind('uuid', $uuid);
            $this->db->bind('NoRegistrasi', $data['noregistrasi']); 
            $this->db->bind('NoEpisode', $data['NoEpisode']);
            $this->db->bind('TglCreate', date("Y-m-d H:i:s"));
            $this->db->bind('NamaPasien', $data['namapasien']);
            $this->db->bind('NoRMPasien', $data['norm']);
            $this->db->bind('namawali', $data['namawali']);
            $this->db->bind('nik', $data['nik']);
            $this->db->bind('petugas', $data['namapetugas_ext']);
            $this->db->bind('divisi', 'Admission & Billing');
            $this->db->bind('idpetugas_ext', $data['idpetugas_ext']);
            $this->db->bind('nohp_send', $data['nohp_send']); 
            $this->db->bind('email_send', $data['email_send']); 
            $this->db->bind('ttdpasien_aws', $ttdpasien_aws); 
             
            $this->db->execute();
            $this->db->Commit();
            $getID = $this->db->GetLastID();
            //return $this->response(200, 'Tanda Tangan Berhasi di simpan');
            $callback = [
                'status' => 200,
                'message' => 'Tanda Tangan Berhasi di simpan',
                'data' => $getID,
            ];
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            return $this->response(400, $e);
        }
    }

    public function saveTataTertib($data,$ttdpasien_aws)
    {
        
        // var_dump($data);
        $querys = "INSERT INTO Billing_Pasien.[dbo].[TDocumentRegulations]
        (
         DocTransactionID,
        [NoRegistrasi]
        ,[NoEpisode]
        ,[NoMR]
        ,[NamaPasien]
        ,[TglCreate]
        ,[NamaWaliPasien]
        ,[NIK]
        ,[Petugas]
        ,[Divisi]
        ,PetugasTTD_ID
        ,TTD_PasienWali
        ,EmailSend
        ,NoHPSend
        )
  VALUES
        (
        :uuid,
        :NoRegistrasi, 
        :NoEpisode, 
        :NoRMPasien, 
        :NamaPasien, 
        :TglCreate,
        :namawali, 
        :nik,
        :petugas, 
        :divisi,
        :idpetugas_ext,
        :ttdpasien_aws,
        :email_send,
        :nohp_send
        )
             ";

        try {
            $this->db->transaksi();

            $session = SessionManager::getCurrentSession();
            $userlogin = $session->IDEmployee;
            $namauserx = $session->name;
            $datenowcreate= Utils::seCurrentDateTime();
            $uuid = Utils::uuid4str();
            $DocumentType = 'TATA_TERTIB';

            $query = "UPDATE a
              SET Active='0' 
              FROM Billing_Pasien.dbo.TDocumentMasters a
              inner join Billing_Pasien.dbo.TDocumentRegulations b on a.Uuid=b.DocTransactionID
              WHERE NoRegistrasi=:NoRegistrasi and a.DocumentType=:DocumentType
              ";
                $this->db->query($query);
                $this->db->bind('NoRegistrasi', $data['noregistrasi']); 
                $this->db->bind('DocumentType', $DocumentType); 
                $this->db->execute();

            $query = "INSERT INTO Billing_Pasien.dbo.TDocumentMasters (Uuid,DateCreate,UserCreate,DocumentType,NamaTTD1,NamaTTD2)
                Values
            (:uuid,:datenowcreate,:userlogin,:DocumentType,:namaparam,:namaparam2)";
                $this->db->query($query);
                $this->db->bind('uuid', $uuid);
                $this->db->bind('datenowcreate', $datenowcreate);
                $this->db->bind('userlogin', $userlogin);
                $this->db->bind('DocumentType', $DocumentType);
                $this->db->bind('namaparam', $data['usercreate']);
                $this->db->bind('namaparam2', $data['namaparam1']);
                $this->db->execute();

            $query = "UPDATE Billing_Pasien.dbo.TDocumentRegulations SET ActiveDocument='0' WHERE NoRegistrasi=:NoRegistrasi
            ";
            $this->db->query($query);
            $this->db->bind('NoRegistrasi', $data['noregistrasi']); 
            $this->db->execute();


            $this->db->query($querys);  
            $this->db->bind('uuid', $uuid); 
            $this->db->bind('NoRegistrasi', $data['noregistrasi']); 
            $this->db->bind('NoEpisode', $data['NoEpisode']);
            $this->db->bind('TglCreate', date("Y-m-d H:i:s"));
            $this->db->bind('NamaPasien', $data['namapasien']);
            $this->db->bind('NoRMPasien', $data['norm']);
            $this->db->bind('namawali', $data['namawali']);
            $this->db->bind('nik', $data['nik']);
            $this->db->bind('petugas', $data['namapetugas_ext']);
            $this->db->bind('divisi', 'Admission & Billing');
            $this->db->bind('idpetugas_ext', $data['idpetugas_ext']);
            $this->db->bind('nohp_send', $data['nohp_send']); 
            $this->db->bind('email_send', $data['email_send']); 
            $this->db->bind('ttdpasien_aws', $ttdpasien_aws); 
             
            $this->db->execute();
            $this->db->Commit();
            $getID = $this->db->GetLastID();
            //return $this->response(200, 'Tanda Tangan Berhasi di simpan');
            $callback = [
                'status' => 200,
                'message' => 'Tanda Tangan Berhasi di simpan',
                'data' => $getID,
            ];
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            return $this->response(400, $e);
        }
    }

    public function uploadToAwsSignTataTertib($data)
    {
        $s3Client = new S3Client([
            'version' => 'latest',
            'region'  => 'ap-southeast-1',
            'http'    => ['verify' => false],
            'credentials' => [
                'key'    => 'AKIAYV2M6ERJGUKK4QWQ',
                'secret' => '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'
            ]
        ]);
            // $filename1 = __DIR__ . '/../../public' . '/images/signature/' . $data['uuid1']. '.png';
            // $source1 =   $filename1;
            // $awsImages = '';
            // $handle = fopen($source1, 'r');

            $awsImages = $data['path1'];
            $filename1 = null;

            $filename2 = __DIR__ . '/../../public' . '/images/signature/' . $data['uuid2']. '.png';
            $source2 =   $filename2;
            $awsImages2 = '';
            $handle2 = fopen($source2, 'r');

         try {
                // // TTD 1
                //     $bucket = 'rsuyarsibucket';
                //     $key = basename($filename1);
                //     $result = $s3Client->putObject([
                //         'Bucket' => $bucket,
                //         'Key'    => 'digitalfiles/dgitalSignPatient/' . $key,
                //         'Body'   => $handle,
                //         'ACL'    => 'public-read', // make file 'public', 
                //     ]);
                //     $awsImages = $result->get('ObjectURL');
                //     fclose($handle);
                    

                    // TTD 2
                    $bucket2 = 'rsuyarsibucket';
                    $key2 = basename($filename2);
                    $result2 = $s3Client->putObject([
                        'Bucket' => $bucket2,
                        'Key'    => 'digitalfiles/dgitalSignPatient/' . $key2,
                        'Body'   => $handle2,
                        'ACL'    => 'public-read', // make file 'public', 
                    ]);
                    $awsImages2 = $result2->get('ObjectURL');
                    fclose($handle2);
                    unlink($_SERVER["DOCUMENT_ROOT"].'SIKBREC/public/images/signature/'.$data['uuid2']. '.png');
                    // unlink($_SERVER["DOCUMENT_ROOT"].'SIKBREC/public/images/signature/'.$data['uuid1']. '.png');
                    return $this->SaveTTDDigital($data, $data['uuid2'], $filename1, $awsImages,$awsImages2,"TATA TERTIB");

         } catch (MultipartUploadException $e) {
            return $e->getMessage();
         } 
    }

    public function savePerkiraanbiayaNonOP($data,$ttdpasien_aws)
    {
        
         $NoEpisode = $data['NoEpisode'];
        $Noregis = $data['Noregis'];
        $pasien_nomr = $data['pasien_nomr'];
        $pasien_nama = $data['pasien_nama'];
        $pasien_rencanakeperawatan = $data['pasien_rencanakeperawatan'];
        $pasien_diagnosa = $data['pasien_diagnosa'];
        $pasien_dpjp = $data['pasien_dpjp'];
        if (!isset($data['pasien_kamarperawatan'])){
            $pasien_kamarperawatan = null;
        }else{
            $pasien_kamarperawatan = $data['pasien_kamarperawatan'];
        }
        $pasien_kelas = $data['kelasname'];
        $pasien_perkiraanlamarawat = $data['pasien_perkiraanlamarawat'];
        $rs_kamarperawatan = str_replace(".", "", $data['rs_kamarperawatan']);
        $rs_kamarintensive = str_replace(".", "", $data['rs_kamarintensive']);
        $rs_lab = str_replace(".", "", $data['rs_lab']);
        $rs_radiologi = str_replace(".", "", $data['rs_radiologi']);
        $rs_farmasi = str_replace(".", "", $data['rs_farmasi']);
        $rs_bhp = str_replace(".", "", $data['rs_bhp']);
        $rs_administrasi = str_replace(".", "", $data['rs_administrasi']);
        $jd_visitedpjp = str_replace(".", "", $data['jd_visitedpjp']);
        $jd_visiteintensive = str_replace(".", "", $data['jd_visiteintensive']);
        $jd_visitekonsulanestesi = str_replace(".", "", $data['jd_visitekonsulanestesi']);
        $jd_visitekonsulinternis = str_replace(".", "", $data['jd_visitekonsulinternis']);
        $namawali = $data['namawali'];
        $nik = $data['nik'];
        $namapetugas_ext = $data['namapetugas_ext'];
        $idpetugas_ext = $data['idpetugas_ext'];
        $rs_kamarperawatan_ket = $data['rs_kamarperawatan_ket'];
        $rs_kamarintensive_ket = $data['rs_kamarintensive_ket'];
        $rs_lab_ket = $data['rs_lab_ket'];
        $rs_radiologi_ket = $data['rs_radiologi_ket'];
        $rs_farmasi_ket = $data['rs_farmasi_ket'];
        $rs_bhp_ket = $data['rs_bhp_ket'];
        $rs_administrasi_ket = $data['rs_administrasi_ket'];
        $jd_visitedpjp_ket = $data['jd_visitedpjp_ket'];
        $jd_visiteintensive_ket = $data['jd_visiteintensive_ket'];
        $jd_visitekonsulanestesi_ket = $data['jd_visitekonsulanestesi_ket'];
        $jd_visitekonsulinternis_ket = $data['jd_visitekonsulinternis_ket'];
        $keterangan_lainnya = $data['keterangan_lainnya'];


        $querys = "INSERT INTO Billing_Pasien.[dbo].[TDocumentEsitimatedNonOperationgCosts]
        (
            DocTransactionID,
            [NoRegistrasi]
        ,[NoEpisode]
        ,[NoMR]
        ,[NamaPasien]
        ,[TglCreate]
        ,[RencanaPerawatan]
        ,[DiagnosaMedis]
        ,[DPJP]
        ,[KamaPerawatan]
        ,[Kelas]
        ,[PerkiraanLamaRawat]
        ,[RS_KamarPerawatan]
        ,[RS_KamarIntensive]
        ,[RS_Lab]
        ,[RS_Radiologi]
        ,[RS_Farmasi]
        ,[RS_BHP]
        ,[RS_Administrasi]
        ,[JD_VisiteDPJP]
        ,[JD_VisiteIntesive]
        ,[JD_VisiteKonsulAnestesi]
        ,[JD_VisiteKonsulInternis]
        ,[NamaWaliPasien]
        ,[NIK]
        ,[Petugas]
        ,[Divisi]
        ,PetugasTTD_ID
        ,RS_KamarPerawatan_ket
        ,RS_KamarIntensive_ket
        ,RS_Lab_ket
        ,RS_Radiologi_ket
        ,RS_Farmasi_ket
        ,RS_BHP_ket
        ,RS_Administrasi_ket
        ,JD_VisiteDPJP_ket
        ,JD_VisiteIntesive_ket
        ,JD_VisiteKonsulAnestesi_ket
        ,JD_VisiteKonsulInternis_ket
        ,KeteranganLainnya
        ,TTD_PasienWali
        ,EmailSend
        ,NoHPSend
        )
  VALUES
        (
            :uuid,
            :NoRegistrasi
            ,:NoEpisode
            ,:NoMR
            ,:NamaPasien
            ,:TglCreate
            ,:RencanaPerawatan
            ,:DiagnosaMedis
            ,:DPJP
            ,:KamaPerawatan
            ,:Kelas
            ,:PerkiraanLamaRawat
            ,:RS_KamarPerawatan
            ,:RS_KamarIntensive
            ,:RS_Lab
            ,:RS_Radiologi
            ,:RS_Farmasi
            ,:RS_BHP
            ,:RS_Administrasi
            ,:JD_VisiteDPJP
            ,:JD_VisiteIntesive
            ,:JD_VisiteKonsulAnestesi
            ,:JD_VisiteKonsulInternis
            ,:namawali
            ,:nik
            ,:petugas
            ,:divisi
            ,:idpetugas_ext
            ,:rs_kamarperawatan_ket
            ,:rs_kamarintensive_ket
            ,:rs_lab_ket
            ,:rs_radiologi_ket
            ,:rs_farmasi_ket
            ,:rs_bhp_ket
            ,:rs_administrasi_ket
            ,:jd_visitedpjp_ket
            ,:jd_visiteintensive_ket
            ,:jd_visitekonsulanestesi_ket
            ,:jd_visitekonsulinternis_ket
            ,:keterangan_lainnya,
            :ttdpasien_aws,
            :email_send,
            :nohp_send
        )
             ";

        try {
            $this->db->transaksi();

            $session = SessionManager::getCurrentSession();
            $userlogin = $session->IDEmployee;
            $namauserx = $session->name;
            $datenowcreate= Utils::seCurrentDateTime();
            $uuid = Utils::uuid4str();
            $DocumentType = 'BIAYA_NONOPERASI';

            $query = "UPDATE a
              SET Active='0' 
              FROM Billing_Pasien.dbo.TDocumentMasters a
              inner join Billing_Pasien.dbo.TDocumentEsitimatedNonOperationgCosts b on a.Uuid=b.DocTransactionID
              WHERE NoRegistrasi=:NoRegistrasi and a.DocumentType=:DocumentType
              ";
                $this->db->query($query);
                $this->db->bind('NoRegistrasi', $Noregis); 
                $this->db->bind('DocumentType', $DocumentType); 
                $this->db->execute();

            $query = "INSERT INTO Billing_Pasien.dbo.TDocumentMasters (Uuid,DateCreate,UserCreate,DocumentType,NamaTTD1,NamaTTD2)
                Values
            (:uuid,:datenowcreate,:userlogin,:DocumentType,:namaparam,:namaparam2)";
                $this->db->query($query);
                $this->db->bind('uuid', $uuid);
                $this->db->bind('datenowcreate', $datenowcreate);
                $this->db->bind('userlogin', $userlogin);
                $this->db->bind('DocumentType', $DocumentType);
                $this->db->bind('namaparam', $data['usercreate']);
                $this->db->bind('namaparam2', $data['namaparam1']);
                $this->db->execute();

            $query = "UPDATE Billing_Pasien.dbo.TDocumentEsitimatedNonOperationgCosts SET ActiveDocument='0' WHERE NoRegistrasi=:NoRegistrasi
            ";
            $this->db->query($query);
            $this->db->bind('NoRegistrasi', $Noregis); 
            $this->db->execute();

            $this->db->query($querys);  
            $this->db->bind('uuid', $uuid);
            $this->db->bind('NoRegistrasi', $Noregis);
            $this->db->bind('NoEpisode', $NoEpisode);
            $this->db->bind('NoMR', $pasien_nomr);
            $this->db->bind('NamaPasien', $pasien_nama);
            $this->db->bind('TglCreate', date("Y-m-d H:i:s"));
            $this->db->bind('RencanaPerawatan', $pasien_rencanakeperawatan);
            $this->db->bind('DiagnosaMedis', $pasien_diagnosa);
            $this->db->bind('DPJP', $pasien_dpjp);
            $this->db->bind('KamaPerawatan', $pasien_kamarperawatan);
            $this->db->bind('Kelas', $pasien_kelas);
            $this->db->bind('PerkiraanLamaRawat', $pasien_perkiraanlamarawat);
            $this->db->bind('RS_KamarPerawatan', $rs_kamarperawatan);
            $this->db->bind('RS_KamarIntensive', $rs_kamarintensive);
            $this->db->bind('RS_Lab', $rs_lab);
            $this->db->bind('RS_Radiologi', $rs_radiologi);
            $this->db->bind('RS_Farmasi', $rs_farmasi);
            $this->db->bind('RS_BHP', $rs_bhp);
            $this->db->bind('RS_Administrasi', $rs_administrasi);
            $this->db->bind('JD_VisiteDPJP', $jd_visitedpjp);
            $this->db->bind('JD_VisiteIntesive', $jd_visiteintensive);
            $this->db->bind('JD_VisiteKonsulAnestesi', $jd_visitekonsulanestesi);
            $this->db->bind('JD_VisiteKonsulInternis', $jd_visitekonsulinternis);
            $this->db->bind('namawali', $namawali);
            $this->db->bind('nik', $nik);
            $this->db->bind('petugas', $namapetugas_ext);
            $this->db->bind('divisi', 'Admission & Billing');
            $this->db->bind('idpetugas_ext', $idpetugas_ext);
            $this->db->bind('rs_kamarperawatan_ket', $rs_kamarperawatan_ket);
            $this->db->bind('rs_kamarintensive_ket', $rs_kamarintensive_ket);
            $this->db->bind('rs_lab_ket', $rs_lab_ket);
            $this->db->bind('rs_radiologi_ket', $rs_radiologi_ket);
            $this->db->bind('rs_farmasi_ket', $rs_farmasi_ket);
            $this->db->bind('rs_bhp_ket', $rs_bhp_ket);
            $this->db->bind('rs_administrasi_ket', $rs_administrasi_ket);
            $this->db->bind('jd_visitedpjp_ket', $jd_visitedpjp_ket);
            $this->db->bind('jd_visiteintensive_ket', $jd_visiteintensive_ket);
            $this->db->bind('jd_visitekonsulanestesi_ket', $jd_visitekonsulanestesi_ket);
            $this->db->bind('jd_visitekonsulinternis_ket', $jd_visitekonsulinternis_ket);
            $this->db->bind('keterangan_lainnya', $keterangan_lainnya);
            $this->db->bind('nohp_send', $data['nohp_send']); 
            $this->db->bind('email_send', $data['email_send']); 
            $this->db->bind('ttdpasien_aws', $ttdpasien_aws); 
             
            $this->db->execute();
            $this->db->Commit();
            $getID = $this->db->GetLastID();
            //return $this->response(200, 'Tanda Tangan Berhasi di simpan');
            $callback = [
                'status' => 200,
                'message' => 'Tanda Tangan Berhasi di simpan',
                'data' => $getID,
            ];
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            return $this->response(400, $e);
        }
    }

    public function uploadToAwsSignPerkiraanbiayaNonOP($data)
    {
        $s3Client = new S3Client([
            'version' => 'latest',
            'region'  => 'ap-southeast-1',
            'http'    => ['verify' => false],
            'credentials' => [
                'key'    => 'AKIAYV2M6ERJGUKK4QWQ',
                'secret' => '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'
            ]
        ]);
            // $filename1 = __DIR__ . '/../../public' . '/images/signature/' . $data['uuid1']. '.png';
            // $source1 =   $filename1;
            // $awsImages = '';
            // $handle = fopen($source1, 'r');

            $awsImages = $data['path1'];
            $filename1 = null;

            $filename2 = __DIR__ . '/../../public' . '/images/signature/' . $data['uuid2']. '.png';
            $source2 =   $filename2;
            $awsImages2 = '';
            $handle2 = fopen($source2, 'r');

         try {
                // // TTD 1
                //     $bucket = 'rsuyarsibucket';
                //     $key = basename($filename1);
                //     $result = $s3Client->putObject([
                //         'Bucket' => $bucket,
                //         'Key'    => 'digitalfiles/dgitalSignPatient/' . $key,
                //         'Body'   => $handle,
                //         'ACL'    => 'public-read', // make file 'public', 
                //     ]);
                //     $awsImages = $result->get('ObjectURL');
                //     fclose($handle);
                    

                    // TTD 2
                    $bucket2 = 'rsuyarsibucket';
                    $key2 = basename($filename2);
                    $result2 = $s3Client->putObject([
                        'Bucket' => $bucket2,
                        'Key'    => 'digitalfiles/dgitalSignPatient/' . $key2,
                        'Body'   => $handle2,
                        'ACL'    => 'public-read', // make file 'public', 
                    ]);
                    $awsImages2 = $result2->get('ObjectURL');
                    fclose($handle2);
                    unlink($_SERVER["DOCUMENT_ROOT"].'SIKBREC/public/images/signature/'.$data['uuid2']. '.png');
                    // unlink($_SERVER["DOCUMENT_ROOT"].'SIKBREC/public/images/signature/'.$data['uuid1']. '.png');
                    return $this->SaveTTDDigital($data, $data['uuid2'], $filename1, $awsImages,$awsImages2,"PERKIRAAN BIAYA NON OP");

         } catch (MultipartUploadException $e) {
            return $e->getMessage();
         } 
    }

    public function getDataFromGC($data)
    {
        try {

            $this->db->query("SELECT * FROM Billing_Pasien.dbo.TDocumentGeneralConsents WHERE NoRegistrasi=:notrs and ActiveDocument='1'");
            $this->db->bind('notrs', $data['notrs']);
            $data =  $this->db->single();

            //$pasing['TglCreate'] = date('d/m/Y', strtotime($data['TglCreate']));
            $pasing['ID'] = $data['ID'];
            $pasing['NoEpisode'] = $data['NoEpisode'];
            $pasing['NoRegistrasi'] = $data['NoRegistrasi'];
            $pasing['NamaJenisPenanngungJawab'] = $data['NamaJenisPenanngungJawab'];
            $pasing['NamaPenanggungJawab'] = $data['NamaPenanggungJawab'];
            $pasing['AlamatPenanggungJawab'] = $data['AlamatPenanggungJawab'];
            $pasing['NoKtp'] = $data['NoKtp'];
            $pasing['Pekerjaan'] = $data['Pekerjaan'];
            $pasing['NoHandphone'] = $data['NoHandphone'];
            $pasing['JenisKelamin'] = $data['JenisKelamin'];
            $pasing['Tahun'] = $data['Tahun'];
            $pasing['EmailSend'] = $data['EmailSend'];
            $pasing['NoHPSend'] = $data['NoHPSend'];

            $callback = [
                'status' => 200,
                'data' => $pasing,
            ];
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataHistoryGeneralConsent($data)
    {
        try {
            $nomr =  $data['nomr'];

            $this->db->query("SELECT * 
            FROM Billing_Pasien.dbo.TDocumentGeneralConsents WHERE NoRMPasien=:nomr and ActiveDocument='1'
            ORDER BY 1 DESC");
            $this->db->bind('nomr', $nomr);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 0;
            foreach ($data as $key) {
                $no++;
                $pasing['no'] = $no;
                $pasing['TglCreate'] = date('d/m/Y', strtotime($key['TglCreate']));
                $pasing['ID'] = $key['ID'];
                $pasing['NoEpisode'] = $key['NoEpisode'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['Petugas'] = $key['Petugas'];
                $pasing['Divisi'] = $key['Divisi'];
                $pasing['NamaJenisPenanngungJawab'] = $key['NamaJenisPenanngungJawab'];
                $pasing['NamaPenanggungJawab'] = $key['NamaPenanggungJawab'];
                $pasing['AlamatPenanggungJawab'] = $key['AlamatPenanggungJawab'];
                $pasing['NoKtp'] = $key['NoKtp'];
                $pasing['Pekerjaan'] = $key['Pekerjaan'];
                $pasing['NoHandphone'] = $key['NoHandphone'];
                $pasing['JenisKelamin'] = $key['JenisKelamin'];
                $pasing['Tahun'] = $key['Tahun'];
                $pasing['NamaPasien'] = $key['NamaPasien'];
                $pasing['NoRMPasien'] = $key['NoRMPasien'];
                $pasing['JenisKelaminPasien'] = $key['JenisKelaminPasien'];
                $pasing['TangalLahirPasien'] = date('d/m/Y', strtotime($key['TangalLahirPasien']));
                $pasing['AgamaPasien'] = $key['AgamaPasien'];
                $pasing['NIKPasien'] = $key['NIKPasien'];
                $pasing['JenisPengenalPasien'] = $key['JenisPengenalPasien'];
                $pasing['AlamatPasien'] = $key['AlamatPasien'];
                $pasing['jaminan_bpjs'] = $key['jaminan_bpjs'];
                $pasing['jaminan_perusahaan'] = $key['jaminan_perusahaan'];
                $pasing['jaminan_asuransi'] = $key['jaminan_asuransi'];
                $pasing['jaminan_pribadi'] = $key['jaminan_pribadi'];
                $pasing['jaminan_namaPerusahaan'] = $key['jaminan_namaPerusahaan'];
                $pasing['consen_kuasa'] = $key['consen_kuasa'];
                $pasing['consen_kondisiPasien'] = $key['consen_kondisiPasien'];
                $pasing['consen_aksesKeluarga'] = $key['consen_aksesKeluarga'];
                $pasing['consen_privasiKhusus'] = $key['consen_privasiKhusus'];
                $pasing['consen_privasiKhusus_add'] = $key['consen_privasiKhusus_add'];
                $pasing['consen_nilaikepercayaan'] = $key['consen_nilaikepercayaan'];
                $pasing['consen_nilaikepercayaan_add'] = $key['consen_nilaikepercayaan_add'];
                $pasing['AwsUrlDocuments'] = $key['AwsUrlDocuments'];
                $pasing['uuid4'] = $key['DocTransactionID'];
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

    public function getDataHistoryAkadIjaroh($data)
    {
        try {
            $nomr =  $data['nomr'];

            $this->db->query("SELECT * 
            FROM Billing_Pasien.dbo.TDocumentIjarohAgreements WHERE NoRM=:nomr and ActiveDocument='1'
            ORDER BY 1 DESC");
            $this->db->bind('nomr', $nomr);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 0;
            foreach ($data as $key) {
                $no++;
                $pasing['ID'] = $key['ID'];
                $pasing['NoEpisode'] = $key['NoEpisode'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['TglCreate'] = date('d/m/Y', strtotime($key['TglCreate']));
                $pasing['Petugas'] = $key['Petugas'];
                $pasing['Divisi'] = $key['Divisi'];
                $pasing['NamaJenisPenanngungJawab'] = $key['NamaJenisPenanngungJawab'];
                $pasing['NamaPenanggungJawab'] = $key['NamaPenanggungJawab'];
                $pasing['AlamatPenanggungJawab'] = $key['AlamatPenanggungJawab'];
                $pasing['NoKtp'] = $key['NoKtp'];
                $pasing['Pekerjaan'] = $key['Pekerjaan'];
                $pasing['NoHandphone'] = $key['NoHandphone'];
                $pasing['NamaPasien'] = $key['NamaPasien'];
                $pasing['NoRM'] = $key['NoRM'];
                $pasing['JenisKelamin'] = $key['JenisKelamin'];
                $pasing['NIKPasien'] = $key['NIKPasien'];
                $pasing['TangalLahir'] = date('d/m/Y', strtotime($key['TangalLahir']));
                $pasing['LokasiPasien'] = $key['LokasiPasien'];
                $pasing['AwsUrlDocuments'] = $key['AwsUrlDocuments'];
                $pasing['uuid4'] = $key['DocTransactionID'];
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

    public function getDataHistoryTataTertib($data)
    {
        try {
            $nomr =  $data['nomr'];

            $this->db->query("SELECT * 
            FROM Billing_Pasien.dbo.TDocumentRegulations WHERE NoMR=:nomr and ActiveDocument='1'
            ORDER BY 1 DESC");
            $this->db->bind('nomr', $nomr);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 0;
            foreach ($data as $key) {
                $no++;
                $pasing['no'] = $no;
                $pasing['TglCreate_sign'] = date('d/m/Y', strtotime($key['TglCreate']));
                $pasing['ID'] = $key['ID'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['NoEpisode'] = $key['NoEpisode'];
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['NamaPasien'] = $key['NamaPasien'];
                $pasing['AwsUrlDocuments'] = $key['AwsUrlDocuments'];
                $pasing['uuid4'] = $key['DocTransactionID'];
                $pasing['NamaWaliPasien'] = $key['NamaWaliPasien'];
                $pasing['NIK'] = $key['NIK'];
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

    public function getDataHistoryHakdanKewajiban($data)
    {
        try {
            $nomr =  $data['nomr'];

            $this->db->query("SELECT * 
            FROM Billing_Pasien.dbo.TDocumentRightsandObligations WHERE NoMR=:nomr and ActiveDocument='1'
            ORDER BY 1 DESC");
            $this->db->bind('nomr', $nomr);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 0;
            foreach ($data as $key) {
                $no++;
                $pasing['no'] = $no;
                $pasing['TglCreate_sign'] = date('d/m/Y', strtotime($key['TglCreate']));
                $pasing['ID'] = $key['ID'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['NoEpisode'] = $key['NoEpisode'];
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['NamaPasien'] = $key['NamaPasien'];
                $pasing['AwsUrlDocuments'] = $key['AwsUrlDocuments'];
                $pasing['uuid4'] = $key['DocTransactionID'];
                $pasing['NamaWaliPasien'] = $key['NamaWaliPasien'];
                $pasing['NIK'] = $key['NIK'];
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

    public function getDataHistoryBiayaNonOP($data)
    {
        try {
            $nomr =  $data['nomr'];

            $this->db->query("SELECT * 
            FROM Billing_Pasien.dbo.TDocumentEsitimatedNonOperationgCosts WHERE NoMR=:nomr and ActiveDocument='1'
            ORDER BY 1 DESC");
            $this->db->bind('nomr', $nomr);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 0;
            foreach ($data as $key) {
                $no++;
                $pasing['no'] = $no;
                $pasing['TglCreate_sign'] = date('d/m/Y', strtotime($key['TglCreate']));
                $pasing['ID'] = $key['ID'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['NoEpisode'] = $key['NoEpisode'];
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['NamaPasien'] = $key['NamaPasien'];
                $pasing['AwsUrlDocuments'] = $key['AwsUrlDocuments'];
                $pasing['RencanaPerawatan'] = $key['RencanaPerawatan'];
                $pasing['DiagnosaMedis'] = $key['DiagnosaMedis'];
                $pasing['DPJP'] = $key['DPJP'];
                $pasing['KamaPerawatan'] = $key['KamaPerawatan'];
                $pasing['Kelas'] = $key['Kelas'];
                $pasing['PerkiraanLamaRawat'] = $key['PerkiraanLamaRawat'];
                $pasing['RS_KamarPerawatan'] = $key['RS_KamarPerawatan'];
                $pasing['RS_KamarIntensive'] = $key['RS_KamarIntensive'];
                $pasing['RS_Lab'] = $key['RS_Lab'];
                $pasing['RS_Radiologi'] = $key['RS_Radiologi'];
                $pasing['RS_Farmasi'] = $key['RS_Farmasi'];
                $pasing['RS_BHP'] = $key['RS_BHP'];
                $pasing['RS_Administrasi'] = $key['RS_Administrasi'];
                $pasing['JD_VisiteDPJP'] = $key['JD_VisiteDPJP'];
                $pasing['JD_VisiteIntesive'] = $key['JD_VisiteIntesive'];
                $pasing['JD_VisiteKonsulAnestesi'] = $key['JD_VisiteKonsulAnestesi'];
                $pasing['JD_VisiteKonsulInternis'] = $key['JD_VisiteKonsulInternis'];
                $pasing['uuid4'] = $key['DocTransactionID'];
                $pasing['NamaWaliPasien'] = $key['NamaWaliPasien'];
                $pasing['NIK'] = $key['NIK'];
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

    public function savePerkiraanbiayaOP($data,$ttdpasien_aws)
    {
        
        $NoEpisode = $data['NoEpisode'];
        $Noregis = $data['Noregis'];
        $layanan = $data['layanan'];
        $xnoMedrec = $data['xnoMedrec'];
        $dpjp = $data['dpjp'];
        $xNamaPasien = $data['xNamaPasien'];
        $xjaminan = $data['xjaminan'];
        $xTglLahir = $data['xTglLahir'];
        $JenisKelamin = $data['JenisKelamin'];
        $pasien_nomr = $data['pasien_nomr'];
        $pasien_nama = $data['pasien_nama'];
        $pasien_rencanakeperawatan = $data['pasien_rencanakeperawatan'];
        $pasien_diagnosa = $data['pasien_diagnosa'];
        $pasien_tindakan = $data['pasien_tindakan'];
        $pasien_droperator = $data['pasien_droperator'];
        if (!isset($data['pasien_kamarperawatan'])){
            $pasien_kamarperawatan = null;
        }else{
            $pasien_kamarperawatan = $data['pasien_kamarperawatan'];
        }
        $pasien_kelas = $data['kelasname'];
        $pasien_perkiraanlamarawat = $data['pasien_perkiraanlamarawat'];
        $namawali = $data['namawali'];
        $nik = $data['nik'];
        $jd_drop = str_replace(".", "", $data['jd_drop']);
        $jd_drassop = str_replace(".", "", $data['jd_drassop']);
        $jd_dranestesi = str_replace(".", "", $data['jd_dranestesi']);
        $sewakamar = str_replace(".", "", $data['sewakamar']);
        $alkesbhp = str_replace(".", "", $data['alkesbhp']);
        $lainlain = str_replace(".", "", $data['lainlain']);
        $saksi_rumah_sakit = $data['saksi_rumah_sakit'];
        $saksi_pasien = $data['saksi_pasien'];
        $nohp_send = $data['nohp_send'];
        $email_send = $data['email_send'];
        $namaparam1 = $data['namaparam1'];
        $usercreate = $data['usercreate'];
        $namapetugas_ext = $data['namapetugas_ext'];
        $idpetugas_ext = $data['idpetugas_ext'];
        $jd_drop_ket = $data['jd_drop_ket'];
        $jd_drassop_ket = $data['jd_drassop_ket'];
        $jd_dranestesi_ket = $data['jd_dranestesi_ket'];
        $sewakamar_ket = $data['sewakamar_ket'];
        $alkesbhp_ket = $data['alkesbhp_ket'];
        $lainlain_ket = $data['lainlain_ket'];
        $keterangan_lainnya = $data['keterangan_lainnya'];
        $querys = "INSERT INTO Billing_Pasien.[dbo].[TDocumentEsitimatedOperationgCosts]
        (
            DocTransactionID
            ,NoRegistrasi
            ,NoEpisode
            ,NoMR
            ,NamaPasien
            ,TglCreate
            ,RencanaPerawatan
            ,DiagnosaMedis
            ,DPJP
            ,KamaPerawatan
            ,Kelas
            ,PerkiraanLamaRawat
            ,JD_Operator
            ,JD_AssistenOperator
            ,JD_Anestesi
            ,SewaKamarOperasi
            ,AlkesDanBHP
            ,Lainlain
            ,NamaWaliPasien
            ,NIK
            ,Tindakan
            ,DrOperator
            ,[Petugas]
            ,[Divisi]
            ,PetugasTTD_ID
            ,JD_Operator_ket
            ,JD_AssistenOperator_ket
            ,JD_Anestesi_ket
            ,SewaKamarOperasi_ket
            ,AlkesDanBHP_ket
            ,Lainlain_ket
            ,KeteranganLainnya
            ,TTD_PasienWali
            ,EmailSend
            ,NoHPSend
        )
  VALUES
        (
             :uuid
            ,:Noregis
            ,:NoEpisode
            ,:pasien_nomr
            ,:pasien_nama
            ,:TglCreate
            ,:pasien_rencanakeperawatan
            ,:pasien_diagnosa
            ,:dpjp
            ,:pasien_kamarperawatan
            ,:pasien_kelas
            ,:pasien_perkiraanlamarawat
            ,:jd_drop
            ,:jd_drassop
            ,:jd_dranestesi
            ,:sewakamar
            ,:alkesbhp
            ,:lainlain
            ,:namawali
            ,:nik
            ,:pasien_tindakan
            ,:pasien_droperator
            ,:petugas
            ,:divisi
            ,:idpetugas_ext
            ,:jd_drop_ket
            ,:jd_drassop_ket
            ,:jd_dranestesi_ket
            ,:sewakamar_ket
            ,:alkesbhp_ket
            ,:lainlain_ket
            ,:keterangan_lainnya
            ,:ttdpasien_aws
            ,:email_send
            ,:nohp_send
        )
             ";

        try {
            $this->db->transaksi();

            $session = SessionManager::getCurrentSession();
            $userlogin = $session->IDEmployee;
            $namauserx = $session->name;
            $datenowcreate= Utils::seCurrentDateTime();
            $uuid = Utils::uuid4str();
            $DocumentType = 'BIAYA_OPERASI';


            $query = "UPDATE a
              SET Active='0' 
              FROM Billing_Pasien.dbo.TDocumentMasters a
              inner join Billing_Pasien.dbo.TDocumentEsitimatedOperationgCosts b on a.Uuid=b.DocTransactionID
              WHERE NoRegistrasi=:NoRegistrasi and a.DocumentType=:DocumentType
              ";
                $this->db->query($query);
                $this->db->bind('NoRegistrasi', $Noregis); 
                $this->db->bind('DocumentType', $DocumentType); 
                $this->db->execute();

            $query = "INSERT INTO Billing_Pasien.dbo.TDocumentMasters (Uuid,DateCreate,UserCreate,DocumentType,NamaTTD1,NamaTTD2)
                Values
            (:uuid,:datenowcreate,:userlogin,:DocumentType,:namaparam,:namaparam2)";
                $this->db->query($query);
                $this->db->bind('uuid', $uuid);
                $this->db->bind('datenowcreate', $datenowcreate);
                $this->db->bind('userlogin', $userlogin);
                $this->db->bind('DocumentType', $DocumentType);
                $this->db->bind('namaparam', $data['usercreate']);
                $this->db->bind('namaparam2', $data['namaparam1']);
                $this->db->execute();

            $query = "UPDATE Billing_Pasien.dbo.TDocumentEsitimatedOperationgCosts SET ActiveDocument='0' WHERE NoRegistrasi=:NoRegistrasi
            ";
            $this->db->query($query);
            $this->db->bind('NoRegistrasi', $Noregis); 
            $this->db->execute();

            $this->db->query($querys); 

            $this->db->bind('uuid', $uuid );
            $this->db->bind('Noregis', $Noregis );
            $this->db->bind('NoEpisode', $NoEpisode );
            $this->db->bind('pasien_nomr', $pasien_nomr );
            $this->db->bind('pasien_nama', $pasien_nama );
            $this->db->bind('TglCreate', $datenowcreate );
            $this->db->bind('pasien_rencanakeperawatan', $pasien_rencanakeperawatan );
            $this->db->bind('pasien_diagnosa', $pasien_diagnosa );
            $this->db->bind('dpjp', $dpjp );
            $this->db->bind('pasien_kamarperawatan', $pasien_kamarperawatan );
            $this->db->bind('pasien_kelas', $pasien_kelas );
            $this->db->bind('pasien_perkiraanlamarawat', $pasien_perkiraanlamarawat );
            $this->db->bind('jd_drop', $jd_drop );
            $this->db->bind('jd_drassop', $jd_drassop );
            $this->db->bind('jd_dranestesi', $jd_dranestesi );
            $this->db->bind('sewakamar', $sewakamar );
            $this->db->bind('alkesbhp', $alkesbhp );
            $this->db->bind('lainlain', $lainlain );
            $this->db->bind('namawali', $namawali );
            $this->db->bind('nik', $nik );
            $this->db->bind('pasien_tindakan', $pasien_tindakan );
            $this->db->bind('pasien_droperator', $pasien_droperator );
            $this->db->bind('petugas', $namapetugas_ext);
            $this->db->bind('divisi', 'Admission & Billing');
            $this->db->bind('idpetugas_ext', $idpetugas_ext);
            $this->db->bind('jd_drop_ket', $jd_drop_ket);
            $this->db->bind('jd_drassop_ket', $jd_drassop_ket);
            $this->db->bind('jd_dranestesi_ket', $jd_dranestesi_ket);
            $this->db->bind('sewakamar_ket', $sewakamar_ket);
            $this->db->bind('alkesbhp_ket', $alkesbhp_ket);
            $this->db->bind('lainlain_ket', $lainlain_ket);
            $this->db->bind('keterangan_lainnya', $keterangan_lainnya);
            $this->db->bind('nohp_send', $data['nohp_send']); 
            $this->db->bind('email_send', $data['email_send']); 
            $this->db->bind('ttdpasien_aws', $ttdpasien_aws); 
             
            $this->db->execute();
            $this->db->Commit();
            $getID = $this->db->GetLastID();
            //return $this->response(200, 'Tanda Tangan Berhasi di simpan');
            $callback = [
                'status' => 200,
                'message' => 'Tanda Tangan Berhasi di simpan',
                'data' => $getID,
            ];
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            return $this->response(400, $e);
        }
    }

    public function uploadToAwsSignPerkiraanbiayaOP($data)
    {
        $s3Client = new S3Client([
            'version' => 'latest',
            'region'  => 'ap-southeast-1',
            'http'    => ['verify' => false],
            'credentials' => [
                'key'    => 'AKIAYV2M6ERJGUKK4QWQ',
                'secret' => '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'
            ]
        ]);
            // $filename1 = __DIR__ . '/../../public' . '/images/signature/' . $data['uuid1']. '.png';
            // $source1 =   $filename1;
            // $awsImages = '';
            // $handle = fopen($source1, 'r');

            $awsImages = $data['path1'];
            $filename1 = null;

            $filename2 = __DIR__ . '/../../public' . '/images/signature/' . $data['uuid2']. '.png';
            $source2 =   $filename2;
            $awsImages2 = '';
            $handle2 = fopen($source2, 'r');

         try {
                // // TTD 1
                //     $bucket = 'rsuyarsibucket';
                //     $key = basename($filename1);
                //     $result = $s3Client->putObject([
                //         'Bucket' => $bucket,
                //         'Key'    => 'digitalfiles/dgitalSignPatient/' . $key,
                //         'Body'   => $handle,
                //         'ACL'    => 'public-read', // make file 'public', 
                //     ]);
                //     $awsImages = $result->get('ObjectURL');
                //     fclose($handle);
                    

                    // TTD 2
                    $bucket2 = 'rsuyarsibucket';
                    $key2 = basename($filename2);
                    $result2 = $s3Client->putObject([
                        'Bucket' => $bucket2,
                        'Key'    => 'digitalfiles/dgitalSignPatient/' . $key2,
                        'Body'   => $handle2,
                        'ACL'    => 'public-read', // make file 'public', 
                    ]);
                    $awsImages2 = $result2->get('ObjectURL');
                    fclose($handle2);
                    unlink($_SERVER["DOCUMENT_ROOT"].'SIKBREC/public/images/signature/'.$data['uuid2']. '.png');
                    // unlink($_SERVER["DOCUMENT_ROOT"].'SIKBREC/public/images/signature/'.$data['uuid1']. '.png');
                    return $this->SaveTTDDigital($data, $data['uuid2'], $filename1, $awsImages,$awsImages2,"PERKIRAAN BIAYA OP");

         } catch (MultipartUploadException $e) {
            return $e->getMessage();
         } 
    }

    public function getDataHistoryBiayaOP($data)
    {
        try {
            $nomr =  $data['nomr'];

            $this->db->query("SELECT * 
            FROM Billing_Pasien.dbo.TDocumentEsitimatedOperationgCosts WHERE NoMR=:nomr and ActiveDocument='1'
            ORDER BY 1 DESC");
            $this->db->bind('nomr', $nomr);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 0;
            foreach ($data as $key) {
                $no++;
                $pasing['no'] = $no;
                $pasing['TglCreate_sign'] = date('d/m/Y', strtotime($key['TglCreate']));
                $pasing['ID'] = $key['ID'];
                $pasing['DocTransactionID'] = $key['DocTransactionID'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['NoEpisode'] = $key['NoEpisode'];
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['NamaPasien'] = $key['NamaPasien'];
                $pasing['AwsUrlDocuments'] = $key['AwsUrlDocuments'];
                //$pasing['TglCreate'] = $key['TglCreate'];
                $pasing['RencanaPerawatan'] = $key['RencanaPerawatan'];
                $pasing['DiagnosaMedis'] = $key['DiagnosaMedis'];
                $pasing['DPJP'] = $key['DPJP'];
                $pasing['KamaPerawatan'] = $key['KamaPerawatan'];
                $pasing['Kelas'] = $key['Kelas'];
                $pasing['PerkiraanLamaRawat'] = $key['PerkiraanLamaRawat'];
                $pasing['JD_Operator'] = $key['JD_Operator'];
                $pasing['JD_AssistenOperator'] = $key['JD_AssistenOperator'];
                $pasing['JD_Anestesi'] = $key['JD_Anestesi'];
                $pasing['SewaKamarOperasi'] = $key['SewaKamarOperasi'];
                $pasing['AlkesDanBHP'] = $key['AlkesDanBHP'];
                $pasing['Lainlain'] = $key['Lainlain'];
                $pasing['ActiveDocument'] = $key['ActiveDocument'];
                $pasing['NamaWaliPasien'] = $key['NamaWaliPasien'];
                $pasing['NIK'] = $key['NIK'];
                $pasing['Tindakan'] = $key['Tindakan'];
                $pasing['DrOperator'] = $key['DrOperator'];
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

    public function getCopyDiagnosa($data)
    {
        try {

            $this->db->query("SELECT DiagnosaAwal,ID,JenisRawat,LamaRawat,DokterDPJP
             from MedicalRecord.dbo.MR_PermintaanRawat where NoRegistrasi=:notrs and Batal='0'");
            $this->db->bind('notrs', $data['notrs']);
            $data =  $this->db->single();

            $pasing['ID'] = $data['ID'];
            $pasing['A_Diagnosa'] = $data['DiagnosaAwal'];
            $pasing['JenisRawat'] = $data['JenisRawat'];
            $pasing['LamaRawat'] = $data['LamaRawat'];
            $pasing['DokterDPJP'] = $data['DokterDPJP'];

            $callback = [
                'status' => 200,
                'data' => $pasing,
            ];
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataHistoryPersetujuanBiaya($data)
    {
        try {
            $nomr =  $data['nomr'];

            $this->db->query("SELECT * 
            FROM Billing_Pasien.dbo.TDocumentApprovalTreatmentCosts WHERE NoMR=:nomr and ActiveDocument='1'
            ORDER BY 1 DESC");
            $this->db->bind('nomr', $nomr);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 0;
            foreach ($data as $key) {
                $no++;
                $pasing['no'] = $no;
                $pasing['ID'] = $key['ID'];
                $pasing['DocTransactionID'] = $key['DocTransactionID'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['NoEpisode'] = $key['NoEpisode'];
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['NamaPasien'] = $key['NamaPasien'];
                $pasing['AwsUrlDocuments'] = $key['AwsUrlDocuments'];
                $pasing['TglCreate_sign'] = date('d/m/Y', strtotime($key['TglCreate']));
                $pasing['ActiveDocument'] = $key['ActiveDocument'];
                $pasing['NamaWaliPasien'] = $key['NamaWaliPasien'];
                $pasing['NIK'] = $key['NIK'];
                $pasing['HubunganDenganPasien'] = $key['HubunganDenganPasien'];
                $pasing['RencanaTindakan'] = $key['RencanaTindakan'];
                $pasing['EstimasiBiaya'] = $key['EstimasiBiaya'];
                $pasing['Kelas'] = $key['Kelas'];
                $pasing['Ruangan'] = $key['Ruangan'];
                $pasing['Petugas'] = $key['Petugas'];
                $pasing['Divisi'] = $key['Divisi'];
                $pasing['PetugasTTD_ID'] = $key['PetugasTTD_ID'];
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

    public function savePersetujuanBiaya($data,$ttdpasien_aws)
    {
        
        $estimasibiaya = str_replace(".", "", $data['estimasi_biaya']);
        $querys = "INSERT INTO Billing_Pasien.[dbo].[TDocumentApprovalTreatmentCosts]
        (
            DocTransactionID
            ,NoRegistrasi
            ,NoEpisode
            ,NoMR
            ,NamaPasien
            ,TglCreate
            ,NamaWaliPasien
            ,NIK
            ,HubunganDenganPasien
            ,RencanaTindakan
            ,EstimasiBiaya
            ,Kelas
            ,NamaKelas
            ,Ruangan
            ,Petugas
            ,Divisi
            ,PetugasTTD_ID
            ,TTD_PasienWali
            ,EmailSend
            ,NoHPSend
        )
  VALUES
        (
        :uuid,
        :NoRegistrasi, 
        :NoEpisode, 
        :NoRMPasien, 
        :NamaPasien, 
        :TglCreate,
        :namawali, 
        :nik,
        :hubungan_dgnpasien,
        :rencana_tindakan,
        :estimasi_biaya,
        :pasien_kelas,
        :pasien_kelas_nama,
        :ruangan,
        :petugas, 
        :divisi,
        :idpetugas_ext,
        :ttdpasien_aws,
        :email_send,
        :nohp_send
        )
             ";

        try {
            $this->db->transaksi();

            $session = SessionManager::getCurrentSession();
            $userlogin = $session->IDEmployee;
            $namauserx = $session->name;
            $datenowcreate= Utils::seCurrentDateTime();
            $uuid = Utils::uuid4str();
            $DocumentType = 'PERSETUJUAN_BIAYA';

            $query = "UPDATE a
              SET Active='0' 
              FROM Billing_Pasien.dbo.TDocumentMasters a
              inner join Billing_Pasien.dbo.TDocumentApprovalTreatmentCosts b on a.Uuid=b.DocTransactionID
              WHERE NoRegistrasi=:NoRegistrasi and a.DocumentType=:DocumentType
              ";
                $this->db->query($query);
                $this->db->bind('NoRegistrasi', $data['noregistrasi']); 
                $this->db->bind('DocumentType', $DocumentType); 
                $this->db->execute();

            $query = "INSERT INTO Billing_Pasien.dbo.TDocumentMasters (Uuid,DateCreate,UserCreate,DocumentType,NamaTTD1,NamaTTD2)
                Values
            (:uuid,:datenowcreate,:userlogin,:DocumentType,:namaparam,:namaparam2)";
                $this->db->query($query);
                $this->db->bind('uuid', $uuid);
                $this->db->bind('datenowcreate', $datenowcreate);
                $this->db->bind('userlogin', $userlogin);
                $this->db->bind('DocumentType', $DocumentType);
                $this->db->bind('namaparam', $data['namapetugas_ext']);
                $this->db->bind('namaparam2', $data['namaparam1']);
                $this->db->execute();

            $query = "UPDATE Billing_Pasien.dbo.TDocumentApprovalTreatmentCosts SET ActiveDocument='0' WHERE NoRegistrasi=:NoRegistrasi
            ";
            $this->db->query($query);
            $this->db->bind('NoRegistrasi', $data['noregistrasi']); 
            $this->db->execute();

            $this->db->query($querys);  
            $this->db->bind('uuid', $uuid); 
            $this->db->bind('NoRegistrasi', $data['noregistrasi']); 
            $this->db->bind('NoEpisode', $data['NoEpisode']);
            $this->db->bind('TglCreate', date("Y-m-d H:i:s"));
            $this->db->bind('NamaPasien', $data['namapasien']);
            $this->db->bind('NoRMPasien', $data['norm']);
            $this->db->bind('namawali', $data['namawali']);
            $this->db->bind('nik', $data['nik']);
            $this->db->bind('petugas', $data['namapetugas_ext']);
            $this->db->bind('divisi', 'Admission & Billing');
            $this->db->bind('idpetugas_ext', $data['idpetugas_ext']);
            $this->db->bind('hubungan_dgnpasien', $data['hubungan_dgnpasien']);
            $this->db->bind('rencana_tindakan', $data['rencana_tindakan']);
            $this->db->bind('estimasi_biaya', $estimasibiaya);
            $this->db->bind('pasien_kelas', $data['pasien_kelas']);
            $this->db->bind('pasien_kelas_nama', $data['pasien_kelas_nama']);
            $this->db->bind('ruangan', $data['ruangan']);
            $this->db->bind('nohp_send', $data['nohp_send']); 
            $this->db->bind('email_send', $data['email_send']); 
            $this->db->bind('ttdpasien_aws', $ttdpasien_aws); 
             
            $this->db->execute();
            $this->db->Commit();
            $getID = $this->db->GetLastID();
            //return $this->response(200, 'Tanda Tangan Berhasi di simpan');
            $callback = [
                'status' => 200,
                'message' => 'Tanda Tangan Berhasi di simpan',
                'data' => $getID,
            ];
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            return $this->response(400, $e);
        }
    }

    public function uploadToAwsSignPersetujuanBiaya($data)
    {
        $s3Client = new S3Client([
            'version' => 'latest',
            'region'  => 'ap-southeast-1',
            'http'    => ['verify' => false],
            'credentials' => [
                'key'    => 'AKIAYV2M6ERJGUKK4QWQ',
                'secret' => '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'
            ]
        ]);

            $awsImages = $data['path1'];
            $filename1 = null;

            $filename2 = __DIR__ . '/../../public' . '/images/signature/' . $data['uuid2']. '.png';
            $source2 =   $filename2;
            $awsImages2 = '';
            $handle2 = fopen($source2, 'r');

         try {

                    // TTD 2
                    $bucket2 = 'rsuyarsibucket';
                    $key2 = basename($filename2);
                    $result2 = $s3Client->putObject([
                        'Bucket' => $bucket2,
                        'Key'    => 'digitalfiles/dgitalSignPatient/' . $key2,
                        'Body'   => $handle2,
                        'ACL'    => 'public-read', // make file 'public', 
                    ]);
                    $awsImages2 = $result2->get('ObjectURL');
                    fclose($handle2);
                    unlink($_SERVER["DOCUMENT_ROOT"].'SIKBREC/public/images/signature/'.$data['uuid2']. '.png');
                    // unlink($_SERVER["DOCUMENT_ROOT"].'SIKBREC/public/images/signature/'.$data['uuid1']. '.png');
                    return $this->SaveTTDDigital($data, $data['uuid2'], $filename1, $awsImages,$awsImages2,"PERSETUJUAN BIAYA");

         } catch (MultipartUploadException $e) {
            return $e->getMessage();
         } 
    }

    public function getDataHistoryPersetujuanSelisih($data)
    {
        try {
            $nomr =  $data['nomr'];

            $this->db->query("SELECT * 
            FROM Billing_Pasien.dbo.TDocumentApprovalCostDifferents WHERE NoMR=:nomr and ActiveDocument='1'
            ORDER BY 1 DESC");
            $this->db->bind('nomr', $nomr);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 0;
            foreach ($data as $key) {
                $no++;
                $pasing['no'] = $no;
                $pasing['TglCreate_sign'] = date('d/m/Y', strtotime($key['TglCreate']));
                $pasing['ID'] = $key['ID'];
                $pasing['DocTransactionID'] = $key['DocTransactionID'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['NoEpisode'] = $key['NoEpisode'];
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['NamaPasien'] = $key['NamaPasien'];
                $pasing['AwsUrlDocuments'] = $key['AwsUrlDocuments'];
                $pasing['ActiveDocument'] = $key['ActiveDocument'];
                $pasing['NamaWaliPasien'] = $key['NamaWaliPasien'];
                $pasing['NIK'] = $key['NIK'];
                $pasing['HubunganDenganPasien'] = $key['HubunganDenganPasien'];
                $pasing['NoTelp'] = $key['NoTelp'];
                $pasing['Petugas'] = $key['Petugas'];
                $pasing['Divisi'] = $key['Divisi'];
                $pasing['PetugasTTD_ID'] = $key['PetugasTTD_ID'];
                $pasing['TTD_PasienWali'] = $key['TTD_PasienWali'];
                $pasing['EmailSend'] = $key['EmailSend'];
                $pasing['NoHPSend'] = $key['NoHPSend'];
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

    public function savePersetujuanSelisih($data,$ttdpasien_aws)
    {
        date_default_timezone_set('Asia/Jakarta');
        $datenow   = new DateTime('today');
        $dob   = new DateTime($data['tgllahir_pasien']);
        $age = $dob->diff($datenow)->y;
        $querys = "INSERT INTO Billing_Pasien.[dbo].[TDocumentApprovalCostDifferents]
        (
            DocTransactionID
            ,NoRegistrasi
            ,NoEpisode
            ,NoMR
            ,NamaPasien
            ,NamaPenjamin
            ,JenisKelamin
            ,Usia
            ,Alamat
            ,NoTelp_Pasien
            ,TglCreate
            ,NamaWaliPasien
            ,NIK
            ,HubunganDenganPasien
            ,NoTelp
            ,Petugas
            ,Divisi
            ,PetugasTTD_ID
            ,TTD_PasienWali
            ,EmailSend
            ,NoHPSend
        )
  VALUES
        (
        :uuid,
        :NoRegistrasi, 
        :NoEpisode, 
        :NoRMPasien, 
        :NamaPasien, 
        :namapenjamin_pasien,
        :gender_pasien,
        :age,
        :alamat_pasien,
        :nohp_pasien,
        :TglCreate,
        :namawali, 
        :nik,
        :hubungan_dgnpasien,
        :nohp_pjpasien,
        :petugas, 
        :divisi,
        :idpetugas_ext,
        :ttdpasien_aws,
        :email_send,
        :nohp_send
        )
             ";

        try {
            $this->db->transaksi();

            $session = SessionManager::getCurrentSession();
            $userlogin = $session->IDEmployee;
            $namauserx = $session->name;
            $datenowcreate= Utils::seCurrentDateTime();
            $uuid = Utils::uuid4str();
            $DocumentType = 'PERSETUJUAN_SELISIH';

            $query = "UPDATE a
              SET Active='0' 
              FROM Billing_Pasien.dbo.TDocumentMasters a
              inner join Billing_Pasien.dbo.TDocumentApprovalCostDifferents b on a.Uuid=b.DocTransactionID
              WHERE NoRegistrasi=:NoRegistrasi and a.DocumentType=:DocumentType
              ";
                $this->db->query($query);
                $this->db->bind('NoRegistrasi', $data['noregistrasi']); 
                $this->db->bind('DocumentType', $DocumentType); 
                $this->db->execute();

            $query = "INSERT INTO Billing_Pasien.dbo.TDocumentMasters (Uuid,DateCreate,UserCreate,DocumentType,NamaTTD1,NamaTTD2)
                Values
            (:uuid,:datenowcreate,:userlogin,:DocumentType,:namaparam,:namaparam2)";
                $this->db->query($query);
                $this->db->bind('uuid', $uuid);
                $this->db->bind('datenowcreate', $datenowcreate);
                $this->db->bind('userlogin', $userlogin);
                $this->db->bind('DocumentType', $DocumentType);
                $this->db->bind('namaparam', $data['namapetugas_ext']);
                $this->db->bind('namaparam2', $data['namaparam1']);
                $this->db->execute();

            $query = "UPDATE Billing_Pasien.dbo.TDocumentApprovalCostDifferents SET ActiveDocument='0' WHERE NoRegistrasi=:NoRegistrasi
            ";
            $this->db->query($query);
            $this->db->bind('NoRegistrasi', $data['noregistrasi']); 
            $this->db->execute();

            $this->db->query($querys);  
            $this->db->bind('uuid', $uuid); 
            $this->db->bind('NoRegistrasi', $data['noregistrasi']); 
            $this->db->bind('NoEpisode', $data['NoEpisode']);
            $this->db->bind('TglCreate', date("Y-m-d H:i:s"));
            $this->db->bind('NamaPasien', $data['namapasien']);
            $this->db->bind('NoRMPasien', $data['norm']);
            $this->db->bind('namawali', $data['namawali']);
            $this->db->bind('nik', $data['nik']);
            $this->db->bind('petugas', $data['namapetugas_ext']);
            $this->db->bind('divisi', 'Admission & Billing');
            $this->db->bind('idpetugas_ext', $data['idpetugas_ext']);
            $this->db->bind('hubungan_dgnpasien', $data['hubungan_dgnpasien']);
            $this->db->bind('nohp_pjpasien', $data['nohp_pjpasien']);
            $this->db->bind('nohp_send', $data['nohp_send']); 
            $this->db->bind('email_send', $data['email_send']); 
            $this->db->bind('ttdpasien_aws', $ttdpasien_aws); 
            $this->db->bind('namapenjamin_pasien', $data['namapenjamin_pasien']);
            $this->db->bind('age', $age);
            $this->db->bind('gender_pasien', $data['gender_pasien']);
            $this->db->bind('alamat_pasien', $data['alamat_pasien']);
            $this->db->bind('nohp_pasien', $data['nohp_pasien']);
             
            $this->db->execute();
            $this->db->Commit();
            $getID = $this->db->GetLastID();
            //return $this->response(200, 'Tanda Tangan Berhasi di simpan');
            $callback = [
                'status' => 200,
                'message' => 'Tanda Tangan Berhasi di simpan',
                'data' => $getID,
            ];
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            return $this->response(400, $e);
        }
    }


}
