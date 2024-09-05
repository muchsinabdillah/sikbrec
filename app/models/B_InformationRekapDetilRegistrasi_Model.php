<?php
class  B_InformationRekapDetilRegistrasi_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getDataListRekap($data)
    {
        try {
            $Periode = $data['Periode'];
            $JenisPasien = $data['JenisPasien'];
            $JenisRekap = $data['JenisRekap'];

            // var_dump($data);
            if ($JenisPasien == '1' && $JenisRekap == '1') {
                //             $query = "SELECT First_Name as NamaDokter,
                //         isnull([01],0) as satu,
                //         isnull([02],0) as dua,
                //         isnull([03],0) as tiga,
                //         isnull([04],0) as empat,
                //         isnull([05],0) as lima,
                //         isnull([06],0) as enam,
                //         isnull([07],0) as Jtujuh,
                //         isnull([08],0) as delapan,
                //         isnull([09],0) as sembilan,
                //         isnull([10],0) as sepuluh,
                //         isnull([11],0) as sebelah,
                //         isnull([12],0) as duabelas,
                //         isnull([13],0) as tigabelas,
                // 		isnull([14],0) as empatbelas,
                //         isnull([15],0) as limabelas,
                //         isnull([16],0) as enambelas,
                //         isnull([17],0) as tujuhbelas,
                // 		isnull([18],0) as delapanbelas,
                //         isnull([19],0) as sembilanbelas,
                //         isnull([20],0) as duapuluh,
                //         isnull([21],0) as duapuluhsatu,
                // 		isnull([22],0) as duapuluhdua,
                //         isnull([23],0) as duapuluhtiga,
                //         isnull([24],0) as duapuluhempat,
                //         isnull([25],0) as duapuluhlima,
                // 		isnull([26],0) as duapuluhenam,
                //         isnull([27],0) as duapuluhtujuh,
                //         isnull([28],0) as duapuluhdelapan,
                //         isnull([29],0) as duapuluhlsembilan,
                // 		isnull([30],0) as tigapuluh,
                //         isnull([31],0) as tigapuluhsatu,
                //         (isnull([01],0)+
                //         isnull([02],0)+
                //         isnull([03],0)+
                //         isnull([04],0)+
                //         isnull([05],0)+
                //         isnull([06],0)+
                //         isnull([07],0)+
                //         isnull([08],0)+
                //         isnull([09],0)+
                //         isnull([10],0)+
                //         isnull([11],0)+
                //         isnull([12],0)+
                // 		isnull([13],0)+
                //         isnull([14],0)+
                //         isnull([15],0)+
                //         isnull([16],0)+
                //         isnull([17],0)+
                //         isnull([18],0)+
                //         isnull([19],0)+
                //         isnull([20],0)+
                //         isnull([21],0)+
                //         isnull([22],0)+
                //         isnull([23],0)+
                //         isnull([24],0)+
                // 		isnull([25],0)+
                //         isnull([26],0)+
                //         isnull([27],0)+
                //         isnull([28],0)+
                //         isnull([29],0)+
                //         isnull([30],0)+
                //         isnull([31],0)
                //     )
                //          as TOTAL
                // FROM (
                //      select  c.First_Name,
                //      SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2) [Quarter],
                //     count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                //     from PerawatanSQL.dbo.Visit a
                //     inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                //     inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                //     inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                //     inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                //     left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                //     where SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),1,7)=:Periode
                //     and a.Batal='0'   and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG') 
                //     AND PG.ID<>'53' 
                //     and pg.id not in ('9','10','47','48','49','52','17','1','53')
                //     group by c.First_Name,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2)

                // ) AS QuarterlyData
                // PIVOT( SUM([REGISTRASI Count])   
                //         FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
                //           [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
                //           [25],[26],[27],[28],[29],[30],[31], 
                //         [grandtotal])) AS QPivot";

                $query = "SELECT First_Name as NamaDokter,
            isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
			isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
			isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
			isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
			isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
			isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
			isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
			isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0)
        )
             as TOTAL
    FROM (
         select a.NamaDokter as First_Name,
         SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
        count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
        from DashboardData.dbo.dataRWJ a
        where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
        and a.IdUnit not in ('9','10','47','48','49','52','17','1','53')
        group by a.NamaDokter,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
         
    ) AS QuarterlyData
    PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31], 
            [grandtotal])) AS QPivot";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } else  if ($JenisPasien == '6' && $JenisRekap == '1') {
                //             $query = "SELECT First_Name as NamaDokter,
                //         isnull([01],0) as satu,
                //         isnull([02],0) as dua,
                //         isnull([03],0) as tiga,
                //         isnull([04],0) as empat,
                //         isnull([05],0) as lima,
                //         isnull([06],0) as enam,
                //         isnull([07],0) as Jtujuh,
                //         isnull([08],0) as delapan,
                //         isnull([09],0) as sembilan,
                //         isnull([10],0) as sepuluh,
                //         isnull([11],0) as sebelah,
                //         isnull([12],0) as duabelas,
                //         isnull([13],0) as tigabelas,
                // 		isnull([14],0) as empatbelas,
                //         isnull([15],0) as limabelas,
                //         isnull([16],0) as enambelas,
                //         isnull([17],0) as tujuhbelas,
                // 		isnull([18],0) as delapanbelas,
                //         isnull([19],0) as sembilanbelas,
                //         isnull([20],0) as duapuluh,
                //         isnull([21],0) as duapuluhsatu,
                // 		isnull([22],0) as duapuluhdua,
                //         isnull([23],0) as duapuluhtiga,
                //         isnull([24],0) as duapuluhempat,
                //         isnull([25],0) as duapuluhlima,
                // 		isnull([26],0) as duapuluhenam,
                //         isnull([27],0) as duapuluhtujuh,
                //         isnull([28],0) as duapuluhdelapan,
                //         isnull([29],0) as duapuluhlsembilan,
                // 		isnull([30],0) as tigapuluh,
                //         isnull([31],0) as tigapuluhsatu,
                //         (isnull([01],0)+
                //         isnull([02],0)+
                //         isnull([03],0)+
                //         isnull([04],0)+
                //         isnull([05],0)+
                //         isnull([06],0)+
                //         isnull([07],0)+
                //         isnull([08],0)+
                //         isnull([09],0)+
                //         isnull([10],0)+
                //         isnull([11],0)+
                //         isnull([12],0)+
                // 		isnull([13],0)+
                //         isnull([14],0)+
                //         isnull([15],0)+
                //         isnull([16],0)+
                //         isnull([17],0)+
                //         isnull([18],0)+
                //         isnull([19],0)+
                //         isnull([20],0)+
                //         isnull([21],0)+
                //         isnull([22],0)+
                //         isnull([23],0)+
                //         isnull([24],0)+
                // 		isnull([25],0)+
                //         isnull([26],0)+
                //         isnull([27],0)+
                //         isnull([28],0)+
                //         isnull([29],0)+
                //         isnull([30],0)+
                //         isnull([31],0))
                //          as TOTAL
                // FROM (
                //      select  c.First_Name,
                //      SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2) [Quarter],
                //     count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                //     from PerawatanSQL.dbo.Visit a
                //     inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                //     inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                //     inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                //     inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                //     left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                //     where SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),1,7)=:Periode
                //     and a.Batal='0'    
                //     and pg.id   in ('47')
                //     group by c.First_Name,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2)

                // ) AS QuarterlyData
                // PIVOT( SUM([REGISTRASI Count])   
                //         FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
                //           [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
                //           [25],[26],[27],[28],[29],[30],[31],
                //         [grandtotal])) AS QPivot";

                $query = "SELECT First_Name as NamaDokter,
            isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
			isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
			isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
			isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
			isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
			isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
			isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
			isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0)
        )
             as TOTAL
    FROM (
         select a.NamaDokter as First_Name,
         SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
        count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
        from DashboardData.dbo.dataRWJ a
        where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
        and a.IdUnit in ('47')
        group by a.NamaDokter,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
         
    ) AS QuarterlyData
    PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31], 
            [grandtotal])) AS QPivot";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } else  if ($JenisPasien == '7' && $JenisRekap == '1') {
                //             $query = "SELECT First_Name as NamaDokter,
                //         isnull([01],0) as satu,
                //         isnull([02],0) as dua,
                //         isnull([03],0) as tiga,
                //         isnull([04],0) as empat,
                //         isnull([05],0) as lima,
                //         isnull([06],0) as enam,
                //         isnull([07],0) as Jtujuh,
                //         isnull([08],0) as delapan,
                //         isnull([09],0) as sembilan,
                //         isnull([10],0) as sepuluh,
                //         isnull([11],0) as sebelah,
                //         isnull([12],0) as duabelas,
                //         isnull([13],0) as tigabelas,
                // 		isnull([14],0) as empatbelas,
                //         isnull([15],0) as limabelas,
                //         isnull([16],0) as enambelas,
                //         isnull([17],0) as tujuhbelas,
                // 		isnull([18],0) as delapanbelas,
                //         isnull([19],0) as sembilanbelas,
                //         isnull([20],0) as duapuluh,
                //         isnull([21],0) as duapuluhsatu,
                // 		isnull([22],0) as duapuluhdua,
                //         isnull([23],0) as duapuluhtiga,
                //         isnull([24],0) as duapuluhempat,
                //         isnull([25],0) as duapuluhlima,
                // 		isnull([26],0) as duapuluhenam,
                //         isnull([27],0) as duapuluhtujuh,
                //         isnull([28],0) as duapuluhdelapan,
                //         isnull([29],0) as duapuluhlsembilan,
                // 		isnull([30],0) as tigapuluh,
                //         isnull([31],0) as tigapuluhsatu,
                //         (isnull([01],0)+
                //         isnull([02],0)+
                //         isnull([03],0)+
                //         isnull([04],0)+
                //         isnull([05],0)+
                //         isnull([06],0)+
                //         isnull([07],0)+
                //         isnull([08],0)+
                //         isnull([09],0)+
                //         isnull([10],0)+
                //         isnull([11],0)+
                //         isnull([12],0)+
                // 		isnull([13],0)+
                //         isnull([14],0)+
                //         isnull([15],0)+
                //         isnull([16],0)+
                //         isnull([17],0)+
                //         isnull([18],0)+
                //         isnull([19],0)+
                //         isnull([20],0)+
                //         isnull([21],0)+
                //         isnull([22],0)+
                //         isnull([23],0)+
                //         isnull([24],0)+
                // 		isnull([25],0)+
                //         isnull([26],0)+
                //         isnull([27],0)+
                //         isnull([28],0)+
                //         isnull([29],0)+
                //         isnull([30],0)+
                //         isnull([31],0))
                //          as TOTAL
                // FROM (
                //      select  c.First_Name,
                //      SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2) [Quarter],
                //     count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                //     from PerawatanSQL.dbo.Visit a
                //     inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                //     inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                //     inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                //     inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                //     left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                //     where SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),1,7)=:Periode
                //      and a.Batal='0'  
                //    and pg.id  in ('9','10','48','49','52','17')
                //     group by c.First_Name,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2)

                // ) AS QuarterlyData
                // PIVOT( SUM([REGISTRASI Count])   
                //         FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
                //           [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
                //           [25],[26],[27],[28],[29],[30],[31],
                //         [grandtotal])) AS QPivot";

                $query = "SELECT First_Name as NamaDokter,
            isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
			isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
			isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
			isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
			isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
			isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
			isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
			isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0)
        )
             as TOTAL
    FROM (
         select a.NamaDokter as First_Name,
         SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
        count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
        from DashboardData.dbo.dataRWJ a
        where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
        and a.IdUnit in ('9','10','48','49','52','17')
        group by a.NamaDokter,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
         
    ) AS QuarterlyData
    PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31], 
            [grandtotal])) AS QPivot";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '2' && $JenisRekap == '1') {
                $query = "SELECT First_Name as NamaDokter,
            isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
			isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
			isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
			isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
			isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
			isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
			isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
			isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0)
        )
             as TOTAL
    FROM (
         select a.NamaDokter as First_Name,
         SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
        count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
        from DashboardData.dbo.dataRWJ a
        where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
        and a.IdUnit = '1'
        group by a.NamaDokter,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
         
    ) AS QuarterlyData
    PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31], 
            [grandtotal])) AS QPivot";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '3' && $JenisRekap == '1') {
                $query = "SELECT First_Name as NamaDokter,
            isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
			isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
			isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
			isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
			isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
			isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
			isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
			isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0)
        )
             as TOTAL
    FROM (
         select a.NamaDokter as First_Name,
         SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
        count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
        from DashboardData.dbo.dataRWJ a
        where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
        and a.IdUnit in '53'
        group by a.NamaDokter,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
         
    ) AS QuarterlyData
    PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31], 
            [grandtotal])) AS QPivot";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '4' && $JenisRekap == '1') {
                $query = "SELECT JenisRawat,First_Name as NamaDokter,
                isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
			isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
			isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
			isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
			isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
			isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
			isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
			isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0))
                 as TOTAL
                      FROM (
                           select  a.JenisRawat,c.First_Name,
                           SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),6,2) [Quarter],
                          count(isnull(a.drPenerima,0)) as  [REGISTRASI Count]
                          from RawatInapSQL.dbo.Inpatient a
                          inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                          inner join MasterdataSQL.dbo.Doctors c on c.ID = a.drPenerima
                          where YEAR(a.StartDate)=:Periode 
                          group by a.JenisRawat,c.First_Name,SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),6,2)
                           
                      ) AS QuarterlyData
                      PIVOT( SUM([REGISTRASI Count])   
                              FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31],
                              [grandtotal])) AS QPivot
                              order by JenisRawat asc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '5' && $JenisRekap == '1') {
                $query = "SELECT GroupSpesialis,DrOperator as NamaDokter,
                isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
			isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
			isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
			isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
			isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
			isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
			isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
			isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0))
                 as TOTAL
                      FROM (
                           select  d.GroupSpesialis,d.DrOperator,
                           SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),6,2) [Quarter],
                          count(isnull(a.drPenerima,0)) as  [REGISTRASI Count]
                          from RawatInapSQL.dbo.Inpatient a
                          inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
              inner join MedicalRecord.dbo.EMR_OrderOperasi d on a.NoRegRI  collate SQL_Latin1_General_CP1_CI_AS=d.NoRegistrasi  collate SQL_Latin1_General_CP1_CI_AS
                          where YEAR(a.StartDate)=:Periode and d.StatusOrder='Approved OT' 
                          group by d.GroupSpesialis,d.DrOperator,SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),6,2)
                           
                      ) AS QuarterlyData
                      PIVOT( SUM([REGISTRASI Count])   
                              FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31],
                              [grandtotal])) AS QPivot
                              order by GroupSpesialis asc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '1' && $JenisRekap == '3') {
                //     $query = "SELECT NamaCaraMasukRef as NamaRujukan,NamaUnit,First_Name as NamaDokter,
                //     isnull([01],0) as satu,
                // isnull([02],0) as dua,
                // isnull([03],0) as tiga,
                // isnull([04],0) as empat,
                // isnull([05],0) as lima,
                // isnull([06],0) as enam,
                // isnull([07],0) as Jtujuh,
                // isnull([08],0) as delapan,
                // isnull([09],0) as sembilan,
                // isnull([10],0) as sepuluh,
                // isnull([11],0) as sebelah,
                // isnull([12],0) as duabelas,
                // isnull([13],0) as tigabelas,
                // isnull([14],0) as empatbelas,
                // isnull([15],0) as limabelas,
                // isnull([16],0) as enambelas,
                // isnull([17],0) as tujuhbelas,
                // isnull([18],0) as delapanbelas,
                // isnull([19],0) as sembilanbelas,
                // isnull([20],0) as duapuluh,
                // isnull([21],0) as duapuluhsatu,
                // isnull([22],0) as duapuluhdua,
                // isnull([23],0) as duapuluhtiga,
                // isnull([24],0) as duapuluhempat,
                // isnull([25],0) as duapuluhlima,
                // isnull([26],0) as duapuluhenam,
                // isnull([27],0) as duapuluhtujuh,
                // isnull([28],0) as duapuluhdelapan,
                // isnull([29],0) as duapuluhlsembilan,
                // isnull([30],0) as tigapuluh,
                // isnull([31],0) as tigapuluhsatu,
                // (isnull([01],0)+
                // isnull([02],0)+
                // isnull([03],0)+
                // isnull([04],0)+
                // isnull([05],0)+
                // isnull([06],0)+
                // isnull([07],0)+
                // isnull([08],0)+
                // isnull([09],0)+
                // isnull([10],0)+
                // isnull([11],0)+
                // isnull([12],0)+
                // isnull([13],0)+
                // isnull([14],0)+
                // isnull([15],0)+
                // isnull([16],0)+
                // isnull([17],0)+
                // isnull([18],0)+
                // isnull([19],0)+
                // isnull([20],0)+
                // isnull([21],0)+
                // isnull([22],0)+
                // isnull([23],0)+
                // isnull([24],0)+
                // isnull([25],0)+
                // isnull([26],0)+
                // isnull([27],0)+
                // isnull([28],0)+
                // isnull([29],0)+
                // isnull([30],0)+
                // isnull([31],0))
                //      as TOTAL
                //           FROM (
                //                select  f.NamaCaraMasukRef,pg.NamaUnit, c.First_Name,
                //                SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2) [Quarter],
                //               count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                //               from PerawatanSQL.dbo.Visit a
                //               inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                //               inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                //               inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                //               inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                //   --inner join MasterdataSQL.dbo.MstrCaraMasuk e on a.idCaraMasuk=e.id
                //   inner join MasterdataSQL.dbo.MstrCaraMasuk_2 f on a.idCaraMasuk2=f.id
                //               left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                //               where SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),1,7)=:Periode
                //               and a.Batal='0'    and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG')  
                //               and pg.id not in  ('9','10','47','48','49','52','17','1','52','53')
                //               group by f.NamaCaraMasukRef,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2),pg.NamaUnit, c.First_Name

                //           ) AS QuarterlyData
                //           PIVOT( SUM([REGISTRASI Count])   
                //                   FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
                //   [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
                //   [25],[26],[27],[28],[29],[30],[31],
                //                   [grandtotal])) AS QPivot
                //                   order by NamaCaraMasukRef asc";

                $query = "SELECT NamaCaraMasukRef as NamaRujukan,NamaUnit,NamaDokter,
            isnull([01],0) as satu,
        isnull([02],0) as dua,
        isnull([03],0) as tiga,
        isnull([04],0) as empat,
        isnull([05],0) as lima,
        isnull([06],0) as enam,
        isnull([07],0) as Jtujuh,
        isnull([08],0) as delapan,
        isnull([09],0) as sembilan,
        isnull([10],0) as sepuluh,
        isnull([11],0) as sebelah,
        isnull([12],0) as duabelas,
        isnull([13],0) as tigabelas,
        isnull([14],0) as empatbelas,
        isnull([15],0) as limabelas,
        isnull([16],0) as enambelas,
        isnull([17],0) as tujuhbelas,
        isnull([18],0) as delapanbelas,
        isnull([19],0) as sembilanbelas,
        isnull([20],0) as duapuluh,
        isnull([21],0) as duapuluhsatu,
        isnull([22],0) as duapuluhdua,
        isnull([23],0) as duapuluhtiga,
        isnull([24],0) as duapuluhempat,
        isnull([25],0) as duapuluhlima,
        isnull([26],0) as duapuluhenam,
        isnull([27],0) as duapuluhtujuh,
        isnull([28],0) as duapuluhdelapan,
        isnull([29],0) as duapuluhlsembilan,
        isnull([30],0) as tigapuluh,
        isnull([31],0) as tigapuluhsatu,
        (isnull([01],0)+
        isnull([02],0)+
        isnull([03],0)+
        isnull([04],0)+
        isnull([05],0)+
        isnull([06],0)+
        isnull([07],0)+
        isnull([08],0)+
        isnull([09],0)+
        isnull([10],0)+
        isnull([11],0)+
        isnull([12],0)+
        isnull([13],0)+
        isnull([14],0)+
        isnull([15],0)+
        isnull([16],0)+
        isnull([17],0)+
        isnull([18],0)+
        isnull([19],0)+
        isnull([20],0)+
        isnull([21],0)+
        isnull([22],0)+
        isnull([23],0)+
        isnull([24],0)+
        isnull([25],0)+
        isnull([26],0)+
        isnull([27],0)+
        isnull([28],0)+
        isnull([29],0)+
        isnull([30],0)+
        isnull([31],0))
             as TOTAL
                  FROM (
                       select  a.NamaCaraMasukRef,a.NamaUnit, a.NamaDokter,
                       SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                      count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                      from DashboardData.dbo.dataRWJ a
                      where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
                      and a.IdUnit not in  ('9','10','47','48','49','52','17','1','52','53')
                      group by a.NamaCaraMasukRef,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2),a.NamaUnit,a.NamaDokter
                       
                  ) AS QuarterlyData
                  PIVOT( SUM([REGISTRASI Count])   
                          FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
          [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
          [25],[26],[27],[28],[29],[30],[31],
                          [grandtotal])) AS QPivot
                          order by NamaCaraMasukRef asc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaUnit'];
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '6' && $JenisRekap == '3') {
                //     $query = "SELECT NamaCaraMasukRef as NamaRujukan,NamaUnit,First_Name as NamaDokter,
                //     isnull([01],0) as satu,
                // isnull([02],0) as dua,
                // isnull([03],0) as tiga,
                // isnull([04],0) as empat,
                // isnull([05],0) as lima,
                // isnull([06],0) as enam,
                // isnull([07],0) as Jtujuh,
                // isnull([08],0) as delapan,
                // isnull([09],0) as sembilan,
                // isnull([10],0) as sepuluh,
                // isnull([11],0) as sebelah,
                // isnull([12],0) as duabelas,
                // isnull([13],0) as tigabelas,
                // isnull([14],0) as empatbelas,
                // isnull([15],0) as limabelas,
                // isnull([16],0) as enambelas,
                // isnull([17],0) as tujuhbelas,
                // isnull([18],0) as delapanbelas,
                // isnull([19],0) as sembilanbelas,
                // isnull([20],0) as duapuluh,
                // isnull([21],0) as duapuluhsatu,
                // isnull([22],0) as duapuluhdua,
                // isnull([23],0) as duapuluhtiga,
                // isnull([24],0) as duapuluhempat,
                // isnull([25],0) as duapuluhlima,
                // isnull([26],0) as duapuluhenam,
                // isnull([27],0) as duapuluhtujuh,
                // isnull([28],0) as duapuluhdelapan,
                // isnull([29],0) as duapuluhlsembilan,
                // isnull([30],0) as tigapuluh,
                // isnull([31],0) as tigapuluhsatu,
                // (isnull([01],0)+
                // isnull([02],0)+
                // isnull([03],0)+
                // isnull([04],0)+
                // isnull([05],0)+
                // isnull([06],0)+
                // isnull([07],0)+
                // isnull([08],0)+
                // isnull([09],0)+
                // isnull([10],0)+
                // isnull([11],0)+
                // isnull([12],0)+
                // isnull([13],0)+
                // isnull([14],0)+
                // isnull([15],0)+
                // isnull([16],0)+
                // isnull([17],0)+
                // isnull([18],0)+
                // isnull([19],0)+
                // isnull([20],0)+
                // isnull([21],0)+
                // isnull([22],0)+
                // isnull([23],0)+
                // isnull([24],0)+
                // isnull([25],0)+
                // isnull([26],0)+
                // isnull([27],0)+
                // isnull([28],0)+
                // isnull([29],0)+
                // isnull([30],0)+
                // isnull([31],0))
                //      as TOTAL
                //           FROM (
                //                select  f.NamaCaraMasukRef,pg.NamaUnit, c.First_Name,
                //                SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2) [Quarter],
                //               count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                //               from PerawatanSQL.dbo.Visit a
                //               inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                //               inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                //               inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                //               inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit 
                //   inner join MasterdataSQL.dbo.MstrCaraMasuk_2 f on a.idCaraMasuk2=f.id
                //               left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                //               where SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),1,7)=:Periode
                //               and a.Batal='0'   
                //               and pg.id  in ('47')
                //               group by f.NamaCaraMasukRef,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2),pg.NamaUnit, c.First_Name

                //           ) AS QuarterlyData
                //           PIVOT( SUM([REGISTRASI Count])   
                //                   FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
                //   [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
                //   [25],[26],[27],[28],[29],[30],[31],
                //                   [grandtotal])) AS QPivot
                //                   order by NamaCaraMasukRef asc";

                $query = "SELECT NamaCaraMasukRef as NamaRujukan,NamaUnit,NamaDokter,
            isnull([01],0) as satu,
        isnull([02],0) as dua,
        isnull([03],0) as tiga,
        isnull([04],0) as empat,
        isnull([05],0) as lima,
        isnull([06],0) as enam,
        isnull([07],0) as Jtujuh,
        isnull([08],0) as delapan,
        isnull([09],0) as sembilan,
        isnull([10],0) as sepuluh,
        isnull([11],0) as sebelah,
        isnull([12],0) as duabelas,
        isnull([13],0) as tigabelas,
        isnull([14],0) as empatbelas,
        isnull([15],0) as limabelas,
        isnull([16],0) as enambelas,
        isnull([17],0) as tujuhbelas,
        isnull([18],0) as delapanbelas,
        isnull([19],0) as sembilanbelas,
        isnull([20],0) as duapuluh,
        isnull([21],0) as duapuluhsatu,
        isnull([22],0) as duapuluhdua,
        isnull([23],0) as duapuluhtiga,
        isnull([24],0) as duapuluhempat,
        isnull([25],0) as duapuluhlima,
        isnull([26],0) as duapuluhenam,
        isnull([27],0) as duapuluhtujuh,
        isnull([28],0) as duapuluhdelapan,
        isnull([29],0) as duapuluhlsembilan,
        isnull([30],0) as tigapuluh,
        isnull([31],0) as tigapuluhsatu,
        (isnull([01],0)+
        isnull([02],0)+
        isnull([03],0)+
        isnull([04],0)+
        isnull([05],0)+
        isnull([06],0)+
        isnull([07],0)+
        isnull([08],0)+
        isnull([09],0)+
        isnull([10],0)+
        isnull([11],0)+
        isnull([12],0)+
        isnull([13],0)+
        isnull([14],0)+
        isnull([15],0)+
        isnull([16],0)+
        isnull([17],0)+
        isnull([18],0)+
        isnull([19],0)+
        isnull([20],0)+
        isnull([21],0)+
        isnull([22],0)+
        isnull([23],0)+
        isnull([24],0)+
        isnull([25],0)+
        isnull([26],0)+
        isnull([27],0)+
        isnull([28],0)+
        isnull([29],0)+
        isnull([30],0)+
        isnull([31],0))
             as TOTAL
                  FROM (
                       select  a.NamaCaraMasukRef,a.NamaUnit, a.NamaDokter,
                       SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                      count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                      from DashboardData.dbo.dataRWJ a
                      where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
                      --and a.IdUnit not in  ('9','10','47','48','49','52','17','1','52','53')
                       and a.IdUnit  in ('47')
                      group by a.NamaCaraMasukRef,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2),a.NamaUnit,a.NamaDokter
                       
                  ) AS QuarterlyData
                  PIVOT( SUM([REGISTRASI Count])   
                          FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
          [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
          [25],[26],[27],[28],[29],[30],[31],
                          [grandtotal])) AS QPivot
                          order by NamaCaraMasukRef asc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaUnit'];
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '7' && $JenisRekap == '3') {
                //     $query = "SELECT NamaCaraMasukRef as NamaRujukan,NamaUnit,First_Name as NamaDokter,
                //     isnull([01],0) as satu,
                // isnull([02],0) as dua,
                // isnull([03],0) as tiga,
                // isnull([04],0) as empat,
                // isnull([05],0) as lima,
                // isnull([06],0) as enam,
                // isnull([07],0) as Jtujuh,
                // isnull([08],0) as delapan,
                // isnull([09],0) as sembilan,
                // isnull([10],0) as sepuluh,
                // isnull([11],0) as sebelah,
                // isnull([12],0) as duabelas,
                // isnull([13],0) as tigabelas,
                // isnull([14],0) as empatbelas,
                // isnull([15],0) as limabelas,
                // isnull([16],0) as enambelas,
                // isnull([17],0) as tujuhbelas,
                // isnull([18],0) as delapanbelas,
                // isnull([19],0) as sembilanbelas,
                // isnull([20],0) as duapuluh,
                // isnull([21],0) as duapuluhsatu,
                // isnull([22],0) as duapuluhdua,
                // isnull([23],0) as duapuluhtiga,
                // isnull([24],0) as duapuluhempat,
                // isnull([25],0) as duapuluhlima,
                // isnull([26],0) as duapuluhenam,
                // isnull([27],0) as duapuluhtujuh,
                // isnull([28],0) as duapuluhdelapan,
                // isnull([29],0) as duapuluhlsembilan,
                // isnull([30],0) as tigapuluh,
                // isnull([31],0) as tigapuluhsatu,
                // (isnull([01],0)+
                // isnull([02],0)+
                // isnull([03],0)+
                // isnull([04],0)+
                // isnull([05],0)+
                // isnull([06],0)+
                // isnull([07],0)+
                // isnull([08],0)+
                // isnull([09],0)+
                // isnull([10],0)+
                // isnull([11],0)+
                // isnull([12],0)+
                // isnull([13],0)+
                // isnull([14],0)+
                // isnull([15],0)+
                // isnull([16],0)+
                // isnull([17],0)+
                // isnull([18],0)+
                // isnull([19],0)+
                // isnull([20],0)+
                // isnull([21],0)+
                // isnull([22],0)+
                // isnull([23],0)+
                // isnull([24],0)+
                // isnull([25],0)+
                // isnull([26],0)+
                // isnull([27],0)+
                // isnull([28],0)+
                // isnull([29],0)+
                // isnull([30],0)+
                // isnull([31],0))
                //      as TOTAL
                //           FROM (
                //                select  f.NamaCaraMasukRef,pg.NamaUnit, c.First_Name,
                //                SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2) [Quarter],
                //               count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                //               from PerawatanSQL.dbo.Visit a
                //               inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                //               inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                //               inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                //               inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit 
                //               inner join MasterdataSQL.dbo.MstrCaraMasuk_2 f on a.idCaraMasuk2=f.id
                //               left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                //               where SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),1,7)=:Periode
                //                and a.Batal='0'  
                //                 and pg.id  in ('9','10','48','49','52','17')
                //               group by f.NamaCaraMasukRef,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2),pg.NamaUnit, c.First_Name

                //           ) AS QuarterlyData
                //           PIVOT( SUM([REGISTRASI Count])   
                //                   FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
                //   [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
                //   [25],[26],[27],[28],[29],[30],[31],
                //                   [grandtotal])) AS QPivot
                //                   order by NamaCaraMasukRef asc";

                $query = "SELECT NamaCaraMasukRef as NamaRujukan,NamaUnit,NamaDokter,
            isnull([01],0) as satu,
        isnull([02],0) as dua,
        isnull([03],0) as tiga,
        isnull([04],0) as empat,
        isnull([05],0) as lima,
        isnull([06],0) as enam,
        isnull([07],0) as Jtujuh,
        isnull([08],0) as delapan,
        isnull([09],0) as sembilan,
        isnull([10],0) as sepuluh,
        isnull([11],0) as sebelah,
        isnull([12],0) as duabelas,
        isnull([13],0) as tigabelas,
        isnull([14],0) as empatbelas,
        isnull([15],0) as limabelas,
        isnull([16],0) as enambelas,
        isnull([17],0) as tujuhbelas,
        isnull([18],0) as delapanbelas,
        isnull([19],0) as sembilanbelas,
        isnull([20],0) as duapuluh,
        isnull([21],0) as duapuluhsatu,
        isnull([22],0) as duapuluhdua,
        isnull([23],0) as duapuluhtiga,
        isnull([24],0) as duapuluhempat,
        isnull([25],0) as duapuluhlima,
        isnull([26],0) as duapuluhenam,
        isnull([27],0) as duapuluhtujuh,
        isnull([28],0) as duapuluhdelapan,
        isnull([29],0) as duapuluhlsembilan,
        isnull([30],0) as tigapuluh,
        isnull([31],0) as tigapuluhsatu,
        (isnull([01],0)+
        isnull([02],0)+
        isnull([03],0)+
        isnull([04],0)+
        isnull([05],0)+
        isnull([06],0)+
        isnull([07],0)+
        isnull([08],0)+
        isnull([09],0)+
        isnull([10],0)+
        isnull([11],0)+
        isnull([12],0)+
        isnull([13],0)+
        isnull([14],0)+
        isnull([15],0)+
        isnull([16],0)+
        isnull([17],0)+
        isnull([18],0)+
        isnull([19],0)+
        isnull([20],0)+
        isnull([21],0)+
        isnull([22],0)+
        isnull([23],0)+
        isnull([24],0)+
        isnull([25],0)+
        isnull([26],0)+
        isnull([27],0)+
        isnull([28],0)+
        isnull([29],0)+
        isnull([30],0)+
        isnull([31],0))
             as TOTAL
                  FROM (
                       select  a.NamaCaraMasukRef,a.NamaUnit, a.NamaDokter,
                       SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                      count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                      from DashboardData.dbo.dataRWJ a
                      where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
                      --and a.IdUnit not in  ('9','10','47','48','49','52','17','1','52','53')
                       and a.IdUnit  in ('9','10','48','49','52','17')
                      group by a.NamaCaraMasukRef,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2),a.NamaUnit,a.NamaDokter
                       
                  ) AS QuarterlyData
                  PIVOT( SUM([REGISTRASI Count])   
                          FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
          [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
          [25],[26],[27],[28],[29],[30],[31],
                          [grandtotal])) AS QPivot
                          order by NamaCaraMasukRef asc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaUnit'];
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '2' && $JenisRekap == '3') {
                //     $query = "SELECT NamaCaraMasukRef as NamaRujukan,NamaUnit,First_Name as NamaDokter,
                //     isnull([01],0) as satu,
                // isnull([02],0) as dua,
                // isnull([03],0) as tiga,
                // isnull([04],0) as empat,
                // isnull([05],0) as lima,
                // isnull([06],0) as enam,
                // isnull([07],0) as Jtujuh,
                // isnull([08],0) as delapan,
                // isnull([09],0) as sembilan,
                // isnull([10],0) as sepuluh,
                // isnull([11],0) as sebelah,
                // isnull([12],0) as duabelas,
                // isnull([13],0) as tigabelas,
                // isnull([14],0) as empatbelas,
                // isnull([15],0) as limabelas,
                // isnull([16],0) as enambelas,
                // isnull([17],0) as tujuhbelas,
                // isnull([18],0) as delapanbelas,
                // isnull([19],0) as sembilanbelas,
                // isnull([20],0) as duapuluh,
                // isnull([21],0) as duapuluhsatu,
                // isnull([22],0) as duapuluhdua,
                // isnull([23],0) as duapuluhtiga,
                // isnull([24],0) as duapuluhempat,
                // isnull([25],0) as duapuluhlima,
                // isnull([26],0) as duapuluhenam,
                // isnull([27],0) as duapuluhtujuh,
                // isnull([28],0) as duapuluhdelapan,
                // isnull([29],0) as duapuluhlsembilan,
                // isnull([30],0) as tigapuluh,
                // isnull([31],0) as tigapuluhsatu,
                // (isnull([01],0)+
                // isnull([02],0)+
                // isnull([03],0)+
                // isnull([04],0)+
                // isnull([05],0)+
                // isnull([06],0)+
                // isnull([07],0)+
                // isnull([08],0)+
                // isnull([09],0)+
                // isnull([10],0)+
                // isnull([11],0)+
                // isnull([12],0)+
                // isnull([13],0)+
                // isnull([14],0)+
                // isnull([15],0)+
                // isnull([16],0)+
                // isnull([17],0)+
                // isnull([18],0)+
                // isnull([19],0)+
                // isnull([20],0)+
                // isnull([21],0)+
                // isnull([22],0)+
                // isnull([23],0)+
                // isnull([24],0)+
                // isnull([25],0)+
                // isnull([26],0)+
                // isnull([27],0)+
                // isnull([28],0)+
                // isnull([29],0)+
                // isnull([30],0)+
                // isnull([31],0))
                //      as TOTAL
                //           FROM (
                //                select  f.NamaCaraMasukRef,pg.NamaUnit, c.First_Name,
                //                SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2) [Quarter],
                //               count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                //               from PerawatanSQL.dbo.Visit a
                //               inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                //               inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                //               inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                //               inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit 
                //   inner join MasterdataSQL.dbo.MstrCaraMasuk_2 f on a.idCaraMasuk2=f.id
                //               left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                //               where SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),1,7)=:Periode
                //               and a.Batal='0'   and pg.id  in ('1')
                //               group by f.NamaCaraMasukRef,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2),pg.NamaUnit, c.First_Name

                //           ) AS QuarterlyData
                //           PIVOT( SUM([REGISTRASI Count])   
                //                   FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
                //   [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
                //   [25],[26],[27],[28],[29],[30],[31],
                //                   [grandtotal])) AS QPivot
                //                   order by NamaCaraMasukRef asc";

                $query = "SELECT NamaCaraMasukRef as NamaRujukan,NamaUnit,NamaDokter,
            isnull([01],0) as satu,
        isnull([02],0) as dua,
        isnull([03],0) as tiga,
        isnull([04],0) as empat,
        isnull([05],0) as lima,
        isnull([06],0) as enam,
        isnull([07],0) as Jtujuh,
        isnull([08],0) as delapan,
        isnull([09],0) as sembilan,
        isnull([10],0) as sepuluh,
        isnull([11],0) as sebelah,
        isnull([12],0) as duabelas,
        isnull([13],0) as tigabelas,
        isnull([14],0) as empatbelas,
        isnull([15],0) as limabelas,
        isnull([16],0) as enambelas,
        isnull([17],0) as tujuhbelas,
        isnull([18],0) as delapanbelas,
        isnull([19],0) as sembilanbelas,
        isnull([20],0) as duapuluh,
        isnull([21],0) as duapuluhsatu,
        isnull([22],0) as duapuluhdua,
        isnull([23],0) as duapuluhtiga,
        isnull([24],0) as duapuluhempat,
        isnull([25],0) as duapuluhlima,
        isnull([26],0) as duapuluhenam,
        isnull([27],0) as duapuluhtujuh,
        isnull([28],0) as duapuluhdelapan,
        isnull([29],0) as duapuluhlsembilan,
        isnull([30],0) as tigapuluh,
        isnull([31],0) as tigapuluhsatu,
        (isnull([01],0)+
        isnull([02],0)+
        isnull([03],0)+
        isnull([04],0)+
        isnull([05],0)+
        isnull([06],0)+
        isnull([07],0)+
        isnull([08],0)+
        isnull([09],0)+
        isnull([10],0)+
        isnull([11],0)+
        isnull([12],0)+
        isnull([13],0)+
        isnull([14],0)+
        isnull([15],0)+
        isnull([16],0)+
        isnull([17],0)+
        isnull([18],0)+
        isnull([19],0)+
        isnull([20],0)+
        isnull([21],0)+
        isnull([22],0)+
        isnull([23],0)+
        isnull([24],0)+
        isnull([25],0)+
        isnull([26],0)+
        isnull([27],0)+
        isnull([28],0)+
        isnull([29],0)+
        isnull([30],0)+
        isnull([31],0))
             as TOTAL
                  FROM (
                       select  a.NamaCaraMasukRef,a.NamaUnit, a.NamaDokter,
                       SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                      count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                      from DashboardData.dbo.dataRWJ a
                      where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
                      --and a.IdUnit not in  ('9','10','47','48','49','52','17','1','52','53')
                       and a.IdUnit  in ('1')
                      group by a.NamaCaraMasukRef,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2),a.NamaUnit,a.NamaDokter
                       
                  ) AS QuarterlyData
                  PIVOT( SUM([REGISTRASI Count])   
                          FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
          [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
          [25],[26],[27],[28],[29],[30],[31],
                          [grandtotal])) AS QPivot
                          order by NamaCaraMasukRef asc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaUnit'];
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '3' && $JenisRekap == '3') {
                //     $query = "SELECT NamaCaraMasukRef as NamaRujukan,NamaUnit,First_Name as NamaDokter,
                //     isnull([01],0) as satu,
                // isnull([02],0) as dua,
                // isnull([03],0) as tiga,
                // isnull([04],0) as empat,
                // isnull([05],0) as lima,
                // isnull([06],0) as enam,
                // isnull([07],0) as Jtujuh,
                // isnull([08],0) as delapan,
                // isnull([09],0) as sembilan,
                // isnull([10],0) as sepuluh,
                // isnull([11],0) as sebelah,
                // isnull([12],0) as duabelas,
                // isnull([13],0) as tigabelas,
                // isnull([14],0) as empatbelas,
                // isnull([15],0) as limabelas,
                // isnull([16],0) as enambelas,
                // isnull([17],0) as tujuhbelas,
                // isnull([18],0) as delapanbelas,
                // isnull([19],0) as sembilanbelas,
                // isnull([20],0) as duapuluh,
                // isnull([21],0) as duapuluhsatu,
                // isnull([22],0) as duapuluhdua,
                // isnull([23],0) as duapuluhtiga,
                // isnull([24],0) as duapuluhempat,
                // isnull([25],0) as duapuluhlima,
                // isnull([26],0) as duapuluhenam,
                // isnull([27],0) as duapuluhtujuh,
                // isnull([28],0) as duapuluhdelapan,
                // isnull([29],0) as duapuluhlsembilan,
                // isnull([30],0) as tigapuluh,
                // isnull([31],0) as tigapuluhsatu,
                // (isnull([01],0)+
                // isnull([02],0)+
                // isnull([03],0)+
                // isnull([04],0)+
                // isnull([05],0)+
                // isnull([06],0)+
                // isnull([07],0)+
                // isnull([08],0)+
                // isnull([09],0)+
                // isnull([10],0)+
                // isnull([11],0)+
                // isnull([12],0)+
                // isnull([13],0)+
                // isnull([14],0)+
                // isnull([15],0)+
                // isnull([16],0)+
                // isnull([17],0)+
                // isnull([18],0)+
                // isnull([19],0)+
                // isnull([20],0)+
                // isnull([21],0)+
                // isnull([22],0)+
                // isnull([23],0)+
                // isnull([24],0)+
                // isnull([25],0)+
                // isnull([26],0)+
                // isnull([27],0)+
                // isnull([28],0)+
                // isnull([29],0)+
                // isnull([30],0)+
                // isnull([31],0))
                //      as TOTAL
                //           FROM (
                //                select  f.NamaCaraMasukRef,pg.NamaUnit, c.First_Name,
                //                SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2) [Quarter],
                //               count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                //               from PerawatanSQL.dbo.Visit a
                //               inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                //               inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                //               inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                //               inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit 
                //   inner join MasterdataSQL.dbo.MstrCaraMasuk_2 f on a.idCaraMasuk2=f.id
                //               left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                //               where SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),1,7)=:Periode
                //               and a.Batal='0'  
                //               AND PG.ID='53'  
                //               group by f.NamaCaraMasukRef,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2),pg.NamaUnit, c.First_Name

                //           ) AS QuarterlyData
                //           PIVOT( SUM([REGISTRASI Count])   
                //                   FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
                //   [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
                //   [25],[26],[27],[28],[29],[30],[31],
                //                   [grandtotal])) AS QPivot
                //                   order by NamaCaraMasukRef asc";

                $query = "SELECT NamaCaraMasukRef as NamaRujukan,NamaUnit,NamaDokter,
            isnull([01],0) as satu,
        isnull([02],0) as dua,
        isnull([03],0) as tiga,
        isnull([04],0) as empat,
        isnull([05],0) as lima,
        isnull([06],0) as enam,
        isnull([07],0) as Jtujuh,
        isnull([08],0) as delapan,
        isnull([09],0) as sembilan,
        isnull([10],0) as sepuluh,
        isnull([11],0) as sebelah,
        isnull([12],0) as duabelas,
        isnull([13],0) as tigabelas,
        isnull([14],0) as empatbelas,
        isnull([15],0) as limabelas,
        isnull([16],0) as enambelas,
        isnull([17],0) as tujuhbelas,
        isnull([18],0) as delapanbelas,
        isnull([19],0) as sembilanbelas,
        isnull([20],0) as duapuluh,
        isnull([21],0) as duapuluhsatu,
        isnull([22],0) as duapuluhdua,
        isnull([23],0) as duapuluhtiga,
        isnull([24],0) as duapuluhempat,
        isnull([25],0) as duapuluhlima,
        isnull([26],0) as duapuluhenam,
        isnull([27],0) as duapuluhtujuh,
        isnull([28],0) as duapuluhdelapan,
        isnull([29],0) as duapuluhlsembilan,
        isnull([30],0) as tigapuluh,
        isnull([31],0) as tigapuluhsatu,
        (isnull([01],0)+
        isnull([02],0)+
        isnull([03],0)+
        isnull([04],0)+
        isnull([05],0)+
        isnull([06],0)+
        isnull([07],0)+
        isnull([08],0)+
        isnull([09],0)+
        isnull([10],0)+
        isnull([11],0)+
        isnull([12],0)+
        isnull([13],0)+
        isnull([14],0)+
        isnull([15],0)+
        isnull([16],0)+
        isnull([17],0)+
        isnull([18],0)+
        isnull([19],0)+
        isnull([20],0)+
        isnull([21],0)+
        isnull([22],0)+
        isnull([23],0)+
        isnull([24],0)+
        isnull([25],0)+
        isnull([26],0)+
        isnull([27],0)+
        isnull([28],0)+
        isnull([29],0)+
        isnull([30],0)+
        isnull([31],0))
             as TOTAL
                  FROM (
                       select  a.NamaCaraMasukRef,a.NamaUnit, a.NamaDokter,
                       SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                      count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                      from DashboardData.dbo.dataRWJ a
                      where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
                       and a.IdUnit  in ('53')
                      group by a.NamaCaraMasukRef,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2),a.NamaUnit,a.NamaDokter
                       
                  ) AS QuarterlyData
                  PIVOT( SUM([REGISTRASI Count])   
                          FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
          [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
          [25],[26],[27],[28],[29],[30],[31],
                          [grandtotal])) AS QPivot
                          order by NamaCaraMasukRef asc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaUnit'];
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '4' && $JenisRekap == '3') {
                //         $query = "SELECT NamaCaraMasukRef as NamaRujukan,JenisRawat,First_Name as NamaDokter,
                //         isnull([01],0) as satu,
                //     isnull([02],0) as dua,
                //     isnull([03],0) as tiga,
                //     isnull([04],0) as empat,
                //     isnull([05],0) as lima,
                //     isnull([06],0) as enam,
                //     isnull([07],0) as Jtujuh,
                //     isnull([08],0) as delapan,
                //     isnull([09],0) as sembilan,
                //     isnull([10],0) as sepuluh,
                //     isnull([11],0) as sebelah,
                //     isnull([12],0) as duabelas,
                //     isnull([13],0) as tigabelas,
                // 	isnull([14],0) as empatbelas,
                //     isnull([15],0) as limabelas,
                //     isnull([16],0) as enambelas,
                //     isnull([17],0) as tujuhbelas,
                // 	isnull([18],0) as delapanbelas,
                //     isnull([19],0) as sembilanbelas,
                //     isnull([20],0) as duapuluh,
                //     isnull([21],0) as duapuluhsatu,
                // 	isnull([22],0) as duapuluhdua,
                //     isnull([23],0) as duapuluhtiga,
                //     isnull([24],0) as duapuluhempat,
                //     isnull([25],0) as duapuluhlima,
                // 	isnull([26],0) as duapuluhenam,
                //     isnull([27],0) as duapuluhtujuh,
                //     isnull([28],0) as duapuluhdelapan,
                //     isnull([29],0) as duapuluhlsembilan,
                // 	isnull([30],0) as tigapuluh,
                //     isnull([31],0) as tigapuluhsatu,
                //     (isnull([01],0)+
                //     isnull([02],0)+
                //     isnull([03],0)+
                //     isnull([04],0)+
                //     isnull([05],0)+
                //     isnull([06],0)+
                //     isnull([07],0)+
                //     isnull([08],0)+
                //     isnull([09],0)+
                //     isnull([10],0)+
                //     isnull([11],0)+
                //     isnull([12],0)+
                // 	isnull([13],0)+
                //     isnull([14],0)+
                //     isnull([15],0)+
                //     isnull([16],0)+
                //     isnull([17],0)+
                //     isnull([18],0)+
                //     isnull([19],0)+
                //     isnull([20],0)+
                //     isnull([21],0)+
                //     isnull([22],0)+
                //     isnull([23],0)+
                //     isnull([24],0)+
                // 	isnull([25],0)+
                //     isnull([26],0)+
                //     isnull([27],0)+
                //     isnull([28],0)+
                //     isnull([29],0)+
                //     isnull([30],0)+
                //     isnull([31],0))
                //          as TOTAL
                // FROM (
                //      select  f.NamaCaraMasukRef,JenisRawat, c.First_Name,
                //      SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),6,2) [Quarter],
                //     count(isnull(a.drPenerima,0)) as  [REGISTRASI Count]
                //     from RawatInapSQL.dbo.Inpatient a
                //     inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                //     inner join MasterdataSQL.dbo.Doctors c on c.ID = a.drPenerima
                //     inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.TypePatient  
                //     inner join MasterdataSQL.dbo.MstrCaraMasuk_2 f on a.idCaraMasuk2=f.id
                //     where YEAR(a.StartDate)=:Periode 
                //     group by f.NamaCaraMasukRef,SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),6,2),JenisRawat, c.First_Name

                // ) AS QuarterlyData
                // PIVOT( SUM([REGISTRASI Count])   
                //         FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
                //       [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
                //       [25],[26],[27],[28],[29],[30],[31],
                //         [grandtotal])) AS QPivot
                //         order by NamaCaraMasukRef asc";

                $query = "SELECT NamaCaraMasukRef as NamaRujukan,NamaUnit,NamaDokter,
        isnull([01],0) as satu,
    isnull([02],0) as dua,
    isnull([03],0) as tiga,
    isnull([04],0) as empat,
    isnull([05],0) as lima,
    isnull([06],0) as enam,
    isnull([07],0) as Jtujuh,
    isnull([08],0) as delapan,
    isnull([09],0) as sembilan,
    isnull([10],0) as sepuluh,
    isnull([11],0) as sebelah,
    isnull([12],0) as duabelas,
    isnull([13],0) as tigabelas,
    isnull([14],0) as empatbelas,
    isnull([15],0) as limabelas,
    isnull([16],0) as enambelas,
    isnull([17],0) as tujuhbelas,
    isnull([18],0) as delapanbelas,
    isnull([19],0) as sembilanbelas,
    isnull([20],0) as duapuluh,
    isnull([21],0) as duapuluhsatu,
    isnull([22],0) as duapuluhdua,
    isnull([23],0) as duapuluhtiga,
    isnull([24],0) as duapuluhempat,
    isnull([25],0) as duapuluhlima,
    isnull([26],0) as duapuluhenam,
    isnull([27],0) as duapuluhtujuh,
    isnull([28],0) as duapuluhdelapan,
    isnull([29],0) as duapuluhlsembilan,
    isnull([30],0) as tigapuluh,
    isnull([31],0) as tigapuluhsatu,
    (isnull([01],0)+
    isnull([02],0)+
    isnull([03],0)+
    isnull([04],0)+
    isnull([05],0)+
    isnull([06],0)+
    isnull([07],0)+
    isnull([08],0)+
    isnull([09],0)+
    isnull([10],0)+
    isnull([11],0)+
    isnull([12],0)+
    isnull([13],0)+
    isnull([14],0)+
    isnull([15],0)+
    isnull([16],0)+
    isnull([17],0)+
    isnull([18],0)+
    isnull([19],0)+
    isnull([20],0)+
    isnull([21],0)+
    isnull([22],0)+
    isnull([23],0)+
    isnull([24],0)+
    isnull([25],0)+
    isnull([26],0)+
    isnull([27],0)+
    isnull([28],0)+
    isnull([29],0)+
    isnull([30],0)+
    isnull([31],0))
         as TOTAL
              FROM (
                   select  a.NamaCaraMasukRef,a.NamaUnit, a.NamaDokter,
                   SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                  count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                  from DashboardData.dbo.dataRWJ a
                  where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
                  group by a.NamaCaraMasukRef,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2),a.NamaUnit,a.NamaDokter
                   
              ) AS QuarterlyData
              PIVOT( SUM([REGISTRASI Count])   
                      FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
      [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
      [25],[26],[27],[28],[29],[30],[31],
                      [grandtotal])) AS QPivot
                      order by NamaCaraMasukRef asc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['JenisRawat'];
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '5' && $JenisRekap == '3') {
                $query = "SELECT NamaCaraMasukRef as NamaRujukan,GroupSpesialis,DrOperator as NamaDokter,
                isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
			isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
			isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
			isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
			isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
			isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
			isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
			isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0))
                 as TOTAL
        FROM (
             select  f.NamaCaraMasukRef,g.GroupSpesialis, g.DrOperator,
             SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),6,2) [Quarter],
            count(isnull(a.drPenerima,0)) as  [REGISTRASI Count]
            from RawatInapSQL.dbo.Inpatient a
            inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
            inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.TypePatient  
            inner join MasterdataSQL.dbo.MstrCaraMasuk_2 f on a.idCaraMasuk2=f.id
            inner join MedicalRecord.dbo.EMR_OrderOperasi g on a.NoRegRI  collate SQL_Latin1_General_CP1_CI_AS=g.NoRegistrasi  collate SQL_Latin1_General_CP1_CI_AS
            where YEAR(a.StartDate)=:Periode and g.StatusOrder='Approved OT' 
            group by f.NamaCaraMasukRef,SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),6,2),GroupSpesialis, g.DrOperator
             
        ) AS QuarterlyData
        PIVOT( SUM([REGISTRASI Count])   
                FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31],
                [grandtotal])) AS QPivot
                order by NamaCaraMasukRef asc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['GroupSpesialis'];
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '1' && $JenisRekap == '2') {
                //     $query = "SELECT NamaUnit,First_Name as NamaDokter,
                //     isnull([01],0) as satu,
                // isnull([02],0) as dua,
                // isnull([03],0) as tiga,
                // isnull([04],0) as empat,
                // isnull([05],0) as lima,
                // isnull([06],0) as enam,
                // isnull([07],0) as Jtujuh,
                // isnull([08],0) as delapan,
                // isnull([09],0) as sembilan,
                // isnull([10],0) as sepuluh,
                // isnull([11],0) as sebelah,
                // isnull([12],0) as duabelas,
                // isnull([13],0) as tigabelas,
                // isnull([14],0) as empatbelas,
                // isnull([15],0) as limabelas,
                // isnull([16],0) as enambelas,
                // isnull([17],0) as tujuhbelas,
                // isnull([18],0) as delapanbelas,
                // isnull([19],0) as sembilanbelas,
                // isnull([20],0) as duapuluh,
                // isnull([21],0) as duapuluhsatu,
                // isnull([22],0) as duapuluhdua,
                // isnull([23],0) as duapuluhtiga,
                // isnull([24],0) as duapuluhempat,
                // isnull([25],0) as duapuluhlima,
                // isnull([26],0) as duapuluhenam,
                // isnull([27],0) as duapuluhtujuh,
                // isnull([28],0) as duapuluhdelapan,
                // isnull([29],0) as duapuluhlsembilan,
                // isnull([30],0) as tigapuluh,
                // isnull([31],0) as tigapuluhsatu,
                // (isnull([01],0)+
                // isnull([02],0)+
                // isnull([03],0)+
                // isnull([04],0)+
                // isnull([05],0)+
                // isnull([06],0)+
                // isnull([07],0)+
                // isnull([08],0)+
                // isnull([09],0)+
                // isnull([10],0)+
                // isnull([11],0)+
                // isnull([12],0)+
                // isnull([13],0)+
                // isnull([14],0)+
                // isnull([15],0)+
                // isnull([16],0)+
                // isnull([17],0)+
                // isnull([18],0)+
                // isnull([19],0)+
                // isnull([20],0)+
                // isnull([21],0)+
                // isnull([22],0)+
                // isnull([23],0)+
                // isnull([24],0)+
                // isnull([25],0)+
                // isnull([26],0)+
                // isnull([27],0)+
                // isnull([28],0)+
                // isnull([29],0)+
                // isnull([30],0)+
                // isnull([31],0))
                //      as TOTAL
                //           FROM (
                //                select pg.NamaUnit, c.First_Name,
                //                SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2) [Quarter],
                //               count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                //               from PerawatanSQL.dbo.Visit a
                //               inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                //               inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                //               inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                //               inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                //               left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                //               where SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),1,7)=:Periode
                //               and a.Batal='0'   
                //              and pg.id not in ('9','10','47','48','49','52','17','1','53')
                //               group by pg.NamaUnit,c.First_Name,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2)

                //           ) AS QuarterlyData
                //           PIVOT( SUM([REGISTRASI Count])   
                //                   FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
                //   [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
                //   [25],[26],[27],[28],[29],[30],[31],
                //                   [grandtotal])) AS QPivot
                //                   order by NamaUnit asc";

                $query = "	SELECT NamaUnit, NamaDokter,
            isnull([01],0) as satu,
        isnull([02],0) as dua,
        isnull([03],0) as tiga,
        isnull([04],0) as empat,
        isnull([05],0) as lima,
        isnull([06],0) as enam,
        isnull([07],0) as Jtujuh,
        isnull([08],0) as delapan,
        isnull([09],0) as sembilan,
        isnull([10],0) as sepuluh,
        isnull([11],0) as sebelah,
        isnull([12],0) as duabelas,
        isnull([13],0) as tigabelas,
        isnull([14],0) as empatbelas,
        isnull([15],0) as limabelas,
        isnull([16],0) as enambelas,
        isnull([17],0) as tujuhbelas,
        isnull([18],0) as delapanbelas,
        isnull([19],0) as sembilanbelas,
        isnull([20],0) as duapuluh,
        isnull([21],0) as duapuluhsatu,
        isnull([22],0) as duapuluhdua,
        isnull([23],0) as duapuluhtiga,
        isnull([24],0) as duapuluhempat,
        isnull([25],0) as duapuluhlima,
        isnull([26],0) as duapuluhenam,
        isnull([27],0) as duapuluhtujuh,
        isnull([28],0) as duapuluhdelapan,
        isnull([29],0) as duapuluhlsembilan,
        isnull([30],0) as tigapuluh,
        isnull([31],0) as tigapuluhsatu,
        (isnull([01],0)+
        isnull([02],0)+
        isnull([03],0)+
        isnull([04],0)+
        isnull([05],0)+
        isnull([06],0)+
        isnull([07],0)+
        isnull([08],0)+
        isnull([09],0)+
        isnull([10],0)+
        isnull([11],0)+
        isnull([12],0)+
        isnull([13],0)+
        isnull([14],0)+
        isnull([15],0)+
        isnull([16],0)+
        isnull([17],0)+
        isnull([18],0)+
        isnull([19],0)+
        isnull([20],0)+
        isnull([21],0)+
        isnull([22],0)+
        isnull([23],0)+
        isnull([24],0)+
        isnull([25],0)+
        isnull([26],0)+
        isnull([27],0)+
        isnull([28],0)+
        isnull([29],0)+
        isnull([30],0)+
        isnull([31],0))
             as TOTAL
                  FROM (
                       select a.NamaUnit, a.NamaDokter,
                       SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                      count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                      from DashboardData.dbo.dataRWJ a
                      where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
                     and a.IdUnit not in ('9','10','47','48','49','52','17','1','53')
                      group by a.NamaUnit,a.NamaDokter,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                       
                  ) AS QuarterlyData
                  PIVOT( SUM([REGISTRASI Count])   
                          FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
          [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
          [25],[26],[27],[28],[29],[30],[31],
                          [grandtotal])) AS QPivot
                          order by NamaUnit asc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaUnit'];
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '6' && $JenisRekap == '2') {
                //     $query = "SELECT NamaUnit,First_Name as NamaDokter,
                //     isnull([01],0) as satu,
                // isnull([02],0) as dua,
                // isnull([03],0) as tiga,
                // isnull([04],0) as empat,
                // isnull([05],0) as lima,
                // isnull([06],0) as enam,
                // isnull([07],0) as Jtujuh,
                // isnull([08],0) as delapan,
                // isnull([09],0) as sembilan,
                // isnull([10],0) as sepuluh,
                // isnull([11],0) as sebelah,
                // isnull([12],0) as duabelas,
                // isnull([13],0) as tigabelas,
                // isnull([14],0) as empatbelas,
                // isnull([15],0) as limabelas,
                // isnull([16],0) as enambelas,
                // isnull([17],0) as tujuhbelas,
                // isnull([18],0) as delapanbelas,
                // isnull([19],0) as sembilanbelas,
                // isnull([20],0) as duapuluh,
                // isnull([21],0) as duapuluhsatu,
                // isnull([22],0) as duapuluhdua,
                // isnull([23],0) as duapuluhtiga,
                // isnull([24],0) as duapuluhempat,
                // isnull([25],0) as duapuluhlima,
                // isnull([26],0) as duapuluhenam,
                // isnull([27],0) as duapuluhtujuh,
                // isnull([28],0) as duapuluhdelapan,
                // isnull([29],0) as duapuluhlsembilan,
                // isnull([30],0) as tigapuluh,
                // isnull([31],0) as tigapuluhsatu,
                // (isnull([01],0)+
                // isnull([02],0)+
                // isnull([03],0)+
                // isnull([04],0)+
                // isnull([05],0)+
                // isnull([06],0)+
                // isnull([07],0)+
                // isnull([08],0)+
                // isnull([09],0)+
                // isnull([10],0)+
                // isnull([11],0)+
                // isnull([12],0)+
                // isnull([13],0)+
                // isnull([14],0)+
                // isnull([15],0)+
                // isnull([16],0)+
                // isnull([17],0)+
                // isnull([18],0)+
                // isnull([19],0)+
                // isnull([20],0)+
                // isnull([21],0)+
                // isnull([22],0)+
                // isnull([23],0)+
                // isnull([24],0)+
                // isnull([25],0)+
                // isnull([26],0)+
                // isnull([27],0)+
                // isnull([28],0)+
                // isnull([29],0)+
                // isnull([30],0)+
                // isnull([31],0))
                //      as TOTAL
                //           FROM (
                //                select pg.NamaUnit, c.First_Name,
                //                SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2) [Quarter],
                //               count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                //               from PerawatanSQL.dbo.Visit a
                //               inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                //               inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                //               inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                //               inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                //               left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                //               where SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),1,7)=:Periode
                //               and a.Batal='0'   
                //              and pg.id  in ('47')
                //               group by pg.NamaUnit,c.First_Name,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2)

                //           ) AS QuarterlyData
                //           PIVOT( SUM([REGISTRASI Count])   
                //                   FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
                //   [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
                //   [25],[26],[27],[28],[29],[30],[31],
                //                   [grandtotal])) AS QPivot
                //                   order by NamaUnit asc";
                $query = "	SELECT NamaUnit, NamaDokter,
                               isnull([01],0) as satu,
                           isnull([02],0) as dua,
                           isnull([03],0) as tiga,
                           isnull([04],0) as empat,
                           isnull([05],0) as lima,
                           isnull([06],0) as enam,
                           isnull([07],0) as Jtujuh,
                           isnull([08],0) as delapan,
                           isnull([09],0) as sembilan,
                           isnull([10],0) as sepuluh,
                           isnull([11],0) as sebelah,
                           isnull([12],0) as duabelas,
                           isnull([13],0) as tigabelas,
                           isnull([14],0) as empatbelas,
                           isnull([15],0) as limabelas,
                           isnull([16],0) as enambelas,
                           isnull([17],0) as tujuhbelas,
                           isnull([18],0) as delapanbelas,
                           isnull([19],0) as sembilanbelas,
                           isnull([20],0) as duapuluh,
                           isnull([21],0) as duapuluhsatu,
                           isnull([22],0) as duapuluhdua,
                           isnull([23],0) as duapuluhtiga,
                           isnull([24],0) as duapuluhempat,
                           isnull([25],0) as duapuluhlima,
                           isnull([26],0) as duapuluhenam,
                           isnull([27],0) as duapuluhtujuh,
                           isnull([28],0) as duapuluhdelapan,
                           isnull([29],0) as duapuluhlsembilan,
                           isnull([30],0) as tigapuluh,
                           isnull([31],0) as tigapuluhsatu,
                           (isnull([01],0)+
                           isnull([02],0)+
                           isnull([03],0)+
                           isnull([04],0)+
                           isnull([05],0)+
                           isnull([06],0)+
                           isnull([07],0)+
                           isnull([08],0)+
                           isnull([09],0)+
                           isnull([10],0)+
                           isnull([11],0)+
                           isnull([12],0)+
                           isnull([13],0)+
                           isnull([14],0)+
                           isnull([15],0)+
                           isnull([16],0)+
                           isnull([17],0)+
                           isnull([18],0)+
                           isnull([19],0)+
                           isnull([20],0)+
                           isnull([21],0)+
                           isnull([22],0)+
                           isnull([23],0)+
                           isnull([24],0)+
                           isnull([25],0)+
                           isnull([26],0)+
                           isnull([27],0)+
                           isnull([28],0)+
                           isnull([29],0)+
                           isnull([30],0)+
                           isnull([31],0))
                                as TOTAL
                                     FROM (
                                          select a.NamaUnit, a.NamaDokter,
                                          SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                                         count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                                         from DashboardData.dbo.dataRWJ a
                                         where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
                                        and a.IdUnit in ('47')
                                         group by a.NamaUnit,a.NamaDokter,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                                          
                                     ) AS QuarterlyData
                                     PIVOT( SUM([REGISTRASI Count])   
                                             FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
                             [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
                             [25],[26],[27],[28],[29],[30],[31],
                                             [grandtotal])) AS QPivot
                                             order by NamaUnit asc";



                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaUnit'];
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '7' && $JenisRekap == '2') {
                //     $query = "SELECT NamaUnit,First_Name as NamaDokter,
                //     isnull([01],0) as satu,
                // isnull([02],0) as dua,
                // isnull([03],0) as tiga,
                // isnull([04],0) as empat,
                // isnull([05],0) as lima,
                // isnull([06],0) as enam,
                // isnull([07],0) as Jtujuh,
                // isnull([08],0) as delapan,
                // isnull([09],0) as sembilan,
                // isnull([10],0) as sepuluh,
                // isnull([11],0) as sebelah,
                // isnull([12],0) as duabelas,
                // isnull([13],0) as tigabelas,
                // isnull([14],0) as empatbelas,
                // isnull([15],0) as limabelas,
                // isnull([16],0) as enambelas,
                // isnull([17],0) as tujuhbelas,
                // isnull([18],0) as delapanbelas,
                // isnull([19],0) as sembilanbelas,
                // isnull([20],0) as duapuluh,
                // isnull([21],0) as duapuluhsatu,
                // isnull([22],0) as duapuluhdua,
                // isnull([23],0) as duapuluhtiga,
                // isnull([24],0) as duapuluhempat,
                // isnull([25],0) as duapuluhlima,
                // isnull([26],0) as duapuluhenam,
                // isnull([27],0) as duapuluhtujuh,
                // isnull([28],0) as duapuluhdelapan,
                // isnull([29],0) as duapuluhlsembilan,
                // isnull([30],0) as tigapuluh,
                // isnull([31],0) as tigapuluhsatu,
                // (isnull([01],0)+
                // isnull([02],0)+
                // isnull([03],0)+
                // isnull([04],0)+
                // isnull([05],0)+
                // isnull([06],0)+
                // isnull([07],0)+
                // isnull([08],0)+
                // isnull([09],0)+
                // isnull([10],0)+
                // isnull([11],0)+
                // isnull([12],0)+
                // isnull([13],0)+
                // isnull([14],0)+
                // isnull([15],0)+
                // isnull([16],0)+
                // isnull([17],0)+
                // isnull([18],0)+
                // isnull([19],0)+
                // isnull([20],0)+
                // isnull([21],0)+
                // isnull([22],0)+
                // isnull([23],0)+
                // isnull([24],0)+
                // isnull([25],0)+
                // isnull([26],0)+
                // isnull([27],0)+
                // isnull([28],0)+
                // isnull([29],0)+
                // isnull([30],0)+
                // isnull([31],0))
                //      as TOTAL
                //           FROM (
                //                select pg.NamaUnit, c.First_Name,
                //                SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2) [Quarter],
                //               count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                //               from PerawatanSQL.dbo.Visit a
                //               inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                //               inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                //               inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                //               inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                //               left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                //               where SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),1,7)=:Periode
                //                and a.Batal='0'  
                //                 and pg.id  in ('9','10','48','49','52','17')
                //               group by pg.NamaUnit,c.First_Name,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2)

                //           ) AS QuarterlyData
                //           PIVOT( SUM([REGISTRASI Count])   
                //                   FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
                //   [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
                //   [25],[26],[27],[28],[29],[30],[31],
                //                   [grandtotal])) AS QPivot
                //                   order by NamaUnit asc";
                $query = "	SELECT NamaUnit, NamaDokter,
            isnull([01],0) as satu,
        isnull([02],0) as dua,
        isnull([03],0) as tiga,
        isnull([04],0) as empat,
        isnull([05],0) as lima,
        isnull([06],0) as enam,
        isnull([07],0) as Jtujuh,
        isnull([08],0) as delapan,
        isnull([09],0) as sembilan,
        isnull([10],0) as sepuluh,
        isnull([11],0) as sebelah,
        isnull([12],0) as duabelas,
        isnull([13],0) as tigabelas,
        isnull([14],0) as empatbelas,
        isnull([15],0) as limabelas,
        isnull([16],0) as enambelas,
        isnull([17],0) as tujuhbelas,
        isnull([18],0) as delapanbelas,
        isnull([19],0) as sembilanbelas,
        isnull([20],0) as duapuluh,
        isnull([21],0) as duapuluhsatu,
        isnull([22],0) as duapuluhdua,
        isnull([23],0) as duapuluhtiga,
        isnull([24],0) as duapuluhempat,
        isnull([25],0) as duapuluhlima,
        isnull([26],0) as duapuluhenam,
        isnull([27],0) as duapuluhtujuh,
        isnull([28],0) as duapuluhdelapan,
        isnull([29],0) as duapuluhlsembilan,
        isnull([30],0) as tigapuluh,
        isnull([31],0) as tigapuluhsatu,
        (isnull([01],0)+
        isnull([02],0)+
        isnull([03],0)+
        isnull([04],0)+
        isnull([05],0)+
        isnull([06],0)+
        isnull([07],0)+
        isnull([08],0)+
        isnull([09],0)+
        isnull([10],0)+
        isnull([11],0)+
        isnull([12],0)+
        isnull([13],0)+
        isnull([14],0)+
        isnull([15],0)+
        isnull([16],0)+
        isnull([17],0)+
        isnull([18],0)+
        isnull([19],0)+
        isnull([20],0)+
        isnull([21],0)+
        isnull([22],0)+
        isnull([23],0)+
        isnull([24],0)+
        isnull([25],0)+
        isnull([26],0)+
        isnull([27],0)+
        isnull([28],0)+
        isnull([29],0)+
        isnull([30],0)+
        isnull([31],0))
             as TOTAL
                  FROM (
                       select a.NamaUnit, a.NamaDokter,
                       SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                      count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                      from DashboardData.dbo.dataRWJ a
                      where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
                     and a.IdUnit in ('9','10','48','49','52','17')
                      group by a.NamaUnit,a.NamaDokter,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                       
                  ) AS QuarterlyData
                  PIVOT( SUM([REGISTRASI Count])   
                          FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
          [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
          [25],[26],[27],[28],[29],[30],[31],
                          [grandtotal])) AS QPivot
                          order by NamaUnit asc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaUnit'];
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '2' && $JenisRekap == '2') {
                $query = "SELECT NamaUnit,First_Name as NamaDokter,
                isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
			isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
			isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
			isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
			isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
			isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
			isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
			isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0))
                 as TOTAL
        FROM (
             select pg.NamaUnit, c.First_Name,
             SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2) [Quarter],
            count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
            from PerawatanSQL.dbo.Visit a
            inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
            inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
            inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
            inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
            left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
            where SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),1,7)=:Periode
            and a.Batal='0' and pg.id  in ('1') 
            group by pg.NamaUnit,c.First_Name,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2)
             
        ) AS QuarterlyData
        PIVOT( SUM([REGISTRASI Count])   
                FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31],
                [grandtotal])) AS QPivot
                order by NamaUnit asc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaUnit'];
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '3' && $JenisRekap == '2') {
                $query = "SELECT NamaUnit,First_Name as NamaDokter,
                isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
			isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
			isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
			isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
			isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
			isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
			isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
			isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0))
                 as TOTAL
        FROM (
             select pg.NamaUnit, c.First_Name,
             SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2) [Quarter],
            count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
            from PerawatanSQL.dbo.Visit a
            inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
            inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
            inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
            inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
            left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
            where SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),1,7)=:Periode
            and a.Batal='0'  
            AND PG.ID='53'  
            group by pg.NamaUnit,c.First_Name,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2)
             
        ) AS QuarterlyData
        PIVOT( SUM([REGISTRASI Count])   
                FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31],
                [grandtotal])) AS QPivot
                order by NamaUnit asc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaUnit'];
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '4' && $JenisRekap == '2') {
                $query = "SELECT JenisRawat,First_Name as NamaDokter,
                isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
			isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
			isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
			isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
			isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
			isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
			isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
			isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0))
                 as TOTAL
        FROM (
             select  a.JenisRawat,c.First_Name,
             SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),6,2) [Quarter],
            count(isnull(a.drPenerima,0)) as  [REGISTRASI Count]
            from RawatInapSQL.dbo.Inpatient a
            inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
            inner join MasterdataSQL.dbo.Doctors c on c.ID = a.drPenerima
            where YEAR(a.StartDate)=:Periode 
            group by a.JenisRawat,c.First_Name,SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),6,2)
            ) AS QuarterlyData
                    PIVOT( SUM([REGISTRASI Count])   
                            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31],
                            [grandtotal])) AS QPivot
                            order by JenisRawat asc
            ";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['JenisRawat'];
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '5' && $JenisRekap == '2') {
                $query = "SELECT GroupSpesialis,DrOperator as NamaDokter,
                isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
			isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
			isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
			isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
			isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
			isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
			isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
			isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0))
                 as TOTAL
        FROM (
             select  d.GroupSpesialis,d.DrOperator,
             SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),6,2) [Quarter],
            count(isnull(a.drPenerima,0)) as  [REGISTRASI Count]
            from RawatInapSQL.dbo.Inpatient a
            inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
            inner join MedicalRecord.dbo.EMR_OrderOperasi d on a.NoRegRI  collate SQL_Latin1_General_CP1_CI_AS=d.NoRegistrasi  collate SQL_Latin1_General_CP1_CI_AS
            where YEAR(a.StartDate)=:Periode and d.StatusOrder='Approved OT' 
            group by d.GroupSpesialis,d.DrOperator,SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),6,2)
             
        ) AS QuarterlyData
        PIVOT( SUM([REGISTRASI Count])   
                FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31],
                [grandtotal])) AS QPivot
                order by GroupSpesialis asc
            ";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['GroupSpesialis'];
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '1' && $JenisRekap == '4') {
                //     $query = "SELECT NamaUnit,
                //     isnull([01],0) as satu,
                // isnull([02],0) as dua,
                // isnull([03],0) as tiga,
                // isnull([04],0) as empat,
                // isnull([05],0) as lima,
                // isnull([06],0) as enam,
                // isnull([07],0) as Jtujuh,
                // isnull([08],0) as delapan,
                // isnull([09],0) as sembilan,
                // isnull([10],0) as sepuluh,
                // isnull([11],0) as sebelah,
                // isnull([12],0) as duabelas,
                // isnull([13],0) as tigabelas,
                // isnull([14],0) as empatbelas,
                // isnull([15],0) as limabelas,
                // isnull([16],0) as enambelas,
                // isnull([17],0) as tujuhbelas,
                // isnull([18],0) as delapanbelas,
                // isnull([19],0) as sembilanbelas,
                // isnull([20],0) as duapuluh,
                // isnull([21],0) as duapuluhsatu,
                // isnull([22],0) as duapuluhdua,
                // isnull([23],0) as duapuluhtiga,
                // isnull([24],0) as duapuluhempat,
                // isnull([25],0) as duapuluhlima,
                // isnull([26],0) as duapuluhenam,
                // isnull([27],0) as duapuluhtujuh,
                // isnull([28],0) as duapuluhdelapan,
                // isnull([29],0) as duapuluhlsembilan,
                // isnull([30],0) as tigapuluh,
                // isnull([31],0) as tigapuluhsatu,
                // (isnull([01],0)+
                // isnull([02],0)+
                // isnull([03],0)+
                // isnull([04],0)+
                // isnull([05],0)+
                // isnull([06],0)+
                // isnull([07],0)+
                // isnull([08],0)+
                // isnull([09],0)+
                // isnull([10],0)+
                // isnull([11],0)+
                // isnull([12],0)+
                // isnull([13],0)+
                // isnull([14],0)+
                // isnull([15],0)+
                // isnull([16],0)+
                // isnull([17],0)+
                // isnull([18],0)+
                // isnull([19],0)+
                // isnull([20],0)+
                // isnull([21],0)+
                // isnull([22],0)+
                // isnull([23],0)+
                // isnull([24],0)+
                // isnull([25],0)+
                // isnull([26],0)+
                // isnull([27],0)+
                // isnull([28],0)+
                // isnull([29],0)+
                // isnull([30],0)+
                // isnull([31],0))
                //      as TOTAL
                //           FROM (
                //                select pg.NamaUnit,
                //                SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2) [Quarter],
                //               count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                //               from PerawatanSQL.dbo.Visit a
                //               inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                //               inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                //               inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                //               inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                //               left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                //               where SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),1,7)=:Periode
                //               and a.Batal='0'   and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG')  
                //               and pg.id not in  ('9','10','47','48','49','52','17','1','52','53')
                //               group by pg.NamaUnit,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2)

                //           ) AS QuarterlyData
                //           PIVOT( SUM([REGISTRASI Count])   
                //                   FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
                //   [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
                //   [25],[26],[27],[28],[29],[30],[31],
                //                   [grandtotal])) AS QPivot
                //                   order by NamaUnit asc";

                $query = "SELECT NamaUnit,
            isnull([01],0) as satu,
        isnull([02],0) as dua,
        isnull([03],0) as tiga,
        isnull([04],0) as empat,
        isnull([05],0) as lima,
        isnull([06],0) as enam,
        isnull([07],0) as Jtujuh,
        isnull([08],0) as delapan,
        isnull([09],0) as sembilan,
        isnull([10],0) as sepuluh,
        isnull([11],0) as sebelah,
        isnull([12],0) as duabelas,
        isnull([13],0) as tigabelas,
        isnull([14],0) as empatbelas,
        isnull([15],0) as limabelas,
        isnull([16],0) as enambelas,
        isnull([17],0) as tujuhbelas,
        isnull([18],0) as delapanbelas,
        isnull([19],0) as sembilanbelas,
        isnull([20],0) as duapuluh,
        isnull([21],0) as duapuluhsatu,
        isnull([22],0) as duapuluhdua,
        isnull([23],0) as duapuluhtiga,
        isnull([24],0) as duapuluhempat,
        isnull([25],0) as duapuluhlima,
        isnull([26],0) as duapuluhenam,
        isnull([27],0) as duapuluhtujuh,
        isnull([28],0) as duapuluhdelapan,
        isnull([29],0) as duapuluhlsembilan,
        isnull([30],0) as tigapuluh,
        isnull([31],0) as tigapuluhsatu,
        (isnull([01],0)+
        isnull([02],0)+
        isnull([03],0)+
        isnull([04],0)+
        isnull([05],0)+
        isnull([06],0)+
        isnull([07],0)+
        isnull([08],0)+
        isnull([09],0)+
        isnull([10],0)+
        isnull([11],0)+
        isnull([12],0)+
        isnull([13],0)+
        isnull([14],0)+
        isnull([15],0)+
        isnull([16],0)+
        isnull([17],0)+
        isnull([18],0)+
        isnull([19],0)+
        isnull([20],0)+
        isnull([21],0)+
        isnull([22],0)+
        isnull([23],0)+
        isnull([24],0)+
        isnull([25],0)+
        isnull([26],0)+
        isnull([27],0)+
        isnull([28],0)+
        isnull([29],0)+
        isnull([30],0)+
        isnull([31],0))
             as TOTAL
                  FROM (
                       select a.NamaUnit,
                       SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                      count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                      from DashboardData.dbo.dataRWJ a
                      where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
                      and IdUnit not in  ('9','10','47','48','49','52','17','1','52','53')
                      group by a.NamaUnit,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                       
                  ) AS QuarterlyData
                  PIVOT( SUM([REGISTRASI Count])   
                          FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
          [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
          [25],[26],[27],[28],[29],[30],[31],
                          [grandtotal])) AS QPivot
                          order by NamaUnit asc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaUnit'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '2' && $JenisRekap == '4') {
                //     $query = "SELECT NamaUnit,
                //     isnull([01],0) as satu,
                // isnull([02],0) as dua,
                // isnull([03],0) as tiga,
                // isnull([04],0) as empat,
                // isnull([05],0) as lima,
                // isnull([06],0) as enam,
                // isnull([07],0) as Jtujuh,
                // isnull([08],0) as delapan,
                // isnull([09],0) as sembilan,
                // isnull([10],0) as sepuluh,
                // isnull([11],0) as sebelah,
                // isnull([12],0) as duabelas,
                // isnull([13],0) as tigabelas,
                // isnull([14],0) as empatbelas,
                // isnull([15],0) as limabelas,
                // isnull([16],0) as enambelas,
                // isnull([17],0) as tujuhbelas,
                // isnull([18],0) as delapanbelas,
                // isnull([19],0) as sembilanbelas,
                // isnull([20],0) as duapuluh,
                // isnull([21],0) as duapuluhsatu,
                // isnull([22],0) as duapuluhdua,
                // isnull([23],0) as duapuluhtiga,
                // isnull([24],0) as duapuluhempat,
                // isnull([25],0) as duapuluhlima,
                // isnull([26],0) as duapuluhenam,
                // isnull([27],0) as duapuluhtujuh,
                // isnull([28],0) as duapuluhdelapan,
                // isnull([29],0) as duapuluhlsembilan,
                // isnull([30],0) as tigapuluh,
                // isnull([31],0) as tigapuluhsatu,
                // (isnull([01],0)+
                // isnull([02],0)+
                // isnull([03],0)+
                // isnull([04],0)+
                // isnull([05],0)+
                // isnull([06],0)+
                // isnull([07],0)+
                // isnull([08],0)+
                // isnull([09],0)+
                // isnull([10],0)+
                // isnull([11],0)+
                // isnull([12],0)+
                // isnull([13],0)+
                // isnull([14],0)+
                // isnull([15],0)+
                // isnull([16],0)+
                // isnull([17],0)+
                // isnull([18],0)+
                // isnull([19],0)+
                // isnull([20],0)+
                // isnull([21],0)+
                // isnull([22],0)+
                // isnull([23],0)+
                // isnull([24],0)+
                // isnull([25],0)+
                // isnull([26],0)+
                // isnull([27],0)+
                // isnull([28],0)+
                // isnull([29],0)+
                // isnull([30],0)+
                // isnull([31],0))
                //      as TOTAL
                //           FROM (
                //                select pg.NamaUnit,
                //                SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2) [Quarter],
                //               count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                //               from PerawatanSQL.dbo.Visit a
                //               inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                //               inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                //               inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                //               inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                //               left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                //               where SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),1,7)=:Periode
                //               and a.Batal='0'   
                //               and pg.id in  ('1')
                //               group by pg.NamaUnit,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2)

                //           ) AS QuarterlyData
                //           PIVOT( SUM([REGISTRASI Count])   
                //                   FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
                //   [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
                //   [25],[26],[27],[28],[29],[30],[31],
                //                   [grandtotal])) AS QPivot
                //                   order by NamaUnit asc";

                $query = "SELECT NamaUnit,
            isnull([01],0) as satu,
        isnull([02],0) as dua,
        isnull([03],0) as tiga,
        isnull([04],0) as empat,
        isnull([05],0) as lima,
        isnull([06],0) as enam,
        isnull([07],0) as Jtujuh,
        isnull([08],0) as delapan,
        isnull([09],0) as sembilan,
        isnull([10],0) as sepuluh,
        isnull([11],0) as sebelah,
        isnull([12],0) as duabelas,
        isnull([13],0) as tigabelas,
        isnull([14],0) as empatbelas,
        isnull([15],0) as limabelas,
        isnull([16],0) as enambelas,
        isnull([17],0) as tujuhbelas,
        isnull([18],0) as delapanbelas,
        isnull([19],0) as sembilanbelas,
        isnull([20],0) as duapuluh,
        isnull([21],0) as duapuluhsatu,
        isnull([22],0) as duapuluhdua,
        isnull([23],0) as duapuluhtiga,
        isnull([24],0) as duapuluhempat,
        isnull([25],0) as duapuluhlima,
        isnull([26],0) as duapuluhenam,
        isnull([27],0) as duapuluhtujuh,
        isnull([28],0) as duapuluhdelapan,
        isnull([29],0) as duapuluhlsembilan,
        isnull([30],0) as tigapuluh,
        isnull([31],0) as tigapuluhsatu,
        (isnull([01],0)+
        isnull([02],0)+
        isnull([03],0)+
        isnull([04],0)+
        isnull([05],0)+
        isnull([06],0)+
        isnull([07],0)+
        isnull([08],0)+
        isnull([09],0)+
        isnull([10],0)+
        isnull([11],0)+
        isnull([12],0)+
        isnull([13],0)+
        isnull([14],0)+
        isnull([15],0)+
        isnull([16],0)+
        isnull([17],0)+
        isnull([18],0)+
        isnull([19],0)+
        isnull([20],0)+
        isnull([21],0)+
        isnull([22],0)+
        isnull([23],0)+
        isnull([24],0)+
        isnull([25],0)+
        isnull([26],0)+
        isnull([27],0)+
        isnull([28],0)+
        isnull([29],0)+
        isnull([30],0)+
        isnull([31],0))
             as TOTAL
                  FROM (
                       select a.NamaUnit,
                       SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                      count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                      from DashboardData.dbo.dataRWJ a
                      where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
                      and IdUnit in  ('1')
                      group by a.NamaUnit,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                       
                  ) AS QuarterlyData
                  PIVOT( SUM([REGISTRASI Count])   
                          FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
          [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
          [25],[26],[27],[28],[29],[30],[31],
                          [grandtotal])) AS QPivot
                          order by NamaUnit asc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaUnit'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '3' && $JenisRekap == '4') {
                //     $query = "SELECT NamaUnit,
                //     isnull([01],0) as satu,
                // isnull([02],0) as dua,
                // isnull([03],0) as tiga,
                // isnull([04],0) as empat,
                // isnull([05],0) as lima,
                // isnull([06],0) as enam,
                // isnull([07],0) as Jtujuh,
                // isnull([08],0) as delapan,
                // isnull([09],0) as sembilan,
                // isnull([10],0) as sepuluh,
                // isnull([11],0) as sebelah,
                // isnull([12],0) as duabelas,
                // isnull([13],0) as tigabelas,
                // isnull([14],0) as empatbelas,
                // isnull([15],0) as limabelas,
                // isnull([16],0) as enambelas,
                // isnull([17],0) as tujuhbelas,
                // isnull([18],0) as delapanbelas,
                // isnull([19],0) as sembilanbelas,
                // isnull([20],0) as duapuluh,
                // isnull([21],0) as duapuluhsatu,
                // isnull([22],0) as duapuluhdua,
                // isnull([23],0) as duapuluhtiga,
                // isnull([24],0) as duapuluhempat,
                // isnull([25],0) as duapuluhlima,
                // isnull([26],0) as duapuluhenam,
                // isnull([27],0) as duapuluhtujuh,
                // isnull([28],0) as duapuluhdelapan,
                // isnull([29],0) as duapuluhlsembilan,
                // isnull([30],0) as tigapuluh,
                // isnull([31],0) as tigapuluhsatu,
                // (isnull([01],0)+
                // isnull([02],0)+
                // isnull([03],0)+
                // isnull([04],0)+
                // isnull([05],0)+
                // isnull([06],0)+
                // isnull([07],0)+
                // isnull([08],0)+
                // isnull([09],0)+
                // isnull([10],0)+
                // isnull([11],0)+
                // isnull([12],0)+
                // isnull([13],0)+
                // isnull([14],0)+
                // isnull([15],0)+
                // isnull([16],0)+
                // isnull([17],0)+
                // isnull([18],0)+
                // isnull([19],0)+
                // isnull([20],0)+
                // isnull([21],0)+
                // isnull([22],0)+
                // isnull([23],0)+
                // isnull([24],0)+
                // isnull([25],0)+
                // isnull([26],0)+
                // isnull([27],0)+
                // isnull([28],0)+
                // isnull([29],0)+
                // isnull([30],0)+
                // isnull([31],0))
                //      as TOTAL
                //           FROM (
                //                select pg.NamaUnit,
                //                SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2) [Quarter],
                //               count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                //               from PerawatanSQL.dbo.Visit a
                //               inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                //               inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                //               inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                //               inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                //               left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                //               where SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),1,7)=:Periode
                //               and a.Batal='0'    
                //               and pg.id in  ('53')
                //               group by pg.NamaUnit,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2)

                //           ) AS QuarterlyData
                //           PIVOT( SUM([REGISTRASI Count])   
                //                   FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
                //   [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
                //   [25],[26],[27],[28],[29],[30],[31],
                //                   [grandtotal])) AS QPivot
                //                   order by NamaUnit asc";

                $query = "SELECT NamaUnit,
            isnull([01],0) as satu,
        isnull([02],0) as dua,
        isnull([03],0) as tiga,
        isnull([04],0) as empat,
        isnull([05],0) as lima,
        isnull([06],0) as enam,
        isnull([07],0) as Jtujuh,
        isnull([08],0) as delapan,
        isnull([09],0) as sembilan,
        isnull([10],0) as sepuluh,
        isnull([11],0) as sebelah,
        isnull([12],0) as duabelas,
        isnull([13],0) as tigabelas,
        isnull([14],0) as empatbelas,
        isnull([15],0) as limabelas,
        isnull([16],0) as enambelas,
        isnull([17],0) as tujuhbelas,
        isnull([18],0) as delapanbelas,
        isnull([19],0) as sembilanbelas,
        isnull([20],0) as duapuluh,
        isnull([21],0) as duapuluhsatu,
        isnull([22],0) as duapuluhdua,
        isnull([23],0) as duapuluhtiga,
        isnull([24],0) as duapuluhempat,
        isnull([25],0) as duapuluhlima,
        isnull([26],0) as duapuluhenam,
        isnull([27],0) as duapuluhtujuh,
        isnull([28],0) as duapuluhdelapan,
        isnull([29],0) as duapuluhlsembilan,
        isnull([30],0) as tigapuluh,
        isnull([31],0) as tigapuluhsatu,
        (isnull([01],0)+
        isnull([02],0)+
        isnull([03],0)+
        isnull([04],0)+
        isnull([05],0)+
        isnull([06],0)+
        isnull([07],0)+
        isnull([08],0)+
        isnull([09],0)+
        isnull([10],0)+
        isnull([11],0)+
        isnull([12],0)+
        isnull([13],0)+
        isnull([14],0)+
        isnull([15],0)+
        isnull([16],0)+
        isnull([17],0)+
        isnull([18],0)+
        isnull([19],0)+
        isnull([20],0)+
        isnull([21],0)+
        isnull([22],0)+
        isnull([23],0)+
        isnull([24],0)+
        isnull([25],0)+
        isnull([26],0)+
        isnull([27],0)+
        isnull([28],0)+
        isnull([29],0)+
        isnull([30],0)+
        isnull([31],0))
             as TOTAL
                  FROM (
                       select a.NamaUnit,
                       SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                      count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                      from DashboardData.dbo.dataRWJ a
                      where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
                      and IdUnit in  ('53')
                      group by a.NamaUnit,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                       
                  ) AS QuarterlyData
                  PIVOT( SUM([REGISTRASI Count])   
                          FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
          [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
          [25],[26],[27],[28],[29],[30],[31],
                          [grandtotal])) AS QPivot
                          order by NamaUnit asc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaUnit'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '6' && $JenisRekap == '4') {
                //     $query = "SELECT NamaUnit,
                //     isnull([01],0) as satu,
                // isnull([02],0) as dua,
                // isnull([03],0) as tiga,
                // isnull([04],0) as empat,
                // isnull([05],0) as lima,
                // isnull([06],0) as enam,
                // isnull([07],0) as Jtujuh,
                // isnull([08],0) as delapan,
                // isnull([09],0) as sembilan,
                // isnull([10],0) as sepuluh,
                // isnull([11],0) as sebelah,
                // isnull([12],0) as duabelas,
                // isnull([13],0) as tigabelas,
                // isnull([14],0) as empatbelas,
                // isnull([15],0) as limabelas,
                // isnull([16],0) as enambelas,
                // isnull([17],0) as tujuhbelas,
                // isnull([18],0) as delapanbelas,
                // isnull([19],0) as sembilanbelas,
                // isnull([20],0) as duapuluh,
                // isnull([21],0) as duapuluhsatu,
                // isnull([22],0) as duapuluhdua,
                // isnull([23],0) as duapuluhtiga,
                // isnull([24],0) as duapuluhempat,
                // isnull([25],0) as duapuluhlima,
                // isnull([26],0) as duapuluhenam,
                // isnull([27],0) as duapuluhtujuh,
                // isnull([28],0) as duapuluhdelapan,
                // isnull([29],0) as duapuluhlsembilan,
                // isnull([30],0) as tigapuluh,
                // isnull([31],0) as tigapuluhsatu,
                // (isnull([01],0)+
                // isnull([02],0)+
                // isnull([03],0)+
                // isnull([04],0)+
                // isnull([05],0)+
                // isnull([06],0)+
                // isnull([07],0)+
                // isnull([08],0)+
                // isnull([09],0)+
                // isnull([10],0)+
                // isnull([11],0)+
                // isnull([12],0)+
                // isnull([13],0)+
                // isnull([14],0)+
                // isnull([15],0)+
                // isnull([16],0)+
                // isnull([17],0)+
                // isnull([18],0)+
                // isnull([19],0)+
                // isnull([20],0)+
                // isnull([21],0)+
                // isnull([22],0)+
                // isnull([23],0)+
                // isnull([24],0)+
                // isnull([25],0)+
                // isnull([26],0)+
                // isnull([27],0)+
                // isnull([28],0)+
                // isnull([29],0)+
                // isnull([30],0)+
                // isnull([31],0))
                //      as TOTAL
                //           FROM (
                //                select pg.NamaUnit,
                //                SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2) [Quarter],
                //               count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                //               from PerawatanSQL.dbo.Visit a
                //               inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                //               inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                //               inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                //               inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                //               left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                //               where SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),1,7)=:Periode
                //               and a.Batal='0'   
                //               and pg.id in  ('47')
                //               group by pg.NamaUnit,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2)

                //           ) AS QuarterlyData
                //           PIVOT( SUM([REGISTRASI Count])   
                //                   FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
                //   [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
                //   [25],[26],[27],[28],[29],[30],[31],
                //                   [grandtotal])) AS QPivot
                //                   order by NamaUnit asc";
                $query = "SELECT NamaUnit,
            isnull([01],0) as satu,
        isnull([02],0) as dua,
        isnull([03],0) as tiga,
        isnull([04],0) as empat,
        isnull([05],0) as lima,
        isnull([06],0) as enam,
        isnull([07],0) as Jtujuh,
        isnull([08],0) as delapan,
        isnull([09],0) as sembilan,
        isnull([10],0) as sepuluh,
        isnull([11],0) as sebelah,
        isnull([12],0) as duabelas,
        isnull([13],0) as tigabelas,
        isnull([14],0) as empatbelas,
        isnull([15],0) as limabelas,
        isnull([16],0) as enambelas,
        isnull([17],0) as tujuhbelas,
        isnull([18],0) as delapanbelas,
        isnull([19],0) as sembilanbelas,
        isnull([20],0) as duapuluh,
        isnull([21],0) as duapuluhsatu,
        isnull([22],0) as duapuluhdua,
        isnull([23],0) as duapuluhtiga,
        isnull([24],0) as duapuluhempat,
        isnull([25],0) as duapuluhlima,
        isnull([26],0) as duapuluhenam,
        isnull([27],0) as duapuluhtujuh,
        isnull([28],0) as duapuluhdelapan,
        isnull([29],0) as duapuluhlsembilan,
        isnull([30],0) as tigapuluh,
        isnull([31],0) as tigapuluhsatu,
        (isnull([01],0)+
        isnull([02],0)+
        isnull([03],0)+
        isnull([04],0)+
        isnull([05],0)+
        isnull([06],0)+
        isnull([07],0)+
        isnull([08],0)+
        isnull([09],0)+
        isnull([10],0)+
        isnull([11],0)+
        isnull([12],0)+
        isnull([13],0)+
        isnull([14],0)+
        isnull([15],0)+
        isnull([16],0)+
        isnull([17],0)+
        isnull([18],0)+
        isnull([19],0)+
        isnull([20],0)+
        isnull([21],0)+
        isnull([22],0)+
        isnull([23],0)+
        isnull([24],0)+
        isnull([25],0)+
        isnull([26],0)+
        isnull([27],0)+
        isnull([28],0)+
        isnull([29],0)+
        isnull([30],0)+
        isnull([31],0))
             as TOTAL
                  FROM (
                       select a.NamaUnit,
                       SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                      count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                      from DashboardData.dbo.dataRWJ a
                      where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
                      and IdUnit in  ('47')
                      group by a.NamaUnit,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                       
                  ) AS QuarterlyData
                  PIVOT( SUM([REGISTRASI Count])   
                          FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
          [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
          [25],[26],[27],[28],[29],[30],[31],
                          [grandtotal])) AS QPivot
                          order by NamaUnit asc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaUnit'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '1' && $JenisRekap == '6') {
                //     $query = "SELECT NamaPerusahaan  ,
                // isnull([01],0) as satu,
                // isnull([02],0) as dua,
                // isnull([03],0) as tiga,
                // isnull([04],0) as empat,
                // isnull([05],0) as lima,
                // isnull([06],0) as enam,
                // isnull([07],0) as Jtujuh,
                // isnull([08],0) as delapan,
                // isnull([09],0) as sembilan,
                // isnull([10],0) as sepuluh,
                // isnull([11],0) as sebelah,
                // isnull([12],0) as duabelas,
                // isnull([13],0) as tigabelas,
                // isnull([14],0) as empatbelas,
                // isnull([15],0) as limabelas,
                // isnull([16],0) as enambelas,
                // isnull([17],0) as tujuhbelas,
                // isnull([18],0) as delapanbelas,
                // isnull([19],0) as sembilanbelas,
                // isnull([20],0) as duapuluh,
                // isnull([21],0) as duapuluhsatu,
                // isnull([22],0) as duapuluhdua,
                // isnull([23],0) as duapuluhtiga,
                // isnull([24],0) as duapuluhempat,
                // isnull([25],0) as duapuluhlima,
                // isnull([26],0) as duapuluhenam,
                // isnull([27],0) as duapuluhtujuh,
                // isnull([28],0) as duapuluhdelapan,
                // isnull([29],0) as duapuluhlsembilan,
                // isnull([30],0) as tigapuluh,
                // isnull([31],0) as tigapuluhsatu,
                // (isnull([01],0)+
                // isnull([02],0)+
                // isnull([03],0)+
                // isnull([04],0)+
                // isnull([05],0)+
                // isnull([06],0)+
                // isnull([07],0)+
                // isnull([08],0)+
                // isnull([09],0)+
                // isnull([10],0)+
                // isnull([11],0)+
                // isnull([12],0)+
                // isnull([13],0)+
                // isnull([14],0)+
                // isnull([15],0)+
                // isnull([16],0)+
                // isnull([17],0)+
                // isnull([18],0)+
                // isnull([19],0)+
                // isnull([20],0)+
                // isnull([21],0)+
                // isnull([22],0)+
                // isnull([23],0)+
                // isnull([24],0)+
                // isnull([25],0)+
                // isnull([26],0)+
                // isnull([27],0)+
                // isnull([28],0)+
                // isnull([29],0)+
                // isnull([30],0)+
                // isnull([31],0))
                //  as TOTAL
                //     FROM (
                //         select  oc.NamaPerusahaan,
                //         SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2) [Quarter],
                //         count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                //         from PerawatanSQL.dbo.Visit a
                //         inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                //         inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                //         inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                //         inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                //         left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                //         inner join MasterdataSQL.dbo.MstrPerusahaanJPK OC ON OC.ID = A.Perusahaan
                //         where SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),1,7)=:Periode
                //     and a.Batal='0'   and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG') 
                //         AND PG.ID<>'53' 
                //         and pg.id not in ('9','10','47','48','49','52','17','1','53')
                //     and a.PatientType<>'2'
                //         group by oc.NamaPerusahaan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2)

                //     ) AS QuarterlyData
                //     PIVOT( SUM([REGISTRASI Count])   
                // FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
                //   [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
                //   [25],[26],[27],[28],[29],[30],[31],
                // [grandtotal])) AS QPivot";
                $query = "SELECT NamaPerusahaan  ,
            isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
            isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
            isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
            isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
            isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
            isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
            isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
            isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0))
             as TOTAL
                FROM (
                    select  a.NamaJaminan as NamaPerusahaan,
                    SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                    count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                    from DashboardData.dbo.dataRWJ a
                    --inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                    --inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                    --inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                    --inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                    --left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                    --inner join MasterdataSQL.dbo.MstrPerusahaanJPK OC ON OC.ID = A.Perusahaan
                    where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7):Periode
                --and a.Batal='0'   and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG') 
                  --  AND PG.ID<>'53' 
                    and a.IdUnit not in ('9','10','47','48','49','52','17','1','53')
                and a.TipePasien<>'2'
                    group by a.NamaJaminan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                    
                ) AS QuarterlyData
                PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31],
            [grandtotal])) AS QPivot";


                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaPerusahaan'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '1' && $JenisRekap == '7') {
                //     $query = "SELECT NamaPerusahaan  ,
                // isnull([01],0) as satu,
                // isnull([02],0) as dua,
                // isnull([03],0) as tiga,
                // isnull([04],0) as empat,
                // isnull([05],0) as lima,
                // isnull([06],0) as enam,
                // isnull([07],0) as Jtujuh,
                // isnull([08],0) as delapan,
                // isnull([09],0) as sembilan,
                // isnull([10],0) as sepuluh,
                // isnull([11],0) as sebelah,
                // isnull([12],0) as duabelas,
                // isnull([13],0) as tigabelas,
                // isnull([14],0) as empatbelas,
                // isnull([15],0) as limabelas,
                // isnull([16],0) as enambelas,
                // isnull([17],0) as tujuhbelas,
                // isnull([18],0) as delapanbelas,
                // isnull([19],0) as sembilanbelas,
                // isnull([20],0) as duapuluh,
                // isnull([21],0) as duapuluhsatu,
                // isnull([22],0) as duapuluhdua,
                // isnull([23],0) as duapuluhtiga,
                // isnull([24],0) as duapuluhempat,
                // isnull([25],0) as duapuluhlima,
                // isnull([26],0) as duapuluhenam,
                // isnull([27],0) as duapuluhtujuh,
                // isnull([28],0) as duapuluhdelapan,
                // isnull([29],0) as duapuluhlsembilan,
                // isnull([30],0) as tigapuluh,
                // isnull([31],0) as tigapuluhsatu,
                // (isnull([01],0)+
                // isnull([02],0)+
                // isnull([03],0)+
                // isnull([04],0)+
                // isnull([05],0)+
                // isnull([06],0)+
                // isnull([07],0)+
                // isnull([08],0)+
                // isnull([09],0)+
                // isnull([10],0)+
                // isnull([11],0)+
                // isnull([12],0)+
                // isnull([13],0)+
                // isnull([14],0)+
                // isnull([15],0)+
                // isnull([16],0)+
                // isnull([17],0)+
                // isnull([18],0)+
                // isnull([19],0)+
                // isnull([20],0)+
                // isnull([21],0)+
                // isnull([22],0)+
                // isnull([23],0)+
                // isnull([24],0)+
                // isnull([25],0)+
                // isnull([26],0)+
                // isnull([27],0)+
                // isnull([28],0)+
                // isnull([29],0)+
                // isnull([30],0)+
                // isnull([31],0))
                //  as TOTAL
                //     FROM (
                //         select  oc.NamaPerusahaan,
                //         SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2) [Quarter],
                //         count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                //         from PerawatanSQL.dbo.Visit a
                //         inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                //         inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                //         inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                //         inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                //         left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                //         inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi OC ON OC.ID = A.asuransi
                //         where SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),1,7)=:Periode
                //     and a.Batal='0'   and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG') 
                //         AND PG.ID<>'53' 
                //         and pg.id not in ('9','10','47','48','49','52','17','1','53')
                //     and a.PatientType='2'
                //         group by oc.NamaPerusahaan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2)

                //     ) AS QuarterlyData
                //     PIVOT( SUM([REGISTRASI Count])   
                // FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
                //   [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
                //   [25],[26],[27],[28],[29],[30],[31],
                // [grandtotal])) AS QPivot
                // order by total desc";
                $query = "SELECT NamaPerusahaan  ,
            isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
            isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
            isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
            isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
            isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
            isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
            isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
            isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0))
             as TOTAL
                FROM (
                    select  a.NamaJaminan as NamaPerusahaan,
                    SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                    count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                    from DashboardData.dbo.dataRWJ a
                    --inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                    --inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                    --inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                    --inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                    --left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                    --inner join MasterdataSQL.dbo.MstrPerusahaanJPK OC ON OC.ID = A.Perusahaan
                    where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7):Periode
                --and a.Batal='0'   and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG') 
                  --  AND PG.ID<>'53' 
                    and a.IdUnit not in ('9','10','47','48','49','52','17','1','53')
                and a.TipePasien='2'
                    group by a.NamaJaminan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                    
                ) AS QuarterlyData
                PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31],
            [grandtotal])) AS QPivot";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaPerusahaan'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '2' && $JenisRekap == '6') {
                //     $query = "SELECT NamaPerusahaan  ,
                // isnull([01],0) as satu,
                // isnull([02],0) as dua,
                // isnull([03],0) as tiga,
                // isnull([04],0) as empat,
                // isnull([05],0) as lima,
                // isnull([06],0) as enam,
                // isnull([07],0) as Jtujuh,
                // isnull([08],0) as delapan,
                // isnull([09],0) as sembilan,
                // isnull([10],0) as sepuluh,
                // isnull([11],0) as sebelah,
                // isnull([12],0) as duabelas,
                // isnull([13],0) as tigabelas,
                // isnull([14],0) as empatbelas,
                // isnull([15],0) as limabelas,
                // isnull([16],0) as enambelas,
                // isnull([17],0) as tujuhbelas,
                // isnull([18],0) as delapanbelas,
                // isnull([19],0) as sembilanbelas,
                // isnull([20],0) as duapuluh,
                // isnull([21],0) as duapuluhsatu,
                // isnull([22],0) as duapuluhdua,
                // isnull([23],0) as duapuluhtiga,
                // isnull([24],0) as duapuluhempat,
                // isnull([25],0) as duapuluhlima,
                // isnull([26],0) as duapuluhenam,
                // isnull([27],0) as duapuluhtujuh,
                // isnull([28],0) as duapuluhdelapan,
                // isnull([29],0) as duapuluhlsembilan,
                // isnull([30],0) as tigapuluh,
                // isnull([31],0) as tigapuluhsatu,
                // (isnull([01],0)+
                // isnull([02],0)+
                // isnull([03],0)+
                // isnull([04],0)+
                // isnull([05],0)+
                // isnull([06],0)+
                // isnull([07],0)+
                // isnull([08],0)+
                // isnull([09],0)+
                // isnull([10],0)+
                // isnull([11],0)+
                // isnull([12],0)+
                // isnull([13],0)+
                // isnull([14],0)+
                // isnull([15],0)+
                // isnull([16],0)+
                // isnull([17],0)+
                // isnull([18],0)+
                // isnull([19],0)+
                // isnull([20],0)+
                // isnull([21],0)+
                // isnull([22],0)+
                // isnull([23],0)+
                // isnull([24],0)+
                // isnull([25],0)+
                // isnull([26],0)+
                // isnull([27],0)+
                // isnull([28],0)+
                // isnull([29],0)+
                // isnull([30],0)+
                // isnull([31],0))
                //  as TOTAL
                //     FROM (
                //         select  oc.NamaPerusahaan,
                //         SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2) [Quarter],
                //         count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                //         from PerawatanSQL.dbo.Visit a
                //         inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                //         inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                //         inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                //         inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                //         left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                //         inner join MasterdataSQL.dbo.MstrPerusahaanJPK OC ON OC.ID = A.Perusahaan
                //         where SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),1,7)=:Periode
                //     and a.Batal='0'   
                //         and pg.id  in ('1')
                //     and a.PatientType<>'2'
                //         group by oc.NamaPerusahaan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2)

                //     ) AS QuarterlyData
                //     PIVOT( SUM([REGISTRASI Count])   
                // FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
                //   [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
                //   [25],[26],[27],[28],[29],[30],[31],
                // [grandtotal])) AS QPivot";
                $query = "SELECT NamaPerusahaan  ,
            isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
            isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
            isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
            isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
            isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
            isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
            isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
            isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0))
             as TOTAL
                FROM (
                    select  a.NamaJaminan as NamaPerusahaan,
                    SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                    count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                    from DashboardData.dbo.dataRWJ a
                    --inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                    --inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                    --inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                    --inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                    --left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                    --inner join MasterdataSQL.dbo.MstrPerusahaanJPK OC ON OC.ID = A.Perusahaan
                    where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7):Periode
                --and a.Batal='0'   and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG') 
                  --  AND PG.ID<>'53' 
                    and a.IdUnit in ('1')
                and a.TipePasien<>'2'
                    group by a.NamaJaminan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                    
                ) AS QuarterlyData
                PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31],
            [grandtotal])) AS QPivot";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaPerusahaan'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '2' && $JenisRekap == '7') {
                //     $query = "SELECT NamaPerusahaan  ,
                // isnull([01],0) as satu,
                // isnull([02],0) as dua,
                // isnull([03],0) as tiga,
                // isnull([04],0) as empat,
                // isnull([05],0) as lima,
                // isnull([06],0) as enam,
                // isnull([07],0) as Jtujuh,
                // isnull([08],0) as delapan,
                // isnull([09],0) as sembilan,
                // isnull([10],0) as sepuluh,
                // isnull([11],0) as sebelah,
                // isnull([12],0) as duabelas,
                // isnull([13],0) as tigabelas,
                // isnull([14],0) as empatbelas,
                // isnull([15],0) as limabelas,
                // isnull([16],0) as enambelas,
                // isnull([17],0) as tujuhbelas,
                // isnull([18],0) as delapanbelas,
                // isnull([19],0) as sembilanbelas,
                // isnull([20],0) as duapuluh,
                // isnull([21],0) as duapuluhsatu,
                // isnull([22],0) as duapuluhdua,
                // isnull([23],0) as duapuluhtiga,
                // isnull([24],0) as duapuluhempat,
                // isnull([25],0) as duapuluhlima,
                // isnull([26],0) as duapuluhenam,
                // isnull([27],0) as duapuluhtujuh,
                // isnull([28],0) as duapuluhdelapan,
                // isnull([29],0) as duapuluhlsembilan,
                // isnull([30],0) as tigapuluh,
                // isnull([31],0) as tigapuluhsatu,
                // (isnull([01],0)+
                // isnull([02],0)+
                // isnull([03],0)+
                // isnull([04],0)+
                // isnull([05],0)+
                // isnull([06],0)+
                // isnull([07],0)+
                // isnull([08],0)+
                // isnull([09],0)+
                // isnull([10],0)+
                // isnull([11],0)+
                // isnull([12],0)+
                // isnull([13],0)+
                // isnull([14],0)+
                // isnull([15],0)+
                // isnull([16],0)+
                // isnull([17],0)+
                // isnull([18],0)+
                // isnull([19],0)+
                // isnull([20],0)+
                // isnull([21],0)+
                // isnull([22],0)+
                // isnull([23],0)+
                // isnull([24],0)+
                // isnull([25],0)+
                // isnull([26],0)+
                // isnull([27],0)+
                // isnull([28],0)+
                // isnull([29],0)+
                // isnull([30],0)+
                // isnull([31],0))
                //  as TOTAL
                //     FROM (
                //         select  oc.NamaPerusahaan,
                //         SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2) [Quarter],
                //         count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                //         from PerawatanSQL.dbo.Visit a
                //         inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                //         inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                //         inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                //         inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                //         left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                //          inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi OC ON OC.ID = A.asuransi
                //         where SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),1,7)=:Periode
                //     and a.Batal='0'   
                //         and pg.id  in ('1')
                //     and a.PatientType<>'2'
                //         group by oc.NamaPerusahaan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2)

                //     ) AS QuarterlyData
                //     PIVOT( SUM([REGISTRASI Count])   
                // FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
                //   [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
                //   [25],[26],[27],[28],[29],[30],[31],
                // [grandtotal])) AS QPivot";
                $query = "SELECT NamaPerusahaan  ,
            isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
            isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
            isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
            isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
            isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
            isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
            isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
            isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0))
             as TOTAL
                FROM (
                    select  a.NamaJaminan as NamaPerusahaan,
                    SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                    count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                    from DashboardData.dbo.dataRWJ a
                    --inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                    --inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                    --inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                    --inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                    --left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                    --inner join MasterdataSQL.dbo.MstrPerusahaanJPK OC ON OC.ID = A.Perusahaan
                    where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7):Periode
                --and a.Batal='0'   and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG') 
                  --  AND PG.ID<>'53' 
                    and a.IdUnit in ('1')
                and a.TipePasien='2'
                    group by a.NamaJaminan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                    
                ) AS QuarterlyData
                PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31],
            [grandtotal])) AS QPivot";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaPerusahaan'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '3' && $JenisRekap == '6') {
                //     $query = "SELECT NamaPerusahaan  ,
                // isnull([01],0) as satu,
                // isnull([02],0) as dua,
                // isnull([03],0) as tiga,
                // isnull([04],0) as empat,
                // isnull([05],0) as lima,
                // isnull([06],0) as enam,
                // isnull([07],0) as Jtujuh,
                // isnull([08],0) as delapan,
                // isnull([09],0) as sembilan,
                // isnull([10],0) as sepuluh,
                // isnull([11],0) as sebelah,
                // isnull([12],0) as duabelas,
                // isnull([13],0) as tigabelas,
                // isnull([14],0) as empatbelas,
                // isnull([15],0) as limabelas,
                // isnull([16],0) as enambelas,
                // isnull([17],0) as tujuhbelas,
                // isnull([18],0) as delapanbelas,
                // isnull([19],0) as sembilanbelas,
                // isnull([20],0) as duapuluh,
                // isnull([21],0) as duapuluhsatu,
                // isnull([22],0) as duapuluhdua,
                // isnull([23],0) as duapuluhtiga,
                // isnull([24],0) as duapuluhempat,
                // isnull([25],0) as duapuluhlima,
                // isnull([26],0) as duapuluhenam,
                // isnull([27],0) as duapuluhtujuh,
                // isnull([28],0) as duapuluhdelapan,
                // isnull([29],0) as duapuluhlsembilan,
                // isnull([30],0) as tigapuluh,
                // isnull([31],0) as tigapuluhsatu,
                // (isnull([01],0)+
                // isnull([02],0)+
                // isnull([03],0)+
                // isnull([04],0)+
                // isnull([05],0)+
                // isnull([06],0)+
                // isnull([07],0)+
                // isnull([08],0)+
                // isnull([09],0)+
                // isnull([10],0)+
                // isnull([11],0)+
                // isnull([12],0)+
                // isnull([13],0)+
                // isnull([14],0)+
                // isnull([15],0)+
                // isnull([16],0)+
                // isnull([17],0)+
                // isnull([18],0)+
                // isnull([19],0)+
                // isnull([20],0)+
                // isnull([21],0)+
                // isnull([22],0)+
                // isnull([23],0)+
                // isnull([24],0)+
                // isnull([25],0)+
                // isnull([26],0)+
                // isnull([27],0)+
                // isnull([28],0)+
                // isnull([29],0)+
                // isnull([30],0)+
                // isnull([31],0))
                //  as TOTAL
                //     FROM (
                //         select  oc.NamaPerusahaan,
                //         SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2) [Quarter],
                //         count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                //         from PerawatanSQL.dbo.Visit a
                //         inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                //         inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                //         inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                //         inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                //         left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                //         inner join MasterdataSQL.dbo.MstrPerusahaanJPK OC ON OC.ID = A.Perusahaan
                //         where SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),1,7)=:Periode
                //     and a.Batal='0'   
                //         and pg.id  in ('53')
                //     and a.PatientType<>'2'
                //         group by oc.NamaPerusahaan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2)

                //     ) AS QuarterlyData
                //     PIVOT( SUM([REGISTRASI Count])   
                // FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
                //   [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
                //   [25],[26],[27],[28],[29],[30],[31],
                // [grandtotal])) AS QPivot";
                $query = "SELECT NamaPerusahaan  ,
            isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
            isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
            isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
            isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
            isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
            isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
            isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
            isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0))
             as TOTAL
                FROM (
                    select  a.NamaJaminan as NamaPerusahaan,
                    SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                    count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                    from DashboardData.dbo.dataRWJ a
                    where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7):Periode
                    and a.IdUnit in ('53')
                and a.TipePasien<>'2'
                    group by a.NamaJaminan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                    
                ) AS QuarterlyData
                PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31],
            [grandtotal])) AS QPivot";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaPerusahaan'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '3' && $JenisRekap == '7') {
                //     $query = "SELECT NamaPerusahaan  ,
                // isnull([01],0) as satu,
                // isnull([02],0) as dua,
                // isnull([03],0) as tiga,
                // isnull([04],0) as empat,
                // isnull([05],0) as lima,
                // isnull([06],0) as enam,
                // isnull([07],0) as Jtujuh,
                // isnull([08],0) as delapan,
                // isnull([09],0) as sembilan,
                // isnull([10],0) as sepuluh,
                // isnull([11],0) as sebelah,
                // isnull([12],0) as duabelas,
                // isnull([13],0) as tigabelas,
                // isnull([14],0) as empatbelas,
                // isnull([15],0) as limabelas,
                // isnull([16],0) as enambelas,
                // isnull([17],0) as tujuhbelas,
                // isnull([18],0) as delapanbelas,
                // isnull([19],0) as sembilanbelas,
                // isnull([20],0) as duapuluh,
                // isnull([21],0) as duapuluhsatu,
                // isnull([22],0) as duapuluhdua,
                // isnull([23],0) as duapuluhtiga,
                // isnull([24],0) as duapuluhempat,
                // isnull([25],0) as duapuluhlima,
                // isnull([26],0) as duapuluhenam,
                // isnull([27],0) as duapuluhtujuh,
                // isnull([28],0) as duapuluhdelapan,
                // isnull([29],0) as duapuluhlsembilan,
                // isnull([30],0) as tigapuluh,
                // isnull([31],0) as tigapuluhsatu,
                // (isnull([01],0)+
                // isnull([02],0)+
                // isnull([03],0)+
                // isnull([04],0)+
                // isnull([05],0)+
                // isnull([06],0)+
                // isnull([07],0)+
                // isnull([08],0)+
                // isnull([09],0)+
                // isnull([10],0)+
                // isnull([11],0)+
                // isnull([12],0)+
                // isnull([13],0)+
                // isnull([14],0)+
                // isnull([15],0)+
                // isnull([16],0)+
                // isnull([17],0)+
                // isnull([18],0)+
                // isnull([19],0)+
                // isnull([20],0)+
                // isnull([21],0)+
                // isnull([22],0)+
                // isnull([23],0)+
                // isnull([24],0)+
                // isnull([25],0)+
                // isnull([26],0)+
                // isnull([27],0)+
                // isnull([28],0)+
                // isnull([29],0)+
                // isnull([30],0)+
                // isnull([31],0))
                //  as TOTAL
                //     FROM (
                //         select  oc.NamaPerusahaan,
                //         SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2) [Quarter],
                //         count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                //         from PerawatanSQL.dbo.Visit a
                //         inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                //         inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                //         inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                //         inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                //         left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                //         inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi OC ON OC.ID = A.asuransi
                //         where SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),1,7)=:Periode
                //     and a.Batal='0'   
                //         and pg.id  in ('53')
                //     and a.PatientType<>'2'
                //         group by oc.NamaPerusahaan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2)

                //     ) AS QuarterlyData
                //     PIVOT( SUM([REGISTRASI Count])   
                // FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
                //   [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
                //   [25],[26],[27],[28],[29],[30],[31],
                // [grandtotal])) AS QPivot";
                $query = "SELECT NamaPerusahaan  ,
            isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
            isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
            isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
            isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
            isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
            isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
            isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
            isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0))
             as TOTAL
                FROM (
                    select  a.NamaJaminan as NamaPerusahaan,
                    SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                    count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                    from DashboardData.dbo.dataRWJ a
                    where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7):Periode
                    and a.IdUnit in ('53')
                and a.TipePasien='2'
                    group by a.NamaJaminan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                    
                ) AS QuarterlyData
                PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31],
            [grandtotal])) AS QPivot";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaPerusahaan'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '4' && $JenisRekap == '6') {
                $query = "SELECT NamaPerusahaan,
               isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
			isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
			isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
			isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
			isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
			isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
			isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
			isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0))
                 as TOTAL
                      FROM (
                           select  oc.NamaPerusahaan,
                           SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),6,2) [Quarter],
                          count(isnull(a.drPenerima,0)) as  [REGISTRASI Count]
                          from RawatInapSQL.dbo.Inpatient a
                          inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                          inner join MasterdataSQL.dbo.Doctors c on c.ID = a.drPenerima
						  inner join MasterdataSQL.dbo.MstrPerusahaanJPK OC ON OC.ID = A.IDJPK
                          where YEAR(a.StartDate)=:Periode
                          group by oc.NamaPerusahaan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),6,2)
                           
                      ) AS QuarterlyData
                      PIVOT( SUM([REGISTRASI Count])   
                              FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31],
                              [grandtotal])) AS QPivot
                              order by TOTAL desc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaPerusahaan'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '4' && $JenisRekap == '7') {
                $query = "SELECT NamaPerusahaan,
               isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
			isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
			isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
			isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
			isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
			isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
			isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
			isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0))
                 as TOTAL
                      FROM (
                           select  oc.NamaPerusahaan,
                           SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),6,2) [Quarter],
                          count(isnull(a.drPenerima,0)) as  [REGISTRASI Count]
                          from RawatInapSQL.dbo.Inpatient a
                          inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                          inner join MasterdataSQL.dbo.Doctors c on c.ID = a.drPenerima
						  inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi OC ON OC.ID = A.IDAsuransi
                          where YEAR(a.StartDate)=:Periode
                          group by oc.NamaPerusahaan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),6,2)
                           
                      ) AS QuarterlyData
                      PIVOT( SUM([REGISTRASI Count])   
                              FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31],
                              [grandtotal])) AS QPivot
                              order by TOTAL desc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaPerusahaan'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '6' && $JenisRekap == '6') {
                //     $query = "SELECT NamaPerusahaan  ,
                // isnull([01],0) as satu,
                // isnull([02],0) as dua,
                // isnull([03],0) as tiga,
                // isnull([04],0) as empat,
                // isnull([05],0) as lima,
                // isnull([06],0) as enam,
                // isnull([07],0) as Jtujuh,
                // isnull([08],0) as delapan,
                // isnull([09],0) as sembilan,
                // isnull([10],0) as sepuluh,
                // isnull([11],0) as sebelah,
                // isnull([12],0) as duabelas,
                // isnull([13],0) as tigabelas,
                // isnull([14],0) as empatbelas,
                // isnull([15],0) as limabelas,
                // isnull([16],0) as enambelas,
                // isnull([17],0) as tujuhbelas,
                // isnull([18],0) as delapanbelas,
                // isnull([19],0) as sembilanbelas,
                // isnull([20],0) as duapuluh,
                // isnull([21],0) as duapuluhsatu,
                // isnull([22],0) as duapuluhdua,
                // isnull([23],0) as duapuluhtiga,
                // isnull([24],0) as duapuluhempat,
                // isnull([25],0) as duapuluhlima,
                // isnull([26],0) as duapuluhenam,
                // isnull([27],0) as duapuluhtujuh,
                // isnull([28],0) as duapuluhdelapan,
                // isnull([29],0) as duapuluhlsembilan,
                // isnull([30],0) as tigapuluh,
                // isnull([31],0) as tigapuluhsatu,
                // (isnull([01],0)+
                // isnull([02],0)+
                // isnull([03],0)+
                // isnull([04],0)+
                // isnull([05],0)+
                // isnull([06],0)+
                // isnull([07],0)+
                // isnull([08],0)+
                // isnull([09],0)+
                // isnull([10],0)+
                // isnull([11],0)+
                // isnull([12],0)+
                // isnull([13],0)+
                // isnull([14],0)+
                // isnull([15],0)+
                // isnull([16],0)+
                // isnull([17],0)+
                // isnull([18],0)+
                // isnull([19],0)+
                // isnull([20],0)+
                // isnull([21],0)+
                // isnull([22],0)+
                // isnull([23],0)+
                // isnull([24],0)+
                // isnull([25],0)+
                // isnull([26],0)+
                // isnull([27],0)+
                // isnull([28],0)+
                // isnull([29],0)+
                // isnull([30],0)+
                // isnull([31],0))
                //  as TOTAL
                //     FROM (
                //         select  oc.NamaPerusahaan,
                //         SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2) [Quarter],
                //         count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                //         from PerawatanSQL.dbo.Visit a
                //         inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                //         inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                //         inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                //         inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                //         left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                //         inner join MasterdataSQL.dbo.MstrPerusahaanJPK OC ON OC.ID = A.Perusahaan
                //         where SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),1,7)=:Periode
                //     and a.Batal='0'   
                //         and pg.id  in ('47')
                //     and a.PatientType<>'2'
                //         group by oc.NamaPerusahaan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2)

                //     ) AS QuarterlyData
                //     PIVOT( SUM([REGISTRASI Count])   
                // FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
                //   [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
                //   [25],[26],[27],[28],[29],[30],[31],
                // [grandtotal])) AS QPivot";
                $query = "SELECT NamaPerusahaan  ,
            isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
            isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
            isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
            isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
            isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
            isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
            isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
            isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0))
             as TOTAL
                FROM (
                    select  a.NamaJaminan as NamaPerusahaan,
                    SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                    count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                    from DashboardData.dbo.dataRWJ a
                    where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7):Periode
                    and a.IdUnit in ('47')
                and a.TipePasien<>'2'
                    group by a.NamaJaminan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                    
                ) AS QuarterlyData
                PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31],
            [grandtotal])) AS QPivot";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaPerusahaan'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '6' && $JenisRekap == '7') {
                //     $query = "SELECT NamaPerusahaan  ,
                // isnull([01],0) as satu,
                // isnull([02],0) as dua,
                // isnull([03],0) as tiga,
                // isnull([04],0) as empat,
                // isnull([05],0) as lima,
                // isnull([06],0) as enam,
                // isnull([07],0) as Jtujuh,
                // isnull([08],0) as delapan,
                // isnull([09],0) as sembilan,
                // isnull([10],0) as sepuluh,
                // isnull([11],0) as sebelah,
                // isnull([12],0) as duabelas,
                // isnull([13],0) as tigabelas,
                // isnull([14],0) as empatbelas,
                // isnull([15],0) as limabelas,
                // isnull([16],0) as enambelas,
                // isnull([17],0) as tujuhbelas,
                // isnull([18],0) as delapanbelas,
                // isnull([19],0) as sembilanbelas,
                // isnull([20],0) as duapuluh,
                // isnull([21],0) as duapuluhsatu,
                // isnull([22],0) as duapuluhdua,
                // isnull([23],0) as duapuluhtiga,
                // isnull([24],0) as duapuluhempat,
                // isnull([25],0) as duapuluhlima,
                // isnull([26],0) as duapuluhenam,
                // isnull([27],0) as duapuluhtujuh,
                // isnull([28],0) as duapuluhdelapan,
                // isnull([29],0) as duapuluhlsembilan,
                // isnull([30],0) as tigapuluh,
                // isnull([31],0) as tigapuluhsatu,
                // (isnull([01],0)+
                // isnull([02],0)+
                // isnull([03],0)+
                // isnull([04],0)+
                // isnull([05],0)+
                // isnull([06],0)+
                // isnull([07],0)+
                // isnull([08],0)+
                // isnull([09],0)+
                // isnull([10],0)+
                // isnull([11],0)+
                // isnull([12],0)+
                // isnull([13],0)+
                // isnull([14],0)+
                // isnull([15],0)+
                // isnull([16],0)+
                // isnull([17],0)+
                // isnull([18],0)+
                // isnull([19],0)+
                // isnull([20],0)+
                // isnull([21],0)+
                // isnull([22],0)+
                // isnull([23],0)+
                // isnull([24],0)+
                // isnull([25],0)+
                // isnull([26],0)+
                // isnull([27],0)+
                // isnull([28],0)+
                // isnull([29],0)+
                // isnull([30],0)+
                // isnull([31],0))
                //  as TOTAL
                //     FROM (
                //         select  oc.NamaPerusahaan,
                //         SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2) [Quarter],
                //         count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                //         from PerawatanSQL.dbo.Visit a
                //         inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                //         inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                //         inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                //         inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                //         left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                //         inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi OC ON OC.ID = A.Asuransi
                //         where SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),1,7)=:Periode
                //     and a.Batal='0'   
                //         and pg.id  in ('47')
                //     and a.PatientType<>'2'
                //         group by oc.NamaPerusahaan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2)

                //     ) AS QuarterlyData
                //     PIVOT( SUM([REGISTRASI Count])   
                // FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
                //   [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
                //   [25],[26],[27],[28],[29],[30],[31],
                // [grandtotal])) AS QPivot";
                $query = "SELECT NamaPerusahaan  ,
            isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
            isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
            isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
            isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
            isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
            isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
            isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
            isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0))
             as TOTAL
                FROM (
                    select  a.NamaJaminan as NamaPerusahaan,
                    SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                    count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                    from DashboardData.dbo.dataRWJ a
                    where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7):Periode
                    and a.IdUnit in ('47')
                and a.TipePasien='2'
                    group by a.NamaJaminan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                    
                ) AS QuarterlyData
                PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31],
            [grandtotal])) AS QPivot";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaPerusahaan'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            }

            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataListRekap1($data)
    {
        try {
            $Periode = $data['Periode'];
            $JenisPasien = $data['JenisPasien'];
            $JenisRekap = $data['JenisRekap'];

            // var_dump($data);
            if ($JenisPasien == '1' && $JenisRekap == '1') {

                $query = "SELECT First_Name as NamaDokter,
            isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
			isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
			isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
			isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
			isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
			isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
			isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
			isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0)
        )
             as TOTAL
    FROM (
         select a.NamaDokter as First_Name,
         SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
        count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
        from DashboardData.dbo.dataRWJ a
        where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
        and a.IdUnit not in ('9','10','47','48','49','52','17','1','53')
        group by a.NamaDokter,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
         
    ) AS QuarterlyData
    PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31], 
            [grandtotal])) AS QPivot";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } else  if ($JenisPasien == '6' && $JenisRekap == '1') {

                $query = "SELECT First_Name as NamaDokter,
            isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
			isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
			isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
			isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
			isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
			isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
			isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
			isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0)
        )
             as TOTAL
    FROM (
         select a.NamaDokter as First_Name,
         SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
        count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
        from DashboardData.dbo.dataRWJ a
        where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
        and a.IdUnit in ('47')
        group by a.NamaDokter,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
         
    ) AS QuarterlyData
    PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31], 
            [grandtotal])) AS QPivot";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } else  if ($JenisPasien == '7' && $JenisRekap == '1') {
                $query = "SELECT First_Name as NamaDokter,
            isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
			isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
			isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
			isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
			isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
			isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
			isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
			isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0)
        )
             as TOTAL
    FROM (
         select a.NamaDokter as First_Name,
         SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
        count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
        from DashboardData.dbo.dataRWJ a
        where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
        and a.IdUnit in ('9','10','48','49','52','17')
        group by a.NamaDokter,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
         
    ) AS QuarterlyData
    PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31], 
            [grandtotal])) AS QPivot";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '2' && $JenisRekap == '1') {
                $query = "SELECT First_Name as NamaDokter,
            isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
			isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
			isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
			isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
			isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
			isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
			isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
			isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0)
        )
             as TOTAL
    FROM (
         select a.NamaDokter as First_Name,
         SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
        count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
        from DashboardData.dbo.dataRWJ a
        where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
        and a.IdUnit = '1'
        group by a.NamaDokter,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
         
    ) AS QuarterlyData
    PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31], 
            [grandtotal])) AS QPivot";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '3' && $JenisRekap == '1') {
                $query = "SELECT First_Name as NamaDokter,
            isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
			isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
			isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
			isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
			isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
			isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
			isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
			isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0)
        )
             as TOTAL
    FROM (
         select a.NamaDokter as First_Name,
         SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
        count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
        from DashboardData.dbo.dataRWJ a
        where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
        and a.IdUnit in '53'
        group by a.NamaDokter,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
         
    ) AS QuarterlyData
    PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31], 
            [grandtotal])) AS QPivot";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '4' && $JenisRekap == '1') {
                $query = "SELECT JenisRawat,First_Name as NamaDokter,
                isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
			isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
			isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
			isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
			isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
			isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
			isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
			isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0))
                 as TOTAL
                      FROM (
                           select  a.JenisRawat,c.First_Name,
                           SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),6,2) [Quarter],
                          count(isnull(a.drPenerima,0)) as  [REGISTRASI Count]
                          from RawatInapSQL.dbo.Inpatient a
                          inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                          inner join MasterdataSQL.dbo.Doctors c on c.ID = a.drPenerima
                          where YEAR(a.StartDate)=:Periode 
                          group by a.JenisRawat,c.First_Name,SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),6,2)
                           
                      ) AS QuarterlyData
                      PIVOT( SUM([REGISTRASI Count])   
                              FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31],
                              [grandtotal])) AS QPivot
                              order by JenisRawat asc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '5' && $JenisRekap == '1') {
                $query = "SELECT GroupSpesialis,DrOperator as NamaDokter,
                isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
			isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
			isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
			isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
			isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
			isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
			isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
			isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0))
                 as TOTAL
                      FROM (
                           select  d.GroupSpesialis,d.DrOperator,
                           SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),6,2) [Quarter],
                          count(isnull(a.drPenerima,0)) as  [REGISTRASI Count]
                          from RawatInapSQL.dbo.Inpatient a
                          inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
              inner join MedicalRecord.dbo.EMR_OrderOperasi d on a.NoRegRI  collate SQL_Latin1_General_CP1_CI_AS=d.NoRegistrasi  collate SQL_Latin1_General_CP1_CI_AS
                          where YEAR(a.StartDate)=:Periode and d.StatusOrder='Approved OT' 
                          group by d.GroupSpesialis,d.DrOperator,SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),6,2)
                           
                      ) AS QuarterlyData
                      PIVOT( SUM([REGISTRASI Count])   
                              FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31],
                              [grandtotal])) AS QPivot
                              order by GroupSpesialis asc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '1' && $JenisRekap == '3') {

                $query = "SELECT NamaCaraMasukRef as NamaRujukan,NamaUnit,NamaDokter,
            isnull([01],0) as satu,
        isnull([02],0) as dua,
        isnull([03],0) as tiga,
        isnull([04],0) as empat,
        isnull([05],0) as lima,
        isnull([06],0) as enam,
        isnull([07],0) as Jtujuh,
        isnull([08],0) as delapan,
        isnull([09],0) as sembilan,
        isnull([10],0) as sepuluh,
        isnull([11],0) as sebelah,
        isnull([12],0) as duabelas,
        isnull([13],0) as tigabelas,
        isnull([14],0) as empatbelas,
        isnull([15],0) as limabelas,
        isnull([16],0) as enambelas,
        isnull([17],0) as tujuhbelas,
        isnull([18],0) as delapanbelas,
        isnull([19],0) as sembilanbelas,
        isnull([20],0) as duapuluh,
        isnull([21],0) as duapuluhsatu,
        isnull([22],0) as duapuluhdua,
        isnull([23],0) as duapuluhtiga,
        isnull([24],0) as duapuluhempat,
        isnull([25],0) as duapuluhlima,
        isnull([26],0) as duapuluhenam,
        isnull([27],0) as duapuluhtujuh,
        isnull([28],0) as duapuluhdelapan,
        isnull([29],0) as duapuluhlsembilan,
        isnull([30],0) as tigapuluh,
        isnull([31],0) as tigapuluhsatu,
        (isnull([01],0)+
        isnull([02],0)+
        isnull([03],0)+
        isnull([04],0)+
        isnull([05],0)+
        isnull([06],0)+
        isnull([07],0)+
        isnull([08],0)+
        isnull([09],0)+
        isnull([10],0)+
        isnull([11],0)+
        isnull([12],0)+
        isnull([13],0)+
        isnull([14],0)+
        isnull([15],0)+
        isnull([16],0)+
        isnull([17],0)+
        isnull([18],0)+
        isnull([19],0)+
        isnull([20],0)+
        isnull([21],0)+
        isnull([22],0)+
        isnull([23],0)+
        isnull([24],0)+
        isnull([25],0)+
        isnull([26],0)+
        isnull([27],0)+
        isnull([28],0)+
        isnull([29],0)+
        isnull([30],0)+
        isnull([31],0))
             as TOTAL
                  FROM (
                       select  a.NamaCaraMasukRef,a.NamaUnit, a.NamaDokter,
                       SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                      count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                      from DashboardData.dbo.dataRWJ a
                      where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
                      and a.IdUnit not in  ('9','10','47','48','49','52','17','1','52','53')
                      group by a.NamaCaraMasukRef,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2),a.NamaUnit,a.NamaDokter
                       
                  ) AS QuarterlyData
                  PIVOT( SUM([REGISTRASI Count])   
                          FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
          [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
          [25],[26],[27],[28],[29],[30],[31],
                          [grandtotal])) AS QPivot
                          order by NamaCaraMasukRef asc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaUnit'];
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '6' && $JenisRekap == '3') {

                $query = "SELECT NamaCaraMasukRef as NamaRujukan,NamaUnit,NamaDokter,
            isnull([01],0) as satu,
        isnull([02],0) as dua,
        isnull([03],0) as tiga,
        isnull([04],0) as empat,
        isnull([05],0) as lima,
        isnull([06],0) as enam,
        isnull([07],0) as Jtujuh,
        isnull([08],0) as delapan,
        isnull([09],0) as sembilan,
        isnull([10],0) as sepuluh,
        isnull([11],0) as sebelah,
        isnull([12],0) as duabelas,
        isnull([13],0) as tigabelas,
        isnull([14],0) as empatbelas,
        isnull([15],0) as limabelas,
        isnull([16],0) as enambelas,
        isnull([17],0) as tujuhbelas,
        isnull([18],0) as delapanbelas,
        isnull([19],0) as sembilanbelas,
        isnull([20],0) as duapuluh,
        isnull([21],0) as duapuluhsatu,
        isnull([22],0) as duapuluhdua,
        isnull([23],0) as duapuluhtiga,
        isnull([24],0) as duapuluhempat,
        isnull([25],0) as duapuluhlima,
        isnull([26],0) as duapuluhenam,
        isnull([27],0) as duapuluhtujuh,
        isnull([28],0) as duapuluhdelapan,
        isnull([29],0) as duapuluhlsembilan,
        isnull([30],0) as tigapuluh,
        isnull([31],0) as tigapuluhsatu,
        (isnull([01],0)+
        isnull([02],0)+
        isnull([03],0)+
        isnull([04],0)+
        isnull([05],0)+
        isnull([06],0)+
        isnull([07],0)+
        isnull([08],0)+
        isnull([09],0)+
        isnull([10],0)+
        isnull([11],0)+
        isnull([12],0)+
        isnull([13],0)+
        isnull([14],0)+
        isnull([15],0)+
        isnull([16],0)+
        isnull([17],0)+
        isnull([18],0)+
        isnull([19],0)+
        isnull([20],0)+
        isnull([21],0)+
        isnull([22],0)+
        isnull([23],0)+
        isnull([24],0)+
        isnull([25],0)+
        isnull([26],0)+
        isnull([27],0)+
        isnull([28],0)+
        isnull([29],0)+
        isnull([30],0)+
        isnull([31],0))
             as TOTAL
                  FROM (
                       select  a.NamaCaraMasukRef,a.NamaUnit, a.NamaDokter,
                       SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                      count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                      from DashboardData.dbo.dataRWJ a
                      where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
                      --and a.IdUnit not in  ('9','10','47','48','49','52','17','1','52','53')
                       and a.IdUnit  in ('47')
                      group by a.NamaCaraMasukRef,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2),a.NamaUnit,a.NamaDokter
                       
                  ) AS QuarterlyData
                  PIVOT( SUM([REGISTRASI Count])   
                          FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
          [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
          [25],[26],[27],[28],[29],[30],[31],
                          [grandtotal])) AS QPivot
                          order by NamaCaraMasukRef asc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaUnit'];
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '7' && $JenisRekap == '3') {

                $query = "SELECT NamaCaraMasukRef as NamaRujukan,NamaUnit,NamaDokter,
            isnull([01],0) as satu,
        isnull([02],0) as dua,
        isnull([03],0) as tiga,
        isnull([04],0) as empat,
        isnull([05],0) as lima,
        isnull([06],0) as enam,
        isnull([07],0) as Jtujuh,
        isnull([08],0) as delapan,
        isnull([09],0) as sembilan,
        isnull([10],0) as sepuluh,
        isnull([11],0) as sebelah,
        isnull([12],0) as duabelas,
        isnull([13],0) as tigabelas,
        isnull([14],0) as empatbelas,
        isnull([15],0) as limabelas,
        isnull([16],0) as enambelas,
        isnull([17],0) as tujuhbelas,
        isnull([18],0) as delapanbelas,
        isnull([19],0) as sembilanbelas,
        isnull([20],0) as duapuluh,
        isnull([21],0) as duapuluhsatu,
        isnull([22],0) as duapuluhdua,
        isnull([23],0) as duapuluhtiga,
        isnull([24],0) as duapuluhempat,
        isnull([25],0) as duapuluhlima,
        isnull([26],0) as duapuluhenam,
        isnull([27],0) as duapuluhtujuh,
        isnull([28],0) as duapuluhdelapan,
        isnull([29],0) as duapuluhlsembilan,
        isnull([30],0) as tigapuluh,
        isnull([31],0) as tigapuluhsatu,
        (isnull([01],0)+
        isnull([02],0)+
        isnull([03],0)+
        isnull([04],0)+
        isnull([05],0)+
        isnull([06],0)+
        isnull([07],0)+
        isnull([08],0)+
        isnull([09],0)+
        isnull([10],0)+
        isnull([11],0)+
        isnull([12],0)+
        isnull([13],0)+
        isnull([14],0)+
        isnull([15],0)+
        isnull([16],0)+
        isnull([17],0)+
        isnull([18],0)+
        isnull([19],0)+
        isnull([20],0)+
        isnull([21],0)+
        isnull([22],0)+
        isnull([23],0)+
        isnull([24],0)+
        isnull([25],0)+
        isnull([26],0)+
        isnull([27],0)+
        isnull([28],0)+
        isnull([29],0)+
        isnull([30],0)+
        isnull([31],0))
             as TOTAL
                  FROM (
                       select  a.NamaCaraMasukRef,a.NamaUnit, a.NamaDokter,
                       SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                      count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                      from DashboardData.dbo.dataRWJ a
                      where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
                      --and a.IdUnit not in  ('9','10','47','48','49','52','17','1','52','53')
                       and a.IdUnit  in ('9','10','48','49','52','17')
                      group by a.NamaCaraMasukRef,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2),a.NamaUnit,a.NamaDokter
                       
                  ) AS QuarterlyData
                  PIVOT( SUM([REGISTRASI Count])   
                          FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
          [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
          [25],[26],[27],[28],[29],[30],[31],
                          [grandtotal])) AS QPivot
                          order by NamaCaraMasukRef asc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaUnit'];
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '2' && $JenisRekap == '3') {
                $query = "SELECT NamaCaraMasukRef as NamaRujukan,NamaUnit,NamaDokter,
            isnull([01],0) as satu,
        isnull([02],0) as dua,
        isnull([03],0) as tiga,
        isnull([04],0) as empat,
        isnull([05],0) as lima,
        isnull([06],0) as enam,
        isnull([07],0) as Jtujuh,
        isnull([08],0) as delapan,
        isnull([09],0) as sembilan,
        isnull([10],0) as sepuluh,
        isnull([11],0) as sebelah,
        isnull([12],0) as duabelas,
        isnull([13],0) as tigabelas,
        isnull([14],0) as empatbelas,
        isnull([15],0) as limabelas,
        isnull([16],0) as enambelas,
        isnull([17],0) as tujuhbelas,
        isnull([18],0) as delapanbelas,
        isnull([19],0) as sembilanbelas,
        isnull([20],0) as duapuluh,
        isnull([21],0) as duapuluhsatu,
        isnull([22],0) as duapuluhdua,
        isnull([23],0) as duapuluhtiga,
        isnull([24],0) as duapuluhempat,
        isnull([25],0) as duapuluhlima,
        isnull([26],0) as duapuluhenam,
        isnull([27],0) as duapuluhtujuh,
        isnull([28],0) as duapuluhdelapan,
        isnull([29],0) as duapuluhlsembilan,
        isnull([30],0) as tigapuluh,
        isnull([31],0) as tigapuluhsatu,
        (isnull([01],0)+
        isnull([02],0)+
        isnull([03],0)+
        isnull([04],0)+
        isnull([05],0)+
        isnull([06],0)+
        isnull([07],0)+
        isnull([08],0)+
        isnull([09],0)+
        isnull([10],0)+
        isnull([11],0)+
        isnull([12],0)+
        isnull([13],0)+
        isnull([14],0)+
        isnull([15],0)+
        isnull([16],0)+
        isnull([17],0)+
        isnull([18],0)+
        isnull([19],0)+
        isnull([20],0)+
        isnull([21],0)+
        isnull([22],0)+
        isnull([23],0)+
        isnull([24],0)+
        isnull([25],0)+
        isnull([26],0)+
        isnull([27],0)+
        isnull([28],0)+
        isnull([29],0)+
        isnull([30],0)+
        isnull([31],0))
             as TOTAL
                  FROM (
                       select  a.NamaCaraMasukRef,a.NamaUnit, a.NamaDokter,
                       SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                      count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                      from DashboardData.dbo.dataRWJ a
                      where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
                      --and a.IdUnit not in  ('9','10','47','48','49','52','17','1','52','53')
                       and a.IdUnit  in ('1')
                      group by a.NamaCaraMasukRef,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2),a.NamaUnit,a.NamaDokter
                       
                  ) AS QuarterlyData
                  PIVOT( SUM([REGISTRASI Count])   
                          FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
          [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
          [25],[26],[27],[28],[29],[30],[31],
                          [grandtotal])) AS QPivot
                          order by NamaCaraMasukRef asc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaUnit'];
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '3' && $JenisRekap == '3') {

                $query = "SELECT NamaCaraMasukRef as NamaRujukan,NamaUnit,NamaDokter,
            isnull([01],0) as satu,
        isnull([02],0) as dua,
        isnull([03],0) as tiga,
        isnull([04],0) as empat,
        isnull([05],0) as lima,
        isnull([06],0) as enam,
        isnull([07],0) as Jtujuh,
        isnull([08],0) as delapan,
        isnull([09],0) as sembilan,
        isnull([10],0) as sepuluh,
        isnull([11],0) as sebelah,
        isnull([12],0) as duabelas,
        isnull([13],0) as tigabelas,
        isnull([14],0) as empatbelas,
        isnull([15],0) as limabelas,
        isnull([16],0) as enambelas,
        isnull([17],0) as tujuhbelas,
        isnull([18],0) as delapanbelas,
        isnull([19],0) as sembilanbelas,
        isnull([20],0) as duapuluh,
        isnull([21],0) as duapuluhsatu,
        isnull([22],0) as duapuluhdua,
        isnull([23],0) as duapuluhtiga,
        isnull([24],0) as duapuluhempat,
        isnull([25],0) as duapuluhlima,
        isnull([26],0) as duapuluhenam,
        isnull([27],0) as duapuluhtujuh,
        isnull([28],0) as duapuluhdelapan,
        isnull([29],0) as duapuluhlsembilan,
        isnull([30],0) as tigapuluh,
        isnull([31],0) as tigapuluhsatu,
        (isnull([01],0)+
        isnull([02],0)+
        isnull([03],0)+
        isnull([04],0)+
        isnull([05],0)+
        isnull([06],0)+
        isnull([07],0)+
        isnull([08],0)+
        isnull([09],0)+
        isnull([10],0)+
        isnull([11],0)+
        isnull([12],0)+
        isnull([13],0)+
        isnull([14],0)+
        isnull([15],0)+
        isnull([16],0)+
        isnull([17],0)+
        isnull([18],0)+
        isnull([19],0)+
        isnull([20],0)+
        isnull([21],0)+
        isnull([22],0)+
        isnull([23],0)+
        isnull([24],0)+
        isnull([25],0)+
        isnull([26],0)+
        isnull([27],0)+
        isnull([28],0)+
        isnull([29],0)+
        isnull([30],0)+
        isnull([31],0))
             as TOTAL
                  FROM (
                       select  a.NamaCaraMasukRef,a.NamaUnit, a.NamaDokter,
                       SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                      count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                      from DashboardData.dbo.dataRWJ a
                      where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
                       and a.IdUnit  in ('53')
                      group by a.NamaCaraMasukRef,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2),a.NamaUnit,a.NamaDokter
                       
                  ) AS QuarterlyData
                  PIVOT( SUM([REGISTRASI Count])   
                          FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
          [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
          [25],[26],[27],[28],[29],[30],[31],
                          [grandtotal])) AS QPivot
                          order by NamaCaraMasukRef asc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaUnit'];
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '4' && $JenisRekap == '3') {
                $query = "SELECT NamaCaraMasukRef as NamaRujukan,NamaUnit,NamaDokter,
        isnull([01],0) as satu,
    isnull([02],0) as dua,
    isnull([03],0) as tiga,
    isnull([04],0) as empat,
    isnull([05],0) as lima,
    isnull([06],0) as enam,
    isnull([07],0) as Jtujuh,
    isnull([08],0) as delapan,
    isnull([09],0) as sembilan,
    isnull([10],0) as sepuluh,
    isnull([11],0) as sebelah,
    isnull([12],0) as duabelas,
    isnull([13],0) as tigabelas,
    isnull([14],0) as empatbelas,
    isnull([15],0) as limabelas,
    isnull([16],0) as enambelas,
    isnull([17],0) as tujuhbelas,
    isnull([18],0) as delapanbelas,
    isnull([19],0) as sembilanbelas,
    isnull([20],0) as duapuluh,
    isnull([21],0) as duapuluhsatu,
    isnull([22],0) as duapuluhdua,
    isnull([23],0) as duapuluhtiga,
    isnull([24],0) as duapuluhempat,
    isnull([25],0) as duapuluhlima,
    isnull([26],0) as duapuluhenam,
    isnull([27],0) as duapuluhtujuh,
    isnull([28],0) as duapuluhdelapan,
    isnull([29],0) as duapuluhlsembilan,
    isnull([30],0) as tigapuluh,
    isnull([31],0) as tigapuluhsatu,
    (isnull([01],0)+
    isnull([02],0)+
    isnull([03],0)+
    isnull([04],0)+
    isnull([05],0)+
    isnull([06],0)+
    isnull([07],0)+
    isnull([08],0)+
    isnull([09],0)+
    isnull([10],0)+
    isnull([11],0)+
    isnull([12],0)+
    isnull([13],0)+
    isnull([14],0)+
    isnull([15],0)+
    isnull([16],0)+
    isnull([17],0)+
    isnull([18],0)+
    isnull([19],0)+
    isnull([20],0)+
    isnull([21],0)+
    isnull([22],0)+
    isnull([23],0)+
    isnull([24],0)+
    isnull([25],0)+
    isnull([26],0)+
    isnull([27],0)+
    isnull([28],0)+
    isnull([29],0)+
    isnull([30],0)+
    isnull([31],0))
         as TOTAL
              FROM (
                   select  a.NamaCaraMasukRef,a.NamaUnit, a.NamaDokter,
                   SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                  count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                  from DashboardData.dbo.dataRWJ a
                  where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
                  group by a.NamaCaraMasukRef,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2),a.NamaUnit,a.NamaDokter
                   
              ) AS QuarterlyData
              PIVOT( SUM([REGISTRASI Count])   
                      FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
      [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
      [25],[26],[27],[28],[29],[30],[31],
                      [grandtotal])) AS QPivot
                      order by NamaCaraMasukRef asc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['JenisRawat'];
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '5' && $JenisRekap == '3') {
                $query = "SELECT NamaCaraMasukRef as NamaRujukan,GroupSpesialis,DrOperator as NamaDokter,
                isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
			isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
			isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
			isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
			isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
			isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
			isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
			isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0))
                 as TOTAL
        FROM (
             select  f.NamaCaraMasukRef,g.GroupSpesialis, g.DrOperator,
             SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),6,2) [Quarter],
            count(isnull(a.drPenerima,0)) as  [REGISTRASI Count]
            from RawatInapSQL.dbo.Inpatient a
            inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
            inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.TypePatient  
            inner join MasterdataSQL.dbo.MstrCaraMasuk_2 f on a.idCaraMasuk2=f.id
            inner join MedicalRecord.dbo.EMR_OrderOperasi g on a.NoRegRI  collate SQL_Latin1_General_CP1_CI_AS=g.NoRegistrasi  collate SQL_Latin1_General_CP1_CI_AS
            where YEAR(a.StartDate)=:Periode and g.StatusOrder='Approved OT' 
            group by f.NamaCaraMasukRef,SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),6,2),GroupSpesialis, g.DrOperator
             
        ) AS QuarterlyData
        PIVOT( SUM([REGISTRASI Count])   
                FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31],
                [grandtotal])) AS QPivot
                order by NamaCaraMasukRef asc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['GroupSpesialis'];
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '1' && $JenisRekap == '2') {
                $query = "	SELECT NamaUnit, NamaDokter,
            isnull([01],0) as satu,
        isnull([02],0) as dua,
        isnull([03],0) as tiga,
        isnull([04],0) as empat,
        isnull([05],0) as lima,
        isnull([06],0) as enam,
        isnull([07],0) as Jtujuh,
        isnull([08],0) as delapan,
        isnull([09],0) as sembilan,
        isnull([10],0) as sepuluh,
        isnull([11],0) as sebelah,
        isnull([12],0) as duabelas,
        isnull([13],0) as tigabelas,
        isnull([14],0) as empatbelas,
        isnull([15],0) as limabelas,
        isnull([16],0) as enambelas,
        isnull([17],0) as tujuhbelas,
        isnull([18],0) as delapanbelas,
        isnull([19],0) as sembilanbelas,
        isnull([20],0) as duapuluh,
        isnull([21],0) as duapuluhsatu,
        isnull([22],0) as duapuluhdua,
        isnull([23],0) as duapuluhtiga,
        isnull([24],0) as duapuluhempat,
        isnull([25],0) as duapuluhlima,
        isnull([26],0) as duapuluhenam,
        isnull([27],0) as duapuluhtujuh,
        isnull([28],0) as duapuluhdelapan,
        isnull([29],0) as duapuluhlsembilan,
        isnull([30],0) as tigapuluh,
        isnull([31],0) as tigapuluhsatu,
        (isnull([01],0)+
        isnull([02],0)+
        isnull([03],0)+
        isnull([04],0)+
        isnull([05],0)+
        isnull([06],0)+
        isnull([07],0)+
        isnull([08],0)+
        isnull([09],0)+
        isnull([10],0)+
        isnull([11],0)+
        isnull([12],0)+
        isnull([13],0)+
        isnull([14],0)+
        isnull([15],0)+
        isnull([16],0)+
        isnull([17],0)+
        isnull([18],0)+
        isnull([19],0)+
        isnull([20],0)+
        isnull([21],0)+
        isnull([22],0)+
        isnull([23],0)+
        isnull([24],0)+
        isnull([25],0)+
        isnull([26],0)+
        isnull([27],0)+
        isnull([28],0)+
        isnull([29],0)+
        isnull([30],0)+
        isnull([31],0))
             as TOTAL
                  FROM (
                       select a.NamaUnit, a.NamaDokter,
                       SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                      count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                      from DashboardData.dbo.dataRWJ a
                      where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
                     and a.IdUnit not in ('9','10','47','48','49','52','17','1','53')
                      group by a.NamaUnit,a.NamaDokter,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                       
                  ) AS QuarterlyData
                  PIVOT( SUM([REGISTRASI Count])   
                          FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
          [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
          [25],[26],[27],[28],[29],[30],[31],
                          [grandtotal])) AS QPivot
                          order by NamaUnit asc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaUnit'];
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '6' && $JenisRekap == '2') {
                $query = "	SELECT NamaUnit, NamaDokter,
                               isnull([01],0) as satu,
                           isnull([02],0) as dua,
                           isnull([03],0) as tiga,
                           isnull([04],0) as empat,
                           isnull([05],0) as lima,
                           isnull([06],0) as enam,
                           isnull([07],0) as Jtujuh,
                           isnull([08],0) as delapan,
                           isnull([09],0) as sembilan,
                           isnull([10],0) as sepuluh,
                           isnull([11],0) as sebelah,
                           isnull([12],0) as duabelas,
                           isnull([13],0) as tigabelas,
                           isnull([14],0) as empatbelas,
                           isnull([15],0) as limabelas,
                           isnull([16],0) as enambelas,
                           isnull([17],0) as tujuhbelas,
                           isnull([18],0) as delapanbelas,
                           isnull([19],0) as sembilanbelas,
                           isnull([20],0) as duapuluh,
                           isnull([21],0) as duapuluhsatu,
                           isnull([22],0) as duapuluhdua,
                           isnull([23],0) as duapuluhtiga,
                           isnull([24],0) as duapuluhempat,
                           isnull([25],0) as duapuluhlima,
                           isnull([26],0) as duapuluhenam,
                           isnull([27],0) as duapuluhtujuh,
                           isnull([28],0) as duapuluhdelapan,
                           isnull([29],0) as duapuluhlsembilan,
                           isnull([30],0) as tigapuluh,
                           isnull([31],0) as tigapuluhsatu,
                           (isnull([01],0)+
                           isnull([02],0)+
                           isnull([03],0)+
                           isnull([04],0)+
                           isnull([05],0)+
                           isnull([06],0)+
                           isnull([07],0)+
                           isnull([08],0)+
                           isnull([09],0)+
                           isnull([10],0)+
                           isnull([11],0)+
                           isnull([12],0)+
                           isnull([13],0)+
                           isnull([14],0)+
                           isnull([15],0)+
                           isnull([16],0)+
                           isnull([17],0)+
                           isnull([18],0)+
                           isnull([19],0)+
                           isnull([20],0)+
                           isnull([21],0)+
                           isnull([22],0)+
                           isnull([23],0)+
                           isnull([24],0)+
                           isnull([25],0)+
                           isnull([26],0)+
                           isnull([27],0)+
                           isnull([28],0)+
                           isnull([29],0)+
                           isnull([30],0)+
                           isnull([31],0))
                                as TOTAL
                                     FROM (
                                          select a.NamaUnit, a.NamaDokter,
                                          SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                                         count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                                         from DashboardData.dbo.dataRWJ a
                                         where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
                                        and a.IdUnit in ('47')
                                         group by a.NamaUnit,a.NamaDokter,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                                          
                                     ) AS QuarterlyData
                                     PIVOT( SUM([REGISTRASI Count])   
                                             FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
                             [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
                             [25],[26],[27],[28],[29],[30],[31],
                                             [grandtotal])) AS QPivot
                                             order by NamaUnit asc";



                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaUnit'];
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '7' && $JenisRekap == '2') {
                $query = "	SELECT NamaUnit, NamaDokter,
            isnull([01],0) as satu,
        isnull([02],0) as dua,
        isnull([03],0) as tiga,
        isnull([04],0) as empat,
        isnull([05],0) as lima,
        isnull([06],0) as enam,
        isnull([07],0) as Jtujuh,
        isnull([08],0) as delapan,
        isnull([09],0) as sembilan,
        isnull([10],0) as sepuluh,
        isnull([11],0) as sebelah,
        isnull([12],0) as duabelas,
        isnull([13],0) as tigabelas,
        isnull([14],0) as empatbelas,
        isnull([15],0) as limabelas,
        isnull([16],0) as enambelas,
        isnull([17],0) as tujuhbelas,
        isnull([18],0) as delapanbelas,
        isnull([19],0) as sembilanbelas,
        isnull([20],0) as duapuluh,
        isnull([21],0) as duapuluhsatu,
        isnull([22],0) as duapuluhdua,
        isnull([23],0) as duapuluhtiga,
        isnull([24],0) as duapuluhempat,
        isnull([25],0) as duapuluhlima,
        isnull([26],0) as duapuluhenam,
        isnull([27],0) as duapuluhtujuh,
        isnull([28],0) as duapuluhdelapan,
        isnull([29],0) as duapuluhlsembilan,
        isnull([30],0) as tigapuluh,
        isnull([31],0) as tigapuluhsatu,
        (isnull([01],0)+
        isnull([02],0)+
        isnull([03],0)+
        isnull([04],0)+
        isnull([05],0)+
        isnull([06],0)+
        isnull([07],0)+
        isnull([08],0)+
        isnull([09],0)+
        isnull([10],0)+
        isnull([11],0)+
        isnull([12],0)+
        isnull([13],0)+
        isnull([14],0)+
        isnull([15],0)+
        isnull([16],0)+
        isnull([17],0)+
        isnull([18],0)+
        isnull([19],0)+
        isnull([20],0)+
        isnull([21],0)+
        isnull([22],0)+
        isnull([23],0)+
        isnull([24],0)+
        isnull([25],0)+
        isnull([26],0)+
        isnull([27],0)+
        isnull([28],0)+
        isnull([29],0)+
        isnull([30],0)+
        isnull([31],0))
             as TOTAL
                  FROM (
                       select a.NamaUnit, a.NamaDokter,
                       SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                      count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                      from DashboardData.dbo.dataRWJ a
                      where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
                     and a.IdUnit in ('9','10','48','49','52','17')
                      group by a.NamaUnit,a.NamaDokter,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                       
                  ) AS QuarterlyData
                  PIVOT( SUM([REGISTRASI Count])   
                          FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
          [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
          [25],[26],[27],[28],[29],[30],[31],
                          [grandtotal])) AS QPivot
                          order by NamaUnit asc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaUnit'];
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '2' && $JenisRekap == '2') {
                $query = "SELECT NamaUnit,First_Name as NamaDokter,
                isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
			isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
			isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
			isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
			isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
			isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
			isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
			isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0))
                 as TOTAL
        FROM (
             select pg.NamaUnit, c.First_Name,
             SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2) [Quarter],
            count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
            from PerawatanSQL.dbo.Visit a
            inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
            inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
            inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
            inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
            left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
            where SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),1,7)=:Periode
            and a.Batal='0' and pg.id  in ('1') 
            group by pg.NamaUnit,c.First_Name,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2)
             
        ) AS QuarterlyData
        PIVOT( SUM([REGISTRASI Count])   
                FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31],
                [grandtotal])) AS QPivot
                order by NamaUnit asc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaUnit'];
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '3' && $JenisRekap == '2') {
                $query = "SELECT NamaUnit,First_Name as NamaDokter,
                isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
			isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
			isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
			isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
			isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
			isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
			isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
			isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0))
                 as TOTAL
        FROM (
             select pg.NamaUnit, c.First_Name,
             SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2) [Quarter],
            count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
            from PerawatanSQL.dbo.Visit a
            inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
            inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
            inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
            inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
            left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
            where SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),1,7)=:Periode
            and a.Batal='0'  
            AND PG.ID='53'  
            group by pg.NamaUnit,c.First_Name,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2)
             
        ) AS QuarterlyData
        PIVOT( SUM([REGISTRASI Count])   
                FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31],
                [grandtotal])) AS QPivot
                order by NamaUnit asc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaUnit'];
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '4' && $JenisRekap == '2') {
                $query = "SELECT JenisRawat,First_Name as NamaDokter,
                isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
			isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
			isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
			isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
			isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
			isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
			isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
			isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0))
                 as TOTAL
        FROM (
             select  a.JenisRawat,c.First_Name,
             SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),6,2) [Quarter],
            count(isnull(a.drPenerima,0)) as  [REGISTRASI Count]
            from RawatInapSQL.dbo.Inpatient a
            inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
            inner join MasterdataSQL.dbo.Doctors c on c.ID = a.drPenerima
            where YEAR(a.StartDate)=:Periode 
            group by a.JenisRawat,c.First_Name,SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),6,2)
            ) AS QuarterlyData
                    PIVOT( SUM([REGISTRASI Count])   
                            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31],
                            [grandtotal])) AS QPivot
                            order by JenisRawat asc
            ";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['JenisRawat'];
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '5' && $JenisRekap == '2') {
                $query = "SELECT GroupSpesialis,DrOperator as NamaDokter,
                isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
			isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
			isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
			isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
			isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
			isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
			isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
			isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0))
                 as TOTAL
        FROM (
             select  d.GroupSpesialis,d.DrOperator,
             SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),6,2) [Quarter],
            count(isnull(a.drPenerima,0)) as  [REGISTRASI Count]
            from RawatInapSQL.dbo.Inpatient a
            inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
            inner join MedicalRecord.dbo.EMR_OrderOperasi d on a.NoRegRI  collate SQL_Latin1_General_CP1_CI_AS=d.NoRegistrasi  collate SQL_Latin1_General_CP1_CI_AS
            where YEAR(a.StartDate)=:Periode and d.StatusOrder='Approved OT' 
            group by d.GroupSpesialis,d.DrOperator,SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),6,2)
             
        ) AS QuarterlyData
        PIVOT( SUM([REGISTRASI Count])   
                FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31],
                [grandtotal])) AS QPivot
                order by GroupSpesialis asc
            ";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['GroupSpesialis'];
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '1' && $JenisRekap == '4') {
                $query = "SELECT NamaUnit,
            isnull([01],0) as satu,
        isnull([02],0) as dua,
        isnull([03],0) as tiga,
        isnull([04],0) as empat,
        isnull([05],0) as lima,
        isnull([06],0) as enam,
        isnull([07],0) as Jtujuh,
        isnull([08],0) as delapan,
        isnull([09],0) as sembilan,
        isnull([10],0) as sepuluh,
        isnull([11],0) as sebelah,
        isnull([12],0) as duabelas,
        isnull([13],0) as tigabelas,
        isnull([14],0) as empatbelas,
        isnull([15],0) as limabelas,
        isnull([16],0) as enambelas,
        isnull([17],0) as tujuhbelas,
        isnull([18],0) as delapanbelas,
        isnull([19],0) as sembilanbelas,
        isnull([20],0) as duapuluh,
        isnull([21],0) as duapuluhsatu,
        isnull([22],0) as duapuluhdua,
        isnull([23],0) as duapuluhtiga,
        isnull([24],0) as duapuluhempat,
        isnull([25],0) as duapuluhlima,
        isnull([26],0) as duapuluhenam,
        isnull([27],0) as duapuluhtujuh,
        isnull([28],0) as duapuluhdelapan,
        isnull([29],0) as duapuluhlsembilan,
        isnull([30],0) as tigapuluh,
        isnull([31],0) as tigapuluhsatu,
        (isnull([01],0)+
        isnull([02],0)+
        isnull([03],0)+
        isnull([04],0)+
        isnull([05],0)+
        isnull([06],0)+
        isnull([07],0)+
        isnull([08],0)+
        isnull([09],0)+
        isnull([10],0)+
        isnull([11],0)+
        isnull([12],0)+
        isnull([13],0)+
        isnull([14],0)+
        isnull([15],0)+
        isnull([16],0)+
        isnull([17],0)+
        isnull([18],0)+
        isnull([19],0)+
        isnull([20],0)+
        isnull([21],0)+
        isnull([22],0)+
        isnull([23],0)+
        isnull([24],0)+
        isnull([25],0)+
        isnull([26],0)+
        isnull([27],0)+
        isnull([28],0)+
        isnull([29],0)+
        isnull([30],0)+
        isnull([31],0))
             as TOTAL
                  FROM (
                       select a.NamaUnit,
                       SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                      count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                      from DashboardData.dbo.dataRWJ a
                      where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
                      and IdUnit not in  ('9','10','47','48','49','52','17','1','52','53')
                      group by a.NamaUnit,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                       
                  ) AS QuarterlyData
                  PIVOT( SUM([REGISTRASI Count])   
                          FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
          [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
          [25],[26],[27],[28],[29],[30],[31],
                          [grandtotal])) AS QPivot
                          order by NamaUnit asc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaUnit'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '2' && $JenisRekap == '4') {

                $query = "SELECT NamaUnit,
            isnull([01],0) as satu,
        isnull([02],0) as dua,
        isnull([03],0) as tiga,
        isnull([04],0) as empat,
        isnull([05],0) as lima,
        isnull([06],0) as enam,
        isnull([07],0) as Jtujuh,
        isnull([08],0) as delapan,
        isnull([09],0) as sembilan,
        isnull([10],0) as sepuluh,
        isnull([11],0) as sebelah,
        isnull([12],0) as duabelas,
        isnull([13],0) as tigabelas,
        isnull([14],0) as empatbelas,
        isnull([15],0) as limabelas,
        isnull([16],0) as enambelas,
        isnull([17],0) as tujuhbelas,
        isnull([18],0) as delapanbelas,
        isnull([19],0) as sembilanbelas,
        isnull([20],0) as duapuluh,
        isnull([21],0) as duapuluhsatu,
        isnull([22],0) as duapuluhdua,
        isnull([23],0) as duapuluhtiga,
        isnull([24],0) as duapuluhempat,
        isnull([25],0) as duapuluhlima,
        isnull([26],0) as duapuluhenam,
        isnull([27],0) as duapuluhtujuh,
        isnull([28],0) as duapuluhdelapan,
        isnull([29],0) as duapuluhlsembilan,
        isnull([30],0) as tigapuluh,
        isnull([31],0) as tigapuluhsatu,
        (isnull([01],0)+
        isnull([02],0)+
        isnull([03],0)+
        isnull([04],0)+
        isnull([05],0)+
        isnull([06],0)+
        isnull([07],0)+
        isnull([08],0)+
        isnull([09],0)+
        isnull([10],0)+
        isnull([11],0)+
        isnull([12],0)+
        isnull([13],0)+
        isnull([14],0)+
        isnull([15],0)+
        isnull([16],0)+
        isnull([17],0)+
        isnull([18],0)+
        isnull([19],0)+
        isnull([20],0)+
        isnull([21],0)+
        isnull([22],0)+
        isnull([23],0)+
        isnull([24],0)+
        isnull([25],0)+
        isnull([26],0)+
        isnull([27],0)+
        isnull([28],0)+
        isnull([29],0)+
        isnull([30],0)+
        isnull([31],0))
             as TOTAL
                  FROM (
                       select a.NamaUnit,
                       SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                      count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                      from DashboardData.dbo.dataRWJ a
                      where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
                      and IdUnit in  ('1')
                      group by a.NamaUnit,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                       
                  ) AS QuarterlyData
                  PIVOT( SUM([REGISTRASI Count])   
                          FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
          [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
          [25],[26],[27],[28],[29],[30],[31],
                          [grandtotal])) AS QPivot
                          order by NamaUnit asc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaUnit'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '3' && $JenisRekap == '4') {

                $query = "SELECT NamaUnit,
            isnull([01],0) as satu,
        isnull([02],0) as dua,
        isnull([03],0) as tiga,
        isnull([04],0) as empat,
        isnull([05],0) as lima,
        isnull([06],0) as enam,
        isnull([07],0) as Jtujuh,
        isnull([08],0) as delapan,
        isnull([09],0) as sembilan,
        isnull([10],0) as sepuluh,
        isnull([11],0) as sebelah,
        isnull([12],0) as duabelas,
        isnull([13],0) as tigabelas,
        isnull([14],0) as empatbelas,
        isnull([15],0) as limabelas,
        isnull([16],0) as enambelas,
        isnull([17],0) as tujuhbelas,
        isnull([18],0) as delapanbelas,
        isnull([19],0) as sembilanbelas,
        isnull([20],0) as duapuluh,
        isnull([21],0) as duapuluhsatu,
        isnull([22],0) as duapuluhdua,
        isnull([23],0) as duapuluhtiga,
        isnull([24],0) as duapuluhempat,
        isnull([25],0) as duapuluhlima,
        isnull([26],0) as duapuluhenam,
        isnull([27],0) as duapuluhtujuh,
        isnull([28],0) as duapuluhdelapan,
        isnull([29],0) as duapuluhlsembilan,
        isnull([30],0) as tigapuluh,
        isnull([31],0) as tigapuluhsatu,
        (isnull([01],0)+
        isnull([02],0)+
        isnull([03],0)+
        isnull([04],0)+
        isnull([05],0)+
        isnull([06],0)+
        isnull([07],0)+
        isnull([08],0)+
        isnull([09],0)+
        isnull([10],0)+
        isnull([11],0)+
        isnull([12],0)+
        isnull([13],0)+
        isnull([14],0)+
        isnull([15],0)+
        isnull([16],0)+
        isnull([17],0)+
        isnull([18],0)+
        isnull([19],0)+
        isnull([20],0)+
        isnull([21],0)+
        isnull([22],0)+
        isnull([23],0)+
        isnull([24],0)+
        isnull([25],0)+
        isnull([26],0)+
        isnull([27],0)+
        isnull([28],0)+
        isnull([29],0)+
        isnull([30],0)+
        isnull([31],0))
             as TOTAL
                  FROM (
                       select a.NamaUnit,
                       SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                      count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                      from DashboardData.dbo.dataRWJ a
                      where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
                      and IdUnit in  ('53')
                      group by a.NamaUnit,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                       
                  ) AS QuarterlyData
                  PIVOT( SUM([REGISTRASI Count])   
                          FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
          [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
          [25],[26],[27],[28],[29],[30],[31],
                          [grandtotal])) AS QPivot
                          order by NamaUnit asc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaUnit'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '6' && $JenisRekap == '4') {
                $query = "SELECT NamaUnit,
            isnull([01],0) as satu,
        isnull([02],0) as dua,
        isnull([03],0) as tiga,
        isnull([04],0) as empat,
        isnull([05],0) as lima,
        isnull([06],0) as enam,
        isnull([07],0) as Jtujuh,
        isnull([08],0) as delapan,
        isnull([09],0) as sembilan,
        isnull([10],0) as sepuluh,
        isnull([11],0) as sebelah,
        isnull([12],0) as duabelas,
        isnull([13],0) as tigabelas,
        isnull([14],0) as empatbelas,
        isnull([15],0) as limabelas,
        isnull([16],0) as enambelas,
        isnull([17],0) as tujuhbelas,
        isnull([18],0) as delapanbelas,
        isnull([19],0) as sembilanbelas,
        isnull([20],0) as duapuluh,
        isnull([21],0) as duapuluhsatu,
        isnull([22],0) as duapuluhdua,
        isnull([23],0) as duapuluhtiga,
        isnull([24],0) as duapuluhempat,
        isnull([25],0) as duapuluhlima,
        isnull([26],0) as duapuluhenam,
        isnull([27],0) as duapuluhtujuh,
        isnull([28],0) as duapuluhdelapan,
        isnull([29],0) as duapuluhlsembilan,
        isnull([30],0) as tigapuluh,
        isnull([31],0) as tigapuluhsatu,
        (isnull([01],0)+
        isnull([02],0)+
        isnull([03],0)+
        isnull([04],0)+
        isnull([05],0)+
        isnull([06],0)+
        isnull([07],0)+
        isnull([08],0)+
        isnull([09],0)+
        isnull([10],0)+
        isnull([11],0)+
        isnull([12],0)+
        isnull([13],0)+
        isnull([14],0)+
        isnull([15],0)+
        isnull([16],0)+
        isnull([17],0)+
        isnull([18],0)+
        isnull([19],0)+
        isnull([20],0)+
        isnull([21],0)+
        isnull([22],0)+
        isnull([23],0)+
        isnull([24],0)+
        isnull([25],0)+
        isnull([26],0)+
        isnull([27],0)+
        isnull([28],0)+
        isnull([29],0)+
        isnull([30],0)+
        isnull([31],0))
             as TOTAL
                  FROM (
                       select a.NamaUnit,
                       SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                      count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                      from DashboardData.dbo.dataRWJ a
                      where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7)=:Periode
                      and IdUnit in  ('47')
                      group by a.NamaUnit,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                       
                  ) AS QuarterlyData
                  PIVOT( SUM([REGISTRASI Count])   
                          FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
          [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
          [25],[26],[27],[28],[29],[30],[31],
                          [grandtotal])) AS QPivot
                          order by NamaUnit asc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaUnit'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '1' && $JenisRekap == '6') {
                $query = "SELECT NamaPerusahaan  ,
            isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
            isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
            isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
            isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
            isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
            isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
            isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
            isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0))
             as TOTAL
                FROM (
                    select  a.NamaJaminan as NamaPerusahaan,
                    SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                    count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                    from DashboardData.dbo.dataRWJ a
                    --inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                    --inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                    --inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                    --inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                    --left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                    --inner join MasterdataSQL.dbo.MstrPerusahaanJPK OC ON OC.ID = A.Perusahaan
                    where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7):Periode
                --and a.Batal='0'   and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG') 
                  --  AND PG.ID<>'53' 
                    and a.IdUnit not in ('9','10','47','48','49','52','17','1','53')
                and a.TipePasien<>'2'
                    group by a.NamaJaminan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                    
                ) AS QuarterlyData
                PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31],
            [grandtotal])) AS QPivot";


                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaPerusahaan'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '1' && $JenisRekap == '7') {
                $query = "SELECT NamaPerusahaan  ,
            isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
            isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
            isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
            isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
            isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
            isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
            isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
            isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0))
             as TOTAL
                FROM (
                    select  a.NamaJaminan as NamaPerusahaan,
                    SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                    count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                    from DashboardData.dbo.dataRWJ a
                    --inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                    --inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                    --inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                    --inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                    --left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                    --inner join MasterdataSQL.dbo.MstrPerusahaanJPK OC ON OC.ID = A.Perusahaan
                    where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7):Periode
                --and a.Batal='0'   and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG') 
                  --  AND PG.ID<>'53' 
                    and a.IdUnit not in ('9','10','47','48','49','52','17','1','53')
                and a.TipePasien='2'
                    group by a.NamaJaminan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                    
                ) AS QuarterlyData
                PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31],
            [grandtotal])) AS QPivot";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaPerusahaan'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '2' && $JenisRekap == '6') {
                $query = "SELECT NamaPerusahaan  ,
            isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
            isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
            isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
            isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
            isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
            isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
            isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
            isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0))
             as TOTAL
                FROM (
                    select  a.NamaJaminan as NamaPerusahaan,
                    SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                    count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                    from DashboardData.dbo.dataRWJ a
                    --inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                    --inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                    --inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                    --inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                    --left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                    --inner join MasterdataSQL.dbo.MstrPerusahaanJPK OC ON OC.ID = A.Perusahaan
                    where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7):Periode
                --and a.Batal='0'   and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG') 
                  --  AND PG.ID<>'53' 
                    and a.IdUnit in ('1')
                and a.TipePasien<>'2'
                    group by a.NamaJaminan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                    
                ) AS QuarterlyData
                PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31],
            [grandtotal])) AS QPivot";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaPerusahaan'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '2' && $JenisRekap == '7') {

                $query = "SELECT NamaPerusahaan  ,
            isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
            isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
            isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
            isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
            isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
            isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
            isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
            isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0))
             as TOTAL
                FROM (
                    select  a.NamaJaminan as NamaPerusahaan,
                    SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                    count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                    from DashboardData.dbo.dataRWJ a
                    --inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                    --inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                    --inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                    --inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                    --left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                    --inner join MasterdataSQL.dbo.MstrPerusahaanJPK OC ON OC.ID = A.Perusahaan
                    where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7):Periode
                --and a.Batal='0'   and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG') 
                  --  AND PG.ID<>'53' 
                    and a.IdUnit in ('1')
                and a.TipePasien='2'
                    group by a.NamaJaminan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                    
                ) AS QuarterlyData
                PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31],
            [grandtotal])) AS QPivot";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaPerusahaan'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '3' && $JenisRekap == '6') {
                $query = "SELECT NamaPerusahaan  ,
            isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
            isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
            isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
            isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
            isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
            isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
            isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
            isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0))
             as TOTAL
                FROM (
                    select  a.NamaJaminan as NamaPerusahaan,
                    SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                    count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                    from DashboardData.dbo.dataRWJ a
                    where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7):Periode
                    and a.IdUnit in ('53')
                and a.TipePasien<>'2'
                    group by a.NamaJaminan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                    
                ) AS QuarterlyData
                PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31],
            [grandtotal])) AS QPivot";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaPerusahaan'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '3' && $JenisRekap == '7') {
                $query = "SELECT NamaPerusahaan  ,
            isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
            isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
            isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
            isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
            isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
            isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
            isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
            isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0))
             as TOTAL
                FROM (
                    select  a.NamaJaminan as NamaPerusahaan,
                    SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                    count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                    from DashboardData.dbo.dataRWJ a
                    where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7):Periode
                    and a.IdUnit in ('53')
                and a.TipePasien='2'
                    group by a.NamaJaminan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                    
                ) AS QuarterlyData
                PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31],
            [grandtotal])) AS QPivot";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaPerusahaan'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '4' && $JenisRekap == '6') {
                $query = "SELECT NamaPerusahaan,
               isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
			isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
			isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
			isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
			isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
			isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
			isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
			isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0))
                 as TOTAL
                      FROM (
                           select  oc.NamaPerusahaan,
                           SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),6,2) [Quarter],
                          count(isnull(a.drPenerima,0)) as  [REGISTRASI Count]
                          from RawatInapSQL.dbo.Inpatient a
                          inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                          inner join MasterdataSQL.dbo.Doctors c on c.ID = a.drPenerima
						  inner join MasterdataSQL.dbo.MstrPerusahaanJPK OC ON OC.ID = A.IDJPK
                          where YEAR(a.StartDate)=:Periode
                          group by oc.NamaPerusahaan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),6,2)
                           
                      ) AS QuarterlyData
                      PIVOT( SUM([REGISTRASI Count])   
                              FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31],
                              [grandtotal])) AS QPivot
                              order by TOTAL desc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaPerusahaan'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '4' && $JenisRekap == '7') {
                $query = "SELECT NamaPerusahaan,
               isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
			isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
			isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
			isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
			isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
			isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
			isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
			isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0))
                 as TOTAL
                      FROM (
                           select  oc.NamaPerusahaan,
                           SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),6,2) [Quarter],
                          count(isnull(a.drPenerima,0)) as  [REGISTRASI Count]
                          from RawatInapSQL.dbo.Inpatient a
                          inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                          inner join MasterdataSQL.dbo.Doctors c on c.ID = a.drPenerima
						  inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi OC ON OC.ID = A.IDAsuransi
                          where YEAR(a.StartDate)=:Periode
                          group by oc.NamaPerusahaan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),6,2)
                           
                      ) AS QuarterlyData
                      PIVOT( SUM([REGISTRASI Count])   
                              FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31],
                              [grandtotal])) AS QPivot
                              order by TOTAL desc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaPerusahaan'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '6' && $JenisRekap == '6') {
                $query = "SELECT NamaPerusahaan  ,
            isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
            isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
            isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
            isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
            isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
            isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
            isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
            isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0))
             as TOTAL
                FROM (
                    select  a.NamaJaminan as NamaPerusahaan,
                    SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                    count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                    from DashboardData.dbo.dataRWJ a
                    where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7):Periode
                    and a.IdUnit in ('47')
                and a.TipePasien<>'2'
                    group by a.NamaJaminan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                    
                ) AS QuarterlyData
                PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31],
            [grandtotal])) AS QPivot";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaPerusahaan'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '6' && $JenisRekap == '7') {
                $query = "SELECT NamaPerusahaan  ,
            isnull([01],0) as satu,
            isnull([02],0) as dua,
            isnull([03],0) as tiga,
            isnull([04],0) as empat,
            isnull([05],0) as lima,
            isnull([06],0) as enam,
            isnull([07],0) as Jtujuh,
            isnull([08],0) as delapan,
            isnull([09],0) as sembilan,
            isnull([10],0) as sepuluh,
            isnull([11],0) as sebelah,
            isnull([12],0) as duabelas,
            isnull([13],0) as tigabelas,
            isnull([14],0) as empatbelas,
            isnull([15],0) as limabelas,
            isnull([16],0) as enambelas,
            isnull([17],0) as tujuhbelas,
            isnull([18],0) as delapanbelas,
            isnull([19],0) as sembilanbelas,
            isnull([20],0) as duapuluh,
            isnull([21],0) as duapuluhsatu,
            isnull([22],0) as duapuluhdua,
            isnull([23],0) as duapuluhtiga,
            isnull([24],0) as duapuluhempat,
            isnull([25],0) as duapuluhlima,
            isnull([26],0) as duapuluhenam,
            isnull([27],0) as duapuluhtujuh,
            isnull([28],0) as duapuluhdelapan,
            isnull([29],0) as duapuluhlsembilan,
            isnull([30],0) as tigapuluh,
            isnull([31],0) as tigapuluhsatu,
            (isnull([01],0)+
            isnull([02],0)+
            isnull([03],0)+
            isnull([04],0)+
            isnull([05],0)+
            isnull([06],0)+
            isnull([07],0)+
            isnull([08],0)+
            isnull([09],0)+
            isnull([10],0)+
            isnull([11],0)+
            isnull([12],0)+
            isnull([13],0)+
            isnull([14],0)+
            isnull([15],0)+
            isnull([16],0)+
            isnull([17],0)+
            isnull([18],0)+
            isnull([19],0)+
            isnull([20],0)+
            isnull([21],0)+
            isnull([22],0)+
            isnull([23],0)+
            isnull([24],0)+
            isnull([25],0)+
            isnull([26],0)+
            isnull([27],0)+
            isnull([28],0)+
            isnull([29],0)+
            isnull([30],0)+
            isnull([31],0))
             as TOTAL
                FROM (
                    select  a.NamaJaminan as NamaPerusahaan,
                    SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                    count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                    from DashboardData.dbo.dataRWJ a
                    where SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),1,7):Periode
                    and a.IdUnit in ('47')
                and a.TipePasien='2'
                    group by a.NamaJaminan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                    
                ) AS QuarterlyData
                PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
              [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23],[24],
              [25],[26],[27],[28],[29],[30],[31],
            [grandtotal])) AS QPivot";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaPerusahaan'];
                    $pasing['01']  = $row['satu'];
                    $pasing['02']  = $row['dua'];
                    $pasing['03']  = $row['tiga'];
                    $pasing['04']  = $row['empat'];
                    $pasing['05']  = $row['lima'];
                    $pasing['06']  = $row['enam'];
                    $pasing['07']  = $row['Jtujuh'];
                    $pasing['08']  = $row['delapan'];
                    $pasing['09']  = $row['sembilan'];
                    $pasing['10']  = $row['sepuluh'];
                    $pasing['11']  = $row['sebelah'];
                    $pasing['12']  = $row['duabelas'];
                    $pasing['13']  = $row['tigabelas'];
                    $pasing['14']  = $row['empatbelas'];
                    $pasing['15']  = $row['limabelas'];
                    $pasing['16']  = $row['enambelas'];
                    $pasing['17']  = $row['tujuhbelas'];
                    $pasing['18']  = $row['delapanbelas'];
                    $pasing['19']  = $row['sembilanbelas'];
                    $pasing['20']  = $row['duapuluh'];
                    $pasing['21']  = $row['duapuluhsatu'];
                    $pasing['22']  = $row['duapuluhdua'];
                    $pasing['23']  = $row['duapuluhtiga'];
                    $pasing['24']  = $row['duapuluhempat'];
                    $pasing['25']  = $row['duapuluhlima'];
                    $pasing['26']  = $row['duapuluhenam'];
                    $pasing['27']  = $row['duapuluhtujuh'];
                    $pasing['28']  = $row['duapuluhdelapan'];
                    $pasing['29']  = $row['duapuluhlsembilan'];
                    $pasing['30']  = $row['tigapuluh'];
                    $pasing['31']  = $row['tigapuluhsatu'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            }

            return $data;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getIDDokter()
    {
        try {
            $this->db->query("SELECT ID, First_Name
             from MasterdataSQL.dbo.Doctors 
                                   where active='1'");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['First_Name'] = $key['First_Name'];
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
}
