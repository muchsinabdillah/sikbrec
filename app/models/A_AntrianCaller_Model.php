<?php
class A_AntrianCaller_Model
{
    use ApiRsyarsi; 
    private $db; 
    public function __construct()
    {
        $this->db = new Database;
    }
    public function getIpCounter(){
        try {
           // return Utils::get_client_ip_2();

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang   "UserCreate" : "'. $userid .'" 
            $postSatuanData = '{  
                 "IpAddress": "172.16.20.4" 
            }';
            $method_getsatuan = "POST";
            $urlAddSatuan = "Antrian/MasterData/AntrianCounter/ViewbyIpAddress";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getsatuan, $postSatuanData, $urlAddSatuan); 
            return $addSatuan;
        
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getListAntrian($data){
        try {
           // return Utils::get_client_ip_2();

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang   "UserCreate" : "'. $userid .'" 
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $postSatuanData = '{  
                 "FloorId": "'. $data['Lantai'] .'" ,
                 "DateCreated": "'. $data['Tanggal'] .'"  
            }';
            $method_getsatuan = "POST";
            $urlAddSatuan = "Antrian/Admission/ViewbyFloorTrsAntrianAdmission";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getsatuan, $postSatuanData, $urlAddSatuan); 
            return $addSatuan['data'];
        
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function gocallantrian($data){
        try {
           return Utils::get_client_ip();

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;

            // 2. add Data Group Barang   "UserCreate" : "'. $userid .'" 
            $postSatuanData = '{
                "IDTrsAntrian": "'. $data['idantrian'] .'" ,
                "Username" :  "'. $userid .'" ,
                "ConterID" : "'. $data['CounterId'] .'" ,
                "StatusAntrian" : "CALLED"
            }';
            $method_getsatuan = "POST";
            $urlAddSatuan = "Antrian/Admission/PanggilAntrian";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getsatuan, $postSatuanData, $urlAddSatuan); 
         
            if($addSatuan['status']){
                $methodAntrian = "POST";
                $URLAntrian = "genToken";
                $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $methodAntrian, $URLAntrian);
                $session = SessionManager::getCurrentSession();
                $userid = $session->username;
    
                // 2. add Data Group Barang   "UserCreate" : "'. $userid .'" 
                $postSatuanDataAntrian = '{
                        "IDTrsAntrian":  "'. $data['idantrian'] .'" ,
                        "Username":  "'. $userid .'" ,
                        "ConterID":  "'. $data['CounterId'] .'" ,
                        "StatusAntrian": "CALLED",
                        "NoAntrean": "'. $data['NoAntrian'] .'" ,
                        "CounterName":  "'. $data['CounterName'] .'" ,
                        "Ip":  "'. $data['IpAddress'] .'" ,
                        "FloorId":  "'. $data['Lantai'] .'" 
                    }';
                $method_getsatuanAntrian = "POST";
                $urlAddSatuanAntrian = "api-admission-called-outside";
                $addSatuanx = $this->curl_request_Antrian_rsyarsi(GenerateTokenRS::headers_api_token_antrian_RSyarsi(), $method_getsatuanAntrian, $postSatuanDataAntrian, $urlAddSatuanAntrian); 
                return $addSatuanx;
            }
          
            

        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function goholdAntrian($data){
        try {
           // return Utils::get_client_ip_2();

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            
            // 2. add Data Group Barang   "UserCreate" : "'. $userid .'" 
            $postSatuanData = '{
                "IDTrsAntrian": "'. $data['idantrian'] .'" ,
                "Username" :  "'. $userid .'" ,
                "ConterID" : "'. $data['CounterId'] .'" ,
                "StatusAntrian" : "HOLD"
            }';
            $method_getsatuan = "POST";
            $urlAddSatuan = "Antrian/Admission/HoldAntrian";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getsatuan, $postSatuanData, $urlAddSatuan); 
            return $addSatuan;
        
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function goproccessAntrian($data){
        try {
           // return Utils::get_client_ip_2();

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            
            // 2. add Data Group Barang   "UserCreate" : "'. $userid .'" 
            $postSatuanData = '{
                "IDTrsAntrian": "'. $data['idantrian'] .'" ,
                "Username" :  "'. $userid .'" ,
                "ConterID" : "'. $data['CounterId'] .'" ,
                "StatusAntrian" : "PROCCESSED"
            }';
            $method_getsatuan = "POST";
            $urlAddSatuan = "Antrian/Admission/ProccesedAntrian";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getsatuan, $postSatuanData, $urlAddSatuan); 
            return $addSatuan;
        
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function goFinishAntrian($data){
        try {
           // return Utils::get_client_ip_2();

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            
            // 2. add Data Group Barang   "UserCreate" : "'. $userid .'" 
            $postSatuanData = '{
                "IDTrsAntrian": "'. $data['idantrian'] .'" ,
                "Username" :  "'. $userid .'" ,
                "ConterID" : "'. $data['CounterId'] .'" ,
                "StatusAntrian" : "CLOSED"
            }';
            $method_getsatuan = "POST";
            $urlAddSatuan = "Antrian/Admission/ClosedAntrian";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getsatuan, $postSatuanData, $urlAddSatuan); 
            return $addSatuan;
        
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}