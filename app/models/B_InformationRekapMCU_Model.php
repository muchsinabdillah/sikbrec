<?php
class  B_InformationRekapMCU_Model
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
            $tp_pasien = $data['TipePenjamin'];
            $id_penjamin = $data['NamaPenjamin'];
            //var_dump($tp_pasien);exit;

            if ($tp_pasien === "1") { //
                $tsql = "SELECT replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as Tgl,b.PatientName,
           b.Gander,DATEDIFF(yy, b.Date_of_birth, GETDATE()) as UMUR,a.noregistrasi,
           c.TB  as PemfisikTB,c.BB  as PemfisikBB,c.KondisiNutrisi  as PemfisikKondisiNutrisi,c.BMI  as PemfisikBMI,c.KetBMI as PemfisikKetBMI,
           d.pfk_usg as UsgAbdomen, d.PFK_Radiologi as Rontgen_Thorax,d.PFK_Audiometri as Audiometri,
           d.PFK_Lab as Laboratorium,e.A as PenyakitDalam,f.A as Bedah, d.Saran as AnjuranKonsulKe,
           d.PFK_EKG as EKG, d.PFK_Treadmill as Treadmill,g.Kesimpulan as KesimpulanMata,h.kesimpulan as kesimpulantht,j.Kesimpulan as kesimpulansyaraf,d.DiagnosaKerja
           ,CASE WHEN d.KetKesehatan ='Kesehatan Baik' THEN 'A'
WHEN d.KetKesehatan ='Kesehatan Cukup Baik dengan Kelainan yang dapat dipulihkan' THEN 'B'
WHEN d.KetKesehatan ='Kesehatan Baik dengan Kelainan yang dapat dipulihkan' THEN 'B'
WHEN d.KetKesehatan ='Kemampuan Fisik terbatas untuk pekerjaan tertentu' THEN 'C'
WHEN d.KetKesehatan ='Tidak Fit tidak aman untuk semua pekerjaan' THEN 'D'
WHEN d.KetKesehatan ='Tidak Sehat/tidak Layak Penempatan' THEN 'E' END AS KetKesehatan,d.KetKesehatan as kategorikesehatan,d.PFK_Spirometri as Spirometri
           FROM PerawatanSQL.dbo.Visit a
           inner join MasterdataSQL.dbo.Admision b
           on a.NoMR = b.NoMR
           inner join MedicalRecord.DBO.MR_ASSM_MCU  c on c.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
           left join MedicalRecord.DBO.MR_ASS_MCU2 d on d.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
           left join MedicalRecord.DBO.MR_MCU_PenyakitDalam e on e.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
           left join MedicalRecord.DBO.MR_MCU_Bedah f on f.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
           left join MedicalRecord.DBO.MR_MCU_MATA g on g.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
           left join MedicalRecord.DBO.MR_MCU_THT h on h.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
           left join MedicalRecord.dbo.MR_MCU_Syaraf j on j.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS
           inner join MasterdataSQL.dbo.MstrTypePatient i
                       on i.ID = a.PatientType 
           where 
           replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') between :tglawal and :tglakhir
           and a.Unit='53' and a.Batal='0'   and i.TypePatient='UMUM'  ";
                $this->db->query($tsql);
            } elseif ($tp_pasien === "5") { //rajal,jaminan,Perusahaan
                $tsql = "SELECT replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as Tgl,b.PatientName,
           b.Gander,DATEDIFF(yy, b.Date_of_birth, GETDATE()) as UMUR,a.noregistrasi,
           c.TB  as PemfisikTB,c.BB  as PemfisikBB,c.KondisiNutrisi  as PemfisikKondisiNutrisi,c.BMI  as PemfisikBMI,c.KetBMI as PemfisikKetBMI,
           d.pfk_usg as UsgAbdomen, d.PFK_Radiologi as Rontgen_Thorax,d.PFK_Audiometri as Audiometri,
           d.PFK_Lab as Laboratorium,e.A as PenyakitDalam,f.A as Bedah, d.Saran as AnjuranKonsulKe,
           d.PFK_EKG as EKG, d.PFK_Treadmill as Treadmill,g.Kesimpulan as KesimpulanMata,h.kesimpulan as kesimpulantht,j.Kesimpulan as kesimpulansyaraf,d.DiagnosaKerja
           ,CASE WHEN d.KetKesehatan ='Kesehatan Baik' THEN 'A'
WHEN d.KetKesehatan ='Kesehatan Cukup Baik dengan Kelainan yang dapat dipulihkan' THEN 'B'
WHEN d.KetKesehatan ='Kesehatan Baik dengan Kelainan yang dapat dipulihkan' THEN 'B'
WHEN d.KetKesehatan ='Kemampuan Fisik terbatas untuk pekerjaan tertentu' THEN 'C'
WHEN d.KetKesehatan ='Tidak Fit tidak aman untuk semua pekerjaan' THEN 'D'
WHEN d.KetKesehatan ='Tidak Sehat/tidak Layak Penempatan' THEN 'E' END AS KetKesehatan,d.KetKesehatan as kategorikesehatan,d.PFK_Spirometri as Spirometri
           FROM PerawatanSQL.dbo.Visit a
           inner join MasterdataSQL.dbo.Admision b
           on a.NoMR = b.NoMR
           inner join MedicalRecord.DBO.MR_ASSM_MCU  c on c.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
           left join MedicalRecord.DBO.MR_ASS_MCU2 d on d.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
           left join MedicalRecord.DBO.MR_MCU_PenyakitDalam e on e.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
           left join MedicalRecord.DBO.MR_MCU_Bedah f on f.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
           left join MedicalRecord.DBO.MR_MCU_MATA g on g.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
           left join MedicalRecord.DBO.MR_MCU_THT h on h.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
           inner join MasterdataSQL.dbo.MstrTypePatient i
                       on i.ID = a.PatientType 
           inner join MasterdataSQL.dbo.MstrPerusahaanJPK op on op.ID = a.Perusahaan
           left join MedicalRecord.dbo.MR_MCU_Syaraf j on j.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS
           where 
           replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') between   :tglawal and :tglakhir
           and a.Unit='53' and a.Batal='0'     and a.Perusahaan=:id_penjamin";
                $this->db->query($tsql);
                $this->db->bind('id_penjamin', $id_penjamin);
            } elseif ($tp_pasien === "2") { //rajal,jaminan,asuransi
                $tsql = "SELECT replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as Tgl,b.PatientName,
           b.Gander,DATEDIFF(yy, b.Date_of_birth, GETDATE()) as UMUR,a.noregistrasi,
           c.TB  as PemfisikTB,c.BB  as PemfisikBB,c.KondisiNutrisi  as PemfisikKondisiNutrisi,c.BMI  as PemfisikBMI,c.KetBMI as PemfisikKetBMI,
           d.pfk_usg as UsgAbdomen, d.PFK_Radiologi as Rontgen_Thorax,d.PFK_Audiometri as Audiometri,
           d.PFK_Lab as Laboratorium,e.A as PenyakitDalam,f.A as Bedah, d.Saran as AnjuranKonsulKe,
           d.PFK_EKG as EKG, d.PFK_Treadmill as Treadmill,g.Kesimpulan as KesimpulanMata,h.kesimpulan as kesimpulantht,j.Kesimpulan as kesimpulansyaraf,d.DiagnosaKerja
           ,CASE WHEN d.KetKesehatan ='Kesehatan Baik' THEN 'A'
WHEN d.KetKesehatan ='Kesehatan Cukup Baik dengan Kelainan yang dapat dipulihkan' THEN 'B'
WHEN d.KetKesehatan ='Kesehatan Baik dengan Kelainan yang dapat dipulihkan' THEN 'B'
WHEN d.KetKesehatan ='Kemampuan Fisik terbatas untuk pekerjaan tertentu' THEN 'C'
WHEN d.KetKesehatan ='Tidak Fit tidak aman untuk semua pekerjaan' THEN 'D'
WHEN d.KetKesehatan ='Tidak Sehat/tidak Layak Penempatan' THEN 'E' END AS KetKesehatan,d.KetKesehatan as kategorikesehatan,d.PFK_Spirometri as Spirometri
           FROM PerawatanSQL.dbo.Visit a
           inner join MasterdataSQL.dbo.Admision b
           on a.NoMR = b.NoMR
           inner join MedicalRecord.DBO.MR_ASSM_MCU  c on c.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
           left join MedicalRecord.DBO.MR_ASS_MCU2 d on d.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
           left join MedicalRecord.DBO.MR_MCU_PenyakitDalam e on e.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
           left join MedicalRecord.DBO.MR_MCU_Bedah f on f.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
           left join MedicalRecord.DBO.MR_MCU_MATA g on g.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
           left join MedicalRecord.DBO.MR_MCU_THT h on h.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
           inner join MasterdataSQL.dbo.MstrTypePatient i
                       on i.ID = a.PatientType 
           inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi op on op.ID = a.Asuransi
           left join MedicalRecord.dbo.MR_MCU_Syaraf j on j.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS
           where 
           replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') between  :tglawal and :tglakhir
           and a.Unit='53' and a.Batal='0'    and a.Asuransi=:id_penjamin";
                $this->db->query($tsql);
                $this->db->bind('id_penjamin', $id_penjamin);
            } else {
                $tsql = "SELECT replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as Tgl,b.PatientName,
            b.Gander,DATEDIFF(yy, b.Date_of_birth, GETDATE()) as UMUR,a.noregistrasi,
            c.TB  as PemfisikTB,c.BB  as PemfisikBB,c.KondisiNutrisi  as PemfisikKondisiNutrisi,c.BMI  as PemfisikBMI,c.KetBMI as PemfisikKetBMI,
            d.pfk_usg as UsgAbdomen, d.PFK_Radiologi as Rontgen_Thorax,d.PFK_Audiometri as Audiometri,
            d.PFK_Lab as Laboratorium,e.A as PenyakitDalam,f.A as Bedah, d.Saran as AnjuranKonsulKe,
            d.PFK_EKG as EKG, d.PFK_Treadmill as Treadmill,g.Kesimpulan as KesimpulanMata,h.kesimpulan as kesimpulantht,j.Kesimpulan as kesimpulansyaraf,d.DiagnosaKerja
            ,CASE WHEN d.KetKesehatan ='Kesehatan Baik' THEN 'A'
 WHEN d.KetKesehatan ='Kesehatan Cukup Baik dengan Kelainan yang dapat dipulihkan' THEN 'B'
WHEN d.KetKesehatan ='Kesehatan Baik dengan Kelainan yang dapat dipulihkan' THEN 'B'
 WHEN d.KetKesehatan ='Kemampuan Fisik terbatas untuk pekerjaan tertentu' THEN 'C'
 WHEN d.KetKesehatan ='Tidak Fit tidak aman untuk semua pekerjaan' THEN 'D'
 WHEN d.KetKesehatan ='Tidak Sehat/tidak Layak Penempatan' THEN 'E' END AS KetKesehatan,d.KetKesehatan as kategorikesehatan,d.PFK_Spirometri as Spirometri
            FROM PerawatanSQL.dbo.Visit a
            inner join MasterdataSQL.dbo.Admision b
            on a.NoMR = b.NoMR
            inner join MedicalRecord.DBO.MR_ASSM_MCU  c on c.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
            left join MedicalRecord.DBO.MR_ASS_MCU2 d on d.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
            left join MedicalRecord.DBO.MR_MCU_PenyakitDalam e on e.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
            left join MedicalRecord.DBO.MR_MCU_Bedah f on f.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
            left join MedicalRecord.DBO.MR_MCU_MATA g on g.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
            left join MedicalRecord.DBO.MR_MCU_THT h on h.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
            left join MedicalRecord.dbo.MR_MCU_Syaraf j on j.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS
            inner join MasterdataSQL.dbo.MstrTypePatient i
                        on i.ID = a.PatientType 
            where 
            replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') between :tglawal and :tglakhir
            and a.Unit='53' and a.Batal='0'   ";
                $this->db->query($tsql);
            }

            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $row) {
                $pasing['no'] = $no++;
                $pasing['tgl'] = date('d-m-Y', strtotime($row['Tgl']));
                $pasing['PatientName'] = $row['PatientName'];
                $pasing['Gander'] = $row['Gander'];
                $pasing['UMUR'] = $row['UMUR'];
                $pasing['PemfisikTB'] = $row['PemfisikTB'] . ' Cm';
                $pasing['PemfisikBB'] = $row['PemfisikBB'] . ' Kg';

                $pasing['Kelainan'] = '1. Fisik - Kondisi Nutrisi :  ' . $row['PemfisikKondisiNutrisi'] . ' - BMI :  ' . $row['PemfisikBMI'] . ' - Ket BMI : ' . $row['PemfisikKetBMI'] . ' <br> 2. Rontgen Thorax : ' . $row['Rontgen_Thorax'] . '<br> 3. USG Abdomen : ' . $row['UsgAbdomen'] . '<br> 4. Audiometri : ' . $row['Audiometri'] . '<br> 5. Laboratorium : ' . $row['Laboratorium'] . '<br> 6. Jantung - EKG : ' . $row['EKG'] . ' - Treadmill : ' . $row['Treadmill'] . ' <br> 7. Mata : ' . $row['KesimpulanMata'] . '<br> 8. THT : ' . $row['kesimpulantht'] . '<br> 9. Penyakit Dalam : ' . $row['PenyakitDalam'] . '<br> 10. Bedah : ' . $row['Bedah'] . '<br> 11. Syaraf : ' . $row['kesimpulansyaraf'] . '<br> 12. Ginekologi :' . '<br> 13. Spirometri : ' . $row['Spirometri'];
                $pasing['DiagnosaKerja'] = $row['DiagnosaKerja'];
                $pasing['AnjuranKonsulKe'] = $row['AnjuranKonsulKe'];
                $pasing['KetKesehatan'] = $row['KetKesehatan'];
                $pasing['kategorikesehatan'] = $row['kategorikesehatan'];
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
            $tp_pasien = $data['TipePenjamin'];
            $id_penjamin = $data['NamaPenjamin'];
            //var_dump($tp_pasien);exit;

            if ($tp_pasien === "1") { //
                $tsql = "SELECT replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as Tgl,b.PatientName,
                b.Gander,DATEDIFF(yy, b.Date_of_birth, GETDATE()) as UMUR,a.noregistrasi,
                c.TB  as PemfisikTB,c.BB  as PemfisikBB,c.KondisiNutrisi  as PemfisikKondisiNutrisi,c.BMI  as PemfisikBMI,c.KetBMI as PemfisikKetBMI,
                d.pfk_usg as UsgAbdomen, d.PFK_Radiologi as Rontgen_Thorax,d.PFK_Audiometri as Audiometri,
                d.PFK_Lab as Laboratorium,e.A as PenyakitDalam,f.A as Bedah, d.Saran as AnjuranKonsulKe,
                d.PFK_EKG as EKG, d.PFK_Treadmill as Treadmill,g.Kesimpulan as KesimpulanMata,h.kesimpulan as kesimpulantht,j.Kesimpulan as kesimpulansyaraf,d.DiagnosaKerja
                ,CASE WHEN d.KetKesehatan ='Kesehatan Baik' THEN 'A'
     WHEN d.KetKesehatan ='Kesehatan Cukup Baik dengan Kelainan yang dapat dipulihkan' THEN 'B'
     WHEN d.KetKesehatan ='Kesehatan Baik dengan Kelainan yang dapat dipulihkan' THEN 'B'
     WHEN d.KetKesehatan ='Kemampuan Fisik terbatas untuk pekerjaan tertentu' THEN 'C'
     WHEN d.KetKesehatan ='Tidak Fit tidak aman untuk semua pekerjaan' THEN 'D'
     WHEN d.KetKesehatan ='Tidak Sehat/tidak Layak Penempatan' THEN 'E' END AS KetKesehatan,d.KetKesehatan as kategorikesehatan,d.PFK_Spirometri as Spirometri
                FROM PerawatanSQL.dbo.Visit a
                inner join MasterdataSQL.dbo.Admision b
                on a.NoMR = b.NoMR
                inner join MedicalRecord.DBO.MR_ASSM_MCU  c on c.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
                left join MedicalRecord.DBO.MR_ASS_MCU2 d on d.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
                left join MedicalRecord.DBO.MR_MCU_PenyakitDalam e on e.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
                left join MedicalRecord.DBO.MR_MCU_Bedah f on f.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
                left join MedicalRecord.DBO.MR_MCU_MATA g on g.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
                left join MedicalRecord.DBO.MR_MCU_THT h on h.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
                left join MedicalRecord.dbo.MR_MCU_Syaraf j on j.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS
                inner join MasterdataSQL.dbo.MstrTypePatient i
                            on i.ID = a.PatientType 
                where 
                replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') between :tglawal and :tglakhir
                and a.Unit='53' and a.Batal='0'   and i.TypePatient='UMUM'  ";
                $this->db->query($tsql);
            } elseif ($tp_pasien === "5") { //rajal,jaminan,Perusahaan
                $tsql = "SELECT replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as Tgl,b.PatientName,
                b.Gander,DATEDIFF(yy, b.Date_of_birth, GETDATE()) as UMUR,a.noregistrasi,
                c.TB  as PemfisikTB,c.BB  as PemfisikBB,c.KondisiNutrisi  as PemfisikKondisiNutrisi,c.BMI  as PemfisikBMI,c.KetBMI as PemfisikKetBMI,
                d.pfk_usg as UsgAbdomen, d.PFK_Radiologi as Rontgen_Thorax,d.PFK_Audiometri as Audiometri,
                d.PFK_Lab as Laboratorium,e.A as PenyakitDalam,f.A as Bedah, d.Saran as AnjuranKonsulKe,
                d.PFK_EKG as EKG, d.PFK_Treadmill as Treadmill,g.Kesimpulan as KesimpulanMata,h.kesimpulan as kesimpulantht,j.Kesimpulan as kesimpulansyaraf,d.DiagnosaKerja
                ,CASE WHEN d.KetKesehatan ='Kesehatan Baik' THEN 'A'
     WHEN d.KetKesehatan ='Kesehatan Cukup Baik dengan Kelainan yang dapat dipulihkan' THEN 'B'
     WHEN d.KetKesehatan ='Kesehatan Baik dengan Kelainan yang dapat dipulihkan' THEN 'B'
     WHEN d.KetKesehatan ='Kemampuan Fisik terbatas untuk pekerjaan tertentu' THEN 'C'
     WHEN d.KetKesehatan ='Tidak Fit tidak aman untuk semua pekerjaan' THEN 'D'
     WHEN d.KetKesehatan ='Tidak Sehat/tidak Layak Penempatan' THEN 'E' END AS KetKesehatan,d.KetKesehatan as kategorikesehatan,d.PFK_Spirometri as Spirometri
                FROM PerawatanSQL.dbo.Visit a
                inner join MasterdataSQL.dbo.Admision b
                on a.NoMR = b.NoMR
                inner join MedicalRecord.DBO.MR_ASSM_MCU  c on c.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
                left join MedicalRecord.DBO.MR_ASS_MCU2 d on d.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
                left join MedicalRecord.DBO.MR_MCU_PenyakitDalam e on e.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
                left join MedicalRecord.DBO.MR_MCU_Bedah f on f.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
                left join MedicalRecord.DBO.MR_MCU_MATA g on g.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
                left join MedicalRecord.DBO.MR_MCU_THT h on h.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
                inner join MasterdataSQL.dbo.MstrTypePatient i
                            on i.ID = a.PatientType 
                inner join MasterdataSQL.dbo.MstrPerusahaanJPK op on op.ID = a.Perusahaan
                left join MedicalRecord.dbo.MR_MCU_Syaraf j on j.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS
                where 
                replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') between   :tglawal and :tglakhir
                and a.Unit='53' and a.Batal='0'     and a.Perusahaan=:id_penjamin";
                $this->db->query($tsql);
                $this->db->bind('id_penjamin', $id_penjamin);
            } elseif ($tp_pasien === "2") { //rajal,jaminan,asuransi
                $tsql = "SELECT replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as Tgl,b.PatientName,
                b.Gander,DATEDIFF(yy, b.Date_of_birth, GETDATE()) as UMUR,a.noregistrasi,
                c.TB  as PemfisikTB,c.BB  as PemfisikBB,c.KondisiNutrisi  as PemfisikKondisiNutrisi,c.BMI  as PemfisikBMI,c.KetBMI as PemfisikKetBMI,
                d.pfk_usg as UsgAbdomen, d.PFK_Radiologi as Rontgen_Thorax,d.PFK_Audiometri as Audiometri,
                d.PFK_Lab as Laboratorium,e.A as PenyakitDalam,f.A as Bedah, d.Saran as AnjuranKonsulKe,
                d.PFK_EKG as EKG, d.PFK_Treadmill as Treadmill,g.Kesimpulan as KesimpulanMata,h.kesimpulan as kesimpulantht,j.Kesimpulan as kesimpulansyaraf,d.DiagnosaKerja
                ,CASE WHEN d.KetKesehatan ='Kesehatan Baik' THEN 'A'
     WHEN d.KetKesehatan ='Kesehatan Cukup Baik dengan Kelainan yang dapat dipulihkan' THEN 'B'
     WHEN d.KetKesehatan ='Kesehatan Baik dengan Kelainan yang dapat dipulihkan' THEN 'B'
     WHEN d.KetKesehatan ='Kemampuan Fisik terbatas untuk pekerjaan tertentu' THEN 'C'
     WHEN d.KetKesehatan ='Tidak Fit tidak aman untuk semua pekerjaan' THEN 'D'
     WHEN d.KetKesehatan ='Tidak Sehat/tidak Layak Penempatan' THEN 'E' END AS KetKesehatan,d.KetKesehatan as kategorikesehatan,d.PFK_Spirometri as Spirometri
                FROM PerawatanSQL.dbo.Visit a
                inner join MasterdataSQL.dbo.Admision b
                on a.NoMR = b.NoMR
                inner join MedicalRecord.DBO.MR_ASSM_MCU  c on c.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
                left join MedicalRecord.DBO.MR_ASS_MCU2 d on d.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
                left join MedicalRecord.DBO.MR_MCU_PenyakitDalam e on e.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
                left join MedicalRecord.DBO.MR_MCU_Bedah f on f.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
                left join MedicalRecord.DBO.MR_MCU_MATA g on g.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
                left join MedicalRecord.DBO.MR_MCU_THT h on h.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
                inner join MasterdataSQL.dbo.MstrTypePatient i
                            on i.ID = a.PatientType 
                inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi op on op.ID = a.Asuransi
                left join MedicalRecord.dbo.MR_MCU_Syaraf j on j.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS
                where 
                replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') between  :tglawal and :tglakhir
                and a.Unit='53' and a.Batal='0'    and a.Asuransi=:id_penjamin";
                $this->db->query($tsql);
                $this->db->bind('id_penjamin', $id_penjamin);
            } else {
                $tsql = "SELECT replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as Tgl,b.PatientName,
                 b.Gander,DATEDIFF(yy, b.Date_of_birth, GETDATE()) as UMUR,a.noregistrasi,
                 c.TB  as PemfisikTB,c.BB  as PemfisikBB,c.KondisiNutrisi  as PemfisikKondisiNutrisi,c.BMI  as PemfisikBMI,c.KetBMI as PemfisikKetBMI,
                 d.pfk_usg as UsgAbdomen, d.PFK_Radiologi as Rontgen_Thorax,d.PFK_Audiometri as Audiometri,
                 d.PFK_Lab as Laboratorium,e.A as PenyakitDalam,f.A as Bedah, d.Saran as AnjuranKonsulKe,
                 d.PFK_EKG as EKG, d.PFK_Treadmill as Treadmill,g.Kesimpulan as KesimpulanMata,h.kesimpulan as kesimpulantht,j.Kesimpulan as kesimpulansyaraf,d.DiagnosaKerja
                 ,CASE WHEN d.KetKesehatan ='Kesehatan Baik' THEN 'A'
      WHEN d.KetKesehatan ='Kesehatan Cukup Baik dengan Kelainan yang dapat dipulihkan' THEN 'B'
     WHEN d.KetKesehatan ='Kesehatan Baik dengan Kelainan yang dapat dipulihkan' THEN 'B'
      WHEN d.KetKesehatan ='Kemampuan Fisik terbatas untuk pekerjaan tertentu' THEN 'C'
      WHEN d.KetKesehatan ='Tidak Fit tidak aman untuk semua pekerjaan' THEN 'D'
      WHEN d.KetKesehatan ='Tidak Sehat/tidak Layak Penempatan' THEN 'E' END AS KetKesehatan,d.KetKesehatan as kategorikesehatan,d.PFK_Spirometri as Spirometri
                 FROM PerawatanSQL.dbo.Visit a
                 inner join MasterdataSQL.dbo.Admision b
                 on a.NoMR = b.NoMR
                 inner join MedicalRecord.DBO.MR_ASSM_MCU  c on c.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
                 left join MedicalRecord.DBO.MR_ASS_MCU2 d on d.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
                 left join MedicalRecord.DBO.MR_MCU_PenyakitDalam e on e.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
                 left join MedicalRecord.DBO.MR_MCU_Bedah f on f.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
                 left join MedicalRecord.DBO.MR_MCU_MATA g on g.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
                 left join MedicalRecord.DBO.MR_MCU_THT h on h.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS 
                 left join MedicalRecord.dbo.MR_MCU_Syaraf j on j.NoRegistrasi collate Latin1_General_CI_AS = a.NoRegistrasi  collate Latin1_General_CI_AS
                 inner join MasterdataSQL.dbo.MstrTypePatient i
                             on i.ID = a.PatientType 
                 where 
                 replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') between :tglawal and :tglakhir
                 and a.Unit='53' and a.Batal='0'   ";
                $this->db->query($tsql);
            }

            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            // $this->db->bind('TipePenjamin', $tp_pasien);
            // $this->db->bind('NamaPenjamin', $id_penjamin);
            // $tp_pasien = $data['TipePenjamin'];
            // $id_penjamin = $data['NamaPenjamin'];
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $row) {
                $pasing['no'] = $no++;
                $pasing['tgl'] = date('d-m-Y', strtotime($row['Tgl']));
                $pasing['PatientName'] = $row['PatientName'];
                $pasing['Gander'] = $row['Gander'];
                $pasing['UMUR'] = $row['UMUR'];
                $pasing['PemfisikTB'] = $row['PemfisikTB'] . ' Cm';
                $pasing['PemfisikBB'] = $row['PemfisikBB'] . ' Kg';

                $pasing['Kelainan'] = '1. Fisik - Kondisi Nutrisi :  ' . $row['PemfisikKondisiNutrisi'] . ' - BMI :  ' . $row['PemfisikBMI'] . ' - Ket BMI : ' . $row['PemfisikKetBMI'] . ' <br> 2. Rontgen Thorax : ' . $row['Rontgen_Thorax'] . '<br> 3. USG Abdomen : ' . $row['UsgAbdomen'] . '<br> 4. Audiometri : ' . $row['Audiometri'] . '<br> 5. Laboratorium : ' . $row['Laboratorium'] . '<br> 6. Jantung - EKG : ' . $row['EKG'] . ' - Treadmill : ' . $row['Treadmill'] . ' <br> 7. Mata : ' . $row['KesimpulanMata'] . '<br> 8. THT : ' . $row['kesimpulantht'] . '<br> 9. Penyakit Dalam : ' . $row['PenyakitDalam'] . '<br> 10. Bedah : ' . $row['Bedah'] . '<br> 11. Syaraf : ' . $row['kesimpulansyaraf'] . '<br> 12. Ginekologi :' . '<br> 13. Spirometri : ' . $row['Spirometri'];
                $pasing['DiagnosaKerja'] = $row['DiagnosaKerja'];
                $pasing['AnjuranKonsulKe'] = $row['AnjuranKonsulKe'];
                $pasing['KetKesehatan'] = $row['KetKesehatan'];
                $pasing['kategorikesehatan'] = $row['kategorikesehatan'];
                $rows[] = $pasing;
            }
            return $data;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getNamaPenjamin($tp_pasien)
    {
        try {
            if ($tp_pasien == '2') {
                $query = "SELECT ID,NamaPerusahaan FROM MasterDataSQL.dbo.MstrPerusahaanAsuransi where StatusAktif='1'";
            } elseif ($tp_pasien == '5') {
                $query = "SELECT ID,NamaPerusahaan FROM MasterDataSQL.dbo.MstrPerusahaanJPK where StatusAktif='1' and ID<>'315'";
            } elseif ($tp_pasien == '1') {
                $query = "SELECT ID,NamaPerusahaan FROM MasterDataSQL.dbo.MstrPerusahaanJPK where StatusAktif='1' and ID='315'";
            } else {
                $query = "SELECT ID,NamaPerusahaan FROM MasterDataSQL.dbo.MstrPerusahaanJPK where StatusAktif='1' and 1=0";
            }

            $this->db->query($query);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['NamaPerusahaan'] = $key['NamaPerusahaan'];
                $rows[] = $pasing;
            }
            $callback = array(
                'status' => "success", // Set array nama  
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
