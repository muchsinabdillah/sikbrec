<?php
use Aws\Exception\MultipartUploadException;
use Aws\S3\S3Client;

class  B_InformationResumeMedis_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getDataListPasien($data)
    {
        try {
            $tglawal = $data['TglAwal'];
            $tglakhir = $data['TglAkhir'];
            $TipeResume = $data['TipeResume'];

            if ($TipeResume == '4') {
                $this->db->query("SELECT ID,Jenis_Resume_Medis,
            replace(CONVERT(VARCHAR(11),Tgl_Transaksi, 111), '/','-')  as Tgl_Transaksi,Jam_Transaksi,petugas,
            replace(CONVERT(VARCHAR(11),Tgl_Berobat, 111), '/','-') Tgl_Berobat,
            replace(CONVERT(VARCHAR(11),Tgl_Pulang, 111), '/','-') Tgl_Pulang,No_MR,No_Episode,No_Registrasi,Nama_Pasien
            ,Tgl_lahir,Jenis_Kelamin,Jaminan,keluhan_Utama,H_Penunjang,treatment,Diagnosa_Awal,Diagnosa_Akhir,Obat_obatan,
            Anjuran,Tindak_Lanjut,Rujuk_Dokter,
            Alasan_Dirujuk_Dokter,Alasan_Dirawat_Inap,Riwayat_Penyakit,Dokter_Merawat,
            CASE 
            WHEN Kondisi_pasien='1' THEN 'SEMBUH' 
            WHEN Kondisi_pasien='2' then 'MENINGGOY' 
            WHEN Kondisi_pasien='3' then 'LAIN-LAIN' 
            ELSE 'TIDAK TAHU' 
            END AS STUATUSPULANG
            ,Kondisi_pasien,komordibitas
            FROM MedicalRecord.DBO.MR_Resume_Medis
            WHERE replace(CONVERT(VARCHAR(11),Tgl_Pulang, 111), '/','-')
            BETWEEN :tglawal AND :tglakhir 
            and No_MR is not null and No_Episode is not null and No_Registrasi is not null
             ");
            } else {
                $this->db->query("SELECT ID,Jenis_Resume_Medis,
            replace(CONVERT(VARCHAR(11),Tgl_Transaksi, 111), '/','-')  as Tgl_Transaksi,Jam_Transaksi,petugas,
            replace(CONVERT(VARCHAR(11),Tgl_Berobat, 111), '/','-') Tgl_Berobat,
            replace(CONVERT(VARCHAR(11),Tgl_Pulang, 111), '/','-') Tgl_Pulang,No_MR,No_Episode,No_Registrasi,Nama_Pasien
            ,Tgl_lahir,Jenis_Kelamin,Jaminan,keluhan_Utama,H_Penunjang,treatment,Diagnosa_Awal,Diagnosa_Akhir,Obat_obatan,
            Anjuran,Tindak_Lanjut,Rujuk_Dokter,
            Alasan_Dirujuk_Dokter,Alasan_Dirawat_Inap,Riwayat_Penyakit,Dokter_Merawat,
            CASE 
            WHEN Kondisi_pasien='1' THEN 'SEMBUH' 
            WHEN Kondisi_pasien='2' then 'MENINGGOY' 
            WHEN Kondisi_pasien='3' then 'LAIN-LAIN' 
            ELSE 'TIDAK TAHU' 
            END AS STUATUSPULANG
            ,Kondisi_pasien,komordibitas
            FROM MedicalRecord.DBO.MR_Resume_Medis
            WHERE replace(CONVERT(VARCHAR(11),Tgl_Pulang, 111), '/','-')
            BETWEEN :tglawal AND :tglakhir and Kondisi_pasien=:tipeResume
            and No_MR is not null and No_Episode is not null and No_Registrasi is not null
                ");
                $this->db->bind('tipeResume', $TipeResume);
            }
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            // $key =  $this->db->single();
            // $pasing['ID'] = $key['ID'];
            // $pasing['Jenis_Resume_Medis'] = $key['Jenis_Resume_Medis'];
            // $pasing['Tgl_Berobat'] = date('d/m/Y', strtotime($key['Tgl_Berobat']));
            // $pasing['Tgl_Pulang'] = date('d/m/Y', strtotime($key['Tgl_Pulang']));
            // $pasing['No_MR'] = $key['No_MR'];
            // $pasing['No_Episode'] = $key['No_Episode'];
            // $pasing['No_Registrasi'] = $key['No_Registrasi'];
            // $pasing['Nama_Pasien'] = $key['Nama_Pasien'];
            // $pasing['komordibitas'] = $key['komordibitas'];
            // $pasing['Diagnosa_Awal'] = $key['Diagnosa_Awal'];
            // $pasing['Diagnosa_Akhir'] = $key['Diagnosa_Akhir'];
            // return $pasing;
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['Jenis_Resume_Medis'] = $key['Jenis_Resume_Medis'];
                $pasing['Tgl_Berobat'] = date('d/m/Y', strtotime($key['Tgl_Berobat']));
                $pasing['Tgl_Pulang'] = date('d/m/Y', strtotime($key['Tgl_Pulang']));
                $pasing['No_MR'] = $key['No_MR'];
                $pasing['No_Episode'] = $key['No_Episode'];
                $pasing['No_Registrasi'] = $key['No_Registrasi'];
                $pasing['Nama_Pasien'] = $key['Nama_Pasien'];
                $pasing['komordibitas'] = $key['komordibitas'];
                $pasing['Diagnosa_Awal'] = $key['Diagnosa_Awal'];
                $pasing['Diagnosa_Akhir'] = $key['Diagnosa_Akhir'];
                $pasing['Tgl_lahir'] = $key['Tgl_lahir'];
                $rows[] = $pasing;
            }
            return $data;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintResumeMedisbyID($data)
    {
        try {
                $query = "SELECT *,replace(CONVERT(VARCHAR(11),Tgl_Transaksi, 111), '/','-') as Tgl_Transaksi,replace(CONVERT(VARCHAR(11),Tgl_Berobat, 111), '/','-') as Tgl_Berobat,replace(CONVERT(VARCHAR(11),Tgl_Pulang, 111), '/','-') as Tgl_Pulang,
                CASE 
            WHEN Kondisi_pasien='1' THEN 'SEMBUH' 
            WHEN Kondisi_pasien='2' then 'MENINGGOY' 
            WHEN Kondisi_pasien='3' then 'LAIN-LAIN' 
            WHEN Kondisi_pasien='4' then 'DIRUJUK' 
            WHEN Kondisi_pasien='5' then 'PULANG PAKSA' 
            WHEN Kondisi_pasien='6' then 'MELARIKAN DIRI' 
            ELSE 'TIDAK TAHU' 
            END AS STUATUSPULANG,b.ID as IdUserSign
                 FROM MedicalRecord.dbo.MR_Resume_Medis a
                 left join MasterDataSQL.dbo.Employees b on a.Dokter_Merawat=b.username collate Latin1_General_CI_AS
                 WHERE a.ID=:notrs";
            $this->db->query($query);
            $this->db->bind('notrs', $data['notrs']);
            $datas =  $this->db->single();

            $pasing['ID'] = $datas['id'];
            $pasing['Jenis_Resume_Medis'] = $datas['Jenis_Resume_Medis'];
            $pasing['Tgl_Transaksi'] = $datas['Tgl_Transaksi'];
            $pasing['Jam_Transaksi'] = $datas['Jam_Transaksi'];
            $pasing['petugas'] = $datas['petugas'];
            $pasing['Tgl_Berobat'] =  ($datas['Tgl_Berobat'] != null) ? date('d/m/Y', strtotime($datas['Tgl_Berobat'])) : '';
            $pasing['Tgl_Pulang'] =  ($datas['Tgl_Pulang'] != null) ? date('d/m/Y', strtotime($datas['Tgl_Pulang'])) : '';
            $pasing['No_MR'] = $datas['No_MR'];
            $pasing['No_Episode'] = $datas['No_Episode'];
            $pasing['No_Registrasi'] = $datas['No_Registrasi'];
            $pasing['Nama_Pasien'] = $datas['Nama_Pasien'];
            $pasing['Tgl_lahir'] = $datas['Tgl_lahir'];
            $pasing['Jenis_Kelamin'] = $datas['Jenis_Kelamin'];
            $pasing['Jaminan'] = $datas['Jaminan'];
            $pasing['keluhan_Utama'] = $datas['keluhan_Utama'];
            $pasing['TTV_Gcs'] = $datas['TTV_Gcs'];
            $pasing['TTV_Bp'] = $datas['TTV_Bp'];
            $pasing['TTV_Hr'] = $datas['TTV_Hr'];
            $pasing['TTV_Rr'] = $datas['TTV_Rr'];
            $pasing['TTV_T'] = $datas['TTV_T'];
            $pasing['TTV_Others'] = $datas['TTV_Others'];
            $pasing['H_Penunjang'] = $datas['H_Penunjang'];
            $pasing['treatment'] = $datas['treatment'];
            $pasing['Diagnosa_Awal'] = $datas['Diagnosa_Awal'];
            $pasing['Diagnosa_Akhir'] = $datas['Diagnosa_Akhir'];
            $pasing['Obat_obatan'] = $datas['Obat_obatan'];
            $pasing['Anjuran'] = $datas['Anjuran'];
            $pasing['Tindak_Lanjut'] = $datas['Tindak_Lanjut'];
            $pasing['Rujuk_Dokter'] = $datas['Rujuk_Dokter'];
            $pasing['Alasan_Dirujuk_Dokter'] = $datas['Alasan_Dirujuk_Dokter'];
            $pasing['Alasan_Dirawat_Inap'] = $datas['Alasan_Dirawat_Inap'];
            $pasing['Riwayat_Penyakit'] = $datas['Riwayat_Penyakit'];
            $pasing['Tgl_Gejala'] = $datas['Tgl_Gejala'];
            $pasing['kontrol'] = $datas['kontrol'];
            $pasing['Tgl_kontrol'] = $datas['Tgl_kontrol'];
            $pasing['Fisio'] = $datas['Fisio'];
            $pasing['Fisio_Count'] = $datas['Fisio_Count'];
            $pasing['Rawat_Inap'] = $datas['Rawat_Inap'];
            $pasing['Tgl_Rawat_Inap'] = $datas['Tgl_Rawat_Inap'];
            $pasing['Operasi'] = $datas['Operasi'];
            $pasing['Tgl_Operasi'] = $datas['Tgl_Operasi'];
            $pasing['Rencana_Lain'] = $datas['Rencana_Lain'];
            $pasing['Dokter_Merawat'] = $datas['Dokter_Merawat'];
            $pasing['Kondisi_pasien'] = $datas['Kondisi_pasien'];
            $pasing['TglKontrol'] = $datas['TglKontrol'];
            $pasing['Jam'] = $datas['Jam'];
            $pasing['Poliklinik'] = $datas['Poliklinik'];
            $pasing['DokterDPJP'] = $datas['DokterDPJP'];
            $pasing['Komordibitas'] = $datas['Komordibitas'];
            $pasing['PemeriksaanFisik'] = $datas['PemeriksaanFisik'];
            $pasing['Riwayatkesehatan'] = $datas['Riwayatkesehatan'];
            $pasing['Obat_obatanPulang'] = $datas['Obat_obatanPulang'];
            $pasing['Temuan_Fisik'] = $datas['Temuan_Fisik'];
            $pasing['FirstUser'] = $datas['FirstUser'];
            $pasing['FirstDateSave1'] = $datas['FirstDateSave1'];
            $pasing['LastUser'] = $datas['LastUser'];
            $pasing['LastDateSave'] = $datas['LastDateSave'];
            $pasing['statusResume'] = $datas['statusResume'];
            $pasing['STUATUSPULANG'] = $datas['STUATUSPULANG'];
            $pasing['IdUserSign'] = $datas['IdUserSign'];

            return $pasing;
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
                        'Key'    => 'digitalfiles/resumemedis/dev/' . $key,
                        'Body'   => $handle,
                        'ACL'    => 'public-read', // make file 'public', 
                    ]);
                    $awsImages = $result->get('ObjectURL');

                    //close filenya
                    fclose($handle);
                    //hapus filenya 
                    //unlink($_SERVER["DOCUMENT_ROOT"].'SIKBREC/public/tmp/'.$nama_file);

                    return $this->SaveFile($data, $awsImages);
                } catch (MultipartUploadException $e) {

                    return $e->getMessage();
                }
    }

    public function SaveFile($data, $awsImages)
    {
        try {
            $this->db->transaksi();
            // $session = SessionManager::getCurrentSession();
             $userlogin = '';
            // $usernamelogin = $session->name;

            $datenowcreate= Utils::seCurrentDateTime();
            $uuid = $data['uuid4'];
            $DocumentType = $data['GrupTransaksi'];
            $NoRegistrasi = $data['NoRegistrasi'];
            $notrs = $data['notrs'];

              $query = "UPDATE a
              SET Active='0' 
              FROM Billing_Pasien.dbo.TDocumentMasters a
              inner join Billing_Pasien.dbo.TDocumentMedicalSummaries b on a.Uuid=b.DocTransactionID
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

                $query = "UPDATE Billing_Pasien.dbo.TDocumentMedicalSummaries SET ActiveDocument='0' WHERE NoTrs_Reff=:id";
                $this->db->query($query);
                $this->db->bind('id', $notrs);
                $this->db->execute();

                    $query = "INSERT INTO  Billing_Pasien.dbo.TDocumentMedicalSummaries (DocTransactionID,NoTrs_Reff,NoRegistrasi,AwsUrlDocuments,TglCreate,UserCreate)
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
                'aws_url' =>  $awsImages,
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
                FROM Billing_Pasien.dbo.TDocumentMedicalSummaries
                where ID=:notrs and ActiveDocument='1'";
            $this->db->query($query);
            $this->db->bind('notrs', $data['notrs']);
            $datas =  $this->db->single();

            $pasing['AwsUrlDocuments'] = $datas['AwsUrlDocuments'];
            $pasing['ID'] = $datas['ID'];

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function SendWhatsappVerification($data)
    {
        $idx = base64_decode($data['kodeResumeMEdis']);
    
        $query = "SELECT *
        FROM MedicalRecord.DBO.MR_Resume_Medis
        where ID=:notrs ";
        $this->db->query($query);
        $this->db->bind('notrs', $idx);
        $datas =  $this->db->single(); 
        $NoRegistrasi = $datas['No_Registrasi'];


        if(substr($NoRegistrasi,0,2) == "RJ"){
            $query = "SELECT select a.Doctor_1,b.First_Name , b.Mob_Phone
            from PerawatanSQL.dbo.Visit a
            inner join MasterdataSQL.dbo.Doctors b
            on a.Doctor_1 = b.ID
             where a.NoRegistrasi=:NoRegistrasi";
            $this->db->query($query);
            $this->db->bind('NoRegistrasi', $NoRegistrasi);
            $dataDR =  $this->db->single(); 
            $Mob_Phone = $dataDR['Mob_Phone'];
            $First_Name = $dataDR['First_Name'];
        }else{
            $query = "SELECT a.drPenerima,b.First_Name , b.Mob_Phone
            from RawatInapSQL.dbo.Inpatient a
            inner join MasterdataSQL.dbo.Doctors b
            on a.drPenerima = b.ID
             where a.NoRegRI=:NoRegistrasi";
            $this->db->query($query);
            $this->db->bind('NoRegistrasi', $NoRegistrasi);
            $dataDR =  $this->db->single(); 
            $Mob_Phone = $dataDR['Mob_Phone'];
            $First_Name = $dataDR['First_Name'];
        }
    
        $replacenumberhp = Utils::hp($Mob_Phone);
        $gettoken = $this->getTokenWapin(); 
        $this->sendOTPWapin($gettoken, $replacenumberhp, $data['kodeResumeMEdis'],$First_Name,'Resume Medis');
        $callback = array(
            'status' => 'success', // Set array status dengan success   
            'errorname' => 'Verifikasi Berhasil Disimpan !', // Set array status dengan success    
        );
        return $callback;




        return $NoRegistrasi;

    }
    public function getTokenWapin(){ 
            $curl = curl_init();
            $wapinx = "YXBpbW9iaWxlOmlickFZRmxvc1YwIw==";
            
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.chat.wappin.app/v1/users/login",
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
            return $JsonData['users']['0']['token'];
    }
    public function sendOTPWapin($token,$NoHandphone,$idResumeMedis,$namadokter,$JenisDocument)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.chat.wappin.app/v1/messages",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => FALSE,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "to":  "'.$NoHandphone.'",
            "type": "template",
            "template": {
                "name": "verifikasi_resume_medis",
                "namespace": "700eb891_fb62_4d15_8d30_d493e38bbfc9", 
                "language": {
                    "policy": "deterministic",
                    "code": "id"
                },
                "components": [
                    {
                        "type": "body",
                        "parameters": [
                            {
                                "type": "text",
                                "text": "'.$namadokter.'"
                            } , {
                                "type": "text",
                                "text": "'.$JenisDocument.'"
                            }  
                        ]
                    } ,
                    {
                        "type": "button",
                        "sub_type": "URL",
                        "index": "0",
                        "parameters": [
                            {
                                "type": "text",
                                "text": "'.$idResumeMedis.'"
                            }  
                        ]
                    } 
                ]
            }
        }',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$token,
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);
        $JsonData = json_decode($response, TRUE);
        curl_close($curl); 
        return $JsonData;
    }
}
