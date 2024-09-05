<?php
class I_Masterdata_Golongan_Model
{
    //aa
    private $db;
    use ApiRsyarsi; 
    public function __construct()
    {
        $this->db = new Database;
    }
    public function addGolongan($data)
    {
        try {
            $NamaGolongan = $data['NamaGolongan'];
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);
            
            // 2. add Data Golongan
            $postGolonganData = '{ 
                "Golongan" : "'. $NamaGolongan .'"
            }';
            $urlAddGolongan = "masterdata/apotek/addGolongan/";
            $addGolongan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method, $postGolonganData, $urlAddGolongan);
            if (isset($addGolongan['status']) == 1) {
                $callback = array(
                    'status' => 'success',
                    'message' => $addGolongan['message'],
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
    public function showGolonganAll(){
        try {
            
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgolongan = "GET";
            $urlAddGolongan = "masterdata/apotek/getGolonganAll/";
            $addGolongan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgolongan, [], $urlAddGolongan); 
            return $addGolongan['data'];
        
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getGolonganbyId($data){
        try {

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgolongan = "GET";
            $urlAddGolongan = "masterdata/apotek/getGolonganbyId/".$data['id'];
            $getGolonganbyId = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgolongan, [], $urlAddGolongan);
            if ($getGolonganbyId['success'] == 1
            ) {
                $callback = array(
                    'status' => 'success',
                    'message' => $getGolonganbyId['message'],
                    'data' => $getGolonganbyId['data']
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
    public function editGolongan($data)
    {
        try {
            $IdAuto = $data['IdAuto'];
            $NamaGolongan = $data['NamaGolongan'];
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang
            $postGolonganData = '{ 
                "ID" : "' . $IdAuto . '",
                "Golongan" : "' . $NamaGolongan . '"
            }';
            $urlAddGolongan = "masterdata/apotek/editGolongan/";
            $addGolongan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method, $postGolonganData, $urlAddGolongan);
            if (isset($addGolongan['status']) == 1) {
                $callback = array(
                    'status' => 'success',
                    'message' => $addGolongan['message'],
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
