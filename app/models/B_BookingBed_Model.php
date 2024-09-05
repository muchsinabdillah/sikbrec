<?php
class B_BookingBed_Model
{
    use ApiRsyarsi; 
    private $db; 
    public function __construct()
    {
        $this->db = new Database;
    }
    public function create($data)
    {
        try {
            if (!isset($data['patientsex'])){
                $patientsex = '';
            }
            $medicalrecordnumber = $data['medicalrecordnumber'];
            $transactiondate = $data['transactiondate'];
            $patientname = $data['patientname'];
            $bookingbeddate = $data['bookingbeddate'];
            $patientaddress = $data['patientaddress'];
            $classname = $data['classname'];
            $classid = $data['classid'];
            $patientsex = $data['patientsex'];
            $roomname = $data['roomname'];
            $roomid = $data['roomid'];
            $patientbirthplace = $data['patientbirthplace'];
            $patientbirthdate = $data['patientbirthdate'];
            $bedname = $data['bedname'];
            $bedid = $data['bedid'];
            $notes = $data['notes'];
            $bookingstatus = $data['bookingstatus'];
            $TransasctionDate = $data['TransasctionDate'];
            $jenisbooking = $data['jenisbooking'];
            $jenispasien = $data['jenispasien'];

            
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $operator =  $session->IDEmployee;
            
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);
            
            // 2. add Data Golongan
            $postSatuanData = '{ 
                "transactiondate" : "'.$TransasctionDate.'",
                "bookingbeddate" : "'.$bookingbeddate.'",
                "medicalrecordnumber" : "'.$medicalrecordnumber.'",
                "patientname" : "'.$patientname.'",
                "patientaddress" : "'.$patientaddress.'",
                "patientsex" : "'.$patientsex.'",
                "patientbirthplace" : "'.$patientbirthplace.'",
                "patientbirthdate" : "'.$patientbirthdate.'",
                "classid" : "'.$classid.'",
                "classname" : "'.$classname.'",
                "roomid" : "'.$roomid.'",
                "roomname" : "'.$roomname.'",
                "bedid" : "'.$bedid.'",
                "bedname" : "'.$bedname.'",
                "notes" : "'.$notes.'",
                "userentri" : "'.$operator.'",
                "jenisbooking" : "'.$jenisbooking.'",
                "jenispasien" : "'.$jenispasien.'"
            }';
            $urlAddSatuan = "BookingBed/transaction/create/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method, $postSatuanData, $urlAddSatuan);
           // var_dump($addSatuan['errors']);
            if (!empty($addSatuan['errors'])){
                $callback = array(
                    'status' => 'danger',
                    'errorname' => $addSatuan['message'],
                    'errordetails' => $addSatuan['errors'],
                );
                return $callback;
            }
            if ($addSatuan['status'] == true) {
                $callback = array(
                    'status' => 'success',
                    'message' => $addSatuan['message'],
                    'data' => $addSatuan['data'],
                );
            } else {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => $addSatuan['message'],
                    'errordetails' => [],
                );
            }
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    } 

    public function update($data)
    {
        try {
            $transactioncode = $data['transactioncode'];
            $medicalrecordnumber = $data['medicalrecordnumber'];
            $transactiondate = $data['transactiondate'];
            $patientname = $data['patientname'];
            $bookingbeddate = $data['bookingbeddate'];
            $patientaddress = $data['patientaddress'];
            $classname = $data['classname'];
            $classid = $data['classid'];
            $patientsex = $data['patientsex'];
            $roomname = $data['roomname'];
            $roomid = $data['roomid'];
            $patientbirthplace = $data['patientbirthplace'];
            $patientbirthdate = $data['patientbirthdate'];
            $bedname = $data['bedname'];
            $bedid = $data['bedid'];
            $notes = $data['notes'];
            $bookingstatus = $data['bookingstatus'];
            $TransasctionDate = $data['TransasctionDate'];
            $jenisbooking = $data['jenisbooking'];

            
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $operator =  $session->IDEmployee;
            
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);
            
            // 2. add Data Golongan
            $postSatuanData = '{ 
                "transactioncode" : "'.$transactioncode.'",
                "transactiondate" : "'.$TransasctionDate.'",
                "bookingbeddate" : "'.$bookingbeddate.'",
                "medicalrecordnumber" : "'.$medicalrecordnumber.'",
                "patientname" : "'.$patientname.'",
                "patientaddress" : "'.$patientaddress.'",
                "patientsex" : "'.$patientsex.'",
                "patientbirthplace" : "'.$patientbirthplace.'",
                "patientbirthdate" : "'.$patientbirthdate.'",
                "classid" : "'.$classid.'",
                "classname" : "'.$classname.'",
                "roomid" : "'.$roomid.'",
                "roomname" : "'.$roomname.'",
                "bedid" : "'.$bedid.'",
                "bedname" : "'.$bedname.'",
                "notes" : "'.$notes.'",
                "userupdate" : "'.$operator.'",
                "jenisbooking" : "'.$jenisbooking.'"
            }';
            $urlAddSatuan = "BookingBed/transaction/edit/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method, $postSatuanData, $urlAddSatuan);
            //var_dump($addSatuan);
            if (!empty($addSatuan['errors'])){
                $callback = array(
                    'status' => 'warning',
                    'errorname' => $addSatuan['message'],
                );
                return $callback;
            }
            if ($addSatuan['status'] == true) {
                $callback = array(
                    'status' => 'success',
                    'message' => $addSatuan['message'],
                );
            } else {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => $addSatuan['message'],
                );
            }
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    } 

    public function void($data)
    {
        try {
            $transactioncode = $data['transactioncode'];
            $alasanbatal = $data['alasanbatal'];

            
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $operator =  $session->IDEmployee;
            
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);
            
            // 2. add Data Golongan
            $postSatuanData = '{ 
                "transactioncode" : "'.$transactioncode.'",
                "uservoid" : "'.$operator.'",
                "alasanvoid" : "'.$alasanbatal.'"
            }';
            $urlAddSatuan = "BookingBed/transaction/void/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method, $postSatuanData, $urlAddSatuan);
            //var_dump($addSatuan);
            if (!empty($addSatuan['errors'])){
                $callback = array(
                    'status' => 'warning',
                    'errorname' => $addSatuan['message'],
                );
                return $callback;
            }
            if ($addSatuan['status'] == true) {
                $callback = array(
                    'status' => 'success',
                    'message' => $addSatuan['message'],
                );
            } else {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => $addSatuan['message'],
                );
            }
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    } 

    public function listAllActive($data){
        try {
            $StartPeriode = $data['StartPeriode'];
            $EndPeriode = $data['EndPeriode'];
            
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang
            $postSatuanData = '{ 
                "StartPeriode" : "'. $StartPeriode .'",
                "EndPeriode" : "'. $EndPeriode .'"
            }';
            $endpoint = "BookingBed/transaction/listAllActive/";
            $responseApi = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method, $postSatuanData, $endpoint);
            if ($responseApi['status'] == false){
                $responseData = [];
            }else{
                $responseData = $responseApi['data'];
            }
            return $responseData;
        
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function listAllActivebyNoMR($data){
        try {
            $NoMR = $data['NoMR'];
            
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang
            $postSatuanData = '{ 
                "medicalrecordnumber" : "'. $NoMR .'"
            }';
            $endpoint = "BookingBed/transaction/listAllActivebyNoMR/";
            $responseApi = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method, $postSatuanData, $endpoint);
            //var_dump($responseApi);
            if ($responseApi['status'] == false){
                $responseData = [];
            }else{
                $responseData = $responseApi['data'];
            }
            return $responseData;
        
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function listAllArchive($data){
        try {
            $StartPeriode = $data['StartPeriode'];
            $EndPeriode = $data['EndPeriode'];
            
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang
            $postSatuanData = '{ 
                "StartPeriode" : "'. $StartPeriode .'",
                "EndPeriode" : "'. $EndPeriode .'"
            }';
            $endpoint = "BookingBed/transaction/listAllArchive/";
            $responseApi = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method, $postSatuanData, $endpoint);
            if ($responseApi['status'] == false){
                $responseData = [];
            }else{
                $responseData = $responseApi['data'];
            }
            return $responseData;
        
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function viewByNoTrs($data){
        try {
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getsatuan = "GET";
            $urlAddSatuan = "BookingBed/transaction/view/".$data['transactioncode'];
            $getSatuanbyId = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getsatuan, [], $urlAddSatuan);
            
            if ($getSatuanbyId['status'] == 1) {
                $callback = array(
                    'status' => 'success',
                    'message' => $getSatuanbyId['message'],
                    'data' => $getSatuanbyId['data']
                );
            } else {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => $getSatuanbyId['message'],

                );
            }
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function editData($data)
    {
        try {
            $ID = $data['IdAuto'];
            $IPAddress = $data['IPAddress'];
            $UnitCode = $data['UnitCode'];
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang
            $postSatuanData = '{ 
                "ID" : "'. $ID .'",
                "IPAddress" : "'. $IPAddress .'",
                "UnitCode" : "'. $UnitCode .'"

            }';
            $urlAddSatuan = "masterdata/apotek/editIPUnitFarmasi/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method, $postSatuanData, $urlAddSatuan);
             
            if (isset($addSatuan['status']) == 1) {

                $callback = array(
                    'status' => 'success',
                    'message' => $addSatuan['message'],
                );
            } else {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => "Data Kosong",

                );
            }
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    } 

    public function viewByMatch($data){
        try {
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getsatuan = "GET";
            $urlAddSatuan = "BookingBed/transaction/viewByMatch/".$data['transactioncode'];
            $getSatuanbyId = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getsatuan, [], $urlAddSatuan);
            
            if ($getSatuanbyId['status'] == 1) {
                $callback = array(
                    'status' => 'success',
                    'message' => $getSatuanbyId['message'],
                    'data' => $getSatuanbyId['data']
                );
            } else {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => $getSatuanbyId['message'],

                );
            }
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
