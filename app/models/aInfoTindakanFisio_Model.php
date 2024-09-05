<?php
class aInfoTindakanFisio_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }


    //data list sesus filter
    public function getDataListInfoTindakanFisio($data)
    {
        // var_dump($data);
        //     exit;
        try {
            $tglawal = $data['TglAwal'];
            $tglakhir = $data['TglAkhir'];

            $this->db->query("SELECT b.NoMR,b.NoEpisode,b.NoRegistrasi,
            b.PatientName,a.NamaDokter,a.Tanggal
            ,a.Tanggal as Jam,'' as Kelas,
            a.NamaProduct,a.Quantity,a.Tarif,a.TotalTarif, a.UserInput,c.NamaPerusahaan as NamaJaminan
            FROM PerawatanSQL.DBO.[Visit Details] a
            inner join DashboardData.dbo.dataRWJ b on a.NoRegistrasi = b.NoRegistrasi
            inner join MasterdataSQL.dbo.MstrPerusahaanJPK c
                on c.ID  = b.KodeJaminan
            
            where ProductID in (
                select ID
                from PerawatanSQL.dbo.Tarif_RJ_UGD 
                where CodeUNIT in ('UNIT14','UNIT49') 
                and CategoryProduct='Tindakan Fisioteraphy'
            ) and replace(CONVERT(VARCHAR(11), Tanggal, 111), '/','-') between :tglawal and :tglakhir
            and b.TipePasien<>'2'
            union all
            SELECT b.NoMR,b.NoEpisode,b.NoRegistrasi,
            b.PatientName,a.NamaDokter,a.Tanggal
            ,a.Tanggal as Jam,'' as Kelas,
            a.NamaProduct,a.Quantity,a.Tarif,a.TotalTarif, a.UserInput,c.NamaPerusahaan as NamaJaminan
            FROM PerawatanSQL.DBO.[Visit Details] a
            inner join DashboardData.dbo.dataRWJ b on a.NoRegistrasi = b.NoRegistrasi
            inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi c
                on c.ID  = b.KodeJaminan
            
            where ProductID in (
                select ID
                from PerawatanSQL.dbo.Tarif_RJ_UGD 
                where CodeUNIT in ('UNIT14','UNIT49') 
                and CategoryProduct='Tindakan Fisioteraphy'
            ) and replace(CONVERT(VARCHAR(11), Tanggal, 111), '/','-') between :tglawal2 and :tglakhir2
            and b.TipePasien='2'
            UNION ALL
            SELECT b.NoMR,b.NoEpisode,b.NoRegistrasi,b.PatientName,a.NamaDokter,a.VisitDate  as tanggal,
            a.JamPemeriksaan as Jam,a.Kelas,
            a.NamaTindakan,a.Quantity,a.[Unit Price] as Tarif,a.TotalTarif as TotalTarif,a.PetugasOrder,c.NamaPerusahaan as NamaJaminan
                FROM RawatInapSQL.dbo.[Inpatient Details] a
                inner join DashboardData.dbo.dataRWI b
                on a.NoRegRI = b.NoRegistrasi
                left join MasterdataSQL.dbo.MstrPerusahaanJPK c
                on c.ID  = b.KodeJaminan
                where [Product ID] in (
                select ID 
                from RawatInapSQL.dbo.Tarif_RI 
                where CategoryProduct='Tindakan Fisioteraphy' 
            ) and replace(CONVERT(VARCHAR(11), VisitDate, 111), '/','-') between :tglawal3 and :tglakhir3
            and b.TipePasien<>'2'
            union all
            SELECT b.NoMR,b.NoEpisode,b.NoRegistrasi,b.PatientName,a.NamaDokter,a.VisitDate  as tanggal,
            a.JamPemeriksaan as Jam,a.Kelas,
            a.NamaTindakan,a.Quantity,a.[Unit Price] as Tarif,a.TotalTarif as TotalTarif,a.PetugasOrder,c.NamaPerusahaan as NamaJaminan
                FROM RawatInapSQL.dbo.[Inpatient Details] a
                inner join DashboardData.dbo.dataRWI b
                on a.NoRegRI = b.NoRegistrasi
                inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi c
                on c.ID  = b.KodeJaminan
                where [Product ID] in (
                select ID 
                from RawatInapSQL.dbo.Tarif_RI 
                where CategoryProduct='Tindakan Fisioteraphy'
            ) and replace(CONVERT(VARCHAR(11), VisitDate, 111), '/','-') between :tglawal4 and :tglakhir4
            and b.TipePasien='2'
             order by Tanggal asc, NoRegistrasi asc");


            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $this->db->bind('tglawal2', $tglawal);
            $this->db->bind('tglakhir2', $tglakhir);
            $this->db->bind('tglawal3', $tglawal);
            $this->db->bind('tglakhir3', $tglakhir);
            $this->db->bind('tglawal4', $tglawal);
            $this->db->bind('tglakhir4', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();


            foreach ($data as $key) {
                //PerawatanSQL.DBO.[Visit Details]
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['NoEpisode'] = $key['NoEpisode'];
                $pasing['PatientName'] = $key['PatientName'];
                $pasing['NamaDokter'] = $key['NamaDokter'];
                $pasing['Tanggal'] = $key['Tanggal'];
                $pasing['Jam'] = $key['Jam'];
                $pasing['Kelas'] = $key['Kelas'];
                $pasing['NamaProduct'] = $key['NamaProduct'];
                $pasing['Quantity'] = $key['Quantity'];
                $pasing['Tarif'] = $key['Tarif'];
                $pasing['TotalTarif'] = $key['TotalTarif'];
                $pasing['UserInput'] = $key['UserInput'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['NamaJaminan'] = $key['NamaJaminan'];
                //PerawatanSQL.dbo.Tarif_RJ_UGD
                //$pasing['ID'] = $key['ID'];
                // $pasing['CodeUNIT'] = $key['CodeUNIT'];
                //$pasing['CategoryProduct'] = $key['CategoryProduct'];
                //RawatInapSQL.dbo.[Inpatient Details]
                // $pasing['VisitDate'] = $key['VisitDate'];
                //$pasing['JamPemeriksaan'] = $key['JamPemeriksaan'];
                //$pasing['NamaTindakan'] = $key['NamaTindakan'];
                //$pasing['[Unit Price]'] = $key['[Unit Price]'];
                //$pasing['PetugasOrder'] = $key['PetugasOrder'];
                //DashboardData.dbo.dataRWI b
                //$pasing['NoRegRI'] = $key['NoRegRI'];
                //RawatInapSQL.dbo.Tarif_RI 
                //$pasing['[Product ID]'] = $key['[Product ID]'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataListInfoTindakanFisio1($data)
    {
        // var_dump($data);
        //     exit;
        try {
            $tglawal = $data['TglAwal'];
            $tglakhir = $data['TglAkhir'];

            $this->db->query("SELECT b.NoMR,b.NoEpisode,b.NoRegistrasi,
            b.PatientName,a.NamaDokter,a.Tanggal
            ,a.Tanggal as Jam,'' as Kelas,
            a.NamaProduct,a.Quantity,a.Tarif,a.TotalTarif, a.UserInput,c.NamaPerusahaan as NamaJaminan
            FROM PerawatanSQL.DBO.[Visit Details] a
            inner join DashboardData.dbo.dataRWJ b on a.NoRegistrasi = b.NoRegistrasi
            inner join MasterdataSQL.dbo.MstrPerusahaanJPK c
                on c.ID  = b.KodeJaminan
            
            where ProductID in (
                select ID
                from PerawatanSQL.dbo.Tarif_RJ_UGD 
                where CodeUNIT in ('UNIT14','UNIT49') 
                and CategoryProduct='Tindakan Fisioteraphy'
            ) and replace(CONVERT(VARCHAR(11), Tanggal, 111), '/','-') between :tglawal and :tglakhir
            and b.TipePasien<>'2'
            union all
            SELECT b.NoMR,b.NoEpisode,b.NoRegistrasi,
            b.PatientName,a.NamaDokter,a.Tanggal
            ,a.Tanggal as Jam,'' as Kelas,
            a.NamaProduct,a.Quantity,a.Tarif,a.TotalTarif, a.UserInput,c.NamaPerusahaan as NamaJaminan
            FROM PerawatanSQL.DBO.[Visit Details] a
            inner join DashboardData.dbo.dataRWJ b on a.NoRegistrasi = b.NoRegistrasi
            inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi c
                on c.ID  = b.KodeJaminan
            
            where ProductID in (
                select ID
                from PerawatanSQL.dbo.Tarif_RJ_UGD 
                where CodeUNIT in ('UNIT14','UNIT49') 
                and CategoryProduct='Tindakan Fisioteraphy'
            ) and replace(CONVERT(VARCHAR(11), Tanggal, 111), '/','-') between :tglawal2 and :tglakhir2
            and b.TipePasien='2'
            UNION ALL
            SELECT b.NoMR,b.NoEpisode,b.NoRegistrasi,b.PatientName,a.NamaDokter,a.VisitDate  as tanggal,
            a.JamPemeriksaan as Jam,a.Kelas,
            a.NamaTindakan,a.Quantity,a.[Unit Price] as Tarif,a.TotalTarif as TotalTarif,a.PetugasOrder,c.NamaPerusahaan as NamaJaminan
                FROM RawatInapSQL.dbo.[Inpatient Details] a
                inner join DashboardData.dbo.dataRWI b
                on a.NoRegRI = b.NoRegistrasi
                left join MasterdataSQL.dbo.MstrPerusahaanJPK c
                on c.ID  = b.KodeJaminan
                where [Product ID] in (
                select ID 
                from RawatInapSQL.dbo.Tarif_RI 
                where CategoryProduct='Tindakan Fisioteraphy' 
            ) and replace(CONVERT(VARCHAR(11), VisitDate, 111), '/','-') between :tglawal3 and :tglakhir3
            and b.TipePasien<>'2'
            union all
            SELECT b.NoMR,b.NoEpisode,b.NoRegistrasi,b.PatientName,a.NamaDokter,a.VisitDate  as tanggal,
            a.JamPemeriksaan as Jam,a.Kelas,
            a.NamaTindakan,a.Quantity,a.[Unit Price] as Tarif,a.TotalTarif as TotalTarif,a.PetugasOrder,c.NamaPerusahaan as NamaJaminan
                FROM RawatInapSQL.dbo.[Inpatient Details] a
                inner join DashboardData.dbo.dataRWI b
                on a.NoRegRI = b.NoRegistrasi
                inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi c
                on c.ID  = b.KodeJaminan
                where [Product ID] in (
                select ID 
                from RawatInapSQL.dbo.Tarif_RI 
                where CategoryProduct='Tindakan Fisioteraphy'
            ) and replace(CONVERT(VARCHAR(11), VisitDate, 111), '/','-') between :tglawal4 and :tglakhir4
            and b.TipePasien='2'
             order by Tanggal asc, NoRegistrasi asc");


            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $this->db->bind('tglawal2', $tglawal);
            $this->db->bind('tglakhir2', $tglakhir);
            $this->db->bind('tglawal3', $tglawal);
            $this->db->bind('tglakhir3', $tglakhir);
            $this->db->bind('tglawal4', $tglawal);
            $this->db->bind('tglakhir4', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();


            foreach ($data as $key) {
                //PerawatanSQL.DBO.[Visit Details]
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['NoEpisode'] = $key['NoEpisode'];
                $pasing['PatientName'] = $key['PatientName'];
                $pasing['NamaDokter'] = $key['NamaDokter'];
                $pasing['Tanggal'] = $key['Tanggal'];
                $pasing['Jam'] = $key['Jam'];
                $pasing['Kelas'] = $key['Kelas'];
                $pasing['NamaProduct'] = $key['NamaProduct'];
                $pasing['Quantity'] = $key['Quantity'];
                $pasing['Tarif'] = $key['Tarif'];
                $pasing['TotalTarif'] = $key['TotalTarif'];
                $pasing['UserInput'] = $key['UserInput'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['NamaJaminan'] = $key['NamaJaminan'];
                //PerawatanSQL.dbo.Tarif_RJ_UGD
                //$pasing['ID'] = $key['ID'];
                // $pasing['CodeUNIT'] = $key['CodeUNIT'];
                //$pasing['CategoryProduct'] = $key['CategoryProduct'];
                //RawatInapSQL.dbo.[Inpatient Details]
                // $pasing['VisitDate'] = $key['VisitDate'];
                //$pasing['JamPemeriksaan'] = $key['JamPemeriksaan'];
                //$pasing['NamaTindakan'] = $key['NamaTindakan'];
                //$pasing['[Unit Price]'] = $key['[Unit Price]'];
                //$pasing['PetugasOrder'] = $key['PetugasOrder'];
                //DashboardData.dbo.dataRWI b
                //$pasing['NoRegRI'] = $key['NoRegRI'];
                //RawatInapSQL.dbo.Tarif_RI 
                //$pasing['[Product ID]'] = $key['[Product ID]'];

                $rows[] = $pasing;
            }
            return $data;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
