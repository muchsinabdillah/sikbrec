<?php

use Aws\S3\S3Client;
use Aws\Exception\MultipartUploadException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class  B_EMR_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // DATA PASIEN
    public function listPasienPoliklinikPerawat($data)
    {
        try {

            $this->db->query("SELECT View_PasienActive_EMR.ID, View_PasienActive_EMR.TTV, View_PasienActive_EMR.[Visit Date], View_PasienActive_EMR.NoEpisode, View_PasienActive_EMR.NoRegistrasi, 
            View_PasienActive_EMR.Unit, View_PasienActive_EMR.NamaUnit, View_PasienActive_EMR.NamaDokter, View_PasienActive_EMR.Doctor_1, View_PasienActive_EMR.NoMR, 
            View_PasienActive_EMR.IDPasien AS PID, View_PasienActive_EMR.PatientName, View_PasienActive_EMR.[Status ID], View_PasienActive_EMR.[Status Name], 
            View_PasienActive_EMR.[CodeAntrian] ,View_PasienActive_EMR.[Antrian] AS AntrianQ, View_PasienActive_EMR.Antrian, View_PasienActive_EMR.Aktif, View_PasienActive_EMR.FlagPanggil, View_PasienActive_EMR.[Mobile Phone] AS HP, 
            CASE WHEN PatientType=1 then 'UMUM' WHEN [PatientType]=2 then [View_PasienActive_EMR].[NamaAsuransi] WHEN [PatientType]=5 then [NamaPerusahaan] else 'Other' end AS penjamin, 
            BPJS_T_SEP.Task4, BPJS_T_SEP.Task5, 
            BPJS_T_SEP.NO_SEP, BPJS_T_SEP.KETERANGAN_PRB, BPJS_T_SEP.Task2
            FROM PerawatanSQL.dbo.View_PasienActive_EMR LEFT JOIN PerawatanSQL.dbo.BPJS_T_SEP ON View_PasienActive_EMR.NoRegistrasi = BPJS_T_SEP.NO_REGISTRASI
            WHERE View_PasienActive_EMR.Unit<>9 And View_PasienActive_EMR.Unit<>10 And View_PasienActive_EMR.Unit<>53
            ORDER BY View_PasienActive_EMR.ID DESC , View_PasienActive_EMR.TTV, View_PasienActive_EMR.[Visit Date], View_PasienActive_EMR.Doctor_1, View_PasienActive_EMR.Antrian");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = 0;
            foreach ($data as $key) {
                $no++;
                $nosep = '';
                if ($key['NO_SEP'] != null || $key['NO_SEP'] != '') {
                    $nosep = '<b>(No SEP: ' . $key['NO_SEP'] . ')</b>';
                }
                $pasing['no'] = $no;
                $pasing['ID'] = $key['ID'];
                $pasing['NoEpisode'] = $key['NoEpisode'];
                $pasing['Company'] = "";
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['LokasiPasien'] = $key['NamaUnit'];
                $pasing['Perusahaan'] = $key['penjamin'];
                $pasing['namauser'] = "";
                $pasing['NoSEP_edited'] = $nosep;
                $pasing['NoSEP'] = $key['NO_SEP'];
                $pasing['Telemedicine'] = "";
                $pasing['VisitDate'] = date('d/m/Y H:i:s', strtotime($key['Visit Date']));
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['PatientName'] = $key['PatientName'];
                $pasing['DokterName'] = $key['NamaDokter'];
                $pasing['Task2'] = $key['Task2'];
                $pasing['Task4'] = $key['Task4'];
                $pasing['Task5'] = $key['Task5'];
                $pasing['HakKelasBPJS'] = "";
                $pasing['PRB'] = "";
                $pasing['NoPesertaBPJS'] = "";

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
    public function getDataPasien($data)
    {
        try {
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $idemployee = $session->IDEmployee;
            $token = $session->token;
            $namauserx = $session->name;
            // var_dump($data, 'ddddd');
            $noregistrasi = $data['NoRegistrasi'];
            $this->db->query("SELECT a.ID, a.NoMR, b.PatientName, replace(CONVERT(VARCHAR(11), b.Date_of_birth, 111), '/','-') as Date_of_birth, b.[Mobile Phone] AS No_Phone, 
                        b.Nik, b.Ocupation, b.Address, b.Religion, b.Gander, a.NoRegistrasi, replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as TglKunjungan,
                        a.NoEpisode, c.First_Name, d.NamaUnit, d.ID AS IDUNIT,a.Doctor_1 as idDokter,
                        a.PatientType,
                        datediff(month, b.Date_of_birth, getdate()) /12 TAHUN, datediff(month, b.Date_of_birth, getdate()) %12 BULAN ,
                        CASE when a.PatientType ='1' THEN F.NamaPerusahaan 
                        when a.PatientType ='2' THEN e.NamaPerusahaan 
                        when a.PatientType ='5' THEN F.NamaPerusahaan 
                        end as NamaPerusahaan 
                        FROM PerawatanSQL.dbo.Visit a
                        INNER JOIN MasterdataSQL.dbo.Admision b on b.NoMR = a.NoMR
                        LEFT JOIN MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                        LEFT JOIN MasterdataSQL.dbo.MstrUnitPerwatan d on d.ID = a.Unit
                        left join MasterdataSQL.dbo.MstrPerusahaanAsuransi e on e.ID= a.Asuransi
                        left join MasterdataSQL.dbo.MstrPerusahaanJPK f on f.ID= a.Perusahaan
            WHERE a.NoRegistrasi = :noreg");
            $this->db->bind('noreg', $noregistrasi);
            $key =  $this->db->single();
            $pasing['ID'] = $key['ID'];
            $pasing['NoMR'] = $key['NoMR'];
            $pasing['PatientName'] = $key['PatientName'];
            $pasing['NamaPerusahaan'] = $key['NamaPerusahaan'];

            // $pasing['Date_of_birth'] = date('d/m/Y', strtotime($key['Date_of_birth']));
            $pasing['Date_of_birth'] = $key['Date_of_birth'];
            $pasing['No_Phone'] = $key['No_Phone'];
            $pasing['Nik'] = $key['Nik'];
            $pasing['Pekerjaan'] = $key['Ocupation'];
            $pasing['Address'] = $key['Address'];
            $pasing['Religion'] = $key['Religion'];
            $pasing['Gander'] = $key['Gander'];
            $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
            $pasing['TglKunjungan'] = $key['TglKunjungan'];
            $pasing['NoEpisode'] = $key['NoEpisode'];
            $pasing['First_Name'] = $key['First_Name'];
            $pasing['idDokter'] = $key['idDokter'];
            $pasing['NamaUnit'] = $key['NamaUnit'];
            $pasing['IDUNIT'] = $key['IDUNIT'];
            $pasing['IdUser'] = $userid;
            $pasing['IdEmploye'] = $idemployee;
            $pasing['NamaUser'] = $namauserx;

            $pasing['as_year'] = $key['TAHUN'] . ' ' . 'Tahun' . ' ' . $key['BULAN'] . ' ' . 'Bulan';



            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // DATA WAKIL PASIEN
    public function getDataWakilPasien($data)
    {
        try {
            $noregistrasi = $data['NoRegistrasi'];
            $this->db->query("SELECT * FROM EMR.dbo.OutpatientWakilPasien WHERE No_Registrasi = :noreg1");
            $this->db->bind('noreg1', $noregistrasi);
            $key =  $this->db->single();
            $pasing['ID'] = $key['ID'];
            $pasing['Nama_Wakil_Pasien'] = $key['Nama_Wakil_Pasien'];
            $pasing['Umur_Wakil_Paisen'] = $key['Umur_Wakil_Paisen'];
            $pasing['NoHp_Wakil_Pasien'] = $key['NoHp_Wakil_Pasien'];
            $pasing['NIK_Wakil_Pasien'] = $key['NIK_Wakil_Pasien'];
            $pasing['Pekerjaan_Wakil_Pasien'] = $key['Pekerjaan_Wakil_Pasien'];
            $pasing['Alamat_Wakil_Pasien'] = $key['Alamat_Wakil_Pasien'];
            $pasing['Hubungan_Wakil_Pasien'] = $key['Hubungan_Wakil_Pasien'];
            $pasing['Keterangan_Wakil_Pasien'] = $key['Keterangan_Wakil_Pasien'];
            $pasing['JenisKelamin_Wakil_Pasien'] = $key['JenisKelamin_Wakil_Pasien'];
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // EMR ASSESMENT RAWAT JALAN
    public function getDataAssesment($data)
    {
        try {
            $noregistrasi = $data['NoRegistrasi'];

            // ASSESMENT
            $this->db->query("SELECT Keluhan_Utama, Pernapasan, Tensi, Sistole, Diastole, Suhu, Nadi, SpO2, Tinggi_Badan, Berat_Badan, Hamil, Menyusui, Riwayat_Alergi, Riwayat_Alergi_Detail, NA_Assesment, Pulang, Rawat_Inap, Rujuk_Detail, Rujuk FROM EMR.dbo.OutpatientAssesments WHERE No_Registrasi = :noreg1");
            $this->db->bind('noreg1', $noregistrasi);
            $key =  $this->db->single();
            $pasing['Keluhan_Utama'] = $key['Keluhan_Utama'];
            $pasing['Pernapasan'] = $key['Pernapasan'];
            $pasing['Tensi'] = $key['Tensi'];
            $pasing['Sistole'] = $key['Sistole'];
            $pasing['Diastole'] = $key['Diastole'];
            $pasing['Suhu'] = $key['Suhu'];
            $pasing['Nadi'] = $key['Nadi'];
            $pasing['SpO2'] = $key['SpO2'];
            $pasing['Tinggi_Badan'] = $key['Tinggi_Badan'];
            $pasing['Berat_Badan'] = $key['Berat_Badan'];
            $pasing['Hamil'] = $key['Hamil'];
            $pasing['Menyusui'] = $key['Menyusui'];
            $pasing['Riwayat_Alergi'] = $key['Riwayat_Alergi'];
            $pasing['Riwayat_Alergi_Detail'] = $key['Riwayat_Alergi_Detail'];
            $pasing['NA_Assesment'] = $key['NA_Assesment'];

            $pasing['Pulang'] = $key['Pulang'];
            $pasing['Rawat_Inap'] = $key['Rawat_Inap'];
            $pasing['Rujuk_Detail'] = $key['Rujuk_Detail'];
            $pasing['Rujuk'] = $key['Rujuk'];


            // TRIAGE COVID
            $this->db->query("SELECT * FROM EMR.dbo.OutpatientTriageCovid19 WHERE No_Registrasi = :noreg2");
            $this->db->bind('noreg2', $noregistrasi);
            $key =  $this->db->single();
            $pasing['Batuk_SakitTenggorokan_HidungTersumbat'] = $key['Batuk_SakitTenggorokan_HidungTersumbat'];
            $pasing['Sesak_PeningkatanFreskuensiNafas'] = $key['Sesak_PeningkatanFreskuensiNafas'];
            $pasing['Demam_1'] = $key['Demam_1'];
            $pasing['Riwayat_Kontak_Pasien_Covid'] = $key['Riwayat_Kontak_Pasien_Covid'];
            $pasing['Riwayat_Perjalanan'] = $key['Riwayat_Perjalanan'];
            $pasing['Tanda_Pneumia'] = $key['Tanda_Pneumia'];
            $pasing['Riwayat_Kontak_Pasien_Covid_2'] = $key['Riwayat_Kontak_Pasien_Covid_2'];
            $pasing['Demam_2'] = $key['Demam_2'];
            $pasing['Usia_Diatas_43Thn'] = $key['Usia_Diatas_43Thn'];
            $pasing['Jenis_Kelamin'] = $key['Jenis_Kelamin'];
            $pasing['Suhu_Max_38C'] = $key['Suhu_Max_38C'];
            $pasing['Gejala_Gangguan_Respirasi'] = $key['Gejala_Gangguan_Respirasi'];
            $pasing['RasioNeutrofildanLimfosit_lebihdari_57'] = $key['RasioNeutrofildanLimfosit_lebihdari_57'];

            // TBC
            $this->db->query("SELECT * FROM EMR.dbo.OutpatientSkriningTBC WHERE No_Registrasi = :noreg3");
            $this->db->bind('noreg3', $noregistrasi);
            $key =  $this->db->single();
            $pasing['NA_Skrining_TBC'] = $key['NA_Skrining_TBC'];
            $pasing['Batuk_Max_2Minggu'] = $key['Batuk_Max_2Minggu'];
            $pasing['Dahak_Bercampur_Darah'] = $key['Dahak_Bercampur_Darah'];
            $pasing['DemamMeriang_Max_1Bulan'] = $key['DemamMeriang_Max_1Bulan'];
            $pasing['Sesak_Nafas'] = $key['Sesak_Nafas'];
            $pasing['Riwayat_Batuk_Berdarah'] = $key['Riwayat_Batuk_Berdarah'];
            $pasing['Lemah'] = $key['Lemah'];
            $pasing['Badan_Lemas_Berdarah'] = $key['Badan_Lemas_Berdarah'];
            $pasing['Keringatan_Malam_Tanpa_Aktifitas'] = $key['Keringatan_Malam_Tanpa_Aktifitas'];
            $pasing['BB_Menurun_Drastis'] = $key['BB_Menurun_Drastis'];
            $pasing['Kesimpulan_Negatif'] = $key['Kesimpulan_Negatif'];
            $pasing['Kesimpulan_ODP_PDP'] = $key['Kesimpulan_ODP_PDP'];
            $pasing['Kesimpulan_Tuberkulosis'] = $key['Kesimpulan_Tuberkulosis'];
            $pasing['Kesimpulan_Pinere_Lainnya'] = $key['Kesimpulan_Pinere_Lainnya'];

            //ANAMNESIS
            $this->db->query("SELECT * FROM EMR.dbo.OutpatientAnamnesis WHERE No_Registrasi = :noreg4");
            $this->db->bind('noreg4', $noregistrasi);
            $key =  $this->db->single();
            $pasing['Anamnesis'] = $key['Anamnesis'];
            $pasing['Keluhan_Utama_Anamnesis'] = $key['Keluhan_Utama_Anamnesis'];
            $pasing['Riwayat_Penyakit_Sekarang'] = $key['Riwayat_Penyakit_Sekarang'];
            $pasing['Riwayat_Penyakit_Terdahulu'] = $key['Riwayat_Penyakit_Terdahulu'];
            $pasing['Riwayat_Penyakit_Terdahulu_Detail'] = $key['Riwayat_Penyakit_Terdahulu_Detail'];
            $pasing['Riwayat_Pembedahan'] = $key['Riwayat_Pembedahan'];
            $pasing['Riwayat_Pembedahan_Detail'] = $key['Riwayat_Pembedahan_Detail'];
            $pasing['Riwayat_Rawat_Sebelumnya'] = $key['Riwayat_Rawat_Sebelumnya'];
            $pasing['Riwayat_Rawat_Sebelumnya_Detail'] = $key['Riwayat_Rawat_Sebelumnya_Detail'];
            $pasing['Obat_Rutin_Dari_Rumah'] = $key['Obat_Rutin_Dari_Rumah'];
            $pasing['Obat_Rutin_Dari_Rumah_Detail'] = $key['Obat_Rutin_Dari_Rumah_Detail'];

            //SKRINNING JATUH
            $this->db->query("SELECT * FROM EMR.dbo.OutpatientSkriningResikoJatuh WHERE No_Registrasi = :noreg5");
            $this->db->bind('noreg5', $noregistrasi);
            $key =  $this->db->single();
            $pasing['NA_Skrining_Jatuh_Anak'] = $key['NA_Skrining_Jatuh_Anak'];
            $pasing['Riwayat_Jatuh_Dalam_3Bulan'] = $key['Riwayat_Jatuh_Dalam_3Bulan'];
            $pasing['Riwayat_Seizures'] = $key['Riwayat_Seizures'];
            $pasing['Anak_Konsumsi_Narkotik'] = $key['Anak_Konsumsi_Narkotik'];
            $pasing['Risiko_Rendah_Jatuh_Anak'] = $key['Risiko_Rendah_Jatuh_Anak'];
            $pasing['Risiko_Tinggi_Jatuh_Anak'] = $key['Risiko_Tinggi_Jatuh_Anak'];
            $pasing['NA_Skrining_Jatuh_Dewasa'] = $key['NA_Skrining_Jatuh_Dewasa'];
            $pasing['Cara_Berjalan_Saat_Akan_Duduk'] = $key['Cara_Berjalan_Saat_Akan_Duduk'];
            $pasing['Pasien_Memegang_Pinggiran_Kursi'] = $key['Pasien_Memegang_Pinggiran_Kursi'];
            $pasing['Risiko_Rendah_Jatuh_Dewasa'] = $key['Risiko_Rendah_Jatuh_Dewasa'];
            $pasing['Risiko_Tinggi_Jatuh_Dewasa'] = $key['Risiko_Tinggi_Jatuh_Dewasa'];
            $pasing['Keluhan_Nyeri'] = $key['Keluhan_Nyeri'];
            $pasing['Lokasi_Nyeri'] = $key['Lokasi_Nyeri'];
            $pasing['Nyeri_Timbul_Sejak'] = $key['Nyeri_Timbul_Sejak'];
            $pasing['Frekwensi_Nyeri'] = $key['Frekwensi_Nyeri'];
            $pasing['Karakteristik_Nyeri'] = $key['Karakteristik_Nyeri'];
            $pasing['Etensitas_Nyeri'] = $key['Etensitas_Nyeri'];
            $pasing['Metode_Penilaian_Nyeri'] = $key['Metode_Penilaian_Nyeri'];
            $pasing['Tipe_Nyeri'] = $key['Tipe_Nyeri'];
            $pasing['Pencetus_Nyeri'] = $key['Pencetus_Nyeri'];
            $pasing['Pereda_Nyeri'] = $key['Pereda_Nyeri'];
            $pasing['Tindakan_Mandiri_Perawat'] = $key['Tindakan_Mandiri_Perawat'];
            $pasing['Tindakan_Mandiri_Perawat_Detail'] = $key['Tindakan_Mandiri_Perawat_Detail'];
            $pasing['Kolaborasi'] = $key['Kolaborasi'];
            $pasing['Kolaborasi_Detail'] = $key['Kolaborasi_Detail'];

            //SKRINNING NUTRISI
            $this->db->query("SELECT * FROM EMR.dbo.OutPatientSkriningNutrisi WHERE No_Registrasi = :noreg6");
            $this->db->bind('noreg6', $noregistrasi);
            $key =  $this->db->single();
            $pasing['NA_Skrining_Nutrisi_Anak'] = $key['NA_Skrining_Nutrisi_Anak'];
            $pasing['Resiko_Nutrisional'] = $key['Resiko_Nutrisional'];
            $pasing['Tampak_Kurus'] = $key['Tampak_Kurus'];
            $pasing['Penurunan_BB_1Bulan_Terakhir'] = $key['Penurunan_BB_1Bulan_Terakhir'];
            $pasing['Terdapat_Kondisi_DiareMuntahKurangasupan'] = $key['Terdapat_Kondisi_DiareMuntahKurangasupan'];
            $pasing['RiwayatPenyakit_Beresiko_Malnutrisi'] = $key['RiwayatPenyakit_Beresiko_Malnutrisi'];
            $pasing['Diare_Konik'] = $key['Diare_Konik'];
            $pasing['Penyakit_Jantung_Bawaan'] = $key['Penyakit_Jantung_Bawaan'];
            $pasing['HIV'] = $key['HIV'];
            $pasing['Kanker'] = $key['Kanker'];
            $pasing['Penyakit_Hati_Kronik'] = $key['Penyakit_Hati_Kronik'];
            $pasing['Penyakit_Ginjal_Kronik'] = $key['Penyakit_Ginjal_Kronik'];
            $pasing['TB_Paru'] = $key['TB_Paru'];
            $pasing['Terpasang_Stoma'] = $key['Terpasang_Stoma'];
            $pasing['Tauma'] = $key['Tauma'];
            $pasing['Luka_Bakar_Luas'] = $key['Luka_Bakar_Luas'];
            $pasing['Kelainan_Anatomi_Daerah_Mulut'] = $key['Kelainan_Anatomi_Daerah_Mulut'];
            $pasing['Pasca_Operasi'] = $key['Pasca_Operasi'];
            $pasing['Kelainan_Metabolik_Bawaan'] = $key['Kelainan_Metabolik_Bawaan'];
            $pasing['Retardasi_Metal'] = $key['Retardasi_Metal'];
            $pasing['Keterlambatan_Perkembangan'] = $key['Keterlambatan_Perkembangan'];
            $pasing['Nilai_Skor_Malnutrisi'] = $key['Nilai_Skor_Malnutrisi'];
            $pasing['Resiko_Tinggi_Skrining_Nutrisi_Anak'] = $key['Resiko_Tinggi_Skrining_Nutrisi_Anak'];
            $pasing['NA_Skrining_Nutrisi_Dewasa'] = $key['NA_Skrining_Nutrisi_Dewasa'];
            $pasing['Nilai_Skor_Nutirisi_Dewasa'] = $key['Nilai_Skor_Nutirisi_Dewasa'];
            $pasing['Penurunan_BB_6Bulan_TidakDisengaja'] = $key['Penurunan_BB_6Bulan_TidakDisengaja'];
            $pasing['Skala_Penurunan_BB'] = $key['Skala_Penurunan_BB'];
            $pasing['Asupan_Makanan_Berkurang'] = $key['Asupan_Makanan_Berkurang'];
            $pasing['Pasien_Kebutuhan_Khusus'] = $key['Pasien_Kebutuhan_Khusus'];
            $pasing['Resiko_Tinggi_Skrining_Nutrisi_Dewasa'] = $key['Resiko_Tinggi_Skrining_Nutrisi_Dewasa'];
            $pasing['NA_Skrining_Nutrisi_Ibu_Hamil'] = $key['NA_Skrining_Nutrisi_Ibu_Hamil'];
            $pasing['LILA'] = $key['LILA'];

            //KEBUTUHAN KOMUNIKASI
            $this->db->query("SELECT * FROM EMR.dbo.OutpatientComunicationEducation WHERE No_Registrasi = :noreg7");
            $this->db->bind('noreg7', $noregistrasi);
            $key =  $this->db->single();
            $pasing['Fungsi_Bicara'] = $key['Fungsi_Bicara'];
            $pasing['Fungsi_Bicara_Detail'] = $key['Fungsi_Bicara_Detail'];
            $pasing['Bahasa_Sehari_Hari'] = $key['Bahasa_Sehari_Hari'];
            $pasing['Bahasa_Sehari_Hari_Detail'] = $key['Bahasa_Sehari_Hari_Detail'];
            $pasing['Perlu_Penerjemah'] = $key['Perlu_Penerjemah'];
            $pasing['Perlu_Penerjemah_Detail'] = $key['Perlu_Penerjemah_Detail'];
            $pasing['Bahasa_Isyarat'] = $key['Bahasa_Isyarat'];
            $pasing['Bahasa_Isyarat_Detail'] = $key['Bahasa_Isyarat_Detail'];
            $pasing['Hambatan_Belajar_Secara_Fisik'] = $key['Hambatan_Belajar_Secara_Fisik'];
            $pasing['Hambatan_Belajar_Secara_Fisik_Detail'] = $key['Hambatan_Belajar_Secara_Fisik_Detail'];
            $pasing['Hambatan_Belajar_Secara_Budaya'] = $key['Hambatan_Belajar_Secara_Budaya'];
            $pasing['Hambatan_Belajar_Secara_Budaya_Detai'] = $key['Hambatan_Belajar_Secara_Budaya_Detai'];
            $pasing['Hambatan_Belajar_Secara_Bahasa'] = $key['Hambatan_Belajar_Secara_Bahasa'];
            $pasing['Hambatan_Belajar_Secara_Bahasa_Detail'] = $key['Hambatan_Belajar_Secara_Bahasa_Detail'];
            $pasing['Hambatan_Belajar_Secara_Emosi'] = $key['Hambatan_Belajar_Secara_Emosi'];
            $pasing['Hambatan_Belajar_Secara_Emosi_Detail'] = $key['Hambatan_Belajar_Secara_Emosi_Detail'];
            $pasing['Pengobatan'] = $key['Pengobatan'];
            $pasing['Nutrisi'] = $key['Nutrisi'];
            $pasing['Tindakan_Medis'] = $key['Tindakan_Medis'];
            $pasing['keperawatan'] = $key['keperawatan'];
            $pasing['Kebutuhan_Lain'] = $key['Kebutuhan_Lain'];
            $pasing['Kebutuhan_Lain_Detail'] = $key['Kebutuhan_Lain_Detail'];

            //SPIRITUAL
            $this->db->query("SELECT * FROM EMR.dbo.OutpatientPsikososialEkonomiSpiritual WHERE No_Registrasi = :noreg8");
            $this->db->bind('noreg8', $noregistrasi);
            $key =  $this->db->single();
            $pasing['TingkatPendidikan'] = $key['TingkatPendidikan'];
            $pasing['TingkatPendidikan_Detail'] = $key['TingkatPendidikan_Detail'];
            $pasing['Pekerjaan'] = $key['Pekerjaan'];
            $pasing['Pekerjaan_Detail'] = $key['Pekerjaan_Detail'];
            $pasing['Tinggal_Bersama'] = $key['Tinggal_Bersama'];
            $pasing['Tinggal_Bersama_Detail'] = $key['Tinggal_Bersama_Detail'];
            $pasing['Tenang'] = $key['Tenang'];
            $pasing['Sedih_Menangis_MenarikDiri'] = $key['Sedih_Menangis_MenarikDiri'];
            $pasing['Cemas_Gelisah'] = $key['Cemas_Gelisah'];
            $pasing['TakutTerapi_Tindakan_Lingkungan'] = $key['TakutTerapi_Tindakan_Lingkungan'];
            $pasing['Marah_Mudah_Tersinggung'] = $key['Marah_Mudah_Tersinggung'];

            $pasing['Agama'] = $key['Agama'];
            $pasing['Agama_Detail'] = $key['Agama_Detail'];
            $pasing['Hambatan_Menjalankan_Ibadah'] = $key['Hambatan_Menjalankan_Ibadah'];
            $pasing['Hambatan_Menjalankan_Ibadah_Detail'] = $key['Hambatan_Menjalankan_Ibadah_Detail'];
            $pasing['Nilai_Kepercayaan_Dianut'] = $key['Nilai_Kepercayaan_Dianut'];
            $pasing['Nilai_Kepercayaan_Dianut_Detail'] = $key['Nilai_Kepercayaan_Dianut_Detail'];
            $pasing['Pantang_Makanan_Minuman'] = $key['Pantang_Makanan_Minuman'];
            $pasing['Pantang_Makanan_Minuman_Detail'] = $key['Pantang_Makanan_Minuman_Detail'];
            $pasing['Riwayat_Tindak_Kekerasan'] = $key['Riwayat_Tindak_Kekerasan'];
            $pasing['Riwayat_Tindak_Kekerasan_Detail'] = $key['Riwayat_Tindak_Kekerasan_Detail'];

            //KEPERAWATAN GIGI
            $this->db->query("SELECT * FROM EMR.dbo.OutpatientKeperawatanGigi WHERE No_Registrasi = :noreg9");
            $this->db->bind('noreg9', $noregistrasi);
            $key =  $this->db->single();
            $pasing['NA_Keperawatan_Gigi'] = $key['NA_Keperawatan_Gigi'];
            $pasing['Riwayat_Perawatan_Gigi'] = $key['Riwayat_Perawatan_Gigi'];
            $pasing['Riwayat_Perawatan_Gigi_Detail'] = $key['Riwayat_Perawatan_Gigi_Detail'];
            $pasing['TakutCemas_Setelah_PerawatanGigi'] = $key['TakutCemas_Setelah_PerawatanGigi'];
            $pasing['Pemeliharaan_Gigi_Baik'] = $key['Pemeliharaan_Gigi_Baik'];
            $pasing['SikatGigi_Min_2xSehari'] = $key['SikatGigi_Min_2xSehari'];
            $pasing['Menyikat_Gigi_Benar'] = $key['Menyikat_Gigi_Benar'];
            $pasing['Mengurangi_Makanan_ManisLengket'] = $key['Mengurangi_Makanan_ManisLengket'];
            $pasing['Warna_Bibir'] = $key['Warna_Bibir'];
            $pasing['Bibir_Simetris'] = $key['Bibir_Simetris'];
            $pasing['Bibir_Simetris_Detail'] = $key['Bibir_Simetris_Detail'];
            $pasing['Bibir_Lembab'] = $key['Bibir_Lembab'];
            $pasing['Bibir_Lembab_Detail'] = $key['Bibir_Lembab_Detail'];
            $pasing['Bibir_Pecah_Pecah'] = $key['Bibir_Pecah_Pecah'];
            $pasing['Bibir_Berdarah'] = $key['Bibir_Berdarah'];
            $pasing['Bibir_Biru'] = $key['Bibir_Biru'];
            $pasing['Bibir_Pucat'] = $key['Bibir_Pucat'];
            $pasing['Bibir_Bengkak'] = $key['Bibir_Bengkak'];
            $pasing['BB_Lahir'] = $key['BB_Lahir'];
            $pasing['TB_Lahir'] = $key['TB_Lahir'];
            $pasing['Cacat_Bawaan'] = $key['Cacat_Bawaan'];
            $pasing['Cacat_Bawaan_Detail'] = $key['Cacat_Bawaan_Detail'];
            $pasing['Penyakit_Setelah_Lahir'] = $key['Penyakit_Setelah_Lahir'];
            $pasing['Penyakit_Setelah_Lahir_Detail'] = $key['Penyakit_Setelah_Lahir_Detail'];
            $pasing['BCG'] = $key['BCG'];
            $pasing['BCG_Usia'] = $key['BCG_Usia'];
            $pasing['DPT'] = $key['DPT'];
            $pasing['DPT_Usia1'] = $key['DPT_Usia1'];
            $pasing['Polio'] = $key['Polio'];
            $pasing['Polio_Usia'] = $key['Polio_Usia'];
            $pasing['Campak'] = $key['Campak'];
            $pasing['Campak_Usia'] = $key['Campak_Usia'];
            $pasing['MMR'] = $key['MMR'];
            $pasing['MMR_Usia'] = $key['MMR_Usia'];
            $pasing['HEPB'] = $key['HEPB'];
            $pasing['HEPB_Usia1'] = $key['HEPB_Usia1'];
            $pasing['HEPA'] = $key['HEPA'];
            $pasing['HEPA_Usia'] = $key['HEPA_Usia'];
            $pasing['Boster'] = $key['Boster'];
            $pasing['Boster_Usia'] = $key['Boster_Usia'];
            $pasing['HIBI'] = $key['HIBI'];
            $pasing['HIBI_Usia'] = $key['HIBI_Usia'];
            $pasing['Varicela'] = $key['Varicela'];
            $pasing['Varicela_Usia'] = $key['Varicela_Usia'];
            $pasing['Rotavirus'] = $key['Rotavirus'];
            $pasing['Rotavirus_Usia'] = $key['Rotavirus_Usia'];
            $pasing['Thypoid'] = $key['Thypoid'];
            $pasing['Thypoid_Usia'] = $key['Thypoid_Usia'];
            $pasing['Influenza'] = $key['Influenza'];
            $pasing['Influenza_Usia'] = $key['Influenza_Usia'];
            $pasing['Riwayat_Asi'] = $key['Riwayat_Asi'];
            $pasing['Susu_Formnula'] = $key['Susu_Formnula'];
            $pasing['Makanan_Tambahan'] = $key['Makanan_Tambahan'];
            $pasing['kelainan_Pertumbuhan'] = $key['kelainan_Pertumbuhan'];
            $pasing['kelainan_Pertumbuhan_Detail'] = $key['kelainan_Pertumbuhan_Detail'];
            $pasing['Pneunomia'] = $key['Pneunomia'];
            $pasing['Pneunomia_Usia'] = $key['Pneunomia_Usia'];

            // DISCHARGE PLANNING
            $this->db->query("SELECT * FROM EMR.dbo.OutpatientDischargePlaning WHERE No_Registrasi = :noreg10");
            $this->db->bind('noreg10', $noregistrasi);
            $key =  $this->db->single();
            $pasing['Butuhkan_Bantuan_Untuk_Aktifitas'] = $key['Butuhkan_Bantuan_Untuk_Aktifitas'];
            $pasing['Butuhkan_Bantuan_Untuk_Aktifitas_Detail'] = $key['Butuhkan_Bantuan_Untuk_Aktifitas_Detail'];
            $pasing['Butuh_Peralatan_Medis_Setelah_Dari_RS'] = $key['Butuh_Peralatan_Medis_Setelah_Dari_RS'];
            $pasing['Butuh_Peralatan_Medis_Setelah_Dari_RS_Detail'] = $key['Butuh_Peralatan_Medis_Setelah_Dari_RS_Detail'];
            $pasing['Perlu_Edukasi_Kesehatan_Setelah_Dari_RS'] = $key['Perlu_Edukasi_Kesehatan_Setelah_Dari_RS'];
            $pasing['Perlu_Edukasi_Kesehatan_Setelah_Dari_RS_Detail'] = $key['Perlu_Edukasi_Kesehatan_Setelah_Dari_RS_Detail'];
            $pasing['Tinggal_Sendiri_Setelah_Dari_RS'] = $key['Tinggal_Sendiri_Setelah_Dari_RS'];
            $pasing['Tinggal_Sendiri_Setelah_Dari_RS_Detail'] = $key['Tinggal_Sendiri_Setelah_Dari_RS_Detail'];
            $pasing['Perawatan_Lanjutan_Setelah_Dari_RS'] = $key['Perawatan_Lanjutan_Setelah_Dari_RS'];
            $pasing['Perawatan_Lanjutan_Setelah_Dari_RS_Detail'] = $key['Perawatan_Lanjutan_Setelah_Dari_RS_Detail'];
            $pasing['TempatTinggal_Dekat_Pelayanan_Kesehatan'] = $key['TempatTinggal_Dekat_Pelayanan_Kesehatan'];
            $pasing['TempatTinggal_Dekat_Pelayanan_Kesehatan_Detail'] = $key['TempatTinggal_Dekat_Pelayanan_Kesehatan_Detail'];
            $pasing['Ada_Yang_Merawat_Dirumah'] = $key['Ada_Yang_Merawat_Dirumah'];
            $pasing['Ada_Yang_Merawat_Dirumah_Detail'] = $key['Ada_Yang_Merawat_Dirumah_Detail'];
            $pasing['Nyeri_Kronis_Kelelahan'] = $key['Nyeri_Kronis_Kelelahan'];
            $pasing['Nyeri_Kronis_Kelelahan_Detail'] = $key['Nyeri_Kronis_Kelelahan_Detail'];
            $pasing['Memerlukan_Transportasi'] = $key['Memerlukan_Transportasi'];
            $pasing['Memerlukan_Transportasi_Detail'] = $key['Memerlukan_Transportasi_Detail'];
            $pasing['Perlu_Bantuan_Khusus'] = $key['Perlu_Bantuan_Khusus'];
            $pasing['Perlu_Bantuan_Khusus_Detail'] = $key['Perlu_Bantuan_Khusus_Detail'];
            $pasing['No_RM'] = $key['No_RM'];
            $pasing['No_Registrasi'] = $key['No_Registrasi'];
            $pasing['User_Input'] = $key['User_Input'];


            // DISCHARGE PLANNING
            $this->db->query("SELECT * FROM EMR.dbo.EyesAssesment WHERE NoRegistrasi = :noreg11");
            $this->db->bind('noreg11', $noregistrasi);
            $key =  $this->db->single();
            $pasing['Anamnesis'] = $key['Anamnesis'];
            $pasing['PemerisaanMata'] = $key['PemerisaanMata'];
            $pasing['Tako_AVOD'] = $key['Tako_AVOD'];
            $pasing['Tako_AVOS'] = $key['Tako_AVOS'];
            $pasing['Seko_AVODS'] = $key['Seko_AVODS'];
            $pasing['Seko_AVODC'] = $key['Seko_AVODC'];
            $pasing['Seko_AVODAxis'] = $key['Seko_AVODAxis'];
            $pasing['Seko_AVODMenjadi'] = $key['Seko_AVODMenjadi'];
            $pasing['Seko_AVODKet'] = $key['Seko_AVODKet'];
            $pasing['Seko_AVOSS'] = $key['Seko_AVOSS'];
            $pasing['Seko_AVOSC'] = $key['Seko_AVOSC'];
            $pasing['Seko_AVOSAxis'] = $key['Seko_AVOSAxis'];
            $pasing['Seko_AVOSMenjadi'] = $key['Seko_AVOSMenjadi'];
            $pasing['Seko_AVOSKet'] = $key['Seko_AVOSKet'];
            $pasing['Seko_Add'] = $key['Seko_Add'];
            $pasing['Seko_PD'] = $key['Seko_PD'];
            $pasing['Kcmt_AVODS'] = $key['Kcmt_AVODS'];
            $pasing['Kcmt_AVODC'] = $key['Kcmt_AVODC'];
            $pasing['Kcmt_AVODAxis'] = $key['Kcmt_AVODAxis'];
            $pasing['Kcmt_AVODMenjadi'] = $key['Kcmt_AVODMenjadi'];
            $pasing['Kcmt_AVOSS'] = $key['Kcmt_AVOSS'];
            $pasing['Kcmt_AVOSC'] = $key['Kcmt_AVOSC'];
            $pasing['Kcmt_AVOSAxis'] = $key['Kcmt_AVOSAxis'];
            $pasing['Kcmt_AVOSMenjadi'] = $key['Kcmt_AVOSMenjadi'];
            $pasing['Kcmt_Add'] = $key['Kcmt_Add'];
            $pasing['PalpebraKa'] = $key['PalpebraKa'];
            $pasing['PalpebraKaNote'] = $key['PalpebraKaNote'];
            $pasing['PalpebraKi'] = $key['PalpebraKi'];
            $pasing['PalpebraKiNote'] = $key['PalpebraKiNote'];
            $pasing['KonjungtivaKa'] = $key['KonjungtivaKa'];
            $pasing['KonjungtivaKaNote'] = $key['KonjungtivaKaNote'];
            $pasing['KonjungtivaKi'] = $key['KonjungtivaKi'];
            $pasing['KonjungtivaKiNote'] = $key['KonjungtivaKiNote'];
            $pasing['KorneaKa'] = $key['KorneaKa'];
            $pasing['KorneaKaNote'] = $key['KorneaKaNote'];
            $pasing['KorneaKi'] = $key['KorneaKi'];
            $pasing['KorneaKiNote'] = $key['KorneaKiNote'];
            $pasing['KameraKa'] = $key['KameraKa'];
            $pasing['KameraKaNote'] = $key['KameraKaNote'];
            $pasing['KameraKi'] = $key['KameraKi'];
            $pasing['KameraKiNote'] = $key['KameraKiNote'];
            $pasing['PupilKa'] = $key['PupilKa'];
            $pasing['PupilKaNote'] = $key['PupilKaNote'];
            $pasing['PupilKi'] = $key['PupilKi'];
            $pasing['PupilKiNote'] = $key['PupilKiNote'];
            $pasing['IrisKa'] = $key['IrisKa'];
            $pasing['IriKaNote'] = $key['IriKaNote'];
            $pasing['IriKi'] = $key['IriKi'];
            $pasing['IriKiNote'] = $key['IriKiNote'];
            $pasing['LensaKa'] = $key['LensaKa'];
            $pasing['LenasKaNote'] = $key['LenasKaNote'];
            $pasing['LensaKi'] = $key['LensaKi'];
            $pasing['LensaKiNote'] = $key['LensaKiNote'];
            $pasing['Lain2Ka'] = $key['Lain2Ka'];
            $pasing['Lain2KaNote'] = $key['Lain2KaNote'];
            $pasing['Lain2Ki'] = $key['Lain2Ki'];
            $pasing['Lain2KiNote'] = $key['Lain2KiNote'];
            $pasing['RetinaKa'] = $key['RetinaKa'];
            $pasing['RetinakaNote'] = $key['RetinakaNote'];
            $pasing['RetinaKi'] = $key['RetinaKi'];
            $pasing['RetinaKiNote'] = $key['RetinaKiNote'];
            $pasing['OptikusKa'] = $key['OptikusKa'];
            $pasing['OptikusKaNote'] = $key['OptikusKaNote'];
            $pasing['OptikusKi'] = $key['OptikusKi'];
            $pasing['OptikusKiNote'] = $key['OptikusKiNote'];
            $pasing['CDRatioKa'] = $key['CDRatioKa'];
            $pasing['CDRatioKi'] = $key['CDRatioKi'];
            $pasing['KesOtotKa'] = $key['KesOtotKa'];
            $pasing['KesOtotKaNote'] = $key['KesOtotKaNote'];
            $pasing['KesOtotKi'] = $key['KesOtotKi'];
            $pasing['KesOtotKiNote'] = $key['KesOtotKiNote'];
            $pasing['TIOKa'] = $key['TIOKa'];
            $pasing['TIOKi'] = $key['TIOKi'];
            $pasing['MakulaLutKa'] = $key['MakulaLutKa'];
            $pasing['MakulaLutKaNote'] = $key['MakulaLutKaNote'];
            $pasing['MakulaLutKi'] = $key['MakulaLutKi'];
            $pasing['MakulaLutKiNote'] = $key['MakulaLutKiNote'];
            $pasing['KorpusVitreumKa'] = $key['KorpusVitreumKa'];
            $pasing['KorpusVitreumKaNote'] = $key['KorpusVitreumKaNote'];
            $pasing['KorpusVitreumKi'] = $key['KorpusVitreumKi'];
            $pasing['KorpusVitreumKiNote'] = $key['KorpusVitreumKiNote'];
            $pasing['ArteriVenaKa'] = $key['ArteriVenaKa'];
            $pasing['ArteriVenaKaNote'] = $key['ArteriVenaKaNote'];
            $pasing['ArteriVenaKi'] = $key['ArteriVenaKi'];
            $pasing['ArteriVenaKiNote'] = $key['ArteriVenaKiNote'];
            $pasing['TBWaranaKa'] = $key['TBWaranaKa'];
            $pasing['TBWaranaKaNote'] = $key['TBWaranaKaNote'];
            $pasing['TBWaranaKi'] = $key['TBWaranaKi'];
            $pasing['TBWaranaKiNote'] = $key['TBWaranaKiNote'];
            $pasing['Kesimpulan'] = $key['Kesimpulan'];
            $pasing['Saran'] = $key['Saran'];
            $pasing['DokterPemeri'] = $key['DokterPemeri'];

            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function setSaveAssesment($data)
    {
        try {
            $this->db->transaksi();

            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            // DATA PASIEN
            $noreg_pasien = $data['noreg_pasien'];
            $mr_pasien = $data['mr_pasien'];
            // DATA WAKIL PASIEN
            $nama_wakil = $data['nama_wakil'];
            $umur_wakil = $data['umur_wakil'];
            $nik_wakil = $data['nik_wakil'];
            $nohp_wakil = $data['nohp_wakil'];
            $pekerjaan_wakil = $data['pekerjaan_wakil'];
            $alamat_wakil = $data['alamat_wakil'];
            $hubungan_wakil = $data['hubungan_wakil'];
            $keterangan_wakil = $data['keterangan_wakil'];
            $jeniskelamin_wakil = $data['jeniskelamin_wakil'];
            // DATA ASSESMENT RAJAL
            $emr_keluhan_utama = $data['emr_keluhan_utama'];
            $emr_pernapasan = $data['emr_pernapasan'];
            if ($emr_pernapasan == '') {
                $emr_pernapasan = 0;
            }
            $emr_tensi = $data['emr_tensi'];
            if ($emr_tensi == '') {
                $emr_tensi = 0;
            }
            $emr_sistole = $data['emr_sistole'];
            if ($emr_sistole == '') {
                $emr_sistole = 0;
            }
            $emr_diastole = $data['emr_diastole'];
            if ($emr_diastole == '') {
                $emr_diastole = 0;
            }
            $emr_suhu = $data['emr_suhu'];
            if ($emr_suhu == '') {
                $emr_suhu = 0;
            }
            $emr_nadi = $data['emr_nadi'];
            if ($emr_nadi == '') {
                $emr_nadi = 0;
            }
            $emr_spo2 = $data['emr_spo2'];
            if ($emr_spo2 == '') {
                $emr_spo2 = 0;
            }
            $emr_tinggibadan = $data['emr_tinggibadan'];
            if ($emr_tinggibadan == '') {
                $emr_tinggibadan = 0;
            }
            $emr_beratbadan = $data['emr_beratbadan'];
            if ($emr_beratbadan == '') {
                $emr_beratbadan = 0;
            }
            $emr_hamil = $data['emr_hamil'];
            $emr_menyusui = $data['emr_menyusui'];
            $emr_riwayatalergi = $data['emr_riwayatalergi'];
            $emr_riwayatalergiya = $data['emr_riwayatalergiya'];
            $checkbox_nariwayatalergi = $data['checkbox_nariwayatalergi'];
            // DATA TRIAGE COVID
            $emr_batutenggorokantersumbat = $data['emr_batutenggorokantersumbat'];
            $emr_frekuensispo2 = $data['emr_frekuensispo2'];
            $emr_demam1 = $data['emr_demam1'];
            $emr_riwayatkontakerat = $data['emr_riwayatkontakerat'];
            $emr_riwayatperjalanan = $data['emr_riwayatperjalanan'];
            $emr_tandapeunomiadenganct = $data['emr_tandapeunomiadenganct'];
            $emr_riwayatkontakeratdenganpasiencovid = $data['emr_riwayatkontakeratdenganpasiencovid'];
            $emr_demam2 = $data['emr_demam2'];
            $emr_usialebihdarisamadengan44 = $data['emr_usialebihdarisamadengan44'];
            $emr_jeniskelamincek = $data['emr_jeniskelamincek'];
            $emr_suhumaxsejaksampai = $data['emr_suhumaxsejaksampai'];
            $emr_gejalagangguanrespirasi = $data['emr_gejalagangguanrespirasi'];
            $emr_rasioneutrofil = $data['emr_rasioneutrofil'];
            // DATA SKRINNING TBC
            $emr_adakahbatukselama2minggu = $data['emr_adakahbatukselama2minggu'];
            $emr_dahakbercampurdarah = $data['emr_dahakbercampurdarah'];
            $emr_demammerianglebihdari1bulan = $data['emr_demammerianglebihdari1bulan'];
            $emr_sesaknafas = $data['emr_sesaknafas'];
            $emr_riwayatbatukberdarah = $data['emr_riwayatbatukberdarah'];
            $emr_lemah = $data['emr_lemah'];
            $emr_badanlemas = $data['emr_badanlemas'];
            $emr_keringatmalamtanpaaktifitas = $data['emr_keringatmalamtanpaaktifitas'];
            $emr_beratbadanmenurundrastis = $data['emr_beratbadanmenurundrastis'];
            $checkbox_naskrinningtbc = $data['checkbox_naskrinningtbc'];
            $checkbox_negatif = $data['checkbox_negatif'];
            $checkbox_odp = $data['checkbox_odp'];
            $checkbox_tbc = $data['checkbox_tbc'];
            $checkbox_pinerelainnya = $data['checkbox_pinerelainnya'];
            // DATA ANAMNESIS
            $emr_anamnesis = $data['emr_anamnesis'];
            $emr_keluhanutamaanamnesis = $data['emr_keluhanutamaanamnesis'];
            $emr_riwayatpenyakitsekarang = $data['emr_riwayatpenyakitsekarang'];
            $emr_riwayatpenyakitterdahulu = $data['emr_riwayatpenyakitterdahulu'];
            $emr_riwayatpenyakitterdahulurincian = $data['emr_riwayatpenyakitterdahulurincian'];
            $emr_pembedahan = $data['emr_pembedahan'];
            $emr_pembedahanrincian = $data['emr_pembedahanrincian'];
            $emr_riwayatrawatsebelumnya = $data['emr_riwayatrawatsebelumnya'];
            $emr_riwayatrawatsebelumnyarincian = $data['emr_riwayatrawatsebelumnyarincian'];
            $emr_adaobatrutinyangdiminum = $data['emr_adaobatrutinyangdiminum'];
            $emr_adaobatrutinyangdiminumrincian = $data['emr_adaobatrutinyangdiminumrincian'];
            // DATA SKRINNING JATUH
            $emr_adariwayatjatuhdalam3bulan = $data['emr_adariwayatjatuhdalam3bulan'];
            $emr_riwayatseizures = $data['emr_riwayatseizures'];
            $emr_anakmengkonmsumsiobat = $data['emr_anakmengkonmsumsiobat'];
            $emr_caraberjalanpasiensaatakanduduk = $data['emr_caraberjalanpasiensaatakanduduk'];
            $emr_pasienmemegangpinggirankursi = $data['emr_pasienmemegangpinggirankursi'];
            $emr_keluhannyeri = $data['emr_keluhannyeri'];
            $emr_lokasinyeri = $data['emr_lokasinyeri'];
            $emr_nyeritimbul = $data['emr_nyeritimbul'];
            $emr_frekwensinyeri = $data['emr_frekwensinyeri'];
            $emr_karakteristiknyeri = $data['emr_karakteristiknyeri'];
            $emr_etensitasnyeri = $data['emr_etensitasnyeri'];
            $emr_metodepenilaiannyeri = $data['emr_metodepenilaiannyeri'];
            $emr_tipenyeri = $data['emr_tipenyeri'];
            $emr_pemberatnyeri = $data['emr_pemberatnyeri'];
            $emr_halyangdapatmeredakannyeri = $data['emr_halyangdapatmeredakannyeri'];
            $emr_tindakanmandiriperawatdetail = $data['emr_tindakanmandiriperawatdetail'];
            $emr_kolaborasidetail = $data['emr_kolaborasidetail'];

            $checkbox_emr_naskrinningjatuhanak = $data['checkbox_emr_naskrinningjatuhanak'];
            $checkbox_emr_risikorendahjatuh = $data['checkbox_emr_risikorendahjatuh'];
            $checkbox_emr_risikotinggijatuh = $data['checkbox_emr_risikotinggijatuh'];
            $checkbox_emr_naskrinningrisikojatuhmobilisasi = $data['checkbox_emr_naskrinningrisikojatuhmobilisasi'];
            $checkbox_emr_risikorendahpoinpencegahan = $data['checkbox_emr_risikorendahpoinpencegahan'];
            $checkbox_emr_risikotinggipoinpencegahan = $data['checkbox_emr_risikotinggipoinpencegahan'];
            $checkbox_emr_tindakanmandiriperawat = $data['checkbox_emr_tindakanmandiriperawat'];
            $checkbox_emr_kolaborasi = $data['checkbox_emr_kolaborasi'];

            // DATA SKRINNING NUTRISI
            $emr_risikonutrisi = $data['emr_risikonutrisi'];
            $emr_pasientampakkurus = $data['emr_pasientampakkurus'];
            $emr_penurunanbb = $data['emr_penurunanbb'];
            $emr_terdapatsalahsatukondisi = $data['emr_terdapatsalahsatukondisi'];
            $emr_beresikomengalamimalnutrisi = $data['emr_beresikomengalamimalnutrisi'];
            $emr_nilaiskore = $data['emr_nilaiskore'];
            $emr_nilaiskoreskrinningdewasa = $data['emr_nilaiskoreskrinningdewasa'];
            $emr_penurunanberatbadandewasa = $data['emr_penurunanberatbadandewasa'];
            $emr_berapapenurunanbbdewasa = $data['emr_berapapenurunanbbdewasa'];
            $emr_asupanmakananberkurang = $data['emr_asupanmakananberkurang'];
            $emr_kondisikhusus = $data['emr_kondisikhusus'];
            $emr_lila = $data['emr_lila'];

            $checkbox_emr_skrinningnutrisianak = $data['checkbox_emr_skrinningnutrisianak'];
            $checkbox_emr_diarekronik = $data['checkbox_emr_diarekronik'];
            $checkbox_emr_jantungbawaan = $data['checkbox_emr_jantungbawaan'];
            $checkbox_emr_hiv = $data['checkbox_emr_hiv'];
            $checkbox_emr_kanker = $data['checkbox_emr_kanker'];
            $checkbox_emr_hatikronik = $data['checkbox_emr_hatikronik'];
            $checkbox_emr_ginjalkronik = $data['checkbox_emr_ginjalkronik'];
            $checkbox_emr_tbparu = $data['checkbox_emr_tbparu'];
            $checkbox_emr_terpasangstoma = $data['checkbox_emr_terpasangstoma'];
            $checkbox_emr_trauma = $data['checkbox_emr_trauma'];
            $checkbox_emr_lukabakarluas = $data['checkbox_emr_lukabakarluas'];
            $checkbox_emr_kelainananatomidaerahmulut = $data['checkbox_emr_kelainananatomidaerahmulut'];
            $checkbox_emr_rencanapascaoperasi = $data['checkbox_emr_rencanapascaoperasi'];
            $checkbox_emr_kelainanmetabolikbawaan = $data['checkbox_emr_kelainanmetabolikbawaan'];
            $checkbox_emr_retardasimetal = $data['checkbox_emr_retardasimetal'];
            $checkbox_emr_stunting = $data['checkbox_emr_stunting'];
            $checkbox_emr_risikotinggikolaborasiahligizi = $data['checkbox_emr_risikotinggikolaborasiahligizi'];
            $checkbox_emr_skrinningnutrisidewasa = $data['checkbox_emr_skrinningnutrisidewasa'];
            $checkbox_emr_risikotinggipilihandengandiagnosisi = $data['checkbox_emr_risikotinggipilihandengandiagnosisi'];
            $checkbox_emr_skrinningnutrisiibuhamil = $data['checkbox_emr_skrinningnutrisiibuhamil'];

            // DATA KOMUNIKASI
            $emr_fungsibicara = $data['emr_fungsibicara'];
            $emr_kelainanfungsibicara = $data['emr_kelainanfungsibicara'];
            $emr_bahasasehari = $data['emr_bahasasehari'];
            $emr_bahaseharidetail = $data['emr_bahaseharidetail'];
            $emr_perlupenerjemah = $data['emr_perlupenerjemah'];
            $emr_perlupenerjemahdetail = $data['emr_perlupenerjemahdetail'];
            $emr_bhsisyarat = $data['emr_bhsisyarat'];
            $emr_bhsisyaratdetail = $data['emr_bhsisyaratdetail'];
            $emr_hambatanbelajarsecarafisik = $data['emr_hambatanbelajarsecarafisik'];
            $emr_hambatanbelajarsecarafisikdetail = $data['emr_hambatanbelajarsecarafisikdetail'];
            $emr_hambatanbelajarsecarabudaya = $data['emr_hambatanbelajarsecarabudaya'];
            $emr_hambatanbelajarsecarabudayadetail = $data['emr_hambatanbelajarsecarabudayadetail'];
            $emr_hambatanbelajarsecarabahasa = $data['emr_hambatanbelajarsecarabahasa'];
            $emr_hambatanbelajarsecarabahasadetail = $data['emr_hambatanbelajarsecarabahasadetail'];
            $emr_hambatanbelajarsecaraemosi = $data['emr_hambatanbelajarsecaraemosi'];
            $emr_hambatanbelajarsecaraemosidetail = $data['emr_hambatanbelajarsecaraemosidetail'];
            $emr_lainkebutuhandeukasidetail = $data['emr_lainkebutuhandeukasidetail'];

            $checkbox_emr_pengobatan = $data['checkbox_emr_pengobatan'];
            $checkbox_emr_nutrisi = $data['checkbox_emr_nutrisi'];
            $checkbox_emr_tindakanmedis = $data['checkbox_emr_tindakanmedis'];
            $checkbox_emr_keperawatan = $data['checkbox_emr_keperawatan'];
            $checkbox_emr_lainkebutuhandeukasi = $data['checkbox_emr_lainkebutuhandeukasi'];

            // DATA SPIRITUAL
            $emr_tingkkatpendidikan = $data['emr_tingkkatpendidikan'];
            $emr_tingkkatpendidikanselain = $data['emr_tingkkatpendidikanselain'];
            $emr_pekerjaansaatini = $data['emr_pekerjaansaatini'];
            $emr_pekerjaansaatiniselain = $data['emr_pekerjaansaatiniselain'];
            $emr_tinggalsaatini = $data['emr_tinggalsaatini'];
            $emr_tinggalsaatiniselain = $data['emr_tinggalsaatiniselain'];
            $emr_agamasaatini = $data['emr_agamasaatini'];
            $emr_agamasaatiniselain = $data['emr_agamasaatiniselain'];
            $emr_hambatanmenjalankanibadah = $data['emr_hambatanmenjalankanibadah'];
            $emr_hambatanmenjalankanibadahket = $data['emr_hambatanmenjalankanibadahket'];
            $emr_nilaikepercayaandiriyangdianut = $data['emr_nilaikepercayaandiriyangdianut'];
            $emr_nilaikepercayaandiriyangdianutket = $data['emr_nilaikepercayaandiriyangdianutket'];
            $emr_pantangmakanananminuman = $data['emr_pantangmakanananminuman'];
            $emr_pantangmakanananminumanket = $data['emr_pantangmakanananminumanket'];
            $emr_riwayattindakkekerasan = $data['emr_riwayattindakkekerasan'];
            $emr_riwayattindakkekerasanket = $data['emr_riwayattindakkekerasanket'];

            $checkbox_emr_tenang = $data['checkbox_emr_tenang'];
            $checkbox_emr_sedihmenangis = $data['checkbox_emr_sedihmenangis'];
            $checkbox_emr_cemasgelisah = $data['checkbox_emr_cemasgelisah'];
            $checkbox_emr_takutsekitar = $data['checkbox_emr_takutsekitar'];
            $checkbox_emr_mudahmarah = $data['checkbox_emr_mudahmarah'];

            // DATA KEPERAWATAN GIGI
            $emr_riwayatperawatangigi = $data['emr_riwayatperawatangigi'];
            $emr_riwayatperawatangigikapan = $data['emr_riwayatperawatangigikapan'];
            $emr_riwayatperawatangigimenjaditrauma = $data['emr_riwayatperawatangigimenjaditrauma'];
            $emr_pasienmengetahuiperwatangigiyangbenar = $data['emr_pasienmengetahuiperwatangigiyangbenar'];
            $emr_sikatgigimax2kali = $data['emr_sikatgigimax2kali'];
            $emr_sikatgigidenganbenar = $data['emr_sikatgigidenganbenar'];
            $emr_mengurangimakananyangmanis = $data['emr_mengurangimakananyangmanis'];
            $emer_warnabibir = $data['emer_warnabibir'];
            $emr_bibirsimetris = $data['emr_bibirsimetris'];
            $emr_bibirsimetrisket = $data['emr_bibirsimetrisket'];
            $emr_bibirlembab = $data['emr_bibirlembab'];
            $emr_bibirlembabdetail = $data['emr_bibirlembabdetail'];
            $emr_beratbadanlahir = $data['emr_beratbadanlahir'];
            if ($emr_beratbadanlahir == '') {
                $emr_beratbadanlahir = 0;
            }
            $emr_beratbadanlahirgram = $data['emr_beratbadanlahirgram'];
            $emr_panjanglahir = $data['emr_panjanglahir'];
            if ($emr_panjanglahir == '') {
                $emr_panjanglahir = 0;
            }
            $emr_panjanglahircm = $data['emr_panjanglahircm'];
            $emr_cacatbawaan = $data['emr_cacatbawaan'];
            $emr_cacatbawaanket = $data['emr_cacatbawaanket'];
            $emr_riwayatpenyakitsetelahlahir = $data['emr_riwayatpenyakitsetelahlahir'];
            $emr_riwayatpenyakitsetelahlahirket = $data['emr_riwayatpenyakitsetelahlahirket'];
            $emr_bcgusia = $data['emr_bcgusia'];
            if ($emr_bcgusia == '') {
                $emr_bcgusia = 0;
            }
            $emr_dptusia = $data['emr_dptusia'];
            if ($emr_dptusia == '') {
                $emr_dptusia = 0;
            }
            $emr_poliousia = $data['emr_poliousia'];
            if ($emr_poliousia == '') {
                $emr_poliousia = 0;
            }
            $emr_campakusia = $data['emr_campakusia'];
            if ($emr_campakusia == '') {
                $emr_campakusia = 0;
            }
            $emr_mmrusia = $data['emr_mmrusia'];
            if ($emr_mmrusia == '') {
                $emr_mmrusia = 0;
            }
            $emr_hepbusia = $data['emr_hepbusia'];
            if ($emr_hepbusia == '') {
                $emr_hepbusia = 0;
            }
            $emr_hepausia = $data['emr_hepausia'];
            if ($emr_hepausia == '') {
                $emr_hepausia = 0;
            }
            $emr_bosterusia = $data['emr_bosterusia'];
            if ($emr_bosterusia == '') {
                $emr_bosterusia = 0;
            }
            $emr_hibiusia = $data['emr_hibiusia'];
            if ($emr_hibiusia == '') {
                $emr_hibiusia = 0;
            }
            $emr_varicelausia = $data['emr_varicelausia'];
            if ($emr_varicelausia == '') {
                $emr_varicelausia = 0;
            }
            $emr_rotavirususia = $data['emr_rotavirususia'];
            if ($emr_rotavirususia == '') {
                $emr_rotavirususia = 0;
            }
            $emr_pneumoniausia = $data['emr_pneumoniausia'];
            if ($emr_pneumoniausia == '') {
                $emr_pneumoniausia = 0;
            }
            $emr_thypoidusia = $data['emr_thypoidusia'];
            if ($emr_thypoidusia == '') {
                $emr_thypoidusia = 0;
            }
            $emr_influenzausia = $data['emr_influenzausia'];
            if ($emr_influenzausia == '') {
                $emr_influenzausia = 0;
            }
            $emr_riwayatasi = $data['emr_riwayatasi'];
            $emr_riwayatsufor = $data['emr_riwayatsufor'];
            $emr_makanantambahanusia = $data['emr_makanantambahanusia'];
            if ($emr_makanantambahanusia == '') {
                $emr_makanantambahanusia = 0;
            }
            $emr_riwayatkelainanpertumbuhan = $data['emr_riwayatkelainanpertumbuhan'];
            $emr_riwayatkelainanpertumbuhanket = $data['emr_riwayatkelainanpertumbuhanket'];

            $checkbox_emr_napengkajiangigi = $data['checkbox_emr_napengkajiangigi'];
            $checkbox_emr_bibirpecah = $data['checkbox_emr_bibirpecah'];
            $checkbox_emr_bibirberdarah = $data['checkbox_emr_bibirberdarah'];
            $checkbox_emr_bibirsianosis = $data['checkbox_emr_bibirsianosis'];
            $checkbox_emr_bibirpucat = $data['checkbox_emr_bibirpucat'];
            $checkbox_emr_bibirbengkak = $data['checkbox_emr_bibirbengkak'];
            $checkbox_emr_bcg = $data['checkbox_emr_bcg'];
            $checkbox_emr_dpt = $data['checkbox_emr_dpt'];
            $checkbox_emr_polio = $data['checkbox_emr_polio'];
            $checkbox_emr_campak = $data['checkbox_emr_campak'];
            $checkbox_emr_mmr = $data['checkbox_emr_mmr'];
            $checkbox_emr_hepb = $data['checkbox_emr_hepb'];
            $checkbox_emr_hepa = $data['checkbox_emr_hepa'];
            $checkbox_emr_boster = $data['checkbox_emr_boster'];
            $checkbox_emr_hibi = $data['checkbox_emr_hibi'];
            $checkbox_emr_varicela = $data['checkbox_emr_varicela'];
            $checkbox_emr_rotavirus = $data['checkbox_emr_rotavirus'];
            $checkbox_emr_pneumonia = $data['checkbox_emr_pneumonia'];
            $checkbox_emr_thypoid = $data['checkbox_emr_thypoid'];
            $checkbox_emr_influenza = $data['checkbox_emr_influenza'];


            //DATA DISCHARGE PLANNING
            $emr_memerlukanbantuanuntukaktifitas = $data['emr_memerlukanbantuanuntukaktifitas'];
            $emr_memerlukanbantuanuntukaktifitasket = $data['emr_memerlukanbantuanuntukaktifitasket'];
            $emr_memerlukanperalatanmedis = $data['emr_memerlukanperalatanmedis'];
            $emr_memerlukanperalatanmedisket = $data['emr_memerlukanperalatanmedisket'];
            $emr_memerlukanedukasikesehatan = $data['emr_memerlukanedukasikesehatan'];
            $emr_memerlukanedukasikesehatanket = $data['emr_memerlukanedukasikesehatanket'];
            $emr_tinggalsendiri = $data['emr_tinggalsendiri'];
            $emr_tinggalsendiriket = $data['emr_tinggalsendiriket'];
            $emr_perwatanlanjutan = $data['emr_perwatanlanjutan'];
            $emr_perwatanlanjutanket = $data['emr_perwatanlanjutanket'];
            $emr_dekatdenganpelayanankesehatan = $data['emr_dekatdenganpelayanankesehatan'];
            $emr_dekatdenganpelayanankesehatanket = $data['emr_dekatdenganpelayanankesehatanket'];
            $emr_dirumahadayangmerawat = $data['emr_dirumahadayangmerawat'];
            $emr_dirumahadayangmerawatket = $data['emr_dirumahadayangmerawatket'];
            $emr_memilikinyerikronis = $data['emr_memilikinyerikronis'];
            $emr_memilikinyerikronisket = $data['emr_memilikinyerikronisket'];
            $emr_memerlukantransport = $data['emr_memerlukantransport'];
            $emr_memerlukantransportket = $data['emr_memerlukantransportket'];
            $emr_bantuanperawatankhusus = $data['emr_bantuanperawatankhusus'];
            $emr_bantuanperawatankhususket = $data['emr_bantuanperawatankhususket'];

            //KESIMPULAN
            $checkbox_emr_rujuk = $data['checkbox_emr_rujuk'];
            $emr_pulang = $data['emr_pulang'];
            $emr_rawatinap = $data['emr_rawatinap'];
            $emr_rujukuntuk = $data['emr_rujukuntuk'];

            //CEK DATA
            $this->db->query("SELECT COUNT(ID) cekOutpatientWakilPasien FROM EMR.dbo.OutpatientWakilPasien WHERE No_Registrasi = :noreg_pasien");
            $this->db->bind('noreg_pasien', $noreg_pasien);
            $dataWakil =  $this->db->single();
            $cekWakil = $dataWakil['cekOutpatientWakilPasien'];

            if ($cekWakil == "0") {
                $this->db->query("INSERT INTO EMR.dbo.OutpatientWakilPasien ([Nama_Wakil_Pasien], [Umur_Wakil_Paisen], [NoHp_Wakil_Pasien], [NIK_Wakil_Pasien], [Pekerjaan_Wakil_Pasien], [Alamat_Wakil_Pasien], [Hubungan_Wakil_Pasien],
                [Keterangan_Wakil_Pasien], [JenisKelamin_Wakil_Pasien], [No_RM], [No_Registrasi], [User_Input])
                VALUES (:nama_wakil1a, :umur_wakil1a, :nohp_wakil1a, :nik_wakil1a, :pekerjaan_wakil1a, :alamat_wakil1a, :hubungan_wakil1a, :keterangan_wakil1a, :jeniskelamin_wakil1a, :mr_pasien1a, :noreg_pasien1a, :namauserx1a)");
                $this->db->bind('nama_wakil1a', $nama_wakil);
                $this->db->bind('umur_wakil1a', $umur_wakil);
                $this->db->bind('nohp_wakil1a', $nohp_wakil);
                $this->db->bind('nik_wakil1a', $nik_wakil);
                $this->db->bind('pekerjaan_wakil1a', $pekerjaan_wakil);
                $this->db->bind('alamat_wakil1a', $alamat_wakil);
                $this->db->bind('hubungan_wakil1a', $hubungan_wakil);
                $this->db->bind('keterangan_wakil1a', $keterangan_wakil);
                $this->db->bind('jeniskelamin_wakil1a', $jeniskelamin_wakil);
                $this->db->bind('mr_pasien1a', $mr_pasien);
                $this->db->bind('noreg_pasien1a', $noreg_pasien);
                $this->db->bind('namauserx1a', $namauserx);
                $this->db->execute();

                $this->db->query("INSERT INTO EMR.dbo.OutpatientAssesments([Keluhan_Utama], [Pernapasan], [Tensi], [Sistole], [Diastole], [Suhu], [Nadi], [SpO2], [Tinggi_Badan], [Berat_Badan], [Hamil], [Menyusui], [Riwayat_Alergi], [Riwayat_Alergi_Detail], [NA_Assesment], [Pulang], [Rawat_Inap], [Rujuk], [Rujuk_Detail], [No_RM], [No_Registrasi], [User_Input])
                VALUES (:emr_keluhan_utama2a, :emr_pernapasan2a, :emr_tensi2a, :emr_sistole2a, :emr_diastole2a, :emr_suhu2a, :emr_nadi2a, :emr_spo22a, :emr_tinggibadan2a,:emr_beratbadan2a, :emr_hamil2a, :emr_menyusui2a, :emr_riwayatalergi2a, :emr_riwayatalergiya2a, :checkbox_nariwayatalergi2a, 
                :emr_pulang2a, 
                :emr_rawatinap2a, 
                :checkbox_emr_rujuk2a, 
                :emr_rujukuntuk2a, :mr_pasien2a, :noreg_pasien2a, :namauserx2a)");
                $this->db->bind('emr_keluhan_utama2a', $emr_keluhan_utama);
                $this->db->bind('emr_pernapasan2a', $emr_pernapasan);
                $this->db->bind('emr_tensi2a', $emr_tensi);
                $this->db->bind('emr_sistole2a', $emr_sistole);
                $this->db->bind('emr_diastole2a', $emr_diastole);
                $this->db->bind('emr_suhu2a', $emr_suhu);
                $this->db->bind('emr_nadi2a', $emr_nadi);
                $this->db->bind('emr_spo22a', $emr_spo2);
                $this->db->bind('emr_tinggibadan2a', $emr_tinggibadan);
                $this->db->bind('emr_beratbadan2a', $emr_beratbadan);
                $this->db->bind('emr_hamil2a', $emr_hamil);
                $this->db->bind('emr_menyusui2a', $emr_menyusui);
                $this->db->bind('emr_riwayatalergi2a', $emr_riwayatalergi);
                $this->db->bind('emr_riwayatalergiya2a', $emr_riwayatalergiya);
                $this->db->bind('checkbox_nariwayatalergi2a', $checkbox_nariwayatalergi);
                $this->db->bind('mr_pasien2a', $mr_pasien);
                $this->db->bind('noreg_pasien2a', $noreg_pasien);
                $this->db->bind('namauserx2a', $namauserx);
                $this->db->bind('emr_pulang2a', $emr_pulang);
                $this->db->bind('emr_rawatinap2a', $emr_rawatinap);
                $this->db->bind('checkbox_emr_rujuk2a', $checkbox_emr_rujuk);
                $this->db->bind('emr_rujukuntuk2a', $emr_rujukuntuk);
                $this->db->execute();

                $this->db->query("INSERT INTO EMR.dbo.OutpatientTriageCovid19 ([Batuk_SakitTenggorokan_HidungTersumbat],[Sesak_PeningkatanFreskuensiNafas],[Demam_1],[Riwayat_Kontak_Pasien_Covid],[Riwayat_Perjalanan],[Tanda_Pneumia],[Riwayat_Kontak_Pasien_Covid_2],[Demam_2],[Usia_Diatas_43Thn],[Jenis_Kelamin],[Suhu_Max_38C],[Gejala_Gangguan_Respirasi],[RasioNeutrofildanLimfosit_lebihdari_57],[No_RM],[No_Registrasi],[User_Input])
                VALUES (:emr_batutenggorokantersumbat3a,:emr_frekuensispo23a,:emr_demam13a,:emr_riwayatkontakerat3a,:emr_riwayatperjalanan3a,:emr_tandapeunomiadenganct3a,:emr_riwayatkontakeratdenganpasiencovid3a,:emr_demam23a,:emr_usialebihdarisamadengan443a,:emr_jeniskelamincek3a,:emr_suhumaxsejaksampai3a,:emr_gejalagangguanrespirasi3a,:emr_rasioneutrofil3a,:mr_pasien3a,:noreg_pasien3a,:namauserx3a)");
                $this->db->bind('emr_batutenggorokantersumbat3a', $emr_batutenggorokantersumbat);
                $this->db->bind('emr_frekuensispo23a', $emr_frekuensispo2);
                $this->db->bind('emr_demam13a', $emr_demam1);
                $this->db->bind('emr_riwayatkontakerat3a', $emr_riwayatkontakerat);
                $this->db->bind('emr_riwayatperjalanan3a', $emr_riwayatperjalanan);
                $this->db->bind('emr_tandapeunomiadenganct3a', $emr_tandapeunomiadenganct);
                $this->db->bind('emr_riwayatkontakeratdenganpasiencovid3a', $emr_riwayatkontakeratdenganpasiencovid);
                $this->db->bind('emr_demam23a', $emr_demam2);
                $this->db->bind('emr_usialebihdarisamadengan443a', $emr_usialebihdarisamadengan44);
                $this->db->bind('emr_jeniskelamincek3a', $emr_jeniskelamincek);
                $this->db->bind('emr_suhumaxsejaksampai3a', $emr_suhumaxsejaksampai);
                $this->db->bind('emr_gejalagangguanrespirasi3a', $emr_gejalagangguanrespirasi);
                $this->db->bind('emr_rasioneutrofil3a', $emr_rasioneutrofil);
                $this->db->bind('mr_pasien3a', $mr_pasien);
                $this->db->bind('noreg_pasien3a', $noreg_pasien);
                $this->db->bind('namauserx3a', $namauserx);
                $this->db->execute();

                $this->db->query("INSERT INTO EMR.dbo.OutpatientSkriningTBC ([NA_Skrining_TBC],[Batuk_Max_2Minggu],[Dahak_Bercampur_Darah],[DemamMeriang_Max_1Bulan],[Sesak_Nafas],
                [Riwayat_Batuk_Berdarah],[Lemah],[Badan_Lemas_Berdarah],[Keringatan_Malam_Tanpa_Aktifitas],[BB_Menurun_Drastis],
                [Kesimpulan_Negatif],[Kesimpulan_ODP_PDP],[Kesimpulan_Tuberkulosis],[Kesimpulan_Pinere_Lainnya],[No_RM],[No_Registrasi],[User_Input])
                VALUES (:checkbox_naskrinningtbc4a,:emr_adakahbatukselama2minggu4a,:emr_dahakbercampurdarah4a,:emr_demammerianglebihdari1bulan4a,:emr_sesaknafas4a,
                :emr_riwayatbatukberdarah4a,:emr_lemah4a,:emr_badanlemas4a,:emr_keringatmalamtanpaaktifitas4a,:emr_beratbadanmenurundrastis4a,:checkbox_negatif4a,:checkbox_odp4a,:checkbox_tbc4a,:checkbox_pinerelainnya4a,
                :mr_pasien4a,:noreg_pasien4a,:namauserx4a)");
                $this->db->bind('emr_adakahbatukselama2minggu4a', $emr_adakahbatukselama2minggu);
                $this->db->bind('emr_dahakbercampurdarah4a', $emr_dahakbercampurdarah);
                $this->db->bind('emr_demammerianglebihdari1bulan4a', $emr_demammerianglebihdari1bulan);
                $this->db->bind('emr_sesaknafas4a', $emr_sesaknafas);
                $this->db->bind('emr_riwayatbatukberdarah4a', $emr_riwayatbatukberdarah);
                $this->db->bind('emr_lemah4a', $emr_lemah);
                $this->db->bind('emr_badanlemas4a', $emr_badanlemas);
                $this->db->bind('emr_keringatmalamtanpaaktifitas4a', $emr_keringatmalamtanpaaktifitas);
                $this->db->bind('emr_beratbadanmenurundrastis4a', $emr_beratbadanmenurundrastis);
                $this->db->bind('mr_pasien4a', $mr_pasien);
                $this->db->bind('noreg_pasien4a', $noreg_pasien);
                $this->db->bind('namauserx4a', $namauserx);
                $this->db->bind('checkbox_naskrinningtbc4a', $checkbox_naskrinningtbc);
                $this->db->bind('checkbox_negatif4a', $checkbox_negatif);
                $this->db->bind('checkbox_odp4a', $checkbox_odp);
                $this->db->bind('checkbox_tbc4a', $checkbox_tbc);
                $this->db->bind('checkbox_pinerelainnya4a', $checkbox_pinerelainnya);
                $this->db->execute();


                $this->db->query("INSERT INTO EMR.dbo.OutpatientAnamnesis ([Anamnesis],[Keluhan_Utama_Anamnesis],[Riwayat_Penyakit_Sekarang],[Riwayat_Penyakit_Terdahulu],[Riwayat_Penyakit_Terdahulu_Detail],[Riwayat_Pembedahan],[Riwayat_Pembedahan_Detail],[Riwayat_Rawat_Sebelumnya],[Riwayat_Rawat_Sebelumnya_Detail],[Obat_Rutin_Dari_Rumah],[Obat_Rutin_Dari_Rumah_Detail],[No_RM],[No_Registrasi],[User_Input])
                VALUES 
                (:emr_anamnesis5a,:emr_keluhanutamaanamnesis5a,:emr_riwayatpenyakitsekarang5a,:emr_riwayatpenyakitterdahulu5a,:emr_riwayatpenyakitterdahulurincian5a,:emr_pembedahan5a,:emr_pembedahanrincian5a,:emr_riwayatrawatsebelumnya5a,:emr_riwayatrawatsebelumnyarincian5a,:emr_adaobatrutinyangdiminum5a,:emr_adaobatrutinyangdiminumrincian5a,:mr_pasien5a,:noreg_pasien5a,:namauserx5a)");
                $this->db->bind('emr_anamnesis5a', $emr_anamnesis);
                $this->db->bind('emr_keluhanutamaanamnesis5a', $emr_keluhanutamaanamnesis);
                $this->db->bind('emr_riwayatpenyakitsekarang5a', $emr_riwayatpenyakitsekarang);
                $this->db->bind('emr_riwayatpenyakitterdahulu5a', $emr_riwayatpenyakitterdahulu);
                $this->db->bind('emr_riwayatpenyakitterdahulurincian5a', $emr_riwayatpenyakitterdahulurincian);
                $this->db->bind('emr_pembedahan5a', $emr_pembedahan);
                $this->db->bind('emr_pembedahanrincian5a', $emr_pembedahanrincian);
                $this->db->bind('emr_riwayatrawatsebelumnya5a', $emr_riwayatrawatsebelumnya);
                $this->db->bind('emr_riwayatrawatsebelumnyarincian5a', $emr_riwayatrawatsebelumnyarincian);
                $this->db->bind('emr_adaobatrutinyangdiminum5a', $emr_adaobatrutinyangdiminum);
                $this->db->bind('emr_adaobatrutinyangdiminumrincian5a', $emr_adaobatrutinyangdiminumrincian);
                $this->db->bind('mr_pasien5a', $mr_pasien);
                $this->db->bind('noreg_pasien5a', $noreg_pasien);
                $this->db->bind('namauserx5a', $namauserx);
                $this->db->execute();


                $this->db->query("INSERT INTO EMR.dbo.OutpatientSkriningResikoJatuh 
                ([NA_Skrining_Jatuh_Anak],[Riwayat_Jatuh_Dalam_3Bulan],[Riwayat_Seizures],[Anak_Konsumsi_Narkotik],[Risiko_Rendah_Jatuh_Anak],[Risiko_Tinggi_Jatuh_Anak],[NA_Skrining_Jatuh_Dewasa],
                [Cara_Berjalan_Saat_Akan_Duduk],[Pasien_Memegang_Pinggiran_Kursi],[Risiko_Rendah_Jatuh_Dewasa],[Risiko_Tinggi_Jatuh_Dewasa],[Keluhan_Nyeri],[Lokasi_Nyeri],[Nyeri_Timbul_Sejak],
                [Frekwensi_Nyeri],[Karakteristik_Nyeri],[Etensitas_Nyeri],[Metode_Penilaian_Nyeri],[Tipe_Nyeri],[Pencetus_Nyeri],[Pereda_Nyeri],
                [Tindakan_Mandiri_Perawat],[Tindakan_Mandiri_Perawat_Detail],[Kolaborasi],[Kolaborasi_Detail],[No_RM],[No_Registrasi],[User_Input])
                VALUES
                (:checkbox_emr_naskrinningjatuhanak6a,:emr_adariwayatjatuhdalam3bulan6a,:emr_riwayatseizures6a,:emr_anakmengkonmsumsiobat6a,:checkbox_emr_risikorendahjatuh6a,:checkbox_emr_risikotinggijatuh6a,:checkbox_emr_naskrinningrisikojatuhmobilisasi6a,
                :emr_caraberjalanpasiensaatakanduduk6a,:emr_pasienmemegangpinggirankursi6a,:checkbox_emr_risikorendahpoinpencegahan6a,:checkbox_emr_risikotinggipoinpencegahan6a,:emr_keluhannyeri6a,:emr_lokasinyeri6a,:emr_nyeritimbul6a,
                :emr_frekwensinyeri6a,:emr_karakteristiknyeri6a,:emr_etensitasnyeri6a,:emr_metodepenilaiannyeri6a,:emr_tipenyeri6a,:emr_pemberatnyeri6a,:emr_halyangdapatmeredakannyeri6a,
                :checkbox_emr_tindakanmandiriperawat6a,:emr_tindakanmandiriperawatdetail6a,:checkbox_emr_kolaborasi6a,:emr_kolaborasidetail6a,:mr_pasien6a,:noreg_pasien6a,:namauserx6a)");
                $this->db->bind('emr_adariwayatjatuhdalam3bulan6a', $emr_adariwayatjatuhdalam3bulan);
                $this->db->bind('emr_riwayatseizures6a', $emr_riwayatseizures);
                $this->db->bind('emr_anakmengkonmsumsiobat6a', $emr_anakmengkonmsumsiobat);
                $this->db->bind('emr_caraberjalanpasiensaatakanduduk6a', $emr_caraberjalanpasiensaatakanduduk);
                $this->db->bind('emr_pasienmemegangpinggirankursi6a', $emr_pasienmemegangpinggirankursi);
                $this->db->bind('emr_keluhannyeri6a', $emr_keluhannyeri);
                $this->db->bind('emr_lokasinyeri6a', $emr_lokasinyeri);
                $this->db->bind('emr_nyeritimbul6a', $emr_nyeritimbul);
                $this->db->bind('emr_frekwensinyeri6a', $emr_frekwensinyeri);
                $this->db->bind('emr_karakteristiknyeri6a', $emr_karakteristiknyeri);
                $this->db->bind('emr_etensitasnyeri6a', $emr_etensitasnyeri);
                $this->db->bind('emr_metodepenilaiannyeri6a', $emr_metodepenilaiannyeri);
                $this->db->bind('emr_tipenyeri6a', $emr_tipenyeri);
                $this->db->bind('emr_pemberatnyeri6a', $emr_pemberatnyeri);
                $this->db->bind('emr_halyangdapatmeredakannyeri6a', $emr_halyangdapatmeredakannyeri);
                $this->db->bind('emr_tindakanmandiriperawatdetail6a', $emr_tindakanmandiriperawatdetail);
                $this->db->bind('emr_kolaborasidetail6a', $emr_kolaborasidetail);
                $this->db->bind('mr_pasien6a', $mr_pasien);
                $this->db->bind('noreg_pasien6a', $noreg_pasien);
                $this->db->bind('namauserx6a', $namauserx);
                $this->db->bind('checkbox_emr_naskrinningjatuhanak6a', $checkbox_emr_naskrinningjatuhanak);
                $this->db->bind('checkbox_emr_risikorendahjatuh6a', $checkbox_emr_risikorendahjatuh);
                $this->db->bind('checkbox_emr_risikotinggijatuh6a', $checkbox_emr_risikotinggijatuh);
                $this->db->bind('checkbox_emr_naskrinningrisikojatuhmobilisasi6a', $checkbox_emr_naskrinningrisikojatuhmobilisasi);
                $this->db->bind('checkbox_emr_risikorendahpoinpencegahan6a', $checkbox_emr_risikorendahpoinpencegahan);
                $this->db->bind('checkbox_emr_risikotinggipoinpencegahan6a', $checkbox_emr_risikotinggipoinpencegahan);
                $this->db->bind('checkbox_emr_tindakanmandiriperawat6a', $checkbox_emr_tindakanmandiriperawat);
                $this->db->bind('checkbox_emr_kolaborasi6a', $checkbox_emr_kolaborasi);
                $this->db->execute();


                $this->db->query("INSERT INTO EMR.dbo.OutPatientSkriningNutrisi 
                (
                [NA_Skrining_Nutrisi_Anak],
                [Resiko_Nutrisional],
                [Tampak_Kurus],
                [Penurunan_BB_1Bulan_Terakhir],
                [Terdapat_Kondisi_DiareMuntahKurangasupan],
                [RiwayatPenyakit_Beresiko_Malnutrisi],
                [Diare_Konik],
                [Penyakit_Jantung_Bawaan],
                [HIV],
                [Kanker],
                [Penyakit_Hati_Kronik],
                [Penyakit_Ginjal_Kronik],
                [TB_Paru],
                [Terpasang_Stoma],
                [Tauma],
                [Luka_Bakar_Luas],
                [Kelainan_Anatomi_Daerah_Mulut],
                [Pasca_Operasi],
                [Kelainan_Metabolik_Bawaan],
                [Retardasi_Metal],
                [Keterlambatan_Perkembangan],
                [Nilai_Skor_Malnutrisi],
                [Resiko_Tinggi_Skrining_Nutrisi_Anak],
                [NA_Skrining_Nutrisi_Dewasa],
                [Nilai_Skor_Nutirisi_Dewasa],
                [Penurunan_BB_6Bulan_TidakDisengaja],
                [Skala_Penurunan_BB],
                [Asupan_Makanan_Berkurang],
                [Pasien_Kebutuhan_Khusus],
                [Resiko_Tinggi_Skrining_Nutrisi_Dewasa],
                [NA_Skrining_Nutrisi_Ibu_Hamil],
                [LILA],
                [No_RM],
                [No_Registrasi],
                [User_Input]
                )
                VALUES
                (
:checkbox_emr_skrinningnutrisianak7a,
:emr_risikonutrisi7a,
:emr_pasientampakkurus7a,
:emr_penurunanbb7a,
:emr_terdapatsalahsatukondisi7a,
:emr_beresikomengalamimalnutrisi7a,
:checkbox_emr_diarekronik7a,
:checkbox_emr_jantungbawaan7a,
:checkbox_emr_hiv7a,
:checkbox_emr_kanker7a,
:checkbox_emr_hatikronik7a,
:checkbox_emr_ginjalkronik7a,
:checkbox_emr_tbparu7a,
:checkbox_emr_terpasangstoma7a,
:checkbox_emr_trauma7a,
:checkbox_emr_lukabakarluas7a,
:checkbox_emr_kelainananatomidaerahmulut7a,
:checkbox_emr_rencanapascaoperasi7a,
:checkbox_emr_kelainanmetabolikbawaan7a,
:checkbox_emr_retardasimetal7a,
:checkbox_emr_stunting7a,
:emr_nilaiskore7a,
:checkbox_emr_risikotinggikolaborasiahligizi7a,
:checkbox_emr_skrinningnutrisidewasa7a,
:emr_nilaiskoreskrinningdewasa7a,
:emr_penurunanberatbadandewasa7a,
:emr_berapapenurunanbbdewasa7a,
:emr_asupanmakananberkurang7a,
:emr_kondisikhusus7a,
:checkbox_emr_risikotinggipilihandengandiagnosisi7a,
:checkbox_emr_skrinningnutrisiibuhamil7a,
:emr_lila7a,
:mr_pasien7a,
:noreg_pasien7a,
:namauserx7a
                )");
                $this->db->bind('emr_risikonutrisi7a', $emr_risikonutrisi);
                $this->db->bind('emr_pasientampakkurus7a', $emr_pasientampakkurus);
                $this->db->bind('emr_penurunanbb7a', $emr_penurunanbb);
                $this->db->bind('emr_terdapatsalahsatukondisi7a', $emr_terdapatsalahsatukondisi);
                $this->db->bind('emr_beresikomengalamimalnutrisi7a', $emr_beresikomengalamimalnutrisi);
                $this->db->bind('emr_nilaiskore7a', $emr_nilaiskore);
                $this->db->bind('emr_nilaiskoreskrinningdewasa7a', $emr_nilaiskoreskrinningdewasa);
                $this->db->bind('emr_penurunanberatbadandewasa7a', $emr_penurunanberatbadandewasa);
                $this->db->bind('emr_berapapenurunanbbdewasa7a', $emr_berapapenurunanbbdewasa);
                $this->db->bind('emr_asupanmakananberkurang7a', $emr_asupanmakananberkurang);
                $this->db->bind('emr_kondisikhusus7a', $emr_kondisikhusus);
                $this->db->bind('emr_lila7a', $emr_lila);
                $this->db->bind('mr_pasien7a', $mr_pasien);
                $this->db->bind('noreg_pasien7a', $noreg_pasien);
                $this->db->bind('namauserx7a', $namauserx);
                $this->db->bind('checkbox_emr_skrinningnutrisianak7a', $checkbox_emr_skrinningnutrisianak);
                $this->db->bind('checkbox_emr_diarekronik7a', $checkbox_emr_diarekronik);
                $this->db->bind('checkbox_emr_jantungbawaan7a', $checkbox_emr_jantungbawaan);
                $this->db->bind('checkbox_emr_hiv7a', $checkbox_emr_hiv);
                $this->db->bind('checkbox_emr_kanker7a', $checkbox_emr_kanker);
                $this->db->bind('checkbox_emr_hatikronik7a', $checkbox_emr_hatikronik);
                $this->db->bind('checkbox_emr_ginjalkronik7a', $checkbox_emr_ginjalkronik);
                $this->db->bind('checkbox_emr_tbparu7a', $checkbox_emr_tbparu);
                $this->db->bind('checkbox_emr_terpasangstoma7a', $checkbox_emr_terpasangstoma);
                $this->db->bind('checkbox_emr_trauma7a', $checkbox_emr_trauma);
                $this->db->bind('checkbox_emr_lukabakarluas7a', $checkbox_emr_lukabakarluas);
                $this->db->bind('checkbox_emr_kelainananatomidaerahmulut7a', $checkbox_emr_kelainananatomidaerahmulut);
                $this->db->bind('checkbox_emr_rencanapascaoperasi7a', $checkbox_emr_rencanapascaoperasi);
                $this->db->bind('checkbox_emr_kelainanmetabolikbawaan7a', $checkbox_emr_kelainanmetabolikbawaan);
                $this->db->bind('checkbox_emr_retardasimetal7a', $checkbox_emr_retardasimetal);
                $this->db->bind('checkbox_emr_stunting7a', $checkbox_emr_stunting);
                $this->db->bind('checkbox_emr_risikotinggikolaborasiahligizi7a', $checkbox_emr_risikotinggikolaborasiahligizi);
                $this->db->bind('checkbox_emr_skrinningnutrisidewasa7a', $checkbox_emr_skrinningnutrisidewasa);
                $this->db->bind('checkbox_emr_risikotinggipilihandengandiagnosisi7a', $checkbox_emr_risikotinggipilihandengandiagnosisi);
                $this->db->bind('checkbox_emr_skrinningnutrisiibuhamil7a', $checkbox_emr_skrinningnutrisiibuhamil);
                $this->db->execute();


                $this->db->query("INSERT INTO EMR.dbo.OutpatientComunicationEducation 
                ([Fungsi_Bicara],[Fungsi_Bicara_Detail],[Bahasa_Sehari_Hari],[Bahasa_Sehari_Hari_Detail],[Perlu_Penerjemah],[Perlu_Penerjemah_Detail],
                [Bahasa_Isyarat],[Bahasa_Isyarat_Detail],[Hambatan_Belajar_Secara_Fisik],[Hambatan_Belajar_Secara_Fisik_Detail],[Hambatan_Belajar_Secara_Budaya],
                [Hambatan_Belajar_Secara_Budaya_Detai],[Hambatan_Belajar_Secara_Bahasa],[Hambatan_Belajar_Secara_Bahasa_Detail],[Hambatan_Belajar_Secara_Emosi],
                [Hambatan_Belajar_Secara_Emosi_Detail],[Pengobatan],[Nutrisi],[Tindakan_Medis],[keperawatan],[Kebutuhan_Lain],[Kebutuhan_Lain_Detail],[No_RM],[No_Registrasi],[User_Input])
                VALUES
                (:emr_fungsibicara8a,:emr_kelainanfungsibicara8a,:emr_bahasasehari8a,:emr_bahaseharidetail8a,:emr_perlupenerjemah8a,:emr_perlupenerjemahdetail8a,
                :emr_bhsisyarat8a,:emr_bhsisyaratdetail8a,:emr_hambatanbelajarsecarafisik8a,:emr_hambatanbelajarsecarafisikdetail8a,:emr_hambatanbelajarsecarabudaya8a,
                :emr_hambatanbelajarsecarabudayadetail8a,:emr_hambatanbelajarsecarabahasa8a,:emr_hambatanbelajarsecarabahasadetail8a,:emr_hambatanbelajarsecaraemosi8a,
                :emr_hambatanbelajarsecaraemosidetail8a,
                :checkbox_emr_pengobatana8a,
                :checkbox_emr_nutrisia8a,
                :checkbox_emr_tindakanmedisa8a,
                :checkbox_emr_keperawatana8a,
                :checkbox_emr_lainkebutuhandeukasia8a,
                :emr_lainkebutuhandeukasidetail8a,:mr_pasien8a,:noreg_pasien8a,:namauserx8a)");
                $this->db->bind('emr_fungsibicara8a', $emr_fungsibicara);
                $this->db->bind('emr_kelainanfungsibicara8a', $emr_kelainanfungsibicara);
                $this->db->bind('emr_bahasasehari8a', $emr_bahasasehari);
                $this->db->bind('emr_bahaseharidetail8a', $emr_bahaseharidetail);
                $this->db->bind('emr_perlupenerjemah8a', $emr_perlupenerjemah);
                $this->db->bind('emr_perlupenerjemahdetail8a', $emr_perlupenerjemahdetail);
                $this->db->bind('emr_bhsisyarat8a', $emr_bhsisyarat);
                $this->db->bind('emr_bhsisyaratdetail8a', $emr_bhsisyaratdetail);
                $this->db->bind('emr_hambatanbelajarsecarafisik8a', $emr_hambatanbelajarsecarafisik);
                $this->db->bind('emr_hambatanbelajarsecarafisikdetail8a', $emr_hambatanbelajarsecarafisikdetail);
                $this->db->bind('emr_hambatanbelajarsecarabudaya8a', $emr_hambatanbelajarsecarabudaya);
                $this->db->bind('emr_hambatanbelajarsecarabudayadetail8a', $emr_hambatanbelajarsecarabudayadetail);
                $this->db->bind('emr_hambatanbelajarsecarabahasa8a', $emr_hambatanbelajarsecarabahasa);
                $this->db->bind('emr_hambatanbelajarsecarabahasadetail8a', $emr_hambatanbelajarsecarabahasadetail);
                $this->db->bind('emr_hambatanbelajarsecaraemosi8a', $emr_hambatanbelajarsecaraemosi);
                $this->db->bind('emr_hambatanbelajarsecaraemosidetail8a', $emr_hambatanbelajarsecaraemosidetail);
                $this->db->bind('emr_lainkebutuhandeukasidetail8a', $emr_lainkebutuhandeukasidetail);
                $this->db->bind('mr_pasien8a', $mr_pasien);
                $this->db->bind('noreg_pasien8a', $noreg_pasien);
                $this->db->bind('namauserx8a', $namauserx);

                $this->db->bind('checkbox_emr_pengobatana8a', $checkbox_emr_pengobatan);
                $this->db->bind('checkbox_emr_nutrisia8a', $checkbox_emr_nutrisi);
                $this->db->bind('checkbox_emr_tindakanmedisa8a', $checkbox_emr_tindakanmedis);
                $this->db->bind('checkbox_emr_keperawatana8a', $checkbox_emr_keperawatan);
                $this->db->bind('checkbox_emr_lainkebutuhandeukasia8a', $checkbox_emr_lainkebutuhandeukasi);
                $this->db->execute();



                $this->db->query("INSERT INTO EMR.dbo.OutpatientPsikososialEkonomiSpiritual 
                ([TingkatPendidikan],[TingkatPendidikan_Detail],[Pekerjaan],[Pekerjaan_Detail],[Tinggal_Bersama],
                [Tinggal_Bersama_Detail],[Tenang],[Sedih_Menangis_MenarikDiri],[Cemas_Gelisah],[TakutTerapi_Tindakan_Lingkungan],[Marah_Mudah_Tersinggung],[Agama],[Agama_Detail],
                [Hambatan_Menjalankan_Ibadah],[Hambatan_Menjalankan_Ibadah_Detail],[Nilai_Kepercayaan_Dianut],[Nilai_Kepercayaan_Dianut_Detail],
                [Pantang_Makanan_Minuman],[Pantang_Makanan_Minuman_Detail],[Riwayat_Tindak_Kekerasan],[Riwayat_Tindak_Kekerasan_Detail],
                [No_RM],[No_Registrasi],[User_Input])
                VALUES
                (:emr_tingkkatpendidikan9a,:emr_tingkkatpendidikanselain9a,:emr_pekerjaansaatini9a,:emr_pekerjaansaatiniselain9a,:emr_tinggalsaatini9a,
                :emr_tinggalsaatiniselain9a,
                :checkbox_emr_tenang9a,
                :checkbox_emr_sedihmenangis9a,
                :checkbox_emr_cemasgelisah9a,
                :checkbox_emr_takutsekitar9a,
                :checkbox_emr_mudahmarah9a,
                :emr_agamasaatini9a,:emr_agamasaatiniselain9a,
                :emr_hambatanmenjalankanibadah9a,:emr_hambatanmenjalankanibadahket9a,:emr_nilaikepercayaandiriyangdianut9a,:emr_nilaikepercayaandiriyangdianutket9a,
                :emr_pantangmakanananminuman9a,:emr_pantangmakanananminumanket9a,:emr_riwayattindakkekerasan9a,:emr_riwayattindakkekerasanket9a,
                :mr_pasien9a,:noreg_pasien9a,:namauserx9a)");
                $this->db->bind('emr_tingkkatpendidikan9a', $emr_tingkkatpendidikan);
                $this->db->bind('emr_tingkkatpendidikanselain9a', $emr_tingkkatpendidikanselain);
                $this->db->bind('emr_pekerjaansaatini9a', $emr_pekerjaansaatini);
                $this->db->bind('emr_pekerjaansaatiniselain9a', $emr_pekerjaansaatiniselain);
                $this->db->bind('emr_tinggalsaatini9a', $emr_tinggalsaatini);
                $this->db->bind('emr_tinggalsaatiniselain9a', $emr_tinggalsaatiniselain);
                $this->db->bind('emr_agamasaatini9a', $emr_agamasaatini);
                $this->db->bind('emr_agamasaatiniselain9a', $emr_agamasaatiniselain);
                $this->db->bind('emr_hambatanmenjalankanibadah9a', $emr_hambatanmenjalankanibadah);
                $this->db->bind('emr_hambatanmenjalankanibadahket9a', $emr_hambatanmenjalankanibadahket);
                $this->db->bind('emr_nilaikepercayaandiriyangdianut9a', $emr_nilaikepercayaandiriyangdianut);
                $this->db->bind('emr_nilaikepercayaandiriyangdianutket9a', $emr_nilaikepercayaandiriyangdianutket);
                $this->db->bind('emr_pantangmakanananminuman9a', $emr_pantangmakanananminuman);
                $this->db->bind('emr_pantangmakanananminumanket9a', $emr_pantangmakanananminumanket);
                $this->db->bind('emr_riwayattindakkekerasan9a', $emr_riwayattindakkekerasan);
                $this->db->bind('emr_riwayattindakkekerasanket9a', $emr_riwayattindakkekerasanket);
                $this->db->bind('mr_pasien9a', $mr_pasien);
                $this->db->bind('noreg_pasien9a', $noreg_pasien);
                $this->db->bind('namauserx9a', $namauserx);

                $this->db->bind('checkbox_emr_tenang9a', $checkbox_emr_tenang);
                $this->db->bind('checkbox_emr_sedihmenangis9a', $checkbox_emr_sedihmenangis);
                $this->db->bind('checkbox_emr_cemasgelisah9a', $checkbox_emr_cemasgelisah);
                $this->db->bind('checkbox_emr_takutsekitar9a', $checkbox_emr_takutsekitar);
                $this->db->bind('checkbox_emr_mudahmarah9a', $checkbox_emr_mudahmarah);
                $this->db->execute();


                $this->db->query("INSERT INTO EMR.dbo.OutpatientKeperawatanGigi 
                ([NA_Keperawatan_Gigi],[Riwayat_Perawatan_Gigi],[Riwayat_Perawatan_Gigi_Detail],[TakutCemas_Setelah_PerawatanGigi],[Pemeliharaan_Gigi_Baik],
                [SikatGigi_Min_2xSehari],[Menyikat_Gigi_Benar],[Mengurangi_Makanan_ManisLengket],[Warna_Bibir],[Bibir_Simetris],[Bibir_Simetris_Detail],
                [Bibir_Lembab],[Bibir_Lembab_Detail],[Bibir_Pecah_Pecah],[Bibir_Berdarah],[Bibir_Biru],[Bibir_Pucat],[Bibir_Bengkak],[BB_Lahir],[TB_Lahir],
                [Cacat_Bawaan],[Cacat_Bawaan_Detail],[Penyakit_Setelah_Lahir],[Penyakit_Setelah_Lahir_Detail],[BCG],[BCG_Usia],[DPT],[DPT_Usia1],
                [Polio],[Polio_Usia],[Campak],[Campak_Usia],[MMR],[MMR_Usia],[HEPB],[HEPB_Usia1],[HEPA],[HEPA_Usia],[Boster],[Boster_Usia],[HIBI],[HIBI_Usia],
                [Varicela],[Varicela_Usia],[Rotavirus],[Rotavirus_Usia],[Pneunomia],[Pneunomia_Usia],[Thypoid],[Thypoid_Usia],[Influenza],[Influenza_Usia],
                [Riwayat_Asi],[Susu_Formnula],[Makanan_Tambahan],[kelainan_Pertumbuhan],[kelainan_Pertumbuhan_Detail],[No_RM],[No_Registrasi],[User_Input])
                VALUES
                (:checkbox_emr_napengkajiangigi10a,:emr_riwayatperawatangigi10a,:emr_riwayatperawatangigikapan10a,:emr_riwayatperawatangigimenjaditrauma10a,:emr_pasienmengetahuiperwatangigiyangbenar10a,
                :emr_sikatgigimax2kali10a,:emr_sikatgigidenganbenar10a,:emr_mengurangimakananyangmanis10a,:emer_warnabibir10a,:emr_bibirsimetris10a,:emr_bibirsimetrisket10a,
                :emr_bibirlembab10a,:emr_bibirlembabdetail10a,
                :checkbox_emr_bibirpecah10a,
                :checkbox_emr_bibirberdarah10a,
                :checkbox_emr_bibirsianosis10a,
                :checkbox_emr_bibirpucat10a,
                :checkbox_emr_bibirbengkak10a,:emr_beratbadanlahir10a,:emr_panjanglahir10a,
                :emr_cacatbawaan10a,:emr_cacatbawaanket10a,:emr_riwayatpenyakitsetelahlahir10a,:emr_riwayatpenyakitsetelahlahirket10a,
                :checkbox_emr_bcg10a,:emr_bcgusia10a,
                :checkbox_emr_dpt10a,:emr_dptusia10a,
                :checkbox_emr_polio10a,:emr_poliousia10a,
                :checkbox_emr_campak10a,:emr_campakusia10a,
                :checkbox_emr_mmr10a,:emr_mmrusia10a,
                :checkbox_emr_hepb10a,:emr_hepbusia10a,
                :checkbox_emr_hepa10a,:emr_hepausia10a,
                :checkbox_emr_boster10a,:emr_bosterusia10a,
                :checkbox_emr_hibi10a,:emr_hibiusia10a,
                :checkbox_emr_varicela10a,:emr_varicelausia10a,
                :checkbox_emr_rotavirus10a,:emr_rotavirususia10a,
                :checkbox_emr_pneumonia10a,:emr_pneumoniausia10a,
                :checkbox_emr_thypoid10a,:emr_thypoidusia10a,
                :checkbox_emr_influenza10a,:emr_influenzausia10a,
                :emr_riwayatasi10a,:emr_riwayatsufor10a,:emr_makanantambahanusia10a,:emr_riwayatkelainanpertumbuhan10a,:emr_riwayatkelainanpertumbuhanket10a,:mr_pasien10a,:noreg_pasien10a,:namauserx10a)");
                $this->db->bind('emr_riwayatperawatangigi10a', $emr_riwayatperawatangigi);
                $this->db->bind('emr_riwayatperawatangigikapan10a', $emr_riwayatperawatangigikapan);
                $this->db->bind('emr_riwayatperawatangigimenjaditrauma10a', $emr_riwayatperawatangigimenjaditrauma);
                $this->db->bind('emr_pasienmengetahuiperwatangigiyangbenar10a', $emr_pasienmengetahuiperwatangigiyangbenar);
                $this->db->bind('emr_sikatgigimax2kali10a', $emr_sikatgigimax2kali);
                $this->db->bind('emr_sikatgigidenganbenar10a', $emr_sikatgigidenganbenar);
                $this->db->bind('emr_mengurangimakananyangmanis10a', $emr_mengurangimakananyangmanis);
                $this->db->bind('emer_warnabibir10a', $emer_warnabibir);
                $this->db->bind('emr_bibirsimetris10a', $emr_bibirsimetris);
                $this->db->bind('emr_bibirsimetrisket10a', $emr_bibirsimetrisket);
                $this->db->bind('emr_bibirlembab10a', $emr_bibirlembab);
                $this->db->bind('emr_bibirlembabdetail10a', $emr_bibirlembabdetail);
                $this->db->bind('emr_beratbadanlahir10a', $emr_beratbadanlahir);
                $this->db->bind('emr_panjanglahir10a', $emr_panjanglahir);
                $this->db->bind('emr_cacatbawaan10a', $emr_cacatbawaan);
                $this->db->bind('emr_cacatbawaanket10a', $emr_cacatbawaanket);
                $this->db->bind('emr_riwayatpenyakitsetelahlahir10a', $emr_riwayatpenyakitsetelahlahir);
                $this->db->bind('emr_riwayatpenyakitsetelahlahirket10a', $emr_riwayatpenyakitsetelahlahirket);
                $this->db->bind('emr_bcgusia10a', $emr_bcgusia);
                $this->db->bind('emr_dptusia10a', $emr_dptusia);
                $this->db->bind('emr_poliousia10a', $emr_poliousia);
                $this->db->bind('emr_campakusia10a', $emr_campakusia);
                $this->db->bind('emr_mmrusia10a', $emr_mmrusia);
                $this->db->bind('emr_hepbusia10a', $emr_hepbusia);
                $this->db->bind('emr_hepausia10a', $emr_hepausia);
                $this->db->bind('emr_bosterusia10a', $emr_bosterusia);
                $this->db->bind('emr_hibiusia10a', $emr_hibiusia);
                $this->db->bind('emr_varicelausia10a', $emr_varicelausia);
                $this->db->bind('emr_rotavirususia10a', $emr_rotavirususia);
                $this->db->bind('emr_pneumoniausia10a', $emr_pneumoniausia);
                $this->db->bind('emr_thypoidusia10a', $emr_thypoidusia);
                $this->db->bind('emr_influenzausia10a', $emr_influenzausia);
                $this->db->bind('emr_riwayatasi10a', $emr_riwayatasi);
                $this->db->bind('emr_riwayatsufor10a', $emr_riwayatsufor);
                $this->db->bind('emr_makanantambahanusia10a', $emr_makanantambahanusia);
                $this->db->bind('emr_riwayatkelainanpertumbuhan10a', $emr_riwayatkelainanpertumbuhan);
                $this->db->bind('emr_riwayatkelainanpertumbuhanket10a', $emr_riwayatkelainanpertumbuhanket);
                $this->db->bind('mr_pasien10a', $mr_pasien);
                $this->db->bind('noreg_pasien10a', $noreg_pasien);
                $this->db->bind('namauserx10a', $namauserx);

                $this->db->bind('checkbox_emr_napengkajiangigi10a', $checkbox_emr_napengkajiangigi);
                $this->db->bind('checkbox_emr_bibirpecah10a', $checkbox_emr_bibirpecah);
                $this->db->bind('checkbox_emr_bibirberdarah10a', $checkbox_emr_bibirberdarah);
                $this->db->bind('checkbox_emr_bibirsianosis10a', $checkbox_emr_bibirsianosis);
                $this->db->bind('checkbox_emr_bibirpucat10a', $checkbox_emr_bibirpucat);
                $this->db->bind('checkbox_emr_bibirbengkak10a', $checkbox_emr_bibirbengkak);
                $this->db->bind('checkbox_emr_bcg10a', $checkbox_emr_bcg);
                $this->db->bind('checkbox_emr_dpt10a', $checkbox_emr_dpt);
                $this->db->bind('checkbox_emr_polio10a', $checkbox_emr_polio);
                $this->db->bind('checkbox_emr_campak10a', $checkbox_emr_campak);
                $this->db->bind('checkbox_emr_mmr10a', $checkbox_emr_mmr);
                $this->db->bind('checkbox_emr_hepb10a', $checkbox_emr_hepb);
                $this->db->bind('checkbox_emr_hepa10a', $checkbox_emr_hepa);
                $this->db->bind('checkbox_emr_boster10a', $checkbox_emr_boster);
                $this->db->bind('checkbox_emr_hibi10a', $checkbox_emr_hibi);
                $this->db->bind('checkbox_emr_varicela10a', $checkbox_emr_varicela);
                $this->db->bind('checkbox_emr_rotavirus10a', $checkbox_emr_rotavirus);
                $this->db->bind('checkbox_emr_pneumonia10a', $checkbox_emr_pneumonia);
                $this->db->bind('checkbox_emr_thypoid10a', $checkbox_emr_thypoid);
                $this->db->bind('checkbox_emr_influenza10a', $checkbox_emr_influenza);
                $this->db->execute();



                $this->db->query("INSERT INTO EMR.dbo.OutpatientDischargePlaning 
                ([Butuhkan_Bantuan_Untuk_Aktifitas],[Butuhkan_Bantuan_Untuk_Aktifitas_Detail]
                ,[Butuh_Peralatan_Medis_Setelah_Dari_RS],[Butuh_Peralatan_Medis_Setelah_Dari_RS_Detail],[Perlu_Edukasi_Kesehatan_Setelah_Dari_RS],
                [Perlu_Edukasi_Kesehatan_Setelah_Dari_RS_Detail],[Tinggal_Sendiri_Setelah_Dari_RS],[Tinggal_Sendiri_Setelah_Dari_RS_Detail],
                [Perawatan_Lanjutan_Setelah_Dari_RS],[Perawatan_Lanjutan_Setelah_Dari_RS_Detail],[TempatTinggal_Dekat_Pelayanan_Kesehatan],
                [TempatTinggal_Dekat_Pelayanan_Kesehatan_Detail],[Ada_Yang_Merawat_Dirumah],[Ada_Yang_Merawat_Dirumah_Detail],[Nyeri_Kronis_Kelelahan],
                [Nyeri_Kronis_Kelelahan_Detail],[Memerlukan_Transportasi],[Memerlukan_Transportasi_Detail],[Perlu_Bantuan_Khusus],
                [Perlu_Bantuan_Khusus_Detail],[No_RM],[No_Registrasi],[User_Input])
                VALUES
                (:emr_memerlukanbantuanuntukaktifitas11a,:emr_memerlukanbantuanuntukaktifitasket11a,:emr_memerlukanperalatanmedis11a,:emr_memerlukanperalatanmedisket11a,:emr_memerlukanedukasikesehatan11a,
                :emr_memerlukanedukasikesehatanket11a,:emr_tinggalsendiri11a,:emr_tinggalsendiriket11a,
                :emr_perwatanlanjutan11a,:emr_perwatanlanjutanket11a,:emr_dekatdenganpelayanankesehatan11a,
                :emr_dekatdenganpelayanankesehatanket11a,:emr_dirumahadayangmerawat11a,:emr_dirumahadayangmerawatket11a,:emr_memilikinyerikronis11a,
                :emr_memilikinyerikronisket11a,:emr_memerlukantransport11a,:emr_memerlukantransportket11a,:emr_bantuanperawatankhusus11a,
                :emr_bantuanperawatankhususket11a,:mr_pasien11a,:noreg_pasien11a,:namauserx11a)");
                $this->db->bind('emr_memerlukanbantuanuntukaktifitas11a', $emr_memerlukanbantuanuntukaktifitas);
                $this->db->bind('emr_memerlukanbantuanuntukaktifitasket11a', $emr_memerlukanbantuanuntukaktifitasket);
                $this->db->bind('emr_memerlukanperalatanmedis11a', $emr_memerlukanperalatanmedis);
                $this->db->bind('emr_memerlukanperalatanmedisket11a', $emr_memerlukanperalatanmedisket);
                $this->db->bind('emr_memerlukanedukasikesehatan11a', $emr_memerlukanedukasikesehatan);
                $this->db->bind('emr_memerlukanedukasikesehatanket11a', $emr_memerlukanedukasikesehatanket);
                $this->db->bind('emr_tinggalsendiri11a', $emr_tinggalsendiri);
                $this->db->bind('emr_tinggalsendiriket11a', $emr_tinggalsendiriket);
                $this->db->bind('emr_perwatanlanjutan11a', $emr_perwatanlanjutan);
                $this->db->bind('emr_perwatanlanjutanket11a', $emr_perwatanlanjutanket);
                $this->db->bind('emr_dekatdenganpelayanankesehatan11a', $emr_dekatdenganpelayanankesehatan);
                $this->db->bind('emr_dekatdenganpelayanankesehatanket11a', $emr_dekatdenganpelayanankesehatanket);
                $this->db->bind('emr_dirumahadayangmerawat11a', $emr_dirumahadayangmerawat);
                $this->db->bind('emr_dirumahadayangmerawatket11a', $emr_dirumahadayangmerawatket);
                $this->db->bind('emr_memilikinyerikronis11a', $emr_memilikinyerikronis);
                $this->db->bind('emr_memilikinyerikronisket11a', $emr_memilikinyerikronisket);
                $this->db->bind('emr_memerlukantransport11a', $emr_memerlukantransport);
                $this->db->bind('emr_memerlukantransportket11a', $emr_memerlukantransportket);
                $this->db->bind('emr_bantuanperawatankhusus11a', $emr_bantuanperawatankhusus);
                $this->db->bind('emr_bantuanperawatankhususket11a', $emr_bantuanperawatankhususket);
                $this->db->bind('mr_pasien11a', $mr_pasien);
                $this->db->bind('noreg_pasien11a', $noreg_pasien);
                $this->db->bind('namauserx11a', $namauserx);
                $this->db->execute();
            } else {
                $this->db->query("UPDATE EMR.dbo.OutpatientWakilPasien SET Nama_Wakil_Pasien = :nama_wakil1b, Umur_Wakil_Paisen = :umur_wakil1b, NoHp_Wakil_Pasien = :nohp_wakil1b, NIK_Wakil_Pasien = :nik_wakil1b, Pekerjaan_Wakil_Pasien = :pekerjaan_wakil1b, Alamat_Wakil_Pasien = :alamat_wakil1b, Hubungan_Wakil_Pasien = :hubungan_wakil1b, Keterangan_Wakil_Pasien = :keterangan_wakil1b, JenisKelamin_Wakil_Pasien = :jeniskelamin_wakil1b, User_Input = :namauserx1b WHERE No_Registrasi = :noreg_pasien1b");
                $this->db->bind('noreg_pasien1b', $noreg_pasien);
                $this->db->bind('nama_wakil1b', $nama_wakil);
                $this->db->bind('umur_wakil1b', $umur_wakil);
                $this->db->bind('nik_wakil1b', $nik_wakil);
                $this->db->bind('nohp_wakil1b', $nohp_wakil);
                $this->db->bind('pekerjaan_wakil1b', $pekerjaan_wakil);
                $this->db->bind('alamat_wakil1b', $alamat_wakil);
                $this->db->bind('hubungan_wakil1b', $hubungan_wakil);
                $this->db->bind('keterangan_wakil1b', $keterangan_wakil);
                $this->db->bind('jeniskelamin_wakil1b', $jeniskelamin_wakil);
                $this->db->bind('namauserx1b', $namauserx);
                $this->db->execute();

                $this->db->query("UPDATE EMR.dbo.OutpatientAssesments SET Keluhan_Utama = :emr_keluhan_utama2b, Pernapasan = :emr_pernapasan2b, Tensi = :emr_tensi2b, 
                Sistole = :emr_sistole2b, Diastole = :emr_diastole2b, Suhu = :emr_suhu2b, Nadi = :emr_nadi2b, SpO2 = :emr_spo22b, Tinggi_Badan = :emr_tinggibadan2b, Berat_Badan = :emr_beratbadan2b, Hamil = :emr_hamil2b, Menyusui = :emr_menyusui2b, Riwayat_Alergi = :emr_riwayatalergi2b, 
                Riwayat_Alergi_Detail = :emr_riwayatalergiya2b, NA_Assesment=:checkbox_nariwayatalergi2b, User_Input = :namauserx2b,
Pulang = :emr_pulang2b,
Rawat_Inap = :emr_rawatinap2b,
Rujuk = :checkbox_emr_rujuk2b,
Rujuk_Detail = :emr_rujukuntuk2b
                 WHERE No_Registrasi = :noreg_pasien2b");
                $this->db->bind('noreg_pasien2b', $noreg_pasien);
                $this->db->bind('emr_keluhan_utama2b', $emr_keluhan_utama);
                $this->db->bind('emr_pernapasan2b', $emr_pernapasan);
                $this->db->bind('emr_tensi2b', $emr_tensi);
                $this->db->bind('emr_sistole2b', $emr_sistole);
                $this->db->bind('emr_diastole2b', $emr_diastole);
                $this->db->bind('emr_suhu2b', $emr_suhu);
                $this->db->bind('emr_nadi2b', $emr_nadi);
                $this->db->bind('emr_spo22b', $emr_spo2);
                $this->db->bind('emr_tinggibadan2b', $emr_tinggibadan);
                $this->db->bind('emr_beratbadan2b', $emr_beratbadan);
                $this->db->bind('emr_hamil2b', $emr_hamil);
                $this->db->bind('emr_menyusui2b', $emr_menyusui);
                $this->db->bind('emr_riwayatalergi2b', $emr_riwayatalergi);
                $this->db->bind('emr_riwayatalergiya2b', $emr_riwayatalergiya);
                $this->db->bind('checkbox_nariwayatalergi2b', $checkbox_nariwayatalergi);
                $this->db->bind('namauserx2b', $namauserx);

                $this->db->bind('emr_pulang2b', $emr_pulang);
                $this->db->bind('emr_rawatinap2b', $emr_rawatinap);
                $this->db->bind('checkbox_emr_rujuk2b', $checkbox_emr_rujuk);
                $this->db->bind('emr_rujukuntuk2b', $emr_rujukuntuk);
                $this->db->execute();

                $this->db->query("UPDATE EMR.dbo.OutpatientTriageCovid19 SET Batuk_SakitTenggorokan_HidungTersumbat = :emr_batutenggorokantersumbat3b, Sesak_PeningkatanFreskuensiNafas = :emr_frekuensispo23b, Demam_1 = :emr_demam13b, Riwayat_Kontak_Pasien_Covid = :emr_riwayatkontakerat3b, Riwayat_Perjalanan = :emr_riwayatperjalanan3b, Tanda_Pneumia = :emr_tandapeunomiadenganct3b, Riwayat_Kontak_Pasien_Covid_2 = :emr_riwayatkontakeratdenganpasiencovid3b, Demam_2 = :emr_demam23b, Usia_Diatas_43Thn = :emr_usialebihdarisamadengan443b, Jenis_Kelamin = :emr_jeniskelamincek3b, Suhu_Max_38C = :emr_suhumaxsejaksampai3b, Gejala_Gangguan_Respirasi = :emr_gejalagangguanrespirasi3b, RasioNeutrofildanLimfosit_lebihdari_57 = :emr_rasioneutrofil3b, User_Input = :namauserx3b
                WHERE No_Registrasi = :noreg_pasien3b");
                $this->db->bind('noreg_pasien3b', $noreg_pasien);
                $this->db->bind('emr_batutenggorokantersumbat3b', $emr_batutenggorokantersumbat);
                $this->db->bind('emr_frekuensispo23b', $emr_frekuensispo2);
                $this->db->bind('emr_demam13b', $emr_demam1);
                $this->db->bind('emr_riwayatkontakerat3b', $emr_riwayatkontakerat);
                $this->db->bind('emr_riwayatperjalanan3b', $emr_riwayatperjalanan);
                $this->db->bind('emr_tandapeunomiadenganct3b', $emr_tandapeunomiadenganct);
                $this->db->bind('emr_riwayatkontakeratdenganpasiencovid3b', $emr_riwayatkontakeratdenganpasiencovid);
                $this->db->bind('emr_demam23b', $emr_demam2);
                $this->db->bind('emr_usialebihdarisamadengan443b', $emr_usialebihdarisamadengan44);
                $this->db->bind('emr_jeniskelamincek3b', $emr_jeniskelamincek);
                $this->db->bind('emr_suhumaxsejaksampai3b', $emr_suhumaxsejaksampai);
                $this->db->bind('emr_gejalagangguanrespirasi3b', $emr_gejalagangguanrespirasi);
                $this->db->bind('emr_rasioneutrofil3b', $emr_rasioneutrofil);
                $this->db->bind('namauserx3b', $namauserx);
                $this->db->execute();

                $this->db->query("UPDATE EMR.dbo.OutpatientSkriningTBC SET Batuk_Max_2Minggu = :emr_adakahbatukselama2minggu4b, Dahak_Bercampur_Darah = :emr_dahakbercampurdarah4b, DemamMeriang_Max_1Bulan = :emr_demammerianglebihdari1bulan4b, Sesak_Nafas = :emr_sesaknafas4b, Riwayat_Batuk_Berdarah = :emr_riwayatbatukberdarah4b, Lemah = :emr_lemah4b, Badan_Lemas_Berdarah = :emr_badanlemas4b, Keringatan_Malam_Tanpa_Aktifitas = :emr_keringatmalamtanpaaktifitas4b, BB_Menurun_Drastis = :emr_beratbadanmenurundrastis4b, User_Input = :namauserx4b, NA_Skrining_TBC = :checkbox_naskrinningtbc4b,Kesimpulan_Negatif = :checkbox_negatif4b,Kesimpulan_ODP_PDP = :checkbox_odp4b,Kesimpulan_Tuberkulosis = :checkbox_tbc4b,Kesimpulan_Pinere_Lainnya = :checkbox_pinerelainnya4b
                WHERE No_Registrasi = :noreg_pasien4b");
                $this->db->bind('noreg_pasien4b', $noreg_pasien);
                $this->db->bind('emr_adakahbatukselama2minggu4b', $emr_adakahbatukselama2minggu);
                $this->db->bind('emr_dahakbercampurdarah4b', $emr_dahakbercampurdarah);
                $this->db->bind('emr_demammerianglebihdari1bulan4b', $emr_demammerianglebihdari1bulan);
                $this->db->bind('emr_sesaknafas4b', $emr_sesaknafas);
                $this->db->bind('emr_riwayatbatukberdarah4b', $emr_riwayatbatukberdarah);
                $this->db->bind('emr_lemah4b', $emr_lemah);
                $this->db->bind('emr_badanlemas4b', $emr_badanlemas);
                $this->db->bind('emr_keringatmalamtanpaaktifitas4b', $emr_keringatmalamtanpaaktifitas);
                $this->db->bind('emr_beratbadanmenurundrastis4b', $emr_beratbadanmenurundrastis);
                $this->db->bind('namauserx4b', $namauserx);

                $this->db->bind('checkbox_naskrinningtbc4b', $checkbox_naskrinningtbc);
                $this->db->bind('checkbox_negatif4b', $checkbox_negatif);
                $this->db->bind('checkbox_odp4b', $checkbox_odp);
                $this->db->bind('checkbox_tbc4b', $checkbox_tbc);
                $this->db->bind('checkbox_pinerelainnya4b', $checkbox_pinerelainnya);
                $this->db->execute();

                $this->db->query("UPDATE EMR.dbo.OutpatientAnamnesis SET Anamnesis = :emr_anamnesis5b, Keluhan_Utama_Anamnesis = :emr_keluhanutamaanamnesis5b, Riwayat_Penyakit_Sekarang = :emr_riwayatpenyakitsekarang5b, Riwayat_Penyakit_Terdahulu = :emr_riwayatpenyakitterdahulu5b, Riwayat_Penyakit_Terdahulu_Detail = :emr_riwayatpenyakitterdahulurincian5b, Riwayat_Pembedahan = :emr_pembedahan5b, Riwayat_Pembedahan_Detail = :emr_pembedahanrincian5b, Riwayat_Rawat_Sebelumnya = :emr_riwayatrawatsebelumnya5b, Riwayat_Rawat_Sebelumnya_Detail = :emr_riwayatrawatsebelumnyarincian5b, Obat_Rutin_Dari_Rumah = :emr_adaobatrutinyangdiminum5b, Obat_Rutin_Dari_Rumah_Detail = :emr_adaobatrutinyangdiminumrincian5b, User_Input = :namauserx5b
                WHERE No_Registrasi = :noreg_pasien5b");
                $this->db->bind('noreg_pasien5b', $noreg_pasien);
                $this->db->bind('emr_anamnesis5b', $emr_anamnesis);
                $this->db->bind('emr_keluhanutamaanamnesis5b', $emr_keluhanutamaanamnesis);
                $this->db->bind('emr_riwayatpenyakitsekarang5b', $emr_riwayatpenyakitsekarang);
                $this->db->bind('emr_riwayatpenyakitterdahulu5b', $emr_riwayatpenyakitterdahulu);
                $this->db->bind('emr_riwayatpenyakitterdahulurincian5b', $emr_riwayatpenyakitterdahulurincian);
                $this->db->bind('emr_pembedahan5b', $emr_pembedahan);
                $this->db->bind('emr_pembedahanrincian5b', $emr_pembedahanrincian);
                $this->db->bind('emr_riwayatrawatsebelumnya5b', $emr_riwayatrawatsebelumnya);
                $this->db->bind('emr_riwayatrawatsebelumnyarincian5b', $emr_riwayatrawatsebelumnyarincian);
                $this->db->bind('emr_adaobatrutinyangdiminum5b', $emr_adaobatrutinyangdiminum);
                $this->db->bind('emr_adaobatrutinyangdiminumrincian5b', $emr_adaobatrutinyangdiminumrincian);
                $this->db->bind('namauserx5b', $namauserx);
                $this->db->execute();

                $this->db->query("UPDATE EMR.dbo.OutpatientSkriningResikoJatuh SET Riwayat_Jatuh_Dalam_3Bulan = :emr_adariwayatjatuhdalam3bulan6b, Riwayat_Seizures = :emr_riwayatseizures6b, Anak_Konsumsi_Narkotik = :emr_anakmengkonmsumsiobat6b, Cara_Berjalan_Saat_Akan_Duduk = :emr_caraberjalanpasiensaatakanduduk6b, Pasien_Memegang_Pinggiran_Kursi = :emr_pasienmemegangpinggirankursi6b, Keluhan_Nyeri = :emr_keluhannyeri6b, Lokasi_Nyeri = :emr_lokasinyeri6b, Nyeri_Timbul_Sejak = :emr_nyeritimbul6b, Frekwensi_Nyeri = :emr_frekwensinyeri6b, Karakteristik_Nyeri = :emr_karakteristiknyeri6b, Etensitas_Nyeri = :emr_etensitasnyeri6b, Metode_Penilaian_Nyeri = :emr_metodepenilaiannyeri6b, Tipe_Nyeri = :emr_tipenyeri6b, Pencetus_Nyeri = :emr_pemberatnyeri6b, Pereda_Nyeri = :emr_halyangdapatmeredakannyeri6b, Tindakan_Mandiri_Perawat_Detail = :emr_tindakanmandiriperawatdetail6b, Kolaborasi_Detail = :emr_kolaborasidetail6b, User_Input = :namauserx6b, NA_Skrining_Jatuh_Anak = :checkbox_emr_naskrinningjatuhanak6b, Risiko_Rendah_Jatuh_Anak = :checkbox_emr_risikorendahjatuh6b, Risiko_Tinggi_Jatuh_Anak = :checkbox_emr_risikotinggijatuh6b, NA_Skrining_Jatuh_Dewasa = :checkbox_emr_naskrinningrisikojatuhmobilisasi6b, Risiko_Rendah_Jatuh_Dewasa = :checkbox_emr_risikorendahpoinpencegahan6b, Risiko_Tinggi_Jatuh_Dewasa = :checkbox_emr_risikotinggipoinpencegahan6b, Tindakan_Mandiri_Perawat = :checkbox_emr_tindakanmandiriperawat6b, Kolaborasi = :checkbox_emr_kolaborasi6b
                WHERE No_Registrasi = :noreg_pasien6b");
                $this->db->bind('noreg_pasien6b', $noreg_pasien);
                $this->db->bind('emr_adariwayatjatuhdalam3bulan6b', $emr_adariwayatjatuhdalam3bulan);
                $this->db->bind('emr_riwayatseizures6b', $emr_riwayatseizures);
                $this->db->bind('emr_anakmengkonmsumsiobat6b', $emr_anakmengkonmsumsiobat);
                $this->db->bind('emr_caraberjalanpasiensaatakanduduk6b', $emr_caraberjalanpasiensaatakanduduk);
                $this->db->bind('emr_pasienmemegangpinggirankursi6b', $emr_pasienmemegangpinggirankursi);
                $this->db->bind('emr_keluhannyeri6b', $emr_keluhannyeri);
                $this->db->bind('emr_lokasinyeri6b', $emr_lokasinyeri);
                $this->db->bind('emr_nyeritimbul6b', $emr_nyeritimbul);
                $this->db->bind('emr_frekwensinyeri6b', $emr_frekwensinyeri);
                $this->db->bind('emr_karakteristiknyeri6b', $emr_karakteristiknyeri);
                $this->db->bind('emr_etensitasnyeri6b', $emr_etensitasnyeri);
                $this->db->bind('emr_metodepenilaiannyeri6b', $emr_metodepenilaiannyeri);
                $this->db->bind('emr_tipenyeri6b', $emr_tipenyeri);
                $this->db->bind('emr_pemberatnyeri6b', $emr_pemberatnyeri);
                $this->db->bind('emr_halyangdapatmeredakannyeri6b', $emr_halyangdapatmeredakannyeri);
                $this->db->bind('emr_tindakanmandiriperawatdetail6b', $emr_tindakanmandiriperawatdetail);
                $this->db->bind('emr_kolaborasidetail6b', $emr_kolaborasidetail);
                $this->db->bind('namauserx6b', $namauserx);

                $this->db->bind('checkbox_emr_naskrinningjatuhanak6b', $checkbox_emr_naskrinningjatuhanak);
                $this->db->bind('checkbox_emr_risikorendahjatuh6b', $checkbox_emr_risikorendahjatuh);
                $this->db->bind('checkbox_emr_risikotinggijatuh6b', $checkbox_emr_risikotinggijatuh);
                $this->db->bind('checkbox_emr_naskrinningrisikojatuhmobilisasi6b', $checkbox_emr_naskrinningrisikojatuhmobilisasi);
                $this->db->bind('checkbox_emr_risikorendahpoinpencegahan6b', $checkbox_emr_risikorendahpoinpencegahan);
                $this->db->bind('checkbox_emr_risikotinggipoinpencegahan6b', $checkbox_emr_risikotinggipoinpencegahan);
                $this->db->bind('checkbox_emr_tindakanmandiriperawat6b', $checkbox_emr_tindakanmandiriperawat);
                $this->db->bind('checkbox_emr_kolaborasi6b', $checkbox_emr_kolaborasi);
                $this->db->execute();

                $this->db->query("UPDATE EMR.dbo.OutPatientSkriningNutrisi SET Resiko_Nutrisional = :emr_risikonutrisi7b, Tampak_Kurus = :emr_pasientampakkurus7b, Penurunan_BB_1Bulan_Terakhir = :emr_penurunanbb7b, Terdapat_Kondisi_DiareMuntahKurangasupan = :emr_terdapatsalahsatukondisi7b, RiwayatPenyakit_Beresiko_Malnutrisi = :emr_beresikomengalamimalnutrisi7b, Nilai_Skor_Malnutrisi = :emr_nilaiskore7b, Nilai_Skor_Nutirisi_Dewasa = :emr_nilaiskoreskrinningdewasa7b, Penurunan_BB_6Bulan_TidakDisengaja = :emr_penurunanberatbadandewasa7b, Skala_Penurunan_BB = :emr_berapapenurunanbbdewasa7b, Asupan_Makanan_Berkurang = :emr_asupanmakananberkurang7b, Pasien_Kebutuhan_Khusus = :emr_kondisikhusus7b, LILA = :emr_lila7b, User_Input = :namauserx7b,

NA_Skrining_Nutrisi_Anak = :checkbox_emr_skrinningnutrisianak7b,
Diare_Konik = :checkbox_emr_diarekronik7b,
Penyakit_Jantung_Bawaan = :checkbox_emr_jantungbawaan7b,
HIV = :checkbox_emr_hiv7b,
Kanker = :checkbox_emr_kanker7b,
Penyakit_Hati_Kronik = :checkbox_emr_hatikronik7b,
Penyakit_Ginjal_Kronik = :checkbox_emr_ginjalkronik7b,
TB_Paru = :checkbox_emr_tbparu7b,
Terpasang_Stoma = :checkbox_emr_terpasangstoma7b,
Tauma = :checkbox_emr_trauma7b,
Luka_Bakar_Luas = :checkbox_emr_lukabakarluas7b,
Kelainan_Anatomi_Daerah_Mulut = :checkbox_emr_kelainananatomidaerahmulut7b,
Pasca_Operasi = :checkbox_emr_rencanapascaoperasi7b,
Kelainan_Metabolik_Bawaan = :checkbox_emr_kelainanmetabolikbawaan7b,
Retardasi_Metal = :checkbox_emr_retardasimetal7b,
Keterlambatan_Perkembangan = :checkbox_emr_stunting7b,
Resiko_Tinggi_Skrining_Nutrisi_Anak = :checkbox_emr_risikotinggikolaborasiahligizi7b,
NA_Skrining_Nutrisi_Dewasa = :checkbox_emr_skrinningnutrisidewasa7b,
Resiko_Tinggi_Skrining_Nutrisi_Dewasa = :checkbox_emr_risikotinggipilihandengandiagnosisi7b,
NA_Skrining_Nutrisi_Ibu_Hamil = :checkbox_emr_skrinningnutrisiibuhamil7b

                WHERE No_Registrasi = :noreg_pasien7b");
                $this->db->bind('noreg_pasien7b', $noreg_pasien);
                $this->db->bind('emr_risikonutrisi7b', $emr_risikonutrisi);
                $this->db->bind('emr_pasientampakkurus7b', $emr_pasientampakkurus);
                $this->db->bind('emr_penurunanbb7b', $emr_penurunanbb);
                $this->db->bind('emr_terdapatsalahsatukondisi7b', $emr_terdapatsalahsatukondisi);
                $this->db->bind('emr_beresikomengalamimalnutrisi7b', $emr_beresikomengalamimalnutrisi);
                $this->db->bind('emr_nilaiskore7b', $emr_nilaiskore);
                $this->db->bind('emr_nilaiskoreskrinningdewasa7b', $emr_nilaiskoreskrinningdewasa);
                $this->db->bind('emr_penurunanberatbadandewasa7b', $emr_penurunanberatbadandewasa);
                $this->db->bind('emr_berapapenurunanbbdewasa7b', $emr_berapapenurunanbbdewasa);
                $this->db->bind('emr_asupanmakananberkurang7b', $emr_asupanmakananberkurang);
                $this->db->bind('emr_kondisikhusus7b', $emr_kondisikhusus);
                $this->db->bind('emr_lila7b', $emr_lila);
                $this->db->bind('namauserx7b', $namauserx);

                $this->db->bind('checkbox_emr_skrinningnutrisianak7b', $checkbox_emr_skrinningnutrisianak);
                $this->db->bind('checkbox_emr_diarekronik7b', $checkbox_emr_diarekronik);
                $this->db->bind('checkbox_emr_jantungbawaan7b', $checkbox_emr_jantungbawaan);
                $this->db->bind('checkbox_emr_hiv7b', $checkbox_emr_hiv);
                $this->db->bind('checkbox_emr_kanker7b', $checkbox_emr_kanker);
                $this->db->bind('checkbox_emr_hatikronik7b', $checkbox_emr_hatikronik);
                $this->db->bind('checkbox_emr_ginjalkronik7b', $checkbox_emr_ginjalkronik);
                $this->db->bind('checkbox_emr_tbparu7b', $checkbox_emr_tbparu);
                $this->db->bind('checkbox_emr_terpasangstoma7b', $checkbox_emr_terpasangstoma);
                $this->db->bind('checkbox_emr_trauma7b', $checkbox_emr_trauma);
                $this->db->bind('checkbox_emr_lukabakarluas7b', $checkbox_emr_lukabakarluas);
                $this->db->bind('checkbox_emr_kelainananatomidaerahmulut7b', $checkbox_emr_kelainananatomidaerahmulut);
                $this->db->bind('checkbox_emr_rencanapascaoperasi7b', $checkbox_emr_rencanapascaoperasi);
                $this->db->bind('checkbox_emr_kelainanmetabolikbawaan7b', $checkbox_emr_kelainanmetabolikbawaan);
                $this->db->bind('checkbox_emr_retardasimetal7b', $checkbox_emr_retardasimetal);
                $this->db->bind('checkbox_emr_stunting7b', $checkbox_emr_stunting);
                $this->db->bind('checkbox_emr_risikotinggikolaborasiahligizi7b', $checkbox_emr_risikotinggikolaborasiahligizi);
                $this->db->bind('checkbox_emr_skrinningnutrisidewasa7b', $checkbox_emr_skrinningnutrisidewasa);
                $this->db->bind('checkbox_emr_risikotinggipilihandengandiagnosisi7b', $checkbox_emr_risikotinggipilihandengandiagnosisi);
                $this->db->bind('checkbox_emr_skrinningnutrisiibuhamil7b', $checkbox_emr_skrinningnutrisiibuhamil);

                $this->db->execute();

                $this->db->query("UPDATE EMR.dbo.OutpatientComunicationEducation SET Fungsi_Bicara = :emr_fungsibicara8b, Fungsi_Bicara_Detail = :emr_kelainanfungsibicara8b, Bahasa_Sehari_Hari = :emr_bahasasehari8b, Bahasa_Sehari_Hari_Detail = :emr_bahaseharidetail8b, Perlu_Penerjemah = :emr_perlupenerjemah8b, Perlu_Penerjemah_Detail = :emr_perlupenerjemahdetail8b, Bahasa_Isyarat = :emr_bhsisyarat8b, Bahasa_Isyarat_Detail = :emr_bhsisyaratdetail8b, Hambatan_Belajar_Secara_Fisik = :emr_hambatanbelajarsecarafisik8b, Hambatan_Belajar_Secara_Fisik_Detail = :emr_hambatanbelajarsecarafisikdetail8b, Hambatan_Belajar_Secara_Budaya = :emr_hambatanbelajarsecarabudaya8b, Hambatan_Belajar_Secara_Budaya_Detai = :emr_hambatanbelajarsecarabudayadetail8b, Hambatan_Belajar_Secara_Bahasa = :emr_hambatanbelajarsecarabahasa8b, Hambatan_Belajar_Secara_Bahasa_Detail = :emr_hambatanbelajarsecarabahasadetail8b, Hambatan_Belajar_Secara_Emosi = :emr_hambatanbelajarsecaraemosi8b, Hambatan_Belajar_Secara_Emosi_Detail = :emr_hambatanbelajarsecaraemosidetail8b, Kebutuhan_Lain_Detail = :emr_lainkebutuhandeukasidetail8b, User_Input = :namauserx8b,
Pengobatan = :checkbox_emr_pengobatana8b,
Nutrisi = :checkbox_emr_nutrisia8b,
Tindakan_Medis = :checkbox_emr_tindakanmedisa8b,
keperawatan = :checkbox_emr_keperawatana8b,
Kebutuhan_Lain = :checkbox_emr_lainkebutuhandeukasia8b
                WHERE No_Registrasi = :noreg_pasien8b");
                $this->db->bind('noreg_pasien8b', $noreg_pasien);
                $this->db->bind('emr_fungsibicara8b', $emr_fungsibicara);
                $this->db->bind('emr_kelainanfungsibicara8b', $emr_kelainanfungsibicara);
                $this->db->bind('emr_bahasasehari8b', $emr_bahasasehari);
                $this->db->bind('emr_bahaseharidetail8b', $emr_bahaseharidetail);
                $this->db->bind('emr_perlupenerjemah8b', $emr_perlupenerjemah);
                $this->db->bind('emr_perlupenerjemahdetail8b', $emr_perlupenerjemahdetail);
                $this->db->bind('emr_bhsisyarat8b', $emr_bhsisyarat);
                $this->db->bind('emr_bhsisyaratdetail8b', $emr_bhsisyaratdetail);
                $this->db->bind('emr_hambatanbelajarsecarafisik8b', $emr_hambatanbelajarsecarafisik);
                $this->db->bind('emr_hambatanbelajarsecarafisikdetail8b', $emr_hambatanbelajarsecarafisikdetail);
                $this->db->bind('emr_hambatanbelajarsecarabudaya8b', $emr_hambatanbelajarsecarabudaya);
                $this->db->bind('emr_hambatanbelajarsecarabudayadetail8b', $emr_hambatanbelajarsecarabudayadetail);
                $this->db->bind('emr_hambatanbelajarsecarabahasa8b', $emr_hambatanbelajarsecarabahasa);
                $this->db->bind('emr_hambatanbelajarsecarabahasadetail8b', $emr_hambatanbelajarsecarabahasadetail);
                $this->db->bind('emr_hambatanbelajarsecaraemosi8b', $emr_hambatanbelajarsecaraemosi);
                $this->db->bind('emr_hambatanbelajarsecaraemosidetail8b', $emr_hambatanbelajarsecaraemosidetail);
                $this->db->bind('emr_lainkebutuhandeukasidetail8b', $emr_lainkebutuhandeukasidetail);
                $this->db->bind('namauserx8b', $namauserx);

                $this->db->bind('checkbox_emr_pengobatana8b', $checkbox_emr_pengobatan);
                $this->db->bind('checkbox_emr_nutrisia8b', $checkbox_emr_nutrisi);
                $this->db->bind('checkbox_emr_tindakanmedisa8b', $checkbox_emr_tindakanmedis);
                $this->db->bind('checkbox_emr_keperawatana8b', $checkbox_emr_keperawatan);
                $this->db->bind('checkbox_emr_lainkebutuhandeukasia8b', $checkbox_emr_lainkebutuhandeukasi);
                $this->db->execute();

                $this->db->query("UPDATE EMR.dbo.OutpatientPsikososialEkonomiSpiritual SET
                TingkatPendidikan = :emr_tingkkatpendidikan9b,
                TingkatPendidikan_Detail = :emr_tingkkatpendidikanselain9b,
                Pekerjaan = :emr_pekerjaansaatini9b,
                Pekerjaan_Detail = :emr_pekerjaansaatiniselain9b,
                Tinggal_Bersama = :emr_tinggalsaatini9b,
                Tinggal_Bersama_Detail = :emr_tinggalsaatiniselain9b,
                Agama = :emr_agamasaatini9b,
                Agama_Detail = :emr_agamasaatiniselain9b,
                Hambatan_Menjalankan_Ibadah = :emr_hambatanmenjalankanibadah9b,
                Hambatan_Menjalankan_Ibadah_Detail = :emr_hambatanmenjalankanibadahket9b,
                Nilai_Kepercayaan_Dianut = :emr_nilaikepercayaandiriyangdianut9b,
                Nilai_Kepercayaan_Dianut_Detail = :emr_nilaikepercayaandiriyangdianutket9b,
                Pantang_Makanan_Minuman = :emr_pantangmakanananminuman9b,
                Pantang_Makanan_Minuman_Detail = :emr_pantangmakanananminumanket9b,
                Riwayat_Tindak_Kekerasan = :emr_riwayattindakkekerasan9b,
                Riwayat_Tindak_Kekerasan_Detail = :emr_riwayattindakkekerasanket9b,
                User_Input = :namauserx9b,
Tenang = :checkbox_emr_tenang9B,
Sedih_Menangis_MenarikDiri = :checkbox_emr_sedihmenangis9B,
Cemas_Gelisah = :checkbox_emr_cemasgelisah9B,
TakutTerapi_Tindakan_Lingkungan = :checkbox_emr_takutsekitar9B,
Marah_Mudah_Tersinggung = :checkbox_emr_mudahmarah9B
                WHERE No_Registrasi = :noreg_pasien9b");
                $this->db->bind('noreg_pasien9b', $noreg_pasien);
                $this->db->bind('emr_tingkkatpendidikan9b', $emr_tingkkatpendidikan);
                $this->db->bind('emr_tingkkatpendidikanselain9b', $emr_tingkkatpendidikanselain);
                $this->db->bind('emr_pekerjaansaatini9b', $emr_pekerjaansaatini);
                $this->db->bind('emr_pekerjaansaatiniselain9b', $emr_pekerjaansaatiniselain);
                $this->db->bind('emr_tinggalsaatini9b', $emr_tinggalsaatini);
                $this->db->bind('emr_tinggalsaatiniselain9b', $emr_tinggalsaatiniselain);
                $this->db->bind('emr_agamasaatini9b', $emr_agamasaatini);
                $this->db->bind('emr_agamasaatiniselain9b', $emr_agamasaatiniselain);
                $this->db->bind('emr_hambatanmenjalankanibadah9b', $emr_hambatanmenjalankanibadah);
                $this->db->bind('emr_hambatanmenjalankanibadahket9b', $emr_hambatanmenjalankanibadahket);
                $this->db->bind('emr_nilaikepercayaandiriyangdianut9b', $emr_nilaikepercayaandiriyangdianut);
                $this->db->bind('emr_nilaikepercayaandiriyangdianutket9b', $emr_nilaikepercayaandiriyangdianutket);
                $this->db->bind('emr_pantangmakanananminuman9b', $emr_pantangmakanananminuman);
                $this->db->bind('emr_pantangmakanananminumanket9b', $emr_pantangmakanananminumanket);
                $this->db->bind('emr_riwayattindakkekerasan9b', $emr_riwayattindakkekerasan);
                $this->db->bind('emr_riwayattindakkekerasanket9b', $emr_riwayattindakkekerasanket);
                $this->db->bind('namauserx9b', $namauserx);

                $this->db->bind('checkbox_emr_tenang9B', $checkbox_emr_tenang);
                $this->db->bind('checkbox_emr_sedihmenangis9B', $checkbox_emr_sedihmenangis);
                $this->db->bind('checkbox_emr_cemasgelisah9B', $checkbox_emr_cemasgelisah);
                $this->db->bind('checkbox_emr_takutsekitar9B', $checkbox_emr_takutsekitar);
                $this->db->bind('checkbox_emr_mudahmarah9B', $checkbox_emr_mudahmarah);
                $this->db->execute();

                $this->db->query("UPDATE EMR.dbo.OutpatientKeperawatanGigi SET Riwayat_Perawatan_Gigi = :emr_riwayatperawatangigi10b, Riwayat_Perawatan_Gigi_Detail = :emr_riwayatperawatangigikapan10b, TakutCemas_Setelah_PerawatanGigi = :emr_riwayatperawatangigimenjaditrauma10b, Pemeliharaan_Gigi_Baik = :emr_pasienmengetahuiperwatangigiyangbenar10b, SikatGigi_Min_2xSehari = :emr_sikatgigimax2kali10b, Menyikat_Gigi_Benar = :emr_sikatgigidenganbenar10b, Mengurangi_Makanan_ManisLengket = :emr_mengurangimakananyangmanis10b, Warna_Bibir = :emer_warnabibir10b, Bibir_Simetris = :emr_bibirsimetris10b, Bibir_Simetris_Detail = :emr_bibirsimetrisket10b, Bibir_Lembab = :emr_bibirlembab10b, Bibir_Lembab_Detail = :emr_bibirlembabdetail10b, BB_Lahir = :emr_beratbadanlahir10b, TB_Lahir = :emr_panjanglahir10b, Cacat_Bawaan = :emr_cacatbawaan10b, Cacat_Bawaan_Detail = :emr_cacatbawaanket10b, Penyakit_Setelah_Lahir = :emr_riwayatpenyakitsetelahlahir10b, Penyakit_Setelah_Lahir_Detail = :emr_riwayatpenyakitsetelahlahirket10b, BCG_Usia = :emr_bcgusia10b, DPT_Usia1 = :emr_dptusia10b, Polio_Usia = :emr_poliousia10b, Campak_Usia = :emr_campakusia10b, MMR_Usia = :emr_mmrusia10b, HEPB_Usia1 = :emr_hepbusia10b, HEPA_Usia = :emr_hepausia10b, Boster_Usia = :emr_bosterusia10b, HIBI_Usia = :emr_hibiusia10b, Varicela_Usia = :emr_varicelausia10b, Rotavirus_Usia = :emr_rotavirususia10b, Pneunomia_Usia = :emr_pneumoniausia10b, Thypoid_Usia = :emr_thypoidusia10b, Influenza_Usia = :emr_influenzausia10b, Riwayat_Asi = :emr_riwayatasi10b, Susu_Formnula = :emr_riwayatsufor10b, Makanan_Tambahan = :emr_makanantambahanusia10b, kelainan_Pertumbuhan = :emr_riwayatkelainanpertumbuhan10b, kelainan_Pertumbuhan_Detail = :emr_riwayatkelainanpertumbuhanket10b, User_Input = :namauserx10b,
NA_Keperawatan_Gigi = :checkbox_emr_napengkajiangigi10b,
Bibir_Pecah_Pecah = :checkbox_emr_bibirpecah10b,
Bibir_Berdarah = :checkbox_emr_bibirberdarah10b,
Bibir_Biru = :checkbox_emr_bibirsianosis10b,
Bibir_Pucat = :checkbox_emr_bibirpucat10b,
Bibir_Bengkak = :checkbox_emr_bibirbengkak10b,
BCG = :checkbox_emr_bcg10b,
DPT = :checkbox_emr_dpt10b,
Polio = :checkbox_emr_polio10b,
Campak = :checkbox_emr_campak10b,
MMR = :checkbox_emr_mmr10b,
HEPB = :checkbox_emr_hepb10b,
HEPA = :checkbox_emr_hepa10b,
Boster = :checkbox_emr_boster10b,
HIBI = :checkbox_emr_hibi10b,
Varicela = :checkbox_emr_varicela10b,
Rotavirus = :checkbox_emr_rotavirus10b,
Pneunomia = :checkbox_emr_pneumonia10b,
Thypoid = :checkbox_emr_thypoid10b,
Influenza = :checkbox_emr_influenza10b
                WHERE No_Registrasi = :noreg_pasien10b");
                $this->db->bind('noreg_pasien10b', $noreg_pasien);
                $this->db->bind('emr_riwayatperawatangigi10b', $emr_riwayatperawatangigi);
                $this->db->bind('emr_riwayatperawatangigikapan10b', $emr_riwayatperawatangigikapan);
                $this->db->bind('emr_riwayatperawatangigimenjaditrauma10b', $emr_riwayatperawatangigimenjaditrauma);
                $this->db->bind('emr_pasienmengetahuiperwatangigiyangbenar10b', $emr_pasienmengetahuiperwatangigiyangbenar);
                $this->db->bind('emr_sikatgigimax2kali10b', $emr_sikatgigimax2kali);
                $this->db->bind('emr_sikatgigidenganbenar10b', $emr_sikatgigidenganbenar);
                $this->db->bind('emr_mengurangimakananyangmanis10b', $emr_mengurangimakananyangmanis);
                $this->db->bind('emer_warnabibir10b', $emer_warnabibir);
                $this->db->bind('emr_bibirsimetris10b', $emr_bibirsimetris);
                $this->db->bind('emr_bibirsimetrisket10b', $emr_bibirsimetrisket);
                $this->db->bind('emr_bibirlembab10b', $emr_bibirlembab);
                $this->db->bind('emr_bibirlembabdetail10b', $emr_bibirlembabdetail);
                $this->db->bind('emr_beratbadanlahir10b', $emr_beratbadanlahir);
                $this->db->bind('emr_panjanglahir10b', $emr_panjanglahir);
                $this->db->bind('emr_cacatbawaan10b', $emr_cacatbawaan);
                $this->db->bind('emr_cacatbawaanket10b', $emr_cacatbawaanket);
                $this->db->bind('emr_riwayatpenyakitsetelahlahir10b', $emr_riwayatpenyakitsetelahlahir);
                $this->db->bind('emr_riwayatpenyakitsetelahlahirket10b', $emr_riwayatpenyakitsetelahlahirket);
                $this->db->bind('emr_bcgusia10b', $emr_bcgusia);
                $this->db->bind('emr_dptusia10b', $emr_dptusia);
                $this->db->bind('emr_poliousia10b', $emr_poliousia);
                $this->db->bind('emr_campakusia10b', $emr_campakusia);
                $this->db->bind('emr_mmrusia10b', $emr_mmrusia);
                $this->db->bind('emr_hepbusia10b', $emr_hepbusia);
                $this->db->bind('emr_hepausia10b', $emr_hepausia);
                $this->db->bind('emr_bosterusia10b', $emr_bosterusia);
                $this->db->bind('emr_hibiusia10b', $emr_hibiusia);
                $this->db->bind('emr_varicelausia10b', $emr_varicelausia);
                $this->db->bind('emr_rotavirususia10b', $emr_rotavirususia);
                $this->db->bind('emr_pneumoniausia10b', $emr_pneumoniausia);
                $this->db->bind('emr_thypoidusia10b', $emr_thypoidusia);
                $this->db->bind('emr_influenzausia10b', $emr_influenzausia);
                $this->db->bind('emr_riwayatasi10b', $emr_riwayatasi);
                $this->db->bind('emr_riwayatsufor10b', $emr_riwayatsufor);
                $this->db->bind('emr_makanantambahanusia10b', $emr_makanantambahanusia);
                $this->db->bind('emr_riwayatkelainanpertumbuhan10b', $emr_riwayatkelainanpertumbuhan);
                $this->db->bind('emr_riwayatkelainanpertumbuhanket10b', $emr_riwayatkelainanpertumbuhanket);
                $this->db->bind('namauserx10b', $namauserx);

                $this->db->bind('checkbox_emr_napengkajiangigi10b', $checkbox_emr_napengkajiangigi);
                $this->db->bind('checkbox_emr_bibirpecah10b', $checkbox_emr_bibirpecah);
                $this->db->bind('checkbox_emr_bibirberdarah10b', $checkbox_emr_bibirberdarah);
                $this->db->bind('checkbox_emr_bibirsianosis10b', $checkbox_emr_bibirsianosis);
                $this->db->bind('checkbox_emr_bibirpucat10b', $checkbox_emr_bibirpucat);
                $this->db->bind('checkbox_emr_bibirbengkak10b', $checkbox_emr_bibirbengkak);
                $this->db->bind('checkbox_emr_bcg10b', $checkbox_emr_bcg);
                $this->db->bind('checkbox_emr_dpt10b', $checkbox_emr_dpt);
                $this->db->bind('checkbox_emr_polio10b', $checkbox_emr_polio);
                $this->db->bind('checkbox_emr_campak10b', $checkbox_emr_campak);
                $this->db->bind('checkbox_emr_mmr10b', $checkbox_emr_mmr);
                $this->db->bind('checkbox_emr_hepb10b', $checkbox_emr_hepb);
                $this->db->bind('checkbox_emr_hepa10b', $checkbox_emr_hepa);
                $this->db->bind('checkbox_emr_boster10b', $checkbox_emr_boster);
                $this->db->bind('checkbox_emr_hibi10b', $checkbox_emr_hibi);
                $this->db->bind('checkbox_emr_varicela10b', $checkbox_emr_varicela);
                $this->db->bind('checkbox_emr_rotavirus10b', $checkbox_emr_rotavirus);
                $this->db->bind('checkbox_emr_pneumonia10b', $checkbox_emr_pneumonia);
                $this->db->bind('checkbox_emr_thypoid10b', $checkbox_emr_thypoid);
                $this->db->bind('checkbox_emr_influenza10b', $checkbox_emr_influenza);
                $this->db->execute();

                $this->db->query("UPDATE EMR.dbo.OutpatientDischargePlaning SET Butuhkan_Bantuan_Untuk_Aktifitas = :emr_memerlukanbantuanuntukaktifitas11b, Butuhkan_Bantuan_Untuk_Aktifitas_Detail = :emr_memerlukanbantuanuntukaktifitasket11b, Butuh_Peralatan_Medis_Setelah_Dari_RS = :emr_memerlukanperalatanmedis11b, Butuh_Peralatan_Medis_Setelah_Dari_RS_Detail = :emr_memerlukanperalatanmedisket11b, Perlu_Edukasi_Kesehatan_Setelah_Dari_RS = :emr_memerlukanedukasikesehatan11b, Perlu_Edukasi_Kesehatan_Setelah_Dari_RS_Detail = :emr_memerlukanedukasikesehatanket11b, Tinggal_Sendiri_Setelah_Dari_RS = :emr_tinggalsendiri11b, Tinggal_Sendiri_Setelah_Dari_RS_Detail = :emr_tinggalsendiriket11b, Perawatan_Lanjutan_Setelah_Dari_RS = :emr_perwatanlanjutan11b, Perawatan_Lanjutan_Setelah_Dari_RS_Detail = :emr_perwatanlanjutanket11b, TempatTinggal_Dekat_Pelayanan_Kesehatan = :emr_dekatdenganpelayanankesehatan11b, TempatTinggal_Dekat_Pelayanan_Kesehatan_Detail = :emr_dekatdenganpelayanankesehatanket11b, Ada_Yang_Merawat_Dirumah = :emr_dirumahadayangmerawat11b, Ada_Yang_Merawat_Dirumah_Detail = :emr_dirumahadayangmerawatket11b, Nyeri_Kronis_Kelelahan = :emr_memilikinyerikronis11b, Nyeri_Kronis_Kelelahan_Detail = :emr_memilikinyerikronisket11b, Memerlukan_Transportasi = :emr_memerlukantransport11b, Memerlukan_Transportasi_Detail = :emr_memerlukantransportket11b, Perlu_Bantuan_Khusus = :emr_bantuanperawatankhusus11b, Perlu_Bantuan_Khusus_Detail = :emr_bantuanperawatankhususket11b, User_Input = :namauserx11b
                WHERE No_Registrasi = :noreg_pasien11b");
                $this->db->bind('noreg_pasien11b', $noreg_pasien);
                $this->db->bind('emr_memerlukanbantuanuntukaktifitas11b', $emr_memerlukanbantuanuntukaktifitas);
                $this->db->bind('emr_memerlukanbantuanuntukaktifitasket11b', $emr_memerlukanbantuanuntukaktifitasket);
                $this->db->bind('emr_memerlukanperalatanmedis11b', $emr_memerlukanperalatanmedis);
                $this->db->bind('emr_memerlukanperalatanmedisket11b', $emr_memerlukanperalatanmedisket);
                $this->db->bind('emr_memerlukanedukasikesehatan11b', $emr_memerlukanedukasikesehatan);
                $this->db->bind('emr_memerlukanedukasikesehatanket11b', $emr_memerlukanedukasikesehatanket);
                $this->db->bind('emr_tinggalsendiri11b', $emr_tinggalsendiri);
                $this->db->bind('emr_tinggalsendiriket11b', $emr_tinggalsendiriket);
                $this->db->bind('emr_perwatanlanjutan11b', $emr_perwatanlanjutan);
                $this->db->bind('emr_perwatanlanjutanket11b', $emr_perwatanlanjutanket);
                $this->db->bind('emr_dekatdenganpelayanankesehatan11b', $emr_dekatdenganpelayanankesehatan);
                $this->db->bind('emr_dekatdenganpelayanankesehatanket11b', $emr_dekatdenganpelayanankesehatanket);
                $this->db->bind('emr_dirumahadayangmerawat11b', $emr_dirumahadayangmerawat);
                $this->db->bind('emr_dirumahadayangmerawatket11b', $emr_dirumahadayangmerawatket);
                $this->db->bind('emr_memilikinyerikronis11b', $emr_memilikinyerikronis);
                $this->db->bind('emr_memilikinyerikronisket11b', $emr_memilikinyerikronisket);
                $this->db->bind('emr_memerlukantransport11b', $emr_memerlukantransport);
                $this->db->bind('emr_memerlukantransportket11b', $emr_memerlukantransportket);
                $this->db->bind('emr_bantuanperawatankhusus11b', $emr_bantuanperawatankhusus);
                $this->db->bind('emr_bantuanperawatankhususket11b', $emr_bantuanperawatankhususket);
                $this->db->bind('namauserx11b', $namauserx);
                $this->db->execute();
            }

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Assesment Berhasi',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function setSaveMasalahKeperawatan($data)
    {
        try {
            $this->db->transaksi();
            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            // DATA MASALAH KEPERAWATAN
            $id_masalahkeperawatan = $data['emr_id_masalahkeperawatan'];
            $nodp_masalahkeperawatan = $data['emr_nodp_masalahkeperawatan'];
            $noreg_masalahkeperawatan = $data['emr_noreg_masalahkeperawatan'];
            $mr_masalahkeperawatan = $data['emr_mr_masalahkeperawatan'];
            $diagnosa_masalahkeperawatan = $data['emr_diagnosa_masalahkeperawatan'];
            //CEK DATA

            if ($id_masalahkeperawatan == "") {
                //GENERATE DATA MASALAH KEPERAWATAN
                $a = 1;
                $this->db->query("SELECT COUNT(ID) urutan FROM EMR.dbo.OutpatientMasalahKeperawatan 
                WHERE No_Registrasi = :noreg_pasien");
                $this->db->bind('noreg_pasien', $noreg_masalahkeperawatan);
                $datamasalahkeperawatan =  $this->db->single();
                $cekmasalahkeperawatan = (int)$datamasalahkeperawatan['urutan'];
                $cekmasalahkeperawatantambah = $cekmasalahkeperawatan + $a;
                $cekmasalahkeperawatantambahfix = Utils::generateAutoNumber($cekmasalahkeperawatantambah);
                $nodp_masalahkeperawatan_insert = $noreg_masalahkeperawatan . '-' . $cekmasalahkeperawatantambahfix;

                $this->db->query("INSERT INTO EMR.dbo.OutpatientMasalahKeperawatan ([No_DP],[Diagnosa_Keperawatan],[Batal],[No_RM],[No_Registrasi],[User_Input],[User_UpdateOrBatal])
                VALUES (:nodp_masalah1a,:diagnosa_masalah1a,0,:mr_masalah1a,:noreg_masalah1a,:namauserx1a,'')");
                $this->db->bind('nodp_masalah1a', $nodp_masalahkeperawatan_insert);
                $this->db->bind('noreg_masalah1a', $noreg_masalahkeperawatan);
                $this->db->bind('mr_masalah1a', $mr_masalahkeperawatan);
                $this->db->bind('diagnosa_masalah1a', $diagnosa_masalahkeperawatan);
                $this->db->bind('namauserx1a', $namauserx);
                $this->db->execute();
            } else {
                $this->db->query("UPDATE EMR.dbo.OutpatientMasalahKeperawatan SET Diagnosa_Keperawatan = :diagnosa_masalahkeperawatan1b, User_UpdateOrBatal= :namauserx1b WHERE ID = :id_masalahkeperawatan1b AND No_DP = :nodp_masalahkeperawatan1b");
                $this->db->bind('id_masalahkeperawatan1b', $id_masalahkeperawatan);
                $this->db->bind('nodp_masalahkeperawatan1b', $nodp_masalahkeperawatan);
                $this->db->bind('diagnosa_masalahkeperawatan1b', $diagnosa_masalahkeperawatan);
                $this->db->bind('namauserx1b', $namauserx);
                $this->db->execute();
            }

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function getDataMasalahKeperawatan($data)
    {
        try {
            $noreg = $data['noreg_pasien'];
            $query = "SELECT ID, No_DP,Diagnosa_Keperawatan FROM EMR.dbo.OutpatientMasalahKeperawatan WHERE No_Registrasi = :noreg AND Batal = '0'";
            $this->db->query($query);
            $this->db->bind('noreg', $noreg);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['ID'] = $key['ID'];
                $pasing['No_DP'] = $key['No_DP'];
                $pasing['Diagnosa_Keperawatan'] = $key['Diagnosa_Keperawatan'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDataCPPT($data)
    {
        try {
            $noreg = $data['noreg_pasien'];
            $query = "SELECT a.ID, a.No_DP,a.S,a.O,a.A,a.P,  b.[First Name] User_Input,a.Date_Input,
            c.[First Name] as User_Update,a.Date_Update,
            IsRead,
            d.[First Name] as  User_Read, Date_Read,a.User_Input as User_InputID
            FROM EMR.dbo.Soap a 
            inner join MasterdataSQL.dbo.Employees b
            on a.User_Input collate Latin1_General_CI_AS = b.NoPIN collate Latin1_General_CI_AS
            left join MasterdataSQL.dbo.Employees c
            on a.User_Update collate Latin1_General_CI_AS = c.NoPIN collate Latin1_General_CI_AS
            left join MasterdataSQL.dbo.Employees D
            on a.User_Read collate Latin1_General_CI_AS = D.NoPIN collate Latin1_General_CI_AS
            WHERE a.No_Registrasi = :noreg AND a.Batal = '0' order by a.ID DESC";
            $this->db->query($query);
            $this->db->bind('noreg', $noreg);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['ID'] = $key['ID'];
                $pasing['No_DP'] = $key['No_DP'];
                $pasing['S'] = $key['S'];
                $pasing['O'] = $key['O'];
                $pasing['A'] = $key['A'];
                $pasing['P'] = $key['P'];
                $pasing['User_Input'] = $key['User_Input'];
                $pasing['User_InputID'] = $key['User_InputID'];
                $pasing['Date_Input'] = $key['Date_Input'];
                $pasing['User_Update'] = $key['User_Update'];
                $pasing['Date_Update'] = $key['Date_Update'];
                $pasing['IsRead'] = $key['IsRead'];
                $pasing['User_Read'] = $key['User_Read'];
                $pasing['Date_Read'] = $key['Date_Read'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function setSaveCPPT($data)
    {
        try {
            $this->db->transaksi();
            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            // DATA MASALAH KEPERAWATAN
            $emr_id_cppt = $data['emr_id_cppt'];
            $nodp_masalahkeperawatan = $data['emr_nodp_cppt'];
            $emr_noreg_cppt = $data['emr_noreg_cppt'];
            $emr_mr_cppt = $data['emr_mr_cppt'];
            $emr_cppt_s = $data['emr_cppt_s'];
            $emr_cppt_o = $data['emr_cppt_o'];
            $emr_cppt_a = $data['emr_cppt_a'];
            $emr_cppt_p = $data['emr_cppt_p'];
            $xuserentry = $data['userentry'];
            //CEK DATA

            if ($emr_id_cppt == "") {
                //GENERATE DATA MASALAH KEPERAWATAN
                $a = 1;
                $this->db->query("SELECT COUNT(ID) urutan FROM EMR.dbo.Soap 
                WHERE No_Registrasi = :noreg_pasien");
                $this->db->bind('noreg_pasien', $emr_noreg_cppt);
                $datamasalahkeperawatan =  $this->db->single();
                $cekmasalahkeperawatan = (int)$datamasalahkeperawatan['urutan'];
                $cekmasalahkeperawatantambah = $cekmasalahkeperawatan + $a;
                $cekmasalahkeperawatantambahfix = Utils::generateAutoNumber($cekmasalahkeperawatantambah);
                $nodp_masalahkeperawatan_insert = $emr_noreg_cppt . '-' . $cekmasalahkeperawatantambahfix;

                $this->db->query("INSERT INTO EMR.dbo.Soap 
                (No_DP,S,O,A,P,
                [No_RM],[No_Registrasi],User_Input,Date_Input)
                VALUES (:nodp_masalah1a,:emr_cppt_s,:emr_cppt_o,:emr_cppt_a,:emr_cppt_p,
                :mr_masalah1a,:noreg_masalah1a,:namauserx1a,:Date_Input)");
                $this->db->bind('nodp_masalah1a', $nodp_masalahkeperawatan_insert);
                $this->db->bind('noreg_masalah1a', $emr_noreg_cppt);
                $this->db->bind('mr_masalah1a', $emr_mr_cppt);
                $this->db->bind('emr_cppt_s', $emr_cppt_s);
                $this->db->bind('emr_cppt_o', $emr_cppt_o);
                $this->db->bind('emr_cppt_a', $emr_cppt_a);
                $this->db->bind('emr_cppt_p', $emr_cppt_p);
                $this->db->bind('namauserx1a', $userid);
                $this->db->bind('Date_Input', $datenowcreate);
                $this->db->execute();
            } else {
                if ($xuserentry <> $userid) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'SOAP ini di entri Oleh User Lain. Anda tidak Dapat Melakukan Edit !',
                    );
                    return $callback;
                    exit;
                }
                $this->db->query("UPDATE EMR.dbo.Soap SET 
                    S = :emr_cppt_s, 
                    O = :emr_cppt_o, 
                    A = :emr_cppt_a, 
                    P = :emr_cppt_p, 
                    User_Update= :namauserx1b,
                    Date_Update= :Date_Input 
                    
                    WHERE ID = :emr_id_cppt1b AND No_DP = :nodp_masalahkeperawatan1b");
                $this->db->bind('emr_id_cppt1b', $emr_id_cppt);
                $this->db->bind('nodp_masalahkeperawatan1b', $nodp_masalahkeperawatan);
                $this->db->bind('emr_cppt_s', $emr_cppt_s);
                $this->db->bind('emr_cppt_o', $emr_cppt_o);
                $this->db->bind('emr_cppt_a', $emr_cppt_a);
                $this->db->bind('emr_cppt_p', $emr_cppt_p);
                $this->db->bind('namauserx1b', $userid);
                $this->db->bind('Date_Input', $datenowcreate);
                $this->db->execute();
            }

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function setBatalMasalahKeperawatan($data)
    {
        try {
            $this->db->transaksi();

            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            // DATA MASALAH KEPERAWAWATAN
            $idbtn = $data['idbtn'];
            $labiddtl = implode(',', $data['idmasalahkeperawatan']);
            $countlabiddtl = count($data['idmasalahkeperawatan']);

            $this->db->query("UPDATE EMR.dbo.OutpatientMasalahKeperawatan SET Batal = '1', User_UpdateOrBatal = :namauserx WHERE ID IN ($labiddtl)");
            $this->db->bind('namauserx', $namauserx);
            $this->db->execute();

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function setBatalCPPT($data)
    {
        try {
            $this->db->transaksi();

            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            // DATA MASALAH KEPERAWAWATAN
            $idbtn = $data['idbtn'];
            $labiddtl = implode(',', $data['idcppt']);
            $countlabiddtl = count($data['idcppt']);


            $this->db->query("SELECT User_Input FROM  EMR.dbo.Soap 
            WHERE ID=:idccpt ");
            $this->db->bind('idccpt', $labiddtl);
            $datacppts =  $this->db->single();
            if ($datacppts) {
                if ($userid <> $datacppts['User_Input']) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'SOAP ini di entri Oleh User Lain. Anda tidak Dapat Melakukan Edit !',
                    );
                    return $callback;
                    exit;
                }
            } else {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Data Tidak ditemukan !',
                );
                return $callback;
                exit;
            }



            $this->db->query("UPDATE EMR.dbo.Soap SET Batal = '1', User_Cancel = :namauserx, Date_Cancel = :Date_Cancel WHERE ID IN ($labiddtl)");
            $this->db->bind('namauserx', $namauserx);
            $this->db->bind('Date_Cancel', $datenowcreate);
            $this->db->execute();

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    //RESUME MEDIS
    public function setSaveResume($data)
    {
        try {
            $this->db->transaksi();
            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            // DATA PASIEN
            $noreg_pasien = $data['noreg_pasien'];
            $mr_pasien = $data['mr_pasien'];

            $sembuh = $data['sembuh'];
            $pulang = $data['pulang'];
            $emr_alasandatang = $data['emr_alasandatang'];
            $emr_bedah = $data['emr_bedah'];
            $emr_nonbedah = $data['emr_nonbedah'];
            $emr_nonbedahlainnya = $data['emr_nonbedahlainnya'];
            $emr_anamnesissingkat = $data['emr_anamnesissingkat'];
            $emr_pemeriksaan = $data['emr_pemeriksaan'];
            $emr_tensi = $data['emr_tensi'];
            if ($emr_tensi == '') {
                $emr_tensi = 0;
            }
            $emr_suhu = $data['emr_suhu'];
            if ($emr_suhu == '') {
                $emr_suhu = 0;
            }
            $emr_nadi = $data['emr_nadi'];
            if ($emr_nadi == '') {
                $emr_nadi = 0;
            }
            $emr_nafas = $data['emr_nafas'];
            if ($emr_nafas == '') {
                $emr_nafas = 0;
            }
            $emr_bb = $data['emr_bb'];
            if ($emr_bb == '') {
                $emr_bb = 0;
            }
            $emr_tb = $data['emr_tb'];
            if ($emr_tb == '') {
                $emr_tb = 0;
            }
            $emr_laboratorium = $data['emr_laboratorium'];
            $emr_radiologi = $data['emr_radiologi'];
            $emr_pemeriksaanlainnya = $data['emr_pemeriksaanlainnya'];
            $emr_tindakan = $data['emr_tindakan'];
            $emr_diagnosisakhir = $data['emr_diagnosisakhir'];
            $emr_kategorikasus = $data['emr_kategorikasus'];
            $emr_dipulangkanuntuk = $data['emr_dipulangkanuntuk'];
            $emr_dirurukke = $data['emr_dirurukke'];
            $emr_atasdasar = $data['emr_atasdasar'];


            //CEK DATA
            $this->db->query("SELECT COUNT(ID) cekOutpatientResumeMedis FROM EMR.dbo.OutpatientResumeMedis WHERE No_Registrasi = :noreg_pasien");
            $this->db->bind('noreg_pasien', $noreg_pasien);
            $dataResume =  $this->db->single();
            $cekResume = $dataResume['cekOutpatientResumeMedis'];

            if ($cekResume == "0") {

                $this->db->query("INSERT INTO EMR.dbo.OutpatientResumeMedis([Bedah] ,[Non_Bedah] ,[Non_Bedah_Lainnya] ,[Anamnesis_Singkat] ,[Keadaan_Umum] ,[Tensi] ,[Suhu] ,[Nadi] ,[Nafas] ,[BB] ,[TB] ,[Laboratorium] ,[Radiologi] ,[Pemeriksaan_Lainnya] ,[Terapi] ,[Diagnosis_Akhir] ,[Kategori_Kasus] ,[Sembuh] ,[Dipulangkan] ,[Alasan_Dipulangkan] ,[Dirujuk] ,[Atas_Dasar] ,[No_RM] ,[No_Registrasi] ,[User_Input] ,[Alasan_Datang] 
                )
                VALUES (:emr_bedah1a,:emr_nonbedah1a,:emr_nonbedahlainnya1a,:emr_anamnesissingkat1a,:emr_pemeriksaan1a,:emr_tensi1a,:emr_suhu1a,:emr_nadi1a,:emr_nafas1a,:emr_bb1a,:emr_tb1a,:emr_laboratorium1a,:emr_radiologi1a,:emr_pemeriksaanlainnya1a,:emr_tindakan1a,:emr_diagnosisakhir1a,:emr_kategorikasus1a,:sembuh1a,:pulang1a,:emr_dipulangkanuntuk1a,:emr_dirurukke1a,:emr_atasdasar1a,:mr_pasien1a,:noreg_pasien1a,:namauserx1a,:emr_alasandatang1a)");
                $this->db->bind('emr_bedah1a', $emr_bedah);
                $this->db->bind('emr_nonbedah1a', $emr_nonbedah);
                $this->db->bind('emr_nonbedahlainnya1a', $emr_nonbedahlainnya);
                $this->db->bind('emr_anamnesissingkat1a', $emr_anamnesissingkat);
                $this->db->bind('emr_pemeriksaan1a', $emr_pemeriksaan);
                $this->db->bind('emr_tensi1a', $emr_tensi);
                $this->db->bind('emr_suhu1a', $emr_suhu);
                $this->db->bind('emr_nadi1a', $emr_nadi);
                $this->db->bind('emr_nafas1a', $emr_nafas);
                $this->db->bind('emr_bb1a', $emr_bb);
                $this->db->bind('emr_tb1a', $emr_tb);
                $this->db->bind('emr_laboratorium1a', $emr_laboratorium);
                $this->db->bind('emr_radiologi1a', $emr_radiologi);
                $this->db->bind('emr_pemeriksaanlainnya1a', $emr_pemeriksaanlainnya);
                $this->db->bind('emr_tindakan1a', $emr_tindakan);
                $this->db->bind('emr_diagnosisakhir1a', $emr_diagnosisakhir);
                $this->db->bind('emr_kategorikasus1a', $emr_kategorikasus);
                $this->db->bind('sembuh1a', $sembuh);
                $this->db->bind('pulang1a', $pulang);
                $this->db->bind('emr_dipulangkanuntuk1a', $emr_dipulangkanuntuk);
                $this->db->bind('emr_dirurukke1a', $emr_dirurukke);
                $this->db->bind('emr_atasdasar1a', $emr_atasdasar);
                $this->db->bind('mr_pasien1a', $mr_pasien);
                $this->db->bind('noreg_pasien1a', $noreg_pasien);
                $this->db->bind('namauserx1a', $namauserx);
                $this->db->bind('emr_alasandatang1a', $emr_alasandatang);
                $this->db->execute();
            } else {

                $this->db->query("UPDATE EMR.dbo.OutpatientResumeMedis SET Bedah = :emr_bedah1b,Non_Bedah = :emr_nonbedah1b,Non_Bedah_Lainnya = :emr_nonbedahlainnya1b,Anamnesis_Singkat = :emr_anamnesissingkat1b,Keadaan_Umum = :emr_pemeriksaan1b,Tensi = :emr_tensi1b,Suhu = :emr_suhu1b,Nadi = :emr_nadi1b,Nafas = :emr_nafas1b,BB = :emr_bb1b,TB = :emr_tb1b,Laboratorium = :emr_laboratorium1b,Radiologi = :emr_radiologi1b,Pemeriksaan_Lainnya = :emr_pemeriksaanlainnya1b,Terapi = :emr_tindakan1b,Diagnosis_Akhir = :emr_diagnosisakhir1b,Kategori_Kasus = :emr_kategorikasus1b,Sembuh = :sembuh1b,Dipulangkan = :pulang1b,Alasan_Dipulangkan = :emr_dipulangkanuntuk1b,Dirujuk = :emr_dirurukke1b,Atas_Dasar = :emr_atasdasar1b,User_Input = :namauserx1b,Alasan_Datang = :emr_alasandatang1b
                WHERE No_Registrasi = :noreg_pasien1b");
                $this->db->bind('noreg_pasien1b', $noreg_pasien);
                $this->db->bind('emr_bedah1b', $emr_bedah);
                $this->db->bind('emr_nonbedah1b', $emr_nonbedah);
                $this->db->bind('emr_nonbedahlainnya1b', $emr_nonbedahlainnya);
                $this->db->bind('emr_anamnesissingkat1b', $emr_anamnesissingkat);
                $this->db->bind('emr_pemeriksaan1b', $emr_pemeriksaan);
                $this->db->bind('emr_tensi1b', $emr_tensi);
                $this->db->bind('emr_suhu1b', $emr_suhu);
                $this->db->bind('emr_nadi1b', $emr_nadi);
                $this->db->bind('emr_nafas1b', $emr_nafas);
                $this->db->bind('emr_bb1b', $emr_bb);
                $this->db->bind('emr_tb1b', $emr_tb);
                $this->db->bind('emr_laboratorium1b', $emr_laboratorium);
                $this->db->bind('emr_radiologi1b', $emr_radiologi);
                $this->db->bind('emr_pemeriksaanlainnya1b', $emr_pemeriksaanlainnya);
                $this->db->bind('emr_tindakan1b', $emr_tindakan);
                $this->db->bind('emr_diagnosisakhir1b', $emr_diagnosisakhir);
                $this->db->bind('emr_kategorikasus1b', $emr_kategorikasus);
                $this->db->bind('sembuh1b', $sembuh);
                $this->db->bind('pulang1b', $pulang);
                $this->db->bind('emr_dipulangkanuntuk1b', $emr_dipulangkanuntuk);
                $this->db->bind('emr_dirurukke1b', $emr_dirurukke);
                $this->db->bind('emr_atasdasar1b', $emr_atasdasar);
                $this->db->bind('namauserx1b', $namauserx);
                $this->db->bind('emr_alasandatang1b', $emr_alasandatang);
                $this->db->execute();
            }

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Resume Medis Berhasi',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function getResumePasien($data)
    {
        try {
            $noregistrasi = $data['NoRegistrasi'];
            $this->db->query("SELECT * FROM EMR.dbo.OutpatientResumeMedis WHERE No_Registrasi = :noreg1");
            $this->db->bind('noreg1', $noregistrasi);
            $key =  $this->db->single();
            $pasing['ID'] = $key['ID'];
            $pasing['Bedah'] = $key['Bedah'];
            $pasing['Non_Bedah'] = $key['Non_Bedah'];
            $pasing['Non_Bedah_Lainnya'] = $key['Non_Bedah_Lainnya'];
            $pasing['Anamnesis_Singkat'] = $key['Anamnesis_Singkat'];
            $pasing['Keadaan_Umum'] = $key['Keadaan_Umum'];
            $pasing['Tensi'] = $key['Tensi'];
            $pasing['Suhu'] = $key['Suhu'];
            $pasing['Nadi'] = $key['Nadi'];
            $pasing['Nafas'] = $key['Nafas'];
            $pasing['BB'] = $key['BB'];
            $pasing['TB'] = $key['TB'];
            $pasing['Laboratorium'] = $key['Laboratorium'];
            $pasing['Radiologi'] = $key['Radiologi'];
            $pasing['Pemeriksaan_Lainnya'] = $key['Pemeriksaan_Lainnya'];
            $pasing['Terapi'] = $key['Terapi'];
            $pasing['Diagnosis_Akhir'] = $key['Diagnosis_Akhir'];
            $pasing['Kategori_Kasus'] = $key['Kategori_Kasus'];
            $pasing['Sembuh'] = $key['Sembuh'];
            $pasing['Dipulangkan'] = $key['Dipulangkan'];
            $pasing['Alasan_Dipulangkan'] = $key['Alasan_Dipulangkan'];
            $pasing['Dirujuk'] = $key['Dirujuk'];
            $pasing['Atas_Dasar'] = $key['Atas_Dasar'];
            $pasing['No_RM'] = $key['No_RM'];
            $pasing['No_Registrasi'] = $key['No_Registrasi'];
            $pasing['User_Input'] = $key['User_Input'];
            $pasing['Alasan_Datang'] = $key['Alasan_Datang'];
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    //SURAT KETERANGAN SAKIT
    public function setSaveSuket($data)
    {
        try {
            $this->db->transaksi();
            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            // DATA PASIEN
            $noreg_pasien = $data['noreg_pasien'];
            $mr_pasien = $data['mr_pasien'];

            $emer_tglistirahat = $data['emer_tglistirahat'];
            $emr_diagnosa = $data['emr_diagnosa'];
            $emr_kontrolulang = $data['emr_kontrolulang'];
            $emr_tanggalsaatini = $data['emr_tanggalsaatini'];
            $emr_dokter = $data['emr_dokter'];


            //CEK DATA
            $this->db->query("SELECT COUNT(ID) cekOutpatientSuratKeteranganSakit FROM EMR.dbo.OutpatientSuratKeteranganSakit WHERE No_Registrasi = :noreg_pasien");
            $this->db->bind('noreg_pasien', $noreg_pasien);
            $dataSuket =  $this->db->single();
            $cekSuket = $dataSuket['cekOutpatientSuratKeteranganSakit'];

            if ($cekSuket == "0") {

                $this->db->query("INSERT INTO EMR.dbo.OutpatientSuratKeteranganSakit([Tanggal_Istirahat],[Diagnosa],[Tanggal_Kontrol],[Tanggal_Sekarang],[Dokter],[No_RM],[No_Registrasi],[User_Input]
                )
                VALUES (:emer_tglistirahat1a,:emr_diagnosa1a,:emr_kontrolulang1a,:emr_tanggalsaatini1a,:emr_dokter1a,:mr_pasien1a,:noreg_pasien1a,:namauserx1a)");
                $this->db->bind('emer_tglistirahat1a', $emer_tglistirahat);
                $this->db->bind('emr_diagnosa1a', $emr_diagnosa);
                $this->db->bind('emr_kontrolulang1a', $emr_kontrolulang);
                $this->db->bind('emr_tanggalsaatini1a', $emr_tanggalsaatini);
                $this->db->bind('emr_dokter1a', $emr_dokter);
                $this->db->bind('mr_pasien1a', $mr_pasien);
                $this->db->bind('noreg_pasien1a', $noreg_pasien);
                $this->db->bind('namauserx1a', $namauserx);
                $this->db->execute();
            } else {

                $this->db->query("UPDATE EMR.dbo.OutpatientSuratKeteranganSakit SET Tanggal_Istirahat = :emer_tglistirahat1b,Diagnosa = :emr_diagnosa1b,Tanggal_Kontrol = :emr_kontrolulang1b,Tanggal_Sekarang = :emr_tanggalsaatini1b,Dokter = :emr_dokter1b,User_Input = :namauserx1b
                WHERE No_Registrasi = :noreg_pasien1b");
                $this->db->bind('emer_tglistirahat1b', $emer_tglistirahat);
                $this->db->bind('emr_diagnosa1b', $emr_diagnosa);
                $this->db->bind('emr_kontrolulang1b', $emr_kontrolulang);
                $this->db->bind('emr_tanggalsaatini1b', $emr_tanggalsaatini);
                $this->db->bind('emr_dokter1b', $emr_dokter);
                $this->db->bind('noreg_pasien1b', $noreg_pasien);
                $this->db->bind('namauserx1b', $namauserx);
                $this->db->execute();
            }

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Surat Keterangan Sakit Berhasi',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function getSuratKeteranganSakit($data)
    {
        try {
            $noregistrasi = $data['NoRegistrasi'];
            $this->db->query("SELECT * FROM EMR.dbo.OutpatientSuratKeteranganSakit WHERE No_Registrasi = :noreg1");
            $this->db->bind('noreg1', $noregistrasi);
            $key =  $this->db->single();
            $pasing['ID'] = $key['ID'];
            $pasing['Tanggal_Istirahat'] = $key['Tanggal_Istirahat'];
            $pasing['Diagnosa'] = $key['Diagnosa'];
            $pasing['Tanggal_Kontrol'] = $key['Tanggal_Kontrol'];
            $pasing['Tanggal_Sekarang'] = $key['Tanggal_Sekarang'];
            $pasing['Dokter'] = $key['Dokter'];
            $pasing['No_RM'] = $key['No_RM'];
            $pasing['No_Registrasi'] = $key['No_Registrasi'];
            $pasing['User_Input'] = $key['User_Input'];

            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    //FORM EDUKASI
    public function setFormEdukasi($data)
    {
        try {
            // var_dump($data);
            // exit;
            $this->db->transaksi();
            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            // DATA PASIEN
            $noreg_pasien = $data['noreg_pasien'];
            $mr_pasien = $data['mr_pasien'];

            $emr_tambahanmateridokter = $data['emr_tambahanmateridokter'];
            $emr_tglmateridokter = $data['emr_tglmateridokter'];
            $emr_metodemateridokter = $data['emr_metodemateridokter'];
            $emr_evaluasimateridokter = $data['emr_evaluasimateridokter'];
            $emr_edukatormateridokter = $data['emr_edukatormateridokter'];
            $emr_penerimamateridokter = $data['emr_penerimamateridokter'];
            $emr_tambahanmaterinutrisi = $data['emr_tambahanmaterinutrisi'];
            $emr_tglmaterinutrisi = $data['emr_tglmaterinutrisi'];
            $emr_metodematerinutrisi = $data['emr_metodematerinutrisi'];
            $emr_evaluasimaterinutrisi = $data['emr_evaluasimaterinutrisi'];
            $emr_edukatormaterinutrisi = $data['emr_edukatormaterinutrisi'];
            $emr_penerimamaterinutrisi = $data['emr_penerimamaterinutrisi'];
            $emr_tglmaterinyeri = $data['emr_tglmaterinyeri'];
            $emr_metodematerinyeri = $data['emr_metodematerinyeri'];
            $emr_evaluasimaterinyeri = $data['emr_evaluasimaterinyeri'];
            $emr_edukatormaterinyeri = $data['emr_edukatormaterinyeri'];
            $emr_penerimamaterinyeri = $data['emr_penerimamaterinyeri'];
            $emr_tambahanmaterifarmasi = $data['emr_tambahanmaterifarmasi'];
            $emr_tglmaterifarmasi = $data['emr_tglmaterifarmasi'];
            $emr_metodematerifarmasi = $data['emr_metodematerifarmasi'];
            $emr_evaluasimaterifarmasi = $data['emr_evaluasimaterifarmasi'];
            $emr_edukatormaterifarmasi = $data['emr_edukatormaterifarmasi'];
            $emr_penerimamaterifarmasi = $data['emr_penerimamaterifarmasi'];
            $emr_tentangmateriperawat = $data['emr_tentangmateriperawat'];
            $emr_tambahanmateriperawat = $data['emr_tambahanmateriperawat'];
            $emr_tglmateriperawat = $data['emr_tglmateriperawat'];
            $emr_metodemateriperawat = $data['emr_metodemateriperawat'];
            $emr_evaluasimateriperawat = $data['emr_evaluasimateriperawat'];
            $emr_edukatormateriperawat = $data['emr_edukatormateriperawat'];
            $emr_penerimamateriperawat = $data['emr_penerimamateriperawat'];
            $emr_tglmateriisolasi = $data['emr_tglmateriisolasi'];
            $emr_metodemateriisolasi = $data['emr_metodemateriisolasi'];
            $emr_evaluasimateriisolasi = $data['emr_evaluasimateriisolasi'];
            $emr_edukatormateriisolasi = $data['emr_edukatormateriisolasi'];
            $emr_penerimamateriisolasi = $data['emr_penerimamateriisolasi'];


            //CEK DATA
            $this->db->query("SELECT COUNT(ID) cekOutpatientFormEdukasi FROM EMR.dbo.OutpatientFormEdukasi WHERE No_Registrasi = :noreg_pasien");
            $this->db->bind('noreg_pasien', $noreg_pasien);
            $dataFormEdukasi =  $this->db->single();
            $cekformedukasi = $dataFormEdukasi['cekOutpatientFormEdukasi'];

            if ($cekformedukasi == "0") {

                $this->db->query("INSERT INTO EMR.dbo.OutpatientFormEdukasi(
[Tambahan_Materi_Dokter],
[Tgl_Materi_Dokter],
[Metode_Materi_Dokter],
[Evaluasi_Materi_Dokter],
[Edukator_Materi_Dokter],
[Penerima_Materi_Dokter],
[Tambahan_Materi_Nutrisi],
[Tgl_Materi_Nutrisi],
[Metode_Materi_Nutrisi],
[Evaluasi_Materi_Nutrisi],
[Edukator_Materi_Nutrisi],
[Penerima_Materi_Nutrisi],
[Tgl_Materi_Nyeri],
[Metode_Materi_Nyeri],
[Evaluasi_Materi_Nyeri],
[Edukator_Materi_Nyeri],
[Penerima_Materi_Nyeri],
[Tambahan_Materi_Farmasi],
[Tgl_Materi_Farmasi],
[Metode_Materi_Farmasi],
[Evaluasi_Materi_Farmasi],
[Edukator_Materi_Farmasi],
[Penerima_Materi_Farmasi],
[Tentang_Materi_Perawat],
[Tambahan_Materi_Perawat],
[Tgl_Materi_Perawat],
[Metode_Materi_Perawat],
[Evaluasi_Materi_Perawat],
[Edukator_Materi_Perawat],
[Penerima_Materi_Perawat],
[Tgl_Materi_Isolasi],
[Metode_Materi_Isolasi],
[Evaluasi_Materi_Isolasi],
[Edukator_Materi_Isolasi],
[Penerima_Materi_Isolasi],
[No_RM],
[No_Registrasi],
[User_Input]
                )
                VALUES (
:emr_tambahanmateridokter1a,
:emr_tglmateridokter1a,
:emr_metodemateridokter1a,
:emr_evaluasimateridokter1a,
:emr_edukatormateridokter1a,
:emr_penerimamateridokter1a,
:emr_tambahanmaterinutrisi1a,
:emr_tglmaterinutrisi1a,
:emr_metodematerinutrisi1a,
:emr_evaluasimaterinutrisi1a,
:emr_edukatormaterinutrisi1a,
:emr_penerimamaterinutrisi1a,
:emr_tglmaterinyeri1a,
:emr_metodematerinyeri1a,
:emr_evaluasimaterinyeri1a,
:emr_edukatormaterinyeri1a,
:emr_penerimamaterinyeri1a,
:emr_tambahanmaterifarmasi1a,
:emr_tglmaterifarmasi1a,
:emr_metodematerifarmasi1a,
:emr_evaluasimaterifarmasi1a,
:emr_edukatormaterifarmasi1a,
:emr_penerimamaterifarmasi1a,
:emr_tentangmateriperawat1a,
:emr_tambahanmateriperawat1a,
:emr_tglmateriperawat1a,
:emr_metodemateriperawat1a,
:emr_evaluasimateriperawat1a,
:emr_edukatormateriperawat1a,
:emr_penerimamateriperawat1a,
:emr_tglmateriisolasi1a,
:emr_metodemateriisolasi1a,
:emr_evaluasimateriisolasi1a,
:emr_edukatormateriisolasi1a,
:emr_penerimamateriisolasi1a,
:mr_pasien1a,
:noreg_pasien1a,
:namauserx1a
                )");
                $this->db->bind('emr_tambahanmateridokter1a', $emr_tambahanmateridokter);
                $this->db->bind('emr_tglmateridokter1a', $emr_tglmateridokter);
                $this->db->bind('emr_metodemateridokter1a', $emr_metodemateridokter);
                $this->db->bind('emr_evaluasimateridokter1a', $emr_evaluasimateridokter);
                $this->db->bind('emr_edukatormateridokter1a', $emr_edukatormateridokter);
                $this->db->bind('emr_penerimamateridokter1a', $emr_penerimamateridokter);
                $this->db->bind('emr_tambahanmaterinutrisi1a', $emr_tambahanmaterinutrisi);
                $this->db->bind('emr_tglmaterinutrisi1a', $emr_tglmaterinutrisi);
                $this->db->bind('emr_metodematerinutrisi1a', $emr_metodematerinutrisi);
                $this->db->bind('emr_evaluasimaterinutrisi1a', $emr_evaluasimaterinutrisi);
                $this->db->bind('emr_edukatormaterinutrisi1a', $emr_edukatormaterinutrisi);
                $this->db->bind('emr_penerimamaterinutrisi1a', $emr_penerimamaterinutrisi);
                $this->db->bind('emr_tglmaterinyeri1a', $emr_tglmaterinyeri);
                $this->db->bind('emr_metodematerinyeri1a', $emr_metodematerinyeri);
                $this->db->bind('emr_evaluasimaterinyeri1a', $emr_evaluasimaterinyeri);
                $this->db->bind('emr_edukatormaterinyeri1a', $emr_edukatormaterinyeri);
                $this->db->bind('emr_penerimamaterinyeri1a', $emr_penerimamaterinyeri);
                $this->db->bind('emr_tambahanmaterifarmasi1a', $emr_tambahanmaterifarmasi);
                $this->db->bind('emr_tglmaterifarmasi1a', $emr_tglmaterifarmasi);
                $this->db->bind('emr_metodematerifarmasi1a', $emr_metodematerifarmasi);
                $this->db->bind('emr_evaluasimaterifarmasi1a', $emr_evaluasimaterifarmasi);
                $this->db->bind('emr_edukatormaterifarmasi1a', $emr_edukatormaterifarmasi);
                $this->db->bind('emr_penerimamaterifarmasi1a', $emr_penerimamaterifarmasi);
                $this->db->bind('emr_tentangmateriperawat1a', $emr_tentangmateriperawat);
                $this->db->bind('emr_tambahanmateriperawat1a', $emr_tambahanmateriperawat);
                $this->db->bind('emr_tglmateriperawat1a', $emr_tglmateriperawat);
                $this->db->bind('emr_metodemateriperawat1a', $emr_metodemateriperawat);
                $this->db->bind('emr_evaluasimateriperawat1a', $emr_evaluasimateriperawat);
                $this->db->bind('emr_edukatormateriperawat1a', $emr_edukatormateriperawat);
                $this->db->bind('emr_penerimamateriperawat1a', $emr_penerimamateriperawat);
                $this->db->bind('emr_tglmateriisolasi1a', $emr_tglmateriisolasi);
                $this->db->bind('emr_metodemateriisolasi1a', $emr_metodemateriisolasi);
                $this->db->bind('emr_evaluasimateriisolasi1a', $emr_evaluasimateriisolasi);
                $this->db->bind('emr_edukatormateriisolasi1a', $emr_edukatormateriisolasi);
                $this->db->bind('emr_penerimamateriisolasi1a', $emr_penerimamateriisolasi);
                $this->db->bind('mr_pasien1a', $mr_pasien);
                $this->db->bind('noreg_pasien1a', $noreg_pasien);
                $this->db->bind('namauserx1a', $namauserx);
                $this->db->execute();
            } else {

                $this->db->query("UPDATE EMR.dbo.OutpatientFormEdukasi SET 
Tambahan_Materi_Dokter = :emr_tambahanmateridokter1b,
Tgl_Materi_Dokter = :emr_tglmateridokter1b,
Metode_Materi_Dokter = :emr_metodemateridokter1b,
Evaluasi_Materi_Dokter = :emr_evaluasimateridokter1b,
Edukator_Materi_Dokter = :emr_edukatormateridokter1b,
Penerima_Materi_Dokter = :emr_penerimamateridokter1b,
Tambahan_Materi_Nutrisi = :emr_tambahanmaterinutrisi1b,
Tgl_Materi_Nutrisi = :emr_tglmaterinutrisi1b,
Metode_Materi_Nutrisi = :emr_metodematerinutrisi1b,
Evaluasi_Materi_Nutrisi = :emr_evaluasimaterinutrisi1b,
Edukator_Materi_Nutrisi = :emr_edukatormaterinutrisi1b,
Penerima_Materi_Nutrisi = :emr_penerimamaterinutrisi1b,
Tgl_Materi_Nyeri = :emr_tglmaterinyeri1b,
Metode_Materi_Nyeri = :emr_metodematerinyeri1b,
Evaluasi_Materi_Nyeri = :emr_evaluasimaterinyeri1b,
Edukator_Materi_Nyeri = :emr_edukatormaterinyeri1b,
Penerima_Materi_Nyeri = :emr_penerimamaterinyeri1b,
Tambahan_Materi_Farmasi = :emr_tambahanmaterifarmasi1b,
Tgl_Materi_Farmasi = :emr_tglmaterifarmasi1b,
Metode_Materi_Farmasi = :emr_metodematerifarmasi1b,
Evaluasi_Materi_Farmasi = :emr_evaluasimaterifarmasi1b,
Edukator_Materi_Farmasi = :emr_edukatormaterifarmasi1b,
Penerima_Materi_Farmasi = :emr_penerimamaterifarmasi1b,
Tentang_Materi_Perawat = :emr_tentangmateriperawat1b,
Tambahan_Materi_Perawat = :emr_tambahanmateriperawat1b,
Tgl_Materi_Perawat = :emr_tglmateriperawat1b,
Metode_Materi_Perawat = :emr_metodemateriperawat1b,
Evaluasi_Materi_Perawat = :emr_evaluasimateriperawat1b,
Edukator_Materi_Perawat = :emr_edukatormateriperawat1b,
Penerima_Materi_Perawat = :emr_penerimamateriperawat1b,
Tgl_Materi_Isolasi = :emr_tglmateriisolasi1b,
Metode_Materi_Isolasi = :emr_metodemateriisolasi1b,
Evaluasi_Materi_Isolasi = :emr_evaluasimateriisolasi1b,
Edukator_Materi_Isolasi = :emr_edukatormateriisolasi1b,
Penerima_Materi_Isolasi = :emr_penerimamateriisolasi1b
                WHERE No_Registrasi = :noreg_pasien1b");
                $this->db->bind('emr_tambahanmateridokter1b', $emr_tambahanmateridokter);
                $this->db->bind('emr_tglmateridokter1b', $emr_tglmateridokter);
                $this->db->bind('emr_metodemateridokter1b', $emr_metodemateridokter);
                $this->db->bind('emr_evaluasimateridokter1b', $emr_evaluasimateridokter);
                $this->db->bind('emr_edukatormateridokter1b', $emr_edukatormateridokter);
                $this->db->bind('emr_penerimamateridokter1b', $emr_penerimamateridokter);
                $this->db->bind('emr_tambahanmaterinutrisi1b', $emr_tambahanmaterinutrisi);
                $this->db->bind('emr_tglmaterinutrisi1b', $emr_tglmaterinutrisi);
                $this->db->bind('emr_metodematerinutrisi1b', $emr_metodematerinutrisi);
                $this->db->bind('emr_evaluasimaterinutrisi1b', $emr_evaluasimaterinutrisi);
                $this->db->bind('emr_edukatormaterinutrisi1b', $emr_edukatormaterinutrisi);
                $this->db->bind('emr_penerimamaterinutrisi1b', $emr_penerimamaterinutrisi);
                $this->db->bind('emr_tglmaterinyeri1b', $emr_tglmaterinyeri);
                $this->db->bind('emr_metodematerinyeri1b', $emr_metodematerinyeri);
                $this->db->bind('emr_evaluasimaterinyeri1b', $emr_evaluasimaterinyeri);
                $this->db->bind('emr_edukatormaterinyeri1b', $emr_edukatormaterinyeri);
                $this->db->bind('emr_penerimamaterinyeri1b', $emr_penerimamaterinyeri);
                $this->db->bind('emr_tambahanmaterifarmasi1b', $emr_tambahanmaterifarmasi);
                $this->db->bind('emr_tglmaterifarmasi1b', $emr_tglmaterifarmasi);
                $this->db->bind('emr_metodematerifarmasi1b', $emr_metodematerifarmasi);
                $this->db->bind('emr_evaluasimaterifarmasi1b', $emr_evaluasimaterifarmasi);
                $this->db->bind('emr_edukatormaterifarmasi1b', $emr_edukatormaterifarmasi);
                $this->db->bind('emr_penerimamaterifarmasi1b', $emr_penerimamaterifarmasi);
                $this->db->bind('emr_tentangmateriperawat1b', $emr_tentangmateriperawat);
                $this->db->bind('emr_tambahanmateriperawat1b', $emr_tambahanmateriperawat);
                $this->db->bind('emr_tglmateriperawat1b', $emr_tglmateriperawat);
                $this->db->bind('emr_metodemateriperawat1b', $emr_metodemateriperawat);
                $this->db->bind('emr_evaluasimateriperawat1b', $emr_evaluasimateriperawat);
                $this->db->bind('emr_edukatormateriperawat1b', $emr_edukatormateriperawat);
                $this->db->bind('emr_penerimamateriperawat1b', $emr_penerimamateriperawat);
                $this->db->bind('emr_tglmateriisolasi1b', $emr_tglmateriisolasi);
                $this->db->bind('emr_metodemateriisolasi1b', $emr_metodemateriisolasi);
                $this->db->bind('emr_evaluasimateriisolasi1b', $emr_evaluasimateriisolasi);
                $this->db->bind('emr_edukatormateriisolasi1b', $emr_edukatormateriisolasi);
                $this->db->bind('emr_penerimamateriisolasi1b', $emr_penerimamateriisolasi);
                $this->db->bind('noreg_pasien1b', $noreg_pasien);
                $this->db->execute();
            }

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Form Edukasi Berhasi',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }


    public function getFormEdukasi($data)
    {
        try {
            $noregistrasi = $data['NoRegistrasi'];
            $this->db->query("SELECT * FROM EMR.dbo.OutpatientFormEdukasi WHERE No_Registrasi = :noreg1");
            $this->db->bind('noreg1', $noregistrasi);
            $key =  $this->db->single();
            $pasing['ID'] = $key['ID'];
            $pasing['Tambahan_Materi_Dokter'] = $key['Tambahan_Materi_Dokter'];
            $pasing['Tgl_Materi_Dokter'] = $key['Tgl_Materi_Dokter'];
            $pasing['Metode_Materi_Dokter'] = $key['Metode_Materi_Dokter'];
            $pasing['Evaluasi_Materi_Dokter'] = $key['Evaluasi_Materi_Dokter'];
            $pasing['Edukator_Materi_Dokter'] = $key['Edukator_Materi_Dokter'];
            $pasing['Penerima_Materi_Dokter'] = $key['Penerima_Materi_Dokter'];
            $pasing['Tambahan_Materi_Nutrisi'] = $key['Tambahan_Materi_Nutrisi'];
            $pasing['Tgl_Materi_Nutrisi'] = $key['Tgl_Materi_Nutrisi'];
            $pasing['Metode_Materi_Nutrisi'] = $key['Metode_Materi_Nutrisi'];
            $pasing['Evaluasi_Materi_Nutrisi'] = $key['Evaluasi_Materi_Nutrisi'];
            $pasing['Edukator_Materi_Nutrisi'] = $key['Edukator_Materi_Nutrisi'];
            $pasing['Penerima_Materi_Nutrisi'] = $key['Penerima_Materi_Nutrisi'];
            $pasing['Tgl_Materi_Nyeri'] = $key['Tgl_Materi_Nyeri'];
            $pasing['Metode_Materi_Nyeri'] = $key['Metode_Materi_Nyeri'];
            $pasing['Evaluasi_Materi_Nyeri'] = $key['Evaluasi_Materi_Nyeri'];
            $pasing['Edukator_Materi_Nyeri'] = $key['Edukator_Materi_Nyeri'];
            $pasing['Penerima_Materi_Nyeri'] = $key['Penerima_Materi_Nyeri'];
            $pasing['Tambahan_Materi_Farmasi'] = $key['Tambahan_Materi_Farmasi'];
            $pasing['Tgl_Materi_Farmasi'] = $key['Tgl_Materi_Farmasi'];
            $pasing['Metode_Materi_Farmasi'] = $key['Metode_Materi_Farmasi'];
            $pasing['Evaluasi_Materi_Farmasi'] = $key['Evaluasi_Materi_Farmasi'];
            $pasing['Edukator_Materi_Farmasi'] = $key['Edukator_Materi_Farmasi'];
            $pasing['Penerima_Materi_Farmasi'] = $key['Penerima_Materi_Farmasi'];
            $pasing['Tentang_Materi_Perawat'] = $key['Tentang_Materi_Perawat'];
            $pasing['Tambahan_Materi_Perawat'] = $key['Tambahan_Materi_Perawat'];
            $pasing['Tgl_Materi_Perawat'] = $key['Tgl_Materi_Perawat'];
            $pasing['Metode_Materi_Perawat'] = $key['Metode_Materi_Perawat'];
            $pasing['Evaluasi_Materi_Perawat'] = $key['Evaluasi_Materi_Perawat'];
            $pasing['Edukator_Materi_Perawat'] = $key['Edukator_Materi_Perawat'];
            $pasing['Penerima_Materi_Perawat'] = $key['Penerima_Materi_Perawat'];
            $pasing['Tgl_Materi_Isolasi'] = $key['Tgl_Materi_Isolasi'];
            $pasing['Metode_Materi_Isolasi'] = $key['Metode_Materi_Isolasi'];
            $pasing['Evaluasi_Materi_Isolasi'] = $key['Evaluasi_Materi_Isolasi'];
            $pasing['Edukator_Materi_Isolasi'] = $key['Edukator_Materi_Isolasi'];
            $pasing['Penerima_Materi_Isolasi'] = $key['Penerima_Materi_Isolasi'];

            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function setSaveEdukasiLanjutan($data)
    {
        try {
            $this->db->transaksi();
            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            // DATA PASIEN
            $emr_id_edukasilanjutan = $data['emr_id_edukasilanjutan'];
            $emr_mr_edukasilanjutan = $data['emr_mr_edukasilanjutan'];
            $emr_noreg_edukasilanjutan = $data['emr_noreg_edukasilanjutan'];
            $emr_tgl_edukasilanjutan = $data['emr_tgl_edukasilanjutan'];
            $emr_materi_edukasilanjutan = $data['emr_materi_edukasilanjutan'];
            $emr_penerima_edukasilanjutan = $data['emr_penerima_edukasilanjutan'];
            $emr_edukator_edukasilanjutan = $data['emr_edukator_edukasilanjutan'];
            $emr_evaluasi_edukasilanjutan = $data['emr_evaluasi_edukasilanjutan'];


            //CEK DATA
            $this->db->query("SELECT COUNT(ID) cekOutpatientEdukasiLanjutan FROM EMR.dbo.OutpatientEdukasiLanjutan WHERE No_Registrasi = :noreg_pasien");
            $this->db->bind('noreg_pasien', $emr_noreg_edukasilanjutan);
            $dataEdukasiLanjut =  $this->db->single();
            $cekEdukasiLanjut = $dataEdukasiLanjut['cekOutpatientEdukasiLanjutan'];

            if ($emr_id_edukasilanjutan == "") {

                $this->db->query("INSERT INTO EMR.dbo.OutpatientEdukasiLanjutan(
[Tgl_Edukasi],
[Materi_Edukasi],
[Penerima_Edukasi],
[Edukator_Edukasi],
[Evaluasi_Edukasi],
[No_RM],
[No_Registrasi],
[User_Input],
[Batal],
[User_Update_Batal]
                )
                VALUES (
:emr_tgl_edukasilanjutan1a,
:emr_materi_edukasilanjutan1a,
:emr_penerima_edukasilanjutan1a,
:emr_edukator_edukasilanjutan1a,
:emr_evaluasi_edukasilanjutan1a,
:emr_mr_edukasilanjutan1a,
:emr_noreg_edukasilanjutan1a,
:namauserx1a,
0,
''
                )");
                $this->db->bind('emr_mr_edukasilanjutan1a', $emr_mr_edukasilanjutan);
                $this->db->bind('emr_noreg_edukasilanjutan1a', $emr_noreg_edukasilanjutan);
                $this->db->bind('emr_tgl_edukasilanjutan1a', $emr_tgl_edukasilanjutan);
                $this->db->bind('emr_materi_edukasilanjutan1a', $emr_materi_edukasilanjutan);
                $this->db->bind('emr_penerima_edukasilanjutan1a', $emr_penerima_edukasilanjutan);
                $this->db->bind('emr_edukator_edukasilanjutan1a', $emr_edukator_edukasilanjutan);
                $this->db->bind('emr_evaluasi_edukasilanjutan1a', $emr_evaluasi_edukasilanjutan);
                $this->db->bind('namauserx1a', $namauserx);
                $this->db->execute();
            } else {

                $this->db->query("UPDATE EMR.dbo.OutpatientEdukasiLanjutan SET 
Tgl_Edukasi = :emr_tgl_edukasilanjutan1b,
Materi_Edukasi = :emr_materi_edukasilanjutan1b,
Penerima_Edukasi = :emr_penerima_edukasilanjutan1b,
Edukator_Edukasi = :emr_edukator_edukasilanjutan1b,
Evaluasi_Edukasi = :emr_evaluasi_edukasilanjutan1b,
User_Update_Batal = :namauserx1b
                WHERE ID = :emr_id_edukasilanjutan1b");
                $this->db->bind('emr_tgl_edukasilanjutan1b', $emr_tgl_edukasilanjutan);
                $this->db->bind('emr_materi_edukasilanjutan1b', $emr_materi_edukasilanjutan);
                $this->db->bind('emr_penerima_edukasilanjutan1b', $emr_penerima_edukasilanjutan);
                $this->db->bind('emr_edukator_edukasilanjutan1b', $emr_edukator_edukasilanjutan);
                $this->db->bind('emr_evaluasi_edukasilanjutan1b', $emr_evaluasi_edukasilanjutan);
                $this->db->bind('emr_id_edukasilanjutan1b', $emr_id_edukasilanjutan);
                $this->db->bind('namauserx1b', $namauserx);
                $this->db->execute();
            }

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Edukasi Lanjutan Berhasi',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function getDataTableEdukasiLanjutan($data)
    {
        try {
            $noreg = $data['noreg_pasien'];
            $query = "SELECT ID, Tgl_Edukasi, Materi_Edukasi, Penerima_Edukasi, Edukator_Edukasi, Evaluasi_Edukasi FROM EMR.dbo.OutpatientEdukasiLanjutan WHERE No_Registrasi = :noreg AND Batal = '0'";
            $this->db->query($query);
            $this->db->bind('noreg', $noreg);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['ID'] = $key['ID'];
                $pasing['Tgl_Edukasi'] = $key['Tgl_Edukasi'];
                $pasing['Materi_Edukasi'] = $key['Materi_Edukasi'];
                $pasing['Penerima_Edukasi'] = $key['Penerima_Edukasi'];
                $pasing['Edukator_Edukasi'] = $key['Edukator_Edukasi'];
                $pasing['Evaluasi_Edukasi'] = $key['Evaluasi_Edukasi'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function setBatalEdukasiLanjutan($data)
    {
        try {
            $this->db->transaksi();

            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            // DATA MASALAH KEPERAWAWATAN
            $idbtn = $data['idbtn'];
            $labiddtl = implode(',', $data['idedukasilanjutan']);
            $countlabiddtl = count($data['idedukasilanjutan']);

            $this->db->query("UPDATE EMR.dbo.OutpatientEdukasiLanjutan SET Batal = '1', User_Update_Batal = :namauserx WHERE ID IN ($labiddtl)");
            $this->db->bind('namauserx', $namauserx);
            $this->db->execute();

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function setSaveAssesmentRajal($data)
    {
        try {
            $this->db->transaksi();
            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $emrLevel = $session->emrLevel;
            $DoctorID = $session->DoctorID;
            $namauserx = $session->name;
            // DATA ASSESMENT  
            // $data['emr_assesment'];
            // $emr_keluhan_utama = $data['emr_keluhan_utama'];
            // $emr_pernapasan = $data['emr_pernapasan'];
            // $data['emr_pernapasanmenit'];
            // $data['emr_tensi'];
            // $data['emr_tensimenit'];
            // $data['emr_sistole'];
            // $data['emr_sistolemmhg'];
            // $data['emr_diastole'];
            // $data['emr_diastolemmhg'];
            // $data['emr_suhu'];
            // $data['emr_suhuc'];
            // $data['emr_nadi'];
            // $data['emr_nadimenit'];
            // $data['emr_spo2'];
            // $data['emr_spo2persen'];
            // $data['emr_tinggibadan'];
            // $data['emr_tinggibadancm'];
            // $data['emr_beratbadan'];
            // $data['emr_beratbadankg'];
            // $data['emr_hamil'];
            // $data['emr_menyusui'];
            // $data['emr_riwayatalergi'];
            // $data['emr_riwayatalergiya'];

            // DATA ASSESMENT RAJAL
            $emr_keluhan_utama = $data['emr_keluhan_utama'];
            $emr_pernapasan = $data['emr_pernapasan'];
            if ($emr_pernapasan == '') {
                $emr_pernapasan = 0;
            }
            $emr_tensi = $data['emr_tensi'];
            if ($emr_tensi == '') {
                $emr_tensi = 0;
            }
            $emr_sistole = $data['emr_sistole'];
            if ($emr_sistole == '') {
                $emr_sistole = 0;
            }
            $emr_diastole = $data['emr_diastole'];
            if ($emr_diastole == '') {
                $emr_diastole = 0;
            }
            $emr_suhu = $data['emr_suhu'];
            if ($emr_suhu == '') {
                $emr_suhu = 0;
            }
            $emr_nadi = $data['emr_nadi'];
            if ($emr_nadi == '') {
                $emr_nadi = 0;
            }
            $emr_spo2 = $data['emr_spo2'];
            if ($emr_spo2 == '') {
                $emr_spo2 = 0;
            }
            $emr_tinggibadan = $data['emr_tinggibadan'];
            if ($emr_tinggibadan == '') {
                $emr_tinggibadan = 0;
            }
            $emr_beratbadan = $data['emr_beratbadan'];
            if ($emr_beratbadan == '') {
                $emr_beratbadan = 0;
            }
            $emr_hamil = $data['emr_hamil'];
            $emr_menyusui = $data['emr_menyusui'];
            $emr_riwayatalergi = $data['emr_riwayatalergi'];
            $emr_riwayatalergiya = $data['emr_riwayatalergiya'];
            $checkbox_nariwayatalergi = $data['checkbox_nariwayatalergi'];

            //KESIMPULAN
            $checkbox_emr_rujuk = $data['checkbox_emr_rujuk'];
            $emr_pulang = $data['emr_pulang'];
            $emr_rawatinap = $data['emr_rawatinap'];
            $emr_rujukuntuk = $data['emr_rujukuntuk'];
            $noreg_pasien = $data['noreg_pasien'];
            $mr_pasien = $data['mr_pasien'];

            if ($emrLevel <> "PERAWAT") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Form ini hanya bisa diisi Oleh Perawat !',
                );
                return $callback;
                exit;
            }
            //CEK DATA
            $this->db->query("SELECT COUNT(ID) cekAssesment FROM EMR.dbo.OutpatientAssesments WHERE No_Registrasi = :noreg_pasien");
            $this->db->bind('noreg_pasien', $data['noreg_pasien']);
            $dataEye =  $this->db->single();
            $cekEye = $dataEye['cekAssesment'];
            if ($cekEye == "0") {
                $this->db->query("INSERT INTO EMR.dbo.OutpatientAssesments([Keluhan_Utama], [Pernapasan], [Tensi], [Sistole], [Diastole], [Suhu], [Nadi], [SpO2], [Tinggi_Badan], [Berat_Badan], [Hamil], [Menyusui], [Riwayat_Alergi], [Riwayat_Alergi_Detail], [NA_Assesment], [Pulang], [Rawat_Inap], [Rujuk], [Rujuk_Detail], [No_RM], [No_Registrasi], [User_Input])
                VALUES (:emr_keluhan_utama2a, :emr_pernapasan2a, :emr_tensi2a, :emr_sistole2a, :emr_diastole2a, :emr_suhu2a, :emr_nadi2a, :emr_spo22a, :emr_tinggibadan2a,:emr_beratbadan2a, :emr_hamil2a, :emr_menyusui2a, :emr_riwayatalergi2a, :emr_riwayatalergiya2a, :checkbox_nariwayatalergi2a, 
                :emr_pulang2a, 
                :emr_rawatinap2a, 
                :checkbox_emr_rujuk2a, 
                :emr_rujukuntuk2a, :mr_pasien2a, :noreg_pasien2a, :namauserx2a)");
                $this->db->bind('emr_keluhan_utama2a', $emr_keluhan_utama);
                $this->db->bind('emr_pernapasan2a', $emr_pernapasan);
                $this->db->bind('emr_tensi2a', $emr_tensi);
                $this->db->bind('emr_sistole2a', $emr_sistole);
                $this->db->bind('emr_diastole2a', $emr_diastole);
                $this->db->bind('emr_suhu2a', $emr_suhu);
                $this->db->bind('emr_nadi2a', $emr_nadi);
                $this->db->bind('emr_spo22a', $emr_spo2);
                $this->db->bind('emr_tinggibadan2a', $emr_tinggibadan);
                $this->db->bind('emr_beratbadan2a', $emr_beratbadan);
                $this->db->bind('emr_hamil2a', $emr_hamil);
                $this->db->bind('emr_menyusui2a', $emr_menyusui);
                $this->db->bind('emr_riwayatalergi2a', $emr_riwayatalergi);
                $this->db->bind('emr_riwayatalergiya2a', $emr_riwayatalergiya);
                $this->db->bind('checkbox_nariwayatalergi2a', $checkbox_nariwayatalergi);
                $this->db->bind('mr_pasien2a', $mr_pasien);
                $this->db->bind('noreg_pasien2a', $noreg_pasien);
                $this->db->bind('namauserx2a', $namauserx);
                $this->db->bind('emr_pulang2a', $emr_pulang);
                $this->db->bind('emr_rawatinap2a', $emr_rawatinap);
                $this->db->bind('checkbox_emr_rujuk2a', $checkbox_emr_rujuk);
                $this->db->bind('emr_rujukuntuk2a', $emr_rujukuntuk);
                $this->db->execute();
            } else {
                $this->db->query("UPDATE EMR.dbo.OutpatientAssesments SET Keluhan_Utama = :emr_keluhan_utama2b, Pernapasan = :emr_pernapasan2b, Tensi = :emr_tensi2b, 
                Sistole = :emr_sistole2b, Diastole = :emr_diastole2b, Suhu = :emr_suhu2b, Nadi = :emr_nadi2b, SpO2 = :emr_spo22b, Tinggi_Badan = :emr_tinggibadan2b, Berat_Badan = :emr_beratbadan2b, Hamil = :emr_hamil2b, Menyusui = :emr_menyusui2b, Riwayat_Alergi = :emr_riwayatalergi2b, 
                Riwayat_Alergi_Detail = :emr_riwayatalergiya2b, NA_Assesment=:checkbox_nariwayatalergi2b, User_Input = :namauserx2b,
                Pulang = :emr_pulang2b,
                Rawat_Inap = :emr_rawatinap2b,
                Rujuk = :checkbox_emr_rujuk2b,
                Rujuk_Detail = :emr_rujukuntuk2b
                 WHERE No_Registrasi = :noreg_pasien2b");
                $this->db->bind('noreg_pasien2b', $noreg_pasien);
                $this->db->bind('emr_keluhan_utama2b', $emr_keluhan_utama);
                $this->db->bind('emr_pernapasan2b', $emr_pernapasan);
                $this->db->bind('emr_tensi2b', $emr_tensi);
                $this->db->bind('emr_sistole2b', $emr_sistole);
                $this->db->bind('emr_diastole2b', $emr_diastole);
                $this->db->bind('emr_suhu2b', $emr_suhu);
                $this->db->bind('emr_nadi2b', $emr_nadi);
                $this->db->bind('emr_spo22b', $emr_spo2);
                $this->db->bind('emr_tinggibadan2b', $emr_tinggibadan);
                $this->db->bind('emr_beratbadan2b', $emr_beratbadan);
                $this->db->bind('emr_hamil2b', $emr_hamil);
                $this->db->bind('emr_menyusui2b', $emr_menyusui);
                $this->db->bind('emr_riwayatalergi2b', $emr_riwayatalergi);
                $this->db->bind('emr_riwayatalergiya2b', $emr_riwayatalergiya);
                $this->db->bind('checkbox_nariwayatalergi2b', $checkbox_nariwayatalergi);
                $this->db->bind('namauserx2b', $namauserx);

                $this->db->bind('emr_pulang2b', $emr_pulang);
                $this->db->bind('emr_rawatinap2b', $emr_rawatinap);
                $this->db->bind('checkbox_emr_rujuk2b', $checkbox_emr_rujuk);
                $this->db->bind('emr_rujukuntuk2b', $emr_rujukuntuk);
                $this->db->execute();
            }

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function setSaveAssesmentMata($data)
    {
        try {
            $this->db->transaksi();
            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $emrLevel = $session->emrLevel;
            $DoctorID = $session->DoctorID;
            $namauserx = $session->name;

            // DATA ASSESMENT MATA
            $emr_noregmata = $data['emr_noregmata'];
            $emr_normmata = $data['emr_normmata'];

            $emr_anamnesismata = $data['emr_anamnesismata'];
            $emr_pemeriksaanmata = $data['emr_pemeriksaanmata'];
            $emr_tanpakoreksi_avod = $data['emr_tanpakoreksi_avod'];
            $emr_tanpakoreksi_avos = $data['emr_tanpakoreksi_avos'];
            $emr_setelahkoreksi_avods = $data['emr_setelahkoreksi_avods'];
            $emr_setelahkoreksi_avodc = $data['emr_setelahkoreksi_avodc'];
            $emr_setelahkoreksi_avodaxis = $data['emr_setelahkoreksi_avodaxis'];
            $emr_avodc_keterangan1 = $data['emr_avodc_keterangan1'];
            $emr_avodc_keterangan2 = $data['emr_avodc_keterangan2'];
            $emr_setelahkoreksi_avoss = $data['emr_setelahkoreksi_avoss'];
            $emr_setelahkoreksi_avosc = $data['emr_setelahkoreksi_avosc'];
            $emr_setelahkoreksi_avosaxis = $data['emr_setelahkoreksi_avosaxis'];
            $emr_avosc_keterangan1 = $data['emr_avosc_keterangan1'];
            $emr_avosc_keterangan2 = $data['emr_avosc_keterangan2'];
            $emr_setelahkoreksi_adds = $data['emr_setelahkoreksi_adds'];
            $emr_setelahkoreksi_pd = $data['emr_setelahkoreksi_pd'];
            $emr_kacamata_avods = $data['emr_kacamata_avods'];
            $emr_kacamata_avodc = $data['emr_kacamata_avodc'];
            $emr_kacamata_avodaxis = $data['emr_kacamata_avodaxis'];
            $emr_avodc_keterangan1_kacamata = $data['emr_avodc_keterangan1_kacamata'];
            $emr_kacamata_avoss = $data['emr_kacamata_avoss'];
            $emr_kacamata_avosc = $data['emr_kacamata_avosc'];
            $emr_kacamata_avosaxis = $data['emr_kacamata_avosaxis'];
            $emr_avosc_keterangan1_kacamata = $data['emr_avosc_keterangan1_kacamata'];
            $emr_kacamata_adds = $data['emr_kacamata_adds'];
            $emr_palbebra_kanan = $data['emr_palbebra_kanan'];
            $emr_palbebra_kanan_detail = $data['emr_palbebra_kanan_detail'];
            $emr_palbebra_kiri = $data['emr_palbebra_kiri'];
            $emr_palbebra_kiri_detail = $data['emr_palbebra_kiri_detail'];
            $emr_konjungtiva_kanan = $data['emr_konjungtiva_kanan'];
            $emr_konjungtiva_kanan_detail = $data['emr_konjungtiva_kanan_detail'];
            $emr_konjungtiva_kiri = $data['emr_konjungtiva_kiri'];
            $emr_konjungtiva_kiri_detail = $data['emr_konjungtiva_kiri_detail'];
            $emr_kornea_kanan = $data['emr_kornea_kanan'];
            $emr_kornea_kanan_detail = $data['emr_kornea_kanan_detail'];
            $emr_kornea_kiri = $data['emr_kornea_kiri'];
            $emr_kornea_kiri_detail = $data['emr_kornea_kiri_detail'];
            $emr_kamera_kanan = $data['emr_kamera_kanan'];
            $emr_kamera_kanan_detail = $data['emr_kamera_kanan_detail'];
            $emr_kamera_kiri = $data['emr_kamera_kiri'];
            $emr_kamera_kiri_detail = $data['emr_kamera_kiri_detail'];
            $emr_pupil_kanan = $data['emr_pupil_kanan'];
            $emr_pupil_kanan_detail = $data['emr_pupil_kanan_detail'];
            $emr_pupil_kiri = $data['emr_pupil_kiri'];
            $emr_pupil_kiri_detail = $data['emr_pupil_kiri_detail'];
            $emr_iris_kanan = $data['emr_iris_kanan'];
            $emr_iris_kanan_detail = $data['emr_iris_kanan_detail'];
            $emr_iris_kiri = $data['emr_iris_kiri'];
            $emr_iris_kiri_detail = $data['emr_iris_kiri_detail'];
            $emr_lensa_kanan = $data['emr_lensa_kanan'];
            $emr_lensa_kanan_detail = $data['emr_lensa_kanan_detail'];
            $emr_lensa_kiri = $data['emr_lensa_kiri'];
            $emr_lensa_kiri_detail = $data['emr_lensa_kiri_detail'];
            $emr_lainlain_kanan = $data['emr_lainlain_kanan'];
            $emr_lainlain_kanan_detail = $data['emr_lainlain_kanan_detail'];
            $emr_lainlain_kiri = $data['emr_lainlain_kiri'];
            $emr_lainlain_kiri_detail = $data['emr_lainlain_kiri_detail'];
            $emr_retina_kanan = $data['emr_retina_kanan'];
            $emr_retina_kanan_detail = $data['emr_retina_kanan_detail'];
            $emr_retina_kiri = $data['emr_retina_kiri'];
            $emr_retina_kiri_detail = $data['emr_retina_kiri_detail'];
            $emr_disknoptikus_kanan = $data['emr_disknoptikus_kanan'];
            $emr_disknoptikus_kanan_detail = $data['emr_disknoptikus_kanan_detail'];
            $emr_disknoptikus_kiri = $data['emr_disknoptikus_kiri'];
            $emr_disknoptikus_kiri_detail = $data['emr_disknoptikus_kiri_detail'];
            $emr_cdratio_kanan_detail = $data['emr_cdratio_kanan_detail'];
            $emr_cdratio_kiri_detail = $data['emr_cdratio_kiri_detail'];
            $emr_keseimbanganotot_kanan = $data['emr_keseimbanganotot_kanan'];
            $emr_keseimbanganotot_kanan_detail = $data['emr_keseimbanganotot_kanan_detail'];
            $emr_keseimbanganotot_kiri = $data['emr_keseimbanganotot_kiri'];
            $emr_keseimbanganotot_kiri_detail = $data['emr_keseimbanganotot_kiri_detail'];
            $emr_tekananintraokuler_kanan_detail = $data['emr_tekananintraokuler_kanan_detail'];
            $emr_tekananintraokuler_kiri_detail = $data['emr_tekananintraokuler_kiri_detail'];
            $emr_malulalutea_kanan = $data['emr_malulalutea_kanan'];
            $emr_malulalutea_kanan_detail = $data['emr_malulalutea_kanan_detail'];
            $emr_malulalutea_kiri = $data['emr_malulalutea_kiri'];
            $emr_malulalutea_kiri_detail = $data['emr_malulalutea_kiri_detail'];
            $emr_kompusvitreum_kanan = $data['emr_kompusvitreum_kanan'];
            $emr_kompusvitreum_kanan_detail = $data['emr_kompusvitreum_kanan_detail'];
            $emr_kompusvitreum_kiri = $data['emr_kompusvitreum_kiri'];
            $emr_kompusvitreum_kiri_detail = $data['emr_kompusvitreum_kiri_detail'];
            $emr_arterivena_kanan = $data['emr_arterivena_kanan'];
            $emr_arterivena_kanan_detail = $data['emr_arterivena_kanan_detail'];
            $emr_arterivena_kiri = $data['emr_arterivena_kiri'];
            $emr_arterivena_kiri_detail = $data['emr_arterivena_kiri_detail'];
            $emr_testbutawarna_kanan = $data['emr_testbutawarna_kanan'];
            $emr_testbutawarna_kanan_detail = $data['emr_testbutawarna_kanan_detail'];
            $emr_testbutawarna_kiri = $data['emr_testbutawarna_kiri'];
            $emr_testbutawarna_kiri_detail = $data['emr_testbutawarna_kiri_detail'];
            $emr_kesimpulan_mata = $data['emr_kesimpulan_mata'];
            $emr_saran_mata = $data['emr_saran_mata'];
            $emr_dokter_mata = $data['emr_dokter_mata'];

            if ($emrLevel <> "DOKTER") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Maaf.. Akses Login anda ' . $emrLevel . ', Form ini hanya bisa diisi Oleh Dokter !',
                );
                return $callback;
                exit;
            }
            //CEK DATA
            $this->db->query("SELECT COUNT(ID) cekEyesAssesment FROM EMR.dbo.EyesAssesment WHERE NoRegistrasi = :noreg_pasien");
            $this->db->bind('noreg_pasien', $emr_noregmata);
            $dataEye =  $this->db->single();
            $cekEye = $dataEye['cekEyesAssesment'];
            if ($cekEye == "0") {
                $this->db->query("INSERT INTO EMR.dbo.EyesAssesment ([NoMR],[NoEpisode],[NoRegistrasi],[Tanggal],[Anamnesis],[PemerisaanMata],[Tako_AVOD],[Tako_AVOS],[Seko_AVODS],[Seko_AVODC],[Seko_AVODAxis],[Seko_AVODMenjadi],[Seko_AVODKet],[Seko_AVOSS],[Seko_AVOSC],[Seko_AVOSAxis],[Seko_AVOSMenjadi],[Seko_AVOSKet],[Seko_Add],[Seko_PD],[Kcmt_AVODS],[Kcmt_AVODC],[Kcmt_AVODAxis],[Kcmt_AVODMenjadi],[Kcmt_AVOSS],[Kcmt_AVOSC],[Kcmt_AVOSAxis],[Kcmt_AVOSMenjadi],[Kcmt_Add],[PalpebraKa],[PalpebraKaNote],[PalpebraKi],[PalpebraKiNote],[KonjungtivaKa],[KonjungtivaKaNote],[KonjungtivaKi],[KonjungtivaKiNote],[KorneaKa],[KorneaKaNote],[KorneaKi],[KorneaKiNote],[KameraKa],[KameraKaNote],[KameraKi],[KameraKiNote],[PupilKa],[PupilKaNote],[PupilKi],[PupilKiNote],[IrisKa],[IriKaNote],[IriKi],[IriKiNote],[LensaKa],[LenasKaNote],[LensaKi],[LensaKiNote],[Lain2Ka],[Lain2KaNote],[Lain2Ki],[Lain2KiNote],[RetinaKa],[RetinakaNote],[RetinaKi],[RetinaKiNote],[OptikusKa],[OptikusKaNote],[OptikusKi],[OptikusKiNote],[CDRatioKa],[CDRatioKi],[KesOtotKa],[KesOtotKaNote],[KesOtotKi],[KesOtotKiNote],[TIOKa],[TIOKi],[MakulaLutKa],[MakulaLutKaNote],[MakulaLutKi],[MakulaLutKiNote],[KorpusVitreumKa],[KorpusVitreumKaNote],[KorpusVitreumKi],[KorpusVitreumKiNote],[ArteriVenaKa],[ArteriVenaKaNote],[ArteriVenaKi],[ArteriVenaKiNote],[TBWaranaKa],[TBWaranaKaNote],[TBWaranaKi],[TBWaranaKiNote],[Kesimpulan],[Saran],[DokterPemeri]
                )
                VALUES (:emr_normmata12a,'',:emr_noregmata12a,:datenowx12a,:emr_anamnesismata12a,:emr_pemeriksaanmata12a,:emr_tanpakoreksi_avod12a,:emr_tanpakoreksi_avos12a,:emr_setelahkoreksi_avods12a,:emr_setelahkoreksi_avodc12a,:emr_setelahkoreksi_avodaxis12a,:emr_avodc_keterangan112a,:emr_avodc_keterangan212a,:emr_setelahkoreksi_avoss12a,:emr_setelahkoreksi_avosc12a,:emr_setelahkoreksi_avosaxis12a,:emr_avosc_keterangan112a,:emr_avosc_keterangan212a,:emr_setelahkoreksi_adds12a,:emr_setelahkoreksi_pd12a,:emr_kacamata_avods12a,:emr_kacamata_avodc12a,:emr_kacamata_avodaxis12a,:emr_avodc_keterangan1_kacamata12a,:emr_kacamata_avoss12a,:emr_kacamata_avosc12a,:emr_kacamata_avosaxis12a,:emr_avosc_keterangan1_kacamata12a,:emr_kacamata_adds12a,:emr_palbebra_kanan12a,:emr_palbebra_kanan_detail12a,:emr_palbebra_kiri12a,:emr_palbebra_kiri_detail12a,:emr_konjungtiva_kanan12a,:emr_konjungtiva_kanan_detail12a,:emr_konjungtiva_kiri12a,:emr_konjungtiva_kiri_detail12a,:emr_kornea_kanan12a,:emr_kornea_kanan_detail12a,:emr_kornea_kiri12a,:emr_kornea_kiri_detail12a,:emr_kamera_kanan12a,:emr_kamera_kanan_detail12a,:emr_kamera_kiri12a,:emr_kamera_kiri_detail12a,:emr_pupil_kanan12a,:emr_pupil_kanan_detail12a,:emr_pupil_kiri12a,:emr_pupil_kiri_detail12a,:emr_iris_kanan12a,:emr_iris_kanan_detail12a,:emr_iris_kiri12a,:emr_iris_kiri_detail12a,:emr_lensa_kanan12a,:emr_lensa_kanan_detail12a,:emr_lensa_kiri12a,:emr_lensa_kiri_detail12a,:emr_lainlain_kanan12a,:emr_lainlain_kanan_detail12a,:emr_lainlain_kiri12a,:emr_lainlain_kiri_detail12a,:emr_retina_kanan12a,:emr_retina_kanan_detail12a,:emr_retina_kiri12a,:emr_retina_kiri_detail12a,:emr_disknoptikus_kanan12a,:emr_disknoptikus_kanan_detail12a,:emr_disknoptikus_kiri12a,:emr_disknoptikus_kiri_detail12a,:emr_cdratio_kanan_detail12a,:emr_cdratio_kiri_detail12a,:emr_keseimbanganotot_kanan12a,:emr_keseimbanganotot_kanan_detail12a,:emr_keseimbanganotot_kiri12a,:emr_keseimbanganotot_kiri_detail12a,:emr_tekananintraokuler_kanan_detail12a,:emr_tekananintraokuler_kiri_detail12a,:emr_malulalutea_kanan12a,:emr_malulalutea_kanan_detail12a,:emr_malulalutea_kiri12a,:emr_malulalutea_kiri_detail12a,:emr_kompusvitreum_kanan12a,:emr_kompusvitreum_kanan_detail12a,:emr_kompusvitreum_kiri12a,:emr_kompusvitreum_kiri_detail12a,:emr_arterivena_kanan12a,:emr_arterivena_kanan_detail12a,:emr_arterivena_kiri12a,:emr_arterivena_kiri_detail12a,:emr_testbutawarna_kanan12a,:emr_testbutawarna_kanan_detail12a,:emr_testbutawarna_kiri12a,:emr_testbutawarna_kiri_detail12a,:emr_kesimpulan_mata12a,:emr_saran_mata12a,:emr_dokter_mata12a
                )");
                $this->db->bind('emr_normmata12a', $emr_normmata);
                $this->db->bind('emr_noregmata12a', $emr_noregmata);
                $this->db->bind('datenowx12a', $datenowcreate);
                $this->db->bind('emr_anamnesismata12a', $emr_anamnesismata);
                $this->db->bind('emr_pemeriksaanmata12a', $emr_pemeriksaanmata);
                $this->db->bind('emr_tanpakoreksi_avod12a', $emr_tanpakoreksi_avod);
                $this->db->bind('emr_tanpakoreksi_avos12a', $emr_tanpakoreksi_avos);
                $this->db->bind('emr_setelahkoreksi_avods12a', $emr_setelahkoreksi_avods);
                $this->db->bind('emr_setelahkoreksi_avodc12a', $emr_setelahkoreksi_avodc);
                $this->db->bind('emr_setelahkoreksi_avodaxis12a', $emr_setelahkoreksi_avodaxis);
                $this->db->bind('emr_avodc_keterangan112a', $emr_avodc_keterangan1);
                $this->db->bind('emr_avodc_keterangan212a', $emr_avodc_keterangan2);
                $this->db->bind('emr_setelahkoreksi_avoss12a', $emr_setelahkoreksi_avoss);
                $this->db->bind('emr_setelahkoreksi_avosc12a', $emr_setelahkoreksi_avosc);
                $this->db->bind('emr_setelahkoreksi_avosaxis12a', $emr_setelahkoreksi_avosaxis);
                $this->db->bind('emr_avosc_keterangan112a', $emr_avosc_keterangan1);
                $this->db->bind('emr_avosc_keterangan212a', $emr_avosc_keterangan2);
                $this->db->bind('emr_setelahkoreksi_adds12a', $emr_setelahkoreksi_adds);
                $this->db->bind('emr_setelahkoreksi_pd12a', $emr_setelahkoreksi_pd);
                $this->db->bind('emr_kacamata_avods12a', $emr_kacamata_avods);
                $this->db->bind('emr_kacamata_avodc12a', $emr_kacamata_avodc);
                $this->db->bind('emr_kacamata_avodaxis12a', $emr_kacamata_avodaxis);
                $this->db->bind('emr_avodc_keterangan1_kacamata12a', $emr_avodc_keterangan1_kacamata);
                $this->db->bind('emr_kacamata_avoss12a', $emr_kacamata_avoss);
                $this->db->bind('emr_kacamata_avosc12a', $emr_kacamata_avosc);
                $this->db->bind('emr_kacamata_avosaxis12a', $emr_kacamata_avosaxis);
                $this->db->bind('emr_avosc_keterangan1_kacamata12a', $emr_avosc_keterangan1_kacamata);
                $this->db->bind('emr_kacamata_adds12a', $emr_kacamata_adds);
                $this->db->bind('emr_palbebra_kanan12a', $emr_palbebra_kanan);
                $this->db->bind('emr_palbebra_kanan_detail12a', $emr_palbebra_kanan_detail);
                $this->db->bind('emr_palbebra_kiri12a', $emr_palbebra_kiri);
                $this->db->bind('emr_palbebra_kiri_detail12a', $emr_palbebra_kiri_detail);
                $this->db->bind('emr_konjungtiva_kanan12a', $emr_konjungtiva_kanan);
                $this->db->bind('emr_konjungtiva_kanan_detail12a', $emr_konjungtiva_kanan_detail);
                $this->db->bind('emr_konjungtiva_kiri12a', $emr_konjungtiva_kiri);
                $this->db->bind('emr_konjungtiva_kiri_detail12a', $emr_konjungtiva_kiri_detail);
                $this->db->bind('emr_kornea_kanan12a', $emr_kornea_kanan);
                $this->db->bind('emr_kornea_kanan_detail12a', $emr_kornea_kanan_detail);
                $this->db->bind('emr_kornea_kiri12a', $emr_kornea_kiri);
                $this->db->bind('emr_kornea_kiri_detail12a', $emr_kornea_kiri_detail);
                $this->db->bind('emr_kamera_kanan12a', $emr_kamera_kanan);
                $this->db->bind('emr_kamera_kanan_detail12a', $emr_kamera_kanan_detail);
                $this->db->bind('emr_kamera_kiri12a', $emr_kamera_kiri);
                $this->db->bind('emr_kamera_kiri_detail12a', $emr_kamera_kiri_detail);
                $this->db->bind('emr_pupil_kanan12a', $emr_pupil_kanan);
                $this->db->bind('emr_pupil_kanan_detail12a', $emr_pupil_kanan_detail);
                $this->db->bind('emr_pupil_kiri12a', $emr_pupil_kiri);
                $this->db->bind('emr_pupil_kiri_detail12a', $emr_pupil_kiri_detail);
                $this->db->bind('emr_iris_kanan12a', $emr_iris_kanan);
                $this->db->bind('emr_iris_kanan_detail12a', $emr_iris_kanan_detail);
                $this->db->bind('emr_iris_kiri12a', $emr_iris_kiri);
                $this->db->bind('emr_iris_kiri_detail12a', $emr_iris_kiri_detail);
                $this->db->bind('emr_lensa_kanan12a', $emr_lensa_kanan);
                $this->db->bind('emr_lensa_kanan_detail12a', $emr_lensa_kanan_detail);
                $this->db->bind('emr_lensa_kiri12a', $emr_lensa_kiri);
                $this->db->bind('emr_lensa_kiri_detail12a', $emr_lensa_kiri_detail);
                $this->db->bind('emr_lainlain_kanan12a', $emr_lainlain_kanan);
                $this->db->bind('emr_lainlain_kanan_detail12a', $emr_lainlain_kanan_detail);
                $this->db->bind('emr_lainlain_kiri12a', $emr_lainlain_kiri);
                $this->db->bind('emr_lainlain_kiri_detail12a', $emr_lainlain_kiri_detail);
                $this->db->bind('emr_retina_kanan12a', $emr_retina_kanan);
                $this->db->bind('emr_retina_kanan_detail12a', $emr_retina_kanan_detail);
                $this->db->bind('emr_retina_kiri12a', $emr_retina_kiri);
                $this->db->bind('emr_retina_kiri_detail12a', $emr_retina_kiri_detail);
                $this->db->bind('emr_disknoptikus_kanan12a', $emr_disknoptikus_kanan);
                $this->db->bind('emr_disknoptikus_kanan_detail12a', $emr_disknoptikus_kanan_detail);
                $this->db->bind('emr_disknoptikus_kiri12a', $emr_disknoptikus_kiri);
                $this->db->bind('emr_disknoptikus_kiri_detail12a', $emr_disknoptikus_kiri_detail);
                $this->db->bind('emr_cdratio_kanan_detail12a', $emr_cdratio_kanan_detail);
                $this->db->bind('emr_cdratio_kiri_detail12a', $emr_cdratio_kiri_detail);
                $this->db->bind('emr_keseimbanganotot_kanan12a', $emr_keseimbanganotot_kanan);
                $this->db->bind('emr_keseimbanganotot_kanan_detail12a', $emr_keseimbanganotot_kanan_detail);
                $this->db->bind('emr_keseimbanganotot_kiri12a', $emr_keseimbanganotot_kiri);
                $this->db->bind('emr_keseimbanganotot_kiri_detail12a', $emr_keseimbanganotot_kiri_detail);
                $this->db->bind('emr_tekananintraokuler_kanan_detail12a', $emr_tekananintraokuler_kanan_detail);
                $this->db->bind('emr_tekananintraokuler_kiri_detail12a', $emr_tekananintraokuler_kiri_detail);
                $this->db->bind('emr_malulalutea_kanan12a', $emr_malulalutea_kanan);
                $this->db->bind('emr_malulalutea_kanan_detail12a', $emr_malulalutea_kanan_detail);
                $this->db->bind('emr_malulalutea_kiri12a', $emr_malulalutea_kiri);
                $this->db->bind('emr_malulalutea_kiri_detail12a', $emr_malulalutea_kiri_detail);
                $this->db->bind('emr_kompusvitreum_kanan12a', $emr_kompusvitreum_kanan);
                $this->db->bind('emr_kompusvitreum_kanan_detail12a', $emr_kompusvitreum_kanan_detail);
                $this->db->bind('emr_kompusvitreum_kiri12a', $emr_kompusvitreum_kiri);
                $this->db->bind('emr_kompusvitreum_kiri_detail12a', $emr_kompusvitreum_kiri_detail);
                $this->db->bind('emr_arterivena_kanan12a', $emr_arterivena_kanan);
                $this->db->bind('emr_arterivena_kanan_detail12a', $emr_arterivena_kanan_detail);
                $this->db->bind('emr_arterivena_kiri12a', $emr_arterivena_kiri);
                $this->db->bind('emr_arterivena_kiri_detail12a', $emr_arterivena_kiri_detail);
                $this->db->bind('emr_testbutawarna_kanan12a', $emr_testbutawarna_kanan);
                $this->db->bind('emr_testbutawarna_kanan_detail12a', $emr_testbutawarna_kanan_detail);
                $this->db->bind('emr_testbutawarna_kiri12a', $emr_testbutawarna_kiri);
                $this->db->bind('emr_testbutawarna_kiri_detail12a', $emr_testbutawarna_kiri_detail);
                $this->db->bind('emr_kesimpulan_mata12a', $emr_kesimpulan_mata);
                $this->db->bind('emr_saran_mata12a', $emr_saran_mata);
                $this->db->bind('emr_dokter_mata12a', $emr_dokter_mata);
                $this->db->execute();
            } else {
                $this->db->query("UPDATE EMR.dbo.EyesAssesment SET Tanggal = :datenowx12b,Anamnesis = :emr_anamnesismata12b,PemerisaanMata = :emr_pemeriksaanmata12b,Tako_AVOD = :emr_tanpakoreksi_avod12b,Tako_AVOS = :emr_tanpakoreksi_avos12b,Seko_AVODS = :emr_setelahkoreksi_avods12b,Seko_AVODC = :emr_setelahkoreksi_avodc12b,Seko_AVODAxis = :emr_setelahkoreksi_avodaxis12b,Seko_AVODMenjadi = :emr_avodc_keterangan112b,Seko_AVODKet = :emr_avodc_keterangan212b,Seko_AVOSS = :emr_setelahkoreksi_avoss12b,Seko_AVOSC = :emr_setelahkoreksi_avosc12b,Seko_AVOSAxis = :emr_setelahkoreksi_avosaxis12b,Seko_AVOSMenjadi = :emr_avosc_keterangan112b,Seko_AVOSKet = :emr_avosc_keterangan212b,Seko_Add = :emr_setelahkoreksi_adds12b,Seko_PD = :emr_setelahkoreksi_pd12b,Kcmt_AVODS = :emr_kacamata_avods12b,Kcmt_AVODC = :emr_kacamata_avodc12b,Kcmt_AVODAxis = :emr_kacamata_avodaxis12b,Kcmt_AVODMenjadi = :emr_avodc_keterangan1_kacamata12b,Kcmt_AVOSS = :emr_kacamata_avoss12b,Kcmt_AVOSC = :emr_kacamata_avosc12b,Kcmt_AVOSAxis = :emr_kacamata_avosaxis12b,Kcmt_AVOSMenjadi = :emr_avosc_keterangan1_kacamata12b,Kcmt_Add = :emr_kacamata_adds12b,PalpebraKa = :emr_palbebra_kanan12b,PalpebraKaNote = :emr_palbebra_kanan_detail12b,PalpebraKi = :emr_palbebra_kiri12b,PalpebraKiNote = :emr_palbebra_kiri_detail12b,KonjungtivaKa = :emr_konjungtiva_kanan12b,KonjungtivaKaNote = :emr_konjungtiva_kanan_detail12b,KonjungtivaKi = :emr_konjungtiva_kiri12b,KonjungtivaKiNote = :emr_konjungtiva_kiri_detail12b,KorneaKa = :emr_kornea_kanan12b,KorneaKaNote = :emr_kornea_kanan_detail12b,KorneaKi = :emr_kornea_kiri12b,KorneaKiNote = :emr_kornea_kiri_detail12b,KameraKa = :emr_kamera_kanan12b,KameraKaNote = :emr_kamera_kanan_detail12b,KameraKi = :emr_kamera_kiri12b,KameraKiNote = :emr_kamera_kiri_detail12b,PupilKa = :emr_pupil_kanan12b,PupilKaNote = :emr_pupil_kanan_detail12b,PupilKi = :emr_pupil_kiri12b,PupilKiNote = :emr_pupil_kiri_detail12b,IrisKa = :emr_iris_kanan12b,IriKaNote = :emr_iris_kanan_detail12b,IriKi = :emr_iris_kiri12b,IriKiNote = :emr_iris_kiri_detail12b,LensaKa = :emr_lensa_kanan12b,LenasKaNote = :emr_lensa_kanan_detail12b,LensaKi = :emr_lensa_kiri12b,LensaKiNote = :emr_lensa_kiri_detail12b,Lain2Ka = :emr_lainlain_kanan12b,Lain2KaNote = :emr_lainlain_kanan_detail12b,Lain2Ki = :emr_lainlain_kiri12b,Lain2KiNote = :emr_lainlain_kiri_detail12b,RetinaKa = :emr_retina_kanan12b,RetinakaNote = :emr_retina_kanan_detail12b,RetinaKi = :emr_retina_kiri12b,RetinaKiNote = :emr_retina_kiri_detail12b,OptikusKa = :emr_disknoptikus_kanan12b,OptikusKaNote = :emr_disknoptikus_kanan_detail12b,OptikusKi = :emr_disknoptikus_kiri12b,OptikusKiNote = :emr_disknoptikus_kiri_detail12b,CDRatioKa = :emr_cdratio_kanan_detail12b,CDRatioKi = :emr_cdratio_kiri_detail12b,KesOtotKa = :emr_keseimbanganotot_kanan12b,KesOtotKaNote = :emr_keseimbanganotot_kanan_detail12b,KesOtotKi = :emr_keseimbanganotot_kiri12b,KesOtotKiNote = :emr_keseimbanganotot_kiri_detail12b,TIOKa = :emr_tekananintraokuler_kanan_detail12b,TIOKi = :emr_tekananintraokuler_kiri_detail12b,MakulaLutKa = :emr_malulalutea_kanan12b,MakulaLutKaNote = :emr_malulalutea_kanan_detail12b,MakulaLutKi = :emr_malulalutea_kiri12b,MakulaLutKiNote = :emr_malulalutea_kiri_detail12b,KorpusVitreumKa = :emr_kompusvitreum_kanan12b,KorpusVitreumKaNote = :emr_kompusvitreum_kanan_detail12b,KorpusVitreumKi = :emr_kompusvitreum_kiri12b,KorpusVitreumKiNote = :emr_kompusvitreum_kiri_detail12b,ArteriVenaKa = :emr_arterivena_kanan12b,ArteriVenaKaNote = :emr_arterivena_kanan_detail12b,ArteriVenaKi = :emr_arterivena_kiri12b,ArteriVenaKiNote = :emr_arterivena_kiri_detail12b,TBWaranaKa = :emr_testbutawarna_kanan12b,TBWaranaKaNote = :emr_testbutawarna_kanan_detail12b,TBWaranaKi = :emr_testbutawarna_kiri12b,TBWaranaKiNote = :emr_testbutawarna_kiri_detail12b,Kesimpulan = :emr_kesimpulan_mata12b,Saran = :emr_saran_mata12b,DokterPemeri = :emr_dokter_mata12b
                WHERE NoRegistrasi = :emr_noregmata12b");
                $this->db->bind('emr_noregmata12b', $emr_noregmata);
                $this->db->bind('datenowx12b', $datenowx);
                $this->db->bind('emr_anamnesismata12b', $emr_anamnesismata);
                $this->db->bind('emr_pemeriksaanmata12b', $emr_pemeriksaanmata);
                $this->db->bind('emr_tanpakoreksi_avod12b', $emr_tanpakoreksi_avod);
                $this->db->bind('emr_tanpakoreksi_avos12b', $emr_tanpakoreksi_avos);
                $this->db->bind('emr_setelahkoreksi_avods12b', $emr_setelahkoreksi_avods);
                $this->db->bind('emr_setelahkoreksi_avodc12b', $emr_setelahkoreksi_avodc);
                $this->db->bind('emr_setelahkoreksi_avodaxis12b', $emr_setelahkoreksi_avodaxis);
                $this->db->bind('emr_avodc_keterangan112b', $emr_avodc_keterangan1);
                $this->db->bind('emr_avodc_keterangan212b', $emr_avodc_keterangan2);
                $this->db->bind('emr_setelahkoreksi_avoss12b', $emr_setelahkoreksi_avoss);
                $this->db->bind('emr_setelahkoreksi_avosc12b', $emr_setelahkoreksi_avosc);
                $this->db->bind('emr_setelahkoreksi_avosaxis12b', $emr_setelahkoreksi_avosaxis);
                $this->db->bind('emr_avosc_keterangan112b', $emr_avosc_keterangan1);
                $this->db->bind('emr_avosc_keterangan212b', $emr_avosc_keterangan2);
                $this->db->bind('emr_setelahkoreksi_adds12b', $emr_setelahkoreksi_adds);
                $this->db->bind('emr_setelahkoreksi_pd12b', $emr_setelahkoreksi_pd);
                $this->db->bind('emr_kacamata_avods12b', $emr_kacamata_avods);
                $this->db->bind('emr_kacamata_avodc12b', $emr_kacamata_avodc);
                $this->db->bind('emr_kacamata_avodaxis12b', $emr_kacamata_avodaxis);
                $this->db->bind('emr_avodc_keterangan1_kacamata12b', $emr_avodc_keterangan1_kacamata);
                $this->db->bind('emr_kacamata_avoss12b', $emr_kacamata_avoss);
                $this->db->bind('emr_kacamata_avosc12b', $emr_kacamata_avosc);
                $this->db->bind('emr_kacamata_avosaxis12b', $emr_kacamata_avosaxis);
                $this->db->bind('emr_avosc_keterangan1_kacamata12b', $emr_avosc_keterangan1_kacamata);
                $this->db->bind('emr_kacamata_adds12b', $emr_kacamata_adds);
                $this->db->bind('emr_palbebra_kanan12b', $emr_palbebra_kanan);
                $this->db->bind('emr_palbebra_kanan_detail12b', $emr_palbebra_kanan_detail);
                $this->db->bind('emr_palbebra_kiri12b', $emr_palbebra_kiri);
                $this->db->bind('emr_palbebra_kiri_detail12b', $emr_palbebra_kiri_detail);
                $this->db->bind('emr_konjungtiva_kanan12b', $emr_konjungtiva_kanan);
                $this->db->bind('emr_konjungtiva_kanan_detail12b', $emr_konjungtiva_kanan_detail);
                $this->db->bind('emr_konjungtiva_kiri12b', $emr_konjungtiva_kiri);
                $this->db->bind('emr_konjungtiva_kiri_detail12b', $emr_konjungtiva_kiri_detail);
                $this->db->bind('emr_kornea_kanan12b', $emr_kornea_kanan);
                $this->db->bind('emr_kornea_kanan_detail12b', $emr_kornea_kanan_detail);
                $this->db->bind('emr_kornea_kiri12b', $emr_kornea_kiri);
                $this->db->bind('emr_kornea_kiri_detail12b', $emr_kornea_kiri_detail);
                $this->db->bind('emr_kamera_kanan12b', $emr_kamera_kanan);
                $this->db->bind('emr_kamera_kanan_detail12b', $emr_kamera_kanan_detail);
                $this->db->bind('emr_kamera_kiri12b', $emr_kamera_kiri);
                $this->db->bind('emr_kamera_kiri_detail12b', $emr_kamera_kiri_detail);
                $this->db->bind('emr_pupil_kanan12b', $emr_pupil_kanan);
                $this->db->bind('emr_pupil_kanan_detail12b', $emr_pupil_kanan_detail);
                $this->db->bind('emr_pupil_kiri12b', $emr_pupil_kiri);
                $this->db->bind('emr_pupil_kiri_detail12b', $emr_pupil_kiri_detail);
                $this->db->bind('emr_iris_kanan12b', $emr_iris_kanan);
                $this->db->bind('emr_iris_kanan_detail12b', $emr_iris_kanan_detail);
                $this->db->bind('emr_iris_kiri12b', $emr_iris_kiri);
                $this->db->bind('emr_iris_kiri_detail12b', $emr_iris_kiri_detail);
                $this->db->bind('emr_lensa_kanan12b', $emr_lensa_kanan);
                $this->db->bind('emr_lensa_kanan_detail12b', $emr_lensa_kanan_detail);
                $this->db->bind('emr_lensa_kiri12b', $emr_lensa_kiri);
                $this->db->bind('emr_lensa_kiri_detail12b', $emr_lensa_kiri_detail);
                $this->db->bind('emr_lainlain_kanan12b', $emr_lainlain_kanan);
                $this->db->bind('emr_lainlain_kanan_detail12b', $emr_lainlain_kanan_detail);
                $this->db->bind('emr_lainlain_kiri12b', $emr_lainlain_kiri);
                $this->db->bind('emr_lainlain_kiri_detail12b', $emr_lainlain_kiri_detail);
                $this->db->bind('emr_retina_kanan12b', $emr_retina_kanan);
                $this->db->bind('emr_retina_kanan_detail12b', $emr_retina_kanan_detail);
                $this->db->bind('emr_retina_kiri12b', $emr_retina_kiri);
                $this->db->bind('emr_retina_kiri_detail12b', $emr_retina_kiri_detail);
                $this->db->bind('emr_disknoptikus_kanan12b', $emr_disknoptikus_kanan);
                $this->db->bind('emr_disknoptikus_kanan_detail12b', $emr_disknoptikus_kanan_detail);
                $this->db->bind('emr_disknoptikus_kiri12b', $emr_disknoptikus_kiri);
                $this->db->bind('emr_disknoptikus_kiri_detail12b', $emr_disknoptikus_kiri_detail);
                $this->db->bind('emr_cdratio_kanan_detail12b', $emr_cdratio_kanan_detail);
                $this->db->bind('emr_cdratio_kiri_detail12b', $emr_cdratio_kiri_detail);
                $this->db->bind('emr_keseimbanganotot_kanan12b', $emr_keseimbanganotot_kanan);
                $this->db->bind('emr_keseimbanganotot_kanan_detail12b', $emr_keseimbanganotot_kanan_detail);
                $this->db->bind('emr_keseimbanganotot_kiri12b', $emr_keseimbanganotot_kiri);
                $this->db->bind('emr_keseimbanganotot_kiri_detail12b', $emr_keseimbanganotot_kiri_detail);
                $this->db->bind('emr_tekananintraokuler_kanan_detail12b', $emr_tekananintraokuler_kanan_detail);
                $this->db->bind('emr_tekananintraokuler_kiri_detail12b', $emr_tekananintraokuler_kiri_detail);
                $this->db->bind('emr_malulalutea_kanan12b', $emr_malulalutea_kanan);
                $this->db->bind('emr_malulalutea_kanan_detail12b', $emr_malulalutea_kanan_detail);
                $this->db->bind('emr_malulalutea_kiri12b', $emr_malulalutea_kiri);
                $this->db->bind('emr_malulalutea_kiri_detail12b', $emr_malulalutea_kiri_detail);
                $this->db->bind('emr_kompusvitreum_kanan12b', $emr_kompusvitreum_kanan);
                $this->db->bind('emr_kompusvitreum_kanan_detail12b', $emr_kompusvitreum_kanan_detail);
                $this->db->bind('emr_kompusvitreum_kiri12b', $emr_kompusvitreum_kiri);
                $this->db->bind('emr_kompusvitreum_kiri_detail12b', $emr_kompusvitreum_kiri_detail);
                $this->db->bind('emr_arterivena_kanan12b', $emr_arterivena_kanan);
                $this->db->bind('emr_arterivena_kanan_detail12b', $emr_arterivena_kanan_detail);
                $this->db->bind('emr_arterivena_kiri12b', $emr_arterivena_kiri);
                $this->db->bind('emr_arterivena_kiri_detail12b', $emr_arterivena_kiri_detail);
                $this->db->bind('emr_testbutawarna_kanan12b', $emr_testbutawarna_kanan);
                $this->db->bind('emr_testbutawarna_kanan_detail12b', $emr_testbutawarna_kanan_detail);
                $this->db->bind('emr_testbutawarna_kiri12b', $emr_testbutawarna_kiri);
                $this->db->bind('emr_testbutawarna_kiri_detail12b', $emr_testbutawarna_kiri_detail);
                $this->db->bind('emr_kesimpulan_mata12b', $emr_kesimpulan_mata);
                $this->db->bind('emr_saran_mata12b', $emr_saran_mata);
                $this->db->bind('emr_dokter_mata12b', $emr_dokter_mata);
                $this->db->execute();
            }


            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    // anamnesis
    public function setAnamnesis($data)
    {
        try {
            $this->db->transaksi();
            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $emrLevel = $session->emrLevel;
            $DoctorID = $session->DoctorID;
            $namauserx = $session->name;

            // DATA ASSESMENT MATA
            $noreg_pasien = $data['noreg_pasien'];
            $mr_pasien = $data['mr_pasien'];

            $emr_anamnesis = $data['emr_anamnesis'];
            $emr_keluhanutamaanamnesis = $data['emr_keluhanutamaanamnesis'];
            $emr_riwayatpenyakitsekarang = $data['emr_riwayatpenyakitsekarang'];
            $emr_riwayatpenyakitterdahulu = $data['emr_riwayatpenyakitterdahulu'];
            $emr_riwayatpenyakitterdahulurincian = $data['emr_riwayatpenyakitterdahulurincian'];
            $emr_pembedahan = $data['emr_pembedahan'];
            $emr_pembedahanrincian = $data['emr_pembedahanrincian'];
            $emr_riwayatrawatsebelumnya = $data['emr_riwayatrawatsebelumnya'];
            $emr_riwayatrawatsebelumnyarincian = $data['emr_riwayatrawatsebelumnyarincian'];
            $emr_adaobatrutinyangdiminum = $data['emr_adaobatrutinyangdiminum'];
            $emr_adaobatrutinyangdiminumrincian = $data['emr_adaobatrutinyangdiminumrincian'];


            if ($emrLevel <> "DOKTER") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Maaf.. Akses Login anda ' . $emrLevel . ', Form ini hanya bisa diisi Oleh Dokter !',
                );
                return $callback;
                exit;
            }
            //CEK DATA
            $this->db->query("SELECT COUNT(ID) cekEyesAssesment FROM EMR.dbo.OutpatientAnamnesis WHERE No_Registrasi = :noreg_pasien");
            $this->db->bind('noreg_pasien', $noreg_pasien);
            $dataEye =  $this->db->single();
            $cekEye = $dataEye['cekEyesAssesment'];
            if ($cekEye == "0") {
                $this->db->query("INSERT INTO EMR.dbo.OutpatientAnamnesis ([Anamnesis],[Keluhan_Utama_Anamnesis],[Riwayat_Penyakit_Sekarang],[Riwayat_Penyakit_Terdahulu],[Riwayat_Penyakit_Terdahulu_Detail],[Riwayat_Pembedahan],[Riwayat_Pembedahan_Detail],[Riwayat_Rawat_Sebelumnya],[Riwayat_Rawat_Sebelumnya_Detail],[Obat_Rutin_Dari_Rumah],[Obat_Rutin_Dari_Rumah_Detail],[No_RM],[No_Registrasi],[User_Input])
                VALUES 
                (:emr_anamnesis5a,:emr_keluhanutamaanamnesis5a,:emr_riwayatpenyakitsekarang5a,:emr_riwayatpenyakitterdahulu5a,:emr_riwayatpenyakitterdahulurincian5a,:emr_pembedahan5a,:emr_pembedahanrincian5a,:emr_riwayatrawatsebelumnya5a,:emr_riwayatrawatsebelumnyarincian5a,:emr_adaobatrutinyangdiminum5a,:emr_adaobatrutinyangdiminumrincian5a,:mr_pasien5a,:noreg_pasien5a,:namauserx5a)");
                $this->db->bind('emr_anamnesis5a', $emr_anamnesis);
                $this->db->bind('emr_keluhanutamaanamnesis5a', $emr_keluhanutamaanamnesis);
                $this->db->bind('emr_riwayatpenyakitsekarang5a', $emr_riwayatpenyakitsekarang);
                $this->db->bind('emr_riwayatpenyakitterdahulu5a', $emr_riwayatpenyakitterdahulu);
                $this->db->bind('emr_riwayatpenyakitterdahulurincian5a', $emr_riwayatpenyakitterdahulurincian);
                $this->db->bind('emr_pembedahan5a', $emr_pembedahan);
                $this->db->bind('emr_pembedahanrincian5a', $emr_pembedahanrincian);
                $this->db->bind('emr_riwayatrawatsebelumnya5a', $emr_riwayatrawatsebelumnya);
                $this->db->bind('emr_riwayatrawatsebelumnyarincian5a', $emr_riwayatrawatsebelumnyarincian);
                $this->db->bind('emr_adaobatrutinyangdiminum5a', $emr_adaobatrutinyangdiminum);
                $this->db->bind('emr_adaobatrutinyangdiminumrincian5a', $emr_adaobatrutinyangdiminumrincian);
                $this->db->bind('mr_pasien5a', $mr_pasien);
                $this->db->bind('noreg_pasien5a', $noreg_pasien);
                $this->db->bind('namauserx5a', $namauserx);
                $this->db->execute();
            } else {
                $this->db->query("UPDATE EMR.dbo.OutpatientAnamnesis SET Anamnesis = :emr_anamnesis5b, Keluhan_Utama_Anamnesis = :emr_keluhanutamaanamnesis5b, Riwayat_Penyakit_Sekarang = :emr_riwayatpenyakitsekarang5b, Riwayat_Penyakit_Terdahulu = :emr_riwayatpenyakitterdahulu5b, Riwayat_Penyakit_Terdahulu_Detail = :emr_riwayatpenyakitterdahulurincian5b, Riwayat_Pembedahan = :emr_pembedahan5b, Riwayat_Pembedahan_Detail = :emr_pembedahanrincian5b, Riwayat_Rawat_Sebelumnya = :emr_riwayatrawatsebelumnya5b, Riwayat_Rawat_Sebelumnya_Detail = :emr_riwayatrawatsebelumnyarincian5b, Obat_Rutin_Dari_Rumah = :emr_adaobatrutinyangdiminum5b, Obat_Rutin_Dari_Rumah_Detail = :emr_adaobatrutinyangdiminumrincian5b, User_Input = :namauserx5b
                WHERE No_Registrasi = :noreg_pasien5b");
                $this->db->bind('noreg_pasien5b', $noreg_pasien);
                $this->db->bind('emr_anamnesis5b', $emr_anamnesis);
                $this->db->bind('emr_keluhanutamaanamnesis5b', $emr_keluhanutamaanamnesis);
                $this->db->bind('emr_riwayatpenyakitsekarang5b', $emr_riwayatpenyakitsekarang);
                $this->db->bind('emr_riwayatpenyakitterdahulu5b', $emr_riwayatpenyakitterdahulu);
                $this->db->bind('emr_riwayatpenyakitterdahulurincian5b', $emr_riwayatpenyakitterdahulurincian);
                $this->db->bind('emr_pembedahan5b', $emr_pembedahan);
                $this->db->bind('emr_pembedahanrincian5b', $emr_pembedahanrincian);
                $this->db->bind('emr_riwayatrawatsebelumnya5b', $emr_riwayatrawatsebelumnya);
                $this->db->bind('emr_riwayatrawatsebelumnyarincian5b', $emr_riwayatrawatsebelumnyarincian);
                $this->db->bind('emr_adaobatrutinyangdiminum5b', $emr_adaobatrutinyangdiminum);
                $this->db->bind('emr_adaobatrutinyangdiminumrincian5b', $emr_adaobatrutinyangdiminumrincian);
                $this->db->bind('namauserx5b', $namauserx);
                $this->db->execute();
            }


            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    // triage covid 19
    public function setTriageCovid19($data)
    {
        try {
            $this->db->transaksi();
            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $emrLevel = $session->emrLevel;
            $DoctorID = $session->DoctorID;
            $namauserx = $session->name;

            // DATA ASSESMENT MATA
            $noreg_pasien = $data['noreg_pasien'];
            $mr_pasien = $data['mr_pasien'];

            $emr_batutenggorokantersumbat = $data['emr_batutenggorokantersumbat'];
            $emr_frekuensispo2 = $data['emr_frekuensispo2'];
            $emr_demam1 = $data['emr_demam1'];
            $emr_riwayatkontakerat = $data['emr_riwayatkontakerat'];
            $emr_riwayatperjalanan = $data['emr_riwayatperjalanan'];
            $emr_tandapeunomiadenganct = $data['emr_tandapeunomiadenganct'];
            $emr_riwayatkontakeratdenganpasiencovid = $data['emr_riwayatkontakeratdenganpasiencovid'];
            $emr_demam2 = $data['emr_demam2'];
            $emr_usialebihdarisamadengan44 = $data['emr_usialebihdarisamadengan44'];
            $emr_jeniskelamincek = $data['emr_jeniskelamincek'];
            $emr_suhumaxsejaksampai = $data['emr_suhumaxsejaksampai'];
            $emr_gejalagangguanrespirasi = $data['emr_gejalagangguanrespirasi'];
            $emr_rasioneutrofil = $data['emr_rasioneutrofil'];

            // DATA SKRINNING TBC
            $emr_adakahbatukselama2minggu = $data['emr_adakahbatukselama2minggu'];
            $emr_dahakbercampurdarah = $data['emr_dahakbercampurdarah'];
            $emr_demammerianglebihdari1bulan = $data['emr_demammerianglebihdari1bulan'];
            $emr_sesaknafas = $data['emr_sesaknafas'];
            $emr_riwayatbatukberdarah = $data['emr_riwayatbatukberdarah'];
            $emr_lemah = $data['emr_lemah'];
            $emr_badanlemas = $data['emr_badanlemas'];
            $emr_keringatmalamtanpaaktifitas = $data['emr_keringatmalamtanpaaktifitas'];
            $emr_beratbadanmenurundrastis = $data['emr_beratbadanmenurundrastis'];
            $checkbox_naskrinningtbc = $data['checkbox_naskrinningtbc'];
            $checkbox_negatif = $data['checkbox_negatif'];
            $checkbox_odp = $data['checkbox_odp'];
            $checkbox_tbc = $data['checkbox_tbc'];
            $checkbox_pinerelainnya = $data['checkbox_pinerelainnya'];

            //CEK DATA
            $this->db->query("SELECT COUNT(ID) cekEyesAssesment FROM EMR.dbo.OutpatientTriageCovid19 WHERE No_Registrasi = :noreg_pasien");
            $this->db->bind('noreg_pasien', $noreg_pasien);
            $dataEye =  $this->db->single();
            $cekEye = $dataEye['cekEyesAssesment'];
            if ($cekEye == "0") {
                $this->db->query("INSERT INTO EMR.dbo.OutpatientTriageCovid19 ([Batuk_SakitTenggorokan_HidungTersumbat],[Sesak_PeningkatanFreskuensiNafas],[Demam_1],[Riwayat_Kontak_Pasien_Covid],[Riwayat_Perjalanan],[Tanda_Pneumia],[Riwayat_Kontak_Pasien_Covid_2],[Demam_2],[Usia_Diatas_43Thn],[Jenis_Kelamin],[Suhu_Max_38C],[Gejala_Gangguan_Respirasi],[RasioNeutrofildanLimfosit_lebihdari_57],[No_RM],[No_Registrasi],[User_Input])
                VALUES (:emr_batutenggorokantersumbat3a,:emr_frekuensispo23a,:emr_demam13a,:emr_riwayatkontakerat3a,:emr_riwayatperjalanan3a,:emr_tandapeunomiadenganct3a,:emr_riwayatkontakeratdenganpasiencovid3a,:emr_demam23a,:emr_usialebihdarisamadengan443a,:emr_jeniskelamincek3a,:emr_suhumaxsejaksampai3a,:emr_gejalagangguanrespirasi3a,:emr_rasioneutrofil3a,:mr_pasien3a,:noreg_pasien3a,:namauserx3a)");
                $this->db->bind('emr_batutenggorokantersumbat3a', $emr_batutenggorokantersumbat);
                $this->db->bind('emr_frekuensispo23a', $emr_frekuensispo2);
                $this->db->bind('emr_demam13a', $emr_demam1);
                $this->db->bind('emr_riwayatkontakerat3a', $emr_riwayatkontakerat);
                $this->db->bind('emr_riwayatperjalanan3a', $emr_riwayatperjalanan);
                $this->db->bind('emr_tandapeunomiadenganct3a', $emr_tandapeunomiadenganct);
                $this->db->bind('emr_riwayatkontakeratdenganpasiencovid3a', $emr_riwayatkontakeratdenganpasiencovid);
                $this->db->bind('emr_demam23a', $emr_demam2);
                $this->db->bind('emr_usialebihdarisamadengan443a', $emr_usialebihdarisamadengan44);
                $this->db->bind('emr_jeniskelamincek3a', $emr_jeniskelamincek);
                $this->db->bind('emr_suhumaxsejaksampai3a', $emr_suhumaxsejaksampai);
                $this->db->bind('emr_gejalagangguanrespirasi3a', $emr_gejalagangguanrespirasi);
                $this->db->bind('emr_rasioneutrofil3a', $emr_rasioneutrofil);
                $this->db->bind('mr_pasien3a', $mr_pasien);
                $this->db->bind('noreg_pasien3a', $noreg_pasien);
                $this->db->bind('namauserx3a', $namauserx);
                $this->db->execute();

                $this->db->query("INSERT INTO EMR.dbo.OutpatientSkriningTBC ([NA_Skrining_TBC],[Batuk_Max_2Minggu],[Dahak_Bercampur_Darah],[DemamMeriang_Max_1Bulan],[Sesak_Nafas],
                [Riwayat_Batuk_Berdarah],[Lemah],[Badan_Lemas_Berdarah],[Keringatan_Malam_Tanpa_Aktifitas],[BB_Menurun_Drastis],
                [Kesimpulan_Negatif],[Kesimpulan_ODP_PDP],[Kesimpulan_Tuberkulosis],[Kesimpulan_Pinere_Lainnya],[No_RM],[No_Registrasi],[User_Input])
                VALUES (:checkbox_naskrinningtbc4a,:emr_adakahbatukselama2minggu4a,:emr_dahakbercampurdarah4a,:emr_demammerianglebihdari1bulan4a,:emr_sesaknafas4a,
                :emr_riwayatbatukberdarah4a,:emr_lemah4a,:emr_badanlemas4a,:emr_keringatmalamtanpaaktifitas4a,:emr_beratbadanmenurundrastis4a,:checkbox_negatif4a,:checkbox_odp4a,:checkbox_tbc4a,:checkbox_pinerelainnya4a,
                :mr_pasien4a,:noreg_pasien4a,:namauserx4a)");
                $this->db->bind('emr_adakahbatukselama2minggu4a', $emr_adakahbatukselama2minggu);
                $this->db->bind('emr_dahakbercampurdarah4a', $emr_dahakbercampurdarah);
                $this->db->bind('emr_demammerianglebihdari1bulan4a', $emr_demammerianglebihdari1bulan);
                $this->db->bind('emr_sesaknafas4a', $emr_sesaknafas);
                $this->db->bind('emr_riwayatbatukberdarah4a', $emr_riwayatbatukberdarah);
                $this->db->bind('emr_lemah4a', $emr_lemah);
                $this->db->bind('emr_badanlemas4a', $emr_badanlemas);
                $this->db->bind('emr_keringatmalamtanpaaktifitas4a', $emr_keringatmalamtanpaaktifitas);
                $this->db->bind('emr_beratbadanmenurundrastis4a', $emr_beratbadanmenurundrastis);
                $this->db->bind('mr_pasien4a', $mr_pasien);
                $this->db->bind('noreg_pasien4a', $noreg_pasien);
                $this->db->bind('namauserx4a', $namauserx);
                $this->db->bind('checkbox_naskrinningtbc4a', $checkbox_naskrinningtbc);
                $this->db->bind('checkbox_negatif4a', $checkbox_negatif);
                $this->db->bind('checkbox_odp4a', $checkbox_odp);
                $this->db->bind('checkbox_tbc4a', $checkbox_tbc);
                $this->db->bind('checkbox_pinerelainnya4a', $checkbox_pinerelainnya);
                $this->db->execute();
            } else {
                $this->db->query("UPDATE EMR.dbo.OutpatientTriageCovid19 SET Batuk_SakitTenggorokan_HidungTersumbat = :emr_batutenggorokantersumbat3b, Sesak_PeningkatanFreskuensiNafas = :emr_frekuensispo23b, Demam_1 = :emr_demam13b, Riwayat_Kontak_Pasien_Covid = :emr_riwayatkontakerat3b, Riwayat_Perjalanan = :emr_riwayatperjalanan3b, Tanda_Pneumia = :emr_tandapeunomiadenganct3b, Riwayat_Kontak_Pasien_Covid_2 = :emr_riwayatkontakeratdenganpasiencovid3b, Demam_2 = :emr_demam23b, Usia_Diatas_43Thn = :emr_usialebihdarisamadengan443b, Jenis_Kelamin = :emr_jeniskelamincek3b, Suhu_Max_38C = :emr_suhumaxsejaksampai3b, Gejala_Gangguan_Respirasi = :emr_gejalagangguanrespirasi3b, RasioNeutrofildanLimfosit_lebihdari_57 = :emr_rasioneutrofil3b, User_Input = :namauserx3b
                WHERE No_Registrasi = :noreg_pasien3b");
                $this->db->bind('noreg_pasien3b', $noreg_pasien);
                $this->db->bind('emr_batutenggorokantersumbat3b', $emr_batutenggorokantersumbat);
                $this->db->bind('emr_frekuensispo23b', $emr_frekuensispo2);
                $this->db->bind('emr_demam13b', $emr_demam1);
                $this->db->bind('emr_riwayatkontakerat3b', $emr_riwayatkontakerat);
                $this->db->bind('emr_riwayatperjalanan3b', $emr_riwayatperjalanan);
                $this->db->bind('emr_tandapeunomiadenganct3b', $emr_tandapeunomiadenganct);
                $this->db->bind('emr_riwayatkontakeratdenganpasiencovid3b', $emr_riwayatkontakeratdenganpasiencovid);
                $this->db->bind('emr_demam23b', $emr_demam2);
                $this->db->bind('emr_usialebihdarisamadengan443b', $emr_usialebihdarisamadengan44);
                $this->db->bind('emr_jeniskelamincek3b', $emr_jeniskelamincek);
                $this->db->bind('emr_suhumaxsejaksampai3b', $emr_suhumaxsejaksampai);
                $this->db->bind('emr_gejalagangguanrespirasi3b', $emr_gejalagangguanrespirasi);
                $this->db->bind('emr_rasioneutrofil3b', $emr_rasioneutrofil);
                $this->db->bind('namauserx3b', $namauserx);
                $this->db->execute();

                $this->db->query("UPDATE EMR.dbo.OutpatientSkriningTBC SET Batuk_Max_2Minggu = :emr_adakahbatukselama2minggu4b, Dahak_Bercampur_Darah = :emr_dahakbercampurdarah4b, DemamMeriang_Max_1Bulan = :emr_demammerianglebihdari1bulan4b, Sesak_Nafas = :emr_sesaknafas4b, Riwayat_Batuk_Berdarah = :emr_riwayatbatukberdarah4b, Lemah = :emr_lemah4b, Badan_Lemas_Berdarah = :emr_badanlemas4b, Keringatan_Malam_Tanpa_Aktifitas = :emr_keringatmalamtanpaaktifitas4b, BB_Menurun_Drastis = :emr_beratbadanmenurundrastis4b, User_Input = :namauserx4b, NA_Skrining_TBC = :checkbox_naskrinningtbc4b,Kesimpulan_Negatif = :checkbox_negatif4b,Kesimpulan_ODP_PDP = :checkbox_odp4b,Kesimpulan_Tuberkulosis = :checkbox_tbc4b,Kesimpulan_Pinere_Lainnya = :checkbox_pinerelainnya4b
                WHERE No_Registrasi = :noreg_pasien4b");
                $this->db->bind('noreg_pasien4b', $noreg_pasien);
                $this->db->bind('emr_adakahbatukselama2minggu4b', $emr_adakahbatukselama2minggu);
                $this->db->bind('emr_dahakbercampurdarah4b', $emr_dahakbercampurdarah);
                $this->db->bind('emr_demammerianglebihdari1bulan4b', $emr_demammerianglebihdari1bulan);
                $this->db->bind('emr_sesaknafas4b', $emr_sesaknafas);
                $this->db->bind('emr_riwayatbatukberdarah4b', $emr_riwayatbatukberdarah);
                $this->db->bind('emr_lemah4b', $emr_lemah);
                $this->db->bind('emr_badanlemas4b', $emr_badanlemas);
                $this->db->bind('emr_keringatmalamtanpaaktifitas4b', $emr_keringatmalamtanpaaktifitas);
                $this->db->bind('emr_beratbadanmenurundrastis4b', $emr_beratbadanmenurundrastis);
                $this->db->bind('namauserx4b', $namauserx);

                $this->db->bind('checkbox_naskrinningtbc4b', $checkbox_naskrinningtbc);
                $this->db->bind('checkbox_negatif4b', $checkbox_negatif);
                $this->db->bind('checkbox_odp4b', $checkbox_odp);
                $this->db->bind('checkbox_tbc4b', $checkbox_tbc);
                $this->db->bind('checkbox_pinerelainnya4b', $checkbox_pinerelainnya);
                $this->db->execute();
            }


            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    // spiritual
    public function setSpiritual($data)
    {
        try {
            $this->db->transaksi();
            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $emrLevel = $session->emrLevel;
            $DoctorID = $session->DoctorID;
            $namauserx = $session->name;

            // DATA SPIRITUAL
            $noreg_pasien = $data['noreg_pasien'];
            $mr_pasien = $data['mr_pasien'];

            $emr_tingkkatpendidikan = $data['emr_tingkkatpendidikan'];
            $emr_tingkkatpendidikanselain = $data['emr_tingkkatpendidikanselain'];
            $emr_pekerjaansaatini = $data['emr_pekerjaansaatini'];
            $emr_pekerjaansaatiniselain = $data['emr_pekerjaansaatiniselain'];
            $emr_tinggalsaatini = $data['emr_tinggalsaatini'];
            $emr_tinggalsaatiniselain = $data['emr_tinggalsaatiniselain'];
            $emr_agamasaatini = $data['emr_agamasaatini'];
            $emr_agamasaatiniselain = $data['emr_agamasaatiniselain'];
            $emr_hambatanmenjalankanibadah = $data['emr_hambatanmenjalankanibadah'];
            $emr_hambatanmenjalankanibadahket = $data['emr_hambatanmenjalankanibadahket'];
            $emr_nilaikepercayaandiriyangdianut = $data['emr_nilaikepercayaandiriyangdianut'];
            $emr_nilaikepercayaandiriyangdianutket = $data['emr_nilaikepercayaandiriyangdianutket'];
            $emr_pantangmakanananminuman = $data['emr_pantangmakanananminuman'];
            $emr_pantangmakanananminumanket = $data['emr_pantangmakanananminumanket'];
            $emr_riwayattindakkekerasan = $data['emr_riwayattindakkekerasan'];
            $emr_riwayattindakkekerasanket = $data['emr_riwayattindakkekerasanket'];

            $checkbox_emr_tenang = $data['checkbox_emr_tenang'];
            $checkbox_emr_sedihmenangis = $data['checkbox_emr_sedihmenangis'];
            $checkbox_emr_cemasgelisah = $data['checkbox_emr_cemasgelisah'];
            $checkbox_emr_takutsekitar = $data['checkbox_emr_takutsekitar'];
            $checkbox_emr_mudahmarah = $data['checkbox_emr_mudahmarah'];

            //CEK DATA
            $this->db->query("SELECT COUNT(ID) cekEyesAssesment FROM EMR.dbo.OutpatientPsikososialEkonomiSpiritual WHERE No_Registrasi = :noreg_pasien");
            $this->db->bind('noreg_pasien', $noreg_pasien);
            $dataEye =  $this->db->single();
            $cekEye = $dataEye['cekEyesAssesment'];
            if ($cekEye == "0") {
                $this->db->query("INSERT INTO EMR.dbo.OutpatientPsikososialEkonomiSpiritual 
                ([TingkatPendidikan],[TingkatPendidikan_Detail],[Pekerjaan],[Pekerjaan_Detail],[Tinggal_Bersama],
                [Tinggal_Bersama_Detail],[Tenang],[Sedih_Menangis_MenarikDiri],[Cemas_Gelisah],[TakutTerapi_Tindakan_Lingkungan],[Marah_Mudah_Tersinggung],[Agama],[Agama_Detail],
                [Hambatan_Menjalankan_Ibadah],[Hambatan_Menjalankan_Ibadah_Detail],[Nilai_Kepercayaan_Dianut],[Nilai_Kepercayaan_Dianut_Detail],
                [Pantang_Makanan_Minuman],[Pantang_Makanan_Minuman_Detail],[Riwayat_Tindak_Kekerasan],[Riwayat_Tindak_Kekerasan_Detail],
                [No_RM],[No_Registrasi],[User_Input])
                VALUES
                (:emr_tingkkatpendidikan9a,:emr_tingkkatpendidikanselain9a,:emr_pekerjaansaatini9a,:emr_pekerjaansaatiniselain9a,:emr_tinggalsaatini9a,
                :emr_tinggalsaatiniselain9a,
                :checkbox_emr_tenang9a,
                :checkbox_emr_sedihmenangis9a,
                :checkbox_emr_cemasgelisah9a,
                :checkbox_emr_takutsekitar9a,
                :checkbox_emr_mudahmarah9a,
                :emr_agamasaatini9a,:emr_agamasaatiniselain9a,
                :emr_hambatanmenjalankanibadah9a,:emr_hambatanmenjalankanibadahket9a,:emr_nilaikepercayaandiriyangdianut9a,:emr_nilaikepercayaandiriyangdianutket9a,
                :emr_pantangmakanananminuman9a,:emr_pantangmakanananminumanket9a,:emr_riwayattindakkekerasan9a,:emr_riwayattindakkekerasanket9a,
                :mr_pasien9a,:noreg_pasien9a,:namauserx9a)");
                $this->db->bind('emr_tingkkatpendidikan9a', $emr_tingkkatpendidikan);
                $this->db->bind('emr_tingkkatpendidikanselain9a', $emr_tingkkatpendidikanselain);
                $this->db->bind('emr_pekerjaansaatini9a', $emr_pekerjaansaatini);
                $this->db->bind('emr_pekerjaansaatiniselain9a', $emr_pekerjaansaatiniselain);
                $this->db->bind('emr_tinggalsaatini9a', $emr_tinggalsaatini);
                $this->db->bind('emr_tinggalsaatiniselain9a', $emr_tinggalsaatiniselain);
                $this->db->bind('emr_agamasaatini9a', $emr_agamasaatini);
                $this->db->bind('emr_agamasaatiniselain9a', $emr_agamasaatiniselain);
                $this->db->bind('emr_hambatanmenjalankanibadah9a', $emr_hambatanmenjalankanibadah);
                $this->db->bind('emr_hambatanmenjalankanibadahket9a', $emr_hambatanmenjalankanibadahket);
                $this->db->bind('emr_nilaikepercayaandiriyangdianut9a', $emr_nilaikepercayaandiriyangdianut);
                $this->db->bind('emr_nilaikepercayaandiriyangdianutket9a', $emr_nilaikepercayaandiriyangdianutket);
                $this->db->bind('emr_pantangmakanananminuman9a', $emr_pantangmakanananminuman);
                $this->db->bind('emr_pantangmakanananminumanket9a', $emr_pantangmakanananminumanket);
                $this->db->bind('emr_riwayattindakkekerasan9a', $emr_riwayattindakkekerasan);
                $this->db->bind('emr_riwayattindakkekerasanket9a', $emr_riwayattindakkekerasanket);
                $this->db->bind('mr_pasien9a', $mr_pasien);
                $this->db->bind('noreg_pasien9a', $noreg_pasien);
                $this->db->bind('namauserx9a', $namauserx);

                $this->db->bind('checkbox_emr_tenang9a', $checkbox_emr_tenang);
                $this->db->bind('checkbox_emr_sedihmenangis9a', $checkbox_emr_sedihmenangis);
                $this->db->bind('checkbox_emr_cemasgelisah9a', $checkbox_emr_cemasgelisah);
                $this->db->bind('checkbox_emr_takutsekitar9a', $checkbox_emr_takutsekitar);
                $this->db->bind('checkbox_emr_mudahmarah9a', $checkbox_emr_mudahmarah);
                $this->db->execute();
            } else {
                $this->db->query("UPDATE EMR.dbo.OutpatientPsikososialEkonomiSpiritual SET
                TingkatPendidikan = :emr_tingkkatpendidikan9b,
                TingkatPendidikan_Detail = :emr_tingkkatpendidikanselain9b,
                Pekerjaan = :emr_pekerjaansaatini9b,
                Pekerjaan_Detail = :emr_pekerjaansaatiniselain9b,
                Tinggal_Bersama = :emr_tinggalsaatini9b,
                Tinggal_Bersama_Detail = :emr_tinggalsaatiniselain9b,
                Agama = :emr_agamasaatini9b,
                Agama_Detail = :emr_agamasaatiniselain9b,
                Hambatan_Menjalankan_Ibadah = :emr_hambatanmenjalankanibadah9b,
                Hambatan_Menjalankan_Ibadah_Detail = :emr_hambatanmenjalankanibadahket9b,
                Nilai_Kepercayaan_Dianut = :emr_nilaikepercayaandiriyangdianut9b,
                Nilai_Kepercayaan_Dianut_Detail = :emr_nilaikepercayaandiriyangdianutket9b,
                Pantang_Makanan_Minuman = :emr_pantangmakanananminuman9b,
                Pantang_Makanan_Minuman_Detail = :emr_pantangmakanananminumanket9b,
                Riwayat_Tindak_Kekerasan = :emr_riwayattindakkekerasan9b,
                Riwayat_Tindak_Kekerasan_Detail = :emr_riwayattindakkekerasanket9b,
                User_Input = :namauserx9b,
                Tenang = :checkbox_emr_tenang9B,
                Sedih_Menangis_MenarikDiri = :checkbox_emr_sedihmenangis9B,
                Cemas_Gelisah = :checkbox_emr_cemasgelisah9B,
                TakutTerapi_Tindakan_Lingkungan = :checkbox_emr_takutsekitar9B,
                Marah_Mudah_Tersinggung = :checkbox_emr_mudahmarah9B
                WHERE No_Registrasi = :noreg_pasien9b");
                $this->db->bind('noreg_pasien9b', $noreg_pasien);
                $this->db->bind('emr_tingkkatpendidikan9b', $emr_tingkkatpendidikan);
                $this->db->bind('emr_tingkkatpendidikanselain9b', $emr_tingkkatpendidikanselain);
                $this->db->bind('emr_pekerjaansaatini9b', $emr_pekerjaansaatini);
                $this->db->bind('emr_pekerjaansaatiniselain9b', $emr_pekerjaansaatiniselain);
                $this->db->bind('emr_tinggalsaatini9b', $emr_tinggalsaatini);
                $this->db->bind('emr_tinggalsaatiniselain9b', $emr_tinggalsaatiniselain);
                $this->db->bind('emr_agamasaatini9b', $emr_agamasaatini);
                $this->db->bind('emr_agamasaatiniselain9b', $emr_agamasaatiniselain);
                $this->db->bind('emr_hambatanmenjalankanibadah9b', $emr_hambatanmenjalankanibadah);
                $this->db->bind('emr_hambatanmenjalankanibadahket9b', $emr_hambatanmenjalankanibadahket);
                $this->db->bind('emr_nilaikepercayaandiriyangdianut9b', $emr_nilaikepercayaandiriyangdianut);
                $this->db->bind('emr_nilaikepercayaandiriyangdianutket9b', $emr_nilaikepercayaandiriyangdianutket);
                $this->db->bind('emr_pantangmakanananminuman9b', $emr_pantangmakanananminuman);
                $this->db->bind('emr_pantangmakanananminumanket9b', $emr_pantangmakanananminumanket);
                $this->db->bind('emr_riwayattindakkekerasan9b', $emr_riwayattindakkekerasan);
                $this->db->bind('emr_riwayattindakkekerasanket9b', $emr_riwayattindakkekerasanket);
                $this->db->bind('namauserx9b', $namauserx);

                $this->db->bind('checkbox_emr_tenang9B', $checkbox_emr_tenang);
                $this->db->bind('checkbox_emr_sedihmenangis9B', $checkbox_emr_sedihmenangis);
                $this->db->bind('checkbox_emr_cemasgelisah9B', $checkbox_emr_cemasgelisah);
                $this->db->bind('checkbox_emr_takutsekitar9B', $checkbox_emr_takutsekitar);
                $this->db->bind('checkbox_emr_mudahmarah9B', $checkbox_emr_mudahmarah);
                $this->db->execute();
            }


            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function getDataListProductObat($data)
    {
        try {
            $noreg = $data['noreg_pasien'];
            $query = "SELECT ID, [Product Name] AS ProductName, 
            [Unit Satuan] AS UnitSatuan, [Product Code] AS ProductCode FROM [Apotik_V1.1SQL].dbo.Products ";
            $this->db->query($query);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['ID'] = $key['ID'];
                $pasing['ProductName'] = $key['ProductName'];
                $pasing['UnitSatuan'] = $key['UnitSatuan'];
                $pasing['ProductCode'] = $key['ProductCode'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataListResepByNoreg($data)
    {
        try {
            $noreg = $data['noreg_pasien'];
            $query = "SELECT b.ID, b.IdOrderResep, b.NamaBarang, b.QryOrder, b.QryRealisasi, b.Signa, a.StatusResep FROM [Apotik_V1.1SQL].dbo.OrderResep a
            INNER JOIN [Apotik_V1.1SQL].dbo.OrderResepDetail b on b.IdOrderResep = a.ID
            WHERE NoRegistrasi = :noreg AND b.Batal = '0'";
            $this->db->query($query);
            $this->db->bind('noreg', $noreg);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['ID'] = $key['ID'];
                $pasing['IdOrderResep'] = $key['IdOrderResep'];
                $pasing['NamaBarang'] = $key['NamaBarang'];
                $pasing['QryOrder'] = $key['QryOrder'];
                $pasing['QryRealisasi'] = $key['QryRealisasi'];
                $pasing['Signa'] = $key['Signa'];
                $pasing['StatusResep'] = $key['StatusResep'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataDetailResepByIDHDR($data)
    {
        try {
            $idhdr = $data['idhdr'];
            $this->db->query("SELECT ID, replace(CONVERT(VARCHAR(11), TglResep, 111), '/','-') as TglResep, UserOrder, NamaUserOrder, JenisResep, UnitOrder, NamaUnitOrder, Iter  FROM [Apotik_V1.1SQL].dbo.OrderResep WHERE ID = :idhdr");
            $this->db->bind('idhdr', $idhdr);
            $key =  $this->db->single();
            $pasing['ID'] = $key['ID'];
            $pasing['TglResep'] = $key['TglResep'];
            $pasing['UserOrder'] = $key['UserOrder'];
            $pasing['NamaUserOrder'] = $key['NamaUserOrder'];
            $pasing['JenisResep'] = $key['JenisResep'];
            $pasing['UnitOrder'] = $key['UnitOrder'];
            $pasing['NamaUnitOrder'] = $key['NamaUnitOrder'];
            $pasing['Iter'] = $key['Iter'];
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataListResepByIDHDR($data)
    {
        try {
            $idhdr = $data['idhdr'];
            $query = "SELECT ID, Racik, NamaBarang, QryOrder, Signa FROM [Apotik_V1.1SQL].dbo.OrderResepDetail WHERE IdOrderResep  = :idhdr AND Batal = '0'";
            $this->db->query($query);
            $this->db->bind('idhdr', $idhdr);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['ID'] = $key['ID'];
                $pasing['Racik'] = $key['Racik'];
                $pasing['NamaBarang'] = $key['NamaBarang'];
                $pasing['QryOrder'] = $key['QryOrder'];
                $pasing['Signa'] = $key['Signa'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // setDeleteDetailResepByID
    public function setDeleteDetailResepByID($data)
    {
        try {
            $this->db->transaksi();

            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            // DATA MASALAH KEPERAWAWATAN
            $iddetail = $data['iddetail'];

            $this->db->query("UPDATE [Apotik_V1.1SQL].dbo.OrderResepDetail SET Batal = '1', PetugasBatal = :namauserx, TglBatal = :datenowcreate WHERE ID =:iddetail");
            $this->db->bind('iddetail', $iddetail);
            $this->db->bind('namauserx', $namauserx);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->execute();
            $this->db->commit();

            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    // setSaveGetNewOrderResep
    // 'data' => $pasing

    public function setSaveGetNewOrderResep($data)
    {
        try {
            $this->db->transaksi();

            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $datebills  = date('dmy', strtotime($datenowcreate));
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;

            // var_dump($datenowx);
            // exit;
            // DATA RESEP

            $emr_nomr_resep = $data['emr_nomr_resep'];
            $emr_namapasien_resep = $data['emr_namapasien_resep'];

            $emr_episode_resep = $data['emr_episode_resep'];
            $emr_noreg_resep = $data['emr_noreg_resep'];

            $emr_iduserentri_resep = $data['emr_iduserentri_resep'];
            $emr_userentri_resep = $data['emr_userentri_resep'];

            $emr_dpjp_resep = $data['emr_dpjp_resep'];

            $emr_idunit_resep = $data['emr_idunit_resep'];
            $emr_unit_resep = $data['emr_unit_resep'];

            $this->db->query("SELECT TOP 1 ID,right( OrderCode  ,5) as urut 
            FROM [Apotik_V1.1SQL].dbo.OrderResep
            WHERE OrderCode LIKE 'ASSN%' ORDER BY urut DESC
            ");
            $datax =  $this->db->single();
            $this->db->execute();
            //no urut reg
            $nexturut = $datax['urut'];
            $nexturut++;
            $nourutfix = Utils::generateAutoNumber($nexturut);
            // var_dump($nourutfix);
            // exit;
            $kodeawal = "ASSN";
            $ordercode = $kodeawal . $nourutfix;



            $this->db->query("INSERT INTO [Apotik_V1.1SQL].dbo.OrderResep (
                [JenisResep], [NoEpisode], [NoRegistrasi], [NoMR], [TglResep], [UnitOrder], [NamaUnitOrder], [UserOrder], [NamaUserOrder], [IDCppt], [StatusResep], 
                [IsPaket], [Iter], [IterRealisasi], [HasilReview], [TglReview], [PetugasReview], [NamaPetugasReview], [IsRacik], [Batal], [PetugasBatal], [TglBatal], 
                [AlasanBatal], [RR_Identitas], [RR_Obat], [RR_Dosis], [RR_Aturan], [RR_Waktu], [RR_Duplikasi], [RR_Alergi], [RR_Interaksi], [RR_BeratBadan], [RR_KontraIndikasi], 
                [RO_Identitas], [RO_Obat], [RO_Dosis], [RO_Rute], [RO_Waktu], [OrderCode]
            )
            VALUES (
                '', :emr_episode_resep, :emr_noreg_resep, :emr_nomr_resep, :datenowcreate, :emr_idunit_resep, :emr_unit_resep, :emr_iduserentri_resep, :emr_userentri_resep, '', '0', 
                '', '', '', '', '', '', '', '', '0', '', '', 
                '', '', '', '', '', '', '', '', '', '', '', 
                '', '', '', '', '', :ordercode
            )");
            $this->db->bind('emr_episode_resep', $emr_episode_resep);
            $this->db->bind('emr_noreg_resep', $emr_noreg_resep);
            $this->db->bind('emr_nomr_resep', $emr_nomr_resep);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('emr_idunit_resep', $emr_idunit_resep);
            $this->db->bind('emr_unit_resep', $emr_unit_resep);
            $this->db->bind('emr_iduserentri_resep', $emr_iduserentri_resep);
            $this->db->bind('emr_userentri_resep', $emr_userentri_resep);
            $this->db->bind('ordercode', $ordercode);
            $this->db->execute();

            $this->db->query("SELECT ID FROM [Apotik_V1.1SQL].dbo.OrderResep WHERE OrderCode = :ordercode1");
            $this->db->bind('ordercode1', $ordercode);
            $dataidbyordercode =  $this->db->single();
            $this->db->execute();
            $GENID = $dataidbyordercode['ID'];

            $pasing['GenID'] = $GENID;

            // var_dump($GENID);
            // exit;

            $this->db->commit();

            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function newSetTambahResepDetail($data)
    {
        try {
            $this->db->transaksi();

            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            // DATA RESEP

            $emr_orderid_resep = $data['emr_orderid_resep'];
            $emr_productcode_resep = $data['emr_productcode_resep'];
            $emr_namaobat_resep = $data['emr_namaobat_resep'];
            $emr_qty_resep = $data['emr_qty_resep'];
            $emr_signa_resep = $data['emr_signa_resep'];

            if ($emr_productcode_resep == '') {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Transaksi gagal, Obat belum dipilih',
                );
                echo json_encode($callback);
                exit;
            }

            if ($emr_qty_resep == '' || $emr_signa_resep == '') {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Transaksi gagal, Qty atau Signa belum terisi',
                );
                echo json_encode($callback);
                exit;
            }

            // var_dump($data);
            // exit;
            $this->db->query("INSERT INTO [Apotik_V1.1SQL].dbo.OrderResepDetail (
                [IdOrderResep], [KodeBarang], [NamaBarang], [QryOrder], [QryRealisasi], [Signa], [SignaTerjemahan], 
                [Keterangan], [Review], [HasilReview], [Batal], [TglBatal], [PetugasBatal], [Racik], [Header]
            )
            VALUES (
                :emr_orderid_resep, :emr_productcode_resep, :emr_namaobat_resep, :emr_qty_resep, NULL, :emr_signa_resep, '', 
                '', 0, '', 0, '', '', 0, 0
            )
            ");
            $this->db->bind('emr_orderid_resep', $emr_orderid_resep);
            $this->db->bind('emr_productcode_resep', $emr_productcode_resep);
            $this->db->bind('emr_namaobat_resep', $emr_namaobat_resep);
            $this->db->bind('emr_qty_resep', $emr_qty_resep);
            $this->db->bind('emr_signa_resep', $emr_signa_resep);
            $this->db->execute();

            $this->db->commit();

            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function SetUpdateFinalResepDokter($data)
    {
        try {
            $this->db->transaksi();

            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            // DATA RESEP
            // var_dump($data);
            // exit;
            $emr_orderid_resep = $data['emr_orderid_resep'];
            $emr_jenis_resep = $data['emr_jenis_resep'];
            $emr_iter_resep = $data['emr_iter_resep'];

            if ($emr_jenis_resep == '' || $emr_iter_resep == '') {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Transaksi gagal, Jenis Resep atau Iter belum terisi',
                );
                echo json_encode($callback);
                exit;
            }

            $this->db->query("UPDATE [Apotik_V1.1SQL].dbo.OrderResep SET JenisResep = :emr_jenis_resep, Iter = :emr_iter_resep WHERE ID = :emr_orderid_resep");
            $this->db->bind('emr_orderid_resep', $emr_orderid_resep);
            $this->db->bind('emr_jenis_resep', $emr_jenis_resep);
            $this->db->bind('emr_iter_resep', $emr_iter_resep);
            $this->db->execute();

            $this->db->commit();

            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }


    public function SetNewResepDetailHeader($data)
    {
        try {
            $this->db->transaksi();

            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            // DATA RESEP

            $emr_orderid_resep = $data['emr_orderid_resep'];
            $emr_jenis_resepracik = $data['emr_jenis_resepracik'];
            $emr_signa_resepracik = $data['emr_signa_resepracik'];
            $emr_qty_resepracik = $data['emr_qty_resepracik'];

            if ($emr_jenis_resepracik == '' || $emr_signa_resepracik == '' || $emr_qty_resepracik == '') {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Transaksi gagal, Jenis Racik / Qty / Signa Belum terisi',
                );
                echo json_encode($callback);
                exit;
            }

            $this->db->query("SELECT TOP 1 ID, racik as urut 
            FROM [Apotik_V1.1SQL].dbo.OrderResepDetail
            WHERE Racik != '0' AND IdOrderResep =:emr_orderid_resep ORDER BY urut DESC");
            $this->db->bind('emr_orderid_resep', $emr_orderid_resep);
            $datax =  $this->db->single();
            $this->db->execute();
            //no urut reg
            $nexturut = $datax['urut'];
            $nexturut++;

            // var_dump($nexturut);
            // exit;

            $this->db->query("INSERT INTO [Apotik_V1.1SQL].dbo.OrderResepDetail (
                [IdOrderResep], [KodeBarang], [NamaBarang], [QryOrder], [QryRealisasi], [Signa], [SignaTerjemahan], 
                [Keterangan], [Review], [HasilReview], [Batal], [TglBatal], [PetugasBatal], [Racik], [Header]
            )
            VALUES (
                :emr_orderid_resep, NULL, :emr_jenis_resepracik, :emr_qty_resepracik, NULL, :emr_signa_resepracik, '', 
                '', 0, '', 0, '', '', :nexturut, 1
            )
            ");
            $this->db->bind('emr_orderid_resep', $emr_orderid_resep);
            $this->db->bind('nexturut', $nexturut);
            $this->db->bind('emr_jenis_resepracik', $emr_jenis_resepracik);
            $this->db->bind('emr_qty_resepracik', $emr_qty_resepracik);
            $this->db->bind('emr_signa_resepracik', $emr_signa_resepracik);
            $this->db->execute();

            $pasing['nexturut'] = $nexturut;

            $this->db->commit();

            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function getDataListResepByIDHDRRacik($data)
    {
        try {
            $idhdr = $data['idhdr'];
            $noracik = $data['noracik'];
            $query = "SELECT ID, Racik, NamaBarang, QryOrder, Signa FROM [Apotik_V1.1SQL].dbo.OrderResepDetail WHERE IdOrderResep  = :idhdr AND Batal = '0' AND Racik = :noracik AND Header = '0'";
            $this->db->query($query);
            $this->db->bind('idhdr', $idhdr);
            $this->db->bind('noracik', $noracik);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['ID'] = $key['ID'];
                $pasing['Racik'] = $key['Racik'];
                $pasing['NamaBarang'] = $key['NamaBarang'];
                $pasing['QryOrder'] = $key['QryOrder'];
                $pasing['Signa'] = $key['Signa'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function newSetTambahResepDetailRacikObat($data)
    {
        try {
            $this->db->transaksi();

            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            // DATA RESEP

            $emr_orderid_resep = $data['emr_orderid_resep'];
            $emr_number_resepracik = $data['emr_number_resepracik'];
            $emr_productcode_resepracikdetail = $data['emr_productcode_resepracikdetail'];
            $emr_namaobat_resepracikdetail = $data['emr_namaobat_resepracikdetail'];
            $emr_satuan_resepracikdetail = $data['emr_satuan_resepracikdetail'];
            $emr_qty_resepracikdetail = $data['emr_qty_resepracikdetail'];



            if ($emr_number_resepracik == '') {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Transaksi gagal, header racikan belum dibuat',
                );
                echo json_encode($callback);
                exit;
            }

            if ($emr_productcode_resepracikdetail == '') {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Transaksi gagal, obat belum dipilih',
                );
                echo json_encode($callback);
                exit;
            }

            if ($emr_qty_resepracikdetail == '') {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Transaksi gagal, Qty belum terisi',
                );
                echo json_encode($callback);
                exit;
            }

            $this->db->query("INSERT INTO [Apotik_V1.1SQL].dbo.OrderResepDetail (
                [IdOrderResep], [KodeBarang], [NamaBarang], [QryOrder], [QryRealisasi], [Signa], [SignaTerjemahan], 
                [Keterangan], [Review], [HasilReview], [Batal], [TglBatal], [PetugasBatal], [Racik], [Header]
            )
            VALUES (
                :emr_orderid_resep, :emr_productcode_resepracikdetail, :emr_namaobat_resepracikdetail, :emr_qty_resepracikdetail, NULL, '', '', 
                '', 0, '', 0, '', '', :emr_number_resepracik, 0
            )
            ");
            $this->db->bind('emr_orderid_resep', $emr_orderid_resep);
            $this->db->bind('emr_productcode_resepracikdetail', $emr_productcode_resepracikdetail);
            $this->db->bind('emr_namaobat_resepracikdetail', $emr_namaobat_resepracikdetail);
            $this->db->bind('emr_qty_resepracikdetail', $emr_qty_resepracikdetail);
            $this->db->bind('emr_number_resepracik', $emr_number_resepracik);
            $this->db->execute();

            $pasing['numberracik'] = $emr_number_resepracik;

            $this->db->commit();

            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function searchdiagnosaICD10($data)
    {
        try {

            $textPencarian = $data['searchTerm'];
            $query = "SELECT id,ICD_CODE,DESCRIPTION FROM MasterdataSQL.DBO.ICDX
                     where DESCRIPTION like '%'+:keyword+'%' ";
            $this->db->query($query);
            $this->db->bind('keyword',   $textPencarian);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['id'] = $key['id'];
                $pasing['label'] = $key['ICD_CODE'] . ' - ' . $key['DESCRIPTION'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function insertICD10Utama($data)
    {
        try {
            $this->db->transaksi();

            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;

            // DATA  
            $NoRegistrasi =  $data['NoRegistrasi'];
            $idicd = $data['idicd'];
            $emrLevel = $session->emrLevel;
            if ($emrLevel <> "DOKTER") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Maaf.. Akses Login anda ' . $emrLevel . ', Form ini hanya bisa diisi Oleh Dokter !',
                );
                return $callback;
                exit;
            }
            //CEK DATA
            $this->db->query("SELECT COUNT(ID) cekEyesAssesment FROM MasterdataSQL.DBO.ICDX_Transactions 
                            WHERE NoRegistrasi = :noreg_pasien and header = :header and status = :status");
            $this->db->bind('noreg_pasien', $NoRegistrasi);
            $this->db->bind('status', '1');
            $this->db->bind('header', '1');
            $dataEy =  $this->db->single();
            if ($dataEy['cekEyesAssesment'] > 0) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Diagnosa Utama Sudah ada.',
                );
                return $callback;
                exit;
            }
            $this->db->query("INSERT INTO MasterdataSQL.DBO.ICDX_Transactions 
                            (id_icd,NoRegistrasi,Petugas_Input, Waktu_input,status, header)
                            VALUES (:id_icd,:NoRegistrasi,:Petugas_Input,:Waktu_input,:status, :header)");
            $this->db->bind('id_icd', $idicd);
            $this->db->bind('NoRegistrasi', $NoRegistrasi);
            $this->db->bind('Petugas_Input', $namauserx);
            $this->db->bind('Waktu_input', $datenowcreate);
            $this->db->bind('status', '1');
            $this->db->bind('header', '1');
            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
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
    public function listICD10Utama($data)
    {
        try {
            $noreg = $data['noreg_pasien'];
            $query = "SELECT ICDX_Transactions.id, ICDX_Transactions.id_icd, ICDX.DESCRIPTION, ICDX_Transactions.NoRegistrasi, ICDX_Transactions.header, ICDX.ICD_CODE
            FROM MasterdataSQL.dbo.ICDX_Transactions LEFT JOIN MasterdataSQL.dbo.ICDX ON ICDX_Transactions.id_icd = ICDX.ID
            WHERE  ICDX_Transactions.NoRegistrasi =:noreg AND ICDX_Transactions.header=1";
            $this->db->query($query);
            $this->db->bind('noreg', $noreg);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['id'] = $key['id'];
                $pasing['id_icd'] = $key['id_icd'];
                $pasing['DESCRIPTION'] = $key['id_icd'] . ' - ' . $key['DESCRIPTION'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function searchdiagnosaICD9($data)
    {
        try {
            $textPencarian = $data['searchTerm'];
            $query = "SELECT id,ICD_CODE,DESCRIPTION FROM MasterdataSQL.DBO.ICDX_9
                     where DESCRIPTION like '%'+:keyword+'%' ";
            $this->db->query($query);
            $this->db->bind('keyword',   $textPencarian);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['id'] = $key['id'];
                $pasing['label'] = $key['ICD_CODE'] . ' - ' . $key['DESCRIPTION'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function insertICD10sekunder($data)
    {
        try {
            $this->db->transaksi();

            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;

            // DATA  
            $NoRegistrasi =  $data['NoRegistrasi'];
            $idicd = $data['idicd'];
            if ($emrLevel <> "DOKTER") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Maaf.. Akses Login anda ' . $emrLevel . ', Form ini hanya bisa diisi Oleh Dokter !',
                );
                return $callback;
                exit;
            }
            //CEK DATA
            $this->db->query("SELECT COUNT(ID) cekEyesAssesment FROM MasterdataSQL.DBO.ICDX_Transactions 
                            WHERE NoRegistrasi = :noreg_pasien and id_icd = :id_icd and header = :header and status=:status");
            $this->db->bind('noreg_pasien', $NoRegistrasi);
            $this->db->bind('id_icd', $idicd);
            $this->db->bind('header', '0');
            $this->db->bind('status', '1');
            $this->db->execute();
            $dataEy =  $this->db->single();
            if ($dataEy['cekEyesAssesment'] > 0) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Diagnosa Sekunder sudah ada!',
                );
                return $callback;
                exit;
            }
            $this->db->query("INSERT INTO MasterdataSQL.DBO.ICDX_Transactions 
                            (id_icd,NoRegistrasi,Petugas_Input, Waktu_input,status, header)
                            VALUES (:id_icd,:NoRegistrasi,:Petugas_Input,:Waktu_input,:status, :header)");
            $this->db->bind('id_icd', $idicd);
            $this->db->bind('NoRegistrasi', $NoRegistrasi);
            $this->db->bind('Petugas_Input', $namauserx);
            $this->db->bind('Waktu_input', $datenowcreate);
            $this->db->bind('status', '1');
            $this->db->bind('header', '0');
            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
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
    public function listICD10Sekunder($data)
    {
        try {
            $noreg = $data['noreg_pasien'];
            $query = "SELECT ICDX_Transactions.id, ICDX_Transactions.id_icd, ICDX.DESCRIPTION, ICDX_Transactions.NoRegistrasi, ICDX_Transactions.header, ICDX.ICD_CODE
            FROM MasterdataSQL.dbo.ICDX_Transactions LEFT JOIN MasterdataSQL.dbo.ICDX ON ICDX_Transactions.id_icd = ICDX.ID
            WHERE  ICDX_Transactions.NoRegistrasi =:noreg AND ICDX_Transactions.header=0";
            $this->db->query($query);
            $this->db->bind('noreg', $noreg);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['id'] = $key['id'];
                $pasing['id_icd'] = $key['id_icd'];
                $pasing['DESCRIPTION'] = $key['id_icd'] . ' - ' . $key['DESCRIPTION'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function insertICDTindakan($data)
    {
        try {
            $this->db->transaksi();

            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;

            // DATA  
            $NoRegistrasi =  $data['NoRegistrasi'];
            $idicd = $data['idicd'];
            if ($emrLevel <> "DOKTER") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Maaf.. Akses Login anda ' . $emrLevel . ', Form ini hanya bisa diisi Oleh Dokter !',
                );
                return $callback;
                exit;
            }
            //CEK DATA
            $this->db->query("SELECT COUNT(ID) cekEyesAssesment FROM MasterdataSQL.DBO.ICDX_Transactions_9 
                            WHERE NoRegistrasi = :noreg_pasien and id_icd = :id_icd and header = :header and status=:status");
            $this->db->bind('noreg_pasien', $NoRegistrasi);
            $this->db->bind('id_icd', $idicd);
            $this->db->bind('header', '0');
            $this->db->bind('status', '1');
            $this->db->execute();
            $dataEy =  $this->db->single();
            if ($dataEy['cekEyesAssesment'] > 0) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Diagnosa sudah ada!',
                );
                return $callback;
                exit;
            }
            $this->db->query("INSERT INTO MasterdataSQL.DBO.ICDX_Transactions_9 
                            (id_icd,NoRegistrasi,Petugas_Input, Waktu_input,status, header)
                            VALUES (:id_icd,:NoRegistrasi,:Petugas_Input,:Waktu_input,:status, :header)");
            $this->db->bind('id_icd', $idicd);
            $this->db->bind('NoRegistrasi', $NoRegistrasi);
            $this->db->bind('Petugas_Input', $namauserx);
            $this->db->bind('Waktu_input', $datenowcreate);
            $this->db->bind('status', '1');
            $this->db->bind('header', '0');
            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
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
    public function listICDTindakan($data)
    {
        try {
            $noreg = $data['noreg_pasien'];
            $query = "SELECT ICDX_Transactions_9.id, ICDX_Transactions_9.id_icd, ICDX.DESCRIPTION, ICDX_Transactions_9.NoRegistrasi, 
            ICDX_Transactions_9.header, ICDX.ICD_CODE
            FROM MasterdataSQL.dbo.ICDX_Transactions_9 LEFT JOIN MasterdataSQL.dbo.ICDX ON ICDX_Transactions_9.id_icd = ICDX.ID
            WHERE  ICDX_Transactions_9.NoRegistrasi =:noreg AND ICDX_Transactions_9.header=0";
            $this->db->query($query);
            $this->db->bind('noreg', $noreg);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['id'] = $key['id'];
                $pasing['id_icd'] = $key['id_icd'];
                $pasing['DESCRIPTION'] = $key['id_icd'] . ' - ' . $key['DESCRIPTION'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function setOrderOperasi($data)
    {
        try {
            $this->db->transaksi();

            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $datebills  = date('dmy', strtotime($datenowcreate));
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;

            $op_ID = $data['op_ID'];
            $op_NoMR = $data['op_NoMR'];
            $op_NamaPasien = $data['op_NamaPasien'];
            $op_NoEpisode = $data['op_NoEpisode'];
            $op_NoRegistrasi = $data['op_NoRegistrasi'];
            $op_DrOperator = $data['op_DrOperator'];
            $op_DrOperatorId = $data['op_DrOperatorId'];
            $op_TglOrder_time = $data['op_TglOrder_time'];
            $op_PetugasOrder = $data['op_PetugasOrder'];
            $op_PetugasOrder = $data['op_PetugasOrder'];
            $op_LokasiPasien = $data['op_LokasiPasien'];
            $op_UnitPasien = $data['op_UnitPasien'];
            $op_UnitPasienId = $data['op_UnitPasienId'];
            $op_JenisOperasi_cari = $data['op_JenisOperasi_cari'];
            $op_JenisOperasi = $data['op_JenisOperasi'];
            $op_GroupSpesialis = $data['op_GroupSpesialis'];
            $op_Kategori = $data['op_Kategori'];
            $op_JenisAnestesi = $data['op_JenisAnestesi'];
            $op_JenisAnestesi = $data['op_JenisAnestesi'];
            $op_TglOperasi = $data['op_TglOperasi'];
            $op_JamPelaksanaan = $data['op_JamPelaksanaan'];
            $op_LamaOperasi = $data['op_LamaOperasi'];
            $op_StatusAdministrasi = $data['op_StatusAdministrasi'];
            $op_NamaJaminan = $data['op_NamaJaminan'];
            if ($op_StatusAdministrasi === "APPROVED" || $op_StatusAdministrasi === "REJECTED") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Status Administrasi Sudah di Rubah Approved/Rejected, Data tidak bisa di Rubah !',
                );
                echo json_encode($callback);
                exit;
            }

            $this->db->query("SELECT b.ICD_CODE,b.DESCRIPTION
                        FROM MasterdataSQL.DBO.ICDX_Transactions a
                        inner join MasterdataSQL.dbo.ICDX b
                        on a.id_icd = b.ID
            WHERE a.NoRegistrasi=:NoRegistrasi ");
            $this->db->bind('NoRegistrasi', $op_NoRegistrasi);
            $dataCoutndtaig =  $this->db->rowCount();
            $namaDiagnosa = $this->db->single();


            $xnamadiag = $namaDiagnosa['ICD_CODE'] . ' - ' . $namaDiagnosa['DESCRIPTION'];
            if ($namaDiagnosa['DESCRIPTION'] == null) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Diagnosa Utama Mohon Dimasukan !',
                );
                return $callback;
                exit;
            }

            if ($op_ID == "") {
                if ($op_NoMR == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'No. Medical Record Kosong !',
                    );
                    echo json_encode($callback);
                    exit;
                }
                if ($op_NamaPasien == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Nama Pasien Kosong !',
                    );
                    echo json_encode($callback);
                    exit;
                }
                if ($op_NoEpisode == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'No. Episode Kosong !',
                    );
                    echo json_encode($callback);
                    exit;
                }
                if ($op_NoRegistrasi == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'No. Registrasi Kosong !',
                    );
                    echo json_encode($callback);
                    exit;
                }
                if ($op_DrOperator == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Nama Dokter Operator Kosong !',
                    );
                    echo json_encode($callback);
                    exit;
                }

                if ($op_UnitPasien == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Nama Unit Kosong !',
                    );
                    echo json_encode($callback);
                    exit;
                }


                if (substr($op_NoRegistrasi, 1, 2) == "RJ") {
                    $LokasiPasien = "Outpatient";
                } else {
                    $LokasiPasien = "Inpatient";
                }
                $this->db->query("INSERT INTO EMR.dbo.OrderOperasis (
                     NoMR,NoEpisode,NoRegistrasi,
                     NamaPasien,LokasiPasien,UnitPasien,
                     PetugasOrder,StatusOrder,NamaJaminan,
                     StatusAdministrasi,NoEpisodeOrder,NoRegistrasiOrder,RequestBy,DrOperator,TglOrder
                     ,DiagnosaPreOP
                )
                VALUES (
                     :NoMR, :NoEpisode, :NoRegistrasi, 
                     :NamaPasien, :LokasiPasien, :UnitPasien, 
                     :PetugasOrder, :StatusOrder, :NamaJaminan, 
                     :StatusAdministrasi, :NoEpisodeOrder, :NoRegistrasiOrder, :RequestBy,:DrOperator,:TglOrder
                     ,:DiagnosaPreOP
                     
                )");
                $this->db->bind('DiagnosaPreOP', $xnamadiag);
                $this->db->bind('TglOrder', $datenowcreate);
                $this->db->bind('DrOperator', $op_DrOperator);
                $this->db->bind('NoEpisode', $op_NoEpisode);
                $this->db->bind('NoRegistrasi', $op_NoRegistrasi);
                $this->db->bind('NoMR', $op_NoMR);
                $this->db->bind('NamaPasien', $op_NamaPasien);
                $this->db->bind('LokasiPasien', $LokasiPasien);
                $this->db->bind('UnitPasien', $op_UnitPasienId);
                $this->db->bind('PetugasOrder', $namauserx);
                $this->db->bind('StatusOrder', "NEW");
                $this->db->bind('NamaJaminan', $op_NamaJaminan);
                $this->db->bind('StatusAdministrasi', "NEW");
                $this->db->bind('NoEpisodeOrder', $op_NoEpisode);
                $this->db->bind('NoRegistrasiOrder', $op_NoRegistrasi);
                $this->db->bind('RequestBy', $namauserx);
                $this->db->execute();

                $pasing['GenID'] =  $this->db->GetLastID();
                $pasing['TglOrder'] =  $datenowx;
                $pasing['JamOrder'] =  Utils::getCurrentTime();
                $pasing['PetugasOrder'] =  $namauserx;
                $pasing['LokasiPasien'] =  $LokasiPasien;
                $pasing['xnamadiag'] =  $xnamadiag;
                $pasing['StatusAdministrasi'] =  'NEW';
                $pasing['StatusOrder'] =  'NEW';
            } else {
                if ($op_NoMR == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'No. Medical Record Kosong !',
                    );
                    echo json_encode($callback);
                    exit;
                }
                if ($op_NamaPasien == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Nama Pasien Kosong !',
                    );
                    echo json_encode($callback);
                    exit;
                }
                if ($op_NoEpisode == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'No. Episode Kosong !',
                    );
                    echo json_encode($callback);
                    exit;
                }
                if ($op_NoRegistrasi == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'No. Registrasi Kosong !',
                    );
                    echo json_encode($callback);
                    exit;
                }
                if ($op_DrOperator == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Nama Dokter Operator Kosong !',
                    );
                    echo json_encode($callback);
                    exit;
                }

                if ($op_UnitPasien == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Nama Unit Kosong !',
                    );
                    echo json_encode($callback);
                    exit;
                }
                if ($op_NamaJaminan == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Nama Jaminan Kosong !',
                    );
                    echo json_encode($callback);
                    exit;
                }
                if ($data['op_JenisOperasiID'] == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Id Rencana Operasi Kosong !',
                    );
                    echo json_encode($callback);
                    exit;
                }
                if ($op_JenisOperasi == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Nama Rencana Operasi Kosong !',
                    );
                    echo json_encode($callback);
                    exit;
                }
                if ($data['op_GroupSpesialisID'] == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Id Group Spesialis Operasi Kosong !',
                    );
                    echo json_encode($callback);
                    exit;
                }
                if ($op_GroupSpesialis == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Nama Group Spesialis Kosong !',
                    );
                    echo json_encode($callback);
                    exit;
                }
                if ($data['op_KategoriID'] == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Id Kategori Operasi Kosong !',
                    );
                    echo json_encode($callback);
                    exit;
                }
                if ($op_Kategori == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Nama Kategori Operasi Kosong !',
                    );
                    echo json_encode($callback);
                    exit;
                }
                if ($op_JenisAnestesi == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Jenis Anestesi Operasi Kosong !',
                    );
                    echo json_encode($callback);
                    exit;
                }
                if ($data['op_Kriteria'] == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Kriteria Operasi Kosong !',
                    );
                    echo json_encode($callback);
                    exit;
                }
                if ($op_TglOperasi == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Tanggal Waktu Pelaksanaan Operasi Kosong !',
                    );
                    echo json_encode($callback);
                    exit;
                }
                if ($op_JamPelaksanaan == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Jam Waktu Pelaksanaan Operasi Kosong !',
                    );
                    echo json_encode($callback);
                    exit;
                }
                if ($op_LamaOperasi == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Lama Waktu Pelaksanaan Operasi Kosong !',
                    );
                    echo json_encode($callback);
                    exit;
                }
                if (substr($op_NoRegistrasi, 1, 2) == "RJ") {
                    $LokasiPasien = "Outpatient";
                } else {
                    $LokasiPasien = "Inpatient";
                }

                $this->db->query("UPDATE EMR.dbo.OrderOperasis  set
                                    IdJenisOperasi=:IdJenisOperasi,
                                    JenisOperasi=:JenisOperasi,
                                    IdGroupSpesialis=:IdGroupSpesialis,
                                    GroupSpesialis=:GroupSpesialis,
                                    IdKategori=:IdKategori,
                                    Kategori=:Kategori,
                                    PerkiraanLamaOP=:PerkiraanLamaOP,
                                    TglOperasi=:TglOperasi,
                                    JamPelaksanaan=:JamPelaksanaan,
                                    JamMulai=:JamMulai,
                                    JamSelesai=:JamSelesai, 
                                    KlasifikasiOP=:KlasifikasiOP,
                                    JenisAnestesi=:JenisAnestesi
                                WHERE id=:id");
                $this->db->bind('id', $op_ID);
                $this->db->bind('IdJenisOperasi', $data['op_JenisOperasiID']);
                $this->db->bind('JenisOperasi', $op_JenisOperasi);
                $this->db->bind('IdGroupSpesialis', $data['op_GroupSpesialisID']);
                $this->db->bind('GroupSpesialis', $op_GroupSpesialis);
                $this->db->bind('IdKategori', $data['op_KategoriID']);
                $this->db->bind('Kategori', $op_Kategori);
                $this->db->bind('PerkiraanLamaOP', $op_LamaOperasi);
                $this->db->bind('TglOperasi', $op_TglOperasi);
                $this->db->bind('JamPelaksanaan', $op_JamPelaksanaan);
                $this->db->bind('JamMulai', $op_JamPelaksanaan);
                $this->db->bind('JamSelesai', $op_JamPelaksanaan);
                $this->db->bind('KlasifikasiOP', $data['op_Kriteria']);
                $this->db->bind('JenisAnestesi', $op_JenisAnestesi);

                $this->db->execute();

                $pasing['TglOrder'] =  $datenowx;
                $pasing['JamOrder'] =  Utils::getCurrentTime();
                $pasing['PetugasOrder'] =  $namauserx;
                $pasing['LokasiPasien'] =  $LokasiPasien;
                $pasing['xnamadiag'] =  $xnamadiag;
                $pasing['StatusAdministrasi'] =  'NEW';
                $pasing['StatusOrder'] =  'NEW';
            }

            $this->db->commit();

            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
                'data' =>  $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function setOrderOperasiBatal($data)
    {
        try {
            $this->db->transaksi();

            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $datebills  = date('dmy', strtotime($datenowcreate));
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;

            $op_ID = $data['op_ID'];
            $op_NoMR = $data['op_NoMR'];
            $op_NamaPasien = $data['op_NamaPasien'];
            $op_NoEpisode = $data['op_NoEpisode'];
            $op_NoRegistrasi = $data['op_NoRegistrasi'];
            $op_DrOperator = $data['op_DrOperator'];
            $op_DrOperatorId = $data['op_DrOperatorId'];
            $op_TglOrder_time = $data['op_TglOrder_time'];
            $op_PetugasOrder = $data['op_PetugasOrder'];
            $op_PetugasOrder = $data['op_PetugasOrder'];
            $op_LokasiPasien = $data['op_LokasiPasien'];
            $op_UnitPasien = $data['op_UnitPasien'];
            $op_UnitPasienId = $data['op_UnitPasienId'];
            $op_JenisOperasi_cari = $data['op_JenisOperasi_cari'];
            $op_JenisOperasi = $data['op_JenisOperasi'];
            $op_GroupSpesialis = $data['op_GroupSpesialis'];
            $op_Kategori = $data['op_Kategori'];
            $op_JenisAnestesi = $data['op_JenisAnestesi'];
            $op_JenisAnestesi = $data['op_JenisAnestesi'];
            $op_TglOperasi = $data['op_TglOperasi'];
            $op_JamPelaksanaan = $data['op_JamPelaksanaan'];
            $op_LamaOperasi = $data['op_LamaOperasi'];
            $op_StatusAdministrasi = $data['op_StatusAdministrasi'];
            $op_NamaJaminan = $data['op_NamaJaminan'];
            if ($op_StatusAdministrasi === "APPROVED" || $op_StatusAdministrasi === "REJECTED") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Status Administrasi Sudah di Rubah Approved/Rejected, Data tidak bisa di Rubah !',
                );
                echo json_encode($callback);
                exit;
            }
            $this->db->query("UPDATE EMR.dbo.OrderOperasis  set
                                    Batal=:Batal,
                                    tglBatal=:tglBatal,
                                    UserBatal=:UserBatal 
                                WHERE id=:id");
            $this->db->bind('id', $op_ID);
            $this->db->bind('Batal', '1');
            $this->db->bind('tglBatal', $datenowcreate);
            $this->db->bind('UserBatal', $userid);
            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi Di batalkan !',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function getDataListOrderOperasi($data)
    {
        try {
            $noreg = $data['noreg_pasien'];
            $query = "SELECT ID,TglOrder,RequestBy,DiagnosaPreOP,RencanaPerawatan,DrOperator,
            StatusOrder,StatusAdministrasi,JenisOperasi
            FROM EMR.DBO.OrderOperasis
            WHERE NoRegistrasiOrder = :noreg AND Batal = '0' order by id desc";
            $this->db->query($query);
            $this->db->bind('noreg', $noreg);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['ID'] = $key['ID'];
                $pasing['TglOrder'] = $key['TglOrder'];
                $pasing['JenisOperasi'] = $key['JenisOperasi'];
                $pasing['RequestBy'] = $key['RequestBy'];
                $pasing['DiagnosaPreOP'] = $key['DiagnosaPreOP'];
                $pasing['RencanaPerawatan'] = $key['RencanaPerawatan'];
                $pasing['DrOperator'] = $key['DrOperator'];
                $pasing['StatusOrder'] =  $key['StatusOrder'];
                $pasing['StatusAdministrasi'] = $key['StatusAdministrasi'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataDetailOrderOperasiByIDHDR($data)
    {
        try {
            $idhdr = $data['idhdr'];
            $this->db->query("SELECT * , replace(CONVERT(VARCHAR(11),TglOrder, 111), '/','-') as xTglOrder,
                            replace(CONVERT(VARCHAR(11),TglOperasi, 111), '/','-') as xTglOperasi,
                            CONVERT(VARCHAR(8),TglOrder,108) as xJamOrder,
                            CONVERT(VARCHAR(8),JamPelaksanaan,108) as xJamPelaksanaan 
                            FROM EMR.DBO.OrderOperasis WHERE ID = :idhdr");
            $this->db->bind('idhdr', $idhdr);
            $key =  $this->db->single();
            $pasing['ID'] = $key['ID'];
            $pasing['xJamPelaksanaan'] = $key['xJamPelaksanaan'];
            $pasing['xTglOperasi'] = $key['xTglOperasi'];
            $pasing['xTglOrder'] = $key['xTglOrder'];
            $pasing['xJamOrder'] = $key['xJamOrder'];
            $pasing['NoMR'] = $key['NoMR'];
            $pasing['NoEpisode'] = $key['NoEpisodeOrder'];
            $pasing['NoRegistrasi'] = $key['NoRegistrasiOrder'];
            $pasing['NamaPasien'] = $key['NamaPasien'];
            $pasing['TglOrder'] = $key['TglOrder'];
            $pasing['Departemen'] = $key['Departemen'];
            $pasing['RequestBy'] = $key['RequestBy'];
            $pasing['LokasiPasien'] = $key['LokasiPasien'];
            $pasing['UnitPasien'] = $key['UnitPasien'];
            $pasing['PerkiraanLamaOP'] = $key['PerkiraanLamaOP'];
            $pasing['TglOperasi'] = $key['TglOperasi'];
            $pasing['JamPelaksanaan'] = $key['JamPelaksanaan'];
            $pasing['JamMulai'] = $key['JamMulai'];
            $pasing['JamSelesai'] = $key['JamSelesai'];
            $pasing['LamaOperasi'] = $key['LamaOperasi'];
            $pasing['DiagnosaPreOP'] = $key['DiagnosaPreOP'];
            $pasing['DiagnosaPostOP'] = $key['DiagnosaPostOP'];
            $pasing['JenisOperasi'] = $key['JenisOperasi'];
            $pasing['IdJenisOperasi'] = $key['IdJenisOperasi'];
            $pasing['IdGroupSpesialis'] = $key['IdGroupSpesialis'];
            $pasing['GroupSpesialis'] = $key['GroupSpesialis'];
            $pasing['IdKategori'] = $key['IdKategori'];
            $pasing['Kategori'] = $key['Kategori'];
            $pasing['RencanaPerawatan'] = $key['RencanaPerawatan'];
            $pasing['KelasPerawatan'] = $key['KelasPerawatan'];
            $pasing['KlasifikasiOP'] = $key['KlasifikasiOP'];
            $pasing['JenisAnestesi'] = $key['JenisAnestesi'];
            $pasing['DrOperatorId'] = $key['DrOperatorId'];
            $pasing['DrOperator'] = $key['DrOperator'];
            $pasing['DrAnastesi'] = $key['DrAnastesi'];
            $pasing['LaporanOP'] = $key['LaporanOP'];
            $pasing['PetugasOrder'] = $key['PetugasOrder'];
            $pasing['Note'] = $key['Note'];
            $pasing['NamaJaminan'] = $key['NamaJaminan'];
            $pasing['StatusOrder'] = $key['StatusOrder'];
            $pasing['StatusAdministrasi'] = $key['StatusAdministrasi'];
            $pasing['tglAprove'] = $key['tglAprove'];
            $pasing['UserAprove'] = $key['UserAprove'];
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function searchTarifOperasi($data)
    {
        try {

            $textPencarian = $data['searchTerm'];
            $query = "SELECT id,NamaTarif FROM PerawatanSQL.dbo.TarifOperasis
                     where NamaTarif like '%'+:keyword+'%' ";
            $this->db->query($query);
            $this->db->bind('keyword',   $textPencarian);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['id'] = $key['id'];
                $pasing['label'] = $key['NamaTarif'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function searchTarifOperasibyId($data)
    {
        try {

            $textPencarian = $data['id'];
            $query = "SELECT a.id,a.NamaTarif,a.golonganoperasi,b.nama as Namagolongan,a.groupOperasi, c.nama as namagroupoperasi
                        from PerawatanSQL.dbo.TarifOperasis a
                        inner join PerawatanSQL.dbo.TarifOperasiGroups b
                        on a.golonganoperasi = b.id
                        inner join PerawatanSQL.dbo.TarifOperasiGolongans c
                        on c.id = a.groupOperasi
                     where a.id = :textPencarian ";
            $this->db->query($query);
            $this->db->bind('textPencarian',   $textPencarian);
            $key =  $this->db->single();
            $pasing['id'] = $key['id'];
            $pasing['NamaTarif'] = $key['NamaTarif'];
            $pasing['golonganoperasi'] = $key['golonganoperasi'];
            $pasing['Namagolongan'] = $key['Namagolongan'];
            $pasing['groupOperasi'] = $key['groupOperasi'];
            $pasing['namagroupoperasi'] = $key['namagroupoperasi'];
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function getDataListOrderOperasibyNoRekamMedikPeriodik($data)
    {
        try {
            $NoMR = $data['NoMR'];
            $PeriodeAwal = $data['PeriodeAwal'];
            $PeriodeAkhir = $data['PeriodeAkhir'];
            $query = "SELECT *
                    FROM EMR.DBO.OrderOperasis
                    WHERE Batal = '0' and NoMR=:NoMR
                    and  replace(CONVERT(VARCHAR(11),TglOrder, 111), '/','-') between :PeriodeAwal and :PeriodeAkhir order by id desc";
            $this->db->query($query);
            $this->db->bind('NoMR', $NoMR);
            $this->db->bind('PeriodeAwal', $PeriodeAwal);
            $this->db->bind('PeriodeAkhir', $PeriodeAkhir);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['ID'] = $key['ID'];
                $pasing['TglOrder'] = $key['TglOrder'];
                $pasing['JenisOperasi'] = $key['JenisOperasi'];
                $pasing['RequestBy'] = $key['RequestBy'];
                $pasing['DiagnosaPreOP'] = $key['DiagnosaPreOP'];
                $pasing['RencanaPerawatan'] = $key['RencanaPerawatan'];
                $pasing['DrOperator'] = $key['DrOperator'];
                $pasing['StatusOrder'] =  $key['StatusOrder'];
                $pasing['StatusAdministrasi'] = $key['StatusAdministrasi'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDataListOrderOperasibyPeriodik($data)
    {
        try {

            $PeriodeAwal = $data['PeriodeAwal'];
            $PeriodeAkhir = $data['PeriodeAkhir'];
            $query = "SELECT replace(CONVERT(VARCHAR(11),TglOperasi, 111), '/','-') as tglOperasis, 
            convert(char(5), JamPelaksanaan, 108) as JamPelaksanaans,
            convert(char(5), JamMulai, 108) as JamMulais,
            convert(char(5), JamSelesai, 108) as JamSelesais,
            convert(char(5), LamaOperasi, 108) as LamaOperasis, *
                    FROM EMR.DBO.OrderOperasis
                    WHERE Batal = '0'  
                    and  replace(CONVERT(VARCHAR(11),TglOrder, 111), '/','-') between :PeriodeAwal and :PeriodeAkhir order by id desc";
            $this->db->query($query);
            $this->db->bind('PeriodeAwal', $PeriodeAwal);
            $this->db->bind('PeriodeAkhir', $PeriodeAkhir);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['ID'] = $key['ID'];
                $pasing['TglOrder'] = $key['TglOrder'];
                $pasing['JenisOperasi'] = $key['JenisOperasi'];
                $pasing['RequestBy'] = $key['RequestBy'];
                $pasing['DiagnosaPreOP'] = $key['DiagnosaPreOP'];
                $pasing['RencanaPerawatan'] = $key['RencanaPerawatan'];
                $pasing['DrOperator'] = $key['DrOperator'];
                $pasing['StatusOrder'] =  $key['StatusOrder'];
                $pasing['StatusAdministrasi'] = $key['StatusAdministrasi'];
                $pasing['RequestBy'] = $key['RequestBy'];
                $pasing['JenisOperasi'] = $key['JenisOperasi'];
                $pasing['DrOperator'] = $key['DrOperator'];
                $pasing['TglOperasi'] = $key['tglOperasis'];
                $pasing['JamPelaksanaan'] = $key['JamPelaksanaans'];
                $pasing['PerkiraanLamaOP'] = $key['PerkiraanLamaOP'];
                $pasing['JamMulais'] = $key['JamMulais'];
                $pasing['JamSelesais'] = $key['JamSelesais'];
                $pasing['LamaOperasis'] = $key['LamaOperasis'];
                $pasing['LaporanOP'] = $key['LaporanOP'];
                $pasing['NoEpisode'] = $key['NoEpisode'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['NamaPasien'] = $key['NamaPasien'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    //EMR KAMAR OPERASI
    public function getDataNurseAssOperasi($data)
    {
        try {
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $idemployee = $session->IDEmployee;
            $token = $session->token;
            $namauserx = $session->name;
            $noregistrasi = $data['NoRegistrasi'];
            $idorder = $data['idOrder'];

            $this->db->query("SELECT 
KeadaanUmum ,GCS ,GCS_E ,GCS_M ,GCS_V ,Kesadaran ,TD_Sistole 
,TD_Distole ,Suhu ,Nadi ,pernafasan ,RPD ,PengobatanSaatini ,PSI_Lainnya ,HasilLab ,StatusPsikologis ,Spiritual ,NamaUserOrder 

FROM EMR.dbo.MR_Pre_Operatifs WHERE NoRegistrasi = :noreg AND IdOrderOperasi = :idorder");
            $this->db->bind('noreg', $noregistrasi);
            $this->db->bind('idorder', $idorder);
            $key =  $this->db->single();

            $this->db->query("SELECT 
VP_PIP_PR ,VP_PIP_OT ,VP_PIP_Note ,VP_PGI_PR ,VP_PGI_OT ,VP_PGI_Note ,VP_SPO_PR ,VP_SPO_OT ,VP_SPO_Note 
,VP_JLP_PR ,VP_JLP_OT ,VP_JLP_Note ,VP_MBK_PR ,VP_MBK_OT ,VP_MBK_Note ,VP_PKPP_PR ,VP_PKPP_OT ,VP_PKPP_Note 
,VP_PKPA_PR ,VP_PKPA_OT ,VP_PKPA_Note ,VP_PKRM_PR ,VP_PKRM_OT ,VP_PKRM_Note

,PFP_Puasa_PR ,PFP_Puasa_OT ,PFP_Puasa_Note ,PFP_ProtaseL_PR ,PFP_ProtaseL_OT ,PFP_ProtaseL_Note ,PFP_ProtaseD_PR ,PFP_ProtaseD_OT ,PFP_ProtaseD_Note ,PFP_JLP_PR ,PFP_JLP_OT ,PFP_JLP_Note ,PFP_MB_PR ,PFP_MB_OT ,PFP_MB_Note ,PFP_Persetujuan_PR ,PFP_Persetujuan_OT ,PFP_Persetujuan_Note ,PFP_PDarah_PR ,PFP_PDarah_OT ,PFP_PDarah_Note ,PFP_AB_PR ,PFP_AB_OT ,PFP_AB_Note ,PFP_Obat_PR ,PFP_Obat_OT ,PFP_Obat_Note ,PFP_ObatTerahir_PR ,PFP_ObatTerahir_OT ,PFP_ObatTerahir_Note ,PFP_Cimino_PR ,PFP_Cimino_OT ,PFP_Cimino_Note ,PFP_PerawatRuangan ,PFP_PR_Jam ,PFP_OT_Jam ,PFP_PerawatOT

,PLL_SiteMarking ,PLL_KegunaanManfaat ,sudah_sholat 

FROM EMR.dbo.MR_Persiapan_Operatifs WHERE NoRegistrasi = :noreg1 AND IdOrderOperasi = :idorder1");
            $this->db->bind('noreg1', $noregistrasi);
            $this->db->bind('idorder1', $idorder);
            $key2 =  $this->db->single();

            $this->db->query("SELECT 
[PIO_TimeOut] ,[PIO_TOJam] ,[PIO_CKPF] ,[PIO_CKPFJam] ,[PIO_Instrumen] ,[PIO_Protase] ,[PIO_MulaiJam] ,[PIO_SelesaiJam] ,[PIO_Operasi] ,[PIO_TipeOP] ,[PIO_JenisAnestesi] 
,[PIO_Emosi] ,[PIO_PosisiKanul] ,[PIO_PosisiOP] ,[PIO_PosisiLengan] ,[PIO_PosisiAlatB] ,[PIO_Kateter] ,[PIO_PersiapanKulit] ,[PIO_Diathermy]

,[PIO_LElektroda] ,[PIO_ELDPO] ,[PIO_PKKSBOP] ,[PIO_PKKSTOP] ,[PIO_KUE] ,[PIO_UPP] ,[PIO_UPPP] ,[PIO_UPPTemp] ,[PIO_UPPJamM] ,[PIO_UPPJamS] ,[PIO_PTorniquet] ,[PIO_PTLKa] 
,[PIO_PTLKaJM] ,[PIO_PTLKaJS] ,[PIO_PTLKaT] ,[PIO_PTLKi] ,[PIO_PTLKiJM] ,[PIO_PTLKiJS] ,[PIO_PTLKiT] ,[PIO_PTPKa] ,[PIO_PTPKaJM] ,[PIO_PTPKaJS] ,[PIO_PTPKaT] ,[PIO_PTPKi] 
,[PIO_PTPKiJM] ,[PIO_PTPKiJS] ,[PIO_PTPKiT] ,[PIO_PTorqDiawasiO] ,[PIO_PImplant] ,[PIO_Perdarahan] ,[PIO_PDrain] ,[PIO_LokasiDrain] ,[PIO_IrigasiLuka] ,[PIO_PCairan] 
,[PIO_JumlahCairan] ,[PIO_Balutan] ,[PIO_Spesimen] ,[PIO_JenisJaringan] ,[PIO_JmlJaringan] ,[PIO_TipeFiksasi] ,[PIO_Keterangan]

FROM EMR.dbo.MR_Intra_Operatifs WHERE NoRegistrasi = :noreg2 AND IdOrderOperasi = :idorder2");
            $this->db->bind('noreg2', $noregistrasi);
            $this->db->bind('idorder2', $idorder);
            $key3 =  $this->db->single();

            $this->db->query("SELECT 
[SI_IGP] ,[SI_IC] ,[SI_NamaOperator] ,[SI_NamaTindakan] ,[SI_LokasiTindakan] ,[SI_TDO] ,[SI_PKAnestesi] ,[SI_PMAnestesi] ,[SI_PAlatInstrumen] ,[SI_PSterilInstrumen] ,[SI_RAsma] ,[SI_KetSignIn] ,[SI_RAlergi] ,[SI_PerawatanKhusus] ,[SI_DokLab] ,[SI_DokRadiologi] ,[SI_PDarah] ,[SI_TglSignin] ,[SI_JamSignIn] ,[SI_PerawatAnestesi] ,[SI_DokterAnestesi] ,[SI_Keterangan] ,[oksimeter] ,[Tim_sholat]
FROM EMR.dbo.MR_SurgicalSafetyCheklistSIgnIns WHERE NoRegistrasi = :noreg3 AND IdOrderOperasi = :idorder3");
            $this->db->bind('noreg3', $noregistrasi);
            $this->db->bind('idorder3', $idorder);
            $key4 =  $this->db->single();


            $this->db->query("SELECT 
[TO_IP] ,[TO_TglTindakan] ,[TO_LO] ,[TO_NamaTim] ,[TO_PO] ,[TO_TanggalTindakan] ,[TO_Premedikasi] ,[TO_DiberikanJam] ,[TO_Antibiotik] ,[TO_FotoRadiologi] ,[TO_Keterangan] ,[TO_Perhatian] ,[TO_Jam] ,[TO_DokterBedah] ,[TO_drAnestesi] ,[TO_PerawatSirkulasi] ,[PerawatInstrumen] ,[mendoakan_pasien] ,[TO_PerawatAnestesi] ,[TO_PerawatAsisten] ,[PerawatSirkuler]
FROM EMR.dbo.MR_SurgicalSafetyCheklistsTimeOuts WHERE NoRegistrasi = :noreg4 AND IdOrderOperasi = :idorder4");
            $this->db->bind('noreg4', $noregistrasi);
            $this->db->bind('idorder4', $idorder);
            $key5 =  $this->db->single();


            $this->db->query("SELECT 
            [SO_Membacakan] ,[SO_JumlahInstrumen] ,[SO_ProsedurTindakan] ,[SO_PJaringan] ,[SO_Implant] ,[SO_KerusakanAlat] ,[SO_JenisInstrument] ,[SO_Doa] ,[SO_Jam] ,[SO_drBedah] ,[SO_drSerkuler]
            FROM EMR.dbo.MR_SurgicalSafetyCheklistsSignOuts WHERE NoRegistrasi = :noreg5 AND IdOrderOperasi = :idorder5");
            $this->db->bind('noreg5', $noregistrasi);
            $this->db->bind('idorder5', $idorder);
            $key6 =  $this->db->single();


            $this->db->query("SELECT 
            [Tgl] ,[JenisTindakan] ,[DokterBedah] ,[DokterAnestesi] ,[Drain] ,[JenisDrain] ,[Catheter] ,[NoCatheter] ,[BalonCatheter] ,[Bungkusan] ,[JenisBungkusan] ,[Patologi] ,[Kultur] ,[Prothesis] ,[JenisProthesis] ,[Perdarahan] ,[ICOperasi] ,[LaporanOP] ,[DaftarObat] ,[InstruksiPostOP] ,[CeklistAlkes] ,[SSC] ,[FKSterilisasi] ,[DokumenRadiologi] ,[DokumenFoto] ,[DokumenUSG] ,[Keterangan_PB] ,[JenisAnestesi] ,[Kesadaran] ,[TD] ,[Nadi] ,[RR] ,[SO2] ,[Suhu] ,[Analgetik] ,[Antibiotik] ,[Jam] ,[Intake] ,[Output] ,[SI_Anestesi] ,[PraBedah] ,[CatatanAnestesi] ,[KetAnestesi] ,[PerawatBedah] ,[PerawatAnastesi]
            FROM EMR.dbo.MR_PK_PostOPerasis WHERE NoRegistrasi = :noreg5 AND IdOrderOperasi = :idorder5");
            $this->db->bind('noreg5', $noregistrasi);
            $this->db->bind('idorder5', $idorder);
            $key7 =  $this->db->single();


            $this->db->query("SELECT 
            [RPulihSadar] ,[JamMasuk] ,[JamKeluar] ,[KembaliKe] ,[KeadaanUmum] ,[Kesadaran] ,[JalanNafasDatang] ,[JalanNafasKeluar] ,[TerapiO2] ,[JenisO2] ,[KulitDatang] ,[KulitKeluar] ,[PosisiPasien] ,[Keterangan] ,[Cemas] ,[Cedera] ,[Nyeri] ,[Infeksi] ,[Hipertermi] ,[Hipotermi] ,[IntegritasKulit] ,[PerawatanMandiri] ,[PTK] ,[LFL] ,[PPObat] ,[PerawatanLuka] ,[Diet] ,[BAktifitasFisik] ,[BantuanMedis]
            FROM EMR.dbo.MR_PK_RuangPulihSadars WHERE NoRegistrasi = :noreg5 AND IdOrderOperasi = :idorder5");
            $this->db->bind('noreg5', $noregistrasi);
            $this->db->bind('idorder5', $idorder);
            $key8 =  $this->db->single();


            //PRE OPERASI NURSE
            $pasing['KeadaanUmum'] = $key['KeadaanUmum'];
            $pasing['GCS'] = $key['GCS'];
            $pasing['GCS_E'] = $key['GCS_E'];
            $pasing['GCS_M'] = $key['GCS_M'];
            $pasing['GCS_V'] = $key['GCS_V'];
            $pasing['Kesadaran'] = $key['Kesadaran'];
            $pasing['TD_Sistole'] = $key['TD_Sistole'];
            $pasing['TD_Distole'] = $key['TD_Distole'];
            $pasing['Suhu'] = $key['Suhu'];
            $pasing['Nadi'] = $key['Nadi'];
            $pasing['pernafasan'] = $key['pernafasan'];
            $pasing['RPD'] = $key['RPD'];
            $pasing['PengobatanSaatini'] = $key['PengobatanSaatini'];
            $pasing['PSI_Lainnya'] = $key['PSI_Lainnya'];
            $pasing['HasilLab'] = $key['HasilLab'];
            $pasing['StatusPsikologis'] = $key['StatusPsikologis'];
            $pasing['Spiritual'] = $key['Spiritual'];
            $pasing['NamaUserOrder'] = $key['NamaUserOrder'];

            // PERSIAPAN OPERASI NURSE
            $pasing['VP_PIP_PR'] = $key2['VP_PIP_PR'];
            $pasing['VP_PIP_OT'] = $key2['VP_PIP_OT'];
            $pasing['VP_PIP_Note'] = $key2['VP_PIP_Note'];
            $pasing['VP_PGI_PR'] = $key2['VP_PGI_PR'];
            $pasing['VP_PGI_OT'] = $key2['VP_PGI_OT'];
            $pasing['VP_PGI_Note'] = $key2['VP_PGI_Note'];
            $pasing['VP_SPO_PR'] = $key2['VP_SPO_PR'];
            $pasing['VP_SPO_OT'] = $key2['VP_SPO_OT'];
            $pasing['VP_SPO_Note'] = $key2['VP_SPO_Note'];
            $pasing['VP_JLP_PR'] = $key2['VP_JLP_PR'];
            $pasing['VP_JLP_OT'] = $key2['VP_JLP_OT'];
            $pasing['VP_JLP_Note'] = $key2['VP_JLP_Note'];
            $pasing['VP_MBK_PR'] = $key2['VP_MBK_PR'];
            $pasing['VP_MBK_OT'] = $key2['VP_MBK_OT'];
            $pasing['VP_MBK_Note'] = $key2['VP_MBK_Note'];
            $pasing['VP_PKPP_PR'] = $key2['VP_PKPP_PR'];
            $pasing['VP_PKPP_OT'] = $key2['VP_PKPP_OT'];
            $pasing['VP_PKPP_Note'] = $key2['VP_PKPP_Note'];
            $pasing['VP_PKPA_PR'] = $key2['VP_PKPA_PR'];
            $pasing['VP_PKPA_OT'] = $key2['VP_PKPA_OT'];
            $pasing['VP_PKPA_Note'] = $key2['VP_PKPA_Note'];
            $pasing['VP_PKRM_PR'] = $key2['VP_PKRM_PR'];
            $pasing['VP_PKRM_OT'] = $key2['VP_PKRM_OT'];
            $pasing['VP_PKRM_Note'] = $key2['VP_PKRM_Note'];


            $pasing['PFP_Puasa_PR'] = $key2['PFP_Puasa_PR'];
            $pasing['PFP_Puasa_OT'] = $key2['PFP_Puasa_OT'];
            $pasing['PFP_Puasa_Note'] = $key2['PFP_Puasa_Note'];
            $pasing['PFP_ProtaseL_PR'] = $key2['PFP_ProtaseL_PR'];
            $pasing['PFP_ProtaseL_OT'] = $key2['PFP_ProtaseL_OT'];
            $pasing['PFP_ProtaseL_Note'] = $key2['PFP_ProtaseL_Note'];
            $pasing['PFP_ProtaseD_PR'] = $key2['PFP_ProtaseD_PR'];
            $pasing['PFP_ProtaseD_OT'] = $key2['PFP_ProtaseD_OT'];
            $pasing['PFP_ProtaseD_Note'] = $key2['PFP_ProtaseD_Note'];
            $pasing['PFP_JLP_PR'] = $key2['PFP_JLP_PR'];
            $pasing['PFP_JLP_OT'] = $key2['PFP_JLP_OT'];
            $pasing['PFP_JLP_Note'] = $key2['PFP_JLP_Note'];
            $pasing['PFP_MB_PR'] = $key2['PFP_MB_PR'];
            $pasing['PFP_MB_OT'] = $key2['PFP_MB_OT'];
            $pasing['PFP_MB_Note'] = $key2['PFP_MB_Note'];
            $pasing['PFP_Persetujuan_PR'] = $key2['PFP_Persetujuan_PR'];
            $pasing['PFP_Persetujuan_OT'] = $key2['PFP_Persetujuan_OT'];
            $pasing['PFP_Persetujuan_Note'] = $key2['PFP_Persetujuan_Note'];
            $pasing['PFP_PDarah_PR'] = $key2['PFP_PDarah_PR'];
            $pasing['PFP_PDarah_OT'] = $key2['PFP_PDarah_OT'];
            $pasing['PFP_PDarah_Note'] = $key2['PFP_PDarah_Note'];
            $pasing['PFP_AB_PR'] = $key2['PFP_AB_PR'];
            $pasing['PFP_AB_OT'] = $key2['PFP_AB_OT'];
            $pasing['PFP_AB_Note'] = $key2['PFP_AB_Note'];
            $pasing['PFP_Obat_PR'] = $key2['PFP_Obat_PR'];
            $pasing['PFP_Obat_OT'] = $key2['PFP_Obat_OT'];
            $pasing['PFP_Obat_Note'] = $key2['PFP_Obat_Note'];
            $pasing['PFP_ObatTerahir_PR'] = $key2['PFP_ObatTerahir_PR'];
            $pasing['PFP_ObatTerahir_OT'] = $key2['PFP_ObatTerahir_OT'];
            $pasing['PFP_ObatTerahir_Note'] = $key2['PFP_ObatTerahir_Note'];
            $pasing['PFP_Cimino_PR'] = $key2['PFP_Cimino_PR'];
            $pasing['PFP_Cimino_OT'] = $key2['PFP_Cimino_OT'];
            $pasing['PFP_Cimino_Note'] = $key2['PFP_Cimino_Note'];
            $pasing['PFP_PerawatRuangan'] = $key2['PFP_PerawatRuangan'];
            $pasing['PFP_PR_Jam'] = $key2['PFP_PR_Jam'];
            $pasing['PFP_OT_Jam'] = $key2['PFP_OT_Jam'];
            $pasing['PFP_PerawatOT'] = $key2['PFP_PerawatOT'];

            $pasing['PLL_SiteMarking'] = $key2['PLL_SiteMarking'];
            $pasing['PLL_KegunaanManfaat'] = $key2['PLL_KegunaanManfaat'];
            $pasing['sudah_sholat'] = $key2['sudah_sholat'];


            // ASS INTRA OPERASI NA
            $pasing['PIO_TimeOut'] = $key3['PIO_TimeOut'];
            $pasing['PIO_TOJam'] = $key3['PIO_TOJam'];
            $pasing['PIO_CKPF'] = $key3['PIO_CKPF'];
            $pasing['PIO_CKPFJam'] = $key3['PIO_CKPFJam'];
            $pasing['PIO_Instrumen'] = $key3['PIO_Instrumen'];
            $pasing['PIO_Protase'] = $key3['PIO_Protase'];
            $pasing['PIO_MulaiJam'] = $key3['PIO_MulaiJam'];
            $pasing['PIO_SelesaiJam'] = $key3['PIO_SelesaiJam'];
            $pasing['PIO_Operasi'] = $key3['PIO_Operasi'];
            $pasing['PIO_TipeOP'] = $key3['PIO_TipeOP'];
            $pasing['PIO_JenisAnestesi'] = $key3['PIO_JenisAnestesi'];
            $pasing['PIO_Emosi'] = $key3['PIO_Emosi'];
            $pasing['PIO_PosisiKanul'] = $key3['PIO_PosisiKanul'];
            $pasing['PIO_PosisiOP'] = $key3['PIO_PosisiOP'];
            $pasing['PIO_PosisiLengan'] = $key3['PIO_PosisiLengan'];
            $pasing['PIO_PosisiAlatB'] = $key3['PIO_PosisiAlatB'];
            $pasing['PIO_Kateter'] = $key3['PIO_Kateter'];
            $pasing['PIO_PersiapanKulit'] = $key3['PIO_PersiapanKulit'];
            $pasing['PIO_Diathermy'] = $key3['PIO_Diathermy'];

            $pasing['PIO_LElektroda'] = $key3['PIO_LElektroda'];
            $pasing['PIO_ELDPO'] = $key3['PIO_ELDPO'];
            $pasing['PIO_PKKSBOP'] = $key3['PIO_PKKSBOP'];
            $pasing['PIO_PKKSTOP'] = $key3['PIO_PKKSTOP'];
            $pasing['PIO_KUE'] = $key3['PIO_KUE'];
            $pasing['PIO_UPP'] = $key3['PIO_UPP'];
            $pasing['PIO_UPPP'] = $key3['PIO_UPPP'];
            $pasing['PIO_UPPTemp'] = $key3['PIO_UPPTemp'];
            $pasing['PIO_UPPJamM'] = $key3['PIO_UPPJamM'];
            $pasing['PIO_UPPJamS'] = $key3['PIO_UPPJamS'];
            $pasing['PIO_PTorniquet'] = $key3['PIO_PTorniquet'];
            $pasing['PIO_PTLKa'] = $key3['PIO_PTLKa'];
            $pasing['PIO_PTLKaJM'] = $key3['PIO_PTLKaJM'];
            $pasing['PIO_PTLKaJS'] = $key3['PIO_PTLKaJS'];
            $pasing['PIO_PTLKaT'] = $key3['PIO_PTLKaT'];
            $pasing['PIO_PTLKi'] = $key3['PIO_PTLKi'];
            $pasing['PIO_PTLKiJM'] = $key3['PIO_PTLKiJM'];
            $pasing['PIO_PTLKiJS'] = $key3['PIO_PTLKiJS'];
            $pasing['PIO_PTLKiT'] = $key3['PIO_PTLKiT'];
            $pasing['PIO_PTPKa'] = $key3['PIO_PTPKa'];
            $pasing['PIO_PTPKaJM'] = $key3['PIO_PTPKaJM'];
            $pasing['PIO_PTPKaJS'] = $key3['PIO_PTPKaJS'];
            $pasing['PIO_PTPKaT'] = $key3['PIO_PTPKaT'];
            $pasing['PIO_PTPKi'] = $key3['PIO_PTPKi'];
            $pasing['PIO_PTPKiJM'] = $key3['PIO_PTPKiJM'];
            $pasing['PIO_PTPKiJS'] = $key3['PIO_PTPKiJS'];
            $pasing['PIO_PTPKiT'] = $key3['PIO_PTPKiT'];
            $pasing['PIO_PTorqDiawasiO'] = $key3['PIO_PTorqDiawasiO'];
            $pasing['PIO_PImplant'] = $key3['PIO_PImplant'];
            $pasing['PIO_Perdarahan'] = $key3['PIO_Perdarahan'];
            $pasing['PIO_PDrain'] = $key3['PIO_PDrain'];
            $pasing['PIO_LokasiDrain'] = $key3['PIO_LokasiDrain'];
            $pasing['PIO_IrigasiLuka'] = $key3['PIO_IrigasiLuka'];
            $pasing['PIO_PCairan'] = $key3['PIO_PCairan'];
            $pasing['PIO_JumlahCairan'] = $key3['PIO_JumlahCairan'];
            $pasing['PIO_Balutan'] = $key3['PIO_Balutan'];
            $pasing['PIO_Spesimen'] = $key3['PIO_Spesimen'];
            $pasing['PIO_JenisJaringan'] = $key3['PIO_JenisJaringan'];
            $pasing['PIO_JmlJaringan'] = $key3['PIO_JmlJaringan'];
            $pasing['PIO_TipeFiksasi'] = $key3['PIO_TipeFiksasi'];
            $pasing['PIO_Keterangan'] = $key3['PIO_Keterangan'];

            //SIGIN
            $pasing['SI_IGP'] = $key4['SI_IGP'];
            $pasing['SI_IC'] = $key4['SI_IC'];
            $pasing['SI_NamaOperator'] = $key4['SI_NamaOperator'];
            $pasing['SI_NamaTindakan'] = $key4['SI_NamaTindakan'];
            $pasing['SI_LokasiTindakan'] = $key4['SI_LokasiTindakan'];
            $pasing['SI_TDO'] = $key4['SI_TDO'];
            $pasing['SI_PKAnestesi'] = $key4['SI_PKAnestesi'];
            $pasing['SI_PMAnestesi'] = $key4['SI_PMAnestesi'];
            $pasing['SI_PAlatInstrumen'] = $key4['SI_PAlatInstrumen'];
            $pasing['SI_PSterilInstrumen'] = $key4['SI_PSterilInstrumen'];
            $pasing['SI_RAsma'] = $key4['SI_RAsma'];
            $pasing['SI_KetSignIn'] = $key4['SI_KetSignIn'];
            $pasing['SI_RAlergi'] = $key4['SI_RAlergi'];
            $pasing['SI_PerawatanKhusus'] = $key4['SI_PerawatanKhusus'];
            $pasing['SI_DokLab'] = $key4['SI_DokLab'];
            $pasing['SI_DokRadiologi'] = $key4['SI_DokRadiologi'];
            $pasing['SI_PDarah'] = $key4['SI_PDarah'];
            $pasing['SI_TglSignin'] = $key4['SI_TglSignin'];
            $pasing['SI_JamSignIn'] = $key4['SI_JamSignIn'];
            $pasing['SI_PerawatAnestesi'] = $key4['SI_PerawatAnestesi'];
            $pasing['SI_DokterAnestesi'] = $key4['SI_DokterAnestesi'];
            $pasing['SI_Keterangan'] = $key4['SI_Keterangan'];
            $pasing['oksimeter'] = $key4['oksimeter'];
            $pasing['Tim_sholat'] = $key4['Tim_sholat'];

            //TIME OUT
            $pasing['TO_IP'] = $key5['TO_IP'];
            $pasing['TO_TglTindakan'] = $key5['TO_TglTindakan'];
            $pasing['TO_LO'] = $key5['TO_LO'];
            $pasing['TO_NamaTim'] = $key5['TO_NamaTim'];
            $pasing['TO_PO'] = $key5['TO_PO'];
            $pasing['TO_TanggalTindakan'] = $key5['TO_TanggalTindakan'];
            $pasing['TO_Premedikasi'] = $key5['TO_Premedikasi'];
            $pasing['TO_DiberikanJam'] = $key5['TO_DiberikanJam'];
            $pasing['TO_Antibiotik'] = $key5['TO_Antibiotik'];
            $pasing['TO_FotoRadiologi'] = $key5['TO_FotoRadiologi'];
            $pasing['TO_Keterangan'] = $key5['TO_Keterangan'];
            $pasing['TO_Perhatian'] = $key5['TO_Perhatian'];
            $pasing['TO_Jam'] = $key5['TO_Jam'];
            $pasing['TO_DokterBedah'] = $key5['TO_DokterBedah'];
            $pasing['TO_drAnestesi'] = $key5['TO_drAnestesi'];
            $pasing['TO_PerawatSirkulasi'] = $key5['TO_PerawatSirkulasi'];
            $pasing['PerawatInstrumen'] = $key5['PerawatInstrumen'];
            $pasing['mendoakan_pasien'] = $key5['mendoakan_pasien'];
            $pasing['TO_PerawatAnestesi'] = $key5['TO_PerawatAnestesi'];
            $pasing['TO_PerawatAsisten'] = $key5['TO_PerawatAsisten'];
            $pasing['PerawatSirkuler'] = $key5['PerawatSirkuler'];


            $pasing['SO_Membacakan'] = $key6['SO_Membacakan'];
            $pasing['SO_JumlahInstrumen'] = $key6['SO_JumlahInstrumen'];
            $pasing['SO_ProsedurTindakan'] = $key6['SO_ProsedurTindakan'];
            $pasing['SO_PJaringan'] = $key6['SO_PJaringan'];
            $pasing['SO_Implant'] = $key6['SO_Implant'];
            $pasing['SO_KerusakanAlat'] = $key6['SO_KerusakanAlat'];
            $pasing['SO_JenisInstrument'] = $key6['SO_JenisInstrument'];
            $pasing['SO_Doa'] = $key6['SO_Doa'];
            $pasing['SO_Jam'] = $key6['SO_Jam'];
            $pasing['SO_drBedah'] = $key6['SO_drBedah'];
            $pasing['SO_drSerkuler'] = $key6['SO_drSerkuler'];


            //SERAH TERIMA RR
            $pasing['Tgl'] = $key7['Tgl'];
            $pasing['JenisTindakan'] = $key7['JenisTindakan'];
            $pasing['DokterBedah'] = $key7['DokterBedah'];
            $pasing['DokterAnestesi'] = $key7['DokterAnestesi'];
            $pasing['Drain'] = $key7['Drain'];
            $pasing['JenisDrain'] = $key7['JenisDrain'];
            $pasing['Catheter'] = $key7['Catheter'];
            $pasing['NoCatheter'] = $key7['NoCatheter'];
            $pasing['BalonCatheter'] = $key7['BalonCatheter'];
            $pasing['Bungkusan'] = $key7['Bungkusan'];
            $pasing['JenisBungkusan'] = $key7['JenisBungkusan'];
            $pasing['Patologi'] = $key7['Patologi'];
            $pasing['Kultur'] = $key7['Kultur'];
            $pasing['Prothesis'] = $key7['Prothesis'];
            $pasing['JenisProthesis'] = $key7['JenisProthesis'];
            $pasing['Perdarahan'] = $key7['Perdarahan'];
            $pasing['ICOperasi'] = $key7['ICOperasi'];
            $pasing['LaporanOP'] = $key7['LaporanOP'];
            $pasing['DaftarObat'] = $key7['DaftarObat'];
            $pasing['InstruksiPostOP'] = $key7['InstruksiPostOP'];
            $pasing['CeklistAlkes'] = $key7['CeklistAlkes'];
            $pasing['SSC'] = $key7['SSC'];
            $pasing['FKSterilisasi'] = $key7['FKSterilisasi'];
            $pasing['DokumenRadiologi'] = $key7['DokumenRadiologi'];
            $pasing['DokumenFoto'] = $key7['DokumenFoto'];
            $pasing['DokumenUSG'] = $key7['DokumenUSG'];
            $pasing['Keterangan_PB'] = $key7['Keterangan_PB'];
            $pasing['JenisAnestesi'] = $key7['JenisAnestesi'];
            $pasing['Kesadaran'] = $key7['Kesadaran'];
            $pasing['TD'] = $key7['TD'];
            $pasing['Nadi'] = $key7['Nadi'];
            $pasing['RR'] = $key7['RR'];
            $pasing['SO2'] = $key7['SO2'];
            $pasing['Suhu'] = $key7['Suhu'];
            $pasing['Analgetik'] = $key7['Analgetik'];
            $pasing['Antibiotik'] = $key7['Antibiotik'];
            $pasing['Jam'] = $key7['Jam'];
            $pasing['Intake'] = $key7['Intake'];
            $pasing['Output'] = $key7['Output'];
            $pasing['SI_Anestesi'] = $key7['SI_Anestesi'];
            $pasing['PraBedah'] = $key7['PraBedah'];
            $pasing['CatatanAnestesi'] = $key7['CatatanAnestesi'];
            $pasing['KetAnestesi'] = $key7['KetAnestesi'];
            $pasing['PerawatBedah'] = $key7['PerawatBedah'];
            $pasing['PerawatAnastesi'] = $key7['PerawatAnastesi'];


            // POST OPERASI
            $pasing['RPulihSadar'] = $key8['RPulihSadar'];
            $pasing['JamMasuk'] = $key8['JamMasuk'];
            $pasing['JamKeluar'] = $key8['JamKeluar'];
            $pasing['KembaliKe'] = $key8['KembaliKe'];
            $pasing['KeadaanUmum'] = $key8['KeadaanUmum'];
            $pasing['Kesadaran'] = $key8['Kesadaran'];
            $pasing['JalanNafasDatang'] = $key8['JalanNafasDatang'];
            $pasing['JalanNafasKeluar'] = $key8['JalanNafasKeluar'];
            $pasing['TerapiO2'] = $key8['TerapiO2'];
            $pasing['JenisO2'] = $key8['JenisO2'];
            $pasing['KulitDatang'] = $key8['KulitDatang'];
            $pasing['KulitKeluar'] = $key8['KulitKeluar'];
            $pasing['PosisiPasien'] = $key8['PosisiPasien'];
            $pasing['Keterangan'] = $key8['Keterangan'];
            $pasing['Cemas'] = $key8['Cemas'];
            $pasing['Cedera'] = $key8['Cedera'];
            $pasing['Nyeri'] = $key8['Nyeri'];
            $pasing['Infeksi'] = $key8['Infeksi'];
            $pasing['Hipertermi'] = $key8['Hipertermi'];
            $pasing['Hipotermi'] = $key8['Hipotermi'];
            $pasing['IntegritasKulit'] = $key8['IntegritasKulit'];
            $pasing['PerawatanMandiri'] = $key8['PerawatanMandiri'];
            $pasing['PTK'] = $key8['PTK'];
            $pasing['LFL'] = $key8['LFL'];
            $pasing['PPObat'] = $key8['PPObat'];
            $pasing['PerawatanLuka'] = $key8['PerawatanLuka'];
            $pasing['Diet'] = $key8['Diet'];
            $pasing['BAktifitasFisik'] = $key8['BAktifitasFisik'];
            $pasing['BantuanMedis'] = $key8['BantuanMedis'];


            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    public function setSavePreOperasiNA($data)
    {
        try {
            $this->db->transaksi();

            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $useridx = $session->IDEmployee;

            // DATA PASING
            $emr_nama = $data['emr_nama'];
            $emr_norm = $data['emr_norm'];
            $emr_noreg = $data['emr_noreg'];
            $emr_noeps = $data['emr_noeps'];
            $emr_idorder = $data['emr_idorder'];
            // $form_preop = $data['form_preop'];
            $emr_preop_keadaanumum = $data['emr_preop_keadaanumum'];
            $emr_preop_totalscorecgs = $data['emr_preop_totalscorecgs'];
            $emr_preop_bukamata = $data['emr_preop_bukamata'];
            $emr_preop_motorik = $data['emr_preop_motorik'];
            $emr_preop_verbal = $data['emr_preop_verbal'];

            $emr_preop_kesadaran = $data['emr_preop_kesadaran'];
            $emr_preop_tekanandarah = $data['emr_preop_tekanandarah'];
            $emr_preop_tekanandarahmmhg = $data['emr_preop_tekanandarahmmhg'];
            $emr_preop_suhu = $data['emr_preop_suhu'];
            $emr_preop_nadi = $data['emr_preop_nadi'];
            $emr_preop_pernapasan = $data['emr_preop_pernapasan'];
            $emr_preop_riwayatpernapasan = $data['emr_preop_riwayatpernapasan'];
            $emr_preop_pengobatansaatini = $data['emr_preop_pengobatansaatini'];
            $emr_preop_pengobatansaatiniket = $data['emr_preop_pengobatansaatiniket'];
            $emr_preop_hasilpenunjang = $data['emr_preop_hasilpenunjang'];
            $emr_preop_statuspsikologi = $data['emr_preop_statuspsikologi'];
            $emr_preop_spiritualagama = $data['emr_preop_spiritualagama'];
            // $emr_preop_userinput = $data['emr_preop_userinput'];

            //CEGAT NULL
            if ($emr_preop_totalscorecgs == '') {
                $emr_preop_totalscorecgs = 0;
            }
            if ($emr_preop_bukamata == '') {
                $emr_preop_bukamata = 0;
            }
            if ($emr_preop_motorik == '') {
                $emr_preop_motorik = 0;
            }
            if ($emr_preop_verbal == '') {
                $emr_preop_verbal = 0;
            }

            if ($emr_preop_tekanandarah == '') {
                $emr_preop_tekanandarah = 0;
            }
            if ($emr_preop_tekanandarahmmhg == '') {
                $emr_preop_tekanandarahmmhg = 0;
            }
            if ($emr_preop_suhu == '') {
                $emr_preop_suhu = 0;
            }
            if ($emr_preop_nadi == '') {
                $emr_preop_nadi = 0;
            }

            //CEK DATA
            $this->db->query("SELECT COUNT(ID) cekOutpatientOperasi FROM EMR.dbo.MR_Pre_Operatifs WHERE NoRegistrasi = :emr_noreg AND IdOrderOperasi = :emr_idorder");
            $this->db->bind('emr_noreg', $emr_noreg);
            $this->db->bind('emr_idorder', $emr_idorder);
            $dataoperasiNA =  $this->db->single();
            $cekformoperasina = $dataoperasiNA['cekOutpatientOperasi'];

            if ($cekformoperasina == "0") {
                $this->db->query("INSERT INTO EMR.dbo.MR_Pre_Operatifs
    ([NoMR] ,[NoEpisode] ,[NoRegistrasi] ,[TglPengkajian] ,[KeadaanUmum] ,[GCS] ,[GCS_E] ,[GCS_M] ,[GCS_V] ,[Kesadaran] 
    ,[TD_Sistole] ,[TD_Distole] ,[Suhu] ,[Nadi] ,[pernafasan] ,[RPD] ,[PengobatanSaatini] ,[PSI_Lainnya] ,[HasilLab] ,[StatusPsikologis] ,[Spiritual]
    ,[IdUserOrder] ,[NamaUserOrder] ,[IdOrderOperasi])
VALUES
    (:emr_norm ,:emr_noeps ,:emr_noreg ,:datenowcreate ,:emr_preop_keadaanumum ,:emr_preop_totalscorecgs ,:emr_preop_bukamata ,:emr_preop_motorik ,:emr_preop_verbal ,:emr_preop_kesadaran 
    ,:emr_preop_tekanandarah ,:emr_preop_tekanandarahmmhg ,:emr_preop_suhu ,:emr_preop_nadi ,:emr_preop_pernapasan ,:emr_preop_riwayatpernapasan ,:emr_preop_pengobatansaatini ,:emr_preop_pengobatansaatiniket ,:emr_preop_hasilpenunjang ,:emr_preop_statuspsikologi ,:emr_preop_spiritualagama ,:useridx ,:namauserx ,:emr_idorder)");
            } else {
                $this->db->query("UPDATE EMR.dbo.MR_Pre_Operatifs 
SET NoMR = :emr_norm,NoEpisode = :emr_noeps,TglPengkajian = :datenowcreate,KeadaanUmum = :emr_preop_keadaanumum,GCS = :emr_preop_totalscorecgs,GCS_E = :emr_preop_bukamata,GCS_M = :emr_preop_motorik,GCS_V = :emr_preop_verbal,Kesadaran = :emr_preop_kesadaran,TD_Sistole = :emr_preop_tekanandarah,TD_Distole = :emr_preop_tekanandarahmmhg,Suhu = :emr_preop_suhu,Nadi = :emr_preop_nadi,pernafasan = :emr_preop_pernapasan,RPD = :emr_preop_riwayatpernapasan,PengobatanSaatini = :emr_preop_pengobatansaatini,PSI_Lainnya = :emr_preop_pengobatansaatiniket,HasilLab = :emr_preop_hasilpenunjang,StatusPsikologis = :emr_preop_statuspsikologi,Spiritual = :emr_preop_spiritualagama
,IdUserOrder = :useridx ,NamaUserOrder = :namauserx
WHERE NoRegistrasi = :emr_noreg AND IdOrderOperasi = :emr_idorder");
            }

            $this->db->bind('emr_norm', $emr_norm);
            $this->db->bind('emr_noeps', $emr_noeps);
            $this->db->bind('emr_noreg', $emr_noreg);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('emr_preop_keadaanumum', $emr_preop_keadaanumum);
            $this->db->bind('emr_preop_totalscorecgs', $emr_preop_totalscorecgs);
            $this->db->bind('emr_preop_bukamata', $emr_preop_bukamata);
            $this->db->bind('emr_preop_motorik', $emr_preop_motorik);
            $this->db->bind('emr_preop_verbal', $emr_preop_verbal);
            $this->db->bind('emr_preop_kesadaran', $emr_preop_kesadaran);
            $this->db->bind('emr_preop_tekanandarah', $emr_preop_tekanandarah);
            $this->db->bind('emr_preop_tekanandarahmmhg', $emr_preop_tekanandarahmmhg);
            $this->db->bind('emr_preop_suhu', $emr_preop_suhu);
            $this->db->bind('emr_preop_nadi', $emr_preop_nadi);
            $this->db->bind('emr_preop_pernapasan', $emr_preop_pernapasan);
            $this->db->bind('emr_preop_riwayatpernapasan', $emr_preop_riwayatpernapasan);
            $this->db->bind('emr_preop_pengobatansaatini', $emr_preop_pengobatansaatini);
            $this->db->bind('emr_preop_pengobatansaatiniket', $emr_preop_pengobatansaatiniket);
            $this->db->bind('emr_preop_hasilpenunjang', $emr_preop_hasilpenunjang);
            $this->db->bind('emr_preop_statuspsikologi', $emr_preop_statuspsikologi);
            $this->db->bind('emr_preop_spiritualagama', $emr_preop_spiritualagama);
            $this->db->bind('useridx', $useridx);
            $this->db->bind('namauserx', $namauserx);
            $this->db->bind('emr_idorder', $emr_idorder);

            $this->db->execute();
            $this->db->commit();

            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function setSavePersiapanOperasiNA($data)
    {
        try {
            $this->db->transaksi();

            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;

            // DATA PASING
            $emr_nama = $data['emr_nama'];
            $emr_norm = $data['emr_norm'];
            $emr_noreg = $data['emr_noreg'];
            $emr_noeps = $data['emr_noeps'];
            $emr_idorder = $data['emr_idorder'];

            $emr_persiapanop_identitaspasien_pruangan = $data['emr_persiapanop_identitaspasien_pruangan'];
            $emr_persiapanop_identitaspasien_poti = $data['emr_persiapanop_identitaspasien_poti'];
            $emr_persiapanop_identitaspasienket = $data['emr_persiapanop_identitaspasienket'];
            $emr_persiapanop_identitasgelang_pruangan = $data['emr_persiapanop_identitasgelang_pruangan'];
            $emr_persiapanop_identitasgelang_poti = $data['emr_persiapanop_identitasgelang_poti'];
            $emr_persiapanop_identitasgelangket = $data['emr_persiapanop_identitasgelangket'];
            $emr_persiapanop_permintaanonline_pruangan = $data['emr_persiapanop_permintaanonline_pruangan'];
            $emr_persiapanop_permintaanonline_poti = $data['emr_persiapanop_permintaanonline_poti'];
            $emr_persiapanop_permintaanonlineket = $data['emr_persiapanop_permintaanonlineket'];
            $emr_persiapanop_jenislokasi_pruangan = $data['emr_persiapanop_jenislokasi_pruangan'];
            $emr_persiapanop_jenislokasi_poti = $data['emr_persiapanop_jenislokasi_poti'];
            $emr_persiapanop_jenislokasiket = $data['emr_persiapanop_jenislokasiket'];
            $emr_persiapanop_masalahkomunikasi_pruangan = $data['emr_persiapanop_masalahkomunikasi_pruangan'];
            $emr_persiapanop_masalahkomunikasi_poti = $data['emr_persiapanop_masalahkomunikasi_poti'];
            $emr_persiapanop_masalahkomunikasiket = $data['emr_persiapanop_masalahkomunikasiket'];
            $emr_persiapanop_persetujuanbedah_pruangan = $data['emr_persiapanop_persetujuanbedah_pruangan'];
            $emr_persiapanop_persetujuanbedah_poti = $data['emr_persiapanop_persetujuanbedah_poti'];
            $emr_persiapanop_persetujuanbedahket = $data['emr_persiapanop_persetujuanbedahket'];
            $emr_persiapanop_persetujuananastesi_pruangan = $data['emr_persiapanop_persetujuananastesi_pruangan'];
            $emr_persiapanop_persetujuananastesi_poti = $data['emr_persiapanop_persetujuananastesi_poti'];
            $emr_persiapanop_persetujuananastesiket = $data['emr_persiapanop_persetujuananastesiket'];
            $emr_persiapanop_pemeriksaaanpenunjang_pruangan = $data['emr_persiapanop_pemeriksaaanpenunjang_pruangan'];
            $emr_persiapanop_pemeriksaaanpenunjang_poti = $data['emr_persiapanop_pemeriksaaanpenunjang_poti'];
            $emr_persiapanop_pemeriksaaanpenunjangket = $data['emr_persiapanop_pemeriksaaanpenunjangket'];

            $emr_persiapanop_pasienpuas_pruangan = $data['emr_persiapanop_pasienpuas_pruangan'];
            $emr_persiapanop_pasienpuas_poti = $data['emr_persiapanop_pasienpuas_poti'];
            $emr_persiapanop_pasienpuasket = $data['emr_persiapanop_pasienpuasket'];
            $emr_persiapanop_protaseluarlepas_pruangan = $data['emr_persiapanop_protaseluarlepas_pruangan'];
            $emr_persiapanop_protaseluarlepas_poti = $data['emr_persiapanop_protaseluarlepas_poti'];
            $emr_persiapanop_protaseluarlepasket = $data['emr_persiapanop_protaseluarlepasket'];
            $emr_persiapanop_protasedalam_pruangan = $data['emr_persiapanop_protasedalam_pruangan'];
            $emr_persiapanop_protasedalam_poti = $data['emr_persiapanop_protasedalam_poti'];
            $emr_persiapanop_protasedalamket = $data['emr_persiapanop_protasedalamket'];
            $emr_persiapanop_perhiasandilepas_pruangan = $data['emr_persiapanop_perhiasandilepas_pruangan'];
            $emr_persiapanop_perhiasandilepas_poti = $data['emr_persiapanop_perhiasandilepas_poti'];
            $emr_persiapanop_perhiasandilepasket = $data['emr_persiapanop_perhiasandilepasket'];
            $emr_persiapanop_persiapankulit_pruangan = $data['emr_persiapanop_persiapankulit_pruangan'];
            $emr_persiapanop_persiapankulit_poti = $data['emr_persiapanop_persiapankulit_poti'];
            $emr_persiapanop_persiapankulitket = $data['emr_persiapanop_persiapankulitket'];
            $emr_persiapanop_klisma_pruangan = $data['emr_persiapanop_klisma_pruangan'];
            $emr_persiapanop_klisma_poti = $data['emr_persiapanop_klisma_poti'];
            $emr_persiapanop_klismaket = $data['emr_persiapanop_klismaket'];
            $emr_persiapanop_persiapandarah_pruangan = $data['emr_persiapanop_persiapandarah_pruangan'];
            $emr_persiapanop_persiapandarah_poti = $data['emr_persiapanop_persiapandarah_poti'];
            $emr_persiapanop_persiapandarahket = $data['emr_persiapanop_persiapandarahket'];
            $emr_persiapanop_alatbantu_pruangan = $data['emr_persiapanop_alatbantu_pruangan'];
            $emr_persiapanop_alatbantu_poti = $data['emr_persiapanop_alatbantu_poti'];
            $emr_persiapanop_alatbantuket = $data['emr_persiapanop_alatbantuket'];
            $emr_persiapanop_obatyangdisertakan_pruangan = $data['emr_persiapanop_obatyangdisertakan_pruangan'];
            $emr_persiapanop_obatyangdisertakan_poti = $data['emr_persiapanop_obatyangdisertakan_poti'];
            $emr_persiapanop_obatyangdisertakanket = $data['emr_persiapanop_obatyangdisertakanket'];
            $emr_persiapanop_obatterakhir_pruangan = $data['emr_persiapanop_obatterakhir_pruangan'];
            $emr_persiapanop_obatterakhir_poti = $data['emr_persiapanop_obatterakhir_poti'];
            $emr_persiapanop_obatterakhirket = $data['emr_persiapanop_obatterakhirket'];
            $emr_persiapanop_cimino_pruangan = $data['emr_persiapanop_cimino_pruangan'];
            $emr_persiapanop_cimino_poti = $data['emr_persiapanop_cimino_poti'];
            $emr_persiapanop_ciminoket = $data['emr_persiapanop_ciminoket'];
            $emr_persiapanop_userpruangan = $data['emr_persiapanop_userpruangan'];
            $emr_persiapanop_jaminputpruangan = $data['emr_persiapanop_jaminputpruangan'];
            $emr_persiapanop_jaminputpbedah = $data['emr_persiapanop_jaminputpbedah'];
            $emr_persiapanop_userpbedah = $data['emr_persiapanop_userpbedah'];

            $emr_persiapanop_sitemarketing = $data['emr_persiapanop_sitemarketing'];
            $emr_persiapanop_pasiensudahdijelaskan = $data['emr_persiapanop_pasiensudahdijelaskan'];
            $emr_persiapanop_sholat = $data['emr_persiapanop_sholat'];

            //CEGAT NULL
            // if ($emr_preop_totalscorecgs == '') {
            //     $emr_preop_totalscorecgs = 0;
            // }


            //CEGAT JIKA BELUM MENGISI PRE FORM PRE OPERASI

            $this->db->query("SELECT COUNT(ID) cekOutpatientOperasiPre FROM EMR.dbo.MR_Pre_Operatifs WHERE NoRegistrasi = :emr_noreg AND IdOrderOperasi =:emr_idorder");
            $this->db->bind('emr_noreg', $emr_noreg);
            $this->db->bind('emr_idorder', $emr_idorder);
            $dataoperasiNAPre =  $this->db->single();
            $cekformoperasinapre = $dataoperasiNAPre['cekOutpatientOperasiPre'];

            if ($cekformoperasinapre == "0") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'FORM PRE OPERASI BELUM DI ISI. Silakan isi terlebih dahulu / klik simpan pada form pre operasi !',
                );
                return $callback;
                exit;
            }

            //CEK DATA
            $this->db->query("SELECT COUNT(ID) cekOutpatientOperasi FROM EMR.dbo.MR_Persiapan_Operatifs WHERE NoRegistrasi = :emr_noreg AND IdOrderOperasi =:emr_idorder");
            $this->db->bind('emr_noreg', $emr_noreg);
            $this->db->bind('emr_idorder', $emr_idorder);
            $dataoperasiNA =  $this->db->single();
            $cekformoperasina = $dataoperasiNA['cekOutpatientOperasi'];

            if ($cekformoperasina == "0") {
                $this->db->query("INSERT INTO EMR.dbo.MR_Persiapan_Operatifs
    ([NoMR] ,[NoEpisode] ,[NoRegistrasi] 
    ,[VP_PIP_PR] ,[VP_PIP_OT] ,[VP_PIP_Note] ,[VP_PGI_PR] ,[VP_PGI_OT] ,[VP_PGI_Note] ,[VP_SPO_PR] ,[VP_SPO_OT] ,[VP_SPO_Note] 
    ,[VP_JLP_PR] ,[VP_JLP_OT] ,[VP_JLP_Note] ,[VP_MBK_PR] ,[VP_MBK_OT] ,[VP_MBK_Note] ,[VP_PKPP_PR] ,[VP_PKPP_OT] ,[VP_PKPP_Note] 
    ,[VP_PKPA_PR] ,[VP_PKPA_OT] ,[VP_PKPA_Note] ,[VP_PKRM_PR] ,[VP_PKRM_OT] ,[VP_PKRM_Note]
    ,[PFP_Puasa_PR] ,[PFP_Puasa_OT] ,[PFP_Puasa_Note] ,[PFP_ProtaseL_PR] ,[PFP_ProtaseL_OT] ,[PFP_ProtaseL_Note] ,[PFP_ProtaseD_PR] 
    ,[PFP_ProtaseD_OT] ,[PFP_ProtaseD_Note] ,[PFP_JLP_PR] ,[PFP_JLP_OT] ,[PFP_JLP_Note] ,[PFP_MB_PR] ,[PFP_MB_OT] ,[PFP_MB_Note] ,[PFP_Persetujuan_PR] 
    ,[PFP_Persetujuan_OT] ,[PFP_Persetujuan_Note] ,[PFP_PDarah_PR] ,[PFP_PDarah_OT] ,[PFP_PDarah_Note] ,[PFP_AB_PR] ,[PFP_AB_OT] ,[PFP_AB_Note] ,[PFP_Obat_PR] 
    ,[PFP_Obat_OT] ,[PFP_Obat_Note] ,[PFP_ObatTerahir_PR] ,[PFP_ObatTerahir_OT] ,[PFP_ObatTerahir_Note] ,[PFP_Cimino_PR] ,[PFP_Cimino_OT] ,[PFP_Cimino_Note] 
    ,[PFP_PerawatRuangan] ,[PFP_PR_Jam] ,[PFP_OT_Jam] ,[PFP_PerawatOT]
    ,[PLL_SiteMarking] ,[PLL_PSOD] ,[PLL_NamaPerawat] ,[PLL_tanggal] ,[PLL_Jam] ,[PLL_KegunaanManfaat] ,[sudah_sholat]
    ,[IdOrderOperasi])
VALUES
    (:emr_norm ,:emr_noeps ,:emr_noreg 
    ,:emr_persiapanop_identitaspasien_pruangan ,:emr_persiapanop_identitaspasien_poti ,:emr_persiapanop_identitaspasienket ,:emr_persiapanop_identitasgelang_pruangan ,:emr_persiapanop_identitasgelang_poti ,:emr_persiapanop_identitasgelangket ,:emr_persiapanop_permintaanonline_pruangan ,:emr_persiapanop_permintaanonline_poti ,:emr_persiapanop_permintaanonlineket 
    ,:emr_persiapanop_jenislokasi_pruangan ,:emr_persiapanop_jenislokasi_poti ,:emr_persiapanop_jenislokasiket ,:emr_persiapanop_masalahkomunikasi_pruangan ,:emr_persiapanop_masalahkomunikasi_poti ,:emr_persiapanop_masalahkomunikasiket ,:emr_persiapanop_persetujuanbedah_pruangan ,:emr_persiapanop_persetujuanbedah_poti ,:emr_persiapanop_persetujuanbedahket
    ,:emr_persiapanop_persetujuananastesi_pruangan ,:emr_persiapanop_persetujuananastesi_poti ,:emr_persiapanop_persetujuananastesiket ,:emr_persiapanop_pemeriksaaanpenunjang_pruangan ,:emr_persiapanop_pemeriksaaanpenunjang_poti ,:emr_persiapanop_pemeriksaaanpenunjangket
    ,:emr_persiapanop_pasienpuas_pruangan ,:emr_persiapanop_pasienpuas_poti ,:emr_persiapanop_pasienpuasket ,:emr_persiapanop_protaseluarlepas_pruangan ,:emr_persiapanop_protaseluarlepas_poti ,:emr_persiapanop_protaseluarlepasket ,:emr_persiapanop_protasedalam_pruangan ,:emr_persiapanop_protasedalam_poti ,:emr_persiapanop_protasedalamket ,
    :emr_persiapanop_perhiasandilepas_pruangan ,:emr_persiapanop_perhiasandilepas_poti ,:emr_persiapanop_perhiasandilepasket ,:emr_persiapanop_persiapankulit_pruangan ,:emr_persiapanop_persiapankulit_poti ,:emr_persiapanop_persiapankulitket ,:emr_persiapanop_klisma_pruangan ,:emr_persiapanop_klisma_poti ,:emr_persiapanop_klismaket ,:emr_persiapanop_persiapandarah_pruangan 
    ,:emr_persiapanop_persiapandarah_poti ,:emr_persiapanop_persiapandarahket ,:emr_persiapanop_alatbantu_pruangan ,:emr_persiapanop_alatbantu_poti ,:emr_persiapanop_alatbantuket ,:emr_persiapanop_obatyangdisertakan_pruangan ,:emr_persiapanop_obatyangdisertakan_poti ,:emr_persiapanop_obatyangdisertakanket ,:emr_persiapanop_obatterakhir_pruangan ,:emr_persiapanop_obatterakhir_poti 
    ,:emr_persiapanop_obatterakhirket ,:emr_persiapanop_cimino_pruangan ,:emr_persiapanop_cimino_poti ,:emr_persiapanop_ciminoket ,:emr_persiapanop_userpruangan ,:emr_persiapanop_jaminputpruangan ,:emr_persiapanop_jaminputpbedah ,:emr_persiapanop_userpbedah
    ,:emr_persiapanop_sitemarketing , NULL , :namauserx ,:datenowx ,:datenowcreate ,:emr_persiapanop_pasiensudahdijelaskan ,:emr_persiapanop_sholat
    ,:emr_idorder)");
            } else {
                $this->db->query("UPDATE EMR.dbo.MR_Persiapan_Operatifs 
SET 
NoMR = :emr_norm ,NoEpisode = :emr_noeps ,VP_PIP_PR = :emr_persiapanop_identitaspasien_pruangan  ,VP_PIP_OT = :emr_persiapanop_identitaspasien_poti  
,VP_PIP_Note = :emr_persiapanop_identitaspasienket  ,VP_PGI_PR = :emr_persiapanop_identitasgelang_pruangan  ,VP_PGI_OT = :emr_persiapanop_identitasgelang_poti  
,VP_PGI_Note = :emr_persiapanop_identitasgelangket  ,VP_SPO_PR = :emr_persiapanop_permintaanonline_pruangan  ,VP_SPO_OT = :emr_persiapanop_permintaanonline_poti  
,VP_SPO_Note = :emr_persiapanop_permintaanonlineket ,VP_JLP_PR = :emr_persiapanop_jenislokasi_pruangan  ,VP_JLP_OT = :emr_persiapanop_jenislokasi_poti  
,VP_JLP_Note = :emr_persiapanop_jenislokasiket  ,VP_MBK_PR = :emr_persiapanop_masalahkomunikasi_pruangan  ,VP_MBK_OT = :emr_persiapanop_masalahkomunikasi_poti  
,VP_MBK_Note = :emr_persiapanop_masalahkomunikasiket  ,VP_PKPP_PR = :emr_persiapanop_persetujuanbedah_pruangan  ,VP_PKPP_OT = :emr_persiapanop_persetujuanbedah_poti  
,VP_PKPP_Note = :emr_persiapanop_persetujuanbedahket ,VP_PKPA_PR = :emr_persiapanop_persetujuananastesi_pruangan  ,VP_PKPA_OT = :emr_persiapanop_persetujuananastesi_poti  
,VP_PKPA_Note = :emr_persiapanop_persetujuananastesiket  ,VP_PKRM_PR = :emr_persiapanop_pemeriksaaanpenunjang_pruangan  
,VP_PKRM_OT = :emr_persiapanop_pemeriksaaanpenunjang_poti  ,VP_PKRM_Note = :emr_persiapanop_pemeriksaaanpenunjangket
,PFP_Puasa_PR = :emr_persiapanop_pasienpuas_pruangan ,PFP_Puasa_OT = :emr_persiapanop_pasienpuas_poti ,PFP_Puasa_Note = :emr_persiapanop_pasienpuasket 
,PFP_ProtaseL_PR = :emr_persiapanop_protaseluarlepas_pruangan ,PFP_ProtaseL_OT = :emr_persiapanop_protaseluarlepas_poti ,PFP_ProtaseL_Note = :emr_persiapanop_protaseluarlepasket 
,PFP_ProtaseD_PR = :emr_persiapanop_protasedalam_pruangan ,PFP_ProtaseD_OT = :emr_persiapanop_protasedalam_poti ,PFP_ProtaseD_Note = :emr_persiapanop_protasedalamket 
,PFP_JLP_PR = :emr_persiapanop_perhiasandilepas_pruangan ,PFP_JLP_OT = :emr_persiapanop_perhiasandilepas_poti ,PFP_JLP_Note = :emr_persiapanop_perhiasandilepasket 
,PFP_MB_PR = :emr_persiapanop_persiapankulit_pruangan ,PFP_MB_OT = :emr_persiapanop_persiapankulit_poti ,PFP_MB_Note = :emr_persiapanop_persiapankulitket 
,PFP_Persetujuan_PR = :emr_persiapanop_klisma_pruangan ,PFP_Persetujuan_OT = :emr_persiapanop_klisma_poti ,PFP_Persetujuan_Note = :emr_persiapanop_klismaket 
,PFP_PDarah_PR = :emr_persiapanop_persiapandarah_pruangan ,PFP_PDarah_OT = :emr_persiapanop_persiapandarah_poti ,PFP_PDarah_Note = :emr_persiapanop_persiapandarahket 
,PFP_AB_PR = :emr_persiapanop_alatbantu_pruangan ,PFP_AB_OT = :emr_persiapanop_alatbantu_poti ,PFP_AB_Note = :emr_persiapanop_alatbantuket ,PFP_Obat_PR = :emr_persiapanop_obatyangdisertakan_pruangan 
,PFP_Obat_OT = :emr_persiapanop_obatyangdisertakan_poti ,PFP_Obat_Note = :emr_persiapanop_obatyangdisertakanket ,PFP_ObatTerahir_PR = :emr_persiapanop_obatterakhir_pruangan ,PFP_ObatTerahir_OT = :emr_persiapanop_obatterakhir_poti 
,PFP_ObatTerahir_Note = :emr_persiapanop_obatterakhirket ,PFP_Cimino_PR = :emr_persiapanop_cimino_pruangan ,PFP_Cimino_OT = :emr_persiapanop_cimino_poti ,PFP_Cimino_Note = :emr_persiapanop_ciminoket 
,PFP_PerawatRuangan = :emr_persiapanop_userpruangan ,PFP_PR_Jam = :emr_persiapanop_jaminputpruangan ,PFP_OT_Jam = :emr_persiapanop_jaminputpbedah ,PFP_PerawatOT = :emr_persiapanop_userpbedah
,PLL_SiteMarking = :emr_persiapanop_sitemarketing ,PLL_PSOD = NULL ,PLL_NamaPerawat = :namauserx ,PLL_tanggal = :datenowx ,PLL_Jam = :datenowcreate  ,PLL_KegunaanManfaat = :emr_persiapanop_pasiensudahdijelaskan ,sudah_sholat = :emr_persiapanop_sholat
WHERE NoRegistrasi = :emr_noreg AND IdOrderOperasi = :emr_idorder");
            }

            $this->db->bind('emr_norm', $emr_norm);
            $this->db->bind('emr_noreg', $emr_noreg);
            $this->db->bind('emr_noeps', $emr_noeps);
            $this->db->bind('emr_persiapanop_identitaspasien_pruangan', $emr_persiapanop_identitaspasien_pruangan);
            $this->db->bind('emr_persiapanop_identitaspasien_poti', $emr_persiapanop_identitaspasien_poti);
            $this->db->bind('emr_persiapanop_identitaspasienket', $emr_persiapanop_identitaspasienket);
            $this->db->bind('emr_persiapanop_identitasgelang_pruangan', $emr_persiapanop_identitasgelang_pruangan);
            $this->db->bind('emr_persiapanop_identitasgelang_poti', $emr_persiapanop_identitasgelang_poti);
            $this->db->bind('emr_persiapanop_identitasgelangket', $emr_persiapanop_identitasgelangket);
            $this->db->bind('emr_persiapanop_permintaanonline_pruangan', $emr_persiapanop_permintaanonline_pruangan);
            $this->db->bind('emr_persiapanop_permintaanonline_poti', $emr_persiapanop_permintaanonline_poti);
            $this->db->bind('emr_persiapanop_permintaanonlineket', $emr_persiapanop_permintaanonlineket);
            $this->db->bind('emr_persiapanop_jenislokasi_pruangan', $emr_persiapanop_jenislokasi_pruangan);
            $this->db->bind('emr_persiapanop_jenislokasi_poti', $emr_persiapanop_jenislokasi_poti);
            $this->db->bind('emr_persiapanop_jenislokasiket', $emr_persiapanop_jenislokasiket);
            $this->db->bind('emr_persiapanop_masalahkomunikasi_pruangan', $emr_persiapanop_masalahkomunikasi_pruangan);
            $this->db->bind('emr_persiapanop_masalahkomunikasi_poti', $emr_persiapanop_masalahkomunikasi_poti);
            $this->db->bind('emr_persiapanop_masalahkomunikasiket', $emr_persiapanop_masalahkomunikasiket);
            $this->db->bind('emr_persiapanop_persetujuanbedah_pruangan', $emr_persiapanop_persetujuanbedah_pruangan);
            $this->db->bind('emr_persiapanop_persetujuanbedah_poti', $emr_persiapanop_persetujuanbedah_poti);
            $this->db->bind('emr_persiapanop_persetujuanbedahket', $emr_persiapanop_persetujuanbedahket);
            $this->db->bind('emr_persiapanop_persetujuananastesi_pruangan', $emr_persiapanop_persetujuananastesi_pruangan);
            $this->db->bind('emr_persiapanop_persetujuananastesi_poti', $emr_persiapanop_persetujuananastesi_poti);
            $this->db->bind('emr_persiapanop_persetujuananastesiket', $emr_persiapanop_persetujuananastesiket);
            $this->db->bind('emr_persiapanop_pemeriksaaanpenunjang_pruangan', $emr_persiapanop_pemeriksaaanpenunjang_pruangan);
            $this->db->bind('emr_persiapanop_pemeriksaaanpenunjang_poti', $emr_persiapanop_pemeriksaaanpenunjang_poti);
            $this->db->bind('emr_persiapanop_pemeriksaaanpenunjangket', $emr_persiapanop_pemeriksaaanpenunjangket);

            $this->db->bind('emr_persiapanop_pasienpuas_pruangan', $emr_persiapanop_pasienpuas_pruangan);
            $this->db->bind('emr_persiapanop_pasienpuas_poti', $emr_persiapanop_pasienpuas_poti);
            $this->db->bind('emr_persiapanop_pasienpuasket', $emr_persiapanop_pasienpuasket);
            $this->db->bind('emr_persiapanop_protaseluarlepas_pruangan', $emr_persiapanop_protaseluarlepas_pruangan);
            $this->db->bind('emr_persiapanop_protaseluarlepas_poti', $emr_persiapanop_protaseluarlepas_poti);
            $this->db->bind('emr_persiapanop_protaseluarlepasket', $emr_persiapanop_protaseluarlepasket);
            $this->db->bind('emr_persiapanop_protasedalam_pruangan', $emr_persiapanop_protasedalam_pruangan);
            $this->db->bind('emr_persiapanop_protasedalam_poti', $emr_persiapanop_protasedalam_poti);
            $this->db->bind('emr_persiapanop_protasedalamket', $emr_persiapanop_protasedalamket);
            $this->db->bind('emr_persiapanop_perhiasandilepas_pruangan', $emr_persiapanop_perhiasandilepas_pruangan);
            $this->db->bind('emr_persiapanop_perhiasandilepas_poti', $emr_persiapanop_perhiasandilepas_poti);
            $this->db->bind('emr_persiapanop_perhiasandilepasket', $emr_persiapanop_perhiasandilepasket);
            $this->db->bind('emr_persiapanop_persiapankulit_pruangan', $emr_persiapanop_persiapankulit_pruangan);
            $this->db->bind('emr_persiapanop_persiapankulit_poti', $emr_persiapanop_persiapankulit_poti);
            $this->db->bind('emr_persiapanop_persiapankulitket', $emr_persiapanop_persiapankulitket);
            $this->db->bind('emr_persiapanop_klisma_pruangan', $emr_persiapanop_klisma_pruangan);
            $this->db->bind('emr_persiapanop_klisma_poti', $emr_persiapanop_klisma_poti);
            $this->db->bind('emr_persiapanop_klismaket', $emr_persiapanop_klismaket);
            $this->db->bind('emr_persiapanop_persiapandarah_pruangan', $emr_persiapanop_persiapandarah_pruangan);
            $this->db->bind('emr_persiapanop_persiapandarah_poti', $emr_persiapanop_persiapandarah_poti);
            $this->db->bind('emr_persiapanop_persiapandarahket', $emr_persiapanop_persiapandarahket);
            $this->db->bind('emr_persiapanop_alatbantu_pruangan', $emr_persiapanop_alatbantu_pruangan);
            $this->db->bind('emr_persiapanop_alatbantu_poti', $emr_persiapanop_alatbantu_poti);
            $this->db->bind('emr_persiapanop_alatbantuket', $emr_persiapanop_alatbantuket);
            $this->db->bind('emr_persiapanop_obatyangdisertakan_pruangan', $emr_persiapanop_obatyangdisertakan_pruangan);
            $this->db->bind('emr_persiapanop_obatyangdisertakan_poti', $emr_persiapanop_obatyangdisertakan_poti);
            $this->db->bind('emr_persiapanop_obatyangdisertakanket', $emr_persiapanop_obatyangdisertakanket);
            $this->db->bind('emr_persiapanop_obatterakhir_pruangan', $emr_persiapanop_obatterakhir_pruangan);
            $this->db->bind('emr_persiapanop_obatterakhir_poti', $emr_persiapanop_obatterakhir_poti);
            $this->db->bind('emr_persiapanop_obatterakhirket', $emr_persiapanop_obatterakhirket);
            $this->db->bind('emr_persiapanop_cimino_pruangan', $emr_persiapanop_cimino_pruangan);
            $this->db->bind('emr_persiapanop_cimino_poti', $emr_persiapanop_cimino_poti);
            $this->db->bind('emr_persiapanop_ciminoket', $emr_persiapanop_ciminoket);
            $this->db->bind('emr_persiapanop_userpruangan', $emr_persiapanop_userpruangan);
            $this->db->bind('emr_persiapanop_jaminputpruangan', $emr_persiapanop_jaminputpruangan);
            $this->db->bind('emr_persiapanop_jaminputpbedah', $emr_persiapanop_jaminputpbedah);
            $this->db->bind('emr_persiapanop_userpbedah', $emr_persiapanop_userpbedah);

            $this->db->bind('emr_persiapanop_sitemarketing', $emr_persiapanop_sitemarketing);
            $this->db->bind('emr_persiapanop_pasiensudahdijelaskan', $emr_persiapanop_pasiensudahdijelaskan);
            $this->db->bind('emr_persiapanop_sholat', $emr_persiapanop_sholat);
            $this->db->bind('datenowx', $datenowx);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('namauserx', $namauserx);

            $this->db->bind('emr_idorder', $emr_idorder);


            $this->db->execute();
            $this->db->commit();

            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }


    public function setSaveIntraOperasiNA($data)
    {
        try {
            $this->db->transaksi();

            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $useridx = $session->IDEmployee;

            // DATA PASING
            $emr_nama = $data['emr_nama'];
            $emr_norm = $data['emr_norm'];
            $emr_noreg = $data['emr_noreg'];
            $emr_noeps = $data['emr_noeps'];
            $emr_idorder = $data['emr_idorder'];

            $emr_intraop_timeout = $data['emr_intraop_timeout'];
            $emr_intraop_timeoutjam = $data['emr_intraop_timeoutjam'];
            $emr_intraop_cekkesediaanbarang = $data['emr_intraop_cekkesediaanbarang'];
            $emr_intraop_cekkesediaanbarangjam = $data['emr_intraop_cekkesediaanbarangjam'];
            $emr_intraop_ainstrumen = $data['emr_intraop_ainstrumen'];
            $emr_intraop_bprotase = $data['emr_intraop_bprotase'];
            $emr_intraop_jammulai = $data['emr_intraop_jammulai'];
            $emr_intraop_jamselesai = $data['emr_intraop_jamselesai'];
            $emr_intraop_operasidilakukan = $data['emr_intraop_operasidilakukan'];
            $emr_intraop_tipeoperasi = $data['emr_intraop_tipeoperasi'];
            $emr_intraop_jenisoperasi = $data['emr_intraop_jenisoperasi'];
            $emr_intraop_statusemosi = $data['emr_intraop_statusemosi'];
            $emr_intraop_posisikanul = $data['emr_intraop_posisikanul'];
            $emr_intraop_posisilengan = $data['emr_intraop_posisilengan'];
            $emr_intraop_posisialatbantudigunakan = $data['emr_intraop_posisialatbantudigunakan'];
            $emr_intraop_memakaikateterurine = $data['emr_intraop_memakaikateterurine'];
            $emr_intraop_perskulit = $data['emr_intraop_perskulit'];
            $emr_intraop_makaidiathermy = $data['emr_intraop_makaidiathermy'];

            $emr_intraop_lokasielektroda = $data['emr_intraop_lokasielektroda'];
            $emr_intraop_dipasangoleh = $data['emr_intraop_dipasangoleh'];
            $emr_intraop_pemeriksakondisisebelum = $data['emr_intraop_pemeriksakondisisebelum'];
            $emr_intraop_pemeriksakondisisesudah = $data['emr_intraop_pemeriksakondisisesudah'];
            $emr_intraop_kodeunitelektro = $data['emr_intraop_kodeunitelektro'];
            $emr_intraop_unitpemanaspendingin = $data['emr_intraop_unitpemanaspendingin'];
            $emr_intraop_pengaturan = $data['emr_intraop_pengaturan'];
            $emr_intraop_temperatur = $data['emr_intraop_temperatur'];
            $emr_intraop_jammulai12 = $data['emr_intraop_jammulai12'];
            $emr_intraop_jamselesai12 = $data['emr_intraop_jamselesai12'];
            $emr_intraop_pakaitourniquet = $data['emr_intraop_pakaitourniquet'];
            $emr_timeoutop_lengankananjammulai = $data['emr_timeoutop_lengankananjammulai'];
            $emr_timeoutop_lengankananjamselesai = $data['emr_timeoutop_lengankananjamselesai'];
            $emr_timeoutop_lengankanantekanan = $data['emr_timeoutop_lengankanantekanan'];
            $emr_timeoutop_lengankirijammulai = $data['emr_timeoutop_lengankirijammulai'];
            $emr_timeoutop_lengankirijamselesai = $data['emr_timeoutop_lengankirijamselesai'];
            $emr_timeoutop_lengankiritekanan = $data['emr_timeoutop_lengankiritekanan'];
            $emr_timeoutop_pahakananjammulai = $data['emr_timeoutop_pahakananjammulai'];
            $emr_timeoutop_pahakananjamselesai = $data['emr_timeoutop_pahakananjamselesai'];
            $emr_timeoutop_pahakanantekanan = $data['emr_timeoutop_pahakanantekanan'];
            $emr_timeoutop_pahakirijammulai = $data['emr_timeoutop_pahakirijammulai'];
            $emr_timeoutop_pahakirijamselesai = $data['emr_timeoutop_pahakirijamselesai'];
            $emr_timeoutop_pahakiritekanan = $data['emr_timeoutop_pahakiritekanan'];
            $emr_intraop_diawasioleh = $data['emr_intraop_diawasioleh'];
            $emr_intraop_pemakaianimplant = $data['emr_intraop_pemakaianimplant'];
            $emr_intraop_pendarahan = $data['emr_intraop_pendarahan'];
            $emr_intraop_pemakaiandrain = $data['emr_intraop_pemakaiandrain'];
            $emr_intraop_pemakaiandrainlokasi = $data['emr_intraop_pemakaiandrainlokasi'];
            $emr_intraop_irigasiluka = $data['emr_intraop_irigasiluka'];
            $emr_intraop_pemakaiancairan = $data['emr_intraop_pemakaiancairan'];
            $emr_intraop_pemakaiancairanjumlah = $data['emr_intraop_pemakaiancairanjumlah'];
            $emr_intraop_balutan = $data['emr_intraop_balutan'];
            $emr_intraop_spesimen = $data['emr_intraop_spesimen'];
            $emr_intraop_jenisjaringan = $data['emr_intraop_jenisjaringan'];
            $emr_intraop_jenisjaringanjumlah = $data['emr_intraop_jenisjaringanjumlah'];
            $emr_intraop_tipefiksasi = $data['emr_intraop_tipefiksasi'];
            $emr_intraop_keterangan = $data['emr_intraop_keterangan'];
            $checkbox_lengankanan = $data['checkbox_lengankanan'];
            $checkbox_lengankiri = $data['checkbox_lengankiri'];
            $checkbox_pahakanan = $data['checkbox_pahakanan'];
            $checkbox_pahakiri = $data['checkbox_pahakiri'];


            // CEGAT NULL
            if ($emr_intraop_temperatur == '') {
                $emr_intraop_temperatur = 0;
            }

            if ($emr_timeoutop_lengankanantekanan == '') {
                $emr_timeoutop_lengankanantekanan = 0;
            }

            if ($emr_timeoutop_lengankiritekanan == '') {
                $emr_timeoutop_lengankiritekanan = 0;
            }

            if ($emr_timeoutop_pahakanantekanan == '') {
                $emr_timeoutop_pahakanantekanan = 0;
            }

            if ($emr_timeoutop_pahakiritekanan == '') {
                $emr_timeoutop_pahakiritekanan = 0;
            }

            //CEGAT JIKA BELUM MENGISI PERSIAPAN FORM Persiapan

            $this->db->query("SELECT COUNT(ID) cekOutpatientOperasiPre FROM EMR.dbo.MR_SurgicalSafetyCheklistsTimeOuts WHERE NoRegistrasi = :emr_noreg AND IdOrderOperasi =:emr_idorder");
            $this->db->bind('emr_noreg', $emr_noreg);
            $this->db->bind('emr_idorder', $emr_idorder);
            $dataoperasiNAPers =  $this->db->single();
            $cekformoperasinapers = $dataoperasiNAPers['cekOutpatientOperasiPre'];

            if ($cekformoperasinapers == "0") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'FORM TIME OUT OPERASI BELUM DI ISI. Silakan isi terlebih dahulu / klik simpan pada form Time Out operasi !',
                );
                return $callback;
                exit;
            }

            //CEK DATA
            $this->db->query("SELECT COUNT(ID) cekOutpatientOperasi FROM EMR.dbo.MR_Intra_Operatifs WHERE NoRegistrasi = :emr_noreg AND IdOrderOperasi =:emr_idorder ");
            $this->db->bind('emr_noreg', $emr_noreg);
            $this->db->bind('emr_idorder', $emr_idorder);
            $dataoperasiNA =  $this->db->single();
            $cekformoperasina = $dataoperasiNA['cekOutpatientOperasi'];

            if ($cekformoperasina == "0") {
                // var_dump('insert');
                // exit;
                $this->db->query("INSERT INTO EMR.dbo.MR_Intra_Operatifs
    ([NoMR] ,[NoEpisode] ,[NoRegistrasi] 
    ,[PIO_TimeOut] ,[PIO_TOJam] ,[PIO_CKPF] ,[PIO_CKPFJam] ,[PIO_Instrumen] ,[PIO_Protase] ,[PIO_MulaiJam] ,[PIO_SelesaiJam] ,[PIO_Operasi] ,[PIO_TipeOP] ,[PIO_JenisAnestesi] 
    ,[PIO_Emosi] ,[PIO_PosisiKanul] ,[PIO_PosisiOP] ,[PIO_PosisiLengan] ,[PIO_PosisiAlatB] ,[PIO_Kateter] ,[PIO_PersiapanKulit] ,[PIO_Diathermy]
    
    ,[PIO_LElektroda] ,[PIO_ELDPO] ,[PIO_PKKSBOP] ,[PIO_PKKSTOP] ,[PIO_KUE] ,[PIO_UPP] ,[PIO_UPPP] ,[PIO_UPPTemp] ,[PIO_UPPJamM] ,[PIO_UPPJamS] ,[PIO_PTorniquet] ,[PIO_PTLKa] 
    ,[PIO_PTLKaJM] ,[PIO_PTLKaJS] ,[PIO_PTLKaT] ,[PIO_PTLKi] ,[PIO_PTLKiJM] ,[PIO_PTLKiJS] ,[PIO_PTLKiT] ,[PIO_PTPKa] ,[PIO_PTPKaJM] ,[PIO_PTPKaJS] ,[PIO_PTPKaT] ,[PIO_PTPKi] 
    ,[PIO_PTPKiJM] ,[PIO_PTPKiJS] ,[PIO_PTPKiT] ,[PIO_PTorqDiawasiO] ,[PIO_PImplant] ,[PIO_Perdarahan] ,[PIO_PDrain] ,[PIO_LokasiDrain] ,[PIO_IrigasiLuka] ,[PIO_PCairan] 
    ,[PIO_JumlahCairan] ,[PIO_Balutan] ,[PIO_Spesimen] ,[PIO_JenisJaringan] ,[PIO_JmlJaringan] ,[PIO_TipeFiksasi] ,[PIO_Keterangan]

    ,[IdUserOrder] ,[NamaUserOrder] ,[IdOrderOperasi]
    )
VALUES
    (:emr_norm ,:emr_noeps ,:emr_noreg 
    ,:emr_intraop_timeout ,:emr_intraop_timeoutjam ,:emr_intraop_cekkesediaanbarang ,:emr_intraop_cekkesediaanbarangjam ,:emr_intraop_ainstrumen ,:emr_intraop_bprotase 
    ,:emr_intraop_jammulai ,:emr_intraop_jamselesai ,:emr_intraop_operasidilakukan ,:emr_intraop_tipeoperasi ,:emr_intraop_jenisoperasi ,:emr_intraop_statusemosi 
    ,:emr_intraop_posisikanul ,NULL ,:emr_intraop_posisilengan ,:emr_intraop_posisialatbantudigunakan ,:emr_intraop_memakaikateterurine ,:emr_intraop_perskulit 
    ,:emr_intraop_makaidiathermy
    
    ,:emr_intraop_lokasielektroda ,:emr_intraop_dipasangoleh ,:emr_intraop_pemeriksakondisisebelum ,:emr_intraop_pemeriksakondisisesudah ,:emr_intraop_kodeunitelektro 
    ,:emr_intraop_unitpemanaspendingin ,:emr_intraop_pengaturan ,:emr_intraop_temperatur ,:emr_intraop_jammulai12 ,:emr_intraop_jamselesai12 ,:emr_intraop_pakaitourniquet 
    ,:checkbox_lengankanan ,:emr_timeoutop_lengankananjammulai ,:emr_timeoutop_lengankananjamselesai ,:emr_timeoutop_lengankanantekanan ,:checkbox_lengankiri 
    ,:emr_timeoutop_lengankirijammulai ,:emr_timeoutop_lengankirijamselesai ,:emr_timeoutop_lengankiritekanan ,:checkbox_pahakanan ,:emr_timeoutop_pahakananjammulai 
    ,:emr_timeoutop_pahakananjamselesai ,:emr_timeoutop_pahakanantekanan ,:checkbox_pahakiri ,:emr_timeoutop_pahakirijammulai ,:emr_timeoutop_pahakirijamselesai 
    ,:emr_timeoutop_pahakiritekanan ,:emr_intraop_diawasioleh ,:emr_intraop_pemakaianimplant ,:emr_intraop_pendarahan ,:emr_intraop_pemakaiandrain ,:emr_intraop_pemakaiandrainlokasi 
    ,:emr_intraop_irigasiluka ,:emr_intraop_pemakaiancairan ,:emr_intraop_pemakaiancairanjumlah ,:emr_intraop_balutan ,:emr_intraop_spesimen ,:emr_intraop_jenisjaringan 
    ,:emr_intraop_jenisjaringanjumlah ,:emr_intraop_tipefiksasi ,:emr_intraop_keterangan
    
    ,:useridx ,:namauserx ,:emr_idorder
    )");
            } else {
                // var_dump('update');
                // exit;
                $this->db->query("UPDATE EMR.dbo.MR_Intra_Operatifs 
SET 
NoMR = :emr_norm ,NoEpisode = :emr_noeps 
,PIO_TimeOut = :emr_intraop_timeout ,PIO_TOJam = :emr_intraop_timeoutjam ,PIO_CKPF = :emr_intraop_cekkesediaanbarang ,PIO_CKPFJam = :emr_intraop_cekkesediaanbarangjam 
,PIO_Instrumen = :emr_intraop_ainstrumen ,PIO_Protase = :emr_intraop_bprotase ,PIO_MulaiJam = :emr_intraop_jammulai ,PIO_SelesaiJam = :emr_intraop_jamselesai 
,PIO_Operasi = :emr_intraop_operasidilakukan ,PIO_TipeOP = :emr_intraop_tipeoperasi ,PIO_JenisAnestesi = :emr_intraop_jenisoperasi ,PIO_Emosi = :emr_intraop_statusemosi 
,PIO_PosisiKanul = :emr_intraop_posisikanul ,PIO_PosisiOP = NULL ,PIO_PosisiLengan = :emr_intraop_posisilengan ,PIO_PosisiAlatB = :emr_intraop_posisialatbantudigunakan 
,PIO_Kateter = :emr_intraop_memakaikateterurine ,PIO_PersiapanKulit = :emr_intraop_perskulit ,PIO_Diathermy = :emr_intraop_makaidiathermy

,PIO_LElektroda = :emr_intraop_lokasielektroda ,PIO_ELDPO = :emr_intraop_dipasangoleh ,PIO_PKKSBOP = :emr_intraop_pemeriksakondisisebelum ,PIO_PKKSTOP = :emr_intraop_pemeriksakondisisesudah 
,PIO_KUE = :emr_intraop_kodeunitelektro ,PIO_UPP = :emr_intraop_unitpemanaspendingin ,PIO_UPPP = :emr_intraop_pengaturan ,PIO_UPPTemp = :emr_intraop_temperatur 
,PIO_UPPJamM = :emr_intraop_jammulai12 ,PIO_UPPJamS = :emr_intraop_jamselesai12 ,PIO_PTorniquet = :emr_intraop_pakaitourniquet ,PIO_PTLKa = :checkbox_lengankanan 
,PIO_PTLKaJM = :emr_timeoutop_lengankananjammulai ,PIO_PTLKaJS = :emr_timeoutop_lengankananjamselesai ,PIO_PTLKaT = :emr_timeoutop_lengankanantekanan ,PIO_PTLKi = :checkbox_lengankiri 
,PIO_PTLKiJM = :emr_timeoutop_lengankirijammulai ,PIO_PTLKiJS = :emr_timeoutop_lengankirijamselesai ,PIO_PTLKiT = :emr_timeoutop_lengankiritekanan ,PIO_PTPKa = :checkbox_pahakanan 
,PIO_PTPKaJM = :emr_timeoutop_pahakananjammulai ,PIO_PTPKaJS = :emr_timeoutop_pahakananjamselesai ,PIO_PTPKaT = :emr_timeoutop_pahakanantekanan ,PIO_PTPKi = :checkbox_pahakiri 
,PIO_PTPKiJM = :emr_timeoutop_pahakirijammulai ,PIO_PTPKiJS = :emr_timeoutop_pahakirijamselesai ,PIO_PTPKiT = :emr_timeoutop_pahakiritekanan ,PIO_PTorqDiawasiO = :emr_intraop_diawasioleh 
,PIO_PImplant = :emr_intraop_pemakaianimplant ,PIO_Perdarahan = :emr_intraop_pendarahan ,PIO_PDrain = :emr_intraop_pemakaiandrain ,PIO_LokasiDrain = :emr_intraop_pemakaiandrainlokasi 
,PIO_IrigasiLuka = :emr_intraop_irigasiluka ,PIO_PCairan = :emr_intraop_pemakaiancairan ,PIO_JumlahCairan = :emr_intraop_pemakaiancairanjumlah ,PIO_Balutan = :emr_intraop_balutan 
,PIO_Spesimen = :emr_intraop_spesimen ,PIO_JenisJaringan = :emr_intraop_jenisjaringan ,PIO_JmlJaringan = :emr_intraop_jenisjaringanjumlah ,PIO_TipeFiksasi = :emr_intraop_tipefiksasi 
,PIO_Keterangan = :emr_intraop_keterangan

,IdUserOrder = :useridx ,NamaUserOrder = :namauserx
WHERE NoRegistrasi = :emr_noreg AND IdOrderOperasi = :emr_idorder");
            }

            $this->db->bind('emr_norm', $emr_norm);
            $this->db->bind('emr_noreg', $emr_noreg);
            $this->db->bind('emr_noeps', $emr_noeps);

            $this->db->bind('emr_intraop_timeout', $emr_intraop_timeout);
            $this->db->bind('emr_intraop_timeoutjam', $emr_intraop_timeoutjam);
            $this->db->bind('emr_intraop_cekkesediaanbarang', $emr_intraop_cekkesediaanbarang);
            $this->db->bind('emr_intraop_cekkesediaanbarangjam', $emr_intraop_cekkesediaanbarangjam);
            $this->db->bind('emr_intraop_ainstrumen', $emr_intraop_ainstrumen);
            $this->db->bind('emr_intraop_bprotase', $emr_intraop_bprotase);
            $this->db->bind('emr_intraop_jammulai', $emr_intraop_jammulai);
            $this->db->bind('emr_intraop_jamselesai', $emr_intraop_jamselesai);
            $this->db->bind('emr_intraop_operasidilakukan', $emr_intraop_operasidilakukan);
            $this->db->bind('emr_intraop_tipeoperasi', $emr_intraop_tipeoperasi);
            $this->db->bind('emr_intraop_jenisoperasi', $emr_intraop_jenisoperasi);
            $this->db->bind('emr_intraop_statusemosi', $emr_intraop_statusemosi);
            $this->db->bind('emr_intraop_posisikanul', $emr_intraop_posisikanul);
            $this->db->bind('emr_intraop_posisilengan', $emr_intraop_posisilengan);
            $this->db->bind('emr_intraop_posisialatbantudigunakan', $emr_intraop_posisialatbantudigunakan);
            $this->db->bind('emr_intraop_memakaikateterurine', $emr_intraop_memakaikateterurine);
            $this->db->bind('emr_intraop_perskulit', $emr_intraop_perskulit);
            $this->db->bind('emr_intraop_makaidiathermy', $emr_intraop_makaidiathermy);


            $this->db->bind('emr_intraop_lokasielektroda', $emr_intraop_lokasielektroda);
            $this->db->bind('emr_intraop_dipasangoleh', $emr_intraop_dipasangoleh);
            $this->db->bind('emr_intraop_pemeriksakondisisebelum', $emr_intraop_pemeriksakondisisebelum);
            $this->db->bind('emr_intraop_pemeriksakondisisesudah', $emr_intraop_pemeriksakondisisesudah);
            $this->db->bind('emr_intraop_kodeunitelektro', $emr_intraop_kodeunitelektro);
            $this->db->bind('emr_intraop_unitpemanaspendingin', $emr_intraop_unitpemanaspendingin);
            $this->db->bind('emr_intraop_pengaturan', $emr_intraop_pengaturan);
            $this->db->bind('emr_intraop_temperatur', $emr_intraop_temperatur);
            $this->db->bind('emr_intraop_jammulai12', $emr_intraop_jammulai12);
            $this->db->bind('emr_intraop_jamselesai12', $emr_intraop_jamselesai12);
            $this->db->bind('emr_intraop_pakaitourniquet', $emr_intraop_pakaitourniquet);
            $this->db->bind('emr_timeoutop_lengankananjammulai', $emr_timeoutop_lengankananjammulai);
            $this->db->bind('emr_timeoutop_lengankananjamselesai', $emr_timeoutop_lengankananjamselesai);
            $this->db->bind('emr_timeoutop_lengankanantekanan', $emr_timeoutop_lengankanantekanan);
            $this->db->bind('emr_timeoutop_lengankirijammulai', $emr_timeoutop_lengankirijammulai);
            $this->db->bind('emr_timeoutop_lengankirijamselesai', $emr_timeoutop_lengankirijamselesai);
            $this->db->bind('emr_timeoutop_lengankiritekanan', $emr_timeoutop_lengankiritekanan);
            $this->db->bind('emr_timeoutop_pahakananjammulai', $emr_timeoutop_pahakananjammulai);
            $this->db->bind('emr_timeoutop_pahakananjamselesai', $emr_timeoutop_pahakananjamselesai);
            $this->db->bind('emr_timeoutop_pahakanantekanan', $emr_timeoutop_pahakanantekanan);
            $this->db->bind('emr_timeoutop_pahakirijammulai', $emr_timeoutop_pahakirijammulai);
            $this->db->bind('emr_timeoutop_pahakirijamselesai', $emr_timeoutop_pahakirijamselesai);
            $this->db->bind('emr_timeoutop_pahakiritekanan', $emr_timeoutop_pahakiritekanan);
            $this->db->bind('emr_intraop_diawasioleh', $emr_intraop_diawasioleh);
            $this->db->bind('emr_intraop_pemakaianimplant', $emr_intraop_pemakaianimplant);
            $this->db->bind('emr_intraop_pendarahan', $emr_intraop_pendarahan);
            $this->db->bind('emr_intraop_pemakaiandrain', $emr_intraop_pemakaiandrain);
            $this->db->bind('emr_intraop_pemakaiandrainlokasi', $emr_intraop_pemakaiandrainlokasi);
            $this->db->bind('emr_intraop_irigasiluka', $emr_intraop_irigasiluka);
            $this->db->bind('emr_intraop_pemakaiancairan', $emr_intraop_pemakaiancairan);
            $this->db->bind('emr_intraop_pemakaiancairanjumlah', $emr_intraop_pemakaiancairanjumlah);
            $this->db->bind('emr_intraop_balutan', $emr_intraop_balutan);
            $this->db->bind('emr_intraop_spesimen', $emr_intraop_spesimen);
            $this->db->bind('emr_intraop_jenisjaringan', $emr_intraop_jenisjaringan);
            $this->db->bind('emr_intraop_jenisjaringanjumlah', $emr_intraop_jenisjaringanjumlah);
            $this->db->bind('emr_intraop_tipefiksasi', $emr_intraop_tipefiksasi);
            $this->db->bind('emr_intraop_keterangan', $emr_intraop_keterangan);
            $this->db->bind('checkbox_lengankanan', $checkbox_lengankanan);
            $this->db->bind('checkbox_lengankiri', $checkbox_lengankiri);
            $this->db->bind('checkbox_pahakanan', $checkbox_pahakanan);
            $this->db->bind('checkbox_pahakiri', $checkbox_pahakiri);

            $this->db->bind('useridx', $useridx);
            $this->db->bind('emr_idorder', $emr_idorder);
            $this->db->bind('namauserx', $namauserx);

            $this->db->execute();
            $this->db->commit();

            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function setSaveSignInOperasiNA($data)
    {
        try {
            $this->db->transaksi();

            // var_dump($data);
            // exit;

            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $useridx = $session->IDEmployee;

            // DATA PASING
            $emr_nama = $data['emr_nama'];
            $emr_norm = $data['emr_norm'];
            $emr_noreg = $data['emr_noreg'];
            $emr_noeps = $data['emr_noeps'];
            $emr_idorder = $data['emr_idorder'];

            $emr_signinop_namaoperator = $data['emr_signinop_namaoperator'];
            $emr_signinop_namatindakan = $data['emr_signinop_namatindakan'];
            $emr_signinop_lokasitindakan = $data['emr_signinop_lokasitindakan'];
            $emr_signinop_tandadaerahoprasi = $data['emr_signinop_tandadaerahoprasi'];
            $emr_signinop_riwayatasma = $data['emr_signinop_riwayatasma'];
            $emr_signinop_riwayatasmaket = $data['emr_signinop_riwayatasmaket'];
            $emr_signinop_riwayatalergi = $data['emr_signinop_riwayatalergi'];
            $emr_signinop_perawatankhususdiperlukan = $data['emr_signinop_perawatankhususdiperlukan'];
            $emr_signinop_resikokurangdarah = $data['emr_signinop_resikokurangdarah'];
            $emr_signinop_resikokurangdarahket = $data['emr_signinop_resikokurangdarahket'];
            $emr_signinop_oksimeterberfungsi = $data['emr_signinop_oksimeterberfungsi'];
            $emr_signinop_anggotatimsholat = $data['emr_signinop_anggotatimsholat'];
            $emr_signinop_jam = $data['emr_signinop_jam'];
            $emr_signinop_jakarta = $data['emr_signinop_jakarta'];
            $emr_signinop_dranastesi = $data['emr_signinop_dranastesi'];
            $emr_signinop_pranastesi = $data['emr_signinop_pranastesi'];

            $checkbox_emr_signinop_identitasgelang = $data['checkbox_emr_signinop_identitasgelang'];
            $checkbox_emr_signinop_informconsent = $data['checkbox_emr_signinop_informconsent'];
            $checkbox_emr_signinop_periksakelengkapananastesi = $data['checkbox_emr_signinop_periksakelengkapananastesi'];
            $checkbox_emr_signinop_cekmesinanastesi = $data['checkbox_emr_signinop_cekmesinanastesi'];
            $checkbox_emr_signinop_cekalatinstrumen = $data['checkbox_emr_signinop_cekalatinstrumen'];
            $checkbox_emr_signinop_ceksterilinstrumen = $data['checkbox_emr_signinop_ceksterilinstrumen'];
            $checkbox_emr_signinop_lab = $data['checkbox_emr_signinop_lab'];
            $checkbox_emr_signinop_rad = $data['checkbox_emr_signinop_rad'];


            // CEGAT NULL
            // if ($emr_intraop_temperatur == '') {
            //     $emr_intraop_temperatur = 0;
            // }


            //CEGAT JIKA BELUM MENGISI PERSIAPAN FORM PRE OPERASI

            $this->db->query("SELECT COUNT(ID) cekOutpatientOperasiPers FROM EMR.dbo.MR_Persiapan_Operatifs WHERE NoRegistrasi = :emr_noreg AND IdOrderOperasi =:emr_idorder");
            $this->db->bind('emr_noreg', $emr_noreg);
            $this->db->bind('emr_idorder', $emr_idorder);
            $dataoperasiNAPers =  $this->db->single();
            $cekformoperasinapers = $dataoperasiNAPers['cekOutpatientOperasiPers'];

            if ($cekformoperasinapers == "0") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'FORM PERSIAPAN OPERASI BELUM DI ISI. Silakan isi terlebih dahulu / klik simpan pada form Persiapan operasi !',
                );
                return $callback;
                exit;
            }

            //CEK DATA
            $this->db->query("SELECT COUNT(ID) cekOutpatientOperasi FROM EMR.dbo.MR_SurgicalSafetyCheklistSignIns WHERE NoRegistrasi = :emr_noreg AND IdOrderOperasi = :emr_idorder");
            $this->db->bind('emr_noreg', $emr_noreg);
            $this->db->bind('emr_idorder', $emr_idorder);
            $dataoperasiNA =  $this->db->single();
            $cekformoperasina = $dataoperasiNA['cekOutpatientOperasi'];

            if ($cekformoperasina == "0") {
                // var_dump('insert');
                // exit;
                $this->db->query("INSERT INTO EMR.dbo.MR_SurgicalSafetyCheklistSIgnIns
    ([NoMR] ,[NoEpisode] ,[NoRegistrasi] ,[SI_Tanggal] ,[SI_IGP] ,[SI_IC] ,[SI_NamaOperator] ,[SI_NamaTindakan] ,[SI_LokasiTindakan] ,[SI_TDO] ,[SI_PKAnestesi] ,[SI_PMAnestesi] ,[SI_PAlatInstrumen] ,[SI_PSterilInstrumen] ,[SI_RAsma] ,[SI_KetSignIn] ,[SI_RAlergi] ,[SI_PerawatanKhusus] ,[SI_DokLab] ,[SI_DokRadiologi] ,[SI_PDarah] ,[SI_TglSignin] ,[SI_JamSignIn] ,[SI_PerawatAnestesi] ,[SI_DokterAnestesi] ,[SI_Keterangan] ,[oksimeter] ,[Tim_sholat] ,[IdUserOrder] ,[NamaUserOrder] ,[IdOrderOperasi])
VALUES
    (:emr_norm ,:emr_noeps ,:emr_noreg ,:datenowcreate ,:checkbox_emr_signinop_identitasgelang ,:checkbox_emr_signinop_informconsent ,:emr_signinop_namaoperator ,:emr_signinop_namatindakan ,:emr_signinop_lokasitindakan ,:emr_signinop_tandadaerahoprasi ,:checkbox_emr_signinop_periksakelengkapananastesi ,:checkbox_emr_signinop_cekmesinanastesi ,:checkbox_emr_signinop_cekalatinstrumen ,:checkbox_emr_signinop_ceksterilinstrumen ,:emr_signinop_riwayatasma ,:emr_signinop_riwayatasmaket ,:emr_signinop_riwayatalergi ,:emr_signinop_perawatankhususdiperlukan ,:checkbox_emr_signinop_lab ,:checkbox_emr_signinop_rad ,:emr_signinop_resikokurangdarah ,:emr_signinop_jakarta ,:emr_signinop_jam ,:emr_signinop_pranastesi ,:emr_signinop_dranastesi ,:emr_signinop_resikokurangdarahket ,:emr_signinop_oksimeterberfungsi ,:emr_signinop_anggotatimsholat ,:useridx ,:namauserx ,:emr_idorder)");
            } else {
                // var_dump('update');
                // exit;
                $this->db->query("UPDATE EMR.dbo.MR_SurgicalSafetyCheklistSIgnIns 
SET 
NoMR =:emr_norm ,NoEpisode =:emr_noeps ,SI_Tanggal =:datenowcreate ,SI_IGP =:checkbox_emr_signinop_identitasgelang ,SI_IC =:checkbox_emr_signinop_informconsent ,SI_NamaOperator =:emr_signinop_namaoperator ,SI_NamaTindakan =:emr_signinop_namatindakan ,SI_LokasiTindakan =:emr_signinop_lokasitindakan ,SI_TDO =:emr_signinop_tandadaerahoprasi ,SI_PKAnestesi =:checkbox_emr_signinop_periksakelengkapananastesi ,SI_PMAnestesi =:checkbox_emr_signinop_cekmesinanastesi ,SI_PAlatInstrumen =:checkbox_emr_signinop_cekalatinstrumen ,SI_PSterilInstrumen =:checkbox_emr_signinop_ceksterilinstrumen ,SI_RAsma =:emr_signinop_riwayatasma ,SI_KetSignIn =:emr_signinop_riwayatasmaket ,SI_RAlergi =:emr_signinop_riwayatalergi ,SI_PerawatanKhusus =:emr_signinop_perawatankhususdiperlukan ,SI_DokLab =:checkbox_emr_signinop_lab ,SI_DokRadiologi =:checkbox_emr_signinop_rad ,SI_PDarah =:emr_signinop_resikokurangdarah ,SI_TglSignin =:emr_signinop_jakarta ,SI_JamSignIn =:emr_signinop_jam ,SI_PerawatAnestesi =:emr_signinop_pranastesi ,SI_DokterAnestesi =:emr_signinop_dranastesi ,SI_Keterangan =:emr_signinop_resikokurangdarahket ,oksimeter =:emr_signinop_oksimeterberfungsi ,Tim_sholat =:emr_signinop_anggotatimsholat ,IdUserOrder =:useridx ,NamaUserOrder =:namauserx
WHERE NoRegistrasi = :emr_noreg AND IdOrderOperasi  =:emr_idorder");
            }

            $this->db->bind('emr_norm', $emr_norm);
            $this->db->bind('emr_noreg', $emr_noreg);
            $this->db->bind('emr_noeps', $emr_noeps);
            $this->db->bind('emr_idorder', $emr_idorder);

            $this->db->bind('emr_signinop_namaoperator', $emr_signinop_namaoperator);
            $this->db->bind('emr_signinop_namatindakan', $emr_signinop_namatindakan);
            $this->db->bind('emr_signinop_lokasitindakan', $emr_signinop_lokasitindakan);
            $this->db->bind('emr_signinop_tandadaerahoprasi', $emr_signinop_tandadaerahoprasi);
            $this->db->bind('emr_signinop_riwayatasma', $emr_signinop_riwayatasma);
            $this->db->bind('emr_signinop_riwayatasmaket', $emr_signinop_riwayatasmaket);
            $this->db->bind('emr_signinop_riwayatalergi', $emr_signinop_riwayatalergi);
            $this->db->bind('emr_signinop_perawatankhususdiperlukan', $emr_signinop_perawatankhususdiperlukan);
            $this->db->bind('emr_signinop_resikokurangdarah', $emr_signinop_resikokurangdarah);
            $this->db->bind('emr_signinop_resikokurangdarahket', $emr_signinop_resikokurangdarahket);
            $this->db->bind('emr_signinop_oksimeterberfungsi', $emr_signinop_oksimeterberfungsi);
            $this->db->bind('emr_signinop_anggotatimsholat', $emr_signinop_anggotatimsholat);
            $this->db->bind('emr_signinop_jam', $emr_signinop_jam);
            $this->db->bind('emr_signinop_jakarta', $emr_signinop_jakarta);
            $this->db->bind('emr_signinop_dranastesi', $emr_signinop_dranastesi);
            $this->db->bind('emr_signinop_pranastesi', $emr_signinop_pranastesi);

            $this->db->bind('checkbox_emr_signinop_identitasgelang', $checkbox_emr_signinop_identitasgelang);
            $this->db->bind('checkbox_emr_signinop_informconsent', $checkbox_emr_signinop_informconsent);
            $this->db->bind('checkbox_emr_signinop_periksakelengkapananastesi', $checkbox_emr_signinop_periksakelengkapananastesi);
            $this->db->bind('checkbox_emr_signinop_cekmesinanastesi', $checkbox_emr_signinop_cekmesinanastesi);
            $this->db->bind('checkbox_emr_signinop_cekalatinstrumen', $checkbox_emr_signinop_cekalatinstrumen);
            $this->db->bind('checkbox_emr_signinop_ceksterilinstrumen', $checkbox_emr_signinop_ceksterilinstrumen);
            $this->db->bind('checkbox_emr_signinop_lab', $checkbox_emr_signinop_lab);
            $this->db->bind('checkbox_emr_signinop_rad', $checkbox_emr_signinop_rad);

            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('namauserx', $namauserx);
            $this->db->bind('useridx', $useridx);

            $this->db->execute();
            $this->db->commit();

            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function setSaveTimeOutOperasiNA($data)
    {
        try {
            $this->db->transaksi();

            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $useridx = $session->IDEmployee;

            // DATA PASING
            $emr_nama = $data['emr_nama'];
            $emr_norm = $data['emr_norm'];
            $emr_noreg = $data['emr_noreg'];
            $emr_noeps = $data['emr_noeps'];
            $emr_idorder = $data['emr_idorder'];

            $checkbox_emr_timeoutop_identifikasipasien = $data['checkbox_emr_timeoutop_identifikasipasien'];
            $checkbox_emr_timeoutop_tgltindakan = $data['checkbox_emr_timeoutop_tgltindakan'];
            $checkbox_emr_timeoutop_lokasitindakan = $data['checkbox_emr_timeoutop_lokasitindakan'];
            $checkbox_emr_timeoutop_namatimoperasi = $data['checkbox_emr_timeoutop_namatimoperasi'];
            $checkbox_emr_timeoutop_proseduroperasi = $data['checkbox_emr_timeoutop_proseduroperasi'];
            $emr_timeoutop_jakarta = $data['emr_timeoutop_jakarta'];
            $emr_timeoutop_premedikasi = $data['emr_timeoutop_premedikasi'];
            $emr_timeoutop_diberikanjam = $data['emr_timeoutop_diberikanjam'];
            $emr_timeoutop_abtkprofilaks = $data['emr_timeoutop_abtkprofilaks'];
            $emr_timeoutop_fotoradiologi = $data['emr_timeoutop_fotoradiologi'];
            $emr_timeoutop_keterangan = $data['emr_timeoutop_keterangan'];
            $emr_timeoutop_haldiperhatikan = $data['emr_timeoutop_haldiperhatikan'];
            $emr_timeoutop_jam = $data['emr_timeoutop_jam'];
            $emr_timeoutop_droperator = $data['emr_timeoutop_droperator'];
            $emr_timeoutop_dranastesi = $data['emr_timeoutop_dranastesi'];
            $emr_timeoutop_prsirkulasi = $data['emr_timeoutop_prsirkulasi'];
            $emr_timeoutop_prinstrumen = $data['emr_timeoutop_prinstrumen'];
            $emr_timeoutop_doabersama = $data['emr_timeoutop_doabersama'];
            $emr_timeoutop_pranastesi = $data['emr_timeoutop_pranastesi'];
            $emr_timeoutop_prasisten = $data['emr_timeoutop_prasisten'];
            $emr_timeoutop_prsirkuler = $data['emr_timeoutop_prsirkuler'];

            // CEGAT NULL
            // if ($emr_intraop_temperatur == '') {
            //     $emr_intraop_temperatur = 0;
            // }


            //CEGAT JIKA BELUM MENGISI PERSIAPAN FORM PRE OPERASI

            $this->db->query("SELECT COUNT(ID) cekOutpatient FROM EMR.dbo.MR_SurgicalSafetyCheklistSignIns WHERE NoRegistrasi = :emr_noreg AND IdOrderOperasi =:emr_idorder");
            $this->db->bind('emr_noreg', $emr_noreg);
            $this->db->bind('emr_idorder', $emr_idorder);
            $dataoperasiNA =  $this->db->single();
            $cekformoperasina = $dataoperasiNA['cekOutpatient'];

            if ($cekformoperasina == "0") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'FORM SIGN BELUM DI ISI. Silakan isi terlebih dahulu / klik simpan pada form sign in operasi !',
                );
                return $callback;
                exit;
            }

            //CEK DATA
            $this->db->query("SELECT COUNT(ID) cekOutpatientOperasi FROM EMR.dbo.MR_SurgicalSafetyCheklistsTimeOuts WHERE NoRegistrasi = :emr_noreg AND IdOrderOperasi = :emr_idorder");
            $this->db->bind('emr_noreg', $emr_noreg);
            $this->db->bind('emr_idorder', $emr_idorder);
            $dataoperasiNA =  $this->db->single();
            $cekformoperasina = $dataoperasiNA['cekOutpatientOperasi'];

            if ($cekformoperasina == "0") {
                // var_dump('insert');
                // exit;
                $this->db->query("INSERT INTO EMR.dbo.MR_SurgicalSafetyCheklistsTimeOuts
    (
    [NoMR] ,[NoEpisode] ,[NoRegistrasi] ,[TO_IP] ,[TO_TglTindakan] ,[TO_LO] ,[TO_NamaTim] ,[TO_PO] ,[TO_TanggalTindakan] ,[TO_Premedikasi] ,[TO_DiberikanJam] ,[TO_Antibiotik] ,[TO_FotoRadiologi] ,[TO_Keterangan] ,[TO_Perhatian] ,[TO_Jam] ,[TO_DokterBedah] ,[TO_drAnestesi] ,[TO_PerawatSirkulasi] ,[PerawatInstrumen] ,[mendoakan_pasien] ,[TO_PerawatAnestesi] ,[TO_PerawatAsisten] ,[PerawatSirkuler] ,[IdUserOrder] ,[NamaUserOrder] ,[IdOrderOperasi]
    )
VALUES
    (
    :emr_norm ,:emr_noeps ,:emr_noreg ,:checkbox_emr_timeoutop_identifikasipasien ,:checkbox_emr_timeoutop_tgltindakan ,:checkbox_emr_timeoutop_lokasitindakan ,:checkbox_emr_timeoutop_namatimoperasi ,:checkbox_emr_timeoutop_proseduroperasi ,:emr_timeoutop_jakarta ,:emr_timeoutop_premedikasi ,:emr_timeoutop_diberikanjam ,:emr_timeoutop_abtkprofilaks ,:emr_timeoutop_fotoradiologi ,:emr_timeoutop_keterangan ,:emr_timeoutop_haldiperhatikan ,:emr_timeoutop_jam ,:emr_timeoutop_droperator ,:emr_timeoutop_dranastesi ,:emr_timeoutop_prsirkulasi ,:emr_timeoutop_prinstrumen ,:emr_timeoutop_doabersama ,:emr_timeoutop_pranastesi ,:emr_timeoutop_prasisten ,:emr_timeoutop_prsirkuler ,:useridx ,:namauserx ,:emr_idorder
    )");
            } else {
                // var_dump('update');
                // exit;
                $this->db->query("UPDATE EMR.dbo.MR_SurgicalSafetyCheklistsTimeOuts 
SET 
NoMR = :emr_norm ,NoEpisode = :emr_noeps ,TO_IP = :checkbox_emr_timeoutop_identifikasipasien ,TO_TglTindakan = :checkbox_emr_timeoutop_tgltindakan ,TO_LO = :checkbox_emr_timeoutop_lokasitindakan ,TO_NamaTim = :checkbox_emr_timeoutop_namatimoperasi ,TO_PO = :checkbox_emr_timeoutop_proseduroperasi ,TO_TanggalTindakan = :emr_timeoutop_jakarta ,TO_Premedikasi = :emr_timeoutop_premedikasi ,TO_DiberikanJam = :emr_timeoutop_diberikanjam ,TO_Antibiotik = :emr_timeoutop_abtkprofilaks ,TO_FotoRadiologi = :emr_timeoutop_fotoradiologi ,TO_Keterangan = :emr_timeoutop_keterangan ,TO_Perhatian = :emr_timeoutop_haldiperhatikan ,TO_Jam = :emr_timeoutop_jam ,TO_DokterBedah = :emr_timeoutop_droperator ,TO_drAnestesi = :emr_timeoutop_dranastesi ,TO_PerawatSirkulasi = :emr_timeoutop_prsirkulasi ,PerawatInstrumen = :emr_timeoutop_prinstrumen ,mendoakan_pasien = :emr_timeoutop_doabersama ,TO_PerawatAnestesi = :emr_timeoutop_pranastesi ,TO_PerawatAsisten = :emr_timeoutop_prasisten ,PerawatSirkuler = :emr_timeoutop_prsirkuler ,IdUserOrder = :useridx ,NamaUserOrder = :namauserx
WHERE NoRegistrasi = :emr_noreg AND IdOrderOperasi  =:emr_idorder");
            }

            $this->db->bind('emr_norm', $emr_norm);
            $this->db->bind('emr_noeps', $emr_noeps);
            $this->db->bind('emr_noreg', $emr_noreg);
            $this->db->bind('checkbox_emr_timeoutop_identifikasipasien', $checkbox_emr_timeoutop_identifikasipasien);
            $this->db->bind('checkbox_emr_timeoutop_tgltindakan', $checkbox_emr_timeoutop_tgltindakan);
            $this->db->bind('checkbox_emr_timeoutop_lokasitindakan', $checkbox_emr_timeoutop_lokasitindakan);
            $this->db->bind('checkbox_emr_timeoutop_namatimoperasi', $checkbox_emr_timeoutop_namatimoperasi);
            $this->db->bind('checkbox_emr_timeoutop_proseduroperasi', $checkbox_emr_timeoutop_proseduroperasi);
            $this->db->bind('emr_timeoutop_jakarta', $emr_timeoutop_jakarta);
            $this->db->bind('emr_timeoutop_premedikasi', $emr_timeoutop_premedikasi);
            $this->db->bind('emr_timeoutop_diberikanjam', $emr_timeoutop_diberikanjam);
            $this->db->bind('emr_timeoutop_abtkprofilaks', $emr_timeoutop_abtkprofilaks);
            $this->db->bind('emr_timeoutop_fotoradiologi', $emr_timeoutop_fotoradiologi);
            $this->db->bind('emr_timeoutop_keterangan', $emr_timeoutop_keterangan);
            $this->db->bind('emr_timeoutop_haldiperhatikan', $emr_timeoutop_haldiperhatikan);
            $this->db->bind('emr_timeoutop_jam', $emr_timeoutop_jam);
            $this->db->bind('emr_timeoutop_droperator', $emr_timeoutop_droperator);
            $this->db->bind('emr_timeoutop_dranastesi', $emr_timeoutop_dranastesi);
            $this->db->bind('emr_timeoutop_prsirkulasi', $emr_timeoutop_prsirkulasi);
            $this->db->bind('emr_timeoutop_prinstrumen', $emr_timeoutop_prinstrumen);
            $this->db->bind('emr_timeoutop_doabersama', $emr_timeoutop_doabersama);
            $this->db->bind('emr_timeoutop_pranastesi', $emr_timeoutop_pranastesi);
            $this->db->bind('emr_timeoutop_prasisten', $emr_timeoutop_prasisten);
            $this->db->bind('emr_timeoutop_prsirkuler', $emr_timeoutop_prsirkuler);
            $this->db->bind('useridx', $useridx);
            $this->db->bind('namauserx', $namauserx);
            $this->db->bind('emr_idorder', $emr_idorder);

            $this->db->execute();
            $this->db->commit();

            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function setSaveSignOutOperasiNA($data)
    {
        try {
            $this->db->transaksi();

            // var_dump($data);
            // exit;
            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $useridx = $session->IDEmployee;

            // DATA PASING
            $emr_nama = $data['emr_nama'];
            $emr_norm = $data['emr_norm'];
            $emr_noreg = $data['emr_noreg'];
            $emr_noeps = $data['emr_noeps'];
            $emr_idorder = $data['emr_idorder'];

            $checkbox_emr_signout_bacatindakansecaraverbal = $data['checkbox_emr_signout_bacatindakansecaraverbal'];
            $emr_signout_jumlahinstrumenkasajarum = $data['emr_signout_jumlahinstrumenkasajarum'];
            $emr_signout_prsedurtindakankhusus = $data['emr_signout_prsedurtindakankhusus'];
            $emr_signout_penangananjaringan = $data['emr_signout_penangananjaringan'];
            $emr_signout_pasangimplant = $data['emr_signout_pasangimplant'];
            $emr_signout_alatrusakselamatindakan = $data['emr_signout_alatrusakselamatindakan'];
            $emr_signout_alatrusakselamatindakanket = $data['emr_signout_alatrusakselamatindakanket'];
            $emr_signout_hamdalahdandoa = $data['emr_signout_hamdalahdandoa'];
            $emr_signoutop_jam = $data['emr_signoutop_jam'];
            $emr_signoutop_drserkuler = $data['emr_signoutop_drserkuler'];
            $emr_signoutop_drbedah = $data['emr_signoutop_drbedah'];

            // CEGAT NULL
            // if ($emr_intraop_temperatur == '') {
            //     $emr_intraop_temperatur = 0;
            // }


            //CEGAT JIKA BELUM MENGISI PERSIAPAN FORM PRE OPERASI

            $this->db->query("SELECT COUNT(ID) cekOutpatient FROM EMR.dbo.MR_Intra_Operatifs WHERE NoRegistrasi = :emr_noreg AND IdOrderOperasi =:emr_idorder");
            $this->db->bind('emr_noreg', $emr_noreg);
            $this->db->bind('emr_idorder', $emr_idorder);
            $dataoperasiNA =  $this->db->single();
            $cekformoperasina = $dataoperasiNA['cekOutpatient'];

            if ($cekformoperasina == "0") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'FORM INTRA OPERASI BELUM DI ISI. Silakan isi terlebih dahulu / klik simpan pada form intra operasi !',
                );
                return $callback;
                exit;
            }

            //CEK DATA
            $this->db->query("SELECT COUNT(ID) cekOutpatientOperasi FROM EMR.dbo.MR_SurgicalSafetyCheklistsSignOuts WHERE NoRegistrasi = :emr_noreg AND IdOrderOperasi = :emr_idorder");
            $this->db->bind('emr_noreg', $emr_noreg);
            $this->db->bind('emr_idorder', $emr_idorder);
            $dataoperasiNA =  $this->db->single();
            $cekformoperasina = $dataoperasiNA['cekOutpatientOperasi'];

            if ($cekformoperasina == "0") {
                // var_dump('insert');
                // exit;
                $this->db->query("INSERT INTO EMR.dbo.MR_SurgicalSafetyCheklistsSignOuts
    (
    [NoMR] ,[NoEpisode] ,[NoRegistrasi] ,[SO_Membacakan] ,[SO_JumlahInstrumen] ,[SO_ProsedurTindakan] ,[SO_PJaringan] ,[SO_Implant] ,[SO_KerusakanAlat] ,[SO_JenisInstrument] ,[SO_Doa] ,[SO_Jam] ,[SO_drBedah] ,[SO_drSerkuler] ,[IdUserOrder] ,[NamaUserOrder] ,[IdOrderOperasi]
    )
VALUES
    (
    :emr_norm ,:emr_noeps ,:emr_noreg ,:checkbox_emr_signout_bacatindakansecaraverbal ,:emr_signout_jumlahinstrumenkasajarum ,:emr_signout_prsedurtindakankhusus ,:emr_signout_penangananjaringan ,:emr_signout_pasangimplant ,:emr_signout_alatrusakselamatindakan ,:emr_signout_alatrusakselamatindakanket ,:emr_signout_hamdalahdandoa ,:emr_signoutop_jam ,:emr_signoutop_drserkuler ,:emr_signoutop_drbedah ,:useridx ,:namauserx ,:emr_idorder
    )");
            } else {
                // var_dump('update');
                // exit;
                $this->db->query("UPDATE EMR.dbo.MR_SurgicalSafetyCheklistsSignOuts 
SET 
NoMR = :emr_norm ,NoEpisode	= :emr_noeps ,SO_Membacakan = :checkbox_emr_signout_bacatindakansecaraverbal ,SO_JumlahInstrumen = :emr_signout_jumlahinstrumenkasajarum ,SO_ProsedurTindakan = :emr_signout_prsedurtindakankhusus ,SO_PJaringan = :emr_signout_penangananjaringan ,SO_Implant = :emr_signout_pasangimplant ,SO_KerusakanAlat = :emr_signout_alatrusakselamatindakan ,SO_JenisInstrument = :emr_signout_alatrusakselamatindakanket ,SO_Doa = :emr_signout_hamdalahdandoa ,SO_Jam = :emr_signoutop_jam ,SO_drBedah = :emr_signoutop_drserkuler ,SO_drSerkuler = :emr_signoutop_drbedah ,IdUserOrder = :useridx ,NamaUserOrder = :namauserx
WHERE NoRegistrasi = :emr_noreg AND IdOrderOperasi  =:emr_idorder");
            }

            $this->db->bind('emr_norm', $emr_norm);
            $this->db->bind('emr_noeps', $emr_noeps);
            $this->db->bind('emr_noreg', $emr_noreg);
            $this->db->bind('checkbox_emr_signout_bacatindakansecaraverbal', $checkbox_emr_signout_bacatindakansecaraverbal);
            $this->db->bind('emr_signout_jumlahinstrumenkasajarum', $emr_signout_jumlahinstrumenkasajarum);
            $this->db->bind('emr_signout_prsedurtindakankhusus', $emr_signout_prsedurtindakankhusus);
            $this->db->bind('emr_signout_penangananjaringan', $emr_signout_penangananjaringan);
            $this->db->bind('emr_signout_pasangimplant', $emr_signout_pasangimplant);
            $this->db->bind('emr_signout_alatrusakselamatindakan', $emr_signout_alatrusakselamatindakan);
            $this->db->bind('emr_signout_alatrusakselamatindakanket', $emr_signout_alatrusakselamatindakanket);
            $this->db->bind('emr_signout_hamdalahdandoa', $emr_signout_hamdalahdandoa);
            $this->db->bind('emr_signoutop_jam', $emr_signoutop_jam);
            $this->db->bind('emr_signoutop_drserkuler', $emr_signoutop_drserkuler);
            $this->db->bind('emr_signoutop_drbedah', $emr_signoutop_drbedah);
            $this->db->bind('useridx', $useridx);
            $this->db->bind('namauserx', $namauserx);
            $this->db->bind('emr_idorder', $emr_idorder);

            $this->db->execute();
            $this->db->commit();

            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function setSaveSerahTerimasOperasiNA($data)
    {
        try {
            $this->db->transaksi();

            // var_dump($data);
            // exit;
            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $useridx = $session->IDEmployee;

            // DATA PASING
            $emr_nama = $data['emr_nama'];
            $emr_norm = $data['emr_norm'];
            $emr_noreg = $data['emr_noreg'];
            $emr_noeps = $data['emr_noeps'];
            $emr_idorder = $data['emr_idorder'];

            $emr_serahterimarr_tgl = $data['emr_serahterimarr_tgl'];
            $emr_serahterimarr_jenistindakan = $data['emr_serahterimarr_jenistindakan'];
            $emr_serahterimarr_drbedah = $data['emr_serahterimarr_drbedah'];
            $emr_serahterimarr_dranestiologi = $data['emr_serahterimarr_dranestiologi'];
            $emr_serahterimarr_drain = $data['emr_serahterimarr_drain'];
            $emr_serahterimarr_jenisdrain = $data['emr_serahterimarr_jenisdrain'];
            $emr_serahterimarr_catheter = $data['emr_serahterimarr_catheter'];
            $emr_serahterimarr_catheterno = $data['emr_serahterimarr_catheterno'];
            $emr_serahterimarr_balon = $data['emr_serahterimarr_balon'];
            $emr_serahterimarr_balutanluka = $data['emr_serahterimarr_balutanluka'];
            $emr_serahterimarr_jenisbalutanluka = $data['emr_serahterimarr_jenisbalutanluka'];
            $emr_serahterimarr_patologi = $data['emr_serahterimarr_patologi'];
            $emr_serahterimarr_kultur = $data['emr_serahterimarr_kultur'];
            $emr_serahterimarr_prothesis = $data['emr_serahterimarr_prothesis'];
            $emr_serahterimarr_prothesisjenis = $data['emr_serahterimarr_prothesisjenis'];
            $emr_serahterimarr_pendarahan = $data['emr_serahterimarr_pendarahan'];
            $checkbox_emr_serahterimarr_checkperhitunganalkes = $data['checkbox_emr_serahterimarr_checkperhitunganalkes'];
            $checkbox_emr_serahterimarr_lapoperasi = $data['checkbox_emr_serahterimarr_lapoperasi'];
            $checkbox_emr_serahterimarr_daftarobat = $data['checkbox_emr_serahterimarr_daftarobat'];
            $checkbox_emr_serahterimarr_inspostoperasi = $data['checkbox_emr_serahterimarr_inspostoperasi'];
            $checkbox_emr_serahterimarr_surgicalsafety = $data['checkbox_emr_serahterimarr_surgicalsafety'];
            $checkbox_emr_serahterimarr_suratijinop = $data['checkbox_emr_serahterimarr_suratijinop'];
            $checkbox_emr_serahterimarr_formkondisisteril = $data['checkbox_emr_serahterimarr_formkondisisteril'];
            $checkbox_emr_serahterimarr_radiologi = $data['checkbox_emr_serahterimarr_radiologi'];
            $checkbox_emr_serahterimarr_foto = $data['checkbox_emr_serahterimarr_foto'];
            $checkbox_emr_serahterimarr_usg = $data['checkbox_emr_serahterimarr_usg'];
            $emr_serahterimarr_kelengkapanodocket = $data['emr_serahterimarr_kelengkapanodocket'];
            $emr_serahterimarr_jenisanestesi = $data['emr_serahterimarr_jenisanestesi'];
            $emr_serahterimarr_kesadaran = $data['emr_serahterimarr_kesadaran'];
            $emr_serahterimarr_td = $data['emr_serahterimarr_td'];
            $emr_serahterimarr_nadi = $data['emr_serahterimarr_nadi'];
            $emr_serahterimarr_rr = $data['emr_serahterimarr_rr'];
            $emr_serahterimarr_saturasioxygen = $data['emr_serahterimarr_saturasioxygen'];
            $emr_serahterimarr_suhu = $data['emr_serahterimarr_suhu'];
            $emr_serahterimarr_analgetik = $data['emr_serahterimarr_analgetik'];
            $emr_serahterimarr_antibiotik = $data['emr_serahterimarr_antibiotik'];
            $emr_serahterimarr_jamantibiotik = $data['emr_serahterimarr_jamantibiotik'];
            $emr_serahterimarr_intake = $data['emr_serahterimarr_intake'];
            $emr_serahterimarr_intakeoutput = $data['emr_serahterimarr_intakeoutput'];
            $checkbox_emr_serahterimarr_suratijinanestesi = $data['checkbox_emr_serahterimarr_suratijinanestesi'];
            $checkbox_emr_serahterimarr_prabedah = $data['checkbox_emr_serahterimarr_prabedah'];
            $checkbox_emr_serahterimarr_cttnanestesi = $data['checkbox_emr_serahterimarr_cttnanestesi'];
            $emr_serahterimarr_kelengkapanformket = $data['emr_serahterimarr_kelengkapanformket'];
            $emr_serahterimarr_prbedah = $data['emr_serahterimarr_prbedah'];
            $emr_serahterimarr_pranestesi = $data['emr_serahterimarr_pranestesi'];

            // CEGAT NULL
            // if ($emr_intraop_temperatur == '') {
            //     $emr_intraop_temperatur = 0;
            // }

            //CEGAT JIKA BELUM MENGISI PERSIAPAN FORM PRE OPERASI

            $this->db->query("SELECT COUNT(ID) cekOutpatient FROM EMR.dbo.MR_SurgicalSafetyCheklistsSignOuts WHERE NoRegistrasi = :emr_noreg AND IdOrderOperasi =:emr_idorder");
            $this->db->bind('emr_noreg', $emr_noreg);
            $this->db->bind('emr_idorder', $emr_idorder);
            $dataoperasiNA =  $this->db->single();
            $cekformoperasina = $dataoperasiNA['cekOutpatient'];

            if ($cekformoperasina == "0") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'FORM SIGN OUT BELUM DI ISI. Silakan isi terlebih dahulu / klik simpan pada form sign out operasi !',
                );
                return $callback;
                exit;
            }

            //CEK DATA
            $this->db->query("SELECT COUNT(ID) cekOutpatientOperasi FROM EMR.dbo.MR_PK_PostOPerasis WHERE NoRegistrasi = :emr_noreg AND IdOrderOperasi = :emr_idorder");
            $this->db->bind('emr_noreg', $emr_noreg);
            $this->db->bind('emr_idorder', $emr_idorder);
            $dataoperasiNA =  $this->db->single();
            $cekformoperasina = $dataoperasiNA['cekOutpatientOperasi'];

            if ($cekformoperasina == "0") {
                // var_dump('insert');
                // exit;
                $this->db->query("INSERT INTO EMR.dbo.MR_PK_PostOPerasis
    (
    [NoMR] ,[NoEpisode] ,[NoRegistrasi] ,[Tgl] ,[JenisTindakan] ,[DokterBedah] ,[DokterAnestesi] ,[Drain] ,[JenisDrain] ,[Catheter] ,[NoCatheter] ,[BalonCatheter] ,[Bungkusan] ,[JenisBungkusan] ,[Patologi] ,[Kultur] ,[Prothesis] ,[JenisProthesis] ,[Perdarahan] ,[ICOperasi] ,[LaporanOP] ,[DaftarObat] ,[InstruksiPostOP] ,[CeklistAlkes] ,[SSC] ,[FKSterilisasi] ,[DokumenRadiologi] ,[DokumenFoto] ,[DokumenUSG] ,[Keterangan_PB] ,[JenisAnestesi] ,[Kesadaran] ,[TD] ,[Nadi] ,[RR] ,[SO2] ,[Suhu] ,[Analgetik] ,[Antibiotik] ,[Jam] ,[Intake] ,[Output] ,[SI_Anestesi] ,[PraBedah] ,[CatatanAnestesi] ,[KetAnestesi] ,[PerawatBedah] ,[PerawatAnastesi] ,[IdUserOrder] ,[NamaUserOrder] ,[IdOrderOperasi]
    )
VALUES
    (
    :emr_norm ,:emr_noeps ,:emr_noreg ,:emr_serahterimarr_tgl ,:emr_serahterimarr_jenistindakan ,:emr_serahterimarr_drbedah ,:emr_serahterimarr_dranestiologi ,:emr_serahterimarr_drain ,:emr_serahterimarr_jenisdrain ,:emr_serahterimarr_catheter ,:emr_serahterimarr_catheterno ,:emr_serahterimarr_balon ,:emr_serahterimarr_balutanluka ,:emr_serahterimarr_jenisbalutanluka ,:emr_serahterimarr_patologi ,:emr_serahterimarr_kultur ,:emr_serahterimarr_prothesis ,:emr_serahterimarr_prothesisjenis ,:emr_serahterimarr_pendarahan ,:checkbox_emr_serahterimarr_checkperhitunganalkes ,:checkbox_emr_serahterimarr_lapoperasi ,:checkbox_emr_serahterimarr_daftarobat ,:checkbox_emr_serahterimarr_inspostoperasi ,:checkbox_emr_serahterimarr_surgicalsafety ,:checkbox_emr_serahterimarr_suratijinop ,:checkbox_emr_serahterimarr_formkondisisteril ,:checkbox_emr_serahterimarr_radiologi ,:checkbox_emr_serahterimarr_foto ,:checkbox_emr_serahterimarr_usg ,:emr_serahterimarr_kelengkapanodocket ,:emr_serahterimarr_jenisanestesi ,:emr_serahterimarr_kesadaran ,:emr_serahterimarr_td ,:emr_serahterimarr_nadi ,:emr_serahterimarr_rr ,:emr_serahterimarr_saturasioxygen ,:emr_serahterimarr_suhu ,:emr_serahterimarr_analgetik ,:emr_serahterimarr_antibiotik ,:emr_serahterimarr_jamantibiotik ,:emr_serahterimarr_intake ,:emr_serahterimarr_intakeoutput ,:checkbox_emr_serahterimarr_suratijinanestesi ,:checkbox_emr_serahterimarr_prabedah ,:checkbox_emr_serahterimarr_cttnanestesi ,:emr_serahterimarr_kelengkapanformket ,:emr_serahterimarr_prbedah ,:emr_serahterimarr_pranestesi ,:useridx ,:namauserx ,:emr_idorder
    )");
            } else {
                // var_dump('update');
                // exit;
                $this->db->query("UPDATE EMR.dbo.MR_PK_PostOPerasis 
SET 
NoMR = :emr_norm ,NoEpisode = :emr_noeps ,Tgl = :emr_serahterimarr_tgl ,JenisTindakan = :emr_serahterimarr_jenistindakan ,DokterBedah = :emr_serahterimarr_drbedah ,DokterAnestesi = :emr_serahterimarr_dranestiologi ,Drain = :emr_serahterimarr_drain ,JenisDrain = :emr_serahterimarr_jenisdrain ,Catheter = :emr_serahterimarr_catheter ,NoCatheter = :emr_serahterimarr_catheterno ,BalonCatheter = :emr_serahterimarr_balon ,Bungkusan = :emr_serahterimarr_balutanluka ,JenisBungkusan = :emr_serahterimarr_jenisbalutanluka ,Patologi = :emr_serahterimarr_patologi ,Kultur = :emr_serahterimarr_kultur ,Prothesis = :emr_serahterimarr_prothesis ,JenisProthesis = :emr_serahterimarr_prothesisjenis ,Perdarahan = :emr_serahterimarr_pendarahan ,ICOperasi = :checkbox_emr_serahterimarr_checkperhitunganalkes ,LaporanOP = :checkbox_emr_serahterimarr_lapoperasi ,DaftarObat = :checkbox_emr_serahterimarr_daftarobat ,InstruksiPostOP = :checkbox_emr_serahterimarr_inspostoperasi ,CeklistAlkes = :checkbox_emr_serahterimarr_surgicalsafety ,SSC = :checkbox_emr_serahterimarr_suratijinop ,FKSterilisasi = :checkbox_emr_serahterimarr_formkondisisteril ,DokumenRadiologi = :checkbox_emr_serahterimarr_radiologi ,DokumenFoto = :checkbox_emr_serahterimarr_foto ,DokumenUSG = :checkbox_emr_serahterimarr_usg ,Keterangan_PB = :emr_serahterimarr_kelengkapanodocket ,JenisAnestesi = :emr_serahterimarr_jenisanestesi ,Kesadaran = :emr_serahterimarr_kesadaran ,TD = :emr_serahterimarr_td ,Nadi = :emr_serahterimarr_nadi ,RR = :emr_serahterimarr_rr ,SO2 = :emr_serahterimarr_saturasioxygen ,Suhu = :emr_serahterimarr_suhu ,Analgetik = :emr_serahterimarr_analgetik ,Antibiotik = :emr_serahterimarr_antibiotik ,Jam = :emr_serahterimarr_jamantibiotik ,Intake = :emr_serahterimarr_intake ,Output = :emr_serahterimarr_intakeoutput ,SI_Anestesi = :checkbox_emr_serahterimarr_suratijinanestesi ,PraBedah = :checkbox_emr_serahterimarr_prabedah ,CatatanAnestesi = :checkbox_emr_serahterimarr_cttnanestesi ,KetAnestesi = :emr_serahterimarr_kelengkapanformket ,PerawatBedah = :emr_serahterimarr_prbedah ,PerawatAnastesi = :emr_serahterimarr_pranestesi ,IdUserOrder = :useridx ,NamaUserOrder = :namauserx
WHERE NoRegistrasi = :emr_noreg AND IdOrderOperasi  =:emr_idorder");
            }
            $this->db->bind('emr_norm', $emr_norm);
            $this->db->bind('emr_noeps', $emr_noeps);
            $this->db->bind('emr_noreg', $emr_noreg);
            $this->db->bind('emr_serahterimarr_tgl', $emr_serahterimarr_tgl);
            $this->db->bind('emr_serahterimarr_jenistindakan', $emr_serahterimarr_jenistindakan);
            $this->db->bind('emr_serahterimarr_drbedah', $emr_serahterimarr_drbedah);
            $this->db->bind('emr_serahterimarr_dranestiologi', $emr_serahterimarr_dranestiologi);
            $this->db->bind('emr_serahterimarr_drain', $emr_serahterimarr_drain);
            $this->db->bind('emr_serahterimarr_jenisdrain', $emr_serahterimarr_jenisdrain);
            $this->db->bind('emr_serahterimarr_catheter', $emr_serahterimarr_catheter);
            $this->db->bind('emr_serahterimarr_catheterno', $emr_serahterimarr_catheterno);
            $this->db->bind('emr_serahterimarr_balon', $emr_serahterimarr_balon);
            $this->db->bind('emr_serahterimarr_balutanluka', $emr_serahterimarr_balutanluka);
            $this->db->bind('emr_serahterimarr_jenisbalutanluka', $emr_serahterimarr_jenisbalutanluka);
            $this->db->bind('emr_serahterimarr_patologi', $emr_serahterimarr_patologi);
            $this->db->bind('emr_serahterimarr_kultur', $emr_serahterimarr_kultur);
            $this->db->bind('emr_serahterimarr_prothesis', $emr_serahterimarr_prothesis);
            $this->db->bind('emr_serahterimarr_prothesisjenis', $emr_serahterimarr_prothesisjenis);
            $this->db->bind('emr_serahterimarr_pendarahan', $emr_serahterimarr_pendarahan);
            $this->db->bind('checkbox_emr_serahterimarr_checkperhitunganalkes', $checkbox_emr_serahterimarr_checkperhitunganalkes);
            $this->db->bind('checkbox_emr_serahterimarr_lapoperasi', $checkbox_emr_serahterimarr_lapoperasi);
            $this->db->bind('checkbox_emr_serahterimarr_daftarobat', $checkbox_emr_serahterimarr_daftarobat);
            $this->db->bind('checkbox_emr_serahterimarr_inspostoperasi', $checkbox_emr_serahterimarr_inspostoperasi);
            $this->db->bind('checkbox_emr_serahterimarr_surgicalsafety', $checkbox_emr_serahterimarr_surgicalsafety);
            $this->db->bind('checkbox_emr_serahterimarr_suratijinop', $checkbox_emr_serahterimarr_suratijinop);
            $this->db->bind('checkbox_emr_serahterimarr_formkondisisteril', $checkbox_emr_serahterimarr_formkondisisteril);
            $this->db->bind('checkbox_emr_serahterimarr_radiologi', $checkbox_emr_serahterimarr_radiologi);
            $this->db->bind('checkbox_emr_serahterimarr_foto', $checkbox_emr_serahterimarr_foto);
            $this->db->bind('checkbox_emr_serahterimarr_usg', $checkbox_emr_serahterimarr_usg);
            $this->db->bind('emr_serahterimarr_kelengkapanodocket', $emr_serahterimarr_kelengkapanodocket);
            $this->db->bind('emr_serahterimarr_jenisanestesi', $emr_serahterimarr_jenisanestesi);
            $this->db->bind('emr_serahterimarr_kesadaran', $emr_serahterimarr_kesadaran);
            $this->db->bind('emr_serahterimarr_td', $emr_serahterimarr_td);
            $this->db->bind('emr_serahterimarr_nadi', $emr_serahterimarr_nadi);
            $this->db->bind('emr_serahterimarr_rr', $emr_serahterimarr_rr);
            $this->db->bind('emr_serahterimarr_saturasioxygen', $emr_serahterimarr_saturasioxygen);
            $this->db->bind('emr_serahterimarr_suhu', $emr_serahterimarr_suhu);
            $this->db->bind('emr_serahterimarr_analgetik', $emr_serahterimarr_analgetik);
            $this->db->bind('emr_serahterimarr_antibiotik', $emr_serahterimarr_antibiotik);
            $this->db->bind('emr_serahterimarr_jamantibiotik', $emr_serahterimarr_jamantibiotik);
            $this->db->bind('emr_serahterimarr_intake', $emr_serahterimarr_intake);
            $this->db->bind('emr_serahterimarr_intakeoutput', $emr_serahterimarr_intakeoutput);
            $this->db->bind('checkbox_emr_serahterimarr_suratijinanestesi', $checkbox_emr_serahterimarr_suratijinanestesi);
            $this->db->bind('checkbox_emr_serahterimarr_prabedah', $checkbox_emr_serahterimarr_prabedah);
            $this->db->bind('checkbox_emr_serahterimarr_cttnanestesi', $checkbox_emr_serahterimarr_cttnanestesi);
            $this->db->bind('emr_serahterimarr_kelengkapanformket', $emr_serahterimarr_kelengkapanformket);
            $this->db->bind('emr_serahterimarr_prbedah', $emr_serahterimarr_prbedah);
            $this->db->bind('emr_serahterimarr_pranestesi', $emr_serahterimarr_pranestesi);
            $this->db->bind('useridx', $useridx);
            $this->db->bind('namauserx', $namauserx);
            $this->db->bind('emr_idorder', $emr_idorder);

            $this->db->execute();
            $this->db->commit();

            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }



    public function setSavePostOperasiNA($data)
    {
        try {
            $this->db->transaksi();

            // var_dump($data);
            // exit;
            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $useridx = $session->IDEmployee;

            // DATA PASING
            $emr_nama = $data['emr_nama'];
            $emr_norm = $data['emr_norm'];
            $emr_noreg = $data['emr_noreg'];
            $emr_noeps = $data['emr_noeps'];
            $emr_idorder = $data['emr_idorder'];

            $emr_postop_ruangpulihsadar = $data['emr_postop_ruangpulihsadar'];
            $emr_postop_masukjam = $data['emr_postop_masukjam'];
            $emr_postop_keluarjam = $data['emr_postop_keluarjam'];
            $emr_postop_kembalike = $data['emr_postop_kembalike'];
            $emr_postop_keadaanumum = $data['emr_postop_keadaanumum'];
            $emr_postop_tingkatkesadaran = $data['emr_postop_tingkatkesadaran'];
            $emr_postop_jlnafaspatentdatang = $data['emr_postop_jlnafaspatentdatang'];
            $emr_postop_jlnafaspatentkeluar = $data['emr_postop_jlnafaspatentkeluar'];
            $emr_postop_terapipasien = $data['emr_postop_terapipasien'];
            $emr_postop_terapipasienjer = $data['emr_postop_terapipasienjer'];
            $emr_postop_kulitdatar = $data['emr_postop_kulitdatar'];
            $emr_postop_kulitkeluar = $data['emr_postop_kulitkeluar'];
            $emr_postop_posisipasien = $data['emr_postop_posisipasien'];
            $emr_postop_keterangan = $data['emr_postop_keterangan'];
            $checkbox_emr_postop_cemas = $data['checkbox_emr_postop_cemas'];
            $checkbox_emr_postop_cedera = $data['checkbox_emr_postop_cedera'];
            $checkbox_emr_postop_nyeri = $data['checkbox_emr_postop_nyeri'];
            $checkbox_emr_postop_infeksi = $data['checkbox_emr_postop_infeksi'];
            $checkbox_emr_postop_hipertemi = $data['checkbox_emr_postop_hipertemi'];
            $checkbox_emr_postop_hipotermi = $data['checkbox_emr_postop_hipotermi'];
            $checkbox_emr_postop_integritaskulit = $data['checkbox_emr_postop_integritaskulit'];
            $checkbox_emr_postop_perawatandiri = $data['checkbox_emr_postop_perawatandiri'];
            $checkbox_emr_postop_pendampingtenagakhusus = $data['checkbox_emr_postop_pendampingtenagakhusus'];
            $checkbox_emr_postop_latihanfisiklanjutan = $data['checkbox_emr_postop_latihanfisiklanjutan'];
            $checkbox_emr_postop_pantauanpemberianobat = $data['checkbox_emr_postop_pantauanpemberianobat'];
            $checkbox_emr_postop_perawatanluka = $data['checkbox_emr_postop_perawatanluka'];
            $checkbox_emr_postop_pemantauandiet = $data['checkbox_emr_postop_pemantauandiet'];
            $checkbox_emr_postop_bantuanaktifitasfisik = $data['checkbox_emr_postop_bantuanaktifitasfisik'];
            $checkbox_emr_postop_bantuanmedisperawatan = $data['checkbox_emr_postop_bantuanmedisperawatan'];


            //CEGAT NULL
            if ($emr_postop_terapipasien == '') {
                $emr_postop_terapipasien = 0;
            }

            //CEGAT JIKA BELUM MENGISI PERSIAPAN FORM PRE OPERASI

            $this->db->query("SELECT COUNT(ID) cekOutpatient FROM EMR.dbo.MR_PK_PostOPerasis WHERE NoRegistrasi = :emr_noreg AND IdOrderOperasi =:emr_idorder");
            $this->db->bind('emr_noreg', $emr_noreg);
            $this->db->bind('emr_idorder', $emr_idorder);
            $dataoperasiNA =  $this->db->single();
            $cekformoperasina = $dataoperasiNA['cekOutpatient'];

            if ($cekformoperasina == "0") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'FORM SERAH TERIMA BELUM DI ISI. Silakan isi terlebih dahulu / klik simpan pada form serah terima operasi !',
                );
                return $callback;
                exit;
            }

            //CEK DATA
            $this->db->query("SELECT COUNT(ID) cekOutpatientOperasi FROM EMR.dbo.MR_PK_RuangPulihSadars WHERE NoRegistrasi = :emr_noreg AND IdOrderOperasi = :emr_idorder");
            $this->db->bind('emr_noreg', $emr_noreg);
            $this->db->bind('emr_idorder', $emr_idorder);
            $dataoperasiNA =  $this->db->single();
            $cekformoperasina = $dataoperasiNA['cekOutpatientOperasi'];

            if ($cekformoperasina == "0") {
                // var_dump('insert');
                // exit;
                $this->db->query("INSERT INTO EMR.dbo.MR_PK_RuangPulihSadars
    (
    [NoMR] ,[NoEpisode] ,[NoRegistrasi] ,[RPulihSadar] ,[JamMasuk] ,[JamKeluar] ,[KembaliKe] ,[KeadaanUmum] ,[Kesadaran] ,[JalanNafasDatang] ,[JalanNafasKeluar] ,[TerapiO2] ,[JenisO2] ,[KulitDatang] ,[KulitKeluar] ,[PosisiPasien] ,[Keterangan] ,[Cemas] ,[Cedera] ,[Nyeri] ,[Infeksi] ,[Hipertermi] ,[Hipotermi] ,[IntegritasKulit] ,[PerawatanMandiri] ,[PTK] ,[LFL] ,[PPObat] ,[PerawatanLuka] ,[Diet] ,[BAktifitasFisik] ,[BantuanMedis] ,[IdUserOrder] ,[NamaUserOrder] ,[IdOrderOperasi]
    )
VALUES
    (
    :emr_norm ,:emr_noeps ,:emr_noreg ,:emr_postop_ruangpulihsadar ,:emr_postop_masukjam ,:emr_postop_keluarjam ,:emr_postop_kembalike ,:emr_postop_keadaanumum ,:emr_postop_tingkatkesadaran ,:emr_postop_jlnafaspatentdatang ,:emr_postop_jlnafaspatentkeluar ,:emr_postop_terapipasien ,:emr_postop_terapipasienjer ,:emr_postop_kulitdatar ,:emr_postop_kulitkeluar ,:emr_postop_posisipasien ,:emr_postop_keterangan ,:checkbox_emr_postop_cemas ,:checkbox_emr_postop_cedera ,:checkbox_emr_postop_nyeri ,:checkbox_emr_postop_infeksi ,:checkbox_emr_postop_hipertemi ,:checkbox_emr_postop_hipotermi ,:checkbox_emr_postop_integritaskulit ,:checkbox_emr_postop_perawatandiri ,:checkbox_emr_postop_pendampingtenagakhusus ,:checkbox_emr_postop_latihanfisiklanjutan ,:checkbox_emr_postop_pantauanpemberianobat ,:checkbox_emr_postop_perawatanluka ,:checkbox_emr_postop_pemantauandiet ,:checkbox_emr_postop_bantuanaktifitasfisik ,:checkbox_emr_postop_bantuanmedisperawatan ,:useridx ,:namauserx ,:emr_idorder
    )");
            } else {
                // var_dump('update');
                // exit;
                $this->db->query("UPDATE EMR.dbo.MR_PK_RuangPulihSadars 
SET 
NoMR = :emr_norm ,NoEpisode = :emr_noeps ,RPulihSadar = :emr_postop_ruangpulihsadar ,JamMasuk = :emr_postop_masukjam ,JamKeluar = :emr_postop_keluarjam ,KembaliKe = :emr_postop_kembalike ,KeadaanUmum = :emr_postop_keadaanumum ,Kesadaran = :emr_postop_tingkatkesadaran ,JalanNafasDatang = :emr_postop_jlnafaspatentdatang ,JalanNafasKeluar = :emr_postop_jlnafaspatentkeluar ,TerapiO2 = :emr_postop_terapipasien ,JenisO2 = :emr_postop_terapipasienjer ,KulitDatang = :emr_postop_kulitdatar ,KulitKeluar = :emr_postop_kulitkeluar ,PosisiPasien = :emr_postop_posisipasien ,Keterangan = :emr_postop_keterangan ,Cemas = :checkbox_emr_postop_cemas ,Cedera = :checkbox_emr_postop_cedera ,Nyeri = :checkbox_emr_postop_nyeri ,Infeksi = :checkbox_emr_postop_infeksi ,Hipertermi = :checkbox_emr_postop_hipertemi ,Hipotermi = :checkbox_emr_postop_hipotermi ,IntegritasKulit = :checkbox_emr_postop_integritaskulit ,PerawatanMandiri = :checkbox_emr_postop_perawatandiri ,PTK = :checkbox_emr_postop_pendampingtenagakhusus ,LFL = :checkbox_emr_postop_latihanfisiklanjutan ,PPObat = :checkbox_emr_postop_pantauanpemberianobat ,PerawatanLuka = :checkbox_emr_postop_perawatanluka ,Diet = :checkbox_emr_postop_pemantauandiet ,BAktifitasFisik = :checkbox_emr_postop_bantuanaktifitasfisik ,BantuanMedis = :checkbox_emr_postop_bantuanmedisperawatan ,IdUserOrder = :useridx ,NamaUserOrder = :namauserx
WHERE NoRegistrasi = :emr_noreg AND IdOrderOperasi  =:emr_idorder");
            }
            $this->db->bind('emr_norm', $emr_norm);
            $this->db->bind('emr_noeps', $emr_noeps);
            $this->db->bind('emr_noreg', $emr_noreg);
            $this->db->bind('emr_postop_ruangpulihsadar', $emr_postop_ruangpulihsadar);
            $this->db->bind('emr_postop_masukjam', $emr_postop_masukjam);
            $this->db->bind('emr_postop_keluarjam', $emr_postop_keluarjam);
            $this->db->bind('emr_postop_kembalike', $emr_postop_kembalike);
            $this->db->bind('emr_postop_keadaanumum', $emr_postop_keadaanumum);
            $this->db->bind('emr_postop_tingkatkesadaran', $emr_postop_tingkatkesadaran);
            $this->db->bind('emr_postop_jlnafaspatentdatang', $emr_postop_jlnafaspatentdatang);
            $this->db->bind('emr_postop_jlnafaspatentkeluar', $emr_postop_jlnafaspatentkeluar);
            $this->db->bind('emr_postop_terapipasien', $emr_postop_terapipasien);
            $this->db->bind('emr_postop_terapipasienjer', $emr_postop_terapipasienjer);
            $this->db->bind('emr_postop_kulitdatar', $emr_postop_kulitdatar);
            $this->db->bind('emr_postop_kulitkeluar', $emr_postop_kulitkeluar);
            $this->db->bind('emr_postop_posisipasien', $emr_postop_posisipasien);
            $this->db->bind('emr_postop_keterangan', $emr_postop_keterangan);
            $this->db->bind('checkbox_emr_postop_cemas', $checkbox_emr_postop_cemas);
            $this->db->bind('checkbox_emr_postop_cedera', $checkbox_emr_postop_cedera);
            $this->db->bind('checkbox_emr_postop_nyeri', $checkbox_emr_postop_nyeri);
            $this->db->bind('checkbox_emr_postop_infeksi', $checkbox_emr_postop_infeksi);
            $this->db->bind('checkbox_emr_postop_hipertemi', $checkbox_emr_postop_hipertemi);
            $this->db->bind('checkbox_emr_postop_hipotermi', $checkbox_emr_postop_hipotermi);
            $this->db->bind('checkbox_emr_postop_integritaskulit', $checkbox_emr_postop_integritaskulit);
            $this->db->bind('checkbox_emr_postop_perawatandiri', $checkbox_emr_postop_perawatandiri);
            $this->db->bind('checkbox_emr_postop_pendampingtenagakhusus', $checkbox_emr_postop_pendampingtenagakhusus);
            $this->db->bind('checkbox_emr_postop_latihanfisiklanjutan', $checkbox_emr_postop_latihanfisiklanjutan);
            $this->db->bind('checkbox_emr_postop_pantauanpemberianobat', $checkbox_emr_postop_pantauanpemberianobat);
            $this->db->bind('checkbox_emr_postop_perawatanluka', $checkbox_emr_postop_perawatanluka);
            $this->db->bind('checkbox_emr_postop_pemantauandiet', $checkbox_emr_postop_pemantauandiet);
            $this->db->bind('checkbox_emr_postop_bantuanaktifitasfisik', $checkbox_emr_postop_bantuanaktifitasfisik);
            $this->db->bind('checkbox_emr_postop_bantuanmedisperawatan', $checkbox_emr_postop_bantuanmedisperawatan);
            $this->db->bind('useridx', $useridx);
            $this->db->bind('namauserx', $namauserx);
            $this->db->bind('emr_idorder', $emr_idorder);

            $this->db->execute();
            $this->db->commit();

            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }


    // DOKTER ASSESMENT

    public function getDataDokterAssOperasi($data)
    {
        try {

            $noregistrasi = $data['NoRegistrasi'];
            $idorder = $data['idOrder'];

            $this->db->query("SELECT 
            ID, LokasiPengkajian ,LokasiLain ,Keluhan ,RPS ,RO_Kapan ,ObatSaatIni ,Hamil ,SedangHaid ,TD_Sistole ,TD_Diastole ,RR ,Nadi ,Suhu ,GCS ,GCS_E ,GCS_M ,GCS_V ,Kepala ,Mata ,THT ,Thorax ,Abdomen ,Genitalia ,Kulit ,Ektremitas ,StatusLokalis ,HasilLab ,Radiologi ,EKG ,O_LainLain ,RencanaOperasi ,SifatProsedur ,HariOP ,TanggalOP ,PLamaTindakan ,Anestesi ,Puasa ,JamMulaiPuasa ,PeralatanKhusus ,PeralatanKhusuLain ,Klisma ,KlismaSejak ,Obat ,PersiapanDarah ,KetPersiapanDarah ,RencanaPostOP ,Catatan
            FROM EMR.dbo.MR_PraOperasis WHERE NoRegistrasi = :noreg AND IdOrderOperasi = :idorder");
            $this->db->bind('noreg', $noregistrasi);
            $this->db->bind('idorder', $idorder);
            $key =  $this->db->single();

            // $this->db->query("SELECT 
            // ID, LokasiPengkajian ,LokasiLain ,Keluhan ,RPS ,RO_Kapan ,ObatSaatIni ,Hamil ,SedangHaid ,TD_Sistole ,TD_Diastole ,RR ,Nadi ,Suhu ,GCS ,GCS_E ,GCS_M ,GCS_V ,Kepala ,Mata ,THT ,Thorax ,Abdomen ,Genitalia ,Kulit ,Ektremitas ,StatusLokalis ,HasilLab ,Radiologi ,EKG ,O_LainLain ,RencanaOperasi ,SifatProsedur ,HariOP ,TanggalOP ,PLamaTindakan ,Anestesi ,Puasa ,JamMulaiPuasa ,PeralatanKhusus ,PeralatanKhusuLain ,Klisma ,KlismaSejak ,Obat ,PersiapanDarah ,KetPersiapanDarah ,RencanaPostOP ,Catatan
            // FROM EMR.dbo.MR_PraOperasis WHERE NoRegistrasi = :noreg AND IdOrderOperasi = :idorder");
            // $this->db->bind('noreg', $noregistrasi);
            // $this->db->bind('idorder', $idorder);
            // $key1a =  $this->db->single();

            // PRA OPERASI
            $pasing['ID'] = $key['ID'];
            $pasing['LokasiPengkajian'] = $key['LokasiPengkajian'];
            $pasing['LokasiLain'] = $key['LokasiLain'];
            $pasing['Keluhan'] = $key['Keluhan'];
            $pasing['RPS'] = $key['RPS'];
            $pasing['RO_Kapan'] = $key['RO_Kapan'];
            $pasing['ObatSaatIni'] = $key['ObatSaatIni'];
            $pasing['Hamil'] = $key['Hamil'];
            $pasing['SedangHaid'] = $key['SedangHaid'];
            $pasing['TD_Sistole'] = $key['TD_Sistole'];
            $pasing['TD_Diastole'] = $key['TD_Diastole'];
            $pasing['RR'] = $key['RR'];
            $pasing['Nadi'] = $key['Nadi'];
            $pasing['Suhu'] = $key['Suhu'];
            $pasing['GCS'] = $key['GCS'];
            $pasing['GCS_E'] = $key['GCS_E'];
            $pasing['GCS_M'] = $key['GCS_M'];
            $pasing['GCS_V'] = $key['GCS_V'];
            $pasing['Kepala'] = $key['Kepala'];
            $pasing['Mata'] = $key['Mata'];
            $pasing['THT'] = $key['THT'];
            $pasing['Thorax'] = $key['Thorax'];
            $pasing['Abdomen'] = $key['Abdomen'];
            $pasing['Genitalia'] = $key['Genitalia'];
            $pasing['Kulit'] = $key['Kulit'];
            $pasing['Ektremitas'] = $key['Ektremitas'];
            $pasing['StatusLokalis'] = $key['StatusLokalis'];
            $pasing['HasilLab'] = $key['HasilLab'];
            $pasing['Radiologi'] = $key['Radiologi'];
            $pasing['EKG'] = $key['EKG'];
            $pasing['O_LainLain'] = $key['O_LainLain'];
            $pasing['RencanaOperasi'] = $key['RencanaOperasi'];
            $pasing['SifatProsedur'] = $key['SifatProsedur'];
            $pasing['HariOP'] = $key['HariOP'];
            $pasing['TanggalOP'] = $key['TanggalOP'];
            $pasing['PLamaTindakan'] = $key['PLamaTindakan'];
            $pasing['Anestesi'] = $key['Anestesi'];
            $pasing['Puasa'] = $key['Puasa'];
            $pasing['JamMulaiPuasa'] = $key['JamMulaiPuasa'];
            $pasing['PeralatanKhusus'] = $key['PeralatanKhusus'];
            $pasing['PeralatanKhusuLain'] = $key['PeralatanKhusuLain'];
            $pasing['Klisma'] = $key['Klisma'];
            $pasing['KlismaSejak'] = $key['KlismaSejak'];
            $pasing['Obat'] = $key['Obat'];
            $pasing['PersiapanDarah'] = $key['PersiapanDarah'];
            $pasing['KetPersiapanDarah'] = $key['KetPersiapanDarah'];
            $pasing['RencanaPostOP'] = $key['RencanaPostOP'];
            $pasing['Catatan'] = $key['Catatan'];


            //SURGICAL SAFETY CHECKLIS


            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function setSavePraBedahOperasiDA($data)
    {
        try {
            $this->db->transaksi();

            // var_dump($data);
            // exit;
            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $useridx = $session->IDEmployee;

            // DATA PASING
            $emr_nama = $data['emr_nama'];
            $emr_norm = $data['emr_norm'];
            $emr_noreg = $data['emr_noreg'];
            $emr_noeps = $data['emr_noeps'];
            $emr_idorder = $data['emr_idorder'];

            $emr_prabedah_tmptpengkajian = $data['emr_prabedah_tmptpengkajian'];
            $emr_prabedah_tmptpengkajianket = $data['emr_prabedah_tmptpengkajianket'];
            $emr_prabedah_skeluhan = $data['emr_prabedah_skeluhan'];
            $emr_prabedah_sriwayatpenyakit = $data['emr_prabedah_sriwayatpenyakit'];
            $emr_prabedah_sriwayatoperasi = $data['emr_prabedah_sriwayatoperasi'];
            $emr_prabedah_spengobatansaatini = $data['emr_prabedah_spengobatansaatini'];
            $emr_prabedah_shamil = $data['emr_prabedah_shamil'];
            $emr_prabedah_smenstruasi = $data['emr_prabedah_smenstruasi'];
            $emr_prabedah_otd = $data['emr_prabedah_otd'];
            $emr_prabedah_otdper = $data['emr_prabedah_otdper'];
            $emr_prabedah_orr = $data['emr_prabedah_orr'];
            $emr_prabedah_onadi = $data['emr_prabedah_onadi'];
            $emr_prabedah_osuhu = $data['emr_prabedah_osuhu'];
            $emr_prabedah_ogcs = $data['emr_prabedah_ogcs'];
            $emr_prabedah_ogcse = $data['emr_prabedah_ogcse'];
            $emr_prabedah_ogcsm = $data['emr_prabedah_ogcsm'];
            $emr_prabedah_ogcsv = $data['emr_prabedah_ogcsv'];
            $emr_prabedah_okepala = $data['emr_prabedah_okepala'];
            $emr_prabedah_omata = $data['emr_prabedah_omata'];
            $emr_prabedah_otht = $data['emr_prabedah_otht'];
            $emr_prabedah_othorax = $data['emr_prabedah_othorax'];
            $emr_prabedah_oabdomen = $data['emr_prabedah_oabdomen'];
            $emr_prabedah_ogenetalia = $data['emr_prabedah_ogenetalia'];
            $emr_prabedah_okulit = $data['emr_prabedah_okulit'];
            $emr_prabedah_oextremitas = $data['emr_prabedah_oextremitas'];
            $emr_prabedah_ostatuslokasi = $data['emr_prabedah_ostatuslokasi'];
            $emr_prabedah_olaboratorium = $data['emr_prabedah_olaboratorium'];
            $emr_prabedah_oradiologi = $data['emr_prabedah_oradiologi'];
            $emr_prabedah_oekg = $data['emr_prabedah_oekg'];
            $emr_prabedah_olain2 = $data['emr_prabedah_olain2'];
            $emr_prabedah_prencanaop = $data['emr_prabedah_prencanaop'];
            $emr_prabedah_pkriteria = $data['emr_prabedah_pkriteria'];
            $emr_prabedah_pha = $data['emr_prabedah_pha'];
            $emr_prabedah_ptanggal = $data['emr_prabedah_ptanggal'];
            $emr_prabedah_pperkiraanlamaop = $data['emr_prabedah_pperkiraanlamaop'];
            $emr_prabedah_panestesia = $data['emr_prabedah_panestesia'];
            $emr_prabedah_ppuasa = $data['emr_prabedah_ppuasa'];
            $emr_prabedah_pmulaijam = $data['emr_prabedah_pmulaijam'];
            $emr_prabedah_pderetankasus = $data['emr_prabedah_pderetankasus'];
            $emr_prabedah_pderetankasusket = $data['emr_prabedah_pderetankasusket'];
            $emr_prabedah_ppengosongankandungkemih = $data['emr_prabedah_ppengosongankandungkemih'];
            $emr_prabedah_psejakjam = $data['emr_prabedah_psejakjam'];
            $emr_prabedah_pobat = $data['emr_prabedah_pobat'];
            $checkbox_emr_prabedah_ppersiapandarah = $data['checkbox_emr_prabedah_ppersiapandarah'];
            $emr_prabedah_ppersiapandarahket = $data['emr_prabedah_ppersiapandarahket'];
            $emr_prabedah_ppersiapandarahrencana = $data['emr_prabedah_ppersiapandarahrencana'];
            $emr_prabedah_pcatatan = $data['emr_prabedah_pcatatan'];

            //CEGAT NULL

            if ($emr_prabedah_otd == '') {
                $emr_prabedah_otd = 0;
            }
            if ($emr_prabedah_otdper == '') {
                $emr_prabedah_otdper = 0;
            }
            if ($emr_prabedah_orr == '') {
                $emr_prabedah_orr = 0;
            }
            if ($emr_prabedah_onadi == '') {
                $emr_prabedah_onadi = 0;
            }
            if ($emr_prabedah_osuhu == '') {
                $emr_prabedah_osuhu = 0;
            }
            if ($emr_prabedah_ogcs == '') {
                $emr_prabedah_ogcs = 0;
            }
            if ($emr_prabedah_ogcse == '') {
                $emr_prabedah_ogcse = 0;
            }
            if ($emr_prabedah_ogcsm == '') {
                $emr_prabedah_ogcsm = 0;
            }
            if ($emr_prabedah_ogcsv == '') {
                $emr_prabedah_ogcsv = 0;
            }

            //CEGAT JIKA BELUM MENGISI FORM

            // $this->db->query("SELECT COUNT(ID) cekOutpatient FROM EMR.dbo.MR_PK_PostOPerasis WHERE NoRegistrasi = :emr_noreg AND IdOrderOperasi =:emr_idorder");
            // $this->db->bind('emr_noreg', $emr_noreg);
            // $this->db->bind('emr_idorder', $emr_idorder);
            // $dataoperasiNA =  $this->db->single();
            // $cekformoperasina = $dataoperasiNA['cekOutpatient'];

            // if ($cekformoperasina == "0") {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => 'FORM SERAH TERIMA BELUM DI ISI. Silakan isi terlebih dahulu / klik simpan pada form serah terima operasi !',
            //     );
            //     return $callback;
            //     exit;
            // }

            //CEK DATA
            $this->db->query("SELECT COUNT(ID) cekOutpatientOperasi FROM EMR.dbo.MR_PraOperasis WHERE NoRegistrasi = :emr_noreg AND IdOrderOperasi = :emr_idorder");
            $this->db->bind('emr_noreg', $emr_noreg);
            $this->db->bind('emr_idorder', $emr_idorder);
            $dataoperasiNA =  $this->db->single();
            $cekformoperasina = $dataoperasiNA['cekOutpatientOperasi'];

            if ($cekformoperasina == "0") {
                // var_dump('insert');
                // exit;
                $this->db->query("INSERT INTO EMR.dbo.MR_PraOperasis
                (
                [NoMR] ,[NoEpisode] ,[NoRegistrasi] ,[IdUserOrder] ,[NamaUserOrder] ,[IdOrderOperasi] ,[LokasiPengkajian] ,[LokasiLain] ,[Keluhan] , [RPS] ,[RO_Kapan] ,[ObatSaatIni] ,[Hamil] ,[SedangHaid] ,[TD_Sistole] ,[TD_Diastole] ,[RR] ,[Nadi] ,[Suhu] ,[GCS] ,[GCS_E] ,  [GCS_M] ,[GCS_V] ,[Kepala] ,[Mata] ,[THT] ,[Thorax] ,[Abdomen] ,[Genitalia] ,[Kulit] ,[Ektremitas] ,[StatusLokalis] ,[HasilLab] ,  [Radiologi] ,[EKG] ,[O_LainLain] ,[RencanaOperasi] ,[SifatProsedur] ,[HariOP] ,[TanggalOP] ,[PLamaTindakan] ,[Anestesi] ,[Puasa] , [JamMulaiPuasa] ,[PeralatanKhusus] ,[PeralatanKhusuLain] ,[Klisma] ,[KlismaSejak] ,[Obat] ,[PersiapanDarah] ,[KetPersiapanDarah] ,[RencanaPostOP] ,[Catatan]
                )
                VALUES
                (
                :emr_norm ,:emr_noeps ,:emr_noreg ,:useridx ,:namauserx ,:emr_idorder ,:emr_prabedah_tmptpengkajian ,   :emr_prabedah_tmptpengkajianket ,:emr_prabedah_skeluhan ,:emr_prabedah_sriwayatpenyakit ,:emr_prabedah_sriwayatoperasi ,   :emr_prabedah_spengobatansaatini ,:emr_prabedah_shamil ,:emr_prabedah_smenstruasi ,:emr_prabedah_otd ,:emr_prabedah_otdper ,   :emr_prabedah_orr ,:emr_prabedah_onadi ,:emr_prabedah_osuhu ,:emr_prabedah_ogcs ,:emr_prabedah_ogcse ,:emr_prabedah_ogcsm ,    :emr_prabedah_ogcsv ,:emr_prabedah_okepala ,:emr_prabedah_omata ,:emr_prabedah_otht ,:emr_prabedah_othorax ,    :emr_prabedah_oabdomen ,:emr_prabedah_ogenetalia ,:emr_prabedah_okulit ,:emr_prabedah_oextremitas ,:emr_prabedah_ostatuslokasi ,    :emr_prabedah_olaboratorium ,:emr_prabedah_oradiologi ,:emr_prabedah_oekg ,:emr_prabedah_olain2 ,:emr_prabedah_prencanaop , :emr_prabedah_pkriteria ,:emr_prabedah_pha ,:emr_prabedah_ptanggal ,:emr_prabedah_pperkiraanlamaop ,:emr_prabedah_panestesia ,   :emr_prabedah_ppuasa ,:emr_prabedah_pmulaijam ,:emr_prabedah_pderetankasus ,:emr_prabedah_pderetankasusket ,   :emr_prabedah_ppengosongankandungkemih ,:emr_prabedah_psejakjam ,:emr_prabedah_pobat ,:checkbox_emr_prabedah_ppersiapandarah , :emr_prabedah_ppersiapandarahket ,:emr_prabedah_ppersiapandarahrencana ,:emr_prabedah_pcatatan
                )");
            } else {
                // var_dump('update');
                // exit;
                $this->db->query("UPDATE EMR.dbo.MR_PraOperasis 
                SET 
                NoMR = :emr_norm ,NoEpisode = :emr_noeps ,IdUserOrder = :useridx ,NamaUserOrder = :namauserx ,LokasiPengkajian = :emr_prabedah_tmptpengkajian ,LokasiLain = :emr_prabedah_tmptpengkajianket ,Keluhan = :emr_prabedah_skeluhan ,RPS = :emr_prabedah_sriwayatpenyakit ,RO_Kapan = :emr_prabedah_sriwayatoperasi ,ObatSaatIni = :emr_prabedah_spengobatansaatini ,Hamil = :emr_prabedah_shamil ,SedangHaid = :emr_prabedah_smenstruasi ,TD_Sistole = :emr_prabedah_otd ,TD_Diastole = :emr_prabedah_otdper ,RR = :emr_prabedah_orr ,Nadi = :emr_prabedah_onadi ,Suhu = :emr_prabedah_osuhu ,GCS = :emr_prabedah_ogcs ,GCS_E = :emr_prabedah_ogcse ,GCS_M = :emr_prabedah_ogcsm ,GCS_V = :emr_prabedah_ogcsv ,Kepala = :emr_prabedah_okepala ,Mata = :emr_prabedah_omata ,THT = :emr_prabedah_otht ,Thorax = :emr_prabedah_othorax ,Abdomen = :emr_prabedah_oabdomen ,Genitalia = :emr_prabedah_ogenetalia ,Kulit = :emr_prabedah_okulit ,Ektremitas = :emr_prabedah_oextremitas ,StatusLokalis = :emr_prabedah_ostatuslokasi ,HasilLab = :emr_prabedah_olaboratorium ,Radiologi = :emr_prabedah_oradiologi ,EKG = :emr_prabedah_oekg ,O_LainLain = :emr_prabedah_olain2 ,RencanaOperasi = :emr_prabedah_prencanaop ,SifatProsedur = :emr_prabedah_pkriteria ,HariOP = :emr_prabedah_pha ,TanggalOP = :emr_prabedah_ptanggal ,PLamaTindakan = :emr_prabedah_pperkiraanlamaop ,Anestesi = :emr_prabedah_panestesia ,Puasa = :emr_prabedah_ppuasa ,JamMulaiPuasa = :emr_prabedah_pmulaijam ,PeralatanKhusus = :emr_prabedah_pderetankasus ,PeralatanKhusuLain = :emr_prabedah_pderetankasusket ,Klisma = :emr_prabedah_ppengosongankandungkemih ,KlismaSejak = :emr_prabedah_psejakjam ,Obat = :emr_prabedah_pobat ,PersiapanDarah = :checkbox_emr_prabedah_ppersiapandarah ,KetPersiapanDarah = :emr_prabedah_ppersiapandarahket ,RencanaPostOP = :emr_prabedah_ppersiapandarahrencana ,Catatan = :emr_prabedah_pcatatan
                WHERE NoRegistrasi = :emr_noreg AND IdOrderOperasi  =:emr_idorder");
            }
            $this->db->bind('emr_norm', $emr_norm);
            $this->db->bind('emr_noeps', $emr_noeps);
            $this->db->bind('emr_noreg', $emr_noreg);
            $this->db->bind('useridx', $useridx);
            $this->db->bind('namauserx', $namauserx);
            $this->db->bind('emr_idorder', $emr_idorder);
            $this->db->bind('emr_prabedah_tmptpengkajian', $emr_prabedah_tmptpengkajian);
            $this->db->bind('emr_prabedah_tmptpengkajianket', $emr_prabedah_tmptpengkajianket);
            $this->db->bind('emr_prabedah_skeluhan', $emr_prabedah_skeluhan);
            $this->db->bind('emr_prabedah_sriwayatpenyakit', $emr_prabedah_sriwayatpenyakit);
            $this->db->bind('emr_prabedah_sriwayatoperasi', $emr_prabedah_sriwayatoperasi);
            $this->db->bind('emr_prabedah_spengobatansaatini', $emr_prabedah_spengobatansaatini);
            $this->db->bind('emr_prabedah_shamil', $emr_prabedah_shamil);
            $this->db->bind('emr_prabedah_smenstruasi', $emr_prabedah_smenstruasi);
            $this->db->bind('emr_prabedah_otd', $emr_prabedah_otd);
            $this->db->bind('emr_prabedah_otdper', $emr_prabedah_otdper);
            $this->db->bind('emr_prabedah_orr', $emr_prabedah_orr);
            $this->db->bind('emr_prabedah_onadi', $emr_prabedah_onadi);
            $this->db->bind('emr_prabedah_osuhu', $emr_prabedah_osuhu);
            $this->db->bind('emr_prabedah_ogcs', $emr_prabedah_ogcs);
            $this->db->bind('emr_prabedah_ogcse', $emr_prabedah_ogcse);
            $this->db->bind('emr_prabedah_ogcsm', $emr_prabedah_ogcsm);
            $this->db->bind('emr_prabedah_ogcsv', $emr_prabedah_ogcsv);
            $this->db->bind('emr_prabedah_okepala', $emr_prabedah_okepala);
            $this->db->bind('emr_prabedah_omata', $emr_prabedah_omata);
            $this->db->bind('emr_prabedah_otht', $emr_prabedah_otht);
            $this->db->bind('emr_prabedah_othorax', $emr_prabedah_othorax);
            $this->db->bind('emr_prabedah_oabdomen', $emr_prabedah_oabdomen);
            $this->db->bind('emr_prabedah_ogenetalia', $emr_prabedah_ogenetalia);
            $this->db->bind('emr_prabedah_okulit', $emr_prabedah_okulit);
            $this->db->bind('emr_prabedah_oextremitas', $emr_prabedah_oextremitas);
            $this->db->bind('emr_prabedah_ostatuslokasi', $emr_prabedah_ostatuslokasi);
            $this->db->bind('emr_prabedah_olaboratorium', $emr_prabedah_olaboratorium);
            $this->db->bind('emr_prabedah_oradiologi', $emr_prabedah_oradiologi);
            $this->db->bind('emr_prabedah_oekg', $emr_prabedah_oekg);
            $this->db->bind('emr_prabedah_olain2', $emr_prabedah_olain2);
            $this->db->bind('emr_prabedah_prencanaop', $emr_prabedah_prencanaop);
            $this->db->bind('emr_prabedah_pkriteria', $emr_prabedah_pkriteria);
            $this->db->bind('emr_prabedah_pha', $emr_prabedah_pha);
            $this->db->bind('emr_prabedah_ptanggal', $emr_prabedah_ptanggal);
            $this->db->bind('emr_prabedah_pperkiraanlamaop', $emr_prabedah_pperkiraanlamaop);
            $this->db->bind('emr_prabedah_panestesia', $emr_prabedah_panestesia);
            $this->db->bind('emr_prabedah_ppuasa', $emr_prabedah_ppuasa);
            $this->db->bind('emr_prabedah_pmulaijam', $emr_prabedah_pmulaijam);
            $this->db->bind('emr_prabedah_pderetankasus', $emr_prabedah_pderetankasus);
            $this->db->bind('emr_prabedah_pderetankasusket', $emr_prabedah_pderetankasusket);
            $this->db->bind('emr_prabedah_ppengosongankandungkemih', $emr_prabedah_ppengosongankandungkemih);
            $this->db->bind('emr_prabedah_psejakjam', $emr_prabedah_psejakjam);
            $this->db->bind('emr_prabedah_pobat', $emr_prabedah_pobat);
            $this->db->bind('checkbox_emr_prabedah_ppersiapandarah', $checkbox_emr_prabedah_ppersiapandarah);
            $this->db->bind('emr_prabedah_ppersiapandarahket', $emr_prabedah_ppersiapandarahket);
            $this->db->bind('emr_prabedah_ppersiapandarahrencana', $emr_prabedah_ppersiapandarahrencana);
            $this->db->bind('emr_prabedah_pcatatan', $emr_prabedah_pcatatan);

            $this->db->execute();
            $this->db->commit();

            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
}
