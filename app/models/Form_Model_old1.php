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
            $NoMR = $data['PasienNoMR'];
            $NoRegistrasi = $data['pxNoRegistrasi'];
            // $NoEpisode = $data['pxnoEpisode'];
            $NamaPasien = $data['PasienNama'];
            $Tanggal = $data['tglregistrasi'];
            $Tgl_Lahir = $data['TglLahir'];
            $PoliTujuan = $data['poliklinikid'];

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
            $saksi_rumah_sakit = $data['saksi_rumah_sakit'];
            $saksi_pasiens = $data['saksi_pasiens'];
            $datenow = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $idEmploye = $session->IDEmployee; {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Data Kosong !',
                );
                return $callback;
                exit;
            }

            // if ($data['ID'] == "") {

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
            $this->db->bind('PasienNoMR', $NoMR);
            $this->db->bind('pxNoRegistrasi', $NoRegistrasi);
            // $this->db->bind('pxnoEpisode', $NoEpisode);
            $this->db->bind('PasienNama', $NamaPasien);
            $this->db->bind('tglregistrasi', $Tanggal);
            $this->db->bind('TglLahir', $Tgl_Lahir);
            $this->db->bind('poliklinikid', $PoliTujuan);

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
                'message' => 'Transkasi Berhasil Disimpan !' // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
}
