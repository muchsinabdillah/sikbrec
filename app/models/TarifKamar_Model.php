<?php
class TarifKamar_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getAllTarifKamar()
    {
        try {
            $this->db->query("SELECT A.ID,A.KLSID,A.Group_Tarif,A.TarifKamar,A.Tanggal_Berlaku,A.Tanggal_Expired,B.NamaKelas
                            FROM MasterdataSQL.DBO.MstrRoomID_2 A
                            INNER JOIN RawatInapSQL.DBO.TblKelas B
                            ON A.KLSID = B.IDkelas
                            ORDER BY A.ID DESC");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['CLASS_ID'] = $key['KLSID'] . ' - ' . $key['NamaKelas'];
                $pasing['Group_Tarif'] = $key['Group_Tarif']; 
                $pasing['TarifKamar'] = $key['TarifKamar'];
                $pasing['Tanggal_Berlaku'] = $key['Tanggal_Berlaku'];
                $pasing['Tanggal_Expired'] = $key['Tanggal_Expired'];
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
    public function getAllTarifKamarByGroupTarif($data)
    {
        try {
            $idLantai = $data['LantaiID'];
            if ($idLantai <> "") {
                $this->db->query("SELECT A.ID,A.KLSID,A.Group_Tarif,A.TarifKamar,A.Tanggal_Berlaku,A.Tanggal_Expired,B.NamaKelas
                            FROM MasterdataSQL.DBO.MstrRoomID_2 A
                            INNER JOIN RawatInapSQL.DBO.TblKelas B
                            ON A.KLSID = B.IDkelas
                            WHERE A.Group_Tarif=:idLantai
                            ORDER BY A.ID DESC");
                $this->db->bind('idLantai', $idLantai);
            } else {
                $this->db->query("SELECT A.ID,A.KLSID,A.Group_Tarif,A.TarifKamar,A.Tanggal_Berlaku,A.Tanggal_Expired,B.NamaKelas
                            FROM MasterdataSQL.DBO.MstrRoomID_2 A
                            INNER JOIN RawatInapSQL.DBO.TblKelas B
                            ON A.KLSID = B.IDkelas
                            ORDER BY A.ID DESC");
            }



            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['CLASS_ID'] = $key['KLSID'] . ' - ' . $key['NamaKelas'];
                $pasing['Group_Tarif'] = $key['Group_Tarif'];
                $pasing['TarifKamar'] = $key['TarifKamar'];
                $pasing['Tanggal_Berlaku'] = $key['Tanggal_Berlaku'];
                $pasing['Tanggal_Expired'] = $key['Tanggal_Expired'];
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
            if ($data['TRFKMR_ClassID'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Pilih Kelas !',
                );
                return $callback;
                exit;
            }
            if ($data['TRFKMR_GroupTarif'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Pilih Group Tarif !',
                );
                return $callback;
                exit;
            }
            if ($data['TRFKMR_Nilai'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Nilai Tarif !',
                );
                return $callback;
                exit;
            }
            if ($data['TRFKMR_TglBerlaku'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Tanggal Berlaku !',
                );
                return $callback;
                exit;
            } 

            $IdAuto = $data['IdAuto'];
            $TRFKMR_ClassID = $data['TRFKMR_ClassID'];
            $TRFKMR_GroupTarif = $data['TRFKMR_GroupTarif'];
            $TRFKMR_Nilai = $data['TRFKMR_Nilai'];
            $TRFKMR_TglBerlaku = $data['TRFKMR_TglBerlaku'];
            $TRFKMR_TglExpired = "3000-01-01";
            $dateNow = Utils::seCurrentDateTime();
            $datenowMinOne = date('Y-m-d', strtotime('-1 days', strtotime($TRFKMR_TglBerlaku)));
            if ($IdAuto == "") {  
                // update Expired Sebelumnya
                $this->db->query("UPDATE MasterdataSQL.dbo.MstrRoomID_2 set  
                            Tanggal_Expired=:Tanggal_Expired 
                            WHERE KLSID=:TRFKMR_ClassID and Group_Tarif=:Group_Tarif
                            and  replace(CONVERT(VARCHAR(11), Tanggal_Expired, 111), '/','-') =:tglaktif"); 
                $this->db->bind('Tanggal_Expired', $datenowMinOne);
                $this->db->bind('TRFKMR_ClassID', $TRFKMR_ClassID);
                $this->db->bind('tglaktif', '3000-01-01');
                $this->db->bind('Group_Tarif', $TRFKMR_GroupTarif);
                $this->db->execute();


                $this->db->query("INSERT INTO MasterdataSQL.DBO.MstrRoomID_2
                    (KLSID,Group_Tarif,TarifKamar,Tanggal_Berlaku,Tanggal_Expired) 
                    VALUES
                    (:KLSID,:Group_Tarif,:TarifKamar,:Tanggal_Berlaku,:Tanggal_Expired)");
                $this->db->bind('KLSID', $TRFKMR_ClassID);
                $this->db->bind('Group_Tarif', $TRFKMR_GroupTarif);
                $this->db->bind('TarifKamar', $TRFKMR_Nilai);
                $this->db->bind('Tanggal_Berlaku', $TRFKMR_TglBerlaku);
                $this->db->bind('Tanggal_Expired', $TRFKMR_TglExpired);
                $this->db->execute();
            } else {
                $this->db->query("UPDATE MasterdataSQL.dbo.MstrRoomID_2 
                            set  TarifKamar=:TarifKamar 
                            WHERE ID=:ID"); 
                $this->db->bind('TarifKamar', $TRFKMR_Nilai); 
                $this->db->bind('ID', $IdAuto);
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
    public function getTarifRoomId($id)
    {

        try {
            $this->db->query("SELECT ID,KLSID,Group_Tarif,TarifKamar,  
                            replace(CONVERT(VARCHAR(11),Tanggal_Berlaku, 111), '/','-') AS Tanggal_Berlaku,
                            replace(CONVERT(VARCHAR(11),Tanggal_Expired, 111), '/','-') AS Tanggal_Expired 
                            FROM MasterdataSQL.DBO.MstrRoomID_2
                            WHERE ID =:id");
            $this->db->bind('id', $id);
            $data =  $this->db->single();
            $pasing['KLSID'] = $data['KLSID'];
            $pasing['Group_Tarif'] = $data['Group_Tarif'];
            $pasing['TarifKamar'] = $data['TarifKamar'];
            $pasing['Tanggal_Berlaku'] = $data['Tanggal_Berlaku'];
            $pasing['Tanggal_Expired'] = $data['Tanggal_Expired'];
            $pasing['ID'] = $data['ID']; 
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
					        ON a.CLASS_ID = b.ID
                            WHERE a.ROOM_ID=:id");
        $this->db->bind('id', $IdAuto);
        $data =  $this->db->single();
        $IDkelasBPJS = $data['IDkelasBPJS'];
        $ROOM = $data['ROOM'];
        $BED = $data['BED'];
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
					        ON a.CLASS_ID = b.ID
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
}
