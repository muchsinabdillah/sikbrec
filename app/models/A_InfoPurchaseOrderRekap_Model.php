<?php
class A_InfoPurchaseOrderRekap_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getDataListInfoPurchaseOrderRekap($data)
    {
        try {
            $tglawal = $data['PeriodeAwal']; //(kanan view)
            $tglakhir = $data['PeriodeAkhir'];

            $query = "SELECT PurchaseCode,PurchaseDate,b.[First Name] NamaUser,a.Notes,c.Company as NamaSupplier, a.TotalQtyPurchase,a.SubtotalPurchase,a.TaxPurchase,a.GrandtotalPurchase
            ,a.PurchaseReqCode, 
            case when a.Close_PO='1' then 'CLOSED' ELSE 'OPEN' END AS StatusPO,TotalRowPO,TotalQtyPO,
            case when a.TipePO='1' then 'FARMASI' when a.TipePO='2' then 'UMUM' END AS TipePO
            FROM [Apotik_V1.1SQL].DBO.PurchaseOrders a
            inner join MasterdataSQL.dbo.Employees b
            on a.UserCreate collate  Latin1_General_CI_AS = b.NoPIN   collate  Latin1_General_CI_AS 
            inner join [Apotik_V1.1SQL].dbo.Suppliers c
            on c.ID = a.SupplierCode
            where  replace(CONVERT(VARCHAR(11), PurchaseDate, 111), '/','-') between :tglawal and :tglakhir
            and Void='0'
            ";

            $this->db->query($query);
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {

                $pasing['PurchaseCode'] = $row['PurchaseCode'];
                $pasing['Tanggal'] = $row['PurchaseDate'];
                $pasing['NamaUser'] = $row['NamaUser'];
                $pasing['Keterangan'] = $row['Notes'];
                $pasing['NamaSupplier'] = $row['NamaSupplier'];
                $pasing['TotalQtyPurchase'] = $row['TotalQtyPurchase'];
                $pasing['SubtotalPurchase'] = $row['SubtotalPurchase'];
                $pasing['TaxPurchase'] = $row['TaxPurchase'];
                $pasing['GrandtotalPurchase'] = $row['GrandtotalPurchase'];
                $pasing['PurchaseReqCode'] = $row['PurchaseReqCode'];
                $pasing['StatusPO'] = $row['StatusPO'];
                $pasing['TotalPO'] = $row['TotalRowPO'];
                $pasing['TotalQtyPO'] = $row['TotalQtyPO'];
                $pasing['TipePO'] = $row['TipePO'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDataListInfoPurchaseOrderRekap1($data)
    {
        try {
            $tglawal = $data['PeriodeAwal']; //(kanan view)
            $tglakhir = $data['PeriodeAkhir'];

            $query = "SELECT PurchaseCode,PurchaseDate,b.[First Name] NamaUser,a.Notes,c.Company as NamaSupplier, a.TotalQtyPurchase,a.SubtotalPurchase,a.TaxPurchase,a.GrandtotalPurchase
            ,a.PurchaseReqCode, 
            case when a.Close_PO='1' then 'CLOSED' ELSE 'OPEN' END AS StatusPO,TotalRowPO,TotalQtyPO,
            case when a.TipePO='1' then 'FARMASI' when a.TipePO='2' then 'UMUM' END AS TipePO
            FROM [Apotik_V1.1SQL].DBO.PurchaseOrders a
            inner join MasterdataSQL.dbo.Employees b
            on a.UserCreate collate  Latin1_General_CI_AS = b.NoPIN   collate  Latin1_General_CI_AS 
            inner join [Apotik_V1.1SQL].dbo.Suppliers c
            on c.ID = a.SupplierCode
            where  replace(CONVERT(VARCHAR(11),  PurchaseDate, 111), '/','-') between :tglawal and :tglakhir
            and Void='0'
            ";

            $this->db->query($query);
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {

                $pasing['PurchaseCode'] = $row['PurchaseCode'];
                $pasing['Tanggal'] = $row['PurchaseDate'];
                $pasing['NamaUser'] = $row['NamaUser'];
                $pasing['Keterangan'] = $row['Notes'];
                $pasing['NamaSupplier'] = $row['NamaSupplier'];
                $pasing['TotalQtyPurchase'] = $row['TotalQtyPurchase'];
                $pasing['SubtotalPurchase'] = $row['SubtotalPurchase'];
                $pasing['TaxPurchase'] = $row['TaxPurchase'];
                $pasing['GrandtotalPurchase'] = $row['GrandtotalPurchase'];
                $pasing['PurchaseReqCode'] = $row['PurchaseReqCode'];
                $pasing['StatusPO'] = $row['StatusPO'];
                $pasing['TotalPO'] = $row['TotalRowPO'];
                $pasing['TotalQtyPO'] = $row['TotalQtyPO'];
                $pasing['TipePO'] = $row['TipePO'];

                $rows[] = $pasing;
            }
            return $data;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
