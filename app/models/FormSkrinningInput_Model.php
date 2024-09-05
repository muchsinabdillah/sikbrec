<?php

use \Ramsey\Uiid\Uuid;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;

class FormSkrinningInput_Model
{
    private $db;
    use ApiRsyarsi;
    public function __construct()
    {
        $this->db = new Database;
    }

    //List Get ALL Table
    public function getAllSkrinningBatuk($data)
    {
        try {
            $this->db->query("SELECT ID,datecreate,case when Kondisi_Kesehatan_Batuk ='1' then 'Ya' else 'Tidak' end as Kondisi_Kesehatan_Batuk,case when Kondisi_Kesehatan_Pilek ='1' then 'Ya' else 'Tidak' end as Kondisi_Kesehatan_Pilek,case when Kondisi_Kesehatan_NyeriTenggorokan ='1' then 'Ya' else 'Tidak' end as Kondisi_Kesehatan_NyeriTenggorokan,case when Kondisi_Kesehatan_Demam ='1' then 'Ya' else 'Tidak' end as Kondisi_Kesehatan_Demam,case when Kondisi_Kesehatan_Sesak ='1' then 'Ya' else 'Tidak' end as Kondisi_Kesehatan_Sesak,case when Batuk_2Minggu ='1' then 'Ya' else 'Tidak' end as Batuk_2Minggu,case when Riwayat_Berkunjung_Covid19 ='1' then 'Ya' else 'Tidak' end as Riwayat_Berkunjung_Covid19,case when Riwayat_Perjalanan ='1' then 'Ya' else 'Tidak' end as Riwayat_Perjalanan,case when Kontak_Terkonfirmasi_Positif ='1' then 'Ya' else 'Tidak' end as Kontak_Terkonfirmasi_Positif,case when Diabetes ='1' then 'Ya' else 'Tidak' end as Diabetes,case when Ginjal ='1' then 'Ya' else 'Tidak' end as Ginjal,case when Kanker ='1' then 'Ya' else 'Tidak' end as Kanker,case when HIV_AIDS ='1' then 'Ya' else 'Tidak' end as HIV_AIDS,case when Minum_ObatSteroid ='1' then 'Ya' else 'Tidak' end as Minum_ObatSteroid,TTD_Pasein,TTD_Petugas 
            from PerawatanSQL.dbo.FormSkrinningBatuk where NoRegistrasi=:NoRegistrasi AND Batal='0' ");
            $this->db->bind('NoRegistrasi', $data['NoRegistrasi']);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['datecreate'] = $key['datecreate'];
                $pasing['Kondisi_Kesehatan_Batuk'] = $key['Kondisi_Kesehatan_Batuk'];
                $pasing['Kondisi_Kesehatan_Pilek'] = $key['Kondisi_Kesehatan_Pilek'];
                $pasing['Kondisi_Kesehatan_NyeriTenggorokan'] = $key['Kondisi_Kesehatan_NyeriTenggorokan'];
                $pasing['Kondisi_Kesehatan_Demam'] = $key['Kondisi_Kesehatan_Demam'];
                $pasing['Kondisi_Kesehatan_Sesak'] = $key['Kondisi_Kesehatan_Sesak'];
                $pasing['Batuk_2Minggu'] = $key['Batuk_2Minggu'];
                $pasing['Riwayat_Berkunjung_Covid19'] = $key['Riwayat_Berkunjung_Covid19'];
                $pasing['Riwayat_Perjalanan'] = $key['Riwayat_Perjalanan'];
                $pasing['Kontak_Terkonfirmasi_Positif'] = $key['Kontak_Terkonfirmasi_Positif'];
                $pasing['Diabetes'] = $key['Diabetes'];
                $pasing['Ginjal'] = $key['Ginjal'];
                $pasing['Ginjal'] = $key['Ginjal'];
                $pasing['Kanker'] = $key['Kanker'];
                $pasing['HIV_AIDS'] = $key['HIV_AIDS'];
                $pasing['Minum_ObatSteroid'] = $key['Minum_ObatSteroid'];
                $pasing['URLPASIEN'] = $key['TTD_Pasein'];
                $pasing['URLPETUGAS'] = $key['TTD_Petugas'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    // delete

    public function delete($data)
    {
        $this->db->transaksi();
        // var_dump($data);
        // exit;
        $id = $data['ID'];
        $datenow = Utils::seCurrentDateTime();
        $session = SessionManager::getCurrentSession();
        $idEmploye = $session->IDEmployee;

        $this->db->query(" UPDATE PerawatanSQL.dbo.FormSkrinningBatuk SET Batal = 1, TglBatal=:datenow,PetugasBatal=:idEmploye WHERE ID=:id");
        $this->db->bind('id', $id);
        $this->db->bind('datenow', $datenow);
        $this->db->bind('idEmploye', $idEmploye);

        $this->db->execute();
        $this->db->commit();
        $callback = array(
            'status' => 'success', // Set array status dengan success   
            'message' => 'Transkasi Berhasil Dihapus !', // Set array status dengan success    
        );
        return $callback;
    }

    // INSERT
    public function insert($data)
    {
        try {
            $this->db->transaksi();
            $IdRegistrasi = $data['IdRegistrasi'];
            $NoMR = $data['NoMR'];
            $NoRegistrasi = $data['NoRegistrasi'];

            if (isset($data['case1a'])) {
                $case1a = $data['case1a'];
            } else {
                $case1a = '0';
            }

            if (isset($data['case1b'])) {
                $case1b = $data['case1b'];
            } else {
                $case1b = '0';
            }

            if (isset($data['case1c'])) {
                $case1c = $data['case1c'];
            } else {
                $case1c = '0';
            }

            if (isset($data['case1d'])) {
                $case1d = $data['case1d'];
            } else {
                $case1d = '0';
            }

            if (isset($data['case1e'])) {
                $case1e = $data['case1e'];
            } else {
                $case1e = '0';
            }
            $case2 = $data['case2'];
            $case3a = $data['case3a'];
            $case3b = $data['case3b'];
            $case3c = $data['case3c'];
            $case4a = $data['case4a'];
            $case4b = $data['case4b'];
            $case4c = $data['case4c'];
            $case4d = $data['case4d'];
            $case4e = $data['case4e'];
            $saksi_rumah_sakit = $data['saksi_rumah_sakit'];
            $saksi_pasiens = $data['saksi_pasiens'];
            $datenow = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $idEmploye = $session->IDEmployee;

            if ($case2 == "" or $case3a == "" or $case3b == "" or $case3c == "" or $case4a == "" or $case4a == "" or $case4b == "" or $case4c == "" or $case4d == "" or $case4e == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Data Kosong !',
                );
                return $callback;
                exit;
            }

            // if ($data['ID'] == "") {

            $this->db->query("INSERT INTO PerawatanSQL.dbo.FormSkrinningBatuk
                            ([NoMR],[NoRegistrasi],[Kondisi_Kesehatan_Batuk],[Kondisi_Kesehatan_Pilek],[Kondisi_Kesehatan_NyeriTenggorokan],[Kondisi_Kesehatan_Demam],[Kondisi_Kesehatan_Sesak],[Batuk_2Minggu],[Riwayat_Berkunjung_Covid19],[Riwayat_Perjalanan],[Kontak_Terkonfirmasi_Positif],[Diabetes],[Ginjal],[Kanker],[HIV_AIDS],[Minum_ObatSteroid],[datecreate],[usercreate],[TTD_Petugas],[TTD_Pasein])
                        values
                        (:NoMR,:NoRegistrasi,:case1a,:case1b,:case1c,:case1d,:case1e,:case2,:case3a,:case3b,:case3c,:case4a,:case4b,:case4c,:case4d,:case4e,:datenow,:idEmploye, :saksi_rumah_sakit,:saksi_pasiens)");
            $this->db->bind('NoMR', $NoMR);
            $this->db->bind('NoRegistrasi', $NoRegistrasi);
            $this->db->bind('case1a', $case1a);
            $this->db->bind('case1b', $case1b);
            $this->db->bind('case1c', $case1c);
            $this->db->bind('case1d', $case1d);
            $this->db->bind('case1e', $case1e);
            $this->db->bind('case2', $case2);
            $this->db->bind('case3a', $case3a);
            $this->db->bind('case3b', $case3b);
            $this->db->bind('case3c', $case3c);
            $this->db->bind('case4a', $case4a);
            $this->db->bind('case4b', $case4b);
            $this->db->bind('case4c', $case4c);
            $this->db->bind('case4d', $case4d);
            $this->db->bind('case4e', $case4e);
            $this->db->bind('datenow', $datenow);
            $this->db->bind('idEmploye', $idEmploye);
            $this->db->bind('saksi_rumah_sakit', $saksi_rumah_sakit);
            $this->db->bind('saksi_pasiens', $saksi_pasiens);

            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Disimpan !' // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function uploadDataTTD($data)
    {
        // $idRegist = $data['IdRegistrasi'];
        $doc_nomr = $data['NoMR'];
        $this->db->transaksi();
        // $IdRegistrasi = $data['IdRegistrasi'];
        $NoMR = $data['NoMR'];
        $NoRegistrasi = $data['NoRegistrasi'];
        $ext = 'png'; // Ambil ekstensi filenya apa
        $namafile_Petugas = $data['saksi_rumah_sakit'];
        $namafile_Pasien = $data['saksi_pasiens'];


        $NoMR = $data['NoMR'];
        // var_dump($data['case1a']);
        // exit;



        $case2 = $data['case2'];
        $case3a = $data['case3a'];
        $case3b = $data['case3b'];
        $case3c = $data['case3c'];
        $case4a = $data['case4a'];
        $case4b = $data['case4b'];
        $case4c = $data['case4c'];
        $case4d = $data['case4d'];
        $case4e = $data['case4e'];
        $saksi_rumah_sakit = $data['saksi_rumah_sakit'];
        $saksi_pasiens = $data['saksi_pasiens'];


        // $datenow = Utils::seCurrentDateTime();
        // $session = SessionManager::getCurrentSession();
        // $idEmploye = $session->IDEmployee;
        // var_dump($case2);

        if ($case2 == "" or $case3a == "" or $case3b == "" or $case3c == "" or $case4a == "" or $case4a == "" or $case4b == "" or $case4c == "" or $case4d == "" or $case4e == "") {
            $callback = array(
                'status' => 'warning',
                'message' => 'Silahkan pilih Kolom pertanyaan yang belum terisi !, Wajib !',
            );
            return $callback;
            exit;
        }

        if ($namafile_Petugas == '') {
            $callback = array(
                'status' => 'warning',
                'message' => 'Input Tanda Tangan Petugas Terlebih dulu !',
            );
            return $callback;
            exit;
        }

        if ($namafile_Pasien == '') {
            $callback = array(
                'status' => 'warning',
                'message' => 'Input Tanda Tangan Pasien Terlebih dulu !',
            );
            return $callback;
            exit;
        }

        // if ($namafile_Petugas != '' AND $namafile_Pasien != '') {
        $bytes = random_bytes(20);
        $nama_file_baru  =     $doc_nomr . bin2hex($bytes) . "-" . date("YmdHis") . '.' . $ext;
        // $nama_file_baru_Pasien  =     $doc_nomr . bin2hex($bytes) . "-" . date("YmdHis") . '.' . $ext;
        // var_dump($nama_file_baru_Petugas);
        // var_dump($nama_file_baru_Pasien);
        // exit;
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
        $file_name_Petugas = $namafile_Petugas;
        $file_name_Pasien = $namafile_Pasien;

        $source_Petugas =   $file_name_Petugas;
        $source_Pasien =   $file_name_Pasien;

        $awsImages = '';
        try {
            $bucket = 'rsuyarsibucket';
            $key = basename($file_name_Petugas);
            $result = $s3Client->putObject([
                'Bucket' => $bucket,
                'Key'    => 'Perawatan/FormSkrinningBatuk/' . $key,
                'Body'   => fopen($source_Petugas, 'r'),
                'ACL'    => 'public-read', // make file 'public', 
            ]);
            $awsImages_Petugas = $result->get('ObjectURL');

            $key2 = basename($file_name_Pasien);
            $result = $s3Client->putObject([
                'Bucket' => $bucket,
                'Key'    => 'Perawatan/FormSkrinningBatuk/' . $key2,
                'Body'   => fopen($source_Pasien, 'r'),
                'ACL'    => 'public-read', // make file 'public', 
            ]);
            $awsImages_Pasien = $result->get('ObjectURL');

            // var_dump($awsImages_Petugas);
            // var_dump($awsImages_Pasien);
            // exit;

            //var_dump($data);exit;
            return $this->SaveTTD_TTD($data,  $nama_file_baru, $awsImages_Petugas, $awsImages_Pasien, $ext);
        } catch (MultipartUploadException $e) {

            return $e->getMessage();
        }
        // } else {
        // $callback = array(
        //     'status' => 'warning',
        //     'message' => 'Upload Failed.',
        // );
        // return $callback;
        //}
        // } else { // Jika file yang diupload bukan File Excel 2007 (.xlsx)
        //     // Munculkan pesan validasi 
        //     $callback = array(
        //         'status' => 'warning',
        //         'message' => 'Lengkapi Inputan Tanda Tangan Terlebih dahulu.',
        //         '$ext' => $ext,
        //     );
        //     return $callback;
        // }

    }

    public function SaveTTD_TTD($data,  $nama_file_baru, $awsImages_Petugas, $awsImages_Pasien, $ext)
    {


        try {

            if (isset($data['case1a'])) {
                $case1a = $data['case1a'];
            } else {
                $case1a = '0';
            }


            if (isset($data['case1b'])) {
                $case1b = $data['case1b'];
            } else {
                $case1b = '0';
            }

            if (isset($data['case1c'])) {
                $case1c = $data['case1c'];
            } else {
                $case1c = '0';
            }

            if (isset($data['case1d'])) {
                $case1d = $data['case1d'];
            } else {
                $case1d = '0';
            }

            if (isset($data['case1e'])) {
                $case1e = $data['case1e'];
            } else {
                $case1e = '0';
            }


            $ro = "aws";
            $NoMR = $data['NoMR'];
            $datetime = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $operator =  $session->IDEmployee;

            $NoRegistrasi = $data['NoRegistrasi'];

            // $case1a = $data['case1a'];
            // $case1b = $data['case1b'];
            // $case1c = $data['case1c'];
            // $case1d = $data['case1d'];
            // $case1e = $data['case1e'];

            $case2 = $data['case2'];
            $case3a = $data['case3a'];
            $case3b = $data['case3b'];
            $case3c = $data['case3c'];
            $case4a = $data['case4a'];
            $case4b = $data['case4b'];
            $case4c = $data['case4c'];
            $case4d = $data['case4d'];
            $case4e = $data['case4e'];

            $query = "INSERT INTO PerawatanSQL.dbo.FormSkrinningBatuk
                ([NoMR],[NoRegistrasi],[Kondisi_Kesehatan_Batuk],[Kondisi_Kesehatan_Pilek],[Kondisi_Kesehatan_NyeriTenggorokan],[Kondisi_Kesehatan_Demam],[Kondisi_Kesehatan_Sesak],[Batuk_2Minggu],[Riwayat_Berkunjung_Covid19],[Riwayat_Perjalanan],[Kontak_Terkonfirmasi_Positif],[Diabetes],[Ginjal],[Kanker],[HIV_AIDS],[Minum_ObatSteroid],[datecreate],[usercreate],[TTD_Petugas],[TTD_Pasein],[Extension],Provider)
                values
                (:NoMR,:NoRegistrasi,:case1a,:case1b,:case1c,:case1d,:case1e,:case2,:case3a,:case3b,:case3c,:case4a,:case4b,:case4c,:case4d,:case4e,:datenow,:idEmploye, :TTD_Petugas,:TTD_Pasein,:EXTENSION,:Provider)";

            $this->db->query($query);

            $this->db->bind('TTD_Pasein', $awsImages_Pasien);
            $this->db->bind('TTD_Petugas', $awsImages_Petugas);

            $this->db->bind('NoMR', $NoMR);

            $this->db->bind('NoRegistrasi', $NoRegistrasi);
            $this->db->bind('case1a', $case1a);
            $this->db->bind('case1b', $case1b);
            $this->db->bind('case1c', $case1c);
            $this->db->bind('case1d', $case1d);
            $this->db->bind('case1e', $case1e);
            $this->db->bind('case2', $case2);
            $this->db->bind('case3a', $case3a);
            $this->db->bind('case3b', $case3b);
            $this->db->bind('case3c', $case3c);
            $this->db->bind('case4a', $case4a);
            $this->db->bind('case4b', $case4b);
            $this->db->bind('case4c', $case4c);
            $this->db->bind('case4d', $case4d);
            $this->db->bind('case4e', $case4e);
            // $this->db->bind('JenisDocument', $data['jenisdoc']);

            $this->db->bind('Provider', $ro);
            $this->db->bind('datenow', $datetime);
            $this->db->bind('idEmploye', $namauserx);
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

    //edit badrul
}
