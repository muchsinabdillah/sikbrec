<?php
class A_InfoDeliveryOrderRekap_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getDataListInfoDeliveryOrderRekap($data)
    {
        try {
            $tglawal = $data['PeriodeAwal']; //(kanan view)
            $tglakhir = $data['PeriodeAkhir'];

            $query = "SELECT TransactionCode,DeliveryOrderDate,b.[First Name] UserCreate,SupplierCode,Notes,
TotalQtyDelivery,SubtotalDelivery,TaxDelivery,GrandtotalDelivery,PurchaseOrderCode,TotalRowDO,TotalQtyDO,JenisDelivery,
NamaSupplier,NamaUser,TglPeriode,UnitCode
            FROM [Apotik_V1.1SQL].DBO.v_transaksi_do_hdr a
            inner join MasterdataSQL.dbo.Employees b
            on a.UserCreate collate  Latin1_General_CI_AS = b.NoPIN    collate  Latin1_General_CI_AS 
            where DeliveryOrderDate between :tglawal and :tglakhir
            ";

            $this->db->query($query);
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {

                $pasing['Transaction_Code'] = $row['TransactionCode'];
                $pasing['DeliveryOrder_Date'] = $row['DeliveryOrderDate'];
                $pasing['User_Create'] = $row['UserCreate'];
                $pasing['Supplier_Code'] = $row['SupplierCode'];
                $pasing['Notes'] = $row['Notes'];
                $pasing['TotalQty_Delivery'] = $row['TotalQtyDelivery'];
                $pasing['Subtotal_Delivery'] = $row['SubtotalDelivery'];
                $pasing['Tax_Delivery'] = $row['TaxDelivery'];
                $pasing['GrandTotal_Delivery'] = $row['GrandtotalDelivery'];
                $pasing['PurchaseOrder_Code'] = $row['PurchaseOrderCode'];
                $pasing['TotalRowDO'] = $row['TotalRowDO'];
                $pasing['TotalQty_DO'] = $row['TotalQtyDO'];
                $pasing['Jenis_Delivery'] = $row['JenisDelivery'];
                $pasing['Nama_Supplier'] = $row['NamaSupplier'];
                $pasing['Nama_User'] = $row['NamaUser'];
                $pasing['Tanggal_Periode'] = $row['TglPeriode'];
                $pasing['Unit_Code'] = $row['UnitCode'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDataListInfoDeliveryOrderRekap1($data)
    {
        try {
            $tglawal = $data['PeriodeAwal']; //(kanan view)
            $tglakhir = $data['PeriodeAkhir'];

            $query = "SELECT TransactionCode,DeliveryOrderDate,b.[First Name] UserCreate,SupplierCode,Notes,
TotalQtyDelivery,SubtotalDelivery,TaxDelivery,GrandtotalDelivery,PurchaseOrderCode,TotalRowDO,TotalQtyDO,JenisDelivery,
NamaSupplier,NamaUser,TglPeriode,UnitCode
            FROM [Apotik_V1.1SQL].DBO.v_transaksi_do_hdr a
            inner join MasterdataSQL.dbo.Employees b
            on a.UserCreate collate  Latin1_General_CI_AS = b.NoPIN    collate  Latin1_General_CI_AS 
            where DeliveryOrderDate between :tglawal and :tglakhir
            ";

            $this->db->query($query);
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {

                $pasing['Transaction_Code'] = $row['TransactionCode'];
                $pasing['DeliveryOrder_Date'] = $row['DeliveryOrderDate'];
                $pasing['User_Create'] = $row['UserCreate'];
                $pasing['Supplier_Code'] = $row['SupplierCode'];
                $pasing['Notes'] = $row['Notes'];
                $pasing['TotalQty_Delivery'] = $row['TotalQtyDelivery'];
                $pasing['Subtotal_Delivery'] = $row['SubtotalDelivery'];
                $pasing['Tax_Delivery'] = $row['TaxDelivery'];
                $pasing['GrandTotal_Delivery'] = $row['GrandtotalDelivery'];
                $pasing['PurchaseOrder_Code'] = $row['PurchaseOrderCode'];
                $pasing['TotalRowDO'] = $row['TotalRowDO'];
                $pasing['TotalQty_DO'] = $row['TotalQtyDO'];
                $pasing['Jenis_Delivery'] = $row['JenisDelivery'];
                $pasing['Nama_Supplier'] = $row['NamaSupplier'];
                $pasing['Nama_User'] = $row['NamaUser'];
                $pasing['Tanggal_Periode'] = $row['TglPeriode'];
                $pasing['Unit_Code'] = $row['UnitCode'];

                $rows[] = $pasing;
            }
            return $data;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
