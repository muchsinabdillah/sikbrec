<?php
class A_InfoPurchaseOrder_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getDataListInfoPurchaseOrder($data)
    {
        try {
            $tglawal = $data['PeriodeAwal']; //(kanan view)
            $tglakhir = $data['PeriodeAkhir'];

            $query = "SELECT a.id,a.PurchaseCode,a.ProductCode,a.ProductName,a.Price,a.DiscountProsen,a.DiscountRp,a.QtyPurchase,a.SubtotalPurchase,a.TaxProsen,a.TaxRp,
            a.TotalPurchase
            FROM [Apotik_V1.1SQL].dbo.PurchaseOrderDetails a
            inner join  [Apotik_V1.1SQL].DBO.PurchaseOrders b
            on a.PurchaseCode = b.PurchaseCode
            where  replace(CONVERT(VARCHAR(11),  b.PurchaseDate, 111), '/','-') between :tglawal and :tglakhir
            and a.Void='0'
            ";

            $this->db->query($query);
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {

                $pasing['id'] = $row['id'];
                $pasing['PurchaseCode'] = $row['PurchaseCode'];
                $pasing['Kode_Barang'] = $row['ProductCode'];
                $pasing['Nama_Barang'] = $row['ProductName'];
                $pasing['Harga'] = $row['Price'];
                $pasing['DiscountProsen'] = $row['DiscountProsen'];
                $pasing['DiscountRp'] = $row['DiscountRp'];
                $pasing['QtyPurchase'] = $row['QtyPurchase'];
                $pasing['SubtotalPurchase'] = $row['SubtotalPurchase'];
                $pasing['TaxProsen'] = $row['TaxProsen'];
                $pasing['TaxRp'] = $row['TaxRp'];
                $pasing['TotalPurchase'] = $row['TotalPurchase'];


                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDataListInfoPurchaseOrder1($data)
    {
        try {
            $tglawal = $data['PeriodeAwal']; //(kanan view)
            $tglakhir = $data['PeriodeAkhir'];

            $query = "SELECT a.id,a.PurchaseCode,a.ProductCode,a.ProductName,a.Price,a.DiscountProsen,a.DiscountRp,a.QtyPurchase,a.SubtotalPurchase,a.TaxProsen,a.TaxRp,
            a.TotalPurchase
            FROM [Apotik_V1.1SQL].dbo.PurchaseOrderDetails a
            inner join  [Apotik_V1.1SQL].DBO.PurchaseOrders b
            on a.PurchaseCode = b.PurchaseCode
            where  replace(CONVERT(VARCHAR(11),  b.PurchaseDate, 111), '/','-') between :tglawal and :tglakhir
            and a.Void='0'
            ";

            $this->db->query($query);
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {

                $pasing['id'] = $row['id'];
                $pasing['PurchaseCode'] = $row['PurchaseCode'];
                $pasing['Kode_Barang'] = $row['ProductCode'];
                $pasing['Nama_Barang'] = $row['ProductName'];
                $pasing['Harga'] = $row['Price'];
                $pasing['DiscountProsen'] = $row['DiscountProsen'];
                $pasing['DiscountRp'] = $row['DiscountRp'];
                $pasing['QtyPurchase'] = $row['QtyPurchase'];
                $pasing['SubtotalPurchase'] = $row['SubtotalPurchase'];
                $pasing['TaxProsen'] = $row['TaxProsen'];
                $pasing['TaxRp'] = $row['TaxRp'];
                $pasing['TotalPurchase'] = $row['TotalPurchase'];


                $rows[] = $pasing;
            }
            return $data;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
