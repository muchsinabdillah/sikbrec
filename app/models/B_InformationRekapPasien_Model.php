<?php
class  B_InformationRekapPasien_Model
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

            $this->db->query("SELECT a.NoMR,a.NoRegistrasi as NoRegRI,a.PatientName,a.TipePasien as TypePatient,a.Address,NamaJaminan as NamaPerusahaan,'RAWAT INAP' as JenisReg, RoomName_Awal as NAMA_RUANG_AWAL,RoomName_Akhir as NAMA_RUANG_AKHIR,KelasName_Awal as KELAS_PERAWATAN_AWAL,KelasName_Akhir as KELAS_PERAWATAN_AKHIR,replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as TGL_MASUK,replace(CONVERT(VARCHAR(11), a.EndDate, 111), '/','-') AS TGL_KELUAR, '-' LOS, replace(CONVERT(VARCHAR(11), a.DateOfBirth, 111), '/','-') as Date_of_birth,DATEDIFF(year,a.DateOfBirth,a.StartDate) as UMUR_THN, DATEDIFF(DAY,a.DateOfBirth,a.StartDate) as UMUR_HARI, '' AS BERAT_LAHIR, CASE WHEN a.Sex='P' THEN 'PEREMPUAN' WHEN a.Sex='L' THEN 'LAKI-LAKI' END  AS JENIS_KELAMIN,
            CASE WHEN ppx.Kondisi_pasien='1' THEN 'SEMBUH'   
             WHEN ppx.Kondisi_pasien='2' THEN 'MENINGGAL'
             WHEN ppx.Kondisi_pasien='5' THEN 'PULANG PAKSA'
             WHEN ppx.Kondisi_pasien='4' THEN 'DIRUJUK' 
             WHEN ppx.Kondisi_pasien='6' THEN 'MELARIKAN DIRI' 
             WHEN ppx.Kondisi_pasien='3' THEN 'LAIN-LAIN' END  AS STATUS_KELUAR,
             replace(CONVERT(VARCHAR(max),a.Diagnosa_Akhir),char(13)+char(10), '') as DIAGNOSA_EMR_DOKTER, replace(CONVERT(VARCHAR(max),a.Diagnosa_Akhir),char(13)+char(10), '') AS DIAGNOSA_UTAMA, '' AS DIAGNOSA_PROCEDURE, c.First_Name AS DOKTER_DPJP,a.BiayaPerawatan as BILLING 
             FROM DashboardData.dbo.dataRWI a
             LEFT join MasterdataSQL.dbo.Doctors c on c.ID = a.drPenerima
             outer apply
         (SELECT TOP 1 Kondisi_pasien,Diagnosa_Akhir
         from MedicalRecord.dbo.MR_Resume_Medis where No_Registrasi collate Latin1_General_CS_AS=a.NoRegistrasi collate Latin1_General_CS_AS ORDER BY 1 DESC )ppx
         WHERE replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') between :TglAwal and :TglAkhir

         UNION ALL

         SELECT a.NoMR  collate Latin1_General_CI_AS,a.NoRegistrasi  collate Latin1_General_CI_AS as NoRegRI,a.PatientName  collate Latin1_General_CI_AS
         ,a.TipePasien  collate Latin1_General_CI_AS as TypePatient,a.Address  collate Latin1_General_CI_AS,NamaJaminan  collate Latin1_General_CI_AS as NamaPerusahaan,
         'RAWAT JALAN' as JenisReg, 
         a.NamaUnit  collate Latin1_General_CI_AS as NAMA_RUANG_AWAL,a.NamaUnit  collate Latin1_General_CI_AS as NAMA_RUANG_AKHIR,'NON KELAS' as KELAS_PERAWATAN_AWAL,
         'NON KELAS' as KELAS_PERAWATAN_AKHIR,replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-')  collate Latin1_General_CI_AS as TGL_MASUK,
         replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-')  collate Latin1_General_CI_AS AS TGL_KELUAR, '-' LOS, 
         replace(CONVERT(VARCHAR(11), a.DateOfBirth, 111), '/','-')  as Date_of_birth,DATEDIFF(year,a.DateOfBirth,a.[Visit Date])  as UMUR_THN,
         DATEDIFF(DAY,a.DateOfBirth,a.[Visit Date])  as UMUR_HARI, '' AS BERAT_LAHIR, 
         CASE WHEN a.Sex='P' THEN 'PEREMPUAN' WHEN a.Sex='L' THEN 'LAKI-LAKI' END  AS JENIS_KELAMIN,
            CASE WHEN ppx.Kondisi_pasien='1' THEN 'SEMBUH'   
             WHEN ppx.Kondisi_pasien='2' THEN 'MENINGGAL'
             WHEN ppx.Kondisi_pasien='5' THEN 'PULANG PAKSA'
             WHEN ppx.Kondisi_pasien='4' THEN 'DIRUJUK' 
             WHEN ppx.Kondisi_pasien='6' THEN 'MELARIKAN DIRI' 
             WHEN ppx.Kondisi_pasien='3' THEN 'LAIN-LAIN' END  AS STATUS_KELUAR,
             replace(CONVERT(VARCHAR(max),a.Diagnosa_Akhir),char(13)+char(10), '') as DIAGNOSA_EMR_DOKTER, replace(CONVERT(VARCHAR(max),a.Diagnosa_Akhir),char(13)+char(10), '')  collate Latin1_General_CI_AS AS DIAGNOSA_UTAMA, '' AS DIAGNOSA_PROCEDURE,
             a.NamaDokter  collate Latin1_General_CI_AS AS DOKTER_DPJP,(isnull(cg.[Total Radiologi],0)+isnull(cg.TotalBHP,0)+isnull(cg.TotalLab,0)+isnull(cg.TotalObat,0)+isnull(cg.TotalVisit,0)) as BILLING
             FROM DashboardData.dbo.dataRWJ a
             outer apply
         (SELECT TOP 1 Kondisi_pasien,Diagnosa_Akhir
         from MedicalRecord.dbo.MR_Resume_Medis where No_Registrasi collate Latin1_General_CS_AS=a.NoRegistrasi collate Latin1_General_CS_AS ORDER BY 1 DESC )ppx
          inner join  PerawatanSQL.dbo.View_VisitExtnded cg on cg.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS
         WHERE replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :TglAwal2 and :TglAkhir2

            ");

            //     $this->db->query(" SELECT a.NoMR,a.NoRegRI,b.PatientName,d.TypePatient,b.Address ,op.NamaPerusahaan   AS NamaPerusahaan ,'RAWAT INAP' as JenisReg, ah2.RoomName AS NAMA_RUANG_AWAL, ah.RoomName AS NAMA_RUANG_AKHIR, ah2.Class as KELAS_PERAWATAN_AWAL,  ah.Class as KELAS_PERAWATAN_AKHIR, replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as TGL_MASUK,  replace(CONVERT(VARCHAR(11), a.EndDate, 111), '/','-') AS TGL_KELUAR,
            //     '-' LOS, replace(CONVERT(VARCHAR(11), b.Date_of_birth, 111), '/','-') as Date_of_birth,DATEDIFF(year,b.Date_of_birth,a.StartDate) as UMUR_THN,
            //     DATEDIFF(DAY,b.Date_of_birth,a.StartDate) as UMUR_HARI, '' AS BERAT_LAHIR, CASE WHEN b.Gander='P' THEN 'PEREMPUAN' WHEN B.Gander='L' THEN 'LAKI-LAKI' END  AS JENIS_KELAMIN
            //     ,
            //     CASE WHEN ppx.Kondisi_pasien='1' THEN 'SEMBUH'   
            //         WHEN ppx.Kondisi_pasien='2' THEN 'MENINGGAL'
            //         WHEN ppx.Kondisi_pasien='5' THEN 'PULANG PAKSA'
            //         WHEN ppx.Kondisi_pasien='4' THEN 'DIRUJUK' 
            //         WHEN ppx.Kondisi_pasien='6' THEN 'MELARIKAN DIRI' 
            //         WHEN ppx.Kondisi_pasien='3' THEN 'LAIN-LAIN' END  AS STATUS_KELUAR, 
            //     replace(CONVERT(VARCHAR(max),ppx.Diagnosa_Akhir),char(13)+char(10), '') as DIAGNOSA_EMR_DOKTER, '' AS DIAGNOSA_UTAMA, '' AS DIAGNOSA_PROCEDURE, c.First_Name AS DOKTER_DPJP,
            //     cg.TotalBiayaRawat as BILLING
            //          from RawatInapSQL.dbo.Inpatient a
            //     inner join MasterdataSQL.dbo.Admision b
            //     on a.NoMR = b.NoMR
            //     LEFT join MasterdataSQL.dbo.Doctors c
            //     on c.ID = a.drPenerima
            //     LEFT join MasterdataSQL.dbo.MstrTypePatient d
            //     on d.ID = a.TypePatient 
            //     left join MasterdataSQL.dbo.MstrPerusahaanAsuransi op on op.ID = a.IDAsuransi
            //     left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.StatusID
            //    -- left join MedicalRecord.dbo.MR_Resume_Medis ppx on ppx.No_Registrasi collate  Latin1_General_CS_AS = a.NoRegRI collate  Latin1_General_CS_AS
            //      outer apply
            //     (SELECT TOP 1 Kondisi_pasien,Diagnosa_Akhir
            //     from MedicalRecord.dbo.MR_Resume_Medis where No_Registrasi collate Latin1_General_CS_AS=a.NoRegRI collate Latin1_General_CS_AS ORDER BY 1 DESC )ppx
            //     left join RawatInapSQL.dbo.Inpatient_in_out ah on ah.ID = a.RoomID_Akhir
            //     left join RawatInapSQL.dbo.Inpatient_in_out ah2 on ah2.ID = a.RoomID_Awal
            //      outer apply
            //     (SELECT TOP 1 diagB.ICD_CODE,diagB.DESCRIPTION
            //     from MasterdataSQL.DBO.ICDX_Transactions diaga inner join MasterdataSQL.DBO.ICDX diagB ON diaga.ID_ICD = diagB.ID 
            //     where diaga.NoRegistrasi collate Latin1_General_CS_AS=a.NoRegRI collate Latin1_General_CS_AS and header='1' ORDER BY 1 DESC ) diag10
            //     inner join RawatInapSQL.dbo.View_ControlDP cg on a.NoRegRI=cg.NoRegRI
            //     where replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') between :TglAwal and :TglAkhir
            //     and d.TypePatient='ASURANSI'  
            //     UNION ALL
            //      select            a.NoMR,a.NoRegRI,b.PatientName,d.TypePatient,b.Address ,op.NamaPerusahaan   AS NamaPerusahaan ,'RAWAT INAP' as JenisReg, ah2.RoomName AS NAMA_RUANG_AWAL, ah.RoomName AS NAMA_RUANG_AKHIR, ah2.Class as KELAS_PERAWATAN_AWAL,  ah.Class as KELAS_PERAWATAN_AKHIR, replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as TGL_MASUK,  replace(CONVERT(VARCHAR(11), a.EndDate, 111), '/','-') AS TGL_KELUAR,
            //     '-' LOS, replace(CONVERT(VARCHAR(11), b.Date_of_birth, 111), '/','-') as Date_of_birth,DATEDIFF(year,b.Date_of_birth,a.StartDate) as UMUR_THN,
            //     DATEDIFF(DAY,b.Date_of_birth,a.StartDate) as UMUR_HARI, '' AS BERAT_LAHIR, CASE WHEN b.Gander='P' THEN 'PEREMPUAN' WHEN B.Gander='L' THEN 'LAKI-LAKI' END  AS JENIS_KELAMIN
            //     ,
            //     CASE WHEN ppx.Kondisi_pasien='1' THEN 'SEMBUH'   
            //         WHEN ppx.Kondisi_pasien='2' THEN 'MENINGGAL'
            //         WHEN ppx.Kondisi_pasien='5' THEN 'PULANG PAKSA'
            //         WHEN ppx.Kondisi_pasien='4' THEN 'DIRUJUK' 
            //         WHEN ppx.Kondisi_pasien='6' THEN 'MELARIKAN DIRI' 
            //         WHEN ppx.Kondisi_pasien='3' THEN 'LAIN-LAIN' END  AS STATUS_KELUAR, 
            //     replace(CONVERT(VARCHAR(max),ppx.Diagnosa_Akhir),char(13)+char(10), '') as DIAGNOSA_EMR_DOKTER, '' AS DIAGNOSA_UTAMA, '' AS DIAGNOSA_PROCEDURE, c.First_Name AS DOKTER_DPJP,
            //     cg.TotalBiayaRawat as BILLING
            //     from RawatInapSQL.dbo.Inpatient a
            //     inner join MasterdataSQL.dbo.Admision b
            //     on a.NoMR = b.NoMR
            //     left join MasterdataSQL.dbo.Doctors c
            //     on c.ID = a.drPenerima
            //     left join MasterdataSQL.dbo.MstrTypePatient d
            //     on d.ID = a.TypePatient 
            //     left join MasterdataSQL.dbo.MstrPerusahaanJPK op on op.ID = a.IDJPK
            //     left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.StatusID 
            //      outer apply
            //     (SELECT TOP 1 Kondisi_pasien,Diagnosa_Akhir
            //     from MedicalRecord.dbo.MR_Resume_Medis where No_Registrasi collate Latin1_General_CS_AS=a.NoRegRI collate Latin1_General_CS_AS ORDER BY 1 DESC )ppx
            //     left join RawatInapSQL.dbo.Inpatient_in_out ah on ah.ID = a.RoomID_Akhir
            //     left join RawatInapSQL.dbo.Inpatient_in_out ah2 on ah2.ID = a.RoomID_Awal
            //      outer apply
            //     (SELECT TOP 1 diagB.ICD_CODE,diagB.DESCRIPTION
            //     from MasterdataSQL.DBO.ICDX_Transactions diaga inner join MasterdataSQL.DBO.ICDX diagB ON diaga.ID_ICD = diagB.ID 
            //     where diaga.NoRegistrasi collate Latin1_General_CS_AS=a.NoRegRI collate Latin1_General_CS_AS and header='1' ORDER BY 1 DESC ) diag10
            //     inner join RawatInapSQL.dbo.View_ControlDP cg on a.NoRegRI=cg.NoRegRI
            //     where replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') between :TglAwal2 and :TglAkhir2
            //     and d.TypePatient<>'ASURANSI'  
            //     union all

            //     SELECT  a.NoMR,a.NoRegistrasi as NoRegRI,b.PatientName,d.TypePatient,b.Address ,op.NamaPerusahaan   AS NamaPerusahaan ,pg.Group_Jaminan as JenisReg, pg.NamaUnit AS NAMA_RUANG_AWAL,pg.NamaUnit AS NAMA_RUANG_AKHIR, 'NON KELAS' as KELAS_PERAWATAN_AWAL,  'NON KELAS'  as KELAS_PERAWATAN_AKHIR, replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as TGL_MASUK,  replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') AS TGL_KELUAR,
            //     '-' LOS, replace(CONVERT(VARCHAR(11), b.Date_of_birth, 111), '/','-') as Date_of_birth,DATEDIFF(year,b.Date_of_birth,a.TglKunjungan) as UMUR_THN,
            //     DATEDIFF(DAY,b.Date_of_birth,a.TglKunjungan) as UMUR_HARI, '' AS BERAT_LAHIR, CASE WHEN b.Gander='P' THEN 'PEREMPUAN' WHEN B.Gander='L' THEN 'LAKI-LAKI' END  AS JENIS_KELAMIN
            //     ,
            //     CASE WHEN ppx.Kondisi_pasien='1' THEN 'SEMBUH'   
            //         WHEN ppx.Kondisi_pasien='2' THEN 'MENINGGAL'
            //         WHEN ppx.Kondisi_pasien='5' THEN 'PULANG PAKSA'
            //         WHEN ppx.Kondisi_pasien='4' THEN 'DIRUJUK' 
            //         WHEN ppx.Kondisi_pasien='6' THEN 'MELARIKAN DIRI' 
            //         WHEN ppx.Kondisi_pasien='3' THEN 'LAIN-LAIN' END  AS STATUS_KELUAR, 
            //     replace(CONVERT(VARCHAR(max),kkl.A_Diagnosa),char(13)+char(10), '') as DIAGNOSA_EMR_DOKTER, '' AS DIAGNOSA_UTAMA, '' AS DIAGNOSA_PROCEDURE, c.First_Name AS DOKTER_DPJP,
            //     (isnull(cg.[Total Radiologi],0)+isnull(cg.TotalBHP,0)+isnull(cg.TotalLab,0)+isnull(cg.TotalObat,0)+isnull(cg.TotalVisit,0)) as BILLING
            //     from PerawatanSQL.dbo.Visit a
            //     inner join MasterdataSQL.dbo.Admision b
            //     on a.NoMR = b.NoMR
            //     inner join MasterdataSQL.dbo.Doctors c
            //     on c.ID = a.Doctor_1
            //     inner join MasterdataSQL.dbo.MstrTypePatient d
            //     on d.ID = a.PatientType 
            //     inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi op on op.ID = a.Asuransi
            //     inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
            //     left join MasterdataSQL.dbo.MstrCaraMasuk hh on hh.id = a.idCaraMasuk
            //     left join MasterdataSQL.dbo.MstrCaraMasuk_2 hj on hj.id = a.idCaraMasuk2
            //     left join PerawatanSQL.dbo.Tarif_RJ_UGD jk on jk.ID = a.idAdmin
            //     left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
            //     left join  PerawatanSQL.dbo.View_VisitExtnded cg on cg.NoRegistrasi = a.NoRegistrasi
            //     left join MedicalRecord.dbo.EMR_RWJ kkl on kkl.NoRegistrasi  collate  Latin1_General_CS_AS = a.NoRegistrasi  collate  Latin1_General_CS_AS 
            //     outer apply
            //     (SELECT NoRegistrasi,StatusHamil,Gravida,Para,Abortus,HPHT,HPL,UsiaKehamilan,CatatanKehamilan
            //     from MedicalRecord.dbo.EMR_RWJ_TTV where NoRegistrasi collate Latin1_General_CS_AS=a.NoRegistrasi collate Latin1_General_CS_AS and NamaUser is not null)ttv
            //      outer apply
            //     (SELECT TOP 1 Kondisi_pasien,Diagnosa_Akhir
            //     from MedicalRecord.dbo.MR_Resume_Medis where No_Registrasi collate Latin1_General_CS_AS=a.NoRegistrasi collate Latin1_General_CS_AS ORDER BY 1 DESC )ppx
            //     where kkl.YgMelapor is null and kkl.YgMelapor is null
            //     and replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') between :TglAwal3 and :TglAkhir3
            //     and a.Batal='0'     and d.TypePatient='ASURANSI' and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG')
            //     UNION ALL

            //      select  a.NoMR,a.NoRegistrasi as NoRegRI,b.PatientName,d.TypePatient,b.Address ,op.NamaPerusahaan   AS NamaPerusahaan ,pg.Group_Jaminan as JenisReg, pg.NamaUnit AS NAMA_RUANG_AWAL,pg.NamaUnit AS NAMA_RUANG_AKHIR, 'NON KELAS' as KELAS_PERAWATAN_AWAL,  'NON KELAS'  as KELAS_PERAWATAN_AKHIR, replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as TGL_MASUK,  replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') AS TGL_KELUAR,
            //     '-' LOS, replace(CONVERT(VARCHAR(11), b.Date_of_birth, 111), '/','-') as Date_of_birth,DATEDIFF(year,b.Date_of_birth,a.TglKunjungan) as UMUR_THN,
            //     DATEDIFF(DAY,b.Date_of_birth,a.TglKunjungan) as UMUR_HARI, '' AS BERAT_LAHIR, CASE WHEN b.Gander='P' THEN 'PEREMPUAN' WHEN B.Gander='L' THEN 'LAKI-LAKI' END  AS JENIS_KELAMIN
            //     ,
            //     CASE WHEN ppx.Kondisi_pasien='1' THEN 'SEMBUH'   
            //         WHEN ppx.Kondisi_pasien='2' THEN 'MENINGGAL'
            //         WHEN ppx.Kondisi_pasien='5' THEN 'PULANG PAKSA'
            //         WHEN ppx.Kondisi_pasien='4' THEN 'DIRUJUK' 
            //         WHEN ppx.Kondisi_pasien='6' THEN 'MELARIKAN DIRI' 
            //         WHEN ppx.Kondisi_pasien='3' THEN 'LAIN-LAIN' END  AS STATUS_KELUAR, 
            //     replace(CONVERT(VARCHAR(max),kkl.A_Diagnosa),char(13)+char(10), '') as DIAGNOSA_EMR_DOKTER, '' AS DIAGNOSA_UTAMA, '' AS DIAGNOSA_PROCEDURE, c.First_Name AS DOKTER_DPJP,
            //     (isnull(cg.[Total Radiologi],0)+isnull(cg.TotalBHP,0)+isnull(cg.TotalLab,0)+isnull(cg.TotalObat,0)+isnull(cg.TotalVisit,0)) as BILLING
            //     from PerawatanSQL.dbo.Visit a
            //     inner join MasterdataSQL.dbo.Admision b
            //     on a.NoMR = b.NoMR
            //     inner join MasterdataSQL.dbo.Doctors c
            //     on c.ID = a.Doctor_1
            //     inner join MasterdataSQL.dbo.MstrTypePatient d
            //     on d.ID = a.PatientType 
            //     inner join MasterdataSQL.dbo.MstrPerusahaanJPK op on op.ID = a.Perusahaan
            //     inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
            //     left join MasterdataSQL.dbo.MstrCaraMasuk hh on hh.id = a.idCaraMasuk
            //     left join MasterdataSQL.dbo.MstrCaraMasuk_2 hj on hj.id = a.idCaraMasuk2
            //     left join PerawatanSQL.dbo.Tarif_RJ_UGD jk on jk.ID = a.idAdmin
            //     left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
            //     left join  PerawatanSQL.dbo.View_VisitExtnded cg on cg.NoRegistrasi = a.NoRegistrasi
            //     left join MedicalRecord.dbo.EMR_RWJ kkl on kkl.NoRegistrasi  collate  Latin1_General_CS_AS = a.NoRegistrasi  collate  Latin1_General_CS_AS 
            //     outer apply
            //     (SELECT NoRegistrasi,StatusHamil,Gravida,Para,Abortus,HPHT,HPL,UsiaKehamilan,CatatanKehamilan
            //     from MedicalRecord.dbo.EMR_RWJ_TTV where NoRegistrasi collate Latin1_General_CS_AS=a.NoRegistrasi collate Latin1_General_CS_AS and NamaUser is not null)ttv
            //      outer apply
            //     (SELECT TOP 1 Kondisi_pasien,Diagnosa_Akhir
            //     from MedicalRecord.dbo.MR_Resume_Medis where No_Registrasi collate Latin1_General_CS_AS=a.NoRegistrasi collate Latin1_General_CS_AS ORDER BY 1 DESC )ppx
            //     where kkl.YgMelapor is null and kkl.YgMelapor is null
            //     and replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') between :TglAwal4 and :TglAkhir4
            //     and a.Batal='0'   and d.TypePatient<>'ASURANSI'   and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG')
            //     ORDER BY OP.NamaPerusahaan ASC
            //      "); 
            $this->db->bind('TglAwal', $tglawal);
            $this->db->bind('TglAkhir', $tglakhir);
            $this->db->bind('TglAwal2', $tglawal);
            $this->db->bind('TglAkhir2', $tglakhir);
            //  $this->db->bind('TglAwal3', $tglawal); 
            //  $this->db->bind('TglAkhir3', $tglakhir); 
            //  $this->db->bind('TglAwal4', $tglawal); 
            //  $this->db->bind('TglAkhir4', $tglakhir); 
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['NoRegistrasi'] = $key['NoRegRI'];
                $pasing['PatientName'] = $key['PatientName'];
                $pasing['TypePatient'] = $key['TypePatient'];

                $pasing['Address'] = $key['Address'];
                $pasing['NamaPerusahaan'] = $key['NamaPerusahaan'];
                $pasing['JenisReg'] = $key['JenisReg'];
                $pasing['NAMA_RUANG_AWAL'] = $key['NAMA_RUANG_AWAL'];

                $pasing['NAMA_RUANG_AKHIR'] = $key['NAMA_RUANG_AKHIR'];
                $pasing['KELAS_PERAWATAN_AWAL'] = $key['KELAS_PERAWATAN_AWAL'];
                $pasing['KELAS_PERAWATAN_AKHIR'] = $key['KELAS_PERAWATAN_AKHIR'];
                $pasing['TGL_MASUK'] = date('d/m/Y', strtotime($key['TGL_MASUK']));

                $pasing['TGL_KELUAR'] = date('d/m/Y', strtotime($key['TGL_KELUAR']));
                $pasing['LOS'] = $key['LOS'];
                $pasing['Date_of_birth'] = date('d/m/Y', strtotime($key['Date_of_birth']));
                $pasing['UMUR_THN'] = $key['UMUR_THN'];

                $pasing['UMUR_HARI'] = $key['UMUR_HARI'];
                $pasing['BERAT_LAHIR'] = $key['BERAT_LAHIR'];
                $pasing['JENIS_KELAMIN'] = $key['JENIS_KELAMIN'];
                $pasing['STATUS_KELUAR'] = $key['STATUS_KELUAR'];

                $pasing['DIAGNOSA_EMR_DOKTER'] = $key['DIAGNOSA_EMR_DOKTER'];
                $pasing['DIAGNOSA_UTAMA'] = $key['DIAGNOSA_UTAMA'];
                $pasing['DIAGNOSA_PROCEDURE'] = $key['DIAGNOSA_PROCEDURE'];
                $pasing['DOKTER_DPJP'] = $key['DOKTER_DPJP'];
                $pasing['BILLING'] = $key['BILLING'];
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

            $this->db->query("SELECT a.NoMR,a.NoRegistrasi as NoRegRI,a.PatientName,a.TipePasien as TypePatient,a.Address,NamaJaminan as NamaPerusahaan,'RAWAT INAP' as JenisReg, RoomName_Awal as NAMA_RUANG_AWAL,RoomName_Akhir as NAMA_RUANG_AKHIR,KelasName_Awal as KELAS_PERAWATAN_AWAL,KelasName_Akhir as KELAS_PERAWATAN_AKHIR,replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as TGL_MASUK,replace(CONVERT(VARCHAR(11), a.EndDate, 111), '/','-') AS TGL_KELUAR, '-' LOS, replace(CONVERT(VARCHAR(11), a.DateOfBirth, 111), '/','-') as Date_of_birth,DATEDIFF(year,a.DateOfBirth,a.StartDate) as UMUR_THN, DATEDIFF(DAY,a.DateOfBirth,a.StartDate) as UMUR_HARI, '' AS BERAT_LAHIR, CASE WHEN a.Sex='P' THEN 'PEREMPUAN' WHEN a.Sex='L' THEN 'LAKI-LAKI' END  AS JENIS_KELAMIN,
            CASE WHEN ppx.Kondisi_pasien='1' THEN 'SEMBUH'   
             WHEN ppx.Kondisi_pasien='2' THEN 'MENINGGAL'
             WHEN ppx.Kondisi_pasien='5' THEN 'PULANG PAKSA'
             WHEN ppx.Kondisi_pasien='4' THEN 'DIRUJUK' 
             WHEN ppx.Kondisi_pasien='6' THEN 'MELARIKAN DIRI' 
             WHEN ppx.Kondisi_pasien='3' THEN 'LAIN-LAIN' END  AS STATUS_KELUAR,
             replace(CONVERT(VARCHAR(max),a.Diagnosa_Akhir),char(13)+char(10), '') as DIAGNOSA_EMR_DOKTER, replace(CONVERT(VARCHAR(max),a.Diagnosa_Akhir),char(13)+char(10), '') AS DIAGNOSA_UTAMA, '' AS DIAGNOSA_PROCEDURE, c.First_Name AS DOKTER_DPJP,a.BiayaPerawatan as BILLING 
             FROM DashboardData.dbo.dataRWI a
             LEFT join MasterdataSQL.dbo.Doctors c on c.ID = a.drPenerima
             outer apply
         (SELECT TOP 1 Kondisi_pasien,Diagnosa_Akhir
         from MedicalRecord.dbo.MR_Resume_Medis where No_Registrasi collate Latin1_General_CS_AS=a.NoRegistrasi collate Latin1_General_CS_AS ORDER BY 1 DESC )ppx
         WHERE replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') between :TglAwal and :TglAkhir

         UNION ALL

         SELECT a.NoMR  collate Latin1_General_CI_AS,a.NoRegistrasi  collate Latin1_General_CI_AS as NoRegRI,a.PatientName  collate Latin1_General_CI_AS
         ,a.TipePasien  collate Latin1_General_CI_AS as TypePatient,a.Address  collate Latin1_General_CI_AS,NamaJaminan  collate Latin1_General_CI_AS as NamaPerusahaan,
         'RAWAT JALAN' as JenisReg, 
         a.NamaUnit  collate Latin1_General_CI_AS as NAMA_RUANG_AWAL,a.NamaUnit  collate Latin1_General_CI_AS as NAMA_RUANG_AKHIR,'NON KELAS' as KELAS_PERAWATAN_AWAL,
         'NON KELAS' as KELAS_PERAWATAN_AKHIR,replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-')  collate Latin1_General_CI_AS as TGL_MASUK,
         replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-')  collate Latin1_General_CI_AS AS TGL_KELUAR, '-' LOS, 
         replace(CONVERT(VARCHAR(11), a.DateOfBirth, 111), '/','-')  as Date_of_birth,DATEDIFF(year,a.DateOfBirth,a.[Visit Date])  as UMUR_THN,
         DATEDIFF(DAY,a.DateOfBirth,a.[Visit Date])  as UMUR_HARI, '' AS BERAT_LAHIR, 
         CASE WHEN a.Sex='P' THEN 'PEREMPUAN' WHEN a.Sex='L' THEN 'LAKI-LAKI' END  AS JENIS_KELAMIN,
            CASE WHEN ppx.Kondisi_pasien='1' THEN 'SEMBUH'   
             WHEN ppx.Kondisi_pasien='2' THEN 'MENINGGAL'
             WHEN ppx.Kondisi_pasien='5' THEN 'PULANG PAKSA'
             WHEN ppx.Kondisi_pasien='4' THEN 'DIRUJUK' 
             WHEN ppx.Kondisi_pasien='6' THEN 'MELARIKAN DIRI' 
             WHEN ppx.Kondisi_pasien='3' THEN 'LAIN-LAIN' END  AS STATUS_KELUAR,
             replace(CONVERT(VARCHAR(max),a.Diagnosa_Akhir),char(13)+char(10), '') as DIAGNOSA_EMR_DOKTER, replace(CONVERT(VARCHAR(max),a.Diagnosa_Akhir),char(13)+char(10), '')  collate Latin1_General_CI_AS AS DIAGNOSA_UTAMA, '' AS DIAGNOSA_PROCEDURE,
             a.NamaDokter  collate Latin1_General_CI_AS AS DOKTER_DPJP,(isnull(cg.[Total Radiologi],0)+isnull(cg.TotalBHP,0)+isnull(cg.TotalLab,0)+isnull(cg.TotalObat,0)+isnull(cg.TotalVisit,0)) as BILLING
             FROM DashboardData.dbo.dataRWJ a
             outer apply
         (SELECT TOP 1 Kondisi_pasien,Diagnosa_Akhir
         from MedicalRecord.dbo.MR_Resume_Medis where No_Registrasi collate Latin1_General_CS_AS=a.NoRegistrasi collate Latin1_General_CS_AS ORDER BY 1 DESC )ppx
          inner join  PerawatanSQL.dbo.View_VisitExtnded cg on cg.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS
         WHERE replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :TglAwal2 and :TglAkhir2

            ");
            $this->db->bind('TglAwal', $tglawal);
            $this->db->bind('TglAkhir', $tglakhir);
            $this->db->bind('TglAwal2', $tglawal);
            $this->db->bind('TglAkhir2', $tglakhir);

            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {

                $this->db->query("SELECT NoRegistrasi, sum(TotalBill) as total
                from DashboardData.dbo.DataPendapatanRWI
                where NoRegistrasi=:NoRegistrasi
                group by NoRegistrasi");
                $this->db->bind('NoRegistrasi', $key['NoRegRI']);
                $totalbill =  $this->db->single();
                $dataTotalbill = $totalbill['total'];


                $pasing['NoMR'] = $key['NoMR'];
                $pasing['NoRegistrasi'] = $key['NoRegRI'];
                $pasing['PatientName'] = $key['PatientName'];
                $pasing['TypePatient'] = $key['TypePatient'];

                $pasing['Address'] = $key['Address'];
                $pasing['NamaPerusahaan'] = $key['NamaPerusahaan'];
                $pasing['JenisReg'] = $key['JenisReg'];
                $pasing['NAMA_RUANG_AWAL'] = $key['NAMA_RUANG_AWAL'];

                $pasing['NAMA_RUANG_AKHIR'] = $key['NAMA_RUANG_AKHIR'];
                $pasing['KELAS_PERAWATAN_AWAL'] = $key['KELAS_PERAWATAN_AWAL'];
                $pasing['KELAS_PERAWATAN_AKHIR'] = $key['KELAS_PERAWATAN_AKHIR'];
                $pasing['TGL_MASUK'] = date('d/m/Y', strtotime($key['TGL_MASUK']));

                $pasing['TGL_KELUAR'] = date('d/m/Y', strtotime($key['TGL_KELUAR']));
                $pasing['LOS'] = $key['LOS'];
                $pasing['Date_of_birth'] = date('d/m/Y', strtotime($key['Date_of_birth']));
                $pasing['UMUR_THN'] = $key['UMUR_THN'];

                $pasing['UMUR_HARI'] = $key['UMUR_HARI'];
                $pasing['BERAT_LAHIR'] = $key['BERAT_LAHIR'];
                $pasing['JENIS_KELAMIN'] = $key['JENIS_KELAMIN'];
                $pasing['STATUS_KELUAR'] = $key['STATUS_KELUAR'];

                $pasing['DIAGNOSA_EMR_DOKTER'] = $key['DIAGNOSA_EMR_DOKTER'];
                $pasing['DIAGNOSA_UTAMA'] = $key['DIAGNOSA_UTAMA'];
                $pasing['DIAGNOSA_PROCEDURE'] = $key['DIAGNOSA_PROCEDURE'];
                $pasing['DOKTER_DPJP'] = $key['DOKTER_DPJP'];
                $pasing['BILLING'] = $key['BILLING'];
                $rows[] = $pasing;
            }
            return $data;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function printShowDataLMA($data)
    {
        try {
            $this->db->query("SELECT a.*,b.PatientName,b.Address,
            case when b.Gander = 'P' then 'Perempuan' else 'Laki-laki' end as gender,
            case when a.Isolasi is null then '-' else a.Isolasi end as isolasix,
            case when a.JenisRawat is null then '-' else a.Jenisrawat end as jenisrawat, 
            case when a.DokterPemeriksa is null then '-' else a.DokterPemeriksa end as DokterPemeriksa,
            case when a.DokterDPJP is null then '-' else a.DokterDPJP end as DokterDPJP,
            case when a.Keterangan is null then '-' else a.Keterangan end as Keterangan,
            replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as tgllahir,
            replace(CONVERT(VARCHAR(11), Tglmasuk, 111), '/','-') as tglmasuk 
            from MedicalRecord.dbo.MR_PermintaanRawat a
                  inner join MasterDataSQL.dbo.Admision b 
                  on a.NoMR collate Latin1_General_CS_AS=b.NoMR collate Latin1_General_CS_AS 
                  WHERE a.Id=:idspr ");
            $this->db->bind('idspr', $data['notrs']);
            $data =  $this->db->single();
            $pasing['PatientName'] = $data['PatientName'];
            //Identitas Pasien
            $pasing['PatientName'] = $data['PatientName'];
            $pasing['NoMR'] = $data['NoMR'];
            $pasing['alamat'] = $data['Address'];
            $pasing['tgllahir'] = date('d/m/Y', strtotime($data['tgllahir']));
            $pasing['gender'] = $data['gender'];

            //tbl MR_PermintaanRawat
            $pasing['jenisrawat'] = $data['jenisrawat'];
            $pasing['dr_pemeriksa'] = $data['DokterPemeriksa'];
            $pasing['Isolasi'] = $data['isolasix'];
            $pasing['dpjp'] = $data['DokterDPJP'];
            if ($data['tglmasuk'] == null) {
                $pasing['tglmasuk'] = '-';
            } else {
                $pasing['tglmasuk'] = date('d/m/Y', strtotime($data['tglmasuk']));
            }
            $pasing['keterangan'] = $data['Keterangan'];
            $pasing['keluhanutama'] = $data['KeluhanUtama'];
            $pasing['tglmulaikeluhan'] = $data['TglMulaiKeluhan'];
            $pasing['IndikasiRawat'] = $data['IndikasiRawat'];
            $pasing['RiwayatPenyakitDulu'] = $data['RiwayatPenyakitDulu'];
            $pasing['TTV'] = $data['TTV'];
            $pasing['PemeriksaanFisik'] = $data['PemeriksaanFisik'];
            $pasing['PemeriksaanPenunjang'] = $data['PemeriksaanPenunjang'];
            $pasing['DiagnosaAwal'] = $data['DiagnosaAwal'];
            $pasing['DiagnosaRawatSama'] = $data['DiagnosaRawatSama'];
            $pasing['TglDiagnosaSama'] = $data['TglDiagnosaSama'];
            $pasing['Dimana'] = $data['Dimana'];

            $pasing['RadangUsus12Jari'] = $data['RadangUsus12Jari'];
            $pasing['BawaanLahir'] = $data['BawaanLahir'];
            $pasing['TukakLambung'] = $data['TukakLambung'];
            $pasing['KomplikasiHamil'] = $data['KomplikasiHamil'];
            $pasing['Kejiwaan'] = $data['Kejiwaan'];
            $pasing['SaluranProduksi'] = $data['SaluranProduksi'];
            $pasing['PenyakitJantung'] = $data['PenyakitJantung'];
            $pasing['KB'] = $data['KB'];
            $pasing['Tumor'] = $data['Tumor'];
            $pasing['Hepatitis'] = $data['Hepatitis'];

            $pasing['DarahTinggi'] = $data['DarahTinggi'];
            $pasing['TulangBelakang'] = $data['TulangBelakang'];
            $pasing['DM'] = $data['DM'];
            $pasing['Gigi'] = $data['Gigi'];
            $pasing['Tuberculosis'] = $data['Tuberculosis'];
            $pasing['Hormonal'] = $data['Hormonal'];
            $pasing['BatuGinjal'] = $data['BatuGinjal'];
            $pasing['Geriatri'] = $data['Geriatri'];

            $pasing['BatuEmpedu'] = $data['BatuEmpedu'];
            $pasing['Alkoholisme'] = $data['Alkoholisme'];
            $pasing['KelainanDarah'] = $data['KelainanDarah'];
            $pasing['KLL'] = $data['KLL'];
            $pasing['Tonsil'] = $data['Tonsil'];
            $pasing['Tentamen'] = $data['Tentamen'];
            $pasing['Sinus'] = $data['Sinus'];
            $pasing['STDH'] = $data['STDH'];

            $pasing['Telinga'] = $data['Telinga'];
            $pasing['Kosmetik'] = $data['Kosmetik'];
            $pasing['Asthma'] = $data['Asthma'];
            $pasing['Appendiks'] = $data['Appendiks'];
            $pasing['TerapiSaatini'] = $data['TerapiSaatini'];
            $pasing['MedicalSpesialistik'] = $data['MedicalSpesialistik'];

            $pasing['LamaRawat'] = $data['LamaRawat'];
            $pasing['Operasi1'] = $data['Operasi1'];
            $pasing['Operasi2'] = $data['Operasi2'];
            $pasing['JenisAnastesi'] = $data['JenisAnastesi'];
            $pasing['StatusPembedahan'] = $data['StatusPembedahan'];
            $pasing['JumlahSayatan'] = $data['JumlahSayatan'];
            if ($data['JadwalBedah'] == null) {
                $jadwabedahx = $data['JadwalBedah'];
            } else {
                $jadwabedahx =  date('d/m/Y', strtotime($data['JadwalBedah']));
            }
            $pasing['JadwalBedah'] = $jadwabedahx;

            $pasing['Kecelakaan'] = $data['Kecelakaan'];
            $pasing['TglKecelakaan'] = $data['TglKecelakaan'];
            $pasing['JamKecelakaan'] = $data['JamKecelakaan'];
            $pasing['SebabKecelakaan'] = $data['SebabKecelakaan'];
            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDataPasien($data)
    {
        try {
            // var_dump($data);
            // exit;
            $tglawal = $data['TglAwal'];
            $tglakhir = $data['TglAkhir'];
            $jenisinfo = $data['jenisinfo']; //pasien apa

            if ($jenisinfo == '1') {
                $query = "SELECT  mrn,EPISODE_NUMBER,a.NOREGISTRASI,ORDER_DATE,PATIENT_NAME,b.NamaJaminan , SCHEDULED_PROC_DESC,Tarif,IsVerifikasi
            from RadiologiSQL.dbo.WO_RADIOLOGY a
            left join DashboardData.dbo.dataRWJ b on a.NOREGISTRASI = b.NoRegistrasi
            where  SCHEDULED_PROC_DESC like '%cbct%' and a.Batal='0'  
            and replace(CONVERT(VARCHAR(11), ORDER_DATE, 111), '/','-') between :tglawal and :tglakhir
            UNION ALL
            select mrn,EPISODE_NUMBER,a.NOREGISTRASI,ORDER_DATE,PATIENT_NAME,b.NamaJaminan, SCHEDULED_PROC_DESC,Tarif,IsVerifikasi
            from RadiologiSQL.dbo.WO_RADIOLOGY a
            left join DashboardData.dbo.dataRWJ b on a.NOREGISTRASI = b.NoRegistrasi
            where  SCHEDULED_PROC_DESC like '%cephalometry%' and a.Batal='0'
            and replace(CONVERT(VARCHAR(11), ORDER_DATE, 111), '/','-') between :tglawal1 and :tglakhir1
            UNION ALL
            select mrn,EPISODE_NUMBER,a.NOREGISTRASI,ORDER_DATE,PATIENT_NAME,b.NamaJaminan, SCHEDULED_PROC_DESC,Tarif,IsVerifikasi
            from RadiologiSQL.dbo.WO_RADIOLOGY a
            left join DashboardData.dbo.dataRWJ b on a.NOREGISTRASI = b.NoRegistrasi
            where  SCHEDULED_PROC_DESC like '%panoramic%' and a.Batal='0'
             and replace(CONVERT(VARCHAR(11), ORDER_DATE, 111), '/','-') between :tglawal2 and :tglakhir2
            UNION ALL
            select mrn,EPISODE_NUMBER,a.NOREGISTRASI,ORDER_DATE,PATIENT_NAME,b.NamaJaminan, SCHEDULED_PROC_DESC,Tarif,IsVerifikasi
            from RadiologiSQL.dbo.WO_RADIOLOGY a
            left join DashboardData.dbo.dataRWJ b on a.NOREGISTRASI = b.NoRegistrasi
            where  SCHEDULED_PROC_DESC like '%periaprichal%' and a.Batal='0'
            and replace(CONVERT(VARCHAR(11), ORDER_DATE, 111), '/','-') between :tglawal3 and :tglakhir3
            UNION ALL
            select mrn,EPISODE_NUMBER,a.NOREGISTRASI,ORDER_DATE,PATIENT_NAME,b.NamaJaminan, SCHEDULED_PROC_DESC,Tarif,IsVerifikasi
            from RadiologiSQL.dbo.WO_RADIOLOGY a
            left join DashboardData.dbo.dataRWJ b on a.NOREGISTRASI = b.NoRegistrasi
            where  SCHEDULED_PROC_DESC like '%tmj%' and a.Batal='0'
            and replace(CONVERT(VARCHAR(11), ORDER_DATE, 111), '/','-') between :tglawal4 and :tglakhir4
                        
                ";
                $this->db->query($query);
                $this->db->bind('tglawal', $tglawal);
                $this->db->bind('tglakhir', $tglakhir);
                $this->db->bind('tglawal1', $tglawal);
                $this->db->bind('tglakhir1', $tglakhir);
                $this->db->bind('tglawal2', $tglawal);
                $this->db->bind('tglakhir2', $tglakhir);
                $this->db->bind('tglawal3', $tglawal);
                $this->db->bind('tglakhir3', $tglakhir);
                $this->db->bind('tglawal4', $tglawal);
                $this->db->bind('tglakhir4', $tglakhir);
                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['mrn'] = $row['mrn'];
                    $pasing['EPISODE_NUMBER'] = $row['EPISODE_NUMBER'];
                    $pasing['NOREGISTRASI'] = $row['NOREGISTRASI'];
                    $pasing['ORDER_DATE'] = $row['ORDER_DATE'];
                    $pasing['PATIENT_NAME'] = $row['PATIENT_NAME'];
                    $pasing['NamaJaminan'] = $row['NamaJaminan'];
                    $pasing['SCHEDULED_PROC_DESC'] = $row['SCHEDULED_PROC_DESC'];
                    $pasing['Tarif'] = $row['Tarif'];
                    $pasing['IsVerifikasi'] = $row['IsVerifikasi'];
                    $rows[] = $pasing;
                }
            } elseif ($jenisinfo == '2') {

                $query = "SELECT  mrn,EPISODE_NUMBER,a.NOREGISTRASI,ORDER_DATE,PATIENT_NAME,b.NamaJaminan , SCHEDULED_PROC_DESC,Tarif,IsVerifikasi
            from RadiologiSQL.dbo.WO_RADIOLOGY a
            left join DashboardData.dbo.dataRWI b on a.NOREGISTRASI = b.NoRegistrasi
            where  SCHEDULED_PROC_DESC like '%cbct%' and a.Batal='0'  
            and replace(CONVERT(VARCHAR(11), ORDER_DATE, 111), '/','-') between :tglawal and :tglakhir
            UNION ALL
            select mrn,EPISODE_NUMBER,a.NOREGISTRASI,ORDER_DATE,PATIENT_NAME,b.NamaJaminan, SCHEDULED_PROC_DESC,Tarif,IsVerifikasi
            from RadiologiSQL.dbo.WO_RADIOLOGY a
            left join DashboardData.dbo.dataRWI b on a.NOREGISTRASI = b.NoRegistrasi
            where  SCHEDULED_PROC_DESC like '%cephalometry%' and a.Batal='0'
            and replace(CONVERT(VARCHAR(11), ORDER_DATE, 111), '/','-') between :tglawal1 and :tglakhir1
            UNION ALL
            select mrn,EPISODE_NUMBER,a.NOREGISTRASI,ORDER_DATE,PATIENT_NAME,b.NamaJaminan, SCHEDULED_PROC_DESC,Tarif,IsVerifikasi
            from RadiologiSQL.dbo.WO_RADIOLOGY a
            left join DashboardData.dbo.dataRWI b on a.NOREGISTRASI = b.NoRegistrasi
            where  SCHEDULED_PROC_DESC like '%panoramic%' and a.Batal='0'
             and replace(CONVERT(VARCHAR(11), ORDER_DATE, 111), '/','-') between :tglawal2 and :tglakhir2
            UNION ALL
            select mrn,EPISODE_NUMBER,a.NOREGISTRASI,ORDER_DATE,PATIENT_NAME,b.NamaJaminan, SCHEDULED_PROC_DESC,Tarif,IsVerifikasi
            from RadiologiSQL.dbo.WO_RADIOLOGY a
            left join DashboardData.dbo.dataRWI b on a.NOREGISTRASI = b.NoRegistrasi
            where  SCHEDULED_PROC_DESC like '%periaprichal%' and a.Batal='0'
            and replace(CONVERT(VARCHAR(11), ORDER_DATE, 111), '/','-') between :tglawal3 and :tglakhir3
            UNION ALL
            select mrn,EPISODE_NUMBER,a.NOREGISTRASI,ORDER_DATE,PATIENT_NAME,b.NamaJaminan, SCHEDULED_PROC_DESC,Tarif,IsVerifikasi
            from RadiologiSQL.dbo.WO_RADIOLOGY a
            left join DashboardData.dbo.dataRWI b on a.NOREGISTRASI = b.NoRegistrasi
            where  SCHEDULED_PROC_DESC like '%tmj%' and a.Batal='0'
            and replace(CONVERT(VARCHAR(11), ORDER_DATE, 111), '/','-') between :tglawal4 and :tglakhir4
                                    
                            ";
                $this->db->query($query);
                $this->db->bind('tglawal', $tglawal);
                $this->db->bind('tglakhir', $tglakhir);
                $this->db->bind('tglawal1', $tglawal);
                $this->db->bind('tglakhir1', $tglakhir);
                $this->db->bind('tglawal2', $tglawal);
                $this->db->bind('tglakhir2', $tglakhir);
                $this->db->bind('tglawal3', $tglawal);
                $this->db->bind('tglakhir3', $tglakhir);
                $this->db->bind('tglawal4', $tglawal);
                $this->db->bind('tglakhir4', $tglakhir);
                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['mrn'] = $row['mrn'];
                    $pasing['EPISODE_NUMBER'] = $row['EPISODE_NUMBER'];
                    $pasing['NOREGISTRASI'] = $row['NOREGISTRASI'];
                    $pasing['ORDER_DATE'] = $row['ORDER_DATE'];
                    $pasing['PATIENT_NAME'] = $row['PATIENT_NAME'];
                    $pasing['NamaJaminan'] = $row['NamaJaminan'];
                    $pasing['SCHEDULED_PROC_DESC'] = $row['SCHEDULED_PROC_DESC'];
                    $pasing['Tarif'] = $row['Tarif'];
                    $pasing['IsVerifikasi'] = $row['IsVerifikasi'];
                    $rows[] = $pasing;
                }
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}