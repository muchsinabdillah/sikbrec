<?php
class B_ListKontrolUlang_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function showKOntrolUlang($data)
    {
        try {
            $sql_details = array(
                'user' => DB_USER,
                'pass' => DB_PASSWORD,
                'db'   => DB_NAME,
                'host' => DB_HOST
            );
            $table = <<<EOT
 (SELECT A.ID, A.NOMR,B.PatientName, NoEpisode,
                        NoRegistrasi,TglKontrol,Jam,Dokter,PoliKlinik,Keterangan,NoReservasi
                        FROM MedicalRecord.DBO.MR_DaftarKontrolUlang A
                        inner join MasterdataSQL.dbo.Admision B
                        ON A.NOMR COLLATE Latin1_General_CI_AS = B.NOMR COLLATE Latin1_General_CI_AS) temp
EOT;

            // Table's primary key
            $primaryKey = 'ID';

            // Array of database columns which should be read and sent back to DataTables.
            // The `db` parameter represents the column name in the database, while the `dt`
            // parameter represents the DataTables column identifier. In this case simple
            // indexes
            $columns = array(

                array('db' => 'ID', 'dt' => 'ID'),
                array('db' => 'NoMR',  'dt' => 'NoMR'),
                array('db' => 'PatientName',     'dt' => 'PatientName'),
                array('db' => 'NoEpisode',     'dt' => 'NoEpisode'),
                array('db' => 'NoRegistrasi',   'dt' => 'NoRegistrasi'),
                array('db' => 'TglKontrol',     'dt' => 'TglKontrol'),
                array('db' => 'Jam',     'dt' => 'Jam'),
                array('db' => 'Dokter',     'dt' => 'Dokter'),
                array('db' => 'PoliKlinik',     'dt' => 'PoliKlinik'),
                array('db' => 'Keterangan',     'dt' => 'Keterangan'),
                array('db' => 'NoReservasi',     'dt' => 'NoReservasi')

            );
            // require('SSP.php');

            // echo json_encode(
            //     SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns)

            // );
            // return SP::simple($_POST, $sql_details, $table, $primaryKey, $columns); 
            return SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns);

            // return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function showKOntrolUlang_old($data)
    {
        try {
            $this->db->query("SELECT A.ID, A.NOMR,B.PatientName, NoEpisode,
                        NoRegistrasi,TglKontrol,Jam,Dokter,PoliKlinik,Keterangan,NoReservasi
                        FROM MedicalRecord.DBO.MR_DaftarKontrolUlang A
                        inner join MasterdataSQL.dbo.Admision B
                        ON A.NOMR COLLATE Latin1_General_CI_AS = B.NOMR COLLATE Latin1_General_CI_AS
                        ORDER BY 1 DESC");
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 0;
            foreach ($data as $key) {
                $no++;
                $nosep = '';
                $pasing['no'] = $no;
                $pasing['ID'] = $key['ID'];
                $pasing['NoMR'] = $key['NOMR'];
                $pasing['NoEpisode'] = $key['NoEpisode'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['PatientName'] = $key['PatientName'];
                $pasing['TglKontrol'] = date('d/m/Y', strtotime($key['TglKontrol']));
                $pasing['Jam'] = $key['Jam'];
                $pasing['Dokter'] = $key['Dokter'];
                $pasing['PoliKlinik'] = $key['PoliKlinik'];
                $pasing['Keterangan'] = $key['Keterangan'];
                $pasing['NoReservasi'] = $key['NoReservasi'];
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
    public function getDataRencanaKontrolDetail($data)
    {
        try {
            $id = $data['id'];
            $this->db->query("SELECT A.ID, A.NOMR,B.PatientName, A.NoEpisode,NoRegistrasi,
                                replace(CONVERT(VARCHAR(11),TglKontrol, 111), '/','-') as TglKontrol,Jam,Dokter,PoliKlinik,
                                Keterangan,NoReservasi,C.NoSEP
                                ,replace(CONVERT(VARCHAR(11),c.StartDate, 111), '/','-') as TglBerobat,
                                replace(CONVERT(VARCHAR(11),C.EndDate, 111), '/','-') as TglPulang
                                ,ISNULL(D.RoomName,'Room Invalid') as RoomName
                                FROM MedicalRecord.DBO.MR_DaftarKontrolUlang A
                                inner join MasterdataSQL.dbo.Admision B
                                ON A.NOMR COLLATE Latin1_General_CI_AS = B.NOMR COLLATE Latin1_General_CI_AS
                                INNER JOIN RawatInapSQL.DBO.Inpatient C
                                ON C.NoRegRI COLLATE Latin1_General_CI_AS = A.NoRegistrasi COLLATE Latin1_General_CI_AS
                                LEFT JOIN RawatInapSQL.DBO.Inpatient_in_out D
                                ON D.ID = C.RoomID_Akhir
                                where A.ID=:id");
            $this->db->bind('id', $id);
            $data =  $this->db->single();
            $pasing['ID'] = $data['ID'];
            $pasing['NoMR'] = $data['NOMR'];
            $pasing['PatientName'] = $data['PatientName'];
            $pasing['NoEpisode'] = $data['NoEpisode'];
            $pasing['NoRegistrasi'] = $data['NoRegistrasi'];
            $pasing['TglKontrol'] = $data['TglKontrol'];
            $pasing['Jam'] = $data['Jam'];
            $pasing['Dokter'] = $data['Dokter'];
            $pasing['PoliKlinik'] = $data['PoliKlinik'];
            $pasing['Keterangan'] = $data['Keterangan'];
            $pasing['NoReservasi'] = $data['NoReservasi'];
            $pasing['TglBerobat'] = $data['TglBerobat'];
            $pasing['NoSEP'] = $data['NoSEP'];
            $pasing['TglPulang'] = $data['TglPulang'];
            $pasing['RoomName'] = $data['RoomName'];
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
    public function getDataRencanaKontrolbyIDBPJS($data)
    {
        try {
            $BPJS_NoRencKontrol = $data['BPJS_NoRencKontrol'];
            // cari dulu si simrs
            $this->db->query("SELECT NO_SPR_SIMRS,NO_REGISTRASI FROM PerawatanSQL.DBO.BPJS_T_SPRI WHERE NO_SPRI=:BPJS_NoRencKontrol");
            $this->db->bind('BPJS_NoRencKontrol', $BPJS_NoRencKontrol);
            $dtspri =  $this->db->single();
            $NO_SPR_SIMRS = $dtspri['NO_SPR_SIMRS'];
            $NO_REGISTRASIx = $dtspri['NO_REGISTRASI'];
            if ($NO_SPR_SIMRS == "") {
                $this->db->query("SELECT '' ID, C.NOMR,B.PatientName, C.NoEpisode,NoRegistrasi,
                                replace(CONVERT(VARCHAR(11),a.TGL_RENCANA_KONTROL, 111), '/','-') as TglKontrol,'' Jam,E.First_Name AS Dokter, f.NamaUnit as PoliKlinik,
                                Keterangan,'' NoReservasi,C.NoSEP
                                ,replace(CONVERT(VARCHAR(11), C.TglKunjungan, 111), '/','-') as TglBerobat,
                                replace(CONVERT(VARCHAR(11),C.TglKunjungan, 111), '/','-') as TglPulang
                                ,ISNULL(D.NamaUnit,'Room Invalid') as RoomName
                                FROM PerawatanSQL.DBO.BPJS_T_SPRI A 
                                INNER JOIN PerawatanSQL.dbo.Visit C
                                ON C.NoRegistrasi COLLATE Latin1_General_CI_AS = A.NO_REGISTRASI COLLATE Latin1_General_CI_AS
								inner join MasterdataSQL.dbo.Admision B
                                ON C.NoMR COLLATE Latin1_General_CI_AS = B.NOMR COLLATE Latin1_General_CI_AS
                                LEFT JOIN MasterdataSQL.dbo.MstrUnitPerwatan D
                                ON D.ID = C.Unit
								INNER JOIN MasterdataSQL.DBO.Doctors E ON E.ID = C.Doctor_1
								inner join MasterdataSQL.dbo.MstrUnitPerwatan f on f.ID=c.Unit
                                where A.NO_SPRI=:BPJS_NoRencKontrol");
                $this->db->bind('BPJS_NoRencKontrol', $BPJS_NoRencKontrol);
                $data =  $this->db->single();
                $pasing['ID'] = $data['ID'];
                $pasing['NoMR'] = $data['NOMR'];
                $pasing['PatientName'] = $data['PatientName'];
                $pasing['NoEpisode'] = $data['NoEpisode'];
                $pasing['NoRegistrasi'] = $data['NoRegistrasi'];
                $pasing['TglKontrol'] = $data['TglKontrol'];
                $pasing['Jam'] = $data['Jam'];
                $pasing['Dokter'] = $data['Dokter'];
                $pasing['PoliKlinik'] = $data['PoliKlinik'];
                $pasing['Keterangan'] = $data['Keterangan'];
                $pasing['NoReservasi'] = $data['NoReservasi'];
                $pasing['TglBerobat'] = $data['TglBerobat'];
                $pasing['NoSEP'] = $data['NoSEP'];
                $pasing['TglPulang'] = $data['TglPulang'];
                $pasing['RoomName'] = $data['RoomName'];
                $callback = array(
                    'message' => "success", // Set array nama 
                    'data' => $pasing
                );
                return $callback;
            } else {
                $this->db->query("SELECT A.ID, A.NOMR,B.PatientName, A.NoEpisode,NoRegistrasi,
                                replace(CONVERT(VARCHAR(11),TglKontrol, 111), '/','-') as TglKontrol,Jam,Dokter,PoliKlinik,
                                Keterangan,NoReservasi,C.NoSEP
                                ,replace(CONVERT(VARCHAR(11),c.StartDate, 111), '/','-') as TglBerobat,
                                replace(CONVERT(VARCHAR(11),C.EndDate, 111), '/','-') as TglPulang
                                ,ISNULL(D.RoomName,'Room Invalid') as RoomName
                                FROM MedicalRecord.DBO.MR_DaftarKontrolUlang A
                                inner join MasterdataSQL.dbo.Admision B
                                ON A.NOMR COLLATE Latin1_General_CI_AS = B.NOMR COLLATE Latin1_General_CI_AS
                                INNER JOIN RawatInapSQL.DBO.Inpatient C
                                ON C.NoRegRI COLLATE Latin1_General_CI_AS = A.NoRegistrasi COLLATE Latin1_General_CI_AS
                                LEFT JOIN RawatInapSQL.DBO.Inpatient_in_out D
                                ON D.ID = C.RoomID_Akhir
                                where A.ID=:id");
                $this->db->bind('id', $NO_SPR_SIMRS);
                $data =  $this->db->single();
                $pasing['ID'] = $data['ID'];
                $pasing['NoMR'] = $data['NOMR'];
                $pasing['PatientName'] = $data['PatientName'];
                $pasing['NoEpisode'] = $data['NoEpisode'];
                $pasing['NoRegistrasi'] = $data['NoRegistrasi'];
                $pasing['TglKontrol'] = $data['TglKontrol'];
                $pasing['Jam'] = $data['Jam'];
                $pasing['Dokter'] = $data['Dokter'];
                $pasing['PoliKlinik'] = $data['PoliKlinik'];
                $pasing['Keterangan'] = $data['Keterangan'];
                $pasing['NoReservasi'] = $data['NoReservasi'];
                $pasing['TglBerobat'] = $data['TglBerobat'];
                $pasing['NoSEP'] = $data['NoSEP'];
                $pasing['TglPulang'] = $data['TglPulang'];
                $pasing['RoomName'] = $data['RoomName'];
                $callback = array(
                    'message' => "success", // Set array nama 
                    'data' => $pasing
                );
                return $callback;
            }
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    function CreateKontrolUlang($data)
    {
        $curl = curl_init();
        $JnsKontrol = $data['JnsKontrol'];
        $nomor = $data['nomor'];
        //   $TglRencanaKontrol = $data['TglRencanaKontrol'];
        $TglRencanaKontrol = $data['TglRencanaKontrol'];
        $KodePoliklinikBPJS = $data['KodePoliklinikBPJS'];
        $TglRegIGD = $data['TglRegIGD'];
        $NamaPoliklinikBPJS = $data['NamaPoliklinikBPJS'];
        $NamaDokterBPJS = $data['NamaDokterBPJS'];
        $SPRI_NoSPR2 = $data['SPRI_NoSPR2'];
        $jenisTrs = $data['jenisTrs'];
        $SPRI_NoSPR2BPJS = $data['SPRI_NoSPR2BPJS'];
        $SPRI_NoSEP = $data['SPRI_NoSEP'];
        $SIMRS_JENIS_SEP = $data['SIMRS_JENIS_SEP'];
        $KodeDokterBPJS = $data['KodeDokterBPJS'];
        $NO_REGISTRASI = $data['SIMRS_Registrasi'];

        //$KodeDokterBPJS = "20507";
        $session = SessionManager::getCurrentSession();
        $userid = $session->username;
        $token = $session->token;
        $namauserx = $session->name;
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);

        if ($jenisTrs == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Jenis TRS Invalid !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($SPRI_NoSEP == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'No. SEP Invalid !',
            );
            echo json_encode($callback);
            exit;
        }
        //if ($SPRI_NoSPR2 == "") {
        //     $callback = array(
        //         'status' => 'warning',
        //         'errorname' => 'No. SPR SIMRS Invalid !',
        //     );
        //     echo json_encode($callback);
        //     exit;
        // }
        if ($TglRencanaKontrol == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Tgl Rencana Kontrol Invalid !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($KodePoliklinikBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Kode Poliklinik Invalid !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($NamaPoliklinikBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Nama Poliklinik Invalid !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($KodeDokterBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Kode Dokter Invalid !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($NamaDokterBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Nama Dokter Invalid !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($jenisTrs == "Insert") {
            curl_setopt_array($curl, array(
                CURLOPT_URL =>  URL_BPJS . 'RencanaKontrol/insert',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                                        "request":
                                            {
                                                "noSEP":"' . $SPRI_NoSEP . '",
                                                "kodeDokter":"' . $KodeDokterBPJS . '",
                                                "poliKontrol":"' . $KodePoliklinikBPJS . '",
                                                "tglRencanaKontrol":"' . $TglRencanaKontrol . '",
                                                "user":"' . $namauserx . '"
                                            }
                                        }',
                CURLOPT_HTTPHEADER => $headerbpjs,
            ));
            $output = curl_exec($curl);
            // tutup curl 
            curl_close($curl);
            // ubah string JSON menjadi array
            $JsonData = json_decode($output, TRUE);
            if ($JsonData['metaData']['code'] == "200") {
                $EncodeData = json_encode($JsonData);
                $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
                $JsonDatax   = json_decode(json_encode($ResultEncriptLzString), true);
                $noSPRI = $JsonDatax['1']['noSuratKontrol'];
                $tglRencanaKontrol = $JsonDatax['1']['tglRencanaKontrol'];
                $namaDokter = $JsonDatax['1']['namaDokter'];
                $noKartu = $JsonDatax['1']['noKartu'];
                $nama = $JsonDatax['1']['nama'];
                $kelamin = $JsonDatax['1']['kelamin'];
                $tglLahir = $JsonDatax['1']['tglLahir'];
                $namaDiagnosa = $JsonDatax['1']['namaDiagnosa'];

                $TGLNOW = Utils::seCurrentDateTime();
                $this->db->query("INSERT INTO perawatanSQL.dbo.BPJS_T_SPRI 
                            (NO_SPRI,NO_SPR_SIMRS,TGL_RENCANA_KONTROL,TGL_ENTRY,
                            NAMA_PASIEN,JENIS_KELAMIN,NAMA_DIAGNOSA,NAMA_DOKTER,
                            NO_KARTU,TGL_LAHIR,USER_INPUT,TANGGAL_INPUT,TGL_REG_IGD,KODE_DOKTER,KODE_POLI,NAMA_POLI,NO_SEP,JENIS_KONTROL,JENIS_PASIEN_SEP,NO_REGISTRASI)
                            VALUES 
                            (:NO_SPRI,:NO_SPR_SIMRS,:TGL_RENCANA_KONTROL,:TGL_ENTRY,
                            :NAMA_PASIEN,:JENIS_KELAMIN,:NAMA_DIAGNOSA
                            ,:NAMA_DOKTER,:NO_KARTU
                            ,:TGL_LAHIR,:USER_INPUT,:TANGGAL_INPUT,:TGL_REG_IGD,:KODE_DOKTER,:KODE_POLI,:NAMA_POLI,:NO_SEP,:JENIS_KONTROL,:JENIS_PASIEN_SEP,:NO_REGISTRASI)");
                $this->db->bind('NO_REGISTRASI', $NO_REGISTRASI);
                $this->db->bind('JENIS_PASIEN_SEP', $SIMRS_JENIS_SEP);
                $this->db->bind('NO_SPRI', $noSPRI);
                $this->db->bind('NO_SPR_SIMRS', $SPRI_NoSPR2);
                $this->db->bind('TGL_RENCANA_KONTROL', $tglRencanaKontrol);
                $this->db->bind('TGL_ENTRY', $TGLNOW);
                $this->db->bind('NAMA_PASIEN', $nama);
                $this->db->bind('JENIS_KELAMIN', $kelamin);
                $this->db->bind('NAMA_DIAGNOSA', $namaDiagnosa);
                $this->db->bind('NAMA_DOKTER', $namaDokter);
                $this->db->bind('NO_KARTU', $noKartu);
                $this->db->bind('TGL_LAHIR', $tglLahir);
                $this->db->bind('USER_INPUT', $namauserx);
                $this->db->bind('TANGGAL_INPUT', $TGLNOW);
                $this->db->bind('TGL_REG_IGD', $TglRegIGD);
                $this->db->bind('KODE_DOKTER', $KodeDokterBPJS);
                $this->db->bind('KODE_POLI', $KodeDokterBPJS);
                $this->db->bind('KODE_POLI', $KodePoliklinikBPJS);
                $this->db->bind('NAMA_POLI', $NamaPoliklinikBPJS);
                $this->db->bind('NO_SEP', $SPRI_NoSEP);
                $this->db->bind('JENIS_KONTROL', $JnsKontrol);
                $this->db->execute();
                $callback = array(
                    'status' => 'success',
                    'hasil' => $noSPRI,
                );
                return $callback;
            } else {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => $JsonData['metaData']['message']
                );
                return $callback;
            }
        } elseif ($jenisTrs == "Update") {

            if ($SPRI_NoSPR2BPJS == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. Surat Kontrol Invalid !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($SPRI_NoSEP == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. SEP Invalid !',
                );
                echo json_encode($callback);
                exit;
            }
            curl_setopt_array($curl, array(
                CURLOPT_URL =>  URL_BPJS . 'RencanaKontrol/Update',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'PUT',
                CURLOPT_POSTFIELDS => '{
                                        "request":
                                            {
                                                "noSuratKontrol":"' . $SPRI_NoSPR2BPJS . '", 
                                                "noSEP":"' . $SPRI_NoSEP . '", 
                                                "kodeDokter":"' . $KodeDokterBPJS . '",
                                                "poliKontrol":"' . $KodePoliklinikBPJS . '",
                                                "tglRencanaKontrol":"' . $TglRencanaKontrol . '",
                                                "user":"' . $namauserx . '"
                                            }
                                        }',
                CURLOPT_HTTPHEADER => $headerbpjs,
            ));
            $output = curl_exec($curl);
            // tutup curl 
            curl_close($curl);
            // ubah string JSON menjadi array
            $JsonData = json_decode($output, TRUE);
            if ($JsonData['metaData']['code'] == "200") {
                $EncodeData = json_encode($JsonData);
                $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
                $JsonDatax   = json_decode(json_encode($ResultEncriptLzString), true);


                $this->db->query("UPDATE perawatanSQL.dbo.BPJS_T_SPRI SET
                            TGL_RENCANA_KONTROL=:TGL_RENCANA_KONTROL,NAMA_DOKTER=:NAMA_DOKTER,
                            KODE_DOKTER=:KODE_DOKTER,KODE_POLI=:KODE_POLI,NAMA_POLI=:NAMA_POLI
                            where NO_SPRI=:NO_SPRI");
                $this->db->bind('NO_SPRI', $SPRI_NoSPR2BPJS);
                $this->db->bind('TGL_RENCANA_KONTROL', $TglRencanaKontrol);
                $this->db->bind('NAMA_DOKTER', $NamaDokterBPJS);
                $this->db->bind('KODE_DOKTER', $KodeDokterBPJS);
                $this->db->bind('KODE_POLI', $KodePoliklinikBPJS);
                $this->db->bind('NAMA_POLI', $NamaPoliklinikBPJS);
                $this->db->execute();
                $callback = array(
                    'status' => 'success',
                    'hasil' => $SPRI_NoSPR2BPJS,
                );
                return $callback;
            } else {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => $JsonData['metaData']['message']
                );
                return $callback;
            }
        }
    }
    function GetRencanaKontrolbyId($data)
    {
        $BPJS_NoRencKontrol = $data['BPJS_NoRencKontrol'];
        // persiapkan curl
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS . "RencanaKontrol/noSuratKontrol/$BPJS_NoRencKontrol");
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
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            $callback = array(
                'status' => 'success',
                'hasil' => $ResultEncriptLzString['1'],
            );
            return $callback;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']

            );
            return $callback;
        }
    }

    public function getDataPasien($data)
    {
        try {
            $id = $data['id'];
            // $this->db->query("SELECT A.ID, A.NOMR,B.PatientName, A.NoEpisode,NoRegistrasi,
            //                 replace(CONVERT(VARCHAR(11),TglKontrol, 111), '/','-') as TglKontrol,Jam,Dokter,PoliKlinik,
            //                 Keterangan,NoReservasi,C.NoSEP
            //                 ,replace(CONVERT(VARCHAR(11),c.StartDate, 111), '/','-') as TglBerobat,
            //                 replace(CONVERT(VARCHAR(11),C.EndDate, 111), '/','-') as TglPulang
            //                 ,ISNULL(D.RoomName,'Room Invalid') as RoomName
            //                 FROM MedicalRecord.DBO.MR_DaftarKontrolUlang A
            //                 inner join MasterdataSQL.dbo.Admision B
            //                 ON A.NOMR COLLATE Latin1_General_CI_AS = B.NOMR COLLATE Latin1_General_CI_AS
            //                 INNER JOIN RawatInapSQL.DBO.Inpatient C
            //                 ON C.NoRegRI COLLATE Latin1_General_CI_AS = A.NoRegistrasi COLLATE Latin1_General_CI_AS
            //                 LEFT JOIN RawatInapSQL.DBO.Inpatient_in_out D
            //                 ON D.ID = C.RoomID_Akhir
            //                 where A.ID=:id");
            $this->db->query("SELECT a.NoMR,a.NoRegistrasi,a.NoEpisode,replace(CONVERT(VARCHAR(11),TglKunjungan, 111), '/','-') as TglBerobat,a.NoSEP,b.PatientName
                FROM PerawatanSQL.dbo.Visit a
                                inner join MasterDataSQL.dbo.Admision b on a.NoMR=b.NoMR
                                WHERE NoRegistrasi=:id
                                UNION ALL
                                Select  a.NoMR,a.NoRegRI as NoRegistrasi,a.NoEpisode,replace(CONVERT(VARCHAR(11),StartDate, 111), '/','-') as TglBerobat,a.NoSEP,b.PatientName
                                FROM RawatInapSQL.dbo.Inpatient a
                                inner join MasterDataSQL.dbo.Admision b on a.NoMR=b.NoMR
                                WHERE a.NoRegRI=:id2
                                ");
            $this->db->bind('id', $id);
            $this->db->bind('id2', $id);
            $data =  $this->db->single();
            $pasing['NoMR'] = $data['NoMR'];
            $pasing['PatientName'] = $data['PatientName'];
            $pasing['NoEpisode'] = $data['NoEpisode'];
            $pasing['NoRegistrasi'] = $data['NoRegistrasi'];
            //$pasing['TglKontrol'] = $data['TglKontrol'];
            //$pasing['Jam'] = $data['Jam'];
            //$pasing['Dokter'] = $data['Dokter'];
            //$pasing['PoliKlinik'] = $data['PoliKlinik'];
            //$pasing['Keterangan'] = $data['Keterangan'];
            //$pasing['NoReservasi'] = $data['NoReservasi'];
            $pasing['TglBerobat'] = $data['TglBerobat'];
            $pasing['NoSEP'] = $data['NoSEP'];
            //$pasing['TglPulang'] = $data['TglPulang'];
            //$pasing['RoomName'] = $data['RoomName']; 
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            //$this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    function CreateKontrolUlang_2($data)
    {
        $curl = curl_init();
        $JnsKontrol = $data['JnsKontrol'];
        $nomor = $data['nomor'];
        //   $TglRencanaKontrol = $data['TglRencanaKontrol'];
        $TglRencanaKontrol = $data['TglRencanaKontrol'];
        $KodePoliklinikBPJS = $data['KodePoliklinikBPJS'];
        $TglRegIGD = $data['TglRegIGD'];
        $NamaPoliklinikBPJS = $data['NamaPoliklinikBPJS'];
        $NamaDokterBPJS = $data['NamaDokterBPJS'];
        $SPRI_NoSPR2 = $data['SPRI_NoSPR2'];
        $jenisTrs = $data['jenisTrs'];
        $SPRI_NoSPR2BPJS = $data['SPRI_NoSPR2BPJS'];
        $SPRI_NoSEP = $data['SPRI_NoSEP'];
        $SIMRS_JENIS_SEP = $data['SIMRS_JENIS_SEP'];
        $KodeDokterBPJS = $data['KodeDokterBPJS'];
        $NO_REGISTRASI = $data['SIMRS_Registrasi'];

        //GET ID DAN NAMA DOKTER BPJS
        $this->db->query("SELECT ID_Dokter_BPJS,NAMA_Dokter_BPJS FROM MasterDataSQL.dbo.Doctors WHERE ID=:id");
        $this->db->bind('id', $KodeDokterBPJS);
        $datas =  $this->db->single();
        $KodeDokterBPJS = $datas['ID_Dokter_BPJS'];
        $NamaDokterBPJS = $datas['NAMA_Dokter_BPJS'];

        //GET ID DAN NAMA POLI BPJS
        $this->db->query("SELECT codeBPJS,NamaBPJS FROM MasterDataSQL.dbo.MstrUnitPerwatan WHERE ID=:id");
        $this->db->bind('id', $KodePoliklinikBPJS);
        $datas2 =  $this->db->single();
        $KodePoliklinikBPJS = $datas2['codeBPJS'];
        $NamaPoliklinikBPJS = $datas2['NamaBPJS'];


        //GET ID DAN NAMA POLI BPJS
        $this->db->query("SELECT replace(CONVERT(VARCHAR(11),TglKunjungan, 111), '/','-') as TglMasuk 
        FROM PerawatanSQL.dbo.Visit 
        WHERE NoRegistrasi=:NO_REGISTRASI
        UNION ALL
        SELECT replace(CONVERT(VARCHAR(11),StartDate, 111), '/','-') as TglMasuk 
        FROM RawatInapSQL.dbo.Inpatient
        WHERE NoRegRI=:NO_REGISTRASI2
        ");
        $this->db->bind('NO_REGISTRASI', $NO_REGISTRASI);
        $this->db->bind('NO_REGISTRASI2', $NO_REGISTRASI);
        $datas3 =  $this->db->single();
        $TglRegIGD = $datas3['TglMasuk'];


        //$KodeDokterBPJS = "20507";
        // $session = SessionManager::getCurrentSession();
        // $userid = $session->username;
        // $token = $session->token;
        //$namauserx = $session->name;
        $namauserx = 'Administrator';
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);

        if ($jenisTrs == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Jenis TRS Invalid !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($SPRI_NoSEP == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'No. SEP Invalid !',
            );
            echo json_encode($callback);
            exit;
        }
        //if ($SPRI_NoSPR2 == "") {
        //     $callback = array(
        //         'status' => 'warning',
        //         'errorname' => 'No. SPR SIMRS Invalid !',
        //     );
        //     echo json_encode($callback);
        //     exit;
        // }
        if ($TglRencanaKontrol == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Tgl Rencana Kontrol Invalid !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($KodePoliklinikBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Kode Poliklinik Invalid !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($NamaPoliklinikBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Nama Poliklinik Invalid !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($KodeDokterBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Kode Dokter Invalid !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($NamaDokterBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Nama Dokter Invalid !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($jenisTrs == "Insert") {
            curl_setopt_array($curl, array(
                CURLOPT_URL =>  URL_BPJS . 'RencanaKontrol/insert',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                                        "request":
                                            {
                                                "noSEP":"' . $SPRI_NoSEP . '",
                                                "kodeDokter":"' . $KodeDokterBPJS . '",
                                                "poliKontrol":"' . $KodePoliklinikBPJS . '",
                                                "tglRencanaKontrol":"' . $TglRencanaKontrol . '",
                                                "user":"' . $namauserx . '"
                                            }
                                        }',
                CURLOPT_HTTPHEADER => $headerbpjs,
            ));
            $output = curl_exec($curl);
            // tutup curl 
            curl_close($curl);
            // ubah string JSON menjadi array
            $JsonData = json_decode($output, TRUE);
            if ($JsonData['metaData']['code'] == "200") {
                $EncodeData = json_encode($JsonData);
                $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
                $JsonDatax   = json_decode(json_encode($ResultEncriptLzString), true);
                $noSPRI = $JsonDatax['1']['noSuratKontrol'];
                $tglRencanaKontrol = $JsonDatax['1']['tglRencanaKontrol'];
                $namaDokter = $JsonDatax['1']['namaDokter'];
                $noKartu = $JsonDatax['1']['noKartu'];
                $nama = $JsonDatax['1']['nama'];
                $kelamin = $JsonDatax['1']['kelamin'];
                $tglLahir = $JsonDatax['1']['tglLahir'];
                $namaDiagnosa = $JsonDatax['1']['namaDiagnosa'];

                $TGLNOW = Utils::seCurrentDateTime();
                $this->db->query("INSERT INTO perawatanSQL.dbo.BPJS_T_SPRI 
                            (NO_SPRI,NO_SPR_SIMRS,TGL_RENCANA_KONTROL,TGL_ENTRY,
                            NAMA_PASIEN,JENIS_KELAMIN,NAMA_DIAGNOSA,NAMA_DOKTER,
                            NO_KARTU,TGL_LAHIR,USER_INPUT,TANGGAL_INPUT,TGL_REG_IGD,KODE_DOKTER,KODE_POLI,NAMA_POLI,NO_SEP,JENIS_KONTROL,JENIS_PASIEN_SEP,NO_REGISTRASI)
                            VALUES 
                            (:NO_SPRI,:NO_SPR_SIMRS,:TGL_RENCANA_KONTROL,:TGL_ENTRY,
                            :NAMA_PASIEN,:JENIS_KELAMIN,:NAMA_DIAGNOSA
                            ,:NAMA_DOKTER,:NO_KARTU
                            ,:TGL_LAHIR,:USER_INPUT,:TANGGAL_INPUT,:TGL_REG_IGD,:KODE_DOKTER,:KODE_POLI,:NAMA_POLI,:NO_SEP,:JENIS_KONTROL,:JENIS_PASIEN_SEP,:NO_REGISTRASI)");
                $this->db->bind('NO_REGISTRASI', $NO_REGISTRASI);
                $this->db->bind('JENIS_PASIEN_SEP', $SIMRS_JENIS_SEP);
                $this->db->bind('NO_SPRI', $noSPRI);
                $this->db->bind('NO_SPR_SIMRS', $SPRI_NoSPR2);
                $this->db->bind('TGL_RENCANA_KONTROL', $tglRencanaKontrol);
                $this->db->bind('TGL_ENTRY', $TGLNOW);
                $this->db->bind('NAMA_PASIEN', $nama);
                $this->db->bind('JENIS_KELAMIN', $kelamin);
                $this->db->bind('NAMA_DIAGNOSA', $namaDiagnosa);
                $this->db->bind('NAMA_DOKTER', $namaDokter);
                $this->db->bind('NO_KARTU', $noKartu);
                $this->db->bind('TGL_LAHIR', $tglLahir);
                $this->db->bind('USER_INPUT', $namauserx);
                $this->db->bind('TANGGAL_INPUT', $TGLNOW);
                $this->db->bind('TGL_REG_IGD', $TglRegIGD);
                $this->db->bind('KODE_DOKTER', $KodeDokterBPJS);
                $this->db->bind('KODE_POLI', $KodeDokterBPJS);
                $this->db->bind('KODE_POLI', $KodePoliklinikBPJS);
                $this->db->bind('NAMA_POLI', $NamaPoliklinikBPJS);
                $this->db->bind('NO_SEP', $SPRI_NoSEP);
                $this->db->bind('JENIS_KONTROL', $JnsKontrol);
                $this->db->execute();
                $callback = array(
                    'status' => 'success',
                    'hasil' => $noSPRI,
                );
                return $callback;
            } else {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => $JsonData['metaData']['message']
                );
                return $callback;
            }
        }
    }


    public function ShowSuratKeteranganKontrolJKN($data)
    {
        // $id = $data['id'];
        // var_dump('okeee', $data['noRegistrasi']);
        // exit;

        $data = $data['noRegistrasi'];

        try {

            $this->db->query("SELECT * from PerawatanSQL.dbo.Rencana_kontrol_JKN WHERE NoRegistrasi=:id");
            $this->db->bind('id', $data);
            $data =  $this->db->single();
            $pasing['ID'] = $data['ID'];
            $pasing['NoMR'] = $data['NoMR'];
            $pasing['NoRegistrasi'] = $data['NoRegistrasi'];
            $pasing['NoEpisode'] = $data['NoEpisode'];
            $pasing['NamaPasien'] = $data['NamaPasien'];
            $pasing['NoSEP'] = $data['NoSEP'];
            $pasing['Tgl_SuratRujukan'] = $data['Tgl_SuratRujukan'];
            $pasing['Diagnosa'] = $data['Diagnosa'];
            $pasing['Terapi'] = $data['Terapi'];
            $pasing['is_belum_kembali'] = $data['is_belum_kembali'];
            $pasing['Tindak_Lanjut'] = $data['Tindak_Lanjut'];
            $pasing['is_konsul_selesai'] = $data['is_konsul_selesai'];
            $pasing['datecreate'] = $data['datecreate'];
            $pasing['sign_dokter'] = $data['sign_dokter'];
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
            // var_dump($callback);
            // exit;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }


    public function ShowTableKeteranganKontrolJKN($data)
    {
        // $id = $data['idheader'];
        // var_dump('okeee', $data['idheader']);
        // exit;

        try {

            $this->db->query("SELECT * from PerawatanSQL.dbo.Rencana_kontrol_JKN_2 WHERE ID_HDR=:id");
            $this->db->bind('id', $data['idheader']);
            // $data =  $this->db->single();
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();

            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                // $pasing['ID_HDR'] = $key['ID_HDR'];
                $pasing['Tgl_Kontrol'] = $key['Tgl_Kontrol'];
                $pasing['Poli'] = $key['Poli'];
                $pasing['Keterangan'] = $key['Keterangan'];
                $rows[] = $pasing;
            }

            return $rows;

            // $callback = array(
            //     'message' => "success", // Set array nama 
            //     'data' => $rows
            // );
            // return $callback;
            // var_dump($callback);
            // exit;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataCetakBuktiPelayananBPJS($data)
    {
        try {
            $noregistrasi = $data['id'];
            $this->db->query("SELECT a.*,c.NamaUnit 
                FROM PerawatanSQL.dbo.Bukti_Pelayanan_JKN a
                inner join PerawatanSQL.dbo.Visit b on a.NoRegistrasi=b.NoRegistrasi
                inner join MasterDataSQL.dbo.MstrUnitPerwatan c on b.Unit=c.ID
                 where a.NoRegistrasi=:noregistrasi and a.Batal='0' ");
            $this->db->bind('noregistrasi', $noregistrasi);
            $data =  $this->db->single();
            $pasing['ID'] = $data['ID'];
            $pasing['NoMR'] = $data['NoMR'];
            $pasing['NoRegistrasi'] = $data['NoRegistrasi'];
            $pasing['NoEpisode'] = $data['NoEpisode'];
            $pasing['NoSEP'] = $data['NoSEP'];
            $pasing['NamaPasien'] = $data['NamaPasien'];
            $pasing['TglKunjungan'] = $data['TglKunjungan'];
            $pasing['Tgl_Lahir'] = $data['Tgl_Lahir'];
            $pasing['IdDokter'] = $data['IdDokter'];
            $pasing['NamaDokter'] = $data['NamaDokter'];
            $pasing['Diagnosa'] = $data['Diagnosa'];
            $pasing['Tindakan'] = $data['Tindakan'];
            $pasing['Batal'] = $data['Batal'];
            $pasing['PetugasBatal'] = $data['PetugasBatal'];
            $pasing['TglBatal'] = $data['TglBatal'];
            $pasing['TindakLanjut'] = $data['TindakLanjut'];
            $pasing['Pasien_Sign'] = $data['Pasien_Sign'];
            $pasing['Dokter_Sign'] = $data['Dokter_Sign'];
            $pasing['datecreate'] = $data['datecreate'];
            $pasing['NamaUnit'] = $data['NamaUnit'];
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            //$this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function getDataSuketKontrolPasien($data)
    {
        try {
            $noregistrasi = $data['id'];
            $this->db->query("SELECT * FROM PerawatanSQL.dbo.Rencana_kontrol_JKN
                 where NoRegistrasi=:noregistrasi ");
            $this->db->bind('noregistrasi', $noregistrasi);
            $data =  $this->db->single();
            $pasing['ID'] = $data['ID'];
            $pasing['NoMR'] = $data['NoMR'];
            $pasing['NoRegistrasi'] = $data['NoRegistrasi'];
            $pasing['NoEpisode'] = $data['NoEpisode'];
            $pasing['NamaPasien'] = $data['NamaPasien'];
            $pasing['NoSEP'] = $data['NoSEP'];
            $pasing['Tgl_SuratRujukan'] = $data['Tgl_SuratRujukan'];
            $pasing['Diagnosa'] = $data['Diagnosa'];
            $pasing['Terapi'] = $data['Terapi'];
            $pasing['is_belum_kembali'] = $data['is_belum_kembali'];
            $pasing['Tindak_Lanjut'] = $data['Tindak_Lanjut'];
            $pasing['is_konsul_selesai'] = $data['is_konsul_selesai'];
            $pasing['datecreate'] = $data['datecreate'];
            $pasing['sign_dokter'] = $data['sign_dokter'];
            $pasing['DPJP'] = $data['DPJP'];
            $pasing['PRB'] = $data['PRB'];
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            //$this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function getDataSuketKontrolPasienDtl($data)
    {
        try {

            $query = "SELECT * FROM PerawatanSQL.dbo.Rencana_kontrol_JKN_2
                where ID_HDR=:notrs ";

            $this->db->query($query);
            $this->db->bind('notrs', $data['listdata']['data']['ID']);
            $datas =  $this->db->resultSet();

            $rows = array();
            $no = 1;
            foreach ($datas as $key) {
                $pasing['No'] = $no++;
                $pasing['Tgl_Kontrol'] = $key['Tgl_Kontrol'];
                $pasing['Poli'] = $key['Poli'];
                $pasing['Keterangan'] = $key['Keterangan'];
                $rows[] = $pasing;
            }

            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
