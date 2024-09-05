<?php
class A_InfoBuku_Model
{
    private $db;
    use ApiRsyarsi;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function getDataListInfoBuku($data)
    {
      
        try {
            $tglawal = $data['PeriodeAwal']; //(kanan view)
            $tglakhir = $data['PeriodeAkhir'];
            $NamaUnit = $data['NamaUnit'];            
            $KodeBarang = $data['KodeBarang'];


            
            // $query = "SELECT TransactionCode, TransactionDate,ProductCode,ProductName,Satuan,'0' as QtyAwal, QtyIn,QtyOut, '' as QtyAkhir,
            // TransactionCodeReff,TransactionCodeReff2,b.NamaUnit
            // FROM APOREK_3.DBO.BukuStoks a
            // inner join MasterdataSQL.dbo.MstrUnitPerwatan b
            // on a.Unit = b.id
            // WHERE replace(CONVERT(VARCHAR(11), a.Transactiondate, 111), '/','-') between :tglawal and :tglakhir";

            $query = "EXEC infobuku @PeriodeAwal =:tglawal,
            @PeriodeAkhir=:tglakhir,
          @Unit=:NamaUnit
          ,@KodeBarang=:KodeBarang";

            $this->db->query($query);
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $this->db->bind('NamaUnit', $NamaUnit);
            $this->db->bind('KodeBarang', $KodeBarang);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {

                $pasing['Kode_Transaksi'] = $row['kodetransaksi'];
                $pasing['Tgl_Transaksi'] = $row['TransactionDate'];
                $pasing['Kode_Barang'] = $row['ProductCode'];
                $pasing['Nama_Barang'] = $row['ProductName'];
                $pasing['Satuan'] = $row['Satuan'];
                $pasing['SaldoAwal'] = $row['SaldoAwal'];
                $pasing['Qty_In'] = $row['QtyIn'];
                $pasing['Qty_Out'] = $row['QtyOut'];
                $pasing['SaldoAkhir'] = $row['SaldoAkhir'];
                $pasing['SaldoPersediaanAwal'] = $row['SaldoPersediaanAwal'];
                $pasing['PersediaanIn'] = $row['PersediaanIn'];
                $pasing['PersediaanOut'] = $row['PersediaanOut'];
                $pasing['SaldoPersediaanAkhir'] = $row['SaldoPersediaanAkhir'];
                $pasing['No_Trs_Reff2'] = $row['TransactionCodeReff2'];

                $rows[] = $pasing;
            }
            return $rows;


            //  // 1. Gen Token
            //  $method = "POST";
            //  $URL = "genToken";
            //  $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);
 
            //  // 2. add Data Group Barang 
            //  $method_getgroup = "POST";
            //  // 2. add Data Golongan
            //  $postData = '{  
            //      "PeriodeAwal" : "' . $tglawal .'", 
            //      "PeriodeAkhir" : "' . $tglakhir .'",
            //      "unit" : "' . $NamaUnit .'",
            //      "ProductCode" : "'.$KodeBarang.'" 


            //  }';
            //  $urlAddKelompok = "information/inventory/stok/getBukuStokBarangbyUnit";
            //  $addSatuan = $this->curl_request(
            //      GenerateTokenRS::headers_api_token($token['access_token']),
            //      $method_getgroup,
            //      $postData,
            //      $urlAddKelompok
            //  );  
            //  $no=1;
            //  $qtyAkhir = 0;
            //  if ($addSatuan['status'] == true){
            //      foreach ($addSatuan['data'] as $key => $row) { // This will search in the 2 jsons
            //         if($no== '1'){
                       
            //             /// cek data stok seblumnya
            //             // 1. Gen Token
            //             $method = "POST";
            //             $URL = "genToken";
            //             $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);
            
            //             // 2. add Data Group Barang 
            //             $method_getgroup = "POST";
            //             // 2. add Data Golongan
            //             $postData2 = '{  
            //                 "PeriodeAwal" : "'.$tglawal.'", 
            //                 "PeriodeAkhir" : "'.$tglakhir.'",
            //                 "unit" : "' . $NamaUnit .'",
            //                 "ProductCode" : "'.$KodeBarang.'" 


            //             }';
            //             $urlGenStokBefore = "information/inventory/stok/getBukuStokBarangBeforebyUnit";
            //             $dataBukuBeofre = $this->curl_request(
            //                 GenerateTokenRS::headers_api_token($token['access_token']),
            //                 $method_getgroup,
            //                 $postData2,
            //                 $urlGenStokBefore
            //             );   

            //             if ($dataBukuBeofre['status'] == true){
            //                 $stokbefore = 0;
            //                 foreach ($dataBukuBeofre['data'] as $key => $rowsssss) {
            //                     $stokbefore = $rowsssss['stok'];
            //                 }
            //             }
            //             $pasing['Kode_Transaksi'] = $row['TransactionCode'];
            //             $pasing['Tgl_Transaksi'] = $row['TransactionDate'];
            //             $pasing['Kode_Barang'] = $row['ProductCode'];
            //             $pasing['Nama_Barang'] = $row['ProductName'];                        
            //             $pasing['no'] = $no; 
            //             $pasing['Satuan'] = $row['Satuan'];
            //             $pasing['Qty_Awal'] = 0;
            //             $pasing['Qty_In'] = $row['QtyIn'];
            //             $pasing['Qty_Out'] = $row['QtyOut'];
            //             $pasing['Qty_Akhir'] = (0+$row['QtyIn'])-$row['QtyOut'];
            //             $qtyAkhir  = ($stokbefore+$row['QtyIn'])-$row['QtyOut'];
            //             $pasing['No_Trs_Reff'] = $row['TransactionCodeReff'];
            //             $pasing['No_Trs_Reff2'] = $row['TransactionCodeReff2'];
            //             $pasing['Nama_Unit'] = $row['NamaUnit'];
            //         }else{
            //             $pasing['Kode_Transaksi'] = $row['TransactionCode'];
            //             $pasing['Tgl_Transaksi'] = $row['TransactionDate'];
            //             $pasing['Kode_Barang'] = $row['ProductCode'];
            //             $pasing['Nama_Barang'] = $row['ProductName'];
            //             $pasing['Satuan'] = $row['Satuan'];
            //             $pasing['Qty_Awal'] = $qtyAkhir;
            //             $pasing['Qty_In'] = $row['QtyIn'];
            //             $pasing['Qty_Out'] = $row['QtyOut'];
            //             $pasing['no'] = $no; 
            //             $pasing['Qty_Akhir'] = ($qtyAkhir+$row['QtyIn'])-$row['QtyOut'];
            //             $pasing['No_Trs_Reff'] = $row['TransactionCodeReff'];
            //             $pasing['No_Trs_Reff2'] = $row['TransactionCodeReff2'];
            //             $pasing['Nama_Unit'] = $row['NamaUnit'];
            //         }
                        
                    
            //         $no++;
                    
            //          $datas[] = $pasing;
            //      }
            //  }else{
            //     $pasing['Kode_Transaksi'] = null;
            //     $pasing['Tgl_Transaksi'] = null;
            //     $pasing['Kode_Barang'] = null;
            //     $pasing['Nama_Barang'] = null;
            //     $pasing['Satuan'] = null;
            //     $pasing['Qty_Awal'] = null;
            //     $pasing['Qty_In'] = null;
            //     $pasing['Qty_Out'] = null;
            //     $pasing['no'] = null; 
            //     $pasing['Qty_Akhir'] = null;
            //     $pasing['No_Trs_Reff'] = null;
            //     $pasing['No_Trs_Reff2'] = null;
            //     $pasing['Nama_Unit'] = null;
            //      $datas[] = $pasing;
            //  }
            //  return $datas;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getBarangAll($data)
    {
        try {
     
            $rows = array();
            $array = array();
            
            // 1. Gen Token
            $method = "POST";
            $URL = "genToken";
            $token = $this->curl_request_token(GenerateTokenRS::headers_api(), $method, $URL);
 
             // 2. add Data Group Barang 
             $method_getgroup = "GET";
        
             $urlAddKelompok = "masterdata/apotek/getBarangAll";
             $addSatuan = $this->curl_request(
                 GenerateTokenRS::headers_api_token($token['access_token']),
                 $method_getgroup,
                 [],
                 $urlAddKelompok
             );  
             if ($addSatuan['status'] == true){
                     $datas[] = $addSatuan['data'];
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
}
