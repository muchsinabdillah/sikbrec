<?php
class I_Masterdata_Barang_Model
{
    private $db;
    use ApiRsyarsi;
    public function __construct()
    {
        $this->db = new Database;
    } 
    public function getBarangAll()
    {
        try {

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "GET";
            $urlAddKelompok = "masterdata/apotek/getBarangAll/";
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
    public function getBarangbyId($data)
    {
        try {

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "GET";
            $urlAddKelompok = "masterdata/apotek/getBarangbyId/". $data['id'];
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, [], $urlAddKelompok);
            return $addSatuan;
            return $addSatuan['data'];
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function addBarang($data)
    {
        try {
             $ID = $data["ID"];
             $Product_Code = $data["Product_Code"];
             $Barcode_Code = $data["Barcode_Code"];
             $Nama_Product = $data["Nama_Product"];
             $Nama_Alias = $data["Nama_Alias"];
             $Discontinue = $data["Discontinue"];
             $KelompokBarang = $data["KelompokBarang"];
             $Jenis_Barang = $data["Jenis_Barang"];
             $Golongan_Obat = $data["Golongan_Obat"];
             $Group_Barang = $data["Group_Barang"];
             $Satuan_Beli = $data["Satuan_Beli"];
             $Satuan_Jual = $data["Satuan_Jual"];
             $Konversi_Satuan = $data["Konversi_Satuan"];
             $Stok_Minimum = $data["Stok_Minimum"];
             $Label_Signa = $data["Label_Signa"];
             $Komposisi = $data["Komposisi"];
             $Dosis = $data["Dosis"];
             $KontraIndikasi = $data["KontraIndikasi"];
             $EfekSamping = $data["EfekSamping"];
             $Peringatan = $data["Peringatan"];
             $Kemasan = $data["Kemasan"];
             $Indikasi = $data["Indikasi"];
             $Deskripsi = $data["Deskripsi"];
             $KD_PDP = $data['KodePDP'];

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '{
                            "ProductCode" : "'.$Product_Code.'",
                            "ProductName" : "'.$Nama_Product.'",
                            "ProductNameAlias" : "'.$Nama_Alias.'",
                            "Discontinue" : "'.$Discontinue.'",
                            "Category" : "'.$KelompokBarang.'",
                            "Satuan_Beli" : "'.$Satuan_Beli.'",
                            "Unit_Satuan" : "'.$Satuan_Jual.'",
                            "Konversi_satuan" : "'.$Konversi_Satuan.'",
                            "Reorder_Level" : "0",
                            "Signa" : "'.$Label_Signa.'",
                            "Description" : "'.$Deskripsi.'",
                            "Composisi" : "'.$Komposisi.'",
                            "Indikasi" : "'.$Indikasi.'",
                            "Dosis" : "'.$Dosis.'",
                            "Kontra_indikasi" : "'.$KontraIndikasi.'",
                            "Efek_Samping" : "'.$EfekSamping.'",
                            "Peringatan" : "'.$Peringatan.'",
                            "Kemasan" : "'.$Kemasan.'",
                            "Kode_Barcode" : "'.$Barcode_Code.'",
                            "flag_telemedicine" : "0",
                            "Jenis_Barang" : "'.$Jenis_Barang.'",
                            "Golongan_Obat" : "'.$Golongan_Obat.'",
                            "Group_DK" : "'.$Group_Barang.'",
                            "KD_PDP" : "'.$KD_PDP.'"
                        }';
            $urlAddKelompok = "masterdata/apotek/addBarang/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, 
                                            $postData, $urlAddKelompok);
            return $addSatuan;


           // return $this->db->execute();
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon(); 
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e,
                
            );
            return $callback; 
        }
    }

    public function editBarang($data)
    {
        try {
             $ID = $data["ID"];
             $Product_Code = $data["Product_Code"];
             $Barcode_Code = $data["Barcode_Code"];
             $Nama_Product = $data["Nama_Product"];
             $Nama_Alias = $data["Nama_Alias"];
             $Discontinue = $data["Discontinue"];
             $KelompokBarang = $data["KelompokBarang"];
             $Jenis_Barang = $data["Jenis_Barang"];
             $Golongan_Obat = $data["Golongan_Obat"];
             $Group_Barang = $data["Group_Barang"];
             $Satuan_Beli = $data["Satuan_Beli"];
             $Satuan_Jual = $data["Satuan_Jual"];
             $Konversi_Satuan = $data["Konversi_Satuan"];
             $Stok_Minimum = $data["Stok_Minimum"];
             $Label_Signa = $data["Label_Signa"];
             $Komposisi = $data["Komposisi"];
             $Dosis = $data["Dosis"];
             $KontraIndikasi = $data["KontraIndikasi"];
             $EfekSamping = $data["EfekSamping"];
             $Peringatan = $data["Peringatan"];
             $Kemasan = $data["Kemasan"];
             $Indikasi = $data["Indikasi"];
             $Deskripsi = $data["Deskripsi"];
             $KD_PDP = $data['KodePDP'];

             $Kemasan = htmlspecialchars($data["Kemasan"], ENT_QUOTES, 'UTF-8');

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '{
                            "ID" : "'.$ID.'",
                            "ProductCode" : "'.$Product_Code.'",
                            "ProductName" : "'.$Nama_Product.'",
                            "ProductNameAlias" : "'.$Nama_Alias.'",
                            "Discontinue" : "'.$Discontinue.'",
                            "Category" : "'.$KelompokBarang.'",
                            "Satuan_Beli" : "'.$Satuan_Beli.'",
                            "Unit_Satuan" : "'.$Satuan_Jual.'",
                            "Konversi_satuan" : "'.$Konversi_Satuan.'",
                            "Reorder_Level" : "0",
                            "Signa" : "'.$Label_Signa.'",
                            "Description" : "'.$Deskripsi.'",
                            "Composisi" : "'.$Komposisi.'",
                            "Indikasi" : "'.$Indikasi.'",
                            "Dosis" : "'.$Dosis.'",
                            "Kontra_indikasi" : "'.$KontraIndikasi.'",
                            "Efek_Samping" : "'.$EfekSamping.'",
                            "Peringatan" : "'.$Peringatan.'",
                            "Kemasan" : "'.$Kemasan.'",
                            "Kode_Barcode" : "'.$Barcode_Code.'",
                            "flag_telemedicine" : "0",
                            "Jenis_Barang" : "'.$Jenis_Barang.'",
                            "Golongan_Obat" : "'.$Golongan_Obat.'",
                            "Group_DK" : "'.$Group_Barang.'",
                            "KD_PDP" : "'.$KD_PDP.'"
                        }
                        ';
                        
            $urlAddKelompok = "masterdata/apotek/editBarang/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup,$postData, $urlAddKelompok);
            return $addSatuan;


           // return $this->db->execute();
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon(); 
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e,
                
            );
            return $callback; 
        }
    }

    public function addBarangSupplier($data)
    {
        try {
             $ID = $data["ID"];
             $IDSupplier = $data["DataSupplier"];

             if ($IDSupplier == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Supplier Kosong !',
                );
                return $callback;
                exit;
            }

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '{
                            "IDBarang" : "'.$ID.'",
                            "IDSupplier" : "'.$IDSupplier.'"
                        }';
            $urlAddKelompok = "masterdata/apotek/addBarangSupplier/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, 
                                            $postData, $urlAddKelompok);
            return $addSatuan;


           // return $this->db->execute();
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon(); 
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e,
                
            );
            return $callback; 
        }
    }

    public function getBarangbyFormulariums($data)
    {
        try {
            $ID = $data['ID'];

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "GET";
            $urlAddKelompok = "masterdata/apotek/getBarangbyFormulariums/".$ID;
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, [], $urlAddKelompok);
            //return $addSatuan['data'];
            if ($addSatuan['status'] == 1
            ) {
                return $addSatuan['data'];
            } else {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => "Data Kosong",
                );
                return $callback;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function addBarangFormularium($data)
    {
        try {
             $ID = $data["ID"];
             $DataFormularium = $data["DataFormularium"];

             if ($DataFormularium == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Formularium Kosong !',
                );
                return $callback;
                exit;
            }

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '{
                            "IDBarang" : "'.$ID.'",
                            "IDFormularium" : "'.$DataFormularium.'"
                        }';
            $urlAddKelompok = "masterdata/apotek/addBarangFormularium/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, 
                                            $postData, $urlAddKelompok);
            return $addSatuan;


           // return $this->db->execute();
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon(); 
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e,
                
            );
            return $callback; 
        }
    }

    public function getBarangbySuppliers($data)
    {
        try {
            $ID = $data['ID'];

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "GET";
            $urlAddKelompok = "masterdata/apotek/getBarangbySuppliers/".$ID;
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, [], $urlAddKelompok);
            //return $addSatuan['data'];
            if ($addSatuan['status'] == 1
            ) {
                return $addSatuan['data'];
            } else {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => "Data Kosong",
                );
                return $callback;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function deleteBarangSupplier($data)
    {
        try {
             $idbarang = $data["idbarang"];
             $idparam = $data["idparam"];

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "DELETE";
            // 2. add Data Golongan
            $postData = '{
                            "IDBarang" : "'.$idbarang.'",
                            "IDSupplier" : "'.$idparam.'"
                        }';
            $urlAddKelompok = "masterdata/apotek/deleteBarangSupplier/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, 
                                            $postData, $urlAddKelompok);
            return $addSatuan;


           // return $this->db->execute();
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon(); 
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e,
                
            );
            return $callback; 
        }
    }

    public function deleteBarangFormularium($data)
    {
        try {
             $idbarang = $data["idbarang"];
             $idparam = $data["idparam"];

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "DELETE";
            // 2. add Data Golongan
            $postData = '{
                            "IDBarang" : "'.$idbarang.'",
                            "IDFormularium" : "'.$idparam.'"
                        }';
            $urlAddKelompok = "masterdata/apotek/deleteBarangFormularium/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, 
                                            $postData, $urlAddKelompok);
            return $addSatuan;


           // return $this->db->execute();
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon(); 
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e,
                
            );
            return $callback; 
        }
    }

    public function getHistoryHargaBeli($data)
    {
        try {
            $ID = $data['ID'];

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "GET";
            $urlAddKelompok = "masterdata/apotek/getHistoryHargaBeli/".$ID;
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, [], $urlAddKelompok);
            //return $addSatuan['data'];
            if ($addSatuan['status'] == 1
            ) {
                return $addSatuan['data'];
            } else {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => "Data Kosong",
                );
                return $callback;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getHistoryHargaJual($data)
    {
        try {
            $ID = $data['ID'];

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "GET";
            $urlAddKelompok = "masterdata/apotek/getHistoryHargaJual/".$ID;
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, [], $urlAddKelompok);
            //return $addSatuan['data'];
            if ($addSatuan['status'] == 1
            ) {
                return $addSatuan['data'];
            } else {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => "Data Kosong",
                );
                return $callback;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    

    public function getDataPaketbyNameLike($data)
    {
        try {
            $keywords = $data['keywords'];  
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '{
                            "keywords" : "'.$keywords.'"
                        }';
            $urlAddKelompok = "masterdata/apotek/getDataPaketbyNameLike/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, 
                                            $postData, $urlAddKelompok);
            if($addSatuan['status']){
                return $addSatuan['data'];
            }else{
                return [];
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    

    public function getDataPaketDetailbyIDHdr($data)
    {
        try {
            $id_header = $data['id_header'];  
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '{
                            "id_header" : "'.$id_header.'"
                        }';
            $urlAddKelompok = "masterdata/apotek/getDataPaketDetailbyIDHdr/";
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, 
                                            $postData, $urlAddKelompok);
            if($addSatuan['status']){
                return $addSatuan['data'];
            }else{
                return [];
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getBarangKonversibyId($data)
    {
        try {
            $ProductCode = $data['ProductCode'];

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "GET";
            $urlAddKelompok = "masterdata/apotek/getBarangKonversibyId/".$ProductCode;
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, [], $urlAddKelompok);
            return $addSatuan;
            if ($addSatuan['status'] == 1
            ) {
                return $addSatuan['data'];
            } else {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => "Data Kosong",
                );
                return $callback;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getBarangKonversibyIdDetail($data)
    {
        try {
            $id = $data['id'];

            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "GET";
            $urlAddKelompok = "masterdata/apotek/getBarangKonversibyIddetail/".$id;
            $addSatuan = $this->curl_request(GenerateTokenRS::headers_api_token($token['access_token']), $method_getgroup, [], $urlAddKelompok);
            return $addSatuan;
            if ($addSatuan['status'] == 1
            ) {
                return $addSatuan['data'];
            } else {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => "Data Kosong",
                );
                return $callback;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
