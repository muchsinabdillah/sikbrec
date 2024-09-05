<?php
class B_ReservasiNonWalkin_Model
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function datareservasi($data)
    {
        // var_dump($data);
        $query = "SELECT a.ID,a.NoUrut,a.NoBooking,a.NoMR,a.NamaPasien,a.Alamat,a.TglLahir,
        a.JenisPembayaran,replace(CONVERT(VARCHAR(11), a.ApmDate, 111), '/','-')  as ApmDate,a.JamPraktek,a.NoAntrianAll,
        b.NamaUnit,c.First_Name,a.Description,a.HP,a.Datang
        from  PerawatanSQL.dbo.Apointment a
        inner join MasterdataSQL.dbo.MstrUnitPerwatan b on a.IdPoli = b.ID
        inner join MasterdataSQL.dbo.Doctors c on c.ID = a.DoctorID
        where replace(CONVERT(VARCHAR(11), a.ApmDate, 111), '/','-') between :tgl_awal and :tgl_akhir
        and a.Batal='0' and a.Datang='0' --and a.NamaPasien like :namapasien";
        $this->db->query($query);
        $this->db->bind('tgl_akhir', $data['tgl_akhir']);
        $this->db->bind('tgl_awal', $data['tgl_awal']);
        // $this->db->bind('%namapasien%', $data);
        $this->db->execute();
        return self::JsonDecode(200, $this->db->resultSet());
    }
    public function listDatareservasi($data)
    {
        try {
            $querylistreservasi = "SELECT a.ID,a.NoUrut,a.NoBooking,a.NoMR,a.NamaPasien,a.Alamat,a.TglLahir,
            a.JenisPembayaran,replace(CONVERT(VARCHAR(11), a.ApmDate, 111), '/','-')  as ApmDate,a.JamPraktek,a.NoAntrianAll,
            b.NamaUnit,c.First_Name,a.Description,a.HP,a.Datang
            from  PerawatanSQL.dbo.Apointment a
            inner join MasterdataSQL.dbo.MstrUnitPerwatan b on a.IdPoli = b.ID
            inner join MasterdataSQL.dbo.Doctors c on c.ID = a.DoctorID
            where replace(CONVERT(VARCHAR(11), a.ApmDate, 111), '/','-') between :tanggal_awal and :tanggal_akhir
            and a.Batal='0' and a.Datang='0' and a.NamaPasien like :namapasien";
            $this->db->query($querylistreservasi);
            $this->db->bind('tanggal_awal', $data['tanggal_awal']);
            $this->db->bind('tanggal_akhir', $data['tanggal_akhir']);
            $this->db->bind('namapasien', '%' . $data['namapasien'] . '%');
            $this->db->execute();
            // return  $this->db->resultSet();
            return self::JsonDecode(200, $this->db->resultSet());
        } catch (PDOException $e) {
            return self::JsonDecode(0, $e);
        }
    }

    public function listDatareservasi2($data)
    {
        try {

            if ($data['iswalkin'] == 'WALKIN') {
                $wherepoli = "and IdPoli='9'";
            } else {
                $wherepoli = "and IdPoli<>'9'";
            }
            
            if ($data['jenisdata'] == "1") {
                $querylistreservasi = "SELECT a.ID,a.NoUrut,a.NoBooking,a.NoMR,a.NamaPasien,a.Alamat,a.TglLahir,
                a.JenisPembayaran,replace(CONVERT(VARCHAR(11), a.ApmDate, 111), '/','-')  as ApmDate,a.JamPraktek,a.NoAntrianAll,
                b.NamaUnit,c.First_Name,a.Description,a.HP,a.Datang,
                case when a.JenisPembayaran = 'ASURANSI' THEN d.NamaPerusahaan
                else e.NamaPerusahaan end as 'NamaPerusahaan',
                A.NoRujukanBPJS, A.NoKartuBPJS, A.NoSuratKontrolBPJS,A.NoSEP,a.IdPoli,f.[First Name] as PetugasInput
                from  PerawatanSQL.dbo.Apointment a
                inner join MasterdataSQL.dbo.MstrUnitPerwatan b on a.IdPoli = b.ID
                inner join MasterdataSQL.dbo.Doctors c on c.ID = a.DoctorID
                left join MasterDataSQL.dbo.MstrPerusahaanAsuransi d on a.ID_Penjamin=d.ID
                left join MasterDataSQL.dbo.MstrPerusahaanJPK e on a.ID_Penjamin=e.ID
                left join MasterdataSQL.dbo.Employees f on f.NoPIN = a.petugas_input
                where replace(CONVERT(VARCHAR(11), a.ApmDate, 111), '/','-') between :tanggal_awal and :tanggal_akhir
                and a.Batal='0' and a.Datang='0' $wherepoli
                order by a.ApmDate desc";
                $this->db->query($querylistreservasi);
                $this->db->bind('tanggal_awal', $data['tanggal_awal']);
                $this->db->bind('tanggal_akhir', $data['tanggal_akhir']);
                $this->db->execute();
                $data =  $this->db->resultSet();
            } else {
                $querylistreservasi = "SELECT a.ID,a.NoUrut,a.NoBooking,a.NoMR,a.NamaPasien,a.Alamat,a.TglLahir,
                a.JenisPembayaran,replace(CONVERT(VARCHAR(11), a.ApmDate, 111), '/','-')  as ApmDate,a.JamPraktek,a.NoAntrianAll,
                b.NamaUnit,c.First_Name,a.Description,a.HP,a.Datang,
                case when a.JenisPembayaran = 'ASURANSI' THEN d.NamaPerusahaan
                else e.NamaPerusahaan end as 'NamaPerusahaan',
                A.NoRujukanBPJS, A.NoKartuBPJS, A.NoSuratKontrolBPJS,A.NoSEP,a.IdPoli,f.[First Name] as PetugasInput
                from  PerawatanSQL.dbo.Apointment a
                inner join MasterdataSQL.dbo.MstrUnitPerwatan b on a.IdPoli = b.ID
                inner join MasterdataSQL.dbo.Doctors c on c.ID = a.DoctorID
                left join MasterDataSQL.dbo.MstrPerusahaanAsuransi d on a.ID_Penjamin=d.ID
                left join MasterDataSQL.dbo.MstrPerusahaanJPK e on a.ID_Penjamin=e.ID
                left join MasterdataSQL.dbo.Employees f on f.NoPIN = a.petugas_input
                where replace(CONVERT(VARCHAR(11), a.jam_input, 111), '/','-') between :tanggal_awal and :tanggal_akhir
                and a.Batal='0' and a.Datang='0' $wherepoli
                order by a.ApmDate desc";
                $this->db->query($querylistreservasi);
                $this->db->bind('tanggal_awal', $data['tanggal_awal']);
                $this->db->bind('tanggal_akhir', $data['tanggal_akhir']);
                $this->db->execute();
                $data =  $this->db->resultSet();
            }

            // return  $this->db->resultSet();
            //return self::JsonDecode(200, $this->db->resultSet());
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['ID'] = $key['ID'];
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['NamaPasien'] = $key['NamaPasien'];
                $pasing['ApmDate'] = $key['ApmDate'];
                $pasing['NamaUnit'] = $key['NamaUnit'];
                $pasing['First_Name'] = $key['First_Name'];
                $pasing['HP'] = $key['HP'];
                $pasing['JenisPembayaran'] = $key['JenisPembayaran'];
                $pasing['Description'] = $key['Description'];
                $pasing['Alamat'] = $key['Alamat'];
                $pasing['Datang'] = $key['Datang'];
                $pasing['NoAntrianAll'] = $key['NoAntrianAll'];
                $pasing['NoBooking'] = $key['NoBooking'];
                $pasing['NamaPerusahaan'] = $key['NamaPerusahaan'];
                $pasing['NoRujukanBPJS'] = $key['NoRujukanBPJS'];
                $pasing['NoKartuBPJS'] = $key['NoKartuBPJS'];
                $pasing['NoSuratKontrolBPJS'] = $key['NoSuratKontrolBPJS'];
                $pasing['NoSEP'] = $key['NoSEP'];
                $pasing['IdPoli'] = $key['IdPoli'];
                $pasing['PetugasInput'] = $key['PetugasInput'];
                //$rows[] = $pasing;
                $rows[] = $pasing;
            }
            // var_dump($rows);
            return $rows;
        } catch (PDOException $e) {
            return self::JsonDecode(0, $e);
        }
    }

    public function listDatareservasi2_new($data)
    {
        try {
            $sql_details = array(
                'user' => DB_USER,
                'pass' => DB_PASSWORD,
                'db'   => DB_NAME,
                'host' => DB_HOST
            );

            if ($data['iswalkin'] == 'WALKIN') {
                $wherepoli = 'and IdPoli=9';
            } else {
                $wherepoli = 'and IdPoli<>9';
            }
            $xtglawal = $data['tanggal_awal']; 
            $xtglakhir = $data['tanggal_akhir']; 
            if ($data['jenisdata'] == "1") {

$table = <<<EOT
                (SELECT a.ID,a.NoUrut,a.NoBooking,a.NoMR,a.NamaPasien,a.Alamat,a.TglLahir,
                               a.JenisPembayaran,replace(CONVERT(VARCHAR(11), a.ApmDate, 111), '/','-')  as ApmDate,a.JamPraktek,a.NoAntrianAll,
                               b.NamaUnit,c.First_Name,a.Description,a.HP,a.Datang,
                               case when a.JenisPembayaran = 'ASURANSI' THEN d.NamaPerusahaan
                               else e.NamaPerusahaan end as 'NamaPerusahaan',
                               A.NoRujukanBPJS, A.NoKartuBPJS, A.NoSuratKontrolBPJS,A.NoSEP,a.IdPoli,f.[First Name] as PetugasInput
                               from  PerawatanSQL.dbo.Apointment a
                               inner join MasterdataSQL.dbo.MstrUnitPerwatan b on a.IdPoli = b.ID
                               inner join MasterdataSQL.dbo.Doctors c on c.ID = a.DoctorID
                               left join MasterDataSQL.dbo.MstrPerusahaanAsuransi d on a.ID_Penjamin=d.ID
                               left join MasterDataSQL.dbo.MstrPerusahaanJPK e on a.ID_Penjamin=e.ID
                               left join MasterdataSQL.dbo.Employees f on f.NoPIN = a.petugas_input
                               where replace(CONVERT(VARCHAR(11), a.ApmDate, 111), '/','-') between '$xtglawal' and '$xtglakhir'
                               and a.Batal='0' and a.Datang='0' $wherepoli) temp
EOT;
            } else {
$table = <<<EOT
                (SELECT a.ID,a.NoUrut,a.NoBooking,a.NoMR,a.NamaPasien,a.Alamat,a.TglLahir,
                               a.JenisPembayaran,replace(CONVERT(VARCHAR(11), a.ApmDate, 111), '/','-')  as ApmDate,a.JamPraktek,a.NoAntrianAll,
                               b.NamaUnit,c.First_Name,a.Description,a.HP,a.Datang,
                               case when a.JenisPembayaran = 'ASURANSI' THEN d.NamaPerusahaan
                               else e.NamaPerusahaan end as 'NamaPerusahaan',
                               A.NoRujukanBPJS, A.NoKartuBPJS, A.NoSuratKontrolBPJS,A.NoSEP,a.IdPoli,f.[First Name] as PetugasInput
                               from  PerawatanSQL.dbo.Apointment a
                               inner join MasterdataSQL.dbo.MstrUnitPerwatan b on a.IdPoli = b.ID
                               inner join MasterdataSQL.dbo.Doctors c on c.ID = a.DoctorID
                               left join MasterDataSQL.dbo.MstrPerusahaanAsuransi d on a.ID_Penjamin=d.ID
                               left join MasterDataSQL.dbo.MstrPerusahaanJPK e on a.ID_Penjamin=e.ID
                               left join MasterdataSQL.dbo.Employees f on f.NoPIN = a.petugas_input
                               where replace(CONVERT(VARCHAR(11), a.jam_input, 111), '/','-') between '$xtglawal' and '$xtglakhir'
                               and a.Batal='0' and a.Datang='0' $wherepoli) temp
EOT;
            }
            // Table's primary key
            $primaryKey = 'ID';
            // var_dump($table);
            // exit;
            // Array of database columns which should be read and sent back to DataTables.
            // The `db` parameter represents the column name in the database, while the `dt`
            // parameter represents the DataTables column identifier. In this case simple
            // indexes
            $columns = array(
                array('db' => 'ID', 'dt' => 'ID'),
                array('db' => 'NoUrut', 'dt' => 'NoUrut'),
                array('db' => 'TglLahir', 'dt' => 'TglLahir'),
                array('db' => 'JamPraktek', 'dt' => 'JamPraktek'),
                array('db' => 'NoMR',  'dt' => 'NoMR'),
                array('db' => 'NamaPasien',     'dt' => 'NamaPasien'),
                array('db' => 'ApmDate',   'dt' => 'ApmDate'),
                array('db' => 'First_Name',     'dt' => 'First_Name'),
                array('db' => 'NamaUnit',     'dt' => 'NamaUnit'),
                array('db' => 'Alamat',     'dt' => 'Alamat'),
                array('db' => 'HP',     'dt' => 'HP'),
                array('db' => 'JenisPembayaran',     'dt' => 'JenisPembayaran'),
                array('db' => 'Description',     'dt' => 'Description'),
                array('db' => 'NoBooking',     'dt' => 'NoBooking'),
                array('db' => 'NoAntrianAll',     'dt' => 'NoAntrianAll'),
                array('db' => 'NamaPerusahaan',     'dt' => 'NamaPerusahaan'),
                array('db' => 'NoRujukanBPJS',     'dt' => 'NoRujukanBPJS'),
                array('db' => 'NoKartuBPJS',     'dt' => 'NoKartuBPJS'),
                array('db' => 'NoSuratKontrolBPJS',     'dt' => 'NoSuratKontrolBPJS'),
                array('db' => 'NoSEP',     'dt' => 'NoSEP'),
                array('db' => 'IdPoli',     'dt' => 'IdPoli'),
                array('db' => 'PetugasInput',     'dt' => 'PetugasInput')

            );

            return SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns);
        } catch (PDOException $e) {
            return self::JsonDecode(0, $e);
        }
    }

    public function DataReservasiPasien($data)
    {
        try {
            $datareservasipasien = "SELECT  a.NoAntrianAll, a.MrExist, a.JenisKelamin,a.id,a.NoUrut,a.NoBooking,a.NoMR,a.NamaPasien,a.Alamat,
            replace(CONVERT(VARCHAR(11), a.TglLahir, 111), '/','-') as TglLahir,
                       case when a.JenisPembayaran='PRIBADI' then '1' when a.JenisPembayaran='ASURANSI' then '2'   
                       when a.JenisPembayaran='JAMINAN PERUSAHAAN' then '5'   
                       END AS JenisPembayaran,replace(CONVERT(VARCHAR(11), a.ApmDate, 111), '/','-')  as ApmDate,
                       a.JamPraktek,a.NoAntrianAll,a.IdPoli,a.DoctorID,
                                           b.NamaUnit,c.First_Name,a.Telephone,a.HP,a.Description,A.Email,
                                           a.Kelurahan,
                                       a.Kecamatan,
                                       a.City,
                                       a.[State/Province] as provinsi,
                                       a.[ZIP/Postal Code] as kodepos,
                                       a.[Country/Region] as Medrec_Warganegara,
                                       a.Religion,
                                       a.Tipe_Idcard,
                                       a.BirthPlace,
                                       a.Education,
                                       a.Bahasa,
                                       a.Etnis,
                                       a.Mother,
                                       a.StatusMenikah,
                                       a.Ocupation,
                                       a.NoKTP,
                                       a.ID_JadwalPraktek,
                                       a.ID_Penjamin, a.NoSuratKontrolBPJS
                                           from  PerawatanSQL.dbo.Apointment a
                                           inner join MasterdataSQL.dbo.MstrUnitPerwatan b on a.IdPoli = b.ID
                                           inner join MasterdataSQL.dbo.Doctors c on c.ID = a.DoctorID
                         WHERE A.ID=:ID";
            $this->db->query($datareservasipasien);
            $this->db->bind('ID', $data['ID']);
            $this->db->execute();
            return self::JsonDecode(200, $this->db->single());
        } catch (PDOException $e) {
            self::JsonDecode('error', $e);
        }
    }
    public function JadwalDokter($data)
    {
        // var_dump($data);
        try {
            if ($data['hari'] === "Minggu") {
                $quser = "SELECT A.ID,A.First_Name 
            from MasterdataSQL.dbo.Doctors A
            INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
            inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
            WHERE A.active='1' AND B.IdLayanan=:idlayanan AND c.Minggu='1' AND c.Status_Aktif='1' group by A.ID,A.First_Name  ";
                $this->db->query($quser);
                $this->db->bind('idlayanan', $data['idlayanan']);
                $this->db->execute();
                return self::JsonDecode(200, $this->db->resultSet());
            } elseif ($data['hari'] === "Senin") {
                $quser = "SELECT A.ID,A.First_Name 
            from MasterdataSQL.dbo.Doctors A
            INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
            inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
            WHERE A.active='1' AND B.IdLayanan=:idlayanan AND c.Senin='1'AND c.Status_Aktif='1' group by A.ID,A.First_Name  ";
                $this->db->query($quser);
                $this->db->bind('idlayanan', $data['idlayanan']);
                $this->db->execute();
                return self::JsonDecode(200, $this->db->resultSet());
            } elseif ($data['hari'] === "Selasa") {
                $quser = "SELECT A.ID,A.First_Name 
            from MasterdataSQL.dbo.Doctors A
            INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
            inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
            WHERE A.active='1' AND B.IdLayanan=:idlayanan AND c.Selasa='1'AND c.Status_Aktif='1' group by A.ID,A.First_Name  ";
                $this->db->query($quser);
                $this->db->bind('idlayanan', $data['idlayanan']);
                $this->db->execute();
                return self::JsonDecode(200, $this->db->resultSet());
            } elseif ($data['hari'] === "Rabu") {
                $quser = "SELECT A.ID,A.First_Name 
            from MasterdataSQL.dbo.Doctors A
            INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
            inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
            WHERE A.active='1' AND B.IdLayanan=:idlayanan AND c.Rabu='1'AND c.Status_Aktif='1' group by A.ID,A.First_Name   ";
                $this->db->query($quser);
                $this->db->bind('idlayanan', $data['idlayanan']);
                $this->db->execute();
                return self::JsonDecode(200, $this->db->resultSet());
            } elseif ($data['hari'] === "Kamis") {
                $quser = "SELECT A.ID,A.First_Name 
            from MasterdataSQL.dbo.Doctors A
            INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
            inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
            WHERE A.active='1' AND B.IdLayanan=:idlayanan AND c.Kamis='1'AND c.Status_Aktif='1' group by A.ID,A.First_Name  ";
                $this->db->query($quser);
                $this->db->bind('idlayanan', $data['idlayanan']);
                $this->db->execute();
                return self::JsonDecode(200, $this->db->resultSet());
            } elseif ($data['hari'] === "Jumat") {
                $quser = "SELECT A.ID,A.First_Name 
            from MasterdataSQL.dbo.Doctors A
            INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
            inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
            WHERE A.active='1' AND B.IdLayanan=:idlayanan AND c.Jumat='1'AND c.Status_Aktif='1' group by A.ID,A.First_Name  ";
                $this->db->query($quser);
                $this->db->bind('idlayanan', $data['idlayanan']);
                $this->db->execute();
                return self::JsonDecode(200, $this->db->resultSet());
            } elseif ($data['hari'] === "Sabtu") {
                $quser = "SELECT A.ID,A.First_Name 
            from MasterdataSQL.dbo.Doctors A
            INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
            inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
            WHERE A.active='1' AND B.IdLayanan=:idlayanan AND c.Sabtu='1'AND c.Status_Aktif='1' group by A.ID,A.First_Name  ";
                $this->db->query($quser);
                $this->db->bind('idlayanan', $data['idlayanan']);
                $this->db->execute();
                return self::JsonDecode(200, $this->db->resultSet());
            }
            // $this->db->query($quser);
        } catch (PDOException $e) {
            return self::JsonDecode('error', $e);
        }
    }

    public function sudahPunyaMR($data)
    {
        $query = "SELECT [Home Phone],ID,Mother,NoMR, PatientName,Date_of_birth,Address,[Mobile Phone],Nik,Ocupation
        from MasterdataSQL.dbo.Admision where 
        Aktif='1' and 
        [PatientName] like :namapasien or  CONVERT(VARCHAR(10), Date_of_birth, 103) like :tgllahir";
        $this->db->query($query);
        $this->db->bind('namapasien', "%" . $data['nama'] . "%");
        $this->db->bind('tgllahir', "%" . $data['nama'] . "%");
        $this->db->execute();
        return self::JsonDecode(200, $this->db->resultSet());
    }

    public function Detailpasien($data)
    {
        // var_dump($data);
        $query = "SELECT replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as Date_of_birthx,
                NoMR,PatientName,Address,Gander,BirthPlace,Ocupation,
        case when Gander='L' then 'LAKI-LAKI' when Gander='P' then 'PEREMPUAN'  END AS NamaGander,
        ID_Card_number,[E-mail Address] as email,[Mobile Phone] as mobilephone,[Home Phone] as homephone,*
         from MasterdataSQL.dbo.Admision where ID=:ID";
        $this->db->query($query);
        $this->db->bind('ID', $data['ID']);
        $this->db->execute();
        return self::JsonDecode(200, $this->db->single());
    }

    // membuat create reservasi non walkin
    public function Buatreservasi($data)
    {
        $datenowx = date('Y-m-d');
        date_default_timezone_set('Asia/Jakarta');
        $datenowcreate = date("Y-m-d H:i:s");
        // var_dump($data);
        $MrExist = $data['MrExist'];
        $NoMr = $data['nomr'];
        $NamaPasien = $data['PasienNama'];
        $Alamat = $data['PasienAlamat'];
        $JnsKelamin = $data['jeniskelamin'];
        $TglLahir = $data['ttlpasien'];
        $PasienUsia = $data['PasienUsia'];
        $PasienPekerjaan = $data['PasienPekerjaan'];
        $PasienNIK = $data['nik'];
        $PasienNoBooking = $data['PasienNoBooking'];
        // $PasienJenisDaftar = $_POST['PasienJenisDaftar'];
        $JenisBayar = $data['idpembayaran'];
        $IdGrupPerawatan = $data['idpoliklinik'];
        $TglBookingx = $data['tglreservasi'];
        $tglregistrasi = $data['tglreservasi'];
        $shift = $data['shiftpraktek'];
        $IdDokter = $data['iddokter'];
        $NoTlp = $data['homephone'];
        $NoHp = $data['mobilephone'];
        $PasienKetReservasi = $data['Keterangan'];
        $PasienEmail = $data['email'];

        $Medical_Provinsi = $data['Medical_Provinsi'];
        $Medrec_IdPengenal = $data['Medrec_IdPengenal'];
        $Medrec_kabupaten = $data['Medrec_kabupaten'];
        $Medrec_Kecamatan = $data['Medrec_Kecamatan'];
        $Medrec_Tpt_lahir = $data['Medrec_Tpt_lahir'];
        $Medrec_Kelurahan = $data['Medrec_Kelurahan'];
        $Medrec_statusNikah = $data['Medrec_statusNikah'];
        $Medical_Agama = $data['Medical_Agama'];

        $Medrec_Bahasa = $data['Medrec_Bahasa'];
        $Medrec_Warganegara = $data['Medrec_Warganegara'];
        $Medrec_Kodepos = $data['Medrec_Kodepos'];
        $Medrec_Pendidikan = $data['Medrec_Pendidikan'];
        $Medrec_Etnis = $data['Medrec_Etnis'];
        $Medrec_NamaIbuKandung = $data['Medrec_NamaIbuKandung'];


        //var_dump($Medrec_Bahasa);exit;iduser

        $jampraktek = $data['jampraktek'];
        $penjamin = $data['penjamin'];


        $idkananxres = substr($data['tglreservasi'], 8); // xx-xx-03 kanan
        $idtengahxres = substr($data['tglreservasi'], -5, -3); //
        $tglres = substr($data['tglreservasi'], 0, -8);
        $idbookingres =   $tglres . $idtengahxres . $idkananxres;
        $TglBookingx = $data['tglreservasi'];
        $idkananxcat = substr($TglBookingx, 8);
        $idtengahxres = substr($TglBookingx, -5, -3);
        $tgl = substr($TglBookingx, 0, -8);
        $idbooking =   $tgl . $idtengahxres . $idkananxcat;
        $pembayaran = "";

        if ($data['iduser'] == '') {
            $userid = '000L';
        } else {
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
        }

        if (isset($data['BPJS_xNorujukan'])) {
            $BPJS_xNorujukan = $data['BPJS_xNorujukan'];

            if ($BPJS_xNorujukan == '') {
                $BPJS_xNorujukan = null;
            }
        } else {
            $BPJS_xNorujukan = null;
        }

        if (isset($data['BPJS_NoKartu'])) {
            $BPJS_NoKartu = $data['BPJS_NoKartu'];

            if ($BPJS_NoKartu == '') {
                $BPJS_NoKartu = null;
            }
        } else {
            $BPJS_NoKartu = null;
        }

        if (isset($data['BPJS_NoSEP'])) {
            $BPJS_NoSEP = $data['BPJS_NoSEP'];

            if ($BPJS_NoSEP == '') {
                $BPJS_NoSEP = null;
            }
        } else {
            $BPJS_NoSEP = null;
        }

        if (isset($data['BPJS_NoRencKontrol'])) {
            $BPJS_NoRencKontrol = $data['BPJS_NoRencKontrol'];

            if ($BPJS_NoRencKontrol == '') {
                $BPJS_NoRencKontrol = null;
            }
        } else {
            $BPJS_NoRencKontrol = null;
        }





        switch ($data['idpembayaran']) {
            case 1:
                $pembayaran = "PRIBADI";
                break;
            case 2:
                $pembayaran = "ASURANSI";
                break;
            case 5:
                $pembayaran = "JAMINAN PERUSAHAAN";
                break;
            default:
                $pembayaran = "PRIBADI";
        }
        // cek jadwal 
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
                    ,Senin_Akhir,Selasa_Akhir,Rabu_Akhir,Kamis_akhir,Jumat_Akhir,Sabtu_Akhir,Minggu_Akhir
                    FROM MasterdataSQL.DBO.JadwalPraktek WHERE ID=:IDJadwal");
        $this->db->bind('IDJadwal', $jampraktek);
        $dtjdwl =  $this->db->single();
        $jampraktekx = $dtjdwl['Minggu_Waktu'];
        if ($datename == "Sunday") {
            $jampraktekx = $dtjdwl['Minggu_Waktu'];
            $MaxHari = $dtjdwl['Minggu_Max'];
            $Max_NonJKN = $dtjdwl['Minggu_Max_NonJKN'];
            $Max_JKN = $dtjdwl['Minggu_Max_JKN'];
            $JamPraktekAkhir = $dtjdwl['Minggu_Akhir'];
        } elseif ($datename == "Monday") {
            $jampraktekx = $dtjdwl['Senin_Waktu'];
            $MaxHari = $dtjdwl['Senin_Max'];
            $Max_NonJKN = $dtjdwl['Senin_Max_NonJKN'];
            $Max_JKN = $dtjdwl['Senin_Max_JKN'];
            $JamPraktekAkhir = $dtjdwl['Senin_Akhir'];
        } elseif ($datename == "Tuesday") {
            $jampraktekx = $dtjdwl['Selasa_Waktu'];
            $MaxHari = $dtjdwl['Selasa_Max'];
            $Max_NonJKN = $dtjdwl['Selasa_Max_NonJKN'];
            $Max_JKN = $dtjdwl['Selasa_Max_JKN'];
            $JamPraktekAkhir = $dtjdwl['Selasa_Akhir'];
        } elseif ($datename == "Wednesday") {
            $jampraktekx = $dtjdwl['Rabu_Waktu'];
            $MaxHari = $dtjdwl['Rabu_Max'];
            $Max_NonJKN = $dtjdwl['Rabu_Max_NonJKN'];
            $Max_JKN = $dtjdwl['Rabu_Max_JKN'];
            $JamPraktekAkhir = $dtjdwl['Rabu_Akhir'];
        } elseif ($datename == "Thursday") {
            $jampraktekx = $dtjdwl['Kamis_Waktu'];
            $MaxHari = $dtjdwl['Kamis_Max'];
            $Max_NonJKN = $dtjdwl['Kamis_Max_NonJKN'];
            $Max_JKN = $dtjdwl['Kamis_Max_JKN'];
            $JamPraktekAkhir = $dtjdwl['Kamis_akhir'];
        } elseif ($datename == "Friday") {
            $jampraktekx = $dtjdwl['Jumat_Waktu'];
            $MaxHari = $dtjdwl['Jumat_Max'];
            $Max_NonJKN = $dtjdwl['Jumat_Max_NonJKN'];
            $Max_JKN = $dtjdwl['Jumat_Max_JKN'];
            $JamPraktekAkhir = $dtjdwl['Jumat_Akhir'];
        } elseif ($datename == "Saturday") {
            $jampraktekx = $dtjdwl['Sabtu_Waktu'];
            $MaxHari = $dtjdwl['Sabtu_Max'];
            $Max_NonJKN = $dtjdwl['Sabtu_Max_NonJKN'];
            $Max_JKN = $dtjdwl['Sabtu_Max_JKN'];
            $JamPraktekAkhir = $dtjdwl['Sabtu_Akhir'];
        }

        if ($MaxHari == '0') {
            $callback = array(
                'statusmessage' => "warning",
                'errorname' => "Kuota Hari Tersebut Masih Kosong, Silahkan Dicek Terlebih Dahulu !",
                //'errormessage' => $dataidregfieedback,    
            );
            return self::JsonDecode(200, $callback, "warning");
        }

        // cek jadwal
        // START - VALIDASI KUOTA
        $koutaPerPoli = [];
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
            $this->db->bind('TglKunjungan', $tglregistrasi);
            $this->db->bind('Batal', '0');
            $this->db->bind('Doctor_1', $IdDokter);
            $this->db->bind('IdPoli', $IdGrupPerawatan);
            $this->db->bind('Minggu_Waktu', $jampraktekx);
            $this->db->bind('TglKunjungan2', $tglregistrasi);
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
            $this->db->bind('TglKunjungan', $tglregistrasi);
            $this->db->bind('Batal', '0');
            $this->db->bind('Doctor_1', $IdDokter);
            $this->db->bind('IdPoli', $IdGrupPerawatan);
            $this->db->bind('Senin_Waktu', $jampraktekx);
            $this->db->bind('TglKunjungan2', $tglregistrasi);
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
            $this->db->bind('TglKunjungan', $tglregistrasi);
            $this->db->bind('Batal', '0');
            $this->db->bind('Doctor_1', $IdDokter);
            $this->db->bind('IdPoli', $IdGrupPerawatan);
            $this->db->bind('Selasa_Waktu', $jampraktekx);
            $this->db->bind('TglKunjungan2', $tglregistrasi);
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
            $this->db->bind('TglKunjungan', $tglregistrasi);
            $this->db->bind('Batal', '0');
            $this->db->bind('Doctor_1', $IdDokter);
            $this->db->bind('IdPoli', $IdGrupPerawatan);
            $this->db->bind('Rabu_Waktu', $jampraktekx);
            $this->db->bind('TglKunjungan2', $tglregistrasi);
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
            $this->db->bind('TglKunjungan', $tglregistrasi);
            $this->db->bind('Batal', '0');
            $this->db->bind('Doctor_1', $IdDokter);
            $this->db->bind('IdPoli', $IdGrupPerawatan);
            $this->db->bind('Kamis_Waktu', $jampraktekx);
            $this->db->bind('TglKunjungan2', $tglregistrasi);
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
            $this->db->bind('TglKunjungan', $tglregistrasi);
            $this->db->bind('Batal', '0');
            $this->db->bind('Doctor_1', $IdDokter);
            $this->db->bind('IdPoli', $IdGrupPerawatan);
            $this->db->bind('Jumat_Waktu', $jampraktekx);
            $this->db->bind('TglKunjungan2', $tglregistrasi);
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
            $this->db->bind('TglKunjungan', $tglregistrasi);
            $this->db->bind('Batal', '0');
            $this->db->bind('Doctor_1', $IdDokter);
            $this->db->bind('IdPoli', $IdGrupPerawatan);
            $this->db->bind('Sabtu_Waktu', $jampraktekx);
            $this->db->bind('TglKunjungan2', $tglregistrasi);
            $this->db->bind('Batal2', '0');
            $this->db->bind('Doctor_12', $IdDokter);
            $this->db->bind('IdPoli2', $IdGrupPerawatan);
            $this->db->bind('Sabtu_Waktu2', $jampraktekx);
            $xe = $this->db->single();
            $koutaPerPoli = $xe['total'];
        }
        // return $tglregistrasi. ' - '. $IdDokter. ' - '. $IdGrupPerawatan. ' - '. $jampraktekx . ' - : ' . $koutaPerPoli; exit;
        $Ant = $koutaPerPoli + 1;
        if ($JenisBayar == '5' && $penjamin == '313') {
            if ($koutaPerPoli >= $Max_JKN) {
                $callback = array(
                    'statusmessage' => 'warning',
                    'errorname' => "Kuota Dokter : " . $data['namadokter'] . ", Hari : " . $datename . " Sudah Penuh, Kuota Maksimal " . $Max_JKN . ", No. Antrian Pasien Saat ini Adalah : " .  $Ant . ". Silahkan Pilih tanggal Lain untuk Melakukan Booking/Reservasi kembali",
                    'errormessage' => '',
                    // 'nama' => $data['nama'], // Set array nama dengan isi kolom nama pada tabel siswa    
                );
                return self::JsonDecode(200, $callback, "warning");
            }
        } else {
            if ($koutaPerPoli >= $Max_NonJKN) {
                $callback = array(
                    'statusmessage' => 'warning',
                    'errorname' => "Kuota Dokter : " . $data['namadokter'] . ", Hari : " . $datename . " Sudah Penuh, Kuota Maksimal " . $Max_NonJKN . ", No. Antrian Pasien Saat ini Adalah : " .  $Ant . ". Silahkan Pilih tanggal Lain untuk Melakukan Booking/Reservasi kembali",
                    'errormessage' => '',
                    // 'nama' => $data['nama'], // Set array nama dengan isi kolom nama pada tabel siswa    
                );
                return self::JsonDecode(200, $callback, "warning");
            }
        }

        // END - VALIDASI KUOTA
        try {
            $this->db->transaksi();
            // mendapatkan data poli
            $queryDataPoli = "SELECT NamaUnit from MasterdataSQL.dbo.MstrUnitPerwatan where id=:ID";
            $this->db->query($queryDataPoli);
            $this->db->bind('ID', $IdGrupPerawatan);
            $this->db->execute();
            $namapoli = $this->db->single();
            $viewNamaPoliklinik = $namapoli['NamaUnit'];
            // Query Dokter
            $querydokter = "SELECT First_Name from MasterdataSQL.dbo.Doctors where id=:ID";
            $this->db->query($querydokter);
            $this->db->bind('ID', $IdDokter);
            $this->db->execute();
            $namadokter = $this->db->single();
            // cek jika nomor booking sudah ada
            if ($PasienNoBooking != "") {
                $datenowcreate = date("Y-m-d H:i:s");
                $updatedatapasien = "UPDATE perawatanSQL.dbo.Apointment SET 
                NoMR=:NoMrfix,
                TglLahir=:TglLahir,
                JenisKelamin=:JnsKelamin,
                Status='1',
                NamaPasien=:NamaPasien,
                MrExist=:MrExist,
                JenisPembayaran=:kodejenispayment,
                Telephone=:NoTlp,
                HP=:NoHp,
                Alamat=:Alamat,
                Description=:PasienKetReservasi,
                Email=:PasienEmail,
                NoKTP=:NoKTP,
                petugas_edit=:petugas_edit,
                jam_edit =:jam_edit,
                Kelurahan=:Medrec_Kelurahan,Kecamatan=:Medrec_Kecamatan,City=:Medrec_kabupaten,[State/Province]=:Medical_Provinsi,
                [ZIP/Postal Code]=:Medrec_Kodepos,
                                       [Country/Region]=:Medrec_Warganegara,
                                       Religion=:Medical_Agama,
                                       Tipe_Idcard=:Medrec_IdPengenal,
                                       BirthPlace=:Medrec_Tpt_lahir,
                                       Education=:Medrec_Pendidikan,
                                       Bahasa=:Medrec_Bahasa,
                                       Etnis=:Medrec_Etnis,
                                       Mother=:Medrec_NamaIbuKandung,
                                       Ocupation=:PasienPekerjaan,
                                       StatusMenikah=:Medrec_statusNikah
                WHERE NoBooking=:PasienNoBooking";
                $this->db->query($updatedatapasien);
                $this->db->bind('PasienNoBooking', $PasienNoBooking);
                $this->db->bind('NoMrfix', $data['nomr'] == '' ? null : $data['nomr']);
                $this->db->bind('TglLahir', $TglLahir);
                $this->db->bind('JnsKelamin', $JnsKelamin);
                $this->db->bind('NamaPasien', $NamaPasien);
                $this->db->bind('MrExist', $MrExist);
                $this->db->bind('kodejenispayment', $pembayaran);
                $this->db->bind('NoTlp', $NoTlp);
                $this->db->bind('NoHp', $NoHp);
                $this->db->bind('NoKTP', $data['nik']);
                $this->db->bind('Alamat', $Alamat);
                $this->db->bind('PasienKetReservasi', $PasienKetReservasi);
                $this->db->bind('PasienEmail', $PasienEmail);
                $this->db->bind('petugas_edit', $userid);
                $this->db->bind('jam_edit', $datenowcreate);

                $this->db->bind('Medical_Provinsi', $Medical_Provinsi);
                $this->db->bind('Medrec_IdPengenal', $Medrec_IdPengenal);
                $this->db->bind('Medrec_kabupaten', $Medrec_kabupaten);
                $this->db->bind('Medrec_Kecamatan', $Medrec_Kecamatan);
                $this->db->bind('Medrec_Tpt_lahir', $Medrec_Tpt_lahir);
                $this->db->bind('Medrec_Kelurahan', $Medrec_Kelurahan);
                $this->db->bind('Medrec_statusNikah', $Medrec_statusNikah);
                $this->db->bind('Medical_Agama', $Medical_Agama);

                $this->db->bind('Medrec_Bahasa', $Medrec_Bahasa);
                $this->db->bind('Medrec_Warganegara', $Medrec_Warganegara);
                $this->db->bind('Medrec_Kodepos', $Medrec_Kodepos);
                $this->db->bind('Medrec_Pendidikan', $Medrec_Pendidikan);
                $this->db->bind('Medrec_Etnis', $Medrec_Etnis);
                $this->db->bind('Medrec_NamaIbuKandung', $Medrec_NamaIbuKandung);
                $this->db->bind('PasienPekerjaan', $PasienPekerjaan);
                $this->db->execute();
                $this->db->Commit();
                // echo "data update";
                return self::JsonDecode(200, 'Registrasi ' . $data['PasienNoBooking'] . " Berhasil Di perbaharui", "updated");
            } else {
                // dokter cuti
                $idkananx = substr($TglBookingx, 6); // xx-xx-03 kanan
                $idkananxcat = substr($TglBookingx, 8);
                $idtengahxres = substr($TglBookingx, -5, -3);
                $tgl = substr($TglBookingx, 2, 2);
                $idbooking =   $idkananxcat . $idtengahxres . $tgl;
                $tglbookingfix =  $TglBookingx;

                $idkananxres = substr($TglBookingx, 8); // xx-xx-03 kanan
                $idtengahxres = substr($TglBookingx, -5, -3); //
                $tglres = substr($TglBookingx, 2, 2);
                $idbookingres =    $idkananxres . $idtengahxres . $tglres;
                //   var_dump($idbookingres);

                $cutidokter = "SELECT *FROM MasterdataSQL.dbo.TR_CUTI_DOKTER
                where :tglreservasi
                between MasterdataSQL.dbo.TR_CUTI_DOKTER.periode_awal 
                and MasterdataSQL.dbo.TR_CUTI_DOKTER.periode_akhir 
                and id_dokter=:id_dokter and Batal='0' ";
                $this->db->query($cutidokter);
                $this->db->bind('id_dokter', $IdDokter);
                $this->db->bind('tglreservasi', $TglBookingx);
                $this->db->execute();
                $jadwalcutidokter = $this->db->single();
                if (!empty($jadwalcutidokter)) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => "Dokter Yang Anda Pilih sedang Cuti !",
                        'errormessage' => '',
                        // 'nama' => $data['nama'], // Set array nama dengan isi kolom nama pada tabel siswa    
                    );
                    return self::JsonDecode(200, $callback, "warning");
                    // $response = array(
                    //     'status' => 'success',
                    //     'statusmessage' => 'warning',
                    //     'code' => 200,
                    //     'response' => "Dokter Yang Anda Pilih sedang Cuti !",
                    //     'errorname' => "Warning !",
                    //     'errormessage' => "Dokter Yang Anda Pilih sedang Cuti !",
                    // );
                    // return $response;
                } else {
                    // CARI NILAI PALING AKHIR
                    $urut = "SELECT max(ID) as urut from PerawatanSQL.dbo.Apointment ";
                    $this->db->query($urut);
                    $this->db->execute();
                    $nomorurut = $this->db->single();
                    $no_pass = $nomorurut['urut'];
                    $id = $no_pass;
                    $id++;
                    // var_dump($id);
                    //CONVERT No. Mr
                    $idkanan = substr($NoMr, 4); // xx-xx-03 kanan
                    $idtengah = substr($NoMr, 2, -2); //
                    $idkiri = substr($NoMr, 0, -4);
                    $NoMrfix =   $idkiri . '-' . $idtengah . '-' . $idkanan;
                    // var_dump($NoMrfix);
                    // methode get no antrian per poli
                    // GENERATE NO ANTRIAN POLI
                    $antrian = "SELECT max(Antrian) as urutantrian
                        from PerawatanSQL.dbo.AntrianPasien  where  
                        replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-')
                        =:tglreservasi and JamPraktek=:JamPraktek and Doctor_1=:Doctor_1 ";
                    $this->db->query($antrian);
                    $this->db->bind('tglreservasi', $TglBookingx);
                    $this->db->bind('JamPraktek', $shift);
                    $this->db->bind('Doctor_1', $IdDokter);
                    $this->db->execute();
                    $nomorantrian = $this->db->single(); //ini hasilnya null
                    // var_dump($nomorantrian);
                    //     // no urut op
                    $no_urutantrian = $nomorantrian['urutantrian'];
                    $idno_urutantrian = $no_urutantrian;
                    $idno_urutantrian++;
                    // var_dump("Nomor antrian" . $idno_urutantrian);
                    // CARI KODE ANTRIAN DOKTER
                    $antriandokter = "SELECT *from MasterdataSQL.dbo.Doctors  where ID=:ID ";
                    $this->db->query($antriandokter);
                    $this->db->bind('ID', $IdDokter);
                    $this->db->execute();
                    $nomorantriandokter = $this->db->single();
                    $CodeAntrian = $nomorantriandokter['CodeAntrian'];
                    // var_dump($CodeAntrian);
                    // GENERATE NO BOKING
                    $GENERATE_No_booking = "SELECT  TOP 1 NoBooking ,right(NoBooking,3) as urut ,NoUrut
                         FROM PerawatanSQl.dbo.Apointment 
                         WHERE  replace(CONVERT(VARCHAR(11), ApmDate, 111), '/','-')
                         =:tglbooking  order by nourut desc";
                    $this->db->query($GENERATE_No_booking);
                    $this->db->bind('tglbooking', $TglBookingx);
                    $this->db->execute();
                    $GENERATEbooking = $this->db->single();
                    // var_dump($GENERATEbooking);
                    //     // no urut op
                    $no_urutbokingtempo = $GENERATEbooking['NoUrut'];
                    $nouruttrx = $GENERATEbooking['NoUrut'];
                    $no_urutbokingtempo = $no_urutbokingtempo;
                    $no_urutbokingtempo++;
                    // var_dump($no_urutbokingtempo);
                    $nouruttrx++;
                    //     // GENERATE NO REGISTRASI
                    if (strlen($no_urutbokingtempo) == 1) {
                        $nourutbokingsebenernya = "00" . $no_urutbokingtempo;
                    } else if (strlen($no_urutbokingtempo) == 2) {
                        $nourutbokingsebenernya = "0" . $no_urutbokingtempo;
                    } else if (strlen($no_urutbokingtempo) == 3) {
                        $nourutbokingsebenernya = $no_urutbokingtempo;
                    }
                    $xcode = 'BORJ';
                    $datenow = $idbookingres;

                    $nobokingreal = $xcode . $datenow . '-' . $nourutbokingsebenernya;

                    if (isset($data['ID_KontrolUlangEMR'])) {
                        $sqlkontrolulang = "UPDATE MedicalRecord.dbo.MR_DaftarKontrolUlang set NoReservasi=:nobokingreal WHERE ID=:id";
                        $this->db->query($sqlkontrolulang);
                        $this->db->bind('id', $data['ID_KontrolUlangEMR']);
                        $this->db->bind('nobokingreal', $nobokingreal);
                        $this->db->execute();

                        $sqlkontrolulang_del = "DELETE MedicalRecord.dbo.MR_DaftarKontrolUlang  WHERE ID<>:id AND NoReservasi is null AND NoRegistrasi in (SELECT NoRegistrasi FROM MedicalRecord.dbo.MR_DaftarKontrolUlang WHERE ID=:id2)";
                        $this->db->query($sqlkontrolulang_del);
                        $this->db->bind('id', $data['ID_KontrolUlangEMR']);
                        $this->db->bind('id2', $data['ID_KontrolUlangEMR']);
                        $this->db->execute();
                    }
                    if ($MrExist == 1) {
                        $bookingnomor = "SELECT NoBooking
                                FROM PerawatanSQl.dbo.Apointment 
                                WHERE  replace(CONVERT(VARCHAR(11), ApmDate, 111), '/','-')=:tglbookingfix and NoMR =:NoMr
                                and idPoli=:IdGrupPerawatan and DoctorID=:IdDokter and Batal='0'";
                        $this->db->query($bookingnomor);
                        $this->db->bind('tglbookingfix', $tglbookingfix);
                        $this->db->bind('NoMr', $NoMr);
                        $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                        $this->db->bind('IdDokter', $IdDokter);
                        $this->db->execute();
                        $booking = $this->db->single();
                        if (!empty($booking)) {
                            $dataidregfieedback = $booking['NoBooking'];
                            $callback = array(
                                'errorname' => "Pasien Sudah Reservasi di Poli dan Dokter yang sama !", // Set array nama dengan isi kolom nama pada tabel siswa
                                'errormessage' => $dataidregfieedback,
                                // 'nama' => $data['nama'], // Set array nama dengan isi kolom nama pada tabel siswa    
                            );
                            return self::JsonDecode(200, $callback, 'warning');
                        } else {
                            // fix no antrian
                            $fixNoAntrian = $CodeAntrian . '-' . $idno_urutantrian;
                            // Inseert to booking
                            $xres = $idbookingres . '-' . $idno_urutantrian;
                            $insertbooking = "INSERT INTO perawatanSQL.dbo.Apointment (
                                        CodeReservasi,
                                        CategoriReservasi,
                                        NoUrut,
                                        NoMR,
                                        TglLahir,
                                       JenisKelamin,
                                       StatusMenikah,
                                       IdPoli,
                                       Poli,
                                       DoctorID,
                                       NamaDokter,
                                       Status,
                                       JamPraktek, 
                                       Antrian,
                                       NoAntrianAll ,
                                       NamaPasien,
                                       ApmDate,
                                       NoBooking,
                                       NoReservasi,
                                       MrExist,
                                       Company,
                                       JenisPembayaran,
                                       Telephone,
                                       HP,
                                       Alamat ,
                                       Description,
                                       Email,
                                       jam_input,
                                       petugas_input,
                                       NoKTP,
                                       
                                       Kelurahan,
                                       Kecamatan,
                                       City,
                                       [State/Province],
                                       [ZIP/Postal Code],
                                       [Country/Region],
                                       Religion,
                                       Tipe_Idcard,
                                       BirthPlace,
                                       Education,
                                       Bahasa,
                                       Etnis,
                                       Mother,
                                       Ocupation,
                                       ID_JadwalPraktek,
                                       ID_Penjamin,
                                       
                                       NoRujukanBPJS,
                                       NoKartuBPJS,
                                       NoSEP,
                                       NoSuratKontrolBPJS
                                       ) VALUES ( 
                                       :idbooking,
                                       '1',
                                       :nouruttrx,
                                       :NoMr,
                                       :TglLahir,
                                       :JnsKelamin,
                                       :Medrec_statusNikah,
                                       :IdGrupPerawatan,
                                       :NamaGrupPerawatan,
                                       :IdDokter,
                                       :NamaDokter,
                                       '1',
                                       :shift,
                                       :idno_urutantrian,
                                       :fixNoAntrian,
                                       :NamaPasien,
                                       :tglbookingfix,
                                       :nobokingreal,
                                       :xres,
                                       :MrExist,
                                       'RS YARSI WEB',
                                       :kodejenispayment,
                                       :NoTlp,
                                       :NoHp,
                                       :Alamat,
                                       :PasienKetReservasi,
                                       :PasienEmail,
                                       :datenowcreate,
                                       :operator,
                                       :noktp,

                                       :Medrec_Kelurahan,
                                       :Medrec_Kecamatan,
                                       :Medrec_kabupaten,
                                       :Medical_Provinsi,
                                       :Medrec_Kodepos,
                                       :Medrec_Warganegara,
                                       :Medical_Agama,
                                       :Medrec_IdPengenal,
                                       :Medrec_Tpt_lahir,
                                       :Medrec_Pendidikan,
                                       :Medrec_Bahasa,
                                       :Medrec_Etnis,
                                       :Medrec_NamaIbuKandung,
                                       :PasienPekerjaan,
                                       :jampraktek,
                                       :penjamin,
                                       
                                       :BPJS_xNorujukan,
                                       :BPJS_NoKartu,
                                       :BPJS_NoSEP,
                                       :BPJS_NoRencKontrol
                                       
                                       )";

                            $this->db->query($insertbooking);
                            $this->db->bind('idbooking', $idbooking);
                            $this->db->bind('nouruttrx', $nouruttrx);
                            $this->db->bind('NoMr', $NoMr == '' ? null : $NoMr);
                            $this->db->bind('TglLahir', $TglLahir);
                            $this->db->bind('JnsKelamin', $JnsKelamin);
                            $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                            $this->db->bind('NamaGrupPerawatan', $data['namapoliklinik']);
                            $this->db->bind('IdDokter', $IdDokter);
                            $this->db->bind('NamaDokter', $namadokter['First_Name']);
                            $this->db->bind('shift', $shift);
                            $this->db->bind('idno_urutantrian', $idno_urutantrian);
                            $this->db->bind('fixNoAntrian', $fixNoAntrian);
                            $this->db->bind('NamaPasien', $NamaPasien);
                            $this->db->bind('tglbookingfix', $tglbookingfix);
                            $this->db->bind('nobokingreal', $nobokingreal);
                            $this->db->bind('xres', $xres);
                            $this->db->bind('MrExist', $MrExist);
                            $this->db->bind('kodejenispayment', $pembayaran);
                            $this->db->bind('NoTlp', $NoTlp);
                            $this->db->bind('NoHp', $NoHp);
                            $this->db->bind('Alamat', $Alamat);
                            $this->db->bind('PasienKetReservasi', $PasienKetReservasi);
                            $this->db->bind('PasienEmail', $PasienEmail);
                            $this->db->bind('datenowcreate', $datenowcreate);
                            $this->db->bind('operator', $userid);
                            $this->db->bind('noktp', $data['nik']);

                            $this->db->bind('Medical_Provinsi', $Medical_Provinsi);
                            $this->db->bind('Medrec_IdPengenal', $Medrec_IdPengenal);
                            $this->db->bind('Medrec_kabupaten', $Medrec_kabupaten);
                            $this->db->bind('Medrec_Kecamatan', $Medrec_Kecamatan);
                            $this->db->bind('Medrec_Tpt_lahir', $Medrec_Tpt_lahir);
                            $this->db->bind('Medrec_Kelurahan', $Medrec_Kelurahan);
                            $this->db->bind('Medrec_statusNikah', $Medrec_statusNikah);
                            $this->db->bind('Medical_Agama', $Medical_Agama);

                            $this->db->bind('Medrec_Bahasa', $Medrec_Bahasa);
                            $this->db->bind('Medrec_Warganegara', $Medrec_Warganegara);
                            $this->db->bind('Medrec_Kodepos', $Medrec_Kodepos);
                            $this->db->bind('Medrec_Pendidikan', $Medrec_Pendidikan);
                            $this->db->bind('Medrec_Etnis', $Medrec_Etnis);
                            $this->db->bind('Medrec_NamaIbuKandung', $Medrec_NamaIbuKandung);
                            $this->db->bind('PasienPekerjaan', $PasienPekerjaan);
                            $this->db->bind('jampraktek', $jampraktek);
                            $this->db->bind('penjamin', $penjamin);

                            $this->db->bind('BPJS_xNorujukan', $BPJS_xNorujukan);
                            $this->db->bind('BPJS_NoKartu', $BPJS_NoKartu);
                            $this->db->bind('BPJS_NoSEP', $BPJS_NoSEP);
                            $this->db->bind('BPJS_NoRencKontrol', $BPJS_NoRencKontrol);

                            $this->db->execute();
                            $antianpasienwalkin = "INSERT INTO perawatanSQL.dbo.AntrianPasien (
                                        no_transaksi,
                                        Doctor_1,
                                        JamPraktek,
                                        Antrian,
                                        noAntrianAll,
                                        TglKunjungan,
                                        Company
                                        )VALUES
                                        (
                                        :nobokingreal,
                                        :IdDokter,
                                        :shift,
                                        :idno_urutantrian,
                                        :fixNoAntrian,
                                        :tglbookingfix,
                                        'RS YARSI WEB')";
                            $this->db->query($antianpasienwalkin);
                            $this->db->bind('nobokingreal', $nobokingreal);
                            $this->db->bind('IdDokter', $IdDokter);
                            $this->db->bind('shift', $shift);
                            $this->db->bind('idno_urutantrian', $idno_urutantrian);
                            $this->db->bind('fixNoAntrian', $fixNoAntrian);
                            $this->db->bind('tglbookingfix', $tglbookingfix);
                            $this->db->execute();
                            $datalog = [
                                'noregistrasi' => $nobokingreal,
                                'nama_biling' => "Administrasi Pasien NonWalkin",
                                'petugas_entry' => $data['iduser'],
                                'tgl_entry' => date("Y-m-d H:i:s")
                            ];
                            $this->logAlasan($datalog);

                            $replacenumberhp = Utils::hp($NoHp);
                            $replacenumberhpDokter = Utils::hp($nomorantriandokter['Mob_Phone']);
                            // $gettoken = $this->getTokenWapin();

                            $arr_data = array(
                                'ID_JadwalPraktek' => $jampraktek,
                                'tglreservasi' => $TglBookingx,
                                'IdDokter' => $IdDokter,
                                'IdPoli' => $IdGrupPerawatan,
                            );
                            $getwaktujadwal = $this->getWaktuPraktek($arr_data);

                            $this->sendNotifWapin(
                                '',
                                $replacenumberhp,
                                $data['PasienNama'],
                                $nobokingreal,
                                date("d-m-Y", strtotime($TglBookingx)),
                                $getwaktujadwal,
                                $viewNamaPoliklinik,
                                $namadokter['First_Name'],
                                $fixNoAntrian,
                                $NoMr == '' ? '-' : $NoMr
                            );

                            // MATIIN INI KALO MAU TEST
                            if ($IdGrupPerawatan <> '9' && $IdGrupPerawatan <> '10') {
                                // $this->sendNotifWapinDokter(
                                //     '',
                                //     $replacenumberhpDokter,
                                //     $namadokter['First_Name'],
                                //     $data['PasienNama'],
                                //     $nobokingreal,
                                //     date("d-m-Y", strtotime($TglBookingx)),
                                //     $getwaktujadwal,
                                //     $viewNamaPoliklinik,
                                //     $namadokter['First_Name'],
                                //     $fixNoAntrian
                                // );
                            }
                            $this->db->Commit();
                            $callback = array(
                                'status' => 'success',
                                'NoBoking' => $nobokingreal,
                                'NoAntrianPoli' => $fixNoAntrian,
                                'IdDokter' => $namadokter,
                                'IdPoli' => $IdGrupPerawatan,
                                'mrexist' => $MrExist,
                                'NoAntrianAll' =>  $fixNoAntrian,
                                'First_Name' =>  $namadokter['First_Name'],
                            );
                            return self::JsonDecode(200, $callback, 'success');
                        }
                    } else {
                        // fix no antrian
                        $fixNoAntrian = $CodeAntrian . '-' . $idno_urutantrian;
                        // var_dump("Nomor antrian fix" . $fixNoAntrian);
                        $xres = $idbookingres . '-' . $idno_urutantrian;
                        // var_dump("nomor xres" . $xres);
                        $insertbookingmr0 = "INSERT INTO perawatanSQL.dbo.Apointment (
                            CodeReservasi,
                            CategoriReservasi,
                            NoUrut,
                            TglLahir,
                            JenisKelamin,
                            IdPoli,
                            Poli,
                            DoctorID,
                            NamaDokter,
                            Status,
                            JamPraktek, 
                            Antrian,
                            NoAntrianAll,
                            NamaPasien,
                            ApmDate,
                            NoBooking,
                            NoReservasi,
                            MrExist,
                            Company,
                            JenisPembayaran,
                            Telephone,
                            HP,
                            Alamat,
                            Description,
                            Email,
                            jam_input,
                            petugas_input,
                            NoKTP,
                            StatusMenikah,
                            Kelurahan,
                            Kecamatan,
                            City,
                            [State/Province],
                            [ZIP/Postal Code],
                            [Country/Region],
                            Religion,
                            Tipe_Idcard,
                            BirthPlace,
                            Education,
                            Bahasa,
                            Etnis,
                            Mother,
                            Ocupation,
                            ID_JadwalPraktek,
                            ID_Penjamin,

                            NoRujukanBPJS,
                            NoKartuBPJS,
                            NoSEP,
                            NoSuratKontrolBPJS
                            ) 
                            VALUES 
                            ( 
                                :idbooking,
                                '1',
                                :nouruttrx,
                                :TglLahir,
                                :JnsKelamin,
                                :IdGrupPerawatan,
                                :NamaGrupPerawatan,
                                :IdDokter,
                                :NamaDokter,
                                '1',
                                :shift,
                                :idno_urutantrian,
                                :fixNoAntrian,
                                :NamaPasien,
                                :TglBookingx,
                                :nobokingreal,
                                :xres,
                                :MrExist,
                                'RS YARSI WEB',
                                :kodejenispayment,
                                :NoTlp,
                                :NoHp,
                                :Alamat,
                                :PasienKetReservasi,
                                :PasienEmail,
                                :datenowcreate,
                                :operator,
                                :NoKTP,
                                 :Medrec_statusNikah,
                                :Medrec_Kelurahan,
                                :Medrec_Kecamatan,
                                :Medrec_kabupaten,
                                :Medical_Provinsi,
                                :Medrec_Kodepos,
                                :Medrec_Warganegara,
                                :Medical_Agama,
                                :Medrec_IdPengenal,
                                :Medrec_Tpt_lahir,
                                :Medrec_Pendidikan,
                                :Medrec_Bahasa,
                                :Medrec_Etnis,
                                :Medrec_NamaIbuKandung,
                                 :PasienPekerjaan,
                                 :jampraktek,
                                 :penjamin,

                                :BPJS_xNorujukan,
                                :BPJS_NoKartu,
                                :BPJS_NoSEP,
                                :BPJS_NoRencKontrol
                            )";
                        $this->db->query($insertbookingmr0);
                        $this->db->bind('idbooking', $idbooking);
                        $this->db->bind('nouruttrx', $nouruttrx);
                        $this->db->bind('TglLahir', $TglLahir);
                        $this->db->bind('JnsKelamin', $JnsKelamin);
                        $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                        $this->db->bind('NamaGrupPerawatan', $data['namapoliklinik']);
                        $this->db->bind('IdDokter', $IdDokter);
                        $this->db->bind('NamaDokter', $namadokter['First_Name']);
                        $this->db->bind('shift', $shift);
                        $this->db->bind('idno_urutantrian', $idno_urutantrian);
                        $this->db->bind('fixNoAntrian', $fixNoAntrian);
                        $this->db->bind('NamaPasien', $NamaPasien);
                        $this->db->bind('TglBookingx', $TglBookingx);
                        $this->db->bind('nobokingreal', $nobokingreal);
                        $this->db->bind('xres', $xres);
                        $this->db->bind('MrExist', $MrExist);
                        $this->db->bind('kodejenispayment', $pembayaran);
                        $this->db->bind('NoTlp', $NoTlp);
                        $this->db->bind('NoHp', $NoHp);
                        $this->db->bind('Alamat', $Alamat);
                        $this->db->bind('PasienKetReservasi', $PasienKetReservasi);
                        $this->db->bind('PasienEmail', $PasienEmail);
                        $this->db->bind('datenowcreate', $datenowcreate);
                        $this->db->bind('operator', $userid);
                        $this->db->bind('NoKTP', $data['nik']);
                        $this->db->bind('Medical_Provinsi', $Medical_Provinsi);
                        $this->db->bind('Medrec_IdPengenal', $Medrec_IdPengenal);
                        $this->db->bind('Medrec_kabupaten', $Medrec_kabupaten);
                        $this->db->bind('Medrec_Kecamatan', $Medrec_Kecamatan);
                        $this->db->bind('Medrec_Tpt_lahir', $Medrec_Tpt_lahir);
                        $this->db->bind('Medrec_Kelurahan', $Medrec_Kelurahan);
                        $this->db->bind('Medrec_statusNikah', $Medrec_statusNikah);
                        $this->db->bind('Medical_Agama', $Medical_Agama);

                        $this->db->bind('Medrec_Bahasa', $Medrec_Bahasa);
                        $this->db->bind('Medrec_Warganegara', $Medrec_Warganegara);
                        $this->db->bind('Medrec_Kodepos', $Medrec_Kodepos);
                        $this->db->bind('Medrec_Pendidikan', $Medrec_Pendidikan);
                        $this->db->bind('Medrec_Etnis', $Medrec_Etnis);
                        $this->db->bind('Medrec_NamaIbuKandung', $Medrec_NamaIbuKandung);
                        $this->db->bind('PasienPekerjaan', $PasienPekerjaan);
                        $this->db->bind('jampraktek', $jampraktek);
                        $this->db->bind('penjamin', $penjamin);

                        $this->db->bind('BPJS_xNorujukan', $BPJS_xNorujukan);
                        $this->db->bind('BPJS_NoKartu', $BPJS_NoKartu);
                        $this->db->bind('BPJS_NoSEP', $BPJS_NoSEP);
                        $this->db->bind('BPJS_NoRencKontrol', $BPJS_NoRencKontrol);
                        $this->db->execute();
                        $sqlantrianmr0 = "INSERT INTO perawatanSQL.dbo.AntrianPasien 
                        (
                        no_transaksi,
                        Doctor_1,
                        JamPraktek,
                        Antrian,
                        noAntrianAll,
                        TglKunjungan,
                        Company)
                        VALUES
                        (
                        :nobokingreal,
                        :Doctor_1,
                        :shift,
                        :idno_urutantrian,
                        :fixNoAntrian,
                        :TglBookingx,
                        'RS YARSI WEB'
                        )";

                        $this->db->query($sqlantrianmr0);
                        $this->db->bind('nobokingreal', $nobokingreal);
                        $this->db->bind('Doctor_1', $IdDokter);
                        $this->db->bind('shift', $shift);
                        $this->db->bind('idno_urutantrian', $idno_urutantrian);
                        $this->db->bind('fixNoAntrian', $fixNoAntrian);
                        $this->db->bind('TglBookingx', $TglBookingx);
                        $this->db->execute();
                        $datalog = [
                            'noregistrasi' => $nobokingreal,
                            'nama_biling' => "Administrasi Pasien NonWalkin",
                            'petugas_entry' => $data['iduser'],
                            'tgl_entry' => $datenowcreate
                        ];
                        $this->logAlasan($datalog);
                        $replacenumberhp = Utils::hp($NoHp);
                        $replacenumberhpDokter = Utils::hp($nomorantriandokter['Mob_Phone']);
                        // $gettoken = $this->getTokenWapin();


                        $arr_data = array(
                            'ID_JadwalPraktek' => $jampraktek,
                            'tglreservasi' => $TglBookingx,
                            'IdDokter' => $IdDokter,
                            'IdPoli' => $IdGrupPerawatan,
                        );
                        $getwaktujadwal = $this->getWaktuPraktek($arr_data);



                        $this->db->Commit();

                        $this->sendNotifWapin(
                            "",
                            $replacenumberhp,
                            $data['PasienNama'],
                            $nobokingreal,
                            date("d-m-Y", strtotime($TglBookingx)),
                            $getwaktujadwal,
                            $viewNamaPoliklinik,
                            $namadokter['First_Name'],
                            $fixNoAntrian,
                            $NoMr == '' ? '-' : $NoMr
                        );
                        if ($IdGrupPerawatan <> '9' && $IdGrupPerawatan <> '10') {
                            // $this->sendNotifWapinDokter(
                            //     $gettoken,
                            //     $replacenumberhpDokter,
                            //     $namadokter['First_Name'],
                            //     $data['PasienNama'],
                            //     $nobokingreal,
                            //     date("d-m-Y", strtotime($TglBookingx)),
                            //     $getwaktujadwal,
                            //     $viewNamaPoliklinik,
                            //     $namadokter['First_Name'],
                            //     $fixNoAntrian
                            // );
                        }

                        $callback = array(
                            'status' => 'success',
                            'NoBoking' => $nobokingreal,
                            'NoAntrianPoli' => $fixNoAntrian,
                            'IdDokter' => $namadokter,
                            'IdPoli' => $IdGrupPerawatan,
                            'mrexist' => $MrExist,
                            'NoAntrianAll' =>  $fixNoAntrian,
                            'First_Name' =>  $namadokter['First_Name'],

                        );
                        return self::JsonDecode(200, $callback, "success");
                    }
                }
            }
        } catch (PDOException $e) {
            $this->db->rollback();
            return self::JsonDecode(503, $e);
        }
    }

    // batal reservasi
    public function Batal($data)
    {
        try {
            $this->db->transaksi();
            if (!empty($this->cekSudahdiregis($data['nomorbooking']))) {
                $callback = array(
                    'errorname' => 'Reservasi ini sudah berubah menjadi Registrasi, Anda Tidak membatalkan !',
                );
                return self::JsonDecode(200, $callback, 'warning');
            } else {
                // var_dump($data);
                if ($data['NOspri'] <> "") {
                    // batal spri bpjs
                    $this->goBatalSPRI($data);
                }
                $upadteyangbatal = $this->yangbatalReservasi($data);
                $updateflagbatal = $this->flagbatal($data);
                $datalogbatal = [];
                $this->logBatal($data);
                if ($upadteyangbatal > 0 && $updateflagbatal > 0) {
                    $callback = array(
                        'status' => 'success',
                    );
                    $this->db->Commit();
                    return self::JsonDecode(200, $callback, 'success');
                }
            }
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => 'Error',
                'errorname' => $e,
            );
            return self::JsonDecode(500, $callback, 'error');
        }
    }

    public static function JsonDecode($status = 200, $message = null, $statusmessage = null)
    {
        if ($status == 200) {
            $response = [
                'status' => 'success',
                'statusmessage' => $statusmessage,
                'code' => $status,
                'response' => $message,
            ];
            return $response;
        } else {
            $response = [
                'status' => 'error',
                'code' => $status,
                'errorMessage' => $message
            ];
            return $response;
        }
    }

    public function DaftarPoliKlinik($data)
    {
        if ($data == 'WALKIN') {
            $daftarpoli = "SELECT ID, NamaUnit
            from MasterdataSQL.dbo.MstrUnitPerwatan 
            where ID='9'";
        } else {
            $daftarpoli = "SELECT ID, NamaUnit
            from MasterdataSQL.dbo.MstrUnitPerwatan 
            where grup_instalasi in ('RAWAT JALAN','PENUNJANG')";
        }
        $this->db->query($daftarpoli);
        $this->db->execute();
        return $this->db->resultSet();
    }
    public function goBatalSPRI($data)
    {
        $curl = curl_init();
        $alasanbatal = $data['alasanbatal'];
        $NOspri = $data['NOspri'];
        $session = SessionManager::getCurrentSession();
        $namauserx = $session->name;
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        $tglNow = Utils::seCurrentDateTime();
        $ISBATAL = "1";
        if ($NOspri == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'No. SPRI Kosong !',
            );
            echo json_encode($callback);
            exit;
        }
        // if ($NoRegistrasi == "") {
        //     $callback = array(
        //         'status' => 'warning',
        //         'errorname' => 'No. Registrasi Kosong !',
        //     );
        //     echo json_encode($callback);
        //     exit;
        // }
        if ($alasanbatal == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Alasan Batal kosong !',
            );
            echo json_encode($callback);
            exit;
        }
        curl_setopt_array($curl, array(
            CURLOPT_URL =>  URL_BPJS . 'RencanaKontrol/Delete',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_POSTFIELDS => '{
                                                "request": {
                                                    "t_suratkontrol":{
                                                    "noSuratKontrol": "' . $NOspri . '",
                                                    "user": "' . $namauserx . '"
                                                    }
                                                }
                                            }
                                    ',
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
            // $nosep = $JsonDatax['1']['sep']['noSep'];  
            $this->db->query("UPDATE PerawatanSQL.dbo.BPJS_T_SPRI
                            SET STATUS=:ISBATAL,USER_BATAL=:USER_BATAL, 
                            TANGGAL_BATAL=:TANGGAL_BATAL,ALASAN=:ALASAN
                            WHERE NO_SPRI=:NO_SPRI");
            $this->db->bind('NO_SPRI', $NOspri);
            $this->db->bind('USER_BATAL', $namauserx);
            $this->db->bind('TANGGAL_BATAL', $tglNow);
            $this->db->bind('ALASAN', $alasanbatal);
            $this->db->bind('ISBATAL', $ISBATAL);
            $this->db->execute();
            $callback = array(
                'status' => 'success',
                'hasil' => $ResultEncriptLzString,
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
    public function yangbatalReservasi($data)
    {
        $datenowcreate = date("Y-m-d H:i:s");
        $batal = "UPDATE  PerawatanSQL.dbo.Apointment SET  Batal='1' , jam_batal=:jambatal,petugas_batal=:petugasbatal
        where NoBooking=:NoBooking";
        $this->db->query($batal);
        $this->db->bind('jambatal', $datenowcreate);
        $this->db->bind('petugasbatal', $data['petugasbatal']);
        $this->db->bind('NoBooking', $data['nomorbooking']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    // update flag batal ke antrian
    public function flagbatal($data)
    {
        // var_dump($data);
        $flagbatal = "UPDATE PerawatanSQL.dbo.AntrianPasien set batal ='1' where no_transaksi=:no_transaksi";
        $this->db->query($flagbatal);
        $this->db->bind('no_transaksi', $data['nomorbooking']);
        $this->db->execute();
        return $this->db->rowCount();
    }
    // update alasan 
    public function logAlasan($data)
    {
        // var_dump($data);
        $log = "INSERT INTO SysLog.dbo.TZ_Log_Button
        ([noregistrasi],[nama_biling],[petugas_entry],[tgl_entry])
  VALUES
  (:noregistrasi,:nama_biling,:petugas_entry,:tgl_entry)";
        $this->db->query($log);
        $this->db->bind('noregistrasi', $data['noregistrasi']);
        $this->db->bind('nama_biling', $data['nama_biling']);
        $this->db->bind('petugas_entry', $data['petugas_entry']);
        $this->db->bind('tgl_entry', $data['tgl_entry']);
        // $this->db->bind('petugas_batal', $data['nomorbooking']);
        // $this->db->bind('tgl_batal', $data['nomorbooking']);
        // $this->db->bind('alasan_batal', $data['nomorbooking']);
        $this->db->execute();
    }
    // 
    public function logBatal($data)
    {
        // var_dump($data);
        $log = "UPDATE SysLog.dbo.TZ_Log_Button Set petugas_batal=:petugas_batal,tgl_batal=:tgl_batal,alasan_batal=:alasan_batal
            where noregistrasi=:noregistrasi
            ";
        $this->db->query($log);
        $this->db->bind('noregistrasi', $data['nomorbooking']);
        $this->db->bind('petugas_batal', $data['petugasbatal']);
        $this->db->bind('tgl_batal', date("Y-m-d H:i:s"));
        $this->db->bind('alasan_batal', $data['alasanbatal']);

        // $this->db->bind('petugas_batal', $data['nomorbooking']);
        // $this->db->bind('tgl_batal', $data['nomorbooking']);
        // $this->db->bind('alasan_batal', $data['nomorbooking']);
        $this->db->execute();
    }
    public function cekSudahdiregis($noregbatal)
    {
        $cekregis = "SELECT *from PerawatanSQL.dbo.Apointment where NoBooking=:NoBooking  and Datang='1'";
        $this->db->query($cekregis);
        $this->db->bind('NoBooking', $noregbatal);
        $this->db->execute();
        return $this->db->single();
    }

    public function datareservasiid($data)
    {
        try {
            $query = "SELECT  a.NoAntrianAll, a.MrExist, a.JenisKelamin,a.id,a.NoUrut,a.NoBooking,a.NoMR,a.NamaPasien,a.Alamat,d.ID_Card_number as NoKTP,
            replace(CONVERT(VARCHAR(11), a.TglLahir, 111), '/','-') as TglLahir,
                       case when a.JenisPembayaran='PRIBADI' then '1' when a.JenisPembayaran='ASURANSI' then '2'   
                       when a.JenisPembayaran='JAMINAN PERUSAHAAN' then '5'   
                       END AS JenisPembayaran,replace(CONVERT(VARCHAR(11), a.ApmDate, 111), '/','-')  as ApmDate,
                       a.JamPraktek,a.NoAntrianAll,a.IdPoli,a.DoctorID,
                                           b.NamaUnit,c.First_Name,a.Telephone,a.HP,a.Description,A.Email
                                           ,a.Kelurahan,
                                       a.Kecamatan,
                                       a.City,
                                       a.[State/Province] as provinsi,
                                       a.[ZIP/Postal Code] as kodepos,
                                       a.[Country/Region] as Medrec_Warganegara,
                                       a.Religion,
                                       a.Tipe_Idcard,
                                       a.BirthPlace,
                                       a.Education,
                                       a.Bahasa,
                                       a.Etnis,
                                       a.Mother,
                                       a.StatusMenikah,
                                       a.Ocupation,
                                       a.NoKTP,
                                       a.ID_JadwalPraktek,
                                       a.ID_Penjamin
                                           from  PerawatanSQL.dbo.Apointment a
                                           inner join MasterdataSQL.dbo.MstrUnitPerwatan b on a.IdPoli = b.ID
                                           inner join MasterdataSQL.dbo.Doctors c on c.ID = a.DoctorID
                                           left join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
                         WHERE A.ID=:ID";
            $this->db->query($query);
            $this->db->bind('ID', $data['ID']);
            $this->db->execute();
            return $this->db->single();
        } catch (PDOException $e) {
            return $e;
        }
    }
    public function getTokenWapin()
    {
        $curl = curl_init();
        $wapinx = "YXBpbW9iaWxlOmlickFZRmxvc1YwIw==";
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.chat.wappin.app/v1/users/login",
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
        return $JsonData['users']['0']['token'];
    }
    public function sendNotifWapin($token, $NoHandphone, $PasienNama, $nobokingreal, $TglBookingx, $getwaktujadwal, $viewNamaPoliklinik, $namadokter, $fixNoAntrian, $NoMr)
    {
  
                                
$text = urlencode("Bapak/Ibu ".$PasienNama."\nBerikut adalah Data NoReservasi anda :\nNo. Reservasi : ".$nobokingreal . "\nTanggal : ".$TglBookingx . "\nWaktu Pelayanan  : ".$getwaktujadwal . "\nPoliklinik : ".$viewNamaPoliklinik . "\nDokter : ".$namadokter . "\nNo. Antrian : ".$fixNoAntrian . "\nNo. MR : ".$NoMr . "\nKlinik Utama Brebes Eye Center.\nTerima Kasih. "  );
        
        $curl = curl_init();
        $url = "https://api.kirimpesan.net/api/sendText?token=66b5ace5c302c5956a66b6f3&phone=".$NoHandphone."&message=".$text;
        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_SSL_VERIFYPEER => FALSE,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET', 
          CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Content-Type: application/json'
          ),
        ));
        
        $response = curl_exec($curl);
        $JsonData = json_decode($response, TRUE);
        curl_close($curl); 
          return $JsonData;
    }
    public function sendNotifWapinDokter($token, $NoHandphone, $param1, $param2, $param3, $param4, $param5, $param6, $param7, $param8)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.chat.wappin.app/v1/messages',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "to": "' . $NoHandphone . '",
            "type": "template",
            "template": {
                "name": "appointment_dokter_yarsi",
                "namespace": "700eb891_fb62_4d15_8d30_d493e38bbfc9", 
                "language": {
                    "policy": "deterministic",
                    "code": "id"
                },
                "components": [
                    {
                        "type": "body",
                        "parameters": [
                            {
                                "type": "text",
                                "text": "' . $param1 . '"
                            } , {
                                "type": "text",
                                "text": "' . $param2 . '"
                            } , {
                                "type": "text",
                                "text": "' . $param3 . '"
                            } , {
                                "type": "text",
                                "text": "' . $param4 . '"
                            } , {
                                "type": "text",
                                "text": "' . $param5 . '"
                            } , {
                                "type": "text",
                                "text": "' . $param6 . '"
                            } , {
                                "type": "text",
                                "text": "' . $param7 . '"
                            } , {
                                "type": "text",
                                "text": "' . $param8 . '"
                            } 
                        ]
                    } 
                ]
            }
        }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token,
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        $JsonData = json_decode($response, TRUE);
        curl_close($curl);
        return $JsonData;
    }

    public function sendreminder($token, $data)
    {

        $idresv = $data['idresv'];
        //get data
        $this->db->query("SELECT NamaPasien,NamaDokter,Poli,
        replace(CONVERT(VARCHAR(11), ApmDate, 111), '/','-') as TglResv,JamPraktek,NoAntrianAll,HP
                            FROM PerawatanSQL.dbo.Apointment
                            WHERE ID=:idresv
                            ");
        $this->db->bind('idresv', $idresv);
        $data2 =  $this->db->single();

        $nama = $data2['NamaPasien'];
        $namadokter = $data2['NamaDokter'];
        $namapoli = $data2['Poli'];
        $hari = $data2['TglResv'];
        $jampoli = $data2['JamPraktek'];
        $antrian = $data2['NoAntrianAll'];
        $NoHandphone =  Utils::hp($data2['HP']);
        $notereminder = $data['noted'];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.chat.wappin.app/v1/messages',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "to": "' . $NoHandphone . '",
            "type": "template",
            "template": {
                "name": "reminderapoitment_1",
                "namespace": "700eb891_fb62_4d15_8d30_d493e38bbfc9", 
                "language": {
                    "policy": "deterministic",
                    "code": "id"
                },
                "components": [
                    {
                        "type": "body",
                        "parameters": [
                            {
                                "type": "text",
                                "text": "' . $nama . '"
                            } , {
                                "type": "text",
                                "text": "' . $namadokter . '"
                            } , {
                                "type": "text",
                                "text": "' . $namapoli . '"
                            } , {
                                "type": "text",
                                "text": "' . $hari . '"
                            } , {
                                "type": "text",
                                "text": "' . $jampoli . '"
                            } , {
                                "type": "text",
                                "text": "' . $antrian . '"
                            } , {
                                "type": "text",
                                "text": "' . $notereminder . '"
                            }  
                        ]
                    } 
                ]
            }
        }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token,
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        $JsonData = json_decode($response, TRUE);
        curl_close($curl);
        return $JsonData;
    }

    public function sendreminderAll($token, $data)
    {
        try {
            //$this->db->transaksi();
            $notereminderx = $data['noted'];
            //$idbtn = $data['idbtn'];

            //$odid = array();
            $tod = json_decode(json_encode((object) $data['idorderapprove']), FALSE);
            foreach ($tod as $data) {

                $idresv = $data;
                //get data
                $this->db->query("SELECT NamaPasien,NamaDokter,Poli,
                replace(CONVERT(VARCHAR(11), ApmDate, 111), '/','-') as TglResv,JamPraktek,NoAntrianAll,HP,ID_JadwalPraktek,DoctorID,IdPoli
                                    FROM PerawatanSQL.dbo.Apointment
                                    WHERE ID=:idresv
                                    ");
                $this->db->bind('idresv', $idresv);
                $data2 =  $this->db->single();

                $nama = $data2['NamaPasien'];
                $namadokter = $data2['NamaDokter'];
                $namapoli = $data2['Poli'];
                $hari = $data2['TglResv'];
                $jampoli = $data2['JamPraktek'];
                $antrian = $data2['NoAntrianAll'];
                $NoHandphone =  Utils::hp($data2['HP']);
                $hari_dmy = date('d-m-Y', strtotime($data2['TglResv']));

                $jampraktek = $data2['ID_JadwalPraktek'];
                $IdDokter = $data2['DoctorID'];
                $IdGrupPerawatan = $data2['IdPoli'];


                $arr_data = array(
                    'ID_JadwalPraktek' => $jampraktek,
                    'tglreservasi' => $hari,
                    'IdDokter' => $IdDokter,
                    'IdPoli' => $IdGrupPerawatan,
                );
                $getwaktujadwal = $this->getWaktuPraktek($arr_data);

                if ($getwaktujadwal == null || $getwaktujadwal == '' || $getwaktujadwal == '-') {
                    $getwaktujadwal = $jampoli;
                }

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://api.chat.wappin.app/v1/messages',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_SSL_VERIFYPEER => FALSE,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => '{
                    "to": "' . $NoHandphone . '",
                    "type": "template",
                    "template": {
                        "name": "reminderapoitment_1",
                        "namespace": "700eb891_fb62_4d15_8d30_d493e38bbfc9", 
                        "language": {
                            "policy": "deterministic",
                            "code": "id"
                        },
                        "components": [
                            {
                                "type": "body",
                                "parameters": [ 
                                    {
                                        "type": "text",
                                        "text": "' . $nama . '"
                                    } , {
                                        "type": "text",
                                        "text": "' . $namadokter . '"
                                    } , {
                                        "type": "text",
                                        "text": "' . $namapoli . '"
                                    } , {
                                        "type": "text",
                                        "text": "' . $hari_dmy . '"
                                    } , {
                                        "type": "text",
                                        "text": "' . $getwaktujadwal . '"
                                    } , {
                                        "type": "text",
                                        "text": "' . $antrian . '"
                                    } , {
                                        "type": "text",
                                        "text": "' . $notereminderx . '"
                                    }  
                                ]
                            } 
                        ]
                    }
                }',
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Bearer ' . $token,
                        'Content-Type: application/json'
                    ),
                ));
                $response = curl_exec($curl);
                $JsonData = json_decode($response, TRUE);
                curl_close($curl);
            }
            //exit;

            // $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Simpan Berhasil',
            );
            return $callback;
        } catch (PDOException $e) {
            //  $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }


    public function getWaktuPraktek($data)
    {

        $tglresv = $data['tglreservasi'];
        $ID_JadwalPraktek = $data['ID_JadwalPraktek'];
        $IdDokter = $data['IdDokter'];
        $IdPoli = $data['IdPoli'];
        $getdate = date('l', strtotime($tglresv));

        if ($getdate == 'Sunday') {
            $waktu = 'Minggu';
        } elseif ($getdate == 'Monday') {
            $waktu = 'Senin';
        } elseif ($getdate == 'Tuesday') {
            $waktu = 'Selasa';
        } elseif ($getdate == 'Wednesday') {
            $waktu = 'Rabu';
        } elseif ($getdate == 'Thursday') {
            $waktu = 'Kamis';
        } elseif ($getdate == 'Friday') {
            $waktu = 'Jumat';
        } elseif ($getdate == 'Saturday') {
            $waktu = 'Sabtu';
        }
        $waktusession = $waktu . '_Waktu';

        if ($ID_JadwalPraktek == '' ||  $ID_JadwalPraktek == null) {
            $getwaktujadwal = "SELECT $waktusession as WaktuPraktek from MasterdataSQL.dbo.JadwalPraktek where IdDokter=:IdDokter and IDUnit=:IdPoli and $waktu='1' ";
            $this->db->query($getwaktujadwal);
            $this->db->bind('IdDokter', $IdDokter);
            $this->db->bind('IdPoli', $IdPoli);
        } else {
            $getwaktujadwal = "SELECT $waktusession as WaktuPraktek from MasterdataSQL.dbo.JadwalPraktek where ID=:ID_JadwalPraktek";
            $this->db->query($getwaktujadwal);
            $this->db->bind('ID_JadwalPraktek', $ID_JadwalPraktek);
        }
        $this->db->execute();
        $datax = $this->db->single();
        $jadwalwaktupraktek = $datax['WaktuPraktek'];
        return $jadwalwaktupraktek;
    }
    public function listDatareservasi_arsip_new($data)
    {
        try {
            $sql_details = array(
                'user' => DB_USER,
                'pass' => DB_PASSWORD,
                'db'   => DB_NAME,
                'host' => DB_HOST
            );
            if ($data['iswalkin'] == 'WALKIN') {
                $wherepoli = 'and IdPoli=9'; 
            } else {
                $wherepoli = 'and IdPoli<>9';
            }
            $xtglawal = $data['tanggal_awal']; 
            $xtglakhir = $data['tanggal_akhir']; 
$table = <<<EOT
            (SELECT a.ID,a.NoUrut,a.NoBooking,a.NoMR,a.NamaPasien,a.Alamat,a.TglLahir,
            a.JenisPembayaran,replace(CONVERT(VARCHAR(11), a.ApmDate, 111), '/','-')  as ApmDate,a.JamPraktek,a.NoAntrianAll,
            b.NamaUnit,c.First_Name,a.Description,a.HP,a.Datang,NoRegistrasi,
            case when a.JenisPembayaran = 'ASURANSI' THEN d.NamaPerusahaan
            else e.NamaPerusahaan end as 'NamaPerusahaan'
            from  PerawatanSQL.dbo.Apointment a
            inner join MasterdataSQL.dbo.MstrUnitPerwatan b on a.IdPoli = b.ID
            inner join MasterdataSQL.dbo.Doctors c on c.ID = a.DoctorID
            left join MasterDataSQL.dbo.MstrPerusahaanAsuransi d on a.ID_Penjamin=d.ID
            left join MasterDataSQL.dbo.MstrPerusahaanJPK e on a.ID_Penjamin=e.ID
            where replace(CONVERT(VARCHAR(11), a.ApmDate, 111), '/','-') between '$xtglawal' and '$xtglakhir'
            and a.Batal='0' and a.Datang='1' $wherepoli
            ) temp
EOT;
            $primaryKey = 'ID';
            // var_dump($table);
            // exit;
            // Array of database columns which should be read and sent back to DataTables.
            // The `db` parameter represents the column name in the database, while the `dt`
            // parameter represents the DataTables column identifier. In this case simple
            // indexes
            $columns = array(
                array('db' => 'ID', 'dt' => 'ID'),
                array('db' => 'NoUrut', 'dt' => 'NoUrut'),
                array('db' => 'NoBooking',     'dt' => 'NoBooking'),
                // array('db' => 'No', 'dt' => 'No'),
                array('db' => 'NoMR',  'dt' => 'NoMR'),
                array('db' => 'NamaPasien',     'dt' => 'NamaPasien'),
                array('db' => 'Alamat',     'dt' => 'Alamat'),
                array('db' => 'TglLahir', 'dt' => 'TglLahir'),
                array('db' => 'JenisPembayaran',     'dt' => 'JenisPembayaran'),
                array('db' => 'ApmDate',   'dt' => 'ApmDate'),
                array('db' => 'JamPraktek', 'dt' => 'JamPraktek'),
                array('db' => 'NoAntrianAll',     'dt' => 'NoAntrianAll'),
                array('db' => 'NamaUnit',     'dt' => 'NamaUnit'),

                array('db' => 'First_Name',     'dt' => 'First_Name'),
                array('db' => 'Description',     'dt' => 'Description'),

                array('db' => 'HP',     'dt' => 'HP'),
                array('db' => 'Datang',     'dt' => 'Datang'),
                array('db' => 'NoRegistrasi',     'dt' => 'NoRegistrasi'),
                array('db' => 'NamaPerusahaan',     'dt' => 'NamaPerusahaan')

            );

            return SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns);
        } catch (PDOException $e) {
            return self::JsonDecode(0, $e);
        }
    }

    public function listDatareservasi_arsip($data)
    {
        try {
            if ($data['iswalkin'] == 'WALKIN') {
                $wherepoli = 'and IdPoli=9';
            } else {
                $wherepoli = 'and IdPoli<>9';
            }
            $querylistreservasi = "SELECT a.ID,a.NoUrut,a.NoBooking,a.NoMR,a.NamaPasien,a.Alamat,a.TglLahir,
            a.JenisPembayaran,replace(CONVERT(VARCHAR(11), a.ApmDate, 111), '/','-')  as ApmDate,a.JamPraktek,a.NoAntrianAll,
            b.NamaUnit,c.First_Name,a.Description,a.HP,a.Datang,NoRegistrasi,
            case when a.JenisPembayaran = 'ASURANSI' THEN d.NamaPerusahaan
            else e.NamaPerusahaan end as 'NamaPerusahaan'
            from  PerawatanSQL.dbo.Apointment a
            inner join MasterdataSQL.dbo.MstrUnitPerwatan b on a.IdPoli = b.ID
            inner join MasterdataSQL.dbo.Doctors c on c.ID = a.DoctorID
            left join MasterDataSQL.dbo.MstrPerusahaanAsuransi d on a.ID_Penjamin=d.ID
            left join MasterDataSQL.dbo.MstrPerusahaanJPK e on a.ID_Penjamin=e.ID
            where replace(CONVERT(VARCHAR(11), a.ApmDate, 111), '/','-') between :tanggal_awal and :tanggal_akhir
            and a.Batal='0' and a.Datang='1' $wherepoli
            order by a.ApmDate desc";
            $this->db->query($querylistreservasi);
            $this->db->bind('tanggal_awal', $data['tanggal_awal']);
            $this->db->bind('tanggal_akhir', $data['tanggal_akhir']);
            $this->db->execute();
            $data =  $this->db->resultSet();
            // return  $this->db->resultSet();
            //return self::JsonDecode(200, $this->db->resultSet());
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['ID'] = $key['ID'];
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['NamaPasien'] = $key['NamaPasien'];
                $pasing['ApmDate'] = $key['ApmDate'];
                $pasing['NamaUnit'] = $key['NamaUnit'];
                $pasing['First_Name'] = $key['First_Name'];
                $pasing['HP'] = $key['HP'];
                $pasing['JenisPembayaran'] = $key['JenisPembayaran'];
                $pasing['Description'] = $key['Description'];
                $pasing['Alamat'] = $key['Alamat'];
                $pasing['Datang'] = $key['Datang'];
                $pasing['NoAntrianAll'] = $key['NoAntrianAll'];
                $pasing['NoBooking'] = $key['NoBooking'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['NamaPerusahaan'] = $key['NamaPerusahaan'];
                //$rows[] = $pasing;
                $rows[] = $pasing;
            }
            // var_dump($rows);
            return $rows;
        } catch (PDOException $e) {
            return self::JsonDecode(0, $e);
        }
    }

    public function CreateKontrolUlang_EMR($data)
    {
        try {
            $this->db->transaksi();
            $NoMr = $data['nomr'];
            //$PasienNoEpisode = $data['PasienNoEpisode'];
            $PasienNoRegistrasi = $data['SIMRS_Registrasi'];
            $tglbookingfix = $data['tglreservasi'];
            $WaktuPraktek = $data['jampraktek'];
            $NamaDokter = $data['namadokter'];
            $NamaGrupPerawatan = $data['namapoliklinik'];
            $PasienKetReservasi = $data['Keterangan'];
            //$nobokingreal = $data['nobokingreal'];
            $IdDokter = $data['iddokter'];

            //GET WAKTU
            $getdate = date('l', strtotime($tglbookingfix));

            if ($getdate == 'Sunday') {
                $waktu = 'Minggu';
            } elseif ($getdate == 'Monday') {
                $waktu = 'Senin';
            } elseif ($getdate == 'Tuesday') {
                $waktu = 'Selasa';
            } elseif ($getdate == 'Wednesday') {
                $waktu = 'Rabu';
            } elseif ($getdate == 'Thursday') {
                $waktu = 'Kamis';
            } elseif ($getdate == 'Friday') {
                $waktu = 'Jumat';
            } elseif ($getdate == 'Saturday') {
                $waktu = 'Sabtu';
            }
            $waktusession = $waktu . '_Waktu';

            $getnoepisode = "SELECT NoEpisode from PerawatanSQL.dbo.Visit where NoRegistrasi=:PasienNoRegistrasi
                UNION ALL
                SELECT NoEpisode FROM RawatInapSQL.dbo.Inpatient where NoRegRI=:PasienNoRegistrasi2
                ";
            $this->db->query($getnoepisode);
            $this->db->bind('PasienNoRegistrasi', $PasienNoRegistrasi);
            $this->db->bind('PasienNoRegistrasi2', $PasienNoRegistrasi);
            $datas = $this->db->single();
            $PasienNoEpisode = $datas['NoEpisode'];


            $getwaktujadwal = "SELECT $waktusession as WaktuPraktek from MasterdataSQL.dbo.JadwalPraktek where ID=:ID_JadwalPraktek";
            $this->db->query($getwaktujadwal);
            $this->db->bind('ID_JadwalPraktek', $WaktuPraktek);
            $datax = $this->db->single();
            $jadwalwaktupraktek = $datax['WaktuPraktek'];


            $sqlkontrolulang = "INSERT INTO  MedicalRecord.DBO.MR_DaftarKontrolUlang
                (NoMR,NoEpisode,NoRegistrasi,TglKontrol,Jam,Dokter,PoliKlinik,Keterangan)
                 VALUES
                (
                    :NoMr,
                    :PasienNoEpisode,
                    :PasienNoRegistrasi,
                    :tglbookingfix,
                    :WaktuPraktek,
                    :NamaDokter,
                    :NamaGrupPerawatan,
                    :PasienKetReservasi
                    )";
            $this->db->query($sqlkontrolulang);
            $this->db->bind('NoMr', $NoMr);
            $this->db->bind('PasienNoEpisode', $PasienNoEpisode);
            $this->db->bind('PasienNoRegistrasi', $PasienNoRegistrasi);
            $this->db->bind('tglbookingfix', $tglbookingfix);
            $this->db->bind('WaktuPraktek', $jadwalwaktupraktek);
            $this->db->bind('NamaDokter', $NamaDokter);
            $this->db->bind('NamaGrupPerawatan', $NamaGrupPerawatan);
            $this->db->bind('PasienKetReservasi', $PasienKetReservasi);
            //$this->db->bind('nobokingreal', $nobokingreal);
            $this->db->execute();
            $getID = $this->db->GetLastID();

            $this->db->Commit();

            $callback = array(
                'status' => 'success',
                'message' => 'Buat Kontrol Ulang EMR Berhasil',
                'ID_KontrolUlangEMR' => $getID,
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            return self::JsonDecode(0, $e);
        }
    }

    public function GoUpdateRujukanBooking($data)
    {
        $session = SessionManager::getCurrentSession();
        $userid = $session->username;
        $datenowcreate = Utils::seCurrentDateTime();
        try {
            $this->db->transaksi();

            $query = "SELECT NoRujukanBPJS,NoKartuBPJS,NoSuratKontrolBPJS,NoSEP,NoBooking FROM PerawatanSQL.dbo.Apointment WHERE ID=:ID";
            $this->db->query($query);
            $this->db->bind('ID', $data['updtbook_ID']);
            $this->db->execute();
            $dataold =  $this->db->single();
            $pesan = 'NoRujukanBPJS:' . $dataold['NoRujukanBPJS'] . ';NoKartuBPJS:' . $dataold['NoKartuBPJS'] . ';NoSuratKontrolBPJS:' . $dataold['NoSuratKontrolBPJS'] . ';NoSEP:' . $dataold['NoSEP'];


            $log = "INSERT INTO SysLog.dbo.TZ_Log_Button
        ([idtrs],[noregistrasi],[nama_biling],[petugas_entry],[tgl_entry],[alasan_batal])
        VALUES
        (:idtrs,:noregistrasi,:nama_biling,:petugas_batal,:tgl_batal,:alasan_batal)";
            $this->db->query($log);
            $this->db->bind('idtrs', $data['updtbook_ID']);
            $this->db->bind('noregistrasi', $dataold['NoBooking']);
            $this->db->bind('petugas_batal', $userid);
            $this->db->bind('tgl_batal', $datenowcreate);
            $this->db->bind('nama_biling', 'Update No Rujukan BPJS Dari List Reservasi Pasien Non Walkin');
            $this->db->bind('alasan_batal', $pesan);
            $this->db->execute();

            $updatedatapasien = "UPDATE perawatanSQL.dbo.Apointment SET 
                NoRujukanBPJS=:updtbook_NoRujukan,NoKartuBPJS=:updtbook_nokartubpjs,NoSuratKontrolBPJS=:updtbook_NoSurkon
                WHERE ID=:updtbook_ID";
            $this->db->query($updatedatapasien);
            $this->db->bind('updtbook_ID', $data['updtbook_ID']);
            $this->db->bind('updtbook_NoRujukan', $data['kodePeserta']);
            $this->db->bind('updtbook_nokartubpjs', $data['updtbook_nokartubpjs']);
            $this->db->bind('updtbook_NoSurkon', $data['updtbook_NoSurkon']);
            $this->db->execute();

            $this->db->Commit();

            $callback = array(
                'status' => 'success',
                'message' => 'Data Berhasil Diperbarui !'
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => 'Error',
                'errorname' => $e,
            );
            return self::JsonDecode(500, $callback, 'error');
        }
    }
}
