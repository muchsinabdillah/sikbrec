<?php
class  B_info_harga_Jual
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getDataList($data)
    {
        try { 

                $query = "SELECT ID, [Product Name] as Nama, [Unit Satuan] as satuanjual,Satuan_Beli,Konversi_satuan
                        FROM [Apotik_V1.1SQL].DBO.Products WHERE Discontinued='0' ";

            $this->db->query($query); 
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            $datex = Utils::datenowcreateNotFull();
            foreach ($data as $rowx) {
                $this->db->query("SELECT top 1 NominalHna FROM [Apotik_V1.1SQL].dbo.Hnas where ProductCode=:KODEBARANG and Batal='0' 
                                and :datex between StartDate and ExpiredDate
                                order by NominalHna desc");
                $this->db->bind('KODEBARANG',$rowx['ID']); 
                $this->db->bind('datex',$datex); 
                $row = $this->db->rowCount();
               
                    $key =  $this->db->single();
                    $Hna = $key['NominalHna'];
                    if($Hna >0){ 
                            // $hargaprofit = ((($Hna*$rowx['Konversi_satuan'])+7500+400)*1.1) * 1.4;
                            $hargappn = ((($Hna*$rowx['Konversi_satuan'])+7500+400)*1.1);
                            $hargaprofit = $hargappn * 1.5;
                            $harga = $hargaprofit/$rowx['Konversi_satuan'];
                           // $harga = number_format($Hna); 
                    }else{
                        $harga = 0;
                    } 
                    
                    $pasing['no'] = $no++;
                        $pasing['ID'] = $rowx['ID'];
                        $pasing['Nama'] = $rowx['Nama'];
                        $pasing['Satuan_Beli'] = $rowx['Satuan_Beli'];
                        $pasing['satuanjual'] = $rowx['satuanjual'];
                        $pasing['Harga'] = number_format($harga);  
                        $pasing['Konversi_satuan'] = $rowx['Konversi_satuan']; 
                        $rows[] = $pasing; 
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

}