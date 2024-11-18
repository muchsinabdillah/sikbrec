<?php
class B_Reservasi_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function showListReservasi($data)
    {
        try {
            $where = "AND b.ID<>'9'";
            if (isset($_POST['iswalkin'])) {
                $iswalkin = $data['iswalkin'];
                if ($iswalkin == 'WALKIN') {
                    $where = "AND b.ID='9'";
                }
            }

            $tgl_awal = $data['tglAwalReservasi'];
            $tglAkhirReservasi = $data['tglAkhirReservasi'];
            $this->db->query("SELECT a.ID,a.NoUrut,a.NoBooking,a.NoMR,a.NamaPasien,a.Alamat,a.TglLahir,
                                      a.JenisPembayaran,replace(CONVERT(VARCHAR(11), a.ApmDate, 111), '/','-')  as ApmDate,
                                      a.JamPraktek,a.NoAntrianAll,
                                      b.NamaUnit,c.First_Name,a.Company
                                      from  PerawatanSQL.dbo.Apointment a
                                      inner join MasterdataSQL.dbo.MstrUnitPerwatan b on a.IdPoli = b.ID
                                      inner join MasterdataSQL.dbo.Doctors c on c.ID = a.DoctorID
                                      where replace(CONVERT(VARCHAR(11), a.ApmDate, 111), '/','-') between :tgl_awal and :tglAkhirReservasi
                                      and a.Batal='0' and a.Datang='0' $where");
            $this->db->bind('tgl_awal', $tgl_awal);
            $this->db->bind('tglAkhirReservasi', $tglAkhirReservasi);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = 0;
            foreach ($data as $key) {
                $no++;
                $pasing['no'] = $no;
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['ID'] = $key['ID'];
                $pasing['NamaPasien'] = $key['NamaPasien'];
                $pasing['ApmDate'] = date('d/m/Y', strtotime($key['ApmDate']));
                $pasing['NamaUnit'] = $key['NamaUnit'];
                $pasing['First_Name'] = $key['First_Name'];
                $pasing['NoAntrianAll'] = $key['NoAntrianAll'];
                $pasing['JenisPembayaran'] = $key['JenisPembayaran'];
                $pasing['JamPraktek'] = $key['JamPraktek'];
                $pasing['Alamat'] = $key['Alamat'];
                $pasing['TglLahir'] = $key['TglLahir'];
                $pasing['Company'] = $key['Company'];
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
    public function GoshowIDReservasi($data)
    {
        try {

            $idReservasi = $data['q'];
            $this->db->query(" SELECT  a.NoAntrianAll, a.MrExist, a.JenisKelamin,a.id,a.NoUrut,a.NoBooking,a.NoMR,a.NamaPasien,a.Alamat,
                                    replace(CONVERT(VARCHAR(11), a.TglLahir, 111), '/','-') as TglLahir,
                                    case when a.JenisPembayaran='PRIBADI' then '1' when a.JenisPembayaran='ASURANSI' then '2'   
                                    when a.JenisPembayaran='JAMINAN PERUSAHAAN' then '5'   
                                    END AS JenisPembayaran,replace(CONVERT(VARCHAR(11), a.ApmDate, 111), '/','-')  as ApmDate,
                                    a.JamPraktek,a.NoAntrianAll,a.IdPoli,a.DoctorID,
                                    b.NamaUnit,c.First_Name,a.Telephone,a.HP,a.Description,A.Email,a.Kelurahan,
                                       a.Kecamatan,
                                       a.City,
                                       a.[State/Province],
                                       a.[ZIP/Postal Code],
                                       a.[Country/Region],
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
                                       a.ID_Penjamin,
                                       d.NamaPerusahaan,
                                       a.Company,
                                       case when datepart(dw,a.ApmDate)='1' then Minggu_Awal
									   when datepart(dw,a.ApmDate)='2' then Senin_Awal
									   when datepart(dw,a.ApmDate)='3' then Selasa_Awal
									   when datepart(dw,a.ApmDate)='4' then Rabu_Awal
									   when datepart(dw,a.ApmDate)='5' then Kamis_Awal
									   when datepart(dw,a.ApmDate)='6' then Jumat_Awal
									   when datepart(dw,a.ApmDate)='7' then Sabtu_Awal
									   end as JamAwalPraktek, e.Open_Assesment_Senin,e.Open_Assesment_Selasa,e.Open_Assesment_Rabu,e.Open_Assesment_Kamis,e.Open_Assesment_Jumat,e.Open_Assesment_Sabtu,e.Open_Assesment_Minggu
                                    from  PerawatanSQL.dbo.Apointment a
                                    inner join MasterdataSQL.dbo.MstrUnitPerwatan b on a.IdPoli = b.ID
                                    inner join MasterdataSQL.dbo.Doctors c on c.ID = a.DoctorID
                                    left join MasterdataSQL.dbo.MstrPerusahaanJPK d on a.ID_Penjamin=d.ID
									inner join MasterdataSQL.dbo.JadwalPraktek e on a.ID_JadwalPraktek=e.ID
                                    WHERE A.ID=:idReservasi and a.JenisPembayaran<>'ASURANSI'
                                    UNION ALL
                                    SELECT  a.NoAntrianAll, a.MrExist, a.JenisKelamin,a.id,a.NoUrut,a.NoBooking,a.NoMR,a.NamaPasien,a.Alamat,
                                    replace(CONVERT(VARCHAR(11), a.TglLahir, 111), '/','-') as TglLahir,
                                    case when a.JenisPembayaran='PRIBADI' then '1' when a.JenisPembayaran='ASURANSI' then '2'   
                                    when a.JenisPembayaran='JAMINAN PERUSAHAAN' then '5'   
                                    END AS JenisPembayaran,replace(CONVERT(VARCHAR(11), a.ApmDate, 111), '/','-')  as ApmDate,
                                    a.JamPraktek,a.NoAntrianAll,a.IdPoli,a.DoctorID,
                                    b.NamaUnit,c.First_Name,a.Telephone,a.HP,a.Description,A.Email,a.Kelurahan,
                                       a.Kecamatan,
                                       a.City,
                                       a.[State/Province],
                                       a.[ZIP/Postal Code],
                                       a.[Country/Region],
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
                                       a.ID_Penjamin,
                                       d.NamaPerusahaan,
                                       a.Company,
									   case when datepart(dw,a.ApmDate)='1' then Minggu_Awal
									   when datepart(dw,a.ApmDate)='2' then Senin_Awal
									   when datepart(dw,a.ApmDate)='3' then Selasa_Awal
									   when datepart(dw,a.ApmDate)='4' then Rabu_Awal
									   when datepart(dw,a.ApmDate)='5' then Kamis_Awal
									   when datepart(dw,a.ApmDate)='6' then Jumat_Awal
									   when datepart(dw,a.ApmDate)='7' then Sabtu_Awal
									   end as JamAwalPraktek, e.Open_Assesment_Senin,e.Open_Assesment_Selasa,e.Open_Assesment_Rabu,e.Open_Assesment_Kamis,e.Open_Assesment_Jumat,e.Open_Assesment_Sabtu,e.Open_Assesment_Minggu
                                    from  PerawatanSQL.dbo.Apointment a
                                    inner join MasterdataSQL.dbo.MstrUnitPerwatan b on a.IdPoli = b.ID
                                    inner join MasterdataSQL.dbo.Doctors c on c.ID = a.DoctorID
                                    left join MasterdataSQL.dbo.MstrPerusahaanAsuransi d on a.ID_Penjamin=d.ID
									inner join MasterdataSQL.dbo.JadwalPraktek e on a.ID_JadwalPraktek=e.ID
                                    WHERE A.ID=:idReservasi2 and a.JenisPembayaran='ASURANSI'
                                    ");
            $this->db->bind('idReservasi', $idReservasi);
            $this->db->bind('idReservasi2', $idReservasi);
            $data =  $this->db->single();
            
            $callback = array(
                'status' => 'success', // Set array status dengan success
                'ID' => $data['id'], // Set array status dengan success
                'NoUrut' => $data['NoUrut'], // Set array status dengan success
                'NoBooking' => $data['NoBooking'], // Set array status dengan success
                'NoMR' => $data['NoMR'], // Set array status dengan success
                'NamaPasien' => $data['NamaPasien'], // Set array status dengan success
                'Alamat' => $data['Alamat'], // Set array status dengan success
                'TglLahir' => $data['TglLahir'], // Set array status dengan successDate_of_birth
                'JenisPembayaran' => $data['JenisPembayaran'], // Set array status dengan successDate_of_birth
                'ApmDate' => $data['ApmDate'], // Set array status dengan successDate_of_birth
                'JamPraktek' => $data['JamPraktek'], // Set array status dengan successDate_of_birth
                'NoAntrianAll' => $data['NoAntrianAll'], // Set array status dengan successDate_of_birth
                'IdPoli' => $data['IdPoli'], // Set array status dengan successDate_of_birth
                'DoctorID' => $data['DoctorID'], // Set array status dengan successDate_of_birth
                'JenisKelamin' => $data['JenisKelamin'], // Set array status dengan successDate_of_birth
                'MrExist' => $data['MrExist'],
                'NoAntrianAll' => $data['NoAntrianAll'],
                'Telephone' => $data['Telephone'],
                'HP' => $data['HP'],
                'Description' => $data['Description'],
                'Email' => $data['Email'],

                'ID_Card_number' => $data['NoKTP'],
                'Ocupation' => $data['Ocupation'],
                'Medical_Provinsi' => $data['State/Province'],
                'Medrec_Warganegara' => $data['Country/Region'],
                'Medical_Agama' => $data['Religion'],

                'Medrec_statusNikah' => $data['StatusMenikah'],
                'Medrec_Pendidikan' => $data['Education'],
                'Mother' => $data['Mother'],
                'kodepos' => $data['ZIP/Postal Code'],

                'Bahasa' => $data['Bahasa'],
                'Tipe_Idcard' => $data['Tipe_Idcard'],
                'Etnis' => $data['Etnis'],
                'Medrec_Kecamatan' => $data['Kecamatan'],
                'Medrec_kabupaten' => $data['City'],
                'Medrec_Kelurahan' => $data['Kelurahan'],
                'Ocupation' => $data['Ocupation'],
                'BirthPlace' => $data['BirthPlace'],

                'ID_JadwalPraktek' => $data['ID_JadwalPraktek'],
                'ID_Penjamin' => $data['ID_Penjamin'],
                'NamaPerusahaan' => $data['NamaPerusahaan'],
                'Company' => $data['Company'],
                'JamAwalPraktek' => $data['JamAwalPraktek'],
                'Open_Assesment_Senin' => $data['Open_Assesment_Senin'],
                'Open_Assesment_Selasa' => $data['Open_Assesment_Selasa'],
                'Open_Assesment_Rabu' => $data['Open_Assesment_Rabu'],
                'Open_Assesment_Kamis' => $data['Open_Assesment_Kamis'],
                'Open_Assesment_Jumat' => $data['Open_Assesment_Jumat'],
                'Open_Assesment_Sabtu' => $data['Open_Assesment_Sabtu'],
                'Open_Assesment_Minggu' => $data['Open_Assesment_Minggu'],

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

    // query walkin
    public function getWalkin($data)
    {
        // var_dump($data);
        $query = "SELECT a.ID,a.NoUrut,a.NoBooking,a.NoMR,a.NamaPasien,a.Alamat,a.TglLahir,
            a.JenisPembayaran,replace(CONVERT(VARCHAR(11), a.ApmDate, 111), '/','-')  as ApmDate,a.JamPraktek,a.NoAntrianAll,
            b.NamaUnit,c.First_Name,a.Description,a.HP
            from  PerawatanSQL.dbo.Apointment a
            inner join MasterdataSQL.dbo.MstrUnitPerwatan b on a.IdPoli = b.ID
            inner join MasterdataSQL.dbo.Doctors c on c.ID = a.DoctorID
            left join MasterdataSQL.dbo.Admision_walkin d on d.NoMR=a.NoMR
            where replace(CONVERT(VARCHAR(11), a.ApmDate, 111), '/','-') between :tgl_awal and :tgl_akhir
            and a.Batal='0' and a.Datang='0' and NamaPasien like :nama and NamaUnit='Laboratorium'";
        $this->db->query($query);
        $this->db->bind('tgl_awal', $data['tglawal']);
        $this->db->bind('tgl_akhir', $data['tglakhir']);
        $this->db->bind('nama', '%' . $data['nama'] . '%');
        // $this->db->bind('namapasien'$data);
        $this->db->execute();
        return $this->db->resultSet();
    }

    public function cariRekamMedik($data)
    {
        $query = "SELECT * from MasterdataSQL.dbo.Admision_walkin where 
            Aktif='1' and 
            [PatientName] like :namapasien or  CONVERT(VARCHAR(10), Date_of_birth, 103) like :tgl  or NoMR like :nomr 
            ORDER BY 1 DESC ";
        $this->db->query($query);
        $this->db->bind('namapasien', '%' . $data['namapasien'] . '%');
        $this->db->bind('tgl', '%' . $data['namapasien'] . '%');
        $this->db->bind('nomr', '%' . $data['namapasien'] . '%');
        $this->db->execute();
        return $this->db->resultSet();
    }

    public function getDataWalkinByid($id)
    {
        $query = "SELECT  a.NoAntrianAll, a.MrExist, a.JenisKelamin,a.id,a.NoUrut,a.ApmDate,a.NoBooking,a.NoMR,a.NamaPasien,a.Alamat,d.ID_Card_number,d.Ocupation,a.NoKTP,
        replace(CONVERT(VARCHAR(11), a.TglLahir, 111), '/','-') as TglLahir,
                   case when a.JenisPembayaran='PRIBADI' then '1' when a.JenisPembayaran='ASURANSI' then '2'   
                   when a.JenisPembayaran='JAMINAN PERUSAHAAN' then '5'   
                   END AS JenisPembayaran,replace(CONVERT(VARCHAR(11), a.ApmDate, 111), '/','-')  as ApmDate,
                   a.JamPraktek,a.NoAntrianAll,a.IdPoli,a.DoctorID,
                                       b.NamaUnit,c.First_Name,a.Telephone,a.HP,a.Description,A.Email
                                       from  PerawatanSQL.dbo.Apointment a
                                       inner join MasterdataSQL.dbo.MstrUnitPerwatan b on a.IdPoli = b.ID
									   left join MasterdataSQL.dbo.Admision_walkin d on a.NoMR = d.NoMR
                                       inner join MasterdataSQL.dbo.Doctors c on c.ID = a.DoctorID
                     WHERE A.ID=:ID";
        $this->db->query($query);
        $this->db->bind('ID', $id['idpasien']);
        $this->db->execute();
        return $this->db->single();
    }
    public function getPasienSudahpunyaMR($data)
    {
        $query = " SELECT replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as Date_of_birthx,
        NoMR,PatientName,Address,Gander,BirthPlace,Ocupation,
        case when Gander='L' then 'LAKI-LAKI' when Gander='P' then 'PEREMPUAN'  END AS NamaGander,
        ID_Card_number,*,
        --[E-mail Address] as email,[Mobile Phone] as mobilephone,[Home Phone] as homephone,*,
        [Country/Region] as warganegaara,[State/Province] as provinsi,[Home Phone] as homephone,
                            [Mobile Phone] as mobilephone,[E-mail Address] as email,Mother,[ZIP/Postal Code] as kodepos
        from MasterdataSQL.dbo.Admision_walkin where ID=:ID";
        $this->db->query($query);
        $this->db->bind('ID', $data['idpasien']);
        $this->db->execute();
        return $this->db->single();
    }
    public function getDokterJadwalhari($data)
    {
        if ($data['hari'] === "Minggu") {
            $quser = "SELECT A.ID,A.First_Name 
                from MasterdataSQL.dbo.Doctors A
                INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
                inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
                WHERE A.active='1' AND B.IdLayanan=:idlayanan AND c.Minggu='1'AND c.Status_Aktif='1'  group by A.ID,A.First_Name  ";
            $this->db->query($quser);
            $this->db->bind('idlayanan', $data['idlayanan']);
            $this->db->execute();
            return $this->db->resultSet();
        } elseif ($data['hari'] === "Senin") {
            $quser = "SELECT A.ID,A.First_Name 
                from MasterdataSQL.dbo.Doctors A
                INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
                inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
                WHERE A.active='1' AND B.IdLayanan=:idlayanan AND c.Senin='1'AND c.Status_Aktif='1' group by A.ID,A.First_Name  ";
            $this->db->query($quser);
            $this->db->bind('idlayanan', $data['idlayanan']);
            $this->db->execute();
            return $this->db->resultSet();
        } elseif ($data['hari'] === "Selasa") {
            $quser = "SELECT A.ID,A.First_Name 
                from MasterdataSQL.dbo.Doctors A
                INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
                inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
                WHERE A.active='1' AND B.IdLayanan=:idlayanan AND c.Selasa='1'AND c.Status_Aktif='1' group by A.ID,A.First_Name  ";
            $this->db->query($quser);
            $this->db->bind('idlayanan', $data['idlayanan']);
            $this->db->execute();
            return $this->db->resultSet();
        } elseif ($data['hari'] === "Rabu") {
            $quser = "SELECT A.ID,A.First_Name 
                from MasterdataSQL.dbo.Doctors A
                INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
                inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
                WHERE A.active='1' AND B.IdLayanan=:idlayanan AND c.Rabu='1'AND c.Status_Aktif='1' group by A.ID,A.First_Name   ";
            $this->db->query($quser);
            $this->db->bind('idlayanan', $data['idlayanan']);
            $this->db->execute();
            return $this->db->resultSet();
        } elseif ($data['hari'] === "Kamis") {
            $quser = "SELECT A.ID,A.First_Name 
                from MasterdataSQL.dbo.Doctors A
                INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
                inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
                WHERE A.active='1' AND B.IdLayanan=:idlayanan AND c.Kamis='1'AND c.Status_Aktif='1' group by A.ID,A.First_Name  ";
            $this->db->query($quser);
            $this->db->bind('idlayanan', $data['idlayanan']);
            $this->db->execute();
            return $this->db->resultSet();
        } elseif ($data['hari'] === "Jumat") {
            $quser = "SELECT A.ID,A.First_Name 
                from MasterdataSQL.dbo.Doctors A
                INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
                inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
                WHERE A.active='1' AND B.IdLayanan=:idlayanan AND c.Jumat='1'AND c.Status_Aktif='1' group by A.ID,A.First_Name  ";
            $this->db->query($quser);
            $this->db->bind('idlayanan', $data['idlayanan']);
            $this->db->execute();
            return $this->db->resultSet();
        } elseif ($data['hari'] === "Sabtu") {
            $quser = "SELECT A.ID,A.First_Name 
                from MasterdataSQL.dbo.Doctors A
                INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
                inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
                WHERE A.active='1' AND B.IdLayanan=:idlayanan AND c.Sabtu='1'AND c.Status_Aktif='1' group by A.ID,A.First_Name  ";
            $this->db->query($quser);
            $this->db->bind('idlayanan', $data['idlayanan']);
            $this->db->execute();
            return $this->db->resultSet();
        }
    }
    public function getJamDokterPraktek($data)
    {
        if ($data['hari'] === "Minggu") {
            $quser = "SELECT C.ID,A.First_Name , c.Status_Aktif,
            c.Senin,c.Senin_Waktu,c.Senin_Sesion,c.Selasa,c.Selasa_Waktu,c.Selasa_Sesion
            ,c.Rabu,c.Rabu_Waktu,c.Rabu_Sesion,c.Kamis,c.Kamis_Waktu,c.Kamis_Sesion
            ,c.Jumat,c.Jumat_Waktu,c.Jumat_Sesion,c.Sabtu,c.Sabtu_Waktu,c.Sabtu_Sesion
            ,c.Minggu,c.Minggu_Waktu,c.Minggu_Sesion,c.Note
            from MasterdataSQL.dbo.Doctors A
            --INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
            inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
            WHERE A.active='1' AND c.IDUnit=:layanan AND c.Minggu='1'AND c.Status_Aktif='1' and C.IDDokter=:iddokter ";
            $this->db->query($quser);
            $this->db->bind('layanan', $data['idlayanan']);
            $this->db->bind('iddokter', $data['iddokter']);
            $this->db->execute();
            return $this->db->resultSet();
        } elseif ($data['hari'] === "Senin") {
            $quser = "SELECT C.ID,A.First_Name,c.Status_Aktif,
            c.Senin,c.Senin_Waktu,c.Senin_Sesion,c.Selasa,c.Selasa_Waktu,c.Selasa_Sesion
            ,c.Rabu,c.Rabu_Waktu,c.Rabu_Sesion,c.Kamis,c.Kamis_Waktu,c.Kamis_Sesion
            ,c.Jumat,c.Jumat_Waktu,c.Jumat_Sesion,c.Sabtu,c.Sabtu_Waktu,c.Sabtu_Sesion
            ,c.Minggu,c.Minggu_Waktu,c.Minggu_Sesion,c.Note
            from MasterdataSQL.dbo.Doctors A
            --INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
            inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
            WHERE A.active='1' AND c.IDUnit=:layanan AND c.Senin='1'AND c.Status_Aktif='1' and C.IDDokter=:iddokter  ";
            $this->db->query($quser);
            $this->db->bind('layanan', $data['idlayanan']);
            $this->db->bind('iddokter', $data['iddokter']);
            $this->db->execute();
            return $this->db->resultSet();
        } elseif ($data['hari'] === "Selasa") {
            $quser = "SELECT C.ID,A.First_Name,c.Status_Aktif,
            c.Senin,c.Senin_Waktu,c.Senin_Sesion,c.Selasa,c.Selasa_Waktu,c.Selasa_Sesion
            ,c.Rabu,c.Rabu_Waktu,c.Rabu_Sesion,c.Kamis,c.Kamis_Waktu,c.Kamis_Sesion
            ,c.Jumat,c.Jumat_Waktu,c.Jumat_Sesion,c.Sabtu,c.Sabtu_Waktu,c.Sabtu_Sesion
            ,c.Minggu,c.Minggu_Waktu,c.Minggu_Sesion,c.Note
            from MasterdataSQL.dbo.Doctors A
            --INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
            inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
            WHERE A.active='1' AND c.IDUnit=:layanan AND c.Selasa='1'AND c.Status_Aktif='1' and C.IDDokter=:iddokter  ";
            $this->db->query($quser);
            $this->db->bind('layanan', $data['idlayanan']);
            $this->db->bind('iddokter', $data['iddokter']);
            $this->db->execute();
            return $this->db->resultSet();
        } elseif ($data['hari'] === "Rabu") {
            $quser = "SELECT C.ID,A.First_Name,c.Status_Aktif,
            c.Senin,c.Senin_Waktu,c.Senin_Sesion,c.Selasa,c.Selasa_Waktu,c.Selasa_Sesion
            ,c.Rabu,c.Rabu_Waktu,c.Rabu_Sesion,c.Kamis,c.Kamis_Waktu,c.Kamis_Sesion
            ,c.Jumat,c.Jumat_Waktu,c.Jumat_Sesion,c.Sabtu,c.Sabtu_Waktu,c.Sabtu_Sesion
            ,c.Minggu,c.Minggu_Waktu,c.Minggu_Sesion,c.Note
            from MasterdataSQL.dbo.Doctors A
            --INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
            inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
            WHERE A.active='1' AND c.IDUnit=:layanan AND c.Rabu='1'AND c.Status_Aktif='1' and C.IDDokter=:iddokter ";
            $this->db->query($quser);
            $this->db->bind('layanan', $data['idlayanan']);
            $this->db->bind('iddokter', $data['iddokter']);
            $this->db->execute();
            return $this->db->resultSet();
        } elseif ($data['hari'] === "Kamis") {
            $quser = "SELECT C.ID,A.First_Name,c.Status_Aktif,
            c.Senin,c.Senin_Waktu,c.Senin_Sesion,c.Selasa,c.Selasa_Waktu,c.Selasa_Sesion
            ,c.Rabu,c.Rabu_Waktu,c.Rabu_Sesion,c.Kamis,c.Kamis_Waktu,c.Kamis_Sesion
            ,c.Jumat,c.Jumat_Waktu,c.Jumat_Sesion,c.Sabtu,c.Sabtu_Waktu,c.Sabtu_Sesion
            ,c.Minggu,c.Minggu_Waktu,c.Minggu_Sesion,c.Note
            from MasterdataSQL.dbo.Doctors A
            --INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
            inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
            WHERE A.active='1' AND c.IDUnit=:layanan AND c.Kamis='1'AND c.Status_Aktif='1' and C.IDDokter=:iddokter  ";
            $this->db->query($quser);
            $this->db->bind('layanan', $data['idlayanan']);
            $this->db->bind('iddokter', $data['iddokter']);
            $this->db->execute();
            return $this->db->resultSet();
        } elseif ($data['hari'] === "Jumat") {
            $quser = "SELECT C.ID,A.First_Name,c.Status_Aktif,
            c.Senin,c.Senin_Waktu,c.Senin_Sesion,c.Selasa,c.Selasa_Waktu,c.Selasa_Sesion
            ,c.Rabu,c.Rabu_Waktu,c.Rabu_Sesion,c.Kamis,c.Kamis_Waktu,c.Kamis_Sesion
            ,c.Jumat,c.Jumat_Waktu,c.Jumat_Sesion,c.Sabtu,c.Sabtu_Waktu,c.Sabtu_Sesion
            ,c.Minggu,c.Minggu_Waktu,c.Minggu_Sesion,c.Note
            from MasterdataSQL.dbo.Doctors A
            --INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
            inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
            WHERE A.active='1' AND c.IDUnit=:layanan AND c.Jumat='1'AND c.Status_Aktif='1' and C.IDDokter=:iddokter ";
            $this->db->query($quser);
            $this->db->bind('layanan', $data['idlayanan']);
            $this->db->bind('iddokter', $data['iddokter']);
            $this->db->execute();
            return $this->db->resultSet();
        } elseif ($data['hari'] === "Sabtu") {
            $quser = "SELECT C.ID,A.First_Name,c.Status_Aktif,
            c.Senin,c.Senin_Waktu,c.Senin_Sesion,c.Selasa,c.Selasa_Waktu,c.Selasa_Sesion
            ,c.Rabu,c.Rabu_Waktu,c.Rabu_Sesion,c.Kamis,c.Kamis_Waktu,c.Kamis_Sesion
            ,c.Jumat,c.Jumat_Waktu,c.Jumat_Sesion,c.Sabtu,c.Sabtu_Waktu,c.Sabtu_Sesion
            ,c.Minggu,c.Minggu_Waktu,c.Minggu_Sesion,c.Note
            from MasterdataSQL.dbo.Doctors A
            --INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
            inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
            WHERE A.active='1' AND c.IDUnit=:layanan AND c.Sabtu='1'AND c.Status_Aktif='1' and C.IDDokter=:iddokter  ";
            $this->db->query($quser);
            $this->db->bind('layanan', $data['idlayanan']);
            $this->db->bind('iddokter', $data['iddokter']);
            $this->db->execute();
            return $this->db->resultSet();
        }
    }

    public function getshiftDokter($data)
    {
        // var_dump($data);
        $query = "SELECT *
            from MasterdataSQL.DBO.JadwalPraktekSesion where :jam between Jam_Awal and Jam_Akhir";
        $this->db->query($query);
        $this->db->bind('jam', $data['jam']);
        $this->db->execute();
        return $this->db->single();
    }

    public function caridatareservasi($data)
    {
        $query = "SELECT a.ID,a.NoUrut,a.NoBooking,a.NoMR,a.NamaPasien,a.Alamat,a.TglLahir,
                                      a.JenisPembayaran,replace(CONVERT(VARCHAR(11), a.ApmDate, 111), '/','-')  as ApmDate,a.JamPraktek,a.NoAntrianAll,
                                      b.NamaUnit,c.First_Name,a.Description,a.HP
                                      from  PerawatanSQL.dbo.Apointment a
                                      inner join MasterdataSQL.dbo.MstrUnitPerwatan b on a.IdPoli = b.ID
                                      inner join MasterdataSQL.dbo.Doctors c on c.ID = a.DoctorID
                                      left join MasterdataSQL.dbo.Admision_walkin d on d.NoMR=a.NoMR
                                      where replace(CONVERT(VARCHAR(11), a.ApmDate, 111), '/','-') between :tgl_awal and :tgl_akhir
                                      and a.Batal='0' and a.Datang='0' and NamaUnit='Laboratorium'";
        $this->db->query($query);
        $this->db->bind('tgl_awal', $data['tglawal_Search']);
        $this->db->bind('tgl_akhir', $data['tglakhir_Search']);
        $this->db->execute();
        return $this->db->resultSet();
    }

    public function getDatareservasibyid($data)
    {
        // var_dump($data);
        $datareservasi = "SELECT  a.NoAntrianAll, a.MrExist, a.JenisKelamin, a.id,a.NoUrut,a.NoBooking,a.NoMR,a.NamaPasien,a.NoKTP,d.Ocupation,a.Alamat,c.First_Name,
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
                                       a.NoKTP
                                       from  PerawatanSQL.dbo.Apointment a
                                       inner join MasterdataSQL.dbo.MstrUnitPerwatan b on a.IdPoli = b.ID
                                       inner join MasterdataSQL.dbo.Doctors c on c.ID = a.DoctorID
									   left join MasterdataSQL.dbo.Admision_walkin d on a.NoMR = d.NoMR
                     WHERE A.ID=:ID";
        $this->db->query($datareservasi);
        $this->db->bind('ID', $data['ID']);
        $this->db->execute();
        return $this->db->single();
    }

    public function createReservasi($data)
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


        $idkananxres = substr($data['tglreservasi'], 8); // xx-xx-03 kanan
        $idtengahxres = substr($data['tglreservasi'], -5, -3); //
        $tglres = substr($data['tglreservasi'], 0, -8);
        $idbookingres =   $tglres . $idtengahxres . $idkananxres;
        $TglBookingx = $data['tglreservasi'];
        $idkananxcat = substr($TglBookingx, 8);
        $idtengahxres = substr($TglBookingx, -5, -3);
        $tgl = substr($TglBookingx, 0, -8);
        $idbooking =   $tgl . $idtengahxres . $idkananxcat;
        // var_dump($data);
        $pembayaran = "";
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
        try {
            $this->db->transaksi();
            $poli = "SELECT NamaUnit from MasterdataSQL.dbo.MstrUnitPerwatan where id=:id";
            $this->db->query($poli);
            $this->db->bind('id', $IdGrupPerawatan);
            $this->db->execute();
            $namapoli = $this->db->single();
            // nama dokter
            $dokter = "SELECT First_Name from MasterdataSQL.dbo.Doctors where id=:id";
            $this->db->query($dokter);
            $this->db->bind('id', $IdDokter);
            $this->db->execute();
            $namadokter = $this->db->single();
            if ($PasienNoBooking != "") {
                // var_dump("Nomor booking tidak kosong");
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
                $this->db->bind('PasienNoBooking', $data['PasienNoBooking']);
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
                $this->db->bind('petugas_edit', $data['petugasbatal']);
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
                $callback = array(
                    'status' => 'updated',
                    'message' => 'Registrasi ' . $data['PasienNoBooking'] . " Berhasil Di perbaharui"
                );
                return $callback;
            } else {
                // var_dump($data);
                // var_dump('nomor booking kosong');
                // // convert no booking   
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
                // var_dump($idbookingres);

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
                // var_dump($jadwalcutidokter);
                if (!empty($jadwalcutidokter)) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => "Dokter Yang Anda Pilih sedang Cuti !",
                        // 'nama' => $data['nama'], // Set array nama dengan isi kolom nama pada tabel siswa    
                    );
                    return $callback;
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
                    // var_dump($nobokingreal);

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
                                'status' => 'warning',
                                'errorname' => "Pasien Sudah Reservasi di Poli dan Dokter yang sama !", // Set array nama dengan isi kolom nama pada tabel siswa
                                'errormessage' => $dataidregfieedback,
                                // 'nama' => $data['nama'], // Set array nama dengan isi kolom nama pada tabel siswa    
                            );
                            return $callback;
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
                                       StatusMenikah
                                       ) VALUES ( 
                                       :idbooking,
                                       '1',
                                       :nouruttrx,
                                       :NoMr,
                                       :TglLahir,
                                       :JnsKelamin,
                                       '',
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
                                       :Medrec_statusNikah
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
                            $this->db->bind('operator', $data['iduser']);
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
                                'nama_biling' => "Administrasi Pasien Walkin",
                                'petugas_entry' => $data['iduser'],
                                'tgl_entry' => date("Y-m-d H:i:s")
                            ];
                            $this->logAlasan($datalog);
                            $this->db->Commit();
                            $callback = array(
                                'status' => 'success',
                                'NoBoking' => $nobokingreal,
                                'NoAntrianPoli' => $fixNoAntrian,
                                'IdDokter' => $namadokter,
                                'IdPoli' => $IdGrupPerawatan,
                                'mrexist' => $MrExist,
                                'NoAntrianAll' =>  $fixNoAntrian,
                            );
                            return $callback;
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
                                       StatusMenikah
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
                                       :Medrec_statusNikah
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
                        $this->db->bind('operator', $data['iduser']);
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
                            'nama_biling' => "Administrasi Pasien Walkin",
                            'petugas_entry' => $data['iduser'],
                            'tgl_entry' => date("Y-m-d H:i:s")
                        ];
                        $this->logAlasan($datalog);
                        $this->db->Commit();
                        $callback = array(
                            'status' => 'success',
                            'NoBoking' => $nobokingreal,
                            'NoAntrianPoli' => $fixNoAntrian,
                            'IdDokter' => $namadokter,
                            'IdPoli' => $IdGrupPerawatan,
                            'mrexist' => $MrExist,
                            'NoAntrianAll' =>  $fixNoAntrian,

                        );
                        return $callback;
                    }
                }
            }
            // $this->db->Commit();
        } catch (PDOException $e) {
            $this->db->rollback();
            return $e;
        }
    }

    public function batalReservasi($data)
    {
        // var_dump($data);
        try {
            $this->db->transaksi();
            if (!empty($this->cekSudahdiregis($data['nomorbooking']))) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Reservasi ini sudah berubah menjadi Registrasi, Anda Tidak membatalkan !',
                );
                return $callback;
            } else {
                $upadteyangbatal = $this->yangbatalReservasi($data);
                $updateflagbatal = $this->flagbatal($data);
                $this->logBatal($data);
                if ($upadteyangbatal > 0 && $updateflagbatal > 0) {
                    $callback = array(
                        'status' => 'success',
                    );
                    $this->db->Commit();
                    return $callback;
                }
            }
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => 'Error',
                'errorname' => $e,
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

    public function cekSudahdiregis($noregbatal)
    {
        $cekregis = "SELECT *from PerawatanSQL.dbo.Apointment where NoBooking=:NoBooking  and Datang='1'";
        $this->db->query($cekregis);
        $this->db->bind('NoBooking', $noregbatal);
        $this->db->execute();
        return $this->db->single();
    }

    public function cekPembayaran($noregistrasi)
    {
        $pembayaran = "SELECT *from PerawatanSQL.dbo.payments where NoRegistrasi=:NoRegistrasi";
        $this->db->query($pembayaran);
        $this->db->bind('NoRegistrasi', $noregistrasi);
        $this->db->execute();
        return $this->db->single();
    }

    public function cekAssesmentDokter($NoRegistrasi)
    {
        $assesment = "SELECT *from MedicalRecord.dbo.EMR_RWJ where NoRegistrasi=:NoRegistrasi";
        $this->db->query($assesment);
        $this->db->bind('NoRegistrasi', $NoRegistrasi);
        $this->db->execute();
        return $this->db->single();
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
}
