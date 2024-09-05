<?php
class  B_InformationBPJS_Model  
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
            $JenisRekap = $data['JenisRekap'];//yang banyak
            $JenisTipe = $data['JenisTipe'];//Detail atau Rekap
            $JenisInfo = $data['JenisInfo'];//Pasien apa
            $NamaDokter = $data['NamaDokter'];//ID DOkter
            $GrupPerawatan = $data['GrupPerawatan'];//ID unit

            if ($JenisTipe == '1'){
            //PASIEN RAWAT JALAN DAN IGD
            if ($JenisInfo == '1' && $JenisRekap == '1'){
                $query = "SELECT a.TglKunjungan,a.NoMR,a.NoRegistrasi,b.PatientName,
                b.Gander,a.Unit,pg.NamaUnit,a.[Status ID],
               c.First_Name,d.TypePatient,b.Address ,op.NamaPerusahaan   AS NamaPerusahaan  , hh.NamaCaraMasuk,hj.NamaCaraMasukRef,admx.Nama_Karcis as 'tarif',admx.Nilai_Karcis as 'TarifRS',
               replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglregis,
               replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-') as tglregis,
               case 
               when replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') > replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-')
               then 'Lama'  ELSE 'Baru'
               end as 'JenisPasien'
               ,co.[Status Name] as statusregis,(isnull(cg.[Total Radiologi],0)+isnull(cg.TotalBHP,0)+isnull(cg.TotalLab,0)+isnull(cg.TotalObat,0)+isnull(cg.TotalVisit,0)) as totalbill
               ,'' as A_Diagnosa,xm.Kecamatan,mx.Kelurahan,msx.kabupatenNama,ggg.ProvinsiNama
               from PerawatanSQL.dbo.Visit a
               inner join MasterdataSQL.dbo.Admision b
               on a.NoMR = b.NoMR
               inner join MasterdataSQL.dbo.Doctors c
               on c.ID = a.Doctor_1
               inner join MasterdataSQL.dbo.MstrTypePatient d
               on d.ID = a.PatientType 
               inner join MasterdataSQL.dbo.MstrPerusahaanJPK op on op.ID = a.Perusahaan
               inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
               left join MasterdataSQL.dbo.MstrCaraMasuk hh on hh.id = a.idCaraMasuk
               left join MasterdataSQL.dbo.MstrCaraMasuk_2 hj on hj.id = a.idCaraMasuk2
               left join PerawatanSQL.dbo.Tarif_RJ_UGD jk on jk.ID = a.idAdmin
               left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
               left join  PerawatanSQL.dbo.View_VisitExtnded cg on cg.NoRegistrasi = a.NoRegistrasi
               left join MasterdataSQL.dbo.mstrKecamatan xm on xm.kecamatanId = b.Kecamatan
               left join MasterdataSQL.dbo.mstrKelurahan mx on mx.desaId = b.Kelurahan
               left join MasterdataSQL.dbo.MstrKabupaten msx on msx.kabupatenId=b.City
               left join MasterdataSQL.dbo.MstrProvinsi ggg on ggg.PovinsiID = b.[State/Province]
			left join MasterdataSQL.dbo.MstrKarcisAdministrasi admx on a.idAdmin=admx.ID
               where replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') between :tglawal2 and :tglakhir2
               and a.Batal='0'   and d.TypePatient<>'ASURANSI'  and pg.grup_instalasi in ('RAWAT JALAN','IGD','PENUNJANG')
               and a.Doctor_1=:dokter2 
               --and   PG.ID<>'53'
                --and pg.id not in ('9','10','47','48','49','52','17')
                and a.PatientType='5' and a.Perusahaan='313'
               order by replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') asc,a.NoRegistrasi asc
               ";

            //$query_master = $query_master1;=
            $this->db->query($query); 
            $this->db->bind('tglawal2', $tglawal);
            $this->db->bind('tglakhir2', $tglakhir);
            $this->db->bind('dokter2', $NamaDokter);
            
            // PASIEN Pivot POLIKLINIK
            }elseif ($JenisInfo == '1' && $JenisRekap == '2'){
                $query = "SELECT a.TglKunjungan,a.NoMR,a.NoRegistrasi,b.PatientName,
                b.Gander,a.Unit,pg.NamaUnit,a.[Status ID],
               c.First_Name,d.TypePatient,b.Address ,op.NamaPerusahaan   AS NamaPerusahaan  , hh.NamaCaraMasuk,hj.NamaCaraMasukRef,admx.Nama_Karcis as 'tarif',admx.Nilai_Karcis as 'TarifRS',
               replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglregis,
               replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-') as tglregis,
               case 
               when replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') > replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-')
               then 'Lama'  ELSE 'Baru'
               end as 'JenisPasien'
               ,co.[Status Name] as statusregis,(isnull(cg.[Total Radiologi],0)+isnull(cg.TotalBHP,0)+isnull(cg.TotalLab,0)+isnull(cg.TotalObat,0)+isnull(cg.TotalVisit,0)) as totalbill
               ,replace(CONVERT(VARCHAR(max),kkl.A_Diagnosa),char(13)+char(10), '') as A_Diagnosa,xm.Kecamatan,mx.Kelurahan,msx.kabupatenNama,ggg.ProvinsiNama
               from PerawatanSQL.dbo.Visit a
               inner join MasterdataSQL.dbo.Admision b
               on a.NoMR = b.NoMR
               inner join MasterdataSQL.dbo.Doctors c
               on c.ID = a.Doctor_1
               inner join MasterdataSQL.dbo.MstrTypePatient d
               on d.ID = a.PatientType 
               inner join MasterdataSQL.dbo.MstrPerusahaanJPK op on op.ID = a.Perusahaan
               inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
               left join MasterdataSQL.dbo.MstrCaraMasuk hh on hh.id = a.idCaraMasuk
               left join MasterdataSQL.dbo.MstrCaraMasuk_2 hj on hj.id = a.idCaraMasuk2
               left join PerawatanSQL.dbo.Tarif_RJ_UGD jk on jk.ID = a.idAdmin
               left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
               left join  PerawatanSQL.dbo.View_VisitExtnded cg on cg.NoRegistrasi = a.NoRegistrasi
			   OUTER APPLY (
			   SELECT TOP 1 A_Diagnosa FROM MedicalRecord.dbo.EMR_RWJ kkl where NoRegistrasi collate Latin1_General_CS_AS = a.NoRegistrasi  collate  Latin1_General_CS_AS
			   and kkl.YgMelapor is null and kkl.YgMelapor is null
			   )kkl
               --left join MedicalRecord.dbo.EMR_RWJ kkl on kkl.NoRegistrasi  collate  Latin1_General_CS_AS = a.NoRegistrasi  collate  Latin1_General_CS_AS
               left join MasterdataSQL.dbo.mstrKecamatan xm on xm.kecamatanId = b.Kecamatan
               left join MasterdataSQL.dbo.mstrKelurahan mx on mx.desaId = b.Kelurahan
               left join MasterdataSQL.dbo.MstrKabupaten msx on msx.kabupatenId=b.City
               left join MasterdataSQL.dbo.MstrProvinsi ggg on ggg.PovinsiID = b.[State/Province]
			left join MasterdataSQL.dbo.MstrKarcisAdministrasi admx on a.idAdmin=admx.ID
               where replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') between '2022-01-01' and '2022-01-31'
               and a.Batal='0'   and d.TypePatient<>'ASURANSI' and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG','IGD') and a.PatientType='5' and a.Perusahaan='313'
               and a.Unit=:poli2 
			   --and pg.id not in ('9','10','47','48','49','52','17')
               ORDER BY a.TglKunjungan asc,NamaPerusahaan ASC";
               
               $this->db->query($query); 
               $this->db->bind('tglawal2', $tglawal);
               $this->db->bind('tglakhir2', $tglakhir);
               $this->db->bind('poli2', $GrupPerawatan);
            }elseif ($JenisInfo == '3' && $JenisRekap == '1'){
                $query = "SELECT a.StartDate as TglKunjungan,a.NoMR,a.NoRegRI NoRegistrasi,b.PatientName,
                b.Gander,'' as Unit,'Rawat Inap' as NamaUnit,a.[StatusID],
               c.First_Name,d.TypePatient,b.Address ,op.NamaPerusahaan   AS NamaPerusahaan  , hh.NamaCaraMasuk,hj.NamaCaraMasukRef,'' as 'tarif','' as 'TarifRS',
               replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as tglregis,
               replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-') as tglregis,
               case 
               when replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') > replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-')
               then 'Lama'  ELSE 'Baru'
               end as 'JenisPasien'
               ,'' as statusregis,'' as totalbill
               ,'' as A_Diagnosa,xm.Kecamatan,mx.Kelurahan,msx.kabupatenNama,ggg.ProvinsiNama
               from RawatInapSQL.dbo.Inpatient a
               inner join MasterdataSQL.dbo.Admision b
               on a.NoMR = b.NoMR
               inner join MasterdataSQL.dbo.Doctors c
               on c.ID = a.drPenerima
               inner join MasterdataSQL.dbo.MstrTypePatient d
               on d.ID = a.TypePatient 
               inner join MasterdataSQL.dbo.MstrPerusahaanJPK op on op.ID = a.IDJPK
               left join MasterdataSQL.dbo.MstrCaraMasuk hh on hh.id = a.idCaraMasuk
               left join MasterdataSQL.dbo.MstrCaraMasuk_2 hj on hj.id = a.idCaraMasuk2
               left join MasterdataSQL.dbo.mstrKecamatan xm on xm.kecamatanId = b.Kecamatan
               left join MasterdataSQL.dbo.mstrKelurahan mx on mx.desaId = b.Kelurahan
               left join MasterdataSQL.dbo.MstrKabupaten msx on msx.kabupatenId=b.City
               left join MasterdataSQL.dbo.MstrProvinsi ggg on ggg.PovinsiID = b.[State/Province]
               where replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') between :tglawal2 and :tglakhir2
                and d.TypePatient<>'ASURANSI' 
               and c.ID=:dokter2
                and d.ID='5' and a.IDJPK='313'
               order by replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') asc,a.NoRegRI asc
               ";

            //$query_master = $query_master1;=
            $this->db->query($query); 
            $this->db->bind('tglawal2', $tglawal);
            $this->db->bind('tglakhir2', $tglakhir);
            $this->db->bind('dokter2', $NamaDokter);
            
            // PASIEN RAWAT INAP
            }
            /*
            elseif ($JenisInfo == '7' && $JenisRekap == '2'){
                $query = "SELECT a.TglKunjungan,a.NoMR,a.NoRegistrasi,b.PatientName,
                b.Gander,a.Unit,pg.NamaUnit,a.[Status ID],
               c.First_Name,d.TypePatient,b.Address ,op.NamaPerusahaan   AS NamaPerusahaan , hh.NamaCaraMasuk,hj.NamaCaraMasukRef,admx.Nama_Karcis as 'tarif',admx.Nilai_Karcis as 'TarifRS',
               replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglregis,
               replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-') as tglregis,
               case 
               when replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') > replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-')
               then 'Lama'  ELSE 'Baru'
               end as 'JenisPasien' 
               ,co.[Status Name] as statusregis,'0' AS  totalbill
               ,replace(CONVERT(VARCHAR(max),kkl.DiagnosaPrimer),char(13)+char(10), '') as A_Diagnosa,xm.Kecamatan,mx.Kelurahan,msx.kabupatenNama,ggg.ProvinsiNama
               from PerawatanSQL.dbo.Visit a
               inner join MasterdataSQL.dbo.Admision b
               on a.NoMR = b.NoMR
               inner join MasterdataSQL.dbo.Doctors c
               on c.ID = a.Doctor_1
               inner join MasterdataSQL.dbo.MstrTypePatient d
               on d.ID = a.PatientType 
               inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi op on op.ID = a.Asuransi
               inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
               left join MasterdataSQL.dbo.MstrCaraMasuk hh on hh.id = a.idCaraMasuk
               left join MasterdataSQL.dbo.MstrCaraMasuk_2 hj on hj.id = a.idCaraMasuk2
               left join PerawatanSQL.dbo.Tarif_RJ_UGD jk on jk.ID = a.idAdmin
               left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
               left join MedicalRecord.dbo.EMR_UGD_MedicalAss kkl on kkl.NoRegistrasi  collate  Latin1_General_CS_AS = a.NoRegistrasi  collate  Latin1_General_CS_AS
               left join MasterdataSQL.dbo.mstrKecamatan xm on xm.kecamatanId = b.Kecamatan
               left join MasterdataSQL.dbo.mstrKelurahan mx on mx.desaId = b.Kelurahan
               left join MasterdataSQL.dbo.MstrKabupaten msx on msx.kabupatenId=b.City
               left join MasterdataSQL.dbo.MstrProvinsi ggg on ggg.PovinsiID = b.[State/Province]
			left join MasterdataSQL.dbo.MstrKarcisAdministrasi admx on a.idAdmin=admx.ID
               where replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') between :tglawal and :tglakhir
               and a.Batal='0'    and d.TypePatient<>'UMUM'  and d.TypePatient='ASURANSI' and pg.grup_instalasi='PENUNJANG'
              and a.Unit=:poli
               UNION ALL
                select a.TglKunjungan,a.NoMR,a.NoRegistrasi,b.PatientName,
                b.Gander,a.Unit,pg.NamaUnit,a.[Status ID],
               c.First_Name,d.TypePatient,b.Address ,op.NamaPerusahaan   AS NamaPerusahaan  , hh.NamaCaraMasuk,hj.NamaCaraMasukRef,admx.Nama_Karcis as 'tarif',admx.Nilai_Karcis as 'TarifRS',
               replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglregis,
               replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-') as tglregis,
               case 
               when replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') > replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-')
               then 'Lama'  ELSE 'Baru'
               end as 'JenisPasien' 
               ,co.[Status Name] as statusregis,'0' AS  totalbill
               ,replace(CONVERT(VARCHAR(max),kkl.DiagnosaPrimer),char(13)+char(10), '') as A_Diagnosa,xm.Kecamatan,mx.Kelurahan,msx.kabupatenNama,ggg.ProvinsiNama
               from PerawatanSQL.dbo.Visit a
               inner join MasterdataSQL.dbo.Admision b
               on a.NoMR = b.NoMR
               inner join MasterdataSQL.dbo.Doctors c
               on c.ID = a.Doctor_1
               inner join MasterdataSQL.dbo.MstrTypePatient d
               on d.ID = a.PatientType 
               inner join MasterdataSQL.dbo.MstrPerusahaanJPK op on op.ID = a.Perusahaan
               inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
               left join MasterdataSQL.dbo.MstrCaraMasuk hh on hh.id = a.idCaraMasuk
               left join MasterdataSQL.dbo.MstrCaraMasuk_2 hj on hj.id = a.idCaraMasuk2
               left join PerawatanSQL.dbo.Tarif_RJ_UGD jk on jk.ID = a.idAdmin
               left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
               left join MedicalRecord.dbo.EMR_UGD_MedicalAss kkl on kkl.NoRegistrasi  collate  Latin1_General_CS_AS = a.NoRegistrasi  collate  Latin1_General_CS_AS
               left join MasterdataSQL.dbo.mstrKecamatan xm on xm.kecamatanId = b.Kecamatan
               left join MasterdataSQL.dbo.mstrKelurahan mx on mx.desaId = b.Kelurahan
               left join MasterdataSQL.dbo.MstrKabupaten msx on msx.kabupatenId=b.City
               left join MasterdataSQL.dbo.MstrProvinsi ggg on ggg.PovinsiID = b.[State/Province]
			left join MasterdataSQL.dbo.MstrKarcisAdministrasi admx on a.idAdmin=admx.ID
               where replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') between  :tglawal2 and :tglakhir2
               and a.Batal='0'   and d.TypePatient<>'ASURANSI'  and pg.grup_instalasi='PENUNJANG'
               and a.Unit=:poli2
               ORDER BY a.TglKunjungan asc,NamaPerusahaan ASC";
               
               $this->db->query($query); 
               $this->db->bind('tglawal', $tglawal);
               $this->db->bind('tglakhir', $tglakhir);
               $this->db->bind('tglawal2', $tglawal);
               $this->db->bind('tglakhir2', $tglakhir);
               $this->db->bind('poli', $GrupPerawatan);
               $this->db->bind('poli2', $GrupPerawatan);
            }
            */
             
                            $data =  $this->db->resultSet();
                            $rows = array();
                            $no = 1;
                            foreach ($data as $row) {
                                $pasing['no'] = $no++;
                                //$pasing['TglKunjungan'] = date('d-m-Y', strtotime($row['tglregisx']));
                                $pasing['TglKunjungan'] = date('d-m-Y', strtotime($row['TglKunjungan']));
                                $pasing['NoMR'] = $row['NoMR'];
                                $pasing['JenisPasien'] = $row['JenisPasien'];
                                $pasing['statusregis'] = $row['statusregis'];
                                $pasing['NoRegistrasi'] = $row['NoRegistrasi'];
                                $pasing['PatientName'] = $row['PatientName'];
                                $pasing['Gander'] = $row['Gander'];
                                $pasing['NamaUnit'] = $row['NamaUnit'];
                                $pasing['A_Diagnosa'] = $row['A_Diagnosa'];
                                $pasing['First_Name'] = $row['First_Name'];
                                $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                                $pasing['Address'] = $row['Address'].
                                $pasing['Kelurahan'] = $row['Kelurahan'];
                                $pasing['Kecamatan'] = $row['Kecamatan'];
                                $pasing['kabupatenNama'] = $row['kabupatenNama'];
                                $pasing['ProvinsiNama'] = $row['ProvinsiNama'];
                                $pasing['NamaCaraMasuk'] = $row['NamaCaraMasuk'];
                                $pasing['NamaCaraMasukRef'] = $row['NamaCaraMasukRef'];
                                $pasing['tarif'] = $row['tarif'];
                                $pasing['TarifRS'] = $row['TarifRS'];
                                $pasing['totalbill'] = $row['totalbill'];

                                $rows[] = $pasing;
                            }
                            //return $rows;
            }elseif ($JenisTipe == '2') {

                if($JenisInfo == '1' && $JenisRekap == '1'){
                    $query = "SELECT *
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
                        where replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') between :tglawal and :tglakhir and a.PatientType='5' and a.Perusahaan='313'
                        and a.Batal='0'   and pg.grup_instalasi in ('RAWAT JALAN','IGD','PENUNJANG') 
                        --AND PG.ID<>'53' 
                        --and pg.id not in ('9','10','47','48','49','52','17')
                        group by pg.NamaUnit,c.First_Name,SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2)
                         
                    ) AS QuarterlyData
                    PIVOT( SUM([REGISTRASI Count])   
                            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],[13],[14],[15],
                            [16],[17],[18],[19],[20],[21],[22],[23],[24],[25],[26],[27],[28],[29],[30],[31],
                            [grandtotal])) AS QPivot
                            order by NamaUnit asc";
                }elseif ($JenisInfo == '1' && $JenisRekap == '2'){//RAJAL, REKAP
                    $query = "SELECT *,'' as First_Name
                    FROM (
                         select pg.NamaUnit, 
                         SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2) [Quarter],
                        count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                        from PerawatanSQL.dbo.Visit a
                        inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                        inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                        inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                        inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                        left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                        where replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') between :tglawal and :tglakhir and a.PatientType='5' and a.Perusahaan='313'
                        and a.Batal='0'   and pg.grup_instalasi in ('RAWAT JALAN','IGD','PENUNJANG')
                         --AND PG.ID<>'53' 
                        --and pg.id not in ('9','10','47','48','49')
                        group by pg.NamaUnit, SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2)
                         
                    ) AS QuarterlyData
                    PIVOT( SUM([REGISTRASI Count])   
                            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],[13],[14],[15],
                            [16],[17],[18],[19],[20],[21],[22],[23],[24],[25],[26],[27],[28],[29],[30],[31],
                            [grandtotal])) AS QPivot
                            order by NamaUnit asc";
                }elseif($JenisInfo == '3' && $JenisRekap == '1'){
                    $query = "SELECT *
                    FROM (
                         select 'Rawat Inap' as NamaUnit, c.First_Name,
                         SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),9,2) [Quarter],
                        count(isnull(a.drPenerima,0)) as  [REGISTRASI Count]
                        from RawatInapSQL.dbo.Inpatient a
                        inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                        inner join MasterdataSQL.dbo.Doctors c on c.ID = a.drPenerima
                        inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.TypePatient 
                        where replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') between :tglawal and :tglakhir and a.TypePatient='5' and a.IDJPK='313'
                        group by c.First_Name,SUBSTRING(replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-'),9,2)
                         
                    ) AS QuarterlyData
                    PIVOT( SUM([REGISTRASI Count])   
                            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],[13],[14],[15],
                            [16],[17],[18],[19],[20],[21],[22],[23],[24],[25],[26],[27],[28],[29],[30],[31],
                            [grandtotal])) AS QPivot
                            order by NamaUnit asc";
                }
                /*
                elseif ($JenisInfo == '7' && $JenisRekap == '2'){//PENUNJANG, REKAP
                    $query = "SELECT *,'' as First_Name
                    FROM (
                         select pg.NamaUnit, 
                         SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2) [Quarter],
                        count(isnull(a.Doctor_1,0)) as  [REGISTRASI Count]
                        from PerawatanSQL.dbo.Visit a
                        inner join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                        inner join MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
                        inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.PatientType 
                        inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                        left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                        where replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') between :tglawal and :tglakhir
                        and a.Batal='0'   and pg.grup_instalasi in ('PENUNJANG')
                         AND PG.ID<>'53' 
                        group by pg.NamaUnit, SUBSTRING(replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-'),9,2)
                         
                    ) AS QuarterlyData
                    PIVOT( SUM([REGISTRASI Count])   
                            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],[13],[14],[15],
                            [16],[17],[18],[19],[20],[21],[22],[23],[24],[25],[26],[27],[28],[29],[30],[31],
                            [grandtotal])) AS QPivot
                            order by NamaUnit asc";
                }
                */

                $this->db->query($query); 
                $this->db->bind('tglawal', $tglawal);
                $this->db->bind('tglakhir', $tglakhir);

                if($JenisInfo == '4' && $JenisRekap == '7'){
                    $this->db->bind('tglawal3', $tglawal);
                    $this->db->bind('tglakhir3', $tglakhir);
                    $this->db->bind('tglawal4', $tglawal);
                    $this->db->bind('tglakhir4', $tglakhir);
                    $this->db->bind('tglawal5', $tglawal);
                    $this->db->bind('tglakhir5', $tglakhir);
                    $this->db->bind('tglawal6', $tglawal);
                    $this->db->bind('tglakhir6', $tglakhir);
                    $this->db->bind('tglawal7', $tglawal);
                    $this->db->bind('tglakhir7', $tglakhir);
                    $this->db->bind('tglawal8', $tglawal);
                    $this->db->bind('tglakhir8', $tglakhir);
                    $this->db->bind('tglawal9', $tglawal);
                    $this->db->bind('tglakhir9', $tglakhir);
                }

                    $data =  $this->db->resultSet();
                            $rows = array();
                            $no = 1;
                            foreach ($data as $row) {
                                $pasing['no'] = $no++;
                                
                                $total=$row['01']+$row['02']+$row['03']+$row['04']+$row['05']
                                +$row['06']+$row['07']+$row['08']+$row['09']+$row['10']
                                +$row['11']+$row['12']+$row['13']+$row['14']+$row['15']
                                +$row['16']+$row['17']+$row['18']+$row['19']+$row['20']
                                +$row['21']+$row['22']+$row['23']+$row['24']+$row['25']
                                +$row['26']+$row['27']+$row['28']+$row['29']+$row['30']
                                +$row['31'];
                                
                                $pasing['NamaUnit']  = $row['NamaUnit'];
                                $pasing['First_Name']  = $row['First_Name'];
                                $pasing['01']  = $row['01'];
                                $pasing['02']  = $row['02'];
                                $pasing['03']  = $row['03'];
                                $pasing['04']  = $row['04'];
                                $pasing['05']  = $row['05'];
                                $pasing['06']  = $row['06'];
                                $pasing['07']  = $row['07'];
                                $pasing['08']  = $row['08'];
                                $pasing['09']  = $row['09'];
                                $pasing['10']  = $row['10'];
                                $pasing['11']  = $row['11'];
                                $pasing['12']  = $row['12'];
                                $pasing['13']  = $row['13'];
                                $pasing['14']  = $row['14'];
                                $pasing['15']  = $row['15'];
                                $pasing['16']  = $row['16'];
                                $pasing['17']  = $row['17'];
                                $pasing['18']  = $row['18'];
                                $pasing['19']  = $row['19'];
                                $pasing['20']  = $row['20'];
                                $pasing['21']  = $row['21'];
                                $pasing['22']  = $row['22'];
                                $pasing['23']  = $row['23'];
                                $pasing['24']  = $row['24'];
                                $pasing['25']  = $row['25'];
                                $pasing['26']  = $row['26'];
                                $pasing['27']  = $row['27'];
                                $pasing['28']  = $row['28'];
                                $pasing['29']  = $row['29'];
                                $pasing['30']  = $row['30'];
                                $pasing['31']  = $row['31'];
                                $pasing['total'] = $total;

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

    public function getDataMonitoringBPJS($data)
    {
        try {
            $tglawal = $data['TglAwal'];
            $tglakhir = $data['TglAkhir'];
            $this->db->query("SELECT NO_SEP,NO_REGISTRASI, NAMA_PESERTA,NAMA_POLI,NAMA_DOKTER,TGL_SEP,
            CASE WHEN [1] = '1' THEN '' ELSE 'X' END AS [1]
            ,Task1,
            CASE WHEN [2] = '1' THEN '' ELSE 'X' END AS [2]
            ,TASK2,
            CASE WHEN [3] = '1' THEN '' ELSE 'X' END AS [3]
            ,Task3,
            CASE WHEN [4] = '1' THEN '' ELSE 'X' END AS [4]
            ,Task4,
            CASE WHEN [5] = '1' THEN '' ELSE 'X' END AS [5]
            ,task5,
            CASE WHEN [6] = '1' THEN '' ELSE 'X' END AS [6]
            ,Task6,
            CASE WHEN [7] = '1' THEN '' ELSE 'X' END AS [7],
            Task7
            FROM PerawatanSQL.DBO.BPJS_T_SEP a
            INNER JOIN (
                SELECT  KODE_TRANSAKSI,[1],[2],[3],[4],[5],[6],[7]
                    FROM 
                    (
                        SELECT KODE_TRANSAKSI ,TASK_ID  AS [Quarter] ,DATE_CREATE [REGISTRASI Count]
                        FROM PerawatanSQL.dbo.BPJS_TASKID_LOG
                        where 
                        replace(CONVERT(VARCHAR(11), DATE_CREATE, 111), '/','-') between :TglAwal1 and :TglAkhir1
                    )AS QuarterlyData
                    PIVOT( COUNT([REGISTRASI Count])   
                    FOR Quarter IN ([1],[2],[3],[4],[5],[6],[7])) AS QPivot
            )XX ON XX.KODE_TRANSAKSI = A.NO_REGISTRASI
            WHERE replace(CONVERT(VARCHAR(11), A.TGL_SEP, 111), '/','-') between :TglAwal2 and :TglAkhir2
             "); 
             $this->db->bind('TglAwal1', $tglawal);
             $this->db->bind('TglAkhir1', $tglakhir);
             $this->db->bind('TglAwal2', $tglawal); 
             $this->db->bind('TglAkhir2', $tglakhir); 
                            $data =  $this->db->resultSet();
                            $rows = array();
                            foreach ($data as $key) {
                                $pasing['NO_SEP'] = $key['NO_SEP'];
                                $pasing['NO_REGISTRASI'] = $key['NO_REGISTRASI'];
                                $pasing['NAMA_PESERTA'] = $key['NAMA_PESERTA'];
                                $pasing['NAMA_POLI'] = $key['NAMA_POLI'];
                                $pasing['NAMA_DOKTER'] = $key['NAMA_DOKTER'];
                                $pasing['TGL_SEP'] = $key['TGL_SEP'];
                                $pasing['Task1'] = $key['Task1']; 
                                $pasing['Task2'] = $key['TASK2']; 
                                $pasing['Task3'] = $key['Task3']; 
                                $pasing['Task4'] = $key['Task4']; 
                                $pasing['Task5'] = $key['task5']; 
                                $pasing['Task6'] = $key['Task6']; 
                                $pasing['Task7'] = $key['Task7']; 
                                //$pasing['VisitDate'] = date('d/m/Y', strtotime($key['VisitDate']));
                                $rows[] = $pasing;
                            }
                            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

}
