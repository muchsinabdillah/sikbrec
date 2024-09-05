<?php
class  B_InformationKamarPerawatan
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function GenerateData($data)
    {
        try {
            $this->db->transaksi();
            $Periode = $data['Periode'];

            $query = "EXEC DashboardData.dbo.Haripearawatan @periode=:Periode";

            $this->db->query($query);
            $this->db->bind('Periode', $Periode);
            $this->db->execute(); 

            $querys = "UPDATE  DashboardData.DBO.dataRWI
            SET  RoomID_Akhir=AAAAAA.ID,RoomID_Awal=AAAAAA.ID,RoomName_Awal=AAAAAA.RoomName,RoomName_Akhir=AAAAAA.RoomName
            ,KelasID_Awal=AAAAAA.IDKelas, KelasID_Akhir=AAAAAA.IDKelas,KelasName_Awal=AAAAAA.Class,KelasName_Akhir=AAAAAA.Class
            FROM  DashboardData.DBO.dataRWI ASW
            INNER JOIN  (
                    SELECT C.NoRegRI,  max(C.ID) as rowids,COUNT(C.roomid) countroomid,RoomID,ID, 
                    RoomName,Class,IDKelas, BED,startdate,timestart,enddate,timeend,statusActive ,row_num
                    FROM (  
                      SELECT 
                        ROW_NUMBER() OVER (
                        PARTITION BY noregri
                        ORDER BY noregri
                        ) row_num,NoRegRI,RoomID,ID, RoomName,Class,IDKelas, BED,startdate,timestart,enddate,timeend,statusActive 
                      FROM RawatInapSQL.DBO.Inpatient_in_out
                      where NoRegRI in (
                        select  noregri from RawatInapSQL.dbo.Inpatient 
                      )
                    ) C
                     where 
                     row_num <= 1
                    group by  NoRegRI, RoomID,ID, RoomName,Class,IDKelas, BED,startdate,timestart,enddate,timeend,statusActive ,row_num
              )AAAAAA
             ON ASW.NoRegistrasi = AAAAAA.NoRegRI ";
            $this->db->query($querys);
            $this->db->execute(); 

            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success       
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataList($data)
    {
        try {
            $Periode = $data['Periode'];

                $query = "SELECT * from DashboardData.dbo.HariPerawatan where Periode=:Periode";

            $this->db->query($query);
            $this->db->bind('Periode', $Periode);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $row) {
                $pasing['no'] = $no++;
               // $pasing['TglKunjungan'] = date('d-m-Y', strtotime($row['tglregisx']));
                $pasing['ID'] = $row['ID'];
                $pasing['NoRegistrasi'] = $row['NoRegistrasi'];
                $pasing['PatientName'] = $row['PatientName'];
                $pasing['StartdateReg'] = ($row['StartdateReg'] != null) ? date('d/m/Y', strtotime($row['StartdateReg'])) : '';
                $pasing['EndDateReg'] =  ($row['EndDateReg'] != null) ? date('d/m/Y', strtotime($row['EndDateReg'])) : '';
                $pasing['RoomName_Awal'] = $row['RoomName_Awal'];
                $pasing['RoomName_Akhir'] = $row['RoomName_Akhir'];
                $pasing['Periode'] = $row['Periode'];
                $pasing['date1'] = $row['date1'];
                $pasing['date2'] = $row['date2'];
                $pasing['date3'] = $row['date3'];
                $pasing['date4'] = $row['date4'];
                $pasing['date5'] = $row['date5'];
                $pasing['date6'] = $row['date6'];
                $pasing['date7'] = $row['date7'];
                $pasing['date8'] = $row['date8'];
                $pasing['date9'] = $row['date9'];
                $pasing['date10'] = $row['date10'];
                $pasing['date11'] = $row['date11'];
                $pasing['date12'] = $row['date12'];
                $pasing['date13'] = $row['date13'];
                $pasing['date14'] = $row['date14'];
                $pasing['date15'] = $row['date15'];
                $pasing['date16'] = $row['date16'];
                $pasing['date17'] = $row['date17'];
                $pasing['date18'] = $row['date18'];
                $pasing['date19'] = $row['date19'];
                $pasing['date20'] = $row['date20'];
                $pasing['date21'] = $row['date21'];
                $pasing['date22'] = $row['date22'];
                $pasing['date23'] = $row['date23'];
                $pasing['date24'] = $row['date24'];
                $pasing['date25'] = $row['date25'];
                $pasing['date26'] = $row['date26'];
                $pasing['date27'] = $row['date27'];
                $pasing['date28'] = $row['date28'];
                $pasing['date29'] = $row['date29'];
                $pasing['date30'] = $row['date30'];
                $pasing['date31'] = $row['date31'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function GenerateData_borlostoi($data)
    {
        try {
            $this->db->transaksi();
            $Periode = $data['Periode'];

            $query = "EXEC DashboardData.dbo.borlostoi @periode=:Periode";

            $this->db->query($query);
            $this->db->bind('Periode', $Periode);
            $this->db->execute(); 
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success       
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataListBOR($data)
    {
        try {
            $Periode = substr($data['Periode'],0,4);

                $query = "SELECT    periode,
                ISNULL([@@totalpasienpulang],0) AS TotalPasienPulang,
                ISNULL([SEMBUH],0) AS ResumeTotalSEMBUH,
                ISNULL([MENINGGAL],0) AS ResumeTotalMeninggal2,
                ISNULL([LAIN-LAIN],0) AS ResumeTotalLainlain, 
                ISNULL([PULANG PAKSA],0) AS ResumeTotalPulangPaksa,  
                ISNULL([BOR],0) AS [BOR],ISNULL([LOS],0) AS [LOS],
                ISNULL([BTO],0) AS [BTO],
                ISNULL([TOI],0) AS [TOI],ISNULL([GDR],0) AS [GDR],ISNULL([NDR],0) AS [NDR],ISNULL([Hari Perawatan],0) AS HariPerawatan,ISNULL([Jumlah Bed],0) AS JumlahBed ,
                ISNULL([Lama Perawatan],0) AS LamaPerawatan
                FROM (
                
                        SELECT  total as  [REGISTRASI Count], keterangan as  [Quarter],periode from DashboardData.dbo.Dashboard_Medrec WHERE left(periode,4)=:Periode ) AS QuarterlyData
                PIVOT( sum([REGISTRASI Count])   
                FOR Quarter IN ([@@totalpasienpulang],[Hari Perawatan],[Jumlah Bed],[Lama Perawatan],[BOR],[LOS],[BTO],[TOI],[GDR],[NDR]
                ,[SEMBUH],[MENINGGAL],[LAIN-LAIN],[PULANG PAKSA]  )) AS QPivot  order by periode asc";

            $this->db->query($query);
            $this->db->bind('Periode', $Periode);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $row) {
                $pasing['no'] = $no++;
               // $pasing['TglKunjungan'] = date('d-m-Y', strtotime($row['tglregisx']));
                $pasing['periode'] = $row['periode'];
                $pasing['TotalPasienPulang'] = $row['TotalPasienPulang'];
                $pasing['ResumeTotalSEMBUH'] = $row['ResumeTotalSEMBUH'];
                $pasing['ResumeTotalMeninggal2'] =  $row['ResumeTotalMeninggal2'];
                $pasing['ResumeTotalLainlain'] =   $row['ResumeTotalLainlain'];
                $pasing['ResumeTotalPulangPaksa'] = $row['ResumeTotalPulangPaksa'];
                $pasing['BOR'] = $row['BOR'];
                $pasing['LOS'] = $row['LOS'];
                $pasing['BTO'] = $row['BTO'];
                $pasing['TOI'] = $row['TOI'];
                $pasing['GDR'] = $row['GDR'];
                $pasing['NDR'] = $row['NDR'];
                $pasing['HariPerawatan'] = $row['HariPerawatan'];
                $pasing['JumlahBed'] = $row['JumlahBed'];
                $pasing['LamaPerawatan'] = $row['LamaPerawatan'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
