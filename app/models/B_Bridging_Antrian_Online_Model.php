<?php
class B_Bridging_Antrian_Online_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    function GetReferensiPoli()
    {
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS_Antrian($tStamp);
        // persiapkan curl
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => URL_BPJS_ANTRIAN . "ref/poli",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            
            CURLOPT_HTTPHEADER => $headerbpjs,
        ));
        $output = curl_exec($curl);
        // tutup curl 
        curl_close($curl);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
         
        if ($JsonData['metadata']['code'] == "1") {
            $EncodeData = json_encode($JsonData);
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2_Antrian_Reff($EncodeData, GenerateBpjs::keyString(Utils::setConsid_Antrian(), Utils::setSeckey_Antrian(), $tStamp));
            foreach ($ResultEncriptLzString['1'] as $key => $jsons) { // This will search in the 2 jsons 
                $pasing['kdpoli'] = $jsons['kdpoli'];
                $pasing['kdsubspesialis'] = $jsons['kdsubspesialis'];
                $pasing['nmpoli'] = $jsons['nmpoli'];
                $pasing['nmsubspesialis'] = $jsons['nmsubspesialis'];
                // $this->db->query("INSERT INTO perawatanSQL.dbo.BPJS_REF_POLI
                //             (kdpoli,kdsubspesialis,nmpoli,nmsubspesialis)
                //             VALUES 
                //             (:kdpoli,:kdsubspesialis,:nmpoli,:nmsubspesialis)");
                // $this->db->bind('kdpoli', $jsons['kdpoli']);
                // $this->db->bind('kdsubspesialis', $jsons['kdsubspesialis']);
                // $this->db->bind('nmpoli', $jsons['nmpoli']);
                // $this->db->bind('nmsubspesialis', $jsons['nmsubspesialis']); 
                // $this->db->execute();
                $datas[] = $pasing;
            }
            return $datas;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']

            );
            return $callback;
        }
    }
    function GetReferensiDokter()
    {
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS_Antrian($tStamp);
        // persiapkan curl
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => URL_BPJS_ANTRIAN . "ref/dokter",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',

            CURLOPT_HTTPHEADER => $headerbpjs,
        ));
        $output = curl_exec($curl);
        // tutup curl 
        curl_close($curl);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);

        if ($JsonData['metadata']['code'] == "1") {
            $EncodeData = json_encode($JsonData);
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2_Antrian_Reff($EncodeData, GenerateBpjs::keyString(Utils::setConsid_Antrian(), Utils::setSeckey_Antrian(), $tStamp));
            foreach ($ResultEncriptLzString['1'] as $key => $jsons) { // This will search in the 2 jsons 
                $pasing['namadokter'] = $jsons['namadokter'];
                $pasing['kodedokter'] = $jsons['kodedokter']; 
                $this->db->query("INSERT INTO perawatanSQL.dbo.BPJS_REF_DOKTER
                            (namadokter,kodedokter)
                            VALUES 
                            (:namadokter,:kodedokter)");
                $this->db->bind('namadokter', $jsons['namadokter']);
                $this->db->bind('kodedokter', $jsons['kodedokter']); 
                $this->db->execute();
                $datas[] = $pasing;
            }
            return $datas;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']

            );
            return $callback;
        }
    }
    function GoListWaktuTask($data)
    {
        $MNoTrs = $data['MNoTrs'];

        if ($MNoTrs == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Masukan No. TRS !',
            );
            echo json_encode($callback);
            exit;
        }
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS_Antrian($tStamp);
        // persiapkan curl
        $curl = curl_init();  
        curl_setopt_array($curl, array(
            CURLOPT_URL => URL_BPJS_ANTRIAN . "antrean/getlisttask",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "kodebooking": "'. $MNoTrs .'"
                }',
            CURLOPT_HTTPHEADER => $headerbpjs,
        ));
        $output = curl_exec($curl);
        // tutup curl 
        curl_close($curl);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metadata']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2_Antrian($EncodeData, GenerateBpjs::keyString(Utils::setConsid_Antrian(), Utils::setSeckey_Antrian(), $tStamp));
            foreach ($ResultEncriptLzString['1'] as $key => $jsons) { // This will search in the 2 jsons 
                $pasing['wakturs'] = $jsons['wakturs'];
                $pasing['waktu'] = $jsons['waktu'];
                $pasing['taskname'] = $jsons['taskname'];
                $pasing['taskid'] = $jsons['taskid'];
                $pasing['kodebooking'] = $jsons['kodebooking']; 
                $datas[] = $pasing;
            }
            return $datas;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']

            );
            return $callback;
        }
    }
    function UpdateTaskAntrianBPJS($data)
    {
        $curl = curl_init();
        $kodebooking = $data['kodebooking']; 

        if ($kodebooking == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Masukan Kode Booking !',
            );
            echo json_encode($callback);
            exit;
        }
         
        // CARI DULU NO BOOKING, APAKAH DARI MOBILE JKN 
        $this->db->query("SELECT NoRegistrasi,NoBooking 
                            FROM PerawatanSQL.DBO.Apointment WHERE NoRegistrasi=:kodebooking AND Company=:company");
        $this->db->bind('kodebooking', $kodebooking);
        $this->db->bind('company', 'JKN MOBILE');
        $dtaptmn =  $this->db->single();
        $dtrowCount =  $this->db->rowCount();
        if ($dtrowCount <> 0) {
            $kodebookingx = $dtaptmn['NoBooking'];
        } else {
            $kodebookingx = $kodebooking;
        }
        $waktux = Utils::seCurrentDateTime();
        $estimasi2 = strtotime($waktux);
        $estimasidilayani = $estimasi2 * 1000;
        //waktu  
        $session = SessionManager::getCurrentSession();
        $userid = $session->username;
        $token = $session->token;
        $namauserx = $session->name;
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS_Antrian($tStamp);
        $dateNows = Utils::seCurrentDateTime();
        $datenownotfull = Utils::datenowcreateNotFull();
       
        // update ke tabel sep dulu untuk waktu task nya....
        $this->db->query("SELECT Task3
                        FROM PerawatanSQL.DBO.BPJS_T_SEP
                        WHERE NO_REGISTRASI=:kodebookingx ");
        $this->db->bind('kodebookingx', $kodebooking);
        $this->db->execute();
        $datarow =  $this->db->single();
        if ($datarow['Task3'] == null) {
            $callback = array(
                'status' => 'warning',
                'errorname' => "Task 3 Masih Kosong, Silahkan Konfirmasi ke Perawat Untuk Save Nursing Assesment !!!!",
            );
            return $callback;
            exit;
        } else {
            $this->db->query("UPDATE PerawatanSQL.DBO.AntrianPasien SET StatusAntrian='1' 
                                WHERE no_transaksi=:kodebookingx");
            $this->db->bind('kodebookingx', $kodebookingx);
            $this->db->execute();
            
            $this->db->query("SELECT Task4
                                FROM PerawatanSQL.DBO.BPJS_T_SEP
                                WHERE NO_REGISTRASI=:kodebookingx ");
            $this->db->bind('kodebookingx', $kodebooking);
            $this->db->execute();
            $datarow =  $this->db->single();
            if ($datarow['Task4'] == null) {
                $this->db->query("UPDATE PerawatanSQL.DBO.BPJS_T_SEP SET Task4=:task4time
                                        WHERE NO_REGISTRASI=:kodebookingx");
                $this->db->bind('kodebookingx', $kodebooking);
                $this->db->bind('task4time', $waktux);
                $this->db->execute();
            }
            $callback = array(
                'status' => 'success',
                'Max_JKN' => 'tes',
            );
            return $callback;
        }
               
        
            // $curl = curl_init();
            // $taskid = "4";
            // curl_setopt_array($curl, array(
            //     CURLOPT_URL =>  URL_BPJS_ANTRIAN . 'antrean/updatewaktu',
            //     CURLOPT_RETURNTRANSFER => true,
            //     CURLOPT_ENCODING => '',
            //     CURLOPT_MAXREDIRS => 10,
            //     CURLOPT_TIMEOUT => 0,
            //     CURLOPT_FOLLOWLOCATION => false,
            //     CURLOPT_SSL_VERIFYPEER => false,
            //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //     CURLOPT_CUSTOMREQUEST => 'POST',
            //     CURLOPT_POSTFIELDS => '                                                
            //         {
            //             "kodebooking": "' . $kodebookingx . '",
            //             "taskid":  "' . $taskid . '",
            //             "waktu": "' . $estimasidilayani . '"
            //         }
            //             ',
            //     CURLOPT_HTTPHEADER => $headerbpjs,
            // ));
            // $output = curl_exec($curl);
            // // tutup curl 
            // curl_close($curl);
            // // ubah string JSON menjadi array
            // $JsonData = json_decode($output, TRUE);
            // if ($JsonData['metadata']['code'] == "200") {
            //     $this->db->query("INSERT INTO perawatanSQL.dbo.BPJS_TASKID_LOG 
            //                         (KODE_TRANSAKSI,WAKTU,TASK_ID,DATE_CREATE) 
            //                         VALUES 
            //                         (:kodebooking,:waktu,:taskid,:DATE_CREATE)");
            //     $this->db->bind('kodebooking', $kodebookingx);
            //     $this->db->bind('waktu', $estimasidilayani);
            //     $this->db->bind('taskid', $taskid);
            //     $this->db->bind('DATE_CREATE', $waktux);
            //     $this->db->execute(); 
            //     $callback = array(
            //         'status' => 'success',
            //         'Max_JKN' => 'tes',
            //     );
            //     return $callback;
            // } else {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => $JsonData['metadata']['message'],
            //     );
            //     return $callback;
            // }

       
    }
    function UpdateTaskAntrianBPJS2($data)
    {
        $curl = curl_init();
        $kodebooking = $data['kodebooking'];

        if ($kodebooking == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Masukan Kode Booking !',
            );
            echo json_encode($callback);
            exit;
        }

        // CARI DULU NO BOOKING, APAKAH DARI MOBILE JKN 
        $this->db->query("SELECT NoRegistrasi,NoBooking 
                            FROM PerawatanSQL.DBO.Apointment WHERE NoRegistrasi=:kodebooking AND Company=:company");
        $this->db->bind('kodebooking', $kodebooking);
        $this->db->bind('company', 'JKN MOBILE');
        $dtaptmn =  $this->db->single();
        $dtrowCount =  $this->db->rowCount();
        if ($dtrowCount > 0) {
            $kodebookingx = $dtaptmn['NoBooking'];
        } else {
            $kodebookingx = $kodebooking;
        }
        $waktux = Utils::seCurrentDateTime();
        $estimasi2 = strtotime($waktux);
        $estimasidilayani = $estimasi2 * 1000;
        //waktu  
        $session = SessionManager::getCurrentSession();
        $userid = $session->username;
        $token = $session->token;
        $namauserx = $session->name;
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS_Antrian($tStamp);
        $dateNows = Utils::seCurrentDateTime();
        $datenownotfull = Utils::datenowcreateNotFull();
        // update ke tabel sep dulu untuk waktu task nya....
        $this->db->query("SELECT Task2,Task1
                        FROM PerawatanSQL.DBO.BPJS_T_SEP
                        WHERE NO_REGISTRASI=:kodebookingx");
        $this->db->bind('kodebookingx', $kodebooking);
        $this->db->execute();
        $datarow =  $this->db->single();
        if ($datarow['Task1'] == null) {
            $callback = array(
                'status' => 'warning',
                'errorname' => "Task 1 Masih Kosong, Silahkan Konfirmasi ke Admision Untuk Kirim Task 1 !!!!",
            );
            return $callback;
            exit;
        }else{
            if ($datarow['Task2'] == null) {
                
                $this->db->query("SELECT DATEADD(minute,3,[Visit Date]) as fixTask2
                FROM PerawatanSQL.DBO.Visit
                WHERE NoRegistrasi=:noreg ");
                $this->db->bind('noreg', $kodebooking);
                $this->db->execute();
                $datarowRegFix =  $this->db->single();
                $valuewaktutask1 = $datarowRegFix['fixTask2'];

                $this->db->query("UPDATE PerawatanSQL.DBO.BPJS_T_SEP SET Task2=:task4time
                                    WHERE NO_REGISTRASI=:kodebookingx");
                $this->db->bind('kodebookingx', $kodebooking);
                $this->db->bind('task4time', $valuewaktutask1);
                $this->db->execute();
            }
            $callback = array(
                'status' => 'success',
                'Max_JKN' => 'tes',
            );
            return $callback;
        }
        

        // $curl = curl_init();
        // $taskid = "2";
        // curl_setopt_array($curl, array(
        //     CURLOPT_URL =>  URL_BPJS_ANTRIAN . 'antrean/updatewaktu',
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => '',
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => false,
        //     CURLOPT_SSL_VERIFYPEER => false,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => 'POST',
        //     CURLOPT_POSTFIELDS => '                                                
        //             {
        //                 "kodebooking": "' . $kodebookingx . '",
        //                 "taskid":  "' . $taskid . '",
        //                 "waktu": "' . $estimasidilayani . '"
        //             }
        //                 ',
        //     CURLOPT_HTTPHEADER => $headerbpjs,
        // ));
        // $output = curl_exec($curl);
        // // tutup curl 
        // curl_close($curl);
        // // ubah string JSON menjadi array
        // $JsonData = json_decode($output, TRUE);
        // if ($JsonData['metadata']['code'] == "200") {
        //     $this->db->query("INSERT INTO perawatanSQL.dbo.BPJS_TASKID_LOG 
        //                             (KODE_TRANSAKSI,WAKTU,TASK_ID,DATE_CREATE) 
        //                             VALUES 
        //                             (:kodebooking,:waktu,:taskid,:DATE_CREATE)");
        //     $this->db->bind('kodebooking', $kodebookingx);
        //     $this->db->bind('waktu', $estimasidilayani);
        //     $this->db->bind('taskid', $taskid);
        //     $this->db->bind('DATE_CREATE', $waktux);
        //     $this->db->execute();

        //     $callback = array(
        //         'status' => 'success',
        //         'Max_JKN' => 'tes',
        //     );
        //     return $callback;
        // } else {
        //     $callback = array(
        //         'status' => 'warning',
        //         'errorname' => $JsonData['metadata']['message'],
        //     );
        //     return $callback;
        // } 
    }
    function CallDokterCendana($data)
    {
        $curl = curl_init();
        $kodedokter = $data['kodedokter'];
        $koderuangan = $data['koderuangan'];

        if ($kodedokter == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Masukan Kode Dokter !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($koderuangan == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Masukan Kode Ruangan !',
            );
            echo json_encode($callback);
            exit;
        }
 

        $curl = curl_init();
        $cabang = "YARSI";
        $userid= "2400";
        curl_setopt_array($curl, array(
            CURLOPT_URL =>  URL_BPJS_ANTRIAN_CENDANA . 'tcall_dokter',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '                                                
                    {
                        "id_cabang": "' . $cabang . '",
                        "id_dokter":  "' . $kodedokter . '",
                        "user_id": "' . $userid . '",
                        "id_ruang": "' . $koderuangan . '"
                    }
                        ',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Cookie: ci_session=r9fsvr21jaobb91s5j0sln71mjcusup4'
            ),
        ));
        $output = curl_exec($curl);
        // tutup curl 
        curl_close($curl);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['status'] == "200") {
            $callback = array(
                'status' => 'success',
                'data' => $JsonData, 
            );
            return $callback;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['msg'],
            );
            return $callback;
        } 
    }
    function ReCallDokterCendana($data)
    {
        $curl = curl_init();
        $kodedokter = $data['kodedokter'];
        $koderuangan = $data['koderuangan'];

        if ($kodedokter == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Masukan Kode Dokter !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($koderuangan == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Masukan Kode Ruangan !',
            );
            echo json_encode($callback);
            exit;
        }


        $curl = curl_init();
        $cabang = "YARSI";
        $userid = "2400";
        curl_setopt_array($curl, array(
            CURLOPT_URL =>  URL_BPJS_ANTRIAN_CENDANA . 'trecall_dokter',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '                                                
                    {
                        "id_cabang": "' . $cabang . '",
                        "id_dokter":  "' . $kodedokter . '",
                        "user_id": "' . $userid . '",
                        "id_ruang": "' . $koderuangan . '"
                    }
                        ',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Cookie: ci_session=r9fsvr21jaobb91s5j0sln71mjcusup4'
            ),
        ));
        $output = curl_exec($curl);
        // tutup curl 
        curl_close($curl);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['status'] == "200") {
            $callback = array(
                'status' => 'success',
                'data' => $JsonData,
            );
            return $callback;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['msg'],
            );
            return $callback;
        }
    }
    function SpecialCallDokterCendana($data)
    {
        $curl = curl_init();
        $kodedokter = $data['kodedokter'];
        $koderuangan = $data['koderuangan'];
        $antrianNo = $data['antrianNo'];

        if ($kodedokter == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Masukan Kode Dokter !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($koderuangan == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Masukan Kode Ruangan !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($antrianNo == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Masukan No. Antrian !',
            );
            echo json_encode($callback);
            exit;
        }
        $fixnoantrian = str_replace("-","", $antrianNo);


        $curl = curl_init();
        $cabang = "YARSI";
        $userid = "2400";
        curl_setopt_array($curl, array(
            CURLOPT_URL =>  URL_BPJS_ANTRIAN_CENDANA . 'tspecialcall_dokter',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '                                                
                    {
                        "id_cabang": "' . $cabang . '",
                        "id_dokter":  "' . $kodedokter . '",
                        "user_id": "' . $userid . '",
                        "id_ruang": "' . $koderuangan . '",
                        "nomor": "' . $fixnoantrian . '"
                    }
                        ',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Cookie: ci_session=r9fsvr21jaobb91s5j0sln71mjcusup4'
            ),
        ));
        $output = curl_exec($curl);
        // tutup curl 
        curl_close($curl);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['status'] == "200") {
            $callback = array(
                'status' => 'success',
                'data' => $JsonData,
            );
            return $callback;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['msg'],
            );
            return $callback;
        }
    }
    function xGoSendHFIS($data)
    {
       
        $dataid = $data['dataid'];

        if ($dataid == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Kode Invalid !',
            );
            echo json_encode($callback);
            exit;
        }

        // cari kode bpjs - poli 
        $this->db->query("SELECT a.IDUnit,b.codeBPJS, CodeSubBPJS as CodeSubBPJS
                        FROM MasterdataSQL.DBO.JadwalPraktek a
                        inner join MasterdataSQL.dbo.MstrUnitPerwatan b
                        on a.IDUnit = b.ID  WHERE a.ID=:dataid  ");
        $this->db->bind('dataid', $dataid);
        $dtunit =  $this->db->single();
        $codeUnitBPJS = $dtunit['codeBPJS'];
        $codeUnitSubBPJS = $dtunit['CodeSubBPJS'];
        
        // cari kode bpjs - poli 
        $this->db->query("	 SELECT a.IDUnit,b.ID_Dokter_BPJS
                            FROM MasterdataSQL.DBO.JadwalPraktek a
                            inner join MasterdataSQL.dbo.Doctors b
                            on a.IDDokter = b.ID 
                            WHERE a.ID=:dataid");
        $this->db->bind('dataid', $dataid);
        $dtdok =  $this->db->single();
        $codeDokterBPJS = intval($dtdok['ID_Dokter_BPJS']);


        if ($codeUnitBPJS == null ) {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Kode Unit Poli BPJS null, cek Data Master !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($codeUnitSubBPJS == null) {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Kode Sub Unit Poli BPJS null, cek Data Master !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($codeDokterBPJS == null) {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Kode Dokter Poli BPJS null, cek Data Master !',
            );
            echo json_encode($callback);
            exit;
        }

        $hariJadwal = $data['hari'];
        // CARI DULU NO BOOKING, APAKAH DARI MOBILE JKN 
        if($hariJadwal == "Senin"){
            $kodehari = "1";
            $this->db->query("SELECT *
	                    FROM MasterdataSQL.DBO.JadwalPraktek 
                        WHERE ID=:dataid and Senin='1' ");
            $this->db->bind('dataid', $dataid);
            $dthari =  $this->db->single();
            $jadwalAwal = $dthari['Senin_Awal'];
            $jadwalAkhir = $dthari['Senin_Akhir'];
        }  else if ($hariJadwal == "Selasa") {
            $kodehari = "2";
            $this->db->query("SELECT *
	                    FROM MasterdataSQL.DBO.JadwalPraktek 
                        WHERE ID=:dataid and Selasa='1' ");
            $this->db->bind('dataid', $dataid);
            $dthari =  $this->db->single();
            $jadwalAwal = $dthari['Selasa_Awal'];
            $jadwalAkhir = $dthari['Selasa_Akhir'];
        } else if ($hariJadwal == "Rabu") {
            $kodehari = "3";
            $this->db->query("SELECT *
	                    FROM MasterdataSQL.DBO.JadwalPraktek 
                        WHERE ID=:dataid  and Rabu='1'");
            $this->db->bind('dataid', $dataid);
            $dthari =  $this->db->single();
            $jadwalAwal = $dthari['Rabu_Awal'];
            $jadwalAkhir = $dthari['Rabu_Akhir'];
        } else if ($hariJadwal == "Kamis") {
            $kodehari = "4";
            $this->db->query("SELECT *
	                    FROM MasterdataSQL.DBO.JadwalPraktek 
                        WHERE ID=:dataid  and Kamis='1'");
            $this->db->bind('dataid', $dataid);
            $dthari =  $this->db->single();
            $jadwalAwal = $dthari['Kamis_Awal'];
            $jadwalAkhir = $dthari['Kamis_akhir'];
        } else if ($hariJadwal == "Jumat") {
            $kodehari = "5";
            $this->db->query("SELECT *
	                    FROM MasterdataSQL.DBO.JadwalPraktek 
                        WHERE ID=:dataid  and Jumat='1'");
            $this->db->bind('dataid', $dataid);
            $dthari =  $this->db->single();
            $jadwalAwal = $dthari['Jumat_Awal'];
            $jadwalAkhir = $dthari['Jumat_Akhir'];
        } else if ($hariJadwal == "Sabtu") {
            $kodehari = "6";
            $this->db->query("SELECT *
	                    FROM MasterdataSQL.DBO.JadwalPraktek 
                        WHERE ID=:dataid and Sabtu='1' ");
            $this->db->bind('dataid', $dataid);
            $dthari =  $this->db->single();
            $jadwalAwal = $dthari['Sabtu_Awal'];
            $jadwalAkhir = $dthari['Sabtu_Akhir'];
        } else if ($hariJadwal == "Minggu") {
            $kodehari = "7";
            $this->db->query("SELECT *
	                    FROM MasterdataSQL.DBO.JadwalPraktek 
                        WHERE ID=:dataid  and Minggu='1'");
            $this->db->bind('dataid', $dataid);
            $dthari =  $this->db->single();
            $jadwalAwal = $dthari['Minggu_Awal'];
            $jadwalAkhir = $dthari['Minggu_Akhir'];
        }
        $datajadwal = array();  
        $datajadwal['hari'] = $kodehari;
        $datajadwal['buka'] = $jadwalAwal;
        $datajadwal['tutup'] =  $jadwalAkhir;
        $datas[] = $datajadwal ; 

        $jadwal = json_encode($datas);
        $datapost = '{
                        "kodepoli": "' . $codeUnitBPJS . '",
                        "kodesubspesialis": "' . $codeUnitSubBPJS . '",
                        "kodedokter": "' . $codeDokterBPJS . '",
                        "jadwal":  "' . $jadwal . '"
                    }';  
        $curl = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS_Antrian($tStamp);

        $curl = curl_init();
        $taskid = "2";
        curl_setopt_array($curl, array(
            CURLOPT_URL =>  URL_BPJS_ANTRIAN . 'jadwaldokter/updatejadwaldokter',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                        "kodepoli": "' . $codeUnitBPJS . '",
                        "kodesubspesialis": "' . $codeUnitSubBPJS . '",
                        "kodedokter": "' . $codeDokterBPJS . '",
                        "jadwal":  ' . $jadwal . '
                    }',
            CURLOPT_HTTPHEADER => $headerbpjs,
        ));
        $output = curl_exec($curl);
        // tutup curl 
        curl_close($curl);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metadata']['code'] == "200") { 
            $callback = array(
                'status' => 'success',
                'pesan' => 'Data Jadwal ID '. $dataid .'Berhasil dikirim Ke HFIS BPJS Kesehatan !',
            );
            return $callback;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metadata']['message'],
                'data' => $datapost,
                'header' =>  $headerbpjs 
            );
            return $callback;
        }
    }

    function Dashboardper_Tanggal($data)
    {
        $dateNow = Utils::datenowcreateNotFull();
        $MTglKunjunganBPJS = $data['MTglKunjunganBPJS'];
        $waktu = $data['waktu'];
        if ($MTglKunjunganBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Masukan Tanggal Kunjungan !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($waktu == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Masukan Waktu !',
            );
            echo json_encode($callback);
            exit;
        }
        // persiapkan curl
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS_Antrian($tStamp);
        //var_dump($headerbpjs,'header');
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS_ANTRIAN . "dashboard/waktutunggu/tanggal/$MTglKunjunganBPJS/waktu/$waktu");
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
        // ssl verifi
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);

        // tutup curl 
        curl_close($ch);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        //var_dump($JsonData);
        if ($JsonData['metadata']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            // $ResultEncriptLzString = GenerateBpjs::responseBpjsV2_Antrian_Reff($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            //echo json_encode($output);
            foreach ($JsonData['response']['list'] as $key => $jsons) { // This will search in the 2 jsons

                $pasing['kdppk'] = $jsons['kdppk'];
                $pasing['waktu_task1'] = $jsons['waktu_task1'];
                $pasing['avg_waktu_task4'] = $jsons['avg_waktu_task4'];
                $pasing['jumlah_antrean'] = $jsons['jumlah_antrean'];
                $pasing['avg_waktu_task3'] = $jsons['avg_waktu_task3'];
                $pasing['namapoli'] = $jsons['namapoli'];
                $pasing['avg_waktu_task6'] = $jsons['avg_waktu_task6'];
                $pasing['avg_waktu_task5'] = $jsons['avg_waktu_task5'];
                $pasing['nmppk'] = $jsons['nmppk'];
                $pasing['avg_waktu_task2'] = $jsons['avg_waktu_task2'];
                $pasing['avg_waktu_task1'] = $jsons['avg_waktu_task1'];
                $pasing['kodepoli'] = $jsons['kodepoli'];
                $pasing['waktu_task5'] = $jsons['waktu_task5'];
                $pasing['waktu_task4'] = $jsons['waktu_task4'];
                $pasing['waktu_task3'] = $jsons['waktu_task3'];
                $pasing['insertdate'] = $jsons['insertdate'];
                $pasing['tanggal'] = $jsons['tanggal'];
                $pasing['waktu_task2'] = $jsons['waktu_task2'];
                $pasing['waktu_task6'] = $jsons['waktu_task6'];
                $datas[] = $pasing;
            } 
            return $datas;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metadata']['message']

            );
            return $callback;
        }
    }

    function Dashboardper_Bulan($data)
    {
        date_default_timezone_set('Asia/Jakarta');
        $dateNow = Utils::datenowcreateNotFull();
        $MTglKunjunganBPJS = $data['MTglKunjunganBPJS'];
        $waktu = $data['waktu'];
        if ($MTglKunjunganBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Masukan Tanggal Kunjungan !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($waktu == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Masukan Waktu !',
            );
            echo json_encode($callback);
            exit;
        }
        $getbulan = date ('m',strtotime($MTglKunjunganBPJS));
        $gettahun = date ('Y',strtotime($MTglKunjunganBPJS));
        // persiapkan curl
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS_Antrian($tStamp);
        //var_dump($headerbpjs,'header');
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS_ANTRIAN . "dashboard/waktutunggu/bulan/$getbulan/tahun/$gettahun/waktu/$waktu");
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
        // ssl verifi
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);

        // tutup curl 
        curl_close($ch);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        //var_dump($JsonData);
        if ($JsonData['metadata']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            // $ResultEncriptLzString = GenerateBpjs::responseBpjsV2_Antrian_Reff($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            //echo json_encode($output);
            foreach ($JsonData['response']['list'] as $key => $jsons) { // This will search in the 2 jsons

                $pasing['kdppk'] = $jsons['kdppk'];
                $pasing['waktu_task1'] = $jsons['waktu_task1'];
                $pasing['avg_waktu_task4'] = $jsons['avg_waktu_task4'];
                $pasing['jumlah_antrean'] = $jsons['jumlah_antrean'];
                $pasing['avg_waktu_task3'] = $jsons['avg_waktu_task3'];
                $pasing['namapoli'] = $jsons['namapoli'];
                $pasing['avg_waktu_task6'] = $jsons['avg_waktu_task6'];
                $pasing['avg_waktu_task5'] = $jsons['avg_waktu_task5'];
                $pasing['nmppk'] = $jsons['nmppk'];
                $pasing['avg_waktu_task2'] = $jsons['avg_waktu_task2'];
                $pasing['avg_waktu_task1'] = $jsons['avg_waktu_task1'];
                $pasing['kodepoli'] = $jsons['kodepoli'];
                $pasing['waktu_task5'] = $jsons['waktu_task5'];
                $pasing['waktu_task4'] = $jsons['waktu_task4'];
                $pasing['waktu_task3'] = $jsons['waktu_task3'];
                $pasing['insertdate'] = $jsons['insertdate'];
                $pasing['tanggal'] = $jsons['tanggal'];
                $pasing['waktu_task2'] = $jsons['waktu_task2'];
                $pasing['waktu_task6'] = $jsons['waktu_task6'];
                $datas[] = $pasing;
            } 
            return $datas;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metadata']['message']

            );
            return $callback;
        }
    }
    function get_antreanPertanggal($data)
    {
        $dateNow = Utils::datenowcreateNotFull();
        $MTglKunjunganBPJS = $data['MTglKunjunganBPJS']; 
        if ($MTglKunjunganBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Masukan Tanggal Kunjungan !',
            );
            echo json_encode($callback);
            exit;
        }
      
        // persiapkan curl
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS_Antrian($tStamp);
        //var_dump($headerbpjs,'header');
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS_ANTRIAN . "antrean/pendaftaran/tanggal/$MTglKunjunganBPJS");
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
        // ssl verifi
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);

        // tutup curl 
        curl_close($ch);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        //var_dump($JsonData);
        if ($JsonData['metadata']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            // $ResultEncriptLzString = GenerateBpjs::responseBpjsV2_Antrian_Reff($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            //echo json_encode($output);
            foreach ($JsonData['response']['list'] as $key => $jsons) { // This will search in the 2 jsons

                $pasing['kodebooking'] = $jsons['kodebooking'];
                $pasing['tanggal'] = $jsons['tanggal'];
                $pasing['kodepoli'] = $jsons['kodepoli'];
                $pasing['kodedokter'] = $jsons['kodedokter'];
                $pasing['jampraktek'] = $jsons['jampraktek'];
                $pasing['nik'] = $jsons['nik'];
                $pasing['nokapst'] = $jsons['nokapst'];
                $pasing['nohp'] = $jsons['nohp'];
                $pasing['norekammedis'] = $jsons['norekammedis'];
                $pasing['jeniskunjungan'] = $jsons['jeniskunjungan'];
                $pasing['nomorreferensi'] = $jsons['nomorreferensi'];
                $pasing['sumberdata'] = $jsons['sumberdata'];
                $pasing['noantrean'] = $jsons['noantrean'];
                $pasing['status'] = $jsons['status']; 
                $datas[] = $pasing;
            } 
            return $datas;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metadata']['message']

            );
            return $callback;
        }
    }
    function get_antreanBulanBelumdilayani($data)
    {
        date_default_timezone_set('Asia/Jakarta');
        $dateNow = Utils::datenowcreateNotFull();
        $MTglKunjunganBPJS = $data['MTglKunjunganBPJS'];
        $waktu = $data['waktu'];
        if ($MTglKunjunganBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Masukan Tanggal Kunjungan !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($waktu == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Masukan Waktu !',
            );
            echo json_encode($callback);
            exit;
        }
        $getbulan = date ('m',strtotime($MTglKunjunganBPJS));
        $gettahun = date ('Y',strtotime($MTglKunjunganBPJS));
        // persiapkan curl
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS_Antrian($tStamp);
        //var_dump($headerbpjs,'header');
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS_ANTRIAN . "antrean/pendaftaran/aktif");
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
        // ssl verifi
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);

        // tutup curl 
        curl_close($ch);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
       
         
        if ($JsonData['metadata']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2_Antrian($EncodeData, GenerateBpjs::keyString(Utils::setConsid_Antrian(), Utils::setSeckey_Antrian(), $tStamp));
             
            foreach ($ResultEncriptLzString['1'] as $key => $jsons) { // This will search in the 2 jsons 

                $pasing['kodebooking'] = $jsons['kodebooking'];
                $pasing['tanggal'] = $jsons['tanggal'];
                $pasing['kodepoli'] = $jsons['kodepoli'];
                $pasing['kodedokter'] = $jsons['kodedokter'];
                $pasing['jampraktek'] = $jsons['jampraktek'];
                $pasing['nik'] = $jsons['nik'];
                $pasing['nokapst'] = $jsons['nokapst'];
                $pasing['nohp'] = $jsons['nohp'];
                $pasing['norekammedis'] = $jsons['norekammedis'];
                $pasing['jeniskunjungan'] = $jsons['jeniskunjungan'];
                $pasing['nik'] = $jsons['nik'];
                $pasing['noantrean'] = $jsons['noantrean'];
                $pasing['sumberdata'] = $jsons['sumberdata'];
                $pasing['status'] = $jsons['status'];
                $pasing['nomorreferensi'] = $jsons['nomorreferensi'];
                // $pasing['kdsubspesialis'] = $jsons['kdsubspesialis'];
                // $pasing['nmpoli'] = $jsons['nmpoli'];
                // $pasing['nmsubspesialis'] = $jsons['nmsubspesialis'];
                // $this->db->query("INSERT INTO perawatanSQL.dbo.BPJS_REF_POLI
                //             (kdpoli,kdsubspesialis,nmpoli,nmsubspesialis)
                //             VALUES 
                //             (:kdpoli,:kdsubspesialis,:nmpoli,:nmsubspesialis)");
                // $this->db->bind('kdpoli', $jsons['kdpoli']);
                // $this->db->bind('kdsubspesialis', $jsons['kdsubspesialis']);
                // $this->db->bind('nmpoli', $jsons['nmpoli']);
                // $this->db->bind('nmsubspesialis', $jsons['nmsubspesialis']); 
                // $this->db->execute();
                $datas[] = $pasing;
            }
            return $datas;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metadata']['message']

            );
            return $callback;
        }
    }
}

