<?php
class B_create_Registrasi_Rajal
{
    use SatuSehat;
    use SatuSehatEncounter;
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function VoidRegistrasi($data)
    {
        try {
            $this->db->transaksi();
            $datenowcreate = Utils::seCurrentDateTime();
            $noregbatal = $data['noregbatal']; // ok
            $alasanbatal = $data['alasanbatal']; // ok
            // TRIGER SEBELUM SIMPAN DATA
            // 1. TRIGER PASIEN JIKA JENIS BELUM DIISI  
            if ($noregbatal == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. Registrasi Kosong !',
                );
                echo json_encode($callback);
                exit;
            }
            // 1. TRIGER PASIEN JIKA ALASAN
            if ($alasanbatal == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Alasan Batal kosong !',
                );
                echo json_encode($callback);
                exit;
            }
            // cek sudah ada emr belum
            // $this->db->query("SELECT *from MedicalRecord.dbo.EMR_RWJ where NoRegistrasi=:noregbatal");
            // $this->db->bind('noregbatal', $noregbatal);
            // $data =  $this->db->single();
            // if ($data) {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => 'Registrasi Sudah ada Assesment Dokter, anda tidak bisa membatalkan !',
            //     );
            //     return $callback;
            //     exit;
            // }
            // cek sudah ada billing aktif kah 
            $this->db->query("SELECT *FROM PerawatanSQL.DBO.[Visit Details] 
                            WHERE NoRegistrasi=:noregbatal and KategoriTarif<>'Administrasi'");
            $this->db->bind('noregbatal', $noregbatal);
            $data =  $this->db->single();
            if ($data) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Registrasi Sudah ada Billing Selain Administrasi, Batalkan Dahulu Semua Billing !',
                );
                return $callback;
                exit;
            }
            // cek sudah ada billing aktif kah
            $this->db->query("SELECT *FROM Billing_Pasien.DBO.FO_T_BILLING_1 
                            WHERE NO_REGISTRASI=:noregbatal and BATAL='0' and GROUP_ENTRI<>'KARCIS'");
            $this->db->bind('noregbatal', $noregbatal);
            $data =  $this->db->single();
            if ($data) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Registrasi Sudah ada Billing Selain Administrasi, Batalkan Dahulu Semua Billing !',
                );
                return $callback;
                exit;
            }
            // cek sudah ada payment belum
            $this->db->query("SELECT Id FROM  PerawatanSQL.dbo.payments 
                            WHERE NoRegistrasi=:noregbatal ");
            $this->db->bind('noregbatal', $noregbatal);
            $data =  $this->db->single();
            if ($data) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Simpan Gagal! No Registrasi Ini Sudah Memiliki Payment!',
                );
                return $callback;
                exit;
            }
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            //UPDATE
            $isBatal = "1";
            $isDatangFalse = "0";
            $isBatalstatus = "4";
            $this->db->query("UPDATE perawatanSQL.dbo.Visit SET 
            Batal=:isBatal, 
            PetugasBatal=:namauserx,tglBatal=:datenowcreate,[Status ID]=:isBatalstatus
            WHERE NoRegistrasi=:noregbatal");
            $this->db->bind('isBatal', $isBatal);
            $this->db->bind('namauserx', $namauserx);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('isBatalstatus', $isBatalstatus);
            $this->db->bind('noregbatal', $noregbatal);
            $this->db->execute();

            $this->db->query("UPDATE  PerawatanSQL.dbo.Apointment 
                                SET Datang=:isDatangFalse, NoRegistrasi=null
                                where NoRegistrasi=:noregbatal");
            $this->db->bind('isDatangFalse', $isDatangFalse);
            $this->db->bind('noregbatal', $noregbatal);
            $this->db->execute();

            $this->db->query("INSERT INTO  SysLog.dbo.TZ_Log_Button 
                        (noregistrasi,petugas_batal,tgl_batal,alasan_batal) VALUES
                        (:noregbatal,:userid,:datenowcreate,:alasanbatal)");
            $this->db->bind('noregbatal', $noregbatal);
            $this->db->bind('userid', $userid);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('alasanbatal', $alasanbatal);
            $this->db->execute();

            //update flag batal ke tabel AntrianPasien
            $this->db->query("UPDATE PerawatanSQL.dbo.AntrianPasien SET 
            batal=:isBatal
            WHERE no_transaksi=:noregbatal");
            $this->db->bind('isBatal', $isBatal);
            $this->db->bind('noregbatal', $noregbatal);
            $this->db->execute();

            //update flag batal 1 ke tabel billing

            //fo_t_billing
            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING SET 
            BATAL=:isBatal, 
            PETUGAS_BATAL=:namauserx,JAM_BATAL=:datenowcreate,FB_VERIF_JURNAL='0'
            WHERE NO_REGISTRASI=:noregbatal");
            $this->db->bind('isBatal', $isBatal);
            $this->db->bind('namauserx', $namauserx);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('noregbatal', $noregbatal);
            $this->db->execute();

            //fo_t_billing_1
            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 SET 
            BATAL=:isBatal, 
            PETUGAS_BATAL=:namauserx,JAM_BATAL=:datenowcreate
            WHERE NO_REGISTRASI=:noregbatal");
            $this->db->bind('isBatal', $isBatal);
            $this->db->bind('namauserx', $namauserx);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('noregbatal', $noregbatal);
            $this->db->execute();

            //fo_t_billing_2
            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_2 SET 
            BATAL=:isBatal, 
            PETUGAS_BATAL=:namauserx,JAM_BATAL=:datenowcreate
            FROM Billing_Pasien.dbo.FO_T_BILLING_2 a
            inner join Billing_Pasien.dbo.FO_T_BILLING_1 b on a.NO_TRS_BILLING=b.NO_TRS_BILLING
            WHERE b.NO_REGISTRASI=:noregbatal");
            $this->db->bind('isBatal', $isBatal);
            $this->db->bind('namauserx', $namauserx);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('noregbatal', $noregbatal);
            $this->db->execute();

            //#END update flag batal 1 ke tabel billing

            //DELETE DASHBOARD
            $this->db->query("DELETE DashboardData.dbo.dataRWJ
                                where NoRegistrasi=:noregbatal");
            $this->db->bind('noregbatal', $noregbatal);
            $this->db->execute();

            // KEMENKES
            // $waktuAwalkemkes = $xTglNowTempx.'+07:00';
            //         $EndTime =  $xTglNowTempx.'+07:00';
            //         $this->db->query("INSERT INTO DashboardData.dbo.Encounter_Update_Status 
            //         (Noregistrasi,statusName,idRegKemenkes,StartTime,EndTime)VALUES
            //         (:nofixReg,:statusName,:idMrkemkes,:StartTime,:EndTime)");
            //         $this->db->bind('nofixReg', $nofixReg);
            //         $this->db->bind('idMrkemkes', $idMrkemkes);
            //         $this->db->bind('StartTime', $waktuAwalkemkes);
            //         $this->db->bind('EndTime', $EndTime); 
            //         $this->db->bind('statusName', 'arrived'); 
            //         $this->db->execute();

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Registrasi berhasil Dihapus !'
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
    public function CreateRegistrasi($data)
    {
        try {
            $this->db->transaksi();
            date_default_timezone_set('Asia/Jakarta');
            $datenowcreate = $data['tglregistrasi'];
            $datenowcreate = date('Y-m-d H:i:s', strtotime($datenowcreate));
            $PasienJenisDaftar = $data['PasienJenisDaftar']; // ok
            $NoMr = str_replace("-", "", $data['PasienNoMR']); // ok
            $perusahaanid = $data['namajaminanid']; // ok
            $IdGrupPerawatan = $data['poliklinikid'];
            $NamaGrupPerawatan = $data['shownamapolifix']; // ok
            $IdDokter = $data['dokterid']; // ok
            $NamaDokter = $data['shownamdokterfix']; // ok
            $JenisBayar = $data['grupJaminanid']; // ok
            $namapasien = $data['PasienNama']; // ok
            $shift = $data['NamaSesionPraktek']; // ok
            $nilaiadminstrasi = $data['jenisadminnilai'];
            $idadministrasi = $data['jenisadministrasiid'];
            $referralid = $data['referralid'];
            $caramasukid = $data['caramasukid'];
            $Company = "RS YARSI WEB";
            $NoRegistrasiExist = $data['pxNoRegistrasi'];
            $NoEpisodeExist = $data['pxnoEpisode'];
            $NoReservasi = $data['pxNoReservasi'];
            $admclID = $data['admclID'];
            $admPayorName = $data['admPayorName'];
            $admpolicyNo = $data['admpolicyNo'];
            $admpolicyDate = $data['admpolicyDate'];
            $admplanCode = $data['admplanCode'];
            $admclStatus = $data['admclStatus'];
            $admclDesc = $data['admclDesc'];
            $admketstatus = $data['admketstatus'];
            $admpayorMemberID = $data['admpayorMemberID'];
            $admcoveragetype = $data['admcoveragetype'];
            $tiperegistrasi = $data['tiperegistrasi'];
            $JamPraktek = $data['Jampraktek'];
            $pxNoteRegistrasi = $data['pxNoteRegistrasi'];
            $TrimJamAkhir = Utils::datenowcreateHourMinutes();
            $tglregistrasi = $data['tglregistrasi'];
            $tglregistrasi = date('Y-m-d H:i:s', strtotime($tglregistrasi));
            $tglregistrasi_Ymd = date('Y-m-d', strtotime($tglregistrasi));
            $nosep = $data['pxNoSep'];
            $idUnitKemkes = $data['idUnitKemkes'];
            $idDoktertKemkes = $data['idDoktertKemkes'];
            $xTglNowTempx = $data['TglNowTemp'];
            $idMrkemkes = $data['idMrkemkes'];
            $nullable = '0';
            $NoMr_Real = $data['PasienNoMR']; // ok

            $iswalkin = $data['iswalkin'];
            if (isset($data['COB'])) {
                $COB = $data['COB'];
            } else {
                $COB = null;
            }
            $shownamaperusahaanfix = $data['shownamaperusahaanfix'];
            $showrefferalfix = $data['showrefferalfix'];

            $idodc = $data['idodc'];

            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $operator =  $session->IDEmployee;
            // cek sudah ada payment belum
            // if ($idUnitKemkes == "") {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => 'Silahkan Masukan Kode Unit Kemenkes !',
            //     );
            //     return $callback;
            //     exit;
            // }
            // if ($idDoktertKemkes == "") {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => 'Silahkan Masukan Kode Dokter Kemenkes !',
            //     );
            //     return $callback;
            //     exit;
            // }
            $this->db->query("SELECT Id FROM  PerawatanSQL.dbo.payments 
                            WHERE NoRegistrasi=:NoRegistrasiExist ");
            $this->db->bind('NoRegistrasiExist', $NoRegistrasiExist);
            $data =  $this->db->single();
            if ($data) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Simpan Gagal! No Registrasi Ini Sudah Memiliki Payment!',
                );
                return $callback;
                exit;
            }

            // TRIGER SEBELUM SIMPAN DATA
            // 1. TRIGER PASIEN JIKA JENIS BELUM DIISI  
            if ($PasienJenisDaftar == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Pilih jenis Pasien / Refresh halaman dahulu !',
                );
                return $callback;
                exit;
            }
            // 1. TRIGER PASIEN JIKA NO. MR KOSONG  
            if ($NoMr == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan No. MR !',
                );
                return $callback;
                exit;
            }

            if ($JenisBayar == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Jenis Jaminan Pasien !',
                );
                return $callback;
                exit;
            }

            // if ($JenisBayar == "5" && $perusahaanid == '313') {
            //     if ($nosep == '') {
            //         $callback = array(
            //             'status' => 'warning',
            //             'errorname' => 'Silahkan Masukan Nomor SEP !',
            //         );
            //         return $callback;
            //         exit;
            //     }
            // } else {
            //     $nosep = '';
            // }

            if ($IdGrupPerawatan == '17') {
                $fisioflag = 1;
            } else {
                $fisioflag = 0;
            }

            if ($IdDokter == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Dokter !',
                );
                return $callback;
                exit;
            }

            if ($perusahaanid == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Nama Jaminan !',
                );
                return $callback;
                exit;
            }

            if ($tiperegistrasi == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Pilih Tipe Registrasi !',
                );
                return $callback;
                exit;
            }

            if ($shift == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Sesion Praktek Harus Terisi !',
                );
                return $callback;
                exit;
            }

            // CEK ANTRIAN POLI
            $this->db->query("SELECT ID, NamaUnit, CodeRegis
                            from MasterdataSQL.dbo.MstrUnitPerwatan 
                            where  ID=:IdGrupPerawatan ");
            $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
            $data =  $this->db->single();
            $CodeRegis = $data['CodeRegis'];

            //CEK MAKSIMAL KUOTA------------------
            //waktu
            $datename  = date("l", strtotime($tglregistrasi));
            $this->db->query("SELECT Senin_Waktu,Selasa_Waktu,Rabu_Waktu,
                    Kamis_Waktu,Jumat_Waktu,Sabtu_Waktu,Minggu_Waktu,
                    isnull(Senin_Max_NonJKN,0) as Senin_Max_NonJKN,
                    isnull(Senin_Max_JKN,0) as Senin_Max_JKN,
                    isnull(Selasa_Max_JKN,0) Selasa_Max_JKN,
                    isnull(Selasa_Max_NonJKN,0) Selasa_Max_NonJKN,
                    isnull(Rabu_Max_JKN,0) Rabu_Max_JKN,
                    isnull(Rabu_Max_NonJKN,0) Rabu_Max_NonJKN,
                    isnull(Kamis_Max_JKN,0) Kamis_Max_JKN,
                    isnull(Kamis_Max_NonJKN,0) Kamis_Max_NonJKN,
                    isnull(Jumat_Max_JKN,0) Jumat_Max_JKN,
                    isnull(Jumat_Max_NonJKN,0) Jumat_Max_NonJKN,
                    isnull(Sabtu_Max_JKN,0) Sabtu_Max_JKN,
                    isnull(Sabtu_Max_NonJKN,0) Sabtu_Max_NonJKN,
                    isnull(Minggu_Max_JKN,0) Minggu_Max_JKN,
                    isnull(Minggu_Max_NonJKN,0) Minggu_Max_NonJKN,
                    isnull(Senin_Max,0) as Senin_Max,isnull(Selasa_Max,0) as Selasa_Max,
                    isnull(Rabu_Max,0) as Rabu_Max,isnull(Kamis_Max,0) as Kamis_Max,
                    isnull(Jumat_Max,0) as Jumat_Max,isnull(Sabtu_Max,0) as Sabtu_Max,isnull(Minggu_Max,0) as Minggu_Max
                    ,Senin_Akhir,Selasa_Akhir,Rabu_Akhir,Kamis_akhir,Jumat_Akhir,Sabtu_Akhir,Minggu_Akhir,Close_Schedule_Senin, Close_Schedule_Selasa, Close_Schedule_Rabu, Close_Schedule_Kamis, Close_Schedule_Jumat, Close_Schedule_Sabtu, 
                    Close_Schedule_Minggu,Senin_Awal,Selasa_Awal,Rabu_Awal,Kamis_Awal,Jumat_Awal,Sabtu_Awal,Minggu_Awal, Open_Assesment_Senin,Open_Assesment_Selasa,Open_Assesment_Rabu,Open_Assesment_Kamis,Open_Assesment_Jumat,Open_Assesment_Sabtu,Open_Assesment_Minggu
                    FROM MasterdataSQL.DBO.JadwalPraktek WHERE ID=:IDJadwal");
            $this->db->bind('IDJadwal', $JamPraktek);
            $dtjdwl =  $this->db->single();
            $jampraktekx = $dtjdwl['Minggu_Waktu'];
            if ($datename == "Sunday") {
                $jampraktekx = $dtjdwl['Minggu_Waktu'];
                $MaxHari = $dtjdwl['Minggu_Max'];
                $Max_NonJKN = $dtjdwl['Minggu_Max_NonJKN'];
                $Max_JKN = $dtjdwl['Minggu_Max_JKN'];
                $JamPraktekAkhir = $dtjdwl['Minggu_Akhir'];
                $close_schedule = $dtjdwl['Close_Schedule_Minggu'];
                $JamPraktekAwal = $dtjdwl['Minggu_Awal'];
                $OpenAssesment = $dtjdwl['Open_Assesment_Minggu'];
            } elseif ($datename == "Monday") {
                $jampraktekx = $dtjdwl['Senin_Waktu'];
                $MaxHari = $dtjdwl['Senin_Max'];
                $Max_NonJKN = $dtjdwl['Senin_Max_NonJKN'];
                $Max_JKN = $dtjdwl['Senin_Max_JKN'];
                $JamPraktekAkhir = $dtjdwl['Senin_Akhir'];
                $close_schedule = $dtjdwl['Close_Schedule_Senin'];
                $JamPraktekAwal = $dtjdwl['Senin_Awal'];
                $OpenAssesment = $dtjdwl['Open_Assesment_Senin'];
            } elseif ($datename == "Tuesday") {
                $jampraktekx = $dtjdwl['Selasa_Waktu'];
                $MaxHari = $dtjdwl['Selasa_Max'];
                $Max_NonJKN = $dtjdwl['Selasa_Max_NonJKN'];
                $Max_JKN = $dtjdwl['Selasa_Max_JKN'];
                $JamPraktekAkhir = $dtjdwl['Selasa_Akhir'];
                $close_schedule = $dtjdwl['Close_Schedule_Selasa'];
                $JamPraktekAwal = $dtjdwl['Selasa_Awal'];
                $OpenAssesment = $dtjdwl['Open_Assesment_Selasa'];
            } elseif ($datename == "Wednesday") {
                $jampraktekx = $dtjdwl['Rabu_Waktu'];
                $MaxHari = $dtjdwl['Rabu_Max'];
                $Max_NonJKN = $dtjdwl['Rabu_Max_NonJKN'];
                $Max_JKN = $dtjdwl['Rabu_Max_JKN'];
                $JamPraktekAkhir = $dtjdwl['Rabu_Akhir'];
                $close_schedule = $dtjdwl['Close_Schedule_Rabu'];
                $JamPraktekAwal = $dtjdwl['Rabu_Awal'];
                $OpenAssesment = $dtjdwl['Open_Assesment_Rabu'];
            } elseif ($datename == "Thursday") {
                $jampraktekx = $dtjdwl['Kamis_Waktu'];
                $MaxHari = $dtjdwl['Kamis_Max'];
                $Max_NonJKN = $dtjdwl['Kamis_Max_NonJKN'];
                $Max_JKN = $dtjdwl['Kamis_Max_JKN'];
                $JamPraktekAkhir = $dtjdwl['Kamis_akhir'];
                $close_schedule = $dtjdwl['Close_Schedule_Kamis'];
                $JamPraktekAwal = $dtjdwl['Kamis_Awal'];
                $OpenAssesment = $dtjdwl['Open_Assesment_Kamis'];
            } elseif ($datename == "Friday") {
                $jampraktekx = $dtjdwl['Jumat_Waktu'];
                $MaxHari = $dtjdwl['Jumat_Max'];
                $Max_NonJKN = $dtjdwl['Jumat_Max_NonJKN'];
                $Max_JKN = $dtjdwl['Jumat_Max_JKN'];
                $JamPraktekAkhir = $dtjdwl['Jumat_Akhir'];
                $close_schedule = $dtjdwl['Close_Schedule_Jumat'];
                $JamPraktekAwal = $dtjdwl['Jumat_Awal'];
                $OpenAssesment = $dtjdwl['Open_Assesment_Jumat'];
            } elseif ($datename == "Saturday") {
                $jampraktekx = $dtjdwl['Sabtu_Waktu'];
                $MaxHari = $dtjdwl['Sabtu_Max'];
                $Max_NonJKN = $dtjdwl['Sabtu_Max_NonJKN'];
                $Max_JKN = $dtjdwl['Sabtu_Max_JKN'];
                $JamPraktekAkhir = $dtjdwl['Sabtu_Akhir'];
                $close_schedule = $dtjdwl['Close_Schedule_Sabtu'];
                $JamPraktekAwal = $dtjdwl['Sabtu_Awal'];
                $OpenAssesment = $dtjdwl['Open_Assesment_Sabtu'];
            }
            if ($MaxHari == '0') {
                $callback = array(
                    'status' => "warning",
                    'errorname' => "Kuota Hari Tersebut Masih Kosong, Silahkan Dicek Terlebih Dahulu !",
                    //'errormessage' => $dataidregfieedback,    
                );
                return $callback;
            }

            if ($NoReservasi == "") {
                    if ($close_schedule == '1') {
                        $callback = array(
                            'status' => "warning",
                            'errorname' => "Maaf, Jadwal Poliklinik Dokter Sudah Tutup !",
                        );
                        return $callback;
                    }
             }

            if ($NoRegistrasiExist == "") {
                if ($IdGrupPerawatan <> '1') { // Jika BUKAN IGD Cek Semuanya
                    if ($iswalkin <> 'WALKIN') { //CONVERT No. Mr 
                        if (
                            $JenisBayar == '5' && $perusahaanid == '313'
                        ) {
                            if ($Max_JKN == '0') {
                                $callback = array(
                                    'status' => "warning",
                                    'errorname' => "Kuota Max JKN Masih Kosong, Silahkan Dicek Terlebih Dahulu !",
                                    //'errormessage' => $dataidregfieedback,    
                                );
                                return $callback;
                            }
                        } else {
                            if ($Max_NonJKN == '0') {
                                $callback = array(
                                    'status' => "warning",
                                    'errorname' => "Kuota Max NON JKN Masih Kosong, Silahkan Dicek Terlebih Dahulu !",
                                    //'errormessage' => $dataidregfieedback,    
                                );
                                return $callback;
                            }
                        }
                        if ($OpenAssesment != '1') {
                            if (date("H:i", strtotime($TrimJamAkhir)) > date("H:i", strtotime($JamPraktekAkhir))) {
                                $metadata = array(
                                    'errorname' => 'Pendaftaran Ke Poli ' . $NamaGrupPerawatan . ' Sudah Tutup Jam ' . $JamPraktekAkhir,
                                    'status' => 'warning', // Set array nama dengan isi kolom nama pada tabel siswa 
                                );
                                return $metadata;
                                exit;
                            }
                        }
                        
                        // if ($NoReservasi != ''){
                        //     $timediff_in_minutes = round(abs(strtotime($JamPraktekAwal) - strtotime($TrimJamAkhir)) / 60);
                        //     if ($timediff_in_minutes > 60) {
                        //         $metadata = array(
                        //             'errorname' => 'Pendaftaran Ke Poli ' . $NamaGrupPerawatan . ' Jam Praktek Melebihi 1 (Satu) Jam Sebelum Praktek Dokter Mulai Jam ' . $JamPraktekAwal,
                        //             'status' => 'warning', 
                        //         );
                        //         return $metadata;
                        //         exit;
                        //     }
                        // }
                        // cek ada cuti ga
                        $this->db->query("SELECT  *FROM MasterdataSQL.dbo.TR_CUTI_DOKTER
                                    where :tglbookingfix 
                                    between MasterdataSQL.dbo.TR_CUTI_DOKTER.periode_awal 
                                    and MasterdataSQL.dbo.TR_CUTI_DOKTER.periode_akhir 
                                    and id_dokter=:IdDokter AND  Batal='0'");
                        $this->db->bind('IdDokter', $shift);
                        $this->db->bind('tglbookingfix', $tglregistrasi);
                        $cutidokter =  $this->db->rowCount();
                        if (
                            $cutidokter > 0
                        ) {
                            $metadata = array(
                                'errorname' => 'Dokter Yang Anda Pilih sedang Cuti.',
                                'status' => 'warning', // Set array nama dengan isi kolom nama pada tabel siswa 
                            );
                            return $metadata;
                            exit;
                        }
                    }
                }
            }

            // START - VALIDASI KUOTA
            if ($NoReservasi == "") {
                if ($datename == "Sunday") {
                    $this->db->query("SELECT count(id) as total	FROM 
                    (SELECT id,noAntrianAll 
                    FROM PerawatanSQL.DBO.View_Antrian_Booking
                    WHERE replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-')=:TglKunjungan
                    AND Batal=:Batal AND Doctor_1=:Doctor_1 AND IdPoli=:IdPoli AND Minggu_Waktu=:Minggu_Waktu
                    UNION ALL
                    SELECT id,noAntrianAll 
                    FROM PerawatanSQL.DBO.View_Antrian_Registrasi
                    WHERE replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-')=:TglKunjungan2
                    AND Batal=:Batal2 AND Doctor_1=:Doctor_12 AND Unit=:IdPoli2 AND Minggu_Waktu=:Minggu_Waktu2 ) AS QuarterlyData");
                    $this->db->bind('TglKunjungan', $tglregistrasi_Ymd);
                    $this->db->bind('Batal', '0');
                    $this->db->bind('Doctor_1', $IdDokter);
                    $this->db->bind('IdPoli', $IdGrupPerawatan);
                    $this->db->bind('Minggu_Waktu', $jampraktekx);
                    $this->db->bind('TglKunjungan2', $tglregistrasi_Ymd);
                    $this->db->bind('Batal2', '0');
                    $this->db->bind('Doctor_12', $IdDokter);
                    $this->db->bind('IdPoli2', $IdGrupPerawatan);
                    $this->db->bind('Minggu_Waktu2', $jampraktekx);
                    $xe = $this->db->single();
                    $koutaPerPoli = $xe['total'];
                } elseif ($datename == "Monday") {
                    $this->db->query("SELECT count(id) as total	FROM 
                    (SELECT id,noAntrianAll 
                    FROM PerawatanSQL.DBO.View_Antrian_Booking
                    WHERE replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-')=:TglKunjungan
                    AND Batal=:Batal AND Doctor_1=:Doctor_1 AND IdPoli=:IdPoli AND Senin_Waktu=:Senin_Waktu
                    UNION ALL
                    SELECT id,noAntrianAll 
                    FROM PerawatanSQL.DBO.View_Antrian_Registrasi
                    WHERE replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-')=:TglKunjungan2
                    AND Batal=:Batal2 AND Doctor_1=:Doctor_12 AND Unit=:IdPoli2 AND Senin_Waktu=:Senin_Waktu2 ) AS QuarterlyData");
                    $this->db->bind('TglKunjungan', $tglregistrasi_Ymd);
                    $this->db->bind('Batal', '0');
                    $this->db->bind('Doctor_1', $IdDokter);
                    $this->db->bind('IdPoli', $IdGrupPerawatan);
                    $this->db->bind('Senin_Waktu', $jampraktekx);
                    $this->db->bind('TglKunjungan2', $tglregistrasi_Ymd);
                    $this->db->bind('Batal2', '0');
                    $this->db->bind('Doctor_12', $IdDokter);
                    $this->db->bind('IdPoli2', $IdGrupPerawatan);
                    $this->db->bind('Senin_Waktu2', $jampraktekx);
                    $xe = $this->db->single();
                    $koutaPerPoli = $xe['total'];
                } elseif ($datename == "Tuesday") {
                    $this->db->query("SELECT count(id) as total	FROM 
                    (SELECT id,noAntrianAll 
                    FROM PerawatanSQL.DBO.View_Antrian_Booking
                    WHERE replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-')=:TglKunjungan
                    AND Batal=:Batal AND Doctor_1=:Doctor_1 AND IdPoli=:IdPoli AND Selasa_Waktu=:Selasa_Waktu
                    UNION ALL
                    SELECT id,noAntrianAll 
                    FROM PerawatanSQL.DBO.View_Antrian_Registrasi
                    WHERE replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-')=:TglKunjungan2
                    AND Batal=:Batal2 AND Doctor_1=:Doctor_12 AND Unit=:IdPoli2 AND Selasa_Waktu=:Selasa_Waktu2 ) AS QuarterlyData");
                    $this->db->bind('TglKunjungan', $tglregistrasi_Ymd);
                    $this->db->bind('Batal', '0');
                    $this->db->bind('Doctor_1', $IdDokter);
                    $this->db->bind('IdPoli', $IdGrupPerawatan);
                    $this->db->bind('Selasa_Waktu', $jampraktekx);
                    $this->db->bind('TglKunjungan2', $tglregistrasi_Ymd);
                    $this->db->bind('Batal2', '0');
                    $this->db->bind('Doctor_12', $IdDokter);
                    $this->db->bind('IdPoli2', $IdGrupPerawatan);
                    $this->db->bind('Selasa_Waktu2', $jampraktekx);
                    $xe = $this->db->single();
                    $koutaPerPoli = $xe['total'];
                } elseif ($datename == "Wednesday") {
                    $this->db->query("SELECT count(id) as total	FROM 
                    (SELECT id,noAntrianAll 
                    FROM PerawatanSQL.DBO.View_Antrian_Booking
                    WHERE replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-')=:TglKunjungan
                    AND Batal=:Batal AND Doctor_1=:Doctor_1 AND IdPoli=:IdPoli AND Rabu_Waktu=:Rabu_Waktu
                    UNION ALL
                    SELECT id,noAntrianAll 
                    FROM PerawatanSQL.DBO.View_Antrian_Registrasi
                    WHERE replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-')=:TglKunjungan2
                    AND Batal=:Batal2 AND Doctor_1=:Doctor_12 AND Unit=:IdPoli2 AND Rabu_Waktu=:Rabu_Waktu2 ) AS QuarterlyData");
                    $this->db->bind('TglKunjungan', $tglregistrasi_Ymd);
                    $this->db->bind('Batal', '0');
                    $this->db->bind('Doctor_1', $IdDokter);
                    $this->db->bind('IdPoli', $IdGrupPerawatan);
                    $this->db->bind('Rabu_Waktu', $jampraktekx);
                    $this->db->bind('TglKunjungan2', $tglregistrasi_Ymd);
                    $this->db->bind('Batal2', '0');
                    $this->db->bind('Doctor_12', $IdDokter);
                    $this->db->bind('IdPoli2', $IdGrupPerawatan);
                    $this->db->bind('Rabu_Waktu2', $jampraktekx);
                    $xe = $this->db->single();
                    $koutaPerPoli = $xe['total'];
                } elseif ($datename == "Thursday") {
                    $this->db->query("SELECT count(id) as total	FROM 
                    (SELECT id,noAntrianAll 
                    FROM PerawatanSQL.DBO.View_Antrian_Booking
                    WHERE replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-')=:TglKunjungan
                    AND Batal=:Batal AND Doctor_1=:Doctor_1 AND IdPoli=:IdPoli AND Kamis_Waktu=:Kamis_Waktu
                    UNION ALL
                    SELECT id,noAntrianAll 
                    FROM PerawatanSQL.DBO.View_Antrian_Registrasi
                    WHERE replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-')=:TglKunjungan2
                    AND Batal=:Batal2 AND Doctor_1=:Doctor_12 AND Unit=:IdPoli2 AND Kamis_Waktu=:Kamis_Waktu2 ) AS QuarterlyData");
                    $this->db->bind('TglKunjungan', $tglregistrasi_Ymd);
                    $this->db->bind('Batal', '0');
                    $this->db->bind('Doctor_1', $IdDokter);
                    $this->db->bind('IdPoli', $IdGrupPerawatan);
                    $this->db->bind('Kamis_Waktu', $jampraktekx);
                    $this->db->bind('TglKunjungan2', $tglregistrasi_Ymd);
                    $this->db->bind('Batal2', '0');
                    $this->db->bind('Doctor_12', $IdDokter);
                    $this->db->bind('IdPoli2', $IdGrupPerawatan);
                    $this->db->bind('Kamis_Waktu2', $jampraktekx);
                    $xe = $this->db->single();
                    $koutaPerPoli = $xe['total'];
                } elseif ($datename == "Friday") {
                    $this->db->query("SELECT count(id) as total	FROM 
                    (SELECT id,noAntrianAll 
                    FROM PerawatanSQL.DBO.View_Antrian_Booking
                    WHERE replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-')=:TglKunjungan
                    AND Batal=:Batal AND Doctor_1=:Doctor_1 AND IdPoli=:IdPoli AND Jumat_Waktu=:Jumat_Waktu
                    UNION ALL
                    SELECT id,noAntrianAll 
                    FROM PerawatanSQL.DBO.View_Antrian_Registrasi
                    WHERE replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-')=:TglKunjungan2
                    AND Batal=:Batal2 AND Doctor_1=:Doctor_12 AND Unit=:IdPoli2 AND Jumat_Waktu=:Jumat_Waktu2 ) AS QuarterlyData");
                    $this->db->bind('TglKunjungan', $tglregistrasi_Ymd);
                    $this->db->bind('Batal', '0');
                    $this->db->bind('Doctor_1', $IdDokter);
                    $this->db->bind('IdPoli', $IdGrupPerawatan);
                    $this->db->bind('Jumat_Waktu', $jampraktekx);
                    $this->db->bind('TglKunjungan2', $tglregistrasi_Ymd);
                    $this->db->bind('Batal2', '0');
                    $this->db->bind('Doctor_12', $IdDokter);
                    $this->db->bind('IdPoli2', $IdGrupPerawatan);
                    $this->db->bind('Jumat_Waktu2', $jampraktekx);
                    $xe = $this->db->single();
                    $koutaPerPoli = $xe['total'];
                } elseif ($datename == "Saturday") {
                    $this->db->query("SELECT count(id) as total	FROM 
                    (SELECT id,noAntrianAll 
                    FROM PerawatanSQL.DBO.View_Antrian_Booking
                    WHERE replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-')=:TglKunjungan
                    AND Batal=:Batal AND Doctor_1=:Doctor_1 AND IdPoli=:IdPoli AND Sabtu_Waktu=:Sabtu_Waktu
                    UNION ALL
                    SELECT id,noAntrianAll 
                    FROM PerawatanSQL.DBO.View_Antrian_Registrasi
                    WHERE replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-')=:TglKunjungan2
                    AND Batal=:Batal2 AND Doctor_1=:Doctor_12 AND Unit=:IdPoli2 AND Sabtu_Waktu=:Sabtu_Waktu2 ) AS QuarterlyData");
                    $this->db->bind('TglKunjungan', $tglregistrasi_Ymd);
                    $this->db->bind('Batal', '0');
                    $this->db->bind('Doctor_1', $IdDokter);
                    $this->db->bind('IdPoli', $IdGrupPerawatan);
                    $this->db->bind('Sabtu_Waktu', $jampraktekx);
                    $this->db->bind('TglKunjungan2', $tglregistrasi_Ymd);
                    $this->db->bind('Batal2', '0');
                    $this->db->bind('Doctor_12', $IdDokter);
                    $this->db->bind('IdPoli2', $IdGrupPerawatan);
                    $this->db->bind('Sabtu_Waktu2', $jampraktekx);
                    $xe = $this->db->single();
                    $koutaPerPoli = $xe['total'];
                }

                $Ant = $koutaPerPoli + 1;

                if ($JenisBayar == '5' && $perusahaanid == '313') {
                    if ($koutaPerPoli >= $Max_JKN) {
                        $callback = array(
                            'status' => "warning",
                            'errorname' => "Kuota Dokter : " . $NamaDokter  . ", Hari : " . $datename . " Sudah Penuh, Kuota Maksimal " . $Max_JKN . ", No. Antrian Pasien Saat ini Adalah : " .  $Ant . ". Silahkan Pilih tanggal Lain untuk Melakukan Booking/Reservasi kembali",
                            //'errormessage' => $dataidregfieedback,    
                        );
                        return $callback;
                    }
                } else {
                    if ($koutaPerPoli >= $Max_NonJKN) {
                        $callback = array(
                            'status' => "warning",
                            'errorname' => "Kuota Dokter : " . $NamaDokter . ", Hari : " . $datename . " Sudah Penuh, Kuota Maksimal " . $Max_NonJKN . ", No. Antrian Pasien Saat ini Adalah : " .  $Ant . ". Silahkan Pilih tanggal Lain untuk Melakukan Booking/Reservasi kembali.",
                            //'errormessage' => $dataidregfieedback,    
                        );
                        return $callback;
                    }
                }
            }

            // END - VALIDASI KUOTA


            // Jumlah antrian Saat ini
            // $this->db->query("SELECT COUNT(ID) AS JUMLAHJKN FROM PerawatanSQL.DBO.Visit
            // where replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-')=:ApmDate
            // and Doctor_1=:DoctorID and JamPraktek=:JamPraktek and batal='0'
            // and perusahaan='313' and PatientType='5' and Unit=:Unit");
            // $this->db->bind('JamPraktek', $shift);
            // $this->db->bind('DoctorID', $IdDokter);
            // $this->db->bind('ApmDate', $tglregistrasi_Ymd);
            // $this->db->bind('Unit', $IdGrupPerawatan);
            // $datallantrian =  $this->db->single();
            // $JUMLAHJKN = $datallantrian['JUMLAHJKN'];

            // $this->db->query("SELECT COUNT(ID) AS JUMLAHNONJKN FROM PerawatanSQL.DBO.Visit
            //         where replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-')=:ApmDate and Doctor_1=:DoctorID 
            //         and JamPraktek=:JamPraktek and batal='0' and Unit=:Unit
            //         and id not in(
            //                 SELECT ID  FROM PerawatanSQL.DBO.Visit
            //                 where replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-')=:ApmDate2 
            //                 and Doctor_1=:DoctorID2 and JamPraktek=:JamPraktek2 and batal='0'
            //                 and perusahaan='313' and PatientType='5' and Unit=:Unit2
            //         ) ");
            // $this->db->bind('JamPraktek', $shift);
            // $this->db->bind('JamPraktek2', $shift);
            // $this->db->bind('DoctorID', $IdDokter);
            // $this->db->bind('DoctorID2', $IdDokter);
            // $this->db->bind('ApmDate', $tglregistrasi_Ymd);
            // $this->db->bind('ApmDate2', $tglregistrasi_Ymd);
            // $this->db->bind('Unit', $IdGrupPerawatan);
            // $this->db->bind('Unit2', $IdGrupPerawatan);
            // $datasdhpgl =  $this->db->single();
            // $JUMLAHNONJKN = $datasdhpgl['JUMLAHNONJKN'];
            if ($NoRegistrasiExist == "") {
                if ($IdGrupPerawatan <> '1') { // Jika BUKAN IGD Cek Semuanya
                    if ($iswalkin <> 'WALKIN') { //CONVERT No. Mr  
                        if ($JenisBayar == '5' && $perusahaanid == '313') {
                            // if (($Max_JKN - $JUMLAHJKN) <= 0) {
                            //     $callback = array(
                            //         'status' => "warning",
                            //         'errorname' => "Maaf Tidak Dapat Simpan Registrasi, Kuota Telah Melebihi Batas Maksimal",
                            //         //'errormessage' => $dataidregfieedback,    
                            //     );
                            //     return $callback;
                            // }

                            $this->db->query("SELECT COUNT(ID) AS Jumlah_ApmJkn FROM PerawatanSQL.DBO.Apointment
                            where replace(CONVERT(VARCHAR(11), ApmDate, 111), '/','-')=:ApmDate  AND Datang='0' AND NoMR=:NoMr_Real AND Batal='0' AND Company=:Company AND IdPoli=:IdGrupPerawatan AND DoctorID=:IdDokter");
                            $this->db->bind('ApmDate', $tglregistrasi_Ymd);
                            $this->db->bind('NoMr_Real', $NoMr_Real);
                            $this->db->bind('Company', 'JKN Mobile');
                            $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                            $this->db->bind('IdDokter', $IdDokter);
                            $data_apmjkn =  $this->db->single();
                            if ($data_apmjkn['Jumlah_ApmJkn'] > 0) {
                                // $callback = array(
                                //     'status' => "warning",
                                //     'errorname' => "Pasien sudah reservasi via jkn mobile. Silahkan check In via aplikasi jkn mobile atau batalkan via jkn mobile jika tidak jadi berobat.",
                                // );
                                // return $callback;
                                // exit;
                                $Company = 'JKN MOBILE';
                            }
                        } else {
                            // if (($Max_NonJKN - $JUMLAHNONJKN) <= 0
                            // ) {
                            //     $callback = array(
                            //         'status' => "warning",
                            //         'errorname' => "Maaf Tidak Dapat Simpan Registrasi, Kuota Telah Melebihi Batas Maksimal",
                            //         //'errormessage' => $dataidregfieedback,    
                            //     );
                            //     return $callback;
                            // }
                        }
                    }
                }
            }
            // cek cuti engga
            //END CEK KUOTA MAKSIMAL----------------------------------
            // JIKA NO REGISTRASI SUDAH ADA 
            if ($NoRegistrasiExist <> "") {

                // GET DATA KARCIS
                $this->db->query("SELECT ID, Nama_Karcis,Nilai_Karcis
                 from MasterdataSQL.dbo.MstrKarcisAdministrasi  
                 where  ID=:idadministrasi");
                $this->db->bind('idadministrasi', $idadministrasi);
                $data =  $this->db->single();
                $Nama_Karcis = $data['Nama_Karcis'];
                $Nilai_Karcis = $data['Nilai_Karcis'];

                // update ke tabel FO_T_Billing
                


                // update ke tabel FO_T_Billing_1
                // update Administrasi
                // $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_1
                //       SET PETUGAS_ENTRY=:namauserx,KODE_TARIF=:idadministrasi,UNIT=:IdGrupPerawatan,GROUP_JAMINAN=:JenisBayar,KODE_JAMINAN=:perusahaanid,NAMA_TARIF=:Nama_Karcis,NILAI_TARIF=:Nilai_Karcis,SUB_TOTAL=:Nilai_Karcis2,SUB_TOTAL_2=:Nilai_Karcis3,GRANDTOTAL=:Nilai_Karcis4
                //       where NO_REGISTRASI=:NoRegistrasiExist and GROUP_TARIF='Administrasi'");
                // $this->db->bind('NoRegistrasiExist', $NoRegistrasiExist);
                // $this->db->bind('idadministrasi', $idadministrasi);
                // $this->db->bind('Nama_Karcis', $Nama_Karcis);
                // $this->db->bind('Nilai_Karcis', $Nilai_Karcis);
                // $this->db->bind('Nilai_Karcis2', $Nilai_Karcis);
                // $this->db->bind('Nilai_Karcis3', $Nilai_Karcis);
                // $this->db->bind('Nilai_Karcis4', $Nilai_Karcis);
                // $this->db->bind('namauserx', $namauserx);
                // $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                // $this->db->bind('JenisBayar', $JenisBayar);
                // $this->db->bind('perusahaanid', $perusahaanid);
                // $this->db->execute();

                // update ke tabel FO_T_Billing_1
                // update Administrasi
                // $this->db->query(" UPDATE Billing_Pasien.dbo.FO_T_BILLING_2
                //       SET KODE_TARIF=A1.KODE_TARIF,UNIT=A1.UNIT,GROUP_JAMINAN=A1.GROUP_JAMINAN,KODE_JAMINAN=A1.KODE_JAMINAN,NAMA_TARIF=A1.NAMA_TARIF,NILAI_TARIF=A1.NILAI_TARIF,SUB_TOTAL=A1.NILAI_TARIF*A1.QTY,SUB_TOTAL_2=
                //       ((A1.NILAI_TARIF*A1.QTY)-(((A1.NILAI_TARIF*A1.QTY)*A1.DISC)/100)),NILAI_PDP=(CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN (((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY)-(((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*A1.DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' THEN (b.NILAI_FIX*A1.QTY)-((b.NILAI_FIX*A1.QTY*A1.DISC)/100)*A1.QTY END )
				// 	  ,NILAI_DISKON_PDP= (CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN ((((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*A1.DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' THEN ((b.NILAI_FIX*A1.QTY*A1.DISC)/100)*A1.QTY END ),DISC_RP=(A1.NILAI_TARIF-((A1.NILAI_TARIF*A1.DISC)/100)),DISC=A1.DISC,KD_POSTING=B.KD_POSTING,KD_POSTING_DISC=b.KD_POSTING_DISC
                //       froM Billing_Pasien.DBO.FO_T_BILLING_2 xx 
				// 	  inner join Billing_Pasien.DBO.FO_T_BILLING A on xx.NO_TRS_BILLING=A.NO_TRS_BILLING
                //      inner join Billing_Pasien.dbo.FO_T_BILLING_1 A1
                //      ON A.NO_TRS_BILLING = A1.NO_TRS_BILLING
                //      INNER JOIN MasterdataSQL.DBO.MstrKarcisAdministrasi CC 
                //      ON CC.ID = A1.KODE_TARIF
                //      INNER JOIN Keuangan.DBO.BO_M_PDP2 B
                //     ON CC.KD_PDP collate SQL_Latin1_General_CP1_CI_AS = B.KD_PDP collate SQL_Latin1_General_CP1_CI_AS
                //     INNER JOIN Keuangan.DBO.BO_M_PDP CX
                //     ON CX.KD_PDP = B.KD_PDP
                //       where xx.NO_TRS_BILLING in 
				// 	  (SELECT z.NO_TRS_BILLING FROM Billing_Pasien.DBO.FO_T_BILLING_1 z 
				// 	  inner join Billing_Pasien.dbo.FO_T_BILLING x on z.NO_TRS_BILLING=x.NO_TRS_BILLING
				// 	  where z.NO_REGISTRASI=:NoRegistrasiExist and z.GROUP_ENTRI='KARCIS' AND z.BATAL='0' AND x.BATAL='0')");
                // $this->db->bind('NoRegistrasiExist', $NoRegistrasiExist);
                // $this->db->execute();

                //UPDATE TOTAL KE FO_T_BILLING

                // update HDR tabel billing
                // $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING
                //     SET 
                //     where NO_REGISTRASI=:NoRegistrasiExist and SUBSTRING(no_trs_billing,1,2)=:no_trs_billing ");
                // $this->db->bind('NoRegistrasiExist', $NoRegistrasiExist);
                // $this->db->bind('namauserx', $namauserx);
                // $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                // $this->db->bind('JenisBayar', $JenisBayar);
                // $this->db->bind('perusahaanid', $perusahaanid);
                // $this->db->bind('no_trs_billing', 'AD');
                // $this->db->execute();


                // $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_BILLING
                //     SET TOTAL_TARIF=B.SUM_NILAI_TARIF,TOTAL_QTY=B.SUM_QTY,SUBTOTAL=B.SUM_SUB_TOTAL,SUBTOTAL_2=B.SUM_SUB_TOTAL_2,
                //     GRANDTOTAL=B.SUM_GRANDTOTAL,FB_VERIF_JURNAL='0',
                //     PETUGAS_ENTRY=:namauserx,UNIT=:IdGrupPerawatan,GROUP_JAMINAN=:JenisBayar,KODE_JAMINAN=:perusahaanid
                //     FROM Billing_Pasien.DBO.FO_T_BILLING A 
                //     INNER JOIN
                //     (
                //         SELECT  NO_TRS_BILLING,SUM(NILAI_TARIF) AS SUM_NILAI_TARIF,SUM(QTY) AS SUM_QTY,SUM(SUB_TOTAL) AS SUM_SUB_TOTAL,SUM(SUB_TOTAL_2) AS SUM_SUB_TOTAL_2,
                //         SUM(GRANDTOTAL) AS SUM_GRANDTOTAL
                //         FROM Billing_Pasien.DBO.FO_T_BILLING_1
                //         WHERE NO_REGISTRASI=:noreg and Batal='0'  and GROUP_ENTRI='KARCIS'
                //         GROUP BY NO_TRS_BILLING
                //     ) B
                //     ON A.NO_TRS_BILLING = B.NO_TRS_BILLING
                //     WHERE A.NO_REGISTRASI=:noreg2");
                // $this->db->bind('noreg', $NoRegistrasiExist);
                // $this->db->bind('noreg2', $NoRegistrasiExist);
                // $this->db->bind('namauserx', $namauserx);
                // $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                // $this->db->bind('JenisBayar', $JenisBayar);
                // $this->db->bind('perusahaanid', $perusahaanid);
                // $this->db->execute();

                if ($iswalkin == 'WALKIN') { //CONVERT No. Mr
                    $idkanan = substr($NoMr, 5); // xx-xx-03 kanan
                    $idtengah = substr($NoMr, 3, -2); //
                    $idkiri = substr($NoMr, 1, -4);
                    $idwalkin = substr($NoMr, 0, -6);
                    $NoMrfix =   $idwalkin . '-' . $idkiri . $idtengah . $idkanan;
                } else {
                    //CONVERT No. Mr
                    $idkanan = substr($NoMr, 4); // xx-xx-03 kanan
                    $idtengah = substr($NoMr, 2, -2); //
                    $idkiri = substr($NoMr, 0, -4);
                    $NoMrfix =   $idkiri . '-' . $idtengah . '-' . $idkanan;
                }


                // HAPUS ADMINISTRASI
                $this->db->query("DELETE PerawatanSQL.dbo.[Visit Details] 
                                where NoRegistrasi=:NoRegistrasiExist 
                                and KategoriTarif='Administrasi' ");
                $this->db->bind('NoRegistrasiExist', $NoRegistrasiExist);
                $this->db->execute();

                // cek diskon admin per jaminan
                $this->db->query("SELECT RJ_Disc_Administrasi 
                                            from MasterdataSQL.dbo.MstrPerusahaanAsuransi 
                                          where id=:JenisBayar");
                $this->db->bind('JenisBayar', $JenisBayar);
                $data =  $this->db->single();
                $RJ_Disc_Administrasi = $data['RJ_Disc_Administrasi'];
                $adminmindisc = $RJ_Disc_Administrasi * $nilaiadminstrasi;
                $nilaiadministrasifix = $nilaiadminstrasi - $adminmindisc;

                // CEK ANTRIAN
                $this->db->query("SELECT unit,Doctor_1, 
                                replace(CONVERT(VARCHAR(11),TglKunjungan, 111), '/','-') AS tgl   
                                from PerawatanSQL.dbo.Visit 
                                where NoRegistrasi=:NoRegistrasiExist");
                $this->db->bind('NoRegistrasiExist', $NoRegistrasiExist);
                $data =  $this->db->single();
                $Doctor_1 = $data['Doctor_1'];
                $unit = $data['unit'];
                $tglregawl = $data['tgl'];

                if ($unit <> $IdGrupPerawatan || $Doctor_1 <> $IdDokter) {
                    // CARI MAX ANTRIAN
                    $this->db->query("SELECT max(Antrian) as urutantrian
                                from PerawatanSQL.dbo.AntrianPasien  where  
                                replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-')
                                =:tglregawl and JamPraktek=:shift and Doctor_1=:IdDokter");
                    $this->db->bind('tglregawl', $tglregawl);
                    $this->db->bind('shift', $shift);
                    $this->db->bind('IdDokter', $IdDokter);
                    $data =  $this->db->single();
                    $no_urutantrian = $data['urutantrian'];
                    $idno_urutantrian = $no_urutantrian;
                    $idno_urutantrian++;

                    // KODE ANTRIAN DOKTER
                    $this->db->query("SELECT *from MasterdataSQL.dbo.Doctors  where ID=:IdDokter ");
                    $this->db->bind('IdDokter', $IdDokter);
                    $data =  $this->db->single();
                    $CodeAntrian = $data['CodeAntrian'];
                    // fix no antrian
                    $fixNoAntrian = $CodeAntrian . '-' . $idno_urutantrian;

                    if ($JenisBayar === "2") { // ASURANSI
                        $this->db->query("UPDATE perawatanSQL.dbo.Visit SET 
                                          LokasiPasien=:NamaGrupPerawatan,
                                          CaraBayar='0', 
                                          PatientType=:JenisBayar,Unit=:IdGrupPerawatan,Doctor_1=:IdDokter,
                                          Antrian=:idno_urutantrian,NoAntrianAll=:fixNoAntrian,
                                          --Company=:Company,
                                          JamPraktek=:shift,Asuransi=:perusahaanid
                                          ,idAdmin=:idadministrasi,idCaraMasuk=:caramasukid,idCaraMasuk2=:referralid,
                                          JenisDaftar=:PasienJenisDaftar
                                          ,admclID=:admclID,admPayorName=:admPayorName,
                                          admpolicyNo=:admpolicyNo,admpolicyDate=:admpolicyDate,
                                          admplanCode=:admplanCode,admclStatus=:admclStatus,
                                          admclDesc=:admclDesc,admketstatus=:admketstatus,
                                          admpayorMemberID=:admpayorMemberID,admcoveragetype=:admcoveragetype, 
                                          FisioterapiFlag=:fisioflag,TglKunjungan=:tglregistrasi,
                                          [Visit Date]=:tglregistrasi2 ,NoSEP=:nosep,Tipe_Registrasi=:tiperegistrasi,
                                          ID_JadwalPraktek=:JamPraktek,
                                          Catatan=:pxNoteRegistrasi,KodeJaminanCOB=:COB
                                          WHERE NoRegistrasi=:NoRegistrasiExist");
                        $this->db->bind('NamaGrupPerawatan', $NamaGrupPerawatan);
                        $this->db->bind('JenisBayar', $JenisBayar);
                        $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                        $this->db->bind('IdDokter', $IdDokter);
                        $this->db->bind('idno_urutantrian', $idno_urutantrian);
                        $this->db->bind('fixNoAntrian', $fixNoAntrian);
                        //$this->db->bind('Company', $Company);
                        $this->db->bind('shift', $shift);
                        $this->db->bind('perusahaanid', $perusahaanid);
                        $this->db->bind('idadministrasi', $idadministrasi);
                        $this->db->bind('caramasukid', $caramasukid);
                        $this->db->bind('referralid', $referralid);
                        $this->db->bind('PasienJenisDaftar', $PasienJenisDaftar);
                        $this->db->bind('admclID', $admclID);
                        $this->db->bind('admPayorName', $admPayorName);
                        $this->db->bind('admpolicyNo', $admpolicyNo);
                        $this->db->bind('admpolicyDate', $admpolicyDate);
                        $this->db->bind('admplanCode', $admplanCode);
                        $this->db->bind('admclStatus', $admclStatus);
                        $this->db->bind('admclDesc', $admclDesc);
                        $this->db->bind('admketstatus', $admketstatus);
                        $this->db->bind('admpayorMemberID', $admpayorMemberID);
                        $this->db->bind('admcoveragetype', $admcoveragetype);
                        $this->db->bind('fisioflag', $fisioflag);
                        $this->db->bind('tglregistrasi', $tglregistrasi);
                        $this->db->bind('tglregistrasi2', $tglregistrasi);
                        $this->db->bind('nosep', $nosep);
                        $this->db->bind('NoRegistrasiExist', $NoRegistrasiExist);
                        $this->db->bind('tiperegistrasi', $tiperegistrasi);
                        $this->db->bind('JamPraktek', $JamPraktek);
                        $this->db->bind('pxNoteRegistrasi', $pxNoteRegistrasi);
                        $this->db->bind('COB', $COB);
                        $this->db->execute();
                    } elseif ($JenisBayar <> "2") { // ASURANSI
                        $this->db->query("UPDATE perawatanSQL.dbo.Visit SET 
                                          LokasiPasien=:NamaGrupPerawatan,
                                          CaraBayar='0', 
                                          PatientType=:JenisBayar,Unit=:IdGrupPerawatan,Doctor_1=:IdDokter,
                                          Antrian=:idno_urutantrian,NoAntrianAll=:fixNoAntrian,
                                          --Company=:Company,
                                          JamPraktek=:shift,Perusahaan=:perusahaanid
                                          ,idAdmin=:idadministrasi,idCaraMasuk=:caramasukid,idCaraMasuk2=:referralid,
                                          JenisDaftar=:PasienJenisDaftar
                                          ,admclID=:admclID,admPayorName=:admPayorName,
                                          admpolicyNo=:admpolicyNo,admpolicyDate=:admpolicyDate,
                                          admplanCode=:admplanCode,admclStatus=:admclStatus,
                                          admclDesc=:admclDesc,admketstatus=:admketstatus,
                                          admpayorMemberID=:admpayorMemberID,admcoveragetype=:admcoveragetype, 
                                          FisioterapiFlag=:fisioflag,TglKunjungan=:tglregistrasi,
                                          [Visit Date]=:tglregistrasi2 ,NoSEP=:nosep,Tipe_Registrasi=:tiperegistrasi,
                                          ID_JadwalPraktek=:JamPraktek,
                                          Catatan=:pxNoteRegistrasi,KodeJaminanCOB=:COB
                                          WHERE NoRegistrasi=:NoRegistrasiExist");
                        $this->db->bind('pxNoteRegistrasi', $pxNoteRegistrasi);
                        $this->db->bind('NamaGrupPerawatan', $NamaGrupPerawatan);
                        $this->db->bind('JenisBayar', $JenisBayar);
                        $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                        $this->db->bind('IdDokter', $IdDokter);
                        $this->db->bind('idno_urutantrian', $idno_urutantrian);
                        $this->db->bind('fixNoAntrian', $fixNoAntrian);
                        //$this->db->bind('Company', $Company);
                        $this->db->bind('shift', $shift);
                        $this->db->bind('perusahaanid', $perusahaanid);
                        $this->db->bind('idadministrasi', $idadministrasi);
                        $this->db->bind('caramasukid', $caramasukid);
                        $this->db->bind('referralid', $referralid);
                        $this->db->bind('PasienJenisDaftar', $PasienJenisDaftar);
                        $this->db->bind('admclID', $admclID);
                        $this->db->bind('admPayorName', $admPayorName);
                        $this->db->bind('admpolicyNo', $admpolicyNo);
                        $this->db->bind('admpolicyDate', $admpolicyDate);
                        $this->db->bind('admplanCode', $admplanCode);
                        $this->db->bind('admclStatus', $admclStatus);
                        $this->db->bind('admclDesc', $admclDesc);
                        $this->db->bind('admketstatus', $admketstatus);
                        $this->db->bind('admpayorMemberID', $admpayorMemberID);
                        $this->db->bind('admcoveragetype', $admcoveragetype);
                        $this->db->bind('fisioflag', $fisioflag);
                        $this->db->bind('tglregistrasi', $tglregistrasi);
                        $this->db->bind('tglregistrasi2', $tglregistrasi);
                        $this->db->bind('nosep', $nosep);
                        $this->db->bind('NoRegistrasiExist', $NoRegistrasiExist);
                        $this->db->bind('tiperegistrasi', $tiperegistrasi);
                        $this->db->bind('JamPraktek', $JamPraktek);
                        $this->db->bind('COB', $COB);
                        $this->db->execute();
                    }
                    //insert antrian
                    $this->db->query("INSERT INTO perawatanSQL.dbo.AntrianPasien 
                                            (no_transaksi,no_transaksi_reff,Doctor_1,JamPraktek,Antrian,noAntrianAll,TglKunjungan,Company)VALUES
                                            (:NoRegistrasiExist,:no_transaksi_reff,:IdDokter,:shift,:idno_urutantrian,:fixNoAntrian,
                                            :datenowcreate,:Company)");
                    $this->db->bind('NoRegistrasiExist', $NoRegistrasiExist);
                    $this->db->bind('no_transaksi_reff', $NoRegistrasiExist);
                    $this->db->bind('IdDokter', $IdDokter);
                    $this->db->bind('shift', $shift);
                    $this->db->bind('idno_urutantrian', $idno_urutantrian);
                    $this->db->bind('fixNoAntrian', $fixNoAntrian);
                    $this->db->bind('datenowcreate', $datenowcreate);
                    $this->db->bind('Company', $Company);
                    $this->db->execute();
                } else {
                    if ($JenisBayar === "2") {
                        $this->db->query("UPDATE perawatanSQL.dbo.Visit SET 
                                          LokasiPasien=:NamaGrupPerawatan,
                                          CaraBayar='0', 
                                          PatientType=:JenisBayar,Unit=:IdGrupPerawatan,Doctor_1=:IdDokter,
                                          --Company=:Company,
                                          JamPraktek=:shift,Asuransi=:perusahaanid
                                          ,idAdmin=:idadministrasi,idCaraMasuk=:caramasukid,idCaraMasuk2=:referralid,
                                          JenisDaftar=:PasienJenisDaftar
                                          ,admclID=:admclID,admPayorName=:admPayorName,admpolicyNo=:admpolicyNo,
                                          admpolicyDate=:admpolicyDate,
                                          admplanCode=:admplanCode,admclStatus=:admclStatus,
                                          admclDesc=:admclDesc,admketstatus=:admketstatus,
                                          admpayorMemberID=:admpayorMemberID,admcoveragetype=:admcoveragetype, 
                                          FisioterapiFlag=:fisioflag,TglKunjungan=:tglregistrasi,
                                          [Visit Date]=:tglregistrasi2 ,NoSEP=:nosep,
                                          Tipe_Registrasi=:tiperegistrasi,ID_JadwalPraktek=:JamPraktek,
                                          Catatan=:pxNoteRegistrasi,KodeJaminanCOB=:COB
                                          WHERE NoRegistrasi=:NoRegistrasiExist");
                        $this->db->bind('pxNoteRegistrasi', $pxNoteRegistrasi);
                        $this->db->bind('NamaGrupPerawatan', $NamaGrupPerawatan);
                        $this->db->bind('JenisBayar', $JenisBayar);
                        $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                        $this->db->bind('IdDokter', $IdDokter);
                        //$this->db->bind('Company', $Company);
                        $this->db->bind('shift', $shift);
                        $this->db->bind('perusahaanid', $perusahaanid);
                        $this->db->bind('idadministrasi', $idadministrasi);
                        $this->db->bind('caramasukid', $caramasukid);
                        $this->db->bind('referralid', $referralid);
                        $this->db->bind('PasienJenisDaftar', $PasienJenisDaftar);
                        $this->db->bind('admclID', $admclID);
                        $this->db->bind('admPayorName', $admPayorName);
                        $this->db->bind('admpolicyNo', $admpolicyNo);
                        $this->db->bind('admpolicyDate', $admpolicyDate);
                        $this->db->bind('admplanCode', $admplanCode);
                        $this->db->bind('admclStatus', $admclStatus);
                        $this->db->bind('admclDesc', $admclDesc);
                        $this->db->bind('admketstatus', $admketstatus);
                        $this->db->bind('admpayorMemberID', $admpayorMemberID);
                        $this->db->bind('admcoveragetype', $admcoveragetype);
                        $this->db->bind('fisioflag', $fisioflag);
                        $this->db->bind('tglregistrasi', $tglregistrasi);
                        $this->db->bind('tglregistrasi2', $tglregistrasi);
                        $this->db->bind('nosep', $nosep);
                        $this->db->bind('NoRegistrasiExist', $NoRegistrasiExist);
                        $this->db->bind('tiperegistrasi', $tiperegistrasi);
                        $this->db->bind('JamPraktek', $JamPraktek);
                        $this->db->bind('COB', $COB);
                        $this->db->execute();
                    } elseif ($JenisBayar <> "2") {
                        $this->db->query("UPDATE perawatanSQL.dbo.Visit SET 
                                          LokasiPasien=:NamaGrupPerawatan,
                                          CaraBayar='0', 
                                          PatientType=:JenisBayar,Unit=:IdGrupPerawatan,Doctor_1=:IdDokter,
                                          --Company=:Company,
                                          JamPraktek=:shift,Perusahaan=:perusahaanid
                                          ,idAdmin=:idadministrasi,idCaraMasuk=:caramasukid,idCaraMasuk2=:referralid,
                                          JenisDaftar=:PasienJenisDaftar
                                          ,admclID=:admclID,admPayorName=:admPayorName,admpolicyNo=:admpolicyNo,
                                          admpolicyDate=:admpolicyDate,
                                          admplanCode=:admplanCode,admclStatus=:admclStatus,
                                          admclDesc=:admclDesc,admketstatus=:admketstatus,
                                          admpayorMemberID=:admpayorMemberID,admcoveragetype=:admcoveragetype, 
                                          FisioterapiFlag=:fisioflag,TglKunjungan=:tglregistrasi,
                                          [Visit Date]=:tglregistrasi2 ,NoSEP=:nosep,Tipe_Registrasi=:tiperegistrasi,
                                          ID_JadwalPraktek=:JamPraktek,
                                          Catatan=:pxNoteRegistrasi,KodeJaminanCOB=:COB
                                          WHERE NoRegistrasi=:NoRegistrasiExist");
                        $this->db->bind('pxNoteRegistrasi', $pxNoteRegistrasi);
                        $this->db->bind('JamPraktek', $JamPraktek);
                        $this->db->bind('NamaGrupPerawatan', $NamaGrupPerawatan);
                        $this->db->bind('JenisBayar', $JenisBayar);
                        $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                        $this->db->bind('IdDokter', $IdDokter);
                        //$this->db->bind('Company', $Company);
                        $this->db->bind('shift', $shift);
                        $this->db->bind('perusahaanid', $perusahaanid);
                        $this->db->bind('idadministrasi', $idadministrasi);
                        $this->db->bind('caramasukid', $caramasukid);
                        $this->db->bind('referralid', $referralid);
                        $this->db->bind('PasienJenisDaftar', $PasienJenisDaftar);
                        $this->db->bind('admclID', $admclID);
                        $this->db->bind('admPayorName', $admPayorName);
                        $this->db->bind('admpolicyNo', $admpolicyNo);
                        $this->db->bind('admpolicyDate', $admpolicyDate);
                        $this->db->bind('admplanCode', $admplanCode);
                        $this->db->bind('admclStatus', $admclStatus);
                        $this->db->bind('admclDesc', $admclDesc);
                        $this->db->bind('admketstatus', $admketstatus);
                        $this->db->bind('admpayorMemberID', $admpayorMemberID);
                        $this->db->bind('admcoveragetype', $admcoveragetype);
                        $this->db->bind('fisioflag', $fisioflag);
                        $this->db->bind('tglregistrasi', $tglregistrasi);
                        $this->db->bind('tglregistrasi2', $tglregistrasi);
                        $this->db->bind('nosep', $nosep);
                        $this->db->bind('NoRegistrasiExist', $NoRegistrasiExist);
                        $this->db->bind('tiperegistrasi', $tiperegistrasi);
                        $this->db->bind('JamPraktek', $JamPraktek);
                        $this->db->bind('COB', $COB);
                        $this->db->execute();
                    }
                }
                // INSERT ULANG ADMINISTRASI
                // Insert administrasi 
                // Insert Administrasi
                $this->db->query("INSERT INTO  PerawatanSQL.dbo.[Visit Details] ( ProductID, NamaProduct, Quantity, Tarif, TotalTarif, 
                  JasaDokter,Discount, StatusID, Aproved, KategoriTarif, Lunas, NoRegistrasi, NoMR, NoEpisode,Tanggal )
                  SELECT ID, Nama_Karcis, 1 AS Quantity, Nilai_Karcis, '$nilaiadministrasifix' AS [fixtarif], 0 AS Expr1, 
                  '$adminmindisc' AS diskonjaminanx, 1 AS Expr3, 0 AS Expr4, 
                  'Administrasi' AS Admin, 0 AS Expr6, '$NoRegistrasiExist' AS xNoreg, 
                  '$NoMrfix' AS NoMR, '$NoEpisodeExist' AS xNoEpisode,'$tglregistrasi'
                  FROM MasterdataSQL.dbo.MstrKarcisAdministrasi
                  WHERE ID=:idadministrasi");
                $this->db->bind('idadministrasi', $idadministrasi);
                $this->db->execute();

                $this->db->query("UPDATE MedicalRecord.DBO.EMR_RWJ_TTV 
                                SET Dokter=:NamaDokter
                                where noregistrasi=:NoRegistrasiExist and GroupUser='Perawat Poli' and TTV='1'");
                $this->db->bind('NamaDokter', $NamaDokter);
                $this->db->bind('NoRegistrasiExist', $NoRegistrasiExist);
                $this->db->execute();

                //UPDATE DASHBOARD RWJ

                // //GET NAMACARAMASUK
                $querry = "SELECT NamaCaraMasuk
                    from MasterdataSQL.dbo.MstrCaraMasuk
                    where id=:caramasukid";
                $this->db->query($querry);
                $this->db->bind('caramasukid', $caramasukid);
                $dataf =  $this->db->single();
                $NamaCaraMasuk = $dataf['NamaCaraMasuk'];

                $this->db->query("UPDATE DashboardData.dbo.dataRWJ
                                SET TipePasien=:JenisBayar,
                                KodeJaminan=:perusahaanid,
                                NamaJaminan=:shownamaperusahaanfix,
                                IdUnit=:IdGrupPerawatan,
                                NamaUnit=:NamaGrupPerawatan,
                                IdDokter=:IdDokter,
                                NamaDokter=:NamaDokter,
                                NoSEP=:nosep,
                                JamPraktek=:shift,
                                Tipe_Registrasi=:tiperegistrasi,
                                Id_Jadwal_Praktek=:JamPraktek,
                                idCaraMasuk=:caramasukid,
                                idCaraMasuk2=:referralid,
                                idAdmin=:idadministrasi,
                               -- Company=:Company,
                                NamaCaraMasuk=:NamaCaraMasuk,
                                NamaCaraMasukRef=:showrefferalfix,
                                NamaKarcis=:Nama_Karcis,
                                NilaiKarcis=:Nilai_Karcis
                                where NoRegistrasi=:NoRegistrasiExist");
                $this->db->bind('JenisBayar', $JenisBayar);
                $this->db->bind('perusahaanid', $perusahaanid);
                $this->db->bind('shownamaperusahaanfix', $shownamaperusahaanfix);
                $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                $this->db->bind('NamaGrupPerawatan', $NamaGrupPerawatan);
                $this->db->bind('IdDokter', $IdDokter);
                $this->db->bind('NamaDokter', $NamaDokter);
                $this->db->bind('nosep', $nosep);
                $this->db->bind('shift', $shift);
                $this->db->bind('tiperegistrasi', $tiperegistrasi);
                $this->db->bind('JamPraktek', $JamPraktek);
                $this->db->bind('caramasukid', $caramasukid);
                $this->db->bind('referralid', $referralid);
                $this->db->bind('idadministrasi', $idadministrasi);
                // $this->db->bind('Company', $Company);
                $this->db->bind('NamaCaraMasuk', $NamaCaraMasuk);
                $this->db->bind('showrefferalfix', $showrefferalfix);
                $this->db->bind('Nama_Karcis', $Nama_Karcis);
                $this->db->bind('Nilai_Karcis', $Nilai_Karcis);
                $this->db->bind('NoRegistrasiExist', $NoRegistrasiExist);
                $this->db->execute();


                $this->db->commit();
                $callback = array(
                    'status' => 'success',
                    'NoEpisode' => $NoEpisodeExist,
                    'NoRegistrasi' => $NoRegistrasiExist,
                    'IdDokter' => $IdDokter,
                    'DokterName' => $NamaDokter,
                    'IdPoli' => $IdGrupPerawatan,
                    'PoliName' => $NamaGrupPerawatan,
                    'NoMR' => $NoMrfix,
                    'Namapasien' => $namapasien,
                    'JenisBayar' => $JenisBayar,
                );
                return $callback;
            } else {  // JIKA TIDAK ADA NO REGISTRASI



                // cari no antrian dari no Booking
                $this->db->query("SELECT NoAntrianAll,Antrian 
                            from PerawatanSQL.dbo.Apointment 
                            where NoBooking=:NoReservasi");
                $this->db->bind('NoReservasi', $NoReservasi);
                $data =  $this->db->single();
                $AntrianReservasi = $data['Antrian'];
                $NoAntrianAllReservasi = $data['NoAntrianAll'];

                // Cari Nilai Paling terakhir dari tabel Visit
                $this->db->query("SELECT max(ID) as urut from PerawatanSQL.dbo.Visit ");
                $data =  $this->db->single();
                $no_pass = $data['urut'];
                $id = $no_pass;
                $id++;
                if ($CodeRegis == "RJ") {
                    // creeate jenis registrasinya
                    if ($JenisBayar == "1") {
                        $kodeRegAwalXX = "RJUM";
                    } else if ($JenisBayar == "2") {
                        $kodeRegAwalXX = "RJAS";
                    } else if ($JenisBayar == "5") {
                        $kodeRegAwalXX = "RJJP";
                    }
                } elseif ($CodeRegis == "RJUL") {
                    $kodeRegAwalXX = "RJUL";
                } elseif ($CodeRegis == "RJUR") {
                    $kodeRegAwalXX = "RJUR";
                }
                if ($iswalkin == 'WALKIN') { //CONVERT No. Mr
                    $idkanan = substr($NoMr, 5); // xx-xx-03 kanan
                    $idtengah = substr($NoMr, 3, -2); //
                    $idkiri = substr($NoMr, 1, -4);
                    $idwalkin = substr($NoMr, 0, -6);
                    $NoMrfix =   $idwalkin . '-' . $idkiri . $idtengah . $idkanan;
                } else {
                    //CONVERT No. Mr
                    $idkanan = substr($NoMr, 4); // xx-xx-03 kanan
                    $idtengah = substr($NoMr, 2, -2); //
                    $idkiri = substr($NoMr, 0, -4);
                    $NoMrfix =   $idkiri . '-' . $idtengah . '-' . $idkanan;
                }

                // CEK REGISTRASI ADA YANG AKTIF ??? 
                $this->db->query("SELECT  top 1  [Status ID],NoEpisode 
                                from  perawatanSQL.dbo.Visit  
                                where NoMR =:NoMrfix and batal='0' and [Status ID]<>'4'  ");
                $this->db->bind('NoMrfix', $NoMrfix);
                $data =  $this->db->single();
                if ($data) { // Jika ada Registrasi Yang Aktif
                    $NoEpisode = $data['NoEpisode'];
                    $datenow2 = date('Y-m-d', strtotime($datenowcreate));
                    $uuidkemenkes = Utils::uuid4str();
                    $this->db->query("SELECT  TOP 1 NoRegistrasi,right( REPLACE(NoRegistrasi,'-','0') ,4) as urutregx
                                    FROM PerawatanSQL.dbo.Visit  WHERE  
                                    replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-')=:datenow2 
                                    AND LEFT(NoRegistrasi,4)=:kodeRegAwalXX  
                                    ORDER BY id DESC");
                    $this->db->bind('datenow2', $datenow2);
                    $this->db->bind('kodeRegAwalXX', $kodeRegAwalXX);
                    $data =  $this->db->single();
                    //no urut reg
                    $no_reg = $data['urutregx'];
                    $idReg = $no_reg;
                    $idReg++;

                    $awalOp = "OP";
                    $tenganOp = $NoMr;
                    $datenow = date('dmy', strtotime($datenowcreate));

                    // GENERATE NO REGISTRASI
                    $nourutfixReg = Utils::generateAutoNumberFourDigit($idReg);
                    if ($CodeRegis == "RJ") {
                        if ($JenisBayar == "1") {
                            $kodeRegAwal = "RJUM";
                        } else if ($JenisBayar == "2") {
                            $kodeRegAwal = "RJAS";
                        } else if ($JenisBayar == "5") {
                            $kodeRegAwal = "RJJP";
                        }
                    } elseif ($CodeRegis == "RJUL") {
                        $kodeRegAwal = "RJUL";
                    } elseif ($CodeRegis == "RJUR") {
                        $kodeRegAwal = "RJUR";
                    }
                    $nofixReg = $kodeRegAwal . $datenow . '-' . $nourutfixReg;
                    // GENERATE NO ANTRIAN POLI
                    $this->db->query("SELECT max(Antrian) as urutantrian
                                from PerawatanSQL.dbo.AntrianPasien  where  
                                replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-')=:datenow2 
                                and JamPraktek=:shift and Doctor_1=:IdDokter ");
                    $this->db->bind('datenow2', $datenow2);
                    $this->db->bind('shift', $shift);
                    $this->db->bind('IdDokter', $IdDokter);
                    $data =  $this->db->single();
                    //no urut reg
                    $no_urutantrian = $data['urutantrian'];
                    $idno_urutantrian = $no_urutantrian;
                    $idno_urutantrian++;

                    // CARI KODE ANTRIAN DOKTER
                    $this->db->query("SELECT *from MasterdataSQL.dbo.Doctors  where ID=:IdDokter ");
                    $this->db->bind('IdDokter', $IdDokter);
                    $data =  $this->db->single();
                    // no antrian
                    $CodeAntrian = $data['CodeAntrian'];

                    // fix no antrian
                    $fixNoAntrian = $CodeAntrian . '-' . $idno_urutantrian;


                    $this->db->query("SELECT  top 1  [Status ID],NoEpisode,NoRegistrasi 
                                    from  perawatanSQL.dbo.Visit  
                                    where NoMR =:NoMrfix and [Status ID]<>'4' 
                                    and unit=:IdGrupPerawatan and Doctor_1=:IdDokter 
                                    and JamPraktek=:shift 
                                    and replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-')=:datenow2 
                                    and Batal='0'");
                    $this->db->bind('NoMrfix', $NoMrfix);
                    $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                    $this->db->bind('IdDokter', $IdDokter);
                    $this->db->bind('shift', $shift);
                    $this->db->bind('datenow2', $datenow2);
                    $data =  $this->db->single();
                    if ($data) {
                        $dataidregfieedback = $data['NoRegistrasi'];
                        $callback = array(
                            'status' => "warning",
                            'errorname' => "Sudah ada reg aktif : " . $dataidregfieedback, // Set array nama dengan isi kolom nama pada tabel siswa
                            'errormessage' => $dataidregfieedback,
                            // 'nama' => $data['nama'], // Set array nama dengan isi kolom nama pada tabel siswa    
                        );

                        return $callback;
                    } else {
                        if ($JenisBayar === "2") { // ASURANSI 
                            //INSERT KE TABEL REGISTRASI
                            if ($NoReservasi <> "") {
                                $this->db->query("INSERT INTO perawatanSQL.dbo.Visit (ID,NoEpisode,NoRegistrasi,LokasiPasien,
                                CaraBayar,NoMR ,
                                PatientType,Unit,Doctor_1,Antrian,NoAntrianAll,Company,JamPraktek,Asuransi,Operator
                                ,idAdmin,idCaraMasuk,idCaraMasuk2,JenisDaftar
                                ,admclID,admPayorName,admpolicyNo,admpolicyDate,
                                admplanCode,admclStatus,admclDesc,admketstatus,admpayorMemberID,admcoveragetype,
                                FisioterapiFlag,TglKunjungan,[Visit Date],NoSEP,Tipe_Registrasi,ID_JadwalPraktek,
                                  Catatan,KodeJaminanCOB,idRegKemenkes
                                ) VALUES (:id,:NoEpisode,:nofixReg,:NamaGrupPerawatan,
                               :nullable,:NoMrfix,
                                :JenisBayar,:IdGrupPerawatan,:IdDokter,:AntrianReservasi,:NoAntrianAllReservasi,:Company,:shift,:perusahaanid,:operator
                                ,:idadministrasi,:caramasukid,:referralid,:PasienJenisDaftar 
                                ,:admclID,:admPayorName,:admpolicyNo,:admpolicyDate,
                                :admplanCode,:admclStatus,:admclDesc,:admketstatus,:admpayorMemberID,:admcoveragetype,
                                :fisioflag,:tglregistrasi,:tglregistrasi2,:nosep,:tiperegistrasi,:JamPraktek,
                                :pxNoteRegistrasi,:COB,:uuidkemenkes)");
                                $this->db->bind('id', $id);
                                $this->db->bind('NoEpisode', $NoEpisode);
                                $this->db->bind('nofixReg', $nofixReg);
                                $this->db->bind('NamaGrupPerawatan', $NamaGrupPerawatan);
                                $this->db->bind('nullable', $nullable);
                                $this->db->bind('NoMrfix', $NoMrfix);
                                $this->db->bind('JenisBayar', $JenisBayar);
                                $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                                $this->db->bind('IdDokter', $IdDokter);
                                $this->db->bind('AntrianReservasi', $AntrianReservasi);
                                $this->db->bind('NoAntrianAllReservasi', $NoAntrianAllReservasi);
                                $this->db->bind('Company', $Company);
                                $this->db->bind('shift', $shift);
                                $this->db->bind('perusahaanid', $perusahaanid);
                                $this->db->bind('operator', $operator);
                                $this->db->bind('idadministrasi', $idadministrasi);
                                $this->db->bind('caramasukid', $caramasukid);
                                $this->db->bind('referralid', $referralid);
                                $this->db->bind('PasienJenisDaftar', $PasienJenisDaftar);
                                $this->db->bind('admclID', $admclID);
                                $this->db->bind('admPayorName', $admPayorName);
                                $this->db->bind('admpolicyNo', $admpolicyNo);
                                $this->db->bind('admpolicyDate', $admpolicyDate);
                                $this->db->bind('admplanCode', $admplanCode);
                                $this->db->bind('admclStatus', $admclStatus);
                                $this->db->bind('admclDesc', $admclDesc);
                                $this->db->bind('admketstatus', $admketstatus);
                                $this->db->bind('admpayorMemberID', $admpayorMemberID);
                                $this->db->bind('admcoveragetype', $admcoveragetype);
                                $this->db->bind('fisioflag', $fisioflag);
                                $this->db->bind('tglregistrasi', $tglregistrasi);
                                $this->db->bind('tglregistrasi2', $tglregistrasi);
                                $this->db->bind('nosep', $nosep);
                                $this->db->bind('tiperegistrasi', $tiperegistrasi);
                                $this->db->bind('JamPraktek', $JamPraktek);
                                $this->db->bind('pxNoteRegistrasi', $pxNoteRegistrasi);
                                $this->db->bind('COB', $COB);
                                $this->db->bind('uuidkemenkes', $uuidkemenkes); 
                                $this->db->execute();

                                //      //INSERT ke DataRWJ 14-03-2023
                                // //GET DATA PASIEN
                                // $this->db->query("SELECT PatientName,
                                // KelurahanName,KecamatanName,CityName,ProvinceName,Gander,replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as Date_of_birth,Tipe_Idcard,ID_Card_number,Address,Marital_status,Religion,
                                // Education,[Home Phone],[Mobile Phone],Ocupation,[ZIP/Postal Code] as PostalCode
                                // ,Bahasa,Etnis,replace(CONVERT(VARCHAR(11), InputDate, 111), '/','-') as InputDate
                                // from MasterdataSQL.dbo.Admision 
                                // where  NoMR=:NoMrfix
                                // UNION ALL
                                // SELECT PatientName,
                                // KelurahanName,KecamatanName,CityName,ProvinceName,Gander,replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as Date_of_birth,Tipe_Idcard,ID_Card_number,Address,Marital_status,Religion,
                                // Education,[Home Phone],[Mobile Phone],Ocupation,[ZIP/Postal Code] as PostalCode
                                // ,Bahasa,Etnis,replace(CONVERT(VARCHAR(11), InputDate, 111), '/','-') as InputDate
                                // from MasterdataSQL.dbo.Admision_walkin 
                                // where  NoMR=:NoMrfix2");
                                // $this->db->bind('NoMrfix', $NoMrfix);
                                // $this->db->bind('NoMrfix2', $NoMrfix);
                                // $datag =  $this->db->single();
                                // $PatientName = $datag['PatientName'];
                                // $KelurahanName = $datag['KelurahanName'];
                                // $KecamatanName = $datag['KecamatanName'];
                                // $CityName = $datag['CityName'];
                                // $ProvinceName = $datag['ProvinceName'];
                                // $Gander = $datag['Gander'];
                                // $Date_of_birth = $datag['Date_of_birth'];
                                // $Tipe_Idcard = $datag['Tipe_Idcard'];
                                // $ID_Card_number = $datag['ID_Card_number'];
                                // $Address = $datag['Address'];
                                // $Marital_status = $datag['Marital_status'];
                                // $Religion = $datag['Religion'];
                                // $Education = $datag['Education'];
                                // $HomePhone = $datag['Home Phone'];
                                // $MobilePhone = $datag['Mobile Phone'];
                                // $Ocupation = $datag['Ocupation'];
                                // $PostalCode = $datag['PostalCode'];
                                // $Bahasa = $datag['Bahasa'];
                                // $Etnis = $datag['Etnis'];
                                // $InputDate = $datag['InputDate'];

                                // //GET CARA MASUK
                                // $querry = "SELECT NamaCaraMasuk
                                //     from MasterdataSQL.dbo.MstrCaraMasuk
                                //     where id=:caramasukid";
                                // $this->db->query($querry);
                                // $this->db->bind('caramasukid', $caramasukid);
                                // $dataf =  $this->db->single();
                                // $NamaCaraMasuk = $dataf['NamaCaraMasuk']; 

                                // // GET DATA KARCIS
                                //     $this->db->query("SELECT ID, Nama_Karcis,Nilai_Karcis
                                //     from MasterdataSQL.dbo.MstrKarcisAdministrasi  
                                //     where  ID=:idadministrasi");
                                // $this->db->bind('idadministrasi', $idadministrasi);
                                // $data =  $this->db->single();
                                // $Nama_Karcis = $data['Nama_Karcis'];
                                // $Nilai_Karcis = $data['Nilai_Karcis'];

                                // if (strtotime($tglregistrasi_Ymd) > strtotime($InputDate)){
                                //     $BL = 'LAMA';
                                // }else{
                                //     $BL = 'BARU';
                                // }

                                // $this->db->query("INSERT INTO DashboardData.dbo.DataRWJ (NoEpisode,NoRegistrasi,NoMR,PatientName,[Visit Date],
                                // Kelurahan,Kecamatan,kabupatenNama,ProvinsiNama,BL,TipePasien,FP,
                                // KodeJaminan,NamaJaminan,Sex,DateOfBirth,TipeIdCard, NoIdCard, Address,MaritalStatus,Religion,
                                // Education,HomePhone,MobilePhone,Pekerjaan,KodePos,IdUnit,NamaUnit,IdDokter,NamaDokter,
                                // NoPesertaBPJS,NoSep,JamPraktek,StatusID,OperatorId,
                                // Lockbill,JenisDaftar,Telemedicine,Appointment_ID,Tipe_Registrasi,Id_Jadwal_Praktek,
                                // idCaraMasuk,idCaraMasuk2,idAdmin,NoAntrianAll,Company,NamaCaraMasuk,NamaCaraMasukRef,NamaKarcis,NilaiKarcis,hosnamedata,datatimestamp,Bahasa,Etnis
                                // ) VALUES ( :NoEpisode, :nofixReg,:NoMrfix,:PatientName,:tglregistrasi,
                                //         :KelurahanName,:KecamatanName,:CityName,:ProvinceName,
                                //         :BL
                                //         ,:JenisBayar,'1',
                                //         :perusahaanid,:NamaPerusahaan,:Gander,:Date_of_birth,:Tipe_Idcard,:ID_Card_number,:Address,:Marital_status,:Religion,
                                //         :Education,:HomePhone,:MobilePhone,:Ocupation,:PostalCode
                                //         ,:IdGrupPerawatan,:NamaGrupPerawatan,:IdDokter,:NamaDokter,
                                //         :NoPesertaBPJS,:nosep,:shift,:StatusID,:operator,
                                //         :LockBill,:PasienJenisDaftar,:TelemedicineIs,:appointment_id,:tiperegistrasi,:JamPraktek,
                                //         :caramasukid,:referralid,:idadministrasi,:fixNoAntrian,:Company,:NamaCaraMasuk,:NamaCaraMasukRef,:Nama_Karcis,:Nilai_Karcis,host_name(),:datenowcreate
                                //         ,:Bahasa,:Etnis)
                                //         ");
                                // $this->db->bind('NoEpisode', $NoEpisode);
                                // $this->db->bind('nofixReg', $nofixReg);
                                // $this->db->bind('NoMrfix', $NoMrfix);
                                // $this->db->bind('PatientName', $PatientName);
                                // $this->db->bind('tglregistrasi', $tglregistrasi);
                                // $this->db->bind('KelurahanName', $KelurahanName);
                                // $this->db->bind('KecamatanName', $KecamatanName);
                                // $this->db->bind('CityName', $CityName);
                                // $this->db->bind('ProvinceName', $ProvinceName);
                                // $this->db->bind('BL', $BL);
                                // $this->db->bind('JenisBayar', $JenisBayar);
                                // $this->db->bind('perusahaanid', $perusahaanid);
                                // $this->db->bind('NamaPerusahaan', $shownamaperusahaanfix);
                                // $this->db->bind('Gander', $Gander);
                                // $this->db->bind('Date_of_birth', $Date_of_birth);
                                // $this->db->bind('Tipe_Idcard', $Tipe_Idcard);
                                // $this->db->bind('ID_Card_number', $ID_Card_number);
                                // $this->db->bind('Address', $Address);
                                // $this->db->bind('Marital_status', $Marital_status);
                                // $this->db->bind('Religion', $Religion);
                                // $this->db->bind('Education', $Education);
                                // $this->db->bind('HomePhone', $HomePhone);
                                // $this->db->bind('MobilePhone', $MobilePhone);
                                // $this->db->bind('Ocupation', $Ocupation);
                                // $this->db->bind('PostalCode', $PostalCode);
                                // $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                                // $this->db->bind('NamaGrupPerawatan', $NamaGrupPerawatan);
                                // $this->db->bind('IdDokter', $IdDokter);
                                // $this->db->bind('NamaDokter', $NamaDokter);
                                // $this->db->bind('NoPesertaBPJS', null);
                                // $this->db->bind('nosep', $nosep);
                                // $this->db->bind('shift', $shift);
                                // $this->db->bind('StatusID', '0');
                                // $this->db->bind('operator', $operator);
                                // $this->db->bind('LockBill', '0');
                                // $this->db->bind('PasienJenisDaftar', $PasienJenisDaftar);
                                // $this->db->bind('TelemedicineIs', '0');
                                // $this->db->bind('appointment_id', null);
                                // $this->db->bind('tiperegistrasi', $tiperegistrasi);
                                // $this->db->bind('JamPraktek', $JamPraktek);
                                // $this->db->bind('caramasukid', $caramasukid);
                                // $this->db->bind('referralid', $referralid);
                                // $this->db->bind('idadministrasi', $idadministrasi);
                                // $this->db->bind('fixNoAntrian', $fixNoAntrian);
                                // $this->db->bind('Company', $Company);
                                // $this->db->bind('NamaCaraMasuk', $NamaCaraMasuk);
                                // $this->db->bind('NamaCaraMasukRef', $showrefferalfix);
                                // $this->db->bind('Nama_Karcis', $Nama_Karcis);
                                // $this->db->bind('Nilai_Karcis', $Nilai_Karcis);
                                // $this->db->bind('Bahasa', $Bahasa);
                                // $this->db->bind('Etnis', $Etnis);
                                // $this->db->bind('datenowcreate', $datenowcreate);
                                // $this->db->execute(); 
                                // // //---#END INSERT DATARWJ
                                //Update Nomor Registrasi EMR_OrderOperasi
                                if ($idodc <> '') {
                                    //Update NoEpisode ODC
                                    $this->db->query("SELECT NoEpisode
                            from MedicalRecord.dbo.MR_PermintaanRawat_ODC
                            where  ID=:idodc");
                                    $this->db->bind('idodc', $idodc);
                                    $data =  $this->db->single();
                                    $NoEpisode_odc = $data['NoEpisode'];

                                    // UPDATE TABEL Visit No Episode
                                    $this->db->query("UPDATE PerawatanSQL.dbo.Visit
                        SET NoEpisode=:NoEpisode_odc where NoRegistrasi=:nofixReg");
                                    $this->db->bind('nofixReg', $nofixReg);
                                    $this->db->bind('NoEpisode_odc', $NoEpisode_odc);
                                    $this->db->execute();

                                    // UPDATE TABEL EMR_ORDEROPERASI
                                    $this->db->query("UPDATE MedicalRecord.dbo.EMR_OrderOperasi
                            SET NoRegistrasi=:nofixReg where NoRegistrasi in (SELECT NoRegistrasi FROM MedicalRecord.dbo.MR_PermintaanRawat_ODC WHERE ID=:idodc) and StatusOrder not in('Close' , 'Batal', 'cancel') ");
                                    $this->db->bind('nofixReg', $nofixReg);
                                    $this->db->bind('idodc', $idodc);
                                    $this->db->execute();

                                    // UPDATE TABEL MR_PermintaanRawat_ODC
                                    $this->db->query("UPDATE MedicalRecord.dbo.MR_PermintaanRawat_ODC
                            SET StatusRegis='1' where ID=:idodc");
                                    $this->db->bind('idodc', $idodc);
                                    $this->db->execute();


                                    // // UPDATE TABEL EMR_ORDEROPERASI
                                    // $this->db->query("UPDATE MedicalRecord.dbo.MR_LaporanOperasi
                                    //  SET NoRegistrasi=:nofinalreg where NoRegistrasi=:noregisrwj");
                                    // $this->db->bind('nofinalreg', $nofinalreg);
                                    // $this->db->bind('noregisrwj', $noregisrwj);
                                    // $this->db->execute();
                                    //#END Update Nomor Registrasi EMR_OrderOperasi
                                }
                            } elseif ($NoReservasi == "") {
                                $this->db->query("INSERT INTO perawatanSQL.dbo.Visit (ID,NoEpisode,NoRegistrasi,LokasiPasien,
                                CaraBayar,NoMR ,
                                PatientType,Unit,Doctor_1,Antrian,NoAntrianAll,Company,JamPraktek,Asuransi,Operator
                                ,idAdmin,idCaraMasuk,idCaraMasuk2,JenisDaftar
                                ,admclID,admPayorName,admpolicyNo,admpolicyDate,
                                admplanCode,admclStatus,admclDesc,admketstatus,admpayorMemberID,admcoveragetype,
                                FisioterapiFlag,TglKunjungan,[Visit Date],NoSEP,Tipe_Registrasi,ID_JadwalPraktek,
                                Catatan,KodeJaminanCOB,idRegKemenkes
                                ) VALUES (:id,:NoEpisode,:nofixReg,:NamaGrupPerawatan,
                               :nullable,:NoMrfix,
                                :JenisBayar,:IdGrupPerawatan,:IdDokter,:idno_urutantrian,:fixNoAntrian,:Company,:shift,:perusahaanid,:operator
                                ,:idadministrasi,:caramasukid,:referralid,:PasienJenisDaftar 
                                ,:admclID,:admPayorName,:admpolicyNo,:admpolicyDate,
                                :admplanCode,:admclStatus,:admclDesc,:admketstatus,:admpayorMemberID,
                                :admcoveragetype,:fisioflag,:tglregistrasi,:tglregistrasi2,:nosep,:tiperegistrasi,:JamPraktek,
                                 :pxNoteRegistrasi,:COB,:uuidkemenkes)");
                                $this->db->bind('id', $id);
                                $this->db->bind('NoEpisode', $NoEpisode);
                                $this->db->bind('pxNoteRegistrasi', $pxNoteRegistrasi);
                                $this->db->bind('nofixReg', $nofixReg);
                                $this->db->bind('NamaGrupPerawatan', $NamaGrupPerawatan);
                                $this->db->bind('nullable', $nullable);
                                $this->db->bind('NoMrfix', $NoMrfix);
                                $this->db->bind('JenisBayar', $JenisBayar);
                                $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                                $this->db->bind('IdDokter', $IdDokter);
                                $this->db->bind('idno_urutantrian', $idno_urutantrian);
                                $this->db->bind('fixNoAntrian', $fixNoAntrian);
                                $this->db->bind('Company', $Company);
                                $this->db->bind('shift', $shift);
                                $this->db->bind('perusahaanid', $perusahaanid);
                                $this->db->bind('operator', $operator);
                                $this->db->bind('idadministrasi', $idadministrasi);
                                $this->db->bind('caramasukid', $caramasukid);
                                $this->db->bind('referralid', $referralid);
                                $this->db->bind('PasienJenisDaftar', $PasienJenisDaftar);
                                $this->db->bind('admclID', $admclID);
                                $this->db->bind('admPayorName', $admPayorName);
                                $this->db->bind('admpolicyNo', $admpolicyNo);
                                $this->db->bind('admpolicyDate', $admpolicyDate);
                                $this->db->bind('admplanCode', $admplanCode);
                                $this->db->bind('admclStatus', $admclStatus);
                                $this->db->bind('admclDesc', $admclDesc);
                                $this->db->bind('admketstatus', $admketstatus);
                                $this->db->bind('admpayorMemberID', $admpayorMemberID);
                                $this->db->bind('admcoveragetype', $admcoveragetype);
                                $this->db->bind('fisioflag', $fisioflag);
                                $this->db->bind('tglregistrasi', $tglregistrasi);
                                $this->db->bind('tglregistrasi2', $tglregistrasi);
                                $this->db->bind('nosep', $nosep);
                                $this->db->bind('tiperegistrasi', $tiperegistrasi);
                                $this->db->bind('JamPraktek', $JamPraktek);
                                $this->db->bind('COB', $COB);
                                $this->db->bind('uuidkemenkes', $uuidkemenkes); 
                                $this->db->execute();

                                //      //INSERT ke DataRWJ 14-03-2023
                                // //GET DATA PASIEN
                                // $this->db->query("SELECT PatientName,
                                // KelurahanName,KecamatanName,CityName,ProvinceName,Gander,replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as Date_of_birth,Tipe_Idcard,ID_Card_number,Address,Marital_status,Religion,
                                // Education,[Home Phone],[Mobile Phone],Ocupation,[ZIP/Postal Code] as PostalCode
                                // ,Bahasa,Etnis,replace(CONVERT(VARCHAR(11), InputDate, 111), '/','-') as InputDate
                                // from MasterdataSQL.dbo.Admision 
                                // where  NoMR=:NoMrfix
                                // UNION ALL
                                // SELECT PatientName,
                                // KelurahanName,KecamatanName,CityName,ProvinceName,Gander,replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as Date_of_birth,Tipe_Idcard,ID_Card_number,Address,Marital_status,Religion,
                                // Education,[Home Phone],[Mobile Phone],Ocupation,[ZIP/Postal Code] as PostalCode
                                // ,Bahasa,Etnis,replace(CONVERT(VARCHAR(11), InputDate, 111), '/','-') as InputDate
                                // from MasterdataSQL.dbo.Admision_walkin 
                                // where  NoMR=:NoMrfix2");
                                // $this->db->bind('NoMrfix', $NoMrfix);
                                // $this->db->bind('NoMrfix2', $NoMrfix);
                                // $datag =  $this->db->single();
                                // $PatientName = $datag['PatientName'];
                                // $KelurahanName = $datag['KelurahanName'];
                                // $KecamatanName = $datag['KecamatanName'];
                                // $CityName = $datag['CityName'];
                                // $ProvinceName = $datag['ProvinceName'];
                                // $Gander = $datag['Gander'];
                                // $Date_of_birth = $datag['Date_of_birth'];
                                // $Tipe_Idcard = $datag['Tipe_Idcard'];
                                // $ID_Card_number = $datag['ID_Card_number'];
                                // $Address = $datag['Address'];
                                // $Marital_status = $datag['Marital_status'];
                                // $Religion = $datag['Religion'];
                                // $Education = $datag['Education'];
                                // $HomePhone = $datag['Home Phone'];
                                // $MobilePhone = $datag['Mobile Phone'];
                                // $Ocupation = $datag['Ocupation'];
                                // $PostalCode = $datag['PostalCode'];
                                // $Bahasa = $datag['Bahasa'];
                                // $Etnis = $datag['Etnis'];
                                // $InputDate = $datag['InputDate'];

                                // //GET CARA MASUK
                                // $querry = "SELECT NamaCaraMasuk
                                //     from MasterdataSQL.dbo.MstrCaraMasuk
                                //     where id=:caramasukid";
                                // $this->db->query($querry);
                                // $this->db->bind('caramasukid', $caramasukid);
                                // $dataf =  $this->db->single();
                                // $NamaCaraMasuk = $dataf['NamaCaraMasuk']; 

                                // // GET DATA KARCIS
                                //     $this->db->query("SELECT ID, Nama_Karcis,Nilai_Karcis
                                //     from MasterdataSQL.dbo.MstrKarcisAdministrasi  
                                //     where  ID=:idadministrasi");
                                // $this->db->bind('idadministrasi', $idadministrasi);
                                // $data =  $this->db->single();
                                // $Nama_Karcis = $data['Nama_Karcis'];
                                // $Nilai_Karcis = $data['Nilai_Karcis'];

                                // if (strtotime($tglregistrasi_Ymd) > strtotime($InputDate)){
                                //     $BL = 'LAMA';
                                // }else{
                                //     $BL = 'BARU';
                                // }

                                // $this->db->query("INSERT INTO DashboardData.dbo.DataRWJ (NoEpisode,NoRegistrasi,NoMR,PatientName,[Visit Date],
                                // Kelurahan,Kecamatan,kabupatenNama,ProvinsiNama,BL,TipePasien,FP,
                                // KodeJaminan,NamaJaminan,Sex,DateOfBirth,TipeIdCard, NoIdCard, Address,MaritalStatus,Religion,
                                // Education,HomePhone,MobilePhone,Pekerjaan,KodePos,IdUnit,NamaUnit,IdDokter,NamaDokter,
                                // NoPesertaBPJS,NoSep,JamPraktek,StatusID,OperatorId,
                                // Lockbill,JenisDaftar,Telemedicine,Appointment_ID,Tipe_Registrasi,Id_Jadwal_Praktek,
                                // idCaraMasuk,idCaraMasuk2,idAdmin,NoAntrianAll,Company,NamaCaraMasuk,NamaCaraMasukRef,NamaKarcis,NilaiKarcis,hosnamedata,datatimestamp,Bahasa,Etnis
                                // ) VALUES ( :NoEpisode, :nofixReg,:NoMrfix,:PatientName,:tglregistrasi,
                                //         :KelurahanName,:KecamatanName,:CityName,:ProvinceName,
                                //         :BL
                                //         ,:JenisBayar,'1',
                                //         :perusahaanid,:NamaPerusahaan,:Gander,:Date_of_birth,:Tipe_Idcard,:ID_Card_number,:Address,:Marital_status,:Religion,
                                //         :Education,:HomePhone,:MobilePhone,:Ocupation,:PostalCode
                                //         ,:IdGrupPerawatan,:NamaGrupPerawatan,:IdDokter,:NamaDokter,
                                //         :NoPesertaBPJS,:nosep,:shift,:StatusID,:operator,
                                //         :LockBill,:PasienJenisDaftar,:TelemedicineIs,:appointment_id,:tiperegistrasi,:JamPraktek,
                                //         :caramasukid,:referralid,:idadministrasi,:fixNoAntrian,:Company,:NamaCaraMasuk,:NamaCaraMasukRef,:Nama_Karcis,:Nilai_Karcis,host_name(),:datenowcreate
                                //         ,:Bahasa,:Etnis)
                                //         ");
                                // $this->db->bind('NoEpisode', $NoEpisode);
                                // $this->db->bind('nofixReg', $nofixReg);
                                // $this->db->bind('NoMrfix', $NoMrfix);
                                // $this->db->bind('PatientName', $PatientName);
                                // $this->db->bind('tglregistrasi', $tglregistrasi);
                                // $this->db->bind('KelurahanName', $KelurahanName);
                                // $this->db->bind('KecamatanName', $KecamatanName);
                                // $this->db->bind('CityName', $CityName);
                                // $this->db->bind('ProvinceName', $ProvinceName);
                                // $this->db->bind('BL', $BL);
                                // $this->db->bind('JenisBayar', $JenisBayar);
                                // $this->db->bind('perusahaanid', $perusahaanid);
                                // $this->db->bind('NamaPerusahaan', $shownamaperusahaanfix);
                                // $this->db->bind('Gander', $Gander);
                                // $this->db->bind('Date_of_birth', $Date_of_birth);
                                // $this->db->bind('Tipe_Idcard', $Tipe_Idcard);
                                // $this->db->bind('ID_Card_number', $ID_Card_number);
                                // $this->db->bind('Address', $Address);
                                // $this->db->bind('Marital_status', $Marital_status);
                                // $this->db->bind('Religion', $Religion);
                                // $this->db->bind('Education', $Education);
                                // $this->db->bind('HomePhone', $HomePhone);
                                // $this->db->bind('MobilePhone', $MobilePhone);
                                // $this->db->bind('Ocupation', $Ocupation);
                                // $this->db->bind('PostalCode', $PostalCode);
                                // $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                                // $this->db->bind('NamaGrupPerawatan', $NamaGrupPerawatan);
                                // $this->db->bind('IdDokter', $IdDokter);
                                // $this->db->bind('NamaDokter', $NamaDokter);
                                // $this->db->bind('NoPesertaBPJS', null);
                                // $this->db->bind('nosep', $nosep);
                                // $this->db->bind('shift', $shift);
                                // $this->db->bind('StatusID', '0');
                                // $this->db->bind('operator', $operator);
                                // $this->db->bind('LockBill', '0');
                                // $this->db->bind('PasienJenisDaftar', $PasienJenisDaftar);
                                // $this->db->bind('TelemedicineIs', '0');
                                // $this->db->bind('appointment_id', null);
                                // $this->db->bind('tiperegistrasi', $tiperegistrasi);
                                // $this->db->bind('JamPraktek', $JamPraktek);
                                // $this->db->bind('caramasukid', $caramasukid);
                                // $this->db->bind('referralid', $referralid);
                                // $this->db->bind('idadministrasi', $idadministrasi);
                                // $this->db->bind('fixNoAntrian', $fixNoAntrian);
                                // $this->db->bind('Company', $Company);
                                // $this->db->bind('NamaCaraMasuk', $NamaCaraMasuk);
                                // $this->db->bind('NamaCaraMasukRef', $showrefferalfix);
                                // $this->db->bind('Nama_Karcis', $Nama_Karcis);
                                // $this->db->bind('Nilai_Karcis', $Nilai_Karcis);
                                // $this->db->bind('Bahasa', $Bahasa);
                                // $this->db->bind('Etnis', $Etnis);
                                // $this->db->bind('datenowcreate', $datenowcreate);
                                // $this->db->execute(); 
                                // //---#END INSERT DATARWJ

                                //Update Nomor Registrasi EMR_OrderOperasi
                                if ($idodc <> '') {
                                    //Update NoEpisode ODC
                                    $this->db->query("SELECT NoEpisode
                            from MedicalRecord.dbo.MR_PermintaanRawat_ODC
                            where  ID=:idodc");
                                    $this->db->bind('idodc', $idodc);
                                    $data =  $this->db->single();
                                    $NoEpisode_odc = $data['NoEpisode'];

                                    // UPDATE TABEL Visit No Episode
                                    $this->db->query("UPDATE PerawatanSQL.dbo.Visit
                        SET NoEpisode=:NoEpisode_odc where NoRegistrasi=:nofixReg");
                                    $this->db->bind('nofixReg', $nofixReg);
                                    $this->db->bind('NoEpisode_odc', $NoEpisode_odc);
                                    $this->db->execute();

                                    // UPDATE TABEL EMR_ORDEROPERASI
                                    $this->db->query("UPDATE MedicalRecord.dbo.EMR_OrderOperasi
                            SET NoRegistrasi=:nofixReg where NoRegistrasi in (SELECT NoRegistrasi FROM MedicalRecord.dbo.MR_PermintaanRawat_ODC WHERE ID=:idodc) and StatusOrder not in('Close' , 'Batal', 'cancel') ");
                                    $this->db->bind('nofixReg', $nofixReg);
                                    $this->db->bind('idodc', $idodc);
                                    $this->db->execute();

                                    // UPDATE TABEL MR_PermintaanRawat_ODC
                                    $this->db->query("UPDATE MedicalRecord.dbo.MR_PermintaanRawat_ODC
                            SET StatusRegis='1' where ID=:idodc");
                                    $this->db->bind('idodc', $idodc);
                                    $this->db->execute();


                                    // // UPDATE TABEL EMR_ORDEROPERASI
                                    // $this->db->query("UPDATE MedicalRecord.dbo.MR_LaporanOperasi
                                    //  SET NoRegistrasi=:nofinalreg where NoRegistrasi=:noregisrwj");
                                    // $this->db->bind('nofinalreg', $nofinalreg);
                                    // $this->db->bind('noregisrwj', $noregisrwj);
                                    // $this->db->execute();
                                    //#END Update Nomor Registrasi EMR_OrderOperasi
                                }
                            }
                            // cek diskon admin per jaminan
                            $this->db->query("SELECT RJ_Disc_Administrasi 
                                            from MasterdataSQL.dbo.MstrPerusahaanAsuransi 
                                          where id=:JenisBayar");
                            $this->db->bind('JenisBayar', $JenisBayar);
                            $data =  $this->db->single();
                            $RJ_Disc_Administrasi = $data['RJ_Disc_Administrasi'];
                            $adminmindisc = $RJ_Disc_Administrasi * $nilaiadminstrasi;
                            $nilaiadministrasifix = $nilaiadminstrasi - $adminmindisc;
                        } else {
                            //INSERT KE TABEL REGISTRASI
                            if ($NoReservasi <> "") {
                                $this->db->query("INSERT INTO perawatanSQL.dbo.Visit (ID,NoEpisode,NoRegistrasi,LokasiPasien,
                                CaraBayar,NoMR ,
                                PatientType,Unit,Doctor_1,Antrian,NoAntrianAll,Company,JamPraktek,Perusahaan,Operator
                                ,idAdmin,idCaraMasuk,idCaraMasuk2,JenisDaftar
                                ,admclID,admPayorName,admpolicyNo,admpolicyDate,
                                admplanCode,admclStatus,admclDesc,admketstatus,admpayorMemberID,
                                admcoveragetype,FisioterapiFlag,TglKunjungan,[Visit Date],NoSEP,Tipe_Registrasi,ID_JadwalPraktek,
                                Catatan,KodeJaminanCOB,idRegKemenkes
                                ) VALUES (:id,:NoEpisode,:nofixReg,:NamaGrupPerawatan,
                               :nullable,:NoMrfix,
                                :JenisBayar,:IdGrupPerawatan,:IdDokter,:AntrianReservasi,:NoAntrianAllReservasi,:Company,:shift,:perusahaanid,:operator
                                ,:idadministrasi,:caramasukid,:referralid,:PasienJenisDaftar 
                                ,:admclID,:admPayorName,:admpolicyNo,:admpolicyDate,
                                :admplanCode,:admclStatus,:admclDesc,:admketstatus,:admpayorMemberID,
                                :admcoveragetype,:fisioflag,:tglregistrasi,:tglregistrasi2,:nosep,:tiperegistrasi,:JamPraktek,
                                :pxNoteRegistrasi,:COB,:uuidkemenkes)");
                                $this->db->bind('id', $id);
                                $this->db->bind('pxNoteRegistrasi', $pxNoteRegistrasi);
                                $this->db->bind('NoEpisode', $NoEpisode);
                                $this->db->bind('nofixReg', $nofixReg);
                                $this->db->bind('NamaGrupPerawatan', $NamaGrupPerawatan);
                                $this->db->bind('nullable', $nullable);
                                $this->db->bind('NoMrfix', $NoMrfix);
                                $this->db->bind('JenisBayar', $JenisBayar);
                                $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                                $this->db->bind('IdDokter', $IdDokter);
                                $this->db->bind('AntrianReservasi', $AntrianReservasi);
                                $this->db->bind('NoAntrianAllReservasi', $NoAntrianAllReservasi);
                                $this->db->bind('Company', $Company);
                                $this->db->bind('shift', $shift);
                                $this->db->bind('perusahaanid', $perusahaanid);
                                $this->db->bind('operator', $operator);
                                $this->db->bind('idadministrasi', $idadministrasi);
                                $this->db->bind('caramasukid', $caramasukid);
                                $this->db->bind('referralid', $referralid);
                                $this->db->bind('PasienJenisDaftar', $PasienJenisDaftar);
                                $this->db->bind('admclID', $admclID);
                                $this->db->bind('admPayorName', $admPayorName);
                                $this->db->bind('admpolicyNo', $admpolicyNo);
                                $this->db->bind('admpolicyDate', $admpolicyDate);
                                $this->db->bind('admplanCode', $admplanCode);
                                $this->db->bind('admclStatus', $admclStatus);
                                $this->db->bind('admclDesc', $admclDesc);
                                $this->db->bind('admketstatus', $admketstatus);
                                $this->db->bind('admpayorMemberID', $admpayorMemberID);
                                $this->db->bind('admcoveragetype', $admcoveragetype);
                                $this->db->bind('fisioflag', $fisioflag);
                                $this->db->bind('tglregistrasi', $tglregistrasi);
                                $this->db->bind('tglregistrasi2', $tglregistrasi);
                                $this->db->bind('nosep', $nosep);
                                $this->db->bind('tiperegistrasi', $tiperegistrasi);
                                $this->db->bind('JamPraktek', $JamPraktek);
                                $this->db->bind('COB', $COB);
                                $this->db->bind('uuidkemenkes', $uuidkemenkes); 
                                $this->db->execute();

                                // //      //INSERT ke DataRWJ 14-03-2023
                                // //GET DATA PASIEN
                                // $this->db->query("SELECT PatientName,
                                // KelurahanName,KecamatanName,CityName,ProvinceName,Gander,replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as Date_of_birth,Tipe_Idcard,ID_Card_number,Address,Marital_status,Religion,
                                // Education,[Home Phone],[Mobile Phone],Ocupation,[ZIP/Postal Code] as PostalCode
                                // ,Bahasa,Etnis,replace(CONVERT(VARCHAR(11), InputDate, 111), '/','-') as InputDate
                                // from MasterdataSQL.dbo.Admision 
                                // where  NoMR=:NoMrfix
                                // UNION ALL
                                // SELECT PatientName,
                                // KelurahanName,KecamatanName,CityName,ProvinceName,Gander,replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as Date_of_birth,Tipe_Idcard,ID_Card_number,Address,Marital_status,Religion,
                                // Education,[Home Phone],[Mobile Phone],Ocupation,[ZIP/Postal Code] as PostalCode
                                // ,Bahasa,Etnis,replace(CONVERT(VARCHAR(11), InputDate, 111), '/','-') as InputDate
                                // from MasterdataSQL.dbo.Admision_walkin 
                                // where  NoMR=:NoMrfix2");
                                // $this->db->bind('NoMrfix', $NoMrfix);
                                // $this->db->bind('NoMrfix2', $NoMrfix);
                                // $datag =  $this->db->single();
                                // $PatientName = $datag['PatientName'];
                                // $KelurahanName = $datag['KelurahanName'];
                                // $KecamatanName = $datag['KecamatanName'];
                                // $CityName = $datag['CityName'];
                                // $ProvinceName = $datag['ProvinceName'];
                                // $Gander = $datag['Gander'];
                                // $Date_of_birth = $datag['Date_of_birth'];
                                // $Tipe_Idcard = $datag['Tipe_Idcard'];
                                // $ID_Card_number = $datag['ID_Card_number'];
                                // $Address = $datag['Address'];
                                // $Marital_status = $datag['Marital_status'];
                                // $Religion = $datag['Religion'];
                                // $Education = $datag['Education'];
                                // $HomePhone = $datag['Home Phone'];
                                // $MobilePhone = $datag['Mobile Phone'];
                                // $Ocupation = $datag['Ocupation'];
                                // $PostalCode = $datag['PostalCode'];
                                // $Bahasa = $datag['Bahasa'];
                                // $Etnis = $datag['Etnis'];
                                // $InputDate = $datag['InputDate'];


                                // //GET CARA MASUK
                                // $querry = "SELECT NamaCaraMasuk
                                //     from MasterdataSQL.dbo.MstrCaraMasuk
                                //     where id=:caramasukid";
                                // $this->db->query($querry);
                                // $this->db->bind('caramasukid', $caramasukid);
                                // $dataf =  $this->db->single();
                                // $NamaCaraMasuk = $dataf['NamaCaraMasuk']; 

                                // // GET DATA KARCIS
                                //     $this->db->query("SELECT ID, Nama_Karcis,Nilai_Karcis
                                //     from MasterdataSQL.dbo.MstrKarcisAdministrasi  
                                //     where  ID=:idadministrasi");
                                // $this->db->bind('idadministrasi', $idadministrasi);
                                // $data =  $this->db->single();
                                // $Nama_Karcis = $data['Nama_Karcis'];
                                // $Nilai_Karcis = $data['Nilai_Karcis'];

                                // if (strtotime($tglregistrasi_Ymd) > strtotime($InputDate)){
                                //     $BL = 'LAMA';
                                // }else{
                                //     $BL = 'BARU';
                                // }

                                // $this->db->query("INSERT INTO DashboardData.dbo.DataRWJ (NoEpisode,NoRegistrasi,NoMR,PatientName,[Visit Date],
                                // Kelurahan,Kecamatan,kabupatenNama,ProvinsiNama,BL,TipePasien,FP,
                                // KodeJaminan,NamaJaminan,Sex,DateOfBirth,TipeIdCard, NoIdCard, Address,MaritalStatus,Religion,
                                // Education,HomePhone,MobilePhone,Pekerjaan,KodePos,IdUnit,NamaUnit,IdDokter,NamaDokter,
                                // NoPesertaBPJS,NoSep,JamPraktek,StatusID,OperatorId,
                                // Lockbill,JenisDaftar,Telemedicine,Appointment_ID,Tipe_Registrasi,Id_Jadwal_Praktek,
                                // idCaraMasuk,idCaraMasuk2,idAdmin,NoAntrianAll,Company,NamaCaraMasuk,NamaCaraMasukRef,NamaKarcis,NilaiKarcis,hosnamedata,datatimestamp,Bahasa,Etnis
                                // ) VALUES ( :NoEpisode, :nofixReg,:NoMrfix,:PatientName,:tglregistrasi,
                                //         :KelurahanName,:KecamatanName,:CityName,:ProvinceName,
                                //         :BL
                                //         ,:JenisBayar,'1',
                                //         :perusahaanid,:NamaPerusahaan,:Gander,:Date_of_birth,:Tipe_Idcard,:ID_Card_number,:Address,:Marital_status,:Religion,
                                //         :Education,:HomePhone,:MobilePhone,:Ocupation,:PostalCode
                                //         ,:IdGrupPerawatan,:NamaGrupPerawatan,:IdDokter,:NamaDokter,
                                //         :NoPesertaBPJS,:nosep,:shift,:StatusID,:operator,
                                //         :LockBill,:PasienJenisDaftar,:TelemedicineIs,:appointment_id,:tiperegistrasi,:JamPraktek,
                                //         :caramasukid,:referralid,:idadministrasi,:fixNoAntrian,:Company,:NamaCaraMasuk,:NamaCaraMasukRef,:Nama_Karcis,:Nilai_Karcis,host_name(),:datenowcreate
                                //         ,:Bahasa,:Etnis)
                                //         ");
                                // $this->db->bind('NoEpisode', $NoEpisode);
                                // $this->db->bind('nofixReg', $nofixReg);
                                // $this->db->bind('NoMrfix', $NoMrfix);
                                // $this->db->bind('PatientName', $PatientName);
                                // $this->db->bind('tglregistrasi', $tglregistrasi);
                                // $this->db->bind('KelurahanName', $KelurahanName);
                                // $this->db->bind('KecamatanName', $KecamatanName);
                                // $this->db->bind('CityName', $CityName);
                                // $this->db->bind('ProvinceName', $ProvinceName);
                                // $this->db->bind('BL', $BL);
                                // $this->db->bind('JenisBayar', $JenisBayar);
                                // $this->db->bind('perusahaanid', $perusahaanid);
                                // $this->db->bind('NamaPerusahaan', $shownamaperusahaanfix);
                                // $this->db->bind('Gander', $Gander);
                                // $this->db->bind('Date_of_birth', $Date_of_birth);
                                // $this->db->bind('Tipe_Idcard', $Tipe_Idcard);
                                // $this->db->bind('ID_Card_number', $ID_Card_number);
                                // $this->db->bind('Address', $Address);
                                // $this->db->bind('Marital_status', $Marital_status);
                                // $this->db->bind('Religion', $Religion);
                                // $this->db->bind('Education', $Education);
                                // $this->db->bind('HomePhone', $HomePhone);
                                // $this->db->bind('MobilePhone', $MobilePhone);
                                // $this->db->bind('Ocupation', $Ocupation);
                                // $this->db->bind('PostalCode', $PostalCode);
                                // $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                                // $this->db->bind('NamaGrupPerawatan', $NamaGrupPerawatan);
                                // $this->db->bind('IdDokter', $IdDokter);
                                // $this->db->bind('NamaDokter', $NamaDokter);
                                // $this->db->bind('NoPesertaBPJS', null);
                                // $this->db->bind('nosep', $nosep);
                                // $this->db->bind('shift', $shift);
                                // $this->db->bind('StatusID', '0');
                                // $this->db->bind('operator', $operator);
                                // $this->db->bind('LockBill', '0');
                                // $this->db->bind('PasienJenisDaftar', $PasienJenisDaftar);
                                // $this->db->bind('TelemedicineIs', '0');
                                // $this->db->bind('appointment_id', null);
                                // $this->db->bind('tiperegistrasi', $tiperegistrasi);
                                // $this->db->bind('JamPraktek', $JamPraktek);
                                // $this->db->bind('caramasukid', $caramasukid);
                                // $this->db->bind('referralid', $referralid);
                                // $this->db->bind('idadministrasi', $idadministrasi);
                                // $this->db->bind('fixNoAntrian', $fixNoAntrian);
                                // $this->db->bind('Company', $Company);
                                // $this->db->bind('NamaCaraMasuk', $NamaCaraMasuk);
                                // $this->db->bind('NamaCaraMasukRef', $showrefferalfix);
                                // $this->db->bind('Nama_Karcis', $Nama_Karcis);
                                // $this->db->bind('Nilai_Karcis', $Nilai_Karcis);
                                // $this->db->bind('Bahasa', $Bahasa);
                                // $this->db->bind('Etnis', $Etnis);
                                // $this->db->bind('datenowcreate', $datenowcreate);
                                // $this->db->execute(); 
                                // //---#END INSERT DATARWJ
                                //Update Nomor Registrasi EMR_OrderOperasi
                                if ($idodc <> '') {
                                    //Update NoEpisode ODC
                                    $this->db->query("SELECT NoEpisode
                            from MedicalRecord.dbo.MR_PermintaanRawat_ODC
                            where  ID=:idodc");
                                    $this->db->bind('idodc', $idodc);
                                    $data =  $this->db->single();
                                    $NoEpisode_odc = $data['NoEpisode'];

                                    // UPDATE TABEL Visit No Episode
                                    $this->db->query("UPDATE PerawatanSQL.dbo.Visit
                        SET NoEpisode=:NoEpisode_odc where NoRegistrasi=:nofixReg");
                                    $this->db->bind('nofixReg', $nofixReg);
                                    $this->db->bind('NoEpisode_odc', $NoEpisode_odc);
                                    $this->db->execute();

                                    // UPDATE TABEL EMR_ORDEROPERASI
                                    $this->db->query("UPDATE MedicalRecord.dbo.EMR_OrderOperasi
                            SET NoRegistrasi=:nofixReg where NoRegistrasi in (SELECT NoRegistrasi FROM MedicalRecord.dbo.MR_PermintaanRawat_ODC WHERE ID=:idodc) and StatusOrder not in('Close' , 'Batal', 'cancel') ");
                                    $this->db->bind('nofixReg', $nofixReg);
                                    $this->db->bind('idodc', $idodc);
                                    $this->db->execute();

                                    // UPDATE TABEL MR_PermintaanRawat_ODC
                                    $this->db->query("UPDATE MedicalRecord.dbo.MR_PermintaanRawat_ODC
                            SET StatusRegis='1' where ID=:idodc");
                                    $this->db->bind('idodc', $idodc);
                                    $this->db->execute();


                                    // // UPDATE TABEL EMR_ORDEROPERASI
                                    // $this->db->query("UPDATE MedicalRecord.dbo.MR_LaporanOperasi
                                    //  SET NoRegistrasi=:nofinalreg where NoRegistrasi=:noregisrwj");
                                    // $this->db->bind('nofinalreg', $nofinalreg);
                                    // $this->db->bind('noregisrwj', $noregisrwj);
                                    // $this->db->execute();
                                    //#END Update Nomor Registrasi EMR_OrderOperasi
                                }
                            } else {
                                $this->db->query("INSERT INTO perawatanSQL.dbo.Visit (ID,NoEpisode,NoRegistrasi,LokasiPasien,
                                CaraBayar,NoMR ,
                                PatientType,Unit,Doctor_1,Antrian,NoAntrianAll,Company,JamPraktek,Perusahaan,Operator
                                ,idAdmin,idCaraMasuk,idCaraMasuk2,JenisDaftar
                                ,admclID,admPayorName,admpolicyNo,admpolicyDate,
                                admplanCode,admclStatus,admclDesc,admketstatus,admpayorMemberID,admcoveragetype,
                                FisioterapiFlag,TglKunjungan,[Visit Date],NoSEP,Tipe_Registrasi,ID_JadwalPraktek,
                                Catatan,KodeJaminanCOB,idRegKemenkes
                                ) VALUES (:id,:NoEpisode,:nofixReg,:NamaGrupPerawatan,
                               :nullable,:NoMrfix,
                                :JenisBayar,:IdGrupPerawatan,:IdDokter,:idno_urutantrian,:fixNoAntrian,:Company,:shift,:perusahaanid,:operator
                                ,:idadministrasi,:caramasukid,:referralid,:PasienJenisDaftar 
                                ,:admclID,:admPayorName,:admpolicyNo,:admpolicyDate,
                                :admplanCode,:admclStatus,:admclDesc,:admketstatus,:admpayorMemberID,
                                :admcoveragetype,:fisioflag,:tglregistrasi,:tglregistrasi2,:nosep,:tiperegistrasi,:JamPraktek,
                               :pxNoteRegistrasi,:COB,:uuidkemenkes)");
                                $this->db->bind('id', $id);
                                $this->db->bind('pxNoteRegistrasi', $pxNoteRegistrasi);
                                $this->db->bind('NoEpisode', $NoEpisode);
                                $this->db->bind('nofixReg', $nofixReg);
                                $this->db->bind('NamaGrupPerawatan', $NamaGrupPerawatan);
                                $this->db->bind('nullable', $nullable);
                                $this->db->bind('NoMrfix', $NoMrfix);
                                $this->db->bind('JenisBayar', $JenisBayar);
                                $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                                $this->db->bind('IdDokter', $IdDokter);
                                $this->db->bind('idno_urutantrian', $idno_urutantrian);
                                $this->db->bind('fixNoAntrian', $fixNoAntrian);
                                $this->db->bind('Company', $Company);
                                $this->db->bind('shift', $shift);
                                $this->db->bind('perusahaanid', $perusahaanid);
                                $this->db->bind('operator', $operator);
                                $this->db->bind('idadministrasi', $idadministrasi);
                                $this->db->bind('caramasukid', $caramasukid);
                                $this->db->bind('referralid', $referralid);
                                $this->db->bind('PasienJenisDaftar', $PasienJenisDaftar);
                                $this->db->bind('admclID', $admclID);
                                $this->db->bind('admPayorName', $admPayorName);
                                $this->db->bind('admpolicyNo', $admpolicyNo);
                                $this->db->bind('admpolicyDate', $admpolicyDate);
                                $this->db->bind('admplanCode', $admplanCode);
                                $this->db->bind('admclStatus', $admclStatus);
                                $this->db->bind('admclDesc', $admclDesc);
                                $this->db->bind('admketstatus', $admketstatus);
                                $this->db->bind('admpayorMemberID', $admpayorMemberID);
                                $this->db->bind('admcoveragetype', $admcoveragetype);
                                $this->db->bind('fisioflag', $fisioflag);
                                $this->db->bind('tglregistrasi', $tglregistrasi);
                                $this->db->bind('tglregistrasi2', $tglregistrasi);
                                $this->db->bind('nosep', $nosep);
                                $this->db->bind('tiperegistrasi', $tiperegistrasi);
                                $this->db->bind('JamPraktek', $JamPraktek);
                                $this->db->bind('COB', $COB);
                                $this->db->bind('uuidkemenkes', $uuidkemenkes); 
                                $this->db->execute();

                                    
                                // //INSERT ke DataRWJ 14-03-2023
                                // //GET DATA PASIEN
                                // $this->db->query("SELECT PatientName,
                                // KelurahanName,KecamatanName,CityName,ProvinceName,Gander,replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as Date_of_birth,Tipe_Idcard,ID_Card_number,Address,Marital_status,Religion,
                                // Education,[Home Phone],[Mobile Phone],Ocupation,[ZIP/Postal Code] as PostalCode
                                // ,Bahasa,Etnis,replace(CONVERT(VARCHAR(11), InputDate, 111), '/','-') as InputDate
                                // from MasterdataSQL.dbo.Admision 
                                // where  NoMR=:NoMrfix
                                // UNION ALL
                                // SELECT PatientName,
                                // KelurahanName,KecamatanName,CityName,ProvinceName,Gander,replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as Date_of_birth,Tipe_Idcard,ID_Card_number,Address,Marital_status,Religion,
                                // Education,[Home Phone],[Mobile Phone],Ocupation,[ZIP/Postal Code] as PostalCode
                                // ,Bahasa,Etnis,replace(CONVERT(VARCHAR(11), InputDate, 111), '/','-') as InputDate
                                // from MasterdataSQL.dbo.Admision_walkin 
                                // where  NoMR=:NoMrfix2");
                                // $this->db->bind('NoMrfix', $NoMrfix);
                                // $this->db->bind('NoMrfix2', $NoMrfix);
                                // $datag =  $this->db->single();
                                // $PatientName = $datag['PatientName'];
                                // $KelurahanName = $datag['KelurahanName'];
                                // $KecamatanName = $datag['KecamatanName'];
                                // $CityName = $datag['CityName'];
                                // $ProvinceName = $datag['ProvinceName'];
                                // $Gander = $datag['Gander'];
                                // $Date_of_birth = $datag['Date_of_birth'];
                                // $Tipe_Idcard = $datag['Tipe_Idcard'];
                                // $ID_Card_number = $datag['ID_Card_number'];
                                // $Address = $datag['Address'];
                                // $Marital_status = $datag['Marital_status'];
                                // $Religion = $datag['Religion'];
                                // $Education = $datag['Education'];
                                // $HomePhone = $datag['Home Phone'];
                                // $MobilePhone = $datag['Mobile Phone'];
                                // $Ocupation = $datag['Ocupation'];
                                // $PostalCode = $datag['PostalCode'];
                                // $Bahasa = $datag['Bahasa'];
                                // $Etnis = $datag['Etnis'];
                                // $InputDate = $datag['InputDate'];

                                // //GET CARA MASUK
                                // $querry = "SELECT NamaCaraMasuk
                                //     from MasterdataSQL.dbo.MstrCaraMasuk
                                //     where id=:caramasukid";
                                // $this->db->query($querry);
                                // $this->db->bind('caramasukid', $caramasukid);
                                // $dataf =  $this->db->single();
                                // $NamaCaraMasuk = $dataf['NamaCaraMasuk']; 

                                // // GET DATA KARCIS
                                //     $this->db->query("SELECT ID, Nama_Karcis,Nilai_Karcis
                                //     from MasterdataSQL.dbo.MstrKarcisAdministrasi  
                                //     where  ID=:idadministrasi");
                                // $this->db->bind('idadministrasi', $idadministrasi);
                                // $data =  $this->db->single();
                                // $Nama_Karcis = $data['Nama_Karcis'];
                                // $Nilai_Karcis = $data['Nilai_Karcis'];

                                // if (strtotime($tglregistrasi_Ymd) > strtotime($InputDate)){
                                //     $BL = 'LAMA';
                                // }else{
                                //     $BL = 'BARU';
                                // }

                                // $this->db->query("INSERT INTO DashboardData.dbo.DataRWJ (NoEpisode,NoRegistrasi,NoMR,PatientName,[Visit Date],
                                // Kelurahan,Kecamatan,kabupatenNama,ProvinsiNama,BL,TipePasien,FP,
                                // KodeJaminan,NamaJaminan,Sex,DateOfBirth,TipeIdCard, NoIdCard, Address,MaritalStatus,Religion,
                                // Education,HomePhone,MobilePhone,Pekerjaan,KodePos,IdUnit,NamaUnit,IdDokter,NamaDokter,
                                // NoPesertaBPJS,NoSep,JamPraktek,StatusID,OperatorId,
                                // Lockbill,JenisDaftar,Telemedicine,Appointment_ID,Tipe_Registrasi,Id_Jadwal_Praktek,
                                // idCaraMasuk,idCaraMasuk2,idAdmin,NoAntrianAll,Company,NamaCaraMasuk,NamaCaraMasukRef,NamaKarcis,NilaiKarcis,hosnamedata,datatimestamp,Bahasa,Etnis
                                // ) VALUES ( :NoEpisode, :nofixReg,:NoMrfix,:PatientName,:tglregistrasi,
                                //         :KelurahanName,:KecamatanName,:CityName,:ProvinceName,
                                //         :BL
                                //         ,:JenisBayar,'1',
                                //         :perusahaanid,:NamaPerusahaan,:Gander,:Date_of_birth,:Tipe_Idcard,:ID_Card_number,:Address,:Marital_status,:Religion,
                                //         :Education,:HomePhone,:MobilePhone,:Ocupation,:PostalCode
                                //         ,:IdGrupPerawatan,:NamaGrupPerawatan,:IdDokter,:NamaDokter,
                                //         :NoPesertaBPJS,:nosep,:shift,:StatusID,:operator,
                                //         :LockBill,:PasienJenisDaftar,:TelemedicineIs,:appointment_id,:tiperegistrasi,:JamPraktek,
                                //         :caramasukid,:referralid,:idadministrasi,:fixNoAntrian,:Company,:NamaCaraMasuk,:NamaCaraMasukRef,:Nama_Karcis,:Nilai_Karcis,host_name(),:datenowcreate
                                //         ,:Bahasa,:Etnis)
                                //         ");
                                // $this->db->bind('NoEpisode', $NoEpisode);
                                // $this->db->bind('nofixReg', $nofixReg);
                                // $this->db->bind('NoMrfix', $NoMrfix);
                                // $this->db->bind('PatientName', $PatientName);
                                // $this->db->bind('tglregistrasi', $tglregistrasi);
                                // $this->db->bind('KelurahanName', $KelurahanName);
                                // $this->db->bind('KecamatanName', $KecamatanName);
                                // $this->db->bind('CityName', $CityName);
                                // $this->db->bind('ProvinceName', $ProvinceName);
                                // $this->db->bind('BL', $BL);
                                // $this->db->bind('JenisBayar', $JenisBayar);
                                // $this->db->bind('perusahaanid', $perusahaanid);
                                // $this->db->bind('NamaPerusahaan', $shownamaperusahaanfix);
                                // $this->db->bind('Gander', $Gander);
                                // $this->db->bind('Date_of_birth', $Date_of_birth);
                                // $this->db->bind('Tipe_Idcard', $Tipe_Idcard);
                                // $this->db->bind('ID_Card_number', $ID_Card_number);
                                // $this->db->bind('Address', $Address);
                                // $this->db->bind('Marital_status', $Marital_status);
                                // $this->db->bind('Religion', $Religion);
                                // $this->db->bind('Education', $Education);
                                // $this->db->bind('HomePhone', $HomePhone);
                                // $this->db->bind('MobilePhone', $MobilePhone);
                                // $this->db->bind('Ocupation', $Ocupation);
                                // $this->db->bind('PostalCode', $PostalCode);
                                // $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                                // $this->db->bind('NamaGrupPerawatan', $NamaGrupPerawatan);
                                // $this->db->bind('IdDokter', $IdDokter);
                                // $this->db->bind('NamaDokter', $NamaDokter);
                                // $this->db->bind('NoPesertaBPJS', null);
                                // $this->db->bind('nosep', $nosep);
                                // $this->db->bind('shift', $shift);
                                // $this->db->bind('StatusID', '0');
                                // $this->db->bind('operator', $operator);
                                // $this->db->bind('LockBill', '0');
                                // $this->db->bind('PasienJenisDaftar', $PasienJenisDaftar);
                                // $this->db->bind('TelemedicineIs', '0');
                                // $this->db->bind('appointment_id', null);
                                // $this->db->bind('tiperegistrasi', $tiperegistrasi);
                                // $this->db->bind('JamPraktek', $JamPraktek);
                                // $this->db->bind('caramasukid', $caramasukid);
                                // $this->db->bind('referralid', $referralid);
                                // $this->db->bind('idadministrasi', $idadministrasi);
                                // $this->db->bind('fixNoAntrian', $fixNoAntrian);
                                // $this->db->bind('Company', $Company);
                                // $this->db->bind('NamaCaraMasuk', $NamaCaraMasuk);
                                // $this->db->bind('NamaCaraMasukRef', $showrefferalfix);
                                // $this->db->bind('Nama_Karcis', $Nama_Karcis);
                                // $this->db->bind('Nilai_Karcis', $Nilai_Karcis);
                                // $this->db->bind('Bahasa', $Bahasa);
                                // $this->db->bind('Etnis', $Etnis);
                                // $this->db->bind('datenowcreate', $datenowcreate);
                                // $this->db->execute(); 
                                // //---#END INSERT DATARWJ
                                //Update Nomor Registrasi EMR_OrderOperasi
                                if ($idodc <> '') {
                                    //Update NoEpisode ODC
                                    $this->db->query("SELECT NoEpisode
                            from MedicalRecord.dbo.MR_PermintaanRawat_ODC
                            where  ID=:idodc");
                                    $this->db->bind('idodc', $idodc);
                                    $data =  $this->db->single();
                                    $NoEpisode_odc = $data['NoEpisode'];

                                    // UPDATE TABEL Visit No Episode
                                    $this->db->query("UPDATE PerawatanSQL.dbo.Visit
                        SET NoEpisode=:NoEpisode_odc where NoRegistrasi=:nofixReg");
                                    $this->db->bind('nofixReg', $nofixReg);
                                    $this->db->bind('NoEpisode_odc', $NoEpisode_odc);
                                    $this->db->execute();

                                    // UPDATE TABEL EMR_ORDEROPERASI
                                    $this->db->query("UPDATE MedicalRecord.dbo.EMR_OrderOperasi
                            SET NoRegistrasi=:nofixReg where NoRegistrasi in (SELECT NoRegistrasi FROM MedicalRecord.dbo.MR_PermintaanRawat_ODC WHERE ID=:idodc) and StatusOrder not in('Close' , 'Batal', 'cancel') ");
                                    $this->db->bind('nofixReg', $nofixReg);
                                    $this->db->bind('idodc', $idodc);
                                    $this->db->execute();

                                    // UPDATE TABEL MR_PermintaanRawat_ODC
                                    $this->db->query("UPDATE MedicalRecord.dbo.MR_PermintaanRawat_ODC
                            SET StatusRegis='1' where ID=:idodc");
                                    $this->db->bind('idodc', $idodc);
                                    $this->db->execute();


                                    // // UPDATE TABEL EMR_ORDEROPERASI
                                    // $this->db->query("UPDATE MedicalRecord.dbo.MR_LaporanOperasi
                                    //  SET NoRegistrasi=:nofinalreg where NoRegistrasi=:noregisrwj");
                                    // $this->db->bind('nofinalreg', $nofinalreg);
                                    // $this->db->bind('noregisrwj', $noregisrwj);
                                    // $this->db->execute();
                                    //#END Update Nomor Registrasi EMR_OrderOperasi
                                }
                            }
                            // cek diskon admin per jaminan
                            $this->db->query("SELECT RJ_Disc_Administrasi 
                                            from MasterdataSQL.dbo.MstrPerusahaanJPK 
                                            where id=:JenisBayar");
                            $this->db->bind('JenisBayar', $JenisBayar);
                            $data =  $this->db->single();
                            $RJ_Disc_Administrasi = $data['RJ_Disc_Administrasi'];
                            $adminmindisc = $RJ_Disc_Administrasi * $nilaiadminstrasi;
                            $nilaiadministrasifix = $nilaiadminstrasi - $adminmindisc;
                        }
                        // Insert Administrasi
                        $this->db->query("INSERT INTO  PerawatanSQL.dbo.[Visit Details] ( ProductID, NamaProduct, Quantity, Tarif, TotalTarif, JasaDokter, 
                                        Discount, StatusID, Aproved, KategoriTarif, Lunas, NoRegistrasi, NoMR, NoEpisode,Tanggal )
                                        SELECT ID, Nama_Karcis, 1 AS Quantity, Nilai_Karcis, '$nilaiadministrasifix' AS [fixtarif], 0 AS Expr1, 
                                        '$adminmindisc' AS diskonjaminanx, 1 AS Expr3, 0 AS Expr4, 
                                        'Administrasi' AS Admin, 0 AS Expr6, '$nofixReg' AS xNoreg, 
                                        '$NoMrfix' AS NoMR, '$NoEpisode' AS xNoEpisode,'$tglregistrasi'
                                        FROM MasterdataSQL.dbo.MstrKarcisAdministrasi
                                        WHERE ID=:idadministrasi");
                        $this->db->bind('idadministrasi', $idadministrasi);
                        $this->db->execute();

                        // insert antrian
                        if ($NoReservasi === "") {
                            $this->db->query("INSERT INTO perawatanSQL.dbo.AntrianPasien 
                                            (no_transaksi,no_transaksi_reff,Doctor_1,JamPraktek,Antrian,noAntrianAll,TglKunjungan,Company)VALUES
                                            (:nofixReg,:no_transaksi_reff,:IdDokter,:shift,:idno_urutantrian,:fixNoAntrian,
                                            :datenowcreate,:Company)");
                            $this->db->bind('nofixReg', $nofixReg);
                            $this->db->bind('no_transaksi_reff', $nofixReg);
                            $this->db->bind('IdDokter', $IdDokter);
                            $this->db->bind('shift', $shift);
                            $this->db->bind('idno_urutantrian', $idno_urutantrian);
                            $this->db->bind('fixNoAntrian', $fixNoAntrian);
                            $this->db->bind('datenowcreate', $datenowcreate);
                            $this->db->bind('Company', $Company);
                            $this->db->execute();
                        }
                        if ($NoReservasi <> "") {
                            // $this->db->query("UPDATE  PerawatanSQL.dbo.Apointment 
                            //                 SET Datang='1', NoRegistrasi=:nofixReg,no_transaksi_reff=:no_transaksi_reff
                            //                 where NoBooking=:NoReservasi");
                            // $this->db->bind('nofixReg', $nofixReg);
                            // $this->db->bind('no_transaksi_reff', $nofixReg);
                            // $this->db->bind('NoReservasi', $NoReservasi);
                            // $this->db->execute(); 
                            $this->db->query("UPDATE  PerawatanSQL.dbo.Apointment 
                            SET Datang='1', NoRegistrasi=:nofixReg
                            where NoBooking=:NoReservasi");
                            $this->db->bind('nofixReg', $nofixReg);
                            //$this->db->bind('no_transaksi_reff', $nofixReg);
                            $this->db->bind('NoReservasi', $NoReservasi);
                            $this->db->execute();
                    
                            $this->db->query("UPDATE  PerawatanSQL.dbo.AntrianPasien 
                                            SET no_transaksi_reff=:no_transaksi_reff
                                            where no_transaksi=:no_transaksi"); 
                            $this->db->bind('no_transaksi_reff', $nofixReg);
                            $this->db->bind('no_transaksi', $NoReservasi);
                            $this->db->execute();
                        } else {
                            $executeboking = null;
                        }

                        //Generate no trs billing

                        $datenowx = Utils::datenowcreateNotFull();
                        $datenow = date('dmy', strtotime($datenowcreate));
                        $datenow_ymd = date('Y-m-d', strtotime($datenowcreate));
                        $datenotrsadmin =  date('dmys', strtotime(Utils::seCurrentDateTime()));
                        $this->db->query("SELECT  TOP 1 NO_TRS_BILLING,right( REPLACE(NO_TRS_BILLING,'-','0')  ,5) as urut
                        FROM Billing_Pasien.dbo.FO_T_BILLING  WHERE  
                        replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-')=:datenow2 
                        and SUBSTRING(no_trs_billing,1,2)=:no_trs_billing
                        ORDER BY urut DESC");
                        $this->db->bind('datenow2', $datenow_ymd);
                        $this->db->bind('no_trs_billing', 'AD');
                        $data =  $this->db->single();
                        //no urut reg
                        $nexturut = $data['urut'];
                        $nexturut++;

                        $nourutfix = Utils::generateAutoNumber($nexturut);
                        $kodeawal = "AD";
                        $notrsbill = $kodeawal . $datenotrsadmin . $nourutfix;
                        //var_dump($notrsbill);exit;

                        // insert ke tabel FO_T_Billing
                        //         $this->db->query("INSERT INTO Billing_Pasien.dbo.FO_T_BILLING
                        //         ([NO_TRS_BILLING],[TGL_BILLING],[PETUGAS_ENTRY],[NO_MR],[NO_EPISODE],[NO_REGISTRASI],[UNIT],[GROUP_JAMINAN],[KODE_JAMINAN],[TOTAL_TARIF],[TOTAL_QTY],[SUBTOTAL],[TOTAL_DISCOUNT],[TOTAL_DISCOUNT_RP],[SUBTOTAL_2],[GRANDTOTAL],[BATAL],[FB_CLOSE_KEUANGAN],[FB_VERIF_JURNAL])
                        //   VALUES
                        //         (:notrsbill,:datenowx,:namauserx,:NoMrfix,:NoEpisode,:nofixReg,:IdGrupPerawatan,:JenisBayar,:perusahaanid,:totaltarif,:totalqty,:subtotal,:totaldiscount,:totaldiscountrp,:subtotal2,:grandtotal,:batal,:closekeuangan,:verifkeuangan)");

                        //         $this->db->bind('notrsbill', $notrsbill);
                        //         $this->db->bind('datenowx', Utils::seCurrentDateTime());
                        //         $this->db->bind('namauserx', $namauserx);
                        //         $this->db->bind('NoMrfix', $NoMrfix);
                        //         $this->db->bind('NoEpisode', $NoEpisode);
                        //         $this->db->bind('nofixReg', $nofixReg);
                        //         $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                        //         $this->db->bind('JenisBayar', $JenisBayar);
                        //         $this->db->bind('perusahaanid', $perusahaanid);
                        //         $this->db->bind('totaltarif', 0);
                        //         $this->db->bind('totalqty', 0);
                        //         $this->db->bind('subtotal', 0);
                        //         $this->db->bind('totaldiscount', 0);
                        //         $this->db->bind('totaldiscountrp', 0);
                        //         $this->db->bind('subtotal2', 0);
                        //         $this->db->bind('grandtotal', 0);
                        //         $this->db->bind('batal', 0);
                        //         $this->db->bind('closekeuangan', 0);
                        //         $this->db->bind('verifkeuangan', 0);
                        //         $this->db->execute();

                        //       // insert ke tabel FO_T_Billing_1
                        //       // Insert Administrasi
                        //     $this->db->query("INSERT INTO  Billing_Pasien.dbo.FO_T_BILLING_1
                        //     ([NO_TRS_BILLING],[TGL_BILLING],[PETUGAS_ENTRY],[NO_MR],[NO_EPISODE],[NO_REGISTRASI],[KODE_TARIF],[UNIT],[GROUP_JAMINAN],[KODE_JAMINAN],[NAMA_TARIF],[GROUP_TARIF],[KD_KELAS],[QTY],[NILAI_TARIF],[SUB_TOTAL],[DISC],[DISC_RP],[SUB_TOTAL_2],[GRANDTOTAL],[KD_DR],[NM_DR],[BATAL],[PETUGAS_BATAL],[GROUP_ENTRI],
                        //     BAYAR,KLAIM,KEKURANGAN,ID_TR_TARIF_PAKET,ID_TRS_Payment)
                        //     SELECT '$notrsbill' as notrsbill, '$datenowcreate' as datenow,'$namauserx' as namauserx,'$NoMrfix' AS NoMR, '$NoEpisode' AS xNoEpisode,'$nofixReg' as NoReg,ID,
                        //     '$IdGrupPerawatan' as Unit,'$JenisBayar' as GroupJaminan,'$perusahaanid' as kdjaminan, Nama_Karcis,'Administrasi' as adm, null as kdkelas, 1 as Qty, Nilai_Karcis, Nilai_Karcis, 0 as Disc, 0 as disc2, Nilai_Karcis, Nilai_Karcis, null as kddokter, null as nmdokter, 0 as batal,null as petugasbatal,'KARCIS',
                        //     '0','0',Nilai_Karcis,null,null
                        //     FROM MasterdataSQL.dbo.MstrKarcisAdministrasi
                        //     WHERE ID=:idadministrasi");
                        //     $this->db->bind('idadministrasi', $idadministrasi); 
                        //     $this->db->execute();

                        //     //Insert ke tabel FO_T_Billing_2
                        // $this->db->query("INSERT INTO  Billing_Pasien.DBO.FO_T_BILLING_2
                        // SELECT '0' as ID_BILL,A.NO_TRS_BILLING AS NO_TRS_BILLING,A1.KODE_TARIF,B.KD_TIPE_PDP as Kode_komponen,A1.UNIT AS UNIT, A1.GROUP_JAMINAN AS GROUP_JAMINAN, A1.KODE_JAMINAN AS KODE_JAMINAN, 
                        // A1.NAMA_TARIF AS NAMA_TARIF, 
                        // A1.GROUP_TARIF AS GROUP_TARIF, A1.KD_KELAS as KELAS,A1.QTY AS QTY, 
                        // A1.NILAI_TARIF AS NILAI_TARIF  ,
                        // A1.NILAI_TARIF*A1.QTY  AS SUBTOTAL,
                        // A1.DISC AS DISC,
                        // (A1.NILAI_TARIF-((A1.NILAI_TARIF*A1.DISC)/100)) AS DISC_RP,
                        // ((A1.NILAI_TARIF*A1.QTY)-(((A1.NILAI_TARIF*A1.QTY)*A1.DISC)/100))   SUB_TOTAL_PDP_2,
                        // (CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN ((((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' THEN ((b.NILAI_FIX*A1.QTY*DISC)/100)*A1.QTY END ) NILAI_DISKON_PDP,
                        // (CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN (((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY)-(((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' THEN (b.NILAI_FIX*A1.QTY)-((b.NILAI_FIX*A1.QTY*DISC)/100)*A1.QTY END ) as NILAI_PDP,
                        // A1.KD_DR AS KD_DR, '' NM_DR,b.NILAI_PROSEN,'0' AS BATAL,'' PETUGAS_BATAL, '' AS JAM_BATAL, B.KD_POSTING AS KD_POSTING, b.KD_POSTING_DISC as kd_posting_diskon,null
                        //  FROM Billing_Pasien.DBO.FO_T_BILLING A
                        //  inner join Billing_Pasien.dbo.FO_T_BILLING_1 A1
                        //  ON A.NO_TRS_BILLING = A1.NO_TRS_BILLING
                        //  INNER JOIN MasterdataSQL.DBO.MstrKarcisAdministrasi CC 
                        //  ON CC.ID = A1.KODE_TARIF
                        //  INNER JOIN Keuangan.DBO.BO_M_PDP2 B
                        // ON CC.KD_PDP collate SQL_Latin1_General_CP1_CI_AS = B.KD_PDP collate SQL_Latin1_General_CP1_CI_AS
                        // INNER JOIN Keuangan.DBO.BO_M_PDP CX
                        // ON CX.KD_PDP = B.KD_PDP
                        //  WHERE A1.GROUP_ENTRI='KARCIS' and a.BATAL='0' and A1.BATAL='0' and a.NO_TRS_BILLING=:notrsbill");
                        // $this->db->bind('notrsbill', $notrsbill); 
                        // $this->db->execute();

                        //    //UPDATE TOTAL KE FO_T_BILLING
                        // $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_BILLING
                        // SET TOTAL_TARIF=B.SUM_NILAI_TARIF,TOTAL_QTY=B.SUM_QTY,SUBTOTAL=B.SUM_SUB_TOTAL,SUBTOTAL_2=B.SUM_SUB_TOTAL_2,GRANDTOTAL=B.SUM_GRANDTOTAL
                        // FROM Billing_Pasien.DBO.FO_T_BILLING A 
                        // INNER JOIN
                        // (
                        //     SELECT  NO_TRS_BILLING,SUM(NILAI_TARIF) AS SUM_NILAI_TARIF,SUM(QTY) AS SUM_QTY,SUM(SUB_TOTAL) AS SUM_SUB_TOTAL,SUM(SUB_TOTAL_2) AS SUM_SUB_TOTAL_2,
                        //     SUM(GRANDTOTAL) AS SUM_GRANDTOTAL
                        //     FROM Billing_Pasien.DBO.FO_T_BILLING_1
                        //     WHERE NO_REGISTRASI=:noreg and Batal='0'
                        //     GROUP BY NO_TRS_BILLING
                        // ) B
                        // ON A.NO_TRS_BILLING = B.NO_TRS_BILLING
                        // WHERE A.NO_REGISTRASI=:noreg2");
                        // $this->db->bind('noreg', $nofixReg);
                        // $this->db->bind('noreg2', $nofixReg);
                        // $this->db->execute();

                    }

                    // INSERT POST TO KEMNKES

                    // $this->db->query("SELECT bridging_SatuSehat FROM MasterdataSQL.DBO.A_DATA_RS");
                    // $data =  $this->db->single();
                    //no urut reg
                    // $bridging_SatuSehat = $data['bridging_SatuSehat'];
                    // if ($bridging_SatuSehat == "1") {
                    //     $postData = $this->PostEncounter(
                    //         $idMrkemkes,
                    //         $namapasien,
                    //         $idDoktertKemkes,
                    //         $NamaDokter,
                    //         $xTglNowTempx,
                    //         $idUnitKemkes,
                    //         $NamaGrupPerawatan,
                    //         $nofixReg
                    //     );

                        // $this->db->query("UPDATE  PerawatanSQL.dbo.Visit 
                        // SET idRegKemenkes=:idRegKemenkes ,idDoktertKemkes=:idDoktertKemkes,idUnitKemkes=:idUnitKemkes
                        // where NoRegistrasi=:nofixReg");
                        // $this->db->bind('nofixReg', $nofixReg);
                        // $this->db->bind('idRegKemenkes', $postData['id']);
                        // $this->db->bind('idDoktertKemkes', $idDoktertKemkes);
                        // $this->db->bind('idUnitKemkes', $idUnitKemkes);
                        // $this->db->execute();

                        $waktuAwalkemkes = $xTglNowTempx . '-07:00';
                        $EndTime =  $xTglNowTempx . '-07:00';
                        $this->db->query("INSERT INTO DashboardData.dbo.Encounter_Update_Status 
                        (Noregistrasi,statusName,StartTime,EndTime)VALUES
                        (:nofixReg,:statusName,:StartTime,:EndTime)");
                        $this->db->bind('nofixReg', $nofixReg);
                        $this->db->bind('StartTime', $waktuAwalkemkes);
                        $this->db->bind('EndTime', $EndTime);
                        $this->db->bind('statusName', 'arrived');
                        $this->db->execute();
                    // }
                    // INSERT POST TO KEMNKES 


                    $this->db->commit();
                    $callback = array(
                        'status' => 'success',
                        'NoEpisode' => $NoEpisode,
                        'NoRegistrasi' => $nofixReg,
                        'NoAntrianPoli' => $fixNoAntrian,
                        'IdDokter' => $IdDokter,
                        'DokterName' => $NamaDokter,
                        'IdPoli' => $IdGrupPerawatan,
                        'PoliName' => $NamaGrupPerawatan,
                        'NoMR' => $NoMrfix,
                        'Namapasien' => $namapasien,
                        'JenisBayar' => $JenisBayar,
                        //'idRegKemenkes' => $idMrkemkes
                    );
                    return $callback;
                } else { // Jika Tidak Ada Registrasi Yang Aktif
                    $datenow2 = date('Y-m-d', strtotime($datenowcreate));
                    // cek diskon admin per jaminan
                    $this->db->query("SELECT  TOP 1 NoEpisode,right( REPLACE(NoEpisode,'-','0')  ,4) as urut,
                                    right( REPLACE(NoEpisode,'-','0')  ,4)+1, 
                                    NoRegistrasi,right( REPLACE(NoRegistrasi,'-','0') ,4) as urutreg
                                    FROM PerawatanSQL.dbo.Visit  WHERE  
                                    replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-')=:datenow2 
                                    AND LEFT(NoRegistrasi,4)=:kodeRegAwalXX ORDER BY id DESC");
                    $this->db->bind('datenow2', $datenow2);
                    $this->db->bind('kodeRegAwalXX', $kodeRegAwalXX);
                    $data =  $this->db->single();
                    // no urut op
                    $no_pass = $data['urut'];
                    $idx = $no_pass;
                    $idx++;
                    //no urut reg
                    $no_reg = $data['urutreg'];
                    $idReg = $no_reg;
                    $idReg++;

                    $awalOp = "OP";
                    $tenganOp = $NoMr;
                    $datenow = date('dmy', strtotime($datenowcreate));
                    $nourutfix = Utils::generateAutoNumberFourDigit($idx);
                    // generate No. Episode
                    $nofixOp = $awalOp . $tenganOp . '-' . $datenow . '-' . $nourutfix;
                    // GENERATE NO REGISTRASI 
                    $nourutfixReg = Utils::generateAutoNumberFourDigit($idReg);
                    if ($CodeRegis == "RJ") {
                        if ($JenisBayar == "1") {
                            $kodeRegAwal = "RJUM";
                        } else if ($JenisBayar == "2") {
                            $kodeRegAwal = "RJAS";
                        } else if ($JenisBayar == "5") {
                            $kodeRegAwal = "RJJP";
                        }
                    } elseif ($CodeRegis == "RJUL") {
                        $kodeRegAwal = "RJUL";
                    } elseif ($CodeRegis == "RJUR") {
                        $kodeRegAwal = "RJUR";
                    }
                    $nofixReg = $kodeRegAwal . $datenow . '-' . $nourutfixReg;


                    // GENERATE NO ANTRIAN POLI
                    $this->db->query("SELECT max(Antrian) as urutantrian
                                from PerawatanSQL.dbo.AntrianPasien  where  
                                replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-')=:datenow2 
                                and JamPraktek=:shift and Doctor_1=:IdDokter ");
                    $this->db->bind('datenow2', $datenow2);
                    $this->db->bind('shift', $shift);
                    $this->db->bind('IdDokter', $IdDokter);
                    $data =  $this->db->single();
                    //no urut reg
                    $no_urutantrian = $data['urutantrian'];
                    $idno_urutantrian = $no_urutantrian;
                    $idno_urutantrian++;

                    // CARI KODE ANTRIAN DOKTER
                    $this->db->query("SELECT *from MasterdataSQL.dbo.Doctors  where ID=:IdDokter ");
                    $this->db->bind('IdDokter', $IdDokter);
                    $data =  $this->db->single();
                    // no antrian
                    $CodeAntrian = $data['CodeAntrian'];

                    // fix no antrian
                    $fixNoAntrian = $CodeAntrian . '-' . $idno_urutantrian;
                    $uuidkemenkes = Utils::uuid4str();

                    $nullable = '0';
                    //$operator = "2384";
                    if ($JenisBayar === "2") { // ASURANSI 
                        //INSERT KE TABEL REGISTRASI
                        if ($NoReservasi <> "") {
                            $this->db->query("INSERT INTO perawatanSQL.dbo.Visit (ID,NoEpisode,NoRegistrasi,LokasiPasien,
                                CaraBayar,NoMR ,
                                PatientType,Unit,Doctor_1,Antrian,NoAntrianAll,Company,JamPraktek,Asuransi,Operator
                                ,idAdmin,idCaraMasuk,idCaraMasuk2,JenisDaftar
                                ,admclID,admPayorName,admpolicyNo,admpolicyDate,
                                admplanCode,admclStatus,admclDesc,admketstatus,admpayorMemberID,admcoveragetype,
                                FisioterapiFlag,TglKunjungan,[Visit Date],NoSEP,Tipe_Registrasi,ID_JadwalPraktek
                                , Catatan,KodeJaminanCOB,idRegKemenkes
                                ) VALUES (:id,:NoEpisode,:nofixReg,:NamaGrupPerawatan,
                               :nullable,:NoMrfix,
                                :JenisBayar,:IdGrupPerawatan,:IdDokter,:AntrianReservasi,:NoAntrianAllReservasi,:Company,:shift,:perusahaanid,:operator
                                ,:idadministrasi,:caramasukid,:referralid,:PasienJenisDaftar 
                                ,:admclID,:admPayorName,:admpolicyNo,:admpolicyDate,
                                :admplanCode,:admclStatus,:admclDesc,:admketstatus,:admpayorMemberID,
                                :admcoveragetype,:fisioflag,:tglregistrasi,:tglregistrasi2,:nosep,:tiperegistrasi,:JamPraktek,
                                :pxNoteRegistrasi,:COB,:uuidkemenkes)");
                            $this->db->bind('id', $id);
                            $this->db->bind('NoEpisode',  $nofixOp);
                            $this->db->bind('pxNoteRegistrasi',  $pxNoteRegistrasi);
                            $this->db->bind('nofixReg', $nofixReg);
                            $this->db->bind('NamaGrupPerawatan', $NamaGrupPerawatan);
                            $this->db->bind('nullable', $nullable);
                            $this->db->bind('NoMrfix', $NoMrfix);
                            $this->db->bind(
                                'JenisBayar',
                                $JenisBayar
                            );
                            $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                            $this->db->bind('IdDokter', $IdDokter);
                            $this->db->bind('AntrianReservasi', $AntrianReservasi);
                            $this->db->bind('NoAntrianAllReservasi', $NoAntrianAllReservasi);
                            $this->db->bind('Company', $Company);
                            $this->db->bind('shift', $shift);
                            $this->db->bind('perusahaanid', $perusahaanid);
                            $this->db->bind('operator', $operator);
                            $this->db->bind('idadministrasi', $idadministrasi);
                            $this->db->bind('caramasukid', $caramasukid);
                            $this->db->bind(
                                'referralid',
                                $referralid
                            );
                            $this->db->bind('PasienJenisDaftar', $PasienJenisDaftar);
                            $this->db->bind('admclID', $admclID);
                            $this->db->bind('admPayorName', $admPayorName);
                            $this->db->bind('admpolicyNo', $admpolicyNo);
                            $this->db->bind('admpolicyDate', $admpolicyDate);
                            $this->db->bind('admplanCode', $admplanCode);
                            $this->db->bind('admclStatus', $admclStatus);
                            $this->db->bind(
                                'admclDesc',
                                $admclDesc
                            );
                            $this->db->bind('admketstatus', $admketstatus);
                            $this->db->bind('admpayorMemberID', $admpayorMemberID);
                            $this->db->bind('admcoveragetype', $admcoveragetype);
                            $this->db->bind(
                                'fisioflag',
                                $fisioflag
                            );
                            $this->db->bind('tglregistrasi', $tglregistrasi);
                            $this->db->bind('tglregistrasi2', $tglregistrasi);
                            $this->db->bind('nosep', $nosep);
                            $this->db->bind('tiperegistrasi', $tiperegistrasi);
                            $this->db->bind('JamPraktek', $JamPraktek);
                            $this->db->bind('COB', $COB);
                            $this->db->bind('uuidkemenkes', $uuidkemenkes); 
                            
                            $this->db->execute();

                            // //INSERT ke DataRWJ 14-03-2023
                            // //GET DATA PASIEN
                            // $this->db->query("SELECT PatientName,
                            // KelurahanName,KecamatanName,CityName,ProvinceName,Gander,replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as Date_of_birth,Tipe_Idcard,ID_Card_number,Address,Marital_status,Religion,
                            // Education,[Home Phone],[Mobile Phone],Ocupation,[ZIP/Postal Code] as PostalCode
                            // ,Bahasa,Etnis,replace(CONVERT(VARCHAR(11), InputDate, 111), '/','-') as InputDate
                            // from MasterdataSQL.dbo.Admision 
                            // where  NoMR=:NoMrfix
                            // UNION ALL
                            // SELECT PatientName,
                            // KelurahanName,KecamatanName,CityName,ProvinceName,Gander,replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as Date_of_birth,Tipe_Idcard,ID_Card_number,Address,Marital_status,Religion,
                            // Education,[Home Phone],[Mobile Phone],Ocupation,[ZIP/Postal Code] as PostalCode
                            // ,Bahasa,Etnis,replace(CONVERT(VARCHAR(11), InputDate, 111), '/','-') as InputDate
                            // from MasterdataSQL.dbo.Admision_walkin 
                            // where  NoMR=:NoMrfix2");
                            // $this->db->bind('NoMrfix', $NoMrfix);
                            // $this->db->bind('NoMrfix2', $NoMrfix);
                            // $datag =  $this->db->single();
                            // $PatientName = $datag['PatientName'];
                            // $KelurahanName = $datag['KelurahanName'];
                            // $KecamatanName = $datag['KecamatanName'];
                            // $CityName = $datag['CityName'];
                            // $ProvinceName = $datag['ProvinceName'];
                            // $Gander = $datag['Gander'];
                            // $Date_of_birth = $datag['Date_of_birth'];
                            // $Tipe_Idcard = $datag['Tipe_Idcard'];
                            // $ID_Card_number = $datag['ID_Card_number'];
                            // $Address = $datag['Address'];
                            // $Marital_status = $datag['Marital_status'];
                            // $Religion = $datag['Religion'];
                            // $Education = $datag['Education'];
                            // $HomePhone = $datag['Home Phone'];
                            // $MobilePhone = $datag['Mobile Phone'];
                            // $Ocupation = $datag['Ocupation'];
                            // $PostalCode = $datag['PostalCode'];
                            // $Bahasa = $datag['Bahasa'];
                            // $Etnis = $datag['Etnis'];
                            // $InputDate = $datag['InputDate'];

                            // //GET CARA MASUK
                            // $querry = "SELECT NamaCaraMasuk
                            //     from MasterdataSQL.dbo.MstrCaraMasuk
                            //     where id=:caramasukid";
                            // $this->db->query($querry);
                            // $this->db->bind('caramasukid', $caramasukid);
                            // $dataf =  $this->db->single();
                            // $NamaCaraMasuk = $dataf['NamaCaraMasuk']; 

                            // // GET DATA KARCIS
                            //     $this->db->query("SELECT ID, Nama_Karcis,Nilai_Karcis
                            //     from MasterdataSQL.dbo.MstrKarcisAdministrasi  
                            //     where  ID=:idadministrasi");
                            // $this->db->bind('idadministrasi', $idadministrasi);
                            // $data =  $this->db->single();
                            // $Nama_Karcis = $data['Nama_Karcis'];
                            // $Nilai_Karcis = $data['Nilai_Karcis'];

                            // if (strtotime($tglregistrasi_Ymd) > strtotime($InputDate)){
                            //     $BL = 'LAMA';
                            // }else{
                            //     $BL = 'BARU';
                            // }

                            // $this->db->query("INSERT INTO DashboardData.dbo.DataRWJ (NoEpisode,NoRegistrasi,NoMR,PatientName,[Visit Date],
                            // Kelurahan,Kecamatan,kabupatenNama,ProvinsiNama,BL,TipePasien,FP,
                            // KodeJaminan,NamaJaminan,Sex,DateOfBirth,TipeIdCard, NoIdCard, Address,MaritalStatus,Religion,
                            // Education,HomePhone,MobilePhone,Pekerjaan,KodePos,IdUnit,NamaUnit,IdDokter,NamaDokter,
                            // NoPesertaBPJS,NoSep,JamPraktek,StatusID,OperatorId,
                            // Lockbill,JenisDaftar,Telemedicine,Appointment_ID,Tipe_Registrasi,Id_Jadwal_Praktek,
                            // idCaraMasuk,idCaraMasuk2,idAdmin,NoAntrianAll,Company,NamaCaraMasuk,NamaCaraMasukRef,NamaKarcis,NilaiKarcis,hosnamedata,datatimestamp,Bahasa,Etnis
                            // ) VALUES ( :NoEpisode, :nofixReg,:NoMrfix,:PatientName,:tglregistrasi,
                            //         :KelurahanName,:KecamatanName,:CityName,:ProvinceName,
                            //         :BL
                            //         ,:JenisBayar,'1',
                            //         :perusahaanid,:NamaPerusahaan,:Gander,:Date_of_birth,:Tipe_Idcard,:ID_Card_number,:Address,:Marital_status,:Religion,
                            //         :Education,:HomePhone,:MobilePhone,:Ocupation,:PostalCode
                            //         ,:IdGrupPerawatan,:NamaGrupPerawatan,:IdDokter,:NamaDokter,
                            //         :NoPesertaBPJS,:nosep,:shift,:StatusID,:operator,
                            //         :LockBill,:PasienJenisDaftar,:TelemedicineIs,:appointment_id,:tiperegistrasi,:JamPraktek,
                            //         :caramasukid,:referralid,:idadministrasi,:fixNoAntrian,:Company,:NamaCaraMasuk,:NamaCaraMasukRef,:Nama_Karcis,:Nilai_Karcis,host_name(),:datenowcreate
                            //         ,:Bahasa,:Etnis)
                            //         ");
                            // $this->db->bind('NoEpisode', $nofixOp);
                            // $this->db->bind('nofixReg', $nofixReg);
                            // $this->db->bind('NoMrfix', $NoMrfix);
                            // $this->db->bind('PatientName', $PatientName);
                            // $this->db->bind('tglregistrasi', $tglregistrasi);
                            // $this->db->bind('KelurahanName', $KelurahanName);
                            // $this->db->bind('KecamatanName', $KecamatanName);
                            // $this->db->bind('CityName', $CityName);
                            // $this->db->bind('ProvinceName', $ProvinceName);
                            // $this->db->bind('BL', $BL);
                            // $this->db->bind('JenisBayar', $JenisBayar);
                            // $this->db->bind('perusahaanid', $perusahaanid);
                            // $this->db->bind('NamaPerusahaan', $shownamaperusahaanfix);
                            // $this->db->bind('Gander', $Gander);
                            // $this->db->bind('Date_of_birth', $Date_of_birth);
                            // $this->db->bind('Tipe_Idcard', $Tipe_Idcard);
                            // $this->db->bind('ID_Card_number', $ID_Card_number);
                            // $this->db->bind('Address', $Address);
                            // $this->db->bind('Marital_status', $Marital_status);
                            // $this->db->bind('Religion', $Religion);
                            // $this->db->bind('Education', $Education);
                            // $this->db->bind('HomePhone', $HomePhone);
                            // $this->db->bind('MobilePhone', $MobilePhone);
                            // $this->db->bind('Ocupation', $Ocupation);
                            // $this->db->bind('PostalCode', $PostalCode);
                            // $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                            // $this->db->bind('NamaGrupPerawatan', $NamaGrupPerawatan);
                            // $this->db->bind('IdDokter', $IdDokter);
                            // $this->db->bind('NamaDokter', $NamaDokter);
                            // $this->db->bind('NoPesertaBPJS', null);
                            // $this->db->bind('nosep', $nosep);
                            // $this->db->bind('shift', $shift);
                            // $this->db->bind('StatusID', '0');
                            // $this->db->bind('operator', $operator);
                            // $this->db->bind('LockBill', '0');
                            // $this->db->bind('PasienJenisDaftar', $PasienJenisDaftar);
                            // $this->db->bind('TelemedicineIs', '0');
                            // $this->db->bind('appointment_id', null);
                            // $this->db->bind('tiperegistrasi', $tiperegistrasi);
                            // $this->db->bind('JamPraktek', $JamPraktek);
                            // $this->db->bind('caramasukid', $caramasukid);
                            // $this->db->bind('referralid', $referralid);
                            // $this->db->bind('idadministrasi', $idadministrasi);
                            // $this->db->bind('fixNoAntrian', $fixNoAntrian);
                            // $this->db->bind('Company', $Company);
                            // $this->db->bind('NamaCaraMasuk', $NamaCaraMasuk);
                            // $this->db->bind('NamaCaraMasukRef', $showrefferalfix);
                            // $this->db->bind('Nama_Karcis', $Nama_Karcis);
                            // $this->db->bind('Nilai_Karcis', $Nilai_Karcis);
                            // $this->db->bind('Bahasa', $Bahasa);
                            // $this->db->bind('Etnis', $Etnis);
                            // $this->db->bind('datenowcreate', $datenowcreate);
                            // $this->db->execute(); 
                            // //---#END INSERT DATARWJ
                            //Update Nomor Registrasi EMR_OrderOperasi
                            if ($idodc <> '') {
                                //Update NoEpisode ODC
                                $this->db->query("SELECT NoEpisode
                            from MedicalRecord.dbo.MR_PermintaanRawat_ODC
                            where  ID=:idodc");
                                $this->db->bind('idodc', $idodc);
                                $data =  $this->db->single();
                                $NoEpisode_odc = $data['NoEpisode'];

                                // UPDATE TABEL Visit No Episode
                                $this->db->query("UPDATE PerawatanSQL.dbo.Visit
                        SET NoEpisode=:NoEpisode_odc where NoRegistrasi=:nofixReg");
                                $this->db->bind('nofixReg', $nofixReg);
                                $this->db->bind('NoEpisode_odc', $NoEpisode_odc);
                                $this->db->execute();

                                // UPDATE TABEL EMR_ORDEROPERASI
                                $this->db->query("UPDATE MedicalRecord.dbo.EMR_OrderOperasi
                            SET NoRegistrasi=:nofixReg where NoRegistrasi in (SELECT NoRegistrasi FROM MedicalRecord.dbo.MR_PermintaanRawat_ODC WHERE ID=:idodc) and StatusOrder not in('Close' , 'Batal', 'cancel') ");
                                $this->db->bind('nofixReg', $nofixReg);
                                $this->db->bind('idodc', $idodc);
                                $this->db->execute();

                                // UPDATE TABEL MR_PermintaanRawat_ODC
                                $this->db->query("UPDATE MedicalRecord.dbo.MR_PermintaanRawat_ODC
                            SET StatusRegis='1' where ID=:idodc");
                                $this->db->bind('idodc', $idodc);
                                $this->db->execute();


                                // // UPDATE TABEL EMR_ORDEROPERASI
                                // $this->db->query("UPDATE MedicalRecord.dbo.MR_LaporanOperasi
                                //  SET NoRegistrasi=:nofinalreg where NoRegistrasi=:noregisrwj");
                                // $this->db->bind('nofinalreg', $nofinalreg);
                                // $this->db->bind('noregisrwj', $noregisrwj);
                                // $this->db->execute();
                                //#END Update Nomor Registrasi EMR_OrderOperasi
                            }
                        } elseif ($NoReservasi == "") {
                            $this->db->query("INSERT INTO perawatanSQL.dbo.Visit (ID,NoEpisode,NoRegistrasi,LokasiPasien,
                                CaraBayar,NoMR ,
                                PatientType,Unit,Doctor_1,Antrian,NoAntrianAll,Company,JamPraktek,Asuransi,Operator
                                ,idAdmin,idCaraMasuk,idCaraMasuk2,JenisDaftar
                                ,admclID,admPayorName,admpolicyNo,admpolicyDate,
                                admplanCode,admclStatus,admclDesc,admketstatus,admpayorMemberID,admcoveragetype,
                                FisioterapiFlag,TglKunjungan,[Visit Date],NoSEP,Tipe_Registrasi,ID_JadwalPraktek,
                                Catatan,KodeJaminanCOB,idRegKemenkes
                                ) VALUES (:id,:NoEpisode,:nofixReg,:NamaGrupPerawatan,
                               :nullable,:NoMrfix,
                                :JenisBayar,:IdGrupPerawatan,:IdDokter,:idno_urutantrian,:fixNoAntrian,:Company,:shift,:perusahaanid,:operator
                                ,:idadministrasi,:caramasukid,:referralid,:PasienJenisDaftar 
                                ,:admclID,:admPayorName,:admpolicyNo,:admpolicyDate,
                                :admplanCode,:admclStatus,:admclDesc,:admketstatus,:admpayorMemberID,
                                :admcoveragetype,:fisioflag,:tglregistrasi,:tglregistrasi2,:nosep,:tiperegistrasi,:JamPraktek,
                                :pxNoteRegistrasi,:COB,:uuidkemenkes)");
                            $this->db->bind('id', $id);
                            $this->db->bind('pxNoteRegistrasi',  $pxNoteRegistrasi);
                            $this->db->bind('NoEpisode',  $nofixOp);
                            $this->db->bind('nofixReg', $nofixReg);
                            $this->db->bind('NamaGrupPerawatan', $NamaGrupPerawatan);
                            $this->db->bind('nullable', $nullable);
                            $this->db->bind('NoMrfix', $NoMrfix);
                            $this->db->bind(
                                'JenisBayar',
                                $JenisBayar
                            );
                            $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                            $this->db->bind('IdDokter', $IdDokter);
                            $this->db->bind('idno_urutantrian', $idno_urutantrian);
                            $this->db->bind('fixNoAntrian', $fixNoAntrian);
                            $this->db->bind('Company', $Company);
                            $this->db->bind('shift', $shift);
                            $this->db->bind('perusahaanid', $perusahaanid);
                            $this->db->bind('operator', $operator);
                            $this->db->bind('idadministrasi', $idadministrasi);
                            $this->db->bind('caramasukid', $caramasukid);
                            $this->db->bind(
                                'referralid',
                                $referralid
                            );
                            $this->db->bind('PasienJenisDaftar', $PasienJenisDaftar);
                            $this->db->bind('admclID', $admclID);
                            $this->db->bind('admPayorName', $admPayorName);
                            $this->db->bind('admpolicyNo', $admpolicyNo);
                            $this->db->bind('admpolicyDate', $admpolicyDate);
                            $this->db->bind('admplanCode', $admplanCode);
                            $this->db->bind('admclStatus', $admclStatus);
                            $this->db->bind(
                                'admclDesc',
                                $admclDesc
                            );
                            $this->db->bind('admketstatus', $admketstatus);
                            $this->db->bind('admpayorMemberID', $admpayorMemberID);
                            $this->db->bind('admcoveragetype', $admcoveragetype);
                            $this->db->bind(
                                'fisioflag',
                                $fisioflag
                            );
                            $this->db->bind('tglregistrasi', $tglregistrasi);
                            $this->db->bind('tglregistrasi2', $tglregistrasi);
                            $this->db->bind('nosep', $nosep);
                            $this->db->bind('tiperegistrasi', $tiperegistrasi);
                            $this->db->bind('JamPraktek', $JamPraktek);
                            $this->db->bind('COB', $COB);
                            $this->db->bind('uuidkemenkes', $uuidkemenkes); 
                            $this->db->execute();

                            // //INSERT ke DataRWJ 14-03-2023
                            // //GET DATA PASIEN
                            // $this->db->query("SELECT PatientName,
                            // KelurahanName,KecamatanName,CityName,ProvinceName,Gander,replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as Date_of_birth,Tipe_Idcard,ID_Card_number,Address,Marital_status,Religion,
                            // Education,[Home Phone],[Mobile Phone],Ocupation,[ZIP/Postal Code] as PostalCode
                            // ,Bahasa,Etnis,replace(CONVERT(VARCHAR(11), InputDate, 111), '/','-') as InputDate
                            // from MasterdataSQL.dbo.Admision 
                            // where  NoMR=:NoMrfix
                            // UNION ALL
                            // SELECT PatientName,
                            // KelurahanName,KecamatanName,CityName,ProvinceName,Gander,replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as Date_of_birth,Tipe_Idcard,ID_Card_number,Address,Marital_status,Religion,
                            // Education,[Home Phone],[Mobile Phone],Ocupation,[ZIP/Postal Code] as PostalCode
                            // ,Bahasa,Etnis,replace(CONVERT(VARCHAR(11), InputDate, 111), '/','-') as InputDate
                            // from MasterdataSQL.dbo.Admision_walkin 
                            // where  NoMR=:NoMrfix2");
                            // $this->db->bind('NoMrfix', $NoMrfix);
                            // $this->db->bind('NoMrfix2', $NoMrfix);
                            // $datag =  $this->db->single();
                            // $PatientName = $datag['PatientName'];
                            // $KelurahanName = $datag['KelurahanName'];
                            // $KecamatanName = $datag['KecamatanName'];
                            // $CityName = $datag['CityName'];
                            // $ProvinceName = $datag['ProvinceName'];
                            // $Gander = $datag['Gander'];
                            // $Date_of_birth = $datag['Date_of_birth'];
                            // $Tipe_Idcard = $datag['Tipe_Idcard'];
                            // $ID_Card_number = $datag['ID_Card_number'];
                            // $Address = $datag['Address'];
                            // $Marital_status = $datag['Marital_status'];
                            // $Religion = $datag['Religion'];
                            // $Education = $datag['Education'];
                            // $HomePhone = $datag['Home Phone'];
                            // $MobilePhone = $datag['Mobile Phone'];
                            // $Ocupation = $datag['Ocupation'];
                            // $PostalCode = $datag['PostalCode'];
                            // $Bahasa = $datag['Bahasa'];
                            // $Etnis = $datag['Etnis'];
                            // $InputDate = $datag['InputDate'];

                            // //GET CARA MASUK
                            // $querry = "SELECT NamaCaraMasuk
                            //     from MasterdataSQL.dbo.MstrCaraMasuk
                            //     where id=:caramasukid";
                            // $this->db->query($querry);
                            // $this->db->bind('caramasukid', $caramasukid);
                            // $dataf =  $this->db->single();
                            // $NamaCaraMasuk = $dataf['NamaCaraMasuk']; 

                            // // GET DATA KARCIS
                            //     $this->db->query("SELECT ID, Nama_Karcis,Nilai_Karcis
                            //     from MasterdataSQL.dbo.MstrKarcisAdministrasi  
                            //     where  ID=:idadministrasi");
                            // $this->db->bind('idadministrasi', $idadministrasi);
                            // $data =  $this->db->single();
                            // $Nama_Karcis = $data['Nama_Karcis'];
                            // $Nilai_Karcis = $data['Nilai_Karcis'];

                            // if (strtotime($tglregistrasi_Ymd) > strtotime($InputDate)){
                            //     $BL = 'LAMA';
                            // }else{
                            //     $BL = 'BARU';
                            // }

                            // $this->db->query("INSERT INTO DashboardData.dbo.DataRWJ (NoEpisode,NoRegistrasi,NoMR,PatientName,[Visit Date],
                            // Kelurahan,Kecamatan,kabupatenNama,ProvinsiNama,BL,TipePasien,FP,
                            // KodeJaminan,NamaJaminan,Sex,DateOfBirth,TipeIdCard, NoIdCard, Address,MaritalStatus,Religion,
                            // Education,HomePhone,MobilePhone,Pekerjaan,KodePos,IdUnit,NamaUnit,IdDokter,NamaDokter,
                            // NoPesertaBPJS,NoSep,JamPraktek,StatusID,OperatorId,
                            // Lockbill,JenisDaftar,Telemedicine,Appointment_ID,Tipe_Registrasi,Id_Jadwal_Praktek,
                            // idCaraMasuk,idCaraMasuk2,idAdmin,NoAntrianAll,Company,NamaCaraMasuk,NamaCaraMasukRef,NamaKarcis,NilaiKarcis,hosnamedata,datatimestamp,Bahasa,Etnis
                            // ) VALUES ( :NoEpisode, :nofixReg,:NoMrfix,:PatientName,:tglregistrasi,
                            //         :KelurahanName,:KecamatanName,:CityName,:ProvinceName,
                            //         :BL
                            //         ,:JenisBayar,'1',
                            //         :perusahaanid,:NamaPerusahaan,:Gander,:Date_of_birth,:Tipe_Idcard,:ID_Card_number,:Address,:Marital_status,:Religion,
                            //         :Education,:HomePhone,:MobilePhone,:Ocupation,:PostalCode
                            //         ,:IdGrupPerawatan,:NamaGrupPerawatan,:IdDokter,:NamaDokter,
                            //         :NoPesertaBPJS,:nosep,:shift,:StatusID,:operator,
                            //         :LockBill,:PasienJenisDaftar,:TelemedicineIs,:appointment_id,:tiperegistrasi,:JamPraktek,
                            //         :caramasukid,:referralid,:idadministrasi,:fixNoAntrian,:Company,:NamaCaraMasuk,:NamaCaraMasukRef,:Nama_Karcis,:Nilai_Karcis,host_name(),:datenowcreate
                            //         ,:Bahasa,:Etnis)
                            //         ");
                            // $this->db->bind('NoEpisode', $nofixOp);
                            // $this->db->bind('nofixReg', $nofixReg);
                            // $this->db->bind('NoMrfix', $NoMrfix);
                            // $this->db->bind('PatientName', $PatientName);
                            // $this->db->bind('tglregistrasi', $tglregistrasi);
                            // $this->db->bind('KelurahanName', $KelurahanName);
                            // $this->db->bind('KecamatanName', $KecamatanName);
                            // $this->db->bind('CityName', $CityName);
                            // $this->db->bind('ProvinceName', $ProvinceName);
                            // $this->db->bind('BL', $BL);
                            // $this->db->bind('JenisBayar', $JenisBayar);
                            // $this->db->bind('perusahaanid', $perusahaanid);
                            // $this->db->bind('NamaPerusahaan', $shownamaperusahaanfix);
                            // $this->db->bind('Gander', $Gander);
                            // $this->db->bind('Date_of_birth', $Date_of_birth);
                            // $this->db->bind('Tipe_Idcard', $Tipe_Idcard);
                            // $this->db->bind('ID_Card_number', $ID_Card_number);
                            // $this->db->bind('Address', $Address);
                            // $this->db->bind('Marital_status', $Marital_status);
                            // $this->db->bind('Religion', $Religion);
                            // $this->db->bind('Education', $Education);
                            // $this->db->bind('HomePhone', $HomePhone);
                            // $this->db->bind('MobilePhone', $MobilePhone);
                            // $this->db->bind('Ocupation', $Ocupation);
                            // $this->db->bind('PostalCode', $PostalCode);
                            // $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                            // $this->db->bind('NamaGrupPerawatan', $NamaGrupPerawatan);
                            // $this->db->bind('IdDokter', $IdDokter);
                            // $this->db->bind('NamaDokter', $NamaDokter);
                            // $this->db->bind('NoPesertaBPJS', null);
                            // $this->db->bind('nosep', $nosep);
                            // $this->db->bind('shift', $shift);
                            // $this->db->bind('StatusID', '0');
                            // $this->db->bind('operator', $operator);
                            // $this->db->bind('LockBill', '0');
                            // $this->db->bind('PasienJenisDaftar', $PasienJenisDaftar);
                            // $this->db->bind('TelemedicineIs', '0');
                            // $this->db->bind('appointment_id', null);
                            // $this->db->bind('tiperegistrasi', $tiperegistrasi);
                            // $this->db->bind('JamPraktek', $JamPraktek);
                            // $this->db->bind('caramasukid', $caramasukid);
                            // $this->db->bind('referralid', $referralid);
                            // $this->db->bind('idadministrasi', $idadministrasi);
                            // $this->db->bind('fixNoAntrian', $fixNoAntrian);
                            // $this->db->bind('Company', $Company);
                            // $this->db->bind('NamaCaraMasuk', $NamaCaraMasuk);
                            // $this->db->bind('NamaCaraMasukRef', $showrefferalfix);
                            // $this->db->bind('Nama_Karcis', $Nama_Karcis);
                            // $this->db->bind('Nilai_Karcis', $Nilai_Karcis);
                            // $this->db->bind('Bahasa', $Bahasa);
                            // $this->db->bind('Etnis', $Etnis);
                            // $this->db->bind('datenowcreate', $datenowcreate);
                            // $this->db->execute(); 
                            // //---#END INSERT DATARWJ
                            //Update Nomor Registrasi EMR_OrderOperasi
                            if ($idodc <> '') {
                                //Update NoEpisode ODC
                                $this->db->query("SELECT NoEpisode
                            from MedicalRecord.dbo.MR_PermintaanRawat_ODC
                            where  ID=:idodc");
                                $this->db->bind('idodc', $idodc);
                                $data =  $this->db->single();
                                $NoEpisode_odc = $data['NoEpisode'];

                                // UPDATE TABEL Visit No Episode
                                $this->db->query("UPDATE PerawatanSQL.dbo.Visit
                        SET NoEpisode=:NoEpisode_odc where NoRegistrasi=:nofixReg");
                                $this->db->bind('nofixReg', $nofixReg);
                                $this->db->bind('NoEpisode_odc', $NoEpisode_odc);
                                $this->db->execute();

                                // UPDATE TABEL EMR_ORDEROPERASI
                                $this->db->query("UPDATE MedicalRecord.dbo.EMR_OrderOperasi
                            SET NoRegistrasi=:nofixReg where NoRegistrasi in (SELECT NoRegistrasi FROM MedicalRecord.dbo.MR_PermintaanRawat_ODC WHERE ID=:idodc) and StatusOrder not in('Close' , 'Batal', 'cancel') ");
                                $this->db->bind('nofixReg', $nofixReg);
                                $this->db->bind('idodc', $idodc);
                                $this->db->execute();

                                // UPDATE TABEL MR_PermintaanRawat_ODC
                                $this->db->query("UPDATE MedicalRecord.dbo.MR_PermintaanRawat_ODC
                            SET StatusRegis='1' where ID=:idodc");
                                $this->db->bind('idodc', $idodc);
                                $this->db->execute();


                                // // UPDATE TABEL EMR_ORDEROPERASI
                                // $this->db->query("UPDATE MedicalRecord.dbo.MR_LaporanOperasi
                                //  SET NoRegistrasi=:nofinalreg where NoRegistrasi=:noregisrwj");
                                // $this->db->bind('nofinalreg', $nofinalreg);
                                // $this->db->bind('noregisrwj', $noregisrwj);
                                // $this->db->execute();
                                //#END Update Nomor Registrasi EMR_OrderOperasi
                            }
                        }
                        // cek diskon admin per jaminan
                        $this->db->query("SELECT RJ_Disc_Administrasi 
                                            from MasterdataSQL.dbo.MstrPerusahaanAsuransi 
                                          where id=:JenisBayar");
                        $this->db->bind('JenisBayar', $JenisBayar);
                        $data =  $this->db->single();
                        $RJ_Disc_Administrasi = $data['RJ_Disc_Administrasi'];
                        $adminmindisc = $RJ_Disc_Administrasi * $nilaiadminstrasi;
                        $nilaiadministrasifix = $nilaiadminstrasi - $adminmindisc;
                    } else {
                        //INSERT KE TABEL REGISTRASI
                        if ($NoReservasi <> "") {
                            $this->db->query("INSERT INTO perawatanSQL.dbo.Visit (ID,NoEpisode,NoRegistrasi,LokasiPasien,
                                CaraBayar,NoMR ,
                                PatientType,Unit,Doctor_1,Antrian,NoAntrianAll,Company,JamPraktek,Perusahaan,Operator
                                ,idAdmin,idCaraMasuk,idCaraMasuk2,JenisDaftar
                                ,admclID,admPayorName,admpolicyNo,admpolicyDate,
                                admplanCode,admclStatus,admclDesc,admketstatus,admpayorMemberID,admcoveragetype,
                                FisioterapiFlag,TglKunjungan,[Visit Date],NoSEP,Tipe_Registrasi,ID_JadwalPraktek,
                                Catatan,KodeJaminanCOB,idRegKemenkes
                                ) VALUES (:id,:NoEpisode,:nofixReg,:NamaGrupPerawatan,
                               :nullable,:NoMrfix,
                                :JenisBayar,:IdGrupPerawatan,:IdDokter,:AntrianReservasi,:NoAntrianAllReservasi,:Company,:shift,:perusahaanid,:operator
                                ,:idadministrasi,:caramasukid,:referralid,:PasienJenisDaftar 
                                ,:admclID,:admPayorName,:admpolicyNo,:admpolicyDate,
                                :admplanCode,:admclStatus,:admclDesc,:admketstatus,:admpayorMemberID,
                                :admcoveragetype,:fisioflag,:tglregistrasi,:tglregistrasi2,:nosep,:tiperegistrasi,:JamPraktek,
                                :pxNoteRegistrasi,:COB,:uuidkemenkes)");
                            $this->db->bind('id', $id);
                            $this->db->bind('pxNoteRegistrasi', $pxNoteRegistrasi);
                            $this->db->bind('NoEpisode', $nofixOp);
                            $this->db->bind('nofixReg', $nofixReg);
                            $this->db->bind('NamaGrupPerawatan', $NamaGrupPerawatan);
                            $this->db->bind('nullable', $nullable);
                            $this->db->bind('NoMrfix', $NoMrfix);
                            $this->db->bind(
                                'JenisBayar',
                                $JenisBayar
                            );
                            $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                            $this->db->bind('IdDokter', $IdDokter);
                            $this->db->bind('AntrianReservasi', $AntrianReservasi);
                            $this->db->bind('NoAntrianAllReservasi', $NoAntrianAllReservasi);
                            $this->db->bind('Company', $Company);
                            $this->db->bind('shift', $shift);
                            $this->db->bind('perusahaanid', $perusahaanid);
                            $this->db->bind('operator', $operator);
                            $this->db->bind('idadministrasi', $idadministrasi);
                            $this->db->bind('caramasukid', $caramasukid);
                            $this->db->bind(
                                'referralid',
                                $referralid
                            );
                            $this->db->bind('PasienJenisDaftar', $PasienJenisDaftar);
                            $this->db->bind('admclID', $admclID);
                            $this->db->bind('admPayorName', $admPayorName);
                            $this->db->bind('admpolicyNo', $admpolicyNo);
                            $this->db->bind('admpolicyDate', $admpolicyDate);
                            $this->db->bind('admplanCode', $admplanCode);
                            $this->db->bind('admclStatus', $admclStatus);
                            $this->db->bind(
                                'admclDesc',
                                $admclDesc
                            );
                            $this->db->bind('admketstatus', $admketstatus);
                            $this->db->bind('admpayorMemberID', $admpayorMemberID);
                            $this->db->bind('admcoveragetype', $admcoveragetype);
                            $this->db->bind(
                                'fisioflag',
                                $fisioflag
                            );
                            $this->db->bind('tglregistrasi', $tglregistrasi);
                            $this->db->bind('tglregistrasi2', $tglregistrasi);
                            $this->db->bind('nosep', $nosep);
                            $this->db->bind('tiperegistrasi', $tiperegistrasi);
                            $this->db->bind('JamPraktek', $JamPraktek);
                            $this->db->bind('COB', $COB);
                            $this->db->bind('uuidkemenkes', $uuidkemenkes); 
                            $this->db->execute();

                            // //INSERT ke DataRWJ 14-03-2023
                            // //GET DATA PASIEN
                            // $this->db->query("SELECT PatientName,
                            // KelurahanName,KecamatanName,CityName,ProvinceName,Gander,replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as Date_of_birth,Tipe_Idcard,ID_Card_number,Address,Marital_status,Religion,
                            // Education,[Home Phone],[Mobile Phone],Ocupation,[ZIP/Postal Code] as PostalCode
                            // ,Bahasa,Etnis,replace(CONVERT(VARCHAR(11), InputDate, 111), '/','-') as InputDate
                            // from MasterdataSQL.dbo.Admision 
                            // where  NoMR=:NoMrfix
                            // UNION ALL
                            // SELECT PatientName,
                            // KelurahanName,KecamatanName,CityName,ProvinceName,Gander,replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as Date_of_birth,Tipe_Idcard,ID_Card_number,Address,Marital_status,Religion,
                            // Education,[Home Phone],[Mobile Phone],Ocupation,[ZIP/Postal Code] as PostalCode
                            // ,Bahasa,Etnis,replace(CONVERT(VARCHAR(11), InputDate, 111), '/','-') as InputDate
                            // from MasterdataSQL.dbo.Admision_walkin 
                            // where  NoMR=:NoMrfix2");
                            // $this->db->bind('NoMrfix', $NoMrfix);
                            // $this->db->bind('NoMrfix2', $NoMrfix);
                            // $datag =  $this->db->single();
                            // $PatientName = $datag['PatientName'];
                            // $KelurahanName = $datag['KelurahanName'];
                            // $KecamatanName = $datag['KecamatanName'];
                            // $CityName = $datag['CityName'];
                            // $ProvinceName = $datag['ProvinceName'];
                            // $Gander = $datag['Gander'];
                            // $Date_of_birth = $datag['Date_of_birth'];
                            // $Tipe_Idcard = $datag['Tipe_Idcard'];
                            // $ID_Card_number = $datag['ID_Card_number'];
                            // $Address = $datag['Address'];
                            // $Marital_status = $datag['Marital_status'];
                            // $Religion = $datag['Religion'];
                            // $Education = $datag['Education'];
                            // $HomePhone = $datag['Home Phone'];
                            // $MobilePhone = $datag['Mobile Phone'];
                            // $Ocupation = $datag['Ocupation'];
                            // $PostalCode = $datag['PostalCode'];
                            // $Bahasa = $datag['Bahasa'];
                            // $Etnis = $datag['Etnis'];
                            // $InputDate = $datag['InputDate'];

                            // //GET CARA MASUK
                            // $querry = "SELECT NamaCaraMasuk
                            //     from MasterdataSQL.dbo.MstrCaraMasuk
                            //     where id=:caramasukid";
                            // $this->db->query($querry);
                            // $this->db->bind('caramasukid', $caramasukid);
                            // $dataf =  $this->db->single();
                            // $NamaCaraMasuk = $dataf['NamaCaraMasuk']; 

                            // // GET DATA KARCIS
                            //     $this->db->query("SELECT ID, Nama_Karcis,Nilai_Karcis
                            //     from MasterdataSQL.dbo.MstrKarcisAdministrasi  
                            //     where  ID=:idadministrasi");
                            // $this->db->bind('idadministrasi', $idadministrasi);
                            // $data =  $this->db->single();
                            // $Nama_Karcis = $data['Nama_Karcis'];
                            // $Nilai_Karcis = $data['Nilai_Karcis'];

                            // if (strtotime($tglregistrasi_Ymd) > strtotime($InputDate)){
                            //     $BL = 'LAMA';
                            // }else{
                            //     $BL = 'BARU';
                            // }

                            // $this->db->query("INSERT INTO DashboardData.dbo.DataRWJ (NoEpisode,NoRegistrasi,NoMR,PatientName,[Visit Date],
                            // Kelurahan,Kecamatan,kabupatenNama,ProvinsiNama,BL,TipePasien,FP,
                            // KodeJaminan,NamaJaminan,Sex,DateOfBirth,TipeIdCard, NoIdCard, Address,MaritalStatus,Religion,
                            // Education,HomePhone,MobilePhone,Pekerjaan,KodePos,IdUnit,NamaUnit,IdDokter,NamaDokter,
                            // NoPesertaBPJS,NoSep,JamPraktek,StatusID,OperatorId,
                            // Lockbill,JenisDaftar,Telemedicine,Appointment_ID,Tipe_Registrasi,Id_Jadwal_Praktek,
                            // idCaraMasuk,idCaraMasuk2,idAdmin,NoAntrianAll,Company,NamaCaraMasuk,NamaCaraMasukRef,NamaKarcis,NilaiKarcis,hosnamedata,datatimestamp,Bahasa,Etnis
                            // ) VALUES ( :NoEpisode, :nofixReg,:NoMrfix,:PatientName,:tglregistrasi,
                            //         :KelurahanName,:KecamatanName,:CityName,:ProvinceName,
                            //         :BL
                            //         ,:JenisBayar,'1',
                            //         :perusahaanid,:NamaPerusahaan,:Gander,:Date_of_birth,:Tipe_Idcard,:ID_Card_number,:Address,:Marital_status,:Religion,
                            //         :Education,:HomePhone,:MobilePhone,:Ocupation,:PostalCode
                            //         ,:IdGrupPerawatan,:NamaGrupPerawatan,:IdDokter,:NamaDokter,
                            //         :NoPesertaBPJS,:nosep,:shift,:StatusID,:operator,
                            //         :LockBill,:PasienJenisDaftar,:TelemedicineIs,:appointment_id,:tiperegistrasi,:JamPraktek,
                            //         :caramasukid,:referralid,:idadministrasi,:fixNoAntrian,:Company,:NamaCaraMasuk,:NamaCaraMasukRef,:Nama_Karcis,:Nilai_Karcis,host_name(),:datenowcreate
                            //         ,:Bahasa,:Etnis)
                            //         ");
                            // $this->db->bind('NoEpisode', $nofixOp);
                            // $this->db->bind('nofixReg', $nofixReg);
                            // $this->db->bind('NoMrfix', $NoMrfix);
                            // $this->db->bind('PatientName', $PatientName);
                            // $this->db->bind('tglregistrasi', $tglregistrasi);
                            // $this->db->bind('KelurahanName', $KelurahanName);
                            // $this->db->bind('KecamatanName', $KecamatanName);
                            // $this->db->bind('CityName', $CityName);
                            // $this->db->bind('ProvinceName', $ProvinceName);
                            // $this->db->bind('BL', $BL);
                            // $this->db->bind('JenisBayar', $JenisBayar);
                            // $this->db->bind('perusahaanid', $perusahaanid);
                            // $this->db->bind('NamaPerusahaan', $shownamaperusahaanfix);
                            // $this->db->bind('Gander', $Gander);
                            // $this->db->bind('Date_of_birth', $Date_of_birth);
                            // $this->db->bind('Tipe_Idcard', $Tipe_Idcard);
                            // $this->db->bind('ID_Card_number', $ID_Card_number);
                            // $this->db->bind('Address', $Address);
                            // $this->db->bind('Marital_status', $Marital_status);
                            // $this->db->bind('Religion', $Religion);
                            // $this->db->bind('Education', $Education);
                            // $this->db->bind('HomePhone', $HomePhone);
                            // $this->db->bind('MobilePhone', $MobilePhone);
                            // $this->db->bind('Ocupation', $Ocupation);
                            // $this->db->bind('PostalCode', $PostalCode);
                            // $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                            // $this->db->bind('NamaGrupPerawatan', $NamaGrupPerawatan);
                            // $this->db->bind('IdDokter', $IdDokter);
                            // $this->db->bind('NamaDokter', $NamaDokter);
                            // $this->db->bind('NoPesertaBPJS', null);
                            // $this->db->bind('nosep', $nosep);
                            // $this->db->bind('shift', $shift);
                            // $this->db->bind('StatusID', '0');
                            // $this->db->bind('operator', $operator);
                            // $this->db->bind('LockBill', '0');
                            // $this->db->bind('PasienJenisDaftar', $PasienJenisDaftar);
                            // $this->db->bind('TelemedicineIs', '0');
                            // $this->db->bind('appointment_id', null);
                            // $this->db->bind('tiperegistrasi', $tiperegistrasi);
                            // $this->db->bind('JamPraktek', $JamPraktek);
                            // $this->db->bind('caramasukid', $caramasukid);
                            // $this->db->bind('referralid', $referralid);
                            // $this->db->bind('idadministrasi', $idadministrasi);
                            // $this->db->bind('fixNoAntrian', $fixNoAntrian);
                            // $this->db->bind('Company', $Company);
                            // $this->db->bind('NamaCaraMasuk', $NamaCaraMasuk);
                            // $this->db->bind('NamaCaraMasukRef', $showrefferalfix);
                            // $this->db->bind('Nama_Karcis', $Nama_Karcis);
                            // $this->db->bind('Nilai_Karcis', $Nilai_Karcis);
                            // $this->db->bind('Bahasa', $Bahasa);
                            // $this->db->bind('Etnis', $Etnis);
                            // $this->db->bind('datenowcreate', $datenowcreate);
                            // $this->db->execute(); 
                            // //---#END INSERT DATARWJ
                            //Update Nomor Registrasi EMR_OrderOperasi
                            if ($idodc <> '') {
                                //Update NoEpisode ODC
                                $this->db->query("SELECT NoEpisode
                            from MedicalRecord.dbo.MR_PermintaanRawat_ODC
                            where  ID=:idodc");
                                $this->db->bind('idodc', $idodc);
                                $data =  $this->db->single();
                                $NoEpisode_odc = $data['NoEpisode'];

                                // UPDATE TABEL Visit No Episode
                                $this->db->query("UPDATE PerawatanSQL.dbo.Visit
                        SET NoEpisode=:NoEpisode_odc where NoRegistrasi=:nofixReg");
                                $this->db->bind('nofixReg', $nofixReg);
                                $this->db->bind('NoEpisode_odc', $NoEpisode_odc);
                                $this->db->execute();

                                // UPDATE TABEL EMR_ORDEROPERASI
                                $this->db->query("UPDATE MedicalRecord.dbo.EMR_OrderOperasi
                            SET NoRegistrasi=:nofixReg where NoRegistrasi in (SELECT NoRegistrasi FROM MedicalRecord.dbo.MR_PermintaanRawat_ODC WHERE ID=:idodc) and StatusOrder not in('Close' , 'Batal', 'cancel') ");
                                $this->db->bind('nofixReg', $nofixReg);
                                $this->db->bind('idodc', $idodc);
                                $this->db->execute();

                                // UPDATE TABEL MR_PermintaanRawat_ODC
                                $this->db->query("UPDATE MedicalRecord.dbo.MR_PermintaanRawat_ODC
                            SET StatusRegis='1' where ID=:idodc");
                                $this->db->bind('idodc', $idodc);
                                $this->db->execute();


                                // // UPDATE TABEL EMR_ORDEROPERASI
                                // $this->db->query("UPDATE MedicalRecord.dbo.MR_LaporanOperasi
                                //  SET NoRegistrasi=:nofinalreg where NoRegistrasi=:noregisrwj");
                                // $this->db->bind('nofinalreg', $nofinalreg);
                                // $this->db->bind('noregisrwj', $noregisrwj);
                                // $this->db->execute();
                                //#END Update Nomor Registrasi EMR_OrderOperasi
                            }
                        } else {
                            $this->db->query("INSERT INTO perawatanSQL.dbo.Visit (ID,NoEpisode,NoRegistrasi,LokasiPasien,
                                CaraBayar,NoMR ,
                                PatientType,Unit,Doctor_1,Antrian,NoAntrianAll,Company,JamPraktek,Perusahaan,Operator
                                ,idAdmin,idCaraMasuk,idCaraMasuk2,JenisDaftar
                                ,admclID,admPayorName,admpolicyNo,admpolicyDate,
                                admplanCode,admclStatus,admclDesc,admketstatus,admpayorMemberID,admcoveragetype,
                                FisioterapiFlag,TglKunjungan,[Visit Date],NoSEP,Tipe_Registrasi,ID_JadwalPraktek,
                                 Catatan,KodeJaminanCOB,idRegKemenkes
                                ) VALUES (:id,:NoEpisode,:nofixReg,:NamaGrupPerawatan,
                               :nullable,:NoMrfix,
                                :JenisBayar,:IdGrupPerawatan,:IdDokter,:idno_urutantrian,:fixNoAntrian,:Company,:shift,:perusahaanid,:operator
                                ,:idadministrasi,:caramasukid,:referralid,:PasienJenisDaftar 
                                ,:admclID,:admPayorName,:admpolicyNo,:admpolicyDate,
                                :admplanCode,:admclStatus,:admclDesc,:admketstatus,:admpayorMemberID,
                                :admcoveragetype,:fisioflag,:tglregistrasi,:tglregistrasi2,:nosep,:tiperegistrasi,:JamPraktek,
                                :pxNoteRegistrasi,:COB,:uuidkemenkes)");
                            $this->db->bind('id', $id);
                            $this->db->bind('pxNoteRegistrasi', $pxNoteRegistrasi);
                            $this->db->bind('NoEpisode', $nofixOp);
                            $this->db->bind('nofixReg', $nofixReg);
                            $this->db->bind('NamaGrupPerawatan', $NamaGrupPerawatan);
                            $this->db->bind('nullable', $nullable);
                            $this->db->bind('NoMrfix', $NoMrfix);
                            $this->db->bind(
                                'JenisBayar',
                                $JenisBayar
                            );
                            $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                            $this->db->bind('IdDokter', $IdDokter);
                            $this->db->bind('idno_urutantrian', $idno_urutantrian);
                            $this->db->bind('fixNoAntrian', $fixNoAntrian);
                            $this->db->bind('Company', $Company);
                            $this->db->bind('shift', $shift);
                            $this->db->bind('perusahaanid', $perusahaanid);
                            $this->db->bind('operator', $operator);
                            $this->db->bind('idadministrasi', $idadministrasi);
                            $this->db->bind('caramasukid', $caramasukid);
                            $this->db->bind(
                                'referralid',
                                $referralid
                            );
                            $this->db->bind('PasienJenisDaftar', $PasienJenisDaftar);
                            $this->db->bind('admclID', $admclID);
                            $this->db->bind('admPayorName', $admPayorName);
                            $this->db->bind('admpolicyNo', $admpolicyNo);
                            $this->db->bind('admpolicyDate', $admpolicyDate);
                            $this->db->bind('admplanCode', $admplanCode);
                            $this->db->bind('admclStatus', $admclStatus);
                            $this->db->bind(
                                'admclDesc',
                                $admclDesc
                            );
                            $this->db->bind('admketstatus', $admketstatus);
                            $this->db->bind('admpayorMemberID', $admpayorMemberID);
                            $this->db->bind('admcoveragetype', $admcoveragetype);
                            $this->db->bind(
                                'fisioflag',
                                $fisioflag
                            );
                            $this->db->bind('tglregistrasi', $tglregistrasi);
                            $this->db->bind('tglregistrasi2', $tglregistrasi);
                            $this->db->bind('nosep', $nosep);
                            $this->db->bind('tiperegistrasi', $tiperegistrasi);
                            $this->db->bind('JamPraktek', $JamPraktek);
                            $this->db->bind('COB', $COB);
                            $this->db->bind('uuidkemenkes', $uuidkemenkes); 
                            $this->db->execute();

                            // //INSERT ke DataRWJ 14-03-2023
                            // //GET DATA PASIEN
                            // $this->db->query("SELECT PatientName,
                            // KelurahanName,KecamatanName,CityName,ProvinceName,Gander,replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as Date_of_birth,Tipe_Idcard,ID_Card_number,Address,Marital_status,Religion,
                            // Education,[Home Phone],[Mobile Phone],Ocupation,[ZIP/Postal Code] as PostalCode
                            // ,Bahasa,Etnis,replace(CONVERT(VARCHAR(11), InputDate, 111), '/','-') as InputDate
                            // from MasterdataSQL.dbo.Admision 
                            // where  NoMR=:NoMrfix
                            // UNION ALL
                            // SELECT PatientName,
                            // KelurahanName,KecamatanName,CityName,ProvinceName,Gander,replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as Date_of_birth,Tipe_Idcard,ID_Card_number,Address,Marital_status,Religion,
                            // Education,[Home Phone],[Mobile Phone],Ocupation,[ZIP/Postal Code] as PostalCode
                            // ,Bahasa,Etnis,replace(CONVERT(VARCHAR(11), InputDate, 111), '/','-') as InputDate
                            // from MasterdataSQL.dbo.Admision_walkin 
                            // where  NoMR=:NoMrfix2");
                            // $this->db->bind('NoMrfix', $NoMrfix);
                            // $this->db->bind('NoMrfix2', $NoMrfix);
                            // $datag =  $this->db->single();
                            // $PatientName = $datag['PatientName'];
                            // $KelurahanName = $datag['KelurahanName'];
                            // $KecamatanName = $datag['KecamatanName'];
                            // $CityName = $datag['CityName'];
                            // $ProvinceName = $datag['ProvinceName'];
                            // $Gander = $datag['Gander'];
                            // $Date_of_birth = $datag['Date_of_birth'];
                            // $Tipe_Idcard = $datag['Tipe_Idcard'];
                            // $ID_Card_number = $datag['ID_Card_number'];
                            // $Address = $datag['Address'];
                            // $Marital_status = $datag['Marital_status'];
                            // $Religion = $datag['Religion'];
                            // $Education = $datag['Education'];
                            // $HomePhone = $datag['Home Phone'];
                            // $MobilePhone = $datag['Mobile Phone'];
                            // $Ocupation = $datag['Ocupation'];
                            // $PostalCode = $datag['PostalCode'];
                            // $Bahasa = $datag['Bahasa'];
                            // $Etnis = $datag['Etnis'];
                            // $InputDate = $datag['InputDate'];

                            // //GET CARA MASUK
                            // $querry = "SELECT NamaCaraMasuk
                            //     from MasterdataSQL.dbo.MstrCaraMasuk
                            //     where id=:caramasukid";
                            // $this->db->query($querry);
                            // $this->db->bind('caramasukid', $caramasukid);
                            // $dataf =  $this->db->single();
                            // $NamaCaraMasuk = $dataf['NamaCaraMasuk']; 

                            // // GET DATA KARCIS
                            //     $this->db->query("SELECT ID, Nama_Karcis,Nilai_Karcis
                            //     from MasterdataSQL.dbo.MstrKarcisAdministrasi  
                            //     where  ID=:idadministrasi");
                            // $this->db->bind('idadministrasi', $idadministrasi);
                            // $data =  $this->db->single();
                            // $Nama_Karcis = $data['Nama_Karcis'];
                            // $Nilai_Karcis = $data['Nilai_Karcis'];

                            // if (strtotime($tglregistrasi_Ymd) > strtotime($InputDate)){
                            //     $BL = 'LAMA';
                            // }else{
                            //     $BL = 'BARU';
                            // }

                            // $this->db->query("INSERT INTO DashboardData.dbo.DataRWJ (NoEpisode,NoRegistrasi,NoMR,PatientName,[Visit Date],
                            // Kelurahan,Kecamatan,kabupatenNama,ProvinsiNama,BL,TipePasien,FP,
                            // KodeJaminan,NamaJaminan,Sex,DateOfBirth,TipeIdCard, NoIdCard, Address,MaritalStatus,Religion,
                            // Education,HomePhone,MobilePhone,Pekerjaan,KodePos,IdUnit,NamaUnit,IdDokter,NamaDokter,
                            // NoPesertaBPJS,NoSep,JamPraktek,StatusID,OperatorId,
                            // Lockbill,JenisDaftar,Telemedicine,Appointment_ID,Tipe_Registrasi,Id_Jadwal_Praktek,
                            // idCaraMasuk,idCaraMasuk2,idAdmin,NoAntrianAll,Company,NamaCaraMasuk,NamaCaraMasukRef,NamaKarcis,NilaiKarcis,hosnamedata,datatimestamp,Bahasa,Etnis
                            // ) VALUES ( :NoEpisode, :nofixReg,:NoMrfix,:PatientName,:tglregistrasi,
                            //         :KelurahanName,:KecamatanName,:CityName,:ProvinceName,
                            //         :BL
                            //         ,:JenisBayar,'1',
                            //         :perusahaanid,:NamaPerusahaan,:Gander,:Date_of_birth,:Tipe_Idcard,:ID_Card_number,:Address,:Marital_status,:Religion,
                            //         :Education,:HomePhone,:MobilePhone,:Ocupation,:PostalCode
                            //         ,:IdGrupPerawatan,:NamaGrupPerawatan,:IdDokter,:NamaDokter,
                            //         :NoPesertaBPJS,:nosep,:shift,:StatusID,:operator,
                            //         :LockBill,:PasienJenisDaftar,:TelemedicineIs,:appointment_id,:tiperegistrasi,:JamPraktek,
                            //         :caramasukid,:referralid,:idadministrasi,:fixNoAntrian,:Company,:NamaCaraMasuk,:NamaCaraMasukRef,:Nama_Karcis,:Nilai_Karcis,host_name(),:datenowcreate
                            //         ,:Bahasa,:Etnis)
                            //         ");
                            // $this->db->bind('NoEpisode', $nofixOp);
                            // $this->db->bind('nofixReg', $nofixReg);
                            // $this->db->bind('NoMrfix', $NoMrfix);
                            // $this->db->bind('PatientName', $PatientName);
                            // $this->db->bind('tglregistrasi', $tglregistrasi);
                            // $this->db->bind('KelurahanName', $KelurahanName);
                            // $this->db->bind('KecamatanName', $KecamatanName);
                            // $this->db->bind('CityName', $CityName);
                            // $this->db->bind('ProvinceName', $ProvinceName);
                            // $this->db->bind('BL', $BL);
                            // $this->db->bind('JenisBayar', $JenisBayar);
                            // $this->db->bind('perusahaanid', $perusahaanid);
                            // $this->db->bind('NamaPerusahaan', $shownamaperusahaanfix);
                            // $this->db->bind('Gander', $Gander);
                            // $this->db->bind('Date_of_birth', $Date_of_birth);
                            // $this->db->bind('Tipe_Idcard', $Tipe_Idcard);
                            // $this->db->bind('ID_Card_number', $ID_Card_number);
                            // $this->db->bind('Address', $Address);
                            // $this->db->bind('Marital_status', $Marital_status);
                            // $this->db->bind('Religion', $Religion);
                            // $this->db->bind('Education', $Education);
                            // $this->db->bind('HomePhone', $HomePhone);
                            // $this->db->bind('MobilePhone', $MobilePhone);
                            // $this->db->bind('Ocupation', $Ocupation);
                            // $this->db->bind('PostalCode', $PostalCode);
                            // $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                            // $this->db->bind('NamaGrupPerawatan', $NamaGrupPerawatan);
                            // $this->db->bind('IdDokter', $IdDokter);
                            // $this->db->bind('NamaDokter', $NamaDokter);
                            // $this->db->bind('NoPesertaBPJS', null);
                            // $this->db->bind('nosep', $nosep);
                            // $this->db->bind('shift', $shift);
                            // $this->db->bind('StatusID', '0');
                            // $this->db->bind('operator', $operator);
                            // $this->db->bind('LockBill', '0');
                            // $this->db->bind('PasienJenisDaftar', $PasienJenisDaftar);
                            // $this->db->bind('TelemedicineIs', '0');
                            // $this->db->bind('appointment_id', null);
                            // $this->db->bind('tiperegistrasi', $tiperegistrasi);
                            // $this->db->bind('JamPraktek', $JamPraktek);
                            // $this->db->bind('caramasukid', $caramasukid);
                            // $this->db->bind('referralid', $referralid);
                            // $this->db->bind('idadministrasi', $idadministrasi);
                            // $this->db->bind('fixNoAntrian', $fixNoAntrian);
                            // $this->db->bind('Company', $Company);
                            // $this->db->bind('NamaCaraMasuk', $NamaCaraMasuk);
                            // $this->db->bind('NamaCaraMasukRef', $showrefferalfix);
                            // $this->db->bind('Nama_Karcis', $Nama_Karcis);
                            // $this->db->bind('Nilai_Karcis', $Nilai_Karcis);
                            // $this->db->bind('Bahasa', $Bahasa);
                            // $this->db->bind('Etnis', $Etnis);
                            // $this->db->bind('datenowcreate', $datenowcreate);
                            // $this->db->execute(); 
                            // //---#END INSERT DATARWJ
                            //Update Nomor Registrasi EMR_OrderOperasi
                            if ($idodc <> '') {
                                //Update NoEpisode ODC
                                $this->db->query("SELECT NoEpisode
                            from MedicalRecord.dbo.MR_PermintaanRawat_ODC
                            where  ID=:idodc");
                                $this->db->bind('idodc', $idodc);
                                $data =  $this->db->single();
                                $NoEpisode_odc = $data['NoEpisode'];

                                // UPDATE TABEL Visit No Episode
                                $this->db->query("UPDATE PerawatanSQL.dbo.Visit
                        SET NoEpisode=:NoEpisode_odc where NoRegistrasi=:nofixReg");
                                $this->db->bind('nofixReg', $nofixReg);
                                $this->db->bind('NoEpisode_odc', $NoEpisode_odc);
                                $this->db->execute();

                                // UPDATE TABEL EMR_ORDEROPERASI
                                $this->db->query("UPDATE MedicalRecord.dbo.EMR_OrderOperasi
                            SET NoRegistrasi=:nofixReg where NoRegistrasi in (SELECT NoRegistrasi FROM MedicalRecord.dbo.MR_PermintaanRawat_ODC WHERE ID=:idodc) and StatusOrder not in('Close' , 'Batal', 'cancel') ");
                                $this->db->bind('nofixReg', $nofixReg);
                                $this->db->bind('idodc', $idodc);
                                $this->db->execute();

                                // UPDATE TABEL MR_PermintaanRawat_ODC
                                $this->db->query("UPDATE MedicalRecord.dbo.MR_PermintaanRawat_ODC
                            SET StatusRegis='1' where ID=:idodc");
                                $this->db->bind('idodc', $idodc);
                                $this->db->execute();


                                // // UPDATE TABEL EMR_ORDEROPERASI
                                // $this->db->query("UPDATE MedicalRecord.dbo.MR_LaporanOperasi
                                //  SET NoRegistrasi=:nofinalreg where NoRegistrasi=:noregisrwj");
                                // $this->db->bind('nofinalreg', $nofinalreg);
                                // $this->db->bind('noregisrwj', $noregisrwj);
                                // $this->db->execute();
                                //#END Update Nomor Registrasi EMR_OrderOperasi
                            }
                        }
                        // cek diskon admin per jaminan
                        $this->db->query("SELECT RJ_Disc_Administrasi 
                                            from MasterdataSQL.dbo.MstrPerusahaanJPK 
                                            where id=:JenisBayar");
                        $this->db->bind('JenisBayar', $JenisBayar);
                        $data =  $this->db->single();
                        $RJ_Disc_Administrasi = $data['RJ_Disc_Administrasi'];
                        $adminmindisc = $RJ_Disc_Administrasi * $nilaiadminstrasi;
                        $nilaiadministrasifix = $nilaiadminstrasi - $adminmindisc;
                    }
                    // Insert Administrasi
                    $this->db->query("INSERT INTO  PerawatanSQL.dbo.[Visit Details] ( ProductID, NamaProduct, Quantity, Tarif, TotalTarif, JasaDokter, 
                                        Discount, StatusID, Aproved, KategoriTarif, Lunas, NoRegistrasi, NoMR, NoEpisode,Tanggal )
                                        SELECT ID, Nama_Karcis, 1 AS Quantity, Nilai_Karcis, '$nilaiadministrasifix' AS [fixtarif], 0 AS Expr1, 
                                        '$adminmindisc' AS diskonjaminanx, 1 AS Expr3, 0 AS Expr4, 
                                        'Administrasi' AS Admin, 0 AS Expr6, '$nofixReg' AS xNoreg, 
                                        '$NoMrfix' AS NoMR, '$nofixOp' AS xNoEpisode,'$tglregistrasi'
                                        FROM MasterdataSQL.dbo.MstrKarcisAdministrasi
                                        WHERE ID=:idadministrasi");
                    $this->db->bind('idadministrasi', $idadministrasi);
                    $this->db->execute();

                    // insert antrian
                    if ($NoReservasi === "") {
                        $this->db->query("INSERT INTO perawatanSQL.dbo.AntrianPasien 
                                            (no_transaksi,no_transaksi_reff,Doctor_1,JamPraktek,Antrian,noAntrianAll,TglKunjungan,Company)VALUES
                                            (:nofixReg,:no_transaksi_reff,:IdDokter,:shift,:idno_urutantrian,:fixNoAntrian,
                                            :datenowcreate,:Company)");
                        $this->db->bind('nofixReg', $nofixReg);
                        $this->db->bind('no_transaksi_reff', $nofixReg);
                        $this->db->bind('IdDokter', $IdDokter);
                        $this->db->bind('shift', $shift);
                        $this->db->bind('idno_urutantrian', $idno_urutantrian);
                        $this->db->bind('fixNoAntrian', $fixNoAntrian);
                        $this->db->bind(
                            'datenowcreate',
                            $datenowcreate
                        );
                        $this->db->bind('Company', $Company);
                        $this->db->execute();
                    }
                    if ($NoReservasi <> "") {
                        // $this->db->query("UPDATE  PerawatanSQL.dbo.Apointment 
                        //                     SET Datang='1', NoRegistrasi=:nofixReg,no_transaksi_reff=:no_transaksi_reff
                        //                     where NoBooking=:NoReservasi");
                        // $this->db->bind('nofixReg', $nofixReg);
                        // $this->db->bind('no_transaksi_reff', $nofixReg);
                        // $this->db->bind('NoReservasi', $NoReservasi);
                        // $this->db->execute();

                        $this->db->query("UPDATE  PerawatanSQL.dbo.Apointment 
                        SET Datang='1', NoRegistrasi=:nofixReg
                        where NoBooking=:NoReservasi");
                        $this->db->bind('nofixReg', $nofixReg);
                        //$this->db->bind('no_transaksi_reff', $nofixReg);
                        $this->db->bind('NoReservasi', $NoReservasi);
                        $this->db->execute();
                
                        $this->db->query("UPDATE  PerawatanSQL.dbo.AntrianPasien 
                                        SET no_transaksi_reff=:no_transaksi_reff
                                        where no_transaksi=:no_transaksi"); 
                        $this->db->bind('no_transaksi_reff', $nofixReg);
                        $this->db->bind('no_transaksi', $NoReservasi);
                        $this->db->execute();
                    } else {
                        $executeboking = null;
                    }

                    //Generate no trs billing

                      $datenowx = Utils::datenowcreateNotFull();
                      $datenow = date('dmy', strtotime($datenowcreate));

                      $this->db->query("SELECT  TOP 1 NO_TRS_BILLING,right( REPLACE(NO_TRS_BILLING,'-','0')  ,5) as urut
                      FROM Billing_Pasien.dbo.FO_T_BILLING  WHERE  
                      replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-')=:datenow2 
                      and SUBSTRING(no_trs_billing,1,2)=:no_trs_billing
                      ORDER BY urut DESC");
                      $this->db->bind('datenow2', $datenowcreate);
                      $this->db->bind('no_trs_billing', 'AD');
                      $data =  $this->db->single();
                      //no urut reg
                      $nexturut = $data['urut'];
                      $nexturut++;

                      $nourutfix = Utils::generateAutoNumber($nexturut);
                      $kodeawal = "AD";
                      $datenotrsadmin =  date('dmys', strtotime(Utils::seCurrentDateTime()));
                      $notrsbill = $kodeawal . $datenotrsadmin . $nourutfix;
                      //var_dump($notrsbill);exit;

                      // insert ke tabel FO_T_Billing
                          $this->db->query("INSERT INTO Billing_Pasien.dbo.FO_T_BILLING
                          ([NO_TRS_BILLING],[TGL_BILLING],[PETUGAS_ENTRY],[NO_MR],[NO_EPISODE],[NO_REGISTRASI],[UNIT],[GROUP_JAMINAN],[KODE_JAMINAN],[TOTAL_TARIF],[TOTAL_QTY],[SUBTOTAL],[TOTAL_DISCOUNT],[TOTAL_DISCOUNT_RP],[SUBTOTAL_2],[GRANDTOTAL],[BATAL],[FB_CLOSE_KEUANGAN],[FB_VERIF_JURNAL])
                    VALUES
                          (:notrsbill,:datenowx,:namauserx,:NoMrfix,:NoEpisode,:nofixReg,:IdGrupPerawatan,:JenisBayar,:perusahaanid,:totaltarif,:totalqty,:subtotal,:totaldiscount,:totaldiscountrp,:subtotal2,:grandtotal,:batal,:closekeuangan,:verifkeuangan)");

                          $this->db->bind('notrsbill', $notrsbill);
                          $this->db->bind('datenowx', Utils::seCurrentDateTime());
                          $this->db->bind('namauserx', $namauserx);
                          $this->db->bind('NoMrfix', $NoMrfix);
                          $this->db->bind('NoEpisode', $nofixOp);
                          $this->db->bind('nofixReg', $nofixReg);
                          $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                          $this->db->bind('JenisBayar', $JenisBayar);
                          $this->db->bind('perusahaanid', $perusahaanid);
                          $this->db->bind('totaltarif', 0);
                          $this->db->bind('totalqty', 0);
                          $this->db->bind('subtotal', 0);
                          $this->db->bind('totaldiscount', 0);
                          $this->db->bind('totaldiscountrp', 0);
                          $this->db->bind('subtotal2', 0);
                          $this->db->bind('grandtotal', 0);
                          $this->db->bind('batal', 0);
                          $this->db->bind('closekeuangan', 0);
                          $this->db->bind('verifkeuangan', 0);
                          $this->db->execute();

                        // insert ke tabel FO_T_Billing_1
                        // Insert Administrasi
                      $this->db->query("INSERT INTO  Billing_Pasien.dbo.FO_T_BILLING_1
                      ([NO_TRS_BILLING],[TGL_BILLING],[PETUGAS_ENTRY],[NO_MR],[NO_EPISODE],[NO_REGISTRASI],[KODE_TARIF],[UNIT],[GROUP_JAMINAN],[KODE_JAMINAN],[NAMA_TARIF],[GROUP_TARIF],[KD_KELAS],[QTY],[NILAI_TARIF],[SUB_TOTAL],[DISC],[DISC_RP],[SUB_TOTAL_2],[GRANDTOTAL],[KD_DR],[NM_DR],[BATAL],[PETUGAS_BATAL],
                      [GROUP_ENTRI])
                      SELECT '$notrsbill' as notrsbill, '$datenowcreate' as datenow,'$namauserx' as namauserx,'$NoMrfix' AS NoMR, '$nofixOp' AS xNoEpisode,'$nofixReg' as NoReg,ID,
                      '$IdGrupPerawatan' as Unit,'$JenisBayar' as GroupJaminan,'$perusahaanid' as kdjaminan, Nama_Karcis,'Administrasi' as adm, null as kdkelas, 1 as Qty, Nilai_Karcis, Nilai_Karcis, 0 as Disc, 0 as disc2, Nilai_Karcis, Nilai_Karcis, null as kddokter, null as nmdokter, 0 as batal,null as petugasbatal,'KARCIS'
                      FROM MasterdataSQL.dbo.MstrKarcisAdministrasi
                      WHERE ID=:idadministrasi");
                      $this->db->bind('idadministrasi', $idadministrasi); 
                      $this->db->execute();

                      //Insert ke tabel FO_T_Billing_2
                      $this->db->query("INSERT INTO  Billing_Pasien.DBO.FO_T_BILLING_2
                      SELECT '0' as ID_BILL,A.NO_TRS_BILLING AS NO_TRS_BILLING,
                      A1.KODE_TARIF,B.KD_TIPE_PDP as Kode_komponen,A1.UNIT AS UNIT, A1.GROUP_JAMINAN AS GROUP_JAMINAN, A1.KODE_JAMINAN AS KODE_JAMINAN, 
                      A1.NAMA_TARIF AS NAMA_TARIF, 
                      A1.GROUP_TARIF AS GROUP_TARIF, A1.KD_KELAS as KELAS,A1.QTY AS QTY, 
                      A1.NILAI_TARIF AS NILAI_TARIF  ,
                      A1.NILAI_TARIF*A1.QTY  AS SUBTOTAL,
                      A1.DISC AS DISC,
                      (A1.NILAI_TARIF-((A1.NILAI_TARIF*A1.DISC)/100)) AS DISC_RP,
                      ((A1.NILAI_TARIF*A1.QTY)-(((A1.NILAI_TARIF*A1.QTY)*A1.DISC)/100))   SUB_TOTAL_PDP_2,
                      (CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN ((((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' THEN ((b.NILAI_FIX*A1.QTY*DISC)/100)*A1.QTY END ) NILAI_DISKON_PDP,
                      (CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN (((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY)-(((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' THEN (b.NILAI_FIX*A1.QTY)-((b.NILAI_FIX*A1.QTY*DISC)/100)*A1.QTY END ) as NILAI_PDP,
                      A1.KD_DR AS KD_DR, '' NM_DR,b.NILAI_PROSEN,'0' AS BATAL,'' PETUGAS_BATAL, '' AS JAM_BATAL, B.KD_POSTING AS KD_POSTING, b.KD_POSTING_DISC as kd_posting_diskon,null
                       FROM Billing_Pasien.DBO.FO_T_BILLING A
                       inner join Billing_Pasien.dbo.FO_T_BILLING_1 A1
                       ON A.NO_TRS_BILLING = A1.NO_TRS_BILLING
                       INNER JOIN MasterdataSQL.DBO.MstrKarcisAdministrasi CC 
                       ON CC.ID = A1.KODE_TARIF
                       INNER JOIN Keuangan.DBO.BO_M_PDP2 B
                      ON CC.KD_PDP collate SQL_Latin1_General_CP1_CI_AS = B.KD_PDP collate SQL_Latin1_General_CP1_CI_AS
                      INNER JOIN Keuangan.DBO.BO_M_PDP CX
                      ON CX.KD_PDP = B.KD_PDP
                       WHERE A1.GROUP_ENTRI='KARCIS' and a.BATAL='0' and A1.BATAL='0' and a.NO_TRS_BILLING=:notrsbill");
                      $this->db->bind('notrsbill', $notrsbill); 
                      $this->db->execute();

                      //UPDATE TOTAL KE FO_T_BILLING
                      $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_BILLING
                      SET TOTAL_TARIF=B.SUM_NILAI_TARIF,TOTAL_QTY=B.SUM_QTY,SUBTOTAL=B.SUM_SUB_TOTAL,SUBTOTAL_2=B.SUM_SUB_TOTAL_2,GRANDTOTAL=B.SUM_GRANDTOTAL
                      FROM Billing_Pasien.DBO.FO_T_BILLING A 
                      INNER JOIN
                      (
                          SELECT  NO_TRS_BILLING,SUM(NILAI_TARIF) AS SUM_NILAI_TARIF,SUM(QTY) AS SUM_QTY,SUM(SUB_TOTAL) AS SUM_SUB_TOTAL,SUM(SUB_TOTAL_2) AS SUM_SUB_TOTAL_2,
                          SUM(GRANDTOTAL) AS SUM_GRANDTOTAL
                          FROM Billing_Pasien.DBO.FO_T_BILLING_1
                          WHERE NO_REGISTRASI=:noreg and Batal='0'
                          GROUP BY NO_TRS_BILLING
                      ) B
                      ON A.NO_TRS_BILLING = B.NO_TRS_BILLING
                      WHERE A.NO_REGISTRASI=:noreg2");
                      $this->db->bind('noreg', $nofixReg);
                      $this->db->bind('noreg2', $nofixReg);
                      $this->db->execute();

                    // INSERT POST TO KEMNKES
                    // 1. Gen Token
                    // $method = "POST";
                    // $URL = "accesstoken?grant_type=client_credentials";
                    // $token = $this->curl_request_token(GenerateTokenSatuSehat::headers_api(), $method, $URL);
                    // $Fixtoken = "Bearer ".$token['access_token'];


                    // // 2. GetHis
                    // $method2 = "POST"; 
                    // $urlAddSatuan = "Encounter";
                    // $Organization = "10000004";
                    // //data
                    // $postSatuanData = '{
                    //     "resourceType": "Encounter",
                    //     "status": "arrived",
                    //     "class": {
                    //         "system": "http://terminology.hl7.org/CodeSystem/v3-ActCode",
                    //         "code": "AMB",
                    //         "display": "ambulatory"
                    //     },
                    //     "subject": {
                    //         "reference": "Patient/'.$idMrkemkes.'",
                    //         "display": "'.$namapasien.'" 
                    //     },
                    //     "participant": [
                    //         {
                    //             "type": [
                    //                 {
                    //                     "coding": [
                    //                         {
                    //                             "system": "http://terminology.hl7.org/CodeSystem/v3-ParticipationType",
                    //                             "code": "ATND",
                    //                             "display": "attender"
                    //                         }
                    //                     ]
                    //                 }
                    //             ],
                    //             "individual": {
                    //                 "reference": "Practitioner/'.$idDoktertKemkes.'",
                    //                 "display": "'.$NamaDokter.'"
                    //             }
                    //         }
                    //     ],
                    //     "period": {
                    //         "start": "'.$xTglNowTempx.'+07:00"
                    //     },
                    //     "location": [
                    //         {
                    //             "location": {
                    //                 "reference": "Location/'.$idUnitKemkes.'",
                    //                 "display": "'.$NamaGrupPerawatan.'"
                    //             }
                    //         }
                    //     ],
                    //     "statusHistory": [
                    //         {
                    //             "status": "arrived",
                    //             "period": {
                    //                 "start": "'.$xTglNowTempx.'+07:00"
                    //             }
                    //         }
                    //     ],
                    //     "serviceProvider": {
                    //         "reference": "Organization/'.$Organization.'"
                    //     },
                    //     "identifier": [
                    //         {
                    //             "system": "http://sys-ids.kemkes.go.id/encounter/10000004",
                    //             "value": "'.$nofixReg.'"
                    //         }
                    //     ]
                    // }';
                    // // UPDATE REG KEMENKES KE TABEL VISIT
                    // $addSatuan = $this->curl_request(GenerateTokenSatuSehat::headers_api_token($Fixtoken), $method2, $postSatuanData, $urlAddSatuan);
                    // $idMrkemkes =  $addSatuan['id'];

                    // $this->db->query("UPDATE  PerawatanSQL.dbo.Visit 
                    // SET idRegKemenkes=:idMrkemkes ,idDoktertKemkes=:idDoktertKemkes,idUnitKemkes=:idUnitKemkes
                    // where NoRegistrasi=:nofixReg");
                    // $this->db->bind('nofixReg', $nofixReg);
                    // $this->db->bind('idMrkemkes', $idMrkemkes);
                    // $this->db->bind('idDoktertKemkes', $idDoktertKemkes);
                    // $this->db->bind('idUnitKemkes', $idUnitKemkes);
                    // $this->db->execute();

                    $waktuAwalkemkes = $xTglNowTempx.'-07:00';
                    $EndTime =  $xTglNowTempx.'-07:00';
                    $this->db->query("INSERT INTO DashboardData.dbo.Encounter_Update_Status 
                    (Noregistrasi,statusName,StartTime,EndTime)VALUES
                    (:nofixReg,:statusName,:StartTime,:EndTime)");
                    $this->db->bind('nofixReg', $nofixReg); 
                    $this->db->bind('StartTime', $waktuAwalkemkes);
                    $this->db->bind('EndTime', $EndTime); 
                    $this->db->bind('statusName', 'arrived'); 
                    $this->db->execute();

                    $this->db->commit();
                    $callback = array(
                        'status' => 'success',
                        'NoEpisode' => $nofixOp,
                        'NoRegistrasi' => $nofixReg,
                        'NoAntrianPoli' => $fixNoAntrian,
                        'IdDokter' => $IdDokter,
                        'DokterName' => $NamaDokter,
                        'IdPoli' => $IdGrupPerawatan,
                        'PoliName' => $NamaGrupPerawatan,
                        'NoMR' => $NoMrfix,
                        'Namapasien' => $namapasien,
                        'JenisBayar' => $JenisBayar,
                        'idRegKemenkes' => $uuidkemenkes
                    );
                    return $callback;
                }
            }
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'errorname' => $e
            );
            return $callback;
        }
    }
    public function GetregistrasiRajalbyId($data)
    {
        // var_dump($data);
        // exit;

        try {
            $IdRegistrasi = $data['IdRegistrasi'];
            $tabel = "MasterDataSQL.dbo.Admision";
            if (isset($_POST['iswalkin'])) {
                $iswalkin = $data['iswalkin'];
                if ($iswalkin == 'WALKIN') {
                    $tabel = "MasterDataSQL.dbo.Admision_walkin";
                }
            }
            // $this->db->query(" SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName,a.LokasiPasien,a.CaraBayar,
            //                               a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
            //                               a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
            //                               a.PatientType,a.Unit,a.Doctor_1,b.First_Name as namadokter,a.JamPraktek,a.Asuransi as Perusahaanid,c.NamaPerusahaan as  Perusahaan,a.[Payment Type],
            //                               a.Antrian,a.NoAntrianAll,e.[First Name] as namauser,
            //           replace(CONVERT(VARCHAR(11), d.Date_of_birth, 111), '/','-') as Date_of_birthx,
            //           d.Address,d.Gander,d.BirthPlace,d.Ocupation,d.[Mobile Phone] as noHp,
            //           case when d.Gander='L' then 'LAKI-LAKI' when d.Gander='P' then 'PEREMPUAN'  END AS NamaGander,
            //           d.ID_Card_number,a.idAdmin,a.idCaraMasuk,a.idCaraMasuk2,a.JenisDaftar,f.NoBooking,
            //           replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglkunjungan,
            //           CONVERT(VARCHAR(8),TglKunjungan,108) as jamkunjungan,bl.KODE_TARIF,a.Tipe_Registrasi,a.JamPraktek,
            //           a.ID_JadwalPraktek,a.Catatan,a.KodeJaminanCOB,a.idRegKemenkes,a.idDoktertKemkes,a.idUnitKemkes
            //                               from PerawatanSQL.dbo.Visit a
            //                               inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
            //                               inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.Asuransi
            //                               inner join $tabel d on d.NoMR = a.NoMR
            //                               inner join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
            //                               left join PerawatanSQL.DBO.Apointment f on f.NoRegistrasi = a.NoRegistrasi
            //                               outer apply (SELECT KODE_TARIF,NILAI_TARIF,NO_REGISTRASI FROM Billing_Pasien.dbo.FO_T_BILLING_1 where GROUP_ENTRI='KARCIS' and BATAL='0' and NO_REGISTRASI collate Latin1_General_CI_AS=a.NoRegistrasi collate Latin1_General_CI_AS)
            //                               bl 
            //                               where a.PatientType='2' and a.Batal='0'  and  a.id=:IdRegistrasi
            //                               UNION ALL
            //                               SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName ,a.LokasiPasien,a.CaraBayar,
            //                               a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
            //                               a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
            //                               a.PatientType,a.Unit,a.Doctor_1,b.First_Name as namadokter,a.JamPraktek,a.Perusahaan as Perusahaanid,c.NamaPerusahaan as  Perusahaan,a.[Payment Type],
            //                               a.Antrian,a.NoAntrianAll,e.[First Name] as namauser,
            //           replace(CONVERT(VARCHAR(11), d.Date_of_birth, 111), '/','-') as Date_of_birthx,
            //           d.Address,d.Gander,d.BirthPlace,d.Ocupation,d.[Mobile Phone] as noHp,
            //           case when d.Gander='L' then 'LAKI-LAKI' when d.Gander='P' then 'PEREMPUAN'  END AS NamaGander,
            //           d.ID_Card_number,a.idAdmin,a.idCaraMasuk,a.idCaraMasuk2,a.JenisDaftar,f.NoBooking,
            //           replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglkunjungan,
            //           CONVERT(VARCHAR(8),TglKunjungan,108) as jamkunjungan,bl.KODE_TARIF,a.Tipe_Registrasi,
            //           a.JamPraktek,a.ID_JadwalPraktek,a.Catatan,a.KodeJaminanCOB,a.idRegKemenkes,a.idDoktertKemkes,a.idUnitKemkes
            //                               from PerawatanSQL.dbo.Visit a
            //                               inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
            //                               inner join MasterdataSQL.dbo.MstrPerusahaanJPK c on c.ID = a.Perusahaan
            //                               inner join $tabel d on d.NoMR = a.NoMR
            //                               inner join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
            //                               left join PerawatanSQL.DBO.Apointment f on f.NoRegistrasi = a.NoRegistrasi
            //                               outer apply (SELECT KODE_TARIF,NILAI_TARIF,NO_REGISTRASI FROM Billing_Pasien.dbo.FO_T_BILLING_1 where GROUP_ENTRI='KARCIS' and BATAL='0' and NO_REGISTRASI collate Latin1_General_CI_AS=a.NoRegistrasi collate Latin1_General_CI_AS)
            //                               bl  
            //                               where a.PatientType<>'2' and a.Batal='0' and  a.id=:IdRegistrasi2
            //                              ");

            $this->db->query(" SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName,a.LokasiPasien,a.CaraBayar,
            a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
            a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
            a.PatientType,a.Unit,a.Doctor_1,b.First_Name as namadokter,a.JamPraktek,
            case when a.Asuransi is not null and a.PatientType='2' then a.Asuransi else a.Perusahaan end as Perusahaanid,
		    case when c.NamaPerusahaan is not null and a.PatientType='2'  then c.NamaPerusahaan else h.NamaPerusahaan end as  Perusahaan,
            a.[Payment Type],
            a.Antrian,a.NoAntrianAll,e.[First Name] as namauser,
            replace(CONVERT(VARCHAR(11), d.Date_of_birth, 111), '/','-') as Date_of_birthx,
            d.Address,d.Gander,d.BirthPlace,d.Ocupation,d.[Mobile Phone] as noHp,
            case when d.Gander='L' then 'LAKI-LAKI' when d.Gander='P' then 'PEREMPUAN'  END AS NamaGander,
            d.ID_Card_number,a.idAdmin,a.idCaraMasuk,a.idCaraMasuk2,a.JenisDaftar,f.NoBooking,
            replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglkunjungan,
            CONVERT(VARCHAR(8),TglKunjungan,108) as jamkunjungan,bl.KODE_TARIF,a.Tipe_Registrasi,a.JamPraktek,
            a.ID_JadwalPraktek,a.Catatan,a.KodeJaminanCOB,a.idRegKemenkes,a.idDoktertKemkes,a.idUnitKemkes
            from PerawatanSQL.dbo.Visit a
            inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
            left join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.Asuransi
            left join MasterdataSQL.dbo.MstrPerusahaanJPK h on h.ID = a.Perusahaan
            inner join $tabel d on d.NoMR = a.NoMR
            inner join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
            left join PerawatanSQL.DBO.Apointment f on f.NoRegistrasi = a.NoRegistrasi
            outer apply (SELECT KODE_TARIF,NILAI_TARIF,NO_REGISTRASI FROM Billing_Pasien.dbo.FO_T_BILLING_1 where GROUP_ENTRI='KARCIS' and BATAL='0' and NO_REGISTRASI collate Latin1_General_CI_AS=a.NoRegistrasi collate Latin1_General_CI_AS)
            bl 
            where  a.Batal='0'  and  a.id=:IdRegistrasi ");
            $this->db->bind('IdRegistrasi', $IdRegistrasi);
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
                'KodeJaminanCOB' => $data['KodeJaminanCOB'],
                'idRegKemenkes' => $data['idRegKemenkes'],
                'idDoktertKemkes' => $data['idDoktertKemkes'],
                'idUnitKemkes' => $data['idUnitKemkes']
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
    public function GetregistrasiRajalbyNoRegistrasi($data)
    {
        try {
            $NoRegistrasi = $data['NoRegistrasi'];
            // $this->db->query(" SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName,a.LokasiPasien,a.CaraBayar,
            //                               a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
            //                               a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
            //                               a.PatientType,a.Unit,a.Doctor_1,b.First_Name as namadokter,a.JamPraktek,a.Asuransi as Perusahaanid,c.NamaPerusahaan as  Perusahaan,a.[Payment Type],
            //                               a.Antrian,a.NoAntrianAll,e.[First Name] as namauser,
            //           replace(CONVERT(VARCHAR(11), d.Date_of_birth, 111), '/','-') as Date_of_birthx,
            //           d.Address,d.Gander,d.BirthPlace,d.Ocupation,
            //           case when d.Gander='L' then 'LAKI-LAKI' when d.Gander='P' then 'PEREMPUAN'  END AS NamaGander,
            //           d.ID_Card_number,a.idAdmin,a.idCaraMasuk,a.idCaraMasuk2,a.JenisDaftar,f.NoBooking,replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglkunjungan,CONVERT(VARCHAR(8),TglKunjungan,108) as jamkunjungan
            //                               ,f.Description from PerawatanSQL.dbo.Visit a
            //                               inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
            //                               inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.Asuransi
            //                               inner join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
            //                               inner join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
            //                               left join PerawatanSQL.DBO.Apointment f on f.NoRegistrasi = a.NoRegistrasi
            //                               where a.PatientType='2' and a.Batal='0'  and  a.NoRegistrasi=:NoRegistrasi
            //                               UNION ALL
            //                               SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName ,a.LokasiPasien,a.CaraBayar,
            //                               a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
            //                               a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
            //                               a.PatientType,a.Unit,a.Doctor_1,b.First_Name as namadokter,a.JamPraktek,a.Perusahaan as Perusahaanid,c.NamaPerusahaan as  Perusahaan,a.[Payment Type],
            //                               a.Antrian,a.NoAntrianAll,e.[First Name] as namauser,
            //           replace(CONVERT(VARCHAR(11), d.Date_of_birth, 111), '/','-') as Date_of_birthx,
            //           d.Address,d.Gander,d.BirthPlace,d.Ocupation,
            //           case when d.Gander='L' then 'LAKI-LAKI' when d.Gander='P' then 'PEREMPUAN'  END AS NamaGander,
            //           d.ID_Card_number,a.idAdmin,a.idCaraMasuk,a.idCaraMasuk2,a.JenisDaftar,f.NoBooking,replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglkunjungan,CONVERT(VARCHAR(8),TglKunjungan,108) as jamkunjungan
            //                               ,f.Description from PerawatanSQL.dbo.Visit a
            //                               inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
            //                               inner join MasterdataSQL.dbo.MstrPerusahaanJPK c on c.ID = a.Perusahaan
            //                               inner join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
            //                               inner join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
            //                               left join PerawatanSQL.DBO.Apointment f on f.NoRegistrasi = a.NoRegistrasi
            //                               where a.PatientType<>'2' and a.Batal='0' and  a.NoRegistrasi=:NoRegistrasi2
            //                               UNION ALL
            //                               SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName,a.LokasiPasien,a.CaraBayar,
            //                               a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
            //                               a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
            //                               a.PatientType,a.Unit,a.Doctor_1,b.First_Name as namadokter,a.JamPraktek,a.Asuransi as Perusahaanid,c.NamaPerusahaan as  Perusahaan,a.[Payment Type],
            //                               a.Antrian,a.NoAntrianAll,e.[First Name] as namauser,
            //           replace(CONVERT(VARCHAR(11), d.Date_of_birth, 111), '/','-') as Date_of_birthx,
            //           d.Address,d.Gander,d.BirthPlace,d.Ocupation,
            //           case when d.Gander='L' then 'LAKI-LAKI' when d.Gander='P' then 'PEREMPUAN'  END AS NamaGander,
            //           d.ID_Card_number,a.idAdmin,a.idCaraMasuk,a.idCaraMasuk2,a.JenisDaftar,f.NoBooking,replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglkunjungan,CONVERT(VARCHAR(8),TglKunjungan,108) as jamkunjungan
            //                               ,f.Description from PerawatanSQL.dbo.Visit a
            //                               inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
            //                               inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.Asuransi
            //                               inner join MasterdataSQL.dbo.Admision_walkin d on d.NoMR = a.NoMR
            //                               inner join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
            //                               left join PerawatanSQL.DBO.Apointment f on f.NoRegistrasi = a.NoRegistrasi
            //                               where a.PatientType='2' and a.Batal='0'  and  a.NoRegistrasi=:NoRegistrasi3
            //                               UNION ALL
            //                               SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName ,a.LokasiPasien,a.CaraBayar,
            //                               a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
            //                               a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
            //                               a.PatientType,a.Unit,a.Doctor_1,b.First_Name as namadokter,a.JamPraktek,a.Perusahaan as Perusahaanid,c.NamaPerusahaan as  Perusahaan,a.[Payment Type],
            //                               a.Antrian,a.NoAntrianAll,e.[First Name] as namauser,
            //           replace(CONVERT(VARCHAR(11), d.Date_of_birth, 111), '/','-') as Date_of_birthx,
            //           d.Address,d.Gander,d.BirthPlace,d.Ocupation,
            //           case when d.Gander='L' then 'LAKI-LAKI' when d.Gander='P' then 'PEREMPUAN'  END AS NamaGander,
            //           d.ID_Card_number,a.idAdmin,a.idCaraMasuk,a.idCaraMasuk2,a.JenisDaftar,f.NoBooking,replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglkunjungan,CONVERT(VARCHAR(8),TglKunjungan,108) as jamkunjungan
            //                               ,f.Description from PerawatanSQL.dbo.Visit a
            //                               inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
            //                               inner join MasterdataSQL.dbo.MstrPerusahaanJPK c on c.ID = a.Perusahaan
            //                               inner join MasterdataSQL.dbo.Admision_walkin d on d.NoMR = a.NoMR
            //                               inner join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
            //                               left join PerawatanSQL.DBO.Apointment f on f.NoRegistrasi = a.NoRegistrasi
            //                               where a.PatientType<>'2' and a.Batal='0' and  a.NoRegistrasi=:NoRegistrasi4
            //                              ");

            $this->db->query(" SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName,a.LokasiPasien,a.CaraBayar,
            a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
            a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
            a.PatientType,a.Unit,a.Doctor_1,b.First_Name as namadokter,a.JamPraktek,
            case when a.Asuransi is not null and a.PatientType='2' then a.Asuransi else a.Perusahaan end as Perusahaanid,
			case when c.NamaPerusahaan is not null and a.PatientType='2'  then c.NamaPerusahaan else h.NamaPerusahaan end as  Perusahaan,
            a.[Payment Type],
            a.Antrian,a.NoAntrianAll,e.[First Name] as namauser,
            replace(CONVERT(VARCHAR(11), d.Date_of_birth, 111), '/','-') as Date_of_birthx,
            d.Address,d.Gander,d.BirthPlace,d.Ocupation,
            case when d.Gander='L' then 'LAKI-LAKI' when d.Gander='P' then 'PEREMPUAN'  END AS NamaGander,
            d.ID_Card_number,a.idAdmin,a.idCaraMasuk,a.idCaraMasuk2,a.JenisDaftar,f.NoBooking,replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglkunjungan,CONVERT(VARCHAR(8),TglKunjungan,108) as jamkunjungan
            ,f.Description from PerawatanSQL.dbo.Visit a
            inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
            left join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.Asuransi
			left join MasterdataSQL.dbo.MstrPerusahaanJPK h on h.ID = a.Perusahaan
            inner join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
            inner join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
            left join PerawatanSQL.DBO.Apointment f on f.NoRegistrasi = a.NoRegistrasi
            where  a.Batal='0'  and  a.NoRegistrasi=:NoRegistrasi 
            UNION ALL
            SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName,a.LokasiPasien,a.CaraBayar,
            a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
            a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
            a.PatientType,a.Unit,a.Doctor_1,b.First_Name as namadokter,a.JamPraktek,
            case when a.Asuransi is not null and a.PatientType='2' then a.Asuransi else a.Perusahaan end as Perusahaanid,
			case when c.NamaPerusahaan is not null and a.PatientType='2'  then c.NamaPerusahaan else h.NamaPerusahaan end as  Perusahaan,
            a.[Payment Type],
            a.Antrian,a.NoAntrianAll,e.[First Name] as namauser,
            replace(CONVERT(VARCHAR(11), d.Date_of_birth, 111), '/','-') as Date_of_birthx,
            d.Address,d.Gander,d.BirthPlace,d.Ocupation,
            case when d.Gander='L' then 'LAKI-LAKI' when d.Gander='P' then 'PEREMPUAN'  END AS NamaGander,
            d.ID_Card_number,a.idAdmin,a.idCaraMasuk,a.idCaraMasuk2,a.JenisDaftar,f.NoBooking,replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglkunjungan,CONVERT(VARCHAR(8),TglKunjungan,108) as jamkunjungan
            ,f.Description from PerawatanSQL.dbo.Visit a
            inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
            left join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.Asuransi
			left join MasterdataSQL.dbo.MstrPerusahaanJPK h on h.ID = a.Perusahaan
            inner join MasterdataSQL.dbo.Admision_walkin d on d.NoMR = a.NoMR
            inner join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
            left join PerawatanSQL.DBO.Apointment f on f.NoRegistrasi = a.NoRegistrasi
            where a.Batal='0'  and  a.NoRegistrasi=:NoRegistrasi2 ");
            $this->db->bind('NoRegistrasi', $NoRegistrasi);
            $this->db->bind('NoRegistrasi2', $NoRegistrasi);
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success', // Set array status dengan success
                'ID' => $data['id'], // Set array status dengan success
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
                'Description' => $data['Description'],

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
    public function GetregistrasiRajalbyNoRegistrasiDigital($data)
    {
        try {
            $NoRegistrasi = $data;

            // $this->db->query(" SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName,a.LokasiPasien,a.CaraBayar,
            //                               a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
            //                               a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
            //                               a.PatientType,a.Unit,a.Doctor_1,b.First_Name as namadokter,a.JamPraktek,a.Asuransi as Perusahaanid,c.NamaPerusahaan as  Perusahaan,a.[Payment Type],
            //                               a.Antrian,a.NoAntrianAll,e.[First Name] as namauser,
            //           replace(CONVERT(VARCHAR(11), d.Date_of_birth, 111), '/','-') as Date_of_birthx,
            //           d.Address,d.Gander,d.BirthPlace,d.Ocupation,
            //           case when d.Gander='L' then 'LAKI-LAKI' when d.Gander='P' then 'PEREMPUAN'  END AS NamaGander,
            //           d.ID_Card_number,a.idAdmin,a.idCaraMasuk,a.idCaraMasuk2,a.JenisDaftar,f.NoBooking,replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglkunjungan,CONVERT(VARCHAR(8),TglKunjungan,108) as jamkunjungan
            //                               ,f.Description from PerawatanSQL.dbo.Visit a
            //                               inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
            //                               inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.Asuransi
            //                               inner join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
            //                               inner join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
            //                               left join PerawatanSQL.DBO.Apointment f on f.NoRegistrasi = a.NoRegistrasi
            //                               where a.PatientType='2' and a.Batal='0'  and  a.NoRegistrasi=:NoRegistrasi
            //                               UNION ALL
            //                               SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName ,a.LokasiPasien,a.CaraBayar,
            //                               a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
            //                               a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
            //                               a.PatientType,a.Unit,a.Doctor_1,b.First_Name as namadokter,a.JamPraktek,a.Perusahaan as Perusahaanid,c.NamaPerusahaan as  Perusahaan,a.[Payment Type],
            //                               a.Antrian,a.NoAntrianAll,e.[First Name] as namauser,
            //           replace(CONVERT(VARCHAR(11), d.Date_of_birth, 111), '/','-') as Date_of_birthx,
            //           d.Address,d.Gander,d.BirthPlace,d.Ocupation,
            //           case when d.Gander='L' then 'LAKI-LAKI' when d.Gander='P' then 'PEREMPUAN'  END AS NamaGander,
            //           d.ID_Card_number,a.idAdmin,a.idCaraMasuk,a.idCaraMasuk2,a.JenisDaftar,f.NoBooking,replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglkunjungan,CONVERT(VARCHAR(8),TglKunjungan,108) as jamkunjungan
            //                               ,f.Description from PerawatanSQL.dbo.Visit a
            //                               inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
            //                               inner join MasterdataSQL.dbo.MstrPerusahaanJPK c on c.ID = a.Perusahaan
            //                               inner join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
            //                               inner join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
            //                               left join PerawatanSQL.DBO.Apointment f on f.NoRegistrasi = a.NoRegistrasi
            //                               where a.PatientType<>'2' and a.Batal='0' and  a.NoRegistrasi=:NoRegistrasi2
            //                               UNION ALL
            //                               SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName,a.LokasiPasien,a.CaraBayar,
            //                               a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
            //                               a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
            //                               a.PatientType,a.Unit,a.Doctor_1,b.First_Name as namadokter,a.JamPraktek,a.Asuransi as Perusahaanid,c.NamaPerusahaan as  Perusahaan,a.[Payment Type],
            //                               a.Antrian,a.NoAntrianAll,e.[First Name] as namauser,
            //           replace(CONVERT(VARCHAR(11), d.Date_of_birth, 111), '/','-') as Date_of_birthx,
            //           d.Address,d.Gander,d.BirthPlace,d.Ocupation,
            //           case when d.Gander='L' then 'LAKI-LAKI' when d.Gander='P' then 'PEREMPUAN'  END AS NamaGander,
            //           d.ID_Card_number,a.idAdmin,a.idCaraMasuk,a.idCaraMasuk2,a.JenisDaftar,f.NoBooking,replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglkunjungan,CONVERT(VARCHAR(8),TglKunjungan,108) as jamkunjungan
            //                               ,f.Description from PerawatanSQL.dbo.Visit a
            //                               inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
            //                               inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.Asuransi
            //                               inner join MasterdataSQL.dbo.Admision_walkin d on d.NoMR = a.NoMR
            //                               inner join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
            //                               left join PerawatanSQL.DBO.Apointment f on f.NoRegistrasi = a.NoRegistrasi
            //                               where a.PatientType='2' and a.Batal='0'  and  a.NoRegistrasi=:NoRegistrasi3
            //                               UNION ALL
            //                               SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName ,a.LokasiPasien,a.CaraBayar,
            //                               a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
            //                               a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
            //                               a.PatientType,a.Unit,a.Doctor_1,b.First_Name as namadokter,a.JamPraktek,a.Perusahaan as Perusahaanid,c.NamaPerusahaan as  Perusahaan,a.[Payment Type],
            //                               a.Antrian,a.NoAntrianAll,e.[First Name] as namauser,
            //           replace(CONVERT(VARCHAR(11), d.Date_of_birth, 111), '/','-') as Date_of_birthx,
            //           d.Address,d.Gander,d.BirthPlace,d.Ocupation,
            //           case when d.Gander='L' then 'LAKI-LAKI' when d.Gander='P' then 'PEREMPUAN'  END AS NamaGander,
            //           d.ID_Card_number,a.idAdmin,a.idCaraMasuk,a.idCaraMasuk2,a.JenisDaftar,f.NoBooking,replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglkunjungan,CONVERT(VARCHAR(8),TglKunjungan,108) as jamkunjungan
            //                               ,f.Description from PerawatanSQL.dbo.Visit a
            //                               inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
            //                               inner join MasterdataSQL.dbo.MstrPerusahaanJPK c on c.ID = a.Perusahaan
            //                               inner join MasterdataSQL.dbo.Admision_walkin d on d.NoMR = a.NoMR
            //                               inner join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
            //                               left join PerawatanSQL.DBO.Apointment f on f.NoRegistrasi = a.NoRegistrasi
            //                               where a.PatientType<>'2' and a.Batal='0' and  a.NoRegistrasi=:NoRegistrasi4
            //                              ");

            $this->db->query(" SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName,a.LokasiPasien,a.CaraBayar,
            a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
            a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
            a.PatientType,a.Unit,a.Doctor_1,b.First_Name as namadokter,a.JamPraktek,
            case when a.Asuransi is not null and a.PatientType='2' then a.Asuransi else a.Perusahaan end as Perusahaanid,
            case when c.NamaPerusahaan is not null and a.PatientType='2'  then c.NamaPerusahaan else h.NamaPerusahaan end as  Perusahaan,
            a.[Payment Type],
            a.Antrian,a.NoAntrianAll,e.[First Name] as namauser,
replace(CONVERT(VARCHAR(11), d.Date_of_birth, 111), '/','-') as Date_of_birthx,
d.Address,d.Gander,d.BirthPlace,d.Ocupation,
case when d.Gander='L' then 'LAKI-LAKI' when d.Gander='P' then 'PEREMPUAN'  END AS NamaGander,
d.ID_Card_number,a.idAdmin,a.idCaraMasuk,a.idCaraMasuk2,a.JenisDaftar,f.NoBooking,replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglkunjungan,CONVERT(VARCHAR(8),TglKunjungan,108) as jamkunjungan
            ,f.Description,d.Religion,d.Tipe_Idcard,d.[Home Phone] as NoHP,d.[E-mail Address] as Email from PerawatanSQL.dbo.Visit a
            inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
            left join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.Asuransi
            left join MasterdataSQL.dbo.MstrPerusahaanJPK h on h.ID = a.Perusahaan
            inner join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
            inner join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
            left join PerawatanSQL.DBO.Apointment f on f.NoRegistrasi = a.NoRegistrasi
            where  a.Batal='0'  and  a.NoRegistrasi=:NoRegistrasi
            UNION ALL
            SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName,a.LokasiPasien,a.CaraBayar,
            a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
            a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
            a.PatientType,a.Unit,a.Doctor_1,b.First_Name as namadokter,a.JamPraktek,
            case when a.Asuransi is not null and a.PatientType='2' then a.Asuransi else a.Perusahaan end as Perusahaanid,
            case when c.NamaPerusahaan is not null and a.PatientType='2'  then c.NamaPerusahaan else h.NamaPerusahaan end as  Perusahaan,
            a.[Payment Type],
            a.Antrian,a.NoAntrianAll,e.[First Name] as namauser,
replace(CONVERT(VARCHAR(11), d.Date_of_birth, 111), '/','-') as Date_of_birthx,
d.Address,d.Gander,d.BirthPlace,d.Ocupation,
case when d.Gander='L' then 'LAKI-LAKI' when d.Gander='P' then 'PEREMPUAN'  END AS NamaGander,
d.ID_Card_number,a.idAdmin,a.idCaraMasuk,a.idCaraMasuk2,a.JenisDaftar,f.NoBooking,replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglkunjungan,CONVERT(VARCHAR(8),TglKunjungan,108) as jamkunjungan
            ,f.Description,d.Religion,d.Tipe_Idcard,d.[Home Phone] as NoHP,d.[E-mail Address] as Email from PerawatanSQL.dbo.Visit a
            inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
            left join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.Asuransi
            left join MasterdataSQL.dbo.MstrPerusahaanJPK h on h.ID = a.Perusahaan
            inner join MasterdataSQL.dbo.Admision_walkin d on d.NoMR = a.NoMR
            inner join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
            left join PerawatanSQL.DBO.Apointment f on f.NoRegistrasi = a.NoRegistrasi
            where   a.Batal='0'  and  a.NoRegistrasi=:NoRegistrasi2
            
           ");

            $this->db->bind('NoRegistrasi', $NoRegistrasi);
            $this->db->bind('NoRegistrasi2', $NoRegistrasi);
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success', // Set array status dengan success
                'ID' => $data['id'], // Set array status dengan success
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
                'Description' => $data['Description'],
                'Religion' => $data['Religion'],
                'Tipe_Idcard' => $data['Tipe_Idcard'],
                'NoHP' => $data['NoHP'],
                'Email' => $data['Email'],

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
    public function GetregistrasiRajalbyNoRegistrasiRI($data)
    {
        try {
            $NoRegistrasi = $data['NoRegistrasi'];

            // $this->db->query(" SELECT b.First_Name as NamaDokter,a.NoRegRI,a.NoEpisode,d.PatientName,a.NoMR,a.drPenerima,a.JenisRawat,a.InpatientID as id,replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as tglkunjungan,CONVERT(VARCHAR(8),a.StartTime,108) as jamkunjungan,c.ID as Perusahaanid,c.NamaPerusahaan as  Perusahaan,a.TypePatient as PatientType
            //                               from RawatInapSQL.dbo.Inpatient a
            //                               inner join MasterdataSQL.dbo.Doctors b on a.drPenerima = b.ID
            //                               inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.IDAsuransi
            //                               inner join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
            //                               where a.TypePatient='2'  and  a.NoRegRI=:NoRegistrasi
            //                               UNION ALL
            //                               SELECT b.First_Name as NamaDokter,a.NoRegRI,a.NoEpisode,d.PatientName,a.NoMR,a.drPenerima,a.JenisRawat,a.InpatientID as id,replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as tglkunjungan,CONVERT(VARCHAR(8),a.StartTime,108) as jamkunjungan,c.ID as Perusahaanid,c.NamaPerusahaan as  Perusahaan,a.TypePatient as PatientType
            //                               from RawatInapSQL.dbo.Inpatient a
            //                               inner join MasterdataSQL.dbo.Doctors b on a.drPenerima = b.ID
            //                               inner join MasterdataSQL.dbo.MstrPerusahaanJPK c on c.ID = a.IDJPK
            //                               inner join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
            //                               where a.TypePatient<>'2'  and  a.NoRegRI=:NoRegistrasi2");

            $this->db->query("SELECT b.First_Name as NamaDokter,a.NoRegRI,a.NoEpisode,d.PatientName,a.NoMR,a.drPenerima,a.JenisRawat,
                                a.InpatientID as id,replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as tglkunjungan,CONVERT(VARCHAR(8),a.StartTime,108) as jamkunjungan,
                                case when a.IDAsuransi is not null and a.TypePatient='2' then a.IDAsuransi else a.IDJPK end as Perusahaanid,
                                case when c.NamaPerusahaan is not null and a.TypePatient='2'  
                                then c.NamaPerusahaan else h.NamaPerusahaan end as  Perusahaan,
                                a.TypePatient as PatientType
                                from RawatInapSQL.dbo.Inpatient a
                                inner join MasterdataSQL.dbo.Doctors b on a.drPenerima = b.ID
                                left join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.IDAsuransi
                                left join MasterdataSQL.dbo.MstrPerusahaanJPK h on h.ID = a.IDJPK
                                inner join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
                                where  a.NoRegRI=:NoRegistrasi");
            $this->db->bind('NoRegistrasi', $NoRegistrasi);
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success',
                'ID' => $data['id'],
                'NoMR' => $data['NoMR'],
                'NoEpisode' => $data['NoEpisode'],
                'NoRegistrasi' => $data['NoRegRI'],
                'PatientName' => $data['PatientName'],
                'LokasiPasien' => $data['JenisRawat'],
                'NamaDokter' => $data['NamaDokter'],
                'Doctor1' => $data['drPenerima'],
                'VisitDate' => $data['tglkunjungan'],
                'JamDate' => $data['jamkunjungan'],
                'Perusahaanid' => $data['Perusahaanid'],
                'Perusahaan' => $data['Perusahaan'],
                'PatientType' => $data['PatientType'],
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
    public function GetregistrasiRanapbyNoRegistrasiRIDigital($data)
    {
        try {
            $NoRegistrasi = $data;
            // $this->db->query(" SELECT b.First_Name as NamaDokter,a.NoRegRI,a.NoEpisode,d.PatientName,a.NoMR,a.drPenerima,a.JenisRawat,a.InpatientID as id,replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as tglkunjungan,CONVERT(VARCHAR(8),a.StartTime,108) as jamkunjungan,c.ID as Perusahaanid,c.NamaPerusahaan as  Perusahaan,a.TypePatient as PatientType
            //                               from RawatInapSQL.dbo.Inpatient a
            //                               inner join MasterdataSQL.dbo.Doctors b on a.drPenerima = b.ID
            //                               inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.IDAsuransi
            //                               inner join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
            //                               where a.TypePatient='2'  and  a.NoRegRI=:NoRegistrasi
            //                               UNION ALL
            //                               SELECT b.First_Name as NamaDokter,a.NoRegRI,a.NoEpisode,d.PatientName,a.NoMR,a.drPenerima,a.JenisRawat,a.InpatientID as id,replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as tglkunjungan,CONVERT(VARCHAR(8),a.StartTime,108) as jamkunjungan,c.ID as Perusahaanid,c.NamaPerusahaan as  Perusahaan,a.TypePatient as PatientType
            //                               from RawatInapSQL.dbo.Inpatient a
            //                               inner join MasterdataSQL.dbo.Doctors b on a.drPenerima = b.ID
            //                               inner join MasterdataSQL.dbo.MstrPerusahaanJPK c on c.ID = a.IDJPK
            //                               inner join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
            //                               where a.TypePatient<>'2'  and  a.NoRegRI=:NoRegistrasi2");

            // $this->db->query(" SELECT b.First_Name as NamaDokter,a.NoRegRI,a.NoEpisode,d.PatientName,a.NoMR,
            //                             a.drPenerima,a.JenisRawat,a.InpatientID as id,
            //                             replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as tglkunjungan,
            //                             CONVERT(VARCHAR(8),a.StartTime,108) as jamkunjungan,
            //                             case when a.IDAsuransi is not null and a.TypePatient='2' then a.IDAsuransi else a.IDJPK end as Perusahaanid,
            //                             case when c.NamaPerusahaan is not null and a.TypePatient='2'  then c.NamaPerusahaan else h.NamaPerusahaan end as  Perusahaan,
            //                             a.TypePatient as PatientType, replace(CONVERT(VARCHAR(11), d.Date_of_birth, 111), '/','-') as Date_of_birth
            //                             from RawatInapSQL.dbo.Inpatient a
            //                             inner join MasterdataSQL.dbo.Doctors b on a.drPenerima = b.ID
            //                             left join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.IDAsuransi 
			// 							left join MasterdataSQL.dbo.MstrPerusahaanJPK h on h.ID = a.IDJPK
            //                             inner join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
            //                             where  a.NoRegRI=:NoRegistrasi ");

                        $this->db->query("SELECT a.InpatientID as id, a.NoEpisode,a.NoRegRI as NoRegistrasi,d.PatientName,a.JenisRawat as LokasiPasien,'' CaraBayar,
                        a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
                        a.TglRujukan,a.StartDate as TglKunjungan,a.PPKRujukan, a.StartDate as [Visit Date],
                        a.TypePatient as PatientType,a.JenisRawat Unit,a.drPenerima as Doctor_1,b.First_Name as namadokter,'' JamPraktek,
                        case when a.IDAsuransi is not null and a.TypePatient='2' then a.IDAsuransi else a.IDJPK end as Perusahaanid,
                        case when c.NamaPerusahaan is not null and a.TypePatient='2'  then c.NamaPerusahaan else h.NamaPerusahaan end as  Perusahaan,
                        '' [Payment Type],
                        '' Antrian,'' NoAntrianAll,e.[First Name] as namauser,
                        replace(CONVERT(VARCHAR(11), d.Date_of_birth, 111), '/','-') as Date_of_birthx,
                        d.Address,d.Gander,d.BirthPlace,d.Ocupation,
                        case when d.Gander='L' then 'LAKI-LAKI' when d.Gander='P' then 'PEREMPUAN'  END AS NamaGander,
                        d.ID_Card_number,'' idAdmin,a.idCaraMasuk,a.idCaraMasuk2,'' JenisDaftar,'' NoBooking,replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as tglkunjungan,
						CONVERT(VARCHAR(8),startTime,108) as jamkunjungan
                        ,'' Description,d.Religion,d.Tipe_Idcard,d.[Home Phone] as NoHP,d.[E-mail Address] as Email 
                            from RawatInapSQL.dbo.Inpatient a
                            inner join MasterdataSQL.dbo.Doctors b on a.drPenerima = b.ID
                            left join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.IDAsuransi 
                            left join MasterdataSQL.dbo.MstrPerusahaanJPK h on h.ID = a.IDJPK
                            inner join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
                            inner join MasterdataSQL.dbo.Employees e on e.ID = a.operator
                            where  a.NoRegRI=:NoRegistrasi");
            $this->db->bind('NoRegistrasi', $NoRegistrasi); 
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success',
                'ID' => $data['id'],
                'NoMR' => $data['NoMR'],
                'NoEpisode' => $data['NoEpisode'],
                'NoRegistrasi' => $data['NoRegistrasi'],
                'PatientName' => $data['PatientName'],
                'LokasiPasien' => $data['LokasiPasien'],
                'CaraBayar' => $data['CaraBayar'], 
                'NoPesertaBPJS' => $data['NoPesertaBPJS'], 
                'NoSEP' => $data['NoSEP'], 
                'TglSEP' => $data['TglSEP'], 
                'AlasanSEPtunda' => $data['AlasanSEPtunda'], 
                'ID_Card_number' => $data['ID_Card_number'], 
                'Gander' => $data['Gander'],
                'Date_of_birth' => $data['Date_of_birthx'], 
                'Address' => $data['Address'], 
                'NamaGander' => $data['NamaGander'], 
                'BirthPlace' => $data['BirthPlace'], 
                'Ocupation' => $data['Ocupation'], 
                'NoAntrianAll' => $data['NoAntrianAll'], 
                'NoBooking' => $data['NoBooking'],
                'Unit' => $data['Unit'], 
                'LokasiPasien' => $data['LokasiPasien'], 
                'namadokter' => $data['namadokter'], 
                'Doctor1' => $data['Doctor_1'], 
                'PatientType' => $data['PatientType'], 
                'Perusahaanid' => $data['Perusahaanid'], 
                'Perusahaan' => $data['Perusahaan'], 
                'idAdmin' => $data['idAdmin'], 
                'idCaraMasuk' => $data['idCaraMasuk'], 
                'idCaraMasuk2' => $data['idCaraMasuk2'], 
                'JenisDaftar' => $data['JenisDaftar'], 
                'VisitDate' => $data['tglkunjungan'],
                'JamDate' => $data['jamkunjungan'],
                'Description' => $data['Description'],
                'Religion' => $data['Religion'],
                'Tipe_Idcard' => $data['Tipe_Idcard'],
                'NoHP' => $data['NoHP'],
                'Email' => $data['Email'],
                'Perusahaanid' => $data['Perusahaanid'],
                'Perusahaan' => $data['Perusahaan'],
                'PatientType' => $data['PatientType'],
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
    public function GetregistrasiRajalbyNoMR($data)
    {
        try {
            $Rad_NoMR = $data['Rad_NoMR'];
            $this->db->query(" SELECT c.PatientName, CASE WHEN c.Gander='L' then 'M' ELSE 'F' END AS Gander, 
                        replace(CONVERT(VARCHAR(11), c.Date_of_birth, 111), '/','-') as Date_of_birth,c.Address,
                        case when a.PatientType='1' THEN 'PRIBADI' WHEN a.PatientType='2' THEN 'ASURANSI' 
                        WHEN a.PatientType='5' THEN 'PERUSAHAAN' END 
                        AS  PatientType,d.CODEUNIT,d.NamaUnit,a.Doctor_1,e.First_Name, a.NoMR,a.NoEpisode,
                        a.NoRegistrasi
                        from PerawatanSQL.dbo.Visit a 
                        inner join MasterdataSQL.dbo.Admision c
                        on c.NoMR = a.NoMR
                        inner join MasterdataSQL.dbo.MstrUnitPerwatan d
                        on d.ID=a.Unit
                        inner join MasterdataSQL.dbo.Doctors e
                        on e.ID=a.Doctor_1
                        where a.NoMR=:Rad_NoMR
                        UNION ALL
                        SELECT c.PatientName, CASE WHEN c.Gander='L' then 'M' ELSE 'F' END AS Gander, 
                        replace(CONVERT(VARCHAR(11), c.Date_of_birth, 111), '/','-') as Date_of_birth,c.Address,
                        case when a.PatientType='1' THEN 'PRIBADI' WHEN a.PatientType='2' THEN 'ASURANSI' 
                        WHEN a.PatientType='5' THEN 'PERUSAHAAN' END 
                        AS  PatientType,d.CODEUNIT,d.NamaUnit,a.Doctor_1,e.First_Name, a.NoMR,a.NoEpisode,
                        a.NoRegistrasi
                        from PerawatanSQL.dbo.Visit a 
                        inner join MasterdataSQL.dbo.Admision_walkin c
                        on c.NoMR = a.NoMR
                        inner join MasterdataSQL.dbo.MstrUnitPerwatan d
                        on d.ID=a.Unit
                        inner join MasterdataSQL.dbo.Doctors e
                        on e.ID=a.Doctor_1
                        where a.NoMR=:Rad_NoMR2");
            $this->db->bind('Rad_NoMR', $Rad_NoMR);
            $this->db->bind('Rad_NoMR2', $Rad_NoMR);
            $dtReg =  $this->db->single();

            return $dtReg;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function PrintBuktiRegis($data)
    {
        try {
            $this->db->query("SELECT A.NoRegistrasi,A.NoMR,B.PatientName,A.NoAntrianAll,A.TglKunjungan,
            C.First_Name as dokternama, d.NamaUnit  ,
            CONVERT(VARCHAR(11), a.TglKunjungan, 103) as tglfix,
            CONVERT(VARCHAR(11), a.TglKunjungan, 108)  as jamfix,
            JamPraktek,
            case when
			datename(dw,a.TglKunjungan) = 'Sunday' then Minggu_Waktu
			when datename(dw,a.TglKunjungan) = 'Monday' then Senin_Waktu
			when datename(dw,a.TglKunjungan) = 'Tuesday' then Selasa_Waktu
			when datename(dw,a.TglKunjungan) = 'Wednesday' then Rabu_Waktu
			when datename(dw,a.TglKunjungan) = 'Thursday' then Kamis_Waktu
			when datename(dw,a.TglKunjungan) = 'Friday' then Jumat_Waktu
			when datename(dw,a.TglKunjungan) = 'Saturday' then Sabtu_Waktu
			end as JamPraktekDokter
            ,Case when a.PatientType='2' Then asu.NamaPerusahaan
            else jpk.NamaPerusahaan end as NamaJaminan,a.NoSEP
            FROM PerawatanSQL.DBO.Visit A
            left JOIN MasterdataSQL.DBO.Admision B 
            ON A.NoMR = B.NoMR 
            left JOIN MasterdataSQL.DBO.Doctors C ON C.ID = A.Doctor_1 
            left JOIN MasterdataSQL.dbo.MstrUnitPerwatan d  on d.ID = a.Unit
            left join MasterdataSQL.dbo.JadwalPraktek e on a.ID_JadwalPraktek=e.ID
            left join MasterdataSQL.dbo.MstrPerusahaanAsuransi asu on a.Asuransi=asu.ID
            left join MasterdataSQL.dbo.MstrPerusahaanJPK jpk on a.Perusahaan=jpk.ID
            WHERE A.NoRegistrasi=:id");
            $this->db->bind('id', $data['noregistrasi']);
            $data2 =  $this->db->single();

            $passing['NoRegistrasi'] = $data2['NoRegistrasi'];
            $passing['NoMR'] = $data2['NoMR'];
            $passing['PatientName'] = $data2['PatientName'];
            $passing['NoAntrianAll'] = $data2['NoAntrianAll'];
            $passing['TglKunjungan'] = $data2['TglKunjungan'];
            $passing['dokternama'] = $data2['dokternama'];
            $passing['NamaUnit'] = $data2['NamaUnit'];
            $passing['tglfix'] = $data2['tglfix'];
            $passing['jamfix'] = $data2['jamfix'];
            $passing['JamPraktek'] = $data2['JamPraktek'];
            $passing['JamPraktekDokter'] = $data2['JamPraktekDokter'];
            $passing['NamaJaminan'] = $data2['NamaJaminan'];
            $passing['NoSEP'] = $data2['NoSEP'];
            return $passing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintLabelPasien($data)
    {
        try {
            $this->db->query("SELECT PatientName,NoMR,Gander,replace(CONVERT(VARCHAR(11), Date_of_Birth, 111), '/','-') as tgllahir,ID_Card_Number , Religion FROM MasterDataSQL.dbo.Admision where NoMR=:nomr
            union all
            SELECT PatientName,NoMR,Gander,replace(CONVERT(VARCHAR(11), Date_of_Birth, 111), '/','-') as tgllahir,ID_Card_Number , Religion FROM MasterDataSQL.dbo.Admision_walkin where NoMR=:nomr2");
            $this->db->bind('nomr', $data['notrs']);
            $this->db->bind('nomr2', $data['notrs']);
            $row =  $this->db->single();

            $passing['Gander'] = $row['Gander'];
            $passing['NoMR'] = $row['NoMR'];
            $passing['Religion'] = $row['Religion'];
            if ($row['PatientName'] == null) {
                $passing['PatientName'] = '-';
            } else {
                $passing['PatientName'] = $row['PatientName'];
            }
            $passing['tgllahir'] = date('d/m/Y', strtotime($row['tgllahir']));
            $passing['ID_Card_Number'] = $row['ID_Card_Number'];

            return $passing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    //03-04-2023 odc
    public function getDataListODCPasien()
    {
        try {
            $this->db->query("SELECT 
                DokterDPJP,JenisRawat, a.NoEpisode,a.NoRegistrasi,a.NoMR,PatientName,
                case when a.datecreate is not null then a.datecreate else replace(CONVERT(VARCHAR(11), f.[Visit Date], 111), '/','-') end as VisitDate,NamaDokter,
                case when PatientType='2' then NamaAsuransi else NamaPerusahaan end as NamaPerusahaan,f.[Status Name] as Status ,a.ID as IDSpr,null as NoSEP
                        from MedicalRecord.dbo.MR_PermintaanRawat_ODC  a
                        inner join PerawatanSQL.dbo.View_PasienAll f on a.NoRegistrasi collate Latin1_General_CI_AS=f.NoRegistrasi
                        where a.StatusRegis='0'
             ");
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['DokterDPJP'] = $key['DokterDPJP'];
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['PatientName'] = $key['PatientName'];
                $pasing['JenisRawat'] = $key['JenisRawat'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['VisitDate'] = date('d/m/Y', strtotime($key['VisitDate']));
                $pasing['NamaDokter'] = $key['NamaDokter'];
                $pasing['NamaPerusahaan'] = $key['NamaPerusahaan'];
                $pasing['Status'] = $key['Status'];
                $pasing['IDSpr'] = $key['IDSpr'];
                $pasing['NoSEP'] = $key['NoSEP'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function validatejeniskunjunganBPJS($data)
    {
        try {
            $pxNoSep = $data['pxNoSep'];
            $noreg = $data['noreg'];
            $this->db->query("SELECT NO_SPRI,KODE_ASAL_FASKES,NO_RUJUKAN
                        FROM PerawatanSQL.DBO.BPJS_T_SEP 
                        WHERE NO_SEP=:pxNoSep and NO_REGISTRASI=:noreg");
            $this->db->bind('pxNoSep', $pxNoSep); 
            $this->db->bind('noreg', $noreg); 
            $data =  $this->db->single();
          
            $NO_SPRI = $data['NO_SPRI'];
            $KODE_ASAL_FASKES = $data['KODE_ASAL_FASKES'];
            $NO_RUJUKAN = $data['NO_RUJUKAN'];

            $jeniskunjungan = '2';

                // GET TOTAL KUNJUNGAN KE
                
                $urlApi = "Rujukan/JumlahSEP/$KODE_ASAL_FASKES/$NO_RUJUKAN";
                // persiapkan curl
                $ch = curl_init();
                $tStamp = GenerateBpjs::bpjsTimestamp();
                $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
                // set url 
                curl_setopt($ch, CURLOPT_URL, URL_BPJS . $urlApi);
                // set header
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
                // set time out
                curl_setopt($ch, CURLOPT_TIMEOUT, 3);
                // ssl verifi
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                // method
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                // data yang dikirim
                //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                // return the transfer as a string 
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                // $output contains the output string 
                $output = curl_exec($ch);
                // tutup curl 
                curl_close($ch);
                // ubah string JSON menjadi array
                $JsonData = json_decode($output, TRUE);
                if ($JsonData['metaData']['code'] == "200") {
                    $EncodeData = json_encode($JsonData);
                    // $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
                    $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
                    $jumlahsep = $ResultEncriptLzString['response']['jumlahSEP'];
                    
                    if($jumlahsep < 2){
                        if($KODE_ASAL_FASKES == '1' ){ // kunjungan pertama faskes pertama
                            $jeniskunjungan = '1';
                        }elseif($KODE_ASAL_FASKES == '2' ){ // kunjungan pertama faskes kedua
                            $jeniskunjungan = '4';
                        }
                    }else{
                        if($NO_SPRI <> null ){ // sama poli dan post ranap
                            $jeniskunjungan = '3';
                        }if($NO_SPRI === null ){ // beda poli
                            $jeniskunjungan = '2';
                        } 
                    } 

                } else {
                    if($NO_SPRI <> null ){ // sama poli dan post ranap
                        $jeniskunjungan = '3';
                    }if($NO_SPRI === null ){ // beda poli
                        $jeniskunjungan = '2';
                    } 
                } 
            $callback = array(
                'status' => 'success',
                'jeniskunjungan' => $jeniskunjungan, 
                'jumlahsep' => $jumlahsep, 
            );
            return $callback;

        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}