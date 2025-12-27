<?php


class Grafik_KunjuganPasien_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function RekapBulan($data)
    {
        try {
            $no = "1";
            $Info_Date_Start=$data['Info_Date_Start']; 

            $this->db->query("	SELECT    
            case when CONVERT(DATE, A.[Visit Date])=CONVERT(DATE, B.InputDate) then 
            'BARU' ELSE 'LAMA' END As Gander
            ,COUNT(A.NOMR) AS total
            FROM PerawatanSQL.DBO.Visit A
            INNER JOIN MasterdataSQL.DBO.Admision B
            ON A.NoMR = B.NoMR
            WHERE left( CONVERT(DATE, A.[Visit Date]),7)= :Info_Date_Start
            AND [Status ID]='4' AND Batal='0' 
            GROUP BY case when CONVERT(DATE, A.[Visit Date])=CONVERT(DATE, B.InputDate) then 
            'BARU' ELSE 'LAMA' END");
                $this->db->bind('Info_Date_Start', $data['Info_Date_Start']); 
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) { 
                $pasing['Gander'] = $key['Gander'];
                $pasing['value'] = $key['total']; 
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function Harian($data)
    {
        try {
            $no = "1";
            $Info_Date_Start=$data['Info_Date_Start']; 

            $this->db->query(" SELECT tanggal,isnull([BARU],0) as pasienbaru,
			        isnull([LAMA],0) as pasienlama
                    FROM (
                        SELECT    
                        case when CONVERT(DATE, A.[Visit Date])=CONVERT(DATE, B.InputDate) then 
                        'BARU' ELSE 'LAMA' END AS [Quarter],
                        right( CONVERT(DATE, A.[Visit Date]) ,2) tanggal
                        ,COUNT(A.NOMR) AS [REGISTRASI Count]
                        FROM PerawatanSQL.DBO.Visit A
                        INNER JOIN MasterdataSQL.DBO.Admision B
                        ON A.NoMR = B.NoMR
                        WHERE left( CONVERT(DATE, A.[Visit Date]),7)= :Info_Date_Start
                        AND [Status ID]='4'
                         AND Batal='0' 
                        GROUP BY case when CONVERT(DATE, A.[Visit Date])=CONVERT(DATE, B.InputDate) then 
                        'BARU' ELSE 'LAMA' END, right( CONVERT(DATE, A.[Visit Date]) ,2)
                    ) AS QuarterlyData
                    PIVOT( SUM([REGISTRASI Count])   
                    FOR Quarter IN ([BARU],[LAMA] )) AS QPivot
                    order by 1 asc ");
                $this->db->bind('Info_Date_Start', $data['Info_Date_Start']); 
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) { 
                $pasing['Usia'] = $key['tanggal'];
                $pasing['pasienbaru'] = $key['pasienbaru'];
                $pasing['pasienlama'] = $key['pasienlama']; 
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function RekapTahun($data)
    {
        try {
            $no = "1";
            $Info_Date_Start= $data['Info_Date_Start'];
            $this->db->query("		SELECT    
                            case when CONVERT(DATE, A.[Visit Date])=CONVERT(DATE, B.InputDate) then 
                            'BARU' ELSE 'LAMA' END AS Gander
                            ,COUNT(A.NOMR) AS total
                            FROM PerawatanSQL.DBO.Visit A
                            INNER JOIN MasterdataSQL.DBO.Admision B
                            ON A.NoMR = B.NoMR
                            WHERE left( CONVERT(DATE, A.[Visit Date]),4) =:Info_Date_Start
                            AND [Status ID]='4' AND Batal='0' 
                            GROUP BY case when CONVERT(DATE, A.[Visit Date])=CONVERT(DATE, B.InputDate) then 
                            'BARU' ELSE 'LAMA' END");
                $this->db->bind('Info_Date_Start', $data['Info_Date_Start']); 
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) { 
                $pasing['Gander'] = $key['Gander'];
                $pasing['value'] = $key['total']; 
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function Bulanan($data)
    {
        try {
            $no = "1";
            $Info_Date_Start=$data['Info_Date_Start']; 

            $this->db->query("SELECT  tanggal,isnull([BARU],0) as pasienbaru,
			            isnull([LAMA],0) as pasienlama
                        FROM (
                            SELECT    
                            case when CONVERT(DATE, A.[Visit Date])=CONVERT(DATE, B.InputDate) then 
                            'BARU' ELSE 'LAMA' END AS [Quarter],
                            right(left( CONVERT(DATE, A.[Visit Date]),7),2) as tanggal
                            ,COUNT(A.NOMR) AS [REGISTRASI Count]
                            FROM PerawatanSQL.DBO.Visit A
                            INNER JOIN MasterdataSQL.DBO.Admision B
                            ON A.NoMR = B.NoMR
                            WHERE left( CONVERT(DATE, A.[Visit Date]),4) =:Info_Date_Start
                            AND [Status ID]='4' AND Batal='0' 
                            GROUP BY case when CONVERT(DATE, A.[Visit Date])=CONVERT(DATE, B.InputDate) then 
                            'BARU' ELSE 'LAMA' END,right(left( CONVERT(DATE, A.[Visit Date]),7),2)
                        ) AS QuarterlyData
                        PIVOT( SUM([REGISTRASI Count])   
                        FOR Quarter IN ([BARU],[LAMA] )) AS QPivotwh");
                $this->db->bind('Info_Date_Start', $data['Info_Date_Start']); 
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) { 
                $pasing['Usia'] = $key['tanggal'];
                $pasing['pasienbaru'] = $key['pasienbaru'];
                $pasing['pasienlama'] = $key['pasienlama']; 
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}