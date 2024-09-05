<?php
class I_Masterdata_Satuan_Model
{
    use ApiRsyarsi; 
    private $db; 
    public function __construct()
    {
        $this->db = new Database;
    }
    public function addSatuan($data)
    {
        try {
            $Isi = $data['Isi'];
            $NamaSatuan = $data['NamaSatuan'];
            
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);
            
            // 2. add Data Golongan
            $postSatuanData = '{ 
                "isi" : "'. $Isi .'",
                "nama_satuan" : "'. $NamaSatuan .'"
            }';
            $urlAddSatuan = "masterdata/apotek/addSatuan/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method, $postSatuanData, $urlAddSatuan);
            if (isset($addSatuan['status']) == 1) {
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
    public function showSatuanAll(){
        try {
            
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);
        
            // 2. add Data Group Barang 
            $method_getsatuan = "GET";
            $urlAddSatuan = "masterdata/apotek/getSatuanAll/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getsatuan, [], $urlAddSatuan); 
            if($addSatuan['status']){
                return $addSatuan['data'];
            }else{
                return [];
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getSatuanbyId($data){
        try {

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getsatuan = "GET";
            $urlAddSatuan = "masterdata/apotek/getSatuanbyId/".$data['id'];
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
    public function editSatuan($data)
    {
        try {
            $IdAuto = $data['IdAuto'];
            $Isi = $data['Isi'];
            $NamaSatuan = $data['NamaSatuan'];
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang
            $postSatuanData = '{ 
                "ID" : "' . $IdAuto . '",
                "isi" : "' . $Isi . '",
                "nama_satuan" : "' . $NamaSatuan . '"

            }';
            $urlAddSatuan = "masterdata/apotek/editSatuan/";
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
