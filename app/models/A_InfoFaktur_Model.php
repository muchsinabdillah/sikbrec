<?php

class A_InfoFaktur_Model
{
    private $db;
    use ApiRsyarsi;


    public function __construct()
    {
        $this->db = new Database;
    }
    public function getDataListInfoFaktur($data)
    {
        try {

            $TglAwal = $data['TglAwal'];
            $TglAkhir = $data['TglAkhir'];
            // var_dump($TglAwal, $TglAkhir, $optJenisInfo);
            // exit;
            $this->db->query("SELECT TransactionCode, TransactionDate, TglJatuhTempo, PurchaseOrderCode, DeliveryCode, c.Company ,b.NamaUnit, NoFakturPajak, NoFakturPBF, 
            NoRekeningSupplier, NamaNBank, DateFakturPBF, Keterangan,
            TotalNilaiFaktur, TotalDiskon, TotalTax, Subtotal, DiskonLain, BiayaLain, Pph23,Grandtotal
            FROM [Apotik_V1.1SQL].dbo.v_info_trs_faktur a
            inner join MasterdataSQL.dbo.MstrUnitPerwatan b on a.UnitPembelian = b.ID
            inner join [Apotik_V1.1SQL].dbo.Suppliers c on a.SupplierCode = c.ID
                where replace(CONVERT(VARCHAR(11), TransactionDate, 111), '/','-') between :TglAwal and :TglAkhir
                UNION ALL
                SELECT TransactionCode, TransactionDate, TglJatuhTempo, PurchaseOrderCode, DeliveryCode, c.Company, b.NamaUnit, 
            NoFakturPajak, NoFakturPBF, NoRekeningSupplier, NamaNBank, DateFakturPBF, Keterangan,
            TotalNilaiFaktur, TotalDiskon, TotalTax, Subtotal, DiskonLain, BiayaLain, Pph23,Grandtotal
            FROM [Apotik_V1.1SQL].DBO.v_info_trs_faktur_manual a
            inner join MasterdataSQL.dbo.MstrUnitPerwatan b on a.UnitPembelian = b.ID
            inner join [Apotik_V1.1SQL].dbo.Suppliers c on a.SupplierCode = c.ID
                where replace(CONVERT(VARCHAR(11), TransactionDate, 111), '/','-') between :TglAwal2 and :TglAkhir2");
            $this->db->bind('TglAwal', $TglAwal);
            $this->db->bind('TglAwal2', $TglAwal);

            $this->db->bind('TglAkhir', $TglAkhir);
            $this->db->bind('TglAkhir2', $TglAkhir);

            $data =  $this->db->resultSet();

            $rows = array();
            $no = 1;

            foreach ($data as $row) {
                $pasing['no'] = $no++;
                $pasing['TransactionCode'] = $row['TransactionCode'];
                $pasing['TransactionDate'] = $row['TransactionDate'];
                $pasing['TglJatuhTempo'] = $row['TglJatuhTempo'];
                $pasing['PurchaseOrderCode'] = $row['PurchaseOrderCode'];
                $pasing['DeliveryCode'] = $row['DeliveryCode'];
                $pasing['Company'] = $row['Company'];
                $pasing['NamaUnit'] = $row['NamaUnit'];
                $pasing['NoFakturPajak'] = $row['NoFakturPajak'];
                $pasing['NoFakturPBF'] = $row['NoFakturPBF'];
                $pasing['NoRekeningSupplier'] = $row['NoRekeningSupplier'];
                $pasing['NamaNBank'] = $row['NamaNBank'];
                $pasing['DateFakturPBF'] = $row['DateFakturPBF'];
                $pasing['Keterangan'] = $row['Keterangan'];
                $pasing['TotalNilaiFaktur'] = $row['TotalNilaiFaktur'];
                $pasing['TotalDiskon'] = $row['TotalDiskon'];
                $pasing['TotalTax'] = $row['TotalTax'];
                $pasing['Subtotal'] = $row['Subtotal'];
                $pasing['DiskonLain'] = $row['DiskonLain'];
                $pasing['BiayaLain'] = $row['BiayaLain'];
                $pasing['Pph23'] = $row['Pph23'];
                $pasing['Grandtotal'] = $row['Grandtotal'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDataListInfoFaktur1($data)
    {
        try {

            $TglAwal = $data['TglAwal'];
            $TglAkhir = $data['TglAkhir'];
            // var_dump($TglAwal, $TglAkhir, $optJenisInfo);
            // exit;
            $this->db->query("SELECT TransactionCode, TransactionDate, TglJatuhTempo, PurchaseOrderCode, DeliveryCode, c.Company ,b.NamaUnit, NoFakturPajak, NoFakturPBF, 
            NoRekeningSupplier, NamaNBank, DateFakturPBF, Keterangan,
            TotalNilaiFaktur, TotalDiskon, TotalTax, Subtotal, DiskonLain, BiayaLain, Pph23
            FROM [Apotik_V1.1SQL].dbo.v_info_trs_faktur a
            inner join MasterdataSQL.dbo.MstrUnitPerwatan b on a.UnitPembelian = b.ID
            inner join [Apotik_V1.1SQL].dbo.Suppliers c on a.SupplierCode = c.ID
                where replace(CONVERT(VARCHAR(11), TransactionDate, 111), '/','-') between :TglAwal and :TglAkhir
                UNION ALL
                SELECT TransactionCode, TransactionDate, TglJatuhTempo, PurchaseOrderCode, DeliveryCode, c.Company, b.NamaUnit, 
            NoFakturPajak, NoFakturPBF, NoRekeningSupplier, NamaNBank, DateFakturPBF, Keterangan,
            TotalNilaiFaktur, TotalDiskon, TotalTax, Subtotal, DiskonLain, BiayaLain, Pph23
            FROM [Apotik_V1.1SQL].DBO.v_info_trs_faktur_manual a
            inner join MasterdataSQL.dbo.MstrUnitPerwatan b on a.UnitPembelian = b.ID
            inner join [Apotik_V1.1SQL].dbo.Suppliers c on a.SupplierCode = c.ID
                where replace(CONVERT(VARCHAR(11), TransactionDate, 111), '/','-') between :TglAwal2 and :TglAkhir2");
            $this->db->bind('TglAwal', $TglAwal);
            $this->db->bind('TglAwal2', $TglAwal);

            $this->db->bind('TglAkhir', $TglAkhir);
            $this->db->bind('TglAkhir2', $TglAkhir);

            $data =  $this->db->resultSet();

            $rows = array();
            $no = 1;

            foreach ($data as $row) {
                $pasing['no'] = $no++;
                $pasing['TransactionCode'] = $row['TransactionCode'];
                $pasing['TransactionDate'] = $row['TransactionDate'];
                $pasing['TglJatuhTempo'] = $row['TglJatuhTempo'];
                $pasing['PurchaseOrderCode'] = $row['PurchaseOrderCode'];
                $pasing['DeliveryCode'] = $row['DeliveryCode'];
                $pasing['Company'] = $row['Company'];
                $pasing['NamaUnit'] = $row['NamaUnit'];
                $pasing['NoFakturPajak'] = $row['NoFakturPajak'];
                $pasing['NoFakturPBF'] = $row['NoFakturPBF'];
                $pasing['NoRekeningSupplier'] = $row['NoRekeningSupplier'];
                $pasing['NamaNBank'] = $row['NamaNBank'];
                $pasing['DateFakturPBF'] = $row['DateFakturPBF'];
                $pasing['Keterangan'] = $row['Keterangan'];
                $pasing['TotalNilaiFaktur'] = $row['TotalNilaiFaktur'];
                $pasing['TotalDiskon'] = $row['TotalDiskon'];
                $pasing['TotalTax'] = $row['TotalTax'];
                $pasing['Subtotal'] = $row['Subtotal'];
                $pasing['DiskonLain'] = $row['DiskonLain'];
                $pasing['BiayaLain'] = $row['BiayaLain'];
                $pasing['Pph23'] = $row['Pph23'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
