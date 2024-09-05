<?php
class B_Dataeklaim_Model
{
    use EklaimWS;
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getcoderNIK()
    {
        $session = SessionManager::getCurrentSession();
        $userid = $session->username;
        $this->db->query("SELECT NIK_KTP
             FROM MasterDataSQL.dbo.Employees Where NoPIN=:userid 
             ");
        $this->db->bind('userid', $userid);
        $key =  $this->db->single();
        return $key['NIK_KTP'];
    }

    //GET DATA FROM DB
    public function getListDataReg($data){
        try {
            $kriteria = $data['txSearchData'];
            $cmbxcrimr = $data['cmbxcrimr'];
            if($cmbxcrimr =="1"){ // nama pasien
                $query = "SELECT NoRegistrasi,a.NoSEP,c.PatientName,a.NoMR,a.[Visit Date] as TglKunjungan,b.TGL_SEP,'RAWAT JALAN' as  JenisPasien,
				CASE WHEN B.ID is not null then 'YA' else 'TIDAK' END AS 'IS_BRIDGING',c.Date_of_birth as DateOfBirth
                from PerawatanSQL.dbo.Visit a
                left join PerawatanSQL.dbo.BPJS_T_SEP b on a.NoRegistrasi collate Latin1_General_CI_AS=b.NO_REGISTRASI collate Latin1_General_CI_AS and b.BATAL='0'
				inner join MasterdataSQL.dbo.Admision c on a.NoMR=c.NoMR
                WHERE PatientName like '%'+:keyword+'%' AND a.Batal='0'
                UNION ALL
                SELECT a.NoRegRI as NoRegistrasi,b.NO_SEP,c.PatientName,a.NoMR,a.StartDate as TglKunjungan,b.TGL_SEP,
				'RAWAT INAP' as  JenisPasien,CASE WHEN B.ID is not null then 'YA' else 'TIDAK' END AS 'IS_BRIDGING',c.Date_of_birth as DateOfBirth
                FROM RawatInapSQL.dbo.Inpatient a
                left join PerawatanSQL.dbo.BPJS_T_SEP b on a.NoRegRI collate Latin1_General_CI_AS=b.NO_REGISTRASI collate Latin1_General_CI_AS and b.BATAL='0'
				inner join MasterdataSQL.dbo.Admision c on a.NoMR=c.NoMR
                WHERE PatientName like '%'+:keyword2+'%'
                ORDER BY 5 DESC
                ";
                $this->db->query($query);
                $this->db->bind('keyword',   $kriteria); 
                $this->db->bind('keyword2',   $kriteria); 
            } elseif ($cmbxcrimr == "2") { // tgl lahir
                $query = "SELECT NoRegistrasi,a.NoSEP,c.PatientName,a.NoMR,a.[Visit Date] as TglKunjungan,b.TGL_SEP,'RAWAT JALAN' as  JenisPasien,
				CASE WHEN B.ID is not null then 'YA' else 'TIDAK' END AS 'IS_BRIDGING',c.Date_of_birth as DateOfBirth
                from PerawatanSQL.dbo.Visit a
                left join PerawatanSQL.dbo.BPJS_T_SEP b on a.NoRegistrasi collate Latin1_General_CI_AS=b.NO_REGISTRASI collate Latin1_General_CI_AS and b.BATAL='0'
				inner join MasterdataSQL.dbo.Admision c on a.NoMR=c.NoMR
                WHERE convert(varchar, Date_of_birth, 103) like '%' + :keyword +'%' AND a.Batal='0'
                UNION ALL
                SELECT a.NoRegRI as NoRegistrasi,a.NoSEP,c.PatientName,a.NoMR,a.StartDate as TglKunjungan,b.TGL_SEP,
				'RAWAT INAP' as  JenisPasien,CASE WHEN B.ID is not null then 'YA' else 'TIDAK' END AS 'IS_BRIDGING',c.Date_of_birth as DateOfBirth
                FROM RawatInapSQL.dbo.Inpatient a
                left join PerawatanSQL.dbo.BPJS_T_SEP b on a.NoRegRI collate Latin1_General_CI_AS=b.NO_REGISTRASI collate Latin1_General_CI_AS and b.BATAL='0'
				inner join MasterdataSQL.dbo.Admision c on a.NoMR=c.NoMR
                WHERE convert(varchar, Date_of_birth, 103) like '%' + :keyword2 +'%'
                ORDER BY 5 DESC";
                $this->db->query($query); 
                $this->db->bind('keyword',   $kriteria); 
                $this->db->bind('keyword2',   $kriteria); 
            } elseif ($cmbxcrimr == "3") { // no mr
                $query = "SELECT NoRegistrasi,a.NoSEP,c.PatientName,a.NoMR,a.[Visit Date] as TglKunjungan,b.TGL_SEP,'RAWAT JALAN' as  JenisPasien,
				CASE WHEN B.ID is not null then 'YA' else 'TIDAK' END AS 'IS_BRIDGING',c.Date_of_birth as DateOfBirth
                from PerawatanSQL.dbo.Visit a
                left join PerawatanSQL.dbo.BPJS_T_SEP b on a.NoRegistrasi collate Latin1_General_CI_AS=b.NO_REGISTRASI collate Latin1_General_CI_AS and b.BATAL='0'
				inner join MasterdataSQL.dbo.Admision c on a.NoMR=c.NoMR
                WHERE a.NoMR like '%'+:keyword+'%' AND a.Batal='0'
                UNION ALL
                SELECT a.NoRegRI as NoRegistrasi,a.NoSEP,c.PatientName,a.NoMR,a.StartDate as TglKunjungan,b.TGL_SEP,
				'RAWAT INAP' as  JenisPasien,CASE WHEN B.ID is not null then 'YA' else 'TIDAK' END AS 'IS_BRIDGING',c.Date_of_birth as DateOfBirth
                FROM RawatInapSQL.dbo.Inpatient a
                left join PerawatanSQL.dbo.BPJS_T_SEP b on a.NoRegRI collate Latin1_General_CI_AS=b.NO_REGISTRASI collate Latin1_General_CI_AS and b.BATAL='0'
				inner join MasterdataSQL.dbo.Admision c on a.NoMR=c.NoMR
                WHERE a.NoMR like '%'+:keyword2+'%'
                ORDER BY 5 DESC";
                $this->db->query($query); 
                $this->db->bind('keyword',   $kriteria); 
                $this->db->bind('keyword2',   $kriteria); 
            } elseif ($cmbxcrimr == "4") { // no SEP
                $query = "SELECT NoRegistrasi,a.NoSEP,c.PatientName,a.NoMR,a.[Visit Date] as TglKunjungan,b.TGL_SEP,'RAWAT JALAN' as  JenisPasien,
				CASE WHEN B.ID is not null then 'YA' else 'TIDAK' END AS 'IS_BRIDGING',c.Date_of_birth as DateOfBirth
                from PerawatanSQL.dbo.Visit a
                left join PerawatanSQL.dbo.BPJS_T_SEP b on a.NoRegistrasi collate Latin1_General_CI_AS=b.NO_REGISTRASI collate Latin1_General_CI_AS and b.BATAL='0'
				inner join MasterdataSQL.dbo.Admision c on a.NoMR=c.NoMR
                WHERE NoSEP like '%'+:keyword+'%' AND a.Batal='0'
                UNION ALL
                SELECT a.NoRegRI as NoRegistrasi,a.NoSEP,c.PatientName,a.NoMR,a.StartDate as TglKunjungan,b.TGL_SEP,
				'RAWAT INAP' as  JenisPasien,CASE WHEN B.ID is not null then 'YA' else 'TIDAK' END AS 'IS_BRIDGING',c.Date_of_birth as DateOfBirth
                FROM RawatInapSQL.dbo.Inpatient a
                left join PerawatanSQL.dbo.BPJS_T_SEP b on a.NoRegRI collate Latin1_General_CI_AS=b.NO_REGISTRASI collate Latin1_General_CI_AS and b.BATAL='0'
				inner join MasterdataSQL.dbo.Admision c on a.NoMR=c.NoMR
                WHERE NoSEP like '%'+:keyword2+'%'
                ORDER BY 5 DESC";
                $this->db->query($query); 
                $this->db->bind('keyword',   $kriteria); 
                $this->db->bind('keyword2',   $kriteria); 
                // $this->db->bind('keywordx',   $kriteria); 
                // $this->db->bind('keywordx2',   $kriteria); 
            } 
            // elseif ($cmbxcrimr == "5") { // alamat
            //     $query = "SELECT top 5000 
            //             *,replace(CONVERT(VARCHAR(11), Date_of_birth, 111), '/','-') as TglLahir
            //             from MasterDataSQL.dbo.Admision where    Aktif='1' and  ID_Card_number like    '%' + :Medrec_NoIdPengenal  + '%'    
            //             ORDER BY 1 DESC";
            //     $this->db->query($query); 
            //     $this->db->bind('Medrec_NoIdPengenal',   $kriteria); 
            // }

            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['NO_SEP'] = $key['NoSEP'];
                $pasing['NAMA_PESERTA'] = $key['PatientName'];
                $pasing['NO_REGISTRASI'] = $key['NoRegistrasi'];
                $pasing['NO_MR'] = $key['NoMR'];
                $pasing['TGL_SEP'] = is_null($key['TGL_SEP']) ? null : date('d/m/Y', strtotime($key['TGL_SEP']));
                $pasing['TglKunjungan'] = date('d/m/Y', strtotime($key['TglKunjungan']));
                $pasing['DateOfBirth'] = date('d/m/Y', strtotime($key['DateOfBirth']));
                $pasing['JenisPasien'] = $key['JenisPasien'];
                $pasing['IS_BRIDGING'] = $key['IS_BRIDGING'];
                $rows[] = $pasing;
            }
        return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    public function getListDatabyNoSEP($data)
    {
        try {
            $keyword = $data['keyword'];
            // $this->db->query("SELECT NO_SEP,NAMA_PESERTA,NO_REGISTRASI,NO_MR,TGL_SEP,NO_KARTU FROM PerawatanSQL.dbo.BPJS_T_SEP WHERE NO_SEP=:keyword"); 

            $this->db->query("SELECT NoRegistrasi,b.NO_SEP,b.NAMA_PESERTA,a.NoMR,a.TglKunjungan,b.TGL_SEP,'RAWAT JALAN' as  JenisPasien,CASE WHEN B.ID is not null then 'BRIDGING' else 'TIDAK BRIDGING' END AS 'IS_BRIDGING',CASE WHEN C.ID IS NOT NULL THEN 'EDIT' ELSE 'NEW' END AS IS_NEWCLAIM
            from PerawatanSQL.dbo.Visit a
            left join PerawatanSQL.dbo.BPJS_T_SEP b on a.NoRegistrasi=b.NO_REGISTRASI
            left join DashboardData.dbo.EKLAIM c on a.NoRegistrasi collate Latin1_General_CI_AS=c.NO_REGISTRASI collate Latin1_General_CI_AS and c.BATAL='0'
            WHERE NoMR=:keyword AND a.Batal='0'
            UNION ALL
            SELECT a.NoRegRI as NoRegistrasi,b.NO_SEP,b.NAMA_PESERTA,a.NoMR,a.StartDate as TglKunjungan,b.TGL_SEP,'RAWAT INAP' as  JenisPasien,CASE WHEN B.ID is not null then 'BRIDGING' else 'TIDAK BRIDGING' END AS 'IS_BRIDGING' ,CASE WHEN C.ID IS NOT NULL THEN 'EDIT' ELSE 'NEW' END AS IS_NEWCLAIM
            FROM RawatInapSQL.dbo.Inpatient a
            left join PerawatanSQL.dbo.BPJS_T_SEP b on a.NoRegRI=b.NO_REGISTRASI
            left join DashboardData.dbo.EKLAIM c on a.NoRegRI collate Latin1_General_CI_AS=c.NO_REGISTRASI collate Latin1_General_CI_AS and c.BATAL='0'
            WHERE NoMR=:keyword2
            ORDER BY 5 DESC
            ");
            $this->db->bind('keyword', $keyword);
            $this->db->bind('keyword2', $keyword);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['NO_SEP'] = $key['NO_SEP'];
                $pasing['NAMA_PESERTA'] = $key['NAMA_PESERTA'];
                $pasing['NO_REGISTRASI'] = $key['NoRegistrasi'];
                $pasing['NO_MR'] = $key['NoMR'];
                $pasing['TGL_SEP'] = date('d/m/Y', strtotime($key['TGL_SEP']));
                $pasing['TglKunjungan'] = date('d/m/Y', strtotime($key['TglKunjungan']));
                $pasing['JenisPasien'] = $key['JenisPasien'];
                $pasing['IS_BRIDGING'] = $key['IS_BRIDGING'];
                $pasing['IS_NEWCLAIM'] = $key['IS_NEWCLAIM'];
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

//     public function goGetDatabyNoSEP($data)
//     {
//         try {
//             $id = $data['id'];
//             $getreg = substr($id, 0, 2);
//             ////ver1----
//             // $this->db->query("SELECT b.NO_SEP,b.NAMA_PESERTA,b.NO_REGISTRASI,b.NO_MR,b.TGL_SEP,b.NO_KARTU,'-' as  KODE_KELAS_RAWAT,replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-') as StartDate,replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-') as EndDate,'1' as LOS,'00:00' as JAM_LOS , DATEDIFF(yy, b.TGL_LAHIR, GETDATE()) as UMUR,BeratLahir,NAMA_DOKTER
//             // FROM PerawatanSQL.dbo.Visit a
//             //                 INNER JOIN PerawatanSQL.dbo.BPJS_T_SEP b on a.NoRegistrasi=b.NO_REGISTRASI
//             //                 INNER JOIN MasterDataSQL.dbo.Admision c on a.NoMR=c.NoMR
//             // WHERE NO_SEP=:nosep
//             //  "); 

//             ////ver2------
//             //  $this->db->query("SELECT b.NO_SEP,b.NAMA_PESERTA,b.NO_REGISTRASI,b.NO_MR,b.TGL_SEP,b.NO_KARTU,'-' as  KODE_KELAS_RAWAT,replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-') as StartDate,replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-') as EndDate,'1' as LOS,'00:00' as JAM_LOS , DATEDIFF(yy, b.TGL_LAHIR, GETDATE()) as UMUR,BeratLahir,NAMA_DOKTER
//             //  FROM PerawatanSQL.dbo.BPJS_T_SEP
//             //  WHERE NO_SEP=:nosep
//             //   "); 

//             ////ver3--------
//             // $this->db->query("SELECT a.NO_SEP,NAMA_PESERTA,replace(CONVERT(VARCHAR(11), a.TGL_LAHIR, 111), '/','-') as DOB,
//             // CASE WHEN JENIS_KELAMIN='LAKI-LAKI' THEN '1'
//             //  ELSE '2' END AS GENDER
//             // ,a.NO_REGISTRASI,a.NO_MR,TGL_SEP,a.NO_KARTU,
//             // KODE_KELAS_RAWAT,replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-') as StartDate,
//             // replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-') as EndDate,
//             // CONVERT(VARCHAR(8),TglKunjungan,108) as jamkunjungan,
//             // '1' as LOS,'00:00' as JAM_LOS ,
//             // DATEDIFF(yy, a.TGL_LAHIR, GETDATE()) as UMUR,'-' BeratLahir,a.NAMA_DOKTER,c.ID as ID_EKLAIM,a.KODE_JENIS_RAWAT,a.IS_EKSEKUTIF,a.IS_COB,a.NAIK_KELAS,isnull(lab.TotalTarif,0) as TotalLab, isnull(rad.TotalTarif,0) as TotalRad,CAST(isnull(aptk.TotalTarif,0) AS int) as TotalAptk,isnull(op.TotalTarif,0) as TotalOP,isnull(km.TotalTarif,0) as TotalKamar
//             //  FROM PerawatanSQL.dbo.BPJS_T_SEP a
//             //  inner join PerawatanSQL.dbo.Visit b on a.NO_REGISTRASI=b.NoRegistrasi
//             //  left join DashboardData.dbo.EKLAIM c on a.NO_SEP collate Latin1_General_CI_AS=c.NO_SEP collate Latin1_General_CI_AS and c.BATAL='0'
//             // 	 outer apply (SELECT sum(Tarif) as TotalTarif,NoRegRI FROM LaboratoriumSQL.dbo.View_Labdetails WHERE NoRegRI=b.NoRegistrasi group by NoRegRI) lab
//             //      outer apply (SELECT sum(Service_Charge) as TotalTarif,NOREGISTRASI FROM RadiologiSQL.dbo.WO_RADIOLOGY WHERE NOREGISTRASI=b.NoRegistrasi and Batal='0' group by NOREGISTRASI) rad
//             //      outer apply (SELECT sum([Unit Price]*QtyRealisasi*(1-x.Discount)) as TotalTarif,xx.NoRegistrasi FROM [Apotik_V1.1SQL].dbo.[Order Details] x
//             //      INNER JOIN [Apotik_V1.1SQL].dbo.Orders xx on x.[Order ID]=xx.[Order ID]
//             //                                    WHERE NoRegistrasi=b.NoRegistrasi AND
//             // 								   [Product ID] is not null AND xx.[Status ID] >= 1 AND OrderBatal=0 and QtyRealisasi <>0 group by NoRegistrasi) aptk
//             // 	 outer apply (SELECT sum(Tarif) as TotalTarif,NoRegistrasi FROM RawatInapSQL.dbo.tblTindakanRIDetail WHERE NoRegistrasi=b.NoRegistrasi and NamaKelas is not null group by NoRegistrasi) op
//             // 	 outer apply (SELECT sum(jumlah) as TotalTarif,NoRegRI FROM RawatInapSQL.dbo.View_LamaRawat Where NoRegRI=b.NoRegistrasi group by NoRegRI) km
//             //  WHERE a.NO_REGISTRASI=:id
//             //  union all
//             // --  SELECT a.NO_SEP,NAMA_PESERTA,replace(CONVERT(VARCHAR(11), a.TGL_LAHIR, 111), '/','-') as DOB,
//             // --  CASE WHEN JENIS_KELAMIN='LAKI-LAKI' THEN '1'
//             // --  ELSE '2' END AS GENDER
//             // --  ,NO_REGISTRASI,a.NO_MR,TGL_SEP,a.NO_KARTU,
//             // -- KODE_KELAS_RAWAT, StartDate,
//             // --  EndDate,'1' as LOS,'00:00' as JAM_LOS ,
//             // -- DATEDIFF(yy, a.TGL_LAHIR, GETDATE()) as UMUR,'-' BeratLahir,a.NAMA_DOKTER,c.ID as ID_EKLAIM,a.KODE_JENIS_RAWAT,a.IS_EKSEKUTIF,a.IS_COB,a.NAIK_KELAS
//             // --  FROM PerawatanSQL.dbo.BPJS_T_SEP a
//             // --  inner join RawatInapSQL.dbo.Inpatient b on a.NO_REGISTRASI=b.NoRegRI
//             // --  left join DashboardData.dbo.EKLAIM c on a.NO_SEP collate Latin1_General_CI_AS=c.NO_SEP collate Latin1_General_CI_AS and c.BATAL='0'
//             // --  WHERE a.NO_SEP=:nosep2
//             // SELECT a.NO_SEP,NAMA_PESERTA,replace(CONVERT(VARCHAR(11), a.TGL_LAHIR, 111), '/','-') as DOB,
//             //  CASE WHEN JENIS_KELAMIN='LAKI-LAKI' THEN '1'
//             //  ELSE '2' END AS GENDER
//             //  ,a.NO_REGISTRASI,a.NO_MR,TGL_SEP,a.NO_KARTU,
//             // KODE_KELAS_RAWAT, replace(CONVERT(VARCHAR(11), StartDate, 111), '/','-') as StartDate, replace(CONVERT(VARCHAR(11), EndDate, 111), '/','-') as EndDate,
//             // CONVERT(VARCHAR(8),StartTime,108) as jamkunjungan,
//             //  DATEDIFF(dd, b.StartDate, b.EndDate)+1 as LOS,'00:00' as JAM_LOS ,
//             // DATEDIFF(yy, a.TGL_LAHIR, GETDATE()) as UMUR,'-' BeratLahir,a.NAMA_DOKTER,c.ID as ID_EKLAIM,a.KODE_JENIS_RAWAT,a.IS_EKSEKUTIF,a.IS_COB,a.NAIK_KELAS,
//             // isnull(lab.TotalTarif,0)+isnull(lab_rj.TotalTarif,0) as TotalLab, isnull(rad.TotalTarif,0)+isnull(rad_rj.TotalTarif,0) as TotalRad,
//             // CAST(isnull(aptk.TotalTarif,0)+isnull(aptk_rj.TotalTarif,0) AS int) as TotalAptk,isnull(op.TotalTarif,0) as TotalOP,isnull(km.TotalTarif,0) as TotalKamar
//             //  FROM PerawatanSQL.dbo.BPJS_T_SEP a
//             //  inner join RawatInapSQL.dbo.Inpatient b on a.NO_REGISTRASI=b.NoRegRI
//             //  left join DashboardData.dbo.EKLAIM c on a.NO_SEP collate Latin1_General_CI_AS=c.NO_SEP collate Latin1_General_CI_AS and c.BATAL='0'
//             //  --left join (select NoRegRI,sum(LamaRawat) as LOS from RawatInapSQL.dbo.View_LamaRawat group by NoRegRI ) d on b.NoRegRI=d.NoRegRI
//             // --  outer apply (select NoRegRI,sum(LamaRawat) as LOS from RawatInapSQL.dbo.View_LamaRawat where NoRegRI=b.NoRegRI group by NoRegRI )d
//             // outer apply (SELECT sum(Tarif) as TotalTarif,NoRegRI FROM LaboratoriumSQL.dbo.View_Labdetails WHERE NoRegRI=b.NoRegRI group by NoRegRI) lab
//             // 	 outer apply (SELECT sum(Service_Charge) as TotalTarif,NOREGISTRASI FROM RadiologiSQL.dbo.WO_RADIOLOGY WHERE NOREGISTRASI=b.NoRegRI and Batal='0' group by NOREGISTRASI) rad
//             //      outer apply (SELECT sum([Unit Price]*QtyRealisasi*(1-x.Discount)) as TotalTarif,xx.NoRegistrasi FROM [Apotik_V1.1SQL].dbo.[Order Details] x
//             // 	 INNER JOIN [Apotik_V1.1SQL].dbo.Orders xx on x.[Order ID]=xx.[Order ID]
//             //                                    WHERE NoRegistrasi=b.NoRegRI AND
//             // 								   [Product ID] is not null AND xx.[Status ID] >= 1 AND OrderBatal=0 and QtyRealisasi <>0 group by NoRegistrasi) aptk
//             // 	 outer apply (SELECT sum(Tarif) as TotalTarif,NoRegistrasi FROM RawatInapSQL.dbo.tblTindakanRIDetail WHERE NoRegistrasi=b.NoRegRI and NamaKelas is not null group by NoRegistrasi) op
//             // 	 outer apply (SELECT sum(jumlah) as TotalTarif,NoRegRI FROM RawatInapSQL.dbo.View_LamaRawat Where NoRegRI=b.NoRegRI group by NoRegRI) km
//             //      outer apply (SELECT sum(Tarif) as TotalTarif,NoRegRI FROM LaboratoriumSQL.dbo.View_Labdetails WHERE NoRegRI=b.NoRegisRwj group by NoRegRI) lab_rj
//             // outer apply (SELECT sum(Service_Charge) as TotalTarif,NOREGISTRASI 
//             // 	 FROM RadiologiSQL.dbo.WO_RADIOLOGY WHERE NOREGISTRASI=b.NoRegisRwj and Batal='0' group by NOREGISTRASI) rad_rj
//             //  outer apply (SELECT sum([Unit Price]*QtyRealisasi*(1-x.Discount)) as TotalTarif,xx.NoRegistrasi FROM [Apotik_V1.1SQL].dbo.[Order Details] x
//             // 	 INNER JOIN [Apotik_V1.1SQL].dbo.Orders xx on x.[Order ID]=xx.[Order ID]
//             //                                    WHERE NoRegistrasi=b.NoRegisRwj AND
//             // 								   [Product ID] is not null AND xx.[Status ID] >= 1 AND OrderBatal=0 and QtyRealisasi <>0 group by NoRegistrasi) aptk_rj
//             //  WHERE a.NO_REGISTRASI=:id2
//             //  ");

//             //ver 4-------
//             // if ($getreg == 'RJ'){
//             //     $query = "SELECT a.NO_SEP,NAMA_PESERTA,replace(CONVERT(VARCHAR(11), a.TGL_LAHIR, 111), '/','-') as DOB,
//             //     CASE WHEN JENIS_KELAMIN='LAKI-LAKI' THEN '1'
//             //      ELSE '2' END AS GENDER
//             //     ,a.NO_REGISTRASI,a.NO_MR,TGL_SEP,a.NO_KARTU,
//             //     KODE_KELAS_RAWAT,replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-') as StartDate,
//             //     replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-') as EndDate,
//             //     CONVERT(VARCHAR(8),TglKunjungan,108) as jamkunjungan,
//             //     '1' as LOS,'00:00' as JAM_LOS ,
//             //     DATEDIFF(yy, a.TGL_LAHIR, GETDATE()) as UMUR,'-' BeratLahir,a.NAMA_DOKTER,c.ID as ID_EKLAIM,a.KODE_JENIS_RAWAT,a.IS_EKSEKUTIF,a.IS_COB,a.NAIK_KELAS,isnull(lab.TotalTarif,0) as TotalLab, isnull(rad.TotalTarif,0) as TotalRad,CAST(isnull(aptk.TotalTarif,0) AS int) as TotalAptk
//             //     ,isnull(op.TotalTarif,0) as TotalOP,isnull(km.TotalTarif,0) as TotalKamar
//             //     ,CAST(isnull(kons.TotalTarif,0) as INT )  as TotalKonsul
//             //     ,CAST(isnull(tind.TotalTarif,0) as INT )  as TotalTindakan
//             //      FROM PerawatanSQL.dbo.BPJS_T_SEP a
//             //      inner join PerawatanSQL.dbo.Visit b on a.NO_REGISTRASI=b.NoRegistrasi
//             //      left join DashboardData.dbo.EKLAIM c on a.NO_REGISTRASI collate Latin1_General_CI_AS=c.NO_REGISTRASI collate Latin1_General_CI_AS and c.BATAL='0'
//             //          outer apply (SELECT sum(Tarif) as TotalTarif,NoRegRI FROM LaboratoriumSQL.dbo.View_Labdetails WHERE NoRegRI=b.NoRegistrasi group by NoRegRI) lab
//             //          outer apply (SELECT sum(Service_Charge) as TotalTarif,NOREGISTRASI FROM RadiologiSQL.dbo.WO_RADIOLOGY WHERE NOREGISTRASI=b.NoRegistrasi and Batal='0' group by NOREGISTRASI) rad
//             //          outer apply (SELECT sum([Unit Price]*QtyRealisasi*(1-x.Discount)) as TotalTarif,xx.NoRegistrasi FROM [Apotik_V1.1SQL].dbo.[Order Details] x
//             //          INNER JOIN [Apotik_V1.1SQL].dbo.Orders xx on x.[Order ID]=xx.[Order ID]
//             //                                        WHERE NoRegistrasi=b.NoRegistrasi AND
//             //                                        [Product ID] is not null AND xx.[Status ID] >= 1 AND OrderBatal=0 and QtyRealisasi <>0 group by NoRegistrasi) aptk
//             //          outer apply (SELECT sum(Tarif) as TotalTarif,NoRegistrasi FROM RawatInapSQL.dbo.tblTindakanRIDetail WHERE NoRegistrasi=b.NoRegistrasi and NamaKelas is not null group by NoRegistrasi) op
//             //          outer apply (SELECT sum(jumlah) as TotalTarif,NoRegRI FROM RawatInapSQL.dbo.View_LamaRawat Where NoRegRI=b.NoRegistrasi group by NoRegRI) km
//             // outer apply (SELECT sum(z.Quantity*z.Tarif*(1-z.Discount)) as TotalTarif,NoRegistrasi FROM PerawatanSQL.dbo.[Visit Details] z
//             // inner join PerawatanSQL.dbo.Tarif_RJ_UGD zz on z.ProductID=zz.ID
//             // where NoRegistrasi=b.NoRegistrasi and zz.CategoryProduct='Konsultasi'
//             // group by NoRegistrasi) kons
//             // outer apply (SELECT sum(z.Quantity*z.Tarif*(1-z.Discount)) as TotalTarif,NoRegistrasi FROM PerawatanSQL.dbo.[Visit Details] z
//             // inner join PerawatanSQL.dbo.Tarif_RJ_UGD zz on z.ProductID=zz.ID
//             // where NoRegistrasi=b.NoRegistrasi and zz.CategoryProduct<>'Konsultasi'
//             // group by NoRegistrasi) tind
//             //      WHERE a.NO_REGISTRASI=:id";
//             // }else{
//             //         $query = "SELECT a.NO_SEP,NAMA_PESERTA,replace(CONVERT(VARCHAR(11), a.TGL_LAHIR, 111), '/','-') as DOB,
//             //         CASE WHEN JENIS_KELAMIN='LAKI-LAKI' THEN '1'
//             //         ELSE '2' END AS GENDER
//             //         ,a.NO_REGISTRASI,a.NO_MR,TGL_SEP,a.NO_KARTU,
//             //        KODE_KELAS_RAWAT, replace(CONVERT(VARCHAR(11), StartDate, 111), '/','-') as StartDate, replace(CONVERT(VARCHAR(11), EndDate, 111), '/','-') as EndDate,
//             //        CONVERT(VARCHAR(8),StartTime,108) as jamkunjungan,
//             //         DATEDIFF(dd, b.StartDate, b.EndDate)+1 as LOS,'00:00' as JAM_LOS ,
//             //        DATEDIFF(yy, a.TGL_LAHIR, GETDATE()) as UMUR,'-' BeratLahir,a.NAMA_DOKTER,c.ID as ID_EKLAIM,a.KODE_JENIS_RAWAT,a.IS_EKSEKUTIF,a.IS_COB,a.NAIK_KELAS,
//             //        isnull(lab.TotalTarif,0)+isnull(lab_rj.TotalTarif,0) as TotalLab, isnull(rad.TotalTarif,0)+isnull(rad_rj.TotalTarif,0) as TotalRad,
//             //        CAST(isnull(aptk.TotalTarif,0)+isnull(aptk_rj.TotalTarif,0) AS int) as TotalAptk
//             //        ,isnull(op.TotalTarif,0) as TotalOP,isnull(km.TotalTarif,0) as TotalKamar
//             //        ,CAST(isnull(kons.TotalTarif,0)+isnull(kons_rj.TotalTarif,0) as INT )  as TotalKonsul
//             //        ,CAST(isnull(tind.TotalTarif,0)+isnull(tind_rj.TotalTarif,0) as INT )  as TotalTindakan
//             //         FROM PerawatanSQL.dbo.BPJS_T_SEP a
//             //         inner join RawatInapSQL.dbo.Inpatient b on a.NO_REGISTRASI=b.NoRegRI
//             //         left join DashboardData.dbo.EKLAIM c on a.NO_SEP collate Latin1_General_CI_AS=c.NO_SEP collate Latin1_General_CI_AS and c.BATAL='0'
//             //        outer apply (SELECT sum(Tarif) as TotalTarif,NoRegRI FROM LaboratoriumSQL.dbo.View_Labdetails WHERE NoRegRI=b.NoRegRI group by NoRegRI) lab
//             //             outer apply (SELECT sum(Service_Charge) as TotalTarif,NOREGISTRASI 
//             //             FROM RadiologiSQL.dbo.WO_RADIOLOGY WHERE NOREGISTRASI=b.NoRegRI and Batal='0' group by NOREGISTRASI) rad
//             //             outer apply (SELECT sum([Unit Price]*QtyRealisasi*(1-x.Discount)) as TotalTarif,xx.NoRegistrasi FROM [Apotik_V1.1SQL].dbo.[Order Details] x
//             //             INNER JOIN [Apotik_V1.1SQL].dbo.Orders xx on x.[Order ID]=xx.[Order ID]
//             //                                           WHERE NoRegistrasi=b.NoRegRI AND
//             //                                           [Product ID] is not null AND xx.[Status ID] >= 1 AND OrderBatal=0 and QtyRealisasi <>0 group by NoRegistrasi) aptk
//             //             outer apply (SELECT sum(Tarif) as TotalTarif,NoRegistrasi FROM RawatInapSQL.dbo.tblTindakanRIDetail WHERE NoRegistrasi=b.NoRegRI and NamaKelas is not null group by NoRegistrasi) op
//             //             outer apply (SELECT sum(jumlah) as TotalTarif,NoRegRI FROM RawatInapSQL.dbo.View_LamaRawat Where NoRegRI=b.NoRegRI group by NoRegRI) km

//             //        outer apply (SELECT sum(Tarif) as TotalTarif,NoRegRI FROM LaboratoriumSQL.dbo.View_Labdetails WHERE NoRegRI=b.NoRegisRwj group by NoRegRI) lab_rj
//             //        outer apply (SELECT sum(Service_Charge) as TotalTarif,NOREGISTRASI 
//             //             FROM RadiologiSQL.dbo.WO_RADIOLOGY WHERE NOREGISTRASI=b.NoRegisRwj and Batal='0' group by NOREGISTRASI) rad_rj
//             //         outer apply (SELECT sum([Unit Price]*QtyRealisasi*(1-x.Discount)) as TotalTarif,xx.NoRegistrasi FROM [Apotik_V1.1SQL].dbo.[Order Details] x
//             //             INNER JOIN [Apotik_V1.1SQL].dbo.Orders xx on x.[Order ID]=xx.[Order ID]
//             //                                           WHERE NoRegistrasi=b.NoRegisRwj AND
//             //                                           [Product ID] is not null AND xx.[Status ID] >= 1 AND OrderBatal=0 and QtyRealisasi <>0 group by NoRegistrasi) aptk_rj

//             // outer apply (SELECT sum(z.Quantity*[Unit Price]*(1-Discount)) as TotalTarif,NoRegRI FROM RawatInapSQL.dbo.[Inpatient Details] z
//             // inner join RawatInapSQL.dbo.Tarif_RI zz on z.[Product ID]=zz.ID
//             // where NoRegRI=b.NoRegRI and zz.CategoryProduct='Visite'
//             // group by NoRegRI) kons
//             // outer apply (SELECT sum(z.Quantity*z.Tarif*(1-Discount)) as TotalTarif,NoRegistrasi FROM PerawatanSQL.dbo.[Visit Details] z
//             // inner join PerawatanSQL.dbo.Tarif_RJ_UGD zz on z.ProductID=zz.ID
//             // where NoRegistrasi=b.NoRegisRwj and zz.CategoryProduct='Konsultasi'
//             // group by NoRegistrasi) kons_rj
//             // outer apply (SELECT sum(z.Quantity*[Unit Price]*(1-Discount)) as TotalTarif,NoRegRI FROM RawatInapSQL.dbo.[Inpatient Details] z
//             // inner join RawatInapSQL.dbo.Tarif_RI zz on z.[Product ID]=zz.ID
//             // where NoRegRI=b.NoRegRI and zz.CategoryProduct<>'Visite'
//             // group by NoRegRI) tind
//             // outer apply (SELECT sum(z.Quantity*z.Tarif*(1-Discount)) as TotalTarif,NoRegistrasi FROM PerawatanSQL.dbo.[Visit Details] z
//             // inner join PerawatanSQL.dbo.Tarif_RJ_UGD zz on z.ProductID=zz.ID
//             // where NoRegistrasi=b.NoRegisRwj and zz.CategoryProduct<>'Konsultasi'
//             // group by NoRegistrasi) tind_rj
//             //         WHERE a.NO_REGISTRASI=:id";
//             // }

//             // $this->db->query("EXEC DashboardData.dbo.GetDateVentilator @NoReg=:id");
//             // $this->db->bind('id', $id); 
//             // $this->db->execute();

//             // $this->db->query("SELECT DashboardData.dbo.GetDateVentilator");
//             // $datas =  $this->db->single();
//             // $pasing['SD'] = $datas['SD'];
//             // $pasing['ED'] = $datas['ED'];
//             // var_dump($pasing);exit;

//             //---versi 5
//             if ($getreg == 'RJ') {
//                 $query = "SELECT 
//                 CASE WHEN d.ID IS NOT NULL THEN d.NO_SEP
//                 ELSE c.NoSEP END AS NO_SEP
//                 ,NAMA_PESERTA,replace(CONVERT(VARCHAR(11), d.TGL_LAHIR, 111), '/','-') as DOB,
//                                     CASE WHEN JENIS_KELAMIN='LAKI-LAKI' THEN '1'
//                                     ELSE '2' END AS GENDER
//                                     ,d.NO_REGISTRASI,d.NO_MR,TGL_SEP,d.NO_KARTU,
//                                     KODE_KELAS_RAWAT, replace(CONVERT(VARCHAR(11), c.[Visit Date], 111), '/','-') as StartDate, replace(CONVERT(VARCHAR(11), c.[Visit Date], 111), '/','-') as EndDate,
//                                    CONVERT(VARCHAR(8),c.[Visit Date],108) as jamkunjungan,
//                                     DATEDIFF(dd, c.[Visit Date], c.[Visit Date])+1 as LOS,'00:00' as JAM_LOS ,
//                                    DATEDIFF(yy, d.TGL_LAHIR, GETDATE()) as UMUR,'-' BeratLahir,d.NAMA_DOKTER,
//                                    CASE WHEN d.ID IS NOT NULL THEN d.KODE_JENIS_RAWAT 
//                                     ELSE '2' END AS KODE_JENIS_RAWAT
//                                    ,d.IS_EKSEKUTIF,d.IS_COB,d.NAIK_KELAS,
//                                    CAST(isnull(c.TotalLab,0) as INT) as TotalLab, 
//                                    CAST(isnull(c.[Total Radiologi],0) as INT) as TotalRad,
//                                   CAST(isnull(c.TotalObat,0) as INT) as TotalAptk
//                                    ,0 as TotalKamar
//                                    ,CAST(isnull(c.TotalVisit,0) as INT)  as TotalKonsul
//                                    ,0 as  TotalOP
//                                    ,0  as TotalTindakan
//                                    ,v.PatientName,v.NoMR,case when v.Gander='L' then '1' else '2' end as JenisKelamin,replace(CONVERT(VARCHAR(11), v.Date_of_birth, 111), '/','-') as DOB_ext,DATEDIFF(yy, Date_of_birth, GETDATE()) as UMUR_ext,c.NamaDokter as NamaDokter_ext,
//                                    CASE WHEN c.PatientType='2' THEN n.NamaPerusahaan ELSE m.NamaPerusahaan END AS NamaPenjamin,null as is_intensif,null as VentiUsed,CAST(isnull(kons.TotalTarif,0) as INT)  as TarifKonsultasi, CAST(isnull(tind.TotalTarif,0) as INT) as TarifTindakan,CAST(isnull(pel_darah.TotalTarif,0) as INT) as TarifPelayananDarah,CAST(isnull(fisio.TotalTarif,0) as INT) as TarifFisio

//                 FROM PerawatanSQL.dbo.View_VisitExtnded c 
//                 left join PerawatanSQL.dbo.BPJS_T_SEP d on c.NoRegistrasi=d.NO_REGISTRASI and BATAL='0'
//                 inner join MasterDataSQL.dbo.Admision v on c.NoMR=v.NoMR
//             left join MasterDataSQL.dbo.MstrPerusahaanJPK m on c.Perusahaan_ID=m.ID
//             left join MasterDataSQL.dbo.MstrPerusahaanAsuransi n on c.Asuransi_ID=n.ID
//              outer apply (SELECT sum(z.Quantity*z.Tarif*(1-Discount)) as TotalTarif,NoRegistrasi FROM PerawatanSQL.dbo.[Visit Details] z
//              inner join PerawatanSQL.dbo.Tarif_RJ_UGD zz on z.ProductID=zz.ID
// 			 where NoRegistrasi=c.NoRegistrasi and zz.CategoryProduct='Konsultasi'
// 			 group by NoRegistrasi) kons
// 			 outer apply (SELECT sum(z.Quantity*z.Tarif*(1-z.Discount)) as TotalTarif,NoRegistrasi FROM PerawatanSQL.dbo.[Visit Details] z
// 			 inner join PerawatanSQL.dbo.Tarif_RJ_UGD zz on z.ProductID=zz.ID
// 			 where NoRegistrasi=c.NoRegistrasi and zz.CategoryProduct not in ('Konsultasi','Tindakan Fisioteraphy') and z.NamaProduct not like '%hemodialisa%' 
// 			 group by NoRegistrasi) tind
//              outer apply (SELECT sum(z.Quantity*z.Tarif*(1-z.Discount)) as TotalTarif,NoRegistrasi FROM PerawatanSQL.dbo.[Visit Details] z
// 			 inner join PerawatanSQL.dbo.Tarif_RJ_UGD zz on z.ProductID=zz.ID
// 			 where NoRegistrasi=c.NoRegistrasi and zz.CategoryProduct<>'Konsultasi' and z.NamaProduct  like '%hemodialisa%'
// 			 group by NoRegistrasi) pel_darah
//              outer apply (SELECT sum(z.Quantity*z.Tarif*(1-z.Discount)) as TotalTarif,NoRegistrasi FROM PerawatanSQL.dbo.[Visit Details] z
// 			 inner join PerawatanSQL.dbo.Tarif_RJ_UGD zz on z.ProductID=zz.ID
// 			 where NoRegistrasi=c.NoRegistrasi and zz.CategoryProduct ='Tindakan Fisioteraphy'
// 			 group by NoRegistrasi) fisio
// -- left join DashboardData.dbo.EKLAIM e on c.NoRegistrasi collate Latin1_General_CI_AS=e.NO_REGISTRASI collate Latin1_General_CI_AS and e.BATAL='0' 
//                 where c.NoRegistrasi=:id";
//             }else{
//                     $query = "SELECT 
//                     CASE WHEN d.ID IS NOT NULL THEN d.NO_SEP
//                 ELSE a.NoSEP END AS NO_SEP
//                 ,NAMA_PESERTA,replace(CONVERT(VARCHAR(11), d.TGL_LAHIR, 111), '/','-') as DOB,
//                                         CASE WHEN JENIS_KELAMIN='LAKI-LAKI' THEN '1'
//                                         ELSE '2' END AS GENDER
//                                         ,d.NO_REGISTRASI,d.NO_MR,TGL_SEP,d.NO_KARTU,
//                                        KODE_KELAS_RAWAT, replace(CONVERT(VARCHAR(11), StartDate, 111), '/','-') as StartDate, replace(CONVERT(VARCHAR(11), EndDate, 111), '/','-') as EndDate,
//                                        CONVERT(VARCHAR(8),StartTime,108) as jamkunjungan,
//                                         DATEDIFF(dd, a.StartDate, a.EndDate)+1 as LOS,'00:00' as JAM_LOS ,
//                                        DATEDIFF(yy, d.TGL_LAHIR, GETDATE()) as UMUR,'-' BeratLahir,d.NAMA_DOKTER,
//                                        CASE WHEN d.ID IS NOT NULL THEN d.KODE_JENIS_RAWAT 
//                                     ELSE '1' END AS KODE_JENIS_RAWAT
//                                        ,d.IS_EKSEKUTIF,d.IS_COB,d.NAIK_KELAS,
//                                        CAST(isnull(b.TotalLab,0)+isnull(c.TotalLab,0) as INT) as TotalLab, 
//                                        isnull(b.TotalRadiologi,0)+isnull(c.[Total Radiologi],0) as TotalRad,
//                                        CAST(isnull(b.TotalResep,0)+isnull(c.TotalObat,0) as INT) as TotalAptk
//                                        , CAST(isnull(b.biayaKamar,0)+isnull(b.BiayaAdmin,0)+isnull(a.materai,0) as INT) as TotalKamar
//                                        , CAST(isnull(b.TotalVisit,0)+isnull(c.TotalVisit,0) as INT)  as TotalKonsul
//                                        , CAST(isnull(b.TotalTindakan,0) as INT) as TotalOP
//                                        ,0  as TotalTindakan
//                                        ,v.PatientName,v.NoMR,case when v.Gander='L' then '1' else '2' end as JenisKelamin,replace(CONVERT(VARCHAR(11), v.Date_of_birth, 111), '/','-') as DOB_ext,DATEDIFF(yy, Date_of_birth, GETDATE()) as UMUR_ext,dd.First_Name as NamaDokter_ext,
//                                        CASE WHEN a.TypePatient='2' THEN n.NamaPerusahaan ELSE m.NamaPerusahaan END AS NamaPenjamin,
// 									   is_intensif,xx.VentiUsed,0 as TarifKonsultasi,0 as TarifTindakan,0 as TarifPelayananDarah,0 as TarifFisio

//                     FROM RawatInapSQL.dbo.Inpatient a
//                     inner join RawatInapSQL.dbo.View_SummeryRawatInap b on a.NoRegRI=b.NoRegRI
//                     left join PerawatanSQL.dbo.View_VisitExtnded c on a.NoRegisRwj=c.NoRegistrasi
//                     left join PerawatanSQL.dbo.BPJS_T_SEP d on a.NoRegRI=d.NO_REGISTRASI
//                 inner join MasterDataSQL.dbo.Admision v on a.NoMR=v.NoMR
//                 left join MasterdataSQL.dbo.Doctors dd on a.drPenerima=dd.ID
//             left join MasterDataSQL.dbo.MstrPerusahaanJPK m on a.IDJPK=m.ID
//             left join MasterDataSQL.dbo.MstrPerusahaanAsuransi n on a.IDAsuransi=n.ID
// 			outer apply (SELECT sum(LamaRawat) as is_intensif FROM RawatInapSQL.dbo.View_LamaRawat where NoRegRI=a.NoRegRI 
// 			AND Class in ('ICU','NICU','PICU','NEONATUS','HCU','ISOLASI HCU','ISOLASI HCCU')) x
//             outer apply (SELECT datediff(hour, min(Tgl),max(Tgl)) as VentiUsed  from MedicalRecord.dbo.MR_Ventilasi_ICU 
// 			where NoEpisode collate Latin1_General_CI_AS=a.NoEpisode) xx
//                     where a.NoRegRI=:id";

//             }

//             $this->db->query($query);
             
//              $this->db->bind('id', $id); 
//              //$this->db->bind('id2', $id); 
//              $key =  $this->db->single();
//              $pasing['NO_SEP'] = $key['NO_SEP'];
//              $pasing['NAMA_PESERTA'] = $key['NAMA_PESERTA'];
//              $pasing['DOB'] = $key['DOB'];
//              $pasing['GENDER'] = $key['GENDER'];
//              $pasing['NO_REGISTRASI'] = $key['NO_REGISTRASI'];
//              $pasing['NO_MR'] = $key['NO_MR'];
//              $pasing['TGL_SEP'] = $key['TGL_SEP'];
//              $pasing['NO_KARTU'] = $key['NO_KARTU'];
//              $pasing['KODE_KELAS_RAWAT'] = $key['KODE_KELAS_RAWAT'];
//              $pasing['StartDate'] = $key['StartDate'];
//              $pasing['EndDate'] = $key['EndDate'];
//              $pasing['LOS'] = $key['LOS'];
//              $pasing['JAM_LOS'] = $key['JAM_LOS'];
//              $pasing['UMUR'] = $key['UMUR'];
//              $pasing['BeratLahir'] = $key['BeratLahir'];
//              $pasing['NAMA_DOKTER'] = $key['NAMA_DOKTER'];
//              //$pasing['ID_EKLAIM'] = $key['ID_EKLAIM'];
//              $pasing['KODE_JENIS_RAWAT'] = $key['KODE_JENIS_RAWAT'];
//              $pasing['IS_EKSEKUTIF'] = $key['IS_EKSEKUTIF'];
//              $pasing['IS_COB'] = $key['IS_COB'];
//              $pasing['NAIK_KELAS'] = $key['NAIK_KELAS'];
//              $pasing['jamkunjungan'] = $key['jamkunjungan'];
//              $pasing['TotalLab'] = $key['TotalLab'];
//              $pasing['TotalRad'] = $key['TotalRad'];
//              $pasing['TotalAptk'] = $key['TotalAptk'];
//              $pasing['TotalOP'] = $key['TotalOP'];
//              $pasing['TotalKamar'] = $key['TotalKamar'];
//              $pasing['TotalKonsul'] = $key['TotalKonsul'];
//              $pasing['TotalTindakan'] = $key['TotalTindakan'];

//              $pasing['PatientName'] = $key['PatientName'];
//              $pasing['NoMR'] = $key['NoMR'];
//              $pasing['JenisKelamin'] = $key['JenisKelamin'];
//              $pasing['DOB_ext'] = $key['DOB_ext'];
//              $pasing['UMUR_ext'] = $key['UMUR_ext'];
//              $pasing['NamaDokter_ext'] = $key['NamaDokter_ext'];
//              $pasing['NamaPenjamin'] = $key['NamaPenjamin'];
//              $pasing['is_intensif'] = $key['is_intensif'];
//              $pasing['VentiUsed'] = $key['VentiUsed'];
             
//              $pasing['TarifKonsultasi'] = $key['TarifKonsultasi'];
//              $pasing['TarifTindakan'] = $key['TarifTindakan'];
             
//              $pasing['TarifPelayananDarah'] = $key['TarifPelayananDarah'];
//              $pasing['TarifFisio'] = $key['TarifFisio'];
             

//                             $callback = array(
//                                 'message' => "success", // Set array nama 
//                                 'data' => $pasing
//                             );
//                             return $callback;
//         } catch (PDOException $e) {
//             die($e->getMessage());
//         }
//     }

public function goGetDatabyNoSEP($data)
    {
        try {
            $id = $data['id'];
            $getreg = substr($id, 0, 2);

            if ($getreg == 'RJ') {
                $query = "SELECT  NO_SEP
                ,NAMA_PESERTA,replace(CONVERT(VARCHAR(11), d.TGL_LAHIR, 111), '/','-') as DOB,
                                    CASE WHEN JENIS_KELAMIN='LAKI-LAKI' THEN '1'
                                    ELSE '2' END AS GENDER
                                    ,d.NO_REGISTRASI,d.NO_MR,TGL_SEP,d.NO_KARTU,
                                    KODE_KELAS_RAWAT, replace(CONVERT(VARCHAR(11), d.TGL_SEP, 111), '/','-') as StartDate, replace(CONVERT(VARCHAR(11), d.TGL_SEP, 111), '/','-') as EndDate,
                                   CONVERT(VARCHAR(8),d.TGL_CREATE,108) as jamkunjungan,
                                    DATEDIFF(dd, d.TGL_CREATE, d.TGL_CREATE)+1 as LOS,'00:00' as JAM_LOS ,
                                   DATEDIFF(yy, d.TGL_LAHIR, GETDATE()) as UMUR,'-' BeratLahir,d.NAMA_DOKTER,
                                    '2'  AS KODE_JENIS_RAWAT
                                   ,d.IS_EKSEKUTIF,d.IS_COB,d.NAIK_KELAS,
                                   0 as TotalLab, 
                                   0 as TotalRad,
                                  0 as TotalAptk
                                   ,0 as TotalKamar
                                   ,0  as TotalKonsul
                                   ,0 as  TotalOP
                                   ,0  as TotalTindakan
                                   ,null NamaPenjamin,null is_intensif,null VentiUsed,0 as TarifKonsultasi,0 as TarifTindakan,0 as TarifPelayananDarah,0 as TarifFisio

                FROM PerawatanSQL.dbo.BPJS_T_SEP d 
                where d.NO_REGISTRASI=:id";
            }else{
                    $query = "SELECT 
                    NO_SEP
                ,NAMA_PESERTA,replace(CONVERT(VARCHAR(11), d.TGL_LAHIR, 111), '/','-') as DOB,
                                        CASE WHEN JENIS_KELAMIN='LAKI-LAKI' THEN '1'
                                        ELSE '2' END AS GENDER
                                        ,d.NO_REGISTRASI,d.NO_MR,TGL_SEP,d.NO_KARTU,
                                       KODE_KELAS_RAWAT, replace(CONVERT(VARCHAR(11), StartDate, 111), '/','-') as StartDate, 
									   replace(CONVERT(VARCHAR(11), EndDate, 111), '/','-') as EndDate,
                                       CONVERT(VARCHAR(8),StartTime,108) as jamkunjungan,
                                        DATEDIFF(dd, a.StartDate, a.EndDate)+1 as LOS,'00:00' as JAM_LOS ,
                                       DATEDIFF(yy, d.TGL_LAHIR, GETDATE()) as UMUR,'-' BeratLahir,d.NAMA_DOKTER,
                                       CASE WHEN d.ID IS NOT NULL THEN d.KODE_JENIS_RAWAT 
                                    ELSE '1' END AS KODE_JENIS_RAWAT
                                       ,d.IS_EKSEKUTIF,d.IS_COB,d.NAIK_KELAS,
                                      0 as TotalLab, 
                                       0as TotalRad,
                                       0 as TotalAptk
                                       , 0 as TotalKamar
                                       , 0  as TotalKonsul
                                       , 0 as TotalOP
                                       ,0  as TotalTindakan
									   ,'' NamaPenjamin,
									   is_intensif,xx.VentiUsed,0 as TarifKonsultasi,0 as TarifTindakan,0 as TarifPelayananDarah,0 as TarifFisio

                    FROM  PerawatanSQL.dbo.BPJS_T_SEP d 
					inner join RawatInapSQL.dbo.Inpatient a on d.NO_REGISTRASI=a.NoRegRI
			outer apply (SELECT sum(LamaRawat) as is_intensif FROM RawatInapSQL.dbo.View_LamaRawat where NoRegRI=a.NoRegRI 
			AND Class in ('ICU','NICU','PICU','NEONATUS','HCU','ISOLASI HCU','ISOLASI HCCU')) x
            outer apply (SELECT datediff(hour, min(Tgl),max(Tgl)) as VentiUsed  from MedicalRecord.dbo.MR_Ventilasi_ICU 
			where NoEpisode collate Latin1_General_CI_AS=a.NoEpisode) xx
                    where a.NoRegRI=:id";

            }

            $this->db->query($query);
             
             $this->db->bind('id', $id); 
             //$this->db->bind('id2', $id); 
             $key =  $this->db->single();
             $pasing['NO_SEP'] = $key['NO_SEP'];
             $pasing['NAMA_PESERTA'] = $key['NAMA_PESERTA'];
             $pasing['DOB'] = $key['DOB'];
             $pasing['GENDER'] = $key['GENDER'];
             $pasing['NO_REGISTRASI'] = $key['NO_REGISTRASI'];
             $pasing['NO_MR'] = $key['NO_MR'];
             $pasing['TGL_SEP'] = $key['TGL_SEP'];
             $pasing['NO_KARTU'] = $key['NO_KARTU'];
             $pasing['KODE_KELAS_RAWAT'] = $key['KODE_KELAS_RAWAT'];
             $pasing['StartDate'] = $key['StartDate'];
             $pasing['EndDate'] = $key['EndDate'];
             $pasing['LOS'] = $key['LOS'];
             $pasing['JAM_LOS'] = $key['JAM_LOS'];
             $pasing['UMUR'] = $key['UMUR'];
             $pasing['BeratLahir'] = $key['BeratLahir'];
             $pasing['NAMA_DOKTER'] = $key['NAMA_DOKTER'];
             //$pasing['ID_EKLAIM'] = $key['ID_EKLAIM'];
             $pasing['KODE_JENIS_RAWAT'] = $key['KODE_JENIS_RAWAT'];
             $pasing['IS_EKSEKUTIF'] = $key['IS_EKSEKUTIF'];
             $pasing['IS_COB'] = $key['IS_COB'];
             $pasing['NAIK_KELAS'] = $key['NAIK_KELAS'];
             $pasing['jamkunjungan'] = $key['jamkunjungan'];
             $pasing['TotalLab'] = $key['TotalLab'];
             $pasing['TotalRad'] = $key['TotalRad'];
             $pasing['TotalAptk'] = $key['TotalAptk'];
             $pasing['TotalOP'] = $key['TotalOP'];
             $pasing['TotalKamar'] = $key['TotalKamar'];
             $pasing['TotalKonsul'] = $key['TotalKonsul'];
             $pasing['TotalTindakan'] = $key['TotalTindakan'];

             $pasing['NamaPenjamin'] = $key['NamaPenjamin'];
             $pasing['is_intensif'] = $key['is_intensif'];
             $pasing['VentiUsed'] = $key['VentiUsed'];
             
             $pasing['TarifKonsultasi'] = $key['TarifKonsultasi'];
             $pasing['TarifTindakan'] = $key['TarifTindakan'];
             
             $pasing['TarifPelayananDarah'] = $key['TarifPelayananDarah'];
             $pasing['TarifFisio'] = $key['TarifFisio'];
             
            if ($key['NO_SEP'] != null){
                $callback = array(
                    'message' => "success", // Set array nama 
                    'data' => $pasing,
                    'is_bridging' => true,
                );
            }else{
                $callback = $this->goGetDatabyNoRegistrasi($id);
            }
            
            return $callback;
                            
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function goGetDatabyIDEKLAIM($data)
    {
        try {
            $ID_EKLAIM = $data['ID_EKLAIM'];
            $this->db->query("SELECT *,
                    replace(CONVERT(VARCHAR(11), TGL_MASUK, 111), '/','-') as StartDate,
                    CONVERT(VARCHAR(8),TGL_MASUK,108) as JamMasuk,
                    replace(CONVERT(VARCHAR(11), TGL_PULANG, 111), '/','-') as EndDate,
                    CONVERT(VARCHAR(8),TGL_PULANG,108) as JamKeluar,
                    DATEDIFF(dd, TGL_MASUK, TGL_PULANG)+1 as LOS,
                    DATEDIFF(yy, TGL_LAHIR, GETDATE()) as UMUR,
                    replace(CONVERT(VARCHAR(11), TGL_LAHIR, 111), '/','-') as TGL_LAHIR
             FROM DashboardData.dbo.EKLAIM Where ID=:ID_EKLAIM 
             ");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $key =  $this->db->single();

             $pasing['NO_MR'] = $key['NO_MR'];
             $pasing['NAMA_PASIEN'] = $key['NAMA_PASIEN'];
             $pasing['TGL_LAHIR'] = $key['TGL_LAHIR'];
             $pasing['GENDER'] = $key['GENDER'];
                $pasing['NO_REGISTRASI'] = $key['NO_REGISTRASI'];
                $pasing['NO_KARTU'] = $key['NO_KARTU'];
                $pasing['NO_SEP'] = $key['NO_SEP'];
                $pasing['JENIS_RAWAT'] = $key['JENIS_RAWAT'];
                $pasing['NAMA_JENIS_RAWAT'] = $key['NAMA_JENIS_RAWAT'];
                $pasing['KELAS_RAWAT'] = $key['KELAS_RAWAT'];
                $pasing['ADL_SUB_ACUTE'] = $key['ADL_SUB_ACUTE'];
                $pasing['ADL_CHRONIC'] = $key['ADL_CHRONIC'];
                $pasing['ICU_INDIKATOR'] = $key['ICU_INDIKATOR'];
                $pasing['ICU_LOS'] = $key['ICU_LOS'];
                $pasing['VENTILATOR_HOUR'] = $key['VENTILATOR_HOUR'];
                $pasing['UPGRADE_CLASS_IND'] = $key['UPGRADE_CLASS_IND'];
                $pasing['UPGRADE_CLASS_CLASS'] = $key['UPGRADE_CLASS_CLASS'];
                $pasing['UPGRADE_CLASS_LOS'] = $key['UPGRADE_CLASS_LOS'];
                $pasing['ADD_PAYMENT_PCT'] = $key['ADD_PAYMENT_PCT'];
                $pasing['BIRTH_WEIGHT'] = $key['BIRTH_WEIGHT'];
                $pasing['DISCHARGE_STATUS'] = $key['DISCHARGE_STATUS'];
                $pasing['NAMA_DISCHARGE_STATUS'] = $key['NAMA_DISCHARGE_STATUS'];
                $pasing['TARIF_PROSEDUR_NON_BEDAH'] = $key['TARIF_PROSEDUR_NON_BEDAH'];
                $pasing['TARIF_PROSEDUR_BEDAH'] = $key['TARIF_PROSEDUR_BEDAH'];
                $pasing['TARIF_KONSULTASI'] = $key['TARIF_KONSULTASI'];
                $pasing['TARIF_TENAGA_AHLI'] = $key['TARIF_TENAGA_AHLI'];
                $pasing['TARIF_KEPERAWATAN'] = $key['TARIF_KEPERAWATAN'];
                $pasing['TARIF_PENUNJANG'] = $key['TARIF_PENUNJANG'];
                $pasing['TARIF_RADIOLOGI'] = $key['TARIF_RADIOLOGI'];
                $pasing['TARIF_LABORATORIUM'] = $key['TARIF_LABORATORIUM'];
                $pasing['TARIF_PELAYANAN_DARAH'] = $key['TARIF_PELAYANAN_DARAH'];
                $pasing['TARIF_REHABILITASI'] = $key['TARIF_REHABILITASI'];
                $pasing['TARIF_KAMAR'] = $key['TARIF_KAMAR'];
                $pasing['TARIF_RAWAT_INTENSIF'] = $key['TARIF_RAWAT_INTENSIF'];
                $pasing['TARIF_OBAT'] = $key['TARIF_OBAT'];
                $pasing['TARIF_OBAT_KRONIS'] = $key['TARIF_OBAT_KRONIS'];
                $pasing['TARIF_OBAT_KEMOTERAPI'] = $key['TARIF_OBAT_KEMOTERAPI'];
                $pasing['TARIF_ALKES'] = $key['TARIF_ALKES'];
                $pasing['TARIF_BMHP'] = $key['TARIF_BMHP'];
                $pasing['TARIF_SEWA_ALAT'] = $key['TARIF_SEWA_ALAT'];
                $pasing['PEMULASARAAN_JENAZAH'] = $key['PEMULASARAAN_JENAZAH'];
                $pasing['KANTONG_JENAZAH'] = $key['KANTONG_JENAZAH'];
                $pasing['PETI_JENAZAH'] = $key['PETI_JENAZAH'];
                $pasing['PLASTIK_ERAT'] = $key['PLASTIK_ERAT'];
                $pasing['DESINFEKTAN_JENAZAH'] = $key['DESINFEKTAN_JENAZAH'];
                $pasing['MOBIL_JENAZAH'] = $key['MOBIL_JENAZAH'];
                $pasing['DESINFEKTAN_MOBIL_JENAZAH'] = $key['DESINFEKTAN_MOBIL_JENAZAH'];
                $pasing['COVID19_STATUS_CD'] = $key['COVID19_STATUS_CD'];
                $pasing['NOMOR_KARTU_T'] = $key['NOMOR_KARTU_T'];
                $pasing['EPISODES'] = $key['EPISODES'];
                $pasing['COVID19_CC_IND'] = $key['COVID19_CC_IND'];
                $pasing['COVID19_RS_DARURAT_IND'] = $key['COVID19_RS_DARURAT_IND'];
                $pasing['COVID19_CO_INSIDENSE_IND'] = $key['COVID19_CO_INSIDENSE_IND'];
                $pasing['COVID19_NO_SEP'] = $key['COVID19_NO_SEP'];
                $pasing['LAB_ASAM_LAKTAT'] = $key['LAB_ASAM_LAKTAT'];
                $pasing['LAB_PROCALCITONIN'] = $key['LAB_PROCALCITONIN'];
                $pasing['LAB_CRP'] = $key['LAB_CRP'];
                $pasing['LAB_KULTUR'] = $key['LAB_KULTUR'];
                $pasing['LAB_D_DIMER'] = $key['LAB_D_DIMER'];
                $pasing['LAB_PT'] = $key['LAB_PT'];
                $pasing['LAB_APTT'] = $key['LAB_APTT'];
                $pasing['LAB_WAKTU_PENDARAHAN'] = $key['LAB_WAKTU_PENDARAHAN'];
                $pasing['LAB_ANTI_HIV'] = $key['LAB_ANTI_HIV'];
                $pasing['LAB_ANALISA_GAS'] = $key['LAB_ANALISA_GAS'];
                $pasing['LAB_ALBUMIN'] = $key['LAB_ALBUMIN'];
                $pasing['RAD_THORAX_AP_PA'] = $key['RAD_THORAX_AP_PA'];
                $pasing['TERAPI_KONVALESEN'] = $key['TERAPI_KONVALESEN'];
                $pasing['AKSES_NAAT'] = $key['AKSES_NAAT'];
                $pasing['ISOMAN_IND'] = $key['ISOMAN_IND'];
                $pasing['BAYI_LAHIR_STATUS_CD'] = $key['BAYI_LAHIR_STATUS_CD'];
                $pasing['TARIF_POLI_EKS'] = $key['TARIF_POLI_EKS'];
                $pasing['NAMA_DOKTER'] = $key['NAMA_DOKTER'];
                $pasing['KODE_TARIF'] = $key['KODE_TARIF'];
                $pasing['PAYOR_ID'] = $key['PAYOR_ID'];
                $pasing['PAYOR_CD'] = $key['PAYOR_CD'];
                $pasing['COB_CD'] = $key['COB_CD'];
                $pasing['CODER_NIK'] = $key['CODER_NIK'];
                $pasing['DATE_UPDATE'] = $key['DATE_UPDATE'];
                $pasing['USER_UPDATE'] = $key['USER_UPDATE'];
                $pasing['FINAL_KLAIM'] = $key['FINAL_KLAIM'];
                $pasing['StartDate'] = $key['StartDate'];
                $pasing['JamMasuk'] = $key['JamMasuk'];
                $pasing['EndDate'] = $key['EndDate'];
                $pasing['JamKeluar'] = $key['JamKeluar'];
                $pasing['LOS'] = $key['LOS'];
                $pasing['UMUR'] = $key['UMUR'];
                $pasing['TOTAL_TARIF_RS'] = $key['TOTAL_TARIF_RS'];
                $pasing['PENJAMIN'] = $key['PENJAMIN'];
                $pasing['NO_REGISTER_SITB'] = $key['NO_REGISTER_SITB'];

            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function addDiagnosa($data)
    {
        try {
            $this->db->transaksi();


            if ($data['ID_EKLAIM'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'ID Klaim Tidak Ditemukan ! Silahkan Buat Klaim Baru !',
                );
                return $callback;
                exit;
            }

            if ($data['kode_diagnosa'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Diagnosa!',
                );
                return $callback;
                exit;
            }

            $ID_EKLAIM = $data['ID_EKLAIM'];
            $kode_diagnosa = $data['kode_diagnosa'];
            $nama_diagnosa = $data['nama_diagnosa'];
            $nomor_registrasi = $data['nomor_registrasi'];
            $TGLNOW = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $namauser = $session->name;


            $nomor_sep = $data['nomor_sep'];
            $payor_id = $data['payor_id'];

            $this->db->query("SELECT ID from DashboardData.dbo.EKLAIM_DTL_DIAGNOSA
                                where ID_EKLAIM=:ID_EKLAIM and KODE_DIAGNOSA=:kode_diagnosa AND NAMA_DIAGNOSA=:nama_diagnosa");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $this->db->bind('kode_diagnosa', $kode_diagnosa);
            $this->db->bind('nama_diagnosa', $nama_diagnosa);
            $data =  $this->db->resultSet();
            if (count($data) > 0) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Sudah Ada Diagnosa Tersebut !',
                );
                return $callback;
                exit;
            }

            //GET DIAGNOSA FROM TABLE
            $this->db->query("SELECT KODE_DIAGNOSA FROM DashboardData.dbo.EKLAIM_DTL_DIAGNOSA
                                           where ID_EKLAIM=:ID_EKLAIM 
                                           order by IS_PRIMER desc");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $datas =  $this->db->resultSet();
            $rows = array();
            foreach ($datas as $key) {
                $rows[] = $key['KODE_DIAGNOSA'];
            }

            if (count($datas) > 0) {
                $diagnosa = implode("#", $rows);
                $separator = '#';
            } else {
                $separator = null;
                $diagnosa = null;
            }
            $diagnosa .= $separator . $kode_diagnosa;

            $coder_nik = $this->getcoderNIK();
            $ws_query["metadata"]["method"] = "set_claim_data";
            $ws_query["metadata"]["nomor_sep"] = $nomor_sep;

            $ws_query["data"]["diagnosa"] =  $diagnosa;
            $ws_query["data"]["coder_nik"] =  $coder_nik;
            $ws_query["data"]["payor_id"] =  $payor_id;

            $json_request = json_encode($ws_query);

            $response =  $this->EklaimApi($json_request);

            if ($response['metadata']['code'] == 200) {

                $this->db->query("SELECT ID from DashboardData.dbo.EKLAIM_DTL_DIAGNOSA
                where ID_EKLAIM=:ID_EKLAIM and IS_PRIMER='1'");
                $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
                $data =  $this->db->resultSet();
                if (count($data) > 0) {
                    $is_primer = '0';
                } else {
                    $is_primer = '1';
                }

                $this->db->query("INSERT INTO DashboardData.dbo.EKLAIM_DTL_DIAGNOSA (ID_EKLAIM,KODE_DIAGNOSA,NAMA_DIAGNOSA,IS_PRIMER,DATE_CREATE,USER_CREATE) VALUES
            (:ID_EKLAIM,:KODE_DIAGNOSA,:NAMA_DIAGNOSA,:IS_PRIMER,:DATE_CREATE,:USER_CREATE)");
                $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
                $this->db->bind('KODE_DIAGNOSA', $kode_diagnosa);
                $this->db->bind('NAMA_DIAGNOSA', $nama_diagnosa);
                $this->db->bind('DATE_CREATE', $TGLNOW);
                $this->db->bind('USER_CREATE', $userid);
                $this->db->bind('IS_PRIMER', $is_primer);
                $this->db->execute();
                $getID = $this->db->GetLastID();

                //INSERT TABLE ICD
                $this->db->query("SELECT ID from MasterDataSQL.dbo.ICDX
                where ICD_CODE=:KODE_DIAGNOSA");
                $this->db->bind('KODE_DIAGNOSA', $kode_diagnosa);
                $key =  $this->db->single();
                $ID_ICD = $key['ID'];
                if ($ID_ICD == null) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Diagnosa Tidak Ditemukan Di Database RS !',
                    );
                    return $callback;
                    exit;
                }

                
                $getreg = substr($nomor_registrasi,0,2);
                if ($getreg == 'RJ'){
                    $this->db->query("SELECT NoEpisode from PerawatanSQL.dbo.Visit
                    where NoRegistrasi=:nomor_registrasi");
                    $this->db->bind('nomor_registrasi', $nomor_registrasi);
                    $datas =  $this->db->single();
                    $NoEpisode = $datas['NoEpisode'];
                }else{
                    $this->db->query("SELECT NoEpisode from RawatInapSQL.dbo.Inpatient
                    where NoRegRI=:nomor_registrasi");
                    $this->db->bind('nomor_registrasi', $nomor_registrasi);
                    $datas =  $this->db->single();
                    $NoEpisode = $datas['NoEpisode'];
                }

                $this->db->query("SELECT count(a.ID) as cekdouble from MasterdataSQL.dbo.ICDX_Transactions a
                inner join MasterdataSQL.dbo.ICDX b on a.id_icd=b.ID
                where NoRegistrasi=:nomor_registrasi AND status='1' and b.ICD_CODE=:KODE_DIAGNOSA");
                $this->db->bind('KODE_DIAGNOSA', $kode_diagnosa);
                $this->db->bind('nomor_registrasi', $nomor_registrasi);
                $datass =  $this->db->single();
                $cekdouble = $datass['cekdouble'];

                if ($cekdouble == 0){
                    $this->db->query("INSERT INTO MasterdataSQL.dbo.ICDX_Transactions  (id_icd,NoEpisode,NoRegistrasi,Petugas_Input,Waktu_Input,status,header) VALUES
                (:ID_ICD,:NoEpisode,:NoRegistrasi,:namauser,:DATE_CREATE,'1',:is_primer)");
                    $this->db->bind('ID_ICD', $ID_ICD);
                    $this->db->bind('NoEpisode', $NoEpisode);
                    $this->db->bind('NoRegistrasi', $nomor_registrasi);
                    $this->db->bind('namauser', $namauser);
                    $this->db->bind('DATE_CREATE', $TGLNOW);
                    $this->db->bind('is_primer', $is_primer);
                    $this->db->execute();
                }
                

                // $postData['ID'] = $getID;
                // $postData['ID_EKLAIM'] = $ID_EKLAIM;
                // $postData['nomor_registrasi'] = $nomor_registrasi;
                // $postData['nomor_sep'] = $nomor_sep;
                // $postData['payor_id'] = $payor_id;

                $this->db->commit();
                // $this->SetPrimer_Diagnosa($postData);
                $callback = array(
                    'status' => 'success', // Set array status dengan success   
                    'message' => 'Diagnosa Berhasil Ditambahkan !', // Set array status dengan success    
                );
            } else {
                $callback = array(
                    'status' => 'danger',
                    'message' => $response['metadata']['message']
                );
            }


            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function getList_Diagnosa($data)
    {
        try {
            $this->db->query("SELECT *,CASE WHEN IS_PRIMER='1' THEN 'PRIMER' ELSE 'SEKUNDER' END AS STATUS_PRIMER FROM DashboardData.dbo.EKLAIM_DTL_DIAGNOSA
                                           where ID_EKLAIM=:ID_EKLAIM 
                                           order by IS_PRIMER desc");
            $this->db->bind('ID_EKLAIM', $data['ID_EKLAIM']);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['ID'] = $key['ID'];
                $pasing['NAMA_DIAGNOSA'] = $key['NAMA_DIAGNOSA'];
                $pasing['KODE_DIAGNOSA'] = $key['KODE_DIAGNOSA'];
                $pasing['IS_PRIMER'] = $key['IS_PRIMER'];
                $pasing['STATUS_PRIMER'] = $key['STATUS_PRIMER'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function addProsedur($data)
    {
        try {
            $this->db->transaksi();


            if ($data['ID_EKLAIM'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'ID Klaim Tidak Ditemukan ! Silahkan Buat Klaim Baru !',
                );
                return $callback;
                exit;
            }

            if ($data['kode_prosedur'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Prosedur!',
                );
                return $callback;
                exit;
            }

            $ID_EKLAIM = $data['ID_EKLAIM'];
            $kode_prosedur = $data['kode_prosedur'];
            $nama_prosedur = $data['nama_prosedur'];
            $nomor_registrasi = $data['nomor_registrasi'];
            $TGLNOW = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $namauser = $session->name;

            $nomor_sep = $data['nomor_sep'];
            $payor_id = $data['payor_id'];

            $this->db->query("SELECT ID from DashboardData.dbo.EKLAIM_DTL_PROSEDUR
                                where ID_EKLAIM=:ID_EKLAIM and KODE_PROSEDUR=:kode_prosedur AND NAMA_PROSEDUR=:nama_prosedur");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $this->db->bind('kode_prosedur', $kode_prosedur);
            $this->db->bind('nama_prosedur', $nama_prosedur);
            $data =  $this->db->resultSet();
            if (count($data) > 0) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Sudah Ada Prosedur Tersebut !',
                );
                return $callback;
                exit;
            }

            //GET PROSEDUR FROM TABLE
            $this->db->query("SELECT KODE_PROSEDUR FROM DashboardData.dbo.EKLAIM_DTL_PROSEDUR
         where ID_EKLAIM=:ID_EKLAIM order by ID ASC");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $datas2 =  $this->db->resultSet();
            $rows2 = array();
            foreach ($datas2 as $key) {
                $rows2[] = $key['KODE_PROSEDUR'];
            }

            if (count($datas2) > 0) {
                $procedure = implode("#", $rows2);
                $separator = '#';
            } else {
                $separator = null;
                $procedure = null;
            }

            $procedure .= $separator . $kode_prosedur;



            $coder_nik = $this->getcoderNIK();
            $ws_query["metadata"]["method"] = "set_claim_data";
            $ws_query["metadata"]["nomor_sep"] = $nomor_sep;

            $ws_query["data"]["procedure"] =  $procedure;
            $ws_query["data"]["coder_nik"] =  $coder_nik;
            $ws_query["data"]["payor_id"] =  $payor_id;

            $json_request = json_encode($ws_query);

            $response =  $this->EklaimApi($json_request);

            if ($response['metadata']['code'] == 200) {

                $this->db->query("INSERT INTO DashboardData.dbo.EKLAIM_DTL_PROSEDUR (ID_EKLAIM,KODE_PROSEDUR,NAMA_PROSEDUR,DATE_CREATE,USER_CREATE) VALUES
                  (:ID_EKLAIM,:KODE_PROSEDUR,:NAMA_PROSEDUR,:DATE_CREATE,:USER_CREATE)");

                $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
                $this->db->bind('KODE_PROSEDUR', $kode_prosedur);
                $this->db->bind('NAMA_PROSEDUR', $nama_prosedur);
                $this->db->bind('DATE_CREATE', $TGLNOW);
                $this->db->bind('USER_CREATE', $userid);
                $this->db->execute();

                //INSERT TABLE ICD
                $this->db->query("SELECT ID from MasterDataSQL.dbo.ICDX_9
                where ICD_CODE=:kode_prosedur");
                $this->db->bind('kode_prosedur', $kode_prosedur);
                $key =  $this->db->single();
                $ID_ICD = $key['ID'];

                
                $getreg = substr($nomor_registrasi,0,2);
                if ($getreg == 'RJ'){
                    $this->db->query("SELECT NoEpisode from PerawatanSQL.dbo.Visit
                    where NoRegistrasi=:nomor_registrasi");
                    $this->db->bind('nomor_registrasi', $nomor_registrasi);
                    $datas =  $this->db->single();
                    $NoEpisode = $datas['NoEpisode'];
                }else{
                    $this->db->query("SELECT NoEpisode from RawatInapSQL.dbo.Inpatient
                    where NoRegRI=:nomor_registrasi");
                    $this->db->bind('nomor_registrasi', $nomor_registrasi);
                    $datas =  $this->db->single();
                    $NoEpisode = $datas['NoEpisode'];
                }

                $this->db->query("SELECT count(a.ID) as cekdouble from MasterdataSQL.dbo.ICDX_Transactions_9 a
                inner join MasterdataSQL.dbo.ICDX_9 b on a.id_icd=b.ID
                where NoRegistrasi=:nomor_registrasi AND status='1' and b.ICD_CODE=:KODE_PROCEDURE");
                $this->db->bind('KODE_PROCEDURE', $kode_prosedur);
                $this->db->bind('nomor_registrasi', $nomor_registrasi);
                $datass =  $this->db->single();
                $cekdouble = $datass['cekdouble'];

                if ($cekdouble == 0){
                    $this->db->query("INSERT INTO MasterdataSQL.dbo.ICDX_Transactions_9  (id_icd,NoEpisode,NoRegistrasi,Petugas_Input,Waktu_Input,status,header) VALUES
                (:ID_ICD,:NoEpisode,:NoRegistrasi,:namauser,:DATE_CREATE,'1',:is_primer)");
                    $this->db->bind('ID_ICD', $ID_ICD);
                    $this->db->bind('NoEpisode', $NoEpisode);
                    $this->db->bind('NoRegistrasi', $nomor_registrasi);
                    $this->db->bind('namauser', $namauser);
                    $this->db->bind('DATE_CREATE', $TGLNOW);
                    $this->db->bind('is_primer', '1');
                    $this->db->execute();
                }

                $this->db->commit();

                $callback = array(
                    'status' => 'success',
                    'message' => 'Prosedur Berhasil Ditambahkan !',
                );
            } else {
                $callback = array(
                    'status' => 'danger',
                    'message' => $response['metadata']['message']
                );
            }

            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function getList_Prosedur($data)
    {
        try {
            $this->db->query("SELECT * FROM DashboardData.dbo.EKLAIM_DTL_PROSEDUR
                                           where ID_EKLAIM=:ID_EKLAIM");
            $this->db->bind('ID_EKLAIM', $data['ID_EKLAIM']);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['ID'] = $key['ID'];
                $pasing['NAMA_PROSEDUR'] = $key['NAMA_PROSEDUR'];
                $pasing['KODE_PROSEDUR'] = $key['KODE_PROSEDUR'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function goVoidDetails_Diag($data)
    {
        try {
            $this->db->transaksi();

            $ID_EKLAIM = $data['ID_EKLAIM'];
            $ID = $data['ID'];
            $nomor_sep = $data['nomor_sep'];
            $payor_id = $data['payor_id'];
            $nomor_registrasi = $data['nomor_registrasi'];
            $kodeicd = $data['kodeicd'];
            $this->db->query("DELETE DashboardData.dbo.EKLAIM_DTL_DIAGNOSA WHERE ID=:ID");
            $this->db->bind('ID', $ID);
            $this->db->execute();

            $this->db->query("DELETE MasterdataSQL.dbo.ICDX_Transactions 
            from MasterdataSQL.dbo.ICDX_Transactions a
            inner join MasterdataSQL.dbo.ICDX b on a.id_icd=b.ID
             WHERE Noregistrasi=:nomor_registrasi AND ICD_CODE=:kodeicd");
            $this->db->bind('nomor_registrasi', $nomor_registrasi);
            $this->db->bind('kodeicd', $kodeicd);
            $this->db->execute();

            $this->db->query("SELECT ID from DashboardData.dbo.EKLAIM_DTL_DIAGNOSA
                                where ID_EKLAIM=:ID_EKLAIM and IS_PRIMER='1'");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $data =  $this->db->resultSet();
            if (count($data) > 0) {
            } else {
                $this->db->query("UPDATE DashboardData.dbo.EKLAIM_DTL_DIAGNOSA SET IS_PRIMER='1' WHERE ID_EKLAIM=:ID_EKLAIM AND ID = (SELECT TOP 1 ID FROM DashboardData.dbo.EKLAIM_DTL_DIAGNOSA WHERE ID_EKLAIM=:ID_EKLAIM2 ORDER BY 1 ASC)");
                $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
                $this->db->bind('ID_EKLAIM2', $ID_EKLAIM);
            }
            $this->db->execute();

            //GET DIAGNOSA FROM TABLE
            $this->db->query("SELECT KODE_DIAGNOSA FROM DashboardData.dbo.EKLAIM_DTL_DIAGNOSA
               where ID_EKLAIM=:ID_EKLAIM 
               order by IS_PRIMER desc");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $datas =  $this->db->resultSet();
            $rows = array();
            foreach ($datas as $key) {
                $rows[] = $key['KODE_DIAGNOSA'];
            }

            if (count($datas) > 0) {
                $diagnosa = implode("#", $rows);
            } else {
                $diagnosa = '#';
            }

            $coder_nik = $this->getcoderNIK();
            $ws_query["metadata"]["method"] = "set_claim_data";
            $ws_query["metadata"]["nomor_sep"] = $nomor_sep;

            $ws_query["data"]["diagnosa"] =  $diagnosa;
            $ws_query["data"]["coder_nik"] =  $coder_nik;
            $ws_query["data"]["payor_id"] =  $payor_id;

            $json_request = json_encode($ws_query);

            $response =  $this->EklaimApi($json_request);


            if ($response['metadata']['code'] == 200) {

                $this->db->commit();
                $callback = array(
                    'status' => 'success', // Set array status dengan success   
                    'message' => 'Diagnosa Berhasil Dihapus !', // Set array status dengan success    
                );
            } else {
                $this->db->rollback();
                $callback = array(
                    'status' => 'danger',
                    'message' => $response['metadata']['message']
                );
            }
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function goVoidDetails_Prosedur($data)
    {
        try {
            $this->db->transaksi();
            $ID_EKLAIM = $data['ID_EKLAIM'];
            $ID = $data['ID'];
            $nomor_sep = $data['nomor_sep'];
            $payor_id = $data['payor_id'];
            $this->db->query("DELETE DashboardData.dbo.EKLAIM_DTL_PROSEDUR WHERE ID=:ID");
            $this->db->bind('ID', $ID);

            $this->db->execute();

            //GET PROSEDUR FROM TABLE
            $this->db->query("SELECT KODE_PROSEDUR FROM DashboardData.dbo.EKLAIM_DTL_PROSEDUR
         where ID_EKLAIM=:ID_EKLAIM order by ID ASC");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $datas2 =  $this->db->resultSet();
            $rows2 = array();
            foreach ($datas2 as $key) {
                $rows2[] = $key['KODE_PROSEDUR'];
            }

            if (count($datas2) > 0) {
                $procedure = implode("#", $rows2);
            } else {
                $procedure = '#';
            }

            $coder_nik = $this->getcoderNIK();
            $ws_query["metadata"]["method"] = "set_claim_data";
            $ws_query["metadata"]["nomor_sep"] = $nomor_sep;

            $ws_query["data"]["procedure"] =  $procedure;
            $ws_query["data"]["coder_nik"] =  $coder_nik;
            $ws_query["data"]["payor_id"] =  $payor_id;

            $json_request = json_encode($ws_query);

            $response =  $this->EklaimApi($json_request);

            if ($response['metadata']['code'] == 200) {

                $this->db->commit();
                $callback = array(
                    'status' => 'success', // Set array status dengan success   
                    'message' => 'Prosedur Berhasil Dihapus !', // Set array status dengan success    
                );
            } else {
                $this->db->rollback();
                $callback = array(
                    'status' => 'danger',
                    'message' => $response['metadata']['message']
                );
            }
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function SetPrimer_Diagnosa($data)
    {
        try {
            $this->db->transaksi();

            $ID_EKLAIM = $data['ID_EKLAIM'];
            $nomor_registrasi = $data['nomor_registrasi'];

            $nomor_sep = $data['nomor_sep'];
            $payor_id = $data['payor_id'];
            $ID = $data['ID'];
            $this->db->query("UPDATE DashboardData.dbo.EKLAIM_DTL_DIAGNOSA SET IS_PRIMER='0' WHERE ID_EKLAIM=:ID_EKLAIM AND IS_PRIMER='1'");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $this->db->execute();

            $this->db->query("UPDATE DashboardData.dbo.EKLAIM_DTL_DIAGNOSA SET IS_PRIMER='1' WHERE ID=:ID");
            $this->db->bind('ID', $ID);
            $this->db->execute();

            //ICD
            $this->db->query("SELECT KODE_DIAGNOSA from DashboardData.dbo.EKLAIM_DTL_DIAGNOSA
            where ID=:ID");
            $this->db->bind('ID', $ID);
            $datas =  $this->db->single();
            $KODE_DIAGNOSA = $datas['KODE_DIAGNOSA'];
            
            $this->db->query("UPDATE MasterdataSQL.dbo.ICDX_Transactions SET header='0' WHERE status='1' and NoRegistrasi=:nomor_registrasi AND header='1'");
            $this->db->bind('nomor_registrasi', $nomor_registrasi);
            $this->db->execute();

            $this->db->query("UPDATE MasterdataSQL.dbo.ICDX_Transactions SET header='1' FROM MasterdataSQL.dbo.ICDX_Transactions a
            inner join MasterdataSQL.dbo.ICDX b on a.id_icd=b.ID
             WHERE b.ICD_CODE=:KODE_DIAGNOSA AND a.NoRegistrasi=:nomor_registrasi");
            $this->db->bind('nomor_registrasi', $nomor_registrasi);
            $this->db->bind('KODE_DIAGNOSA', $KODE_DIAGNOSA);
            $this->db->execute();


            //GET DIAGNOSA FROM TABLE
            $this->db->query("SELECT KODE_DIAGNOSA FROM DashboardData.dbo.EKLAIM_DTL_DIAGNOSA
                        where ID_EKLAIM=:ID_EKLAIM 
                        order by IS_PRIMER desc");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $datas =  $this->db->resultSet();
            $rows = array();
            foreach ($datas as $key) {
                $rows[] = $key['KODE_DIAGNOSA'];
            }

            if (count($datas) > 0) {
                $diagnosa = implode("#", $rows);
            } else {
                $diagnosa = '#';
            }

            $coder_nik = $this->getcoderNIK();
            $ws_query["metadata"]["method"] = "set_claim_data";
            $ws_query["metadata"]["nomor_sep"] = $nomor_sep;

            $ws_query["data"]["diagnosa"] =  $diagnosa;
            $ws_query["data"]["coder_nik"] =  $coder_nik;
            $ws_query["data"]["payor_id"] =  $payor_id;

            $json_request = json_encode($ws_query);

            $response =  $this->EklaimApi($json_request);

            if ($response['metadata']['code'] == 200) {

                $this->db->commit();
                $callback = array(
                    'status' => 'success', // Set array status dengan success   
                    'message' => 'Berhasil Set Primer !', // Set array status dengan success    
                );
            } else {
                $this->db->rollback();
                $callback = array(
                    'status' => 'danger',
                    'message' => $response['metadata']['message']
                );
            }
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function ImportCoding($data)
    {
        try {
            $this->db->transaksi();


            if ($data['ID_EKLAIM'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'ID Klaim Tidak Ditemukan ! Silahkan Buat Klaim Baru !',
                );
                return $callback;
                exit;
            }

            $ID_EKLAIM = $data['ID_EKLAIM'];
            $TGLNOW = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;

            $nomor_sep = $data['nomor_sep'];
            $payor_id = $data['payor_id'];

            $this->db->query("DELETE DashboardData.dbo.EKLAIM_DTL_DIAGNOSA_V6 WHERE ID_EKLAIM=:ID_EKLAIM");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $this->db->execute();

            $this->db->query("DELETE DashboardData.dbo.EKLAIM_DTL_PROSEDUR_V6 WHERE ID_EKLAIM=:ID_EKLAIM");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $this->db->execute();


            $this->db->query("INSERT INTO DashboardData.dbo.EKLAIM_DTL_DIAGNOSA_V6 (ID_EKLAIM,KODE_DIAGNOSA,NAMA_DIAGNOSA,IS_PRIMER,DATE_CREATE,USER_CREATE) 
            SELECT ID_EKLAIM,KODE_DIAGNOSA,NAMA_DIAGNOSA,IS_PRIMER,'$TGLNOW','$userid' FROM DashboardData.dbo.EKLAIM_DTL_DIAGNOSA WHERE ID_EKLAIM=:ID_EKLAIM");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $this->db->execute();

            $this->db->query("INSERT INTO DashboardData.dbo.EKLAIM_DTL_PROSEDUR_V6 (ID_EKLAIM,KODE_PROSEDUR,NAMA_PROSEDUR,DATE_CREATE,USER_CREATE,IS_PRIMER,JUMLAH) 
            SELECT 
            ID_EKLAIM,KODE_PROSEDUR,NAMA_PROSEDUR,'$TGLNOW','$userid',
            CASE WHEN rn = 1 THEN 1 else 0 END AS IS_PRIMER,1
            FROM
            (
                SELECT ID, ID_EKLAIM, KODE_PROSEDUR, NAMA_PROSEDUR,
                ROW_NUMBER() OVER (PARTITION BY ID_EKLAIM ORDER BY ID ASC) AS rn
                FROM DashboardData.dbo.EKLAIM_DTL_PROSEDUR
            ) AS X WHERE ID_EKLAIM=:ID_EKLAIM");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $this->db->execute();


            //GET PROSEDUR FROM TABLE
            $this->db->query("SELECT KODE_PROSEDUR FROM DashboardData.dbo.EKLAIM_DTL_PROSEDUR_V6
         where ID_EKLAIM=:ID_EKLAIM order by ID ASC");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $datas2 =  $this->db->resultSet();
            $rows2 = array();
            foreach ($datas2 as $key) {
                $rows2[] = $key['KODE_PROSEDUR'];
            }

            if (count($datas2) > 0) {
                $procedure = implode("#", $rows2);
            } else {
                $procedure = '#';
            }

            //GET DIAGNOSA FROM TABLE
            $this->db->query("SELECT KODE_DIAGNOSA FROM DashboardData.dbo.EKLAIM_DTL_DIAGNOSA_V6
           where ID_EKLAIM=:ID_EKLAIM 
           order by IS_PRIMER desc");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $datas =  $this->db->resultSet();
            $rows = array();
            foreach ($datas as $key) {
                $rows[] = $key['KODE_DIAGNOSA'];
            }

            if (count($datas) > 0) {
                $diagnosa = implode("#", $rows);
            } else {
                $diagnosa = '#';
            }

            $coder_nik = $this->getcoderNIK();
            $ws_query["metadata"]["method"] = "set_claim_data";
            $ws_query["metadata"]["nomor_sep"] = $nomor_sep;

            $ws_query["data"]["diagnosa"] =  $diagnosa;
            $ws_query["data"]["procedure"] =  $procedure;
            $ws_query["data"]["coder_nik"] =  $coder_nik;
            $ws_query["data"]["payor_id"] =  $payor_id;

            $json_request = json_encode($ws_query);

            $response =  $this->EklaimApi($json_request);

            if ($response['metadata']['code'] == 200) {

                $this->db->commit();
                $callback = array(
                    'status' => 'success',
                    'message' => 'Import Coding Berhasil Ditambahkan !',
                );
            } else {
                $this->db->rollback();
                $callback = array(
                    'status' => 'danger',
                    'message' => $response['metadata']['message']
                );
            }

            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function getList_ProsedurV6($data)
    {
        try {
            $this->db->query("SELECT *,CASE WHEN IS_PRIMER='1' THEN 'PRIMER' ELSE 'SEKUNDER' END AS STATUS_PRIMER FROM DashboardData.dbo.EKLAIM_DTL_PROSEDUR_V6
                                           where ID_EKLAIM=:ID_EKLAIM
                                           order by IS_PRIMER desc
                                           ");
            $this->db->bind('ID_EKLAIM', $data['ID_EKLAIM']);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['ID'] = $key['ID'];
                $pasing['NAMA_PROSEDUR'] = $key['NAMA_PROSEDUR'];
                $pasing['KODE_PROSEDUR'] = $key['KODE_PROSEDUR'];
                $pasing['IS_PRIMER'] = $key['IS_PRIMER'];
                $pasing['JUMLAH'] = $key['JUMLAH'];
                $pasing['STATUS_PRIMER'] = $key['STATUS_PRIMER'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getList_DiagnosaV6($data)
    {
        try {
            $this->db->query("SELECT *,CASE WHEN IS_PRIMER='1' THEN 'PRIMER' ELSE 'SEKUNDER' END AS STATUS_PRIMER FROM DashboardData.dbo.EKLAIM_DTL_DIAGNOSA_V6
                                           where ID_EKLAIM=:ID_EKLAIM 
                                           order by IS_PRIMER desc");
            $this->db->bind('ID_EKLAIM', $data['ID_EKLAIM']);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['ID'] = $key['ID'];
                $pasing['NAMA_DIAGNOSA'] = $key['NAMA_DIAGNOSA'];
                $pasing['KODE_DIAGNOSA'] = $key['KODE_DIAGNOSA'];
                $pasing['IS_PRIMER'] = $key['IS_PRIMER'];
                $pasing['STATUS_PRIMER'] = $key['STATUS_PRIMER'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    public function goUpdateMultiplicity($data)
    {
        try {
            $this->db->transaksi();

            $ID = $data['ID'];
            $Jumlah = $data['Jumlah'];
            $ID_EKLAIM = $data['ID_EKLAIM'];
            $nomor_sep = $data['nomor_sep'];
            $payor_id = $data['payor_id'];

            if (!is_numeric($Jumlah)) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Masukkan Angka !',
                );
                echo json_encode($callback);
                exit;
            }

            $this->db->query("UPDATE DashboardData.dbo.EKLAIM_DTL_PROSEDUR_V6 SET JUMLAH=:JUMLAH WHERE ID=:ID");
            $this->db->bind('ID', $ID);
            $this->db->bind('JUMLAH', $Jumlah);
            $this->db->execute();

            //GET PROSEDUR V6 FROM TABLE
            $this->db->query("SELECT KODE_PROSEDUR,JUMLAH FROM DashboardData.dbo.EKLAIM_DTL_PROSEDUR_V6
         where ID_EKLAIM=:ID_EKLAIM order by IS_PRIMER DESC");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $datas2 =  $this->db->resultSet();
            $rows2 = array();
            foreach ($datas2 as $key) {
                if ($key['JUMLAH'] > 1) {
                    $muliplicity = '+' . $key['JUMLAH'];
                } else {
                    $muliplicity = null;
                }
                $rows2[] = $key['KODE_PROSEDUR'] . $muliplicity;
            }

            if (count($datas2) > 0) {
                $procedure = implode("#", $rows2);
            } else {
                $procedure = '#';
            }

            $coder_nik = $this->getcoderNIK();
            $ws_query["metadata"]["method"] = "set_claim_data";
            $ws_query["metadata"]["nomor_sep"] = $nomor_sep;

            $ws_query["data"]["procedure"] =  $procedure;
            $ws_query["data"]["coder_nik"] =  $coder_nik;
            $ws_query["data"]["payor_id"] =  $payor_id;

            $json_request = json_encode($ws_query);

            $response =  $this->EklaimApi($json_request);

            if ($response['metadata']['code'] == 200) {

                $this->db->commit();
                $callback = array(
                    'status' => 'success', // Set array status dengan success   
                    'message' => 'Jumlah Berhasil Diupdate !', // Set array status dengan success    
                );
            } else {
                $this->db->rollback();
                $callback = array(
                    'status' => 'danger',
                    'message' => $response['metadata']['message']
                );
            }
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function getList_DiagnosaEMR($data)
    {
        try {
            $nomor_registrasi = $data['nomor_registrasi'];
            $this->db->query("SELECT *,CASE 
            WHEN Kondisi_pasien='1' THEN 'SEMBUH' 
            WHEN Kondisi_pasien='2' then 'MENINGGOY' 
            WHEN Kondisi_pasien='3' then 'LAIN-LAIN' 
            ELSE 'TIDAK TAHU' 
            END AS STUATUSPULANG FROM MedicalRecord.dbo.MR_Resume_Medis
                                           where No_Registrasi=:nomor_registrasi");
            $this->db->bind('nomor_registrasi', $nomor_registrasi);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['ID'] = $key['id'];
                $pasing['Diagnosa_Awal'] = $key['Diagnosa_Awal'];
                $pasing['Diagnosa_Akhir'] = $key['Diagnosa_Akhir'];
                $pasing['Komordibitas'] = $key['Komordibitas'];
                $pasing['Alasan_Dirawat_Inap'] = $key['Alasan_Dirawat_Inap'];
                $pasing['Anjuran'] = $key['Anjuran'];
                $pasing['Riwayat_Penyakit'] = $key['Riwayat_Penyakit'];
                $pasing['Obat_obatan'] = $key['Obat_obatan'];
                $pasing['Obat_obatanPulang'] = $key['Obat_obatanPulang'];
                $pasing['Dokter_Merawat'] = $key['Dokter_Merawat'];
                $pasing['Tindak_Lanjut'] = $key['Tindak_Lanjut'];
                $pasing['STUATUSPULANG'] = $key['STUATUSPULANG'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function addDiagnosav6($data)
    {
        try {
            $this->db->transaksi();


            if ($data['ID_EKLAIM'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'ID Klaim Tidak Ditemukan ! Silahkan Buat Klaim Baru !',
                );
                return $callback;
                exit;
            }

            if ($data['kode_diagnosa'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Diagnosa!',
                );
                return $callback;
                exit;
            }

            $ID_EKLAIM = $data['ID_EKLAIM'];
            $kode_diagnosa = $data['kode_diagnosa'];
            $nama_diagnosa = $data['nama_diagnosa'];
            $TGLNOW = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;


            $nomor_sep = $data['nomor_sep'];
            $payor_id = $data['payor_id'];

            $this->db->query("SELECT ID from DashboardData.dbo.EKLAIM_DTL_DIAGNOSA_V6
                                where ID_EKLAIM=:ID_EKLAIM and KODE_DIAGNOSA=:kode_diagnosa AND NAMA_DIAGNOSA=:nama_diagnosa");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $this->db->bind('kode_diagnosa', $kode_diagnosa);
            $this->db->bind('nama_diagnosa', $nama_diagnosa);
            $data =  $this->db->resultSet();
            if (count($data) > 0) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Sudah Ada Diagnosa Tersebut !',
                );
                return $callback;
                exit;
            }

            //GET DIAGNOSA FROM TABLE
            $this->db->query("SELECT KODE_DIAGNOSA FROM DashboardData.dbo.EKLAIM_DTL_DIAGNOSA_V6
                                           where ID_EKLAIM=:ID_EKLAIM 
                                           order by IS_PRIMER desc");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $datas =  $this->db->resultSet();
            $rows = array();
            foreach ($datas as $key) {
                $rows[] = $key['KODE_DIAGNOSA'];
            }

            if (count($datas) > 0) {
                $diagnosa = implode("#", $rows);
                $separator = '#';
            } else {
                $separator = null;
                $diagnosa = null;
            }
            $diagnosa .= $separator . $kode_diagnosa;

            $coder_nik = $this->getcoderNIK();
            $ws_query["metadata"]["method"] = "set_claim_data";
            $ws_query["metadata"]["nomor_sep"] = $nomor_sep;

            $ws_query["data"]["diagnosa_inagrouper"] =  $diagnosa;
            $ws_query["data"]["coder_nik"] =  $coder_nik;
            $ws_query["data"]["payor_id"] =  $payor_id;

            $json_request = json_encode($ws_query);

            $response =  $this->EklaimApi($json_request);
            if ($response['metadata']['code'] == 200) {

                $this->db->query("SELECT ID from DashboardData.dbo.EKLAIM_DTL_DIAGNOSA_V6
                where ID_EKLAIM=:ID_EKLAIM and IS_PRIMER='1'");
                $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
                $data =  $this->db->resultSet();
                if (count($data) > 0) {
                    $is_primer = '0';
                } else {
                    $is_primer = '1';
                }

                $this->db->query("INSERT INTO DashboardData.dbo.EKLAIM_DTL_DIAGNOSA_V6 (ID_EKLAIM,KODE_DIAGNOSA,NAMA_DIAGNOSA,IS_PRIMER,DATE_CREATE,USER_CREATE) VALUES
            (:ID_EKLAIM,:KODE_DIAGNOSA,:NAMA_DIAGNOSA,:IS_PRIMER,:DATE_CREATE,:USER_CREATE)");
                $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
                $this->db->bind('KODE_DIAGNOSA', $kode_diagnosa);
                $this->db->bind('NAMA_DIAGNOSA', $nama_diagnosa);
                $this->db->bind('DATE_CREATE', $TGLNOW);
                $this->db->bind('USER_CREATE', $userid);
                $this->db->bind('IS_PRIMER', $is_primer);
                $this->db->execute();

                $this->db->commit();
                $callback = array(
                    'status' => 'success', // Set array status dengan success   
                    'message' => 'Diagnosa Berhasil Ditambahkan !', // Set array status dengan success    
                );
            } else {
                $callback = array(
                    'status' => 'danger',
                    'message' => $response['metadata']['message']
                );
            }


            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function goVoidDetails_Diagv6($data)
    {
        try {
            $this->db->transaksi();

            $ID_EKLAIM = $data['ID_EKLAIM'];
            $ID = $data['ID'];
            $nomor_sep = $data['nomor_sep'];
            $payor_id = $data['payor_id'];
            $this->db->query("DELETE DashboardData.dbo.EKLAIM_DTL_DIAGNOSA_V6 WHERE ID=:ID");
            $this->db->bind('ID', $ID);
            $this->db->execute();

            $this->db->query("SELECT ID from DashboardData.dbo.EKLAIM_DTL_DIAGNOSA_V6
                                where ID_EKLAIM=:ID_EKLAIM and IS_PRIMER='1'");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $data =  $this->db->resultSet();
            if (count($data) > 0) {
            } else {
                $this->db->query("UPDATE DashboardData.dbo.EKLAIM_DTL_DIAGNOSA_V6 SET IS_PRIMER='1' WHERE ID_EKLAIM=:ID_EKLAIM AND ID = (SELECT TOP 1 ID FROM DashboardData.dbo.EKLAIM_DTL_DIAGNOSA_V6 WHERE ID_EKLAIM=:ID_EKLAIM2 ORDER BY 1 ASC)");
                $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
                $this->db->bind('ID_EKLAIM2', $ID_EKLAIM);
            }
            $this->db->execute();

            //GET DIAGNOSA FROM TABLE
            $this->db->query("SELECT KODE_DIAGNOSA FROM DashboardData.dbo.EKLAIM_DTL_DIAGNOSA_V6
               where ID_EKLAIM=:ID_EKLAIM 
               order by IS_PRIMER desc");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $datas =  $this->db->resultSet();
            $rows = array();
            foreach ($datas as $key) {
                $rows[] = $key['KODE_DIAGNOSA'];
            }

            if (count($datas) > 0) {
                $diagnosa = implode("#", $rows);
            } else {
                $diagnosa = '#';
            }

            $coder_nik = $this->getcoderNIK();
            $ws_query["metadata"]["method"] = "set_claim_data";
            $ws_query["metadata"]["nomor_sep"] = $nomor_sep;

            $ws_query["data"]["diagnosa_inagrouper"] =  $diagnosa;
            $ws_query["data"]["coder_nik"] =  $coder_nik;
            $ws_query["data"]["payor_id"] =  $payor_id;

            $json_request = json_encode($ws_query);

            $response =  $this->EklaimApi($json_request);


            if ($response['metadata']['code'] == 200) {

                $this->db->commit();
                $callback = array(
                    'status' => 'success', // Set array status dengan success   
                    'message' => 'Diagnosa Berhasil Dihapus !', // Set array status dengan success    
                );
            } else {
                $this->db->rollback();
                $callback = array(
                    'status' => 'danger',
                    'message' => $response['metadata']['message']
                );
            }
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function SetPrimer_Diagnosav6($data)
    {
        try {
            $this->db->transaksi();

            $ID_EKLAIM = $data['ID_EKLAIM'];

            $nomor_sep = $data['nomor_sep'];
            $payor_id = $data['payor_id'];
            $ID = $data['ID'];
            $this->db->query("UPDATE DashboardData.dbo.EKLAIM_DTL_DIAGNOSA_V6 SET IS_PRIMER='0' WHERE ID_EKLAIM=:ID_EKLAIM AND IS_PRIMER='1'");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $this->db->execute();

            $this->db->query("UPDATE DashboardData.dbo.EKLAIM_DTL_DIAGNOSA_V6 SET IS_PRIMER='1' WHERE ID=:ID");
            $this->db->bind('ID', $ID);
            $this->db->execute();


            //GET DIAGNOSA FROM TABLE
            $this->db->query("SELECT KODE_DIAGNOSA FROM DashboardData.dbo.EKLAIM_DTL_DIAGNOSA_V6
                        where ID_EKLAIM=:ID_EKLAIM 
                        order by IS_PRIMER desc");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $datas =  $this->db->resultSet();
            $rows = array();
            foreach ($datas as $key) {
                $rows[] = $key['KODE_DIAGNOSA'];
            }

            if (count($datas) > 0) {
                $diagnosa = implode("#", $rows);
            } else {
                $diagnosa = '#';
            }

            $coder_nik = $this->getcoderNIK();
            $ws_query["metadata"]["method"] = "set_claim_data";
            $ws_query["metadata"]["nomor_sep"] = $nomor_sep;

            $ws_query["data"]["diagnosa_inagrouper"] =  $diagnosa;
            $ws_query["data"]["coder_nik"] =  $coder_nik;
            $ws_query["data"]["payor_id"] =  $payor_id;

            $json_request = json_encode($ws_query);

            $response =  $this->EklaimApi($json_request);

            if ($response['metadata']['code'] == 200) {

                $this->db->commit();
                $callback = array(
                    'status' => 'success', // Set array status dengan success   
                    'message' => 'Berhasil Set Primer !', // Set array status dengan success    
                );
            } else {
                $this->db->rollback();
                $callback = array(
                    'status' => 'danger',
                    'message' => $response['metadata']['message']
                );
            }
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function goVoidDetails_Prosedurv6($data)
    {
        try {
            $this->db->transaksi();
            $ID_EKLAIM = $data['ID_EKLAIM'];
            $ID = $data['ID'];
            $nomor_sep = $data['nomor_sep'];
            $payor_id = $data['payor_id'];
            $this->db->query("DELETE DashboardData.dbo.EKLAIM_DTL_PROSEDUR_V6 WHERE ID=:ID");
            $this->db->bind('ID', $ID);
            $this->db->execute();

            $this->db->query("SELECT ID from DashboardData.dbo.EKLAIM_DTL_PROSEDUR_V6
                                where ID_EKLAIM=:ID_EKLAIM and IS_PRIMER='1'");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $data =  $this->db->resultSet();
            if (count($data) > 0) {
            } else {
                $this->db->query("UPDATE DashboardData.dbo.EKLAIM_DTL_PROSEDUR_V6 SET IS_PRIMER='1' WHERE ID_EKLAIM=:ID_EKLAIM AND ID = (SELECT TOP 1 ID FROM DashboardData.dbo.EKLAIM_DTL_PROSEDUR_V6 WHERE ID_EKLAIM=:ID_EKLAIM2 ORDER BY 1 ASC)");
                $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
                $this->db->bind('ID_EKLAIM2', $ID_EKLAIM);
            }
            $this->db->execute();

            //GET PROSEDUR FROM TABLE
            $this->db->query("SELECT KODE_PROSEDUR FROM DashboardData.dbo.EKLAIM_DTL_PROSEDUR_V6
         where ID_EKLAIM=:ID_EKLAIM order by ID ASC");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $datas2 =  $this->db->resultSet();
            $rows2 = array();
            foreach ($datas2 as $key) {
                $rows2[] = $key['KODE_PROSEDUR'];
            }

            if (count($datas2) > 0) {
                $procedure = implode("#", $rows2);
            } else {
                $procedure = '#';
            }

            $coder_nik = $this->getcoderNIK();
            $ws_query["metadata"]["method"] = "set_claim_data";
            $ws_query["metadata"]["nomor_sep"] = $nomor_sep;

            $ws_query["data"]["procedure_inagrouper"] =  $procedure;
            $ws_query["data"]["coder_nik"] =  $coder_nik;
            $ws_query["data"]["payor_id"] =  $payor_id;

            $json_request = json_encode($ws_query);

            $response =  $this->EklaimApi($json_request);

            if ($response['metadata']['code'] == 200) {

                $this->db->commit();
                $callback = array(
                    'status' => 'success', // Set array status dengan success   
                    'message' => 'Prosedur Berhasil Dihapus !', // Set array status dengan success    
                );
            } else {
                $this->db->rollback();
                $callback = array(
                    'status' => 'danger',
                    'message' => $response['metadata']['message']
                );
            }
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function addProsedurv6($data)
    {
        try {
            $this->db->transaksi();


            if ($data['ID_EKLAIM'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'ID Klaim Tidak Ditemukan ! Silahkan Buat Klaim Baru !',
                );
                return $callback;
                exit;
            }

            if ($data['kode_prosedur'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Prosedur!',
                );
                return $callback;
                exit;
            }

            $ID_EKLAIM = $data['ID_EKLAIM'];
            $kode_prosedur = $data['kode_prosedur'];
            $nama_prosedur = $data['nama_prosedur'];
            $TGLNOW = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;

            $nomor_sep = $data['nomor_sep'];
            $payor_id = $data['payor_id'];

            $this->db->query("SELECT ID from DashboardData.dbo.EKLAIM_DTL_PROSEDUR_V6
                                where ID_EKLAIM=:ID_EKLAIM and KODE_PROSEDUR=:kode_prosedur AND NAMA_PROSEDUR=:nama_prosedur");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $this->db->bind('kode_prosedur', $kode_prosedur);
            $this->db->bind('nama_prosedur', $nama_prosedur);
            $data =  $this->db->resultSet();
            if (count($data) > 0) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Sudah Ada Prosedur Tersebut !',
                );
                return $callback;
                exit;
            }

            //GET PROSEDUR FROM TABLE
            $this->db->query("SELECT KODE_PROSEDUR FROM DashboardData.dbo.EKLAIM_DTL_PROSEDUR_V6
         where ID_EKLAIM=:ID_EKLAIM order by ID ASC");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $datas2 =  $this->db->resultSet();
            $rows2 = array();
            foreach ($datas2 as $key) {
                $rows2[] = $key['KODE_PROSEDUR'];
            }

            if (count($datas2) > 0) {
                $procedure = implode("#", $rows2);
                $separator = '#';
            } else {
                $separator = null;
                $procedure = null;
            }

            $procedure .= $separator . $kode_prosedur;



            $coder_nik = $this->getcoderNIK();
            $ws_query["metadata"]["method"] = "set_claim_data";
            $ws_query["metadata"]["nomor_sep"] = $nomor_sep;

            $ws_query["data"]["procedure_inagrouper"] =  $procedure;
            $ws_query["data"]["coder_nik"] =  $coder_nik;
            $ws_query["data"]["payor_id"] =  $payor_id;

            $json_request = json_encode($ws_query);

            $response =  $this->EklaimApi($json_request);

            if ($response['metadata']['code'] == 200) {

                $this->db->query("SELECT ID from DashboardData.dbo.EKLAIM_DTL_PROSEDUR_V6
                        where ID_EKLAIM=:ID_EKLAIM and IS_PRIMER='1'");
                $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
                $data =  $this->db->resultSet();
                if (count($data) > 0) {
                    $is_primer = '0';
                } else {
                    $is_primer = '1';
                }

                $this->db->query("INSERT INTO DashboardData.dbo.EKLAIM_DTL_PROSEDUR_V6 (ID_EKLAIM,KODE_PROSEDUR,NAMA_PROSEDUR,DATE_CREATE,USER_CREATE,JUMLAH,IS_PRIMER) VALUES
                  (:ID_EKLAIM,:KODE_PROSEDUR,:NAMA_PROSEDUR,:DATE_CREATE,:USER_CREATE,:JUMLAH,:IS_PRIMER)");

                $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
                $this->db->bind('KODE_PROSEDUR', $kode_prosedur);
                $this->db->bind('NAMA_PROSEDUR', $nama_prosedur);
                $this->db->bind('DATE_CREATE', $TGLNOW);
                $this->db->bind('USER_CREATE', $userid);
                $this->db->bind('JUMLAH', '1');
                $this->db->bind('IS_PRIMER', $is_primer);

                $this->db->execute();
                $this->db->commit();

                $callback = array(
                    'status' => 'success',
                    'message' => 'Prosedur Berhasil Ditambahkan !',
                );
            } else {
                $callback = array(
                    'status' => 'danger',
                    'message' => $response['metadata']['message']
                );
            }

            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function getList_RiwayatKlaim($data)
    {
        try {
            $this->db->query("SELECT a.ID,TGL_MASUK,TGL_PULANG,PAYOR_CD,NO_SEP,NAMA_JENIS_RAWAT,GROUP_CODE, b.username AS PETUGAS,
            CASE WHEN FINAL_KLAIM='1' AND SEND_CLAIM_INDIVIDUAL='1' THEN 'Terkirim'
            WHEN  FINAL_KLAIM='1' AND SEND_CLAIM_INDIVIDUAL='0' THEN 'Final'
            ELSE '-'
            END AS STATUS
            FROM DashboardData.dbo.EKLAIM a
            inner join MasterdataSQL.dbo.Employees b on a.USER_CREATE collate Latin1_General_CI_AS=b.NoPIN collate Latin1_General_CI_AS
                                           where NO_MR=:nomor_rm AND BATAL='0'");
            $this->db->bind('nomor_rm', $data['nomor_rm']);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['ID'] = $key['ID'];
                $pasing['TGL_MASUK'] = date('d/m/Y', strtotime($key['TGL_MASUK']));
                $pasing['TGL_PULANG'] =  date('d/m/Y', strtotime($key['TGL_PULANG']));
                $pasing['PAYOR_CD'] = $key['PAYOR_CD'];
                $pasing['NO_SEP'] = $key['NO_SEP'];
                $pasing['NAMA_JENIS_RAWAT'] = $key['NAMA_JENIS_RAWAT'];
                $pasing['GROUP_CODE'] = $key['GROUP_CODE'];
                $pasing['STATUS'] = $key['STATUS'];
                $pasing['PETUGAS'] = $key['PETUGAS'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getListDataEklaim($data)
    {
        try {
            $kriteria = $data['txSearchData'];
            $cmbxcrimr = $data['cmbxcrimr'];
            if($cmbxcrimr =="1"){ // nama pasien
                $query = "SELECT a.ID,TGL_MASUK,TGL_PULANG,PAYOR_CD,NO_SEP,NAMA_JENIS_RAWAT,GROUP_CODE, b.username AS PETUGAS,
                CASE WHEN FINAL_KLAIM='1' AND SEND_CLAIM_INDIVIDUAL='1' THEN 'Terkirim'
                WHEN  FINAL_KLAIM='1' AND SEND_CLAIM_INDIVIDUAL='0' THEN 'Final'
                ELSE '-'
                END AS STATUS,NAMA_PASIEN,TGL_LAHIR,NO_MR
                FROM DashboardData.dbo.EKLAIM a
                inner join MasterdataSQL.dbo.Employees b on a.USER_CREATE collate Latin1_General_CI_AS=b.NoPIN collate Latin1_General_CI_AS
                                               where NAMA_PASIEN like '%'+:keyword+'%' AND BATAL='0'";
                $this->db->query($query);
                $this->db->bind('keyword',   $kriteria); 
            } elseif ($cmbxcrimr == "2") { // tgl lahir
                $query = "SELECT a.ID,TGL_MASUK,TGL_PULANG,PAYOR_CD,NO_SEP,NAMA_JENIS_RAWAT,GROUP_CODE, b.username AS PETUGAS,
                CASE WHEN FINAL_KLAIM='1' AND SEND_CLAIM_INDIVIDUAL='1' THEN 'Terkirim'
                WHEN  FINAL_KLAIM='1' AND SEND_CLAIM_INDIVIDUAL='0' THEN 'Final'
                ELSE '-'
                END AS STATUS,NAMA_PASIEN,TGL_LAHIR,NO_MR
                FROM DashboardData.dbo.EKLAIM a
                inner join MasterdataSQL.dbo.Employees b on a.USER_CREATE collate Latin1_General_CI_AS=b.NoPIN collate Latin1_General_CI_AS
                                               where convert(varchar, TGL_LAHIR, 103) like '%'+:keyword+'%' AND BATAL='0'";
                $this->db->query($query);
                $this->db->bind('keyword',   $kriteria); 
            } elseif ($cmbxcrimr == "3") { // no mr
                $query = "SELECT a.ID,TGL_MASUK,TGL_PULANG,PAYOR_CD,NO_SEP,NAMA_JENIS_RAWAT,GROUP_CODE, b.username AS PETUGAS,
                CASE WHEN FINAL_KLAIM='1' AND SEND_CLAIM_INDIVIDUAL='1' THEN 'Terkirim'
                WHEN  FINAL_KLAIM='1' AND SEND_CLAIM_INDIVIDUAL='0' THEN 'Final'
                ELSE '-'
                END AS STATUS,NAMA_PASIEN,TGL_LAHIR,NO_MR
                FROM DashboardData.dbo.EKLAIM a
                inner join MasterdataSQL.dbo.Employees b on a.USER_CREATE collate Latin1_General_CI_AS=b.NoPIN collate Latin1_General_CI_AS
                                               where NO_MR like '%'+:keyword+'%' AND BATAL='0'";
                $this->db->query($query);
                $this->db->bind('keyword',   $kriteria); 
            } elseif ($cmbxcrimr == "4") { // no SEP
                $query = "SELECT a.ID,TGL_MASUK,TGL_PULANG,PAYOR_CD,NO_SEP,NAMA_JENIS_RAWAT,GROUP_CODE, b.username AS PETUGAS,
                CASE WHEN FINAL_KLAIM='1' AND SEND_CLAIM_INDIVIDUAL='1' THEN 'Terkirim'
                WHEN  FINAL_KLAIM='1' AND SEND_CLAIM_INDIVIDUAL='0' THEN 'Final'
                ELSE '-'
                END AS STATUS,NAMA_PASIEN,TGL_LAHIR,NO_MR
                FROM DashboardData.dbo.EKLAIM a
                inner join MasterdataSQL.dbo.Employees b on a.USER_CREATE collate Latin1_General_CI_AS=b.NoPIN collate Latin1_General_CI_AS
                                               where NO_SEP like '%'+:keyword+'%' AND BATAL='0'";
                $this->db->query($query);
                $this->db->bind('keyword',   $kriteria); 
            } 

            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['ID'] = $key['ID'];
                $pasing['TGL_MASUK'] = date('d/m/Y', strtotime($key['TGL_MASUK']));
                $pasing['TGL_PULANG'] =  date('d/m/Y', strtotime($key['TGL_PULANG']));
                $pasing['PAYOR_CD'] = $key['PAYOR_CD'];
                $pasing['NO_SEP'] = $key['NO_SEP'];
                $pasing['NAMA_JENIS_RAWAT'] = $key['NAMA_JENIS_RAWAT'];
                $pasing['GROUP_CODE'] = $key['GROUP_CODE'];
                $pasing['STATUS'] = $key['STATUS'];
                $pasing['PETUGAS'] = $key['PETUGAS'];
                $pasing['NAMA_PASIEN'] = $key['NAMA_PASIEN'];
                $pasing['TGL_LAHIR'] =date('d/m/Y', strtotime($key['TGL_LAHIR']));
                $pasing['NO_MR'] = $key['NO_MR'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
 

    //API----------------------------------
    public function testDecript()
    {
        try {

            $result = "----BEGIN ENCRYPTED DATA----
            U1+dJqdoUh6X4QyOWZdERcAffzhLDequA7XylnmGzIUUIpSgbmsAk6QPI0L0nYth93fQRq9Ahr6q
            6pItUa8S04HDVPKujx2dr0fiUOUprjtTWLd2T8XP5REg8rZ/xa1omn5XihQEAjSnRKt4Z00qJObi
            UhPkwldE6/J5e02Uwy2QtS8eVUnLnLSRyepSRGiS9l7VLNzu5MYV1Q==
            ----END ENCRYPTED DATA----";
            $result = str_replace('----BEGIN ENCRYPTED DATA----', '', $result);
            $result = str_replace('----END ENCRYPTED DATA----', '', $result);
            $key = Utils::eklaimKey();
            $decriptResult = Eklaim::inacbg_decrypt($result, $key);


            $callback = array(
                'status' => 'success', // Set array status dengan success    
                'result' => $decriptResult

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

    // public function showGrouper($data)
    // {
    //     try {
    //         $ID_EKLAIM = $data['ID_EKLAIM'];
    //         $this->db->query("SELECT a.*,b.FINAL_KLAIM
    //         FROM DashboardData.dbo.EKLAIM_GROUPER_V5 a
    //         inner join DashboardData.dbo.EKLAIM b on a.ID_EKLAIM=b.ID_EKLAIM
    //         WHERE ID_EKLAIM=:ID_EKLAIM
    //          ");

    //          $this->db->bind('ID_EKLAIM', $ID_EKLAIM); 
    //          $key =  $this->db->single();
    //          $pasing['NO_SEP'] = $key['NO_SEP'];
    //          $pasing['NAMA_PESERTA'] = $key['NAMA_PESERTA'];

    //                         $callback = array(
    //                             'message' => "success", // Set array nama 
    //                             'data' => $pasing
    //                         );
    //                         return $callback;
    //     } catch (PDOException $e) {
    //         die($e->getMessage());
    //     }
    // }

    public function new_claim($data)
    {
        //DECLARE VARIABLES
        $nomor_kartu = $data['nomor_kartu'];
        $nomor_sep = $data['nomor_sep'];
        $nomor_rm = $data['nomor_rm'];
        $nama_pasien = $data['nama_pasien'];
        $tgl_lahir = $data['tgl_lahir'];
        $gender = $data['gender'];
        $nomor_registrasi = $data['nomor_registrasi'];
        $penjamin = $data['penjamin'];

        $nomor_rm_converted = str_replace("-",".",$nomor_rm);

        if ($nomor_kartu == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'No. Kartu Kosong !',
            );
            echo json_encode($callback);
            exit;
        }

        // if ($nomor_sep == "") {
        //     $callback = array(
        //         'status' => 'warning',
        //         'errorname' => 'No. SEP Kosong !',
        //     );
        //     echo json_encode($callback);
        //     exit;
        // }

        if ($nomor_rm == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'No. RM Kosong !',
            );
            echo json_encode($callback);
            exit;
        }

        if ($nama_pasien == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Nama Pasien Kosong !',
            );
            echo json_encode($callback);
            exit;
        }

        if ($tgl_lahir == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Tanggal Lahir Kosong !',
            );
            echo json_encode($callback);
            exit;
        }

        if ($gender == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Jenis Kelamin Kosong !',
            );
            echo json_encode($callback);
            exit;
        }

        // $getreg = substr($data['nomor_registrasi'],0,2);
        // if ($getreg == 'RJ'){
        //     //GET status 
        //  $this->db->query("SELECT [Status ID] as statusid from PerawatanSQL.dbo.Visit WHERE NoRegistrasi=:nomor_registrasi AND [Status ID] = '4'");
        //  $this->db->bind('nomor_registrasi', $data['nomor_registrasi']);
        //  $datas =  $this->db->resultSet();

        //  if (count($datas) > 0){
        //      $callback = array(
        //          'status' => 'warning',
        //          'errorname' => 'Billing Sudah Diclose ! Mohon Dibuka Untuk Proses Eklaim !',
        //      );
        //      echo json_encode($callback);
        //      exit;
        //  }
        // }else{
        // //GET status 
        //  $this->db->query("SELECT [StatusID] as statusid from RawatInapSQL.dbo.Inpatient WHERE NoRegRI=:nomor_registrasi AND [StatusID] = '4'");
        //  $this->db->bind('nomor_registrasi', $data['nomor_registrasi']);
        //  $datas =  $this->db->resultSet();

        //  if (count($datas) > 0){
        //      $callback = array(
        //          'status' => 'warning',
        //          'errorname' => 'Billing Sudah Diclose ! Mohon Dibuka Untuk Proses Eklaim !',
        //      );
        //      echo json_encode($callback);
        //      exit;
        //  }

        //   //GET status 
        //   $this->db->query("SELECT statusResume from MedicalRecord.dbo.MR_Resume_Medis where No_Registrasi=:nomor_registrasi AND statusResume='CLOSED'");
        //   $this->db->bind('nomor_registrasi', $data['nomor_registrasi']);
        //   $datas =  $this->db->resultSet();
 
        //   if (count($datas) == 0){
        //       $callback = array(
        //           'status' => 'warning',
        //           'errorname' => 'Resume Medis Belum Diclose !',
        //       );
        //       echo json_encode($callback);
        //       exit;
        //   }
        // }

        if ($data['payor_id'] == '71') {
            $nomor_sep = $this->generate_claim_number();
        }


        // membuat json juga dapat menggunakan json_encode:
        $ws_query["metadata"]["method"] = "new_claim";
        // $ws_query["data"]["nomor_kartu"] = "16120507422";
        // $ws_query["data"]["nomor_sep"] = "0001R0016120507422";
        // $ws_query["data"]["nomor_rm"] = "123-45-67";
        // $ws_query["data"]["nama_pasien"] =  "NAMA TEST PASIEN";
        // $ws_query["data"]["tgl_lahir"] = "1940-01-01 02:00:00";
        // $ws_query["data"]["gender"] = "2";

        $ws_query["data"]["nomor_kartu"] = $nomor_kartu;
        $ws_query["data"]["nomor_sep"] = $nomor_sep;
        $ws_query["data"]["nomor_rm"] = $nomor_rm_converted;
        $ws_query["data"]["nama_pasien"] = $nama_pasien;
        $ws_query["data"]["tgl_lahir"] = $tgl_lahir;
        $ws_query["data"]["gender"] = $gender;

        $json_request = json_encode($ws_query);
        // data yang akan dikirimkan dengan method POST adalah encrypted:

        $response =  $this->EklaimApi($json_request);
        if ($response['metadata']['code'] == 200) {
            //$EncodeData = json_encode($JsonData);
            //$ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            // $JsonDatax   = json_decode(json_encode($ResultEncriptLzString), true);
            // $noSPRI = $JsonDatax['1']['noSPRI'];
            $patient_id = $response['response']['patient_id'];
            $admission_id = $response['response']['admission_id'];
            $hospital_admission_id = $response['response']['hospital_admission_id'];
            $TGLNOW = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;

            $this->db->query("INSERT INTO DashboardData.dbo.EKLAIM 
                        (NO_SEP,NO_MR,NO_REGISTRASI,NAMA_PASIEN,GENDER,
                        TGL_LAHIR,NO_KARTU,PATIENT_ID,
                        ADMISSION_ID,HOSPITAL_ADMISSION_ID,DATE_CREATE,USER_CREATE,PENJAMIN)
                        VALUES 
                        (:nomor_sep,:nomor_rm,:nomor_registrasi,
                        :nama_pasien,:gender,:tgl_lahir,:nomor_kartu
                        ,:patient_id,:admission_id
                        ,:hospital_admission_id,:date_create,:user_create,:penjamin)");

            $this->db->bind('nomor_kartu', $nomor_kartu);
            $this->db->bind('nomor_sep', $nomor_sep);
            $this->db->bind('nomor_rm', $nomor_rm);
            $this->db->bind('nama_pasien', $nama_pasien);
            $this->db->bind('tgl_lahir', $tgl_lahir);
            $this->db->bind('nomor_registrasi', $nomor_registrasi);
            $this->db->bind('gender', $gender);
            $this->db->bind('patient_id', $patient_id);
            $this->db->bind('admission_id', $admission_id);
            $this->db->bind('hospital_admission_id', $hospital_admission_id);
            $this->db->bind('date_create', $TGLNOW);
            $this->db->bind('user_create', $userid);
            $this->db->bind('penjamin', $penjamin);

            $this->db->execute();
            $getID = $this->db->GetLastID();
            $passing['ID_EKLAIM'] = $getID;
            $passing['nomor_sep'] = $nomor_sep;
            $callback = array(
                'status' => 'success',
                'message' => 'Klaim Baru Berhasil Dibuat !',
                'data' => $passing,
            );
        } else {
            $callback = array(
                'status' => 'danger',
                'message' => $response['metadata']['message']
            );
        }


        return $callback;
        //return $response;

    }
    public function update_patient($data)
    {
        //DECLARE VARIABLES
        $nomor_kartu = $data['nomor_kartu'];
        $nomor_rm = $data['nomor_rm'];
        $nama_pasien = $data['nama_pasien'];
        $tgl_lahir = $data['tgl_lahir'];
        $gender = $data['gender'];

        $nomor_rm_converted = str_replace("-",".",$nomor_rm);

        // membuat json juga dapat menggunakan json_encode:
        $ws_query["metadata"]["method"] = "update_patient";
        // $ws_query["metadata"]["nomor_rm"] = "123-45-67";
        // $ws_query["data"]["nomor_kartu"] = "16120507422"; 
        // $ws_query["data"]["nomor_rm"] = "123-45-67";
        // $ws_query["data"]["nama_pasien"] =  "TEST MUCHSIN aaa";
        // $ws_query["data"]["tgl_lahir"] = "1940-01-01 02:00:00";
        // $ws_query["data"]["gender"] = "2";

        $ws_query["metadata"]["nomor_rm"] = $nomor_rm_converted;
        $ws_query["data"]["nomor_kartu"] = $nomor_kartu;
        $ws_query["data"]["nomor_rm"] = $nomor_rm;
        $ws_query["data"]["nama_pasien"] = $nama_pasien;
        $ws_query["data"]["tgl_lahir"] = $tgl_lahir;
        $ws_query["data"]["gender"] = $gender;

        $json_request = json_encode($ws_query);
        // data yang akan dikirimkan dengan method POST adalah encrypted:

        $response =  $this->EklaimApi($json_request);
        return $response;
    }
    public function delete_patient($data)
    {
        $nomor_rm = $data['nomor_rm'];
        // membuat json juga dapat menggunakan json_encode:
        $ws_query["metadata"]["method"] = "delete_patient";
        // $ws_query["data"]["nomor_rm"] = "123-45-67";
        // $ws_query["data"]["coder_nik"] = "3175081904930001"; 
        
        $nomor_rm_converted = str_replace("-",".",$nomor_rm);
        
        $ws_query["data"]["nomor_rm"] = $nomor_rm_converted;
        $ws_query["data"]["coder_nik"] = "3175081904930001";  

        $json_request = json_encode($ws_query);
        // data yang akan dikirimkan dengan method POST adalah encrypted:

        $response =  $this->EklaimApi($json_request);
        return $response;
    }
    public function set_claim_data($data)
    {

        //Default value
        $tarif_poli_eks = null;
        $upgrade_class_ind = '0';
        $upgrade_class_class = null;
        $add_payment_pct = null;
        $upgrade_class_los = null;
        $icu_indikator = '0';
        $icu_los = null;
        $ventilator_hour = null;
        $covid19_co_insidense_ind = '0';
        $covid19_no_sep = null;
        $kelas_rawat = '3';
        $nomor_kartu_t = null;
        $covid19_rs_darurat_ind = '0';
        $isoman_ind = '0';
        $pemulasaraan_jenazah = '0';
        $kantong_jenazah = '0';
        $peti_jenazah = '0';
        $plastik_erat = '0';
        $desinfektan_jenazah = '0';
        $mobil_jenazah = '0';
        $desinfektan_mobil_jenazah = '0';

        if ($data['payor_id'] == '3') { //JIKA JAMINAN JKN
            //JIKA CEKLIS KELAS RAWAT
            if ($data['jenis_rawat'] == '2') { //Rawat Jalan/Poli
                if (isset($data['kelas_eksekutif'])) { //Jika Poli Eksekutif, Kelas = Kelas 1
                    $kelas_rawat = '1';
                    $tarif_poli_eks = $data['tarif_poli_eks'];
                } else { //Jika Poli Regular, Kelas = Kelas 3
                    $kelas_rawat = '3';
                }
            } else { //Rawat Inap
                $kelas_rawat = $data['kelas_rawat'];

                //JIKA CEKLIS NAIK KELAS
                if (isset($data['upgrade_class_ind'])) {
                    $upgrade_class_ind = '1';
                    $upgrade_class_class = $data['upgrade_class_class'];
                    $add_payment_pct = $data['add_payment_pct'];
                    $upgrade_class_los = $data['upgrade_class_los'];
                }

                //JIKA CEKLIS INTENSIF
                if (isset($data['icu_indikator'])) {
                    $icu_indikator = '1';
                    $icu_los = $data['icu_los'];
                    $ventilator_hour = $data['ventilator_hour'];
                }

                //JIKA CEKLIS CO INSIDENSE
                if (isset($data['covid19_co_insidense_ind'])) {
                    $covid19_co_insidense_ind = '1';
                    $covid19_no_sep = $data['covid19_no_sep'];
                }
            }
        } else if ($data['payor_id'] == '71') { //JIKA JAMINAN COVID-19

            $nomor_kartu_t = $data['nomor_kartu_t'];

            if ($data['jenis_rawat'] <> '2') { //Rawat Inap/IGD
                $covid19_rs_darurat_ind = $data['covid19_rs_darurat_ind'];
                $isoman_ind = $data['isoman_ind'];
            }

            if ($data['discharge_status'] == '4') {
                $pemulasaraan_jenazah = isset($data['pemulasaraan_jenazah']) ? '1' : '0';
                $kantong_jenazah = isset($data['kantong_jenazah']) ? '1' : '0';
                $peti_jenazah = isset($data['peti_jenazah']) ? '1' : '0';
                $plastik_erat = isset($data['plastik_erat']) ? '1' : '0';
                $desinfektan_jenazah = isset($data['desinfektan_jenazah']) ? '1' : '0';
                $mobil_jenazah = isset($data['mobil_jenazah']) ? '1' : '0';
                $desinfektan_mobil_jenazah = isset($data['desinfektan_mobil_jenazah']) ? '1' : '0';
            } else {
                $pemulasaraan_jenazah = '0';
                $kantong_jenazah = '0';
                $peti_jenazah = '0';
                $plastik_erat = '0';
                $desinfektan_jenazah = '0';
                $mobil_jenazah = '0';
                $desinfektan_mobil_jenazah = '0';
            }

            //JIKA CEKLIS INTENSIF
            if (isset($data['icu_indikator'])) {
                $icu_indikator = '1';
                $icu_los = $data['icu_los'];
                $ventilator_hour = $data['ventilator_hour'];
            }
        }

        $ID_EKLAIM = $data['ID_EKLAIM'];

        $nomor_sep = $data['nomor_sep'];
        $nomor_kartu = $data['nomor_kartu'];
        $tgl_masuk = date('Y-m-d H:i:s', strtotime($data['tgl_masuk']));
        $tgl_pulang = date('Y-m-d H:i:s', strtotime($data['tgl_pulang']));
        $jenis_rawat = $data['jenis_rawat'];
        //$kelas_rawat = $data['kelas_rawat'];
        $adl_sub_acute = $data['adl_sub_acute'];
        $adl_chronic = $data['adl_chronic'];
        //$icu_indikator = isset($data['icu_indikator']) ? $data['icu_indikator'] : '0';
        //$icu_los = $data['icu_los'];
        //$ventilator_hour = $data['ventilator_hour'];
        //$upgrade_class_ind = $data['upgrade_class_ind'];
        //$upgrade_class_class = $data['upgrade_class_class'];
        //$upgrade_class_los = $data['upgrade_class_los'];
        $birth_weight = $data['birth_weight'];
        $discharge_status = $data['discharge_status'];
        //$diagnosa = $data['diagnosa'];//pen
        //$procedure = $data['procedure'];//pen
        //$diagnosa_inagrouper = '';//pen
        //$procedure_inagrouper = '';//pen
        $prosedur_non_bedah = str_replace(".", "", $data['prosedur_non_bedah']);
        $prosedur_bedah = str_replace(".", "", $data['prosedur_bedah']);
        $konsultasi = str_replace(".", "", $data['konsultasi']);
        $tenaga_ahli = str_replace(".", "", $data['tenaga_ahli']);
        $keperawatan = str_replace(".", "", $data['keperawatan']);
        $penunjang = str_replace(".", "", $data['penunjang']);
        $radiologi = str_replace(".", "", $data['radiologi']);
        $laboratorium = str_replace(".", "", $data['laboratorium']);
        $pelayanan_darah = str_replace(".", "", $data['pelayanan_darah']);
        $rehabilitasi = str_replace(".", "", $data['rehabilitasi']);
        $kamar = str_replace(".", "", $data['kamar']);
        $rawat_intensif = str_replace(".", "", $data['rawat_intensif']);
        $obat = str_replace(".", "", $data['obat']);
        $obat_kronis = str_replace(".", "", $data['obat_kronis']);
        $obat_kemoterapi = str_replace(".", "", $data['obat_kemoterapi']);
        $alkes = str_replace(".", "", $data['alkes']);
        $bmhp = str_replace(".", "", $data['bmhp']);
        $sewa_alat = str_replace(".", "", $data['sewa_alat']);

        //JIKA CARA PULANG MENIGGAL
        // $pemulasaraan_jenazah = isset($data['pemulasaraan_jenazah']) ? '1' : '0';
        // $kantong_jenazah = isset($data['kantong_jenazah']) ? '1' : '0';
        // $peti_jenazah = isset($data['peti_jenazah']) ? '1' : '0';
        // $plastik_erat = isset($data['plastik_erat']) ? '1' : '0';
        // $desinfektan_jenazah = isset($data['desinfektan_jenazah']) ? '1' : '0';
        // $mobil_jenazah = isset($data['mobil_jenazah']) ? '1' : '0';
        // $desinfektan_mobil_jenazah = isset($data['desinfektan_mobil_jenazah']) ? '1' : '0';


        $covid19_status_cd = '0'; //tidak berlaku lg per 1 oktober 2021
        $episodes = ''; //tidak berlaku lg per 1 oktober 2021

        $covid19_cc_ind = '0'; //blm ada di form
        // $covid19_co_insidense_ind = isset($data['covid19_co_insidense_ind']) ? $data['covid19_co_insidense_ind'] : '0';
        // $covid19_no_sep = $data['covid19_no_sep'];

        $lab_asam_laktat = '0'; //tidak berlaku lg per 1 oktober 2021
        $lab_procalcitonin = '0'; //tidak berlaku lg per 1 oktober 2021
        $lab_crp = '0'; //tidak berlaku lg per 1 oktober 2021
        $lab_kultur = '0'; //tidak berlaku lg per 1 oktober 2021
        $lab_d_dimer = '0'; //tidak berlaku lg per 1 oktober 2021
        $lab_pt = '0'; //tidak berlaku lg per 1 oktober 2021
        $lab_aptt = '0'; //tidak berlaku lg per 1 oktober 2021
        $lab_waktu_pendarahan = '0'; //tidak berlaku lg per 1 oktober 2021
        $lab_anti_hiv = '0'; //tidak berlaku lg per 1 oktober 2021
        $lab_analisa_gas = '0'; //tidak berlaku lg per 1 oktober 2021
        $lab_albumin = '0'; //tidak berlaku lg per 1 oktober 2021
        $rad_thorax_ap_pa = '0'; //tidak berlaku lg per 1 oktober 2021

        $terapi_konvalesen = $data['terapi_konvalesen'];

        $akses_naat = '0'; //tidak berlaku lg
        $isoman_ind = $isoman_ind; //0 blm ada di form
        $bayi_lahir_status_cd = '0'; //blm ada di form
        // $tarif_poli_eks = $data['tarif_poli_eks'];

        $nama_dokter = $data['nama_dokter'];
        $kode_tarif = $data['kode_tarif'];
        $payor_id = $data['payor_id'];
        //$payor_cd = $data['payor_cd'];
        $cob_cd = $data['cob_cd']; //# jika tidak cob
        $coder_nik = $this->getcoderNIK(); //-----

        //GET KODE PAYOR
        if ($payor_id == '3') {
            $payor_cd = 'JKN';
        } elseif ($payor_id == '71') {
            $payor_cd = 'COVID-19';
        } elseif ($payor_id == '72') {
            $payor_cd = 'KIPI';
        } elseif ($payor_id == '73') {
            $payor_cd = 'BBL';
        } elseif ($payor_id == '74') {
            $payor_cd = 'PMR';
        } elseif ($payor_id == '75') {
            $payor_cd = 'CO-INS';
        } elseif ($payor_id == '76') {
            $payor_cd = 'JPS';
        }

        //GET NAMA JENIS RAWAT
        if ($jenis_rawat == '1') {
            $nama_jenisrawat = 'Rawat Inap';
        } elseif ($jenis_rawat == '2') {
            $nama_jenisrawat = 'Rawat Jalan';
        } elseif ($jenis_rawat == '3') {
            $nama_jenisrawat = 'Rawat Igd';
        }

        //GET NAMA DISCHARGE STATUS
        if ($discharge_status == '1') {
            $nama_dischargestatus = 'Atas persetujuan dokter';
        } elseif ($discharge_status == '2') {
            $nama_dischargestatus = 'Dirujuk';
        } elseif ($discharge_status == '3') {
            $nama_dischargestatus = 'Atas permintaan sendiri';
        } elseif ($discharge_status == '4') {
            $nama_dischargestatus = 'Meninggal';
        } elseif ($discharge_status == '5') {
            $nama_dischargestatus = 'Lain-lain';
        } else {
            $nama_dischargestatus = '';
        }

        if ($payor_id == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Cara Bayar Kosong !',
            );
            echo json_encode($callback);
            exit;
        }

        //GET DIAGNOSA FROM TABLE
        $this->db->query("SELECT KODE_DIAGNOSA FROM DashboardData.dbo.EKLAIM_DTL_DIAGNOSA
                                           where ID_EKLAIM=:ID_EKLAIM 
                                           order by IS_PRIMER desc");
        $this->db->bind('ID_EKLAIM', $data['ID_EKLAIM']);
        $datas =  $this->db->resultSet();
        $rows = array();
        foreach ($datas as $key) {
            $rows[] = $key['KODE_DIAGNOSA'];
        }

            if (count($datas) > 0){
                    $diagnosa = implode("#",$rows);
            }else{
                    //$diagnosa = '';
                    // $callback = array(
                    //     'status' => 'warning',
                    //     'errorname' => 'Diagnosa Harus Diiisi !',
                    // );
                    // echo json_encode($callback);
                    // exit;
                    $diagnosa = null;
            }

        //GET PROSEDUR FROM TABLE
        $this->db->query("SELECT KODE_PROSEDUR FROM DashboardData.dbo.EKLAIM_DTL_PROSEDUR
         where ID_EKLAIM=:ID_EKLAIM order by ID ASC");
        $this->db->bind('ID_EKLAIM', $data['ID_EKLAIM']);
        $datas2 =  $this->db->resultSet();
        $rows2 = array();
        foreach ($datas2 as $key) {
            $rows2[] = $key['KODE_PROSEDUR'];
        }

        if (count($datas2) > 0) {
            $procedure = implode("#", $rows2);
        } else {
            $procedure = '#';
        }

        //     //GET DIAGNOSA FROM TABLE
        // $this->db->query("SELECT KODE_DIAGNOSA,NAMA_DIAGNOSA AS NAMA FROM DashboardData.dbo.EKLAIM_DTL_DIAGNOSA
        //                                    where ID_EKLAIM=:ID_EKLAIM 
        //                                    order by IS_PRIMER desc");
        //     $this->db->bind('ID_EKLAIM', $data['ID_EKLAIM']);
        //     $datas =  $this->db->resultSet();
        //     $rows = array();
        //     foreach ($datas as $key) {
        //         $rows[] = $key['KODE_DIAGNOSA'].'-'.$key['NAMA'];
        //     }

        //     if (count($datas) > 0){
        //             $diagnosa = implode("#",$rows);
        //     }else{
        //             //$diagnosa = '';
        //             $callback = array(
        //                 'status' => 'warning',
        //                 'errorname' => 'Diagnosa Harus Diiisi !',
        //             );
        //             echo json_encode($callback);
        //             exit;
        //     }

        //  //GET PROSEDUR FROM TABLE
        //  $this->db->query("SELECT KODE_PROSEDUR,NAMA_PROSEDUR AS NAMA FROM DashboardData.dbo.EKLAIM_DTL_PROSEDUR
        //  where ID_EKLAIM=:ID_EKLAIM order by ID ASC");
        //     $this->db->bind('ID_EKLAIM', $data['ID_EKLAIM']);
        //     $datas2 =  $this->db->resultSet();
        //     $rows2 = array();
        //     foreach ($datas2 as $key) {
        //             $rows2[] = $key['KODE_PROSEDUR'].'-'.$key['NAMA'];
        //     }

        //     if (count($datas2) > 0){
        //             $procedure = implode("#",$rows2);
        //     }else{
        //             $procedure = '#';
        //     }


        //GET DIAGNOSA V6 FROM TABLE
        $this->db->query("SELECT KODE_DIAGNOSA FROM DashboardData.dbo.EKLAIM_DTL_DIAGNOSA_V6
            where ID_EKLAIM=:ID_EKLAIM 
            order by IS_PRIMER desc");
        $this->db->bind('ID_EKLAIM', $data['ID_EKLAIM']);
        $datas =  $this->db->resultSet();
        $rows = array();
        foreach ($datas as $key) {
            $rows[] = $key['KODE_DIAGNOSA'];
        }

        if (count($datas) > 0) {
            $diagnosa_inagrouper = implode("#", $rows);
        } else {
            $diagnosa_inagrouper = '#';
        }

        //GET PROSEDUR V6 FROM TABLE
        $this->db->query("SELECT KODE_PROSEDUR,JUMLAH FROM DashboardData.dbo.EKLAIM_DTL_PROSEDUR_V6
         where ID_EKLAIM=:ID_EKLAIM order by IS_PRIMER DESC");
        $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
        $datas2 =  $this->db->resultSet();
        $rows2 = array();
        foreach ($datas2 as $key) {
            if ($key['JUMLAH'] > 1) {
                $muliplicity = '+' . $key['JUMLAH'];
            } else {
                $muliplicity = null;
            }
            $rows2[] = $key['KODE_PROSEDUR'] . $muliplicity;
        }

        if (count($datas2) > 0) {
            $procedure_inagrouper = implode("#", $rows2);
        } else {
            $procedure_inagrouper = '#';
        }

        //GET DIAGNOSA PRIMER FROM TABLE
        $this->db->query("SELECT KODE_DIAGNOSA,NAMA_DIAGNOSA AS NAMA FROM DashboardData.dbo.EKLAIM_DTL_DIAGNOSA
           where ID_EKLAIM=:ID_EKLAIM AND IS_PRIMER='1'");
        $this->db->bind('ID_EKLAIM', $data['ID_EKLAIM']);
        $datas =  $this->db->resultSet();
        $rows = array();
        foreach ($datas as $key) {
            $rows[] = $key['KODE_DIAGNOSA'] . '-' . $key['NAMA'];
        }

        if (count($datas) > 0) {
            $diagnosav5_primer = implode("#", $rows);
        } else {
            $diagnosav5_primer = null;
        }

        //GET DIAGNOSA SEKUNDER FROM TABLE
        $this->db->query("SELECT KODE_DIAGNOSA,NAMA_DIAGNOSA AS NAMA FROM DashboardData.dbo.EKLAIM_DTL_DIAGNOSA
           where ID_EKLAIM=:ID_EKLAIM AND IS_PRIMER='0'");
        $this->db->bind('ID_EKLAIM', $data['ID_EKLAIM']);
        $datas =  $this->db->resultSet();
        $rows = array();
        foreach ($datas as $key) {
            $rows[] = $key['KODE_DIAGNOSA'] . '-' . $key['NAMA'];
        }

        if (count($datas) > 0) {
            $diagnosav5_sekunder = implode("#", $rows);
        } else {
            $diagnosav5_sekunder = null;
        }

        //GET PROSEDUR FROM TABLE
        $this->db->query("SELECT KODE_PROSEDUR,NAMA_PROSEDUR AS NAMA FROM DashboardData.dbo.EKLAIM_DTL_PROSEDUR
           where ID_EKLAIM=:ID_EKLAIM order by ID ASC");
        $this->db->bind('ID_EKLAIM', $data['ID_EKLAIM']);
        $datas =  $this->db->resultSet();
        $rows = array();
        foreach ($datas as $key) {
            $rows[] = $key['KODE_PROSEDUR'] . '-' . $key['NAMA'];
        }

        if (count($datas) > 0) {
            $prosedurv5 = implode("#", $rows);
        } else {
            $prosedurv5 = null;
        }

        //V6
        //GET DIAGNOSA PRIMER FROM TABLE
        $this->db->query("SELECT KODE_DIAGNOSA,NAMA_DIAGNOSA AS NAMA FROM DashboardData.dbo.EKLAIM_DTL_DIAGNOSA_V6
           where ID_EKLAIM=:ID_EKLAIM AND IS_PRIMER='1'");
        $this->db->bind('ID_EKLAIM', $data['ID_EKLAIM']);
        $datas =  $this->db->resultSet();
        $rows = array();
        foreach ($datas as $key) {
            $rows[] = $key['KODE_DIAGNOSA'] . '-' . $key['NAMA'];
        }

        if (count($datas) > 0) {
            $diagnosav6_primer = implode("#", $rows);
        } else {
            $diagnosav6_primer = null;
        }

        //GET DIAGNOSA SEKUNDER FROM TABLE
        $this->db->query("SELECT KODE_DIAGNOSA,NAMA_DIAGNOSA AS NAMA FROM DashboardData.dbo.EKLAIM_DTL_DIAGNOSA_V6
           where ID_EKLAIM=:ID_EKLAIM AND IS_PRIMER='0'");
        $this->db->bind('ID_EKLAIM', $data['ID_EKLAIM']);
        $datas =  $this->db->resultSet();
        $rows = array();
        foreach ($datas as $key) {
            $rows[] = $key['KODE_DIAGNOSA'] . '-' . $key['NAMA'];
        }

        if (count($datas) > 0) {
            $diagnosav6_sekunder = implode("#", $rows);
        } else {
            $diagnosav6_sekunder = null;
        }

        //GET PROSEDUR V6 FROM TABLE
        $this->db->query("SELECT KODE_PROSEDUR,JUMLAH,NAMA_PROSEDUR AS NAMA FROM DashboardData.dbo.EKLAIM_DTL_PROSEDUR_V6
         where ID_EKLAIM=:ID_EKLAIM AND IS_PRIMER='1'");
        $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
        $datas2 =  $this->db->resultSet();
        $rows2 = array();
        foreach ($datas2 as $key) {
            if ($key['JUMLAH'] > 1) {
                $muliplicity = '+' . $key['JUMLAH'];
            } else {
                $muliplicity = null;
            }
            $rows2[] = $key['KODE_PROSEDUR'] . $muliplicity . '-' . $key['NAMA'];
        }

        if (count($datas2) > 0) {
            $procedurev6_primer = implode("#", $rows2);
        } else {
            $procedurev6_primer = null;
        }

        //GET PROSEDUR V6 FROM TABLE
        $this->db->query("SELECT KODE_PROSEDUR,JUMLAH,NAMA_PROSEDUR AS NAMA FROM DashboardData.dbo.EKLAIM_DTL_PROSEDUR_V6
         where ID_EKLAIM=:ID_EKLAIM AND IS_PRIMER='0' order by ID Asc");
        $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
        $datas2 =  $this->db->resultSet();
        $rows2 = array();
        foreach ($datas2 as $key) {
            if ($key['JUMLAH'] > 1) {
                $muliplicity = '+' . $key['JUMLAH'];
            } else {
                $muliplicity = null;
            }
            $rows2[] = $key['KODE_PROSEDUR'] . $muliplicity . '-' . $key['NAMA'];
        }

        if (count($datas2) > 0) {
            $procedurev6_sekunder = implode("#", $rows2);
        } else {
            $procedurev6_sekunder = null;
        }

        $tarif_rs = str_replace(".", "", $data['tarif_rs']);
        $nomor_registrasi = $data['nomor_registrasi'];



        // membuat json juga dapatmenggunakan json_encode:
        $ws_query["metadata"]["method"] = "set_claim_data";
        $ws_query["metadata"]["nomor_sep"] = $nomor_sep;
        $ws_query["data"]["nomor_sep"] = $nomor_sep;
        $ws_query["data"]["nomor_kartu"] =  $nomor_kartu;
        $ws_query["data"]["tgl_masuk"] =  $tgl_masuk;
        $ws_query["data"]["tgl_pulang"] =  $tgl_pulang;
        $ws_query["data"]["jenis_rawat"] =  $jenis_rawat;
        $ws_query["data"]["kelas_rawat"] =  $kelas_rawat;
        $ws_query["data"]["adl_sub_acute"] =  $adl_sub_acute;
        $ws_query["data"]["adl_chronic"] =  $adl_chronic;
        $ws_query["data"]["icu_indikator"] =  $icu_indikator;
        $ws_query["data"]["icu_los"] =  $icu_los;
        $ws_query["data"]["ventilator_hour"] =  $ventilator_hour;
        $ws_query["data"]["upgrade_class_ind"] =  $upgrade_class_ind;
        $ws_query["data"]["upgrade_class_class"] =  $upgrade_class_class;
        $ws_query["data"]["upgrade_class_los"] =  $upgrade_class_los;
        $ws_query["data"]["add_payment_pct"] =  $add_payment_pct;
        $ws_query["data"]["birth_weight"] =  $birth_weight;
        $ws_query["data"]["discharge_status"] =  $discharge_status;
        $ws_query["data"]["diagnosa"] =  $diagnosa;
        $ws_query["data"]["procedure"] =  $procedure;
        $ws_query["data"]["diagnosa_inagrouper"] =  $diagnosa_inagrouper;
        $ws_query["data"]["procedure_inagrouper"] =  $procedure_inagrouper;
        $ws_query["data"]["tarif_rs"]["prosedur_non_bedah"] = $prosedur_non_bedah;
        $ws_query["data"]["tarif_rs"]["prosedur_bedah"] = $prosedur_bedah;
        $ws_query["data"]["tarif_rs"]["konsultasi"] = $konsultasi;
        $ws_query["data"]["tarif_rs"]["tenaga_ahli"] = $tenaga_ahli;
        $ws_query["data"]["tarif_rs"]["keperawatan"] = $keperawatan;
        $ws_query["data"]["tarif_rs"]["penunjang"] = $penunjang;
        $ws_query["data"]["tarif_rs"]["radiologi"] = $radiologi;
        $ws_query["data"]["tarif_rs"]["laboratorium"] = $laboratorium;
        $ws_query["data"]["tarif_rs"]["pelayanan_darah"] = $pelayanan_darah;
        $ws_query["data"]["tarif_rs"]["rehabilitasi"] = $rehabilitasi;
        $ws_query["data"]["tarif_rs"]["kamar"] = $kamar;
        $ws_query["data"]["tarif_rs"]["rawat_intensif"] = $rawat_intensif;
        $ws_query["data"]["tarif_rs"]["obat"] = $obat;
        $ws_query["data"]["tarif_rs"]["obat_kronis"] = $obat_kronis;
        $ws_query["data"]["tarif_rs"]["obat_kemoterapi"] = $obat_kemoterapi;
        $ws_query["data"]["tarif_rs"]["alkes"] = $alkes;
        $ws_query["data"]["tarif_rs"]["bmhp"] = $bmhp;
        $ws_query["data"]["tarif_rs"]["sewa_alat"] = $sewa_alat;
        $ws_query["data"]["pemulasaraan_jenazah"] =  $pemulasaraan_jenazah;
        $ws_query["data"]["kantong_jenazah"] =  $kantong_jenazah;
        $ws_query["data"]["peti_jenazah"] =  $peti_jenazah;
        $ws_query["data"]["plastik_erat"] =  $plastik_erat;
        $ws_query["data"]["desinfektan_jenazah"] =  $desinfektan_jenazah;
        $ws_query["data"]["mobil_jenazah"] =  $mobil_jenazah;
        $ws_query["data"]["desinfektan_mobil_jenazah"] =  $desinfektan_mobil_jenazah;
        $ws_query["data"]["covid19_status_cd"] =  $covid19_status_cd;
        $ws_query["data"]["nomor_kartu_t"] =  $nomor_kartu_t;
        $ws_query["data"]["episodes"] =  $episodes;
        $ws_query["data"]["covid19_cc_ind"] =  $covid19_cc_ind;
        $ws_query["data"]["covid19_rs_darurat_ind"] =  $covid19_rs_darurat_ind;
        $ws_query["data"]["covid19_co_insidense_ind"] =  $covid19_co_insidense_ind;
        $ws_query["data"]["covid19_no_sep"] =  $covid19_no_sep;
        $ws_query["data"]["covid19_penunjang_pengurang"]["lab_asam_laktat"] = $lab_asam_laktat;
        $ws_query["data"]["covid19_penunjang_pengurang"]["lab_procalcitonin"] = $lab_procalcitonin;
        $ws_query["data"]["covid19_penunjang_pengurang"]["lab_crp"] = $lab_crp;
        $ws_query["data"]["covid19_penunjang_pengurang"]["lab_kultur"] = $lab_kultur;
        $ws_query["data"]["covid19_penunjang_pengurang"]["lab_d_dimer"] = $lab_d_dimer;
        $ws_query["data"]["covid19_penunjang_pengurang"]["lab_pt"] = $lab_pt;
        $ws_query["data"]["covid19_penunjang_pengurang"]["lab_aptt"] = $lab_aptt;
        $ws_query["data"]["covid19_penunjang_pengurang"]["lab_waktu_pendarahan"] = $lab_waktu_pendarahan;
        $ws_query["data"]["covid19_penunjang_pengurang"]["lab_anti_hiv"] = $lab_anti_hiv;
        $ws_query["data"]["covid19_penunjang_pengurang"]["lab_analisa_gas"] = $lab_analisa_gas;
        $ws_query["data"]["covid19_penunjang_pengurang"]["lab_albumin"] = $lab_albumin;
        $ws_query["data"]["covid19_penunjang_pengurang"]["rad_thorax_ap_pa"] = $rad_thorax_ap_pa;
        $ws_query["data"]["terapi_konvalesen"] =  $terapi_konvalesen;
        $ws_query["data"]["akses_naat"] =  $akses_naat;
        $ws_query["data"]["isoman_ind"] =  $isoman_ind;
        $ws_query["data"]["bayi_lahir_status_cd"] =  $bayi_lahir_status_cd;
        $ws_query["data"]["tarif_poli_eks"] =  $tarif_poli_eks;
        $ws_query["data"]["nama_dokter"] =  $nama_dokter;
        $ws_query["data"]["kode_tarif"] =  $kode_tarif;
        $ws_query["data"]["payor_id"] =  $payor_id;
        $ws_query["data"]["payor_cd"] =  $payor_cd;
        $ws_query["data"]["cob_cd"] =  $cob_cd;
        $ws_query["data"]["coder_nik"] =  $coder_nik;

        $json_request = json_encode($ws_query);
        // data yang akan dikirimkan dengan method POST adalah encrypted:

        $response =  $this->EklaimApi($json_request);
        //var_dump($response);exit;
        if ($response['metadata']['code'] == 200) {
            $TGLNOW = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;

            //INSERT KE LOG-----------
            $this->db->query("INSERT INTO DashboardData.dbo.LOG_EKLAIM (ID_EKLAIM,NO_REGISTRASI,KETERANGAN,DATE_UPDATE,USER_UPDATE) VALUES
            (:ID_EKLAIM,:NO_REGISTRASI,:KETERANGAN,:DATE_UPDATE,:USER_UPDATE)");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $this->db->bind('NO_REGISTRASI', $nomor_registrasi);
            $this->db->bind('KETERANGAN', 'Simpan');
            $this->db->bind('DATE_UPDATE', $TGLNOW);
            $this->db->bind('USER_UPDATE', $userid);
            $this->db->execute();
            //----------------

            $this->db->query("UPDATE DashboardData.dbo.EKLAIM Set 
            [TGL_MASUK] = :TGL_MASUK
            ,[TGL_PULANG] = :TGL_PULANG
            ,[JENIS_RAWAT] = :JENIS_RAWAT
            ,[NAMA_JENIS_RAWAT] = :NAMA_JENIS_RAWAT
            ,[KELAS_RAWAT] = :KELAS_RAWAT
            ,[ADL_SUB_ACUTE] = :ADL_SUB_ACUTE
            ,[ADL_CHRONIC] = :ADL_CHRONIC
            ,[ICU_INDIKATOR] = :ICU_INDIKATOR
            ,[ICU_LOS] = :ICU_LOS
            ,[VENTILATOR_HOUR] = :VENTILATOR_HOUR
            ,[UPGRADE_CLASS_IND] = :UPGRADE_CLASS_IND
            ,[UPGRADE_CLASS_CLASS] = :UPGRADE_CLASS_CLASS
            ,[UPGRADE_CLASS_LOS] = :UPGRADE_CLASS_LOS
            ,[ADD_PAYMENT_PCT] = :ADD_PAYMENT_PCT
            ,[BIRTH_WEIGHT] = :BIRTH_WEIGHT
            ,[DISCHARGE_STATUS] = :DISCHARGE_STATUS
            ,[NAMA_DISCHARGE_STATUS] = :NAMA_DISCHARGE_STATUS
            ,[TARIF_PROSEDUR_NON_BEDAH] = :TARIF_PROSEDUR_NON_BEDAH
            ,[TARIF_PROSEDUR_BEDAH] = :TARIF_PROSEDUR_BEDAH
            ,[TARIF_KONSULTASI] = :TARIF_KONSULTASI
            ,[TARIF_TENAGA_AHLI] = :TARIF_TENAGA_AHLI
            ,[TARIF_KEPERAWATAN] = :TARIF_KEPERAWATAN
            ,[TARIF_PENUNJANG] = :TARIF_PENUNJANG
            ,[TARIF_RADIOLOGI] = :TARIF_RADIOLOGI
            ,[TARIF_LABORATORIUM] = :TARIF_LABORATORIUM
            ,[TARIF_PELAYANAN_DARAH] = :TARIF_PELAYANAN_DARAH
            ,[TARIF_REHABILITASI] = :TARIF_REHABILITASI
            ,[TARIF_KAMAR] = :TARIF_KAMAR
            ,[TARIF_RAWAT_INTENSIF] = :TARIF_RAWAT_INTENSIF
            ,[TARIF_OBAT] = :TARIF_OBAT
            ,[TARIF_OBAT_KRONIS] = :TARIF_OBAT_KRONIS
            ,[TARIF_OBAT_KEMOTERAPI] = :TARIF_OBAT_KEMOTERAPI
            ,[TARIF_ALKES] = :TARIF_ALKES
            ,[TARIF_BMHP] = :TARIF_BMHP
            ,[TARIF_SEWA_ALAT] = :TARIF_SEWA_ALAT
            ,[PEMULASARAAN_JENAZAH] = :PEMULASARAAN_JENAZAH
            ,[KANTONG_JENAZAH] = :KANTONG_JENAZAH
            ,[PETI_JENAZAH] = :PETI_JENAZAH
            ,[PLASTIK_ERAT] = :PLASTIK_ERAT
            ,[DESINFEKTAN_JENAZAH] = :DESINFEKTAN_JENAZAH
            ,[MOBIL_JENAZAH] = :MOBIL_JENAZAH
            ,[DESINFEKTAN_MOBIL_JENAZAH] = :DESINFEKTAN_MOBIL_JENAZAH
            ,[COVID19_STATUS_CD] = :COVID19_STATUS_CD
            ,[NOMOR_KARTU_T] = :NOMOR_KARTU_T
            ,[EPISODES] = :EPISODES
            ,[COVID19_CC_IND] = :COVID19_CC_IND
            ,[COVID19_RS_DARURAT_IND] = :COVID19_RS_DARURAT_IND
            ,[COVID19_CO_INSIDENSE_IND] = :COVID19_CO_INSIDENSE_IND
            ,[COVID19_NO_SEP] = :COVID19_NO_SEP
            ,[LAB_ASAM_LAKTAT] = :LAB_ASAM_LAKTAT
            ,[LAB_PROCALCITONIN] = :LAB_PROCALCITONIN
            ,[LAB_CRP] = :LAB_CRP
            ,[LAB_KULTUR] = :LAB_KULTUR
            ,[LAB_D_DIMER] = :LAB_D_DIMER
            ,[LAB_PT] = :LAB_PT
            ,[LAB_APTT] = :LAB_APTT
            ,[LAB_WAKTU_PENDARAHAN] = :LAB_WAKTU_PENDARAHAN
            ,[LAB_ANTI_HIV] = :LAB_ANTI_HIV
            ,[LAB_ANALISA_GAS] = :LAB_ANALISA_GAS
            ,[LAB_ALBUMIN] = :LAB_ALBUMIN
            ,[RAD_THORAX_AP_PA] = :RAD_THORAX_AP_PA
            ,[TERAPI_KONVALESEN] = :TERAPI_KONVALESEN
            ,[AKSES_NAAT] = :AKSES_NAAT
            ,[ISOMAN_IND] = :ISOMAN_IND
            ,[BAYI_LAHIR_STATUS_CD] = :BAYI_LAHIR_STATUS_CD
            ,[TARIF_POLI_EKS] = :TARIF_POLI_EKS
            ,[NAMA_DOKTER] = :NAMA_DOKTER
            ,[KODE_TARIF] = :KODE_TARIF
            ,[PAYOR_ID] = :PAYOR_ID
            ,[PAYOR_CD] = :PAYOR_CD
            ,[COB_CD] = :COB_CD
            ,[CODER_NIK] = :CODER_NIK
            ,[DATE_UPDATE] = :DATE_UPDATE
            ,[USER_UPDATE] = :USER_UPDATE
            ,[INACBG_V5DIAG10_PRIMER] = :INACBG_V5DIAG10_PRIMER
            ,[INACBG_V5DIAG10_SEKUNDER] = :INACBG_V5DIAG10_SEKUNDER
            ,[INACBG_V5DIAG9] = :INACBG_V5DIAG9
            ,[INACBG_V6DIAG10_PRIMER] = :INACBG_V6DIAG10_PRIMER
            ,[INACBG_V6DIAG10_SEKUNDER] = :INACBG_V6DIAG10_SEKUNDER
            ,[INACBG_V6DIAG9_PRIMER] = :INACBG_V6DIAG9_PRIMER
            ,[INACBG_V6DIAG9_SEKUNDER] = :INACBG_V6DIAG9_SEKUNDER
            ,[TOTAL_TARIF_RS] = :TOTAL_TARIF_RS
            -- ,[TOTAL_TARIF_INACBG] = :TOTAL_TARIF_INACBG
            -- ,[SELISIH_CLAIM] = :SELISIH_CLAIM
            WHERE ID=:ID_EKLAIM");

            $this->db->bind('TGL_MASUK', $tgl_masuk);
            $this->db->bind('TGL_PULANG', $tgl_pulang);
            $this->db->bind('JENIS_RAWAT', $jenis_rawat);
            $this->db->bind('NAMA_JENIS_RAWAT', $nama_jenisrawat);
            $this->db->bind('KELAS_RAWAT', $kelas_rawat);
            $this->db->bind('ADL_SUB_ACUTE', $adl_sub_acute);
            $this->db->bind('ADL_CHRONIC', $adl_chronic);
            $this->db->bind('ICU_INDIKATOR', $icu_indikator);
            $this->db->bind('ICU_LOS', $icu_los);
            $this->db->bind('VENTILATOR_HOUR', $ventilator_hour);
            $this->db->bind('UPGRADE_CLASS_IND', $upgrade_class_ind);
            $this->db->bind('UPGRADE_CLASS_CLASS', $upgrade_class_class);
            $this->db->bind('UPGRADE_CLASS_LOS', $upgrade_class_los);
            $this->db->bind('ADD_PAYMENT_PCT', $add_payment_pct);
            $this->db->bind('BIRTH_WEIGHT', $birth_weight);
            $this->db->bind('DISCHARGE_STATUS', $discharge_status);
            $this->db->bind('NAMA_DISCHARGE_STATUS', $nama_dischargestatus);
            $this->db->bind('TARIF_PROSEDUR_NON_BEDAH', $prosedur_non_bedah);
            $this->db->bind('TARIF_PROSEDUR_BEDAH', $prosedur_bedah);
            $this->db->bind('TARIF_KONSULTASI', $konsultasi);
            $this->db->bind('TARIF_TENAGA_AHLI', $tenaga_ahli);
            $this->db->bind('TARIF_KEPERAWATAN', $keperawatan);
            $this->db->bind('TARIF_PENUNJANG', $penunjang);
            $this->db->bind('TARIF_RADIOLOGI', $radiologi);
            $this->db->bind('TARIF_LABORATORIUM', $laboratorium);
            $this->db->bind('TARIF_PELAYANAN_DARAH', $pelayanan_darah);
            $this->db->bind('TARIF_REHABILITASI', $rehabilitasi);
            $this->db->bind('TARIF_KAMAR', $kamar);
            $this->db->bind('TARIF_RAWAT_INTENSIF', $rawat_intensif);
            $this->db->bind('TARIF_OBAT', $obat);
            $this->db->bind('TARIF_OBAT_KRONIS', $obat_kronis);
            $this->db->bind('TARIF_OBAT_KEMOTERAPI', $obat_kemoterapi);
            $this->db->bind('TARIF_ALKES', $alkes);
            $this->db->bind('TARIF_BMHP', $bmhp);
            $this->db->bind('TARIF_SEWA_ALAT', $sewa_alat);
            $this->db->bind('PEMULASARAAN_JENAZAH', $pemulasaraan_jenazah);
            $this->db->bind('KANTONG_JENAZAH', $kantong_jenazah);
            $this->db->bind('PETI_JENAZAH', $peti_jenazah);
            $this->db->bind('PLASTIK_ERAT', $plastik_erat);
            $this->db->bind('DESINFEKTAN_JENAZAH', $desinfektan_jenazah);
            $this->db->bind('MOBIL_JENAZAH', $mobil_jenazah);
            $this->db->bind('DESINFEKTAN_MOBIL_JENAZAH', $desinfektan_mobil_jenazah);
            $this->db->bind('COVID19_STATUS_CD', $covid19_status_cd);
            $this->db->bind('NOMOR_KARTU_T', $nomor_kartu_t);
            $this->db->bind('EPISODES', $episodes);
            $this->db->bind('COVID19_CC_IND', $covid19_cc_ind);
            $this->db->bind('COVID19_RS_DARURAT_IND', $covid19_rs_darurat_ind);
            $this->db->bind('COVID19_CO_INSIDENSE_IND', $covid19_co_insidense_ind);
            $this->db->bind('COVID19_NO_SEP', $covid19_no_sep);
            $this->db->bind('LAB_ASAM_LAKTAT', $lab_asam_laktat);
            $this->db->bind('LAB_PROCALCITONIN', $lab_procalcitonin);
            $this->db->bind('LAB_CRP', $lab_crp);
            $this->db->bind('LAB_KULTUR', $lab_kultur);
            $this->db->bind('LAB_D_DIMER', $lab_d_dimer);
            $this->db->bind('LAB_PT', $lab_pt);
            $this->db->bind('LAB_APTT', $lab_aptt);
            $this->db->bind('LAB_WAKTU_PENDARAHAN', $lab_waktu_pendarahan);
            $this->db->bind('LAB_ANTI_HIV', $lab_anti_hiv);
            $this->db->bind('LAB_ANALISA_GAS', $lab_analisa_gas);
            $this->db->bind('LAB_ALBUMIN', $lab_albumin);
            $this->db->bind('RAD_THORAX_AP_PA', $rad_thorax_ap_pa);
            $this->db->bind('TERAPI_KONVALESEN', $terapi_konvalesen);
            $this->db->bind('AKSES_NAAT', $akses_naat);
            $this->db->bind('ISOMAN_IND', $isoman_ind);
            $this->db->bind('BAYI_LAHIR_STATUS_CD', $bayi_lahir_status_cd);
            $this->db->bind('TARIF_POLI_EKS', $tarif_poli_eks);
            $this->db->bind('NAMA_DOKTER', $nama_dokter);
            $this->db->bind('KODE_TARIF', $kode_tarif);
            $this->db->bind('PAYOR_ID', $payor_id);
            $this->db->bind('PAYOR_CD', $payor_cd);
            $this->db->bind('COB_CD', $cob_cd);
            $this->db->bind('CODER_NIK', $coder_nik);
            $this->db->bind('DATE_UPDATE', $TGLNOW);
            $this->db->bind('USER_UPDATE', $userid);
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);

            $this->db->bind('INACBG_V5DIAG10_PRIMER', $diagnosav5_primer);
            $this->db->bind('INACBG_V5DIAG10_SEKUNDER', $diagnosav5_sekunder);
            $this->db->bind('INACBG_V5DIAG9', $prosedurv5);
            $this->db->bind('INACBG_V6DIAG10_PRIMER', $diagnosav6_primer);
            $this->db->bind('INACBG_V6DIAG10_SEKUNDER', $diagnosav6_sekunder);
            $this->db->bind('INACBG_V6DIAG9_PRIMER', $procedurev6_primer);
            $this->db->bind('INACBG_V6DIAG9_SEKUNDER', $procedurev6_sekunder);
            $this->db->bind('TOTAL_TARIF_RS', $tarif_rs);
            // $this->db->bind('TOTAL_TARIF_INACBG',$TOTAL_TARIF_INACBG);
            // $this->db->bind('SELISIH_CLAIM',$SELISIH_CLAIM);

            $this->db->execute();
            $callback = array(
                'status' => 'success',
                'message' => 'Klaim Berhasil Disimpan !'
            );
        } else {
            $callback = array(
                'status' => 'danger',
                'message' => $response['metadata']['message']
            );
        }

        return $callback;
    }

    //GROUPER
    public function grouping_stage_1($data)
    {
        $nomor_sep = $data['nomor_sep'];
        $ID_EKLAIM = $data['ID_EKLAIM'];
        $nomor_registrasi = $data['nomor_registrasi'];
        // membuat json juga dapat menggunakan json_encode:
        $ws_query["metadata"]["method"] = "grouper";
        $ws_query["metadata"]["stage"] = "1";

        $ws_query["data"]["nomor_sep"] = $nomor_sep;

        $json_request = json_encode($ws_query);
        // data yang akan dikirimkan dengan method POST adalah encrypted:

        $response =  $this->EklaimApi($json_request);

        if ($response['metadata']['code'] == 200) {
            $TGLNOW = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $namauser = $session->name;

            $this->db->query("UPDATE DashboardData.[dbo].[EKLAIM]
                    SET  
                     [SUB_ACUTE_DESC] =:SUB_ACUTE_DESC
                    ,[SUB_ACUTE_CODE] =:SUB_ACUTE_CODE
                    ,[SUB_ACUTE_TARIF] =:SUB_ACUTE_TARIF
                    ,[CHRONIC_DESC] =:CHRONIC_DESC
                    ,[CHRONIC_CODE] =:CHRONIC_CODE
                    ,[CHRONIC_TARIF] =:CHRONIC_TARIF
                    ,[GROUP_DESC] =:GROUP_DESC   
                    ,[GROUP_CODE] =:GROUP_CODE   
                    ,[GROUP_TARIF] =:GROUP_TARIF  
                    ,[DATE_UPDATE] =:DATE_UPDATE  
                    ,[USER_UPDATE] =:USER_UPDATE   
                    ,[ADD_PAYMENT_AMT] =:ADD_PAYMENT_AMT   
                    ,[MDC_NUMBER] =:MDC_NUMBER  
                    ,[MDC_DESCRIPTION] =:MDC_DESCRIPTION  
                    ,[DRG_CODE] =:DRG_CODE  
                    ,[DRG_DESCRIPTION] =:DRG_DESCRIPTION  
                    WHERE ID=:ID_EKLAIM
                    ");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $this->db->bind('SUB_ACUTE_DESC', '-');
            $this->db->bind('SUB_ACUTE_CODE', '-');
            $this->db->bind('SUB_ACUTE_TARIF', '-');
            $this->db->bind('CHRONIC_DESC', '-');
            $this->db->bind('CHRONIC_CODE', '-');
            $this->db->bind('CHRONIC_TARIF', '-');
            $this->db->bind('GROUP_DESC', $response['response']['cbg']['description']);
            $this->db->bind('GROUP_CODE', $response['response']['cbg']['code']);
            $this->db->bind('GROUP_TARIF', isset($response['response']['cbg']['tariff']) ? $response['response']['cbg']['tariff'] : 0);
            $this->db->bind('DATE_UPDATE', $TGLNOW);
            $this->db->bind('USER_UPDATE', $userid);
            $this->db->bind('ADD_PAYMENT_AMT', isset($response['response']['add_payment_amt']) ? $response['response']['add_payment_amt'] : null);
            $this->db->bind('MDC_NUMBER', isset($response['response_inagrouper']['drg_code']) ? $response['response_inagrouper']['mdc_number'] : null);
            $this->db->bind('MDC_DESCRIPTION', isset($response['response_inagrouper']['drg_code']) ? $response['response_inagrouper']['mdc_description'] : null);
            $this->db->bind('DRG_CODE', isset($response['response_inagrouper']['drg_code']) ? $response['response_inagrouper']['mdc_number'] : null);
            $this->db->bind('DRG_DESCRIPTION', isset($response['response_inagrouper']['drg_code']) ? $response['response_inagrouper']['drg_description'] : null);
            $this->db->execute();

            $this->db->query("SELECT 
                    CASE WHEN KODE_TARIF='BS' THEN 'KELAS B' ELSE '-' END AS KELAS_RS,
                    'TARIF RS KELAS B SWASTA' AS TARIF_RS,
                    CASE WHEN JENIS_RAWAT='2' THEN 'RAWAT JALAN'
                    WHEN JENIS_RAWAT='1' THEN 'RAWAT INAP'
                    ELSE 'IGD'
                    END AS JENIS_RAWAT_DESC
                    ,
                    CASE WHEN JENIS_RAWAT='2' AND KELAS_RAWAT='3' Then 'Regular' 
                    when JENIS_RAWAT='2' AND KELAS_RAWAT='1' Then 'Eksekutif' 
                    ELSE KELAS_RAWAT 
                    END AS JENIS_RAWAT_DESC2
                    FROM DashboardData.dbo.EKLAIM WHERE ID=:ID_EKLAIM
                    ");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $key =  $this->db->single();
            $KELAS_RS = $key['KELAS_RS'];
            $TARIF_RS = $key['TARIF_RS'];
            $JENIS_RAWAT = $key['JENIS_RAWAT_DESC'];
            $JENIS_RAWAT_DESC = $key['JENIS_RAWAT_DESC2'];

            $response2['NAMAUSER'] = $namauser;
            $response2['DATETIME'] = date('d M Y H:i', strtotime($TGLNOW));
            $response2['KELAS_RS'] = $KELAS_RS;
            $response2['TARIF_RS'] = $TARIF_RS;
            $response2['JENIS_RAWAT'] = $JENIS_RAWAT;
            $response2['JENIS_RAWAT_DESC'] = $JENIS_RAWAT_DESC;
            $dataresponse[] = $response2;

            //INSERT KE LOG-----------
            $this->db->query("INSERT INTO DashboardData.dbo.LOG_EKLAIM (ID_EKLAIM,NO_REGISTRASI,KETERANGAN,DATE_UPDATE,USER_UPDATE) VALUES
            (:ID_EKLAIM,:NO_REGISTRASI,:KETERANGAN,:DATE_UPDATE,:USER_UPDATE)");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $this->db->bind('NO_REGISTRASI', $nomor_registrasi);
            $this->db->bind('KETERANGAN', 'Grouper Stage 1');
            $this->db->bind('DATE_UPDATE', $TGLNOW);
            $this->db->bind('USER_UPDATE', $userid);
            $this->db->execute();
            //----------------


            $callback = array(
                'status' => 'success',
                'message' => 'Generate Grouper Berhasil !',
                'data_api' => $response,
                'data_local' => $dataresponse,
                //'ID_EKLAIM' => $getID,
            );
        } else {
            $callback = array(
                'status' => 'danger',
                'message' => $response['metadata']['message']
            );
        }
        // return $response;
        return $callback;
    }
    public function grouping_stage_2($data)
    {
        $nomor_sep = $data['nomor_sep'];
        $ID_EKLAIM = $data['ID_EKLAIM'];
        $nomor_registrasi = $data['nomor_registrasi'];
        //$special_cmg = $data['special_cmg'];

        $passing['sp_procedure'] = $data['sp_procedure'];
        $passing['sp_prosthesis'] = $data['sp_prosthesis'];
        $passing['sp_investigation'] = $data['sp_investigation'];
        $passing['sp_drug'] = $data['sp_drug'];

        $dataarray[] = $passing;

        foreach ($dataarray as $d) {
            $special_cmg = implode("#", array_filter($d));
        }

        // membuat json juga dapat menggunakan json_encode:
        $ws_query["metadata"]["method"] = "grouper";
        $ws_query["metadata"]["stage"] = "2";

        $ws_query["data"]["nomor_sep"] = $nomor_sep;
        $ws_query["data"]["special_cmg"] = $special_cmg;

        $json_request = json_encode($ws_query);
        // data yang akan dikirimkan dengan method POST adalah encrypted:

        $response =  $this->EklaimApi($json_request);

        if ($response['metadata']['code'] == 200) {
            $TGLNOW = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $namauser = $session->name;

            $sp_procedure_code = null;
            $sp_procedure_desc = null;
            $sp_procedure_tarif = null;
            $sp_prothesis_code = null;
            $sp_prothesis_desc = null;
            $sp_prothesis_tarif = null;
            $sp_investigation_code = null;
            $sp_investigation_desc = null;
            $sp_investigation_tarif = null;
            $sp_drug_code = null;
            $sp_drug_desc = null;
            $sp_drug_tarif = null;

            if (isset($response['response']['special_cmg'])) {
                foreach ($response['response']['special_cmg'] as $key) {
                    if ($key['type'] == 'Special Procedure') {
                        $sp_procedure_code = $key['code'];
                        $sp_procedure_desc = $key['description'];
                        $sp_procedure_tarif = $key['tariff'];
                    } elseif ($key['type'] == 'Special Prosthesis') {
                        $sp_prothesis_code = $key['code'];
                        $sp_prothesis_desc = $key['description'];
                        $sp_prothesis_tarif = $key['tariff'];
                    } elseif ($key['type'] == 'Special Investigation') {
                        $sp_investigation_code = $key['code'];
                        $sp_investigation_desc = $key['description'];
                        $sp_investigation_tarif = $key['tariff'];
                    } elseif ($key['type'] == 'Special Drug') {
                        $sp_drug_code = $key['code'];
                        $sp_drug_desc = $key['description'];
                        $sp_drug_tarif = $key['tariff'];
                    }
                }
            }


            $this->db->query("UPDATE DashboardData.[dbo].[EKLAIM]
                    SET
                    [SP_PROCEDURE_DESC] =:SP_PROCEDURE_DESC
                    ,[SP_PROCEDURE_CODE] =:SP_PROCEDURE_CODE
                    ,[SP_PROCEDURE_TARIF] =:SP_PROCEDURE_TARIF
                    ,[SP_PROSTHESIS_DESC] =:SP_PROSTHESIS_DESC
                    ,[SP_PROSTHESIS_CODE] =:SP_PROSTHESIS_CODE
                    ,[SP_PROSTHESIS_TARIF] =:SP_PROSTHESIS_TARIF
                    ,[SP_INVESTIGATION_DESC] =:SP_INVESTIGATION_DESC
                    ,[SP_INVESTIGATION_CODE] =:SP_INVESTIGATION_CODE
                    ,[SP_INVESTIGATION_TARIF] =:SP_INVESTIGATION_TARIF
                    ,[SP_DRUG_DESC] =:SP_DRUG_DESC
                    ,[SP_DRUG_CODE] =:SP_DRUG_CODE
                    ,[SP_DRUG_TARIF] =:SP_DRUG_TARIF
                    ,[DATE_UPDATE] =:DATE_UPDATE
                    ,[USER_UPDATE] =:USER_UPDATE
                    ,[MDC_NUMBER] =:MDC_NUMBER  
                    ,[MDC_DESCRIPTION] =:MDC_DESCRIPTION  
                    ,[DRG_CODE] =:DRG_CODE  
                    ,[DRG_DESCRIPTION] =:DRG_DESCRIPTION 
                    WHERE ID=:ID_EKLAIM
                    ");

            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $this->db->bind('SP_PROCEDURE_CODE', $sp_procedure_code);
            $this->db->bind('SP_PROCEDURE_DESC', $sp_procedure_desc);
            $this->db->bind('SP_PROCEDURE_TARIF', $sp_procedure_tarif);
            $this->db->bind('SP_PROSTHESIS_DESC', $sp_prothesis_desc);
            $this->db->bind('SP_PROSTHESIS_CODE', $sp_prothesis_code);
            $this->db->bind('SP_PROSTHESIS_TARIF', $sp_prothesis_tarif);
            $this->db->bind('SP_INVESTIGATION_DESC', $sp_investigation_desc);
            $this->db->bind('SP_INVESTIGATION_CODE', $sp_investigation_code);
            $this->db->bind('SP_INVESTIGATION_TARIF', $sp_investigation_tarif);
            $this->db->bind('SP_DRUG_DESC', $sp_drug_desc);
            $this->db->bind('SP_DRUG_CODE', $sp_drug_code);
            $this->db->bind('SP_DRUG_TARIF', $sp_drug_tarif);
            $this->db->bind('DATE_UPDATE', $TGLNOW);
            $this->db->bind('USER_UPDATE', $userid);
            $this->db->bind('MDC_NUMBER', isset($response['response_inagrouper']['drg_code']) ? $response['response_inagrouper']['mdc_number'] : null);
            $this->db->bind('MDC_DESCRIPTION', isset($response['response_inagrouper']['drg_code']) ? $response['response_inagrouper']['mdc_description'] : null);
            $this->db->bind('DRG_CODE', isset($response['response_inagrouper']['drg_code']) ? $response['response_inagrouper']['mdc_number'] : null);
            $this->db->bind('DRG_DESCRIPTION', isset($response['response_inagrouper']['drg_code']) ? $response['response_inagrouper']['drg_description'] : null);
            $this->db->execute();

            //INSERT KE LOG-----------
            $this->db->query("INSERT INTO DashboardData.dbo.LOG_EKLAIM (ID_EKLAIM,NO_REGISTRASI,KETERANGAN,DATE_UPDATE,USER_UPDATE) VALUES
            (:ID_EKLAIM,:NO_REGISTRASI,:KETERANGAN,:DATE_UPDATE,:USER_UPDATE)");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $this->db->bind('NO_REGISTRASI', $nomor_registrasi);
            $this->db->bind('KETERANGAN', 'Grouper Stage 2');
            $this->db->bind('DATE_UPDATE', $TGLNOW);
            $this->db->bind('USER_UPDATE', $userid);
            $this->db->execute();
            //----------------


            $callback = array(
                'status' => 'success',
                'message' => 'Generate Grouper Stage 2 Berhasil !',
                'data_api' => $response,
                //'data_local' => $dataresponse,
            );
        } else {
            $callback = array(
                'status' => 'danger',
                'message' => $response['metadata']['message'],
                'data_api' => $response,
            );
        }
        // return $response;
        return $callback;
    }

    public function claim_final($data){
        
        try {
            $this->db->transaksi();
            $tgl_pulang = $data['tgl_pulang'];
            $nama_pasien = $data['nama_pasien'];
        $nomor_sep = $data['nomor_sep'];
        $nomor_rm = $data['nomor_rm'];
        $nomor_registrasi = $data['nomor_registrasi'];
        $ID_EKLAIM = $data['ID_EKLAIM'];
        $total_grouper_input = $data['total_grouper_input'];
        $tarif_rs = str_replace(".", "", $data['tarif_rs']);
        $selisih_claim = $total_grouper_input - $tarif_rs;
        $selisih_claim_convert = str_replace("-","",$selisih_claim);
        $insert_payment = $tarif_rs - $selisih_claim_convert;
        if ($insert_payment >= 0){
            $insert_payment_convert = $insert_payment;
        }else{
            $insert_payment_convert = $tarif_rs;
        }
        $total_insert = $insert_payment + $selisih_claim_convert;

        // //CEK JIKA BILL SUDAH DICLOSE
        // $getreg = substr($data['nomor_registrasi'],0,2);
        // if ($getreg == 'RJ'){
        //     //GET status 
        //  $this->db->query("SELECT [Status ID] as statusid,PatientType as TypePatientID,NoEpisode,Perusahaan as IDJaminan from PerawatanSQL.dbo.Visit WHERE NoRegistrasi=:nomor_registrasi");
        //  $this->db->bind('nomor_registrasi', $data['nomor_registrasi']);
        //  $datas =  $this->db->single();
        //  $TypePatientID = $datas['TypePatientID'];
        //  $NoEpisode = $datas['NoEpisode'];
        //  $IDJaminan = $datas['IDJaminan'];

        //  if ($datas['statusid'] == '4'){
        //      $callback = array(
        //          'status' => 'warning',
        //          'errorname' => 'Billing Sudah Diclose ! Mohon Dibuka Untuk Proses Eklaim !',
        //      );
        //      echo json_encode($callback);
        //      exit;
        //  }
        // }else{
        //     $NoEpisode = null;
        // //GET status 
        //  $this->db->query("SELECT [StatusID] as statusid,TypePatient as TypePatientID,IDJPK as IDJaminan 
        //  from RawatInapSQL.dbo.Inpatient WHERE NoRegRI=:nomor_registrasi");
        //  $this->db->bind('nomor_registrasi', $data['nomor_registrasi']);
        //  $datas =  $this->db->single();
        //  $TypePatientID = $datas['TypePatientID'];
        //  $IDJaminan = $datas['IDJaminan'];

        //  if ($datas['statusid'] == '4'){
        //      $callback = array(
        //          'status' => 'warning',
        //          'errorname' => 'Billing Sudah Diclose ! Mohon Dibuka Untuk Proses Eklaim !',
        //      );
        //      echo json_encode($callback);
        //      exit;
        //  }
        // }

        //  $getreg = substr($nomor_registrasi,0,2);
        //      if ($getreg == 'RJ'){
        //         $this->db->query("SELECT ID as idpayment,Lock_Finance,NoKwitansi as nokwitansi FROM PerawatanSQL.dbo.payments  WHERE NoRegistrasi=:noreg AND Descripton='Selisih Bridging Eklaim'
        //         ");
        //         $this->db->bind('noreg', $nomor_registrasi); 
        //         $datas =  $this->db->single();
        //         $idpayment = $datas['idpayment'];
        //         $Lock_Finance = $datas['Lock_Finance'];
        //         $nokwitansi = $datas['nokwitansi'];
        //      }else{
        //         $this->db->query("SELECT Id as idpayment,Lock_Finance,NoKwitansi as nokwitansi FROM RawatInapSQL.dbo.Deposit  WHERE NoRegistrasi=:noreg AND Keterangan='Selisih Bridging Eklaim'
        //         ");
        //         $this->db->bind('noreg', $nomor_registrasi); 
        //         $datas =  $this->db->single();
        //         $idpayment = $datas['idpayment'];
        //         $Lock_Finance = $datas['Lock_Finance'];
        //         $nokwitansi = $datas['nokwitansi'];
        //      }

        //      //CEK JIKA SUDAH DITAGIHKAN
        //      $this->db->query("SELECT FB_TAGIH FROM  Keuangan.dbo.PIUTANG_PASIEN  WHERE PAYMENT_NO=:idpayment AND Fs_KET2=:nomor_registrasi
        //      ");
        //      $this->db->bind('idpayment', $idpayment); 
        //      $this->db->bind('nomor_registrasi', $nomor_registrasi); 
        //      $key =  $this->db->single();

        //      $FB_TAGIH = $key['FB_TAGIH']; 
        //      if ($FB_TAGIH == '1'){
        //         $callback = array(
        //             'status' => 'warning',
        //             'errorname' => 'Piutang Sudah Ditagihkan !',
        //         );
        //         echo json_encode($callback);
        //         exit;
        //      }
             
        //      if ($Lock_Finance == '1'){
        //         $callback = array(
        //             'status' => 'warning',
        //             'errorname' => 'Payment Sudah Dilock Oleh Bagian Keuangan! Silahkan Konfirmasi ke Bagian Keuangan!',
        //         );
        //         echo json_encode($callback);
        //         exit;
        //      }

        //      if ($getreg == 'RJ'){
        //         $this->db->query("SELECT ID as idpayment,Lock_Finance,NoKwitansi as nokwitansi FROM PerawatanSQL.dbo.payments  WHERE NoRegistrasi=:noreg AND Descripton='Selisih Bridging Eklaim'
        //         ");
        //         $this->db->bind('noreg', $nomor_registrasi); 
        //         $datas =  $this->db->single();
        //         $idpayment = $datas['idpayment'];
        //         $Lock_Finance = $datas['Lock_Finance'];
        //         $nokwitansi = $datas['nokwitansi'];
        //      }else{
        //         $this->db->query("SELECT Id as idpayment,Lock_Finance,NoKwitansi as nokwitansi FROM RawatInapSQL.dbo.Deposit  WHERE NoRegistrasi=:noreg AND Keterangan='Selisih Bridging Eklaim'
        //         ");
        //         $this->db->bind('noreg', $nomor_registrasi); 
        //         $datas =  $this->db->single();
        //         $idpayment = $datas['idpayment'];
        //         $Lock_Finance = $datas['Lock_Finance'];
        //         $nokwitansi = $datas['nokwitansi'];
        //      }

        //      //CEK JIKA SUDAH DITAGIHKAN
        //      $this->db->query("SELECT FB_TAGIH FROM  Keuangan.dbo.PIUTANG_PASIEN  WHERE PAYMENT_NO=:idpayment AND Fs_KET2=:nomor_registrasi
        //      ");
        //      $this->db->bind('idpayment', $idpayment); 
        //      $this->db->bind('nomor_registrasi', $nomor_registrasi); 
        //      $key =  $this->db->single();

        //      $FB_TAGIH = $key['FB_TAGIH']; 
        //      if ($FB_TAGIH == '1'){
        //         $callback = array(
        //             'status' => 'warning',
        //             'errorname' => 'Piutang Sudah Ditagihkan !',
        //         );
        //         echo json_encode($callback);
        //         exit;
        //      }
             
        //      if ($Lock_Finance == '1'){
        //         $callback = array(
        //             'status' => 'warning',
        //             'errorname' => 'Payment Sudah Dilock Oleh Bagian Keuangan! Silahkan Konfirmasi ke Bagian Keuangan!',
        //         );
        //         echo json_encode($callback);
        //         exit;
        //      }

        //$coder_nik = $data['coder_nik'];
        $coder_nik = $this->getcoderNIK();
        // membuat json juga dapat menggunakan json_encode:
        $ws_query["metadata"]["method"] = "claim_final";

        $ws_query["data"]["nomor_sep"] = $nomor_sep;
        $ws_query["data"]["coder_nik"] = $coder_nik;

        $json_request = json_encode($ws_query);
        // data yang akan dikirimkan dengan method POST adalah encrypted:

        $response =  $this->EklaimApi($json_request);

        if ($response['metadata']['code'] == 200) {
            $TGLNOW = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $namauser = $session->name;

            $this->db->query("UPDATE DashboardData.[dbo].[EKLAIM]
                    SET
                    [FINAL_KLAIM] =:FINAL_KLAIM,
                    [TOTAL_TARIF_RS] = :tarif_rs,
                    [TOTAL_TARIF_INACBG] = :total_grouper_input,
                    [SELISIH_CLAIM] = :selisih_claim
                    WHERE ID=:ID_EKLAIM
                    ");

            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $this->db->bind('FINAL_KLAIM', '1');
            $this->db->bind('tarif_rs', $tarif_rs);
            $this->db->bind('selisih_claim', $selisih_claim);
            $this->db->bind('total_grouper_input', $total_grouper_input);
            $this->db->execute();

            //INSERT KE LOG-----------
            $this->db->query("INSERT INTO DashboardData.dbo.LOG_EKLAIM (ID_EKLAIM,NO_REGISTRASI,KETERANGAN,DATE_UPDATE,USER_UPDATE) VALUES
            (:ID_EKLAIM,:NO_REGISTRASI,:KETERANGAN,:DATE_UPDATE,:USER_UPDATE)");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $this->db->bind('NO_REGISTRASI', $nomor_registrasi);
            $this->db->bind('KETERANGAN', 'Final Klaim');
            $this->db->bind('DATE_UPDATE', $TGLNOW);
            $this->db->bind('USER_UPDATE', $userid);
            $this->db->execute();
            //----------------

            // //DELETE YANG SUDAH ADA--------
            // //$this->Delete_PaymentbyReg($nomor_registrasi);
            // //DELETE YANG SUDAH ADA--------
            // if ($getreg == 'RJ'){
            //     //DELETE JURNAL
            //     $this->db->query("DELETE Keuangan.dbo.TA_JURNAL_HDR WHERE FS_KD_JURNAL collate Latin1_General_CI_AS in (SELECT NoKwitansi FROM PerawatanSQL.dbo.payments WHERE NoRegistrasi=:nomor_registrasi)");
            //     $this->db->bind('nomor_registrasi', $nomor_registrasi);
            //     $this->db->execute();

            //     $this->db->query("DELETE Keuangan.dbo.TA_JURNAL_DTL WHERE FS_KD_JURNAL collate Latin1_General_CI_AS in (SELECT NoKwitansi FROM PerawatanSQL.dbo.payments WHERE NoRegistrasi=:nomor_registrasi)");
            //     $this->db->bind('nomor_registrasi', $nomor_registrasi);
            //     $this->db->execute();

            //     $this->db->query("DELETE PerawatanSQL.dbo.PaymentDetails WHERE PaymentID IN (SELECT Id FROM PerawatanSQL.dbo.payments WHERE NoRegistrasi=:nomor_registrasi)");
            //     $this->db->bind('nomor_registrasi', $nomor_registrasi);
            //     $this->db->execute();

            //     $this->db->query("DELETE PerawatanSQL.dbo.payments WHERE NoRegistrasi=:nomor_registrasi");
            //     $this->db->bind('nomor_registrasi', $nomor_registrasi);
            //     $this->db->execute();

                
            //  }else{
            //     //DELETE JURNAL
            //     $this->db->query("DELETE Keuangan.dbo.TA_JURNAL_HDR WHERE FS_KD_JURNAL collate Latin1_General_CI_AS in (SELECT NoKwitansi FROM RawatInapSQL.dbo.Deposit WHERE NoRegistrasi=:nomor_registrasi)");
            //     $this->db->bind('nomor_registrasi', $nomor_registrasi);
            //     $this->db->execute();

            //     $this->db->query("DELETE Keuangan.dbo.TA_JURNAL_DTL WHERE FS_KD_JURNAL collate Latin1_General_CI_AS in (SELECT NoKwitansi FROM RawatInapSQL.dbo.Deposit WHERE NoRegistrasi=:nomor_registrasi)");
            //     $this->db->bind('nomor_registrasi', $nomor_registrasi);
            //     $this->db->execute();

            //     $this->db->query("DELETE RawatInapSQL.dbo.DepositDetails WHERE IDDeposit IN (SELECT IDDeposit FROM RawatInapSQL.dbo.Deposit WHERE NoRegistrasi=:nomor_registrasi)");
            //     $this->db->bind('nomor_registrasi', $nomor_registrasi);
            //     $this->db->execute();

            //     $this->db->query("DELETE RawatInapSQL.dbo.Deposit WHERE NoRegistrasi=:nomor_registrasi");
            //     $this->db->bind('nomor_registrasi', $nomor_registrasi);
            //     $this->db->execute();
                
            //  }

            //  //VOID PIUTANG
            //  $this->db->query("UPDATE Keuangan.dbo.PIUTANG_PASIEN SET FB_BATAL='1' WHERE  Fs_KET2=:nomor_registrasi");
            //  $this->db->bind('nomor_registrasi', $nomor_registrasi);
            //  $this->db->execute();
            //  //#END DELETE----------------

            // //INSERT KE TABEL PAYMENT/DEPOSIT
            // $datenowcreate= Utils::seCurrentDateTime();
            // $datenowcreate2= Utils::datenowcreateNotFull();
            // $session = SessionManager::getCurrentSession();
            // $namauserx = $session->name;
            // $IDEmployee = $session->IDEmployee;
            // $tipepembayaran = 'Piutang Perusahaan';
            // if ($selisih_claim <= 0) {
            //     //jika selisih
            //     $IDJaminan = '492';
            //     $Ket_Ref = 'Selisih Klaim';
            // }else{
            //     //jika surplus
            //     $IDJaminan = '601';
            //     $Ket_Ref = 'Surplus Klaim';
            // }

            // $this->db->query("SELECT  ID,NamaPerusahaan,Gen_BP,Rekening from MasterdataSQL.dbo.MstrPerusahaanJPK 
            // where ID=:IDJaminan");
            //    $this->db->bind('IDJaminan',   $IDJaminan);
            //    $data2 =  $this->db->single();
            //    $Gen_BP = $data2['Gen_BP'];
            //    $Rekening = $data2['Rekening'];
            //    $NamaPerusahaan = $data2['NamaPerusahaan'];
            //    $tipejaminan = 'Perusahaan';
            
            // if ($getreg == 'RJ'){
            //     $jenis_reg = 'RAJAL ';
            //     $jenis_reg_cd = 'RJ';
            // //GENERATE NO KWITANSI
            // //untuk kode awal no NoKwitansi
            // if ($TypePatientID == "1"){
            //      $kodeawal = "KUJ";
            // }else{
            //      $kodeawal = "PRJ";
            // }
            // // $kodetengah = date('dmy');//untuk kode tengah no NoKwitansi
            // $kodetengah = date('dmy', strtotime($datenowcreate));

            // //cek no urut kwitansi

            // //GET URUT
            // $this->db->query("SELECT  TOP 1 NoKwitansi,right(NoKwitansi,4) as urutkwitansi
            // FROM PerawatanSQL.dbo.payments
            // WHERE replace(CONVERT(VARCHAR(11), Paymentdate, 111), '/','-')=:tgl_payment AND LEFT(NoKwitansi,3)=:kodeawal ORDER BY Id DESC");
            // $this->db->bind('tgl_payment',   $datenowcreate2);
            // $this->db->bind('kodeawal',   $kodeawal);
            // $data =  $this->db->single();
            // $nourutkwitansi = $data['urutkwitansi'];

            // if (empty($nourutkwitansi)){
            //     //jika gk ada record
            //     $nourutkwitansi = "0001";
            // }else{
            // //jika ada record
            //      $nourutkwitansi++;
            // }

            //     if(strlen($nourutkwitansi)==1)
            //     {
            //         $nourutfixKwitansi = "000".$nourutkwitansi;
            //     }else if(strlen($nourutkwitansi)==2)
            //     {
            //         $nourutfixKwitansi = "00".$nourutkwitansi;
            //     }else if(strlen($nourutkwitansi)==3)
            //     {
            //         $nourutfixKwitansi = "0".$nourutkwitansi;
            //     }else if(strlen($nourutkwitansi)==4)
            //     {
            //         $nourutfixKwitansi = $nourutkwitansi;
            //     }

            //     $nofinalkwitansi = $kodeawal.'-'.$kodetengah.'-'.$nourutfixKwitansi;
                

            //     //INSERT-----------
            //     $this->db->query(" INSERT INTO PerawatanSQL.dbo.payments (NoKwitansi,NoEpisode,NoRegistrasi,TotalPaid,Ammount,Kasir,Descripton,Billto,Paymentdate,Id_Kasir) VALUES
            //     (:nofinalkwitansi,:noepisode,:noreg,:terimapembayaran,:grandtotal,:user_id,:keterangan_payment,:billtox,:tgl_payment,:operator)");
            //     $this->db->bind('nofinalkwitansi', $nofinalkwitansi);
            //     $this->db->bind('noepisode', $NoEpisode);
            //     $this->db->bind('noreg', $nomor_registrasi);
            //     $this->db->bind('terimapembayaran', $total_insert);
            //     $this->db->bind('grandtotal', $total_insert);
            //     $this->db->bind('grandtotal', $total_insert);
            //     $this->db->bind('user_id', $namauserx);
            //     $this->db->bind('keterangan_payment', 'Selisih Bridging Eklaim');
            //     $this->db->bind('billtox', $NamaPerusahaan);
            //     $this->db->bind('tgl_payment', $datenowcreate2);
            //     $this->db->bind('operator', $IDEmployee);
            //     $this->db->execute();
            //     $getID = $this->db->GetLastID();
            //     //----------------

            //     //INSERT DTL-----------
            //     $this->db->query("INSERT INTO PerawatanSQL.dbo.PaymentDetails (PaymentID,NoRegistrasi,TipePembayaran,PayCash,TotalPaid,Tgl) VALUES
            //     (:idkwitansi,:noreg,:tipepembayaran,'0.02',:totalinput,:datetime_payment)");
            //     $this->db->bind('idkwitansi', $getID);
            //     $this->db->bind('noreg', $nomor_registrasi);
            //     $this->db->bind('tipepembayaran', $tipepembayaran);
            //     $this->db->bind('totalinput', $insert_payment_convert);
            //     $this->db->bind('datetime_payment', $datenowcreate);
            //     $this->db->execute();
            //     //----------------

            //      //INSERT DTL 2-----------
            //      $this->db->query("INSERT INTO PerawatanSQL.dbo.PaymentDetails (PaymentID,NoRegistrasi,TipePembayaran,PayCash,TotalPaid,Tgl) VALUES
            //      (:idkwitansi,:noreg,:tipepembayaran,'0.02',:totalinput,:datetime_payment)");
            //      $this->db->bind('idkwitansi', $getID);
            //      $this->db->bind('noreg', $nomor_registrasi);
            //      $this->db->bind('tipepembayaran', $Ket_Ref);
            //      $this->db->bind('totalinput', $selisih_claim_convert);
            //      $this->db->bind('datetime_payment', $datenowcreate);
            //      $this->db->execute();
            //      //----------------

            // }else{
            //     $kodeawal = 'KUI';
            //     $kodetengah = Date('dmy',strtotime($datenowcreate));
            //     $jenis_reg = 'RANAP ';
            //     $jenis_reg_cd = 'RI';

            //     //GET URUT
            //     $this->db->query("SELECT  TOP 1 NoKwitansi,right(NoKwitansi,4) as urutkwitansi
            //     FROM RawatInapSQL.dbo.Deposit
            //     WHERE replace(CONVERT(VARCHAR(11), Paymentdate, 111), '/','-')=:tgl_payment ORDER BY Id DESC");
            //     $this->db->bind('tgl_payment',   $datenowcreate2);
            //     $data2 =  $this->db->single();
            //     $nourutkwitansi = $data2['urutkwitansi'];
            //     if (empty($nourutkwitansi)){
            //       //jika gk ada record
            //       $nourutkwitansi = "0001";
            //       }else{
            //       //jika ada record
            //       $nourutkwitansi++;
            //       }

            //     if(strlen($nourutkwitansi)==1)
            //     {
            //         $nourutfixKwitansi = "000".$nourutkwitansi;
            //     }else if(strlen($nourutkwitansi)==2)
            //     {
            //         $nourutfixKwitansi = "00".$nourutkwitansi;
            //     }else if(strlen($nourutkwitansi)==3)
            //     {
            //         $nourutfixKwitansi = "0".$nourutkwitansi;
            //     }else if(strlen($nourutkwitansi)==4)
            //     {
            //         $nourutfixKwitansi = $nourutkwitansi;
            //     }

            //     $nofinalkwitansi = $kodeawal.$kodetengah.$nourutfixKwitansi;

            //     //INSERT-----------
            //     $this->db->query(" INSERT INTO RawatInapSQL.dbo.deposit (NoMR,NoRegistrasi,Paymentdate,Ammount,Kasir,Billto,Keterangan,JamTransaksi,NoKwitansi,Id_Kasir) VALUES
            //     (:nomr,:noreg,:datetime_payment,:terimapembayaran,:user_id,:billto,:untuk_pembayaran,:datenowall,:nofinalkwitansi,:operator)");
            //     $this->db->bind('nomr', $nomor_rm);
            //     $this->db->bind('noreg', $nomor_registrasi);
            //     $this->db->bind('datetime_payment', $datenowcreate);
            //     $this->db->bind('terimapembayaran', $total_insert);
            //     $this->db->bind('user_id', $namauserx);
            //     $this->db->bind('billto', $NamaPerusahaan);
            //     $this->db->bind('untuk_pembayaran', 'Selisih Bridging Eklaim');
            //     $this->db->bind('datenowall', $datenowcreate);
            //     $this->db->bind('nofinalkwitansi', $nofinalkwitansi);
            //     $this->db->bind('operator', $IDEmployee);
            //     $this->db->execute();
                
            //     $this->db->query("SELECT  TOP 1 Id
            //     FROM RawatInapSQL.dbo.Deposit
            //     WHERE NoRegistrasi=:nomor_registrasi ORDER BY Id DESC");
            //     $this->db->bind('nomor_registrasi',   $nomor_registrasi);
            //     $data2 =  $this->db->single();
            //     $getID = $data2['Id'];
            //     //----------------

            //     //INSERT DTL-----------
            //     $this->db->query("INSERT INTO RawatInapSQL.dbo.DepositDetails (IDDeposit,TipePembayaran,Totalbayar,TotalPlusCharge,InputDate) VALUES
            //     (:idkwitansi,:tipepembayaran,:totalinput,:totalinput2,:datetime_payment)");
            //     $this->db->bind('idkwitansi', $getID);
            //     $this->db->bind('tipepembayaran', $tipepembayaran);
            //     $this->db->bind('totalinput', $insert_payment_convert);
            //     $this->db->bind('totalinput2', $insert_payment_convert);
            //     $this->db->bind('datetime_payment', $datenowcreate);
            //     $this->db->execute();
            //     //----------------

            //     //INSERT DTL 2-----------
            //     $this->db->query("INSERT INTO RawatInapSQL.dbo.DepositDetails (IDDeposit,TipePembayaran,Totalbayar,TotalPlusCharge,InputDate) VALUES
            //     (:idkwitansi,:tipepembayaran,:totalinput,:totalinput2,:datetime_payment)");
            //     $this->db->bind('idkwitansi', $getID);
            //     $this->db->bind('tipepembayaran', $Ket_Ref);
            //     $this->db->bind('totalinput', $selisih_claim_convert);
            //     $this->db->bind('totalinput2', $selisih_claim_convert);
            //     $this->db->bind('datetime_payment', $datenowcreate);
            //     $this->db->execute();
            //     //----------------
            // }
           


            // //INSERT JURNAL
            //  $ket_jur = 'Piutang Pasien:'.$nama_pasien.' Tanggal:'.$tgl_pulang;
            //  //INSERT-----------
            //  $this->db->query("INSERT INTO Keuangan.dbo.TA_JURNAL_HDR (FS_KD_JURNAL,FD_TGL_JURNAL,FN_DEBET,FN_KREDIT,FN_JURNAL,FS_KD_PETUGAS,FS_KET,FS_KET2,FB_SELESAI) VALUES
            //  (:NoKwitansi,:datetime_payment,:terimapembayaran,:terimapembayaran2,:terimapembayaran3,:user_nopin,:ket_jur,:idkwitansi,'1')");
            //  $this->db->bind('NoKwitansi', $nofinalkwitansi);
            //  $this->db->bind('datetime_payment', $datenowcreate);
            //  $this->db->bind('terimapembayaran', $total_insert);
            //  $this->db->bind('terimapembayaran2', $total_insert);
            //  $this->db->bind('terimapembayaran3', $total_insert);
            //  $this->db->bind('user_nopin', $userid);
            //  $this->db->bind('ket_jur', $ket_jur);
            //  $this->db->bind('idkwitansi', $getID);
            //  $this->db->execute();

            //  $ledger = '0';
            //  //INSERT-----------
            //  $fs_ket_reff = $jenis_reg.$tipepembayaran;
            //  $this->db->query("INSERT INTO Keuangan.dbo.TA_JURNAL_DTL (FS_KD_JURNAL,FS_KET_REFF,FN_DEBET,FN_KREDIT,FB_VOID,FS_REK,FS_KD_REFF,FS_KD_REG,FS_KD_UNIT,FB_UNIT_USAHA,FB_LEDGER,BP_TIPE,BP_SOURCE_TRS,FS_KD_REF_OUT) VALUES
            //  (:NoKwitansi,:fs_ket_reff,:totalinput,'0','0',:kd_rekening,:idkwitansi,:noreg,'','0',:ledger,'','',:idkwitansi2)");
            //  $this->db->bind('NoKwitansi', $nofinalkwitansi);
            //  $this->db->bind('fs_ket_reff', $fs_ket_reff);
            //  $this->db->bind('totalinput', $selisih_claim_convert);
            //  $this->db->bind('kd_rekening', $Rekening);
            //  $this->db->bind('idkwitansi', $getID);
            //  $this->db->bind('noreg', $nomor_registrasi);
            //  $this->db->bind('ledger', $ledger);
            //  $this->db->bind('idkwitansi2', $getID);
            //  $this->db->execute();

            //  $ledger = '1';
            //  //INSERT JURNAL DTL
            //  $fs_ket_reff_kredit = $jenis_reg.'PIUTANG DALAM PERAWATAN';
            //  //INSERT-----------
            //  $this->db->query("INSERT INTO Keuangan.dbo.TA_JURNAL_DTL (FS_KD_JURNAL,FS_KET_REFF,FN_DEBET,FN_KREDIT,FB_VOID,FS_REK,FS_KD_REFF,FS_KD_REG,FS_KD_UNIT,FB_UNIT_USAHA,FB_LEDGER,BP_TIPE,BP_SOURCE_TRS,FS_KD_REF_OUT) VALUES
            //  (:NoKwitansi,:fs_ket_reff_kredit,'0',:terimapembayaran,'0','15400001',:idkwitansi,:noreg,'','0',:ledger,'','',:idkwitansi2)");
            //  $this->db->bind('NoKwitansi', $nofinalkwitansi);
            //  $this->db->bind('fs_ket_reff_kredit', $fs_ket_reff_kredit);
            //  $this->db->bind('terimapembayaran', $selisih_claim_convert);
            //  $this->db->bind('idkwitansi', $getID);
            //  $this->db->bind('noreg', $nomor_registrasi);
            //  $this->db->bind('ledger', $ledger);
            //  $this->db->bind('idkwitansi2', $getID);
            //  $this->db->execute();

            //  $ledger = '0';
            //  //INSERT-----------
            //  $fs_ket_reff = $jenis_reg.$tipepembayaran;
            //  $this->db->query("INSERT INTO Keuangan.dbo.TA_JURNAL_DTL (FS_KD_JURNAL,FS_KET_REFF,FN_DEBET,FN_KREDIT,FB_VOID,FS_REK,FS_KD_REFF,FS_KD_REG,FS_KD_UNIT,FB_UNIT_USAHA,FB_LEDGER,BP_TIPE,BP_SOURCE_TRS,FS_KD_REF_OUT) VALUES
            //  (:NoKwitansi,:fs_ket_reff,:totalinput,'0','0',:kd_rekening,:idkwitansi,:noreg,'','0',:ledger,'','',:idkwitansi2)");
            //  $this->db->bind('NoKwitansi', $nofinalkwitansi);
            //  $this->db->bind('fs_ket_reff', $fs_ket_reff);
            //  $this->db->bind('totalinput', $insert_payment_convert);
            //  $this->db->bind('kd_rekening', $Rekening);
            //  $this->db->bind('idkwitansi', $getID);
            //  $this->db->bind('noreg', $nomor_registrasi);
            //  $this->db->bind('ledger', $ledger);
            //  $this->db->bind('idkwitansi2', $getID);
            //  $this->db->execute();

            //  $ledger = '1';
            //  //INSERT JURNAL DTL
            //  $fs_ket_reff_kredit = $jenis_reg.'PIUTANG DALAM PERAWATAN';
            //  //INSERT-----------
            //  $this->db->query("INSERT INTO Keuangan.dbo.TA_JURNAL_DTL (FS_KD_JURNAL,FS_KET_REFF,FN_DEBET,FN_KREDIT,FB_VOID,FS_REK,FS_KD_REFF,FS_KD_REG,FS_KD_UNIT,FB_UNIT_USAHA,FB_LEDGER,BP_TIPE,BP_SOURCE_TRS,FS_KD_REF_OUT) VALUES
            //  (:NoKwitansi,:fs_ket_reff_kredit,'0',:terimapembayaran,'0','15400001',:idkwitansi,:noreg,'','0',:ledger,'','',:idkwitansi2)");
            //  $this->db->bind('NoKwitansi', $nofinalkwitansi);
            //  $this->db->bind('fs_ket_reff_kredit', $fs_ket_reff_kredit);
            //  $this->db->bind('terimapembayaran', $insert_payment_convert);
            //  $this->db->bind('idkwitansi', $getID);
            //  $this->db->bind('noreg', $nomor_registrasi);
            //  $this->db->bind('ledger', $ledger);
            //  $this->db->bind('idkwitansi2', $getID);
            //  $this->db->execute();

            //  //INSERT PIUTANG

            //     if($Gen_BP=='1'){
            //         $TglTrs = date('Y-m-d', strtotime($datenowcreate));
            //         $formatDateJurnal = date('dmy', strtotime($datenowcreate));
            //         $kodeHT = "PU";
            //         $ket = 'Piutang Pasien:'.$nama_pasien.'-Tanggal:'.$tgl_pulang.'-Noreg:'.$nomor_registrasi;

            //         $this->db->query("SELECT  TOP 1 KD_PIUTANG,right(KD_PIUTANG,4) as urutregx
            //         FROM Keuangan.dbo.PIUTANG_PASIEN  WHERE  
            //         replace(CONVERT(VARCHAR(11), fd_tgL_piutang, 111), '/','-')=:TglTrs
            //         AND LEFT(KD_PIUTANG,2)=:kodeHT
            //         ORDER BY KD_PIUTANG DESC");
            //            $this->db->bind('TglTrs',   $TglTrs);
            //            $this->db->bind('kodeHT',   $kodeHT);
            //            $data2 =  $this->db->single();

            //             $no_reg = $data2['urutregx'];  
            //             $idReg = $no_reg;
            //             $idReg++;
            //                     // GENERATE NO REGISTRASI
            //                     if(strlen($idReg)==1)
            //                     {
            //                         $noUrutJurnal = "000".$idReg;
            //                     }
            //                     else if(strlen($idReg)==2)
            //                     {
            //                         $noUrutJurnal = "00".$idReg;
            //                     }
            //                     else if(strlen($idReg)==3)
            //                     {
            //                         $noUrutJurnal = "0".$idReg;
            //                     }
            //                     else if(strlen($idReg)==4)
            //                     {
            //                         $noUrutJurnal = $idReg;
            //                     }
            //             $nofinalpiutang = $kodeHT.$formatDateJurnal.'-'.$noUrutJurnal;


            //         $this->db->query("INSERT INTO Keuangan.dbo.PIUTANG_PASIEN (KD_PIUTANG,fd_tgL_piutang,NO_TRANSAKSI,kode_jaminan,
            //         fn_piutang,fn_sisa,fs_kd_petugas,PAYMENT_NO,TipePiutang,TipeJaminan,FS_kET,FS_kET2,FS_REKENING)
            //         VALUES
            //         (:nofinalpiutang,:datetime_payment,:noreg,:idjaminan,
            //         :totalinput,:totalinput2,:user_id,:idkwitansi,$jenis_reg_cd,:tipejaminan,:ket,:noreg2,:kd_rekening)");
            //         $this->db->bind('nofinalpiutang', $nofinalpiutang);
            //         $this->db->bind('datetime_payment', $datenowcreate);
            //         $this->db->bind('noreg', $nomor_registrasi);
            //         $this->db->bind('idjaminan', $IDJaminan);
            //         $this->db->bind('totalinput', $total_insert);
            //         $this->db->bind('totalinput2', $total_insert);
            //         $this->db->bind('user_id', $namauser);
            //         $this->db->bind('idkwitansi', $getID);
            //         $this->db->bind('tipejaminan', $tipejaminan);
            //         $this->db->bind('ket', $ket);
            //         $this->db->bind('noreg2', $nomor_registrasi);
            //         $this->db->bind('kd_rekening', $Rekening);
            //         $this->db->execute();
            //         //var_dump('sss');exit;

            //         //PIUTANG DTL
            //         $this->db->query("INSERT INTO Keuangan.dbo.PIUTANG_PASIEN_2 (kd_piutang,fn_piutang)
            //         VALUES
            //         (:nofinalpiutang,:totalinput)");
            //         $this->db->bind('nofinalpiutang', $nofinalpiutang);
            //         $this->db->bind('totalinput', $selisih_claim_convert);
            //         $this->db->execute();

            //         //PIUTANG DTL 2
            //         $this->db->query("INSERT INTO Keuangan.dbo.PIUTANG_PASIEN_2 (kd_piutang,fn_piutang)
            //         VALUES
            //         (:nofinalpiutang,:totalinput)");
            //         $this->db->bind('nofinalpiutang', $nofinalpiutang);
            //         $this->db->bind('totalinput', $insert_payment_convert);
            //         $this->db->execute();
                    
            //         }


             $this->db->Commit();
            
            $callback = array(
                'status' => 'success',
                'message' => 'Final Klaim Berhasil !',
                'data_api' => $response,
            );
        } else {
            $this->db->rollback();
            $callback = array(
                'status' => 'danger',
                'message' => $response['metadata']['message'],
                'data_api' => $response,
            );
        }
       // return $response;
       return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            die($e->getMessage());
        }
    }

    public function Delete_PaymentbyReg($data){
        try{
            $this->db->transaksi();
            $nomor_registrasi = $data;
            $getreg = substr($nomor_registrasi,0,2);
            //DELETE YANG SUDAH ADA--------
            if ($getreg == 'RJ'){
                $this->db->query("DELETE PerawatanSQL.dbo.payments WHERE NoRegistrasi=:nomor_registrasi");
                $this->db->bind('nomor_registrasi', $nomor_registrasi);
                $this->db->execute();

                $this->db->query("DELETE PerawatanSQL.dbo.PaymentDetails WHERE PaymentID IN (SELECT Id FROM PerawatanSQL.dbo.payments WHERE NoRegistrasi=:nomor_registrasi)");
                $this->db->bind('nomor_registrasi', $nomor_registrasi);
                $this->db->execute();

                //DELETE JURNAL
                $this->db->query("DELETE Keuangan.dbo.TA_JURNAL_HDR WHERE FS_KD_JURNAL collate Latin1_General_CI_AS in (SELECT NoKwitansi FROM PerawatanSQL.dbo.payments WHERE NoRegistrasi=:nomor_registrasi)");
                $this->db->bind('nomor_registrasi', $nomor_registrasi);
                $this->db->execute();

                $this->db->query("DELETE Keuangan.dbo.TA_JURNAL_DTL WHERE FS_KD_JURNAL collate Latin1_General_CI_AS in (SELECT NoKwitansi FROM PerawatanSQL.dbo.payments WHERE NoRegistrasi=:nomor_registrasi)");
                $this->db->bind('nomor_registrasi', $nomor_registrasi);
                $this->db->execute();
             }else{
                $this->db->query("DELETE RawatInapSQL.dbo.Deposit WHERE NoRegistrasi=:nomor_registrasi");
                $this->db->bind('nomor_registrasi', $nomor_registrasi);
                $this->db->execute();

                $this->db->query("DELETE RawatInapSQL.dbo.DepositDetails WHERE IDDeposit IN (SELECT IDDeposit RawatInapSQL.dbo.Deposit WHERE NoRegistrasi=:nomor_registrasi)");
                $this->db->bind('nomor_registrasi', $nomor_registrasi);
                $this->db->execute();

                //DELETE JURNAL
                $this->db->query("DELETE Keuangan.dbo.TA_JURNAL_HDR WHERE FS_KD_JURNAL collate Latin1_General_CI_AS in (SELECT NoKwitansi RawatInapSQL.dbo.Deposit WHERE NoRegistrasi=:nomor_registrasi)");
                $this->db->bind('nomor_registrasi', $nomor_registrasi);
                $this->db->execute();

                $this->db->query("DELETE Keuangan.dbo.TA_JURNAL_DTL WHERE FS_KD_JURNAL collate Latin1_General_CI_AS in (SELECT NoKwitansi RawatInapSQL.dbo.Deposit WHERE NoRegistrasi=:nomor_registrasi)");
                $this->db->bind('nomor_registrasi', $nomor_registrasi);
                $this->db->execute();
             }

             //VOID PIUTANG
             $this->db->query("UPDATE Keuangan.dbo.PIUTANG_PASIEN SET FB_BATAL='1' WHERE  Fs_KET2=:nomor_registrasi");
             $this->db->bind('nomor_registrasi', $nomor_registrasi);
             $this->db->execute();
             $this->db->Commit();
             //#END DELETE----------------
        }catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function reedit_claim($data){

        try {
         $this->db->transaksi();
        $getreg = substr($data['nomor_registrasi'],0,2);
        // if ($getreg == 'RJ'){
        //     //GET status 
        //  $this->db->query("SELECT [Status ID] as statusid from PerawatanSQL.dbo.Visit WHERE NoRegistrasi=:nomor_registrasi AND [Status ID] = '4'");
        //  $this->db->bind('nomor_registrasi', $data['nomor_registrasi']);
        //  $datas =  $this->db->resultSet();

        //  if (count($datas) > 0){
        //      $callback = array(
        //          'status' => 'warning',
        //          'errorname' => 'Billing Sudah Diclose ! Mohon Dibuka Untuk Proses Eklaim !',
        //      );
        //      echo json_encode($callback);
        //      exit;
        //  }
        // }else{
        // //GET status 
        //  $this->db->query("SELECT [StatusID] as statusid from RawatInapSQL.dbo.Inpatient WHERE NoRegRI=:nomor_registrasi AND [StatusID] = '4'");
        //  $this->db->bind('nomor_registrasi', $data['nomor_registrasi']);
        //  $datas =  $this->db->resultSet();

        //  if (count($datas) > 0){
        //      $callback = array(
        //          'status' => 'warning',
        //          'errorname' => 'Billing Sudah Diclose ! Mohon Dibuka Untuk Proses Eklaim !',
        //      );
        //      echo json_encode($callback);
        //      exit;
        //  }

        //   //GET status 
        //   $this->db->query("SELECT statusResume from MedicalRecord.dbo.MR_Resume_Medis where No_Registrasi=:nomor_registrasi AND statusResume='CLOSED'");
        //   $this->db->bind('nomor_registrasi', $data['nomor_registrasi']);
        //   $datas =  $this->db->resultSet();
 
        //   if (count($datas) == 0){
        //       $callback = array(
        //           'status' => 'warning',
        //           'errorname' => 'Resume Medis Belum Diclose !',
        //       );
        //       echo json_encode($callback);
        //       exit;
        //   }
        // }

        
        
        $nomor_sep = $data['nomor_sep'];
        $nomor_registrasi = $data['nomor_registrasi'];
        $ID_EKLAIM = $data['ID_EKLAIM'];
        $alasan = $data['alasan'];

        // $getreg = substr($nomor_registrasi,0,2);
        //      if ($getreg == 'RJ'){
        //         $this->db->query("SELECT ID as idpayment,Lock_Finance,NoKwitansi as nokwitansi FROM PerawatanSQL.dbo.payments  WHERE NoRegistrasi=:noreg AND Descripton='Selisih Bridging Eklaim'
        //         ");
        //         $this->db->bind('noreg', $nomor_registrasi); 
        //         $datas =  $this->db->single();
        //         $idpayment = $datas['idpayment'];
        //         $Lock_Finance = $datas['Lock_Finance'];
        //         $nokwitansi = $datas['nokwitansi'];
        //      }else{
        //         $this->db->query("SELECT Id as idpayment,Lock_Finance,NoKwitansi as nokwitansi FROM RawatInapSQL.dbo.Deposit  WHERE NoRegistrasi=:noreg AND Keterangan='Selisih Bridging Eklaim'
        //         ");
        //         $this->db->bind('noreg', $nomor_registrasi); 
        //         $datas =  $this->db->single();
        //         $idpayment = $datas['idpayment'];
        //         $Lock_Finance = $datas['Lock_Finance'];
        //         $nokwitansi = $datas['nokwitansi'];
        //      }

        //      //CEK JIKA SUDAH DITAGIHKAN
        //      $this->db->query("SELECT FB_TAGIH FROM  Keuangan.dbo.PIUTANG_PASIEN  WHERE PAYMENT_NO=:idpayment AND Fs_KET2=:nomor_registrasi
        //      ");
        //      $this->db->bind('idpayment', $idpayment); 
        //      $this->db->bind('nomor_registrasi', $nomor_registrasi); 
        //      $key =  $this->db->single();

        //      $FB_TAGIH = $key['FB_TAGIH']; 
        //      if ($FB_TAGIH == '1'){
        //         $callback = array(
        //             'status' => 'warning',
        //             'errorname' => 'Piutang Sudah Ditagihkan !',
        //         );
        //         echo json_encode($callback);
        //         exit;
        //      }
             
        //      if ($Lock_Finance == '1'){
        //         $callback = array(
        //             'status' => 'warning',
        //             'errorname' => 'Payment Sudah Dilock Oleh Bagian Keuangan! Silahkan Konfirmasi ke Bagian Keuangan!',
        //         );
        //         echo json_encode($callback);
        //         exit;
        //      }


        // membuat json juga dapat menggunakan json_encode:
        $ws_query["metadata"]["method"] = "reedit_claim";

        $ws_query["data"]["nomor_sep"] = $nomor_sep;

        $json_request = json_encode($ws_query);
        // data yang akan dikirimkan dengan method POST adalah encrypted:

        $response =  $this->EklaimApi($json_request);

        if ($response['metadata']['code'] == 200) {
            $TGLNOW = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $namauser = $session->name;

            $this->db->query("UPDATE DashboardData.[dbo].[EKLAIM]
                    SET
                    [FINAL_KLAIM] =:FINAL_KLAIM,[SEND_CLAIM_INDIVIDUAL]=:SEND_CLAIM_INDIVIDUAL,TOTAL_TARIF_INACBG=:TOTAL_TARIF_INACBG,SELISIH_CLAIM=:SELISIH_CLAIM
                    WHERE ID=:ID_EKLAIM
                    ");

            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $this->db->bind('FINAL_KLAIM', '0');
            $this->db->bind('SEND_CLAIM_INDIVIDUAL', '0');
            $this->db->bind('TOTAL_TARIF_INACBG', NULL);
            $this->db->bind('SELISIH_CLAIM', NULL);
            // $this->db->bind('NAMA_USER_UPDATE', $namauser);
            $this->db->execute();

            //INSERT KE LOG-----------
            $this->db->query("INSERT INTO DashboardData.dbo.LOG_EKLAIM (ID_EKLAIM,NO_REGISTRASI,KETERANGAN,DATE_UPDATE,USER_UPDATE,ALASAN) VALUES
             (:ID_EKLAIM,:NO_REGISTRASI,:KETERANGAN,:DATE_UPDATE,:USER_UPDATE,:alasan)");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $this->db->bind('NO_REGISTRASI', $nomor_registrasi);
            $this->db->bind('KETERANGAN', 'Edit Ulang Klaim');
            $this->db->bind('DATE_UPDATE', $TGLNOW);
            $this->db->bind('USER_UPDATE', $userid);
            $this->db->bind('alasan', $alasan);
            $this->db->execute();
            //----------------

            //  if ($getreg == 'RJ'){
            //     $this->db->query("DELETE PerawatanSQL.dbo.payments WHERE ID=:idpayment");
            //     $this->db->bind('idpayment', $idpayment);
            //     $this->db->execute();

            //     $this->db->query("DELETE PerawatanSQL.dbo.PaymentDetails WHERE PaymentID=:idpayment");
            //     $this->db->bind('idpayment', $idpayment);
            //     $this->db->execute();
            //  }else{
            //     $this->db->query("DELETE RawatInapSQL.dbo.Deposit WHERE Id=:idpayment");
            //     $this->db->bind('idpayment', $idpayment);
            //     $this->db->execute();

            //     $this->db->query("DELETE RawatInapSQL.dbo.DepositDetails WHERE IDDeposit=:idpayment");
            //     $this->db->bind('idpayment', $idpayment);
            //     $this->db->execute();
            //  }
             
            //  //DELETE JURNAL
            //  $this->db->query("DELETE Keuangan.dbo.TA_JURNAL_HDR WHERE FS_KD_JURNAL=:nokwitansi");
            //  $this->db->bind('nokwitansi', $nokwitansi);
            //  $this->db->execute();

            //  $this->db->query("DELETE Keuangan.dbo.TA_JURNAL_DTL WHERE FS_KD_JURNAL=:nokwitansi");
            //  $this->db->bind('nokwitansi', $nokwitansi);
            //  $this->db->execute();

            //  //VOID PIUTANG
            //  $this->db->query("UPDATE Keuangan.dbo.PIUTANG_PASIEN SET FB_BATAL='1' WHERE PAYMENT_NO=:idpayment AND Fs_KET2=:nomor_registrasi");
            //  $this->db->bind('idpayment', $idpayment);
            //  $this->db->bind('nomor_registrasi', $nomor_registrasi);
            //  $this->db->execute();

             $this->db->Commit();

            $callback = array(
                'status' => 'success',
                'message' => 'Edit Ulang Klaim Berhasil !',
                'data_api' => $response,
            );
        } else {
            $this->db->rollback();
            $callback = array(
                'status' => 'danger',
                'message' => $response['metadata']['message'],
                'data_api' => $response,
            );
        }
            return $callback;
            //return $response;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function send_claim($data)
    {
        $start_dt = $data['start_dt'];
        $stop_dt = $data['stop_dt'];
        $jenis_rawat = $data['jenis_rawat'];
        $date_type = $data['date_type'];
        // membuat json juga dapat menggunakan json_encode:
        $ws_query["metadata"]["method"] = "send_claim";

        $ws_query["data"]["start_dt"] = $start_dt;
        $ws_query["data"]["stop_dt"] = $stop_dt;
        $ws_query["data"]["jenis_rawat"] = $jenis_rawat;
        $ws_query["data"]["date_type"] = $date_type;

        $json_request = json_encode($ws_query);
        // data yang akan dikirimkan dengan method POST adalah encrypted:

        $response =  $this->EklaimApi($json_request);
        return $response;
    }

    public function send_claim_individual($data)
    {
        $nomor_sep = $data['nomor_sep'];
        $nomor_registrasi = $data['nomor_registrasi'];
        $ID_EKLAIM = $data['ID_EKLAIM'];
        // membuat json juga dapat menggunakan json_encode:
        $ws_query["metadata"]["method"] = "send_claim_individual";

        $ws_query["data"]["nomor_sep"] = $nomor_sep;

        $json_request = json_encode($ws_query);
        // data yang akan dikirimkan dengan method POST adalah encrypted:

        $response =  $this->EklaimApi($json_request);

        if ($response['metadata']['code'] == 200) {
            $TGLNOW = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $namauser = $session->name;

            $this->db->query("UPDATE DashboardData.[dbo].[EKLAIM]
                    SET
                    [SEND_CLAIM_INDIVIDUAL] =:FINAL_KLAIM
                    WHERE ID=:ID_EKLAIM
                    ");

            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $this->db->bind('FINAL_KLAIM', '1');
            // $this->db->bind('DATE_UPDATE', $TGLNOW);
            // $this->db->bind('USER_UPDATE', $userid);
            // $this->db->bind('NAMA_USER_UPDATE', $namauser);
            $this->db->execute();

            //INSERT KE LOG-----------
            $this->db->query("INSERT INTO DashboardData.dbo.LOG_EKLAIM (ID_EKLAIM,NO_REGISTRASI,KETERANGAN,DATE_UPDATE,USER_UPDATE) VALUES
              (:ID_EKLAIM,:NO_REGISTRASI,:KETERANGAN,:DATE_UPDATE,:USER_UPDATE)");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $this->db->bind('NO_REGISTRASI', $nomor_registrasi);
            $this->db->bind('KETERANGAN', 'Kirim Klaim Online');
            $this->db->bind('DATE_UPDATE', $TGLNOW);
            $this->db->bind('USER_UPDATE', $userid);
            $this->db->execute();
            //----------------


            $callback = array(
                'status' => 'success',
                'message' => 'Klaim Berhasil Dikirim !',
                'data_api' => $response,
            );
        } else {
            $callback = array(
                'status' => 'danger',
                'message' => $response['metadata']['message'],
                'data_api' => $response,
            );
        }
        return $callback;
        //return $response;
    }

    public function pull_claim($data)
    {
        $start_dt = $data['start_dt'];
        $stop_dt = $data['stop_dt'];
        $jenis_rawat = $data['jenis_rawat'];
        // membuat json juga dapat menggunakan json_encode:
        $ws_query["metadata"]["method"] = "pull_claim";

        $ws_query["data"]["start_dt"] = $start_dt;
        $ws_query["data"]["stop_dt"] = $stop_dt;
        $ws_query["data"]["jenis_rawat"] = $jenis_rawat;

        $json_request = json_encode($ws_query);
        // data yang akan dikirimkan dengan method POST adalah encrypted:

        $response =  $this->EklaimApi($json_request);
        return $response;
    }

    public function get_claim_data($data)
    {
        $nomor_sep = $data['nomor_sep'];
        $ID_EKLAIM = $data['ID_EKLAIM'];
        // membuat json juga dapat menggunakan json_encode:
        $ws_query["metadata"]["method"] = "get_claim_data";

        $ws_query["data"]["nomor_sep"] = $nomor_sep;

        $json_request = json_encode($ws_query);
        // data yang akan dikirimkan dengan method POST adalah encrypted:

        $response =  $this->EklaimApi($json_request);

        $this->db->query("SELECT DATE_UPDATE
             FROM DashboardData.dbo.EKLAIM
             Where ID=:ID_EKLAIM 
             ");
        $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
        $key =  $this->db->single();

        $pasing['DATE_UPDATE'] =  date('d M Y H:i', strtotime($key['DATE_UPDATE']));
        $datalocal[] = $pasing;

        $callback = array(
            'status' => 'success',
            //'message' => 'Klaim Berhasil Dihapus !',
            'data_api' => $response,
            'data_local' => $datalocal,
        );
        //return $response;
        return $callback;
    }

    public function get_claim_status($data)
    {
        $nomor_sep = $data['nomor_sep'];
        // membuat json juga dapat menggunakan json_encode:
        $ws_query["metadata"]["method"] = "get_claim_status";

        $ws_query["data"]["nomor_sep"] = $nomor_sep;

        $json_request = json_encode($ws_query);
        // data yang akan dikirimkan dengan method POST adalah encrypted:

        $response =  $this->EklaimApi($json_request);
        return $response;
    }

    public function delete_claim($data)
    {
        $nomor_sep = $data['nomor_sep'];
        $nomor_registrasi = $data['nomor_registrasi'];
        $ID_EKLAIM = $data['ID_EKLAIM'];
        $alasan = $data['alasan'];
        //$coder_nik = $data['coder_nik'];
        // membuat json juga dapat menggunakan json_encode:
        $ws_query["metadata"]["method"] = "delete_claim";

        $ws_query["data"]["nomor_sep"] = $nomor_sep;
        //$ws_query["data"]["coder_nik"] = $coder_nik;
        $ws_query["data"]["coder_nik"] = "3175081904930001";

        $json_request = json_encode($ws_query);
        // data yang akan dikirimkan dengan method POST adalah encrypted:

        $response =  $this->EklaimApi($json_request);

        if ($response['metadata']['code'] == 200) {
            $TGLNOW = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;

            $this->db->query("UPDATE DashboardData.dbo.EKLAIM SET BATAL='1',USER_BATAL=:user_create,DATE_BATAL=:date_create WHERE ID=:ID_EKLAIM");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $this->db->bind('date_create', $TGLNOW);
            $this->db->bind('user_create', $userid);
            $this->db->execute();

            //INSERT KE LOG-----------
            $this->db->query("INSERT INTO DashboardData.dbo.LOG_EKLAIM (ID_EKLAIM,NO_REGISTRASI,KETERANGAN,DATE_UPDATE,USER_UPDATE,ALASAN) VALUES
             (:ID_EKLAIM,:NO_REGISTRASI,:KETERANGAN,:DATE_UPDATE,:USER_UPDATE,:alasan)");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $this->db->bind('NO_REGISTRASI', $nomor_registrasi);
            $this->db->bind('KETERANGAN', 'Delete Klaim');
            $this->db->bind('DATE_UPDATE', $TGLNOW);
            $this->db->bind('USER_UPDATE', $userid);
            $this->db->bind('alasan', $alasan);
            $this->db->execute();
            //----------------

            //Hapus sitb
            $this->sitb_invalidate($data);

            $callback = array(
                'status' => 'success',
                'message' => 'Klaim Berhasil Dihapus !',
            );
        } else {
            $callback = array(
                'status' => 'danger',
                'message' => $response['metadata']['message']
            );
        }


        return $callback;
    }

    public function claim_print($data)
    {
        $nomor_sep = $data['nomor_sep'];
        // membuat json juga dapat menggunakan json_encode:
        $ws_query["metadata"]["method"] = "claim_print";

        $ws_query["data"]["nomor_sep"] = $nomor_sep;

        $json_request = json_encode($ws_query);
        // data yang akan dikirimkan dengan method POST adalah encrypted:

        $response =  $this->EklaimApi($json_request);
        return $response;
    }

    public function search_diagnosis($data)
    {
        $keyword = $data['keyword'];
        // membuat json juga dapat menggunakan json_encode:
        $ws_query["metadata"]["method"] = "search_diagnosis";

        $ws_query["data"]["keyword"] = $keyword;

        $json_request = json_encode($ws_query);
        // data yang akan dikirimkan dengan method POST adalah encrypted:

        $response =  $this->EklaimApi($json_request);
        //var_dump($response['response']['data']);
        foreach ($response['response']['data'] as $jsons) {
            $pasing['id'] = $jsons[1];
            $pasing['text'] = $jsons[0] . ' - ' . $jsons[1];
            $pasing['nama_diagnosa'] = $jsons[0];
            $datas[] = $pasing;
        }
        return $datas;
    }

    public function search_procedures($data)
    {
        $keyword = $data['keyword'];
        // membuat json juga dapat menggunakan json_encode:
        $ws_query["metadata"]["method"] = "search_procedures";

        $ws_query["data"]["keyword"] = $keyword;

        $json_request = json_encode($ws_query);
        // data yang akan dikirimkan dengan method POST adalah encrypted:

        $response =  $this->EklaimApi($json_request);

        foreach ($response['response']['data'] as $jsons) {
            $pasing['id'] = $jsons[1];
            $pasing['text'] = $jsons[0] . ' - ' . $jsons[1];
            $pasing['nama_prosedur'] = $jsons[0];
            $datas[] = $pasing;
        }
        return $datas;
    }

    public function retrieve_claim_status($data)
    {
        $nomor_sep = $data['nomor_sep'];
        $nomor_pengajuan = $data['nomor_pengajuan'];
        // membuat json juga dapat menggunakan json_encode:
        $ws_query["metadata"]["method"] = "retrieve_claim_status";

        $ws_query["data"]["nomor_sep"] = $nomor_sep;
        $ws_query["data"]["nomor_pengajuan"] = $nomor_pengajuan;

        $json_request = json_encode($ws_query);
        // data yang akan dikirimkan dengan method POST adalah encrypted:

        $response =  $this->EklaimApi($json_request);
        return $response;
    }

    public function search_diagnosis_inagrouper($data)
    {
        $keyword = $data['keyword'];
        // membuat json juga dapat menggunakan json_encode:
        $ws_query["metadata"]["method"] = "search_diagnosis_inagrouper";

        $ws_query["data"]["keyword"] = $keyword;

        $json_request = json_encode($ws_query);
        // data yang akan dikirimkan dengan method POST adalah encrypted:

        $response =  $this->EklaimApi($json_request);
        foreach ($response['response']['data'] as $jsons) {
            $pasing['id'] = $jsons['code'];
            $pasing['text'] = $jsons['code'] . ' - ' . $jsons['description'];
            $pasing['nama_diagnosa'] = $jsons['description'];
            $datas[] = $pasing;
        }
        return $datas;
    }

    public function search_procedures_inagrouper($data)
    {
        $keyword = $data['keyword'];
        // membuat json juga dapat menggunakan json_encode:
        $ws_query["metadata"]["method"] = "search_procedures_inagrouper";

        $ws_query["data"]["keyword"] = $keyword;

        $json_request = json_encode($ws_query);
        // data yang akan dikirimkan dengan method POST adalah encrypted:

        $response =  $this->EklaimApi($json_request);

        foreach ($response['response']['data'] as $jsons) {
            $pasing['id'] = $jsons['code'];
            $pasing['text'] = $jsons['code'] . ' - ' . $jsons['description'];
            $pasing['nama_prosedur'] = $jsons['description'];
            $datas[] = $pasing;
        }
        return $datas;
    }

    public function file_upload($data)
    {
        $ID_EKLAIM = $data['ID_EKLAIM'];
        $nomor_sep = $data['nomor_sep'];
        $file_class = $data['file_class'];

        if (!isset($_FILES["file"])) {
            $callback = array(
                'status' => 'danger',
                'message' => 'Pilih File Yang Ingin Diupload !',
            );
            return $callback;
            exit;
        }

        $allowed = array("pdf" => "application/pdf");
        $filetype = $_FILES["file"]["type"];
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
        $tmp_file = $_FILES['file']['tmp_name'];
        $file_name = $_FILES['file']['name'];

        $file_encoded = base64_encode(file_get_contents($tmp_file));


        if (!in_array($filetype, $allowed)) {
            $callback = array(
                'status' => 'danger',
                'message' => 'File Tidak Support !',
            );
            return $callback;
            exit;
        }

        $ws_query["metadata"]["method"] = "file_upload";
        $ws_query["metadata"]["nomor_sep"] = $nomor_sep;
        $ws_query["metadata"]["file_class"] = $file_class;
        $ws_query["metadata"]["file_name"] = $file_name;

        $ws_query["data"] = $file_encoded;

        $json_request = json_encode($ws_query);


        $response =  $this->EklaimApi($json_request);

        if ($response['metadata']['code'] == 200) {
            $TGLNOW = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $namauser = $session->name;

            //INSERT KE LOG-----------
            $this->db->query("INSERT INTO DashboardData.dbo.EKLAIM_UPLOAD_FILE (ID_EKLAIM,NAMA_FILE,DATA_FILE,FILE_CLASS,DATE_CREATE,USER_CREATE,FILE_ID,FILE_TYPE,FILE_SIZE) VALUES
             (:ID_EKLAIM,:namafile,:file_encoded,:file_class,:DATE_UPDATE,:USER_UPDATE,:file_id,:FILE_TYPE,:FILE_SIZE)");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $this->db->bind('namafile', $file_name);
            $this->db->bind('file_encoded', $file_encoded);
            $this->db->bind('file_class', $file_class);
            $this->db->bind('DATE_UPDATE', $TGLNOW);
            $this->db->bind('USER_UPDATE', $userid);
            $this->db->bind('file_id', $response['response']['file_id']);
            $this->db->bind('FILE_TYPE', $response['response']['file_type']);
            $this->db->bind('FILE_SIZE', $response['response']['file_size']);
            $this->db->execute();
            //----------------


            $callback = array(
                'status' => 'success',
                'message' => 'Upload Berhasil !',
                'data_api' => $response,
            );
        } else {
            $callback = array(
                'status' => 'danger',
                'message' => $response['metadata']['message'],
                'data_api' => $response,
            );
        }
        return $callback;
    }

    public function getList_UploadFile($data)
    {
        try {
            $this->db->query("SELECT a.*,b.username FROM DashboardData.dbo.EKLAIM_UPLOAD_FILE a
            inner join MasterdataSQL.dbo.Employees b on a.USER_CREATE collate Latin1_General_CI_AS=b.NoPIN collate Latin1_General_CI_AS
             WHERE ID_EKLAIM=:ID_EKLAIM AND FILE_CLASS=:file_class");
            $this->db->bind('ID_EKLAIM', $data['ID_EKLAIM']);
            $this->db->bind('file_class', $data['file_class']);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['DATA_FILE'] = $key['DATA_FILE'];
                $pasing['NAMA_FILE'] = $key['NAMA_FILE'];
                $pasing['DATE_CREATE'] = date('d/m/Y H:i:s', strtotime($key['DATE_CREATE']));
                $pasing['USER_CREATE'] = $key['username'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function ViewUploadFile($data)
    {
        try {
            $this->db->query("SELECT DATA_FILE FROM DashboardData.dbo.EKLAIM_UPLOAD_FILE WHERE ID=:id
             ");
            $this->db->bind('id', $data['id']);
            $key =  $this->db->single();
            $pasing['data'] = $key['DATA_FILE'];

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function file_delete($data)
    {
        try {
            $this->db->transaksi();

            //$ID_EKLAIM = $data['ID_EKLAIM'];
            $ID = $data['ID'];
            $nomor_sep = $data['nomor_sep'];

            $this->db->query("SELECT FILE_ID FROM DashboardData.dbo.EKLAIM_UPLOAD_FILE WHERE ID=:ID
             ");
            $this->db->bind('ID', $data['ID']);
            $key =  $this->db->single();
            $file_id = $key['FILE_ID'];


            $ws_query["metadata"]["method"] = "file_delete";

            $ws_query["data"]["nomor_sep"] = $nomor_sep;
            $ws_query["data"]["file_id"] =  $file_id;

            $json_request = json_encode($ws_query);

            $response =  $this->EklaimApi($json_request);


            if ($response['metadata']['code'] == 200) {
                $this->db->query("DELETE DashboardData.dbo.EKLAIM_UPLOAD_FILE WHERE ID=:ID");
                $this->db->bind('ID', $ID);
                $this->db->execute();

                $this->db->commit();
                $callback = array(
                    'status' => 'success', // Set array status dengan success   
                    'message' => 'File Berhasil Dihapus !', // Set array status dengan success    
                );
            } else {
                $this->db->rollback();
                $callback = array(
                    'status' => 'danger',
                    'message' => $response['metadata']['message']
                );
            }
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function generate_claim_number()
    {
        $ws_query["metadata"]["method"] = "generate_claim_number";

        $json_request = json_encode($ws_query);
        $response =  $this->EklaimApi($json_request);
        if ($response['metadata']['code'] == 200) {
            return $response['response']['claim_number'];
        } else {
            $callback = array(
                'status' => 'warning',
                'message' => $response['metadata']['message']
            );
            return $callback;
        }
    }

    public function create_co_insidense($data)
    {
        try {
            $this->db->transaksi();

            $ID_EKLAIM = $data['ID_EKLAIM'];
            $nomor_sep = $data['nomor_sep'];
            $TGLNOW = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $coder_nik =  $this->getcoderNIK();

            $this->db->query("INSERT INTO DashboardData.dbo.EKLAIM (
                [NO_SEP]
                ,[NO_MR]
                ,[NO_REGISTRASI]
                ,[NAMA_PASIEN]
                ,[TGL_LAHIR]
                ,[NO_KARTU]
                ,[PATIENT_ID]
                ,[ADMISSION_ID]
                ,[HOSPITAL_ADMISSION_ID]
                ,[DATE_CREATE]
                ,[USER_CREATE]
                ,[BATAL]
                ,[USER_BATAL]
                ,[DATE_BATAL]
                ,[TGL_MASUK]
                ,[TGL_PULANG]
                ,[JENIS_RAWAT]
                ,[NAMA_JENIS_RAWAT]
                ,[KELAS_RAWAT]
                ,[ADL_SUB_ACUTE]
                ,[ADL_CHRONIC]
                ,[ICU_INDIKATOR]
                ,[ICU_LOS]
                ,[VENTILATOR_HOUR]
                ,[UPGRADE_CLASS_IND]
                ,[UPGRADE_CLASS_CLASS]
                ,[UPGRADE_CLASS_LOS]
                ,[ADD_PAYMENT_PCT]
                ,[BIRTH_WEIGHT]
                ,[DISCHARGE_STATUS]
                ,[NAMA_DISCHARGE_STATUS]
                ,[TARIF_PROSEDUR_NON_BEDAH]
                ,[TARIF_PROSEDUR_BEDAH]
                ,[TARIF_KONSULTASI]
                ,[TARIF_TENAGA_AHLI]
                ,[TARIF_KEPERAWATAN]
                ,[TARIF_PENUNJANG]
                ,[TARIF_RADIOLOGI]
                ,[TARIF_LABORATORIUM]
                ,[TARIF_PELAYANAN_DARAH]
                ,[TARIF_REHABILITASI]
                ,[TARIF_KAMAR]
                ,[TARIF_RAWAT_INTENSIF]
                ,[TARIF_OBAT]
                ,[TARIF_OBAT_KRONIS]
                ,[TARIF_OBAT_KEMOTERAPI]
                ,[TARIF_ALKES]
                ,[TARIF_BMHP]
                ,[TARIF_SEWA_ALAT]
                ,[PEMULASARAAN_JENAZAH]
                ,[KANTONG_JENAZAH]
                ,[PETI_JENAZAH]
                ,[PLASTIK_ERAT]
                ,[DESINFEKTAN_JENAZAH]
                ,[MOBIL_JENAZAH]
                ,[DESINFEKTAN_MOBIL_JENAZAH]
                ,[COVID19_STATUS_CD]
                ,[NOMOR_KARTU_T]
                ,[EPISODES]
                ,[COVID19_CC_IND]
                ,[COVID19_RS_DARURAT_IND]
                ,[COVID19_CO_INSIDENSE_IND]
                ,[COVID19_NO_SEP]
                ,[LAB_ASAM_LAKTAT]
                ,[LAB_PROCALCITONIN]
                ,[LAB_CRP]
                ,[LAB_KULTUR]
                ,[LAB_D_DIMER]
                ,[LAB_PT]
                ,[LAB_APTT]
                ,[LAB_WAKTU_PENDARAHAN]
                ,[LAB_ANTI_HIV]
                ,[LAB_ANALISA_GAS]
                ,[LAB_ALBUMIN]
                ,[RAD_THORAX_AP_PA]
                ,[TERAPI_KONVALESEN]
                ,[AKSES_NAAT]
                ,[ISOMAN_IND]
                ,[BAYI_LAHIR_STATUS_CD]
                ,[TARIF_POLI_EKS]
                ,[NAMA_DOKTER]
                ,[KODE_TARIF]
                ,[PAYOR_ID]
                ,[PAYOR_CD]
                ,[COB_CD]
                ,[CODER_NIK]
                ) 
                SELECT 
                b.NO_SEP
                ,a.[NO_MR]
                ,a.[NO_REGISTRASI]
                ,a.[NAMA_PASIEN]
                ,a.[TGL_LAHIR]
                ,a.[NO_KARTU]
                ,a.[PATIENT_ID]
                ,a.[ADMISSION_ID]
                ,a.[HOSPITAL_ADMISSION_ID]
                ,'$TGLNOW' as [DATE_CREATE]
                ,'$userid' as [USER_CREATE]
                ,a.[BATAL]
                ,a.[USER_BATAL]
                ,a.[DATE_BATAL]
                ,a.[TGL_MASUK]
                ,a.[TGL_PULANG]
                ,null as [JENIS_RAWAT]
                ,null as [NAMA_JENIS_RAWAT]
                ,a.[KELAS_RAWAT]
                ,a.[ADL_SUB_ACUTE]
                ,a.[ADL_CHRONIC]
                ,a.[ICU_INDIKATOR]
                ,a.[ICU_LOS]
                ,a.[VENTILATOR_HOUR]
                ,a.[UPGRADE_CLASS_IND]
                ,a.[UPGRADE_CLASS_CLASS]
                ,a.[UPGRADE_CLASS_LOS]
                ,a.[ADD_PAYMENT_PCT]
                ,a.[BIRTH_WEIGHT]
                ,a.[DISCHARGE_STATUS]
                ,a.[NAMA_DISCHARGE_STATUS]
                ,a.[TARIF_PROSEDUR_NON_BEDAH]
                ,a.[TARIF_PROSEDUR_BEDAH]
                ,a.[TARIF_KONSULTASI]
                ,a.[TARIF_TENAGA_AHLI]
                ,a.[TARIF_KEPERAWATAN]
                ,a.[TARIF_PENUNJANG]
                ,a.[TARIF_RADIOLOGI]
                ,a.[TARIF_LABORATORIUM]
                ,a.[TARIF_PELAYANAN_DARAH]
                ,a.[TARIF_REHABILITASI]
                ,a.[TARIF_KAMAR]
                ,a.[TARIF_RAWAT_INTENSIF]
                ,a.[TARIF_OBAT]
                ,a.[TARIF_OBAT_KRONIS]
                ,a.[TARIF_OBAT_KEMOTERAPI]
                ,a.[TARIF_ALKES]
                ,a.[TARIF_BMHP]
                ,a.[TARIF_SEWA_ALAT]
                ,a.[PEMULASARAAN_JENAZAH]
                ,a.[KANTONG_JENAZAH]
                ,a.[PETI_JENAZAH]
                ,a.[PLASTIK_ERAT]
                ,a.[DESINFEKTAN_JENAZAH]
                ,a.[MOBIL_JENAZAH]
                ,a.[DESINFEKTAN_MOBIL_JENAZAH]
                ,a.[COVID19_STATUS_CD]
                ,a.[NOMOR_KARTU_T]
                ,a.[EPISODES]
                ,a.[COVID19_CC_IND]
                ,a.[COVID19_RS_DARURAT_IND]
                ,'1' as [COVID19_CO_INSIDENSE_IND]
                ,'$nomor_sep' as [COVID19_NO_SEP]
                ,a.[LAB_ASAM_LAKTAT]
                ,a.[LAB_PROCALCITONIN]
                ,a.[LAB_CRP]
                ,a.[LAB_KULTUR]
                ,a.[LAB_D_DIMER]
                ,a.[LAB_PT]
                ,a.[LAB_APTT]
                ,a.[LAB_WAKTU_PENDARAHAN]
                ,a.[LAB_ANTI_HIV]
                ,a.[LAB_ANALISA_GAS]
                ,a.[LAB_ALBUMIN]
                ,a.[RAD_THORAX_AP_PA]
                ,a.[TERAPI_KONVALESEN]
                ,a.[AKSES_NAAT]
                ,a.[ISOMAN_IND]
                ,a.[BAYI_LAHIR_STATUS_CD]
                ,a.[TARIF_POLI_EKS]
                ,a.[NAMA_DOKTER]
                ,a.[KODE_TARIF]
                ,'3' AS [PAYOR_ID]
                ,'JKN' AS PAYOR_CD
                ,a.[COB_CD]
                ,'$coder_nik' as CODER_NIK
                 FROM DashboardData.dbo.EKLAIM a
                 left join PerawatanSQL.dbo.BPJS_T_SEP b on a.NO_REGISTRASI COLLATE Latin1_General_CI_AS=b.NO_REGISTRASI  COLLATE Latin1_General_CI_AS
                 WHERE a.ID=:ID_EKLAIM
            ");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $this->db->execute();
            $getID = $this->db->GetLastID();

            $this->db->query("SELECT NO_REGISTRASI
             FROM DashboardData.dbo.EKLAIM Where ID=:id 
             ");
            $this->db->bind('id', $getID);
            $key =  $this->db->single();

            $passing['nomor_registrasi'] = $key['NO_REGISTRASI'];
            $callback = array(
                'status' => 'success',
                'message' => 'Klaim Baru Berhasil Dibuat !',
                'data' => $passing,
            );

            $this->db->Commit();

            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function getListDataBPJS_SEP($data)
    {
        try {
            $JenisPasien = $data['JenisPasien'];
            $PeriodeAwal = $data['PeriodeAwal'];
            $PeriodeAkhir = $data['PeriodeAkhir'];

            $this->db->query("SELECT *,replace(CONVERT(VARCHAR(11), TGL_LAHIR, 111), '/','-') as DOB FROM PerawatanSQL.dbo.BPJS_T_SEP
            WHERE replace(CONVERT(VARCHAR(11), TGL_SEP, 111), '/','-') between :PeriodeAwal and :PeriodeAkhir AND KODE_JENIS_RAWAT =:JenisPasien AND BATAL='0'
            ORDER BY 1 DESC
            ");
             $this->db->bind('PeriodeAwal', $PeriodeAwal);
             $this->db->bind('PeriodeAkhir', $PeriodeAkhir);
             $this->db->bind('JenisPasien', $JenisPasien);
                            $data =  $this->db->resultSet();
                            $rows = array();
                            foreach ($data as $key) {
                                $pasing['ID'] = $key['ID'];
                                $pasing['NO_SEP'] = $key['NO_SEP'];
                                $pasing['NO_KARTU'] = $key['NO_KARTU'];
                                $pasing['NAMA_PESERTA'] = $key['NAMA_PESERTA'];
                                $pasing['NO_REGISTRASI'] = $key['NO_REGISTRASI'];
                                $pasing['NO_MR'] = $key['NO_MR'];
                                $pasing['TGL_SEP'] = date('d/m/Y', strtotime($key['TGL_SEP']));
                                $pasing['IS_EKSEKUTIF'] = $key['IS_EKSEKUTIF'];
                                $pasing['NAMA_POLI'] = $key['NAMA_POLI'];
                                $pasing['NAMA_DOKTER'] = $key['NAMA_DOKTER'];
                                $pasing['KELAS_RAWAT'] = $key['KELAS_RAWAT'];
                                $pasing['DOB'] = date('d/m/Y',strtotime($key['DOB']));
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
    public function KirimData($data)
    {
        $start_dt = $data['start_dt'];
        // $stop_dt = $data['stop_dt'];
        $jenis_rawat = $data['jenis_rawat'];
        $date_type = $data['date_type'];
        // membuat json juga dapat menggunakan json_encode:
        $ws_query["metadata"]["method"] = "send_claim";

        $ws_query["data"]["start_dt"] = $start_dt;
        $ws_query["data"]["stop_dt"] = $start_dt;
        $ws_query["data"]["jenis_rawat"] = $jenis_rawat;
        $ws_query["data"]["date_type"] = $date_type;

        $json_request = json_encode($ws_query);
        // data yang akan dikirimkan dengan method POST adalah encrypted:

        $response =  $this->EklaimApi($json_request);

        $rows = array();
        // var_dump($response);
        // exit;
        $no = 1;
        foreach ($response['response']['data'] as $key) {
            $pasing['bpjs_dc_status'] = $key['bpjs_dc_status'];
            $pasing['kemkes_dc_status'] = $key['kemkes_dc_status'];
            $pasing['nomor_sep'] = $key['nomor_sep'];
            // $pasing['DATE_CREATE'] = date('d/m/Y H:i:s', strtotime($key['DATE_CREATE']));
            $pasing['tgl_pulang'] = $key['tgl_pulang'];
            $rows[] = $pasing;
        }
        return $rows;
        //return $response;
    }

    public function AutoGenerateTarif($data)
    {
        try {
            $id = $data['id'];
            $getreg = substr($id, 0, 2);
            if ($getreg == 'RJ') {
                $query = "	SELECT 
                CAST(isnull(c.TotalLab,0) as INT) as TotalLab, 
                CAST(isnull(c.[Total Radiologi],0) as INT) as TotalRad,
               CAST(isnull(c.TotalObat,0) as INT) as TotalAptk
                ,0 as TotalKamar
                ,CAST(isnull(c.TotalVisit,0) as INT)  as TotalKonsul
                ,0 as  TotalOP
                ,0  as TotalTindakan
                ,
               CAST(isnull(kons.TotalTarif,0) as INT)  as TarifKonsultasi, 
               CAST(isnull(tind.TotalTarif,0) as INT) as TarifTindakan,
               CAST(isnull(pel_darah.TotalTarif,0) as INT) as TarifPelayananDarah,
               CAST(isnull(fisio.TotalTarif,0) as INT) as TarifFisio

                FROM PerawatanSQL.dbo.View_VisitExtnded c 
                outer apply (SELECT sum(z.Quantity*z.Tarif*(1-Discount)) as TotalTarif,NoRegistrasi FROM PerawatanSQL.dbo.[Visit Details] z
                inner join PerawatanSQL.dbo.Tarif_RJ_UGD zz on z.ProductID=zz.ID
                where NoRegistrasi=c.NoRegistrasi and zz.CategoryProduct='Konsultasi'
                group by NoRegistrasi) kons
                outer apply (SELECT sum(z.Quantity*z.Tarif*(1-z.Discount)) as TotalTarif,NoRegistrasi FROM PerawatanSQL.dbo.[Visit Details] z
                inner join PerawatanSQL.dbo.Tarif_RJ_UGD zz on z.ProductID=zz.ID
                where NoRegistrasi=c.NoRegistrasi and zz.CategoryProduct not in ('Konsultasi','Tindakan Fisioteraphy') and z.NamaProduct not like '%hemodialisa%' 
                group by NoRegistrasi) tind
                outer apply (SELECT sum(z.Quantity*z.Tarif*(1-z.Discount)) as TotalTarif,NoRegistrasi FROM PerawatanSQL.dbo.[Visit Details] z
                inner join PerawatanSQL.dbo.Tarif_RJ_UGD zz on z.ProductID=zz.ID
                where NoRegistrasi=c.NoRegistrasi and zz.CategoryProduct<>'Konsultasi' and z.NamaProduct  like '%hemodialisa%'
                group by NoRegistrasi) pel_darah
                outer apply (SELECT sum(z.Quantity*z.Tarif*(1-z.Discount)) as TotalTarif,NoRegistrasi FROM PerawatanSQL.dbo.[Visit Details] z
                inner join PerawatanSQL.dbo.Tarif_RJ_UGD zz on z.ProductID=zz.ID
                where NoRegistrasi=c.NoRegistrasi and zz.CategoryProduct ='Tindakan Fisioteraphy'
                group by NoRegistrasi) fisio
                where c.NoRegistrasi=:id
                ";
            }else{
                    $query = "SELECT 
                    CAST(isnull(b.TotalLab,0)+isnull(c.TotalLab,0) as INT) as TotalLab, 
                    isnull(b.TotalRadiologi,0)+isnull(c.[Total Radiologi],0) as TotalRad,
                    CAST(isnull(b.TotalResep,0)+isnull(c.TotalObat,0) as INT) as TotalAptk
                    , CAST(isnull(b.biayaKamar,0)+isnull(b.BiayaAdmin,0)+isnull(a.materai,0) as INT) as TotalKamar
                    , CAST(isnull(b.TotalVisit,0)+isnull(c.TotalVisit,0) as INT)  as TotalKonsul
                    , CAST(isnull(b.TotalTindakan,0) as INT) as TotalOP
                    ,0  as TotalTindakan
                    ,0 as TarifKonsultasi,0 as TarifTindakan,0 as TarifPelayananDarah,0 as TarifFisio

 FROM RawatInapSQL.dbo.Inpatient a
 inner join RawatInapSQL.dbo.View_SummeryRawatInap b on a.NoRegRI=b.NoRegRI
 left join PerawatanSQL.dbo.View_VisitExtnded c on a.NoRegisRwj=c.NoRegistrasi
 where a.NoRegRI=:id";

            }

            $this->db->query($query);
             
             $this->db->bind('id', $id); 
             $key =  $this->db->single();
             $pasing['TotalLab'] = $key['TotalLab'];
             $pasing['TotalRad'] = $key['TotalRad'];
             $pasing['TotalAptk'] = $key['TotalAptk'];
             $pasing['TotalOP'] = $key['TotalOP'];
             $pasing['TotalKamar'] = $key['TotalKamar'];
             $pasing['TotalKonsul'] = $key['TotalKonsul'];
             $pasing['TotalTindakan'] = $key['TotalTindakan'];
             $pasing['TarifKonsultasi'] = $key['TarifKonsultasi'];
             $pasing['TarifTindakan'] = $key['TarifTindakan'];
             $pasing['TarifPelayananDarah'] = $key['TarifPelayananDarah'];
             $pasing['TarifFisio'] = $key['TarifFisio'];
             

                            $callback = array(
                                'message' => "success", // Set array nama 
                                'data' => $pasing
                            );
                            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function goGetDatabyNoRegistrasi($data)
    {
        try {
            $id = $data;
            $getreg = substr($id, 0, 2);
            
            if ($getreg == 'RJ') {
                $query = "SELECT c.NoSEP as NO_SEP,c.NoMR NO_MR
                ,v.PatientName NAMA_PESERTA,replace(CONVERT(VARCHAR(11), v.Date_of_birth, 111), '/','-') as DOB,
                                    CASE WHEN v.Gander='L' THEN '1'
                                    ELSE '2' END AS GENDER
                                    ,c.NoRegistrasi as NO_REGISTRASI,c.TglKunjungan as TGL_SEP,c.NoPesertaBPJS NO_KARTU,
                                    null KODE_KELAS_RAWAT, 
                                    replace(CONVERT(VARCHAR(11), c.[Visit Date], 111), '/','-') as StartDate, replace(CONVERT(VARCHAR(11), c.[Visit Date], 111), '/','-') as EndDate,
                                   CONVERT(VARCHAR(8),c.[Visit Date],108) as jamkunjungan,
                                    DATEDIFF(dd, c.[Visit Date], c.[Visit Date])+1 as LOS,'00:00' as JAM_LOS ,
                                   DATEDIFF(yy, v.Date_of_birth, GETDATE()) as UMUR,'-' BeratLahir,d.First_Name NAMA_DOKTER,
                                   '2' AS KODE_JENIS_RAWAT
                                   ,null IS_EKSEKUTIF,null IS_COB,null NAIK_KELAS,
                                   0 TotalLab, 
                                  0 as TotalRad,
                                 0 as TotalAptk
                                   ,0 as TotalKamar
                                   ,0  as TotalKonsul
                                   ,0 as  TotalOP
                                   ,0  as TotalTindakan
                                   ,CASE WHEN c.PatientType='2' THEN n.NamaPerusahaan ELSE m.NamaPerusahaan END AS NamaPenjamin,
                                   null as is_intensif,null as VentiUsed,0  as TarifKonsultasi,0 as TarifTindakan,0 as TarifPelayananDarah,0 as TarifFisio
                FROM PerawatanSQL.dbo.Visit c 
                inner join MasterDataSQL.dbo.Admision v on c.NoMR=v.NoMR
            left join MasterDataSQL.dbo.MstrPerusahaanJPK m on c.Perusahaan=m.ID
            left join MasterDataSQL.dbo.MstrPerusahaanAsuransi n on c.Asuransi=n.ID
            left join MasterdataSQL.dbo.Doctors d on c.Doctor_1=d.ID
                where c.NoRegistrasi=:id";
            }else{
                    $query = "SELECT 
                    a.NoSEP AS NO_SEP
                ,v.PatientName NAMA_PESERTA,replace(CONVERT(VARCHAR(11), v.Date_of_birth, 111), '/','-') as DOB,
                                        CASE WHEN v.Gander='L' THEN '1'
                                        ELSE '2' END AS GENDER
                                        ,a.NoRegRI as NO_REGISTRASI,a.NoMR NO_MR,a.StartDate TGL_SEP,a.NoPesertaBPJS NO_KARTU,
                                       null KODE_KELAS_RAWAT, replace(CONVERT(VARCHAR(11), StartDate, 111), '/','-') as StartDate, 
                                       replace(CONVERT(VARCHAR(11), EndDate, 111), '/','-') as EndDate,
                                       CONVERT(VARCHAR(8),StartTime,108) as jamkunjungan,
                                        DATEDIFF(dd, a.StartDate, a.EndDate)+1 as LOS,'00:00' as JAM_LOS ,
                                       DATEDIFF(yy, v.Date_of_birth, GETDATE()) as UMUR,'-' BeratLahir,dd.First_Name NAMA_DOKTER,
                                        '1' AS KODE_JENIS_RAWAT
                                       ,null IS_EKSEKUTIF,null IS_COB,null NAIK_KELAS,
                                       0 as TotalLab, 
                                      0 as TotalRad,
                                       0 as TotalAptk
                                       , 0 as TotalKamar
                                       , 0  as TotalKonsul
                                       , 0 as TotalOP
                                       ,0  as TotalTindakan
                                       ,CASE WHEN a.TypePatient='2' THEN n.NamaPerusahaan ELSE m.NamaPerusahaan END AS NamaPenjamin,
                                       is_intensif,xx.VentiUsed,0 as TarifKonsultasi,0 as TarifTindakan,0 as TarifPelayananDarah,0 as TarifFisio
                    FROM RawatInapSQL.dbo.Inpatient a
                inner join MasterDataSQL.dbo.Admision v on a.NoMR=v.NoMR
                left join MasterdataSQL.dbo.Doctors dd on a.drPenerima=dd.ID
            left join MasterDataSQL.dbo.MstrPerusahaanJPK m on a.IDJPK=m.ID
            left join MasterDataSQL.dbo.MstrPerusahaanAsuransi n on a.IDAsuransi=n.ID
            outer apply (SELECT sum(LamaRawat) as is_intensif FROM RawatInapSQL.dbo.View_LamaRawat where NoRegRI=a.NoRegRI 
            AND Class in ('ICU','NICU','PICU','NEONATUS','HCU','ISOLASI HCU','ISOLASI HCCU')) x
            outer apply (SELECT datediff(hour, min(Tgl),max(Tgl)) as VentiUsed  from MedicalRecord.dbo.MR_Ventilasi_ICU 
            where NoEpisode collate Latin1_General_CI_AS=a.NoEpisode) xx
                    where a.NoRegRI=:id";

            }

            $this->db->query($query);
             
             $this->db->bind('id', $id); 
             //$this->db->bind('id2', $id); 
             $key =  $this->db->single();
             $pasing['NO_SEP'] = $key['NO_SEP'];
             $pasing['NAMA_PESERTA'] = $key['NAMA_PESERTA'];
             $pasing['DOB'] = $key['DOB'];
             $pasing['GENDER'] = $key['GENDER'];
             $pasing['NO_REGISTRASI'] = $key['NO_REGISTRASI'];
             $pasing['NO_MR'] = $key['NO_MR'];
             $pasing['TGL_SEP'] = $key['TGL_SEP'];
             $pasing['NO_KARTU'] = $key['NO_KARTU'];
             $pasing['KODE_KELAS_RAWAT'] = $key['KODE_KELAS_RAWAT'];
             $pasing['StartDate'] = $key['StartDate'];
             $pasing['EndDate'] = $key['EndDate'];
             $pasing['LOS'] = $key['LOS'];
             $pasing['JAM_LOS'] = $key['JAM_LOS'];
             $pasing['UMUR'] = $key['UMUR'];
             $pasing['BeratLahir'] = $key['BeratLahir'];
             $pasing['NAMA_DOKTER'] = $key['NAMA_DOKTER'];
             //$pasing['ID_EKLAIM'] = $key['ID_EKLAIM'];
             $pasing['KODE_JENIS_RAWAT'] = $key['KODE_JENIS_RAWAT'];
             $pasing['IS_EKSEKUTIF'] = $key['IS_EKSEKUTIF'];
             $pasing['IS_COB'] = $key['IS_COB'];
             $pasing['NAIK_KELAS'] = $key['NAIK_KELAS'];
             $pasing['jamkunjungan'] = $key['jamkunjungan'];
             $pasing['TotalLab'] = $key['TotalLab'];
             $pasing['TotalRad'] = $key['TotalRad'];
             $pasing['TotalAptk'] = $key['TotalAptk'];
             $pasing['TotalOP'] = $key['TotalOP'];
             $pasing['TotalKamar'] = $key['TotalKamar'];
             $pasing['TotalKonsul'] = $key['TotalKonsul'];
             $pasing['TotalTindakan'] = $key['TotalTindakan'];

             $pasing['NamaPenjamin'] = $key['NamaPenjamin'];
             $pasing['is_intensif'] = $key['is_intensif'];
             $pasing['VentiUsed'] = $key['VentiUsed'];
             
             $pasing['TarifKonsultasi'] = $key['TarifKonsultasi'];
             $pasing['TarifTindakan'] = $key['TarifTindakan'];
             
             $pasing['TarifPelayananDarah'] = $key['TarifPelayananDarah'];
             $pasing['TarifFisio'] = $key['TarifFisio'];
             

                            $callback = array(
                                'message' => "success", // Set array nama 
                                'data' => $pasing,
                                'is_bridging' => false,
                            );
                            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function CopyDiagnosaEMR($data)
    {
        try {
            $this->db->transaksi();


            if ($data['ID_EKLAIM'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'ID Klaim Tidak Ditemukan ! Silahkan Buat Klaim Baru !',
                );
                return $callback;
                exit;
            }

            $ID_EKLAIM = $data['ID_EKLAIM'];
            $nomor_registrasi = $data['nomor_registrasi'];
            $TGLNOW = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $namauser = $session->name;
            $nomor_sep = $data['nomor_sep'];
            $payor_id = $data['payor_id'];

            $this->db->query("SELECT COUNT(ID) as cekdiagnosa from DashboardData.dbo.EKLAIM_DTL_DIAGNOSA
            WHERE ID_EKLAIM=:ID_EKLAIM");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $cekdiagnosa =  $this->db->single();
            if ($cekdiagnosa['cekdiagnosa'] > 0) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kosongkan Diagnosa ICD-10 jika ingin import diagnosa dari EMR !',
                );
                return $callback;
                exit;
            }

            $this->db->query("SELECT COUNT(ID) as cekdiagnosa from DashboardData.dbo.EKLAIM_DTL_PROSEDUR
            WHERE ID_EKLAIM=:ID_EKLAIM");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $cekdiagnosa =  $this->db->single();
            if ($cekdiagnosa['cekdiagnosa'] > 0) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kosongkan Prosedur ICD-9 jika ingin import diagnosa dari EMR !',
                );
                return $callback;
                exit;
            }

            $this->db->query("INSERT INTO DashboardData.dbo.EKLAIM_DTL_DIAGNOSA (ID_EKLAIM,KODE_DIAGNOSA,NAMA_DIAGNOSA,IS_PRIMER,DATE_CREATE,USER_CREATE) 
            SELECT :ID_EKLAIM,b.ICD_CODE,b.DESCRIPTION,header,:DATE_CREATE,:USER_CREATE
             from MasterdataSQL.dbo.ICDX_Transactions a
            inner join MasterdataSQL.dbo.ICDX b on a.id_icd=b.ID
            where NoRegistrasi=:nomor_registrasi AND status='1'");
                $this->db->bind('nomor_registrasi', $nomor_registrasi);
                $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
                $this->db->bind('DATE_CREATE', $TGLNOW);
                $this->db->bind('USER_CREATE', $userid);
                $this->db->execute();

                $this->db->query("INSERT INTO DashboardData.dbo.EKLAIM_DTL_PROSEDUR (ID_EKLAIM,KODE_PROSEDUR,NAMA_PROSEDUR,DATE_CREATE,USER_CREATE) 
                SELECT :ID_EKLAIM,b.ICD_CODE,b.DESCRIPTION,:DATE_CREATE,:USER_CREATE
                 from MasterdataSQL.dbo.ICDX_Transactions_9 a
                inner join MasterdataSQL.dbo.ICDX_9 b on a.id_icd=b.ID
                where NoRegistrasi=:nomor_registrasi AND status='1'");
                    $this->db->bind('nomor_registrasi', $nomor_registrasi);
                    $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
                    $this->db->bind('DATE_CREATE', $TGLNOW);
                    $this->db->bind('USER_CREATE', $userid);
                    $this->db->execute();

           

            //GET DIAGNOSA FROM TABLE
            $this->db->query("SELECT KODE_DIAGNOSA FROM DashboardData.dbo.EKLAIM_DTL_DIAGNOSA
                                           where ID_EKLAIM=:ID_EKLAIM 
                                           order by IS_PRIMER desc");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $datas =  $this->db->resultSet();
            $rows = array();
            foreach ($datas as $key) {
                $rows[] = $key['KODE_DIAGNOSA'];
            }

            if (count($datas) > 0) {
                $diagnosa = implode("#", $rows);
                $separator = '#';
            } else {
                $separator = null;
                $diagnosa = null;
            }
            //$diagnosa .= $separator . $kode_diagnosa;

            //GET PROSEDUR FROM TABLE
            $this->db->query("SELECT KODE_PROSEDUR FROM DashboardData.dbo.EKLAIM_DTL_PROSEDUR
         where ID_EKLAIM=:ID_EKLAIM order by ID ASC");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $datas2 =  $this->db->resultSet();
            $rows2 = array();
            foreach ($datas2 as $key) {
                $rows2[] = $key['KODE_PROSEDUR'];
            }

            if (count($datas2) > 0) {
                $procedure = implode("#", $rows2);
                $separator = '#';
            } else {
                $separator = null;
                $procedure = null;
            }

            $coder_nik = $this->getcoderNIK();
            $ws_query["metadata"]["method"] = "set_claim_data";
            $ws_query["metadata"]["nomor_sep"] = $nomor_sep;

            $ws_query["data"]["diagnosa"] =  $diagnosa;
            $ws_query["data"]["procedure"] =  $procedure;
            $ws_query["data"]["coder_nik"] =  $coder_nik;
            $ws_query["data"]["payor_id"] =  $payor_id;

            $json_request = json_encode($ws_query);

            $response =  $this->EklaimApi($json_request);


                // $this->db->query("SELECT ID from DashboardData.dbo.EKLAIM_DTL_DIAGNOSA
                // where ID_EKLAIM=:ID_EKLAIM and IS_PRIMER='1'");
                // $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
                // $data =  $this->db->resultSet();
                // if (count($data) > 0) {
                //     $is_primer = '0';
                // } else {
                //     $is_primer = '1';
                // }

                if ($response['metadata']['code'] == 200) {
                    $this->db->commit();
                    $callback = array(
                        'status' => 'success',
                        'message' => 'Diagnosa Berhasil Ditambahkan !', 
                    );
                }else{
                    $this->db->rollback();
                    $callback = array(
                        'status' => 'danger',
                        'message' => $response['metadata']['message']
                    );
                }
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function search_diagnosis_new($data)
    {
        $keyword = $data['keyword'];
        // membuat json juga dapat menggunakan json_encode:
        $ws_query["metadata"]["method"] = "search_diagnosis";

        $ws_query["data"]["keyword"] = $keyword;

        $json_request = json_encode($ws_query);
        // data yang akan dikirimkan dengan method POST adalah encrypted:

        $response =  $this->EklaimApi($json_request);

        if ($response['metadata']['code'] == 200){
            if ($response['response']['data'] != 'EMPTY'){
            foreach ($response['response']['data'] as $key => $jsons) { // This will search in the 2 jsons
                $pasing['id'] = $jsons[1];
                $pasing['nama_diagnosa'] = $jsons[0];
                $pasing['label'] = $jsons[0] . ' - ' . $jsons[1];
                $datas[] = $pasing;
            }
        }else{
            $pasing['id'] = null;
            $pasing['nama_diagnosa'] = null;
            $pasing['label'] = ' -- Data Tidak Ditemukan ! -- ';
            $datas[] = $pasing;
        }
        }
        return $datas;

    }

    public function search_procedures_new($data)
    {
        $keyword = $data['keyword'];
        // membuat json juga dapat menggunakan json_encode:
        $ws_query["metadata"]["method"] = "search_procedures";

        $ws_query["data"]["keyword"] = $keyword;

        $json_request = json_encode($ws_query);
        // data yang akan dikirimkan dengan method POST adalah encrypted:

        $response =  $this->EklaimApi($json_request);

        if ($response['metadata']['code'] == 200){
            if ($response['response']['data'] != 'EMPTY'){
            foreach ($response['response']['data'] as $key => $jsons) { // This will search in the 2 jsons
                $pasing['id'] = $jsons[1];
                $pasing['nama_procedure'] = $jsons[0];
                $pasing['label'] = $jsons[0] . ' - ' . $jsons[1];
                $datas[] = $pasing;
            }
        }else{
            $pasing['id'] = null;
            $pasing['nama_procedure'] = null;
            $pasing['label'] = ' -- Data Tidak Ditemukan ! -- ';
            $datas[] = $pasing;
        }
        }
        return $datas;
    }

    public function sitb_validate($data)
    {
        try {
        $nomor_sep = $data['nomor_sep'];
        $nomor_registrasi = $data['nomor_registrasi'];
        $nomor_register_sitb = $data['nomor_register_sitb'];
        $ID_EKLAIM = $data['ID_EKLAIM'];

        if ($ID_EKLAIM == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'ID Eklaim Kosong !',
            );
            echo json_encode($callback);
            exit;
        }

        // membuat json juga dapat menggunakan json_encode:
        $ws_query["metadata"]["method"] = "sitb_validate";

        $ws_query["data"]["nomor_sep"] = $nomor_sep;
        $ws_query["data"]["nomor_register_sitb"] = $nomor_register_sitb;

        $json_request = json_encode($ws_query);
        // data yang akan dikirimkan dengan method POST adalah encrypted:

        $response =  $this->EklaimApi($json_request);
        if ($response['metadata']['code'] == 200) {
            if ($response['response']['status'] != 'INVALID'){

                $TGLNOW = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $namauser = $session->name;

            $this->db->query("UPDATE DashboardData.[dbo].[EKLAIM]
                    SET
                    [NO_REGISTER_SITB] =:nomor_register_sitb
                    WHERE ID=:ID_EKLAIM
                    ");

            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $this->db->bind('nomor_register_sitb', $nomor_register_sitb);
            $this->db->execute();

            //INSERT KE LOG-----------
            $this->db->query("INSERT INTO DashboardData.dbo.LOG_EKLAIM (ID_EKLAIM,NO_REGISTRASI,KETERANGAN,DATE_UPDATE,USER_UPDATE) VALUES
              (:ID_EKLAIM,:NO_REGISTRASI,:KETERANGAN,:DATE_UPDATE,:USER_UPDATE)");
            $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
            $this->db->bind('NO_REGISTRASI', $nomor_registrasi);
            $this->db->bind('KETERANGAN', 'Validasi SITB');
            $this->db->bind('DATE_UPDATE', $TGLNOW);
            $this->db->bind('USER_UPDATE', $userid);
            $this->db->execute();
            //----------------

            $callback = array(
                'status' => 'success',
                'message' => $response['response'],
            );
            

            }else{
                $callback = array(
                    'status' => 'danger',
                    'message' => $response['response']['detail'],
                );
            }

            
            
        } else {
            $callback = array(
                'status' => 'danger',
                'message' => $response['metadata']['message'],
            );
        }
        return $callback;

    } catch (PDOException $e) {
        die($e->getMessage());
    }
    }

    public function sitb_invalidate($data)
    {
        try {
            $nomor_sep = $data['nomor_sep'];
            $nomor_registrasi = $data['nomor_registrasi'];
            $ID_EKLAIM = $data['ID_EKLAIM'];

            // membuat json juga dapat menggunakan json_encode:
            $ws_query["metadata"]["method"] = "sitb_invalidate";

            $ws_query["data"]["nomor_sep"] = $nomor_sep;

            $json_request = json_encode($ws_query);
            // data yang akan dikirimkan dengan method POST adalah encrypted:

            $response =  $this->EklaimApi($json_request);
            
            if ($response['metadata']['code'] == 200) {
    
                    $TGLNOW = Utils::seCurrentDateTime();
                $session = SessionManager::getCurrentSession();
                $userid = $session->username;
                $namauser = $session->name;
    
                $this->db->query("UPDATE DashboardData.[dbo].[EKLAIM]
                        SET
                        [NO_REGISTER_SITB] =null
                        WHERE ID=:ID_EKLAIM
                        ");
    
                $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
                $this->db->execute();
    
                //INSERT KE LOG-----------
                $this->db->query("INSERT INTO DashboardData.dbo.LOG_EKLAIM (ID_EKLAIM,NO_REGISTRASI,KETERANGAN,DATE_UPDATE,USER_UPDATE) VALUES
                  (:ID_EKLAIM,:NO_REGISTRASI,:KETERANGAN,:DATE_UPDATE,:USER_UPDATE)");
                $this->db->bind('ID_EKLAIM', $ID_EKLAIM);
                $this->db->bind('NO_REGISTRASI', $nomor_registrasi);
                $this->db->bind('KETERANGAN', 'Batal Validasi SITB');
                $this->db->bind('DATE_UPDATE', $TGLNOW);
                $this->db->bind('USER_UPDATE', $userid);
                $this->db->execute();
                //----------------
    
                $callback = array(
                    'status' => 'success',
                    'message' => 'SITB berhasil dibatalkan',
                );
    
                
                
            } else {
                $callback = array(
                    'status' => 'danger',
                    'message' => $response['metadata']['message'],
                );
            }
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


}
