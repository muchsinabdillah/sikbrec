<?php
class A_Master_Barang_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getBarangBySupplierId($data)
    {
        try {
            $active = '1';
            $PO_KodeSupplier = $data['PO_KodeSupplier'];
            $PO_JenisPurchase = $data['PO_JenisPurchase']; 
            $this->db->query("SELECT A.ID,A.[Product Name] as NamaBarang
                            from [Apotik_V1.1SQL].DBO.Products a
                            INNER JOIN [Apotik_V1.1SQL].DBO.Products_2 B
                            ON A.ID = B.IDBarang
                            WHERE B.IDSupplier=:PO_KodeSupplier AND A.Active=:active and a.Group_DK=:PO_JenisPurchase
                            and A.[Product Name] like  '%' + :searchTerm  + '%' ");
            $this->db->bind('active', $active);
            $this->db->bind('PO_KodeSupplier', $PO_KodeSupplier);
            $this->db->bind('PO_JenisPurchase', $PO_JenisPurchase);
            $this->db->bind('searchTerm',  $data['searchTerm']);
            $data =  $this->db->resultSet(); 
            foreach ($data as $key) {
                $pasing['id'] = $key['ID'];
                $pasing['text'] = $key['NamaBarang'];
                $data[] = $pasing;  
            }
            return $data;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function getBarangById($data)
    {
        try {
            $idBarang = $data['Po_SrcBarang'];
            $this->db->query("SELECT ID,[Product Name] AS NamaBarang,[Unit Satuan] as SatuanJual, Satuan_Beli,Konversi_satuan
                            FROM [Apotik_V1.1SQL].DBO.Products WHERE ID=:idBarang");
            $this->db->bind('idBarang', $idBarang);
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success',
                'ID' => $data['ID'],
                'NamaBarang' => $data['NamaBarang'],
                'Satuan_Beli' => $data['Satuan_Beli'],
                'SatuanJual' => $data['SatuanJual'],
            );
            return $callback;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
}
