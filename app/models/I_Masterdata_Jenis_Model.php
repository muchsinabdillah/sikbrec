<?php
class I_Masterdata_Jenis_Model
{
    private $db;
    use ApiRsyarsi;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function addJenis($data)
    {
        try {
            $NamaJenis = $data['NamaJenis'];
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang
            $postGroupData = '{ 
                "NamaJenis" : "' . $NamaJenis . '"
            }';
            $urlAddKelompok = "masterdata/apotek/addJenis/";
            $addJenis = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method, $postGroupData, $urlAddKelompok);
            if (isset($addJenis['status']) == 1) {
                $callback = array(
                    'status' => 'success',
                    'message' => $addJenis['message'],
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
    public function showJenisAll()
    {
        try {

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "GET";
            $urlAddKelompok = "masterdata/apotek/getJenisAll";
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
    public function getJenisbyId($data)
    {
        try {

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "GET";
            $urlAddKelompok = "masterdata/apotek/getJenisbyId/" . $data['id'];
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
    public function editJenis($data)
    {
        try {
            $ID = $data['ID'];
            $Nama_Jenis = $data['NamaJenis'];
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang
            $postGroupData = '{ 
                "ID" : "' . $ID . '",
                "NamaJenis" : "' . $Nama_Jenis . '"
            }';
            $urlAddKelompok = "masterdata/apotek/editJenis/";
            $addJenis = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method, $postGroupData, $urlAddKelompok);
            if (isset($addJenis['status']) == 1) {
                $callback = array(
                    'status' => 'success',
                    'message' => $addJenis['message'],
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
