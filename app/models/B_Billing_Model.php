<?php

use Aws\S3\S3Client;
use Aws\Exception\MultipartUploadException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class  B_Billing_Model
{
    use ApiRsyarsi;
    use ApiGenerateEmaterai;

    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getDataPasien($data)
    {
        try {
            $noregistrasi = $data['NoRegistrasi'];
            $this->db->query("SELECT a.InpatientID as ID,b.PatientName,a.NoMR,a.NoRegRI as NoRegistrasi,a.NoEpisode,a.TypePatient as TypePatientID, replace(CONVERT(VARCHAR(11), b.Date_of_birth, 111), '/','-') as DOB,
                        case when a.TypePatient = '2' then h.ID when a.TypePatient = '5' then i.ID else '315' end as penjamin_kode,
                        case when a.TypePatient = '2' then h.NamaPerusahaan when a.TypePatient = '5' then i.NamaPerusahaan else 'UMUM' end as nama_penjamin,e.ID as IDDokter,e.First_Name as NamaDokter,f.IDKelas,f.NamaKelas,
                        replace(CONVERT(VARCHAR(11), a.[StartDate], 111), '/','-') as TglMasuk,replace(CONVERT(VARCHAR(11), a.[EndDate], 111), '/','-') as TglKeluar,null as IDUnit,a.JenisRawat as NamaUnit,
                         case when a.TypePatient='2' then kja.HakKelas else kj.HakKelas end as HakKelas,vst.NoRegistrasi as NoRegisRWJ,d.A_Diagnosa,'' as TelemedicineIs,
                         '' as  JenisPasien,
                         cast((DATEDIFF(m, b.Date_of_birth, GETDATE())/12) as varchar) + ' Tahun ' + 
                          cast((DATEDIFF(m, b.Date_of_birth, GETDATE())%12) as varchar) + ' Bulan' as age, 
                          case when vst.NoRegistrasi is not null then replace(CONVERT(VARCHAR(11), vst.TglKunjungan, 111), '/','-') else replace(CONVERT(VARCHAR(11), a.[StartDate], 111), '/','-') end as awal_periode,ss.[Status Name] collate Latin1_General_CI_AS as StatusReg,a.[StatusID] as statusid,'Rawat Inap' as judul,g.TipePasien,
						   case when a.TypePatient = '2' then h.Group_Jaminan  else i.Group_Jaminan end as GroupJaminan, b.[E-mail Address] as emailpasien,b.[Mobile Phone] as nohp
                                      from RawatInapSQL.dbo.Inpatient a
                                      inner join MasterdataSQL.dbo.Admision b on a.NoMR=b.NoMR
                                      inner join PerawatanSQL.dbo.T_TipePasien g on a.TypePatient = g.ID
                                outer apply
                                (SELECT TOP 1 A_Diagnosa from MedicalRecord.dbo.EMR_RWJ where NoRegistrasi collate Latin1_General_CS_AS=a.NoRegRI collate Latin1_General_CS_AS)d
                                      inner join MasterdataSQL.dbo.Doctors e on a.drPenerima=e.ID
                                      inner join RawatInapSQL.dbo.TblKelas f on a.KLSID=f.IDKelas
                                      left join MasterdataSQL.dbo.MstrPerusahaanAsuransi h on a.IDAsuransi=h.ID
                                      left join MasterdataSQL.dbo.MstrPerusahaanJPK i on a.IDJPK=i.ID
                                      left join PerawatanSQL.dbo.Visit vst on a.NoRegisRwj=vst.NoRegistrasi
                                 left join MasterdataSQL.dbo.Admision_Kartu_Jaminan kj on a.NoMR=kj.NoMR and a.TypePatient=kj.KodeGroupJaminan 
                                and a.IDJPK=kj.KodeJaminan
                                left join MasterdataSQL.dbo.Admision_Kartu_Jaminan kja on a.NoMR=kja.NoMR and a.TypePatient=kja.KodeGroupJaminan 
                                and a.IDAsuransi=kja.KodeJaminan
                                left join RawatInapSQL.dbo.[Visit Status] ss on a.StatusID=ss.[Status ID]
                                       where a.NoRegRI=:noreg_ranap
                                       UNION ALL
                           SELECT a.ID,b.PatientName,a.NoMR,a.NoRegistrasi,a.NoEpisode,a.PatientType as TypePatientID,replace(CONVERT(VARCHAR(11), b.Date_of_birth, 111), '/','-') as DOB,
                           case when a.PatientType = '2' then h.ID else i.ID end as penjamin_kode,
                           case when a.PatientType = '2' then h.NamaPerusahaan else i.NamaPerusahaan end as nama_penjamin,
                           f.ID as IDDokter,f.First_Name as NamaDokter,null as IDKelas,'Rawat Jalan' as NamaKelas,
                           replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as TglMasuk,replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as TglMasuk,
                           a.Unit AS IDUnit,e.NamaUnit,'-' HakKelas,'-' as NoRegisRWJ,d.A_Diagnosa
                        ,CASE WHEN a.TelemedicineIs='1' THEN 'PASIEN TELEMEDINE' ELSE 'PASIEN NON TELEMEDICINE' END AS TelemedicineIs,
                        case 
                        when replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') > replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-')
                        then 'Pasien Lama'  ELSE 'Pasien Baru'
                        end as JenisPasien ,
                        cast((DATEDIFF(m, b.Date_of_birth, GETDATE())/12) as varchar) + ' Tahun ' + 
                          cast((DATEDIFF(m, b.Date_of_birth, GETDATE())%12) as varchar) + ' Bulan' as age,replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as awal_periode,ss.[Status Name] collate Latin1_General_CI_AS  as StatusReg,a.[Status ID] as statusid,'Rawat Jalan' as judul,g.TipePasien,
						   case when a.PatientType = '2' then h.Group_Jaminan  else i.Group_Jaminan end as GroupJaminan, b.[E-mail Address] as emailpasien,b.[Mobile Phone] as nohp
                          from PerawatanSQL.dbo.Visit a
                          inner join MasterdataSQL.dbo.Admision b on a.NoMR collate Latin1_General_CS_AS = b.NoMR
                          collate Latin1_General_CS_AS
                          left join MasterdataSQL.dbo.MstrPerusahaanAsuransi h on a.Asuransi=h.ID
                          left join MasterdataSQL.dbo.MstrPerusahaanJPK i on a.Perusahaan=i.ID
                          inner join MasterdataSQL.dbo.Doctors f on a.Doctor_1 = f.ID
                          inner join MasterdataSQL.dbo.MstrUnitPerwatan e on a.Unit=e.ID
                          inner join PerawatanSQL.dbo.T_TipePasien g on a.PatientType=g.ID
                          outer apply
                    (SELECT TOP 1 A_Diagnosa from MedicalRecord.dbo.EMR_RWJ where NoRegistrasi collate Latin1_General_CS_AS=a.NoRegistrasi collate Latin1_General_CS_AS)d
                    left join RawatInapSQL.dbo.[Visit Status] ss on a.[Status ID]=ss.[Status ID]
                           where a.NoRegistrasi=:noreg_rajal
                            UNION ALL
                            SELECT a.ID,b.PatientName,a.NoMR,a.NoRegistrasi,a.NoEpisode,a.PatientType as TypePatientID,replace(CONVERT(VARCHAR(11), b.Date_of_birth, 111), '/','-') as DOB,
                           case when a.PatientType = '2' then h.ID else i.ID end as penjamin_kode,
                           case when a.PatientType = '2' then h.NamaPerusahaan else i.NamaPerusahaan end as nama_penjamin,
                           f.ID as IDDokter,f.First_Name as NamaDokter,null as IDKelas,'Walkin' as NamaKelas,
                           replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as TglMasuk,replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as TglMasuk,
                           a.Unit AS IDUnit,e.NamaUnit,'-' HakKelas,'-' as NoRegisRWJ,d.A_Diagnosa
                        ,CASE WHEN a.TelemedicineIs='1' THEN 'PASIEN TELEMEDINE' ELSE 'PASIEN NON TELEMEDICINE' END AS TelemedicineIs,
                        case 
                        when replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') > replace(CONVERT(VARCHAR(11), b.InputDate, 111), '/','-')
                        then 'Pasien Lama'  ELSE 'Pasien Baru'
                        end as JenisPasien ,
                        cast((DATEDIFF(m, b.Date_of_birth, GETDATE())/12) as varchar) + ' Tahun ' + 
                          cast((DATEDIFF(m, b.Date_of_birth, GETDATE())%12) as varchar) + ' Bulan' as age,replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as awal_periode,ss.[Status Name] collate Latin1_General_CI_AS  as StatusReg,a.[Status ID] as statusid,'Walkin' as judul,g.TipePasien,
						   case when a.PatientType = '2' then h.Group_Jaminan  else i.Group_Jaminan end as GroupJaminan, b.[E-mail Address] as emailpasien,b.[Mobile Phone] as nohp
                          from PerawatanSQL.dbo.Visit a
                          inner join MasterdataSQL.dbo.Admision_walkin b on a.NoMR collate Latin1_General_CS_AS = b.NoMR
                          collate Latin1_General_CS_AS
                          left join MasterdataSQL.dbo.MstrPerusahaanAsuransi h on a.Asuransi=h.ID
                          left join MasterdataSQL.dbo.MstrPerusahaanJPK i on a.Perusahaan=i.ID
                          inner join MasterdataSQL.dbo.Doctors f on a.Doctor_1 = f.ID
                          inner join MasterdataSQL.dbo.MstrUnitPerwatan e on a.Unit=e.ID
                          inner join PerawatanSQL.dbo.T_TipePasien g on a.PatientType=g.ID
                          outer apply
                    (SELECT TOP 1 A_Diagnosa from MedicalRecord.dbo.EMR_RWJ where NoRegistrasi collate Latin1_General_CS_AS=a.NoRegistrasi collate Latin1_General_CS_AS)d
                    left join RawatInapSQL.dbo.[Visit Status] ss on a.[Status ID]=ss.[Status ID]
                           where a.NoRegistrasi=:noreg_walkin
                           UNION ALL
                    SELECT [Order ID] as ID,[Ship Name],CAST([Customer ID] as varchar) as NoMR,NoRegistrasi,'-' as NoEpisode,null as TypePatientID,
                    null as DOB,null as penjamin_kode,'-' nama_penjamin,null as IDDokter,'-' as NamaDokter,null as IDKelas,JenisResep collate Latin1_General_CS_AS as NamaKelas,
                    replace(CONVERT(VARCHAR(11), tglResep, 111), '/','-') as TglMasuk,replace(CONVERT(VARCHAR(11), tglResep, 111), '/','-') as TglKeluar,
                    null AS IDUnit,JenisResep collate Latin1_General_CS_AS as NamaUnit,'-' HakKelas,'-' as NoRegisRWJ,'-' as A_Diagnosa
                    ,'' AS TelemedicineIs,'' as  JenisPasien ,null as age,replace(CONVERT(VARCHAR(11), tglResep, 111), '/','-') as awal_periode,ss.[Status Name] collate Latin1_General_CI_AS  as StatusReg,a.[Status ID] as statusid,'Penjualan Bebas' as judul,'' as TipePasien,'' as GroupJaminan, '' emailpasien,'' as nohp
                    FROM [Apotik_V1.1SQL].dbo.Orders a
                    left join [Apotik_V1.1SQL].dbo.[Orders Status] ss on a.[Status ID]=ss.[Status ID]
                    where NoRegistrasi=:noreg_obatbebas
             ");
            $this->db->bind('noreg_ranap', $noregistrasi);
            $this->db->bind('noreg_rajal', $noregistrasi);
            $this->db->bind('noreg_walkin', $noregistrasi);
            $this->db->bind('noreg_obatbebas', $noregistrasi);
            $key =  $this->db->single();
            $pasing['ID'] = $key['ID'];
            $pasing['NoMR'] = $key['NoMR'];
            $pasing['PatientName'] = $key['PatientName'];
            $pasing['NoMR'] = $key['NoMR'];
            $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
            $pasing['DOB'] = date('d/m/Y', strtotime($key['DOB']));
            $pasing['NoEpisode'] = $key['NoEpisode'];
            $pasing['TypePatientID'] = $key['TypePatientID'];
            // $pasing['DOB'] = $key['DOB']; 
            $pasing['penjamin_kode'] = $key['penjamin_kode'];
            $pasing['nama_penjamin'] = $key['nama_penjamin'];
            $pasing['IDDokter'] = $key['IDDokter'];
            $pasing['NamaDokter'] = $key['NamaDokter'];
            $pasing['IDKelas'] = $key['IDKelas'];
            $pasing['NamaKelas'] = $key['NamaKelas'];
            $pasing['Unit'] = $key['IDUnit'];
            $pasing['NamaUnit'] = $key['NamaUnit'];
            $pasing['TglMasuk'] = $key['TglMasuk'];
            $pasing['TglKeluar'] = $key['TglKeluar'];
            $pasing['HakKelas'] = $key['HakKelas'];
            $pasing['NoRegisRWJ'] = $key['NoRegisRWJ'];
            $pasing['Diagnosa'] = $key['A_Diagnosa'];
            $pasing['TelemedicineIs'] = $key['TelemedicineIs'];
            $pasing['JenisPasien'] = $key['JenisPasien'];
            $pasing['age'] = $key['age'];
            $pasing['awal_periode'] = $key['awal_periode'];
            $pasing['StatusReg'] = $key['StatusReg'];
            $pasing['statusid'] = $key['statusid'];
            $pasing['judul'] = $key['judul'];
            $pasing['TipePasien'] = $key['TipePasien'];
            $pasing['GroupJaminan'] = $key['GroupJaminan'];

            // $pasing['emailpasien'] = $key['emailpasien'];

            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataListBillingRajal($data)
    {
        try {
            $tglawal = $data['tglawal'];
            $tglakhir = $data['tglakhir'];
            $this->db->query("SELECT a.NoMR,a.NoRegistrasi,b.PatientName as NamaPasien,
            a.TglKunjungan,c.NamaUnit,d.First_Name as NamaDokter,
            e.TypePatient as TipePenjamin,f.NamaPerusahaan as NamaPenjamin,a.NoSEP,
            ss.[Status Name] as NamaStatus,
            a.SelesaiPerawat,a.SelesaiPoli,a.SelesaiOptik,a.SelesaiFarmasi
            FROM PerawatanSQL.dbo.Visit a 
            inner join MasterDataSQL.dbo.Admision b on a.NoMR=b.NoMR
            left join MasterDataSQL.dbo.MstrUnitPerwatan c on a.Unit=c.ID 
            left join MasterDataSQL.dbo.Doctors d on a.Doctor_1=d.ID 
            inner join MasterdataSQL.dbo.MstrTypePatient e on a.PatientType=e.ID 
            inner join MasterDataSQL.dbo.MstrPerusahaanAsuransi f on a.Asuransi=f.ID
            inner join RawatInapSQL.dbo.[Visit Status] ss on a.[Status ID]=ss.[Status ID]
            Where a.[Status ID]<>4  and a.batal=0 AND a.PatientType='2' AND
                 replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-')  between :tglawal and :tglakhir
                 UNION ALL
            SELECT a.NoMR,a.NoRegistrasi,b.PatientName as NamaPasien,
            a.TglKunjungan,c.NamaUnit,d.First_Name as NamaDokter,
            e.TypePatient as TipePenjamin,f.NamaPerusahaan as NamaPenjamin,a.NoSEP,
            ss.[Status Name] as NamaStatus,
            a.SelesaiPerawat,a.SelesaiPoli,a.SelesaiOptik,a.SelesaiFarmasi
            FROM PerawatanSQL.dbo.Visit a 
            inner join MasterDataSQL.dbo.Admision b on a.NoMR=b.NoMR
            left join MasterDataSQL.dbo.MstrUnitPerwatan c on a.Unit=c.ID 
            left join MasterDataSQL.dbo.Doctors d on a.Doctor_1=d.ID 
            inner join MasterdataSQL.dbo.MstrTypePatient e on a.PatientType=e.ID 
            inner join MasterDataSQL.dbo.MstrPerusahaanJPK f on a.Perusahaan=f.ID
            inner join RawatInapSQL.dbo.[Visit Status] ss on a.[Status ID]=ss.[Status ID]
            Where a.[Status ID]<>4  and a.batal=0 AND a.PatientType<>'2' AND
                 replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-')  between :tglawal2 and :tglakhir2
                 --order by  a.[Visit Date]  desc,NamaUnit ASC , NamaDokter ASC
             ");
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $this->db->bind('tglawal2', $tglawal);
            $this->db->bind('tglakhir2', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['NamaPasien'] = $key['NamaPasien'];
                $pasing['TglKunjungan'] = $key['TglKunjungan'];
                $pasing['NamaUnit'] = $key['NamaUnit'];
                $pasing['NamaDokter'] = $key['NamaDokter'];
                $pasing['TipePenjamin'] = $key['TipePenjamin'];
                $pasing['NamaPenjamin'] = $key['NamaPenjamin'];
                $pasing['NoSEP'] = $key['NoSEP'];
                $pasing['NamaStatus'] = $key['NamaStatus'];
                $pasing['SelesaiPerawat'] = $key['SelesaiPerawat'];
                $pasing['SelesaiPoli'] = $key['SelesaiPoli'];
                $pasing['SelesaiOptik'] = $key['SelesaiOptik'];
                $pasing['SelesaiFarmasi'] = $key['SelesaiFarmasi']; 
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataListBillingRajal_Arsip($data)
    {
        try {
            $tglawal = $data['tglawal'];
            $tglakhir = $data['tglakhir'];
            $this->db->query("SELECT a.NoMR,a.NoRegistrasi,b.PatientName as NamaPasien,a.TglKunjungan,c.NamaUnit,d.First_Name as NamaDokter,e.TypePatient as TipePenjamin,f.NamaPerusahaan as NamaPenjamin,a.NoSEP,ss.[Status Name] as NamaStatus
            FROM PerawatanSQL.dbo.Visit a 
            inner join MasterDataSQL.dbo.Admision b on a.NoMR=b.NoMR
            left join MasterDataSQL.dbo.MstrUnitPerwatan c on a.Unit=c.ID 
            left join MasterDataSQL.dbo.Doctors d on a.Doctor_1=d.ID 
            inner join MasterdataSQL.dbo.MstrTypePatient e on a.PatientType=e.ID 
            inner join MasterDataSQL.dbo.MstrPerusahaanAsuransi f on a.Asuransi=f.ID
            inner join RawatInapSQL.dbo.[Visit Status] ss on a.[Status ID]=ss.[Status ID]
            Where a.[Status ID]=4  and a.batal=0 AND a.PatientType='2' AND
                 replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-')  between :tglawal and :tglakhir
                 UNION ALL
                 SELECT a.NoMR,a.NoRegistrasi,b.PatientName as NamaPasien,a.TglKunjungan,c.NamaUnit,d.First_Name as NamaDokter,e.TypePatient as TipePenjamin,f.NamaPerusahaan as NamaPenjamin,a.NoSEP,ss.[Status Name] as NamaStatus
            FROM PerawatanSQL.dbo.Visit a 
            inner join MasterDataSQL.dbo.Admision b on a.NoMR=b.NoMR
            left join MasterDataSQL.dbo.MstrUnitPerwatan c on a.Unit=c.ID 
            left join MasterDataSQL.dbo.Doctors d on a.Doctor_1=d.ID 
            inner join MasterdataSQL.dbo.MstrTypePatient e on a.PatientType=e.ID 
            inner join MasterDataSQL.dbo.MstrPerusahaanJPK f on a.Perusahaan=f.ID
            inner join RawatInapSQL.dbo.[Visit Status] ss on a.[Status ID]=ss.[Status ID]
            Where a.[Status ID]=4  and a.batal=0 AND a.PatientType<>'2' AND
                 replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-')  between :tglawal2 and :tglakhir2
                 --order by  a.[Visit Date]  desc,NamaUnit ASC , NamaDokter ASC
             ");
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $this->db->bind('tglawal2', $tglawal);
            $this->db->bind('tglakhir2', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['NamaPasien'] = $key['NamaPasien'];
                $pasing['TglKunjungan'] = $key['TglKunjungan'];
                $pasing['NamaUnit'] = $key['NamaUnit'];
                $pasing['NamaDokter'] = $key['NamaDokter'];
                $pasing['TipePenjamin'] = $key['TipePenjamin'];
                $pasing['NamaPenjamin'] = $key['NamaPenjamin'];
                $pasing['NoSEP'] = $key['NoSEP'];
                $pasing['NamaStatus'] = $key['NamaStatus'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataListBillingWalkin($data)
    {
        try {
            $tglawal = $data['tglawal'];
            $tglakhir = $data['tglakhir'];
            $this->db->query("SELECT a.NoMR,a.NoRegistrasi,b.PatientName as NamaPasien,a.TglKunjungan,c.NamaUnit,d.First_Name as NamaDokter,e.TypePatient as TipePenjamin,f.NamaPerusahaan as NamaPenjamin,a.NoSEP,ss.[Status Name] as NamaStatus
            FROM PerawatanSQL.dbo.Visit a 
            inner join MasterDataSQL.dbo.Admision_walkin b on a.NoMR=b.NoMR
            left join MasterDataSQL.dbo.MstrUnitPerwatan c on a.Unit=c.ID 
            left join MasterDataSQL.dbo.Doctors d on a.Doctor_1=d.ID 
            inner join MasterdataSQL.dbo.MstrTypePatient e on a.PatientType=e.ID 
            inner join MasterDataSQL.dbo.MstrPerusahaanAsuransi f on a.Asuransi=f.ID
            inner join RawatInapSQL.dbo.[Visit Status] ss on a.[Status ID]=ss.[Status ID]
            Where a.[Status ID]<>4  and a.batal=0 AND a.PatientType='2' AND
                 replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-')  between :tglawal and :tglakhir
                 UNION ALL
                 SELECT a.NoMR,a.NoRegistrasi,b.PatientName as NamaPasien,a.TglKunjungan,c.NamaUnit,d.First_Name as NamaDokter,e.TypePatient as TipePenjamin,f.NamaPerusahaan as NamaPenjamin,a.NoSEP,ss.[Status Name] as NamaStatus
            FROM PerawatanSQL.dbo.Visit a 
            inner join MasterDataSQL.dbo.Admision_walkin b on a.NoMR=b.NoMR
            left join MasterDataSQL.dbo.MstrUnitPerwatan c on a.Unit=c.ID 
            left join MasterDataSQL.dbo.Doctors d on a.Doctor_1=d.ID 
            inner join MasterdataSQL.dbo.MstrTypePatient e on a.PatientType=e.ID 
            inner join MasterDataSQL.dbo.MstrPerusahaanJPK f on a.Perusahaan=f.ID
            inner join RawatInapSQL.dbo.[Visit Status] ss on a.[Status ID]=ss.[Status ID]
            Where a.[Status ID]<>4  and a.batal=0 AND a.PatientType<>'2' AND
                 replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-')  between :tglawal2 and :tglakhir2
                 --order by  a.[Visit Date]  desc,NamaUnit ASC , NamaDokter ASC
             ");
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $this->db->bind('tglawal2', $tglawal);
            $this->db->bind('tglakhir2', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['NamaPasien'] = $key['NamaPasien'];
                $pasing['TglKunjungan'] = $key['TglKunjungan'];
                $pasing['NamaUnit'] = $key['NamaUnit'];
                $pasing['NamaDokter'] = $key['NamaDokter'];
                $pasing['TipePenjamin'] = $key['TipePenjamin'];
                $pasing['NamaPenjamin'] = $key['NamaPenjamin'];
                $pasing['NoSEP'] = $key['NoSEP'];
                $pasing['NamaStatus'] = $key['NamaStatus'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataListBillingWalkin_Arsip($data)
    {
        try {
            $tglawal = $data['tglawal'];
            $tglakhir = $data['tglakhir'];
            $this->db->query("SELECT a.NoMR,a.NoRegistrasi,b.PatientName as NamaPasien,a.TglKunjungan,c.NamaUnit,d.First_Name as NamaDokter,e.TypePatient as TipePenjamin,f.NamaPerusahaan as NamaPenjamin,a.NoSEP,ss.[Status Name] as NamaStatus
            FROM PerawatanSQL.dbo.Visit a 
            inner join MasterDataSQL.dbo.Admision_walkin b on a.NoMR=b.NoMR
            left join MasterDataSQL.dbo.MstrUnitPerwatan c on a.Unit=c.ID 
            left join MasterDataSQL.dbo.Doctors d on a.Doctor_1=d.ID 
            inner join MasterdataSQL.dbo.MstrTypePatient e on a.PatientType=e.ID 
            inner join MasterDataSQL.dbo.MstrPerusahaanAsuransi f on a.Asuransi=f.ID
            inner join RawatInapSQL.dbo.[Visit Status] ss on a.[Status ID]=ss.[Status ID]
            Where a.[Status ID]=4  and a.batal=0 AND a.PatientType='2' AND
                 replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-')  between :tglawal and :tglakhir
                 UNION ALL
                 SELECT a.NoMR,a.NoRegistrasi,b.PatientName as NamaPasien,a.TglKunjungan,c.NamaUnit,d.First_Name as NamaDokter,e.TypePatient as TipePenjamin,f.NamaPerusahaan as NamaPenjamin,a.NoSEP,ss.[Status Name] as NamaStatus
            FROM PerawatanSQL.dbo.Visit a 
            inner join MasterDataSQL.dbo.Admision_walkin b on a.NoMR=b.NoMR
            left join MasterDataSQL.dbo.MstrUnitPerwatan c on a.Unit=c.ID 
            left join MasterDataSQL.dbo.Doctors d on a.Doctor_1=d.ID 
            inner join MasterdataSQL.dbo.MstrTypePatient e on a.PatientType=e.ID 
            inner join MasterDataSQL.dbo.MstrPerusahaanJPK f on a.Perusahaan=f.ID
            inner join RawatInapSQL.dbo.[Visit Status] ss on a.[Status ID]=ss.[Status ID]
            Where a.[Status ID]=4  and a.batal=0 AND a.PatientType<>'2' AND
                 replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-')  between :tglawal2 and :tglakhir2
                 --order by  a.[Visit Date]  desc,NamaUnit ASC , NamaDokter ASC
             ");
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $this->db->bind('tglawal2', $tglawal);
            $this->db->bind('tglakhir2', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['NamaPasien'] = $key['NamaPasien'];
                $pasing['TglKunjungan'] = $key['TglKunjungan'];
                $pasing['NamaUnit'] = $key['NamaUnit'];
                $pasing['NamaDokter'] = $key['NamaDokter'];
                $pasing['TipePenjamin'] = $key['TipePenjamin'];
                $pasing['NamaPenjamin'] = $key['NamaPenjamin'];
                $pasing['NoSEP'] = $key['NoSEP'];
                $pasing['NamaStatus'] = $key['NamaStatus'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataListBillingRanap($data)
    {
        try {
            $tglawal = $data['tglawal'];
            $tglakhir = $data['tglakhir'];
            $this->db->query(" SELECT a.NoMR,a.NoRegRI as NoRegistrasi,b.PatientName as NamaPasien,a.StartDate as TglKunjungan,'' as NamaUnit,d.First_Name as NamaDokter
            ,e.TypePatient as TipePenjamin,f.NamaPerusahaan as NamaPenjamin,a.NoSEP,ss.[Status Name] as NamaStatus
            FROM RawatInapSQL.dbo.Inpatient a 
            inner join MasterDataSQL.dbo.Admision b on a.NoMR=b.NoMR
            -- left join MasterDataSQL.dbo.MstrUnitPerwatan c on a.Unit=c.ID 
            left join MasterDataSQL.dbo.Doctors d on a.drPenerima=d.ID 
            inner join MasterdataSQL.dbo.MstrTypePatient e on a.TypePatient=e.ID 
            inner join MasterDataSQL.dbo.MstrPerusahaanAsuransi f on a.IDAsuransi=f.ID
            inner join RawatInapSQL.dbo.[Visit Status] ss on a.[StatusID]=ss.[Status ID]
            Where a.[StatusID]<>4   AND a.TypePatient='2' AND
            replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-')  between :tglawal and :tglakhir
            UNION ALL
            SELECT a.NoMR,a.NoRegRI as NoRegistrasi,b.PatientName as NamaPasien,a.StartDate as TglKunjungan,'' as NamaUnit,d.First_Name as NamaDokter
                        ,e.TypePatient as TipePenjamin,f.NamaPerusahaan as NamaPenjamin,a.NoSEP,ss.[Status Name] as NamaStatus
            FROM RawatInapSQL.dbo.Inpatient a 
            inner join MasterDataSQL.dbo.Admision b on a.NoMR=b.NoMR
            -- left join MasterDataSQL.dbo.MstrUnitPerwatan c on a.Unit=c.ID 
            left join MasterDataSQL.dbo.Doctors d on a.drPenerima=d.ID 
            inner join MasterdataSQL.dbo.MstrTypePatient e on a.TypePatient=e.ID 
            inner join MasterDataSQL.dbo.MstrPerusahaanJPK f on a.IDJPK=f.ID
            inner join RawatInapSQL.dbo.[Visit Status] ss on a.[StatusID]=ss.[Status ID]
            Where a.[StatusID]<>4   AND a.TypePatient<>'2' AND
            replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-')  between :tglawal2 and :tglakhir2
                 --order by  a.[Visit Date]  desc,NamaUnit ASC , NamaDokter ASC
             ");
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $this->db->bind('tglawal2', $tglawal);
            $this->db->bind('tglakhir2', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['NamaPasien'] = $key['NamaPasien'];
                $pasing['TglKunjungan'] = $key['TglKunjungan'];
                $pasing['NamaUnit'] = $key['NamaUnit'];
                $pasing['NamaDokter'] = $key['NamaDokter'];
                $pasing['TipePenjamin'] = $key['TipePenjamin'];
                $pasing['NamaPenjamin'] = $key['NamaPenjamin'];
                $pasing['NoSEP'] = $key['NoSEP'];
                $pasing['NamaStatus'] = $key['NamaStatus'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataListBillingRanap_Arsip($data)
    {
        try {
            $tglawal = $data['tglawal'];
            $tglakhir = $data['tglakhir'];
            $this->db->query(" SELECT a.NoMR,a.NoRegRI as NoRegistrasi,b.PatientName as NamaPasien,a.StartDate as TglKunjungan,'' as NamaUnit,d.First_Name as NamaDokter
            ,e.TypePatient as TipePenjamin,f.NamaPerusahaan as NamaPenjamin,a.NoSEP,ss.[Status Name] as NamaStatus
            FROM RawatInapSQL.dbo.Inpatient a 
            inner join MasterDataSQL.dbo.Admision b on a.NoMR=b.NoMR
            -- left join MasterDataSQL.dbo.MstrUnitPerwatan c on a.Unit=c.ID 
            left join MasterDataSQL.dbo.Doctors d on a.drPenerima=d.ID 
            inner join MasterdataSQL.dbo.MstrTypePatient e on a.TypePatient=e.ID 
            inner join MasterDataSQL.dbo.MstrPerusahaanAsuransi f on a.IDAsuransi=f.ID
            inner join RawatInapSQL.dbo.[Visit Status] ss on a.[StatusID]=ss.[Status ID]
            Where a.[StatusID]=4   AND a.TypePatient='2' AND
            replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-')  between :tglawal and :tglakhir
            UNION ALL
            SELECT a.NoMR,a.NoRegRI as NoRegistrasi,b.PatientName as NamaPasien,a.StartDate as TglKunjungan,'' as NamaUnit,d.First_Name as NamaDokter
                        ,e.TypePatient as TipePenjamin,f.NamaPerusahaan as NamaPenjamin,a.NoSEP,ss.[Status Name] as NamaStatus
            FROM RawatInapSQL.dbo.Inpatient a 
            inner join MasterDataSQL.dbo.Admision b on a.NoMR=b.NoMR
            -- left join MasterDataSQL.dbo.MstrUnitPerwatan c on a.Unit=c.ID 
            left join MasterDataSQL.dbo.Doctors d on a.drPenerima=d.ID 
            inner join MasterdataSQL.dbo.MstrTypePatient e on a.TypePatient=e.ID 
            inner join MasterDataSQL.dbo.MstrPerusahaanJPK f on a.IDJPK=f.ID
            inner join RawatInapSQL.dbo.[Visit Status] ss on a.[StatusID]=ss.[Status ID]
            Where a.[StatusID]=4   AND a.TypePatient<>'2' AND
            replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-')  between :tglawal2 and :tglakhir2
                 --order by  a.[Visit Date]  desc,NamaUnit ASC , NamaDokter ASC
             ");
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $this->db->bind('tglawal2', $tglawal);
            $this->db->bind('tglakhir2', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['NamaPasien'] = $key['NamaPasien'];
                $pasing['TglKunjungan'] = $key['TglKunjungan'];
                $pasing['NamaUnit'] = $key['NamaUnit'];
                $pasing['NamaDokter'] = $key['NamaDokter'];
                $pasing['TipePenjamin'] = $key['TipePenjamin'];
                $pasing['NamaPenjamin'] = $key['NamaPenjamin'];
                $pasing['NoSEP'] = $key['NoSEP'];
                $pasing['NamaStatus'] = $key['NamaStatus'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // Penjualan Obat Bebas
    public function getDataListBillingBebas($data)
    {
        try {
            //13-09-2024 editan fiqri
            $tglawal = $data['tglawal'];
            $tglakhir = $data['tglakhir'];
            $this->db->query("SELECT TransactionCode,'-' as NoMR,NoRegistrasi,NamaPembeli as NamaPasien,TransactionDate as TglKunjungan,JenisPasien AS NamaUnit,
CASE 
WHEN b.NO_TRS_BILLING  IS NULL AND c.NO_TRS IS NULL AND d.NOREG_FIRST IS NULL THEN 'NEW' 
WHEN b.NO_TRS_BILLING IS NOT NUll AND c.NO_TRS IS NULL AND d.NOREG_FIRST IS NULL THEN 'APPROVED' 
WHEN b.NO_TRS_BILLING IS NOT NUll AND c.NO_TRS IS NOT NULL AND d.NOREG_FIRST IS NULL THEN 'PAYMENT'
ELSE 'CLOSED' END AS NamaStatus
                FROM [Apotik_V1.1SQL].dbo.v_transaksi_sales_hdr a
				LEFT JOIN Billing_Pasien.dbo.FO_T_BILLING b on b.NO_REGISTRASI = a.TransactionCode
				LEFT JOIN Billing_Pasien.dbo.FO_T_KASIR c on c.NO_REGISTRASI = a.TransactionCode
				LEFT JOIN Billing_Pasien.dbo.CLOSING_BILL d on d.NOREG_FIRST = a.TransactionCode
                Where replace(CONVERT(VARCHAR(11),TransactionDate, 111), '/','-')  between :tglawal and :tglakhir and Group_Transaksi='NON RESEP' AND d.NOREG_FIRST IS NULL AND a.Void = '0'  ");
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['NamaPasien'] = $key['NamaPasien'];
                $pasing['TglKunjungan'] = $key['TglKunjungan'];
                $pasing['NamaUnit'] = $key['NamaUnit'];
                $pasing['NamaStatus'] = $key['NamaStatus'];
                $pasing['TransactionCode'] = $key['TransactionCode'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDataListBillingBebas_Arsip($data)
    {
        try {
            $tglawal = $data['tglawal'];
            $tglakhir = $data['tglakhir'];
            $this->db->query("SELECT TransactionCode,'-' as NoMR,NoRegistrasi,NamaPembeli as NamaPasien,TransactionDate as TglKunjungan,JenisPasien AS NamaUnit,
CASE 
WHEN b.NO_TRS_BILLING  IS NULL AND c.NO_TRS IS NULL AND d.NOREG_FIRST IS NULL THEN 'NEW' 
WHEN b.NO_TRS_BILLING IS NOT NUll AND c.NO_TRS IS NULL AND d.NOREG_FIRST IS NULL THEN 'APPROVED' 
WHEN b.NO_TRS_BILLING IS NOT NUll AND c.NO_TRS IS NOT NULL AND d.NOREG_FIRST IS NULL THEN 'PAYMENT'
ELSE 'CLOSED' END AS NamaStatus
                FROM [Apotik_V1.1SQL].dbo.v_transaksi_sales_hdr a
				LEFT JOIN Billing_Pasien.dbo.FO_T_BILLING b on b.NO_REGISTRASI = a.TransactionCode
				LEFT JOIN Billing_Pasien.dbo.FO_T_KASIR c on c.NO_REGISTRASI = a.TransactionCode
				LEFT JOIN Billing_Pasien.dbo.CLOSING_BILL d on d.NOREG_FIRST = a.TransactionCode
                Where replace(CONVERT(VARCHAR(11),TransactionDate, 111), '/','-')  between :tglawal and :tglakhir and Group_Transaksi='NON RESEP' AND d.NOREG_FIRST IS NOT NULL AND a.Void = '0'");
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['NamaPasien'] = $key['NamaPasien'];
                $pasing['TglKunjungan'] = $key['TglKunjungan'];
                $pasing['NamaUnit'] = $key['NamaUnit'];
                $pasing['NamaStatus'] = $key['NamaStatus'];
                $pasing['TransactionCode'] = $key['TransactionCode'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    public function getDataPasienBebas($data)
    {
        try {
            $notrscode = $data['NoRegistrasi'];
            $this->db->query("SELECT TransactionCode, NamaPembeli, GenderPembeli, JenisPasien, replace(CONVERT(VARCHAR(11), TglLahirPembeli, 111), '/','-') as TglLahir, 
replace(CONVERT(VARCHAR(11), TransactionDate, 111), '/','-') as TglKunjungan, NamaUnit, NamaJaminan, KodeJaminan, GroupJaminan, AlamatPembeli,
CASE 
WHEN b.NO_TRS_BILLING  IS NULL AND c.NO_TRS IS NULL AND d.NOREG_FIRST IS NULL THEN 'NEW' 
WHEN b.NO_TRS_BILLING IS NOT NUll AND c.NO_TRS IS NULL AND d.NOREG_FIRST IS NULL THEN 'APPROVED' 
WHEN b.NO_TRS_BILLING IS NOT NUll AND c.NO_TRS IS NOT NULL AND d.NOREG_FIRST IS NULL THEN 'PAYMENT'
ELSE 'CLOSED' END AS NamaStatus,
CASE
WHEN b.NO_TRS_BILLING IS NOT NUll AND c.NO_TRS IS NOT NULL AND d.NOREG_FIRST IS NOT NULL THEN 'close'
ELSE 'open' END AS statusclose
FROM [Apotik_V1.1SQL].dbo.v_transaksi_sales_hdr a
LEFT JOIN Billing_Pasien.dbo.FO_T_BILLING b on b.NO_REGISTRASI = a.TransactionCode
				LEFT JOIN Billing_Pasien.dbo.FO_T_KASIR c on c.NO_REGISTRASI = a.TransactionCode
				LEFT JOIN Billing_Pasien.dbo.CLOSING_BILL d on d.NOREG_FIRST = a.TransactionCode WHERE TransactionCode = :notrscode");
            $this->db->bind('notrscode', $notrscode);
            $key =  $this->db->single();
            $pasing['TransactionCode'] = $key['TransactionCode'];
            $pasing['NamaPembeli'] = $key['NamaPembeli'];
            $pasing['GenderPembeli'] = $key['GenderPembeli'];
            $pasing['JenisPasien'] = $key['JenisPasien'];
            $pasing['TglLahir'] = $key['TglLahir'];
            $pasing['TglKunjungan'] = $key['TglKunjungan'];
            $pasing['NamaUnit'] = $key['NamaUnit'];
            $pasing['NamaJaminan'] = $key['NamaJaminan'];
            $pasing['KodeJaminan'] = $key['KodeJaminan'];
            $pasing['GroupJaminan'] = $key['GroupJaminan'];
            $pasing['AlamatPembeli'] = $key['AlamatPembeli'];
            $pasing['StatusReg'] = $key['NamaStatus'];
            $pasing['statusclose'] = $key['statusclose'];

            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataApproveFarmasiBebas($data)
    {
        try {
            $notrs = $data['noreg'];
            $tglawal = $data['tglawal'];
            $tglakhir = $data['tglakhir'];
            $substr = substr($notrs, 0, 2);

            // Badrul
            // Start Data Approve
            $query = "SELECT a.ID, TransactionCode, Satuan_Beli, ProductCode, ProductName, a.Qty, a.Grandtotal, '-' AS StatusOrder, replace(CONVERT(VARCHAR(11), DateAdd, 111), '/','-') as TglOrder, 
            CASE 
	        WHEN b.NO_TRS_BILLING  IS NULL THEN 'NEW'
	        ELSE 'APPROVED' END AS NamaStatus
            FROM [Apotik_V1.1SQL].dbo.v_transaksi_sales_dtl a
			LEFT JOIN Billing_Pasien.dbo.FO_T_BILLING_1 b on b.KODE_REF = a.ID
			WHERE TransactionCode = :notrs1 AND a.Void = '0' AND replace(CONVERT(VARCHAR(11), DateAdd, 111), '/','-') Between :tglawal AND :tglakhir";
            // End Data Approve
            // Badrul

            $this->db->query($query);
            $this->db->bind('notrs1', $notrs);
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['ID'] = $key['ID'];
                $pasing['TransactionCode'] = $key['TransactionCode'];
                $pasing['Satuan_Beli'] = $key['Satuan_Beli'];
                $pasing['ProductCode'] = $key['ProductCode'];
                $pasing['ProductName'] = $key['ProductName'];
                $pasing['Qty'] = $key['Qty'];
                $pasing['Grandtotal'] = number_format($key['Grandtotal'], 0, ',', '.');
                $pasing['StatusOrder'] = $key['StatusOrder'];
                $pasing['TglOrder'] = $key['TglOrder'];
                $pasing['NamaStatus'] = $key['NamaStatus'];
                //$rows[] = $pasing;
                $rows[] = $pasing;
            }
            // var_dump($rows);
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function ApprovePenjualanBebas($data)
    {
        try {
            $this->db->transaksi();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();

            $noreg = $data['noreg'];
            $noeps = $data['noeps'];
            $nomr = $data['nomr'];
            $datebill = $data['datebill'];
            $datebills  = date('dmy', strtotime($datebill));
            $datenowcreatex =  $datebill . ' 00:00:00';
            $dataaptk = $data['data'];
            $idbtn = $_POST['idbtn'];
            $getREG = $data['getreg'];
            $kelas = NULL;

            //noreg = transaction code

            $this->db->query("SELECT COUNT(*) AS statuspasien FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE NO_REGISTRASI = :norega1 AND BATAL = '0' AND ID_TRS_Payment IS NOT NULL");
            $this->db->bind('norega1', $data['noreg']);
            $statuscek =  $this->db->single();
            $statuspasien = $statuscek['statuspasien'];

            if ($statuspasien <> '0') {
                $callback = array(
                    'status' => "error", // Set array nama
                    'message' => "Gagal, Status Penjualan Bebas Sudah Di Approve dan Sudah ada Pembayaran"
                );
                return $callback;
                exit;
            }

            if ($idbtn == 'cb_approvefarmasiall') {
                //Cek
                $this->db->query("SELECT COUNT(*) AS statuspasien FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE NO_REGISTRASI = :norega2 AND BATAL = '0'");
                $this->db->bind('norega2', $data['noreg']);
                $statuscek2 =  $this->db->single();
                $statuspasie2 = $statuscek2['statuspasien'];

                if ($statuspasie2 <> '0') {
                    $callback = array(
                        'status' => "error", // Set array nama
                        'message' => "Gagal Approve, Status Penjualan Bebas Sudah Di Approve"
                    );
                    return $callback;
                    exit;
                }

                $datenowcreate = Utils::seCurrentDateTime();
                $datenowcreate1 = date('Y-m-d', strtotime($datenowcreate));
                $datenowcreate2 = date('dmy', strtotime($datenowcreate));
                $session = SessionManager::getCurrentSession();
                $namauserx = $session->name;

                $this->db->query("SELECT ID AS Unit FROM MasterdataSQL.dbo.MstrUnitPerwatan WHERE NamaUnit = :NamaUnit1");
                $this->db->bind('NamaUnit1', $data['lokasipembelian']);
                $datax =  $this->db->single();

                $IdGrupPerawatan = $datax['Unit'];
                $JenisBayar = $data['PatientType'];
                $perusahaanid = $data['perusahaanid'];
                $datenowcreatex1 = $datenowcreatex;

                // insert ke tabel FO_T_Billing
                $this->db->query("INSERT INTO Billing_Pasien.dbo.FO_T_BILLING
                    ([NO_TRS_BILLING],[TGL_BILLING],[PETUGAS_ENTRY],[NO_MR],[NO_EPISODE],[NO_REGISTRASI],[UNIT],[GROUP_JAMINAN],[KODE_JAMINAN],[TOTAL_TARIF],[TOTAL_QTY],[SUBTOTAL],[TOTAL_DISCOUNT],[TOTAL_DISCOUNT_RP],[SUBTOTAL_2],[GRANDTOTAL],[BATAL],[FB_CLOSE_KEUANGAN],[FB_VERIF_JURNAL]) 
                    VALUES
                    (:notrsbill,:datenowx,:namauserx,:NoMrfix,:NoEpisode,:nofixReg,:IdGrupPerawatan,:JenisBayar,:perusahaanid,:totaltarif,:totalqty,:subtotal,:totaldiscount,:totaldiscountrp,:subtotal2,:grandtotal,:batal,:closekeuangan,:verifkeuangan)");

                $this->db->bind('notrsbill', $noreg);
                $this->db->bind('datenowx', $datenowcreatex1);
                $this->db->bind('namauserx', $namauserx);
                $this->db->bind('NoMrfix', $nomr);
                $this->db->bind('NoEpisode', $noeps);
                $this->db->bind('nofixReg', $noreg);
                $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                $this->db->bind('JenisBayar', $JenisBayar);
                $this->db->bind('perusahaanid', $perusahaanid);
                $this->db->bind('totaltarif', 0);
                $this->db->bind('totalqty', 0);
                $this->db->bind('subtotal', 0);
                $this->db->bind('totaldiscount', 0);
                $this->db->bind('totaldiscountrp', 0);
                $this->db->bind('subtotal2', 0);
                $this->db->bind('grandtotal', 0);
                $this->db->bind('batal', 0);
                $this->db->bind('closekeuangan', 0);
                $this->db->bind('verifkeuangan', 0);
                $this->db->execute();

                //GET acc number
                $this->db->query("SELECT ID AS ID_Detail, ProductCode AS 'Kode_Tarif', ProductName AS Nama_Tarif, isnull(Qty,0) as QtyRealisasi, Harga, Discount  FROM [Apotik_V1.1SQL].dbo.v_transaksi_sales_dtl WHERE TransactionCode = :dataaptk1");
                $this->db->bind('dataaptk1', $dataaptk);
                $dataaptk_dtl =  $this->db->resultSet();
                foreach ($dataaptk_dtl as $key) {
                    if ($data['GROUP_JAMINAN'] == "1") {
                        $kekurangan = $key['QtyRealisasi'] * $key['Harga'];
                        $klaim = "0";
                        $bayar = "0";
                    } else {
                        $kekurangan = "0";
                        $klaim = $key['QtyRealisasi'] * $key['Harga'];
                        $bayar = "0";
                    }

                    // insert ke tabel FO_T_Billing_1
                    $this->db->query("INSERT INTO  Billing_Pasien.dbo.FO_T_BILLING_1
                        (ID_BILL,[NO_TRS_BILLING],[TGL_BILLING] ,[PETUGAS_ENTRY],[NO_MR],[NO_EPISODE],[NO_REGISTRASI],[KODE_TARIF],[UNIT],[GROUP_JAMINAN],[KODE_JAMINAN],
                        [NAMA_TARIF],[GROUP_TARIF],[KD_KELAS],[QTY],[NILAI_TARIF],[SUB_TOTAL],[DISC],[DISC_RP],[SUB_TOTAL_2],[GRANDTOTAL],[KODE_REF],[KD_DR],[NM_DR],
                        [BATAL],[PETUGAS_BATAL],[GROUP_ENTRI], [KEKURANGAN], [KLAIM], [BAYAR])
                        SELECT :dataaptk2,:notrsbill , :datenowcreatex as datenow,:namauserx as namauserx,:nomr AS NoMR, :noeps AS xNoEpisode,:noreg as NoReg,:Rad_Kode_Tarif as kodetarif,UNIT,GROUP_JAMINAN,KODE_JAMINAN,:Rad_Nama_Tarif as namatarif,'Farmasi' as far, :kdkelas, :Qty as QTY, :Rad_Nilai as nilai, :Rad_Nilai2 as nilai2,:Discount as DISC,:Discount_RP as DISC_RP, :Rad_Nilai3 as nilai3, :Rad_Nilai4 as nilai4,:ID_Detail, :Farm_Dokter, null as namadokter, 0 as batal,null as petugasbatal,'BEBAS', :kekurangan, :klaim, :bayar
                        FROM Billing_Pasien.dbo.FO_T_BILLING
                        WHERE NO_TRS_BILLING=:notrsbill2 AND Batal='0'");
                    $this->db->bind('dataaptk2', $dataaptk);
                    $this->db->bind('ID_Detail', $key['ID_Detail']);
                    $this->db->bind('notrsbill', $noreg);
                    $this->db->bind('notrsbill2', $noreg);
                    $this->db->bind('datenowcreatex', $datenowcreatex1);
                    $this->db->bind('namauserx', $namauserx);
                    $this->db->bind('nomr', $nomr);
                    $this->db->bind('noeps', $noeps);
                    $this->db->bind('noreg', $noreg);
                    $this->db->bind('Rad_Kode_Tarif', $key['Kode_Tarif']);
                    $this->db->bind('Rad_Nama_Tarif', $key['Nama_Tarif']);
                    $this->db->bind('kdkelas', $kelas);
                    $this->db->bind('Qty',  $key['QtyRealisasi']);
                    $this->db->bind('Rad_Nilai',  $key['Harga']);
                    $this->db->bind('Rad_Nilai2', $key['QtyRealisasi'] * $key['Harga']);
                    $this->db->bind('Discount', $key['Discount']);
                    $this->db->bind('Discount_RP', $key['Discount'] * $key['Harga']);
                    $this->db->bind('Rad_Nilai3', ($key['Harga'] * $key['QtyRealisasi']) * (1 - $key['Discount']));
                    $this->db->bind('Rad_Nilai4', ($key['Harga'] * $key['QtyRealisasi']) * (1 - $key['Discount']));
                    $this->db->bind('Farm_Dokter', '0');
                    $this->db->bind('kekurangan', $kekurangan);
                    $this->db->bind('klaim', $klaim);
                    $this->db->bind('bayar', $bayar);
                    $this->db->execute();
                }

                // var_dump('masukkk');
                // exit;
                //Insert ke tabel FO_T_Billing_2
                $this->db->query("INSERT INTO Billing_Pasien.DBO.FO_T_BILLING_2
                SELECT ID_BILL,A.NO_TRS_BILLING AS NO_TRS_BILLING,A1.KODE_TARIF,B.KD_TIPE_PDP as Kode_komponen,A1.UNIT AS UNIT, A1.GROUP_JAMINAN AS GROUP_JAMINAN, A1.KODE_JAMINAN AS KODE_JAMINAN, 
                A1.NAMA_TARIF AS NAMA_TARIF, 
                A1.GROUP_TARIF AS GROUP_TARIF, A1.KD_KELAS as KELAS,A1.QTY AS QTY, 
                A1.NILAI_TARIF AS NILAI_TARIF  ,
                A1.NILAI_TARIF*A1.QTY  AS SUBTOTAL,
                A1.DISC AS DISC,
                (A1.NILAI_TARIF-((A1.NILAI_TARIF*A1.DISC)/100)) AS DISC_RP,
                ((A1.NILAI_TARIF*A1.QTY)-(((A1.NILAI_TARIF*A1.QTY)*A1.DISC)/100))   SUB_TOTAL_PDP_2,
                (CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN ((((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*A1.DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' THEN ((b.NILAI_FIX*A1.QTY*A1.DISC)/100)*A1.QTY END ) NILAI_DISKON_PDP,
                (CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN (((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY)-(((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*A1.DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' THEN (b.NILAI_FIX*A1.QTY)-((b.NILAI_FIX*A1.QTY*A1.DISC)/100)*A1.QTY END ) as NILAI_PDP,
                A1.KD_DR AS KD_DR, '' NM_DR,b.NILAI_PROSEN,'0' AS BATAL,'' PETUGAS_BATAL, '' AS JAM_BATAL, B.KD_POSTING AS KD_POSTING,'' as kd_posting_diskon, 0 as ID_TR_TARIF_PAKET
                FROM Billing_Pasien.DBO.FO_T_BILLING A
                inner join Billing_Pasien.dbo.FO_T_BILLING_1 A1
                ON A.NO_TRS_BILLING = A1.NO_TRS_BILLING
                INNER JOIN [Apotik_V1.1SQL].dbo.Products CC 
                ON CC.ID = A1.KODE_TARIF
                INNER JOIN Keuangan.DBO.BO_M_PDP2 B
                ON CC.KD_PDP collate SQL_Latin1_General_CP1_CI_AS = B.KD_PDP collate SQL_Latin1_General_CP1_CI_AS
                INNER JOIN Keuangan.DBO.BO_M_PDP CX
                ON CX.KD_PDP = B.KD_PDP
                WHERE A1.GROUP_ENTRI='BEBAS' and a.BATAL='0' and A1.BATAL='0' and B.KD_TIPE_PDP='OBT1' and a.NO_TRS_BILLING=:notrsbill2");
                $this->db->bind('notrsbill2', $noreg);
                $this->db->execute();

                //UPDATE TOTAL KE FO_T_BILLING
                $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_BILLING
                    SET TOTAL_TARIF=B.SUM_NILAI_TARIF,TOTAL_QTY=B.SUM_QTY,SUBTOTAL=B.SUM_SUB_TOTAL,SUBTOTAL_2=B.SUM_SUB_TOTAL_2,GRANDTOTAL=B.SUM_GRANDTOTAL
                    FROM Billing_Pasien.DBO.FO_T_BILLING A 
                    INNER JOIN
                    (
                        SELECT  NO_TRS_BILLING,SUM(NILAI_TARIF) AS SUM_NILAI_TARIF,SUM(isnull(QTY,0)) AS SUM_QTY,SUM(SUB_TOTAL) AS SUM_SUB_TOTAL,SUM(SUB_TOTAL_2) AS SUM_SUB_TOTAL_2,
                        SUM(GRANDTOTAL) AS SUM_GRANDTOTAL
                        FROM Billing_Pasien.DBO.FO_T_BILLING_1
                        WHERE NO_REGISTRASI=:noreg and Batal='0'
                        GROUP BY NO_TRS_BILLING
                    ) B
                    ON A.NO_TRS_BILLING = B.NO_TRS_BILLING
                    WHERE A.NO_REGISTRASI=:noreg2 AND A.NO_TRS_BILLING=:notrsbill
                    ");
                $this->db->bind('noreg', $noreg);
                $this->db->bind('noreg2', $noreg);
                $this->db->bind('notrsbill', $noreg);
                $this->db->execute();


                //INSERT RECORD SYSLOG
                $this->db->query("INSERT INTO SysLog.dbo.TZ_Log_Button
                (noregistrasi, nama_biling, petugas_entry, tgl_entry)
                VALUES (:NoRegRecord, 'APPROVE PENJUALAN BEBAS', :USER_KASIRRecord, :TGL_TRSRecord)");
                $this->db->bind('NoRegRecord', $noreg);
                $this->db->bind('USER_KASIRRecord', $namauserx);
                $this->db->bind('TGL_TRSRecord', $datenowcreate);
                $this->db->execute();
            } else if ($idbtn == 'cb_btlapprovefarmasiall') {

                $this->db->query("SELECT COUNT(ID) AS CEK1 FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE GROUP_ENTRI = 'BEBAS' AND NO_TRS_BILLING = :notrsbill");
                $this->db->bind('notrsbill', $noreg);
                $data_CEK1 =  $this->db->single();
                $CEK1 = $data_CEK1['CEK1'];

                if ($CEK1 == '0') {
                    $callback = array(
                        'status' => "error",
                        'message' => "GAGAL BATAL APPROVE, Order Ini Belum Di Approve Sebelumnya!",
                    );
                    return $callback;
                    exit;
                }

                // var_dump($data);
                // exit;

                $this->db->query("SELECT COUNT(ID) AS CEK1payment FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE GROUP_ENTRI = 'FARMASI' AND ID_BILL = :dataaptk1a AND ID_TRS_Payment IS NOT NULL ");
                $this->db->bind('dataaptk1a', $dataaptk);
                $data_CEKpayment =  $this->db->single();
                $CEKpayment = $data_CEKpayment['CEK1payment'];

                if ($CEKpayment != '0') {
                    $callback = array(
                        'status' => "error",
                        'message' => "GAGAL BATAL APPROVE, Order Ini Sudah Di Payment!",
                    );
                    return $callback;
                    exit;
                }

                // $this->db->query("SELECT ID from [Apotik_V1.1SQL].dbo.[Order Details] where [Order ID]=:dataaptk1a");
                // $this->db->bind('dataaptk1a', $dataaptk);
                // $data_kodetarif =  $this->db->single();
                // $IDdetail = $data_kodetarif['ID'];


                // $query = "UPDATE [Apotik_V1.1SQL].dbo.Orders SET [Status ID]=1, TotalBayar=null, TglDikerjakanAwal=:datenowcreate, 
                // PetugasMengerjakanAwal=:namauserx WHERE [Order ID] = :iddata and [Status ID] = 2";
                // $datenowcreate = null;
                // $namauserx = null;

                // $querydtl = "UPDATE  a
                // SET a.[Status ID]=1
                // from [Apotik_V1.1SQL].dbo.[Order Details] a
                // inner join [Apotik_V1.1SQL].dbo.Orders b on a.[Order ID]=b.[Order ID]
                // WHERE a.[Order ID] = :iddata and b.[Status ID]=2";

                // $this->db->query("SELECT KODE_TARIF, NO_TRS_BILLING from Billing_Pasien.dbo.FO_T_BILLING_1 where ID_BILL = :dataaptk1 and KODE_REF = :IDdetail1a and batal = '0'");
                // $this->db->bind('dataaptk1', $dataaptk);
                // $this->db->bind('IDdetail1a', $IDdetail);
                // $data_kodetarifar =  $this->db->single();
                // $kodetrffar = $data_kodetarifar['KODE_TARIF'];
                // $trsfar = $data_kodetarifar['NO_TRS_BILLING'];
                // var_dump($noreg);
                // var_dump($trsfar);
                // exit;
                // exit;
                // $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 SET BATAL = '1' WHERE ID_BILL = :dataaptk1a --AND KODE_REF = :IDdetail1b");
                // $this->db->bind('dataaptk1a', $dataaptk);
                // // $this->db->bind('IDdetail1b', $IDdetail);
                // $this->db->execute();

                // $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_2 SET BATAL = '1' WHERE ID_BILL = :dataaptk1b --AND KODE_TARIF = :kodetrfrad1a");
                // $this->db->bind('dataaptk1b', $dataaptk);
                // // $this->db->bind('kodetrfrad1a', $kodetrfrad);
                // $this->db->execute();

                // $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING SET BATAL = '1' WHERE NO_REGISTRASI = :noregfinis AND NO_TRS_BILLING=:trsfar1");
                // $this->db->bind('noregfinis', $noreg);
                // $this->db->bind('trsfar1', $trsfar);
                // $this->db->execute();

                // $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_BILLING
                //     SET TOTAL_TARIF=B.SUM_NILAI_TARIF,TOTAL_QTY=B.SUM_QTY,SUBTOTAL=B.SUM_SUB_TOTAL,SUBTOTAL_2=B.SUM_SUB_TOTAL_2,GRANDTOTAL=B.SUM_GRANDTOTAL,
                //     FB_VERIF_JURNAL='0' 
                //     FROM Billing_Pasien.DBO.FO_T_BILLING A 
                //     INNER JOIN
                //     (
                //         SELECT  NO_TRS_BILLING,SUM(NILAI_TARIF) AS SUM_NILAI_TARIF,SUM(QTY) AS SUM_QTY,SUM(SUB_TOTAL) AS SUM_SUB_TOTAL,SUM(SUB_TOTAL_2) AS SUM_SUB_TOTAL_2,
                //         SUM(GRANDTOTAL) AS SUM_GRANDTOTAL
                //         FROM Billing_Pasien.DBO.FO_T_BILLING_1
                //         WHERE NO_REGISTRASI=:noreg and Batal='0'
                //         GROUP BY NO_TRS_BILLING
                //     ) B
                //     ON A.NO_TRS_BILLING = B.NO_TRS_BILLING
                //     WHERE A.NO_REGISTRASI=:noreg2 AND A.NO_TRS_BILLING=:notrsbill
                //     ");
                // $this->db->bind('noreg', $noreg);
                // $this->db->bind('noreg2', $noreg);
                // $this->db->bind('notrsbill', $trsfar);
                // $this->db->execute();

                $this->db->query("DELETE Billing_Pasien.dbo.FO_T_BILLING WHERE NO_TRS_BILLING = :noregbilling");
                $this->db->bind('noregbilling', $noreg);
                $this->db->execute();

                $this->db->query("DELETE Billing_Pasien.dbo.FO_T_BILLING_1 WHERE NO_TRS_BILLING = :noregbilling1");
                $this->db->bind('noregbilling1', $noreg);
                $this->db->execute();

                $this->db->query("DELETE Billing_Pasien.dbo.FO_T_BILLING_2 WHERE NO_TRS_BILLING = :noregbilling2");
                $this->db->bind('noregbilling2', $noreg);
                $this->db->execute();

                // $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING SET BATAL = '1' WHERE NO_REGISTRASI = :noregfini and NO_TRS_BILLING=:trsfar1a");
                // $this->db->bind('noregfini', $noreg);
                // $this->db->bind('trsfar1a', $trsfar);
                //UPDATE RECORD SYSLOG
                $this->db->query("UPDATE SysLog.dbo.TZ_Log_Button SET petugas_batal = :USER_KASIRRecord, alasan_batal = 'BATAL APPROVE PENJUALAN BEBAS', tgl_batal = :TGL_TRSRecord
                WHERE NoRegistrasi = :NoRegRecord AND petugas_batal IS NULL");
                $this->db->bind('NoRegRecord', $noreg);
                $this->db->bind('USER_KASIRRecord', $namauserx);
                $this->db->bind('TGL_TRSRecord', $datenowcreate);
                $this->db->execute();
            } else {
                $callback = array(
                    'status' => "warning",
                    'errorname' => "Something Wrong !",
                );
                return $callback;
                exit;
            }

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Simpan Berhasil',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function SaveTrsPayment_closing_Bebas($data)
    {
        try {
            $this->db->transaksi();
            $count_array = count($data['tipepembayaran']);
            $terimapembayaran = array_sum(str_replace(".", "", $data['totalinput']));
            $totalhargadumi = str_replace(".", "", $data['totalharga']);
            $yangharusdibayar = str_replace(".", "", $data['totalbayar']);
            if ($terimapembayaran <> $yangharusdibayar) {
                $callback = array(
                    'status' => 'eror',
                    'message' => 'Hasil input tidak matching dengan total harga !',
                );
                return $callback;
                exit;
            }

            $totalklaimdumi = str_replace(".", "", $data['totalklaim2']);
            $klaimyangharusdibayar = str_replace(".", "", $data['totalklaim1']);
            if ($klaimyangharusdibayar <> $totalklaimdumi) {
                $callback = array(
                    'status' => 'eror',
                    'message' => 'Hasil input piutang tidak matching dengan total klaim !',
                );
                return $callback;
                exit;
            }

            $totalkurangdumi = str_replace(".", "", $data['totalkekurangan1']);
            $kurangyangharusdibayar = str_replace(".", "", $data['totalkekurangan2']);
            if ($totalkurangdumi <> $kurangyangharusdibayar) {
                $callback = array(
                    'status' => 'eror',
                    'message' => 'Hasil input harga tidak matching dengan harga !',
                );
                return $callback;
                exit;
            }

            $totalinput = str_replace(".", "", $data['totalinput']);
            $tipepembayaran = $data['tipepembayaran'];
            $tipepembayarandummi = $data['tipepembayaran'][0];

            $NoMR = $data['NoMR'];
            $NoEpisode = $data['NoEpisode'];
            $NoRegistrasi = $data['NoRegistrasi'];
            $tgl_payment = $data['tglpayment_closing'];
            $TypePatientID = $data['TypePatientID'];
            $bilito2 = $data['billto'][0];

            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $namauserx = $session->name;
            $iduserx = $session->IDEmployee;
            $timenow = Date('H:i:s');
            $totalinput = str_replace(".", "", $data['totalinput']);
            $tipepembayaran = $data['tipepembayaran'];
            $bilito1 = $data['billtox'];
            $kodejaminan = $data['kodejaminan'];
            $kd_rekening = $data['kd_rekening'];
            $expired = $data['expired'];
            $nokartu = $data['nokartu'];
            $bilito = $data['billto'];

            $this->db->query("SELECT
	                CASE
	                WHEN b.NO_TRS_BILLING IS NOT NUll AND c.NO_TRS IS NOT NULL AND d.NOREG_FIRST IS NOT NULL THEN 'close'
	                ELSE 'open' END AS statusclose
	                FROM [Apotik_V1.1SQL].dbo.v_transaksi_sales_hdr a
	                LEFT JOIN Billing_Pasien.dbo.FO_T_BILLING b on b.NO_REGISTRASI = a.TransactionCode
					LEFT JOIN Billing_Pasien.dbo.FO_T_KASIR c on c.NO_REGISTRASI = a.TransactionCode
					LEFT JOIN Billing_Pasien.dbo.CLOSING_BILL d on d.NOREG_FIRST = a.TransactionCode
                    WHERE TransactionCode = :norega1a");
            $this->db->bind('norega1a', $data['NoRegistrasi']);
            $statuscek =  $this->db->single();
            $statuspasien = $statuscek['statusclose'];

            if ($statuspasien == 'close') {
                $callback = array(
                    'status' => 'eror', // Set array nama
                    'message' => 'Gagal Closing, Status Transaksi Pembelian Sudah Close'
                );
                return $callback;
                exit;
            }

            if ($tipepembayarandummi == "Pasien Kabur") {
                // var_dump($tipepembayaran, 'kabur');
                // exit;
                $this->db->query("SELECT SUM(BAYAR) AS TotalBayar, SUM(KLAIM) AS TotalKlaim, SUM(KEKURANGAN) AS TotalKekurangan FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE NO_REGISTRASI = :noreg1a AND BATAL = '0' AND ID_TRS_Payment IS NOT NULL");
                $this->db->bind('noreg1a', $NoRegistrasi);
                $datasd1 =  $this->db->single();
                $TotalBayaridtrs = $datasd1['TotalBayar'];
                $TotalKlaimidtrs = $datasd1['TotalKlaim'];
                $TotalKekuranganidtrs = $datasd1['TotalKekurangan'];

                $this->db->query("SELECT SUM(GRANDTOTAL) AS GrandTotal, SUM(KLAIM) AS TotalKlaim, SUM(KEKURANGAN) AS TotalKekurangan FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE NO_REGISTRASI = :noreg2a AND BATAL = '0' AND ID_TRS_Payment IS NULL");
                $this->db->bind('noreg2a', $NoRegistrasi);
                $datasd2 =  $this->db->single();
                $TotalBayarnoidtrs = $datasd2['GrandTotal'];
                $TotalKlaimnoidtrs = $datasd2['TotalKlaim'];
                $TotalKekurangannoidtrs = $datasd2['TotalKekurangan'];
                $TotalBayar = $TotalBayaridtrs + $TotalBayarnoidtrs;

                $this->db->query("INSERT INTO Billing_Pasien.dbo.CLOSING_BILL
                ([NOREG_FIRST], [JENIS_CLOSING], [TOTAL], [NOREG_REFF], [NO_MR])
                VALUES ( 
                :NoReg1, 'PASIEN KABUR', :TotalBayar1, '', :NoMR1)");
                $this->db->bind('NoReg1', $NoRegistrasi);
                $this->db->bind('TotalBayar1', $TotalBayar);
                $this->db->bind('NoMR1', $NoMR);
                $this->db->execute();

                $this->db->query("INSERT INTO Billing_Pasien.dbo.CLOSE_RO
                ([NOREG], [TOTAL_BILL], [KLAIM], [KEKURANGAN])
                VALUES ( 
                :NoReg2, :TotalBayar2, :TotalKlaim2, :TotalKekurangan2)");
                $this->db->bind('NoReg2', $NoRegistrasi);
                $this->db->bind('TotalBayar2', $TotalBayar);
                $this->db->bind('TotalKlaim2', $TotalKlaimnoidtrs);
                $this->db->bind('TotalKekurangan2', $TotalKekurangannoidtrs);
                $this->db->execute();

                $this->db->query("SELECT COUNT(*) AS CEKHUTANG FROM Billing_Pasien.dbo.CLOSING_BILL WHERE NOREG_REFF = :noreg3a");
                $this->db->bind('noreg3a', $NoRegistrasi);
                $datasd3 =  $this->db->single();
                $CEKHUTANGS = $datasd3['CEKHUTANG'];

                if ($CEKHUTANGS <> 0) {
                    $this->db->query("UPDATE Billing_Pasien.dbo.CLOSING_BILL SET NOREG_REFF = '' WHERE NOREG_REFF = :NoReg4a");
                    $this->db->bind('NoReg4a', $NoRegistrasi);
                    $this->db->execute();
                }
            } elseif ($tipepembayarandummi == "Piutang Rawat Inap") {
                $this->db->query("SELECT SUM(BAYAR) AS TotalBayar, SUM(KLAIM) AS TotalKlaim, SUM(KEKURANGAN) AS TotalKekurangan FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE NO_REGISTRASI = :noreg1a AND BATAL = '0' AND ID_TRS_Payment IS NOT NULL");
                $this->db->bind('noreg1a', $NoRegistrasi);
                $datasd1 =  $this->db->single();
                $TotalBayaridtrs = $datasd1['TotalBayar'];
                $TotalKlaimidtrs = $datasd1['TotalKlaim'];
                $TotalKekuranganidtrs = $datasd1['TotalKekurangan'];

                $this->db->query("SELECT SUM(GRANDTOTAL) AS GrandTotal, SUM(KLAIM) AS TotalKlaim, SUM(KEKURANGAN) AS TotalKekurangan FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE NO_REGISTRASI = :noreg2a AND BATAL = '0' AND ID_TRS_Payment IS NULL");
                $this->db->bind('noreg2a', $NoRegistrasi);
                $datasd2 =  $this->db->single();
                $TotalBayarnoidtrs = $datasd2['GrandTotal'];
                $TotalKlaimnoidtrs = $datasd2['TotalKlaim'];
                $TotalKekurangannoidtrs = $datasd2['TotalKekurangan'];
                $TotalBayar = $TotalBayaridtrs + $TotalBayarnoidtrs;

                $this->db->query("INSERT INTO Billing_Pasien.dbo.CLOSING_BILL
                ([NOREG_FIRST], [JENIS_CLOSING], [TOTAL], [NOREG_REFF], [NO_MR])
                VALUES ( 
                :NoReg1, 'PIUTANG RANAP', :TotalBayar1, '', :NoMR1)");
                $this->db->bind('NoReg1', $NoRegistrasi);
                $this->db->bind('TotalBayar1', $TotalBayar);
                $this->db->bind('NoMR1', $NoMR);
                $this->db->execute();

                $this->db->query("INSERT INTO Billing_Pasien.dbo.CLOSE_RO
                ([NOREG], [TOTAL_BILL], [KLAIM], [KEKURANGAN])
                VALUES ( 
                :NoReg2, :TotalBayar2, :TotalKlaim2, :TotalKekurangan2)");
                $this->db->bind('NoReg2', $NoRegistrasi);
                $this->db->bind('TotalBayar2', $TotalBayar);
                $this->db->bind('TotalKlaim2', $TotalKlaimnoidtrs);
                $this->db->bind('TotalKekurangan2', $TotalKekurangannoidtrs);
                $this->db->execute();

                $this->db->query("SELECT COUNT(*) AS CEKHUTANG FROM Billing_Pasien.dbo.CLOSING_BILL WHERE NOREG_REFF = :noreg3a");
                $this->db->bind('noreg3a', $NoRegistrasi);
                $datasd3 =  $this->db->single();
                $CEKHUTANGS = $datasd3['CEKHUTANG'];

                if ($CEKHUTANGS <> 0) {
                    $this->db->query("UPDATE Billing_Pasien.dbo.CLOSING_BILL SET NOREG_REFF = '' WHERE NOREG_REFF = :NoReg4a");
                    $this->db->bind('NoReg4a', $NoRegistrasi);
                    $this->db->execute();
                }
            } else {

                $datenowlis = date('dmy', strtotime($datenowcreate));
                $this->db->query("SELECT  max(NO_TRS) as nourut from Billing_Pasien.dbo.FO_T_KASIR WHERE SUBSTRING(NO_TRS, 4, 6)=:datenowlis ");
                $this->db->bind('datenowlis',   $datenowlis);
                $data =  $this->db->single();
                $nourut = $data['nourut'];
                $substringlis = substr($nourut, 9);
                if ($substringlis == null) {
                    $substringlis = 0;
                }
                $substringlis++;
                if (strlen($substringlis) == 1) {
                    $nourutfixLis = "00" . $substringlis;
                } else if (strlen($substringlis) == 2) {
                    $nourutfixLis = "0" . $substringlis;
                } else if (strlen($substringlis) == 3) {
                    $nourutfixLis = $substringlis;
                }

                $ID_TR_TARIF = 'TRS' . $datenowlis . $nourutfixLis;
                //#END GENERATE NO TRS HDR

                //GENERATE NO KWITANSI

                //untuk kode awal no NoKwitansi
                if ($TypePatientID == "1") {
                    $kodeawal = "KUJ";
                } else {
                    $kodeawal = "PRJ";
                }
                // $kodetengah = date('dmy');//untuk kode tengah no NoKwitansi
                $kodetengah = date('dmy', strtotime($tgl_payment));

                //cek no urut kwitansi

                //GET URUT
                $this->db->query("SELECT  TOP 1 NO_KWITANSI,right(NO_KWITANSI,4) as urutkwitansi
                FROM Billing_Pasien.dbo.FO_T_KASIR
                WHERE replace(CONVERT(VARCHAR(11), TGL_TRS, 111), '/','-')=:tgl_payment AND LEFT(NO_KWITANSI,3)=:kodeawal ORDER BY right(NO_KWITANSI,4) DESC");
                $this->db->bind('tgl_payment',   $tgl_payment);
                $this->db->bind('kodeawal',   $kodeawal);
                $data =  $this->db->single();
                $nourutkwitansi = $data['urutkwitansi'];

                if (empty($nourutkwitansi)) {
                    //jika gk ada record
                    $nourutkwitansi = "0001";
                } else {
                    //jika ada record
                    $nourutkwitansi++;
                }

                if (strlen($nourutkwitansi) == 1) {
                    $nourutfixKwitansi = "000" . $nourutkwitansi;
                } else if (strlen($nourutkwitansi) == 2) {
                    $nourutfixKwitansi = "00" . $nourutkwitansi;
                } else if (strlen($nourutkwitansi) == 3) {
                    $nourutfixKwitansi = "0" . $nourutkwitansi;
                } else if (strlen($nourutkwitansi) == 4) {
                    $nourutfixKwitansi = $nourutkwitansi;
                }

                $nofinalkwitansi = $kodeawal . '-' . $kodetengah . '-' . $nourutfixKwitansi;

                //#END GENERATE KWITANSI

                //INSERT TABEL PAYMENT HDR
                // Update FO_T_BILLING_1
                $this->db->query("INSERT INTO Billing_Pasien.dbo.FO_T_KASIR (
                    [NO_TRS]
                   ,[NO_KWITANSI]
                    ,[NO_EPISODE]
                    ,[NO_REGISTRASI]
                    ,[NO_MR]
                   ,[TGL_TRS]
                   ,[KODE_KASIR]
                   ,[USER_KASIR]
                   ,[NOMINAL_BAYAR]
                   ,[CASH]
                   ,[DEBIT]
                   ,[PIUTANG]
                   ,[KREDIT]
                   ,[QRIS]
                   ,[BATAL]
                   ,[TGL_BATAL]
                   ,[USER_BATAL]
                   ,[ALASAN_BATAL]
                   ,[USER_LAST]
                    ,[TGL_TRS_LAST]
                   ,[BILLTO]
                    ) values (
                    :NO_TRS
                    ,:NO_KWITANSI
                    ,:NO_EPISODE
                    ,:NO_REGISTRASI
                    ,:NO_MR
                    ,:TGL_TRS
                    ,:KODE_KASIR
                    ,:USER_KASIR
                    ,:NOMINAL_BAYAR
                    ,:CASH
                    ,:DEBIT
                    ,:PIUTANG
                    ,:KREDIT
                    ,:QRIS
                    ,:BATAL
                    ,:TGL_BATAL
                    ,:USER_BATAL
                    ,:ALASAN_BATAL
                    ,:USER_LAST
                    ,:TGL_TRS_LAST
                    ,:BILLTO
                    )");
                $this->db->bind('NO_TRS', $ID_TR_TARIF);
                $this->db->bind('NO_KWITANSI', $nofinalkwitansi);
                $this->db->bind('NO_EPISODE', $NoEpisode);
                $this->db->bind('NO_REGISTRASI', $NoRegistrasi);
                $this->db->bind('NO_MR', $NoMR);
                $this->db->bind('TGL_TRS', $datenowcreate);
                $this->db->bind('KODE_KASIR', $iduserx);
                $this->db->bind('USER_KASIR', $namauserx);
                $this->db->bind('NOMINAL_BAYAR', $terimapembayaran);
                $this->db->bind('CASH', 0);
                $this->db->bind('DEBIT', 0);
                $this->db->bind('PIUTANG', 0);
                $this->db->bind('KREDIT', 0);
                $this->db->bind('QRIS', 0);
                $this->db->bind('BATAL', '0');
                $this->db->bind('TGL_BATAL', '');
                $this->db->bind('USER_BATAL', '');
                $this->db->bind('ALASAN_BATAL', '');
                $this->db->bind('USER_LAST', $iduserx);
                $this->db->bind('TGL_TRS_LAST', $datenowcreate);
                $this->db->bind('BILLTO', $bilito1);
                $this->db->execute();

                // var_dump($tipepembayaran);
                // var_dump($timenow);
                // exit;

                //INSERT TABEL PAYMENT DTL
                for ($i = 0; $i < $count_array; $i++) {

                    //GENERATE NO TRS DTL
                    //GET URUT
                    $datenowlis = date('dmy', strtotime($datenowcreate));
                    $this->db->query("SELECT  max(NO_TRS) as nourut from Billing_Pasien.dbo.FO_T_KASIR_2 WHERE SUBSTRING(NO_TRS, 5, 6)=:datenowlis ");
                    $this->db->bind('datenowlis',   $datenowlis);
                    $data =  $this->db->single();
                    $nourut = $data['nourut'];
                    $substringlis = substr($nourut, 10);
                    if ($substringlis == null) {
                        $substringlis = 0;
                    }
                    $substringlis++;
                    if (strlen($substringlis) == 1) {
                        $nourutfixLis = "00" . $substringlis;
                    } else if (strlen($substringlis) == 2) {
                        $nourutfixLis = "0" . $substringlis;
                    } else if (strlen($substringlis) == 3) {
                        $nourutfixLis = $substringlis;
                    }

                    $ID_TR_TARIF_DTL = 'TRSD' . $datenowlis . $nourutfixLis;
                    //#END GENERATE NO TRS DTL

                    $this->db->query("INSERT INTO Billing_Pasien.[dbo].[FO_T_KASIR_2]
                    ([NO_TRS], [NO_TRS_REFF], [NOMINAL_BAYAR], [TIPE_PEMBAYARAN], [kode_Tipe_Reff] , [NAMA_TIPE_PEMBAYARAN], [NO_KARTU_REFRENSI], [EXPIRED_DATE])
                    VALUES (:NO_TRS, :NO_TRS_REFF, :NOMINAL_BAYAR, :TIPE_PEMBAYARAN, :kode_Tipe_Reff, :NAMA_TIPE_PEMBAYARAN, :NO_KARTU_REFRENSI, :EXPIRED_DATE)");
                    $this->db->bind('NO_TRS', $ID_TR_TARIF_DTL);
                    $this->db->bind('NO_TRS_REFF', $ID_TR_TARIF);
                    $this->db->bind('NOMINAL_BAYAR', $totalinput[$i]);
                    $this->db->bind('TIPE_PEMBAYARAN', $tipepembayaran[$i]);
                    $this->db->bind('kode_Tipe_Reff', $kodejaminan[$i]);
                    // $this->db->bind('kode_Tipe_Reff', $kd_rekening[$i]);
                    $this->db->bind('NAMA_TIPE_PEMBAYARAN', $bilito[$i]);
                    $this->db->bind('NO_KARTU_REFRENSI', $nokartu[$i]);
                    $this->db->bind('EXPIRED_DATE', $expired[$i]);
                    $this->db->execute();
                }

                // update fo
                $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 SET BAYAR = GRANDTOTAL, ID_TRS_Payment = :ID_TR_TARIFx WHERE NO_REGISTRASI = :NoRegistrasix AND BATAL = '0' AND ID_TRS_Payment IS NULL");
                $this->db->bind('NoRegistrasix', $NoRegistrasi);
                $this->db->bind('ID_TR_TARIFx', $ID_TR_TARIF);
                $this->db->execute();

                //update bill hutang
                $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_1
                SET BAYAR = GRANDTOTAL, ID_TRS_Payment = :ID_TR_TARIFxd
                FROM Billing_Pasien.dbo.FO_T_BILLING_1 a
                LEFT JOIN Billing_Pasien.dbo.CLOSING_BILL b on a.NO_REGISTRASI=b.NOREG_FIRST
                WHERE BATAL='0' and NOREG_REFF=:NoRegistrasixd
                and ID_TRS_Payment is null ");
                $this->db->bind('NoRegistrasixd', $NoRegistrasi);
                $this->db->bind('ID_TR_TARIFxd', $ID_TR_TARIF);
                $this->db->execute();
                //end update bill hutang

                $this->db->query("SELECT SUM(BAYAR) AS TotalBayar, SUM(KLAIM) AS TotalKlaim, SUM(KEKURANGAN) AS TotalKekurangan FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE NO_REGISTRASI = :NoReg AND BATAL = '0' AND ID_TRS_Payment IS NOT NULL");
                $this->db->bind('NoReg', $NoRegistrasi);
                $datasd =  $this->db->single();
                $TotalBayar = $datasd['TotalBayar'];
                $TotalKlaim = $datasd['TotalKlaim'];
                $TotalKekurangan = $datasd['TotalKekurangan'];

                //total hutang
                $this->db->query("SELECT SUM(BAYAR) AS TotalBayar, SUM(KLAIM) AS TotalKlaim, SUM(KEKURANGAN) AS TotalKekurangan 
                FROM Billing_Pasien.dbo.FO_T_BILLING_1 a
                INNER JOIN Billing_Pasien.dbo.CLOSING_BILL b on a.NO_REGISTRASI=b.NOREG_FIRST
                WHERE BATAL='0' and NOREG_REFF=:NoRegxd
                and ID_TRS_Payment is null ");
                $this->db->bind('NoRegxd', $NoRegistrasi);
                $dataxd =  $this->db->single();
                $TotalBayarxd = $dataxd['TotalBayar'];
                $TotalKlaimxd = $dataxd['TotalKlaim'];
                $TotalKekuranganxd = $dataxd['TotalKekurangan'];
                // total hutang

                $TotalBayarall = $TotalBayar + $TotalBayarxd;
                $TotalKlaimall = $TotalKlaim + $TotalKlaimxd;
                $TotalKekuranganall = $TotalKekurangan + $TotalKekuranganxd;

                $this->db->query("INSERT INTO Billing_Pasien.dbo.CLOSING_BILL
                ([NOREG_FIRST], [JENIS_CLOSING], [TOTAL], [NOREG_REFF], [NO_MR])
                VALUES ( 
                :NoReg1, 'CLOSEBILL', :TotalBayar1, '', :NoMR1)");
                $this->db->bind('NoReg1', $NoRegistrasi);
                $this->db->bind('TotalBayar1', $TotalBayarall);
                $this->db->bind('NoMR1', $NoMR);
                $this->db->execute();

                $this->db->query("INSERT INTO Billing_Pasien.dbo.CLOSE_RO
                ([NOREG], [TOTAL_BILL], [KLAIM], [KEKURANGAN])
                VALUES ( 
                :NoReg2, :TotalBayar2, :TotalKlaim2, :TotalKekurangan2)");
                $this->db->bind('NoReg2', $NoRegistrasi);
                $this->db->bind('TotalBayar2', $TotalBayarall);
                $this->db->bind('TotalKlaim2', $TotalKlaimall);
                $this->db->bind('TotalKekurangan2', $TotalKekuranganall);
                $this->db->execute();


                $this->db->query("SELECT SUM(NOMINAL_BAYAR) as totalbayar FROM Billing_Pasien.[dbo].[FO_T_KASIR_2] WHERE NO_TRS_REFF = :ID_TR_TARIF1 AND TIPE_PEMBAYARAN = 'TUNAI'");
                $this->db->bind('ID_TR_TARIF1', $ID_TR_TARIF);
                $dataxc =  $this->db->single();
                $total_bayar_cash = $dataxc['totalbayar'];

                $this->db->query("SELECT SUM(NOMINAL_BAYAR) as totalbayar FROM Billing_Pasien.[dbo].[FO_T_KASIR_2] WHERE NO_TRS_REFF = :ID_TR_TARIF2 AND TIPE_PEMBAYARAN = 'Kartu Debit'");
                $this->db->bind('ID_TR_TARIF2', $ID_TR_TARIF);
                $dataxd =  $this->db->single();
                $total_bayar_debit = $dataxd['totalbayar'];

                $this->db->query("SELECT SUM(NOMINAL_BAYAR) as totalbayar FROM Billing_Pasien.[dbo].[FO_T_KASIR_2] WHERE NO_TRS_REFF = :ID_TR_TARIF3 AND TIPE_PEMBAYARAN = 'Kartu Kredit'");
                $this->db->bind('ID_TR_TARIF3', $ID_TR_TARIF);
                $dataxk =  $this->db->single();
                $total_bayar_kredit = $dataxk['totalbayar'];
                // 22/08/2024x
                $this->db->query("SELECT SUM(NOMINAL_BAYAR) as totalbayar FROM Billing_Pasien.[dbo].[FO_T_KASIR_2] WHERE NO_TRS_REFF = :ID_TR_TARIF4 AND TIPE_PEMBAYARAN like '%Piutang%' ");
                $this->db->bind('ID_TR_TARIF4', $ID_TR_TARIF);
                $dataxp =  $this->db->single();
                $total_bayar_piutang = $dataxp['totalbayar'];

                $this->db->query("SELECT SUM(NOMINAL_BAYAR) as totalbayar FROM Billing_Pasien.[dbo].[FO_T_KASIR_2] WHERE NO_TRS_REFF = :ID_TR_TARIF4 AND TIPE_PEMBAYARAN = 'QRIS' ");
                $this->db->bind('ID_TR_TARIF4', $ID_TR_TARIF);
                $dataxp =  $this->db->single();
                $total_bayar_qris = $dataxp['totalbayar'];
                // 22/08/2024

                if ($total_bayar_cash == NULL) {
                    $total_bayar_cash = 0;
                }
                if ($total_bayar_debit == NULL) {
                    $total_bayar_debit = 0;
                }
                if ($total_bayar_kredit == NULL) {
                    $total_bayar_kredit = 0;
                }
                if ($total_bayar_piutang == NULL) {
                    $total_bayar_piutang = 0;
                }
                if ($total_bayar_qris == NULL) {
                    $total_bayar_qris = 0;
                }

                //INSERT TABEL PAYMENT HDR
                // Update FO_T_BILLING_1
                $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_KASIR SET CASH = :CASH, DEBIT = :DEBIT, KREDIT = :KREDIT, PIUTANG = :PIUTANG, QRIS = :QRIS where NO_TRS = :NO_TRSx");
                $this->db->bind('NO_TRSx', $ID_TR_TARIF);
                $this->db->bind('CASH', $total_bayar_cash);
                $this->db->bind('DEBIT', $total_bayar_debit);
                $this->db->bind('KREDIT', $total_bayar_kredit);
                $this->db->bind('PIUTANG', $total_bayar_piutang);
                $this->db->bind('QRIS', $total_bayar_qris);
                $this->db->execute();


                $this->db->query("INSERT INTO Billing_Pasien.dbo.TEMP_INA_CBG
                SELECT 
                NO_REGISTRASI
                ,isnull(ProsedurNonBedah,0) as ProsedurNonBedah
                ,isnull(ProsedurBedah,0) as ProsedurBedah
                ,isnull(Konsultasi,0) as Konsultasi
                ,0 as TenagaAhli
                ,isnull(Keperawatan,0) as Keperawatan
                ,0 as Penunjang
                ,isnull(Laboratorium,0) as Laboratorium
                ,isnull(Radiologi,0) as Radiologi
                ,isnull(PelayananDarah,0) as PelayananDarah
                ,isnull(Rehabilitasi,0) as Rehabilitasi
                ,isnull(Kamar,0) as Kamar_Akomodasi
                ,0 as RawatIntensif
                ,isnull(Obat,0) as Obat
                ,0 as ObatKronis
                ,0 as ObatKemoterapi
                ,0 as Alkes
                ,0 as BMHP
                ,0 as SewaAlat
                ,isnull(ProsedurNonBedah,0)
                +isnull(ProsedurBedah,0)
                +isnull(Konsultasi,0)
                +isnull(Laboratorium,0)
                +isnull(Radiologi,0)
                +isnull(PelayananDarah,0)
                +isnull(Rehabilitasi,0)
                +isnull(Kamar,0)
                +isnull(Obat,0) as TOTAL
                FROM (
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'ProsedurNonBedah' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3a and GROUP_TARIF ='Tindakan' 
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'ProsedurBedah' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3b and GROUP_TARIF ='Operasi'
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'Konsultasi' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3c and GROUP_TARIF ='Konsultasi'
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'Keperawatan' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3d and GROUP_TARIF ='Administrasi' 
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'Laboratorium' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3e and GROUP_TARIF ='Laboratorium'
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'Radiologi' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3f and GROUP_TARIF ='Radiologi'
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'PelayananDarah' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3g and GROUP_TARIF ='BankDarah'
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'Rehabilitasi' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3h and GROUP_TARIF ='Fisioterapi'
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'Kamar' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3i and GROUP_TARIF ='Kamar'
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'Obat' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3j and GROUP_TARIF ='Farmasi'
                Group by NO_REGISTRASI
                )AS QPivot
                PIVOT( SUM(TotalTarif)   
                FOR GROUP_TARIF IN ([ProsedurNonBedah],[ProsedurBedah],[Konsultasi],[Keperawatan],[Laboratorium],[Radiologi],[PelayananDarah],[Rehabilitasi],[Kamar],[Obat])) AS QPivot");
                $this->db->bind('NoReg3a', $NoRegistrasi);
                $this->db->bind('NoReg3b', $NoRegistrasi);
                $this->db->bind('NoReg3c', $NoRegistrasi);
                $this->db->bind('NoReg3d', $NoRegistrasi);
                $this->db->bind('NoReg3e', $NoRegistrasi);
                $this->db->bind('NoReg3f', $NoRegistrasi);
                $this->db->bind('NoReg3g', $NoRegistrasi);
                $this->db->bind('NoReg3h', $NoRegistrasi);
                $this->db->bind('NoReg3i', $NoRegistrasi);
                $this->db->bind('NoReg3j', $NoRegistrasi);
                $this->db->execute();
            }

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Simpan Berhasil',
                // 'paramsid' => $ID_TR_TARIF,
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function PrintKuitansiHeaderbyAllBebas($data)
    {
        try {

            $session = SessionManager::getCurrentSession();
            $namauserx = $session->name;

            if ($data['kodereg'] == 'RJ') {
            } elseif ($data['kodereg'] == 'RI') {
            } elseif ($data['kodereg'] == 'TS') {
                $query = "SELECT a.NamaPembeli AS PatientName,  b2.Billto as BILLTO, '-' as NO_MR, a.NoRegistrasi as NO_REGISTRASI, a.NoEpisode as NO_EPISODE, b3.NO_KWITANSI as NO_KWITANSI, '' as USER_KASIR, b4.nominalbayar as NOMINAL_BAYAR, a.UnitOrder AS NamaUnit,
                case when a.GroupJaminan='2' then asu.NamaPerusahaan else jpk.NamaPerusahaan end AS NamaJaminan, '' AS Id_Kasir,
                SUBSTRING(x.nama_test,1, LEN(x.nama_test) - 1) NamaTest , y.nominal_bayar_tunai , z.nominal_bayar_Debit, w.nominal_bayar_PiuangPerushaan, wa.nominal_bayar_Qris
                FROM [Apotik_V1.1SQL].dbo.v_transaksi_sales_hdr a
                        OUTER APPLY (
                            SELECT Billto
                            FROM Billing_Pasien.dbo.FO_T_KASIR b1 
                            WHERE b1.NO_REGISTRASI = a.TransactionCode COLLATE  SQL_Latin1_General_CP1_CI_AS
                            GROUP BY Billto
                        ) b2 (Billto)
						OUTER APPLY (
                            SELECT NO_KWITANSI
                            FROM Billing_Pasien.dbo.FO_T_KASIR b15 
                            WHERE b15.NO_REGISTRASI = a.TransactionCode COLLATE  SQL_Latin1_General_CP1_CI_AS
                            GROUP BY NO_KWITANSI
                        ) b3 (NO_KWITANSI)
                        OUTER APPLY (
                            SELECT SUM(NOMINAL_BAYAR) as nominalbayar
                            FROM Billing_Pasien.dbo.FO_T_KASIR b3 
                            WHERE b3.NO_REGISTRASI = a.TransactionCode AND b3.BATAL='0' COLLATE  SQL_Latin1_General_CP1_CI_AS
                            GROUP BY Billto
                        ) b4 (nominalbayar)
                        OUTER APPLY (
                            SELECT NAMA_TARIF + ', '
                            FROM Billing_Pasien.dbo.FO_T_BILLING_1 b5
                            inner join Billing_Pasien.dbo.FO_T_KASIR b6 on b6.NO_REGISTRASI = a.TransactionCode COLLATE  SQL_Latin1_General_CP1_CI_AS
                            WHERE b5.ID_TRS_Payment = b6.NO_TRS AND b5.BATAL = '0'
                            FOR XML PATH('')
                        ) x (nama_test)
                        OUTER APPLY (
                            SELECT SUM(b7.NOMINAL_BAYAR) as bayartunai
                            FROM Billing_Pasien.dbo.FO_T_KASIR_2 b7
                            inner join Billing_Pasien.dbo.FO_T_KASIR b8 on b8.NO_REGISTRASI = a.TransactionCode COLLATE  SQL_Latin1_General_CP1_CI_AS
                            WHERE b7.NO_TRS_REFF = b8.NO_TRS AND TIPE_PEMBAYARAN = 'Tunai' AND b8.BATAL='0'
                        ) y (nominal_bayar_tunai)
                        OUTER APPLY (
                            SELECT SUM(b9.NOMINAL_BAYAR) as bayartunai
                            FROM Billing_Pasien.dbo.FO_T_KASIR_2 b9
                            inner join Billing_Pasien.dbo.FO_T_KASIR b10 on b10.NO_REGISTRASI = a.TransactionCode COLLATE  SQL_Latin1_General_CP1_CI_AS
                            WHERE b9.NO_TRS_REFF = b10.NO_TRS AND TIPE_PEMBAYARAN = 'Kartu Debit'  AND b10.BATAL='0'
                        ) z (nominal_bayar_Debit)
                        OUTER APPLY (
                            SELECT SUM(b11.NOMINAL_BAYAR) as bayartunai
                            FROM Billing_Pasien.dbo.FO_T_KASIR_2 b11
                            inner join Billing_Pasien.dbo.FO_T_KASIR b12 on b12.NO_REGISTRASI = a.TransactionCode COLLATE  SQL_Latin1_General_CP1_CI_AS
                            WHERE b11.NO_TRS_REFF = b12.NO_TRS AND TIPE_PEMBAYARAN = 'Piutang Perusahaan' AND b12.BATAL='0'
                        ) w (nominal_bayar_PiuangPerushaan)
						OUTER APPLY (
                            SELECT SUM(b13.NOMINAL_BAYAR) as bayartunai
                            FROM Billing_Pasien.dbo.FO_T_KASIR_2 b13
                            inner join Billing_Pasien.dbo.FO_T_KASIR b14 on b14.NO_REGISTRASI = a.TransactionCode COLLATE  SQL_Latin1_General_CP1_CI_AS
                            WHERE b13.NO_TRS_REFF = b14.NO_TRS AND TIPE_PEMBAYARAN = 'QRIS' AND b14.BATAL='0'
                        ) wa (nominal_bayar_Qris)
                  left join MasterdataSQL.dbo.MstrPerusahaanJPK jpk on a.KodeJaminan=jpk.ID
                  left join MasterdataSQL.dbo.MstrPerusahaanAsuransi asu on a.KodeJaminan=asu.ID
                WHERE a.TransactionCode = :noreg1";
            } else {
                $pasing['NoKwitansi'] = '';
                $pasing['NoRegistrasi'] = '';
                $pasing['NoMR'] = '';
                $pasing['billto'] = '';
                $pasing['PatientName'] = '';
                $pasing['NamaJaminan'] = '';
                $pasing['NamaUnit'] = '';
                $pasing['Kasir'] = '';
                $pasing['Terbilang'] = '';
                $pasing['TotalPaid'] = '';
                $pasing['Id_Kasir'] = '';
                $pasing['Cetakan_Ke'] = '';
                $pasing['ID'] = '';
                return $pasing;
            }
            $this->db->query($query);
            $this->db->bind('noreg1', $data['notrs']);
            $datas =  $this->db->single();

            $terbilang = $this->terbilang($datas['NOMINAL_BAYAR']);
            $pasing['billto'] = $datas['BILLTO'];
            $pasing['NoMR'] = $datas['NO_MR'];
            $pasing['NoRegistrasi'] = $datas['NO_REGISTRASI'];
            $pasing['NO_EPISODE'] = $datas['NO_EPISODE'];
            $pasing['NoKwitansi'] = $datas['NO_KWITANSI'];
            $pasing['PatientName'] = $datas['PatientName'];
            $pasing['NamaJaminan'] = $datas['NamaJaminan'];
            $pasing['NamaUnit'] = $datas['NamaUnit'];
            $pasing['NamaTest'] = $datas['NamaTest'];
            $pasing['Kasir'] = $namauserx;
            $pasing['Id_Kasir'] = $datas['Id_Kasir'];
            $pasing['Terbilang'] = $terbilang;
            $pasing['TotalPaid'] = number_format($datas['NOMINAL_BAYAR'], 0, ',', '.');

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintKuitansiDetailbyAllBebas($data)
    {
        try {

            if ($data['kodereg'] == 'RJ' || $data['kodereg'] == 'TS') {
                $query = "SELECT b.TIPE_PEMBAYARAN, b.NOMINAL_BAYAR FROM Billing_Pasien.dbo.FO_T_KASIR a
                INNER JOIN Billing_Pasien.dbo.FO_T_KASIR_2 b ON b.NO_TRS_REFF = a.NO_TRS
                WHERE a.NO_REGISTRASI = :noreg";
            } elseif ($data['kodereg'] == 'RI') {
                $query = "SELECT TipePembayaran,TotalBayar as TotalPaid FROM RawatInapSQL.dbo.DepositDetails Where IDDeposit=:id";
            } else {
                $pasing['No'] = '';
                $pasing['TipePembayaran'] = '';
                $pasing['TotalPaid'] = '';
                $rows[] = $pasing;
                return $rows;
            }

            $this->db->query($query);
            $this->db->bind('noreg', $data['notrs']);
            // $this->db->bind('notrskasir', $data['lang']);
            $data =  $this->db->resultSet();

            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['TipePembayaran'] = $key['TIPE_PEMBAYARAN'];
                $pasing['TotalPaid'] = number_format($key['NOMINAL_BAYAR'], 0, ',', '.');
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintRincianHeaderbyRegAllBebas($data)
    {
        try {
            if ($data['kodereg'] == 'RJ') {
            } elseif ($data['kodereg'] == 'RI') {
            } elseif ($data['kodereg'] == 'TS') {
                $query = "SELECT a.TglPeriode AS TglKunjungan, '-' AS NoRegistrasi, a.TransactionCode AS NoReff, '-' AS NoMR, a.NamaPembeli AS PatientName, a.Discount AS  ValueDiscount, a.UnitOrder AS IdUnit, a.NamaUnit,
'-' AS NamaDokter, a.TglLahirPembeli AS DateOfBirth, a.NamaJaminan, a.TglPeriode AS TglPulang, '-' AS NoSEP, a.GenderPembeli AS Gander, '-' AS NoRegisRWJ, a.AlamatPembeli AS Address,
'-' AS NamaCOB, '-' AS NamaUnit_RWJ, 0 AS BiayaAdm, a.Discount AS Discount, '-' AS materai
FROM [Apotik_V1.1SQL].dbo.v_transaksi_sales_hdr a
LEFT JOIN MasterdataSQL.dbo.MstrUnitPerwatan b ON b.NamaUnit = a.NamaUnit
WHERE TransactionCode = :id";
            } else {
                $pasing['NoRegistrasi'] = '';
                $pasing['NoReff'] = '';
                $pasing['NoMR'] = '';
                $pasing['PatientName'] = '';
                $pasing['TglKunjungan'] = '';
                $pasing['ValueDiscount'] = 0;
                $pasing['IdUnit'] = '';
                $pasing['NamaUnit'] = '';
                $pasing['NamaDokter'] = '';
                $pasing['DateOfBirth'] = '';
                $pasing['NamaJaminan'] = '';
                $pasing['TglPulang'] = '';
                $pasing['NoSEP'] = '';
                $pasing['Gander'] = '';
                $pasing['NoRegisRWJ'] = '';
                $pasing['Address'] = '';
                $pasing['NamaCOB'] = '';
                $pasing['NamaUnit_RWJ'] = '';
                $pasing['BiayaAdm'] = '';
                $pasing['Discount'] = '';
                $pasing['materai'] = '';
                return $pasing;
            }
            $this->db->query($query);
            $this->db->bind('id', $data['notrs']);
            // $this->db->bind('id2', $data['notrs']);
            $datas =  $this->db->single();

            $pasing['TglKunjungan'] = ($datas['TglKunjungan'] != null) ? date('d/m/Y', strtotime($datas['TglKunjungan'])) : '';
            $pasing['NoRegistrasi'] = $datas['NoRegistrasi'];
            $pasing['NoReff'] = $datas['NoReff'];
            $pasing['NoMR'] = $datas['NoMR'];
            $pasing['PatientName'] = $datas['PatientName'];
            $pasing['ValueDiscount'] = $datas['ValueDiscount'];
            $pasing['IdUnit'] = $datas['IdUnit'];
            $pasing['NamaUnit'] = $datas['NamaUnit'];
            $pasing['NamaDokter'] = $datas['NamaDokter'];
            $pasing['DateOfBirth'] = ($datas['DateOfBirth'] != null) ? date('d/m/Y', strtotime($datas['DateOfBirth'])) : '';
            $pasing['NamaJaminan'] = $datas['NamaJaminan'];
            $pasing['TglPulang'] = ($datas['TglPulang'] != null) ? date('d/m/Y', strtotime($datas['TglPulang'])) : '';
            $pasing['NoSEP'] = $datas['NoSEP'];
            $pasing['Gander'] = $datas['Gander'];
            $pasing['NoRegisRWJ'] = $datas['NoRegisRWJ'];
            $pasing['Address'] = $datas['Address'];
            $pasing['NamaCOB'] = $datas['NamaCOB'];
            $pasing['NamaUnit_RWJ'] = $datas['NamaUnit_RWJ'];
            $pasing['BiayaAdm'] = $datas['BiayaAdm'];
            $pasing['Discount'] = $datas['Discount'];
            $pasing['materai'] = $datas['materai'];

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintRincianpaybyRegidtrsALLBebas($data)
    {

        try {
            $query = "SELECT NAMA_TARIF AS Keterangan,GROUP_TARIF as jenis_tarif, a.GRANDTOTAL AS BILL,KEKURANGAN AS Kekurangan, KLAIM, NO_KWITANSI AS NoBayar,replace(CONVERT(VARCHAR(11), a.TGL_BILLING, 111), '/','-') as TglOrder
            from Billing_Pasien.dbo.FO_T_BILLING_1 a
            inner join Billing_Pasien.dbo.FO_T_BILLING b on a.NO_TRS_BILLING= b.NO_TRS_BILLING
            left join Billing_Pasien.dbo.FO_T_KASIR c on a.ID_TRS_Payment = c.NO_TRS
            WHERE a.NO_REGISTRASI=:noreg1 AND a.batal='0' AND a.ID_TRS_Payment IS NOT NULL AND c.NO_REGISTRASI = :noreg4
UNION ALL
SELECT (NAMA_TARIF + ' (Hutang)') AS Keterangan,GROUP_TARIF as jenis_tarif, a.GRANDTOTAL AS BILL,KEKURANGAN AS Kekurangan, KLAIM, NO_KWITANSI AS NoBayar,replace(CONVERT(VARCHAR(11), a.TGL_BILLING, 111), '/','-') as TglOrder
            from Billing_Pasien.dbo.FO_T_BILLING_1 a
            inner join Billing_Pasien.dbo.FO_T_BILLING b on a.NO_TRS_BILLING= b.NO_TRS_BILLING
            inner join Billing_Pasien.dbo.FO_T_KASIR c on a.ID_TRS_Payment = c.NO_TRS
			inner join Billing_Pasien.dbo.CLOSING_BILL d ON d.NOREG_FIRST = a.NO_REGISTRASI
            WHERE d.NOREG_REFF=:noreg2 AND a.BATAL='0' AND c.NO_REGISTRASI = :noreg3";

            $this->db->query($query);
            $this->db->bind('noreg1', $data['notrs']);
            $this->db->bind('noreg2', $data['notrs']);
            $this->db->bind('noreg3', $data['notrs']);
            $this->db->bind('noreg4', $data['notrs']);
            // $this->db->bind('idtrspayment', $data['lang']);
            $datas =  $this->db->resultSet();

            $rows = array();
            $no = 1;
            foreach ($datas as $key) {
                // $diskon_value = $key['TarifSatuan'] * $key['Discount'];
                $pasing['No'] = $no++;
                $pasing['Keterangan'] = $key['Keterangan'];
                $pasing['jenis_tarif'] = $key['jenis_tarif'];
                $pasing['BILL'] = $key['BILL'];
                $pasing['Kekurangan'] = $key['Kekurangan'];
                $pasing['ASURANSI'] = $key['KLAIM'];
                $pasing['NoBayar'] = $key['NoBayar'];
                $pasing['TglOrder'] = ($key['TglOrder'] != null) ? date('d/m/Y', strtotime($key['TglOrder'])) : '';
                // $diskon = $key['Discount'] * 100;
                // $pasing['diskon_persen'] = ($diskon != 0) ? number_format($diskon, 0, ',', '.') . '%' : '';
                $rows[] = $pasing;
            }

            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function SetSaveBatalRiwayatPembayaranBebas($data)
    {
        try {
            $this->db->transaksi();

            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $useridx = $session->IDEmployee;

            // DATA PASING
            $noreg = $data['noreg'];
            $notrs = $data['notrs'];
            $alasanBtlPayment = $data['alasanBtlPayment'];

            $this->db->query("SELECT Count(id) AS StatusID FROM Billing_Pasien.dbo.CLOSING_BILL WHERE NOREG_FIRST = :norega1");
            $this->db->bind('norega1', $noreg);
            $dataStatusId =  $this->db->single();
            $statusID = $dataStatusId['StatusID'];

            if ($alasanBtlPayment == '') {
                $callback = array(
                    'status' => "warning",
                    'errorname' => "Silahkan isi alasan terlebih dahulu", // Set array nama 

                );
                return $callback;
                exit;
            }

            if ($statusID <> 0) {
                $callback = array(
                    'status' => "warning",
                    'errorname' => "Pasien sudah close, silahkan open bill untuk melakukan pembatalan pembayaran", // Set array nama 
                );
                return $callback;
                exit;
            }

            // BATAL KASIR
            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_KASIR SET BATAL = '1', TGL_BATAL = :datenowx1, USER_BATAL= :namauserx1, ALASAN_BATAL = :alasanBtlPayment1 WHERE NO_TRS = :notrs1");
            // $this->db->bind('noreg1', $noreg);
            $this->db->bind('datenowx1', $datenowx);
            $this->db->bind('namauserx1', $namauserx);
            $this->db->bind('alasanBtlPayment1', $alasanBtlPayment);
            $this->db->bind('notrs1', $notrs);
            $this->db->execute();
            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_KASIR_2 SET BATAL = '1' WHERE NO_TRS_REFF = :notrs2");
            $this->db->bind('notrs2', $notrs);
            $this->db->execute();

            // BATAL FOT_BILL
            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 SET ID_TRS_Payment = NULL, BAYAR = 0 WHERE ID_TRS_Payment = :notrs3");
            $this->db->bind('notrs3', $notrs);
            // $this->db->bind('noreg3', $noreg);
            $this->db->execute();

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
                // 'ket_respons' => $respons_ket,
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function setSaveCloseOrOpenBillBebas($data)
    {
        try {
            $this->db->transaksi();
            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $useridx = $session->IDEmployee;

            // exit;
            // DATA PASING
            $NoRegistrasi = $data['NoRegistrasi'];
            $Ket_btn_closeoropenbill = $data['Ket_btn_closeoropenbill'];
            $NoMR = $data['NoMR'];

            if ($Ket_btn_closeoropenbill == 'close') {
                // var_dump($Ket_btn_closeoropenbill);
                // var_dump('yuu');
                // exit;

                $this->db->query("DELETE Billing_Pasien.dbo.CLOSING_BILL WHERE NOREG_FIRST = :NoRegistrasi1");
                $this->db->bind('NoRegistrasi1', $NoRegistrasi);
                $this->db->execute();
                $this->db->query("DELETE Billing_Pasien.dbo.CLOSE_RO WHERE NOREG = :NoRegistrasi2");
                $this->db->bind('NoRegistrasi2', $NoRegistrasi);
                $this->db->execute();
                $this->db->query("DELETE Billing_Pasien.dbo.TEMP_INA_CBG WHERE NO_REGISTRASI = :NoRegistrasi3");
                $this->db->bind('NoRegistrasi3', $NoRegistrasi);
                $this->db->execute();

                $this->db->query("UPDATE  PerawatanSQL.dbo.Visit SET jamPulang=:jamPulang, 
                                [Status ID]='3'
                                where NoRegistrasi=:NoRegistrasi3");
                $this->db->bind('NoRegistrasi3', $NoRegistrasi);
                $this->db->bind('jamPulang', null);
                $this->db->execute();

                $respons_ket = 'Open Bill';
            } else {
                // var_dump($Ket_btn_closeoropenbill);

                // var_dump('yeee');
                // exit;

                $this->db->query("SELECT COUNT(ID) AS cekDataBill1 from Billing_Pasien.dbo.FO_T_BILLING_1 where BATAL='0' and NO_REGISTRASI=:noreg1 and ID_TRS_Payment is null");
                $this->db->bind('noreg1', $NoRegistrasi);
                $dataStatusBill1 =  $this->db->single();
                $cekDataBill1 = $dataStatusBill1['cekDataBill1'];

                if ($cekDataBill1 <> 0) {
                    $callback = array(
                        'status' => "warning",
                        'errorname' => "Gagal Closing Bill, Ada Bilingan Yang Belum Dibayar", // Set array nama 
                    );
                    return $callback;
                    exit;
                }

                $this->db->query("SELECT SUM(BAYAR) AS TotalBayar, SUM(KLAIM) AS TotalKlaim, SUM(KEKURANGAN) AS TotalKekurangan FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE NO_REGISTRASI = :NoReg3 AND BATAL = '0' AND ID_TRS_Payment IS NOT NULL");
                $this->db->bind('NoReg3', $NoRegistrasi);
                $datasd =  $this->db->single();
                $TotalBayar = $datasd['TotalBayar'];
                $TotalKlaim = $datasd['TotalKlaim'];
                $TotalKekurangan = $datasd['TotalKekurangan'];

                //total hutang
                $this->db->query("SELECT SUM(BAYAR) AS TotalBayar, SUM(KLAIM) AS TotalKlaim, SUM(KEKURANGAN) AS TotalKekurangan 
                FROM Billing_Pasien.dbo.FO_T_BILLING_1 a
                INNER JOIN Billing_Pasien.dbo.CLOSING_BILL b on a.NO_REGISTRASI=b.NOREG_FIRST
                WHERE BATAL='0' and NOREG_REFF=:NoRegxd
                and ID_TRS_Payment is null ");
                $this->db->bind('NoRegxd', $NoRegistrasi);
                $dataxd =  $this->db->single();
                $TotalBayarxd = $dataxd['TotalBayar'];
                $TotalKlaimxd = $dataxd['TotalKlaim'];
                $TotalKekuranganxd = $dataxd['TotalKekurangan'];
                // total hutang

                $TotalBayarall = $TotalBayar + $TotalBayarxd;
                $TotalKlaimall = $TotalKlaim + $TotalKlaimxd;
                $TotalKekuranganall = $TotalKekurangan + $TotalKekuranganxd;

                $this->db->query("INSERT INTO Billing_Pasien.dbo.CLOSING_BILL
                ([NOREG_FIRST], [JENIS_CLOSING], [TOTAL], [NOREG_REFF], [NO_MR])
                VALUES ( 
                :NoRegxd1a, 'CLOSEBILL', :TotalBayar1a, '', :NoMR1a)");
                $this->db->bind('NoRegxd1a', $NoRegistrasi);
                $this->db->bind('TotalBayar1a', $TotalBayarall);
                $this->db->bind('NoMR1a', $NoMR);
                $this->db->execute();

                $this->db->query("INSERT INTO Billing_Pasien.dbo.CLOSE_RO
                ([NOREG], [TOTAL_BILL], [KLAIM], [KEKURANGAN])
                VALUES ( 
                :NoRegxd2a, :TotalBayar2a, :TotalKlaim2a, :TotalKekurangan2a)");
                $this->db->bind('NoRegxd2a', $NoRegistrasi);
                $this->db->bind('TotalBayar2a', $TotalBayarall);
                $this->db->bind('TotalKlaim2a', $TotalKlaimall);
                $this->db->bind('TotalKekurangan2a', $TotalKekuranganall);
                $this->db->execute();

                $this->db->query("INSERT INTO Billing_Pasien.dbo.TEMP_INA_CBG
                SELECT 
                NO_REGISTRASI
                ,isnull(ProsedurNonBedah,0) as ProsedurNonBedah
                ,isnull(ProsedurBedah,0) as ProsedurBedah
                ,isnull(Konsultasi,0) as Konsultasi
                ,0 as TenagaAhli
                ,isnull(Keperawatan,0) as Keperawatan
                ,0 as Penunjang
                ,isnull(Laboratorium,0) as Laboratorium
                ,isnull(Radiologi,0) as Radiologi
                ,isnull(PelayananDarah,0) as PelayananDarah
                ,isnull(Rehabilitasi,0) as Rehabilitasi
                ,isnull(Kamar,0) as Kamar_Akomodasi
                ,0 as RawatIntensif
                ,isnull(Obat,0) as Obat
                ,0 as ObatKronis
                ,0 as ObatKemoterapi
                ,0 as Alkes
                ,0 as BMHP
                ,0 as SewaAlat
                ,isnull(ProsedurNonBedah,0)
                +isnull(ProsedurBedah,0)
                +isnull(Konsultasi,0)
                +isnull(Laboratorium,0)
                +isnull(Radiologi,0)
                +isnull(PelayananDarah,0)
                +isnull(Rehabilitasi,0)
                +isnull(Kamar,0)
                +isnull(Obat,0) as TOTAL
                FROM (
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'ProsedurNonBedah' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3a and GROUP_TARIF ='Tindakan' 
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'ProsedurBedah' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3b and GROUP_TARIF ='Operasi'
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'Konsultasi' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3c and GROUP_TARIF ='Konsultasi'
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'Keperawatan' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3d and GROUP_TARIF ='Administrasi' 
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'Laboratorium' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3e and GROUP_TARIF ='Laboratorium'
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'Radiologi' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3f and GROUP_TARIF ='Radiologi'
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'PelayananDarah' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3g and GROUP_TARIF ='BankDarah'
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'Rehabilitasi' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3h and GROUP_TARIF ='Fisioterapi'
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'Kamar' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3i and GROUP_TARIF ='Kamar'
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'Obat' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3j and GROUP_TARIF ='Farmasi'
                Group by NO_REGISTRASI
                )AS QPivot
                PIVOT( SUM(TotalTarif)   
                FOR GROUP_TARIF IN ([ProsedurNonBedah],[ProsedurBedah],[Konsultasi],[Keperawatan],[Laboratorium],[Radiologi],[PelayananDarah],[Rehabilitasi],[Kamar],[Obat])) AS QPivot");
                $this->db->bind('NoReg3a', $NoRegistrasi);
                $this->db->bind('NoReg3b', $NoRegistrasi);
                $this->db->bind('NoReg3c', $NoRegistrasi);
                $this->db->bind('NoReg3d', $NoRegistrasi);
                $this->db->bind('NoReg3e', $NoRegistrasi);
                $this->db->bind('NoReg3f', $NoRegistrasi);
                $this->db->bind('NoReg3g', $NoRegistrasi);
                $this->db->bind('NoReg3h', $NoRegistrasi);
                $this->db->bind('NoReg3i', $NoRegistrasi);
                $this->db->bind('NoReg3j', $NoRegistrasi);
                $this->db->execute();

                $this->db->query("UPDATE PerawatanSQL.dbo.Visit SET [Status ID] = 4 WHERE NoRegistrasi = :NoRegistrasi ");
                $this->db->bind('NoRegistrasi', $NoRegistrasi);
                $this->db->execute();

                $respons_ket = 'Close Bill';
            }

            $this->db->commit();

            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
                'ket_respons' => $respons_ket,
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    // Penjualan Obat Bebas

    // 20/08/2024
    public function getDataDetailBilling($data)
    {
        try {
            $noreg = $data['noreg'];
            $tglawal = $data['tglawal'];
            $tglakhir = $data['tglakhir'];
            $getreg = $data['getreg'];
            // var_dump($getreg);

            if (isset($data['ispayment'])) {
                if (isset($data['attr'])) {
                    if ($data['attr'] == 'KLAIM') {
                        $filter = "AND KLAIM=0";
                    } elseif ($data['attr'] == 'BAYAR') {
                        $filter = "AND BAYAR=0";
                    } else {
                        $filter = "AND 1=0";
                    }
                }
            } else {
                $filter = null;
            }

             // ADMINISTRASI
            //  $this->db->query("SELECT SUM(GRANDTOTAL) AS SUM_GRANDTOTAL 
            //  FROM Billing_Pasien.DBO.FO_T_BILLING_1
            //  WHERE NO_REGISTRASI=:NO_REGISTRASI and Batal='0' and GROUP_ENTRI<>'ADMINISTRASI'");
            //  $this->db->bind('NO_REGISTRASI', $noreg); 
            //  $sumTotalBill =  $this->db->single();
            //  $biaya_perawatan = $sumTotalBill['SUM_GRANDTOTAL'];

            // CARI REGNYA
            $this->db->query("SELECT e.id as UNIT, a.NoMR,a.NoEpisode, '' as RoomID_Awal, a.TipePasien as TypePatient,
            '3' as KelasID,a.[Visit Date] as EndDate,'0' as Paket,
            A.KodeJaminan AS kodePenjamin,
            A.NamaJaminan AS NamaPenjamin,
            CASE WHEN A.TipePasien = '2' THEN f.Group_Jaminan ELSE fp.Group_Jaminan END AS KodegroupJaminan
            FROM DashboardData.dbo.datarwj a 
            LEFT JOIN MasterdataSQL.dbo.MstrPerusahaanAsuransi AS f ON a.KodeJaminan = f.ID 
            LEFT OUTER JOIN MasterdataSQL.dbo.MstrPerusahaanJPK AS fp ON a.KodeJaminan = fp.ID
            INNER JOIN MasterdataSQL.dbo.MstrUnitPerwatan e
			on e.id = a.IdUnit
            WHERE a.NoRegistrasi=:NO_REGISTRASI");
            $this->db->bind('NO_REGISTRASI', $noreg); 
            $detilReRAnap =  $this->db->single();
            $kelasid = $detilReRAnap['KelasID'];
            $tipepasien = $detilReRAnap['TypePatient'];
            $pasien_paket = $detilReRAnap['Paket'];
            $grup_jaminan = $detilReRAnap['KodegroupJaminan'];
            $idperusahaan = $detilReRAnap['kodePenjamin'];
            $UNIT = $detilReRAnap['UNIT'];
            //  if($UNIT <> '10') {
            //     $biaya_admin = 0.02 * $biaya_perawatan;

            //     // CARI ADA ADMINNNYA BELUM,
            //             // JIKA ADA UPDATE KAYAK UPDATE KAMAR METODENYA
            //             // JIKA BELUM YA DI INSERT
            //             $datenow = Utils::seCurrentDateTime();
                        
            //             $this->db->query("SELECT  NO_TRS_BILLING,ID,
            //                             QTY,SUB_TOTAL,DISC,DISC_RP,SUB_TOTAL_2,GRANDTOTAL,KLAIM,KEKURANGAN,NO_REGISTRASI 
            //                             FROM Billing_Pasien.DBO.FO_T_BILLING_1 
            //             WHERE NO_REGISTRASI=:NO_REGISTRASI and GROUP_ENTRI='ADMINISTRASI'
            //             and BATAL='0' and GROUP_TARIF='Administrasi Rajal'  and BATAL='0'  ");
            //             $this->db->bind('NO_REGISTRASI', $noreg);  
            //             $this->db->execute();
            //             $dataadminx =  $this->db->rowCount(); 
            //             $dataregformupdateadmin =  $this->db->single(); 
            //             $xNO_TRS_BILLING =  $dataregformupdateadmin['NO_TRS_BILLING'];
            //            //  var_dump($dataadminx); exit;
            //             if($dataadminx){
            //                     // UPDATE ADMINISTRASI
            //                         $xDISC = 0;
            //                         $subtotal2 = $biaya_admin;
            //                         $KEKURANGAN = $biaya_admin;
            //                         $KLAIM = '0';
                           
                                
            //                     $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 SET 
            //                     SUB_TOTAL = :subtotal,   NILAI_TARIF = :nilaitarif,  
            //                     DISC_RP = :xDISC, 
            //                     SUB_TOTAL_2 = :subtotal2, GRANDTOTAL = :grttl, 
            //                     KLAIM = :klaim, KEKURANGAN = :kekurangan
            //                     WHERE NO_TRS_BILLING = :NO_TRS_BILLING AND GROUP_TARIF = :GROUP_TARIF AND GROUP_ENTRI = :GROUP_ENTRI"); 
            //                     $this->db->bind('subtotal', $biaya_admin);
            //                     $this->db->bind('xDISC', $xDISC);
            //                     $this->db->bind('subtotal2', $subtotal2); 
            //                     $this->db->bind('nilaitarif', $biaya_admin); 
            //                     $this->db->bind('grttl', $subtotal2); 
            //                     $this->db->bind('NO_TRS_BILLING', $xNO_TRS_BILLING); 
            //                     $this->db->bind('klaim', $KLAIM); 
            //                     $this->db->bind('kekurangan', $KEKURANGAN); 
            //                     $this->db->bind('GROUP_TARIF', 'Administrasi Rajal'); 
            //                     $this->db->bind('GROUP_ENTRI', 'ADMINISTRASI'); 
            //                     $this->db->execute();
   
            //                     $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_2 SET   
            //                     SUB_TOTAL = :subtotal,  
            //                     DISC_RP = :xDISC, 
            //                     NILAI_DISKON_PDP = :xDISC2, 
            //                     SUB_TOTAL_2 = :subtotal2, NILAI_PDP = :grttl 
            //                     WHERE NO_TRS_BILLING = :NO_TRS_BILLING AND GROUP_TARIF = :GROUP_TARIF AND ID_BILL = :ID_BILL "); 
            //                     $this->db->bind('subtotal', $biaya_admin);
            //                     $this->db->bind('xDISC', $xDISC);
            //                     $this->db->bind('xDISC2', $xDISC);
            //                     $this->db->bind('subtotal2', $subtotal2); 
            //                     $this->db->bind('grttl', $biaya_admin); 
            //                     $this->db->bind('NO_TRS_BILLING', $xNO_TRS_BILLING); 
            //                     $this->db->bind('GROUP_TARIF', 'Administrasi Rajal'); 
            //                     $this->db->bind('ID_BILL', $dataregformupdateadmin['ID']); 
            //                     $this->db->execute(); 
   
            //                     // UPDATE FO
            //                     $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_BILLING
            //                     SET TOTAL_TARIF=B.SUM_NILAI_TARIF,
            //                     TOTAL_QTY=B.SUM_QTY,SUBTOTAL=B.SUM_SUB_TOTAL,SUBTOTAL_2=B.SUM_SUB_TOTAL_2,GRANDTOTAL=B.SUM_GRANDTOTAL,
            //                     FB_VERIF_JURNAL='0', TOTAL_DISCOUNT = B.DISC, TOTAL_DISCOUNT_RP=b.DISC_RP
            //                     FROM Billing_Pasien.DBO.FO_T_BILLING A 
            //                     INNER JOIN
            //                     (
            //                         SELECT  NO_TRS_BILLING,SUM(NILAI_TARIF) AS SUM_NILAI_TARIF,SUM(QTY) AS SUM_QTY,SUM(SUB_TOTAL) AS SUM_SUB_TOTAL,SUM(SUB_TOTAL_2) AS SUM_SUB_TOTAL_2,
            //                         SUM(GRANDTOTAL) AS SUM_GRANDTOTAL,sum(DISC) as DISC, SUM(DISC_RP) AS DISC_RP
            //                         FROM Billing_Pasien.DBO.FO_T_BILLING_1
            //                         WHERE NO_REGISTRASI=:noreg and Batal='0'
            //                         GROUP BY NO_TRS_BILLING
            //                     ) B
            //                     ON A.NO_TRS_BILLING = B.NO_TRS_BILLING
            //                     WHERE A.NO_REGISTRASI=:noreg2 AND A.NO_TRS_BILLING=:notrsbill
            //                     ");
            //                     $this->db->bind('noreg', $noreg);
            //                     $this->db->bind('noreg2', $noreg);
            //                     $this->db->bind('notrsbill', $xNO_TRS_BILLING);
            //                     $this->db->execute();
            //             }else{
            //                     // ADMINISTRASI
            //                     $notrs = "ADR" . Utils::idtrsByDatetime();
            //                     $this->db->query("INSERT INTO Billing_Pasien.dbo.FO_T_BILLING
            //                     ([NO_TRS_BILLING],[TGL_BILLING],[PETUGAS_ENTRY],[NO_MR],[NO_EPISODE],
            //                     [NO_REGISTRASI],[UNIT],[GROUP_JAMINAN],[KODE_JAMINAN],[TOTAL_TARIF],
            //                     [TOTAL_QTY],[SUBTOTAL],[TOTAL_DISCOUNT],[TOTAL_DISCOUNT_RP],[SUBTOTAL_2],
            //                     [GRANDTOTAL],[BATAL],[FB_CLOSE_KEUANGAN],[FB_VERIF_JURNAL]) 
            //                     VALUES
            //                     (:notrsbill,:datenowx,:namauserx,:NoMrfix,:NoEpisode,
            //                     :nofixReg,:IdGrupPerawatan,:JenisBayar,:perusahaanid,:totaltarif,
            //                     :totalqty,:subtotal,:totaldiscount,:totaldiscountrp,:subtotal2,
            //                     :grandtotal,:batal,:closekeuangan,:verifkeuangan)"); 
            //                     $this->db->bind('notrsbill', $notrs);
            //                     $this->db->bind('datenowx', $datenow);
            //                     $this->db->bind('namauserx', 'Administrator');
            //                     $this->db->bind('NoMrfix', $detilReRAnap['NoMR']);
            //                     $this->db->bind('NoEpisode', $detilReRAnap['NoEpisode']);
            //                     $this->db->bind('nofixReg', $noreg);
            //                     $this->db->bind('IdGrupPerawatan', $detilReRAnap['UNIT']);
            //                     $this->db->bind('JenisBayar', $detilReRAnap['TypePatient']);
            //                     $this->db->bind('perusahaanid', $detilReRAnap['kodePenjamin']);
            //                     $this->db->bind('totaltarif', $biaya_admin);
            //                     $this->db->bind('totalqty', 1);
            //                     $this->db->bind('subtotal', $biaya_admin);
            //                     $this->db->bind('totaldiscount', 0);
            //                     $this->db->bind('totaldiscountrp', 0);
            //                     $this->db->bind('subtotal2', $biaya_admin);
            //                     $this->db->bind('grandtotal', $biaya_admin);
            //                     $this->db->bind('batal', 0);
            //                     $this->db->bind('closekeuangan', 0);
            //                     $this->db->bind('verifkeuangan', 0);
            //                     $this->db->execute();
            //                     $id_inpatientinout_max = $this->db->GetLastID();
   
                              
            //                         $bayar = '0';
            //                         $bayarmat = '0';
            //                         $klaim = '0';
            //                         $klaimmat = '0';
            //                         $kekurangan = $biaya_admin;
                            
            //                     // fo billing 1 ADMIN
            //                     $this->db->query("INSERT INTO  Billing_Pasien.dbo.FO_T_BILLING_1
            //                     (ID_BILL,[NO_TRS_BILLING],[TGL_BILLING] ,[PETUGAS_ENTRY],[NO_MR],[NO_EPISODE],[NO_REGISTRASI],[KODE_TARIF],[UNIT],[GROUP_JAMINAN],[KODE_JAMINAN],
            //                     [NAMA_TARIF],[GROUP_TARIF],[KD_KELAS],[QTY],[NILAI_TARIF],[SUB_TOTAL],[DISC],[DISC_RP],[SUB_TOTAL_2],[GRANDTOTAL],[KODE_REF],[KD_DR],[NM_DR],
            //                     [BATAL],[PETUGAS_BATAL],[GROUP_ENTRI],[BAYAR],[KLAIM],[KEKURANGAN])
            //                     SELECT '$id_inpatientinout_max','$notrs' , '$datenow' as datenow,'Administrator' as namauserx,NO_MR, NO_EPISODE,'$noreg' as NoReg,:Kode_Tarif as kodetarif,
            //                     UNIT,GROUP_JAMINAN,KODE_JAMINAN, :Nama_Tarif as namatarif,'Administrasi Rajal' as rad, :kdkelas, 1 as Qty, :Nilai as nilai, :Nilai2 as nilai2, 0, 
            //                     0, :Nilai3 as nilai3, :Nilai4 as nilai4,'$id_inpatientinout_max', :drPenerima, null as namadokter, 0 as batal,null as petugasbatal,'ADMINISTRASI',$bayar,$klaim,$kekurangan
            //                     FROM Billing_Pasien.dbo.FO_T_BILLING
            //                     WHERE NO_TRS_BILLING=:notrsbill AND Batal='0'");
            //                     $this->db->bind('notrsbill', $notrs);
            //                     $this->db->bind('Kode_Tarif', 'ADR00001');
            //                     $this->db->bind('Nama_Tarif', 'Administrasi Rajal');
            //                     $this->db->bind('Nilai',  $biaya_admin);
            //                     $this->db->bind('Nilai2', $biaya_admin);
            //                     $this->db->bind('Nilai3', $biaya_admin);
            //                     $this->db->bind('Nilai4', $biaya_admin);
            //                     $this->db->bind('drPenerima', '');
            //                     $this->db->bind('kdkelas', $detilReRAnap['KelasID']); 
            //                     $this->db->execute();
            //                     $bill1last = $this->db->GetLastID();
   
            //                     $this->db->query("INSERT INTO Billing_Pasien.DBO.FO_T_BILLING_2
            //                     SELECT '$bill1last',A.NO_TRS_BILLING AS NO_TRS_BILLING,A1.KODE_TARIF,'ADM2' as Kode_komponen,A1.UNIT AS UNIT, 
            //                     A1.GROUP_JAMINAN AS GROUP_JAMINAN, A1.KODE_JAMINAN AS KODE_JAMINAN, A1.NAMA_TARIF AS NAMA_TARIF, A1.GROUP_TARIF AS GROUP_TARIF,
            //                     A1.KD_KELAS as KELAS,A1.QTY AS QTY, A1.NILAI_TARIF AS NILAI_TARIF , A1.NILAI_TARIF*A1.QTY  AS SUBTOTAL,A1.DISC AS DISC,
            //                     0 AS DISC_RP,((A1.NILAI_TARIF*A1.QTY)-(((A1.NILAI_TARIF*A1.QTY)*A1.DISC)/100)) SUB_TOTAL_PDP_2,
            //                     '0' NILAI_DISKON_PDP,A1.NILAI_TARIF as NILAI_PDP,null AS KD_DR, null NM_DR,'1' as NILAI_PROSEN,'0' AS BATAL,
            //                     '' PETUGAS_BATAL, '' AS JAM_BATAL, '44100001' AS KD_POSTING,'45100002' as kd_posting_diskon, 0 as ID_TR_TARIF_PAKET
            //                     FROM Billing_Pasien.DBO.FO_T_BILLING A
            //                     inner join Billing_Pasien.dbo.FO_T_BILLING_1 A1 ON A.NO_TRS_BILLING = A1.NO_TRS_BILLING 
            //                     WHERE a.NO_TRS_BILLING=:notrsbill2 and a1.GROUP_ENTRI='ADMINISTRASI' ");
            //                     $this->db->bind('notrsbill2', $notrs);
            //                     $this->db->execute();
   
                               
                               
            //             }
            //  }else{
            //     $this->db->query("DELETE  Billing_Pasien.DBO.FO_T_BILLING 
            //     WHERE NO_REGISTRASI=:NO_REGISTRASI and PETUGAS_ENTRY='Administrator'");
            //     $this->db->bind('NO_REGISTRASI', $noreg);
            //     $this->db->execute();

            //     $this->db->query("DELETE  Billing_Pasien.DBO.FO_T_BILLING_1 
            //     WHERE NO_REGISTRASI=:NO_REGISTRASI and GROUP_TARIF='Administrasi Rajal'");
            //     $this->db->bind('NO_REGISTRASI', $noreg);
            //     $this->db->execute();
            //  }
           




            $this->db->query("SELECT a.*,b.NamaKelas,
            replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-') as TglBilling,c.NamaUnit
            FROM Billing_Pasien.dbo.FO_T_BILLING_1 a
            left join RawatInapSQL.dbo.TblKelas b on a.KD_KELAS=b.IDkelas
            inner join MasterdataSQL.dbo.MstrUnitPerwatan c
            on c.id = a.UNIT
            WHERE NO_REGISTRASI=:noreg AND BATAL='0' and replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-') between :tglawal and :tglakhir $filter
            ");
            $this->db->bind('noreg', $noreg);
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;

            // if ($getreg == 'RI') {
            //     $this->db->query("SELECT a.*,b.NamaKelas,
            //     replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-') as TglBilling,c.NamaUnit
            //     FROM Billing_Pasien.dbo.FO_T_BILLING_1 a
            //     left join RawatInapSQL.dbo.TblKelas b on a.KD_KELAS=b.IDkelas
            //     inner join MasterdataSQL.dbo.MstrUnitPerwatan c
            //     on c.id = a.UNIT
            //     WHERE NO_REGISTRASI=:noreg AND BATAL='0' and replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-') between :tglawal and :tglakhir $filter
            //      ");
            //     $this->db->bind('noreg', $noreg);
            //     $this->db->bind('tglawal', $tglawal);
            //     $this->db->bind('tglakhir', $tglakhir);
            //     $data =  $this->db->resultSet();
            //     $rows = array();
            //     $no = 1;
            //     // var_dump('ri');
            //     // exit;
            // } else {
            //     $this->db->query("SELECT a.*,NamaKelas = 'NULL' ,
            //     replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-') as TglBilling,c.NamaUnit
            //     FROM Billing_Pasien.dbo.FO_T_BILLING_1 a
            //     inner join MasterdataSQL.dbo.MstrUnitPerwatan c
            //     on c.id = a.UNIT
            //     WHERE NO_REGISTRASI=:noreg AND BATAL='0' and replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-') between :tglawal and :tglakhir $filter
            //      ");
            //     $this->db->bind('noreg', $noreg);
            //     $this->db->bind('tglawal', $tglawal);
            //     $this->db->bind('tglakhir', $tglakhir);
            //     $data =  $this->db->resultSet();
            //     $rows = array();
            //     $no = 1;
            //     // var_dump('rj');
            //     // exit;
            // }
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['ID'] = $key['ID'];
                $pasing['NO_TRS_BILLING'] = $key['NO_TRS_BILLING'];
                $pasing['TGL_BILLING'] = $key['TGL_BILLING'];
                $pasing['TglBilling'] = $key['TglBilling'];
                $pasing['NAMA_TARIF'] = $key['NAMA_TARIF'];
                $pasing['NamaUnit'] = $key['NamaUnit'];
                $pasing['NM_DR'] = $key['NM_DR'];
                $pasing['GROUP_TARIF'] = $key['GROUP_TARIF'];
                $pasing['KD_KELAS'] = $key['NamaKelas'];
                $pasing['QTY'] = $key['QTY'];
                // $pasing['NILAI_TARIF'] = number_format($key['NILAI_TARIF'],0,',','.');
                $pasing['NILAI_TARIF'] = $key['NILAI_TARIF'];
                $pasing['DISC_RP'] = $key['DISC_RP'];
                $pasing['GRANDTOTAL'] = $key['GRANDTOTAL'];
                $pasing['KLAIM'] = $key['KLAIM'];
                $pasing['KEKURANGAN'] = $key['KEKURANGAN'];
                $pasing['BAYAR'] = $key['BAYAR'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    // 20/08/2024


    public function getDataDetailRincianBilling($data)
    {
        try {
            $noreg = $data['noreg'];
            // $nomr = $data['nomr'];

            $this->db->query("SELECT ID, NO_TRS_BILLING,NO_REGISTRASI, replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-') as TglBilling, NAMA_TARIF, QTY, NILAI_TARIF, DISC_RP, GRANDTOTAL, KEKURANGAN , KLAIM
            from Billing_Pasien.dbo.FO_T_BILLING_1 
            where BATAL='0' and NO_REGISTRASI=:noreg1
            and ID_TRS_Payment is null
            UNION ALL
            Select a.ID, NO_TRS_BILLING,NO_REGISTRASI, replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-') as TglBilling, NAMA_TARIF, QTY, NILAI_TARIF, DISC_RP, GRANDTOTAL, KEKURANGAN , KLAIM
            FROM Billing_Pasien.dbo.FO_T_BILLING_1 a 
            inner join Billing_Pasien.dbo.CLOSING_BILL b on a.NO_REGISTRASI=b.NOREG_FIRST
            where BATAL='0' and NOREG_REFF=:noreg2
            and ID_TRS_Payment is null
            ");
            $this->db->bind('noreg1', $noreg);
            $this->db->bind('noreg2', $noreg);
            // $this->db->bind('nomr', $nomr);

            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['ID'] = $key['ID'];
                $pasing['NO_TRS_BILLING'] = $key['NO_TRS_BILLING'];
                $pasing['NO_REGISTRASI'] = $key['NO_REGISTRASI'];

                $pasing['TglBilling'] = $key['TglBilling'];
                $pasing['NAMA_TARIF'] = $key['NAMA_TARIF'];
                $pasing['QTY'] = $key['QTY'];
                $pasing['NILAI_TARIF'] = $key['NILAI_TARIF'];
                $pasing['DISC_RP'] = $key['DISC_RP'];
                $pasing['GRANDTOTAL'] = $key['GRANDTOTAL'];
                $pasing['KEKURANGAN'] = $key['KEKURANGAN'];
                $pasing['KLAIM'] = $key['KLAIM'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataDetailRincianBillingPayment($data)
    {
        try {
            $noreg = $data['noreg'];
            // $nomr = $data['nomr'];

            $this->db->query("SELECT ID, NO_TRS_BILLING,NO_REGISTRASI, replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-') as TglBilling, NAMA_TARIF, QTY, NILAI_TARIF, DISC_RP, GRANDTOTAL, KLAIM, KEKURANGAN, BAYAR, ID_TRS_Payment
            from Billing_Pasien.dbo.FO_T_BILLING_1 
            where BATAL='0' and NO_REGISTRASI=:noreg1
            and ID_TRS_Payment is null and KLAIM = 0
            ");
            $this->db->bind('noreg1', $noreg);
            // $this->db->bind('noreg2', $noreg);
            // $this->db->bind('nomr', $nomr);

            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['ID'] = $key['ID'];
                $pasing['NO_TRS_BILLING'] = $key['NO_TRS_BILLING'];
                $pasing['NO_REGISTRASI'] = $key['NO_REGISTRASI'];

                $pasing['TglBilling'] = $key['TglBilling'];
                $pasing['NAMA_TARIF'] = $key['NAMA_TARIF'];
                $pasing['QTY'] = $key['QTY'];
                $pasing['NILAI_TARIF'] = $key['NILAI_TARIF'];
                $pasing['DISC_RP'] = $key['DISC_RP'];
                $pasing['GRANDTOTAL'] = $key['GRANDTOTAL'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }



    public function getDataDetailBillingx($data)
    {

        // var_dump($data);
        // exit;
        try {
            $noreg = $data['noreg'];
            // $tglawal = $data['tglawal'];
            // $tglakhir = $data['tglakhir'];

            if (isset($data['ispayment'])) {
                if (isset($data['attr'])) {
                    if ($data['attr'] == 'KLAIM') {
                        $filter = "AND KLAIM!=0";
                    } elseif ($data['attr'] == 'BAYAR') {
                        $filter = "AND KEKURANGAN!=0";
                    } else {
                        $filter = "AND 1=0";
                    }
                }
            } else {
                $filter = null;
            }

            // var_dump($filter);
            // exit;

            $this->db->query("SELECT a.NO_TRS_BILLING, a.TGL_BILLING, a.TOTAL_TARIF, a.SUBTOTAL_2 , SUBSTRING(x.nama_test,1, LEN(x.nama_test) - 1) NamaTest FROM Billing_Pasien.dbo.FO_T_BILLING a
            OUTER APPLY (
                     SELECT NAMA_TARIF + ', '
            		 FROM Billing_Pasien.dbo.FO_T_BILLING_1 b
            		 WHERE b.NO_TRS_BILLING = a.NO_TRS_BILLING AND b.BATAL = '0' $filter
            		 FOR XML PATH('')
                        ) x (nama_test)
            WHERE NO_REGISTRASI = :noreg AND BATAL = '0' AND SUBSTRING(x.nama_test,1, LEN(x.nama_test) - 1) != 'NULL' AND ID_TRS_Payment IS NULL");

            $this->db->bind('noreg', $noreg);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['NO_TRS_BILLING'] = $key['NO_TRS_BILLING'];
                $pasing['TGL_BILLING'] = $key['TGL_BILLING'];
                $pasing['TOTAL_TARIF'] = $key['TOTAL_TARIF'];
                $pasing['SUBTOTAL_2'] = $key['SUBTOTAL_2'];
                $pasing['NamaTest'] = $key['NamaTest'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    public function getDataTarifNext($data)
    {
        // var_dump($data, 'ita');
        // exit;
        try {
            $noreg = $data['noreg'];
            $GroupJaminan = $data['GroupJaminan'];
            $penjamin_kode = $data['penjamin_kode'];
            $IDUnit = $data['IDUnit'];

            $this->db->query("SELECT NO_TRS_BILLING, TGL_BILLING, TOTAL_TARIF, SUBTOTAL_2 FROM Billing_Pasien.dbo.FO_T_BILLING
            WHERE NO_REGISTRASI = :noreg AND ID_TRS_Payment IS NULL");
            $this->db->bind('noreg', $noreg);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['NO_TRS_BILLING'] = $key['NO_TRS_BILLING'];
                $pasing['TGL_BILLING'] = $key['TGL_BILLING'];
                $pasing['TOTAL_TARIF'] = $key['TOTAL_TARIF'];
                $pasing['SUBTOTAL_2'] = $key['SUBTOTAL_2'];
                // $pasing['GROUP_ENTRI'] = $key['GROUP_ENTRI'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function changeBillingJaminan($data)
    {
        try {

            // var_dump('Masih Tahap Perbaikan');
            // exit;

            $this->db->transaksi();
            $notrsbill = $data['Idbilling'];
            $noreg = $data['bilNOreg'];
            $groupjaminan = $data['xgrupjaminan'];

            $row_data_id = $data['hidden_id'];
            $row_hidden_nama_tarif_ = $data['hidden_nama_tarif_'];
            $row_hidden_qty_ = $data['hidden_qty_'];
            $row_hidden_harga_ = $data['hidden_harga_'];
            $row_hidden_subtotal_ = $data['hidden_subtotal_'];
            $row_hidden_diskon_ = $data['hidden_diskon_'];
            $hidden_subtotal2_ = $data['hidden_subtotal2_'];

            $ID_UNIT = $data['ID_UNIT'];

            $jumlahdata = count($row_data_id);

            $totaltarif = 0;
            $totalqty = 0;
            $subtotal = 0;
            $totaldiskon = 0;
            $totaldiskonrp = 0;
            $grandsubtotal2 = 0;
            $grandtotal = 0;

            //contoh
            $gruptarifx = $data['GROUP_ENTRI_'];
            $row_hidden_kode_tarif = $data['KODE_TARIF_'];
            $row_hidden_kode_ref = $data['KODE_REF_'];
            $namapenjamin = $data['bilNamaJaminan'];
            $GROUP_JAMINANNO = $data['GROUP_JAMINANNO'];
            $penjamin_kodex = $data['penjamin_kodex'];

            // var_dump($row_hidden_nama_tarif_[2]);
            // var_dump(substr($row_hidden_nama_tarif_[2], 0, 10));
            // exit;

            for ($i = 0; $i < $jumlahdata; $i++) {
                $gruptarif = $gruptarifx[$i];

                if ($gruptarif == "LABORATORIUM") {


                    // var_dump($groupjaminan);
                    // var_dump($row_hidden_kode_tarif);
                    // var_dump($row_hidden_kode_tarif);
                    // exit;
                    $row_hidden_nama_tarif_tgl = substr($row_hidden_nama_tarif_[2], 0, 10);


                    $this->db->query("SELECT COUNT(*) AS cektarif
                        FROM LaboratoriumSQL.dbo.tblGrouping_3 A
                        INNER JOIN LaboratoriumSQL.dbo.tblGrouping_4 B ON a.ID_TR_TARIF = B.ID_TR_TARIF
                        INNER JOIN LaboratoriumSQL.dbo.tblGrouping C ON C.IDTes = B.ID_TARIF
                        WHERE :kdtgla between  replace(CONVERT(VARCHAR(11),a.TGL_BERLAKU, 111), '/','-')   and replace(CONVERT(VARCHAR(11),a.TGL_EXPIRED, 111), '/','-') 
                        AND B.GROUP_TARIF = :groupjaminana AND A.KD_INSTALASI = 'LAB' AND C.IDTes = :kdtarifa order by 1 desc");
                    $this->db->bind('groupjaminana', $groupjaminan);
                    $this->db->bind('kdtarifa', $row_hidden_kode_tarif[$i]);
                    $this->db->bind('kdtgla', $row_hidden_nama_tarif_tgl);
                    $datarada =  $this->db->single();
                    $cek = $datarada['cektarif'];

                    if ($cek <> "0") {
                        $this->db->query("SELECT  C.IDTes as ID,C.NamaTes as namatarif, B.NILAI
                        FROM LaboratoriumSQL.dbo.tblGrouping_3 A
                        INNER JOIN LaboratoriumSQL.dbo.tblGrouping_4 B ON a.ID_TR_TARIF = B.ID_TR_TARIF
                        INNER JOIN LaboratoriumSQL.dbo.tblGrouping C ON C.IDTes = B.ID_TARIF
                        WHERE :kdtglb between  replace(CONVERT(VARCHAR(11),a.TGL_BERLAKU, 111), '/','-')   and replace(CONVERT(VARCHAR(11),a.TGL_EXPIRED, 111), '/','-') 
                        AND B.GROUP_TARIF = :groupjaminanb AND A.KD_INSTALASI = 'LAB' AND C.IDTes = :kdtarifb
                        order by 1 desc");
                        $this->db->bind('groupjaminanb', $groupjaminan);
                        $this->db->bind('kdtarifb', $row_hidden_kode_tarif[$i]);
                        $this->db->bind('kdtglb', $row_hidden_nama_tarif_tgl);

                        $dataradb =  $this->db->single();
                        $hargabaru = $dataradb['NILAI'];

                        $this->db->query("SELECT ID_BILL FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE NO_TRS_BILLING = :notrsbilld AND GROUP_ENTRI = 'LABORATORIUM' AND KODE_TARIF = :kodetarifd");
                        $this->db->bind('kodetarifd', $row_hidden_kode_tarif[$i]);
                        $this->db->bind('notrsbilld', $notrsbill[$i]);
                        $datalabc =  $this->db->single();
                        $nolab = $datalabc['ID_BILL'];

                        //update LAB DETAIL
                        $this->db->query("UPDATE LaboratoriumSQL.dbo.tblLabDetail SET Tarif = :hargabaruc WHERE idTes = :kodetarifc AND LabDetailID = :koderefc");
                        $this->db->bind('hargabaruc', $hargabaru);
                        $this->db->bind('kodetarifc', $row_hidden_kode_tarif[$i]);
                        $this->db->bind('koderefc', $row_hidden_kode_ref[$i]);
                        $this->db->execute();

                        //update LIS
                        $this->db->query("UPDATE LaboratoriumSQL.dbo.LIS_Order SET asuransi = :namapenjamine, is_taken = 'FALSE' WHERE NoLab = :nolabe");
                        $this->db->bind('namapenjamine', $namapenjamin);
                        $this->db->bind('nolabe', $nolab);
                        $this->db->execute();
                        // END LAB
                    } else {
                        $callback = array(
                            'status' => "warning",
                            'message' => "Pergantian tarif gagal, karena tidak ada tindakan dengan jaminan ini", // Set array nama 

                        );
                        return $callback;
                        exit;
                    }
                } else if ($gruptarif == "RADIOLOGI") {

                    $row_hidden_nama_tarif_tgl = substr($row_hidden_nama_tarif_[2], 0, 10);
                    // var_dump($groupjaminan);
                    // var_dump($row_hidden_kode_tarif);
                    // var_dump($row_hidden_nama_tarif_tgl);
                    // var_dump($gruptarif, '2');
                    // exit;
                    $this->db->query("SELECT ID from RadiologiSQL.dbo.ProcedureRadiology 
                    WHERE Proc_Code = :kodetarifa");
                    $this->db->bind('kodetarifa', $row_hidden_kode_tarif[$i]);
                    $datarada =  $this->db->single();
                    $idpro = $datarada['ID'];

                    $this->db->query("SELECT COUNT(*) as cektarif
                        FROM RadiologiSQL.dbo.ProcedureRadiology_3 A
                        INNER JOIN RadiologiSQL.dbo.ProcedureRadiology_4 B ON a.ID_TR_TARIF = B.ID_TR_TARIF
                        INNER JOIN RadiologiSQL.dbo.ProcedureRadiology C ON C.ID = B.ID_TARIF
                        WHERE :kdtgla between  replace(CONVERT(VARCHAR(11),a.TGL_BERLAKU, 111), '/','-')   and replace(CONVERT(VARCHAR(11),a.TGL_EXPIRED, 111), '/','-') 
                        AND B.GROUP_TARIF = :groupjaminanb1 AND A.KD_INSTALASI = 'RAD' AND C.ID = :idprob1
                    order by 1 desc");
                    $this->db->bind('groupjaminanb1', $groupjaminan);
                    $this->db->bind('idprob1', $idpro);
                    $this->db->bind('kdtgla', $row_hidden_nama_tarif_tgl);
                    $dataradb1 =  $this->db->single();
                    $cek = $dataradb1['cektarif'];

                    // var_dump($cek);
                    // exit;

                    if ($cek <> "0") {

                        $this->db->query("SELECT c.ID as ID,c.Proc_Description as namatarif, b.NILAI
                            FROM RadiologiSQL.dbo.ProcedureRadiology_3 A
                            INNER JOIN RadiologiSQL.dbo.ProcedureRadiology_4 B ON a.ID_TR_TARIF = B.ID_TR_TARIF
                            INNER JOIN RadiologiSQL.dbo.ProcedureRadiology C ON C.ID = B.ID_TARIF
                            WHERE :kdtglb between  replace(CONVERT(VARCHAR(11),a.TGL_BERLAKU, 111), '/','-')   and replace(CONVERT(VARCHAR(11),a.TGL_EXPIRED, 111), '/','-') 
                            AND B.GROUP_TARIF = :groupjaminanb AND A.KD_INSTALASI = 'RAD' AND C.ID = :idprob
                        order by 1 desc");
                        $this->db->bind('groupjaminanb', $groupjaminan);
                        $this->db->bind('idprob', $idpro);
                        $this->db->bind('kdtglb', $row_hidden_nama_tarif_tgl);
                        $dataradb =  $this->db->single();
                        $hargabaru = $dataradb['NILAI'];

                        //
                        $this->db->query("SELECT ID_BILL FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE NO_TRS_BILLING = :notrsbilld AND GROUP_ENTRI = 'LABORATORIUM' AND KODE_TARIF = :kodetarifd");
                        $this->db->bind('kodetarifd', $row_hidden_kode_tarif[$i]);
                        $this->db->bind('notrsbilld', $notrsbill[$i]);
                        $datalabc =  $this->db->single();
                        $noacc = $datalabc['ID_BILL'];

                        // //update WO
                        $this->db->query("UPDATE RadiologiSQL.dbo.WO_RADIOLOGY SET Tarif = :hargabaru1 , Service_Charge =:hargabaru2 WHERE ACCESSION_NO = :noacc");
                        $this->db->bind('hargabaru1', $hargabaru);
                        $this->db->bind('hargabaru2', $hargabaru);
                        $this->db->bind('noacc', $noacc);
                        $this->db->execute();
                    } else {
                        $callback = array(
                            'status' => "warning",
                            'message' => "Pergantian tarif gagal, karena tidak ada tindakan dengan jaminan ini", // Set array nama 

                        );
                        return $callback;
                        exit;
                    }

                    //
                } else if ($gruptarif == "FARMASI") {

                    // $this->db->query("SELECT c.ID as ID,c.[Product Name] as namatarif, b.NILAI, b.ID_TARIF, b.GROUP_TARIF, B.KLSID , D.KD_INSTALASI
                    // FROM PerawatanSQL.DBO.Tarif_RJ_UGD_3  a JOIN PerawatanSQL.DBO.Tarif_RJ_UGD_4 B ON A.ID_TR_TARIF = B.ID_TR_TARIF
                    // INNER JOIN [Apotik_V1.1SQL].dbo.Products C ON C.ID = B.ID_TARIF INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD_2 D ON D.id_tarif = C.ID
                    // WHERE '2023-10-09' between  replace(CONVERT(VARCHAR(11),a.TGL_BERLAKU, 111), '/','-')   and replace(CONVERT(VARCHAR(11),a.TGL_EXPIRED, 111), '/','-')  
                    // AND C.ID = :kdtarifb  AND B.GROUP_TARIF = :groupjaminanb AND B.KLSID = '1' AND D.KD_INSTALASI = 'RJ'
                    // order by 1 desc");
                    // $this->db->bind('groupjaminanb', $groupjaminan);
                    // $this->db->bind('kdtarifb', $row_hidden_kode_tarif[$i]);
                    // $dataradb =  $this->db->single();
                    // $hargabaru = $dataradb['NILAI'];

                    $callback = array(
                        'status' => "warning",
                        'message' => "Pergantian Tarif Untuk Orderan Farmasi Belum Tersedia", // Set array nama 
                    );
                    return $callback;
                    exit;

                    $this->db->query("SELECT COUNT(*) as cektarif
                    FROM [Apotik_V1.1SQL].dbo.Products_3 a JOIN [Apotik_V1.1SQL].dbo.Products_4 B ON A.ID_TR_TARIF = B.ID_TR_TARIF
                    INNER JOIN [Apotik_V1.1SQL].dbo.Products C ON C.ID = B.ID_TARIF 
                    WHERE '2023-10-09' between  replace(CONVERT(VARCHAR(11),a.TGL_BERLAKU, 111), '/','-')   and replace(CONVERT(VARCHAR(11),a.TGL_EXPIRED, 111), '/','-')  
                    and  b.GROUP_TARIF=:groupjaminanb1 and c.ID = :kdtarifb1 order by 1 desc");
                    $this->db->bind('groupjaminanb1', $groupjaminan);
                    $this->db->bind('kdtarifb1', $row_hidden_kode_tarif[$i]);
                    $dataradb1 =  $this->db->single();
                    $cek = $dataradb1['cektarif'];

                    if ($cek <> "0") {
                        $this->db->query("SELECT  c.ID as ID,c.[Product Name] as namatarif, b.NILAI
                    FROM [Apotik_V1.1SQL].dbo.Products_3 a JOIN [Apotik_V1.1SQL].dbo.Products_4 B ON A.ID_TR_TARIF = B.ID_TR_TARIF
                    INNER JOIN [Apotik_V1.1SQL].dbo.Products C ON C.ID = B.ID_TARIF 
                    WHERE '2023-10-09' between  replace(CONVERT(VARCHAR(11),a.TGL_BERLAKU, 111), '/','-')   and replace(CONVERT(VARCHAR(11),a.TGL_EXPIRED, 111), '/','-')  
                    and  b.GROUP_TARIF=:groupjaminanb and c.ID = :kdtarifb order by 1 desc");
                        $this->db->bind('groupjaminanb', $groupjaminan);
                        $this->db->bind('kdtarifb', $row_hidden_kode_tarif[$i]);
                        $dataradb =  $this->db->single();
                        $hargabaru = $dataradb['NILAI'];

                        $this->db->query("SELECT ID_BILL FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE NO_TRS_BILLING = :notrsbilld AND GROUP_ENTRI = 'LABORATORIUM' AND KODE_TARIF = :kodetarifd");
                        $this->db->bind('kodetarifd', $row_hidden_kode_tarif[$i]);
                        $this->db->bind('notrsbilld', $notrsbill[$i]);
                        $datalabc =  $this->db->single();
                        $orderid = $datalabc['ID_BILL'];


                        $this->db->query("UPDATE [Apotik_V1.1SQL].dbo.[Order Details] SET Tarif = :hargabaru1 WHERE [Order ID] = :orderid1 AND [Product ID] = :kodetarif1");
                        $this->db->bind('hargabaru1', $hargabaru);
                        $this->db->bind('orderid1', $orderid);
                        $this->db->bind('kodetarif1', $row_hidden_kode_tarif[$i]);
                        $this->db->execute();
                    } else {
                        $callback = array(
                            'status' => "warning",
                            'message' => "Pergantian tarif gagal, karena tidak ada tindakan dengan jaminan ini", // Set array nama 
                        );
                        return $callback;
                        exit;
                    }

                    //
                } else if ($gruptarif == "BANKDARAH") {

                    $callback = array(
                        'status' => "warning",
                        'message' => "Pergantian Tarif Untuk Orderan Bank Darah Belum Tersedia", // Set array nama 
                    );
                    return $callback;
                    exit;

                    $this->db->query("SELECT COUNT(*) as cektarif
                    FROM LaboratoriumSQL.dbo.MasterBloodBanks_3 a JOIN LaboratoriumSQL.dbo.MasterBloodBanks_4 B ON A.ID_TR_TARIF = B.ID_TR_TARIF
                    INNER JOIN LaboratoriumSQL.dbo.MasterBloodBanks C ON C.ID = B.ID_TARIF 
                    WHERE '2023-10-09' between  replace(CONVERT(VARCHAR(11),a.TGL_BERLAKU, 111), '/','-')   and replace(CONVERT(VARCHAR(11),a.TGL_EXPIRED, 111), '/','-')  
                    and  b.GROUP_TARIF=:groupjaminanb1 and c.ID = :kdtarifb1 order by 1 desc");
                    $this->db->bind('groupjaminanb1', $groupjaminan);
                    $this->db->bind('kdtarifb1', $row_hidden_kode_tarif[$i]);
                    $dataradb1 =  $this->db->single();
                    $cek = $dataradb1['cektarif'];

                    if ($cek <> "0") {
                        $this->db->query("SELECT  c.ID as ID,c.Name as namatarif, b.NILAI
                        FROM LaboratoriumSQL.dbo.MasterBloodBanks_3 a JOIN LaboratoriumSQL.dbo.MasterBloodBanks_4 B ON A.ID_TR_TARIF = B.ID_TR_TARIF
                        INNER JOIN LaboratoriumSQL.dbo.MasterBloodBanks C ON C.ID = B.ID_TARIF 
                        WHERE '2023-10-09' between  replace(CONVERT(VARCHAR(11),a.TGL_BERLAKU, 111), '/','-')   and replace(CONVERT(VARCHAR(11),a.TGL_EXPIRED, 111), '/','-')  
                        and  b.GROUP_TARIF=:groupjaminanb and c.ID = :kdtarifb order by 1 desc");
                        $this->db->bind('groupjaminanb', $groupjaminan);
                        $this->db->bind('kdtarifb', $row_hidden_kode_tarif[$i]);
                        $dataradb =  $this->db->single();
                        $hargabaru = $dataradb['NILAI'];

                        $this->db->query("SELECT ID_BILL FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE NO_TRS_BILLING = :notrsbilld AND GROUP_ENTRI = 'LABORATORIUM' AND KODE_TARIF = :kodetarifd");
                        $this->db->bind('kodetarifd', $row_hidden_kode_tarif[$i]);
                        $this->db->bind('notrsbilld', $notrsbill[$i]);
                        $datalabc =  $this->db->single();
                        $IDHDR = $datalabc['ID_BILL'];


                        $this->db->query("UPDATE LaboratoriumSQL.dbo.OrderBloodDetails SET Harga = :hargabaru1 WHERE IDHdr = :IDHDR1 AND IdTarifDarah = :kodetarif1");
                        $this->db->bind('hargabaru1', $hargabaru);
                        $this->db->bind('IDHDR1', $IDHDR);
                        $this->db->bind('kodetarif1', $row_hidden_kode_tarif[$i]);
                        $this->db->execute();
                    } else {
                        $callback = array(
                            'status' => "warning",
                            'message' => "Pergantian tarif gagal, karena tidak ada tindakan dengan jaminan ini", // Set array nama 
                        );
                        return $callback;
                        exit;
                    }
                    //
                } else {

                    $row_hidden_nama_tarif_tgl = substr($row_hidden_nama_tarif_[2], 0, 10);

                    // var_dump($groupjaminan);
                    // var_dump($row_hidden_kode_tarif[$i]);
                    // var_dump($row_hidden_nama_tarif_tgl);
                    // var_dump($ID_UNIT);
                    // exit;

                    if ($ID_UNIT == '1') {
                        $kelastemp = '2';
                        $this->db->query("SELECT  COUNT(*) as cektarif FROM PerawatanSQL.DBO.Tarif_RJ_UGD_3 A
                        INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD_4 B ON A.ID_TR_TARIF = B.ID_TR_TARIF
                        INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD C ON C.ID = B.ID_TARIF
                        INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD_2 D ON D.id_tarif = C.ID
                        WHERE :kdtgla between  replace(CONVERT(VARCHAR(11),a.TGL_BERLAKU, 111), '/','-')   and replace(CONVERT(VARCHAR(11),a.TGL_EXPIRED,          111), '/','-')  
                        and b.KD_INSTALASI='RJ' and b.GROUP_TARIF=:groupjaminana
                        and id_layanan=:ID_UNITa and C.ID = :kdtarifa and KLSID = '2' order by 1 desc");
                    } else {
                        $kelastemp = '3';
                        $this->db->query("SELECT  COUNT(*) as cektarif FROM PerawatanSQL.DBO.Tarif_RJ_UGD_3 A
                        INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD_4 B ON A.ID_TR_TARIF = B.ID_TR_TARIF
                        INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD C ON C.ID = B.ID_TARIF
                        INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD_2 D ON D.id_tarif = C.ID
                        WHERE :kdtgla between  replace(CONVERT(VARCHAR(11),a.TGL_BERLAKU, 111), '/','-')   and replace(CONVERT(VARCHAR(11),a.TGL_EXPIRED,          111), '/','-')  
                        and b.KD_INSTALASI='RJ' and b.GROUP_TARIF=:groupjaminana
                        and id_layanan=:ID_UNITa and C.ID = :kdtarifa and KLSID = '3' order by 1 desc");
                    }
                    $this->db->bind('groupjaminana', $groupjaminan);
                    $this->db->bind('kdtarifa', $row_hidden_kode_tarif[$i]);
                    $this->db->bind('kdtgla', $row_hidden_nama_tarif_tgl);
                    $this->db->bind('ID_UNITa', $ID_UNIT);
                    $datarja =  $this->db->single();
                    $cek = $datarja['cektarif'];

                    if ($cek <> "0") {
                        // $this->db->query("SELECT  C.ID as ID, C.[Product Name] as namatarif, B.NILAI as NILAI, B.ID_TARIF, B.GROUP_TARIF, B.KLSID, D.KD_INSTALASI  FROM PerawatanSQL.DBO.Tarif_RJ_UGD_3 A
                        // INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD_4 B ON A.ID_TR_TARIF = B.ID_TR_TARIF
                        // INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD C ON C.ID = B.ID_TARIF
                        // INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD_2 D ON D.id_tarif = C.ID
                        // WHERE :kdtglb 
                        // between  replace(CONVERT(VARCHAR(11),a.TGL_BERLAKU, 111), '/','-')   and replace(CONVERT(VARCHAR(11),a.TGL_EXPIRED,          111), '/','-')  
                        // and b.KD_INSTALASI='RJ' and b.GROUP_TARIF=:groupjaminanb
                        // and id_layanan=:ID_UNITb and C.ID = :kdtarifb and KLSID = :kelastemp order by 1 desc");


                        $this->db->query("SELECT 
                        A.ID_TR_TARIF,c.ID,c.[Product Name] as namatarif , D.id_layanan, SUM(b.NILAI) AS NILAI
                        FROM PerawatanSQL.DBO.Tarif_RJ_UGD_3 A
                        INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD_4 B ON A.ID_TR_TARIF = B.ID_TR_TARIF
                        INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD C ON C.ID = B.ID_TARIF
                        INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD_2 D ON D.id_tarif = C.ID
                        WHERE :kdtglb 
                        between  replace(CONVERT(VARCHAR(11),a.TGL_BERLAKU, 111), '/','-')   and replace(CONVERT(VARCHAR(11),a.TGL_EXPIRED, 111), '/','-')  
                        and b.KD_INSTALASI='RJ'  AND B.GROUP_TARIF=:groupjaminanb
                        and id_layanan=:ID_UNITb and KLSID = :kelastemp and C.ID = :kdtarifb 
                        group by  A.ID_TR_TARIF,c.ID,c.[Product Name] ,D.id_layanan
                        order by 2 asc ");

                        $this->db->bind('groupjaminanb', $groupjaminan);
                        $this->db->bind('kdtarifb', $row_hidden_kode_tarif[$i]);
                        $this->db->bind('ID_UNITb', $ID_UNIT);
                        $this->db->bind('kdtglb', $row_hidden_nama_tarif_tgl);
                        $this->db->bind('kelastemp', $kelastemp);
                        $datarjb =  $this->db->single();
                        $hargabaru = $datarjb['NILAI'];
                    } else {
                        $callback = array(
                            'status' => "warning",
                            'message' => "Pergantian tarif gagal, karena tidak ada tindakan dengan jaminan ini", // Set array nama 
                        );
                        return $callback;
                        exit;
                    }
                }

                $hargadisc = $row_hidden_diskon_[$i] * $hargabaru;
                $subtotal2 = $hargabaru - $hargadisc;
                $subtotalxx = $hargabaru * $row_hidden_qty_[$i];
                $grttl = $subtotalxx - $hargadisc;
                $totaltarif = $totaltarif + $hargabaru;
                $totalqty = $totalqty + $row_hidden_qty_[$i];
                $subtotal = $subtotal + $subtotalxx;
                $totaldiskon = $totaldiskon + $hargadisc;

                $grandsubtotal2 = $grandsubtotal2 + $subtotal2;
                $grandtotal = $grandtotal + $grttl;


                // UPDATE FO_1
                // GROUP_JAMINANNO
                // penjamin_kodex

                $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING 
                SET GROUP_JAMINAN = :GROUP_JAMINANNO1a, KODE_JAMINAN = :penjamin_kodex1a
                WHERE NO_TRS_BILLING = :notrsbill1a");
                $this->db->bind('notrsbill1a', $notrsbill);
                $this->db->bind('GROUP_JAMINANNO1a', $GROUP_JAMINANNO);
                $this->db->bind('penjamin_kodex1a', $penjamin_kodex);
                $this->db->execute();


                if ($data['GROUP_JAMINANNO'] == "1") {
                    $kekurangan = $grttl;
                    $klaim = "0";
                    $bayar = "0";
                } else {
                    $kekurangan = "0";
                    $klaim = $grttl;
                    $bayar = "0";
                }

                // var_dump($hargabaru);
                // var_dump($subtotal2);
                // var_dump($subtotalxx);
                // var_dump($grttl);
                // var_dump($grandtotal);
                // var_dump($gruptarif);
                // var_dump($row_hidden_kode_tarif);
                // var_dump($notrsbill);
                // var_dump($GROUP_JAMINANNO);
                // var_dump($penjamin_kodex);
                // var_dump($kekurangan);
                // var_dump($klaim);
                // exit;

                // UPDATE FO_2
                $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_2 
                SET GROUP_JAMINAN= :GROUP_JAMINANNO2, KODE_JAMINAN= :penjamin_kodex2, 
                NILAI_TARIF = :hargabaru2, SUB_TOTAL = :subtotalxx2, SUB_TOTAL_2 = :subtotal22
                WHERE NO_TRS_BILLING = :notrsbill2 AND KODE_TARIF = :kdtarif2");
                $this->db->bind('hargabaru2', $hargabaru);
                $this->db->bind('subtotal22', $subtotal2);
                $this->db->bind('subtotalxx2', $subtotalxx);
                $this->db->bind('kdtarif2', $row_hidden_kode_tarif[$i]);
                $this->db->bind('notrsbill2', $notrsbill);
                $this->db->bind('GROUP_JAMINANNO2', $GROUP_JAMINANNO);
                $this->db->bind('penjamin_kodex2', $penjamin_kodex);
                $this->db->execute();

                $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 
                SET GROUP_JAMINAN = :GROUP_JAMINANNO1, 
                KODE_JAMINAN = :penjamin_kodex1, 
                NILAI_TARIF = :hargabaru, SUB_TOTAL = :subtotalxx, SUB_TOTAL_2 = :subtotal2, GRANDTOTAL = :grttl, 
                KLAIM = :klaim, KEKURANGAN = :kekurangan, DISC=:DISC , DISC_RP = :DISC_RP
                WHERE NO_TRS_BILLING = :notrsbill1 AND KODE_TARIF = :kdtarif1 AND GROUP_ENTRI = :gruptarif1");
                $this->db->bind('hargabaru', $hargabaru);
                $this->db->bind('subtotal2', $subtotal2);
                $this->db->bind('subtotalxx', $subtotalxx);
                $this->db->bind('grttl', $grttl);
                $this->db->bind('DISC', $row_hidden_diskon_[$i]);
                $this->db->bind('DISC_RP', $hargadisc);
                // $this->db->bind('grandtotal', $grandtotal);
                $this->db->bind('kekurangan', $kekurangan);
                $this->db->bind('klaim', $klaim);
                $this->db->bind('gruptarif1', $gruptarif);
                $this->db->bind('kdtarif1', $row_hidden_kode_tarif[$i]);
                $this->db->bind('notrsbill1', $notrsbill);
                $this->db->bind('GROUP_JAMINANNO1', $GROUP_JAMINANNO);
                $this->db->bind('penjamin_kodex1', $penjamin_kodex);
                $this->db->execute();

                // UPDATE FO
                $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_BILLING
                SET TOTAL_TARIF=B.SUM_NILAI_TARIF,TOTAL_QTY=B.SUM_QTY,SUBTOTAL=B.SUM_SUB_TOTAL,SUBTOTAL_2=B.SUM_SUB_TOTAL_2,GRANDTOTAL=B.SUM_GRANDTOTAL,
                FB_VERIF_JURNAL='0' 
                FROM Billing_Pasien.DBO.FO_T_BILLING A 
                INNER JOIN
                (
                    SELECT  NO_TRS_BILLING,SUM(NILAI_TARIF) AS SUM_NILAI_TARIF,SUM(QTY) AS SUM_QTY,SUM(SUB_TOTAL) AS SUM_SUB_TOTAL,SUM(SUB_TOTAL_2) AS SUM_SUB_TOTAL_2,
                    SUM(GRANDTOTAL) AS SUM_GRANDTOTAL
                    FROM Billing_Pasien.DBO.FO_T_BILLING_1
                    WHERE NO_REGISTRASI=:noreg and Batal='0'
                    GROUP BY NO_TRS_BILLING
                ) B
                ON A.NO_TRS_BILLING = B.NO_TRS_BILLING
                WHERE A.NO_REGISTRASI=:noreg2 AND A.NO_TRS_BILLING=:notrsbill
                ");
                $this->db->bind('noreg', $noreg);
                $this->db->bind('noreg2', $noreg);
                $this->db->bind('notrsbill', $notrsbill);
                $this->db->execute();
            }

            $this->db->commit();
            $callback = array(
                'status' => "success",
                'message' => "Berhasil Melakukan Transaksi", // Set array nama 

            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function changeBillingJaminan_backup($data)
    {
        try {
            $this->db->transaksi();
            // var_dump($data);
            // exit;
            $notrsbill = $data['Idbilling'];
            $noreg = $data['bilNOreg'];



            $groupjaminan = $data['xgrupjaminan'];

            $row_data_id = $data['hidden_id'];
            $row_hidden_nama_tarif_ = $data['hidden_nama_tarif_'];
            // $row_hidden_nama_dr_ = $data['hidden_nama_dr_'];
            // $row_hidden_tgl_billing_ = $data['hidden_tgl_billing_'];
            $row_hidden_qty_ = $data['hidden_qty_'];
            $row_hidden_harga_ = $data['hidden_harga_'];
            $row_hidden_subtotal_ = $data['hidden_subtotal_'];
            $row_hidden_diskon_ = $data['hidden_diskon_'];
            $hidden_subtotal2_ = $data['hidden_subtotal2_'];

            // $row_hidden_kode_tarif = $data['hidden_kode_tarif'];

            $jumlahdata = count($row_data_id);

            $ID_UNIT = $data['ID_UNIT'];

            $totaltarif = 0;
            $totalqty = 0;
            $subtotal = 0;
            $totaldiskon = 0;
            $totaldiskonrp = 0;
            $grandsubtotal2 = 0;
            $grandtotal = 0;

            //contoh
            $gruptarifx = $data['GROUP_ENTRI_'];
            $row_hidden_kode_tarif = $data['KODE_TARIF_'];
            $row_hidden_kode_ref = $data['KODE_REF_'];


            // $hargabaru = 1000;
            for ($i = 0; $i < $jumlahdata; $i++) {
                // selct tarif 
                //GET TARIF

                // var_dump($gruptarifx[$i]);
                // var_dump($row_hidden_kode_tarif[$i]);
                // exit;

                $gruptarif = $gruptarifx[$i];
                // var_dump($gruptarif);
                // exit;

                if ($gruptarif == "LABORATORIUM") {
                    // var_dump($gruptarif, '1');
                    // exit;

                    $this->db->query("SELECT kodekelompok FROM LaboratoriumSQL.dbo.tblGrouping a
                    INNER JOIN LaboratoriumSQL.dbo.tblTestLab b ON a.KodeTes = b.KodeTes
                    WHERE a.InLevel='1' and Discontinue= '0' AND a.IDTes = :kodetarifA
                    and a.Group_Jaminan= :groupjaminanA");
                    $this->db->bind('kodetarifA', $row_hidden_kode_tarif[$i]);
                    $this->db->bind('groupjaminanA', $groupjaminan);
                    $dataxa =  $this->db->single();
                    $kodekelompok = $dataxa['kodekelompok'];

                    $this->db->query("SELECT COUNT(*) as cektarif FROM LaboratoriumSQL.dbo.tblGrouping a
                    INNER JOIN LaboratoriumSQL.dbo.tblTestLab b ON a.KodeTes = b.KodeTes
                    WHERE a.InLevel='1' and Discontinue= '0' AND a.kodekelompok = :kodetarifA
                    and a.Group_Jaminan= :groupjaminanA");
                    $this->db->bind('kodekelompok', $kodekelompok);
                    $this->db->bind('groupjaminanA', $groupjaminan);
                    $dataxa =  $this->db->single();
                    $cekTarif = $dataxa['cektarif'];


                    if ($cekTarif <> "0") {
                        $this->db->query("SELECT a.IDTes, a.KodeTes, a.KodeKelompok,a.NamaTes, a.Tarif, 
                        a.TJamsostek, a.TGakin, b.Kelompok, a.InLevel , a.Group_Jaminan
                        FROM LaboratoriumSQL.dbo.tblGrouping a
                        INNER JOIN LaboratoriumSQL.dbo.tblTestLab b ON a.KodeTes = b.KodeTes
                        WHERE a.InLevel='1' and Discontinue= '0' AND a.IDTes = :kodetarif
                        and a.Group_Jaminan= :groupjaminan ORDER BY a.InLevel, a.NamaTes, a.IDTes");
                        $this->db->bind('kodetarif', $row_hidden_kode_tarif[$i]);
                        $this->db->bind('groupjaminan', $groupjaminan);
                        $datax =  $this->db->single();
                        $hargabaru = $datax['Tarif'];

                        //update LAB
                        $this->db->query("UPDATE LaboratoriumSQL.dbo.tblLabDetail SET Tarif = :hargabarux WHERE idTes = :kodetarifx AND LabDetailID = :koderefx");
                        $this->db->bind('hargabarux', $hargabaru);
                        $this->db->bind('kodetarifx', $row_hidden_kode_tarif[$i]);
                        $this->db->bind('koderefx', $row_hidden_kode_ref[$i]);
                        $this->db->execute();
                    } else {
                        $callback = array(
                            'status' => 'warning',
                            'message' => 'tarif tidak ada pada jaminan ini!',
                        );
                        echo json_encode($callback);
                        exit;
                    }
                } else if ($gruptarif == "RADIOLOGI") {
                    // var_dump($gruptarif, '2');
                    // exit;
                    $this->db->query("SELECT COUNT(*) as cektarif FROM RadiologiSQL.dbo.ProcedureRadiology 
                    WHERE Proc_Code = :kodetarifA AND Group_Jaminan = :groupjaminanA");
                    $this->db->bind('kodetarifA', $row_hidden_kode_tarif[$i]);
                    $this->db->bind('groupjaminanA', $groupjaminan);
                    $dataxa =  $this->db->single();
                    $cekTarif = $dataxa['cektarif'];

                    if ($cekTarif <> "0") {
                        $this->db->query("SELECT ServiceCharge_O from RadiologiSQL.dbo.ProcedureRadiology 
                        WHERE Proc_Code = :kodetarif :groupjaminan");
                        $this->db->bind('kodetarif', $row_hidden_kode_tarif[$i]);
                        $this->db->bind('groupjaminan', $groupjaminan);
                        $datax =  $this->db->single();
                        $hargabaru = $datax['ServiceCharge_O'];
                    } else {
                        $callback = array(
                            'status' => 'warning',
                            'message' => 'tarif tidak ada pada jaminan ini!',
                        );
                        echo json_encode($callback);
                        exit;
                    }
                } else if ($gruptarif == "FARMASI") {
                    // var_dump($gruptarif, '3');
                    // exit;

                    $this->db->query("SELECT COUNT(*) as cektarif FROM  [Apotik_V1.1SQL].dbo.Products 
                    where ID = :kodetarifA and Group_Jaminan = :groupjaminanA");
                    $this->db->bind('kodetarifA', $row_hidden_kode_tarif[$i]);
                    $this->db->bind('groupjaminanA', $groupjaminan);
                    $dataxa =  $this->db->single();
                    $cekTarif = $dataxa['cektarif'];

                    if ($cekTarif <> "0") {
                        $this->db->query("SELECT [Product Name] ,isnull([Quantity Per Unit],0) as qtystok,isnull([List Price],0) as listprice,isnull(Konversi_satuan,0) as KonversiSatuan,[Unit Satuan] as unitsatuan from [Apotik_V1.1SQL].dbo.Products 
                        where ID = :kodetarif and Group_Jaminan = :groupjaminan");
                        $this->db->bind('kodetarif', $row_hidden_kode_tarif[$i]);
                        $this->db->bind('groupjaminan', $groupjaminan);
                        $datax =  $this->db->single();
                        $qtystok = $datax['qtystok'];
                        $hargabaru = $datax['listprice'];
                    } else {
                        $callback = array(
                            'status' => 'warning',
                            'message' => 'tarif tidak ada pada jaminan ini!',
                        );
                        echo json_encode($callback);
                        exit;
                    }
                } else {
                    var_dump('TARIF RAJAL');
                    exit;
                    // $ID_UNIT
                    $this->db->query("SELECT  c.ID,c.[Product Name] as namatarif, b.NILAI, id_layanan, b.GROUP_TARIF, C.ID
                    FROM PerawatanSQL.DBO.Tarif_RJ_UGD_3 A
                    INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD_4 B ON A.ID_TR_TARIF = B.ID_TR_TARIF
                    INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD C ON C.ID = B.ID_TARIF
                    INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD_2 D ON D.id_tarif = C.ID
                    WHERE '2024-09-09' between  replace(CONVERT(VARCHAR(11),a.TGL_BERLAKU, 111), '/','-')   and replace(CONVERT(VARCHAR(11),a.TGL_EXPIRED,             111), '/','-')  
                    and b.KD_INSTALASI='RJ' and b.GROUP_TARIF='BS'
                    and id_layanan='22'");
                    $this->db->bind('kodetarifA', $row_hidden_kode_tarif[$i]);
                    $this->db->bind('groupjaminanA', $groupjaminan);
                    $this->db->bind('ID_UNIT', $ID_UNIT);
                    $dataxa =  $this->db->single();
                    $cekTarif = $dataxa['cektarif'];
                    // var_dump($cekTarif);
                    // exit;
                    if ($cekTarif <> "0") {
                        // var_dump($cekTarif, 'tai');
                        // exit;
                        $this->db->query("SELECT ID,[Product Name],CategoryProduct,TarifRS from PerawatanSQL.dbo.Tarif_RJ_UGD where ID=:kodetarif and Group_Jaminan = :groupjaminan");
                        $this->db->bind('kodetarif', $row_hidden_kode_tarif[$i]);
                        $this->db->bind('groupjaminan', $groupjaminan);
                        $datax =  $this->db->single();
                        $hargabaru = $datax['TarifRS'];
                    } else {
                        // var_dump($cekTarif, 'ita');
                        // exit;
                        $callback = array(
                            'status' => 'warning',
                            'message' => 'tarif tidak ada pada jaminan ini!',
                        );
                        // return $callback;
                        echo json_encode($callback);
                        exit;
                    }
                }

                // var_dump($hargabaru);
                // exit;
                // $totaldiskonrp = 0;
                $subtotal2 = $hargabaru - $row_hidden_diskon_[$i];
                $subtotalxx = $hargabaru * $row_hidden_qty_[$i];
                $grttl = $subtotalxx - $row_hidden_diskon_[$i];
                $totaltarif = $totaltarif + $hargabaru;
                $totalqty = $totalqty + $row_hidden_qty_[$i];
                $subtotal = $subtotal + $subtotalxx;
                $totaldiskon = $totaldiskon + $row_hidden_diskon_[$i];

                $grandsubtotal2 = $grandsubtotal2 + $subtotal2;
                $grandtotal = $grandtotal + $grttl;


                // UPDATE FO_1
                $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 SET NILAI_TARIF = :hargabaru, SUB_TOTAL = :subtotalxx, SUB_TOTAL_2 = :subtotal2, GRANDTOTAL = :grttl, KLAIM = :grandtotal
                WHERE NO_TRS_BILLING = :notrsbill1 AND KODE_TARIF = :kdtarif1 AND GROUP_ENTRI = :gruptarif1");
                $this->db->bind('hargabaru', $hargabaru);
                $this->db->bind('subtotal2', $subtotal2);
                $this->db->bind('subtotalxx', $subtotalxx);
                $this->db->bind('grttl', $grttl);
                // $this->db->bind('totaltarif', $totaltarif);
                // $this->db->bind('totalqty', $totalqty);
                // $this->db->bind('subtotal', $subtotal);
                // $this->db->bind('totaldiskon', $totaldiskon);
                // $this->db->bind('grandsubtotal2', $grandsubtotal2);
                $this->db->bind('grandtotal', $grandtotal);

                $this->db->bind('gruptarif1', $gruptarif);
                $this->db->bind('kdtarif1', $row_hidden_kode_tarif[$i]);
                $this->db->bind('notrsbill1', $notrsbill);
                $this->db->execute();



                // UPDATE FO_2
                $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_2 SET NILAI_TARIF = :hargabaru2, SUB_TOTAL = :subtotalxx2, SUB_TOTAL_2 = :subtotal22
                WHERE NO_TRS_BILLING = :notrsbill2 AND KODE_TARIF = :kdtarif2");
                $this->db->bind('hargabaru2', $hargabaru);
                $this->db->bind('subtotal22', $subtotal2);
                $this->db->bind('subtotalxx2', $subtotalxx);
                // $this->db->bind('grttl', $grttl);
                // $this->db->bind('totaltarif', $totaltarif);
                // $this->db->bind('totalqty', $totalqty);
                // $this->db->bind('subtotal', $subtotal);
                // $this->db->bind('totaldiskon', $totaldiskon);
                // $this->db->bind('grandsubtotal2', $grandsubtotal2);
                // $this->db->bind('grandtotal', $grandtotal);

                // $this->db->bind('gruptarif2', $gruptarif);
                $this->db->bind('kdtarif2', $row_hidden_kode_tarif[$i]);
                $this->db->bind('notrsbill2', $notrsbill);
                $this->db->execute();

                // var_dump($grandtotal);
                // exit;

                // UPDATE FO
                $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_BILLING
                SET TOTAL_TARIF=B.SUM_NILAI_TARIF,TOTAL_QTY=B.SUM_QTY,SUBTOTAL=B.SUM_SUB_TOTAL,SUBTOTAL_2=B.SUM_SUB_TOTAL_2,GRANDTOTAL=B.SUM_GRANDTOTAL,
                FB_VERIF_JURNAL='0' 
                FROM Billing_Pasien.DBO.FO_T_BILLING A 
                INNER JOIN
                (
                    SELECT  NO_TRS_BILLING,SUM(NILAI_TARIF) AS SUM_NILAI_TARIF,SUM(QTY) AS SUM_QTY,SUM(SUB_TOTAL) AS SUM_SUB_TOTAL,SUM(SUB_TOTAL_2) AS SUM_SUB_TOTAL_2,
                    SUM(GRANDTOTAL) AS SUM_GRANDTOTAL
                    FROM Billing_Pasien.DBO.FO_T_BILLING_1
                    WHERE NO_REGISTRASI=:noreg and Batal='0'
                    GROUP BY NO_TRS_BILLING
                ) B
                ON A.NO_TRS_BILLING = B.NO_TRS_BILLING
                WHERE A.NO_REGISTRASI=:noreg2 AND A.NO_TRS_BILLING=:notrsbill
                ");
                $this->db->bind('noreg', $noreg);
                $this->db->bind('noreg2', $noreg);
                $this->db->bind('notrsbill', $notrsbill);
                $this->db->execute();
            }

            $this->db->commit();
            $callback = array(
                'status' => "success",
                'message' => "Berhasil Melakukan Transaksi", // Set array nama 

            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }




    public function getDataRekapBiaya($data)
    {
        try {
            $noreg = $data['noreg'];
            $tglawal = $data['tglawal'];
            $tglakhir = $data['tglakhir'];
            $this->db->query("SELECT sum(GRANDTOTAL) as Jumlah,GROUP_TARIF as Keterangan from Billing_Pasien.dbo.FO_T_BILLING_1 where
			NO_REGISTRASI=:noreg AND BATAL='0' and replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-') between :tglawal and :tglakhir
			group by GROUP_TARIF
             ");
            $this->db->bind('noreg', $noreg);
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['Keterangan'] = $key['Keterangan'];
                // $pasing['Jumlah'] = number_format($key['Jumlah'], 0, ',', '.');
                $pasing['Jumlah'] = $key['Jumlah'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // 25/08/2024
    public function getDataRiwayatPayment($data)
    {
        try {
            $noreg = $data['noreg'];
            $tglawal = $data['tglawal'];
            $tglakhir = $data['tglakhir'];
            $this->db->query("SELECT a.NO_TRS, a.NO_KWITANSI, a.TGL_TRS, SUBSTRING(y.nama_tipe,1, LEN(y.nama_tipe) - 1) TIPE_PEMBAYARAN, a.NOMINAL_BAYAR, a.USER_KASIR, a.BILLTO, SUBSTRING(x.nama_test,1, LEN(x.nama_test) - 1) NamaTest 
            FROM Billing_Pasien.dbo.FO_T_KASIR a
            OUTER APPLY (SELECT NAMA_TARIF + ', '
            FROM Billing_Pasien.dbo.FO_T_BILLING_1
            WHERE ID_TRS_Payment = a.NO_TRS AND BATAL = '0'
            FOR XML PATH('')
            ) x (nama_test) 
            OUTER APPLY (SELECT TIPE_PEMBAYARAN + ', '
            FROM Billing_Pasien.dbo.FO_T_KASIR_2
            WHERE NO_TRS_REFF = a.NO_TRS
            FOR XML PATH('')
            ) y (nama_tipe)
            WHERE a.NO_REGISTRASI = :noreg  AND a.BATAL='0' and replace(CONVERT(VARCHAR(11), a.TGL_TRS, 111), '/','-') between :tglawal and :tglakhir
            ");
            $this->db->bind('noreg', $noreg);
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['NO_TRS'] = $key['NO_TRS'];
                $pasing['NO_KWITANSI'] = $key['NO_KWITANSI'];
                $pasing['TGL_TRS'] = $key['TGL_TRS'];
                $pasing['TIPE_PEMBAYARAN'] = $key['TIPE_PEMBAYARAN'];
                $pasing['NOMINAL_BAYAR'] = number_format($key['NOMINAL_BAYAR'], 0, ',', '.');
                $pasing['USER_KASIR'] = $key['USER_KASIR'];
                $pasing['BILLTO'] = $key['BILLTO'];
                $pasing['NamaTest'] = $key['NamaTest'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    // 25/08/2024

    public function getDataApproveFarmasi($data)
    {
        try {
            $noreg = $data['noreg'];
            $tglawal = $data['tglawal'];
            $tglakhir = $data['tglakhir'];
            $substr = substr($noreg, 0, 2);

            // Badrul
            // Start Data Approve
            $query = "SELECT a.NoResep AS orderid, a.TransactionDate AS tglResep, b.NamaUserOrder AS NamaDokter, a.TransactionCode AS NoResep, a.Grandtotal AS TotalObat,
d.[Status Name] AS StatusName, d.[Status ID] AS StatusID, 
            CASE 
            WHEN b.JenisResep = 1 THEN 'CITO' WHEN b.JenisResep = 2 THEN 'OBAT RUTIN' 
            WHEN b.JenisResep = 3 THEN 'OBAT PULANG' WHEN b.JenisResep = 4 THEN 'TAMBAHAN' 
            WHEN b.JenisResep  = 5 THEN 'TERAPI BARU' ELSE '' END AS JenisResep,
			CASE 
            WHEN a.TransactionCode is not NUll AND c.NO_TRS_BILLING IS NULL THEN 'Review'
            WHEN a.TransactionCode is not NUll AND c.NO_TRS_BILLING IS not NULL THEN 'Approve'
			ELSE 'New' END AS StatusResep
            FROM [Apotik_V1.1SQL].dbo.Sales a
            INNER JOIN [Apotik_V1.1SQL].dbo.OrderResep b on a.NoResep = b.ID
            INNER JOIN [Apotik_V1.1SQL].dbo.[Orders Status] d ON b.StatusResep = d.[Status ID]
			LEFT JOIN Billing_Pasien.dbo.FO_T_BILLING c on c.NO_TRS_BILLING = a.TransactionCode
            WHERE a.NoRegistrasi = :noreg AND a.Void = '0' AND replace(CONVERT(VARCHAR(11), a.TransactionDate, 111), '/','-') Between :tglawal AND :tglakhir";
            // End Data Approve
            // Badrul
            $this->db->query($query);
            $this->db->bind('noreg', $noreg);
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['orderid'] = $key['orderid'];
                $pasing['tglResep'] = $key['tglResep'];
                $pasing['JenisResep'] = $key['JenisResep'];
                $pasing['NoResep'] = $key['NoResep'];
                $pasing['StatusName'] = $key['StatusName'];
                $pasing['StatusID'] = $key['StatusID'];
                $pasing['StatusResep'] = $key['StatusResep'];
                $pasing['Jumlah'] = number_format($key['TotalObat'], 0, ',', '.');
                //$rows[] = $pasing;
                $rows[] = $pasing;
            }
            // var_dump($rows);
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function Approve($data)
    {
        try {
            $this->db->transaksi();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $datenowx = Utils::datenowcreateNotFull();

            $datenowcreate = Utils::seCurrentDateTime();

            $noreg = $data['noreg'];
            $noeps = $data['noeps'];
            $nomr = $data['nomr'];


            $datebill = $data['datebill'];
            $datebills  = date('dmy', strtotime($datebill));
            $datenowcreatex =  $datebill . ' 00:00:00';


            $dataaptk = $data['data'];
            $idbtn = $_POST['idbtn'];
            $getREG = $data['getreg'];

            $kelas = NULL;

            if ($getREG == 'RI') {
                $this->db->query("SELECT KlsID FROM RawatInapSQL.dbo.Inpatient WHERE NoRegRI = :noregri");
                $this->db->bind('noregri', $noreg);
                $klsiddata =  $this->db->single();
                $kelas = $klsiddata['KlsID'];
            } else {
                if ($data['IDUnit'] == '1') {
                    $kelas = '2';
                } else {
                    $kelas = '3';
                }
            }

            $this->db->query("SELECT [Status ID] AS statuspasien FROM PerawatanSQL.dbo.visit WHERE NoRegistrasi = :norega1
            UNION ALL SELECT StatusID AS statuspasien FROM RawatInapSQL.dbo.Inpatient WHERE NoRegRI = :norega2");
            $this->db->bind('norega1', $data['noreg']);
            $this->db->bind('norega2', $data['noreg']);
            $statuscek =  $this->db->single();
            $statuspasien = $statuscek['statuspasien'];

            if ($statuspasien == '4') {
                $callback = array(
                    'status' => "error", // Set array nama
                    'message' => "Status Pasien Sudah Close"
                );
                return $callback;
                exit;
            }

            if ($idbtn == 'btn_approve') {
                //Cek
                $this->db->query("SELECT ID as odid
                FROM [Apotik_V1.1SQL].dbo.OrderResep
                WHERE (StatusResep = 0) AND ID =:iddata");
                $this->db->bind('iddata', $dataaptk);
                $data_cek =  $this->db->single();
                if ($data_cek) {
                    $callback = array(
                        'status' => "error",
                        'message' => "Gagal Approve, Status Order Harus Review !, Status order saat ini new silahkan hubungi bagian farmasi untuk review orderan",
                    );
                    return $callback;
                    exit;
                }

                $this->db->query("SELECT TransactionCode FROM [Apotik_V1.1SQL].dbo.Sales WHERE NoRegistrasi = :noregsales AND NoResep = :noresepsales AND Void = '0'");
                $this->db->bind('noresepsales', $dataaptk);
                $this->db->bind('noregsales', $noreg);
                $data_ceksales =  $this->db->single();
                $trscodesales = $data_ceksales['TransactionCode'];

                $this->db->query("SELECT COUNT(id) AS cekApproved FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE NO_TRS_BILLING = :trscodesalesapprove AND BATAL ='0' ");
                $this->db->bind('trscodesalesapprove', $trscodesales);
                $data_cekApprove =  $this->db->single();
                $cekApprove = $data_cekApprove['cekApproved'];

                if ($cekApprove <> 0) {
                    $callback = array(
                        'status' => "error",
                        'message' => "Gagal Approve !, Status order saat ini sudah pernah di approve, silahkan batal approve untuk approve ulang orderan",
                    );
                    return $callback;
                    exit;
                }

                $datenowcreate = Utils::seCurrentDateTime();
                $datenowcreate1 = date('Y-m-d', strtotime($datenowcreate));
                $datenowcreate2 = date('dmy', strtotime($datenowcreate));
                $session = SessionManager::getCurrentSession();
                $namauserx = $session->name;

                if ($getREG == 'RJ') {
                    // $this->db->query("SELECT TOP 1 NO_TRS_BILLING,right( REPLACE(NO_TRS_BILLING,'-','0')  ,5) as urut FROM Billing_Pasien.dbo.FO_T_BILLING  WHERE replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-')=:datenow2  ORDER BY urut DESC");
                    // $this->db->bind('datenow2', $datebill);
                    // $datax =  $this->db->single();
                    // //no urut reg
                    // $nexturut = $datax['urut'];
                    // $nexturut++;

                    // $nourutfix = Utils::generateAutoNumber($nexturut);
                    // $kodeawal = "BIL";
                    // $notrsbill = $kodeawal . $datebills . $nourutfix;

                    // $this->db->query("SELECT [Order ID] as orderid FROM [Apotik_V1.1SQL].dbo.[Order Details] WHERE [Order ID] = :dataOrderid");
                    // $this->db->bind('dataOrderid', $dataaptk);
                    // $datafo =  $this->db->single();
                    // $dataaccnumber = $datafo['orderid'];

                    // $this->db->query("SELECT COUNT(*) as FOBILLING1 FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE ID_BILL = :dataaptk AND GROUP_ENTRI = 'FARMASI'");
                    // $this->db->bind('dataaptk', $dataaptk);
                    // $datafo =  $this->db->single();
                    // $datafoo = $datafo['FOBILLING1'];

                    // if ($datafoo == "0") {
                    //get data visit

                    $this->db->query("SELECT Unit,PatientType,case when PatientType='2' then Asuransi else Perusahaan end as perusahaanid FROM PerawatanSQL.dbo.Visit  WHERE NoRegistrasi=:NoRegistrasi");
                    $this->db->bind('NoRegistrasi', $noreg);
                    $datax =  $this->db->single();
                    $IdGrupPerawatan = $datax['Unit'];
                    $JenisBayar = $datax['PatientType'];
                    $perusahaanid = $datax['perusahaanid'];
                    $datenowcreatex1 = $datenowcreatex;
                }
                //get data Inpatient
                if ($getREG == 'RI') {
                    // var_dump($datenowcreate);
                    // exit;

                    // var_dump($getREG);
                    // exit;

                    // $this->db->query("SELECT TOP 1 NO_TRS_BILLING,right( REPLACE(NO_TRS_BILLING,'-','0')  ,5) as urut FROM Billing_Pasien.dbo.FO_T_BILLING  WHERE replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-')=:datenow2a  ORDER BY urut DESC");
                    // $this->db->bind('datenow2a', $datenowcreate1);
                    // $datax =  $this->db->single();

                    // //no urut reg
                    // $nexturut = $datax['urut'];
                    // $nexturut++;

                    // $nourutfix = Utils::generateAutoNumber($nexturut);
                    // $kodeawal = "BIL";
                    // $notrsbill = $kodeawal . $datenowcreate2 . $nourutfix;

                    // $this->db->query("SELECT [Order ID] as orderid FROM [Apotik_V1.1SQL].dbo.[Order Details] WHERE [Order ID] = :dataOrderid");
                    // $this->db->bind('dataOrderid', $dataaptk);
                    // $datafo =  $this->db->single();
                    // $dataaccnumber = $datafo['orderid'];

                    // $this->db->query("SELECT COUNT(*) as FOBILLING1 FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE ID_BILL = :dataaptk AND GROUP_ENTRI = 'FARMASI'");
                    // $this->db->bind('dataaptk', $dataaptk);
                    // $datafo =  $this->db->single();
                    // $datafoo = $datafo['FOBILLING1'];

                    // if ($datafoo == "0") {
                    //get data visit

                    $this->db->query("SELECT b.ID, a.TypePatient, case when a.TypePatient='2' then a.IDAsuransi else a.IDJPK end as perusahaanid 
                        FROM RawatInapSQL.dbo.Inpatient a 
                        INNER JOIN MasterdataSQL.dbo.MstrUnitPerwatan b ON b.NamaUnit = a.JenisRawat
                        WHERE NoRegRI = :NoRegistrasi");
                    $this->db->bind('NoRegistrasi', $noreg);
                    $datax =  $this->db->single();
                    $IdGrupPerawatan = $datax['ID'];
                    $JenisBayar = $datax['TypePatient'];
                    $perusahaanid = $datax['perusahaanid'];
                    $datenowcreatex1 = $datenowcreate;
                }

                // var_dump($data);
                // exit;
                // $this->db->query("SELECT TransactionCode FROM [Apotik_V1.1SQL].dbo.Sales WHERE NoResep = :dataaptknoresep");
                // $this->db->bind('dataaptknoresep', $dataaptk);
                // $datafo =  $this->db->single();
                // $trscode = $datafo['TransactionCode'];

                // insert ke tabel FO_T_Billing
                // var_dump($notrsbill);
                // exit;
                $this->db->query("INSERT INTO Billing_Pasien.dbo.FO_T_BILLING
                    ([NO_TRS_BILLING],[TGL_BILLING],[PETUGAS_ENTRY],[NO_MR],[NO_EPISODE],[NO_REGISTRASI],[UNIT],[GROUP_JAMINAN],[KODE_JAMINAN],[TOTAL_TARIF],[TOTAL_QTY],[SUBTOTAL],[TOTAL_DISCOUNT],[TOTAL_DISCOUNT_RP],[SUBTOTAL_2],[GRANDTOTAL],[BATAL],[FB_CLOSE_KEUANGAN],[FB_VERIF_JURNAL]) 
                    VALUES
                    (:notrsbill,:datenowx,:namauserx,:NoMrfix,:NoEpisode,:nofixReg,:IdGrupPerawatan,:JenisBayar,:perusahaanid,:totaltarif,:totalqty,:subtotal,:totaldiscount,:totaldiscountrp,:subtotal2,:grandtotal,:batal,:closekeuangan,:verifkeuangan)");

                $this->db->bind('notrsbill', $trscodesales);
                // $this->db->bind('notrsbill', $notrsbill);
                $this->db->bind('datenowx', $datenowcreatex1);
                $this->db->bind('namauserx', $namauserx);
                $this->db->bind('NoMrfix', $nomr);
                $this->db->bind('NoEpisode', $noeps);
                $this->db->bind('nofixReg', $noreg);
                $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                $this->db->bind('JenisBayar', $JenisBayar);
                $this->db->bind('perusahaanid', $perusahaanid);
                $this->db->bind('totaltarif', 0);
                $this->db->bind('totalqty', 0);
                $this->db->bind('subtotal', 0);
                $this->db->bind('totaldiscount', 0);
                $this->db->bind('totaldiscountrp', 0);
                $this->db->bind('subtotal2', 0);
                $this->db->bind('grandtotal', 0);
                $this->db->bind('batal', 0);
                $this->db->bind('closekeuangan', 0);
                $this->db->bind('verifkeuangan', 0);
                $this->db->execute();

                //GET acc number
                $this->db->query("SELECT b.NoResep as ID_Detail,c.ProductCode 'Kode_Tarif', c.ProductName as Nama_Tarif, isnull(c.Qty,0) as QtyRealisasi, c.Harga, c.Discount
                FROM  [Apotik_V1.1SQL].dbo.Sales b 
                INNER JOIN [Apotik_V1.1SQL].dbo.SalesDetails c on c.TransactionCode = b.TransactionCode
                WHERE b.NoResep =:dataaptk AND c.Void = '0' AND b.TransactionCode = :trscodesales");
                $this->db->bind('dataaptk', $dataaptk);
                $this->db->bind('trscodesales', $trscodesales);

                $dataaptk_dtl =  $this->db->resultSet();
                foreach ($dataaptk_dtl as $key) {
                    if ($data['GROUP_JAMINAN'] == "1") {
                        $kekurangan = $key['QtyRealisasi'] * $key['Harga'];
                        $klaim = "0";
                        $bayar = "0";
                    } else {
                        $kekurangan = "0";
                        $klaim = $key['QtyRealisasi'] * $key['Harga'];
                        $bayar = "0";
                    }
                    // insert ke tabel FO_T_Billing_1
                    $this->db->query("INSERT INTO  Billing_Pasien.dbo.FO_T_BILLING_1
                        (ID_BILL,[NO_TRS_BILLING],[TGL_BILLING] ,[PETUGAS_ENTRY],[NO_MR],[NO_EPISODE],[NO_REGISTRASI],[KODE_TARIF],[UNIT],[GROUP_JAMINAN],[KODE_JAMINAN],
                        [NAMA_TARIF],[GROUP_TARIF],[KD_KELAS],[QTY],[NILAI_TARIF],[SUB_TOTAL],[DISC],[DISC_RP],[SUB_TOTAL_2],[GRANDTOTAL],[KODE_REF],[KD_DR],[NM_DR],
                        [BATAL],[PETUGAS_BATAL],[GROUP_ENTRI], [KEKURANGAN], [KLAIM], [BAYAR])
                        SELECT :dataaptk,:notrsbill , :datenowcreatex as datenow,:namauserx as namauserx,:nomr AS NoMR, :noeps AS xNoEpisode,:noreg as NoReg,:Rad_Kode_Tarif as kodetarif,UNIT,GROUP_JAMINAN,KODE_JAMINAN,:Rad_Nama_Tarif as namatarif,'Farmasi' as far, :kdkelas, :Qty as QTY, :Rad_Nilai as nilai, :Rad_Nilai2 as nilai2,:Discount as DISC,:Discount_RP as DISC_RP, :Rad_Nilai3 as nilai3, :Rad_Nilai4 as nilai4,:ID_Detail, :Farm_Dokter, null as namadokter, 0 as batal,null as petugasbatal,'FARMASI', :kekurangan, :klaim, :bayar
                        FROM Billing_Pasien.dbo.FO_T_BILLING
                        WHERE NO_TRS_BILLING=:notrsbill2 AND Batal='0'");
                    $this->db->bind('dataaptk', $dataaptk);
                    $this->db->bind('ID_Detail', $key['ID_Detail']);
                    // $this->db->bind('notrsbill', $notrsbill);
                    // $this->db->bind('notrsbill2', $notrsbill);
                    $this->db->bind('notrsbill', $trscodesales);
                    $this->db->bind('notrsbill2', $trscodesales);

                    $this->db->bind('datenowcreatex', $datenowcreatex1);
                    $this->db->bind('namauserx', $namauserx);
                    $this->db->bind('nomr', $nomr);
                    $this->db->bind('noeps', $noeps);
                    $this->db->bind('noreg', $noreg);
                    $this->db->bind('Rad_Kode_Tarif', $key['Kode_Tarif']);
                    $this->db->bind('Rad_Nama_Tarif', $key['Nama_Tarif']);
                    $this->db->bind('kdkelas', $kelas);
                    $this->db->bind('Qty',  $key['QtyRealisasi']);
                    $this->db->bind('Rad_Nilai',  $key['Harga']);
                    $this->db->bind('Rad_Nilai2', $key['QtyRealisasi'] * $key['Harga']);
                    $this->db->bind('Discount', $key['Discount']);
                    $this->db->bind('Discount_RP', $key['Discount'] * $key['Harga']);
                    $this->db->bind('Rad_Nilai3', ($key['Harga'] * $key['QtyRealisasi']) * (1 - $key['Discount']));
                    $this->db->bind('Rad_Nilai4', ($key['Harga'] * $key['QtyRealisasi']) * (1 - $key['Discount']));
                    $this->db->bind('Farm_Dokter', '0');
                    $this->db->bind('kekurangan', $kekurangan);
                    $this->db->bind('klaim', $klaim);
                    $this->db->bind('bayar', $bayar);
                    $this->db->execute();
                }

                //Insert ke tabel FO_T_Billing_2
                $this->db->query("INSERT INTO Billing_Pasien.DBO.FO_T_BILLING_2
                SELECT ID_BILL,A.NO_TRS_BILLING AS NO_TRS_BILLING,A1.KODE_TARIF,B.KD_TIPE_PDP as Kode_komponen,A1.UNIT AS UNIT, A1.GROUP_JAMINAN AS GROUP_JAMINAN, A1.KODE_JAMINAN AS KODE_JAMINAN, 
                A1.NAMA_TARIF AS NAMA_TARIF, 
                A1.GROUP_TARIF AS GROUP_TARIF, A1.KD_KELAS as KELAS,A1.QTY AS QTY, 
                A1.NILAI_TARIF AS NILAI_TARIF  ,
                A1.NILAI_TARIF*A1.QTY  AS SUBTOTAL,
                A1.DISC AS DISC,
                --(A1.NILAI_TARIF-((A1.NILAI_TARIF*A1.DISC)/100)) AS DISC_RP,
                (A1.NILAI_TARIF - (A1.NILAI_TARIF * (1 - A1.DISC))) AS DISC_RP,
                --((A1.NILAI_TARIF*A1.QTY)-(((A1.NILAI_TARIF*A1.QTY)*A1.DISC)/100))   SUB_TOTAL_PDP_2,
				(CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN (((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY)-(((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*A1.DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' THEN (b.NILAI_FIX*A1.QTY)-((b.NILAI_FIX*A1.QTY*A1.DISC)/100)*A1.QTY END ) as SUB_TOTAL_PDP_2,
                (CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN ((((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*A1.DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' THEN ((b.NILAI_FIX*A1.QTY*A1.DISC)/100)*A1.QTY END ) NILAI_DISKON_PDP,
                (CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN (((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY)-(((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*A1.DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' THEN (b.NILAI_FIX*A1.QTY)-((b.NILAI_FIX*A1.QTY*A1.DISC)/100)*A1.QTY END ) as NILAI_PDP,
                A1.KD_DR AS KD_DR, '' NM_DR,b.NILAI_PROSEN,'0' AS BATAL,'' PETUGAS_BATAL, '' AS JAM_BATAL, B.KD_POSTING AS KD_POSTING,'' as kd_posting_diskon, 0 as ID_TR_TARIF_PAKET
                FROM Billing_Pasien.DBO.FO_T_BILLING A
                inner join Billing_Pasien.dbo.FO_T_BILLING_1 A1
                ON A.NO_TRS_BILLING = A1.NO_TRS_BILLING
                INNER JOIN [Apotik_V1.1SQL].dbo.Products CC 
                ON CC.ID = A1.KODE_TARIF
                INNER JOIN Keuangan.DBO.BO_M_PDP2 B
                ON CC.KD_PDP collate SQL_Latin1_General_CP1_CI_AS = B.KD_PDP collate SQL_Latin1_General_CP1_CI_AS
                INNER JOIN Keuangan.DBO.BO_M_PDP CX
                ON CX.KD_PDP = B.KD_PDP
                WHERE A1.GROUP_ENTRI='FARMASI' and a.BATAL='0' and A1.BATAL='0' and B.KD_TIPE_PDP='OBT1' and a.NO_TRS_BILLING=:notrsbill2");
                // $this->db->bind('notrsbill2', $notrsbill);
                $this->db->bind('notrsbill2', $trscodesales);
                $this->db->execute();
                //UPDATE TOTAL KE FO_T_BILLING
                $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_BILLING
                    SET TOTAL_TARIF=B.SUM_NILAI_TARIF,TOTAL_QTY=B.SUM_QTY,SUBTOTAL=B.SUM_SUB_TOTAL,SUBTOTAL_2=B.SUM_SUB_TOTAL_2,GRANDTOTAL=B.SUM_GRANDTOTAL
                    FROM Billing_Pasien.DBO.FO_T_BILLING A 
                    INNER JOIN
                    (
                        SELECT  NO_TRS_BILLING,SUM(NILAI_TARIF) AS SUM_NILAI_TARIF,SUM(isnull(QTY,0)) AS SUM_QTY,SUM(SUB_TOTAL) AS SUM_SUB_TOTAL,SUM(SUB_TOTAL_2) AS SUM_SUB_TOTAL_2,
                        SUM(GRANDTOTAL) AS SUM_GRANDTOTAL
                        FROM Billing_Pasien.DBO.FO_T_BILLING_1
                        WHERE NO_REGISTRASI=:noreg and Batal='0'
                        GROUP BY NO_TRS_BILLING
                    ) B
                    ON A.NO_TRS_BILLING = B.NO_TRS_BILLING
                    WHERE A.NO_REGISTRASI=:noreg2 AND A.NO_TRS_BILLING=:notrsbill
                    ");
                $this->db->bind('noreg', $noreg);
                $this->db->bind('noreg2', $noreg);
                // $this->db->bind('notrsbill', $notrsbill);
                $this->db->bind('notrsbill', $trscodesales);

                $this->db->execute();
                //Generate
                // } else {
                //     $callback = array(
                //         'status' => "warning",
                //         'message' => "Order Sudah Ada !",
                //     );
                //     return $callback;    
                //     exit;
                // }

                // var_dump($datenowcreate);
                // exit;

                $this->db->query("INSERT INTO SysLog.dbo.TZ_Log_Button
                (noregistrasi, nama_biling, petugas_entry, tgl_entry, idtrs)
                VALUES (:NoRegRecord, 'APPROVE FARMASI', :USER_KASIRRecord, :TGL_TRSRecord, :trscoderecord)");
                $this->db->bind('NoRegRecord', $noreg);
                $this->db->bind('USER_KASIRRecord', $namauserx);
                $this->db->bind('TGL_TRSRecord', $datenowcreate);
                $this->db->bind('trscoderecord', $dataaptk);
                $this->db->execute();

                $this->db->query("DELETE SysLog.dbo.z_Notif_Kasir   
                where TransactionType = 'SALES' and PatientType='RJ' and idTransaction=:idTransaction");
                $this->db->bind('idTransaction', $dataaptk); 
                $this->db->execute();




                // var_dump($data);
                // var_dump($trscodesales);
                // exit;

            } else if ($idbtn == 'btn_btlapprove') {

                $this->db->query("SELECT TransactionCode FROM [Apotik_V1.1SQL].dbo.Sales WHERE NoRegistrasi = :noregsales AND NoResep = :noresepsales AND Void = '0'");
                $this->db->bind('noresepsales', $dataaptk);
                $this->db->bind('noregsales', $noreg);
                $data_ceksales =  $this->db->single();
                $trscodesales = $data_ceksales['TransactionCode'];

                // var_dump($data);
                // exit;
                $this->db->query("SELECT COUNT(ID) AS CEK1 FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE GROUP_ENTRI = 'FARMASI' AND ID_BILL = :dataaptk1a AND NO_TRS_BILLING = :trscodesalescek1");
                $this->db->bind('dataaptk1a', $dataaptk);
                $this->db->bind('trscodesalescek1', $trscodesales);
                $data_CEK1 =  $this->db->single();
                $CEK1 = $data_CEK1['CEK1'];

                if ($CEK1 == '0') {
                    $callback = array(
                        'status' => "error",
                        'message' => "GAGAL BATAL APPROVE, Order Ini Belum Di Approve Sebelumnya!",
                    );
                    return $callback;
                    exit;
                }

                $this->db->query("SELECT COUNT(ID) AS CEK1payment FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE GROUP_ENTRI = 'FARMASI' AND ID_BILL = :dataaptk1a AND BATAL = '0' AND NO_TRS_BILLING = :trscodesalescekpayment AND ID_TRS_Payment IS NOT NULL ");
                $this->db->bind('dataaptk1a', $dataaptk);
                $this->db->bind('trscodesalescekpayment', $trscodesales);
                $data_CEKpayment =  $this->db->single();
                $CEKpayment = $data_CEKpayment['CEK1payment'];

                if ($CEKpayment != '0') {
                    $callback = array(
                        'status' => "error",
                        'message' => "GAGAL BATAL APPROVE, Order Ini Sudah Di Payment!",
                    );
                    return $callback;
                    exit;
                }

                // $this->db->query("SELECT ID from [Apotik_V1.1SQL].dbo.[Order Details] where [Order ID]=:dataaptk1a");
                // $this->db->bind('dataaptk1a', $dataaptk);
                // $data_kodetarif =  $this->db->single();
                // $IDdetail = $data_kodetarif['ID'];


                // $query = "UPDATE [Apotik_V1.1SQL].dbo.Orders SET [Status ID]=1, TotalBayar=null, TglDikerjakanAwal=:datenowcreate, 
                // PetugasMengerjakanAwal=:namauserx WHERE [Order ID] = :iddata and [Status ID] = 2";
                // $datenowcreate = null;
                // $namauserx = null;

                // $querydtl = "UPDATE  a
                // SET a.[Status ID]=1
                // from [Apotik_V1.1SQL].dbo.[Order Details] a
                // inner join [Apotik_V1.1SQL].dbo.Orders b on a.[Order ID]=b.[Order ID]
                // WHERE a.[Order ID] = :iddata and b.[Status ID]=2";

                // $this->db->query("SELECT KODE_TARIF, NO_TRS_BILLING from Billing_Pasien.dbo.FO_T_BILLING_1 where ID_BILL = :dataaptk1 and KODE_REF = :IDdetail1a and batal = '0'");
                // $this->db->bind('dataaptk1', $dataaptk);
                // $this->db->bind('IDdetail1a', $IDdetail);
                // $data_kodetarifar =  $this->db->single();
                // $kodetrffar = $data_kodetarifar['KODE_TARIF'];
                // $trsfar = $data_kodetarifar['NO_TRS_BILLING'];
                // var_dump($noreg);
                // var_dump($trsfar);
                // exit;
                // exit;
                // $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 SET BATAL = '1' WHERE ID_BILL = :dataaptk1a --AND KODE_REF = :IDdetail1b");
                // $this->db->bind('dataaptk1a', $dataaptk);
                // // $this->db->bind('IDdetail1b', $IDdetail);
                // $this->db->execute();

                // $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_2 SET BATAL = '1' WHERE ID_BILL = :dataaptk1b --AND KODE_TARIF = :kodetrfrad1a");
                // $this->db->bind('dataaptk1b', $dataaptk);
                // // $this->db->bind('kodetrfrad1a', $kodetrfrad);
                // $this->db->execute();

                // $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING SET BATAL = '1' WHERE NO_REGISTRASI = :noregfinis AND NO_TRS_BILLING=:trsfar1");
                // $this->db->bind('noregfinis', $noreg);
                // $this->db->bind('trsfar1', $trsfar);
                // $this->db->execute();


                // $this->db->query("SELECT TransactionCode FROM [Apotik_V1.1SQL].dbo.Sales WHERE NoResep = :dataaptknoresep");
                // $this->db->bind('dataaptknoresep', $dataaptk);
                // $datafo =  $this->db->single();
                // $trscode = $datafo['TransactionCode'];

                // $this->db->query("SELECT COUNT(ID) AS CEK1 FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE GROUP_ENTRI = 'FARMASI' AND ID_BILL = :dataaptk1a");
                // $this->db->bind('dataaptk1a', $dataaptk);
                // $data_CEK1 =  $this->db->single();
                // $CEK1 = $data_CEK1['CEK1'];

                // if ($CEK1 == '0') {
                //     $callback = array(
                //         'status' => "error",
                //         'message' => "GAGAL BATAL APPROVE, Order Ini Belum Di Approve Sebelumnya!",
                //     );
                //     return $callback;
                //     exit;
                // }

                // $this->db->query("SELECT COUNT(ID) AS CEK1payment FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE GROUP_ENTRI = 'FARMASI' AND ID_BILL = :dataaptk1a AND ID_TRS_Payment IS NOT NULL ");
                // $this->db->bind('dataaptk1a', $dataaptk);
                // $data_CEKpayment =  $this->db->single();
                // $CEKpayment = $data_CEKpayment['CEK1payment'];

                // if ($CEKpayment != '0') {
                //     $callback = array(
                //         'status' => "error",
                //         'message' => "GAGAL BATAL APPROVE, Order Ini Sudah Di Payment!",
                //     );
                //     return $callback;
                //     exit;
                // }


                $this->db->query("DELETE Billing_Pasien.dbo.FO_T_BILLING_1 WHERE NO_TRS_BILLING = :trscode1 --AND KODE_REF = :IDdetail1b");
                $this->db->bind('trscode1', $trscodesales);
                // $this->db->bind('IDdetail1b', $IDdetail);
                $this->db->execute();

                $this->db->query("DELETE Billing_Pasien.dbo.FO_T_BILLING_2 WHERE NO_TRS_BILLING = :trscode2 --AND KODE_TARIF = :kodetrfrad1a");
                $this->db->bind('trscode2', $trscodesales);
                // $this->db->bind('kodetrfrad1a', $kodetrfrad);
                $this->db->execute();

                $this->db->query("DELETE Billing_Pasien.dbo.FO_T_BILLING WHERE NO_TRS_BILLING=:trscode3");
                $this->db->bind('trscode3', $trscodesales);
                $this->db->execute();



                // $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_BILLING
                //     SET TOTAL_TARIF=B.SUM_NILAI_TARIF,TOTAL_QTY=B.SUM_QTY,SUBTOTAL=B.SUM_SUB_TOTAL,SUBTOTAL_2=B.SUM_SUB_TOTAL_2,GRANDTOTAL=B.SUM_GRANDTOTAL,
                //     FB_VERIF_JURNAL='0' 
                //     FROM Billing_Pasien.DBO.FO_T_BILLING A 
                //     INNER JOIN
                //     (
                //         SELECT  NO_TRS_BILLING,SUM(NILAI_TARIF) AS SUM_NILAI_TARIF,SUM(QTY) AS SUM_QTY,SUM(SUB_TOTAL) AS SUM_SUB_TOTAL,SUM(SUB_TOTAL_2) AS SUM_SUB_TOTAL_2,
                //         SUM(GRANDTOTAL) AS SUM_GRANDTOTAL
                //         FROM Billing_Pasien.DBO.FO_T_BILLING_1
                //         WHERE NO_REGISTRASI=:noreg and Batal='0'
                //         GROUP BY NO_TRS_BILLING
                //     ) B
                //     ON A.NO_TRS_BILLING = B.NO_TRS_BILLING
                //     WHERE A.NO_REGISTRASI=:noreg2 AND A.NO_TRS_BILLING=:notrsbill
                //     ");
                // $this->db->bind('noreg', $noreg);
                // $this->db->bind('noreg2', $noreg);
                // $this->db->bind('notrsbill', $trsfar);
                // $this->db->execute();


                $this->db->query("UPDATE  [Apotik_V1.1SQL].dbo.OrderResep SET StatusResep = '1' WHERE ID = :dataaptkstatus");
                $this->db->bind('dataaptkstatus', $dataaptk);
                $this->db->execute();

                // var_dump('wait');
                // exit;

                // $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING SET BATAL = '1' WHERE NO_REGISTRASI = :noregfini and NO_TRS_BILLING=:trsfar1a");
                // $this->db->bind('noregfini', $noreg);
                // $this->db->bind('trsfar1a', $trsfar);

                $this->db->query("UPDATE SysLog.dbo.TZ_Log_Button SET petugas_batal = :USER_KASIRRecord, alasan_batal = 'BATAL APPROVE', tgl_batal = :TGL_TRSRecord
                WHERE NoRegistrasi = :NoRegRecord AND idtrs = :dataaptk1 AND petugas_batal IS NULL");
                $this->db->bind('NoRegRecord', $noreg);
                // $this->db->bind('trscoderecord', $trscode);
                $this->db->bind('USER_KASIRRecord', $namauserx);
                $this->db->bind('TGL_TRSRecord', $datenowcreate);
                $this->db->bind('dataaptk1', $dataaptk);
                $this->db->execute();
            } else {
                $callback = array(
                    'status' => "warning",
                    'errorname' => "Something Wrong !",
                );
                return $callback;
                exit;
            }

            // Update DTL
            // $this->db->query($querydtl);
            // $this->db->bind('iddata', $dataaptk);
            // $this->db->execute();

            // Update HDR
            // $this->db->query($query);
            // $this->db->bind('iddata', $dataaptk);
            // $this->db->bind('datenowcreate', $datenowcreate);
            // $this->db->bind('namauserx', $namauserx);
            // $this->db->execute();

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Simpan Berhasil',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function ApproveAll($data)
    {
        try {
            $this->db->transaksi();

            $idbtn = $data['idbtn'];

            if ($idbtn == 'cb_approvefarmasiall') {
                $query = "UPDATE [Apotik_V1.1SQL].dbo.Orders SET [Status ID]=2, TotalBayar=TotalResep, TglDikerjakanAwal=:datenowcreate, 
                PetugasMengerjakanAwal=:namauserx WHERE [Order ID] = :iddata and [Status ID] = 1";
                $datenowcreate = Utils::seCurrentDateTime();
                $session = SessionManager::getCurrentSession();
                $namauserx = $session->name;

                $querydtl = "UPDATE  a
                SET a.[Status ID]=2
                from [Apotik_V1.1SQL].dbo.[Order Details] a
                inner join [Apotik_V1.1SQL].dbo.Orders b on a.[Order ID]=b.[Order ID]
                WHERE a.[Order ID] = :iddata and b.[Status ID]=1";
            } else {
                $query = "UPDATE [Apotik_V1.1SQL].dbo.Orders SET [Status ID]=1, TotalBayar=null, TglDikerjakanAwal=:datenowcreate, 
                PetugasMengerjakanAwal=:namauserx WHERE [Order ID] = :iddata and [Status ID] = 2";
                $datenowcreate = null;
                $namauserx = null;

                $querydtl = "UPDATE  a
                 SET a.[Status ID]=1
                 from [Apotik_V1.1SQL].dbo.[Order Details] a
                 inner join [Apotik_V1.1SQL].dbo.Orders b on a.[Order ID]=b.[Order ID]
                  WHERE a.[Order ID] = :iddata and b.[Status ID]=2";
            }

            //$odid = array();
            $tod = json_decode(json_encode((object) $data['idorderapprove']), FALSE);
            foreach ($tod as $data) {
                // //Cek
                // $this->db->query("SELECT [Order ID] as odid
                // FROM [Apotik_V1.1SQL].dbo.Orders
                // WHERE ([Status ID] = 0 or [Status ID] > 2) AND ID=:idtrs");
                // $this->db->bind('iddata', $data);
                // $data =  $this->db->single();
                // if($data){
                //     $callback = array(
                //         'status' => "warning",
                //         'errorname' => "Ada Order ID yang statusnya bukan Review atau Lunas !",
                //     );
                //     return $callback; 
                //     exit;
                //     $odid[] = $data['odid'];
                // }

                // Update DTL
                $this->db->query($querydtl);
                $this->db->bind('iddata', $data);
                $this->db->execute();

                // Update HDR
                $this->db->query($query);
                $this->db->bind('iddata', $data);
                $this->db->bind('datenowcreate', $datenowcreate);
                $this->db->bind('namauserx', $namauserx);
                $this->db->execute();
            }
            //exit;

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Simpan Berhasil',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    //10/09/2024
    public function getDataApproveLabo($data)
    {
        try {

            $noreg = $data['noreg'];
            $tglawal = $data['tglawal'];
            $tglakhir = $data['tglakhir'];

            $query = "SELECT a.LabID, replace(CONVERT(VARCHAR(11), a.LabDate, 111), '/','-')  as LabDate, b.First_Name, a.NoLAB, SUBSTRING(x.nama_test,1, LEN(x.nama_test) - 1) NamaTest, a.StatusID, case when a.StatusID='0' then 'New' when a.StatusID='1' then 'Invoiced' when a.StatusID='2' then 'Payment' when a.StatusID='3' then 'Lunas' when a.StatusID='4' then 'Close' END AS StatusOrders FROM LaboratoriumSQL.dbo.tblLab a
                        INNER JOIN MasterdataSQL.dbo.Doctors b ON b.ID = a.Dokter
                        INNER JOIN MasterdataSQL.dbo.Admision c ON c.NoMR = a.NoMR
                        OUTER APPLY (
                        SELECT e.NamaTes + ', ' 
                        FROM LaboratoriumSQL.dbo.tblLabDetail d
                        INNER JOIN LaboratoriumSQL.dbo.tblGrouping e on e.IDTes = d.idTes
                        WHERE d.LabID=a.LabID AND d.Batal = '0'
                        FOR XML PATH('')
                        ) x (nama_test)
            where NoRegRI = :noreg and replace(CONVERT(VARCHAR(11), LabDate, 111), '/','-') Between :tglawal AND :tglakhir AND a.Batal = '0'";

            $this->db->query($query);
            $this->db->bind('noreg', $noreg);
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $data =  $this->db->resultSet();

            $rows = array();
            $no = 1;
            foreach ($data as $key) {

                $pasing['No'] = $no++;
                $pasing['LabID'] = $key['LabID'];
                $pasing['LabDate'] = $key['LabDate'];
                $pasing['First_Name'] = $key['First_Name'];
                $pasing['NoLAB'] = $key['NoLAB'];
                $pasing['NamaTest'] = $key['NamaTest'];
                $pasing['StatusID'] = $key['StatusID'];
                $pasing['StatusOrders'] = $key['StatusOrders'];

                $rows[] = $pasing;
            }

            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    //10/09/2024
    public function getDataApproveLabodetail($data)
    {
        try {

            $labid = $data['id'];

            $query = "SELECT a.LabDetailID, b.NamaTes, b.Tarif, a.Batal, case when a.Batal='0' then 'Aktif' when a.Batal='1' then 'Batal'  END AS StatusBatal FROM LaboratoriumSQL.dbo.tblLabDetail a
            INNER JOIN LaboratoriumSQL.dbo.tblGrouping b on a.idTes = b.IDTes WHERE LabID = :labid AND a.batal = '0'";

            $this->db->query($query);
            $this->db->bind('labid', $labid);
            $data =  $this->db->resultSet();

            $rows = array();
            $no = 1;
            foreach ($data as $key) {

                $pasing['No'] = $no++;
                $pasing['LabDetailID'] = $key['LabDetailID'];
                $pasing['NamaTes'] = $key['NamaTes'];
                $pasing['Tarif'] = $key['Tarif'];
                $pasing['Batal'] = $key['Batal'];
                $pasing['StatusBatal'] = $key['StatusBatal'];

                $rows[] = $pasing;
            }

            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function Approvelab($data)
    {
        try {
            $this->db->transaksi();

            $data = $data['data'];
            $idbtn = $_POST['idbtn'];

            if ($idbtn == 'btn_approve') {
                $query = "UPDATE [Apotik_V1.1SQL].dbo.Orders SET [Status ID]=2, TotalBayar=TotalResep, TglDikerjakanAwal=:datenowcreate, 
                PetugasMengerjakanAwal=:namauserx WHERE [Order ID] = :iddata and [Status ID] = 1";
                $datenowcreate = Utils::seCurrentDateTime();
                $session = SessionManager::getCurrentSession();
                $namauserx = $session->name;

                $querydtl = "UPDATE  a
                SET a.[Status ID]=2
                from [Apotik_V1.1SQL].dbo.[Order Details] a
                inner join [Apotik_V1.1SQL].dbo.Orders b on a.[Order ID]=b.[Order ID]
                WHERE a.[Order ID] = :iddata and b.[Status ID]=1";
            } else if ($idbtn == 'btn_btlapprove') {
                $query = "UPDATE [Apotik_V1.1SQL].dbo.Orders SET [Status ID]=1, TotalBayar=null, TglDikerjakanAwal=:datenowcreate, 
                PetugasMengerjakanAwal=:namauserx WHERE [Order ID] = :iddata and [Status ID] = 2";
                $datenowcreate = null;
                $namauserx = null;

                $querydtl = "UPDATE  a
                 SET a.[Status ID]=1
                 from [Apotik_V1.1SQL].dbo.[Order Details] a
                 inner join [Apotik_V1.1SQL].dbo.Orders b on a.[Order ID]=b.[Order ID]
                  WHERE a.[Order ID] = :iddata and b.[Status ID]=2";
            } else {
                $callback = array(
                    'status' => "warning",
                    'errorname' => "Something Wrong !",
                );
                return $callback;
                exit;
            }

            //Cek
            $this->db->query("SELECT [Order ID] as odid
                FROM [Apotik_V1.1SQL].dbo.Orders
                WHERE ([Status ID] = 0 or [Status ID] > 2) AND [Order ID]=:iddata");
            $this->db->bind('iddata', $data);
            $data_cek =  $this->db->single();
            if ($data_cek) {
                $callback = array(
                    'status' => "warning",
                    'errorname' => "Status Order Harus Review atau Lunas !",
                );
                return $callback;
                exit;
            }

            // Update DTL
            $this->db->query($querydtl);
            $this->db->bind('iddata', $data);
            $this->db->execute();

            // Update HDR
            $this->db->query($query);
            $this->db->bind('iddata', $data);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('namauserx', $namauserx);
            $this->db->execute();


            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Simpan Berhasil',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    //10/09/2024
    public function ApproveAllLab($data)
    {

        try {
            $this->db->transaksi();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $datenowx = Utils::datenowcreateNotFull();

            $datenowcreate = Utils::seCurrentDateTime();
            $datenowcreate1 = date('Y-m-d', strtotime($datenowcreate));
            $datenowcreate2 = date('dmy', strtotime($datenowcreate));
            // $session = SessionManager::getCurrentSession();
            // $namauserx = $session->name;

            $idbtn = $data['idbtn'];
            $noreg = $data['noreg'];
            // $dataaptk = $data['idorderapproveRad'];


            // $datawoid = $data['data'];
            $noeps = $data['noeps'];
            $nomr = $data['nomr'];


            $datebill = $data['datebill'];
            $datebills  = date('dmy', strtotime($datebill));
            $datenowcreatex =  $datebill . ' 00:00:00';

            $IDHDR = $data['labidx'];
            $getREG = $data['getreg'];


            $this->db->query("SELECT [Status ID] AS statuspasien FROM PerawatanSQL.dbo.visit WHERE NoRegistrasi = :norega1
            UNION ALL SELECT StatusID AS statuspasien FROM RawatInapSQL.dbo.Inpatient WHERE NoRegRI = :norega2");
            $this->db->bind('norega1', $data['noreg']);
            $this->db->bind('norega2', $data['noreg']);
            $statuscek =  $this->db->single();
            $statuspasien = $statuscek['statuspasien'];

            if ($statuspasien == '4') {
                $callback = array(
                    'status' => "error", // Set array nama
                    'message' => "Status Pasien Sudah Close"
                );
                return $callback;
                exit;
            }

            $kelas = NULL;

            if ($getREG == 'RI') {
                $this->db->query("SELECT KlsID FROM RawatInapSQL.dbo.Inpatient WHERE NoRegRI = :noregri");
                $this->db->bind('noregri', $noreg);
                $klsiddata =  $this->db->single();
                $kelas = $klsiddata['KlsID'];
            } else {
                if ($data['IDUnit'] == '1') {
                    $kelas = '2';
                } else {
                    $kelas = '3';
                }
            }

            if ($idbtn == 'cb_approveLaboall') {
                // var_dump($data);
                // exit;

                $labiddtl = implode(',', $data['idorderapprovelab']);
                $countlabiddtl = count($data['idorderapprovelab']);

                //update ke Lab
                $this->db->query("UPDATE LaboratoriumSQL.dbo.tblLab SET StatusID = '3' WHERE LabID = :labID1");
                $this->db->bind('labID1', $IDHDR);
                $this->db->execute();

                // var_dump($labID);
                // exit;

                //cek
                $this->db->query("SELECT count(lbid) as LIS from LaboratoriumSQL.dbo.LIS_Order where NoLab in ( select NoLab from LaboratoriumSQL.dbo.tblLab where LabID =:labID1a)");
                $this->db->bind('labID1a', $IDHDR);
                $data_lis =  $this->db->single();
                $LIS = $data_lis['LIS'];
                // var_dump($LIS);
                // exit;

                if ($LIS == 0) {

                    $this->db->query("UPDATE LaboratoriumSQL.dbo.tblLabDetail set Batal='1' 
                    WHERE LabDetailID not in ($labiddtl) and LabID=:labID1ax and Batal='0'");
                    $this->db->bind('labID1ax', $IDHDR);
                    $this->db->execute();

                    $this->db->query("INSERT INTO LaboratoriumSQL.dbo.LIS_Order_detail ( NoMR, NoEpisode, NoLAB, kode_test, 
                    nama_test, is_cito ,dateInput,dokterOperator ) 
                    SELECT tblLab.NoMR, tblLab.NoEpisode, tblLab.NoLAB, tblGrouping.KodeKelompok, tblGrouping.NamaTes, 
                    JenisOrder,GETDATE(),''
                    FROM LaboratoriumSQL.dbo.tblLabDetail 
                    INNER JOIN LaboratoriumSQL.dbo.tblLab ON tblLabDetail.LabID = tblLab.LabID
                    INNER JOIN LaboratoriumSQL.dbo.tblGrouping ON tblLabDetail.idTes = tblGrouping.IDTes
                    WHERE tblLabDetail.LabID=:labID1ab AND tblGrouping.KodeKelompok Is Not Null and tblLabDetail.Batal='0'
                    ORDER BY tblLab.NoLAB");
                    $this->db->bind('labID1ab', $IDHDR);
                    $this->db->execute();

                    $this->db->query("INSERT INTO LaboratoriumSQL.dbo.LIS_Order (NoMR,NoEpisode,NoRegistrasi,NoLAB ,
                    Title,pname,sex,birth_dt,Address,ptype,
                    locid,locname,clinician_id,
                    clinician_name,request_dt, user_order,diag_klinik,ketklinis,asuransi)
                    SELECT a.NoMR,a.NoEpisode,a.NoRegRI,NoLAB,'',b.PatientName
                    ,case when b.Gander='L' then 'M' else 'F' end as Gender,Date_of_birth,b.Address
                    ,case when x.PatientType='2' then 'ASURANSI'
                    when x.PatientType='5' then 'JAMINAN PERUSAHAAN'
                    else 'PRIBADI' end as Ptype,p.CODEUNIT,p.NamaUnit,a.Dokter
                    ,d.First_Name,GETDATE(),d.First_Name,a.Diagnosa,KeteranganKlinis
                    ,case when x.PatientType='2' then m.NamaPerusahaan
                    else n.NamaPerusahaan end as asuransi
                    from LaboratoriumSQL.dbo.tblLab a
                    inner join MasterdataSQL.dbo.Admision b on a.NoMR=b.NoMR
                    inner join PerawatanSQL.dbo.Visit x on a.NoRegRI=x.NoRegistrasi
                    left join MasterdataSQL.dbo.Doctors d on a.Dokter=d.ID
                    left join MasterdataSQL.dbo.MstrPerusahaanAsuransi m on x.Asuransi=m.ID
                    left join MasterdataSQL.dbo.MstrPerusahaanJPK n on x.Perusahaan=n.ID
                    left join MasterdataSQL.dbo.MstrUnitPerwatan p on x.Unit=p.ID
                    where a.LabID=:labID1aa and a.Batal='0' and x.Batal='0'
                    UNION ALL
                    select a.NoMR,a.NoEpisode,a.NoRegRI,NoLAB,'',b.PatientName
                    ,case when b.Gander='L' then 'M' else 'F' end as Gender,Date_of_birth,b.Address
                    ,case when x.TypePatient='2' then 'ASURANSI'
                    when x.TypePatient='5' then 'JAMINAN PERUSAHAAN'
                    else 'PRIBADI' end as Ptype,pp.KodeLokasi,p.RoomName,a.Dokter
                    ,d.First_Name,GETDATE(),d.First_Name,a.Diagnosa,KeteranganKlinis
                    ,case when x.TypePatient='2' then m.NamaPerusahaan
                    else n.NamaPerusahaan end as asuransi
                    from LaboratoriumSQL.dbo.tblLab a
                    inner join MasterdataSQL.dbo.Admision b on a.NoMR=b.NoMR
                    inner join RawatInapSQL.dbo.Inpatient x on a.NoRegRI=x.NoRegRI
                    left join MasterdataSQL.dbo.Doctors d on a.Dokter=d.ID
                    left join MasterdataSQL.dbo.MstrPerusahaanAsuransi m on x.IDAsuransi=m.ID
                    left join MasterdataSQL.dbo.MstrPerusahaanJPK n on x.IDJPK=n.ID
                    left join RawatInapSQL.dbo.Inpatient_in_out p on x.RoomID_Akhir=p.ID
                    left join MasterdataSQL.dbo.MstrRoomID pp on p.RoomID=pp.RoomID
                    where a.LabID=:labID1ac and a.Batal='0'");
                    $this->db->bind('labID1ac', $IDHDR);
                    $this->db->bind('labID1aa', $IDHDR);
                    $this->db->execute();
                } else {

                    //CEK JIKA SUDAH ADA HASIL
                    //cek
                    $this->db->query("SELECT st_received,NoLab from LaboratoriumSQL.dbo.LIS_Order where NoLab in ( select NoLAB from LaboratoriumSQL.dbo.tblLab where LabID=:labID1adx)");
                    $this->db->bind('labID1adx', $IDHDR);
                    $data2 =  $this->db->single();
                    $st_received = $data2['st_received'];
                    $NoLab = $data2['NoLab'];

                    $this->db->query("SELECT count(LabDetailID) as countoldlabdtl from LaboratoriumSQL.dbo.tblLabDetail where LabID=:labID1adxvd and Batal='0'");
                    $this->db->bind('labID1adxvd', $IDHDR);
                    $dataxs =  $this->db->single();
                    $countoldlabdtl = $dataxs['countoldlabdtl'];
                    // var_dump($countoldlabdtl);
                    // exit;

                    if ($st_received == true) {

                        if ($countlabiddtl <> $countoldlabdtl) {
                            $callback = array(
                                'status' => "error",
                                'message' => "Order Ini Sudah Direceive Oleh Bagian Lab, Silahkan Approve Semua Pemeriksaan !",
                            );
                            return $callback;
                            exit;
                        }
                    } else {

                        $this->db->query("UPDATE LaboratoriumSQL.dbo.tblLabDetail set Batal='1' 
                        WHERE LabDetailID not in ($labiddtl) and LabID=:labID123a and Batal='0'");
                        $this->db->bind('labID123a', $IDHDR);
                        $this->db->execute();

                        $this->db->query("UPDATE LaboratoriumSQL.dbo.LIS_Order_detail set status_ts='1'
                        where NoLab=:NoLab123b and kode_test in (
                        select kode_test from LaboratoriumSQL.dbo.tblLabDetail
                        where  LabID=:labID123b and Batal='1')");
                        $this->db->bind('labID123b', $IDHDR);
                        $this->db->bind('NoLab123b', $NoLab);
                        $this->db->execute();

                        $this->db->query("UPDATE LaboratoriumSQL.dbo.LIS_Order set 
                        is_taken='FALSE'
                        where NoLab=:NoLab123c");
                        $this->db->bind('NoLab123c', $NoLab);
                        $this->db->execute();
                    }
                    // $exec_lisdetail = null;
                    // $exec_lis = null;

                    $this->db->query("UPDATE LaboratoriumSQL.dbo.tblLab SET StatusID=3
                    WHERE LabID=:labID1f");
                    $this->db->bind('labID1f', $IDHDR);
                    $this->db->execute();
                }

                // $this->db->query("SELECT  TOP 1 NO_TRS_BILLING,right( REPLACE(NO_TRS_BILLING,'-','0')  ,5) as urut FROM Billing_Pasien.dbo.FO_T_BILLING  WHERE replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-')=:datenow2  ORDER BY urut DESC");
                // $this->db->bind('datenow2', $datebill);
                // $datax =  $this->db->single();
                // //no urut reg
                // $nexturut = $datax['urut'];
                // $nexturut++;
                // $nourutfix = Utils::generateAutoNumber($nexturut);
                // $kodeawal = "BIL";
                // $notrsbill = $kodeawal . $datebills . $nourutfix;


                // $this->db->query("SELECT NOLAB FROM LaboratoriumSQL.dbo.tblLab WHERE LabID = :dataID");
                // $this->db->bind('dataID', $IDHDR);
                // $datafo =  $this->db->single();
                // $dataLabnumber = $datafo['NOLAB'];


                // $this->db->query("SELECT COUNT(*) as FOBILLING1 FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE ID_BILL = :nolabuniq AND NO_REGISTRASI = :noregw AND GROUP_ENTRI = 'LABORATORIUM'");
                // $this->db->bind('nolabuniq', $dataLabnumber);
                // $this->db->bind('noregw', $noreg);
                // $datafo =  $this->db->single();
                // $datafoo = $datafo['FOBILLING1'];

                if ($getREG == 'RJ') {
                    $this->db->query("SELECT  TOP 1 NO_TRS_BILLING,right( REPLACE(NO_TRS_BILLING,'-','0')  ,5) as urut FROM Billing_Pasien.dbo.FO_T_BILLING  WHERE replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-')=:datenow2  ORDER BY urut DESC");
                    $this->db->bind('datenow2', $datebill);
                    $datax =  $this->db->single();
                    //no urut reg
                    $nexturut = $datax['urut'];
                    $nexturut++;
                    $nourutfix = Utils::generateAutoNumber($nexturut);
                    $kodeawal = "BIL";
                    $notrsbill = $kodeawal . $datebills . $nourutfix;


                    $this->db->query("SELECT NOLAB FROM LaboratoriumSQL.dbo.tblLab WHERE LabID = :dataID");
                    $this->db->bind('dataID', $IDHDR);
                    $datafo =  $this->db->single();
                    $dataLabnumber = $datafo['NOLAB'];


                    $this->db->query("SELECT COUNT(*) as FOBILLING1 FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE ID_BILL = :nolabuniq AND NO_REGISTRASI = :noregw AND GROUP_ENTRI = 'LABORATORIUM'");
                    $this->db->bind('nolabuniq', $dataLabnumber);
                    $this->db->bind('noregw', $noreg);
                    $datafo =  $this->db->single();
                    $datafoo = $datafo['FOBILLING1'];

                    $datenowcreatex1 = $datenowcreatex;
                }
                if ($getREG == 'RI') {
                    $this->db->query("SELECT  TOP 1 NO_TRS_BILLING,right( REPLACE(NO_TRS_BILLING,'-','0')  ,5) as urut FROM Billing_Pasien.dbo.FO_T_BILLING  WHERE replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-')=:datenow2  ORDER BY urut DESC");
                    $this->db->bind('datenow2', $datenowcreate1);
                    $datax =  $this->db->single();
                    //no urut reg
                    $nexturut = $datax['urut'];
                    $nexturut++;
                    $nourutfix = Utils::generateAutoNumber($nexturut);
                    $kodeawal = "BIL";
                    $notrsbill = $kodeawal . $datenowcreate2 . $nourutfix;


                    $this->db->query("SELECT NOLAB FROM LaboratoriumSQL.dbo.tblLab WHERE LabID = :dataID");
                    $this->db->bind('dataID', $IDHDR);
                    $datafo =  $this->db->single();
                    $dataLabnumber = $datafo['NOLAB'];


                    $this->db->query("SELECT COUNT(*) as FOBILLING1 FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE ID_BILL = :nolabuniq AND NO_REGISTRASI = :noregw AND GROUP_ENTRI = 'LABORATORIUM'");
                    $this->db->bind('nolabuniq', $dataLabnumber);
                    $this->db->bind('noregw', $noreg);
                    $datafo =  $this->db->single();
                    $datafoo = $datafo['FOBILLING1'];
                    $datenowcreatex1 = $datenowcreate;
                    // $datenowcreatex1 = $datenowcreatex;
                }

                if ($datafoo == "0") {
                    //GET Data from tabel visit

                    if ($getREG == 'RJ') {
                        $this->db->query("SELECT  Unit,PatientType,case when PatientType='2' then Asuransi else Perusahaan end as perusahaanid FROM PerawatanSQL.dbo.Visit  WHERE NoRegistrasi=:NoRegistrasi
                        ");
                        $this->db->bind('NoRegistrasi', $noreg);
                        $datax =  $this->db->single();
                        $IdGrupPerawatan = $datax['Unit'];
                        $JenisBayar = $datax['PatientType'];
                        $perusahaanid = $datax['perusahaanid'];
                    }
                    //Get Data Inpatient
                    if ($getREG == 'RI') {
                        $this->db->query("SELECT b.ID, a.TypePatient, case when a.TypePatient='2' then a.IDAsuransi else a.IDJPK end as perusahaanid 
                        FROM RawatInapSQL.dbo.Inpatient a 
                        INNER JOIN MasterdataSQL.dbo.MstrUnitPerwatan b ON b.NamaUnit = a.JenisRawat
                        WHERE NoRegRI = :NoRegistrasi");
                        $this->db->bind('NoRegistrasi', $noreg);
                        $datax =  $this->db->single();
                        $IdGrupPerawatan = $datax['ID'];
                        $JenisBayar = $datax['TypePatient'];
                        $perusahaanid = $datax['perusahaanid'];
                    }

                    // insert ke tabel FO_T_Billing
                    $this->db->query("INSERT INTO Billing_Pasien.dbo.FO_T_BILLING
                    ([NO_TRS_BILLING],[TGL_BILLING],[PETUGAS_ENTRY],[NO_MR],[NO_EPISODE],[NO_REGISTRASI],[UNIT],[GROUP_JAMINAN],[KODE_JAMINAN],[TOTAL_TARIF],[TOTAL_QTY],[SUBTOTAL],[TOTAL_DISCOUNT],[TOTAL_DISCOUNT_RP],[SUBTOTAL_2],[GRANDTOTAL],[BATAL],[FB_CLOSE_KEUANGAN],[FB_VERIF_JURNAL]) 
                    VALUES
                    (:notrsbill,:datenowx,:namauserx,:NoMrfix,:NoEpisode,:nofixReg,:IdGrupPerawatan,:JenisBayar,:perusahaanid,:totaltarif,:totalqty,:subtotal,:totaldiscount,:totaldiscountrp,:subtotal2,:grandtotal,:batal,:closekeuangan,:verifkeuangan)");

                    $this->db->bind('notrsbill', $notrsbill);
                    $this->db->bind('datenowx', $datenowcreatex1);
                    $this->db->bind('namauserx', $namauserx);
                    $this->db->bind('NoMrfix', $nomr);
                    $this->db->bind('NoEpisode', $noeps);
                    $this->db->bind('nofixReg', $noreg);
                    $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                    $this->db->bind('JenisBayar', $JenisBayar);
                    $this->db->bind('perusahaanid', $perusahaanid);
                    $this->db->bind('totaltarif', 0);
                    $this->db->bind('totalqty', 0);
                    $this->db->bind('subtotal', 0);
                    $this->db->bind('totaldiscount', 0);
                    $this->db->bind('totaldiscountrp', 0);
                    $this->db->bind('subtotal2', 0);
                    $this->db->bind('grandtotal', 0);
                    $this->db->bind('batal', 0);
                    $this->db->bind('closekeuangan', 0);
                    $this->db->bind('verifkeuangan', 0);
                    $this->db->execute();
                } else {
                    $callback = array(
                        'status' => "error",
                        'message' => "Order Ini Sudah Ditambahkan atau Sudah Di approve",
                    );
                    return $callback;
                    exit;
                }

                $this->db->query("SELECT COUNT(*) as FOBILLING1a FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE ID_BILL = :nolabuniq AND NO_REGISTRASI = :noregw AND GROUP_ENTRI = 'LABORATORIUM'");
                $this->db->bind('nolabuniq', $dataLabnumber);
                $this->db->bind('noregw', $noreg);
                // $this->db->bind('kodetestuniq', $kodetest)0;
                // $this->db->bind('labdetailuniq2', $datalabiddetail);
                $datafo1 =  $this->db->single();
                $datafoo1 = $datafo1['FOBILLING1a'];

                if ($datafoo1 == '0') {

                    // insert ke tabel FO_T_Billing_1
                    // Insert Laboratorium
                    $this->db->query("INSERT INTO Billing_Pasien.dbo.FO_T_BILLING_1
                    (ID_BILL,[NO_TRS_BILLING],[TGL_BILLING] ,[PETUGAS_ENTRY],[NO_MR],[NO_EPISODE],[NO_REGISTRASI],[KODE_TARIF],[UNIT],[GROUP_JAMINAN],[KODE_JAMINAN],[NAMA_TARIF],[GROUP_TARIF],[KD_KELAS],[QTY],[NILAI_TARIF],[SUB_TOTAL],[DISC],[DISC_RP],[SUB_TOTAL_2],[GRANDTOTAL],[KODE_REF],[KD_DR],[NM_DR],[BATAL],[PETUGAS_BATAL],[GROUP_ENTRI],
                    [BAYAR], [KLAIM], [KEKURANGAN])
                    SELECT '$dataLabnumber',NO_TRS_BILLING , '$datenowcreatex1' as datenow,'$namauserx' as namauserx,'$nomr' AS NoMR, '$noeps' AS xNoEpisode,'$noreg' as NoReg,a.idTes,
                    UNIT,c.GROUP_JAMINAN,KODE_JAMINAN, NamaTes,'Laboratorium' as lab, :kdkelas, 1 as Qty, a.TarifKelas, a.TarifKelas, ISNULL(a.disc,0), ISNULL(a.DiscountRP,0), a.Tarif, a.Tarif,a.LabDetailID, a.DokterJasa, e.First_Name, 0 as batal,null as petugasbatal,'LABORATORIUM',
                    '0', (CASE WHEN c.GROUP_JAMINAN = '1' THEN ('0') WHEN c.GROUP_JAMINAN != '1' THEN (a.Tarif) END) Nilai_Klaim, (CASE WHEN c.GROUP_JAMINAN = '1' THEN (a.Tarif) WHEN c.GROUP_JAMINAN != '1' THEN ('0') END) Nilai_KEKURANGAN
                    FROM LaboratoriumSQL.dbo.tblLabDetail a
                    INNER JOIN LaboratoriumSQL.dbo.tblLab b ON a.LabID = b.LabID
                    INNER JOIN Billing_Pasien.dbo.FO_T_BILLING c on b.NoRegRI collate SQL_Latin1_General_CP1_CI_AS=c.NO_REGISTRASI collate SQL_Latin1_General_CP1_CI_AS
                    INNER JOIN LaboratoriumSQL.dbo.tblGrouping d ON a.idTes = d.IDTes
                    LEFT JOIN MasterDataSQL.dbo.Doctors e on a.DokterJasa=e.ID
                    WHERE NoLAB=:Lab_NoLab AND d.KodeKelompok Is Not Null and c.NO_TRS_BILLING=:notrsbill and
                    a.Batal='0' and a.LabDetailID not in (SELECT KODE_REF FROM Billing_Pasien.dbo.FO_T_BILLING_1 where Batal='0' and NO_TRS_BILLING=:notrsbill2) ORDER BY b.NoLAB");
                    $this->db->bind('Lab_NoLab', $dataLabnumber);
                    $this->db->bind('kdkelas', $kelas);
                    $this->db->bind('notrsbill', $notrsbill);
                    $this->db->bind('notrsbill2', $notrsbill);
                    $this->db->execute();
                    // var_dump($dataLabnumber);
                    // exit;
                    //Insert ke tabel FO_T_Billing_2
                    $this->db->query("INSERT INTO Billing_Pasien.DBO.FO_T_BILLING_2
                    SELECT '$dataLabnumber' as ID_BILL,A.NO_TRS_BILLING AS NO_TRS_BILLING,A1.KODE_TARIF,B.KD_TIPE_PDP as Kode_komponen,A1.UNIT AS UNIT, A1.GROUP_JAMINAN AS GROUP_JAMINAN, A1.KODE_JAMINAN AS KODE_JAMINAN, 
                    A1.NAMA_TARIF AS NAMA_TARIF, 
                    A1.GROUP_TARIF AS GROUP_TARIF, A1.KD_KELAS as KELAS,A1.QTY AS QTY, 
                    A1.NILAI_TARIF AS NILAI_TARIF  ,
                    A1.NILAI_TARIF*A1.QTY  AS SUBTOTAL,
                    A1.DISC AS DISC,
                    --(A1.NILAI_TARIF-((A1.NILAI_TARIF*A1.DISC)/100)) AS DISC_RP,
					(A1.NILAI_TARIF - (A1.NILAI_TARIF * (1 - A1.DISC))) AS DISC_RP,
                    --((A1.NILAI_TARIF*A1.QTY)-(((A1.NILAI_TARIF*A1.QTY)*A1.DISC)/100))   SUB_TOTAL_PDP_2,
					(CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN (((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY)-(((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' THEN (b.NILAI_FIX*A1.QTY)-((b.NILAI_FIX*A1.QTY*DISC)/100)*A1.QTY END ) as SUB_TOTAL_PDP_2,
                    (CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN ((((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' THEN ((b.NILAI_FIX*A1.QTY*DISC)/100)*A1.QTY END ) NILAI_DISKON_PDP,
                    (CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN (((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY)-(((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' THEN (b.NILAI_FIX*A1.QTY)-((b.NILAI_FIX*A1.QTY*DISC)/100)*A1.QTY END ) as NILAI_PDP,
                    A1.KD_DR AS KD_DR, '' NM_DR,b.NILAI_PROSEN,'0' AS BATAL,'' PETUGAS_BATAL, '' AS JAM_BATAL, B.KD_POSTING AS KD_POSTING, b.KD_POSTING_DISC as kd_posting_diskon,null as ID_TR_TARIF_PAKET
                    FROM Billing_Pasien.DBO.FO_T_BILLING A
                    inner join Billing_Pasien.dbo.FO_T_BILLING_1 A1
                    ON A.NO_TRS_BILLING = A1.NO_TRS_BILLING
                    INNER JOIN LaboratoriumSQL.dbo.tblGrouping CC 
                    ON CC.IDTes = A1.KODE_TARIF
                    INNER JOIN Keuangan.DBO.BO_M_PDP2 B
                    ON CC.KD_PDP collate SQL_Latin1_General_CP1_CI_AS = B.KD_PDP collate SQL_Latin1_General_CP1_CI_AS
                    INNER JOIN Keuangan.DBO.BO_M_PDP CX
                    ON CX.KD_PDP = B.KD_PDP
                    WHERE A1.GROUP_ENTRI='LABORATORIUM' and a.BATAL='0' and A1.BATAL='0' and B.KD_TIPE_PDP='RS01' and a.NO_TRS_BILLING=:notrsbill and
                    A1.KODE_TARIF not in (select KODE_TARIF from Billing_Pasien.dbo.FO_T_BILLING_2 where NO_TRS_BILLING=:notrsbill2 and Batal='0')");
                    $this->db->bind('notrsbill', $notrsbill);
                    $this->db->bind('notrsbill2', $notrsbill);
                    $this->db->execute();
                    // var_dump($dataLabnumber);
                    // exit;

                    //UPDATE TOTAL KE FO_T_BILLING
                    $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_BILLING
                    SET TOTAL_TARIF=B.SUM_NILAI_TARIF,TOTAL_QTY=B.SUM_QTY,SUBTOTAL=B.SUM_SUB_TOTAL,SUBTOTAL_2=B.SUM_SUB_TOTAL_2,GRANDTOTAL=B.SUM_GRANDTOTAL,
                    FB_VERIF_JURNAL='0' 
                    FROM Billing_Pasien.DBO.FO_T_BILLING A 
                    INNER JOIN
                    (
                        SELECT  NO_TRS_BILLING,SUM(NILAI_TARIF) AS SUM_NILAI_TARIF,SUM(QTY) AS SUM_QTY,SUM(SUB_TOTAL) AS SUM_SUB_TOTAL,SUM(SUB_TOTAL_2) AS SUM_SUB_TOTAL_2,
                        SUM(GRANDTOTAL) AS SUM_GRANDTOTAL
                        FROM Billing_Pasien.DBO.FO_T_BILLING_1
                        WHERE NO_REGISTRASI=:noreg and Batal='0'
                        GROUP BY NO_TRS_BILLING
                    ) B
                    ON A.NO_TRS_BILLING = B.NO_TRS_BILLING
                    WHERE A.NO_REGISTRASI=:noreg2 AND A.NO_TRS_BILLING=:notrsbill
                    ");
                    $this->db->bind('noreg', $noreg);
                    $this->db->bind('noreg2', $noreg);
                    $this->db->bind('notrsbill', $notrsbill);
                    $this->db->execute();
                } else {
                    $callback = array(
                        'status' => "warning",
                        'message' => "Order Ini Sudah Ditambahkan atau Sudah Di approvex",
                    );
                    return $callback;
                    exit;
                }

                // var_dump('ita');
                // exit;
                //update di visit nya
                //if noregis == rj
                if ($getREG == 'RJ') {
                    $this->db->query("UPDATE PerawatanSQL.dbo.Visit SET LabLunas=1 WHERE NoRegistrasi = :noregvisit1");
                    $this->db->bind('noregvisit1', $noreg);
                    $this->db->execute();
                } elseif ($getREG == 'RI') {
                    $this->db->query("UPDATE RawatInapSQL.dbo.Inpatient SET LabFlag=1 WHERE NoRegRI = :noregvisit1");
                    $this->db->bind('noregvisit1', $noreg);
                    $this->db->execute();
                }

                $this->db->query("INSERT INTO SysLog.dbo.TZ_Log_Button
                (noregistrasi, nama_biling, petugas_entry, tgl_entry, idtrs)
                VALUES (:NoRegRecord, 'APPROVE LAB', :USER_KASIRRecord, :TGL_TRSRecord, :trscoderecord)");
                $this->db->bind('NoRegRecord', $noreg);
                $this->db->bind('USER_KASIRRecord', $namauserx);
                $this->db->bind('TGL_TRSRecord', $datenowcreate);
                $this->db->bind('trscoderecord', $IDHDR);
                $this->db->execute();
            } else if ($idbtn == 'cb_btlapproveLaboall') {

                //$odid = array();
                $tod = json_decode(json_encode((object) $data['idorderapprovelab']), FALSE);
                foreach ($tod as $datalabdetail) {


                    $this->db->query("SELECT ID_TRS_Payment FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE KODE_REF = :KDREFF1A AND GROUP_ENTRI = 'LABORATORIUM'");
                    $this->db->bind('KDREFF1A', $datalabdetail);
                    $datastrspaymentcek =  $this->db->single();
                    $ID_TRS_Payment = $datastrspaymentcek['ID_TRS_Payment'];

                    if ($ID_TRS_Payment != NULL) {
                        $callback = array(
                            'status' => 'error',
                            'message' => 'Gagal menghapus orderan, Karena orderan sudah di payment!',
                        );
                        return $callback;
                        exit;
                    }

                    $this->db->query("SELECT a.NoLAB, b.kode_test, a.LabID FROM LaboratoriumSQL.dbo.tblLab a
                    INNER JOIN LaboratoriumSQL.dbo.tblLabDetail b on b.LabID = a.LabID
                    WHERE b.LabDetailID= :datalabdetail1");
                    $this->db->bind('datalabdetail1', $datalabdetail);
                    $data_bylabdetail =  $this->db->single();
                    $noLab = $data_bylabdetail['NoLAB'];
                    $kodetes = $data_bylabdetail['kode_test'];
                    $labidd = $data_bylabdetail['LabID'];


                    $this->db->query("SELECT st_received FROM LaboratoriumSQL.dbo.LIS_Order_detail where NoLab = :noLab1a AND kode_test = :kodetes1a");
                    $this->db->bind('kodetes1a', $kodetes);
                    $this->db->bind('noLab1a', $noLab);
                    $data_received =  $this->db->single();
                    $received = $data_received['st_received'];

                    if ($received <> '1') {
                        $this->db->query("UPDATE LaboratoriumSQL.dbo.LIS_Order_detail SET status_ts = '1' WHERE NoLab = :noLab1b AND kode_test = :kodetes1b");
                        $this->db->bind('noLab1b', $noLab);
                        $this->db->bind('kodetes1b', $kodetes);
                        $this->db->execute();

                        $this->db->query("UPDATE LaboratoriumSQL.dbo.LIS_Order SET is_taken = 'FALSE' WHERE NoLab = :noLab1c");
                        $this->db->bind('noLab1c', $noLab);
                        $this->db->execute();

                        $this->db->query("UPDATE LaboratoriumSQL.dbo.tblLabDetail SET Batal = '1' WHERE LabDetailID = :datalabdetail1c");
                        $this->db->bind('datalabdetail1c', $datalabdetail);
                        $this->db->execute();

                        $this->db->query("UPDATE PerawatanSQL.dbo.Visit SET LabLunas=0
                        WHERE NoRegistrasi = :noregvisit2a");
                        $this->db->bind('noregvisit2a', $noreg);
                        $this->db->execute();

                        $this->db->query("SELECT KODE_TARIF, NO_TRS_BILLING from Billing_Pasien.dbo.FO_T_BILLING_1 where ID_BILL = :noLabf and KODE_REF = :datalabdetaila");
                        $this->db->bind('noLabf', $noLab);
                        $this->db->bind('datalabdetaila', $datalabdetail);
                        $data_kodetarif =  $this->db->single();
                        $kodetrf = $data_kodetarif['KODE_TARIF'];
                        $trs = $data_kodetarif['NO_TRS_BILLING'];
                        // exit;
                        $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 SET BATAL = '1' WHERE ID_BILL = :noLab12 AND KODE_REF = :datalabdetail12");
                        $this->db->bind('noLab12', $noLab);
                        $this->db->bind('datalabdetail12', $datalabdetail);
                        $this->db->execute();

                        $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_2 SET BATAL = '1' WHERE ID_BILL = :noLab13 AND KODE_TARIF = :kodetrf3");
                        $this->db->bind('noLab13', $noLab);
                        $this->db->bind('kodetrf3', $kodetrf);
                        $this->db->execute();

                        $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_BILLING
                        SET TOTAL_TARIF=B.SUM_NILAI_TARIF,TOTAL_QTY=B.SUM_QTY,SUBTOTAL=B.SUM_SUB_TOTAL,SUBTOTAL_2=B.SUM_SUB_TOTAL_2,GRANDTOTAL=B.SUM_GRANDTOTAL,
                        FB_VERIF_JURNAL='0' 
                        FROM Billing_Pasien.DBO.FO_T_BILLING A 
                        INNER JOIN
                        (
                            SELECT  NO_TRS_BILLING,SUM(NILAI_TARIF) AS SUM_NILAI_TARIF,SUM(QTY) AS SUM_QTY,SUM(SUB_TOTAL) AS SUM_SUB_TOTAL,SUM(SUB_TOTAL_2) AS SUM_SUB_TOTAL_2,
                            SUM(GRANDTOTAL) AS SUM_GRANDTOTAL
                            FROM Billing_Pasien.DBO.FO_T_BILLING_1
                            WHERE NO_REGISTRASI=:noreg and Batal='0'
                            GROUP BY NO_TRS_BILLING
                        ) B
                        ON A.NO_TRS_BILLING = B.NO_TRS_BILLING
                        WHERE A.NO_REGISTRASI=:noreg2 AND A.NO_TRS_BILLING=:notrsbill
                        ");
                        $this->db->bind('noreg', $noreg);
                        $this->db->bind('noreg2', $noreg);
                        $this->db->bind('notrsbill', $trs);
                        $this->db->execute();
                    } elseif ($received == '0') {
                        $callback = array(
                            'status' => "error",
                            'message' => "Order Sudah ditindak lanjut lab !",
                        );
                        return $callback;
                        exit;
                    }
                }

                $this->db->query("SELECT COUNT(*) as jml_LIS FROM LaboratoriumSQL.dbo.LIS_Order_detail WHERE NoLab = :noLab21 AND status_ts = '0'");
                $this->db->bind('noLab21', $noLab);
                $data_cekjmlstreceiv =  $this->db->single();
                $jmlLIS = $data_cekjmlstreceiv['jml_LIS'];

                $this->db->query("SELECT COUNT(*) as jml_BTL_DETAIL FROM LaboratoriumSQL.dbo.tblLabDetail WHERE LabID = :labidda AND Batal = '0'");
                $this->db->bind('labidda', $labidd);
                $data_cekjmlbtl =  $this->db->single();
                $jmlbtldetaillab = $data_cekjmlbtl['jml_BTL_DETAIL'];
                // var_dump($labidd);
                // exit;
                if ($jmlLIS == '0' and $jmlbtldetaillab == '0') {
                    $this->db->query("UPDATE LaboratoriumSQL.dbo.LIS_Order SET is_taken = 'FALSE', status_ts = '2' where NoLab = :noLablis");
                    $this->db->bind('noLablis', $noLab);
                    $this->db->execute();

                    $this->db->query("UPDATE LaboratoriumSQL.dbo.tblLab SET Batal = '1' where NoLab = :noLabtbllab");
                    $this->db->bind('noLabtbllab', $noLab);
                    $this->db->execute();
                }
                $this->db->query("SELECT COUNT(*) as jml_btl_bill1 FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE ID_BILL = :noLab21a AND BATAL = '0'");
                $this->db->bind('noLab21a', $noLab);
                $data_btlbill =  $this->db->single();
                $jmlbtlb = $data_btlbill['jml_btl_bill1'];

                if ($jmlbtlb == '0') {
                    $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING SET BATAL = '1' WHERE NO_REGISTRASI = :noregfini and NO_TRS_BILLING=:trs1");
                    $this->db->bind('noregfini', $noreg);
                    $this->db->bind('trs1', $trs);

                    $this->db->execute();
                }

                $this->db->query("UPDATE SysLog.dbo.TZ_Log_Button SET petugas_batal = :USER_KASIRRecord, alasan_batal = 'BATAL APPROVE', tgl_batal = :TGL_TRSRecord
                WHERE NoRegistrasi = :NoRegRecord AND idtrs = :dataaptk1 AND petugas_batal IS NULL");
                $this->db->bind('NoRegRecord', $noreg);
                // $this->db->bind('trscoderecord', $trscode);
                $this->db->bind('USER_KASIRRecord', $namauserx);
                $this->db->bind('TGL_TRSRecord', $datenowcreate);
                $this->db->bind('dataaptk1', $IDHDR);
                $this->db->execute();
            } else {
                $callback = array(
                    'status' => "error",
                    'message' => "Something Wrong !",
                );
                return $callback;
                exit;
            }

            $this->db->commit();
            $callback = array(
                'status' => "success",
                'message' => "Berhasil Melakukan Transaksi", // Set array nama 
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    //10/09/2024

    public function sumAllTarif($data)
    {
        try {

            $idfo1x = implode(',', $data['cb_tarifall']);
            $idfo1 = str_replace(",", "','", $idfo1x);
            $this->db->query("SELECT cast(cast(sum(SUB_TOTAL_2) AS int) AS varchar(10)) AS SUBTOTAL2 FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE ID in ('$idfo1')");
            $datax1 =  $this->db->single();
            $SUBTOTAL2 = $datax1['SUBTOTAL2'];

            return $SUBTOTAL2;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataApproveBDRS($data)
    {
        try {

            $noreg = $data['noreg'];
            $tglawal = $data['tglawal'];
            $tglakhir = $data['tglakhir'];

            $query = "SELECT a.ID, replace(CONVERT(VARCHAR(11), a.DateOrder , 111), '/','-') as DateOrder, a.UserOrderName, SUBSTRING(b.NamaTarifDarah,1, LEN(b.NamaTarifDarah) - 1) NamaTarifDarah, a.Keterangan, StatusOrder, CASE WHEN ReviewQtyOrder='0' AND StatusOrder='0' THEN 'New' 
            WHEN ReviewQtyOrder='1' AND StatusOrder='0' THEN 'Reviewed' 
            WHEN StatusOrder = '1' THEN 'Approved'
            ELSE 'UNKOWN'
            END AS Status_Order 
            FROM LaboratoriumSQL.dbo.OrderBloods a
           -- INNER JOIN LaboratoriumSQL.dbo.OrderBloodDetails x ON x.IDHdr = a.ID
            OUTER APPLY (
                        SELECT b.NamaTarifDarah + ', ' 
                        FROM LaboratoriumSQL.dbo.OrderBloodDetails b
                        WHERE b.IDHdr=a.ID AND b.Batal = '0'
                        FOR XML PATH('')
                        ) b (NamaTarifDarah)
            WHERE a.NoRegistrasi = :noreg AND a.Batal = '0' AND replace(CONVERT(VARCHAR(11), DateOrder, 111), '/','-') Between :tglawal AND :tglakhir";

            $this->db->query($query);
            $this->db->bind('noreg', $noreg);
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $data =  $this->db->resultSet();
            // var_dump($data);
            // exit;
            $rows = array();
            $no = 1;
            foreach ($data as $key) {

                $pasing['No'] = $no++;
                $pasing['ID'] = $key['ID'];
                $pasing['DateOrder'] = $key['DateOrder'];
                $pasing['UserOrderName'] = $key['UserOrderName'];
                $pasing['NamaTarifDarah'] = $key['NamaTarifDarah'];
                $pasing['Keterangan'] = $key['Keterangan'];
                // $pasing['Total'] = $key['Total'];
                $pasing['StatusOrder'] = $key['StatusOrder'];
                // $pasing['ReviewQtyOrder'] = $key['ReviewQtyOrder'];
                $pasing['Status_Order'] = $key['Status_Order'];

                $rows[] = $pasing;
            }

            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDataApproveBDRSdetail($data)
    {
        try {

            $ID = $data['id'];

            $query = "SELECT ID AS iddetail,NamaTarifDarah, Harga, Batal, case when Batal='0' then 'Aktif' when Batal='1' then 'Batal' END AS Batal FROM LaboratoriumSQL.dbo.OrderBloodDetails WHERE IDHdr = :IDx";

            $this->db->query($query);
            $this->db->bind('IDx', $ID);
            $data =  $this->db->resultSet();

            $rows = array();
            $no = 1;
            foreach ($data as $key) {

                $pasing['No'] = $no++;
                $pasing['iddetail'] = $key['iddetail'];
                $pasing['NamaTarifDarah'] = $key['NamaTarifDarah'];
                $pasing['Harga'] = $key['Harga'];
                $pasing['Batal'] = $key['Batal'];
                // $pasing['StatusBatal'] = $key['StatusBatal'];

                $rows[] = $pasing;
            }

            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function ApproveAllBDRS($data)
    {
        try {

            $this->db->transaksi();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $datenowx = Utils::datenowcreateNotFull();

            $datenowcreate = Utils::seCurrentDateTime();

            $dataBDRSid = $data['idorderapproveBDRS'];
            $idbtn = $data['idbtn'];
            $noreg = $data['noreg'];
            $noeps = $data['noeps'];
            $nomr = $data['nomr'];
            $datahdr = $data['idX'];
            $getREG = $data['getreg'];

            $datebill = $data['datebill'];
            $datebills  = date('dmy', strtotime($datebill));
            $datenowcreatex =  $datebill . ' 00:00:00';


            // $datenowcreate = Utils::seCurrentDateTime();
            $datenowcreate1 = date('Y-m-d', strtotime($datenowcreate));
            $datenowcreate2 = date('dmy', strtotime($datenowcreate));
            // $session = SessionManager::getCurrentSession();
            // $namauserx = $session->name;


            $orderbloodsiddtl = implode(',', $data['idorderapproveBDRS']);

            //cek status close
            $this->db->query("SELECT [Status ID] AS statuspasien FROM PerawatanSQL.dbo.visit WHERE NoRegistrasi = :norega1
             UNION ALL SELECT StatusID AS statuspasien FROM RawatInapSQL.dbo.Inpatient WHERE NoRegRI = :norega2");
            $this->db->bind('norega1', $data['noreg']);
            $this->db->bind('norega2', $data['noreg']);
            $statuscek =  $this->db->single();
            $statuspasien = $statuscek['statuspasien'];

            if ($statuspasien == '4') {
                $callback = array(
                    'status' => "warning", // Set array nama
                    'message' => "Gagal Approve, Status Pasien Sudah Close"
                );
                return $callback;
                exit;
            }

            if ($idbtn == 'cb_approveBDRSall') {
                // var_dump($datahdr, 'approve');
                // exit;

                $kelas = NULL;
                if ($getREG == 'RI') {
                    $this->db->query("SELECT KlsID FROM RawatInapSQL.dbo.Inpatient WHERE NoRegRI = :noregri");
                    $this->db->bind('noregri', $noreg);
                    $klsiddata =  $this->db->single();
                    $kelas = $klsiddata['KlsID'];
                } else {
                    if ($data['IDUnit'] == '1') {
                        $kelas = '2';
                    } else {
                        $kelas = '3';
                    }
                }

                $this->db->query("SELECT a.ID,b.ReviewQtyOrder FROM LaboratoriumSQL.dbo.OrderBloods b
                left join LaboratoriumSQL.dbo.UseBloods a on b.ID=a.IDOrder and a.Batal='0'
                where b.ID=:datahdr and  b.Batal='0'");
                $this->db->bind('datahdr', $datahdr);
                $datax1 =  $this->db->single();
                $cekUseID = $datax1['ID'];
                $ReviewQtyOrder = $datax1['ReviewQtyOrder'];

                if ($ReviewQtyOrder == 0) {
                    $callback = array(
                        'status' => 'warning',
                        'message' => 'Orderan Darah Ini Belum Direview Oleh Bagian Bank Darah !',
                    );
                    echo json_encode($callback);
                    exit;
                }

                if ($cekUseID != null) {
                    $callback = array(
                        'status' => 'warning',
                        'message' => 'Bank Darah Ini Sudah Dalam Pemakaian ! Mohon Konfirmasi Kembali ke Bagian Bank Darah !',
                    );
                    echo json_encode($callback);
                    exit;
                }

                //update ORDER BLOODS
                $this->db->query("UPDATE LaboratoriumSQL.dbo.OrderBloods SET StatusOrder=1,DateApproveKasir='$datenowcreatex',PetugasApproveKasir='$namauserx'
                WHERE ID=:datahdrx1");
                $this->db->bind('datahdrx1', $datahdr);
                $this->db->execute();

                //update ORDER BATAL
                $this->db->query("UPDATE LaboratoriumSQL.dbo.OrderBloodDetails SET Batal='1', DateBatal = '$datenowcreatex', PetugasBatal = '$namauserx' WHERE ID NOT IN ($orderbloodsiddtl) AND IDHdr = :datahdrx2 AND Batal='0'");
                $this->db->bind('datahdrx2', $datahdr);
                $this->db->execute();

                if ($getREG == 'RJ') {

                    $this->db->query("SELECT  TOP 1 NO_TRS_BILLING,right( REPLACE(NO_TRS_BILLING,'-','0')  ,5) as urut FROM Billing_Pasien.dbo.FO_T_BILLING  WHERE replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-')=:datenow2  ORDER BY urut DESC");
                    $this->db->bind('datenow2', $datebill);
                    $datax =  $this->db->single();
                    //no urut reg
                    $nexturut = $datax['urut'];
                    $nexturut++;
                    $nourutfix = Utils::generateAutoNumber($nexturut);
                    $kodeawal = "BIL";
                    $notrsbill = $kodeawal . $datebills . $nourutfix;

                    $this->db->query("SELECT COUNT(*) as FOBILLING1 FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE ID_BILL = :datahdrx3 AND NO_REGISTRASI = :noregx3 AND GROUP_ENTRI = 'BANKDARAH'");
                    $this->db->bind('datahdrx3', $datahdr);
                    $this->db->bind('noregx3', $noreg);
                    $datafo =  $this->db->single();
                    $datafoo = $datafo['FOBILLING1'];

                    $datenowcreatex1 = $datenowcreatex;
                }
                if ($getREG == 'RI') {
                    $this->db->query("SELECT  TOP 1 NO_TRS_BILLING,right( REPLACE(NO_TRS_BILLING,'-','0')  ,5) as urut FROM Billing_Pasien.dbo.FO_T_BILLING  WHERE replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-')=:datenow2  ORDER BY urut DESC");
                    $this->db->bind('datenow2', $datenowcreate1);
                    $datax =  $this->db->single();
                    //no urut reg
                    $nexturut = $datax['urut'];
                    $nexturut++;
                    $nourutfix = Utils::generateAutoNumber($nexturut);
                    $kodeawal = "BIL";
                    $notrsbill = $kodeawal . $datenowcreate2 . $nourutfix;

                    $this->db->query("SELECT COUNT(*) as FOBILLING1 FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE ID_BILL = :datahdrx3 AND NO_REGISTRASI = :noregx3 AND GROUP_ENTRI = 'BANKDARAH'");
                    $this->db->bind('datahdrx3', $datahdr);
                    $this->db->bind('noregx3', $noreg);
                    $datafo =  $this->db->single();
                    $datafoo = $datafo['FOBILLING1'];

                    $datenowcreatex1 = $datenowcreate;
                    // $datenowcreatex1 = $datenowcreatex;
                }

                if ($datafoo == '0') {
                    //GET data Visit
                    if ($getREG == 'RJ') {
                        $this->db->query("SELECT  Unit,PatientType,case when PatientType='2' then Asuransi else Perusahaan end as perusahaanid FROM PerawatanSQL.dbo.Visit  WHERE NoRegistrasi=:NoRegistrasi
                        ");
                        $this->db->bind('NoRegistrasi', $noreg);
                        $datax =  $this->db->single();
                        $IdGrupPerawatan = $datax['Unit'];
                        $JenisBayar = $datax['PatientType'];
                        $perusahaanid = $datax['perusahaanid'];
                    }
                    //GET data Inpatient
                    if ($getREG == 'RI') {
                        $this->db->query("SELECT b.ID, a.TypePatient, case when a.TypePatient='2' then a.IDAsuransi else a.IDJPK end as perusahaanid 
                        FROM RawatInapSQL.dbo.Inpatient a 
                        INNER JOIN MasterdataSQL.dbo.MstrUnitPerwatan b ON b.NamaUnit = a.JenisRawat
                        WHERE NoRegRI = :NoRegistrasi");
                        $this->db->bind('NoRegistrasi', $noreg);
                        $datax =  $this->db->single();
                        $IdGrupPerawatan = $datax['ID'];
                        $JenisBayar = $datax['TypePatient'];
                        $perusahaanid = $datax['perusahaanid'];
                    }

                    // insert ke tabel FO_T_Billing
                    $this->db->query("INSERT INTO Billing_Pasien.dbo.FO_T_BILLING
                    ([NO_TRS_BILLING],[TGL_BILLING],[PETUGAS_ENTRY],[NO_MR],[NO_EPISODE],[NO_REGISTRASI],[UNIT],[GROUP_JAMINAN],[KODE_JAMINAN],[TOTAL_TARIF],[TOTAL_QTY],[SUBTOTAL],[TOTAL_DISCOUNT],[TOTAL_DISCOUNT_RP],[SUBTOTAL_2],[GRANDTOTAL],[BATAL],[FB_CLOSE_KEUANGAN],[FB_VERIF_JURNAL]) 
                    VALUES
                    (:notrsbill,:datenowx,:namauserx,:NoMrfix,:NoEpisode,:nofixReg,:IdGrupPerawatan,:JenisBayar,:perusahaanid,:totaltarif,:totalqty,:subtotal,:totaldiscount,:totaldiscountrp,:subtotal2,:grandtotal,:batal,:closekeuangan,:verifkeuangan)");

                    $this->db->bind('notrsbill', $notrsbill);
                    $this->db->bind('datenowx', $datenowcreatex1);
                    $this->db->bind('namauserx', $namauserx);
                    $this->db->bind('NoMrfix', $nomr);
                    $this->db->bind('NoEpisode', $noeps);
                    $this->db->bind('nofixReg', $noreg);
                    $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                    $this->db->bind('JenisBayar', $JenisBayar);
                    $this->db->bind('perusahaanid', $perusahaanid);
                    $this->db->bind('totaltarif', 0);
                    $this->db->bind('totalqty', 0);
                    $this->db->bind('subtotal', 0);
                    $this->db->bind('totaldiscount', 0);
                    $this->db->bind('totaldiscountrp', 0);
                    $this->db->bind('subtotal2', 0);
                    $this->db->bind('grandtotal', 0);
                    $this->db->bind('batal', 0);
                    $this->db->bind('closekeuangan', 0);
                    $this->db->bind('verifkeuangan', 0);
                    $this->db->execute();
                } else {
                    $callback = array(
                        'status' => "warning",
                        'message' => "Order Ini Sudah Ditambahkan atau Sudah Di approve",
                    );
                    return $callback;
                    exit;
                }

                $this->db->query("SELECT COUNT(*) as FOBILLING1a FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE ID_BILL = :datahdrx4 AND NO_REGISTRASI = :noregx4 AND GROUP_ENTRI = 'BANKDARAH'");
                $this->db->bind('datahdrx4', $datahdr);
                $this->db->bind('noregx4', $noreg);
                $datafo1 =  $this->db->single();
                $datafoo1 = $datafo1['FOBILLING1a'];

                if ($datafoo1 == '0') {

                    // insert ke tabel FO_T_Billing_1
                    // Insert Laboratorium
                    $this->db->query("INSERT INTO  Billing_Pasien.dbo.FO_T_BILLING_1
                    (ID_BILL,[NO_TRS_BILLING],[TGL_BILLING] ,[PETUGAS_ENTRY],[NO_MR],[NO_EPISODE],[NO_REGISTRASI],[KODE_TARIF],[UNIT],[GROUP_JAMINAN],[KODE_JAMINAN],[NAMA_TARIF],
                    [GROUP_TARIF],[KD_KELAS],[QTY],[NILAI_TARIF],[SUB_TOTAL],[DISC],[DISC_RP],[SUB_TOTAL_2],[GRANDTOTAL],[KODE_REF],[KD_DR],[NM_DR],[BATAL],[PETUGAS_BATAL],[GROUP_ENTRI],[BAYAR],[KLAIM],[KEKURANGAN])
                    SELECT '$datahdr',NO_TRS_BILLING , '$datenowcreatex1' as datenow,'$namauserx' as namauserx,'$nomr' AS NoMR, '$noeps' AS xNoEpisode,'$noreg' as NoReg,a.IdTarifDarah,
                    UNIT,c.GROUP_JAMINAN,KODE_JAMINAN, a.NamaTarifDarah,'BankDarah' as BankDarah, :kdkelas, QtyOrder as Qty, a.Harga, a.Total,0, 0, a.Total, a.Total,a.ID, b.DPJP, b.DPJPName, 0 as batal,null as petugasbatal,'BANKDARAH',
                    '0',(CASE WHEN c.GROUP_JAMINAN = '1' THEN ('0') WHEN c.GROUP_JAMINAN != '1' THEN (a.Harga * a.QtyOrder) END) Nilai_Klaim, (CASE WHEN c.GROUP_JAMINAN = '1' THEN (a.Harga * a.QtyOrder) WHEN c.GROUP_JAMINAN != '1' THEN ('0') END) Nilai_KEKURANGAN
                    FROM LaboratoriumSQL.dbo.OrderBloodDetails a
                    INNER JOIN LaboratoriumSQL.dbo.OrderBloods b ON a.IDHdr = b.ID
                    INNER JOIN Billing_Pasien.dbo.FO_T_BILLING c on b.NoRegistrasi collate SQL_Latin1_General_CP1_CI_AS=c.NO_REGISTRASI collate SQL_Latin1_General_CP1_CI_AS
                    Where a.IDHdr = :idhdrx5 AND a.Batal = '0' AND  c.NO_TRS_BILLING=:notrsbill AND  a.IdTarifDarah not in (SELECT KODE_REF FROM Billing_Pasien.dbo.FO_T_BILLING_1 where Batal='0' and NO_TRS_BILLING=:notrsbill2)
                    ORDER BY b.ID
                    ");
                    $this->db->bind('idhdrx5', $datahdr);
                    $this->db->bind('kdkelas', $kelas);
                    $this->db->bind('notrsbill', $notrsbill);
                    $this->db->bind('notrsbill2', $notrsbill);
                    $this->db->execute();

                    $this->db->query("INSERT INTO Billing_Pasien.DBO.FO_T_BILLING_2
                    SELECT '$datahdr' as ID_BILL,A.NO_TRS_BILLING AS NO_TRS_BILLING,A1.KODE_TARIF,B.KD_TIPE_PDP as Kode_komponen,A1.UNIT AS UNIT, A1.GROUP_JAMINAN AS GROUP_JAMINAN, A1.KODE_JAMINAN AS KODE_JAMINAN, 
                    A1.NAMA_TARIF AS NAMA_TARIF, 
                    A1.GROUP_TARIF AS GROUP_TARIF, A1.KD_KELAS as KELAS,A1.QTY AS QTY, 
                    A1.NILAI_TARIF AS NILAI_TARIF  ,
                    A1.NILAI_TARIF*A1.QTY  AS SUBTOTAL,
                    A1.DISC AS DISC,
                    --(A1.NILAI_TARIF-((A1.NILAI_TARIF*A1.DISC)/100)) AS DISC_RP,
					(A1.NILAI_TARIF - (A1.NILAI_TARIF * (1 - A1.DISC))) AS DISC_RP,
					--((A1.NILAI_TARIF*A1.QTY)-(((A1.NILAI_TARIF*A1.QTY)*A1.DISC)/100))   SUB_TOTAL_PDP_2,
					(CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN (((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY)-(((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' THEN (b.NILAI_FIX*A1.QTY)-((b.NILAI_FIX*A1.QTY*DISC)/100)*A1.QTY END ) as SUB_TOTAL_PDP_2,
                    (CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN ((((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' THEN ((b.NILAI_FIX*A1.QTY*DISC)/100)*A1.QTY END ) NILAI_DISKON_PDP,
                    (CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN (((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY)-(((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' THEN (b.NILAI_FIX*A1.QTY)-((b.NILAI_FIX*A1.QTY*DISC)/100)*A1.QTY END ) as NILAI_PDP,
                    A1.KD_DR AS KD_DR, '' NM_DR,b.NILAI_PROSEN,'0' AS BATAL,'' PETUGAS_BATAL, '' AS JAM_BATAL, B.KD_POSTING AS KD_POSTING, b.KD_POSTING_DISC as kd_posting_diskon, null as ID_TR_TARIF_PAKET
                    FROM Billing_Pasien.DBO.FO_T_BILLING A
                    inner join Billing_Pasien.dbo.FO_T_BILLING_1 A1
                    ON A.NO_TRS_BILLING = A1.NO_TRS_BILLING
                    INNER JOIN LaboratoriumSQL.dbo.MasterBloodBanks CC 
                    ON CC.ID = A1.KODE_TARIF
                    INNER JOIN Keuangan.DBO.BO_M_PDP2 B
                    ON CC.KD_PDP collate SQL_Latin1_General_CP1_CI_AS = B.KD_PDP collate SQL_Latin1_General_CP1_CI_AS
                    INNER JOIN Keuangan.DBO.BO_M_PDP CX
                    ON CX.KD_PDP = B.KD_PDP
                    WHERE A1.GROUP_ENTRI='BANKDARAH' and a.BATAL='0' and A1.BATAL='0' and B.KD_TIPE_PDP='RS01' and a.NO_TRS_BILLING=:notrsbill and
                    A1.KODE_TARIF not in (select KODE_TARIF from Billing_Pasien.dbo.FO_T_BILLING_2 where NO_TRS_BILLING=:notrsbill2 and Batal='0')");
                    $this->db->bind('notrsbill', $notrsbill);
                    $this->db->bind('notrsbill2', $notrsbill);
                    $this->db->execute();
                    // var_dump($dataLabnumber);
                    // exit;

                    // UPDATE TOTAL KE FO_T_BILLING
                    $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_BILLING
                    SET TOTAL_TARIF=B.SUM_NILAI_TARIF,TOTAL_QTY=B.SUM_QTY,SUBTOTAL=B.SUM_SUB_TOTAL,SUBTOTAL_2=B.SUM_SUB_TOTAL_2,GRANDTOTAL=B.SUM_GRANDTOTAL,
                    FB_VERIF_JURNAL='0' 
                    FROM Billing_Pasien.DBO.FO_T_BILLING A 
                    INNER JOIN
                    (
                        SELECT  NO_TRS_BILLING,SUM(NILAI_TARIF) AS SUM_NILAI_TARIF,SUM(QTY) AS SUM_QTY,SUM(SUB_TOTAL) AS SUM_SUB_TOTAL,SUM(SUB_TOTAL_2) AS SUM_SUB_TOTAL_2,
                        SUM(GRANDTOTAL) AS SUM_GRANDTOTAL
                        FROM Billing_Pasien.DBO.FO_T_BILLING_1
                        WHERE NO_REGISTRASI=:noreg and Batal='0'
                        GROUP BY NO_TRS_BILLING
                    ) B
                    ON A.NO_TRS_BILLING = B.NO_TRS_BILLING
                    WHERE A.NO_REGISTRASI=:noreg2 AND A.NO_TRS_BILLING=:notrsbill
                    ");
                    $this->db->bind('noreg', $noreg);
                    $this->db->bind('noreg2', $noreg);
                    $this->db->bind('notrsbill', $notrsbill);
                    $this->db->execute();
                } else {
                    $callback = array(
                        'status' => "warning",
                        'message' => "Order Yang Dipilih Sudah Pernah Ditambahkan atau Sudah Di approve sebelumnya, jika ada status batal maka sudah pernah dilakukan transaksi batal pada orderan tersebut",
                    );
                    return $callback;
                    exit;
                }

                $this->db->query("INSERT INTO SysLog.dbo.TZ_Log_Button
                (noregistrasi, nama_biling, petugas_entry, tgl_entry, idtrs)
                VALUES (:NoRegRecord, 'APPROVE BANK DARAH', :USER_KASIRRecord, :TGL_TRSRecord, :trscoderecord)");
                $this->db->bind('NoRegRecord', $noreg);
                $this->db->bind('USER_KASIRRecord', $namauserx);
                $this->db->bind('TGL_TRSRecord', $datenowcreate);
                $this->db->bind('trscoderecord', $datahdr);
                $this->db->execute();
            } else if ($idbtn == 'cb_btlapproveBankDarahall') {
                // var_dump($datahdr, 'btl');
                // exit;

                //update ORDER BLOODS
                // $this->db->query("UPDATE LaboratoriumSQL.dbo.OrderBloods SET StatusOrder=0,DateApproveKasir='$datenowcreatex',PetugasApproveKasir='$namauserx'
                // WHERE ID=:datahdrx1");
                // $this->db->bind('datahdrx1', $datahdr);
                // $this->db->execute();

                $this->db->query("SELECT COUNT(ID) AS CEK1payment FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE GROUP_ENTRI = 'BANKDARAH' AND KODE_REF = :dataref12 AND ID_TRS_Payment IS NOT NULL");
                $this->db->bind('dataref12', $orderbloodsiddtl);
                $data_CEKpayment =  $this->db->single();
                $CEKpayment = $data_CEKpayment['CEK1payment'];

                if ($CEKpayment != '0') {
                    $callback = array(
                        'status' => "warning",
                        'message' => "GAGAL BATAL APPROVE ALL, Karena Ada Orderan Yang Sudah Di Payment!",
                    );
                    return $callback;
                    exit;
                }

                $this->db->query("SELECT COUNT(*) AS CEKDATAUSEBLOODS FROM LaboratoriumSQL.dbo.UseBloods WHERE IDOrder = :dataheader12 AND Batal = '0'");
                $this->db->bind('dataheader12', $datahdr);
                $data_CEKUSE =  $this->db->single();
                $CEK_USE = $data_CEKUSE['CEKDATAUSEBLOODS'];

                if ($CEK_USE != '0') {
                    $callback = array(
                        'status' => "warning",
                        'message' => "Bank Darah Ini Sudah Dalam Pemakaian ! Mohon Konfirmasi Kembali ke Bagian Bank Darah!",
                    );
                    return $callback;
                    exit;
                }

                // CEK USE BLOODS

                $this->db->query("UPDATE LaboratoriumSQL.dbo.OrderBloods SET StatusOrder=0,DateApproveKasir=NULL,PetugasApproveKasir=NULL
                WHERE ID=:datahdrx1");
                $this->db->bind('datahdrx1', $datahdr);
                $this->db->execute();

                //update ORDER BATAL
                // $this->db->query("UPDATE LaboratoriumSQL.dbo.OrderBloodDetails SET Batal='0', DateBatal = '$datenowcreatex', PetugasBatal = '$namauserx' WHERE ID IN ($orderbloodsiddtl) AND IDHdr = :datahdrx2 AND Batal='0'");
                // $this->db->bind('datahdrx2', $datahdr);
                // $this->db->execute();

                //update ORDER BATAL
                $this->db->query("UPDATE LaboratoriumSQL.dbo.OrderBloodDetails SET Batal='1', DateBatal = '$datenowcreatex', PetugasBatal = '$namauserx' WHERE ID IN ($orderbloodsiddtl) AND IDHdr = :datahdrx2 AND Batal='0'");
                $this->db->bind('datahdrx2', $datahdr);
                $this->db->execute();

                //update ORDER BATAL
                $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 set BATAL = '1' WHERE ID_BILL = :datahdrx3 AND KODE_REF in ($orderbloodsiddtl) AND GROUP_ENTRI = 'BANKDARAH'");
                $this->db->bind('datahdrx3', $datahdr);
                $this->db->execute();

                $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_2 set BATAL = '1' WHERE ID_BILL = :datahdrx4 AND GROUP_TARIF = 'BankDarah'
                ");
                $this->db->bind('datahdrx4', $datahdr);
                $this->db->execute();

                $this->db->query("SELECT NO_TRS_BILLING FROM Billing_Pasien.dbo.FO_T_BILLING_1  WHERE ID_BILL = :datahdrx5 AND NO_REGISTRASI = :noregx5 AND GROUP_ENTRI = 'BANKDARAH'");
                $this->db->bind('datahdrx5', $datahdr);
                $this->db->bind('noregx5', $noreg);
                $datafo1ax =  $this->db->single();
                $trs = $datafo1ax['NO_TRS_BILLING'];

                $this->db->query("SELECT COUNT(*) as cekFOBILLING FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE ID_BILL = :datahdrx4 AND NO_REGISTRASI = :noregx4 AND GROUP_ENTRI = 'BANKDARAH' AND BATAL = '0'");
                $this->db->bind('datahdrx4', $datahdr);
                $this->db->bind('noregx4', $noreg);
                $datafo1a =  $this->db->single();
                $datafoo1 = $datafo1a['cekFOBILLING'];

                if ($datafoo1 == '0') {
                    $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING set BATAL = '1' WHERE NO_TRS_BILLING = :trs1x AND NO_REGISTRASI =:noregx6");
                    $this->db->bind('trs1x', $trs);
                    $this->db->bind('noregx6', $noreg);
                    $this->db->execute();
                }

                $this->db->query("UPDATE SysLog.dbo.TZ_Log_Button SET petugas_batal = :USER_KASIRRecord, alasan_batal = 'BATAL APPROVE', tgl_batal = :TGL_TRSRecord
                WHERE NoRegistrasi = :NoRegRecord AND idtrs = :dataaptk1 AND petugas_batal IS NULL");
                $this->db->bind('NoRegRecord', $noreg);
                // $this->db->bind('trscoderecord', $trscode);
                $this->db->bind('USER_KASIRRecord', $namauserx);
                $this->db->bind('TGL_TRSRecord', $datenowcreate);
                $this->db->bind('dataaptk1', $datahdr);
                $this->db->execute();
            } else {
                $callback = array(
                    'status' => "warning",
                    'message' => "Something Wrong !",
                );
                return $callback;
                exit;
            }

            $this->db->commit();
            $callback = array(
                'status' => "success",
                'message' => "Berhasil Melakukan Transaksi", // Set array nama 

            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function getDataApproveRad($data)
    {
        try {

            $noreg = $data['noreg'];
            $tglawal = $data['tglawal'];
            $tglakhir = $data['tglakhir'];

            $query = "SELECT WOID, replace(CONVERT(VARCHAR(11), ORDER_DATE, 111), '/','-') as DateOrder,b.First_Name as DokterOrder,a.NoRegistrasi,REQUESTED_PROC_DESC as NamaTarif,ACCESSION_NO,Service_Charge,StatusID,c.[Status Name] as Status, PaymentStatus
            FROM RadiologiSQL.dbo.WO_RADIOLOGY a
            left join MasterdataSQL.dbo.Doctors b on a.REQUEST_BY=b.ID
            left join PerawatanSQL.dbo.[Visit Status] c on a.PaymentStatus=c.[Status ID]
            where NOREGISTRASI=:noreg and Batal='0'and replace(CONVERT(VARCHAR(11), ORDER_DATE, 111), '/','-') Between :tglawal AND :tglakhir";

            $this->db->query($query);
            $this->db->bind('noreg', $noreg);
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $data =  $this->db->resultSet();
            // var_dump($data);
            // exit;
            $rows = array();
            $no = 1;
            foreach ($data as $key) {

                $pasing['No'] = $no++;
                $pasing['WOID'] = $key['WOID'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];

                $pasing['ORDER_DATE'] = $key['DateOrder'];
                $pasing['DokterOrder'] = $key['DokterOrder'];
                $pasing['NamaTarif'] = $key['NamaTarif'];
                $pasing['ACCESSION_NO'] = $key['ACCESSION_NO'];
                $pasing['Service_Charge'] = $key['Service_Charge'];
                $pasing['Status'] = $key['Status'];
                $pasing['StatusID'] = $key['StatusID'];
                $pasing['PaymentStatus'] = $key['PaymentStatus'];


                $rows[] = $pasing;
            }

            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    //10/09/2024
    public function ApproveRad($data)
    {
        try {
            $this->db->transaksi();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $datenowx = Utils::datenowcreateNotFull();

            $datenowcreate = Utils::seCurrentDateTime();

            $datawoid = $data['data'];
            $idbtn = $data['idbtn'];
            $noreg = $data['noreg'];
            $noeps = $data['noeps'];
            $nomr = $data['nomr'];


            $datebill = $data['datebill'];
            $datebills  = date('dmy', strtotime($datebill));
            $datenowcreatex =  $datebill . ' 00:00:00';
            $getREG = $data['getreg'];

            // $datenowcreate = Utils::seCurrentDateTime();
            $datenowcreate1 = date('Y-m-d', strtotime($datenowcreate));
            $datenowcreate2 = date('dmy', strtotime($datenowcreate));


            $kelas = NULL;

            // var_dump($data);
            // exit;

            if ($getREG == 'RI') {
                $this->db->query("SELECT KlsID FROM RawatInapSQL.dbo.Inpatient WHERE NoRegRI = :noregri");
                $this->db->bind('noregri', $noreg);
                $klsiddata =  $this->db->single();
                $kelas = $klsiddata['KlsID'];
            }

            // var_dump($datenowcreate);
            // var_dump($datenowcreatex);
            // var_dump($datebill);
            // var_dump($datenowx);
            // exit;

            //CEk Status Order
            $this->db->query("SELECT StatusID, PaymentStatus FROM RadiologiSQL.dbo.WO_RADIOLOGY WHERE WOID=:datawoid");
            $this->db->bind('datawoid', $datawoid);

            $data_cek =  $this->db->single();

            if ($data_cek['PaymentStatus'] == '3') {
                $callback = array(
                    'status' => "warning",
                    'message' => "Order Sudah di APPROVE !",
                );
                return $callback;
                exit;
            }

            // var_dump('tai');
            // exit;

            $this->db->query("SELECT [Status ID] AS statuspasien FROM PerawatanSQL.dbo.visit WHERE NoRegistrasi = :norega1
            UNION ALL SELECT StatusID AS statuspasien FROM RawatInapSQL.dbo.Inpatient WHERE NoRegRI = :norega2");
            $this->db->bind('norega1', $data['noreg']);
            $this->db->bind('norega2', $data['noreg']);
            $statuscek =  $this->db->single();
            $statuspasien = $statuscek['statuspasien'];


            if ($statuspasien == '4') {
                $callback = array(
                    'status' => "warning", // Set array nama
                    'message' => "Status Pasien Sudah Close"
                );
                return $callback;
                exit;
            }



            if ($idbtn == 'btn_approveRad') {
                //update di visit nya
                // $this->db->query("UPDATE PerawatanSQL.dbo.Visit SET RadiologiLunas=1 WHERE NoRegistrasi = :noregvisit1");
                // $this->db->bind('noregvisit1', $noreg);
                // $this->db->execute();
                //update ke WO_radiology nya
                $this->db->query("UPDATE RadiologiSQL.dbo.WO_RADIOLOGY SET PaymentStatus=3
                        WHERE WOID=:datawoid1");
                $this->db->bind('datawoid1', $datawoid);
                $this->db->execute();

                $this->db->query("SELECT count(MWL_KEY) as MWL_KEY from RadiologiSQL.dbo.MWLWL where ACCESSION_NO in ( select ACCESSION_NO from RadiologiSQL.dbo.WO_RADIOLOGY where WOID=:datawoid1a)");
                $this->db->bind('datawoid1a', $datawoid);
                $data_mwl =  $this->db->single();
                $MWL_KEY = $data_mwl['MWL_KEY'];

                if ($MWL_KEY == "0") {
                    $this->db->query("INSERT INTO  RadiologiSQL.DBO.MWLWL (TRIGGER_DTTM,REPLICA_DTTM,EVENT_TYPE,CHARACTER_SET, SCHEDULED_AETITLE,SCHEDULED_DTTM,SCHEDULED_MODALITY,SCHEDULED_STATION, SCHEDULED_LOCATION,SCHEDULED_PROC_ID,SCHEDULED_PROC_DESC,SCHEDULED_ACTION_CODES, SCHEDULED_PROC_STATUS,REQUESTED_PROC_ID,REQUESTED_PROC_DESC, REQUESTED_PROC_CODES, STUDY_INSTANCE_UID,PROC_PLACER_ORDER_NO,REFER_DOCTOR,REQUEST_DEPARTMENT, PATIENT_LOCATION,PATIENT_NAME,Patient_ID,PATIENT_BIRTH_DATE, PATIENT_SEX,DIAGNOSIS,ACCESSION_NO,OTHER_PATIENT_ID) select TRIGGER_DTTM,'ANY','','ISO_IR 100','ANY',TRIGGER_DTTM,SCHEDULED_MODALITY,SCHEDULED_STATION,SCHEDULED_LOCATION, SCHEDULED_PROC_ID,SCHEDULED_PROC_DESC,SCHEDULED_ACTION_CODES, '120',REQUESTED_PROC_ID,REQUESTED_PROC_DESC,REQUESTED_PROC_CODES, '1.2.410.2000010.82.111.'+ACCESSION_NO,PROC_PLACER_ORDER_NO,REQUEST_BY,REQUEST_DEPARTMENT, PATIENT_LOCATION,PATIENT_NAME,Patient_ID,format(b.Date_of_Birth,'yyyyMMdd'), CASE WHEN b.Gander='L' THEN 'M' ELSE 'F' END AS PATIENT_SEX,DIAGNOSIS,ACCESSION_NO,NOREGISTRASI from RadiologiSQL.dbo.WO_RADIOLOGY a inner join MasterdataSQL.dbo.Admision b on a.MRN=b.NoMR where WOID=:datawoid1b");
                    $this->db->bind('datawoid1b', $datawoid);
                    $this->db->execute();
                }

                // else {
                //     $callback = array(
                //         'status' => "warning",
                //         'message' => "Order Sudah Ada di Poli Radiologi !",
                //     );
                //     return $callback;
                //     exit;
                // }

                //Generate no trs billing
                // $datenowx = Utils::datenowcreateNotFull();
                // $datenow = date('dmy', strtotime($datenowcreate));


                if ($getREG == 'RJ') {
                    $this->db->query("SELECT  TOP 1 NO_TRS_BILLING,right( REPLACE(NO_TRS_BILLING,'-','0')  ,5) as urut FROM Billing_Pasien.dbo.FO_T_BILLING  WHERE replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-')=:datenow2  ORDER BY urut DESC");
                    $this->db->bind('datenow2', $datebill);
                    $datax =  $this->db->single();
                    //no urut reg
                    $nexturut = $datax['urut'];
                    $nexturut++;

                    $nourutfix = Utils::generateAutoNumber($nexturut);
                    $kodeawal = "BIL";
                    $notrsbill = $kodeawal . $datebills . $nourutfix;

                    $this->db->query("SELECT ACCESSION_NO, Service_Charge FROM RadiologiSQL.dbo.WO_RADIOLOGY WHERE WOID = :datawowwo");
                    $this->db->bind('datawowwo', $datawoid);
                    $datafo =  $this->db->single();
                    $dataaccnumber = $datafo['ACCESSION_NO'];
                    $datatarifwo = $datafo['Service_Charge'];

                    $this->db->query("SELECT COUNT(*) as FOBILLING1 FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE ID_BILL = :accnumber");
                    $this->db->bind('accnumber', $dataaccnumber);
                    $datafo =  $this->db->single();
                    $datafoo = $datafo['FOBILLING1'];

                    $datenowcreatex1 = $datenowcreatex;
                }
                if ($getREG == 'RI') {
                    $this->db->query("SELECT  TOP 1 NO_TRS_BILLING,right( REPLACE(NO_TRS_BILLING,'-','0')  ,5) as urut FROM Billing_Pasien.dbo.FO_T_BILLING  WHERE replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-')=:datenow2  ORDER BY urut DESC");
                    $this->db->bind('datenow2', $datenowcreate1);
                    $datax =  $this->db->single();
                    //no urut reg
                    $nexturut = $datax['urut'];
                    $nexturut++;
                    $nourutfix = Utils::generateAutoNumber($nexturut);
                    $kodeawal = "BIL";
                    $notrsbill = $kodeawal . $datenowcreate2 . $nourutfix;

                    $this->db->query("SELECT ACCESSION_NO, Service_Charge FROM RadiologiSQL.dbo.WO_RADIOLOGY WHERE WOID = :datawowwo");
                    $this->db->bind('datawowwo', $datawoid);
                    $datafo =  $this->db->single();
                    $dataaccnumber = $datafo['ACCESSION_NO'];
                    $datatarifwo = $datafo['Service_Charge'];

                    $this->db->query("SELECT COUNT(*) as FOBILLING1 FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE ID_BILL = :accnumber");
                    $this->db->bind('accnumber', $dataaccnumber);
                    $datafo =  $this->db->single();
                    $datafoo = $datafo['FOBILLING1'];

                    $datenowcreatex1 = $datenowcreate;
                    // $datenowcreatex1 = $datenowcreatex;
                }

                if ($datafoo == "0") {
                    //Get Data Visit
                    if ($getREG == 'RJ') {
                        $this->db->query("SELECT  Unit,PatientType,case when PatientType='2' then Asuransi else Perusahaan end as perusahaanid FROM PerawatanSQL.dbo.Visit  WHERE NoRegistrasi=:NoRegistrasi
                        ");
                        $this->db->bind('NoRegistrasi', $noreg);
                        $datax =  $this->db->single();
                        $IdGrupPerawatan = $datax['Unit'];
                        $JenisBayar = $datax['PatientType'];
                        $perusahaanid = $datax['perusahaanid'];
                    }
                    //Get Data Inpatient
                    if ($getREG == 'RI') {
                        $this->db->query("SELECT b.ID, a.TypePatient, case when a.TypePatient='2' then a.IDAsuransi else a.IDJPK end as perusahaanid 
                        FROM RawatInapSQL.dbo.Inpatient a 
                        INNER JOIN MasterdataSQL.dbo.MstrUnitPerwatan b ON b.NamaUnit = a.JenisRawat
                        WHERE NoRegRI = :NoRegistrasi");
                        $this->db->bind('NoRegistrasi', $noreg);
                        $datax =  $this->db->single();
                        $IdGrupPerawatan = $datax['ID'];
                        $JenisBayar = $datax['TypePatient'];
                        $perusahaanid = $datax['perusahaanid'];
                    }


                    // insert ke tabel FO_T_Billing
                    $this->db->query("INSERT INTO Billing_Pasien.dbo.FO_T_BILLING
                ([NO_TRS_BILLING],[TGL_BILLING],[PETUGAS_ENTRY],[NO_MR],[NO_EPISODE],[NO_REGISTRASI],[UNIT],[GROUP_JAMINAN],[KODE_JAMINAN],[TOTAL_TARIF],[TOTAL_QTY],[SUBTOTAL],[TOTAL_DISCOUNT],[TOTAL_DISCOUNT_RP],[SUBTOTAL_2],[GRANDTOTAL],[BATAL],[FB_CLOSE_KEUANGAN],[FB_VERIF_JURNAL]) 
                VALUES
                (:notrsbill,:datenowx,:namauserx,:NoMrfix,:NoEpisode,:nofixReg,:IdGrupPerawatan,:JenisBayar,:perusahaanid,:totaltarif,:totalqty,:subtotal,:totaldiscount,:totaldiscountrp,:subtotal2,:grandtotal,:batal,:closekeuangan,:verifkeuangan)");

                    $this->db->bind('notrsbill', $notrsbill);
                    $this->db->bind('datenowx', $datenowcreatex1);
                    $this->db->bind('namauserx', $namauserx);
                    $this->db->bind('NoMrfix', $nomr);
                    $this->db->bind('NoEpisode', $noeps);
                    $this->db->bind('nofixReg', $noreg);
                    $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                    $this->db->bind('JenisBayar', $JenisBayar);
                    $this->db->bind('perusahaanid', $perusahaanid);
                    $this->db->bind('totaltarif', 0);
                    $this->db->bind('totalqty', 0);
                    $this->db->bind('subtotal', 0);
                    $this->db->bind('totaldiscount', 0);
                    $this->db->bind('totaldiscountrp', 0);
                    $this->db->bind('subtotal2', 0);
                    $this->db->bind('grandtotal', 0);
                    $this->db->bind('batal', 0);
                    $this->db->bind('closekeuangan', 0);
                    $this->db->bind('verifkeuangan', 0);
                    $this->db->execute();


                    //GET acc number
                    $this->db->query("SELECT ACCESSION_NO, SCHEDULED_PROC_ID, SCHEDULED_PROC_DESC, Service_Charge, DokterRadiologi FROM RadiologiSQL.dbo.WO_RADIOLOGY where WOID = :idwo");
                    $this->db->bind('idwo', $datawoid);
                    $dataacc =  $this->db->single();
                    $Accession_No = $dataacc['ACCESSION_NO'];
                    $Kode_Tarif = $dataacc['SCHEDULED_PROC_ID'];
                    $Nama_Tarif = $dataacc['SCHEDULED_PROC_DESC'];
                    $Tarif_Servis = $dataacc['Service_Charge'];
                    $Dokter_Radiology = $dataacc['DokterRadiologi'];


                    if ($data['GROUP_JAMINAN'] == "1") {
                        $kekurangan = $datatarifwo;
                        $klaim = "0";
                        $bayar = "0";
                    } else {
                        $kekurangan = "0";
                        $klaim = $datatarifwo;
                        $bayar = "0";
                    }

                    // insert ke tabel FO_T_Billing_1
                    // select Radiologi
                    $this->db->query("INSERT INTO  Billing_Pasien.dbo.FO_T_BILLING_1
                    (ID_BILL,[NO_TRS_BILLING],[TGL_BILLING] ,[PETUGAS_ENTRY],[NO_MR],[NO_EPISODE],[NO_REGISTRASI],[KODE_TARIF],[UNIT],[GROUP_JAMINAN],[KODE_JAMINAN],
                    [NAMA_TARIF],[GROUP_TARIF],[KD_KELAS],[QTY],[NILAI_TARIF],[SUB_TOTAL],[DISC],[DISC_RP],[SUB_TOTAL_2],[GRANDTOTAL],[KODE_REF],[KD_DR],[NM_DR],
                    [BATAL],[PETUGAS_BATAL],[GROUP_ENTRI],[BAYAR],[KLAIM],[KEKURANGAN])
                    SELECT '$Accession_No','$notrsbill' , '$datenowcreatex1' as datenow,'$namauserx' as namauserx,'$nomr' AS NoMR, '$noeps' AS xNoEpisode,'$noreg' as NoReg,:Rad_Kode_Tarif as kodetarif,
                    UNIT,GROUP_JAMINAN,KODE_JAMINAN, :Rad_Nama_Tarif as namatarif,'Radiologi' as rad, :kdkelas, 1 as Qty, :Rad_Nilai as nilai, :Rad_Nilai2 as nilai2, 0, 
                    0, :Rad_Nilai3 as nilai3, :Rad_Nilai4 as nilai4,'$datawoid', :Rad_DokterRadiologi, null as namadokter, 0 as batal,null as petugasbatal,'RADIOLOGI',$bayar,$klaim,$kekurangan
                    FROM Billing_Pasien.dbo.FO_T_BILLING
                    WHERE NO_TRS_BILLING=:notrsbill AND Batal='0'");
                    $this->db->bind('notrsbill', $notrsbill);
                    $this->db->bind('kdkelas', $kelas);
                    $this->db->bind('Rad_Kode_Tarif', $Kode_Tarif);
                    $this->db->bind('Rad_Nama_Tarif', $Nama_Tarif);
                    $this->db->bind('Rad_Nilai',  $Tarif_Servis);
                    $this->db->bind('Rad_Nilai2', $Tarif_Servis);
                    $this->db->bind('Rad_Nilai3', $Tarif_Servis);
                    $this->db->bind('Rad_Nilai4', $Tarif_Servis);
                    $this->db->bind('Rad_DokterRadiologi', $Dokter_Radiology);
                    $this->db->execute();


                    // var_dump($notrsbill);
                    // exit;

                    //Insert ke tabel FO_T_Billing_2
                    $this->db->query("INSERT INTO Billing_Pasien.DBO.FO_T_BILLING_2
                SELECT '$Accession_No',A.NO_TRS_BILLING AS NO_TRS_BILLING,A1.KODE_TARIF,B.KD_TIPE_PDP as Kode_komponen,A1.UNIT AS UNIT, A1.GROUP_JAMINAN AS GROUP_JAMINAN, A1.KODE_JAMINAN AS KODE_JAMINAN, 
                A1.NAMA_TARIF AS NAMA_TARIF, 
                A1.GROUP_TARIF AS GROUP_TARIF, A1.KD_KELAS as KELAS,A1.QTY AS QTY, 
                A1.NILAI_TARIF AS NILAI_TARIF  ,
                A1.NILAI_TARIF*A1.QTY  AS SUBTOTAL,
                A1.DISC AS DISC,
                (A1.NILAI_TARIF-((A1.NILAI_TARIF*A1.DISC)/100)) AS DISC_RP,
                ((A1.NILAI_TARIF*A1.QTY)-(((A1.NILAI_TARIF*A1.QTY)*A1.DISC)/100)) SUB_TOTAL_PDP_2,
                (CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN ((((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' THEN ((b.NILAI_FIX*A1.QTY*DISC)/100)*A1.QTY END ) NILAI_DISKON_PDP,
                (CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN (((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY)-(((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' THEN (b.NILAI_FIX*A1.QTY)-((b.NILAI_FIX*A1.QTY*DISC)/100)*A1.QTY END ) as NILAI_PDP,
                A1.KD_DR AS KD_DR, '' NM_DR,b.NILAI_PROSEN,'0' AS BATAL,'' PETUGAS_BATAL, '' AS JAM_BATAL, B.KD_POSTING AS KD_POSTING,'' as kd_posting_diskon, 0 as ID_TR_TARIF_PAKET
                FROM Billing_Pasien.DBO.FO_T_BILLING A
                inner join Billing_Pasien.dbo.FO_T_BILLING_1 A1
                ON A.NO_TRS_BILLING = A1.NO_TRS_BILLING
                INNER JOIN RadiologiSQL.dbo.ProcedureRadiology CC 
                ON CC.Proc_Code collate SQL_Latin1_General_CP1_CI_AS= A1.KODE_TARIF collate SQL_Latin1_General_CP1_CI_AS
                INNER JOIN Keuangan.DBO.BO_M_PDP2 B
                ON CC.KD_PDP collate SQL_Latin1_General_CP1_CI_AS = B.KD_PDP collate SQL_Latin1_General_CP1_CI_AS
                INNER JOIN Keuangan.DBO.BO_M_PDP CX
                ON CX.KD_PDP = B.KD_PDP
                WHERE A1.GROUP_ENTRI='RADIOLOGI' and a.BATAL='0' and A1.BATAL='0' and B.KD_TIPE_PDP='RS01' and a.NO_TRS_BILLING=:notrsbill2");
                    $this->db->bind('notrsbill2', $notrsbill);
                    // $this->db->bind('kdkelas', $kelas);
                    $this->db->execute();




                    //UPDATE TOTAL KE FO_T_BILLING
                    $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_BILLING
                SET TOTAL_TARIF=B.SUM_NILAI_TARIF,TOTAL_QTY=B.SUM_QTY,SUBTOTAL=B.SUM_SUB_TOTAL,SUBTOTAL_2=B.SUM_SUB_TOTAL_2,GRANDTOTAL=B.SUM_GRANDTOTAL
                FROM Billing_Pasien.DBO.FO_T_BILLING A 
                INNER JOIN
                (
                    SELECT  NO_TRS_BILLING,SUM(NILAI_TARIF) AS SUM_NILAI_TARIF,SUM(QTY) AS SUM_QTY,SUM(SUB_TOTAL) AS SUM_SUB_TOTAL,SUM(SUB_TOTAL_2) AS SUM_SUB_TOTAL_2,
                    SUM(GRANDTOTAL) AS SUM_GRANDTOTAL
                    FROM Billing_Pasien.DBO.FO_T_BILLING_1
                    WHERE NO_REGISTRASI=:noreg and Batal='0'
                    GROUP BY NO_TRS_BILLING
                ) B
                ON A.NO_TRS_BILLING = B.NO_TRS_BILLING
                WHERE A.NO_REGISTRASI=:noreg2 AND A.NO_TRS_BILLING=:notrsbill
                ");
                    $this->db->bind('noreg', $noreg);
                    $this->db->bind('noreg2', $noreg);
                    $this->db->bind('notrsbill', $notrsbill);
                    $this->db->execute();
                    //Generate
                } else {
                    $callback = array(
                        'status' => "warning",
                        'message' => "Gagal Approve Orderan, Karena orderan sudah di approve sebelumnya / orderan di batal approve!",
                    );
                    return $callback;
                    exit;
                }
            } else if ($idbtn == 'btn_btlapproveRad') {

                // var_dump($datawoid);
                // exit;
                $this->db->query("SELECT COUNT(ID) AS CEK1payment FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE GROUP_ENTRI = 'RADIOLOGI' AND KODE_REF = :dataref12 AND ID_TRS_Payment IS NOT NULL");
                $this->db->bind('dataref12', $datawoid);
                $data_CEKpayment =  $this->db->single();
                $CEKpayment = $data_CEKpayment['CEK1payment'];

                if ($CEKpayment != '0') {
                    $callback = array(
                        'status' => "warning",
                        'message' => "GAGAL BATAL APPROVE, Order Ini Sudah Di Payment!",
                    );
                    return $callback;
                    exit;
                }

                $this->db->query("SELECT ACCESSION_NO FROM RadiologiSQL.dbo.WO_RADIOLOGY WHERE WOID = :datawoid2a");
                $this->db->bind('datawoid2a', $datawoid);
                $data_accnumber =  $this->db->single();
                $ACC_Number = $data_accnumber['ACCESSION_NO'];

                $this->db->query("SELECT COUNT(*) as cekRIS FROM RadiologiSQL.dbo.REPORT_RIS WHERE ACCESSION_NO = :ACC_Number");
                $this->db->bind('ACC_Number', $ACC_Number);
                $data_countris =  $this->db->single();
                $COUNT_RIS = $data_countris['cekRIS'];
                // var_dump($COUNT_RIS);
                // exit;
                if ($COUNT_RIS == "0") {
                    //update di visit nya

                    $this->db->query("UPDATE PerawatanSQL.dbo.Visit SET RadiologiLunas=0
                WHERE NoRegistrasi = :noregvisit2a");
                    $this->db->bind('noregvisit2a', $noreg);
                    $this->db->execute();

                    //update ke WO_radiology nya
                    $this->db->query("UPDATE RadiologiSQL.dbo.WO_RADIOLOGY SET PaymentStatus=0
                WHERE WOID=:datawoid2a");
                    $this->db->bind('datawoid2a', $datawoid);
                    $this->db->execute();

                    $this->db->query("SELECT KODE_TARIF, NO_TRS_BILLING from Billing_Pasien.dbo.FO_T_BILLING_1 where ID_BILL = :noACC and KODE_REF = :dataWO");
                    $this->db->bind('noACC', $ACC_Number);
                    $this->db->bind('dataWO', $datawoid);
                    $data_kodetarifrad =  $this->db->single();
                    $kodetrfrad = $data_kodetarifrad['KODE_TARIF'];
                    $trsrad = $data_kodetarifrad['NO_TRS_BILLING'];
                    // exit;
                    $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 SET BATAL = '1' WHERE ID_BILL = :noACC1a AND KODE_REF = :dataWO1a");
                    $this->db->bind('noACC1a', $ACC_Number);
                    $this->db->bind('dataWO1a', $datawoid);
                    $this->db->execute();

                    $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_2 SET BATAL = '1' WHERE ID_BILL = :noACC1b AND KODE_TARIF = :kodetrfrad1a");
                    $this->db->bind('noACC1b', $ACC_Number);
                    $this->db->bind('kodetrfrad1a', $kodetrfrad);
                    $this->db->execute();

                    $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_BILLING
                        SET TOTAL_TARIF=B.SUM_NILAI_TARIF,TOTAL_QTY=B.SUM_QTY,SUBTOTAL=B.SUM_SUB_TOTAL,SUBTOTAL_2=B.SUM_SUB_TOTAL_2,GRANDTOTAL=B.SUM_GRANDTOTAL,
                        FB_VERIF_JURNAL='0' 
                        FROM Billing_Pasien.DBO.FO_T_BILLING A 
                        INNER JOIN
                        (
                            SELECT  NO_TRS_BILLING,SUM(NILAI_TARIF) AS SUM_NILAI_TARIF,SUM(QTY) AS SUM_QTY,SUM(SUB_TOTAL) AS SUM_SUB_TOTAL,SUM(SUB_TOTAL_2) AS SUM_SUB_TOTAL_2,
                            SUM(GRANDTOTAL) AS SUM_GRANDTOTAL
                            FROM Billing_Pasien.DBO.FO_T_BILLING_1
                            WHERE NO_REGISTRASI=:noreg and Batal='0'
                            GROUP BY NO_TRS_BILLING
                        ) B
                        ON A.NO_TRS_BILLING = B.NO_TRS_BILLING
                        WHERE A.NO_REGISTRASI=:noreg2 AND A.NO_TRS_BILLING=:notrsbill
                        ");
                    $this->db->bind('noreg', $noreg);
                    $this->db->bind('noreg2', $noreg);
                    $this->db->bind('notrsbill', $trsrad);
                    $this->db->execute();
                    $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING SET BATAL = '1' WHERE NO_REGISTRASI = :noregfinis and NO_TRS_BILLING=:trsrad1");
                    $this->db->bind('noregfinis', $noreg);
                    $this->db->bind('trsrad1', $trsrad);

                    $this->db->execute();
                } else {
                    $callback = array(
                        'status' => "warning",
                        'message' => "Order Sudah Ada Hasil !",
                    );
                    return $callback;
                    exit;
                }
            } else {
                $callback = array(
                    'status' => "warning",
                    'message' => "Something Wrong !",
                );
                return $callback;
                exit;
            }

            $this->db->commit();
            $callback = array(
                'status' => "success",
                'message' => "Berhasil Melakukan Transaksi", // Set array nama 

            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    //10/09/2024


    public function ApproveAllRad($data)
    {
        try {
            $this->db->transaksi();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $datenowx = Utils::datenowcreateNotFull();

            $TRIGGER_DTTM = date('YmdHis');

            $idbtn = $data['idbtn'];
            $noreg = $data['noreg'];
            // $datawoid = $data['idorderapproveRad'];


            // $datawoid = $data['data'];
            $noeps = $data['noeps'];
            $nomr = $data['nomr'];


            $datebill = $data['datebill'];
            $datebills  = date('dmy', strtotime($datebill));
            $datenowcreatex =  $datebill . ' 00:00:00';
            $getREG = $data['getreg'];

            $datenowcreate = Utils::seCurrentDateTime();
            $datenowcreate1 = date('Y-m-d', strtotime($datenowcreate));
            $datenowcreate2 = date('dmy', strtotime($datenowcreate));

            // $data['GROUP_JAMINAN'];

            $kelas = NULL;
            if ($getREG == 'RI') {
                $this->db->query("SELECT KlsID FROM RawatInapSQL.dbo.Inpatient WHERE NoRegRI = :noregri");
                $this->db->bind('noregri', $noreg);
                $klsiddata =  $this->db->single();
                $kelas = $klsiddata['KlsID'];
            } else {
                if ($data['IDUnit'] == '1') {
                    $kelas = '2';
                } else {
                    $kelas = '3';
                }
            }

            //CEk Status Order
            // $this->db->query("SELECT StatusID, PaymentStatus FROM RadiologiSQL.dbo.WO_RADIOLOGY WHERE WOID=:datawoid");
            // $this->db->bind('datawoid', $datawoid);

            // $data_cek =  $this->db->single();

            // if ($data_cek['PaymentStatus'] == '3') {
            //     $callback = array(
            //         'status' => "warning",
            //         'message' => "Order Sudah di APPROVE !",
            //     );
            //     return $callback;
            //     exit;
            // }

            $this->db->query("SELECT [Status ID] AS statuspasien FROM PerawatanSQL.dbo.visit WHERE NoRegistrasi = :norega1
            UNION ALL SELECT StatusID AS statuspasien FROM RawatInapSQL.dbo.Inpatient WHERE NoRegRI = :norega2");
            $this->db->bind('norega1', $data['noreg']);
            $this->db->bind('norega2', $data['noreg']);
            $statuscek =  $this->db->single();
            $statuspasien = $statuscek['statuspasien'];


            if ($statuspasien == '4') {
                $callback = array(
                    'status' => "warning", // Set array nama
                    'message' => "Status Pasien Sudah Close"
                );
                return $callback;
                exit;
            }

            if ($idbtn == 'cb_approveRadiologyall') {

                //$odid = array();
                $tod = json_decode(json_encode((object) $data['idorderapproveRad']), FALSE);
                foreach ($tod as $datawo) {

                    //CEk Status Order
                    $this->db->query("SELECT StatusID, PaymentStatus FROM RadiologiSQL.dbo.WO_RADIOLOGY WHERE WOID=:datawoid");
                    $this->db->bind('datawoid', $datawo);

                    $data_cek =  $this->db->single();

                    if ($data_cek['PaymentStatus'] == '3') {
                        $callback = array(
                            'status' => "warning",
                            'message' => "Ada Orderan Yang Sudah di APPROVE !",
                        );
                        return $callback;
                        exit;
                    }

                    //update ke WO_radiology nya
                    $this->db->query("UPDATE RadiologiSQL.dbo.WO_RADIOLOGY SET PaymentStatus=3 WHERE WOID= :datawoids1");
                    $this->db->bind('datawoids1', $datawo);
                    $this->db->execute();

                    //cek
                    $this->db->query("SELECT count(MWL_KEY) as MWL_KEY from RadiologiSQL.dbo.MWLWL where ACCESSION_NO in ( select ACCESSION_NO from RadiologiSQL.dbo.WO_RADIOLOGY where WOID=:datawoid1a)");
                    $this->db->bind('datawoid1a', $datawo);
                    $data_mwl =  $this->db->single();
                    $MWL_KEY = $data_mwl['MWL_KEY'];

                    if ($MWL_KEY == "0") {
                        $this->db->query("INSERT INTO  RadiologiSQL.DBO.MWLWL (TRIGGER_DTTM,REPLICA_DTTM,EVENT_TYPE,CHARACTER_SET, SCHEDULED_AETITLE,SCHEDULED_DTTM,SCHEDULED_MODALITY,SCHEDULED_STATION, SCHEDULED_LOCATION,SCHEDULED_PROC_ID,SCHEDULED_PROC_DESC,SCHEDULED_ACTION_CODES, SCHEDULED_PROC_STATUS,REQUESTED_PROC_ID,REQUESTED_PROC_DESC, REQUESTED_PROC_CODES, STUDY_INSTANCE_UID,PROC_PLACER_ORDER_NO,REFER_DOCTOR,REQUEST_DEPARTMENT, PATIENT_LOCATION,PATIENT_NAME,Patient_ID,PATIENT_BIRTH_DATE, PATIENT_SEX,DIAGNOSIS,ACCESSION_NO,OTHER_PATIENT_ID) select TRIGGER_DTTM,'ANY','','ISO_IR 100','ANY',TRIGGER_DTTM,SCHEDULED_MODALITY,SCHEDULED_STATION,SCHEDULED_LOCATION, SCHEDULED_PROC_ID,SCHEDULED_PROC_DESC,SCHEDULED_ACTION_CODES, '120',REQUESTED_PROC_ID,REQUESTED_PROC_DESC,REQUESTED_PROC_CODES, '1.2.410.2000010.82.111.'+ACCESSION_NO,PROC_PLACER_ORDER_NO,REQUEST_BY,REQUEST_DEPARTMENT, PATIENT_LOCATION,PATIENT_NAME,Patient_ID,format(b.Date_of_Birth,'yyyyMMdd'), CASE WHEN b.Gander='L' THEN 'M' ELSE 'F' END AS PATIENT_SEX,DIAGNOSIS,ACCESSION_NO,NOREGISTRASI from RadiologiSQL.dbo.WO_RADIOLOGY a inner join MasterdataSQL.dbo.Admision b on a.MRN=b.NoMR where WOID=:datawoid1b");
                        $this->db->bind('datawoid1b', $datawo);
                        $this->db->execute();
                    }

                    if ($getREG == 'RJ') {
                        $this->db->query("SELECT  TOP 1 NO_TRS_BILLING,right( REPLACE(NO_TRS_BILLING,'-','0')  ,5) as urut FROM Billing_Pasien.dbo.FO_T_BILLING  WHERE replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-')=:datenow2  ORDER BY urut DESC");
                        $this->db->bind('datenow2', $datebill);
                        $datax =  $this->db->single();
                        //no urut reg
                        $nexturut = $datax['urut'];
                        $nexturut++;

                        $nourutfix = Utils::generateAutoNumber($nexturut);
                        $kodeawal = "BIL";
                        $notrsbill = $kodeawal . $datebills . $nourutfix;


                        $this->db->query("SELECT ACCESSION_NO, Service_Charge FROM RadiologiSQL.dbo.WO_RADIOLOGY WHERE WOID = :datawowwo");
                        $this->db->bind('datawowwo', $datawo);
                        $datafo =  $this->db->single();
                        $datatarifwo = $datafo['Service_Charge'];
                        $dataaccnumber = $datafo['ACCESSION_NO'];


                        $this->db->query("SELECT COUNT(*) as FOBILLING1 FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE ID_BILL = :accnumber");
                        $this->db->bind('accnumber', $dataaccnumber);
                        $datafo =  $this->db->single();
                        $datafoo = $datafo['FOBILLING1'];

                        $datenowcreatex1 = $datenowcreatex;
                    }
                    if ($getREG == 'RI') {
                        $this->db->query("SELECT  TOP 1 NO_TRS_BILLING,right( REPLACE(NO_TRS_BILLING,'-','0')  ,5) as urut FROM Billing_Pasien.dbo.FO_T_BILLING  WHERE replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-')=:datenow2  ORDER BY urut DESC");
                        $this->db->bind('datenow2', $datenowcreate1);
                        $datax =  $this->db->single();
                        //no urut reg
                        $nexturut = $datax['urut'];
                        $nexturut++;
                        $nourutfix = Utils::generateAutoNumber($nexturut);
                        $kodeawal = "BIL";
                        $notrsbill = $kodeawal . $datenowcreate2 . $nourutfix;

                        $this->db->query("SELECT ACCESSION_NO, Service_Charge FROM RadiologiSQL.dbo.WO_RADIOLOGY WHERE WOID = :datawowwo");
                        $this->db->bind('datawowwo', $datawo);
                        $datafo =  $this->db->single();
                        $datatarifwo = $datafo['Service_Charge'];
                        $dataaccnumber = $datafo['ACCESSION_NO'];


                        $this->db->query("SELECT COUNT(*) as FOBILLING1 FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE ID_BILL = :accnumber");
                        $this->db->bind('accnumber', $dataaccnumber);
                        $datafo =  $this->db->single();
                        $datafoo = $datafo['FOBILLING1'];

                        $datenowcreatex1 = $datenowcreate;
                        // $datenowcreatex1 = $datenowcreatex;
                    }

                    if ($datafoo == "0") {
                        //Get Data Visit
                        if ($getREG == 'RJ') {
                            $this->db->query("SELECT  Unit,PatientType,case when PatientType='2' then Asuransi else Perusahaan end as perusahaanid FROM PerawatanSQL.dbo.Visit  WHERE NoRegistrasi=:NoRegistrasi
                            ");
                            $this->db->bind('NoRegistrasi', $noreg);
                            $datax =  $this->db->single();
                            $IdGrupPerawatan = $datax['Unit'];
                            $JenisBayar = $datax['PatientType'];
                            $perusahaanid = $datax['perusahaanid'];
                        }
                        //Get Data Inpatient
                        if ($getREG == 'RI') {
                            $this->db->query("SELECT b.ID, a.TypePatient, case when a.TypePatient='2' then a.IDAsuransi else a.IDJPK end as perusahaanid 
                            FROM RawatInapSQL.dbo.Inpatient a 
                            INNER JOIN MasterdataSQL.dbo.MstrUnitPerwatan b ON b.NamaUnit = a.JenisRawat
                            WHERE NoRegRI = :NoRegistrasi");
                            $this->db->bind('NoRegistrasi', $noreg);
                            $datax =  $this->db->single();
                            $IdGrupPerawatan = $datax['ID'];
                            $JenisBayar = $datax['TypePatient'];
                            $perusahaanid = $datax['perusahaanid'];
                        }

                        // insert ke tabel FO_T_Billing
                        $this->db->query("INSERT INTO Billing_Pasien.dbo.FO_T_BILLING
                    ([NO_TRS_BILLING],[TGL_BILLING],[PETUGAS_ENTRY],[NO_MR],[NO_EPISODE],[NO_REGISTRASI],[UNIT],[GROUP_JAMINAN],[KODE_JAMINAN],[TOTAL_TARIF],[TOTAL_QTY],[SUBTOTAL],[TOTAL_DISCOUNT],[TOTAL_DISCOUNT_RP],[SUBTOTAL_2],[GRANDTOTAL],[BATAL],[FB_CLOSE_KEUANGAN],[FB_VERIF_JURNAL]) 
                    VALUES
                    (:notrsbill,:datenowx,:namauserx,:NoMrfix,:NoEpisode,:nofixReg,:IdGrupPerawatan,:JenisBayar,:perusahaanid,:totaltarif,:totalqty,:subtotal,:totaldiscount,:totaldiscountrp,:subtotal2,:grandtotal,:batal,:closekeuangan,:verifkeuangan)");

                        $this->db->bind('notrsbill', $notrsbill);
                        $this->db->bind('datenowx', $datenowcreatex1);
                        $this->db->bind('namauserx', $namauserx);
                        $this->db->bind('NoMrfix', $nomr);
                        $this->db->bind('NoEpisode', $noeps);
                        $this->db->bind('nofixReg', $noreg);
                        $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                        $this->db->bind('JenisBayar', $JenisBayar);
                        $this->db->bind('perusahaanid', $perusahaanid);
                        $this->db->bind('totaltarif', 0);
                        $this->db->bind('totalqty', 0);
                        $this->db->bind('subtotal', 0);
                        $this->db->bind('totaldiscount', 0);
                        $this->db->bind('totaldiscountrp', 0);
                        $this->db->bind('subtotal2', 0);
                        $this->db->bind('grandtotal', 0);
                        $this->db->bind('batal', 0);
                        $this->db->bind('closekeuangan', 0);
                        $this->db->bind('verifkeuangan', 0);
                        $this->db->execute();

                        //GET acc number
                        $this->db->query("SELECT ACCESSION_NO, SCHEDULED_PROC_ID, SCHEDULED_PROC_DESC, Service_Charge, DokterRadiologi FROM RadiologiSQL.dbo.WO_RADIOLOGY where WOID = :idwo");
                        $this->db->bind('idwo', $datawo);
                        $dataacc =  $this->db->single();
                        $Accession_No = $dataacc['ACCESSION_NO'];
                        $Kode_Tarif = $dataacc['SCHEDULED_PROC_ID'];
                        $Nama_Tarif = $dataacc['SCHEDULED_PROC_DESC'];
                        $Tarif_Servis = $dataacc['Service_Charge'];
                        $Dokter_Radiology = $dataacc['DokterRadiologi'];

                        if ($data['GROUP_JAMINAN'] == "1") {
                            $kekurangan = $datatarifwo;
                            $klaim = "0";
                            $bayar = "0";
                        } else {
                            $kekurangan = "0";
                            $klaim = $datatarifwo;
                            $bayar = "0";
                        }

                        // insert ke tabel FO_T_Billing_1
                        // select Radiologi
                        $this->db->query("INSERT INTO  Billing_Pasien.dbo.FO_T_BILLING_1
                        (ID_BILL,[NO_TRS_BILLING],[TGL_BILLING] ,[PETUGAS_ENTRY],[NO_MR],[NO_EPISODE],[NO_REGISTRASI],[KODE_TARIF],[UNIT],[GROUP_JAMINAN],[KODE_JAMINAN],
                        [NAMA_TARIF],[GROUP_TARIF],[KD_KELAS],[QTY],[NILAI_TARIF],[SUB_TOTAL],[DISC],[DISC_RP],[SUB_TOTAL_2],[GRANDTOTAL],[KODE_REF],[KD_DR],[NM_DR],
                        [BATAL],[PETUGAS_BATAL],[GROUP_ENTRI],[BAYAR],[KLAIM],[KEKURANGAN])
                        SELECT '$Accession_No','$notrsbill' , '$datenowcreatex1' as datenow,'$namauserx' as namauserx,'$nomr' AS NoMR, '$noeps' AS xNoEpisode,'$noreg' as NoReg,:Rad_Kode_Tarif as kodetarif,
                        UNIT,GROUP_JAMINAN,KODE_JAMINAN, :Rad_Nama_Tarif as namatarif,'Radiologi' as rad, :kdkelas, 1 as Qty, :Rad_Nilai as nilai, :Rad_Nilai2 as nilai2, 0, 
                        0, :Rad_Nilai3 as nilai3, :Rad_Nilai4 as nilai4,'$datawo', :Rad_DokterRadiologi, null as namadokter, 0 as batal,null as petugasbatal,'RADIOLOGI', $bayar, $klaim, $kekurangan
                        FROM Billing_Pasien.dbo.FO_T_BILLING
                        WHERE NO_TRS_BILLING=:notrsbill AND Batal='0'");
                        $this->db->bind('notrsbill', $notrsbill);
                        $this->db->bind('kdkelas', $kelas);
                        $this->db->bind('Rad_Kode_Tarif', $Kode_Tarif);
                        $this->db->bind('Rad_Nama_Tarif', $Nama_Tarif);
                        $this->db->bind('Rad_Nilai',  $Tarif_Servis);
                        $this->db->bind('Rad_Nilai2', $Tarif_Servis);
                        $this->db->bind('Rad_Nilai3', $Tarif_Servis);
                        $this->db->bind('Rad_Nilai4', $Tarif_Servis);
                        $this->db->bind('Rad_DokterRadiologi', $Dokter_Radiology);
                        $this->db->execute();

                        //Insert ke tabel FO_T_Billing_2
                        $this->db->query("INSERT INTO Billing_Pasien.DBO.FO_T_BILLING_2
                        SELECT '$Accession_No',A.NO_TRS_BILLING AS NO_TRS_BILLING,A1.KODE_TARIF,B.KD_TIPE_PDP as Kode_komponen,A1.UNIT AS UNIT, A1.GROUP_JAMINAN AS GROUP_JAMINAN, A1.KODE_JAMINAN AS KODE_JAMINAN, 
                        A1.NAMA_TARIF AS NAMA_TARIF, 
                        A1.GROUP_TARIF AS GROUP_TARIF, A1.KD_KELAS as KELAS,A1.QTY AS QTY, 
                        A1.NILAI_TARIF AS NILAI_TARIF  ,
                        A1.NILAI_TARIF*A1.QTY  AS SUBTOTAL,
                        A1.DISC AS DISC,
						--(A1.NILAI_TARIF-((A1.NILAI_TARIF*A1.DISC)/100)) AS DISC_RP,
						(A1.NILAI_TARIF - (A1.NILAI_TARIF * (1 - A1.DISC))) AS DISC_RP,
						--((A1.NILAI_TARIF*A1.QTY)-(((A1.NILAI_TARIF*A1.QTY)*A1.DISC)/100))   SUB_TOTAL_PDP_2,
						(CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN (((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY)-(((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' THEN (b.NILAI_FIX*A1.QTY)-((b.NILAI_FIX*A1.QTY*DISC)/100)*A1.QTY END ) as SUB_TOTAL_PDP_2,
                        (CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN ((((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' THEN ((b.NILAI_FIX*A1.QTY*DISC)/100)*A1.QTY END ) NILAI_DISKON_PDP,
                        (CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN (((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY)-(((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' THEN (b.NILAI_FIX*A1.QTY)-((b.NILAI_FIX*A1.QTY*DISC)/100)*A1.QTY END ) as NILAI_PDP,
                        A1.KD_DR AS KD_DR, '' NM_DR,b.NILAI_PROSEN,'0' AS BATAL,'' PETUGAS_BATAL, '' AS JAM_BATAL, B.KD_POSTING AS KD_POSTING,'' as kd_posting_diskon, 0 as ID_TR_TARIF_PAKET
                        FROM Billing_Pasien.DBO.FO_T_BILLING A
                        inner join Billing_Pasien.dbo.FO_T_BILLING_1 A1
                        ON A.NO_TRS_BILLING = A1.NO_TRS_BILLING
                        INNER JOIN RadiologiSQL.dbo.ProcedureRadiology CC 
                        ON CC.Proc_Code collate SQL_Latin1_General_CP1_CI_AS= A1.KODE_TARIF collate SQL_Latin1_General_CP1_CI_AS
                        INNER JOIN Keuangan.DBO.BO_M_PDP2 B
                        ON CC.KD_PDP collate SQL_Latin1_General_CP1_CI_AS = B.KD_PDP collate SQL_Latin1_General_CP1_CI_AS
                        INNER JOIN Keuangan.DBO.BO_M_PDP CX
                        ON CX.KD_PDP = B.KD_PDP
                        WHERE A1.GROUP_ENTRI='RADIOLOGI' and a.BATAL='0' and A1.BATAL='0' and B.KD_TIPE_PDP='RS01' and a.NO_TRS_BILLING=:notrsbill2");
                        $this->db->bind('notrsbill2', $notrsbill);
                        $this->db->execute();

                        //UPDATE TOTAL KE FO_T_BILLING
                        $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_BILLING
                        SET TOTAL_TARIF=B.SUM_NILAI_TARIF,TOTAL_QTY=B.SUM_QTY,SUBTOTAL=B.SUM_SUB_TOTAL,SUBTOTAL_2=B.SUM_SUB_TOTAL_2,GRANDTOTAL=B.SUM_GRANDTOTAL
                        FROM Billing_Pasien.DBO.FO_T_BILLING A 
                        INNER JOIN
                        (
                        SELECT  NO_TRS_BILLING,SUM(NILAI_TARIF) AS SUM_NILAI_TARIF,SUM(QTY) AS SUM_QTY,SUM(SUB_TOTAL) AS SUM_SUB_TOTAL,SUM(SUB_TOTAL_2) AS SUM_SUB_TOTAL_2,
                        SUM(GRANDTOTAL) AS SUM_GRANDTOTAL
                        FROM Billing_Pasien.DBO.FO_T_BILLING_1
                        WHERE NO_REGISTRASI=:noreg and Batal='0'
                        GROUP BY NO_TRS_BILLING
                        ) B
                        ON A.NO_TRS_BILLING = B.NO_TRS_BILLING
                        WHERE A.NO_REGISTRASI=:noreg2 AND A.NO_TRS_BILLING=:notrsbill
                        ");
                        $this->db->bind('noreg', $noreg);
                        $this->db->bind('noreg2', $noreg);
                        $this->db->bind('notrsbill', $notrsbill);
                        $this->db->execute();
                    }

                    $this->db->query("INSERT INTO SysLog.dbo.TZ_Log_Button
                    (noregistrasi, nama_biling, petugas_entry, tgl_entry, idtrs)
                    VALUES (:NoRegRecord, 'APPROVE RADIOLOGI', :USER_KASIRRecord, :TGL_TRSRecord, :trscoderecord)");
                    $this->db->bind('NoRegRecord', $noreg);
                    $this->db->bind('USER_KASIRRecord', $namauserx);
                    $this->db->bind('TGL_TRSRecord', $datenowcreate);
                    $this->db->bind('trscoderecord', $datawo);
                    $this->db->execute();
                }
                //update di visit nya
                $this->db->query("UPDATE PerawatanSQL.dbo.Visit SET RadiologiLunas=1 WHERE NoRegistrasi = :noregvisit1");
                $this->db->bind('noregvisit1', $noreg);
                $this->db->execute();
            } else if ($idbtn == 'cb_btlapproveRadiologyall') {

                //$odid = array();
                $tod = json_decode(json_encode((object) $data['idorderapproveRad']), FALSE);
                foreach ($tod as $datawo) {

                    $this->db->query("SELECT COUNT(ID) AS CEK1payment FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE GROUP_ENTRI = 'RADIOLOGI' AND KODE_REF = :dataref12 AND ID_TRS_Payment IS NOT NULL");
                    $this->db->bind('dataref12', $datawo);
                    $data_CEKpayment =  $this->db->single();
                    $CEKpayment = $data_CEKpayment['CEK1payment'];

                    if ($CEKpayment != '0') {
                        $callback = array(
                            'status' => "warning",
                            'message' => "GAGAL BATAL APPROVE ALL, Karena Ada Orderan Yang Sudah Di Payment!",
                        );
                        return $callback;
                        exit;
                    }

                    $this->db->query("SELECT ACCESSION_NO FROM RadiologiSQL.dbo.WO_RADIOLOGY WHERE WOID = :datawoid2a");
                    $this->db->bind('datawoid2a', $datawo);
                    $data_accnumber =  $this->db->single();
                    $ACC_Number = $data_accnumber['ACCESSION_NO'];

                    $this->db->query("SELECT COUNT(*) as cekRIS FROM RadiologiSQL.dbo.REPORT_RIS WHERE ACCESSION_NO = :ACC_Number");
                    $this->db->bind('ACC_Number', $ACC_Number);
                    $data_countris =  $this->db->single();
                    $COUNT_RIS = $data_countris['cekRIS'];
                    // var_dump($COUNT_RIS);
                    // exit;
                    if ($COUNT_RIS == "0") {
                        //update di visit nya
                        $this->db->query("UPDATE PerawatanSQL.dbo.Visit SET RadiologiLunas=0
                    WHERE NoRegistrasi = :noregvisit2a");
                        $this->db->bind('noregvisit2a', $noreg);
                        $this->db->execute();

                        // var_dump($TRIGGER_DTTM);
                        // exit;

                        //update ke WO_radiology nya
                        $this->db->query("UPDATE RadiologiSQL.dbo.WO_RADIOLOGY SET PaymentStatus = 0, Batal = '1', TglBatal = :TGL_TRSx, PetugasBatal = :USER_KASIRx WHERE WOID=:datawoid2a");
                        $this->db->bind('datawoid2a', $datawo);
                        $this->db->bind('USER_KASIRx', $namauserx);
                        $this->db->bind('TGL_TRSx', $datenowcreate);
                        $this->db->execute();

                        //batal radiology

                        // MWLWL
                        $this->db->query("UPDATE RadiologiSQL.DBO.MWLWL 
                    SET REPLICA_DTTM = 'ANY', SCHEDULED_PROC_STATUS ='0'
                    WHERE  ACCESSION_NO=:accession_no ");
                        $this->db->bind('accession_no', $ACC_Number);
                        $this->db->execute();

                        // INSERT 
                        $this->db->query("INSERT INTO RadiologiSQL.DBO.MWLWL ( TRIGGER_DTTM, REPLICA_DTTM, EVENT_TYPE, CHARACTER_SET, SCHEDULED_AETITLE, SCHEDULED_DTTM, SCHEDULED_MODALITY, SCHEDULED_STATION, SCHEDULED_LOCATION,         SCHEDULED_PROC_ID, SCHEDULED_PROC_DESC, SCHEDULED_ACTION_CODES, SCHEDULED_PROC_STATUS, PREMEDICATION, CONTRAST_AGENT, REQUESTED_PROC_ID, REQUESTED_PROC_DESC, REQUESTED_PROC_CODES, REQUESTED_PROC_PRIORITY,        REQUESTED_PROC_REASON, REQUESTED_PROC_COMMENTS, STUDY_INSTANCE_UID, PROC_PLACER_ORDER_NO, PROC_FILLER_ORDER_NO, ACCESSION_NO, ATTEND_DOCTOR, PERFORM_DOCTOR, CONSULT_DOCTOR, REQUEST_DOCTOR, REFER_DOCTOR,      REQUEST_DEPARTMENT, IMAGING_REQUEST_REASON, IMAGING_REQUEST_COMMENTS, IMAGING_REQUEST_DTTM, ISR_PLACER_ORDER_NO, ISR_FILLER_ORDER_NO, ADMISSION_ID, PATIENT_TRANSPORT, PATIENT_LOCATION, PATIENT_RESIDENCY,      PATIENT_NAME, PATIENT_ID, OTHER_PATIENT_NAME, OTHER_PATIENT_ID, PATIENT_BIRTH_DATE, PATIENT_SEX, PATIENT_WEIGHT, PATIENT_SIZE, PATIENT_STATE, CONFIDENTIALITY, PREGNANCY_STATUS, MEDICAL_ALERTS,     CONTRAST_ALLERGIES, SPECIAL_NEEDS, SPECIALTY, DIAGNOSIS, ADMIT_DTTM, REGISTER_DTTM, [Match], ORDERCODE, EXPERTISE )
                    SELECT '$TRIGGER_DTTM', 'ANY' AS REPLICA_DTTM, EVENT_TYPE, CHARACTER_SET, SCHEDULED_AETITLE, SCHEDULED_DTTM, SCHEDULED_MODALITY, SCHEDULED_STATION, SCHEDULED_LOCATION, SCHEDULED_PROC_ID,      SCHEDULED_PROC_DESC, SCHEDULED_ACTION_CODES, '120'AS SCHEDULED_PROC_STATUS, PREMEDICATION, CONTRAST_AGENT, REQUESTED_PROC_ID, REQUESTED_PROC_DESC, REQUESTED_PROC_CODES, REQUESTED_PROC_PRIORITY,       REQUESTED_PROC_REASON, REQUESTED_PROC_COMMENTS, STUDY_INSTANCE_UID, PROC_PLACER_ORDER_NO, PROC_FILLER_ORDER_NO, ACCESSION_NO, ATTEND_DOCTOR, PERFORM_DOCTOR, CONSULT_DOCTOR, REQUEST_DOCTOR, REFER_DOCTOR,         REQUEST_DEPARTMENT, IMAGING_REQUEST_REASON, IMAGING_REQUEST_COMMENTS, IMAGING_REQUEST_DTTM, ISR_PLACER_ORDER_NO, ISR_FILLER_ORDER_NO, ADMISSION_ID, PATIENT_TRANSPORT, PATIENT_LOCATION, PATIENT_RESIDENCY,         PATIENT_NAME, PATIENT_ID, OTHER_PATIENT_NAME, OTHER_PATIENT_ID, PATIENT_BIRTH_DATE, PATIENT_SEX, PATIENT_WEIGHT, PATIENT_SIZE, PATIENT_STATE, CONFIDENTIALITY, PREGNANCY_STATUS, MEDICAL_ALERTS,        CONTRAST_ALLERGIES, SPECIAL_NEEDS, SPECIALTY, DIAGNOSIS, ADMIT_DTTM, REGISTER_DTTM, Match, ORDERCODE, EXPERTISE
                    FROM RadiologiSQL.DBO.MWLWL
                    WHERE ACCESSION_NO=:accession_no");
                        $this->db->bind('accession_no', $ACC_Number);
                        $this->db->execute();
                    } else {
                        $callback = array(
                            'status' => "warning",
                            'message' => "Order Sudah Ada Hasil !",
                        );
                        return $callback;
                        exit;
                    }

                    $this->db->query("SELECT KODE_TARIF, NO_TRS_BILLING from Billing_Pasien.dbo.FO_T_BILLING_1 where ID_BILL = :noACC and KODE_REF = :dataWO");
                    $this->db->bind('noACC', $ACC_Number);
                    $this->db->bind('dataWO', $datawo);
                    $data_kodetarifrad =  $this->db->single();
                    $kodetrfrad = $data_kodetarifrad['KODE_TARIF'];
                    $trsrad = $data_kodetarifrad['NO_TRS_BILLING'];
                    // exit;
                    $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 SET BATAL = '1' WHERE ID_BILL = :noACC1a AND KODE_REF = :dataWO1a");
                    $this->db->bind('noACC1a', $ACC_Number);
                    $this->db->bind('dataWO1a', $datawo);
                    $this->db->execute();

                    $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_2 SET BATAL = '1' WHERE ID_BILL = :noACC1b AND KODE_TARIF = :kodetrfrad1a");
                    $this->db->bind('noACC1b', $ACC_Number);
                    $this->db->bind('kodetrfrad1a', $kodetrfrad);
                    $this->db->execute();

                    $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_BILLING
                        SET TOTAL_TARIF=B.SUM_NILAI_TARIF,TOTAL_QTY=B.SUM_QTY,SUBTOTAL=B.SUM_SUB_TOTAL,SUBTOTAL_2=B.SUM_SUB_TOTAL_2,GRANDTOTAL=B.SUM_GRANDTOTAL,
                        FB_VERIF_JURNAL='0' 
                        FROM Billing_Pasien.DBO.FO_T_BILLING A 
                        INNER JOIN
                        (
                            SELECT  NO_TRS_BILLING,SUM(NILAI_TARIF) AS SUM_NILAI_TARIF,SUM(QTY) AS SUM_QTY,SUM(SUB_TOTAL) AS SUM_SUB_TOTAL,SUM(SUB_TOTAL_2) AS SUM_SUB_TOTAL_2,
                            SUM(GRANDTOTAL) AS SUM_GRANDTOTAL
                            FROM Billing_Pasien.DBO.FO_T_BILLING_1
                            WHERE NO_REGISTRASI=:noreg and Batal='0'
                            GROUP BY NO_TRS_BILLING
                        ) B
                        ON A.NO_TRS_BILLING = B.NO_TRS_BILLING
                        WHERE A.NO_REGISTRASI=:noreg2 AND A.NO_TRS_BILLING=:notrsbill
                        ");
                    $this->db->bind('noreg', $noreg);
                    $this->db->bind('noreg2', $noreg);
                    $this->db->bind('notrsbill', $trsrad);
                    $this->db->execute();
                    $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING SET BATAL = '1' WHERE NO_REGISTRASI = :noregfinis and NO_TRS_BILLING=:trsrad1");
                    $this->db->bind('noregfinis', $noreg);
                    $this->db->bind('trsrad1', $trsrad);
                    $this->db->execute();

                    $this->db->query("UPDATE SysLog.dbo.TZ_Log_Button SET petugas_batal = :USER_KASIRRecord, alasan_batal = 'BATAL APPROVE', tgl_batal = :TGL_TRSRecord
                    WHERE NoRegistrasi = :NoRegRecord AND idtrs = :dataaptk1 AND petugas_batal IS NULL");
                    $this->db->bind('NoRegRecord', $noreg);
                    // $this->db->bind('trscoderecord', $trscode);
                    $this->db->bind('USER_KASIRRecord', $namauserx);
                    $this->db->bind('TGL_TRSRecord', $datenowcreate);
                    $this->db->bind('dataaptk1', $datawo);
                    $this->db->execute();
                }
            } else {
                $callback = array(
                    'status' => "warning",
                    'message' => "Something Wrong !",
                );
                return $callback;
                exit;
            }

            $this->db->commit();
            $callback = array(
                'status' => "success",
                'message' => "Berhasil Melakukan Transaksi", // Set array nama 

            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }


    public function getTindakanRajal($data)
    {
        try {
            $idunit = $data['idunit'];
            $groupjaminan = $data['groupjaminan'];

            $this->db->query("SELECT ID,[Product Name] from PerawatanSQL.dbo.Tarif_RJ_UGD
             where Group_Jaminan=:groupjaminan and PacsOrder='0' and discontinue='0' and
             CodeUNIT in (select CodeUNIT from MasterdataSQL.dbo.MstrUnitPerwatan where ID=:idunit) order by [Product Name] asc");
            $this->db->bind('idunit', $idunit);
            $this->db->bind('groupjaminan', $groupjaminan);
            $data =  $this->db->resultSet();
            //$this->db->closeCon();
            $rows = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['ProductName'] = $key['Product Name'];
                $rows[] = $pasing;
            }
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $rows
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function getTindakanRanap($data)
    {
        try {
            $groupjaminan = $data['groupjaminan'];

            $this->db->query("SELECT ID,[Product Name]
                             from RawatInapSQL.dbo.Tarif_RI where Group_Jaminan=:groupjaminan");
            $this->db->bind('groupjaminan', $groupjaminan);
            $data =  $this->db->resultSet();
            //$this->db->closeCon();
            $rows = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['ProductName'] = $key['Product Name'];
                $rows[] = $pasing;
            }
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $rows
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function getTarifTindakanRanap($data)
    {
        try {
            $id = $data['id'];
            $IDKelas = $data['IDKelas'];

            $this->db->query("SELECT ID,[Product Name],CategoryProduct,
                        case when '$IDKelas' = '3' then Tarifkelas3
                            when '$IDKelas' = '2' then Tarifkelas2
                            when '$IDKelas' = '1' or '$IDKelas' = '7' or '$IDKelas' = '11' then Tarifkelas1
                            when '$IDKelas' = '4' then TarifVIP
                            when '$IDKelas' = '5' then TarifSVIP
                            when '$IDKelas' = '6' then TarifPresidenSuite
                            when '$IDKelas' = '8' or '$IDKelas' = '9' or '$IDKelas' = '10' or '$IDKelas' = '12' then TarifICU
                            end as GetTarif
                             from RawatInapSQL.dbo.Tarif_RI where ID=:id");
            $this->db->bind('id', $id);
            $key =  $this->db->single();
            $pasing['ID'] = $key['ID'];
            $pasing['ProductName'] = $key['Product Name'];
            $pasing['CategoryProduct'] = $key['CategoryProduct'];
            $pasing['GetTarif'] = $key['GetTarif'];

            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function getTarifTindakanRajal($data)
    {
        try {
            $id = $data['id'];

            $this->db->query("SELECT ID,[Product Name],CategoryProduct,TarifRS
                             from PerawatanSQL.dbo.Tarif_RJ_UGD where ID=:id");
            $this->db->bind('id', $id);
            $key =  $this->db->single();
            $pasing['ID'] = $key['ID'];
            $pasing['ProductName'] = $key['Product Name'];
            $pasing['CategoryProduct'] = $key['CategoryProduct'];
            $pasing['GetTarif'] = $key['TarifRS'];

            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function getDataDetailBillbyID($data)
    {
        try {
            $id = $data['ID_BILL'];

            $this->db->query("SELECT ID,NAMA_TARIF,NO_TRS_BILLING,KD_KELAS,NILAI_TARIF,SUB_TOTAL,DISC,DISC_RP,KD_DR,QTY
                             from Billing_Pasien.dbo.FO_T_BILLING_2
                             inner join Billing_Pasien.dbo.FO_T_BILLING_1   where ID_BILL=:id");
            $this->db->bind('id', $id);
            $key =  $this->db->single();
            $pasing['ID'] = $key['ID'];
            $pasing['NO_TRS_BILLING'] = $key['NO_TRS_BILLING'];
            $pasing['NAMA_TARIF'] = $key['NAMA_TARIF'];
            $pasing['KD_KELAS'] = $key['KD_KELAS'];
            $pasing['NILAI_TARIF'] = $key['NILAI_TARIF'];

            $pasing['SUB_TOTAL'] = $key['SUB_TOTAL'];
            $pasing['DISC'] = $key['DISC'];
            $pasing['DISC_RP'] = $key['DISC_RP'];
            // $pasing['GRANDTOTAL'] = $key['GRANDTOTAL'];

            // $pasing['TGL_BILLING'] = $key['TGL_BILL'];
            $pasing['KD_DR'] = $key['KD_DR'];
            $pasing['QTY'] = $key['QTY'];

            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function goBatalDetailBillbyID($data)
    {
        try {
            $this->db->transaksi();

            $ID = $data['ID'];
            $alasan = $_POST['alasan'];

            //Cek Group Entri
            $this->db->query("SELECT GROUP_ENTRI
             FROM Billing_Pasien.dbo.FO_T_BILLING_1
             WHERE ID=:ID");
            $this->db->bind('ID', $ID);
            $groupentri = $this->db->single();

            if ($groupentri == 'LABORATORIUM') {
                $this->BatalDtlLab($ID);
            }


            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $namauserx = $session->name;

            //update fo_t_billing_1
            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 set 
            PETUGAS_BATAL=:namauserx,BATAL='1',JAM_BATAL=:datenowcreate
            where ID=:ID");
            $this->db->bind('ID', $ID);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('namauserx', $namauserx);
            $this->db->execute();

            //update fo_t_billing_2
            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_2 set 
           PETUGAS_BATAL=:namauserx,BATAL='1',JAM_BATAL=:datenowcreate
           FROM Billing_Pasien.dbo.FO_T_BILLING_2 c 
           inner join Billing_Pasien.dbo.FO_T_BILLING_1 d on c.NO_TRS_BILLING=d.NO_TRS_BILLING
           where d.ID=:ID");
            $this->db->bind('ID', $ID);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('namauserx', $namauserx);
            $this->db->execute();

            //UPDATE TOTAL KE FO_T_BILLING
            $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_BILLING
          SET TOTAL_TARIF=B.SUM_NILAI_TARIF,TOTAL_QTY=B.SUM_QTY,SUBTOTAL=B.SUM_SUB_TOTAL,SUBTOTAL_2=B.SUM_SUB_TOTAL_2,GRANDTOTAL=B.SUM_GRANDTOTAL,FB_VERIF_JURNAL='0'
          FROM Billing_Pasien.DBO.FO_T_BILLING A 
          INNER JOIN
          (
              SELECT  NO_TRS_BILLING,SUM(NILAI_TARIF) AS SUM_NILAI_TARIF,SUM(QTY) AS SUM_QTY,SUM(SUB_TOTAL) AS SUM_SUB_TOTAL,SUM(SUB_TOTAL_2) AS SUM_SUB_TOTAL_2,
              SUM(GRANDTOTAL) AS SUM_GRANDTOTAL
              FROM Billing_Pasien.DBO.FO_T_BILLING_1
              WHERE NO_TRS_BILLING IN (SELECT NO_TRS_BILLING FROM Billing_Pasien.DBO.FO_T_BILLING_1 Where ID=:ID) and Batal='0'
              GROUP BY NO_TRS_BILLING
          ) B
          ON A.NO_TRS_BILLING = B.NO_TRS_BILLING
          WHERE A.NO_REGISTRASI in (SELECT NO_REGISTRASI FROM Billing_Pasien.DBO.FO_T_BILLING_1 WHERE ID=:ID2) AND A.NO_TRS_BILLING in (SELECT NO_TRS_BILLING FROM Billing_Pasien.DBO.FO_T_BILLING_1 Where ID=:ID3)
          ");
            $this->db->bind('ID', $ID);
            $this->db->bind('ID2', $ID);
            $this->db->bind('ID3', $ID);
            $this->db->execute();
            //var_dump('asd');exit;


            //Insert ke Tz_Log_Button
            $namaaction = 'Hapus Billing Detail';
            $sql = "INSERT INTO  SysLog.dbo.TZ_Log_Button (idtrs,noregistrasi,nama_biling,tgl_entry,petugas_entry,petugas_batal,tgl_batal,alasan_batal)
          ( SELECT ID , NO_REGISTRASI,'$namaaction' as NamaAction,TGL_BILLING,  PETUGAS_ENTRY,PETUGAS_BATAL,JAM_BATAL,'$alasan'
          FROM Billing_Pasien.DBO.FO_T_BILLING_1
                WHERE ID=:ID )";
            $this->db->query($sql);
            $this->db->bind('ID', $ID);
            $this->db->execute();

            $this->db->commit();



            $callback = array(
                'status' => 'success',
                'message' => 'Batal Berhasil',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        } finally {
            //Cek JIKA di detailnya batal semua maka yang di header batal juga
            $this->db->query("SELECT ID
                FROM Billing_Pasien.dbo.FO_T_BILLING_1
                WHERE NO_TRS_BILLING in (SELECT NO_TRS_BILLING FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE ID=:ID) AND BATAL='0'");
            $this->db->bind('ID', $ID);
            $getData = $this->db->resultSet();
            $productCount = count($getData);

            if ($productCount == 0) {
                $this->executeBatalHDR($ID);
            }
        }
    }

    private function executeBatalHDR($data)
    {
        try {
            $this->db->transaksi();
            //var_dump($data,$data['ID']);exit;
            $ID = $data;
            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $namauserx = $session->name;

            //update fo_t_billing
            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING set 
                PETUGAS_BATAL=:namauserx,BATAL='1',JAM_BATAL=:datenowcreate,FB_VERIF_JURNAL='0'
                FROM Billing_Pasien.dbo.FO_T_BILLING c 
                inner join Billing_Pasien.dbo.FO_T_BILLING_1 d on c.NO_TRS_BILLING=d.NO_TRS_BILLING
                where d.ID=:ID");
            $this->db->bind('ID', $ID);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('namauserx', $namauserx);
            $this->db->execute();


            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Batal Header Berhasil',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    private function BatalDtlLab($data)
    {
        try {
            $this->db->transaksi();

            $ID = $data;

            // DETIL LAB Batal
            $this->db->query("UPDATE LaboratoriumSQL.dbo.tblLabDetail set 
        status_ts='1',Batal='1'
        where LabDetailID in (SELECT KODE_REF FROM Billing_Pasien_1 WHERE ID=:ID)");
            $this->db->bind('ID', $ID);
            $this->db->execute();

            // DETIL LIS ORDER Batal
            $this->db->query("UPDATE LaboratoriumSQL.dbo.LIS_Order_detail set 
        status_ts=:datasatu
        where NoLab=:NoLabOrderBatal and kode_test in (
        select kode_test from LaboratoriumSQL.dbo.tblLabDetail
        where LabID in (SELECT LabID FROM LaboratoriumSQL.dbo.tblLab WHERE NoLab=:NoLabOrderBatal2)  ) ");
            $this->db->bind('ID', $ID);
            $this->db->execute();


            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Batal Header Berhasil',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function getPaymentType()
    {
        try {
            $this->db->query("SELECT ID,PaymentType,Account from PerawatanSQL.dbo.PaymentType where Status='1' --AND ID NOT IN (15)");
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['PaymentType'] = $key['PaymentType'];
                $pasing['Account'] = $key['Account'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getPaymentTypevoucher()
    {
        try {
            $this->db->query("SELECT ID,PaymentType,Account from PerawatanSQL.dbo.PaymentType where Status='1' ");
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['PaymentType'] = $key['PaymentType'];
                $pasing['Account'] = $key['Account'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getPaymentTypeNohutang()
    {
        try {
            $this->db->query("SELECT ID,PaymentType,Account from PerawatanSQL.dbo.PaymentType where Status='1' AND ID NOT IN (16,15,5,8,9)");
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['PaymentType'] = $key['PaymentType'];
                $pasing['Account'] = $key['Account'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getPaymentTypeREKENING()
    {
        try {
            $this->db->query("SELECT FS_KD_REKENING, FS_KD_REKENING_GROUP, FS_NM_REKENING FROM Keuangan.dbo.TM_REKENING where FS_KD_REKENING_GROUP in ('KAS','BANK (IDR)','BANK (US)') and AKTIF='1' and GROUP_REK='4'");
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['FS_KD_REKENING'] = $key['FS_KD_REKENING'];
                $pasing['FS_KD_REKENING_GROUP'] = $key['FS_KD_REKENING_GROUP'];
                $pasing['FS_NM_REKENING'] = $key['FS_NM_REKENING'];
                // $pasing['ID'] = $key['ID'];
                // $pasing['PaymentType'] = $key['PaymentType'];
                // $pasing['Account'] = $key['Account'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getEDC($data)
    {
        try {
            if ($data['tipekartu'] == 'Kartu Debit') {
                $tipekartu = 'DEBET';
            } else if ($data['tipekartu'] == 'Kartu Kredit') {
                $tipekartu = 'KREDIT';
            } else {
                $tipekartu = null;
            }


            $this->db->query("SELECT ID,NAMA_BANK,KD_REKENING,VALUE_SIMRS from MasterdataSQL.DBO.Card_Types where STATUS='1' and TIPE_KARTU=:tipekartu");
            $this->db->bind('tipekartu', $tipekartu);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['NAMA_BANK'] = $key['NAMA_BANK'];
                $pasing['KD_REKENING'] = $key['KD_REKENING'];
                $pasing['VALUE_SIMRS'] = $key['VALUE_SIMRS'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getKodeRekening($data)
    {
        try {
            $tipepembayaran = $data['tipekartu'];
            $pasien = $data['pasien'];
            $namabank = $data['namabank'];
            $idjaminan = $data['idjaminan'];
            //var_dump($idjaminan,$tipepembayaran);exit;

            if ($tipepembayaran == 'Piutang Asuransi') {
                $query = "SELECT Rekening as FS_KD_REKENING FROM MasterdataSQL.dbo.MstrPerusahaanAsuransi where ID=:idjaminan";
                $this->db->query($query);
                $this->db->bind('idjaminan', $idjaminan);
            } elseif ($tipepembayaran == 'Piutang Perusahaan') {
                $query = "SELECT Rekening as FS_KD_REKENING FROM MasterdataSQL.dbo.MstrPerusahaanJPK where ID=:idjaminan";
                $this->db->query($query);
                $this->db->bind('idjaminan', $idjaminan);
            } elseif ($tipepembayaran == 'Tunai') {
                if ($pasien == 'RAJAL') {
                    $query = "SELECT rekening as FS_KD_REKENING FROM Keuangan.dbo.TZ_Parameter_Keu where ID='8'";
                    $this->db->query($query);
                } elseif ($pasien == 'RANAP') {
                    $query = "SELECT rekening as FS_KD_REKENING FROM Keuangan.dbo.TZ_Parameter_Keu where ID='9'";
                    $this->db->query($query);
                }
            } elseif ($tipepembayaran == 'Setor Bank') {
                $query = "SELECT rekening as FS_KD_REKENING FROM Keuangan.dbo.TZ_Parameter_Keu where ID='11'";
                $this->db->query($query);
            } elseif ($tipepembayaran == 'Transfer Bank') {
                $query = "SELECT rekening as FS_KD_REKENING FROM Keuangan.dbo.TZ_Parameter_Keu where ID='12'";
                $this->db->query($query);
            } elseif ($tipepembayaran == 'Piutang Rawat Inap') {
                $query = "SELECT rekening as FS_KD_REKENING FROM Keuangan.dbo.TZ_Parameter_Keu where ID='10'";
                $this->db->query($query);
            } elseif ($tipepembayaran == 'Kartu Debit') {
                $query = "SELECT KD_REKENING as FS_KD_REKENING from MasterdataSQL.DBO.Card_Types where STATUS='1' and TIPE_KARTU='DEBET' and VALUE_SIMRS='$namabank'";
                $this->db->query($query);
            } elseif ($tipepembayaran == 'Kartu Kredit') {
                $query = "SELECT KD_REKENING as FS_KD_REKENING from MasterdataSQL.DBO.Card_Types where STATUS='1' and TIPE_KARTU='KREDIT' and VALUE_SIMRS='$namabank'";
                $this->db->query($query);
            } elseif ($tipepembayaran == 'Voucher') {
                $query = "SELECT rekening as FS_KD_REKENING FROM Keuangan.dbo.TZ_Parameter_Keu where ID='13'";
                $this->db->query($query);
            } else {
                $query = "SELECT rekening as FS_KD_REKENING FROM Keuangan.dbo.TZ_Parameter_Keu where 1=0";
                $this->db->query($query);
            }

            $key =  $this->db->single();
            $pasing['FS_KD_REKENING'] = $key['FS_KD_REKENING'];

            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function SaveTrsPayment($data)
    {
        try {
            // var_dump($data);
            // exit;
            $this->db->transaksi();
            $count_array = count($data['tipepembayaran']);
            $terimapembayaran = array_sum(str_replace(".", "", $data['totalinput']));
            $totalhargadumi = str_replace(".", "", $data['totalharga']);
            $yangharusdibayar = str_replace(".", "", $data['totalbayar']);
            // $totalhargadumi = $data['totalharga'];

            if ($terimapembayaran <> $yangharusdibayar) {
                $callback = array(
                    'status' => 'eror',
                    'message' => 'Hasil input tidak matching dengan total harga !',
                );
                return $callback;
                exit;
            }

            $totalinput = str_replace(".", "", $data['totalinput']);

            $tipepembayaran = $data['tipepembayaran'];

            //var_dump($count_array);exit;
            $NoMR = $data['NoMR'];
            $NoEpisode = $data['NoEpisode'];
            $NoRegistrasi = $data['NoRegistrasi'];
            $tgl_payment = $data['tglpayment'];
            $TypePatientID = $data['TypePatientID'];

            $bilito1 = $data['billtox'];
            $kodejaminan = $data['kodejaminan'];
            $kd_rekening = $data['kd_rekening'];
            // $namabank = $data['namabank'];
            $expired = $data['expired'];
            $nokartu = $data['nokartu'];
            $bilito = $data['billto'];


            //total cash, debit, kredit
            // $terimapembayaran = array_sum(str_replace(".", "", $data['totalinput']));


            $notrsfo = implode(',', $data['idbillingdtl']);
            $tod = json_decode(json_encode((object) $data['idbillingdtl']), FALSE);


            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $namauserx = $session->name;
            $iduserx = $session->IDEmployee;
            $kodereg = $data['kodereg'];

            // var_dump($tgl_payment);
            // exit;

            $this->db->query("SELECT [Status ID] AS statuspasien FROM PerawatanSQL.dbo.visit WHERE NoRegistrasi = :norega1 UNION ALL SELECT StatusID AS statuspasien FROM RawatInapSQL.dbo.Inpatient WHERE NoRegRI = :norega2");
            $this->db->bind('norega1', $data['NoRegistrasi']);
            $this->db->bind('norega2', $data['NoRegistrasi']);
            $statuscek =  $this->db->single();
            $statuspasien = $statuscek['statuspasien'];

            if ($statuspasien == '4') {
                $callback = array(
                    'status' => "eror", // Set array nama
                    'message' => "Gagal Simpan, Status Pasien Sudah Close"
                );
                return $callback;
                exit;
            }



            $this->db->query("SELECT StatusActive FROM RawatInapSQL.dbo.Inpatient_in_out a
            INNER JOIN Billing_Pasien.dbo.FO_T_BILLING_1 b ON a.ID = b.ID_BILL 
            WHERE NO_REGISTRASI=:NoRegistrasi AND GROUP_TARIF='Kamar' AND b.ID IN ($notrsfo)");
            $this->db->bind('NoRegistrasi', $NoRegistrasi);
            // $this->db->bind('notrsfo312', $notrsfo);
            $datakamar =  $this->db->single();
            $StatusActive = $datakamar['StatusActive'];

            if ($StatusActive == "1") {
                $callback = array(
                    'status' => 'eror',
                    'message' => 'Gagal Payment, Karena Status Kamar Masih Aktif !',
                );
                return $callback;
                exit;
            }

            // $kodebank = $data['kodebank'];
            // $nokartu = $data['nokartu'];
            // $billtohiden = $data['billtohiden'];



            //GENERATE NO TRS HDR
            //GET URUT

            if ($kodereg == 'RI') {
                $this->db->query("UPDATE RawatInapSQL.dbo.Inpatient SET StatusID = '2' WHERE NoRegRI = :NoRegistrasixr");
                $this->db->bind('NoRegistrasixr', $NoRegistrasi);
                $this->db->execute();
            } else {
                $this->db->query("UPDATE PerawatanSQL.dbo.Visit SET [Status ID] = '2' WHERE NoRegistrasi = :NoRegistrasixr");
                $this->db->bind('NoRegistrasixr', $NoRegistrasi);
                $this->db->execute();
            }

            $datenowlis = date('dmy', strtotime($datenowcreate));
            $this->db->query("SELECT  max(NO_TRS) as nourut from Billing_Pasien.dbo.FO_T_KASIR WHERE SUBSTRING(NO_TRS, 4, 6)=:datenowlis ");
            $this->db->bind('datenowlis',   $datenowlis);
            $data =  $this->db->single();
            $nourut = $data['nourut'];
            $substringlis = substr($nourut, 9);
            if ($substringlis == null) {
                $substringlis = 0;
            }
            $substringlis++;
            if (strlen($substringlis) == 1) {
                $nourutfixLis = "00" . $substringlis;
            } else if (strlen($substringlis) == 2) {
                $nourutfixLis = "0" . $substringlis;
            } else if (strlen($substringlis) == 3) {
                $nourutfixLis = $substringlis;
            }

            $ID_TR_TARIF = 'TRS' . $datenowlis . $nourutfixLis;
            //#END GENERATE NO TRS HDR

            //GENERATE NO KWITANSI
            //untuk kode awal no NoKwitansi
            if ($TypePatientID == "1") {
                $kodeawal = "KUJ";
            } else {
                $kodeawal = "PRJ";
            }
            // $kodetengah = date('dmy');//untuk kode tengah no NoKwitansi
            $kodetengah = date('dmy', strtotime($tgl_payment));
            //cek no urut kwitansi

            //GET URUT
            $this->db->query("SELECT  TOP 1 NO_KWITANSI,right(NO_KWITANSI,4) as urutkwitansi
            FROM Billing_Pasien.dbo.FO_T_KASIR
            WHERE replace(CONVERT(VARCHAR(11), TGL_TRS, 111), '/','-')=:tgl_payment AND LEFT(NO_KWITANSI,3)=:kodeawal ORDER BY right(NO_KWITANSI,4) DESC");
            $this->db->bind('tgl_payment',   $tgl_payment);
            $this->db->bind('kodeawal',   $kodeawal);
            $data =  $this->db->single();
            $nourutkwitansi = $data['urutkwitansi'];
            //var_dump($tgl_payment,$kodeawal);exit;

            if (empty($nourutkwitansi)) {
                //jika gk ada record
                $nourutkwitansi = "0001";
            } else {
                //jika ada record
                $nourutkwitansi++;
            }

            if (strlen($nourutkwitansi) == 1) {
                $nourutfixKwitansi = "000" . $nourutkwitansi;
            } else if (strlen($nourutkwitansi) == 2) {
                $nourutfixKwitansi = "00" . $nourutkwitansi;
            } else if (strlen($nourutkwitansi) == 3) {
                $nourutfixKwitansi = "0" . $nourutkwitansi;
            } else if (strlen($nourutkwitansi) == 4) {
                $nourutfixKwitansi = $nourutkwitansi;
            }

            $nofinalkwitansi = $kodeawal . '-' . $kodetengah . '-' . $nourutfixKwitansi;

            // var_dump('taiiii');
            // exit;

            //#END GENERATE KWITANSI
            $this->db->query("INSERT INTO Billing_Pasien.dbo.FO_T_KASIR (
                [NO_TRS]
               ,[NO_KWITANSI]
                ,[NO_EPISODE]
                ,[NO_REGISTRASI]
                ,[NO_MR]
               ,[TGL_TRS]
               ,[KODE_KASIR]
               ,[USER_KASIR]
               ,[NOMINAL_BAYAR]
               ,[CASH]
               ,[DEBIT]
               ,[KREDIT]
               ,[BATAL]
               ,[TGL_BATAL]
               ,[USER_BATAL]
               ,[ALASAN_BATAL]
               ,[USER_LAST]
                ,[TGL_TRS_LAST]
               ,[BILLTO]
                ) values (
                :NO_TRS
                ,:NO_KWITANSI
                ,:NO_EPISODE
                ,:NO_REGISTRASI
                ,:NO_MR
                ,:TGL_TRS
                ,:KODE_KASIR
                ,:USER_KASIR
                ,:NOMINAL_BAYAR
                ,:CASH
                ,:DEBIT
                ,:KREDIT
                ,:BATAL
                ,:TGL_BATAL
                ,:USER_BATAL
                ,:ALASAN_BATAL
                ,:USER_LAST
                ,:TGL_TRS_LAST
                ,:BILLTO
                )");
            $this->db->bind('NO_TRS', $ID_TR_TARIF);
            $this->db->bind('NO_KWITANSI', $nofinalkwitansi);
            $this->db->bind('NO_EPISODE', $NoEpisode);
            $this->db->bind('NO_REGISTRASI', $NoRegistrasi);
            $this->db->bind('NO_MR', $NoMR);
            $this->db->bind('TGL_TRS', $tgl_payment);
            $this->db->bind('KODE_KASIR', $iduserx);
            $this->db->bind('USER_KASIR', $namauserx);
            $this->db->bind('NOMINAL_BAYAR', $terimapembayaran);
            $this->db->bind('CASH', 0);
            $this->db->bind('DEBIT', 0);
            $this->db->bind('KREDIT', 0);
            $this->db->bind('BATAL', '0');
            $this->db->bind('TGL_BATAL', '');
            $this->db->bind('USER_BATAL', '');
            $this->db->bind('ALASAN_BATAL', '');
            $this->db->bind('USER_LAST', $iduserx);
            $this->db->bind('TGL_TRS_LAST', $datenowcreate);
            $this->db->bind('BILLTO', $bilito1);
            $this->db->execute();



            //INSERT TABEL PAYMENT DTL
            for ($i = 0; $i < $count_array; $i++) {

                //GENERATE NO TRS DTL
                //GET URUT
                $datenowlis = date('dmy', strtotime($datenowcreate));
                $this->db->query("SELECT  max(NO_TRS) as nourut from Billing_Pasien.dbo.FO_T_KASIR_2 WHERE SUBSTRING(NO_TRS, 5, 6)=:datenowlis ");
                $this->db->bind('datenowlis',   $datenowlis);
                $data =  $this->db->single();
                $nourut = $data['nourut'];
                $substringlis = substr($nourut, 10);
                if ($substringlis == null) {
                    $substringlis = 0;
                }
                $substringlis++;
                if (strlen($substringlis) == 1) {
                    $nourutfixLis = "00" . $substringlis;
                } else if (strlen($substringlis) == 2) {
                    $nourutfixLis = "0" . $substringlis;
                } else if (strlen($substringlis) == 3) {
                    $nourutfixLis = $substringlis;
                }

                $ID_TR_TARIF_DTL = 'TRSD' . $datenowlis . $nourutfixLis;
                //#END GENERATE NO TRS DTL

                $this->db->query("INSERT INTO Billing_Pasien.[dbo].[FO_T_KASIR_2]
                ([NO_TRS], [NO_TRS_REFF], [NOMINAL_BAYAR], [TIPE_PEMBAYARAN], [kode_Tipe_Reff] , [NAMA_TIPE_PEMBAYARAN], [NO_KARTU_REFRENSI], [EXPIRED_DATE])
                VALUES (:NO_TRS, :NO_TRS_REFF, :NOMINAL_BAYAR, :TIPE_PEMBAYARAN, :kode_Tipe_Reff, :NAMA_TIPE_PEMBAYARAN, :NO_KARTU_REFRENSI, :EXPIRED_DATE)");
                $this->db->bind('NO_TRS', $ID_TR_TARIF_DTL);
                $this->db->bind('NO_TRS_REFF', $ID_TR_TARIF);
                $this->db->bind('NOMINAL_BAYAR', $totalinput[$i]);
                $this->db->bind('TIPE_PEMBAYARAN', $tipepembayaran[$i]);
                $this->db->bind('kode_Tipe_Reff', $kodejaminan[$i]);
                // $this->db->bind('kode_Tipe_Reff', $kd_rekening[$i]);
                $this->db->bind('NAMA_TIPE_PEMBAYARAN', $bilito[$i]);
                $this->db->bind('NO_KARTU_REFRENSI', $nokartu[$i]);
                $this->db->bind('EXPIRED_DATE', $expired[$i]);
                $this->db->execute();

                // var_dump('ta');
                // exit;
            }

            $this->db->query("SELECT SUM(NOMINAL_BAYAR) as totalbayar FROM Billing_Pasien.[dbo].[FO_T_KASIR_2] WHERE NO_TRS_REFF = :ID_TR_TARIF1 AND TIPE_PEMBAYARAN = 'TUNAI'");
            $this->db->bind('ID_TR_TARIF1', $ID_TR_TARIF);
            $dataxc =  $this->db->single();
            $total_bayar_cash = $dataxc['totalbayar'];

            $this->db->query("SELECT SUM(NOMINAL_BAYAR) as totalbayar FROM Billing_Pasien.[dbo].[FO_T_KASIR_2] WHERE NO_TRS_REFF = :ID_TR_TARIF2 AND TIPE_PEMBAYARAN = 'Kartu Debit'");
            $this->db->bind('ID_TR_TARIF2', $ID_TR_TARIF);
            $dataxd =  $this->db->single();
            $total_bayar_debit = $dataxd['totalbayar'];

            $this->db->query("SELECT SUM(NOMINAL_BAYAR) as totalbayar FROM Billing_Pasien.[dbo].[FO_T_KASIR_2] WHERE NO_TRS_REFF = :ID_TR_TARIF3 AND TIPE_PEMBAYARAN = 'Kartu Kredit'");
            $this->db->bind('ID_TR_TARIF3', $ID_TR_TARIF);
            $dataxk =  $this->db->single();
            $total_bayar_kredit = $dataxk['totalbayar'];

            $this->db->query("SELECT SUM(NOMINAL_BAYAR) as totalbayar FROM Billing_Pasien.[dbo].[FO_T_KASIR_2] WHERE NO_TRS_REFF = :ID_TR_TARIF4 AND TIPE_PEMBAYARAN LIKE 'Piutang%'");
            $this->db->bind('ID_TR_TARIF4', $ID_TR_TARIF);
            $dataxk =  $this->db->single();
            $total_bayar_piutang = $dataxk['totalbayar'];

            $this->db->query("SELECT SUM(NOMINAL_BAYAR) as totalbayar FROM Billing_Pasien.[dbo].[FO_T_KASIR_2] WHERE NO_TRS_REFF = :ID_TR_TARIF5 AND TIPE_PEMBAYARAN = 'QRIS'");
            $this->db->bind('ID_TR_TARIF5', $ID_TR_TARIF);
            $dataxk =  $this->db->single();
            $total_bayar_qris = $dataxk['totalbayar'];

            if ($total_bayar_cash == NULL) {
                $total_bayar_cash = 0;
            }
            if ($total_bayar_debit == NULL) {
                $total_bayar_debit = 0;
            }
            if ($total_bayar_kredit == NULL) {
                $total_bayar_kredit = 0;
            }
            if ($total_bayar_piutang == NULL) {
                $total_bayar_piutang = 0;
            }
            if ($total_bayar_qris == NULL) {
                $total_bayar_qris = 0;
            }


            //INSERT TABEL PAYMENT HDR
            // Update FO_T_BILLING_1
            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_KASIR SET CASH = :CASH, DEBIT = :DEBIT, KREDIT = :KREDIT, PIUTANG = :PIUTANG, QRIS = :QRIS where NO_TRS = :NO_TRSx");
            $this->db->bind('NO_TRSx', $ID_TR_TARIF);
            $this->db->bind('CASH', $total_bayar_cash);
            $this->db->bind('DEBIT', $total_bayar_debit);
            $this->db->bind('KREDIT', $total_bayar_kredit);
            $this->db->bind('PIUTANG', $total_bayar_piutang);
            $this->db->bind('QRIS', $total_bayar_qris);
            $this->db->execute();

            // var_dump('taiiii');
            // exit;

            foreach ($tod as $idfobill1) {
                $this->db->query("SELECT NO_TRS_BILLING, ID_TRS_Payment, GRANDTOTAL FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE ID = :if_FOBill_1");
                $this->db->bind('if_FOBill_1', $idfobill1);
                $datax =  $this->db->single();
                $NO_TRS_BILL = $datax['NO_TRS_BILLING'];
                $ID_TRS_Payment = $datax['ID_TRS_Payment'];
                $GRANDtot = $datax['GRANDTOTAL'];

                $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 SET BAYAR = GRANDTOTAL ,ID_TRS_Payment = :NO_TRS_KAS WHERE ID =:ID_FO AND BATAL = '0'");
                $this->db->bind('NO_TRS_KAS', $ID_TR_TARIF);
                $this->db->bind('ID_FO', $idfobill1);
                $this->db->execute();
            }


            // var_dump($ID_TR_TARIF);
            // exit;

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Simpan Berhasil',
                'paramsid' => $ID_TR_TARIF,
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function UpdateKlaimBayar($data)
    {
        try {
            $this->db->transaksi();
            $tipepembayaran = $data['tipepembayaran'];

            // if ($tipepembayaran == 'Piutang Perusahaan' || $tipepembayaran == 'Piutang Asuransi') {
            //     $query = "UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 SET KLAIM=GRANDTOTAL,BAYAR=GRANDTOTAL,KEKURANGAN=0 WHERE ID = :iddata";
            // } else {
            //     $query = "UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 SET BAYAR=GRANDTOTAL,KLAIM=0,KEKURANGAN=GRANDTOTAL WHERE ID = :iddata";
            // }

            // //$odid = array();
            // $tod = json_decode(json_encode((object) $data['idbillingdtl']), FALSE);
            // foreach ($tod as $data) {

            //     // Update FO_T_BILLING_1
            //     $this->db->query($query);
            //     $this->db->bind('iddata', $data);
            //     $this->db->execute();
            // }

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Simpan Berhasil',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function UpdateKlaimBayarclose($data)
    {
        try {
            $this->db->transaksi();
            $tipepembayaran = $data['tipepembayaran'];

            if ($tipepembayaran == 'Piutang Perusahaan' || $tipepembayaran == 'Piutang Asuransi') {
                $query = "UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 SET KLAIM=GRANDTOTAL,BAYAR=GRANDTOTAL,KEKURANGAN=0 WHERE ID = :iddata";
            } else {
                $query = "UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 SET BAYAR=GRANDTOTAL,KLAIM=0,KEKURANGAN=GRANDTOTAL WHERE ID = :iddata";
            }

            //$odid = array();
            $tod = json_decode(json_encode((object) $data['idbillingdtl']), FALSE);
            foreach ($tod as $data) {

                // Update FO_T_BILLING_1
                $this->db->query($query);
                $this->db->bind('iddata', $data);
                $this->db->execute();
            }

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Simpan Berhasil',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function getDataBillClosingan($data)
    {
        try {
            $NoRegistrasi = $data['NoRegistrasi'];

            $this->db->query("	SELECT isnull(Administrasi,0) as Adm,isnull(Konsultasi,0) as Konsultasi,isnull(Visite,0) as Visite,isnull(Tindakan,0) as Tindakan
			,isnull(Laboratorium,0) as Lab,isnull(Radiologi,0) as Rad,isnull(Farmasi,0) as Far,
            (isnull(Administrasi,0) + isnull(Konsultasi,0) + isnull(Visite,0) + isnull(Tindakan,0) + isnull(Laboratorium,0) 
			+ isnull(Radiologi,0) + isnull(Farmasi,0)) as TOTAL
              FROM (
                	select GROUP_TARIF,sum(GRANDTOTAL) as Total from Billing_Pasien.dbo.FO_T_BILLING_1 
						where NO_REGISTRASI=:NoRegistrasi
						group by GROUP_TARIF
              ) as s
              PIVOT
              (
                SUM(Total)
                FOR GROUP_TARIF IN ([Administrasi], [Konsultasi], [Visite], [Tindakan], [Laboratorium], 
                [Radiologi], [Farmasi])
              )AS pvt");
            $this->db->bind('NoRegistrasi', $NoRegistrasi);
            $key =  $this->db->single();

            $pasing['Adm'] = $key['Adm'];
            $pasing['Konsultasi'] = $key['Konsultasi'];
            $pasing['Visite'] = $key['Visite'];
            $pasing['Tindakan'] = $key['Tindakan'];
            $pasing['Lab'] = $key['Lab'];
            $pasing['Rad'] = $key['Rad'];
            $pasing['Far'] = $key['Far'];
            $pasing['TOTAL'] = $key['TOTAL'];

            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    // 25/08/2024
    public function SaveTrsPayment_closing($data)
    {
        try {
            $this->db->transaksi();
            $count_array = count($data['tipepembayaran']);
            $terimapembayaran = array_sum(str_replace(".", "", $data['totalinput']));
            $totalhargadumi = str_replace(".", "", $data['totalharga']);
            $yangharusdibayar = str_replace(".", "", $data['totalbayar']);
            $datereg = substr($data['NoRegistrasi'], 0, 2);
            if ($terimapembayaran <> $yangharusdibayar) {
                $callback = array(
                    'status' => 'eror',
                    'message' => 'Hasil input tidak matching dengan total harga !',
                );
                return $callback;
                exit;
            }

            $totalklaimdumi = str_replace(".", "", $data['totalklaim2']);
            $klaimyangharusdibayar = str_replace(".", "", $data['totalklaim1']);
            if ($klaimyangharusdibayar <> $totalklaimdumi) {
                $callback = array(
                    'status' => 'eror',
                    'message' => 'Hasil input piutang tidak matching dengan total klaim !',
                );
                return $callback;
                exit;
            }

            $totalkurangdumi = str_replace(".", "", $data['totalkekurangan1']);
            $kurangyangharusdibayar = str_replace(".", "", $data['totalkekurangan2']);
            if ($totalkurangdumi <> $kurangyangharusdibayar) {
                $callback = array(
                    'status' => 'eror',
                    'message' => 'Hasil input harga tidak matching dengan harga !',
                );
                return $callback;
                exit;
            }


            // var_dump('tai');
            // exit;

            $totalinput = str_replace(".", "", $data['totalinput']);
            $tipepembayaran = $data['tipepembayaran'];
            $tipepembayarandummi = $data['tipepembayaran'][0];


            $NoMR = $data['NoMR'];
            $NoEpisode = $data['NoEpisode'];
            $NoRegistrasi = $data['NoRegistrasi'];
            $tgl_payment = $data['tglpayment_closing'];
            // var_dump($tgl_payment);
            // exit;
            $TypePatientID = $data['TypePatientID'];

            $bilito2 = $data['billto'][0];

            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $namauserx = $session->name;
            // $iduserx = $session->name;
            $iduserx = $session->IDEmployee;

            $timenow = Date('H:i:s');
 

            $tgl_paymentnew = $tgl_payment.' '.$timenow.'.000';
            $totalinput = str_replace(".", "", $data['totalinput']);

            $tipepembayaran = $data['tipepembayaran'];


            $bilito1 = $data['billtox'];
            $kodejaminan = $data['kodejaminan'];
            $kd_rekening = $data['kd_rekening'];
            // $namabank = $data['namabank'];
            $expired = $data['expired'];
            $nokartu = $data['nokartu'];
            $bilito = $data['billto'];
// $NoRegistrasi = $data['NoRegistrasi'];
if (isset($data['namapasien'])){
    $namapasien = $data['namapasien'];

    }else{
    $namapasien = null;

    }


            $this->db->query("SELECT [Status ID] AS statuspasien FROM PerawatanSQL.dbo.visit WHERE NoRegistrasi = :norega1a UNION ALL SELECT StatusID AS statuspasien FROM RawatInapSQL.dbo.Inpatient WHERE NoRegRI = :norega1b");
            $this->db->bind('norega1a', $data['NoRegistrasi']);
            $this->db->bind('norega1b', $data['NoRegistrasi']);
            $statuscek =  $this->db->single();
            $statuspasien = $statuscek['statuspasien'];

            if ($statuspasien == '4') {
                $callback = array(
                    'status' => 'eror', // Set array nama
                    'message' => 'Gagal Closing, Status Pasien Sudah Close'
                );
                return $callback;
                exit;
            }

            $this->db->query("UPDATE PerawatanSQL.dbo.Visit SET [Status ID] = '4' WHERE NoRegistrasi = :NoRegistrasixr");
            $this->db->bind('NoRegistrasixr', $NoRegistrasi);
            $this->db->execute();

            if ($tipepembayarandummi == "Pasien Kabur") {
                // var_dump($tipepembayaran, 'kabur');
                // exit;
                $this->db->query("SELECT SUM(BAYAR) AS TotalBayar, SUM(KLAIM) AS TotalKlaim, SUM(KEKURANGAN) AS TotalKekurangan FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE NO_REGISTRASI = :noreg1a AND BATAL = '0' AND ID_TRS_Payment IS NOT NULL");
                $this->db->bind('noreg1a', $NoRegistrasi);
                $datasd1 =  $this->db->single();
                $TotalBayaridtrs = $datasd1['TotalBayar'];
                $TotalKlaimidtrs = $datasd1['TotalKlaim'];
                $TotalKekuranganidtrs = $datasd1['TotalKekurangan'];

                $this->db->query("SELECT SUM(GRANDTOTAL) AS GrandTotal, SUM(KLAIM) AS TotalKlaim, SUM(KEKURANGAN) AS TotalKekurangan FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE NO_REGISTRASI = :noreg2a AND BATAL = '0' AND ID_TRS_Payment IS NULL");
                $this->db->bind('noreg2a', $NoRegistrasi);
                $datasd2 =  $this->db->single();
                $TotalBayarnoidtrs = $datasd2['GrandTotal'];
                $TotalKlaimnoidtrs = $datasd2['TotalKlaim'];
                $TotalKekurangannoidtrs = $datasd2['TotalKekurangan'];
                $TotalBayar = $TotalBayaridtrs + $TotalBayarnoidtrs;
                // $TotalBayar = $TotalBayaridtrs + $TotalBayarnoidtrs;
                // $TotalBayar = $TotalBayaridtrs + $TotalBayarnoidtrs;

                $this->db->query("INSERT INTO Billing_Pasien.dbo.CLOSING_BILL
                ([NOREG_FIRST], [JENIS_CLOSING], [TOTAL], [NOREG_REFF], [NO_MR])
                VALUES ( 
                :NoReg1, 'PASIEN KABUR', :TotalBayar1, '', :NoMR1)");
                $this->db->bind('NoReg1', $NoRegistrasi);
                $this->db->bind('TotalBayar1', $TotalBayar);
                $this->db->bind('NoMR1', $NoMR);
                $this->db->execute();

                $this->db->query("INSERT INTO Billing_Pasien.dbo.CLOSE_RO
                ([NOREG], [TOTAL_BILL], [KLAIM], [KEKURANGAN])
                VALUES ( 
                :NoReg2, :TotalBayar2, :TotalKlaim2, :TotalKekurangan2)");
                $this->db->bind('NoReg2', $NoRegistrasi);
                $this->db->bind('TotalBayar2', $TotalBayar);
                $this->db->bind('TotalKlaim2', $TotalKlaimnoidtrs);
                $this->db->bind('TotalKekurangan2', $TotalKekurangannoidtrs);
                $this->db->execute();

                $this->db->query("SELECT COUNT(*) AS CEKHUTANG FROM Billing_Pasien.dbo.CLOSING_BILL WHERE NOREG_REFF = :noreg3a");
                $this->db->bind('noreg3a', $NoRegistrasi);
                $datasd3 =  $this->db->single();
                $CEKHUTANGS = $datasd3['CEKHUTANG'];

                if ($CEKHUTANGS <> 0) {
                    $this->db->query("UPDATE Billing_Pasien.dbo.CLOSING_BILL SET NOREG_REFF = '' WHERE NOREG_REFF = :NoReg4a");
                    $this->db->bind('NoReg4a', $NoRegistrasi);
                    $this->db->execute();
                }
            } elseif ($tipepembayarandummi == "Piutang Rawat Inap") {
                $this->db->query("SELECT SUM(BAYAR) AS TotalBayar, SUM(KLAIM) AS TotalKlaim, SUM(KEKURANGAN) AS TotalKekurangan FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE NO_REGISTRASI = :noreg1a AND BATAL = '0' AND ID_TRS_Payment IS NOT NULL");
                $this->db->bind('noreg1a', $NoRegistrasi);
                $datasd1 =  $this->db->single();
                $TotalBayaridtrs = $datasd1['TotalBayar'];
                $TotalKlaimidtrs = $datasd1['TotalKlaim'];
                $TotalKekuranganidtrs = $datasd1['TotalKekurangan'];

                $this->db->query("SELECT SUM(GRANDTOTAL) AS GrandTotal, SUM(KLAIM) AS TotalKlaim, SUM(KEKURANGAN) AS TotalKekurangan FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE NO_REGISTRASI = :noreg2a AND BATAL = '0' AND ID_TRS_Payment IS NULL");
                $this->db->bind('noreg2a', $NoRegistrasi);
                $datasd2 =  $this->db->single();
                $TotalBayarnoidtrs = $datasd2['GrandTotal'];
                $TotalKlaimnoidtrs = $datasd2['TotalKlaim'];
                $TotalKekurangannoidtrs = $datasd2['TotalKekurangan'];
                $TotalBayar = $TotalBayaridtrs + $TotalBayarnoidtrs;
                // $TotalBayar = $TotalBayaridtrs + $TotalBayarnoidtrs;
                // $TotalBayar = $TotalBayaridtrs + $TotalBayarnoidtrs;


                $this->db->query("INSERT INTO Billing_Pasien.dbo.CLOSING_BILL
                ([NOREG_FIRST], [JENIS_CLOSING], [TOTAL], [NOREG_REFF], [NO_MR])
                VALUES ( 
                :NoReg1, 'PIUTANG RANAP', :TotalBayar1, '', :NoMR1)");
                $this->db->bind('NoReg1', $NoRegistrasi);
                $this->db->bind('TotalBayar1', $TotalBayar);
                $this->db->bind('NoMR1', $NoMR);
                $this->db->execute();

                $this->db->query("INSERT INTO Billing_Pasien.dbo.CLOSE_RO
                ([NOREG], [TOTAL_BILL], [KLAIM], [KEKURANGAN])
                VALUES ( 
                :NoReg2, :TotalBayar2, :TotalKlaim2, :TotalKekurangan2)");
                $this->db->bind('NoReg2', $NoRegistrasi);
                $this->db->bind('TotalBayar2', $TotalBayar);
                $this->db->bind('TotalKlaim2', $TotalKlaimnoidtrs);
                $this->db->bind('TotalKekurangan2', $TotalKekurangannoidtrs);
                $this->db->execute();

                $this->db->query("SELECT COUNT(*) AS CEKHUTANG FROM Billing_Pasien.dbo.CLOSING_BILL WHERE NOREG_REFF = :noreg3a");
                $this->db->bind('noreg3a', $NoRegistrasi);
                $datasd3 =  $this->db->single();
                $CEKHUTANGS = $datasd3['CEKHUTANG'];

                if ($CEKHUTANGS <> 0) {
                    $this->db->query("UPDATE Billing_Pasien.dbo.CLOSING_BILL SET NOREG_REFF = '' WHERE NOREG_REFF = :NoReg4a");
                    $this->db->bind('NoReg4a', $NoRegistrasi);
                    $this->db->execute();
                }
            } else {

                $datenowlis = date('dmy', strtotime($datenowcreate));
                $this->db->query("SELECT  max(NO_TRS) as nourut from Billing_Pasien.dbo.FO_T_KASIR WHERE SUBSTRING(NO_TRS, 4, 6)=:datenowlis ");
                $this->db->bind('datenowlis',   $datenowlis);
                $data =  $this->db->single();
                $nourut = $data['nourut'];
                $substringlis = substr($nourut, 9);
                if ($substringlis == null) {
                    $substringlis = 0;
                }
                $substringlis++;
                if (strlen($substringlis) == 1) {
                    $nourutfixLis = "00" . $substringlis;
                } else if (strlen($substringlis) == 2) {
                    $nourutfixLis = "0" . $substringlis;
                } else if (strlen($substringlis) == 3) {
                    $nourutfixLis = $substringlis;
                }

                $ID_TR_TARIF = 'TRS' . $datenowlis . $nourutfixLis;
                //#END GENERATE NO TRS HDR


                //GENERATE NO KWITANSI

                //untuk kode awal no NoKwitansi
                if ($TypePatientID == "1") {
                    $kodeawal = "KUJ";
                } else {
                    $kodeawal = "PRJ";
                }
                // $kodetengah = date('dmy');//untuk kode tengah no NoKwitansi
                $kodetengah = date('dmy', strtotime($tgl_payment));

                //cek no urut kwitansi

                //GET URUT
                $this->db->query("SELECT  TOP 1 NO_KWITANSI,right(NO_KWITANSI,4) as urutkwitansi
                FROM Billing_Pasien.dbo.FO_T_KASIR
                WHERE replace(CONVERT(VARCHAR(11), TGL_TRS, 111), '/','-')=:tgl_payment AND LEFT(NO_KWITANSI,3)=:kodeawal ORDER BY right(NO_KWITANSI,4) DESC");
                $this->db->bind('tgl_payment',   $tgl_payment);
                $this->db->bind('kodeawal',   $kodeawal);
                $data =  $this->db->single();
                $nourutkwitansi = $data['urutkwitansi'];

                if (empty($nourutkwitansi)) {
                    //jika gk ada record
                    $nourutkwitansi = "0001";
                } else {
                    //jika ada record
                    $nourutkwitansi++;
                }

                if (strlen($nourutkwitansi) == 1) {
                    $nourutfixKwitansi = "000" . $nourutkwitansi;
                } else if (strlen($nourutkwitansi) == 2) {
                    $nourutfixKwitansi = "00" . $nourutkwitansi;
                } else if (strlen($nourutkwitansi) == 3) {
                    $nourutfixKwitansi = "0" . $nourutkwitansi;
                } else if (strlen($nourutkwitansi) == 4) {
                    $nourutfixKwitansi = $nourutkwitansi;
                }

                $nofinalkwitansi = $kodeawal . '-' . $kodetengah . '-' . $nourutfixKwitansi;

                //#END GENERATE KWITANSI

                //INSERT TABEL PAYMENT HDR
                // Update FO_T_BILLING_1
                $this->db->query("INSERT INTO Billing_Pasien.dbo.FO_T_KASIR (
                    [NO_TRS]
                   ,[NO_KWITANSI]
                    ,[NO_EPISODE]
                    ,[NO_REGISTRASI]
                    ,[NO_MR]
                   ,[TGL_TRS]
                   ,[KODE_KASIR]
                   ,[USER_KASIR]
                   ,[NOMINAL_BAYAR]
                   ,[CASH]
                   ,[DEBIT]
                   ,[PIUTANG]
                   ,[KREDIT]
                   ,[QRIS]
                   ,[BATAL]
                   ,[TGL_BATAL]
                   ,[USER_BATAL]
                   ,[ALASAN_BATAL]
                   ,[USER_LAST]
                    ,[TGL_TRS_LAST]
                   ,[BILLTO]
                    ) values (
                    :NO_TRS
                    ,:NO_KWITANSI
                    ,:NO_EPISODE
                    ,:NO_REGISTRASI
                    ,:NO_MR
                    ,:TGL_TRS
                    ,:KODE_KASIR
                    ,:USER_KASIR
                    ,:NOMINAL_BAYAR
                    ,:CASH
                    ,:DEBIT
                    ,:PIUTANG
                    ,:KREDIT
                    ,:QRIS
                    ,:BATAL
                    ,:TGL_BATAL
                    ,:USER_BATAL
                    ,:ALASAN_BATAL
                    ,:USER_LAST
                    ,:TGL_TRS_LAST
                    ,:BILLTO
                    )");
                $this->db->bind('NO_TRS', $ID_TR_TARIF);
                $this->db->bind('NO_KWITANSI', $nofinalkwitansi);
                $this->db->bind('NO_EPISODE', $NoEpisode);
                $this->db->bind('NO_REGISTRASI', $NoRegistrasi);
                $this->db->bind('NO_MR', $NoMR);
                $this->db->bind('TGL_TRS', $tgl_payment);
                $this->db->bind('KODE_KASIR', $iduserx);
                $this->db->bind('USER_KASIR', $namauserx);
                $this->db->bind('NOMINAL_BAYAR', $terimapembayaran);
                $this->db->bind('CASH', 0);
                $this->db->bind('DEBIT', 0);
                $this->db->bind('PIUTANG', 0);
                $this->db->bind('KREDIT', 0);
                $this->db->bind('QRIS', 0);
                $this->db->bind('BATAL', '0');
                $this->db->bind('TGL_BATAL', '');
                $this->db->bind('USER_BATAL', '');
                $this->db->bind('ALASAN_BATAL', '');
                $this->db->bind('USER_LAST', $iduserx);
                $this->db->bind('TGL_TRS_LAST', $datenowcreate);
                $this->db->bind('BILLTO', $bilito1);
                $this->db->execute();

                // var_dump($tipepembayaran);
                // var_dump($timenow);
                // exit;

                //INSERT TABEL PAYMENT DTL
                for ($i = 0; $i < $count_array; $i++) {

                    //GENERATE NO TRS DTL
                    //GET URUT
                    $datenowlis = date('dmy', strtotime($datenowcreate));
                    $this->db->query("SELECT  max(NO_TRS) as nourut from Billing_Pasien.dbo.FO_T_KASIR_2 WHERE SUBSTRING(NO_TRS, 5, 6)=:datenowlis ");
                    $this->db->bind('datenowlis',   $datenowlis);
                    $data =  $this->db->single();
                    $nourut = $data['nourut'];
                    $substringlis = substr($nourut, 10);
                    if ($substringlis == null) {
                        $substringlis = 0;
                    }
                    $substringlis++;
                    if (strlen($substringlis) == 1) {
                        $nourutfixLis = "00" . $substringlis;
                    } else if (strlen($substringlis) == 2) {
                        $nourutfixLis = "0" . $substringlis;
                    } else if (strlen($substringlis) == 3) {
                        $nourutfixLis = $substringlis;
                    }

                    $ID_TR_TARIF_DTL = 'TRSD' . $datenowlis . $nourutfixLis;
                    //#END GENERATE NO TRS DTL

                    $this->db->query("INSERT INTO Billing_Pasien.[dbo].[FO_T_KASIR_2]
                    ([NO_TRS], [NO_TRS_REFF], [NOMINAL_BAYAR], [TIPE_PEMBAYARAN], [kode_Tipe_Reff] , [NAMA_TIPE_PEMBAYARAN], [NO_KARTU_REFRENSI], [EXPIRED_DATE])
                    VALUES (:NO_TRS, :NO_TRS_REFF, :NOMINAL_BAYAR, :TIPE_PEMBAYARAN, :kode_Tipe_Reff, :NAMA_TIPE_PEMBAYARAN, :NO_KARTU_REFRENSI, :EXPIRED_DATE)");
                    $this->db->bind('NO_TRS', $ID_TR_TARIF_DTL);
                    $this->db->bind('NO_TRS_REFF', $ID_TR_TARIF);
                    $this->db->bind('NOMINAL_BAYAR', $totalinput[$i]);
                    $this->db->bind('TIPE_PEMBAYARAN', $tipepembayaran[$i]);
                    $this->db->bind('kode_Tipe_Reff', $kodejaminan[$i]);
                    // $this->db->bind('kode_Tipe_Reff', $kd_rekening[$i]);
                    $this->db->bind('NAMA_TIPE_PEMBAYARAN', $bilito[$i]);
                    $this->db->bind('NO_KARTU_REFRENSI', $nokartu[$i]);
                    $this->db->bind('EXPIRED_DATE', $expired[$i]);
                    $this->db->execute();


                     //GENERATE PIUTANG
                $ledger = '0';
                if($tipepembayaran[$i] == "Piutang Asuransi" || $tipepembayaran[$i] == "Piutang Perusahaan" || $tipepembayaran[$i] == "Piutang Karyawan" || $tipepembayaran[$i] == "Piutang Rumah Sakit" || //$tipepembayaran[$i] == "Piutang Rawat Inap" ||
                $tipepembayaran[$i] == "Piutang Pasien"){

                    $ledger = '1';
                    $TglTrs = date('Y-m-d', strtotime($tgl_payment));
                    $formatDateJurnal = date('dmy', strtotime($tgl_payment));
                    $dateTransaksi = $TglTrs . ' ' . $timenow;
                    $kodeHT = "PU";
                    $this->db->query("SELECT  TOP 1 KD_PIUTANG,right(KD_PIUTANG,4) as urutregx
                    FROM Keuangan.dbo.PIUTANG_PASIEN  WHERE  
                    replace(CONVERT(VARCHAR(11), fd_tgL_piutang, 111), '/','-')=:TglTrs 
                    AND LEFT(KD_PIUTANG,2)=:kodeHT  
                    ORDER BY KD_PIUTANG DESC");
                    $this->db->bind('TglTrs',   $TglTrs);
                    $this->db->bind('kodeHT',   $kodeHT);
                    $data2 =  $this->db->single();
                    $no_reg = $data2['urutregx'];
                    $idReg = $no_reg;
                    $idReg++;

                    if (strlen($idReg) == 1) {
                        $noUrutJurnal = "000" . $idReg;
                    } else if (strlen($idReg) == 2) {
                        $noUrutJurnal = "00" . $idReg;
                    } else if (strlen($idReg) == 3) {
                        $noUrutJurnal = "0" . $idReg;
                    } else if (strlen($idReg) == 4) {
                        $noUrutJurnal = $idReg; 
                    }
                    $nofinalpiutang = $kodeHT . $formatDateJurnal . '-' . $noUrutJurnal;

                    if($tipepembayaran[$i] == "Piutang Asuransi"){
                        $this->db->query("SELECT  ID,NamaPerusahaan,Gen_BP from MasterdataSQL.dbo.MstrPerusahaanAsuransi 
                                        where ID=:kodeJaminan");
                        $this->db->bind('kodeJaminan', $kodejaminan[$i]);
                        $data3 =  $this->db->single();
                        $idjaminan = $data3['ID'];
                        $Gen_BP = $data3['Gen_BP'];
                        $tipejaminan = 'Asuransi';
                    }elseif($tipepembayaran[$i] == "Piutang Perusahaan" || $tipepembayaran[$i] == "Piutang Karyawan" || $tipepembayaran[$i] == "Piutang Rumah Sakit"){
                        $this->db->query("SELECT  ID,NamaPerusahaan,Gen_BP from MasterdataSQL.dbo.MstrPerusahaanJPK 
                                        where ID=:kodeJaminan");
                        $this->db->bind('kodeJaminan', $kodejaminan[$i]);
                        $data3 =  $this->db->single();
                        $idjaminan = $data3['ID'];
                        $Gen_BP = $data3['Gen_BP'];
                        $tipejaminan = 'Perusahaan';
                    }elseif($tipepembayaran[$i] == "Piutang Pasien"){
                        $this->db->query("SELECT  ID,NamaPerusahaan,Gen_BP from MasterdataSQL.dbo.MstrPerusahaanJPK 
                                        where ID='315'");
                        // $this->db->bind('kodeJaminan', $kodejaminan[$i]);
                        $data3 =  $this->db->single();
                        $idjaminan = $data3['ID'];
                        $Gen_BP = $data3['Gen_BP'];
                        $tipejaminan = 'Perusahaan';
                        $kd_rekening[$i] = '15100001';
                    }else{
                        $idjaminan = NULL;
                        $tipejaminan = NULL;
                        $FS_KD_REKENING = NULL;
                        $Gen_BP = '0';
                    }

                    $ket = 'Piutang Pasien:' . $namapasien . '-Tanggal:' . $tgl_paymentnew . '-Noreg:' . $NoRegistrasi;
                    if ($Gen_BP == '1') {
                        $this->db->query("INSERT INTO Keuangan.dbo.PIUTANG_PASIEN (KD_PIUTANG,fd_tgL_piutang,NO_TRANSAKSI,kode_jaminan,
                                                                fn_piutang,fn_sisa,fs_kd_petugas,PAYMENT_NO,TipePiutang,TipeJaminan,FS_kET,FS_kET2,FS_REKENING)
                                                                VALUES
                                                                ('$nofinalpiutang','$tgl_paymentnew','$NoRegistrasi','$idjaminan',
                                                                '$totalinput[$i]','$totalinput[$i]','$iduserx','$ID_TR_TARIF','$datereg','$tipejaminan','$ket','$NoRegistrasi','$kd_rekening[$i]')");
                        $this->db->execute();

                        $this->db->query("INSERT INTO Keuangan.dbo.PIUTANG_PASIEN_2 (kd_piutang,fn_piutang)
                                                                VALUES
                                                                ('$nofinalpiutang','$totalinput[$i]')");
                        $this->db->execute();

                    }else{
                        $this->db->query("INSERT INTO Keuangan.dbo.PIUTANG_PASIEN (KD_PIUTANG,fd_tgL_piutang,NO_TRANSAKSI,kode_jaminan,
                                                                fn_piutang,fn_sisa,fs_kd_petugas,PAYMENT_NO,TipePiutang,TipeJaminan,FS_kET,FS_kET2,FS_REKENING)
                                                                VALUES
                                                                ('$nofinalpiutang','$tgl_paymentnew','$NoRegistrasi','$idjaminan',
                                                                '$totalinput[$i]','$totalinput[$i]','$iduserx','$ID_TR_TARIF','$datereg','$tipejaminan','$ket','$NoRegistrasi','$kd_rekening[$i]')");
                        $this->db->execute();
                        
                        $this->db->query("INSERT INTO Keuangan.dbo.PIUTANG_PASIEN_2 (kd_piutang,fn_piutang)
                                                                VALUES
                                                                ('$nofinalpiutang','$totalinput[$i]')");
                        $this->db->execute();
                    }

                }
                // END PIUTANG


                }

                // update fo
                $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 SET BAYAR = GRANDTOTAL, ID_TRS_Payment = :ID_TR_TARIFx WHERE NO_REGISTRASI = :NoRegistrasix AND BATAL = '0' AND ID_TRS_Payment IS NULL");
                $this->db->bind('NoRegistrasix', $NoRegistrasi);
                $this->db->bind('ID_TR_TARIFx', $ID_TR_TARIF);
                $this->db->execute();

                // $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 SET BAYAR = GRANDTOTAL, ID_TRS_Payment = :ID_TR_TARIFx WHERE NO_REGISTRASI = :NoRegistrasix AND BATAL = '0' AND ID_TRS_Payment IS NULL");
                // $this->db->bind('NoRegistrasix', $NoRegistrasi);
                // $this->db->bind('ID_TR_TARIFx', $ID_TR_TARIF);
                // $this->db->execute();


                //update bill hutang
                $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_1
                SET BAYAR = GRANDTOTAL, ID_TRS_Payment = :ID_TR_TARIFxd
                FROM Billing_Pasien.dbo.FO_T_BILLING_1 a
                LEFT JOIN Billing_Pasien.dbo.CLOSING_BILL b on a.NO_REGISTRASI=b.NOREG_FIRST
                WHERE BATAL='0' and NOREG_REFF=:NoRegistrasixd
                and ID_TRS_Payment is null ");
                $this->db->bind('NoRegistrasixd', $NoRegistrasi);
                $this->db->bind('ID_TR_TARIFxd', $ID_TR_TARIF);
                $this->db->execute();
                //end update bill hutang

                $this->db->query("SELECT SUM(BAYAR) AS TotalBayar, SUM(KLAIM) AS TotalKlaim, SUM(KEKURANGAN) AS TotalKekurangan FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE NO_REGISTRASI = :NoReg AND BATAL = '0' AND ID_TRS_Payment IS NOT NULL");
                $this->db->bind('NoReg', $NoRegistrasi);
                $datasd =  $this->db->single();
                $TotalBayar = $datasd['TotalBayar'];
                $TotalKlaim = $datasd['TotalKlaim'];
                $TotalKekurangan = $datasd['TotalKekurangan'];

                //total hutang
                $this->db->query("SELECT SUM(BAYAR) AS TotalBayar, SUM(KLAIM) AS TotalKlaim, SUM(KEKURANGAN) AS TotalKekurangan 
                FROM Billing_Pasien.dbo.FO_T_BILLING_1 a
                INNER JOIN Billing_Pasien.dbo.CLOSING_BILL b on a.NO_REGISTRASI=b.NOREG_FIRST
                WHERE BATAL='0' and NOREG_REFF=:NoRegxd
                and ID_TRS_Payment is null ");
                $this->db->bind('NoRegxd', $NoRegistrasi);
                $dataxd =  $this->db->single();
                $TotalBayarxd = $dataxd['TotalBayar'];
                $TotalKlaimxd = $dataxd['TotalKlaim'];
                $TotalKekuranganxd = $dataxd['TotalKekurangan'];
                // total hutang

                $TotalBayarall = $TotalBayar + $TotalBayarxd;
                $TotalKlaimall = $TotalKlaim + $TotalKlaimxd;
                $TotalKekuranganall = $TotalKekurangan + $TotalKekuranganxd;

                $this->db->query("INSERT INTO Billing_Pasien.dbo.CLOSING_BILL
                ([NOREG_FIRST], [JENIS_CLOSING], [TOTAL], [NOREG_REFF], [NO_MR])
                VALUES ( 
                :NoReg1, 'CLOSEBILL', :TotalBayar1, '', :NoMR1)");
                $this->db->bind('NoReg1', $NoRegistrasi);
                $this->db->bind('TotalBayar1', $TotalBayarall);
                $this->db->bind('NoMR1', $NoMR);
                $this->db->execute();

                $this->db->query("INSERT INTO Billing_Pasien.dbo.CLOSE_RO
                ([NOREG], [TOTAL_BILL], [KLAIM], [KEKURANGAN])
                VALUES ( 
                :NoReg2, :TotalBayar2, :TotalKlaim2, :TotalKekurangan2)");
                $this->db->bind('NoReg2', $NoRegistrasi);
                $this->db->bind('TotalBayar2', $TotalBayarall);
                $this->db->bind('TotalKlaim2', $TotalKlaimall);
                $this->db->bind('TotalKekurangan2', $TotalKekuranganall);
                $this->db->execute();


                $this->db->query("SELECT SUM(NOMINAL_BAYAR) as totalbayar FROM Billing_Pasien.[dbo].[FO_T_KASIR_2] WHERE NO_TRS_REFF = :ID_TR_TARIF1 AND TIPE_PEMBAYARAN = 'TUNAI'");
                $this->db->bind('ID_TR_TARIF1', $ID_TR_TARIF);
                $dataxc =  $this->db->single();
                $total_bayar_cash = $dataxc['totalbayar'];

                $this->db->query("SELECT SUM(NOMINAL_BAYAR) as totalbayar FROM Billing_Pasien.[dbo].[FO_T_KASIR_2] WHERE NO_TRS_REFF = :ID_TR_TARIF2 AND TIPE_PEMBAYARAN = 'Kartu Debit'");
                $this->db->bind('ID_TR_TARIF2', $ID_TR_TARIF);
                $dataxd =  $this->db->single();
                $total_bayar_debit = $dataxd['totalbayar'];

                $this->db->query("SELECT SUM(NOMINAL_BAYAR) as totalbayar FROM Billing_Pasien.[dbo].[FO_T_KASIR_2] WHERE NO_TRS_REFF = :ID_TR_TARIF3 AND TIPE_PEMBAYARAN = 'Kartu Kredit'");
                $this->db->bind('ID_TR_TARIF3', $ID_TR_TARIF);
                $dataxk =  $this->db->single();
                $total_bayar_kredit = $dataxk['totalbayar'];
                // 22/08/2024x
                $this->db->query("SELECT SUM(NOMINAL_BAYAR) as totalbayar FROM Billing_Pasien.[dbo].[FO_T_KASIR_2] WHERE NO_TRS_REFF = :ID_TR_TARIF4 AND TIPE_PEMBAYARAN like '%Piutang%' ");
                $this->db->bind('ID_TR_TARIF4', $ID_TR_TARIF);
                $dataxp =  $this->db->single();
                $total_bayar_piutang = $dataxp['totalbayar'];

                $this->db->query("SELECT SUM(NOMINAL_BAYAR) as totalbayar FROM Billing_Pasien.[dbo].[FO_T_KASIR_2] WHERE NO_TRS_REFF = :ID_TR_TARIF4 AND TIPE_PEMBAYARAN = 'QRIS' ");
                $this->db->bind('ID_TR_TARIF4', $ID_TR_TARIF);
                $dataxp =  $this->db->single();
                $total_bayar_qris = $dataxp['totalbayar'];
                // 22/08/2024

                if ($total_bayar_cash == NULL) {
                    $total_bayar_cash = 0;
                }
                if ($total_bayar_debit == NULL) {
                    $total_bayar_debit = 0;
                }
                if ($total_bayar_kredit == NULL) {
                    $total_bayar_kredit = 0;
                }
                if ($total_bayar_piutang == NULL) {
                    $total_bayar_piutang = 0;
                }
                if ($total_bayar_qris == NULL) {
                    $total_bayar_qris = 0;
                }

                //INSERT TABEL PAYMENT HDR
                // Update FO_T_BILLING_1
                $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_KASIR SET CASH = :CASH, DEBIT = :DEBIT, KREDIT = :KREDIT, PIUTANG = :PIUTANG, QRIS = :QRIS where NO_TRS = :NO_TRSx");
                $this->db->bind('NO_TRSx', $ID_TR_TARIF);
                $this->db->bind('CASH', $total_bayar_cash);
                $this->db->bind('DEBIT', $total_bayar_debit);
                $this->db->bind('KREDIT', $total_bayar_kredit);
                $this->db->bind('PIUTANG', $total_bayar_piutang);
                $this->db->bind('QRIS', $total_bayar_qris);
                $this->db->execute();


                $this->db->query("INSERT INTO Billing_Pasien.dbo.TEMP_INA_CBG
                SELECT 
                NO_REGISTRASI
                ,isnull(ProsedurNonBedah,0) as ProsedurNonBedah
                ,isnull(ProsedurBedah,0) as ProsedurBedah
                ,isnull(Konsultasi,0) as Konsultasi
                ,0 as TenagaAhli
                ,isnull(Keperawatan,0) as Keperawatan
                ,0 as Penunjang
                ,isnull(Laboratorium,0) as Laboratorium
                ,isnull(Radiologi,0) as Radiologi
                ,isnull(PelayananDarah,0) as PelayananDarah
                ,isnull(Rehabilitasi,0) as Rehabilitasi
                ,isnull(Kamar,0) as Kamar_Akomodasi
                ,0 as RawatIntensif
                ,isnull(Obat,0) as Obat
                ,0 as ObatKronis
                ,0 as ObatKemoterapi
                ,0 as Alkes
                ,0 as BMHP
                ,0 as SewaAlat
                ,isnull(ProsedurNonBedah,0)
                +isnull(ProsedurBedah,0)
                +isnull(Konsultasi,0)
                +isnull(Laboratorium,0)
                +isnull(Radiologi,0)
                +isnull(PelayananDarah,0)
                +isnull(Rehabilitasi,0)
                +isnull(Kamar,0)
                +isnull(Obat,0) as TOTAL
                FROM (
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'ProsedurNonBedah' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3a and GROUP_TARIF ='Tindakan' 
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'ProsedurBedah' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3b and GROUP_TARIF ='Operasi'
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'Konsultasi' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3c and GROUP_TARIF ='Konsultasi'
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'Keperawatan' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3d and GROUP_TARIF ='Administrasi' 
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'Laboratorium' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3e and GROUP_TARIF ='Laboratorium'
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'Radiologi' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3f and GROUP_TARIF ='Radiologi'
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'PelayananDarah' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3g and GROUP_TARIF ='BankDarah'
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'Rehabilitasi' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3h and GROUP_TARIF ='Fisioterapi'
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'Kamar' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3i and GROUP_TARIF ='Kamar'
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'Obat' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3j and GROUP_TARIF ='Farmasi'
                Group by NO_REGISTRASI
                )AS QPivot
                PIVOT( SUM(TotalTarif)   
                FOR GROUP_TARIF IN ([ProsedurNonBedah],[ProsedurBedah],[Konsultasi],[Keperawatan],[Laboratorium],[Radiologi],[PelayananDarah],[Rehabilitasi],[Kamar],[Obat])) AS QPivot");
                $this->db->bind('NoReg3a', $NoRegistrasi);
                $this->db->bind('NoReg3b', $NoRegistrasi);
                $this->db->bind('NoReg3c', $NoRegistrasi);
                $this->db->bind('NoReg3d', $NoRegistrasi);
                $this->db->bind('NoReg3e', $NoRegistrasi);
                $this->db->bind('NoReg3f', $NoRegistrasi);
                $this->db->bind('NoReg3g', $NoRegistrasi);
                $this->db->bind('NoReg3h', $NoRegistrasi);
                $this->db->bind('NoReg3i', $NoRegistrasi);
                $this->db->bind('NoReg3j', $NoRegistrasi);
                $this->db->execute();
            }

            $this->db->query("INSERT INTO SysLog.dbo.TZ_Log_Button
            (noregistrasi, nama_biling, petugas_entry, tgl_entry)
            VALUES ( 
            :NoRegRecord, 'CLOSE BILL', :USER_KASIRRecord, :TGL_TRSRecord)");
            $this->db->bind('NoRegRecord', $NoRegistrasi);
            $this->db->bind('USER_KASIRRecord', $namauserx);
            $this->db->bind('TGL_TRSRecord', $datenowcreate);
            $this->db->execute();

            //update tanggal pulang pasien
            // emr status close dokter - liat dulu statusnya sudah keisi belum SelesaiPoli, JamSelesaiPoli
            $query = "SELECT SelesaiPoli,JamSelesaiPoli  FROM PerawatanSQL.dbo.Visit 
            where NoRegistrasi=:noreg";
            $this->db->query($query);
            $this->db->bind('noreg', $NoRegistrasi); 
            $dataxreg =  $this->db->single();
            $SelesaiPoli = $dataxreg['SelesaiPoli'];

            if($SelesaiPoli <> '1'){

                // Status Dokter Closed
                $this->db->query("UPDATE PerawatanSQL.dbo.Visit
                SET  JamPulang = :datenowcreate
                WHERE NoRegistrasi = :NoRegistrasi ");
                $this->db->bind('NoRegistrasi', $NoRegistrasi); 
                $this->db->bind('datenowcreate', $datenowcreate);  
                $this->db->execute();

                 
            
            }
            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Simpan Berhasil',
                // 'paramsid' => $ID_TR_TARIF,
            );

            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    // 25/08/2024


    public function getDataListInfoBillHarianRanap($data)
    {
        try {
            $dates = $data['dates'];
            $tp_pasien = $data['TipePenjamin'];
            $id_penjamin = $data['NamaPenjamin'];
            $datenow = Utils::datenowcreateNotFull();

            //GENERATE DataPendapatanRWI
            //DELETE TABLE DataPendapatanRWI
            $this->db->query("DELETE DashboardData.dbo.DataPendapatanRWI");
            $this->db->execute();

            //INSERT TABLE DataPendapatanRWI
            $this->db->query("INSERT into DashboardData.dbo.DataPendapatanRWI (NoRegistrasi,TotalBill)
            SELECT NoRegistrasi,sum([REGISTRASI Count]) TotalBill
            FROM 
            (
              -- obat 
              SELECT b.NoRegistrasi  , 'OBAT' as [Quarter],
              SUM((ISNULL(a.QtyRealisasi, 0) * ISNULL(a.[Unit Price], 0)) * (1 - ISNULL(a.Discount, 0)) + ISNULL(a.Uang_R, 0) + ISNULL(a.Embalase, 0)) AS  [REGISTRASI Count]
              FROM [Apotik_V1.1SQL].dbo.[Order Details] a
              inner join [Apotik_V1.1SQL].dbo.Orders b
              on a.[Order ID] = b.[Order ID]
              WHERE        a.Review = 1 and b.Paket='0'  and SUBSTRING(b.NoRegistrasi,1,2)='RI'
            --   and b.NoRegistrasi='RIJP110623-0018'
              GROUP BY b.NoRegistrasi 
              union 
              --- kamar 
              SELECT NoRegRI as NoRegistrasi,  'KAMAR' as [Quarter], SUM((RawatInapSQL.dbo.fn_GetTotalHariRawat(StartDate, ISNULL(EndDate, GETDATE()), ISNULL(TimeEnd, 
              GETDATE())) * Tarif) * (1 - Disc)) AS  [REGISTRASI Count]
              FROM RawatInapSQL.dbo.Inpatient_in_out
              WHERE (Paket = 0)  and SUBSTRING(NoRegRI,1,2)='RI'
            --   and NoRegRI='RIJP110623-0018'
              GROUP BY NoRegRI
              union 
              -- tindakan operasi
              SELECT NoRegistrasi ,  'OPERASI' as [Quarter],SUM(Tarif) AS  [REGISTRASI Count]
              FROM RawatInapSQL.dbo.tblTindakanRIDetail where   SUBSTRING(NoRegistrasi,1,2)='RI'
              -- where NoRegistrasi='RIJP110623-0018'
              GROUP BY NoRegistrasi
              union
              --- visit 
              SELECT        a.NoRegRI as NoRegistrasi,  'VISIT' as [Quarter], SUM((a.Quantity * a.[Unit Price]) * (1 - a.Discount)) AS  [REGISTRASI Count] 
              FROM             RawatInapSQL.dbo.[Inpatient Details] a
              LEFT OUTER JOIN  RawatInapSQL.dbo.[Visit Details Status] b ON a.[Status ID] = b.[Status ID] 
              LEFT OUTER JOIN  RawatInapSQL.dbo.Tarif_RI c ON a.[Product ID] = c.ID
              WHERE       
               (c.[Product Name] LIKE N'Visit%') 
              -- and a.NoRegRI='RIJP110623-0018'
              GROUP BY NoRegRI
              union 
              SELECT        a.NoRegRI as NoRegistrasi,  'TINDAKANRI' as [Quarter], SUM((a.Quantity * a.[Unit Price]) * (1 - a.Discount)) AS  [REGISTRASI Count] 
              FROM             RawatInapSQL.dbo.[Inpatient Details] a
              LEFT OUTER JOIN  RawatInapSQL.dbo.[Visit Details Status] b ON a.[Status ID] = b.[Status ID] 
              LEFT OUTER JOIN  RawatInapSQL.dbo.Tarif_RI c ON a.[Product ID] = c.ID
              WHERE       
               (c.[Product Name] not LIKE N'Visit%') 
               --and a.NoRegRI='RIJP110623-0018'
              GROUP BY NoRegRI
              UNION
              SELECT        NOREGISTRASI as NoRegistrasi, 'RADIOLOGI' as [Quarter], SUM(Tarif) AS  [REGISTRASI Count] 
              FROM            RadiologiSQL.dbo.ViewRXdetails
              -- where NOREGISTRASI='RIJP110623-0018'
              GROUP BY NOREGISTRASI
              UNION
              SELECT        NoRegRI,'LABORATORIUM' as [Quarter], SUM(Tarif) AS  [REGISTRASI Count] 
              FROM            LaboratoriumSQL.dbo.View_Labdetails
              WHERE        (PaketKMG = 0) 
              -- AND NoRegRI='RIJP110623-0018'
              GROUP BY NoRegRI
              UNION
              select NoRegistrasi, 'PAKET' AS [Quarter], harga as TOTAL
              from RawatInapSQL.dbo.Inpatient_Paket_Operasi 
              -- where NoRegistrasi='RIJP110623-0018'
            )AS QuarterlyData 
             group by NoRegistrasi");
            $this->db->execute();
            //#END GENERATE DataPendapatanRWI

            $query_master = "SELECT hdr.NoRegistrasi as NoRegRI,hdr.NoMR,PatientName,hdr.NamaJaminan as penjamin,kj.HakKelas,
                isnull(totalvst,0) as totalvst,isnull(totallab,0) as totallab,isnull(totalrad,0) as totalrad,isnull(totalaptk,0) as totalaptk,isnull(totalkamar,0) as totalkamar,
                isnull(totalop,0) as totalop,kl.NamaKelas as Class,kmr.RoomName,bx.TotalBill as TotalBiayaRawat,hdr.Diagnosa_Awal as diagnosa,f.GroupName as NamaTindakanOP,lmrwt
                FROM DashboardData.dbo.dataRWI hdr
                        left join 
                            (SELECT NoRegRI,sum([Unit Price]*Quantity*(1-Discount)) as totalvst 
                            FROM RawatInapSQL.dbo.[Inpatient Details] 
                            where replace(CONVERT(VARCHAR(11), VisitDate, 111), '/','-')=:dates
                            group by NoRegRI)vst on hdr.NoRegistrasi=vst.NoRegRI
                        left join (SELECT NoRegRI,sum(Tarif) as totallab
                            FROM LaboratoriumSQL.dbo.View_Labdetails 
                            where replace(CONVERT(VARCHAR(11), LabDate, 111), '/','-') =:dates2
                            group by NoRegRI
                            )lab on hdr.NoRegistrasi=lab.NoRegRI
                         left join (SELECT NOREGISTRASI,sum(Service_Charge) as totalrad
                            FROM RadiologiSQL.dbo.WO_RADIOLOGY
                            where replace(CONVERT(VARCHAR(11), ORDER_DATE, 111), '/','-')=:dates3
                            group by NOREGISTRASI
                            )rad on hdr.NoRegistrasi=rad.NOREGISTRASI
                        left join 
                            (SELECT b.NoRegistrasi,sum(a.[Unit Price]*a.QtyRealisasi*(1-a.Discount)) as totalaptk 
                            FROM [Apotik_V1.1SQL].dbo.[Order Details] a
                            inner join [Apotik_V1.1SQL].dbo.Orders b on a.[Order ID]=b.[Order ID]
                            where replace(CONVERT(VARCHAR(11), b.tglResep, 111), '/','-')=:dates4
                            group by NoRegistrasi
                            ) aptk on hdr.NoRegistrasi=aptk.NoRegistrasi
                        left join (SELECT StatusActive,NoRegRI,Tarif as totalkamar,RoomName 
                            FROM RawatInapSQL.dbo.Inpatient_in_out 
                            where StatusActive='1')kmr on hdr.NoRegistrasi=kmr.NoRegRI
                        left join 
                            (SELECT NoRegRI, sum(CASE WHEN EndDate is not null 
                            then DATEDIFF ( day , StartDate , EndDate ) else  DATEDIFF ( day , StartDate , GETDATE() )  end) as lmrwt
                            FROM RawatInapSQL.dbo.Inpatient_in_out
                            group by NoRegRI) lama on hdr.NoRegistrasi=lama.NoRegRI
                         outer apply
                            (SELECT TOP 1 A_Diagnosa,NoRegistrasi from MedicalRecord.dbo.EMR_RWJ where NoRegistrasi collate Latin1_General_CS_AS=hdr.NoRegistrasi collate Latin1_General_CS_AS)d
                            outer apply (
                            SELECT GroupName,sum(isnull(Tarif,0)) as totalop FROM RawatInapSQL.dbo.tblTindakanRIDetail where hdr.NoRegistrasi=NoRegistrasi and NamaKelas is not null 
                            and replace(CONVERT(VARCHAR(11), DateEntry, 111), '/','-')=:dates5
                            group by GroupName
                            )f
                            left join MasterdataSQL.dbo.Admision_Kartu_Jaminan kj on hdr.NoMR=kj.NoMR and hdr.TipePasien=kj.KodeGroupJaminan 
                            and hdr.KodeJaminan=kj.KodeJaminan
                            inner join RawatInapSQL.dbo.Inpatient ips on hdr.NoRegistrasi=ips.NoRegRI
                        inner join RawatInapSQL.dbo.TblKelas kl on ips.KlsID=kl.IDkelas
                inner join DashboardData.dbo.DataPendapatanRWI bx on  hdr.NoRegistrasi collate SQL_Latin1_General_CP1_CI_AS=bx.NoRegistrasi collate SQL_Latin1_General_CP1_CI_AS
                            WHERE ips.StatusID<>'4'
                ";
            //$orderby = "ORDER BY replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-')  ASC, A.NoMR ASC";
            $orderby = "";

            if ($tp_pasien == '1') { //PRIBADI
                //$query_tambahan = " AND d.TypePatient='UMUM'";
                $query_tambahan = " AND hdr.TipePasien='1'";
                $query = $query_master . $query_tambahan . $orderby;
                $this->db->query($query);
            } elseif ($tp_pasien == '5') { //Jaminan, Perusahaan
                if ($id_penjamin != null || $id_penjamin != '') { //Perusahaan Filter by ID perusahaan----

                    // $query_tambahan = " AND hdr.IDJPK=:id_penjamin AND d.TypePatient='JAMINAN PERUSAHAAN'";
                    $query_tambahan = " AND hdr.KodeJaminan=:id_penjamin AND hdr.TipePasien='5'";
                    $query = $query_master . $query_tambahan . $orderby;
                    $this->db->query($query);
                    $this->db->bind('id_penjamin', $id_penjamin);
                } else { //Perusahaan ALL----
                    //$query_tambahan = " AND d.TypePatient='JAMINAN PERUSAHAAN'";
                    $query_tambahan = " AND hdr.TipePasien='5'";
                    $query = $query_master . $query_tambahan . $orderby;
                    $this->db->query($query);
                }
            } elseif ($tp_pasien == '2') { //Jaminan, Asuransi
                if ($id_penjamin != null || $id_penjamin != '') { //Asuransi Filter by ID Asuransi---
                    //$query_tambahan = " AND hdr.IDAsuransi=:id_penjamin AND d.TypePatient='ASURANSI'";
                    $query_tambahan = " AND hdr.KodeJaminan=:id_penjamin AND hdr.TipePasien='2'";
                    $query = $query_master . $query_tambahan . $orderby;
                    $this->db->query($query);
                    $this->db->bind('id_penjamin', $id_penjamin);
                } else { //Asuransi ALL----
                    //$query_tambahan = " AND d.TypePatient='ASURANSI'";
                    $query_tambahan = " AND hdr.TipePasien='2'";
                    $query = $query_master . $query_tambahan . $orderby;
                    $this->db->query($query);
                }
            } else { // No Filter
                $query_tambahan = "";
                $query = $query_master . $query_tambahan . $orderby;
                $this->db->query($query);
            }

            $this->db->bind('dates', $dates);
            $this->db->bind('dates2', $dates);
            $this->db->bind('dates3', $dates);
            $this->db->bind('dates4', $dates);
            $this->db->bind('dates5', $dates);
            $data =  $this->db->resultSet();
            $rows = array();
            $i = 1;
            foreach ($data as $row) {

                $totalperhari = $row['totalvst'] + $row['totallab'] + $row['totalrad'] + $row['totalaptk'] + $row['totalkamar'] + $row['totalop'];
                $pasing['no'] = $i++;
                $pasing['noreg'] = $row['NoRegRI'];
                $pasing['NoMR'] = $row['NoMR'];
                $pasing['PatientName'] = $row['PatientName'];
                $pasing['totalvst'] = $row['totalvst'] + $row['totalop'];
                $pasing['totallab'] = $row['totallab'];
                $pasing['totalrad'] = $row['totalrad'];
                $pasing['totalaptk'] = $row['totalaptk'];
                $pasing['totalkamar'] = $row['totalkamar'];
                $pasing['Class'] = $row['Class'] . ' / ' . $row['RoomName'];
                $pasing['penjamin'] = $row['penjamin'];
                $pasing['totalperhari'] = $totalperhari;
                $pasing['TarifCoding'] =  '-';
                $pasing['TotalBiayaRawat'] =  $row['TotalBiayaRawat'];
                $pasing['diagnosa'] =  htmlspecialchars($row['diagnosa'], ENT_QUOTES);
                $pasing['NamaTindakanOP'] =  $row['NamaTindakanOP'];
                //$pasing['totalapd'] =  $row['totalapd'];
                $pasing['lamarawat'] =  $row['lmrwt'];
                $pasing['HakKelas'] =  $row['HakKelas'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    private function penyebut($nilai)
    {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = $this->penyebut($nilai - 10) . " belas";
        } else if ($nilai < 100) {
            $temp = $this->penyebut($nilai / 10) . " puluh" . $this->penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . $this->penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->penyebut($nilai / 100) . " ratus" . $this->penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . $this->penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->penyebut($nilai / 1000) . " ribu" . $this->penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->penyebut($nilai / 1000000) . " juta" . $this->penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = $this->penyebut($nilai / 1000000000) . " milyar" . $this->penyebut(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = $this->penyebut($nilai / 1000000000000) . " trilyun" . $this->penyebut(fmod($nilai, 1000000000000));
        }
        return $temp;
    }

    public function terbilang($nilai)
    {
        if ($nilai < 0) {
            $hasil = "minus " . trim($this->penyebut($nilai));
        } else {
            $hasil = trim($this->penyebut($nilai));
        }
        $hasil = $hasil . ' rupiah';
        return $hasil;
    }

    public function terbilang_eng($num = false)
    {
        $num = str_replace(array(',', ' '), '', trim($num));
        if (!$num) {
            return false;
        }
        $num = (int) $num;
        $words = array();
        $list1 = array(
            '',
            'one',
            'two',
            'three',
            'four',
            'five',
            'six',
            'seven',
            'eight',
            'nine',
            'ten',
            'eleven',
            'twelve',
            'thirteen',
            'fourteen',
            'fifteen',
            'sixteen',
            'seventeen',
            'eighteen',
            'nineteen'
        );
        $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
        $list3 = array(
            '',
            'thousand',
            'million',
            'billion',
            'trillion',
            'quadrillion',
            'quintillion',
            'sextillion',
            'septillion',
            'octillion',
            'nonillion',
            'decillion',
            'undecillion',
            'duodecillion',
            'tredecillion',
            'quattuordecillion',
            'quindecillion',
            'sexdecillion',
            'septendecillion',
            'octodecillion',
            'novemdecillion',
            'vigintillion'
        );
        $num_length = strlen($num);
        $levels = (int) (($num_length + 2) / 3);
        $max_length = $levels * 3;
        $num = substr('00' . $num, -$max_length);
        $num_levels = str_split($num, 3);
        for ($i = 0; $i < count($num_levels); $i++) {
            $levels--;
            $hundreds = (int) ($num_levels[$i] / 100);
            $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
            $tens = (int) ($num_levels[$i] % 100);
            $singles = '';
            if ($tens < 20) {
                $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
            } else {
                $tens = (int) ($tens / 10);
                $tens = ' ' . $list2[$tens] . ' ';
                $singles = (int) ($num_levels[$i] % 10);
                $singles = ' ' . $list1[$singles] . ' ';
            }
            $words[] = $hundreds . $tens . $singles . (($levels && (int) ($num_levels[$i])) ? ' ' . $list3[$levels] . ' ' : '');
        } //end for loop
        $commas = count($words);
        if ($commas > 1) {
            $commas = $commas - 1;
        }
        $completewords = implode(' ', $words);
        $completewords = $completewords . ' rupiah';
        return $completewords;
    }

    public function PrintKuitansiHeaderbyIDX($data)
    {
        try {

            if ($data['kodereg'] == 'RJ') {
                $query = "SELECT f.PatientName, a.BILLTO, a.NO_MR, a.NO_REGISTRASI, a.NO_EPISODE, a.NO_KWITANSI, a.USER_KASIR, a.NOMINAL_BAYAR, SUBSTRING(x.nama_test,1, LEN(x.nama_test) - 1) 
                NamaTest, y.nominal_bayar_tunai, z.nominal_bayar_Debit, w.nominal_bayar_PiuangPerushaan, f3.NamaUnit, f4.NamaPerusahaan AS NamaJaminan, a.KODE_KASIR AS Id_Kasir
                FROM Billing_Pasien.dbo.FO_T_KASIR a
                INNER JOIN MasterdataSQL.dbo.Admision f ON f.NoMR = a.NO_MR COLLATE  SQL_Latin1_General_CP1_CI_AS
                inner join PerawatanSQL.dbo.Visit f2 on a.NO_REGISTRASI collate Latin1_General_CI_AS = f2.NoRegistrasi
                inner join MasterdataSQL.dbo.MstrUnitPerwatan f3 on f2.Unit= f3.ID
                inner join MasterdataSQL.dbo.MstrPerusahaanJPK f4 on f2.Perusahaan = f4.ID
                OUTER APPLY (
                SELECT NAMA_TARIF + ', '
                FROM Billing_Pasien.dbo.FO_T_BILLING_1 c
                WHERE c.ID_TRS_Payment = a.NO_TRS AND c.BATAL = '0'
                FOR XML PATH('')
                ) x (nama_test)
                OUTER APPLY (
                SELECT SUM(NOMINAL_BAYAR) as bayartunai
                FROM Billing_Pasien.dbo.FO_T_KASIR_2 b
                WHERE b.NO_TRS_REFF = a.NO_TRS AND TIPE_PEMBAYARAN = 'Tunai'
                ) y (nominal_bayar_tunai)
                OUTER APPLY (
                SELECT SUM(NOMINAL_BAYAR) as bayartunai
                FROM Billing_Pasien.dbo.FO_T_KASIR_2 d
                WHERE d.NO_TRS_REFF = a.NO_TRS AND TIPE_PEMBAYARAN = 'Kartu Debit'
                ) z (nominal_bayar_Debit)
                OUTER APPLY (
                SELECT SUM(NOMINAL_BAYAR) as bayartunai
                FROM Billing_Pasien.dbo.FO_T_KASIR_2 e
                WHERE e.NO_TRS_REFF = a.NO_TRS AND TIPE_PEMBAYARAN = 'Piutang Perusahaan'
                ) w (nominal_bayar_PiuangPerushaan)
                WHERE a.NO_REGISTRASI = :noreg1 AND  a.NO_TRS = :notrskasir1
                UNION ALL 
                SELECT f.PatientName, a.BILLTO, a.NO_MR, a.NO_REGISTRASI, a.NO_EPISODE, a.NO_KWITANSI, a.USER_KASIR, a.NOMINAL_BAYAR, SUBSTRING(x.nama_test,1, LEN(x.nama_test) - 1) 
                NamaTest, y.nominal_bayar_tunai, z.nominal_bayar_Debit, w.nominal_bayar_PiuangPerushaan, f3.NamaUnit, f4.NamaPerusahaan AS NamaJaminan, a.KODE_KASIR AS Id_Kasir
                FROM Billing_Pasien.dbo.FO_T_KASIR a
                INNER JOIN MasterdataSQL.dbo.Admision f ON f.NoMR = a.NO_MR COLLATE  SQL_Latin1_General_CP1_CI_AS
                inner join PerawatanSQL.dbo.Visit f2 on a.NO_REGISTRASI collate Latin1_General_CI_AS = f2.NoRegistrasi
                inner join MasterdataSQL.dbo.MstrUnitPerwatan f3 on f2.Unit= f3.ID
                inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi f4 on f2.Asuransi = f4.ID
                OUTER APPLY (
                SELECT NAMA_TARIF + ', '
                FROM Billing_Pasien.dbo.FO_T_BILLING_1 c
                WHERE c.ID_TRS_Payment = a.NO_TRS AND c.BATAL = '0'
                FOR XML PATH('')
                ) x (nama_test)
                OUTER APPLY (
                SELECT SUM(NOMINAL_BAYAR) as bayartunai
                FROM Billing_Pasien.dbo.FO_T_KASIR_2 b
                WHERE b.NO_TRS_REFF = a.NO_TRS AND TIPE_PEMBAYARAN = 'Tunai'
                ) y (nominal_bayar_tunai)
                OUTER APPLY (
                SELECT SUM(NOMINAL_BAYAR) as bayartunai
                FROM Billing_Pasien.dbo.FO_T_KASIR_2 d
                WHERE d.NO_TRS_REFF = a.NO_TRS AND TIPE_PEMBAYARAN = 'Kartu Debit'
                ) z (nominal_bayar_Debit)
                OUTER APPLY (
                SELECT SUM(NOMINAL_BAYAR) as bayartunai
                FROM Billing_Pasien.dbo.FO_T_KASIR_2 e
                WHERE e.NO_TRS_REFF = a.NO_TRS AND TIPE_PEMBAYARAN = 'Piutang Perusahaan'
                ) w (nominal_bayar_PiuangPerushaan)
                WHERE a.NO_REGISTRASI = :noreg2 AND  a.NO_TRS = :notrskasir2";
            } elseif ($data['kodereg'] == 'RI') {
                $query = "  SELECT a.ID,NoKwitansi,a.NoRegistrasi,b.NoMR,
                case when billto is null then b.PatientName collate Latin1_General_CI_AS else billto end as billto,PatientName,NamaJaminan,a.Keterangan as NamaUnit,Ammount as TotalPaid,Kasir,Id_Kasir,isnull(Cetakan_Ke,0) as Cetakan_Ke
                FROM RawatInapSQL.dbo.Deposit a
                left join DashboardData.dbo.dataRWI b on a.NoRegistrasi=b.NoRegistrasi 
                where a.ID=:id";
            } elseif ($data['kodereg'] == 'PB') {
                $query = "SELECT a.ID,NoKwitansi,a.NoRegistrasi,'-' NoMR,case when billto is null then b.[Ship Name] collate Latin1_General_CI_AS else billto end as billto,[Ship Name] as PatientName,'-' NamaJaminan,'PEMBELIAN OBAT BEBAS' as NamaUnit,TotalPaid,Kasir,Id_Kasir,isnull(Cetakan_Ke,0) as Cetakan_Ke
                FROM PerawatanSQL.dbo.payments a
                left join [Apotik_V1.1SQL].dbo.Orders b on a.NoRegistrasi=b.NoRegistrasi
                where a.ID=:id";
            } else {
                $pasing['NoKwitansi'] = '';
                $pasing['NoRegistrasi'] = '';
                $pasing['NoMR'] = '';
                $pasing['billto'] = '';
                $pasing['PatientName'] = '';
                $pasing['NamaJaminan'] = '';
                $pasing['NamaUnit'] = '';
                $pasing['Kasir'] = '';
                $pasing['Terbilang'] = '';
                $pasing['TotalPaid'] = '';
                $pasing['Id_Kasir'] = '';
                $pasing['Cetakan_Ke'] = '';
                $pasing['ID'] = '';
                return $pasing;
            }
            $this->db->query($query);
            // $this->db->bind('id', $data['notrs']);
            $this->db->bind('noreg1', $data['notrs']);
            $this->db->bind('notrskasir1', $data['lang']);
            $this->db->bind('noreg2', $data['notrs']);
            $this->db->bind('notrskasir2', $data['lang']);
            $datas =  $this->db->single();

            if ($data['lang'] == 'EN') {
                $terbilang = $this->terbilang_eng($datas['NOMINAL_BAYAR']);
            } else {
                $terbilang = $this->terbilang($datas['NOMINAL_BAYAR']);
            }

            // $pasing['TglCreate_sign'] = date('d/m/Y', strtotime($datas['TglCreate']));
            $pasing['billto'] = $datas['BILLTO'];
            $pasing['NoMR'] = $datas['NO_MR'];
            $pasing['NoRegistrasi'] = $datas['NO_REGISTRASI'];
            $pasing['NO_EPISODE'] = $datas['NO_EPISODE'];
            $pasing['NoKwitansi'] = $datas['NO_KWITANSI'];
            // $pasing['Id_Kasir'] = $datas['USER_KASIR'];

            $pasing['PatientName'] = $datas['PatientName'];
            $pasing['NamaJaminan'] = $datas['NamaJaminan'];
            $pasing['NamaUnit'] = $datas['NamaUnit'];
            $pasing['Kasir'] = $datas['USER_KASIR'];
            $pasing['Id_Kasir'] = $datas['Id_Kasir'];
            // $pasing['Cetakan_Ke'] = $datas['Cetakan_Ke'];
            // $pasing['ID'] = $datas['ID'];
            $pasing['Terbilang'] = $terbilang;
            $pasing['TotalPaid'] = number_format($datas['NOMINAL_BAYAR'], 0, ',', '.');

            // var_dump($pasing['TotalPaid']);
            // exit;

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintKuitansiHeaderbyAll($data)
    {
        try {

            $session = SessionManager::getCurrentSession();
            $namauserx = $session->name;

            if ($data['kodereg'] == 'RJ') {
                $query = "SELECT f.PatientName ,  b2.Billto as BILLTO, a.NoMR as NO_MR, a.NoRegistrasi as NO_REGISTRASI, a.NoEpisode as NO_EPISODE, '' as NO_KWITANSI, '' as USER_KASIR, b4.nominalbayar as NOMINAL_BAYAR, f3.NamaUnit,
                case when a.PatientType='2' then asu.NamaPerusahaan else jpk.NamaPerusahaan end AS NamaJaminan, '' AS Id_Kasir,
                SUBSTRING(x.nama_test,1, LEN(x.nama_test) - 1) NamaTest , y.nominal_bayar_tunai , z.nominal_bayar_Debit, w.nominal_bayar_PiuangPerushaan, wa.nominal_bayar_Qris
                FROM PerawatanSQL.dbo.Visit a
                INNER JOIN MasterdataSQL.dbo.Admision f ON f.NoMR = a.NoMR
                INNER join MasterdataSQL.dbo.MstrUnitPerwatan f3 on a.Unit= f3.ID
                --INNER join MasterdataSQL.dbo.MstrPerusahaanJPK f4 on a.Perusahaan = f4.ID
                        OUTER APPLY (
                            SELECT Billto
                            FROM Billing_Pasien.dbo.FO_T_KASIR b1 
                            WHERE b1.BATAL = '0' AND b1.NO_REGISTRASI = a.NoRegistrasi COLLATE  SQL_Latin1_General_CP1_CI_AS
                            GROUP BY Billto
                        ) b2 (Billto)
                        OUTER APPLY (
                            SELECT SUM(NOMINAL_BAYAR) as nominalbayar
                            FROM Billing_Pasien.dbo.FO_T_KASIR b3 
                            WHERE b3.BATAL = '0' AND b3.NO_REGISTRASI = a.NoRegistrasi COLLATE  SQL_Latin1_General_CP1_CI_AS
                            GROUP BY Billto
                        ) b4 (nominalbayar)
                        OUTER APPLY (
                            SELECT NAMA_TARIF + ', '
                            FROM Billing_Pasien.dbo.FO_T_BILLING_1 b5
                            inner join Billing_Pasien.dbo.FO_T_KASIR b6 on b6.NO_REGISTRASI = a.NoRegistrasi COLLATE  SQL_Latin1_General_CP1_CI_AS
                            WHERE b5.ID_TRS_Payment = b6.NO_TRS AND b5.BATAL = '0' AND b6.BATAL = '0'
                            FOR XML PATH('')
                        ) x (nama_test)
                        OUTER APPLY (
                            SELECT SUM(b7.NOMINAL_BAYAR) as bayartunai
                            FROM Billing_Pasien.dbo.FO_T_KASIR_2 b7
                            inner join Billing_Pasien.dbo.FO_T_KASIR b8 on b8.NO_REGISTRASI = a.NoRegistrasi COLLATE  SQL_Latin1_General_CP1_CI_AS
                            WHERE b7.NO_TRS_REFF = b8.NO_TRS AND TIPE_PEMBAYARAN = 'Tunai' AND b7.BATAL = '0' AND b8.BATAL = '0'
                        ) y (nominal_bayar_tunai)
                        OUTER APPLY (
                            SELECT SUM(b9.NOMINAL_BAYAR) as bayartunai
                            FROM Billing_Pasien.dbo.FO_T_KASIR_2 b9
                            inner join Billing_Pasien.dbo.FO_T_KASIR b10 on b10.NO_REGISTRASI = a.NoRegistrasi COLLATE  SQL_Latin1_General_CP1_CI_AS
                            WHERE b9.NO_TRS_REFF = b10.NO_TRS AND TIPE_PEMBAYARAN = 'Kartu Debit' AND b9.BATAL = '0' AND b10.BATAL = '0'
                        ) z (nominal_bayar_Debit)
                        OUTER APPLY (
                            SELECT SUM(b11.NOMINAL_BAYAR) as bayartunai
                            FROM Billing_Pasien.dbo.FO_T_KASIR_2 b11
                            inner join Billing_Pasien.dbo.FO_T_KASIR b12 on b12.NO_REGISTRASI = a.NoRegistrasi COLLATE  SQL_Latin1_General_CP1_CI_AS
                            WHERE b11.NO_TRS_REFF = b12.NO_TRS AND TIPE_PEMBAYARAN = 'Piutang Perusahaan' AND b11.BATAL = '0' AND b12.BATAL = '0'
                        ) w (nominal_bayar_PiuangPerushaan)
                        OUTER APPLY (
                            SELECT SUM(b13.NOMINAL_BAYAR) as bayartunai
                            FROM Billing_Pasien.dbo.FO_T_KASIR_2 b13
                            inner join Billing_Pasien.dbo.FO_T_KASIR b14 on b14.NO_REGISTRASI = a.NoRegistrasi COLLATE  SQL_Latin1_General_CP1_CI_AS
                            WHERE b13.NO_TRS_REFF = b14.NO_TRS AND TIPE_PEMBAYARAN = 'QRIS' AND b13.BATAL = '0' AND b14.BATAL = '0'
                        ) wa (nominal_bayar_Qris)
                        --OUTER APPLY (
                        --	SELECT NamaPerusahaan + ', '
                        --	FROM MasterdataSQL.dbo.MstrPerusahaanJPK b13
                        --	WHERE b13.ID = a.Perusahaan
                        --	UNION ALL
                        --	SELECT NamaPerusahaan + ', '
                        --	FROM MasterdataSQL.dbo.MstrPerusahaanAsuransi b14
                        --	WHERE b14.ID = a.Asuransi
                  --      ) u (nama_perushaaan)
                  left join MasterdataSQL.dbo.MstrPerusahaanJPK jpk on a.Perusahaan=jpk.ID
                  left join MasterdataSQL.dbo.MstrPerusahaanAsuransi asu on a.Asuransi=asu.ID
                WHERE a.NoRegistrasi = :noreg1";
            } elseif ($data['kodereg'] == 'RI') {
                $query = "  SELECT a.ID,NoKwitansi,a.NoRegistrasi,b.NoMR,
                case when billto is null then b.PatientName collate Latin1_General_CI_AS else billto end as billto,PatientName,NamaJaminan,a.Keterangan as NamaUnit,Ammount as TotalPaid,Kasir,Id_Kasir,isnull(Cetakan_Ke,0) as Cetakan_Ke
                FROM RawatInapSQL.dbo.Deposit a
                left join DashboardData.dbo.dataRWI b on a.NoRegistrasi=b.NoRegistrasi 
                where a.ID=:id";
            } elseif ($data['kodereg'] == 'TS') {
                $query = "SELECT a.NamaPembeli AS PatientName,  b2.Billto as BILLTO, '-' as NO_MR, a.NoRegistrasi as NO_REGISTRASI, a.NoEpisode as NO_EPISODE, '' as NO_KWITANSI, '' as USER_KASIR, b4.nominalbayar as NOMINAL_BAYAR, a.UnitOrder AS NamaUnit,
                case when a.GroupJaminan='2' then asu.NamaPerusahaan else jpk.NamaPerusahaan end AS NamaJaminan, '' AS Id_Kasir,
                SUBSTRING(x.nama_test,1, LEN(x.nama_test) - 1) NamaTest , y.nominal_bayar_tunai , z.nominal_bayar_Debit, w.nominal_bayar_PiuangPerushaan, wa.nominal_bayar_Qris
                FROM [Apotik_V1.1SQL].dbo.v_transaksi_sales_hdr a
                        OUTER APPLY (
                            SELECT Billto
                            FROM Billing_Pasien.dbo.FO_T_KASIR b1 
                            WHERE b1.NO_REGISTRASI = a.TransactionCode COLLATE  SQL_Latin1_General_CP1_CI_AS
                            GROUP BY Billto
                        ) b2 (Billto)
                        OUTER APPLY (
                            SELECT SUM(NOMINAL_BAYAR) as nominalbayar
                            FROM Billing_Pasien.dbo.FO_T_KASIR b3 
                            WHERE b3.NO_REGISTRASI = a.TransactionCode COLLATE  SQL_Latin1_General_CP1_CI_AS
                            GROUP BY Billto
                        ) b4 (nominalbayar)
                        OUTER APPLY (
                            SELECT NAMA_TARIF + ', '
                            FROM Billing_Pasien.dbo.FO_T_BILLING_1 b5
                            inner join Billing_Pasien.dbo.FO_T_KASIR b6 on b6.NO_REGISTRASI = a.TransactionCode COLLATE  SQL_Latin1_General_CP1_CI_AS
                            WHERE b5.ID_TRS_Payment = b6.NO_TRS AND b5.BATAL = '0'
                            FOR XML PATH('')
                        ) x (nama_test)
                        OUTER APPLY (
                            SELECT SUM(b7.NOMINAL_BAYAR) as bayartunai
                            FROM Billing_Pasien.dbo.FO_T_KASIR_2 b7
                            inner join Billing_Pasien.dbo.FO_T_KASIR b8 on b8.NO_REGISTRASI = a.TransactionCode COLLATE  SQL_Latin1_General_CP1_CI_AS
                            WHERE b7.NO_TRS_REFF = b8.NO_TRS AND TIPE_PEMBAYARAN = 'Tunai'
                        ) y (nominal_bayar_tunai)
                        OUTER APPLY (
                            SELECT SUM(b9.NOMINAL_BAYAR) as bayartunai
                            FROM Billing_Pasien.dbo.FO_T_KASIR_2 b9
                            inner join Billing_Pasien.dbo.FO_T_KASIR b10 on b10.NO_REGISTRASI = a.TransactionCode COLLATE  SQL_Latin1_General_CP1_CI_AS
                            WHERE b9.NO_TRS_REFF = b10.NO_TRS AND TIPE_PEMBAYARAN = 'Kartu Debit'
                        ) z (nominal_bayar_Debit)
                        OUTER APPLY (
                            SELECT SUM(b11.NOMINAL_BAYAR) as bayartunai
                            FROM Billing_Pasien.dbo.FO_T_KASIR_2 b11
                            inner join Billing_Pasien.dbo.FO_T_KASIR b12 on b12.NO_REGISTRASI = a.TransactionCode COLLATE  SQL_Latin1_General_CP1_CI_AS
                            WHERE b11.NO_TRS_REFF = b12.NO_TRS AND TIPE_PEMBAYARAN = 'Piutang Perusahaan'
                        ) w (nominal_bayar_PiuangPerushaan)
						OUTER APPLY (
                            SELECT SUM(b13.NOMINAL_BAYAR) as bayartunai
                            FROM Billing_Pasien.dbo.FO_T_KASIR_2 b13
                            inner join Billing_Pasien.dbo.FO_T_KASIR b14 on b14.NO_REGISTRASI = a.TransactionCode COLLATE  SQL_Latin1_General_CP1_CI_AS
                            WHERE b13.NO_TRS_REFF = b14.NO_TRS AND TIPE_PEMBAYARAN = 'QRIS'
                        ) wa (nominal_bayar_Qris)
                  left join MasterdataSQL.dbo.MstrPerusahaanJPK jpk on a.KodeJaminan=jpk.ID
                  left join MasterdataSQL.dbo.MstrPerusahaanAsuransi asu on a.KodeJaminan=asu.ID
                WHERE a.TransactionCode = :noreg1";
            } else {
                $pasing['NoKwitansi'] = '';
                $pasing['NoRegistrasi'] = '';
                $pasing['NoMR'] = '';
                $pasing['billto'] = '';
                $pasing['PatientName'] = '';
                $pasing['NamaJaminan'] = '';
                $pasing['NamaUnit'] = '';
                $pasing['Kasir'] = '';
                $pasing['Terbilang'] = '';
                $pasing['TotalPaid'] = '';
                $pasing['Id_Kasir'] = '';
                $pasing['Cetakan_Ke'] = '';
                $pasing['ID'] = '';
                return $pasing;
            }
            $this->db->query($query);
            $this->db->bind('noreg1', $data['notrs']);
            $datas =  $this->db->single();
            $terbilang = $this->terbilang($datas['NOMINAL_BAYAR']);
            $pasing['billto'] = $datas['BILLTO'];
            $pasing['NoMR'] = $datas['NO_MR'];
            $pasing['NoRegistrasi'] = $datas['NO_REGISTRASI'];
            $pasing['NO_EPISODE'] = $datas['NO_EPISODE'];
            $pasing['NoKwitansi'] = '';
            $pasing['PatientName'] = $datas['PatientName'];
            $pasing['NamaJaminan'] = $datas['NamaJaminan'];
            $pasing['NamaUnit'] = $datas['NamaUnit'];
            $pasing['NamaTest'] = $datas['NamaTest'];
            $pasing['Kasir'] = $namauserx;
            $pasing['Id_Kasir'] = $datas['Id_Kasir'];
            $pasing['Terbilang'] = $terbilang;
            $pasing['TotalPaid'] = number_format($datas['NOMINAL_BAYAR'], 0, ',', '.');

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    public function PrintKuitansiHeaderbyID($data)
    {
        // var_dump($data);
        // exit;
        try {
            if ($data['kodereg'] == 'RJ') {
                $query = "SELECT a.ID,NoKwitansi,a.NoRegistrasi,b.NoMR,case when billto is null then b.PatientName collate Latin1_General_CI_AS else billto end as billto,PatientName,NamaJaminan,NamaUnit,TotalPaid,Kasir,Id_Kasir,isnull(Cetakan_Ke,0) as Cetakan_Ke
                FROM PerawatanSQL.dbo.payments a
                left join DashboardData.dbo.DataRWJ b on a.NoRegistrasi=b.NoRegistrasi 
                where a.ID=:id";
            } elseif ($data['kodereg'] == 'RI') {
                $query = "  SELECT a.ID,NoKwitansi,a.NoRegistrasi,b.NoMR,
                case when billto is null then b.PatientName collate Latin1_General_CI_AS else billto end as billto,PatientName,NamaJaminan,a.Keterangan as NamaUnit,Ammount as TotalPaid,Kasir,Id_Kasir,isnull(Cetakan_Ke,0) as Cetakan_Ke
                FROM RawatInapSQL.dbo.Deposit a
                left join DashboardData.dbo.dataRWI b on a.NoRegistrasi=b.NoRegistrasi 
                where a.ID=:id";
            } elseif ($data['kodereg'] == 'PB') {
                $query = "SELECT a.ID,NoKwitansi,a.NoRegistrasi,'-' NoMR,case when billto is null then b.[Ship Name] collate Latin1_General_CI_AS else billto end as billto,[Ship Name] as PatientName,'-' NamaJaminan,'PEMBELIAN OBAT BEBAS' as NamaUnit,TotalPaid,Kasir,Id_Kasir,isnull(Cetakan_Ke,0) as Cetakan_Ke
                FROM PerawatanSQL.dbo.payments a
                left join [Apotik_V1.1SQL].dbo.Orders b on a.NoRegistrasi=b.NoRegistrasi
                where a.ID=:id";
            } else {
                $pasing['NoKwitansi'] = '';
                $pasing['NoRegistrasi'] = '';
                $pasing['NoMR'] = '';
                $pasing['billto'] = '';
                $pasing['PatientName'] = '';
                $pasing['NamaJaminan'] = '';
                $pasing['NamaUnit'] = '';
                $pasing['Kasir'] = '';
                $pasing['Terbilang'] = '';
                $pasing['TotalPaid'] = '';
                $pasing['Id_Kasir'] = '';
                $pasing['Cetakan_Ke'] = '';
                $pasing['ID'] = '';
                return $pasing;
            }
            $this->db->query($query);
            $this->db->bind('id', $data['notrs']);
            $datas =  $this->db->single();

            if ($data['lang'] == 'EN') {
                $terbilang = $this->terbilang_eng($datas['TotalPaid']);
            } else {
                $terbilang = $this->terbilang($datas['TotalPaid']);
            }

            // $pasing['TglCreate_sign'] = date('d/m/Y', strtotime($datas['TglCreate']));
            $pasing['NoKwitansi'] = $datas['NoKwitansi'];
            $pasing['NoRegistrasi'] = $datas['NoRegistrasi'];
            $pasing['NoMR'] = $datas['NoMR'];
            $pasing['billto'] = $datas['billto'];
            $pasing['PatientName'] = $datas['PatientName'];
            $pasing['NamaJaminan'] = $datas['NamaJaminan'];
            $pasing['NamaUnit'] = $datas['NamaUnit'];
            $pasing['Kasir'] = $datas['Kasir'];
            $pasing['Id_Kasir'] = $datas['Id_Kasir'];
            $pasing['Cetakan_Ke'] = $datas['Cetakan_Ke'];
            $pasing['ID'] = $datas['ID'];
            $pasing['Terbilang'] = $terbilang;
            $pasing['TotalPaid'] = number_format($datas['TotalPaid'], 0, ',', '.');

            // var_dump($pasing['TotalPaid']);
            // exit;

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function PrintKuitansiDetailbyIDX($data)
    {
        try {

            if ($data['kodereg'] == 'RJ' || $data['kodereg'] == 'PB') {
                $query = "SELECT b.TIPE_PEMBAYARAN, b.NOMINAL_BAYAR FROM Billing_Pasien.dbo.FO_T_KASIR a
                INNER JOIN Billing_Pasien.dbo.FO_T_KASIR_2 b ON b.NO_TRS_REFF = a.NO_TRS
                WHERE a.NO_REGISTRASI = :noreg AND  a.NO_TRS = :notrskasir";
            } elseif ($data['kodereg'] == 'RI') {
                $query = "SELECT TipePembayaran,TotalBayar as TotalPaid FROM RawatInapSQL.dbo.DepositDetails Where IDDeposit=:id";
            } else {
                $pasing['No'] = '';
                $pasing['TipePembayaran'] = '';
                $pasing['TotalPaid'] = '';
                $rows[] = $pasing;
                return $rows;
            }

            $this->db->query($query);
            $this->db->bind('noreg', $data['notrs']);
            $this->db->bind('notrskasir', $data['lang']);
            $data =  $this->db->resultSet();

            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['TipePembayaran'] = $key['TIPE_PEMBAYARAN'];
                $pasing['TotalPaid'] = number_format($key['NOMINAL_BAYAR'], 0, ',', '.');
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintKuitansiDetailbyAll($data)
    {
        try {
            if ($data['kodereg'] == 'RJ' || $data['kodereg'] == 'PB') {
                $query = "SELECT b.TIPE_PEMBAYARAN, b.NOMINAL_BAYAR FROM Billing_Pasien.dbo.FO_T_KASIR a
                INNER JOIN Billing_Pasien.dbo.FO_T_KASIR_2 b ON b.NO_TRS_REFF = a.NO_TRS
                WHERE a.NO_REGISTRASI = :noreg";
            } elseif ($data['kodereg'] == 'RI') {
                $query = "SELECT TipePembayaran,TotalBayar as TotalPaid FROM RawatInapSQL.dbo.DepositDetails Where IDDeposit=:id";
            } else {
                $pasing['No'] = '';
                $pasing['TipePembayaran'] = '';
                $pasing['TotalPaid'] = '';
                $rows[] = $pasing;
                return $rows;
            }

            $this->db->query($query);
            $this->db->bind('noreg', $data['notrs']);
            // $this->db->bind('notrskasir', $data['lang']);
            $data =  $this->db->resultSet();

            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['TipePembayaran'] = $key['TIPE_PEMBAYARAN'];
                $pasing['TotalPaid'] = number_format($key['NOMINAL_BAYAR'], 0, ',', '.');
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintKuitansiDetailbyID($data)
    {
        try {

            if ($data['kodereg'] == 'RJ' || $data['kodereg'] == 'PB') {
                $query = "SELECT TipePembayaran,TotalPaid FROM PerawatanSQL.dbo.PaymentDetails Where PaymentID=:id";
            } elseif ($data['kodereg'] == 'RI') {
                $query = "SELECT TipePembayaran,TotalBayar as TotalPaid FROM RawatInapSQL.dbo.DepositDetails Where IDDeposit=:id";
            } else {
                $pasing['No'] = '';
                $pasing['TipePembayaran'] = '';
                $pasing['TotalPaid'] = '';
                $rows[] = $pasing;
                return $rows;
            }

            $this->db->query($query);
            $this->db->bind('id', $data['notrs']);
            $data =  $this->db->resultSet();

            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['TipePembayaran'] = $key['TipePembayaran'];
                $pasing['TotalPaid'] = number_format($key['TotalPaid'], 0, ',', '.');
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintKuitansiHeaderbyReg($data)
    {
        try {

            if ($data['kodereg'] == 'RJ') {
                $query = "SELECT a.ID,dd.NO_REGISTRASI as NoRegistrasi,dd.NO_MR as NoMR,
                case when dd.BILLTO is null then b.PatientName collate Latin1_General_CI_AS else dd.BILLTO end as billto 
                ,b.PatientName,NamaPerusahaan as NamaJaminan,c.NamaUnit,sum(dd.NOMINAL_BAYAR)as TotalPaid,USER_KASIR as Kasir ,a.ID as Id_Kasir,a.ID as Cetakan_Ke
                from Billing_Pasien.dbo.FO_T_KASIR dd
                inner join PerawatanSQL.dbo.Visit a on dd.NO_REGISTRASI collate Latin1_General_CI_AS = a.NoRegistrasi
                inner join MasterdataSQL.dbo.Admision b on dd.NO_MR collate Latin1_General_CI_AS = b.NoMR collate Latin1_General_CI_AS
                inner join MasterdataSQL.dbo.MstrUnitPerwatan c on a.Unit= c.ID
                inner join MasterdataSQL.dbo.MstrPerusahaanJPK d on a.Perusahaan = d.ID
                where dd.NO_REGISTRASI=:id
                group by a.ID,dd.NO_REGISTRASI,dd.NO_MR,dd.BILLTO,b.PatientName ,b.PatientName,NamaPerusahaan,c.NamaUnit,USER_KASIR
                union all SELECT a.ID,dd.NO_REGISTRASI as NoRegistrasi,dd.NO_MR as NoMR,
                case when dd.BILLTO is null then b.PatientName collate Latin1_General_CI_AS else dd.BILLTO end as billto 
                ,b.PatientName,NamaPerusahaan as NamaJaminan,c.NamaUnit,sum(dd.NOMINAL_BAYAR)as TotalPaid,USER_KASIR,a.ID as Id_Kasir,a.ID as Cetakan_Ke
                from Billing_Pasien.dbo.FO_T_KASIR dd
                inner join PerawatanSQL.dbo.Visit a on dd.NO_REGISTRASI collate Latin1_General_CI_AS = a.NoRegistrasi
                inner join MasterdataSQL.dbo.Admision b on dd.NO_MR collate Latin1_General_CI_AS = b.NoMR collate Latin1_General_CI_AS
                inner join MasterdataSQL.dbo.MstrUnitPerwatan c on a.Unit= c.ID
                inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi d on a.Asuransi = d.ID
                where dd.NO_REGISTRASI=:id2
                group by a.ID,dd.NO_REGISTRASI,dd.NO_MR,dd.BILLTO,b.PatientName ,b.PatientName,NamaPerusahaan,c.NamaUnit,USER_KASIR";
            } elseif ($data['kodereg'] == 'RI') {
                $query = "SELECT a.ID,NoKwitansi,a.NoRegistrasi,b.NoMR,
                case when billto is null then b.PatientName collate Latin1_General_CI_AS else billto end as billto,PatientName,NamaJaminan,a.Keterangan as NamaUnit,Ammount as TotalPaid,Kasir,Id_Kasir,isnull(Cetakan_Ke,0) as Cetakan_Ke
                FROM RawatInapSQL.dbo.Deposit a
                left join DashboardData.dbo.dataRWI b on a.NoRegistrasi=b.NoRegistrasi 
                where a.NoRegistrasi=:id";
            } elseif ($data['kodereg'] == 'PB') {
                $query = "SELECT a.ID,NoKwitansi,a.NoRegistrasi,'-' NoMR,
				case when billto is null then b.[Ship Name] collate Latin1_General_CI_AS else billto end as billto,[Ship Name] as PatientName,'-' NamaJaminan,'PEMBELIAN OBAT BEBAS' as NamaUnit,sum(c.TotalPaid) as TotalPaid,Kasir,Id_Kasir,isnull(Cetakan_Ke,0) as Cetakan_Ke
                FROM PerawatanSQL.dbo.payments a
                left join [Apotik_V1.1SQL].dbo.Orders b on a.NoRegistrasi=b.NoRegistrasi
                inner join PerawatanSQL.dbo.paymentDetails c on a.ID=c.PaymentID
                where a.NoRegistrasi=:id
				group by  a.ID,NoKwitansi,a.NoRegistrasi,b.[Ship Name],Kasir,Billto,Id_Kasir,Cetakan_Ke";
            } else {
                $pasing['NoKwitansi'] = '';
                $pasing['NoRegistrasi'] = '';
                $pasing['NoMR'] = '';
                $pasing['billto'] = '';
                $pasing['PatientName'] = '';
                $pasing['NamaJaminan'] = '';
                $pasing['NamaUnit'] = '';
                $pasing['Kasir'] = '';
                $pasing['Terbilang'] = '';
                $pasing['TotalPaid'] = '';
                $pasing['Id_Kasir'] = '';
                $pasing['Cetakan_Ke'] = '';
                return $pasing;
            }
            $this->db->query($query);
            $this->db->bind('id', $data['notrs']);
            $this->db->bind('id2', $data['notrs']);
            $datas =  $this->db->single();

            if ($data['lang'] == 'EN') {
                $terbilang = $this->terbilang_eng($datas['TotalPaid']);
            } else {
                $terbilang = $this->terbilang($datas['TotalPaid']);
            }

            // $pasing['TglCreate_sign'] = date('d/m/Y', strtotime($datas['TglCreate']));
            $pasing['ID'] = $datas['ID'];
            // $pasing['NoKwitansi'] = $datas['NoKwitansi'];
            $pasing['NoRegistrasi'] = $datas['NoRegistrasi'];
            $pasing['NoMR'] = $datas['NoMR'];
            $pasing['billto'] = $datas['billto'];
            $pasing['PatientName'] = $datas['PatientName'];
            $pasing['NamaJaminan'] = $datas['NamaJaminan'];
            $pasing['NamaUnit'] = $datas['NamaUnit'];
            $pasing['Kasir'] = $datas['Kasir'];
            $pasing['Id_Kasir'] = $datas['Id_Kasir'];
            $pasing['Cetakan_Ke'] = $datas['Cetakan_Ke'];
            $pasing['Terbilang'] = $terbilang;
            $pasing['TotalPaid'] = number_format($datas['TotalPaid'], 0, ',', '.');

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintKuitansiDetailbyReg($data)
    {
        try {

            if ($data['kodereg'] == 'RJ' || $data['kodereg'] == 'PB') {
                $query = "SELECT a.TIPE_PEMBAYARAN as TipePembayaran ,sum(a.NOMINAL_BAYAR) as TotalPaid,''Keterangan,
                replace(CONVERT(VARCHAR(11), b.TGL_TRS, 111), '/','-') as Paymentdate,BILLTO as Billto
                from Billing_Pasien.dbo.FO_T_KASIR_2 a
                inner join Billing_Pasien.dbo.FO_T_KASIR b on a.NO_TRS_REFF = b.NO_TRS where b.NO_REGISTRASI=:id and a.TIPE_PEMBAYARAN='Tunai' and BILLTO is not null and a.NOMINAL_BAYAR is not null
                group by a.TIPE_PEMBAYARAN, b.TGL_TRS, BILLTO
                union all SELECT a.TIPE_PEMBAYARAN as TipePembayaran ,sum(a.NOMINAL_BAYAR) as TotalPaid,''Keterangan,
                replace(CONVERT(VARCHAR(11), b.TGL_TRS, 111), '/','-') as Paymentdate,BILLTO as Billto
                from Billing_Pasien.dbo.FO_T_KASIR_2 a
                inner join Billing_Pasien.dbo.FO_T_KASIR b on a.NO_TRS_REFF = b.NO_TRS where b.NO_REGISTRASI=:id2 and a.TIPE_PEMBAYARAN='Kartu Debit' and BILLTO is not null and a.NOMINAL_BAYAR is not null
                group by a.TIPE_PEMBAYARAN, b.TGL_TRS, BILLTO
                union all SELECT a.TIPE_PEMBAYARAN as TipePembayaran ,sum(a.NOMINAL_BAYAR) as TotalPaid,''Keterangan,
                replace(CONVERT(VARCHAR(11), b.TGL_TRS, 111), '/','-') as Paymentdate,BILLTO as Billto
                from Billing_Pasien.dbo.FO_T_KASIR_2 a
                inner join Billing_Pasien.dbo.FO_T_KASIR b on a.NO_TRS_REFF = b.NO_TRS where b.NO_REGISTRASI=:id3 and a.TIPE_PEMBAYARAN='Piutang Perusahaan' and BILLTO is not null and a.NOMINAL_BAYAR is not null
                group by a.TIPE_PEMBAYARAN, b.TGL_TRS, BILLTO";
            } elseif ($data['kodereg'] == 'RI') {
                $query = "SELECT a.TipePembayaran,a.TotalBayar as TotalPaid,b.Keterangan,replace(CONVERT(VARCHAR(11), b.Paymentdate, 111), '/','-') as Paymentdate,Billto
                 FROM RawatInapSQL.dbo.DepositDetails a
                 Inner join RawatInapSQL.dbo.Deposit b on a.IDDeposit=b.Id
                 Where NoRegistrasi=:id";
            } else {
                $pasing['No'] = '';
                $pasing['TipePembayaran'] = '';
                $pasing['TotalPaid'] = '';
                $pasing['TotalPaidRaw'] = '';
                $pasing['Keterangan'] = '';
                $pasing['Paymentdate'] = '';
                $pasing['Billto'] = '';
                $rows[] = $pasing;
                return $rows;
            }

            $this->db->query($query);
            $this->db->bind('id', $data['notrs']);
            $this->db->bind('id2', $data['notrs']);
            $this->db->bind('id3', $data['notrs']);

            $datas =  $this->db->resultSet();

            $rows = array();
            $no = 1;
            $pasing['TotalPaidRaw'] = 0;
            foreach ($datas as $key) {
                $pasing['No'] = $no++;
                $pasing['TipePembayaran'] = $key['TipePembayaran'];
                $pasing['TotalPaid'] = number_format($key['TotalPaid'], 0, ',', '.');
                $pasing['TotalPaidRaw'] += $key['TotalPaid'];
                $pasing['Keterangan'] = $key['Keterangan'];
                $pasing['Paymentdate'] = date('d M Y', strtotime($key['Paymentdate']));
                $pasing['Billto'] = $key['Billto'];
                $rows[] = $pasing;
            }

            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function PrintKuitansiDetailbyRegidtrs($data)
    {
        try {
            if ($data['kodereg'] == 'RJ' || $data['kodereg'] == 'PB') {
                $query = "SELECT a.TIPE_PEMBAYARAN as TipePembayaran, SUM(a.NOMINAL_BAYAR) as TotalPaid, '' Keterangan, replace(CONVERT(VARCHAR(11), b.TGL_TRS, 111), '/','-') as Paymentdate,BILLTO as Billto
                FROM Billing_Pasien.dbo.FO_T_KASIR_2 a
                 inner join Billing_Pasien.dbo.FO_T_KASIR b on a.NO_TRS_REFF = b.NO_TRS where b.NO_REGISTRASI=:noreg AND b.NO_TRS = :idtrs
                GROUP BY a.TIPE_PEMBAYARAN, b.TGL_TRS, BILLTO";
            } elseif ($data['kodereg'] == 'RI') {
                $query = "SELECT a.TipePembayaran,a.TotalBayar as TotalPaid,b.Keterangan,replace(CONVERT(VARCHAR(11), b.Paymentdate, 111), '/','-') as Paymentdate,Billto
                 FROM RawatInapSQL.dbo.DepositDetails a
                 Inner join RawatInapSQL.dbo.Deposit b on a.IDDeposit=b.Id
                 Where NoRegistrasi=:id";
            } else {
                $pasing['No'] = '';
                $pasing['TipePembayaran'] = '';
                $pasing['TotalPaid'] = '';
                $pasing['TotalPaidRaw'] = '';
                $pasing['Keterangan'] = '';
                $pasing['Paymentdate'] = '';
                $pasing['Billto'] = '';
                $rows[] = $pasing;
                return $rows;
            }

            $this->db->query($query);
            $this->db->bind('noreg', $data['notrs']);
            $this->db->bind('idtrs', $data['lang']);
            $datas =  $this->db->resultSet();

            $rows = array();
            $no = 1;
            $pasing['TotalPaidRaw'] = 0;
            foreach ($datas as $key) {
                $pasing['No'] = $no++;
                $pasing['TipePembayaran'] = $key['TipePembayaran'];
                $pasing['TotalPaid'] = number_format($key['TotalPaid'], 0, ',', '.');
                $pasing['TotalPaidRaw'] += $key['TotalPaid'];
                $pasing['Keterangan'] = $key['Keterangan'];
                $pasing['Paymentdate'] = date('d M Y', strtotime($key['Paymentdate']));
                $pasing['Billto'] = $key['Billto'];
                $rows[] = $pasing;
            }

            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    public function PrintKuitansiDetailbyRegidtrsAll($data)
    {
        try {
            if ($data['kodereg'] == 'RJ' || $data['kodereg'] == 'PB') {
                // $query = "SELECT a.TIPE_PEMBAYARAN as TipePembayaran, SUM(a.NOMINAL_BAYAR) as TotalPaid, '' Keterangan, replace(CONVERT(VARCHAR(11), b.TGL_TRS, 111), '/','-') as Paymentdate,BILLTO as Billto
                // FROM Billing_Pasien.dbo.FO_T_KASIR_2 a
                //  inner join Billing_Pasien.dbo.FO_T_KASIR b on a.NO_TRS_REFF = b.NO_TRS where b.NO_REGISTRASI=:noreg
                // GROUP BY a.TIPE_PEMBAYARAN, b.TGL_TRS, BILLTO";
                $query = "SELECT a.TIPE_PEMBAYARAN as TipePembayaran, SUM(a.NOMINAL_BAYAR) as TotalPaid, '' Keterangan
                FROM Billing_Pasien.dbo.FO_T_KASIR_2 a
                inner join Billing_Pasien.dbo.FO_T_KASIR b on a.NO_TRS_REFF = b.NO_TRS where b.NO_REGISTRASI=:noreg AND a.BATAL = '0' AND b.BATAL = '0'
                GROUP BY a.TIPE_PEMBAYARAN";
            } elseif ($data['kodereg'] == 'RI') {
                $query = "SELECT a.TipePembayaran,a.TotalBayar as TotalPaid,b.Keterangan,replace(CONVERT(VARCHAR(11), b.Paymentdate, 111), '/','-') as Paymentdate,Billto
                 FROM RawatInapSQL.dbo.DepositDetails a
                 Inner join RawatInapSQL.dbo.Deposit b on a.IDDeposit=b.Id
                 Where NoRegistrasi=:id";
            } else {
                $pasing['No'] = '';
                $pasing['TipePembayaran'] = '';
                $pasing['TotalPaid'] = '';
                $pasing['TotalPaidRaw'] = '';
                $pasing['Keterangan'] = '';
                $pasing['Paymentdate'] = '';
                $pasing['Billto'] = '';
                $rows[] = $pasing;
                return $rows;
            }

            $this->db->query($query);
            $this->db->bind('noreg', $data['notrs']);
            // $this->db->bind('idtrs', $data['lang']);
            $datas =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            $pasing['TotalPaidRaw'] = 0;
            foreach ($datas as $key) {
                $pasing['No'] = $no++;
                $pasing['TipePembayaran'] = $key['TipePembayaran'];
                $pasing['TotalPaid'] = number_format($key['TotalPaid'], 0, ',', '.');
                $pasing['TotalPaidRaw'] += $key['TotalPaid'];
                $pasing['Keterangan'] = $key['Keterangan'];
                $pasing['Paymentdate'] = '';
                $pasing['Billto'] = '';
                $rows[] = $pasing;
            }

            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function GetSignUser($data)
    {
        try {
            $query = "SELECT FileDocument,username
                FROM MasterdataSQL.dbo.Employees 
                where ID=:id";
            $this->db->query($query);
            $this->db->bind('id', $data['id_employee']);
            $datas =  $this->db->single();

            $pasing['AWSSign'] = $datas['FileDocument'];
            $pasing['username'] = $datas['username'];

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function goUpdateCetakanbyID($data)
    {
        try {
            $this->db->transaksi();
            $kodereg = $data['kodereg'];
            $notrs = $data['notrs'];

            if ($kodereg == 'RJ' || $kodereg == 'PB') {
                $query = "UPDATE PerawatanSQL.dbo.payments set Cetakan_Ke=isnull(Cetakan_Ke,0)+1 WHERE Id=:id";
            } elseif ($kodereg == 'RI') {
                $query = "UPDATE RawatInapSQL.dbo.Deposit set Cetakan_Ke=isnull(Cetakan_Ke,0)+1 WHERE Id=:id";
            }

            $this->db->query($query);
            $this->db->bind('id', $notrs);
            $this->db->execute();
            $this->db->commit();

            $callback = array(
                'status' => 'success',
                'message' => 'Berhasil Simpan Data!',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function CountCetak($data)
    {
        $notrs  = $data['notrs'];
        $signAlasanCetak  = $data['signAlasanCetak'];
        $jeniscetakan  = $data['jeniscetakan'];
        $kodereg = $data['kodereg'];
        if ($notrs == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Nomor Transaksi Kosong !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($signAlasanCetak == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Alasan Cetak kosong !',
            );
            echo json_encode($callback);
            exit;
        }
        $datenow = Utils::seCurrentDateTime();
        $session = SessionManager::getCurrentSession();
        $namauserx = $session->name;


        try {
            $this->db->transaksi();
            $fixjeniscetakan = $jeniscetakan;

            if ($fixjeniscetakan == 'KUITANSI') {
                if ($kodereg == 'RJ' || $kodereg == 'PB') {
                    $query = "UPDATE PerawatanSQL.dbo.payments set Cetakan_Ke=isnull(Cetakan_Ke,0)+1 WHERE Id=:id";
                } elseif ($kodereg == 'RI') {
                    $query = "UPDATE RawatInapSQL.dbo.Deposit set Cetakan_Ke=isnull(Cetakan_Ke,0)+1 WHERE Id=:id";
                }
                $this->db->query($query);
                $this->db->bind('id', $notrs);
                $this->db->execute();
            }

            $query = "INSERT INTO SysLog.[dbo].TZ_LOG_PRINT
           (NO_TRS_REFF
           ,ALASAN_CETAK
           ,DATE_CREATE
           ,USER_CREATE
           ,JENIS_CETAK )
            VALUES
                (
                :UUID
                ,:namaparam
                ,:imagepath
                ,:gruptransaksi
                ,:nomortransaksi 
                )
                ";

            $this->db->query($query);
            $this->db->bind('UUID', $notrs);
            $this->db->bind('namaparam', $signAlasanCetak);
            $this->db->bind('imagepath', $datenow);
            $this->db->bind('gruptransaksi', $namauserx);
            $this->db->bind('nomortransaksi', $fixjeniscetakan);
            $this->db->execute();
            $this->db->Commit();
            $callback = [
                'status' => 200,
                'message' => 'Berhasil Simpan!'
            ];
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    // public function uploadAWS($data)
    // {
    //     $notrs = $data['notrs'];

    //     $bytes = random_bytes(20);
    //     $nama_file_baru  =     $notrs . bin2hex($bytes) . "-" . date("YmdHis");
    //     $nama_file = $data['GrupTransaksi'] . '-' . $notrs . '.pdf';

    //     /// AWS
    //     // Create an S3Client
    //     $s3Client = new S3Client([
    //         'version' => 'latest',
    //         'region'  => 'ap-southeast-1',
    //         'http'    => ['verify' => false],
    //         'credentials' => [
    //             'key'    => 'AKIAYV2M6ERJGUKK4QWQ',
    //             'secret' => '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'
    //         ]
    //     ]);
    //     //$file_name = __DIR__ . '/../../public' . '/tmp/' . $nama_file;
    //     $file_name = $_SERVER['DOCUMENT_ROOT'] . 'SIKBREC/public/tmp/' . $nama_file;
    //     $source =   $file_name;
    //     $awsImages = '';
    //     $handle = fopen($source, 'r');
    //     try {
    //         $bucket = 'rsuyarsibucket';
    //         $key = basename($nama_file_baru);
    //         $result = $s3Client->putObject([
    //             'Bucket' => $bucket,
    //             //'Key'    => 'digitalfiles/akadijaroh/' . $key,
    //             'Key'    => 'digitalfiles/billing/' . $key,
    //             'Body'   => $handle,
    //             'ACL'    => 'public-read', // make file 'public', 
    //         ]);
    //         $awsImages = $result->get('ObjectURL');

    //         //close filenya
    //         fclose($handle);
    //         //hapus filenya 
    //         unlink($_SERVER["DOCUMENT_ROOT"] . 'SIKBREC/public/tmp/' . $nama_file);

    //         return $this->SaveFile($data, $awsImages);
    //     } catch (MultipartUploadException $e) {

    //         return $e->getMessage();
    //     }
    // }

    // public function SaveFile($data, $awsImages)
    // {
    //     try {
    //         $this->db->transaksi();
    //         $session = SessionManager::getCurrentSession();
    //         $userlogin = $session->IDEmployee;
    //         $usernamelogin = $session->name;

    //         $datenowcreate = Utils::seCurrentDateTime();
    //         $uuid = $data['uuid4'];

    //         if (substr($data['GrupTransaksi'], 0, 8) == 'KUITANSI') {
    //             $DocumentType = 'KUITANSI_BILLING';
    //         } else {
    //             $DocumentType = 'RINCIAN_BILLING';
    //         }

    //         $query = "UPDATE a
    //           SET Active='0' 
    //           FROM Billing_Pasien.dbo.TDocumentMasters a
    //           inner join Billing_Pasien.dbo.TDocumentBillingPatients b on a.Uuid=b.DocTransactionID
    //           WHERE GrupTransaksi=:GrupTransaksi and NoTrs_Reff=:id and NoRegistrasi=:NoRegistrasi
    //           ";
    //         $this->db->query($query);
    //         $this->db->bind('id', $data['notrs']);
    //         $this->db->bind('NoRegistrasi', $data['listdataheader']['NoRegistrasi']);
    //         $this->db->bind('GrupTransaksi', $data['GrupTransaksi']);
    //         $this->db->execute();

    //         $query = "INSERT INTO Billing_Pasien.dbo.TDocumentMasters (Uuid,DateCreate,UserCreate,DocumentType,AwsUrlDocuments,NamaTTD1)
    //             Values
    //         (:uuid,:datenowcreate,:userlogin,:DocumentType,:AWS_URL,:usernamelogin)";
    //         $this->db->query($query);
    //         $this->db->bind('uuid', $uuid);
    //         $this->db->bind('datenowcreate', $datenowcreate);
    //         $this->db->bind('userlogin', $userlogin);
    //         $this->db->bind('DocumentType', $DocumentType);
    //         $this->db->bind('AWS_URL', $awsImages);
    //         $this->db->bind('usernamelogin', $usernamelogin);
    //         $this->db->execute();

    //         $query = "UPDATE Billing_Pasien.dbo.TDocumentBillingPatients SET ActiveDocument='0' WHERE GrupTransaksi=:GrupTransaksi and NoTrs_Reff=:id and NoRegistrasi=:NoRegistrasi";
    //         $this->db->query($query);
    //         $this->db->bind('id', $data['notrs']);
    //         $this->db->bind('NoRegistrasi', $data['listdataheader']['NoRegistrasi']);
    //         $this->db->bind('GrupTransaksi', $data['GrupTransaksi']);
    //         $this->db->execute();

    //         $query = "INSERT INTO  Billing_Pasien.dbo.TDocumentBillingPatients (DocTransactionID,NoTrs_Reff,NoRegistrasi,GrupTransaksi,AwsUrlDocuments,TglCreate,UserCreate)
    //             Values
    //         (:uuid,:id,:NoRegistrasi,:GrupTransaksi,:AWS_URL,:datenowcreate,:userlogin)";
    //         $this->db->query($query);
    //         $this->db->bind('uuid', $uuid);
    //         $this->db->bind('id', $data['notrs']);
    //         $this->db->bind('NoRegistrasi', $data['listdataheader']['NoRegistrasi']);
    //         $this->db->bind('GrupTransaksi', $data['GrupTransaksi']);
    //         $this->db->bind('AWS_URL', $awsImages);
    //         $this->db->bind('datenowcreate', $datenowcreate);
    //         $this->db->bind('userlogin', $userlogin);
    //         $this->db->execute();


    //         $query = "INSERT INTO  Billing_Pasien.dbo.TDocumentHistoryBillingPatients (DocTransactionID,CetakanKe,Alasan_Cetak,UserCreate,DateCreate)
    //             Values
    //         (:uuid,:CetakanKe,:Alasan_Cetak,:userlogin,:datenowcreate)";
    //         $this->db->query($query);
    //         $this->db->bind('uuid', $uuid);
    //         $this->db->bind('CetakanKe', $data['cetakanke']['CetakanKe']);
    //         $this->db->bind('Alasan_Cetak', '');
    //         $this->db->bind('userlogin', $userlogin);
    //         $this->db->bind('datenowcreate', $datenowcreate);
    //         $this->db->execute();


    //         $this->db->Commit();
    //         $callback = array(
    //             'status' => 200,
    //             'message' => 'Generate Upload Data Succesfully.',
    //             'aws_url' =>  $awsImages,
    //         );
    //         return $callback;
    //     } catch (PDOException $e) {
    //         $this->db->rollback();
    //         $callback = array(
    //             'status' => 'warning',
    //             'message' => $e,
    //         );
    //         return $callback;
    //     }
    // }

    public function getAWSURL($data)
    {
        try {
            $query = "SELECT AwsUrlDocuments,ID
                FROM Billing_Pasien.dbo.TDocumentBillingPatients
                where NoTrs_Reff=:notrs AND GrupTransaksi=:jeniscetakan AND NoRegistrasi=:noregistrasi and ActiveDocument='1'";
            $this->db->query($query);
            $this->db->bind('notrs', $data['notrs']);
            $this->db->bind('jeniscetakan', $data['jeniscetakan']);
            $this->db->bind('noregistrasi', $data['noregistrasi']);
            $datas =  $this->db->single();

            $pasing['AwsUrlDocuments'] = $datas['AwsUrlDocuments'];
            $pasing['ID'] = $datas['ID'];

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintRincianHeaderbyReg($data)
    {
        try {
            if ($data['kodereg'] == 'RJ') {
                $query = "SELECT a.NoRegistrasi,'' NoReff,replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') as TglKunjungan, a.NoMR, PatientName,
                a.ValueDiscount,c.id as IdUnit,NamaUnit,d.First_Name  as NamaDokter,replace(CONVERT(VARCHAR(11), b.Date_of_birth, 111), '/','-') as DateOfBirth,
                f.NamaPerusahaan as NamaJaminan,replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') as TglPulang,a.NoSEP,''Gander,''NoRegisRWJ,''Address,
                cob.NamaCOB,'' as NamaUnit_RWJ,0 as BiayaAdm,0 as Discount,0 as materai,a.JamPulang
                                FROM PerawatanSQL.dbo.Visit a
                                --inner join DashboardData.dbo.DataRWJ b on a.NoRegistrasi=b.NoRegistrasi
                                            inner join MasterDataSQL.dbo.Admision b on a.NoMR=b.NoMR
                                 left join MasterDataSQL.dbo.MstrUnitPerwatan c on a.Unit=c.ID 
                            left join MasterDataSQL.dbo.Doctors d on a.Doctor_1=d.ID 
                            inner join MasterdataSQL.dbo.MstrTypePatient e on a.PatientType=e.ID 
                            inner join MasterDataSQL.dbo.MstrPerusahaanAsuransi f on a.Asuransi=f.ID
                            inner join RawatInapSQL.dbo.[Visit Status] ss on a.[Status ID]=ss.[Status ID]
                            left join MasterdataSQL.dbo.MasterCOB cob on a.KodeJaminanCOB=cob.ID
                                WHERE a.NoRegistrasi=:id
                union all SELECT a.NoRegistrasi,'' NoReff,a.[Visit Date]  as TglKunjungan, a.NoMR, PatientName,
                a.ValueDiscount,c.id,NamaUnit,d.First_Name as NamaDokter,replace(CONVERT(VARCHAR(11), b.Date_of_birth, 111), '/','-') as DateOfBirth,
                f.NamaPerusahaan,replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') as TglPulang,a.NoSEP,''Gander,''NoRegisRWJ,''Address,
                cob.NamaCOB,'' as NamaUnit_RWJ,0 as BiayaAdm,0 as Discount,0 as materai,a.JamPulang
                                FROM PerawatanSQL.dbo.Visit a
                                --inner join DashboardData.dbo.DataRWJ b on a.NoRegistrasi=b.NoRegistrasi
                                            inner join MasterDataSQL.dbo.Admision b on a.NoMR=b.NoMR
                                 left join MasterDataSQL.dbo.MstrUnitPerwatan c on a.Unit=c.ID 
                            left join MasterDataSQL.dbo.Doctors d on a.Doctor_1=d.ID 
                            inner join MasterdataSQL.dbo.MstrTypePatient e on a.PatientType=e.ID 
                            inner join MasterDataSQL.dbo.MstrPerusahaanJPK f on a.Perusahaan=f.ID
                            inner join RawatInapSQL.dbo.[Visit Status] ss on a.[Status ID]=ss.[Status ID]
                            left join MasterdataSQL.dbo.MasterCOB cob on a.KodeJaminanCOB=cob.ID
                                WHERE a.NoRegistrasi=:id2";
            } elseif ($data['kodereg'] == 'RI') {
                $query = "SELECT a.NoRegRI as NoRegistrasi,'' as NoReff,a.[StartDate] as TglKunjungan, 
				a.NoMR, b.PatientName, a.Discount as ValueDiscount,d.NamaKelas as  IdUnit,e.RoomName+' / '+e.Bed as NamaUnit,c.First_Name NamaDokter,replace(CONVERT(VARCHAR(11), Date_of_Birth, 111), '/','-') as DateOfBirth
				,case when a.TypePatient='2' then opx.NamaPerusahaan else op.NamaPerusahaan end as NamaJaminan,
				replace(CONVERT(VARCHAR(11), a.[EndDate], 111), '/','-') as TglPulang,a.NoSEP,b.Gander,a.NoRegisRWJ,b.Address,cob.NamaCOB,m.NamaUnit as NamaUnit_RWJ,a.BiayaAdm,a.Discount,a.materai
                FROM RawatInapSQL.dbo.Inpatient a 
                inner join MasterDataSQL.dbo.Admision b on a.NoMR=b.NoMR
				left join MasterdataSQL.dbo.Doctors c on a.drPenerima=c.ID
                left join MasterdataSQL.dbo.MstrPerusahaanJPK op on a.IDJPK=op.ID
				left join MasterdataSQL.dbo.MstrPerusahaanAsuransi opx on a.IDAsuransi=opx.ID
                inner join RawatInapSQL.dbo.tblKelas d on a.KlsID=d.IDKelas
                left join RawatInapSQL.dbo.Inpatient_in_out e on a.RoomID_Akhir=e.ID
                left join MasterdataSQL.dbo.MasterCOB cob on a.KodeJaminanCOB=cob.ID
                left join PerawatanSQL.dbo.Visit v on a.NoRegisRWJ=v.NoRegistrasi
                left join MasterdataSQL.dbo.MstrUnitPerwatan m on v.Unit=m.ID
                WHERE a.NoRegRI=:id
                ";
            } elseif ($data['kodereg'] == 'PB') {
                $query = "SELECT NoRegistrasi,NoResep as NoReff,replace(CONVERT(VARCHAR(11), [Order Date], 111), '/','-') as TglKunjungan,'-' as NoMR,[Ship Name] as PatientName,isnull(ValueDiscount,0) as ValueDiscount,''IdUnit,''NamaUnit,''NamaDokter,'' as DateOfBirth,''NamaJaminan,'' TglPulang,'' as NoSEP,''Gander,''NoRegisRWJ,''Address,'' NamaCOB,'' as NamaUnit_RWJ,0 as BiayaAdm,0 as Discount,0 as materai
                FROM  [Apotik_V1.1SQL].dbo.Orders 
                where NoRegistrasi=:id";
            } else {
                $pasing['NoRegistrasi'] = '';
                $pasing['NoReff'] = '';
                $pasing['NoMR'] = '';
                $pasing['PatientName'] = '';
                $pasing['TglKunjungan'] = '';
                $pasing['ValueDiscount'] = 0;
                $pasing['IdUnit'] = '';
                $pasing['NamaUnit'] = '';
                $pasing['NamaDokter'] = '';
                $pasing['DateOfBirth'] = '';
                $pasing['NamaJaminan'] = '';
                $pasing['TglPulang'] = '';
                $pasing['NoSEP'] = '';
                $pasing['Gander'] = '';
                $pasing['NoRegisRWJ'] = '';
                $pasing['Address'] = '';
                $pasing['NamaCOB'] = '';
                $pasing['NamaUnit_RWJ'] = '';
                $pasing['BiayaAdm'] = '';
                $pasing['Discount'] = '';
                $pasing['materai'] = '';
                $pasing['JamPulang'] = '';
                return $pasing;
            }
            $this->db->query($query);
            $this->db->bind('id', $data['notrs']);
            $this->db->bind('id2', $data['notrs']);
            $datas =  $this->db->single();

            $pasing['TglKunjungan'] = ($datas['TglKunjungan'] != null) ? date('d/m/Y', strtotime($datas['TglKunjungan'])) . ' - ' . date('H:i:s', strtotime($datas['TglKunjungan'])) : '';
            $pasing['NoRegistrasi'] = $datas['NoRegistrasi'];
            $pasing['NoReff'] = $datas['NoReff'];
            $pasing['NoMR'] = $datas['NoMR'];
            $pasing['PatientName'] = $datas['PatientName'];
            $pasing['ValueDiscount'] = $datas['ValueDiscount'];
            $pasing['IdUnit'] = $datas['IdUnit'];
            $pasing['NamaUnit'] = $datas['NamaUnit'];
            $pasing['NamaDokter'] = $datas['NamaDokter'];
            //$pasing['DateOfBirth'] = date('d/m/Y', strtotime($datas['DateOfBirth']));
            $pasing['DateOfBirth'] = ($datas['DateOfBirth'] != null) ? date('d/m/Y', strtotime($datas['DateOfBirth'])) : '';
            $pasing['NamaJaminan'] = $datas['NamaJaminan'];
            // $pasing['TglPulang'] = ($datas['TglPulang'] != null) ? date('d/m/Y', strtotime($datas['TglPulang'])) . ' - ' . date('H:i:s', strtotime($datas['TglPulang'])) : '';
            $pasing['NoSEP'] = $datas['NoSEP'];
            $pasing['Gander'] = $datas['Gander'];
            $pasing['NoRegisRWJ'] = $datas['NoRegisRWJ'];
            $pasing['Address'] = $datas['Address'];
            $pasing['NamaCOB'] = $datas['NamaCOB'];
            $pasing['NamaUnit_RWJ'] = $datas['NamaUnit_RWJ'];
            $pasing['BiayaAdm'] = $datas['BiayaAdm'];
            $pasing['Discount'] = $datas['Discount'];
            $pasing['materai'] = $datas['materai'];
            $pasing['JamPulang'] = ($datas['JamPulang'] != null) ? date('d/m/Y', strtotime($datas['JamPulang'])) . ' - ' . date('H:i:s', strtotime($datas['JamPulang'])) : '';
            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintRincianHeaderbyRegAll($data)
    {
        try {
            if ($data['kodereg'] == 'RJ') {
                $query = "SELECT a.NoRegistrasi,'' NoReff,replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') as TglKunjungan, a.NoMR, PatientName,
                a.ValueDiscount,c.id as IdUnit,NamaUnit,d.NAMA_Dokter_BPJS as NamaDokter,replace(CONVERT(VARCHAR(11), b.Date_of_birth, 111), '/','-') as DateOfBirth,
                f.NamaPerusahaan as NamaJaminan,replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') as TglPulang,a.NoSEP,''Gander,''NoRegisRWJ,''Address,
                cob.NamaCOB,'' as NamaUnit_RWJ,0 as BiayaAdm,0 as Discount,0 as materai
                                FROM PerawatanSQL.dbo.Visit a
                                --inner join DashboardData.dbo.DataRWJ b on a.NoRegistrasi=b.NoRegistrasi
                                            inner join MasterDataSQL.dbo.Admision b on a.NoMR=b.NoMR
                                 left join MasterDataSQL.dbo.MstrUnitPerwatan c on a.Unit=c.ID 
                            left join MasterDataSQL.dbo.Doctors d on a.Doctor_1=d.ID 
                            inner join MasterdataSQL.dbo.MstrTypePatient e on a.PatientType=e.ID 
                            inner join MasterDataSQL.dbo.MstrPerusahaanAsuransi f on a.Asuransi=f.ID
                            inner join RawatInapSQL.dbo.[Visit Status] ss on a.[Status ID]=ss.[Status ID]
                            left join MasterdataSQL.dbo.MasterCOB cob on a.KodeJaminanCOB=cob.ID
                                WHERE a.NoRegistrasi=:id
                union all SELECT a.NoRegistrasi,'' NoReff,replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') as TglKunjungan, a.NoMR, PatientName,
                a.ValueDiscount,c.id,NamaUnit,d.NAMA_Dokter_BPJS,replace(CONVERT(VARCHAR(11), b.Date_of_birth, 111), '/','-') as DateOfBirth,
                f.NamaPerusahaan,replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') as TglPulang,a.NoSEP,''Gander,''NoRegisRWJ,''Address,
                cob.NamaCOB,'' as NamaUnit_RWJ,0 as BiayaAdm,0 as Discount,0 as materai
                                FROM PerawatanSQL.dbo.Visit a
                                --inner join DashboardData.dbo.DataRWJ b on a.NoRegistrasi=b.NoRegistrasi
                                            inner join MasterDataSQL.dbo.Admision b on a.NoMR=b.NoMR
                                 left join MasterDataSQL.dbo.MstrUnitPerwatan c on a.Unit=c.ID 
                            left join MasterDataSQL.dbo.Doctors d on a.Doctor_1=d.ID 
                            inner join MasterdataSQL.dbo.MstrTypePatient e on a.PatientType=e.ID 
                            inner join MasterDataSQL.dbo.MstrPerusahaanJPK f on a.Perusahaan=f.ID
                            inner join RawatInapSQL.dbo.[Visit Status] ss on a.[Status ID]=ss.[Status ID]
                            left join MasterdataSQL.dbo.MasterCOB cob on a.KodeJaminanCOB=cob.ID
                                WHERE a.NoRegistrasi=:id2";
            } elseif ($data['kodereg'] == 'RI') {
                $query = "SELECT a.NoRegRI as NoRegistrasi,'' as NoReff,replace(CONVERT(VARCHAR(11), a.[StartDate], 111), '/','-') as TglKunjungan, 
				a.NoMR, b.PatientName, a.Discount as ValueDiscount,d.NamaKelas as  IdUnit,e.RoomName+' / '+e.Bed as NamaUnit,c.First_Name NamaDokter,replace(CONVERT(VARCHAR(11), Date_of_Birth, 111), '/','-') as DateOfBirth
				,case when a.TypePatient='2' then opx.NamaPerusahaan else op.NamaPerusahaan end as NamaJaminan,
				replace(CONVERT(VARCHAR(11), a.[EndDate], 111), '/','-') as TglPulang,a.NoSEP,b.Gander,a.NoRegisRWJ,b.Address,cob.NamaCOB,m.NamaUnit as NamaUnit_RWJ,a.BiayaAdm,a.Discount,a.materai
                FROM RawatInapSQL.dbo.Inpatient a 
                inner join MasterDataSQL.dbo.Admision b on a.NoMR=b.NoMR
				left join MasterdataSQL.dbo.Doctors c on a.drPenerima=c.ID
                left join MasterdataSQL.dbo.MstrPerusahaanJPK op on a.IDJPK=op.ID
				left join MasterdataSQL.dbo.MstrPerusahaanAsuransi opx on a.IDAsuransi=opx.ID
                inner join RawatInapSQL.dbo.tblKelas d on a.KlsID=d.IDKelas
                left join RawatInapSQL.dbo.Inpatient_in_out e on a.RoomID_Akhir=e.ID
                left join MasterdataSQL.dbo.MasterCOB cob on a.KodeJaminanCOB=cob.ID
                left join PerawatanSQL.dbo.Visit v on a.NoRegisRWJ=v.NoRegistrasi
                left join MasterdataSQL.dbo.MstrUnitPerwatan m on v.Unit=m.ID
                WHERE a.NoRegRI=:id
                ";
            } elseif ($data['kodereg'] == 'PB') {
                $query = "SELECT NoRegistrasi,NoResep as NoReff,replace(CONVERT(VARCHAR(11), [Order Date], 111), '/','-') as TglKunjungan,'-' as NoMR,[Ship Name] as PatientName,isnull(ValueDiscount,0) as ValueDiscount,''IdUnit,''NamaUnit,''NamaDokter,'' as DateOfBirth,''NamaJaminan,'' TglPulang,'' as NoSEP,''Gander,''NoRegisRWJ,''Address,'' NamaCOB,'' as NamaUnit_RWJ,0 as BiayaAdm,0 as Discount,0 as materai
                FROM  [Apotik_V1.1SQL].dbo.Orders 
                where NoRegistrasi=:id";
            } else {
                $pasing['NoRegistrasi'] = '';
                $pasing['NoReff'] = '';
                $pasing['NoMR'] = '';
                $pasing['PatientName'] = '';
                $pasing['TglKunjungan'] = '';
                $pasing['ValueDiscount'] = 0;
                $pasing['IdUnit'] = '';
                $pasing['NamaUnit'] = '';
                $pasing['NamaDokter'] = '';
                $pasing['DateOfBirth'] = '';
                $pasing['NamaJaminan'] = '';
                $pasing['TglPulang'] = '';
                $pasing['NoSEP'] = '';
                $pasing['Gander'] = '';
                $pasing['NoRegisRWJ'] = '';
                $pasing['Address'] = '';
                $pasing['NamaCOB'] = '';
                $pasing['NamaUnit_RWJ'] = '';
                $pasing['BiayaAdm'] = '';
                $pasing['Discount'] = '';
                $pasing['materai'] = '';
                return $pasing;
            }
            $this->db->query($query);
            $this->db->bind('id', $data['notrs']);
            $this->db->bind('id2', $data['notrs']);
            $datas =  $this->db->single();

            $pasing['TglKunjungan'] = ($datas['TglKunjungan'] != null) ? date('d/m/Y', strtotime($datas['TglKunjungan'])) : '';
            $pasing['NoRegistrasi'] = $datas['NoRegistrasi'];
            $pasing['NoReff'] = $datas['NoReff'];
            $pasing['NoMR'] = $datas['NoMR'];
            $pasing['PatientName'] = $datas['PatientName'];
            $pasing['ValueDiscount'] = $datas['ValueDiscount'];
            $pasing['IdUnit'] = $datas['IdUnit'];
            $pasing['NamaUnit'] = $datas['NamaUnit'];
            $pasing['NamaDokter'] = $datas['NamaDokter'];
            //$pasing['DateOfBirth'] = date('d/m/Y', strtotime($datas['DateOfBirth']));
            $pasing['DateOfBirth'] = ($datas['DateOfBirth'] != null) ? date('d/m/Y', strtotime($datas['DateOfBirth'])) : '';
            $pasing['NamaJaminan'] = $datas['NamaJaminan'];
            $pasing['TglPulang'] = ($datas['TglPulang'] != null) ? date('d/m/Y', strtotime($datas['TglPulang'])) : '';
            $pasing['NoSEP'] = $datas['NoSEP'];
            $pasing['Gander'] = $datas['Gander'];
            $pasing['NoRegisRWJ'] = $datas['NoRegisRWJ'];
            $pasing['Address'] = $datas['Address'];
            $pasing['NamaCOB'] = $datas['NamaCOB'];
            $pasing['NamaUnit_RWJ'] = $datas['NamaUnit_RWJ'];
            $pasing['BiayaAdm'] = $datas['BiayaAdm'];
            $pasing['Discount'] = $datas['Discount'];
            $pasing['materai'] = $datas['materai'];

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintRincianpaybyReg($data)
    {

        try {
            $query = "SELECT NAMA_TARIF AS Keterangan,GROUP_TARIF as jenis_tarif, a.GRANDTOTAL AS BILL,KEKURANGAN AS Kekurangan, KLAIM AS ASURANSI, NO_KWITANSI AS NoBayar,replace(CONVERT(VARCHAR(11), a.TGL_BILLING, 111), '/','-') as TglOrder
            from Billing_Pasien.dbo.FO_T_BILLING_1 a
            inner join Billing_Pasien.dbo.FO_T_BILLING b on a.NO_TRS_BILLING= b.NO_TRS_BILLING
            left join Billing_Pasien.dbo.FO_T_KASIR c on a.ID_TRS_Payment = c.NO_TRS
            WHERE a.NO_REGISTRASI=:id and replace(CONVERT(VARCHAR(11), a.TGL_BILLING, 111), '/','-') Between :periode_awal AND :periode_akhir AND a.batal='0'";

            $this->db->query($query);
            $this->db->bind('id', $data['notrs']);
            $this->db->bind('periode_awal', $data['periode_awal']);
            $this->db->bind('periode_akhir', $data['periode_akhir']);
            $datas =  $this->db->resultSet();

            $rows = array();
            $no = 1;
            foreach ($datas as $key) {
                // $diskon_value = $key['TarifSatuan'] * $key['Discount'];
                $pasing['No'] = $no++;
                $pasing['Keterangan'] = $key['Keterangan'];
                $pasing['jenis_tarif'] = $key['jenis_tarif'];
                $pasing['BILL'] = $key['BILL'];
                $pasing['Kekurangan'] = $key['Kekurangan'];
                $pasing['ASURANSI'] = $key['ASURANSI'];
                $pasing['NoBayar'] = $key['NoBayar'];
                $pasing['TglOrder'] = ($key['TglOrder'] != null) ? date('d/m/Y', strtotime($key['TglOrder'])) : '';
                // $diskon = $key['Discount'] * 100;
                // $pasing['diskon_persen'] = ($diskon != 0) ? number_format($diskon, 0, ',', '.') . '%' : '';
                $rows[] = $pasing;
            }

            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintRincianpaybyRegidtrs($data)
    {

        try {
            $query = "SELECT NAMA_TARIF AS Keterangan,GROUP_TARIF as jenis_tarif, a.GRANDTOTAL AS BILL,
            KEKURANGAN AS Kekurangan, KLAIM, NO_KWITANSI AS NoBayar,
            replace(CONVERT(VARCHAR(11), a.TGL_BILLING, 111), '/','-') as TglOrder,a.QTY,a.NILAI_TARIF,a.DISC_RP,a.NILAI_TARIF,
            a.NM_DR
            from Billing_Pasien.dbo.FO_T_BILLING_1 a
            inner join Billing_Pasien.dbo.FO_T_BILLING b on a.NO_TRS_BILLING= b.NO_TRS_BILLING
            left join Billing_Pasien.dbo.FO_T_KASIR c on a.ID_TRS_Payment = c.NO_TRS
            WHERE a.NO_REGISTRASI=:noreg AND a.batal='0' AND a.ID_TRS_Payment = :idtrspayment";

            $this->db->query($query);
            $this->db->bind('noreg', $data['notrs']);
            $this->db->bind('idtrspayment', $data['lang']);
            $datas =  $this->db->resultSet();

            $rows = array();
            $no = 1;
            foreach ($datas as $key) {
                // $diskon_value = $key['TarifSatuan'] * $key['Discount'];
                $pasing['No'] = $no++;
                $pasing['Keterangan'] = $key['Keterangan'];
                $pasing['NM_DR'] = $key['NM_DR'];
                $pasing['jenis_tarif'] = $key['jenis_tarif'];
                $pasing['BILL'] = $key['BILL'];
                $pasing['Kekurangan'] = $key['Kekurangan'];
                $pasing['ASURANSI'] = $key['KLAIM'];
                $pasing['NoBayar'] = $key['NoBayar'];
                $pasing['TglOrder'] = ($key['TglOrder'] != null) ? date('d/m/Y', strtotime($key['TglOrder'])) : '';
                $pasing['QTY'] = $key['QTY'];
                $pasing['NILAI_TARIF'] = $key['NILAI_TARIF'];
                $pasing['DISC_RP'] = $key['DISC_RP'];
                $pasing['NILAI_TARIF'] = $key['NILAI_TARIF'];
                // $diskon = $key['Discount'] * 100;
                // $pasing['diskon_persen'] = ($diskon != 0) ? number_format($diskon, 0, ',', '.') . '%' : '';
                $rows[] = $pasing;
            }

            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintRincianpaybyRegidtrsALL($data)
    {

        try {
            $query = "SELECT NAMA_TARIF AS Keterangan,GROUP_TARIF as jenis_tarif, a.GRANDTOTAL AS BILL,KEKURANGAN AS Kekurangan, KLAIM, NO_KWITANSI AS NoBayar,replace(CONVERT(VARCHAR(11), a.TGL_BILLING, 111), '/','-') as TglOrder
            from Billing_Pasien.dbo.FO_T_BILLING_1 a
            inner join Billing_Pasien.dbo.FO_T_BILLING b on a.NO_TRS_BILLING= b.NO_TRS_BILLING
            left join Billing_Pasien.dbo.FO_T_KASIR c on a.ID_TRS_Payment = c.NO_TRS
            WHERE a.NO_REGISTRASI=:noreg1 AND a.batal='0' AND a.ID_TRS_Payment IS NOT NULL AND c.NO_REGISTRASI = :noreg4
UNION ALL
SELECT (NAMA_TARIF + ' (Hutang)') AS Keterangan,GROUP_TARIF as jenis_tarif, a.GRANDTOTAL AS BILL,KEKURANGAN AS Kekurangan, KLAIM, NO_KWITANSI AS NoBayar,replace(CONVERT(VARCHAR(11), a.TGL_BILLING, 111), '/','-') as TglOrder
            from Billing_Pasien.dbo.FO_T_BILLING_1 a
            inner join Billing_Pasien.dbo.FO_T_BILLING b on a.NO_TRS_BILLING= b.NO_TRS_BILLING
            inner join Billing_Pasien.dbo.FO_T_KASIR c on a.ID_TRS_Payment = c.NO_TRS
			inner join Billing_Pasien.dbo.CLOSING_BILL d ON d.NOREG_FIRST = a.NO_REGISTRASI
            WHERE d.NOREG_REFF=:noreg2 AND a.BATAL='0' AND c.NO_REGISTRASI = :noreg3";

            $this->db->query($query);
            $this->db->bind('noreg1', $data['notrs']);
            $this->db->bind('noreg2', $data['notrs']);
            $this->db->bind('noreg3', $data['notrs']);
            $this->db->bind('noreg4', $data['notrs']);
            // $this->db->bind('idtrspayment', $data['lang']);
            $datas =  $this->db->resultSet();

            $rows = array();
            $no = 1;
            foreach ($datas as $key) {
                // $diskon_value = $key['TarifSatuan'] * $key['Discount'];
                $pasing['No'] = $no++;
                $pasing['Keterangan'] = $key['Keterangan'];
                $pasing['jenis_tarif'] = $key['jenis_tarif'];
                $pasing['BILL'] = $key['BILL'];
                $pasing['Kekurangan'] = $key['Kekurangan'];
                $pasing['ASURANSI'] = $key['KLAIM'];
                $pasing['NoBayar'] = $key['NoBayar'];
                $pasing['TglOrder'] = ($key['TglOrder'] != null) ? date('d/m/Y', strtotime($key['TglOrder'])) : '';
                // $diskon = $key['Discount'] * 100;
                // $pasing['diskon_persen'] = ($diskon != 0) ? number_format($diskon, 0, ',', '.') . '%' : '';
                $rows[] = $pasing;
            }

            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintRincianKlinikbyReg($data)
    {
        try {

            $query = "SELECT NamaDokter,Tarif,Discount,Quantity as Qty,TotalTarif,KategoriTarif,NamaProduct,
                CASE WHEN KategoriTarif = 'Administrasi' THEN 1
                WHEN KategoriTarif = 'Konsultasi' THEN 2
                WHEN KategoriTarif = 'Tindakan' THEN 3
                ELSE 4  
                END AS urut
                ,CASE WHEN KategoriTarif = 'Konsultasi' then NamaProduct+' : '+NamaDokter
                ELSE NamaProduct
                END AS NamaProduct_ext,Tarif*Discount as Diskon_Value,replace(CONVERT(VARCHAR(11), Tanggal, 111), '/','-') as TglOrder
                  FROM PerawatanSQL.dbo.[Visit Details] a left join PerawatanSQL.dbo.Tarif_RJ_UGD b on a.ProductID = b.ID
                      WHERE a.KategoriTarif <> 'Bahan Habis Pakai' AND NoRegistrasi=:id
                      UNION ALL 
                      SELECT null as NamaDokter,Harga as Tarif,0 Discount,QtyOrder as Qty,case when StatusOrder='1' then Total else 0 end as TotalTarif,'BankDarah' as KategoriTarif,NamaTarifDarah as NamaProduct, 5 as urut,NamaTarifDarah as NamaProduct_ext,0 as Diskon_Value,replace(CONVERT(VARCHAR(11), DateOrder, 111), '/','-') as TglOrder
                                   from LaboratoriumSQL.dbo.OrderBloodDetails a
                                   inner join LaboratoriumSQL.dbo.OrderBloods b on a.IDHdr=b.ID
                                   where NoRegistrasi=:id2  and a.Batal='0' and b.Batal='0' and StatusOrder='1'
                      order by urut";
            // else{
            //     $query = "SELECT NamaDokter,Tarif,Discount,Quantity as Qty,TotalTarif,KategoriTarif,NamaProduct,
            //     CASE WHEN KategoriTarif = 'Administrasi' THEN 1
            //     WHEN KategoriTarif = 'Konsultasi' THEN 2
            //     WHEN KategoriTarif = 'Tindakan' THEN 3
            //     ELSE 4  
            //     END AS urut
            //     ,CASE WHEN KategoriTarif = 'Konsultasi' then NamaProduct+' : '+NamaDokter
            //     ELSE NamaProduct
            //     END AS NamaProduct_ext,Tarif*Discount as Diskon_Value
            //       FROM PerawatanSQL.dbo.[Visit Details] a left join PerawatanSQL.dbo.Tarif_RJ_UGD b on a.ProductID = b.ID
            //           WHERE a.KategoriTarif <> 'Bahan Habis Pakai' AND NoRegistrasi=:id
            //           UNION ALL 
            //           SELECT null as NamaDokter,Harga as Tarif,0 Discount,QtyOrder as Qty,case when StatusOrder='1' then Total else 0 end as TotalTarif,'BankDarah' as KategoriTarif,NamaTarifDarah as NamaProduct, 5 as urut,NamaTarifDarah as NamaProduct_ext,0 as Diskon_Value
            //                        from LaboratoriumSQL.dbo.OrderBloodDetails a
            //                        inner join LaboratoriumSQL.dbo.OrderBloods b on a.IDHdr=b.ID
            //                        where NoRegistrasi=:id2  and a.Batal='0' and b.Batal='0' and StatusOrder='1'
            //           order by urut";
            // }

            $this->db->query($query);
            $this->db->bind('id', $data['notrs']);
            $this->db->bind('id2', $data['notrs']);
            $datas =  $this->db->resultSet();

            $rows = array();
            $no = 1;
            foreach ($datas as $key) {
                $pasing['No'] = $no++;
                $pasing['NamaDokter'] = $key['NamaDokter'];
                $pasing['Tarif'] = $key['Tarif'];
                $pasing['Discount'] = $key['Discount'];
                $pasing['Qty'] = $key['Qty'];
                $pasing['TotalTarif'] = $key['TotalTarif'];
                $pasing['KategoriTarif'] = $key['KategoriTarif'];
                $pasing['NamaProduct'] = $key['NamaProduct'];
                $pasing['urut'] = $key['urut'];
                $pasing['NamaProduct_ext'] = $key['NamaProduct_ext'];
                $pasing['Diskon_Value'] = $key['Diskon_Value'];
                $pasing['TglOrder'] = ($key['TglOrder'] != null) ? date('d/m/Y', strtotime($key['TglOrder'])) : '';
                $diskon = $key['Discount'] * 100;
                $pasing['diskon_persen'] = ($diskon != 0) ? number_format($diskon, 0, ',', '.') . '%' : '';
                $rows[] = $pasing;
            }

            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintRincianOperasibyReg($data)
    {
        try {
            $query = "SELECT DateEntry,NamaDokter,GroupName,NamaJasa,TarifSatuan,Discount,Tarif,replace(CONVERT(VARCHAR(11), DateEntry, 111), '/','-') as TglOrder
                 FROM RawatInapSQL.dbo.View_TindakanOperasi WHERE NoRegistrasi=:id and replace(CONVERT(VARCHAR(11), DateEntry, 111), '/','-') Between :periode_awal AND :periode_akhir";

            $this->db->query($query);
            $this->db->bind('id', $data['notrs']);
            $this->db->bind('periode_awal', $data['periode_awal']);
            $this->db->bind('periode_akhir', $data['periode_akhir']);
            $datas =  $this->db->resultSet();

            $rows = array();
            $no = 1;
            foreach ($datas as $key) {
                $diskon_value = $key['TarifSatuan'] * $key['Discount'];
                $pasing['No'] = $no++;
                $pasing['DateEntry'] = $key['DateEntry'];
                $pasing['NamaDokter'] = $key['NamaDokter'];
                $pasing['NamaJasa'] = $key['NamaJasa'];
                $pasing['TarifSatuan'] = $key['TarifSatuan'];
                $pasing['Discount'] = $key['Discount'];
                $pasing['Tarif'] = $key['Tarif'];
                $pasing['namatindakanop'] = $key['GroupName'] . ' ' . $key['NamaJasa'] . ' | ' . $key['NamaDokter'];
                $pasing['Diskon_Value'] = $diskon_value;
                $pasing['TglOrder'] = ($key['TglOrder'] != null) ? date('d/m/Y', strtotime($key['TglOrder'])) : '';
                $diskon = $key['Discount'] * 100;
                $pasing['diskon_persen'] = ($diskon != 0) ? number_format($diskon, 0, ',', '.') . '%' : '';
                $rows[] = $pasing;
            }

            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintRincianLabbyReg($data)
    {
        try {

            $query = "SELECT NamaTes,TarifKelas,isnull(disc,0) as disc,Tarif,replace(CONVERT(VARCHAR(11), LabDate, 111), '/','-') as TglOrder
                FROM LaboratoriumSQL.dbo.[View_Labdetails] WHERE Batal=0 AND NoRegRI=:id and replace(CONVERT(VARCHAR(11), LabDate, 111), '/','-') Between :periode_awal AND :periode_akhir --and StatusID>='3'";

            $this->db->query($query);
            $this->db->bind('id', $data['notrs']);
            $this->db->bind('periode_awal', $data['periode_awal']);
            $this->db->bind('periode_akhir', $data['periode_akhir']);
            $datas =  $this->db->resultSet();

            $rows = array();
            $no = 1;
            foreach ($datas as $key) {
                $diskon_value = $key['TarifKelas'] * $key['disc'];
                $pasing['No'] = $no++;
                $pasing['NamaTes'] = $key['NamaTes'];
                $pasing['TarifKelas'] = $key['TarifKelas'];
                $pasing['disc'] = $key['disc'];
                $pasing['Tarif'] = $key['Tarif'];
                $pasing['Diskon_Value'] = $diskon_value;
                $pasing['TglOrder'] = ($key['TglOrder'] != null) ? date('d/m/Y', strtotime($key['TglOrder'])) : '';
                $diskon = $key['disc'] * 100;
                $pasing['diskon_persen'] = ($diskon != 0) ? number_format($diskon, 0, ',', '.') . '%' : '';
                $rows[] = $pasing;
            }

            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    public function PrintRincianRadiologibyReg($data)
    {
        try {

            $query = "SELECT REQUESTED_PROC_DESC,Tarif,DiscountRp,Service_Charge,replace(CONVERT(VARCHAR(11), ORDER_DATE, 111), '/','-') AS TglOrder,Discount
                 FROM RadiologiSQL.dbo.WO_RADIOLOGY WHERE Batal=0 AND NOREGISTRASI=:id and replace(CONVERT(VARCHAR(11), ORDER_DATE, 111), '/','-') Between :periode_awal AND :periode_akhir -- and PaymentStatus>='3'";

            $this->db->query($query);
            $this->db->bind('id', $data['notrs']);
            $this->db->bind('periode_awal', $data['periode_awal']);
            $this->db->bind('periode_akhir', $data['periode_akhir']);
            $datas =  $this->db->resultSet();

            $rows = array();
            $no = 1;
            foreach ($datas as $key) {
                $pasing['No'] = $no++;
                $pasing['REQUESTED_PROC_DESC'] = $key['REQUESTED_PROC_DESC'];
                $pasing['Tarif'] = $key['Tarif'];
                $pasing['DiscountRp'] = $key['DiscountRp'];
                $pasing['Service_Charge'] = $key['Service_Charge'];
                $pasing['TglOrder'] = ($key['TglOrder'] != null) ? date('d/m/Y', strtotime($key['TglOrder'])) : '';
                $diskon = $key['Discount'] * 100;
                $pasing['diskon_persen'] = ($diskon != 0) ? number_format($diskon, 0, ',', '.') . '%' : '';
                $rows[] = $pasing;
            }

            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintRincianMCUbyReg($data)
    {
        try {

            $query = "SELECT Pemeriksaan,NamaDokter FROM MedicalRecord.dbo.MR_PemeriksaanMCU WHERE NoRegistrasi=:id AND LokasiPemeriksaan='UNIT MCU' order by Pemeriksaan";

            $this->db->query($query);
            $this->db->bind('id', $data['notrs']);
            $datas =  $this->db->resultSet();

            $rows = array();
            $no = 1;
            foreach ($datas as $key) {
                $pasing['No'] = $no++;
                $pasing['Pemeriksaan'] = $key['Pemeriksaan'];
                $pasing['NamaDokter'] = $key['NamaDokter'];
                $pasing['NamaPemeriksaan'] = $key['Pemeriksaan'] . ' ' . $key['NamaDokter'];
                $rows[] = $pasing;
            }

            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintRincianBhpbyReg($data)
    {
        try {

            $query = "SELECT a.[Status ID] as status,QtyRealisasi as Qty,[Unit Price] as Harga,NamaObat as NamaProduk,b.Discount,replace(CONVERT(VARCHAR(11), tglResep, 111), '/','-') as TglOrder
                FROM [Apotik_V1.1SQL].dbo.Orders a 
                inner join [Apotik_V1.1SQL].dbo.[Order Details] b on a.[Order ID] = b.[Order ID]
                WHERE b.[Product ID] is not null AND b.QtyRealisasi <>0 AND a.NoRegistrasi=:id AND a.JenisResep='BHP' AND OrderBatal=0 and replace(CONVERT(VARCHAR(11), tglResep, 111), '/','-') Between :periode_awal AND :periode_akhir";

            $this->db->query($query);
            $this->db->bind('id', $data['notrs']);
            $this->db->bind('periode_awal', $data['periode_awal']);
            $this->db->bind('periode_akhir', $data['periode_akhir']);
            $datas =  $this->db->resultSet();

            $rows = array();
            $no = 1;
            $tarifobat = 0;
            $diskon_value_obat = 0;
            $tarifobat_fix = 0;
            //$pasing['totaltarif_obat'] = 0;
            foreach ($datas as $key) {
                $pasing['No'] = $no++;
                $pasing['status'] = $key['status'];
                $tarifobat = $key['Harga'] * $key['Qty'];
                $diskon_value_obat = $tarifobat * $key['Discount'];
                $tarifobat_fix = round($tarifobat - $diskon_value_obat);
                $pasing['TotalTarif'] = $tarifobat_fix;
                $pasing['Qty'] = $key['Qty'];
                $pasing['Harga'] = $key['Harga'];
                $pasing['NamaProduk'] = $key['NamaProduk'];
                $pasing['Discount'] = $key['Discount'];
                $pasing['TglOrder'] = ($key['TglOrder'] != null) ? date('d/m/Y', strtotime($key['TglOrder'])) : '';
                $diskon = $key['Discount'] * 100;
                $pasing['diskon_persen'] = ($diskon != 0) ? number_format($diskon, 0, ',', '.') . '%' : '';
                $rows[] = $pasing;
            }

            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintRincianObatbyReg($data)
    {
        try {

            $query = "SELECT a.[Status ID] as status,QtyRealisasi as Qty,[Unit Price] as Harga,NamaObat as NamaProduk,b.Discount,replace(CONVERT(VARCHAR(11), tglResep, 111), '/','-') as TglOrder
                FROM [Apotik_V1.1SQL].dbo.Orders a 
                inner join [Apotik_V1.1SQL].dbo.[Order Details] b on a.[Order ID] = b.[Order ID]
                WHERE b.[Product ID] is not null AND b.QtyRealisasi <>0 AND a.NoRegistrasi=:id AND a.JenisResep not in ('BHP','RETUR') AND OrderBatal=0 and replace(CONVERT(VARCHAR(11), tglResep, 111), '/','-') Between :periode_awal AND :periode_akhir";

            $this->db->query($query);
            $this->db->bind('id', $data['notrs']);
            $this->db->bind('periode_awal', $data['periode_awal']);
            $this->db->bind('periode_akhir', $data['periode_akhir']);
            $datas =  $this->db->resultSet();

            $rows = array();
            $no = 1;
            $tarifobat = 0;
            $diskon_value_obat = 0;
            $tarifobat_fix = 0;
            //$pasing['totaltarif_obat'] = 0;
            foreach ($datas as $key) {
                $pasing['No'] = $no++;
                $pasing['status'] = $key['status'];
                $tarifobat = $key['Harga'] * $key['Qty'];
                $diskon_value_obat = $tarifobat * $key['Discount'];
                $tarifobat_fix = round($tarifobat - $diskon_value_obat);
                $pasing['TotalTarif'] = $tarifobat_fix;
                $pasing['Qty'] = $key['Qty'];
                $pasing['Harga'] = $key['Harga'];
                $pasing['NamaProduk'] = $key['NamaProduk'];
                $pasing['Discount'] = $key['Discount'];
                $pasing['TglOrder'] = ($key['TglOrder'] != null) ? date('d/m/Y', strtotime($key['TglOrder'])) : '';
                $diskon = $key['Discount'] * 100;
                $pasing['diskon_persen'] = ($diskon != 0) ? number_format($diskon, 0, ',', '.') . '%' : '';
                $rows[] = $pasing;
            }

            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintRincianReturbyReg($data)
    {
        try {

            $query = "SELECT a.[Status ID] as status,QtyRealisasi as Qty,[Unit Price] as Harga,NamaObat as NamaProduk,b.Discount,replace(CONVERT(VARCHAR(11), tglResep, 111), '/','-') as TglOrder
                FROM [Apotik_V1.1SQL].dbo.Orders a 
                inner join [Apotik_V1.1SQL].dbo.[Order Details] b on a.[Order ID] = b.[Order ID]
                WHERE b.[Product ID] is not null AND b.QtyRealisasi <>0 AND a.NoRegistrasi=:id AND a.JenisResep = 'RETUR' AND OrderBatal=0 and replace(CONVERT(VARCHAR(11), tglResep, 111), '/','-') Between :periode_awal AND :periode_akhir";

            $this->db->query($query);
            $this->db->bind('id', $data['notrs']);
            $this->db->bind('periode_awal', $data['periode_awal']);
            $this->db->bind('periode_akhir', $data['periode_akhir']);
            $datas =  $this->db->resultSet();

            $rows = array();
            $no = 1;
            $tarifobat = 0;
            $diskon_value_obat = 0;
            $tarifobat_fix = 0;
            //$pasing['totaltarif_obat'] = 0;
            foreach ($datas as $key) {
                $pasing['No'] = $no++;
                $pasing['status'] = $key['status'];
                $tarifobat = $key['Harga'] * $key['Qty'];
                $diskon_value_obat = $tarifobat * $key['Discount'];
                $tarifobat_fix = round($tarifobat - $diskon_value_obat);
                $pasing['TotalTarif'] = $tarifobat_fix;
                $pasing['Qty'] = $key['Qty'];
                $pasing['Harga'] = $key['Harga'];
                $pasing['NamaProduk'] = $key['NamaProduk'];
                $pasing['Discount'] = $key['Discount'];
                $pasing['TglOrder'] = ($key['TglOrder'] != null) ? date('d/m/Y', strtotime($key['TglOrder'])) : '';
                $diskon = $key['Discount'] * 100;
                $pasing['diskon_persen'] = ($diskon != 0) ? number_format($diskon, 0, ',', '.') . '%' : '';
                $rows[] = $pasing;
            }

            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintRincianPaketOPbyReg($data)
    {
        try {
            $query = "SELECT nama_paket,replace(CONVERT(VARCHAR(11), Tgl_Input, 111), '/','-') as TglOrder,qty,harga
                FROM RawatInapSQL.dbo.Inpatient_Paket_Operasi 
                    WHERE  NoRegistrasi=:id AND  replace(CONVERT(VARCHAR(11), Tgl_Input, 111), '/','-') Between :periode_awal AND :periode_akhir order by Tgl_Input asc";

            $this->db->query($query);
            $this->db->bind('id', $data['notrs']);
            $this->db->bind('periode_awal', $data['periode_awal']);
            $this->db->bind('periode_akhir', $data['periode_akhir']);
            $datas =  $this->db->resultSet();

            $rows = array();
            $no = 1;
            foreach ($datas as $key) {
                $pasing['No'] = $no++;
                $pasing['nama_paket'] = $key['nama_paket'];
                $pasing['qty'] = $key['qty'];
                $pasing['harga'] = $key['harga'];
                $pasing['TglOrder'] = ($key['TglOrder'] != null) ? date('d/m/Y', strtotime($key['TglOrder'])) : '';
                $rows[] = $pasing;
            }

            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintRincianKamarbyReg($data)
    {
        try {
            $periode_awal = $data['periode_awal'];
            $periode_akhir = $data['periode_akhir'];
            $query = "SELECT *, CONVERT(VARCHAR(8),TimeEnd,108) as timeend,
                Lamarawat as LamaRawatx
              FROM RawatInapSQL.dbo.View_PemakaianKamarRanap 
                  WHERE  NoRegRI=:id and ((StartDate BETWEEN :periode_awal AND :periode_akhir) OR 
        (EndDate BETWEEN :periode_awal2 AND :periode_akhir2) OR 
        (StartDate <= :periode_awal3 AND EndDate >= :periode_akhir3))";

            $this->db->query($query);
            $this->db->bind('id', $data['notrs']);
            $this->db->bind('periode_awal', $data['periode_awal']);
            $this->db->bind('periode_akhir', $data['periode_akhir']);
            $this->db->bind('periode_awal2', $data['periode_awal']);
            $this->db->bind('periode_akhir2', $data['periode_akhir']);
            $this->db->bind('periode_awal3', $data['periode_awal']);
            $this->db->bind('periode_akhir3', $data['periode_akhir']);
            $datas =  $this->db->resultSet();

            $rows = array();
            $no = 1;
            foreach ($datas as $row) {
                $pasing['No'] = $no++;

                $tglmasuk = date('d-M-y', strtotime($row['StartDate']));
                if (strtotime($row['StartDate']) < strtotime($periode_awal)) {
                    $tglmasuk = date('d-M-y', strtotime($periode_awal));
                }

                if ($row['timeend'] == null) {
                    $timeend = Date('H:i:s');
                } else {
                    $timeend = date('H:i:s', strtotime($row['timeend']));
                }


                if ($row['EndDate'] == null) {
                    $tglkeluar = Date('d-M-y');
                } else {
                    $tglkeluar = date('d-M-y', strtotime($row['EndDate']));
                }

                if (strtotime($tglkeluar) < strtotime($periode_akhir)) {
                    $tgl_keluar = date('d-M-y', strtotime($row['EndDate']));
                } else {
                    $tgl_keluar = date('d-M-y', strtotime($periode_akhir));
                }
                $jam_keluar = $timeend;
                $tgl_masuk = date('d-M-y', strtotime($tglmasuk));


                $jam_keluarx = strtotime($jam_keluar);
                $jam_masukx = strtotime($tgl_masuk);

                $time_diff = ($jam_masukx - $jam_keluarx) / 60;
                $jam12 = strtotime(Date('12:00:00'));


                if (strtotime($periode_awal) > strtotime($row['StartDate'])) {
                    if (strtotime($periode_awal) == strtotime($row['EndDate'])) {
                        $terhitung = 0;
                    } else {
                        if ($jam_keluarx > $jam12) {
                            $terhitung = 1;
                        } else {
                            $terhitung = 0;
                        }
                    }
                } else {
                    $terhitung = 0;
                }

                if (strtotime($periode_akhir) < strtotime($row['EndDate'])) {
                    if ($terhitung == 1) {
                        $plus1 = $terhitung;
                    } else {
                        $plus1 = 1;
                    }
                } else {
                    if ($jam_keluarx > $jam12) {
                        if ($terhitung == 1) {
                            $plus1 = 0 + $terhitung;
                        } else {
                            $plus1 = 1 + $terhitung;
                        }
                    } else {
                        $plus1 = 0 + $terhitung;
                    }
                }
                $datediff = strtotime($tgl_keluar) - strtotime($tgl_masuk);

                $lamarawat = round($datediff / (60 * 60 * 24)) + $plus1;

                $biayakamar = $lamarawat * $row["Tarif"] * (1 - $row['Disc']);
                $namakamar = $row['RoomName'] . ' ' . $row['Bed'] . ' | ' . $tglmasuk . ' sd ' . $tgl_keluar;
                $diskon = $row['Disc'] * 100;

                $pasing['namakamar'] = $namakamar;
                $pasing['biayakamar'] = $biayakamar;
                $pasing['diskon'] = ($diskon != 0) ? number_format($diskon, 0, ',', '.') . '%' : '';
                $pasing['lamarawat'] = $lamarawat;
                $pasing['Tarif'] = $row['Tarif'];
                //$pasing['TglOrder'] = ($row['TglOrder'] != null) ? date('d/m/Y', strtotime($row['TglOrder'])) : '';
                $rows[] = $pasing;
            }

            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintRincianVisitbyReg($data)
    {
        try {
            $query = "SELECT countid,[Product Name],VisitDate,Quantity,Discount,[Unit Price],[Extended Price],NamaDokter,NamaKelas,Category
                FROM RawatInapSQL.dbo.View_BiayaPerawatan A
                join RawatInapSQL.dbo.TblKelas b on a.Kelas=b.IDKelas
              outer Apply(Select count(Category) as countid from RawatInapSQL.dbo.View_BiayaPerawatan where NoRegRI=a.NoRegRI and Category=a.Category and  replace(CONVERT(VARCHAR(11), VisitDate, 111), '/','-') Between :periode_awal AND :periode_akhir and [Product ID] is not null group by Category)x
                    WHERE  NoRegRI=:id AND replace(CONVERT(VARCHAR(11), VisitDate, 111), '/','-') Between :periode_awal2 AND :periode_akhir2 and [Product ID] is not null
                     group by Category,[Product Name],VisitDate,Quantity,Discount,[Unit Price],[Extended Price],NamaDokter,NamaKelas,countid
                     UNION ALL
                        SELECT countid,NamaTarifDarah as [Product Name],DateOrder as VisitDate,QtyOrder Quantity,0 Discount,Harga [Unit Price],case when StatusOrder='1' then Total else 0 end as [Extended Price],null NamaDokter,null NamaKelas,'Bank Darah' Category
     from LaboratoriumSQL.dbo.OrderBloodDetails a
     inner join LaboratoriumSQL.dbo.OrderBloods b on a.IDHdr=b.ID
outer Apply(Select count(t.ID) as countid from LaboratoriumSQL.dbo.OrderBloodDetails t
inner join LaboratoriumSQL.dbo.OrderBloods y on t.IDHdr=y.ID
where y.NoRegistrasi=b.NoRegistrasi and replace(CONVERT(VARCHAR(11), y.DateOrder, 111), '/','-') Between :periode_awal3 AND :periode_akhir3 and t.Batal='0' and y.Batal='0')x
     where NoRegistrasi=:id2  and a.Batal='0' and b.Batal='0' and StatusOrder='1'
and replace(CONVERT(VARCHAR(11), DateOrder, 111), '/','-') Between :periode_awal4 AND :periode_akhir4
          order by Category,VisitDate asc";

            $this->db->query($query);
            $this->db->bind('id', $data['notrs']);
            $this->db->bind('id2', $data['notrs']);
            $this->db->bind('periode_awal', $data['periode_awal']);
            $this->db->bind('periode_akhir', $data['periode_akhir']);
            $this->db->bind('periode_awal2', $data['periode_awal']);
            $this->db->bind('periode_akhir2', $data['periode_akhir']);
            $this->db->bind('periode_awal3', $data['periode_awal']);
            $this->db->bind('periode_akhir3', $data['periode_akhir']);
            $this->db->bind('periode_awal4', $data['periode_awal']);
            $this->db->bind('periode_akhir4', $data['periode_akhir']);
            $datas =  $this->db->resultSet();

            $rows = array();
            $no = 1;
            foreach ($datas as $key) {
                $pasing['No'] = $no++;
                if (!empty($key['NamaDokter'])) {
                    $namadokter_tind = ' | ' . $key['NamaDokter'];
                } else {
                    $namadokter_tind = null;
                }

                if (!empty($key['NamaKelas'])) {
                    $namakelas_tind = ' | ' . $key['NamaKelas'];
                } else {
                    $namakelas_tind = null;
                }
                $description = $key['Product Name'] . $namadokter_tind . $namakelas_tind;
                $discount = $key['Discount'] * 100;
                $pasing['category'] = $key['Category'];
                $pasing['Quantity'] = $key['Quantity'];
                $pasing['Harga'] = $key['Unit Price'];
                $pasing['Tarif'] = $key['Extended Price'];
                $pasing['countid'] = $key['countid'];
                $pasing['description'] = $description;
                $pasing['diskon_persen'] = ($discount != 0) ? number_format($discount, 0, ',', '.') . '%' : '';
                $pasing['VisitDate'] = ($key['VisitDate'] != null) ? date('d/m/Y', strtotime($key['VisitDate'])) : '';
                $rows[] = $pasing;
            }

            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintRincianFarmasibyReg($data)
    {
        try {

            $query = "SELECT a.[Status ID] as status,QtyRealisasi as Qty,[Unit Price] as Harga,NamaObat as NamaProduk,b.Discount,replace(CONVERT(VARCHAR(11), tglResep, 111), '/','-') as TglOrder
                FROM [Apotik_V1.1SQL].dbo.Orders a 
                inner join [Apotik_V1.1SQL].dbo.[Order Details] b on a.[Order ID] = b.[Order ID]
                WHERE b.[Product ID] is not null AND b.QtyRealisasi <>0 AND a.NoRegistrasi=:id AND OrderBatal=0 and replace(CONVERT(VARCHAR(11), tglResep, 111), '/','-') Between :periode_awal AND :periode_akhir";

            $this->db->query($query);
            $this->db->bind('id', $data['notrs']);
            $this->db->bind('periode_awal', $data['periode_awal']);
            $this->db->bind('periode_akhir', $data['periode_akhir']);
            $datas =  $this->db->resultSet();

            $rows = array();
            $no = 1;
            $tarifobat = 0;
            $diskon_value_obat = 0;
            $tarifobat_fix = 0;
            //$pasing['totaltarif_obat'] = 0;
            foreach ($datas as $key) {
                $pasing['No'] = $no++;
                $pasing['status'] = $key['status'];
                $tarifobat = $key['Harga'] * $key['Qty'];
                $diskon_value_obat = $tarifobat * $key['Discount'];
                $tarifobat_fix = round($tarifobat - $diskon_value_obat);
                $pasing['TotalTarif'] = $tarifobat_fix;
                $pasing['Qty'] = $key['Qty'];
                $pasing['Harga'] = $key['Harga'];
                $pasing['NamaProduk'] = $key['NamaProduk'];
                $pasing['Discount'] = $key['Discount'];
                $pasing['TglOrder'] = ($key['TglOrder'] != null) ? date('d/m/Y', strtotime($key['TglOrder'])) : '';
                $diskon = $key['Discount'] * 100;
                $pasing['diskon_persen'] = ($diskon != 0) ? number_format($diskon, 0, ',', '.') . '%' : '';
                $rows[] = $pasing;
            }

            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function gettarifnew($data)
    {
        try {
            $idunit = $data['idunit'];
            $groupjaminan = $data['groupjaminan'];
            $tglbill = $data['tglbill'];
            $jenispasien = $data['jenispasien'];

            if ($jenispasien == 'RJ') {
                if ($idunit == '1') {
                    // $this->db->query("SELECT  c.ID,c.[Product Name] as namatarif, b.NILAI
                    // FROM PerawatanSQL.DBO.Tarif_RJ_UGD_3 A
                    // INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD_4 B ON A.ID_TR_TARIF = B.ID_TR_TARIF
                    // INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD C ON C.ID = B.ID_TARIF
                    // INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD_2 D ON D.id_tarif = C.ID
                    // WHERE :tglbill between  replace(CONVERT(VARCHAR(11),a.TGL_BERLAKU, 111), '/','-')   and replace(CONVERT(VARCHAR(11),a.TGL_EXPIRED, 111), '/','-')  
                    // and b.KD_INSTALASI=:jenispasien and b.GROUP_TARIF=:groupjaminan
                    // and id_layanan=:idunit and KLSID = '2'
                    // order by 1 desc");

                    $this->db->query("SELECT 
                    A.ID_TR_TARIF,c.ID,c.[Product Name] as namatarif , D.id_layanan, SUM(b.NILAI) AS NILAI
                    FROM PerawatanSQL.DBO.Tarif_RJ_UGD_3 A
                    INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD_4 B ON A.ID_TR_TARIF = B.ID_TR_TARIF
                    INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD C ON C.ID = B.ID_TARIF
                    INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD_2 D ON D.id_tarif = C.ID
                    WHERE  :tglbill  between  replace(CONVERT(VARCHAR(11),a.TGL_BERLAKU, 111), '/','-')   and replace(CONVERT(VARCHAR(11),a.TGL_EXPIRED, 111), '/','-')  
                    and b.KD_INSTALASI=:jenispasien  AND B.GROUP_TARIF=:groupjaminan
                    and id_layanan=:idunit and KLSID = '2'
                    group by  A.ID_TR_TARIF,c.ID,c.[Product Name] ,D.id_layanan
                    order by 2 asc");


                } else {
                    // $this->db->query("SELECT  c.ID,c.[Product Name] as namatarif, b.NILAI
                    // FROM PerawatanSQL.DBO.Tarif_RJ_UGD_3 A
                    // INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD_4 B ON A.ID_TR_TARIF = B.ID_TR_TARIF
                    // INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD C ON C.ID = B.ID_TARIF
                    // INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD_2 D ON D.id_tarif = C.ID
                    // WHERE :tglbill between  replace(CONVERT(VARCHAR(11),a.TGL_BERLAKU, 111), '/','-')   and replace(CONVERT(VARCHAR(11),a.TGL_EXPIRED, 111), '/','-')  
                    // and b.KD_INSTALASI=:jenispasien and b.GROUP_TARIF=:groupjaminan
                    // and id_layanan=:idunit and KLSID = '3'
                    // order by 1 desc");

                    $this->db->query("SELECT 
                    A.ID_TR_TARIF,c.ID,c.[Product Name] as namatarif , D.id_layanan, SUM(b.NILAI) AS NILAI
                    FROM PerawatanSQL.DBO.Tarif_RJ_UGD_3 A
                    INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD_4 B ON A.ID_TR_TARIF = B.ID_TR_TARIF
                    INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD C ON C.ID = B.ID_TARIF
                    INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD_2 D ON D.id_tarif = C.ID
                    WHERE  :tglbill  between  replace(CONVERT(VARCHAR(11),a.TGL_BERLAKU, 111), '/','-')   and replace(CONVERT(VARCHAR(11),a.TGL_EXPIRED, 111), '/','-')  
                    and b.KD_INSTALASI=:jenispasien  AND B.GROUP_TARIF=:groupjaminan
                    and id_layanan=:idunit and KLSID = '3'
                    group by  A.ID_TR_TARIF,c.ID,c.[Product Name] ,D.id_layanan
                    order by 2 asc");
                }
            } else {
                $IDKelas = $data['IDKelas'];
                $noreg = $data['noreg'];

                var_dump($noreg);
                exit;

                // $this->db->query("SELECT First_Name from MasterdataSQL.dbo.Doctors where id = :iddokter");
                // $this->db->bind('iddokter', $iddokter);
                // $key =  $this->db->single();
                // $pasing['First_Name'] = $key['First_Name'];

                // var_dump('WLEEEEEEE');
                // exit;
            }

            $this->db->bind('idunit', $idunit);
            $this->db->bind('groupjaminan', $groupjaminan);
            $this->db->bind('tglbill', $tglbill);
            $this->db->bind('jenispasien', $jenispasien);
            $data =  $this->db->resultSet();
            //$this->db->closeCon();
            $rows = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['ProductName'] = $key['namatarif'];
                $pasing['NILAI'] = $key['NILAI'];
                $pasing['ID_TR_TARIF'] = $key['ID_TR_TARIF'];
                $rows[] = $pasing;
            }
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $rows
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function gettarifdetailnew($data)
    {
        try {
            // var_dump($data);
            // exit;
            $idunit = $data['idunit'];
            $groupjaminan = $data['groupjaminan'];
            $tglbill = $data['tglbill'];
            $jenispasien = $data['jenispasien'];

            $tarifvalue = $data['tarifvalue'];
            // $this->db->query("SELECT ID,[Product Name],CategoryProduct,TarifRS
            //                 from PerawatanSQL.dbo.Tarif_RJ_UGD where ID=:tarifvalue");

            if ($idunit == '1') {
                $this->db->query("SELECT A.ID_TR_TARIF,c.ID,c.[Product Name] as namatarif, c.CategoryProduct, sum(b.NILAI) as NILAI
                FROM PerawatanSQL.DBO.Tarif_RJ_UGD_3 A
                INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD_4 B ON A.ID_TR_TARIF = B.ID_TR_TARIF
                INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD C ON C.ID = B.ID_TARIF
                INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD_2 D ON D.id_tarif = C.ID
                WHERE :tglbill between  replace(CONVERT(VARCHAR(11),a.TGL_BERLAKU, 111), '/','-')   and replace(CONVERT(VARCHAR(11),a.TGL_EXPIRED, 111), '/','-')  
                and b.KD_INSTALASI=:jenispasien and b.GROUP_TARIF=:groupjaminan
                and id_layanan=:idunit and c.ID = :tarifvalue and KLSID = '2' 
                group by A.ID_TR_TARIF,c.ID,c.[Product Name], c.CategoryProduct");
            } else {
                $this->db->query("SELECT A.ID_TR_TARIF,c.ID,c.[Product Name] as namatarif, c.CategoryProduct, sum(b.NILAI) as NILAI
                FROM PerawatanSQL.DBO.Tarif_RJ_UGD_3 A
                INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD_4 B ON A.ID_TR_TARIF = B.ID_TR_TARIF
                INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD C ON C.ID = B.ID_TARIF
                INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD_2 D ON D.id_tarif = C.ID
                WHERE :tglbill between  replace(CONVERT(VARCHAR(11),a.TGL_BERLAKU, 111), '/','-')   and replace(CONVERT(VARCHAR(11),a.TGL_EXPIRED, 111), '/','-')  
                and b.KD_INSTALASI=:jenispasien and b.GROUP_TARIF=:groupjaminan
                and id_layanan=:idunit and c.ID = :tarifvalue and KLSID = '3' 
                group by A.ID_TR_TARIF,c.ID,c.[Product Name], c.CategoryProduct");
            }

            $this->db->bind('tarifvalue', $tarifvalue);
            $this->db->bind('idunit', $idunit);
            $this->db->bind('groupjaminan', $groupjaminan);
            $this->db->bind('tglbill', $tglbill);
            $this->db->bind('jenispasien', $jenispasien);
            $key =  $this->db->single();
            $pasing['ID'] = $key['ID'];
            $pasing['ProductName'] = $key['namatarif'];
            $pasing['CategoryProduct'] = $key['CategoryProduct'];
            $pasing['GetTarif'] = $key['NILAI'];
            $pasing['ID_TR_TARIF'] = $key['ID_TR_TARIF'];
            
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function getdokterdetailnew($data)
    {
        try {
            $iddokter = $data['iddokter'];

            $this->db->query("SELECT First_Name from MasterdataSQL.dbo.Doctors where id = :iddokter");
            $this->db->bind('iddokter', $iddokter);
            $key =  $this->db->single();
            $pasing['First_Name'] = $key['First_Name'];

            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function newInsertFO($data)
    {
        // var_dump($data);
        // exit;
        // $this->db->transaksi();
        $session = SessionManager::getCurrentSession();
        $userid = $session->username;
        $token = $session->token;
        $namauserx = $session->name;
        $datenowx = Utils::datenowcreateNotFull();
        $noreg = $data['NoRegistrasi'];

        $datenowcreate = Utils::seCurrentDateTime();
        $datenowcreate1 = date('Y-m-d', strtotime($datenowcreate));
        $datenowcreate2 = date('dmy', strtotime($datenowcreate));
        // $session = SessionManager::getCurrentSession();
        // $namauserx = $session->name;

        $datebilling = $data['tglbill'];
        $kodereg = $data['kodereg'];
        $datenowcreatex = $data['tglbill2'];

        $datenow = date('dmy', strtotime($datebilling));
        $datereg = substr($data['NoRegistrasi'], 4, 6);

        // $data['tglbill2']


        if ($kodereg == "RJ") {
            if ($datenow <> $datereg) {
                $callback = array(
                    'status' => "error", // Set array nama  
                    'message' => "Tanggal Billing harus sama dengan Tanggal Registrasi Pasien."
                );
                return $callback;
            }
        }

        try {
            $this->db->transaksi();

            // $datenowbilling = date('y-m-d', strtotime($datebilling));
            $datenow = date('dmy', strtotime($datebilling));


            $this->db->query("SELECT [Status ID] AS statuspasien FROM PerawatanSQL.dbo.visit WHERE NoRegistrasi = :norega1 UNION ALL SELECT StatusID AS statuspasien FROM RawatInapSQL.dbo.Inpatient WHERE NoRegRI = :norega2");
            $this->db->bind('norega1', $data['NoRegistrasi']);
            $this->db->bind('norega2', $data['NoRegistrasi']);
            $statuscek =  $this->db->single();
            $statuspasien = $statuscek['statuspasien'];

            if ($statuspasien == '4') {
                $callback = array(
                    'status' => "error", // Set array nama
                    'message' => "Status Pasien Sudah Close"
                );
                return $callback;
                exit;
            }


            $this->db->query("SELECT  TOP 1 NO_TRS_BILLING,right( REPLACE(NO_TRS_BILLING,'-','0')  ,5) as urut
            FROM Billing_Pasien.dbo.FO_T_BILLING  WHERE  
            replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-')=:datebilling  ORDER BY urut DESC");
            $this->db->bind('datebilling', $datebilling);
            $key =  $this->db->single();

            $nexturut = $key['urut'];
            $nexturut++;

            $nourutfix = Utils::generateAutoNumber($nexturut);
            $kodeawal = "BIL";
            $notrsbill = $kodeawal . $datenow . $nourutfix;
            $pasing['notrsbill'] = $notrsbill;


            //test
            if ($kodereg == 'RJ') {
                $this->db->query("SELECT TOP 1 NO_TRS_BILLING,
                right( REPLACE(NO_TRS_BILLING,'-','0')  ,5) as urut 
                FROM Billing_Pasien.dbo.FO_T_BILLING  
                WHERE replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-')=:datebilling  
                and SUBSTRING(no_trs_billing,1,3)='BIL'  ORDER BY urut DESC");
                $this->db->bind('datebilling', $datebilling);
                $datax =  $this->db->single();
                //no urut reg
                $nexturut = $datax['urut'];
               
                $nexturut++;
               
                $nourutfix = Utils::generateAutoNumber($nexturut);
                $kodeawal = "BIL";
                $notrsbill = $kodeawal . $datenow . $nourutfix;
                $pasing['notrsbill'] = $notrsbill; 

                $this->db->query("SELECT  Unit,PatientType,case when PatientType='2' then Asuransi else Perusahaan end as perusahaanid FROM PerawatanSQL.dbo.Visit  WHERE NoRegistrasi=:NoRegistrasi
        ");
                $this->db->bind('NoRegistrasi', $noreg);
                $datax =  $this->db->single();
                $IdGrupPerawatan = $datax['Unit'];
                $JenisBayar = $datax['PatientType'];
                $perusahaanid = $datax['perusahaanid'];
                $datenowcreatex1 = $datenowcreatex;
            }
            //get data Inpatient
            if ($kodereg == 'RI') {
                // var_dump($datenowcreate);
                // exit;
                $this->db->query("SELECT TOP 1 NO_TRS_BILLING,right( REPLACE(NO_TRS_BILLING,'-','0')  ,5) as urut FROM Billing_Pasien.dbo.FO_T_BILLING  WHERE replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-')=:datenow2a  ORDER BY urut DESC");
                $this->db->bind('datenow2a', $datenowcreate1);
                $datax =  $this->db->single();

                //no urut reg
                $nexturut = $datax['urut'];
                $nexturut++;

                $nourutfix = Utils::generateAutoNumber($nexturut);
                $kodeawal = "BIL";
                $notrsbill = $kodeawal . $datenowcreate2 . $nourutfix;


                $this->db->query("SELECT b.ID, a.TypePatient, case when a.TypePatient='2' then a.IDAsuransi else a.IDJPK end as perusahaanid 
        FROM RawatInapSQL.dbo.Inpatient a 
        INNER JOIN MasterdataSQL.dbo.MstrUnitPerwatan b ON b.NamaUnit = a.JenisRawat
        WHERE NoRegRI = :NoRegistrasi");
                $this->db->bind('NoRegistrasi', $noreg);
                $datax =  $this->db->single();
                $IdGrupPerawatan = $datax['ID'];
                $JenisBayar = $datax['TypePatient'];
                $perusahaanid = $datax['perusahaanid'];

                $datenowcreatex1 = $datenowcreate;
            }
            //test



            //  insert ke tabel FO_T_Billing
            $this->db->query("INSERT INTO Billing_Pasien.dbo.FO_T_BILLING
                                ([NO_TRS_BILLING],[TGL_BILLING],[PETUGAS_ENTRY],[NO_MR],[NO_EPISODE],[NO_REGISTRASI],[UNIT],[GROUP_JAMINAN],[KODE_JAMINAN],[TOTAL_TARIF],[TOTAL_QTY],[SUBTOTAL],[TOTAL_DISCOUNT],[TOTAL_DISCOUNT_RP],[SUBTOTAL_2],[GRANDTOTAL],[BATAL],[FB_CLOSE_KEUANGAN],[FB_VERIF_JURNAL])
                            VALUES
                                (:notrsbill,:datenowx,:namauserx,:NoMrfix,:NoEpisode,:nofixReg,:IdGrupPerawatan,:JenisBayar,:perusahaanid,:totaltarif,:totalqty,:subtotal,:totaldiscount,:totaldiscountrp,:subtotal2,:grandtotal,:batal,:closekeuangan,:verifkeuangan)");

            $this->db->bind('notrsbill', $notrsbill);
            $this->db->bind('datenowx', $datenowcreatex1);
            $this->db->bind('namauserx', $namauserx);
            $this->db->bind('NoMrfix', $data['NoMR']);
            $this->db->bind('NoEpisode', $data['NoEpisode']);
            $this->db->bind('nofixReg', $data['NoRegistrasi']);
            $this->db->bind('IdGrupPerawatan', $data['IDUnit']);
            $this->db->bind('JenisBayar', $data['GroupJaminan']);
            $this->db->bind('perusahaanid', $data['penjamin_kode']);
            $this->db->bind('totaltarif', 0);
            $this->db->bind('totalqty', 0);
            $this->db->bind('subtotal', 0);
            $this->db->bind('totaldiscount', 0);
            $this->db->bind('totaldiscountrp', 0);
            $this->db->bind('subtotal2', 0);
            $this->db->bind('grandtotal', 0);
            $this->db->bind('batal', 0);
            $this->db->bind('closekeuangan', 0);
            $this->db->bind('verifkeuangan', 0);
            $this->db->execute();

            $this->db->commit();
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function newInsertBill($data)
    {
        try {
            $this->db->transaksi();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;


            $datenowx = Utils::datenowcreateNotFull();

            if ($data['GROUP_JAMINAN'] == "1") {
                $kekurangan = $data['QTY'] * $data['NILAI_TARIF'];
                $klaim = "0";
                $bayar = "0";
            } else {
                $kekurangan = "0";
                $klaim = $data['QTY'] * $data['NILAI_TARIF'];
                $bayar = "0";
            }


            // cek dulu dokternya spesialis apa umum groupnya.
            $this->db->query("SELECT [Status ID] AS statusidpasien FROM PerawatanSQL.dbo.visit WHERE NoRegistrasi = :noreg123");
            $this->db->bind('noreg123', $data['NO_REGISTRASI']);
            $datastatuspasien =  $this->db->single();
            $statusidpasien = $datastatuspasien['statusidpasien'];
            if ($statusidpasien == '4') {
                $callback = array(
                    'status' => "error", // Set array nama
                    'message' => "Gagal menambahkan orderaan, Karena status pasien sudah close"
                );
                return $callback;
            }


            // cek dulu dokternya spesialis apa umum groupnya.
            $this->db->query("select KD_TIPE_JASA, First_Name from MasterdataSQL.dbo.Doctors where id=:iddokter");
            $this->db->bind('iddokter', $data['KD_DR']);
            $datadr =  $this->db->single();
            //no urut reg
            $KD_TIPE_JASA = $datadr['KD_TIPE_JASA'];
            $NAMADOKTER = $datadr['First_Name'];
            if ($KD_TIPE_JASA == null) {
                $callback = array(
                    'status' => "error", // Set array nama  
                    'message' => "Kode Tipe Jasa Kosong."
                );
                return $callback;
            }

            if ($data['KDREG'] == 'RJ') {
                if ($data['UNIT'] == '1') {
                    $kelas = '2';
                } else {
                    $kelas = '3';
                }
            } else {
                //belum
            }

            // var_dump($kelas);
            // exit;

            $this->db->query("INSERT INTO  Billing_Pasien.dbo.FO_T_BILLING_1
                    ([NO_TRS_BILLING],[TGL_BILLING],[PETUGAS_ENTRY],[NO_MR],
                    [NO_EPISODE],[NO_REGISTRASI],[KODE_TARIF],[UNIT],[GROUP_JAMINAN],
                    [KODE_JAMINAN],[NAMA_TARIF],[GROUP_TARIF],[KD_KELAS],[QTY],
                    [NILAI_TARIF],[SUB_TOTAL],[DISC],[DISC_RP],[SUB_TOTAL_2],[GRANDTOTAL],
                    [KD_DR],[NM_DR],[BATAL],[PETUGAS_BATAL],[GROUP_ENTRI]
                    ,BAYAR
                    ,KLAIM
                    ,KEKURANGAN)
                    VALUES
                    (:NO_TRS_BILLING,:TGL_BILLING,:PETUGAS_ENTRY,:NO_MR,
                    :NO_EPISODE,:NO_REGISTRASI,:KODE_TARIF,:UNIT,:GROUP_JAMINAN,
                    :KODE_JAMINAN,:NAMA_TARIF,:GROUP_TARIF,:KD_KELAS,:QTY,
                    :NILAI_TARIF,:SUB_TOTAL,:DISC,:DISC_RP,:SUB_TOTAL_2,:GRANDTOTAL,
                    :KD_DR,:NM_DR,:BATAL,:PETUGAS_BATAL,:GROUP_ENTRI
                    ,:BAYAR
                    ,:KLAIM
                    ,:KEKURANGAN)");

            $this->db->bind('NO_TRS_BILLING', $data['NO_TRS_BILLING']);
            $this->db->bind('TGL_BILLING', $data['TGL_BILLING']);
            $this->db->bind('PETUGAS_ENTRY', $namauserx);
            $this->db->bind('NO_MR', $data['NO_MR']);
            $this->db->bind('NO_EPISODE', $data['NO_EPISODE']);
            $this->db->bind('NO_REGISTRASI', $data['NO_REGISTRASI']);
            $this->db->bind('UNIT', $data['UNIT']);
            $this->db->bind('GROUP_JAMINAN', $data['GROUP_JAMINAN']);
            $this->db->bind('KODE_JAMINAN', $data['KODE_JAMINAN']);
            $this->db->bind('KODE_TARIF', $data['KODE_TARIF']);
            $this->db->bind('NAMA_TARIF', $data['NAMA_TARIF']);
            $this->db->bind('GROUP_TARIF', $data['GROUP_TARIF']);

            $this->db->bind('KD_KELAS', $kelas);
            $this->db->bind('QTY', $data['QTY']);
            $this->db->bind('NILAI_TARIF', $data['NILAI_TARIF']);
            $this->db->bind('SUB_TOTAL', $data['QTY'] * $data['NILAI_TARIF']);
            $this->db->bind('DISC', '0');
            $this->db->bind('DISC_RP', '0');
            $this->db->bind('SUB_TOTAL_2', $data['QTY'] * $data['NILAI_TARIF']);
            $this->db->bind('GRANDTOTAL', $data['QTY'] * $data['NILAI_TARIF']);
            $this->db->bind('KD_DR', $data['KD_DR']);
            $this->db->bind('NM_DR', $NAMADOKTER);
            $this->db->bind('BATAL', '0');
            $this->db->bind('PETUGAS_BATAL', '');
            $this->db->bind('GROUP_ENTRI', $data['GROUP_ENTRI']);
            $this->db->bind('BAYAR', $bayar);
            $this->db->bind('KLAIM', $klaim);
            $this->db->bind('KEKURANGAN', $kekurangan);
            $this->db->execute();

            $lastIdBilling1 = $this->db->GetLastID();

            // var_dump($KD_TIPE_JASA);
            // exit;

            // Insert ke tabel FO_T_Billing_2 - jasmed

            // baru insert

            //Insert ke tabel FO_T_Billing_2 - PDP
            // $this->db->query("INSERT INTO  Billing_Pasien.DBO.FO_T_BILLING_2
            // SELECT $lastIdBilling1 as ID_BILL,A.NO_TRS_BILLING AS NO_TRS_BILLING,A1.KODE_TARIF,B.KD_TIPE_PDP as Kode_komponen,A1.UNIT AS UNIT, A1.GROUP_JAMINAN AS GROUP_JAMINAN, A1.KODE_JAMINAN AS KODE_JAMINAN, 
            // A1.NAMA_TARIF AS NAMA_TARIF, 
            // A1.GROUP_TARIF AS GROUP_TARIF, A1.KD_KELAS as KELAS,A1.QTY AS QTY, 
            // A1.NILAI_TARIF AS NILAI_TARIF  ,
            // A1.NILAI_TARIF*A1.QTY  AS SUBTOTAL,
            // A1.DISC AS DISC,
            // (A1.NILAI_TARIF - (A1.NILAI_TARIF * (1 - A1.DISC))) AS DISC_RP,
            // (CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN (((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY)-(((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' THEN (b.NILAI_FIX*A1.QTY)-((b.NILAI_FIX*A1.QTY*DISC)/100)*A1.QTY END ) as SUB_TOTAL_PDP_2,
            // (CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN ((((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' THEN ((b.NILAI_FIX*A1.QTY*DISC)/100)*A1.QTY END ) NILAI_DISKON_PDP,
            // (CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN (((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY)-(((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' THEN (b.NILAI_FIX*A1.QTY)-((b.NILAI_FIX*A1.QTY*DISC)/100)*A1.QTY END ) as NILAI_PDP,
            // CASE WHEN B.SHOW_JASA='1' THEN A1.KD_DR ELSE '' END AS KD_DR,
            // CASE WHEN B.SHOW_JASA='1' THEN A1.NM_DR ELSE '' END AS NM_DR, b.NILAI_PROSEN,'0' AS BATAL,'' PETUGAS_BATAL, '' AS JAM_BATAL, B.KD_POSTING AS KD_POSTING, b.KD_POSTING_DISC as kd_posting_diskon,'0'
            // FROM Billing_Pasien.DBO.FO_T_BILLING A
            // inner join Billing_Pasien.dbo.FO_T_BILLING_1 A1
            // ON A.NO_TRS_BILLING = A1.NO_TRS_BILLING
            // INNER JOIN PerawatanSQL.dbo.Tarif_RJ_UGD CC 
            // ON CC.ID = A1.KODE_TARIF
            // INNER JOIN Keuangan.DBO.BO_M_PDP2 B
            // ON CC.KD_PDP collate SQL_Latin1_General_CP1_CI_AS = B.KD_PDP collate SQL_Latin1_General_CP1_CI_AS
            // INNER JOIN Keuangan.DBO.BO_M_PDP CX
            // ON CX.KD_PDP = B.KD_PDP
            // WHERE A1.GROUP_ENTRI='RAJAL' and a.BATAL='0' and A1.BATAL='0' and a.NO_TRS_BILLING=:notrsbill and A1.ID = :lastIdBilling1");

            $this->db->query("INSERT INTO  Billing_Pasien.DBO.FO_T_BILLING_2
            SELECT     $lastIdBilling1 as ID_BILL,A.NO_TRS_BILLING AS NO_TRS_BILLING,A1.KODE_TARIF,B.KD_TIPE_PDP as Kode_komponen,
			A1.UNIT AS UNIT, A1.GROUP_JAMINAN AS GROUP_JAMINAN, A1.KODE_JAMINAN AS KODE_JAMINAN, 
            A1.NAMA_TARIF AS NAMA_TARIF, 
            A1.GROUP_TARIF AS GROUP_TARIF, A1.KD_KELAS as KELAS,A1.QTY AS QTY, 
            A1.NILAI_TARIF AS NILAI_TARIF  ,
            A1.NILAI_TARIF*A1.QTY  AS SUBTOTAL,
            A1.DISC AS DISC,
            0 AS DISC_RP, 
            0 as SUB_TOTAL_PDP_2,
            0 NILAI_DISKON_PDP,
			dx.NILAI as NILAI_PDP,
            CASE WHEN B.SHOW_JASA='1' THEN A1.KD_DR ELSE '' END AS KD_DR,
            CASE WHEN B.SHOW_JASA='1' THEN A1.NM_DR ELSE '' END AS NM_DR, 
			b.NILAI_PROSEN,'0' AS BATAL,'' PETUGAS_BATAL, '' AS JAM_BATAL, B.KD_POSTING AS KD_POSTING, b.KD_POSTING_DISC as kd_posting_diskon,'0'
            FROM Billing_Pasien.DBO.FO_T_BILLING A
            inner join Billing_Pasien.dbo.FO_T_BILLING_1 A1
            ON A.NO_TRS_BILLING = A1.NO_TRS_BILLING
            INNER JOIN PerawatanSQL.dbo.Tarif_RJ_UGD CC 
            ON CC.ID = A1.KODE_TARIF
            INNER JOIN Keuangan.DBO.BO_M_PDP2 B
            ON CC.KD_PDP collate SQL_Latin1_General_CP1_CI_AS = B.KD_PDP collate SQL_Latin1_General_CP1_CI_AS
            INNER JOIN Keuangan.DBO.BO_M_PDP CX
            ON CX.KD_PDP = B.KD_PDP
			INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD_4 DX
			ON DX.ID_TARIF = CC.ID  and dx.KD_PDP collate Latin1_General_CI_AS =  CC.KD_PDP  collate Latin1_General_CI_AS 
			AND DX.KD_PDP_DETIL  collate Latin1_General_CI_AS  = b.KD_TIPE_PDP  collate Latin1_General_CI_AS
			WHERE A1.GROUP_ENTRI='RAJAL' and a.BATAL='0' and A1.BATAL='0' and a.NO_TRS_BILLING=:notrsbill and A1.ID =  :lastIdBilling1
			and dx.ID_TR_TARIF=:idtrstariftdk and DX.GROUP_TARIF = 'UM' and dx.NILAI > '0' ");
            $this->db->bind('notrsbill', $data['NO_TRS_BILLING']);
            $this->db->bind('idtrstariftdk', $data['idtrstariftdk']);
            $this->db->bind('lastIdBilling1', $lastIdBilling1);
            $this->db->execute();


            //UPDATE TOTAL KE FO_T_BILLING
            $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_BILLING
                        SET TOTAL_TARIF=B.SUM_NILAI_TARIF,TOTAL_QTY=B.SUM_QTY,SUBTOTAL=B.SUM_SUB_TOTAL,SUBTOTAL_2=B.SUM_SUB_TOTAL_2,GRANDTOTAL=B.SUM_GRANDTOTAL
                        FROM Billing_Pasien.DBO.FO_T_BILLING A 
                        INNER JOIN
                        (
                            SELECT  NO_TRS_BILLING,SUM(NILAI_TARIF) AS SUM_NILAI_TARIF,SUM(QTY) AS SUM_QTY,SUM(SUB_TOTAL) AS SUM_SUB_TOTAL,SUM(SUB_TOTAL_2) AS SUM_SUB_TOTAL_2,
                            SUM(GRANDTOTAL) AS SUM_GRANDTOTAL
                            FROM Billing_Pasien.DBO.FO_T_BILLING_1
                            WHERE NO_REGISTRASI=:noreg and Batal='0'
                            GROUP BY NO_TRS_BILLING
                        ) B
                        ON A.NO_TRS_BILLING = B.NO_TRS_BILLING
                        WHERE A.NO_REGISTRASI=:noreg2");
            $this->db->bind('noreg', $data['NO_REGISTRASI']);
            $this->db->bind('noreg2', $data['NO_REGISTRASI']);
            $this->db->execute();

            // UPDATE FO BILLING BATAL == 0
            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING SET BATAL = '0', PETUGAS_BATAL = '' WHERE NO_TRS_BILLING = :NO_TRS_BILLING");
            $this->db->bind('NO_TRS_BILLING', $data['NO_TRS_BILLING']);
            $this->db->execute();


            $this->db->commit();
            $callback = array(
                'message' => "success", // Set array nama 
                'lastIdBilling1' => $lastIdBilling1,
                'KD_TIPE_JASA' =>  $KD_TIPE_JASA,
                'NO_TRS_BILLING' => $data['NO_TRS_BILLING'],
                'nm' =>  $KD_TIPE_JASA,

            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }



    public function showDatafoBill($data)
    {
        try {
            $notrsbill = $data['NoTRS'];

            $this->db->query("SELECT ID, NAMA_TARIF,NM_DR,KODE_TARIF, NO_TRS_BILLING, TGL_BILLING, QTY, NILAI_TARIF, SUB_TOTAL, DISC,KLAIM,KEKURANGAN, SUB_TOTAL_2, GROUP_ENTRI, KODE_REF FROM Billing_Pasien.dbo.FO_T_BILLING_1  WHERE NO_TRS_BILLING=:notrsbill AND BATAL = '0'");
            $this->db->bind('notrsbill', $notrsbill);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['NAMA_TARIF'] = $key['NAMA_TARIF'];
                $pasing['NM_DR'] = $key['NM_DR'];
                $pasing['KLAIM'] = $key['KLAIM'];
                $pasing['KEKURANGAN'] = $key['KEKURANGAN'];

                $pasing['NO_TRS_BILLING'] = $key['NO_TRS_BILLING'];
                $pasing['TGL_BILLING'] = $key['TGL_BILLING'];
                $pasing['QTY'] = $key['QTY'];
                $pasing['NILAI_TARIF'] = $key['NILAI_TARIF'];
                $pasing['SUB_TOTAL'] = $key['SUB_TOTAL'];
                $pasing['KODE_TARIF'] = $key['KODE_TARIF'];
                $pasing['DISC'] = $key['DISC'];
                $pasing['SUB_TOTAL_2'] = $key['SUB_TOTAL_2'];

                $pasing['GROUP_ENTRI'] = $key['GROUP_ENTRI'];
                $pasing['KODE_REF'] = $key['KODE_REF'];


                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function updateBatalBill($data)
    {
        try {
            $this->db->transaksi();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;

            $datenowx = Utils::datenowcreateNotFull();

            $idfo1 = $data['Idfo1'];


            $this->db->query("SELECT [Status ID] AS statuspasien FROM PerawatanSQL.dbo.visit WHERE NoRegistrasi = :norega1 UNION ALL SELECT StatusID AS statuspasien FROM RawatInapSQL.dbo.Inpatient WHERE NoRegRI = :norega2");
            $this->db->bind('norega1', $data['Noreg']);
            $this->db->bind('norega2', $data['Noreg']);
            $statuscek =  $this->db->single();
            $statuspasien = $statuscek['statuspasien'];

            if ($statuspasien == '4') {
                $callback = array(
                    'status' => "error", // Set array nama
                    'message' => "Status Pasien Sudah Close"
                );
                return $callback;
                exit;
            }

            $this->db->query("SELECT ID_TRS_Payment FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE ID = :idtrsfo1ab");
            $this->db->bind('idtrsfo1ab', $idfo1);
            $datastrspaymentcek =  $this->db->single();
            $ID_TRS_Payment = $datastrspaymentcek['ID_TRS_Payment'];


            if ($ID_TRS_Payment != NULL) {
                $callback = array(
                    'status' => 'error',
                    'message' => 'Gagal menghapus orderan, Karena orderan sudah di payment!',
                );
                return $callback;
                exit;
            }

            // var_dump($idfo1);
            // exit;

            //  UPDATE ke tabel FO_T_Billing_1
            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 SET BATAL = '1', PETUGAS_BATAL = :PETUGAS_ENTRY WHERE ID = :idfo1");
            $this->db->bind('PETUGAS_ENTRY', $namauserx);
            $this->db->bind('idfo1', $idfo1);

            $this->db->execute();

            ///  UPDATE ke tabel FO_T_Billing_2
            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_2 SET BATAL = '1', PETUGAS_BATAL = :PETUGAS_ENTRY WHERE ID_BILL = :idfo1");
            $this->db->bind('PETUGAS_ENTRY', $namauserx);
            $this->db->bind('idfo1', $idfo1);

            $this->db->execute();

            //UPDATE TOTAL KE FO_T_BILLING FB_VERIF_JURNAL
            $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_BILLING
            SET FB_VERIF_JURNAL = '0' where NO_TRS_BILLING = :notrs");
            $this->db->bind('notrs', $data['Notrs']);

            $this->db->execute();


            //UPDATE TOTAL KE FO_T_BILLING
            $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_BILLING
                        SET TOTAL_TARIF=B.SUM_NILAI_TARIF,TOTAL_QTY=B.SUM_QTY,SUBTOTAL=B.SUM_SUB_TOTAL,SUBTOTAL_2=B.SUM_SUB_TOTAL_2,GRANDTOTAL=B.SUM_GRANDTOTAL
                        FROM Billing_Pasien.DBO.FO_T_BILLING A 
                        INNER JOIN
                        (
                            SELECT  NO_TRS_BILLING,SUM(NILAI_TARIF) AS SUM_NILAI_TARIF,SUM(QTY) AS SUM_QTY,SUM(SUB_TOTAL) AS SUM_SUB_TOTAL,SUM(SUB_TOTAL_2) AS SUM_SUB_TOTAL_2,
                            SUM(GRANDTOTAL) AS SUM_GRANDTOTAL
                            FROM Billing_Pasien.DBO.FO_T_BILLING_1
                            WHERE NO_REGISTRASI=:noreg and Batal='0'
                            GROUP BY NO_TRS_BILLING
                        ) B
                        ON A.NO_TRS_BILLING = B.NO_TRS_BILLING
                        WHERE A.NO_REGISTRASI=:noreg2");
            $this->db->bind('noreg', $data['Noreg']);
            $this->db->bind('noreg2', $data['Noreg']);
            $this->db->execute();


            // UPDATE BILLFO KETIKA TINDAKAN TIDAK ADA
            $this->db->query(" SELECT COUNT(*) as jumlahbaris FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE NO_TRS_BILLING = :notrsx AND BATAL = '0'");
            $this->db->bind('notrsx', $data['Notrs']);
            $datas =  $this->db->single();
            // var_dump($data);
            // exit;
            $JumlahBaris = $datas['jumlahbaris'];

            if ($JumlahBaris == "0") {

                $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING SET BATAL = '1', PETUGAS_BATAL = :namauserxs WHERE NO_TRS_BILLING = :notrsxs");
                $this->db->bind('notrsxs', $data['Notrs']);
                $this->db->bind('namauserxs', $namauserx);

                $this->db->execute();
            }

            $this->db->commit();
            $callback = array(
                'message' => "success", // Set array nama 

            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function saveDataBill($data)
    {
        try {
            $this->db->transaksi();

            //UPDATE TOTAL KE FO_T_BILLING
            $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_BILLING
                        SET TOTAL_TARIF=B.SUM_NILAI_TARIF,TOTAL_QTY=B.SUM_QTY,SUBTOTAL=B.SUM_SUB_TOTAL,SUBTOTAL_2=B.SUM_SUB_TOTAL_2,GRANDTOTAL=B.SUM_GRANDTOTAL
                        FROM Billing_Pasien.DBO.FO_T_BILLING A 
                        INNER JOIN
                        (
                            SELECT  NO_TRS_BILLING,SUM(NILAI_TARIF) AS SUM_NILAI_TARIF,SUM(QTY) AS SUM_QTY,SUM(SUB_TOTAL) AS SUM_SUB_TOTAL,SUM(SUB_TOTAL_2) AS SUM_SUB_TOTAL_2,
                            SUM(GRANDTOTAL) AS SUM_GRANDTOTAL
                            FROM Billing_Pasien.DBO.FO_T_BILLING_1
                            WHERE NO_REGISTRASI=:noreg and Batal='0'
                            GROUP BY NO_TRS_BILLING
                        ) B
                        ON A.NO_TRS_BILLING = B.NO_TRS_BILLING
                        WHERE A.NO_REGISTRASI=:noreg2");
            $this->db->bind('noreg', $data['Noreg']);
            $this->db->bind('noreg2', $data['Noreg']);

            $this->db->execute();

            $this->db->commit();
            $callback = array(
                'message' => "success", // Set array nama 

            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function showUpdateBillByFO1($data)
    {
        try {

            $idfo1 = $data['idfo1'];
            // $KODE_TARIF = $data['KODE_TARIF'];

            $this->db->query("SELECT ID, NO_TRS_BILLING, TGL_BILLING, KODE_TARIF, NAMA_TARIF, GRANDTOTAL FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE ID = :idfo1 AND BATAL = '0'");
            $this->db->bind('idfo1', $idfo1);
            // $this->db->bind('KODE_TARIF', $KODE_TARIF);
            $key =  $this->db->single();
            $pasing['ID'] = $key['ID'];
            $pasing['NO_TRS_BILLING'] = $key['NO_TRS_BILLING'];
            $pasing['TGL_BILLING'] = $key['TGL_BILLING'];
            $pasing['KODE_TARIF'] = $key['KODE_TARIF'];
            $pasing['NAMA_TARIF'] = $key['NAMA_TARIF'];
            $pasing['GRANDTOTAL'] = $key['GRANDTOTAL'];

            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function GetCetakanKe($data)
    {
        try {
            $query = "SELECT Count(ID) as CetakanKe
                FROM Billing_Pasien.dbo.TDocumentBillingPatients
                where NoTrs_Reff=:notrs AND GrupTransaksi=:jeniscetakan AND NoRegistrasi=:noregistrasi";
            $this->db->query($query);
            $this->db->bind('notrs', $data['notrs']);
            $this->db->bind('jeniscetakan', $data['jeniscetakan']);
            $this->db->bind('noregistrasi', $data['listdataheader']['NoRegistrasi']);
            $datas =  $this->db->single();

            $pasing['CetakanKe'] = $datas['CetakanKe'] + 1;

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    public function showDataBillFO2($data)
    {
        try {
            $notrsbillfo1 = $data['notrsbillfo1'];
            $KODE_TARIF = $data['KODE_TARIF'];

            $this->db->query("SELECT a.ID, a.KODE_TARIF, a.NAMA_TARIF, a.QTY, a.NILAI_TARIF, a.SUB_TOTAL, a.DISC, a.DISC_RP, 
a.NILAI_PROSEN, a.NILAI_DISKON_PDP, a.SUB_TOTAL_2, a.NILAI_PDP, a.KODE_KOMPONEN_TARIF, 
                            CASE
                            WHEN  KD_DR IS NULL OR NM_DR IS NULL OR NM_DR ='' OR KD_DR ='' THEN b.NM_TIPE_PDP
                            ELSE b.NM_TIPE_PDP + ' - ' + NM_DR END  AS JasaBill
                            FROM Billing_Pasien.dbo.FO_T_BILLING_2 a
							inner join Keuangan.dbo.BO_M_PDP2 b
							on a.KODE_KOMPONEN_TARIF = b.KD_TIPE_PDP WHERE NO_TRS_BILLING = :notrsbillfo1 AND BATAL = '0' AND KODE_TARIF = :KODE_TARIF");
            $this->db->bind('notrsbillfo1', $notrsbillfo1);
            $this->db->bind('KODE_TARIF', $KODE_TARIF);
            $data =  $this->db->resultSet();
            $rows = array();
            // $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['KODE_TARIF'] = $key['KODE_TARIF'];
                $pasing['NAMA_TARIF'] = $key['NAMA_TARIF'];
                $pasing['QTY'] = $key['QTY'];
                $pasing['NILAI_TARIF'] = $key['NILAI_TARIF'];
                $pasing['SUB_TOTAL'] = $key['SUB_TOTAL'];
                $pasing['NILAI_PDP'] = $key['NILAI_PDP'];
                $pasing['DISC'] = $key['DISC'];
                $pasing['DISC_RP'] = $key['DISC_RP'];
                $pasing['NILAI_PROSEN'] = $key['NILAI_PROSEN'];
                $pasing['NILAI_DISKON_PDP'] = $key['NILAI_DISKON_PDP'];
                $pasing['SUB_TOTAL_2'] = $key['SUB_TOTAL_2'];
                $pasing['KODE_KOMPONEN_TARIF'] = $key['KODE_KOMPONEN_TARIF'];
                $pasing['JasaBill'] = $key['JasaBill'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function updateBatalBillfo2($data)
    {
        try {
            $this->db->transaksi();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;

            $datenowx = Utils::datenowcreateNotFull();

            $idfo2 = $data['Idfo2'];
            $idfo1 = $data['Idfo1'];

            $this->db->query("SELECT [Status ID] AS statuspasien FROM PerawatanSQL.dbo.visit WHERE NoRegistrasi = :norega1 UNION ALL SELECT StatusID AS statuspasien FROM RawatInapSQL.dbo.Inpatient WHERE NoRegRI = :norega2");
            $this->db->bind('norega1', $data['Noreg']);
            $this->db->bind('norega2', $data['Noreg']);
            $statuscek =  $this->db->single();
            $statuspasien = $statuscek['statuspasien'];

            if ($statuspasien == '4') {
                $callback = array(
                    'status' => "error", // Set array nama
                    'message' => "Status Pasien Sudah Close"
                );
                return $callback;
                exit;
            }


            $this->db->query("SELECT ID_TRS_Payment FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE ID = :idtrsfo1ab");
            $this->db->bind('idtrsfo1ab', $idfo1);
            $datastrspaymentcek =  $this->db->single();
            $ID_TRS_Payment = $datastrspaymentcek['ID_TRS_Payment'];


            if ($ID_TRS_Payment != NULL) {
                $callback = array(
                    'status' => 'error',
                    'message' => 'Gagal menghapus orderan, Karena orderan sudah di payment!',
                );
                return $callback;
                exit;
            }
            // var_dump($idfo1);
            // exit;


            //  insert ke tabel FO_T_Billing
            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_2 SET BATAL = '1', PETUGAS_BATAL = :PETUGAS_ENTRY WHERE ID = :idfo2");
            $this->db->bind('PETUGAS_ENTRY', $namauserx);
            $this->db->bind('idfo2', $idfo2);
            $this->db->execute();


            //UPDATE TOTAL KE FO_T_BILLING
            $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_BILLING
            SET FB_VERIF_JURNAL = '0' where NO_TRS_BILLING = :notrs");
            $this->db->bind('notrs', $data['Notrs']);
            $this->db->execute();

            // UPDATE BILL1 KETIKA TINDAKAN TIDAK ADA
            $this->db->query(" SELECT COUNT(*) as jumlahbaris FROM Billing_Pasien.dbo.FO_T_BILLING_2 WHERE NO_TRS_BILLING = :notrsx AND BATAL = '0'");
            $this->db->bind('notrsx', $data['Notrs']);
            $datas =  $this->db->single();
            // var_dump($data);
            // exit;
            $JumlahBaris = $datas['jumlahbaris'];

            if ($JumlahBaris == "0") {

                $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 SET BATAL = '1', PETUGAS_BATAL = :namauserxs WHERE NO_TRS_BILLING = :notrsxs");
                $this->db->bind('notrsxs', $data['Notrs']);
                $this->db->bind('namauserxs', $namauserx);

                $this->db->execute();
            }

            // UPDATE BILL1 KETIKA TINDAKAN TIDAK ADA
            $this->db->query(" SELECT COUNT(*) as jumlahbaris FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE NO_TRS_BILLING = :notrsx AND BATAL = '0'");
            $this->db->bind('notrsx', $data['Notrs']);
            $datasx =  $this->db->single();
            // var_dump($data);
            // exit;
            $JumlahBarisx = $datasx['jumlahbaris'];

            if ($JumlahBarisx == "0") {

                $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING SET BATAL = '1', PETUGAS_BATAL = :namauserxs WHERE NO_TRS_BILLING = :notrsxs");
                $this->db->bind('notrsxs', $data['Notrs']);
                $this->db->bind('namauserxs', $namauserx);

                $this->db->execute();
            }

            $this->db->commit();
            $callback = array(
                'message' => "success", // Set array nama 

            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function getsavebillfo2($data)
    {
        try {

            // var_dump($data);
            // exit;
            $this->db->transaksi();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $datenowx = Utils::datenowcreateNotFull();

            // var_dump($data);
            // exit;
            $id_fo2 = $data['id_fo2'];
            $nilaitariffo2 = $data['NILAI_TARIF'];
            $QTY = $data['QTY'];
            $DISC_PDP = $data['DISC'];
            $kodetarif_fo2 = $data['kodetarif_fo2'];
            $NoTRSBill1 = $data['NoTRSBill1'];
            $noreg = $data['Noreg'];
            $id_fo1 = $data['id_fo1'];
            $NILAI_PDP = $data['NILAI_PDP'];
            $TypePatientID = $data['TypePatientID'];
            $nilaiProsen = $data['NILAIPROSEN'];
            // $NILAI_PDP = 0.1;

            $this->db->query("SELECT [Status ID] AS statuspasien FROM PerawatanSQL.dbo.visit WHERE NoRegistrasi = :norega1 UNION ALL SELECT StatusID AS statuspasien FROM RawatInapSQL.dbo.Inpatient WHERE NoRegRI = :norega2");
            $this->db->bind('norega1', $data['Noreg']);
            $this->db->bind('norega2', $data['Noreg']);
            $statuscek =  $this->db->single();
            $statuspasien = $statuscek['statuspasien'];

            if ($statuspasien == '4') {
                $callback = array(
                    'status' => "error", // Set array nama
                    'message' => "Status Pasien Sudah Close"
                );
                return $callback;
                exit;
            }

            $this->db->query("SELECT ID_TRS_Payment FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE ID = :idtrsfo1ab");
            $this->db->bind('idtrsfo1ab', $id_fo1);
            $datastrspaymentcek =  $this->db->single();
            $ID_TRS_Payment = $datastrspaymentcek['ID_TRS_Payment'];

            if ($ID_TRS_Payment != NULL) {
                $callback = array(
                    'status' => 'error',
                    'message' => 'Gagal Update Orderan, Karena orderan sudah di payment!',
                );
                return $callback;
                exit;
            }

            $subtotal2a = $nilaitariffo2 * $nilaiProsen;
            $subtotal2b = $subtotal2a - ($subtotal2a * $DISC_PDP);



            // $subtotal2c = 0;
            // if ($DISC_PDP <> '0') {
            $subtotaldiscrp = $subtotal2a * $DISC_PDP;
            $subtotaldisc = $subtotaldiscrp / $nilaitariffo2;

            // }
            // $subtotaldiskon = $subtotal2b / $nilaitariffo2;
            // $subtotaldiskonrp = $nilaitariffo2 * $subtotaldiskon;


            // var_dump('Nilai PDP AWAL : ', $subtotal2a);
            // var_dump('NILAI PDP SESUDAH DI DISKON :', $subtotal2b);
            // var_dump('DISKON TOTAL :', $subtotaldiskon);
            // var_dump('DISKON RP TOTAL :', $subtotaldiskonrp);
            // exit;

            //  insert ke tabel FO_T_Billing2a
            // $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_2 SET QTY = :QTY1 , SUB_TOTAL = :subtotal, DISC = :DISC1, SUB_TOTAL_2 = :subtotal2, DISC_RP = :discRP1  WHERE ID = :id_fo2");
            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_2 SET NILAI_DISKON_PDP = :DISC_PDPa, SUB_TOTAL_2 = :subtotal2a, 
            NILAI_PDP = :subtotal2b, 
            DISC = :subtotaldisc, DISC_RP = :subtotaldiscrp WHERE ID = :id_fo2");
            $this->db->bind('id_fo2', $id_fo2);
            // $this->db->bind('QTY1', $QTY);
            $this->db->bind('subtotal2a', $subtotal2b);
            $this->db->bind('subtotal2b', $subtotal2b);
            $this->db->bind('subtotaldiscrp', $subtotaldiscrp);
            // $this->db->bind('subtotal', $subtotal);
            // $this->db->bind('DISC1', $DISC);
            $this->db->bind('DISC_PDPa', $DISC_PDP);
            $this->db->bind('subtotaldisc', $subtotaldisc);
            // $this->db->bind('subtotaldiskon', $subtotaldiskon);
            // $this->db->bind('subtotaldiskonrp', $subtotaldiskonrp);
            // $this->db->bind('discRP1', $discRP);
            $this->db->execute();


            // var_dump('ok');
            // exit;

            // //  insert ke tabel FO_T_Billing2b
            // // $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_2 SET QTY = :QTY1 , SUB_TOTAL = :subtotal, DISC = :DISC1, SUB_TOTAL_2 = :subtotal2, DISC_RP = :discRP1  WHERE ID = :id_fo2");
            // $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_2 SET NILAI_DISKON_PDP = :DISC_PDP, SUB_TOTAL_2 = :subtotal2a, NILAI_PDP = :subtotal2b  WHERE NO_TRS_BILLING = :NoTRSBill1");
            // $this->db->bind('NoTRSBill1', $NoTRSBill1);
            // // $this->db->bind('QTY1', $QTY);
            // $this->db->bind('subtotal2a', $subtotal2b);
            // $this->db->bind('subtotal2b', $subtotal2b);
            // // $this->db->bind('subtotal', $subtotal);
            // // $this->db->bind('DISC1', $DISC);
            // $this->db->bind('DISC_PDP', $DISC_PDP);
            // // $this->db->bind('discRP1', $discRP);
            // $this->db->execute();

            // $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 SET GRANDTOTAL = :subtotal2b2, QTY = :QTY1b , SUB_TOTAL = :subtotalb, DISC = :DISC1b, SUB_TOTAL_2 = :subtotal2b, DISC_RP = :discRP1b, BAYAR= :bayarb, KLAIM= :klaimb, KEKURANGAN= :kekuranganb WHERE NO_TRS_BILLING = :NoTRSBill1b AND KODE_TARIF = :kodetarif_fo2b");
            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 SET 
                            GRANDTOTAL = B.SUM_SUB_TOTAL_2, SUB_TOTAL_2 = B.SUM_SUB_TOTAL_2, BAYAR = '0', klaim = B.SUM_SUB_TOTAL_KLAIM, KEKURANGAN = B.SUM_SUB_TOTAL_KEKURANGAN,
                            DISC = B.SUM_DISC_2, DISC_RP = B.SUM_DISC_RP2
                            FROM Billing_Pasien.dbo.FO_T_BILLING_1 A 
                            INNER JOIN 
                            (
                            	SELECT NO_TRS_BILLING,SUM(SUB_TOTAL_2) AS SUM_SUB_TOTAL_2,
                            	CASE 
                            	WHEN $TypePatientID = '1' THEN SUM(SUB_TOTAL_2)
                            	ELSE 0 END AS SUM_SUB_TOTAL_KEKURANGAN,
                            	CASE
                            	WHEN $TypePatientID != '1' THEN SUM(SUB_TOTAL_2)
                            	ELSE 0 END AS SUM_SUB_TOTAL_KLAIM, SUM(DISC) AS SUM_DISC_2, SUM(DISC_RP) AS SUM_DISC_RP2
                                FROM Billing_Pasien.dbo.FO_T_BILLING_2
                                WHERE NO_TRS_BILLING = :NoTRSBill2b and Batal='0' AND KODE_TARIF = :kodetarif_fo2b
                                GROUP BY NO_TRS_BILLING
                            ) B
                            ON A.NO_TRS_BILLING = B.NO_TRS_BILLING
                            WHERE A.NO_TRS_BILLING = :NoTRSBill1b AND KODE_TARIF = :kodetarif_fo1b AND Batal='0'");
            // $this->db->bind('QTY1b', $QTY);
            // $this->db->bind('subtotal2b', $subtotal2);
            // $this->db->bind('subtotal2b2', $subtotal2);
            // $this->db->bind('subtotalb', $subtotal);
            // $this->db->bind('DISC1b', $DISC);
            // $this->db->bind('discRP1b', $discRP);
            $this->db->bind('NoTRSBill1b', $NoTRSBill1);
            $this->db->bind('NoTRSBill2b', $NoTRSBill1);
            $this->db->bind('kodetarif_fo1b', $kodetarif_fo2);
            $this->db->bind('kodetarif_fo2b', $kodetarif_fo2);
            // $this->db->bind('kekuranganb', $kekurangan);
            // $this->db->bind('klaimb', $klaim);
            // $this->db->bind('bayarb', $bayar);
            $this->db->execute();


            // var_dump('ok');
            // exit;

            $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_BILLING
                    SET TOTAL_TARIF=B.SUM_NILAI_TARIF,TOTAL_QTY=B.SUM_QTY,SUBTOTAL=B.SUM_SUB_TOTAL,SUBTOTAL_2=B.SUM_SUB_TOTAL_2,GRANDTOTAL=B.SUM_GRANDTOTAL
                    FROM Billing_Pasien.DBO.FO_T_BILLING A 
                    INNER JOIN
                    (
                        SELECT  NO_TRS_BILLING,SUM(NILAI_TARIF) AS SUM_NILAI_TARIF,SUM(isnull(QTY,0)) AS SUM_QTY,SUM(SUB_TOTAL) AS SUM_SUB_TOTAL,SUM(SUB_TOTAL_2) AS SUM_SUB_TOTAL_2,
                        SUM(GRANDTOTAL) AS SUM_GRANDTOTAL
                        FROM Billing_Pasien.DBO.FO_T_BILLING_1
                        WHERE NO_REGISTRASI=:noreg and Batal='0'
                        GROUP BY NO_TRS_BILLING
                    ) B
                    ON A.NO_TRS_BILLING = B.NO_TRS_BILLING
                    WHERE A.NO_REGISTRASI=:noreg2 AND A.NO_TRS_BILLING=:notrsbill");
            $this->db->bind('noreg', $noreg);
            $this->db->bind('noreg2', $noreg);
            $this->db->bind('notrsbill', $NoTRSBill1);
            $this->db->execute();

            $this->db->commit();
            $callback = array(
                'message' => "success", // Set array nama 
            );

            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function ShowTindakanbyFO1($data)
    {
        try {

            $IDFO1 = $data['IDFO1'];
            // $KODE_TARIF = $data['KODE_TARIF'];

            $this->db->query("SELECT ID, NO_TRS_BILLING,replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-') AS TGL_BILLING_DATE, replace(CONVERT(VARCHAR(5), TGL_BILLING, 108), '-',':') AS TGL_BILLING_TIME FROM Billing_Pasien.dbo.FO_T_BILLING_1 
            WHERE ID=:IDFO1 AND BATAL = '0'");
            $this->db->bind('IDFO1', $IDFO1);
            // $this->db->bind('KODE_TARIF', $KODE_TARIF);
            $key =  $this->db->single();
            $pasing['ID'] = $key['ID'];
            $pasing['NO_TRS_BILLING'] = $key['NO_TRS_BILLING'];
            $pasing['TGL_BILLING'] = $key['TGL_BILLING_DATE'];
            $pasing['TIME_BILLING'] = $key['TGL_BILLING_TIME'];

            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function UpdateKlaimbyFO1($data)
    {
        try {
            $this->db->transaksi();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $datenowx = Utils::datenowcreateNotFull();

            // var_dump($data);
            // exit;
            $id_fo1 = $data['Idfo1'];
            $valuea = $data['ValueKekurangan'];


            $this->db->query("SELECT [Status ID] AS statuspasien FROM PerawatanSQL.dbo.visit WHERE NoRegistrasi = :norega1 UNION ALL SELECT StatusID AS statuspasien FROM RawatInapSQL.dbo.Inpatient WHERE NoRegRI = :norega2");
            $this->db->bind('norega1', $data['Noreg']);
            $this->db->bind('norega2', $data['Noreg']);
            $statuscek =  $this->db->single();
            $statuspasien = $statuscek['statuspasien'];

            if ($statuspasien == '4') {
                $callback = array(
                    'status' => "error", // Set array nama
                    'message' => "Status Pasien Sudah Close"
                );
                return $callback;
                exit;
            }

            $this->db->query("SELECT ID_TRS_Payment FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE ID = :idtrsfo1ab");
            $this->db->bind('idtrsfo1ab', $id_fo1);
            $datastrspaymentcek =  $this->db->single();
            $ID_TRS_Payment = $datastrspaymentcek['ID_TRS_Payment'];


            if ($ID_TRS_Payment != NULL) {
                $callback = array(
                    'status' => 'error',
                    'message' => 'Gagal menghapus orderan, Karena orderan sudah di payment!',
                );
                return $callback;
                exit;
            }

            // var_dump($id_fo1);
            // exit;
            // $kodetarif_fo2 = $data['kodetarif_fo2'];


            //  insert ke tabel FO_T_Billing
            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 SET KLAIM =:valuea, KEKURANGAN = '0'  WHERE ID = :id_fo1");
            $this->db->bind('id_fo1', $id_fo1);
            $this->db->bind('valuea', $valuea);

            $this->db->execute();

            //UPDATE TOTAL KE FO_T_BILLING
            $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_BILLING
            SET FB_VERIF_JURNAL = '0' where NO_TRS_BILLING = :notrs");
            $this->db->bind('notrs', $data['Notrs']);

            $this->db->execute();

            $this->db->commit();
            $callback = array(
                'message' => "success", // Set array nama 

            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function UpdateUnklaimbyFO1($data)
    {
        try {
            $this->db->transaksi();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $datenowx = Utils::datenowcreateNotFull();

            // var_dump($data);
            // exit;
            $id_fo1 = $data['Idfo1'];
            $valuea = $data['ValueKlaim'];
            // var_dump($QTY);
            // exit;
            // $kodetarif_fo2 = $data['kodetarif_fo2'];


            $this->db->query("SELECT [Status ID] AS statuspasien FROM PerawatanSQL.dbo.visit WHERE NoRegistrasi = :norega1 UNION ALL SELECT StatusID AS statuspasien FROM RawatInapSQL.dbo.Inpatient WHERE NoRegRI = :norega2");
            $this->db->bind('norega1', $data['Noreg']);
            $this->db->bind('norega2', $data['Noreg']);
            $statuscek =  $this->db->single();
            $statuspasien = $statuscek['statuspasien'];

            if ($statuspasien == '4') {
                $callback = array(
                    'status' => "error", // Set array nama
                    'message' => "Status Pasien Sudah Close"
                );
                return $callback;
                exit;
            }

            $this->db->query("SELECT ID_TRS_Payment FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE ID = :idtrsfo1ab");
            $this->db->bind('idtrsfo1ab', $id_fo1);
            $datastrspaymentcek =  $this->db->single();
            $ID_TRS_Payment = $datastrspaymentcek['ID_TRS_Payment'];


            if ($ID_TRS_Payment != NULL) {
                $callback = array(
                    'status' => 'error',
                    'message' => 'Gagal menghapus orderan, Karena orderan sudah di payment!',
                );
                return $callback;
                exit;
            }

            // var_dump($id_fo1);
            // exit;


            //  insert ke tabel FO_T_Billing
            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 SET KLAIM = '0', KEKURANGAN = :valuea  WHERE ID = :id_fo1");
            $this->db->bind('id_fo1', $id_fo1);
            $this->db->bind('valuea', $valuea);

            $this->db->execute();

            //UPDATE TOTAL KE FO_T_BILLING
            $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_BILLING
            SET FB_VERIF_JURNAL = '0' where NO_TRS_BILLING = :notrs");
            $this->db->bind('notrs', $data['Notrs']);

            $this->db->execute();

            $this->db->commit();
            $callback = array(
                'message' => "success", // Set array nama 

            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function getDataHutangKabur($data)
    {
        try {
            // var_dump($data);
            // exit;
            $noreg = $data['noreg'];
            $nomr = $data['nomr'];

            // $query = "SELECT a.ID, NO_REGISTRASI,NO_TRS_BILLING, replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-') as TglBilling, NAMA_TARIF, QTY, NILAI_TARIF, DISC_RP, GRANDTOTAL  
            // FROM Billing_Pasien.dbo.FO_T_BILLING_1 a
            // inner join Billing_Pasien.dbo.CLOSING_BILL b on a.NO_REGISTRASI=b.NOREG_FIRST
            // WHERE  BATAL ='0' and NO_REGISTRASI = :noreg and a.ID_TRS_Payment is null";

            $query = "SELECT a.ID, a.NOREG_FIRST, replace(CONVERT(VARCHAR(11), c.TglKunjungan, 111), '/','-') as TglBilling, b.KEKURANGAN
            FROM Billing_Pasien.dbo.CLOSING_BILL a
            INNER JOIN Billing_Pasien.dbo.CLOSE_RO b ON b.NOREG = a.NOREG_FIRST
			INNER JOIN PerawatanSQL.dbo.Visit c ON c.NoRegistrasi = a.NOREG_FIRST COLLATE  SQL_Latin1_General_CP1_CI_AS
            WHERE a.NO_MR = :nomr AND a.JENIS_CLOSING IN ('PASIEN KABUR','PIUTANG RANAP') AND a.NOREG_FIRST <> :noreg AND a.NOREG_REFF = '' AND c.BATAL= '0'";

            $this->db->query($query);
            $this->db->bind('noreg', $noreg);
            $this->db->bind('nomr', $nomr);
            // $this->db->bind('noreg2', $noreg);
            // $this->db->bind('nomr', $nomr);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {

                $pasing['No'] = $no++;
                $pasing['NO_REGISTRASI'] = $key['NOREG_FIRST'];
                $pasing['TGL_BILLING'] = $key['TglBilling'];
                $pasing['KEKURANGAN'] = $key['KEKURANGAN'];
                $rows[] = $pasing;
            }

            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function transferBillPasienHutang($data)
    {
        try {
            $this->db->transaksi();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $datenowx = Utils::datenowcreateNotFull();

            $noreg = $data['noreg'];
            $nomr = $data['nomr'];

            $this->db->query("SELECT [Status ID] AS statuspasien FROM PerawatanSQL.dbo.visit WHERE NoRegistrasi = :norega1
            UNION ALL SELECT StatusID AS statuspasien FROM RawatInapSQL.dbo.Inpatient WHERE NoRegRI = :norega2");
            $this->db->bind('norega1', $data['noreg']);
            $this->db->bind('norega2', $data['noreg']);
            $statuscek =  $this->db->single();
            $statuspasien = $statuscek['statuspasien'];

            if ($statuspasien == '4') {
                $callback = array(
                    'status' => "error", // Set array nama
                    'message' => "Status Pasien Sudah Close"
                );
                return $callback;
                exit;
            }
            // var_dump('lose');
            // exit;

            //  UPDATE
            $this->db->query("UPDATE Billing_Pasien.dbo.CLOSING_BILL SET NOREG_REFF = :noreg 
            WHERE NO_MR = :nomr AND JENIS_CLOSING IN ('PASIEN KABUR', 'PIUTANG RANAP') AND NOREG_REFF = '' AND NOREG_FIRST <> :noreg1");
            $this->db->bind('noreg', $noreg);
            $this->db->bind('noreg1', $noreg);
            $this->db->bind('nomr', $nomr);
            $this->db->execute();

            $this->db->commit();
            $callback = array(
                'message' => "success", // Set array nama 

            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function getDataDetailRincianHutangx($data)
    {
        try {
            $noreg = $data['noreg'];
            $nomr = $data['nomr'];
            $this->db->query("SELECT a.ID, a.NO_TRS_BILLING, a.NO_REGISTRASI, replace(CONVERT(VARCHAR(11), a.TGL_BILLING, 111), '/','-') as TglBilling, a.NAMA_TARIF, a.QTY, a.NILAI_TARIF, a.DISC_RP, a.GRANDTOTAL  
            FROM Billing_Pasien.dbo.FO_T_BILLING_1 a
            LEFT JOIN Billing_Pasien.dbo.CLOSING_BILL b ON b.NOREG_FIRST = a.NO_REGISTRASI
            WHERE a.NO_MR = :nomr AND b.NOREG_REFF = :noreg AND a.BATAL = '0' AND a.ID_TRS_Payment IS NULL
            ");
            $this->db->bind('noreg', $noreg);
            $this->db->bind('nomr', $nomr);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['ID'] = $key['ID'];
                $pasing['NO_TRS_BILLING'] = $key['NO_TRS_BILLING'];
                $pasing['NO_REGISTRASI'] = $key['NO_REGISTRASI'];
                $pasing['TGL_BILLING'] = $key['TglBilling'];
                // $pasing['NAMA_TARIF'] = $key['NAMA_TARIF'];
                $pasing['QTY'] = $key['QTY'];
                $pasing['NILAI_TARIF'] = $key['NILAI_TARIF'];
                $pasing['DISC_RP'] = $key['DISC_RP'];
                $pasing['GRANDTOTAL'] = $key['GRANDTOTAL'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataDetailRincianHutang($data)
    {
        try {
            $noreg = $data['noreg'];
            $nomr = $data['nomr'];

            // $this->db->query("SELECT COUNT(*) AS CEK FROM Billing_Pasien.dbo.CLOSING_BILL WHERE NOREG_REFF = :noregistrasi");
            // $this->db->bind('noregistrasi', $noreg);
            // $statuscek =  $this->db->single();
            // $statushutang = $statuscek['CEK'];

            // if ($statushutang <> '0') {
            $this->db->query("SELECT a.*,b.NamaKelas,
                replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-') as TglBilling,c.NamaUnit
                FROM Billing_Pasien.dbo.FO_T_BILLING_1 a
                left join RawatInapSQL.dbo.TblKelas b on a.KD_KELAS=b.IDkelas
                inner join MasterdataSQL.dbo.MstrUnitPerwatan c on c.id = a.UNIT
                inner join Billing_Pasien.dbo.CLOSING_BILL d ON d.NOREG_FIRST = a.NO_REGISTRASI
                WHERE a.NO_MR = :nomr1 AND d.NOREG_REFF = :noreg1 AND a.BATAL = '0' AND a.ID_TRS_Payment IS NULL
    UNION ALL
    SELECT a.*,b.NamaKelas,
                replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-') as TglBilling,c.NamaUnit
                FROM Billing_Pasien.dbo.FO_T_BILLING_1 a
                left join RawatInapSQL.dbo.TblKelas b on a.KD_KELAS=b.IDkelas
                inner join MasterdataSQL.dbo.MstrUnitPerwatan c on c.id = a.UNIT
                inner join Billing_Pasien.dbo.CLOSING_BILL d ON d.NOREG_FIRST = a.NO_REGISTRASI
                inner join Billing_Pasien.dbo.FO_T_KASIR e ON e.NO_TRS = a.ID_TRS_Payment
                WHERE a.NO_MR = :nomr2 AND d.NOREG_REFF = :noreg2 AND a.BATAL = '0' AND e.NO_REGISTRASI = :noreg3");
            $this->db->bind('noreg1', $noreg);
            $this->db->bind('noreg2', $noreg);
            $this->db->bind('noreg3', $noreg);
            $this->db->bind('nomr1', $nomr);
            $this->db->bind('nomr2', $nomr);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['ID'] = $key['ID'];
                $pasing['NO_TRS_BILLING'] = $key['NO_TRS_BILLING'];
                $pasing['NO_REGISTRASI'] = $key['NO_REGISTRASI'];
                $pasing['TGL_BILLING'] = $key['TGL_BILLING'];
                $pasing['TglBilling'] = $key['TglBilling'];
                $pasing['NAMA_TARIF'] = $key['NAMA_TARIF'];
                $pasing['NamaUnit'] = $key['NamaUnit'];
                $pasing['NM_DR'] = $key['NM_DR'];
                $pasing['GROUP_TARIF'] = $key['GROUP_TARIF'];
                $pasing['KD_KELAS'] = $key['NamaKelas'];
                $pasing['QTY'] = $key['QTY'];
                // $pasing['NILAI_TARIF'] = number_format($key['NILAI_TARIF'],0,',','.');
                $pasing['NILAI_TARIF'] = $key['NILAI_TARIF'];
                $pasing['DISC_RP'] = $key['DISC_RP'];
                $pasing['GRANDTOTAL'] = $key['GRANDTOTAL'];
                $pasing['KLAIM'] = $key['KLAIM'];
                $pasing['KEKURANGAN'] = $key['KEKURANGAN'];
                $pasing['BAYAR'] = $key['BAYAR'];
                $rows[] = $pasing;
            }
            return $rows;
            // }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getCekHutangPasien($data)
    {
        try {
            $noreg = $data['noreg'];
            $nomr = $data['nomr'];
            $this->db->query("SELECT [Status ID] AS statuscek FROM PerawatanSQL.dbo.Visit WHERE NoRegistrasi = :noreg1a
            UNION ALL 
            SELECT StatusID AS statuscek FROM RawatInapSQL.dbo.Inpatient WHERE NoRegRI = :noreg1b
            ");
            $this->db->bind('noreg1a', $noreg);
            $this->db->bind('noreg1b', $noreg);
            $datax1a =  $this->db->single();
            $statuscek = $datax1a['statuscek'];
            $totalrow = '0';
            if ($statuscek <> '4') {
                $this->db->query("SELECT COUNT(*) AS totalrow
                FROM Billing_Pasien.dbo.CLOSING_BILL a
                INNER JOIN Billing_Pasien.dbo.CLOSE_RO b ON b.NOREG = a.NOREG_FIRST
                INNER JOIN Billing_Pasien.dbo.FO_T_BILLING_1 c ON c.NO_REGISTRASI = a.NOREG_FIRST
                WHERE a.NO_MR = :nomr AND a.JENIS_CLOSING IN ('PASIEN KABUR', 'PIUTANG RANAP') AND a.NOREG_FIRST <> :noreg AND a.NOREG_REFF = '' AND c.BATAL= '0' AND c.ID_TRS_Payment is null");
                $this->db->bind('noreg', $noreg);
                $this->db->bind('nomr', $nomr);
                $datax1 =  $this->db->single();
                $totalrow = $datax1['totalrow'];
            }
            return $totalrow;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataDetailRincianVoucher($data)
    {
        try {
            $noreg = $data['noreg'];


            $this->db->query("SELECT NO_TRANSAKSI, TGL_TRS, NOMINAL_BAYAR FROM Billing_Pasien.dbo.Voucher_Pengembalian1 where NO_REGISTRASI = :noreg1 AND BATAL = '0'");


            $this->db->bind('noreg1', $noreg);
            // $this->db->bind('noreg2', $noreg);
            // $this->db->bind('nomr', $nomr);

            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['NO_TRANSAKSI'] = $key['NO_TRANSAKSI'];
                $pasing['TGL_TRS'] = $key['TGL_TRS'];
                $pasing['NOMINAL_BAYAR'] = $key['NOMINAL_BAYAR'];
                $rows[] = $pasing;
            }
            return $rows;
            // var_dump($rows);
            // exit;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDataDetailRincianDeposit($data)
    {
        try {
            $noreg = $data['noreg'];
            // $nomr = $data['nomr'];

            // $this->db->query("SELECT a.ID, a.NO_TRANSAKSI, a.NO_TRANSAKSI_REFF, b.NO_REGISTRASI,  replace(CONVERT(VARCHAR(11), b.TGL_TRS, 111), '/','-') as TglTRS, a.NOMINAL_BAYAR, b.KETRANGAN, TIPE_PEMBAYARAN, NAMA_TIPE_PEMBAYARAN  FROM Billing_Pasien.dbo.FO_DEPOSIT_2 a
            // INNER JOIN Billing_Pasien.dbo.FO_DEPOSIT b ON a.NO_TRANSAKSI_REFF = b.NO_TRANSAKSI
            // WHERE b.NO_REGISTRASI  = :noreg1 AND b.BATAL = '0' AND a.BATAL = '0'
            // ");

            // $this->db->query("SELECT ID, NO_TRS_BILLING,NO_REGISTRASI, replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-') as TglBilling, NAMA_TARIF, QTY, NILAI_TARIF, DISC_RP, GRANDTOTAL, KEKURANGAN , KLAIM
            // from Billing_Pasien.dbo.FO_T_BILLING_1 
            // where BATAL='0' and NO_REGISTRASI='RJUM291123-0001'
            // ");

            $this->db->query("SELECT NO_TRANSAKSI, TGL_TRS, NOMINAL_BAYAR FROM Billing_Pasien.dbo.FO_DEPOSIT where NO_REGISTRASI = :noreg1 AND BATAL = '0'");


            $this->db->bind('noreg1', $noreg);
            // $this->db->bind('noreg2', $noreg);
            // $this->db->bind('nomr', $nomr);

            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['NO_TRANSAKSI'] = $key['NO_TRANSAKSI'];
                $pasing['TGL_TRS'] = $key['TGL_TRS'];
                $pasing['NOMINAL_BAYAR'] = $key['NOMINAL_BAYAR'];
                $rows[] = $pasing;



                // $pasing['No'] = $no++;
                // $pasing['ID'] = $key['ID'];
                // $pasing['NO_TRANSAKSI_REFF'] = $key['NO_TRANSAKSI_REFF'];
                // $pasing['NO_TRANSAKSI'] = $key['NO_TRANSAKSI'];
                // $pasing['NO_REGISTRASI'] = $key['NO_REGISTRASI'];

                // $pasing['TglTRS'] = $key['TglTRS'];
                // $pasing['NOMINAL_BAYAR'] = $key['NOMINAL_BAYAR'];
                // $pasing['KETRANGAN'] = $key['KETRANGAN'];
                // $pasing['TIPE_PEMBAYARAN'] = $key['TIPE_PEMBAYARAN'];
                // $pasing['NAMA_TIPE_PEMBAYARAN'] = $key['NAMA_TIPE_PEMBAYARAN'];
                // $rows[] = $pasing;
            }
            return $rows;
            // var_dump($rows);
            // exit;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDataDetailRincianVoucher2($data)
    {
        try {
            $notrshdr = $data['notrshdr'];

            $this->db->query("SELECT NO_TRANSAKSI, NAMA_TIPE_PEMBAYARAN, NOMINAL_BAYAR, TIPE_PEMBAYARAN, NO_KARTU_REFRENSI, EXPIRED_DATE, Kode_Tipe_Reff FROM Billing_Pasien.dbo.FO_DEPOSIT_2 WHERE NO_TRANSAKSI_REFF = :notrshdr AND BATAL = '0'");


            $this->db->bind('notrshdr', $notrshdr);
            // $this->db->bind('noreg2', $noreg);
            // $this->db->bind('nomr', $nomr);

            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['NO_TRANSAKSI'] = $key['NO_TRANSAKSI'];
                $pasing['NAMA_TIPE_PEMBAYARAN'] = $key['NAMA_TIPE_PEMBAYARAN'];
                $pasing['NOMINAL_BAYAR'] = $key['NOMINAL_BAYAR'];
                $pasing['TIPE_PEMBAYARAN'] = $key['TIPE_PEMBAYARAN'];
                $pasing['NO_KARTU_REFRENSI'] = $key['NO_KARTU_REFRENSI'];
                // $pasing['NO_KARTU_REFRENSI'] = $key['NO_KARTU_REFRENSI'];
                $pasing['EXPIRED_DATE'] = $key['EXPIRED_DATE'];
                $pasing['Kode_Tipe_Reff'] = $key['Kode_Tipe_Reff'];
                $rows[] = $pasing;
            }
            return $rows;
            // var_dump($rows);
            // exit;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataDetailRincianDeposit2($data)
    {
        try {
            $notrshdr = $data['notrshdr'];

            $this->db->query("SELECT NO_TRANSAKSI, NAMA_TIPE_PEMBAYARAN, NOMINAL_BAYAR, TIPE_PEMBAYARAN, NO_KARTU_REFRENSI, EXPIRED_DATE, Kode_Tipe_Reff FROM Billing_Pasien.dbo.FO_DEPOSIT_2 WHERE NO_TRANSAKSI_REFF = :notrshdr AND BATAL = '0'");


            $this->db->bind('notrshdr', $notrshdr);
            // $this->db->bind('noreg2', $noreg);
            // $this->db->bind('nomr', $nomr);

            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['NO_TRANSAKSI'] = $key['NO_TRANSAKSI'];
                $pasing['NAMA_TIPE_PEMBAYARAN'] = $key['NAMA_TIPE_PEMBAYARAN'];
                $pasing['NOMINAL_BAYAR'] = $key['NOMINAL_BAYAR'];
                $pasing['TIPE_PEMBAYARAN'] = $key['TIPE_PEMBAYARAN'];
                $pasing['NO_KARTU_REFRENSI'] = $key['NO_KARTU_REFRENSI'];
                // $pasing['NO_KARTU_REFRENSI'] = $key['NO_KARTU_REFRENSI'];
                $pasing['EXPIRED_DATE'] = $key['EXPIRED_DATE'];
                $pasing['Kode_Tipe_Reff'] = $key['Kode_Tipe_Reff'];
                $rows[] = $pasing;
            }
            return $rows;
            // var_dump($rows);
            // exit;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getgenerateIDTRSNew($data)
    {
        try {
            // var_dump($data);
            // exit;
            $this->db->transaksi();
            $NoMR = $data['NoMR'];
            $NoEpisode = $data['NoEpisode'];
            $NoRegistrasi = $data['NoRegistrasi'];
            // $TypePatientID = $data['TypePatientID'];

            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $namauserx = $session->name;
            $iduserx = $session->IDEmployee;

            $datenowlis = date('dmy', strtotime($datenowcreate));
            $this->db->query("SELECT  max(NO_TRANSAKSI) as nourut from Billing_Pasien.dbo.FO_DEPOSIT WHERE SUBSTRING(NO_TRANSAKSI, 4, 6)=:datenowlis ");
            $this->db->bind('datenowlis',   $datenowlis);
            $data =  $this->db->single();
            $nourut = $data['nourut'];
            $substringlis = substr($nourut, 9);
            if ($substringlis == null) {
                $substringlis = 0;
            }
            $substringlis++;
            if (strlen($substringlis) == 1) {
                $nourutfixLis = "00" . $substringlis;
            } else if (strlen($substringlis) == 2) {
                $nourutfixLis = "0" . $substringlis;
            } else if (strlen($substringlis) == 3) {
                $nourutfixLis = $substringlis;
            }

            $ID_TR_TARIF = 'TRD' . $datenowlis . $nourutfixLis;
            // var_dump($nourut);
            // var_dump($substringlis);
            // var_dump($datenowlis);
            // var_dump($substringlis);
            // var_dump($nourutfixLis);
            // var_dump($ID_TR_TARIF);
            // exit;
            //#END GENERATE NO TRD HDR

            $this->db->query("INSERT INTO Billing_Pasien.dbo.FO_DEPOSIT (
                [NO_TRANSAKSI]
               ,[NO_EPISODE]
                ,[NO_REGISTRASI]
                ,[NO_MR]
                ,[TGL_TRS]
               ,[USER_KASIR]
               ,[NOMINAL_BAYAR]
               ,[KETRANGAN]
               ,[BATAL]
               ,[TGL_BATAL]
               ,[USER_BATAL]
               ,[ALASAN_BATAL]
               ,[USER_LAST]
               ,[TGL_TRS_LAST]
                ) values (
                :NO_TRANSAKSI
                ,:NO_EPISODE
                ,:NO_REGISTRASI
                ,:NO_MR
                ,:TGL_TRS
                ,:USER_KASIR
                ,:NOMINAL_BAYAR
                ,:KETRANGAN
                ,:BATAL
                ,:TGL_BATAL
                ,:USER_BATAL
                ,:ALASAN_BATAL
                ,:USER_LAST
                ,:TGL_TRS_LAST
                )");
            $this->db->bind('NO_TRANSAKSI', $ID_TR_TARIF);
            $this->db->bind('NO_EPISODE', $NoEpisode);
            $this->db->bind('NO_REGISTRASI', $NoRegistrasi);
            $this->db->bind('NO_MR', $NoMR);
            $this->db->bind('TGL_TRS', $datenowcreate);
            $this->db->bind('USER_KASIR', $iduserx);
            // $this->db->bind('USER_KASIR', $namauserx);
            $this->db->bind('NOMINAL_BAYAR', 0);
            $this->db->bind('KETRANGAN', '');
            $this->db->bind('BATAL', '1');
            $this->db->bind('TGL_BATAL', '');
            $this->db->bind('USER_BATAL', '');
            $this->db->bind('ALASAN_BATAL', '');
            $this->db->bind('USER_LAST', $iduserx);
            $this->db->bind('TGL_TRS_LAST', $datenowcreate);
            $this->db->execute();


            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Simpan Berhasil',
                'paramsid' => $ID_TR_TARIF,
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function SaveTrsPayment_deposit($data)
    {
        try {
            $this->db->transaksi();
            $count_array = count($data['tipepembayaran']);
            $terimapembayaran = array_sum(str_replace(".", "", $data['totalinput']));
            $totalhargadumi = str_replace(".", "", $data['totalharga']);
            $yangharusdibayar = str_replace(".", "", $data['totalbayar']);

            $Grandtotalbayar = str_replace(".", "", $data['GrandTotalBayar']);

            $totalinput = str_replace(".", "", $data['totalinput']);
            $tipepembayaran = $data['tipepembayaran'];
            $tipepembayarandummi = $data['tipepembayaran'][0];


            $NoMR = $data['NoMR'];
            $NoEpisode = $data['NoEpisode'];
            $NoRegistrasi = $data['NoRegistrasi'];
            $tgl_payment = $data['tglpayment_closing'];
            $TypePatientID = $data['TypePatientID'];

            $bilito2 = $data['billto'][0];

            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $namauserx = $session->name;
            // $iduserx = $session->name;
            $iduserx = $session->IDEmployee;


            $totalinput = str_replace(".", "", $data['totalinput']);

            $tipepembayaran = $data['tipepembayaran'];

            $bilito1 = $data['billtox'];
            $kodejaminan = $data['kodejaminan'];
            $kd_rekening = $data['kd_rekening'];
            // $namabank = $data['namabank'];
            $expired = $data['expired'];
            $nokartu = $data['nokartu'];
            $bilito = $data['billto'];
            $ktrDeposit = $data['ktrDeposit'];

            $trsdeposithdr = $data['trsdeposit'];



            $this->db->query("SELECT [Status ID] AS statuspasien FROM PerawatanSQL.dbo.visit WHERE NoRegistrasi = :norega1a UNION ALL SELECT StatusID AS statuspasien FROM RawatInapSQL.dbo.Inpatient WHERE NoRegRI = :norega1b");
            $this->db->bind('norega1a', $data['NoRegistrasi']);
            $this->db->bind('norega1b', $data['NoRegistrasi']);
            $statuscek =  $this->db->single();
            $statuspasien = $statuscek['statuspasien'];

            if ($statuspasien == '4') {
                $callback = array(
                    'status' => "eror", // Set array nama
                    'message' => "Gagal Simpan, Status Pasien Sudah Close"
                );
                return $callback;
                exit;
            }

            //UPDATE DEPOSIT HDR
            $this->db->query("UPDATE Billing_Pasien.dbo.FO_DEPOSIT SET USER_KASIR = :USER_KASIR, TGL_TRS = :TGL_TRS, USER_LAST = :USER_LAST, TGL_TRS_LAST = :TGL_TRS_LAST, NOMINAL_BAYAR = :NOMINAL_BAYAR, KETRANGAN = :KETRANGAN, BATAL = '0' WHERE NO_TRANSAKSI = :NO_TRANSAKSI");
            $this->db->bind('NO_TRANSAKSI', $trsdeposithdr);
            $this->db->bind('TGL_TRS', $datenowcreate);
            $this->db->bind('USER_KASIR', $iduserx);
            // $this->db->bind('USER_KASIR', $namauserx);
            $this->db->bind('NOMINAL_BAYAR', $Grandtotalbayar);
            $this->db->bind('KETRANGAN', $ktrDeposit);
            $this->db->bind('USER_LAST', $iduserx);
            $this->db->bind('TGL_TRS_LAST', $datenowcreate);
            $this->db->execute();
            //END UPDATEtable DEPOSIT HDR

            // INSERT KASIR HDR
            $datenowlis = date('dmy', strtotime($datenowcreate));
            $this->db->query("SELECT  max(NO_TRS) as nourut from Billing_Pasien.dbo.FO_T_KASIR WHERE SUBSTRING(NO_TRS, 4, 6)=:datenowlis ");
            $this->db->bind('datenowlis', $datenowlis);
            $data =  $this->db->single();
            $nourut = $data['nourut'];
            $substringlis = substr($nourut, 9);
            if ($substringlis == null) {
                $substringlis = 0;
            }
            $substringlis++;
            if (strlen($substringlis) == 1) {
                $nourutfixLis = "00" . $substringlis;
            } else if (strlen($substringlis) == 2) {
                $nourutfixLis = "0" . $substringlis;
            } else if (strlen($substringlis) == 3) {
                $nourutfixLis = $substringlis;
            }

            $ID_TR_TARIF = 'TRS' . $datenowlis . $nourutfixLis;
            //#END GENERATE NO TRS HDR
            //GENERATE NO KWITANSI

            //untuk kode awal no NoKwitansi
            if ($TypePatientID == "1") {
                $kodeawal = "KUJ";
            } else {
                $kodeawal = "PRJ";
            }
            // $kodetengah = date('dmy');//untuk kode tengah no NoKwitansi
            $kodetengah = date('dmy', strtotime($tgl_payment));

            //cek no urut kwitansi

            //GET URUT
            $this->db->query("SELECT  TOP 1 NO_KWITANSI,right(NO_KWITANSI,4) as urutkwitansi
                 FROM Billing_Pasien.dbo.FO_T_KASIR
                 WHERE replace(CONVERT(VARCHAR(11), TGL_TRS, 111), '/','-')=:tgl_payment AND LEFT(NO_KWITANSI,3)=:kodeawal ORDER BY right(NO_KWITANSI,4) DESC");
            $this->db->bind('tgl_payment',   $tgl_payment);
            $this->db->bind('kodeawal',   $kodeawal);
            $data =  $this->db->single();
            $nourutkwitansi = $data['urutkwitansi'];

            if (empty($nourutkwitansi)) {
                //jika gk ada record
                $nourutkwitansi = "0001";
            } else {
                //jika ada record
                $nourutkwitansi++;
            }

            if (strlen($nourutkwitansi) == 1) {
                $nourutfixKwitansi = "000" . $nourutkwitansi;
            } else if (strlen($nourutkwitansi) == 2) {
                $nourutfixKwitansi = "00" . $nourutkwitansi;
            } else if (strlen($nourutkwitansi) == 3) {
                $nourutfixKwitansi = "0" . $nourutkwitansi;
            } else if (strlen($nourutkwitansi) == 4) {
                $nourutfixKwitansi = $nourutkwitansi;
            }

            $nofinalkwitansi = $kodeawal . '-' . $kodetengah . '-' . $nourutfixKwitansi;

            //#END GENERATE KWITANSI

            //INSERT TABEL PAYMENT HDR
            // Update FO_T_BILLING_1
            $this->db->query("INSERT INTO Billing_Pasien.dbo.FO_T_KASIR (
                     [NO_TRS]
                    ,[NO_KWITANSI]
                     ,[NO_EPISODE]
                     ,[NO_REGISTRASI]
                     ,[NO_MR]
                    ,[TGL_TRS]
                    ,[KODE_KASIR]
                    ,[USER_KASIR]
                    ,[NOMINAL_BAYAR]
                    ,[CASH]
                    ,[DEBIT]
                    ,[KREDIT]
                    ,[BATAL]
                    ,[TGL_BATAL]
                    ,[USER_BATAL]
                    ,[ALASAN_BATAL]
                    ,[USER_LAST]
                     ,[TGL_TRS_LAST]
                    ,[BILLTO]
                    ,[ID_TRSD_HDR]
                     ) values (
                     :NO_TRS
                     ,:NO_KWITANSI
                     ,:NO_EPISODE
                     ,:NO_REGISTRASI
                     ,:NO_MR
                     ,:TGL_TRS
                     ,:KODE_KASIR
                     ,:USER_KASIR
                     ,:NOMINAL_BAYAR
                     ,:CASH
                     ,:DEBIT
                     ,:KREDIT
                     ,:BATAL
                     ,:TGL_BATAL
                     ,:USER_BATAL
                     ,:ALASAN_BATAL
                     ,:USER_LAST
                     ,:TGL_TRS_LAST
                     ,:BILLTO
                     ,:ID_TRSD_HDR
                     )");
            $this->db->bind('NO_TRS', $ID_TR_TARIF);
            $this->db->bind('NO_KWITANSI', $nofinalkwitansi);
            $this->db->bind('NO_EPISODE', $NoEpisode);
            $this->db->bind('NO_REGISTRASI', $NoRegistrasi);
            $this->db->bind('NO_MR', $NoMR);
            $this->db->bind('TGL_TRS', $datenowcreate);
            $this->db->bind('KODE_KASIR', $iduserx);
            $this->db->bind('USER_KASIR', $namauserx);
            $this->db->bind('NOMINAL_BAYAR', $terimapembayaran);
            $this->db->bind('CASH', 0);
            $this->db->bind('DEBIT', 0);
            $this->db->bind('KREDIT', 0);
            $this->db->bind('BATAL', '0');
            $this->db->bind('TGL_BATAL', '');
            $this->db->bind('USER_BATAL', '');
            $this->db->bind('ALASAN_BATAL', '');
            $this->db->bind('USER_LAST', $iduserx);
            $this->db->bind('TGL_TRS_LAST', $datenowcreate);
            $this->db->bind('BILLTO', $bilito1);
            $this->db->bind('ID_TRSD_HDR', $trsdeposithdr);
            $this->db->execute();
            // END KASIR HDR

            // INSERT DEPO DETAILL DAN KASR DETAIL
            for ($i = 0; $i < $count_array; $i++) {

                //GENERATE NO TRS DTL DEPO
                //GET URUT
                $datenowlis = date('dmy', strtotime($datenowcreate));
                $this->db->query("SELECT max(NO_TRANSAKSI) as nourut from Billing_Pasien.dbo.FO_DEPOSIT_2 WHERE SUBSTRING(NO_TRANSAKSI, 5, 6)=:datenowlis");
                $this->db->bind('datenowlis',   $datenowlis);
                $data =  $this->db->single();
                $nourut = $data['nourut'];
                $substringlis = substr($nourut, 10);
                if ($substringlis == null) {
                    $substringlis = 0;
                }
                $substringlis++;
                if (strlen($substringlis) == 1) {
                    $nourutfixLis = "00" . $substringlis;
                } else if (strlen($substringlis) == 2) {
                    $nourutfixLis = "0" . $substringlis;
                } else if (strlen($substringlis) == 3) {
                    $nourutfixLis = $substringlis;
                }
                $ID_TRD_TARIF_DTL = 'TRDD' . $datenowlis . $nourutfixLis;

                $this->db->query("INSERT INTO Billing_Pasien.[dbo].[FO_DEPOSIT_2]
                    ([NO_TRANSAKSI], [NO_TRANSAKSI_REFF], [NOMINAL_BAYAR], [TIPE_PEMBAYARAN], [kode_Tipe_Reff] , [NAMA_TIPE_PEMBAYARAN], [NO_KARTU_REFRENSI], [EXPIRED_DATE])
                    VALUES (:NO_TRANSAKSI, :NO_TRANSAKSI_REFF, :NOMINAL_BAYAR, :TIPE_PEMBAYARAN, :kode_Tipe_Reff, :NAMA_TIPE_PEMBAYARAN, :NO_KARTU_REFRENSI, :EXPIRED_DATE)");
                $this->db->bind('NO_TRANSAKSI', $ID_TRD_TARIF_DTL);
                $this->db->bind('NO_TRANSAKSI_REFF', $trsdeposithdr);
                $this->db->bind('NOMINAL_BAYAR', $totalinput[$i]);
                $this->db->bind('TIPE_PEMBAYARAN', $tipepembayaran[$i]);
                $this->db->bind('kode_Tipe_Reff', $kodejaminan[$i]);
                // $this->db->bind('kode_Tipe_Reff', $kd_rekening[$i]);
                $this->db->bind('NAMA_TIPE_PEMBAYARAN', $bilito[$i]);
                $this->db->bind('NO_KARTU_REFRENSI', $nokartu[$i]);
                $this->db->bind('EXPIRED_DATE', $expired[$i]);
                $this->db->execute();

                //END GENERATE NO TRS DTL DEPO

                //GENERATE NO TRS DTL KASIR
                $datenowlis = date('dmy', strtotime($datenowcreate));
                $this->db->query("SELECT  max(NO_TRS) as nourut from Billing_Pasien.dbo.FO_T_KASIR_2 WHERE SUBSTRING(NO_TRS, 5, 6)=:datenowlis ");
                $this->db->bind('datenowlis',   $datenowlis);
                $data =  $this->db->single();
                $nourut = $data['nourut'];
                $substringlis = substr($nourut, 10);
                if ($substringlis == null) {
                    $substringlis = 0;
                }
                $substringlis++;
                if (strlen($substringlis) == 1) {
                    $nourutfixLis = "00" . $substringlis;
                } else if (strlen($substringlis) == 2) {
                    $nourutfixLis = "0" . $substringlis;
                } else if (strlen($substringlis) == 3) {
                    $nourutfixLis = $substringlis;
                }

                $ID_TR_TARIF_DTL = 'TRSD' . $datenowlis . $nourutfixLis;
                $this->db->query("INSERT INTO Billing_Pasien.[dbo].[FO_T_KASIR_2]
                    ([NO_TRS], [NO_TRS_REFF], [NOMINAL_BAYAR], [TIPE_PEMBAYARAN], [kode_Tipe_Reff] , [NAMA_TIPE_PEMBAYARAN], [NO_KARTU_REFRENSI], [EXPIRED_DATE], [ID_TRSD_DETAIL])
                    VALUES (:NO_TRS, :NO_TRS_REFF, :NOMINAL_BAYAR, :TIPE_PEMBAYARAN, :kode_Tipe_Reff, :NAMA_TIPE_PEMBAYARAN, :NO_KARTU_REFRENSI, :EXPIRED_DATE, :ID_TRSD_DETAIL)");
                $this->db->bind('NO_TRS', $ID_TR_TARIF_DTL);
                $this->db->bind('NO_TRS_REFF', $ID_TR_TARIF);
                $this->db->bind('NOMINAL_BAYAR', $totalinput[$i]);
                $this->db->bind('TIPE_PEMBAYARAN', $tipepembayaran[$i]);
                $this->db->bind('kode_Tipe_Reff', $kodejaminan[$i]);
                // $this->db->bind('kode_Tipe_Reff', $kd_rekening[$i]);
                $this->db->bind('NAMA_TIPE_PEMBAYARAN', $bilito[$i]);
                $this->db->bind('NO_KARTU_REFRENSI', $nokartu[$i]);
                $this->db->bind('EXPIRED_DATE', $expired[$i]);
                $this->db->bind('ID_TRSD_DETAIL', $ID_TRD_TARIF_DTL);
                $this->db->execute();

                //#END GENERATE NO TRS DTL KASIR
            }

            // END INSERT DEPO DETAILL DAN KASR DETAIL


            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Simpan Berhasil',
                // 'paramsid' => $ID_TR_TARIF,
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function UpdateTrsPayment_deposit($data)
    {
        try {

            // var_dump($data);
            // exit;
            // var NoRegistrasi = $("#NoRegistrasi").val();


            $this->db->transaksi();

            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $namauserx = $session->name;
            $iduserx = $session->IDEmployee;
            $NilaiBayar = str_replace(".", "", $data['NilaiBayar']);

            $tipepembayaran = $data['tipepembayaran'];
            $namabank = $data['namabank'];
            $nokartu = $data['nokartu'];
            $TglExpired = $data['TglExpired'];
            $kd_rekening = $data['kd_rekening'];
            $perusahaanjpk = $data['perusahaanjpk'];
            $perusahaanasuransi = $data['perusahaanasuransi'];
            $kodejaminan = $data['kodejaminan'];
            $newTRSdetail = $data['newTRSdetail'];
            $NamaKuitansi = $data['NamaKuitansi'];



            $this->db->query("SELECT [Status ID] AS statuspasien FROM PerawatanSQL.dbo.visit WHERE NoRegistrasi = :norega1a UNION ALL SELECT StatusID AS statuspasien FROM RawatInapSQL.dbo.Inpatient WHERE NoRegRI = :norega1b");
            $this->db->bind('norega1a', $data['NoRegistrasi']);
            $this->db->bind('norega1b', $data['NoRegistrasi']);
            $statuscek =  $this->db->single();
            $statuspasien = $statuscek['statuspasien'];

            if ($statuspasien == '4') {
                $callback = array(
                    'status' => "eror", // Set array nama
                    'message' => "Gagal Simpan, Status Pasien Sudah Close"
                );
                return $callback;
                exit;
            }


            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_KASIR_2 SET NOMINAL_BAYAR = :NilaiBayar , TIPE_PEMBAYARAN = :tipepembayaran, Kode_Tipe_Reff = :kodejaminan, NAMA_TIPE_PEMBAYARAN = :NamaKuitansi, NO_KARTU_REFRENSI = :nokartu, EXPIRED_DATE = :TglExpired 
            WHERE NO_TRS_REFF in (SELECT NO_TRANSAKSI_REFF FROM Billing_Pasien.dbo.FO_DEPOSIT_2 where NO_TRANSAKSI = :newTRSdetail1) AND TIPE_PEMBAYARAN IN (SELECT TIPE_PEMBAYARAN FROM Billing_Pasien.dbo.FO_DEPOSIT_2 where NO_TRANSAKSI = :newTRSdetail2)");
            $this->db->bind('newTRSdetail1', $newTRSdetail);
            $this->db->bind('newTRSdetail2', $newTRSdetail);
            $this->db->bind('NilaiBayar', $NilaiBayar);
            $this->db->bind('tipepembayaran', $tipepembayaran);
            $this->db->bind('kodejaminan', $kodejaminan);
            $this->db->bind('NamaKuitansi', $NamaKuitansi);
            $this->db->bind('nokartu', $nokartu);
            $this->db->bind('TglExpired', $TglExpired);
            $this->db->execute();
            // var_dump('tai');
            // exit;


            //Insert AND UPDATEtable deposit dan deposit_2
            $this->db->query("UPDATE Billing_Pasien.dbo.FO_DEPOSIT_2 SET NOMINAL_BAYAR = :NilaiBayar , TIPE_PEMBAYARAN = :tipepembayaran, Kode_Tipe_Reff = :kodejaminan, NAMA_TIPE_PEMBAYARAN = :NamaKuitansi, NO_KARTU_REFRENSI = :nokartu, EXPIRED_DATE = :TglExpired
            WHERE NO_TRANSAKSI = :newTRSdetail");
            $this->db->bind('newTRSdetail', $newTRSdetail);
            $this->db->bind('NilaiBayar', $NilaiBayar);
            $this->db->bind('tipepembayaran', $tipepembayaran);
            $this->db->bind('kodejaminan', $kodejaminan);
            $this->db->bind('NamaKuitansi', $NamaKuitansi);
            $this->db->bind('nokartu', $nokartu);
            $this->db->bind('TglExpired', $TglExpired);
            $this->db->execute();


            $this->db->query("UPDATE Billing_Pasien.DBO.FO_DEPOSIT SET NOMINAL_BAYAR = B.SUM_NOMINAL_BAYAR, USER_LAST = :iduserx, TGL_TRS_LAST = :datenowcreate
            FROM Billing_Pasien.DBO.FO_DEPOSIT A
            INNER JOIN 
            (
                SELECT NO_TRANSAKSI_REFF, SUM(NOMINAL_BAYAR) AS SUM_NOMINAL_BAYAR
                FROM Billing_Pasien.dbo.FO_DEPOSIT_2
                WHERE NO_TRANSAKSI_REFF  = (SELECT NO_TRANSAKSI_REFF FROM Billing_Pasien.DBO.FO_DEPOSIT_2 Where NO_TRANSAKSI=:newTRSdetail1) AND BATAL = '0'
                group by NO_TRANSAKSI_REFF
            ) B
            ON A.NO_TRANSAKSI = B.NO_TRANSAKSI_REFF
            WHERE NO_TRANSAKSI = (SELECT NO_TRANSAKSI_REFF FROM Billing_Pasien.DBO.FO_DEPOSIT_2 Where NO_TRANSAKSI=:newTRSdetail2)");
            $this->db->bind('newTRSdetail1', $newTRSdetail);
            $this->db->bind('newTRSdetail2', $newTRSdetail);
            $this->db->bind('iduserx', $iduserx);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->execute();


            $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_KASIR SET NOMINAL_BAYAR = B.SUM_NOMINAL_BAYAR, USER_LAST = :iduserx, TGL_TRS_LAST = :datenowcreate
            FROM Billing_Pasien.DBO.FO_DEPOSIT A
            INNER JOIN 
            (
                SELECT NO_TRANSAKSI_REFF, SUM(NOMINAL_BAYAR) AS SUM_NOMINAL_BAYAR
                FROM Billing_Pasien.dbo.FO_DEPOSIT_2
                WHERE NO_TRANSAKSI_REFF  IN (SELECT NO_TRANSAKSI_REFF FROM Billing_Pasien.DBO.FO_DEPOSIT_2 Where NO_TRANSAKSI=:newTRSdetail1) AND BATAL = '0'
                group by NO_TRANSAKSI_REFF
            ) B
            ON A.NO_TRANSAKSI = B.NO_TRANSAKSI_REFF
            WHERE NO_TRS IN (SELECT NO_TRANSAKSI_REFF FROM Billing_Pasien.DBO.FO_DEPOSIT_2 Where NO_TRANSAKSI=:newTRSdetail2)");
            $this->db->bind('newTRSdetail1', $newTRSdetail);
            $this->db->bind('newTRSdetail2', $newTRSdetail);
            $this->db->bind('iduserx', $iduserx);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->execute();




            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Simpan Berhasil',
                // 'paramsid' => $ID_TR_TARIF,
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function DeleteTrsPayment_deposit($data)
    {
        try {

            // var_dump($data);
            // exit;

            $this->db->transaksi();

            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $namauserx = $session->name;
            $iduserx = $session->IDEmployee;
            // $NilaiBayar = str_replace(".", "", $data['NilaiBayar']);

            // $tipepembayaran = $data['tipepembayaran'];
            // $namabank = $data['namabank'];
            // $nokartu = $data['nokartu'];
            // $TglExpired = $data['TglExpired'];
            // $kd_rekening = $data['kd_rekening'];
            // $perusahaanjpk = $data['perusahaanjpk'];
            // $perusahaanasuransi = $data['perusahaanasuransi'];
            // $kodejaminan = $data['kodejaminan'];
            $newTRSdetail = $data['newTRSdetail'];
            // $NamaKuitansi = $data['NamaKuitansi'];


            $this->db->query("SELECT [Status ID] AS statuspasien FROM PerawatanSQL.dbo.visit WHERE NoRegistrasi = :norega1 UNION ALL SELECT StatusID AS statuspasien FROM RawatInapSQL.dbo.Inpatient WHERE NoRegRI = :norega2");
            $this->db->bind('norega1', $data['NoRegistrasi']);
            $this->db->bind('norega2', $data['NoRegistrasi']);
            $statuscek =  $this->db->single();
            $statuspasien = $statuscek['statuspasien'];

            if ($statuspasien == '4') {
                $callback = array(
                    'status' => "eror", // Set array nama
                    'message' => "GAGAL DELETE, Karena Status Pasien Sudah Close"
                );
                return $callback;
                exit;
            }

            // var_dump($data);
            // exit;

            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_KASIR_2 SET BATAL = '1'
            WHERE ID_TRSD_DETAIL in (SELECT NO_TRANSAKSI FROM Billing_Pasien.dbo.FO_DEPOSIT_2 
            where NO_TRANSAKSI_REFF = :newTRSdetail1) AND TIPE_PEMBAYARAN IN 
            (SELECT TIPE_PEMBAYARAN FROM Billing_Pasien.dbo.FO_DEPOSIT_2 where NO_TRANSAKSI_REFF = :newTRSdetail2)
            ");
            $this->db->bind('newTRSdetail1', $newTRSdetail);
            $this->db->bind('newTRSdetail2', $newTRSdetail);
            $this->db->execute();

            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_KASIR SET BATAL = '1',USER_LAST = :iduserx, TGL_TRS_LAST = :datenowcreate WHERE ID_TRSD_HDR = :newTRSdetail1a");
            $this->db->bind('newTRSdetail1a', $newTRSdetail);
            $this->db->bind('iduserx', $iduserx);
            $this->db->bind('datenowcreate', $datenowcreate);
            // var_dump('tai');
            // exit;


            //Insert AND UPDATE table deposit dan deposit_2
            $this->db->query("UPDATE Billing_Pasien.dbo.FO_DEPOSIT_2 SET BATAL = '1'
            WHERE NO_TRANSAKSI_REFF = :newTRSdetail");
            $this->db->bind('newTRSdetail', $newTRSdetail);
            $this->db->execute();

            $this->db->query("UPDATE Billing_Pasien.dbo.FO_DEPOSIT SET BATAL = '1' ,USER_LAST = :iduserx, TGL_TRS_LAST = :datenowcreate where NO_TRANSAKSI = :newTRSdetail2");
            $this->db->bind('newTRSdetail2', $newTRSdetail);
            $this->db->bind('iduserx', $iduserx);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->execute();


            // $this->db->query("UPDATE Billing_Pasien.DBO.FO_DEPOSIT SET NOMINAL_BAYAR = B.SUM_NOMINAL_BAYAR, USER_LAST = :iduserx, TGL_TRS_LAST = :datenowcreate
            // FROM Billing_Pasien.DBO.FO_DEPOSIT A
            // INNER JOIN 
            // (
            //     SELECT NO_TRANSAKSI_REFF, SUM(NOMINAL_BAYAR) AS SUM_NOMINAL_BAYAR
            //     FROM Billing_Pasien.dbo.FO_DEPOSIT_2
            //     WHERE NO_TRANSAKSI_REFF  = (SELECT NO_TRANSAKSI_REFF FROM Billing_Pasien.DBO.FO_DEPOSIT_2 Where NO_TRANSAKSI=:newTRSdetail1) AND BATAL = '0'
            //     group by NO_TRANSAKSI_REFF
            // ) B
            // ON A.NO_TRANSAKSI = B.NO_TRANSAKSI_REFF
            // WHERE NO_TRANSAKSI = (SELECT NO_TRANSAKSI_REFF FROM Billing_Pasien.DBO.FO_DEPOSIT_2 Where NO_TRANSAKSI=:newTRSdetail2)");
            // $this->db->bind('newTRSdetail1', $newTRSdetail);
            // $this->db->bind('newTRSdetail2', $newTRSdetail);
            // $this->db->bind('iduserx', $iduserx);
            // $this->db->bind('datenowcreate', $datenowcreate);
            // $this->db->execute();


            // $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_KASIR SET NOMINAL_BAYAR = B.SUM_NOMINAL_BAYAR, USER_LAST = :iduserx, TGL_TRS_LAST = :datenowcreate
            // FROM Billing_Pasien.DBO.FO_DEPOSIT A
            // INNER JOIN 
            // (
            //     SELECT NO_TRANSAKSI_REFF, SUM(NOMINAL_BAYAR) AS SUM_NOMINAL_BAYAR
            //     FROM Billing_Pasien.dbo.FO_DEPOSIT_2
            //     WHERE NO_TRANSAKSI_REFF  IN (SELECT NO_TRANSAKSI_REFF FROM Billing_Pasien.DBO.FO_DEPOSIT_2 Where NO_TRANSAKSI=:newTRSdetail1) AND BATAL = '0'
            //     group by NO_TRANSAKSI_REFF
            // ) B
            // ON A.NO_TRANSAKSI = B.NO_TRANSAKSI_REFF
            // WHERE NO_TRS IN (SELECT NO_TRANSAKSI_REFF FROM Billing_Pasien.DBO.FO_DEPOSIT_2 Where NO_TRANSAKSI=:newTRSdetail2)");
            // $this->db->bind('newTRSdetail1', $newTRSdetail);
            // $this->db->bind('newTRSdetail2', $newTRSdetail);
            // $this->db->bind('iduserx', $iduserx);
            // $this->db->bind('datenowcreate', $datenowcreate);
            // $this->db->execute();


            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Simpan Berhasil',
                // 'paramsid' => $ID_TR_TARIF,
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function DeleteTrsPayment_depositdetial($data)
    {
        try {

            // var_dump($data);
            // exit;

            $this->db->transaksi();

            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $namauserx = $session->name;
            $iduserx = $session->IDEmployee;
            $newTRSdetail = $data['newTRSdetail'];
            $newTRShdr = $data['newTRShdr'];


            $this->db->query("UPDATE Billing_Pasien.dbo.FO_DEPOSIT_2 SET BATAL = '1' WHERE NO_TRANSAKSI = :newTRSdetail");
            $this->db->bind('newTRSdetail', $newTRSdetail);
            $this->db->execute();

            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_KASIR_2 SET BATAL = '1' WHERE ID_TRSD_DETAIL = :newTRSdetail");
            $this->db->bind('newTRSdetail', $newTRSdetail);
            $this->db->execute();

            $this->db->query("SELECT COUNT(ID) AS CEK FROM Billing_Pasien.dbo.FO_DEPOSIT_2 WHERE NO_TRANSAKSI_REFF = :newTRShdr AND BATAL = '0'");
            $this->db->bind('newTRShdr',   $newTRShdr);
            $data =  $this->db->single();
            $cek = $data['CEK'];

            if ($cek == '0') {
                $this->db->query("UPDATE Billing_Pasien.DBO.FO_DEPOSIT SET BATAL = '1', TGL_BATAL = :datenowcreate2, NOMINAL_BAYAR = '0', USER_LAST = :iduserx, TGL_TRS_LAST = :datenowcreate
                WHERE NO_TRANSAKSI = :newTRShdr");
                $this->db->bind('newTRShdr', $newTRShdr);
                $this->db->bind('iduserx', $iduserx);
                $this->db->bind('datenowcreate', $datenowcreate);
                $this->db->bind('datenowcreate2', $datenowcreate);
                $this->db->execute();

                $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_KASIR SET BATAL = '1', TGL_BATAL = :datenowcreate2, NOMINAL_BAYAR = '0', USER_LAST = :iduserx, TGL_TRS_LAST = :datenowcreate
                WHERE ID_TRSD_HDR = :newTRShdr");
                $this->db->bind('newTRShdr', $newTRShdr);
                $this->db->bind('iduserx', $iduserx);
                $this->db->bind('datenowcreate', $datenowcreate);
                $this->db->bind('datenowcreate2', $datenowcreate);
                $this->db->execute();
            } else {
                $this->db->query("UPDATE Billing_Pasien.DBO.FO_DEPOSIT SET NOMINAL_BAYAR = B.SUM_NOMINAL_BAYAR, USER_LAST = :iduserx, TGL_TRS_LAST = :datenowcreate
                FROM Billing_Pasien.DBO.FO_DEPOSIT A
                INNER JOIN 
                (
                    SELECT NO_TRANSAKSI_REFF, SUM(NOMINAL_BAYAR) AS SUM_NOMINAL_BAYAR
                    FROM Billing_Pasien.dbo.FO_DEPOSIT_2
                    WHERE NO_TRANSAKSI_REFF  = :newTRShdr AND BATAL = '0'
                    group by NO_TRANSAKSI_REFF
                ) B
                ON A.NO_TRANSAKSI = B.NO_TRANSAKSI_REFF
                WHERE NO_TRANSAKSI = (SELECT NO_TRANSAKSI_REFF FROM Billing_Pasien.DBO.FO_DEPOSIT_2 Where NO_TRANSAKSI=:newTRSdetail)");
                $this->db->bind('newTRSdetail', $newTRSdetail);
                $this->db->bind('newTRShdr', $newTRShdr);
                $this->db->bind('iduserx', $iduserx);
                $this->db->bind('datenowcreate', $datenowcreate);
                $this->db->execute();


                $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_KASIR SET NOMINAL_BAYAR = B.SUM_NOMINAL_BAYAR, USER_LAST = :iduserx, TGL_TRS_LAST = :datenowcreate
                FROM Billing_Pasien.DBO.FO_T_KASIR A
                INNER JOIN 
                (
                    SELECT NO_TRS_REFF, SUM(NOMINAL_BAYAR) AS SUM_NOMINAL_BAYAR
                    FROM Billing_Pasien.dbo.FO_T_KASIR_2
                    WHERE NO_TRS_REFF  IN (SELECT NO_TRS_REFF FROM Billing_Pasien.DBO.FO_T_KASIR_2 Where ID_TRSD_DETAIL=:newTRSdetail) AND BATAL = '0'
                    group by NO_TRS_REFF
                ) B
                ON A.NO_TRS = B.NO_TRS_REFF
                WHERE ID_TRSD_HDR = :newTRShdr");
                $this->db->bind('newTRSdetail', $newTRSdetail);
                $this->db->bind('newTRShdr', $newTRShdr);
                $this->db->bind('iduserx', $iduserx);
                $this->db->bind('datenowcreate', $datenowcreate);
                $this->db->execute();
            }

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Simpan Berhasil',
                // 'paramsid' => $ID_TR_TARIF,
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function updatedetailDataDepo2Detail($data)
    {
        try {
            // var_dump($data);
            // exit;

            $this->db->transaksi();

            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $namauserx = $session->name;
            $iduserx = $session->IDEmployee;

            $hidden_no_trs_ = $data['hidden_no_trs_'];
            $hidden_nama_diterima_ = $data['hidden_nama_diterima_'];
            $hidden_nama_nominal_ = $data['hidden_nama_nominal_'];
            $hidden_jenis_pembayaran_ = $data['hidden_jenis_pembayaran_'];

            $hidden_kartu_no_ = $data['hidden_kartu_no_'];
            $hidden_xpired_kartu_ = $data['hidden_xpired_kartu_'];


            $newTRShdr = $data['newTRShdr'];
            $count_array = $data['rowdata'];


            $this->db->query("SELECT [Status ID] AS statuspasien FROM PerawatanSQL.dbo.visit WHERE NoRegistrasi = :norega1 UNION ALL SELECT StatusID AS statuspasien FROM RawatInapSQL.dbo.Inpatient WHERE NoRegRI = :norega2");
            $this->db->bind('norega1', $data['noreg']);
            $this->db->bind('norega2', $data['noreg']);
            $statuscek =  $this->db->single();
            $statuspasien = $statuscek['statuspasien'];

            if ($statuspasien == '4') {
                $callback = array(
                    'status' => "eror", // Set array nama
                    'message' => "Gagal Update, Status Pasien Sudah Close"
                );
                return $callback;
                exit;
            }


            for ($i = 0; $i < $count_array; $i++) {

                //UPDATE DEPOSIT 2
                $this->db->query("UPDATE Billing_Pasien.dbo.FO_DEPOSIT_2 SET NOMINAL_BAYAR = :hidden_nama_nominal_, NAMA_TIPE_PEMBAYARAN = :hidden_nama_diterima_, NO_KARTU_REFRENSI = :hidden_kartu_no_, EXPIRED_DATE= :hidden_xpired_kartu_ WHERE NO_TRANSAKSI = :hidden_no_trs_");
                $this->db->bind('hidden_no_trs_', $hidden_no_trs_[$i]);
                $this->db->bind('hidden_nama_nominal_', $hidden_nama_nominal_[$i]);
                $this->db->bind('hidden_nama_diterima_', $hidden_nama_diterima_[$i]);
                $this->db->bind('hidden_kartu_no_', $hidden_kartu_no_[$i]);
                $this->db->bind('hidden_xpired_kartu_', $hidden_xpired_kartu_[$i]);
                $this->db->execute();
                // END UPDATE DEPOSIT 2

                //UPDATE KASIR 2
                $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_KASIR_2 SET NOMINAL_BAYAR = :hidden_nama_nominal_, NAMA_TIPE_PEMBAYARAN = :hidden_nama_diterima_, NO_KARTU_REFRENSI = :hidden_kartu_no_, EXPIRED_DATE= :hidden_xpired_kartu_ WHERE ID_TRSD_DETAIL = :hidden_no_trs_");
                $this->db->bind('hidden_no_trs_', $hidden_no_trs_[$i]);
                $this->db->bind('hidden_nama_nominal_', $hidden_nama_nominal_[$i]);
                $this->db->bind('hidden_nama_diterima_', $hidden_nama_diterima_[$i]);
                $this->db->bind('hidden_kartu_no_', $hidden_kartu_no_[$i]);
                $this->db->bind('hidden_xpired_kartu_', $hidden_xpired_kartu_[$i]);
                $this->db->execute();
                // END UPDATE KASIR 2

            }
            // UPDATE DEPO HDR
            $this->db->query("UPDATE Billing_Pasien.DBO.FO_DEPOSIT SET NOMINAL_BAYAR = B.SUM_NOMINAL_BAYAR, USER_LAST = :iduserx, TGL_TRS_LAST = :datenowcreate
                FROM Billing_Pasien.DBO.FO_DEPOSIT A
                INNER JOIN 
                (
                    SELECT NO_TRANSAKSI_REFF, SUM(NOMINAL_BAYAR) AS SUM_NOMINAL_BAYAR
                    FROM Billing_Pasien.dbo.FO_DEPOSIT_2
                    WHERE NO_TRANSAKSI_REFF  = :newTRShdr AND BATAL = '0'
                    group by NO_TRANSAKSI_REFF
                ) B
                ON A.NO_TRANSAKSI = B.NO_TRANSAKSI_REFF
                WHERE NO_TRANSAKSI = :newTRShdr2");
            $this->db->bind('newTRShdr', $newTRShdr);
            $this->db->bind('newTRShdr2', $newTRShdr);
            $this->db->bind('iduserx', $iduserx);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->execute();
            // END UPDATE DEPO HDR

            // UPDATE KASIR HDR
            $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_KASIR SET NOMINAL_BAYAR = B.SUM_NOMINAL_BAYAR, USER_LAST = :iduserx, TGL_TRS_LAST = :datenowcreate
                FROM Billing_Pasien.DBO.FO_T_KASIR A
                INNER JOIN 
                (
                    SELECT NO_TRS_REFF, SUM(NOMINAL_BAYAR) AS SUM_NOMINAL_BAYAR
                    FROM Billing_Pasien.dbo.FO_T_KASIR_2
                    WHERE NO_TRS_REFF  IN (SELECT NO_TRS FROM Billing_Pasien.DBO.FO_T_KASIR Where ID_TRSD_HDR=:newTRShdr2) AND BATAL = '0'
                    group by NO_TRS_REFF
                ) B
                ON A.NO_TRS = B.NO_TRS_REFF
                WHERE ID_TRSD_HDR = :newTRShdr");
            $this->db->bind('newTRShdr', $newTRShdr);
            $this->db->bind('newTRShdr2', $newTRShdr);
            $this->db->bind('iduserx', $iduserx);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->execute();
            // END UPDATE KASIR HDR

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Simpan Berhasil',
                // 'paramsid' => $ID_TR_TARIF,
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function DeleteTrsPayment_Pengembaliandetial($data)
    {
        try {

            // var_dump($data);
            // exit;

            $this->db->transaksi();

            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $namauserx = $session->name;
            $iduserx = $session->IDEmployee;
            $newTRSdetail = $data['newTRSdetail'];
            $newTRShdr = $data['newTRShdr'];


            $this->db->query("UPDATE Billing_Pasien.dbo.FO_DEPOSIT_2 SET BATAL = '1' WHERE NO_TRANSAKSI = :newTRSdetail");
            $this->db->bind('newTRSdetail', $newTRSdetail);
            $this->db->execute();

            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_KASIR_2 SET BATAL = '1' WHERE ID_TRSD_DETAIL = :newTRSdetail");
            $this->db->bind('newTRSdetail', $newTRSdetail);
            $this->db->execute();

            $this->db->query("SELECT COUNT(ID) AS CEK FROM Billing_Pasien.dbo.FO_DEPOSIT_2 WHERE NO_TRANSAKSI_REFF = :newTRShdr AND BATAL = '0'");
            $this->db->bind('newTRShdr',   $newTRShdr);
            $data =  $this->db->single();
            $cek = $data['CEK'];

            if ($cek == '0') {
                $this->db->query("UPDATE Billing_Pasien.DBO.Voucher_Pengembalian1 SET BATAL = '1', TGL_BATAL = :datenowcreate2, NOMINAL_BAYAR = '0', USER_LAST = :iduserx, TGL_TRS_LAST = :datenowcreate
                WHERE NO_TRANSAKSI = :newTRShdr");
                $this->db->bind('newTRShdr', $newTRShdr);
                $this->db->bind('iduserx', $iduserx);
                $this->db->bind('datenowcreate', $datenowcreate);
                $this->db->bind('datenowcreate2', $datenowcreate);
                $this->db->execute();

                $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_KASIR SET BATAL = '1', TGL_BATAL = :datenowcreate2, NOMINAL_BAYAR = '0', USER_LAST = :iduserx, TGL_TRS_LAST = :datenowcreate
                WHERE ID_TRSD_HDR = :newTRShdr");
                $this->db->bind('newTRShdr', $newTRShdr);
                $this->db->bind('iduserx', $iduserx);
                $this->db->bind('datenowcreate', $datenowcreate);
                $this->db->bind('datenowcreate2', $datenowcreate);
                $this->db->execute();
            } else {
                $this->db->query("UPDATE Billing_Pasien.DBO.Voucher_Pengembalian1 SET NOMINAL_BAYAR = B.SUM_NOMINAL_BAYAR, USER_LAST = :iduserx, TGL_TRS_LAST = :datenowcreate
                FROM Billing_Pasien.DBO.Voucher_Pengembalian1 A
                INNER JOIN 
                (
                    SELECT NO_TRANSAKSI_REFF, SUM(NOMINAL_BAYAR) AS SUM_NOMINAL_BAYAR
                    FROM Billing_Pasien.dbo.FO_DEPOSIT_2
                    WHERE NO_TRANSAKSI_REFF  = :newTRShdr AND BATAL = '0'
                    group by NO_TRANSAKSI_REFF
                ) B
                ON A.NO_TRANSAKSI = B.NO_TRANSAKSI_REFF
                WHERE NO_TRANSAKSI = (SELECT NO_TRANSAKSI_REFF FROM Billing_Pasien.DBO.FO_DEPOSIT_2 Where NO_TRANSAKSI=:newTRSdetail)");
                $this->db->bind('newTRSdetail', $newTRSdetail);
                $this->db->bind('newTRShdr', $newTRShdr);
                $this->db->bind('iduserx', $iduserx);
                $this->db->bind('datenowcreate', $datenowcreate);
                $this->db->execute();


                $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_KASIR SET NOMINAL_BAYAR = B.SUM_NOMINAL_BAYAR, USER_LAST = :iduserx, TGL_TRS_LAST = :datenowcreate
                FROM Billing_Pasien.DBO.FO_T_KASIR A
                INNER JOIN 
                (
                    SELECT NO_TRS_REFF, SUM(NOMINAL_BAYAR) AS SUM_NOMINAL_BAYAR
                    FROM Billing_Pasien.dbo.FO_T_KASIR_2
                    WHERE NO_TRS_REFF  IN (SELECT NO_TRS_REFF FROM Billing_Pasien.DBO.FO_T_KASIR_2 Where ID_TRSD_DETAIL=:newTRSdetail) AND BATAL = '0'
                    group by NO_TRS_REFF
                ) B
                ON A.NO_TRS = B.NO_TRS_REFF
                WHERE ID_TRSD_HDR = :newTRShdr");
                $this->db->bind('newTRSdetail', $newTRSdetail);
                $this->db->bind('newTRShdr', $newTRShdr);
                $this->db->bind('iduserx', $iduserx);
                $this->db->bind('datenowcreate', $datenowcreate);
                $this->db->execute();
            }

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Simpan Berhasil',
                // 'paramsid' => $ID_TR_TARIF,
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function updatedetailDataPengembalian2Detail($data)
    {
        try {
            // var_dump($data);
            // exit;

            $this->db->transaksi();

            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $namauserx = $session->name;
            $iduserx = $session->IDEmployee;

            $hidden_no_trs_ = $data['hidden_no_trs_'];
            $hidden_nama_diterima_ = $data['hidden_nama_diterima_'];
            $hidden_nama_nominal_ = $data['hidden_nama_nominal_'];
            $hidden_jenis_pembayaran_ = $data['hidden_jenis_pembayaran_'];

            $hidden_kartu_no_ = $data['hidden_kartu_no_'];
            $hidden_xpired_kartu_ = $data['hidden_xpired_kartu_'];


            $newTRShdr = $data['newTRShdr'];
            $count_array = $data['rowdata'];

            for ($i = 0; $i < $count_array; $i++) {

                //UPDATE DEPOSIT 2
                $this->db->query("UPDATE Billing_Pasien.dbo.FO_DEPOSIT_2 SET NOMINAL_BAYAR = :hidden_nama_nominal_, NAMA_TIPE_PEMBAYARAN = :hidden_nama_diterima_, NO_KARTU_REFRENSI = :hidden_kartu_no_, EXPIRED_DATE= :hidden_xpired_kartu_ WHERE NO_TRANSAKSI = :hidden_no_trs_");
                $this->db->bind('hidden_no_trs_', $hidden_no_trs_[$i]);
                $this->db->bind('hidden_nama_nominal_', $hidden_nama_nominal_[$i]);
                $this->db->bind('hidden_nama_diterima_', $hidden_nama_diterima_[$i]);
                $this->db->bind('hidden_kartu_no_', $hidden_kartu_no_[$i]);
                $this->db->bind('hidden_xpired_kartu_', $hidden_xpired_kartu_[$i]);
                $this->db->execute();
                // END UPDATE DEPOSIT 2

                //UPDATE KASIR 2
                $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_KASIR_2 SET NOMINAL_BAYAR = :hidden_nama_nominal_, NAMA_TIPE_PEMBAYARAN = :hidden_nama_diterima_, NO_KARTU_REFRENSI = :hidden_kartu_no_, EXPIRED_DATE= :hidden_xpired_kartu_ WHERE ID_TRSD_DETAIL = :hidden_no_trs_");
                $this->db->bind('hidden_no_trs_', $hidden_no_trs_[$i]);
                $this->db->bind('hidden_nama_nominal_', $hidden_nama_nominal_[$i]);
                $this->db->bind('hidden_nama_diterima_', $hidden_nama_diterima_[$i]);
                $this->db->bind('hidden_kartu_no_', $hidden_kartu_no_[$i]);
                $this->db->bind('hidden_xpired_kartu_', $hidden_xpired_kartu_[$i]);
                $this->db->execute();
                // END UPDATE KASIR 2

            }
            // UPDATE DEPO HDR
            $this->db->query("UPDATE Billing_Pasien.DBO.Voucher_Pengembalian1 SET NOMINAL_BAYAR = B.SUM_NOMINAL_BAYAR, USER_LAST = :iduserx, TGL_TRS_LAST = :datenowcreate
                FROM Billing_Pasien.DBO.Voucher_Pengembalian1 A
                INNER JOIN 
                (
                    SELECT NO_TRANSAKSI_REFF, SUM(NOMINAL_BAYAR) AS SUM_NOMINAL_BAYAR
                    FROM Billing_Pasien.dbo.FO_DEPOSIT_2
                    WHERE NO_TRANSAKSI_REFF  = :newTRShdr AND BATAL = '0'
                    group by NO_TRANSAKSI_REFF
                ) B
                ON A.NO_TRANSAKSI = B.NO_TRANSAKSI_REFF
                WHERE NO_TRANSAKSI = :newTRShdr2");
            $this->db->bind('newTRShdr', $newTRShdr);
            $this->db->bind('newTRShdr2', $newTRShdr);
            $this->db->bind('iduserx', $iduserx);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->execute();
            // END UPDATE DEPO HDR

            // UPDATE KASIR HDR
            $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_KASIR SET NOMINAL_BAYAR = B.SUM_NOMINAL_BAYAR, USER_LAST = :iduserx, TGL_TRS_LAST = :datenowcreate
                FROM Billing_Pasien.DBO.FO_T_KASIR A
                INNER JOIN 
                (
                    SELECT NO_TRS_REFF, SUM(NOMINAL_BAYAR) AS SUM_NOMINAL_BAYAR
                    FROM Billing_Pasien.dbo.FO_T_KASIR_2
                    WHERE NO_TRS_REFF  IN (SELECT NO_TRS FROM Billing_Pasien.DBO.FO_T_KASIR Where ID_TRSD_HDR=:newTRShdr2) AND BATAL = '0'
                    group by NO_TRS_REFF
                ) B
                ON A.NO_TRS = B.NO_TRS_REFF
                WHERE ID_TRSD_HDR = :newTRShdr");
            $this->db->bind('newTRShdr', $newTRShdr);
            $this->db->bind('newTRShdr2', $newTRShdr);
            $this->db->bind('iduserx', $iduserx);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->execute();
            // END UPDATE KASIR HDR

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Simpan Berhasil',
                // 'paramsid' => $ID_TR_TARIF,
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function getgenerateIDTRSNewVoucher($data)
    {
        try {
            // var_dump($data);
            // exit;
            $this->db->transaksi();
            $NoMR = $data['NoMR'];
            $NoEpisode = $data['NoEpisode'];
            $NoRegistrasi = $data['NoRegistrasi'];
            // $TypePatientID = $data['TypePatientID'];

            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $namauserx = $session->name;
            $iduserx = $session->IDEmployee;

            $datenowlis = date('dmy', strtotime($datenowcreate));
            $this->db->query("SELECT  max(NO_TRANSAKSI) as nourut from Billing_Pasien.dbo.Voucher_Pengembalian1 WHERE SUBSTRING(NO_TRANSAKSI, 4, 6)=:datenowlis ");
            $this->db->bind('datenowlis',   $datenowlis);
            $data =  $this->db->single();
            $nourut = $data['nourut'];
            $substringlis = substr($nourut, 9);
            if ($substringlis == null) {
                $substringlis = 0;
            }
            $substringlis++;
            if (strlen($substringlis) == 1) {
                $nourutfixLis = "00" . $substringlis;
            } else if (strlen($substringlis) == 2) {
                $nourutfixLis = "0" . $substringlis;
            } else if (strlen($substringlis) == 3) {
                $nourutfixLis = $substringlis;
            }

            $ID_TR_TARIF = 'TRR' . $datenowlis . $nourutfixLis;
            //#END GENERATE NO TRS HDR

            $this->db->query("INSERT INTO Billing_Pasien.dbo.Voucher_Pengembalian1 (
                [NO_TRANSAKSI]
               ,[NO_EPISODE]
                ,[NO_REGISTRASI]
                ,[NO_MR]
                ,[TGL_TRS]
               ,[USER_KASIR]
               ,[NOMINAL_BAYAR]
               ,[KETRANGAN]
               ,[BATAL]
               ,[TGL_BATAL]
               ,[USER_BATAL]
               ,[ALASAN_BATAL]
               ,[USER_LAST]
               ,[TGL_TRS_LAST]
                ) values (
                :NO_TRANSAKSI
                ,:NO_EPISODE
                ,:NO_REGISTRASI
                ,:NO_MR
                ,:TGL_TRS
                ,:USER_KASIR
                ,:NOMINAL_BAYAR
                ,:KETRANGAN
                ,:BATAL
                ,:TGL_BATAL
                ,:USER_BATAL
                ,:ALASAN_BATAL
                ,:USER_LAST
                ,:TGL_TRS_LAST
                )");
            $this->db->bind('NO_TRANSAKSI', $ID_TR_TARIF);
            $this->db->bind('NO_EPISODE', $NoEpisode);
            $this->db->bind('NO_REGISTRASI', $NoRegistrasi);
            $this->db->bind('NO_MR', $NoMR);
            $this->db->bind('TGL_TRS', $datenowcreate);
            $this->db->bind('USER_KASIR', $iduserx);
            // $this->db->bind('USER_KASIR', $namauserx);
            $this->db->bind('NOMINAL_BAYAR', 0);
            $this->db->bind('KETRANGAN', '');
            $this->db->bind('BATAL', '0');
            $this->db->bind('TGL_BATAL', '');
            $this->db->bind('USER_BATAL', '');
            $this->db->bind('ALASAN_BATAL', '');
            $this->db->bind('USER_LAST', $iduserx);
            $this->db->bind('TGL_TRS_LAST', $datenowcreate);
            $this->db->execute();


            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Simpan Berhasil',
                'paramsid' => $ID_TR_TARIF,
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function SaveTrsPayment_Pengembalian($data)
    {
        try {
            // var_dump($data);
            // exit;

            $this->db->transaksi();
            $count_array = count($data['tipepembayaran']);
            $terimapembayaran = array_sum(str_replace(".", "", $data['totalinput']));
            $totalhargadumi = str_replace(".", "", $data['totalharga']);
            $yangharusdibayar = str_replace(".", "", $data['totalbayar']);

            $Grandtotalbayar = str_replace(".", "", $data['GrandTotalBayar']);

            $totalinput = str_replace(".", "", $data['totalinput']);
            $tipepembayaran = $data['tipepembayaran'];
            $tipepembayarandummi = $data['tipepembayaran'][0];


            $NoMR = $data['NoMR'];
            $NoEpisode = $data['NoEpisode'];
            $NoRegistrasi = $data['NoRegistrasi'];
            $tgl_payment = $data['tglpayment_closing'];
            $TypePatientID = $data['TypePatientID'];

            $bilito2 = $data['billto'][0];

            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $namauserx = $session->name;
            // $iduserx = $session->name;
            $iduserx = $session->IDEmployee;


            $totalinput = str_replace(".", "", $data['totalinput']);

            $tipepembayaran = $data['tipepembayaran'];

            $bilito1 = $data['billtox'];
            $kodejaminan = $data['kodejaminan'];
            $kd_rekening = $data['kd_rekening'];
            // $namabank = $data['namabank'];
            $expired = $data['expired'];
            $nokartu = $data['nokartu'];
            $bilito = $data['billto'];

            $trsdeposithdr = $data['trsdeposit'];
            $ket = $data['ket'];

            //alim
            $this->db->query("SELECT COUNT(*) AS NO_TRANSAKSI
  FROM Billing_Pasien.dbo.Voucher_Pengembalian1 where BATAL='0' AND NO_REGISTRASI=:NoRegistrasi");
            $this->db->bind('NoRegistrasi', $NoRegistrasi);
            // $this->db->bind('notrsfo312', $notrsfo);
            $datavoucher =  $this->db->single();
            $NO_TRANSAKSI = $datavoucher['NO_TRANSAKSI'];

            if ($NO_TRANSAKSI != "1") {
                $callback = array(
                    'status' => 'eror',
                    'message' => 'Gagal Transaksi, Karena Sudah Ada Transaksi Voucher Yang Masih Aktif !',
                );
                return $callback;
                exit;
            }
            //alim

            //Insert AND UPDATEtable deposit dan deposit_2
            $this->db->query("UPDATE Billing_Pasien.dbo.Voucher_Pengembalian1 SET USER_KASIR = :USER_KASIR, TGL_TRS = :TGL_TRS, USER_LAST = :USER_LAST, TGL_TRS_LAST = :TGL_TRS_LAST, NOMINAL_BAYAR = :NOMINAL_BAYAR, KETRANGAN = :KETRANGAN WHERE NO_TRANSAKSI = :NO_TRANSAKSI");
            $this->db->bind('NO_TRANSAKSI', $trsdeposithdr);
            $this->db->bind('TGL_TRS', $datenowcreate);
            $this->db->bind('USER_KASIR', $iduserx);
            // $this->db->bind('USER_KASIR', $namauserx);
            $this->db->bind('NOMINAL_BAYAR', $Grandtotalbayar);
            $this->db->bind('KETRANGAN', $ket);
            $this->db->bind('USER_LAST', $iduserx);
            $this->db->bind('TGL_TRS_LAST', $datenowcreate);
            $this->db->execute();

            for ($i = 0; $i < $count_array; $i++) {

                //GENERATE NO TRS DTL
                //GET URUT
                $datenowlis = date('dmy', strtotime($datenowcreate));
                $this->db->query("SELECT max(NO_TRANSAKSI) as nourut from Billing_Pasien.dbo.FO_DEPOSIT_2 WHERE SUBSTRING(NO_TRANSAKSI, 5, 6)=:datenowlis");
                $this->db->bind('datenowlis',   $datenowlis);
                $data =  $this->db->single();
                $nourut = $data['nourut'];
                $substringlis = substr($nourut, 10);
                if ($substringlis == null) {
                    $substringlis = 0;
                }
                $substringlis++;
                if (strlen($substringlis) == 1) {
                    $nourutfixLis = "00" . $substringlis;
                } else if (strlen($substringlis) == 2) {
                    $nourutfixLis = "0" . $substringlis;
                } else if (strlen($substringlis) == 3) {
                    $nourutfixLis = $substringlis;
                }

                $ID_TRS_TARIF_DTL = 'TRSR' . $datenowlis . $nourutfixLis;
                //#END GENERATE NO TRS DTL

                $this->db->query("INSERT INTO Billing_Pasien.[dbo].[FO_DEPOSIT_2]
                    ([NO_TRANSAKSI], [NO_TRANSAKSI_REFF], [NOMINAL_BAYAR], [TIPE_PEMBAYARAN], [kode_Tipe_Reff] , [NAMA_TIPE_PEMBAYARAN], [NO_KARTU_REFRENSI], [EXPIRED_DATE])
                    VALUES (:NO_TRANSAKSI, :NO_TRANSAKSI_REFF, :NOMINAL_BAYAR, :TIPE_PEMBAYARAN, :kode_Tipe_Reff, :NAMA_TIPE_PEMBAYARAN, :NO_KARTU_REFRENSI, :EXPIRED_DATE)");
                $this->db->bind('NO_TRANSAKSI', $ID_TRS_TARIF_DTL);
                $this->db->bind('NO_TRANSAKSI_REFF', $trsdeposithdr);
                $this->db->bind('NOMINAL_BAYAR', $totalinput[$i]);
                $this->db->bind('TIPE_PEMBAYARAN', $tipepembayaran[$i]);
                $this->db->bind('kode_Tipe_Reff', $kodejaminan[$i]);
                // $this->db->bind('kode_Tipe_Reff', $kd_rekening[$i]);
                $this->db->bind('NAMA_TIPE_PEMBAYARAN', $bilito[$i]);
                $this->db->bind('NO_KARTU_REFRENSI', $nokartu[$i]);
                $this->db->bind('EXPIRED_DATE', $expired[$i]);
                $this->db->execute();
            }
            // END Insert AND UPDATEtable deposit dan deposit_2

            //INSERT UPDATE KASIR DAN KASIR_2
            $datenowlis = date('dmy', strtotime($datenowcreate));
            $this->db->query("SELECT  max(NO_TRS) as nourut from Billing_Pasien.dbo.FO_T_KASIR WHERE SUBSTRING(NO_TRS, 4, 6)=:datenowlis ");
            $this->db->bind('datenowlis', $datenowlis);
            $data =  $this->db->single();
            $nourut = $data['nourut'];
            $substringlis = substr($nourut, 9);
            if ($substringlis == null) {
                $substringlis = 0;
            }
            $substringlis++;
            if (strlen($substringlis) == 1) {
                $nourutfixLis = "00" . $substringlis;
            } else if (strlen($substringlis) == 2) {
                $nourutfixLis = "0" . $substringlis;
            } else if (strlen($substringlis) == 3) {
                $nourutfixLis = $substringlis;
            }

            $ID_TR_TARIF = 'TRS' . $datenowlis . $nourutfixLis;
            //#END GENERATE NO TRS HDR
            //GENERATE NO KWITANSI

            //untuk kode awal no NoKwitansi
            if ($TypePatientID == "1") {
                $kodeawal = "KUJ";
            } else {
                $kodeawal = "PRJ";
            }
            // $kodetengah = date('dmy');//untuk kode tengah no NoKwitansi
            $kodetengah = date('dmy', strtotime($tgl_payment));

            //cek no urut kwitansi

            //GET URUT
            $this->db->query("SELECT  TOP 1 NO_KWITANSI,right(NO_KWITANSI,4) as urutkwitansi
                FROM Billing_Pasien.dbo.FO_T_KASIR
                WHERE replace(CONVERT(VARCHAR(11), TGL_TRS, 111), '/','-')=:tgl_payment AND LEFT(NO_KWITANSI,3)=:kodeawal ORDER BY right(NO_KWITANSI,4) DESC");
            $this->db->bind('tgl_payment',   $tgl_payment);
            $this->db->bind('kodeawal',   $kodeawal);
            $data =  $this->db->single();
            $nourutkwitansi = $data['urutkwitansi'];

            if (empty($nourutkwitansi)) {
                //jika gk ada record
                $nourutkwitansi = "0001";
            } else {
                //jika ada record
                $nourutkwitansi++;
            }

            if (strlen($nourutkwitansi) == 1) {
                $nourutfixKwitansi = "000" . $nourutkwitansi;
            } else if (strlen($nourutkwitansi) == 2) {
                $nourutfixKwitansi = "00" . $nourutkwitansi;
            } else if (strlen($nourutkwitansi) == 3) {
                $nourutfixKwitansi = "0" . $nourutkwitansi;
            } else if (strlen($nourutkwitansi) == 4) {
                $nourutfixKwitansi = $nourutkwitansi;
            }

            $nofinalkwitansi = $kodeawal . '-' . $kodetengah . '-' . $nourutfixKwitansi;

            //#END GENERATE KWITANSI

            //INSERT TABEL PAYMENT HDR
            // Update FO_T_BILLING_1
            $this->db->query("INSERT INTO Billing_Pasien.dbo.FO_T_KASIR (
                    [NO_TRS]
                   ,[NO_KWITANSI]
                    ,[NO_EPISODE]
                    ,[NO_REGISTRASI]
                    ,[NO_MR]
                   ,[TGL_TRS]
                   ,[KODE_KASIR]
                   ,[USER_KASIR]
                   ,[NOMINAL_BAYAR]
                   ,[CASH]
                   ,[DEBIT]
                   ,[KREDIT]
                   ,[BATAL]
                   ,[TGL_BATAL]
                   ,[USER_BATAL]
                   ,[ALASAN_BATAL]
                   ,[USER_LAST]
                    ,[TGL_TRS_LAST]
                   ,[BILLTO]
                   ,[ID_TRSD_HDR]
                    ) values (
                    :NO_TRS
                    ,:NO_KWITANSI
                    ,:NO_EPISODE
                    ,:NO_REGISTRASI
                    ,:NO_MR
                    ,:TGL_TRS
                    ,:KODE_KASIR
                    ,:USER_KASIR
                    ,:NOMINAL_BAYAR
                    ,:CASH
                    ,:DEBIT
                    ,:KREDIT
                    ,:BATAL
                    ,:TGL_BATAL
                    ,:USER_BATAL
                    ,:ALASAN_BATAL
                    ,:USER_LAST
                    ,:TGL_TRS_LAST
                    ,:BILLTO
                    ,:ID_TRSD_HDR)");
            $this->db->bind('NO_TRS', $ID_TR_TARIF);
            $this->db->bind('NO_KWITANSI', $nofinalkwitansi);
            $this->db->bind('NO_EPISODE', $NoEpisode);
            $this->db->bind('NO_REGISTRASI', $NoRegistrasi);
            $this->db->bind('NO_MR', $NoMR);
            $this->db->bind('TGL_TRS', $datenowcreate);
            $this->db->bind('KODE_KASIR', $iduserx);
            $this->db->bind('USER_KASIR', $namauserx);
            $this->db->bind('NOMINAL_BAYAR', $terimapembayaran);
            $this->db->bind('CASH', 0);
            $this->db->bind('DEBIT', 0);
            $this->db->bind('KREDIT', 0);
            $this->db->bind('BATAL', '0');
            $this->db->bind('TGL_BATAL', '');
            $this->db->bind('USER_BATAL', '');
            $this->db->bind('ALASAN_BATAL', '');
            $this->db->bind('USER_LAST', $iduserx);
            $this->db->bind('TGL_TRS_LAST', $datenowcreate);
            $this->db->bind('BILLTO', $bilito1);
            $this->db->bind('ID_TRSD_HDR', $trsdeposithdr);

            $this->db->execute();


            //INSERT TABEL PAYMENT DTL
            for ($i = 0; $i < $count_array; $i++) {

                //GENERATE NO TRS DTL
                //GET URUT
                $datenowlis = date('dmy', strtotime($datenowcreate));
                $this->db->query("SELECT  max(NO_TRS) as nourut from Billing_Pasien.dbo.FO_T_KASIR_2 WHERE SUBSTRING(NO_TRS, 5, 6)=:datenowlis ");
                $this->db->bind('datenowlis',   $datenowlis);
                $data =  $this->db->single();
                $nourut = $data['nourut'];
                $substringlis = substr($nourut, 10);
                if ($substringlis == null) {
                    $substringlis = 0;
                }
                $substringlis++;
                if (strlen($substringlis) == 1) {
                    $nourutfixLis = "00" . $substringlis;
                } else if (strlen($substringlis) == 2) {
                    $nourutfixLis = "0" . $substringlis;
                } else if (strlen($substringlis) == 3) {
                    $nourutfixLis = $substringlis;
                }

                $ID_TR_TARIF_DTL = 'TRSR' . $datenowlis . $nourutfixLis;
                //#END GENERATE NO TRS DTL

                $this->db->query("INSERT INTO Billing_Pasien.[dbo].[FO_T_KASIR_2]
                    ([NO_TRS], [NO_TRS_REFF], [NOMINAL_BAYAR], [TIPE_PEMBAYARAN], [kode_Tipe_Reff] , [NAMA_TIPE_PEMBAYARAN], [NO_KARTU_REFRENSI], [EXPIRED_DATE])
                    VALUES (:NO_TRS, :NO_TRS_REFF, :NOMINAL_BAYAR, :TIPE_PEMBAYARAN, :kode_Tipe_Reff, :NAMA_TIPE_PEMBAYARAN, :NO_KARTU_REFRENSI, :EXPIRED_DATE)");
                $this->db->bind('NO_TRS', $ID_TR_TARIF_DTL);
                $this->db->bind('NO_TRS_REFF', $ID_TR_TARIF);
                $this->db->bind('NOMINAL_BAYAR', $totalinput[$i]);
                $this->db->bind('TIPE_PEMBAYARAN', $tipepembayaran[$i]);
                $this->db->bind('kode_Tipe_Reff', $kodejaminan[$i]);
                // $this->db->bind('kode_Tipe_Reff', $kd_rekening[$i]);
                $this->db->bind('NAMA_TIPE_PEMBAYARAN', $bilito[$i]);
                $this->db->bind('NO_KARTU_REFRENSI', $nokartu[$i]);
                $this->db->bind('EXPIRED_DATE', $expired[$i]);
                $this->db->execute();
            }
            //END INSER KASIR DAN KASIR_2

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Simpan Berhasil',
                // 'paramsid' => $ID_TR_TARIF,
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function UpdateTrsPayment_pengembalian($data)
    {
        try {

            // var_dump($data);
            // exit;

            $this->db->transaksi();

            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $namauserx = $session->name;
            $iduserx = $session->IDEmployee;
            $NilaiBayar = str_replace(".", "", $data['NilaiBayar']);

            $tipepembayaran = $data['tipepembayaran'];
            $namabank = $data['namabank'];
            $nokartu = $data['nokartu'];
            $TglExpired = $data['TglExpired'];
            $kd_rekening = $data['kd_rekening'];
            $perusahaanjpk = $data['perusahaanjpk'];
            $perusahaanasuransi = $data['perusahaanasuransi'];
            $kodejaminan = $data['kodejaminan'];
            $newTRSdetail = $data['newTRSdetail'];

            $NamaKuitansi = $data['NamaKuitansi'];


            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_KASIR_2 SET NOMINAL_BAYAR = :NilaiBayar , TIPE_PEMBAYARAN = :tipepembayaran, Kode_Tipe_Reff = :kodejaminan, NAMA_TIPE_PEMBAYARAN = :NamaKuitansi, NO_KARTU_REFRENSI = :nokartu, EXPIRED_DATE = :TglExpired 
            WHERE NO_TRS_REFF in (SELECT NO_TRANSAKSI_REFF FROM Billing_Pasien.dbo.FO_DEPOSIT_2 where NO_TRANSAKSI = :newTRSdetail1) AND TIPE_PEMBAYARAN IN (SELECT TIPE_PEMBAYARAN FROM Billing_Pasien.dbo.FO_DEPOSIT_2 where NO_TRANSAKSI = :newTRSdetail2)");
            $this->db->bind('newTRSdetail1', $newTRSdetail);
            $this->db->bind('newTRSdetail2', $newTRSdetail);
            $this->db->bind('NilaiBayar', $NilaiBayar);
            $this->db->bind('tipepembayaran', $tipepembayaran);
            $this->db->bind('kodejaminan', $kodejaminan);
            $this->db->bind('NamaKuitansi', $NamaKuitansi);
            $this->db->bind('nokartu', $nokartu);
            $this->db->bind('TglExpired', $TglExpired);
            $this->db->execute();

            //Insert AND UPDATEtable deposit dan deposit_2
            $this->db->query("UPDATE Billing_Pasien.dbo.FO_DEPOSIT_2 SET NOMINAL_BAYAR = :NilaiBayar , TIPE_PEMBAYARAN = :tipepembayaran, Kode_Tipe_Reff = :kodejaminan, NAMA_TIPE_PEMBAYARAN = :NamaKuitansi, NO_KARTU_REFRENSI = :nokartu, EXPIRED_DATE = :TglExpired
            WHERE NO_TRANSAKSI = :newTRSdetail");
            $this->db->bind('newTRSdetail', $newTRSdetail);
            $this->db->bind('NilaiBayar', $NilaiBayar);
            $this->db->bind('tipepembayaran', $tipepembayaran);
            $this->db->bind('kodejaminan', $kodejaminan);
            $this->db->bind('NamaKuitansi', $NamaKuitansi);
            $this->db->bind('nokartu', $nokartu);
            $this->db->bind('TglExpired', $TglExpired);
            $this->db->execute();


            $this->db->query("UPDATE Billing_Pasien.DBO.Voucher_Pengembalian1 SET NOMINAL_BAYAR = B.SUM_NOMINAL_BAYAR, USER_LAST = :iduserx, TGL_TRS_LAST = :datenowcreate
            FROM Billing_Pasien.DBO.Voucher_Pengembalian1 A
            INNER JOIN 
            (
                SELECT NO_TRANSAKSI_REFF, SUM(NOMINAL_BAYAR) AS SUM_NOMINAL_BAYAR
                FROM Billing_Pasien.dbo.FO_DEPOSIT_2
                WHERE NO_TRANSAKSI_REFF  = (SELECT NO_TRANSAKSI_REFF FROM Billing_Pasien.DBO.FO_DEPOSIT_2 Where NO_TRANSAKSI=:newTRSdetail1) AND BATAL = '0'
                group by NO_TRANSAKSI_REFF
            ) B
            ON A.NO_TRANSAKSI = B.NO_TRANSAKSI_REFF
            WHERE NO_TRANSAKSI = (SELECT NO_TRANSAKSI_REFF FROM Billing_Pasien.DBO.FO_DEPOSIT_2 Where NO_TRANSAKSI=:newTRSdetail2)");
            $this->db->bind('newTRSdetail1', $newTRSdetail);
            $this->db->bind('newTRSdetail2', $newTRSdetail);
            $this->db->bind('iduserx', $iduserx);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->execute();



            $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_KASIR SET NOMINAL_BAYAR = B.SUM_NOMINAL_BAYAR, USER_LAST = :iduserx, TGL_TRS_LAST = :datenowcreate
            FROM Billing_Pasien.DBO.Voucher_Pengembalian1 A
            INNER JOIN 
            (
                SELECT NO_TRANSAKSI_REFF, SUM(NOMINAL_BAYAR) AS SUM_NOMINAL_BAYAR
                FROM Billing_Pasien.dbo.FO_DEPOSIT_2
                WHERE NO_TRANSAKSI_REFF  IN (SELECT NO_TRANSAKSI_REFF FROM Billing_Pasien.DBO.FO_DEPOSIT_2 Where NO_TRANSAKSI=:newTRSdetail1) AND BATAL = '0'
                group by NO_TRANSAKSI_REFF
            ) B
            ON A.NO_TRANSAKSI = B.NO_TRANSAKSI_REFF
            WHERE NO_TRS IN (SELECT NO_TRANSAKSI_REFF FROM Billing_Pasien.DBO.FO_DEPOSIT_2 Where NO_TRANSAKSI=:newTRSdetail2)");
            $this->db->bind('newTRSdetail1', $newTRSdetail);
            $this->db->bind('newTRSdetail2', $newTRSdetail);
            $this->db->bind('iduserx', $iduserx);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->execute();

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Simpan Berhasil',
                // 'paramsid' => $ID_TR_TARIF,
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function DeleteTrsPayment_pengembalian($data)
    {
        try {

            // var_dump($data);
            // exit;

            $this->db->transaksi();

            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $namauserx = $session->name;
            $iduserx = $session->IDEmployee;
            // $NilaiBayar = str_replace(".", "", $data['NilaiBayar']);

            // $tipepembayaran = $data['tipepembayaran'];
            // $namabank = $data['namabank'];
            // $nokartu = $data['nokartu'];
            // $TglExpired = $data['TglExpired'];
            // $kd_rekening = $data['kd_rekening'];
            // $perusahaanjpk = $data['perusahaanjpk'];
            // $perusahaanasuransi = $data['perusahaanasuransi'];
            // $kodejaminan = $data['kodejaminan'];
            $newTRSdetail = $data['newTRSdetail'];
            // $NamaKuitansi = $data['NamaKuitansi'];


            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_KASIR_2 SET BATAL = '1'
            WHERE NO_TRS_REFF in (SELECT NO_TRANSAKSI_REFF FROM Billing_Pasien.dbo.FO_DEPOSIT_2 where NO_TRANSAKSI = :newTRSdetail1) AND TIPE_PEMBAYARAN IN (SELECT TIPE_PEMBAYARAN FROM Billing_Pasien.dbo.FO_DEPOSIT_2 where NO_TRANSAKSI = :newTRSdetail2)");
            $this->db->bind('newTRSdetail1', $newTRSdetail);
            $this->db->bind('newTRSdetail2', $newTRSdetail);
            $this->db->execute();
            // var_dump('tai');
            // exit;


            //Insert AND UPDATEtable deposit dan deposit_2
            $this->db->query("UPDATE Billing_Pasien.dbo.FO_DEPOSIT_2 SET BATAL = '1'
            WHERE NO_TRANSAKSI = :newTRSdetail");
            $this->db->bind('newTRSdetail', $newTRSdetail);
            $this->db->execute();


            $this->db->query("UPDATE Billing_Pasien.DBO.Voucher_Pengembalian1 SET NOMINAL_BAYAR = B.SUM_NOMINAL_BAYAR, USER_LAST = :iduserx, TGL_TRS_LAST = :datenowcreate
            FROM Billing_Pasien.DBO.Voucher_Pengembalian1 A
            INNER JOIN 
            (
                SELECT NO_TRANSAKSI_REFF, SUM(NOMINAL_BAYAR) AS SUM_NOMINAL_BAYAR
                FROM Billing_Pasien.dbo.FO_DEPOSIT_2
                WHERE NO_TRANSAKSI_REFF  = (SELECT NO_TRANSAKSI_REFF FROM Billing_Pasien.DBO.FO_DEPOSIT_2 Where NO_TRANSAKSI=:newTRSdetail1) AND BATAL = '0'
                group by NO_TRANSAKSI_REFF
            ) B
            ON A.NO_TRANSAKSI = B.NO_TRANSAKSI_REFF
            WHERE NO_TRANSAKSI = (SELECT NO_TRANSAKSI_REFF FROM Billing_Pasien.DBO.FO_DEPOSIT_2 Where NO_TRANSAKSI=:newTRSdetail2)");
            $this->db->bind('newTRSdetail1', $newTRSdetail);
            $this->db->bind('newTRSdetail2', $newTRSdetail);
            $this->db->bind('iduserx', $iduserx);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->execute();


            $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_KASIR SET NOMINAL_BAYAR = B.SUM_NOMINAL_BAYAR, USER_LAST = :iduserx, TGL_TRS_LAST = :datenowcreate
            FROM Billing_Pasien.DBO.Voucher_Pengembalian1 A
            INNER JOIN 
            (
                SELECT NO_TRANSAKSI_REFF, SUM(NOMINAL_BAYAR) AS SUM_NOMINAL_BAYAR
                FROM Billing_Pasien.dbo.FO_DEPOSIT_2
                WHERE NO_TRANSAKSI_REFF  IN (SELECT NO_TRANSAKSI_REFF FROM Billing_Pasien.DBO.FO_DEPOSIT_2 Where NO_TRANSAKSI=:newTRSdetail1) AND BATAL = '0'
                group by NO_TRANSAKSI_REFF
            ) B
            ON A.NO_TRANSAKSI = B.NO_TRANSAKSI_REFF
            WHERE NO_TRS IN (SELECT NO_TRANSAKSI_REFF FROM Billing_Pasien.DBO.FO_DEPOSIT_2 Where NO_TRANSAKSI=:newTRSdetail2)");
            $this->db->bind('newTRSdetail1', $newTRSdetail);
            $this->db->bind('newTRSdetail2', $newTRSdetail);
            $this->db->bind('iduserx', $iduserx);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->execute();




            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Simpan Berhasil',
                // 'paramsid' => $ID_TR_TARIF,
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function getDataDetailRincianpengembalian($data)
    {
        try {
            $noreg = $data['noreg'];
            // $nomr = $data['nomr'];

            $this->db->query("SELECT a.ID, a.NO_TRANSAKSI, a.NO_TRANSAKSI_REFF, b.NO_REGISTRASI,  replace(CONVERT(VARCHAR(11), b.TGL_TRS, 111), '/','-') as TglTRS, a.NOMINAL_BAYAR, b.KETRANGAN, TIPE_PEMBAYARAN, NAMA_TIPE_PEMBAYARAN  FROM Billing_Pasien.dbo.FO_DEPOSIT_2 a
            INNER JOIN Billing_Pasien.dbo.Voucher_Pengembalian1 b ON a.NO_TRANSAKSI_REFF = b.NO_TRANSAKSI
            WHERE b.NO_REGISTRASI  = :noreg1 AND b.BATAL = '0' AND a.BATAL = '0'
            ");

            // $this->db->query("SELECT ID, NO_TRS_BILLING,NO_REGISTRASI, replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-') as TglBilling, NAMA_TARIF, QTY, NILAI_TARIF, DISC_RP, GRANDTOTAL, KEKURANGAN , KLAIM
            // from Billing_Pasien.dbo.FO_T_BILLING_1 
            // where BATAL='0' and NO_REGISTRASI='RJUM291123-0001'
            // ");



            $this->db->bind('noreg1', $noreg);
            // $this->db->bind('noreg2', $noreg);
            // $this->db->bind('nomr', $nomr);

            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                // $pasing['No'] = $no++;
                // $pasing['ID'] = $key['ID'];
                // $pasing['NO_TRANSAKSI_REFF'] = $key['NO_TRS_BILLING'];
                // $pasing['NO_REGISTRASI'] = $key['NO_REGISTRASI'];

                // $pasing['TglTRS'] = $key['TglBilling'];
                // $pasing['NOMINAL_BAYAR'] = $key['NILAI_TARIF'];
                // $pasing['KETRANGAN'] = $key['NAMA_TARIF'];
                // $pasing['TIPE_PEMBAYARAN'] = $key['NAMA_TARIF'];
                // $pasing['NAMA_TIPE_PEMBAYARAN'] = $key['NAMA_TARIF'];
                // $rows[] = $pasing;



                $pasing['No'] = $no++;
                $pasing['ID'] = $key['ID'];
                $pasing['NO_TRANSAKSI_REFF'] = $key['NO_TRANSAKSI_REFF'];
                $pasing['NO_TRANSAKSI'] = $key['NO_TRANSAKSI'];
                $pasing['NO_REGISTRASI'] = $key['NO_REGISTRASI'];

                $pasing['TglTRS'] = $key['TglTRS'];
                $pasing['NOMINAL_BAYAR'] = $key['NOMINAL_BAYAR'];
                $pasing['KETRANGAN'] = $key['KETRANGAN'];
                $pasing['TIPE_PEMBAYARAN'] = $key['TIPE_PEMBAYARAN'];
                $pasing['NAMA_TIPE_PEMBAYARAN'] = $key['NAMA_TIPE_PEMBAYARAN'];
                $rows[] = $pasing;
            }
            return $rows;
            // var_dump($rows);
            // exit;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getTotalPembayaran($data)
    {
        try {
            $noreg = $data['noreg'];
            $getreg = substr($noreg, 0, 2);

            // HUTANG SUDAH LUNAS
            $pasing['TOTALHUTANG'] = '0,00';
            $this->db->query("SELECT count(GRANDTOTAL) AS nocekhutang1
            FROM Billing_Pasien.dbo.FO_T_BILLING_1 a
            left join RawatInapSQL.dbo.TblKelas b on a.KD_KELAS=b.IDkelas
            inner join MasterdataSQL.dbo.MstrUnitPerwatan c on c.id = a.UNIT
            inner join Billing_Pasien.dbo.CLOSING_BILL d ON d.NOREG_FIRST = a.NO_REGISTRASI
            inner join Billing_Pasien.dbo.FO_T_KASIR e ON e.NO_TRS = a.ID_TRS_Payment
            WHERE d.NOREG_REFF = :noreg1a AND a.BATAL = '0' AND e.NO_REGISTRASI = :noreg1b");
            $this->db->bind('noreg1a', $noreg);
            $this->db->bind('noreg1b', $noreg);
            $datahutang =  $this->db->single();
            $nocekhutang1 = $datahutang['nocekhutang1'];

            $pasing['TOTALHUTANGLUNAS'] = '0,00';

            if ($nocekhutang1 <> '0') {
                $this->db->query("SELECT a.NO_MR ,SUM(GRANDTOTAL) AS TOTALHUTANG
                FROM Billing_Pasien.dbo.FO_T_BILLING_1 a
                left join RawatInapSQL.dbo.TblKelas b on a.KD_KELAS=b.IDkelas
                inner join MasterdataSQL.dbo.MstrUnitPerwatan c on c.id = a.UNIT
                inner join Billing_Pasien.dbo.CLOSING_BILL d ON d.NOREG_FIRST = a.NO_REGISTRASI
                inner join Billing_Pasien.dbo.FO_T_KASIR e ON e.NO_TRS = a.ID_TRS_Payment
                WHERE d.NOREG_REFF = :noreg1c AND a.BATAL = '0' AND e.NO_REGISTRASI = :noreg1d GROUP BY a.NO_MR");
                $this->db->bind('noreg1c', $noreg);
                $this->db->bind('noreg1d', $noreg);
                $key =  $this->db->single();
                $pasing['TOTALHUTANG'] = $key['TOTALHUTANG'];
                $pasing['TOTALHUTANGLUNAS'] = $key['TOTALHUTANG'];
            }

            // HUTANG BELUM LUNAS
            $this->db->query("SELECT count(GRANDTOTAL) AS nocekhutang2
            FROM Billing_Pasien.dbo.FO_T_BILLING_1 a
                       left join RawatInapSQL.dbo.TblKelas b on a.KD_KELAS=b.IDkelas
                       inner join MasterdataSQL.dbo.MstrUnitPerwatan c on c.id = a.UNIT
                       inner join Billing_Pasien.dbo.CLOSING_BILL d ON d.NOREG_FIRST = a.NO_REGISTRASI
                       WHERE d.NOREG_REFF = :noreg1e AND a.BATAL = '0' AND a.ID_TRS_Payment IS NULL");
            $this->db->bind('noreg1e', $noreg);
            $datahutang =  $this->db->single();
            $nocekhutang2 = $datahutang['nocekhutang2'];

            if ($nocekhutang2 <> '0') {
                $this->db->query("SELECT a.NO_MR ,SUM(GRANDTOTAL) AS TOTALHUTANG
                FROM Billing_Pasien.dbo.FO_T_BILLING_1 a
                        left join RawatInapSQL.dbo.TblKelas b on a.KD_KELAS=b.IDkelas
                        inner join MasterdataSQL.dbo.MstrUnitPerwatan c on c.id = a.UNIT
                        inner join Billing_Pasien.dbo.CLOSING_BILL d ON d.NOREG_FIRST = a.NO_REGISTRASI
                        WHERE d.NOREG_REFF = :noreg1f AND a.BATAL = '0' AND a.ID_TRS_Payment IS NULL GROUP BY a.NO_MR");
                $this->db->bind('noreg1f', $noreg);
                $key =  $this->db->single();
                $pasing['TOTALHUTANG'] = $key['TOTALHUTANG'];
            }
            // END HUTANG

            // BILL DALAM PERAWATAN
            $this->db->query("SELECT count(GRANDTOTAL) AS nocekbill FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE NO_REGISTRASI = :noreg2a AND BATAL = '0'");
            $this->db->bind('noreg2a', $noreg);
            $databill =  $this->db->single();
            $nocekbill = $databill['nocekbill'];

            $pasing['TOTALBILL'] = '0,00';

            if ($nocekbill <> '0') {
                $this->db->query("SELECT NO_REGISTRASI, SUM(GRANDTOTAL) AS TOTALBILL FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE NO_REGISTRASI = :noreg2b AND BATAL = '0' GROUP BY NO_REGISTRASI");
                $this->db->bind('noreg2b', $noreg);
                $key =  $this->db->single();
                $pasing['TOTALBILL'] = $key['TOTALBILL'];
            }
            // END BILL DALAM PERAWATAN

            // SUBTOTAL
            $t_hutang = $pasing['TOTALHUTANG'];
            $t_bill = $pasing['TOTALBILL'];
            $pasing['TOTALSUBTOTAL'] = $t_hutang + $t_bill;
            // END SUBTOTAL

            // ADMIN DAN MATERAI
            $pasing['TOTALADMIN'] = '0,00';
            $pasing['TOTALMATERAI'] = '0,00';
            if ($getreg == 'RI') {
                $pasing['TOTALADMIN'] = '50000,00';
                $pasing['TOTALMATERAI'] = '10000,00';
            }
            // END ADMIN DAN MATERAI

            // GRAND TOTAL
            $t_admin = $pasing['TOTALADMIN'];
            $t_materai = $pasing['TOTALMATERAI'];
            $pasing['TOTALGRANDTOTAL'] = $t_admin + $t_materai;
            // END GRAND TOTAL


            // BIAYA TERBAYAR
            $this->db->query("SELECT count(GRANDTOTAL) AS nocekbiayaterbayar FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE NO_REGISTRASI = :noreg5a AND BATAL = '0' AND ID_TRS_Payment IS NOT NULL");
            $this->db->bind('noreg5a', $noreg);
            $databiayaterbayar =  $this->db->single();
            $nocekbiayaterbayar = $databiayaterbayar['nocekbiayaterbayar'];

            $pasing['TOTALTERBAYAR'] = '0,00';

            if ($nocekbiayaterbayar <> '0') {
                $this->db->query("SELECT NO_REGISTRASI, SUM(GRANDTOTAL) AS TOTALTERBAYAR FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE NO_REGISTRASI = :noreg5b AND BATAL = '0' AND ID_TRS_Payment IS NOT NULL GROUP BY NO_REGISTRASI");
                $this->db->bind('noreg5b', $noreg);
                $key =  $this->db->single();
                $pasing['TOTALTERBAYAR'] = $key['TOTALTERBAYAR'];
            }
            // END BIAYA TERBAYAR

            // DEPOSIT
            $this->db->query("SELECT count(NOMINAL_BAYAR) AS nocekdeposit FROM Billing_Pasien.dbo.FO_DEPOSIT WHERE NO_REGISTRASI = :noreg6a AND BATAL = '0'");
            $this->db->bind('noreg6a', $noreg);
            $datadeposit =  $this->db->single();
            $nocekdeposit = $datadeposit['nocekdeposit'];

            $pasing['TOTALDEPOSIT'] = '0,00';

            if ($nocekdeposit <> '0') {
                $this->db->query("SELECT NO_REGISTRASI, SUM(NOMINAL_BAYAR) AS TOTALDEPOSIT FROM Billing_Pasien.dbo.FO_DEPOSIT WHERE NO_REGISTRASI = :noreg6b AND BATAL = '0' GROUP BY NO_REGISTRASI");
                $this->db->bind('noreg6b', $noreg);
                $key =  $this->db->single();
                $pasing['TOTALDEPOSIT'] = $key['TOTALDEPOSIT'];
            }

            // TOTAL PEMBAYARAN
            $t_terbayar = $pasing['TOTALTERBAYAR'] + $pasing['TOTALHUTANGLUNAS'];
            $t_deposit = $pasing['TOTALDEPOSIT'];
            $pasing['TOTALPEMBAYARAN'] = $t_terbayar + $t_deposit;
            // END TOTAL PEMBAYARAN

            // YANG HARUS DIBAYAR
            $t_subtotal = $pasing['TOTALSUBTOTAL'];
            $t_grandtotal = $pasing['TOTALGRANDTOTAL'];
            $t_totalpembayaran = $pasing['TOTALPEMBAYARAN'];
            $pasing['TOTALHARUSDIBAYAR'] = ($t_subtotal + $t_grandtotal) - $t_totalpembayaran;
            // END YANG HARUS DIBAYAR

            // PENGEMBALIAN
            $this->db->query("SELECT count(NOMINAL_BAYAR) AS nocekpengembalian FROM Billing_Pasien.dbo.Voucher_Pengembalian1 WHERE NO_REGISTRASI = :noreg AND BATAL = '0'");
            $this->db->bind('noreg', $noreg);
            $datapengembalian =  $this->db->single();
            $nocekpengembalian = $datapengembalian['nocekpengembalian'];

            $pasing['TOTALPENGEMBALIAN'] = '0,00';;

            if ($nocekpengembalian <> '0') {
                $this->db->query("SELECT NO_REGISTRASI, SUM(NOMINAL_BAYAR) AS TOTALPENGEMBALIAN FROM Billing_Pasien.dbo.Voucher_Pengembalian1 WHERE NO_REGISTRASI = :noreg AND BATAL = '0' GROUP BY NO_REGISTRASI");
                $this->db->bind('noreg', $noreg);
                $key =  $this->db->single();
                $pasing['TOTALPENGEMBALIAN'] = $key['TOTALPENGEMBALIAN'];
            }

            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataVoucherPengembalianAktif($data)
    {
        try {
            $tglawal = $data['tglawal'];
            $tglakhir = $data['tglakhir'];
            $this->db->query("SELECT a.NO_TRANSAKSI, a.NO_REGISTRASI, b.PatientName, CASE
            WHEN c.Perusahaan IS NULL THEN e.NamaPerusahaan
            WHEN c.Asuransi IS NULL THEN d.NamaPerusahaan
            ELSE ''
            END AS JAMINAN, a.NOMINAL_BAYAR FROM Billing_Pasien.dbo.Voucher_Pengembalian1 a
            INNER JOIN MasterdataSQL.dbo.Admision b ON b.NoMR = a.NO_MR COLLATE SQL_Latin1_General_CP1_CI_AS
            INNER JOIN PerawatanSQL.dbo.Visit c ON c.NoRegistrasi = a.NO_REGISTRASI COLLATE SQL_Latin1_General_CP1_CI_AS
            LEFT JOIN MasterdataSQL.dbo.MstrPerusahaanJPK d ON d.ID = c.Perusahaan
            LEFT JOIN MasterdataSQL.dbo.MstrPerusahaanAsuransi e ON e.ID = c.Asuransi
            WHERE 
            a.BATAL='0' and replace(CONVERT(VARCHAR(11), TGL_TRS, 111), '/','-') between :tglawal and :tglakhir AND a.NO_TRANSAKSI_REFF_PELUNASAN IS NULL");
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            // $no = 1;
            foreach ($data as $key) {
                // $pasing['No'] = $no++;
                $pasing['NO_TRANSAKSI'] = $key['NO_TRANSAKSI'];
                $pasing['NO_REGISTRASI'] = $key['NO_REGISTRASI'];
                $pasing['PatientName'] = $key['PatientName'];
                $pasing['JAMINAN'] = $key['JAMINAN'];
                // $pasing['NOMINAL_BAYAR'] = number_format($key['NOMINAL_BAYAR'], 0, ',', '.');
                $pasing['NOMINAL_BAYAR'] = $key['NOMINAL_BAYAR'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataVoucherPengembalianArsip($data)
    {
        try {
            $tglawal = $data['tglawal'];
            $tglakhir = $data['tglakhir'];
            // var_dump($data);
            // exit;
            $this->db->query("SELECT a.NO_TRANSAKSI, a.NO_REGISTRASI, b.PatientName, CASE
            WHEN c.Perusahaan IS NULL THEN e.NamaPerusahaan
            WHEN c.Asuransi IS NULL THEN d.NamaPerusahaan
            ELSE ''
            END AS JAMINAN, a.NOMINAL_BAYAR FROM Billing_Pasien.dbo.Voucher_Pengembalian1 a
            INNER JOIN MasterdataSQL.dbo.Admision b ON b.NoMR = a.NO_MR COLLATE SQL_Latin1_General_CP1_CI_AS
            INNER JOIN PerawatanSQL.dbo.Visit c ON c.NoRegistrasi = a.NO_REGISTRASI COLLATE SQL_Latin1_General_CP1_CI_AS
            LEFT JOIN MasterdataSQL.dbo.MstrPerusahaanJPK d ON d.ID = c.Perusahaan
            LEFT JOIN MasterdataSQL.dbo.MstrPerusahaanAsuransi e ON e.ID = c.Asuransi
            WHERE 
            a.BATAL='0' and replace(CONVERT(VARCHAR(11), TGL_TRS, 111), '/','-') between :tglawal and :tglakhir AND a.NO_TRANSAKSI_REFF_PELUNASAN IS NOT NULL");
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['NO_TRANSAKSI'] = $key['NO_TRANSAKSI'];
                $pasing['NO_REGISTRASI'] = $key['NO_REGISTRASI'];
                $pasing['PatientName'] = $key['PatientName'];
                $pasing['JAMINAN'] = $key['JAMINAN'];
                // $pasing['NOMINAL_BAYAR'] = number_format($key['NOMINAL_BAYAR'], 0, ',', '.');
                $pasing['NOMINAL_BAYAR'] = $key['NOMINAL_BAYAR'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function sumAllTarifVoucherAktif($data)
    {
        try {

            $idvoucherx = implode(',', $data['cb_tarifall']);
            $idvoucher = str_replace(",", "','", $idvoucherx);

            $this->db->query("SELECT cast(cast(sum(NOMINAL_BAYAR) AS int) AS varchar(10)) AS NOMINAL_BAYAR FROM Billing_Pasien.dbo.Voucher_Pengembalian1 WHERE NO_TRANSAKSI in ('$idvoucher')");
            $datax1 =  $this->db->single();
            $NOMINAL_BAYAR = $datax1['NOMINAL_BAYAR'];

            return $NOMINAL_BAYAR;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function SaveTrsPaymentVoucherPelunasan($data)
    {
        try {


            $this->db->transaksi();
            $count_array = count($data['tipepembayaran']);
            $terimapembayaran = array_sum(str_replace(".", "", $data['totalinput']));
            $totalhargadumi = str_replace(".", "", $data['totalharga']);
            $yangharusdibayar = str_replace(".", "", $data['totalbayar']);
            // $totalhargadumi = $data['totalharga'];

            if ($terimapembayaran <> $yangharusdibayar) {
                $callback = array(
                    'status' => 'error',
                    'message' => 'Hasil input tidak matching dengan total harga !',
                );
                return $callback;
                exit;
            }

            // var_dump('wait');
            // exit;

            $totalinput = str_replace(".", "", $data['totalinput']);

            $tipepembayaran = $data['tipepembayaran'];

            //var_dump($count_array);exit;
            // $NoMR = $data['NoMR'];
            // $NoEpisode = $data['NoEpisode'];
            // $NoRegistrasi = $data['NoRegistrasi'];
            // $tgl_payment = $data['tglpayment'];
            // $TypePatientID = $data['TypePatientID'];

            // $bilito1 = $data['billtox'];
            $kodejaminan = $data['kodejaminan'];
            $kd_rekening = $data['kd_rekening'];
            // $namabank = $data['namabank'];
            $expired = $data['expired'];
            $nokartu = $data['nokartu'];
            $bilito = $data['billto'];




            //total cash, debit, kredit
            // $terimapembayaran = array_sum(str_replace(".", "", $data['totalinput']));


            $notrsfo = implode(',', $data['idbillingdtl']);
            $tod = json_decode(json_encode((object) $data['idbillingdtl']), FALSE);


            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $namauserx = $session->name;
            $iduserx = $session->IDEmployee;

            // $kodebank = $data['kodebank'];
            // $nokartu = $data['nokartu'];
            // $billtohiden = $data['billtohiden'];


            //GENERATE NO TRS HDR
            //GET URUT

            $datenowlis = date('dmy', strtotime($datenowcreate));
            $this->db->query("SELECT max(NO_TRANSAKSI) as nourut from Billing_Pasien.dbo.FO_VOUCHER_PELUNASAN WHERE SUBSTRING(NO_TRANSAKSI, 4, 6)=:datenowlis");
            $this->db->bind('datenowlis',   $datenowlis);
            $data =  $this->db->single();
            $nourut = $data['nourut'];
            $substringlis = substr($nourut, 9);
            if ($substringlis == null) {
                $substringlis = 0;
            }
            $substringlis++;
            if (strlen($substringlis) == 1) {
                $nourutfixLis = "00" . $substringlis;
            } else if (strlen($substringlis) == 2) {
                $nourutfixLis = "0" . $substringlis;
            } else if (strlen($substringlis) == 3) {
                $nourutfixLis = $substringlis;
            }


            $ID_TR_TARIF = 'TRP' . $datenowlis . $nourutfixLis;
            //#END GENERATE NO TRS HDR

            //GENERATE NO KWITANSI
            //untuk kode awal no NoKwitansi
            $kodeawal = "KUI";
            // if ($TypePatientID == "1") {
            //     $kodeawal = "KUJ";
            // } else {
            //     $kodeawal = "PRJ";
            // }

            // $kodetengah = date('dmy');//untuk kode tengah no NoKwitansi
            $kodetengah = date('dmy', strtotime($datenowcreate));
            //cek no urut kwitansi

            //#END GENERATE KWITANSI
            $this->db->query("INSERT INTO Billing_Pasien.dbo.FO_VOUCHER_PELUNASAN (
                [NO_TRANSAKSI]
               ,[TGL_TRS]
               ,[USER]
               ,[NOMINAL_BAYAR]
               ,[KETRANGAN]
               ,[BATAL]
               ,[TGL_BATAL]
               ,[USER_BATAL]
               ,[ALASAN_BATAL]
               ,[USER_LAST]
               ,[TGL_TRS_LAST]
               ,[NO_TRANSAKSI_REFF_PENGEMBALIAN]
                ) values (
                :NO_TRS
                ,:TGL_TRS
                ,:USER
                ,:NOMINAL_BAYAR
                ,:KETRANGAN
                ,:BATAL
                ,:TGL_BATAL
                ,:USER_BATAL
                ,:ALASAN_BATAL
                ,:USER_LAST
                ,:TGL_TRS_LAST
                ,:NO_TRANSAKSI_REFF_PENGEMBALIAN)");
            $this->db->bind('NO_TRS', $ID_TR_TARIF);
            $this->db->bind('TGL_TRS', $datenowcreate);
            $this->db->bind('USER', $iduserx);
            $this->db->bind('NOMINAL_BAYAR', $terimapembayaran);
            $this->db->bind('KETRANGAN', 'PELUNASAN');
            $this->db->bind('BATAL', '0');
            $this->db->bind('TGL_BATAL', '');
            $this->db->bind('USER_BATAL', '');
            $this->db->bind('ALASAN_BATAL', '');
            $this->db->bind('USER_LAST', $iduserx);
            $this->db->bind('TGL_TRS_LAST', $datenowcreate);
            $this->db->bind('NO_TRANSAKSI_REFF_PENGEMBALIAN', '');
            $this->db->execute();


            //INSERT TABEL PAYMENT DTL
            for ($i = 0; $i < $count_array; $i++) {

                //GENERATE NO TRS DTL
                //GET URUT
                $datenowlis = date('dmy', strtotime($datenowcreate));
                $this->db->query("SELECT  max(NO_TRANSAKSI) as nourut from Billing_Pasien.dbo.FO_VOUCHER_PELUNASAN_2 WHERE SUBSTRING(NO_TRANSAKSI, 5, 6)=:datenowlis ");
                $this->db->bind('datenowlis',   $datenowlis);
                $data =  $this->db->single();
                $nourut = $data['nourut'];
                $substringlis = substr($nourut, 10);
                if ($substringlis == null) {
                    $substringlis = 0;
                }
                $substringlis++;
                if (strlen($substringlis) == 1) {
                    $nourutfixLis = "00" . $substringlis;
                } else if (strlen($substringlis) == 2) {
                    $nourutfixLis = "0" . $substringlis;
                } else if (strlen($substringlis) == 3) {
                    $nourutfixLis = $substringlis;
                }


                $ID_TR_TARIF_DTL = 'TRPD' . $datenowlis . $nourutfixLis;

                // var_dump($ID_TR_TARIF_DTL);
                // var_dump($ID_TR_TARIF);
                // exit;
                //#END GENERATE NO TRS DTL

                $this->db->query("INSERT INTO Billing_Pasien.[dbo].[FO_VOUCHER_PELUNASAN_2]
                ([NO_TRANSAKSI], [NO_TRANSAKSI_REFF], [NOMINAL_BAYAR], [TIPE_PEMBAYARAN], [kode_Tipe_Reff] , [NAMA_TIPE_PEMBAYARAN], [NO_KARTU_REFRENSI], [EXPIRED_DATE])
                VALUES (:NO_TRS, :NO_TRS_REFF, :NOMINAL_BAYAR, :TIPE_PEMBAYARAN, :kode_Tipe_Reff, :NAMA_TIPE_PEMBAYARAN, :NO_KARTU_REFRENSI, :EXPIRED_DATE)");
                $this->db->bind('NO_TRS', $ID_TR_TARIF_DTL);
                $this->db->bind('NO_TRS_REFF', $ID_TR_TARIF);
                $this->db->bind('NOMINAL_BAYAR', $totalinput[$i]);
                $this->db->bind('TIPE_PEMBAYARAN', $tipepembayaran[$i]);
                $this->db->bind('kode_Tipe_Reff', $kodejaminan[$i]);
                // $this->db->bind('kode_Tipe_Reff', $kd_rekening[$i]);
                $this->db->bind('NAMA_TIPE_PEMBAYARAN', $bilito[$i]);
                $this->db->bind('NO_KARTU_REFRENSI', $nokartu[$i]);
                $this->db->bind('EXPIRED_DATE', $expired[$i]);
                $this->db->execute();

                // var_dump('taiii');
                // exit;
            }

            // var_dump('wait');
            // exit;
            // var_dump($ID_TR_TARIF);
            // var_dump($kodetengah);
            // exit;
            //INSERT TABEL PAYMENT HDR

            foreach ($tod as $notrspengembalian) {

                $this->db->query("UPDATE Billing_Pasien.dbo.Voucher_Pengembalian1 SET NO_TRANSAKSI_REFF_PELUNASAN = :NO_TRS_Pelunasan WHERE NO_TRANSAKSI = :notrspengembalian");
                $this->db->bind('NO_TRS_Pelunasan', $ID_TR_TARIF);
                $this->db->bind('notrspengembalian', $notrspengembalian);
                $this->db->execute();
            }


            // var_dump($ID_TR_TARIF);
            // exit;

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Simpan Berhasil',
                'paramsid' => $ID_TR_TARIF,
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }


    public function OpenBilling($data)
    {
        try {

            $this->db->transaksi();
            $noreg = $data['NoRegistrasi'];
            $jaminan = $data['groupjaminan'];
            $getreg = substr($noreg, 0, 2);

            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;

            $this->db->query("SELECT [Status ID] as StatusID FROM PerawatanSQL.dbo.Visit WHERE NoRegistrasi = :norega1
            UNION ALL SELECT StatusID FROM RawatInapSQL.dbo.Inpatient WHERE NoRegRI = :norega2 ");
            $this->db->bind('norega1', $noreg);
            $this->db->bind('norega2', $noreg);
            $dataStatusId =  $this->db->single();
            $statusID = $dataStatusId['StatusID'];

            if ($statusID <> '4') {
                $callback = array(
                    'status' => "warning",
                    'message' => "Status Billing Pasien Saat Ini Sudah Open Bill, Silahkan Refersh", // Set array nama 

                );
                return $callback;
                exit;
            }

            if ($jaminan == 'BS') {
                $this->db->query("DELETE Billing_Pasien.dbo.TEMP_INA_CBG WHERE NO_REGISTRASI = :noregb1");
                $this->db->bind('noregb1', $noreg);
                // $statuscek =  $this->db->single();
                $this->db->execute();
            }

            $this->db->query("DELETE Billing_Pasien.dbo.CLOSE_RO WHERE NOREG = :noregb2");
            $this->db->bind('noregb2', $noreg);
            $this->db->execute();

            $this->db->query("DELETE Billing_Pasien.dbo.CLOSING_BILL WHERE NOREG_FIRST = :noregb3");
            $this->db->bind('noregb3', $noreg);
            $this->db->execute();

            if ($getreg == 'RJ') {
                $this->db->query("UPDATE PerawatanSQL.dbo.Visit SET [Status ID] = '3' WHERE NoRegistrasi = :noregc1");
                $this->db->bind('noregc1', $noreg);
                $this->db->execute();
            } else {
                $this->db->query("UPDATE RawatInapSQL.dbo.Inpatient SET StatusID = '3' WHERE NoRegRI = :noregc2");
                $this->db->bind('noregc2', $noreg);
                $this->db->execute();
            }

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'OPEN BILL SUCCES',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    // 20/08/2024
    public function setSaveCloseOrOpenBill($data)
    {
        try {
            $this->db->transaksi();
            // DATA USER INPUT

            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $useridx = $session->IDEmployee;

            // DATA PASING
            $NoRegistrasi = $data['NoRegistrasi'];
            $Ket_btn_closeoropenbill = $data['Ket_btn_closeoropenbill'];
            $NoMR = $data['NoMR'];
            $AlasanOpen = $data['AlasanOpen'];


           

            if ($Ket_btn_closeoropenbill == 'Close') {

                $this->db->query("SELECT NOREG_REFF FROM Billing_Pasien.dbo.CLOSING_BILL WHERE NOREG_FIRST = :noreg1 AND NOREG_REFF <> ''");
                $this->db->bind('noreg1', $NoRegistrasi);
                $dataStatusId =  $this->db->single();
                $cekDataHutang = $dataStatusId['NOREG_REFF'];

                if ($cekDataHutang <> '') {
                    $callback = array(
                        'status' => "warning",
                        'errorname' => "Billing sudah di pindah status pada No. Registrasi " . $cekDataHutang, // Set array nama 
                    );
                    return $callback;
                    exit;
                }

                $this->db->query("DELETE Billing_Pasien.dbo.CLOSING_BILL WHERE NOREG_FIRST = :NoRegistrasi1");
                $this->db->bind('NoRegistrasi1', $NoRegistrasi);
                $this->db->execute();
                $this->db->query("DELETE Billing_Pasien.dbo.CLOSE_RO WHERE NOREG = :NoRegistrasi2");
                $this->db->bind('NoRegistrasi2', $NoRegistrasi);
                $this->db->execute();
                $this->db->query("DELETE Billing_Pasien.dbo.TEMP_INA_CBG WHERE NO_REGISTRASI = :NoRegistrasi3");
                $this->db->bind('NoRegistrasi3', $NoRegistrasi);
                $this->db->execute();
                $this->db->query("UPDATE PerawatanSQL.dbo.Visit SET [Status ID] = 3 WHERE NoRegistrasi = :NoRegistrasi4");
                $this->db->bind('NoRegistrasi4', $NoRegistrasi);
                $this->db->execute();
                $this->db->query("UPDATE Billing_Pasien.dbo.CLOSING_BILL SET NOREG_REFF = '' WHERE NOREG_REFF = :NoRegistrasi5");
                $this->db->bind('NoRegistrasi5', $NoRegistrasi);
                $this->db->execute();
                $respons_ket = 'Open Bill';
            } else {

                $this->db->query("SELECT COUNT(ID) AS cekDataBill1 from Billing_Pasien.dbo.FO_T_BILLING_1 where BATAL='0' and NO_REGISTRASI=:noreg1 and ID_TRS_Payment is null");
                $this->db->bind('noreg1', $NoRegistrasi);
                $dataStatusBill1 =  $this->db->single();
                $cekDataBill1 = $dataStatusBill1['cekDataBill1'];

                if ($cekDataBill1 <> 0) {
                    $callback = array(
                        'status' => "warning",
                        'errorname' => "Gagal Closing Bill, Ada Bilingan Yang Belum Dibayar", // Set array nama 
                    );
                    return $callback;
                    exit;
                }

                $this->db->query("SELECT COUNT(a.ID) AS cekDataBill2 FROM Billing_Pasien.dbo.FO_T_BILLING_1 a inner join Billing_Pasien.dbo.CLOSING_BILL b on a.NO_REGISTRASI=b.NOREG_FIRST where BATAL='0' and NOREG_REFF=:noreg2 and ID_TRS_Payment is null");
                $this->db->bind('noreg2', $NoRegistrasi);
                $dataStatusBill2 =  $this->db->single();
                $cekDataBill2 = $dataStatusBill2['cekDataBill2'];

                if ($cekDataBill2 <> 0) {
                    $callback = array(
                        'status' => "warning",
                        'errorname' => "Gagal Closing Bill, Ada Bilingan Hutang Yang Belum Dibayar", // Set array nama 
                    );
                    return $callback;
                    exit;
                }

                $this->db->query("SELECT SUM(BAYAR) AS TotalBayar, SUM(KLAIM) AS TotalKlaim, SUM(KEKURANGAN) AS TotalKekurangan FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE NO_REGISTRASI = :NoReg3 AND BATAL = '0' AND ID_TRS_Payment IS NOT NULL");
                $this->db->bind('NoReg3', $NoRegistrasi);
                $datasd =  $this->db->single();
                $TotalBayar = $datasd['TotalBayar'];
                $TotalKlaim = $datasd['TotalKlaim'];
                $TotalKekurangan = $datasd['TotalKekurangan'];

                //total hutang
                $this->db->query("SELECT SUM(BAYAR) AS TotalBayar, SUM(KLAIM) AS TotalKlaim, SUM(KEKURANGAN) AS TotalKekurangan 
                FROM Billing_Pasien.dbo.FO_T_BILLING_1 a
                INNER JOIN Billing_Pasien.dbo.CLOSING_BILL b on a.NO_REGISTRASI=b.NOREG_FIRST
                WHERE BATAL='0' and NOREG_REFF=:NoRegxd
                and ID_TRS_Payment is null ");
                $this->db->bind('NoRegxd', $NoRegistrasi);
                $dataxd =  $this->db->single();
                $TotalBayarxd = $dataxd['TotalBayar'];
                $TotalKlaimxd = $dataxd['TotalKlaim'];
                $TotalKekuranganxd = $dataxd['TotalKekurangan'];
                // total hutang

                $TotalBayarall = $TotalBayar + $TotalBayarxd;
                $TotalKlaimall = $TotalKlaim + $TotalKlaimxd;
                $TotalKekuranganall = $TotalKekurangan + $TotalKekuranganxd;

                $this->db->query("INSERT INTO Billing_Pasien.dbo.CLOSING_BILL
                ([NOREG_FIRST], [JENIS_CLOSING], [TOTAL], [NOREG_REFF], [NO_MR])
                VALUES ( 
                :NoRegxd1a, 'CLOSEBILL', :TotalBayar1a, '', :NoMR1a)");
                $this->db->bind('NoRegxd1a', $NoRegistrasi);
                $this->db->bind('TotalBayar1a', $TotalBayarall);
                $this->db->bind('NoMR1a', $NoMR);
                $this->db->execute();

                $this->db->query("INSERT INTO Billing_Pasien.dbo.CLOSE_RO
                ([NOREG], [TOTAL_BILL], [KLAIM], [KEKURANGAN])
                VALUES ( 
                :NoRegxd2a, :TotalBayar2a, :TotalKlaim2a, :TotalKekurangan2a)");
                $this->db->bind('NoRegxd2a', $NoRegistrasi);
                $this->db->bind('TotalBayar2a', $TotalBayarall);
                $this->db->bind('TotalKlaim2a', $TotalKlaimall);
                $this->db->bind('TotalKekurangan2a', $TotalKekuranganall);
                $this->db->execute();

                $this->db->query("INSERT INTO Billing_Pasien.dbo.TEMP_INA_CBG
                SELECT 
                NO_REGISTRASI
                ,isnull(ProsedurNonBedah,0) as ProsedurNonBedah
                ,isnull(ProsedurBedah,0) as ProsedurBedah
                ,isnull(Konsultasi,0) as Konsultasi
                ,0 as TenagaAhli
                ,isnull(Keperawatan,0) as Keperawatan
                ,0 as Penunjang
                ,isnull(Laboratorium,0) as Laboratorium
                ,isnull(Radiologi,0) as Radiologi
                ,isnull(PelayananDarah,0) as PelayananDarah
                ,isnull(Rehabilitasi,0) as Rehabilitasi
                ,isnull(Kamar,0) as Kamar_Akomodasi
                ,0 as RawatIntensif
                ,isnull(Obat,0) as Obat
                ,0 as ObatKronis
                ,0 as ObatKemoterapi
                ,0 as Alkes
                ,0 as BMHP
                ,0 as SewaAlat
                ,isnull(ProsedurNonBedah,0)
                +isnull(ProsedurBedah,0)
                +isnull(Konsultasi,0)
                +isnull(Laboratorium,0)
                +isnull(Radiologi,0)
                +isnull(PelayananDarah,0)
                +isnull(Rehabilitasi,0)
                +isnull(Kamar,0)
                +isnull(Obat,0) as TOTAL
                FROM (
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'ProsedurNonBedah' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3a and GROUP_TARIF ='Tindakan' 
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'ProsedurBedah' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3b and GROUP_TARIF ='Operasi'
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'Konsultasi' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3c and GROUP_TARIF ='Konsultasi'
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'Keperawatan' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3d and GROUP_TARIF ='Administrasi' 
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'Laboratorium' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3e and GROUP_TARIF ='Laboratorium'
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'Radiologi' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3f and GROUP_TARIF ='Radiologi'
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'PelayananDarah' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3g and GROUP_TARIF ='BankDarah'
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'Rehabilitasi' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3h and GROUP_TARIF ='Fisioterapi'
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'Kamar' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3i and GROUP_TARIF ='Kamar'
                Group by NO_REGISTRASI
                UNION ALL
                SELECT NO_REGISTRASI,SUM(GRANDTOTAL) as TotalTarif,'Obat' as GROUP_TARIF FROM Billing_Pasien.dbo.FO_T_BILLING_1 
                where BATAL='0' and ID_TRS_Payment is not null and NO_REGISTRASI=:NoReg3j and GROUP_TARIF ='Farmasi'
                Group by NO_REGISTRASI
                )AS QPivot
                PIVOT( SUM(TotalTarif)   
                FOR GROUP_TARIF IN ([ProsedurNonBedah],[ProsedurBedah],[Konsultasi],[Keperawatan],[Laboratorium],[Radiologi],[PelayananDarah],[Rehabilitasi],[Kamar],[Obat])) AS QPivot");
                $this->db->bind('NoReg3a', $NoRegistrasi);
                $this->db->bind('NoReg3b', $NoRegistrasi);
                $this->db->bind('NoReg3c', $NoRegistrasi);
                $this->db->bind('NoReg3d', $NoRegistrasi);
                $this->db->bind('NoReg3e', $NoRegistrasi);
                $this->db->bind('NoReg3f', $NoRegistrasi);
                $this->db->bind('NoReg3g', $NoRegistrasi);
                $this->db->bind('NoReg3h', $NoRegistrasi);
                $this->db->bind('NoReg3i', $NoRegistrasi);
                $this->db->bind('NoReg3j', $NoRegistrasi);
                $this->db->execute();

                $this->db->query("UPDATE PerawatanSQL.dbo.Visit 
                SET [Status ID] = 4, JamPulang=:JamPulang 
                WHERE NoRegistrasi = :NoRegistrasi ");
                $this->db->bind('NoRegistrasi', $NoRegistrasi);
                $this->db->bind('JamPulang', $datenowcreate);
                $this->db->execute();

                $respons_ket = 'Close Bill';
            }

            if ($respons_ket == 'Close Bill') {
                $this->db->query("INSERT INTO SysLog.dbo.TZ_Log_Button
                (noregistrasi, nama_biling, petugas_entry, tgl_entry)
                VALUES ( 
                :NoRegRecord, 'CLOSE BILL', :USER_KASIRRecord, :TGL_TRSRecord)");
                $this->db->bind('NoRegRecord', $NoRegistrasi);
                $this->db->bind('USER_KASIRRecord', $namauserx);
                $this->db->bind('TGL_TRSRecord', $datenowcreate);
                $this->db->execute();
            } else {
                // $this->db->query("INSERT INTO SysLog.dbo.TZ_Log_Button
                // (noregistrasi, nama_biling, petugas_entry, tgl_entry, alasan_batal)
                // VALUES ( 
                // :NoRegRecord, 'OPEN BILL', :USER_KASIRRecord, :TGL_TRSRecord, :AlasanOpenRecord)");
                // $this->db->bind('NoRegRecord', $NoRegistrasi);
                // $this->db->bind('USER_KASIRRecord', $namauserx);
                // $this->db->bind('TGL_TRSRecord', $datenowcreate);
                // $this->db->bind('AlasanOpenRecord', $AlasanOpen);
                // $this->db->execute();

                $this->db->query("UPDATE SysLog.dbo.TZ_Log_Button SET petugas_batal = :USER_KASIRRecord, alasan_batal = :AlasanOpenRecord, tgl_batal = :TGL_TRSRecord
                WHERE NoRegistrasi = :NoRegRecord AND petugas_batal IS NULL");
                $this->db->bind('USER_KASIRRecord', $namauserx);
                $this->db->bind('AlasanOpenRecord', $AlasanOpen);
                $this->db->bind('TGL_TRSRecord', $datenowcreate);
                $this->db->bind('NoRegRecord', $NoRegistrasi);
                $this->db->execute();
            }

            //send blast Whatsapp
            $this->db->query("SELECT PatientName, [Mobile Phone] AS NOHP
            FROM MasterdataSQL.DBO.Admision WHERE NoMR=:NoMR");
            $this->db->bind('NoMR', $NoMR);
            $DATAMRWA =  $this->db->single();
            $NoHandphone =   Utils::hp($DATAMRWA['NOHP']);
            $PatientName = $DATAMRWA['PatientName'];
            // $text = urlencode("Halo ".$PasienNama.", \n\n Anda sudah terdaftar Konsultasi/Kontrol ke ".$viewNamaPoliklinik . " (".$namadokter . "), pada : \n\n Hari/Tgl : ".$TglBookingx . " \n Jam Praktek : ".$getwaktujadwal . " WIB \n No. Booking : ".$nobokingreal . " \n No. Antrian : ".$fixNoAntrian . " \n\n ilhakan lakukan Checkin pada Counter pendaftaran kami pada hari H Konsultasi/Kontrol dengan menunjukan Pesan Whatsapp ini kepada Petugas kami. \n\n Terima Kasih. \n\n Klinik Utama Brebes Eye Center "); 
            $text = urlencode("Bapak/Ibu ".$PatientName.", \n\n Kami ingin mengucapkan terima kasih yang sebesar-besarnya atas kepercayaan Bapak/Ibu yang telah memilih Klinik Utama Brebes Eye Center untuk mendapatkan layanan kesehatan.\n\nGuna meningkatkan Kualitas Pelayanan terhadap pasien, kami mengharapkan umpan balik dari Bapak/Ibu atas pelayanan kami dengan cara mengisi Google Form dibawah ini :\n\nhttps://bit.ly/reviewpasien\n\nSilahkan follow Social Media Kami guna mendapatkan Informasi ataupun promo-promo terbaru dari kami :\n\n- Instagram\n http://bit.ly/instagrambrec\n\n- Tiktok\n http://bit.ly/tiktokbrec \n\n  - Facebook\n  http://bit.ly/facebookbrec\n\nATerima Kasih.\n\nBrebes Eye Center"); 
                $curl = curl_init();
                $url = "https://api.kirimpesan.net/api/sendText?token=66b5ace5c302c5956a66b6f3&phone=".$NoHandphone."&message=".$text;
                curl_setopt_array($curl, array(
                  CURLOPT_URL => $url,
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_SSL_VERIFYPEER => FALSE,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'GET', 
                  CURLOPT_HTTPHEADER => array(
                    'Accept: application/json',
                    'Content-Type: application/json'
                  ),
                ));
                
                $response = curl_exec($curl);
                $JsonData = json_decode($response, TRUE);
                curl_close($curl); 
            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
                'ket_respons' => $respons_ket,
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    // 20/08/2024

    // 22/08/2024
    public function SetSaveBatalRiwayatPembayaran($data)
    {
        try {
            $this->db->transaksi();

            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $useridx = $session->IDEmployee;

            // DATA PASING
            $noreg = $data['noreg'];
            $notrs = $data['notrs'];
            $alasanBtlPayment = $data['alasanBtlPayment'];

            $this->db->query("SELECT [Status ID] as StatusID FROM PerawatanSQL.dbo.Visit WHERE NoRegistrasi = :norega1
            UNION ALL SELECT StatusID FROM RawatInapSQL.dbo.Inpatient WHERE NoRegRI = :norega2 ");
            $this->db->bind('norega1', $noreg);
            $this->db->bind('norega2', $noreg);
            $dataStatusId =  $this->db->single();
            $statusID = $dataStatusId['StatusID'];

            if ($alasanBtlPayment == '') {
                $callback = array(
                    'status' => "warning",
                    'errorname' => "Silahkan isi alasan terlebih dahulu", // Set array nama 

                );
                return $callback;
                exit;
            }

            if ($statusID == '4') {
                $callback = array(
                    'status' => "warning",
                    'errorname' => "Pasien sudah close, silahkan open bill untuk melakukan pembatalan pembayaran", // Set array nama 
                );
                return $callback;
                exit;
            }

            // BATAL KASIR
            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_KASIR SET BATAL = '1', TGL_BATAL = :datenowx1, USER_BATAL= :namauserx1, ALASAN_BATAL = :alasanBtlPayment1 WHERE NO_TRS = :notrs1");
            // $this->db->bind('noreg1', $noreg);
            $this->db->bind('datenowx1', $datenowx);
            $this->db->bind('namauserx1', $namauserx);
            $this->db->bind('alasanBtlPayment1', $alasanBtlPayment);
            $this->db->bind('notrs1', $notrs);
            $this->db->execute();
            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_KASIR_2 SET BATAL = '1' WHERE NO_TRS_REFF = :notrs2");
            $this->db->bind('notrs2', $notrs);
            $this->db->execute();

            // BATAL FOT_BILL
            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 SET ID_TRS_Payment = NULL, BAYAR = 0 WHERE ID_TRS_Payment = :notrs3");
            $this->db->bind('notrs3', $notrs);
            // $this->db->bind('noreg3', $noreg);
            $this->db->execute();

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
                // 'ket_respons' => $respons_ket,
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    // 22/08/2024




    public function getDataDocumentPDF($data)
    {
        try {
            $this->db->transaksi();

            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $useridx = $session->IDEmployee;

            // DATA PASING
            $NoMR = $data['nomr'];
            // $notrs = $data['notrs'];
            // $alasanBtlPayment = $data['alasanBtlPayment'];

            $this->db->query("SELECT EmateraiDocument FROM Billing_Pasien.dbo.TDocumentPaymentDelays WHERE NoMR = :NoMR and ActiveDocument='1'");

            $this->db->bind('NoMR', $NoMR);
            $dataLinkTemp =  $this->db->single();
            $dataLink = $dataLinkTemp['EmateraiDocument'];

            // var_dump($dataLink);
            // exit;

            // $this->db->execute();

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
                'link_response' => $dataLink,
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    //bridging materai
    public function uploadAWS($data)
    {
        $notrs = $data['notrs'];

        $bytes = random_bytes(20);
        $nama_file_baru  =     $notrs . bin2hex($bytes) . "-" . date("YmdHis");
        $nama_file = $data['GrupTransaksi'] . '-' . $notrs . '.pdf';
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
                'Key'    => 'digitalfiles/billing/' . $key,
                'Body'   => $handle,
                'ACL'    => 'public-read', // make file 'public', 
            ]);
            $awsImages = $result->get('ObjectURL');
            $datenowcreate = Utils::datenowcreateNotFull();
            // $datenowx = Utils::datenowcreateNotFull();

            // $AwsUrlDocuments = $data['aws_url'];
            $endpoint = 'singleStampMaterai';
            $provider_code = '7146';
            $app_id = 'api_aNky7D';
            $project_id = 'e-materai_1t9v';
            $document_name = $data['judul'];
            $document_code = 'INV';
            $visLLX = '320';
            $visLLY = '44';
            $visURX = '425';
            $visURY = '150';
            $visSignaturePage = '1';
            $nodoc = '20';
            $IdNumber = '1234123412341236';
            $reason = 'alesan';

            $nilai_document = '10000';
            // $nama_file = 'KUITANSI-.pdf';

            // $file_name = 'tmp/' . $nama_file;
            // $source = curl_file_create($file_name);

            // $file_name = $_SERVER['DOCUMENT_ROOT'] . 'SIKBREC/public/tmp/' . $nama_file;
            $source = curl_file_create($file_name);
            // $awsImages = '';
            // $handle = fopen($source, 'r');
            // 1. Gen Token
            $method = "POST";

            $postSatuanData = array(
                'endpoint' => $endpoint,
                'file' =>  $source,
                'document_name' => $document_name,
                'document_code' => $document_code,
                'provider_code' => $provider_code,
                'app_id' => $app_id,
                'project_id' => $project_id,
                'visLLX' => $visLLX,
                'visLLY' => $visLLY,
                'visURX' => $visURX,
                'visURY' => $visURY,
                'visSignaturePage' => $visSignaturePage,
                'reason' => $reason,
                'nodoc' => $nodoc,
                'IdNumber' => $IdNumber,
                'nilai_document' => $nilai_document,
                'document_date' => $datenowcreate
            );
            $urlCreateEmaterai = "v2/coremdika";
            $addematerai = $this->curl_request_ematerai(GenerateEmaterai::headers_api(), $method, $postSatuanData, $urlCreateEmaterai);
            // return $addematerai;
            if ($addematerai['status'] == true) {
                $callback = array(
                    'status' => 'success',
                    'urlmaterai' => $addematerai['data'],
                    'message' => $addematerai['message'],
                );
            } else {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => $addematerai['message'],
                );
            }
            //             var_dump($addematerai['data']['url_file']);exit;
            //             $array = array($addematerai['data']);
            // $string = implode($array); 
            $UrlEmaterai = $addematerai['data']['url_file'];

            //close filenya
            fclose($handle);
            //hapus filenya 
            // unlink($_SERVER["DOCUMENT_ROOT"] . 'SIKBREC/public/tmp/' . $nama_file);

            return $this->SaveFileDocument($data, $awsImages, $UrlEmaterai);
        } catch (MultipartUploadException $e) {

            return $e->getMessage();
        }
    }

    public function SaveFileDocument($data, $awsImages, $UrlEmaterai)
    {
        try {
            $this->db->transaksi();
            $session = SessionManager::getCurrentSession();
            $userlogin = $session->IDEmployee;
            $usernamelogin = $session->name;

            $datenowcreate = Utils::seCurrentDateTime();
            $uuid = $data['uuid4'];
            $NoRegistrasi = $data['NoRegistrasi'];
            // var_dump($data,$awsImages);exit;

            if (substr($data['GrupTransaksi'], 0, 8) == 'KUITANSI') {
                $DocumentType = 'KUITANSI_BILLING';
            } else {
                $DocumentType = 'RINCIAN_BILLING';
            }

            $query = "UPDATE a
              SET Active='0' 
              FROM Billing_Pasien.dbo.TDocumentMasters a
              inner join Billing_Pasien.dbo.TDocumentBillingPatients b on a.Uuid=b.DocTransactionID
              WHERE GrupTransaksi=:GrupTransaksi and NoTrs_Reff=:id and NoRegistrasi=:NoRegistrasi
              ";
            $this->db->query($query);
            $this->db->bind('id', $data['notrs']);
            $this->db->bind('NoRegistrasi', $data['NoRegistrasi']);
            $this->db->bind('GrupTransaksi', $data['GrupTransaksi']);
            $this->db->execute();

            $query = "INSERT INTO Billing_Pasien.dbo.TDocumentMasters (Uuid,DateCreate,UserCreate,DocumentType,AwsUrlDocuments,NamaTTD1)
                Values
            (:uuid,:datenowcreate,:userlogin,:DocumentType,:AWS_URL,:usernamelogin)";
            $this->db->query($query);
            $this->db->bind('uuid', $uuid);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('userlogin', $userlogin);
            $this->db->bind('DocumentType', $DocumentType);
            $this->db->bind('AWS_URL', $awsImages);
            $this->db->bind('usernamelogin', $usernamelogin);
            // $this->db->bind('NoRegistrasi', $NoRegistrasi);

            $this->db->execute();

            $query = "UPDATE Billing_Pasien.dbo.TDocumentBillingPatients SET ActiveDocument='0' WHERE GrupTransaksi=:GrupTransaksi and NoTrs_Reff=:id and NoRegistrasi=:NoRegistrasi";
            $this->db->query($query);
            $this->db->bind('id', $data['notrs']);
            $this->db->bind('NoRegistrasi', $data['NoRegistrasi']);
            $this->db->bind('GrupTransaksi', $data['GrupTransaksi']);
            $this->db->execute();

            $query = "INSERT INTO  Billing_Pasien.dbo.TDocumentBillingPatients (DocTransactionID,NoTrs_Reff,NoRegistrasi,GrupTransaksi,AwsUrlDocuments,TglCreate,UserCreate,EmateraiDocuments)
                Values
            (:uuid,:id,:NoRegistrasi,:GrupTransaksi,:AWS_URL,:datenowcreate,:userlogin,:EmateraiDocuments)";
            $this->db->query($query);
            $this->db->bind('uuid', $uuid);
            $this->db->bind('id', $data['notrs']);
            $this->db->bind('NoRegistrasi', $data['NoRegistrasi']);
            $this->db->bind('GrupTransaksi', $data['GrupTransaksi']);
            $this->db->bind('AWS_URL', $awsImages);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('userlogin', $userlogin);
            $this->db->bind('EmateraiDocuments', $UrlEmaterai);

            $this->db->execute();


            $query = "INSERT INTO  Billing_Pasien.dbo.TDocumentHistoryBillingPatients (DocTransactionID,CetakanKe,Alasan_Cetak,UserCreate,DateCreate)
                Values
            (:uuid,:CetakanKe,:Alasan_Cetak,:userlogin,:datenowcreate)";
            $this->db->query($query);
            $this->db->bind('uuid', $uuid);
            $this->db->bind('CetakanKe', $data['cetakanke']['CetakanKe']);
            $this->db->bind('Alasan_Cetak', '');
            $this->db->bind('userlogin', $userlogin);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->execute();


            $this->db->Commit();
            $callback = array(
                'status' => 200,
                'message' => 'Generate Upload Data Succesfully.',
                'aws_url' =>  $awsImages,
            );
            // return $this->goEmateraiAPI($data, $awsImages);

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
    public function goEmateraiAPI($data)
    {
        try {
            // $datenowcreate = '2024-10-08';
            $datenowcreate = Utils::datenowcreateNotFull();
            // $datenowx = Utils::datenowcreateNotFull();

            // $AwsUrlDocuments = $data['aws_url'];
            $endpoint = 'singleStampMaterai';
            $provider_code = '7146';
            $app_id = 'api_aNky7D';
            $project_id = 'e-materai_1t9v';
            $document_name = $data['judul'];
            $document_code = 'INV';
            $visLLX = '320';
            $visLLY = '44';
            $visURX = '425';
            $visURY = '150';
            $visSignaturePage = '1';
            $nodoc = '20';
            $IdNumber = '1234123412341236';
            $reason = 'alesan';

            $nilai_document = '10000';
            $nama_file = 'KUITANSI-.pdf';

            // $file_name = 'tmp/' . $nama_file;
            // $source = curl_file_create($file_name);

            $file_name = $_SERVER['DOCUMENT_ROOT'] . 'SIKBREC/public/tmp/' . $nama_file;
            $source = curl_file_create($file_name);
            // $awsImages = '';
            // $handle = fopen($source, 'r');
            // 1. Gen Token
            $method = "POST";

            $postSatuanData = array(
                'endpoint' => $endpoint,
                'file' =>  $source,
                'document_name' => $document_name,
                'document_code' => $document_code,
                'provider_code' => $provider_code,
                'app_id' => $app_id,
                'project_id' => $project_id,
                'visLLX' => $visLLX,
                'visLLY' => $visLLY,
                'visURX' => $visURX,
                'visURY' => $visURY,
                'visSignaturePage' => $visSignaturePage,
                'reason' => $reason,
                'nodoc' => $nodoc,
                'IdNumber' => $IdNumber,
                'nilai_document' => $nilai_document,
                'document_date' => $datenowcreate
            );
            $urlCreateEmaterai = "v2/coremdika";
            $addematerai = $this->curl_request_ematerai(GenerateEmaterai::headers_api(), $method, $postSatuanData, $urlCreateEmaterai);
            // return $addematerai;
            if ($addematerai['status'] == true) {
                $callback = array(
                    'status' => 'success',
                    'urlmaterai' => $addematerai['data'],
                    'message' => $addematerai['message'],
                );
            } else {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => $addematerai['message'],
                );
            }
            //             var_dump($addematerai['data']['url_file']);exit;
            //             $array = array($addematerai['data']);
            // $string = implode($array); 
            $UrlEmaterai = $addematerai['data']['url_file'];
            // var_dump($UrlEmaterai);exit;
            $uuid = $data['uuid4'];

            $query = "UPDATE Billing_Pasien.dbo.TDocumentBillingPatients SET EmateraiDocuments=:UrlEmaterai WHERE DocTransactionID=:uuid and NoRegistrasi=:NoRegistrasi";
            $this->db->query($query);
            $this->db->bind('UrlEmaterai', $UrlEmaterai);
            $this->db->bind('NoRegistrasi', $data['noregistrasi']);
            $this->db->bind('uuid', $uuid);
            $this->db->execute();

            //     $query = "INSERT INTO  Billing_Pasien.dbo.TDocumentBillingPatients (EmateraiDocuments)
            //       Values
            //   (:EmateraiDocuments)";
            //     $this->db->query($query);

            //     $this->db->bind('EmateraiDocuments', $UrlEmaterai);

            //     $this->db->execute();

            return $callback;
            // return $this->SaveFile($data, $UrlEmaterai);

        } catch (MultipartUploadException $e) {

            return $e->getMessage();
        }
    }
    public function GenerateEmateraiHeaderbyIDX($data)
    {
        try {
            // var_dump($data['notrs'], $data['NoRegistrasi']);
            // exit;
            if ($data['kodereg'] == 'RJ') {
                $query = "SELECT f.PatientName, a.BILLTO, a.NO_MR, a.NO_REGISTRASI, a.NO_EPISODE, a.NO_KWITANSI, a.USER_KASIR, a.NOMINAL_BAYAR, SUBSTRING(x.nama_test,1, LEN(x.nama_test) - 1) 
                NamaTest, y.nominal_bayar_tunai, z.nominal_bayar_Debit, w.nominal_bayar_PiuangPerushaan, f3.NamaUnit, f4.NamaPerusahaan AS NamaJaminan, a.KODE_KASIR AS Id_Kasir
                FROM Billing_Pasien.dbo.FO_T_KASIR a
                INNER JOIN MasterdataSQL.dbo.Admision f ON f.NoMR = a.NO_MR COLLATE  SQL_Latin1_General_CP1_CI_AS
                inner join PerawatanSQL.dbo.Visit f2 on a.NO_REGISTRASI collate Latin1_General_CI_AS = f2.NoRegistrasi
                inner join MasterdataSQL.dbo.MstrUnitPerwatan f3 on f2.Unit= f3.ID
                inner join MasterdataSQL.dbo.MstrPerusahaanJPK f4 on f2.Perusahaan = f4.ID
                OUTER APPLY (
                SELECT NAMA_TARIF + ', '
                FROM Billing_Pasien.dbo.FO_T_BILLING_1 c
                WHERE c.ID_TRS_Payment = a.NO_TRS AND c.BATAL = '0'
                FOR XML PATH('')
                ) x (nama_test)
                OUTER APPLY (
                SELECT SUM(NOMINAL_BAYAR) as bayartunai
                FROM Billing_Pasien.dbo.FO_T_KASIR_2 b
                WHERE b.NO_TRS_REFF = a.NO_TRS AND TIPE_PEMBAYARAN = 'Tunai'
                ) y (nominal_bayar_tunai)
                OUTER APPLY (
                SELECT SUM(NOMINAL_BAYAR) as bayartunai
                FROM Billing_Pasien.dbo.FO_T_KASIR_2 d
                WHERE d.NO_TRS_REFF = a.NO_TRS AND TIPE_PEMBAYARAN = 'Kartu Debit'
                ) z (nominal_bayar_Debit)
                OUTER APPLY (
                SELECT SUM(NOMINAL_BAYAR) as bayartunai
                FROM Billing_Pasien.dbo.FO_T_KASIR_2 e
                WHERE e.NO_TRS_REFF = a.NO_TRS AND TIPE_PEMBAYARAN = 'Piutang Perusahaan'
                ) w (nominal_bayar_PiuangPerushaan)
                WHERE a.NO_REGISTRASI = :noreg1 AND  a.NO_TRS = :notrskasir1
                UNION ALL 
                SELECT f.PatientName, a.BILLTO, a.NO_MR, a.NO_REGISTRASI, a.NO_EPISODE, a.NO_KWITANSI, a.USER_KASIR, a.NOMINAL_BAYAR, SUBSTRING(x.nama_test,1, LEN(x.nama_test) - 1) 
                NamaTest, y.nominal_bayar_tunai, z.nominal_bayar_Debit, w.nominal_bayar_PiuangPerushaan, f3.NamaUnit, f4.NamaPerusahaan AS NamaJaminan, a.KODE_KASIR AS Id_Kasir
                FROM Billing_Pasien.dbo.FO_T_KASIR a
                INNER JOIN MasterdataSQL.dbo.Admision f ON f.NoMR = a.NO_MR COLLATE  SQL_Latin1_General_CP1_CI_AS
                inner join PerawatanSQL.dbo.Visit f2 on a.NO_REGISTRASI collate Latin1_General_CI_AS = f2.NoRegistrasi
                inner join MasterdataSQL.dbo.MstrUnitPerwatan f3 on f2.Unit= f3.ID
                inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi f4 on f2.Asuransi = f4.ID
                OUTER APPLY (
                SELECT NAMA_TARIF + ', '
                FROM Billing_Pasien.dbo.FO_T_BILLING_1 c
                WHERE c.ID_TRS_Payment = a.NO_TRS AND c.BATAL = '0'
                FOR XML PATH('')
                ) x (nama_test)
                OUTER APPLY (
                SELECT SUM(NOMINAL_BAYAR) as bayartunai
                FROM Billing_Pasien.dbo.FO_T_KASIR_2 b
                WHERE b.NO_TRS_REFF = a.NO_TRS AND TIPE_PEMBAYARAN = 'Tunai'
                ) y (nominal_bayar_tunai)
                OUTER APPLY (
                SELECT SUM(NOMINAL_BAYAR) as bayartunai
                FROM Billing_Pasien.dbo.FO_T_KASIR_2 d
                WHERE d.NO_TRS_REFF = a.NO_TRS AND TIPE_PEMBAYARAN = 'Kartu Debit'
                ) z (nominal_bayar_Debit)
                OUTER APPLY (
                SELECT SUM(NOMINAL_BAYAR) as bayartunai
                FROM Billing_Pasien.dbo.FO_T_KASIR_2 e
                WHERE e.NO_TRS_REFF = a.NO_TRS AND TIPE_PEMBAYARAN = 'Piutang Perusahaan'
                ) w (nominal_bayar_PiuangPerushaan)
                WHERE a.NO_REGISTRASI = :noreg2 AND  a.NO_TRS = :notrskasir2";
            } elseif ($data['kodereg'] == 'RI') {
                $query = "  SELECT a.ID,NoKwitansi,a.NoRegistrasi,b.NoMR,
                case when billto is null then b.PatientName collate Latin1_General_CI_AS else billto end as billto,PatientName,NamaJaminan,a.Keterangan as NamaUnit,Ammount as TotalPaid,Kasir,Id_Kasir,isnull(Cetakan_Ke,0) as Cetakan_Ke
                FROM RawatInapSQL.dbo.Deposit a
                left join DashboardData.dbo.dataRWI b on a.NoRegistrasi=b.NoRegistrasi 
                where a.ID=:id";
            } elseif ($data['kodereg'] == 'PB') {
                $query = "SELECT a.ID,NoKwitansi,a.NoRegistrasi,'-' NoMR,case when billto is null then b.[Ship Name] collate Latin1_General_CI_AS else billto end as billto,[Ship Name] as PatientName,'-' NamaJaminan,'PEMBELIAN OBAT BEBAS' as NamaUnit,TotalPaid,Kasir,Id_Kasir,isnull(Cetakan_Ke,0) as Cetakan_Ke
                FROM PerawatanSQL.dbo.payments a
                left join [Apotik_V1.1SQL].dbo.Orders b on a.NoRegistrasi=b.NoRegistrasi
                where a.ID=:id";
            } else {
                $pasing['NoKwitansi'] = '';
                $pasing['NoRegistrasi'] = '';
                $pasing['NoMR'] = '';
                $pasing['billto'] = '';
                $pasing['PatientName'] = '';
                $pasing['NamaJaminan'] = '';
                $pasing['NamaUnit'] = '';
                $pasing['Kasir'] = '';
                $pasing['Terbilang'] = '';
                $pasing['TotalPaid'] = '';
                $pasing['Id_Kasir'] = '';
                $pasing['Cetakan_Ke'] = '';
                $pasing['ID'] = '';
                return $pasing;
            }
            $this->db->query($query);
            // $this->db->bind('id', $data['notrs']);
            $this->db->bind('noreg1', $data['NoRegistrasi']);
            $this->db->bind('notrskasir1', $data['notrs']);
            $this->db->bind('noreg2', $data['NoRegistrasi']);
            $this->db->bind('notrskasir2', $data['notrs']);
            $datas =  $this->db->single();

            if ($data['lang'] == 'EN') {
                $terbilang = $this->terbilang_eng($datas['NOMINAL_BAYAR']);
            } else {
                $terbilang = $this->terbilang($datas['NOMINAL_BAYAR']);
            }

            // $pasing['TglCreate_sign'] = date('d/m/Y', strtotime($datas['TglCreate']));
            $pasing['billto'] = $datas['BILLTO'];
            $pasing['NoMR'] = $datas['NO_MR'];
            $pasing['NoRegistrasi'] = $datas['NO_REGISTRASI'];
            $pasing['NO_EPISODE'] = $datas['NO_EPISODE'];
            $pasing['NoKwitansi'] = $datas['NO_KWITANSI'];
            // $pasing['Id_Kasir'] = $datas['USER_KASIR'];

            $pasing['PatientName'] = $datas['PatientName'];
            $pasing['NamaJaminan'] = $datas['NamaJaminan'];
            $pasing['NamaUnit'] = $datas['NamaUnit'];
            $pasing['Kasir'] = $datas['USER_KASIR'];
            $pasing['Id_Kasir'] = $datas['Id_Kasir'];
            // $pasing['Cetakan_Ke'] = $datas['Cetakan_Ke'];
            // $pasing['ID'] = $datas['ID'];
            $pasing['Terbilang'] = $terbilang;
            $pasing['TotalPaid'] = number_format($datas['NOMINAL_BAYAR'], 0, ',', '.');

            // var_dump($pasing['TotalPaid']);
            // exit;

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function GenerateEmateraiDetailbyIDX($data)
    {
        try {

            if ($data['kodereg'] == 'RJ' || $data['kodereg'] == 'PB') {
                $query = "SELECT b.TIPE_PEMBAYARAN, b.NOMINAL_BAYAR FROM Billing_Pasien.dbo.FO_T_KASIR a
                INNER JOIN Billing_Pasien.dbo.FO_T_KASIR_2 b ON b.NO_TRS_REFF = a.NO_TRS
                WHERE a.NO_REGISTRASI = :noreg AND  a.NO_TRS = :notrskasir";
            } elseif ($data['kodereg'] == 'RI') {
                $query = "SELECT TipePembayaran,TotalBayar as TotalPaid FROM RawatInapSQL.dbo.DepositDetails Where IDDeposit=:id";
            } else {
                $pasing['No'] = '';
                $pasing['TipePembayaran'] = '';
                $pasing['TotalPaid'] = '';
                $rows[] = $pasing;
                return $rows;
            }

            $this->db->query($query);
            $this->db->bind('noreg', $data['NoRegistrasi']);
            $this->db->bind('notrskasir', $data['notrs']);
            $data =  $this->db->resultSet();

            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['TipePembayaran'] = $key['TIPE_PEMBAYARAN'];
                $pasing['TotalPaid'] = number_format($key['NOMINAL_BAYAR'], 0, ',', '.');
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    public function cekEmateraibyNoTRS($data)
    {
        try {
            $this->db->transaksi();

            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $useridx = $session->IDEmployee;

            // DATA PASING
            $notrs = $data['notrs'];

            // var_dump($notrs);
            // exit;

            $this->db->query("SELECT COUNT(id) AS totalcek FROM Billing_Pasien.dbo.TDocumentBillingPatients WHERE NoTrs_Reff = :notrs AND EmateraiDocuments IS NOT NULL AND ActiveDocument = '1'");

            $this->db->bind('notrs', $notrs);
            $dataLinkTemp =  $this->db->single();
            $dataLink = $dataLinkTemp['totalcek'];

            // var_dump($dataLink);
            // exit;

            // $this->db->execute();

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
                'link_response' => $dataLink,
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function UpdateAlasanSendEmail($data)
    {
        try {
            $this->db->transaksi();

            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $useridx = $session->IDEmployee;

            // DATA PASING
            $notrs = $data['notrs'];
            $email = $data['email'];
            $Alasan_Cetak = $data['Alasan_Cetak'];
            $NoRegistrasi = $data['NoRegistrasi'];
            $jeniscetakan = $data['jeniscetakan'];
            // $uuid4 = $data['uuid4'];

            // var_dump($data);
            // exit;

            $query = "SELECT Count(a.ID) as CetakanKe
            FROM Billing_Pasien.dbo.TDocumentBillingPatients a
			inner join Billing_Pasien.dbo.TDocumentHistoryBillingPatients b on a.DocTransactionID=b.DocTransactionID
            where NoTrs_Reff=:notrs AND GrupTransaksi=:jeniscetakan AND NoRegistrasi=:noregistrasi";
            $this->db->query($query);
            $this->db->bind('notrs', $notrs);
            $this->db->bind('jeniscetakan', $jeniscetakan);
            $this->db->bind('noregistrasi', $NoRegistrasi);
            $datas =  $this->db->single();

            $CetakanKe = $datas['CetakanKe'] + 1;

            $this->db->query("SELECT DocTransactionID,EmateraiDocuments FROM Billing_Pasien.dbo.TDocumentBillingPatients WHERE NoTrs_Reff = :notrs AND EmateraiDocuments IS NOT NULL AND ActiveDocument = '1'");

            $this->db->bind('notrs', $notrs);
            $dataLinkTemp =  $this->db->single();
            $dataLink = $dataLinkTemp['DocTransactionID'];
            $dataEmaterai = $dataLinkTemp['EmateraiDocuments'];

            // var_dump($dataLink);
            // exit;

            $query = "INSERT INTO  Billing_Pasien.dbo.TDocumentHistoryBillingPatients (DocTransactionID,CetakanKe,Alasan_Cetak,UserCreate,DateCreate,SendEmailTo)
                Values
            (:uuid,:CetakanKe,:Alasan_Cetak,:userlogin,:datenowcreate,:email)";
            $this->db->query($query);
            $this->db->bind('uuid', $dataLink);
            $this->db->bind('CetakanKe', $CetakanKe);
            $this->db->bind('Alasan_Cetak', $Alasan_Cetak);
            $this->db->bind('userlogin', $userid);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('email', $email);

            $this->db->execute();
            // $this->db->execute();
            // var_dump($dataEmaterai);
            // exit;
            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
                'link_response' => $dataLink,
                'link_response' => $dataEmaterai,
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function getDataCetakDocumentPDF($data)
    {
        try {
            $this->db->transaksi();

            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $useridx = $session->IDEmployee;

            // DATA PASING
            $NoMR = $data['nomr'];
            $noreg = $data['noreg'];
            $pkuitansi_notrs = $data['pkuitansi_notrs'];

            // var_dump($pkuitansi_notrs);exit;
            // $notrs = $data['notrs'];
            // $alasanBtlPayment = $data['alasanBtlPayment'];

            $this->db->query("SELECT count (EmateraiDocuments) as jumlah FROM Billing_Pasien.dbo.TDocumentBillingPatients WHERE NoRegistrasi = :noreg and NoTrs_Reff=:pkuitansi_notrs and ActiveDocument='1'");

            $this->db->bind('noreg', $noreg);
            $this->db->bind('pkuitansi_notrs', $pkuitansi_notrs);

            $dataLinkTemp =  $this->db->single();
            // $dataLink = $dataLinkTemp['EmateraiDocuments'];
            $datajumlah = $dataLinkTemp['jumlah'];

            $this->db->query("SELECT EmateraiDocuments FROM Billing_Pasien.dbo.TDocumentBillingPatients WHERE NoRegistrasi = :noreg and NoTrs_Reff=:pkuitansi_notrs and ActiveDocument='1'");

            $this->db->bind('noreg', $noreg);
            $this->db->bind('pkuitansi_notrs', $pkuitansi_notrs);

            $dataLinkTemp =  $this->db->single();
            $dataLink = $dataLinkTemp['EmateraiDocuments'];
            // $datajumlah = $dataLinkTemp['jumlah'];
            // var_dump($dataLink);
            // exit;

            // $this->db->execute();

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Transaksi Berhasi',
                'link_response' => $dataLink,
                'link_jumlah' => $datajumlah,

            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    //bridging materai

    public function IncludePaket($data)
    {
        try {

            // var_dump('Masih Tahap Perbaikan');
            // exit;

            $this->db->transaksi();
            $notrsbill = $data['Idbilling']; 
 

                // UPDATE FO

                $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING SET 
                TOTAL_TARIF='0', SUBTOTAL='0', SUBTOTAL_2='0',
                GRANDTOTAL='0'
                WHERE NO_TRS_BILLING = :notrsbill1a");
                $this->db->bind('notrsbill1a', $notrsbill); 
                $this->db->execute(); 

                // UPDATE FO_2
                $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_2 SET 
                 NILAI_TARIF='0', SUB_TOTAL='0', SUB_TOTAL_2='0', NILAI_PDP='0' 
                WHERE NO_TRS_BILLING = :notrsbill2 "); 
                $this->db->bind('notrsbill2', $notrsbill); 
                $this->db->execute();

                // UPDATE FO_1
                $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 SET 
                NILAI_TARIF='0', SUB_TOTAL='0', SUB_TOTAL_2='0',  
                GRANDTOTAL='0', KEKURANGAN='0',KLAIM='0'
                WHERE NO_TRS_BILLING = :notrsbill1 "); 
                $this->db->bind('notrsbill1', $notrsbill); 
                $this->db->execute();
 

            $this->db->commit();
            $callback = array(
                'status' => "success",
                'message' => "Billing berhasil di Rubah !", // Set array nama 

            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
//edit paket MCU
    public function getPaketMCUbyNoreg($data)
    {
        try {
            $noreg = $data['noreg'];
            $query = "SELECT * from MedicalRecord.dbo.MR_PaketMCU 
                where NoRegistrasi=:noreg ";

            $this->db->query($query);
            $this->db->bind('noreg', $noreg);
            $this->db->execute();
            $data = $this->db->single();

            $callback = array(
                'message' => "success", // Set array nama 
                'IDMCU' => $data['IDMCU'],
                'IDPaket' => $data['IDPaket'],
                'NamaPaket' => $data['NamaPaket'],
                'Tarif' => $data['Harga'],
                'Lock' => $data['Lock'],
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
    public function getDataApprovePaketMCU($data)
    {
        try {
            $noreg = $data['noreg'];
            $tglawal = $data['tglawal'];
            $tglakhir = $data['tglakhir'];
            $substr = substr($noreg, 0, 2);

            $namapaket = $data['namapaket'];

            // Start Data Approve
            $query = "SELECT * FROM PerawatanSQL.dbo.Tarif_MCU where NamaPaket =:namapaket AND Header='0' order by LokasiPemeriksaan";
            $this->db->query($query);
            $this->db->bind('namapaket', $namapaket);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                // $pasing['ID'] = $key['ID'];
                $pasing['Pemeriksaan'] = $key['Pemeriksaan'];
                $pasing['LokasiPemeriksaan'] = $key['LokasiPemeriksaan'];
                $pasing['Keterangan'] = $key['Keterangan'];
                $pasing['Tarif'] = $key['Tarif'];
                //$rows[] = $pasing;
                $rows[] = $pasing;
            }
            // var_dump($rows);
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    public function goApprovePaketMCU($data)
    {
        try {
            $this->db->transaksi();

            date_default_timezone_set('Asia/Jakarta');
            $idpaketmcutext = $data['IDPaketTarif'];

            $namapaketmcutext = $data['namapaket'];
            $tarifpakettext = $data['HargaPaket'];
            $noMrPaketMCU = $data['NoMR'];
            $noepisodePaketMCU = $data['NoEpisode'];
            $noregistrasipaketmcu = $data['NoRegistrasi'];
            $IdDokterMCUx = $data['IDDokter'];
            $namadokterMCUx = $data['Dokter'];

            $getREG = substr($noregistrasipaketmcu, 0, 2);


            $NamapasienMCUxx = $data['NamaPasien'];

            $jaminanxx = $data['Penjamin']; //IDJPK/IDAUSRANSI
            $jenisbayarMCUx = $data['TypePatientID']; //patienttype
            $idpoliMCUx = $data['IDUnit']; //IDNUIT
            $namapolimcux = $data['Unit'];
            // $num_rad =$data['num_rad'];

            $idmax_labid = '';
            $idno_urutantbllablis = '';
            //    $xhrFirstName=$_SESSION['xhrFirstName'];
            //    $NoPIN=$_SESSION['xhrNoPIN'];

            if ($jenisbayarMCUx == "1") {
                $jenisbayarMCUxxd = "PRIBADI";
            } elseif ($jenisbayarMCUx == "2") {
                $jenisbayarMCUxxd = "ASURANSI";
            } elseif ($jenisbayarMCUx == "5") {
                $jenisbayarMCUxxd = "PERUSAHAAN";
            }

            $session = SessionManager::getCurrentSession();
            $useridx = $session->username;
            $token = $session->token;
            $namauserx = $session->name;

            $idmax_mcu = $data['IDPaketMCU'];
            $TempIDMCu = "MCU" . $idmax_mcu;


            $datenowcreate = Utils::seCurrentDateTime();
            $datenowcreate1 = date('Y-m-d', strtotime($datenowcreate));
            $datenowcreate2 = date('dmy', strtotime($datenowcreate));

            $datebill = $data['TglMasuk'];
            $datebills  = date('dmy', strtotime($datebill));
            $datenowcreatex =  $datebill . ' 00:00:00';

            $kelas = NULL;

            if ($data['IDUnit'] == '1') {
                $kelas = '2';
            } else {
                $kelas = '3';
            }

            $query = "SELECT Gander, Address AS alamat, Date_of_birth FROM MasterdataSQL.dbo.Admision WHERE NoMR = :noMrPaketMCU";
            $this->db->query($query);
            $this->db->bind('noMrPaketMCU', $noMrPaketMCU);
            $this->db->execute();
            $data = $this->db->single();
            $jeniskelaminxx = $data['Gander'];
            $alamatxx = $data['alamat'];
            $tgllahirxx = $data['Date_of_birth']; //dob

            if ($jeniskelaminxx == "L") {
                $jeniskelaminxxD = "M";
            } elseif ($jeniskelaminxx == "P") {
                $jeniskelaminxxD = "F";
            }


            if ($getREG == 'RJ') {
                $this->db->query("SELECT  TOP 1 NO_TRS_BILLING,right( REPLACE(NO_TRS_BILLING,'-','0')  ,5) as urut FROM Billing_Pasien.dbo.FO_T_BILLING  WHERE replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-')=:datenow2  ORDER BY urut DESC");
                $this->db->bind('datenow2', $datebill);
                $datax =  $this->db->single();
                //no urut reg
                $nexturut = $datax['urut'];
                $nexturut++;
                $nourutfix = Utils::generateAutoNumber($nexturut);
                $kodeawal = "BIL";
                $notrsbill = $kodeawal . $datebills . $nourutfix;

                // $dataLabnumber = $idno_urutantbllablis;

                $this->db->query("SELECT COUNT(*) as FOBILLING1 FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE ID_BILL = :idmcupaket AND NO_REGISTRASI = :noregw AND GROUP_ENTRI = 'PAKETMCU' AND Batal = '0'");
                $this->db->bind('idmcupaket', $idmax_mcu);
                $this->db->bind('noregw', $noregistrasipaketmcu);
                $datafo =  $this->db->single();
                $datafoo = $datafo['FOBILLING1'];

                $datenowcreatex1 = $datenowcreatex;
            }
            if ($getREG == 'RI') {
                $this->db->query("SELECT  TOP 1 NO_TRS_BILLING,right( REPLACE(NO_TRS_BILLING,'-','0')  ,5) as urut FROM Billing_Pasien.dbo.FO_T_BILLING  WHERE replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-')=:datenow2  ORDER BY urut DESC");
                $this->db->bind('datenow2', $datenowcreate1);
                $datax =  $this->db->single();
                //no urut reg
                $nexturut = $datax['urut'];
                $nexturut++;
                $nourutfix = Utils::generateAutoNumber($nexturut);
                $kodeawal = "BIL";
                $notrsbill = $kodeawal . $datenowcreate2 . $nourutfix;

                $dataLabnumber = $idno_urutantbllablis;


                $this->db->query("SELECT COUNT(*) as FOBILLING1 FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE ID_BILL = :idmcupaket AND NO_REGISTRASI = :noregw AND GROUP_ENTRI = 'PAKETMCU' AND Batal = '0'");
                $this->db->bind('idmcupaket', $idmax_mcu);
                $this->db->bind('noregw', $noregistrasipaketmcu);
                $datafo =  $this->db->single();
                $datafoo = $datafo['FOBILLING1'];
                $datenowcreatex1 = $datenowcreate;
                // $datenowcreatex1 = $datenowcreatex;
            }

            if ($datafoo == "0") {
                //GET Data from tabel visit

                if ($getREG == 'RJ') {
                    $this->db->query("SELECT  Unit,PatientType,case when PatientType='2' then Asuransi else Perusahaan end as perusahaanid FROM PerawatanSQL.dbo.Visit  WHERE NoRegistrasi=:NoRegistrasi
                    ");
                    $this->db->bind('NoRegistrasi', $noregistrasipaketmcu);
                    $datax =  $this->db->single();
                    $IdGrupPerawatan = $datax['Unit'];
                    $JenisBayar = $datax['PatientType'];
                    $perusahaanid = $datax['perusahaanid'];
                }
                //Get Data Inpatient
                if ($getREG == 'RI') {
                    $this->db->query("SELECT b.ID, a.TypePatient, case when a.TypePatient='2' then a.IDAsuransi else a.IDJPK end as perusahaanid 
                    FROM RawatInapSQL.dbo.Inpatient a 
                    INNER JOIN MasterdataSQL.dbo.MstrUnitPerwatan b ON b.NamaUnit = a.JenisRawat
                    WHERE NoRegRI = :NoRegistrasi");
                    $this->db->bind('NoRegistrasi', $noregistrasipaketmcu);
                    $datax =  $this->db->single();
                    $IdGrupPerawatan = $datax['ID'];
                    $JenisBayar = $datax['TypePatient'];
                    $perusahaanid = $datax['perusahaanid'];
                }


                // insert ke tabel FO_T_Billing
                $this->db->query("INSERT INTO Billing_Pasien.dbo.FO_T_BILLING
                ([NO_TRS_BILLING],[TGL_BILLING],[PETUGAS_ENTRY],[NO_MR],[NO_EPISODE],[NO_REGISTRASI],[UNIT],[GROUP_JAMINAN],[KODE_JAMINAN],[TOTAL_TARIF],[TOTAL_QTY],[SUBTOTAL],[TOTAL_DISCOUNT],[TOTAL_DISCOUNT_RP],[SUBTOTAL_2],[GRANDTOTAL],[BATAL],[FB_CLOSE_KEUANGAN],[FB_VERIF_JURNAL]) 
                VALUES
                (:notrsbill,:datenowx,:namauserx,:NoMrfix,:NoEpisode,:nofixReg,:IdGrupPerawatan,:JenisBayar,:perusahaanid,:totaltarif,:totalqty,:subtotal,:totaldiscount,:totaldiscountrp,:subtotal2,:grandtotal,:batal,:closekeuangan,:verifkeuangan)");

                $this->db->bind('notrsbill', $notrsbill);
                $this->db->bind('datenowx', $datenowcreatex1);
                $this->db->bind('namauserx', $namauserx);
                $this->db->bind('NoMrfix', $noMrPaketMCU);
                $this->db->bind('NoEpisode', $noepisodePaketMCU);
                $this->db->bind('nofixReg', $noregistrasipaketmcu);
                $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                $this->db->bind('JenisBayar', $JenisBayar);
                $this->db->bind('perusahaanid', $perusahaanid);
                $this->db->bind('totaltarif', $tarifpakettext);
                $this->db->bind('totaltarif', 0);
                $this->db->bind('totalqty', 0);
                // $this->db->bind('subtotal', 0);
                $this->db->bind('subtotal', $tarifpakettext);
                $this->db->bind('totaldiscount', 0);
                $this->db->bind('totaldiscountrp', 0);
                // $this->db->bind('subtotal2', 0);
                // $this->db->bind('grandtotal', 0);
                $this->db->bind('subtotal2', $tarifpakettext);
                $this->db->bind('grandtotal', $tarifpakettext);
                $this->db->bind('batal', 0);
                $this->db->bind('closekeuangan', 0);
                $this->db->bind('verifkeuangan', 0);
                $this->db->execute();
            } else {
                $callback = array(
                    'status' => "error",
                    'message' => "Order Ini Sudah Ditambahkan atau Sudah Di approve",
                );
                return $callback;
                exit;
            }

            $this->db->query("SELECT COUNT(*) as FOBILLING1a FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE ID_TR_TARIF_PAKET = :idmcupaketuniq AND NO_REGISTRASI = :noregw AND GROUP_ENTRI = 'PAKETMCU' AND Batal = '0'");
            $this->db->bind('idmcupaketuniq', $idmax_mcu);
            $this->db->bind('noregw', $noregistrasipaketmcu);
            // $this->db->bind('kodetestuniq', $kodetest)0;
            // $this->db->bind('labdetailuniq2', $datalabiddetail);
            $datafo1 =  $this->db->single();
            $datafoo1 = $datafo1['FOBILLING1a'];

            if ($datafoo1 == '0') {

                // insert ke tabel FO_T_Billing_1
                $this->db->query("INSERT INTO Billing_Pasien.dbo.FO_T_BILLING_1
                (ID_BILL,[NO_TRS_BILLING],[TGL_BILLING] ,[PETUGAS_ENTRY],[NO_MR],[NO_EPISODE],[NO_REGISTRASI],[KODE_TARIF],[UNIT],[GROUP_JAMINAN],[KODE_JAMINAN],[NAMA_TARIF],[GROUP_TARIF],[KD_KELAS],[QTY],[NILAI_TARIF],[SUB_TOTAL],[DISC],[DISC_RP],[SUB_TOTAL_2],[GRANDTOTAL],[KODE_REF],[KD_DR],[NM_DR],[BATAL],[PETUGAS_BATAL],[GROUP_ENTRI],
                [BAYAR], [KLAIM], [KEKURANGAN], [ID_TR_TARIF_PAKET])
                SELECT '$idmax_mcu','$notrsbill' , '$datenowcreatex1' as datenow,'$namauserx' as namauserx,'$noMrPaketMCU' AS NoMR, '$noepisodePaketMCU' AS xNoEpisode,'$noregistrasipaketmcu' as NoReg,IDMCU,
                '$IdGrupPerawatan','$JenisBayar','$perusahaanid', CASE
                WHEN Keterangan IS NOT NULl AND Pemeriksaan IS NOT NULL THEN Keterangan
                WHEN Keterangan IS NULL AND Pemeriksaan IS NOT NULL THEN Pemeriksaan
                ELSE NamaPaket END AS Keterangan, CASE 
                WHEN LokasiPemeriksaan = 'RADIOLOGI' THEN 'Radiologi' 
                WHEN LokasiPemeriksaan = 'LABORATORIUM' THEN 'Laboratorium' 
                ELSE 'Administrasi' END AS lab, '$kelas', 1 as Qty, case WHEN Header = '1' then Tarif ELSE 0 END AS Tarif, case WHEN Header = '1' then Tarif ELSE 0 END AS Tarif, 0, 0, case WHEN Header = '1' then Tarif ELSE 0 END AS Tarif, case WHEN Header = '1' then Tarif ELSE 0 END AS Tarif,IdTes, '$IdDokterMCUx', '$namadokterMCUx', 0 as batal,null as petugasbatal,'PAKETMCU',
                '0', (CASE WHEN '$JenisBayar' = '1' THEN ('0') WHEN '$JenisBayar' != '1' AND Header = '1' THEN Tarif  ELSE ('0') END) Nilai_Klaim, 
        (CASE WHEN '$JenisBayar' = '1' AND Header = '1' THEN Tarif WHEN '$JenisBayar' != '1' THEN ('0') ELSE ('0') END) Nilai_KEKURANGAN, '$idmax_mcu'
                FROM PerawatanSQL.dbo.Tarif_MCU  WHERE NamaPaket = :namapaketmcutext");
                // $this->db->bind('Lab_NoLab', $dataLabnumber);
                $this->db->bind('namapaketmcutext', $namapaketmcutext);
                $this->db->execute();

                //Insert ke tabel FO_T_Billing_2 JASA
                $this->db->query("INSERT INTO Billing_Pasien.DBO.FO_T_BILLING_2
                   SELECT 'idmax_mcu' as ID_BILL,A.NO_TRS_BILLING AS NO_TRS_BILLING,A1.KODE_TARIF,B.KD_TIPE_Jasa as Kode_komponen,A1.UNIT AS UNIT, A1.GROUP_JAMINAN AS GROUP_JAMINAN, A1.KODE_JAMINAN AS KODE_JAMINAN, 
                   A1.NAMA_TARIF AS NAMA_TARIF, 
                   A1.GROUP_TARIF AS GROUP_TARIF, A1.KD_KELAS as KELAS,A1.QTY AS QTY, 
                   A1.NILAI_TARIF AS NILAI_TARIF  ,
                   A1.NILAI_TARIF*A1.QTY  AS SUBTOTAL,
                   A1.DISC AS DISC,
                   --(A1.NILAI_TARIF-((A1.NILAI_TARIF*A1.DISC)/100)) AS DISC_RP,
                   (A1.NILAI_TARIF - (A1.NILAI_TARIF * (1 - A1.DISC))) AS DISC_RP,
                   --((A1.NILAI_TARIF*A1.QTY)-(((A1.NILAI_TARIF*A1.QTY)*A1.DISC)/100))   SUB_TOTAL_PDP_2,
                   (CASE WHEN CX.KD_JENIS_JASA='PROSEN'  THEN (((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY)-(((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*DISC)/100))   WHEN  CX.KD_JENIS_JASA='FIX' THEN (b.NILAI_FIX*A1.QTY)-((b.NILAI_FIX*A1.QTY*DISC)/100)*A1.QTY END ) as SUB_TOTAL_PDP_2,
                   (CASE WHEN CX.KD_JENIS_JASA='PROSEN'  THEN ((((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*DISC)/100))   WHEN  CX.KD_JENIS_JASA='FIX' THEN ((b.NILAI_FIX*A1.QTY*DISC)/100)*A1.QTY END ) NILAI_DISKON_PDP,
                   (CASE WHEN CX.KD_JENIS_JASA='PROSEN'  THEN (((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY)-(((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*DISC)/100))   WHEN  CX.KD_JENIS_JASA='FIX' THEN (b.NILAI_FIX*A1.QTY)-((b.NILAI_FIX*A1.QTY*DISC)/100)*A1.QTY END ) as NILAI_PDP,
                   A1.KD_DR AS KD_DR, '' NM_DR,b.NILAI_PROSEN,'0' AS BATAL,'' PETUGAS_BATAL, '' AS JAM_BATAL, B.KD_POSTING AS KD_POSTING, b.KD_POSTING_DISC as kd_posting_diskon,CC.IDMCU
                   FROM Billing_Pasien.DBO.FO_T_BILLING A
                   inner join Billing_Pasien.dbo.FO_T_BILLING_1 A1
                   ON A.NO_TRS_BILLING = A1.NO_TRS_BILLING
                   LEFT JOIN PerawatanSQL.dbo.Tarif_MCU CC 
                    ON CC.IDMCU = A1.KODE_TARIF AND CC.NamaPaket = :namapaketmcutext
                   INNER JOIN Keuangan.DBO.BO_M_JASA2 B
                   ON CC.KD_JASA collate SQL_Latin1_General_CP1_CI_AS = B.KD_JASA collate SQL_Latin1_General_CP1_CI_AS
                   INNER JOIN Keuangan.DBO.BO_M_JASA CX
                   ON CX.KD_JASA = B.KD_JASA
                   WHERE A1.GROUP_ENTRI='PAKETMCU' and a.BATAL='0' and A1.BATAL='0' and a.NO_TRS_BILLING=:notrsbill and
                   A1.KODE_TARIF not in (select KODE_TARIF from Billing_Pasien.dbo.FO_T_BILLING_2 where NO_TRS_BILLING=:notrsbill2 and Batal='0')");
                $this->db->bind('notrsbill', $notrsbill);
                //$this->db->bind('idmax_mcu', $idmax_mcu);
                $this->db->bind('notrsbill2', $notrsbill);
                $this->db->bind('namapaketmcutext', $namapaketmcutext);
                $this->db->execute();

                //Insert ke tabel FO_T_Billing_2 PDP
                $this->db->query("INSERT INTO Billing_Pasien.DBO.FO_T_BILLING_2
                SELECT 'idmax_mcu' as ID_BILL,A.NO_TRS_BILLING AS NO_TRS_BILLING,A1.KODE_TARIF,B.KD_TIPE_PDP as Kode_komponen,A1.UNIT AS UNIT, A1.GROUP_JAMINAN AS GROUP_JAMINAN, A1.KODE_JAMINAN AS KODE_JAMINAN, 
                A1.NAMA_TARIF AS NAMA_TARIF, 
                A1.GROUP_TARIF AS GROUP_TARIF, A1.KD_KELAS as KELAS,A1.QTY AS QTY, 
                A1.NILAI_TARIF AS NILAI_TARIF  ,
                A1.NILAI_TARIF*A1.QTY  AS SUBTOTAL,
                A1.DISC AS DISC,
                --(A1.NILAI_TARIF-((A1.NILAI_TARIF*A1.DISC)/100)) AS DISC_RP,
                (A1.NILAI_TARIF - (A1.NILAI_TARIF * (1 - A1.DISC))) AS DISC_RP,
                --((A1.NILAI_TARIF*A1.QTY)-(((A1.NILAI_TARIF*A1.QTY)*A1.DISC)/100))   SUB_TOTAL_PDP_2,
                (CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN (((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY)-(((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' THEN (b.NILAI_FIX*A1.QTY)-((b.NILAI_FIX*A1.QTY*DISC)/100)*A1.QTY END ) as SUB_TOTAL_PDP_2,
                (CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN ((((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' THEN ((b.NILAI_FIX*A1.QTY*DISC)/100)*A1.QTY END ) NILAI_DISKON_PDP,
                (CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN (((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY)-(((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' THEN (b.NILAI_FIX*A1.QTY)-((b.NILAI_FIX*A1.QTY*DISC)/100)*A1.QTY END ) as NILAI_PDP,
                A1.KD_DR AS KD_DR, '' NM_DR,b.NILAI_PROSEN,'0' AS BATAL,'' PETUGAS_BATAL, '' AS JAM_BATAL, B.KD_POSTING AS KD_POSTING, b.KD_POSTING_DISC as kd_posting_diskon,CC.IDMCU
                FROM Billing_Pasien.DBO.FO_T_BILLING A
                inner join Billing_Pasien.dbo.FO_T_BILLING_1 A1
                ON A.NO_TRS_BILLING = A1.NO_TRS_BILLING
                LEFT JOIN PerawatanSQL.dbo.Tarif_MCU CC 
                 ON CC.IDMCU = A1.KODE_TARIF AND CC.NamaPaket = :namapaketmcutext
                --INNER JOIN PerawatanSQL.dbo.Tarif_MCU d ON A1.NAMA_TARIF collate SQL_Latin1_General_CP1_CI_AS= d.Pemeriksaan AND d.NamaPaket = :namapaketmcutext
                INNER JOIN Keuangan.DBO.BO_M_PDP2 B
                ON CC.KD_PDP collate SQL_Latin1_General_CP1_CI_AS = B.KD_PDP collate SQL_Latin1_General_CP1_CI_AS
                INNER JOIN Keuangan.DBO.BO_M_PDP CX
                ON CX.KD_PDP = B.KD_PDP
                WHERE A1.GROUP_ENTRI='PAKETMCU' and a.BATAL='0' and A1.BATAL='0' and a.NO_TRS_BILLING=:notrsbill and KD_TIPE_PDP = 'RS01' AND
                A1.KODE_TARIF not in (select KODE_TARIF from Billing_Pasien.dbo.FO_T_BILLING_2 where NO_TRS_BILLING=:notrsbill2 and Batal='0')");
                $this->db->bind('notrsbill', $notrsbill);
                //$this->db->bind('idmax_mcu', $idmax_mcu);
                $this->db->bind('notrsbill2', $notrsbill);
                $this->db->bind('namapaketmcutext', $namapaketmcutext);
                $this->db->execute();

                //UPDATE TOTAL KE FO_T_BILLING
                //mati sementara
                $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_BILLING
                SET TOTAL_TARIF=B.SUM_NILAI_TARIF,TOTAL_QTY=B.SUM_QTY,SUBTOTAL=B.SUM_SUB_TOTAL,SUBTOTAL_2=B.SUM_SUB_TOTAL_2,GRANDTOTAL=B.SUM_GRANDTOTAL,
                FB_VERIF_JURNAL='0' 
                FROM Billing_Pasien.DBO.FO_T_BILLING A 
                INNER JOIN
                (
                    SELECT  NO_TRS_BILLING,SUM(NILAI_TARIF) AS SUM_NILAI_TARIF,SUM(QTY) AS SUM_QTY,SUM(SUB_TOTAL) AS SUM_SUB_TOTAL,SUM(SUB_TOTAL_2) AS SUM_SUB_TOTAL_2,
                    SUM(GRANDTOTAL) AS SUM_GRANDTOTAL
                    FROM Billing_Pasien.DBO.FO_T_BILLING_1
                    WHERE NO_REGISTRASI=:noreg and Batal='0'
                    GROUP BY NO_TRS_BILLING
                ) B
                ON A.NO_TRS_BILLING = B.NO_TRS_BILLING
                WHERE A.NO_REGISTRASI=:noreg2 AND A.NO_TRS_BILLING=:notrsbill
                ");
                $this->db->bind('noreg', $noregistrasipaketmcu);
                $this->db->bind('noreg2', $noregistrasipaketmcu);
                $this->db->bind('notrsbill', $notrsbill);
                $this->db->execute();
            } else {
                $callback = array(
                    'status' => "warning",
                    'message' => "Order Ini Sudah Ditambahkan atau Sudah Di approvex",
                );
                return $callback;
                exit;
            }


            $this->db->query("INSERT INTO SysLog.dbo.TZ_Log_Button
            (noregistrasi, nama_biling, petugas_entry, tgl_entry, idtrs)
            VALUES (:NoRegRecord, 'APPROVE PAKET MCU', :USER_KASIRRecord, :TGL_TRSRecord, :trscoderecord)");
            $this->db->bind('NoRegRecord', $noregistrasipaketmcu);
            $this->db->bind('USER_KASIRRecord', $namauserx);
            $this->db->bind('TGL_TRSRecord', $datenowcreate);
            $this->db->bind('trscoderecord', $idmax_mcu);
            $this->db->execute();

            // var_dump($notrsbill);
            // var_dump($datafoo);
            // exit;
            //#END ORDER LAB----------------------------

            //#END UNIT MCU WITH PACSORDER------------------
            $this->db->commit();

            $callback = array(
                'status' => "success",
                'message' => "Paket " . $namapaketmcutext . " berhasil Diapprove !" // Set array nama 
                // 'NoEpisode' => $noepisodePaketMCU,
                // 'namapaketmcutext' => $namapaketmcutext,
                // 'NolisOrder' => $idno_urutantbllablis,
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


    public function goBatalApprovePaketMCU($data)
    {
        try {
            $this->db->transaksi();

            date_default_timezone_set('Asia/Jakarta');
            $idpaketmcutext = $data['IDPaketTarif'];
            $namapaketmcutext = $data['namapaket'];
            $tarifpakettext = $data['HargaPaket'];
            $noMrPaketMCU = $data['NoMR'];
            $noepisodePaketMCU = $data['NoEpisode'];
            $noregistrasipaketmcu = $data['NoRegistrasi'];
            $IdDokterMCUx = $data['IDDokter'];
            $namadokterMCUx = $data['Dokter'];
            $getREG = substr($noregistrasipaketmcu, 0, 2);
            $NamapasienMCUxx = $data['NamaPasien'];
            $jaminanxx = $data['Penjamin']; //IDJPK/IDAUSRANSI
            $jenisbayarMCUx = $data['TypePatientID']; //patienttype
            $idpoliMCUx = $data['IDUnit']; //IDNUIT
            $namapolimcux = $data['Unit'];

            $TRIGGER_DTTM = date('YmdHis');
            // $num_rad =$data['num_rad'];
            $idmax_labid = '';
            $idno_urutantbllablis = '';
            if ($jenisbayarMCUx == "1") {
                $jenisbayarMCUxxd = "PRIBADI";
            } elseif ($jenisbayarMCUx == "2") {
                $jenisbayarMCUxxd = "ASURANSI";
            } elseif ($jenisbayarMCUx == "5") {
                $jenisbayarMCUxxd = "PERUSAHAAN";
            }
            $session = SessionManager::getCurrentSession();
            $useridx = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $idmax_mcu = $data['IDPaketMCU'];
            $TempIDMCu = "MCU" . $idmax_mcu;
            $datenowcreate = Utils::seCurrentDateTime();
            $datenowcreate1 = date('Y-m-d', strtotime($datenowcreate));
            $datenowcreate2 = date('dmy', strtotime($datenowcreate));
            $datebill = $data['TglMasuk'];
            $datebills  = date('dmy', strtotime($datebill));
            $datenowcreatex =  $datebill . ' 00:00:00';
            $kelas = NULL;
            //23-12-2024 0:42 alim

            $this->db->query("SELECT count(*) as hasilReceive
            FROM LaboratoriumSQL.DBO.tblLab
            WHERE  NoRegRI=:noregistrasipaketmcu and Receive_st='1' AND Batal = '0'");
            $this->db->bind('noregistrasipaketmcu', $noregistrasipaketmcu);
            $datahasillab =  $this->db->single();
            $hasilReceive = $datahasillab['hasilReceive'];

            if ($hasilReceive == '1') {
                $callback = array(
                    'status' => "warning",
                    'errorname' => "Tidak Bisa Dibatalkan Karena Sudah Di Proses Lab !",
                );
                return $callback;
                exit;
            }

            $this->db->query("SELECT count(*) as hasilvalidasi
            FROM LaboratoriumSQL.DBO.LIS_Order
            WHERE  NoRegistrasi=:noregistrasipaketmcu and DT_Validasi is not null AND status_ts = '0'");
            $this->db->bind('noregistrasipaketmcu', $noregistrasipaketmcu);
            $datahasillabo =  $this->db->single();
            $hasilvalidasi = $datahasillabo['hasilvalidasi'];

            if ($hasilvalidasi == '1') {
                $callback = array(
                    'status' => "warning",
                    'errorname' => "Tidak Bisa Dibatalkan Karena Sudah Ada Hasil Lab !",
                );
                return $callback;
                exit;
            }

            //BATAL RADIOLOGY BADRUL
            $query = "SELECT WOID FROM RadiologiSQL.dbo.WO_RADIOLOGY where NOREGISTRASI=:noregistrasipaketmcu and PATIENT_LOCATION='MCU' AND Batal='0'";
            $this->db->query($query);
            $this->db->bind('noregistrasipaketmcu', $noregistrasipaketmcu);
            $this->db->execute();
            $datalabpaket =  $this->db->resultSet();
            // $rows = array();
            $tod = json_decode(json_encode((object) $datalabpaket), FALSE);
            foreach ($tod as $datawo) {

                foreach ($datawo as $dt) {

                    $this->db->query("SELECT COUNT(ID) AS CEK1payment FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE GROUP_ENTRI = 'RADIOLOGI' AND KODE_REF = :dataref12 AND ID_TRS_Payment IS NOT NULL");
                    $this->db->bind('dataref12', $dt);
                    $data_CEKpayment =  $this->db->single();
                    $CEKpayment = $data_CEKpayment['CEK1payment'];

                    if ($CEKpayment != '0') {
                        $callback = array(
                            'status' => "warning",
                            'message' => "GAGAL BATAL APPROVE ALL, Karena Ada Orderan Yang Sudah Di Payment!",
                        );
                        return $callback;
                        exit;
                    }

                    $this->db->query("SELECT ACCESSION_NO FROM RadiologiSQL.dbo.WO_RADIOLOGY WHERE WOID = :datawoid2a");
                    $this->db->bind('datawoid2a', $dt);
                    $data_accnumber =  $this->db->single();
                    $ACC_Number = $data_accnumber['ACCESSION_NO'];

                    $this->db->query("SELECT COUNT(*) as cekRIS FROM RadiologiSQL.dbo.REPORT_RIS WHERE ACCESSION_NO = :ACC_Number");
                    $this->db->bind('ACC_Number', $ACC_Number);
                    $data_countris =  $this->db->single();
                    $COUNT_RIS = $data_countris['cekRIS'];
                    // var_dump($COUNT_RIS);
                    // exit;
                    if ($COUNT_RIS == "0") {
                        //update di visit nya
                        $this->db->query("UPDATE PerawatanSQL.dbo.Visit SET RadiologiLunas=0
                        WHERE NoRegistrasi = :noregvisit2a");
                        $this->db->bind('noregvisit2a', $noregistrasipaketmcu);
                        $this->db->execute();

                        // var_dump($TRIGGER_DTTM);
                        // exit;

                        //update ke WO_radiology nya
                        $this->db->query("UPDATE RadiologiSQL.dbo.WO_RADIOLOGY SET PaymentStatus = 0, Batal = '1', TglBatal = :TGL_TRSx, PetugasBatal = :USER_KASIRx WHERE WOID=:datawoid2a");
                        $this->db->bind('datawoid2a', $dt);
                        $this->db->bind('USER_KASIRx', $namauserx);
                        $this->db->bind('TGL_TRSx', $datenowcreate);
                        $this->db->execute();

                        //batal radiology

                        // MWLWL
                        $this->db->query("UPDATE RadiologiSQL.DBO.MWLWL 
                        SET REPLICA_DTTM = 'ANY', SCHEDULED_PROC_STATUS ='0'
                        WHERE  ACCESSION_NO=:accession_no ");
                        $this->db->bind('accession_no', $ACC_Number);
                        $this->db->execute();

                        // INSERT 
                        $this->db->query("INSERT INTO RadiologiSQL.DBO.MWLWL ( TRIGGER_DTTM, REPLICA_DTTM, EVENT_TYPE, CHARACTER_SET, SCHEDULED_AETITLE, SCHEDULED_DTTM, SCHEDULED_MODALITY, SCHEDULED_STATION, SCHEDULED_LOCATION,         SCHEDULED_PROC_ID, SCHEDULED_PROC_DESC, SCHEDULED_ACTION_CODES, SCHEDULED_PROC_STATUS, PREMEDICATION, CONTRAST_AGENT, REQUESTED_PROC_ID, REQUESTED_PROC_DESC, REQUESTED_PROC_CODES, REQUESTED_PROC_PRIORITY,        REQUESTED_PROC_REASON, REQUESTED_PROC_COMMENTS, STUDY_INSTANCE_UID, PROC_PLACER_ORDER_NO, PROC_FILLER_ORDER_NO, ACCESSION_NO, ATTEND_DOCTOR, PERFORM_DOCTOR, CONSULT_DOCTOR, REQUEST_DOCTOR, REFER_DOCTOR,      REQUEST_DEPARTMENT, IMAGING_REQUEST_REASON, IMAGING_REQUEST_COMMENTS, IMAGING_REQUEST_DTTM, ISR_PLACER_ORDER_NO, ISR_FILLER_ORDER_NO, ADMISSION_ID, PATIENT_TRANSPORT, PATIENT_LOCATION, PATIENT_RESIDENCY,      PATIENT_NAME, PATIENT_ID, OTHER_PATIENT_NAME, OTHER_PATIENT_ID, PATIENT_BIRTH_DATE, PATIENT_SEX, PATIENT_WEIGHT, PATIENT_SIZE, PATIENT_STATE, CONFIDENTIALITY, PREGNANCY_STATUS, MEDICAL_ALERTS,     CONTRAST_ALLERGIES, SPECIAL_NEEDS, SPECIALTY, DIAGNOSIS, ADMIT_DTTM, REGISTER_DTTM, [Match], ORDERCODE, EXPERTISE )
                        SELECT '$TRIGGER_DTTM', 'ANY' AS REPLICA_DTTM, EVENT_TYPE, CHARACTER_SET, SCHEDULED_AETITLE, SCHEDULED_DTTM, SCHEDULED_MODALITY, SCHEDULED_STATION, SCHEDULED_LOCATION, SCHEDULED_PROC_ID,      SCHEDULED_PROC_DESC, SCHEDULED_ACTION_CODES, '120'AS SCHEDULED_PROC_STATUS, PREMEDICATION, CONTRAST_AGENT, REQUESTED_PROC_ID, REQUESTED_PROC_DESC, REQUESTED_PROC_CODES, REQUESTED_PROC_PRIORITY,       REQUESTED_PROC_REASON, REQUESTED_PROC_COMMENTS, STUDY_INSTANCE_UID, PROC_PLACER_ORDER_NO, PROC_FILLER_ORDER_NO, ACCESSION_NO, ATTEND_DOCTOR, PERFORM_DOCTOR, CONSULT_DOCTOR, REQUEST_DOCTOR, REFER_DOCTOR,         REQUEST_DEPARTMENT, IMAGING_REQUEST_REASON, IMAGING_REQUEST_COMMENTS, IMAGING_REQUEST_DTTM, ISR_PLACER_ORDER_NO, ISR_FILLER_ORDER_NO, ADMISSION_ID, PATIENT_TRANSPORT, PATIENT_LOCATION, PATIENT_RESIDENCY,         PATIENT_NAME, PATIENT_ID, OTHER_PATIENT_NAME, OTHER_PATIENT_ID, PATIENT_BIRTH_DATE, PATIENT_SEX, PATIENT_WEIGHT, PATIENT_SIZE, PATIENT_STATE, CONFIDENTIALITY, PREGNANCY_STATUS, MEDICAL_ALERTS,        CONTRAST_ALLERGIES, SPECIAL_NEEDS, SPECIALTY, DIAGNOSIS, ADMIT_DTTM, REGISTER_DTTM, Match, ORDERCODE, EXPERTISE
                        FROM RadiologiSQL.DBO.MWLWL
                        WHERE ACCESSION_NO=:accession_no");
                        $this->db->bind('accession_no', $ACC_Number);
                        $this->db->execute();
                    } else {
                        $callback = array(
                            'status' => "warning",
                            'message' => "Order Sudah Ada Hasil !",
                        );
                        return $callback;
                        exit;
                    }
                } //2

            } //1
            // badrul
            //END BATAL PENUNJANG


            //BATAL LAB
            //23-12-2024 0:42 alim
            //BATAL PENUNJANG
            $query = "SELECT NoLAB,LabID FROM LaboratoriumSQL.DBO.tblLab WHERE  NoRegRI=:noregistrasipaketmcu and OrderCode Like '%MCU%' and OrderCode not like '%ordertambahan%' and Batal='0'";
            $this->db->query($query);
            $this->db->bind('noregistrasipaketmcu', $noregistrasipaketmcu);
            $this->db->execute();
            $datalabpaket = $this->db->single();
            $NoLAB = $datalabpaket['NoLAB'];
            $LabID = $datalabpaket['LabID'];

            $this->db->query("UPDATE LaboratoriumSQL.DBO.tblLab set Batal='1' where NoLAB=:NoLAB");
            $this->db->bind('NoLAB', $NoLAB);
            $this->db->execute();

            $this->db->query("UPDATE LaboratoriumSQL.DBO.tblLabDetail set Batal='1' where LabID=:LabID");
            $this->db->bind('LabID', $LabID);
            $this->db->execute();

            $this->db->query("UPDATE LaboratoriumSQL.DBO.LIS_Order_detail set status_ts='1' where NoLAB=:NoLAB");
            $this->db->bind('NoLAB', $NoLAB);
            $this->db->execute();

            $this->db->query("UPDATE LaboratoriumSQL.DBO.LIS_Order set is_taken='FALSE',status_ts='1' where NoLAB=:NoLAB");
            $this->db->bind('NoLAB', $NoLAB);
            $this->db->execute();
            //23-12-2024 0:42 alim


            //BATAL BILLING
            $query = "SELECT NO_TRS_BILLING from Billing_Pasien.dbo.FO_T_BILLING_1 WHERE NO_REGISTRASI =:noregistrasipaketmcu AND ID_BILL = :idmax_mcu AND NAMA_TARIF = :namapaketmcutext";
            $this->db->query($query);
            $this->db->bind('namapaketmcutext', $namapaketmcutext);
            $this->db->bind('noregistrasipaketmcu', $noregistrasipaketmcu);
            $this->db->bind('idmax_mcu', $idmax_mcu);
            $this->db->execute();
            $data = $this->db->single();
            $notrsbill = $data['NO_TRS_BILLING'];

            if ($notrsbill <> NULL) {
                //Badrul
                $this->db->query("DELETE FROM Billing_Pasien.dbo.FO_T_BILLING WHERE NO_TRS_BILLING = :notrsbill");
                $this->db->bind('notrsbill', $notrsbill);
                $this->db->execute();

                $this->db->query("DELETE FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE NO_TRS_BILLING = :notrsbill1");
                $this->db->bind('notrsbill1', $notrsbill);
                $this->db->execute();

                $this->db->query("DELETE FROM Billing_Pasien.dbo.FO_T_BILLING_2 WHERE NO_TRS_BILLING = :notrsbill2");
                $this->db->bind('notrsbill2', $notrsbill);
                $this->db->execute();
            }
            //else{
            // $callback = array(
            //     'status' => "error",
            //     'message' => "Order Ini Belum Di Approve",
            // );
            // return $callback;
            // exit;
            //}
            //23-12-2024 0:42 alim
            $this->db->query("DELETE FROM MedicalRecord.dbo.MR_PaketMCU where NoRegistrasi=:noregistrasipaketmcu");
            $this->db->bind('noregistrasipaketmcu', $noregistrasipaketmcu);
            $this->db->execute();

            $this->db->query("DELETE FROM MedicalRecord.dbo.MR_PemeriksaanMCU where NoRegistrasi=:noregistrasipaketmcu");
            $this->db->bind('noregistrasipaketmcu', $noregistrasipaketmcu);
            $this->db->execute();

            $this->db->query("DELETE FROM PerawatanSQL.dbo.[Visit Details] where NoRegistrasi=:noregistrasipaketmcu and KategoriTarif='Paket MCU'");
            $this->db->bind('noregistrasipaketmcu', $noregistrasipaketmcu);
            $this->db->execute();


            $this->db->query("UPDATE SysLog.dbo.TZ_Log_Button SET petugas_batal = :USER_KASIRRecord, alasan_batal = 'BATAL APPROVE', tgl_batal = :TGL_TRSRecord
            WHERE NoRegistrasi = :NoRegRecord AND idtrs = :dataaptk1 AND petugas_batal IS NULL");
            $this->db->bind('NoRegRecord', $noregistrasipaketmcu);
            // $this->db->bind('trscoderecord', $trscode);
            $this->db->bind('USER_KASIRRecord', $namauserx);
            $this->db->bind('TGL_TRSRecord', $datenowcreate);
            $this->db->bind('dataaptk1', $idmax_mcu);
            $this->db->execute();


            // var_dump('masuk', $TRIGGER_DTTM);
            // exit;

            // var_dump($notrsbill);
            // var_dump($datafoo);
            // exit;
            //#END ORDER LAB----------------------------

            //#END UNIT MCU WITH PACSORDER------------------
            $this->db->commit();

            $callback = array(
                'status' => "success",
                'message' => "Paket " . $namapaketmcutext . " berhasil Di Batalkan !" // Set array nama 
                // 'NoEpisode' => $noepisodePaketMCU,
                // 'namapaketmcutext' => $namapaketmcutext,
                // 'NolisOrder' => $idno_urutantbllablis,
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
    //edit paket MCU



    // generate admin
    public function generateAdministrasiRajal($data)
    {
        try {
            $this->db->transaksi();
            // DATA USER INPUT
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $useridx = $session->IDEmployee;

            // exit;
            // DATA PASING
            $noreg = $data['noregistrasi'];
            // SUM TOTAL BILL
             $this->db->query("SELECT SUM(GRANDTOTAL) AS SUM_GRANDTOTAL 
             FROM Billing_Pasien.DBO.FO_T_BILLING_1
             WHERE NO_REGISTRASI=:NO_REGISTRASI and Batal='0' and GROUP_ENTRI<>'ADMINISTRASI'");
             $this->db->bind('NO_REGISTRASI', $noreg); 
             $sumTotalBill =  $this->db->single();
             $biaya_perawatan = $sumTotalBill['SUM_GRANDTOTAL'];


              // CARI REGNYA
            $this->db->query("SELECT e.id as UNIT, a.NoMR,a.NoEpisode, '' as RoomID_Awal, a.TipePasien as TypePatient,
            '3' as KelasID,a.[Visit Date] as EndDate,'0' as Paket,
            A.KodeJaminan AS kodePenjamin,
            A.NamaJaminan AS NamaPenjamin,
            CASE WHEN A.TipePasien = '2' THEN f.Group_Jaminan ELSE fp.Group_Jaminan END AS KodegroupJaminan
            FROM DashboardData.dbo.datarwj a 
            LEFT JOIN MasterdataSQL.dbo.MstrPerusahaanAsuransi AS f ON a.KodeJaminan = f.ID 
            LEFT OUTER JOIN MasterdataSQL.dbo.MstrPerusahaanJPK AS fp ON a.KodeJaminan = fp.ID
            INNER JOIN MasterdataSQL.dbo.MstrUnitPerwatan e
			on e.id = a.IdUnit
            WHERE a.NoRegistrasi=:NO_REGISTRASI");
            $this->db->bind('NO_REGISTRASI', $noreg); 
            $detilReRAnap =  $this->db->single();
            $kelasid = $detilReRAnap['KelasID'];
            $tipepasien = $detilReRAnap['TypePatient'];
            $pasien_paket = $detilReRAnap['Paket'];
            $grup_jaminan = $detilReRAnap['KodegroupJaminan'];
            $idperusahaan = $detilReRAnap['kodePenjamin'];
            $UNIT = $detilReRAnap['UNIT'];

            

           
              
            $biaya_admin = 0.02 * $biaya_perawatan;

            // CARI ADA ADMINNNYA BELUM,
                    // JIKA ADA UPDATE KAYAK UPDATE KAMAR METODENYA
                    // JIKA BELUM YA DI INSERT
                    $datenow = Utils::seCurrentDateTime();
                    
                    $this->db->query("SELECT  NO_TRS_BILLING,ID,
                                    QTY,SUB_TOTAL,DISC,DISC_RP,SUB_TOTAL_2,GRANDTOTAL,KLAIM,KEKURANGAN,NO_REGISTRASI 
                                    FROM Billing_Pasien.DBO.FO_T_BILLING_1 
                    WHERE NO_REGISTRASI=:NO_REGISTRASI and GROUP_ENTRI='ADMINISTRASI'
                    and BATAL='0' and GROUP_TARIF='Administrasi Rajal'  and BATAL='0'  ");
                    $this->db->bind('NO_REGISTRASI', $noreg);  
                    $this->db->execute();
                    $dataadminx =  $this->db->rowCount(); 
                    $dataregformupdateadmin =  $this->db->single(); 
                    $xNO_TRS_BILLING =  $dataregformupdateadmin['NO_TRS_BILLING'];
                   //  var_dump($dataadminx); exit;
                    if($dataadminx){
                            // UPDATE ADMINISTRASI
                            $xDISC = 0;
                            $subtotal2 = $biaya_admin;
                            $KEKURANGAN = $biaya_admin;
                            $KLAIM = '0';
                       
                            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 SET 
                            SUB_TOTAL = :subtotal,   NILAI_TARIF = :nilaitarif,  
                            DISC_RP = :xDISC, 
                            SUB_TOTAL_2 = :subtotal2, GRANDTOTAL = :grttl, 
                            KLAIM = :klaim, KEKURANGAN = :kekurangan
                            WHERE NO_TRS_BILLING = :NO_TRS_BILLING AND GROUP_TARIF = :GROUP_TARIF AND GROUP_ENTRI = :GROUP_ENTRI"); 
                            $this->db->bind('subtotal', $biaya_admin);
                            $this->db->bind('xDISC', $xDISC);
                            $this->db->bind('subtotal2', $subtotal2); 
                            $this->db->bind('nilaitarif', $biaya_admin); 
                            $this->db->bind('grttl', $subtotal2); 
                            $this->db->bind('NO_TRS_BILLING', $xNO_TRS_BILLING); 
                            $this->db->bind('klaim', $KLAIM); 
                            $this->db->bind('kekurangan', $KEKURANGAN); 
                            $this->db->bind('GROUP_TARIF', 'Administrasi Rajal'); 
                            $this->db->bind('GROUP_ENTRI', 'ADMINISTRASI'); 
                            $this->db->execute();

                            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_2 SET   
                            SUB_TOTAL = :subtotal,  
                            DISC_RP = :xDISC, 
                            NILAI_DISKON_PDP = :xDISC2, 
                            SUB_TOTAL_2 = :subtotal2, NILAI_PDP = :grttl 
                            WHERE NO_TRS_BILLING = :NO_TRS_BILLING AND GROUP_TARIF = :GROUP_TARIF AND ID_BILL = :ID_BILL "); 
                            $this->db->bind('subtotal', $biaya_admin);
                            $this->db->bind('xDISC', $xDISC);
                            $this->db->bind('xDISC2', $xDISC);
                            $this->db->bind('subtotal2', $subtotal2); 
                            $this->db->bind('grttl', $biaya_admin); 
                            $this->db->bind('NO_TRS_BILLING', $xNO_TRS_BILLING); 
                            $this->db->bind('GROUP_TARIF', 'Administrasi Rajal'); 
                            $this->db->bind('ID_BILL', $dataregformupdateadmin['ID']); 
                            $this->db->execute(); 

                            // UPDATE FO
                            $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_BILLING
                            SET TOTAL_TARIF=B.SUM_NILAI_TARIF,
                            TOTAL_QTY=B.SUM_QTY,SUBTOTAL=B.SUM_SUB_TOTAL,SUBTOTAL_2=B.SUM_SUB_TOTAL_2,GRANDTOTAL=B.SUM_GRANDTOTAL,
                            FB_VERIF_JURNAL='0', TOTAL_DISCOUNT = B.DISC, TOTAL_DISCOUNT_RP=b.DISC_RP
                            FROM Billing_Pasien.DBO.FO_T_BILLING A 
                            INNER JOIN
                            (
                                SELECT  NO_TRS_BILLING,SUM(NILAI_TARIF) AS SUM_NILAI_TARIF,SUM(QTY) AS SUM_QTY,SUM(SUB_TOTAL) AS SUM_SUB_TOTAL,SUM(SUB_TOTAL_2) AS SUM_SUB_TOTAL_2,
                                SUM(GRANDTOTAL) AS SUM_GRANDTOTAL,sum(DISC) as DISC, SUM(DISC_RP) AS DISC_RP
                                FROM Billing_Pasien.DBO.FO_T_BILLING_1
                                WHERE NO_REGISTRASI=:noreg and Batal='0'
                                GROUP BY NO_TRS_BILLING
                            ) B
                            ON A.NO_TRS_BILLING = B.NO_TRS_BILLING
                            WHERE A.NO_REGISTRASI=:noreg2 AND A.NO_TRS_BILLING=:notrsbill
                            ");
                            $this->db->bind('noreg', $noreg);
                            $this->db->bind('noreg2', $noreg);
                            $this->db->bind('notrsbill', $xNO_TRS_BILLING);
                            $this->db->execute();
                    }else{
                            // ADMINISTRASI
                            $notrs = "ADR" . Utils::idtrsByDatetime();
                            $this->db->query("INSERT INTO Billing_Pasien.dbo.FO_T_BILLING
                            ([NO_TRS_BILLING],[TGL_BILLING],[PETUGAS_ENTRY],[NO_MR],[NO_EPISODE],
                            [NO_REGISTRASI],[UNIT],[GROUP_JAMINAN],[KODE_JAMINAN],[TOTAL_TARIF],
                            [TOTAL_QTY],[SUBTOTAL],[TOTAL_DISCOUNT],[TOTAL_DISCOUNT_RP],[SUBTOTAL_2],
                            [GRANDTOTAL],[BATAL],[FB_CLOSE_KEUANGAN],[FB_VERIF_JURNAL]) 
                            VALUES
                            (:notrsbill,:datenowx,:namauserx,:NoMrfix,:NoEpisode,
                            :nofixReg,:IdGrupPerawatan,:JenisBayar,:perusahaanid,:totaltarif,
                            :totalqty,:subtotal,:totaldiscount,:totaldiscountrp,:subtotal2,
                            :grandtotal,:batal,:closekeuangan,:verifkeuangan)"); 
                            $this->db->bind('notrsbill', $notrs);
                            $this->db->bind('datenowx', $datenow);
                            $this->db->bind('namauserx', 'Administrator');
                            $this->db->bind('NoMrfix', $detilReRAnap['NoMR']);
                            $this->db->bind('NoEpisode', $detilReRAnap['NoEpisode']);
                            $this->db->bind('nofixReg', $noreg);
                            $this->db->bind('IdGrupPerawatan', $detilReRAnap['UNIT']);
                            $this->db->bind('JenisBayar', $detilReRAnap['TypePatient']);
                            $this->db->bind('perusahaanid', $detilReRAnap['kodePenjamin']);
                            $this->db->bind('totaltarif', $biaya_admin);
                            $this->db->bind('totalqty', 1);
                            $this->db->bind('subtotal', $biaya_admin);
                            $this->db->bind('totaldiscount', 0);
                            $this->db->bind('totaldiscountrp', 0);
                            $this->db->bind('subtotal2', $biaya_admin);
                            $this->db->bind('grandtotal', $biaya_admin);
                            $this->db->bind('batal', 0);
                            $this->db->bind('closekeuangan', 0);
                            $this->db->bind('verifkeuangan', 0);
                            $this->db->execute();
                            $id_inpatientinout_max = $this->db->GetLastID();

                          
                                $bayar = '0';
                                $bayarmat = '0';
                                $klaim = '0';
                                $klaimmat = '0';
                                $kekurangan = $biaya_admin;
                        
                            // fo billing 1 ADMIN
                            $this->db->query("INSERT INTO  Billing_Pasien.dbo.FO_T_BILLING_1
                            (ID_BILL,[NO_TRS_BILLING],[TGL_BILLING] ,[PETUGAS_ENTRY],[NO_MR],[NO_EPISODE],[NO_REGISTRASI],[KODE_TARIF],[UNIT],[GROUP_JAMINAN],[KODE_JAMINAN],
                            [NAMA_TARIF],[GROUP_TARIF],[KD_KELAS],[QTY],[NILAI_TARIF],[SUB_TOTAL],[DISC],[DISC_RP],[SUB_TOTAL_2],[GRANDTOTAL],[KODE_REF],[KD_DR],[NM_DR],
                            [BATAL],[PETUGAS_BATAL],[GROUP_ENTRI],[BAYAR],[KLAIM],[KEKURANGAN])
                            SELECT '$id_inpatientinout_max','$notrs' , '$datenow' as datenow,'Administrator' as namauserx,NO_MR, NO_EPISODE,'$noreg' as NoReg,:Kode_Tarif as kodetarif,
                            UNIT,GROUP_JAMINAN,KODE_JAMINAN, :Nama_Tarif as namatarif,'Administrasi Rajal' as rad, :kdkelas, 1 as Qty, :Nilai as nilai, :Nilai2 as nilai2, 0, 
                            0, :Nilai3 as nilai3, :Nilai4 as nilai4,'$id_inpatientinout_max', :drPenerima, null as namadokter, 0 as batal,null as petugasbatal,'ADMINISTRASI',$bayar,$klaim,$kekurangan
                            FROM Billing_Pasien.dbo.FO_T_BILLING
                            WHERE NO_TRS_BILLING=:notrsbill AND Batal='0'");
                            $this->db->bind('notrsbill', $notrs);
                            $this->db->bind('Kode_Tarif', 'ADR00001');
                            $this->db->bind('Nama_Tarif', 'Administrasi Rajal');
                            $this->db->bind('Nilai',  $biaya_admin);
                            $this->db->bind('Nilai2', $biaya_admin);
                            $this->db->bind('Nilai3', $biaya_admin);
                            $this->db->bind('Nilai4', $biaya_admin);
                            $this->db->bind('drPenerima', '');
                            $this->db->bind('kdkelas', $detilReRAnap['KelasID']); 
                            $this->db->execute();
                            $bill1last = $this->db->GetLastID();

                            $this->db->query("INSERT INTO Billing_Pasien.DBO.FO_T_BILLING_2
                            SELECT '$bill1last',A.NO_TRS_BILLING AS NO_TRS_BILLING,A1.KODE_TARIF,'ADM2' as Kode_komponen,A1.UNIT AS UNIT, 
                            A1.GROUP_JAMINAN AS GROUP_JAMINAN, A1.KODE_JAMINAN AS KODE_JAMINAN, A1.NAMA_TARIF AS NAMA_TARIF, A1.GROUP_TARIF AS GROUP_TARIF,
                            A1.KD_KELAS as KELAS,A1.QTY AS QTY, A1.NILAI_TARIF AS NILAI_TARIF , A1.NILAI_TARIF*A1.QTY  AS SUBTOTAL,A1.DISC AS DISC,
                            0 AS DISC_RP,((A1.NILAI_TARIF*A1.QTY)-(((A1.NILAI_TARIF*A1.QTY)*A1.DISC)/100)) SUB_TOTAL_PDP_2,
                            '0' NILAI_DISKON_PDP,A1.NILAI_TARIF as NILAI_PDP,null AS KD_DR, null NM_DR,'1' as NILAI_PROSEN,'0' AS BATAL,
                            '' PETUGAS_BATAL, '' AS JAM_BATAL, '44100001' AS KD_POSTING,'45100002' as kd_posting_diskon, 0 as ID_TR_TARIF_PAKET
                            FROM Billing_Pasien.DBO.FO_T_BILLING A
                            inner join Billing_Pasien.dbo.FO_T_BILLING_1 A1 ON A.NO_TRS_BILLING = A1.NO_TRS_BILLING 
                            WHERE a.NO_TRS_BILLING=:notrsbill2 and a1.GROUP_ENTRI='ADMINISTRASI' ");
                            $this->db->bind('notrsbill2', $notrs);
                            $this->db->execute();
                    }
       




            $this->db->commit();

            $callback = array(
                'status' => 'success',
                'message' => 'Generate Administrasi Transaksi Berhasi', 
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    // generate admin
}
