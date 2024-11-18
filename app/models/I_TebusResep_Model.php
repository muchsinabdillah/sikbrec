<?php

class I_TebusResep_Model
{
    private $db;
    use ApiRsyarsi;


    public function __construct()
    {
        $this->db = new Database;
    }


    public function addTebusResep($data)
    {
        try { 
            $TransasctionDate = $data['TransasctionDate'];
            $NoRegistrasi = $data['NoRegistrasi'];
            $No_Order = $data['No_Order'];
            $Unit = $data['Unit'];
            $Unit_Farmasi = $data['Unit_Farmasi'];
            $Notes = $data['Notes'];
            $NamaPembeli = $data['Nama'];
            $GenderPembeli = $data['JenisKelamin'];
            $AlamatPembeli = $data['Alamat'];
            $TglLahirPembeli = $data['Tgl_Lahir'];
            $TipePasien = $data['TipePasien'];
            $KodeJaminan = $data['KodeJaminan'];
            $isresep = $data['isresep'];
            $Jaminan = $data['Jaminan'];
            $NoMR = $data['No_MR'];
            $IdDokter = $data['IdDokter'];

            //var_dump($data);exit;


            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $name = $session->name;
            $IDEmployee = $session->IDEmployee;

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '
            {
                "TransactionDate" : "'.$TransasctionDate.'",
                "UserCreate" : "'.$userid.'",
                "UnitOrder" : "'.$Unit.'", 
                "UnitTujuan" : "'.$Unit_Farmasi.'", 
                "NoRegistrasi" : "'.$NoRegistrasi.'", 
                "Group_Transaksi" : "'. $isresep . '", 
                "Notes" : "'.$Notes.'" ,
                "NoResep" : "'.$No_Order.'" ,
                "NamaPembeli" : "'.$NamaPembeli.'" ,
                "GenderPembeli" : "'.$GenderPembeli.'" ,
                "AlamatPembeli" : "'.$AlamatPembeli.'" ,
                "Jaminan" : "'.$Jaminan.'" ,
                "TglLahirPembeli" : "'.$TglLahirPembeli.'" ,
                "GroupJaminan" : "'.$TipePasien.'" ,
                "KodeJaminan" : "'.$KodeJaminan.'" ,
                "NoMR" : "'.$NoMR.'" ,
                "KodePoli" : "'.$Unit_Farmasi.'" ,
                "KodeDokter" : "'.$IdDokter.'" ,
                "IdAdmin" : "0" ,
                "IdCaraMasuk" : "1" ,
                "TipeRegistrasi" : "1" ,
                "CaraBayar" : "'.$TipePasien.'" ,
                "TglRegistrasi" : "'.date('Y-m-d', strtotime($TransasctionDate)).'" ,
                "Company" : "RS YARSI WEB - TEBUS RESEP" 
            }
            ';
            $urlAddKelompok = "ResepTransactions/v2/addTebusResep/";
            $addSatuan = $this->curl_request(
                GenerateTokenRS::headers_api_token($token['access_token']),
                $method_getgroup,
                $postData,
                $urlAddKelompok
            );
            return $addSatuan;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    
    public function viewOrderResepbyDatePeriodeTebus($data)
    {
        try { 
            $tglawal = $data['tglawal'];
            $tglakhir = $data['tglakhir'];
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '
            {
                "tglPeriodeAwal" : "'.$tglawal.'" ,
                "tglPeriodeAkhir" : "'.$tglakhir.'" 
            }
            ';
            $urlAddKelompok = "ResepTransactions/v2/viewOrderResepbyDatePeriodeTebus/";
            $addSatuan = $this->curl_request(
                GenerateTokenRS::headers_api_token($token['access_token']),
                $method_getgroup,
                $postData,
                $urlAddKelompok
            );
            return $addSatuan['data'];
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function voidSalesTebus($data)
    {
        try { 
            $TransactionCode = $data['No_Transaksi'];
            $Unit = $data['Unit'];
            $alasan = $data['AlasanBatal'];
            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);

            // 2. add Data Group Barang 
            $method_getgroup = "POST";
            // 2. add Data Golongan
            $postData = '
            {
                "TransactionCode" : "'.$TransactionCode.'", 
                "UnitCode" : "'.$Unit.'",  
                "ReasonVoid" : "'.$alasan.'",
                "DateVoid" : "'.$datenowcreate.'",
                "UserVoid" : "'.$userid.'",
                "Void" : "1"
            }
            ';
            $urlAddKelompok = "transaction/sales/voidSalesTebus/";
            $addSatuan = $this->curl_request(
                GenerateTokenRS::headers_api_token($token['access_token']),
                $method_getgroup,
                $postData,
                $urlAddKelompok
            );
            return $addSatuan;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

     
}