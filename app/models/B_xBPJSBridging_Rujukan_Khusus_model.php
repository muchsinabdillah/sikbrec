<?php
class B_xBPJSBridging_Rujukan_Khusus_model
{
    use BPJS;
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }
    // insert rujukan khusus
    public function save($data)
    {

            //DIAGNOSA
            $this->db->query("SELECT DIAGNOSA_TIPE+';'+DIAGNOSA_KODE AS DIAGNOSA
                        FROM PerawatanSQL.DBO.BPJS_T_RUJUKAN_KHUSUS_DTL
                        where NO_RUJUKAN=:id and BATAL='0'");
            $this->db->bind('id', $data['IdTrsAuto']);
            $datadiag =  $this->db->resultSet();
            $rows = array();
            foreach ($datadiag as $key) {
                $pasing['kode'] = $key['DIAGNOSA']; 
                $rowsDiagnosa[] = $pasing;
            } 
        $session = SessionManager::getCurrentSession();
        $userid = $session->name;
            //PROCEDURE
            $this->db->query("SELECT  PROCEDURE_CODE  
                                FROM PerawatanSQL.DBO.BPJS_T_RUJUKAN_KHUSUS_DTL
                                where NO_RUJUKAN=:id and BATAL='0' and PROCEDURE_CODE<>''");
            $this->db->bind('id', $data['IdTrsAuto']);
            $data2 =  $this->db->resultSet();
            $rows2 = array();
            foreach ($data2 as $key2) {
                $pasing2['kode'] = $key2['PROCEDURE_CODE'];
                $rowsProcedure[] = $pasing2;
            } 
        $request =  [
            "noRujukan" => $data['nomorrujukan'],
            "diagnosa" =>
            $rowsDiagnosa,
            "procedure" =>
            $rowsProcedure,
            "user" => $userid
        ]; 

        $curl = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        curl_setopt($curl, CURLOPT_URL, URL_BPJS . "Rujukan/Khusus/insert"
        );
        // set header
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headerbpjs);
        // set time out
        curl_setopt($curl, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        // data yang dikirim
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($request));
        // return the transfer as a string 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        //var_dump($request);
       // exit;

        $output = curl_exec($curl);
        // tutup curl 
        curl_close($curl);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            // OFF NUNGGU SUKSES DULU
            //$EncodeData = json_encode($JsonData);
            //$ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, Utils::setKey()); 
            //$JsonDatax   = json_decode(json_encode($ResultEncriptLzString), true);
            //$noSPRI = $JsonDatax['1']['noSPRI'];
            $this->db->query("UPDATE PerawatanSQL.DBO.BPJS_T_RUJUKAN_KHUSUS_hdr  SET 
            SEND_BRIDGE='1'
            WHERE NO_RUJUKAN=:NO_RUJUKAN");
            $this->db->bind('NO_RUJUKAN', $data['nomorrujukan']); 
            $this->db->execute(); 
            $callback = array(
                'status' => 'success',
                'message' => 'Data Rujukan Khusus Berhasil Dihapus !',
            );
            return $callback;
            //return $JsonDatax;
        } else {
            $callback = array(
                    'status' => 'warning',
                    'errorname' => $JsonData['metaData']['message']

                );
            return $callback;
        }
    }

    public function spesialistik($data)
    {
        $listspesialistik = $this->bpjsAPI("GET", "/Rujukan/ListSpesialistik/PPKRujukan/" . $data['kodeppk'] . "/TglRujukan/" . $data['tglrujukan'], "Application/x-www-form-urlencoded");
        return $listspesialistik;
    }
    public function CreateRujukanKhususTRS($data)
    {
        try {
            $this->db->transaksi();

            $IdTrsAuto = $data['IdTrsAuto'];
            $nomorrujukan = $data['nomorrujukan']; 
            $datenowcreate = Utils::seCurrentDateTime();
            //Session user
            $session = SessionManager::getCurrentSession();
            $userid =  $session->IDEmployee;
            if ($IdTrsAuto <> "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Sedang Ada No Rujukan Aktif, Silahkan Refresh halaman Untuk membuat Transaksi Baru !',
                );
                return $callback;
                exit;
            }
            if ($nomorrujukan == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input No. Rujukan !',
                );
                return $callback;
                exit;
            }

            

            //get hdr
            $this->db->query("SELECT ID from PerawatanSQL.dbo.BPJS_T_RUJUKAN_KHUSUS_HDR  
                            WHERE NO_RUJUKAN=:nomorrujukan and BATAL='0'");
            $this->db->bind('nomorrujukan', $nomorrujukan);
            $data =  $this->db->single();
            $idprb = $data['ID'];

            if ($idprb != "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Nomor Rujukan Ini Sudah Mempunyai ID Rujukan Khusus ! Silahkan Refresh Halaman !',
                );
                return $callback;
                exit;
            }

            $this->db->query("INSERT INTO PerawatanSQL.[dbo].BPJS_T_RUJUKAN_KHUSUS_HDR
                    (NO_RUJUKAN,TGL_CREATE,USER_CREATE)
                    VALUES
                    (:nomorrujukan,:datenowcreate,:userid)");
            $this->db->bind('nomorrujukan', $nomorrujukan);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('userid', $userid); 


            $this->db->execute();
            $idhdrprb = $this->db->GetLastID();
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success  
                'idhdrjkkhusus' => $idhdrprb, // Set array status dengan success    
                'StausBridging' => '0', // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function CreateRujukanKhususTRSdetil($data)
    {
        try {
            $this->db->transaksi();

            $IdTrsAuto = $data['IdTrsAuto'];
            $nomorrujukan = $data['nomorrujukan'];
            $tipediagnosa = $data['tipediagnosa'];
            $prosedurRujukanKhusus = $data['prosedurRujukanKhususKode'];
            $prosedurRujukanKhususName = $data['prosedurRujukanKhususName'];
            $diagnosarujukanKhusus = $data['diagnosarujukanKhususkode'];
            $diagnosarujukanKhususName = $data['diagnosarujukanKhususName'];
            $datenowcreate = Utils::seCurrentDateTime();
            //Session user
            $session = SessionManager::getCurrentSession();
            $userid =  $session->name;
            if ($IdTrsAuto == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input No. Rujukan Auto !',
                );
                return $callback;
                exit;
            }
            if ($nomorrujukan == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input No. Rujukan !',
                );
                return $callback;
                exit;
            }
            if ($tipediagnosa == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Tipe Diagnosa !',
                );
                return $callback;
                exit;
            }
            if ($prosedurRujukanKhusus == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Procedure !',
                );
                return $callback;
                exit;
            }
            if ($diagnosarujukanKhusus == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Dianosa !',
                );
                return $callback;
                exit;
            }
            if($tipediagnosa=="P"){ 
                $this->db->query("SELECT DIAGNOSA_KODE from PerawatanSQL.DBO.BPJS_T_RUJUKAN_KHUSUS_DTL  
                            WHERE NO_RUJUKAN=:nomorrujukan and BATAL='0' and DIAGNOSA_KODE=:DIAGNOSA_KODE and DIAGNOSA_TIPE='P' ");
                $this->db->bind('nomorrujukan', $nomorrujukan);
                $this->db->bind('DIAGNOSA_KODE', $diagnosarujukanKhusus);
                $data =  $this->db->single();
                $idprb = $data['DIAGNOSA_KODE'];

                if ($idprb != "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Diagnosa Primer Kode ini :'. $diagnosarujukanKhusus . ' Sudah Ada !',
                    );
                    return $callback;
                    exit;
                }
            }
            if ($tipediagnosa == "S") { 
                $this->db->query("SELECT DIAGNOSA_KODE from PerawatanSQL.DBO.BPJS_T_RUJUKAN_KHUSUS_DTL  
                            WHERE NO_RUJUKAN=:nomorrujukan and BATAL='0' and DIAGNOSA_KODE=:DIAGNOSA_KODE and DIAGNOSA_TIPE='S' ");
                $this->db->bind('nomorrujukan', $nomorrujukan);
                $this->db->bind('DIAGNOSA_KODE', $diagnosarujukanKhusus);
                $data =  $this->db->single();
                $idprb = $data['DIAGNOSA_KODE'];

                if ($idprb != "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Diagnosa Sekunder Kode ini :' . $diagnosarujukanKhusus . ' Sudah Ada !',
                    );
                    return $callback;
                    exit;
                }
            }
            $this->db->query("SELECT PROCEDURE_CODE from PerawatanSQL.DBO.BPJS_T_RUJUKAN_KHUSUS_DTL  
                            WHERE NO_RUJUKAN=:nomorrujukan and BATAL='0' and PROCEDURE_CODE=:PROCEDURE_CODE  ");
            $this->db->bind('nomorrujukan', $nomorrujukan);
            $this->db->bind('PROCEDURE_CODE', $prosedurRujukanKhusus);
            $data =  $this->db->single();
            $idprb = $data['PROCEDURE_CODE'];

            if ($idprb != "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Procedure Kode ini :' . $prosedurRujukanKhusus . ' Sudah Ada !',
                );
                return $callback;
                exit;
            }
            
            $this->db->query("INSERT INTO PerawatanSQL.[dbo].BPJS_T_RUJUKAN_KHUSUS_DTL
                    (NO_RUJUKAN,DIAGNOSA_TIPE,DIAGNOSA_KODE,PROCEDURE_CODE,TGL_CREATE,USER_CREATE,
                    DIAGNOSA_NAME,PROCEDURE_NAME)
                    VALUES
                    (:nomorrujukan,:DIAGNOSA_TIPE,:DIAGNOSA_KODE,:PROCEDURE_CODE, :datenowcreate,:userid,
                    :DIAGNOSA_NAME,:PROCEDURE_NAME)");
            $this->db->bind('nomorrujukan', $IdTrsAuto);
            $this->db->bind('DIAGNOSA_KODE', $diagnosarujukanKhusus);
            $this->db->bind('DIAGNOSA_TIPE', $tipediagnosa);
            $this->db->bind('PROCEDURE_CODE', $prosedurRujukanKhusus);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('userid', $userid);
            $this->db->bind('DIAGNOSA_NAME', $diagnosarujukanKhususName);
            $this->db->bind('PROCEDURE_NAME', $prosedurRujukanKhususName);


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
    public function getListRujukanKhusus($id)
    {
        try {
            $this->db->query("  SELECT *FROM  PerawatanSQL.DBO.BPJS_T_RUJUKAN_KHUSUS_DTL
                                WHERE BATAL='0' AND NO_RUJUKAN=:id ");
            $this->db->bind('id', $id);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['DIAGNOSA_TIPE'] = $key['DIAGNOSA_TIPE'];
                $pasing['DIAGNOSA_NAME'] = $key['DIAGNOSA_NAME'];
                $pasing['PROCEDURE_NAME'] = $key['PROCEDURE_NAME']; 
                $pasing['ID'] = $key['ID'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function GoListRujukanData($data)
    {
        try {
            $this->db->query("  SELECT ID, NO_RUJUKAN,NAMA_PASIEN,NO_KARTU,KODE_DIAGNOSA,TGL_RUJUKAN_AWAL, TGL_RUJUKAN_AKHIR,SEND_BRIDGE
                                FROM PerawatanSQL.DBO.BPJS_T_RUJUKAN_KHUSUS_hdr
                                WHERE BATAL='0' AND replace(CONVERT(VARCHAR(11),TGL_CREATE, 111), '/','-') =:MTglKunjunganBPJS");
            $this->db->bind('MTglKunjunganBPJS', $data['MTglKunjunganBPJS']);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['NO_RUJUKAN'] = $key['NO_RUJUKAN'];
                $pasing['NAMA_PASIEN'] = $key['NAMA_PASIEN'];
                $pasing['NO_KARTU'] = $key['NO_KARTU'];
                $pasing['KODE_DIAGNOSA'] = $key['KODE_DIAGNOSA'];
                $pasing['TGL_RUJUKAN_AWAL'] = $key['TGL_RUJUKAN_AWAL'];
                $pasing['TGL_RUJUKAN_AKHIR'] = $key['TGL_RUJUKAN_AKHIR'];
                $pasing['SEND_BRIDGE'] = $key['SEND_BRIDGE']; 
                $pasing['ID'] = $key['ID'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function voidAllRujukanKhusus($data){
        try {
            $this->db->transaksi();

            $noregbatal = $data['noregbatal'];
            $alasanbatal = $data['alasanbatal'];
            $datenowcreate = Utils::seCurrentDateTime();
            //Session user
            $session = SessionManager::getCurrentSession();
            //$userid =  $session->IDEmployee;
            $userid =  $session->name;

            if ($noregbatal == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input No. Rujukan !',
                );
                return $callback;
                exit;
            }

            if ($alasanbatal == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Alasan Batal !',
                );
                return $callback;
                exit;
            } 
            $this->db->query("UPDATE PerawatanSQL.DBO.BPJS_T_RUJUKAN_KHUSUS_hdr SET BATAL='1' 
                            , TGL_BATAL=:TGL_BATAL,USER_BATAL=:USER_BATAL ,ALASAN=:ALASAN
                            WHERE ID=:ID"); 
            $this->db->bind('TGL_BATAL', $datenowcreate);
            $this->db->bind('USER_BATAL', $userid);
            $this->db->bind('ID', $noregbatal);
            $this->db->bind('ALASAN', $alasanbatal);  
            $this->db->execute();

            $this->db->query("UPDATE PerawatanSQL.DBO.BPJS_T_RUJUKAN_KHUSUS_dtl SET BATAL='1' 
                            , TGL_BATAL=:TGL_BATAL,USER_BATAL=:USER_BATAL ,ALASAN=:ALASAN
                            WHERE NO_RUJUKAN=:ID");
            $this->db->bind('TGL_BATAL', $datenowcreate);
            $this->db->bind('USER_BATAL', $userid);
            $this->db->bind('ID', $noregbatal);
            $this->db->bind('ALASAN', $alasanbatal);
            $this->db->execute(); 

            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Dibatalkan !', // Set array status dengan success   
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function voidAllRujukanKhususDTL($data)
    {
        try {
            $this->db->transaksi();

            $noregbatal = $data['noregbataldtl'];
            $alasanbatal = $data['alasanbataldtl'];
            $datenowcreate = Utils::seCurrentDateTime();
            //Session user
            $session = SessionManager::getCurrentSession();
            //$userid =  $session->IDEmployee;
            $userid =  $session->name;

            if ($noregbatal == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input No. Rujukan !',
                );
                return $callback;
                exit;
            }

            if ($alasanbatal == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Alasan Batal !',
                );
                return $callback;
                exit;
            } 

            $this->db->query("UPDATE PerawatanSQL.DBO.BPJS_T_RUJUKAN_KHUSUS_dtl SET BATAL='1' 
                            , TGL_BATAL=:TGL_BATAL,USER_BATAL=:USER_BATAL ,ALASAN=:ALASAN
                            WHERE ID=:ID");
            $this->db->bind('TGL_BATAL', $datenowcreate);
            $this->db->bind('USER_BATAL', $userid);
            $this->db->bind('ID', $noregbatal);
            $this->db->bind('ALASAN', $alasanbatal);
            $this->db->execute();

            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Dibatalkan !', // Set array status dengan success   
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
}
