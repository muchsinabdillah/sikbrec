<?php
class  B_InformationMPP_Model  
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getDataListA($data)
    {
        try {
            $tglawal = $data['TglAwal'];
            $tglakhir = $data['TglAkhir'];
            //$JenisForm = $data['JenisForm'];

            $this->db->query("SELECT A.*
            FROM RawatInapSQL.DBO.EMR_MPPA A
            INNER JOIN RawatInapSQL.DBO.Inpatient B
            ON A.NoRegistrasi = B.NoRegRI
            where replace(CONVERT(VARCHAR(11), b.StartDate, 111), '/','-')   between :tglawal and :tglakhir
                "); 
             $this->db->bind('tglawal', $tglawal);
             $this->db->bind('tglakhir', $tglakhir);
                            $data =  $this->db->resultSet();
                            $rows = array();
                            $id = 1;
                            foreach ($data as $row) {
                                $pasing['No'] = $id++;
                               // $pasing['Tgl'] = date('d-m-Y', strtotime($row['Tgl']));

                                $pasing['NoEpisode'] = $row['NoEpisode'];
                                $pasing['NamaPasien'] = $row['NamaPasien'];
                                $pasing['NoRegistrasi'] = $row['NoRegistrasi'];
                                $pasing['NoMR'] = $row['NoMR'];
                                $pasing['Tgl_Lahir'] = $row['Tgl_Lahir'];
                                $pasing['Umur'] = $row['Umur'];
                                $pasing['JenisKelamin'] = $row['JenisKelamin'];
                                $pasing['RuangPerawatan'] = $row['RuangPerawatan'];
                                $pasing['Identf_Resiko_Tinggi'] = $row['Identf_Resiko_Tinggi'];
                                $pasing['IdentfPotensi_Komplen_Tinggi'] = $row['IdentfPotensi_Komplen_Tinggi'];
                                $pasing['IdentfPotensi_Peny_Kronis'] = $row['IdentfPotensi_Peny_Kronis'];
                                $pasing['IdentfPotensi_Renc_plg_Komplex'] = $row['IdentfPotensi_Renc_plg_Komplex'];
                                $pasing['IdentfPotensi_Membutuhkan_Kontinu'] = $row['IdentfPotensi_Membutuhkan_Kontinu'];
                                $pasing['IdentfPotensi_kasus_rawat_lama'] = $row['IdentfPotensi_kasus_rawat_lama'];
                                $pasing['IdentfPotensi_biaya_tinggi'] = $row['IdentfPotensi_biaya_tinggi'];
                                $pasing['IdentfPotensi_Perkiraan_maslh_Financial'] = $row['IdentfPotensi_Perkiraan_maslh_Financial'];
                                $pasing['IdentfPotensi_Kasus_rumit'] = $row['IdentfPotensi_Kasus_rumit'];
                                $pasing['IdentfPotensi_Riwayat_Gangguan_Mental'] = $row['IdentfPotensi_Riwayat_Gangguan_Mental'];
                                $pasing['IdentfPotensi_Bunuh_diri'] = $row['IdentfPotensi_Bunuh_diri'];
                                $pasing['IdentfPotensi_terlantar'] = $row['IdentfPotensi_terlantar'];
                                $pasing['IdentfPotensi_tinggalSendiri'] = $row['IdentfPotensi_tinggalSendiri'];
                                $pasing['IdentfPotensi_narkoba'] = $row['IdentfPotensi_narkoba'];
                                $pasing['Asesment_Riwayat_Saatini'] = $row['Asesment_Riwayat_Saatini'];
                                $pasing['Riwayat_Kesehatan'] = $row['Riwayat_Kesehatan'];
                                $pasing['Psiko_spiritual_sosial'] = $row['Psiko_spiritual_sosial'];
                                $pasing['Dukungan_Kel'] = $row['Dukungan_Kel'];
                                $pasing['Pemahaman_Kesehatan'] = $row['Pemahaman_Kesehatan'];
                                $pasing['Financial'] = $row['Financial'];
                                $pasing['Penjamin'] = $row['Penjamin'];
                                $pasing['DPJP_Utama'] = $row['DPJP_Utama'];
                                $pasing['DPJP_Raber'] = $row['DPJP_Raber'];
                                $pasing['Diagnosis_Medis'] = $row['Diagnosis_Medis'];
                                $pasing['Identifikasi_Masalah'] = $row['Identifikasi_Masalah'];
                                $pasing['Perencanaan_Pelayanan'] = $row['Perencanaan_Pelayanan'];
                                $pasing['Case_Manager'] = $row['Case_Manager'];
                                $pasing['Hipertensi'] = $row['Hipertensi'];
                                $pasing['Hipertensi_ket'] = $row['Hipertensi_ket'];
                                $pasing['Jantung'] = $row['Jantung'];
                                $pasing['Jantung_ket'] = $row['Jantung_ket'];
                                $pasing['DM'] = $row['DM'];
                                $pasing['DM_ket'] = $row['DM_ket'];
                                $pasing['PPOK'] = $row['PPOK'];
                                $pasing['PPOK_ket'] = $row['PPOK_ket'];
                                $pasing['Kanker'] = $row['Kanker'];
                                $pasing['Kanker_ket'] = $row['Kanker_ket'];
                                $pasing['Lain_lain'] = $row['Lain_lain'];
                                $pasing['Lain_lain_ket'] = $row['Lain_lain_ket'];
                                $rows[] = $pasing;
                            }
                            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataListB($data)
    {
        try {
            $tglawal = $data['TglAwal'];
            $tglakhir = $data['TglAkhir'];
            //$JenisForm = $data['JenisForm'];

            $this->db->query("SELECT A.*,c.*
            FROM RawatInapSQL.DBO.EMR_MPPB A
            INNER JOIN RawatInapSQL.DBO.Inpatient B
            ON A.NoRegistrasi = B.NoRegRI
            inner join RawatInapSQL.dbo.EMR_MPPB_2 C
            on a.Id = C.Id_HDR
            where replace(CONVERT(VARCHAR(11), b.StartDate, 111), '/','-')   between :tglawal and :tglakhir
                "); 
             $this->db->bind('tglawal', $tglawal);
             $this->db->bind('tglakhir', $tglakhir);
                            $data =  $this->db->resultSet();
                            $rows = array();
                            $id = 1;
                            foreach ($data as $row) {
                                $pasing['No'] = $id++;
                                $pasing['NoEpisode'] = $row['NoEpisode'];
                                $pasing['NamaPasien'] = $row['NamaPasien'];
                                $pasing['NoRegistrasi'] = $row['NoRegistrasi'];
                                $pasing['NoMR'] = $row['NoMR'];
                                $pasing['Tgl_Lahir'] = $row['Tgl_Lahir'];
                                $pasing['Umur'] = $row['Umur'];
                                $pasing['JenisKelamin'] = $row['JenisKelamin'];
                                $pasing['RuangPerawatan'] = $row['RuangPerawatan'];
                                $pasing['Penjamin'] = $row['Penjamin'];
                                $pasing['HasilPelayanan'] = $row['HasilPelayanan'];
                                $pasing['Terminasi'] = $row['Terminasi'];
                                $rows[] = $pasing;
                            }
                            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
