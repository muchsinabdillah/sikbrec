 

<?php
class I_MasterData_Formularium_Model
{
    private $db;
    use ApiRsyarsi;
    public function __construct()
    {
        $this->db = new Database;
    }
    
    public function showFormulariumBarangAll()
    {
        try {

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "GET";
            $urlAddKelompok = "masterdata/apotek/getFormulariumAll/";
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

    public function addFormularium($data)
    {
        try {
            $Nama_Formularium = $data['Nama_Formularium'];
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang
            $postGroupData = '{ 
                "Nama_Formularium" : "' . $Nama_Formularium . '"
            }';
            $urlAddKelompok = "masterdata/apotek/addFormularium/";
            $response = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method, $postGroupData, $urlAddKelompok);
            if (isset($response)){
                if ($response['status'] == 1) {
                    $callback = array(
                        'status' => 'success',
                        'message' => $response['message'],
                    );
                } else {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => $response['message'],

                    );
                }
            }else{
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Something wrong!',

                );
            }
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getFormulariumbyId($data)
    {
        try {

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "GET";
            $urlAddKelompok = "masterdata/apotek/getFormulariumbyId/" . $data['id'];
            $getGroupbyId = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, [], $urlAddKelompok);
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
    public function editFormularium($data)
    {
        try {
            $ID = $data['ID'];
            $Nama_Formularium = $data['Nama_Formularium'];
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang
            $postGroupData = '{ 
                "ID" : "' . $ID . '",
                "Nama_Formularium" : "' . $Nama_Formularium . '"
            }';
            $urlAddKelompok = "masterdata/apotek/editFormularium/";
            $response = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method, $postGroupData, $urlAddKelompok);
            if (isset($response)){
                if ($response['status'] == 1) {
                    $callback = array(
                        'status' => 'success',
                        'message' => $response['message'],
                    );
                } else {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => $response['message'],

                    );
                }
            }else{
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Something wrong!',

                );
            }
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
