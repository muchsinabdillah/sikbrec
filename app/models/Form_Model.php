<?php
class Form_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function insert($data)
    {

        try {
            $this->db->transaksi();
            if ($data['TinggalBersama'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi TinggalBersama !',
                );
                return $callback;
                exit;
            }
            if ($data['Bahasa'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi Bahasa!',
                );
                return $callback;
                exit;
            }
            if ($data['Hambatan'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi Hambatan!',
                );
                return $callback;
                exit;
            }
            if ($data['KemampuanSolat'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi KemampuanSolat!',
                );
                return $callback;
                exit;
            }
            if ($data['KemampuanMembacaAl_Quran'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi KemampuanMembacaAl_Quran!',
                );
                return $callback;
                exit;
            }
            if ($data['EdukasiDiberikanKepada'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi Edukasi Diberikan Kepada!',
                );
                return $callback;
                exit;
            }
            if ($data['KemampuanBahasa'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi KemampuanBahasa!',
                );
                return $callback;
                exit;
            }
            if ($data['PerluPenerjemah'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi PerluPenerjemah!',
                );
                return $callback;
                exit;
            }
            if ($data['BacadanTulis'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi BacadanTulis!',
                );
                return $callback;
                exit;
            }
            if ($data['Kepercayaanlainya'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi Kepercayaanlainya!',
                );
                return $callback;
                exit;
            }
            if ($data['CaraEdukasi'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi CaraEdukasi!',
                );
                return $callback;
                exit;
            }
            if ($data['KebutuhanEdukasi'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi KebutuhanEdukasi!',
                );
                return $callback;
                exit;
            }
            if ($data['KebutuhanEdukasiIslami'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi KebutuhanEdukasiIslami!',
                );
                return $callback;
                exit;
            }
            $NoMR = $data['NoMR'];
            $NoRegistrasi = $data['NoRegistrasi'];
            $NoEpisode = $data['NoEpisode'];
            $NamaPasien = $data['NamaPasien'];
            $Tanggal = $data['Tanggal'];
            $Tgl_Lahir = $data['Tgl_Lahir'];
            $PoliTujuan = $data['PoliTujuan'];

            $TinggalBersama = $data['TinggalBersama'];
            $Bahasa = $data['Bahasa'];
            $Hambatan = $data['Hambatan'];
            $KemampuanSolat = $data['KemampuanSolat'];
            $KemampuanMembacaAl_Quran = $data['KemampuanMembacaAl_Quran'];
            $EdukasiDiberikanKepada = $data['EdukasiDiberikanKepada'];
            $KemampuanBahasa = $data['KemampuanBahasa'];
            $PerluPenerjemah = $data['PerluPenerjemah'];
            $BacadanTulis = $data['BacadanTulis'];
            $Kepercayaanlainya = $data['Kepercayaanlainya'];
            $KesediaanMenerimaEdukasi = $data['KesediaanMenerimaEdukasi'];
            $CaraEdukasi = $data['CaraEdukasi'];
            $KebutuhanEdukasi = $data['KebutuhanEdukasi'];
            $KebutuhanEdukasiIslami = $data['KebutuhanEdukasiIslami'];

            if ($TinggalBersama == "") {
                $this->db->query("INSERT INTO  PerawatanSQL.dbo.FormEdukasiPasien (
                        [NoMR],
                        [NoRegistrasi],
                        [NoEpisode],
                        [NamaPasien],
                        [Tanggal],
                        [Tgl_Lahir],
                        [PoliTujuan],
                        [Tinggal_Bersama],
	[Bahasa]  ,
	[Hambatan]  ,
	[Kemampuan_Sholat]  ,
	[Kemampuan_Membaca_Al_Quran]  ,
	[Edukasi_Diberikan_Kepada]  ,
	[Kemampuan_Bahasa]  ,
	[Perlu_Penerjemah]  ,
	[BacadanTulis]  ,
	[Kepercayaan_Lainya]  ,
	[Kesediaan_Menerima_Edukasi]  ,
	[Cara_Edukasi]  ,
	[Kebutuhan_Edukasi]  ,
	[Kebutuhan_Edukasi_Islami] ) values (:NoMR,:NoRegistrasi,:NoEpisode,:NamaPasien,:Tanggal,:Tgl_Lahir,:PoliTujuan,:TinggalBersama,:Bahasa,:Hambatan,:KemampuanSolat,:KemampuanKemampuanMembacaAl_Quran,:EdukasiDiberikanKepada,:KemampuanBahasa,:PerluPenerjemah,:Kepercayaanlainya,:CaraEdukasi,:KemampuanBahasa,:KebutuhanEdukasi,:KebutuhanEdukasiIslami)
    ");
            } else {
                $this->db->query("INSERT INTO PerawatanSQL.dbo.FormEdukasiPasien (
[NoMR],
                        [NoRegistrasi],
                        [NoEpisode],
                        [NamaPasien],
                        [Tanggal],
                        [Tgl_Lahir],
                        [PoliTujuan],
                        [Tinggal_Bersama],	[Bahasa]  ,
	[Hambatan]  ,
	[Kemampuan_Sholat]  ,
	[Kemampuan_Membaca_Al_Quran]  ,
	[Edukasi_Diberikan_Kepada]  ,
	[Kemampuan_Bahasa]  ,
	[Perlu_Penerjemah]  ,
	[BacadanTulis]  ,
	[Kepercayaan_Lainya]  ,
	[Kesediaan_Menerima_Edukasi]  ,
	[Cara_Edukasi]  ,
	[Kebutuhan_Edukasi]  ,
	[Kebutuhan_Edukasi_Islami] ) values (:NoMR,:NoRegistrasi,:NoEpisode,:NamaPasien,:Tanggal,:Tgl_Lahir,:PoliTujuan,:TinggalBersama,:Bahasa,:Hambatan,:KemampuanSolat, :KemampuanMembacaAl_Quran ,:EdukasiDiberikanKepada,:KemampuanBahasa,:PerluPenerjemah,:BacadanTulis,:Kepercayaanlainya,:KesediaanMenerimaEdukasi,:CaraEdukasi,:KebutuhanEdukasi,:KebutuhanEdukasiIslami)
    ");
                $this->db->bind('NoMR', $NoMR);
                $this->db->bind('NoRegistrasi', $NoRegistrasi);
                $this->db->bind('NoEpisode', $NoEpisode);
                $this->db->bind('NamaPasien', $NamaPasien);
                $this->db->bind('Tanggal', $Tanggal);
                $this->db->bind('Tgl_Lahir', $Tgl_Lahir);
                $this->db->bind('PoliTujuan', $PoliTujuan);

                $this->db->bind('TinggalBersama', $TinggalBersama);
                $this->db->bind('Bahasa', $Bahasa);
                $this->db->bind('Hambatan', $Hambatan);
                $this->db->bind('KemampuanSolat', $KemampuanSolat);
                $this->db->bind('KemampuanMembacaAl_Quran', $KemampuanMembacaAl_Quran);
                $this->db->bind('EdukasiDiberikanKepada', $EdukasiDiberikanKepada);
                $this->db->bind('KemampuanBahasa', $KemampuanBahasa);
                $this->db->bind('PerluPenerjemah', $PerluPenerjemah);
                $this->db->bind('BacadanTulis', $BacadanTulis);
                $this->db->bind('Kepercayaanlainya', $Kepercayaanlainya);
                $this->db->bind('KesediaanMenerimaEdukasi', $KesediaanMenerimaEdukasi);
                $this->db->bind('CaraEdukasi', $CaraEdukasi);
                $this->db->bind('KebutuhanEdukasi', $KebutuhanEdukasi);
                $this->db->bind('KebutuhanEdukasiIslami', $KebutuhanEdukasiIslami);
                $this->db->execute();
                $this->db->commit();
                $callback = array(
                    'status' => 'success', // Set array status dengan success   
                    'message' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success    
                );
            }

            if (isset($_POST["submit"])) {

                $for_query = '';

                if (!empty($_POST["KebutuhanEdukasiIslami"])) {

                    foreach ($_POST["KebutuhanEdukasiIslami"] as $KebutuhanEdukasiIslami) {

                        $for_query .= $KebutuhanEdukasiIslami . ', ';
                    }
                }
            }






            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function GetFormEdu($data)
    {
        try {
            $IdRegistrasi = $data['IdRegistrasi'];

            $this->db->query("SELECT *
            from PerawatanSQL.dbo.FormEdukasiPasien where NoRegistrasi=:NoRegistrasi ");
            $this->db->bind('NoRegistrasi', $IdRegistrasi);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {

                $pasing['NoMR'] = $key['NoMR'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['NoEpisode'] = $key['NoEpisode'];
                $pasing['NamaPasien'] = $key['NamaPasien'];
                $pasing['Tanggal'] = $key['Tanggal'];
                $pasing['Tgl_Lahir'] = $key['Tgl_Lahir'];
                $pasing['PoliTujuan'] = $key['PoliTujuan'];
                $pasing['TinggalBersama'] = $key['TinggalBersama'];
                $pasing['Bahasa'] = $key['Bahasa'];
                $pasing['Hambatan'] = $key['Hambatan'];
                $pasing['KemampuanSolat'] = $key['KemampuanSolat'];
                $pasing['KemampuanMembacaAl_Quran'] = $key['KemampuanMembacaAl_Quran'];
                $pasing['EdukasiDiberikanKepada'] = $key['EdukasiDiberikanKepada'];
                $pasing['KemampuanBahasa'] = $key['KemampuanBahasa'];
                $pasing['PerluPenerjemah'] = $key['PerluPenerjemah'];
                $pasing['BacadanTulis'] = $key['BacadanTulis'];
                $pasing['Kepercayaanlainya'] = $key['Kepercayaanlainya'];
                $pasing['KesediaanMenerimaEdukasi'] = $key['KesediaanMenerimaEdukasi'];
                $pasing['CaraEdukasi'] = $key['CaraEdukasi'];
                $pasing['KebutuhanEdukasi'] = $key['KebutuhanEdukasi'];
                $pasing['KebutuhanEdukasiIslami'] = $key['KebutuhanEdukasiIslami'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
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
    // <<<<>>>>>>>
    public function InputTTD($data)
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
