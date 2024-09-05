<?php
class  B_InformationRekapRegistrasi_Model
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
                $query = "SELECT First_Name as NamaDokter,
            isnull([01],0) as JAN,
            isnull([02],0) as FEB,
            isnull([03],0) as MAR,
            isnull([04],0) as APR,
            isnull([05],0) as MAY,
            isnull([06],0) as JUN,
            isnull([07],0) as JUL,
            isnull([08],0) as AUG,
            isnull([09],0) as SEP,
            isnull([10],0) as OCT,
            isnull([11],0) as NOV,
            isnull([12],0) as DEC,
            
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
            isnull([12],0))
             as TOTAL
    FROM (
         select  c.First_Name,
         SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2) [Quarter],
        count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
        from PerawatanSQL.dbo.Visit a
        inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
        inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
        inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
        inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
        left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
        where YEAR(a.TglKunjungan)=:Periode
        and a.Batal='0'   and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG') 
        AND PG.ID<>'53' 
        and pg.id not in ('9','10','47','48','49','52','17','1','53')
        group by c.First_Name,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2)
         
    ) AS QuarterlyData
    PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
            [grandtotal])) AS QPivot";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } else  if ($JenisPasien == '6' && $JenisRekap == '1') {
                $query = "SELECT First_Name as NamaDokter,
            isnull([01],0) as JAN,
            isnull([02],0) as FEB,
            isnull([03],0) as MAR,
            isnull([04],0) as APR,
            isnull([05],0) as MAY,
            isnull([06],0) as JUN,
            isnull([07],0) as JUL,
            isnull([08],0) as AUG,
            isnull([09],0) as SEP,
            isnull([10],0) as OCT,
            isnull([11],0) as NOV,
            isnull([12],0) as DEC,
            
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
            isnull([12],0))
             as TOTAL
    FROM (
         select  c.First_Name,
         SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2) [Quarter],
        count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
        from PerawatanSQL.dbo.Visit a
        inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
        inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
        inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
        inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
        left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
        where YEAR(a.TglKunjungan)=:Periode
        and a.Batal='0'    
        and pg.id   in ('47')
        group by c.First_Name,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2)
         
    ) AS QuarterlyData
    PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
            [grandtotal])) AS QPivot";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } else  if ($JenisPasien == '7' && $JenisRekap == '1') {
                $query = "SELECT First_Name as NamaDokter,
            isnull([01],0) as JAN,
            isnull([02],0) as FEB,
            isnull([03],0) as MAR,
            isnull([04],0) as APR,
            isnull([05],0) as MAY,
            isnull([06],0) as JUN,
            isnull([07],0) as JUL,
            isnull([08],0) as AUG,
            isnull([09],0) as SEP,
            isnull([10],0) as OCT,
            isnull([11],0) as NOV,
            isnull([12],0) as DEC,
            
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
            isnull([12],0))
             as TOTAL
    FROM (
         select  c.First_Name,
         SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2) [Quarter],
        count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
        from PerawatanSQL.dbo.Visit a
        inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
        inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
        inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
        inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
        left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
        where YEAR(a.TglKunjungan)=:Periode
         and a.Batal='0'  
       and pg.id  in ('9','10','48','49','52','17')
        group by c.First_Name,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2)
         
    ) AS QuarterlyData
    PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
            [grandtotal])) AS QPivot";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '2' && $JenisRekap == '1') {
                $query = "SELECT First_Name as NamaDokter,
            isnull([01],0) as JAN,
            isnull([02],0) as FEB,
            isnull([03],0) as MAR,
            isnull([04],0) as APR,
            isnull([05],0) as MAY,
            isnull([06],0) as JUN,
            isnull([07],0) as JUL,
            isnull([08],0) as AUG,
            isnull([09],0) as SEP,
            isnull([10],0) as OCT,
            isnull([11],0) as NOV,
            isnull([12],0) as DEC,
            
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
            isnull([12],0))
             as TOTAL
    FROM (
         select  c.First_Name,
         SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2) [Quarter],
        count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
        from PerawatanSQL.dbo.Visit a
        inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
        inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
        inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
        inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
        left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
        where YEAR(a.TglKunjungan)=:Periode
        and a.Batal='0'    and pg.id  in ('1')
        group by c.First_Name,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2)
         
    ) AS QuarterlyData
    PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
            [grandtotal])) AS QPivot";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '3' && $JenisRekap == '1') {
                $query = "SELECT First_Name as NamaDokter,
            isnull([01],0) as JAN,
            isnull([02],0) as FEB,
            isnull([03],0) as MAR,
            isnull([04],0) as APR,
            isnull([05],0) as MAY,
            isnull([06],0) as JUN,
            isnull([07],0) as JUL,
            isnull([08],0) as AUG,
            isnull([09],0) as SEP,
            isnull([10],0) as OCT,
            isnull([11],0) as NOV,
            isnull([12],0) as DEC,
            
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
            isnull([12],0))
             as TOTAL
    FROM (
         select  c.First_Name,
         SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2) [Quarter],
        count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
        from PerawatanSQL.dbo.Visit a
        inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
        inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
        inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
        inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
        left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
        where YEAR(a.TglKunjungan)=:Periode
        and a.Batal='0'  
        AND PG.ID='53'  
        group by c.First_Name,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2)
         
    ) AS QuarterlyData
    PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
            [grandtotal])) AS QPivot";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaDokter']  = $row['NamaDokter'];
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '4' && $JenisRekap == '1') {
                $query = "SELECT JenisRawat,First_Name as NamaDokter,
                isnull([01],0) as JAN,
                isnull([02],0) as FEB,
                isnull([03],0) as MAR,
                isnull([04],0) as APR,
                isnull([05],0) as MAY,
                isnull([06],0) as JUN,
                isnull([07],0) as JUL,
                isnull([08],0) as AUG,
                isnull([09],0) as SEP,
                isnull([10],0) as OCT,
                isnull([11],0) as NOV,
                isnull([12],0) as DEC,
                
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
                isnull([12],0))
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
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '5' && $JenisRekap == '1') {
                $query = "SELECT GroupSpesialis,DrOperator as NamaDokter,
                isnull([01],0) as JAN,
                isnull([02],0) as FEB,
                isnull([03],0) as MAR,
                isnull([04],0) as APR,
                isnull([05],0) as MAY,
                isnull([06],0) as JUN,
                isnull([07],0) as JUL,
                isnull([08],0) as AUG,
                isnull([09],0) as SEP,
                isnull([10],0) as OCT,
                isnull([11],0) as NOV,
                isnull([12],0) as DEC,
                
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
                isnull([12],0))
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
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } else  if ($JenisPasien == '5' && $JenisRekap == '4') {
                $query = "SELECT GroupSpesialis,
                isnull([01],0) as JAN,
                isnull([02],0) as FEB,
                isnull([03],0) as MAR,
                isnull([04],0) as APR,
                isnull([05],0) as MAY,
                isnull([06],0) as JUN,
                isnull([07],0) as JUL,
                isnull([08],0) as AUG,
                isnull([09],0) as SEP,
                isnull([10],0) as OCT,
                isnull([11],0) as NOV,
                isnull([12],0) as DEC,
                
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
                isnull([12],0))
                 as TOTAL
        FROM (
             select  d.GroupSpesialis,
             SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),6,2) [Quarter],
            count(isnull(a.drPenerima,0)) as  [REGISTRASI Count]
            from RawatInapSQL.dbo.Inpatient a
            inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
            inner join MedicalRecord.dbo.EMR_OrderOperasi d on a.NoRegRI  collate SQL_Latin1_General_CP1_CI_AS=d.NoRegistrasi  collate SQL_Latin1_General_CP1_CI_AS
            where YEAR(a.StartDate)= :Periode and d.StatusOrder='Approved OT' 
            group by d.GroupSpesialis,d.DrOperator,SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),6,2)
             
        ) AS QuarterlyData
        PIVOT( SUM([REGISTRASI Count])   
                FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
                [grandtotal])) AS QPivot
                order by GroupSpesialis asc";
                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaUNIT']  = $row['GroupSpesialis'];
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '1' && $JenisRekap == '3') {
                $query = "SELECT NamaCaraMasukRef as NamaRujukan,NamaUnit,First_Name as NamaDokter,
                isnull([01],0) as JAN,
                isnull([02],0) as FEB,
                isnull([03],0) as MAR,
                isnull([04],0) as APR,
                isnull([05],0) as MAY,
                isnull([06],0) as JUN,
                isnull([07],0) as JUL,
                isnull([08],0) as AUG,
                isnull([09],0) as SEP,
                isnull([10],0) as OCT,
                isnull([11],0) as NOV,
                isnull([12],0) as DEC,
                
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
                isnull([12],0))
                 as TOTAL
                      FROM (
                           select  f.NamaCaraMasukRef,pg.NamaUnit, c.First_Name,
                           SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2) [Quarter],
                          count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                          from PerawatanSQL.dbo.Visit a
                          inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                          inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                          inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                          inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
              --inner join MasterdataSQL.dbo.MstrCaraMasuk e on a.idCaraMasuk=e.id
              inner join MasterdataSQL.dbo.MstrCaraMasuk_2 f on a.idCaraMasuk2=f.id
                          left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                          where YEAR(a.TglKunjungan)=:Periode
                          and a.Batal='0'    and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG')  
                          and pg.id not in  ('9','10','47','48','49','52','17','1','52','53')
                          group by f.NamaCaraMasukRef,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2),pg.NamaUnit, c.First_Name
                           
                      ) AS QuarterlyData
                      PIVOT( SUM([REGISTRASI Count])   
                              FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
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
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '6' && $JenisRekap == '3') {
                $query = "SELECT NamaCaraMasukRef as NamaRujukan,NamaUnit,First_Name as NamaDokter,
                isnull([01],0) as JAN,
                isnull([02],0) as FEB,
                isnull([03],0) as MAR,
                isnull([04],0) as APR,
                isnull([05],0) as MAY,
                isnull([06],0) as JUN,
                isnull([07],0) as JUL,
                isnull([08],0) as AUG,
                isnull([09],0) as SEP,
                isnull([10],0) as OCT,
                isnull([11],0) as NOV,
                isnull([12],0) as DEC,
                
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
                isnull([12],0))
                 as TOTAL
                      FROM (
                           select  f.NamaCaraMasukRef,pg.NamaUnit, c.First_Name,
                           SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2) [Quarter],
                          count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                          from PerawatanSQL.dbo.Visit a
                          inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                          inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                          inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                          inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit 
              inner join MasterdataSQL.dbo.MstrCaraMasuk_2 f on a.idCaraMasuk2=f.id
                          left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                          where YEAR(a.TglKunjungan)=:Periode
                          and a.Batal='0'   
                          and pg.id  in ('47')
                          group by f.NamaCaraMasukRef,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2),pg.NamaUnit, c.First_Name
                           
                      ) AS QuarterlyData
                      PIVOT( SUM([REGISTRASI Count])   
                              FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
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
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '7' && $JenisRekap == '3') {
                $query = "SELECT NamaCaraMasukRef as NamaRujukan,NamaUnit,First_Name as NamaDokter,
                isnull([01],0) as JAN,
                isnull([02],0) as FEB,
                isnull([03],0) as MAR,
                isnull([04],0) as APR,
                isnull([05],0) as MAY,
                isnull([06],0) as JUN,
                isnull([07],0) as JUL,
                isnull([08],0) as AUG,
                isnull([09],0) as SEP,
                isnull([10],0) as OCT,
                isnull([11],0) as NOV,
                isnull([12],0) as DEC,
                
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
                isnull([12],0))
                 as TOTAL
                      FROM (
                           select  f.NamaCaraMasukRef,pg.NamaUnit, c.First_Name,
                           SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2) [Quarter],
                          count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                          from PerawatanSQL.dbo.Visit a
                          inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                          inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                          inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                          inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit 
                          inner join MasterdataSQL.dbo.MstrCaraMasuk_2 f on a.idCaraMasuk2=f.id
                          left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                          where YEAR(a.TglKunjungan)=:Periode
                           and a.Batal='0'  
                            and pg.id  in ('9','10','48','49','52','17')
                          group by f.NamaCaraMasukRef,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2),pg.NamaUnit, c.First_Name
                           
                      ) AS QuarterlyData
                      PIVOT( SUM([REGISTRASI Count])   
                              FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
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
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '2' && $JenisRekap == '3') {
                $query = "SELECT NamaCaraMasukRef as NamaRujukan,NamaUnit,First_Name as NamaDokter,
                isnull([01],0) as JAN,
                isnull([02],0) as FEB,
                isnull([03],0) as MAR,
                isnull([04],0) as APR,
                isnull([05],0) as MAY,
                isnull([06],0) as JUN,
                isnull([07],0) as JUL,
                isnull([08],0) as AUG,
                isnull([09],0) as SEP,
                isnull([10],0) as OCT,
                isnull([11],0) as NOV,
                isnull([12],0) as DEC,
                
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
                isnull([12],0))
                 as TOTAL
                      FROM (
                           select  f.NamaCaraMasukRef,pg.NamaUnit, c.First_Name,
                           SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2) [Quarter],
                          count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                          from PerawatanSQL.dbo.Visit a
                          inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                          inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                          inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                          inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit 
              inner join MasterdataSQL.dbo.MstrCaraMasuk_2 f on a.idCaraMasuk2=f.id
                          left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                          where YEAR(a.TglKunjungan)=:Periode
                          and a.Batal='0'   and pg.id  in ('1')
                          group by f.NamaCaraMasukRef,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2),pg.NamaUnit, c.First_Name
                           
                      ) AS QuarterlyData
                      PIVOT( SUM([REGISTRASI Count])   
                              FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
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
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '3' && $JenisRekap == '3') {
                $query = "SELECT NamaCaraMasukRef as NamaRujukan,NamaUnit,First_Name as NamaDokter,
                isnull([01],0) as JAN,
                isnull([02],0) as FEB,
                isnull([03],0) as MAR,
                isnull([04],0) as APR,
                isnull([05],0) as MAY,
                isnull([06],0) as JUN,
                isnull([07],0) as JUL,
                isnull([08],0) as AUG,
                isnull([09],0) as SEP,
                isnull([10],0) as OCT,
                isnull([11],0) as NOV,
                isnull([12],0) as DEC,
                
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
                isnull([12],0))
                 as TOTAL
                      FROM (
                           select  f.NamaCaraMasukRef,pg.NamaUnit, c.First_Name,
                           SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2) [Quarter],
                          count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                          from PerawatanSQL.dbo.Visit a
                          inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                          inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                          inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                          inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit 
              inner join MasterdataSQL.dbo.MstrCaraMasuk_2 f on a.idCaraMasuk2=f.id
                          left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                          where YEAR(a.TglKunjungan)=:Periode
                          and a.Batal='0'  
                          AND PG.ID='53'  
                          group by f.NamaCaraMasukRef,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2),pg.NamaUnit, c.First_Name
                           
                      ) AS QuarterlyData
                      PIVOT( SUM([REGISTRASI Count])   
                              FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
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
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '4' && $JenisRekap == '3') {
                $query = "SELECT NamaCaraMasukRef as NamaRujukan,JenisRawat,First_Name as NamaDokter,
                isnull([01],0) as JAN,
                isnull([02],0) as FEB,
                isnull([03],0) as MAR,
                isnull([04],0) as APR,
                isnull([05],0) as MAY,
                isnull([06],0) as JUN,
                isnull([07],0) as JUL,
                isnull([08],0) as AUG,
                isnull([09],0) as SEP,
                isnull([10],0) as OCT,
                isnull([11],0) as NOV,
                isnull([12],0) as DEC,
                
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
                isnull([12],0))
                 as TOTAL
        FROM (
             select  f.NamaCaraMasukRef,JenisRawat, c.First_Name,
             SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),6,2) [Quarter],
            count(isnull(a.drPenerima,0)) as  [REGISTRASI Count]
            from RawatInapSQL.dbo.Inpatient a
            inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
            inner join MasterdataSQL.dbo.Doctors c on c.ID = a.drPenerima
            inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.TypePatient  
            inner join MasterdataSQL.dbo.MstrCaraMasuk_2 f on a.idCaraMasuk2=f.id
            where YEAR(a.StartDate)=:Periode 
            group by f.NamaCaraMasukRef,SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),6,2),JenisRawat, c.First_Name
             
        ) AS QuarterlyData
        PIVOT( SUM([REGISTRASI Count])   
                FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
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
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '5' && $JenisRekap == '3') {
                $query = "SELECT NamaCaraMasukRef as NamaRujukan,GroupSpesialis,DrOperator as NamaDokter,
                isnull([01],0) as JAN,
                isnull([02],0) as FEB,
                isnull([03],0) as MAR,
                isnull([04],0) as APR,
                isnull([05],0) as MAY,
                isnull([06],0) as JUN,
                isnull([07],0) as JUL,
                isnull([08],0) as AUG,
                isnull([09],0) as SEP,
                isnull([10],0) as OCT,
                isnull([11],0) as NOV,
                isnull([12],0) as DEC,
                
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
                isnull([12],0))
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
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '1' && $JenisRekap == '2') {
                $query = "SELECT NamaUnit,First_Name as NamaDokter,
                isnull([01],0) as JAN,
                isnull([02],0) as FEB,
                isnull([03],0) as MAR,
                isnull([04],0) as APR,
                isnull([05],0) as MAY,
                isnull([06],0) as JUN,
                isnull([07],0) as JUL,
                isnull([08],0) as AUG,
                isnull([09],0) as SEP,
                isnull([10],0) as OCT,
                isnull([11],0) as NOV,
                isnull([12],0) as DEC,
                
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
                isnull([12],0))
                 as TOTAL
                      FROM (
                           select pg.NamaUnit, c.First_Name,
                           SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2) [Quarter],
                          count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                          from PerawatanSQL.dbo.Visit a
                          inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                          inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                          inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                          inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                          left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                          where YEAR(a.TglKunjungan)=:Periode
                          and a.Batal='0'   
                         and pg.id not in ('9','10','47','48','49','52','17','1','53')
                          group by pg.NamaUnit,c.First_Name,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2)
                           
                      ) AS QuarterlyData
                      PIVOT( SUM([REGISTRASI Count])   
                              FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
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
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '6' && $JenisRekap == '2') {
                $query = "SELECT NamaUnit,First_Name as NamaDokter,
                isnull([01],0) as JAN,
                isnull([02],0) as FEB,
                isnull([03],0) as MAR,
                isnull([04],0) as APR,
                isnull([05],0) as MAY,
                isnull([06],0) as JUN,
                isnull([07],0) as JUL,
                isnull([08],0) as AUG,
                isnull([09],0) as SEP,
                isnull([10],0) as OCT,
                isnull([11],0) as NOV,
                isnull([12],0) as DEC,
                
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
                isnull([12],0))
                 as TOTAL
                      FROM (
                           select pg.NamaUnit, c.First_Name,
                           SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2) [Quarter],
                          count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                          from PerawatanSQL.dbo.Visit a
                          inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                          inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                          inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                          inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                          left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                          where YEAR(a.TglKunjungan)=:Periode
                          and a.Batal='0'   
                         and pg.id  in ('47')
                          group by pg.NamaUnit,c.First_Name,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2)
                           
                      ) AS QuarterlyData
                      PIVOT( SUM([REGISTRASI Count])   
                              FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
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
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '7' && $JenisRekap == '2') {
                $query = "SELECT NamaUnit,First_Name as NamaDokter,
                isnull([01],0) as JAN,
                isnull([02],0) as FEB,
                isnull([03],0) as MAR,
                isnull([04],0) as APR,
                isnull([05],0) as MAY,
                isnull([06],0) as JUN,
                isnull([07],0) as JUL,
                isnull([08],0) as AUG,
                isnull([09],0) as SEP,
                isnull([10],0) as OCT,
                isnull([11],0) as NOV,
                isnull([12],0) as DEC,
                
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
                isnull([12],0))
                 as TOTAL
                      FROM (
                           select pg.NamaUnit, c.First_Name,
                           SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2) [Quarter],
                          count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                          from PerawatanSQL.dbo.Visit a
                          inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                          inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                          inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                          inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                          left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                          where YEAR(a.TglKunjungan)=:Periode
                           and a.Batal='0'  
                            and pg.id  in ('9','10','48','49','52','17')
                          group by pg.NamaUnit,c.First_Name,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2)
                           
                      ) AS QuarterlyData
                      PIVOT( SUM([REGISTRASI Count])   
                              FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
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
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '2' && $JenisRekap == '2') {
                $query = "SELECT NamaUnit,First_Name as NamaDokter,
                isnull([01],0) as JAN,
                isnull([02],0) as FEB,
                isnull([03],0) as MAR,
                isnull([04],0) as APR,
                isnull([05],0) as MAY,
                isnull([06],0) as JUN,
                isnull([07],0) as JUL,
                isnull([08],0) as AUG,
                isnull([09],0) as SEP,
                isnull([10],0) as OCT,
                isnull([11],0) as NOV,
                isnull([12],0) as DEC,
                
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
                isnull([12],0))
                 as TOTAL
        FROM (
             select pg.NamaUnit, c.First_Name,
             SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2) [Quarter],
            count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
            from PerawatanSQL.dbo.Visit a
            inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
            inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
            inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
            inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
            left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
            where YEAR(a.TglKunjungan)=:Periode
            and a.Batal='0' and pg.id  in ('1') 
            group by pg.NamaUnit,c.First_Name,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2)
             
        ) AS QuarterlyData
        PIVOT( SUM([REGISTRASI Count])   
                FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
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
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '3' && $JenisRekap == '2') {
                $query = "SELECT NamaUnit,First_Name as NamaDokter,
                isnull([01],0) as JAN,
                isnull([02],0) as FEB,
                isnull([03],0) as MAR,
                isnull([04],0) as APR,
                isnull([05],0) as MAY,
                isnull([06],0) as JUN,
                isnull([07],0) as JUL,
                isnull([08],0) as AUG,
                isnull([09],0) as SEP,
                isnull([10],0) as OCT,
                isnull([11],0) as NOV,
                isnull([12],0) as DEC,
                
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
                isnull([12],0))
                 as TOTAL
        FROM (
             select pg.NamaUnit, c.First_Name,
             SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2) [Quarter],
            count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
            from PerawatanSQL.dbo.Visit a
            inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
            inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
            inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
            inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
            left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
            where YEAR(a.TglKunjungan)=:Periode
            and a.Batal='0'  
            AND PG.ID='53'  
            group by pg.NamaUnit,c.First_Name,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2)
             
        ) AS QuarterlyData
        PIVOT( SUM([REGISTRASI Count])   
                FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
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
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '4' && $JenisRekap == '2') {
                $query = "SELECT JenisRawat,First_Name as NamaDokter,
                isnull([01],0) as JAN,
                isnull([02],0) as FEB,
                isnull([03],0) as MAR,
                isnull([04],0) as APR,
                isnull([05],0) as MAY,
                isnull([06],0) as JUN,
                isnull([07],0) as JUL,
                isnull([08],0) as AUG,
                isnull([09],0) as SEP,
                isnull([10],0) as OCT,
                isnull([11],0) as NOV,
                isnull([12],0) as DEC,
                
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
                isnull([12],0))
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
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '5' && $JenisRekap == '2') {
                $query = "SELECT GroupSpesialis,DrOperator as NamaDokter,
                isnull([01],0) as JAN,
                isnull([02],0) as FEB,
                isnull([03],0) as MAR,
                isnull([04],0) as APR,
                isnull([05],0) as MAY,
                isnull([06],0) as JUN,
                isnull([07],0) as JUL,
                isnull([08],0) as AUG,
                isnull([09],0) as SEP,
                isnull([10],0) as OCT,
                isnull([11],0) as NOV,
                isnull([12],0) as DEC,
                
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
                isnull([12],0))
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
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '1' && $JenisRekap == '4') {
                $query = "SELECT NamaUnit,
                isnull([01],0) as JAN,
                isnull([02],0) as FEB,
                isnull([03],0) as MAR,
                isnull([04],0) as APR,
                isnull([05],0) as MAY,
                isnull([06],0) as JUN,
                isnull([07],0) as JUL,
                isnull([08],0) as AUG,
                isnull([09],0) as SEP,
                isnull([10],0) as OCT,
                isnull([11],0) as NOV,
                isnull([12],0) as DEC,
                
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
                isnull([12],0))
                 as TOTAL
                      FROM (
                           select pg.NamaUnit,
                           SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2) [Quarter],
                          count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                          from PerawatanSQL.dbo.Visit a
                          inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                          inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                          inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                          inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                          left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                          where YEAR(a.TglKunjungan)=:Periode
                          and a.Batal='0'   and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG')  
                          and pg.id not in  ('9','10','47','48','49','52','17','1','52','53')
                          group by pg.NamaUnit,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2)
                           
                      ) AS QuarterlyData
                      PIVOT( SUM([REGISTRASI Count])   
                              FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
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
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '2' && $JenisRekap == '4') {
                $query = "SELECT NamaUnit,
                isnull([01],0) as JAN,
                isnull([02],0) as FEB,
                isnull([03],0) as MAR,
                isnull([04],0) as APR,
                isnull([05],0) as MAY,
                isnull([06],0) as JUN,
                isnull([07],0) as JUL,
                isnull([08],0) as AUG,
                isnull([09],0) as SEP,
                isnull([10],0) as OCT,
                isnull([11],0) as NOV,
                isnull([12],0) as DEC,
                
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
                isnull([12],0))
                 as TOTAL
                      FROM (
                           select pg.NamaUnit,
                           SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2) [Quarter],
                          count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                          from PerawatanSQL.dbo.Visit a
                          inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                          inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                          inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                          inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                          left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                          where YEAR(a.TglKunjungan)=:Periode
                          and a.Batal='0'   
                          and pg.id in  ('1')
                          group by pg.NamaUnit,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2)
                           
                      ) AS QuarterlyData
                      PIVOT( SUM([REGISTRASI Count])   
                              FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
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
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '3' && $JenisRekap == '4') {
                $query = "SELECT NamaUnit,
                isnull([01],0) as JAN,
                isnull([02],0) as FEB,
                isnull([03],0) as MAR,
                isnull([04],0) as APR,
                isnull([05],0) as MAY,
                isnull([06],0) as JUN,
                isnull([07],0) as JUL,
                isnull([08],0) as AUG,
                isnull([09],0) as SEP,
                isnull([10],0) as OCT,
                isnull([11],0) as NOV,
                isnull([12],0) as DEC,
                
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
                isnull([12],0))
                 as TOTAL
                      FROM (
                           select pg.NamaUnit,
                           SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2) [Quarter],
                          count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                          from PerawatanSQL.dbo.Visit a
                          inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                          inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                          inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                          inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                          left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                          where YEAR(a.TglKunjungan)=:Periode
                          and a.Batal='0'    
                          and pg.id in  ('53')
                          group by pg.NamaUnit,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2)
                           
                      ) AS QuarterlyData
                      PIVOT( SUM([REGISTRASI Count])   
                              FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
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
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '6' && $JenisRekap == '4') {
                $query = "SELECT NamaUnit,
                isnull([01],0) as JAN,
                isnull([02],0) as FEB,
                isnull([03],0) as MAR,
                isnull([04],0) as APR,
                isnull([05],0) as MAY,
                isnull([06],0) as JUN,
                isnull([07],0) as JUL,
                isnull([08],0) as AUG,
                isnull([09],0) as SEP,
                isnull([10],0) as OCT,
                isnull([11],0) as NOV,
                isnull([12],0) as DEC,
                
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
                isnull([12],0))
                 as TOTAL
                      FROM (
                           select pg.NamaUnit,
                           SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2) [Quarter],
                          count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                          from PerawatanSQL.dbo.Visit a
                          inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                          inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                          inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                          inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                          left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                          where YEAR(a.TglKunjungan)=:Periode
                          and a.Batal='0'   
                          and pg.id in  ('47')
                          group by pg.NamaUnit,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2)
                           
                      ) AS QuarterlyData
                      PIVOT( SUM([REGISTRASI Count])   
                              FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
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
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '1' && $JenisRekap == '6') {
                $query = "SELECT NamaPerusahaan  ,
            isnull([01],0) as JAN,
            isnull([02],0) as FEB,
            isnull([03],0) as MAR,
            isnull([04],0) as APR,
            isnull([05],0) as MAY,
            isnull([06],0) as JUN,
            isnull([07],0) as JUL,
            isnull([08],0) as AUG,
            isnull([09],0) as SEP,
            isnull([10],0) as OCT,
            isnull([11],0) as NOV,
            isnull([12],0) as DEC,
            
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
            isnull([12],0))
             as TOTAL
                FROM (
                    select  oc.NamaPerusahaan,
                    SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2) [Quarter],
                    count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                    from PerawatanSQL.dbo.Visit a
                    inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                    inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                    inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                    inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                    left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                    inner join MasterdataSQL.dbo.MstrPerusahaanJPK OC ON OC.ID = A.Perusahaan
                    where YEAR(a.TglKunjungan)=:Periode
                and a.Batal='0'   and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG') 
                    AND PG.ID<>'53' 
                    and pg.id not in ('9','10','47','48','49','52','17','1','53')
                and a.PatientType<>'2'
                    group by oc.NamaPerusahaan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2)
                    
                ) AS QuarterlyData
                PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
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
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '1' && $JenisRekap == '7') {
                $query = "SELECT NamaPerusahaan  ,
            isnull([01],0) as JAN,
            isnull([02],0) as FEB,
            isnull([03],0) as MAR,
            isnull([04],0) as APR,
            isnull([05],0) as MAY,
            isnull([06],0) as JUN,
            isnull([07],0) as JUL,
            isnull([08],0) as AUG,
            isnull([09],0) as SEP,
            isnull([10],0) as OCT,
            isnull([11],0) as NOV,
            isnull([12],0) as DEC,
            
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
            isnull([12],0))
             as TOTAL
                FROM (
                    select  oc.NamaPerusahaan,
                    SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2) [Quarter],
                    count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                    from PerawatanSQL.dbo.Visit a
                    inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                    inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                    inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                    inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                    left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                    inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi OC ON OC.ID = A.asuransi
                    where YEAR(a.TglKunjungan)=:Periode
                and a.Batal='0'   and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG') 
                    AND PG.ID<>'53' 
                    and pg.id not in ('9','10','47','48','49','52','17','1','53')
                and a.PatientType='2'
                    group by oc.NamaPerusahaan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2)
                    
                ) AS QuarterlyData
                PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
            [grandtotal])) AS QPivot
			order by total desc";

                $this->db->query($query);
                $this->db->bind('Periode', $Periode);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    // $pasing['NamaRujukan']  = $row['NamaRujukan'];
                    $pasing['NamaUNIT']  = $row['NamaPerusahaan'];
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '2' && $JenisRekap == '6') {
                $query = "SELECT NamaPerusahaan  ,
            isnull([01],0) as JAN,
            isnull([02],0) as FEB,
            isnull([03],0) as MAR,
            isnull([04],0) as APR,
            isnull([05],0) as MAY,
            isnull([06],0) as JUN,
            isnull([07],0) as JUL,
            isnull([08],0) as AUG,
            isnull([09],0) as SEP,
            isnull([10],0) as OCT,
            isnull([11],0) as NOV,
            isnull([12],0) as DEC,
            
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
            isnull([12],0))
             as TOTAL
                FROM (
                    select  oc.NamaPerusahaan,
                    SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2) [Quarter],
                    count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                    from PerawatanSQL.dbo.Visit a
                    inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                    inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                    inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                    inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                    left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                    inner join MasterdataSQL.dbo.MstrPerusahaanJPK OC ON OC.ID = A.Perusahaan
                    where YEAR(a.TglKunjungan)=:Periode
                and a.Batal='0'   
                    and pg.id  in ('1')
                and a.PatientType<>'2'
                    group by oc.NamaPerusahaan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2)
                    
                ) AS QuarterlyData
                PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
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
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '2' && $JenisRekap == '7') {
                $query = "SELECT NamaPerusahaan  ,
            isnull([01],0) as JAN,
            isnull([02],0) as FEB,
            isnull([03],0) as MAR,
            isnull([04],0) as APR,
            isnull([05],0) as MAY,
            isnull([06],0) as JUN,
            isnull([07],0) as JUL,
            isnull([08],0) as AUG,
            isnull([09],0) as SEP,
            isnull([10],0) as OCT,
            isnull([11],0) as NOV,
            isnull([12],0) as DEC,
            
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
            isnull([12],0))
             as TOTAL
                FROM (
                    select  oc.NamaPerusahaan,
                    SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2) [Quarter],
                    count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                    from PerawatanSQL.dbo.Visit a
                    inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                    inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                    inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                    inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                    left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                     inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi OC ON OC.ID = A.asuransi
                    where YEAR(a.TglKunjungan)=:Periode
                and a.Batal='0'   
                    and pg.id  in ('1')
                and a.PatientType<>'2'
                    group by oc.NamaPerusahaan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2)
                    
                ) AS QuarterlyData
                PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
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
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '3' && $JenisRekap == '6') {
                $query = "SELECT NamaPerusahaan  ,
            isnull([01],0) as JAN,
            isnull([02],0) as FEB,
            isnull([03],0) as MAR,
            isnull([04],0) as APR,
            isnull([05],0) as MAY,
            isnull([06],0) as JUN,
            isnull([07],0) as JUL,
            isnull([08],0) as AUG,
            isnull([09],0) as SEP,
            isnull([10],0) as OCT,
            isnull([11],0) as NOV,
            isnull([12],0) as DEC,
            
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
            isnull([12],0))
             as TOTAL
                FROM (
                    select  oc.NamaPerusahaan,
                    SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2) [Quarter],
                    count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                    from PerawatanSQL.dbo.Visit a
                    inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                    inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                    inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                    inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                    left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                    inner join MasterdataSQL.dbo.MstrPerusahaanJPK OC ON OC.ID = A.Perusahaan
                    where YEAR(a.TglKunjungan)=:Periode
                and a.Batal='0'   
                    and pg.id  in ('53')
                and a.PatientType<>'2'
                    group by oc.NamaPerusahaan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2)
                    
                ) AS QuarterlyData
                PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
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
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '3' && $JenisRekap == '7') {
                $query = "SELECT NamaPerusahaan  ,
            isnull([01],0) as JAN,
            isnull([02],0) as FEB,
            isnull([03],0) as MAR,
            isnull([04],0) as APR,
            isnull([05],0) as MAY,
            isnull([06],0) as JUN,
            isnull([07],0) as JUL,
            isnull([08],0) as AUG,
            isnull([09],0) as SEP,
            isnull([10],0) as OCT,
            isnull([11],0) as NOV,
            isnull([12],0) as DEC,
            
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
            isnull([12],0))
             as TOTAL
                FROM (
                    select  oc.NamaPerusahaan,
                    SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2) [Quarter],
                    count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                    from PerawatanSQL.dbo.Visit a
                    inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                    inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                    inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                    inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                    left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                    inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi OC ON OC.ID = A.asuransi
                    where YEAR(a.TglKunjungan)=:Periode
                and a.Batal='0'   
                    and pg.id  in ('53')
                and a.PatientType<>'2'
                    group by oc.NamaPerusahaan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2)
                    
                ) AS QuarterlyData
                PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
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
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '4' && $JenisRekap == '6') {
                $query = "SELECT NamaPerusahaan,
               isnull([01],0) as JAN,
                isnull([02],0) as FEB,
                isnull([03],0) as MAR,
                isnull([04],0) as APR,
                isnull([05],0) as MAY,
                isnull([06],0) as JUN,
                isnull([07],0) as JUL,
                isnull([08],0) as AUG,
                isnull([09],0) as SEP,
                isnull([10],0) as OCT,
                isnull([11],0) as NOV,
                isnull([12],0) as DEC,
                
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
                isnull([12],0))
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
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '4' && $JenisRekap == '7') {
                $query = "SELECT NamaPerusahaan,
               isnull([01],0) as JAN,
                isnull([02],0) as FEB,
                isnull([03],0) as MAR,
                isnull([04],0) as APR,
                isnull([05],0) as MAY,
                isnull([06],0) as JUN,
                isnull([07],0) as JUL,
                isnull([08],0) as AUG,
                isnull([09],0) as SEP,
                isnull([10],0) as OCT,
                isnull([11],0) as NOV,
                isnull([12],0) as DEC,
                
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
                isnull([12],0))
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
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '6' && $JenisRekap == '6') {
                $query = "SELECT NamaPerusahaan  ,
            isnull([01],0) as JAN,
            isnull([02],0) as FEB,
            isnull([03],0) as MAR,
            isnull([04],0) as APR,
            isnull([05],0) as MAY,
            isnull([06],0) as JUN,
            isnull([07],0) as JUL,
            isnull([08],0) as AUG,
            isnull([09],0) as SEP,
            isnull([10],0) as OCT,
            isnull([11],0) as NOV,
            isnull([12],0) as DEC,
            
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
            isnull([12],0))
             as TOTAL
                FROM (
                    select  oc.NamaPerusahaan,
                    SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2) [Quarter],
                    count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                    from PerawatanSQL.dbo.Visit a
                    inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                    inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                    inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                    inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                    left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                    inner join MasterdataSQL.dbo.MstrPerusahaanJPK OC ON OC.ID = A.Perusahaan
                    where YEAR(a.TglKunjungan)=:Periode
                and a.Batal='0'   
                    and pg.id  in ('47')
                and a.PatientType<>'2'
                    group by oc.NamaPerusahaan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2)
                    
                ) AS QuarterlyData
                PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
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
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisPasien == '6' && $JenisRekap == '7') {
                $query = "SELECT NamaPerusahaan  ,
            isnull([01],0) as JAN,
            isnull([02],0) as FEB,
            isnull([03],0) as MAR,
            isnull([04],0) as APR,
            isnull([05],0) as MAY,
            isnull([06],0) as JUN,
            isnull([07],0) as JUL,
            isnull([08],0) as AUG,
            isnull([09],0) as SEP,
            isnull([10],0) as OCT,
            isnull([11],0) as NOV,
            isnull([12],0) as DEC,
            
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
            isnull([12],0))
             as TOTAL
                FROM (
                    select  oc.NamaPerusahaan,
                    SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2) [Quarter],
                    count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                    from PerawatanSQL.dbo.Visit a
                    inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                    inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                    inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                    inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                    left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                    inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi OC ON OC.ID = A.Asuransi
                    where YEAR(a.TglKunjungan)=:Periode
                and a.Batal='0'   
                    and pg.id  in ('47')
                and a.PatientType<>'2'
                    group by oc.NamaPerusahaan,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),6,2)
                    
                ) AS QuarterlyData
                PIVOT( SUM([REGISTRASI Count])   
            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],
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
                    $pasing['01']  = $row['JAN'];
                    $pasing['02']  = $row['FEB'];
                    $pasing['03']  = $row['MAR'];
                    $pasing['04']  = $row['APR'];
                    $pasing['05']  = $row['MAY'];
                    $pasing['06']  = $row['JUN'];
                    $pasing['07']  = $row['JUL'];
                    $pasing['08']  = $row['AUG'];
                    $pasing['09']  = $row['SEP'];
                    $pasing['10']  = $row['OCT'];
                    $pasing['11']  = $row['NOV'];
                    $pasing['12']  = $row['DEC'];
                    $pasing['total'] = $row['TOTAL'];

                    $rows[] = $pasing;
                }
            }

            return $rows;
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
