<?php
class MasterDataRoom_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getAllDataRoom()
    {
        try {
            $this->db->query("SELECT ROOM_ID , CLASS_ID,ROOM,CLASS,BED ,BRIDGE_BPJS,'Lantai : ' + LANTAI as LANTAI
                            FROM MasterdataSQL.DBO.MstrROOM where ACTIVE='1'
                            ORDER BY  ROOM_ID DESC , CLASS_ID asc");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['RoomID'] = $key['ROOM_ID'];
                $pasing['CLASS_ID'] = $key['CLASS_ID'].' - '. $key['CLASS'];
                $pasing['ROOM'] = $key['ROOM']; 
                $pasing['BED'] = $key['BED'];
                $pasing['BRIDGE_BPJS'] = $key['BRIDGE_BPJS'];
                $pasing['LANTAI'] = $key['LANTAI']; 
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
    public function getAllDataRoomByLantai($data)
    {
        try {
            $idLantai = $data['LantaiID'];
            if($idLantai <>""){
                $this->db->query("SELECT ROOM_ID , CLASS_ID,ROOM,CLASS,BED ,BRIDGE_BPJS,'Lantai : ' + LANTAI as LANTAI
                            FROM MasterdataSQL.DBO.MstrROOM
                            where LANTAI=:idLantai and ACTIVE='1'
                            ORDER BY  ROOM_ID DESC , CLASS_ID asc");
                $this->db->bind('idLantai', $idLantai);
            }else{
                $this->db->query("SELECT ROOM_ID , CLASS_ID,ROOM,CLASS,BED ,BRIDGE_BPJS,'Lantai : ' + LANTAI as LANTAI
                            FROM MasterdataSQL.DBO.MstrROOM  where  ACTIVE='1'
                            ORDER BY  ROOM_ID DESC , CLASS_ID asc"); 
            }
            

            
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['RoomID'] = $key['ROOM_ID'];
                $pasing['CLASS_ID'] = $key['CLASS_ID'] . ' - ' . $key['CLASS'];
                $pasing['ROOM'] = $key['ROOM'];
                $pasing['BED'] = $key['BED'];
                $pasing['BRIDGE_BPJS'] = $key['BRIDGE_BPJS'];
                $pasing['LANTAI'] = $key['LANTAI'];
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
            if ($data['RoomName'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Room Name !',
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
            if ($data['ClassName'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Nama Kelas !',
                );
                return $callback;
                exit;
            }  
            if ($data['JumlahBed'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Jumlah Bed !',
                );
                return $callback;
                exit;
            }
            if ($data['LantaiID'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Lantai !',
                );
                return $callback;
                exit;
            }
            if ($data['UnitID'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Unit Usaha !',
                );
                return $callback;
                exit;
            } 

            $IdAuto = $data['IdAuto']; 
            $RoomName = $data['RoomName'];
            $ClassName = $data['ClassName'];
            $JumlahBed = $data['JumlahBed'];
            $ClassID = $data['ClassID'];
            $UnitID = $data['UnitID'];
            $LantaiID = $data['LantaiID']; 

            if ($IdAuto == "") {
                $this->db->query("SELECT  TOP 1 right( REPLACE(ROOM_ID,'-','0') ,4) as urutregx
                                    FROM MasterdataSQL.dbo.MstrROOM  
                                    ORDER BY ROOM_ID DESC"); 
                $dtNoRoom =  $this->db->single();  
                //no urut reg
                $no_reg = $dtNoRoom['urutregx'];
                $idReg = $no_reg;
                $idReg++;
                $nourutfixReg = Utils::generateAutoNumberFourDigit($idReg);
                $noRoomFix = "R-".$nourutfixReg;
                    $this->db->query("INSERT INTO MasterdataSQL.dbo.MstrROOM 
                    (ROOM_ID,CLASS_ID,ROOM,CLASS,BED,LANTAI,UNIT) 
                    VALUES
                    (:ROOM_ID,:CLASS_ID,:ROOM,:CLASS,:BED,:LANTAI,:UNIT)");
                $this->db->bind('ROOM_ID', $noRoomFix);
                $this->db->bind('CLASS_ID', $ClassID);
                $this->db->bind('ROOM', $RoomName);
                $this->db->bind('CLASS', $ClassName);
                $this->db->bind('BED', $JumlahBed);
                $this->db->bind('LANTAI', $LantaiID);
                $this->db->bind('UNIT', $UnitID);
                $this->db->execute();
            } else {
                $this->db->query("UPDATE MasterdataSQL.dbo.MstrROOM set  
                            ROOM=:ROOM,CLASS_ID=:CLASS_ID,CLASS=:CLASS, BED=:BED
                            ,LANTAI=:LANTAI,UNIT=:UNIT
                            WHERE ROOM_ID=:ROOM_ID"); 
                $this->db->bind('ROOM_ID', $IdAuto);
                $this->db->bind('CLASS_ID', $ClassID);
                $this->db->bind('ROOM', $RoomName);
                $this->db->bind('CLASS', $ClassName);
                $this->db->bind('BED', $JumlahBed);
                $this->db->bind('LANTAI', $LantaiID);
                $this->db->bind('UNIT', $UnitID);
                $this->db->execute();
            }
            
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
    public function getRoomId($id)
    {

        try {
            $this->db->query(" SELECT A.ROOM_ID,A.CLASS_ID,A.ROOM,A.CLASS,A.BED,A.BRIDGE_BPJS,a.LANTAI,a.UNIT ,B.IDkelasBPJS
                            FROM MasterdataSQL.dbo.MstrROOM A
					        INNER JOIN RawatInapSQL.dbo.TblKelas B
					        ON a.CLASS_ID = b.IDkelas
                            WHERE a.ROOM_ID =:id"); 
            $this->db->bind('id', $id);
            $data =  $this->db->single();
            $pasing['RoomID'] = $data['ROOM_ID'];
            $pasing['CLASS_ID'] = $data['CLASS_ID'];
            $pasing['ROOM'] = $data['ROOM'];
            $pasing['CLASS'] = $data['CLASS'];
            $pasing['BED'] = $data['BED'];
            $pasing['BRIDGE_BPJS'] = $data['BRIDGE_BPJS'];
            $pasing['LANTAI'] = $data['LANTAI'];
            $pasing['UNIT'] = $data['UNIT'];
            $pasing['IDkelasBPJS'] = $data['IDkelasBPJS']; 
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
    function GosendBPJS($data)
    { 
        $IdAuto = $data['IdAuto'];
        $this->db->query(" SELECT A.ROOM_ID,A.CLASS_ID,A.ROOM,A.CLASS,A.BED,A.BRIDGE_BPJS ,B.IDkelasBPJS
                            FROM MasterdataSQL.dbo.MstrROOM A
					        INNER JOIN RawatInapSQL.dbo.TblKelas B
					        ON a.CLASS_ID = b.IDkelas
                            WHERE a.ROOM_ID=:id");
        $this->db->bind('id', $IdAuto);
        $data =  $this->db->single();
        $IDkelasBPJS = $data['IDkelasBPJS'];
        $ROOM = $data['ROOM']; 
        $BED= $data['BED']; 
        $curl = curl_init();
        $headerbpjs = Utils::headerBPJS_BPJS_Aplicares();

        curl_setopt_array($curl, array(
            CURLOPT_URL =>  'https://new-api.bpjs-kesehatan.go.id/aplicaresws/rest/bed/create/0114R067',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{ "kodekelas":"'. $IDkelasBPJS. '", 
                    "koderuang":"' . $IdAuto . '", 
                    "namaruang":"' . $ROOM . '", 
                    "kapasitas":"' . $BED . '", 
                    "tersedia":"' . $BED . '",
                    "tersediapria":"0", 
                    "tersediawanita":"0", 
                    "tersediapriawanita":"0"
                }',
            CURLOPT_HTTPHEADER => $headerbpjs,
        ));

        $output = curl_exec($curl);

        // tutup curl 
        curl_close($curl); 
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metadata']['code'] == "1") {
            $this->db->query("UPDATE MasterdataSQL.DBO.MstrROOM SET 
               BRIDGE_BPJS='1'
                WHERE ROOM_ID=:ROOM_ID");
            $this->db->bind('ROOM_ID', $IdAuto); 
            $this->db->execute(); 
            $callback = array(
                'status' => 'success', 
                'message' => $JsonData['metadata']['message']
            );
            return $callback;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metadata']['message']

            );
            return $callback;
        }
    }
    function GosendBPJSBatal($data)
    {
        $IdAuto = $data['IdAuto'];
        $this->db->query(" SELECT A.ROOM_ID,A.CLASS_ID,A.ROOM,A.CLASS,A.BED,A.BRIDGE_BPJS ,B.IDkelasBPJS
                            FROM MasterdataSQL.dbo.MstrROOM A
					        INNER JOIN RawatInapSQL.dbo.TblKelas B
					        ON a.CLASS_ID = b.IDkelas
                            WHERE a.ROOM_ID=:id");
        $this->db->bind('id', $IdAuto);
        $data =  $this->db->single();
        $IDkelasBPJS = $data['IDkelasBPJS'];
        $ROOM = $data['ROOM'];
        $BED = $data['BED'];
        $curl = curl_init();
        $headerbpjs = Utils::headerBPJS_BPJS_Aplicares();
        curl_setopt_array($curl, array(
            CURLOPT_URL =>  'https://new-api.bpjs-kesehatan.go.id/aplicaresws/rest/bed/delete/0114R067',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{ "kodekelas":"' . $IDkelasBPJS . '", 
                    "koderuang":"' . $IdAuto . '", 
                    "namaruang":"' . $ROOM . '", 
                    "kapasitas":"' . $BED . '", 
                    "tersedia":"' . $BED . '",
                    "tersediapria":"0", 
                    "tersediawanita":"0", 
                    "tersediapriawanita":"0"
                }',
            CURLOPT_HTTPHEADER => $headerbpjs,
        ));

        $output = curl_exec($curl);

        // tutup curl 
        curl_close($curl);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metadata']['code'] == "1") {
            $this->db->query("UPDATE MasterdataSQL.DBO.MstrROOM SET 
               BRIDGE_BPJS='0'
                WHERE ROOM_ID=:ROOM_ID");
            $this->db->bind('ROOM_ID', $IdAuto);
            $this->db->execute();
            $callback = array(
                'status' => 'success',
                'message' => $JsonData['metadata']['message']
            );
            return $callback;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metadata']['message']

            );
            return $callback;
        }
    }
    function GosendBPJSUpdate($data)
    {
        $IdAuto = $data['IdAuto'];
        $this->db->query(" SELECT   x.KLSID,x.Class,kapasitas as Jumlah,
                        sum(isnull(x.terpakai,0) ) as terpakai,sum(isnull(x.sisa,0) ) as tersedia,KodeLokasi,Room,KdKlsBPJS
                        from (
                        SELECT  a.KLSID,a.Class,b.BED as kapasitas, CASE WHEN a.status=0 THEN COUNT(status) END AS sisa,
                        CASE WHEN a.status=1 THEN COUNT(status) END AS terpakai,a.kodelokasi,a.Room,a.KdKlsBPJS,a.publish
                        FROM RawatInapSQL.dbo.View_InformasiKamarRI a
                        inner join MasterdataSQL.dbo.MstrROOM b
                        on b.ROOM_ID = a.kodelokasi 
                        where a.KodeLokasi=:IdAuto and a.publish='1'
                        GROUP BY a.Class,a.status,a.KLSID,a.kodelokasi,a.Room,a.KdKlsBPJS,b.BED ,a.publish
                        ) x 
                        group by KLSID,Class,kapasitas,KodeLokasi,Room,KdKlsBPJS
                        order by x.Class asc");
        $this->db->bind('IdAuto', $IdAuto);
        $data =  $this->db->single();
        $kapasitas = $data['Jumlah'];
        $terpakai = $data['terpakai'];
        $tersedia = $data['tersedia'];
        $KdKlsBPJS = $data['KdKlsBPJS'];
        $kodelokasi = $data['KodeLokasi'];
        $Room = $data['Room'];
        $curl = curl_init();
        $headerbpjs = Utils::headerBPJS_BPJS_Aplicares(); 
        curl_setopt_array($curl, array(
            CURLOPT_URL =>  'https://new-api.bpjs-kesehatan.go.id/aplicaresws/rest/bed/update/0114R067',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{ "kodekelas":"' . $KdKlsBPJS . '", 
                    "koderuang":"' . $kodelokasi . '", 
                    "namaruang":"' . $Room . '", 
                    "kapasitas":"' . $kapasitas . '", 
                    "tersedia":"' . $tersedia . '",
                    "tersediapria":"0", 
                    "tersediawanita":"0", 
                    "tersediapriawanita":"0"
                }',
            CURLOPT_HTTPHEADER => $headerbpjs,
        ));

        $output = curl_exec($curl);

        // tutup curl 
        curl_close($curl);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metadata']['code'] == "1") { 
            $callback = array(
                'status' => 'success',
                'message' => $JsonData['metadata']['message']
            );
            return $callback;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metadata']['message']

            );
            return $callback;
        }
    }
    function GosendBPJSReset($data)
    {
        
        $this->db->query(" SELECT A.ROOM_ID,A.CLASS_ID,A.ROOM,A.CLASS,A.BED,A.BRIDGE_BPJS ,B.IDkelasBPJS
                            FROM MasterdataSQL.dbo.MstrROOM A
					        INNER JOIN RawatInapSQL.dbo.TblKelas B
					        ON a.CLASS_ID = b.IDkelas ");
    

            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $IdAuto = $key['ROOM_ID'];
                $IDkelasBPJS = $key['IDkelasBPJS'];
                $ROOM = $key['ROOM'];
                $BED = $key['BED'];
                $curl = curl_init();
                $headerbpjs = Utils::headerBPJS_BPJS_Aplicares();
                curl_setopt_array($curl, array(
                    CURLOPT_URL =>  'https://new-api.bpjs-kesehatan.go.id/aplicaresws/rest/bed/delete/0114R067',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => false,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => '{ "kodekelas":"' . $IDkelasBPJS . '", 
                            "koderuang":"' . $IdAuto . '", 
                            "namaruang":"' . $ROOM . '", 
                            "kapasitas":"' . $BED . '", 
                            "tersedia":"' . $BED . '",
                            "tersediapria":"0", 
                            "tersediawanita":"0", 
                            "tersediapriawanita":"0"
                        }',
                    CURLOPT_HTTPHEADER => $headerbpjs,
                ));

                $output = curl_exec($curl);

                // tutup curl 
                curl_close($curl);
                // ubah string JSON menjadi array
                $JsonData = json_decode($output, TRUE);
                if ($JsonData['metadata']['code'] == "1") {
                    $this->db->query("UPDATE MasterdataSQL.DBO.MstrROOM SET 
                    BRIDGE_BPJS='0'
                        WHERE ROOM_ID=:ROOM_ID");
                    $this->db->bind('ROOM_ID', $IdAuto);
                    $this->db->execute();
                    $callback = array(
                        'status' => 'success',
                        'message' => $JsonData['metadata']['message']
                    );
                   // return $callback;
                } else {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => $JsonData['metadata']['message']

                    );
                   // return $callback;
                }
            }

         
        
    }

    function GosendBPJSAddAll($lantai)
    {  
        
        $this->db->query("  SELECT x.LANTAI,  x.KLSID,x.Class,kapasitas as Jumlah,
                            sum(isnull(x.terpakai,0) ) as terpakai,sum(isnull(x.sisa,0) ) as tersedia,KodeLokasi,Room,KdKlsBPJS
                            from (
                            SELECT  a.KLSID,a.Class,b.BED as kapasitas, CASE WHEN a.status=0 THEN COUNT(status) END AS sisa,
                            CASE WHEN a.status=1 THEN COUNT(status) END AS terpakai,a.kodelokasi,a.Room,a.KdKlsBPJS,a.publish,b.LANTAI
                            FROM RawatInapSQL.dbo.View_InformasiKamarRI a
                            inner join MasterdataSQL.dbo.MstrROOM b
                            on b.ROOM_ID = a.kodelokasi 
                            where  a.publish='1' and b.ACTIVE='1'  and b.LANTAI = :Lantai
                            GROUP BY a.Class,a.status,a.KLSID,a.kodelokasi,a.Room,a.KdKlsBPJS,b.BED ,a.publish,b.LANTAI
                            ) x 
                            group by lantai,KLSID,Class,kapasitas,KodeLokasi,Room,KdKlsBPJS
                            order by lantai asc ,  x.Class asc
                        "); 

        $this->db->bind('Lantai', $lantai);
        $data =  $this->db->resultSet();
        foreach ($data as $key) {
            $IDkelasBPJS = $key['KdKlsBPJS'];
            $KodeLokasi = $key['KodeLokasi']; 
            $Room= $key['Room']; 
            $kapasitas= $key['Jumlah']; 
            $tersedia= $key['tersedia']; 
            $curl = curl_init();
            $headerbpjs = Utils::headerBPJS_BPJS_Aplicares();
    
            curl_setopt_array($curl, array(
                CURLOPT_URL =>  'https://new-api.bpjs-kesehatan.go.id/aplicaresws/rest/bed/create/0114R067',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{ "kodekelas":"'. $IDkelasBPJS. '", 
                        "koderuang":"' . $KodeLokasi . '", 
                        "namaruang":"' . $Room . '", 
                        "kapasitas":"' . $kapasitas . '", 
                        "tersedia":"' . $tersedia . '",
                        "tersediapria":"0", 
                        "tersediawanita":"0", 
                        "tersediapriawanita":"0"
                    }',
                CURLOPT_HTTPHEADER => $headerbpjs,
            ));
    
            $output = curl_exec($curl);
    
            // tutup curl 
            curl_close($curl); 
            // ubah string JSON menjadi array
            $JsonData = json_decode($output, TRUE);
            if ($JsonData['metadata']['code'] == "1") {
                $this->db->query("UPDATE MasterdataSQL.DBO.MstrROOM SET 
                   BRIDGE_BPJS='1'
                    WHERE ROOM_ID=:ROOM_ID");
                $this->db->bind('ROOM_ID', $KodeLokasi); 
                $this->db->execute(); 
                $callback = array(
                    'status' => 'success', 
                    'message' => $JsonData['metadata']['message']
                );
                return $callback;
            } else {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => $JsonData['metadata']['message']
    
                );
                return $callback;
            }
        } 
    }
}
