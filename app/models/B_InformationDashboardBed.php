<?php
class  B_InformationDashboardBed
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getData($data)
    {
        try {
            $kodelokasi = $data['Ruangan'];
            $datenow = Utils::datenowcreateNotFull();

            // $query = "SELECT * from MasterdataSQL.dbo.MstrRoomID where KodeLokasi=:kodelokasi AND Dsicontinue='0'
            // order by Bad asc
            // ";



            $query = "SELECT       
            NoRegRI, RawatInapSQL.dbo.View_PasienRawat.PatientName as PasienRanap, RawatInapSQL.dbo.View_PasienRawat.NoMR, 
            CASE WHEN RawatInapSQL.dbo.View_PasienRawat.Titipan='1' then 'TITIPAN' ELSE '' END AS TITIPAN ,
            RawatInapSQL.dbo.View_PasienRawat.Class,RawatInapSQL.dbo.View_PasienRawat.RoomID, 
            MasterdataSQL.dbo.MstrRoomID.Class, MasterdataSQL.dbo.MstrRoomID.Room, MasterdataSQL.dbo.MstrRoomID.Bad, 
            MasterdataSQL.dbo.MstrRoomID.TarifKamar, MasterdataSQL.dbo.MstrRoomID.JasaKeperawatan,  
               CASE
                   WHEN bx.transactioncode is null
               THEN MasterdataSQL.dbo.MstrRoomID.Status
               ELSE '2'
               END as Status, 
            MasterdataSQL.dbo.MstrRoomID.KLSID, MasterdataSQL.dbo.MstrRoomID.excludeBOR, 
            MasterdataSQL.dbo.MstrRoomID.Dsicontinue, MasterdataSQL.dbo.MstrRoomID.KdKlsBPJS, MasterdataSQL.dbo.MstrRoomID.Publish, MasterdataSQL.dbo.MstrRoomID.KodeLokasi 
           ,bx.patientname ,bx.bookingbeddate, MasterdataSQL.dbo.MstrRoomID.Ward ,
           replace(CONVERT(VARCHAR(11), RawatInapSQL.dbo.View_PasienRawat.StartDate, 111), '/','-') + ' - ' + FORMAT(RawatInapSQL.dbo.View_PasienRawat.startTime,'H:m:s') as tglMasuk,
replace(CONVERT(VARCHAR(11), RawatInapSQL.dbo.View_PasienRawat.EndDate, 111), '/','-') + ' - ' + FORMAT(RawatInapSQL.dbo.View_PasienRawat.EndTime,'H:m:s')  as tglKeluar 
,       CASE 
            WHEN bx.bookingstatus is null 
            THEN '-'
            WHEN bx.bookingstatus ='0' 
            THEN 'BELUM DATANG'  
            WHEN bx.bookingstatus ='1' 
            THEN 'DATANG' 
        END AS  bookingstatus
           FROM            RawatInapSQL.dbo.View_PasienRawat RIGHT OUTER JOIN
                                    MasterdataSQL.dbo.MstrRoomID ON RawatInapSQL.dbo.View_PasienRawat.RoomID = MasterdataSQL.dbo.MstrRoomID.RoomID
                           INNER JOIN MasterdataSQL.dbo.MstrROOM ON MasterdataSQL.dbo.MstrROOM.ROOM_ID = MasterdataSQL.dbo.MstrRoomID.KodeLokasi
                           left join (
           SELECT *
           from RawatInapSQL.dbo.BookingBeds
           where replace(CONVERT(VARCHAR(11), bookingbeddate, 111), '/','-') = :datenow
           )  bx
           on MasterdataSQL.dbo.MstrRoomID.RoomID = bx.bedid
           WHERE        
           (MasterdataSQL.dbo.MstrRoomID.Dsicontinue = 0)  
           and MasterdataSQL.dbo.MstrRoomID.KodeLokasi =:kodelokasi
           order by room asc , bad asc";

            $this->db->query($query);
            $this->db->bind('kodelokasi', $kodelokasi);
            $this->db->bind('datenow', $datenow);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $row) {
                $pasing['no'] = $no++;
                $pasing['RoomID'] = $row['RoomID'];
                $pasing['KodeLokasi'] = $row['KodeLokasi'];
                $pasing['Class'] = $row['Class'];
                $pasing['Ward'] = $row['Ward'];
                $pasing['Room'] = $row['Room'];
                $pasing['Bad'] = $row['Bad'];
                $pasing['TarifKamar'] = $row['TarifKamar'];
                $pasing['JasaKeperawatan'] = $row['JasaKeperawatan'];
                $pasing['Status'] = $row['Status'];
                $pasing['KLSID'] = $row['KLSID'];
                $pasing['excludeBOR'] = $row['excludeBOR'];
                $pasing['Dsicontinue'] = $row['Dsicontinue'];
                $pasing['KdKlsBPJS'] = $row['KdKlsBPJS'];  
                $pasing['Publish'] = $row['Publish']; 
                $pasing['PasienRanap'] = $row['PasienRanap']; 
                $pasing['patientname'] = $row['patientname']; 
                $pasing['bookingbeddate'] = $row['bookingbeddate']; 
                $pasing['tglMasuk'] = $row['tglMasuk']; 
                $pasing['tglKeluar'] = $row['tglKeluar'];
                $pasing['bookingstatus'] = $row['bookingstatus']; 
                
                $rows[] = $pasing;
            }
            return $data;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getRuangan($data)
    {
        try {
            $lantai = $data['lantai'];

            $query = "SELECT ROOM_ID,ROOM FROM MasterDataSQL.dbo.MstrROOM where LANTAI=:lantai";
            $this->db->query($query);
            $this->db->bind('lantai', $lantai);
            
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ROOM_ID'] = $key['ROOM_ID'];
                $pasing['ROOM'] = $key['ROOM'];
                $rows[] = $pasing;
            }
            $callback = array(
                'status' => "success", // Set array nama  
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
}
