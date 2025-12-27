<?php

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;

class B_List_Registrasi_Pasien_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function showDataPasienRajalAktif_new($data)
    {
        try {
            $sql_details = array(
                'user' => DB_USER,
                'pass' => DB_PASSWORD,
                'db'   => DB_NAME,
                'host' => DB_HOST
            );
            $table = <<<EOT
 (SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName,a.LokasiPasien,a.CaraBayar,
                            a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
                            a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date] as VisitDate,
                            a.PatientType,a.Unit,a.Doctor_1,b.First_Name,a.JamPraktek,
                            case when a.Asuransi is not null and a.PatientType='2' then a.Asuransi else a.Perusahaan end as Asuransi,
							case when c.NamaPerusahaan is not null and a.PatientType='2'  then c.NamaPerusahaan else f.NamaPerusahaan end as  Perusahaan,
                            a.[Payment Type] as payment_type,
                            a.Antrian,a.NoAntrianAll,e.[First Name] as namauser
                            , case when a.TelemedicineIs='1' then 'TELEMEDICINE' ELSE '' end as Telemedicine,a.Company,HakKelasBPJS,PRB
                            --,tgc.ID as GeneralConsentID,ai.ID as AkadIjarohID,hk.ID as HakKewajibanID,tt.ID as TataTertibID,nonop.ID as BiayaNonOPID
                            from PerawatanSQL.dbo.Visit a
                            inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
                            left join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.Asuransi
                            left join MasterdataSQL.dbo.MstrPerusahaanJPK f on f.ID = a.Perusahaan
                            inner join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
                            left join MasterdataSQL.dbo.Employees e on e.ID = a.Operator

                            -- left join Billing_Pasien.DBO.TDocumentGeneralConsents tgc on a.NoRegistrasi collate Latin1_General_CI_AS=tgc.NoRegistrasi and tgc.ActiveDocument='1'
                            -- left join Billing_Pasien.DBO.TDocumentIjarohAgreements ai on a.NoRegistrasi collate Latin1_General_CI_AS=ai.NoRegistrasi and ai.ActiveDocument='1'
                            -- left join Billing_Pasien.DBO.TDocumentRightsandObligations hk on a.NoRegistrasi collate Latin1_General_CI_AS=hk.NoRegistrasi and hk.ActiveDocument='1'
                            -- left join Billing_Pasien.DBO.TDocumentRegulations tt on a.NoRegistrasi collate Latin1_General_CI_AS=tt.NoRegistrasi and tt.ActiveDocument='1'
                            -- left join Billing_Pasien.DBO.TDocumentEsitimatedOperationgCosts nonop on a.NoRegistrasi collate Latin1_General_CI_AS=nonop.NoRegistrasi and nonop.ActiveDocument='1'

                            where a.Batal='0' AND   [Status ID]<>'4') temp
EOT;

            // Table's primary key
            $primaryKey = 'id';

            // Array of database columns which should be read and sent back to DataTables.
            // The `db` parameter represents the column name in the database, while the `dt`
            // parameter represents the DataTables column identifier. In this case simple
            // indexes
            $columns = array(

                array('db' => 'id', 'dt' => 'ID'),
                array('db' => 'NoEpisode',  'dt' => 'NoEpisode'),
                array('db' => 'NoRegistrasi',     'dt' => 'NoRegistrasi'),
                array('db' => 'PatientName',     'dt' => 'PatientName'),
                array('db' => 'LokasiPasien',   'dt' => 'LokasiPasien'),
                array('db' => 'CaraBayar',     'dt' => 'CaraBayar'),
                array('db' => 'NoMR',     'dt' => 'NoMR'),
                array('db' => 'NoPesertaBPJS',     'dt' => 'NoPesertaBPJS'),
                array('db' => 'NoSEP',     'dt' => 'NoSEP'),
                array('db' => 'TglSEP',     'dt' => 'TglSEP'),
                array('db' => 'AlasanSEPtunda',     'dt' => 'AlasanSEPtunda'),
                array('db' => 'ApproveSEP',     'dt' => 'ApproveSEP'),
                array('db' => 'NoRujukan',     'dt' => 'NoRujukan'),
                array('db' => 'TglRujukan',     'dt' => 'TglRujukan'),
                array('db' => 'PPKRujukan',     'dt' => 'PPKRujukan'),
                array('db' => 'VisitDate',     'dt' => 'VisitDate'),
                array('db' => 'PatientType',     'dt' => 'PatientType'),
                array('db' => 'Unit',     'dt' => 'Unit'),
                array('db' => 'Doctor_1',     'dt' => 'Doctor_1'),
                array('db' => 'First_Name',     'dt' => 'DokterName'),
                array('db' => 'JamPraktek',     'dt' => 'JamPraktek'),
                array('db' => 'Asuransi',     'dt' => 'Asuransi'),
                array('db' => 'Perusahaan',     'dt' => 'Perusahaan'),
                array('db' => 'payment_type',     'dt' => 'payment_type'),
                array('db' => 'Antrian',     'dt' => 'Antrian'),
                array('db' => 'NoAntrianAll',     'dt' => 'NoAntrianAll'),
                array('db' => 'namauser',     'dt' => 'namauser'),
                array('db' => 'Telemedicine',     'dt' => 'Telemedicine'),
                array('db' => 'Company',     'dt' => 'Company'),
                array('db' => 'HakKelasBPJS',     'dt' => 'HakKelasBPJS'),
                array('db' => 'PRB',     'dt' => 'PRB')


            );
            // require('SSP.php');

            // echo json_encode(
            //     SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns)

            // );
            // return SP::simple($_POST, $sql_details, $table, $primaryKey, $columns); 
            return SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns);

            // return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function showDataPasienRajalAktif($data)
    {
        try {
            // $this->db->query("SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName,a.LokasiPasien,a.CaraBayar,
            //                               a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
            //                               a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
            //                               a.PatientType,a.Unit,a.Doctor_1,b.First_Name,a.JamPraktek,a.Asuransi,c.NamaPerusahaan as  Perusahaan,a.[Payment Type],
            //                               a.Antrian,a.NoAntrianAll,e.[First Name] as namauser
            //                               , case when a.TelemedicineIs='1' then 'TELEMEDICINE' ELSE '' end as Telemedicine,a.Company,HakKelasBPJS,PRB
            //                               from PerawatanSQL.dbo.Visit a
            //                               inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
            //                               inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.Asuransi
            //                               inner join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
            //                               left join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
            //                               where a.PatientType='2' and a.Batal='0' AND   [Status ID]<>'4'
            //                               UNION ALL
            //                               SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName ,a.LokasiPasien,a.CaraBayar,
            //                               a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
            //                               a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
            //                               a.PatientType,a.Unit,a.Doctor_1,b.First_Name,a.JamPraktek,a.Asuransi,c.NamaPerusahaan as  Perusahaan,a.[Payment Type],
            //                               a.Antrian,a.NoAntrianAll,e.[First Name] as namauser
            //                               , case when a.TelemedicineIs='1' then 'TELEMEDICINE' ELSE 'NON TELEMEDICINE' end as Telemedicine,a.Company,HakKelasBPJS,PRB
            //                               from PerawatanSQL.dbo.Visit a
            //                               inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
            //                               left join MasterdataSQL.dbo.MstrPerusahaanJPK c on c.ID = a.Perusahaan
            //                               inner join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
            //                               inner join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
            //                               where  a.PatientType<>'2' and a.Batal='0'
            //                             AND   [Status ID]<>'4'  
            //                             ORDER BY a.id DESC");
            $this->db->query("SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName,a.LokasiPasien,a.CaraBayar,
                            a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
                            a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
                            a.PatientType,a.Unit,a.Doctor_1,b.First_Name,a.JamPraktek,
                            case when a.Asuransi is not null and a.PatientType='2' then a.Asuransi else a.Perusahaan end as Asuransi,
							case when c.NamaPerusahaan is not null and a.PatientType='2'  then c.NamaPerusahaan else f.NamaPerusahaan end as  Perusahaan,
                            a.[Payment Type],
                            a.Antrian,a.NoAntrianAll,e.[First Name] as namauser
                            , case when a.TelemedicineIs='1' then 'TELEMEDICINE' ELSE '' end as Telemedicine,a.Company,HakKelasBPJS,PRB
                            --,tgc.ID as GeneralConsentID,ai.ID as AkadIjarohID,hk.ID as HakKewajibanID,tt.ID as TataTertibID,nonop.ID as BiayaNonOPID
                            from PerawatanSQL.dbo.Visit a
                            inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
                            left join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.Asuransi
                            left join MasterdataSQL.dbo.MstrPerusahaanJPK f on f.ID = a.Perusahaan
                            inner join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
                            left join MasterdataSQL.dbo.Employees e on e.ID = a.Operator

                            -- left join Billing_Pasien.DBO.TDocumentGeneralConsents tgc on a.NoRegistrasi collate Latin1_General_CI_AS=tgc.NoRegistrasi and tgc.ActiveDocument='1'
                            -- left join Billing_Pasien.DBO.TDocumentIjarohAgreements ai on a.NoRegistrasi collate Latin1_General_CI_AS=ai.NoRegistrasi and ai.ActiveDocument='1'
                            -- left join Billing_Pasien.DBO.TDocumentRightsandObligations hk on a.NoRegistrasi collate Latin1_General_CI_AS=hk.NoRegistrasi and hk.ActiveDocument='1'
                            -- left join Billing_Pasien.DBO.TDocumentRegulations tt on a.NoRegistrasi collate Latin1_General_CI_AS=tt.NoRegistrasi and tt.ActiveDocument='1'
                            -- left join Billing_Pasien.DBO.TDocumentEsitimatedOperationgCosts nonop on a.NoRegistrasi collate Latin1_General_CI_AS=nonop.NoRegistrasi and nonop.ActiveDocument='1'

                            where a.Batal='0' AND   [Status ID]<>'4'
                            ORDER BY a.id DESC");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = 0;
            foreach ($data as $key) {
                $no++;
                $nosep = '';
                if ($key['NoSEP'] != null || $key['NoSEP'] != '') {
                    $nosep = '<b>(No SEP: ' . $key['NoSEP'] . ')</b>';
                }
                $pasing['no'] = $no;
                $pasing['ID'] = $key['id'];
                $pasing['NoEpisode'] = $key['NoEpisode'];
                $pasing['Company'] = $key['Company'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['LokasiPasien'] = $key['LokasiPasien'];
                $pasing['Perusahaan'] = $key['Perusahaan'];
                $pasing['namauser'] = $key['namauser'];
                $pasing['NoSEP_edited'] = $nosep;
                $pasing['NoSEP'] = $key['NoSEP'];
                $pasing['Telemedicine'] = $key['Telemedicine'];
                $pasing['VisitDate'] = date('d/m/Y H:i:s', strtotime($key['Visit Date']));
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['PatientName'] = $key['PatientName'];
                $pasing['DokterName'] = $key['First_Name'];
                $pasing['HakKelasBPJS'] = $key['HakKelasBPJS'];
                $pasing['PRB'] = $key['PRB'];
                $pasing['NoPesertaBPJS'] = $key['NoPesertaBPJS'];

                // $pasing['GeneralConsentID'] = $key['GeneralConsentID'];
                // $pasing['AkadIjarohID'] = $key['AkadIjarohID'];
                // $pasing['HakKewajibanID'] = $key['HakKewajibanID'];
                // $pasing['TataTertibID'] = $key['TataTertibID'];
                // $pasing['BiayaNonOPID'] = $key['BiayaNonOPID'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function showDataPasienRajalArsip_new($data)
    {
        try {
            $sql_details = array(
                'user' => DB_USER,
                'pass' => DB_PASSWORD,
                'db'   => DB_NAME,
                'host' => DB_HOST
            );
            $table = <<<EOT
 (SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName,a.LokasiPasien,a.CaraBayar,
                                a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
                                a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date] as VisitDate,
                                a.PatientType,a.Unit,a.Doctor_1,b.First_Name,a.JamPraktek,
                                case when a.Asuransi is not null and a.PatientType='2' then a.Asuransi else a.Perusahaan end as Asuransi,
										  case when c.NamaPerusahaan is not null and a.PatientType='2'  then c.NamaPerusahaan else f.NamaPerusahaan end as  Perusahaan,a.[Payment Type],
                                a.Antrian,a.NoAntrianAll,e.[First Name] as namauser
                                , case when a.TelemedicineIs='1' then 'TELEMEDICINE' ELSE '' end as Telemedicine,a.Company
                                from PerawatanSQL.dbo.Visit a
                                inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
                                left join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.Asuransi
                                left join MasterdataSQL.dbo.MstrPerusahaanJPK f on f.ID = a.Perusahaan
                                inner join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
                                left join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
                                where  a.Batal='0' AND   [Status ID]='4' 
                                AND replace(CONVERT(VARCHAR(11), [Visit Date], 111), '/','-')  between '$data[tglAwalarsip]' and '$data[tglAkhirArsip]') temp
EOT;

            // Table's primary key
            $primaryKey = 'id';

            // Array of database columns which should be read and sent back to DataTables.
            // The `db` parameter represents the column name in the database, while the `dt`
            // parameter represents the DataTables column identifier. In this case simple
            // indexes
            $columns = array(

                array('db' => 'id', 'dt' => 'id'),
                array('db' => 'NoEpisode',  'dt' => 'NoEpisode'),
                array('db' => 'NoRegistrasi',     'dt' => 'NoRegistrasi'),
                array('db' => 'PatientName',     'dt' => 'PatientName'),
                array('db' => 'LokasiPasien',   'dt' => 'LokasiPasien'),
                array('db' => 'CaraBayar',     'dt' => 'CaraBayar'),
                array('db' => 'NoMR',     'dt' => 'NoMR'),
                array('db' => 'NoPesertaBPJS',     'dt' => 'NoPesertaBPJS'),
                array('db' => 'NoSEP',     'dt' => 'NoSEP'),
                array('db' => 'TglSEP',     'dt' => 'TglSEP'),
                array('db' => 'AlasanSEPtunda',     'dt' => 'AlasanSEPtunda'),
                array('db' => 'ApproveSEP',     'dt' => 'ApproveSEP'),
                array('db' => 'NoRujukan',     'dt' => 'NoRujukan'),
                array('db' => 'TglRujukan',     'dt' => 'TglRujukan'),
                array('db' => 'PPKRujukan',     'dt' => 'PPKRujukan'),
                array('db' => 'VisitDate',     'dt' => 'VisitDate'),
                array('db' => 'PatientType',     'dt' => 'PatientType'),
                array('db' => 'Unit',     'dt' => 'Unit'),
                array('db' => 'Doctor_1',     'dt' => 'Doctor_1'),
                array('db' => 'First_Name',     'dt' => 'DokterName'),
                array('db' => 'JamPraktek',     'dt' => 'JamPraktek'),
                array('db' => 'Asuransi',     'dt' => 'Asuransi'),
                array('db' => 'Perusahaan',     'dt' => 'Perusahaan'),
                // array('db' => 'payment_type',     'dt' => 'payment_type'),
                array('db' => 'Antrian',     'dt' => 'Antrian'),
                array('db' => 'NoAntrianAll',     'dt' => 'NoAntrianAll'),
                array('db' => 'namauser',     'dt' => 'namauser'),
                array('db' => 'Telemedicine',     'dt' => 'Telemedicine'),
                array('db' => 'Company',     'dt' => 'Company')
                // array('db' => 'HakKelasBPJS',     'dt' => 'HakKelasBPJS'),
                // array('db' => 'PRB',     'dt' => 'PRB')


            );
            // require('SSP.php');

            // echo json_encode(
            //     SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns)

            // );
            // return SP::simple($_POST, $sql_details, $table, $primaryKey, $columns); 
            return SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns);

            // return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function showDataPasienRajalArsip($data)
    {
        try {
            $tglawal_Search =  $data['tglAwalarsip'];
            $tglakhir_Search = $data['tglAkhirArsip'];

            // $this->db->query("SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName,a.LokasiPasien,a.CaraBayar,
            //                               a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
            //                               a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
            //                               a.PatientType,a.Unit,a.Doctor_1,b.First_Name,a.JamPraktek,a.Asuransi,c.NamaPerusahaan as  Perusahaan,a.[Payment Type],
            //                               a.Antrian,a.NoAntrianAll,e.[First Name] as namauser
            //                               , case when a.TelemedicineIs='1' then 'TELEMEDICINE' ELSE '' end as Telemedicine,a.Company
            //                               from PerawatanSQL.dbo.Visit a
            //                               inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
            //                               inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.Asuransi
            //                               inner join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
            //                               left join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
            //                               where a.PatientType='2' and a.Batal='0' AND   [Status ID]='4' 
            //                               AND replace(CONVERT(VARCHAR(11), [Visit Date], 111), '/','-')  between :tglawal_Search and :tglakhir_Search
            //                               UNION ALL
            //                               SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName ,a.LokasiPasien,a.CaraBayar,
            //                               a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
            //                               a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
            //                               a.PatientType,a.Unit,a.Doctor_1,b.First_Name,a.JamPraktek,a.Asuransi,c.NamaPerusahaan as  Perusahaan,a.[Payment Type],
            //                               a.Antrian,a.NoAntrianAll,e.[First Name] as namauser
            //                               , case when a.TelemedicineIs='1' then 'TELEMEDICINE' ELSE 'NON TELEMEDICINE' end as Telemedicine,a.Company
            //                               from PerawatanSQL.dbo.Visit a
            //                               inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
            //                               left join MasterdataSQL.dbo.MstrPerusahaanJPK c on c.ID = a.Perusahaan
            //                               inner join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
            //                               inner join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
            //                               where  a.PatientType<>'2' and a.Batal='0'
            //                             AND   [Status ID]='4'  
            //                             AND replace(CONVERT(VARCHAR(11), [Visit Date], 111), '/','-')  between :tglawal_Search2 and :tglakhir_Search2
            //                             ORDER BY a.id DESC");

            $this->db->query("SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName,a.LokasiPasien,a.CaraBayar,
                                a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
                                a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
                                a.PatientType,a.Unit,a.Doctor_1,b.First_Name,a.JamPraktek,
                                case when a.Asuransi is not null and a.PatientType='2' then a.Asuransi else a.Perusahaan end as Asuransi,
										  case when c.NamaPerusahaan is not null and a.PatientType='2'  then c.NamaPerusahaan else f.NamaPerusahaan end as  Perusahaan,a.[Payment Type],
                                a.Antrian,a.NoAntrianAll,e.[First Name] as namauser
                                , case when a.TelemedicineIs='1' then 'TELEMEDICINE' ELSE '' end as Telemedicine,a.Company
                                from PerawatanSQL.dbo.Visit a
                                inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
                                left join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.Asuransi
                                left join MasterdataSQL.dbo.MstrPerusahaanJPK f on f.ID = a.Perusahaan
                                inner join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
                                left join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
                                where  a.Batal='0' AND   [Status ID]='4' 
                                AND replace(CONVERT(VARCHAR(11), [Visit Date], 111), '/','-')  between :tglawal_Search2 and :tglakhir_Search2
                                ORDER BY a.id DESC");
            $this->db->bind('tglawal_Search2', $tglawal_Search);
            $this->db->bind('tglakhir_Search2', $tglakhir_Search);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = 0;
            foreach ($data as $key) {
                $no++;
                $nosep = '';
                if ($key['NoSEP'] != null || $key['NoSEP'] != '') {
                    $nosep = '<b>(No SEP: ' . $key['NoSEP'] . ')</b>';
                }
                $pasing['no'] = $no;
                $pasing['ID'] = $key['id'];
                $pasing['NoEpisode'] = $key['NoEpisode'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['LokasiPasien'] = $key['LokasiPasien'];
                $pasing['Perusahaan'] = $key['Perusahaan'];
                $pasing['namauser'] = $key['namauser'];
                $pasing['NoSEP'] = $key['NoSEP'];
                $pasing['NoSEP_edited'] = $nosep;
                $pasing['Telemedicine'] = $key['Telemedicine'];
                $pasing['VisitDate'] = date('d/m/Y H:i:s', strtotime($key['Visit Date']));
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['PatientName'] = $key['PatientName'];
                $pasing['DokterName'] = $key['First_Name'];
                $pasing['Company'] = $key['Company'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function showDataPasienRajalAktifForReservation($data)
    {
        try {
            $tglawal_Search =  $data['tglAwalarsip'];
            $tglakhir_Search = $data['tglAkhirArsip'];
            $Normpasien = $data['Normpasien'];

            // $this->db->query("SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName,a.LokasiPasien,a.CaraBayar,
            //                               a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
            //                               a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
            //                               a.PatientType,a.Unit,a.Doctor_1,b.First_Name,a.JamPraktek,a.Asuransi,c.NamaPerusahaan as  Perusahaan,a.[Payment Type],
            //                               a.Antrian,a.NoAntrianAll,e.[First Name] as namauser
            //                               , case when a.TelemedicineIs='1' then 'TELEMEDICINE' ELSE '' end as Telemedicine,a.Company,HakKelasBPJS,PRB
            //                               from PerawatanSQL.dbo.Visit a
            //                               inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
            //                               inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.Asuransi
            //                               inner join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
            //                               left join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
            //                               where a.PatientType='2' and a.Batal='0' AND   [Status ID]<>'4'
            //                               and a.NoMR = :Nomedrec
            //                               AND replace(CONVERT(VARCHAR(11), [Visit Date], 111), '/','-')  between :tglawal_Search and :tglakhir_Search
            //                               UNION ALL
            //                               SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName ,a.LokasiPasien,a.CaraBayar,
            //                               a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
            //                               a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
            //                               a.PatientType,a.Unit,a.Doctor_1,b.First_Name,a.JamPraktek,a.Asuransi,c.NamaPerusahaan as  Perusahaan,a.[Payment Type],
            //                               a.Antrian,a.NoAntrianAll,e.[First Name] as namauser
            //                               , case when a.TelemedicineIs='1' then 'TELEMEDICINE' ELSE 'NON TELEMEDICINE' end as Telemedicine,a.Company,HakKelasBPJS,PRB
            //                               from PerawatanSQL.dbo.Visit a
            //                               inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
            //                               left join MasterdataSQL.dbo.MstrPerusahaanJPK c on c.ID = a.Perusahaan
            //                               inner join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
            //                               inner join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
            //                               where  a.PatientType<>'2' and a.Batal='0'
            //                             AND   [Status ID]<>'4'
            //                             and a.NoMR = :Nomedrec2
            //                             AND replace(CONVERT(VARCHAR(11), [Visit Date], 111), '/','-')  between :tglawal_Search2 and :tglakhir_Search2  
            //                             ORDER BY a.id DESC");
            $this->db->query("SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName,a.LokasiPasien,a.CaraBayar,
                                a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
                                a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
                                a.PatientType,a.Unit,a.Doctor_1,b.First_Name,a.JamPraktek,
                                case when a.Asuransi is not null and a.PatientType='2' then a.Asuransi else a.Perusahaan end as Asuransi,
								case when c.NamaPerusahaan is not null and a.PatientType='2'  then c.NamaPerusahaan else f.NamaPerusahaan end as  Perusahaan,
                                a.[Payment Type],
                                a.Antrian,a.NoAntrianAll,e.[First Name] as namauser
                                , case when a.TelemedicineIs='1' then 'TELEMEDICINE' ELSE '' end as Telemedicine,a.Company,HakKelasBPJS,PRB
                                from PerawatanSQL.dbo.Visit a
                                inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
                                left join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.Asuransi
								left join MasterdataSQL.dbo.MstrPerusahaanJPK f on f.ID = a.Perusahaan
                                inner join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
                                left join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
                                where  a.Batal='0' AND   [Status ID]<>'4'
                                and a.NoMR = :Nomedrec
                                AND replace(CONVERT(VARCHAR(11), [Visit Date], 111), '/','-')  between :tglawal_Search and :tglakhir_Search
                                ORDER BY a.id DESC");
            $this->db->bind('tglawal_Search', $tglawal_Search);
            $this->db->bind('tglakhir_Search', $tglakhir_Search);
            $this->db->bind('Nomedrec', $Normpasien);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = 0;
            foreach ($data as $key) {
                $no++;
                $nosep = '';
                if ($key['NoSEP'] != null || $key['NoSEP'] != '') {
                    $nosep = '<b>(No SEP: ' . $key['NoSEP'] . ')</b>';
                }
                $pasing['no'] = $no;
                $pasing['ID'] = $key['id'];
                $pasing['NoEpisode'] = $key['NoEpisode'];
                $pasing['Company'] = $key['Company'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['LokasiPasien'] = $key['LokasiPasien'];
                $pasing['Perusahaan'] = $key['Perusahaan'];
                $pasing['namauser'] = $key['namauser'];
                $pasing['NoSEP_edited'] = $nosep;
                $pasing['NoSEP'] = $key['NoSEP'];
                $pasing['Telemedicine'] = $key['Telemedicine'];
                $pasing['VisitDate'] = date('d/m/Y H:i:s', strtotime($key['Visit Date']));
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['PatientName'] = $key['PatientName'];
                $pasing['DokterName'] = $key['First_Name'];
                $pasing['HakKelasBPJS'] = $key['HakKelasBPJS'];
                $pasing['PRB'] = $key['PRB'];
                $pasing['NoPesertaBPJS'] = $key['NoPesertaBPJS'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function showDataPasienRajalArsipForReservation($data)
    {
        try {
            $tglawal_Search =  $data['tglAwalarsip'];
            $tglakhir_Search = $data['tglAkhirArsip'];
            $Normpasien = $data['Normpasien'];

            // $this->db->query("SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName,a.LokasiPasien,a.CaraBayar,
            //                               a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
            //                               a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
            //                               a.PatientType,a.Unit,a.Doctor_1,b.First_Name,a.JamPraktek,a.Asuransi,c.NamaPerusahaan as  Perusahaan,a.[Payment Type],
            //                               a.Antrian,a.NoAntrianAll,e.[First Name] as namauser
            //                               , case when a.TelemedicineIs='1' then 'TELEMEDICINE' ELSE '' end as Telemedicine,a.Company
            //                               from PerawatanSQL.dbo.Visit a
            //                               inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
            //                               inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.Asuransi
            //                               inner join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
            //                               left join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
            //                               where a.PatientType='2' and a.Batal='0' AND   [Status ID]='4' 
            //                               and a.NoMR = :Nomedrec
            //                               AND replace(CONVERT(VARCHAR(11), [Visit Date], 111), '/','-')  between :tglawal_Search and :tglakhir_Search
            //                               UNION ALL
            //                               SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName ,a.LokasiPasien,a.CaraBayar,
            //                               a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
            //                               a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
            //                               a.PatientType,a.Unit,a.Doctor_1,b.First_Name,a.JamPraktek,a.Asuransi,c.NamaPerusahaan as  Perusahaan,a.[Payment Type],
            //                               a.Antrian,a.NoAntrianAll,e.[First Name] as namauser
            //                               , case when a.TelemedicineIs='1' then 'TELEMEDICINE' ELSE 'NON TELEMEDICINE' end as Telemedicine,a.Company
            //                               from PerawatanSQL.dbo.Visit a
            //                               inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
            //                               left join MasterdataSQL.dbo.MstrPerusahaanJPK c on c.ID = a.Perusahaan
            //                               inner join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
            //                               inner join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
            //                               where  a.PatientType<>'2' and a.Batal='0'
            //                             AND   [Status ID]='4'  
            //                             and a.NoMR = :Nomedrec2
            //                             AND replace(CONVERT(VARCHAR(11), [Visit Date], 111), '/','-')  between :tglawal_Search2 and :tglakhir_Search2
            //                             ORDER BY a.id DESC");

            $this->db->query("SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName,a.LokasiPasien,a.CaraBayar,
                            a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
                            a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
                            a.PatientType,a.Unit,a.Doctor_1,b.First_Name,a.JamPraktek,
                            case when a.Asuransi is not null and a.PatientType='2' then a.Asuransi else a.Perusahaan end as Asuransi,
							case when c.NamaPerusahaan is not null and a.PatientType='2'  then c.NamaPerusahaan else f.NamaPerusahaan end as  Perusahaan,
                            a.[Payment Type],
                            a.Antrian,a.NoAntrianAll,e.[First Name] as namauser
                            , case when a.TelemedicineIs='1' then 'TELEMEDICINE' ELSE '' end as Telemedicine,a.Company
                            from PerawatanSQL.dbo.Visit a
                            inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
                            left join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.Asuransi
							left join MasterdataSQL.dbo.MstrPerusahaanJPK f on f.ID = a.Perusahaan
                            inner join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
                            left join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
                            where a.Batal='0' AND   [Status ID]='4' 
                            and a.NoMR = :Nomedrec
                            AND replace(CONVERT(VARCHAR(11), [Visit Date], 111), '/','-')  between :tglawal_Search and :tglakhir_Search 
                            ORDER BY a.id DESC");
            $this->db->bind('tglawal_Search', $tglawal_Search);
            $this->db->bind('tglakhir_Search', $tglakhir_Search);
            $this->db->bind('Nomedrec', $Normpasien);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = 0;
            foreach ($data as $key) {
                $no++;
                $nosep = '';
                if ($key['NoSEP'] != null || $key['NoSEP'] != '') {
                    $nosep = '<b>(No SEP: ' . $key['NoSEP'] . ')</b>';
                }
                $pasing['no'] = $no;
                $pasing['ID'] = $key['id'];
                $pasing['NoEpisode'] = $key['NoEpisode'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['LokasiPasien'] = $key['LokasiPasien'];
                $pasing['Perusahaan'] = $key['Perusahaan'];
                $pasing['namauser'] = $key['namauser'];
                $pasing['NoSEP'] = $key['NoSEP'];
                $pasing['NoSEP_edited'] = $nosep;
                $pasing['Telemedicine'] = $key['Telemedicine'];
                $pasing['VisitDate'] = date('d/m/Y H:i:s', strtotime($key['Visit Date']));
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['PatientName'] = $key['PatientName'];
                $pasing['DokterName'] = $key['First_Name'];
                $pasing['Company'] = $key['Company'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function showDataPasienWalkinAktif_new($data)
    {
        try {
            $sql_details = array(
                'user' => DB_USER,
                'pass' => DB_PASSWORD,
                'db'   => DB_NAME,
                'host' => DB_HOST
            );
            $table = <<<EOT
 (SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName,a.LokasiPasien,a.CaraBayar,
            a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
            a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date] as VisitDate,
            a.PatientType,a.Unit,a.Doctor_1,b.First_Name,a.JamPraktek,
            case when a.Asuransi is not null and a.PatientType='2' then a.Asuransi else a.Perusahaan end as Asuransi,
			case when c.NamaPerusahaan is not null and a.PatientType='2'  then c.NamaPerusahaan else f.NamaPerusahaan end as  Perusahaan,
            a.[Payment Type],
            a.Antrian,a.NoAntrianAll,e.[First Name] as namauser
            , case when a.TelemedicineIs='1' then 'TELEMEDICINE' ELSE 'NON TELEMEDICINE' end as Telemedicine
            from PerawatanSQL.dbo.Visit a
            inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
            left join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.Asuransi
			left join MasterdataSQL.dbo.MstrPerusahaanJPK f on f.ID = a.Perusahaan
            inner join MasterdataSQL.dbo.Admision_Walkin d on d.NoMR = a.NoMR
            left join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
            where  a.Batal='0' AND   [Status ID]<>'4' and (Unit='9' or Unit='10')) temp
EOT;

            // Table's primary key
            $primaryKey = 'id';

            // Array of database columns which should be read and sent back to DataTables.
            // The `db` parameter represents the column name in the database, while the `dt`
            // parameter represents the DataTables column identifier. In this case simple
            // indexes
            $columns = array(

                array('db' => 'id', 'dt' => 'id'),
                array('db' => 'NoEpisode',  'dt' => 'NoEpisode'),
                array('db' => 'NoRegistrasi',     'dt' => 'NoRegistrasi'),
                array('db' => 'PatientName',     'dt' => 'PatientName'),
                array('db' => 'LokasiPasien',   'dt' => 'LokasiPasien'),
                array('db' => 'CaraBayar',     'dt' => 'CaraBayar'),
                array('db' => 'NoMR',     'dt' => 'NoMR'),
                array('db' => 'NoPesertaBPJS',     'dt' => 'NoPesertaBPJS'),
                array('db' => 'NoSEP',     'dt' => 'NoSEP'),
                array('db' => 'TglSEP',     'dt' => 'TglSEP'),
                array('db' => 'AlasanSEPtunda',     'dt' => 'AlasanSEPtunda'),
                array('db' => 'ApproveSEP',     'dt' => 'ApproveSEP'),
                array('db' => 'NoRujukan',     'dt' => 'NoRujukan'),
                array('db' => 'TglRujukan',     'dt' => 'TglRujukan'),
                array('db' => 'PPKRujukan',     'dt' => 'PPKRujukan'),
                array('db' => 'VisitDate',     'dt' => 'VisitDate'),
                array('db' => 'PatientType',     'dt' => 'PatientType'),
                array('db' => 'Unit',     'dt' => 'Unit'),
                array('db' => 'Doctor_1',     'dt' => 'Doctor_1'),
                array('db' => 'First_Name',     'dt' => 'DokterName'),
                array('db' => 'JamPraktek',     'dt' => 'JamPraktek'),
                array('db' => 'Asuransi',     'dt' => 'Asuransi'),
                array('db' => 'Perusahaan',     'dt' => 'Perusahaan'),
                // array('db' => 'payment_type',     'dt' => 'payment_type'),
                array('db' => 'Antrian',     'dt' => 'Antrian'),
                array('db' => 'NoAntrianAll',     'dt' => 'NoAntrianAll'),
                array('db' => 'namauser',     'dt' => 'namauser'),
                array('db' => 'Telemedicine',     'dt' => 'Telemedicine')
                // array('db' => 'Company',     'dt' => 'Company')
                // array('db' => 'HakKelasBPJS',     'dt' => 'HakKelasBPJS'),
                // array('db' => 'PRB',     'dt' => 'PRB')


            );
            // require('SSP.php');

            // echo json_encode(
            //     SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns)

            // );
            // return SP::simple($_POST, $sql_details, $table, $primaryKey, $columns); 
            return SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns);

            // return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function showDataPasienWalkinAktif($data)
    {
        try {
            //     $this->db->query("SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName,a.LokasiPasien,a.CaraBayar,
            //     a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
            //     a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
            //     a.PatientType,a.Unit,a.Doctor_1,b.First_Name,a.JamPraktek,a.Asuransi,c.NamaPerusahaan as  Perusahaan,a.[Payment Type],
            //     a.Antrian,a.NoAntrianAll,e.[First Name] as namauser
            //     , case when a.TelemedicineIs='1' then 'TELEMEDICINE' ELSE 'NON TELEMEDICINE' end as Telemedicine
            //     from PerawatanSQL.dbo.Visit a
            //     inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
            //     inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.Asuransi
            //     inner join MasterdataSQL.dbo.Admision_Walkin d on d.NoMR = a.NoMR
            //     left join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
            //     where a.PatientType='2' and a.Batal='0' AND   [Status ID]<>'4' and (Unit='9' or Unit='10')
            //     UNION ALL
            //     SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName ,a.LokasiPasien,a.CaraBayar,
            //     a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
            //     a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
            //     a.PatientType,a.Unit,a.Doctor_1,b.First_Name,a.JamPraktek,a.Asuransi,c.NamaPerusahaan as  Perusahaan,a.[Payment Type],
            //     a.Antrian,a.NoAntrianAll,e.[First Name] as namauser
            //     , case when a.TelemedicineIs='1' then 'TELEMEDICINE' ELSE 'NON TELEMEDICINE' end as Telemedicine
            //     from PerawatanSQL.dbo.Visit a
            //     inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
            //     left join MasterdataSQL.dbo.MstrPerusahaanJPK c on c.ID = a.Perusahaan
            //     inner join MasterdataSQL.dbo.Admision_Walkin d on d.NoMR = a.NoMR
            //     inner join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
            //     where  a.PatientType<>'2' and a.Batal='0'
            //   AND   [Status ID]<>'4'  and (Unit='9' or Unit='10')
            //   ORDER BY 1 DESC");

            $this->db->query("SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName,a.LokasiPasien,a.CaraBayar,
            a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
            a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
            a.PatientType,a.Unit,a.Doctor_1,b.First_Name,a.JamPraktek,
            case when a.Asuransi is not null and a.PatientType='2' then a.Asuransi else a.Perusahaan end as Asuransi,
			case when c.NamaPerusahaan is not null and a.PatientType='2'  then c.NamaPerusahaan else f.NamaPerusahaan end as  Perusahaan,
            a.[Payment Type],
            a.Antrian,a.NoAntrianAll,e.[First Name] as namauser
            , case when a.TelemedicineIs='1' then 'TELEMEDICINE' ELSE 'NON TELEMEDICINE' end as Telemedicine
            from PerawatanSQL.dbo.Visit a
            inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
            left join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.Asuransi
			left join MasterdataSQL.dbo.MstrPerusahaanJPK f on f.ID = a.Perusahaan
            inner join MasterdataSQL.dbo.Admision_Walkin d on d.NoMR = a.NoMR
            left join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
            where  a.Batal='0' AND   [Status ID]<>'4' and (Unit='9' or Unit='10') 
            ORDER BY 1 DESC");
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 0;
            foreach ($data as $key) {
                $no++;
                $nosep = '';
                if ($key['NoSEP'] != null || $key['NoSEP'] != '') {
                    $nosep = '<b>(No SEP: ' . $key['NoSEP'] . ')</b>';
                }
                $pasing['no'] = $no;
                $pasing['ID'] = $key['id'];
                $pasing['NoEpisode'] = $key['NoEpisode'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['LokasiPasien'] = $key['LokasiPasien'];
                $pasing['Perusahaan'] = $key['Perusahaan'];
                $pasing['namauser'] = $key['namauser'];
                $pasing['NoSEP'] = $nosep;
                $pasing['Telemedicine'] = $key['Telemedicine'];
                $pasing['VisitDate'] = date('d/m/Y H:i:s', strtotime($key['Visit Date']));
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['PatientName'] = $key['PatientName'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function showDataPasienWalkinArsip_new($data)
    {
        try {
            $sql_details = array(
                'user' => DB_USER,
                'pass' => DB_PASSWORD,
                'db'   => DB_NAME,
                'host' => DB_HOST
            );
            $table = <<<EOT
 (SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName,a.LokasiPasien,a.CaraBayar,
                            a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
                            a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date] as VisitDate,
                            a.PatientType,a.Unit,a.Doctor_1,b.First_Name,a.JamPraktek,
                            case when a.Asuransi is not null and a.PatientType='2' then a.Asuransi else a.Perusahaan end as Asuransi,
							case when c.NamaPerusahaan is not null and a.PatientType='2'  then c.NamaPerusahaan else f.NamaPerusahaan end as  Perusahaan,
                            a.[Payment Type],
                            a.Antrian,a.NoAntrianAll,e.[First Name] as namauser
                            , case when a.TelemedicineIs='1' then 'TELEMEDICINE' ELSE 'NON TELEMEDICINE' end as Telemedicine
                            from PerawatanSQL.dbo.Visit a
                            inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
                            left join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.Asuransi
							left join MasterdataSQL.dbo.MstrPerusahaanJPK f on f.ID = a.Perusahaan
                            inner join MasterdataSQL.dbo.Admision_Walkin d on d.NoMR = a.NoMR
                            left join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
                            where a.PatientType='2' and a.Batal='0' AND   [Status ID]='4' and (Unit='9' or Unit='10') 
                            AND replace(CONVERT(VARCHAR(11), [Visit Date], 111), '/','-')  between '$data[tglAwalarsip]' and '$data[tglAkhirArsip]') temp
EOT;

            // Table's primary key
            $primaryKey = 'id';

            // Array of database columns which should be read and sent back to DataTables.
            // The `db` parameter represents the column name in the database, while the `dt`
            // parameter represents the DataTables column identifier. In this case simple
            // indexes
            $columns = array(

                array('db' => 'id', 'dt' => 'id'),
                array('db' => 'NoEpisode',  'dt' => 'NoEpisode'),
                array('db' => 'NoRegistrasi',     'dt' => 'NoRegistrasi'),
                array('db' => 'PatientName',     'dt' => 'PatientName'),
                array('db' => 'LokasiPasien',   'dt' => 'LokasiPasien'),
                array('db' => 'CaraBayar',     'dt' => 'CaraBayar'),
                array('db' => 'NoMR',     'dt' => 'NoMR'),
                array('db' => 'NoPesertaBPJS',     'dt' => 'NoPesertaBPJS'),
                array('db' => 'NoSEP',     'dt' => 'NoSEP'),
                array('db' => 'TglSEP',     'dt' => 'TglSEP'),
                array('db' => 'AlasanSEPtunda',     'dt' => 'AlasanSEPtunda'),
                array('db' => 'ApproveSEP',     'dt' => 'ApproveSEP'),
                array('db' => 'NoRujukan',     'dt' => 'NoRujukan'),
                array('db' => 'TglRujukan',     'dt' => 'TglRujukan'),
                array('db' => 'PPKRujukan',     'dt' => 'PPKRujukan'),
                array('db' => 'VisitDate',     'dt' => 'VisitDate'),
                array('db' => 'PatientType',     'dt' => 'PatientType'),
                array('db' => 'Unit',     'dt' => 'Unit'),
                array('db' => 'Doctor_1',     'dt' => 'Doctor_1'),
                array('db' => 'First_Name',     'dt' => 'DokterName'),
                array('db' => 'JamPraktek',     'dt' => 'JamPraktek'),
                array('db' => 'Asuransi',     'dt' => 'Asuransi'),
                array('db' => 'Perusahaan',     'dt' => 'Perusahaan'),
                // array('db' => 'payment_type',     'dt' => 'payment_type'),
                array('db' => 'Antrian',     'dt' => 'Antrian'),
                array('db' => 'NoAntrianAll',     'dt' => 'NoAntrianAll'),
                array('db' => 'namauser',     'dt' => 'namauser'),
                array('db' => 'Telemedicine',     'dt' => 'Telemedicine')
                // array('db' => 'Company',     'dt' => 'Company')
                // array('db' => 'HakKelasBPJS',     'dt' => 'HakKelasBPJS'),
                // array('db' => 'PRB',     'dt' => 'PRB')


            );
            // require('SSP.php');

            // echo json_encode(
            //     SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns)

            // );
            // return SP::simple($_POST, $sql_details, $table, $primaryKey, $columns); 
            return SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns);

            // return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function showDataPasienWalkinArsip($data)
    {
        try {
            $tglawal_Search =  $data['tglAwalarsip'];
            $tglakhir_Search = $data['tglAkhirArsip'];
            // $this->db->query("SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName,a.LokasiPasien,a.CaraBayar,
            //                 a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
            //                 a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
            //                 a.PatientType,a.Unit,a.Doctor_1,b.First_Name,a.JamPraktek,a.Asuransi,c.NamaPerusahaan as  Perusahaan,a.[Payment Type],
            //                 a.Antrian,a.NoAntrianAll,e.[First Name] as namauser
            //                 , case when a.TelemedicineIs='1' then 'TELEMEDICINE' ELSE 'NON TELEMEDICINE' end as Telemedicine
            //                 from PerawatanSQL.dbo.Visit a
            //                 inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
            //                 inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.Asuransi
            //                 inner join MasterdataSQL.dbo.Admision_Walkin d on d.NoMR = a.NoMR
            //                 left join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
            //                 where a.PatientType='2' and a.Batal='0' AND   [Status ID]='4' and (Unit='9' or Unit='10') AND replace(CONVERT(VARCHAR(11), [Visit Date], 111), '/','-')  between :tglawal_Search and :tglakhir_Search
            //                 UNION ALL
            //                 SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName ,a.LokasiPasien,a.CaraBayar,
            //                 a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
            //                 a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
            //                 a.PatientType,a.Unit,a.Doctor_1,b.First_Name,a.JamPraktek,a.Asuransi,c.NamaPerusahaan as  Perusahaan,a.[Payment Type],
            //                 a.Antrian,a.NoAntrianAll,e.[First Name] as namauser
            //                 , case when a.TelemedicineIs='1' then 'TELEMEDICINE' ELSE 'NON TELEMEDICINE' end as Telemedicine
            //                 from PerawatanSQL.dbo.Visit a
            //                 inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
            //                 left join MasterdataSQL.dbo.MstrPerusahaanJPK c on c.ID = a.Perusahaan
            //                 inner join MasterdataSQL.dbo.Admision_Walkin d on d.NoMR = a.NoMR
            //                 inner join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
            //                 where  a.PatientType<>'2' and a.Batal='0'
            //                 AND   [Status ID]='4'  and (Unit='9' or Unit='10') AND replace(CONVERT(VARCHAR(11), [Visit Date], 111), '/','-')  between :tglawal_Search2 and :tglakhir_Search2
            //                 ORDER BY 1 DESC");

            $this->db->query("SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName,a.LokasiPasien,a.CaraBayar,
                            a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
                            a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
                            a.PatientType,a.Unit,a.Doctor_1,b.First_Name,a.JamPraktek,
                            case when a.Asuransi is not null and a.PatientType='2' then a.Asuransi else a.Perusahaan end as Asuransi,
							case when c.NamaPerusahaan is not null and a.PatientType='2'  then c.NamaPerusahaan else f.NamaPerusahaan end as  Perusahaan,
                            a.[Payment Type],
                            a.Antrian,a.NoAntrianAll,e.[First Name] as namauser
                            , case when a.TelemedicineIs='1' then 'TELEMEDICINE' ELSE 'NON TELEMEDICINE' end as Telemedicine
                            from PerawatanSQL.dbo.Visit a
                            inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
                            left join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.Asuransi
							left join MasterdataSQL.dbo.MstrPerusahaanJPK f on f.ID = a.Perusahaan
                            inner join MasterdataSQL.dbo.Admision_Walkin d on d.NoMR = a.NoMR
                            left join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
                            where a.PatientType='2' and a.Batal='0' AND   [Status ID]='4' and (Unit='9' or Unit='10') 
                            AND replace(CONVERT(VARCHAR(11), [Visit Date], 111), '/','-')  between :tglawal_Search and :tglakhir_Search
                            ORDER BY 1 DESC");
            $this->db->bind('tglawal_Search', $tglawal_Search);
            $this->db->bind('tglakhir_Search', $tglakhir_Search);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = 0;
            foreach ($data as $key) {
                $no++;
                $nosep = '';
                if ($key['NoSEP'] != null || $key['NoSEP'] != '') {
                    $nosep = '<b>(No SEP: ' . $key['NoSEP'] . ')</b>';
                }
                $pasing['no'] = $no;
                $pasing['ID'] = $key['id'];
                $pasing['NoEpisode'] = $key['NoEpisode'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['LokasiPasien'] = $key['LokasiPasien'];
                $pasing['Perusahaan'] = $key['Perusahaan'];
                $pasing['namauser'] = $key['namauser'];
                $pasing['NoSEP'] = $nosep;
                $pasing['Telemedicine'] = $key['Telemedicine'];
                $pasing['VisitDate'] = date('d/m/Y H:i:s', strtotime($key['Visit Date']));
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['PatientName'] = $key['PatientName'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function GoListCallerDokter($data)
    {
        try {
            $dateReg = $data['dateReg'];
            $Dokterx = $data['Dokterx'];
            //     $this->db->query("SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName,a.LokasiPasien,a.CaraBayar,
            //     a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
            //     a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
            //     a.PatientType,a.Unit,a.Doctor_1,b.First_Name,a.JamPraktek,a.Asuransi,c.NamaPerusahaan as  Perusahaan,a.[Payment Type],
            //     a.Antrian,a.NoAntrianAll,e.[First Name] as namauser
            //     , case when a.TelemedicineIs='1' then 'TELEMEDICINE' ELSE '' end as Telemedicine,
            //     f.StatusAntrian,g.task2,g.NO_sEP as Bridging
            //     from PerawatanSQL.dbo.Visit a
            //     inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
            //     inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.Asuransi
            //     inner join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
            //     left join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
            //     inner join PerawatanSQL.dbo.AntrianPasien f on f.no_transaksi=a.NoRegistrasi and f.Doctor_1 = a.Doctor_1
            //     left join PerawatanSQL.DBO.BPJS_T_SEP g on g.NO_sEP = a.NoSep  and a.NoRegistrasi = g.NO_REGISTRASI
            //     where a.PatientType='2' and a.Batal='0' AND   [Status ID]<>'4'  and f.batal='0'  and f.Doctor_1=:Dokterx
            //     and replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-')=:dateReg
            //     UNION ALL
            //     SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName ,a.LokasiPasien,a.CaraBayar,
            //     a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
            //     a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
            //     a.PatientType,a.Unit,a.Doctor_1,b.First_Name,a.JamPraktek,a.Asuransi,c.NamaPerusahaan as  Perusahaan,a.[Payment Type],
            //     a.Antrian,a.NoAntrianAll,e.[First Name] as namauser
            //     , case when a.TelemedicineIs='1' then 'TELEMEDICINE' ELSE 'NON TELEMEDICINE' end as Telemedicine,
            //     f.StatusAntrian,g.task2,g.NO_sEP as Bridging
            //     from PerawatanSQL.dbo.Visit a
            //     inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
            //     left join MasterdataSQL.dbo.MstrPerusahaanJPK c on c.ID = a.Perusahaan
            //     inner join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
            //     inner join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
            //     inner join PerawatanSQL.dbo.AntrianPasien f on f.no_transaksi=a.NoRegistrasi and f.Doctor_1 = a.Doctor_1
            //     left join PerawatanSQL.DBO.BPJS_T_SEP g on g.NO_sEP = a.NoSep  and a.NoRegistrasi = g.NO_REGISTRASI
            //     where  a.PatientType<>'2' and a.Batal='0'
            //   AND   [Status ID]<>'4'  and f.batal='0' and f.Doctor_1=:Dokterx2
            //   and replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-')=:dateReg2

            //   UNION ALL

            //   SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName,a.LokasiPasien,a.CaraBayar,
            //     a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
            //     a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
            //     a.PatientType,a.Unit,a.Doctor_1,b.First_Name,a.JamPraktek,a.Asuransi,c.NamaPerusahaan as  Perusahaan,a.[Payment Type],
            //     a.Antrian,a.NoAntrianAll,e.[First Name] as namauser
            //     , case when a.TelemedicineIs='1' then 'TELEMEDICINE' ELSE '' end as Telemedicine,
            //     f.StatusAntrian,g.task2,g.NO_sEP as Bridging
            //     from PerawatanSQL.dbo.Visit a
            //     inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
            //     inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.Asuransi
            //     inner join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
            //     left join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
            //     inner join PerawatanSQL.dbo.Apointment p on a.NoRegistrasi=p.NoRegistrasi
            //     inner join PerawatanSQL.dbo.AntrianPasien f on f.no_transaksi=p.NoBooking and f.Doctor_1 = a.Doctor_1
            //     left join PerawatanSQL.DBO.BPJS_T_SEP g on g.NO_sEP = a.NoSep  and a.NoRegistrasi = g.NO_REGISTRASI
            //     where a.PatientType='2' and a.Batal='0' AND   [Status ID]<>'4'  and f.batal='0'  and f.Doctor_1=:Dokterx3
            //     and replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-')=:dateReg3
            //     UNION ALL
            //     SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName ,a.LokasiPasien,a.CaraBayar,
            //     a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
            //     a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
            //     a.PatientType,a.Unit,a.Doctor_1,b.First_Name,a.JamPraktek,a.Asuransi,c.NamaPerusahaan as  Perusahaan,a.[Payment Type],
            //     a.Antrian,a.NoAntrianAll,e.[First Name] as namauser
            //     , case when a.TelemedicineIs='1' then 'TELEMEDICINE' ELSE 'NON TELEMEDICINE' end as Telemedicine
            //     ,  f.StatusAntrian,g.task2,g.NO_sEP as Bridging
            //     from PerawatanSQL.dbo.Visit a
            //     inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
            //     left join MasterdataSQL.dbo.MstrPerusahaanJPK c on c.ID = a.Perusahaan
            //     inner join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
            //     inner join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
            //     inner join PerawatanSQL.dbo.Apointment p on a.NoRegistrasi=p.NoRegistrasi
            //     inner join PerawatanSQL.dbo.AntrianPasien f on f.no_transaksi=p.NoBooking and f.Doctor_1 = a.Doctor_1
            //     left join PerawatanSQL.DBO.BPJS_T_SEP g on g.NO_sEP = a.NoSep  and a.NoRegistrasi = g.NO_REGISTRASI
            //     where  a.PatientType<>'2' and a.Batal='0'
            //   AND   [Status ID]<>'4'  and f.batal='0' and f.Doctor_1=:Dokterx4
            //   and replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-')=:dateReg4
            //   ORDER BY a.id DESC");



            $this->db->query("SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName,a.LokasiPasien,a.CaraBayar,
a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
a.PatientType,a.Unit,a.Doctor_1,b.First_Name,a.JamPraktek,
case when a.Asuransi is not null and a.PatientType='2' then a.Asuransi else a.Perusahaan end as Asuransi,
case when c.NamaPerusahaan is not null and a.PatientType='2'  then c.NamaPerusahaan else h.NamaPerusahaan end as  Perusahaan,
a.[Payment Type],
a.Antrian,a.NoAntrianAll,e.[First Name] as namauser
, case when a.TelemedicineIs='1' then 'TELEMEDICINE' ELSE '' end as Telemedicine,
f.StatusAntrian,g.task2,g.NO_sEP as Bridging
from PerawatanSQL.dbo.Visit a
inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
left join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.Asuransi
left join MasterdataSQL.dbo.MstrPerusahaanJPK h on h.ID = a.Perusahaan
inner join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
left join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
inner join PerawatanSQL.dbo.AntrianPasien f on f.no_transaksi=a.NoRegistrasi and f.Doctor_1 = a.Doctor_1
left join PerawatanSQL.DBO.BPJS_T_SEP g on g.NO_sEP = a.NoSep  and a.NoRegistrasi = g.NO_REGISTRASI
where a.Batal='0' AND   [Status ID]<>'4'  and f.batal='0'  and f.Doctor_1=:Dokterx
and replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-')=:dateReg 
UNION ALL
SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName,a.LokasiPasien,a.CaraBayar,
a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
a.PatientType,a.Unit,a.Doctor_1,b.First_Name,a.JamPraktek,
case when a.Asuransi is not null and a.PatientType='2' then a.Asuransi else a.Perusahaan end as Asuransi,
case when c.NamaPerusahaan is not null and a.PatientType='2'  then c.NamaPerusahaan else h.NamaPerusahaan end as  Perusahaan,
a.[Payment Type],
a.Antrian,a.NoAntrianAll,e.[First Name] as namauser
, case when a.TelemedicineIs='1' then 'TELEMEDICINE' ELSE '' end as Telemedicine,
f.StatusAntrian,g.task2,g.NO_sEP as Bridging
from PerawatanSQL.dbo.Visit a
inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
left join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.Asuransi
left join MasterdataSQL.dbo.MstrPerusahaanJPK h on h.ID = a.Perusahaan
inner join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
left join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
inner join PerawatanSQL.dbo.Apointment p on a.NoRegistrasi=p.NoRegistrasi
inner join PerawatanSQL.dbo.AntrianPasien f on f.no_transaksi=p.NoBooking and f.Doctor_1 = a.Doctor_1
left join PerawatanSQL.DBO.BPJS_T_SEP g on g.NO_sEP = a.NoSep  and a.NoRegistrasi = g.NO_REGISTRASI
where  a.Batal='0' AND   [Status ID]<>'4'  and f.batal='0'  and f.Doctor_1=:Dokterx2
and replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-')=:dateReg2
ORDER BY a.id DESC");
            $this->db->bind('dateReg', $dateReg);
            $this->db->bind('Dokterx', $Dokterx);
            $this->db->bind('dateReg2', $dateReg);
            $this->db->bind('Dokterx2', $Dokterx);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = 0;
            foreach ($data as $key) {
                $no++;
                $nosep = '';
                if ($key['NoSEP'] != null || $key['NoSEP'] != '') {
                    $nosep = '<b>(No SEP: ' . $key['NoSEP'] . ')</b>';
                }
                $pasing['no'] = $no;
                $pasing['ID'] = $key['id'];
                $pasing['NoEpisode'] = $key['NoEpisode'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['Bridging'] = $key['Bridging'];
                $pasing['LokasiPasien'] = $key['LokasiPasien'];
                $pasing['Perusahaan'] = $key['Perusahaan'];
                $pasing['namauser'] = $key['namauser'];
                $pasing['NoSEP'] = $nosep;
                $pasing['Telemedicine'] = $key['Telemedicine'];
                $pasing['VisitDate'] = date('d/m/Y H:i:s', strtotime($key['Visit Date']));
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['PatientName'] = $key['PatientName'];
                $pasing['NoAntrianAll'] = $key['NoAntrianAll'];
                $pasing['StatusAntrian'] = $key['StatusAntrian'];
                $pasing['task2'] = $key['task2'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function CekNoSEP($data)
    {
        try {
            $this->db->transaksi();

            $NOID_Reg = $data['NOID_Reg'];
            $NoSEPBaru = $data['NoSEPBaru'];
            $NoSEPLama = $data['NoSEPLama'];
            $JenisPasien = $data['JenisPasien'];
            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $namauserx = $session->name;

            if ($JenisPasien == 'RAJAL') {
                $tsql = "SELECT ID from PerawatanSQL.dbo.Visit where NoSEP=:NoSEPBaru AND BATAL='0'";
            } elseif ($JenisPasien == 'RANAP') {
                $tsql = "SELECT InpatientID as ID FROM RawatInapSQL.dbo.Inpatient WHere NoSEP=:NoSEPBaru";
            }

            $this->db->query($tsql);
            $this->db->bind('NoSEPBaru', $NoSEPBaru);
            $data =  $this->db->single();

            if ($data !== false) {
                $callback = array(
                    'status' => 'warning',
                    'message' => 'Nomor SEP Tersebut Sudah Dipakai Di Nomor Registrasi Lain ! Lanjut ?',
                );
                return $callback;
                exit;
            }

            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    function GoAddIcare($data)
    {
        $curl = curl_init();
        $Noreg = base64_decode($data['Noreg']);
        if ($Noreg == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Masukan Kode Booking !',
            );
            echo json_encode($callback);
            exit;
        }
        $this->db->query("SELECT NO_KARTU,KODE_DOKTER FROM PerawatanSQL.dbo.BPJS_T_SEP
            WHERE NO_REGISTRASI=:Noreg");
        $this->db->bind('Noreg', $Noreg);
        $dtSEP =  $this->db->single();
        $NoPesertaBPJS = $dtSEP['NO_KARTU'];
        $ID_Dokter_BPJS = $dtSEP['KODE_DOKTER'];
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS_Icare($tStamp);
        $body = '{
                "param": "' . $NoPesertaBPJS . '",
                "kodedokter": ' . $ID_Dokter_BPJS . '
            }';
        curl_setopt_array($curl, array(
            CURLOPT_URL =>  'https://apijkn.bpjs-kesehatan.go.id/wsihs/api/rs/validate',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_HTTPHEADER => $headerbpjs,
        ));
        $output = curl_exec($curl);
        // tutup curl 
        curl_close($curl);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);

        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));

            $callback = array(
                'status' => 'success',
                'hasil' => $ResultEncriptLzString['1']['url'],
            );
            return $callback;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']

            );
            return $callback;
        }
    }
    function GoTambahAntrianBPJS($data)
    {
        $curl = curl_init();
        $Noreg = $data['Noreg'];
        $NoSEPBaru = $data['NoSEPBaru'];
        $NamaJaminan = $data['NamaJaminan'];
        $AntrolJenisKunungan = $data['AntrolJenisKunungan'];
        if ($Noreg == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Masukan Kode Booking !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($AntrolJenisKunungan == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Masukan Jenis Kunjungan !',
            );
            echo json_encode($callback);
            exit;
        }
        // GET SEP
        if ($NamaJaminan === "BPJS Kesehatan") {
            $this->db->query("SELECT A.ID,A.NO_SEP,A.NO_REGISTRASI,A.NO_MR,A.NO_RUJUKAN,
                            A.NO_SPRI,A.NO_NIK,A.NO_KARTU,replace(CONVERT(VARCHAR(11), A.TGL_SEP, 111), '/','-') as TGL_SEP,
                            A.KODE_POLI,A.NAMA_POLI,A.KODE_DOKTER,A.NAMA_DOKTER,A.BATAL,
                            B.JamPraktek,b.NoAntrianAll,a.NO_KARTU,a.NO_TELEPON
							,replace(CONVERT(VARCHAR(11), CC.InputDate, 111), '/','-') as TglMR,
							CASE WHEN replace(CONVERT(VARCHAR(11), CC.InputDate, 111), '/','-')=replace(CONVERT(VARCHAR(11), A.TGL_SEP, 111), '/','-') 
							THEN '1' ELSE '0' END AS MR_ISNEW,dd.codeBPJS as kodeunitbpjs,dd.NamaBPJS , ee.ID_Dokter_BPJS,ee.First_Name as namadokter,b.ID_JadwalPraktek
                            ,b.jampraktek as SessionPoli,EE.ID  as IdDokterSIMRS,ee.NAMA_Dokter_BPJS
                            FROM PerawatanSQL.DBO.BPJS_T_SEP A
                            INNER JOIN PerawatanSQL.DBO.Visit B ON A.NO_SEP = B.NoSEP 
                            AND A.NO_REGISTRASI = B.NoRegistrasi
							INNER JOIN MasterdataSQL.DBO.Admision CC ON CC.NoMR = b.NoMR
                            INNER JOIN MasterdataSQL.DBO.MstrUnitPerwatan DD ON DD.ID = B.Unit
                            INNER JOIN MasterdataSQL.DBO.Doctors EE ON EE.ID = B.Doctor_1
                            WHERE A.NO_SEP=:NoSEPBaru AND A.NO_REGISTRASI=:Noreg");
            $this->db->bind('NoSEPBaru', $NoSEPBaru);
            $this->db->bind('Noreg', $Noreg);
            $dtSEP =  $this->db->single();
            $jenispasien = "JKN";
        } else {
            $this->db->query("SELECT '' ID,'' NO_SEP,B.NoRegistrasi AS NO_REGISTRASI,B.NoMR AS NO_MR,'' NO_RUJUKAN,
                            '' NO_SPRI, CC.Nik AS  NO_NIK,B.NoPesertaBPJS AS NO_KARTU,replace(CONVERT(VARCHAR(11), B.TglKunjungan, 111), '/','-') AS TGL_SEP,
                            '' KODE_POLI,'' NAMA_POLI,'' KODE_DOKTER,'' NAMA_DOKTER,'' BATAL,
                            B.JamPraktek,b.NoAntrianAll,CC.[Mobile Phone] AS NO_TELEPON
							,replace(CONVERT(VARCHAR(11), CC.InputDate, 111), '/','-') as TglMR,
							CASE WHEN replace(CONVERT(VARCHAR(11), CC.InputDate, 111), '/','-')=replace(CONVERT(VARCHAR(11), B.TglKunjungan, 111), '/','-') 
							THEN '1' ELSE '0' END AS MR_ISNEW,dd.codeBPJS as kodeunitbpjs,dd.NamaBPJS , ee.ID_Dokter_BPJS,ee.First_Name as namadokter,b.ID_JadwalPraktek
                            ,b.jampraktek as SessionPoli,EE.ID  as IdDokterSIMRS,ee.NAMA_Dokter_BPJS
                            FROM PerawatanSQL.DBO.Visit B  
							INNER JOIN MasterdataSQL.DBO.Admision CC ON CC.NoMR = b.NoMR
                            INNER JOIN MasterdataSQL.DBO.MstrUnitPerwatan DD ON DD.ID = B.Unit
                            INNER JOIN MasterdataSQL.DBO.Doctors EE ON EE.ID = B.Doctor_1
                            WHERE B.NoRegistrasi=:Noreg");
            $this->db->bind('Noreg', $Noreg);
            $dtSEP =  $this->db->single();
            $jenispasien = "NON JKN";
        }
        $nokartubpjs = $dtSEP['NO_KARTU'];
        // $NAMA_Dokter_BPJS = $dtSEP['NAMA_Dokter_BPJS'];
        $nonikktpBPJS = $dtSEP['NO_NIK'];
        $NoMRBPJS = $dtSEP['NO_MR'];
        $NoHpBPJS  = $dtSEP['NO_TELEPON'];
        $KodePoliklinikBPJS =  $dtSEP['kodeunitbpjs'];
        $NamaPoliklinikBPJS = $dtSEP['NamaBPJS'];
        $pasienbaru = $dtSEP['MR_ISNEW'];
        $TglSEP = $dtSEP['TGL_SEP'];
        $KodeDokterBPJS = $dtSEP['ID_Dokter_BPJS'];
        $NamaDokterBPJS = $dtSEP['namadokter'];
        $NO_SPRI = $dtSEP['NO_SPRI'];
        $NO_RUJUKAN = $dtSEP['NO_RUJUKAN'];

        if ($NO_SPRI = null) {
            $nomorreferensi = $NO_SPRI;
        } else {
            $nomorreferensi = $NO_RUJUKAN;
        }
        $nomorantrean = $dtSEP['NoAntrianAll'];
        $IDJadwal = $dtSEP['ID_JadwalPraktek'];
        $SessionPoli = $dtSEP['SessionPoli'];
        $IdDokterSIMRS = $dtSEP['IdDokterSIMRS'];
        $arraynomorantrean = preg_split("/\-/", $nomorantrean);
        $angkaantrean = $arraynomorantrean[1];
        $waktux = Utils::seCurrentDateTime();
        $estimasi2 = strtotime($waktux);
        $estimasidilayani = $estimasi2 * 1000;

        //waktu
        $datename  = date("l", strtotime($TglSEP));
        $this->db->query("SELECT Senin_Waktu,Selasa_Waktu,Rabu_Waktu,
                        Kamis_Waktu,Jumat_Waktu,Sabtu_Waktu,Minggu_Waktu,
                        Senin_Max_NonJKN,Senin_Max_JKN,Selasa_Max_JKN,Selasa_Max_NonJKN,Rabu_Max_JKN,Rabu_Max_NonJKN,
                        Kamis_Max_JKN,Kamis_Max_NonJKN,Jumat_Max_JKN,Jumat_Max_NonJKN,Sabtu_Max_JKN,Sabtu_Max_NonJKN,
                        Minggu_Max_JKN,Minggu_Max_NonJKN
                        FROM MasterdataSQL.DBO.JadwalPraktek WHERE ID=:IDJadwal");
        $this->db->bind('IDJadwal', $IDJadwal);
        $dtjdwl =  $this->db->single();
        $jampraktek = $dtjdwl['Minggu_Waktu'];
        if ($datename == "Sunday") {
            $jampraktek = $dtjdwl['Minggu_Waktu'];
            $Max_NonJKN = $dtjdwl['Minggu_Max_NonJKN'];
            $Max_JKN = $dtjdwl['Minggu_Max_JKN'];
        } elseif ($datename == "Monday") {
            $jampraktek = $dtjdwl['Senin_Waktu'];
            $Max_NonJKN = $dtjdwl['Senin_Max_NonJKN'];
            $Max_JKN = $dtjdwl['Senin_Max_JKN'];
        } elseif ($datename == "Tuesday") {
            $jampraktek = $dtjdwl['Selasa_Waktu'];
            $Max_NonJKN = $dtjdwl['Selasa_Max_NonJKN'];
            $Max_JKN = $dtjdwl['Selasa_Max_JKN'];
        } elseif ($datename == "Wednesday") {
            $jampraktek = $dtjdwl['Rabu_Waktu'];
            $Max_NonJKN = $dtjdwl['Rabu_Max_NonJKN'];
            $Max_JKN = $dtjdwl['Rabu_Max_JKN'];
        } elseif ($datename == "Thursday") {
            $jampraktek = $dtjdwl['Kamis_Waktu'];
            $Max_NonJKN = $dtjdwl['Kamis_Max_NonJKN'];
            $Max_JKN = $dtjdwl['Kamis_Max_JKN'];
        } elseif ($datename == "Friday") {
            $jampraktek = $dtjdwl['Jumat_Waktu'];
            $Max_NonJKN = $dtjdwl['Jumat_Max_NonJKN'];
            $Max_JKN = $dtjdwl['Jumat_Max_JKN'];
        } elseif ($datename == "Saturday") {
            $jampraktek = $dtjdwl['Sabtu_Waktu'];
            $Max_NonJKN = $dtjdwl['Sabtu_Max_NonJKN'];
            $Max_JKN = $dtjdwl['Sabtu_Max_JKN'];
        }

        // Jumlah antrian Saat ini
        $this->db->query("SELECT COUNT(ID) AS JUMLAHJKN FROM PerawatanSQL.DBO.Visit
                where replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-')=:ApmDate
                and Doctor_1=:DoctorID and JamPraktek=:JamPraktek and batal='0'
                and perusahaan='313' and PatientType='5'");
        $this->db->bind('JamPraktek', $SessionPoli);
        $this->db->bind('DoctorID', $IdDokterSIMRS);
        $this->db->bind('ApmDate', $TglSEP);
        $datallantrian =  $this->db->single();
        $JUMLAHJKN = $datallantrian['JUMLAHJKN'];

        $this->db->query("SELECT COUNT(ID) AS JUMLAHNONJKN FROM PerawatanSQL.DBO.Visit
                        where replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-')=:ApmDate and Doctor_1=:DoctorID 
                        and JamPraktek=:JamPraktek and batal='0'
                        and id not in(
                                SELECT ID  FROM PerawatanSQL.DBO.Visit
                                where replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-')=:ApmDate2 
                                and Doctor_1=:DoctorID2 and JamPraktek=:JamPraktek2 and batal='0'
                                and perusahaan='313' and PatientType='5'
                        ) ");
        $this->db->bind('JamPraktek', $SessionPoli);
        $this->db->bind('JamPraktek2', $SessionPoli);
        $this->db->bind('DoctorID', $IdDokterSIMRS);
        $this->db->bind('DoctorID2', $IdDokterSIMRS);
        $this->db->bind('ApmDate', $TglSEP);
        $this->db->bind('ApmDate2', $TglSEP);
        $datasdhpgl =  $this->db->single();
        $JUMLAHNONJKN = $datasdhpgl['JUMLAHNONJKN'];




        $sisakuotajkn = $Max_JKN - $JUMLAHJKN;
        $sisakuotanonjkn = $Max_NonJKN - $JUMLAHNONJKN;

        $keterangan = "Peserta harap 30 menit lebih awal guna pencatatan administrasi.";

        $session = SessionManager::getCurrentSession();
        $userid = $session->username;
        $token = $session->token;
        $namauserx = $session->name;
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS_Antrian($tStamp);
        $dateNows = Utils::seCurrentDateTime();
        $datenownotfull = Utils::datenowcreateNotFull();
        // update ke tabel sep dulu untuk waktu task nya....
        $this->db->query("SELECT Task1
                        FROM PerawatanSQL.DBO.BPJS_T_SEP
                        WHERE NO_REGISTRASI=:Noreg ");
        $this->db->bind('Noreg', $Noreg);
        $this->db->execute();
        $datarow =  $this->db->single();
        if ($datarow['Task1'] == null) {
            $this->db->query("UPDATE PerawatanSQL.DBO.BPJS_T_SEP SET Task1=:task4time
                                WHERE NO_REGISTRASI=:kodebookingx");
            $this->db->bind('kodebookingx', $Noreg);
            $this->db->bind('task4time', $waktux);
            $this->db->execute();
        }
        curl_setopt_array($curl, array(
            CURLOPT_URL =>  URL_BPJS_ANTRIAN . 'antrean/add',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                        "kodebooking": "' . $Noreg . '",
                        "jenispasien": "' . $jenispasien . '",
                        "nomorkartu": "' . $nokartubpjs . '",
                        "nik": "' . $nonikktpBPJS . '",
                        "nohp": "' . $NoHpBPJS . '",
                        "kodepoli": "' . $KodePoliklinikBPJS . '",
                        "namapoli": "' . $NamaPoliklinikBPJS . '",
                        "pasienbaru": "' . $pasienbaru . '",
                        "norm":"' . $NoMRBPJS . '",
                        "tanggalperiksa": "' . $TglSEP . '",
                        "kodedokter": "' . $KodeDokterBPJS . '",
                        "namadokter": "' . $NamaDokterBPJS . '",
                        "jampraktek": "' . $jampraktek . '",
                        "jeniskunjungan": "' . $AntrolJenisKunungan . '",
                        "nomorreferensi": "' . $nomorreferensi . '",
                        "nomorantrean": "' . $nomorantrean . '",
                        "angkaantrean": "' . $angkaantrean . '",
                        "estimasidilayani": "' . $estimasidilayani . '",
                        "sisakuotajkn": "' . $sisakuotajkn . '",
                        "kuotajkn": "' . $Max_JKN . '",
                        "sisakuotanonjkn": "' . $sisakuotanonjkn . '",
                        "kuotanonjkn": "' . $Max_NonJKN . '",
                        "keterangan": "' . $keterangan . '"
                        }',
            CURLOPT_HTTPHEADER => $headerbpjs,
        ));
        $output = curl_exec($curl);
        // tutup curl 
        curl_close($curl);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metadata']['code'] == "200") {

            // CARI DULU NO BOOKING, APAKAH DARI MOBILE JKN 
            $this->db->query("SELECT NoRegistrasi,NoBooking 
                            FROM PerawatanSQL.DBO.Apointment WHERE NoRegistrasi=:NoRegistrasi");
            $this->db->bind('NoRegistrasi', $TglSEP);
            $dtaptmn =  $this->db->single();
            $dtrowCount =  $this->db->rowCount();
            if ($dtrowCount > 0) {
                $kodebookingx = $dtaptmn['NoRegistrasi'];
            } else {
                $kodebookingx = $Noreg;
            }


            $curl = curl_init();
            $taskid = "1";

            curl_setopt_array($curl, array(
                CURLOPT_URL =>  URL_BPJS_ANTRIAN . 'antrean/updatewaktu',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '                                                
                    {
                        "kodebooking": "' . $kodebookingx . '",
                        "taskid":  "' . $taskid . '",
                        "waktu": "' . $estimasidilayani . '"
                    }
                        ',
                CURLOPT_HTTPHEADER => $headerbpjs,
            ));
            $output = curl_exec($curl);
            // tutup curl 
            curl_close($curl);
            // ubah string JSON menjadi array
            $JsonData = json_decode($output, TRUE);
            if ($JsonData['metadata']['code'] == "200") {
                $this->db->query("INSERT INTO perawatanSQL.dbo.BPJS_TASKID_LOG 
                                    (KODE_TRANSAKSI,WAKTU,TASK_ID,DATE_CREATE) 
                                    VALUES 
                                    (:kodebooking,:waktu,:taskid,:DATE_CREATE)");
                $this->db->bind('kodebooking', $kodebookingx);
                $this->db->bind('waktu', $estimasidilayani);
                $this->db->bind('taskid', $taskid);
                $this->db->bind('DATE_CREATE', $waktux);
                $this->db->execute();

                $callback = array(
                    'status' => 'success',
                    'Max_JKN' => 'tes',
                );
                return $callback;
            }
        } else {



            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metadata']['message'],
                'KodeDokterBPJS' => $KodeDokterBPJS,
                'NamaDokterBPJS' => $NamaDokterBPJS,
                'datename' => $datename
            );
            return $callback;
        }
    }

    public function UpdateNoSEP($data)
    {
        try {
            $this->db->transaksi();
            $NOID_Reg = $data['NOID_Reg'];
            $NoSEPBaru = $data['NoSEPBaru'];
            $NoSEPLama = $data['NoSEPLama'];
            $JenisPasien = $data['JenisPasien'];
            $HakKelasBPJS = $data['hakKelasBPJS'];
            $PRB = $data['keteranganprbBPJS'];
            $Desc_INACBG = $data['diagnosaInacbg'];
            $Total_INACBGs = $data['nilai_Gruper'];
            $PerkiraanLOS = $data['lama_dirawat'];
            $Noreg = $data['Noreg'];
            $NamaJaminan = "BPJS Kesehatan";
            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $namauserx = $session->name;
            // $kodebooking = $data['kodebooking'];
            $NoPesertaBPJS = $data['NoPesertaBPJS'];
            $NO_RUJUKAN = $data['NO_RUJUKAN'];

            if (strlen($NoSEPBaru) != 19) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No SEP Harus 19 Digit !',
                );
                return $callback;
                exit;
            }


            if ($JenisPasien == 'RAJAL') {

                $this->db->query("SELECT NO_SEP,NO_REGISTRASI
                FROM PerawatanSQL.dbo.BPJS_T_SEP WHERE NO_REGISTRASI=:NO_REGISTRASI2");
                $this->db->bind('NO_REGISTRASI2', $Noreg);
                $dataSep =  $this->db->single();
                $xnosep = $dataSep['NO_SEP'];
                $dtrowCount =  $this->db->rowCount();
                // $dataSep =  $this->getSEPbyNosep($data);
                // $dataSepp = $this->GoBPJSCekKepesertaan($data);
                // $dataSeppp = $this->setDataSEPRujukanByID($data);
                $this->db->query("SELECT a.unit,b.NamaBPJS,b.CodeSubBPJS,replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-') as tglKunjungan 
                FROM PerawatanSQL.dbo.Visit a
                inner join MasterdataSQL.dbo.mstrunitperwatan b on a.unit = b.ID 
                WHERE NoRegistrasi=:NO_REGISTRASI2");
                $this->db->bind('NO_REGISTRASI2', $Noreg);
                $data2 =  $this->db->single();
                // var_dump($dataSep);

                // var_dump($dataSeppp);
                // // exit;

                // var_dump($dataSep);
                // exit;

                //if ga ada datanya data=0 maka insert
                if ($dtrowCount == "0") {

                    $dataSep = $this->getSEPbyNosep($data);


                    $callbackx = array(
                        'NoPesertaBPJS' => $dataSep['hasil']['peserta']['noKartu']
                    );

                    $dataSepp = $this->GoBPJSCekKepesertaan($callbackx);

                    $dataSeppp = $this->setDataSEPRujukanByID($data);

                    if ($data2['tglKunjungan'] != $dataSep['hasil']['tglSep']) {
                        $callback = array(
                            'status' => 'warning',
                            'errorname' => 'Tanggal SEP : ' . $dataSep['hasil']['tglSep'] . '. Tidak sama dengan Tanggal Berobat Pasien : ' . $data2['tglKunjungan']  . ' !',
                        );
                        echo json_encode($callback);
                        exit;
                    }
                    // var_dump($dataSep['hasil']['tglSep']);
                    // exit;
                    // jika status dari bpjs warning stop aja
                    // if ($dataSep['status'] == "warning") {
                    //     $callback = array(
                    //         'status' => 'warning',
                    //         'errorname' => '',
                    //     );
                    //     echo json_encode($callback);
                    //     exit;
                    // }

                    // // GET SEP DI WS BPJS

                    if ($dataSep['status'] == "success") {
                        $idPesertaBPJS = $dataSep['hasil']['peserta']['noKartu'];
                        $TglSEP = $dataSep['hasil']['tglSep'];
                        $namapesertaBPJS = $dataSep['hasil']['peserta']['nama'];
                        $nosep = $dataSep['hasil']['noSep'];
                        $NoMRBPJS = $dataSep['hasil']['peserta']['noMr'];
                        $jenisKelaminNamaBPJSS = $dataSep['hasil']['peserta']['kelamin'];
                        if ($jenisKelaminNamaBPJSS == "P") {
                            $jenisKelaminNamaBPJS = "PEREMPUAN";
                        } elseif ($jenisKelaminNamaBPJSS == "L") {
                            $jenisKelaminNamaBPJS = "LAKI-LAKI";
                        }
                        $jenisPesertaNamaBPJS = $dataSep['hasil']['peserta']['jnsPeserta'];
                        $cobNamaAsuransiBPJS = $dataSep['hasil']['cob'];
                        $NamaPoliklinikBPJS = $dataSep['hasil']['poli'];
                        $KodePoliklinikBPJS = $data2['CodeSubBPJS'];

                        $NamaDokterBPJS = $dataSep['hasil']['dpjp']['nmDPJP'];
                        $KodeDokterBPJS = $dataSep['hasil']['dpjp']['kdDPJP'];
                        $NamaDiagnosaBPJS = $dataSeppp['hasil']['diagnosa'];
                        $str = substr($NamaDiagnosaBPJS, strpos($NamaDiagnosaBPJS, '-'));
                        $str = str_replace("- ", "", $str);
                        $code_diagnosa = strtok($NamaDiagnosaBPJS, ' -');
                        // var_dump($code_diagnosa);
                        // exit;
                        $norujukan = $dataSep['hasil']['noRujukan'];
                        $iscatarakBPJS = $dataSep['hasil']['katarak'];
                        $isCobBPJS = $dataSep['hasil']['cob'];
                        $TglKejadianBPJS = $dataSep['hasil']['lokasiKejadian']['tglKejadian'];
                        $LakaLantasKetBPJS = $dataSep['hasil']['lokasiKejadian']['ketKejadian'];
                        $SuplesiBPJSProvinsi = $dataSep['hasil']['lokasiKejadian']['kdProp'];
                        $SuplesiBPJSKabupaten = $dataSep['hasil']['lokasiKejadian']['kdKab'];
                        $SuplesiBPJSKecamatan = $dataSep['hasil']['lokasiKejadian']['kdKec'];
                        $dateNows = Utils::seCurrentDateTime();
                        // $namaJenislay = $dataSep['hasil']['jnsPelayanan'];
                        $namaJenislay = "R. Jalan";
                        $hakKelasBPJS = $dataSep['hasil']['peserta']['hakKelas'];
                        $iscatatanBPJS = $dataSep['hasil']['catatan'];
                        $TglLahirBPJS = $dataSep['hasil']['peserta']['tglLahir'];
                        $PembiayaanNiakKelasBPJS = $dataSep['hasil']['klsRawat']['pembiayaan'];
                        $NoSuratKontrolBPJS = $dataSep['hasil']['kontrol']['noSurat'];
                        $PenujangBPJS = $dataSep['hasil']['kdPenunjang']['kode'];
                        $PenanggungJawabBiaya = $dataSep['hasil']['klsRawat']['penanggungJawab'];
                        $idhakKelasBPJS = $dataSep['hasil']['klsRawat']['klsRawatHak'];

                        $AsesmentPelayananBPJS = $dataSep['hasil']['assestmenPel']['kode'];
                        $tujuankunjungan = $dataSep['hasil']['tujuanKunj']['kode'];
                        $flagProcedure = $dataSep['hasil']['flagProcedure']['kode'];
                        $LakaLantasBPJS = $dataSep['hasil']['informasi']['nmstatusKecelakaan'];
                        $nonikktpBPJS = $dataSepp['hasil']['1']['peserta']['nik'];
                        $keteranganprbBPJS = $dataSepp['hasil']['1']['peserta']['informasi']['prolanisPRB'];
                        $jenisPesertaKodeBPJS = $dataSepp['hasil']['1']['peserta']['jenisPeserta']['kode'];
                        $NoHpBPJS = $dataSepp['hasil']['1']['peserta']['mr']['noTelepon'];
                        $namafaskesBPJS = $dataSeppp['hasil']['provPerujuk']['nmProviderPerujuk'];
                        $kdProviderBPJS = $dataSeppp['hasil']['provUmum']['kdProvider'];
                        $nmProviderBPJS = $dataSeppp['hasil']['provUmum']['nmProvider'];
                        $idfaskesBPJS = $dataSeppp['hasil']['provPerujuk']['kdProviderPerujuk'];
                        $TglRujukan = $dataSeppp['hasil']['provPerujuk']['tglRujukan'];
                        $JenisRujukanFaskesBPJS = $dataSeppp['hasil']['provPerujuk']['asalRujukan'];
                        if ($JenisRujukanFaskesBPJS == "1") {
                            $JenisFaskesNamaBPJS = "Faskes 1";
                        } elseif ($JenisRujukanFaskesBPJS == "2") {
                            $JenisFaskesNamaBPJS = "Faskes 2";
                        }

                        $this->db->query("INSERT INTO perawatanSQL.dbo.BPJS_T_SEP (NO_SEP,NO_REGISTRASI,NO_KARTU,TGL_SEP,
                            NO_MR,NAMA_PESERTA,JENIS_KELAMIN,JENIS_PESERTA
                            ,COB,JENIS_RAWAT
                            ,KODE_POLI,NAMA_POLI,KODE_DOKTER,NAMA_DOKTER,
                            KODE_DIAGNOSA,NAMA_DIAGNOSA,NO_TELEPON,PENJAMIN,KELAS_RAWAT,CATATAN,TGL_LAHIR,
                            KODE_PERUJUK,NAMA_PERUJUK
                            ,NO_RUJUKAN,NO_SPRI,NO_NIK,KODE_JENIS_PESERTA,IS_EKSEKUTIF,IS_KATARAK,IS_COB,
                            COB_NO_ASURANSI,KODE_JENIS_RAWAT,NAIK_KELAS,NAIK_KELAS_ID,PENANGGUNG_JAWAB,KODE_KELAS_RAWAT
                            ,KODE_PPK_PERUJUK,NAMA_PPK_PERUJUK,KETERANGAN_PRB,TUJUAN_KUNJUNGAN,FLAG_PROCEDURE,PENUNJANG,
                            ASESMENT_PELAYANAN,IS_LAKA_LANTAS,TGL_LAKA_LANTAS,KET_LAKA_LANTAS,IS_SUPLESI,NO_SUPLESI,
                            PROV_KODE,PROV_NAMA,KABUPATEN_KODE,KABUPATEN_NAMA,KECAMATAN_KODE,KECAMATAN_NAMA
                            ,KODE_ASAL_FASKES,NAMA_ASAL_FASKES,TGL_RUJUKAN,TGL_CREATE,USER_CREATE)
                            VALUES 
                            (:NOSEP,:NO_REGISTRASI,:NO_KARTU,:TGL_SEP,
                            :NO_MR,:NAMA_PESERTA,:JENIS_KELAMIN,:JENIS_PESERTA
                            ,:COB,:JENIS_RAWAT
                            ,:KODE_POLI,:NAMA_POLI,:KODE_DOKTER,:NAMA_DOKTER,
                            :KODE_DIAGNOSA,:NAMA_DIAGNOSA,:NO_TELEPON,:PENJAMIN,:KELAS_RAWAT,:CATATAN,:TGL_LAHIR,
                            :KODE_PERUJUK,:NAMA_PERUJUK
                            ,:NO_RUJUKAN,:NO_SPRI,:NO_NIK,:KODE_JENIS_PESERTA,:IS_EKSEKUTIF,:IS_KATARAK,:IS_COB,
                            :COB_NO_ASURANSI,:KODE_JENIS_RAWAT,:NAIK_KELAS,:NAIK_KELAS_ID,:PENANGGUNG_JAWAB,:KODE_KELAS_RAWAT
                            ,:KODE_PPK_PERUJUK,:NAMA_PPK_PERUJUK,:KETERANGAN_PRB,:TUJUAN_KUNJUNGAN,:FLAG_PROCEDURE,:PENUNJANG,
                            :ASESMENT_PELAYANAN,:IS_LAKA_LANTAS,:TGL_LAKA_LANTAS,:KET_LAKA_LANTAS,:IS_SUPLESI,:NO_SUPLESI,
                            :PROV_KODE,:PROV_NAMA,:KABUPATEN_KODE,:KABUPATEN_NAMA,:KECAMATAN_KODE,:KECAMATAN_NAMA
                            ,:KODE_ASAL_FASKES,:NAMA_ASAL_FASKES,:TGL_RUJUKAN,:TGL_CREATE,:USER_CREATE)");
                        $this->db->bind('TGL_CREATE', $dateNows);
                        $this->db->bind('USER_CREATE', $namauserx);

                        $this->db->bind('KODE_ASAL_FASKES', $JenisRujukanFaskesBPJS);
                        $this->db->bind('NAMA_ASAL_FASKES', $JenisFaskesNamaBPJS);
                        $this->db->bind('TGL_RUJUKAN', $TglRujukan);

                        $this->db->bind('NOSEP', $nosep);
                        $this->db->bind('NO_REGISTRASI', $Noreg);
                        $this->db->bind('NO_KARTU', $idPesertaBPJS);
                        $this->db->bind('TGL_SEP', $TglSEP);
                        $this->db->bind('NO_MR', $NoMRBPJS);
                        $this->db->bind('NAMA_PESERTA', $namapesertaBPJS);
                        $this->db->bind('JENIS_KELAMIN', $jenisKelaminNamaBPJS);
                        $this->db->bind('JENIS_PESERTA', $jenisPesertaNamaBPJS);
                        $this->db->bind('COB', $cobNamaAsuransiBPJS);
                        $this->db->bind('JENIS_RAWAT', $namaJenislay);

                        $this->db->bind('KODE_POLI', $KodePoliklinikBPJS);

                        $this->db->bind('NAMA_POLI', $NamaPoliklinikBPJS);
                        $this->db->bind('KODE_DOKTER', $KodeDokterBPJS);
                        $this->db->bind('NAMA_DOKTER', $NamaDokterBPJS);

                        $this->db->bind('KODE_DIAGNOSA', $code_diagnosa);

                        $this->db->bind('NAMA_DIAGNOSA', $str);

                        $this->db->bind('NO_TELEPON', $NoHpBPJS);

                        $this->db->bind('PENJAMIN', $PembiayaanNiakKelasBPJS);
                        $this->db->bind('KELAS_RAWAT', $hakKelasBPJS);
                        $this->db->bind('CATATAN', $iscatatanBPJS);
                        $this->db->bind('TGL_LAHIR', $TglLahirBPJS);

                        $this->db->bind('KODE_PERUJUK', $kdProviderBPJS);
                        $this->db->bind('NAMA_PERUJUK', $nmProviderBPJS);

                        $this->db->bind('KODE_PPK_PERUJUK', $idfaskesBPJS);
                        $this->db->bind('NAMA_PPK_PERUJUK', $namafaskesBPJS);

                        $this->db->bind('NO_RUJUKAN', $norujukan);
                        $this->db->bind('NO_SPRI', $NoSuratKontrolBPJS);

                        $this->db->bind('NO_NIK', $nonikktpBPJS);
                        $this->db->bind('KODE_JENIS_PESERTA', $jenisPesertaKodeBPJS);
                        $this->db->bind('IS_EKSEKUTIF', '');

                        $this->db->bind('IS_KATARAK', $iscatarakBPJS);
                        $this->db->bind('IS_COB', $isCobBPJS);

                        $this->db->bind('COB_NO_ASURANSI', '');

                        $this->db->bind('KODE_JENIS_RAWAT', '');
                        $this->db->bind('NAIK_KELAS', '');

                        $this->db->bind('NAIK_KELAS_ID', '');
                        $this->db->bind('PENANGGUNG_JAWAB', $PenanggungJawabBiaya);
                        $this->db->bind('KODE_KELAS_RAWAT', $idhakKelasBPJS);

                        $this->db->bind('KETERANGAN_PRB', $keteranganprbBPJS);
                        $this->db->bind('TUJUAN_KUNJUNGAN', $tujuankunjungan);

                        $this->db->bind('FLAG_PROCEDURE', $flagProcedure);
                        $this->db->bind('PENUNJANG', $PenujangBPJS);
                        $this->db->bind('ASESMENT_PELAYANAN', $AsesmentPelayananBPJS);
                        $this->db->bind('IS_LAKA_LANTAS', $LakaLantasBPJS);
                        $this->db->bind('TGL_LAKA_LANTAS', $TglKejadianBPJS);
                        $this->db->bind('KET_LAKA_LANTAS', $LakaLantasKetBPJS);

                        $this->db->bind('IS_SUPLESI', '0');
                        $this->db->bind('NO_SUPLESI', '');

                        $this->db->bind('PROV_KODE', $SuplesiBPJSProvinsi);

                        $this->db->bind('PROV_NAMA', '');

                        $this->db->bind('KABUPATEN_KODE', $SuplesiBPJSKabupaten);

                        $this->db->bind('KABUPATEN_NAMA', '');

                        $this->db->bind('KECAMATAN_KODE', $SuplesiBPJSKecamatan);

                        $this->db->bind('KECAMATAN_NAMA', '');
                        $this->db->execute();
                    }

                    // // if jika ada data nya maka Update
                } else {
                    $dataSep = $this->getSEPbyNosep($data);

                    if ($data2['tglKunjungan'] != $dataSep['hasil']['tglSep']) {
                        $callback = array(
                            'status' => 'warning',
                            'errorname' => 'Tanggal SEP : ' . $dataSep['hasil']['tglSep'] . '. Tidak Sama dengan Tanggal Berobat Pasien : ' . $data2['tglKunjungan']  . ' !',
                        );
                        echo json_encode($callback);
                        exit;
                    }
                    $this->db->query("UPDATE PerawatanSQL.dbo.BPJS_T_SEP set 
                    NO_SEP=:NoSEPBaru,NO_RUJUKAN=:NO_RUJUKAN,NO_KARTU=:NO_KARTU--,NO_NIK=:NO_NIK 
                    WHERE NO_REGISTRASI=:Noreg
                    ");
                    $this->db->bind('NoSEPBaru', $NoSEPBaru);
                    $this->db->bind('NO_RUJUKAN', $NO_RUJUKAN);
                    $this->db->bind('NO_KARTU', $NoPesertaBPJS);
                    $this->db->bind('Noreg', $Noreg);
                    $this->db->execute();
                }
                // var_dump($dtrowCount);
                // exit;
                $tsql = "UPDATE  PerawatanSQL.DBO.Visit SET NoSEP=:NoSEPBaru,HakKelasBPJS=:HakKelasBPJS,PRB=:PRB
                            WHERE NoRegistrasi=:Noreg";
                $qxr = "SELECT NoRegistrasi as noreg
                                  FROM PerawatanSQL.dbo.Visit
                                  Where NoRegistrasi=:Noreg";

                $this->db->query($tsql);
                $this->db->bind('Noreg', $Noreg);
                $this->db->bind('NoSEPBaru', $NoSEPBaru);
                // $this->db->bind('NOID_Reg', $NOID_Reg);
                $this->db->bind('HakKelasBPJS', $HakKelasBPJS);
                $this->db->bind('PRB', $PRB);
            } elseif ($JenisPasien == 'RANAP') {
                $tsql = "UPDATE RawatInapSQL.dbo.Inpatient SET NoSEP=:NoSEPBaru,HakKelasBPJS=:HakKelasBPJS,PRB=:PRB,Desc_INACBG=:Desc_INACBG,Total_INACBGs=:Total_INACBGs
                ,PerkiraanLOS=:PerkiraanLOS
                            WHERE InpatientID=:Noreg";
                $qxr = "SELECT NoRegRI as noreg
                                  FROM RawatInapSQL.dbo.Inpatient
                                  Where InpatientID=:Noreg";

                $this->db->query($tsql);
                $this->db->bind('NoSEPBaru', $NoSEPBaru);
                $this->db->bind('Noreg', $Noreg);
                $this->db->bind('HakKelasBPJS', $HakKelasBPJS);
                $this->db->bind('PRB', $PRB);
                $this->db->bind('Desc_INACBG', $Desc_INACBG);
                $this->db->bind('Total_INACBGs', $Total_INACBGs);
                $this->db->bind('PerkiraanLOS', $PerkiraanLOS);
            }
            $this->db->execute();
            $this->db->query($qxr);
            $this->db->bind('Noreg', $Noreg);
            $data =  $this->db->single();
            $noreg = $data['noreg'];
            // var_dump($dtrowCount);
            // exit;
            //INSERT TZ_LOG
            $info = "Ganti No SEP - SEP Lama: " . $NoSEPLama;
            $this->db->query("INSERT INTO  SysLog.dbo.TZ_Log_Button (idtrs,noregistrasi,nama_biling,petugas_batal,tgl_batal) VALUES
                    (:NOID_Reg,:noreg,:info,:namauserx,:datenowcreate)");
            $this->db->bind('NOID_Reg', $NOID_Reg);
            $this->db->bind('noreg', $noreg);
            $this->db->bind('info', $info);
            $this->db->bind('namauserx', $namauserx);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->execute();
            // var_dump($data);
            // exit;
            //Insert DataRWJ dan DataRWI
            if ($JenisPasien == 'RAJAL') {
                $this->db->query("UPDATE DashboardData.dbo.dataRWJ SET 
                      NoSep=:nosep,HakKelasBPJS=:HakKelasBPJS,PRB=:PRB
                      WHERE NoRegistrasi=:noregistrasi");
                $this->db->bind('nosep', $NoSEPBaru);
                $this->db->bind('noregistrasi', $noreg);
                $this->db->bind('HakKelasBPJS', $HakKelasBPJS);
                $this->db->bind('PRB', $PRB);

                $this->db->execute();
            } elseif ($JenisPasien == 'RANAP') {
                $this->db->query("UPDATE DashboardData.dbo.dataRWI SET 
                        NoSep=:nosep,HakKelasBPJS=:HakKelasBPJS,PRB=:PRB
                        WHERE NoRegistrasi=:noregistrasi");
                $this->db->bind('nosep', $NoSEPBaru);
                $this->db->bind('noregistrasi', $noreg);
                $this->db->bind('HakKelasBPJS', $HakKelasBPJS);
                $this->db->bind('PRB', $PRB);

                $this->db->execute();
            }

            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
        // var_dump($data);
        // exit;
    }

    function getSEPbyNosep($data)
    {
        $NoSEPBaru = $data['NoSEPBaru'];
        // persiapkan curl
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS . "SEP/$NoSEPBaru");
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
        // set time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            $callback = array(
                'status' => 'success',
                'hasil' => $ResultEncriptLzString['1'],
            );

            return $callback;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']

            );
            return $callback;
        }
        // var_dump($callback);
    }
    function GoBPJSCekKepesertaan($data)
    {
        $jenisPencarian = "2";
        $NoPesertaBPJS = $data['NoPesertaBPJS'];
        // $JenisRujukanFaskesBPJSx = $data['JenisRujukanFaskesBPJSx'];
        $dateNow = Utils::datenowcreateNotFull();
        if ($jenisPencarian == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Masukan Jenis Pencarian !',
            );
            echo json_encode($callback);
            exit;
        }

        if ($NoPesertaBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Masukan Kode Peserta/No. Rujukan !',
            );
            echo json_encode($callback);
            exit;
        }


        if ($jenisPencarian == "1") {
            $urlApi = "Peserta/sep/$NoPesertaBPJS/tglSEP/$dateNow";
        } elseif ($jenisPencarian == "2") {
            $urlApi = "Peserta/nokartu/$NoPesertaBPJS/tglSEP/$dateNow";
        }
        // } elseif ($jenisPencarian == "3") {
        //     if ($JenisRujukanFaskesBPJSx == "1") {
        //         $urlApi = "Rujukan/$NoPesertaBPJS";
        //     } else {
        //         $urlApi = "Rujukan/RS/$NoPesertaBPJS";
        //     }
        // }
        //
        // persiapkan curl
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS . $urlApi);
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
        // set time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            // $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));

            //echo json_encode($output);
            $callback = array(
                'status' => 'success',
                'hasil' => $ResultEncriptLzString,
            );
            return $callback;
            // var_dump($ResultEncriptLzString);
            // exit;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']

            );
            return $callback;
        }
    }

    public function PrintAkadIjarah($data)
    {
        try {
            $this->db->query("SELECT a.*,replace(CONVERT(VARCHAR(11), TglCreate, 111), '/','-') as TglCreate,replace(CONVERT(VARCHAR(11), TangalLahir, 111), '/','-') as TglLahir,case when JenisKelamin='P' then 'Perempuan' else 'Laki-laki' end as JenisKelamin ,b.FileDocument as TTDPetugas,TTD_PasienWali
            FROM Billing_Pasien.dbo.TDocumentIjarohAgreements  a
            left join MasterDataSQL.dbo.Employees b on a.PetugasTTD_ID=b.ID WHERE a.ID=:id");
            $this->db->bind('id', $data['notrs']);
            $data =  $this->db->single();

            $pasing['ID'] = $data['ID'];
            $pasing['NoEpisode'] = $data['NoEpisode'];
            $pasing['NoRegistrasi'] = $data['NoRegistrasi'];
            $pasing['TglCreate'] = date('d/m/Y', strtotime($data['TglCreate']));
            $pasing['Petugas'] = $data['Petugas'];
            $pasing['Divisi'] = $data['Divisi'];
            $pasing['NamaJenisPenanngungJawab'] = $data['NamaJenisPenanngungJawab'];
            $pasing['NamaPenanggungJawab'] = $data['NamaPenanggungJawab'];
            $pasing['AlamatPenanggungJawab'] = $data['AlamatPenanggungJawab'];
            $pasing['NoKtp'] = $data['NoKtp'];
            $pasing['Pekerjaan'] = $data['Pekerjaan'];
            $pasing['NoHandphone'] = $data['NoHandphone'];
            $pasing['NamaPasien'] = $data['NamaPasien'];
            $pasing['NoRM'] = $data['NoRM'];
            $pasing['JenisKelamin'] = $data['JenisKelamin'];
            $pasing['NIKPasien'] = $data['NIKPasien'];
            $pasing['TangalLahir'] = date('d/m/Y', strtotime($data['TangalLahir']));
            $pasing['LokasiPasien'] = $data['LokasiPasien'];
            $pasing['AwsUrlDocuments'] = $data['AwsUrlDocuments'];
            $pasing['uuid4'] = $data['DocTransactionID'];
            $pasing['TTDPetugas'] = $data['TTDPetugas'];
            $pasing['TTD_PasienWali'] = $data['TTD_PasienWali'];

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintAkadIjarahSign($data)
    {
        try {

            $this->db->query("SELECT a.*,replace(CONVERT(VARCHAR(11), a.TGL_CREATE, 111), '/','-') TglCreate FROM Billing_Pasien.dbo.T_SIGNATURE a
            inner join Billing_Pasien.dbo.TDocumentIjarohAgreements b on a.REFF_ID=b.ID WHERE b.ID=:id and a.GROUP_TRANSAKSI='AKAD IJAROH'");
            $this->db->bind('id', $data['notrs']);
            $data =  $this->db->single();

            $pasing['TglCreate_sign'] = date('d/m/Y', strtotime($data['TglCreate']));
            $pasing['UID'] = $data['UID'];
            $pasing['NAMA_PARAM_1'] = $data['NAMA_PARAM_1'];
            $pasing['IMAGE_PATH'] = $data['IMAGE_PATH'];
            $pasing['NAMA_PARAM_2'] = $data['NAMA_PARAM_2'];
            $pasing['IMAGE_PATH2'] = $data['IMAGE_PATH2'];
            $pasing['GROUP_TRANSAKSI'] = $data['GROUP_TRANSAKSI'];
            $pasing['NO_TRANSAKSI'] = $data['NO_TRANSAKSI'];
            $pasing['NO_REGISTRASI'] = $data['NO_REGISTRASI'];
            //$pasing['TGL_CREATE'] = $data['TGL_CREATE'];
            $pasing['USER_CREATE'] = $data['USER_CREATE'];
            $pasing['AWS_URL'] = $data['AWS_URL'];

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function uploadAWS_AkadIjaroh($data)
    {

        //$ip = ; // Ambil IP Address dari User 
        $doc_nomr = $data['listdata1']['ID'];
        //var_dump($data);exit;

        $bytes = random_bytes(20);
        $nama_file_baru  =     $doc_nomr . bin2hex($bytes) . "-" . date("YmdHis");
        $nama_file = 'AKADIJAROH-' . $doc_nomr . '.pdf';
        $grupdokumen = 'AKAD_IJAROH';

        /// AWS
        // Create an S3Client
        $s3Client = new S3Client([
            'version' => 'latest',
            'region'  => 'ap-southeast-1',
            'http'    => ['verify' => false],
            'credentials' => [
                'key'    => 'AKIAYV2M6ERJGUKK4QWQ',
                'secret' => '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'
            ]
        ]);
        $file_name = __DIR__ . '/../../public' . '/tmp/' . $nama_file;
        $source =   $file_name;
        $awsImages = '';
        $handle = fopen($source, 'r');
        try {
            $bucket = 'rsuyarsibucket';
            $key = basename($nama_file_baru);
            $result = $s3Client->putObject([
                'Bucket' => $bucket,
                'Key'    => 'digitalfiles/akadijaroh/' . $key,
                'Body'   => $handle,
                'ACL'    => 'public-read', // make file 'public', 
            ]);
            $awsImages = $result->get('ObjectURL');

            //close filenya
            fclose($handle);
            //hapus filenya 
            unlink($_SERVER["DOCUMENT_ROOT"] . 'SIKBREC/public/tmp/' . $nama_file);

            //return $this->SaveTTD_AkadIjaroh($data, $awsImages,$grupdokumen);
            return $this->SaveFile($data, $awsImages, $grupdokumen);
        } catch (MultipartUploadException $e) {

            return $e->getMessage();
        }
    }

    public function SaveFile($data, $awsImages, $grupdokumen)
    {
        if ($grupdokumen == 'AKAD_IJAROH') {
            $tablename = 'TDocumentIjarohAgreements';
        } elseif ($grupdokumen == 'GENERAL_CONSEN') {
            $tablename = 'TDocumentGeneralConsents';
        } elseif ($grupdokumen == 'HAK_DAN_KEWAJIBAN') {
            $tablename = 'TDocumentRightsandObligations';
        } elseif ($grupdokumen == 'TATA_TERTIB') {
            $tablename = 'TDocumentRegulations';
        } elseif ($grupdokumen == 'BIAYA_NONOPERASI') {
            $tablename = 'TDocumentEsitimatedNonOperationgCosts';
        } elseif ($grupdokumen == 'BIAYA_OPERASI') {
            $tablename = 'TDocumentEsitimatedOperationgCosts';
        } elseif ($grupdokumen == 'PERSETUJUAN_BIAYA') {
            $tablename = 'TDocumentApprovalTreatmentCosts';
        } elseif ($grupdokumen == 'PERSETUJUAN_SELISIH') {
            $tablename = 'TDocumentApprovalCostDifferents';
        } else {
            $callback = array(
                'status' => 'warning',
                'message' => ' Save Data Failed.',
            );
            return $callback;
        }

        $query2 = "UPDATE a
        SET a.AwsUrlDocuments=:AWS_URL
        FROM Billing_Pasien.dbo.TDocumentMasters a
        inner join Billing_Pasien.dbo." . $tablename . " b on a.Uuid=b.DocTransactionID
        WHERE ID=:id
        ";

        $query = "UPDATE Billing_Pasien.dbo." . $tablename . " SET AwsUrlDocuments=:AWS_URL WHERE ID=:id
        ";
        try {
            $this->db->transaksi();

            $this->db->query($query2);
            $this->db->bind('id', $data['listdata1']['ID']);
            $this->db->bind('AWS_URL', $awsImages);
            $this->db->execute();

            $this->db->query($query);
            $this->db->bind('id', $data['listdata1']['ID']);
            $this->db->bind('AWS_URL', $awsImages);
            $this->db->execute();

            $this->db->Commit();
            $callback = array(
                'status' => 'success',
                'message' => ' Upload Data Succesfully.',
                'aws_url' =>  $awsImages,
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => 'warning',
                'message' => $e,
            );
            return $callback;
        }
    }

    function setDataSEPRujukanByID($data)
    {
        $NoSEPBaru = $data['NoSEPBaru'];
        // persiapkan curl
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS . "RencanaKontrol/nosep/$NoSEPBaru");
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
        // set time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            $callback = array(
                'status' => 'success',
                'hasil' => $ResultEncriptLzString['1'],
            );
            return $callback;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']

            );
            return $callback;
        }
    }

    public function PrintHakdanKewajibanSign($data)
    {
        try {

            $this->db->query("SELECT *,replace(CONVERT(VARCHAR(11), TGL_CREATE, 111), '/','-') TglCreate FROM Billing_Pasien.dbo.T_SIGNATURE a
            inner join Billing_Pasien.dbo.TDocumentRightsandObligations b on a.REFF_ID=b.ID WHERE b.ID=:id and a.GROUP_TRANSAKSI='HAK DAN KEWAJIBAN'");
            $this->db->bind('id', $data['notrs']);
            $data =  $this->db->single();

            $pasing['TglCreate_sign'] = date('d/m/Y', strtotime($data['TglCreate']));
            $pasing['UID'] = $data['UID'];
            $pasing['NAMA_PARAM_1'] = $data['NAMA_PARAM_1'];
            $pasing['IMAGE_PATH'] = $data['IMAGE_PATH'];
            $pasing['NAMA_PARAM_2'] = $data['NAMA_PARAM_2'];
            $pasing['IMAGE_PATH2'] = $data['IMAGE_PATH2'];
            $pasing['GROUP_TRANSAKSI'] = $data['GROUP_TRANSAKSI'];
            $pasing['NO_TRANSAKSI'] = $data['NO_TRANSAKSI'];
            $pasing['NO_REGISTRASI'] = $data['NO_REGISTRASI'];
            //$pasing['TGL_CREATE'] = $data['TGL_CREATE'];
            $pasing['USER_CREATE'] = $data['USER_CREATE'];
            $pasing['AWS_URL'] = $data['AWS_URL'];
            $pasing['uuid4'] = $data['DocTransactionID'];

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintGeneralConsent($data)
    {
        try {
            $this->db->query("SELECT a.*,
            replace(CONVERT(VARCHAR(11), TglCreate, 111), '/','-') as TglCreate,
            replace(CONVERT(VARCHAR(11), TangalLahirPasien, 111), '/','-') as TangalLahirPasien,
            case when JenisKelamin='Laki-laki' then 'L' else 'P' end as JenisKelamin_Inisial ,
            case when JenisKelamin='Laki-laki' then 'M' else 'F' end as JenisKelamin_Eng ,
            case when JenisKelaminPasien='L' then 'M' else 'F' end as JenisKelaminPasienEng 
            ,case when consen_kuasa = 'MENYETUJUI' then 'Approve' else 'Deny' end as 'consen_kuasa_eng'
            ,case when consen_kondisiPasien = 'MENGIZINKAN' then 'Allow' else 'Disallow' end as 'consen_kondisiPasien_eng'
            ,case when consen_aksesKeluarga = 'MENGIZINKAN' then 'Allowing' else 'Not allowing' end as 'consen_aksesKeluarga_eng'
            ,case when consen_privasiKhusus = 'MENGINGINKAN' then 'I want' else 'Do not want' end as 'consen_privasiKhusus_eng'
            ,b.FileDocument as TTDPetugas,TTD_PasienWali
            FROM Billing_Pasien.dbo.TDocumentGeneralConsents a
            left join MasterDataSQL.dbo.Employees b on a.PetugasTTD_ID=b.ID
             WHERE a.ID=:id");
            $this->db->bind('id', $data['notrs']);
            $data =  $this->db->single();

            $pasing['TglCreate'] = date('d/m/Y', strtotime($data['TglCreate']));
            $pasing['ID'] = $data['ID'];
            $pasing['NoEpisode'] = $data['NoEpisode'];
            $pasing['NoRegistrasi'] = $data['NoRegistrasi'];
            $pasing['Petugas'] = $data['Petugas'];
            $pasing['Divisi'] = $data['Divisi'];
            $pasing['NamaJenisPenanngungJawab'] = $data['NamaJenisPenanngungJawab'];
            $pasing['NamaPenanggungJawab'] = $data['NamaPenanggungJawab'];
            $pasing['AlamatPenanggungJawab'] = $data['AlamatPenanggungJawab'];
            $pasing['NoKtp'] = $data['NoKtp'];
            $pasing['Pekerjaan'] = $data['Pekerjaan'];
            $pasing['NoHandphone'] = $data['NoHandphone'];
            $pasing['JenisKelamin'] = $data['JenisKelamin'];
            $pasing['JenisKelamin_Inisial'] = $data['JenisKelamin_Inisial'];
            $pasing['JenisKelamin_Eng'] = $data['JenisKelamin_Eng'];
            $pasing['Tahun'] = $data['Tahun'];
            $pasing['NamaPasien'] = $data['NamaPasien'];
            $pasing['NoRMPasien'] = $data['NoRMPasien'];
            $pasing['JenisKelaminPasien'] = $data['JenisKelaminPasien'];
            $pasing['JenisKelaminPasienEng'] = $data['JenisKelaminPasienEng'];
            $pasing['TangalLahirPasien'] = date('d/m/Y', strtotime($data['TangalLahirPasien']));
            $pasing['AgamaPasien'] = $data['AgamaPasien'];
            $pasing['NIKPasien'] = $data['NIKPasien'];
            $pasing['JenisPengenalPasien'] = $data['JenisPengenalPasien'];
            $pasing['AlamatPasien'] = $data['AlamatPasien'];
            $pasing['jaminan_bpjs'] = $data['jaminan_bpjs'];
            $pasing['jaminan_perusahaan'] = $data['jaminan_perusahaan'];
            $pasing['jaminan_asuransi'] = $data['jaminan_asuransi'];
            $pasing['jaminan_pribadi'] = $data['jaminan_pribadi'];
            $pasing['jaminan_namaPerusahaan'] = $data['jaminan_namaPerusahaan'];
            $pasing['consen_kuasa'] = $data['consen_kuasa'];
            $pasing['consen_kondisiPasien'] = $data['consen_kondisiPasien'];
            $pasing['consen_aksesKeluarga'] = $data['consen_aksesKeluarga'];
            $pasing['consen_privasiKhusus'] = $data['consen_privasiKhusus'];
            $pasing['consen_privasiKhusus_add'] = $data['consen_privasiKhusus_add'];
            $pasing['consen_nilaikepercayaan'] = $data['consen_nilaikepercayaan'];
            $pasing['consen_nilaikepercayaan_add'] = $data['consen_nilaikepercayaan_add'];
            $pasing['AwsUrlDocuments'] = $data['AwsUrlDocuments'];
            $pasing['uuid4'] = $data['DocTransactionID'];
            $pasing['NoHPPasien'] = $data['NoHPPasien'];
            $pasing['TTDPetugas'] = $data['TTDPetugas'];

            $pasing['consen_kuasa_eng'] = $data['consen_kuasa_eng'];
            $pasing['consen_kondisiPasien_eng'] = $data['consen_kondisiPasien_eng'];
            $pasing['consen_aksesKeluarga_eng'] = $data['consen_aksesKeluarga_eng'];
            $pasing['consen_privasiKhusus_eng'] = $data['consen_privasiKhusus_eng'];
            $pasing['TTD_PasienWali'] = $data['TTD_PasienWali'];

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintGeneralConsentSign($data)
    {
        try {

            $this->db->query("SELECT a.*,replace(CONVERT(VARCHAR(11), a.TGL_CREATE, 111), '/','-') TglCreate FROM Billing_Pasien.dbo.T_SIGNATURE a
            inner join Billing_Pasien.dbo.TDocumentGeneralConsents b on a.REFF_ID=b.ID WHERE b.ID=:id and a.GROUP_TRANSAKSI='GENERAL CONSEN'");
            $this->db->bind('id', $data['notrs']);
            $data =  $this->db->single();

            $pasing['TglCreate_sign'] = date('d/m/Y', strtotime($data['TglCreate']));
            $pasing['UID'] = $data['UID'];
            $pasing['NAMA_PARAM_1'] = $data['NAMA_PARAM_1'];
            $pasing['IMAGE_PATH'] = $data['IMAGE_PATH'];
            $pasing['NAMA_PARAM_2'] = $data['NAMA_PARAM_2'];
            $pasing['IMAGE_PATH2'] = $data['IMAGE_PATH2'];
            $pasing['GROUP_TRANSAKSI'] = $data['GROUP_TRANSAKSI'];
            $pasing['NO_TRANSAKSI'] = $data['NO_TRANSAKSI'];
            $pasing['NO_REGISTRASI'] = $data['NO_REGISTRASI'];
            //$pasing['TGL_CREATE'] = $data['TGL_CREATE'];
            $pasing['USER_CREATE'] = $data['USER_CREATE'];
            $pasing['AWS_URL'] = $data['AWS_URL'];

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function uploadAWS_GeneralConsent($data)
    {

        //$ip = ; // Ambil IP Address dari User 
        $doc_nomr = $data['listdata1']['ID'];
        //var_dump($data);exit;

        $bytes = random_bytes(20);
        $nama_file_baru  =     $doc_nomr . bin2hex($bytes) . "-" . date("YmdHis");
        $nama_file = 'GENERALCONSENT-' . $doc_nomr . '.pdf';
        $grupdokumen = 'GENERAL_CONSEN';

        /// AWS
        // Create an S3Client
        $s3Client = new S3Client([
            'version' => 'latest',
            'region'  => 'ap-southeast-1',
            'http'    => ['verify' => false],
            'credentials' => [
                'key'    => 'AKIAYV2M6ERJGUKK4QWQ',
                'secret' => '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'
            ]
        ]);
        //$file_name = __DIR__ . '/../../public' . '/tmp/' . $nama_file;
        $file_name = $_SERVER['DOCUMENT_ROOT'] . 'SIKBREC/public/tmp/' . $nama_file;
        $source =   $file_name;
        $awsImages = '';
        $handle = fopen($source, 'r');
        try {
            $bucket = 'rsuyarsibucket';
            $key = basename($nama_file_baru);
            $result = $s3Client->putObject([
                'Bucket' => $bucket,
                //'Key'    => 'digitalfiles/akadijaroh/' . $key,
                'Key'    => 'digitalfiles/generalconsent/' . $key,
                'Body'   => $handle,
                'ACL'    => 'public-read', // make file 'public', 
            ]);
            $awsImages = $result->get('ObjectURL');

            //close filenya
            fclose($handle);
            //hapus filenya 
            unlink($_SERVER["DOCUMENT_ROOT"] . 'SIKBREC/public/tmp/' . $nama_file);

            return $this->SaveFile($data, $awsImages, $grupdokumen);
        } catch (MultipartUploadException $e) {

            return $e->getMessage();
        }
    }


    public function uploadAWS_HakdanKewajiban($data)
    {

        //$ip = ; // Ambil IP Address dari User 
        $doc_nomr = $data['listdata1']['ID'];
        //var_dump($data);exit;

        $bytes = random_bytes(20);
        $nama_file_baru  =     $doc_nomr . bin2hex($bytes) . "-" . date("YmdHis");
        $nama_file = 'HAKDANKEWAJIBAN-' . $doc_nomr . '.pdf';
        $grupdokumen = 'HAK_DAN_KEWAJIBAN';

        /// AWS
        // Create an S3Client
        $s3Client = new S3Client([
            'version' => 'latest',
            'region'  => 'ap-southeast-1',
            'http'    => ['verify' => false],
            'credentials' => [
                'key'    => 'AKIAYV2M6ERJGUKK4QWQ',
                'secret' => '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'
            ]
        ]);
        //$file_name = __DIR__ . '/../../public' . '/tmp/' . $nama_file;
        $file_name = $_SERVER['DOCUMENT_ROOT'] . 'SIKBREC/public/tmp/' . $nama_file;
        $source =   $file_name;
        $awsImages = '';
        $handle = fopen($source, 'r');
        try {
            $bucket = 'rsuyarsibucket';
            $key = basename($nama_file_baru);
            $result = $s3Client->putObject([
                'Bucket' => $bucket,
                //'Key'    => 'digitalfiles/akadijaroh/' . $key,
                'Key'    => 'digitalfiles/hakdankewajiban/' . $key,
                'Body'   => $handle,
                'ACL'    => 'public-read', // make file 'public', 
            ]);
            $awsImages = $result->get('ObjectURL');

            //close filenya
            fclose($handle);
            //hapus filenya 
            unlink($_SERVER["DOCUMENT_ROOT"] . 'SIKBREC/public/tmp/' . $nama_file);

            return $this->SaveFile($data, $awsImages, $grupdokumen);
        } catch (MultipartUploadException $e) {

            return $e->getMessage();
        }
    }

    public function PrintHakdanKewajiban($data)
    {
        try {

            $this->db->query("SELECT a.*,replace(CONVERT(VARCHAR(11), TglCreate, 111), '/','-') TglCreate,b.FileDocument as TTDPetugas,TTD_PasienWali 
            FROM Billing_Pasien.dbo.TDocumentRightsandObligations  a
            left join MasterDataSQL.dbo.Employees b on a.PetugasTTD_ID=b.ID WHERE a.ID=:id");
            $this->db->bind('id', $data['notrs']);
            $data =  $this->db->single();

            $pasing['TglCreate_sign'] = date('d/m/Y', strtotime($data['TglCreate']));
            $pasing['ID'] = $data['ID'];
            $pasing['NoRegistrasi'] = $data['NoRegistrasi'];
            $pasing['NoEpisode'] = $data['NoEpisode'];
            $pasing['NoMR'] = $data['NoMR'];
            $pasing['NamaPasien'] = $data['NamaPasien'];
            $pasing['AwsUrlDocuments'] = $data['AwsUrlDocuments'];
            $pasing['uuid4'] = $data['DocTransactionID'];
            $pasing['NamaWaliPasien'] = $data['NamaWaliPasien'];
            $pasing['NIK'] = $data['NIK'];
            $pasing['Petugas'] = $data['Petugas'];
            $pasing['Divisi'] = $data['Divisi'];
            $pasing['TTDPetugas'] = $data['TTDPetugas'];
            $pasing['TTD_PasienWali'] = $data['TTD_PasienWali'];

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintTataTertibSign($data)
    {
        try {

            $this->db->query("SELECT *,replace(CONVERT(VARCHAR(11), TGL_CREATE, 111), '/','-') TglCreate FROM Billing_Pasien.dbo.T_SIGNATURE a
            inner join Billing_Pasien.dbo.TDocumentRegulations b on a.REFF_ID=b.ID WHERE b.ID=:id and a.GROUP_TRANSAKSI='TATA TERTIB'");
            $this->db->bind('id', $data['notrs']);
            $data =  $this->db->single();

            $pasing['TglCreate_sign'] = date('d/m/Y', strtotime($data['TglCreate']));
            $pasing['UID'] = $data['UID'];
            $pasing['NAMA_PARAM_1'] = $data['NAMA_PARAM_1'];
            $pasing['IMAGE_PATH'] = $data['IMAGE_PATH'];
            $pasing['NAMA_PARAM_2'] = $data['NAMA_PARAM_2'];
            $pasing['IMAGE_PATH2'] = $data['IMAGE_PATH2'];
            $pasing['GROUP_TRANSAKSI'] = $data['GROUP_TRANSAKSI'];
            $pasing['NO_TRANSAKSI'] = $data['NO_TRANSAKSI'];
            $pasing['NO_REGISTRASI'] = $data['NO_REGISTRASI'];
            //$pasing['TGL_CREATE'] = $data['TGL_CREATE'];
            $pasing['USER_CREATE'] = $data['USER_CREATE'];
            $pasing['AWS_URL'] = $data['AWS_URL'];

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintTataTertib($data)
    {
        try {

            $this->db->query("SELECT a.*,replace(CONVERT(VARCHAR(11), TglCreate, 111), '/','-') TglCreate,b.FileDocument as TTDPetugas,TTD_PasienWali
            FROM Billing_Pasien.dbo.TDocumentRegulations  a
            left join MasterDataSQL.dbo.Employees b on a.PetugasTTD_ID=b.ID WHERE a.ID=:id");
            $this->db->bind('id', $data['notrs']);
            $data =  $this->db->single();

            $pasing['TglCreate_sign'] = date('d/m/Y', strtotime($data['TglCreate']));
            $pasing['ID'] = $data['ID'];
            $pasing['NoRegistrasi'] = $data['NoRegistrasi'];
            $pasing['NoEpisode'] = $data['NoEpisode'];
            $pasing['NoMR'] = $data['NoMR'];
            $pasing['NamaPasien'] = $data['NamaPasien'];
            $pasing['AwsUrlDocuments'] = $data['AwsUrlDocuments'];
            $pasing['uuid4'] = $data['DocTransactionID'];
            $pasing['NamaWaliPasien'] = $data['NamaWaliPasien'];
            $pasing['NIK'] = $data['NIK'];
            $pasing['Petugas'] = $data['Petugas'];
            $pasing['Divisi'] = $data['Divisi'];
            $pasing['TTDPetugas'] = $data['TTDPetugas'];
            $pasing['TTD_PasienWali'] = $data['TTD_PasienWali'];

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function uploadAWS_TataTertib($data)
    {

        //$ip = ; // Ambil IP Address dari User 
        $doc_nomr = $data['listdata1']['ID'];
        //var_dump($data);exit;

        $bytes = random_bytes(20);
        $nama_file_baru  =     $doc_nomr . bin2hex($bytes) . "-" . date("YmdHis");
        $nama_file = 'TATATERTIB-' . $doc_nomr . '.pdf';
        $grupdokumen = 'TATA_TERTIB';

        /// AWS
        // Create an S3Client
        $s3Client = new S3Client([
            'version' => 'latest',
            'region'  => 'ap-southeast-1',
            'http'    => ['verify' => false],
            'credentials' => [
                'key'    => 'AKIAYV2M6ERJGUKK4QWQ',
                'secret' => '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'
            ]
        ]);
        //$file_name = __DIR__ . '/../../public' . '/tmp/' . $nama_file;
        $file_name = $_SERVER['DOCUMENT_ROOT'] . 'SIKBREC/public/tmp/' . $nama_file;
        $source =   $file_name;
        $awsImages = '';
        $handle = fopen($source, 'r');
        try {
            $bucket = 'rsuyarsibucket';
            $key = basename($nama_file_baru);
            $result = $s3Client->putObject([
                'Bucket' => $bucket,
                //'Key'    => 'digitalfiles/akadijaroh/' . $key,
                'Key'    => 'digitalfiles/tatatertib/' . $key,
                'Body'   => $handle,
                'ACL'    => 'public-read', // make file 'public', 
            ]);
            $awsImages = $result->get('ObjectURL');

            //close filenya
            fclose($handle);
            //hapus filenya 
            unlink($_SERVER["DOCUMENT_ROOT"] . 'SIKBREC/public/tmp/' . $nama_file);

            return $this->SaveFile($data, $awsImages, $grupdokumen);
        } catch (MultipartUploadException $e) {

            return $e->getMessage();
        }
    }

    public function PrintPerkiraanBiayaNoNOPSign($data)
    {
        try {

            $this->db->query("SELECT *,replace(CONVERT(VARCHAR(11), TGL_CREATE, 111), '/','-') TglCreate FROM Billing_Pasien.dbo.T_SIGNATURE a
            inner join Billing_Pasien.dbo.TDocumentEsitimatedNonOperationgCosts b on a.REFF_ID=b.ID WHERE b.ID=:id and a.GROUP_TRANSAKSI='PERKIRAAN BIAYA NON OP'");
            $this->db->bind('id', $data['notrs']);
            $data =  $this->db->single();

            $pasing['TglCreate_sign'] = date('d/m/Y', strtotime($data['TglCreate']));
            $pasing['UID'] = $data['UID'];
            $pasing['NAMA_PARAM_1'] = $data['NAMA_PARAM_1'];
            $pasing['IMAGE_PATH'] = $data['IMAGE_PATH'];
            $pasing['NAMA_PARAM_2'] = $data['NAMA_PARAM_2'];
            $pasing['IMAGE_PATH2'] = $data['IMAGE_PATH2'];
            $pasing['GROUP_TRANSAKSI'] = $data['GROUP_TRANSAKSI'];
            $pasing['NO_TRANSAKSI'] = $data['NO_TRANSAKSI'];
            $pasing['NO_REGISTRASI'] = $data['NO_REGISTRASI'];
            //$pasing['TGL_CREATE'] = $data['TGL_CREATE'];
            $pasing['USER_CREATE'] = $data['USER_CREATE'];
            $pasing['AWS_URL'] = $data['AWS_URL'];

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintPerkiraanBiayaNoNOP($data)
    {
        try {

            $this->db->query("SELECT a.*,replace(CONVERT(VARCHAR(11), TglCreate, 111), '/','-') TglCreate,b.FileDocument as TTDPetugas,TTD_PasienWali 
            FROM Billing_Pasien.dbo.TDocumentEsitimatedNonOperationgCosts  a
            left join MasterDataSQL.dbo.Employees b on a.PetugasTTD_ID=b.ID WHERE a.ID=:id");
            $this->db->bind('id', $data['notrs']);
            $data =  $this->db->single();

            $pasing['TglCreate_sign'] = date('d/m/Y', strtotime($data['TglCreate']));
            $pasing['ID'] = $data['ID'];
            $pasing['NoRegistrasi'] = $data['NoRegistrasi'];
            $pasing['NoEpisode'] = $data['NoEpisode'];
            $pasing['NoMR'] = $data['NoMR'];
            $pasing['NamaPasien'] = $data['NamaPasien'];
            $pasing['AwsUrlDocuments'] = $data['AwsUrlDocuments'];
            //$pasing['TglCreate'] = $data['TglCreate'];
            $pasing['RencanaPerawatan'] = $data['RencanaPerawatan'];
            $pasing['DiagnosaMedis'] = $data['DiagnosaMedis'];
            $pasing['DPJP'] = $data['DPJP'];
            $pasing['KamaPerawatan'] = $data['KamaPerawatan'];
            $pasing['Kelas'] = $data['Kelas'];
            $pasing['PerkiraanLamaRawat'] = $data['PerkiraanLamaRawat'];
            $pasing['RS_KamarPerawatan'] = $data['RS_KamarPerawatan'];
            $pasing['RS_KamarIntensive'] = $data['RS_KamarIntensive'];
            $pasing['RS_Lab'] = $data['RS_Lab'];
            $pasing['RS_Radiologi'] = $data['RS_Radiologi'];
            $pasing['RS_Farmasi'] = $data['RS_Farmasi'];
            $pasing['RS_BHP'] = $data['RS_BHP'];
            $pasing['RS_Administrasi'] = $data['RS_Administrasi'];
            $pasing['JD_VisiteDPJP'] = $data['JD_VisiteDPJP'];
            $pasing['JD_VisiteIntesive'] = $data['JD_VisiteIntesive'];
            $pasing['JD_VisiteKonsulAnestesi'] = $data['JD_VisiteKonsulAnestesi'];
            $pasing['JD_VisiteKonsulInternis'] = $data['JD_VisiteKonsulInternis'];
            $pasing['uuid4'] = $data['DocTransactionID'];
            $pasing['NamaWaliPasien'] = $data['NamaWaliPasien'];
            $pasing['NIK'] = $data['NIK'];
            $pasing['Petugas'] = $data['Petugas'];
            $pasing['Divisi'] = $data['Divisi'];
            $pasing['TTDPetugas'] = $data['TTDPetugas'];
            $pasing['RS_KamarPerawatan_ket'] = $data['RS_KamarPerawatan_ket'];
            $pasing['RS_KamarIntensive_ket'] = $data['RS_KamarIntensive_ket'];
            $pasing['RS_Lab_ket'] = $data['RS_Lab_ket'];
            $pasing['RS_Radiologi_ket'] = $data['RS_Radiologi_ket'];
            $pasing['RS_Farmasi_ket'] = $data['RS_Farmasi_ket'];
            $pasing['RS_BHP_ket'] = $data['RS_BHP_ket'];
            $pasing['RS_Administrasi_ket'] = $data['RS_Administrasi_ket'];
            $pasing['JD_VisiteDPJP_ket'] = $data['JD_VisiteDPJP_ket'];
            $pasing['JD_VisiteIntesive_ket'] = $data['JD_VisiteIntesive_ket'];
            $pasing['JD_VisiteKonsulAnestesi_ket'] = $data['JD_VisiteKonsulAnestesi_ket'];
            $pasing['JD_VisiteKonsulInternis_ket'] = $data['JD_VisiteKonsulInternis_ket'];
            $pasing['KeteranganLainnya'] = $data['KeteranganLainnya'];
            $pasing['Jumlah'] = $data['RS_KamarPerawatan'] + $data['RS_KamarIntensive'] + $data['RS_Lab'] + $data['RS_Radiologi'] + $data['RS_Farmasi'] + $data['RS_BHP'] + $data['RS_Administrasi'] + $data['JD_VisiteDPJP'] + $data['JD_VisiteIntesive'] + $data['JD_VisiteKonsulAnestesi'] + $data['JD_VisiteKonsulInternis'];
            $pasing['TTD_PasienWali'] = $data['TTD_PasienWali'];

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function uploadAWS_PerkiraanBiayaNoNOP($data)
    {

        //$ip = ; // Ambil IP Address dari User 
        $doc_nomr = $data['listdata1']['ID'];
        //var_dump($data);exit;

        $bytes = random_bytes(20);
        $nama_file_baru  =     $doc_nomr . bin2hex($bytes) . "-" . date("YmdHis");
        $nama_file = 'PERKIRAANNONOP-' . $doc_nomr . '.pdf';
        $grupdokumen = 'BIAYA_NONOPERASI';

        /// AWS
        // Create an S3Client
        $s3Client = new S3Client([
            'version' => 'latest',
            'region'  => 'ap-southeast-1',
            'http'    => ['verify' => false],
            'credentials' => [
                'key'    => 'AKIAYV2M6ERJGUKK4QWQ',
                'secret' => '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'
            ]
        ]);
        //$file_name = __DIR__ . '/../../public' . '/tmp/' . $nama_file;
        $file_name = $_SERVER['DOCUMENT_ROOT'] . 'SIKBREC/public/tmp/' . $nama_file;
        $source =   $file_name;
        $awsImages = '';
        $handle = fopen($source, 'r');
        try {
            $bucket = 'rsuyarsibucket';
            $key = basename($nama_file_baru);
            $result = $s3Client->putObject([
                'Bucket' => $bucket,
                //'Key'    => 'digitalfiles/akadijaroh/' . $key,
                'Key'    => 'digitalfiles/perkiraanbiaya/' . $key,
                'Body'   => $handle,
                'ACL'    => 'public-read', // make file 'public', 
            ]);
            $awsImages = $result->get('ObjectURL');

            //close filenya
            fclose($handle);
            //hapus filenya 
            unlink($_SERVER["DOCUMENT_ROOT"] . 'SIKBREC/public/tmp/' . $nama_file);

            return $this->SaveFile($data, $awsImages, $grupdokumen);
        } catch (MultipartUploadException $e) {

            return $e->getMessage();
        }
    }

    public function PrintPerkiraanBiayaOPSign($data)
    {
        try {

            $this->db->query("SELECT *,replace(CONVERT(VARCHAR(11), TGL_CREATE, 111), '/','-') TglCreate FROM Billing_Pasien.dbo.T_SIGNATURE a
            inner join Billing_Pasien.dbo.TDocumentEsitimatedOperationgCosts b on a.REFF_ID=b.ID WHERE b.ID=:id and a.GROUP_TRANSAKSI='PERKIRAAN BIAYA OP'");
            $this->db->bind('id', $data['notrs']);
            $data =  $this->db->single();

            $pasing['TglCreate_sign'] = date('d/m/Y', strtotime($data['TglCreate']));
            $pasing['UID'] = $data['UID'];
            $pasing['NAMA_PARAM_1'] = $data['NAMA_PARAM_1'];
            $pasing['IMAGE_PATH'] = $data['IMAGE_PATH'];
            $pasing['NAMA_PARAM_2'] = $data['NAMA_PARAM_2'];
            $pasing['IMAGE_PATH2'] = $data['IMAGE_PATH2'];
            $pasing['GROUP_TRANSAKSI'] = $data['GROUP_TRANSAKSI'];
            $pasing['NO_TRANSAKSI'] = $data['NO_TRANSAKSI'];
            $pasing['NO_REGISTRASI'] = $data['NO_REGISTRASI'];
            //$pasing['TGL_CREATE'] = $data['TGL_CREATE'];
            $pasing['USER_CREATE'] = $data['USER_CREATE'];
            $pasing['AWS_URL'] = $data['AWS_URL'];

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintPerkiraanBiayaOP($data)
    {
        try {

            $this->db->query("SELECT a.*,replace(CONVERT(VARCHAR(11), TglCreate, 111), '/','-') TglCreate,b.FileDocument as TTDPetugas,TTD_PasienWali  
            FROM Billing_Pasien.dbo.TDocumentEsitimatedOperationgCosts a
            left join MasterDataSQL.dbo.Employees b on a.PetugasTTD_ID=b.ID WHERE a.ID=:id");
            $this->db->bind('id', $data['notrs']);
            $data =  $this->db->single();

            $pasing['TglCreate_sign'] = date('d/m/Y', strtotime($data['TglCreate']));
            $pasing['ID'] = $data['ID'];
            $pasing['uuid4'] = $data['DocTransactionID'];
            $pasing['NoRegistrasi'] = $data['NoRegistrasi'];
            $pasing['NoEpisode'] = $data['NoEpisode'];
            $pasing['NoMR'] = $data['NoMR'];
            $pasing['NamaPasien'] = $data['NamaPasien'];
            $pasing['AwsUrlDocuments'] = $data['AwsUrlDocuments'];
            //$pasing['TglCreate'] = $data['TglCreate'];
            $pasing['RencanaPerawatan'] = $data['RencanaPerawatan'];
            $pasing['DiagnosaMedis'] = $data['DiagnosaMedis'];
            $pasing['DPJP'] = $data['DPJP'];
            $pasing['KamaPerawatan'] = $data['KamaPerawatan'];
            $pasing['Kelas'] = $data['Kelas'];
            $pasing['PerkiraanLamaRawat'] = $data['PerkiraanLamaRawat'];
            $pasing['JD_Operator'] = $data['JD_Operator'];
            $pasing['JD_AssistenOperator'] = $data['JD_AssistenOperator'];
            $pasing['JD_Anestesi'] = $data['JD_Anestesi'];
            $pasing['SewaKamarOperasi'] = $data['SewaKamarOperasi'];
            $pasing['AlkesDanBHP'] = $data['AlkesDanBHP'];
            $pasing['Lainlain'] = $data['Lainlain'];
            $pasing['ActiveDocument'] = $data['ActiveDocument'];
            $pasing['NamaWaliPasien'] = $data['NamaWaliPasien'];
            $pasing['NIK'] = $data['NIK'];
            $pasing['Tindakan'] = $data['Tindakan'];
            $pasing['DrOperator'] = $data['DrOperator'];
            $pasing['Jumlah'] = $data['JD_Operator'] + $data['JD_AssistenOperator'] + $data['JD_Anestesi'] + $data['SewaKamarOperasi'] + $data['AlkesDanBHP'] + $data['Lainlain'];
            $pasing['Petugas'] = $data['Petugas'];
            $pasing['Divisi'] = $data['Divisi'];
            $pasing['TTDPetugas'] = $data['TTDPetugas'];
            $pasing['JD_Operator_ket'] = $data['JD_Operator_ket'];
            $pasing['JD_AssistenOperator_ket'] = $data['JD_AssistenOperator_ket'];
            $pasing['JD_Anestesi_ket'] = $data['JD_Anestesi_ket'];
            $pasing['SewaKamarOperasi_ket'] = $data['SewaKamarOperasi_ket'];
            $pasing['AlkesDanBHP_ket'] = $data['AlkesDanBHP_ket'];
            $pasing['Lainlain_ket'] = $data['Lainlain_ket'];
            $pasing['KeteranganLainnya'] = $data['KeteranganLainnya'];
            $pasing['TTD_PasienWali'] = $data['TTD_PasienWali'];

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function uploadAWS_PerkiraanBiayaOP($data)
    {

        //$ip = ; // Ambil IP Address dari User 
        $doc_nomr = $data['listdata1']['ID'];
        //var_dump($data);exit;

        $bytes = random_bytes(20);
        $nama_file_baru  =     $doc_nomr . bin2hex($bytes) . "-" . date("YmdHis");
        $nama_file = 'PERKIRAANOP-' . $doc_nomr . '.pdf';
        $grupdokumen = 'BIAYA_OPERASI';

        /// AWS
        // Create an S3Client
        $s3Client = new S3Client([
            'version' => 'latest',
            'region'  => 'ap-southeast-1',
            'http'    => ['verify' => false],
            'credentials' => [
                'key'    => 'AKIAYV2M6ERJGUKK4QWQ',
                'secret' => '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'
            ]
        ]);
        //$file_name = __DIR__ . '/../../public' . '/tmp/' . $nama_file;
        $file_name = $_SERVER['DOCUMENT_ROOT'] . 'SIKBREC/public/tmp/' . $nama_file;
        $source =   $file_name;
        $awsImages = '';
        $handle = fopen($source, 'r');
        try {
            $bucket = 'rsuyarsibucket';
            $key = basename($nama_file_baru);
            $result = $s3Client->putObject([
                'Bucket' => $bucket,
                //'Key'    => 'digitalfiles/akadijaroh/' . $key,
                'Key'    => 'digitalfiles/perkiraanbiaya/' . $key,
                'Body'   => $handle,
                'ACL'    => 'public-read', // make file 'public', 
            ]);
            $awsImages = $result->get('ObjectURL');

            //close filenya
            fclose($handle);
            //hapus filenya 
            unlink($_SERVER["DOCUMENT_ROOT"] . 'SIKBREC/public/tmp/' . $nama_file);

            return $this->SaveFile($data, $awsImages, $grupdokumen);
        } catch (MultipartUploadException $e) {

            return $e->getMessage();
        }
    }

    public function PrintGeneralConsent_dtl($data)
    {
        try {

            $query = "SELECT * FROM Billing_Pasien.dbo.TDocumentGeneralConsents_FamilyDetails WHERE ID_Header=:id";

            $this->db->query($query);
            $this->db->bind('id', $data['notrs']);
            $datas =  $this->db->resultSet();

            $rows = array();
            $no = 1;
            foreach ($datas as $key) {
                $pasing['No'] = $no++;
                $pasing['Keluarga_Suami'] = $key['Keluarga_Suami'];
                $pasing['Keluarga_Istri'] = $key['Keluarga_Istri'];
                $pasing['Keluarga_Anak'] = $key['Keluarga_Anak'];
                $pasing['Keluarga_SaudaraKandung'] = $key['Keluarga_SaudaraKandung'];
                $pasing['Keluarga_Orangtua'] = $key['Keluarga_Orangtua'];
                $rows[] = $pasing;
            }

            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintPersetujuanBiayaSign($data)
    {
        try {

            $this->db->query("SELECT *,replace(CONVERT(VARCHAR(11), TGL_CREATE, 111), '/','-') TglCreate FROM Billing_Pasien.dbo.T_SIGNATURE a
            inner join Billing_Pasien.dbo.TDocumentApprovalTreatmentCosts b on a.REFF_ID=b.ID WHERE b.ID=:id and a.GROUP_TRANSAKSI='PERSETUJUAN BIAYA'");
            $this->db->bind('id', $data['notrs']);
            $data =  $this->db->single();

            $pasing['TglCreate_sign'] = date('d/m/Y', strtotime($data['TglCreate']));
            $pasing['UID'] = $data['UID'];
            $pasing['NAMA_PARAM_1'] = $data['NAMA_PARAM_1'];
            $pasing['IMAGE_PATH'] = $data['IMAGE_PATH'];
            $pasing['NAMA_PARAM_2'] = $data['NAMA_PARAM_2'];
            $pasing['IMAGE_PATH2'] = $data['IMAGE_PATH2'];
            $pasing['GROUP_TRANSAKSI'] = $data['GROUP_TRANSAKSI'];
            $pasing['NO_TRANSAKSI'] = $data['NO_TRANSAKSI'];
            $pasing['NO_REGISTRASI'] = $data['NO_REGISTRASI'];
            //$pasing['TGL_CREATE'] = $data['TGL_CREATE'];
            $pasing['USER_CREATE'] = $data['USER_CREATE'];
            $pasing['AWS_URL'] = $data['AWS_URL'];

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintPersetujuanBiaya($data)
    {
        try {

            $this->db->query("SELECT a.*,replace(CONVERT(VARCHAR(11), TglCreate, 111), '/','-') TglCreate,b.FileDocument as TTDPetugas,TTD_PasienWali
            FROM Billing_Pasien.dbo.TDocumentApprovalTreatmentCosts  a
            left join MasterDataSQL.dbo.Employees b on a.PetugasTTD_ID=b.ID WHERE a.ID=:id");
            $this->db->bind('id', $data['notrs']);
            $data =  $this->db->single();

            $pasing['TglCreate_sign'] = date('d/m/Y', strtotime($data['TglCreate']));
            $pasing['ID'] = $data['ID'];
            $pasing['uuid4'] = $data['DocTransactionID'];
            $pasing['NoRegistrasi'] = $data['NoRegistrasi'];
            $pasing['NoEpisode'] = $data['NoEpisode'];
            $pasing['NoMR'] = $data['NoMR'];
            $pasing['NamaPasien'] = $data['NamaPasien'];
            $pasing['AwsUrlDocuments'] = $data['AwsUrlDocuments'];
            $pasing['TglCreate'] = $data['TglCreate'];
            $pasing['ActiveDocument'] = $data['ActiveDocument'];
            $pasing['NamaWaliPasien'] = $data['NamaWaliPasien'];
            $pasing['NIK'] = $data['NIK'];
            $pasing['HubunganDenganPasien'] = $data['HubunganDenganPasien'];
            $pasing['RencanaTindakan'] = $data['RencanaTindakan'];
            $pasing['EstimasiBiaya'] = $data['EstimasiBiaya'];
            $pasing['Kelas'] = $data['Kelas'];
            $pasing['Ruangan'] = $data['Ruangan'];
            $pasing['Petugas'] = $data['Petugas'];
            $pasing['Divisi'] = $data['Divisi'];
            $pasing['PetugasTTD_ID'] = $data['PetugasTTD_ID'];
            $pasing['TTDPetugas'] = $data['TTDPetugas'];
            $pasing['NamaKelas'] = $data['NamaKelas'];
            $pasing['TTD_PasienWali'] = $data['TTD_PasienWali'];

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function uploadAWS_PersetujuanBiaya($data)
    {

        //$ip = ; // Ambil IP Address dari User 
        $doc_nomr = $data['listdata1']['ID'];
        //var_dump($data);exit;

        $bytes = random_bytes(20);
        $nama_file_baru  =     $doc_nomr . bin2hex($bytes) . "-" . date("YmdHis");
        $nama_file = 'PERSETUJUANBIAYA-' . $doc_nomr . '.pdf';
        $grupdokumen = 'PERSETUJUAN_BIAYA';

        /// AWS
        // Create an S3Client
        $s3Client = new S3Client([
            'version' => 'latest',
            'region'  => 'ap-southeast-1',
            'http'    => ['verify' => false],
            'credentials' => [
                'key'    => 'AKIAYV2M6ERJGUKK4QWQ',
                'secret' => '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'
            ]
        ]);
        //$file_name = __DIR__ . '/../../public' . '/tmp/' . $nama_file;
        $file_name = $_SERVER['DOCUMENT_ROOT'] . 'SIKBREC/public/tmp/' . $nama_file;
        $source =   $file_name;
        $awsImages = '';
        $handle = fopen($source, 'r');
        try {
            $bucket = 'rsuyarsibucket';
            $key = basename($nama_file_baru);
            $result = $s3Client->putObject([
                'Bucket' => $bucket,
                //'Key'    => 'digitalfiles/akadijaroh/' . $key,
                'Key'    => 'digitalfiles/persetujuanbiaya/' . $key,
                'Body'   => $handle,
                'ACL'    => 'public-read', // make file 'public', 
            ]);
            $awsImages = $result->get('ObjectURL');

            //close filenya
            fclose($handle);
            //hapus filenya 
            unlink($_SERVER["DOCUMENT_ROOT"] . 'SIKBREC/public/tmp/' . $nama_file);

            return $this->SaveFile($data, $awsImages, $grupdokumen);
        } catch (MultipartUploadException $e) {

            return $e->getMessage();
        }
    }

    public function PrintPersetujuanSelisih($data)
    {
        try {

            $this->db->query("SELECT a.*,replace(CONVERT(VARCHAR(11), TglCreate, 111), '/','-') TglCreate,b.FileDocument as TTDPetugas,TTD_PasienWali
            FROM Billing_Pasien.dbo.TDocumentApprovalCostDifferents  a
            left join MasterDataSQL.dbo.Employees b on a.PetugasTTD_ID=b.ID WHERE a.ID=:id");
            $this->db->bind('id', $data['notrs']);
            $data =  $this->db->single();

            $pasing['TglCreate_sign'] = date('d/m/Y', strtotime($data['TglCreate']));
            $pasing['ID'] = $data['ID'];
            $pasing['uuid4'] = $data['DocTransactionID'];
            $pasing['NoRegistrasi'] = $data['NoRegistrasi'];
            $pasing['NoEpisode'] = $data['NoEpisode'];
            $pasing['NoMR'] = $data['NoMR'];
            $pasing['NamaPasien'] = $data['NamaPasien'];
            $pasing['NamaPenjamin'] = $data['NamaPenjamin'];
            $pasing['JenisKelamin'] = $data['JenisKelamin'];
            $pasing['Usia'] = $data['Usia'];
            $pasing['Alamat'] = $data['Alamat'];
            $pasing['NoTelp_Pasien'] = $data['NoTelp_Pasien'];
            $pasing['AwsUrlDocuments'] = $data['AwsUrlDocuments'];
            $pasing['TglCreate'] = $data['TglCreate'];
            $pasing['ActiveDocument'] = $data['ActiveDocument'];
            $pasing['NamaWaliPasien'] = $data['NamaWaliPasien'];
            $pasing['NIK'] = $data['NIK'];
            $pasing['HubunganDenganPasien'] = $data['HubunganDenganPasien'];
            $pasing['NoTelp'] = $data['NoTelp'];
            $pasing['Petugas'] = $data['Petugas'];
            $pasing['Divisi'] = $data['Divisi'];
            $pasing['PetugasTTD_ID'] = $data['PetugasTTD_ID'];
            $pasing['TTD_PasienWali'] = $data['TTD_PasienWali'];
            $pasing['EmailSend'] = $data['EmailSend'];
            $pasing['NoHPSend'] = $data['NoHPSend'];
            $pasing['TTDPetugas'] = $data['TTDPetugas'];

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function uploadAWS_PersetujuanSelisih($data)
    {

        //$ip = ; // Ambil IP Address dari User 
        $doc_nomr = $data['listdata1']['ID'];
        //var_dump($data);exit;

        $bytes = random_bytes(20);
        $nama_file_baru  =     $doc_nomr . bin2hex($bytes) . "-" . date("YmdHis");
        $nama_file = 'PERSETUJUANSELISIH-' . $doc_nomr . '.pdf';
        $grupdokumen = 'PERSETUJUAN_SELISIH';

        /// AWS
        // Create an S3Client
        $s3Client = new S3Client([
            'version' => 'latest',
            'region'  => 'ap-southeast-1',
            'http'    => ['verify' => false],
            'credentials' => [
                'key'    => 'AKIAYV2M6ERJGUKK4QWQ',
                'secret' => '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'
            ]
        ]);
        //$file_name = __DIR__ . '/../../public' . '/tmp/' . $nama_file;
        $file_name = $_SERVER['DOCUMENT_ROOT'] . 'SIKBREC/public/tmp/' . $nama_file;
        $source =   $file_name;
        $awsImages = '';
        $handle = fopen($source, 'r');
        try {
            $bucket = 'rsuyarsibucket';
            $key = basename($nama_file_baru);
            $result = $s3Client->putObject([
                'Bucket' => $bucket,
                //'Key'    => 'digitalfiles/akadijaroh/' . $key,
                'Key'    => 'digitalfiles/persetujuanselisih/' . $key,
                'Body'   => $handle,
                'ACL'    => 'public-read', // make file 'public', 
            ]);
            $awsImages = $result->get('ObjectURL');

            //close filenya
            fclose($handle);
            //hapus filenya 
            unlink($_SERVER["DOCUMENT_ROOT"] . 'SIKBREC/public/tmp/' . $nama_file);

            return $this->SaveFile($data, $awsImages, $grupdokumen);
        } catch (MultipartUploadException $e) {

            return $e->getMessage();
        }
    }

    public function UpdateNoSEP_MasukRanap($data)
    {
        try {
            $this->db->transaksi();

            $NOID_Reg = $data['NOID_Reg'];
            $NoSEPBaru = $data['nosep_baru'];
            $NoSEPLama = $data['NoSEPLama'];
            $Noreg = $data['Noreg'];
            $alasan = $data['alasan'];
            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $namauserx = $session->name;

            $this->db->query("UPDATE PerawatanSQL.dbo.Visit SET NoSEP=:NoSEPBaru WHERE ID=:NOID_Reg");
            $this->db->bind('NOID_Reg', $NOID_Reg);
            $this->db->bind('NoSEPBaru', $NoSEPBaru);
            $this->db->execute();

            $info = "Ganti No SEP - SEP Lama: " . $NoSEPLama . " - SEP BARU:" . $NoSEPBaru;
            $this->db->query("INSERT INTO  SysLog.dbo.TZ_Log_Button (idtrs,noregistrasi,nama_biling,petugas_batal,tgl_batal,alasan_batal) VALUES
                    (:NOID_Reg,:noreg,:info,:namauserx,:datenowcreate,:alasan)");
            $this->db->bind('NOID_Reg', $NOID_Reg);
            $this->db->bind('noreg', $Noreg);
            $this->db->bind('info', $info);
            $this->db->bind('namauserx', $namauserx);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('alasan', $alasan);
            $this->db->execute();

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Transkasi Berhasil Disimpan !',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function showDataPasienRajalAktifMCU($data)
    {
        try {
            $this->db->query("SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName,a.LokasiPasien,a.CaraBayar,
                            a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
                            a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
                            a.PatientType,a.Unit,a.Doctor_1,b.First_Name,a.JamPraktek,
                            case when a.Asuransi is not null and a.PatientType='2' then a.Asuransi else a.Perusahaan end as Asuransi,
							case when c.NamaPerusahaan is not null and a.PatientType='2'  then c.NamaPerusahaan else f.NamaPerusahaan end as  Perusahaan,
                            a.[Payment Type],
                            a.Antrian,a.NoAntrianAll,e.[First Name] as namauser
                            , case when a.TelemedicineIs='1' then 'TELEMEDICINE' ELSE '' end as Telemedicine,a.Company,HakKelasBPJS,PRB,g.ID as status_kehadiran
                            --,tgc.ID as GeneralConsentID,ai.ID as AkadIjarohID,hk.ID as HakKewajibanID,tt.ID as TataTertibID,nonop.ID as BiayaNonOPID
                            from PerawatanSQL.dbo.Visit a
                            inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
                            left join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.Asuransi
                            left join MasterdataSQL.dbo.MstrPerusahaanJPK f on f.ID = a.Perusahaan
                            inner join MasterdataSQL.dbo.Admision d on d.NoMR = a.NoMR
                            left join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
                            left join PerawatanSQL.dbo.scanbarcode_kehadiranmcu g on a.NoRegistrasi=g.NoRegistrasi

                            where a.Batal='0' AND   [Status ID]<>'4'
                            AND a.Unit='53'
                            ORDER BY a.id DESC");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = 0;
            foreach ($data as $key) {
                $no++;
                $nosep = '';
                if ($key['NoSEP'] != null || $key['NoSEP'] != '') {
                    $nosep = '<b>(No SEP: ' . $key['NoSEP'] . ')</b>';
                }
                $pasing['no'] = $no;
                $pasing['ID'] = $key['id'];
                $pasing['NoEpisode'] = $key['NoEpisode'];
                $pasing['Company'] = $key['Company'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['LokasiPasien'] = $key['LokasiPasien'];
                $pasing['Perusahaan'] = $key['Perusahaan'];
                $pasing['namauser'] = $key['namauser'];
                $pasing['NoSEP_edited'] = $nosep;
                $pasing['NoSEP'] = $key['NoSEP'];
                $pasing['Telemedicine'] = $key['Telemedicine'];
                $pasing['VisitDate'] = date('d/m/Y H:i:s', strtotime($key['Visit Date']));
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['PatientName'] = $key['PatientName'];
                $pasing['DokterName'] = $key['First_Name'];
                $pasing['HakKelasBPJS'] = $key['HakKelasBPJS'];
                $pasing['PRB'] = $key['PRB'];
                $pasing['NoPesertaBPJS'] = $key['NoPesertaBPJS'];
                $pasing['status_kehadiran'] = $key['status_kehadiran'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function goScanQrCode($data)
    {
        try {
            $this->db->transaksi();
            $notrs = $data['NoTrs'];
            $datenowcreate = Utils::seCurrentDateTime();

            //check if data exist
            $this->db->query("SELECT *
                                    FROM PerawatanSQL.dbo.scanbarcode_kehadiranmcu
                                    WHERE NoRegistrasi=:notrs 
                                    ");
            $this->db->bind('notrs', $notrs);
            $data2 =  $this->db->single();

            if ($data2) {
                $callback = array(
                    'status' => 'danger',
                    'message' => 'Barcode sudah pernah discan !',
                );
                return $callback;
            }

            //check if register exist
            $this->db->query("SELECT ID
                FROM PerawatanSQL.dbo.visit
                WHERE NoRegistrasi=:notrs AND Batal='0' and [Status ID]<>'4'
                ");
            $this->db->bind('notrs', $notrs);
            $data3 =  $this->db->single();

            if (!$data3) {
                $callback = array(
                    'status' => 'danger',
                    'message' => 'Barcode / Nomor Registrasi Tidak Ditemukan !',
                );
                return $callback;
            }

            $this->db->query("INSERT INTO perawatanSQL.dbo.scanbarcode_kehadiranmcu 
                                (NoRegistrasi,DateScan) 
                                VALUES 
                                (:notrs,:datenowcreate)");
            $this->db->bind('notrs', $notrs);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->execute();

            $this->db->Commit();
            $callback = array(
                'status' => 'success',
                'message' => ' Scan Data Succesfully.',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => 'warning',
                'message' => $e,
            );
            return $callback;
        }
    }

    public function sendreminderAllMCU($token, $data)
    {
        try {
            //$this->db->transaksi();
            $notereminderx = $data['noted'];
            //$idbtn = $data['idbtn'];

            //$odid = array();
            $tod = json_decode(json_encode((object) $data['idorderapprove']), FALSE);
            foreach ($tod as $data) {

                $idresv = $data;
                //get data
                // $this->db->query("SELECT NamaPasien,NamaDokter,Poli,
                // replace(CONVERT(VARCHAR(11), ApmDate, 111), '/','-') as TglResv,JamPraktek,NoAntrianAll,HP,ID_JadwalPraktek,DoctorID,IdPoli
                //                     FROM PerawatanSQL.dbo.Apointment
                //                     WHERE ID=:idresv
                //                     ");
                $this->db->query("SELECT PatientName as NamaPasien,NamaDokter,NamaUnit as Poli,
                replace(CONVERT(VARCHAR(11), [Visit Date], 111), '/','-') as TglResv,JamPraktek,NoAntrianAll,MobilePhone as HP,'' as ID_JadwalPraktek,IdDokter as DoctorID,IdUnit as IdPoli,NoRegistrasi,NoMR
                                    FROM DashboardData.dbo.DataRWJ
                                    WHERE NoRegistrasi=:idresv
                                    ");
                $this->db->bind('idresv', $idresv);
                $data2 =  $this->db->single();
                $nama = $data2['NamaPasien'];
                $namadokter = $data2['NamaDokter'];
                $namapoli = $data2['Poli'];
                $hari = $data2['TglResv'];
                $jampoli = $data2['JamPraktek'];
                $antrian = $data2['NoAntrianAll'];
                $NoHandphone =  Utils::hp($data2['HP']);
                $hari_dmy = date('d-m-Y', strtotime($data2['TglResv']));
                $NoRegistrasi = $data2['NoRegistrasi'];
                $NoMR = $data2['NoMR'];

                $this->sendNotifWapin(
                    $token,
                    $NoHandphone,
                    $nama,
                    $NoRegistrasi,
                    $hari_dmy,
                    $jampoli,
                    $namapoli,
                    $namadokter,
                    $antrian,
                    $NoMR == '' ? '-' : $NoMR
                );

                // $jampraktek = $data2['ID_JadwalPraktek'];
                // $IdDokter = $data2['DoctorID'];
                // $IdGrupPerawatan = $data2['IdPoli'];


                // // $arr_data = array(
                // //     'ID_JadwalPraktek' => $jampraktek,
                // //     'tglreservasi' => $hari,
                // //     'IdDokter' => $IdDokter,
                // //     'IdPoli' => $IdGrupPerawatan,
                // // );
                // // $getwaktujadwal = $this->getWaktuPraktek($arr_data);

                // // if ($getwaktujadwal == null || $getwaktujadwal == '' || $getwaktujadwal == '-') {
                // //     $getwaktujadwal = $jampoli;
                // // }

                // $getwaktujadwal = $jampoli;

                // $curl = curl_init();
                // curl_setopt_array($curl, array(
                //     CURLOPT_URL => 'https://api.chat.wappin.app/v1/messages',
                //     CURLOPT_RETURNTRANSFER => true,
                //     CURLOPT_ENCODING => '',
                //     CURLOPT_MAXREDIRS => 10,
                //     CURLOPT_TIMEOUT => 0,
                //     CURLOPT_FOLLOWLOCATION => true,
                //     CURLOPT_SSL_VERIFYPEER => FALSE,
                //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                //     CURLOPT_CUSTOMREQUEST => 'POST',
                //     CURLOPT_POSTFIELDS => '{
                //     "to": "' . $NoHandphone . '",
                //     "type": "template",
                //     "template": {
                //         "name": "reminderapoitment_1",
                //         "namespace": "700eb891_fb62_4d15_8d30_d493e38bbfc9", 
                //         "language": {
                //             "policy": "deterministic",
                //             "code": "id"
                //         },
                //         "components": [
                //             {
                //                 "type": "body",
                //                 "parameters": [ 
                //                     {
                //                         "type": "text",
                //                         "text": "' . $nama . '"
                //                     } , {
                //                         "type": "text",
                //                         "text": "' . $namadokter . '"
                //                     } , {
                //                         "type": "text",
                //                         "text": "' . $namapoli . '"
                //                     } , {
                //                         "type": "text",
                //                         "text": "' . $hari_dmy . '"
                //                     } , {
                //                         "type": "text",
                //                         "text": "' . $getwaktujadwal . '"
                //                     } , {
                //                         "type": "text",
                //                         "text": "' . $antrian . '"
                //                     } , {
                //                         "type": "text",
                //                         "text": "' . $notereminderx . '"
                //                     }  
                //                 ]
                //             } 
                //         ]
                //     }
                // }',
                //     CURLOPT_HTTPHEADER => array(
                //         'Authorization: Bearer ' . $token,
                //         'Content-Type: application/json'
                //     ),
                // ));
                // $response = curl_exec($curl);
                // $JsonData = json_decode($response, TRUE);
                // curl_close($curl);
            }
            //exit;

            // $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Simpan Berhasil',
            );
            return $callback;
        } catch (PDOException $e) {
            //  $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function sendNotifWapin($token, $NoHandphone, $param1, $param2, $param3, $param4, $param5, $param6, $param7, $param8)
    {
        $base64 = base64_encode($param2);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.chat.wappin.app/v1/messages',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "to": "' . $NoHandphone . '",
            "type": "template",
            "template": {
                "name": "apoitment_new_2023_4",
                "namespace": "700eb891_fb62_4d15_8d30_d493e38bbfc9", 
                "language": {
                    "policy": "deterministic",
                    "code": "id"
                },
                "components": [
                    {
                        "type": "body",
                        "parameters": [
                            {
                                "type": "text",
                                "text": "' . $param1 . '"
                            } , {
                                "type": "text",
                                "text": "' . $param2 . '"
                            } , {
                                "type": "text",
                                "text": "' . $param3 . '"
                            } , {
                                "type": "text",
                                "text": "' . $param4 . '"
                            } , {
                                "type": "text",
                                "text": "' . $param5 . '"
                            } , {
                                "type": "text",
                                "text": "' . $param6 . '"
                            } , {
                                "type": "text",
                                "text": "' . $param7 . '"
                            } , {
                                "type": "text",
                                "text": "' . $param8 . '"
                            } , {
                                "type": "text",
                                "text": "' . $base64 . '"
                            } 
                        ]
                    } 
                ]
            }
        }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token,
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        $JsonData = json_decode($response, TRUE);
        curl_close($curl);
        return $JsonData;
    }
}
