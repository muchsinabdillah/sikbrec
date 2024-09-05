<?php
class  B_Create_Registrasi_Ranap
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }




    public function getDataListLmaPasien_old()
    {
        try {
            //$tglawal = $data['TglAwal'];
            //$tglakhir = $data['TglAkhir'];
            $this->db->query("SELECT top 100 * FROM (SELECT DokterDPJP,JenisRawat, a.NoEpisode,a.NoRegistrasi,a.NoMR,PatientName,case when a.datecreate is not null then a.datecreate else replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') end as VisitDate,NamaDokter,op.NamaPerusahaan,a.[Status Name] as Status ,a.IDSpr,x.NoSEP
            from MedicalRecord.dbo.View_PermintaanRawat  a
            LEFT join MasterdataSQL.dbo.MstrTypePatient d
            on d.ID = PatientType
            left join MasterdataSQL.dbo.MstrPerusahaanAsuransi op on op.ID = a.Asuransi
            inner join PerawatanSQL.dbo.Visit x on a.NoRegistrasi=x.NoRegistrasi
            where  d.TypePatient='ASURANSI' and (x.NoRegRI is null or x.NoRegRI = '')
            --and replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') Between :TglAwal1 AND :TglAkhir1
            union all
            select DokterDPJP,JenisRawat, a.NoEpisode,a.NoRegistrasi,a.NoMR,PatientName,case when a.datecreate is not null then a.datecreate else replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') end as VisitDate,NamaDokter,op.NamaPerusahaan,
            a.[Status Name] as Status ,a.IDSpr,x.NoSEP
            from MedicalRecord.dbo.View_PermintaanRawat  a
            LEFT join MasterdataSQL.dbo.MstrTypePatient d
            on d.ID = PatientType
            left join MasterdataSQL.dbo.MstrPerusahaanJPK op on op.ID = a.Perusahaan
            inner join PerawatanSQL.dbo.Visit x on a.NoRegistrasi=x.NoRegistrasi
            where   d.TypePatient<>'ASURANSI' and (x.NoRegRI is null or x.NoRegRI = '')
            ) x order by VisitDate desc
           -- and replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') 
            --Between :TglAwal2 AND :TglAkhir2
             ");
            // $this->db->bind('TglAwal1', $tglawal);
            //$this->db->bind('TglAkhir1', $tglakhir);
            // $this->db->bind('TglAwal2', $tglawal); 
            // $this->db->bind('TglAkhir2', $tglakhir); 
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['DokterDPJP'] = $key['DokterDPJP'];
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['PatientName'] = $key['PatientName'];
                $pasing['JenisRawat'] = $key['JenisRawat'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['VisitDate'] = date('d/m/Y H:i:s', strtotime($key['VisitDate']));
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
    public function getDataListLmaPasien()
    {
        try {
            $sql_details = array(
                'user' => DB_USER,
                'pass' => DB_PASSWORD,
                'db'   => DB_NAME,
                'host' => DB_HOST
            );
            $table = <<<EOT
 (SELECT [Status Name] as status_name,*FROM MedicalRecord.DBO.View_PermintaanRawat_2024) temp
EOT;

            // Table's primary key
            $primaryKey = 'IDSpr';

            // Array of database columns which should be read and sent back to DataTables.
            // The `db` parameter represents the column name in the database, while the `dt`
            // parameter represents the DataTables column identifier. In this case simple
            // indexes
            $columns = array(

                array('db' => 'DokterDPJP', 'dt' => 'DokterDPJP'),
                array('db' => 'NoMR',  'dt' => 'NoMR'),
                array('db' => 'PatientName',     'dt' => 'PatientName'),
                // array('db' => 'JenisRawat',     'dt' => 'JenisRawat'),
                array('db' => 'NoRegistrasi',   'dt' => 'NoRegistrasi'),
                array('db' => 'VisitDate',     'dt' => 'VisitDate'),
                array('db' => 'DokterPemeriksa',     'dt' => 'DokterPemeriksa'),
                array('db' => 'NamaPerusahaan',     'dt' => 'NamaPerusahaan'),
                array('db' => 'status_name',     'dt' => 'status_name'),
                array('db' => 'IDSpr',     'dt' => 'IDSpr'),
                array('db' => 'NoSEP',     'dt' => 'NoSEP')

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
    public function getDataListPasienRawat_old()
    {
        try {
            // $this->db->query("SELECT *, replace(CONVERT(VARCHAR(11), StartDate, 111), '/','-')AS VisitDate,  
            // CASE WHEN TypePatient = 1 THEN 'UMUM'
            //      WHEN TypePatient = 2 THEN Asuransi
            //      WHEN TypePatient = 5 THEN JPK
            //      ELSE NULL
            //      END AS NamaPerusahaan FROM RawatInapSQL.dbo.View_PasienRawat 
            //  "); 
            $this->db->query("SELECT InpatientID,a.NoMR,a.NoRegRI,c.PatientName,replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as VisitDate,b.First_Name as NamaDokter,d.Class,d.RoomName as nama_room,d.Bed as tmpt_tidur,e.NamaPerusahaan,f.NamaCOB,a.NoSEP,g.[Status Name],a.JenisRawat,CONVERT(VARCHAR(8),a.StartTime,114) as StartTime
                             FROM RawatInapSQL.DBO.Inpatient a
                             INNER JOIN MasterdataSQL.dbo.Doctors b on a.drPenerima=b.ID
                             INNER JOIN MasterdataSQL.dbo.Admision c on a.NoMR=c.NoMR
                             --LEFT JOIN RawatInapSQL.dbo.Inpatient_in_out d on a.RoomID_Akhir=d.ID
                             OUTER APPLY (
                             SELECT Class,RoomName,Bed FROM RawatInapSQL.dbo.Inpatient_in_out WHERE NoRegRI=a.NoRegRI AND StatusActive='1'
                             ) d
                             INNER JOIN MasterdataSQL.dbo.MstrPerusahaanJPK e on a.IDJPK=e.ID
                             LEFT JOIN MasterdataSQL.dbo.MasterCOB f on a.KodeJaminanCOB=f.ID
                             INNER JOIN RawatInapSQL.dbo.[Visit Status] g on a.StatusID=g.[Status ID]
                             WHERE StatusID<>'4' AND TypePatient<>'2'
                             UNION ALL
                             SELECT InpatientID,a.NoMR,a.NoRegRI,c.PatientName,replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as VisitDate,b.First_Name as NamaDokter,d.Class,d.RoomName as nama_room,d.Bed as tmpt_tidur,e.NamaPerusahaan,f.NamaCOB,a.NoSEP,g.[Status Name],a.JenisRawat,CONVERT(VARCHAR(8),a.StartTime,114) as StartTime
                             FROM RawatInapSQL.DBO.Inpatient a
                             INNER JOIN MasterdataSQL.dbo.Doctors b on a.drPenerima=b.ID
                             INNER JOIN MasterdataSQL.dbo.Admision c on a.NoMR=c.NoMR
                             --LEFT JOIN RawatInapSQL.dbo.Inpatient_in_out d on a.RoomID_Akhir=d.ID
                               OUTER APPLY (
                             SELECT Class,RoomName,Bed FROM RawatInapSQL.dbo.Inpatient_in_out WHERE NoRegRI=a.NoRegRI AND StatusActive='1'
                             ) d
                             INNER JOIN MasterdataSQL.dbo.MstrPerusahaanAsuransi e on a.IDAsuransi=e.ID
                             LEFT JOIN MasterdataSQL.dbo.MasterCOB f on a.KodeJaminanCOB=f.ID
                             INNER JOIN RawatInapSQL.dbo.[Visit Status] g on a.StatusID=g.[Status ID]
                             WHERE StatusID<>'4' AND TypePatient='2'
                             ORDER BY VisitDate DESC
            ");
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $row) {
                $nosep = '';
                if ($row['NoSEP'] != null || $row['NoSEP'] != '') {
                    $nosep = '(<b>No SEP: ' . $row['NoSEP'] . '</b>)';
                }
                $pasing['JenisRawat'] = $row['JenisRawat'];
                $pasing['NoMR'] = $row['NoMR'];
                $pasing['PatientName'] = $row['PatientName'];
                // $pasing['JenisRawat'] = $row['JenisRawat'];
                $pasing['NoRegistrasi'] = $row['NoRegRI'];
                $pasing['VisitDate'] = date('d/m/Y', strtotime($row['VisitDate'])) . ' ' . date('H:i:s', strtotime($row['StartTime']));
                $pasing['NamaDokter'] = $row['NamaDokter'];
                $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                //$namastatus = $row['Status Name'];
                // $status = '<span class="label label-success">'.$namastatus.'</span>';
                $pasing['Status'] = $row['Status Name'];
                $pasing['InpatientID'] = $row['InpatientID'];
                $pasing['NoSEP'] = $nosep;
                $pasing['NoSEP_raw'] = $row['NoSEP'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataListPasienRawat()
    {
        try {


            $sql_details = array(
                'user' => DB_USER,
                'pass' => DB_PASSWORD,
                'db'   => DB_NAME,
                'host' => DB_HOST
            );
            $table = <<<EOT
 (SELECT InpatientID,a.NoMR,a.NoRegRI,c.PatientName,replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as VisitDate,b.First_Name as NamaDokter,d.Class,d.RoomName as nama_room,d.Bed as tmpt_tidur,e.NamaPerusahaan,f.NamaCOB,a.NoSEP,g.[Status Name] as status_name,a.JenisRawat,CONVERT(VARCHAR(8),a.StartTime,114) as StartTime
                             FROM RawatInapSQL.DBO.Inpatient a
                             INNER JOIN MasterdataSQL.dbo.Doctors b on a.drPenerima=b.ID
                             INNER JOIN MasterdataSQL.dbo.Admision c on a.NoMR=c.NoMR
                             --LEFT JOIN RawatInapSQL.dbo.Inpatient_in_out d on a.RoomID_Akhir=d.ID
                             OUTER APPLY (
                             SELECT Class,RoomName,Bed FROM RawatInapSQL.dbo.Inpatient_in_out WHERE NoRegRI=a.NoRegRI AND StatusActive='1'
                             ) d
                             INNER JOIN MasterdataSQL.dbo.MstrPerusahaanJPK e on a.IDJPK=e.ID
                             LEFT JOIN MasterdataSQL.dbo.MasterCOB f on a.KodeJaminanCOB=f.ID
                             INNER JOIN RawatInapSQL.dbo.[Visit Status] g on a.StatusID=g.[Status ID]
                             WHERE StatusID<>'4' AND TypePatient<>'2'
                             UNION ALL
                             SELECT InpatientID,a.NoMR,a.NoRegRI,c.PatientName,replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as VisitDate,b.First_Name as NamaDokter,d.Class,d.RoomName as nama_room,d.Bed as tmpt_tidur,e.NamaPerusahaan,f.NamaCOB,a.NoSEP,g.[Status Name] as status_name,a.JenisRawat,CONVERT(VARCHAR(8),a.StartTime,114) as StartTime
                             FROM RawatInapSQL.DBO.Inpatient a
                             INNER JOIN MasterdataSQL.dbo.Doctors b on a.drPenerima=b.ID
                             INNER JOIN MasterdataSQL.dbo.Admision c on a.NoMR=c.NoMR
                             --LEFT JOIN RawatInapSQL.dbo.Inpatient_in_out d on a.RoomID_Akhir=d.ID
                               OUTER APPLY (
                             SELECT Class,RoomName,Bed FROM RawatInapSQL.dbo.Inpatient_in_out WHERE NoRegRI=a.NoRegRI AND StatusActive='1'
                             ) d
                             INNER JOIN MasterdataSQL.dbo.MstrPerusahaanAsuransi e on a.IDAsuransi=e.ID
                             LEFT JOIN MasterdataSQL.dbo.MasterCOB f on a.KodeJaminanCOB=f.ID
                             INNER JOIN RawatInapSQL.dbo.[Visit Status] g on a.StatusID=g.[Status ID]
                             WHERE StatusID<>'4' AND TypePatient='2' ) temp
EOT;

            // Table's primary key
            $primaryKey = 'InpatientID';

            // Array of database columns which should be read and sent back to DataTables.
            // The `db` parameter represents the column name in the database, while the `dt`
            // parameter represents the DataTables column identifier. In this case simple
            // indexes
            $columns = array(

                array('db' => 'InpatientID', 'dt' => 'InpatientID'),
                array('db' => 'NoMR',  'dt' => 'NoMR'),
                array('db' => 'PatientName',     'dt' => 'PatientName'),
                array('db' => 'VisitDate',     'dt' => 'VisitDate'),
                array('db' => 'NoRegRI',   'dt' => 'NoRegistrasi'),
                array('db' => 'status_name',     'dt' => 'Status'),
                array('db' => 'NamaDokter',     'dt' => 'NamaDokter'),
                array('db' => 'JenisRawat',     'dt' => 'JenisRawat'),
                array('db' => 'NamaPerusahaan',     'dt' => 'NamaPerusahaan'),
                array('db' => 'JenisRawat',     'dt' => 'NoSEP_raw'),
                array('db' => 'JenisRawat',     'dt' => 'NoSEP_raw')

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

    public function getStatusRegRajal($id)
    {
        try {
            $this->db->query("SELECT NoRegistrasi from MedicalRecord.dbo.MR_PermintaanRawat  WHERE ID=:id ");
            $this->db->bind('id', $id);
            $data =  $this->db->single();
            $noreg = $data['NoRegistrasi'];

            $datenowForSPR = date('ddmmYY');

            $getch = str_split($noreg, 4);
            $check = $getch[1];

            // if ($datenowForSPR == $check){
            //     $this->db->query("SELECT [Status ID] AS ST_pasien FROM PerawatanSQL.dbo.Visit WHERE NoRegistrasi=:noreg");
            //     $this->db->bind('noreg', $noreg);
            //     $data =  $this->db->single();
            //     $ST_pasien = $data['ST_pasien']; 

            //     if($ST_pasien == "4" ) { 
            //         $callback = array(    
            //             'status' => 'warning',
            //             'errorname' => 'Registrasi Rajal/IGD sudah di Close, silahkan buka Kembali  !', 
            //         );
            //         return $callback;
            //         exit;
            //     }
            // }

            // else{
            //     $this->db->query("SELECT [Status ID] AS ST_pasien FROM PerawatanSQL.dbo.Visit WHERE NoRegistrasi=:noreg");
            //     $this->db->bind('noreg', $noreg);
            //     $data =  $this->db->single();
            //     $ST_pasien = $data['ST_pasien']; 

            //     if($ST_pasien == "4" ) { 
            //         $callback = array(    
            //             'status' => 'warning',
            //             'errorname' => 'Registrasi Rajal/IGD sudah di Close, silahkan buka Kembali  !', 
            //         );
            //         return $callback;
            //         exit;
            //     }

            // }


            $callback = array(
                'status' => "success",
                'idspr' => $id,
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

    public function getDataSPRDetail($data)
    {
        try {
            $id = $data['id'];
            $noregri = $data['noregri'];
            if (isset($data['NoMR'])) {
                $NoMR = $data['NoMR'];
            } else {
                $NoMR = null;
            }
            $getch = str_split($noregri, 2);
            $check = $getch[0];
            if ($check == 'RI') {
                $this->db->query("SELECT e.NoRegistrasi,e.Id,a.NoMR,a.JenisRawat,e.DokterDPJP,b.PatientName,
                replace(CONVERT(VARCHAR(11), b.Date_of_birth, 111), '/','-') as DOB,b.ID_Card_number,b.Address,a.drPenerima as 'ID_Dokter',a.NoRegRI,a.NoEpisode,d.NoEpisode as 'noepisode_rwj',
                CASE WHEN TypePatient=2 THEN IDAsuransi
                else  IDJPK
                END AS idperusahaan,a.TypePatient,a.idCaraMasuk,a.idCaraMasuk2,a.paket_operasi as Paket,a.KlsID,a.NoSEP
                , replace(CONVERT(VARCHAR(11), d.TglKunjungan, 111), '/','-') as TglKunjungan,a.Catatan as Note,a.KodeJaminanCOB,'REGIST_EXIST' as Kategori,b.Gander,b.BirthPlace
                FROM RawatInapSQL.dbo.Inpatient a 
                inner join MasterdataSQL.dbo.Admision b on a.NoMR 
                collate Latin1_General_CS_AS=b.NoMR collate Latin1_General_CS_AS 
                left join MasterdataSQL.dbo.Doctors c on c.ID = a.drPenerima
                left join PerawatanSQL.dbo.Visit d on a.NoRegRI=d.NoRegRI
                left join MedicalRecord.dbo.MR_PermintaanRawat e on d.NoRegistrasi collate SQL_Latin1_General_CP1_CI_AS=e.NoRegistrasi collate SQL_Latin1_General_CP1_CI_AS
                where a.NoRegRI=:noregri ");
                $this->db->bind('noregri', $noregri);
            } elseif ($NoMR != null || $NoMR != '') {
                $this->db->query("SELECT a.ID as ID_PermintaanBayi,b.ID as ID_DPJP,Ruang_Rawat_Tujuan_Bayi
                from MedicalRecord.dbo.MR_PermintaanMR_Bayi a
                left join MasterDataSQL.dbo.Doctors b on a.DokterDPJP_Bayi collate Latin1_General_CI_AS = b.First_Name
                where a.ID=:id");
                $this->db->bind('id', $id);
                $data =  $this->db->single();
                $pasing['ID_PermintaanBayi'] = $data['ID_PermintaanBayi'];
                $pasing['ID_DPJP'] = $data['ID_DPJP'];
                $pasing['Ruang_Rawat_Tujuan_Bayi'] = $data['Ruang_Rawat_Tujuan_Bayi'];

                $datenowcreate = Utils::datenowcreateNotFull();
                $this->db->query("SELECT '' NoRegistrasi,'' Id,NoMR,'' JenisRawat,'' DokterDPJP,PatientName,
                replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as DOB,ID_Card_number,Address,
                '' as 'ID_Dokter','' NoRegRI,'' NoEpisode,'' as noepisode_rwj,'' as idperusahaan,
                '' as TypePatient,'' as idCaraMasuk,'' as idCaraMasuk2,'' as Paket,'' as KlsID,'' as NoSEP
                , '$datenowcreate' as TglKunjungan,'' as Note,'' as KodeJaminanCOB,'BBL' as Kategori,Gander,BirthPlace
                FROM MasterDataSQL.dbo.Admision 
                where NoMR=:NoMR");
                $this->db->bind('NoMR', $NoMR);
            } else {
                $this->db->query("SELECT a.NoRegistrasi,a.Id,a.NoMR,a.JenisRawat,a.DokterDPJP,b.PatientName,
                replace(CONVERT(VARCHAR(11), b.Date_of_birth, 111), '/','-') as DOB,b.ID_Card_number,b.Address,
                c.ID as 'ID_Dokter',e.NoRegRI,e.NoEpisode,d.NoEpisode as noepisode_rwj,'' as idperusahaan,
                '' as TypePatient,'' as idCaraMasuk,'' as idCaraMasuk2,'' as Paket,'' as KlsID,d.nosep as NoSEP
                , replace(CONVERT(VARCHAR(11), d.TglKunjungan, 111), '/','-') as TglKunjungan,'' as Note,'' as KodeJaminanCOB,'SPR' as Kategori,b.Gander,b.BirthPlace
                FROM MedicalRecord.dbo.MR_PermintaanRawat a 
                inner join MasterdataSQL.dbo.Admision b on a.NoMR collate Latin1_General_CS_AS=b.NoMR collate Latin1_General_CS_AS
                left join MasterdataSQL.dbo.Doctors c on a.DokterDPJP collate Latin1_General_CS_AS=c.First_Name collate Latin1_General_CS_AS
                inner join PerawatanSQL.dbo.Visit d on a.NoRegistrasi collate Latin1_General_CS_AS=d.NoRegistrasi collate Latin1_General_CS_AS
                left join RawatInapSQL.dbo.Inpatient e on d.NoRegRI=e.NoRegRI
                where a.Id=:id");
                $this->db->bind('id', $id);
            }

            $data =  $this->db->single();
            $pasing['ID'] = $data['Id'];
            $pasing['NoMR'] = $data['NoMR'];
            $pasing['Note'] = $data['Note'];
            $pasing['PatientName'] = $data['PatientName'];
            $pasing['JenisRawat'] = $data['JenisRawat'];
            $pasing['DokterDPJP'] = $data['DokterDPJP'];
            $pasing['ID_Card_number'] = $data['ID_Card_number'];
            $pasing['Address'] = $data['Address'];
            $pasing['noepisode_rwj'] = $data['noepisode_rwj'];
            $pasing['NoRegistrasi'] = $data['NoRegistrasi'];
            $pasing['TglKunjungan'] = $data['TglKunjungan'];
            $pasing['NoEpisode'] = $data['NoEpisode'];
            $pasing['NoRegRI'] = $data['NoRegRI'];
            $pasing['ID_Dokter'] = $data['ID_Dokter'];
            $pasing['DOB'] = date('d/m/Y', strtotime($data['DOB']));
            $pasing['DOB_RAW'] = $data['DOB'];
            $pasing['idperusahaan'] = $data['idperusahaan'];
            $pasing['TypePatient'] = $data['TypePatient'];
            $pasing['idCaraMasuk'] = $data['idCaraMasuk'];
            $pasing['idCaraMasuk2'] = $data['idCaraMasuk2'];
            $pasing['Paket'] = $data['Paket'];
            $pasing['KlsID'] = $data['KlsID'];
            $pasing['NoSEP'] = $data['NoSEP'];
            $pasing['KodeJaminanCOB'] = $data['KodeJaminanCOB'];
            $pasing['Kategori'] = $data['Kategori'];
            $pasing['Gander'] = $data['Gander'];
            $pasing['BirthPlace'] = $data['BirthPlace'];
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

    //badrul
    public function GetregistrasiRanapbyNoRegistrasi($data)
    {
        try {
            $noregri = $data['noregri'];
            $this->db->query("SELECT a.ID_Paket, a.NoMR, a.NoRegRI, a.NoEpisode, a.KlsID, a.drPenerima, d.First_Name, replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as SDATE ,b.PatientName, c.NamaKelas, 
            replace(CONVERT(VARCHAR(11), b.Date_of_birth, 111), '/','-') as DOB, b.Gander, b.Address, a.TypePatient, e.ID, f.KodeLokasi, f.Room, g.NamaPerusahaan from RawatInapSQL.dbo.Inpatient a 
                        inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR 
                        inner join RawatInapSQL.dbo.TblKelas c on c.IDkelas = a.KlsID
                        inner join MasterdataSQL.dbo.Doctors d on d.ID = a.drPenerima
                        inner join RawatInapSQL.dbo.Inpatient_in_out e on e.ID = a.RoomID_Akhir
                        inner join MasterdataSQL.dbo.MstrRoomID f on f.RoomID = e.RoomID
                        inner join MasterdataSQL.dbo.MstrPerusahaanJPK g on g.ID = a.IDJPK
                        where a.NoRegRI= :noregri");
            $this->db->bind('noregri', $noregri);

            $data =  $this->db->single();
            $pasing['ID_Paket'] = $data['ID_Paket'];
            $pasing['NoRegRI'] = $data['NoRegRI'];
            $pasing['NoMR'] = $data['NoMR'];
            $pasing['NoEpisode'] = $data['NoEpisode'];
            $pasing['SDATE'] = $data['SDATE'];
            $pasing['DOB'] = $data['DOB'];
            $pasing['PatientName'] = $data['PatientName'];
            $pasing['KlsID'] = $data['KlsID'];
            $pasing['NamaKelas'] = $data['NamaKelas'];
            $pasing['drPenerima'] = $data['drPenerima'];
            $pasing['First_Name'] = $data['First_Name'];
            $pasing['Gander'] = $data['Gander'];

            $pasing['Address'] = $data['Address'];
            $pasing['TypePatient'] = $data['TypePatient'];
            $pasing['KodeLokasi'] = $data['KodeLokasi'];
            $pasing['Room'] = $data['Room'];
            $pasing['NamaPerusahaan'] = $data['NamaPerusahaan'];
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

    public function GetpaketOperasibyNoRegistrasi($data)
    {
        try {
            $noregri = $data['noregri'];
            $this->db->query("SELECT a.id, b.id_paket, a.harga, b.nama_paket from RawatInapSQL.dbo.Inpatient_Paket_Operasi a
            inner join PerawatanSQL.dbo.Tarif_Paket_Operasi b on a.id_paket = b.id_paket
            where a.NoRegistrasi = :noregri");
            $this->db->bind('noregri', $noregri);

            $data =  $this->db->single();

            $pasing['id'] = $data['id'];
            $pasing['id_paket'] = $data['id_paket'];
            $pasing['harga'] = $data['harga'];
            $pasing['nama_paket'] = $data['nama_paket'];
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

    public function getPaketRanap()
    {

        try {
            $datenowcreate = Utils::datenowcreateNotFull();
            // var_dump($datenowcreate);
            // exit;
            $query = "SELECT id_paket,nama_paket,nilai_paket from PerawatanSQL.dbo.Tarif_Paket_Operasi 
            where '$datenowcreate' between tgl_berlaku and tgl_expired and aktif='1' and Approve='0'
            ORDER BY 1 DESC";
            //$this->db->bind('datenowcreate', $datenowcreate);
            $this->db->query($query);
            $this->db->execute();
            $data = $this->db->resultSet();
            $rows = array();

            foreach ($data as $key) {
                $pasing['id_paket'] = $key['id_paket'];
                $pasing['nama_paket'] = $key['nama_paket'];
                $pasing['nilai_paket'] = $key['nilai_paket'];
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

    public function getPaketRI($data)
    {
        // var_dump($data);
        // exit;
        try {
            $this->db->transaksi();
            $IdPaket = $data['IdPaket'];
            $IdKelas = $data['hakkelas'];
            if ($IdKelas == '3') {
                // var_dump('hak kelas III');
                $query = "SELECT id_paket, nama_paket, nilai_paket from PerawatanSQL.dbo.Tarif_Paket_Operasi
                where id_paket=:IdPaket";

                $this->db->query($query);
                $this->db->bind('IdPaket', $IdPaket);
                $this->db->execute();
                $data = $this->db->single();

                $pasing['id_paket'] = $data['id_paket'];
                $pasing['nama_paket'] = $data['nama_paket'];
                $pasing['tarif_paket'] = $data['nilai_paket'];
            } elseif ($IdKelas === '2') {
                // var_dump('hak kelas II');
                $query = "SELECT id_paket, nama_paket, nilai_paket_kelas2 from PerawatanSQL.dbo.Tarif_Paket_Operasi
                where id_paket=:IdPaket";

                $this->db->query($query);
                $this->db->bind('IdPaket', $IdPaket);
                $this->db->execute();
                $data = $this->db->single();

                $pasing['id_paket'] = $data['id_paket'];
                $pasing['nama_paket'] = $data['nama_paket'];
                $pasing['tarif_paket'] = $data['nilai_paket_kelas2'];
            } elseif ($IdKelas == '1') {
                // var_dump('hak kelas Deluxe');
                $query = "SELECT id_paket, nama_paket, nilai_paket_kelas1 from PerawatanSQL.dbo.Tarif_Paket_Operasi
                where id_paket=:IdPaket";

                $this->db->query($query);
                $this->db->bind('IdPaket', $IdPaket);
                $this->db->execute();
                $data = $this->db->single();

                $pasing['id_paket'] = $data['id_paket'];
                $pasing['nama_paket'] = $data['nama_paket'];
                $pasing['tarif_paket'] = $data['nilai_paket_kelas1'];
            } elseif ($IdKelas == '4') {
                // var_dump('Junior Suit');
                $query = "SELECT id_paket, nama_paket, nilai_paket_JuniorS from PerawatanSQL.dbo.Tarif_Paket_Operasi
                where id_paket=:IdPaket";

                $this->db->query($query);
                $this->db->bind('IdPaket', $IdPaket);
                $this->db->execute();
                $data = $this->db->single();

                $pasing['id_paket'] = $data['id_paket'];
                $pasing['nama_paket'] = $data['nama_paket'];
                $pasing['tarif_paket'] = $data['nilai_paket_JuniorS'];
            } elseif ($IdKelas == '5') {
                // var_dump('Executive Suit');
                $query = "SELECT id_paket, nama_paket, nilai_paket_ExecutiveS from PerawatanSQL.dbo.Tarif_Paket_Operasi
                where id_paket=:IdPaket";

                $this->db->query($query);
                $this->db->bind('IdPaket', $IdPaket);
                $this->db->execute();
                $data = $this->db->single();

                $pasing['id_paket'] = $data['id_paket'];
                $pasing['nama_paket'] = $data['nama_paket'];
                $pasing['tarif_paket'] = $data['nilai_paket_ExecutiveS'];
            } elseif ($IdKelas == '6') {
                // var_dump('Presiden Suit');
                $query = "SELECT id_paket, nama_paket, nilai_paket_PresidentS from PerawatanSQL.dbo.Tarif_Paket_Operasi
                where id_paket=:IdPaket";

                $this->db->query($query);
                $this->db->bind('IdPaket', $IdPaket);
                $this->db->execute();
                $data = $this->db->single();

                $pasing['id_paket'] = $data['id_paket'];
                $pasing['nama_paket'] = $data['nama_paket'];
                $pasing['tarif_paket'] = $data['nilai_paket_PresidentS'];
            } else {
                $query = "SELECT id_paket, nama_paket, nilai_paket from PerawatanSQL.dbo.Tarif_Paket_Operasi
                where id_paket=:IdPaket";

                $this->db->query($query);
                $this->db->bind('IdPaket', $IdPaket);
                $this->db->execute();
                $data = $this->db->single();

                $pasing['id_paket'] = $data['id_paket'];
                $pasing['nama_paket'] = $data['nama_paket'];
                $pasing['tarif_paket'] = $data['nilai_paket'];
            }

            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
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


    public function getDataPaketRIDetail($data)
    {
        // var_dump($data);
        // exit;
        try {
            $idpaket = $data['idpaket'];
            $hakkelas = $data['hakkelas'];
            if ($hakkelas == '3') {
                $this->db->query("SELECT nama_item_detil, qty, nilai_item_detil, group_paket_detil FROM PerawatanSQL.dbo.Tarif_Paket_Operasi_2 where id_paket =:idpaket");
                $this->db->bind('idpaket', $idpaket);
                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['No'] = $no++;
                    $pasing['nama_item_detil'] = $row['nama_item_detil'];
                    $pasing['qty'] = $row['qty'];
                    $pasing['group_paket_detil'] = $row['group_paket_detil'];
                    $pasing['Tarif'] = number_format($row['nilai_item_detil'], 0, ",", ".");
                    $rows[] = $pasing;
                }
            } elseif ($hakkelas == '2') {
                $this->db->query("SELECT nama_item_detil, qty, nilai_paket_kelas2, group_paket_detil FROM PerawatanSQL.dbo.Tarif_Paket_Operasi_2 where id_paket =:idpaket");
                $this->db->bind('idpaket', $idpaket);
                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['No'] = $no++;
                    $pasing['nama_item_detil'] = $row['nama_item_detil'];
                    $pasing['qty'] = $row['qty'];
                    $pasing['group_paket_detil'] = $row['group_paket_detil'];
                    $pasing['Tarif'] = number_format($row['nilai_paket_kelas2'], 0, ",", ".");
                    $rows[] = $pasing;
                }
            } elseif ($hakkelas == '1') {
                $this->db->query("SELECT nama_item_detil, qty, nilai_paket_kelas1, group_paket_detil FROM PerawatanSQL.dbo.Tarif_Paket_Operasi_2 where id_paket =:idpaket");
                $this->db->bind('idpaket', $idpaket);
                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['No'] = $no++;
                    $pasing['nama_item_detil'] = $row['nama_item_detil'];
                    $pasing['qty'] = $row['qty'];
                    $pasing['group_paket_detil'] = $row['group_paket_detil'];
                    $pasing['Tarif'] = number_format($row['nilai_paket_kelas1'], 0, ",", ".");
                    $rows[] = $pasing;
                }
            } elseif ($hakkelas == '4') {
                $this->db->query("SELECT nama_item_detil, qty, nilai_paket_JuniorS, group_paket_detil FROM PerawatanSQL.dbo.Tarif_Paket_Operasi_2 where id_paket =:idpaket");
                $this->db->bind('idpaket', $idpaket);
                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['No'] = $no++;
                    $pasing['nama_item_detil'] = $row['nama_item_detil'];
                    $pasing['qty'] = $row['qty'];
                    $pasing['group_paket_detil'] = $row['group_paket_detil'];
                    $pasing['Tarif'] = number_format($row['nilai_paket_JuniorS'], 0, ",", ".");
                    $rows[] = $pasing;
                }
            } elseif ($hakkelas == '5') {
                $this->db->query("SELECT nama_item_detil, qty, nilai_paket_ExecutiveS, group_paket_detil FROM PerawatanSQL.dbo.Tarif_Paket_Operasi_2 where id_paket =:idpaket");
                $this->db->bind('idpaket', $idpaket);
                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['No'] = $no++;
                    $pasing['nama_item_detil'] = $row['nama_item_detil'];
                    $pasing['qty'] = $row['qty'];
                    $pasing['group_paket_detil'] = $row['group_paket_detil'];
                    $pasing['Tarif'] = number_format($row['nilai_paket_kelas1'], 0, ",", ".");
                    $rows[] = $pasing;
                }
            } elseif ($hakkelas == '6') {
                $this->db->query("SELECT nama_item_detil, qty, nilai_paket_PresidentS, group_paket_detil FROM PerawatanSQL.dbo.Tarif_Paket_Operasi_2 where id_paket =:idpaket");
                $this->db->bind('idpaket', $idpaket);
                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['No'] = $no++;
                    $pasing['nama_item_detil'] = $row['nama_item_detil'];
                    $pasing['qty'] = $row['qty'];
                    $pasing['group_paket_detil'] = $row['group_paket_detil'];
                    $pasing['Tarif'] = number_format($row['nilai_paket_PresidentS'], 0, ",", ".");
                    $rows[] = $pasing;
                }
            } else {
                $this->db->query("SELECT nama_item_detil, qty, nilai_item_detil, group_paket_detil FROM PerawatanSQL.dbo.Tarif_Paket_Operasi_2 where id_paket =:idpaket");
                $this->db->bind('idpaket', $idpaket);
                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['No'] = $no++;
                    $pasing['nama_item_detil'] = $row['nama_item_detil'];
                    $pasing['qty'] = $row['qty'];
                    $pasing['group_paket_detil'] = $row['group_paket_detil'];
                    $pasing['Tarif'] = number_format($row['nilai_item_detil'], 0, ",", ".");
                    $rows[] = $pasing;
                }
            }

            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function goCreateOrderPaket($data)
    {
        // var_dump($data);
        // exit;
        try {
            $this->db->transaksi();
            $datenowcreate = Utils::seCurrentDateTime();
            $namapasien = $data['NamaPasien'];
            $noregistrasi = $data['NoRegistrasi'];
            $nomr = $data['NoMR'];
            $noepisode = $data['NoEpisode'];
            $datestart = $data['DateStart'];
            $idpaketorder = $data['IdPaket1'];
            $namakelas = $data['NamaKelas'];
            $hakkelas = $data['HakKelas'];
            $idpakethdr = $data['IDPemeriksaan'];
            $namapaket = $data['namapaket'];
            $kodekelmpoklabtes = $data['Lab_kodeTes_kelompok'];
            $hargapakethdr = $data['HargaPaket'];
            $namadokter = $data['NamaDokter'];
            $iddokter = $data['IdDokter'];
            $tgllahirxx = $data['TglLahir'];
            $jeniskelaminxx = $data['JenisKelamin'];
            $datenowlis = date('dmy', strtotime($datenowcreate));

            $alamatxx = $data['Alamat'];
            $jenisbayarRWIx = $data['TipePasien'];
            $idroomakhir = $data['KodeLokasi'];
            $namaroomakhir = $data['NamaRuangan'];
            $jaminanxx = $data['NamaPerusahaan'];

            if ($jeniskelaminxx == "L") {
                $jeniskelaminxxD = "M";
            } elseif ($jeniskelaminxx == "P") {
                $jeniskelaminxxD = "F";
            }

            if ($idpaketorder != '') {
                $callback = array(
                    'status' => "danger", // Set array nama  
                    'message' => 'sudah ada paket'
                );
                return $callback;
                exit;
            }

            if ($idpakethdr == '') {
                $callback = array(
                    'status' => "danger", // Set array nama  
                    'message' => 'paket belum dipilih'
                );
                return $callback;
                exit;
            }


            if ($jenisbayarRWIx == "1") {
                $jenisbayarRWIxxd = "PRIBADI";
            } elseif ($jenisbayarRWIx == "2") {
                $jenisbayarRWIxxd = "ASURANSI";
            } elseif ($jenisbayarRWIx == "5") {
                $jenisbayarRWIxxd = "PERUSAHAAN";
            }

            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $operator =  $session->IDEmployee;

            //  INSERT INPATIENT PAKET OPERASI
            $queryInpatientPaketOperasi = "INSERT INTO RawatInapSQL.dbo.Inpatient_Paket_Operasi 
            (NoRegistrasi, NoEpisode, NoMr, Tgl_Input, Petugas_Input,id_paket,nama_paket,qty,harga,Asuransi) 
            select 
            :noregistrasi, :noepisode, :nomr, :datenowcreate, :namauserx, id_paket , nama_paket, '1',:hargapakethdr,:hargapakethdr2 
            from PerawatanSQL.dbo.Tarif_Paket_Operasi where id_paket=:idpakethdr";

            $this->db->query($queryInpatientPaketOperasi);
            $this->db->bind('noregistrasi', $noregistrasi);
            $this->db->bind('noepisode', $noepisode);
            $this->db->bind('nomr', $nomr);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('namauserx', $namauserx);
            $this->db->bind('hargapakethdr', $hargapakethdr);
            $this->db->bind('hargapakethdr2', $hargapakethdr);
            $this->db->bind('idpakethdr', $idpakethdr);
            $this->db->execute();

            // INSERT INPATIENT DETAIL
            $queryInpatientDetail = "INSERT INTO RawatInapSQL.dbo.[Inpatient Details] 
            (OrderCode, NoMR, NoEpisode, NoRegRI, Dokter, NamaDokter, Kelas, VisitDate, JamPemeriksaan, [Product ID], 
            NamaTindakan, PaketID, Quantity, [Unit Price], Discount, TotalTarif, [Status ID], Category, [Aproved Doctor],
            LokasiInput,PetugasOrder, ReviewFarmasi, Bayar, Asuransi, lockBill, FB_DISC, IncludePaket)
            SELECT 
            id_paket_detil, :nomr, :noepisode, :noregistrasi, :iddokter, :namadokter, :hakkelas, :datenowcreate, :datenowcreate2, '0', 
            nama_item_detil, :idpakethdr2, qty, '0', '0', '0', '1', 'Visite', '0', 
            Lokasi_Order_stok, :operator, '0', '0', nilai_item_detil, '0', '0', '1'
            FROM PerawatanSQL.dbo.Tarif_Paket_Operasi_2 WHERE id_paket = :idpakethdr and group_paket_detil = 'Visite Dokter'";

            $this->db->query($queryInpatientDetail);
            $this->db->bind('nomr', $nomr);
            $this->db->bind('noepisode', $noepisode);
            $this->db->bind('noregistrasi', $noregistrasi);
            $this->db->bind('iddokter', $iddokter);
            $this->db->bind('namadokter', $namadokter);
            $this->db->bind('hakkelas', $hakkelas);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('datenowcreate2', $datenowcreate);
            $this->db->bind('operator', $operator);
            $this->db->bind('idpakethdr', $idpakethdr);
            $this->db->bind('idpakethdr2', $idpakethdr);
            $this->db->execute();

            // INSERT TBL TINDAKAN RI DETAIL
            $querytbltindakanridetail1 = "INSERT INTO RawatInapSQL.dbo.tblTindakanRIDetail 
            (NoMR, NoEpisode, NoRegistrasi, RecordID, TarifKelasID, strKey, Cito, Penyulit, Discount, JasaMedis, GroupID, GroupName, GroupJasaID, 
            NamaJasa, Dokter, Tarif, TarifSatuan, NamaKelas, Head, UserEntri, DateEntry, Bayar, Asuransi, lockBill, IncludePaket, FB_DISC, Nilai_Reff_Paket)
            SELECT
            '$nomr', '$noepisode', '$noregistrasi', null, '$hakkelas', null, null, null, null, null, :idpakethdr2, nama_hdr_paket, idjasagroup, 
            nama_item_detil, '$iddokter', '0', '0', '$namakelas', '0', '$namauserx', '$datenowcreate', '0', '0', '0', '1', '0', null
            FROM PerawatanSQL.dbo.Tarif_Paket_Operasi_2 where id_paket = :idpakethdr  and group_paket_detil LIKE '%Kamar%' and nama_item_detil LIKE '%dokter%'";

            $this->db->query($querytbltindakanridetail1);
            $this->db->bind('idpakethdr', $idpakethdr);
            $this->db->bind('idpakethdr2', $idpakethdr);
            $this->db->execute();

            $querytbltindakanridetail2 = "INSERT INTO RawatInapSQL.dbo.tblTindakanRIDetail 
            (NoMR, NoEpisode, NoRegistrasi, RecordID, TarifKelasID, strKey, Cito, Penyulit, Discount, JasaMedis, GroupID, GroupName, GroupJasaID, 
            NamaJasa, Dokter, Tarif, TarifSatuan, NamaKelas, Head, UserEntri, DateEntry, Bayar, Asuransi, lockBill, IncludePaket, FB_DISC, Nilai_Reff_Paket)
            SELECT
            '$nomr', '$noepisode', '$noregistrasi', null, '$hakkelas', null, null, null, null, null, :idpakethdr2, nama_hdr_paket, idjasagroup, 
            nama_item_detil, null, '0', '0', '$namakelas', '0', '$namauserx', '$datenowcreate', '0', '0', '0', '1', '0', null
            FROM PerawatanSQL.dbo.Tarif_Paket_Operasi_2 where id_paket = :idpakethdr and group_paket_detil LIKE '%Kamar%' and nama_item_detil NOT LIKE '%dokter%'";

            $this->db->query($querytbltindakanridetail2);
            $this->db->bind('idpakethdr', $idpakethdr);
            $this->db->bind('idpakethdr2', $idpakethdr);
            $this->db->execute();


            // INSERT RADIOLOGY
            $querycek1 = "SELECT * from PerawatanSQL.dbo.Tarif_Paket_Operasi_2 a inner join RadiologiSQL.dbo.ProcedureRadiology b on a.id_paket_detil=b.ID
            where a.group_paket_detil='Radiologi' and id_paket=:idpakethdr";
            $this->db->query($querycek1);
            $this->db->bind('idpakethdr', $idpakethdr);
            $this->db->execute();
            $datax = $this->db->resultSet();

            foreach ($datax as $key) {
                // var_dump($ke);
                // exit;
                $datenowcreateqx = date("His");
                $TRIGGER_DTTMx = date('Ymd', strtotime($datenowcreate));
                $TRIGGER_DTTM = $TRIGGER_DTTMx . $datenowcreateqx;
                $timecreate = date(" H:i:s");
                $datecreate = date('Y-m-d', strtotime($datenowcreate));
                $datetimecreate = $datecreate . $timecreate;
                $DOB = date('Ymd', strtotime($tgllahirxx));

                $querycek2 = "SELECT max(WOID) as WOID from RadiologiSQL.DBO.WO_RADIOLOGY order by 1 desc";
                $this->db->query($querycek2);
                $this->db->execute();
                $data = $this->db->single();
                $WOID = $data['WOID'];
                $WOID++;

                $WOIDx = substr($WOID, -2);
                $Accession_No = $TRIGGER_DTTM . $WOIDx;
                $uid = "1.2.410.2000010.82.111." . $Accession_No;
                $nomrx = str_replace("-", "", $nomr);
                if (strlen($nomrx) == 6) {
                    $nourutfixReg = "00" . $nomrx;
                } else if (strlen($nomrx) == 7) {
                    $nourutfixReg = "0" . $nomrx;
                } else if (strlen($nomrx) == 8) {
                    $nourutfixReg = $nomrx;
                }

                $query_wo = "INSERT INTO  RadiologiSQL.DBO.WO_RADIOLOGY
                (SCHEDULED_DTTM, TRIGGER_DTTM, PROC_PLACER_ORDER_NO, Accession_No, PATIENT_ID, PATIENT_NAME, 
                PATIENT_LOCATION, OrderCode, MRN, EPISODE_NUMBER, NoRegistrasi, Order_Date, REQUEST_BY, SCHEDULED_MODALITY, 
                SCHEDULED_STATION, SCHEDULED_LOCATION, SCHEDULED_PROC_ID, SCHEDULED_PROC_DESC, SCHEDULED_ACTION_CODES, 
                REQUESTED_PROC_ID, REQUESTED_PROC_DESC, Posisition, Side, REQUESTED_PROC_CODES, REQUEST_DEPARTMENT, Diagnosis, 
                Service_Charge, StatusID, PaymentStatus, Batal, Note, Tarif) 
                SELECT 
                '$TRIGGER_DTTM', '$TRIGGER_DTTM', '$TRIGGER_DTTM', '$Accession_No', '$nourutfixReg', '$namapasien', 
                'RWI', Proc_Code, '$nomr', '$noepisode', '$noregistrasi', '$datetimecreate', '$iddokter', Modality_Code, 
                Modality_Code, Modality_Code, Proc_Code, Proc_Description, Proc_ActionCode, 
                Proc_Code, Proc_Description, position, '', Proc_ActionCode, 'YARSI', null, 
                0, '0', '0', '0', null, 0
                from PerawatanSQL.dbo.Tarif_Paket_Operasi_2 a
                inner join RadiologiSQL.dbo.ProcedureRadiology b on a.id_item_detil=b.Proc_Code
                where a.group_paket_detil='Radiologi' and a.id_paket=:idpakethdr and b.Proc_Code=:IdCode_rad";
                $this->db->query($query_wo);
                $this->db->bind('idpakethdr', $idpakethdr);
                $this->db->bind('IdCode_rad', $key['id_item_detil']);
                $this->db->execute();

                $query_mwlwl = "INSERT INTO RadiologiSQL.DBO.MWLWL 
                (TRIGGER_DTTM, REPLICA_DTTM, EVENT_TYPE, CHARACTER_SET, SCHEDULED_AETITLE, SCHEDULED_DTTM, SCHEDULED_MODALITY, SCHEDULED_STATION, 
                SCHEDULED_LOCATION, SCHEDULED_PROC_ID, SCHEDULED_PROC_DESC, SCHEDULED_ACTION_CODES, SCHEDULED_PROC_STATUS, REQUESTED_PROC_ID, 
                REQUESTED_PROC_DESC, REQUESTED_PROC_CODES, STUDY_INSTANCE_UID, PROC_PLACER_ORDER_NO, REFER_DOCTOR, REQUEST_DEPARTMENT, 
                PATIENT_LOCATION, PATIENT_NAME, Patient_ID, PATIENT_BIRTH_DATE, PATIENT_SEX, DIAGNOSIS, ACCESSION_NO) 
                SELECT 
                '$TRIGGER_DTTM', 'ANY', '', 'ISO_IR 100', 'ANY', '$TRIGGER_DTTM', Modality_Code, Modality_Code, 
                Modality_Code, Proc_Code, Proc_Description, Proc_ActionCode, '120', Proc_Code, 
                Proc_Description, Proc_ActionCode, '$uid', '$Accession_No', '$iddokter', 'YARSI', 
                'RWI', '$namapasien', '$nourutfixReg', '$tgllahirxx', '$jeniskelaminxxD', '', '$Accession_No'
                from PerawatanSQL.dbo.Tarif_Paket_Operasi_2 a
                inner join RadiologiSQL.dbo.ProcedureRadiology b on a.id_item_detil=b.Proc_Code
                where a.group_paket_detil='Radiologi' and a.id_paket=:idpakethdr and b.Proc_Code=:IdCode_rad";
                $this->db->query($query_mwlwl);
                $this->db->bind('idpakethdr', $idpakethdr);
                $this->db->bind('IdCode_rad', $key['id_item_detil']);
                $this->db->execute();
                sleep(1);
            }

            // INSERT LAB
            $query = "SELECT  max(LabID) as urutantbllab, max(RecID) as urutantbllabRecID from LaboratoriumSQL.dbo.tblLab";
            $this->db->query($query);
            $this->db->execute();
            $data = $this->db->single();
            $no_urutantbllabRecID = $data['urutantbllabRecID'];
            $no_urutantbllabRecID++;

            $query = "SELECT  max(NoLab) as urutantbllablis from LaboratoriumSQL.dbo.tblLab WHERE left([NoLAB],6)=:datenowlis";
            $this->db->query($query);
            $this->db->bind('datenowlis', $datenowlis);
            $this->db->execute();
            $data = $this->db->single();
            // no urut lab
            $no_urutantbllablis = $data['urutantbllablis'];
            $substringlis = substr($no_urutantbllablis, 6);
            if ($substringlis == null) {
                $substringlis = 0;
            }
            $substringlis++;
            if (strlen($substringlis) == 1) {
                $nourutfixLis = "000" . $substringlis;
            } else if (strlen($substringlis) == 2) {
                $nourutfixLis = "00" . $substringlis;
            } else if (strlen($substringlis) == 3) {
                $nourutfixLis = "0" . $substringlis;
            } else if (strlen($substringlis) == 4) {
                $nourutfixLis = $substringlis;
            }
            $idno_urutantbllablis = $datenowlis . $nourutfixLis;

            $query = "INSERT INTO LaboratoriumSQL.dbo.tblLab (  [OrderCode], RecID, NoLAB, LabDate, Dokter,
            NoMR, NoEpisode , NoRegRI , KelasID, Operator,StatusID, [JenisOrder],JamOrder) VALUES
            ('RWI','$no_urutantbllabRecID','$idno_urutantbllablis','$datenowcreate','$iddokter',
            '$nomr','$noepisode','$noregistrasi','3','1','3','BIASA','$datenowcreate')";
            $this->db->query($query);
            $this->db->execute();

            $query = "SELECT max(LabID) as LabID from LaboratoriumSQL.dbo.tblLab order by 1 desc";
            $this->db->query($query);
            $this->db->execute();
            $data = $this->db->single();
            $idmax_labid = $data['LabID'];

            // INSERT LIS
            $querylis = "INSERT INTO LaboratoriumSQL.dbo.LIS_Order 
            (NoMR, NoEpisode, NoRegistrasi, NoLAB, Title, pname, sex, birth_dt, Address, ptype, locid, locname, clinician_id,
            clinician_name, request_dt, user_order, asuransi) VALUES
            ('$nomr','$noepisode','$noregistrasi','$idno_urutantbllablis',
             '','$namapasien','$jeniskelaminxxD','$tgllahirxx','$alamatxx','$jenisbayarRWIxxd',
             '$idroomakhir','$namaroomakhir','$iddokter', 
             '$namadokter' ,'$datenowcreate', '$userid','$jaminanxx'
            )";

            $this->db->query($querylis);
            $this->db->execute();


            $this->db->commit();

            $callback = array(
                'status' => "success", // Set array nama  
                'message' => 'berhasil'
            );
            return $callback;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        } finally {
            $pasingdata = array(
                'message' => "passing", // Set array nama 
                'idmax_labid' => $idmax_labid,
                'idpakethdr' => $idpakethdr,
                'idno_urutantbllablis' => $idno_urutantbllablis,
            );
            $this->goCreateLabDetail($pasingdata);
        }
    }

    function goCreateLabDetail($data)
    {
        try {
            //$this->db->transaksi();

            $idpakethdr = $data['idpakethdr'];
            $idno_urutantbllablis = $data['idno_urutantbllablis'];
            $idmax_labid = $data['idmax_labid'];

            //tbllabdetail
            $query = "INSERT INTO LaboratoriumSQL.dbo.tblLabDetail 
            ( LabID, IdTes, Tarif, Rate, TarifKelas,kode_test )
            SELECT 
            '$idmax_labid' AS LabID, a.id_item_detil, 0, 0, 0,b.KodeKelompok 
            FROM PerawatanSQL.dbo.Tarif_Paket_Operasi_2 a
            left join LaboratoriumSQL.dbo.tblGrouping b on a.id_item_detil=b.IDTes
            WHERE group_paket_detil = 'Laboratorium' AND id_paket=:idpakethdr";

            $this->db->query($query);
            $this->db->bind('idpakethdr', $idpakethdr);
            $this->db->execute();

            // --LIS DETAIL
            $query = "INSERT INTO LaboratoriumSQL.dbo.LIS_Order_detail ( NoMR, NoEpisode, NoLAB, kode_test, nama_test, is_cito ) 
                SELECT tblLab.NoMR, tblLab.NoEpisode, tblLab.NoLAB, tblGrouping.KodeKelompok, tblGrouping.NamaTes, 
                'BIASA' AS iscito
                FROM LaboratoriumSQL.dbo.tblLabDetail 
                INNER JOIN LaboratoriumSQL.dbo.tblLab ON tblLabDetail.LabID = tblLab.LabID
                INNER JOIN LaboratoriumSQL.dbo.tblGrouping ON tblLabDetail.idTes = tblGrouping.IDTes
                WHERE NoLAB=:idno_urutantbllablis AND tblGrouping.KodeKelompok Is Not Null
                ORDER BY tblLab.NoLAB
                ";
            $this->db->query($query);
            $this->db->bind('idno_urutantbllablis', $idno_urutantbllablis);
            $this->db->execute();

            //#END ORDER LAB----------------------------

            //#END UNIT MCU WITH PACSORDER------------------
            $this->db->commit();
            //var_dump($data);


            $callback = array(
                'message' => "success", // Set array nama 
                'idpakethdr' => $idpakethdr,
                'NolisOrder' => $idno_urutantbllablis,
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

    //badrul

    public function CreateRegistrasi($data)
    {
        try {
            $this->db->transaksi();
            $datenowcreate = Utils::seCurrentDateTime();

            //Deklarasi Variable
            $nomr = $_POST['NoMR'];
            $JenisBayar = $_POST['TipePenjamin'];
            $jenisrawat = $_POST['JenisRawat'];
            $idcaramasuk = $_POST['caramasuk'];
            $dokter = $_POST['NamaDokter'];
            $pasienpaket = $_POST['Paket'];
            $noepisode = $_POST['NoEpisodeRWJ'];
            $noregisrwj = $_POST['NoRegistrasi'];
            $idspr = $_POST['IdAuto'];
            //$idpaket = $_POST['paket'];
            $kelas = $_POST['Kelas'];
            $nosep = $_POST['NoSEP'];
            $noregri = $_POST['NoREGRI'];
            $nikpasien = $_POST['NikPasien'];
            $pxNoteRegistrasi = $_POST['pxNoteRegistrasi'];
            if (isset($_POST['COB'])) {
                $COB = $_POST['COB'];
            } else {
                $COB = null;
            }

            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $operator =  $session->IDEmployee;

            /*
            if ($nomr == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan No. MR !',
                );
                return $callback;
                exit;
            }
            */

            // Cek Data
            if ($JenisBayar == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Pilih Tipe Pasien !',
                );
                return $callback;
                exit;
            } else {
                //deff kode jaminan jika jenis bayar terisi
                $kode_jaminan = $_POST['NamaPenjamin'];
                if ($kode_jaminan == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Silahkan Pilih Nama Penjamin !',
                    );
                    return $callback;
                    exit;
                }
            }

            //   if ($JenisBayar=="5" && $kode_jaminan == '313'){
            //     // if($nosep==''){
            //     // $callback = array(    
            //     //     'status' => 'warning',
            //     //     'errorname' => 'Silahkan Masukan Nomor SEP!', 
            //     // );
            //     // return $callback;
            //     //     exit;
            //     // }
            //  }else{
            //   $nosep = '';
            //  }

            if ($jenisrawat == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Pilih Kategori Keperawatan !',
                );
                return $callback;
                exit;
            }
            if ($idcaramasuk == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Pilih Cara Masuk !',
                );
                return $callback;
                exit;
            } else {
                //def referral jika jenis cara masuk terisi
                if (isset($_POST['referral'])) {
                    $idcaramasuk2 = $_POST['referral'];
                } else {
                    $idcaramasuk2 = 0;
                }
                /*
                if ($idcaramasuk<>"1" && $idcaramasuk2 == ""){
                        $callback = array(    
                            'status' => 'warning',
                            'errorname' => 'Silahkan Pilih Referal !', 
                        );
                        return $callback;
                            exit;
                }*/
            }

            if ($dokter == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Pilih Dokter Penanggung Jawab !',
                );
                return $callback;
                exit;
            }
            if ($pasienpaket == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Pilih Pasien Paket Atau Tidak !',
                );
                return $callback;
                exit;
            }
            if ($kelas == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Pilih Kelas !',
                );
                return $callback;
                exit;
            }

            //cek tipe pasien
            if ($JenisBayar == '2') {
                $tipepasien = 'IDAsuransi';
            } else {
                $tipepasien = 'IDJPK';
            }

            if ($noregri == '' || $noregri == null) { // jika noregri null maka create new

                //Cek Jika ada registrasi yang aktif dengan no mr yang sama
                $this->db->query("SELECT NoRegRI
            FROM RawatInapSQL.dbo.Inpatient
            WHERE NoMR=:nomr AND StatusID<>'4'");
                $this->db->bind('nomr', $nomr);
                $data =  $this->db->single();
                if ($data) {
                    $dataidregfieedback = $data['NoRegRI'];
                    $callback = array(
                        'status' => "warning",
                        'errorname' => "Ada No Registrasi Yang Aktif Pada No MR : " . $nomr . " - No Registrasi Yang Aktif :" . $dataidregfieedback,
                        'errormessage' => $dataidregfieedback,
                    );
                    return $callback;
                    exit;
                }

                //#END Cek

                //untuk kode awal no NoKwitansi
                if ($JenisBayar == "1") {
                    $kodeawal = "RIUM";
                } elseif ($JenisBayar == "2") {
                    $kodeawal = "RIAS";
                } elseif ($JenisBayar == "5") {
                    $kodeawal = "RIJP";
                }
                $kodetengah = date('dmy'); //untuk kode tengah no NoKwitansi

                $datenow = date('Y-m-d');

                // CEK ANTRIAN
                $this->db->query("SELECT  TOP 1 NoRegRI,right( REPLACE(NoRegRI,'-','0'),4) as noregri,right( REPLACE(NoEpisode,'-','0')  ,4) as urut
                FROM RawatInapSQL.dbo.Inpatient
                WHERE --replace(CONVERT(VARCHAR(11), StartDate, 111), '/','-')='$datenow' 
                NoRegRI like :kodetengah and right( NoRegRI,4) not LIKE '%-%'
                AND LEFT(NoRegRI,4)=:kodeawal ORDER BY right(NoRegRI,4) DESC");
                $this->db->bind('kodeawal', $kodeawal);
                $this->db->bind('kodetengah', "%$kodetengah%");
                $data =  $this->db->single();

                $idReg = $data['noregri'];
                $idx = $data['urut'];

                if ($noepisode == null || $noepisode == '') {

                    // no urut op
                    $idx++;

                    $awalOp = "IP";
                    $tenganOp = str_replace("-", "", $nomr);
                    $datenow = date('dmy', strtotime($datenowcreate));

                    if (strlen($idx) == 1) {
                        $nourutfix = "000" . $idx;
                    } else if (strlen($idx) == 2) {
                        $nourutfix = "00" . $idx;
                    } else if (strlen($idx) == 3) {
                        $nourutfix = "0" . $idx;
                    } else if (strlen($idx) == 4) {
                        $nourutfix = $idx;
                    }
                    // generate No. Episode
                    $noepisode = $awalOp . $tenganOp . '-' . $datenow . '-' . $nourutfix;
                    // var_dump($noepisode);exit;
                }

                if (empty($idReg)) {
                    //jika gk ada record
                    $idReg = "0001";
                } else {
                    //jika ada record
                    $idReg++;
                }

                // GENERATE NO REGISTRASI
                if (strlen($idReg) == 1) {
                    $nourutfixReg = "000" . $idReg;
                } else if (strlen($idReg) == 2) {
                    $nourutfixReg = "00" . $idReg;
                } else if (strlen($idReg) == 3) {
                    $nourutfixReg = "0" . $idReg;
                } else if (strlen($idReg) == 4) {
                    $nourutfixReg = $idReg;
                }
                //Nomor Final Registrasi Rawat Inap
                $nofinalreg = $kodeawal . $kodetengah . '-' . $nourutfixReg;


                // INSERT INPATIENT
                $sqlx = "INSERT INTO RawatInapSQL.dbo.Inpatient (NoMR,NoEpisode,NoRegRI,JenisRawat,TypePatient,
                    $tipepasien,drPenerima,StatusID,operator,idCaraMasuk,idCaraMasuk2,Paket,paket_operasi,IdSPR,KlsID,NoSEP,Catatan,KodeJaminanCOB)VALUES
                    (:nomr,:noepisode,:nofinalreg,:jenisrawat,:JenisBayar,:kode_jaminan,:dokter,'0',:operator,
                    :idcaramasuk,:idcaramasuk2,:pasienpaket,:pasienpaket2,:idspr,:kelas,:nosep,:Note,:COB)";
                $this->db->query($sqlx);
                $this->db->bind('nomr', $nomr);
                $this->db->bind('Note', $pxNoteRegistrasi);
                $this->db->bind('noepisode', $noepisode);
                $this->db->bind('nofinalreg', $nofinalreg);
                $this->db->bind('jenisrawat', $jenisrawat);
                $this->db->bind('JenisBayar', $JenisBayar);
                $this->db->bind('kode_jaminan', $kode_jaminan);
                $this->db->bind('dokter', $dokter);
                $this->db->bind('operator', $operator);
                $this->db->bind('idcaramasuk', $idcaramasuk);
                $this->db->bind('idcaramasuk2', $idcaramasuk2);
                $this->db->bind('pasienpaket', $pasienpaket);
                $this->db->bind('pasienpaket2', $pasienpaket);
                $this->db->bind('idspr', $idspr);
                $this->db->bind('kelas', $kelas);
                $this->db->bind('nosep', $nosep);
                $this->db->bind('COB', $COB);
                $this->db->execute();

                //INSERT ke DataRWI 17-03-2023
                //GET DATA PASIEN
                $this->db->query("SELECT PatientName,
                            KelurahanName,KecamatanName,CityName,ProvinceName,Gander,replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as Date_of_birth,Tipe_Idcard,ID_Card_number,Address,Marital_status,Religion,
                            Education,[Home Phone],[Mobile Phone],Ocupation,[ZIP/Postal Code] as PostalCode
                            ,Bahasa,Etnis,replace(CONVERT(VARCHAR(11), InputDate, 111), '/','-') as InputDate
                            from MasterdataSQL.dbo.Admision 
                            where  NoMR=:NoMrfix
                            UNION ALL
                            SELECT PatientName,
                            KelurahanName,KecamatanName,CityName,ProvinceName,Gander,replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as Date_of_birth,Tipe_Idcard,ID_Card_number,Address,Marital_status,Religion,
                            Education,[Home Phone],[Mobile Phone],Ocupation,[ZIP/Postal Code] as PostalCode
                            ,Bahasa,Etnis,replace(CONVERT(VARCHAR(11), InputDate, 111), '/','-') as InputDate
                            from MasterdataSQL.dbo.Admision_walkin 
                            where  NoMR=:NoMrfix2");
                $this->db->bind('NoMrfix', $nomr);
                $this->db->bind('NoMrfix2', $nomr);
                $datag =  $this->db->single();
                $PatientName = $datag['PatientName'];
                $KelurahanName = $datag['KelurahanName'];
                $KecamatanName = $datag['KecamatanName'];
                $CityName = $datag['CityName'];
                $ProvinceName = $datag['ProvinceName'];
                $Gander = $datag['Gander'];
                $Date_of_birth = $datag['Date_of_birth'];
                $Tipe_Idcard = $datag['Tipe_Idcard'];
                $ID_Card_number = $datag['ID_Card_number'];
                $Address = $datag['Address'];
                $Marital_status = $datag['Marital_status'];
                $Religion = $datag['Religion'];
                $Education = $datag['Education'];
                $HomePhone = $datag['Home Phone'];
                $MobilePhone = $datag['Mobile Phone'];
                $Ocupation = $datag['Ocupation'];
                $PostalCode = $datag['PostalCode'];
                $Bahasa = $datag['Bahasa'];
                $Etnis = $datag['Etnis'];
                $InputDate = $datag['InputDate'];

                // GET NAMA PERUSAHAAN
                if ($JenisBayar == '2') {
                    $this->db->query("SELECT NamaPerusahaan
                                from MasterdataSQL.dbo.MstrPerusahaanAsuransi  
                                where  ID=:kode_jaminan");
                    $this->db->bind('kode_jaminan', $kode_jaminan);
                    $datag =  $this->db->single();
                    $NamaPerusahaan = $datag['NamaPerusahaan'];
                } else {
                    $this->db->query("SELECT NamaPerusahaan
                                from MasterdataSQL.dbo.MstrPerusahaanJPK  
                                where  ID=:kode_jaminan");
                    $this->db->bind('kode_jaminan', $kode_jaminan);
                    $datag =  $this->db->single();
                    $NamaPerusahaan = $datag['NamaPerusahaan'];
                }

                $datenowcreate_Ymd = date('Y-m-d', strtotime($datenowcreate));
                if (strtotime($datenowcreate_Ymd) > strtotime($InputDate)) {
                    $BL = 'LAMA';
                } else {
                    $BL = 'BARU';
                }

                $this->db->query("INSERT INTO DashboardData.dbo.DataRWI (NoEpisode,NoRegistrasi,NoMR,PatientName,StartDate,StartTime,
                            Kelurahan,Kecamatan,kabupatenNama,ProvinsiNama,BL,TipePasien,FP,
                            KodeJaminan,NamaJaminan,Sex,DateOfBirth,TipeIdCard, NoIdCard, Address,MaritalStatus,Religion,
                            Education,HomePhone,MobilePhone,Pekerjaan,KodePos,drPenerima,
                            NoSep,OperatorId,
                            idCaraMasuk,idCaraMasuk2,hosnamedata,datatimestamp,Bahasa,Etnis,Catatan,RawatBersama,StatusID,IdSPR
                            ) VALUES ( :NoEpisode, :nofixReg,:NoMrfix,:PatientName,:tglregistrasi,:tglregistrasi2,
                                    :KelurahanName,:KecamatanName,:CityName,:ProvinceName,
                                    :BL
                                    ,:JenisBayar,'1',
                                    :perusahaanid,:NamaPerusahaan,:Gander,:Date_of_birth,:Tipe_Idcard,:ID_Card_number,:Address,:Marital_status,:Religion,
                                    :Education,:HomePhone,:MobilePhone,:Ocupation,:PostalCode
                                    ,:IdDokter,:nosep,:operator,
                                    :caramasukid,:referralid,host_name(),:datenowcreate
                                    ,:Bahasa,:Etnis,:Note,:RawatBersama,:StatusID,:idspr
                                    )
                                    ");
                $this->db->bind('NoEpisode', $noepisode);
                $this->db->bind('nofixReg', $nofinalreg);
                $this->db->bind('NoMrfix', $nomr);
                $this->db->bind('PatientName', $PatientName);
                $this->db->bind('tglregistrasi', $datenowcreate_Ymd);
                $this->db->bind('tglregistrasi2', Date('H:i:s', strtotime($datenowcreate)));
                $this->db->bind('KelurahanName', $KelurahanName);
                $this->db->bind('KecamatanName', $KecamatanName);
                $this->db->bind('CityName', $CityName);
                $this->db->bind('ProvinceName', $ProvinceName);
                $this->db->bind('BL', $BL);
                $this->db->bind('JenisBayar', $JenisBayar);
                $this->db->bind('perusahaanid', $kode_jaminan);
                $this->db->bind('NamaPerusahaan', $NamaPerusahaan);
                $this->db->bind('Gander', $Gander);
                $this->db->bind('Date_of_birth', $Date_of_birth);
                $this->db->bind('Tipe_Idcard', $Tipe_Idcard);
                $this->db->bind('ID_Card_number', $ID_Card_number);
                $this->db->bind('Address', $Address);
                $this->db->bind('Marital_status', $Marital_status);
                $this->db->bind('Religion', $Religion);
                $this->db->bind('Education', $Education);
                $this->db->bind('HomePhone', $HomePhone);
                $this->db->bind('MobilePhone', $MobilePhone);
                $this->db->bind('Ocupation', $Ocupation);
                $this->db->bind('PostalCode', $PostalCode);
                $this->db->bind('IdDokter', $dokter);
                $this->db->bind('nosep', $nosep);
                $this->db->bind('operator', $operator);
                $this->db->bind('caramasukid', $idcaramasuk);
                $this->db->bind('referralid', $idcaramasuk2);
                $this->db->bind('Bahasa', $Bahasa);
                $this->db->bind('Etnis', $Etnis);
                $this->db->bind('datenowcreate', $datenowcreate);
                $this->db->bind('Note', $pxNoteRegistrasi);
                $this->db->bind('RawatBersama', '0');
                $this->db->bind('StatusID', '0');
                $this->db->bind('idspr', $idspr);
                $this->db->execute();
                //---#END INSERT DATARWI


                // UPDATE TABEL VISIT
                $this->db->query("UPDATE PerawatanSQL.dbo.Visit
                    SET NoRegRI=:nofinalreg
                    --,RawatInap=1 
                    where NoRegistrasi=:noregisrwj");
                $this->db->bind('nofinalreg', $nofinalreg);
                $this->db->bind('noregisrwj', $noregisrwj);
                $this->db->execute();

                // // UPDATE TABEL EMR_ORDEROPERASI
                // $this->db->query("UPDATE MedicalRecord.dbo.EMR_OrderOperasi
                //     SET NoRegistrasi=:nofinalreg where NoMR=:nomr and left(NoRegistrasi,2) = 'RJ' and StatusOrder not in('Close' , 'Batal', 'cancel') ");
                // $this->db->bind('nofinalreg', $nofinalreg);
                // $this->db->bind('nomr', $nomr);
                // $this->db->execute();

                // // UPDATE TABEL EMR_ORDEROPERASI
                // $this->db->query("UPDATE MedicalRecord.dbo.MR_LaporanOperasi
                //     SET NoRegistrasi=:nofinalreg where NoRegistrasi=:noregisrwj");
                // $this->db->bind('nofinalreg', $nofinalreg);
                // $this->db->bind('noregisrwj', $noregisrwj);
                // $this->db->execute();

                $this->db->commit();
                $callback = array(
                    'status' => 'success',
                    'message' => 'Registrasi Berhasil disimpan ! Halaman Akan Direct Otomatis ke Halaman Kamar Untuk Check in',
                    'kode_jaminan' => $kode_jaminan,
                    'nofinalreg' => $nofinalreg,
                    'noepisode' => $noepisode,
                    'nikpasien' => $nikpasien,
                );
                return $callback;
            } else { // Jika noregri ada valunya, update reg---------------------------------

                $alasan = $_POST['alasan'];

                // GET DATA SEBELUM DIEDIT
                $this->db->query("SELECT JenisRawat,TypePatient,case when TypePatient = '2' then b.ID else c.ID end as namajaminan,idCaraMasuk,idCaraMasuk2,NoSEP,drPenerima,KlsID,paket_operasi,InpatientID
                    FROM RawatInapSQL.dbo.Inpatient a
                    left join MasterdataSQL.dbo.MstrPerusahaanAsuransi b on a.IDAsuransi=b.ID
                    left join MasterdataSQL.dbo.MstrPerusahaanJPK c on a.IDJPK=c.ID
                    Where NoRegRI=:noregri");
                $this->db->bind('noregri', $noregri);
                $data =  $this->db->single();

                $JenisRawat_lama = $data['JenisRawat'];
                $TypePatient_lama = $data['TypePatient'];
                $namajaminan_lama = $data['namajaminan'];
                $idCaraMasuk_lama = $data['idCaraMasuk'];
                $idCaraMasuk2_lama = $data['idCaraMasuk2'];
                $NoSEP_lama = $data['NoSEP'];
                $drPenerima_lama = $data['drPenerima'];
                $KlsID_lama = $data['KlsID'];
                $paket_operasi_lama = $data['paket_operasi'];
                $InpatientID = $data['InpatientID'];

                $info = 'Edit Reg Rawat Inap - Data Before Edit:' . $JenisRawat_lama . ', TypePatient:' . $TypePatient_lama . ', IDJAMINAN:' . $namajaminan_lama . ', CaraMasuk:' . $idCaraMasuk_lama . ', Referal:' . $idCaraMasuk2_lama . ', SEP:' . $NoSEP_lama . ', Dr:' . $drPenerima_lama . ', Kls:' . $KlsID_lama . ', Paket:' . $paket_operasi_lama;

                // INSERT BUTTON LOG
                $sqlx = "INSERT INTO  SysLog.dbo.TZ_Log_Button (idtrs,noregistrasi,nama_biling,petugas_batal,tgl_batal,alasan_batal) VALUES
                    (:InpatientID,:noregri,:info,:namauserx,:datenowcreate,:alasan)";
                $this->db->query($sqlx);
                $this->db->bind('InpatientID', $InpatientID);
                $this->db->bind('noregri', $noregri);
                $this->db->bind('info', $info);
                $this->db->bind('namauserx', $namauserx);
                $this->db->bind('datenowcreate', $datenowcreate);
                $this->db->bind('alasan', $alasan);
                $this->db->execute();

                // UPDATE TABEL INPATIENT

                if ($JenisBayar == '2') {
                    $query = "UPDATE RawatInapSQL.dbo.Inpatient SET JenisRawat=:jenisrawat,
                        TypePatient=:JenisBayar,IDAsuransi=:kode_jaminan,drPenerima=:dokter,
                        idCaraMasuk=:idcaramasuk,idCaraMasuk2=:idcaramasuk2,Paket=:pasienpaket,paket_operasi=:pasienpaket2,
                        KlsID=:kelas,NoSEP=:nosep,IDJPK=null,Catatan=:Note,KodeJaminanCOB=:COB WHERE NoRegRI=:noregri";
                } else {
                    $query = "UPDATE RawatInapSQL.dbo.Inpatient SET JenisRawat=:jenisrawat,
                        TypePatient=:JenisBayar,IDJPK=:kode_jaminan,drPenerima=:dokter,idCaraMasuk=:idcaramasuk,
                        idCaraMasuk2=:idcaramasuk2,Paket=:pasienpaket,paket_operasi=:pasienpaket2,KlsID=:kelas,NoSEP=:nosep,
                        IDAsuransi=null,Catatan=:Note,KodeJaminanCOB=:COB WHERE NoRegRI=:noregri";
                }

                $this->db->query($query);
                $this->db->bind('noregri', $noregri);
                $this->db->bind('Note', $pxNoteRegistrasi);
                $this->db->bind('jenisrawat', $jenisrawat);
                $this->db->bind('JenisBayar', $JenisBayar);
                $this->db->bind('kode_jaminan', $kode_jaminan);
                $this->db->bind('dokter', $dokter);
                $this->db->bind('idcaramasuk', $idcaramasuk);
                $this->db->bind('idcaramasuk2', $idcaramasuk2);
                $this->db->bind('pasienpaket', $pasienpaket);
                $this->db->bind('pasienpaket2', $pasienpaket);
                $this->db->bind('kelas', $kelas);
                $this->db->bind('nosep', $nosep);
                $this->db->bind('COB', $COB);
                $this->db->execute();


                //UPDATE DASHBOARD RWJ

                // //GET NAMACARAMASUK
                //     $querry = "SELECT NamaCaraMasuk
                //     from MasterdataSQL.dbo.MstrCaraMasuk
                //     where id=:caramasukid";
                // $this->db->query($querry);
                // $this->db->bind('caramasukid', $idcaramasuk);
                // $dataf =  $this->db->single();
                // $NamaCaraMasuk = $dataf['NamaCaraMasuk'];

                //GET NAMAJAMINAN
                if ($JenisBayar == '2') {
                    $querryy = "SELECT NamaPerusahaan
                    from MasterdataSQL.dbo.MstrPerusahaanAsuransi
                    where ID=:perusahaanid";
                } else {
                    $querryy = "SELECT NamaPerusahaan
                    from MasterdataSQL.dbo.MstrPerusahaanJPK
                    where ID=:perusahaanid";
                }

                $this->db->query($querryy);
                $this->db->bind('perusahaanid', $kode_jaminan);
                $dataff =  $this->db->single();
                $NamaPerusahaan = $dataff['NamaPerusahaan'];

                $this->db->query("UPDATE DashboardData.dbo.dataRWI
                                SET 
                                TipePasien=:JenisBayar,
                                KodeJaminan=:perusahaanid,
                                NamaJaminan=:NamaPerusahaan,
                                drPenerima=:IdDokter,
                                NoSEP=:nosep,
                                idCaraMasuk=:caramasukid,
                                idCaraMasuk2=:referralid,
                                Paket=:pasienpaket,
                                Catatan=:Note
                                where NoRegistrasi=:noregri");

                $this->db->bind('JenisBayar', $JenisBayar);
                $this->db->bind('perusahaanid', $kode_jaminan);
                $this->db->bind('NamaPerusahaan', $NamaPerusahaan);
                $this->db->bind('IdDokter', $dokter);
                $this->db->bind('nosep', $nosep);
                $this->db->bind('caramasukid', $idcaramasuk);
                $this->db->bind('referralid', $idcaramasuk2);
                $this->db->bind('pasienpaket', $pasienpaket);
                $this->db->bind('noregri', $noregri);
                $this->db->bind('Note', $pxNoteRegistrasi);
                $this->db->execute();

                $this->db->commit();
                $callback = array(
                    'status' => 'success',
                    'message' => 'Registrasi Berhasil disimpan !',
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
            // cek sudah ada payment belum
            $this->db->query("SELECT Id FROM  RawatInapSQL.dbo.Deposit 
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

            // 2. cek asesment dokter
            if ($alasanbatal == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Alasan Batal kosong !',
                );
                echo json_encode($callback);
                exit;
            }
            // cek sudah ada emr belum
            $this->db->query("SELECT *from MedicalRecord.dbo.EMR_RWJ where NoRegistrasi=:noregbatal");
            $this->db->bind('noregbatal', $noregbatal);
            $data =  $this->db->single();
            if ($data) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Registrasi Sudah ada Assesment Dokter, anda tidak bisa membatalkan !',
                );
                return $callback;
                exit;
            }
            /*
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
            */
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;

            $this->db->query("INSERT INTO  SysLog.dbo.TZ_Log_Button 
                        (noregistrasi,petugas_batal,tgl_batal,alasan_batal) VALUES
                        (:noregbatal,:userid,:datenowcreate,:alasanbatal)");
            $this->db->bind('noregbatal', $noregbatal);
            $this->db->bind('userid', $userid);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('alasanbatal', $alasanbatal);
            $this->db->execute();


            //DELETE
            $this->db->query("DELETE RawatInapSQL.dbo.Inpatient 
            WHERE NoRegRI=:noregbatal");
            $this->db->bind('noregbatal', $noregbatal);
            $this->db->execute();

            //UPDATE NOREGRI = NULL
            $this->db->query("UPDATE PerawatanSQL.dbo.Visit SET 
            NoRegRI=NULL
            WHERE NoRegRI=:noregbatal");
            $this->db->bind('noregbatal', $noregbatal);
            $this->db->execute();

            //DELETE DATARWI
            $this->db->query("DELETE DashboardData.dbo.dataRWI 
            WHERE NoRegistrasi=:noregbatal");
            $this->db->bind('noregbatal', $noregbatal);
            $this->db->execute();


            //update flag batal 1 ke tabel billing

            /*/fo_t_billing
            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING SET 
            BATAL=:isBatal, 
            PETUGAS_BATAL=:namauserx,JAM_BATAL=:datenowcreate,FB_VERIF_JURNAL='0'
            WHERE NO_REGISTRASI=:noregbatal");
            $this->db->bind('isBatal', $isBatal);
            $this->db->bind('namauserx', $namauserx);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('noregbatal', $noregbatal);
            $this->db->execute();
            */

            /*
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

            */

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

    public function getDataListPasienOperasibyNoReg($data)
    {
        try {
            $notrs = $data['notrs'];
            $this->db->query("SELECT *,replace(CONVERT(VARCHAR(11), TglOperasi, 111), '/','-') as TglOperasi FROM MedicalRecord.dbo.EMR_OrderOperasi WHERE NoRegistrasi=:notrs
             ");
            $this->db->bind('notrs', $notrs);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['NamaPasien'] = '';
                $pasing['ID'] = $key['ID'];
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['NoEpisode'] = $key['NoEpisode'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['TglOperasi'] = date('d/m/Y', strtotime($key['TglOperasi']));
                $pasing['DrOperator'] = $key['DrOperator'];
                $pasing['PetugasOrder'] = $key['PetugasOrder'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function goTransferOP($data)
    {
        try {
            $this->db->transaksi();

            $notrs = $data['notrs'];
            $noreg = $data['noreg'];

            $this->db->query("UPDATE MedicalRecord.dbo.EMR_OrderOperasi SET NoRegistrasi=:noreg WHERE ID=:notrs");
            $this->db->bind('notrs', $notrs);
            $this->db->bind('noreg', $noreg);
            $this->db->execute();

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Berhasil Transfer!',
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

    public function getJenisRawat()
    {
        try {
            $this->db->query("SELECT * FROM RawatInapSQL.dbo.JenisRuangRawat WHERE SPR='1'");
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['JenisRuangRawat'] = $key['JenisRuangRawat'];
                $rows[] = $pasing;
            }
            $callback = array(
                'status' => "success", // Set array nama  
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
}
