<?php
class  B_Farmasi  
{
    private $db;
    use ApiRsyarsi;
    use ApiMySDI;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getListDataOrder($data)
    {
        try {
            $tglawal = $data['TglAwal'];
            $tglakhir = $data['TglAkhir'];
            // $tglawal = '2021-07-01';
            // $tglakhir = '2021-07-31';
            $StatusOrder = $data['StatusOrder'];
            $JenisPasien = $data['JenisPasien'];
            $JenisResep = $data['JenisResep'];

            if ($JenisPasien == 'RI'){
                $where_jp = "AND LokasiPasien='RAWAT INAP'";
            }elseif($JenisPasien == 'RJ'){
                $where_jp = "AND LokasiPasien='RAWAT JALAN'";
            }elseif($JenisPasien == 'OB'){
                $where_jp = "AND LokasiPasien='OBATBEBAS'";
            }else{
                $where_jp = "";
            }

            if ($JenisResep == 'BHP'){
                $where_jr = "AND JenisResep='BHP'";
            }elseif($JenisResep == 'RESEP'){
                $where_jr = "AND JenisResep<>'BHP'";
            }else{
                $where_jr = "";
            }


            if($StatusOrder == '0'){
                $where = "AND [Status ID] = '0'";
            }elseif($StatusOrder == '1'){
                $where = "AND [Status ID] = '1'";
            }elseif($StatusOrder == '2'){
                $where = "AND [Status ID] = '2'";
            }elseif($StatusOrder == '3'){
                $where = "AND [Status ID] = '3'";
            }elseif($StatusOrder == '4'){
                $where = "AND [Status ID] = '4'";
            }else{
                $where = "";
            }

            $whereall = $where.$where_jp.$where_jr;

            $this->db->query("SELECT * FROM (
            --RANAP
            SELECT  f.First_Name as [Dokter],a.[Order Date] as tgl,
                                                        a.[Order ID],a.NoResep,a.NoRegistrasi,a.JenisResep,b.NoMR,c.PatientName 
                                                        , 'RAWAT INAP' LokasiPasien,
                                                        case when b.TypePatient='2' then asu.NamaPerusahaan when b.TypePatient='5' then jpk.NamaPerusahaan else 'UMUM' end as penjamin
                                                        ,a.[Status ID],b.JenisRawat as AsalPasien,cob.NamaCOB,b.Catatan
                                                        from [Apotik_V1.1SQL].dbo.Orders a 
                                                        inner join RawatInapSQL.dbo.Inpatient b on a.NoRegistrasi = b.NoRegRI
                                                        inner join MasterdataSQL.dbo.Admision c on c.NoMR = b.NoMR
                                                        inner join MasterdataSQL.dbo.Doctors f on f.ID = b.drPenerima
                                                            left join MasterdataSQL.dbo.MstrPerusahaanJPK jpk on b.IDJPK=jpk.ID
                                                            left join MasterdataSQL.dbo.MstrPerusahaanAsuransi asu on b.IDAsuransi=asu.ID
                                                        left join MasterdataSQL.dbo.MasterCOB cob on b.KodeJaminanCOB=cob.ID
    
                                                        where --replace(CONVERT(VARCHAR(11), a.tglResep, 111), '/','-') between '2022-01-01' and '2022-04-31' and 
                                                        a.OrderBatal='0'
    
                                                        --RAJAL
                                                        UNION ALL
                                                        SELECT f.First_Name as [Dokter],a.[Order Date] as tgl,
                                                        a.[Order ID],a.NoResep,a.NoRegistrasi,a.JenisResep,b.NoMR,c.PatientName 
                                                        , 'RAWAT JALAN' as LokasiPasien,
                                                        case when b.PatientType='2' then asu.NamaPerusahaan when b.PatientType='5' then jpk.NamaPerusahaan else 'UMUM' end as penjamin
                                                        ,a.[Status ID],g.NamaUnit as AsalPasien,cob.NamaCOB,b.Catatan
                                                        from [Apotik_V1.1SQL].dbo.Orders a 
                                                        inner join PerawatanSQL.dbo.Visit b on a.NoRegistrasi = b.NoRegistrasi
                                                        inner join MasterdataSQL.dbo.Admision c on c.NoMR = b.NoMR
                                                        inner join MasterdataSQL.dbo.Doctors f on f.ID = b.Doctor_1
                                                            left join MasterdataSQL.dbo.MstrPerusahaanJPK jpk on b.Perusahaan=jpk.ID
                                                            left join MasterdataSQL.dbo.MstrPerusahaanAsuransi asu on b.Asuransi=asu.ID
                                                            inner join MasterdataSQL.dbo.MstrUnitPerwatan g on b.Unit=g.ID
                                                        left join MasterdataSQL.dbo.MasterCOB cob on b.KodeJaminanCOB=cob.ID
                                                        where 
                                                        --replace(CONVERT(VARCHAR(11), a.tglResep, 111), '/','-') between '2022-01-01' and '2022-04-31' and 
                                                        a.OrderBatal='0'  
    
                                                        --OBAT BEBAS
                                                        UNION ALL
    
                                                        SELECT  f.First_Name as [Dokter],a.[Order Date] as tgl,
                                                        a.[Order ID],a.NoResep,a.NoRegistrasi,a.JenisResep,null as NoMR,a.[Ship Name] ,
                                                        'OBATBEBAS' as LokasiPasien,
                                                        '-' as penjamin,a.[Status ID], null as AsalPasien,null as NamaCOB,null as Catatan
                                                        from [Apotik_V1.1SQL].dbo.Orders a 
                                                        left join MasterdataSQL.dbo.Doctors f on f.ID = a.Dokter
                                                        where 
                                                        --replace(CONVERT(VARCHAR(11), a.tglResep, 111), '/','-') between '2022-01-01' and '2022-04-31' and 
                                                        a.OrderBatal='0'   and a.NoRegistrasi like '%b%'
                                                        )x
                                                        where 
                                                        --[Status ID]='0' and 
                                                        --tgl between :TglAwal and :TglAkhir 
                                                        replace(CONVERT(VARCHAR(11), tgl, 111), '/','-') between :TglAwal and :TglAkhir 
                                                        AND JenisResep is not null
                                                        $whereall
                                                        order by tgl desc
    
    
             "); 
             $this->db->bind('TglAwal', $tglawal);
             $this->db->bind('TglAkhir', $tglakhir); 
                            $data =  $this->db->resultSet();
                            $rows = array();
                            foreach ($data as $key) {
                                $pasing['OrderID'] = $key['Order ID'];
                                $pasing['NoMR'] = $key['NoMR'];
                                $pasing['PatientName'] = $key['PatientName'];
                                $pasing['LokasiPasien'] = $key['LokasiPasien'];
                                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                                $pasing['Dokter'] = $key['Dokter'];
                                $pasing['tgl'] = date('d/m/Y H:i:s', strtotime($key['tgl']));
                                $pasing['JenisResep'] = $key['JenisResep'];
                                $pasing['penjamin'] = $key['penjamin']; 
                                $pasing['Status'] = $key['Status ID']; 
                                $pasing['AsalPasien'] = $key['AsalPasien']; 
                                $pasing['NamaCOB'] = $key['NamaCOB']; 
                                $pasing['Catatan'] = $key['Catatan']; 
                                $rows[] = $pasing;
                            }
                            return $rows;
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
            if ($data['tglmasuk'] == null){
                $pasing['tglmasuk'] = '-';
            }else{
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
            if ($data['JadwalBedah']==null){
                $jadwabedahx = $data['JadwalBedah'];
            }else{
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

    public function goSelesaiAll($data)
    {
        try {
            $this->db->transaksi();


                $query = "UPDATE [Apotik_V1.1SQL].dbo.Orders SET [Status ID]=4 WHERE [Order ID] = :iddata and [Status ID] > 2 and [Status ID] is not null";

            //$odid = array();
            $tod = json_decode(json_encode((object) $data['idorderapprove']), FALSE);
            foreach ($tod as $data) { 

                // Update HDR
                $this->db->query($query);
                $this->db->bind('iddata', $data);
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

    public function getDataPasien($data)
    {
        try {
            $orderid = $data['NoOrder'];
            // $this->db->query(" SELECT [Order ID] as ID,
            // case when NoRegistrasi like '%b%' then [Ship Name]
            // else b.PatientName end as PatientName,b.NoMR,a.NoRegistrasi,NoEpisode,null as TypePatientID,
            // replace(CONVERT(VARCHAR(11), b.Date_of_birth, 111), '/','-') as DOB,null as penjamin_kode,'-' nama_penjamin,null as IDDokter,c.First_Name as NamaDokter,null as IDKelas,'-' as NamaKelas,
            //         replace(CONVERT(VARCHAR(11), tglResep, 111), '/','-') as TglMasuk,replace(CONVERT(VARCHAR(11), tglResep, 111), '/','-') as TglKeluar,
            //         null AS IDUnit,
            //         case 
            //         when left(NoRegistrasi,2)='RJ' then 'Rawat Jalan'
            //         when left(NoRegistrasi,2)='RI' then 'Rawat Inap'
            //         when left(NoRegistrasi,1)='B' then 'Obat Bebas'
            //         end as NamaUnit,replace(CONVERT(VARCHAR(11), tglResep, 111), '/','-') as tglResep,ss.[Status Name] as StatusReg,JenisResep,d.username as 'Apoteker',Iter,IterRealisasi,a.Text,a.HasilReviewResep
            //         FROM [Apotik_V1.1SQL].dbo.Orders a
            //         left join [Apotik_V1.1SQL].dbo.[Orders Status] ss on a.[Status ID]=ss.[Status ID]
            //         left join MasterDataSQL.dbo.Admision b on a.[Customer ID]=b.ID
            //         left join MasterDataSQL.dbo.Doctors c on a.Dokter=c.ID
            //         left join [Apotik_V1.1SQL].dbo.employees d on a.[Employee ID]=d.ID
            //         where a.[Order ID]=:noreg_obatbebas
            //  "); 
              $this->db->query("SELECT  c.NoMR,c.PatientName,a.NoRegistrasi,replace(CONVERT(VARCHAR(11), c.Date_of_birth, 111), '/','-') as DOB,f.First_Name as NamaDokter,a.Iter,
              a.IterRealisasi,d.username as 'Apoteker',JenisResep,replace(CONVERT(VARCHAR(11), tglResep, 111), '/','-') as tglResep,'Rawat Inap' JenisPasien,
              a.Text,a.HasilReviewResep
              ,a.NoResep,vd.First_Name as DokterOrder,vd.NoSIP,km.RoomName as NamaUnit,
              case when mp.ID='2' then asu.NamaPerusahaan
              else jpk.NamaPerusahaan end as NamaJaminan,bb.BeratBadan,al.Alergi,a.[Order Date] as tglorder
                                                          from [Apotik_V1.1SQL].dbo.Orders a 
                                                          inner join RawatInapSQL.dbo.Inpatient b on a.NoRegistrasi = b.NoRegRI
                                                          inner join MasterdataSQL.dbo.Admision c on c.NoMR = b.NoMR
                                                          left join [Apotik_V1.1SQL].dbo.employees d on a.[Employee ID]=d.ID
                                                          inner join MasterdataSQL.dbo.Doctors f on f.ID = b.drPenerima
                                                              left join MasterdataSQL.dbo.MstrPerusahaanJPK jpk on b.IDJPK=jpk.ID
                                                              left join MasterdataSQL.dbo.MstrPerusahaanAsuransi asu on b.IDAsuransi=asu.ID
                                                              left join MasterdataSQL.dbo.Doctors vd on a.Dokter=vd.ID
                                                              left join RawatInapSQL.dbo.Inpatient_in_out km on b.RoomID_Akhir=km.ID
                                                              inner join MasterdataSQL.dbo.MstrTypePatient mp on b.TypePatient=mp.ID
                                                              left join (SELECT TOP 1 NoRegistrasi,BeratBadan FROM MedicalRecord.dbo.EMR_RWJ_TTV) bb on a.NoRegistrasi collate  Latin1_General_CS_AS=bb.NoRegistrasi collate  Latin1_General_CS_AS
                                                              left join (SELECT  ID
														   ,STUFF((SELECT ', ' + CAST(Alergen AS VARCHAR(90)) [text()]
															 FROM MedicalRecord.dbo.MR_RiwayatAlergi  
															 WHERE NoMR collate SQL_Latin1_General_CP1_CI_AS= t.NoMR collate SQL_Latin1_General_CP1_CI_AS
															 FOR XML PATH(''), TYPE)
															.value('.','NVARCHAR(MAX)'),1,2,' ') Alergi
													FROM  MasterdataSQL.dbo.Admision t
													GROUP BY ID,NoMR)al on a.[Customer ID]=al.ID
                                                              
                                                          where [Order ID]=:noreg_obatbebas and
                                                          a.OrderBatal='0'
                                                          --RAJAL
                                                          UNION ALL
                                                           SELECT  c.NoMR,c.PatientName,a.NoRegistrasi,replace(CONVERT(VARCHAR(11), c.Date_of_birth, 111), '/','-') as DOB,f.First_Name as NamaDokter,a.Iter,
              a.IterRealisasi,d.username as 'Apoteker',JenisResep,replace(CONVERT(VARCHAR(11), tglResep, 111), '/','-') as tglResep,'Rawat Jalan' JenisPasien,
              a.Text,a.HasilReviewResep
              ,a.NoResep,vd.First_Name as DokterOrder,vd.NoSIP,u.NamaUnit,
              case when mp.ID='2' then asu.NamaPerusahaan
              else jpk.NamaPerusahaan end as NamaJaminan,bb.BeratBadan,al.Alergi,a.[Order Date] as tglorder
                                                          from [Apotik_V1.1SQL].dbo.Orders a 
                                                          inner join PerawatanSQL.dbo.Visit b on a.NoRegistrasi = b.NoRegistrasi
                                                          inner join MasterdataSQL.dbo.Admision c on c.NoMR = b.NoMR
                                                          left join [Apotik_V1.1SQL].dbo.employees d on a.[Employee ID]=d.ID
                                                          inner join MasterdataSQL.dbo.Doctors f on f.ID = b.Doctor_1
                                                              left join MasterdataSQL.dbo.MstrPerusahaanJPK jpk on b.Perusahaan=jpk.ID
                                                              left join MasterdataSQL.dbo.MstrPerusahaanAsuransi asu on b.Asuransi=asu.ID
                                                              left join MasterdataSQL.dbo.Doctors vd on a.Dokter=vd.ID
                                                              left join MasterdataSQL.dbo.MstrUnitPerwatan u on b.Unit=u.ID
                                                              inner join MasterdataSQL.dbo.MstrTypePatient mp on b.PatientType=mp.ID
                                                              left join (SELECT TOP 1 NoRegistrasi,BeratBadan FROM MedicalRecord.dbo.EMR_RWJ_TTV) bb on a.NoRegistrasi collate  Latin1_General_CS_AS=bb.NoRegistrasi collate  Latin1_General_CS_AS
                                                              left join (SELECT  ID
														   ,STUFF((SELECT ', ' + CAST(Alergen AS VARCHAR(90)) [text()]
															 FROM MedicalRecord.dbo.MR_RiwayatAlergi  
															 WHERE NoMR collate SQL_Latin1_General_CP1_CI_AS= t.NoMR collate SQL_Latin1_General_CP1_CI_AS
															 FOR XML PATH(''), TYPE)
															.value('.','NVARCHAR(MAX)'),1,2,' ') Alergi
													FROM  MasterdataSQL.dbo.Admision t
													GROUP BY ID,NoMR)al on a.[Customer ID]=al.ID

                                                          where [Order ID]=:noreg_obatbebas2 and
                                                          a.OrderBatal='0'  
                                                          UNION ALL
                                                          --OBAT BEBAS
                                                        SELECT  '00-00-01' NoMR,a.[Ship Name] as PatientName,a.NoRegistrasi,'' as DOB,f.First_Name as NamaDokter,a.Iter,
              a.IterRealisasi,d.username as 'Apoteker',JenisResep,replace(CONVERT(VARCHAR(11), tglResep, 111), '/','-') as tglResep,'Obat Bebas' JenisPasien,
              a.Text,a.HasilReviewResep
              ,a.NoResep,vd.NamaDokter as DokterOrder,vd.NoSIP,'-' NamaUnit,'-' NamaJaminan,'-' as BeratBadan,'-' as Alergi,a.[Order Date] as tglorder
                                                          from [Apotik_V1.1SQL].dbo.Orders a 
                                                          left join MasterdataSQL.dbo.Doctors f on f.ID = a.Dokter
                                                          left join [Apotik_V1.1SQL].dbo.employees d on a.[Employee ID]=d.ID
                                                          left join MasterdataSQL.dbo.View_Dokter vd on a.Dokter=vd.ID
                                                          where [Order ID]=:noreg_obatbebas3 and
                                                          a.OrderBatal='0'   and a.NoRegistrasi like '%b%'
               "); 
             $this->db->bind('noreg_obatbebas', $orderid); 
             $this->db->bind('noreg_obatbebas2', $orderid);
             $this->db->bind('noreg_obatbebas3', $orderid);
             $key =  $this->db->single();
                                $pasing['NoMR'] = $key['NoMR'];
                                $pasing['PatientName'] = $key['PatientName'];
                                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                                $pasing['DOB'] = $key['DOB'];
                                $pasing['NamaDokter'] = $key['NamaDokter']; 
                                $pasing['Iter'] = $key['Iter'];  
                                $pasing['IterRealisasi'] = $key['IterRealisasi']; 
                                $pasing['Apoteker'] = $key['Apoteker'];   
                                $pasing['JenisResep'] = $key['JenisResep'];  
                                $pasing['tglResep'] = $key['tglResep'];   
                                $pasing['JenisPasien'] = $key['JenisPasien'];  
                                $pasing['Text'] = $key['Text'];    
                                $pasing['HasilReviewResep'] = $key['HasilReviewResep'];

                                $pasing['NamaUnit'] = $key['NamaUnit'];     
                                $pasing['NoResep'] = $key['NoResep'];     
                                $pasing['DokterOrder'] = $key['DokterOrder'];     
                                $pasing['NoSIP'] = $key['NoSIP'];        
                                $pasing['NamaJaminan'] = $key['NamaJaminan'];   
                                $pasing['BeratBadan'] = $key['BeratBadan'];    
                                $pasing['Alergi'] = $key['Alergi'];        
                                $pasing['tglorder'] = $key['tglorder'];        
                                 

                            $callback = array(
                                'message' => "success", // Set array nama 
                                'data' => $pasing
                            );
                            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getListDataOrderDetails($data)
    {
        try {
            $orderid = $data['orderid'];
            $this->db->query(" SELECT a.*,c.ProductType, [Unit Price]*QtyRealisasi*(1-a.Discount) as TotalTarif,d.NamaSatelit,b.Quantity as QtyOrderType,b.OrderTypeID as otid,c.Racikan as o_racikan
                    FROM  [Apotik_V1.1SQL].dbo.[Order Details] a
                    left join [Apotik_V1.1SQL].dbo.tblOrderType b on a.OrdertypeID=b.OrdertypeID
                    inner join [Apotik_V1.1SQL].dbo.tblProductType c on b.ProductTypeID=c.ProductTypeID
                    left join [Apotik_V1.1SQL].dbo.Locations d on a.Locationstok=d.ID
                    where a.[Order ID]=:orderid
                    order by a.OrderTypeID,a.ID asc
             "); 
             $this->db->bind('orderid', $orderid); 
             $data =  $this->db->resultSet();
                            $rows = array();
                            foreach ($data as $key) {
                                $pasing['ID'] = $key['ID'];
                                $pasing['ProductType'] = $key['ProductType'];
                                $pasing['ProductID'] = $key['Product ID'];
                                $pasing['NamaObat'] = $key['NamaObat'];
                                $pasing['Quantity'] = $key['Quantity']; 
                                $pasing['QtyRealisasi'] = $key['QtyRealisasi'];  
                                $pasing['Dosis'] = $key['Dosis']; 
                                $pasing['KekuatanDosis'] = $key['KekuatanDosis'];   
                                $pasing['Signa'] = $key['Signa'];  
                                $pasing['ED'] = $key['ED'];   
                                $pasing['Note1'] = $key['Note1'];
                                $pasing['Note2'] = $key['Note2']; 
                                $pasing['UnitPrice'] = $key['Unit Price']; 
                                $pasing['Discount'] = $key['Discount']; 
                                $pasing['TotalTarif'] = $key['TotalTarif']; 
                                $pasing['Review'] = $key['Review']; 
                                $pasing['UDD'] = $key['UDD']; 
                                $pasing['NamaSatelit'] = $key['NamaSatelit']; 
                                $pasing['QtyOrderType'] = $key['QtyOrderType']; 
                                $pasing['otid'] = $key['otid']; 
                                $pasing['o_racikan'] = $key['o_racikan']; 
                                $rows[] = $pasing;
                            }
                            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getPrintDetail($data)
    {
        try { 
            //$orderr = '110668';
            $this->db->query("SELECT a.ID,a.[Order ID],c.ProductTypeID,d.ProductType,Instruksi+' No. '+CONVERT(varchar(15), c.Quantity) as MF,
            'S. '+a.Signa+' '+a.Note1+' '+a.Note2 as SignaRacik,
            d.Racikan,NamaObat+' NO : '+CONVERT(varchar(15), a.Quantity)+' (QtyReal : '+CONVERT(varchar(15), a.QtyRealisasi)+' )' as NamaO,
            --NamaObat+' (Dosis :'+CONVERT(varchar(15), a.KekuatanDosis)+') '+CONVERT(varchar(15), a.Dosis) +'; Qty: '+CONVERT(varchar(15), a.QtyRealisasi) +')' as NamaObatRacik,
            a.Quantity as Qty, a.Dosis,a.Signa as SignaNormal, a.Note1 as KetNormal, a.Note2 as KetNormal2,
            a.Quantity-a.QtyRealisasi as Det, a.QtyRealisasi as QtyReal, b.Iter,
            NamaObat+' (Qty : '+CONVERT(varchar(15), a.Quantity)+' )' as NamaO_copy,c.OrderTypeID,
            CONVERT(BIGINT, KekuatanDosis) as KekuatanDosis,a.Dosis,NamaObat,
            a.Signa as SignaNonRacik, a.Note1 as Note1NonRacik, a.Note2 as Note2NonRacik,
            c.Signa,c.Note1,c.Note2,
            c.Quantity as QtyOrderType,Instruksi
            FROM [Apotik_V1.1SQL].dbo.[Order Details] a
            INNER JOIN [Apotik_V1.1SQL].dbo.Orders b on a.[Order ID]=b.[Order ID]
            INNER JOIN [Apotik_V1.1SQL].dbo.tblOrderType c on a.OrdertypeID=c.OrderTypeID
            INNER JOIN [Apotik_V1.1SQL].dbo.tblProductType d on c.ProductTypeID=d.ProductTypeID
            WHERE  a.[Order ID]=:NoOrder
            ORDER BY a.ID");
            $this->db->bind('NoOrder', $data['NoOrder']);
            //$this->db->bind('NoOrder', $orderr);
            $data =  $this->db->resultSet();
            $rows = array();

            foreach ($data as $key) {

                $pasing['ID'] = $key['ID'];
                $pasing['OrderID'] = $key['Order ID'];
                $pasing['OrderTypeID'] = $key['OrderTypeID'];
                $pasing['ProductTypeID'] = $key['ProductTypeID'];
                $pasing['ProductType'] = $key['ProductType'];
                $pasing['MF'] = $key['MF'];
                $pasing['SignaRacik'] = $key['SignaRacik'];
                $pasing['NamaO'] = $key['NamaO'];
                $pasing['NamaObat'] = $key['NamaObat'];
                $pasing['KekuatanDosis'] = $key['KekuatanDosis'];
                $pasing['Dosis'] = $key['Dosis'];
                $pasing['Qty'] = $key['Qty'];
                $pasing['Dosis'] = $key['Dosis'];
                $pasing['SignaNormal'] = $key['SignaNormal'];
                $pasing['KetNormal'] = $key['KetNormal'];
                $pasing['KetNormal2'] = $key['KetNormal2'];
                $pasing['Det'] = $key['Det'];
                $pasing['QtyReal'] = $key['QtyReal'];
                $pasing['Iter'] = $key['Iter'];
                $pasing['Racikan'] = $key['Racikan'];
                $pasing['NamaO_copy'] = $key['NamaO_copy'];
                $pasing['Signa'] = $key['Signa'];
                $pasing['Note1'] = $key['Note1'];
                $pasing['Note2'] = $key['Note2'];
                
                $pasing['SignaNonRacik'] = $key['SignaNonRacik'];
                $pasing['Note1NonRacik'] = $key['Note1NonRacik'];
                $pasing['Note2NonRacik'] = $key['Note2NonRacik'];
                $pasing['QtyOrderType'] = $key['QtyOrderType'];
                $pasing['Instruksi'] = $key['Instruksi'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getFooterRacikan($data)
    {
        try { 
            $this->db->query("	SELECT --a.[Order ID],
			max(a.ID) as IDlastgroup,a.OrdertypeID as OrdertypeIDgroup
            FROM [Apotik_V1.1SQL].dbo.[Order Details] a
            INNER JOIN [Apotik_V1.1SQL].dbo.Orders b on a.[Order ID]=b.[Order ID]
            INNER JOIN [Apotik_V1.1SQL].dbo.tblOrderType c on a.OrdertypeID=c.OrderTypeID
            INNER JOIN [Apotik_V1.1SQL].dbo.tblProductType d on c.ProductTypeID=d.ProductTypeID
            WHERE  a.[Order ID]=:NoOrder
			group by 
			a.OrdertypeID--,a.[OrdertypeID]");
            $this->db->bind('NoOrder', $data['NoOrder']);
            $data =  $this->db->resultSet();
            $rows = array();

            foreach ($data as $key) {

                $pasing['IDlastgroup'] = $key['IDlastgroup'];
                $pasing['OrdertypeIDgroup'] = $key['OrdertypeIDgroup'];

                $rows[] = $pasing;
            }
            return $rows;

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getLabelResep($data)
    {
        try { 
            $this->db->query("SELECT * FROM [Apotik_V1.1SQL].dbo.View_LabelEtiket where DetailID=:notrs ");
            $this->db->bind('notrs', $data['notrs']);
            $data =  $this->db->single();

            $pasing['NamaPasien'] = $data['NamaPasien'];
            $pasing['NoMR'] = $data['NoMR'];
            $pasing['Date_of_birth'] = $data['Date_of_birth'];
            $pasing['NoResep'] = $data['NoResep'];
            $pasing['tglResep'] = $data['tglResep'];
            $pasing['ProductName'] = $data['Product Name'];
            $pasing['QtyRealisasi'] = $data['QtyRealisasi'];
            $pasing['UnitSatuan'] = $data['Unit Satuan'];
            $pasing['Composisi'] = $data['Composisi'];
            $pasing['Signa'] = $data['Signa'];
            $pasing['ED'] = $data['ED'];
            $pasing['Note2'] = $data['Note2'];
            $pasing['DetailID'] = $data['DetailID'];
            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getSignaObat($data)
    {
        try { 
            $this->db->query("SELECT a.Signa FROM [Apotik_V1.1SQL].dbo.Products a
            left join [Apotik_V1.1SQL].dbo.[Order Details] b on a.ID=b.[Product ID]
            where b.ID=:notrs ");
               $this->db->query("SELECT a.Signa FROM [Apotik_V1.1SQL].dbo.Products a
               left join [Apotik_V1.1SQL].dbo.[Order Details] b on a.ID=b.[Product ID]
               where b.ID=:notrs ");
            $this->db->bind('notrs', $data['notrs']);
            $data =  $this->db->single();
            $pasing['Signa'] = $data['Signa'];
            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getSignaObat_New($data)
    {
        try { 
            $this->db->query("SELECT Signa FROM [Apotik_V1.1SQL].dbo.Products 
            where ID=:KodeBarang ");
            $this->db->bind('KodeBarang', $data['KodeBarang']);
            $data =  $this->db->single();
            $pasing['Signa'] = $data['Signa'];
            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function EditSigna($data)
    {
        try {
            $this->db->transaksi();

            $id = $data['id_detail'];
            $signa = $data['Signa_edit'];

                $query = "UPDATE [Apotik_V1.1SQL].dbo.[Order Details] SET Signa=:signa WHERE ID=:iddata";


                // Update
                $this->db->query($query);
                $this->db->bind('iddata', $id);
                $this->db->bind('signa', $signa);
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

    public function printBarcode($data){

        $dob = date('d/m/Y', strtotime($data['listdata1']['Date_of_birth']));
        $tglResep = date('d/m/Y', strtotime($data['listdata1']['tglResep']));

        $filename = $data['listdata1']['DetailID'].".prn";
        $handle =fopen("C:\\\\xampp\\htdocs\\esiryarsi\\public\\".$filename,"w");

        $isi = 'SIZE 59.10 mm, 40 mm
        DIRECTION 0,0
        REFERENCE 0,0
        OFFSET 0 mm
        SET PEEL OFF
        SET CUTTER OFF
        SET PARTIAL_CUTTER OFF
        SET TEAR ON
        CLS
        CODEPAGE 1252
        TEXT 447,291,"1",180,1,1,"Nama"
        TEXT 341,291,"1",180,1,1,"'.$data['listdata1']['NamaPasien'].'"
        DIAGONAL 465,266,464,269,3
        BAR 29,267, 436, 2
        TEXT 447,253,"1",180,1,1,"No MR"
        TEXT 225,253,"1",180,1,1,"Tgl Lahir"
        TEXT 447,223,"1",180,1,1,"No Resep"
        TEXT 447,192,"1",180,1,1,"Tgl Resep"
        TEXT 354,291,"1",180,1,1,":"
        TEXT 354,253,"1",180,1,1,":"
        TEXT 354,223,"1",180,1,1,":"
        TEXT 354,192,"1",180,1,1,":"
        TEXT 144,253,"1",180,1,1,":"
        TEXT 341,253,"1",180,1,1,"'.$data['listdata1']['NoMR'].'"
        TEXT 341,223,"1",180,1,1,"'.$data['listdata1']['NoResep'].'"
        TEXT 341,192,"1",180,1,1,"'.$tglResep.'"
        TEXT 129,253,"1",180,1,1,"'.$dob.'"
        BAR 26,169, 436, 2
        TEXT 225,192,"1",180,1,1,"No Urut"
        TEXT 129,192,"1",180,1,1,"01"
        TEXT 144,192,"1",180,1,1,":"
        TEXT 466,151,"1",180,1,1,"'.$data['listdata1']['ProductName']. ' ('.$data['listdata1']['QtyRealisasi'].' '.$data['listdata1']['UnitSatuan'].')"
        TEXT 279,130,"1",180,1,1,"'.$data['listdata1']['Composisi'].'"
        TEXT 270,102,"1",180,1,1,"'.$data['listdata1']['Signa'].'"
        TEXT 319,43,"1",180,1,1,"- EXPIRED DATE : "
        TEXT 149,43,"1",180,1,1,"'.$data['listdata1']['ED'].'"
        TEXT 430,43,"1",180,1,1,"'.$data['getSignaObat']['Signa'].'"
        PRINT 1,1';

        fwrite($handle, $isi);
        fclose($handle);

        //$filename = $data['listdata1']['DetailID'].".prn";
        // file_put_contents($filename,trim($val));
        //var_dump(file_get_contents($filename));

        
        $cmd = shell_exec('COPY C:\\\\xampp\\htdocs\\ESIRYARSI\\public\\'.$filename.' /B \\\\172.16.40.134\\BlueprintTDx');
        
        // echo $cmd;
        // system($cmd);

        unlink($filename);

        // $callback = array(
        //     'status' => 'success', 
        //     'message' => 'Cetak Berhasil !', 
        // );
        // return $callback;

        
        }

        public function printLabelAll($data){
            try {
            $dob = date('d/m/Y', strtotime($data['listdata1'][0]['dob']));
            $tglResep = date('d/m/Y', strtotime($data['listdata1'][0]['TglResep']));
            $printer = '\\\\'.$data['getPrinterLabel']['data'][0]['IPPrinterSharing'].'\\'.$data['getPrinterLabel']['data'][0]['NamaPrinterSharing'];
            $filename = $data['listdata1'][0]['IDDetail'].".prn";
            $handle =fopen("C:\\\\xampp\\htdocs\\esiryarsi\\public\\".$filename,"w");
    
            $isi = 'SIZE 59.10 mm, 40 mm
            DIRECTION 0,0
            REFERENCE 0,0
            OFFSET 0 mm
            SET PEEL OFF
            SET CUTTER OFF
            SET PARTIAL_CUTTER OFF
            SET TEAR ON
            CLS
            CODEPAGE 1252
            TEXT 447,291,"1",180,1,1,"Nama"
            TEXT 341,291,"1",180,1,1,"'.$data['listdata1'][0]['PatientName'].'"
            DIAGONAL 465,266,464,269,3
            BAR 29,267, 436, 2
            TEXT 447,253,"1",180,1,1,"No MR"
            TEXT 225,253,"1",180,1,1,"Tgl Lahir"
            TEXT 447,223,"1",180,1,1,"No Resep"
            TEXT 447,192,"1",180,1,1,"Tgl Resep"
            TEXT 354,291,"1",180,1,1,":"
            TEXT 354,253,"1",180,1,1,":"
            TEXT 354,223,"1",180,1,1,":"
            TEXT 354,192,"1",180,1,1,":"
            TEXT 144,253,"1",180,1,1,":"
            TEXT 341,253,"1",180,1,1,"'.$data['listdata1'][0]['NoMR'].'"
            TEXT 341,223,"1",180,1,1,"'.$data['listdata1'][0]['NoRegistrasi'].'"
            TEXT 341,192,"1",180,1,1,"'.$tglResep.'"
            TEXT 129,253,"1",180,1,1,"'.$dob.'"
            BAR 26,169, 436, 2
            TEXT 225,192,"1",180,1,1,"No Urut"
            TEXT 129,192,"1",180,1,1,"01"
            TEXT 144,192,"1",180,1,1,":"
            TEXT 466,151,"1",180,1,1,"'.$data['listdata1'][0]['NamaBarang']. ' ('.$data['listdata1'][0]['QryRealisasi'].' '.$data['listdata1'][0]['UnitSatuan'].')"
            TEXT 279,130,"1",180,1,1,"'.$data['listdata1'][0]['Composisi'].'"
            TEXT 270,102,"1",180,1,1,"'.$data['listdata1'][0]['SignaTerjemahan'].'"
            TEXT 319,43,"1",180,1,1,"- EXPIRED DATE : "
            TEXT 149,43,"1",180,1,1,""
            TEXT 430,43,"1",180,1,1,"'.$data['getSignaObat']['Signa'].'"
            PRINT 1,1';
    
            fwrite($handle, $isi);
            fclose($handle);
    
            $cmd = shell_exec('COPY C:\\\\xampp\\htdocs\\ESIRYARSI\\public\\'.$filename.' /B '.$printer);
    
            //unlink($filename);

            // if ($cmd == '0 file(s) copied. '){
            //     $callback = array(
            //         'status' => 'warning', 
            //         'message' => 'Cetak Gagal !', 
            //     );
            // }else{
                $callback = array(
                    'status' => 'success', 
                    'message' => 'Cetak Berhasil !' . $cmd, 
                );
            //}
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

        public function viewOrderResepbyDatePeriode($data)
        {
            try { 
                $tglawal = $data['tglawal'];
                $tglakhir = $data['tglakhir'];
                // 1. Gen Token
                $method = "POST";
                $URL = "genToken";
                $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

                // 2. add Data Group Barang 
                $method_getgroup = "POST";
                // 2. add Data Golongan
                $postData = '
                {
                    "tglPeriodeAwal" : "'.$tglawal.'" ,
                    "tglPeriodeAkhir" : "'.$tglakhir.'" 
                }
                ';
                //$urlAddKelompok = "transaction/sales/getConsumableChargedPeriode";
                $urlAddKelompok = "ResepTransactions/v2/viewOrderResepbyDatePeriode/";
                $addSatuan = $this->curl_request(
                    GenerateTokenRS::headers_api_token($token['access_token']),
                    $method_getgroup,
                    $postData,
                    $urlAddKelompok
                );
                return $addSatuan['data'];
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        public function viewOrderResepbyOrderIDV2($data)
        {
            try { 
                $OrderID = $data['OrderID'];
                // 1. Gen Token
                $method = "POST";
                $URL = "genToken";
                $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

                // 2. add Data Group Barang 
                $method_getgroup = "POST";
                // 2. add Data Golongan
                $postData = '
                {
                    "OrderID" : "'.$OrderID.'" 
                }
                ';
                $urlAddKelompok = "ResepTransactions/v2/viewOrderResepbyOrderIDV2/";
                $addSatuan = $this->curl_request(
                    GenerateTokenRS::headers_api_token($token['access_token']),
                    $method_getgroup,
                    $postData,
                    $urlAddKelompok
                );
                return $addSatuan;
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        public function addSalesHeader($data)
        {
            try { 
                $TransasctionDate = $data['TransasctionDate'];
                $NoRegistrasi = $data['NoRegistrasi'];
                $No_Order = $data['No_Order'];
                $Unit = $data['Unit'];
                $Unit_Farmasi = $data['Unit_Farmasi'];
                $Notes = $data['Notes'];
                $NamaPembeli = $data['Nama'];
                $GenderPembeli = $data['JenisKelamin'];
                $AlamatPembeli = $data['Alamat'];
                $TglLahirPembeli = $data['Tgl_Lahir'];
                $TipePasien = $data['TipePasien'];
                $KodeJaminan = $data['KodeJaminan'];
                $isresep = $data['isresep'];
                $Jaminan = $data['Jaminan'];


                // 1. Gen Token
                $method = "POST";
                $URL = "genToken";
                $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

                $session = SessionManager::getCurrentSession();
                $userid = $session->username;
                $name = $session->name;

                // 2. add Data Group Barang 
                $method_getgroup = "POST";
                // 2. add Data Golongan
                $postData = '
                {
                    "TransactionDate" : "'.$TransasctionDate.'",
                    "UserCreate" : "'.$userid.'",
                    "UnitOrder" : "'.$Unit.'", 
                    "UnitTujuan" : "'.$Unit_Farmasi.'", 
                    "NoRegistrasi" : "'.$NoRegistrasi.'", 
                    "Group_Transaksi" : "'. $isresep . '", 
                    "Notes" : "'.$Notes.'" ,
                    "NoResep" : "'.$No_Order.'" ,
                    "NamaPembeli" : "'.$NamaPembeli.'" ,
                    "GenderPembeli" : "'.$GenderPembeli.'" ,
                    "AlamatPembeli" : "'.$AlamatPembeli.'" ,
                    "Jaminan" : "'.$Jaminan.'" ,
                    "TglLahirPembeli" : "'.$TglLahirPembeli.'" ,
                    "GroupJaminan" : "'.$TipePasien.'" ,
                    "KodeJaminan" : "'.$KodeJaminan.'" 
                }
                ';
                $urlAddKelompok = "transaction/sales/addSalesHeader/";
                $addSatuan = $this->curl_request(
                    GenerateTokenRS::headers_api_token($token['access_token']),
                    $method_getgroup,
                    $postData,
                    $urlAddKelompok
                );
                return $addSatuan;
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        public function getOrderResepDetail($data)
        {
            try { 
                $OrderID = $data['OrderID'];
                $NoRegistrasi = $data['NoRegistrasi'];
                $KodeKelas = $data['KodeKelas'];
                //$OrderID = $data['OrderID'];
                // 1. Gen Token
                $method = "POST";
                $URL = "genToken";
                $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

                // 2. add Data Group Barang 
                $method_getgroup = "POST";
                // 2. add Data Golongan
                $postData = '
                {
                    "OrderID" : "'.$OrderID.'" ,
                    "GroupJaminan" : "UM" ,
                    "NoRegistrasi" : "'.$NoRegistrasi.'" ,
                    "Kelas" : "'.$KodeKelas.'" 
                }
                ';
                $urlAddKelompok = "ResepTransactions/v2/viewOrderResepDetailbyOrderIDV2/";
                $addSatuan = $this->curl_request(
                    GenerateTokenRS::headers_api_token($token['access_token']),
                    $method_getgroup,
                    $postData,
                    $urlAddKelompok
                );
                return $addSatuan['data'];
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        public function EditSignaNew($data)
        {
            try { 
                $ID = $data['ID'];
                $SignaTerjemahan = $data['SignaTerjemahan'];
                // 1. Gen Token
                $method = "POST";
                $URL = "genToken";
                $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

                // 2. add Data Group Barang 
                $method_getgroup = "POST";
                // 2. add Data Golongan
                $postData = '
                {
                    "ID": "'.$ID.'",
                    "SignaTerjemahan": "'.$SignaTerjemahan.'"
                }
                ';
                $urlAddKelompok = "ResepTransactions/v2/editSignaTerjemahanbyID/";
                $addSatuan = $this->curl_request(
                    GenerateTokenRS::headers_api_token($token['access_token']),
                    $method_getgroup,
                    $postData,
                    $urlAddKelompok
                );
                //return $addSatuan;
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        public function addSalesDetail($data)
        {
            try { 
                $grandtotalqty = str_replace(".", "", $data['grandtotalqty']);
                $totalrow = str_replace(".", "", $data['totalrow']);
                $grandtotalxl = str_replace(".", "", $data['grandtotalxl']);
                $hargatotal = str_replace(".", "", $data['hargatotal']);
                $discount = 0;
                $tax = 0;
                
                $TransactionCode = $data['No_Transaksi'];
                $TransasctionDate = $data['TransasctionDate'];
                $NoRegistrasi = $data['NoRegistrasi'];
                $No_MR = $data['No_MR'];
                $No_Episode = $data['No_Episode'];
                $No_Order = $data['No_Order'];
                $Unit = $data['Unit'];
                $Unit_Farmasi = $data['Unit_Farmasi'];
                $Notes = $data['Notes'];
                $GrupJaminan = $data['TipePasien'];
                $KodeKelas = $data['KodeKelas'];
                $isresep = $data['isresep'];


                $KodeJaminan = $data['KodeJaminan'];

                $hidden_kode_barang = str_replace(".", "", $data['hidden_kode_barang']);
                $hidden_nama_barang_ = $data['hidden_nama_barang_'];
                $hidden_signa_latin_ = $data['hidden_signa_latin_'];
                $hidden_signa_terjemahan = $data['hidden_signa_terjemahan'];
                $hidden_qty_barang_ = str_replace(".", "", $data['hidden_qty_barang_']);
                $hidden_qtyreal_barang_ = str_replace(".", "", $data['hidden_qtyreal_barang_']);
                $hidden_harga_barang_ = str_replace(".", "", $data['hidden_harga_barang_']);
                $hidden_satuan_barang_ = $data['hidden_satuan_barang_'];
                $hidden_subtotal_ = str_replace(".", "", $data['hidden_subtotal_']);
                $hidden_discrp_barang_ = str_replace(".", "", $data['hidden_discrp_barang_']);
                $hidden_discpros_barang_ = str_replace(".", "", $data['hidden_discpros_barang_']);
                $hidden_taxrp_ = str_replace(".", "", $data['hidden_taxrp_']);
                $hidden_grandtotal_ = str_replace(".", "", $data['hidden_grandtotal_']);
                $hidden_satuan_konversi_ = $data['hidden_satuan_konversi_'];
                $hidden_konversi_satuan_ = $data['hidden_konversi_satuan_'];
                $hidden_racik_header_ = $data['hidden_racik_header_'];
                $hidden_racik_ = $data['hidden_racik_'];
                $hidden_ID_ = $data['hidden_ID_'];
                $diskonxRp = str_replace(".", "", $data['diskonxRp']);
                $diskonxPros = str_replace(".", "", $data['diskonxPros']);
                $taxxRp = str_replace(".", "", $data['taxxRp']);
                $subtotalttlrp = str_replace(".", "", $data['subtotalttlrp']);
                $uangr = str_replace(".", "", $data['uangr']);
                $embalase = str_replace(".", "", $data['embalase']);

                $grandtotalqty = str_replace(",", ".", $grandtotalqty);
                $totalrow = str_replace(",", ".", $totalrow);
                $grandtotalxl = str_replace(",", ".", $grandtotalxl);
                $hargatotal = str_replace(",", ".", $hargatotal);
                $hidden_kode_barang = str_replace(",", ".", $hidden_kode_barang);
                // $hidden_nama_barang_ = str_replace(",", ".", $hidden_nama_barang_);
                // $hidden_signa_latin_ = str_replace(",", ".", $hidden_signa_latin_);
                // $hidden_signa_terjemahan = str_replace(",", ".", $hidden_signa_terjemahan);
                $hidden_qty_barang_ = str_replace(",", ".", $hidden_qty_barang_);
                $hidden_qtyreal_barang_ = str_replace(",", ".", $hidden_qtyreal_barang_);
                $hidden_harga_barang_ = str_replace(",", ".", $hidden_harga_barang_);
                $hidden_subtotal_ = str_replace(",", ".", $hidden_subtotal_);
                $hidden_discrp_barang_ = str_replace(",", ".", $hidden_discrp_barang_);
                $hidden_discpros_barang_ = str_replace(",", ".", $hidden_discpros_barang_);
                $hidden_taxrp_ = str_replace(",", ".", $hidden_taxrp_);
                $hidden_grandtotal_ = str_replace(",", ".", $hidden_grandtotal_);
                $diskonxRp = str_replace(",", ".", $diskonxRp);
                $diskonxPros = str_replace(",", ".", $diskonxPros);
                $taxxRp = str_replace(",", ".", $taxxRp);
                $subtotalttlrp = str_replace(",", ".", $subtotalttlrp);
                $uangr = str_replace(",", ".", $uangr);
                $embalase = str_replace(",", ".", $embalase);
                

            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $UserCreate = $session->username;

            $jumlah_dipilih = count($hidden_kode_barang);

            $qtytotal = 0;
            $nourut=0;
            $rows = array();
           
            for($x=0;$x<$jumlah_dipilih;$x++){

                $nomor = $x +1 ;

                
                //CEK
                if ($hidden_racik_[$x] <> 0 ){
                    if ($hidden_racik_header_[$x] == 1){
                        if ($hidden_signa_terjemahan[$x] == "") {
                            $callback = array(
                                'status' => 'warning',
                                'errorname' => 'Signa Terjemahan Nomor '.$nomor.' Masih Kosong !',
                            );
                            return $callback;
                            exit;
                        } 
                    }
                }else{
                    if ($hidden_signa_terjemahan[$x] == "") {
                        $callback = array(
                            'status' => 'warning',
                            'errorname' => 'Signa Terjemahan Nomor '.$nomor.' Masih Kosong !',
                        );
                        return $callback;
                        exit;
                    } 
                }

                if ($hidden_qtyreal_barang_[$x] == ''){
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Qty Realisasi Nomor '.$nomor.' Masih Kosong !',
                    );
                    return $callback;
                    exit;
                }
                
                //END CEK
                $nourut++;

                if ($hidden_kode_barang[$x] != null && $hidden_kode_barang[$x] != 'null'){

                    $kodebarang = $hidden_kode_barang[$x];

                    $qtytotal += $hidden_qtyreal_barang_[$x];
                        $pasing['IDResepDetail'] =   $hidden_ID_[$x];
                        $pasing['ProductCode'] =   $kodebarang;
                        $pasing['ProductSatuan'] =    $hidden_satuan_barang_[$x];
                        $pasing['Satuan_Konversi'] = $hidden_satuan_konversi_[$x];
                        $pasing['KonversiQty'] = $hidden_konversi_satuan_[$x];//p
                        $pasing['Konversi_QtyTotal'] = $hidden_qtyreal_barang_[$x]*$hidden_konversi_satuan_[$x];//p
                        $pasing['ProductName'] =    $hidden_nama_barang_[$x];
                        $pasing['QtyResep'] =   $hidden_qty_barang_[$x];
                        $pasing['Qty'] =   $hidden_qtyreal_barang_[$x];
                        $pasing['Harga'] =   $hidden_harga_barang_[$x];
                        $pasing['SubtotalHarga'] =   $hidden_subtotal_[$x];
                        $pasing['DiscountProsen'] =   $hidden_discpros_barang_[$x];//p
                        $pasing['Discount'] =   $hidden_discrp_barang_[$x];//p
                        $pasing['Subtotal'] =  $hidden_subtotal_[$x];
                        $pasing['Tax'] =  $hidden_taxrp_[$x];
                        $pasing['Grandtotal'] =   $hidden_grandtotal_[$x];
                        $pasing['UserAdd'] =    $UserCreate;
                        $pasing['DateAdd'] =    $datenowcreate;
                        $pasing['AturanPakai'] =   $hidden_signa_terjemahan[$x];
                        $pasing['Racik'] =   $hidden_racik_[$x];
                        $pasing['RacikHeader'] =   $hidden_racik_header_[$x];
                        $pasing['UangR'] =   $uangr[$x];
                        $pasing['Embalase'] =   $embalase[$x];

                        $rows[] = $pasing;
                }
                        
                }
                $list = json_encode($rows);



                // 1. Gen Token
                $method = "POST";
                $URL = "genToken";
                $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

                $session = SessionManager::getCurrentSession();
                $userid = $session->username;
                $name = $session->name;

                // 2. add Data Group Barang 
                $method_getgroup = "POST";
                // 2. add Data Golongan
                $postData = '
                {
                    "TransactionCode" : "'.$TransactionCode.'", 
                    "NoRegistrasi" : "'.$NoRegistrasi.'", 
                    "NoMr" : "'.$No_MR.'", 
                    "NoEpisode" : "'.$No_Episode.'",  
                    "GroupJaminan" : "'.$GrupJaminan.'" ,  
                    "KodeJaminan" : "'.$KodeJaminan.'" ,  
                    "UnitOrder" : "'.$Unit.'" ,  
                    "UnitTujuan" : "'.$Unit_Farmasi.'" ,   
                    "KodeKelas" : "'.$KodeKelas.'" ,   
                    "Notes" : "'.$Notes.'",
                    "Group_Transaksi" : "'.$isresep.'",
                    "TotalQtyOrder" : "'.$grandtotalqty.'",
                    "TotalRow" : "'.$totalrow.'",
                    "TotalSales" : "'.$hargatotal.'",
                    "SubtotalQtyPrice" : "'.$grandtotalxl.'",
                    "Discount_Prosen" : "'.$diskonxPros.'",
                    "Discount" : "'.$diskonxRp.'",
                    "Tax" : "'.$taxxRp.'",
                    "Subtotal" : "'.$subtotalttlrp.'",
                    "Grandtotal" : "'.$grandtotalxl.'", 
                    "TransactionDate" : "'.$TransasctionDate.'",
                    "UserCreate" : "'.$userid.'",
                    "IdOrderResep" : "'.$No_Order.'",
                    "Items":  '.$list.'
                }
                ';
                $urlAddKelompok = "transaction/sales/addSalesDetail/";
                $addSatuan = $this->curl_request(
                    GenerateTokenRS::headers_api_token($token['access_token']),
                    $method_getgroup,
                    $postData,
                    $urlAddKelompok
                );
            //    if ($addSatuan['status'] == true){
            //     for($x=0;$x<$jumlah_dipilih;$x++){
            //         $pasings['ID'] = $hidden_ID_[$x];
            //         $pasings['SignaTerjemahan'] = $hidden_signa_terjemahan[$x];
            //         if ($hidden_racik_[$x] <> 0 ){
            //             if ($hidden_racik_header_[$x] == 1){
            //                 $this->EditSignaNew($pasings);
            //             }
            //         }else{
            //                 $this->EditSignaNew($pasings);
            //         }
            //     }
            //         $this->editReviewbyIDResep($No_Order);
            //    }
               
               return $addSatuan;
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        public function finishSalesTransaction($data)
        {
            try { 
                $TransactionCode = $data['No_Transaksi'];
                $Unit_Farmasi = $data['Unit_Farmasi'];
                $UnitOrder = $data['Unit'];
                $Notes = $data['Notes'];
                $HasilReview = $data['HasilReview'];

                $subtotalttlrp = str_replace(".", "", $data['subtotalttlrp']);
                $grandtotalqty = str_replace(".", "", $data['grandtotalqty']);
                $totalrow = str_replace(".", "", $data['totalrow']);
                $grandtotalxl = str_replace(".", "", $data['grandtotalxl']);
                $hargatotal = str_replace(".", "", $data['hargatotal']);
                $diskonxRp = str_replace(".", "", $data['diskonxRp']);
                $taxxRp = str_replace(".", "", $data['taxxRp']);
                

                $subtotalttlrp = str_replace(",", ".", $subtotalttlrp);
                $grandtotalqty = str_replace(",", ".", $grandtotalqty);
                $totalrow = str_replace(",", ".", $totalrow);
                $grandtotalxl = str_replace(",", ".", $grandtotalxl);
                $hargatotal = str_replace(",", ".", $hargatotal);
                $diskonxRp = str_replace(",", ".", $diskonxRp);
                $taxxRp = str_replace(",", ".", $taxxRp);

                $session = SessionManager::getCurrentSession();
                $userid = $session->username;
                // 1. Gen Token
                $method = "POST";
                $URL = "genToken";
                $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

                // 2. add Data Group Barang 
                $method_getgroup = "POST";
                // 2. add Data Golongan
                $postData = '
                {
                    "TransactionCode" : "'.$TransactionCode.'" ,
                    "UnitTujuan" : "'.$Unit_Farmasi.'",
                    "UnitOrder" : "'.$UnitOrder.'",
                    "Notes" : "'.$Notes.'",
                    "TotalQtyOrder" : "'.$grandtotalqty.'",
                    "TotalSales" : "'.$hargatotal.'",
                    "TotalRow" : "'.$totalrow.'",
                    "Discount" : "'.$diskonxRp.'",
                    "Subtotal" : "'.$subtotalttlrp.'",
                    "Tax" : "'.$taxxRp.'",
                    "Grandtotal" : "'.$grandtotalxl.'",
                    "UserCreateLast" : "'.$userid.'" ,
                    "HasilReview" : "'.$HasilReview.'"
                }

                ';
                $urlAddKelompok = "transaction/sales/finishSalesTransaction/";
                $addSatuan = $this->curl_request(
                    GenerateTokenRS::headers_api_token($token['access_token']),
                    $method_getgroup,
                    $postData,
                    $urlAddKelompok
                );
                return $addSatuan;
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        public function viewprintLabelbyID($data)
        {
            try { 
                $ID = $data['notrs'];
                // 1. Gen Token
                $method = "POST";
                $URL = "genToken";
                $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

                // 2. add Data Group Barang 
                $method_getgroup = "POST";
                // 2. add Data Golongan
                $postData = '
                {
                    "ID" : "'.$ID.'" 
                }
                ';
                $urlAddKelompok = "ResepTransactions/v2/viewprintLabelbyID/";
                $addSatuan = $this->curl_request(
                    GenerateTokenRS::headers_api_token($token['access_token']),
                    $method_getgroup,
                    $postData,
                    $urlAddKelompok
                );
                return $addSatuan['data'];
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        public function getPrinterLabel($data)
        {
            try { 
                $ip  = $_SERVER['REMOTE_ADDR'];
                //cek jika localhost (for development)
                if ($ip == '::1'){
                    $ip = gethostbyname(trim(`hostname`));
                }
                $getSignaObat = $data['getSignaObat']['Signa'];
                if ($getSignaObat == 'OBAT LUAR'){
                    $getSignaObat = 'ETIKETOBAT_LUAR';
                }else{
                    $getSignaObat = 'ETIKETOBAT_DALAM';
                }
                // 1. Gen Token
                $method = "POST";
                $URL = "genToken";
                $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

                // 2. add Data Group Barang 
                $method_getgroup = "POST";
                // 2. add Data Golongan
                $postData = '
                {
                    "ipkomputer" : "'.$ip.'" ,
                    "signaobat" : "'.$getSignaObat.'" 
                }
                ';
                $urlAddKelompok = "ResepTransactions/v2/getPrinterLabel/";
                $addSatuan = $this->curl_request(
                    GenerateTokenRS::headers_api_token($token['access_token']),
                    $method_getgroup,
                    $postData,
                    $urlAddKelompok
                );
                return $addSatuan;
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        public function editReviewbyIDResep($data)
        {
            try { 
                $IdOrderResep = $data;
                // 1. Gen Token
                $method = "POST";
                $URL = "genToken";
                $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

                // 2. add Data Group Barang 
                $method_getgroup = "POST";
                // 2. add Data Golongan
                $postData = '
                {
                    "IdOrderResep": "'.$IdOrderResep.'"
                }
                ';
                $urlAddKelompok = "ResepTransactions/v2/editReviewbyIDResep/";
                $addSatuan = $this->curl_request(
                    GenerateTokenRS::headers_api_token($token['access_token']),
                    $method_getgroup,
                    $postData,
                    $urlAddKelompok
                );
                //return $addSatuan;
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        public function voidSales($data)
        {
            try { 
                $TransactionCode = $data['No_Transaksi'];
                $Unit = $data['Unit'];
                $alasan = $data['AlasanBatal'];
                $datenowcreate = Utils::seCurrentDateTime();
                $session = SessionManager::getCurrentSession();
                $userid = $session->username;
                // 1. Gen Token
                $method = "POST";
                $URL = "genToken";
                $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

                // 2. add Data Group Barang 
                $method_getgroup = "POST";
                // 2. add Data Golongan
                $postData = '
                {
                    "TransactionCode" : "'.$TransactionCode.'", 
                    "UnitCode" : "'.$Unit.'",  
                    "ReasonVoid" : "'.$alasan.'",
                    "DateVoid" : "'.$datenowcreate.'",
                    "UserVoid" : "'.$userid.'",
                    "Void" : "1"
                }
                ';
                $urlAddKelompok = "transaction/sales/voidSales/";
                $addSatuan = $this->curl_request(
                    GenerateTokenRS::headers_api_token($token['access_token']),
                    $method_getgroup,
                    $postData,
                    $urlAddKelompok
                );
                return $addSatuan;
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        public function addSalesHeaderTanpaResep($data)
        {
            try { 
                $TransasctionDate = $data['TransasctionDate'];
                $NoRegistrasi = $data['NoRegistrasi'];
                $Unit = $data['Unit'];
                $Unit_Farmasi = $data['Unit_Farmasi'];
                $Notes = $data['Notes'];
                $NamaPembeli = $data['Nama'];
                $GenderPembeli = $data['JenisKelamin'];
                $AlamatPembeli = $data['Alamat'];
                $TglLahirPembeli = $data['Tgl_Lahir'];
                $JenisPasien = $data['JenisPasien'];
                $NIP_Karyawan = $data['NIP_Karyawan'];
                $TipePasien = $data['TipePasien'];
                $KodeJaminan = $data['KodeJaminan'];
                $isresep = $data['isresep'];
                $KodeJaminan_Nama = $data['KodeJaminan_Nama'];

                if ($NamaPembeli == null){
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Nama Masih Kosong !',
                    );
                    return $callback;
                    exit;
                }


                // 1. Gen Token
                $method = "POST";
                $URL = "genToken";
                $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

                $session = SessionManager::getCurrentSession();
                $userid = $session->username;
                $name = $session->name;

                // 2. add Data Group Barang 
                $method_getgroup = "POST";
                // 2. add Data Golongan
                $postData = '
                {
                    "TransactionDate" : "'.$TransasctionDate.'",
                    "UserCreate" : "'.$userid.'",
                    "UnitOrder" : "'.$Unit.'", 
                    "UnitTujuan" : "'.$Unit_Farmasi.'", 
                    "Group_Transaksi" : "'.$isresep.'", 
                    "Notes" : "'.$Notes.'" ,
                    "NamaPembeli" : "'.$NamaPembeli.'" ,
                    "GenderPembeli" : "'.$GenderPembeli.'" ,
                    "AlamatPembeli" : "'.$AlamatPembeli.'" ,
                    "TglLahirPembeli" : "'.$TglLahirPembeli.'" ,
                    "JenisPasien" : "'.$JenisPasien.'" ,
                    "NIP_Karyawan" : "'.$NIP_Karyawan.'" ,
                    "GroupJaminan" : "'.$TipePasien.'" ,
                    "KodeJaminan" : "'.$KodeJaminan.'" ,
                    "Jaminan" : "'.$KodeJaminan_Nama.'"
                }
                ';
                $urlAddKelompok = "transaction/sales/addSalesHeader/";
                $addSatuan = $this->curl_request(
                    GenerateTokenRS::headers_api_token($token['access_token']),
                    $method_getgroup,
                    $postData,
                    $urlAddKelompok
                );
                return $addSatuan;
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        public function getSalesbyDateUser()
    {
        try { 
            $session = SessionManager::getCurrentSession();
            $UserCreate = $session->username;
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '{ 
                "UserCreate" : "' . $UserCreate . '" 
            }';
            $urlAddKelompok = "transaction/sales/getSalesbyDateUser/";
            $addSatuan = $this->curl_request(
                GenerateTokenRS::headers_api_token($token['access_token']),
                $method_getgroup,
                $postData,
                $urlAddKelompok
            );
            if ($addSatuan['status'] == true){
                $callback = $addSatuan['data'];
            }else{
                $callback = [];
            }
            return $callback;
            //return $addSatuan['data'];
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getSalesbyPeriode($data)
    {
        try { 
            $tglawal = $data['tglawal'];
            $tglakhir = $data['tglakhir'];
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '{ 
                "StartPeriode" : "' . $tglawal . '" ,
                "EndPeriode" : "' . $tglakhir . '" 
            }';
            $urlAddKelompok = "transaction/sales/getSalesbyPeriode/";
            $addSatuan = $this->curl_request(
                GenerateTokenRS::headers_api_token($token['access_token']),
                $method_getgroup,
                $postData,
                $urlAddKelompok
            );
            if ($addSatuan['status'] == true){
                $callback = $addSatuan['data'];
            }else{
                $callback = [];
            }
            return $callback;
            //return $addSatuan['data'];
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getSalesbyID($data)
    {
        try { 
            $TransasctionCode = $data['TransasctionCode'];
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '{ 
                "TransactionCode" : "' . $TransasctionCode . '" 
            }';
            $urlAddKelompok = "transaction/sales/getSalesbyID/";
            $addSatuan = $this->curl_request(
                GenerateTokenRS::headers_api_token($token['access_token']),
                $method_getgroup,
                $postData,
                $urlAddKelompok
            );
            return $addSatuan;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getSalesDetailbyID($data)
        {
            try { 
                $TransactionCode = $data['TransactionCode'];
                // 1. Gen Token
                $method = "POST";
                $URL = "genToken";
                $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

                // 2. add Data Group Barang 
                $method_getgroup = "POST";
                // 2. add Data Golongan
                $postData = '
                {
                    "TransactionCode" : "'.$TransactionCode.'" 
                }
                ';
                $urlAddKelompok = "transaction/sales/getSalesDetailbyID/";
                $addSatuan = $this->curl_request(
                    GenerateTokenRS::headers_api_token($token['access_token']),
                    $method_getgroup,
                    $postData,
                    $urlAddKelompok
                );
                return $addSatuan['data'];
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        public function getDataKaryawan($data)
    {
        try { 
            $search = $data['search'];
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            //$token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "GET";
            // 2. add Data Golongan
            $postData = '';
            $header = array(
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization: Bearer 
                eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMjAyLjUxLjE5Ni44OS9hcGkvdjEvYXV0aC9sb2dpbiIsImlhdCI6MTcxMTExMzkxNywiZXhwIjoxNzM3MDMzOTE3LCJuYmYiOjE3MTExMTM5MTcsImp0aSI6IjBXWGVHSDZjNndiRG1ZMUciLCJzdWIiOiIxIiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.do7Q75tVLHefk7syslsv8bzvtd7tpYGA-2ZkhY_5ESc'
            );
            $urlAddKelompok = "v1/masterdata/employees?search=".$search."&per_page=100&active=true";
            $addSatuan = $this->curl_request_mysdi(
                $header,
                $method_getgroup,
                $postData,
                $urlAddKelompok
            );
            if ($addSatuan['code'] == 200){
                $callback = $addSatuan['data']['data'];
            }else{
                $callback = [];
            }
            return $callback;
            //return $addSatuan['data'];
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getKaryawanbyID($data)
    {
        try { 
            $param = $data['param'];
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            //$token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "GET";
            // 2. add Data Golongan
            $postData = '';
            $header = array(
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization: Bearer 
                eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMjAyLjUxLjE5Ni44OS9hcGkvdjEvYXV0aC9sb2dpbiIsImlhdCI6MTcxMTExMzkxNywiZXhwIjoxNzM3MDMzOTE3LCJuYmYiOjE3MTExMTM5MTcsImp0aSI6IjBXWGVHSDZjNndiRG1ZMUciLCJzdWIiOiIxIiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.do7Q75tVLHefk7syslsv8bzvtd7tpYGA-2ZkhY_5ESc'
            );
            $urlAddKelompok = "v1/masterdata/employees/".$param;
            $addSatuan = $this->curl_request_mysdi(
                $header,
                $method_getgroup,
                $postData,
                $urlAddKelompok
            );
            if ($addSatuan['code'] == 200){
                $callback = $addSatuan['data'];
            }else{
                $callback = [];
            }
            return $callback;
            //return $addSatuan['data'];
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getUnitbyIP($data)
    {
        try { 
            $ip  = $_SERVER['REMOTE_ADDR'];
            
            if ($ip == '::1'){
                $ip = gethostbyname(trim(`hostname`));
            }
                
            $IPAddress = $ip; 
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);
            // 2. add Data Group Barang 
            $method_getsatuan = "GET";
            $urlAddSatuan = "masterdata/apotek/getIPUnitFarmasibyIP/".$IPAddress;
            $response = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getsatuan, [], $urlAddSatuan);

            return $response;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getNoregistrasibyNoreg($data)
        {
            try { 
                $noreg = $data['noreg'];
                $tipereg = substr($noreg, 0, 2);
                if ($tipereg == 'RJ'){
                    $endpoint = 'viewByNoregistrasi';
                }else{
                    $endpoint = 'viewByNoregistrasiRanap';
                }
                // 1. Gen Token
                $method = "POST";
                $URL = "genToken";
                $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

                // 2. add Data Group Barang 
                $method_getgroup = "POST";
                // 2. add Data Golongan
                $postData = '
                {
                    "NoRegistrasi": "'.$noreg.'"
                }
                ';
                $urlAddKelompok = "registrations/".$endpoint;
                $addSatuan = $this->curl_request(
                    GenerateTokenRS::headers_api_token($token['access_token']),
                    $method_getgroup,
                    $postData,
                    $urlAddKelompok
                );
                return $addSatuan;
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        public function viewInventoryChargedbyDatePeriode($data)
        {
            try { 
                $tglawal = $data['tglawal'];
                $tglakhir = $data['tglakhir'];
                // 1. Gen Token
                $method = "POST";
                $URL = "genToken";
                $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

                // 2. add Data Group Barang 
                $method_getgroup = "POST";
                // 2. add Data Golongan
                $postData = '
                {
                    "tglPeriodeAwal" : "'.$tglawal.'" ,
                    "tglPeriodeAkhir" : "'.$tglakhir.'" 
                }
                ';
                $urlAddKelompok = "transaction/sales/getConsumableChargedPeriode";
                $addSatuan = $this->curl_request(
                    GenerateTokenRS::headers_api_token($token['access_token']),
                    $method_getgroup,
                    $postData,
                    $urlAddKelompok
                );
                return $addSatuan['data'];
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        public function viewInventoryChargeddetail($data)
        {
            try {  
                $No_Transaksi = $data['No_Transaksi']; 
                //$OrderID = $data['OrderID'];
                // 1. Gen Token
                $method = "POST";
                $URL = "genToken";
                $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

                // 2. add Data Group Barang 
                $method_getgroup = "POST";
                // 2. add Data Golongan
                $postData = '
                {
                    "TransactionCode" : "'.$No_Transaksi.'"  
                }
                ';
                $urlAddKelompok = "transaction/sales/getSalesDetailbyID";
                $addSatuan = $this->curl_request(
                    GenerateTokenRS::headers_api_token($token['access_token']),
                    $method_getgroup,
                    $postData,
                    $urlAddKelompok
                );
                return $addSatuan['data'];
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        public function getPrintDetailv2($data)
        {
            try { 
                //$orderr = '110668';
                //NamaObat+' (Qty : '+CONVERT(varchar(15), a.Quantity)+' )' as NamaO_copy
                $this->db->query("SELECT *,NamaBarang+' NO : '+CONVERT(varchar(15), a.QryOrder)+' (QtyReal : '+CONVERT(varchar(15), a.QryRealisasi)+' )' as NamaO,'' as Instruksi,
                NamaBarang+' (Qty : '+CONVERT(varchar(15), a.QryOrder)+' )' as NamaO_copy
                FROM [Apotik_V1.1SQL].dbo.OrderResepDetail a
                INNER JOIN [Apotik_V1.1SQL].dbo.OrderResep b on a.IdOrderResep=b.ID
				--left join [Apotik_V1.1SQL].dbo.tblProductType d on a.NamaBarang=d.ProductType and a.Racik='1' and a.Header='1'
                Where b.ID=:NoOrder and a.Batal='0' 
                order by Racik asc
                ");
                $this->db->bind('NoOrder', $data['NoOrder']);
                //$this->db->bind('NoOrder', $orderr);
                $data =  $this->db->resultSet();
                $rows = array();
    
                foreach ($data as $key) {
                    $pasing['ID'] = $key['ID'];
                    $pasing['IdOrderResep'] = $key['IdOrderResep'];
                    $pasing['KodeBarang'] = $key['KodeBarang'];
                    $pasing['NamaBarang'] = $key['NamaBarang'];
                    $pasing['QryOrder'] = $key['QryOrder'];
                    $pasing['QryRealisasi'] = $key['QryRealisasi'];
                    $pasing['Signa'] = $key['Signa'];
                    $pasing['SignaTerjemahan'] = $key['SignaTerjemahan'];
                    $pasing['Keterangan'] = $key['Keterangan'];
                    $pasing['Review'] = $key['Review'];
                    $pasing['HasilReview'] = $key['HasilReview'];
                    $pasing['Batal'] = $key['Batal'];
                    $pasing['TglBatal'] = $key['TglBatal'];
                    $pasing['PetugasBatal'] = $key['PetugasBatal'];
                    $pasing['Racik'] = $key['Racik'];
                    $pasing['Header'] = $key['Header'];
                    $pasing['Keterangan1'] = $key['Keterangan1'];
                    $pasing['Keterangan2'] = $key['Keterangan2'];
                    $pasing['Dosis'] = $key['Dosis'];
                    $pasing['JenisResep'] = $key['JenisResep'];
                    $pasing['NoEpisode'] = $key['NoEpisode'];
                    $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                    $pasing['NoMR'] = $key['NoMR'];
                    $pasing['TglResep'] = $key['TglResep'];
                    $pasing['UnitOrder'] = $key['UnitOrder'];
                    $pasing['NamaUnitOrder'] = $key['NamaUnitOrder'];
                    $pasing['UserOrder'] = $key['UserOrder'];
                    $pasing['NamaUserOrder'] = $key['NamaUserOrder'];
                    $pasing['IDCppt'] = $key['IDCppt'];
                    $pasing['StatusResep'] = $key['StatusResep'];
                    $pasing['IsPaket'] = $key['IsPaket'];
                    $pasing['Iter'] = $key['Iter'];
                    $pasing['IterRealisasi'] = $key['IterRealisasi'];
                    $pasing['TglReview'] = $key['TglReview'];
                    $pasing['PetugasReview'] = $key['PetugasReview'];
                    $pasing['NamaPetugasReview'] = $key['NamaPetugasReview'];
                    $pasing['IsRacik'] = $key['IsRacik'];
                    $pasing['AlasanBatal'] = $key['AlasanBatal'];
                    $pasing['RR_Identitas'] = $key['RR_Identitas'];
                    $pasing['RR_Obat'] = $key['RR_Obat'];
                    $pasing['RR_Dosis'] = $key['RR_Dosis'];
                    $pasing['RR_Aturan'] = $key['RR_Aturan'];
                    $pasing['RR_Waktu'] = $key['RR_Waktu'];
                    $pasing['RR_Duplikasi'] = $key['RR_Duplikasi'];
                    $pasing['RR_Alergi'] = $key['RR_Alergi'];
                    $pasing['RR_Interaksi'] = $key['RR_Interaksi'];
                    $pasing['RR_BeratBadan'] = $key['RR_BeratBadan'];
                    $pasing['RR_KontraIndikasi'] = $key['RR_KontraIndikasi'];
                    $pasing['RO_Identitas'] = $key['RO_Identitas'];
                    $pasing['RO_Obat'] = $key['RO_Obat'];
                    $pasing['RO_Dosis'] = $key['RO_Dosis'];
                    $pasing['RO_Rute'] = $key['RO_Rute'];
                    $pasing['RO_Waktu'] = $key['RO_Waktu'];
                    $pasing['OrderCode'] = $key['OrderCode'];
                    $pasing['OrderFreeText'] = $key['OrderFreeText'];
                    $pasing['NamaO'] = $key['NamaO'];
                    $pasing['Instruksi'] = $key['Instruksi'];
                    $pasing['Dosis'] = $key['Dosis'];
                    $pasing['KetDosis'] = $key['KetDosis'];
                    $pasing['NamaO_copy'] = $key['NamaO_copy'];
    
                    $rows[] = $pasing;
                }
                return $rows;
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        public function gogetHargaJualFix($data)
        {
            try {  
                $kodebarang = $data['kodebarang']; 
                $NoRegistrasi = $data['NoRegistrasi']; 
                $GroupJaminan = $data['GroupJaminan']; 
                $TransasctionDate = $data['TransasctionDate'];  
                $Kelasid = $data['Kelasid'];  
                //$OrderID = $data['OrderID'];
                // 1. Gen Token
                $method = "POST";
                $URL = "genToken";
                $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

                // 2. add Data Group Barang 
                $method_getgroup = "POST";
                // 2. add Data Golongan
 

                $postData = '
                {
                    "ProductCode" : "'.$kodebarang.'",
                    "NoRegistrasi" : "'.$NoRegistrasi.'", 
                    "GroupJaminanx" : "'.$GroupJaminan.'",
                    "Kelasid" : "'.$Kelasid.'",
                    "tgl" : "'.$TransasctionDate.'"   
                }
                ';
                $urlAddKelompok = "information/inventory/hna/getHnabyKodeBarang";
                $addSatuan = $this->curl_request(
                    GenerateTokenRS::headers_api_token($token['access_token']),
                    $method_getgroup,
                    $postData,
                    $urlAddKelompok
                );
                return $addSatuan;
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        public function addConsumableChargedDetailv2($data)
        {
            try { 
    
                $TransasctionCode = $data['No_Transaksi'];
                $kode_barang = $data['kode_barang'];
                $nama_barang = $data['nama_barang'];
                $satuanbesar = $data['satuanbesar'];
                $qtypakai = $data['qtypakai'];
                $UnitTujuan = $data['UnitTujuan']; 
                $satuankecil = $data['satuankecil'];
                $nilaikonversisatuan = $data['nilaikonversisatuan'];
                $hpp_barang = $data['hpp_barang'];
                $persediaan = $data['persediaan'];
                $totalpakai = $data['totalpakai'];
                $Konversi_QtyTotal = $qtypakai*$nilaikonversisatuan;
                $datenowcreate = Utils::seCurrentDateTime();
                $session = SessionManager::getCurrentSession();
                $UserCreate = $session->username;
    
                // 1. Gen Token
                $method = "POST";
                $URL = "genToken";
                $DateVoid = Utils::seCurrentDateTime();
                $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);
    
                // 2. add Data Group Barang 
                $method_getgroup = "POST";
                // 2. add Data Golongan

                $postData = '
                {
                    "TransactionCode" : "'.$TransasctionCode.'", 
                    "ProductCode" : "'.$kode_barang.'",   
                    "ProductName" : "'.$nama_barang.'",
                    "Satuan" : "'.$satuankecil.'",
                    "Qty" : "'.$qtypakai.'",
                    "QtyResep" : "0", 
                    "Konversi_QtyTotal" : "'.$Konversi_QtyTotal.'", 
                    "Subtotal" : "'.$Konversi_QtyTotal.'",  
                    "Harga" : "'.$hpp_barang.'",
                    "Discount" : "'.$persediaan.'", 
                    "Tax" : "'.$UnitTujuan.'",  
                    "Grandtotal" : "'.$UserCreate.'",
                    "Konversi_QtyTotal" : "'.$nilaikonversisatuan.'" 
                }
                ';
                    $urlAddKelompok = "transaction/consumable/addConsumableDetailv2/";
                    $addSatuan = $this->curl_request(
                        GenerateTokenRS::headers_api_token($token['access_token']),
                        $method_getgroup,
                        $postData,
                        $urlAddKelompok
                    );
                    return $addSatuan;
                } catch (PDOException $e) {
                    die($e->getMessage());
                }
    
        }

        public function getDataPasienv2($data)
    {
        try {
            $orderid = $data['NoOrder'];
              $this->db->query("SELECT  c.NoMR,c.PatientName,a.NoRegistrasi,replace(CONVERT(VARCHAR(11), c.Date_of_birth, 111), '/','-') as DOB,f.First_Name as NamaDokter,a.Iter,
              a.IterRealisasi,d.username as 'Apoteker',JenisResep,replace(CONVERT(VARCHAR(11), tglResep, 111), '/','-') as tglResep,'Rawat Inap' JenisPasien,
               a.OrderFreeText as Text,a.HasilReview as HasilReviewResep
              ,a.ID as NoResep,vd.First_Name as DokterOrder,vd.NoSIP,km.RoomName as NamaUnit,
              case when mp.ID='2' then asu.NamaPerusahaan
              else jpk.NamaPerusahaan end as NamaJaminan,bb.BeratBadan,al.Alergi,a.TglResep as tglorder
                                                          from [Apotik_V1.1SQL].dbo.OrderResep a 
                                                          inner join RawatInapSQL.dbo.Inpatient b on a.NoRegistrasi = b.NoRegRI collate Latin1_General_CI_AS
                                                          inner join MasterdataSQL.dbo.Admision c on c.NoMR = b.NoMR
                                                          left join [Apotik_V1.1SQL].dbo.employees d on a.PetugasReview=d.ID
                                                          inner join MasterdataSQL.dbo.Doctors f on f.ID = b.drPenerima
                                                              left join MasterdataSQL.dbo.MstrPerusahaanJPK jpk on b.IDJPK=jpk.ID
                                                              left join MasterdataSQL.dbo.MstrPerusahaanAsuransi asu on b.IDAsuransi=asu.ID
                                                              left join MasterdataSQL.dbo.Doctors vd on a.UserOrder=vd.ID
                                                              left join RawatInapSQL.dbo.Inpatient_in_out km on b.RoomID_Akhir=km.ID
                                                              inner join MasterdataSQL.dbo.MstrTypePatient mp on b.TypePatient=mp.ID
                                                              left join (SELECT TOP 1 NoRegistrasi,BeratBadan FROM MedicalRecord.dbo.EMR_RWJ_TTV) bb on a.NoRegistrasi collate  Latin1_General_CS_AS=bb.NoRegistrasi collate  Latin1_General_CS_AS
                                                              left join (SELECT  NoMR
														   ,STUFF((SELECT ', ' + CAST(Alergen AS VARCHAR(90)) [text()]
															 FROM MedicalRecord.dbo.MR_RiwayatAlergi  
															 WHERE NoMR collate SQL_Latin1_General_CP1_CI_AS= t.NoMR collate SQL_Latin1_General_CP1_CI_AS
															 FOR XML PATH(''), TYPE)
															.value('.','NVARCHAR(MAX)'),1,2,' ') Alergi
													FROM  MasterdataSQL.dbo.Admision t
													GROUP BY ID,NoMR)al on a.NoMR=al.NoMR collate Latin1_General_CI_AS
                                                          where a.ID=:noreg_obatbebas and
                                                          a.Batal='0'
                                                          --RAJAL
                                                          UNION ALL
                                                           SELECT  c.NoMR,c.PatientName,a.NoRegistrasi,replace(CONVERT(VARCHAR(11), c.Date_of_birth, 111), '/','-') as DOB,f.First_Name as NamaDokter,a.Iter,
              a.IterRealisasi,d.username as 'Apoteker',JenisResep,replace(CONVERT(VARCHAR(11), tglResep, 111), '/','-') as tglResep,'Rawat Jalan' JenisPasien,
              a.OrderFreeText as Text,a.HasilReview as HasilReviewResep
              ,a.ID as NoResep,vd.First_Name as DokterOrder,vd.NoSIP,u.NamaUnit,
              case when mp.ID='2' then asu.NamaPerusahaan
              else jpk.NamaPerusahaan end as NamaJaminan,bb.BeratBadan,al.Alergi,a.TglResep as tglorder
                                                          from [Apotik_V1.1SQL].dbo.OrderResep a 
                                                          inner join PerawatanSQL.dbo.Visit b on a.NoRegistrasi = b.NoRegistrasi collate Latin1_General_CI_AS
                                                          inner join MasterdataSQL.dbo.Admision c on c.NoMR = b.NoMR
                                                          left join [Apotik_V1.1SQL].dbo.employees d on a.PetugasReview=d.ID
                                                          inner join MasterdataSQL.dbo.Doctors f on f.ID = b.Doctor_1
                                                              left join MasterdataSQL.dbo.MstrPerusahaanJPK jpk on b.Perusahaan=jpk.ID
                                                              left join MasterdataSQL.dbo.MstrPerusahaanAsuransi asu on b.Asuransi=asu.ID
                                                              left join MasterdataSQL.dbo.Doctors vd on a.UserOrder=vd.ID
                                                              left join MasterdataSQL.dbo.MstrUnitPerwatan u on b.Unit=u.ID
                                                              inner join MasterdataSQL.dbo.MstrTypePatient mp on b.PatientType=mp.ID
                                                              left join (SELECT TOP 1 NoRegistrasi,BeratBadan FROM MedicalRecord.dbo.EMR_RWJ_TTV) bb on a.NoRegistrasi collate  Latin1_General_CS_AS=bb.NoRegistrasi collate  Latin1_General_CS_AS
                                                              left join (SELECT  NoMR
														   ,STUFF((SELECT ', ' + CAST(Alergen AS VARCHAR(90)) [text()]
															 FROM MedicalRecord.dbo.MR_RiwayatAlergi  
															 WHERE NoMR collate SQL_Latin1_General_CP1_CI_AS= t.NoMR collate SQL_Latin1_General_CP1_CI_AS
															 FOR XML PATH(''), TYPE)
															.value('.','NVARCHAR(MAX)'),1,2,' ') Alergi
													FROM  MasterdataSQL.dbo.Admision t
													GROUP BY ID,NoMR)al on a.NoMR=al.NoMR collate Latin1_General_CI_AS
                                                          where a.ID=:noreg_obatbebas2 and
                                                          a.Batal='0'
               "); 
             $this->db->bind('noreg_obatbebas', $orderid); 
             $this->db->bind('noreg_obatbebas2', $orderid);
             //$this->db->bind('noreg_obatbebas3', $orderid);
             $key =  $this->db->single();
                                $pasing['NoMR'] = $key['NoMR'];
                                $pasing['PatientName'] = $key['PatientName'];
                                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                                $pasing['DOB'] = $key['DOB'];
                                $pasing['NamaDokter'] = $key['NamaDokter']; 
                                $pasing['Iter'] = $key['Iter'];  
                                $pasing['IterRealisasi'] = $key['IterRealisasi']; 
                                $pasing['Apoteker'] = $key['Apoteker'];   
                                $pasing['JenisResep'] = $key['JenisResep'];  
                                $pasing['tglResep'] = $key['tglResep'];   
                                $pasing['JenisPasien'] = $key['JenisPasien'];  
                                $pasing['Text'] = $key['Text'];    
                                $pasing['HasilReviewResep'] = $key['HasilReviewResep'];

                                $pasing['NamaUnit'] = $key['NamaUnit'];     
                                $pasing['NoResep'] = $key['NoResep'];     
                                $pasing['DokterOrder'] = $key['DokterOrder'];     
                                $pasing['NoSIP'] = $key['NoSIP'];        
                                $pasing['NamaJaminan'] = $key['NamaJaminan'];   
                                $pasing['BeratBadan'] = $key['BeratBadan'];    
                                $pasing['Alergi'] = $key['Alergi'];        
                                $pasing['tglorder'] = $key['tglorder'];        
                                 

                            $callback = array(
                                'message' => "success", // Set array nama 
                                'data' => $pasing
                            );
                            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getSalesDetailbyNoReg($data)
        {
            try { 
                $NoRegistrasi = $data['NoRegistrasi'];
                $UnitCode = $data['UnitCode'];
                $UnitSales = $data['UnitSales'];
                // $UnitCode = '39';
                // $UnitSales = '63';
                // 1. Gen Token
                $method = "POST";
                $URL = "genToken";
                $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

                // 2. add Data Group Barang 
                $method_getgroup = "POST";
                // 2. add Data Golongan
                $postData = '
                {
                    "NoRegistrasi" : "'.$NoRegistrasi.'" ,
                    "UnitCode" : "'.$UnitCode.'" ,
                    "UnitSales" : "'.$UnitSales.'" 
                }
                ';
                $urlAddKelompok = "transaction/sales/getSalesDetailbyNoReg/";
                $addSatuan = $this->curl_request(
                    GenerateTokenRS::headers_api_token($token['access_token']),
                    $method_getgroup,
                    $postData,
                    $urlAddKelompok
                );
                return $addSatuan['data'];
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
}
