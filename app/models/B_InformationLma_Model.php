<?php
class  B_InformationLma_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getDataListLmaPasien($data)
    {
        try {
            $tglawal = $data['TglAwal'];
            $tglakhir = $data['TglAkhir'];
            $this->db->query("SELECT DokterDPJP,a.JenisRawat, a.NoEpisode,a.NoRegistrasi,a.NoMR,PatientName,replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') as VisitDate,NamaDokter,op.NamaPerusahaan,a.[Status Name] as Status ,a.IDSpr,x.NoSEP,a.NamaUnit,a.DiagnosaAwal
            ,replace(CONVERT(VARCHAR(11), xx.StartDate, 111), '/','-') as startdate
                        from MedicalRecord.dbo.View_PermintaanRawat  a
                        LEFT join MasterdataSQL.dbo.MstrTypePatient d
                        on d.ID = PatientType
                        left join MasterdataSQL.dbo.MstrPerusahaanAsuransi op on op.ID = a.Asuransi
                        inner join PerawatanSQL.dbo.Visit x on a.NoRegistrasi=x.NoRegistrasi
                        left join RawatInapSQL.dbo.Inpatient xx on a.NoRegRI=xx.NoRegRI
                        where  d.TypePatient='ASURANSI' 
                        and replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') Between :TglAwal1 AND :TglAkhir1
                        union all
                        select DokterDPJP,a.JenisRawat, a.NoEpisode,a.NoRegistrasi,a.NoMR,PatientName,replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') as VisitDate,NamaDokter,op.NamaPerusahaan,
                        a.[Status Name] as Status ,a.IDSpr,x.NoSEP,a.NamaUnit,a.DiagnosaAwal,replace(CONVERT(VARCHAR(11), xx.StartDate, 111), '/','-') as startdate
                        from MedicalRecord.dbo.View_PermintaanRawat  a
                        LEFT join MasterdataSQL.dbo.MstrTypePatient d
                        on d.ID = PatientType
                        left join MasterdataSQL.dbo.MstrPerusahaanJPK op on op.ID = a.Perusahaan
                        inner join PerawatanSQL.dbo.Visit x on a.NoRegistrasi=x.NoRegistrasi
                        left join RawatInapSQL.dbo.Inpatient xx on a.NoRegRI=xx.NoRegRI
                        where   d.TypePatient<>'ASURANSI' 
                        and replace(CONVERT(VARCHAR(11), a.[Visit Date], 111), '/','-') 
                        Between :TglAwal2 AND :TglAkhir2
            -- UNION ALL
            -- SELECT DokterDPJP,a.JenisRawat, a.NoEpisode,a.NoRegistrasi,a.NoMR,PatientName,replace(CONVERT(VARCHAR(11), x.StartDate, 111), '/','-') as VisitDate,
			-- f.First_Name NamaDokter,case when x.TypePatient='2' then op.NamaPerusahaan else opx.NamaPerusahaan end as NamaPerusahaan,null as Status ,a.Id,x.NoSEP,'' NamaUnit,a.DiagnosaAwal
            -- from MedicalRecord.dbo.MR_PermintaanRawat  a
            -- inner join RawatInapSQL.dbo.Inpatient x on a.NoRegistrasi collate Latin1_General_CI_AS=x.NoRegRI
			-- inner join MasterdataSQL.dbo.Admision v on x.NoMR=v.NoMR
			-- inner join MasterdataSQL.dbo.Doctors f on x.drPenerima=f.ID
            -- LEFT join MasterdataSQL.dbo.MstrTypePatient d on d.ID = x.TypePatient
            -- left join MasterdataSQL.dbo.MstrPerusahaanAsuransi op on op.ID = x.IDAsuransi
			-- left join MasterdataSQL.dbo.MstrPerusahaanJPK opx on opx.ID=x.IDJPK
            -- where  replace(CONVERT(VARCHAR(11), x.StartDate, 111), '/','-') Between :TglAwal5 AND :TglAkhir5
             ");
            $this->db->bind('TglAwal1', $tglawal);
            $this->db->bind('TglAkhir1', $tglakhir);
            $this->db->bind('TglAwal2', $tglawal);
            $this->db->bind('TglAkhir2', $tglakhir);
            // $this->db->bind('TglAwal3', $tglawal);
            // $this->db->bind('TglAkhir3', $tglakhir);
            // $this->db->bind('TglAwal4', $tglawal);
            // $this->db->bind('TglAkhir4', $tglakhir);
            // $this->db->bind('TglAwal5', $tglawal);
            // $this->db->bind('TglAkhir5', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['DokterDPJP'] = $key['DokterDPJP'];
                $pasing['NoMR'] = $key['NoMR'];
                $pasing['PatientName'] = $key['PatientName'];
                $pasing['JenisRawat'] = $key['JenisRawat'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['VisitDate'] = date('d/m/Y', strtotime($key['VisitDate']));
                $pasing['NamaDokter'] = $key['NamaDokter'];
                $pasing['NamaPerusahaan'] = $key['NamaPerusahaan'];
                $pasing['Status'] = $key['Status'];
                $pasing['IDSpr'] = $key['IDSpr'];
                $pasing['NoSEP'] = $key['NoSEP'];
                $pasing['NamaUnit'] = $key['NamaUnit'];
                $pasing['DiagnosaAwal'] = $key['DiagnosaAwal'];
                $pasing['startdate'] = date('d/m/Y', strtotime($key['startdate']));
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
