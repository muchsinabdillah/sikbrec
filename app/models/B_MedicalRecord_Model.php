<?php

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface; 
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;

class B_MedicalRecord_Model
{

    use SatuSehat;
    use SatuSehatPatient;
    use RsyarsiWebsite;
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function getStatusHubunganKeluarga()
    {
        try {
            $uuid = Uuid::uuid4();
            $this->db->query("SELECT CONTACT_STATUS
            from MasterdataSQL.dbo.MstrCONTACT_STATUS");
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['CONTACT_STATUS'] = $key['CONTACT_STATUS'];
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
    public function GetMedicalRecordbyId($data)
    {
        try {
            $idMr = $data['q'];
            $tabel = "MasterDataSQL.dbo.Admision";
            if (isset($_POST['iswalkin'])) {
                $iswalkin = $data['iswalkin'];
                if ($iswalkin == 'WALKIN') {
                    $tabel = "MasterDataSQL.dbo.Admision_walkin";
                }
            }


            $this->db->query("SELECT replace(CONVERT(VARCHAR(11), a.Date_of_birth, 111), '/','-') as Date_of_birthx,
                            a.NoMR,a.PatientName,a.Address  as almt,a.Gander,a.BirthPlace,a.Ocupation,
                            case when Gander='L' then 'LAKI-LAKI' when Gander='P' then 'PEREMPUAN'  END AS NamaGander,
                            ID_Card_number,[Country/Region] as warganegaara,[State/Province] as provinsi,a.[Home Phone] as notlprumah,
                            a.[Mobile Phone] as mobile,a.[E-mail Address] as email,Mother,[ZIP/Postal Code] as kodepos,NoMR_IBU,
                            Contact_Name,CONTACT_PHONE,Contact_Address,CONTACT_STATUS,
                            Office_Name,Office_Address,Office_Fax,Office_Phone,c.[First Name] as PetugasUpdate,UpdateDate,InputDate,
                            b.[First Name] as PetugasInput ,a.idMrkemkes,*
                            from $tabel a 
                            left join MasterdataSQL.dbo.Employees b on a.Petugas_Input = b.NoPIN
                            left join MasterdataSQL.dbo.Employees c on a.Petugas_Update = c.NoPIN where NoMR=:idMr");
            $this->db->bind('idMr', $idMr);
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success', // Set array status dengan success
                'ID' => $data['ID'], // Set array status dengan success
                'NoMR' => $data['NoMR'], // Set array status dengan success
                'PatientName' => $data['PatientName'], // Set array status dengan success
                'ID_Card_number' => $data['ID_Card_number'], // Set array status dengan success
                'NoPesertaBPJS' => $data['NoPesertaBPJS'], // Set array status dengan success
                'Gander' => $data['Gander'], // Set array status dengan success
                'Date_of_birth' => $data['Date_of_birthx'], // Set array status dengan successDate_of_birth
                'Address' => $data['almt'], // Set array status dengan successDate_of_birth
                'NamaGander' => $data['NamaGander'], // Set array status dengan successDate_of_birth
                'BirthPlace' => $data['BirthPlace'], // Set array status dengan successDate_of_birth
                'Bahasa' => $data['Bahasa'], // Set array status dengan successDate_of_birth
                'Tipe_Idcard' => $data['Tipe_Idcard'], // Set array status dengan successDate_of_birth
                'Etnis' => $data['Etnis'], // Set array status dengan successDate_of_birth
                'Medical_Provinsi' => $data['provinsi'], // Set array status dengan successDate_of_birth
                'Medrec_kabupaten' => $data['City'], // Set array status dengan successDate_of_birth
                'Medrec_Kecamatan' => $data['Kecamatan'], // Set array status dengan successDate_of_birth
                'Medrec_Kelurahan' => $data['Kelurahan'], // Set array status dengan successDate_of_birth
                'Medrec_Warganegara' => $data['warganegaara'], // Set array status dengan successDate_of_birth
                'Medrec_handphone' => $data['mobile'], // Set array status dengan successDate_of_birth
                'Medrec_HomePhone' => $data['notlprumah'], // Set array status dengan successDate_of_birth
                'Medical_Agama' => $data['Religion'], // Set array status dengan successDate_of_birth
                'Medrec_statusNikah' => $data['Marital_status'], // Set array status dengan successDate_of_birth
                'Medrec_Pendidikan' => $data['Education'], // Set array status dengan successDate_of_birth
                'Medrec_Email' => $data['email'], // Set array status dengan successDate_of_birth
                'Medrec_Status' => $data['Aktif'], // Set array status dengan successDate_of_birth
                'Ocupation' => $data['Ocupation'], // Set array status dengan successDate_of_birth
                'Mother' => $data['Mother'], // Set array status dengan successDate_of_birth
                'kodepos' => $data['kodepos'], // Set array status dengan successDate_of_birth
                'NoMR_IBU' => $data['NoMR_IBU'], // Set array status dengan successDate_of_birth
                'Contact_Name' => $data['Contact_Name'], // Set array status dengan successDate_of_birth
                'CONTACT_PHONE' => $data['CONTACT_PHONE'], // Set array status dengan successDate_of_birth
                'Contact_Address' => $data['Contact_Address'], // Set array status dengan successDate_of_birth
                'CONTACT_STATUS' => $data['CONTACT_STATUS'], // Set array status dengan successDate_of_birth
                'Office_Name' => $data['Office_Name'], // Set array status dengan successDate_of_birth
                'Office_Address' => $data['Office_Address'], // Set array status dengan successDate_of_birth
                'Office_Fax' => $data['Office_Fax'], // Set array status dengan successDate_of_birth
                'Office_Phone' => $data['Office_Phone'], // Set array status dengan successDate_of_birth
                'Petugas_Update' => $data['PetugasUpdate'], // Set array status dengan successDate_of_birth
                'UpdateDate' => $data['UpdateDate'], // Set array status dengan successDate_of_birth
                'petugasinput' => $data['PetugasInput'], // Set array status dengan successDate_of_birth
                'jaminput' => $data['InputDate'], // Set array status dengan successDate_of_birth
                'Father' => $data['Father'], // Set array status dengan successDate_of_birth
                'idMrkemkes' => $data['idMrkemkes'], // Set array status dengan successDate_of_birth
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
    public function GetMedicalRecordbyQRCode($data)
    {
        try {
            $idMr = $data['q'];
            $tabel = "MasterDataSQL.dbo.Admision";
            if (isset($_POST['iswalkin'])) {
                $iswalkin = $data['iswalkin'];
                if ($iswalkin == 'WALKIN') {
                    $tabel = "MasterDataSQL.dbo.Admision_walkin";
                }
            }

            $this->db->query("SELECT ID,NoPesertaBPJS ,Nik as NiK_PegawaiRS,Status_Nik,replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as Date_of_birthx,
            NoMR,PatientName,Address,Gander,BirthPlace,Ocupation,
            case when Gander='L' then 'LAKI-LAKI' when Gander='P' then 'PEREMPUAN'  END AS NamaGander,
            ID_Card_number
            from $tabel where NoMR=:idMr");
            $this->db->bind('idMr', $idMr);
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success', // Set array status dengan success
                'ID' => $data['ID'], // Set array status dengan success
                'NoMR' => $data['NoMR'], // Set array status dengan success
                'PatientName' => $data['PatientName'], // Set array status dengan success
                'ID_Card_number' => $data['ID_Card_number'], // Set array status dengan success
                'NoPesertaBPJS' => $data['NoPesertaBPJS'], // Set array status dengan success
                'Gander' => $data['Gander'], // Set array status dengan success
                'Date_of_birth' => $data['Date_of_birthx'], // Set array status dengan successDate_of_birth
                'Address' => $data['Address'], // Set array status dengan successDate_of_birth
                'NamaGander' => $data['NamaGander'], // Set array status dengan successDate_of_birth
                'BirthPlace' => $data['BirthPlace'], // Set array status dengan successDate_of_birth
                'Ocupation' => $data['Ocupation'], // Set array status dengan successDate_of_birth
                'NiK_PegawaiRS' => $data['NiK_PegawaiRS'], // Set array status dengan successDate_of_birth
                'Status_Nik' => $data['Status_Nik'],
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
    public function getProvinsi()
    {
        try {

            $this->db->query("SELECT ID,ProvinsiNama,PovinsiID from MasterdataSQL.dbo.MstrProvinsi");
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['ProvinsiNama'] = $key['ProvinsiNama'];
                $pasing['PovinsiID'] = $key['PovinsiID'];
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
    public function GetKabupaten($data)
    {
        try {
            $idProvinsi = $data['q'];
            $this->db->query("SELECT kabupatenId,kabupatenNama from MasterdataSQL.dbo.MstrKabupaten 
                             where  provinsiId=:idProvinsi");
            $this->db->bind('idProvinsi', $idProvinsi);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['kabupatenNama'] = $key['kabupatenNama'];
                $pasing['kabupatenId'] = $key['kabupatenId'];
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
    public function GetKecamatan($data)
    {
        try {
            $idKabupaten = $data['q'];
            $this->db->query("SELECT kecamatanId,Kecamatan  from MasterdataSQL.dbo.mstrKecamatan  
                            where kabupatenId =:idKabupaten");
            $this->db->bind('idKabupaten', $idKabupaten);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['Kecamatan'] = $key['Kecamatan'];
                $pasing['kecamatanId'] = $key['kecamatanId'];
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
    public function GetKelurahan($data)
    {
        try {
            $idkecamatan = $data['q'];
            $this->db->query("SELECT desaId,kecamatanId,Kelurahan,kodepos
                            from MasterdataSQL.dbo.mstrKelurahan  where kecamatanId=:idkecamatan");
            $this->db->bind('idkecamatan', $idkecamatan);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['Kelurahan'] = $key['Kelurahan'];
                $pasing['desaId'] = $key['desaId'];
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
    public function GetKodepos($data)
    {
        try {
            $idKelurahan = $data['q'];
            $this->db->query("SELECT kodepos,desaId
            from MasterdataSQL.dbo.mstrKelurahan  where desaId=:idKelurahan");
            $this->db->bind('idKelurahan', $idKelurahan);
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success',
                'kodepos' => $data['kodepos'],
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
    public function getArsipRawatJalan($data)
    {
        try {
            $idMr = $data['myKey'];
            // $this->db->query("SELECT *,
            // case when PatientType='2' then NamaAsuransi
            //  when PatientType='5' then NamaPerusahaan else 'UMUM' end as namapenjamin,dd.A_Diagnosa
            //                 from  PerawatanSQL.dbo.View_ArsipPasien a
            //                 outer apply (
            //                     SELECT TOP 1 A_Diagnosa from MedicalRecord.dbo.EMR_RWJ 
            //                     where NoRegistrasi collate Latin1_General_CS_AS=a.NoRegistrasi collate Latin1_General_CS_AS
            //                 )dd
            //                 where NoMR=:idMr
			// 				order by [Visit Date] desc");
            $this->db->query("SELECT a.NoMR,a.NoRegistrasi,a.[Visit Date],b.NamaUnit,b.NamaDokter,f.TipePasien,'Close' as [Status Name],
            NamaJaminan as namapenjamin,b.Diagnosa_Awal as A_Diagnosa
            from  PerawatanSQL.dbo.Visit a
            inner join DashboardData.dbo.dataRWJ b on a.NoRegistrasi=b.NoRegistrasi
            inner join PerawatanSQL.dbo.T_TipePasien f on a.PatientType=f.ID
            where a.NoMR=:idMr and a.Batal='0' and a.[Status ID]='4'
            order by [Visit Date] desc");
            $this->db->bind('idMr', $idMr);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                // $noregistrasi = $key['NoRegistrasi'];
                // $this->db->query("SELECT TOP 1 A_Diagnosa from MedicalRecord.dbo.EMR_RWJ 
                //                 where NoRegistrasi=:noregistrasi");
                // $this->db->bind('noregistrasi', $noregistrasi);
                // $dataD =  $this->db->single();
                //$diagnosa = $dataD['A_Diagnosa'];

                $diagnosa = $key['A_Diagnosa'];

                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['TglKunjungan'] = date('d/m/Y', strtotime($key['Visit Date']));
                $pasing['NamaUnit'] = $key['NamaUnit'];
                $pasing['NamaDokter'] = $key['NamaDokter'];
                $pasing['TipePasien'] = $key['TipePasien'];
                $pasing['StatusName'] = $key['Status Name'];
                $pasing['namapenjamin'] = $key['namapenjamin'];
                $pasing['diagnosa'] = $diagnosa;
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getArsipRawatInap($data)
    {
        try {
            $idMr = $data['myKey'];
            $this->db->query("SELECT *,b.NamaKelas,case when a.TypePatient='2' then Asuransi when a.TypePatient='5' then JPK else 'UMUM' end as namapenjamin
                                      from  RawatInapSQL.dbo.View_ArsipPasien a 
                                      left join RawatInapSQL.dbo.TblKelas b on a.KlsID=b.IDkelas
                                      where NoMR=:idMr
                                      order by StartDate desc");
            $this->db->bind('idMr', $idMr);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['NoRegRI'] = $key['NoRegRI'];
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['PatientName'] = $key['PatientName'];
                $pasing['StartDate'] = date('d/m/Y', strtotime($key['StartDate']));
                $pasing['EndDate'] = date('d/m/Y', strtotime($key['EndDate']));
                $pasing['NamaDokter'] = $key['NamaDokter'];
                $pasing['JenisPasien'] = $key['JenisPasien'];
                $pasing['NamaKelas'] = $key['NamaKelas'];
                $pasing['namapenjamin'] = $key['namapenjamin'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function CreateMedicalRecord($data)
    {
        $Medrec_NoMR = $data['Medrec_NoMR'];
        $Medrec_IdPengenal = $data['Medrec_IdPengenal'];
        $Medrec_NamaPasien = strtoupper($data['Medrec_NamaPasien']);
        $Medrec_Bin = strtoupper($data['Medrec_Bin']);
        $Medrec_Alamat = strtoupper($data['Medrec_Alamat']);
        $Medrec_NoIdPengenal = $data['Medrec_NoIdPengenal'];
        $Medical_JKel = $data['Medical_JKel'];
        $Medical_Agama = $data['Medical_Agama'];
        $Medical_Provinsi = $data['Medical_Provinsi'];
        $Medrec_Warganegara = $data['Medrec_Warganegara'];
        if (isset($_POST['Medrec_kabupaten'])) {
            $Medrec_kabupaten = $data['Medrec_kabupaten'];
        }
        $Medrec_Tpt_lahir = strtoupper($data['Medrec_Tpt_lahir']);
        if (isset($_POST['Medrec_Kecamatan'])) {
            $Medrec_Kecamatan = $data['Medrec_Kecamatan'];
        }
        $Medrec_Tgl_Lahir = $data['Medrec_Tgl_Lahir'];
        if (isset($_POST['Medrec_Kelurahan'])) {
            $Medrec_Kelurahan = $data['Medrec_Kelurahan'];
        }
        $Medrec_statusNikah = $data['Medrec_statusNikah'];
        $Medrec_HomePhone = $data['Medrec_HomePhone'];
        $Medrec_handphone = $data['Medrec_handphone'];
        $Medrec_Pendidikan = $data['Medrec_Pendidikan'];
        $Medrec_Pekerjaan = $data['Medrec_Pekerjaan'];
        $Medrec_Email = $data['Medrec_Email'];
        $statusmr = $data['statusmr'];
        $Medrec_PerusahaanNama = strtoupper($data['Medrec_PerusahaanNama']);
        $Medrec_PerusahaanAlamat = strtoupper($data['Medrec_PerusahaanAlamat']);
        $Medrec_PerusahaanTlp = $data['Medrec_PerusahaanTlp'];
        $Medrec_PerusahaanFax = $data['Medrec_PerusahaanFax'];
        $Medrec_DaruratNama = strtoupper($data['Medrec_DaruratNama']);
        $Medrec_DaruratAlamat = strtoupper($data['Medrec_DaruratAlamat']);
        $Medrec_DaruratTlp = $data['Medrec_DaruratTlp'];
        $Medrec_DaruratHub = $data['Medrec_DaruratHub'];
        $Medrec_Ibu_Kandung = $data['Medrec_Ibu_Kandung'];
        $Medrec_Etnis = $data['Medrec_Etnis'];
        $Medrec_Bahasa = $data['Medrec_Bahasa'];
        $Medrec_NamaIbuKandung = strtoupper($data['Medrec_NamaIbuKandung']);
        $Medrec_Status = $data['Medrec_Status'];
        $Medrec_Kodepos = $data['Medrec_Kodepos'];
        // RADIOLOGI
        if ($Medical_JKel == "P") {
            $Medical_JKel_R = "F";
        } elseif ($Medical_JKel == "L") {
            $Medical_JKel_R = "M";
        }
        $datenowcreate = Utils::seCurrentDateTime();
        $DOB = date('Ymd', strtotime($Medrec_Tgl_Lahir));
        $TRIGGER_DTTM = Utils::idtrsByDatetime();

        $session = SessionManager::getCurrentSession();
        $userid = $session->username;
        $token = $session->token;
        $namauserx = $session->name;
        $operator =  $session->IDEmployee;

        $jenisSimpan = $_GET['q'];
        // TRIGER SEBELUM SIMPAN DATA
        // 1. TRIGER PASIEN JIKA JENIS BELUM DIISI  
        if ($Medrec_Tgl_Lahir == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Isi Tgl Lahir Pasien !',

            );
            echo json_encode($callback);
            exit;
        }
        if ($Medrec_NamaPasien == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Isi Nama Pasien Pasien !',
            );
            echo json_encode($callback);
            exit;
        }
        // 1. TRIGER PASIEN JIKA NO. MR KOSONG  
        if ($Medrec_IdPengenal == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Isi Id Pengenal Pasien !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($Medrec_NoIdPengenal == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Isi No. Id Pengenal Pasien !',
            );
            echo json_encode($callback);
            exit;
        }

        if ($Medrec_IdPengenal == 'KTP') {
            $count_idpengenal = strlen($Medrec_NoIdPengenal);
            if ($count_idpengenal != 16) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Nomor Identitas Harus 16 Digit !',
                );
                echo json_encode($callback);
                exit;
            }

            if ($Medrec_NoIdPengenal == '0000000000000000') {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Nomor Identitas Tidak Benar !',
                );
                echo json_encode($callback);
                exit;
            }
        }

        if ($Medrec_Alamat == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Isi Alamat Pasien !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($Medical_JKel == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Isi Jenis Kelamin Pasien !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($Medical_Agama == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Isi Agama Pasien !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($Medical_Provinsi == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Isi Provinsi Pasien !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($Medrec_Warganegara == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Isi Warga Negara Pasien !',
            );
            echo json_encode($callback);
            exit;
        }

        if ($Medrec_kabupaten == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Isi Kab/Kodya Pasien !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($Medrec_Kecamatan == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Isi Kecamatan Pasien !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($Medrec_Kelurahan == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Isi Kelurahan Pasien !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($Medrec_statusNikah == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Isi Status Nikah Pasien !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($Medrec_handphone == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Isi No. Handphone Pasien !',
            );
            echo json_encode($callback);
            exit;
        }

        if ($Medrec_Pendidikan == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Isi Pendidikan Pasien !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($Medrec_Pekerjaan == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Isi Pekerjaan Pasien !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($Medrec_NamaIbuKandung == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Isi Nama Ibu Kandung Pasien !',
            );
            echo json_encode($callback);
            exit;
        }

        // if ($Medrec_PerusahaanNama=="" ){
        //     $callback = array(    
        //         'status' => 'warning',
        //         'errorname' => 'Silahkan Isi Nama Perusahaan Di Data Pekerjaan !', 
        //    );
        //       echo json_encode($callback); 
        //      exit;
        //   }

        //   if ($Medrec_PerusahaanAlamat=="" ){
        //     $callback = array(    
        //         'status' => 'warning',
        //         'errorname' => 'Silahkan Isi Alamat Perusahaan Di Data Pekerjaan !', 
        //    );
        //       echo json_encode($callback); 
        //      exit;
        //   }

        //   if ($Medrec_PerusahaanTlp=="" ){
        //     $callback = array(    
        //         'status' => 'warning',
        //         'errorname' => 'Silahkan Isi Telepon Perusahaan Di Data Pekerjaan !', 
        //    );
        //       echo json_encode($callback); 
        //      exit;
        //   }

        //   if ($Medrec_PerusahaanFax=="" ){
        //     $callback = array(    
        //         'status' => 'warning',
        //         'errorname' => 'Silahkan Isi Fax Perusahaan Di Data Pekerjaan !', 
        //    );
        //       echo json_encode($callback); 
        //      exit;
        //   }

        // if ($Medrec_DaruratNama=="" ){
        //   $callback = array(    
        //       'status' => 'warning',
        //       'errorname' => 'Silahkan Isi Nama Darurat Keluarga Pasien !', 
        //   );
        //       echo json_encode($callback); 
        //      exit;
        // }
        // if ($Medrec_DaruratAlamat=="" ){
        //  $callback = array(    
        //      'status' => 'warning',
        //      'errorname' => 'Silahkan Isi Alamat Darurat Keluarga Pasien !', 
        //  );
        //      echo json_encode($callback); 
        //     exit;
        // }
        // if ($Medrec_DaruratTlp=="" ){
        //    $callback = array(    
        //        'status' => 'warning',
        //        'errorname' => 'Silahkan Isi No. Tlp Darurat Keluarga Pasien !', 
        //    );
        //        echo json_encode($callback); 
        //        exit;
        // }
        // if ($Medrec_DaruratHub=="" ){
        //    $callback = array(    
        //        'status' => 'warning',
        //        'errorname' => 'Silahkan Isi Hubungan Darurat Keluarga Pasien !', 
        //    );
        //        echo json_encode($callback); 
        //        exit;
        // }

        //GET NAMA ALAMAT
        // $query_nm_alamat = "SELECT Kelurahan,Kecamatan,kabupatenNama,ProvinsiNama FROM MasterdataSQL.dbo.mstrKelurahan a
        // inner join MasterdataSQL.dbo.mstrKecamatan b on a.kecamatanId=b.kecamatanId
        // inner join MasterdataSQL.dbo.MstrKabupaten c on b.kabupatenId=c.kabupatenId
        // inner join MasterdataSQL.dbo.MstrProvinsi d on c.provinsiId=d.PovinsiID
        // where a.desaId=:Medrec_Kelurahan";
        //  $this->db->query($query_nm_alamat);
        //  $this->db->bind('Medrec_Kelurahan', $Medrec_Kelurahan);
        //  $datas =  $this->db->single();
        //  $Kelurahan_Nama = $datas['Kelurahan'];
        //  $Kecamatan_Nama = $datas['Kecamatan'];
        //  $Kabupaten_Nama = $datas['kabupatenNama'];
        //  $Provinsi_Nama = $datas['ProvinsiNama'];

        $Kelurahan_Nama = $data['Kelurahan'];
        $Kecamatan_Nama = $data['Kecamatan'];
        $Kabupaten_Nama = $data['kabupatenNama'];
        $Provinsi_Nama = $data['ProvinsiNama'];
        $Medrec_IhsNumber = $data['Medrec_IhsNumber'];



        $tabel = "MasterDataSQL.dbo.Admision";
        if (isset($_POST['iswalkin'])) {
            $iswalkin = $data['iswalkin'];
            if ($iswalkin == 'WALKIN') {
                $tabel = "MasterDataSQL.dbo.Admision_walkin";
            }
        }

        if ($Medrec_NamaPasien <> ""  && $Medrec_NoMR == "") {
            $this->db->query("SELECT top 10 NoMR,PatientName,[Date_of_birth] as tgl_lahir , Mother , Address,ID_Card_number ,
                                [Home Phone] as tlprumah, [Mobile Phone] as hp 
                                from $tabel where Aktif='1' and  
                                [PatientName] like  '%' + :Medrec_NamaPasien  + '%' 
                                or replace(CONVERT(VARCHAR(11), [Date_of_birth], 111), '/','-') = :Medrec_Tgl_Lahir
                                or Address like     '%' + :Medrec_Alamat  + '%' 
                                or ID_Card_number like    '%' + :Medrec_NoIdPengenal  + '%'   
                                ORDER BY 1 DESC ");
            $this->db->bind('Medrec_NamaPasien',   $Medrec_NamaPasien);
            $this->db->bind('Medrec_Alamat',   $Medrec_Alamat);
            $this->db->bind('Medrec_NoIdPengenal',   $Medrec_NoIdPengenal);
            $this->db->bind('Medrec_Tgl_Lahir', $Medrec_Tgl_Lahir);
            $data =  $this->db->resultSet();
            $rowdata = $this->db->rowCount();
            $rows = array();
            $array = array();
            foreach ($data as $row) {
                $pasing['NoMR'] = $row['NoMR'];
                $pasing['PatientName'] = $row['PatientName'];
                $pasing['tgl_lahir'] = $row['tgl_lahir'];
                $pasing['PatientName'] = $row['PatientName'];
                $pasing['Mother'] = $row['Mother'];
                $pasing['Address'] = $row['Address'];
                $pasing['tlprumah'] = $row['tlprumah'];
                $pasing['hp'] = $row['hp'];
                $pasing['ID_Card_number'] = $row['ID_Card_number'];
                $rows[] = $pasing;
                $array['datarekammedik'] = $rows;
            }
            if ($_GET['q'] == 'simpan') {
                if ($rowdata > "0") {
                    echo json_encode(["status" => "double", "data" => $array], 200);
                    exit;
                }
            }
        }
        $nullable = "";
        //$userid = "0108"; 
        try {
            $this->db->transaksi();

            // JIKA NO REGISTRASI SUDAH ADA 
            if ($Medrec_NoMR <> "") {
                // UPDATE 
                // SATU SEHAT 
                $this->db->query("SELECT bridging_SatuSehat FROM MasterdataSQL.DBO.A_DATA_RS");
                $datakemkesvalidate =  $this->db->single();
                //no urut reg
                if($Medrec_IhsNumber == "" || $Medrec_IhsNumber == null){
                    $xidMrkemkes = null;
                    $bridging_SatuSehat = $datakemkesvalidate['bridging_SatuSehat'];
                    if($bridging_SatuSehat == "1"){ 
                        // DEVELPOMENT
                            $nik = $Medrec_NoIdPengenal;
                            $postData = $this->GetPatientbyNIK($nik); 
                            // update nomr kemenkes
                            if (isset($postData['total'])){
                                if($postData['total'] == "1"){
                                    $xidMrkemkes =  $postData['entry']['0']['resource']['id']; 
                                }else{
                                    $xidMrkemkes = $Medrec_IhsNumber;
                                }   
                            }else{
                                $xidMrkemkes = $Medrec_IhsNumber;
                            }
                    } 
                }else{
                    $xidMrkemkes = $Medrec_IhsNumber;
                }
                

                $this->db->query("UPDATE  $tabel  SET 
                    PatientName=:Medrec_NamaPasien,ID_Card_number=:Medrec_NoIdPengenal,
                    Tipe_Idcard=:Medrec_IdPengenal,Address=:Medrec_Alamat,Kelurahan=:Medrec_Kelurahan,
                    Kecamatan=:Medrec_Kecamatan,
                    City=:Medrec_kabupaten,[State/Province]=:Medical_Provinsi,[ZIP/Postal Code]=:Medrec_Kodepos,
                    [Country/Region]=:Medrec_Warganegara,Gander=:Medical_JKel,Marital_status=:Medrec_statusNikah,
                    Religion=:Medical_Agama,
                    BirthPlace=:Medrec_Tpt_lahir,Date_of_birth=:Medrec_Tgl_Lahir,Education=:Medrec_Pendidikan,
                    [Home Phone]=:Medrec_HomePhone,
                    [Mobile Phone]=:Medrec_handphone,[E-mail Address]=:Medrec_Email,
                    Ocupation=:Medrec_Pekerjaan,
                    Office_Name=:Medrec_PerusahaanNama,Office_Address=:Medrec_PerusahaanAlamat,
                    Office_Phone=:Medrec_PerusahaanTlp,Office_Fax=:Medrec_PerusahaanFax,
                    Contact_Name=:Medrec_DaruratNama,Contact_Address=:Medrec_DaruratAlamat,
                    CONTACT_PHONE=:Medrec_DaruratTlp,
                    CONTACT_STATUS=:Medrec_DaruratHub,
                    NoMR_IBU=:Medrec_Ibu_Kandung,Etnis=:Medrec_Etnis,Bahasa=:Medrec_Bahasa,
                    UpdateDate=:datenowcreate,Petugas_Update=:userid,Mother=:Medrec_NamaIbuKandung,Aktif=:Medrec_Status,
                    Father=:Medrec_Bin
                    ,KelurahanName=:Kelurahan_Nama,KecamatanName=:Kecamatan_Nama,CityName=:Kabupaten_Nama,ProvinceName=:Provinsi_Nama
                    ,idMrkemkes=:xidMrkemkes
                    WHERE NoMR=:Medrec_NoMR");


                $this->db->bind('Medrec_NamaPasien', $Medrec_NamaPasien);
                $this->db->bind('Medrec_NoIdPengenal', $Medrec_NoIdPengenal);
                $this->db->bind('Medrec_IdPengenal', $Medrec_IdPengenal);
                $this->db->bind('Medrec_Alamat', $Medrec_Alamat);
                $this->db->bind('Medrec_Kelurahan', $Medrec_Kelurahan);
                $this->db->bind('Medrec_Kecamatan', $Medrec_Kecamatan);
                $this->db->bind('Medrec_kabupaten', $Medrec_kabupaten);
                $this->db->bind('Medical_Provinsi', $Medical_Provinsi);
                $this->db->bind('Medrec_Kodepos', $Medrec_Kodepos);
                $this->db->bind('Medrec_Warganegara', $Medrec_Warganegara);
                $this->db->bind('Medical_JKel', $Medical_JKel);
                $this->db->bind('Medical_Agama', $Medical_Agama);
                $this->db->bind('Medrec_statusNikah', $Medrec_statusNikah);
                $this->db->bind('Medrec_Tpt_lahir', $Medrec_Tpt_lahir);
                $this->db->bind('Medrec_Tgl_Lahir', $Medrec_Tgl_Lahir);
                $this->db->bind('Medrec_Pendidikan', $Medrec_Pendidikan);
                $this->db->bind('Medrec_HomePhone', $Medrec_HomePhone);
                $this->db->bind('Medrec_handphone', $Medrec_handphone);
                $this->db->bind('Medrec_Email', $Medrec_Email);
                $this->db->bind('Medrec_Pekerjaan', $Medrec_Pekerjaan);
                $this->db->bind('Medrec_PerusahaanNama', $Medrec_PerusahaanNama);
                $this->db->bind('Medrec_PerusahaanAlamat', $Medrec_PerusahaanAlamat);
                $this->db->bind('Medrec_PerusahaanTlp', $Medrec_PerusahaanTlp);
                $this->db->bind('Medrec_PerusahaanFax', $Medrec_PerusahaanFax);
                $this->db->bind('Medrec_DaruratNama', $Medrec_DaruratNama);
                $this->db->bind('Medrec_DaruratAlamat', $Medrec_DaruratAlamat);
                $this->db->bind('Medrec_DaruratTlp', $Medrec_DaruratTlp);
                $this->db->bind('Medrec_DaruratHub', $Medrec_DaruratHub);
                $this->db->bind('Medrec_Ibu_Kandung', $Medrec_Ibu_Kandung);
                $this->db->bind('Medrec_Etnis', $Medrec_Etnis);
                $this->db->bind('Medrec_Bahasa', $Medrec_Bahasa);
                $this->db->bind('datenowcreate', $datenowcreate);
                $this->db->bind('Medrec_NamaIbuKandung', $Medrec_NamaIbuKandung);
                $this->db->bind('userid', $userid);
                $this->db->bind('Medrec_Bin', $Medrec_Bin);

                $this->db->bind('Kelurahan_Nama', $Kelurahan_Nama);
                $this->db->bind('Kecamatan_Nama', $Kecamatan_Nama);
                $this->db->bind('Kabupaten_Nama', $Kabupaten_Nama);
                $this->db->bind('Provinsi_Nama', $Provinsi_Nama);

                $this->db->bind('Medrec_Status', $Medrec_Status);
                $this->db->bind('Medrec_NoMR', $Medrec_NoMR);
                $this->db->bind('xidMrkemkes', $xidMrkemkes);
                $this->db->execute();

                $nomrx = str_replace("-", "", $Medrec_NoMR);
                if (strlen($nomrx) == 6) {
                    $nourutfixReg = "00" . $nomrx;
                } else if (strlen($nomrx) == 7) {
                    $nourutfixReg = "0" . $nomrx;
                } else if (strlen($nomrx) == 8) {
                    $nourutfixReg = $nomrx;
                }
                $this->db->query(" INSERT INTO LaboratoriumSQL.dbo.LIS_PATIENT_UPDATE ( NoMR, pname, sex, birth_dt, address, kota, mobile_nb, 
                      status_ts )
                      SELECT NoMR, PatientName, Gander, Date_of_birth, Address, City, [Mobile Phone], 0 AS Expr1
                      FROM $tabel
                      WHERE  NoMR=:Medrec_NoMR");
                $this->db->bind('Medrec_NoMR', $Medrec_NoMR);
                $this->db->execute();

                if ($tabel == 'MasterDataSQL.dbo.Admision'){
                $this->db->query("INSERT INTO RadiologiSQL.dbo.PATIENTWL ( PATIENT_NAME, REPLICA_DTTM, TRIGGER_DTTM, PATIENT_SEX, PATIENT_BIRTH_DTTM, ADDRESS, PATIENT_ID, EVENT_TYPE )
                                        SELECT '$Medrec_NamaPasien' ,'ANY', '$TRIGGER_DTTM', '$Medical_JKel_R','$DOB',
                                        '$Medrec_Alamat', '$nourutfixReg', 'ADT^A08'
                                        FROM $tabel a
                                        WHERE a.NoMR=:Medrec_NoMR2");
                $this->db->bind('Medrec_NoMR2', $Medrec_NoMR);
                $this->db->execute();
                }

                //UPDATE DASHBOARD RWJ

                // //GET NAMACARAMASUK
                //     $querry = "SELECT NamaCaraMasuk
                //     from MasterdataSQL.dbo.MstrCaraMasuk
                //     where id=:caramasukid";
                // $this->db->query($querry);
                // $this->db->bind('caramasukid', $caramasukid);
                // $dataf =  $this->db->single();
                // $NamaCaraMasuk = $dataf['NamaCaraMasuk'];

                $this->db->query("UPDATE DashboardData.[dbo].[dataRWJ]
            SET 
               [PatientName] =:Medrec_NamaPasien
               ,[Kelurahan] =:Kelurahan_Nama
               ,[Kecamatan] =:Kecamatan_Nama
               ,[kabupatenNama] =:Kabupaten_Nama
               ,[ProvinsiNama] =:Provinsi_Nama
               ,[Sex] =:Medical_JKel
               ,[DateOfBirth] =:Medrec_Tgl_Lahir
               ,[TipeIdCard] =:Medrec_IdPengenal
               ,[NoIdCard] =:Medrec_NoIdPengenal
               ,[Address] =:Medrec_Alamat
               ,[MaritalStatus] =:Medrec_statusNikah
               ,[Religion] =:Medical_Agama
               ,[Education] =:Medrec_Pendidikan
               ,[HomePhone] =:Medrec_HomePhone
               ,[MobilePhone] =:Medrec_handphone
               ,[Pekerjaan] =:Medrec_Pekerjaan
               ,[KodePos] =:Medrec_Kodepos
               ,[Bahasa] =:Medrec_Bahasa
               ,[Etnis] =:Medrec_Etnis
          WHERE NoMR=:Medrec_NoMR");

                $this->db->bind('Medrec_NamaPasien', $Medrec_NamaPasien);
                $this->db->bind('Medical_JKel', $Medical_JKel);
                $this->db->bind('Medrec_Tgl_Lahir', $Medrec_Tgl_Lahir);
                $this->db->bind('Medrec_IdPengenal', $Medrec_IdPengenal);
                $this->db->bind('Medrec_NoIdPengenal', $Medrec_NoIdPengenal);
                $this->db->bind('Medrec_Alamat', $Medrec_Alamat);
                $this->db->bind('Medrec_statusNikah', $Medrec_statusNikah);
                $this->db->bind('Medical_Agama', $Medical_Agama);
                $this->db->bind('Medrec_Pendidikan', $Medrec_Pendidikan);
                $this->db->bind('Medrec_HomePhone', $Medrec_HomePhone);
                $this->db->bind('Medrec_handphone', $Medrec_handphone);
                $this->db->bind('Medrec_Pekerjaan', $Medrec_Pekerjaan);
                $this->db->bind('Medrec_Kodepos', $Medrec_Kodepos);
                $this->db->bind('Medrec_Bahasa', $Medrec_Bahasa);
                $this->db->bind('Medrec_Etnis', $Medrec_Etnis);

                $this->db->bind('Kelurahan_Nama', $Kelurahan_Nama);
                $this->db->bind('Kecamatan_Nama', $Kecamatan_Nama);
                $this->db->bind('Kabupaten_Nama', $Kabupaten_Nama);
                $this->db->bind('Provinsi_Nama', $Provinsi_Nama);
                $this->db->bind('Medrec_NoMR', $Medrec_NoMR);
                $this->db->execute();

                //UPDATE DASHBOARD RWI

                // //GET NAMACARAMASUK
                //     $querry = "SELECT NamaCaraMasuk
                //     from MasterdataSQL.dbo.MstrCaraMasuk
                //     where id=:caramasukid";
                // $this->db->query($querry);
                // $this->db->bind('caramasukid', $caramasukid);
                // $dataf =  $this->db->single();
                // $NamaCaraMasuk = $dataf['NamaCaraMasuk'];

                $this->db->query("UPDATE DashboardData.[dbo].[dataRWI]
            SET 
               [PatientName] =:Medrec_NamaPasien
               ,[Kelurahan] =:Kelurahan_Nama
               ,[Kecamatan] =:Kecamatan_Nama
               ,[kabupatenNama] =:Kabupaten_Nama
               ,[ProvinsiNama] =:Provinsi_Nama
               ,[Sex] =:Medical_JKel
               ,[DateOfBirth] =:Medrec_Tgl_Lahir
               ,[TipeIdCard] =:Medrec_IdPengenal
               ,[NoIdCard] =:Medrec_NoIdPengenal
               ,[Address] =:Medrec_Alamat
               ,[MaritalStatus] =:Medrec_statusNikah
               ,[Religion] =:Medical_Agama
               ,[Education] =:Medrec_Pendidikan
               ,[HomePhone] =:Medrec_HomePhone
               ,[MobilePhone] =:Medrec_handphone
               ,[Pekerjaan] =:Medrec_Pekerjaan
               ,[KodePos] =:Medrec_Kodepos
          WHERE NoMR=:Medrec_NoMR");

                $this->db->bind('Medrec_NamaPasien', $Medrec_NamaPasien);
                $this->db->bind('Medical_JKel', $Medical_JKel);
                $this->db->bind('Medrec_Tgl_Lahir', $Medrec_Tgl_Lahir);
                $this->db->bind('Medrec_IdPengenal', $Medrec_IdPengenal);
                $this->db->bind('Medrec_NoIdPengenal', $Medrec_NoIdPengenal);
                $this->db->bind('Medrec_Alamat', $Medrec_Alamat);
                $this->db->bind('Medrec_statusNikah', $Medrec_statusNikah);
                $this->db->bind('Medical_Agama', $Medical_Agama);
                $this->db->bind('Medrec_Pendidikan', $Medrec_Pendidikan);
                $this->db->bind('Medrec_HomePhone', $Medrec_HomePhone);
                $this->db->bind('Medrec_handphone', $Medrec_handphone);
                $this->db->bind('Medrec_Pekerjaan', $Medrec_Pekerjaan);
                $this->db->bind('Medrec_Kodepos', $Medrec_Kodepos);

                $this->db->bind('Kelurahan_Nama', $Kelurahan_Nama);
                $this->db->bind('Kecamatan_Nama', $Kecamatan_Nama);
                $this->db->bind('Kabupaten_Nama', $Kabupaten_Nama);
                $this->db->bind('Provinsi_Nama', $Provinsi_Nama);
                $this->db->bind('Medrec_NoMR', $Medrec_NoMR);
                $this->db->execute();


                $this->db->commit();
                $callback = array(
                    'status' => 'update',
                );
                return $callback;
            } else {
                
            // SATU SEHAT 
            $this->db->query("SELECT bridging_SatuSehat FROM MasterdataSQL.DBO.A_DATA_RS");
            $datakemkesvalidate =  $this->db->single();
            //no urut reg
            $xidMrkemkes = null;
            $bridging_SatuSehat = $datakemkesvalidate['bridging_SatuSehat'];
            if($bridging_SatuSehat == "1"){ 
                // DEVELPOMENT 
                    $nik = $Medrec_NoIdPengenal;
                    $postData = $this->GetPatientbyNIK($nik); 
                   
                   // update nomr kemenkes
                    if (isset($postData['total'])){
                    if($postData['total'] == "1"){
                        $xidMrkemkes =  $postData['entry']['0']['resource']['id']; 
                    }else{
                        $xidMrkemkes = $Medrec_IhsNumber;
                    }   
                    }else{
                        $xidMrkemkes = $Medrec_IhsNumber;
                    }

            } 
             // SATU SEHAT

                $this->db->query("SELECT max(ID) as nomrx
                                from $tabel ");
                $data =  $this->db->single();
                $nomrx = $data['nomrx'];
                $nomrx++;
                $nourutfixMR = Utils::generateAutoNumberMedicalRecord($nomrx);
                $nourutfixReg = Utils::generateAutoNumberMedicalRecordPACS($nomrx);
                $idkanan = substr($nourutfixMR, 4); // xx-xx-03 kanan
                $idtengah = substr($nourutfixMR, 2, -2); //
                $idkiri = substr($nourutfixMR, 0, -4);
                $NoMrfix =   $idkiri . '-' . $idtengah . '-' . $idkanan;
                $nourutfixMR = $idkiri . $idtengah . $idkanan;

                if (isset($_POST['iswalkin'])) {
                    $iswalkin = $_POST['iswalkin'];
                    if ($iswalkin == 'WALKIN') {
                        $NoMrfix =   'W-' . $idkiri . $idtengah . $idkanan;
                    }
                }


                // insert 
                $this->db->query("INSERT INTO $tabel 
                                        (ID,NoMR,PatientName,ID_Card_number,
                                        Tipe_Idcard,Address,Kelurahan,
                                        Kecamatan,
                                        City,[State/Province],[ZIP/Postal Code],
                                        [Country/Region],Gander,Marital_status,Religion,
                                        BirthPlace,Date_of_birth,Education,[Home Phone],
                                        [Mobile Phone],[E-mail Address],Ocupation,
                                        Office_Name,Office_Address,Office_Phone,Office_Fax,
                                        Contact_Name,Contact_Address,CONTACT_PHONE,
                                        CONTACT_STATUS,
                                        NoMR_IBU,Etnis,NilaiKepercayaan,Bahasa,KemampuanMembaca,
                                        HambatanEdukasi,InputDate,Mother,Petugas_Input,Aktif,Father
                                        ,KelurahanName,KecamatanName,CityName,ProvinceName,idMrkemkes
                                        ) values
                                        (:nomrx,:NoMrfix,:Medrec_NamaPasien,:Medrec_NoIdPengenal,
                                        :Medrec_IdPengenal,:Medrec_Alamat,:Medrec_Kelurahan,
                                        :Medrec_Kecamatan,
                                        :Medrec_kabupaten,:Medical_Provinsi,:Medrec_Kodepos,
                                        :Medrec_Warganegara,:Medical_JKel,:Medrec_statusNikah,:Medical_Agama,
                                        :Medrec_Tpt_lahir,:Medrec_Tgl_Lahir,:Medrec_Pendidikan,:Medrec_HomePhone,
                                        :Medrec_handphone,:Medrec_Email,:Medrec_Pekerjaan,
                                        :Medrec_PerusahaanNama,:Medrec_PerusahaanAlamat,:Medrec_PerusahaanTlp,:Medrec_PerusahaanFax,
                                        :Medrec_DaruratNama,:Medrec_DaruratAlamat,:Medrec_DaruratTlp,
                                        :Medrec_DaruratHub,
                                        :Medrec_Ibu_Kandung,:Medrec_Etnis,:nullable,:Medrec_Bahasa,:nullable2,
                                        :nullable3,:datenowcreate,:Medrec_NamaIbuKandung,:userid,'1',:Medrec_Bin
                                        ,:Kelurahan_Nama,:Kecamatan_Nama,:Kabupaten_Nama,:Provinsi_Nama,:idMrkemkes
                                        )");
                $this->db->bind('nomrx', $nomrx);
                $this->db->bind('NoMrfix', $NoMrfix);
                $this->db->bind('Medrec_NamaPasien', $Medrec_NamaPasien);
                $this->db->bind('Medrec_NoIdPengenal', $Medrec_NoIdPengenal);
                $this->db->bind('Medrec_IdPengenal', $Medrec_IdPengenal);
                $this->db->bind('Medrec_Alamat', $Medrec_Alamat);
                $this->db->bind('Medrec_Kelurahan', $Medrec_Kelurahan);
                $this->db->bind('Medrec_Kecamatan', $Medrec_Kecamatan);
                $this->db->bind('Medrec_kabupaten', $Medrec_kabupaten);
                $this->db->bind('Medical_Provinsi', $Medical_Provinsi);
                $this->db->bind('Medrec_Kodepos', $Medrec_Kodepos);
                $this->db->bind('Medrec_Warganegara', $Medrec_Warganegara);
                $this->db->bind('Medical_JKel', $Medical_JKel);
                $this->db->bind('Medical_Agama', $Medical_Agama);
                $this->db->bind('Medrec_statusNikah', $Medrec_statusNikah);
                $this->db->bind('Medrec_Tpt_lahir', $Medrec_Tpt_lahir);
                $this->db->bind('Medrec_Tgl_Lahir', $Medrec_Tgl_Lahir);
                $this->db->bind('Medrec_Pendidikan', $Medrec_Pendidikan);
                $this->db->bind('Medrec_HomePhone', $Medrec_HomePhone);
                $this->db->bind('Medrec_handphone', $Medrec_handphone);
                $this->db->bind('Medrec_Email', $Medrec_Email);
                $this->db->bind('Medrec_Pekerjaan', $Medrec_Pekerjaan);
                $this->db->bind('Medrec_PerusahaanNama', $Medrec_PerusahaanNama);
                $this->db->bind('Medrec_PerusahaanAlamat', $Medrec_PerusahaanAlamat);
                $this->db->bind('Medrec_PerusahaanTlp', $Medrec_PerusahaanTlp);
                $this->db->bind('Medrec_PerusahaanFax', $Medrec_PerusahaanFax);
                $this->db->bind('Medrec_DaruratNama', $Medrec_DaruratNama);
                $this->db->bind('Medrec_DaruratAlamat', $Medrec_DaruratAlamat);
                $this->db->bind('Medrec_DaruratTlp', $Medrec_DaruratTlp);
                $this->db->bind('Medrec_DaruratHub', $Medrec_DaruratHub);
                $this->db->bind('Medrec_Ibu_Kandung', $Medrec_Ibu_Kandung);
                $this->db->bind('Medrec_Etnis', $Medrec_Etnis);
                $this->db->bind('nullable', $nullable);
                $this->db->bind('nullable2', $nullable);
                $this->db->bind('Medrec_Bahasa', $Medrec_Bahasa);
                $this->db->bind('nullable3', $nullable);
                $this->db->bind('datenowcreate', $datenowcreate);
                $this->db->bind('Medrec_NamaIbuKandung', $Medrec_NamaIbuKandung);
                $this->db->bind('userid', $userid);
                $this->db->bind('Medrec_Bin', $Medrec_Bin);

                $this->db->bind('Kelurahan_Nama', $Kelurahan_Nama);
                $this->db->bind('Kecamatan_Nama', $Kecamatan_Nama);
                $this->db->bind('Kabupaten_Nama', $Kabupaten_Nama);
                $this->db->bind('Provinsi_Nama', $Provinsi_Nama);
                $this->db->bind('idMrkemkes', $xidMrkemkes);

                
                $this->db->execute();
                //pacs
                $PATIENTWL_KEY = null;
                $this->db->query("SELECT PATIENTWL_KEY
                                FROM RadiologiSQL.dbo.PATIENTWL 
                                Where PATIENT_ID=:nourutfixReg");
                $this->db->bind('nourutfixReg', $nourutfixReg);
                $data =  $this->db->single();
                $PATIENTWL_KEY = $data['PATIENTWL_KEY'];
                if ($PATIENTWL_KEY == null || $PATIENTWL_KEY == '') {
                    $dt = "ADT^A04";
                } else {
                    $dt = "ADT^A08";
                }
                
                if ($tabel == 'MasterDataSQL.dbo.Admision'){
                $this->db->query("INSERT INTO RadiologiSQL.dbo.PATIENTWL ( PATIENT_NAME, REPLICA_DTTM, TRIGGER_DTTM, PATIENT_SEX, PATIENT_BIRTH_DTTM, ADDRESS, PATIENT_ID, EVENT_TYPE )
                                        SELECT '$Medrec_NamaPasien' ,'ANY', '$TRIGGER_DTTM', '$Medical_JKel_R','$DOB',
                                        '$Medrec_Alamat', '$nourutfixReg', '$dt'
                                        FROM $tabel a
                                        WHERE a.NoMR=:NoMrfix");
                $this->db->bind('NoMrfix', $NoMrfix);
                $this->db->execute();
                }
                $this->db->commit();
                $callback = array(
                    'status' => 'success',
                    'NoMR' => $NoMrfix,
                    'idx' => $nourutfixMR,
                    'PatientName' => $Medrec_NamaPasien,
                    'Gander' => $Medical_JKel,
                    'Date_of_birth' => $Medrec_Tgl_Lahir,
                    'Address' => $Medrec_Alamat,
                    'NIK' => $Medrec_NoIdPengenal,
                    'Pekerjaan' => $Medrec_Pekerjaan,
                    'TptLahir' =>  $Medrec_Tpt_lahir,
                    'NoHp' => $Medrec_handphone,
                    'idMrkemkes' => $xidMrkemkes
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
    public function getListMedicalRecord($data)
    {
        try {
            $kriteria = $data['txSearchData'];
            $cmbxcrimr = $data['cmbxcrimr'];
            $tabel = "MasterDataSQL.dbo.Admision";
            if (isset($_POST['iswalkin'])) {
                $iswalkin = $data['iswalkin'];
                if ($iswalkin == 'WALKIN') {
                    $tabel = "MasterDataSQL.dbo.Admision_walkin";
                }
            }
            if ($cmbxcrimr == "1") { // nama pasien
                $query = "SELECT top 5000 
                    *,replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as TglLahir
                    from $tabel where    Aktif='1' and  [PatientName] like  '%' + :Medrec_NamaPasien  + '%' 
                    ORDER BY 1 DESC";
                $this->db->query($query);
                $this->db->bind('Medrec_NamaPasien',   $kriteria);
            } elseif ($cmbxcrimr == "2") { // tgl lahir
                $query = "SELECT top 5000 
                        *,replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as TglLahir
                        from $tabel where  Aktif='1' and convert(varchar, [Date_of_birth], 103) like '%' + :Medrec_Tgl_Lahir  + '%'  
                        ORDER BY 1 DESC";
                $this->db->query($query);
                $this->db->bind('Medrec_Tgl_Lahir', $kriteria);
            } elseif ($cmbxcrimr == "3") { // no mr
                $query = "SELECT top 5000 
                        *,replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as TglLahir
                        from $tabel where Aktif='1' and  NoMR like    '%' + :NoMR  + '%' 
                        ORDER BY 1 DESC";
                $this->db->query($query);
                $this->db->bind('NoMR', $kriteria);
            } elseif ($cmbxcrimr == "4") { // alamat
                $query = "SELECT top 5000 
                        *,replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as TglLahir
                        from $tabel where    Aktif='1' and Address like     '%' + :Medrec_Alamat  + '%'  
                        ORDER BY 1 DESC";
                $this->db->query($query);
                $this->db->bind('Medrec_Alamat',   $kriteria);
            } elseif ($cmbxcrimr == "5") { // alamat
                $query = "SELECT top 5000 
                        *,replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as TglLahir
                        from $tabel where    Aktif='1' and  ID_Card_number like    '%' + :Medrec_NoIdPengenal  + '%'    
                        ORDER BY 1 DESC";
                $this->db->query($query);
                $this->db->bind('Medrec_NoIdPengenal',   $kriteria);
            }
            // $query = "SELECT top 5000 
            // *,replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as TglLahir
            // from $tabel where    Aktif='1' and convert(varchar, [Date_of_birth], 103) like '%' + :Medrec_Tgl_Lahir  + '%'  
            // and     Aktif='1' or [PatientName] like  '%' + :Medrec_NamaPasien  + '%' 
            // or Address like     '%' + :Medrec_Alamat  + '%' 
            //     or ID_Card_number like    '%' + :Medrec_NoIdPengenal  + '%'   
            //     or NoMR like    '%' + :NoMR  + '%' 
            //     ORDER BY 1 DESC";

            // $this->db->query($query);
            // $this->db->bind('Medrec_NamaPasien',   $kriteria);
            // $this->db->bind('Medrec_Alamat',   $kriteria);
            // $this->db->bind('Medrec_NoIdPengenal',   $kriteria);
            // $this->db->bind('Medrec_Tgl_Lahir', $kriteria);
            // $this->db->bind('NoMR', $kriteria);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {
                $pasing['NoMR'] = $row['NoMR'];
                $pasing['NamaPasien'] = $row['PatientName'];
                $pasing['TglLahir'] = date('d/m/Y', strtotime($row['TglLahir']));
                $pasing['Alamat'] = $row['Address'];
                $pasing['TlpRumah'] = 'Tlp : ' . $row['Home Phone'] . '<br>Hp : ' . $row['Mobile Phone'] . '
                                                              <br>Nama Ibu : ' . $row['Mother'];
                $pasing['ID'] = $row['ID'];
                $pasing['Aktif'] = $row['Aktif'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function GetMedicalRecordbyIDTrs($data)
    {
        try {
            $idTrsMr = $data['q'];
            $tabel = "MasterDataSQL.dbo.Admision";
            if (isset($_POST['iswalkin'])) {
                $iswalkin = $data['iswalkin'];
                if ($iswalkin == 'WALKIN') {
                    $tabel = "MasterDataSQL.dbo.Admision_walkin";
                }
            }

            $this->db->query("SELECT replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as Date_of_birthx,
                                NoMR,PatientName,Address,Gander,BirthPlace,Ocupation,
                                case when Gander='L' then 'LAKI-LAKI' when Gander='P' then 'PEREMPUAN'  END AS NamaGander,
                                ID_Card_number,[E-mail Address] as email,[Mobile Phone] as mobilephone,[Home Phone] as homephone,*
                                from $tabel where ID=:idTrsMr");
            $this->db->bind('idTrsMr', $idTrsMr);
            $data =  $this->db->single();

            // SATU SEHAT
            $idMrkemkes ="";
            $this->db->query("SELECT bridging_SatuSehat FROM MasterdataSQL.DBO.A_DATA_RS");
            $datakemkesvalidate =  $this->db->single();
            //no urut reg

            $bridging_SatuSehat = $datakemkesvalidate['bridging_SatuSehat'];
            if($bridging_SatuSehat == "1"){ 
                // DEVELPOMENT
                
                    $nik = $data['ID_Card_number'];
                    $postData = $this->GetPatientbyNIK($nik); 

                    
                   
                    if (isset($postData['total'])){
                        // update nomr kemenkes
                        if($postData['total'] == "1"){
                            $idMrkemkes =  $postData['entry']['0']['resource']['id'];
                            $this->db->query("UPDATE $tabel
                            SET idMrkemkes=:idMrkemkes  where ID=:idTrsMr and Aktif='1'");
                            $this->db->bind('idMrkemkes', $idMrkemkes); 
                            $this->db->bind('idTrsMr', $idTrsMr);
                            $this->db->execute();
                        }  
                    }

            } 
             // SATU SEHAT
             
            $callback = array(
                'status' => 'success', // Set array status dengan success
                'ID' => $data['ID'], // Set array status dengan success
                'NoMR' => $data['NoMR'], // Set array status dengan success
                'PatientName' => $data['PatientName'], // Set array status dengan success
                'ID_Card_number' => $data['ID_Card_number'], // Set array status dengan success
                'NoPesertaBPJS' => $data['NoPesertaBPJS'], // Set array status dengan success
                'Gander' => $data['Gander'], // Set array status dengan success
                'Date_of_birth' => $data['Date_of_birthx'], // Set array status dengan successDate_of_birth
                'Address' => $data['Address'], // Set array status dengan successDate_of_birth
                'NamaGander' => $data['NamaGander'], // Set array status dengan successDate_of_birth
                'BirthPlace' => $data['BirthPlace'], // Set array status dengan successDate_of_birth
                'Ocupation' => $data['Ocupation'], // Set array status dengan successDate_of_birth
                'email' => $data['email'], // Set array status dengan successDate_of_birth
                'mobilephone' => $data['mobilephone'], // Set array status dengan successDate_of_birth
                'homephone' => $data['homephone'], // Set array status dengan successDate_of_birth

                'Ocupation' => $data['Ocupation'],
                'Medical_Provinsi' => $data['State/Province'],
                'Medrec_Warganegara' => $data['Country/Region'],
                'Medical_Agama' => $data['Religion'],

                'Medrec_statusNikah' => $data['Marital_status'],
                'Medrec_Pendidikan' => $data['Education'],
                'Mother' => $data['Mother'],
                'kodepos' => $data['ZIP/Postal Code'],

                'Bahasa' => $data['Bahasa'],
                'Tipe_Idcard' => $data['Tipe_Idcard'],
                'Etnis' => $data['Etnis'],
                'Medrec_Kecamatan' => $data['Kecamatan'],
                'Medrec_kabupaten' => $data['City'],
                'Medrec_Kelurahan' => $data['Kelurahan'],
                'idMrkemkes' => $idMrkemkes,
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
    public function createPolisAsuransi($data)
    {
        try {
            $this->db->transaksi();
            $kartu_NoRM = $data['kartu_NoRM'];
            $Kartu_NamaPasien = $data['Kartu_NamaPasien'];
            $Kartu_GroupJaminan = $data['Kartu_GroupJaminan'];
            $Kartu_NamaJaminan = $data['Kartu_NamaJaminan'];
            $Kartu_NoPeserta = $data['Kartu_NoPeserta'];
            $Kartu_HakKelas = $data['Kartu_HakKelas'];
            $Kartu_NamaPemegangKartu = $data['Kartu_NamaPemegangKartu'];
            $Kartu_Keterangan = $data['Kartu_Keterangan'];
            $Kartu_ID = $data['Kartu_ID'];
            $Kartu_StatusPeserta = $data['Kartu_StatusPeserta'];
            // Bikin barier 
            if ($kartu_NoRM == "" || $Kartu_GroupJaminan == "" || $Kartu_NamaJaminan == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. MR/Nama Jaminan Anda Masih Kosong !',
                );
                return $callback;
                exit;
            }

            if ($Kartu_NoPeserta == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No Peserta Kosong !',
                );
                return $callback;
                exit;
            }

            if ($Kartu_HakKelas == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Hak Kelas Kosong ! Harap Diisi Kelas 3 Jika Tidak Ada Data!',
                );
                return $callback;
                exit;
            }

            if ($Kartu_StatusPeserta == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Status Peserta Kosong!',
                );
                return $callback;
                exit;
            }

            if ($Kartu_NamaPemegangKartu == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Nama Pemegang Kartu Kosong!',
                );
                return $callback;
                exit;
            }
            if ($Kartu_ID == "") {
                $this->db->query("INSERT INTO MasterdataSQL.dbo.Admision_Kartu_Jaminan
                                (NoMR,KodeGroupJaminan,KodeJaminan,
                                NoKartu,HakKelas,NamaPemegangKartu,StatusPasien,Keterangan)
                                VALUES
                                (:kartu_NoRM,:Kartu_GroupJaminan,:Kartu_NamaJaminan,
                                :Kartu_NoPeserta,:Kartu_HakKelas,:Kartu_NamaPemegangKartu, :Kartu_StatusPeserta,
                                :Kartu_Keterangan )");
                $this->db->bind('kartu_NoRM', $kartu_NoRM);
                $this->db->bind('Kartu_GroupJaminan', $Kartu_GroupJaminan);
                $this->db->bind('Kartu_NamaJaminan', $Kartu_NamaJaminan);
                $this->db->bind('Kartu_NoPeserta', $Kartu_NoPeserta);
                $this->db->bind('Kartu_HakKelas', $Kartu_HakKelas);
                $this->db->bind('Kartu_NamaPemegangKartu', $Kartu_NamaPemegangKartu);
                $this->db->bind('Kartu_StatusPeserta', $Kartu_StatusPeserta);
                $this->db->bind('Kartu_Keterangan', $Kartu_Keterangan);
                $this->db->execute();
                $this->db->commit();
                $callback = array(
                    'status' => 'success',
                    'pesan' => 'Data Anda Berhasil disimpan !',
                );
                return $callback;
            } else {
                $this->db->query("UPDATE MasterdataSQL.dbo.Admision_Kartu_Jaminan
                            SET NoMR=:kartu_NoRM,KodeGroupJaminan=:Kartu_GroupJaminan,KodeJaminan=:Kartu_NamaJaminan,
                            NoKartu=:Kartu_NoPeserta,HakKelas=:Kartu_HakKelas,NamaPemegangKartu=:Kartu_NamaPemegangKartu, 
                            Keterangan=:Kartu_Keterangan,StatusPasien=:Kartu_StatusPeserta where ID=:Kartu_ID");
                $this->db->bind('kartu_NoRM', $kartu_NoRM);
                $this->db->bind('Kartu_GroupJaminan', $Kartu_GroupJaminan);
                $this->db->bind('Kartu_NamaJaminan', $Kartu_NamaJaminan);
                $this->db->bind('Kartu_NoPeserta', $Kartu_NoPeserta);
                $this->db->bind('Kartu_HakKelas', $Kartu_HakKelas);
                $this->db->bind('Kartu_NamaPemegangKartu', $Kartu_NamaPemegangKartu);
                $this->db->bind('Kartu_StatusPeserta', $Kartu_StatusPeserta);
                $this->db->bind('Kartu_Keterangan', $Kartu_Keterangan);
                $this->db->bind('Kartu_ID', $Kartu_ID);
                $this->db->execute();
                $this->db->commit();
                $callback = array(
                    'status' => 'success',
                    'pesan' => 'Data Anda Berhasil disimpan !',
                );
                return $callback;
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
    public function createPolisKaryawan($data)
    {
        try {
            $this->db->transaksi();
            $kartu_NoRM = $data['RSY_kartu_NoRM'];
            $Kartu_NamaPasien = $data['RSY_Kartu_NamaPasien'];
            $Kartu_GroupJaminan = $data['RSY_Kartu_GroupJaminan'];
            $Kartu_NamaJaminan = $data['RSY_Kartu_NamaJaminan'];
            $Kartu_NoPeserta = $data['RSY_Kartu_NoPeserta'];
            $Kartu_HakKelas = $data['RSY_Kartu_HakKelas'];
            $Kartu_NamaPemegangKartu = $data['RSY_Kartu_NamaPemegangKartu'];
            $RSY_stsPeg = $data['RSY_stsPeg'];
            $Kartu_ID = $data['Kartu_ID2'];
            $Kartu_Keterangan = '';
            $Kartu_StatusPeserta = $data['RSY_Kartu_StatusPeserta'];

            $tabel = "MasterDataSQL.dbo.Admision";
            if (isset($_POST['iswalkin'])) {
                $iswalkin = $data['iswalkin'];
                if ($iswalkin == 'WALKIN') {
                    $tabel = "MasterDataSQL.dbo.Admision_walkin";
                }
            }
            // Bikin barier 
            if ($Kartu_StatusPeserta == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Status Peserta Kosong !',
                );
                echo json_encode($callback);
                exit;
            }

            if ($Kartu_NoPeserta == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No Peserta Kosong ! Harap Validasi Terlebih Dahulu!',
                );
                echo json_encode($callback);
                exit;
            }

            if ($RSY_stsPeg == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Status Kepegawaian Kosong! Pastikan Karyawan Yang Masih Bekerja Di RS Yarsi!',
                );
                echo json_encode($callback);
                exit;
            }
            // Bikin barier 
            if ($kartu_NoRM == "" || $Kartu_GroupJaminan == "" || $Kartu_NamaJaminan == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Data Anda Masih Kosong !',
                );
                echo json_encode($callback);
                exit;
            }

            if ($Kartu_ID == "") {
                $this->db->query("INSERT INTO MasterdataSQL.dbo.Admision_Kartu_Jaminan
                                (NoMR,KodeGroupJaminan,KodeJaminan,
                                NoKartu,HakKelas,NamaPemegangKartu,StatusPasien,Keterangan)
                                VALUES
                                (:kartu_NoRM,:Kartu_GroupJaminan,:Kartu_NamaJaminan,
                                :Kartu_NoPeserta,:Kartu_HakKelas,:Kartu_NamaPemegangKartu, :Kartu_StatusPeserta,
                                :Kartu_Keterangan )");
                $this->db->bind('kartu_NoRM', $kartu_NoRM);
                $this->db->bind('Kartu_GroupJaminan', $Kartu_GroupJaminan);
                $this->db->bind('Kartu_NamaJaminan', $Kartu_NamaJaminan);
                $this->db->bind('Kartu_NoPeserta', $Kartu_NoPeserta);
                $this->db->bind('Kartu_HakKelas', $Kartu_HakKelas);
                $this->db->bind('Kartu_NamaPemegangKartu', $Kartu_NamaPemegangKartu);
                $this->db->bind('Kartu_StatusPeserta', $Kartu_StatusPeserta);
                $this->db->bind('Kartu_Keterangan', $Kartu_Keterangan);
                $this->db->execute();

                $this->db->query("UPDATE $tabel
                                SET Nik=:Kartu_NoPeserta,Status_Nik=:Kartu_StatusPeserta 
                                where NoMR=:kartu_NoRM");
                $this->db->bind('kartu_NoRM', $kartu_NoRM);
                $this->db->bind('Kartu_NoPeserta', $Kartu_NoPeserta);
                $this->db->bind('Kartu_StatusPeserta', $Kartu_StatusPeserta);
                $this->db->execute();

                $this->db->commit();
                $callback = array(
                    'status' => 'success',
                    'pesan' => 'Data Anda Berhasil disimpan !',
                );
                return $callback;
            } else {
                $this->db->query("UPDATE MasterdataSQL.dbo.Admision_Kartu_Jaminan
                            SET NoMR=:kartu_NoRM,KodeGroupJaminan=:Kartu_GroupJaminan,KodeJaminan=:Kartu_NamaJaminan,
                            NoKartu=:Kartu_NoPeserta,HakKelas=:Kartu_HakKelas,NamaPemegangKartu=:Kartu_NamaPemegangKartu, 
                            Keterangan=:Kartu_Keterangan,StatusPasien=:Kartu_StatusPeserta where ID=:Kartu_ID");
                $this->db->bind('kartu_NoRM', $kartu_NoRM);
                $this->db->bind('Kartu_GroupJaminan', $Kartu_GroupJaminan);
                $this->db->bind('Kartu_NamaJaminan', $Kartu_NamaJaminan);
                $this->db->bind('Kartu_NoPeserta', $Kartu_NoPeserta);
                $this->db->bind('Kartu_HakKelas', $Kartu_HakKelas);
                $this->db->bind('Kartu_NamaPemegangKartu', $Kartu_NamaPemegangKartu);
                $this->db->bind('Kartu_StatusPeserta', $Kartu_StatusPeserta);
                $this->db->bind('Kartu_Keterangan', $Kartu_Keterangan);
                $this->db->bind('Kartu_ID', $Kartu_ID);
                $this->db->execute();

                $this->db->query("UPDATE $tabel
                                SET Nik=:Kartu_NoPeserta,Status_Nik=:Kartu_StatusPeserta 
                                where NoMR=:kartu_NoRM");
                $this->db->bind('kartu_NoRM', $kartu_NoRM);
                $this->db->bind('Kartu_NoPeserta', $Kartu_NoPeserta);
                $this->db->bind('Kartu_StatusPeserta', $Kartu_StatusPeserta);
                $this->db->execute();

                $this->db->commit();
                $callback = array(
                    'status' => 'success',
                    'pesan' => 'Data Anda Berhasil disimpan !',
                );
                return $callback;
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
    public function uploaddocument($data)
    {


        // Jika user telah mengklik tombol Preview

        //$ip = ; // Ambil IP Address dari User
        $doc_jenisdocument = $data['doc_jenisdocument'];
        $doc_keterangan = $data['doc_keterangan'];
        $doc_nomr = $data['doc_nomr'];

        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png", "pdf" => "application/pdf");
        $filetype = $_FILES["file"]["type"];
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
        $tmp_file = $_FILES['file']['tmp_name'];

        // Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
        if (in_array($filetype, $allowed)) {
            $bytes = random_bytes(20);
            $nama_file_baru  =    $doc_nomr . bin2hex($bytes) . "-" . date("YmdHis") . '.' . $ext;
            if (move_uploaded_file($tmp_file,  __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru)) {

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
                $file_name = __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru;
                $source =   $file_name;
                $awsImages = '';
                try {
                    $bucket = 'rsuyarsibucket';
                    $key = basename($file_name);
                    $result = $s3Client->putObject([
                        'Bucket' => $bucket,
                        'Key'    => 'identitas/' . $key,
                        'Body'   => fopen($source, 'r'),
                        'ACL'    => 'public-read', // make file 'public', 
                    ]);
                    $awsImages = $result->get('ObjectURL');
                    return $this->SaveTTD($data,  $nama_file_baru, $awsImages, $ext);
                } catch (MultipartUploadException $e) {

                    return $e->getMessage();
                }
            } else {
                $callback = array(
                    'status' => 'warning',
                    'message' => 'Upload Failed.',
                );
                return $callback;
            }
        } else { // Jika file yang diupload bukan File Excel 2007 (.xlsx)
            // Munculkan pesan validasi 
            $callback = array(
                'status' => 'warning',
                'message' => ' File Tidak Support.',
                '$ext' => $ext,
                ' $allowed' =>  $allowed,
            );
            return $callback;
        }
    }
    public function SaveTTD($data,  $nama_file_baru, $awsImages, $ext)
    {
        // unlink(__DIR__ . '/../../public' . '/tmp/' . $nama_file_baru); // Hapus file tersebut 

        // var_dump($data);
        $query = "INSERT INTO Billing_Pasien.[dbo].DOCUMENT_UPLOAD
           (NO_MR,PROVIDER,KETERANGAN,URL,date_update,USERID,JENIS_DOCUMENT,EXTENSION)
            VALUES
           ( :NO_MR,:PROVIDER,:KETERANGAN,:URL ,:date_update,:USERID,:JENIS_DOCUMENT,:EXTENSION) ";
        try {
            $this->db->transaksi();
            $ro = "aws";
            $datetime = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $operator =  $session->IDEmployee;
            $this->db->query($query);
            $this->db->bind('NO_MR', $data['doc_nomr']);
            $this->db->bind('KETERANGAN', $data['doc_keterangan']);
            $this->db->bind('JENIS_DOCUMENT', $data['doc_jenisdocument']);
            $this->db->bind('PROVIDER', $ro);
            $this->db->bind('URL', $awsImages);
            $this->db->bind('date_update', $datetime);
            $this->db->bind('USERID', $namauserx);
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
    public function listuploaddocument($data)
    {
        try {
            $this->db->query("SELECT ID,NO_MR,PROVIDER,KETERANGAN,URL,date_update, JENIS_DOCUMENT,USERID,EXTENSION
                            FROM Billing_Pasien.[dbo].DOCUMENT_UPLOAD
                            where NO_MR=:doc_nomr order by 1 desc");
            $this->db->bind('doc_nomr', $data['doc_nomr']);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['NO_MR'] = $key['NO_MR'];
                $pasing['PROVIDER'] = $key['PROVIDER'];
                $pasing['KETERANGAN'] = $key['KETERANGAN'];
                $pasing['URL'] = $key['URL'];
                $pasing['date_update'] = $key['date_update'];
                $pasing['JENIS_DOCUMENT'] = $key['JENIS_DOCUMENT'];
                $pasing['USERID'] = $key['USERID'];
                $pasing['EXTENSION'] = $key['EXTENSION'];
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

    public function getListMedicalRecordAll($data)
    {
        try {
            $kriteria = $data['txSearchData'];
            $tabel = "MasterDataSQL.dbo.Admision";
            if (isset($_POST['iswalkin'])) {
                $iswalkin = $data['iswalkin'];
                if ($iswalkin == 'WALKIN') {
                    $tabel = "MasterDataSQL.dbo.Admision_walkin";
                }
            }

            $query = "SELECT top 5000 
            *,replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as TglLahir,idMrkemkes
            from $tabel where 
                [PatientName] like  '%' + :Medrec_NamaPasien  + '%' 
                or convert(varchar, [Date_of_birth], 103) = :Medrec_Tgl_Lahir
                or Address like     '%' + :Medrec_Alamat  + '%' 
                or ID_Card_number like    '%' + :Medrec_NoIdPengenal  + '%'   
                or NoMR like    '%' + :NoMR  + '%'    
                ORDER BY 1 DESC";

            $this->db->query($query);
            $this->db->bind('Medrec_NamaPasien',   $kriteria);
            $this->db->bind('Medrec_Alamat',   $kriteria);
            $this->db->bind('Medrec_NoIdPengenal',   $kriteria);
            $this->db->bind('Medrec_Tgl_Lahir', $kriteria);
            $this->db->bind('NoMR', $kriteria);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {
                $pasing['NoMR'] = $row['NoMR'];
                $pasing['NamaPasien'] = $row['PatientName'];
                $pasing['idMrkemkes'] = $row['idMrkemkes'];
                $pasing['TglLahir'] = date('d/m/Y', strtotime($row['TglLahir']));
                $pasing['Alamat'] = $row['Address'];
                $pasing['TlpRumah'] = 'Tlp : ' . $row['Home Phone'] . '<br>Hp : ' . $row['Mobile Phone'] . '
                                                              <br>Nama Ibu : ' . $row['Mother'];
                $pasing['ID'] = $row['ID'];
                $pasing['Aktif'] = $row['Aktif'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function signupUser($data)
    {
        $nomr = $data['nomr'];

        $this->db->query("SELECT PatientName,replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as DOB,[E-Mail Address] as email,[Mobile Phone] as nohp
            from MasterdataSQL.dbo.Admision  
            where NoMR=:nomr
            UNION ALL
            SELECT PatientName,replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as DOB,[E-Mail Address] as email,[Mobile Phone] as nohp
            from MasterdataSQL.dbo.Admision_walkin  
            where NoMR=:nomr2
            ");
        $this->db->bind('nomr', $nomr);
        $this->db->bind('nomr2', $nomr);
        $datas =  $this->db->single();

        $PatientName = $datas['PatientName'];
        $DOB = $datas['DOB'];
        $email = $datas['email'];
        $nohp = $datas['nohp'];
        $dob_converted = Date('dmY', strtotime($DOB));
        $replacenumberhp = Utils::hp($nohp);

            $method2 = "POST"; 
            $urlAddSatuan = "register"; 
            $name  = $PatientName;
            $email  = $email;
            $password  = $dob_converted;
            //$password_confirmation  = "26061990";
            $password_confirmation  = $dob_converted;
            $nomr  = $nomr;
            $username  = $nomr;
            $phone_no  = $replacenumberhp;
            $nomor_hp_converted = substr_replace($phone_no,"0",0,3);
                    //data
            $dataMedrec = '{
                "name" : "'.$name.'",
                "email" : "'.$email.'",
                "password" : "'.$password.'", 
                "password_confirmation" : "'.$password_confirmation.'",
                "phone_no" : "'.$nomor_hp_converted.'",
                "nomr" : "'.$nomr.'",
                "username" : "'.$nomr.'",
                "maternaprogram" : "0",
                "level" : "patient",
                "tgllahiran" : "0000-01-01",
                "tgllahiran_nifas" : "0000-01-01",
                "days_nifas" : "0",
                "days_nifas_complete" : "0"
            }';
        $headerwithtoken = array(
            'Content-Type: application/json'
        );
        $postdata = $this->curl_request_mobile($headerwithtoken, $method2, $dataMedrec, $urlAddSatuan);
        if ($postdata['status'] == "1") { // sukses 
            //send wa official rs yarsi 
            $replacenumberhp = Utils::hp($phone_no);
            $replacenumberhpDokter = Utils::hp($phone_no);
            $gettoken = $this->getTokenWapin();
            $this->sendNotifWapin(
                $gettoken,
                $replacenumberhp,
                $nomr,
                $password
            );
            $callback = array(
                'status' => 'success',
                'message' => "Data Berhasil di Buat. Silahkan check Whatsapp pasien.",
            );
        } elseif ($postdata['status'] == "0") { // gagal 
            $callback = array(
                'status' => 'danger',
                'message' => $postdata['message'],
            );
        }
        return $callback;
    }
    public function getTokenWapin()
    {
        $curl = curl_init();
        $wapinx = base64_encode("0410:59bae544f683769ea73951ac0d483ea6e60f65e5");
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.wappin.id/v1/token/get',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Basic ' . $wapinx
            ),
        ));
        $response = curl_exec($curl);
        $JsonData = json_decode($response, TRUE);
        curl_close($curl);
        return $JsonData['data']['access_token'];
    }
    public function sendNotifWapin($token, $NoHandphone, $param1, $param2)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.wappin.id/v1/message/do-send-hsm',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '
                {
                    "client_id": "0410",
                    "project_id": "2805",
                    "type": "mobile_signup",
                    "recipient_number": "' . $NoHandphone . '",
                    "language_code": "id",
                    "params": {
                                    "1" : "' . $param1 . '",
                                    "2" : "' . $param2 . '" 
                    }
                }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token
            ),
        ));
        $response = curl_exec($curl);
        $JsonData = json_decode($response, TRUE);
        curl_close($curl);
        return $JsonData;
    }
    public function GetMedicalRecordbyNoReg($data)
    {
        try {
            $idTrsMr = $data['q'];

            $this->db->query("SELECT replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as Date_of_birthx,
                                b.NoMR,PatientName,Address,Gander,BirthPlace,b.Ocupation,
                                case when Gander='L' then 'LAKI-LAKI' when Gander='P' then 'PEREMPUAN'  END AS NamaGander,
                                ID_Card_number,[E-mail Address] as email,[Mobile Phone] as mobilephone,[Home Phone] as homephone,b.*,a.NoSEP
                                ,c.NamaCOB, a.Notes
                                from PerawatanSQL.dbo.Visit a
                                inner join MasterDataSQL.dbo.Admision b on a.NoMR=b.NoMR
                                left join MasterdataSQL.dbo.MasterCOB c
								on c.ID = a.KodeJaminanCOB
                                where NoRegistrasi=:idTrsMr
                                UNION ALL
                                SELECT replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as Date_of_birthx,
                                b.NoMR,PatientName,Address,Gander,BirthPlace,b.Ocupation,
                                case when Gander='L' then 'LAKI-LAKI' when Gander='P' then 'PEREMPUAN'  END AS NamaGander,
                                ID_Card_number,[E-mail Address] as email,[Mobile Phone] as mobilephone,[Home Phone] as homephone,b.*,a.NoSEP
                                ,c.NamaCOB, a.Note as Notes
                                from RawatInapSQL.dbo.Inpatient a
                                inner join MasterDataSQL.dbo.Admision b on a.NoMR=b.NoMR
                                left join MasterdataSQL.dbo.MasterCOB c
								on c.ID = a.KodeJaminanCOB
                                where NoRegRI=:idTrsMr2
                                ");
            $this->db->bind('idTrsMr', $idTrsMr);
            $this->db->bind('idTrsMr2', $idTrsMr);
            $data =  $this->db->single();

            $callback = array(
                'status' => 'success', // Set array status dengan success
                'ID' => $data['ID'], // Set array status dengan success
                'NamaCOB' => $data['NamaCOB'], // Set array status dengan success
                'Notes' => $data['Notes'], // Set array status dengan success
                'NoMR' => $data['NoMR'], // Set array status dengan success
                'PatientName' => $data['PatientName'], // Set array status dengan success
                'ID_Card_number' => $data['ID_Card_number'], // Set array status dengan success
                'NoPesertaBPJS' => $data['NoPesertaBPJS'], // Set array status dengan success
                'Gander' => $data['Gander'], // Set array status dengan success
                'Date_of_birth' => $data['Date_of_birthx'], // Set array status dengan successDate_of_birth
                'Address' => $data['Address'], // Set array status dengan successDate_of_birth
                'NamaGander' => $data['NamaGander'], // Set array status dengan successDate_of_birth
                'BirthPlace' => $data['BirthPlace'], // Set array status dengan successDate_of_birth
                'Ocupation' => $data['Ocupation'], // Set array status dengan successDate_of_birth
                'email' => $data['email'], // Set array status dengan successDate_of_birth
                'mobilephone' => $data['mobilephone'], // Set array status dengan successDate_of_birth
                'homephone' => $data['homephone'], // Set array status dengan successDate_of_birth

                'Ocupation' => $data['Ocupation'],
                'Medical_Provinsi' => $data['State/Province'],
                'Medrec_Warganegara' => $data['Country/Region'],
                'Medical_Agama' => $data['Religion'],

                'Medrec_statusNikah' => $data['Marital_status'],
                'Medrec_Pendidikan' => $data['Education'],
                'Mother' => $data['Mother'],
                'kodepos' => $data['ZIP/Postal Code'],

                'Bahasa' => $data['Bahasa'],
                'Tipe_Idcard' => $data['Tipe_Idcard'],
                'Etnis' => $data['Etnis'],
                'Medrec_Kecamatan' => $data['Kecamatan'],
                'Medrec_kabupaten' => $data['City'],
                'Medrec_Kelurahan' => $data['Kelurahan'],
                'NoSEP' => $data['NoSEP'],
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

    public function GetDataPasienbyIDODC($data)
    {
        try {
            $idodc = $data['idodc'];
            $tabel = "MasterDataSQL.dbo.Admision";
            if (isset($_POST['iswalkin'])) {
                $iswalkin = $data['iswalkin'];
                if ($iswalkin == 'WALKIN') {
                    $tabel = "MasterDataSQL.dbo.Admision_walkin";
                }
            }


            $this->db->query("SELECT replace(CONVERT(VARCHAR(11), a.Date_of_birth, 111), '/','-') as Date_of_birthx,
                            a.NoMR,a.PatientName,a.Address  as almt,a.Gander,a.BirthPlace,a.Ocupation,
                            case when Gander='L' then 'LAKI-LAKI' when Gander='P' then 'PEREMPUAN'  END AS NamaGander,
                            ID_Card_number,[Country/Region] as warganegaara,[State/Province] as provinsi,a.[Home Phone] as notlprumah,
                            a.[Mobile Phone] as mobile,a.[E-mail Address] as email,Mother,[ZIP/Postal Code] as kodepos,NoMR_IBU,
                            Contact_Name,CONTACT_PHONE,Contact_Address,CONTACT_STATUS,
                            Office_Name,Office_Address,Office_Fax,Office_Phone
                            ,c.[First Name] as PetugasUpdate,UpdateDate,InputDate,
                            b.[First Name] as PetugasInput,
                            a.ID,
                            NoPesertaBPJS,
Bahasa,
Tipe_Idcard,
Etnis,
City,
Kecamatan,
Kelurahan,
Religion,
Marital_status,
Education,
Aktif,
Father,
o.NoRegistrasi
                            from $tabel a 
                            INNER JOIN MedicalRecord.dbo.MR_PermintaanRawat_ODC o on a.NoMR collate Latin1_General_CI_AS=o.NoMR
                            left join MasterdataSQL.dbo.Employees b on a.Petugas_Input = b.NoPIN
                            left join MasterdataSQL.dbo.Employees c on a.Petugas_Update = c.NoPIN
                            where o.ID=:idodc");
            $this->db->bind('idodc', $idodc);
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success',
                'ID' => $data['ID'],
                'NoMR' => $data['NoMR'],
                'PatientName' => $data['PatientName'],
                'ID_Card_number' => $data['ID_Card_number'],
                'NoPesertaBPJS' => $data['NoPesertaBPJS'],
                'Gander' => $data['Gander'],
                'Date_of_birth' => $data['Date_of_birthx'],
                'Address' => $data['almt'],
                'NamaGander' => $data['NamaGander'],
                'BirthPlace' => $data['BirthPlace'],
                'Bahasa' => $data['Bahasa'],
                'Tipe_Idcard' => $data['Tipe_Idcard'],
                'Etnis' => $data['Etnis'],
                'Medical_Provinsi' => $data['provinsi'],
                'Medrec_kabupaten' => $data['City'],
                'Medrec_Kecamatan' => $data['Kecamatan'],
                'Medrec_Kelurahan' => $data['Kelurahan'],
                'Medrec_Warganegara' => $data['warganegaara'],
                'Medrec_handphone' => $data['mobile'],
                'Medrec_HomePhone' => $data['notlprumah'],
                'Medical_Agama' => $data['Religion'],
                'Medrec_statusNikah' => $data['Marital_status'],
                'Medrec_Pendidikan' => $data['Education'],
                'Medrec_Email' => $data['email'],
                'Medrec_Status' => $data['Aktif'],
                'Ocupation' => $data['Ocupation'],
                'Mother' => $data['Mother'],
                'kodepos' => $data['kodepos'],
                'NoMR_IBU' => $data['NoMR_IBU'],
                'Contact_Name' => $data['Contact_Name'],
                'CONTACT_PHONE' => $data['CONTACT_PHONE'],
                'Contact_Address' => $data['Contact_Address'],
                'CONTACT_STATUS' => $data['CONTACT_STATUS'],
                'Office_Name' => $data['Office_Name'],
                'Office_Address' => $data['Office_Address'],
                'Office_Fax' => $data['Office_Fax'],
                'Office_Phone' => $data['Office_Phone'],
                'Petugas_Update' => $data['PetugasUpdate'],
                'UpdateDate' => $data['UpdateDate'],
                'petugasinput' => $data['PetugasInput'],
                'jaminput' => $data['InputDate'],
                'Father' => $data['Father'],
                'NoRegistrasi' => $data['NoRegistrasi'],
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
