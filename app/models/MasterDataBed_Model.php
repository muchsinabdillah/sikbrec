<?php
class MasterDataBed_Model 
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getAllDataBed()
    {
        try {
            $this->db->query("SELECT a.RoomID,a.Class,a.Ward,a.Room,a.Bad,a.TarifKamar,a.Keterangan,
                case when a.excludeBOR='1' then 'INLCUDE BOR' ELSE 'EXLCUDE BOR' end as BOR,
                case when a.status='1' then 'TERPAKAI' else 'KOSONG' end as statusterpakai,
                case when a.Dsicontinue ='1' then 'YA' else 'TIDAK'  end as statusaktif,isnull(b.ROOM,'Tidak Terisi') as RoomName,
				case when b.LANTAI='1' then 'LANTAI 1' 
				when b.LANTAI='2' then 'LANTAI 2' when b.LANTAI='3' then 'LANTAI 3' 
				when b.LANTAI='4' then 'LANTAI 4' 
				when b.LANTAI='5' then 'LANTAI 5' when b.LANTAI='6' then 'LANTAI 6' when b.LANTAI='7' then 'LANTAI 7' 
				when b.LANTAI='8' then 'LANTAI 8' when b.LANTAI='9' then 'LANTAI 9' when b.LANTAI='10' then 'LANTAI 10' 
				when b.LANTAI='11' then 'LANTAI 11' when b.LANTAI='12' then 'LANTAI 12' when b.LANTAI='13' then 'LANTAI 13' 
				when b.LANTAI='14' then 'LANTAI 14' when b.LANTAI='15' then 'LANTAI 15' when b.LANTAI='16' then 'LANTAI 16'  
				ELSE 'TIDAK TERISI' end as LANTAI,
                CASE WHEN  a.Publish ='1' THEN 'YA' ELSE 'TIDAK' END AS PUBLISHBPJS
                from MasterdataSQL.DBO.MstrRoomID a
				left join MasterdataSQL.dbo.MstrROOM b
				on a.KodeLokasi = b.ROOM_ID where a.Dsicontinue='0'  and b.ACTIVE='1' order by a.Class asc,a.Room asc, a.Bad asc");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['RoomID'] = $key['RoomID'];
                $pasing['Class'] = $key['Class'];
                $pasing['Ward'] = $key['Ward'];
                $pasing['Room'] = $key['Room'];
                $pasing['Bad'] = $key['Bad'];
                $pasing['TarifKamar'] = $key['TarifKamar'];
                $pasing['Keterangan'] = $key['Keterangan'];
                $pasing['BOR'] = $key['BOR'];
                $pasing['statusterpakai'] = $key['statusterpakai'];
                $pasing['statusaktif'] = $key['statusaktif'];
                $pasing['RoomName'] = $key['RoomName'];
                $pasing['LANTAI'] = $key['LANTAI'];
                $pasing['PUBLISHBPJS'] = $key['PUBLISHBPJS'];
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
    public function getAllDataBedbyLantai($data)
    {
        try {
            $idLantai = $data['LantaiID'];
            if($idLantai <>""){
                $this->db->query("SELECT a.RoomID,a.Class,a.Ward,a.Room,a.Bad,a.TarifKamar,a.Keterangan,
                case when a.excludeBOR='1' then 'INLCUDE BOR' ELSE 'EXLCUDE BOR' end as BOR,
                case when a.status='1' then 'TERPAKAI' else 'KOSONG' end as statusterpakai,
                case when a.Dsicontinue ='1' then 'YA' else 'TIDAK'  end as statusaktif,isnull(b.ROOM,'Tidak Terisi') as RoomName,
				case when b.LANTAI='1' then 'LANTAI 1' 
				when b.LANTAI='2' then 'LANTAI 2' when b.LANTAI='3' then 'LANTAI 3' 
				when b.LANTAI='4' then 'LANTAI 4' 
				when b.LANTAI='5' then 'LANTAI 5' when b.LANTAI='6' then 'LANTAI 6' when b.LANTAI='7' then 'LANTAI 7' 
				when b.LANTAI='8' then 'LANTAI 8' when b.LANTAI='9' then 'LANTAI 9' when b.LANTAI='10' then 'LANTAI 10' 
				when b.LANTAI='11' then 'LANTAI 11' when b.LANTAI='12' then 'LANTAI 12' when b.LANTAI='13' then 'LANTAI 13' 
				when b.LANTAI='14' then 'LANTAI 14' when b.LANTAI='15' then 'LANTAI 15' when b.LANTAI='16' then 'LANTAI 16'  
				ELSE 'TIDAK TERISI' end as LANTAI,
                CASE WHEN  a.Publish ='1' THEN 'YA' ELSE 'TIDAK' END AS PUBLISHBPJS
                from MasterdataSQL.DBO.MstrRoomID a
				left join MasterdataSQL.dbo.MstrROOM b
				on a.KodeLokasi = b.ROOM_ID
                where b.LANTAI = :idLantai  and a.Dsicontinue='0'  and b.ACTIVE='1'  order by a.Class asc,a.Room asc, a.Bad asc");
                $this->db->bind('idLantai', $idLantai);
            }else{
                $this->db->query("SELECT a.RoomID,a.Class,a.Ward,a.Room,a.Bad,a.TarifKamar,a.Keterangan,
                case when a.excludeBOR='1' then 'INLCUDE BOR' ELSE 'EXLCUDE BOR' end as BOR,
                case when a.status='1' then 'TERPAKAI' else 'KOSONG' end as statusterpakai,
                case when a.Dsicontinue ='1' then 'YA' else 'TIDAK'  end as statusaktif,isnull(b.ROOM,'Tidak Terisi') as RoomName,
				case when b.LANTAI='1' then 'LANTAI 1' 
				when b.LANTAI='2' then 'LANTAI 2' when b.LANTAI='3' then 'LANTAI 3' 
				when b.LANTAI='4' then 'LANTAI 4' 
				when b.LANTAI='5' then 'LANTAI 5' when b.LANTAI='6' then 'LANTAI 6' when b.LANTAI='7' then 'LANTAI 7' 
				when b.LANTAI='8' then 'LANTAI 8' when b.LANTAI='9' then 'LANTAI 9' when b.LANTAI='10' then 'LANTAI 10' 
				when b.LANTAI='11' then 'LANTAI 11' when b.LANTAI='12' then 'LANTAI 12' when b.LANTAI='13' then 'LANTAI 13' 
				when b.LANTAI='14' then 'LANTAI 14' when b.LANTAI='15' then 'LANTAI 15' when b.LANTAI='16' then 'LANTAI 16'  
				ELSE 'TIDAK TERISI' end as LANTAI,
                CASE WHEN  a.Publish ='1' THEN 'YA' ELSE 'TIDAK' END AS PUBLISHBPJS
                from MasterdataSQL.DBO.MstrRoomID a
				left join MasterdataSQL.dbo.MstrROOM b
				on a.KodeLokasi = b.ROOM_ID  where a.Dsicontinue='0'  and b.ACTIVE='1'  order by a.Class asc,a.Room asc, a.Bad asc"); 
            }
            



            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['RoomID'] = $key['RoomID'];
                $pasing['Class'] = $key['Class'];
                $pasing['Ward'] = $key['Ward'];
                $pasing['Room'] = $key['Room'];
                $pasing['Bad'] = $key['Bad'];
                $pasing['TarifKamar'] = $key['TarifKamar'];
                $pasing['Keterangan'] = $key['Keterangan'];
                $pasing['BOR'] = $key['BOR'];
                $pasing['statusterpakai'] = $key['statusterpakai'];
                $pasing['statusaktif'] = $key['statusaktif'];
                $pasing['RoomName'] = $key['RoomName'];
                $pasing['LANTAI'] = $key['LANTAI'];
                $pasing['PUBLISHBPJS'] = $key['PUBLISHBPJS'];
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
    // INSERT
    public function insert($data)
    {
        try {
            $this->db->transaksi();

            if ($data['KodeLokasi'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Kode Lokasi!',
                );
                return $callback;
                exit;
            }
            if ($data['ClassID'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Kelas !',
                );
                return $callback;
                exit;
            }
            if ($data['Ward'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Ward !',
                );
                return $callback;
                exit;
            }
            if ($data['RoomName'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Room Name !',
                );
                return $callback;
                exit;
            }
            if ($data['BedName'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Bed Name !',
                );
                return $callback;
                exit;
            }
            if ($data['Tarif'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Tarif !',
                );
                return $callback;
                exit;
            }
            if ($data['IncludeBOR'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Include BOR !',
                );
                return $callback;
                exit;
            }
            if ($data['Discontinue'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Discontinue !',
                );
                return $callback;
                exit;
            }
            if ($data['Publish'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Publish !',
                );
                return $callback;
                exit;
            }
            if ($data['KodePDP'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Kode PDP !',
                );
                return $callback;
                exit;
            }
            
            $IdAuto = $data['IdAuto'];
            $KodeLokasi = $data['KodeLokasi'];
            $Ward = $data['Ward'];
            $RoomName = $data['RoomName'];
            $BedName = $data['BedName'];
            $Tarif = $data['Tarif'];
            $ClassID = $data['ClassID'];
            $IncludeBOR = $data['IncludeBOR'];
            $Discontinue = $data['Discontinue'];
            $KodeBPJS = $data['KodeBPJS'];
            $Keterangan = $data['Keterangan'];
            $Publish = $data['Publish'];
            $KodePDP = $data['KodePDP'];

            
           $this->db->query("SELECT NamaKelas
                                from RawatInapSQL.dbo.TblKelas 
                                where IDKelas=:ClassID");
                        $this->db->bind('ClassID', $ClassID);
                        $data =  $this->db->resultSet();
                        foreach ($data as $key) {
                            $NamaKelas = $key['NamaKelas'];
                        }


            if ($IdAuto == "") {
                    $this->db->query("INSERT INTO MasterdataSQL.dbo.MstrRoomID (KodeLokasi,Class,Ward,
                        Room, Bad, TarifKamar, 
                        KLSID, excludeBOR,Dsicontinue, KdKlsBPJS, Keterangan,
                        Publish,KD_PDP) VALUES
                  (:KodeLokasi,:NamaKelas,:Ward,:RoomName,:BedName,:Tarif,:ClassID,:IncludeBOR,:Discontinue,:KodeBPJS,:Keterangan,:Publish,:KodePDP)");
            } else {
                $this->db->query("UPDATE MasterdataSQL.dbo.MstrRoomID set  
                          KodeLokasi=:KodeLokasi,Class=:NamaKelas,Ward=:Ward, Room=:RoomName, Bad=:BedName, TarifKamar=:Tarif,KLSID=:ClassID, excludeBOR=:IncludeBOR,Dsicontinue=:Discontinue, KdKlsBPJS=:KodeBPJS, Keterangan=:Keterangan,
                        Publish=:Publish,KD_PDP=:KodePDP
                            WHERE RoomID=:IdAuto");
                    $this->db->bind('IdAuto', $IdAuto); 
            }
                    $this->db->bind('KodeLokasi', $KodeLokasi);
                    $this->db->bind('NamaKelas', $NamaKelas);
                    $this->db->bind('Ward', $Ward);
                    $this->db->bind('RoomName', $RoomName);
                    $this->db->bind('BedName', $BedName);
                    $this->db->bind('Tarif', $Tarif);
                    $this->db->bind('ClassID', $ClassID);
                    $this->db->bind('IncludeBOR', $IncludeBOR);
                    $this->db->bind('Discontinue', $Discontinue);
                    $this->db->bind('KodeBPJS', $KodeBPJS);
                    $this->db->bind('Keterangan', $Keterangan);
                    $this->db->bind('Publish', $Publish);
                    $this->db->bind('KodePDP', $KodePDP);
            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function getBedId($id)
    {

        try{
            $this->db->query("SELECT * FROM MasterdataSQL.dbo.MstrRoomID
                        WHERE RoomID=:id");
            $this->db->bind('id', $id);
            $data =  $this->db->single();
            $pasing['RoomID'] = $data['RoomID'];
            $pasing['KodeLokasi'] = $data['KodeLokasi'];
            $pasing['Ward'] = $data['Ward'];
            $pasing['Room'] = $data['Room'];
            $pasing['Bad'] = $data['Bad'];
            $pasing['TarifKamar'] = $data['TarifKamar'];
            $pasing['KLSID'] = $data['KLSID'];
            $pasing['excludeBOR'] = $data['excludeBOR'];
            $pasing['Dsicontinue'] = $data['Dsicontinue'];
            $pasing['KdKlsBPJS'] = $data['KdKlsBPJS'];
            $pasing['Keterangan'] = $data['Keterangan'];
            $pasing['Publish'] = $data['Publish'];
            $pasing['KD_PDP'] = $data['KD_PDP'];
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
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

     public function getClass()
    {
        try {
            $this->db->query("SELECT IDKelas, NamaKelas
                                  from RawatInapSQL.dbo.TblKelas order by NamaKelas asc");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['IDKelas'] = $key['IDKelas'];
                $pasing['NamaKelas'] = $key['NamaKelas'];
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

    public function getKDPDP()
    {
        try {
            $this->db->query("SELECT KD_PDP, NM_PDP
                                  from Keuangan.DBO.BO_M_PDP");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['KD_PDP'] = $key['KD_PDP'];
                $pasing['NM_PDP'] = $key['NM_PDP'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getRoom()
    {
        try {
            $this->db->query("SELECT ROOM_ID,ROOM,CLASS FROM MasterdataSQL.DBO.MstrROOM
                            ORDER BY ROOM_ID DESC");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ROOM_ID'] = $key['ROOM_ID'];
                $pasing['ROOM'] = $key['ROOM'];
                $pasing['CLASS'] = $key['CLASS'];
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
    public function getJenisRawat()
    {
        try {
            $this->db->query("SELECT ID,JenisRuangRawat FROM RawatInapSQL.dbo.JenisRuangRawat");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['JenisRuangRawat'] = $key['JenisRuangRawat']; 
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

    public function getClassbyID($data)
    {
        try {
            $id = $data['classid'];
            $this->db->query("SELECT IDKelas, NamaKelas
                                  from RawatInapSQL.dbo.TblKelas where IDKelas=:id");
                $this->db->bind('id', $id);
            $data =  $this->db->single();
            $pasing['classid'] = $data['IDKelas'];
            $pasing['classname'] = $data['NamaKelas'];
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
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

    public function getRoombyClassID($data)
    {
        try {
            $id = $data['classid'];
            $this->db->query("SELECT ROOM_ID,ROOM,CLASS FROM MasterdataSQL.DBO.MstrROOM
                            WHERE CLASS_ID=:id
                            ORDER BY ROOM_ID DESC");
                $this->db->bind('id', $id);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ROOM_ID'] = $key['ROOM_ID'];
                $pasing['ROOM'] = $key['ROOM'];
                $pasing['CLASS'] = $key['CLASS'];
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

    public function getRoombyID($data)
    {
        try {
            $id = $data['roomid'];
            $this->db->query("SELECT ROOM_ID,ROOM,CLASS FROM MasterdataSQL.DBO.MstrROOM
                            Where ROOM_ID=:id");
                $this->db->bind('id', $id);
            $data =  $this->db->single();
            $pasing['roomid'] = $data['ROOM_ID'];
            $pasing['roomname'] = $data['ROOM'];
            $pasing['CLASS'] = $data['CLASS'];
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
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

    public function getBedbyRoomID($data)
    {
        try {
            $id = $data['roomid'];
            $this->db->query("SELECT RoomID,Room,Bad,TarifKamar,
                            case when Status='0' then 'TERSEDIA' else 'TERPAKAI' end as StatusName,
                            case when Publish='1' then 'BPJS' else 'NON BPJS' end as IsBPJS 
                            FROM MasterdataSQL.DBO.MstrRoomID
                            WHERE KodeLokasi=:id and Dsicontinue='0' 
                            --ORDER BY ROOM_ID DESC
                            ");
                $this->db->bind('id', $id);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['RoomID'] = $key['RoomID'];
                $pasing['Room'] = $key['Room'];
                $pasing['Bad'] = $key['Bad'];
                $pasing['StatusName'] = $key['StatusName'];
                $pasing['TarifKamar'] = $key['TarifKamar'];
                $pasing['IsBPJS'] = $key['IsBPJS'];
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

    public function getBedbyID($data)
    {
        try {
            $id = $data['bedid'];
            $this->db->query("SELECT RoomID,Room,TarifKamar,Bad FROM MasterdataSQL.DBO.MstrRoomID
                            Where RoomID=:id");
                $this->db->bind('id', $id);
            $data =  $this->db->single();
            $pasing['bedid'] = $data['RoomID'];
            $pasing['roomname'] = $data['Room'];
            $pasing['bedname'] = $data['Bad'];
            $pasing['TarifKamar'] = $data['TarifKamar'];
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
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

