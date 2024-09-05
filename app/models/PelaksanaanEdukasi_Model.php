<?php
class PelaksanaanEdukasi_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function Save($data)
    {
        $result     = array();
        $imagedata  = base64_decode($data['img_data']);
        $filename   = md5(date("dmYhisA"));
        $bytes = random_bytes(20);

        // $uuid = UniversalIdentifier::uniqueImage($filename);
        $TglJamEdukasi = bin2hex($bytes) . "-" . date("YmdHis");
        $file_name  =  'images/signature/' . bin2hex($bytes) . "-" . date("YmdHis") . ".png";
        file_put_contents($file_name, $imagedata);
        $result['status']     = 1;
        $result['file_name']  = $file_name;
        // $result['nama'] = $data['nama'];


        /// AWS
        // Create an S3Client
        // $s3Client = new S3Client([
        //         'profile' => 'default',
        //         'region' => 'ap-southeast-1',
        //         'version' => '2006-03-01',
        //         'credentials' => [
        //             'key' => '',
        //             'secret' => '',
        //         ]
        // ]);
        // $source = BASEURL_PHOTO_SIGNATURE . '/' . $file_name;
        // $uploader = new MultipartUploader($s3Client, $source, [
        //         'bucket' => 'rsuyarsibucket',
        //         'key' => 'my-file.zip',
        // ]);

        // try {
        //     $result = $uploader->upload();
        //     echo "Upload complete: {$result['ObjectURL']}\n";
        // } catch (MultipartUploadException $e) {
        //     echo $e->getMessage() . "\n";
        // }
        return $this->insert($data);
    }

    public function insert($data)
    {
        try {
            $this->db->transaksi();

            if ($data['TglJamEdukasi'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi TglJamEdukasi!',
                );
                return $callback;
                exit;
            }
            if ($data['Materi_Edukasi_Berdasarkan_Kebutuhan'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi Materi_Edukasi_Berdasarkan_Kebutuhan!',
                );
                return $callback;
                exit;
            }
            if ($data['Kode_Leaflet'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi Kode_Leaflet!',
                );
                return $callback;
                exit;
            }
            if ($data['Lama_Edukasi'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi Lama_Edukasi!',
                );
                return $callback;
                exit;
            }
            if ($data['Hasil_Verifikasi'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi Hasil_Verifikasi!',
                );
                return $callback;
                exit;
            }
            if ($data['Tgl_Reedukasi_Redemonstrasi'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi Tgl_Reedukasi_Redemonstrasi!',
                );
                return $callback;
                exit;
            }
            if ($data['Pemberi_Edukasi'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi Pemberi_Edukasi!',
                );
                return $callback;
                exit;
            }
            if ($data['Pasien_keluarga_Hubungan'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi Pasien_keluarga_Hubungan!',
                );
                return $callback;
                exit;
            }
            if ($data['saksi_rumah_sakit'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi tanda tangan!',
                );
                return $callback;
                exit;
            }
            if ($data['saksi_pasiens'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi tanda tangan pasien!',
                );
                return $callback;
                exit;
            }

            $TglJamEdukasi = $data['TglJamEdukasi'];
            $Materi_Edukasi_Berdasarkan_Kebutuhan = $data['Materi_Edukasi_Berdasarkan_Kebutuhan'];
            $Kode_Leaflet = $data['Kode_Leaflet'];
            $Lama_Edukasi = $data['Lama_Edukasi'];
            $Hasil_Verifikasi = $data['Hasil_Verifikasi'];
            $Tgl_Reedukasi_Redemonstrasi = $data['Tgl_Reedukasi_Redemonstrasi'];
            $Pemberi_Edukasi = $data['Pemberi_Edukasi'];
            $Pasien_keluarga_Hubungan = $data['Pasien_keluarga_Hubungan'];
            $saksi_rumah_sakit = $data['saksi_rumah_sakit'];
            $saksi_pasiens = $data['saksi_pasiens'];
            // var_dump($data);



            if ($TglJamEdukasi == "") {
                $this->db->query("INSERT INTO  PerawatanSQL.dbo.formedukasipasien2 (
                        [TglJamEdukasi],
	[Materi_Edukasi_Berdasarkan_Kebutuhan]  ,
	[Kode_Leaflet]  ,
	[Lama_Edukasi]  ,
	[Hasil_Verifikasi]  ,
	[Tgl_Reedukasi_Redemonstrasi]  ,
	[Pemberi_Edukasi]  ,
	[Pasien_keluarga_Hubungan] ,
    [saksi_rumah_sakit] ,
    [saksi_pasiens] 
	) values (:TglJamEdukasi,:Materi_Edukasi_Berdasarkan_Kebutuhan,:Kode_Leaflet,:Lama_Edukasi,:Hasil_Verifikasi,:Tgl_Reedukasi_Redemonstrasi,:Pemberi_Edukasi,:Pasien_keluarga_Hubungan,:saksi_rumah_sakit,:saksi_pasiens)
    ");
            } else {
                $this->db->query("INSERT INTO  PerawatanSQL.dbo.FormEdukasiPasien2 (
                    [TglJamEdukasi],
[Materi_Edukasi_Berdasarkan_Kebutuhan]  ,
[Kode_Leaflet]  ,
[Lama_Edukasi]  ,
[Hasil_Verifikasi]  ,
[Tgl_Reedukasi_Redemonstrasi]  ,
[Pemberi_Edukasi]  ,
[Pasien_keluarga_Hubungan] ,
[saksi_rumah_sakit] ,
[saksi_pasiens] 
) values (:TglJamEdukasi,:Materi_Edukasi_Berdasarkan_Kebutuhan,:Kode_Leaflet,:Lama_Edukasi,:Hasil_Verifikasi,:Tgl_Reedukasi_Redemonstrasi,:Pemberi_Edukasi,:Pasien_keluarga_Hubungan,:saksi_rumah_sakit,:saksi_pasiens)
");
                $this->db->bind('TglJamEdukasi', $TglJamEdukasi);
                $this->db->bind('Materi_Edukasi_Berdasarkan_Kebutuhan', $Materi_Edukasi_Berdasarkan_Kebutuhan);
                $this->db->bind('Kode_Leaflet', $Kode_Leaflet);
                $this->db->bind('Lama_Edukasi', $Lama_Edukasi);
                $this->db->bind('Hasil_Verifikasi', $Hasil_Verifikasi);
                $this->db->bind('Tgl_Reedukasi_Redemonstrasi', $Tgl_Reedukasi_Redemonstrasi);
                $this->db->bind('Pemberi_Edukasi', $Pemberi_Edukasi);
                $this->db->bind('Pasien_keluarga_Hubungan', $Pasien_keluarga_Hubungan);
                $this->db->bind('saksi_rumah_sakit', $saksi_rumah_sakit);
                $this->db->bind('saksi_pasiens', $saksi_pasiens);
                $this->db->execute();
                $this->db->commit();
                $callback = array(
                    'status' => 'success', // Set array status dengan success   
                    'message' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success    
                );
            }
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function Path($data)
    {
        $result     = array();
        $imagedata  = base64_decode($data['img_data']);
        $filename   = md5(date("dmYhisA"));
        $bytes = random_bytes(20);

        // $TglJamEdukasi = UniversalIdentifier::uniqueImage($filename);
        $uuid = bin2hex($bytes) . "-" . date("YmdHis");
        $file_name  = $_SERVER['DOCUMENT_ROOT'] . 'SIKBREC/public/images/signature/' . $uuid . ".png";
        file_put_contents($file_name, $imagedata);
        $result['status']     = 1;
        $result['file_name']  = $file_name;
        // $result['nama'] = $data['nama'];
        return $calback = [
            'uuid' => $uuid,
            'Path' => $file_name
        ];
    }
}
