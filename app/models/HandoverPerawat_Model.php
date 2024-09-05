<?php
class HandoverPerawat_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function insert($data)
    {

        try {
            // var_dump('hhhhh');
            // exit;
            $this->db->transaksi();
            if ($data['Ruangan'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi Ruangan!',
                );
                return $callback;
                exit;
            }
            if ($data['Tanggal'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi Tanggal!',
                );
                return $callback;
                exit;
            }
            if ($data['Jadwal_Shift'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi Jadwal Shift!',
                );
                return $callback;
                exit;
            }
            if ($data['Hari_Rawat_Ke'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi Hari Rawat Ke!',
                );
                return $callback;
                exit;
            }
            if ($data['DPJP'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi DPJP!',
                );
                return $callback;
                exit;
            }
            if ($data['Dokter_Rawat_Bersama'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi Dokter Rawat Bersama!',
                );
                return $callback;
                exit;
            }
            if ($data['Diagnosa_Medis'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi Diagnosa Medis!',
                );
                return $callback;
                exit;
            }
            if ($data['Masalah_utama_saat_ini_yang_menjadi_perhatian'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi Masalah utama saat ini yang menjadi perhatian!',
                );
                return $callback;
                exit;
            }
            if ($data['Obat_Terkini'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi Obat Terkini!',
                );
                return $callback;
                exit;
            }
            if ($data['Kesadaran'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi !',
                );
                return $callback;
                exit;
            }
            if ($data['GCS_E'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi !',
                );
                return $callback;
                exit;
            }
            if ($data['V'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi !',
                );
                return $callback;
                exit;
            }
            if ($data['M'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi !',
                );
                return $callback;
                exit;
            }
            if ($data['Total'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi !',
                );
                return $callback;
                exit;
            }
            if ($data['Tingkat_Ketergantungan_Pasien'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi Tingkat Ketergantungan Pasien!',
                );
                return $callback;
                exit;
            }
            if ($data['TTV_TD'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi TTV:TD!',
                );
                return $callback;
                exit;
            }
            if ($data['Nadi'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi Nadi!',
                );
                return $callback;
                exit;
            }
            if ($data['Suhu'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi Suhu!',
                );
                return $callback;
                exit;
            }
            if ($data['RR'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi RR!',
                );
                return $callback;
                exit;
            }
            if ($data['Saturasi_O2'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi Saturasi O2!',
                );
                return $callback;
                exit;
            }
            if ($data['Score_EWS'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi Score EWS!',
                );
                return $callback;
                exit;
            }
            if ($data['Score_Jatuh'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi Score Jatuh!',
                );
                return $callback;
                exit;
            }
            if ($data['Skala_Nyeri'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi Skala Nyeri!',
                );
                return $callback;
                exit;
            }
            if ($data['Penggunaan_Restrain'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi Penggunaan Restrain!',
                );
                return $callback;
                exit;
            }
            if ($data['NGT'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi NGT!',
                );
                return $callback;
                exit;
            }
            if ($data['TGL_Pasang'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi TGL Pasang!',
                );
                return $callback;
                exit;
            }
            if ($data['Folley_Catheter'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi Folley Catheter!',
                );
                return $callback;
                exit;
            }
            if ($data['TGL_Psng'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Di Isi TGL Psng!',
                );
                return $callback;
                exit;
            }
            $Ruangan = $data['Ruangan'];
            $Tanggal = $data['Tanggal'];
            $Jadwal_Shift = $data['Jadwal_Shift'];
            $Hari_Rawat_Ke = $data['Hari_Rawat_Ke'];
            $DPJP = $data['DPJP'];
            $Dokter_Rawat_Bersama = $data['Dokter_Rawat_Bersama'];
            $Diagnosa_Medis = $data['Diagnosa_Medis'];
            $Masalah_utama_saat_ini_yang_menjadi_perhatian = $data['Masalah_utama_saat_ini_yang_menjadi_perhatian'];
            $Obat_Terkini = $data['Obat_Terkini'];
            $Kesadaran = $data['Kesadaran'];
            $GCS_E = $data['GCS_E'];
            $V = $data['V'];
            $M = $data['M'];
            $Total = $data['Total'];
            $Tingkat_Ketergantungan_Pasien = $data['Tingkat_Ketergantungan_Pasien'];
            $TTV_TD = $data['TTV_TD'];
            $Nadi = $data['Nadi'];
            $Suhu = $data['Suhu'];
            $RR = $data['RR'];
            $Saturasi_O2 = $data['Saturasi_O2'];
            $Score_EWS = $data['Score_EWS'];
            $Score_Jatuh = $data['Score_Jatuh'];
            $Skala_Nyeri = $data['Skala_Nyeri'];
            $Penggunaan_Restrain = $data['Penggunaan_Restrain'];
            $NGT = $data['NGT'];
            $TGL_Pasang = $data['TGL_Pasang'];
            $Folley_Catheter = $data['Folley_Catheter'];
            $TGL_Psng = $data['TGL_Psng'];




            if ($Ruangan == "") {
                $this->db->query("INSERT INTO  PerawatanSQL.dbo.FormHandOverPerawat (
                        [Ruangan],
	[HariTgl]  ,
	[Jadwal_Shift]  ,
	[HariRawatKe]  ,
	[DPJP]  ,
	[DokterRawatBersama]  ,
	[DiagnosaMedis]  ,
	[MasalahUtamaSaatIni]  ,
	[Obat2anTerkini]  ,
	[Kesadaran]  ,
	[GCS]  ,
	[V]  ,
	[M]  ,
	[Total] ,
    [TingkatKetergantungan],
    [TTV],
    [Nadi],
    [Suhu],
    [RR],
    [SaturasiO2],
    [ScoreEWS],
    [ScoreJatuh],
    [SkalaNyeri],
    [PenggunaanRestrain],
    [NGT],
    [TglPasang],
    [FolleyCatheter],
    [tgl]
    ) values (:Ruangan,:Tanggal,:Jadwal_Shift,:Hari_Rawat_Ke,:DPJP,
    :Dokter_Rawat_Bersama,:Diagnosa_Medis,:Masalah_utama_saat_ini_yang_menjadi_perhatian,
    :Obat_Terkini,
    :Kesadaran,:GCS_E,:V,:M,:Total,:Tingkat_Ketergantungan_Pasien,:TTV_TD,:Nadi,:Suhu,
    :RR,:Saturasi_O2,:Score_EWS,:Score_Jatuh,:Skala_Nyeri,:Penggunaan_Restrain,
    :NGT,:TGL_Pasang,:Folley_Catheter,:TGL_Psng
    )
    ");
            } else {
                $this->db->query("INSERT INTO PerawatanSQL.dbo.FormHandOverPerawat (
                        [Ruangan],
	[HariTgl]  ,
	[Jadwal_Shift]  ,
	[HariRawatKe]  ,
	[DPJP]  ,
	[DokterRawatBersama]  ,
	[DiagnosaMedis]  ,
	[MasalahUtamaSaatIni]  ,
	[Obat2anTerkini]  ,
	[Kesadaran]  ,
	[V]  ,
	[M]  ,
	[Total] ,
    [TingkatKetergantungan],
    [TTV],
    [Nadi],
    [Suhu],
    [RR],
    [SaturasiO2],
    [ScoreEWS],
    [ScoreJatuh],
    [SkalaNyeri],
    [PenggunaanRestrain],
    [NGT],
    [TglPasang],
    [FolleyCatheter],
    [tgl]
    ) values (:Ruangan,:Tanggal,:Jadwal_Shift,:Hari_Rawat_Ke,:DPJP,
    :Dokter_Rawat_Bersama,:Diagnosa_Medis,:Masalah_utama_saat_ini_yang_menjadi_perhatian,
    :Obat_Terkini,
    :Kesadaran,:GCS_E,:V,:M,:Total,:Tingkat_Ketergantungan_Pasien,:TTV_TD,:Nadi,:Suhu,
    :RR,:Saturasi_O2,:Score_EWS,:Score_Jatuh,:Skala_Nyeri,:Penggunaan_Restrain,
    :NGT,:TGL_Pasang,:Folley_Catheter,:TGL_Psng
    )
    ");
            }

            $this->db->bind('Ruangan', $Ruangan);
            $this->db->bind('Tanggal', $Tanggal);
            $this->db->bind('Jadwal_Shift', $Jadwal_Shift);
            $this->db->bind('Hari_Rawat_Ke', $Hari_Rawat_Ke);
            $this->db->bind('DPJP', $DPJP);
            $this->db->bind('Dokter_Rawat_Bersama', $Dokter_Rawat_Bersama);
            $this->db->bind('Diagnosa_Medis', $Diagnosa_Medis);
            $this->db->bind('Masalah_utama_saat_ini_yang_menjadi_perhatian', $Masalah_utama_saat_ini_yang_menjadi_perhatian);
            $this->db->bind('Obat_Terkini', $Obat_Terkini);
            $this->db->bind('Kesadaran', $Kesadaran);
            $this->db->bind('GCS_E', $GCS_E);
            $this->db->bind('V', $V);
            $this->db->bind('M', $M);
            $this->db->bind('Total', $Total);
            $this->db->bind('Tingkat_Ketergantungan_Pasien', $Tingkat_Ketergantungan_Pasien);
            $this->db->bind('TTV_TD', $TTV_TD);
            $this->db->bind('Nadi', $Nadi);
            $this->db->bind('Suhu', $Suhu);
            $this->db->bind('RR', $RR);
            $this->db->bind('Saturasi_O2', $Saturasi_O2);
            $this->db->bind('Score_EWS', $Score_EWS);
            $this->db->bind('Score_Jatuh', $Score_Jatuh);
            $this->db->bind('Skala_Nyeri', $Skala_Nyeri);
            $this->db->bind('Penggunaan_Restrain', $Penggunaan_Restrain);
            $this->db->bind('NGT', $NGT);
            $this->db->bind('TGL_Pasang', $TGL_Pasang);
            $this->db->bind('Folley_Catheter', $Folley_Catheter);
            $this->db->bind('TGL_Psng', $TGL_Psng);
            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success    
            );

            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
}
