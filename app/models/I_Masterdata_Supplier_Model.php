 

<?php
class I_MasterData_Supplier_Model
{
    private $db;
    use ApiRsyarsi;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function addSupplier($data)
    {
        try {
            $IdAuto = $data['IdAuto'];
            $Nama = $data['Nama'];
            $NamaCPAwal = $data['NamaCPAwal'];
            $NamaCPAkhir = $data['NamaCPAkhir'];
            $Email = $data['Email'];
            $IdPabrik = $data['IdPabrik'];
            $TlpnKantor = $data['TlpnKantor'];
            $NoHP = $data['NoHP'];
            $FaxTlp = $data['FaxTlp'];
            $Kota = $data['Kota'];
            $Status = $data['Status'];
            $Provinsi = $data['Provinsi'];
            $Alamat = $data['Alamat'];
            $KodePos = $data['KodePos']; 
            $LeadTime = $data['LeadTime']; 
            $JatuhTempo = $data['JatuhTempo']; 
            $NoRekening = $data['NoRekening']; 
            $NamaBank = $data['NamaBank']; 
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang
            $postGroupData = '{ 
                "IdPabrikan" : "' . $IdPabrik . '",
                "Company" : "' . $Nama . '",
                "last_name" : "' . $NamaCPAkhir . '",
                "first_name" : "' . $NamaCPAwal . '",
                "Email_Address" : "' . $Email . '",
                "home_phone" : "' . $TlpnKantor . '",
                "mobile_phone" : "' . $NoHP . '",
                "fax_number" : "' . $FaxTlp . '",
                "Address" : "' . $Alamat . '",
                "City" : "' . $Kota . '",
                "Province" : "' . $Provinsi . '",
                "ZIP" : "' . $KodePos . '",
                "Country" : "",
                "Notes" : "",
                "lock" : "' . $Status . '",
                "suplier" : "1",
                "LeadTime" : "'.$LeadTime.'",
                "NoRekening" : "'.$NoRekening.'",
                "NamaBank" : "'.$NamaBank.'",
                "JatuhTempo" : "'.$JatuhTempo.'"
            }';
            $urlAddKelompok = "masterdata/apotek/addSupplier/";
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
    public function editSupplier($data)
    {
        try {
            $IdAuto = $data['IdAuto'];
            $Nama = $data['Nama'];
            $NamaCPAwal = $data['NamaCPAwal'];
            $NamaCPAkhir = $data['NamaCPAkhir'];
            $Email = $data['Email'];
            $IdPabrik = $data['IdPabrik'];
            $TlpnKantor = $data['TlpnKantor'];
            $NoHP = $data['NoHP'];
            $FaxTlp = $data['FaxTlp'];
            $Kota = $data['Kota'];
            $Status = $data['Status'];
            $Provinsi = $data['Provinsi'];
            $Alamat = $data['Alamat'];
            $KodePos = $data['KodePos']; 
            $LeadTime = $data['LeadTime']; 
            $JatuhTempo = $data['JatuhTempo']; 
            $NoRekening = $data['NoRekening']; 
            $NamaBank = $data['NamaBank']; 
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang
            $postGroupData = '{ 
                "ID" : "' . $IdAuto . '",
                "IdPabrikan" : "' . $IdPabrik . '",
                "Company" : "' . $Nama . '",
                "last_name" : "' . $NamaCPAkhir . '",
                "first_name" : "' . $NamaCPAwal . '",
                "Email_Address" : "' . $Email . '",
                "home_phone" : "' . $TlpnKantor . '",
                "mobile_phone" : "' . $NoHP . '",
                "fax_number" : "' . $FaxTlp . '",
                "Address" : "' . $Alamat . '",
                "City" : "' . $Kota . '",
                "Province" : "' . $Provinsi . '",
                "ZIP" : "' . $KodePos . '",
                "Country" : "",
                "Notes" : "",
                "lock" : "' . $Status . '",
                "suplier" : "1",
                "LeadTime" : "'.$LeadTime.'",
                "NoRekening" : "'.$NoRekening.'",
                "NamaBank" : "'.$NamaBank.'",
                "JatuhTempo" : "'.$JatuhTempo.'"
            }';
            $urlAddKelompok = "masterdata/apotek/editSupplier/";
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
    public function getSupplierbyId($data)
    {
        try {

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "GET";
            $urlAddKelompok = "masterdata/apotek/getSupplierbyId/" . $data['id'];
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
    public function showSupplierAll()
    {
        try {

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "GET";
            $urlAddKelompok = "masterdata/apotek/getSupplierAll/";
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
}
