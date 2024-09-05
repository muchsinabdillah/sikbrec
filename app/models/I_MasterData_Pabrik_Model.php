<?php
class I_Masterdata_Pabrik_Model
{
    private $db;
    use ApiRsyarsi;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function addPabrik($data)
    {
        try {
            $NamaPabrik = $data['Namapabrik'];
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang
            $postGroupData = '{ 
                "Nama" : "' . $NamaPabrik . '"
            }';
            $urlAddKelompok = "masterdata/apotek/addPabrik/";
            $addPabrik = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method, $postGroupData, $urlAddKelompok);
            if (isset($addPabrik['status']) == 1) {
                $callback = array(
                    'status' => 'success',
                    'message' => $addPabrik['message'],
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
    public function showPabrikAll()
    {
        try {

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "GET";
            $urlAddKelompok = "masterdata/apotek/getPabrikAll";
            $addPabrik = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, [], $urlAddKelompok);
            if($addPabrik['status']){
                return $addPabrik['data'];
            }else{
                return [];
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getPabrikbyId($data)
    {
        try {

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "GET";
            $urlAddKelompok = "masterdata/apotek/getPabrikbyId/" . $data['id'];
            // var_dump($data['id']);
            $getGroupbyId = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, [], $urlAddKelompok);
            // var_dump($getGroupbyId);
            // exit;
            if (
                $getGroupbyId['status'] == 1
            ) {
                $callback = array(
                    'status' => 'success',
                    'message' => $getGroupbyId['message'],
                    'data' => $getGroupbyId['data']
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
    public function editPabrik($data)
    {
        try {
            $ID = $data['ID'];
            $NamaPabrik = $data['Namapabrik'];
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang
            $postGroupData = '{ 
                "ID" : "' . $ID . '",
                "Nama" : "' . $NamaPabrik . '"
            }';
            $urlAddKelompok = "masterdata/apotek/editPabrik/";
            $addPabrik = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method, $postGroupData, $urlAddKelompok);
            if (isset($addPabrik['status']) == 1) {
                $callback = array(
                    'status' => 'success',
                    'message' => $addPabrik['message'],
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
