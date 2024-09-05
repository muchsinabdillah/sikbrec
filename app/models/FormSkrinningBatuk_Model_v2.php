<?php

use \Ramsey\Uiid\Uuid;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;

class FormSkrinningBatuk_Model_v2
{
    //edit badrul
    public function getDatapegawaiTTD($data)
    {
        // try {
        //     // var_dump($data);
        //     $IDs = $data['id'];
        //     $this->db->query("SELECT Nip,Nama,Jenis_Pegawai
        //                     FROM HRDYARSI.dbo.[Data Pegawai] where ID_Data=:ID_Data");
        //     $this->db->bind('ID_Data', $IDs);
        //     $data =  $this->db->single();
        //     //var_dump($data);exit;
        //     // $pasing['No'] = $data['NO'];
        //     $pasing['Nip'] = $data['Nip'];
        //     $pasing['Nama'] = $data['Nama'];
        //     $pasing['Jenis_Pegawai'] = $data['Jenis_Pegawai'];
        //     $callback = array(
        //         'message' => "success", // Set array nama 
        //         'data' => $pasing
        //     );
        //     return $callback;
        // } catch (PDOException $e) {
        //     $this->db->rollback();
        //     $callback = array(
        //         'status' => "error", // Set array nama  
        //         'message' => $e
        //     );
        //     return $callback;
        // }

        // try {
        //     $IDs = $data['id'];
        //     $this->db->query("SELECT ID, NoPIN, username
        //                     FROM MasterdataSQL.dbo.Employees where ID=:ID_Data");
        //                     $this->db->bind('ID_Data', $IDs);
        //                     $data =  $this->db->single();
        //     $callback = array(
        //         'status' => 'success', // Set array status dengan success    
        //         'ID' => $data['ID'], // Set array status dengan success    
        //         'NoPIN' => $data['NoPIN'], // Set array status dengan success 
        //         'username' => $data['username'], // Set array status dengan success 
        //     );
        //     return $callback;
        // } catch (PDOException $e) {
        //     $this->db->closeCon();
        //     die($e->getMessage());
        // }

        try {
            $IDs = $data['id'];
            $tabel = "MasterDataSQL.dbo.Admision";
            if (isset($_POST['iswalkin'])) {
                $iswalkin = $data['iswalkin'];
                if ($iswalkin == 'WALKIN') {
                    $tabel = "MasterDataSQL.dbo.Admision_walkin";
                }
            }
            $this->db->query(" SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName,a.LokasiPasien,a.CaraBayar,
                                          a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
                                          a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
                                          a.PatientType,a.Unit,a.Doctor_1,b.First_Name as namadokter,a.JamPraktek,a.Asuransi as Perusahaanid,c.NamaPerusahaan as  Perusahaan,a.[Payment Type],
                                          a.Antrian,a.NoAntrianAll,e.[First Name] as namauser,
                      replace(CONVERT(VARCHAR(11), d.Date_of_birth, 111), '/','-') as Date_of_birthx,
                      d.Address,d.Gander,d.BirthPlace,d.Ocupation,d.[Mobile Phone] as noHp,
                      case when d.Gander='L' then 'LAKI-LAKI' when d.Gander='P' then 'PEREMPUAN'  END AS NamaGander,
                      d.ID_Card_number,a.idAdmin,a.idCaraMasuk,a.idCaraMasuk2,a.JenisDaftar,f.NoBooking,
                      replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglkunjungan,
                      CONVERT(VARCHAR(8),TglKunjungan,108) as jamkunjungan,bl.KODE_TARIF,a.Tipe_Registrasi,a.JamPraktek,a.ID_JadwalPraktek,a.Catatan
                                          from PerawatanSQL.dbo.Visit a
                                          inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
                                          inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.Asuransi
                                          inner join $tabel d on d.NoMR = a.NoMR
                                          inner join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
                                          left join PerawatanSQL.DBO.Apointment f on f.NoRegistrasi = a.NoRegistrasi
                                          outer apply (SELECT KODE_TARIF,NILAI_TARIF,NO_REGISTRASI FROM Billing_Pasien.dbo.FO_T_BILLING_1 where GROUP_ENTRI='KARCIS' and BATAL='0' and NO_REGISTRASI collate Latin1_General_CI_AS=a.NoRegistrasi collate Latin1_General_CI_AS)
                                          bl 
                                          where a.PatientType='2' and a.Batal='0'  and  a.id=:IdRegistrasi
                                          UNION ALL
                                          SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName ,a.LokasiPasien,a.CaraBayar,
                                          a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
                                          a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
                                          a.PatientType,a.Unit,a.Doctor_1,b.First_Name as namadokter,a.JamPraktek,a.Perusahaan as Perusahaanid,c.NamaPerusahaan as  Perusahaan,a.[Payment Type],
                                          a.Antrian,a.NoAntrianAll,e.[First Name] as namauser,
                      replace(CONVERT(VARCHAR(11), d.Date_of_birth, 111), '/','-') as Date_of_birthx,
                      d.Address,d.Gander,d.BirthPlace,d.Ocupation,d.[Mobile Phone] as noHp,
                      case when d.Gander='L' then 'LAKI-LAKI' when d.Gander='P' then 'PEREMPUAN'  END AS NamaGander,
                      d.ID_Card_number,a.idAdmin,a.idCaraMasuk,a.idCaraMasuk2,a.JenisDaftar,f.NoBooking,
                      replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglkunjungan,
                      CONVERT(VARCHAR(8),TglKunjungan,108) as jamkunjungan,bl.KODE_TARIF,a.Tipe_Registrasi,a.JamPraktek,a.ID_JadwalPraktek,a.Catatan
                                          from PerawatanSQL.dbo.Visit a
                                          inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
                                          inner join MasterdataSQL.dbo.MstrPerusahaanJPK c on c.ID = a.Perusahaan
                                          inner join $tabel d on d.NoMR = a.NoMR
                                          inner join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
                                          left join PerawatanSQL.DBO.Apointment f on f.NoRegistrasi = a.NoRegistrasi
                                          outer apply (SELECT KODE_TARIF,NILAI_TARIF,NO_REGISTRASI FROM Billing_Pasien.dbo.FO_T_BILLING_1 where GROUP_ENTRI='KARCIS' and BATAL='0' and NO_REGISTRASI collate Latin1_General_CI_AS=a.NoRegistrasi collate Latin1_General_CI_AS)
                                          bl  
                                          where a.PatientType<>'2' and a.Batal='0' and  a.id=:IdRegistrasi2
                                         ");
            $this->db->bind('IdRegistrasi', $IdRegistrasi);
            $this->db->bind('IdRegistrasi2', $IdRegistrasi);
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success', // Set array status dengan success
                'ID' => $data['id'], // Set array status dengan success
                'Catatan' => $data['Catatan'], // Set array status dengan success
                'NoMR' => $data['NoMR'], // Set array status dengan success
                'NoEpisode' => $data['NoEpisode'], // Set array status dengan success
                'NoRegistrasi' => $data['NoRegistrasi'], // Set array status dengan success
                'PatientName' => $data['PatientName'], // Set array status dengan success
                'LokasiPasien' => $data['LokasiPasien'], // Set array status dengan success
                'CaraBayar' => $data['CaraBayar'], // Set array status dengan successDate_of_birth
                'NoPesertaBPJS' => $data['NoPesertaBPJS'], // Set array status dengan successDate_of_birth
                'NoSEP' => $data['NoSEP'], // Set array status dengan successDate_of_birth
                'TglSEP' => $data['TglSEP'], // Set array status dengan successDate_of_birth
                'AlasanSEPtunda' => $data['AlasanSEPtunda'], // Set array status dengan successDate_of_birth
                'ID_Card_number' => $data['ID_Card_number'], // Set array status dengan success 
                'Gander' => $data['Gander'], // Set array status dengan success
                'Date_of_birth' => $data['Date_of_birthx'], // Set array status dengan successDate_of_birth
                'Address' => $data['Address'], // Set array status dengan successDate_of_birth
                'NamaGander' => $data['NamaGander'], // Set array status dengan successDate_of_birth
                'BirthPlace' => $data['BirthPlace'], // Set array status dengan successDate_of_birth
                'Ocupation' => $data['Ocupation'], // Set array status dengan successDate_of_birth
                'NoAntrianAll' => $data['NoAntrianAll'], // Set array status dengan successDate_of_birth
                'NoBooking' => $data['NoBooking'],
                'Unit' => $data['Unit'], // Set array status dengan successDate_of_birth
                'LokasiPasien' => $data['LokasiPasien'], // Set array status dengan successDate_of_birth
                'namadokter' => $data['namadokter'], // Set array status dengan successDate_of_birth
                'Doctor1' => $data['Doctor_1'], // Set array status dengan successDate_of_birth
                'PatientType' => $data['PatientType'], // Set array status dengan successDate_of_birth
                'Perusahaanid' => $data['Perusahaanid'], // Set array status dengan successDate_of_birth
                'Perusahaan' => $data['Perusahaan'], // Set array status dengan successDate_of_birth
                'idAdmin' => $data['idAdmin'], // Set array status dengan successDate_of_birth
                'idCaraMasuk' => $data['idCaraMasuk'], // Set array status dengan successDate_of_birth
                'idCaraMasuk2' => $data['idCaraMasuk2'], // Set array status dengan successDate_of_birth
                'JenisDaftar' => $data['JenisDaftar'], // Set array status dengan successDate_of_birth
                'VisitDate' => $data['tglkunjungan'],
                'JamDate' => $data['jamkunjungan'],
                'KODE_TARIF' => $data['KODE_TARIF'],
                'Tipe_Registrasi' => $data['Tipe_Registrasi'],
                'JamPraktek' => $data['JamPraktek'],
                'ID_JadwalPraktek' => $data['ID_JadwalPraktek'],
                'noHp' => $data['noHp'],

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
    
    public function uploadDataTTD($data)
    {
    // Jika user telah mengklik tombol Preview

    //$ip = ; // Ambil IP Address dari User 
    $doc_nomr = $data['IdTranasksiAuto'];

    // $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png", "pdf" => "application/pdf");
    // $filetype = $_FILES["file"]["type"];
    // $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
    // $tmp_file = $_FILES['file']['tmp_name'];
    $ext = 'png'; // Ambil ekstensi filenya apa
    $namafile = $data['file'];

    if ($namafile != '') {
        $bytes = random_bytes(20);
        $nama_file_baru  =     $doc_nomr . bin2hex($bytes) . "-" . date("YmdHis") . '.' . $ext;
        // if (move_uploaded_file($tmp_file,  __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru)) {

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
            //$file_name = __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru;
            //$file_name = 'C:/xampp/htdocs/SIKBREC/public/images/signature/' . $namafile;
           // var_dump($namafile);exit;
            $file_name = $namafile;

            $source =   $file_name;
            $awsImages = '';
            try {
                $bucket = 'rsuyarsibucket';
                $key = basename($file_name);
                $result = $s3Client->putObject([
                    'Bucket' => $bucket,
                    'Key'    => 'masterdata/dataTTD/' . $key,
                    'Body'   => fopen($source, 'r'),
                    'ACL'    => 'public-read', // make file 'public', 
                ]);
                $awsImages = $result->get('ObjectURL');
                
    //var_dump($data);exit;
                return $this->SaveTTD_TTD($data,  $nama_file_baru, $awsImages, $ext);
            } catch (MultipartUploadException $e) {

                return $e->getMessage();
            }
        // } else {
            $callback = array(
                'status' => 'warning',
                'message' => 'Upload Failed.',
            );
            return $callback;
        //}
    } else { // Jika file yang diupload bukan File Excel 2007 (.xlsx)
        // Munculkan pesan validasi 
        $callback = array(
            'status' => 'warning',
            'message' => ' File Tidak Support.',
            '$ext' => $ext,
            ' $allowed' =>  $allowed,
        );

    // Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
    // if (in_array($filetype, $allowed)) {
    //     $bytes = random_bytes(20);
    //     $nama_file_baru  =     $doc_nomr . bin2hex($bytes) . "-" . date("YmdHis") . '.' . $ext;
    //     if (move_uploaded_file($tmp_file,  __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru)) {

    //         /// AWS
    //         // Create an S3Client
    //         $s3Client = new S3Client([
    //             'version' => 'latest',
    //             'region'  => 'ap-southeast-1',
    //             'http'    => ['verify' => false],
    //             'credentials' => [
    //                 'key'    => 'AKIAYV2M6ERJGUKK4QWQ',
    //                 'secret' => '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'
    //             ]
    //         ]);
    //         $file_name = __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru;
    //         $source =   $file_name;
    //         $awsImages = '';
    //         try {
    //             $bucket = 'rsuyarsibucket';
    //             $key = basename($file_name);
    //             $result = $s3Client->putObject([
    //                 'Bucket' => $bucket,
    //                 'Key'    => 'masterdata/dataTTD/' . $key,
    //                 'Body'   => fopen($source, 'r'),
    //                 'ACL'    => 'public-read', // make file 'public', 
    //             ]);
    //             $awsImages = $result->get('ObjectURL');
                
    // //var_dump($data);exit;
    //             return $this->SaveTTD_TTD($data,  $nama_file_baru, $awsImages, $ext);
    //         } catch (MultipartUploadException $e) {

    //             return $e->getMessage();
    //         }
    //     } else {
    //         $callback = array(
    //             'status' => 'warning',
    //             'message' => 'Upload Failed.',
    //         );
    //         return $callback;
    //     }
    // } else { // Jika file yang diupload bukan File Excel 2007 (.xlsx)
    //     // Munculkan pesan validasi 
    //     $callback = array(
    //         'status' => 'warning',
    //         'message' => ' File Tidak Support.',
    //         '$ext' => $ext,
    //         ' $allowed' =>  $allowed,
    //     );
        return $callback;
    }
    
}

public function SaveTTD_TTD($data,  $nama_file_baru, $awsImages, $ext)
    {
        // unlink(__DIR__ . '/../../public' . '/tmp/' . $nama_file_baru); // Hapus file tersebut 

        $query = "UPDATE MasterdataSQL.dbo.Employees SET
        FileDocument=:FileDocument,Extension=:EXTENSION,date_update=:date_update,user_update=:user_update,
        Provider=:Provider


        --    ([FileDocument]
        --    ,[Extension]
        -- --    ,[date_update]
        -- --    ,[user_update]
        --    ,[Provider])
        --     VALUES
        --    (:FileDocument,
        --    :EXTENSION,
        -- --    :date_update,
        -- --    :user_update,
        --    :Provider)  
           where ID = :ID " ;
        try {
            $this->db->transaksi();
            $ro = "aws";
            $datetime = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $operator =  $session->IDEmployee;
            $this->db->query($query);

            $this->db->bind('ID', $data['IdTranasksiAuto']);

            $this->db->bind('FileDocument', $awsImages);

            // $this->db->bind('tglAwalTTD', $data['tglAwalTTD']);
            // $this->db->bind('tglAkhirTTD', $data['tglAkhirTTD']);
            // $this->db->bind('noSuratSIP', $data['noSuratSIP']);

            // $this->db->bind('JenisDocument', $data['jenisdoc']);

            $this->db->bind('Provider', $ro);
             $this->db->bind('date_update', $datetime);
             $this->db->bind('user_update', $namauserx);
            $this->db->bind('EXTENSION', $ext);
            $this->db->execute();
            $this->db->Commit();
            $callback = array(
                'status' => 'success',
                'message' => ' Upload Data Succesfully.',
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

    public function getDataListTTD($data)
    {
        try {

            $query = "SELECT Id_trs,Id_data,Tgl_Awal, No_SIP, Tgl_Akhir, JenisDocument,FileDocument,Extension,date_update,user_update
            FROM HRDYARSI.dbo.TTDPegawai1
            WHERE Id_data=:ID_Data";

            $query = "SELECT ID, username, NoPIN, FileDocument 
            FROM MasterdataSQL.dbo.Employees where ID=:ID_Data";
            $this->db->query($query);
            $this->db->bind('ID_Data', $data['doc_nomr']);

            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {
                // $pasing['NO'] = $No++;
                $pasing['IdTranasksiAuto'] = $row['ID'];
                $pasing['Mst_NamaPegawai'] = $row['username'];
                $pasing['Mst_Username'] = $row['NoPIN'];
                $pasing['URL'] = $row['FileDocument'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


//edit badrul
}