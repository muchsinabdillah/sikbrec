<?php
class  B_InformationRegistrasi_Model
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
            $GrupPerawatan = $data['GrupPerawatan'];

            //PASIEN RAWAT JALAN DAN IGD
            if ($jenis_info == '1') {
                //     $query_master1 = "SELECT * from (SELECT ROW_NUMBER()Over(partition by a.NoRegistrasi order by a.NoRegistrasi) as totalreg,a.TglKunjungan,a.NoMR,a.NoRegistrasi,b.PatientName, b.Tipe_Idcard, b.ID_Card_number,
                //     replace(CONVERT(VARCHAR(11), b.Date_of_birth, 111), '/','-') as Date_of_birth,
                //                  b.Gander,a.Unit,pg.NamaUnit,a.[Status ID],pg.ID as 'IDUNIT',
                //                 c.First_Name,d.TypePatient,b.Address ,
                //                 case when d.ID='2' then opx.NamaPerusahaan
                //                  when d.ID='5' then op.NamaPerusahaan
                //                 else 'UMUM' end AS NamaPerusahaan  , hh.NamaCaraMasuk,hj.NamaCaraMasukRef,
                //                 --jk.[Product Name] as tarif,jk.TarifRS,
                //                 replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglregisx,
                //                 replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-') as tglregis,
                //                 case 
                //                 when replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') > replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-')
                //                 then 'Lama'  ELSE 'Baru'
                //                 end as 'JenisPasien' 
                //                 ,co.[Status Name] as statusregis,(isnull(cg.[Total Radiologi],0)+isnull(cg.TotalBHP,0)+isnull(cg.TotalLab,0)+isnull(cg.TotalObat,0)+isnull(cg.TotalVisit,0)) as totalbill
                //                 ,xm.Kecamatan,mx.Kelurahan,msx.kabupatenNama,ggg.ProvinsiNama,'' as AssTriase,ttv.StatusHamil,ttv.Gravida,ttv.Para,ttv.Abortus,replace(CONVERT(VARCHAR(11), ttv.HPHT, 111), '/','-') as HPHT,replace(CONVERT(VARCHAR(11), ttv.HPL, 111), '/','-') as HPL,ttv.UsiaKehamilan,ttv.CatatanKehamilan,replace(CONVERT(VARCHAR(max),kkl.A_Diagnosa),char(13)+char(10), '') as A_Diagnosa,b.[Home Phone],b.[Mobile Phone],admx.Nama_Karcis as 'tarif',admx.Nilai_Karcis as 'TarifRS',
                //                 case when d.ID='2' then opx.ID
                //                 else op.ID end AS idpenjamin 
                //                 from PerawatanSQL.dbo.Visit a
                //                 inner join MasterdataSQL.dbo.Admision b
                //                 on a.NoMR = b.NoMR
                //                 inner join MasterdataSQL.dbo.Doctors c
                //                 on c.ID = a.Doctor_1
                //                 inner join MasterdataSQL.dbo.MstrTypePatient d
                //                 on d.ID = a.PatientType 
                //                 left join MasterdataSQL.dbo.MstrPerusahaanJPK op on op.ID = a.Perusahaan
                //                 left join MasterdataSQL.dbo.MstrPerusahaanAsuransi opx on opx.ID = a.Asuransi
                //                 inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                //                 left join MasterdataSQL.dbo.MstrCaraMasuk hh on hh.id = a.idCaraMasuk
                //                 left join MasterdataSQL.dbo.MstrCaraMasuk_2 hj on hj.id = a.idCaraMasuk2
                //                 left join PerawatanSQL.dbo.Tarif_RJ_UGD jk on jk.ID = a.idAdmin
                //                 inner join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                //                 inner join  PerawatanSQL.dbo.View_VisitExtnded cg on cg.NoRegistrasi = a.NoRegistrasi
                //                -- left join MedicalRecord.dbo.EMR_RWJ kkl on kkl.NoRegistrasi  collate  Latin1_General_CS_AS = a.NoRegistrasi  collate  Latin1_General_CS_AS
                //                 inner join MasterdataSQL.dbo.mstrKecamatan xm on xm.kecamatanId = b.Kecamatan
                //                 inner join MasterdataSQL.dbo.mstrKelurahan mx on mx.desaId = b.Kelurahan
                //                 inner join MasterdataSQL.dbo.MstrKabupaten msx on msx.kabupatenId=b.City
                //                 inner join MasterdataSQL.dbo.MstrProvinsi ggg on ggg.PovinsiID = b.[State/Province]
                //         --            outer apply (
                //         --                SELECT TOP 1 NoRegistrasi,A_Diagnosa
                //         --from MedicalRecord.dbo.EMR_RWJ where NoRegistrasi collate Latin1_General_CS_AS=a.NoRegistrasi collate Latin1_General_CS_AS and YgMelapor is null
                //         --                ) kkl
                // 		left join (select NoRegistrasi,A_Diagnosa from MedicalRecord.dbo.EMR_RWJ where YgMelapor is null ) kkl on a.NoRegistrasi collate SQL_Latin1_General_CP1_CI_AS=kkl.NoRegistrasi collate SQL_Latin1_General_CP1_CI_AS
                // --                outer apply
                // --(SELECT top 1 NoRegistrasi,StatusHamil,Gravida,Para,Abortus,HPHT,HPL,UsiaKehamilan,CatatanKehamilan
                // --from MedicalRecord.dbo.EMR_RWJ_TTV where NoRegistrasi collate Latin1_General_CS_AS=a.NoRegistrasi collate Latin1_General_CS_AS and NamaUser is not null)ttv
                // left join (select NoRegistrasi,StatusHamil,Gravida,Para,Abortus,HPHT,HPL,UsiaKehamilan,CatatanKehamilan from MedicalRecord.dbo.EMR_RWJ_TTV where NamaUser is not null) 
                // ttv on a.NoRegistrasi collate SQL_Latin1_General_CP1_CI_AS=ttv.NoRegistrasi collate SQL_Latin1_General_CP1_CI_AS
                // left join MasterdataSQL.dbo.MstrKarcisAdministrasi admx on a.idAdmin=admx.ID
                //                 where replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') between  :tglawal and :tglakhir AND pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG','IGD')
                //                 and a.Batal='0' )x where totalreg=1 ";
                $query_master1 = "SELECT *,replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') as tglregisx,BL as 'JenisPasien',TipeIdCard as 'Tipe_Idcard',NoIdCard as 'ID_Card_number',DateOfBirth as 'Date_of_birth',Sex as Gander, Diagnosa_Awal as A_Diagnosa,a.NamaDokter as First_Name,NamaJaminan as NamaPerusahaan,'' as 'AssTriase',NamaCaraMasuk,NamaCaraMasukRef,NamaKarcis as tarif,NilaiKarcis as TarifRS,(isnull(cg.[Total Radiologi],0)+isnull(cg.TotalBHP,0)+isnull(cg.TotalLab,0)+isnull(cg.TotalObat,0)+isnull(cg.TotalVisit,0)) as totalbill,'' as StatusHamil,'' as Gravida,'' as Para,'' as Abortus,'' as HPHT,'' as HPL,'' as UsiaKehamilan,'' as CatatanKehamilan,IdUnit as Unit,HomePhone as [Home Phone],MobilePhone as [Mobile Phone],--'' as statusregis,
           -- '' as tarif,
            Case When StatusID = '0' Then 'New'
                WHEN StatusID = '1' Then 'Invoiced'
                WHEN StatusID = '2' Then 'Payment'
                WHEN StatusID = '3' Then 'Lunas'
                WHEN StatusID = '4' Then 'Close'
                End As 'statusregis'
             from DashboardData.dbo.dataRWJ a
             inner join  PerawatanSQL.dbo.View_VisitExtnded cg on cg.NoRegistrasi = a.NoRegistrasi
             WHERE replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between  :tglawal and :tglakhir AND Batal='0' AND LEFT(a.NoMR,1) <> 'W'";
                if ($GrupPerawatan != null || $GrupPerawatan != '') {
                    //$where = " AND x.IDUNIT=:GrupPerawatan";
                    $where = " AND IdUnit=:GrupPerawatan";
                } else {
                    $where = "";
                }
                $query_master = $query_master1 . $where . " ";

                // PASIEN RAWAT INAP
            } elseif ($jenis_info == '3') {
                // $query_master = "SELECT * FROM (SELECT ROW_NUMBER()Over(partition by a.NoRegRI order by a.NoRegRI) as totalreg, a.StartDate as TglKunjungan,a.NoMR,a.NoRegRI as NoRegistrasi,b.PatientName, b.Tipe_Idcard, b.ID_Card_number,
                // replace(CONVERT(VARCHAR(11), b.Date_of_birth, 111), '/','-') as Date_of_birth,
                // b.Gander,a.JenisRawat as NamaUnit, 
                // c.First_Name,d.TypePatient,b.Address ,
                // case when d.ID='2' then opx.NamaPerusahaan
                // when d.ID='5' then op.NamaPerusahaan
                // else 'UMUM' end AS NamaPerusahaan
                // ,co.[Status Name] as statusregis,
                // replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as tglregisx,
                // replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-') as tglregis,
                // case 
                // when replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') > replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-')
                // then 'Lama'  ELSE 'Baru'
                // end as 'JenisPasien', '' as NamaCaraMasuk,'' as NamaCaraMasukRef,'' as tarif,'' as TarifRS,'0' AS  totalbill,
                // xm.Kecamatan,mx.Kelurahan,msx.kabupatenNama,ggg.ProvinsiNama,replace(CONVERT(VARCHAR(max),ppx.Diagnosa_Akhir),char(13)+char(10), '') as A_Diagnosa,'' as AssTriase,'' as StatusHamil,'' as Gravida,'' as Para,'' as Abortus,'' as HPHT,'' as HPL,'' as UsiaKehamilan,'' as CatatanKehamilan,'' as Unit,b.[Home Phone],b.[Mobile Phone],
                // case when d.ID='2' then opx.ID
                //                 else op.ID end AS idpenjamin 
                // from RawatInapSQL.dbo.Inpatient a
                // inner join MasterdataSQL.dbo.Admision b
                // on a.NoMR = b.NoMR
                // inner join MasterdataSQL.dbo.Doctors c
                // on c.ID = a.drPenerima
                // inner join MasterdataSQL.dbo.MstrTypePatient d
                // on d.ID = a.TypePatient 
                // left join MasterdataSQL.dbo.MstrPerusahaanJPK op on op.ID = a.IDJPK
                // left join MasterdataSQL.dbo.MstrPerusahaanAsuransi opx on opx.ID = a.IDAsuransi
                // left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.StatusID
                // left join MasterdataSQL.dbo.mstrKecamatan xm on xm.kecamatanId = b.Kecamatan
                // left join MasterdataSQL.dbo.mstrKelurahan mx on mx.desaId = b.Kelurahan
                // left join MasterdataSQL.dbo.MstrKabupaten msx on msx.kabupatenId=b.City
                // left join MasterdataSQL.dbo.MstrProvinsi ggg on ggg.PovinsiID = b.[State/Province]
                // --left join MedicalRecord.dbo.MR_Resume_Medis ppx on ppx.No_Registrasi collate  Latin1_General_CS_AS = a.NoRegRI collate  Latin1_General_CS_AS
                // --outer apply (
                // --            select top 1 * from MedicalRecord.dbo.MR_Resume_Medis
                // --            where No_Registrasi  collate  Latin1_General_CS_AS=a.NoRegRI  collate  Latin1_General_CS_AS and No_Episode is not null
                // --            )ppx
                // left join (select No_Registrasi,Diagnosa_Akhir FROM MedicalRecord.dbo.MR_Resume_Medis where No_Episode is not null and
                // replace(CONVERT(VARCHAR(max),Diagnosa_Akhir),char(13)+char(10), '') is not null)
                // ppx on a.NoRegRI collate  Latin1_General_CS_AS=ppx.No_Registrasi collate  Latin1_General_CS_AS
                // where replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') between :tglawal and :tglakhir ) x where totalreg=1";

                $query_master = "SELECT *,replace(CONVERT(VARCHAR(11), StartDate, 111), '/','-') as tglregisx,BL as JenisPasien, Case When StatusID = '0' Then 'New'
            WHEN StatusID = '1' Then 'Invoiced'
            WHEN StatusID = '2' Then 'Payment'
            WHEN StatusID = '3' Then 'Lunas'
            WHEN StatusID = '4' Then 'Close'
            End As 'statusregis',TipeIdCard as 'Tipe_Idcard',NoIdCard as 'ID_Card_number',DateOfBirth as 'Date_of_birth',Sex as Gander, Diagnosa_Awal as A_Diagnosa, doc.First_Name,NamaJaminan as NamaPerusahaan,JenisPerawatan as NamaUnit,'' as AssTriase,IdCaraMasuk as NamaCaraMasuk,IdCaraMasuk2 as NamaCaraMasukRef,'' as tarif, '' as TarifRS,GrandTotal as totalbill,HomePhone as [Home Phone],MobilePhone as [Mobile Phone],'' as Unit,'' as StatusHamil,'' as Gravida,'' as Para,'' as Abortus,'' as HPHT,'' as HPL,'' as UsiaKehamilan,'' as CatatanKehamilan FROM DashboardData.dbo.dataRWI a
            left join MasterDataSQL.dbo.Doctors doc on a.drPenerima= doc.ID
             Where replace(CONVERT(VARCHAR(11), StartDate, 111), '/','-') between :tglawal and :tglakhir";

                // PASIEN ALL
            } elseif ($jenis_info == '4') {
                $query_master = "";

                // PASIEN WALKIN
            } elseif ($jenis_info == '5') {
                $query_master = "SELECT a.*,replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') as tglregisx,BL as 'JenisPasien',TipeIdCard as 'Tipe_Idcard',NoIdCard as 'ID_Card_number',DateOfBirth as 'Date_of_birth',Sex as Gander, Diagnosa_Awal as A_Diagnosa,a.NamaDokter as First_Name,NamaJaminan as NamaPerusahaan,'' as 'AssTriase',NamaCaraMasuk,NamaCaraMasukRef,NamaKarcis as tarif,NilaiKarcis as TarifRS,(isnull(cg.[Total Radiologi],0)+isnull(cg.TotalBHP,0)+isnull(cg.TotalLab,0)+isnull(cg.TotalObat,0)+isnull(cg.TotalVisit,0)) as totalbill,'' as StatusHamil,'' as Gravida,'' as Para,'' as Abortus,'' as HPHT,'' as HPL,'' as UsiaKehamilan,'' as CatatanKehamilan,IdUnit as Unit,HomePhone as [Home Phone],MobilePhone as [Mobile Phone],--'' as statusregis,
                -- '' as tarif,
                 Case When StatusID = '0' Then 'New'
                     WHEN StatusID = '1' Then 'Invoiced'
                     WHEN StatusID = '2' Then 'Payment'
                     WHEN StatusID = '3' Then 'Lunas'
                     WHEN StatusID = '4' Then 'Close'
                     End As 'statusregis'
                  from DashboardData.dbo.dataRWJ a
                  inner join  PerawatanSQL.dbo.View_VisitExtnded cg on cg.NoRegistrasi = a.NoRegistrasi
                  WHERE replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between  :tglawal and :tglakhir AND Batal='0' AND LEFT(a.NoMR,1) = 'W'";
            }
            $orderby = " ORDER BY 1 ASC";

            if ($tp_pasien == '1') { //PRIBADI
                //$query_tambahan = " AND x.TypePatient='UMUM'";
                $query_tambahan = " AND a.TipePasien='1'";
                $query = $query_master . $query_tambahan . $orderby;
                $this->db->query($query);
            } elseif ($tp_pasien == '5') { //Jaminan, Perusahaan
                if ($id_penjamin != null || $id_penjamin != '') { //Perusahaan Filter by ID perusahaan----
                    // if ($jenis_info == '3'){//IF rawat inap
                    //     $whereidperusahaan = " AND a.IDJPK=:id_penjamin";
                    // }else{
                    //     $whereidperusahaan = " AND a.Perusahaan=:id_penjamin";
                    // }
                    //$whereidperusahaan = " AND x.idpenjamin=:id_penjamin";
                    $whereidperusahaan = " AND a.KodeJaminan=:id_penjamin";
                    $query_tambahan = $whereidperusahaan . " AND a.TipePasien='5'";
                    $query = $query_master . $query_tambahan . $orderby;
                    $this->db->query($query);
                    $this->db->bind('id_penjamin', $id_penjamin);
                } else { //Perusahaan ALL----
                    $query_tambahan = " AND a.TipePasien='5'";
                    $query = $query_master . $query_tambahan . $orderby;
                    $this->db->query($query);
                }
            } elseif ($tp_pasien == '2') { //Jaminan, Asuransi
                if ($id_penjamin != null || $id_penjamin != '') { //Asuransi Filter by ID Asuransi---
                    // if ($jenis_info == '3'){//IF rawat inap
                    //     $whereidasuransi = " AND a.IDAsuransi=:id_penjamin";
                    // }else{
                    //     $whereidasuransi = " AND a.Asuransi=:id_penjamin";
                    // }
                    //$whereidasuransi = " AND x.idpenjamin=:id_penjamin";
                    $whereidasuransi = " AND a.KodeJaminan=:id_penjamin";
                    $query_tambahan = $whereidasuransi . " AND a.TipePasien='2'";
                    $query = $query_master . $query_tambahan . $orderby;
                    $this->db->query($query);
                    $this->db->bind('id_penjamin', $id_penjamin);
                } else { //Asuransi ALL----
                    $query_tambahan = " AND a.TipePasien='2'";
                    $query = $query_master . $query_tambahan . $orderby;
                    $this->db->query($query);
                }
            } else { // No Filter
                $query_tambahan = "";
                $query = $query_master . $query_tambahan . $orderby;
                $this->db->query($query);
            }


            // var_dump($query);exit;

            //Binding
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            if (($GrupPerawatan != null || $GrupPerawatan != '') && $jenis_info == '1') {
                $this->db->bind('GrupPerawatan', $GrupPerawatan);
            }

            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $row) {
                $pasing['no'] = $no++;
                $pasing['TglKunjungan'] = date('d-m-Y', strtotime($row['tglregisx']));
                $pasing['NoMR'] = $row['NoMR'];
                $pasing['JenisPasien'] = $row['JenisPasien'];
                $pasing['statusregis'] = $row['statusregis'];
                $pasing['NoRegistrasi'] = $row['NoRegistrasi'];
                $pasing['PatientName'] = $row['PatientName'];
                $pasing['Tipe_Idcard'] = $row['Tipe_Idcard'];
                $pasing['ID_Card_number'] = $row['ID_Card_number'];
                $pasing['Date_of_birth'] = date('d-m-Y', strtotime($row['Date_of_birth']));
                $pasing['Gander'] = $row['Gander'];
                $pasing['NamaUnit'] = $row['NamaUnit'];
                $pasing['A_Diagnosa'] = htmlspecialchars($row['A_Diagnosa'], ENT_QUOTES);
                $pasing['First_Name'] = $row['First_Name'];
                $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                $pasing['Address'] = $row['Address'];
                $pasing['Kelurahan'] = $row['Kelurahan'];
                $pasing['Kecamatan'] = $row['Kecamatan'];
                $pasing['AssTriase'] = $row['AssTriase'];

                $pasing['kabupatenNama'] = $row['kabupatenNama'];
                $pasing['ProvinsiNama'] = $row['ProvinsiNama'];
                $pasing['NamaCaraMasuk'] = $row['NamaCaraMasuk'];
                $pasing['NamaCaraMasukRef'] = $row['NamaCaraMasukRef'];

                $pasing['tarif'] = $row['tarif'];
                $pasing['TarifRS'] = $row['TarifRS'];
                $pasing['totalbill'] = $row['totalbill'];

                $pasing['HomePhone'] = $row['Home Phone'];
                $pasing['MobilePhone'] = $row['Mobile Phone'];

                //obgyn-------StatusHamil,Gravida,Para,Abortus,HPHT,HPL,UsiaKehamilan,CatatanKehamilan
                $pasing['Unit'] = $row['Unit'];
                $pasing['StatusHamil'] = $row['StatusHamil'];
                $pasing['Gravida'] = $row['Gravida'];
                $pasing['Para'] = $row['Para'];
                $pasing['Abortus'] = $row['Abortus'];
                $pasing['HPHT'] = $row['HPHT'];
                $pasing['HPL'] = $row['HPL'];
                $pasing['UsiaKehamilan'] = $row['UsiaKehamilan'];
                $pasing['CatatanKehamilan'] = $row['CatatanKehamilan'];
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
            $GrupPerawatan = $data['GrupPerawatan'];

            //PASIEN RAWAT JALAN DAN IGD
            if ($jenis_info == '1') {
                //     $query_master1 = "SELECT * from (SELECT ROW_NUMBER()Over(partition by a.NoRegistrasi order by a.NoRegistrasi) as totalreg,a.TglKunjungan,a.NoMR,a.NoRegistrasi,b.PatientName, b.Tipe_Idcard, b.ID_Card_number,
                //     replace(CONVERT(VARCHAR(11), b.Date_of_birth, 111), '/','-') as Date_of_birth,
                //                  b.Gander,a.Unit,pg.NamaUnit,a.[Status ID],pg.ID as 'IDUNIT',
                //                 c.First_Name,d.TypePatient,b.Address ,
                //                 case when d.ID='2' then opx.NamaPerusahaan
                //                  when d.ID='5' then op.NamaPerusahaan
                //                 else 'UMUM' end AS NamaPerusahaan  , hh.NamaCaraMasuk,hj.NamaCaraMasukRef,
                //                 --jk.[Product Name] as tarif,jk.TarifRS,
                //                 replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglregisx,
                //                 replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-') as tglregis,
                //                 case 
                //                 when replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') > replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-')
                //                 then 'Lama'  ELSE 'Baru'
                //                 end as 'JenisPasien' 
                //                 ,co.[Status Name] as statusregis,(isnull(cg.[Total Radiologi],0)+isnull(cg.TotalBHP,0)+isnull(cg.TotalLab,0)+isnull(cg.TotalObat,0)+isnull(cg.TotalVisit,0)) as totalbill
                //                 ,xm.Kecamatan,mx.Kelurahan,msx.kabupatenNama,ggg.ProvinsiNama,'' as AssTriase,ttv.StatusHamil,ttv.Gravida,ttv.Para,ttv.Abortus,replace(CONVERT(VARCHAR(11), ttv.HPHT, 111), '/','-') as HPHT,replace(CONVERT(VARCHAR(11), ttv.HPL, 111), '/','-') as HPL,ttv.UsiaKehamilan,ttv.CatatanKehamilan,replace(CONVERT(VARCHAR(max),kkl.A_Diagnosa),char(13)+char(10), '') as A_Diagnosa,b.[Home Phone],b.[Mobile Phone],admx.Nama_Karcis as 'tarif',admx.Nilai_Karcis as 'TarifRS',
                //                 case when d.ID='2' then opx.ID
                //                 else op.ID end AS idpenjamin 
                //                 from PerawatanSQL.dbo.Visit a
                //                 inner join MasterdataSQL.dbo.Admision b
                //                 on a.NoMR = b.NoMR
                //                 inner join MasterdataSQL.dbo.Doctors c
                //                 on c.ID = a.Doctor_1
                //                 inner join MasterdataSQL.dbo.MstrTypePatient d
                //                 on d.ID = a.PatientType 
                //                 left join MasterdataSQL.dbo.MstrPerusahaanJPK op on op.ID = a.Perusahaan
                //                 left join MasterdataSQL.dbo.MstrPerusahaanAsuransi opx on opx.ID = a.Asuransi
                //                 inner join MasterdataSQL.dbo.MstrUnitPerwatan pg on pg.ID = a.Unit
                //                 left join MasterdataSQL.dbo.MstrCaraMasuk hh on hh.id = a.idCaraMasuk
                //                 left join MasterdataSQL.dbo.MstrCaraMasuk_2 hj on hj.id = a.idCaraMasuk2
                //                 left join PerawatanSQL.dbo.Tarif_RJ_UGD jk on jk.ID = a.idAdmin
                //                 inner join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.[Status ID]
                //                 inner join  PerawatanSQL.dbo.View_VisitExtnded cg on cg.NoRegistrasi = a.NoRegistrasi
                //                -- left join MedicalRecord.dbo.EMR_RWJ kkl on kkl.NoRegistrasi  collate  Latin1_General_CS_AS = a.NoRegistrasi  collate  Latin1_General_CS_AS
                //                 inner join MasterdataSQL.dbo.mstrKecamatan xm on xm.kecamatanId = b.Kecamatan
                //                 inner join MasterdataSQL.dbo.mstrKelurahan mx on mx.desaId = b.Kelurahan
                //                 inner join MasterdataSQL.dbo.MstrKabupaten msx on msx.kabupatenId=b.City
                //                 inner join MasterdataSQL.dbo.MstrProvinsi ggg on ggg.PovinsiID = b.[State/Province]
                //         --            outer apply (
                //         --                SELECT TOP 1 NoRegistrasi,A_Diagnosa
                //         --from MedicalRecord.dbo.EMR_RWJ where NoRegistrasi collate Latin1_General_CS_AS=a.NoRegistrasi collate Latin1_General_CS_AS and YgMelapor is null
                //         --                ) kkl
                // 		left join (select NoRegistrasi,A_Diagnosa from MedicalRecord.dbo.EMR_RWJ where YgMelapor is null ) kkl on a.NoRegistrasi collate SQL_Latin1_General_CP1_CI_AS=kkl.NoRegistrasi collate SQL_Latin1_General_CP1_CI_AS
                // --                outer apply
                // --(SELECT top 1 NoRegistrasi,StatusHamil,Gravida,Para,Abortus,HPHT,HPL,UsiaKehamilan,CatatanKehamilan
                // --from MedicalRecord.dbo.EMR_RWJ_TTV where NoRegistrasi collate Latin1_General_CS_AS=a.NoRegistrasi collate Latin1_General_CS_AS and NamaUser is not null)ttv
                // left join (select NoRegistrasi,StatusHamil,Gravida,Para,Abortus,HPHT,HPL,UsiaKehamilan,CatatanKehamilan from MedicalRecord.dbo.EMR_RWJ_TTV where NamaUser is not null) 
                // ttv on a.NoRegistrasi collate SQL_Latin1_General_CP1_CI_AS=ttv.NoRegistrasi collate SQL_Latin1_General_CP1_CI_AS
                // left join MasterdataSQL.dbo.MstrKarcisAdministrasi admx on a.idAdmin=admx.ID
                //                 where replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') between  :tglawal and :tglakhir AND pg.grup_instalasi in ('RAWAT JALAN','PENUNJANG','IGD')
                //                 and a.Batal='0' )x where totalreg=1 ";
                $query_master1 = "SELECT *,replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') as tglregisx,BL as 'JenisPasien',TipeIdCard as 'Tipe_Idcard',NoIdCard as 'ID_Card_number',DateOfBirth as 'Date_of_birth',Sex as Gander, Diagnosa_Awal as A_Diagnosa,a.NamaDokter as First_Name,NamaJaminan as NamaPerusahaan,'' as 'AssTriase',NamaCaraMasuk,NamaCaraMasukRef,NamaKarcis as tarif,NilaiKarcis as TarifRS,(isnull(cg.[Total Radiologi],0)+isnull(cg.TotalBHP,0)+isnull(cg.TotalLab,0)+isnull(cg.TotalObat,0)+isnull(cg.TotalVisit,0)) as totalbill,'' as StatusHamil,'' as Gravida,'' as Para,'' as Abortus,'' as HPHT,'' as HPL,'' as UsiaKehamilan,'' as CatatanKehamilan,IdUnit as Unit,HomePhone as [Home Phone],MobilePhone as [Mobile Phone],--'' as statusregis,
           -- '' as tarif,
            Case When StatusID = '0' Then 'New'
                WHEN StatusID = '1' Then 'Invoiced'
                WHEN StatusID = '2' Then 'Payment'
                WHEN StatusID = '3' Then 'Lunas'
                WHEN StatusID = '4' Then 'Close'
                End As 'statusregis'
             from DashboardData.dbo.dataRWJ a
             inner join  PerawatanSQL.dbo.View_VisitExtnded cg on cg.NoRegistrasi = a.NoRegistrasi
             WHERE replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between  :tglawal and :tglakhir AND Batal='0' AND LEFT(a.NoMR,1) <> 'W'";
                if ($GrupPerawatan != null || $GrupPerawatan != '') {
                    //$where = " AND x.IDUNIT=:GrupPerawatan";
                    $where = " AND IdUnit=:GrupPerawatan";
                } else {
                    $where = "";
                }
                $query_master = $query_master1 . $where . " ";

                // PASIEN RAWAT INAP
            } elseif ($jenis_info == '3') {
                // $query_master = "SELECT * FROM (SELECT ROW_NUMBER()Over(partition by a.NoRegRI order by a.NoRegRI) as totalreg, a.StartDate as TglKunjungan,a.NoMR,a.NoRegRI as NoRegistrasi,b.PatientName, b.Tipe_Idcard, b.ID_Card_number,
                // replace(CONVERT(VARCHAR(11), b.Date_of_birth, 111), '/','-') as Date_of_birth,
                // b.Gander,a.JenisRawat as NamaUnit, 
                // c.First_Name,d.TypePatient,b.Address ,
                // case when d.ID='2' then opx.NamaPerusahaan
                // when d.ID='5' then op.NamaPerusahaan
                // else 'UMUM' end AS NamaPerusahaan
                // ,co.[Status Name] as statusregis,
                // replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as tglregisx,
                // replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-') as tglregis,
                // case 
                // when replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') > replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-')
                // then 'Lama'  ELSE 'Baru'
                // end as 'JenisPasien', '' as NamaCaraMasuk,'' as NamaCaraMasukRef,'' as tarif,'' as TarifRS,'0' AS  totalbill,
                // xm.Kecamatan,mx.Kelurahan,msx.kabupatenNama,ggg.ProvinsiNama,replace(CONVERT(VARCHAR(max),ppx.Diagnosa_Akhir),char(13)+char(10), '') as A_Diagnosa,'' as AssTriase,'' as StatusHamil,'' as Gravida,'' as Para,'' as Abortus,'' as HPHT,'' as HPL,'' as UsiaKehamilan,'' as CatatanKehamilan,'' as Unit,b.[Home Phone],b.[Mobile Phone],
                // case when d.ID='2' then opx.ID
                //                 else op.ID end AS idpenjamin 
                // from RawatInapSQL.dbo.Inpatient a
                // inner join MasterdataSQL.dbo.Admision b
                // on a.NoMR = b.NoMR
                // inner join MasterdataSQL.dbo.Doctors c
                // on c.ID = a.drPenerima
                // inner join MasterdataSQL.dbo.MstrTypePatient d
                // on d.ID = a.TypePatient 
                // left join MasterdataSQL.dbo.MstrPerusahaanJPK op on op.ID = a.IDJPK
                // left join MasterdataSQL.dbo.MstrPerusahaanAsuransi opx on opx.ID = a.IDAsuransi
                // left join PerawatanSQL.dbo.[Visit Status] co on co.[Status ID] = a.StatusID
                // left join MasterdataSQL.dbo.mstrKecamatan xm on xm.kecamatanId = b.Kecamatan
                // left join MasterdataSQL.dbo.mstrKelurahan mx on mx.desaId = b.Kelurahan
                // left join MasterdataSQL.dbo.MstrKabupaten msx on msx.kabupatenId=b.City
                // left join MasterdataSQL.dbo.MstrProvinsi ggg on ggg.PovinsiID = b.[State/Province]
                // --left join MedicalRecord.dbo.MR_Resume_Medis ppx on ppx.No_Registrasi collate  Latin1_General_CS_AS = a.NoRegRI collate  Latin1_General_CS_AS
                // --outer apply (
                // --            select top 1 * from MedicalRecord.dbo.MR_Resume_Medis
                // --            where No_Registrasi  collate  Latin1_General_CS_AS=a.NoRegRI  collate  Latin1_General_CS_AS and No_Episode is not null
                // --            )ppx
                // left join (select No_Registrasi,Diagnosa_Akhir FROM MedicalRecord.dbo.MR_Resume_Medis where No_Episode is not null and
                // replace(CONVERT(VARCHAR(max),Diagnosa_Akhir),char(13)+char(10), '') is not null)
                // ppx on a.NoRegRI collate  Latin1_General_CS_AS=ppx.No_Registrasi collate  Latin1_General_CS_AS
                // where replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') between :tglawal and :tglakhir ) x where totalreg=1";

                $query_master = "SELECT *,replace(CONVERT(VARCHAR(11), StartDate, 111), '/','-') as tglregisx,BL as JenisPasien, Case When StatusID = '0' Then 'New'
            WHEN StatusID = '1' Then 'Invoiced'
            WHEN StatusID = '2' Then 'Payment'
            WHEN StatusID = '3' Then 'Lunas'
            WHEN StatusID = '4' Then 'Close'
            End As 'statusregis',TipeIdCard as 'Tipe_Idcard',NoIdCard as 'ID_Card_number',DateOfBirth as 'Date_of_birth',Sex as Gander, Diagnosa_Awal as A_Diagnosa, doc.First_Name,NamaJaminan as NamaPerusahaan,JenisPerawatan as NamaUnit,'' as AssTriase,IdCaraMasuk as NamaCaraMasuk,IdCaraMasuk2 as NamaCaraMasukRef,'' as tarif, '' as TarifRS,GrandTotal as totalbill,HomePhone as [Home Phone],MobilePhone as [Mobile Phone],'' as Unit,'' as StatusHamil,'' as Gravida,'' as Para,'' as Abortus,'' as HPHT,'' as HPL,'' as UsiaKehamilan,'' as CatatanKehamilan FROM DashboardData.dbo.dataRWI a
            left join MasterDataSQL.dbo.Doctors doc on a.drPenerima= doc.ID
             Where replace(CONVERT(VARCHAR(11), StartDate, 111), '/','-') between :tglawal and :tglakhir";

                // PASIEN ALL
            } elseif ($jenis_info == '4') {
                $query_master = "";

                // PASIEN WALKIN
            } elseif ($jenis_info == '5') {
                $query_master = "SELECT a.*,replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') as tglregisx,BL as 'JenisPasien',TipeIdCard as 'Tipe_Idcard',NoIdCard as 'ID_Card_number',DateOfBirth as 'Date_of_birth',Sex as Gander, Diagnosa_Awal as A_Diagnosa,a.NamaDokter as First_Name,NamaJaminan as NamaPerusahaan,'' as 'AssTriase',NamaCaraMasuk,NamaCaraMasukRef,NamaKarcis as tarif,NilaiKarcis as TarifRS,(isnull(cg.[Total Radiologi],0)+isnull(cg.TotalBHP,0)+isnull(cg.TotalLab,0)+isnull(cg.TotalObat,0)+isnull(cg.TotalVisit,0)) as totalbill,'' as StatusHamil,'' as Gravida,'' as Para,'' as Abortus,'' as HPHT,'' as HPL,'' as UsiaKehamilan,'' as CatatanKehamilan,IdUnit as Unit,HomePhone as [Home Phone],MobilePhone as [Mobile Phone],--'' as statusregis,
                -- '' as tarif,
                 Case When StatusID = '0' Then 'New'
                     WHEN StatusID = '1' Then 'Invoiced'
                     WHEN StatusID = '2' Then 'Payment'
                     WHEN StatusID = '3' Then 'Lunas'
                     WHEN StatusID = '4' Then 'Close'
                     End As 'statusregis'
                  from DashboardData.dbo.dataRWJ a
                  inner join  PerawatanSQL.dbo.View_VisitExtnded cg on cg.NoRegistrasi = a.NoRegistrasi
                  WHERE replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') between  :tglawal and :tglakhir AND Batal='0' AND LEFT(a.NoMR,1) = 'W'";
            }
            $orderby = " ORDER BY 1 ASC";

            if ($tp_pasien == '1') { //PRIBADI
                //$query_tambahan = " AND x.TypePatient='UMUM'";
                $query_tambahan = " AND a.TipePasien='1'";
                $query = $query_master . $query_tambahan . $orderby;
                $this->db->query($query);
            } elseif ($tp_pasien == '5') { //Jaminan, Perusahaan
                if ($id_penjamin != null || $id_penjamin != '') { //Perusahaan Filter by ID perusahaan----
                    // if ($jenis_info == '3'){//IF rawat inap
                    //     $whereidperusahaan = " AND a.IDJPK=:id_penjamin";
                    // }else{
                    //     $whereidperusahaan = " AND a.Perusahaan=:id_penjamin";
                    // }
                    //$whereidperusahaan = " AND x.idpenjamin=:id_penjamin";
                    $whereidperusahaan = " AND a.KodeJaminan=:id_penjamin";
                    $query_tambahan = $whereidperusahaan . " AND a.TipePasien='5'";
                    $query = $query_master . $query_tambahan . $orderby;
                    $this->db->query($query);
                    $this->db->bind('id_penjamin', $id_penjamin);
                } else { //Perusahaan ALL----
                    $query_tambahan = " AND a.TipePasien='5'";
                    $query = $query_master . $query_tambahan . $orderby;
                    $this->db->query($query);
                }
            } elseif ($tp_pasien == '2') { //Jaminan, Asuransi
                if ($id_penjamin != null || $id_penjamin != '') { //Asuransi Filter by ID Asuransi---
                    // if ($jenis_info == '3'){//IF rawat inap
                    //     $whereidasuransi = " AND a.IDAsuransi=:id_penjamin";
                    // }else{
                    //     $whereidasuransi = " AND a.Asuransi=:id_penjamin";
                    // }
                    //$whereidasuransi = " AND x.idpenjamin=:id_penjamin";
                    $whereidasuransi = " AND a.KodeJaminan=:id_penjamin";
                    $query_tambahan = $whereidasuransi . " AND a.TipePasien='2'";
                    $query = $query_master . $query_tambahan . $orderby;
                    $this->db->query($query);
                    $this->db->bind('id_penjamin', $id_penjamin);
                } else { //Asuransi ALL----
                    $query_tambahan = " AND a.TipePasien='2'";
                    $query = $query_master . $query_tambahan . $orderby;
                    $this->db->query($query);
                }
            } else { // No Filter
                $query_tambahan = "";
                $query = $query_master . $query_tambahan . $orderby;
                $this->db->query($query);
            }


            // var_dump($query);exit;

            //Binding
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            if (($GrupPerawatan != null || $GrupPerawatan != '') && $jenis_info == '1') {
                $this->db->bind('GrupPerawatan', $GrupPerawatan);
            }

            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $row) {
                $pasing['no'] = $no++;
                $pasing['TglKunjungan'] = date('d-m-Y', strtotime($row['tglregisx']));
                $pasing['NoMR'] = $row['NoMR'];
                $pasing['JenisPasien'] = $row['JenisPasien'];
                $pasing['statusregis'] = $row['statusregis'];
                $pasing['NoRegistrasi'] = $row['NoRegistrasi'];
                $pasing['PatientName'] = $row['PatientName'];
                $pasing['Tipe_Idcard'] = $row['Tipe_Idcard'];
                $pasing['ID_Card_number'] = $row['ID_Card_number'];
                $pasing['Date_of_birth'] = date('d-m-Y', strtotime($row['Date_of_birth']));
                $pasing['Gander'] = $row['Gander'];
                $pasing['NamaUnit'] = $row['NamaUnit'];
                $pasing['A_Diagnosa'] = htmlspecialchars($row['A_Diagnosa'], ENT_QUOTES);
                $pasing['First_Name'] = $row['First_Name'];
                $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                $pasing['Address'] = $row['Address'];
                $pasing['Kelurahan'] = $row['Kelurahan'];
                $pasing['Kecamatan'] = $row['Kecamatan'];
                $pasing['AssTriase'] = $row['AssTriase'];

                $pasing['kabupatenNama'] = $row['kabupatenNama'];
                $pasing['ProvinsiNama'] = $row['ProvinsiNama'];
                $pasing['NamaCaraMasuk'] = $row['NamaCaraMasuk'];
                $pasing['NamaCaraMasukRef'] = $row['NamaCaraMasukRef'];

                $pasing['tarif'] = $row['tarif'];
                $pasing['TarifRS'] = $row['TarifRS'];
                $pasing['totalbill'] = $row['totalbill'];

                $pasing['HomePhone'] = $row['Home Phone'];
                $pasing['MobilePhone'] = $row['Mobile Phone'];

                //obgyn-------StatusHamil,Gravida,Para,Abortus,HPHT,HPL,UsiaKehamilan,CatatanKehamilan
                $pasing['Unit'] = $row['Unit'];
                $pasing['StatusHamil'] = $row['StatusHamil'];
                $pasing['Gravida'] = $row['Gravida'];
                $pasing['Para'] = $row['Para'];
                $pasing['Abortus'] = $row['Abortus'];
                $pasing['HPHT'] = $row['HPHT'];
                $pasing['HPL'] = $row['HPL'];
                $pasing['UsiaKehamilan'] = $row['UsiaKehamilan'];
                $pasing['CatatanKehamilan'] = $row['CatatanKehamilan'];
                $rows[] = $pasing;
            }
            return $data;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
