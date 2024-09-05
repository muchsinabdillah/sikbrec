<?php
class I_Masterdata_Kelompok_Model
{
    private $db;
    use ApiRsyarsi; 
    public function __construct()
    {
        $this->db = new Database;
    }
    public function addGroupBarang($data)
    {
        try {
            $NamaGroupBarang = $data['NamaGroupBarang'];
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);
            
            // 2. add Data Group Barang
            $postGroupData = '{ 
                "GroupName" : "'. $NamaGroupBarang .'"
            }';
            $urlAddKelompok = "masterdata/apotek/addGroup/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method, $postGroupData, $urlAddKelompok);
            if (isset($addSatuan['status']) == 1) {
                $callback = array(
                    'status' => 'success',
                    'message' => $addSatuan['message'],
                );
            } else {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => "Terjadi Kesahalahan. Silahkan Coba Kembali / Hubungi IT.",

                );
            }
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    } 
    public function showGroupBarangAll(){
        try {
            
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "GET";
            $urlAddKelompok = "masterdata/apotek/getGroupAll/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, [], $urlAddKelompok); 
      
            if($addSatuan['status']){
                return $addSatuan['data'];
            }else{
                return [];
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getGroupbarangbyId($data){
        try {

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "GET";
            $urlAddKelompok = "masterdata/apotek/getGroupbyId/".$data['id'];
            $getGroupbyId = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, [], $urlAddKelompok);
            if ($getGroupbyId['status'] == 1
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
    public function editGroupBarang($data)
    {
        try {
            $IdAuto = $data['IdAuto'];
            $NamaGroupBarang = $data['NamaGroupBarang'];
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang
            $postGroupData = '{ 
                "GroupCode" : "' . $IdAuto . '",
                "GroupName" : "' . $NamaGroupBarang . '"
            }';
            $urlAddKelompok = "masterdata/apotek/editGroup/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method, $postGroupData, $urlAddKelompok);
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
    public function showkelompokBarangAll()
    {
        try {
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "GET";
            $urlAddKelompok = "masterdata/apotek/getKelompokAll/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, [], $urlAddKelompok);
            return $addSatuan['data'];
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function GetKelompokbyID($data)
    {
        try {
            $al = $data['id'];
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroupx = "GET";
            $urlAddKelompoxk = "masterdata/apotek/getKelompokbyId/" . $al;
            $getGroupbyIdx = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroupx, [], $urlAddKelompoxk);
            if (
                $getGroupbyIdx['status'] == 1
            ) {
                $callback = array(
                    'status' => 'success',
                    'message' => $getGroupbyIdx['message'],
                    'data' => $getGroupbyIdx['data']
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
    public function addKelompok($data)
    {
        try {
            $Nama = $data['Nama'];
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang
            $postGroupData = '{ 
                "KelompokCode" : "' . $Nama . '",
                "KelompokName" : "' . $Nama . '"
            }';
            $urlAddKelompok = "masterdata/apotek/addKelompok/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method, $postGroupData, $urlAddKelompok);
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
    public function editKelompok($data)
    {
        try {
            $IdAuto = $data['ID'];
            $Nama = $data['Nama'];
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang
            $postGroupData = '{ 
                "KelompokCode" : "' . $IdAuto . '",
                "KelompokName" : "' . $Nama . '"
            }';
            $urlAddKelompok = "masterdata/apotek/editKelompok/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method, $postGroupData, $urlAddKelompok);
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
