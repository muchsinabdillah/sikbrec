<?php

use \Ramsey\Uiid\Uuid;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;

class B_Info_ICD_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getListPoli()
    {
        try {
            $this->db->query("SELECT ID, NamaUnit
                                  from MasterdataSQL.dbo.MstrUnitPerwatan 
                                  where grup_instalasi in ('PENUNJANG','IGD','RAWAT JALAN') Order by NamaUnit");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['NamaUnit'] = $key['NamaUnit'];
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
    public function getDokter()
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

    public function getDataRekap($data)
    {
        try {

            // var_dump($data);
            // exit;

            $tglawal = $data['TglAwal'];
            $tglakhir = $data['TglAkhir'];
            $Poli = $data['Poli']; //nama kasir
            $jenisinfo = $data['jenisinfo']; //pasien apa
            $Dokter = $data['Dokter']; //pembayaran apa

            // $GrupPerawatan = $data['GrupPerawatan']; //ID unit

            if ($jenisinfo == '1') {
                //PASIEN IGD

                $query = " SELECT   b.ICD_CODE,b.DESCRIPTION, count(a.id) as TOTAL
                    FROM  MasterdataSQL.dbo.ICDX_Transactions a
                    INNER JOIN MasterdataSQL.DBO.ICDX B
                    ON A.id_icd = B.ID
                     where replace(CONVERT(VARCHAR(11), a.Waktu_input, 111), '/','-')  between :tglawal and :tglakhir
                    group by   b.ICD_CODE,b.DESCRIPTION
                    order by count(a.id) desc
                    
            ";
                $this->db->query($query);
                $this->db->bind('tglawal', $tglawal);
                $this->db->bind('tglakhir', $tglakhir);

                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['ICD_CODE'] = $row['ICD_CODE'];
                    $pasing['DESCRIPTION'] = $row['DESCRIPTION'];
                    $pasing['TOTAL'] = $row['TOTAL'];
                    $rows[] = $pasing;
                }
                //return $rows;
            } elseif ($jenisinfo == '2') {

                if ($Poli == '1') {
                    $query = " SELECT c.NamaUnit,b.ICD_CODE,b.DESCRIPTION, count(a.id) total
                    FROM  MasterdataSQL.dbo.ICDX_Transactions a
                    INNER JOIN MasterdataSQL.DBO.ICDX B
                    ON A.id_icd = B.ID
                    inner join DashboardData.dbo.dataRWJ c
                    on c.NoRegistrasi = a.NoRegistrasi
                     where replace(CONVERT(VARCHAR(11), a.Waktu_input, 111), '/','-')  between :tglawal and :tglakhir
                     group by  c.NamaUnit,b.ICD_CODE,b.DESCRIPTION
                     order by NamaUnit asc , count(a.id) desc  ";
                    $this->db->query($query);
                    $this->db->bind('tglawal', $tglawal);
                    $this->db->bind('tglakhir', $tglakhir);
                    $data =  $this->db->resultSet();
                } else {
                    $query = " SELECT c.NamaUnit,b.ICD_CODE,b.DESCRIPTION, count(a.id) total
                    FROM  MasterdataSQL.dbo.ICDX_Transactions a
                    INNER JOIN MasterdataSQL.DBO.ICDX B
                    ON A.id_icd = B.ID
                    inner join DashboardData.dbo.dataRWJ c
                    on c.NoRegistrasi = a.NoRegistrasi
                     where replace(CONVERT(VARCHAR(11), a.Waktu_input, 111), '/','-')  between :tglawal and :tglakhir and c.NamaUnit=:Poli
                     group by  c.NamaUnit,b.ICD_CODE,b.DESCRIPTION
                     order by NamaUnit asc , count(a.id) desc
                        
                ";
                    $this->db->query($query);
                    $this->db->bind('Poli', $Poli);
                    $this->db->bind('tglawal', $tglawal);
                    $this->db->bind('tglakhir', $tglakhir);
                    $data =  $this->db->resultSet();
                }
                $this->db->bind('tglawal', $tglawal);
                $this->db->bind('tglakhir', $tglakhir);
                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['Poli'] = $row['NamaUnit'];
                    $pasing['ICD_CODE'] = $row['ICD_CODE'];
                    $pasing['DESCRIPTION'] = $row['DESCRIPTION'];
                    $pasing['TOTAL'] = $row['TOTAL'];
                    $rows[] = $pasing;
                }
            } elseif ($jenisinfo == '3') {

                if ($Dokter == '1') {
                    $query = " SELECT c.NamaDokter,b.ICD_CODE,b.DESCRIPTION, count(a.id) total
                    FROM  MasterdataSQL.dbo.ICDX_Transactions a
                    INNER JOIN MasterdataSQL.DBO.ICDX B
                    ON A.id_icd = B.ID
                    inner join DashboardData.dbo.dataRWJ c
                    on c.NoRegistrasi = a.NoRegistrasi
                     where replace(CONVERT(VARCHAR(11), a.Waktu_input, 111), '/','-')  between :tglawal and :tglakhir 
                     group by  c.NamaDokter,b.ICD_CODE,b.DESCRIPTION
                     order by NamaDokter asc , count(a.id) desc
                    ";
                    $this->db->query($query);
                    $this->db->bind('tglawal', $tglawal);
                    $this->db->bind('tglakhir', $tglakhir);
                    $data =  $this->db->resultSet();
                } else {
                    $query = " SELECT c.NamaDokter,b.ICD_CODE,b.DESCRIPTION, count(a.id) total
                    FROM  MasterdataSQL.dbo.ICDX_Transactions a
                    INNER JOIN MasterdataSQL.DBO.ICDX B
                    ON A.id_icd = B.ID
                    inner join DashboardData.dbo.dataRWJ c
                    on c.NoRegistrasi = a.NoRegistrasi
                     where replace(CONVERT(VARCHAR(11), a.Waktu_input, 111), '/','-')  between :tglawal and :tglakhir and c.NamaDokter=:Dokter
                     group by  c.NamaDokter,b.ICD_CODE,b.DESCRIPTION
                     order by NamaDokter asc , count(a.id) desc
                    ";
                    $this->db->query($query);
                    $this->db->bind('Dokter', $Dokter);
                    $this->db->bind('tglawal', $tglawal);
                    $this->db->bind('tglakhir', $tglakhir);
                    $data =  $this->db->resultSet();
                }
                $this->db->bind('tglawal', $tglawal);
                $this->db->bind('tglakhir', $tglakhir);
                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['Dokter'] = $row['NamaDokter'];
                    $pasing['ICD_CODE'] = $row['ICD_CODE'];
                    $pasing['DESCRIPTION'] = $row['DESCRIPTION'];
                    $pasing['TOTAL'] = $row['TOTAL'];
                    $rows[] = $pasing;
                }
            } elseif ($jenisinfo == '4') {

                $query = "  SELECT c.NoEpisode, a.NoRegistrasi,c.nomr ,c.PatientName,c.NamaUnit, c.[Visit Date] as tgl,a.Petugas_Input,  b.ICD_CODE,b.DESCRIPTION ,a.Waktu_input
                FROM  MasterdataSQL.dbo.ICDX_Transactions a
                INNER JOIN MasterdataSQL.DBO.ICDX B
                ON A.id_icd = B.ID
                inner join DashboardData.dbo.dataRWJ c
                on c.NoRegistrasi = a.NoRegistrasi
                 where replace(CONVERT(VARCHAR(11), a.Waktu_input, 111), '/','-')  between :tglawal and :tglakhir
                 order by a.id desc";

                $this->db->query($query);
                $this->db->bind('tglawal', $tglawal);
                $this->db->bind('tglakhir', $tglakhir);
                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;


                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NoEpisode'] = $row['NoEpisode'];
                    $pasing['NoRegistrasi'] = $row['NoRegistrasi'];
                    $pasing['nomr'] = $row['nomr'];
                    $pasing['PatientName'] = $row['PatientName'];
                    $pasing['NamaUnit'] = $row['NamaUnit'];
                    $pasing['[Visit Date]'] = $row['tgl'];
                    $pasing['Petugas_Input'] = $row['Petugas_Input'];
                    $pasing['ICD_CODE'] = $row['ICD_CODE'];
                    $pasing['DESCRIPTION'] = $row['DESCRIPTION'];
                    $pasing['Waktu_input'] = $row['Waktu_input'];

                    $rows[] = $pasing;
                }
            }

            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDataRekap9($data)
    {
        try {

            $tglawal = $data['TglAwal'];
            $tglakhir = $data['TglAkhir'];
            $Poli = $data['Poli']; //nama kasir
            $jenisinfo = $data['jenisinfo']; //pasien apa
            $Dokter = $data['Dokter']; //pembayaran apa

            // $GrupPerawatan = $data['GrupPerawatan']; //ID unit

            if ($jenisinfo == '1') {
                //PASIEN IGD

                $query = " SELECT   b.ICD_CODE,b.DESCRIPTION, count(a.id) as TOTAL
                    FROM  MasterdataSQL.dbo.ICDX_Transactions_9 a
                    INNER JOIN MasterdataSQL.DBO.ICDX_9 B
                    ON A.id_icd = B.ID
                     where replace(CONVERT(VARCHAR(11), a.Waktu_input, 111), '/','-')  between :tglawal and :tglakhir
                    group by   b.ICD_CODE,b.DESCRIPTION
                    order by count(a.id) desc
                    
            ";
                $this->db->query($query);
                $this->db->bind('tglawal', $tglawal);
                $this->db->bind('tglakhir', $tglakhir);

                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['ICD_CODE'] = $row['ICD_CODE'];
                    $pasing['DESCRIPTION'] = $row['DESCRIPTION'];
                    $pasing['TOTAL'] = $row['TOTAL'];
                    $rows[] = $pasing;
                }
                //return $rows;
            } elseif ($jenisinfo == '2') {

                if ($Poli == '1') {
                    $query = " SELECT c.NamaUnit,b.ICD_CODE,b.DESCRIPTION, count(a.id) total
                    FROM  MasterdataSQL.dbo.ICDX_Transactions_9 a
                    INNER JOIN MasterdataSQL.DBO.ICDX_9 B
                    ON A.id_icd = B.ID
                    inner join DashboardData.dbo.dataRWJ c
                    on c.NoRegistrasi = a.NoRegistrasi
                     where replace(CONVERT(VARCHAR(11), a.Waktu_input, 111), '/','-')  between :tglawal and :tglakhir
                     group by  c.NamaUnit,b.ICD_CODE,b.DESCRIPTION
                     order by NamaUnit asc , count(a.id) desc  ";
                    $this->db->query($query);
                    $this->db->bind('tglawal', $tglawal);
                    $this->db->bind('tglakhir', $tglakhir);
                    $data =  $this->db->resultSet();
                } else {
                    $query = " SELECT c.NamaUnit,b.ICD_CODE,b.DESCRIPTION, count(a.id) total
                    FROM  MasterdataSQL.dbo.ICDX_Transactions_9 a
                    INNER JOIN MasterdataSQL.DBO.ICDX_9 B
                    ON A.id_icd = B.ID
                    inner join DashboardData.dbo.dataRWJ c
                    on c.NoRegistrasi = a.NoRegistrasi
                     where replace(CONVERT(VARCHAR(11), a.Waktu_input, 111), '/','-')  between :tglawal and :tglakhir and c.NamaUnit=:Poli
                     group by  c.NamaUnit,b.ICD_CODE,b.DESCRIPTION
                     order by NamaUnit asc , count(a.id) desc
                        
                ";
                    $this->db->query($query);
                    $this->db->bind('Poli', $Poli);
                    $this->db->bind('tglawal', $tglawal);
                    $this->db->bind('tglakhir', $tglakhir);
                    $data =  $this->db->resultSet();
                }
                $this->db->bind('tglawal', $tglawal);
                $this->db->bind('tglakhir', $tglakhir);
                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['Poli'] = $row['NamaUnit'];
                    $pasing['ICD_CODE'] = $row['ICD_CODE'];
                    $pasing['DESCRIPTION'] = $row['DESCRIPTION'];
                    $pasing['TOTAL'] = $row['TOTAL'];
                    $rows[] = $pasing;
                }
            } elseif ($jenisinfo == '3') {

                if ($Dokter == '1') {
                    $query = " SELECT c.NamaDokter,b.ICD_CODE,b.DESCRIPTION, count(a.id) total
                    FROM  MasterdataSQL.dbo.ICDX_Transactions_9 a
                    INNER JOIN MasterdataSQL.DBO.ICDX_9 B
                    ON A.id_icd = B.ID
                    inner join DashboardData.dbo.dataRWJ c
                    on c.NoRegistrasi = a.NoRegistrasi
                     where replace(CONVERT(VARCHAR(11), a.Waktu_input, 111), '/','-')  between :tglawal and :tglakhir 
                     group by  c.NamaDokter,b.ICD_CODE,b.DESCRIPTION
                     order by NamaDokter asc , count(a.id) desc
                    ";
                    $this->db->query($query);
                    $this->db->bind('tglawal', $tglawal);
                    $this->db->bind('tglakhir', $tglakhir);
                    $data =  $this->db->resultSet();
                } else {
                    $query = " SELECT c.NamaDokter,b.ICD_CODE,b.DESCRIPTION, count(a.id) total
                    FROM  MasterdataSQL.dbo.ICDX_Transactions a
                    INNER JOIN MasterdataSQL.DBO.ICDX B
                    ON A.id_icd = B.ID
                    inner join DashboardData.dbo.dataRWJ c
                    on c.NoRegistrasi = a.NoRegistrasi
                     where replace(CONVERT(VARCHAR(11), a.Waktu_input, 111), '/','-')  between :tglawal and :tglakhir and c.NamaDokter=:Dokter
                     group by  c.NamaDokter,b.ICD_CODE,b.DESCRIPTION
                     order by NamaDokter asc , count(a.id) desc
                    ";
                    $this->db->query($query);
                    $this->db->bind('Dokter', $Dokter);
                    $this->db->bind('tglawal', $tglawal);
                    $this->db->bind('tglakhir', $tglakhir);
                    $data =  $this->db->resultSet();
                }
                $this->db->bind('tglawal', $tglawal);
                $this->db->bind('tglakhir', $tglakhir);
                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['Dokter'] = $row['NamaDokter'];
                    $pasing['ICD_CODE'] = $row['ICD_CODE'];
                    $pasing['DESCRIPTION'] = $row['DESCRIPTION'];
                    $pasing['TOTAL'] = $row['TOTAL'];
                    $rows[] = $pasing;
                }
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataOutStanding($data)
    {
        try {

            $tglawal = $data['TglAwal'];
            $tglakhir = $data['TglAkhir'];
            $jenisinfo = $data['jenisinfo']; //pasien apa

            // $GrupPerawatan = $data['GrupPerawatan']; //ID unit

            if ($jenisinfo == '1') {
                //PASIEN IGD

                $query = "SELECT NoEpisode,NoRegistrasi,NoMR,PatientName,[Visit Date] as VisitDate,NamaDokter,NamaUnit
                from DashboardData.dbo.dataRWJ where NoRegistrasi not in (
                SELECT NoRegistrasi
               FROM  MasterdataSQL.dbo.ICDX_Transactions 
                where replace(CONVERT(VARCHAR(11), Waktu_input, 111), '/','-')  between :tglawal and :tglakhir
                group by NoRegistrasi
                )and   replace(CONVERT(VARCHAR(11), [Visit Date], 111), '/','-')  between :tglawal1 and :tglakhir1
            ";
                $this->db->query($query);
                $this->db->bind('tglawal', $tglawal);
                $this->db->bind('tglakhir', $tglakhir);
                $this->db->bind('tglawal1', $tglawal);
                $this->db->bind('tglakhir1', $tglakhir);
                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NoEpisode'] = $row['NoEpisode'];
                    $pasing['NoRegistrasi'] = $row['NoRegistrasi'];
                    $pasing['NoMR'] = $row['NoMR'];
                    $pasing['PatientName'] = $row['PatientName'];
                    $pasing['VisitDate'] = $row['VisitDate'];
                    $pasing['NamaDokter'] = $row['NamaDokter'];
                    $pasing['NamaUnit'] = $row['NamaUnit'];
                    $rows[] = $pasing;
                }
                //return $rows;
            } elseif ($jenisinfo == '2') {

                $query = " SELECT NoEpisode,NoRegistrasi,NoMR,PatientName,datatimestamp
                from DashboardData.dbo.dataRWI where NoRegistrasi not in (
                SELECT NoRegistrasi
               FROM  MasterdataSQL.dbo.ICDX_Transactions 
                where replace(CONVERT(VARCHAR(11), Waktu_input, 111), '/','-')  between :tglawal and :tglakhir
                group by NoRegistrasi
                )and   replace(CONVERT(VARCHAR(11), datatimestamp, 111), '/','-')  between :tglawal1 and :tglakhir1
                        
                ";
                $this->db->query($query);
                $this->db->bind('tglawal', $tglawal);
                $this->db->bind('tglakhir', $tglakhir);
                $this->db->bind('tglawal1', $tglawal);
                $this->db->bind('tglakhir1', $tglakhir);
                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NoEpisode'] = $row['NoEpisode'];
                    $pasing['NoRegistrasi'] = $row['NoRegistrasi'];
                    $pasing['NoMR'] = $row['NoMR'];
                    $pasing['PatientName'] = $row['PatientName'];
                    $pasing['datatimestamp'] = $row['datatimestamp'];
                    $rows[] = $pasing;
                }
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDataICDDetail($data)
    {
        try {

            $tglawal = $data['TglAwal'];
            $tglakhir = $data['TglAkhir'];
            $jenisinfo = $data['jenisinfo']; //pasien apa

            // $GrupPerawatan = $data['GrupPerawatan']; //ID unit

            if ($jenisinfo == '1') {
                //PASIEN IGD

                $query = "SELECT   c.[Visit Date] as tgl,c.nomr,c.NoEpisode, c.NoRegistrasi,c.BL,c.PatientName,c.DateOfBirth,
               CASE WHEN c.Sex='L' THEN 'LAKI-LAKI' WHEN C.Sex='P' THEN 'PEREMPUAN' ELSE '' END AS sex,c.NamaUnit, NamaJaminan , ISNULL(cg.ICDX_CODE,'') as ICDX_CODE,
               ISNULL(cg.ICDX_NAME,'') as ICDX_NAME ,ISNULL(ch.ICD9_CODE,'') as ICD9_CODE,ISNULL(ch.ICD9_NAME,'') as ICD9_NAME
               FROM DashboardData.dbo.dataRWJ c 
                    left join  (
                       SELECT   b.ICD_CODE as ICDX_CODE,b.DESCRIPTION AS ICDX_NAME,a.NoRegistrasi
                               FROM  MasterdataSQL.dbo.ICDX_Transactions a
                               INNER JOIN MasterdataSQL.DBO.ICDX B
                               ON A.id_icd = B.ID
                               inner join DashboardData.dbo.dataRWJ cx
                               on cx.NoRegistrasi = a.NoRegistrasi
                                where replace(CONVERT(VARCHAR(11), cx.[Visit Date], 111), '/','-')  between :tglawal and :tglakhir
                                and cx.NamaJaminan <>'BPJS Kesehatan'
                       
                    )cg
                    ON cg.NoRegistrasi = c.NoRegistrasi
                    left join  (
                                SELECT  b1.ICD_CODE as ICD9_CODE,b1.DESCRIPTION AS ICD9_NAME,a1.NoRegistrasi
                               FROM  MasterdataSQL.dbo.ICDX_Transactions_9 a1
                               INNER JOIN MasterdataSQL.DBO.ICDX_9 b1
                               ON a1.id_icd = b1.ID 
                                 inner join DashboardData.dbo.dataRWJ cx
                               on cx.NoRegistrasi = a1.NoRegistrasi
                               where replace(CONVERT(VARCHAR(11), cx.[Visit Date], 111), '/','-')  between :tglawal1 and :tglakhir1
                               and cx.NamaJaminan <>'BPJS Kesehatan'
                             
                    )ch
                     ON ch.NoRegistrasi = c.NoRegistrasi
                      where replace(CONVERT(VARCHAR(11), c.[Visit Date], 111), '/','-')  between :tglawal2 and :tglakhir2
                                and c.NamaJaminan <>'BPJS Kesehatan'
                                  order by c.[Visit Date] asc
               
            ";
                $this->db->query($query);
                $this->db->bind('tglawal', $tglawal);
                $this->db->bind('tglakhir', $tglakhir);
                $this->db->bind('tglawal1', $tglawal);
                $this->db->bind('tglakhir1', $tglakhir);
                $this->db->bind('tglawal2', $tglawal);
                $this->db->bind('tglakhir2', $tglakhir);
                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['tgl'] = $row['tgl'];
                    $pasing['nomr'] = $row['nomr'];
                    $pasing['NoEpisode'] = $row['NoEpisode'];
                    $pasing['NoRegistrasi'] = $row['NoRegistrasi'];
                    $pasing['BL'] = $row['BL'];
                    $pasing['PatientName'] = $row['PatientName'];
                    $pasing['DateOfBirth'] = $row['DateOfBirth'];
                    $pasing['sex'] = $row['sex'];
                    $pasing['NamaUnit'] = $row['NamaUnit'];
                    $pasing['NamaJaminan'] = $row['NamaJaminan'];
                    $pasing['ICDX_CODE'] = $row['ICDX_CODE'];
                    $pasing['ICDX_NAME'] = $row['ICDX_NAME'];
                    $pasing['ICD9_CODE'] = $row['ICD9_CODE'];
                    $pasing['ICD9_NAME'] = $row['ICD9_NAME'];

                    $rows[] = $pasing;
                }
                //return $rows;
            } elseif ($jenisinfo == '2') {

                $query = "SELECT   c.StartDate,c.nomr,c.NoEpisode, c.NoRegistrasi,c.BL,c.PatientName,c.DateOfBirth,
                CASE WHEN c.Sex='L' THEN 'LAKI-LAKI' WHEN C.Sex='P' THEN 'PEREMPUAN' ELSE '' END AS sex, NamaJaminan , ISNULL(cg.ICDX_CODE,'') as ICDX_CODE,
                ISNULL(cg.ICDX_NAME,'') as ICDX_NAME ,ISNULL(ch.ICD9_CODE,'') as ICD9_CODE,ISNULL(ch.ICD9_NAME,'') as ICD9_NAME
                FROM DashboardData.dbo.dataRWI c 
                     left join  (
                        SELECT   b.ICD_CODE as ICDX_CODE,b.DESCRIPTION AS ICDX_NAME,a.NoRegistrasi
                                FROM  MasterdataSQL.dbo.ICDX_Transactions a
                                INNER JOIN MasterdataSQL.DBO.ICDX B
                                ON A.id_icd = B.ID
                                inner join DashboardData.dbo.dataRWI cx
                                on cx.NoRegistrasi = a.NoRegistrasi
                                 where replace(CONVERT(VARCHAR(11), cx.StartDate, 111), '/','-')  between :tglawal and :tglakhir
                                 and cx.NamaJaminan <>'BPJS Kesehatan'
                        
                     )cg
                     ON cg.NoRegistrasi = c.NoRegistrasi
                     left join  (
                                 SELECT  b1.ICD_CODE as ICD9_CODE,b1.DESCRIPTION AS ICD9_NAME,a1.NoRegistrasi
                                FROM  MasterdataSQL.dbo.ICDX_Transactions_9 a1
                                INNER JOIN MasterdataSQL.DBO.ICDX_9 b1
                                ON a1.id_icd = b1.ID 
                                  inner join DashboardData.dbo.dataRWI cx
                                on cx.NoRegistrasi = a1.NoRegistrasi
                                where replace(CONVERT(VARCHAR(11), cx.StartDate, 111), '/','-')  between :tglawal1 and :tglakhir1
                                and cx.NamaJaminan <>'BPJS Kesehatan'
                              
                     )ch
                      ON ch.NoRegistrasi = c.NoRegistrasi
                       where replace(CONVERT(VARCHAR(11), c.StartDate, 111), '/','-')  between :tglawal2 and :tglakhir2
                                 and c.NamaJaminan <>'BPJS Kesehatan'
                                   order by c.StartDate asc
                
                        
                ";
                $this->db->query($query);
                $this->db->bind('tglawal', $tglawal);
                $this->db->bind('tglakhir', $tglakhir);
                $this->db->bind('tglawal1', $tglawal);
                $this->db->bind('tglakhir1', $tglakhir);
                $this->db->bind('tglawal2', $tglawal);
                $this->db->bind('tglakhir2', $tglakhir);
                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['StartDate'] = $row['StartDate'];
                    $pasing['nomr'] = $row['nomr'];
                    $pasing['NoEpisode'] = $row['NoEpisode'];
                    $pasing['NoRegistrasi'] = $row['NoRegistrasi'];
                    $pasing['BL'] = $row['BL'];
                    $pasing['PatientName'] = $row['PatientName'];
                    $pasing['DateOfBirth'] = $row['DateOfBirth'];
                    $pasing['sex'] = $row['sex'];
                    $pasing['NamaJaminan'] = $row['NamaJaminan'];
                    $pasing['ICDX_CODE'] = $row['ICDX_CODE'];
                    $pasing['ICDX_NAME'] = $row['ICDX_NAME'];
                    $pasing['ICD9_CODE'] = $row['ICD9_CODE'];
                    $pasing['ICD9_NAME'] = $row['ICD9_NAME'];
                    $rows[] = $pasing;
                }
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
