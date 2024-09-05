<?php
class  B_InformationPasienRanap_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getDataListPasien($data)
    {
        try {
            $tglawal = $data['TglAwal'];
            $tglakhir = $data['TglAkhir'];
            $jenis_info = $data['JenisInfo'];
            $tp_pasien = $data['TipePenjamin'];
            $id_penjamin = $data['NamaPenjamin'];
            $datenow = Utils::datenowcreateNotFull();

            //PASIEN MASIH DIRAWAT
            if ($jenis_info == '1') {
                //     $query_master = "SELECT CONVERT(VARCHAR(8), a.startTime, 108)  as startTime,replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as TglKunjungan,
                //     CASE WHEN a.EndDate is null 
                //    then DateDiff (Day,a.StartDate,:datenow) 
                //    else DateDiff (Day,a.StartDate,a.EndDate) 
                //    end as Lamarawat,replace(CONVERT(VARCHAR(11), a.EndDate, 111), '/','-') as TglPulang ,a.jenis_rawat   ,a.NoMR,a.NoRegRI as NoRegistrasi,b.PatientName,
                //         b.Gander,a.JenisRawat as NamaUnit, 
                //         c.First_Name,d.TypePatient,b.Address ,
                //         case when a.TypePatient='2' then opx.NamaPerusahaan  
                //      when a.TypePatient='5' then op.NamaPerusahaan else
                //     'UMUM' end as NamaPerusahaan,
                //         --op.NamaPerusahaan  
                //         co.[Status Name] as statusregis,
                //         replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as tglregis,
                //         replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-') as tglregis,
                //         case 
                //         when replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') > replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-')
                //         then 'Lama'  ELSE 'Baru'
                //         end as 'JenisPasien', '' as NamaCaraMasuk,'' as NamaCaraMasukRef,'' as tarif,'' as TarifRS,'0' AS  totalbill,
                //         xm.Kecamatan,mx.Kelurahan,msx.kabupatenNama,ggg.ProvinsiNama
                //         ,jk.Class,jk.RoomName,jk.Bed, DATEDIFF(yy, b.Date_of_birth, GETDATE()) as UMUR,diag.DiagnosaPrimer
                //         from RawatInapSQL.dbo.Inpatient a
                //         left join MasterdataSQL.dbo.Admision b
                //         on a.NoMR = b.NoMR
                //         left join MasterdataSQL.dbo.Doctors c
                //         on c.ID = a.drPenerima
                //         left join MasterdataSQL.dbo.MstrTypePatient d
                //         on d.ID = a.TypePatient 
                //         left join MasterdataSQL.dbo.MstrPerusahaanAsuransi opx on opx.ID = a.IDAsuransi
                //         left join MasterdataSQL.dbo.MstrPerusahaanJPK op on op.ID = a.IDJPK
                //         left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.StatusID
                //         left join MasterdataSQL.dbo.mstrKecamatan xm on xm.kecamatanId = b.Kecamatan
                //         left join MasterdataSQL.dbo.mstrKelurahan mx on mx.desaId = b.Kelurahan
                //         left join MasterdataSQL.dbo.MstrKabupaten msx on msx.kabupatenId=b.City
                //         left join MasterdataSQL.dbo.MstrProvinsi ggg on ggg.PovinsiID = b.[State/Province]
                //         left join RawatInapSQL.dbo.Inpatient_in_out jk on jk.NoRegRI = a.NoRegRI
                //         left join  (SELECT NoEpisode,DiagnosaPrimer FROM MedicalRecord.dbo.EMR_UGD_MedicalAss where NamaUser is not null)diag  
                //         on a.NoEpisode collate Latin1_General_CS_AS = diag.NoEpisode collate Latin1_General_CS_AS
                //         where a.StatusID<>'4'  and jk.StatusActive='1' and a.EndDate is null
                //            ";

                $query_master = "SELECT *,a.Sex as Gander, DATEDIFF(yy, a.DateOfBirth, GETDATE()) as UMUR,replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as TglKunjungan, CASE WHEN a.EndDate is null 
                    then DateDiff (Day,a.StartDate,:datenow) 
                    else DateDiff (Day,a.StartDate,a.EndDate) 
                    end as Lamarawat,replace(CONVERT(VARCHAR(11), a.EndDate, 111), '/','-') as TglPulang, c.First_Name,JenisPerawatan as NamaUnit,a.TipePasien as TypePatient,NamaJaminan as NamaPerusahaan,Diagnosa_Awal as DiagnosaPrimer,Case When StatusID = '0' Then 'New'
                WHEN StatusID = '1' Then 'Invoiced'
                WHEN StatusID = '2' Then 'Payment'
                WHEN StatusID = '3' Then 'Lunas'
                WHEN StatusID = '4' Then 'Close'
                End As 'statusregis',KelasName_Akhir as Class,RoomName_Akhir as RoomName,d.Bad as Bed,d.Ward
                        from DashboardData.dbo.dataRWI a
                    left join RawatInapSQL.dbo.Inpatient_in_out jk on jk.NoRegRI = a.NoRegistrasi 
                    left join MasterdataSQL.dbo.Doctors c on c.ID = a.drPenerima
                    left join MasterdataSQL.dbo.MstrRoomID d on d.RoomID = a.RoomID_Akhir 
                        where a.StatusID<>'4'  and jk.StatusActive='1' and a.EndDate is null
                        ";

                // PASIEN DENGAN TANGGAL MASUK
            } elseif ($jenis_info == '2') {
                //     $query_master = "SELECT CONVERT(VARCHAR(8), a.startTime, 108)  as startTime,replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as TglKunjungan,
                //     CASE WHEN a.EndDate is null 
                //    then DateDiff (Day,a.StartDate,:datenow) 
                //    else DateDiff (Day,a.StartDate,a.EndDate) 
                //    end as Lamarawat,replace(CONVERT(VARCHAR(11), a.EndDate, 111), '/','-') as TglPulang ,a.jenis_rawat   ,a.NoMR,a.NoRegRI as NoRegistrasi,b.PatientName,
                //             b.Gander,a.JenisRawat as NamaUnit, 
                //             c.First_Name,d.TypePatient,b.Address ,
                //             case when a.TypePatient='2' then opx.NamaPerusahaan  
                //          when a.TypePatient='5' then op.NamaPerusahaan else
                //         'UMUM' end as NamaPerusahaan,
                //             --op.NamaPerusahaan  
                //             co.[Status Name] as statusregis,
                //             replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as tglregis,
                //             replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-') as tglregis,
                //             case 
                //             when replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') > replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-')
                //             then 'Lama'  ELSE 'Baru'
                //             end as 'JenisPasien', '' as NamaCaraMasuk,'' as NamaCaraMasukRef,'' as tarif,'' as TarifRS,'0' AS  totalbill,
                //             xm.Kecamatan,mx.Kelurahan,msx.kabupatenNama,ggg.ProvinsiNama
                //             ,x.Class,x.RoomName,x.Bed, DATEDIFF(yy, b.Date_of_birth, GETDATE()) as UMUR,diag.DiagnosaPrimer
                //             from RawatInapSQL.dbo.Inpatient a
                //             left join MasterdataSQL.dbo.Admision b
                //             on a.NoMR = b.NoMR
                //             left join MasterdataSQL.dbo.Doctors c
                //             on c.ID = a.drPenerima
                //             left join MasterdataSQL.dbo.MstrTypePatient d
                //             on d.ID = a.TypePatient 
                //             left join MasterdataSQL.dbo.MstrPerusahaanAsuransi opx on opx.ID = a.IDAsuransi
                //             left join MasterdataSQL.dbo.MstrPerusahaanJPK op on op.ID = a.IDJPK
                //             left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.StatusID
                //             left join MasterdataSQL.dbo.mstrKecamatan xm on xm.kecamatanId = b.Kecamatan
                //             left join MasterdataSQL.dbo.mstrKelurahan mx on mx.desaId = b.Kelurahan
                //             left join MasterdataSQL.dbo.MstrKabupaten msx on msx.kabupatenId=b.City
                //             left join MasterdataSQL.dbo.MstrProvinsi ggg on ggg.PovinsiID = b.[State/Province]
                //                 OUTER APPLY
                //             ( 
                //                 select top 1 Class,RoomName,Bed,NoRegRI from  RawatInapSQL.dbo.Inpatient_in_out where NoRegRI=a.NoRegRI order by 1 desc
                //             )as x
                //             left join  (SELECT NoEpisode,DiagnosaPrimer FROM MedicalRecord.dbo.EMR_UGD_MedicalAss where NamaUser is not null)diag  
                //             on a.NoEpisode collate Latin1_General_CS_AS = diag.NoEpisode collate Latin1_General_CS_AS
                //             where  replace(CONVERT(VARCHAR(11), a.StartDate , 111), '/','-') between :tglawal and :tglakhir";

                $query_master = "SELECT *,a.Sex as Gander, DATEDIFF(yy, a.DateOfBirth, GETDATE()) as UMUR,replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as TglKunjungan, CASE WHEN a.EndDate is null 
        then DateDiff (Day,a.StartDate,:datenow) 
        else DateDiff (Day,a.StartDate,a.EndDate) 
        end as Lamarawat,replace(CONVERT(VARCHAR(11), a.EndDate, 111), '/','-') as TglPulang, c.First_Name,JenisPerawatan as NamaUnit,a.TipePasien as TypePatient,NamaJaminan as NamaPerusahaan,Diagnosa_Awal as DiagnosaPrimer,Case When StatusID = '0' Then 'New'
    WHEN StatusID = '1' Then 'Invoiced'
    WHEN StatusID = '2' Then 'Payment'
    WHEN StatusID = '3' Then 'Lunas'
    WHEN StatusID = '4' Then 'Close'
    End As 'statusregis',KelasName_Akhir as Class,RoomName_Akhir as RoomName,d.Bad as Bed,d.Ward
            from DashboardData.dbo.dataRWI a
             left join MasterdataSQL.dbo.Doctors c on c.ID = a.drPenerima
             left join MasterdataSQL.dbo.MstrRoomID d on d.RoomID = a.RoomID_Akhir 
            where replace(CONVERT(VARCHAR(11), a.StartDate , 111), '/','-') between :tglawal and :tglakhir
            ";

                // PASIEN DENGAN TANGGAL KELUAR
            } elseif ($jenis_info == '3') {
                //     $query_master = "SELECT CONVERT(VARCHAR(8), a.startTime, 108)  as startTime,replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as TglKunjungan,
                //     CASE WHEN a.EndDate is null 
                //    then DateDiff (Day,a.StartDate,:datenow) 
                //    else DateDiff (Day,a.StartDate,a.EndDate) 
                //    end as Lamarawat,replace(CONVERT(VARCHAR(11), a.EndDate, 111), '/','-') as TglPulang ,a.jenis_rawat   ,a.NoMR,a.NoRegRI as NoRegistrasi,b.PatientName,
                //         b.Gander,a.JenisRawat as NamaUnit, 
                //         c.First_Name,a.TypePatient,b.Address ,
                //         case when a.TypePatient='2' then opx.NamaPerusahaan  
                //          when a.TypePatient='5' then op.NamaPerusahaan else
                //         'UMUM' end as NamaPerusahaan,
                //         --op.NamaPerusahaan 
                //         co.[Status Name] as statusregis,
                //         replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as tglregis,
                //         replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-') as tglregis,
                //         case 
                //         when replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') > replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-')
                //         then 'Lama'  ELSE 'Baru'
                //         end as 'JenisPasien', '' as NamaCaraMasuk,'' as NamaCaraMasukRef,'' as tarif,'' as TarifRS,'0' AS  totalbill,
                //         xm.Kecamatan,mx.Kelurahan,msx.kabupatenNama,ggg.ProvinsiNama
                //         ,x.Class,x.RoomName,x.Bed, DATEDIFF(yy, b.Date_of_birth, GETDATE()) as UMUR,diag.DiagnosaPrimer
                //         from RawatInapSQL.dbo.Inpatient a
                //         left join MasterdataSQL.dbo.Admision b
                //         on a.NoMR = b.NoMR
                //         left join MasterdataSQL.dbo.Doctors c
                //         on c.ID = a.drPenerima
                //         left join MasterdataSQL.dbo.MstrTypePatient d
                //         on d.ID = a.TypePatient 
                //         left join MasterdataSQL.dbo.MstrPerusahaanJPK op on op.ID = a.IDJPK
                //         left join MasterdataSQL.dbo.MstrPerusahaanAsuransi opx on opx.ID = a.IDAsuransi
                //         left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.StatusID
                //         left join MasterdataSQL.dbo.mstrKecamatan xm on xm.kecamatanId = b.Kecamatan
                //         left join MasterdataSQL.dbo.mstrKelurahan mx on mx.desaId = b.Kelurahan
                //         left join MasterdataSQL.dbo.MstrKabupaten msx on msx.kabupatenId=b.City
                //         left join MasterdataSQL.dbo.MstrProvinsi ggg on ggg.PovinsiID = b.[State/Province]
                //         OUTER APPLY
                //         ( 
                //             select top 1 Class,RoomName,Bed,NoRegRI from  RawatInapSQL.dbo.Inpatient_in_out where NoRegRI=a.NoRegRI order by 1 desc
                //         )as x
                //         left join  (SELECT NoEpisode,DiagnosaPrimer FROM MedicalRecord.dbo.EMR_UGD_MedicalAss where NamaUser is not null)diag  
                //         on a.NoEpisode collate Latin1_General_CS_AS = diag.NoEpisode collate Latin1_General_CS_AS
                //         where  replace(CONVERT(VARCHAR(11), a.EndDate , 111), '/','-') between :tglawal and :tglakhir";
                //ORDER BY
                //$orderby = " ORDER BY  4  ASC, 6 ASC";

                $query_master = "SELECT *,a.Sex as Gander, DATEDIFF(yy, a.DateOfBirth, GETDATE()) as UMUR,replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as TglKunjungan, CASE WHEN a.EndDate is null 
            then DateDiff (Day,a.StartDate,:datenow) 
            else DateDiff (Day,a.StartDate,a.EndDate) 
            end as Lamarawat,replace(CONVERT(VARCHAR(11), a.EndDate, 111), '/','-') as TglPulang, c.First_Name,JenisPerawatan as NamaUnit,a.TipePasien as TypePatient,NamaJaminan as NamaPerusahaan,Diagnosa_Awal as DiagnosaPrimer,Case When StatusID = '0' Then 'New'
        WHEN StatusID = '1' Then 'Invoiced'
        WHEN StatusID = '2' Then 'Payment'
        WHEN StatusID = '3' Then 'Lunas'
        WHEN StatusID = '4' Then 'Close'
        End As 'statusregis',KelasName_Akhir as Class,RoomName_Akhir as RoomName,d.Bad as Bed,d.Ward
                from DashboardData.dbo.dataRWI a
            left join MasterdataSQL.dbo.Doctors c on c.ID = a.drPenerima
            left join MasterdataSQL.dbo.MstrRoomID d on d.RoomID = a.RoomID_Akhir 
                where replace(CONVERT(VARCHAR(11), a.EndDate , 111), '/','-') between :tglawal and :tglakhir
                ";
            }
            $orderby = "ORDER BY replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-')  ASC, A.NoMR ASC";

            if ($tp_pasien == '1') { //PRIBADI
                //$query_tambahan = " AND d.TypePatient='UMUM'";
                $query_tambahan = " AND a.TipePasien='1'";
                $query = $query_master . $query_tambahan . $orderby;
                $this->db->query($query);
            } elseif ($tp_pasien == '5') { //Jaminan, Perusahaan
                if ($id_penjamin != null || $id_penjamin != '') { //Perusahaan Filter by ID perusahaan----

                    // $query_tambahan = " AND a.IDJPK=:id_penjamin AND d.TypePatient='JAMINAN PERUSAHAAN'";
                    $query_tambahan = " AND a.KodeJaminan=:id_penjamin AND a.TipePasien='5'";
                    $query = $query_master . $query_tambahan . $orderby;
                    $this->db->query($query);
                    $this->db->bind('id_penjamin', $id_penjamin);
                } else { //Perusahaan ALL----
                    //$query_tambahan = " AND d.TypePatient='JAMINAN PERUSAHAAN'";
                    $query_tambahan = " AND a.TipePasien='5'";
                    $query = $query_master . $query_tambahan . $orderby;
                    $this->db->query($query);
                }
            } elseif ($tp_pasien == '2') { //Jaminan, Asuransi
                if ($id_penjamin != null || $id_penjamin != '') { //Asuransi Filter by ID Asuransi---
                    //$query_tambahan = " AND a.IDAsuransi=:id_penjamin AND d.TypePatient='ASURANSI'";
                    $query_tambahan = " AND a.KodeJaminan=:id_penjamin AND a.TipePasien='2'";
                    $query = $query_master . $query_tambahan . $orderby;
                    $this->db->query($query);
                    $this->db->bind('id_penjamin', $id_penjamin);
                } else { //Asuransi ALL----
                    //$query_tambahan = " AND d.TypePatient='ASURANSI'";
                    $query_tambahan = " AND a.TipePasien='2'";
                    $query = $query_master . $query_tambahan . $orderby;
                    $this->db->query($query);
                }
            } else { // No Filter
                $query_tambahan = "";
                $query = $query_master . $query_tambahan . $orderby;
                $this->db->query($query);
            }

            //Binding
            if ($jenis_info <> '1') {
                $this->db->bind('tglawal', $tglawal);
                $this->db->bind('tglakhir', $tglakhir);
            }
            $this->db->bind('datenow', $datenow);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $row) {
                $pasing['no'] = $no++;
                $pasing['NoMR'] = $row['NoMR'];
                $pasing['PatientName'] = $row['PatientName'];
                $pasing['NoRegistrasi'] = $row['NoRegistrasi'];
                $pasing['Gander'] = $row['Gander'];
                $pasing['UMUR'] = $row['UMUR'];
                $pasing['TglKunjungan'] = $row['TglKunjungan'];
                $pasing['TglPulang'] = $row['TglPulang'];
                $pasing['Lamarawat'] = $row['Lamarawat'];
                $pasing['First_Name'] = $row['First_Name'];
                $pasing['NamaUnit'] = $row['Ward'];
                $pasing['Class'] = $row['Class'];
                $pasing['RoomName'] = $row['RoomName'];
                $pasing['Bed'] = $row['Bed'];
                $pasing['TypePatient'] = $row['TypePatient'];
                $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                $pasing['DiagnosaPrimer'] = $row['DiagnosaPrimer'];
                $pasing['statusregis'] = $row['statusregis'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDataListPasien1($data)
    {
        try {
            $tglawal = $data['TglAwal'];
            $tglakhir = $data['TglAkhir'];
            $jenis_info = $data['JenisInfo'];
            $tp_pasien = $data['TipePenjamin'];
            $id_penjamin = $data['NamaPenjamin'];
            $datenow = Utils::datenowcreateNotFull();

            //PASIEN MASIH DIRAWAT
            if ($jenis_info == '1') {

                $query_master = "SELECT *,a.Sex as Gander, DATEDIFF(yy, a.DateOfBirth, GETDATE()) as UMUR,replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as TglKunjungan, CASE WHEN a.EndDate is null 
                    then DateDiff (Day,a.StartDate,:datenow) 
                    else DateDiff (Day,a.StartDate,a.EndDate) 
                    end as Lamarawat,replace(CONVERT(VARCHAR(11), a.EndDate, 111), '/','-') as TglPulang, c.First_Name,JenisPerawatan as NamaUnit,a.TipePasien as TypePatient,NamaJaminan as NamaPerusahaan,Diagnosa_Awal as DiagnosaPrimer,Case When StatusID = '0' Then 'New'
                WHEN StatusID = '1' Then 'Invoiced'
                WHEN StatusID = '2' Then 'Payment'
                WHEN StatusID = '3' Then 'Lunas'
                WHEN StatusID = '4' Then 'Close'
                End As 'statusregis',KelasName_Akhir as Class,RoomName_Akhir as RoomName,'' as Bed
                        from DashboardData.dbo.dataRWI a
                    left join RawatInapSQL.dbo.Inpatient_in_out jk on jk.NoRegRI = a.NoRegistrasi left join MasterdataSQL.dbo.Doctors c on c.ID = a.drPenerima
                        where a.StatusID<>'4'  and jk.StatusActive='1' and a.EndDate is null
                        ";

                // PASIEN DENGAN TANGGAL MASUK
            } elseif ($jenis_info == '2') {

                $query_master = "SELECT *,a.Sex as Gander, DATEDIFF(yy, a.DateOfBirth, GETDATE()) as UMUR,replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as TglKunjungan, CASE WHEN a.EndDate is null 
        then DateDiff (Day,a.StartDate,:datenow) 
        else DateDiff (Day,a.StartDate,a.EndDate) 
        end as Lamarawat,replace(CONVERT(VARCHAR(11), a.EndDate, 111), '/','-') as TglPulang, c.First_Name,JenisPerawatan as NamaUnit,a.TipePasien as TypePatient,NamaJaminan as NamaPerusahaan,Diagnosa_Awal as DiagnosaPrimer,Case When StatusID = '0' Then 'New'
    WHEN StatusID = '1' Then 'Invoiced'
    WHEN StatusID = '2' Then 'Payment'
    WHEN StatusID = '3' Then 'Lunas'
    WHEN StatusID = '4' Then 'Close'
    End As 'statusregis',KelasName_Akhir as Class,RoomName_Akhir as RoomName,'' as Bed
            from DashboardData.dbo.dataRWI a
             left join MasterdataSQL.dbo.Doctors c on c.ID = a.drPenerima
            where replace(CONVERT(VARCHAR(11), a.StartDate , 111), '/','-') between :tglawal and :tglakhir
            ";

                // PASIEN DENGAN TANGGAL KELUAR
            } elseif ($jenis_info == '3') {

                $query_master = "SELECT *,a.Sex as Gander, DATEDIFF(yy, a.DateOfBirth, GETDATE()) as UMUR,replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as TglKunjungan, CASE WHEN a.EndDate is null 
            then DateDiff (Day,a.StartDate,:datenow) 
            else DateDiff (Day,a.StartDate,a.EndDate) 
            end as Lamarawat,replace(CONVERT(VARCHAR(11), a.EndDate, 111), '/','-') as TglPulang, c.First_Name,JenisPerawatan as NamaUnit,a.TipePasien as TypePatient,NamaJaminan as NamaPerusahaan,Diagnosa_Awal as DiagnosaPrimer,Case When StatusID = '0' Then 'New'
        WHEN StatusID = '1' Then 'Invoiced'
        WHEN StatusID = '2' Then 'Payment'
        WHEN StatusID = '3' Then 'Lunas'
        WHEN StatusID = '4' Then 'Close'
        End As 'statusregis',KelasName_Akhir as Class,RoomName_Akhir as RoomName,'' as Bed
                from DashboardData.dbo.dataRWI a
            left join MasterdataSQL.dbo.Doctors c on c.ID = a.drPenerima
                where replace(CONVERT(VARCHAR(11), a.EndDate , 111), '/','-') between :tglawal and :tglakhir
                ";
            }
            $orderby = "ORDER BY replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-')  ASC, A.NoMR ASC";

            if ($tp_pasien == '1') { //PRIBADI
                //$query_tambahan = " AND d.TypePatient='UMUM'";
                $query_tambahan = " AND a.TipePasien='1'";
                $query = $query_master . $query_tambahan . $orderby;
                $this->db->query($query);
            } elseif ($tp_pasien == '5') { //Jaminan, Perusahaan
                if ($id_penjamin != null || $id_penjamin != '') { //Perusahaan Filter by ID perusahaan----

                    // $query_tambahan = " AND a.IDJPK=:id_penjamin AND d.TypePatient='JAMINAN PERUSAHAAN'";
                    $query_tambahan = " AND a.KodeJaminan=:id_penjamin AND a.TipePasien='5'";
                    $query = $query_master . $query_tambahan . $orderby;
                    $this->db->query($query);
                    $this->db->bind('id_penjamin', $id_penjamin);
                } else { //Perusahaan ALL----
                    //$query_tambahan = " AND d.TypePatient='JAMINAN PERUSAHAAN'";
                    $query_tambahan = " AND a.TipePasien='5'";
                    $query = $query_master . $query_tambahan . $orderby;
                    $this->db->query($query);
                }
            } elseif ($tp_pasien == '2') { //Jaminan, Asuransi
                if ($id_penjamin != null || $id_penjamin != '') { //Asuransi Filter by ID Asuransi---
                    //$query_tambahan = " AND a.IDAsuransi=:id_penjamin AND d.TypePatient='ASURANSI'";
                    $query_tambahan = " AND a.KodeJaminan=:id_penjamin AND a.TipePasien='2'";
                    $query = $query_master . $query_tambahan . $orderby;
                    $this->db->query($query);
                    $this->db->bind('id_penjamin', $id_penjamin);
                } else { //Asuransi ALL----
                    //$query_tambahan = " AND d.TypePatient='ASURANSI'";
                    $query_tambahan = " AND a.TipePasien='2'";
                    $query = $query_master . $query_tambahan . $orderby;
                    $this->db->query($query);
                }
            } else { // No Filter
                $query_tambahan = "";
                $query = $query_master . $query_tambahan . $orderby;
                $this->db->query($query);
            }

            //Binding
            if ($jenis_info <> '1') {
                $this->db->bind('tglawal', $tglawal);
                $this->db->bind('tglakhir', $tglakhir);
            }
            $this->db->bind('datenow', $datenow);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $row) {
                $pasing['no'] = $no++;
                $pasing['NoMR'] = $row['NoMR'];
                $pasing['PatientName'] = $row['PatientName'];
                $pasing['NoRegistrasi'] = $row['NoRegistrasi'];
                $pasing['Gander'] = $row['Gander'];
                $pasing['UMUR'] = $row['UMUR'];
                $pasing['TglKunjungan'] = $row['TglKunjungan'];
                $pasing['TglPulang'] = $row['TglPulang'];
                $pasing['Lamarawat'] = $row['Lamarawat'];
                $pasing['First_Name'] = $row['First_Name'];
                $pasing['NamaUnit'] = $row['NamaUnit'];
                $pasing['Class'] = $row['Class'];
                $pasing['RoomName'] = $row['RoomName'];
                $pasing['Bed'] = $row['Bed'];
                $pasing['TypePatient'] = $row['TypePatient'];
                $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                $pasing['DiagnosaPrimer'] = $row['DiagnosaPrimer'];
                $pasing['statusregis'] = $row['statusregis'];
                $rows[] = $pasing;
            }
            return $data;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
