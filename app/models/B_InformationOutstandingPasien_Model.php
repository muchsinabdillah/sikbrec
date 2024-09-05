<?php
class  B_InformationOutstandingPasien_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }


    public function getDataListInfoOutstanding($data)
    {
        try {
            $periodeawal = $data['PeriodeAwal'];
            $periodeakhir = $data['PeriodeAkhir'];
            $this->db->query("SELECT a.TglKunjungan,a.NoMR,a.NoRegistrasi,b.PatientName,b.Gander,a.Unit,a.LokasiPasien,a.[Status ID],
            c.First_Name,d.TypePatient ,sum(px.[REGISTRASI Count]) as totalnominal,f.[First Name] as PetugasDaftar
           ,e.[Status Name]  collate SQL_Latin1_General_CP1_CI_AS as namastatus
            from PerawatanSQL.dbo.Visit a
            inner join MasterdataSQL.dbo.Admision b
            on a.NoMR = b.NoMR
            inner join MasterdataSQL.dbo.Doctors c
            on c.ID = a.Doctor_1
            inner join MasterdataSQL.dbo.MstrTypePatient d
            on d.ID = a.PatientType 
            inner join PerawatanSQL.dbo.[Visit Status] e on a.[Status ID]=e.[Status ID]
            inner join MasterdataSQL.dbo.Employees f on f.ID = a.Operator
            inner join (
                 select A.NoRegistrasi,b.TglKunjungan,C.PatientName,d.NamaUnit,A.KategoriTarif AS [Quarter],SUM(isnull(A.TotalTarif,0)) as [REGISTRASI Count]
                from PerawatanSQL.dbo.[Visit Details] A
                INNER JOIN PerawatanSQL.DBO.Visit B ON A.NoRegistrasi = B.NoRegistrasi
                INNER JOIN MasterdataSQL.DBO.Admision C ON C.NoMR = B.NoMR
                INNER JOIN MasterdataSQL.DBO.MstrUnitPerwatan D ON D.ID = B.Unit
                where replace(CONVERT(VARCHAR(11), B.TglKunjungan, 111), '/','-')  BETWEEN '$periodeawal' and '$periodeakhir'
                 and b.Batal='0'
                GROUP BY  A.NoRegistrasi,C.PatientName,d.NamaUnit,A.KategoriTarif,b.TglKunjungan
                UNION ALL
                select A2.NoRegRI,b.TglKunjungan,C.PatientName,d.NamaUnit,'Laboratorium' AS [Quarter],SUM(isnull(A.Tarif,0)) as [REGISTRASI Count]
                from  LaboratoriumSQL.dbo.tblLabDetail  A
                inner join LaboratoriumSQL.dbo.tblLab a2 on a2.LabID = a.LabID
                INNER JOIN PerawatanSQL.DBO.Visit B ON A2.NoRegRI = B.NoRegistrasi
                INNER JOIN MasterdataSQL.DBO.Admision C ON C.NoMR = B.NoMR
                INNER JOIN MasterdataSQL.DBO.MstrUnitPerwatan D ON D.ID = B.Unit
                where replace(CONVERT(VARCHAR(11), B.TglKunjungan, 111), '/','-')  BETWEEN '$periodeawal' and '$periodeakhir'
                 and b.Batal='0' and  a.Batal='0'
                GROUP BY  A2.NoRegRI,C.PatientName,d.NamaUnit,b.TglKunjungan
                UNION ALL
                select A.NoRegistrasi,b.TglKunjungan,C.PatientName,d.NamaUnit,'Radiologi' AS [Quarter],SUM(isnull(A.Service_Charge,0)) as [REGISTRASI Count]
                from RadiologiSQL.dbo.WO_RADIOLOGY A
                INNER JOIN PerawatanSQL.DBO.Visit B ON A.NoRegistrasi = B.NoRegistrasi
                INNER JOIN MasterdataSQL.DBO.Admision C ON C.NoMR = B.NoMR
                INNER JOIN MasterdataSQL.DBO.MstrUnitPerwatan D ON D.ID = B.Unit
                where replace(CONVERT(VARCHAR(11), B.TglKunjungan, 111), '/','-')  BETWEEN '$periodeawal' and '$periodeakhir'
                 and b.Batal='0'  and a.Batal='0'
                GROUP BY  A.NoRegistrasi,C.PatientName,d.NamaUnit ,b.TglKunjungan
                union all
                select A.NoRegistrasi,b.TglKunjungan,C.PatientName,d.NamaUnit,'Farmasi' AS [Quarter],
               SUM(isnull(A2.QtyRealisasi*[Unit Price]*(1-a2.Discount),0)) as [REGISTRASI Count]
                from  [Apotik_V1.1SQL].dbo.Orders  A
                inner join [Apotik_V1.1SQL].dbo.[Order Details] a2 on a2.[Order ID] = a.[Order ID]
                INNER JOIN PerawatanSQL.DBO.Visit B ON A.NoRegistrasi = B.NoRegistrasi
                INNER JOIN MasterdataSQL.DBO.Admision C ON C.NoMR = B.NoMR
                INNER JOIN MasterdataSQL.DBO.MstrUnitPerwatan D ON D.ID = B.Unit
                where replace(CONVERT(VARCHAR(11), B.TglKunjungan, 111), '/','-')  BETWEEN '$periodeawal' and '$periodeakhir'
                 and b.Batal='0' and  a.OrderBatal='0'
                GROUP BY  A.NoRegistrasi,C.PatientName,d.NamaUnit,b.TglKunjungan
                UNION ALL
                select A.NoRegistrasi,A.tglResep AS TglKunjungan,A.[Ship Name] AS PatientName,'FARMASI' AS NamaUnit,
             'Farmasi' AS [Quarter],
             SUM(isnull(A2.QtyRealisasi*[Unit Price]*(1-a2.Discount),0)) as [REGISTRASI Count]
                from  [Apotik_V1.1SQL].dbo.Orders  A
                inner join [Apotik_V1.1SQL].dbo.[Order Details] a2 on a2.[Order ID] = a.[Order ID]
                where replace(CONVERT(VARCHAR(11), A.tglResep, 111), '/','-')  BETWEEN '$periodeawal' and '$periodeakhir'
                AND A.OrderBatal='0' and  a.OrderBatal='0'   AND LEFT(NoResep,1)='B'
                GROUP BY  A.NoRegistrasi,A.[Ship Name],A.tglResep
                union all
               select A.NoRegistrasi,b.TglKunjungan,C.PatientName,d.NamaUnit as NamaUnit,'Paket' AS [Quarter],SUM(isnull(A.harga,0)) as [REGISTRASI Count]
                from RawatInapSQL.dbo.[Inpatient_Paket_Operasi] A
                INNER JOIN PerawatanSQL.DBO.Visit B ON A.NoRegistrasi = B.NoRegistrasi
                INNER JOIN MasterdataSQL.DBO.Admision C ON C.NoMR = B.NoMR
              INNER JOIN MasterdataSQL.DBO.MstrUnitPerwatan D ON D.ID = B.Unit
                where replace(CONVERT(VARCHAR(11), B.TglKunjungan, 111), '/','-')  BETWEEN '$periodeawal' and '$periodeakhir'
                GROUP BY  A.NoRegistrasi,C.PatientName,b.TglKunjungan,d.NamaUnit
                 
            )px on px.NoRegistrasi = a.NoRegistrasi
            where replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') between '$periodeawal' and '$periodeakhir'
            and a.Batal='0' and a.[Status ID]<'4'  
            group by a.TglKunjungan,a.NoMR,a.NoRegistrasi,b.PatientName,b.Gander,a.Unit,a.LokasiPasien,a.[Status ID],
            c.First_Name,d.TypePatient,f.[First Name],e.[Status Name]
            UNION ALL 
               select A.tglResep AS TglKunjungan,'-' AS NoMR,A.NoRegistrasi as NoRegistrasi,A.[Ship Name] AS PatientName,'' Gander,'0' Unit,
'Farmasi' LokasiPasien ,b.[Status ID] ,'-' First_Name,
'UMUM' TypePatient ,
SUM(isnull(A2.QtyRealisasi*[Unit Price]*(1-a2.Discount),0)) as totalnominal, '' PetugasDaftar,b.[Status Name] as namastatus
from  [Apotik_V1.1SQL].dbo.Orders  A
inner join [Apotik_V1.1SQL].dbo.[Order Details] a2 on a2.[Order ID] = a.[Order ID]
inner join [Apotik_V1.1SQL].dbo.[Orders Status] b on b.[Status ID] = a.[Status ID]
where replace(CONVERT(VARCHAR(11), A.tglResep, 111), '/','-') between '$periodeawal' and '$periodeakhir'
AND A.OrderBatal='0' and  a.OrderBatal='0'   AND LEFT(NoResep,1)='B' and A.[Status ID]='1'
GROUP BY A.NoRegistrasi,A.[Ship Name],A.tglResep ,b.[Status Name] ,A.[Ship Name] ,b.[Status ID] 
");
            $data =  $this->db->resultSet();
            $rows = array();
            $no = "1";
            foreach ($data as $row) {
                // $pasing['REKENING'] = $row['FS_KD_REKENING']; //(kiri view/JS 'KANAN QUERY')

                // if ($row['Tgl'] == '1900-01-01 00:00:00.000' || $row['Tgl'] == '1990-01-01 00:00:00.000') {
                //     $Tgl = "";
                // } else {
                //     $Tgl = $row['Tgl'];
                // }
                $pasing['NO'] = $no++;
                $pasing['Tgl'] = $row['TglKunjungan'];
                $pasing['NoMR'] = $row['NoMR'];
                $pasing['NoRegistrasi'] = $row['NoRegistrasi'];
                $pasing['PatientName'] = $row['PatientName'];
                $pasing['LokasiPasien'] = $row['LokasiPasien'];
                $pasing['First_Name'] = $row['First_Name'];
                $pasing['TypePatient'] = $row['TypePatient'];
                $pasing['PetugasDaftar'] = $row['PetugasDaftar'];
                $pasing['Status'] = $row['namastatus'];
                $pasing['totalnominal'] = number_format($row['totalnominal'], 2, ',', '.');
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    //Informasi Transaksi Jurnal Front Office Detail//
    public function getDataListverifJurnalFOdetil($data)
    {
        try {
            $noregistrasi = $_POST['REGISTER'];
            $this->db->query("SELECT FS_KD_REG REGISTER,B.FS_KET PASIEN,a.FS_KD_JURNAL KODE_JURNAL, 
            A.FS_KET_REFF BILL, A.FN_DEBET D, A.FN_KREDIT K, A.FS_REK REK, C.FS_NM_REKENING NM_REK
            from keuangan.dbo.TA_JURNAL_DTL a 
            inner join keuangan.dbo.TA_JURNAL_HDR b on a.FS_KD_JURNAL=b.FS_KD_JURNAL
            inner join keuangan.dbo.TM_REKENING c on c.FS_KD_REKENING=a.FS_REK
            where FD_TGL_VOID='1900-01-01 00:00:00.000' OR FD_TGL_VOID='3000-01-01 00:00:00.000' AND  A.FS_KD_REG = '$noregistrasi'
            order by A.FS_KD_JURNAL, C.FS_NM_REKENING, K, D
");
            $data =  $this->db->resultSet();
            $rows = array();
            $no = "1";
            foreach ($data as $row) {
                $pasing['NoRegistrasi'] = $row['REGISTER'];
                $pasing['Nama_pasien'] = $row['PASIEN'];
                $pasing['Kode_jurnal'] = $row['KODE_JURNAL'];
                $pasing['Keterangan'] = $row['BILL'];
                $pasing['Debet'] = number_format($row['D'], 2, ',', '.');
                $pasing['Kredit'] = number_format($row['K'], 2, ',', '.');
                $pasing['Rekening'] = number_format($row['REK'], 2, ',', '.');
                $pasing['Nama_Rekening'] = $row['NM_REK'];
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
