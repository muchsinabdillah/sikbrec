<?php
class I_MasterIPUnitFarmasi_Model
{
    use ApiRsyarsi; 
    private $db; 
    public function __construct()
    {
        $this->db = new Database;
    }
    public function addData($data)
    {
        try {
            $ID = $data['IdAuto'];
            $IPAddress = $data['IPAddress'];
            $UnitCode = $data['UnitCode'];
            
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);
            
            // 2. add Data Golongan
            $postSatuanData = '{ 
                "ID" : "'. $ID .'",
                "IPAddress" : "'. $IPAddress .'",
                "UnitCode" : "'. $UnitCode .'"
            }';
            $urlAddSatuan = "masterdata/apotek/addIPUnitFarmasi/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method, $postSatuanData, $urlAddSatuan);
            //var_dump($addSatuan['status']);
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
    public function showAll(){
        try {
            
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getsatuan = "GET";
            $urlAddSatuan = "masterdata/apotek/getIPUnitFarmasiAll/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getsatuan, [], $urlAddSatuan); 
            return $addSatuan['data'];
        
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getData($data){
        try {

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getsatuan = "GET";
            $urlAddSatuan = "masterdata/apotek/getIPUnitFarmasibyId/".$data['id'];
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
}
