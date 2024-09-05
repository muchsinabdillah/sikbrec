<?php
class  B_InformationRadGigi_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getListData($data)
    {
        try {
            $tglawal = $data['TglAwal'];
            $tglakhir = $data['TglAkhir'];
            $this->db->query("SELECT 
            mrn,EPISODE_NUMBER,x.NOREGISTRASI,ORDER_DATE,PATIENT_NAME, SCHEDULED_PROC_DESC,
            case when PatientType='2' then ax.NamaPerusahaan else ap.NamaPerusahaan end as NamaJaminan,CAST(Tarif as decimal) as Tarif
            from (
            select  mrn,EPISODE_NUMBER,NOREGISTRASI,ORDER_DATE,PATIENT_NAME, SCHEDULED_PROC_DESC,Tarif,IsVerifikasi
            from RadiologiSQL.dbo.WO_RADIOLOGY 
            where  SCHEDULED_PROC_DESC like '%cbct%' and Batal='0'  
            and replace(CONVERT(VARCHAR(11), ORDER_DATE, 111), '/','-') between :tglawal1 and :tglakhir1
            UNION ALL
            select mrn,EPISODE_NUMBER,NOREGISTRASI,ORDER_DATE,PATIENT_NAME, SCHEDULED_PROC_DESC,Tarif,IsVerifikasi
            from RadiologiSQL.dbo.WO_RADIOLOGY where  SCHEDULED_PROC_DESC like '%cephalometry%' and Batal='0'
            and replace(CONVERT(VARCHAR(11), ORDER_DATE, 111), '/','-') between :tglawal2 and :tglakhir2
            UNION ALL
            select mrn,EPISODE_NUMBER,NOREGISTRASI,ORDER_DATE,PATIENT_NAME, SCHEDULED_PROC_DESC,Tarif,IsVerifikasi
            from RadiologiSQL.dbo.WO_RADIOLOGY where  SCHEDULED_PROC_DESC like '%panoramic%' and Batal='0'
             and replace(CONVERT(VARCHAR(11), ORDER_DATE, 111), '/','-') between :tglawal3 and :tglakhir3
            UNION ALL
            select mrn,EPISODE_NUMBER,NOREGISTRASI,ORDER_DATE,PATIENT_NAME, SCHEDULED_PROC_DESC,Tarif,IsVerifikasi
            from RadiologiSQL.dbo.WO_RADIOLOGY where  SCHEDULED_PROC_DESC like '%periaprichal%' and Batal='0'
            and replace(CONVERT(VARCHAR(11), ORDER_DATE, 111), '/','-') between :tglawal4 and :tglakhir4
            UNION ALL
            select mrn,EPISODE_NUMBER,NOREGISTRASI,ORDER_DATE,PATIENT_NAME, SCHEDULED_PROC_DESC,Tarif,IsVerifikasi
            from RadiologiSQL.dbo.WO_RADIOLOGY where  SCHEDULED_PROC_DESC like '%tmj%' and Batal='0'
            and replace(CONVERT(VARCHAR(11), ORDER_DATE, 111), '/','-') between :tglawal5 and :tglakhir5
            ) x
            inner join PerawatanSQL.dbo.Visit v on x.NOREGISTRASI=v.NoRegistrasi 
            left join MasterdataSQL.dbo.MstrPerusahaanAsuransi ax on v.Asuransi=ax.ID
            left join MasterdataSQL.dbo.MstrPerusahaanJPK ap on v.Perusahaan=ap.ID
            where left(x.NOREGISTRASI,2)='RJ' and v.Batal='0'
            union all
            --ranap
            select
            mrn,EPISODE_NUMBER,x.NOREGISTRASI,ORDER_DATE,PATIENT_NAME, SCHEDULED_PROC_DESC,
            case when TypePatient='2' then ax.NamaPerusahaan else ap.NamaPerusahaan end as NamaJaminan,CAST(Tarif as decimal) as Tarif
            from (
            select  mrn,EPISODE_NUMBER,NOREGISTRASI,ORDER_DATE,PATIENT_NAME, SCHEDULED_PROC_DESC,Tarif,IsVerifikasi
            from RadiologiSQL.dbo.WO_RADIOLOGY 
            where  SCHEDULED_PROC_DESC like '%cbct%' and Batal='0'  
            and replace(CONVERT(VARCHAR(11), ORDER_DATE, 111), '/','-') between :tglawal6 and :tglakhir6
            UNION ALL
            select mrn,EPISODE_NUMBER,NOREGISTRASI,ORDER_DATE,PATIENT_NAME, SCHEDULED_PROC_DESC,Tarif,IsVerifikasi
            from RadiologiSQL.dbo.WO_RADIOLOGY where  SCHEDULED_PROC_DESC like '%cephalometry%' and Batal='0'
            and replace(CONVERT(VARCHAR(11), ORDER_DATE, 111), '/','-') between :tglawal7 and :tglakhir7
            UNION ALL
            select mrn,EPISODE_NUMBER,NOREGISTRASI,ORDER_DATE,PATIENT_NAME, SCHEDULED_PROC_DESC,Tarif,IsVerifikasi
            from RadiologiSQL.dbo.WO_RADIOLOGY where  SCHEDULED_PROC_DESC like '%panoramic%' and Batal='0'
             and replace(CONVERT(VARCHAR(11), ORDER_DATE, 111), '/','-') between :tglawal8 and :tglakhir8
            UNION ALL
            select mrn,EPISODE_NUMBER,NOREGISTRASI,ORDER_DATE,PATIENT_NAME, SCHEDULED_PROC_DESC,Tarif,IsVerifikasi
            from RadiologiSQL.dbo.WO_RADIOLOGY where  SCHEDULED_PROC_DESC like '%periaprichal%' and Batal='0'
            and replace(CONVERT(VARCHAR(11), ORDER_DATE, 111), '/','-') between :tglawal9 and :tglakhir9
            UNION ALL
            select mrn,EPISODE_NUMBER,NOREGISTRASI,ORDER_DATE,PATIENT_NAME, SCHEDULED_PROC_DESC,Tarif,IsVerifikasi
            from RadiologiSQL.dbo.WO_RADIOLOGY where  SCHEDULED_PROC_DESC like '%tmj%' and Batal='0'
            and replace(CONVERT(VARCHAR(11), ORDER_DATE, 111), '/','-') between :tglawal10 and :tglakhir10
            ) x
            inner join RawatInapSQL.dbo.Inpatient v on x.NOREGISTRASI=v.NoRegRI 
            left join MasterdataSQL.dbo.MstrPerusahaanAsuransi ax on v.IDAsuransi=ax.ID
            left join MasterdataSQL.dbo.MstrPerusahaanJPK ap on v.IDJPK=ap.ID
            where left(x.NOREGISTRASI,2)='RI'
            order by ORDER_DATE asc
             ");
             $this->db->bind('tglawal1', $tglawal);
             $this->db->bind('tglawal2', $tglawal);
             $this->db->bind('tglawal3', $tglawal);
             $this->db->bind('tglawal4', $tglawal);
             $this->db->bind('tglawal5', $tglawal);
             $this->db->bind('tglawal6', $tglawal);
             $this->db->bind('tglawal7', $tglawal);
             $this->db->bind('tglawal8', $tglawal);
             $this->db->bind('tglawal9', $tglawal);
             $this->db->bind('tglawal10', $tglawal);
            $this->db->bind('tglakhir1', $tglakhir);
            $this->db->bind('tglakhir2', $tglakhir);
            $this->db->bind('tglakhir3', $tglakhir);
            $this->db->bind('tglakhir4', $tglakhir);
            $this->db->bind('tglakhir5', $tglakhir);
            $this->db->bind('tglakhir6', $tglakhir);
            $this->db->bind('tglakhir7', $tglakhir);
            $this->db->bind('tglakhir8', $tglakhir);
            $this->db->bind('tglakhir9', $tglakhir);
            $this->db->bind('tglakhir10', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['mrn'] = $key['mrn'];
                $pasing['EPISODE_NUMBER'] = $key['EPISODE_NUMBER'];
                $pasing['NOREGISTRASI'] = $key['NOREGISTRASI'];
                $pasing['ORDER_DATE'] = $key['ORDER_DATE'];
                $pasing['PATIENT_NAME'] = $key['PATIENT_NAME'];
                $pasing['SCHEDULED_PROC_DESC'] = $key['SCHEDULED_PROC_DESC'];
                $pasing['NamaJaminan'] = $key['NamaJaminan'];
                $pasing['Tarif'] = $key['Tarif'];
                $rows[] = $pasing;
            }
            return $data;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function printShowDataLMA($data)
    {
        try {
            $this->db->query("SELECT a.*,b.PatientName,b.Address,
            case when b.Gander = 'P' then 'Perempuan' else 'Laki-laki' end as gender,
            case when a.Isolasi is null then '-' else a.Isolasi end as isolasix,
            case when a.JenisRawat is null then '-' else a.Jenisrawat end as jenisrawat, 
            case when a.DokterPemeriksa is null then '-' else a.DokterPemeriksa end as DokterPemeriksa,
            case when a.DokterDPJP is null then '-' else a.DokterDPJP end as DokterDPJP,
            case when a.Keterangan is null then '-' else a.Keterangan end as Keterangan,
            replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as tgllahir,
            replace(CONVERT(VARCHAR(11), Tglmasuk, 111), '/','-') as tglmasuk 
            from MedicalRecord.dbo.MR_PermintaanRawat a
                  inner join MasterDataSQL.dbo.Admision b 
                  on a.NoMR collate Latin1_General_CS_AS=b.NoMR collate Latin1_General_CS_AS 
                  WHERE a.Id=:idspr ");
            $this->db->bind('idspr', $data['notrs']);
            $data =  $this->db->single();
            $pasing['PatientName'] = $data['PatientName'];
            //Identitas Pasien
            $pasing['PatientName'] = $data['PatientName'];
            $pasing['NoMR'] = $data['NoMR'];
            $pasing['alamat'] = $data['Address'];
            $pasing['tgllahir'] = date('d/m/Y', strtotime($data['tgllahir']));
            $pasing['gender'] = $data['gender'];

            //tbl MR_PermintaanRawat
            $pasing['jenisrawat'] = $data['jenisrawat'];
            $pasing['dr_pemeriksa'] = $data['DokterPemeriksa'];
            $pasing['Isolasi'] = $data['isolasix'];
            $pasing['dpjp'] = $data['DokterDPJP'];
            if ($data['tglmasuk'] == null) {
                $pasing['tglmasuk'] = '-';
            } else {
                $pasing['tglmasuk'] = date('d/m/Y', strtotime($data['tglmasuk']));
            }
            $pasing['keterangan'] = $data['Keterangan'];
            $pasing['keluhanutama'] = $data['KeluhanUtama'];
            $pasing['tglmulaikeluhan'] = $data['TglMulaiKeluhan'];
            $pasing['IndikasiRawat'] = $data['IndikasiRawat'];
            $pasing['RiwayatPenyakitDulu'] = $data['RiwayatPenyakitDulu'];
            $pasing['TTV'] = $data['TTV'];
            $pasing['PemeriksaanFisik'] = $data['PemeriksaanFisik'];
            $pasing['PemeriksaanPenunjang'] = $data['PemeriksaanPenunjang'];
            $pasing['DiagnosaAwal'] = $data['DiagnosaAwal'];
            $pasing['DiagnosaRawatSama'] = $data['DiagnosaRawatSama'];
            $pasing['TglDiagnosaSama'] = $data['TglDiagnosaSama'];
            $pasing['Dimana'] = $data['Dimana'];

            $pasing['RadangUsus12Jari'] = $data['RadangUsus12Jari'];
            $pasing['BawaanLahir'] = $data['BawaanLahir'];
            $pasing['TukakLambung'] = $data['TukakLambung'];
            $pasing['KomplikasiHamil'] = $data['KomplikasiHamil'];
            $pasing['Kejiwaan'] = $data['Kejiwaan'];
            $pasing['SaluranProduksi'] = $data['SaluranProduksi'];
            $pasing['PenyakitJantung'] = $data['PenyakitJantung'];
            $pasing['KB'] = $data['KB'];
            $pasing['Tumor'] = $data['Tumor'];
            $pasing['Hepatitis'] = $data['Hepatitis'];

            $pasing['DarahTinggi'] = $data['DarahTinggi'];
            $pasing['TulangBelakang'] = $data['TulangBelakang'];
            $pasing['DM'] = $data['DM'];
            $pasing['Gigi'] = $data['Gigi'];
            $pasing['Tuberculosis'] = $data['Tuberculosis'];
            $pasing['Hormonal'] = $data['Hormonal'];
            $pasing['BatuGinjal'] = $data['BatuGinjal'];
            $pasing['Geriatri'] = $data['Geriatri'];

            $pasing['BatuEmpedu'] = $data['BatuEmpedu'];
            $pasing['Alkoholisme'] = $data['Alkoholisme'];
            $pasing['KelainanDarah'] = $data['KelainanDarah'];
            $pasing['KLL'] = $data['KLL'];
            $pasing['Tonsil'] = $data['Tonsil'];
            $pasing['Tentamen'] = $data['Tentamen'];
            $pasing['Sinus'] = $data['Sinus'];
            $pasing['STDH'] = $data['STDH'];

            $pasing['Telinga'] = $data['Telinga'];
            $pasing['Kosmetik'] = $data['Kosmetik'];
            $pasing['Asthma'] = $data['Asthma'];
            $pasing['Appendiks'] = $data['Appendiks'];
            $pasing['TerapiSaatini'] = $data['TerapiSaatini'];
            $pasing['MedicalSpesialistik'] = $data['MedicalSpesialistik'];

            $pasing['LamaRawat'] = $data['LamaRawat'];
            $pasing['Operasi1'] = $data['Operasi1'];
            $pasing['Operasi2'] = $data['Operasi2'];
            $pasing['JenisAnastesi'] = $data['JenisAnastesi'];
            $pasing['StatusPembedahan'] = $data['StatusPembedahan'];
            $pasing['JumlahSayatan'] = $data['JumlahSayatan'];
            if ($data['JadwalBedah'] == null) {
                $jadwabedahx = $data['JadwalBedah'];
            } else {
                $jadwabedahx =  date('d/m/Y', strtotime($data['JadwalBedah']));
            }
            $pasing['JadwalBedah'] = $jadwabedahx;

            $pasing['Kecelakaan'] = $data['Kecelakaan'];
            $pasing['TglKecelakaan'] = $data['TglKecelakaan'];
            $pasing['JamKecelakaan'] = $data['JamKecelakaan'];
            $pasing['SebabKecelakaan'] = $data['SebabKecelakaan'];
            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function printShowDataODC($data)
    {
        try {
            $this->db->query("SELECT a.*,b.PatientName,b.Address,
            case when b.Gander = 'P' then 'Perempuan' else 'Laki-laki' end as gender,
            case when a.Isolasi is null then '-' else a.Isolasi end as isolasix,
            case when a.JenisRawat is null then '-' else a.Jenisrawat end as jenisrawat, 
            case when a.DokterPemeriksa is null then '-' else a.DokterPemeriksa end as DokterPemeriksa,
            case when a.DokterDPJP is null then '-' else a.DokterDPJP end as DokterDPJP,
            case when a.Keterangan is null then '-' else a.Keterangan end as Keterangan,
            replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as tgllahir,
            replace(CONVERT(VARCHAR(11), Tglmasuk, 111), '/','-') as tglmasuk 
            from MedicalRecord.dbo.MR_PermintaanRawat_ODC a
                  inner join MasterDataSQL.dbo.Admision b 
                  on a.NoMR collate Latin1_General_CS_AS=b.NoMR collate Latin1_General_CS_AS 
                  WHERE a.Id=:idspr ");
            $this->db->bind('idspr', $data['notrs']);
            $data =  $this->db->single();
            $pasing['PatientName'] = $data['PatientName'];
            //Identitas Pasien
            $pasing['PatientName'] = $data['PatientName'];
            $pasing['NoMR'] = $data['NoMR'];
            $pasing['alamat'] = $data['Address'];
            $pasing['tgllahir'] = date('d/m/Y', strtotime($data['tgllahir']));
            $pasing['gender'] = $data['gender'];

            //tbl MR_PermintaanRawat
            $pasing['jenisrawat'] = $data['jenisrawat'];
            $pasing['dr_pemeriksa'] = $data['DokterPemeriksa'];
            $pasing['Isolasi'] = $data['isolasix'];
            $pasing['dpjp'] = $data['DokterDPJP'];
            if ($data['tglmasuk'] == null) {
                $pasing['tglmasuk'] = '-';
            } else {
                $pasing['tglmasuk'] = date('d/m/Y', strtotime($data['tglmasuk']));
            }
            $pasing['keterangan'] = $data['Keterangan'];
            $pasing['keluhanutama'] = $data['KeluhanUtama'];
            $pasing['tglmulaikeluhan'] = $data['TglMulaiKeluhan'];
            $pasing['IndikasiRawat'] = $data['IndikasiRawat'];
            $pasing['RiwayatPenyakitDulu'] = $data['RiwayatPenyakitDulu'];
            $pasing['TTV'] = $data['TTV'];
            $pasing['PemeriksaanFisik'] = $data['PemeriksaanFisik'];
            $pasing['PemeriksaanPenunjang'] = $data['PemeriksaanPenunjang'];
            $pasing['DiagnosaAwal'] = $data['DiagnosaAwal'];
            $pasing['DiagnosaRawatSama'] = $data['DiagnosaRawatSama'];
            $pasing['TglDiagnosaSama'] = $data['TglDiagnosaSama'];
            $pasing['Dimana'] = $data['Dimana'];

            $pasing['RadangUsus12Jari'] = $data['RadangUsus12Jari'];
            $pasing['BawaanLahir'] = $data['BawaanLahir'];
            $pasing['TukakLambung'] = $data['TukakLambung'];
            $pasing['KomplikasiHamil'] = $data['KomplikasiHamil'];
            $pasing['Kejiwaan'] = $data['Kejiwaan'];
            $pasing['SaluranProduksi'] = $data['SaluranProduksi'];
            $pasing['PenyakitJantung'] = $data['PenyakitJantung'];
            $pasing['KB'] = $data['KB'];
            $pasing['Tumor'] = $data['Tumor'];
            $pasing['Hepatitis'] = $data['Hepatitis'];

            $pasing['DarahTinggi'] = $data['DarahTinggi'];
            $pasing['TulangBelakang'] = $data['TulangBelakang'];
            $pasing['DM'] = $data['DM'];
            $pasing['Gigi'] = $data['Gigi'];
            $pasing['Tuberculosis'] = $data['Tuberculosis'];
            $pasing['Hormonal'] = $data['Hormonal'];
            $pasing['BatuGinjal'] = $data['BatuGinjal'];
            $pasing['Geriatri'] = $data['Geriatri'];

            $pasing['BatuEmpedu'] = $data['BatuEmpedu'];
            $pasing['Alkoholisme'] = $data['Alkoholisme'];
            $pasing['KelainanDarah'] = $data['KelainanDarah'];
            $pasing['KLL'] = $data['KLL'];
            $pasing['Tonsil'] = $data['Tonsil'];
            $pasing['Tentamen'] = $data['Tentamen'];
            $pasing['Sinus'] = $data['Sinus'];
            $pasing['STDH'] = $data['STDH'];

            $pasing['Telinga'] = $data['Telinga'];
            $pasing['Kosmetik'] = $data['Kosmetik'];
            $pasing['Asthma'] = $data['Asthma'];
            $pasing['Appendiks'] = $data['Appendiks'];
            $pasing['TerapiSaatini'] = $data['TerapiSaatini'];
            $pasing['MedicalSpesialistik'] = $data['MedicalSpesialistik'];

            $pasing['LamaRawat'] = $data['LamaRawat'];
            $pasing['Operasi1'] = $data['Operasi1'];
            $pasing['Operasi2'] = $data['Operasi2'];
            $pasing['JenisAnastesi'] = $data['JenisAnastesi'];
            $pasing['StatusPembedahan'] = $data['StatusPembedahan'];
            $pasing['JumlahSayatan'] = $data['JumlahSayatan'];
            if ($data['JadwalBedah'] == null) {
                $jadwabedahx = $data['JadwalBedah'];
            } else {
                $jadwabedahx =  date('d/m/Y', strtotime($data['JadwalBedah']));
            }
            $pasing['JadwalBedah'] = $jadwabedahx;

            $pasing['Kecelakaan'] = $data['Kecelakaan'];
            $pasing['TglKecelakaan'] = $data['TglKecelakaan'];
            $pasing['JamKecelakaan'] = $data['JamKecelakaan'];
            $pasing['SebabKecelakaan'] = $data['SebabKecelakaan'];
            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


}
