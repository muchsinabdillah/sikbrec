<?php
class  B_InformationRekamMedik_Model
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
            $JenisRekap = $data['JenisRekap']; //yang banyak
            $JenisTipe = $data['JenisTipe']; //Detail atau Rekap
            $JenisInfo = $data['JenisInfo']; //Pasien apa
            $NamaDokter = $data['NamaDokter']; //ID DOkter
            $GrupPerawatan = $data['GrupPerawatan']; //ID unit

            // if ($JenisInfo == '1' || $JenisInfo == '2' || $JenisInfo == '5' || $JenisInfo == '7' || $JenisInfo == '8'){
            //     if ($JenisInfo == '1'){
            //         $where_v  = "AND IdUnit not in ('9','10','47','48','49','52','17','53')";
            //     }elseif ($JenisInfo == '2'){
            //         $where_v  = "AND IdUnit ='1'";
            //     }elseif ($JenisInfo == '5'){
            //         $where_v  = "AND IdUnit in ('9','10')";
            //     }elseif ($JenisInfo == '5'){
            //         $where_v  = "AND IdUnit ='47'";
            //     }
            // }

            if ($JenisTipe == '1') {
                //PASIEN RAWAT JALAN DAN IGD
                if ($JenisInfo == '1' && $JenisRekap == '1') {
                    //     $query = "SELECT a.TglKunjungan,a.NoMR,a.NoRegistrasi,b.PatientName,
                    //     b.Gander,a.Unit,pg.NamaUnit,a.[Status ID],
                    //    c.First_Name,d.TypePatient,b.Address ,op.NamaPerusahaan   AS NamaPerusahaan , hh.NamaCaraMasuk,hj.NamaCaraMasukRef,admx.Nama_Karcis as 'tarif',admx.Nilai_Karcis as 'TarifRS',
                    //    replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglregis,
                    //    replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-') as tglregis,
                    //    case 
                    //    when replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') > replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-')
                    //    then 'Lama'  ELSE 'Baru'
                    //    end as 'JenisPasien' 
                    //    ,co.[Status Name] as statusregis,(isnull(cg.[Total Radiologi],0)+isnull(cg.TotalBHP,0)+isnull(cg.TotalLab,0)+isnull(cg.TotalObat,0)+isnull(cg.TotalVisit,0)) as totalbill
                    //    ,replace(CONVERT(VARCHAR(max),kkl.A_Diagnosa),char(13)+char(10), '') as A_Diagnosa,xm.Kecamatan,mx.Kelurahan,msx.kabupatenNama,ggg.ProvinsiNama
                    //    from PerawatanSQL.dbo.Visit a
                    //    inner join MasterdataSQL.dbo.Admision b
                    //    on a.NoMR = b.NoMR
                    //    inner join MasterdataSQL.dbo.Doctors c
                    //    on c.ID = a.Doctor_1
                    //    inner join MasterdataSQL.dbo.MstrTypePatient d
                    //    on d.ID = a.PatientType 
                    //    inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi op on op.ID = a.Asuransi
                    //    inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                    //    left join MasterdataSQL.dbo.MstrCaraMasuk hh on hh.id = a.idCaraMasuk
                    //    left join MasterdataSQL.dbo.MstrCaraMasuk_2 hj on hj.id = a.idCaraMasuk2
                    //    left join PerawatanSQL.dbo.Tarif_RJ_UGD jk on jk.ID = a.idAdmin
                    //    left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                    //    left join  PerawatanSQL.dbo.View_VisitExtnded cg on cg.NoRegistrasi = a.NoRegistrasi
                    //    left join MedicalRecord.dbo.EMR_RWJ kkl on kkl.NoRegistrasi  collate  Latin1_General_CS_AS = a.NoRegistrasi  collate  Latin1_General_CS_AS
                    //    left join MasterdataSQL.dbo.mstrKecamatan xm on xm.kecamatanId = b.Kecamatan
                    //    left join MasterdataSQL.dbo.mstrKelurahan mx on mx.desaId = b.Kelurahan
                    //    left join MasterdataSQL.dbo.MstrKabupaten msx on msx.kabupatenId=b.City
                    //    left join MasterdataSQL.dbo.MstrProvinsi ggg on ggg.PovinsiID = b.[State/Province]
                    // left join MasterdataSQL.dbo.MstrKarcisAdministrasi admx on a.idAdmin=admx.ID
                    //    where kkl.YgMelapor is null and kkl.YgMelapor is null
                    //    and replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') between :tglawal and :tglakhir
                    //    and a.Batal='0'    and d.TypePatient<>'UMUM'  and d.TypePatient='ASURANSI' and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG')
                    //    and a.Doctor_1=:dokter and   PG.ID<>'53'
                    //    and pg.id not in ('9','10','47','48','49','52','17')
                    //    UNION ALL
                    //     select a.TglKunjungan,a.NoMR,a.NoRegistrasi,b.PatientName,
                    //     b.Gander,a.Unit,pg.NamaUnit,a.[Status ID],
                    //    c.First_Name,d.TypePatient,b.Address ,op.NamaPerusahaan   AS NamaPerusahaan  , hh.NamaCaraMasuk,hj.NamaCaraMasukRef,admx.Nama_Karcis as 'tarif',admx.Nilai_Karcis as 'TarifRS',
                    //    replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglregis,
                    //    replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-') as tglregis,
                    //    case 
                    //    when replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') > replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-')
                    //    then 'Lama'  ELSE 'Baru'
                    //    end as 'JenisPasien'
                    //    ,co.[Status Name] as statusregis,(isnull(cg.[Total Radiologi],0)+isnull(cg.TotalBHP,0)+isnull(cg.TotalLab,0)+isnull(cg.TotalObat,0)+isnull(cg.TotalVisit,0)) as totalbill
                    //    ,replace(CONVERT(VARCHAR(max),kkl.A_Diagnosa),char(13)+char(10), '') as A_Diagnosa,xm.Kecamatan,mx.Kelurahan,msx.kabupatenNama,ggg.ProvinsiNama
                    //    from PerawatanSQL.dbo.Visit a
                    //    inner join MasterdataSQL.dbo.Admision b
                    //    on a.NoMR = b.NoMR
                    //    inner join MasterdataSQL.dbo.Doctors c
                    //    on c.ID = a.Doctor_1
                    //    inner join MasterdataSQL.dbo.MstrTypePatient d
                    //    on d.ID = a.PatientType 
                    //    inner join MasterdataSQL.dbo.MstrPerusahaanJPK op on op.ID = a.Perusahaan
                    //    inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                    //    left join MasterdataSQL.dbo.MstrCaraMasuk hh on hh.id = a.idCaraMasuk
                    //    left join MasterdataSQL.dbo.MstrCaraMasuk_2 hj on hj.id = a.idCaraMasuk2
                    //    left join PerawatanSQL.dbo.Tarif_RJ_UGD jk on jk.ID = a.idAdmin
                    //    left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                    //    left join  PerawatanSQL.dbo.View_VisitExtnded cg on cg.NoRegistrasi = a.NoRegistrasi
                    //    left join MedicalRecord.dbo.EMR_RWJ kkl on kkl.NoRegistrasi  collate  Latin1_General_CS_AS = a.NoRegistrasi  collate  Latin1_General_CS_AS
                    //    left join MasterdataSQL.dbo.mstrKecamatan xm on xm.kecamatanId = b.Kecamatan
                    //    left join MasterdataSQL.dbo.mstrKelurahan mx on mx.desaId = b.Kelurahan
                    //    left join MasterdataSQL.dbo.MstrKabupaten msx on msx.kabupatenId=b.City
                    //    left join MasterdataSQL.dbo.MstrProvinsi ggg on ggg.PovinsiID = b.[State/Province]
                    // left join MasterdataSQL.dbo.MstrKarcisAdministrasi admx on a.idAdmin=admx.ID
                    //    where kkl.YgMelapor is null and kkl.YgMelapor is null
                    //    and replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') between :tglawal2 and :tglakhir2
                    //    and a.Batal='0'   and d.TypePatient<>'ASURANSI'  and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG')
                    //    and a.Doctor_1=:dokter2 and   PG.ID<>'53'
                    //     and pg.id not in ('9','10','47','48','49','52','17')

                    //    order by replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') asc,a.NoRegistrasi asc
                    //    ";

                    $query = "SELECT *, replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') TglKunjungan,BL as JenisPasien,  Case When StatusID = '0' Then 'New'
            WHEN StatusID = '1' Then 'Invoiced'
            WHEN StatusID = '2' Then 'Payment'
            WHEN StatusID = '3' Then 'Lunas'
            WHEN StatusID = '4' Then 'Close'
            End As 'statusregis',Diagnosa_Awal as A_Diagnosa,Sex as Gander,a.NamaDokter as First_Name,NamaKarcis as tarif, NilaiKarcis as TarifRS,(isnull(cg.[Total Radiologi],0)+isnull(cg.TotalBHP,0)+isnull(cg.TotalLab,0)+isnull(cg.TotalObat,0)+isnull(cg.TotalVisit,0)) as totalbill,NamaJaminan as NamaPerusahaan FROM DashboardData.dbo.dataRWJ a
             inner join  PerawatanSQL.dbo.View_VisitExtnded cg on cg.NoRegistrasi = a.NoRegistrasi
            WHERE
            replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir
           and Batal='0'  -- and a.TipePasien<>'2'  --and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG')
           and IdDokter=:dokter AND IdUnit not in ('9','10','47','48','49','52','17','53')
            order by replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') asc,a.NoRegistrasi asc
            ";
                    //$query_master = $query_master1;=
                    $this->db->query($query);
                    $this->db->bind('tglawal', $tglawal);
                    $this->db->bind('tglakhir', $tglakhir);
                    // $this->db->bind('tglawal2', $tglawal);
                    // $this->db->bind('tglakhir2', $tglakhir);
                    $this->db->bind('dokter', $NamaDokter);
                    //$this->db->bind('dokter2', $NamaDokter);

                    // PASIEN RAWAT INAP
                } elseif ($JenisInfo == '5' && $JenisRekap == '1') {
                    //     $query = "SELECT a.TglKunjungan,a.NoMR,a.NoRegistrasi,b.PatientName,
                    //     b.Gander,a.Unit,pg.NamaUnit,a.[Status ID],
                    //    c.First_Name,d.TypePatient,b.Address ,op.NamaPerusahaan   AS NamaPerusahaan , hh.NamaCaraMasuk,hj.NamaCaraMasukRef,admx.Nama_Karcis as 'tarif',admx.Nilai_Karcis as 'TarifRS',
                    //    replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglregis,
                    //    replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-') as tglregis,
                    //    case 
                    //    when replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') > replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-')
                    //    then 'Lama'  ELSE 'Baru'
                    //    end as 'JenisPasien' 
                    //    ,co.[Status Name] as statusregis,(isnull(cg.[Total Radiologi],0)+isnull(cg.TotalBHP,0)+isnull(cg.TotalLab,0)+isnull(cg.TotalObat,0)+isnull(cg.TotalVisit,0)) as totalbill
                    //    ,replace(CONVERT(VARCHAR(max),kkl.A_Diagnosa),char(13)+char(10), '') as A_Diagnosa,xm.Kecamatan,mx.Kelurahan,msx.kabupatenNama,ggg.ProvinsiNama
                    //    from PerawatanSQL.dbo.Visit a
                    //    inner join MasterdataSQL.dbo.Admision b
                    //    on a.NoMR = b.NoMR
                    //    inner join MasterdataSQL.dbo.Doctors c
                    //    on c.ID = a.Doctor_1
                    //    inner join MasterdataSQL.dbo.MstrTypePatient d
                    //    on d.ID = a.PatientType 
                    //    inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi op on op.ID = a.Asuransi
                    //    inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                    //    left join MasterdataSQL.dbo.MstrCaraMasuk hh on hh.id = a.idCaraMasuk
                    //    left join MasterdataSQL.dbo.MstrCaraMasuk_2 hj on hj.id = a.idCaraMasuk2
                    //    left join PerawatanSQL.dbo.Tarif_RJ_UGD jk on jk.ID = a.idAdmin
                    //    left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                    //    left join  PerawatanSQL.dbo.View_VisitExtnded cg on cg.NoRegistrasi = a.NoRegistrasi
                    //    left join MedicalRecord.dbo.EMR_RWJ kkl on kkl.NoRegistrasi  collate  Latin1_General_CS_AS = a.NoRegistrasi  collate  Latin1_General_CS_AS
                    //    left join MasterdataSQL.dbo.mstrKecamatan xm on xm.kecamatanId = b.Kecamatan
                    //    left join MasterdataSQL.dbo.mstrKelurahan mx on mx.desaId = b.Kelurahan
                    //    left join MasterdataSQL.dbo.MstrKabupaten msx on msx.kabupatenId=b.City
                    //    left join MasterdataSQL.dbo.MstrProvinsi ggg on ggg.PovinsiID = b.[State/Province]
                    // left join MasterdataSQL.dbo.MstrKarcisAdministrasi admx on a.idAdmin=admx.ID
                    //    where kkl.YgMelapor is null and kkl.YgMelapor is null
                    //    and replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') between :tglawal and :tglakhir
                    //    and a.Batal='0'    and d.TypePatient<>'UMUM'  and d.TypePatient='ASURANSI' and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG')
                    //    and a.Doctor_1=:dokter and   PG.ID='53'
                    //    UNION ALL
                    //     select a.TglKunjungan,a.NoMR,a.NoRegistrasi,b.PatientName,
                    //     b.Gander,a.Unit,pg.NamaUnit,a.[Status ID],
                    //    c.First_Name,d.TypePatient,b.Address ,op.NamaPerusahaan   AS NamaPerusahaan  , hh.NamaCaraMasuk,hj.NamaCaraMasukRef,admx.Nama_Karcis as 'tarif',admx.Nilai_Karcis as 'TarifRS',
                    //    replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglregis,
                    //    replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-') as tglregis,
                    //    case 
                    //    when replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') > replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-')
                    //    then 'Lama'  ELSE 'Baru'
                    //    end as 'JenisPasien'
                    //    ,co.[Status Name] as statusregis,(isnull(cg.[Total Radiologi],0)+isnull(cg.TotalBHP,0)+isnull(cg.TotalLab,0)+isnull(cg.TotalObat,0)+isnull(cg.TotalVisit,0)) as totalbill
                    //    ,replace(CONVERT(VARCHAR(max),kkl.A_Diagnosa),char(13)+char(10), '') as A_Diagnosa,xm.Kecamatan,mx.Kelurahan,msx.kabupatenNama,ggg.ProvinsiNama
                    //    from PerawatanSQL.dbo.Visit a
                    //    inner join MasterdataSQL.dbo.Admision b
                    //    on a.NoMR = b.NoMR
                    //    inner join MasterdataSQL.dbo.Doctors c
                    //    on c.ID = a.Doctor_1
                    //    inner join MasterdataSQL.dbo.MstrTypePatient d
                    //    on d.ID = a.PatientType 
                    //    inner join MasterdataSQL.dbo.MstrPerusahaanJPK op on op.ID = a.Perusahaan
                    //    inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                    //    left join MasterdataSQL.dbo.MstrCaraMasuk hh on hh.id = a.idCaraMasuk
                    //    left join MasterdataSQL.dbo.MstrCaraMasuk_2 hj on hj.id = a.idCaraMasuk2
                    //    left join PerawatanSQL.dbo.Tarif_RJ_UGD jk on jk.ID = a.idAdmin
                    //    left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                    //    left join  PerawatanSQL.dbo.View_VisitExtnded cg on cg.NoRegistrasi = a.NoRegistrasi
                    //    left join MedicalRecord.dbo.EMR_RWJ kkl on kkl.NoRegistrasi  collate  Latin1_General_CS_AS = a.NoRegistrasi  collate  Latin1_General_CS_AS
                    //    left join MasterdataSQL.dbo.mstrKecamatan xm on xm.kecamatanId = b.Kecamatan
                    //    left join MasterdataSQL.dbo.mstrKelurahan mx on mx.desaId = b.Kelurahan
                    //    left join MasterdataSQL.dbo.MstrKabupaten msx on msx.kabupatenId=b.City
                    //    left join MasterdataSQL.dbo.MstrProvinsi ggg on ggg.PovinsiID = b.[State/Province]
                    // left join MasterdataSQL.dbo.MstrKarcisAdministrasi admx on a.idAdmin=admx.ID
                    //    where kkl.YgMelapor is null and kkl.YgMelapor is null
                    //    and replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') between :tglawal2 and :tglakhir2
                    //    and a.Batal='0'   and d.TypePatient<>'ASURANSI' and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG')
                    //    and a.Doctor_1=:dokter2 and   PG.ID='53'
                    //    order by replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') asc,a.NoRegistrasi asc
                    //    ";
                    //     $this->db->query($query); 
                    //     $this->db->bind('tglawal', $tglawal);
                    //     $this->db->bind('tglakhir', $tglakhir);
                    //     $this->db->bind('tglawal2', $tglawal);
                    //     $this->db->bind('tglakhir2', $tglakhir);
                    //     $this->db->bind('dokter', $NamaDokter);
                    //     $this->db->bind('dokter2', $NamaDokter);

                    $query = "SELECT *, replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') TglKunjungan,BL as JenisPasien,  Case When StatusID = '0' Then 'New'
            WHEN StatusID = '1' Then 'Invoiced'
            WHEN StatusID = '2' Then 'Payment'
            WHEN StatusID = '3' Then 'Lunas'
            WHEN StatusID = '4' Then 'Close'
            End As 'statusregis',Diagnosa_Awal as A_Diagnosa,Sex as Gander,a.NamaDokter as First_Name,NamaKarcis as tarif, NilaiKarcis as TarifRS,(isnull(cg.[Total Radiologi],0)+isnull(cg.TotalBHP,0)+isnull(cg.TotalLab,0)+isnull(cg.TotalObat,0)+isnull(cg.TotalVisit,0)) as totalbill,NamaJaminan as NamaPerusahaan FROM DashboardData.dbo.dataRWJ a
             inner join  PerawatanSQL.dbo.View_VisitExtnded cg on cg.NoRegistrasi = a.NoRegistrasi
            WHERE
            replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir
           and Batal='0'  -- and a.TipePasien<>'2'  --and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG')
           and IdDokter=:dokter AND IdUnit = '53' 
            order by replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') asc,a.NoRegistrasi asc
            ";
                    $this->db->query($query);
                    $this->db->bind('tglawal', $tglawal);
                    $this->db->bind('tglakhir', $tglakhir);
                    $this->db->bind('dokter', $NamaDokter);
                } elseif ($JenisInfo == '2' && $JenisRekap == '1') {
                    //     $query = "SELECT a.TglKunjungan,a.NoMR,a.NoRegistrasi,b.PatientName,
                    //     b.Gander,a.Unit,pg.NamaUnit,a.[Status ID],
                    //    c.First_Name,d.TypePatient,b.Address ,op.NamaPerusahaan   AS NamaPerusahaan , hh.NamaCaraMasuk,hj.NamaCaraMasukRef,admx.Nama_Karcis as 'tarif',admx.Nilai_Karcis as 'TarifRS',
                    //    replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglregis,
                    //    replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-') as tglregis,
                    //    case 
                    //    when replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') > replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-')
                    //    then 'Lama'  ELSE 'Baru'
                    //    end as 'JenisPasien' 
                    //    ,co.[Status Name] as statusregis,'0' AS  totalbill
                    //    ,replace(CONVERT(VARCHAR(max),kkl.DiagnosaPrimer),char(13)+char(10), '') as A_Diagnosa,xm.Kecamatan,mx.Kelurahan,msx.kabupatenNama,ggg.ProvinsiNama
                    //    from PerawatanSQL.dbo.Visit a
                    //    inner join MasterdataSQL.dbo.Admision b
                    //    on a.NoMR = b.NoMR
                    //    inner join MasterdataSQL.dbo.Doctors c
                    //    on c.ID = a.Doctor_1
                    //    inner join MasterdataSQL.dbo.MstrTypePatient d
                    //    on d.ID = a.PatientType 
                    //    inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi op on op.ID = a.Asuransi
                    //    inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                    //    left join MasterdataSQL.dbo.MstrCaraMasuk hh on hh.id = a.idCaraMasuk
                    //    left join MasterdataSQL.dbo.MstrCaraMasuk_2 hj on hj.id = a.idCaraMasuk2
                    //    left join PerawatanSQL.dbo.Tarif_RJ_UGD jk on jk.ID = a.idAdmin
                    //    left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                    //    left join MedicalRecord.dbo.EMR_UGD_MedicalAss kkl on kkl.NoRegistrasi  collate  Latin1_General_CS_AS = a.NoRegistrasi  collate  Latin1_General_CS_AS
                    //    left join MasterdataSQL.dbo.mstrKecamatan xm on xm.kecamatanId = b.Kecamatan
                    //    left join MasterdataSQL.dbo.mstrKelurahan mx on mx.desaId = b.Kelurahan
                    //    left join MasterdataSQL.dbo.MstrKabupaten msx on msx.kabupatenId=b.City
                    //    left join MasterdataSQL.dbo.MstrProvinsi ggg on ggg.PovinsiID = b.[State/Province]
                    // left join MasterdataSQL.dbo.MstrKarcisAdministrasi admx on a.idAdmin=admx.ID
                    //    where replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') between  :tglawal and :tglakhir
                    //    and a.Batal='0' and d.TypePatient='ASURANSI' and pg.grup_instalasi='IGD'
                    //    and a.Doctor_1=:dokter
                    //    UNION ALL
                    //     select a.TglKunjungan,a.NoMR,a.NoRegistrasi,b.PatientName,
                    //     b.Gander,a.Unit,pg.NamaUnit,a.[Status ID],
                    //    c.First_Name,d.TypePatient,b.Address ,op.NamaPerusahaan   AS NamaPerusahaan  , hh.NamaCaraMasuk,hj.NamaCaraMasukRef,admx.Nama_Karcis as 'tarif',admx.Nilai_Karcis as 'TarifRS',
                    //    replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglregis,
                    //    replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-') as tglregis,
                    //    case 
                    //    when replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') > replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-')
                    //    then 'Lama'  ELSE 'Baru'
                    //    end as 'JenisPasien' 
                    //    ,co.[Status Name] as statusregis,'0' AS  totalbill
                    //    ,replace(CONVERT(VARCHAR(max),kkl.DiagnosaPrimer),char(13)+char(10), '') as A_Diagnosa,xm.Kecamatan,mx.Kelurahan,msx.kabupatenNama,ggg.ProvinsiNama
                    //    from PerawatanSQL.dbo.Visit a
                    //    inner join MasterdataSQL.dbo.Admision b
                    //    on a.NoMR = b.NoMR
                    //    inner join MasterdataSQL.dbo.Doctors c
                    //    on c.ID = a.Doctor_1
                    //    inner join MasterdataSQL.dbo.MstrTypePatient d
                    //    on d.ID = a.PatientType 
                    //    inner join MasterdataSQL.dbo.MstrPerusahaanJPK op on op.ID = a.Perusahaan
                    //    inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                    //    left join MasterdataSQL.dbo.MstrCaraMasuk hh on hh.id = a.idCaraMasuk
                    //    left join MasterdataSQL.dbo.MstrCaraMasuk_2 hj on hj.id = a.idCaraMasuk2
                    //    left join PerawatanSQL.dbo.Tarif_RJ_UGD jk on jk.ID = a.idAdmin
                    //    left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                    //    left join MedicalRecord.dbo.EMR_UGD_MedicalAss kkl on kkl.NoRegistrasi  collate  Latin1_General_CS_AS = a.NoRegistrasi  collate  Latin1_General_CS_AS
                    //    left join MasterdataSQL.dbo.mstrKecamatan xm on xm.kecamatanId = b.Kecamatan
                    //    left join MasterdataSQL.dbo.mstrKelurahan mx on mx.desaId = b.Kelurahan
                    //    left join MasterdataSQL.dbo.MstrKabupaten msx on msx.kabupatenId=b.City
                    //    left join MasterdataSQL.dbo.MstrProvinsi ggg on ggg.PovinsiID = b.[State/Province]
                    // left join MasterdataSQL.dbo.MstrKarcisAdministrasi admx on a.idAdmin=admx.ID
                    //    where replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') between :tglawal2 and :tglakhir2
                    //    and a.Batal='0'   and d.TypePatient<>'ASURANSI' and pg.grup_instalasi='IGD'
                    //    and a.Doctor_1=:dokter2
                    //    order by replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') asc,a.NoRegistrasi asc";

                    //    $this->db->query($query); 
                    //    $this->db->bind('tglawal', $tglawal);
                    //    $this->db->bind('tglakhir', $tglakhir);
                    //    $this->db->bind('tglawal2', $tglawal);
                    //    $this->db->bind('tglakhir2', $tglakhir);
                    //    $this->db->bind('dokter', $NamaDokter);
                    //    $this->db->bind('dokter2', $NamaDokter);

                    $query = "SELECT *, replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') TglKunjungan,BL as JenisPasien,  Case When StatusID = '0' Then 'New'
            WHEN StatusID = '1' Then 'Invoiced'
            WHEN StatusID = '2' Then 'Payment'
            WHEN StatusID = '3' Then 'Lunas'
            WHEN StatusID = '4' Then 'Close'
            End As 'statusregis',Diagnosa_Awal as A_Diagnosa,Sex as Gander,a.NamaDokter as First_Name,NamaKarcis as tarif, NilaiKarcis as TarifRS,(isnull(cg.[Total Radiologi],0)+isnull(cg.TotalBHP,0)+isnull(cg.TotalLab,0)+isnull(cg.TotalObat,0)+isnull(cg.TotalVisit,0)) as totalbill,NamaJaminan as NamaPerusahaan FROM DashboardData.dbo.dataRWJ a
             inner join  PerawatanSQL.dbo.View_VisitExtnded cg on cg.NoRegistrasi = a.NoRegistrasi
            WHERE
            replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir
           and Batal='0'  -- and a.TipePasien<>'2'  --and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG')
           and IdDokter=:dokter AND IdUnit ='1'
            order by replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') asc,a.NoRegistrasi asc
            ";
                    $this->db->query($query);
                    $this->db->bind('tglawal', $tglawal);
                    $this->db->bind('tglakhir', $tglakhir);
                    $this->db->bind('dokter', $NamaDokter);
                } elseif ($JenisInfo == '1' && $JenisRekap == '2') {
                    //     $query = "SELECT a.TglKunjungan,a.NoMR,a.NoRegistrasi,b.PatientName,
                    //     b.Gander,a.Unit,pg.NamaUnit,a.[Status ID],
                    //    c.First_Name,d.TypePatient,b.Address ,op.NamaPerusahaan   AS NamaPerusahaan , hh.NamaCaraMasuk,hj.NamaCaraMasukRef,admx.Nama_Karcis as 'tarif',admx.Nilai_Karcis as 'TarifRS',
                    //    replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglregis,
                    //    replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-') as tglregis,
                    //    case 
                    //    when replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') > replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-')
                    //    then 'Lama'  ELSE 'Baru'
                    //    end as 'JenisPasien' 
                    //    ,co.[Status Name] as statusregis,(isnull(cg.[Total Radiologi],0)+isnull(cg.TotalBHP,0)+isnull(cg.TotalLab,0)+isnull(cg.TotalObat,0)+isnull(cg.TotalVisit,0)) as totalbill
                    //    ,replace(CONVERT(VARCHAR(max),kkl.A_Diagnosa),char(13)+char(10), '') as A_Diagnosa,xm.Kecamatan,mx.Kelurahan,msx.kabupatenNama,ggg.ProvinsiNama
                    //    from PerawatanSQL.dbo.Visit a
                    //    inner join MasterdataSQL.dbo.Admision b
                    //    on a.NoMR = b.NoMR
                    //    inner join MasterdataSQL.dbo.Doctors c
                    //    on c.ID = a.Doctor_1
                    //    inner join MasterdataSQL.dbo.MstrTypePatient d
                    //    on d.ID = a.PatientType 
                    //    inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi op on op.ID = a.Asuransi
                    //    inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                    //    left join MasterdataSQL.dbo.MstrCaraMasuk hh on hh.id = a.idCaraMasuk
                    //    left join MasterdataSQL.dbo.MstrCaraMasuk_2 hj on hj.id = a.idCaraMasuk2
                    //    left join PerawatanSQL.dbo.Tarif_RJ_UGD jk on jk.ID = a.idAdmin
                    //    left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                    //    left join  PerawatanSQL.dbo.View_VisitExtnded cg on cg.NoRegistrasi = a.NoRegistrasi
                    //    left join MedicalRecord.dbo.EMR_RWJ kkl on kkl.NoRegistrasi  collate  Latin1_General_CS_AS = a.NoRegistrasi  collate  Latin1_General_CS_AS
                    //    left join MasterdataSQL.dbo.mstrKecamatan xm on xm.kecamatanId = b.Kecamatan
                    //    left join MasterdataSQL.dbo.mstrKelurahan mx on mx.desaId = b.Kelurahan
                    //    left join MasterdataSQL.dbo.MstrKabupaten msx on msx.kabupatenId=b.City
                    //    left join MasterdataSQL.dbo.MstrProvinsi ggg on ggg.PovinsiID = b.[State/Province]
                    // left join MasterdataSQL.dbo.MstrKarcisAdministrasi admx on a.idAdmin=admx.ID
                    //    where kkl.YgMelapor is null and kkl.YgMelapor is null
                    //    and replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') between :tglawal and :tglakhir
                    //    and a.Batal='0'    and d.TypePatient<>'UMUM'  and d.TypePatient='ASURANSI' and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG')
                    //    and a.Unit=:poli
                    //     and pg.id<>'53' and pg.id not in ('9','10','47','48','49','52','17')
                    //    UNION ALL
                    //     select a.TglKunjungan,a.NoMR,a.NoRegistrasi,b.PatientName,
                    //     b.Gander,a.Unit,pg.NamaUnit,a.[Status ID],
                    //    c.First_Name,d.TypePatient,b.Address ,op.NamaPerusahaan   AS NamaPerusahaan  , hh.NamaCaraMasuk,hj.NamaCaraMasukRef,admx.Nama_Karcis as 'tarif',admx.Nilai_Karcis as 'TarifRS',
                    //    replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglregis,
                    //    replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-') as tglregis,
                    //    case 
                    //    when replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') > replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-')
                    //    then 'Lama'  ELSE 'Baru'
                    //    end as 'JenisPasien'
                    //    ,co.[Status Name] as statusregis,(isnull(cg.[Total Radiologi],0)+isnull(cg.TotalBHP,0)+isnull(cg.TotalLab,0)+isnull(cg.TotalObat,0)+isnull(cg.TotalVisit,0)) as totalbill
                    //    ,replace(CONVERT(VARCHAR(max),kkl.A_Diagnosa),char(13)+char(10), '') as A_Diagnosa,xm.Kecamatan,mx.Kelurahan,msx.kabupatenNama,ggg.ProvinsiNama
                    //    from PerawatanSQL.dbo.Visit a
                    //    inner join MasterdataSQL.dbo.Admision b
                    //    on a.NoMR = b.NoMR
                    //    inner join MasterdataSQL.dbo.Doctors c
                    //    on c.ID = a.Doctor_1
                    //    inner join MasterdataSQL.dbo.MstrTypePatient d
                    //    on d.ID = a.PatientType 
                    //    inner join MasterdataSQL.dbo.MstrPerusahaanJPK op on op.ID = a.Perusahaan
                    //    inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                    //    left join MasterdataSQL.dbo.MstrCaraMasuk hh on hh.id = a.idCaraMasuk
                    //    left join MasterdataSQL.dbo.MstrCaraMasuk_2 hj on hj.id = a.idCaraMasuk2
                    //    left join PerawatanSQL.dbo.Tarif_RJ_UGD jk on jk.ID = a.idAdmin
                    //    left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                    //    left join  PerawatanSQL.dbo.View_VisitExtnded cg on cg.NoRegistrasi = a.NoRegistrasi
                    //    left join MedicalRecord.dbo.EMR_RWJ kkl on kkl.NoRegistrasi  collate  Latin1_General_CS_AS = a.NoRegistrasi  collate  Latin1_General_CS_AS
                    //    left join MasterdataSQL.dbo.mstrKecamatan xm on xm.kecamatanId = b.Kecamatan
                    //    left join MasterdataSQL.dbo.mstrKelurahan mx on mx.desaId = b.Kelurahan
                    //    left join MasterdataSQL.dbo.MstrKabupaten msx on msx.kabupatenId=b.City
                    //    left join MasterdataSQL.dbo.MstrProvinsi ggg on ggg.PovinsiID = b.[State/Province]
                    // left join MasterdataSQL.dbo.MstrKarcisAdministrasi admx on a.idAdmin=admx.ID
                    //    where kkl.YgMelapor is null and kkl.YgMelapor is null
                    //    and replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') between :tglawal2 and :tglakhir2
                    //    and a.Batal='0'   and d.TypePatient<>'ASURANSI' and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG')
                    //    and a.Unit=:poli2 and pg.id<>'53' and pg.id not in ('9','10','47','48','49','52','17')
                    //    ORDER BY a.TglKunjungan asc,NamaPerusahaan ASC";

                    //    $this->db->query($query); 
                    //    $this->db->bind('tglawal', $tglawal);
                    //    $this->db->bind('tglakhir', $tglakhir);
                    //    $this->db->bind('tglawal2', $tglawal);
                    //    $this->db->bind('tglakhir2', $tglakhir);
                    //    $this->db->bind('poli', $GrupPerawatan);
                    //    $this->db->bind('poli2', $GrupPerawatan);

                    $query = "SELECT *, replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') TglKunjungan,BL as JenisPasien,  Case When StatusID = '0' Then 'New'
            WHEN StatusID = '1' Then 'Invoiced'
            WHEN StatusID = '2' Then 'Payment'
            WHEN StatusID = '3' Then 'Lunas'
            WHEN StatusID = '4' Then 'Close'
            End As 'statusregis',Diagnosa_Awal as A_Diagnosa,Sex as Gander,a.NamaDokter as First_Name,NamaKarcis as tarif, NilaiKarcis as TarifRS,(isnull(cg.[Total Radiologi],0)+isnull(cg.TotalBHP,0)+isnull(cg.TotalLab,0)+isnull(cg.TotalObat,0)+isnull(cg.TotalVisit,0)) as totalbill,NamaJaminan as NamaPerusahaan FROM DashboardData.dbo.dataRWJ a
             inner join  PerawatanSQL.dbo.View_VisitExtnded cg on cg.NoRegistrasi = a.NoRegistrasi
            WHERE
            replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir
           and Batal='0'  -- and a.TipePasien<>'2'  --and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG')
           AND IdUnit =:poli-- AND IdUnit not in ('9','10','47','48','49','52','17','53')
           AND LEFT(a.NoMR,1) <> 'W'
            order by replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') asc,a.NoRegistrasi asc
            ";
                    $this->db->query($query);
                    $this->db->bind('tglawal', $tglawal);
                    $this->db->bind('tglakhir', $tglakhir);
                    $this->db->bind('poli', $GrupPerawatan);
                } elseif ($JenisInfo == '5' && $JenisRekap == '2') {
                    //     $query = "SELECT a.TglKunjungan,a.NoMR,a.NoRegistrasi,b.PatientName,
                    //     b.Gander,a.Unit,pg.NamaUnit,a.[Status ID],
                    //    c.First_Name,d.TypePatient,b.Address ,op.NamaPerusahaan   AS NamaPerusahaan , hh.NamaCaraMasuk,hj.NamaCaraMasukRef,admx.Nama_Karcis as 'tarif',admx.Nilai_Karcis as 'TarifRS',
                    //    replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglregis,
                    //    replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-') as tglregis,
                    //    case 
                    //    when replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') > replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-')
                    //    then 'Lama'  ELSE 'Baru'
                    //    end as 'JenisPasien' 
                    //    ,co.[Status Name] as statusregis,(isnull(cg.[Total Radiologi],0)+isnull(cg.TotalBHP,0)+isnull(cg.TotalLab,0)+isnull(cg.TotalObat,0)+isnull(cg.TotalVisit,0)) as totalbill
                    //    ,replace(CONVERT(VARCHAR(max),kkl.A_Diagnosa),char(13)+char(10), '') as A_Diagnosa,xm.Kecamatan,mx.Kelurahan,msx.kabupatenNama,ggg.ProvinsiNama
                    //    from PerawatanSQL.dbo.Visit a
                    //    inner join MasterdataSQL.dbo.Admision b
                    //    on a.NoMR = b.NoMR
                    //    inner join MasterdataSQL.dbo.Doctors c
                    //    on c.ID = a.Doctor_1
                    //    inner join MasterdataSQL.dbo.MstrTypePatient d
                    //    on d.ID = a.PatientType 
                    //    inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi op on op.ID = a.Asuransi
                    //    inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                    //    left join MasterdataSQL.dbo.MstrCaraMasuk hh on hh.id = a.idCaraMasuk
                    //    left join MasterdataSQL.dbo.MstrCaraMasuk_2 hj on hj.id = a.idCaraMasuk2
                    //    left join PerawatanSQL.dbo.Tarif_RJ_UGD jk on jk.ID = a.idAdmin
                    //    left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                    //    left join  PerawatanSQL.dbo.View_VisitExtnded cg on cg.NoRegistrasi = a.NoRegistrasi
                    //    left join MedicalRecord.dbo.EMR_RWJ kkl on kkl.NoRegistrasi  collate  Latin1_General_CS_AS = a.NoRegistrasi  collate  Latin1_General_CS_AS
                    //    left join MasterdataSQL.dbo.mstrKecamatan xm on xm.kecamatanId = b.Kecamatan
                    //    left join MasterdataSQL.dbo.mstrKelurahan mx on mx.desaId = b.Kelurahan
                    //    left join MasterdataSQL.dbo.MstrKabupaten msx on msx.kabupatenId=b.City
                    //    left join MasterdataSQL.dbo.MstrProvinsi ggg on ggg.PovinsiID = b.[State/Province]
                    // left join MasterdataSQL.dbo.MstrKarcisAdministrasi admx on a.idAdmin=admx.ID
                    //    where kkl.YgMelapor is null and kkl.YgMelapor is null
                    //    and replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') between :tglawal and :tglakhir
                    //    and a.Batal='0'    and d.TypePatient<>'UMUM'  and d.TypePatient='ASURANSI' and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG')
                    //    and a.Unit=:poli
                    //     and pg.id='53' and pg.id not in ('9','10','47','48','49','52','17')
                    //    UNION ALL
                    //     select a.TglKunjungan,a.NoMR,a.NoRegistrasi,b.PatientName,
                    //     b.Gander,a.Unit,pg.NamaUnit,a.[Status ID],
                    //    c.First_Name,d.TypePatient,b.Address ,op.NamaPerusahaan   AS NamaPerusahaan  , hh.NamaCaraMasuk,hj.NamaCaraMasukRef,admx.Nama_Karcis as 'tarif',admx.Nilai_Karcis as 'TarifRS',
                    //    replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglregis,
                    //    replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-') as tglregis,
                    //    case 
                    //    when replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') > replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-')
                    //    then 'Lama'  ELSE 'Baru'
                    //    end as 'JenisPasien'
                    //    ,co.[Status Name] as statusregis,(isnull(cg.[Total Radiologi],0)+isnull(cg.TotalBHP,0)+isnull(cg.TotalLab,0)+isnull(cg.TotalObat,0)+isnull(cg.TotalVisit,0)) as totalbill
                    //    ,replace(CONVERT(VARCHAR(max),kkl.A_Diagnosa),char(13)+char(10), '') as A_Diagnosa,xm.Kecamatan,mx.Kelurahan,msx.kabupatenNama,ggg.ProvinsiNama
                    //    from PerawatanSQL.dbo.Visit a
                    //    inner join MasterdataSQL.dbo.Admision b
                    //    on a.NoMR = b.NoMR
                    //    inner join MasterdataSQL.dbo.Doctors c
                    //    on c.ID = a.Doctor_1
                    //    inner join MasterdataSQL.dbo.MstrTypePatient d
                    //    on d.ID = a.PatientType 
                    //    inner join MasterdataSQL.dbo.MstrPerusahaanJPK op on op.ID = a.Perusahaan
                    //    inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                    //    left join MasterdataSQL.dbo.MstrCaraMasuk hh on hh.id = a.idCaraMasuk
                    //    left join MasterdataSQL.dbo.MstrCaraMasuk_2 hj on hj.id = a.idCaraMasuk2
                    //    left join PerawatanSQL.dbo.Tarif_RJ_UGD jk on jk.ID = a.idAdmin
                    //    left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                    //    left join  PerawatanSQL.dbo.View_VisitExtnded cg on cg.NoRegistrasi = a.NoRegistrasi
                    //    left join MedicalRecord.dbo.EMR_RWJ kkl on kkl.NoRegistrasi  collate  Latin1_General_CS_AS = a.NoRegistrasi  collate  Latin1_General_CS_AS
                    //    left join MasterdataSQL.dbo.mstrKecamatan xm on xm.kecamatanId = b.Kecamatan
                    //    left join MasterdataSQL.dbo.mstrKelurahan mx on mx.desaId = b.Kelurahan
                    //    left join MasterdataSQL.dbo.MstrKabupaten msx on msx.kabupatenId=b.City
                    //    left join MasterdataSQL.dbo.MstrProvinsi ggg on ggg.PovinsiID = b.[State/Province]
                    // left join MasterdataSQL.dbo.MstrKarcisAdministrasi admx on a.idAdmin=admx.ID
                    //    where kkl.YgMelapor is null and kkl.YgMelapor is null
                    //    and replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') between :tglawal2 and :tglakhir2
                    //    and a.Batal='0'   and d.TypePatient<>'ASURANSI' and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG')
                    //    and a.Unit=:poli2 and pg.id='53' and pg.id not in ('9','10','47','48','49','52','17')
                    //    ORDER BY a.TglKunjungan asc,NamaPerusahaan ASC";

                    //    $this->db->query($query); 
                    //    $this->db->bind('tglawal', $tglawal);
                    //    $this->db->bind('tglakhir', $tglakhir);
                    //    $this->db->bind('tglawal2', $tglawal);
                    //    $this->db->bind('tglakhir2', $tglakhir);
                    //    $this->db->bind('poli', $GrupPerawatan);
                    //    $this->db->bind('poli2', $GrupPerawatan);

                    $query = "SELECT *, replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') TglKunjungan,BL as JenisPasien,  Case When StatusID = '0' Then 'New'
                WHEN StatusID = '1' Then 'Invoiced'
                WHEN StatusID = '2' Then 'Payment'
                WHEN StatusID = '3' Then 'Lunas'
                WHEN StatusID = '4' Then 'Close'
                End As 'statusregis',Diagnosa_Awal as A_Diagnosa,Sex as Gander,a.NamaDokter as First_Name,NamaKarcis as tarif, NilaiKarcis as TarifRS,(isnull(cg.[Total Radiologi],0)+isnull(cg.TotalBHP,0)+isnull(cg.TotalLab,0)+isnull(cg.TotalObat,0)+isnull(cg.TotalVisit,0)) as totalbill,NamaJaminan as NamaPerusahaan FROM DashboardData.dbo.dataRWJ a
                inner join  PerawatanSQL.dbo.View_VisitExtnded cg on cg.NoRegistrasi = a.NoRegistrasi
                WHERE
                replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir
            and Batal='0'  -- and a.TipePasien<>'2'  --and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG')
            AND IdUnit =:poli-- AND IdUnit not in ('9','10','47','48','49','52','17','53')
            AND LEFT(a.NoMR,1) <> 'W'
                order by replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') asc,a.NoRegistrasi asc
                ";
                    $this->db->query($query);
                    $this->db->bind('tglawal', $tglawal);
                    $this->db->bind('tglakhir', $tglakhir);
                    $this->db->bind('poli', $GrupPerawatan);
                } elseif ($JenisInfo == '2' && $JenisRekap == '2') {
                    //     $query = "SELECT a.TglKunjungan,a.NoMR,a.NoRegistrasi,b.PatientName,
                    //     b.Gander,a.Unit,pg.NamaUnit,a.[Status ID],
                    //    c.First_Name,d.TypePatient,b.Address ,op.NamaPerusahaan   AS NamaPerusahaan , hh.NamaCaraMasuk,hj.NamaCaraMasukRef,admx.Nama_Karcis as 'tarif',admx.Nilai_Karcis as 'TarifRS',
                    //    replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglregis,
                    //    replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-') as tglregis,
                    //    case 
                    //    when replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') > replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-')
                    //    then 'Lama'  ELSE 'Baru'
                    //    end as 'JenisPasien' 
                    //    ,co.[Status Name] as statusregis,'0' AS  totalbill
                    //    ,replace(CONVERT(VARCHAR(max),kkl.DiagnosaPrimer),char(13)+char(10), '') as A_Diagnosa,xm.Kecamatan,mx.Kelurahan,msx.kabupatenNama,ggg.ProvinsiNama
                    //    from PerawatanSQL.dbo.Visit a
                    //    inner join MasterdataSQL.dbo.Admision b
                    //    on a.NoMR = b.NoMR
                    //    inner join MasterdataSQL.dbo.Doctors c
                    //    on c.ID = a.Doctor_1
                    //    inner join MasterdataSQL.dbo.MstrTypePatient d
                    //    on d.ID = a.PatientType 
                    //    inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi op on op.ID = a.Asuransi
                    //    inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                    //    left join MasterdataSQL.dbo.MstrCaraMasuk hh on hh.id = a.idCaraMasuk
                    //    left join MasterdataSQL.dbo.MstrCaraMasuk_2 hj on hj.id = a.idCaraMasuk2
                    //    left join PerawatanSQL.dbo.Tarif_RJ_UGD jk on jk.ID = a.idAdmin
                    //    left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                    //    left join MedicalRecord.dbo.EMR_UGD_MedicalAss kkl on kkl.NoRegistrasi  collate  Latin1_General_CS_AS = a.NoRegistrasi  collate  Latin1_General_CS_AS
                    //    left join MasterdataSQL.dbo.mstrKecamatan xm on xm.kecamatanId = b.Kecamatan
                    //    left join MasterdataSQL.dbo.mstrKelurahan mx on mx.desaId = b.Kelurahan
                    //    left join MasterdataSQL.dbo.MstrKabupaten msx on msx.kabupatenId=b.City
                    //    left join MasterdataSQL.dbo.MstrProvinsi ggg on ggg.PovinsiID = b.[State/Province]
                    // left join MasterdataSQL.dbo.MstrKarcisAdministrasi admx on a.idAdmin=admx.ID
                    //    where replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') between  :tglawal and :tglakhir
                    //    and a.Batal='0'    and d.TypePatient<>'UMUM'  and d.TypePatient='ASURANSI' and pg.grup_instalasi='IGD'
                    //   and a.Unit=:poli
                    //    UNION ALL
                    //     select a.TglKunjungan,a.NoMR,a.NoRegistrasi,b.PatientName,
                    //     b.Gander,a.Unit,pg.NamaUnit,a.[Status ID],
                    //    c.First_Name,d.TypePatient,b.Address ,op.NamaPerusahaan   AS NamaPerusahaan  , hh.NamaCaraMasuk,hj.NamaCaraMasukRef,admx.Nama_Karcis as 'tarif',admx.Nilai_Karcis as 'TarifRS',
                    //    replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglregis,
                    //    replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-') as tglregis,
                    //    case 
                    //    when replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') > replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-')
                    //    then 'Lama'  ELSE 'Baru'
                    //    end as 'JenisPasien' 
                    //    ,co.[Status Name] as statusregis,'0' AS  totalbill
                    //    ,replace(CONVERT(VARCHAR(max),kkl.DiagnosaPrimer),char(13)+char(10), '') as A_Diagnosa,xm.Kecamatan,mx.Kelurahan,msx.kabupatenNama,ggg.ProvinsiNama
                    //    from PerawatanSQL.dbo.Visit a
                    //    inner join MasterdataSQL.dbo.Admision b
                    //    on a.NoMR = b.NoMR
                    //    inner join MasterdataSQL.dbo.Doctors c
                    //    on c.ID = a.Doctor_1
                    //    inner join MasterdataSQL.dbo.MstrTypePatient d
                    //    on d.ID = a.PatientType 
                    //    inner join MasterdataSQL.dbo.MstrPerusahaanJPK op on op.ID = a.Perusahaan
                    //    inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                    //    left join MasterdataSQL.dbo.MstrCaraMasuk hh on hh.id = a.idCaraMasuk
                    //    left join MasterdataSQL.dbo.MstrCaraMasuk_2 hj on hj.id = a.idCaraMasuk2
                    //    left join PerawatanSQL.dbo.Tarif_RJ_UGD jk on jk.ID = a.idAdmin
                    //    left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                    //    left join MedicalRecord.dbo.EMR_UGD_MedicalAss kkl on kkl.NoRegistrasi  collate  Latin1_General_CS_AS = a.NoRegistrasi  collate  Latin1_General_CS_AS
                    //    left join MasterdataSQL.dbo.mstrKecamatan xm on xm.kecamatanId = b.Kecamatan
                    //    left join MasterdataSQL.dbo.mstrKelurahan mx on mx.desaId = b.Kelurahan
                    //    left join MasterdataSQL.dbo.MstrKabupaten msx on msx.kabupatenId=b.City
                    //    left join MasterdataSQL.dbo.MstrProvinsi ggg on ggg.PovinsiID = b.[State/Province]
                    // left join MasterdataSQL.dbo.MstrKarcisAdministrasi admx on a.idAdmin=admx.ID
                    //    where replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') between  :tglawal2 and :tglakhir2
                    //    and a.Batal='0'   and d.TypePatient<>'ASURANSI' and pg.grup_instalasi='IGD'
                    //    and a.Unit=:poli2
                    //    ORDER BY a.TglKunjungan asc,NamaPerusahaan ASC";

                    //    $this->db->query($query); 
                    //    $this->db->bind('tglawal', $tglawal);
                    //    $this->db->bind('tglakhir', $tglakhir);
                    //    $this->db->bind('tglawal2', $tglawal);
                    //    $this->db->bind('tglakhir2', $tglakhir);
                    //    $this->db->bind('poli', $GrupPerawatan);
                    //    $this->db->bind('poli2', $GrupPerawatan);

                    $query = "SELECT *, replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') TglKunjungan,BL as JenisPasien,  Case When StatusID = '0' Then 'New'
            WHEN StatusID = '1' Then 'Invoiced'
            WHEN StatusID = '2' Then 'Payment'
            WHEN StatusID = '3' Then 'Lunas'
            WHEN StatusID = '4' Then 'Close'
            End As 'statusregis',Diagnosa_Awal as A_Diagnosa,Sex as Gander,a.NamaDokter as First_Name,NamaKarcis as tarif, NilaiKarcis as TarifRS,(isnull(cg.[Total Radiologi],0)+isnull(cg.TotalBHP,0)+isnull(cg.TotalLab,0)+isnull(cg.TotalObat,0)+isnull(cg.TotalVisit,0)) as totalbill,NamaJaminan as NamaPerusahaan FROM DashboardData.dbo.dataRWJ a
            inner join  PerawatanSQL.dbo.View_VisitExtnded cg on cg.NoRegistrasi = a.NoRegistrasi
            WHERE
            replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir
        and Batal='0'  -- and a.TipePasien<>'2'  --and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG')
        AND IdUnit =:poli-- AND IdUnit not in ('9','10','47','48','49','52','17','53')
        AND LEFT(a.NoMR,1) <> 'W'
            order by replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') asc,a.NoRegistrasi asc
            ";
                    $this->db->query($query);
                    $this->db->bind('tglawal', $tglawal);
                    $this->db->bind('tglakhir', $tglakhir);
                    $this->db->bind('poli', $GrupPerawatan);
                } elseif ($JenisInfo == '7' && $JenisRekap == '2') {


                    $query = "SELECT *, replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') TglKunjungan,BL as JenisPasien,  Case When StatusID = '0' Then 'New'
            WHEN StatusID = '1' Then 'Invoiced'
            WHEN StatusID = '2' Then 'Payment'
            WHEN StatusID = '3' Then 'Lunas'
            WHEN StatusID = '4' Then 'Close'
            End As 'statusregis',Diagnosa_Awal as A_Diagnosa,Sex as Gander,a.NamaDokter as First_Name,NamaKarcis as tarif, NilaiKarcis as TarifRS,(isnull(cg.[Total Radiologi],0)+isnull(cg.TotalBHP,0)+isnull(cg.TotalLab,0)+isnull(cg.TotalObat,0)+isnull(cg.TotalVisit,0)) as totalbill,NamaJaminan as NamaPerusahaan FROM DashboardData.dbo.dataRWJ a
            inner join  PerawatanSQL.dbo.View_VisitExtnded cg on cg.NoRegistrasi = a.NoRegistrasi
            WHERE
            replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir
        and Batal='0'  -- and a.TipePasien<>'2'  --and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG')
        AND IdUnit =:poli-- AND IdUnit not in ('9','10','47','48','49','52','17','53')
            order by replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') asc,a.NoRegistrasi asc
            ";
                    $this->db->query($query);
                    $this->db->bind('tglawal', $tglawal);
                    $this->db->bind('tglakhir', $tglakhir);
                    $this->db->bind('poli', $GrupPerawatan);
                }

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
                    $pasing['Address'] = $row['Address'] .
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
            } elseif ($JenisTipe == '2') {

                if ($JenisInfo == '1' && $JenisRekap == '1') {

                    $query = "SELECT *
                    FROM (
                         select NamaUnit, a.NamaDokter as First_Name,
                         SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                        count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                        from DashboardData.dbo.dataRWJ a
                        where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir
                        and IdUnit not in ('9','10','48','49','52','1') and Batal='0'
                        group by NamaUnit,a.NamaDokter,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                    ) AS QuarterlyData
                    PIVOT( SUM([REGISTRASI Count])   
                            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],[13],[14],[15],
                            [16],[17],[18],[19],[20],[21],[22],[23],[24],[25],[26],[27],[28],[29],[30],[31],
                            [grandtotal])) AS QPivot
                            order by NamaUnit asc";
                } elseif ($JenisInfo == '2' && $JenisRekap == '1') {

                    $query = "SELECT *
                        FROM (
                                select NamaUnit, a.NamaDokter as First_Name,
                                SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                            count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                            from DashboardData.dbo.dataRWJ a
                            where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir
                            and IdUnit = '1' and Batal='0'
                            group by NamaUnit,a.NamaDokter,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                        ) AS QuarterlyData
                        PIVOT( SUM([REGISTRASI Count])   
                                FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],[13],[14],[15],
                                [16],[17],[18],[19],[20],[21],[22],[23],[24],[25],[26],[27],[28],[29],[30],[31],
                                [grandtotal])) AS QPivot
                                order by NamaUnit asc";
                } elseif ($JenisInfo == '5' && $JenisRekap == '12') {

                    $query = "SELECT *,NamaPaket as First_Name
                        FROM (
                                     select  a.NamaUnit, c.NamaPaket,
                             SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                            count(isnull(c.NamaPaket,0)) as  [REGISTRASI Count]
                            from DashboardData.dbo.dataRWJ a
                            inner join MedicalRecord.dbo.MR_PaketMCU c on c.NoRegistrasi  collate  Latin1_General_CS_AS = a.NoRegistrasi  collate  Latin1_General_CS_AS
                            where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir
                            AND a.IdUnit='53' and Batal='0'
                        group by a.NamaUnit,c.NamaPaket,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                             
                        ) AS QuarterlyData
                        PIVOT( SUM([REGISTRASI Count])   
                                FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],[13],[14],[15],
                                [16],[17],[18],[19],[20],[21],[22],[23],[24],[25],[26],[27],[28],[29],[30],[31],
                                [grandtotal])) AS QPivot
                                order by NamaUnit asc";
                } elseif ($JenisInfo == '1' && $JenisRekap == '2') { //RAJAL, REKAP

                    $query = "SELECT *,'' as First_Name
                        FROM (
                            select a.NamaUnit, 
                            SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                            count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                            from DashboardData.dbo.dataRWJ a
                            where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir
                            and a.IdUnit not in ('9','10','48','49','53','1') and Batal='0'
                            group by a.NamaUnit, SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                            
                        ) AS QuarterlyData
                        PIVOT( SUM([REGISTRASI Count])   
                                FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],[13],[14],[15],
                                [16],[17],[18],[19],[20],[21],[22],[23],[24],[25],[26],[27],[28],[29],[30],[31],
                                [grandtotal])) AS QPivot
                                order by NamaUnit asc";
                } elseif ($JenisInfo == '7' && $JenisRekap == '2') { //PENUNJANG, REKAP

                    $query = "SELECT *,'' as First_Name
                    FROM (
                        select a.NamaUnit, 
                        SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                        count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                        from DashboardData.dbo.dataRWJ a
                        where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir
                        and a.IdUnit in ('9','10') and Batal='0'
                        group by a.NamaUnit, SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                        
                    ) AS QuarterlyData
                    PIVOT( SUM([REGISTRASI Count])   
                            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],[13],[14],[15],
                            [16],[17],[18],[19],[20],[21],[22],[23],[24],[25],[26],[27],[28],[29],[30],[31],
                            [grandtotal])) AS QPivot
                            order by NamaUnit asc";
                } elseif ($JenisInfo == '5' && $JenisRekap == '2') { //MCU, REKAP

                    $query = "SELECT *,'' as First_Name
                             FROM (
                                 select a.NamaUnit, 
                                 SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                                 count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                                 from DashboardData.dbo.dataRWJ a
                                 where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir
                                 and a.IdUnit = '53' and Batal='0'
                                 group by a.NamaUnit, SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                                 
                             ) AS QuarterlyData
                             PIVOT( SUM([REGISTRASI Count])   
                                     FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],[13],[14],[15],
                                     [16],[17],[18],[19],[20],[21],[22],[23],[24],[25],[26],[27],[28],[29],[30],[31],
                                     [grandtotal])) AS QPivot
                                     order by NamaUnit asc";
                } elseif ($JenisInfo == '2' && $JenisRekap == '2') {

                    $query = "SELECT *,'' as First_Name
                    FROM (
                        select a.NamaUnit, 
                        SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                        count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                        from DashboardData.dbo.dataRWJ a
                        where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir
                        and a.IdUnit = '1' and Batal='0'
                        group by a.NamaUnit, SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                        
                    ) AS QuarterlyData
                    PIVOT( SUM([REGISTRASI Count])   
                            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],[13],[14],[15],
                            [16],[17],[18],[19],[20],[21],[22],[23],[24],[25],[26],[27],[28],[29],[30],[31],
                            [grandtotal])) AS QPivot
                            order by NamaUnit asc";
                } elseif ($JenisInfo == '4' && $JenisRekap == '4') {

                    $query = "	SELECT x.Kecamatan as 'Keterangan',sum(x.jumlah ) as jumlah
                    from (
                        SELECT   a.Kecamatan  AS  Kecamatan ,count( isnull(a.Kecamatan,0) ) as jumlah
                        from DashboardData.dbo.dataRWJ a
                        where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir and Batal='0'
                        --and a.Batal='0' and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG','IGD')
                        group by a.Kecamatan 
                        union all
                        SELECT   a.Kecamatan  AS  Kelurahan ,count( isnull(a.Kecamatan,0) ) as jumlah
                        from DashboardData.dbo.dataRWI a
                        where replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') between :tglawal2 and :tglakhir2
                        group by a.Kecamatan 
                        ) x 
                    group by x.Kecamatan  order by jumlah desc";
                } elseif ($JenisInfo == '4' && $JenisRekap == '5') {

                    $query = "	SELECT x.Kelurahan as 'Keterangan',sum(x.jumlah ) as jumlah
                            from (
                                SELECT   a.Kelurahan  AS  Kelurahan ,count( isnull(a.Kelurahan,0) ) as jumlah
                                from DashboardData.dbo.dataRWJ a
                                where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir and Batal='0'
                                group by a.Kelurahan 
                                union all
                                SELECT   a.Kelurahan  AS  Kelurahan ,count( isnull(a.Kelurahan,0) ) as jumlah
                                from DashboardData.dbo.dataRWI a
                                where replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') between :tglawal2 and :tglakhir2
                                group by a.Kelurahan 
                                ) x 
                            group by x.Kelurahan  order by jumlah desc";
                } elseif ($JenisInfo == '4' && $JenisRekap == '6') {

                    $query = "	SELECT x.ProvinsiNama as 'Keterangan',sum(x.jumlah ) as jumlah
                      from (
                          SELECT   a.ProvinsiNama  AS  ProvinsiNama ,count( isnull(a.ProvinsiNama,0) ) as jumlah
                          from DashboardData.dbo.dataRWJ a
                          where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir and Batal='0'
                          group by a.ProvinsiNama 
                          union all
                          SELECT   a.ProvinsiNama  AS  ProvinsiNama ,count( isnull(a.ProvinsiNama,0) ) as jumlah
                          from DashboardData.dbo.dataRWI a
                          where replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') between :tglawal2 and :tglakhir2
                          group by a.ProvinsiNama 
                          ) x 
                      group by x.ProvinsiNama  order by jumlah desc";
                } elseif ($JenisInfo == '4' && $JenisRekap == '7') {

                    $query = "SELECT  x.ket as 'Keterangan',sum(x.jumlah ) as jumlah
                    from (
                        SELECT  '0 sd 28 hari' as ket, count( isnull(datediff(dd,a.DateOfBirth,getdate()),0) ) as jumlah
                        from DashboardData.dbo.dataRWJ a
                        where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir and Batal='0'
                        and datediff(dd,a.DateOfBirth,getdate()) between '0' and '28'
                        union all
                         SELECT  '29 Hari sd 18 tahun' as ket, count( isnull(datediff(dd,a.DateOfBirth,getdate()),0) ) as jumlah
                        from DashboardData.dbo.dataRWJ a
                        where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal2 and :tglakhir2 and Batal='0'
                        and datediff(dd,a.DateOfBirth,getdate()) between '29' and '6570'
                        union all
                         SELECT '19 tahun sd 60 tahun' as ket, count( isnull(datediff(dd,a.DateOfBirth,getdate()),0) ) as jumlah
                        from DashboardData.dbo.dataRWJ a
                        where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal3 and :tglakhir3 and Batal='0'
                        and datediff(dd,a.DateOfBirth,getdate()) between '6571' and '21900'
                        union all
                        SELECT   '0 sd 28 hari' as ket,count( isnull(datediff(dd,a.DateOfBirth,getdate()),0) ) as jumlah
                        from DashboardData.dbo.dataRWI a
                        where replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') between  :tglawal4 and :tglakhir4 and Batal='0'
                        and datediff(dd,a.DateOfBirth,getdate()) between '0' and '28'
                        union all
                        SELECT  '29 Hari sd 18 tahun' as ket,count( isnull(datediff(dd,a.DateOfBirth,getdate()),0) ) as jumlah
                        from DashboardData.dbo.dataRWI a
                        where replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') between :tglawal5 and :tglakhir5
                        and datediff(dd,a.DateOfBirth,getdate()) between '29' and '6570'
                        union all
                        SELECT   '19 tahun sd 60 tahun' as ket,count( isnull(datediff(dd,a.DateOfBirth,getdate()),0) ) as jumlah
                        from DashboardData.dbo.dataRWI a
                        where replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') between  :tglawal6 and :tglakhir6
                        and datediff(dd,a.DateOfBirth,getdate()) between '6571' and '21900'
                     ) x 
                    group by x.ket  order by jumlah desc";
                } elseif ($JenisInfo == '4' && $JenisRekap == '8') {

                    $query = "SELECT  x.pekerjaan as 'Keterangan',sum(x.jumlah ) as jumlah
                    from (
                        SELECT    a.Pekerjaan  AS  pekerjaan  ,count(isnull(a.Pekerjaan,0)) as jumlah
                        from DashboardData.dbo.dataRWJ a
                        where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir and Batal='0'
                        --and a.Batal='0' and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG','IGD')
                        group by a.Pekerjaan
                        union all
                        SELECT   a.Pekerjaan  AS  pekerjaan  ,count(isnull(a.Pekerjaan,0)) as jumlah
                        from DashboardData.dbo.dataRWI a
                        where replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') between :tglawal2 and :tglakhir2
                        group by a.Pekerjaan
                     ) x 
                    group by x.pekerjaan  order by jumlah desc";
                } elseif ($JenisInfo == '4' && $JenisRekap == '9') {

                    $query = "SELECT  x.Religion as 'Keterangan',sum(x.jumlah ) as jumlah
                    from (
                        SELECT    a.Religion  AS  Religion  ,count(isnull(a.Religion,0)) as jumlah
                        from DashboardData.dbo.dataRWJ a
                        where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between  :tglawal and :tglakhir and Batal='0'
                        --and a.Batal='0' and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG','IGD')
                        group by a.Religion
                        union all
                        SELECT   a.Religion  AS  Religion  ,count(isnull(a.Religion,0)) as jumlah
                        from DashboardData.dbo.dataRWI a
                        where replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') between :tglawal2 and :tglakhir2
                        group by a.Religion
                     ) x 
                    group by x.Religion  order by jumlah desc";
                } elseif ($JenisInfo == '4' && $JenisRekap == '10') {
                    $query = "SELECT  x.BAHASA as 'Keterangan',sum(x.jumlah ) as jumlah
                    from (
                        SELECT    a.BAHASA collate Latin1_General_CI_AS  AS  BAHASA  ,count(isnull(a.BAHASA,0)) as jumlah
                        from DashboardData.dbo.dataRWJ a
                        where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between  :tglawal and :tglakhir and Batal='0'
                        --and a.Batal='0' and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG','IGD')
                        group by a.BAHASA
                        union all
                        SELECT   b.BAHASA  AS  BAHASA  ,count(isnull(b.BAHASA,0)) as jumlah
                        from RawatInapSQL.dbo.Inpatient a
                        LEFT join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                        LEFT join MasterdataSQL.dbo.Doctors c on c.ID = a.drDPJP
                        LEFT join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.TypePatient 
                        left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.StatusID
                        where replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') between :tglawal2 and :tglakhir2
                        group by b.BAHASA
                     ) x 
                    group by x.BAHASA  order by jumlah desc";
                } elseif ($JenisInfo == '4' && $JenisRekap == '11') {
                    $query = " SELECT  x.Etnis as 'Keterangan',sum(x.jumlah ) as jumlah
                    from (
                        SELECT    a.Etnis collate Latin1_General_CI_AS  AS  Etnis  ,count(isnull(a.Etnis,0)) as jumlah
                        from DashboardData.dbo.dataRWJ a
                        where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir and Batal='0'
                        --and a.Batal='0' and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG')
                        group by a.Etnis
                        union all
                        SELECT   b.Etnis  AS  Etnis  ,count(isnull(b.Etnis,0)) as jumlah
                        from RawatInapSQL.dbo.Inpatient a
                        LEFT join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                        LEFT join MasterdataSQL.dbo.Doctors c on c.ID = a.drDPJP
                        LEFT join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.TypePatient 
                        left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.StatusID
                        where replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') between :tglawal2 and :tglakhir2
                        group by b.Etnis
                     ) x 
                    group by x.Etnis  order by jumlah desc";
                } elseif ($JenisInfo == '1' && $JenisRekap == '13') {

                    $query = "SELECT  a.NamaJaminan   AS 'Keterangan' ,count( a.NamaJaminan ) as jumlah
                     from DashboardData.dbo.dataRWJ a
                     where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir and Batal='0'
                    and a.IdUnit<>'1'
                    and a.TipePasien='2'
                     group by  a.NamaJaminan 
                     UNION ALL
                    SELECT  a.NamaJaminan   AS 'Keterangan' ,count( a.NamaJaminan ) as jumlah
                     from DashboardData.dbo.dataRWJ a
                     where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal2 and :tglakhir2 and Batal='0'
                    and a.IdUnit<>'1'
                    and a.TipePasien<>'2'
                     group by  a.NamaJaminan 
                     order by jumlah desc";
                } elseif ($JenisInfo == '2' && $JenisRekap == '13') {

                    $query = "SELECT  a.NamaJaminan   AS 'Keterangan' ,count( a.NamaJaminan ) as jumlah
                     from DashboardData.dbo.dataRWJ a
                     where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir and Batal='0'
                    and a.IdUnit='1'
                    and a.TipePasien='2'
                     group by  a.NamaJaminan 
                     UNION ALL
                    SELECT  a.NamaJaminan   AS 'Keterangan' ,count( a.NamaJaminan ) as jumlah
                     from DashboardData.dbo.dataRWJ a
                     where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal2 and :tglakhir2 and Batal='0'
                    and a.IdUnit='1'
                    and a.TipePasien<>'2'
                     group by  a.NamaJaminan 
                     order by jumlah desc";
                } elseif ($JenisInfo == '3' && $JenisRekap == '13') {

                    $query = "SELECT  a.NamaJaminan   AS 'Keterangan' ,count( a.NamaJaminan ) as jumlah
                     from DashboardData.dbo.dataRWI a
                     where replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') between :tglawal and :tglakhir
                   -- and a.IdUnit<>'1'
                    and a.TipePasien='2'
                     group by  a.NamaJaminan 
                     UNION ALL
                SELECT  a.NamaJaminan   AS 'Keterangan' ,count( a.NamaJaminan ) as jumlah
                     from DashboardData.dbo.dataRWI a
                     where replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') between :tglawal2 and :tglakhir2
                   -- and a.IdUnit<>'1'
                    and a.TipePasien<>'2'
                     group by  a.NamaJaminan 
                     order by jumlah desc";
                }

                $this->db->query($query);
                $this->db->bind('tglawal', $tglawal);
                $this->db->bind('tglakhir', $tglakhir);

                if ($JenisInfo == '4' && $JenisRekap == '7') {
                    $this->db->bind('tglawal3', $tglawal);
                    $this->db->bind('tglakhir3', $tglakhir);
                    $this->db->bind('tglawal4', $tglawal);
                    $this->db->bind('tglakhir4', $tglakhir);
                    $this->db->bind('tglawal5', $tglawal);
                    $this->db->bind('tglakhir5', $tglakhir);
                    $this->db->bind('tglawal6', $tglawal);
                    $this->db->bind('tglakhir6', $tglakhir);
                }

                if (($JenisInfo == '4' && $JenisRekap == '4') || ($JenisInfo == '4' && $JenisRekap == '5') || ($JenisInfo == '4' && $JenisRekap == '6') || ($JenisInfo == '4' && $JenisRekap == '7') || ($JenisInfo == '4' && $JenisRekap == '8') || ($JenisInfo == '4' && $JenisRekap == '9') || ($JenisInfo == '4' && $JenisRekap == '10') || ($JenisInfo == '4' && $JenisRekap == '11') || ($JenisInfo == '1' && $JenisRekap == '13') || ($JenisInfo == '2' && $JenisRekap == '13') || ($JenisInfo == '3' && $JenisRekap == '13')) {
                    $this->db->bind('tglawal2', $tglawal);
                    $this->db->bind('tglakhir2', $tglakhir);

                    $data =  $this->db->resultSet();
                    $rows = array();
                    $no = 1;
                    foreach ($data as $row) {
                        $pasing['no'] = $no++;

                        $pasing['Keterangan']  = $row['Keterangan'];
                        $pasing['total'] = $row['jumlah'];

                        $rows[] = $pasing;
                    }
                } else {
                    $data =  $this->db->resultSet();
                    $rows = array();
                    $no = 1;
                    foreach ($data as $row) {
                        $pasing['no'] = $no++;

                        $total = $row['01'] + $row['02'] + $row['03'] + $row['04'] + $row['05']
                            + $row['06'] + $row['07'] + $row['08'] + $row['09'] + $row['10']
                            + $row['11'] + $row['12'] + $row['13'] + $row['14'] + $row['15']
                            + $row['16'] + $row['17'] + $row['18'] + $row['19'] + $row['20']
                            + $row['21'] + $row['22'] + $row['23'] + $row['24'] + $row['25']
                            + $row['26'] + $row['27'] + $row['28'] + $row['29'] + $row['30']
                            + $row['31'];

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
            } elseif ($JenisInfo == '6') {

                $query = " SELECT a.TglOrder,a.TglOperasi,a.NoMR,a.NoRegistrasi,a.NamaPasien,a.DiagnosaPreOP,a.DiagnosaPostOP,
                 a.JenisOperasi,a.DrOperator,a.DrAnastesi,a.PerkiraanLamaOP,b.NamaJaminan,a.GroupSpesialis,a.KlasifikasiOP,x.LaporanOP
                 from MedicalRecord.dbo.View_OrderOperasi a 
                 inner join DashboardData.dbo.dataRWJ b on b.NoRegistrasi collate  Latin1_General_CS_AS  =a.NoRegistrasi collate  Latin1_General_CS_AS 
                                 left join MedicalRecord.dbo.MR_LaporanOperasi x on a.ID=x.OrderID
                 --inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = b.PatientType 
                 --inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi op on op.ID = b.Asuransi
                 where a.StatusOrder<>'Batal'  and Batal='0'
                 and replace(CONVERT(VARCHAR(11), a.TglOperasi, 111), '/','-') between :tglawal and :tglakhir
                 and b.TipePasien='2' 
                  UNION ALL
                  select a.TglOrder,a.TglOperasi,a.NoMR,a.NoRegistrasi,a.NamaPasien,a.DiagnosaPreOP,a.DiagnosaPostOP,
                 a.JenisOperasi,a.DrOperator,a.DrAnastesi,a.PerkiraanLamaOP,b.NamaJaminan,a.GroupSpesialis,a.KlasifikasiOP,x.LaporanOP
                 from MedicalRecord.dbo.View_OrderOperasi a 
                 inner join DashboardData.dbo.dataRWJ b on b.NoRegistrasi collate  Latin1_General_CS_AS  =a.NoRegistrasi collate  Latin1_General_CS_AS 
                                 left join MedicalRecord.dbo.MR_LaporanOperasi x on a.ID=x.OrderID
                 where a.StatusOrder<>'Batal'  and Batal='0'
                 and replace(CONVERT(VARCHAR(11), a.TglOperasi, 111), '/','-') between :tglawal2 and :tglakhir2
                  and b.TipePasien<>'2' 
                  UNION ALL
                 select a.TglOrder,a.TglOperasi,a.NoMR,a.NoRegistrasi,a.NamaPasien,a.DiagnosaPreOP,a.DiagnosaPostOP,
                 a.JenisOperasi,a.DrOperator,a.DrAnastesi,a.PerkiraanLamaOP,b.NamaJaminan,a.GroupSpesialis,a.KlasifikasiOP,x.LaporanOP
                 from MedicalRecord.dbo.View_OrderOperasi a 
                 inner join DashboardData.dbo.dataRWI b on b.NoRegistrasi collate  Latin1_General_CS_AS  =a.NoRegistrasi collate  Latin1_General_CS_AS 
                                 left join MedicalRecord.dbo.MR_LaporanOperasi x on a.ID=x.OrderID
                 where a.StatusOrder<>'Batal' 
                 and replace(CONVERT(VARCHAR(11), a.TglOperasi, 111), '/','-') between :tglawal3 and :tglakhir3
                  and b.TipePasien = '2'
                  UNION ALL
                   select a.TglOrder,a.TglOperasi,a.NoMR,a.NoRegistrasi,a.NamaPasien,a.DiagnosaPreOP,a.DiagnosaPostOP,
                 a.JenisOperasi,a.DrOperator,a.DrAnastesi,a.PerkiraanLamaOP,b.NamaJaminan,a.GroupSpesialis,a.KlasifikasiOP,x.LaporanOP
                 from MedicalRecord.dbo.View_OrderOperasi a 
                 inner join DashboardData.dbo.dataRWI b on b.NoRegistrasi collate  Latin1_General_CS_AS  =a.NoRegistrasi collate  Latin1_General_CS_AS 
                                 left join MedicalRecord.dbo.MR_LaporanOperasi x on a.ID=x.OrderID
                 where a.StatusOrder<>'Batal' 
                 and replace(CONVERT(VARCHAR(11), a.TglOperasi, 111), '/','-') between :tglawal4 and :tglakhir4
                  and b.TipePasien <> '2'";

                $this->db->query($query);
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
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;

                    $pasing['TglOrder'] = $row['TglOrder'];
                    $pasing['TglOperasi'] = $row['TglOperasi'];
                    $pasing['NoMR'] = $row['NoMR'];
                    $pasing['NoRegistrasi'] = $row['NoRegistrasi'];
                    $pasing['NamaPasien'] = $row['NamaPasien'];
                    $pasing['DiagnosaPreOP'] = $row['DiagnosaPreOP'];
                    $pasing['DiagnosaPostOP'] = $row['DiagnosaPostOP'];
                    $pasing['JenisOperasi'] = $row['JenisOperasi'];
                    $pasing['DrOperator'] = $row['DrOperator'];
                    $pasing['DrAnastesi'] = $row['DrAnastesi'];
                    $pasing['PerkiraanLamaOP'] = $row['PerkiraanLamaOP'];
                    $pasing['NamaPerusahaan'] = $row['NamaJaminan'];
                    $pasing['GroupSpesialis'] = $row['GroupSpesialis'];
                    $pasing['KlasifikasiOP'] = $row['KlasifikasiOP'];
                    $pasing['LaporanOP'] = $row['LaporanOP'];

                    $rows[] = $pasing;
                }
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
            $JenisRekap = $data['JenisRekap']; //yang banyak
            $JenisTipe = $data['JenisTipe']; //Detail atau Rekap
            $JenisInfo = $data['JenisInfo']; //Pasien apa
            $GrupPerawatan = $data['GrupPerawatan']; //ID unit
            $NamaDokter = $data['NamaDokter']; //ID DOkter

            if ($JenisTipe == '1') {
                //PASIEN RAWAT JALAN DAN IGD
                if ($JenisInfo == '1' && $JenisRekap == '1') {

                    $query = "SELECT *, replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') TglKunjungan,BL as JenisPasien,  Case When StatusID = '0' Then 'New'
            WHEN StatusID = '1' Then 'Invoiced'
            WHEN StatusID = '2' Then 'Payment'
            WHEN StatusID = '3' Then 'Lunas'
            WHEN StatusID = '4' Then 'Close'
            End As 'statusregis',Diagnosa_Awal as A_Diagnosa,Sex as Gander,a.NamaDokter as First_Name,NamaKarcis as tarif, NilaiKarcis as TarifRS,(isnull(cg.[Total Radiologi],0)+isnull(cg.TotalBHP,0)+isnull(cg.TotalLab,0)+isnull(cg.TotalObat,0)+isnull(cg.TotalVisit,0)) as totalbill,NamaJaminan as NamaPerusahaan FROM DashboardData.dbo.dataRWJ a
             inner join  PerawatanSQL.dbo.View_VisitExtnded cg on cg.NoRegistrasi = a.NoRegistrasi
            WHERE
            replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir
           and Batal='0'  -- and a.TipePasien<>'2'  --and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG')
           and IdDokter=:dokter AND IdUnit not in ('9','10','47','48','49')
            order by replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') asc,a.NoRegistrasi asc
            ";
                    //$query_master = $query_master1;=
                    $this->db->query($query);
                    $this->db->bind('tglawal', $tglawal);
                    $this->db->bind('tglakhir', $tglakhir);
                    // $this->db->bind('tglawal2', $tglawal);
                    // $this->db->bind('tglakhir2', $tglakhir);
                    $this->db->bind('dokter', $NamaDokter);
                    //$this->db->bind('dokter2', $NamaDokter);

                    // PASIEN RAWAT INAP
                } elseif ($JenisInfo == '5' && $JenisRekap == '1') {

                    $query = "SELECT *, replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') TglKunjungan,BL as JenisPasien,  Case When StatusID = '0' Then 'New'
            WHEN StatusID = '1' Then 'Invoiced'
            WHEN StatusID = '2' Then 'Payment'
            WHEN StatusID = '3' Then 'Lunas'
            WHEN StatusID = '4' Then 'Close'
            End As 'statusregis',Diagnosa_Awal as A_Diagnosa,Sex as Gander,a.NamaDokter as First_Name,NamaKarcis as tarif, NilaiKarcis as TarifRS,(isnull(cg.[Total Radiologi],0)+isnull(cg.TotalBHP,0)+isnull(cg.TotalLab,0)+isnull(cg.TotalObat,0)+isnull(cg.TotalVisit,0)) as totalbill,NamaJaminan as NamaPerusahaan FROM DashboardData.dbo.dataRWJ a
             inner join  PerawatanSQL.dbo.View_VisitExtnded cg on cg.NoRegistrasi = a.NoRegistrasi
            WHERE
            replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir
           and Batal='0'  -- and a.TipePasien<>'2'  --and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG')
           and IdDokter=:dokter AND IdUnit = '53' 
            order by replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') asc,a.NoRegistrasi asc
            ";
                    $this->db->query($query);
                    $this->db->bind('tglawal', $tglawal);
                    $this->db->bind('tglakhir', $tglakhir);
                    $this->db->bind('dokter', $NamaDokter);
                } elseif ($JenisInfo == '2' && $JenisRekap == '1') {

                    $query = "SELECT *, replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') TglKunjungan,BL as JenisPasien,  Case When StatusID = '0' Then 'New'
            WHEN StatusID = '1' Then 'Invoiced'
            WHEN StatusID = '2' Then 'Payment'
            WHEN StatusID = '3' Then 'Lunas'
            WHEN StatusID = '4' Then 'Close'
            End As 'statusregis',Diagnosa_Awal as A_Diagnosa,Sex as Gander,a.NamaDokter as First_Name,NamaKarcis as tarif, NilaiKarcis as TarifRS,(isnull(cg.[Total Radiologi],0)+isnull(cg.TotalBHP,0)+isnull(cg.TotalLab,0)+isnull(cg.TotalObat,0)+isnull(cg.TotalVisit,0)) as totalbill,NamaJaminan as NamaPerusahaan FROM DashboardData.dbo.dataRWJ a
             inner join  PerawatanSQL.dbo.View_VisitExtnded cg on cg.NoRegistrasi = a.NoRegistrasi
            WHERE
            replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir
           and Batal='0'  -- and a.TipePasien<>'2'  --and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG')
           and IdDokter=:dokter AND IdUnit ='1'
            order by replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') asc,a.NoRegistrasi asc
            ";
                    $this->db->query($query);
                    $this->db->bind('tglawal', $tglawal);
                    $this->db->bind('tglakhir', $tglakhir);
                    $this->db->bind('dokter', $NamaDokter);
                } elseif ($JenisInfo == '1' && $JenisRekap == '2') {

                    $query = "SELECT *, replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') TglKunjungan,BL as JenisPasien,  Case When StatusID = '0' Then 'New'
            WHEN StatusID = '1' Then 'Invoiced'
            WHEN StatusID = '2' Then 'Payment'
            WHEN StatusID = '3' Then 'Lunas'
            WHEN StatusID = '4' Then 'Close'
            End As 'statusregis',Diagnosa_Awal as A_Diagnosa,Sex as Gander,a.NamaDokter as First_Name,NamaKarcis as tarif, NilaiKarcis as TarifRS,(isnull(cg.[Total Radiologi],0)+isnull(cg.TotalBHP,0)+isnull(cg.TotalLab,0)+isnull(cg.TotalObat,0)+isnull(cg.TotalVisit,0)) as totalbill,NamaJaminan as NamaPerusahaan FROM DashboardData.dbo.dataRWJ a
             inner join  PerawatanSQL.dbo.View_VisitExtnded cg on cg.NoRegistrasi = a.NoRegistrasi
            WHERE
            replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir
           and Batal='0'  -- and a.TipePasien<>'2'  --and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG')
           AND IdUnit =:poli-- AND IdUnit not in ('9','10','47','48','49','52','17','53')
           AND LEFT(a.NoMR,1) <> 'W'
            order by replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') asc,a.NoRegistrasi asc
            ";
                    $this->db->query($query);
                    $this->db->bind('tglawal', $tglawal);
                    $this->db->bind('tglakhir', $tglakhir);
                    $this->db->bind('poli', $GrupPerawatan);
                } elseif ($JenisInfo == '5' && $JenisRekap == '2') {

                    $query = "SELECT *, replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') TglKunjungan,BL as JenisPasien,  Case When StatusID = '0' Then 'New'
                WHEN StatusID = '1' Then 'Invoiced'
                WHEN StatusID = '2' Then 'Payment'
                WHEN StatusID = '3' Then 'Lunas'
                WHEN StatusID = '4' Then 'Close'
                End As 'statusregis',Diagnosa_Awal as A_Diagnosa,Sex as Gander,a.NamaDokter as First_Name,NamaKarcis as tarif, NilaiKarcis as TarifRS,(isnull(cg.[Total Radiologi],0)+isnull(cg.TotalBHP,0)+isnull(cg.TotalLab,0)+isnull(cg.TotalObat,0)+isnull(cg.TotalVisit,0)) as totalbill,NamaJaminan as NamaPerusahaan FROM DashboardData.dbo.dataRWJ a
                inner join  PerawatanSQL.dbo.View_VisitExtnded cg on cg.NoRegistrasi = a.NoRegistrasi
                WHERE
                replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir
            and Batal='0'  -- and a.TipePasien<>'2'  --and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG')
            AND IdUnit =:poli-- AND IdUnit not in ('9','10','47','48','49','52','17','53')
            AND LEFT(a.NoMR,1) <> 'W'
                order by replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') asc,a.NoRegistrasi asc
                ";
                    $this->db->query($query);
                    $this->db->bind('tglawal', $tglawal);
                    $this->db->bind('tglakhir', $tglakhir);
                    $this->db->bind('poli', $GrupPerawatan);
                } elseif ($JenisInfo == '2' && $JenisRekap == '2') {
                    $query = "SELECT *, replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') TglKunjungan,BL as JenisPasien,  Case When StatusID = '0' Then 'New'
            WHEN StatusID = '1' Then 'Invoiced'
            WHEN StatusID = '2' Then 'Payment'
            WHEN StatusID = '3' Then 'Lunas'
            WHEN StatusID = '4' Then 'Close'
            End As 'statusregis',Diagnosa_Awal as A_Diagnosa,Sex as Gander,a.NamaDokter as First_Name,NamaKarcis as tarif, NilaiKarcis as TarifRS,(isnull(cg.[Total Radiologi],0)+isnull(cg.TotalBHP,0)+isnull(cg.TotalLab,0)+isnull(cg.TotalObat,0)+isnull(cg.TotalVisit,0)) as totalbill,NamaJaminan as NamaPerusahaan FROM DashboardData.dbo.dataRWJ a
            inner join  PerawatanSQL.dbo.View_VisitExtnded cg on cg.NoRegistrasi = a.NoRegistrasi
            WHERE
            replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir
        and Batal='0'  -- and a.TipePasien<>'2'  --and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG')
        AND IdUnit =:poli-- AND IdUnit not in ('9','10','47','48','49','52','17','53')
        AND LEFT(a.NoMR,1) <> 'W'
            order by replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') asc,a.NoRegistrasi asc
            ";
                    $this->db->query($query);
                    $this->db->bind('tglawal', $tglawal);
                    $this->db->bind('tglakhir', $tglakhir);
                    $this->db->bind('poli', $GrupPerawatan);
                } elseif ($JenisInfo == '7' && $JenisRekap == '2') {


                    $query = "SELECT *, replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') TglKunjungan,BL as JenisPasien,  Case When StatusID = '0' Then 'New'
            WHEN StatusID = '1' Then 'Invoiced'
            WHEN StatusID = '2' Then 'Payment'
            WHEN StatusID = '3' Then 'Lunas'
            WHEN StatusID = '4' Then 'Close'
            End As 'statusregis',Diagnosa_Awal as A_Diagnosa,Sex as Gander,a.NamaDokter as First_Name,NamaKarcis as tarif, NilaiKarcis as TarifRS,(isnull(cg.[Total Radiologi],0)+isnull(cg.TotalBHP,0)+isnull(cg.TotalLab,0)+isnull(cg.TotalObat,0)+isnull(cg.TotalVisit,0)) as totalbill,NamaJaminan as NamaPerusahaan FROM DashboardData.dbo.dataRWJ a
            inner join  PerawatanSQL.dbo.View_VisitExtnded cg on cg.NoRegistrasi = a.NoRegistrasi
            WHERE
            replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir
        and Batal='0'  -- and a.TipePasien<>'2'  --and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG')
        AND IdUnit =:poli-- AND IdUnit not in ('9','10','47','48','49','52','17','53')
            order by replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') asc,a.NoRegistrasi asc
            ";
                    $this->db->query($query);
                    $this->db->bind('tglawal', $tglawal);
                    $this->db->bind('tglakhir', $tglakhir);
                    $this->db->bind('poli', $GrupPerawatan);
                }

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
                    $pasing['Address'] = $row['Address'] .
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
            } elseif ($JenisTipe == '2') {

                if ($JenisInfo == '1' && $JenisRekap == '1') {

                    $query = "SELECT *
                    FROM (
                         select NamaUnit, a.NamaDokter as First_Name,
                         SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                        count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                        from DashboardData.dbo.dataRWJ a
                        where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir and Batal='0'
                        and IdUnit not in ('9','10','48','49','53','1')
                        group by NamaUnit,a.NamaDokter,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                    ) AS QuarterlyData
                    PIVOT( SUM([REGISTRASI Count])   
                            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],[13],[14],[15],
                            [16],[17],[18],[19],[20],[21],[22],[23],[24],[25],[26],[27],[28],[29],[30],[31],
                            [grandtotal])) AS QPivot
                            order by NamaUnit asc";
                } elseif ($JenisInfo == '2' && $JenisRekap == '1') {

                    $query = "SELECT *
                        FROM (
                                select NamaUnit, a.NamaDokter as First_Name,
                                SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                            count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                            from DashboardData.dbo.dataRWJ a
                            where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir and Batal='0'
                            and IdUnit = '1'
                            group by NamaUnit,a.NamaDokter,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                        ) AS QuarterlyData
                        PIVOT( SUM([REGISTRASI Count])   
                                FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],[13],[14],[15],
                                [16],[17],[18],[19],[20],[21],[22],[23],[24],[25],[26],[27],[28],[29],[30],[31],
                                [grandtotal])) AS QPivot
                                order by NamaUnit asc";
                } elseif ($JenisInfo == '5' && $JenisRekap == '12') {

                    $query = "SELECT *,NamaPaket as First_Name
                        FROM (
                                     select  a.NamaUnit, c.NamaPaket,
                             SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                            count(isnull(c.NamaPaket,0)) as  [REGISTRASI Count]
                            from DashboardData.dbo.dataRWJ a
                            inner join MedicalRecord.dbo.MR_PaketMCU c on c.NoRegistrasi  collate  Latin1_General_CS_AS = a.NoRegistrasi  collate  Latin1_General_CS_AS
                            where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir and Batal='0'
                            AND a.IdUnit='53'
                        group by a.NamaUnit,c.NamaPaket,SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                             
                        ) AS QuarterlyData
                        PIVOT( SUM([REGISTRASI Count])   
                                FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],[13],[14],[15],
                                [16],[17],[18],[19],[20],[21],[22],[23],[24],[25],[26],[27],[28],[29],[30],[31],
                                [grandtotal])) AS QPivot
                                order by NamaUnit asc";
                } elseif ($JenisInfo == '1' && $JenisRekap == '2') { //RAJAL, REKAP

                    $query = "SELECT *,'' as First_Name
                        FROM (
                            select a.NamaUnit, 
                            SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                            count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                            from DashboardData.dbo.dataRWJ a
                            where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir and Batal='0'
                                    and IdUnit not in ('9','10','48','49','53','1')
                            group by a.NamaUnit, SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                            
                        ) AS QuarterlyData
                        PIVOT( SUM([REGISTRASI Count])   
                                FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],[13],[14],[15],
                                [16],[17],[18],[19],[20],[21],[22],[23],[24],[25],[26],[27],[28],[29],[30],[31],
                                [grandtotal])) AS QPivot
                                order by NamaUnit asc";
                } elseif ($JenisInfo == '7' && $JenisRekap == '2') { //PENUNJANG, REKAP

                    $query = "SELECT *,'' as First_Name
                    FROM (
                        select a.NamaUnit, 
                        SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                        count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                        from DashboardData.dbo.dataRWJ a
                        where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir and Batal='0'
                        and a.IdUnit in ('9','10')
                        group by a.NamaUnit, SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                        
                    ) AS QuarterlyData
                    PIVOT( SUM([REGISTRASI Count])   
                            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],[13],[14],[15],
                            [16],[17],[18],[19],[20],[21],[22],[23],[24],[25],[26],[27],[28],[29],[30],[31],
                            [grandtotal])) AS QPivot
                            order by NamaUnit asc";
                } elseif ($JenisInfo == '5' && $JenisRekap == '2') { //MCU, REKAP

                    $query = "SELECT *,'' as First_Name
                             FROM (
                                 select a.NamaUnit, 
                                 SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                                 count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                                 from DashboardData.dbo.dataRWJ a
                                 where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir and Batal='0'
                                 and a.IdUnit = '53'
                                 group by a.NamaUnit, SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                                 
                             ) AS QuarterlyData
                             PIVOT( SUM([REGISTRASI Count])   
                                     FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],[13],[14],[15],
                                     [16],[17],[18],[19],[20],[21],[22],[23],[24],[25],[26],[27],[28],[29],[30],[31],
                                     [grandtotal])) AS QPivot
                                     order by NamaUnit asc";
                } elseif ($JenisInfo == '2' && $JenisRekap == '2') {

                    $query = "SELECT *,'' as First_Name
                    FROM (
                        select a.NamaUnit, 
                        SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2) [Quarter],
                        count(isnull(a.IdDokter,0)) as  [REGISTRASI Count]
                        from DashboardData.dbo.dataRWJ a
                        where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir and Batal='0'
                        and a.IdUnit = '1'
                        group by a.NamaUnit, SUBSTRING(replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-'),9,2)
                        
                    ) AS QuarterlyData
                    PIVOT( SUM([REGISTRASI Count])   
                            FOR Quarter IN ([01],[02],[03],[04],[05],[06],[07],[08],[09],[10],[11],[12],[13],[14],[15],
                            [16],[17],[18],[19],[20],[21],[22],[23],[24],[25],[26],[27],[28],[29],[30],[31],
                            [grandtotal])) AS QPivot
                            order by NamaUnit asc";
                } elseif ($JenisInfo == '4' && $JenisRekap == '4') {

                    $query = "	SELECT x.Kecamatan as 'Keterangan',sum(x.jumlah ) as jumlah
                    from (
                        SELECT   a.Kecamatan  AS  Kecamatan ,count( isnull(a.Kecamatan,0) ) as jumlah
                        from DashboardData.dbo.dataRWJ a
                        where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir and Batal='0'
                        --and a.Batal='0' and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG','IGD')
                        group by a.Kecamatan 
                        union all
                        SELECT   a.Kecamatan  AS  Kelurahan ,count( isnull(a.Kecamatan,0) ) as jumlah
                        from DashboardData.dbo.dataRWI a
                        where replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') between :tglawal2 and :tglakhir2
                        group by a.Kecamatan 
                        ) x 
                    group by x.Kecamatan  order by jumlah desc";
                } elseif ($JenisInfo == '4' && $JenisRekap == '5') {

                    $query = "	SELECT x.Kelurahan as 'Keterangan',sum(x.jumlah ) as jumlah
                            from (
                                SELECT   a.Kelurahan  AS  Kelurahan ,count( isnull(a.Kelurahan,0) ) as jumlah
                                from DashboardData.dbo.dataRWJ a
                                where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir and Batal='0'
                                group by a.Kelurahan 
                                union all
                                SELECT   a.Kelurahan  AS  Kelurahan ,count( isnull(a.Kelurahan,0) ) as jumlah
                                from DashboardData.dbo.dataRWI a
                                where replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') between :tglawal2 and :tglakhir2
                                group by a.Kelurahan 
                                ) x 
                            group by x.Kelurahan  order by jumlah desc";
                } elseif ($JenisInfo == '4' && $JenisRekap == '6') {

                    $query = "	SELECT x.ProvinsiNama as 'Keterangan',sum(x.jumlah ) as jumlah
                      from (
                          SELECT   a.ProvinsiNama  AS  ProvinsiNama ,count( isnull(a.ProvinsiNama,0) ) as jumlah
                          from DashboardData.dbo.dataRWJ a
                          where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir and Batal='0'
                          group by a.ProvinsiNama 
                          union all
                          SELECT   a.ProvinsiNama  AS  ProvinsiNama ,count( isnull(a.ProvinsiNama,0) ) as jumlah
                          from DashboardData.dbo.dataRWI a
                          where replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') between :tglawal2 and :tglakhir2
                          group by a.ProvinsiNama 
                          ) x 
                      group by x.ProvinsiNama  order by jumlah desc";
                } elseif ($JenisInfo == '4' && $JenisRekap == '7') {

                    $query = "SELECT  x.ket as 'Keterangan',sum(x.jumlah ) as jumlah
                    from (
                        SELECT  '0 sd 28 hari' as ket, count( isnull(datediff(dd,a.DateOfBirth,getdate()),0) ) as jumlah
                        from DashboardData.dbo.dataRWJ a
                        where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir and Batal='0'
                        and datediff(dd,a.DateOfBirth,getdate()) between '0' and '28'
                        union all
                         SELECT  '29 Hari sd 18 tahun' as ket, count( isnull(datediff(dd,a.DateOfBirth,getdate()),0) ) as jumlah
                        from DashboardData.dbo.dataRWJ a
                        where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal2 and :tglakhir2 and Batal='0'
                        and datediff(dd,a.DateOfBirth,getdate()) between '29' and '6570'
                        union all
                         SELECT '19 tahun sd 60 tahun' as ket, count( isnull(datediff(dd,a.DateOfBirth,getdate()),0) ) as jumlah
                        from DashboardData.dbo.dataRWJ a
                        where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal3 and :tglakhir3 and Batal='0'
                        and datediff(dd,a.DateOfBirth,getdate()) between '6571' and '21900'
                        union all
                        SELECT   '0 sd 28 hari' as ket,count( isnull(datediff(dd,a.DateOfBirth,getdate()),0) ) as jumlah
                        from DashboardData.dbo.dataRWI a
                        where replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') between  :tglawal4 and :tglakhir4
                        and datediff(dd,a.DateOfBirth,getdate()) between '0' and '28'
                        union all
                        SELECT  '29 Hari sd 18 tahun' as ket,count( isnull(datediff(dd,a.DateOfBirth,getdate()),0) ) as jumlah
                        from DashboardData.dbo.dataRWI a
                        where replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') between :tglawal5 and :tglakhir5
                        and datediff(dd,a.DateOfBirth,getdate()) between '29' and '6570'
                        union all
                        SELECT   '19 tahun sd 60 tahun' as ket,count( isnull(datediff(dd,a.DateOfBirth,getdate()),0) ) as jumlah
                        from DashboardData.dbo.dataRWI a
                        where replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') between  :tglawal6 and :tglakhir6
                        and datediff(dd,a.DateOfBirth,getdate()) between '6571' and '21900'
                     ) x 
                    group by x.ket  order by jumlah desc";
                } elseif ($JenisInfo == '4' && $JenisRekap == '8') {

                    $query = "SELECT  x.pekerjaan as 'Keterangan',sum(x.jumlah ) as jumlah
                    from (
                        SELECT    a.Pekerjaan  AS  pekerjaan  ,count(isnull(a.Pekerjaan,0)) as jumlah
                        from DashboardData.dbo.dataRWJ a
                        where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir and Batal='0'
                        --and a.Batal='0' and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG','IGD')
                        group by a.Pekerjaan
                        union all
                        SELECT   a.Pekerjaan  AS  pekerjaan  ,count(isnull(a.Pekerjaan,0)) as jumlah
                        from DashboardData.dbo.dataRWI a
                        where replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') between :tglawal2 and :tglakhir2
                        group by a.Pekerjaan
                     ) x 
                    group by x.pekerjaan  order by jumlah desc";
                } elseif ($JenisInfo == '4' && $JenisRekap == '9') {

                    $query = "SELECT  x.Religion as 'Keterangan',sum(x.jumlah ) as jumlah
                    from (
                        SELECT    a.Religion  AS  Religion  ,count(isnull(a.Religion,0)) as jumlah
                        from DashboardData.dbo.dataRWJ a
                        where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between  :tglawal and :tglakhir and Batal='0'
                        --and a.Batal='0' and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG','IGD')
                        group by a.Religion
                        union all
                        SELECT   a.Religion  AS  Religion  ,count(isnull(a.Religion,0)) as jumlah
                        from DashboardData.dbo.dataRWI a
                        where replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') between :tglawal2 and :tglakhir2
                        group by a.Religion
                     ) x 
                    group by x.Religion  order by jumlah desc";
                } elseif ($JenisInfo == '4' && $JenisRekap == '10') {
                    $query = "SELECT  x.BAHASA as 'Keterangan',sum(x.jumlah ) as jumlah
                    from (
                        SELECT    a.BAHASA collate Latin1_General_CI_AS AS  BAHASA  ,count(isnull(a.BAHASA,0)) as jumlah
                        from DashboardData.dbo.dataRWJ a
                        where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between  :tglawal and :tglakhir and Batal='0'
                        --and a.Batal='0' and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG','IGD')
                        group by a.BAHASA
                        union all
                        SELECT   b.BAHASA  AS  BAHASA  ,count(isnull(b.BAHASA,0)) as jumlah
                        from RawatInapSQL.dbo.Inpatient a
                        LEFT join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                        LEFT join MasterdataSQL.dbo.Doctors c on c.ID = a.drDPJP
                        LEFT join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.TypePatient 
                        left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.StatusID
                        where replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') between :tglawal2 and :tglakhir2
                        group by b.BAHASA
                     ) x 
                    group by x.BAHASA  order by jumlah desc";
                } elseif ($JenisInfo == '4' && $JenisRekap == '11') {
                    $query = " SELECT  x.Etnis as 'Keterangan',sum(x.jumlah ) as jumlah
                    from (
                        SELECT    a.Etnis collate Latin1_General_CI_AS AS  Etnis  ,count(isnull(a.Etnis,0)) as jumlah
                        from DashboardData.dbo.dataRWJ a
                        where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir and Batal='0'
                        --and a.Batal='0' and pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG')
                        group by a.Etnis
                        union all
                        SELECT   b.Etnis  AS  Etnis  ,count(isnull(b.Etnis,0)) as jumlah
                        from RawatInapSQL.dbo.Inpatient a
                        LEFT join MasterdataSQL.dbo.Admision b on a.NoMR = b.NoMR
                        LEFT join MasterdataSQL.dbo.Doctors c on c.ID = a.drDPJP
                        LEFT join MasterdataSQL.dbo.MstrTypePatient d on d.ID = a.TypePatient 
                        left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.StatusID
                        where replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') between :tglawal2 and :tglakhir2
                        group by b.Etnis
                     ) x 
                    group by x.Etnis  order by jumlah desc";
                } elseif ($JenisInfo == '1' && $JenisRekap == '13') {

                    $query = "SELECT  a.NamaJaminan   AS 'Keterangan' ,count( a.NamaJaminan ) as jumlah
                     from DashboardData.dbo.dataRWJ a
                     where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir and Batal='0'
                    and a.IdUnit<>'1'
                    and a.TipePasien='2'
                     group by  a.NamaJaminan 
                     UNION ALL
                    SELECT  a.NamaJaminan   AS 'Keterangan' ,count( a.NamaJaminan ) as jumlah
                     from DashboardData.dbo.dataRWJ a
                     where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal2 and :tglakhir2 and Batal='0'
                    and a.IdUnit<>'1'
                    and a.TipePasien<>'2'
                     group by  a.NamaJaminan 
                     order by jumlah desc";
                } elseif ($JenisInfo == '2' && $JenisRekap == '13') {

                    $query = "SELECT  a.NamaJaminan   AS 'Keterangan' ,count( a.NamaJaminan ) as jumlah
                     from DashboardData.dbo.dataRWJ a
                     where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal and :tglakhir and Batal='0'
                    and a.IdUnit='1'
                    and a.TipePasien='2'
                     group by  a.NamaJaminan 
                     UNION ALL
                    SELECT  a.NamaJaminan   AS 'Keterangan' ,count( a.NamaJaminan ) as jumlah
                     from DashboardData.dbo.dataRWJ a
                     where replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between :tglawal2 and :tglakhir2 and Batal='0'
                    and a.IdUnit='1'
                    and a.TipePasien<>'2'
                     group by  a.NamaJaminan 
                     order by jumlah desc";
                } elseif ($JenisInfo == '3' && $JenisRekap == '13') {

                    $query = "SELECT  a.NamaJaminan   AS 'Keterangan' ,count( a.NamaJaminan ) as jumlah
                     from DashboardData.dbo.dataRWI a
                     where replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') between :tglawal and :tglakhir
                   -- and a.IdUnit<>'1'
                    and a.TipePasien='2'
                     group by  a.NamaJaminan 
                     UNION ALL
                SELECT  a.NamaJaminan   AS 'Keterangan' ,count( a.NamaJaminan ) as jumlah
                     from DashboardData.dbo.dataRWI a
                     where replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') between :tglawal2 and :tglakhir2
                   -- and a.IdUnit<>'1'
                    and a.TipePasien<>'2'
                     group by  a.NamaJaminan 
                     order by jumlah desc";
                }

                $this->db->query($query);
                $this->db->bind('tglawal', $tglawal);
                $this->db->bind('tglakhir', $tglakhir);

                if ($JenisInfo == '4' && $JenisRekap == '7') {
                    $this->db->bind('tglawal3', $tglawal);
                    $this->db->bind('tglakhir3', $tglakhir);
                    $this->db->bind('tglawal4', $tglawal);
                    $this->db->bind('tglakhir4', $tglakhir);
                    $this->db->bind('tglawal5', $tglawal);
                    $this->db->bind('tglakhir5', $tglakhir);
                    $this->db->bind('tglawal6', $tglawal);
                    $this->db->bind('tglakhir6', $tglakhir);
                }

                if (($JenisInfo == '4' && $JenisRekap == '4') || ($JenisInfo == '4' && $JenisRekap == '5') || ($JenisInfo == '4' && $JenisRekap == '6') || ($JenisInfo == '4' && $JenisRekap == '7') || ($JenisInfo == '4' && $JenisRekap == '8') || ($JenisInfo == '4' && $JenisRekap == '9') || ($JenisInfo == '4' && $JenisRekap == '10') || ($JenisInfo == '4' && $JenisRekap == '11') || ($JenisInfo == '1' && $JenisRekap == '13') || ($JenisInfo == '2' && $JenisRekap == '13') || ($JenisInfo == '3' && $JenisRekap == '13')) {
                    $this->db->bind('tglawal2', $tglawal);
                    $this->db->bind('tglakhir2', $tglakhir);

                    $data =  $this->db->resultSet();
                    $rows = array();
                    $no = 1;
                    foreach ($data as $row) {
                        $pasing['no'] = $no++;

                        $pasing['Keterangan']  = $row['Keterangan'];
                        $pasing['total'] = $row['jumlah'];

                        $rows[] = $pasing;
                    }
                } else {
                    $data =  $this->db->resultSet();
                    $rows = array();
                    $no = 1;
                    foreach ($data as $row) {
                        $pasing['no'] = $no++;

                        $total = $row['01'] + $row['02'] + $row['03'] + $row['04'] + $row['05']
                            + $row['06'] + $row['07'] + $row['08'] + $row['09'] + $row['10']
                            + $row['11'] + $row['12'] + $row['13'] + $row['14'] + $row['15']
                            + $row['16'] + $row['17'] + $row['18'] + $row['19'] + $row['20']
                            + $row['21'] + $row['22'] + $row['23'] + $row['24'] + $row['25']
                            + $row['26'] + $row['27'] + $row['28'] + $row['29'] + $row['30']
                            + $row['31'];

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
            } elseif ($JenisInfo == '6') {

                $query = "SELECT a.TglOrder,a.TglOperasi,a.NoMR,a.NoRegistrasi,a.NamaPasien,a.DiagnosaPreOP,a.DiagnosaPostOP,
                                 a.JenisOperasi,a.DrOperator,a.DrAnastesi,a.PerkiraanLamaOP,b.NamaJaminan as NamaPerusahaan,a.GroupSpesialis,a.KlasifikasiOP,x.LaporanOP
                                 from MedicalRecord.dbo.View_OrderOperasi a 
                                 inner join DashboardData.dbo.dataRWJ b on b.NoRegistrasi collate  Latin1_General_CS_AS  =a.NoRegistrasi collate  Latin1_General_CS_AS 
                                 left join MedicalRecord.dbo.MR_LaporanOperasi x on a.ID=x.OrderID
                                 --inner join MasterdataSQL.dbo.MstrTypePatient d on d.ID = b.PatientType 
                                 --inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi op on op.ID = b.Asuransi
                                 where a.StatusOrder<>'Batal' and Batal='0'
                                 and replace(CONVERT(VARCHAR(11), a.TglOperasi, 111), '/','-') between :tglawal and :tglakhir
                                 and b.TipePasien='2' 
                                  UNION ALL
                                  select a.TglOrder,a.TglOperasi,a.NoMR,a.NoRegistrasi,a.NamaPasien,a.DiagnosaPreOP,a.DiagnosaPostOP,
                                 a.JenisOperasi,a.DrOperator,a.DrAnastesi,a.PerkiraanLamaOP,b.NamaJaminan as NamaPerusahaan,a.GroupSpesialis,a.KlasifikasiOP,x.LaporanOP
                                 from MedicalRecord.dbo.View_OrderOperasi a 
                                 inner join DashboardData.dbo.dataRWJ b on b.NoRegistrasi collate  Latin1_General_CS_AS  =a.NoRegistrasi collate  Latin1_General_CS_AS 
                                 left join MedicalRecord.dbo.MR_LaporanOperasi x on a.ID=x.OrderID
                                 where a.StatusOrder<>'Batal' and Batal='0'
                                 and replace(CONVERT(VARCHAR(11), a.TglOperasi, 111), '/','-') between :tglawal2 and :tglakhir2
                                  and b.TipePasien<>'2' 
                                  UNION ALL
                                 select a.TglOrder,a.TglOperasi,a.NoMR,a.NoRegistrasi,a.NamaPasien,a.DiagnosaPreOP,a.DiagnosaPostOP,
                                 a.JenisOperasi,a.DrOperator,a.DrAnastesi,a.PerkiraanLamaOP,b.NamaJaminan as NamaPerusahaan,a.GroupSpesialis,a.KlasifikasiOP,x.LaporanOP
                                 from MedicalRecord.dbo.View_OrderOperasi a 
                                 inner join DashboardData.dbo.dataRWI b on b.NoRegistrasi collate  Latin1_General_CS_AS  =a.NoRegistrasi collate  Latin1_General_CS_AS 
                                 inner join MedicalRecord.dbo.MR_LaporanOperasi x on a.ID=x.OrderID
                                 where a.StatusOrder<>'Batal' 
                                 and replace(CONVERT(VARCHAR(11), a.TglOperasi, 111), '/','-') between :tglawal3 and :tglakhir3
                                  and b.TipePasien = '2'
                                  UNION ALL
                                   select a.TglOrder,a.TglOperasi,a.NoMR,a.NoRegistrasi,a.NamaPasien,a.DiagnosaPreOP,a.DiagnosaPostOP,
                                 a.JenisOperasi,a.DrOperator,a.DrAnastesi,a.PerkiraanLamaOP,b.NamaJaminan as NamaPerusahaan,a.GroupSpesialis,a.KlasifikasiOP,x.LaporanOP
                                 from MedicalRecord.dbo.View_OrderOperasi a 
                                 inner join DashboardData.dbo.dataRWI b on b.NoRegistrasi collate  Latin1_General_CS_AS  =a.NoRegistrasi collate  Latin1_General_CS_AS
                                 left join MedicalRecord.dbo.MR_LaporanOperasi x on a.ID=x.OrderID
                                 where a.StatusOrder<>'Batal' 
                                 and replace(CONVERT(VARCHAR(11), a.TglOperasi, 111), '/','-') between :tglawal4 and :tglakhir4
                                  and b.TipePasien <> '2'";

                $this->db->query($query);
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
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;

                    $pasing['TglOrder'] = $row['TglOrder'];
                    $pasing['TglOperasi'] = $row['TglOperasi'];
                    $pasing['NoMR'] = $row['NoMR'];
                    $pasing['NoRegistrasi'] = $row['NoRegistrasi'];
                    $pasing['NamaPasien'] = $row['NamaPasien'];
                    $pasing['DiagnosaPreOP'] = $row['DiagnosaPreOP'];
                    $pasing['DiagnosaPostOP'] = $row['DiagnosaPostOP'];
                    $pasing['JenisOperasi'] = $row['JenisOperasi'];
                    $pasing['DrOperator'] = $row['DrOperator'];
                    $pasing['DrAnastesi'] = $row['DrAnastesi'];
                    $pasing['PerkiraanLamaOP'] = $row['PerkiraanLamaOP'];
                    $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                    $pasing['GroupSpesialis'] = $row['GroupSpesialis'];
                    $pasing['KlasifikasiOP'] = $row['KlasifikasiOP'];
                    $pasing['LaporanOP'] = $row['LaporanOP'];

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
