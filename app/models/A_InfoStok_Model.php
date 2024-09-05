<?php
class A_InfoStok_Model
{
    private $db;
    use ApiRsyarsi;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function getDataListInfoStok($data)
    {
        try {

            // $query = "SELECT ProductCode as Kodebrang, NamaBarang, qty, 
            // nilaihpp, qty*nilaihpp as Persediaan, NamaUnit
            // FROM APOREK_3.DBO.v_stok
            // where Layanan=:ID";
            // $this->db->query($query);
            // $this->db->bind('ID', $data['NamaUnit']);
            // $data =  $this->db->resultSet();

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '{  
                "unit" : "' . $data['NamaUnit'] .'" 
            }';
            $urlAddKelompok = "information/inventory/stok/getStokBarangbyUnit";
            $addSatuan = $this->curl_request(
                GenerateTokenRS::headers_api_token($token['access_token']),
                $method_getgroup,
                $postData,
                $urlAddKelompok
            ); 
            if ($addSatuan['status'] == true){
                foreach ($addSatuan['data'] as $key => $jsons) { // This will search in the 2 jsons
                    $pasing['Kode_Barang'] = $jsons['ProductCode'];
                    $pasing['Nama_Barang'] = $jsons['NamaBarang'];
                    $pasing['Qty'] = $jsons['Qty'];
                    $pasing['Satuan'] = $jsons['Satuan'];
                    $pasing['Hpp'] = $jsons['NilaiHpp'];
                    $pasing['Persediaan'] = $jsons['NilaiHpp']*$jsons['Qty'];
                    $pasing['NamaUnit'] = $jsons['NamaUnit'];
                    $datas[] = $pasing;
                }
            }else{
                $pasing['id'] = null;
                $pasing['label'] = ' -- Data Tidak Ditemukan ! -- ';
                $datas[] = $pasing;
            }
            return $datas;



            // $rows = array();
            // $array = array();
            // foreach ($data as $row) {

            //     $pasing['Kode_Barang'] = $row['Kodebrang'];
            //     $pasing['Nama_Barang'] = $row['NamaBarang'];
            //     $pasing['Qty'] = $row['qty'];
            //     $pasing['Hpp'] = $row['nilaihpp'];
            //     $pasing['Persediaan'] = $row['Persediaan'];
            //     $pasing['NamaUnit'] = $row['NamaUnit'];

            //     $rows[] = $pasing;
            // }
            // return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getStokBarangbyUnitNameLike($data)
    {
        try {
            $name = $data['searchTerm'];
            $unit = $data['Unit'];

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '{ 
                "name" : "' . $name . '" ,
                "unit" : "' . $unit .'" 
            }';
            $urlAddKelompok = "information/inventory/stok/getStokBarangbyUnitNameLike";
            $addSatuan = $this->curl_request(
                GenerateTokenRS::headers_api_token($token['access_token']),
                $method_getgroup,
                $postData,
                $urlAddKelompok
            ); 
            // foreach ($addSatuan['data'] as $key => $jsons) { // This will search in the 2 jsons
            //     $pasing['id'] = $jsons['ProductCode'];
            //     $pasing['text'] = $jsons['NamaBarang'];
            //     $pasing['qty'] =$jsons['Qty'];
            //     $pasing['Satuan'] =$jsons['Satuan'];
            //     $pasing['NilaiHpp'] =$jsons['NilaiHpp'];
            //     $pasing['konversisatuan'] =$jsons['Konversi_satuan'];
                
            //     $datas[] = $pasing;
            // }
                //var_dump($addSatuan['status']);
            if ($addSatuan['status'] == true){
                foreach ($addSatuan['data'] as $key => $jsons) { // This will search in the 2 jsons
                    $pasing['id'] = $jsons['ProductCode'];
                    $pasing['label'] = $jsons['NamaBarang'];
                    $pasing['qty'] = $jsons['Qty'];
                    $pasing['Satuan'] = $jsons['Satuan'];
                    $pasing['NilaiHpp'] = $jsons['NilaiHpp'];
                    $pasing['konversisatuan'] = $jsons['Konversi_satuan'];
                    $pasing['Satuan_Beli'] = $jsons['Satuan_Beli'];
                    $datas[] = $pasing;
                }
            }else{
                $pasing['id'] = null;
                $pasing['label'] = ' -- Data Tidak Ditemukan ! -- ';
                $datas[] = $pasing;
            }
            return $datas;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getNamaUnit()
    {
        try {
            $this->db->query("SELECT ID,NamaUnit FROM MasterdataSQL.DBO.MstrUnitPerwatan ");
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                // $pasing['KD_PDP'] = $key['KD_PDP'];
                $pasing['NamaUnit'] = $key['NamaUnit'];
                $pasing['ID'] = $key['ID'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
