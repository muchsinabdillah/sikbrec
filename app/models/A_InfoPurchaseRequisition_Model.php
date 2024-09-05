<?php
class A_InfoPurchaseRequisition_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getDataListInfoPurchaseRequisition($data)
    {
        try {
            $tglawal = $data['PeriodeAwal']; //(kanan view)
            $tglakhir = $data['PeriodeAkhir'];

            $query = "SELECT * FROM [Apotik_V1.1SQL].DBO.PurchaseRequisitionDetails
            where replace(CONVERT(VARCHAR(11), DateAdd, 111), '/','-') between :tglawal and :tglakhir and Void='0'
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
                $pasing['Kode_Barang'] = $row['ProductCode'];
                $pasing['Nama_Barang'] = $row['ProductName'];
                $pasing['Satuan'] = $row['Satuan'];
                $pasing['Satuan_Konversi'] = $row['Satuan_Konversi'];
                $pasing['Konversi_Qty'] = $row['KonversiQty'];
                $pasing['Konversi_Qty_Total'] = $row['Konversi_QtyTotal'];
                $pasing['Qty_Stok'] = $row['QtyStok'];
                $pasing['Qty_Safe'] = $row['QtySafe'];
                $pasing['Qty_PR'] = $row['QtyPR'];
                $pasing['Qty_Remain_PR'] = $row['QtyRemainPR'];
                $pasing['Void'] = $row['Void'];
                $pasing['User_Void'] = $row['UserVoid'];
                $pasing['Date_Void'] = $row['DateVoid'];
                $pasing['User_Add'] = $row['UserAdd'];
                $pasing['Date_Add'] = $row['DateAdd'];


                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDataListInfoPurchaseRequisition1($data)
    {
        try {
            $tglawal = $data['PeriodeAwal']; //(kanan view)
            $tglakhir = $data['PeriodeAkhir'];

            $query = "SELECT * FROM [Apotik_V1.1SQL].DBO.PurchaseRequisitionDetails
            where DateAdd between :tglawal and :tglakhir and Void='0'
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
                $pasing['Kode_Barang'] = $row['ProductCode'];
                $pasing['Nama_Barang'] = $row['ProductName'];
                $pasing['Satuan'] = $row['Satuan'];
                $pasing['Satuan_Konversi'] = $row['Satuan_Konversi'];
                $pasing['Konversi_Qty'] = $row['KonversiQty'];
                $pasing['Konversi_Qty_Total'] = $row['Konversi_QtyTotal'];
                $pasing['Qty_Stok'] = $row['QtyStok'];
                $pasing['Qty_Safe'] = $row['QtySafe'];
                $pasing['Qty_PR'] = $row['QtyPR'];
                $pasing['Qty_Remain_PR'] = $row['QtyRemainPR'];
                $pasing['Void'] = $row['Void'];
                $pasing['User_Void'] = $row['UserVoid'];
                $pasing['Date_Void'] = $row['DateVoid'];
                $pasing['User_Add'] = $row['UserAdd'];
                $pasing['Date_Add'] = $row['DateAdd'];


                $rows[] = $pasing;
            }
            return $data;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
