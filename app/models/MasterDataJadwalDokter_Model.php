<?php
class MasterDataJadwalDokter_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getAllDataJadwalDokter()
    {
        try {
            $this->db->query("SELECT CASE WHEN Group_Jadwal='1' THEN 'BPJS'  WHEN Group_Jadwal='2' THEN 'NON BPJS' END AS Group_Jadwal_fix, CASE WHEN Status_Aktif='1' THEN 'AKTIF' WHEN Status_Aktif='0' THEN 'NON AKTIF' END AS Status_Aktif_fix,* 
                            FROM MasterdataSQL.dbo.JadwalPraktek WHERE Status_Aktif='1'");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['NamaDokter'] = $key['NamaDokter'];
                $pasing['Poli'] = $key['Poli'];
                $pasing['Senin_Waktu'] = $key['Senin_Waktu'];
                $pasing['Selasa_Waktu'] = $key['Selasa_Waktu'];
                $pasing['Rabu_Waktu'] = $key['Rabu_Waktu'];
                $pasing['Kamis_Waktu'] = $key['Kamis_Waktu'];
                $pasing['Jumat_Waktu'] = $key['Jumat_Waktu'];
                $pasing['Sabtu_Waktu'] = $key['Sabtu_Waktu'];
                $pasing['Minggu_Waktu'] = $key['Minggu_Waktu'];
                $pasing['Note'] = $key['Note'];
                $pasing['Group_Jadwal'] = $key['Group_Jadwal_fix'];
                $pasing['Status_Aktif'] = $key['Status_Aktif_fix'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getAllDataJadwalDokterr($data)
    {
        try {
            $this->db->transaksi();
            $GrupPerawatan = $data['GrupPerawatan'];
            $this->db->query("SELECT CASE WHEN Group_Jadwal='1' THEN 'BPJS'  WHEN Group_Jadwal='2' THEN 'NON BPJS' END AS Group_Jadwal_fix, 
            CASE WHEN Status_Aktif='1' THEN 'AKTIF' WHEN Status_Aktif='0' THEN 'NON AKTIF' END AS Status_Aktif_fix,* 
                                        FROM MasterdataSQL.dbo.JadwalPraktek WHERE IDUnit=:GrupPerawatan");
            $this->db->bind('GrupPerawatan', $GrupPerawatan);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['NamaDokter'] = $key['NamaDokter'];
                $pasing['Poli'] = $key['Poli'];
                $pasing['Senin_Waktu'] = $key['Senin_Waktu'];
                $pasing['Selasa_Waktu'] = $key['Selasa_Waktu'];
                $pasing['Rabu_Waktu'] = $key['Rabu_Waktu'];
                $pasing['Kamis_Waktu'] = $key['Kamis_Waktu'];
                $pasing['Jumat_Waktu'] = $key['Jumat_Waktu'];
                $pasing['Sabtu_Waktu'] = $key['Sabtu_Waktu'];
                $pasing['Minggu_Waktu'] = $key['Minggu_Waktu'];
                $pasing['Note'] = $key['Note'];
                $pasing['Group_Jadwal'] = $key['Group_Jadwal_fix'];
                $pasing['Status_Aktif'] = $key['Status_Aktif_fix'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    // INSERT
    public function insert($data)
    {
        try {
            $this->db->transaksi();

            if ($data['GrupPerawatan'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Poliklinik!',
                );
                return $callback;
                exit;
            }
            if ($data['NamaDokter'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Nama Dokter !',
                );
                return $callback;
                exit;
            }

            $IdAuto = $data['IdAuto'];
            $StatusJadwal = $data['StatusJadwal'];
            $SeninStatus = $data['SeninStatus'];
            $SeninWaktuAwal = $data['SeninWaktuAwal'];
            $SeninWaktuAkhir = $data['SeninWaktuAkhir'];
            $SessionSenin = $data['SessionSenin'];
            $SelasaStatus = $data['SelasaStatus'];
            $SelasaWaktuAwal = $data['SelasaWaktuAwal'];
            $SelasaWaktuAkhir = $data['SelasaWaktuAkhir'];
            $SessionSelasa = $data['SessionSelasa'];
            $RabuStatus = $data['RabuStatus'];
            $RabuWaktuAwal = $data['RabuWaktuAwal'];
            $RabuWaktuAkhir = $data['RabuWaktuAkhir'];
            $SessionRabu = $data['SessionRabu'];
            $KamisStatus = $data['KamisStatus'];
            $KamisWaktuAwal = $data['KamisWaktuAwal'];
            $KamisWaktuAkhir = $data['KamisWaktuAkhir'];
            $SessionKamis = $data['SessionKamis'];
            $JumatStatus = $data['JumatStatus'];
            $JumatWaktuAwal = $data['JumatWaktuAwal'];
            $JumatWaktuAkhir = $data['JumatWaktuAkhir'];
            $SessionJumat = $data['SessionJumat'];
            $SabtuStatus = $data['SabtuStatus'];
            $SabtuWaktuAwal = $data['SabtuWaktuAwal'];
            $SabtuWaktuAkhir = $data['SabtuWaktuAkhir'];
            $SessionSabtu = $data['SessionSabtu'];
            $MingguStatus = $data['MingguStatus'];
            $MingguWaktuAwal = $data['MingguWaktuAwal'];
            $MingguWaktuAkhir = $data['MingguWaktuAkhir'];
            $SessionMinggu = $data['SessionMinggu'];
            $MaxSenin = $data['MaxSenin'];
            $MaxSelasa = $data['MaxSelasa'];
            $MaxRabu = $data['MaxRabu'];
            $MaxKamis = $data['MaxKamis'];
            $MaxJumat = $data['MaxJumat'];
            $MaxSabtu = $data['MaxSabtu'];
            $MaxMinggu = $data['MaxMinggu'];
            $Note = $data['Note'];
            $GrupPerawatan = $data['GrupPerawatan'];
            $NamaDokter = $data['NamaDokter'];
            // $IdDokter = $data['iddokter'];

            $KuotaBpjsSenin = $data['KuotaBpjsSenin'];
            $KuotaNonBpjsSenin = $data['KuotaNonBpjsSenin'];

            $KuotaBpjsSelasa = $data['KuotaBpjsSelasa'];
            $KuotaNonBpjsSelasa = $data['KuotaNonBpjsSelasa'];

            $KuotaBpjsRabu = $data['KuotaBpjsRabu'];
            $KuotaNonBpjsRabu = $data['KuotaNonBpjsRabu'];

            $KuotaBpjsKamis = $data['KuotaBpjsKamis'];
            $KuotaNonBpjsKamis = $data['KuotaNonBpjsKamis'];

            $KuotaBpjsJumat = $data['KuotaBpjsJumat'];
            $KuotaNonBpjsJumat = $data['KuotaNonBpjsJumat'];

            $KuotaBpjsSabtu = $data['KuotaBpjsSabtu'];
            $KuotaNonBpjsSabtu = $data['KuotaNonBpjsSabtu'];

            $KuotaBpjsMinggu = $data['KuotaBpjsMinggu'];
            $KuotaNonBpjsMinggu = $data['KuotaNonBpjsMinggu'];
            $GroupJadwal = $data['GroupJadwal'];

            $seninwaktumix = $_POST['SeninWaktuAwal'] . "-" . $_POST['SeninWaktuAkhir'];
            $selasawaktumix = $_POST['SelasaWaktuAwal'] . "-" . $_POST['SelasaWaktuAkhir'];
            $rabuwaktumix = $_POST['RabuWaktuAwal'] . "-" . $_POST['RabuWaktuAkhir'];
            $kamiswaktumix = $_POST['KamisWaktuAwal'] . "-" . $_POST['KamisWaktuAkhir'];
            $jumatwaktumix = $_POST['JumatWaktuAwal'] . "-" . $_POST['JumatWaktuAkhir'];
            $sabtuwaktumix = $_POST['SabtuWaktuAwal'] . "-" . $_POST['SabtuWaktuAkhir'];
            $mingguwaktumix = $_POST['MingguWaktuAwal'] . "-" . $_POST['MingguWaktuAkhir'];

            //Get nama unit
            $this->db->query("SELECT NamaUnit
                                from MasterdataSQL.dbo.MstrUnitPerwatan  
                                where ID=:GrupPerawatan");
            $this->db->bind('GrupPerawatan', $GrupPerawatan);
            $dataUnit =  $this->db->resultSet();
            foreach ($dataUnit as $key) {
                $NamaUnit = $key['NamaUnit'];
            }

            //Get nama dokter
            $this->db->query("SELECT First_Name, id
                                from MasterdataSQL.dbo.Doctors 
                                where ID=:NamaDokter");
            $this->db->bind('NamaDokter', $NamaDokter);
            $datadokter =  $this->db->resultSet();
            foreach ($datadokter as $key) {
                $First_Name = $key['First_Name'];
            }


            //CEK VALIDASI SENIN
            if ($GroupJadwal == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Group Jadwal Harus Diisi !',
                );
                return $callback;
                exit;
            }
            if ($StatusJadwal == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Status Jadwal Harus Diisi !',
                );
                return $callback;
                exit;
            }
            if ($SeninStatus == '1') {
                $hari = 'Senin';

                if ($SeninWaktuAwal == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Jam Waktu ' . $hari . ' Awal Harus Diisi !',
                    );
                    return $callback;
                    exit;
                }

                if ($SeninWaktuAkhir == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Jam Waktu ' . $hari . ' Akhir Harus Diisi !',
                    );
                    return $callback;
                    exit;
                }

                if ($MaxSenin == "" || $MaxSenin == 0) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Kuota Max ' . $hari . ' Tidak Boleh Kosong atau 0 !',
                    );
                    return $callback;
                    exit;
                }

                if ($KuotaBpjsSenin == "" || $KuotaBpjsSenin == 0) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Kuota BPJS ' . $hari . ' Tidak Boleh Kosong atau 0 !',
                    );
                    return $callback;
                    exit;
                }

                if ($KuotaNonBpjsSenin == "" || $KuotaNonBpjsSenin == 0) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Kuota Non BPJS ' . $hari . ' Tidak Boleh Kosong atau 0 !',
                    );
                    return $callback;
                    exit;
                }
            }

            //CEK VALIDASI SELASA
            if ($SelasaStatus == '1') {
                $hari = 'Selasa';
                if ($SelasaWaktuAwal == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Jam Waktu Awal ' . $hari . ' Harus Diisi !',
                    );
                    return $callback;
                    exit;
                }

                if ($SelasaWaktuAkhir == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Jam Waktu Akhir ' . $hari . ' Harus Diisi !',
                    );
                    return $callback;
                    exit;
                }

                if ($MaxSelasa == "" || $MaxSelasa == 0) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Kuota Max ' . $hari . ' Tidak Boleh Kosong atau 0 !',
                    );
                    return $callback;
                    exit;
                }

                if ($KuotaBpjsSelasa == "" || $KuotaBpjsSelasa == 0) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Kuota BPJS ' . $hari . ' Tidak Boleh Kosong atau 0 !',
                    );
                    return $callback;
                    exit;
                }

                if ($KuotaNonBpjsSelasa == "" || $KuotaNonBpjsSelasa == 0) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Kuota Non BPJS ' . $hari . ' Tidak Boleh Kosong atau 0 !',
                    );
                    return $callback;
                    exit;
                }
            }

            //CEK VALIDASI RABU
            if ($RabuStatus == '1') {
                $hari = 'Rabu';

                if ($RabuWaktuAwal == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Jam Waktu ' . $hari . ' Awal Harus Diisi !',
                    );
                    return $callback;
                    exit;
                }

                if ($RabuWaktuAkhir == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Jam Waktu ' . $hari . ' Akhir Harus Diisi !',
                    );
                    return $callback;
                    exit;
                }

                if ($MaxRabu == "" || $MaxRabu == 0) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Kuota Max ' . $hari . ' Tidak Boleh Kosong atau 0 !',
                    );
                    return $callback;
                    exit;
                }

                if ($KuotaBpjsRabu == "" || $KuotaBpjsRabu == 0) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Kuota BPJS ' . $hari . ' Tidak Boleh Kosong atau 0 !',
                    );
                    return $callback;
                    exit;
                }

                if ($KuotaNonBpjsRabu == "" || $KuotaNonBpjsRabu == 0) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Kuota Non BPJS ' . $hari . ' Tidak Boleh Kosong atau 0 !',
                    );
                    return $callback;
                    exit;
                }
            }

            //CEK VALIDASI Kamis
            if ($KamisStatus == '1') {
                $hari = 'Kamis';

                if ($KamisWaktuAwal == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Jam Waktu ' . $hari . ' Awal Harus Diisi !',
                    );
                    return $callback;
                    exit;
                }

                if ($KamisWaktuAkhir == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Jam Waktu ' . $hari . ' Akhir Harus Diisi !',
                    );
                    return $callback;
                    exit;
                }

                if ($MaxKamis == "" || $MaxKamis == 0) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Kuota Max ' . $hari . ' Tidak Boleh Kosong atau 0 !',
                    );
                    return $callback;
                    exit;
                }

                if ($KuotaBpjsKamis == "" || $KuotaBpjsKamis == 0) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Kuota BPJS ' . $hari . ' Tidak Boleh Kosong atau 0 !',
                    );
                    return $callback;
                    exit;
                }

                if ($KuotaNonBpjsKamis == "" || $KuotaNonBpjsKamis == 0) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Kuota Non BPJS ' . $hari . ' Tidak Boleh Kosong atau 0 !',
                    );
                    return $callback;
                    exit;
                }
            }

            //CEK VALIDASI JUMAT
            if ($JumatStatus == '1') {
                $hari = 'Jumat';

                if ($JumatWaktuAwal == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Jam Waktu ' . $hari . ' Awal Harus Diisi !',
                    );
                    return $callback;
                    exit;
                }

                if ($JumatWaktuAkhir == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Jam Waktu ' . $hari . ' Akhir Harus Diisi !',
                    );
                    return $callback;
                    exit;
                }

                if ($MaxJumat == "" || $MaxJumat == 0) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Kuota Max ' . $hari . ' Tidak Boleh Kosong atau 0 !',
                    );
                    return $callback;
                    exit;
                }

                if ($KuotaBpjsJumat == "" || $KuotaBpjsJumat == 0) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Kuota BPJS ' . $hari . ' Tidak Boleh Kosong atau 0 !',
                    );
                    return $callback;
                    exit;
                }

                if ($KuotaNonBpjsJumat == "" || $KuotaNonBpjsJumat == 0) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Kuota Non BPJS ' . $hari . ' Tidak Boleh Kosong atau 0 !',
                    );
                    return $callback;
                    exit;
                }
            }

            //CEK VALIDASI SABTU
            if ($SabtuStatus == '1') {
                $hari = 'Sabtu';

                if ($SabtuWaktuAwal == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Jam Waktu ' . $hari . ' Awal Harus Diisi !',
                    );
                    return $callback;
                    exit;
                }

                if ($SabtuWaktuAkhir == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Jam Waktu ' . $hari . ' Akhir Harus Diisi !',
                    );
                    return $callback;
                    exit;
                }

                if ($MaxSabtu == "" || $MaxSabtu == 0) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Kuota Max ' . $hari . ' Tidak Boleh Kosong atau 0 !',
                    );
                    return $callback;
                    exit;
                }

                if ($KuotaBpjsSabtu == "" || $KuotaBpjsSabtu == 0) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Kuota BPJS ' . $hari . ' Tidak Boleh Kosong atau 0 !',
                    );
                    return $callback;
                    exit;
                }

                if ($KuotaNonBpjsSabtu == "" || $KuotaNonBpjsSabtu == 0) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Kuota Non BPJS ' . $hari . ' Tidak Boleh Kosong atau 0 !',
                    );
                    return $callback;
                    exit;
                }
            }

            //CEK VALIDASI Minggu
            if ($MingguStatus == '1') {
                $hari = 'Minggu';

                if ($MingguWaktuAwal == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Jam Waktu ' . $hari . ' Awal Harus Diisi !',
                    );
                    return $callback;
                    exit;
                }

                if ($MingguWaktuAkhir == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Jam Waktu ' . $hari . ' Akhir Harus Diisi !',
                    );
                    return $callback;
                    exit;
                }

                if ($MaxMinggu == "" || $MaxMinggu == 0) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Kuota Max ' . $hari . ' Tidak Boleh Kosong atau 0 !',
                    );
                    return $callback;
                    exit;
                }

                if ($KuotaBpjsMinggu == "" || $KuotaBpjsMinggu == 0) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Kuota BPJS ' . $hari . ' Tidak Boleh Kosong atau 0 !',
                    );
                    return $callback;
                    exit;
                }

                if ($KuotaNonBpjsMinggu == "" || $KuotaNonBpjsMinggu == 0) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Kuota Non BPJS ' . $hari . ' Tidak Boleh Kosong atau 0 !',
                    );
                    return $callback;
                    exit;
                }
            }

            if ($IdAuto == "") {

                $this->db->query("INSERT INTO MasterdataSQL.dbo.JadwalPraktek (IDDokter,IDUnit,Status_Aktif,Senin,Senin_waktu,Senin_Sesion,
                  Selasa,Selasa_waktu,Selasa_Sesion, Rabu,Rabu_waktu,Rabu_Sesion,
                  Kamis,Kamis_waktu,Kamis_Sesion,Jumat,Jumat_waktu,Jumat_Sesion,
                  Sabtu,Sabtu_waktu,Sabtu_Sesion,Minggu,Minggu_waktu,Minggu_Sesion,Note,
                  Senin_Awal,Senin_Akhir,Selasa_Awal,Selasa_Akhir, Rabu_Awal,Rabu_Akhir,Kamis_Awal,Kamis_Akhir,
                  Jumat_Awal,Jumat_Akhir,Sabtu_Awal,Sabtu_Akhir,Minggu_Awal,Minggu_Akhir,
                  Senin_Max,Selasa_Max,Rabu_Max,Kamis_Max, Jumat_Max,Sabtu_Max,Minggu_Max,NamaDokter,Poli,Senin_Max_JKN,
                  Senin_Max_NonJKN,Selasa_Max_JKN,Selasa_Max_NonJKN,Rabu_Max_JKN,Rabu_Max_NonJKN,Kamis_Max_JKN,
                  Kamis_Max_NonJKN,Jumat_Max_JKN,Jumat_Max_NonJKN,Sabtu_Max_JKN,Sabtu_Max_NonJKN,Minggu_Max_JKN,Minggu_Max_NonJKN
                  ,Group_Jadwal
                  ) 
                  VALUES
                  (:NamaDokter,:GrupPerawatan,:Status_Aktif,:SeninStatus,:seninwaktumix,:SessionSenin,:SelasaStatus,
                  :selasawaktumix,:SessionSelasa,:RabuStatus,:rabuwaktumix,:SessionRabu,:KamisStatus,
                  :kamiswaktumix,:SessionKamis,:JumatStatus,:jumatwaktumix,:SessionJumat,:SabtuStatus,
                  :sabtuwaktumix,:SessionSabtu,:MingguStatus,:mingguwaktumix,:SessionMinggu,:Note,:SeninWaktuAwal,
                  :SeninWaktuAkhir,:SelasaWaktuAwal,:SelasaWaktuAkhir,:RabuWaktuAwal,:RabuWaktuAkhir,:KamisWaktuAwal,
                  :KamisWaktuAkhir,:JumatWaktuAwal,:JumatWaktuAkhir,:SabtuWaktuAwal,:SabtuWaktuAkhir,:MingguWaktuAwal,
                  :MingguWaktuAkhir,:MaxSenin,:MaxSelasa,:MaxRabu,:MaxKamis,:MaxJumat,:MaxSabtu,:MaxMinggu,:First_Name,
                  :NamaUnit,:KuotaBpjsSenin,:KuotaNonBpjsSenin,:KuotaBpjsSelasa,:KuotaNonBpjsSelasa,:KuotaBpjsRabu,
                  :KuotaNonBpjsRabu,:KuotaBpjsKamis,:KuotaNonBpjsKamis,:KuotaBpjsJumat,:KuotaNonBpjsJumat,:KuotaBpjsSabtu,
                  :KuotaNonBpjsSabtu,:KuotaBpjsMinggu,:KuotaNonBpjsMinggu
                  ,:Group_Jadwal
              )");
            } else {
                //alim
                //CEK ADA PERUBAHAN ATAU TIDAK
                $this->db->query("SELECT 
                Group_Jadwal,
                Status_Aktif,
                Senin,
                Selasa,
                Rabu,
                Kamis,
                Jumat,
                Sabtu,
                Minggu,
                Note,
                Senin_Sesion,
                Selasa_Sesion,
                Rabu_Sesion,
                Kamis_Sesion,
                Jumat_Sesion,
                Sabtu_Sesion,
                Minggu_Sesion,
                Senin_Awal,
                Senin_Akhir,
                Selasa_Awal,
                Selasa_Akhir,
                Rabu_Awal,
                Rabu_Akhir,
                Kamis_Awal,
                Kamis_akhir,
                Jumat_Awal,
                Jumat_Akhir,
                Sabtu_Awal,
                Sabtu_Akhir,
                Minggu_Awal,
                Minggu_Akhir
                 from MasterdataSQL.dbo.JadwalPraktek WHERE ID=:IdAuto");
                $this->db->bind('IdAuto', $IdAuto);
                $data2 =  $this->db->single();

                $datenowcreate = Utils::seCurrentDateTime();
                $dates = Utils::datenowcreateNotFull();
                // $dates = '2022-12-18';
                $session = SessionManager::getCurrentSession();
                $namauserx = $session->name;

                //HARI SENIN

                if ($data2['Status_Aktif'] != $StatusJadwal || $data2['Senin'] != $SeninStatus || $data2['Senin_Awal'] != $SeninWaktuAwal || $data2['Senin_Akhir'] != $SeninWaktuAkhir || $data2['Senin_Sesion'] != $SessionSenin) {
                    $hari = 'Monday';
                    if ($GroupJadwal == "1") {
                        $this->db->query(" SELECT *FROM PerawatanSQL.DBO.Apointment WHERE NoBooking IN (
                                            select  no_transaksi from PerawatanSQL.DBO.AntrianPasien 
                                            WHERE Doctor_1=:bNamaDokter 
                                            AND replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-') >=:TglKunjungan
                                            AND FORMAT(TglKunjungan, 'dddd')='Monday'  
                                        ) and ID_Penjamin=:ID_Penjamin and JenisPembayaran=:JenisPembayaran");
                        $this->db->bind('JenisPembayaran', 'JAMINAN PERUSAHAAN');
                        $this->db->bind('ID_Penjamin', '313');
                        $this->db->bind('TglKunjungan', $dates);
                        $this->db->bind('bNamaDokter', $NamaDokter);
                        $data =  $this->db->resultSet();
                        foreach ($data as $key) {
                            $this->db->query("UPDATE PerawatanSQL.DBO.AntrianPasien SET JamPraktek=:SessionSenin
                            WHERE no_transaksi=:kodebooking");
                            $this->db->bind('kodebooking', $key['NoBooking']);
                            $this->db->bind('SessionSenin', $SessionSenin);
                            $this->db->execute();
                        }
                    } else {
                        $this->db->query(" SELECT *FROM PerawatanSQL.DBO.Apointment WHERE NoBooking IN (
                            select  no_transaksi from PerawatanSQL.DBO.AntrianPasien 
                            WHERE Doctor_1=:bNamaDokter 
                            AND replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-') >=:TglKunjungan
                            AND FORMAT(TglKunjungan, 'dddd')='Monday'  
                        ) and ID_Penjamin<>:ID_Penjamin and JenisPembayaran<>:JenisPembayaran");
                        $this->db->bind('JenisPembayaran', 'JAMINAN PERUSAHAAN');
                        $this->db->bind('ID_Penjamin', '313');
                        $this->db->bind('TglKunjungan', $dates);
                        $this->db->bind('bNamaDokter', $NamaDokter);
                        $data =  $this->db->resultSet();
                        foreach ($data as $key) {
                            $this->db->query("UPDATE PerawatanSQL.DBO.AntrianPasien SET JamPraktek=:SessionSenin
                            WHERE no_transaksi=:kodebooking");
                            $this->db->bind('kodebooking', $key['NoBooking']);
                            $this->db->bind('SessionSenin', $SessionSenin);
                            $this->db->execute();
                        }
                    }
                    //insert log perubahan jadwal
                    $logSenin = "INSERT INTO SysLog.dbo.TZ_Log_JadwalDokter
                    (
                     [id]
                    ,[Nama_dokter]
                    ,[Hari]
                    ,[Jam_Sebelum]
                    ,[Jam_Sesudah]
                    ,[SESSION]
                    ,[Kuota_BPJS]
                    ,[Kuota_Non_BPJS]
                    ,[Kuota_Max]
                    ,[UserEdit]
                    ,Jam_Sebelum_BeforeEdit
                    ,Jam_Sesudah_BeforeEdit
                    ,Session_BeforeEdit
                    -- ,Kuota_BPJS_BeforeEdit
                    -- ,Kuota_NonBPJS_BeforeEdit
                    -- ,Kuota_Max_BeforeEdit
                    ,DateEdit
                    )
              VALUES
                  (:IdAuto
                 ,:NamaDokter
                 ,:Senin
                 ,:SeninWaktuAwal
                 ,:SeninWaktuAkhir
                 ,:SessionSenin
                 ,:KuotaBpjsSenin
                 ,:KuotaNonBpjsSenin
                 ,:MaxSenin
                 ,:namauserx
                 ,:Jam_Sebelum_BeforeEdit
                 ,:Jam_Sesudah_BeforeEdit
                 ,:Session_BeforeEdit
                 ,:DateEdit
                )";
                    $this->db->query($logSenin);
                    $this->db->bind('IdAuto', $IdAuto);
                    $this->db->bind('NamaDokter', $NamaDokter);
                    $this->db->bind('Senin', $hari);
                    $this->db->bind('SeninWaktuAwal', $SeninWaktuAwal);
                    $this->db->bind('SeninWaktuAkhir', $SeninWaktuAkhir);
                    $this->db->bind('SessionSenin', $SessionSenin);
                    $this->db->bind('KuotaBpjsSenin', $KuotaBpjsSenin);
                    $this->db->bind('KuotaNonBpjsSenin', $KuotaNonBpjsSenin);
                    $this->db->bind('MaxSenin', $MaxSenin);
                    $this->db->bind('namauserx', $namauserx);

                    $this->db->bind('Jam_Sebelum_BeforeEdit', $data2['Senin_Awal']);
                    $this->db->bind('Jam_Sesudah_BeforeEdit', $data2['Senin_Akhir']);
                    $this->db->bind('Session_BeforeEdit', $data2['Senin_Sesion']);
                    $this->db->bind('DateEdit', $datenowcreate);
                    $this->db->execute();
                }

                // //HARI SELASA
                if ($data2['Status_Aktif'] != $StatusJadwal || $data2['Selasa'] != $SelasaStatus || $data2['Selasa_Awal'] != $SelasaWaktuAwal || $data2['Selasa_Akhir'] != $SelasaWaktuAkhir || $data2['Selasa_Sesion'] != $SessionSelasa) {
                    $hari = 'Tuesday';
                    if ($GroupJadwal == "1") {
                        $this->db->query(" SELECT *FROM PerawatanSQL.DBO.Apointment WHERE NoBooking IN (
                                            select  no_transaksi from PerawatanSQL.DBO.AntrianPasien 
                                            WHERE Doctor_1=:bNamaDokter 
                                            AND replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-') >=:TglKunjungan
                                            AND FORMAT(TglKunjungan, 'dddd')='Tuesday'  
                                        ) and ID_Penjamin=:ID_Penjamin and JenisPembayaran=:JenisPembayaran");
                        $this->db->bind('JenisPembayaran', 'JAMINAN PERUSAHAAN');
                        $this->db->bind('ID_Penjamin', '313');
                        $this->db->bind('TglKunjungan', $dates);
                        $this->db->bind('bNamaDokter', $NamaDokter);
                        $data =  $this->db->resultSet();
                        foreach ($data as $key) {
                            $this->db->query("UPDATE PerawatanSQL.DBO.AntrianPasien SET JamPraktek=:SessionSelasa
                            WHERE no_transaksi=:kodebooking");
                            $this->db->bind('kodebooking', $key['NoBooking']);
                            $this->db->bind('SessionSelasa', $SessionSelasa);
                            $this->db->execute();
                        }
                    } else {
                        $this->db->query(" SELECT *FROM PerawatanSQL.DBO.Apointment WHERE NoBooking IN (
                            select  no_transaksi from PerawatanSQL.DBO.AntrianPasien 
                            WHERE Doctor_1=:bNamaDokter 
                            AND replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-') >=:TglKunjungan
                            AND FORMAT(TglKunjungan, 'dddd')='Tuesday'  
                        ) and ID_Penjamin<>:ID_Penjamin and JenisPembayaran<>:JenisPembayaran");
                        $this->db->bind('JenisPembayaran', 'JAMINAN PERUSAHAAN');
                        $this->db->bind('ID_Penjamin', '313');
                        $this->db->bind('TglKunjungan', $dates);
                        $this->db->bind('bNamaDokter', $NamaDokter);
                        $data =  $this->db->resultSet();
                        foreach ($data as $key) {
                            $this->db->query("UPDATE PerawatanSQL.DBO.AntrianPasien SET JamPraktek=:SessionSelasa
                            WHERE no_transaksi=:kodebooking");
                            $this->db->bind('kodebooking', $key['NoBooking']);
                            $this->db->bind('SessionSelasa', $SessionSelasa);
                            $this->db->execute();
                        }
                    }
                    //insert log perubahan jadwal
                    $this->db->query("INSERT INTO SysLog.dbo.TZ_Log_JadwalDokter
                    (
                    [id]
                    ,[Nama_dokter]
                    ,[Hari]
                    ,[Jam_Sebelum]
                    ,[Jam_Sesudah]
                    ,[SESSION]
                    ,[Kuota_BPJS]
                    ,[Kuota_Non_BPJS]
                    ,[Kuota_Max]
                    ,[UserEdit]
                    ,Jam_Sebelum_BeforeEdit
                    ,Jam_Sesudah_BeforeEdit
                    ,Session_BeforeEdit
                    -- ,Kuota_BPJS_BeforeEdit
                    -- ,Kuota_NonBPJS_BeforeEdit
                    -- ,Kuota_Max_BeforeEdit
                    ,DateEdit
                    )
              VALUES
                 ( :IdAuto
                 ,:NamaDokter
                 ,:Selasa
                 ,:SelasaWaktuAwal
                 ,:SelasaWaktuAkhir
                 ,:SessionSelasa
                 ,:KuotaBpjsSelasa
                 ,:KuotaNonBpjsSelasa
                 ,:MaxSelasa
                 ,:namauserx
                 ,:Jam_Sebelum_BeforeEdit
                 ,:Jam_Sesudah_BeforeEdit
                 ,:Session_BeforeEdit
                 ,:DateEdit
                )");
                    $this->db->bind('IdAuto', $IdAuto);
                    $this->db->bind('NamaDokter', $NamaDokter);
                    $this->db->bind('Selasa', $hari);
                    $this->db->bind('SelasaWaktuAwal', $SelasaWaktuAwal);
                    $this->db->bind('SelasaWaktuAkhir', $SelasaWaktuAkhir);
                    $this->db->bind('SessionSelasa', $SessionSelasa);
                    $this->db->bind('KuotaBpjsSelasa', $KuotaBpjsSelasa);
                    $this->db->bind('KuotaNonBpjsSelasa', $KuotaNonBpjsSelasa);
                    $this->db->bind('MaxSelasa', $MaxSelasa);
                    $this->db->bind('namauserx', $namauserx);
                    $this->db->bind('Jam_Sebelum_BeforeEdit', $data2['Selasa_Awal']);
                    $this->db->bind('Jam_Sesudah_BeforeEdit', $data2['Selasa_Akhir']);
                    $this->db->bind('Session_BeforeEdit', $data2['Selasa_Sesion']);
                    $this->db->bind('DateEdit', $datenowcreate);

                    $this->db->execute();
                }

                // //HARI RABU
                if ($data2['Status_Aktif'] != $StatusJadwal || $data2['Rabu'] != $RabuStatus || $data2['Rabu_Awal'] != $RabuWaktuAwal || $data2['Rabu_Akhir'] != $RabuWaktuAkhir || $data2['Rabu_Sesion'] != $SessionRabu) {
                    $hari = 'Wednesday';
                    if ($GroupJadwal == "1") {
                        $this->db->query(" SELECT *FROM PerawatanSQL.DBO.Apointment WHERE NoBooking IN (
                                            select  no_transaksi from PerawatanSQL.DBO.AntrianPasien 
                                            WHERE Doctor_1=:bNamaDokter 
                                            AND replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-') >=:TglKunjungan
                                            AND FORMAT(TglKunjungan, 'dddd')='Wednesday'  
                                        ) and ID_Penjamin=:ID_Penjamin and JenisPembayaran=:JenisPembayaran");
                        $this->db->bind('JenisPembayaran', 'JAMINAN PERUSAHAAN');
                        $this->db->bind('ID_Penjamin', '313');
                        $this->db->bind('TglKunjungan', $dates);
                        $this->db->bind('bNamaDokter', $NamaDokter);
                        $data =  $this->db->resultSet();
                        foreach ($data as $key) {
                            $this->db->query("UPDATE PerawatanSQL.DBO.AntrianPasien SET JamPraktek=:SessionRabu
                            WHERE no_transaksi=:kodebooking");
                            $this->db->bind('kodebooking', $key['NoBooking']);
                            $this->db->bind('SessionRabu', $SessionRabu);
                            $this->db->execute();
                        }
                    } else {
                        $this->db->query(" SELECT *FROM PerawatanSQL.DBO.Apointment WHERE NoBooking IN (
                            select  no_transaksi from PerawatanSQL.DBO.AntrianPasien 
                            WHERE Doctor_1=:bNamaDokter 
                            AND replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-') >=:TglKunjungan
                            AND FORMAT(TglKunjungan, 'dddd')='Wednesday'  
                        ) and ID_Penjamin<>:ID_Penjamin and JenisPembayaran<>:JenisPembayaran");
                        $this->db->bind('JenisPembayaran', 'JAMINAN PERUSAHAAN');
                        $this->db->bind('ID_Penjamin', '313');
                        $this->db->bind('TglKunjungan', $dates);
                        $this->db->bind('bNamaDokter', $NamaDokter);
                        $data =  $this->db->resultSet();
                        foreach ($data as $key) {
                            $this->db->query("UPDATE PerawatanSQL.DBO.AntrianPasien SET JamPraktek=:SessionRabu
                            WHERE no_transaksi=:kodebooking");
                            $this->db->bind('kodebooking', $key['NoBooking']);
                            $this->db->bind('SessionRabu', $SessionRabu);
                            $this->db->execute();
                        }
                    }
                    //insert log perubahan jadwal
                    $this->db->query("INSERT INTO SysLog.dbo.TZ_Log_JadwalDokter
                    (
                        [id]
                    ,[Nama_dokter]
                    ,[Hari]
                    ,[Jam_Sebelum]
                    ,[Jam_Sesudah]
                    ,[SESSION]
                    ,[Kuota_BPJS]
                    ,[Kuota_Non_BPJS]
                    ,[Kuota_Max]
                    ,[UserEdit]
                    ,Jam_Sebelum_BeforeEdit
                    ,Jam_Sesudah_BeforeEdit
                    ,Session_BeforeEdit
                    -- ,Kuota_BPJS_BeforeEdit
                    -- ,Kuota_NonBPJS_BeforeEdit
                    -- ,Kuota_Max_BeforeEdit
                    ,DateEdit
                    )
              VALUES
               ( :IdAuto
                 ,:NamaDokter
                 ,:Rabu
                 ,:RabuWaktuAwal
                 ,:RabuWaktuAkhir
                 ,:SessionRabu
                 ,:KuotaBpjsRabu
                 ,:KuotaNonBpjsRabu
                 ,:MaxRabu
                 ,:namauserx
                 ,:Jam_Sebelum_BeforeEdit
                 ,:Jam_Sesudah_BeforeEdit
                 ,:Session_BeforeEdit
                 ,:DateEdit
                )");
                    $this->db->bind('IdAuto', $IdAuto);
                    $this->db->bind('NamaDokter', $NamaDokter);
                    $this->db->bind('Rabu', $hari);
                    $this->db->bind('RabuWaktuAwal', $RabuWaktuAwal);
                    $this->db->bind('RabuWaktuAkhir', $RabuWaktuAkhir);
                    $this->db->bind('SessionRabu', $SessionRabu);
                    $this->db->bind('KuotaBpjsRabu', $KuotaBpjsRabu);
                    $this->db->bind('KuotaNonBpjsRabu', $KuotaNonBpjsRabu);
                    $this->db->bind('MaxRabu', $MaxRabu);
                    $this->db->bind('namauserx', $namauserx);
                    $this->db->bind('Jam_Sebelum_BeforeEdit', $data2['Rabu_Awal']);
                    $this->db->bind('Jam_Sesudah_BeforeEdit', $data2['Rabu_Akhir']);
                    $this->db->bind('Session_BeforeEdit', $data2['Rabu_Sesion']);
                    $this->db->bind('DateEdit', $datenowcreate);

                    $this->db->execute();
                }


                // //HARI KAMIS
                if ($data2['Status_Aktif'] != $StatusJadwal || $data2['Kamis'] != $KamisStatus || $data2['Kamis_Awal'] != $KamisWaktuAwal || $data2['Kamis_akhir'] != $KamisWaktuAkhir || $data2['Kamis_Sesion'] != $SessionKamis) {
                    $hari = 'Thursday';

                    if ($GroupJadwal == "1") {
                        $this->db->query(" SELECT *FROM PerawatanSQL.DBO.Apointment WHERE NoBooking IN (
                                            select  no_transaksi from PerawatanSQL.DBO.AntrianPasien 
                                            WHERE Doctor_1=:bNamaDokter 
                                            AND replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-') >=:TglKunjungan
                                            AND FORMAT(TglKunjungan, 'dddd')='Thursday'  
                                        ) and ID_Penjamin=:ID_Penjamin and JenisPembayaran=:JenisPembayaran");
                        $this->db->bind('JenisPembayaran', 'JAMINAN PERUSAHAAN');
                        $this->db->bind('ID_Penjamin', '313');
                        $this->db->bind('TglKunjungan', $dates);
                        $this->db->bind('bNamaDokter', $NamaDokter);
                        $data =  $this->db->resultSet();
                        foreach ($data as $key) {
                            $this->db->query("UPDATE PerawatanSQL.DBO.AntrianPasien SET JamPraktek=:SessionKamis
                            WHERE no_transaksi=:kodebooking");
                            $this->db->bind('kodebooking', $key['NoBooking']);
                            $this->db->bind('SessionKamis', $SessionKamis);
                            $this->db->execute();
                        }
                    } else {
                        $this->db->query(" SELECT *FROM PerawatanSQL.DBO.Apointment WHERE NoBooking IN (
                            select  no_transaksi from PerawatanSQL.DBO.AntrianPasien 
                            WHERE Doctor_1=:bNamaDokter 
                            AND replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-') >=:TglKunjungan
                            AND FORMAT(TglKunjungan, 'dddd')='Thursday'  
                        ) and ID_Penjamin<>:ID_Penjamin and JenisPembayaran<>:JenisPembayaran");
                        $this->db->bind('JenisPembayaran', 'JAMINAN PERUSAHAAN');
                        $this->db->bind('ID_Penjamin', '313');
                        $this->db->bind('TglKunjungan', $dates);
                        $this->db->bind('bNamaDokter', $NamaDokter);
                        $data =  $this->db->resultSet();
                        foreach ($data as $key) {
                            $this->db->query("UPDATE PerawatanSQL.DBO.AntrianPasien SET JamPraktek=:SessionKamis
                            WHERE no_transaksi=:kodebooking");
                            $this->db->bind('kodebooking', $key['NoBooking']);
                            $this->db->bind('SessionKamis', $SessionKamis);
                            $this->db->execute();
                        }
                    }
                    //insert log perubahan jadwal
                    $this->db->query("INSERT INTO SysLog.dbo.TZ_Log_JadwalDokter
                    (
                    [id]
                    ,[Nama_dokter]
                    ,[Hari]
                    ,[Jam_Sebelum]
                    ,[Jam_Sesudah]
                    ,[SESSION]
                    ,[Kuota_BPJS]
                    ,[Kuota_Non_BPJS]
                    ,[Kuota_Max]
                    ,[UserEdit]
                    ,Jam_Sebelum_BeforeEdit
                    ,Jam_Sesudah_BeforeEdit
                    ,Session_BeforeEdit
                    -- ,Kuota_BPJS_BeforeEdit
                    -- ,Kuota_NonBPJS_BeforeEdit
                    -- ,Kuota_Max_BeforeEdit
                    ,DateEdit
                    )
              VALUES
             (:IdAuto
                 ,:NamaDokter
                 ,:Kamis
                 ,:KamisWaktuAwal
                 ,:KamisWaktuAkhir
                 ,:SessionKamis
                 ,:KuotaBpjsKamis
                 ,:KuotaNonBpjsKamis
                 ,:MaxKamis
                 ,:namauserx
                 ,:Jam_Sebelum_BeforeEdit
                 ,:Jam_Sesudah_BeforeEdit
                 ,:Session_BeforeEdit
                 ,:DateEdit
                )");
                    $this->db->bind('IdAuto', $IdAuto);
                    $this->db->bind('NamaDokter', $NamaDokter);
                    $this->db->bind('Kamis', $hari);
                    $this->db->bind('KamisWaktuAwal', $KamisWaktuAwal);
                    $this->db->bind('KamisWaktuAkhir', $KamisWaktuAkhir);
                    $this->db->bind('SessionKamis', $SessionKamis);
                    $this->db->bind('KuotaBpjsKamis', $KuotaBpjsKamis);
                    $this->db->bind('KuotaNonBpjsKamis', $KuotaNonBpjsKamis);
                    $this->db->bind('MaxKamis', $MaxKamis);
                    $this->db->bind('namauserx', $namauserx);
                    $this->db->bind('Jam_Sebelum_BeforeEdit', $data2['Kamis_Awal']);
                    $this->db->bind('Jam_Sesudah_BeforeEdit', $data2['Kamis_akhir']);
                    $this->db->bind('Session_BeforeEdit', $data2['Kamis_Sesion']);
                    $this->db->bind('DateEdit', $datenowcreate);

                    $this->db->execute();
                }

                // //HARI JUMAT
                if ($data2['Status_Aktif'] != $StatusJadwal || $data2['Jumat'] != $JumatStatus || $data2['Jumat_Awal'] != $JumatWaktuAwal || $data2['Jumat_Akhir'] != $JumatWaktuAkhir || $data2['Jumat_Sesion'] != $SessionJumat) {
                    $hari = 'Friday';
                    if ($GroupJadwal == "1") {
                        $this->db->query(" SELECT *FROM PerawatanSQL.DBO.Apointment WHERE NoBooking IN (
                                            select  no_transaksi from PerawatanSQL.DBO.AntrianPasien 
                                            WHERE Doctor_1=:bNamaDokter 
                                            AND replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-') >=:TglKunjungan
                                            AND FORMAT(TglKunjungan, 'dddd')='Friday'  
                                        ) and ID_Penjamin=:ID_Penjamin and JenisPembayaran=:JenisPembayaran");
                        $this->db->bind('JenisPembayaran', 'JAMINAN PERUSAHAAN');
                        $this->db->bind('ID_Penjamin', '313');
                        $this->db->bind('TglKunjungan', $dates);
                        $this->db->bind('bNamaDokter', $NamaDokter);
                        $data =  $this->db->resultSet();
                        foreach ($data as $key) {
                            $this->db->query("UPDATE PerawatanSQL.DBO.AntrianPasien SET JamPraktek=:SessionJumat
                            WHERE no_transaksi=:kodebooking");
                            $this->db->bind('kodebooking', $key['NoBooking']);
                            $this->db->bind('SessionJumat', $SessionJumat);
                            $this->db->execute();
                        }
                    } else {
                        $this->db->query(" SELECT *FROM PerawatanSQL.DBO.Apointment WHERE NoBooking IN (
                            select  no_transaksi from PerawatanSQL.DBO.AntrianPasien 
                            WHERE Doctor_1=:bNamaDokter 
                            AND replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-') >=:TglKunjungan
                            AND FORMAT(TglKunjungan, 'dddd')='Friday'  
                        ) and ID_Penjamin<>:ID_Penjamin and JenisPembayaran<>:JenisPembayaran");
                        $this->db->bind('JenisPembayaran', 'JAMINAN PERUSAHAAN');
                        $this->db->bind('ID_Penjamin', '313');
                        $this->db->bind('TglKunjungan', $dates);
                        $this->db->bind('bNamaDokter', $NamaDokter);
                        $data =  $this->db->resultSet();
                        foreach ($data as $key) {
                            $this->db->query("UPDATE PerawatanSQL.DBO.AntrianPasien SET JamPraktek=:SessionJumat
                            WHERE no_transaksi=:kodebooking");
                            $this->db->bind('kodebooking', $key['NoBooking']);
                            $this->db->bind('SessionJumat', $SessionJumat);
                            $this->db->execute();
                        }
                    }
                    //insert log perubahan jadwal
                    $this->db->query("INSERT INTO SysLog.dbo.TZ_Log_JadwalDokter
                    (
                    [id]
                    ,[Nama_dokter]
                    ,[Hari]
                    ,[Jam_Sebelum]
                    ,[Jam_Sesudah]
                    ,[SESSION]
                    ,[Kuota_BPJS]
                    ,[Kuota_Non_BPJS]
                    ,[Kuota_Max]
                    ,[UserEdit]
                    ,Jam_Sebelum_BeforeEdit
                    ,Jam_Sesudah_BeforeEdit
                    ,Session_BeforeEdit
                    -- ,Kuota_BPJS_BeforeEdit
                    -- ,Kuota_NonBPJS_BeforeEdit
                    -- ,Kuota_Max_BeforeEdit
                    ,DateEdit
                    )
              VALUES
              (:IdAuto
                 ,:NamaDokter
                 ,:Jumat
                 ,:JumatWaktuAwal
                 ,:JumatWaktuAkhir
                 ,:SessionJumat
                 ,:KuotaBpjsJumat
                 ,:KuotaNonBpjsJumat
                 ,:MaxJumat
                 ,:namauserx
                 ,:Jam_Sebelum_BeforeEdit
                 ,:Jam_Sesudah_BeforeEdit
                 ,:Session_BeforeEdit
                 ,:DateEdit
                )");
                    $this->db->bind('IdAuto', $IdAuto);
                    $this->db->bind('NamaDokter', $NamaDokter);
                    $this->db->bind('Jumat', $hari);
                    $this->db->bind('JumatWaktuAwal', $JumatWaktuAwal);
                    $this->db->bind('JumatWaktuAkhir', $JumatWaktuAkhir);
                    $this->db->bind('SessionJumat', $SessionJumat);
                    $this->db->bind('KuotaBpjsJumat', $KuotaBpjsJumat);
                    $this->db->bind('KuotaNonBpjsJumat', $KuotaNonBpjsJumat);
                    $this->db->bind('MaxJumat', $MaxJumat);
                    $this->db->bind('namauserx', $namauserx);
                    $this->db->bind('Jam_Sebelum_BeforeEdit', $data2['Jumat_Awal']);
                    $this->db->bind('Jam_Sesudah_BeforeEdit', $data2['Jumat_Akhir']);
                    $this->db->bind('Session_BeforeEdit', $data2['Jumat_Sesion']);
                    $this->db->bind('DateEdit', $datenowcreate);

                    $this->db->execute();
                }

                // //HARI Sabtu
                if ($data2['Status_Aktif'] != $StatusJadwal || $data2['Sabtu'] != $SabtuStatus || $data2['Sabtu_Awal'] != $SabtuWaktuAwal || $data2['Sabtu_Akhir'] != $SabtuWaktuAkhir || $data2['Sabtu_Sesion'] != $SessionSabtu) {
                    $hari = 'Saturday';
                    if ($GroupJadwal == "1") {
                        $this->db->query(" SELECT *FROM PerawatanSQL.DBO.Apointment WHERE NoBooking IN (
                                            select  no_transaksi from PerawatanSQL.DBO.AntrianPasien 
                                            WHERE Doctor_1=:bNamaDokter 
                                            AND replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-') >=:TglKunjungan
                                            AND FORMAT(TglKunjungan, 'dddd')='Saturday'  
                                        ) and ID_Penjamin=:ID_Penjamin and JenisPembayaran=:JenisPembayaran");
                        $this->db->bind('JenisPembayaran', 'JAMINAN PERUSAHAAN');
                        $this->db->bind('ID_Penjamin', '313');
                        $this->db->bind('TglKunjungan', $dates);
                        $this->db->bind('bNamaDokter', $NamaDokter);
                        $data =  $this->db->resultSet();
                        foreach ($data as $key) {
                            $this->db->query("UPDATE PerawatanSQL.DBO.AntrianPasien SET JamPraktek=:SessionSabtu
                            WHERE no_transaksi=:kodebooking");
                            $this->db->bind('kodebooking', $key['NoBooking']);
                            $this->db->bind('SessionSabtu', $SessionSabtu);
                            $this->db->execute();
                        }
                    } else {
                        $this->db->query(" SELECT *FROM PerawatanSQL.DBO.Apointment WHERE NoBooking IN (
                            select  no_transaksi from PerawatanSQL.DBO.AntrianPasien 
                            WHERE Doctor_1=:bNamaDokter 
                            AND replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-') >=:TglKunjungan
                            AND FORMAT(TglKunjungan, 'dddd')='Saturday'  
                        ) and ID_Penjamin<>:ID_Penjamin and JenisPembayaran<>:JenisPembayaran");
                        $this->db->bind('JenisPembayaran', 'JAMINAN PERUSAHAAN');
                        $this->db->bind('ID_Penjamin', '313');
                        $this->db->bind('TglKunjungan', $dates);
                        $this->db->bind('bNamaDokter', $NamaDokter);
                        $data =  $this->db->resultSet();
                        foreach ($data as $key) {
                            $this->db->query("UPDATE PerawatanSQL.DBO.AntrianPasien SET JamPraktek=:SessionSabtu
                            WHERE no_transaksi=:kodebooking");
                            $this->db->bind('kodebooking', $key['NoBooking']);
                            $this->db->bind('SessionSabtu', $SessionSabtu);
                            $this->db->execute();
                        }
                    }
                    //insert log perubahan jadwal
                    $this->db->query("INSERT INTO SysLog.dbo.TZ_Log_JadwalDokter
                    (
                        [id]
                    ,[Nama_dokter]
                    ,[Hari]
                    ,[Jam_Sebelum]
                    ,[Jam_Sesudah]
                    ,[SESSION]
                    ,[Kuota_BPJS]
                    ,[Kuota_Non_BPJS]
                    ,[Kuota_Max]
                    ,[UserEdit]
                    ,Jam_Sebelum_BeforeEdit
                    ,Jam_Sesudah_BeforeEdit
                    ,Session_BeforeEdit
                    -- ,Kuota_BPJS_BeforeEdit
                    -- ,Kuota_NonBPJS_BeforeEdit
                    -- ,Kuota_Max_BeforeEdit
                    ,DateEdit
                    )
              VALUES
              ( :IdAuto
                 ,:NamaDokter
                 ,:Sabtu
                 ,:SabtuWaktuAwal
                 ,:SabtuWaktuAkhir
                 ,:SessionSabtu
                 ,:KuotaBpjsSabtu
                 ,:KuotaNonBpjsSabtu
                 ,:MaxSabtu
                 ,:namauserx
                 ,:Jam_Sebelum_BeforeEdit
                 ,:Jam_Sesudah_BeforeEdit
                 ,:Session_BeforeEdit
                 ,:DateEdit
                )");
                    $this->db->bind('IdAuto', $IdAuto);
                    $this->db->bind('NamaDokter', $NamaDokter);
                    $this->db->bind('Sabtu', $hari);
                    $this->db->bind('SabtuWaktuAwal', $SabtuWaktuAwal);
                    $this->db->bind('SabtuWaktuAkhir', $SabtuWaktuAkhir);
                    $this->db->bind('SessionSabtu', $SessionSabtu);
                    $this->db->bind('KuotaBpjsSabtu', $KuotaBpjsSabtu);
                    $this->db->bind('KuotaNonBpjsSabtu', $KuotaNonBpjsSabtu);
                    $this->db->bind('MaxSabtu', $MaxSabtu);
                    $this->db->bind('namauserx', $namauserx);
                    $this->db->bind('Jam_Sebelum_BeforeEdit', $data2['Sabtu_Awal']);
                    $this->db->bind('Jam_Sesudah_BeforeEdit', $data2['Sabtu_Akhir']);
                    $this->db->bind('Session_BeforeEdit', $data2['Sabtu_Sesion']);
                    $this->db->bind('DateEdit', $datenowcreate);

                    $this->db->execute();
                }

                // //HARI Minggu
                if ($data2['Status_Aktif'] != $StatusJadwal || $data2['Minggu'] != $MingguStatus || $data2['Minggu_Awal'] != $MingguWaktuAwal || $data2['Minggu_Akhir'] != $MingguWaktuAkhir || $data2['Minggu_Sesion'] != $SessionMinggu) {
                    $hari = 'Sunday';
                    if ($GroupJadwal == "1") {
                        $this->db->query(" SELECT *FROM PerawatanSQL.DBO.Apointment WHERE NoBooking IN (
                                            select  no_transaksi from PerawatanSQL.DBO.AntrianPasien 
                                            WHERE Doctor_1=:bNamaDokter 
                                            AND replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-') >=:TglKunjungan
                                            AND FORMAT(TglKunjungan, 'dddd')='Sunday'  
                                        ) and ID_Penjamin=:ID_Penjamin and JenisPembayaran=:JenisPembayaran");
                        $this->db->bind('JenisPembayaran', 'JAMINAN PERUSAHAAN');
                        $this->db->bind('ID_Penjamin', '313');
                        $this->db->bind('TglKunjungan', $dates);
                        $this->db->bind('bNamaDokter', $NamaDokter);
                        $data =  $this->db->resultSet();
                        foreach ($data as $key) {
                            $this->db->query("UPDATE PerawatanSQL.DBO.AntrianPasien SET JamPraktek=:SessionMinggu
                            WHERE no_transaksi=:kodebooking");
                            $this->db->bind('kodebooking', $key['NoBooking']);
                            $this->db->bind('SessionMinggu', $SessionMinggu);
                            $this->db->execute();
                        }
                    } else {
                        $this->db->query(" SELECT *FROM PerawatanSQL.DBO.Apointment WHERE NoBooking IN (
                            select  no_transaksi from PerawatanSQL.DBO.AntrianPasien 
                            WHERE Doctor_1=:bNamaDokter 
                            AND replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-') >=:TglKunjungan
                            AND FORMAT(TglKunjungan, 'dddd')='Sunday'  
                        ) and ID_Penjamin<>:ID_Penjamin and JenisPembayaran<>:JenisPembayaran");
                        $this->db->bind('JenisPembayaran', 'JAMINAN PERUSAHAAN');
                        $this->db->bind('ID_Penjamin', '313');
                        $this->db->bind('TglKunjungan', $dates);
                        $this->db->bind('bNamaDokter', $NamaDokter);
                        $data =  $this->db->resultSet();
                        foreach ($data as $key) {
                            $this->db->query("UPDATE PerawatanSQL.DBO.AntrianPasien SET JamPraktek=:SessionMinggu
                            WHERE no_transaksi=:kodebooking");
                            $this->db->bind('kodebooking', $key['NoBooking']);
                            $this->db->bind('SessionMinggu', $SessionMinggu);
                            $this->db->execute();
                        }
                    }
                    //insert log perubahan jadwal

                    $log = "INSERT INTO SysLog.dbo.TZ_Log_JadwalDokter
                    (
                        [id]
                    ,[Nama_dokter]
                    ,[Hari]
                    ,[Jam_Sebelum]
                    ,[Jam_Sesudah]
                    ,[SESSION]
                    ,[Kuota_BPJS]
                    ,[Kuota_Non_BPJS]
                    ,[Kuota_Max]
                    ,[UserEdit]
                    ,Jam_Sebelum_BeforeEdit
                    ,Jam_Sesudah_BeforeEdit
                    ,Session_BeforeEdit
                    -- ,Kuota_BPJS_BeforeEdit
                    -- ,Kuota_NonBPJS_BeforeEdit
                    -- ,Kuota_Max_BeforeEdit
                    ,DateEdit
                    )
              VALUES
                ( 
                    :IdAuto
                 ,:NamaDokter
                 ,:Minggu
                 ,:MingguWaktuAwal
                 ,:MingguWaktuAkhir
                 ,:SessionMinggu
                 ,:KuotaBpjsMinggu
                 ,:KuotaNonBpjsMinggu
                 ,:MaxMinggu
                 ,:namauserx
                 ,:Jam_Sebelum_BeforeEdit
                 ,:Jam_Sesudah_BeforeEdit
                 ,:Session_BeforeEdit
                 ,:DateEdit
                )";
                    $this->db->query($log);
                    $this->db->bind('IdAuto', $IdAuto);
                    $this->db->bind('NamaDokter', $NamaDokter);
                    $this->db->bind('Minggu', $hari);
                    $this->db->bind('MingguWaktuAwal', $MingguWaktuAwal);
                    $this->db->bind('MingguWaktuAkhir', $MingguWaktuAkhir);
                    $this->db->bind('SessionMinggu', $SessionMinggu);
                    $this->db->bind('KuotaBpjsMinggu', $KuotaBpjsMinggu);
                    $this->db->bind('KuotaNonBpjsMinggu', $KuotaNonBpjsMinggu);
                    $this->db->bind('MaxMinggu', $MaxMinggu);
                    $this->db->bind('namauserx', $namauserx);
                    $this->db->bind('Jam_Sebelum_BeforeEdit', $data2['Minggu_Awal']);
                    $this->db->bind('Jam_Sesudah_BeforeEdit', $data2['Minggu_Akhir']);
                    $this->db->bind('Session_BeforeEdit', $data2['Minggu_Sesion']);
                    $this->db->bind('DateEdit', $datenowcreate);


                    $this->db->execute();
                }
                //alim
                $this->db->query("UPDATE MasterdataSQL.dbo.JadwalPraktek set  
                        IDDokter=:NamaDokter,IDUnit=:GrupPerawatan,Status_Aktif=:Status_Aktif,Senin=:SeninStatus,Senin_waktu=:seninwaktumix,Senin_Sesion=:SessionSenin,
                  Selasa=:SelasaStatus,Selasa_waktu=:selasawaktumix,Selasa_Sesion=:SessionSelasa, Rabu=:RabuStatus,Rabu_waktu=:rabuwaktumix,Rabu_Sesion=:SessionRabu,
                  Kamis=:KamisStatus,Kamis_waktu=:kamiswaktumix,Kamis_Sesion=:SessionKamis,Jumat=:JumatStatus,Jumat_waktu=:jumatwaktumix,Jumat_Sesion=:SessionJumat,
                  Sabtu=:SabtuStatus,Sabtu_waktu=:sabtuwaktumix,Sabtu_Sesion=:SessionSabtu,Minggu=:MingguStatus,Minggu_waktu=:mingguwaktumix,Minggu_Sesion=:SessionMinggu,Note=:Note,
                  Senin_Awal=:SeninWaktuAwal,Senin_Akhir=:SeninWaktuAkhir,Selasa_Awal=:SelasaWaktuAwal,Selasa_Akhir=:SelasaWaktuAkhir, Rabu_Awal=:RabuWaktuAwal,Rabu_Akhir=:RabuWaktuAkhir,Kamis_Awal=:KamisWaktuAwal,Kamis_Akhir=:KamisWaktuAkhir,
                  Jumat_Awal=:JumatWaktuAwal,Jumat_Akhir=:JumatWaktuAkhir,Sabtu_Awal=:SabtuWaktuAwal,Sabtu_Akhir=:SabtuWaktuAkhir,Minggu_Awal=:MingguWaktuAwal,Minggu_Akhir=:MingguWaktuAkhir,
                  Senin_Max=:MaxSenin,Selasa_Max=:MaxSelasa,Rabu_Max=:MaxRabu,Kamis_Max=:MaxKamis, Jumat_Max=:MaxJumat,Sabtu_Max=:MaxSabtu,Minggu_Max=:MaxMinggu,NamaDokter=:First_Name,Poli=:NamaUnit
                  ,Senin_Max_JKN=:KuotaBpjsSenin
                  ,Senin_Max_NonJKN=:KuotaNonBpjsSenin
                  ,Selasa_Max_JKN=:KuotaBpjsSelasa
                  ,Selasa_Max_NonJKN=:KuotaNonBpjsSelasa
                  ,Rabu_Max_JKN=:KuotaBpjsRabu
                  ,Rabu_Max_NonJKN=:KuotaNonBpjsRabu
                  ,Kamis_Max_JKN=:KuotaBpjsKamis
                  ,Kamis_Max_NonJKN=:KuotaNonBpjsKamis
                  ,Jumat_Max_JKN=:KuotaBpjsJumat
                  ,Jumat_Max_NonJKN=:KuotaNonBpjsJumat
                  ,Sabtu_Max_JKN=:KuotaBpjsSabtu
                  ,Sabtu_Max_NonJKN=:KuotaNonBpjsSabtu
                  ,Minggu_Max_JKN=:KuotaBpjsMinggu
                  ,Minggu_Max_NonJKN=:KuotaNonBpjsMinggu,Group_Jadwal=:Group_Jadwal
                            WHERE ID=:IdAuto");
                $this->db->bind('IdAuto', $IdAuto);
            }
            $this->db->bind('Status_Aktif', $StatusJadwal);
            $this->db->bind('SeninStatus', $SeninStatus);
            $this->db->bind('SeninWaktuAwal', $SeninWaktuAwal);
            $this->db->bind('SeninWaktuAkhir', $SeninWaktuAkhir);
            $this->db->bind('SessionSenin', $SessionSenin);
            $this->db->bind('SelasaStatus', $SelasaStatus);
            $this->db->bind('SelasaWaktuAwal', $SelasaWaktuAwal);
            $this->db->bind('SelasaWaktuAkhir', $SelasaWaktuAkhir);
            $this->db->bind('SessionSelasa', $SessionSelasa);
            $this->db->bind('RabuStatus', $RabuStatus);
            $this->db->bind('RabuWaktuAwal', $RabuWaktuAwal);
            $this->db->bind('RabuWaktuAkhir', $RabuWaktuAkhir);
            $this->db->bind('SessionRabu', $SessionRabu);
            $this->db->bind('KamisStatus', $KamisStatus);
            $this->db->bind('KamisWaktuAwal', $KamisWaktuAwal);
            $this->db->bind('KamisWaktuAkhir', $KamisWaktuAkhir);
            $this->db->bind('SessionKamis', $SessionKamis);
            $this->db->bind('JumatStatus', $JumatStatus);
            $this->db->bind('JumatWaktuAwal', $JumatWaktuAwal);
            $this->db->bind('JumatWaktuAkhir', $JumatWaktuAkhir);
            $this->db->bind('SessionJumat', $SessionJumat);
            $this->db->bind('SabtuStatus', $SabtuStatus);
            $this->db->bind('SabtuWaktuAwal', $SabtuWaktuAwal);
            $this->db->bind('SabtuWaktuAkhir', $SabtuWaktuAkhir);
            $this->db->bind('SessionSabtu', $SessionSabtu);
            $this->db->bind('MingguStatus', $MingguStatus);
            $this->db->bind('MingguWaktuAwal', $MingguWaktuAwal);
            $this->db->bind('MingguWaktuAkhir', $MingguWaktuAkhir);
            $this->db->bind('SessionMinggu', $SessionMinggu);
            $this->db->bind('MaxSenin', $MaxSenin);
            $this->db->bind('MaxSelasa', $MaxSelasa);
            $this->db->bind('MaxRabu', $MaxRabu);
            $this->db->bind('MaxKamis', $MaxKamis);
            $this->db->bind('MaxJumat', $MaxJumat);
            $this->db->bind('MaxSabtu', $MaxSabtu);
            $this->db->bind('MaxMinggu', $MaxMinggu);
            $this->db->bind('Note', $Note);
            $this->db->bind('GrupPerawatan', $GrupPerawatan);
            $this->db->bind('NamaDokter', $NamaDokter);
            $this->db->bind('Status_Aktif', $StatusJadwal);
            $this->db->bind('NamaUnit', $NamaUnit);
            $this->db->bind('First_Name', $First_Name);
            $this->db->bind('seninwaktumix', $seninwaktumix);
            $this->db->bind('selasawaktumix', $selasawaktumix);
            $this->db->bind('rabuwaktumix', $rabuwaktumix);
            $this->db->bind('kamiswaktumix', $kamiswaktumix);
            $this->db->bind('jumatwaktumix', $jumatwaktumix);
            $this->db->bind('sabtuwaktumix', $sabtuwaktumix);
            $this->db->bind('mingguwaktumix', $mingguwaktumix);

            $this->db->bind('KuotaBpjsSenin', $KuotaBpjsSenin);
            $this->db->bind('KuotaNonBpjsSenin', $KuotaNonBpjsSenin);
            $this->db->bind('KuotaBpjsSelasa', $KuotaBpjsSelasa);
            $this->db->bind('KuotaNonBpjsSelasa', $KuotaNonBpjsSelasa);
            $this->db->bind('KuotaBpjsRabu', $KuotaBpjsRabu);
            $this->db->bind('KuotaNonBpjsRabu', $KuotaNonBpjsRabu);
            $this->db->bind('KuotaBpjsKamis', $KuotaBpjsKamis);
            $this->db->bind('KuotaNonBpjsKamis', $KuotaNonBpjsKamis);
            $this->db->bind('KuotaBpjsJumat', $KuotaBpjsJumat);
            $this->db->bind('KuotaNonBpjsJumat', $KuotaNonBpjsJumat);
            $this->db->bind('KuotaBpjsSabtu', $KuotaBpjsSabtu);
            $this->db->bind('KuotaNonBpjsSabtu', $KuotaNonBpjsSabtu);
            $this->db->bind('KuotaBpjsMinggu', $KuotaBpjsMinggu);
            $this->db->bind('KuotaNonBpjsMinggu', $KuotaNonBpjsMinggu);
            $this->db->bind('Group_Jadwal', $GroupJadwal);

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
    public function getJadwalDokterId($id)
    {
        try {
            $this->db->query("SELECT  Group_Jadwal  
                                      AS Group_Jadwal_fix, Status_Aktif AS Status_Aktif_fix,
                            * FROM MasterdataSQL.dbo.JadwalPraktek
                            WHERE ID=:id");
            $this->db->bind('id', $id);
            $data =  $this->db->single();
            $passing['ID'] = $data['ID'];
            $passing['Group_Jadwal_fix'] = $data['Group_Jadwal_fix'];
            $passing['IDDokter'] = $data['IDDokter'];
            $passing['IDUnit'] = $data['IDUnit'];
            $passing['Status_Aktif_fix'] = $data['Status_Aktif_fix'];
            $passing['Senin'] = $data['Senin'];
            $passing['Senin_Waktu'] = $data['Senin_Waktu'];
            $passing['Selasa'] = $data['Selasa'];
            $passing['Selasa_Waktu'] = $data['Selasa_Waktu'];
            $passing['Rabu'] = $data['Rabu'];
            $passing['Rabu_Waktu'] = $data['Rabu_Waktu'];
            $passing['Kamis'] = $data['Kamis'];
            $passing['Kamis_Waktu'] = $data['Kamis_Waktu'];
            $passing['Jumat'] = $data['Jumat'];
            $passing['Jumat_Waktu'] = $data['Jumat_Waktu'];
            $passing['Sabtu'] = $data['Sabtu'];
            $passing['Sabtu_Waktu'] = $data['Sabtu_Waktu'];
            $passing['Minggu'] = $data['Minggu'];
            $passing['Minggu_Waktu'] = $data['Minggu_Waktu'];
            $passing['Note'] = $data['Note'];
            $passing['IDUnit'] = $data['IDUnit'];
            $passing['Senin_Sesion'] = $data['Senin_Sesion'];
            $passing['Selasa_Sesion'] = $data['Selasa_Sesion'];
            $passing['Rabu_Sesion'] = $data['Rabu_Sesion'];
            $passing['Kamis_Sesion'] = $data['Kamis_Sesion'];
            $passing['Jumat_Sesion'] = $data['Jumat_Sesion'];
            $passing['Sabtu_Sesion'] = $data['Sabtu_Sesion'];
            $passing['Minggu_Sesion'] = $data['Minggu_Sesion'];
            $passing['Senin_Awal'] = $data['Senin_Awal'];
            $passing['Senin_Akhir'] = $data['Senin_Akhir'];
            $passing['Selasa_Awal'] = $data['Selasa_Awal'];
            $passing['Selasa_Akhir'] = $data['Selasa_Akhir'];
            $passing['Rabu_Awal'] = $data['Rabu_Awal'];
            $passing['Rabu_Akhir'] = $data['Rabu_Akhir'];
            $passing['Kamis_Awal'] = $data['Kamis_Awal'];
            $passing['Kamis_Akhir'] = $data['Kamis_akhir'];
            $passing['Jumat_Awal'] = $data['Jumat_Awal'];
            $passing['Jumat_Akhir'] = $data['Jumat_Akhir'];
            $passing['Sabtu_Awal'] = $data['Sabtu_Awal'];
            $passing['Sabtu_Akhir'] = $data['Sabtu_Akhir'];
            $passing['Minggu_Awal'] = $data['Minggu_Awal'];
            $passing['Minggu_Akhir'] = $data['Minggu_Akhir'];
            $passing['Senin_Max'] = $data['Senin_Max'];
            $passing['Selasa_Max'] = $data['Selasa_Max'];
            $passing['Rabu_Max'] = $data['Rabu_Max'];
            $passing['Kamis_Max'] = $data['Kamis_Max'];
            $passing['Jumat_Max'] = $data['Jumat_Max'];
            $passing['Sabtu_Max'] = $data['Sabtu_Max'];
            $passing['Minggu_Max'] = $data['Minggu_Max'];

            $passing['Senin_Max_JKN'] = $data['Senin_Max_JKN'];
            $passing['Senin_Max_NonJKN'] = $data['Senin_Max_NonJKN'];
            $passing['Selasa_Max_JKN'] = $data['Selasa_Max_JKN'];
            $passing['Selasa_Max_NonJKN'] = $data['Selasa_Max_NonJKN'];
            $passing['Rabu_Max_JKN'] = $data['Rabu_Max_JKN'];
            $passing['Rabu_Max_NonJKN'] = $data['Rabu_Max_NonJKN'];
            $passing['Kamis_Max_JKN'] = $data['Kamis_Max_JKN'];
            $passing['Kamis_Max_NonJKN'] = $data['Kamis_Max_NonJKN'];
            $passing['Jumat_Max_JKN'] = $data['Jumat_Max_JKN'];
            $passing['Jumat_Max_NonJKN'] = $data['Jumat_Max_NonJKN'];
            $passing['Sabtu_Max_JKN'] = $data['Sabtu_Max_JKN'];
            $passing['Sabtu_Max_NonJKN'] = $data['Sabtu_Max_NonJKN'];
            $passing['Minggu_Max_JKN'] = $data['Minggu_Max_JKN'];
            $passing['Minggu_Max_NonJKN'] = $data['Minggu_Max_NonJKN'];

            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $passing
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

    public function getIDDokter($idpoli)
    {
        try {
            $this->db->query("SELECT a.ID, First_Name
                                  from MasterdataSQL.dbo.Doctors a
                                  inner join MasterdataSQL.dbo.Doctors_2 b on a.ID=b.IdDoctors
                                   where active='1' and b.IdLayanan=:idpoli");
            $this->db->bind('idpoli', $idpoli);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['First_Name'] = $key['First_Name'];
                $rows[] = $pasing;
            }
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $rows
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

    public function getSession($jam)
    {

        $this->db->query("SELECT NamaSesion
                  from MasterdataSQL.DBO.JadwalPraktekSesion where :jam between Jam_Awal and Jam_Akhir");
        $this->db->bind('jam', $jam);
        $data =  $this->db->single();
        $passing['NamaSesion'] = $data['NamaSesion'];

        return $passing;
    }
    public function getShift()
    {
        try {

            $time = Utils::getCurrentTime();
            $this->db->query("SELECT *
                  from MasterdataSQL.DBO.JadwalPraktekSesion where :time between Jam_Awal and Jam_Akhir");
            $this->db->bind('time', $time);
            $data =  $this->db->single();

            $callback = array(
                'status' => 'success', // Set array status dengan success    
                'NamaSesion' => $data['NamaSesion'], // Set array status dengan success     
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

    public function getJamDokterPraktekRegistrasi($data)
    {

        try {

            if ($data['hari'] === "Minggu") {
                $quser = "SELECT C.ID,A.First_Name, c.Status_aktif as Status_aktif
                ,c.Minggu as Hari,c.Minggu_Waktu as HariWaktu,c.Minggu_Sesion as HariSession,c.Note
                from MasterdataSQL.dbo.Doctors A
              --  INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
                inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
                WHERE A.active='1' AND c.IDUnit=:layanan AND c.Minggu='1' and C.IDDokter=:iddokter and c.Group_Jadwal=:groupjadwal and c.Status_Aktif='1' ";
            } elseif ($data['hari'] === "Senin") {
                $quser = "SELECT C.ID,A.First_Name,c.Status_aktif as Status_aktif,
                c.Senin as Hari,c.Senin_Waktu as HariWaktu,c.Senin_Sesion as HariSession,c.Note
                from MasterdataSQL.dbo.Doctors A
               -- INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
                inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
                WHERE A.active='1' AND c.IDUnit=:layanan AND c.Senin='1' and C.IDDokter=:iddokter and c.Group_Jadwal=:groupjadwal and c.Status_Aktif='1' ";
            } elseif ($data['hari'] === "Selasa") {
                $quser = "SELECT C.ID,A.First_Name, c.Status_aktif as Status_aktif,
                c.Selasa as Hari,c.Selasa_Waktu as HariWaktu,c.Selasa_Sesion as HariSession,c.Note
                from MasterdataSQL.dbo.Doctors A
               -- INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
                inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
                WHERE A.active='1' AND c.IDUnit=:layanan AND c.Selasa='1' and C.IDDokter=:iddokter and c.Group_Jadwal=:groupjadwal and c.Status_Aktif='1'";
            } elseif ($data['hari'] === "Rabu") {
                $quser = "SELECT C.ID,A.First_Name,c.Status_aktif as Status_aktif,
                c.Rabu as Hari,c.Rabu_Waktu as HariWaktu,c.Rabu_Sesion as HariSession,c.Note
                from MasterdataSQL.dbo.Doctors A
             --   INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
                inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
                WHERE A.active='1' AND c.IDUnit=:layanan AND c.Rabu='1' and C.IDDokter=:iddokter and c.Group_Jadwal=:groupjadwal and c.Status_Aktif='1'";
            } elseif ($data['hari'] === "Kamis") {
                $quser = "SELECT C.ID,A.First_Name,c.Status_aktif as Status_aktif,
                c.Kamis as Hari,c.Kamis_Waktu as HariWaktu,c.Kamis_Sesion as HariSession,c.Note
                from MasterdataSQL.dbo.Doctors A
              --  INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
                inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
                WHERE A.active='1' AND c.IDUnit=:layanan AND c.Kamis='1' and C.IDDokter=:iddokter and c.Group_Jadwal=:groupjadwal and c.Status_Aktif='1'";
            } elseif ($data['hari'] === "Jumat") {
                $quser = "SELECT C.ID,A.First_Name,c.Status_aktif as Status_aktif,
                c.Jumat as Hari,c.Jumat_Waktu as HariWaktu,c.Jumat_Sesion as HariSession,c.Note
                from MasterdataSQL.dbo.Doctors A
               -- INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
                inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
                WHERE A.active='1' AND c.IDUnit=:layanan AND c.Jumat='1' and C.IDDokter=:iddokter and c.Group_Jadwal=:groupjadwal and c.Status_Aktif='1'";
            } elseif ($data['hari'] === "Sabtu") {
                $quser = "SELECT C.ID,A.First_Name,c.Status_aktif as Status_aktif,
                c.Sabtu as Hari,c.Sabtu_Waktu as HariWaktu,c.Sabtu_Sesion as HariSession,c.Note
                from MasterdataSQL.dbo.Doctors A
                --INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
                inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
                WHERE A.active='1' AND c.IDUnit=:layanan AND c.Sabtu='1' and C.IDDokter=:iddokter and c.Group_Jadwal=:groupjadwal and c.Status_Aktif='1'";
            }
            $this->db->query($quser);
            $this->db->bind('layanan', $data['idlayanan']);
            $this->db->bind('iddokter', $data['iddokter']);
            // $this->db->bind('Status_aktif', $data['Status_aktif']);
            $this->db->bind('groupjadwal', $data['groupjadwal']);
            $this->db->execute();
            $data = $this->db->resultSet();
            $rows = array();

            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['HariWaktu'] = $key['HariWaktu'];
                $rows[] = $pasing;
            }
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $rows
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

    public function getNamaSessionDokter($data)
    {
        try {

            $this->db->query("SELECT $data[hari] as NamaSesion
                  from MasterdataSQL.DBO.JadwalPraktek where ID=:idjampraktek");
            //$this->db->bind('hari', $data['hari']); 
            $this->db->bind('idjampraktek', $data['idjampraktek']);
            $data =  $this->db->single();

            $callback = array(
                'status' => 'success', // Set array status dengan success    
                'NamaSesion' => $data['NamaSesion'], // Set array status dengan success     
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
}
