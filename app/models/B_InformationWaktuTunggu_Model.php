<?php
class  B_InformationWaktuTunggu_Model
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
            $this->db->query("SELECT 
            a.NoMR,
            case 
            when replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') > replace(CONVERT(VARCHAR(11), e.InputDate, 111), '/','-')
            then 'Lama'  ELSE 'Baru'
            end as 'JenisPasien',
            a.NoRegistrasi,e.PatientName,d.NamaUnit,f.First_Name as NamaDokter,g.TypePatient as JenisJaminan,
            case when a.PatientType='2' then b.NamaPerusahaan
            else c.NamaPerusahaan end as NamaJaminan,hh.NamaCaraMasuk,
            replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as TglDaftar,CONVERT(VARCHAR(8),a.TglKunjungan,108) as JamDaftar,
            replace(CONVERT(VARCHAR(11), gg.Tgl, 111), '/','-') as TglAssesmentPerawat,CONVERT(VARCHAR(8),gg.Tgl,108) as JamAssesmentPerawat,
            replace(CONVERT(VARCHAR(11), gm.tgldokter, 111), '/','-') as TglAssesmentDokter,CONVERT(VARCHAR(8),gm.tgldokter,108) as JamAssesmentDokter
            from PerawatanSQL.dbo.Visit a
            left join MasterdataSQL.dbo.MstrPerusahaanAsuransi b on a.Asuransi=b.ID
            left join MasterdataSQL.dbo.MstrPerusahaanJPK c on a.Perusahaan=c.ID
            inner join MasterdataSQL.dbo.MstrUnitPerwatan d on a.Unit=d.ID
            inner join MasterdataSQL.dbo.Admision e on a.NoMR=e.NoMR
            inner join MasterdataSQL.dbo.Doctors f on a.Doctor_1=f.ID
            inner join MasterdataSQL.dbo.MstrTypePatient g on a.PatientType=g.ID
            left join MasterdataSQL.dbo.MstrCaraMasuk hh on hh.id = a.idCaraMasuk
            outer apply 
            (select top 1 Tgl from MedicalRecord.dbo.EMR_RWJ_TTV where NoRegistrasi collate SQL_Latin1_General_CP1_CI_AS=a.NoRegistrasi collate SQL_Latin1_General_CP1_CI_AS)
            gg
            outer apply 
            (select top 1 Tgl as tgldokter from MedicalRecord.dbo.EMR_RWJ where NoRegistrasi collate SQL_Latin1_General_CP1_CI_AS=a.NoRegistrasi collate SQL_Latin1_General_CP1_CI_AS
            and GroupUser='Dokter' and Batal='0' and Hapus='0')
            gm
            where a.Batal='0' and replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') between :TglAwal and :TglAkhir and
            d.grup_instalasi='RAWAT JALAN' and d.ID not in ('17','47','53')
            order by a.TglKunjungan,JamDaftar asc
             ");
            $this->db->bind('TglAwal', $tglawal);
            $this->db->bind('TglAkhir', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['JenisPasien'] = $key['JenisPasien'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['PatientName'] = $key['PatientName'];
                $pasing['NamaUnit'] = $key['NamaUnit'];
                $pasing['NamaDokter'] = $key['NamaDokter'];
                $pasing['JenisJaminan'] = $key['JenisJaminan'];
                $pasing['NamaJaminan'] = $key['NamaJaminan'];
                $pasing['NamaCaraMasuk'] = $key['NamaCaraMasuk'];
                $pasing['TglDaftar'] = $key['TglDaftar'];
                $pasing['JamDaftar'] = $key['JamDaftar'];
                $pasing['TglAssesmentPerawat'] = $key['TglAssesmentPerawat'];
                $pasing['JamAssesmentPerawat'] = $key['JamAssesmentPerawat'];
                $pasing['TglAssesmentDokter'] = $key['TglAssesmentDokter'];
                $pasing['JamAssesmentDokter'] = $key['JamAssesmentDokter'];
                $rows[] = $pasing;
            }
            return $data;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataListPasien_Ranap($data)
    {
        try {
            $tglawal = $data['TglAwal'];
            $tglakhir = $data['TglAkhir'];
            $this->db->query("SELECT a.NoMR,a.NoRegRI,c.PatientName,
            b.NamaUser,b.GroupUser,
            --b.S_Anamnesa,b.O_PemeriksaanFisik,b.A_Diagnosa,b.P_InstruksiNonMedis,b.P_RencanaTatalaksana,
            replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as TglMasuk,
            CONVERT(VARCHAR(8),a.startTime,108) as  JamMasuk,
            replace(CONVERT(VARCHAR(11), b.Tgl, 111), '/','-') as TglCPPT,
            CONVERT(VARCHAR(8),b.Tgl,108) as JamCPPT
            from RawatInapSQL.dbo.Inpatient a
            inner join MasterdataSQL.dbo.Doctors x on a.drPenerima=x.ID
            outer apply (
            SELECT * FROM MedicalRecord.dbo.EMR_RWJ where a.NoRegRI collate SQL_Latin1_General_CP1_CI_AS=NoRegistrasi collate SQL_Latin1_General_CP1_CI_AS
            and GroupUser='Dokter' and Batal='0' and Hapus='0' and NamaUser collate SQL_Latin1_General_CP1_CI_AS=x.First_Name collate SQL_Latin1_General_CP1_CI_AS
            )b
            inner join MasterdataSQL.dbo.Admision c on a.NoMR=c.NoMR
            where replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') between :TglAwal and :TglAkhir
            order by TglMasuk,JamMasuk,TglCPPT asc
             ");
            $this->db->bind('TglAwal', $tglawal);
            $this->db->bind('TglAkhir', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['NoRegistrasi'] = $key['NoRegRI'];
                $pasing['PatientName'] = $key['PatientName'];
                $pasing['NamaUser'] = $key['NamaUser'];
                $pasing['GroupUser'] = $key['GroupUser'];
                // $pasing['S_Anamnesa'] = $key['S_Anamnesa']; 
                // $pasing['O_PemeriksaanFisik'] = $key['O_PemeriksaanFisik']; 
                // $pasing['A_Diagnosa'] = $key['A_Diagnosa']; 
                // $pasing['P_InstruksiNonMedis'] = $key['P_InstruksiNonMedis'];  
                // $pasing['P_RencanaTatalaksana'] = $key['P_RencanaTatalaksana'];  
                $pasing['TglMasuk'] = $key['TglMasuk'];
                $pasing['JamMasuk'] = $key['JamMasuk'];
                $pasing['TglCPPT'] = $key['TglCPPT'];
                $pasing['JamCPPT'] = $key['JamCPPT'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataListPasien_Ranap1($data)
    {
        try {
            $tglawal = $data['TglAwal'];
            $tglakhir = $data['TglAkhir'];
            $this->db->query("SELECT a.NoMR,a.NoRegRI,c.PatientName,
            b.NamaUser,b.GroupUser,
            --b.S_Anamnesa,b.O_PemeriksaanFisik,b.A_Diagnosa,b.P_InstruksiNonMedis,b.P_RencanaTatalaksana,
            replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as TglMasuk,
            CONVERT(VARCHAR(8),a.startTime,108) as  JamMasuk,
            replace(CONVERT(VARCHAR(11), b.Tgl, 111), '/','-') as TglCPPT,
            CONVERT(VARCHAR(8),b.Tgl,108) as JamCPPT
            from RawatInapSQL.dbo.Inpatient a
            inner join MasterdataSQL.dbo.Doctors x on a.drPenerima=x.ID
            outer apply (
            SELECT * FROM MedicalRecord.dbo.EMR_RWJ where a.NoRegRI collate SQL_Latin1_General_CP1_CI_AS=NoRegistrasi collate SQL_Latin1_General_CP1_CI_AS
            and GroupUser='Dokter' and Batal='0' and Hapus='0' and NamaUser collate SQL_Latin1_General_CP1_CI_AS=x.First_Name collate SQL_Latin1_General_CP1_CI_AS
            )b
            inner join MasterdataSQL.dbo.Admision c on a.NoMR=c.NoMR
            where replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') between :TglAwal and :TglAkhir
            order by TglMasuk,JamMasuk,TglCPPT asc
             ");
            $this->db->bind('TglAwal', $tglawal);
            $this->db->bind('TglAkhir', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['NoRegistrasi'] = $key['NoRegRI'];
                $pasing['PatientName'] = $key['PatientName'];
                $pasing['NamaUser'] = $key['NamaUser'];
                $pasing['GroupUser'] = $key['GroupUser'];
                // $pasing['S_Anamnesa'] = $key['S_Anamnesa']; 
                // $pasing['O_PemeriksaanFisik'] = $key['O_PemeriksaanFisik']; 
                // $pasing['A_Diagnosa'] = $key['A_Diagnosa']; 
                // $pasing['P_InstruksiNonMedis'] = $key['P_InstruksiNonMedis'];  
                // $pasing['P_RencanaTatalaksana'] = $key['P_RencanaTatalaksana'];  
                $pasing['TglMasuk'] = $key['TglMasuk'];
                $pasing['JamMasuk'] = $key['JamMasuk'];
                $pasing['TglCPPT'] = $key['TglCPPT'];
                $pasing['JamCPPT'] = $key['JamCPPT'];
                $rows[] = $pasing;
            }
            return $data;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
