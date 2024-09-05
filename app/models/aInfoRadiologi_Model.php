<?php
use Aws\Exception\MultipartUploadException;
use Aws\S3\S3Client;

class aInfoRadiologi_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }


    //data list sesus filter
    public function getDataInfoRadiologi($data)
    {

        try {
            $tglawal = $data['TglAwal'];
            $tglakhir = $data['TglAkhir'];

            $this->db->query("SELECT a.ACCESSION_NO,B.NoEpisode,B.NoRegistrasi,replace(CONVERT(VARCHAR(11), A.ORDER_DATE, 111), '/','-')  as ORDER_DATE, A.PaymentStatus,B.NoMR,A.PATIENT_NAME, C.NamaUnit,A.REQUESTED_PROC_DESC,A.DIAGNOSIS,A.Posisition,
            A.Side,A.Note
            ,D.First_Name as DokterOrder,E.First_Name AS DokterRadiologi,
            CASE WHEN A.IsVerifikasi='0' THEN 'BELUM VERIFIKASI' ELSE 'SUDAH VERIFIKASI' END AS StausVerifikasi,'UMUM' AS NamaPerusahaan,WOID
            ,CONVERT(VARCHAR(8),A.ORDER_DATE,114) as JamOrder,F.TypePatient,A.SCHEDULED_MODALITY,A.PATIENT_LOCATION
            FROM RadiologiSQL.dbo.WO_RADIOLOGY a 
            INNER JOIN PerawatanSQL.DBO.Visit B ON A.NOREGISTRASI = B.NoRegistrasi
            INNER JOIN MasterdataSQL.DBO.MstrUnitPerwatan C ON C.ID = B.Unit
            INNER JOIN MasterdataSQL.DBO.Doctors D ON D.ID = A.REQUEST_BY
            LEFT JOIN MasterdataSQL.DBO.Doctors E ON E.ID = A.DokterRadiologi
            inner join MasterdataSQL.dbo.MstrTypePatient F  on F.ID = B.PatientType 
            where A.Batal='0'  and F.TypePatient='UMUM' 
            AND replace(CONVERT(VARCHAR(11), A.ORDER_DATE, 111), '/','-') between :tglawal and :tglakhir
            and A.REQUESTED_PROC_DESC not like 'ekg' and A.REQUESTED_PROC_DESC not like 'treadmill' and A.REQUESTED_PROC_DESC not like 'Audiometri' and a.IsVerifikasi='1'
            UNION ALL
            SELECT a.ACCESSION_NO,B.NoEpisode,B.NoRegistrasi, replace(CONVERT(VARCHAR(11), A.ORDER_DATE, 111), '/','-')  as ORDER_DATE, A.PaymentStatus,B.NoMR,A.PATIENT_NAME, C.NamaUnit,A.REQUESTED_PROC_DESC,A.DIAGNOSIS,A.Posisition,A.Side,A.Note
            ,D.First_Name as DokterOrder,E.First_Name AS DokterRadiologi,
            CASE WHEN A.IsVerifikasi='0' THEN 'BELUM VERIFIKASI' ELSE 'SUDAH VERIFIKASI' END  AS StausVerifikasi,op.NamaPerusahaan AS NamaPerusahaan,WOID
            ,CONVERT(VARCHAR(8),A.ORDER_DATE,114) as JamOrder,F.TypePatient,A.SCHEDULED_MODALITY,A.PATIENT_LOCATION
            FROM RadiologiSQL.dbo.WO_RADIOLOGY a 
            INNER JOIN PerawatanSQL.DBO.Visit B ON A.NOREGISTRASI = B.NoRegistrasi
            INNER JOIN MasterdataSQL.DBO.MstrUnitPerwatan C ON C.ID = B.Unit
            INNER JOIN MasterdataSQL.DBO.Doctors D ON D.ID = A.REQUEST_BY
            LEFT JOIN MasterdataSQL.DBO.Doctors E ON E.ID = A.DokterRadiologi
            inner join MasterdataSQL.dbo.MstrTypePatient F  on F.ID = B.PatientType 
            inner join MasterdataSQL.dbo.MstrPerusahaanJPK op on op.ID = B.Perusahaan
            where A.Batal='0' and F.TypePatient='JAMINAN PERUSAHAAN'
            AND replace(CONVERT(VARCHAR(11), A.ORDER_DATE, 111), '/','-') between :tglawal2 and :tglakhir2
            and A.REQUESTED_PROC_DESC not like 'ekg' and A.REQUESTED_PROC_DESC not like 'treadmill' and A.REQUESTED_PROC_DESC not like 'Audiometri' and a.IsVerifikasi='1'
            UNION ALL
            SELECT  a.ACCESSION_NO,B.NoEpisode,B.NoRegistrasi,replace(CONVERT(VARCHAR(11), A.ORDER_DATE, 111), '/','-')  as ORDER_DATE, A.PaymentStatus,B.NoMR,A.PATIENT_NAME, C.NamaUnit,A.REQUESTED_PROC_DESC,A.DIAGNOSIS,A.Posisition,A.Side,A.Note
            ,D.First_Name as DokterOrder,E.First_Name AS DokterRadiologi,
            CASE WHEN A.IsVerifikasi='0' THEN 'BELUM VERIFIKASI' ELSE 'SUDAH VERIFIKASI' END AS StausVerifikasi,op.NamaPerusahaan   AS NamaPerusahaan,WOID,CONVERT(VARCHAR(8),A.ORDER_DATE,114) as JamOrder,F.TypePatient,A.SCHEDULED_MODALITY,A.PATIENT_LOCATION
            FROM RadiologiSQL.dbo.WO_RADIOLOGY a 
            INNER JOIN PerawatanSQL.DBO.Visit B ON A.NOREGISTRASI = B.NoRegistrasi
            INNER JOIN MasterdataSQL.DBO.MstrUnitPerwatan C ON C.ID = B.Unit
            INNER JOIN MasterdataSQL.DBO.Doctors D ON D.ID = A.REQUEST_BY
            LEFT JOIN MasterdataSQL.DBO.Doctors E ON E.ID = A.DokterRadiologi
            inner join MasterdataSQL.dbo.MstrTypePatient F  on F.ID = B.PatientType 
            inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi op on op.ID = b.Asuransi
            where A.Batal='0' and F.TypePatient='ASURANSI' 
            AND replace(CONVERT(VARCHAR(11), A.ORDER_DATE, 111), '/','-') between :tglawal3 and :tglakhir3
            and A.REQUESTED_PROC_DESC not like 'ekg' and A.REQUESTED_PROC_DESC not like 'treadmill' and A.REQUESTED_PROC_DESC not like 'Audiometri' and a.IsVerifikasi='1'
            UNION ALL
            SELECT a.ACCESSION_NO,B.NoEpisode,B.NoRegRI,replace(CONVERT(VARCHAR(11), A.ORDER_DATE, 111), '/','-')  as ORDER_DATE, A.PaymentStatus,B.NoMR,A.PATIENT_NAME,b.JenisRawat as NamaUnit,A.REQUESTED_PROC_DESC,A.DIAGNOSIS,A.Posisition,A.Side,A.Note
            ,D.First_Name as DokterOrder,E.First_Name AS DokterRadiologi,
            CASE WHEN A.IsVerifikasi='0' THEN 'BELUM VERIFIKASI' ELSE 'SUDAH VERIFIKASI' END  AS StausVerifikasi,'UMUM'   AS NamaPerusahaan,WOID
            ,CONVERT(VARCHAR(8),A.ORDER_DATE,114) as JamOrder,F.TypePatient,A.SCHEDULED_MODALITY,A.PATIENT_LOCATION
            FROM RadiologiSQL.dbo.WO_RADIOLOGY a 
            INNER JOIN RawatInapSQL.DBO.Inpatient B ON A.NOREGISTRASI = B.NoRegRI 
            INNER JOIN MasterdataSQL.DBO.Doctors D ON D.ID = A.REQUEST_BY
            LEFT JOIN MasterdataSQL.DBO.Doctors E ON E.ID = A.DokterRadiologi
            inner join MasterdataSQL.dbo.MstrTypePatient F  on F.ID = B.TypePatient 
            where A.Batal='0' and F.TypePatient='UMUM' 
            AND replace(CONVERT(VARCHAR(11), A.ORDER_DATE, 111), '/','-') between :tglawal4 and :tglakhir4
            and A.REQUESTED_PROC_DESC not like 'ekg' and A.REQUESTED_PROC_DESC not like 'treadmill' and A.REQUESTED_PROC_DESC not like 'Audiometri' and a.IsVerifikasi='1'
            UNION ALL
            SELECT a.ACCESSION_NO,B.NoEpisode,B.NoRegRI, replace(CONVERT(VARCHAR(11), A.ORDER_DATE, 111), '/','-')  as ORDER_DATE, A.PaymentStatus,B.NoMR,A.PATIENT_NAME, b.JenisRawat as NamaUnit,A.REQUESTED_PROC_DESC,A.DIAGNOSIS,A.Posisition,A.Side,A.Note
            ,D.First_Name as DokterOrder,E.First_Name AS DokterRadiologi,
            CASE WHEN A.IsVerifikasi='0' THEN 'BELUM VERIFIKASI' ELSE 'SUDAH VERIFIKASI' END  AS StausVerifikasi,op.NamaPerusahaan   AS NamaPerusahaan,WOID,CONVERT(VARCHAR(8),A.ORDER_DATE,114) as JamOrder,F.TypePatient,A.SCHEDULED_MODALITY,A.PATIENT_LOCATION
            FROM RadiologiSQL.dbo.WO_RADIOLOGY a 
            INNER JOIN RawatInapSQL.DBO.Inpatient B ON A.NOREGISTRASI = B.NoRegRI  
            INNER JOIN MasterdataSQL.DBO.Doctors D ON D.ID = A.REQUEST_BY
            LEFT JOIN MasterdataSQL.DBO.Doctors E ON E.ID = A.DokterRadiologi
            inner join MasterdataSQL.dbo.MstrTypePatient F  on F.ID = B.TypePatient 
            inner join MasterdataSQL.dbo.MstrPerusahaanJPK op on op.ID = B.IDJPK
            where A.Batal='0'  and F.TypePatient='JAMINAN PERUSAHAAN'
            AND replace(CONVERT(VARCHAR(11), A.ORDER_DATE, 111), '/','-') between :tglawal5 and :tglakhir5
            and A.REQUESTED_PROC_DESC not like 'ekg' and A.REQUESTED_PROC_DESC not like 'treadmill' and A.REQUESTED_PROC_DESC not like 'Audiometri' and a.IsVerifikasi='1'
            UNION ALL
            SELECT  a.ACCESSION_NO,B.NoEpisode,B.NoRegRI,replace(CONVERT(VARCHAR(11), A.ORDER_DATE, 111), '/','-')  as ORDER_DATE, A.PaymentStatus,B.NoMR,A.PATIENT_NAME, b.JenisRawat as NamaUnit,A.REQUESTED_PROC_DESC,A.DIAGNOSIS,A.Posisition,A.Side,A.Note
            ,D.First_Name as DokterOrder,E.First_Name AS DokterRadiologi,
            CASE WHEN A.IsVerifikasi='0' THEN 'BELUM VERIFIKASI' ELSE 'SUDAH VERIFIKASI' END  AS StausVerifikasi,op.NamaPerusahaan   AS NamaPerusahaan,WOID,CONVERT(VARCHAR(8),A.ORDER_DATE,114) as JamOrder,F.TypePatient,A.SCHEDULED_MODALITY,A.PATIENT_LOCATION
            FROM RadiologiSQL.dbo.WO_RADIOLOGY a 
            INNER JOIN RawatInapSQL.DBO.Inpatient B ON A.NOREGISTRASI = B.NoRegRI  
            INNER JOIN MasterdataSQL.DBO.Doctors D ON D.ID = A.REQUEST_BY
            LEFT JOIN MasterdataSQL.DBO.Doctors E ON E.ID = A.DokterRadiologi
            inner join MasterdataSQL.dbo.MstrTypePatient F  on F.ID = B.TypePatient 
            inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi op on op.ID = b.IDAsuransi
            where A.Batal='0' and F.TypePatient='ASURANSI' 
            AND replace(CONVERT(VARCHAR(11), A.ORDER_DATE, 111), '/','-') between :tglawal6 and :tglakhir6
            and A.REQUESTED_PROC_DESC not like 'ekg' and A.REQUESTED_PROC_DESC not like 'treadmill' and A.REQUESTED_PROC_DESC not like 'Audiometri' and a.IsVerifikasi='1' ");

            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $this->db->bind('tglawal2', $tglawal);
            $this->db->bind('tglakhir2', $tglakhir);
            $this->db->bind('tglawal3', $tglawal);
            $this->db->bind('tglakhir3', $tglakhir);
            $this->db->bind('tglawal4', $tglawal);
            $this->db->bind('tglakhir4', $tglakhir);
            $this->db->bind('tglawal5', $tglawal);
            $this->db->bind('tglakhir5', $tglakhir);
            $this->db->bind('tglawal6', $tglawal);
            $this->db->bind('tglakhir6', $tglakhir);

            $data =  $this->db->resultSet();
            $rows = array();
            // var_dump($data);
            // exit;
            foreach ($data as $row) {
                //PerawatanSQL.DBO.[Visit Details]
                $pasing['NoMR'] = $row['NoMR'];
                $pasing['PATIENT_NAME'] = $row['PATIENT_NAME'];
                $pasing['ORDER_DATE'] = date('d/m/Y', strtotime($row['ORDER_DATE']));
                $pasing['ACCESSION_NO'] = $row['ACCESSION_NO'];
                $pasing['NoRegistrasi'] = $row['NoRegistrasi'];

                $pasing['REQUESTED_PROC_DESC'] = $row['REQUESTED_PROC_DESC'];
                $pasing['PATIENT_LOCATION'] = $row['PATIENT_LOCATION'];
                $pasing['DokterRadiologi'] = $row['DokterRadiologi'];
                $pasing['TypePatient'] = $row['TypePatient'];
                $pasing['JamOrder'] = $row['JamOrder'];
                $pasing['SCHEDULED_MODALITY'] = $row['SCHEDULED_MODALITY'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    //ACN = Accession Number
    public function PrintHasilHeaderbyACN($data)
    {
        try {
                $query = "SELECT A.PATIENT_NAME,A.WOID,A.PATIENT_LOCATION,A.MRN,A.ACCESSION_NO,replace(CONVERT(VARCHAR(11), A.ORDER_DATE, 111), '/','-')  as ORDER_DATE,replace(CONVERT(VARCHAR(11), B.Date_of_Birth, 111), '/','-')  as DateOfBirth,A.NOREGISTRASI,c.First_Name as NamaDokter,DIAGNOSIS,SCHEDULED_PROC_DESC
                 FROM RadiologiSQL.dbo.WO_RADIOLOGY A
                INNER JOIN MasterdataSQL.dbo.Admision B on a.MRN=b.NoMR
                LEFT JOIN MasterdataSQL.dbo.Doctors C on a.REQUEST_BY=C.ID
                where ACCESSION_NO=:notrs";
            $this->db->query($query);
            $this->db->bind('notrs', $data['notrs']);
            $datas =  $this->db->single();

            $pasing['PATIENT_NAME'] = $datas['PATIENT_NAME'];
            $pasing['WOID'] = $datas['WOID'];
            $pasing['PATIENT_LOCATION'] = $datas['PATIENT_LOCATION'];
            $pasing['MRN'] = $datas['MRN'];
            $pasing['ACCESSION_NO'] = $datas['ACCESSION_NO'];
            $pasing['ORDER_DATE'] = $datas['ORDER_DATE'];
            $pasing['DateOfBirth'] = $datas['DateOfBirth'];
            $pasing['NOREGISTRASI'] = $datas['NOREGISTRASI'];
            $pasing['NamaDokter'] = $datas['NamaDokter'];
            $pasing['DIAGNOSIS'] = $datas['DIAGNOSIS'];
            $pasing['SCHEDULED_PROC_DESC'] = $datas['SCHEDULED_PROC_DESC'];

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintHasilDetailbyACN($data)
    {
        try {
                $query = "SELECT ACCESSION_NO,CREATE_DTTM,REPORT_STAT,PATIENT_ID,CREATOR_NAME,REPORT_TEXT,CONCLUSION from RadiologiSQL.dbo.REPORT_RIS where ACCESSION_NO=:notrs";
            $this->db->query($query);
            $this->db->bind('notrs', $data['notrs']);
            $datas =  $this->db->single();

            $pasing['ACCESSION_NO'] = $datas['ACCESSION_NO'];
            $pasing['CREATE_DTTM'] = $datas['CREATE_DTTM'];
            $pasing['REPORT_STAT'] = $datas['REPORT_STAT'];
            $pasing['PATIENT_ID'] = $datas['PATIENT_ID'];
            $pasing['CREATOR_NAME'] = $datas['CREATOR_NAME'];
            $pasing['REPORT_TEXT'] = $datas['REPORT_TEXT'];
            $pasing['CONCLUSION'] = $datas['CONCLUSION'];

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
                        'Key'    => 'digitalfiles/radiologi/' . $key,
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
              inner join Billing_Pasien.dbo.TDocumentRadiologiResults b on a.Uuid=b.DocTransactionID
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

                $query = "UPDATE Billing_Pasien.dbo.TDocumentRadiologiResults SET ActiveDocument='0' WHERE NoTrs_Reff=:id";
                $this->db->query($query);
                $this->db->bind('id', $notrs);
                $this->db->execute();

                    $query = "INSERT INTO  Billing_Pasien.dbo.TDocumentRadiologiResults (DocTransactionID,NoTrs_Reff,NoRegistrasi,AwsUrlDocuments,TglCreate,UserCreate)
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
                FROM Billing_Pasien.dbo.TDocumentRadiologiResults
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
}
