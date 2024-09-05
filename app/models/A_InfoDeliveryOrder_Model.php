<?php
class A_InfoDeliveryOrder_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getDataListInfoDeliveryOrder($data)
    {
        try {
            $tglawal = $data['PeriodeAwal']; //(kanan view)
            $tglakhir = $data['PeriodeAkhir'];

            $query = "SELECT * from [Apotik_V1.1SQL].DBO.v_transaksi_do_dtl 
            where DateEntry between :tglawal and :tglakhir and Void='0'
            ";

            $this->db->query($query);
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {

                $pasing['ID'] = $row['ID'];
                $pasing['Transaction_Code'] = $row['TransactionCode'];
                $pasing['Product_Code'] = $row['ProductCode'];
                $pasing['Product_Satuan'] = $row['ProductSatuan'];
                $pasing['Product_Name'] = $row['ProductName'];
                $pasing['Last_Price'] = $row['LastPrice'];
                $pasing['Price'] = $row['Price'];
                $pasing['Discount_Prosen'] = $row['DiscountProsen'];
                $pasing['Discount_Rp'] = $row['DiscountRp'];
                $pasing['DiscountRp_TTL'] = $row['DiscountRpTTL'];
                $pasing['Qty_Purchase'] = $row['QtyPurchase'];
                $pasing['Qty_Delivery'] = $row['QtyDelivery'];
                $pasing['QtyDelivery_Remain'] = $row['QtyDeliveryRemain'];
                $pasing['SubtotalDelivery_Order'] = $row['SubtotalDeliveryOrder'];
                $pasing['Tax_Prosen'] = $row['TaxProsen'];
                $pasing['Tax_Rp'] = $row['TaxRp'];
                $pasing['TaxRp_TTL'] = $row['TaxRpTTL'];
                $pasing['TotalDelivery_Order'] = $row['TotalDeliveryOrder'];
                $pasing['Hpp'] = $row['Hpp'];
                $pasing['Hpp_Tax'] = $row['HppTax'];
                $pasing['Expired_Date'] = $row['ExpiredDate'];
                $pasing['NoBatch'] = $row['NoBatch'];
                $pasing['Konversi_Qty'] = $row['KonversiQty'];
                $pasing['KonversiQty_Total'] = $row['Konversi_QtyTotal'];
                $pasing['Satuan_Konversi'] = $row['Satuan_Konversi'];
                $pasing['Date_Entry'] = $row['DateEntry'];
                $pasing['Nama_User'] = $row['NamaUser'];




                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDataListInfoDeliveryOrder1($data)
    {
        try {
            $tglawal = $data['PeriodeAwal']; //(kanan view)
            $tglakhir = $data['PeriodeAkhir'];

            $query = "SELECT * from [Apotik_V1.1SQL].DBO.v_transaksi_do_dtl 
            where DateEntry between :tglawal and :tglakhir and Void='0'
            ";

            $this->db->query($query);
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {

                $pasing['ID'] = $row['ID'];
                $pasing['Transaction_Code'] = $row['TransactionCode'];
                $pasing['Product_Code'] = $row['ProductCode'];
                $pasing['Product_Satuan'] = $row['ProductSatuan'];
                $pasing['Product_Name'] = $row['ProductName'];
                $pasing['Last_Price'] = $row['LastPrice'];
                $pasing['Price'] = $row['Price'];
                $pasing['Discount_Prosen'] = $row['DiscountProsen'];
                $pasing['Discount_Rp'] = $row['DiscountRp'];
                $pasing['DiscountRp_TTL'] = $row['DiscountRpTTL'];
                $pasing['Qty_Purchase'] = $row['QtyPurchase'];
                $pasing['Qty_Delivery'] = $row['QtyDelivery'];
                $pasing['QtyDelivery_Remain'] = $row['QtyDeliveryRemain'];
                $pasing['SubtotalDelivery_Order'] = $row['SubtotalDeliveryOrder'];
                $pasing['Tax_Prosen'] = $row['TaxProsen'];
                $pasing['Tax_Rp'] = $row['TaxRp'];
                $pasing['TaxRp_TTL'] = $row['TaxRpTTL'];
                $pasing['TotalDelivery_Order'] = $row['TotalDeliveryOrder'];
                $pasing['Hpp'] = $row['Hpp'];
                $pasing['Hpp_Tax'] = $row['HppTax'];
                $pasing['Expired_Date'] = $row['ExpiredDate'];
                $pasing['NoBatch'] = $row['NoBatch'];
                $pasing['Konversi_Qty'] = $row['KonversiQty'];
                $pasing['KonversiQty_Total'] = $row['Konversi_QtyTotal'];
                $pasing['Satuan_Konversi'] = $row['Satuan_Konversi'];
                $pasing['Date_Entry'] = $row['DateEntry'];
                $pasing['Nama_User'] = $row['NamaUser'];




                $rows[] = $pasing;
            }
            return $data;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
