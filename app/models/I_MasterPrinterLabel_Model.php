<?php
class I_MasterPrinterLabel_Model
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
            $IP_Komputer = $data['IP_Komputer'];
            $Jenis = $data['Jenis'];
            $IPPrinterSharing = $data['IPPrinterSharing'];
            $NamaPrinterSharing = $data['NamaPrinterSharing'];
            
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);
            
            // 2. add Data Golongan
            $postSatuanData = '{ 
                "ID" : "'. $ID .'",
                "IP_Komputer" : "'. $IP_Komputer .'",
                "Jenis" : "'. $Jenis .'",
                "IPPrinterSharing" : "'. $IPPrinterSharing .'",
                "NamaPrinterSharing" : "'. $NamaPrinterSharing .'"
            }';
            $urlAddSatuan = "masterdata/apotek/addPrinterLabel/";
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
    public function showall(){
        try {
            
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getsatuan = "GET";
            $urlAddSatuan = "masterdata/apotek/getPrinterLabelAll/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getsatuan, [], $urlAddSatuan); 
            return $addSatuan['data'];
        
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getPrinterLabelbyId($data){
        try {

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getsatuan = "GET";
            $urlAddSatuan = "masterdata/apotek/getPrinterLabelbyId/".$data['id'];
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
            $IP_Komputer = $data['IP_Komputer'];
            $Jenis = $data['Jenis'];
            $IPPrinterSharing = $data['IPPrinterSharing'];
            $NamaPrinterSharing = $data['NamaPrinterSharing'];
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang
            $postSatuanData = '{ 
                "ID" : "'. $ID .'",
                "IP_Komputer" : "'. $IP_Komputer .'",
                "Jenis" : "'. $Jenis .'",
                "IPPrinterSharing" : "'. $IPPrinterSharing .'",
                "NamaPrinterSharing" : "'. $NamaPrinterSharing .'"

            }';
            $urlAddSatuan = "masterdata/apotek/editPrinterLabel/";
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
