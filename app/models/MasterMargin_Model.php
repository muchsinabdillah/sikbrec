<?php


class MasterMargin_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function showDataObat($data)
    {
        try {
            $name = $data['NamaBarang'];
            $this->db->query("SELECT top 100 ID,[Product Name] as NamaBarang, 
                        CAST([Standard Cost] AS DECIMAL(18,2)) as HNA, 
                        CAST(HargaBeli AS DECIMAL(18,2)) as HargaNonPPN,
                        CAST([List Price] AS DECIMAL(18,2)) as HargaAfterPPN,
                        CAST([List Price RI] AS DECIMAL(18,2)) as hargaRanap,
                        CAST([list Price Resep]  AS DECIMAL(18,2)) as HargaRajal,
                        CAST([List Price Bebas] AS DECIMAL(18,2)) as HargaBebas,
                        HargaJamsostek,HargaKMG,
                        CAST(MarkupRI AS DECIMAL(18,2)) as MarginRI,
                        CAST([Markup Resep] AS DECIMAL(18,2))  as MarginRajal,
                        CAST([Markup bebas] AS DECIMAL(18,2))  as MarginBebas,
                            CAST(PPNIn AS DECIMAL(18,2))  as  PPNIn ,
                            CAST(PPNOut AS DECIMAL(18,2))  as PPNOut, 
                            CAST(Disc AS DECIMAL(18,2))  as Disc,
                            [Unit Satuan] as Satuan
                            FROM [Apotik_V1.1SQL].DBO.Products WHERE [Product Name] like '%$name%' "); 
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = "1";
            foreach ($data as $key) { 
                $pasing['NamaBarang'] = $key['NamaBarang'];
                $pasing['ID'] = $key['ID'];
                $pasing['HNA'] = $key['HNA'];
                $pasing['PPNIn'] = $key['PPNIn'];
                $pasing['HargaAfterPPN'] = $key['HargaAfterPPN'];
                $pasing['Disc'] = $key['Disc'];
                $pasing['HargaNonPPN'] = $key['HargaNonPPN'];
                $pasing['HNA'] = $key['HNA'];
                $pasing['HargaBebas'] = $key['HargaBebas'];
                $pasing['HargaRajal'] = $key['HargaRajal'];
                $pasing['hargaRanap'] = $key['hargaRanap'];
                $pasing['Satuan'] = $key['Satuan'];
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function showDataObatOutStanding()
    {
        try { 
            $this->db->query("SELECT  ID,[Product Name] as NamaBarang, 
                         CAST([Standard Cost] AS DECIMAL(18,2)) as HNA, 
                        CAST(HargaBeli AS DECIMAL(18,2)) as HargaNonPPN,
                        CAST([List Price] AS DECIMAL(18,2)) as HargaAfterPPN,
                        CAST([List Price RI] AS DECIMAL(18,2)) as hargaRanap,
                        CAST([list Price Resep]  AS DECIMAL(18,2)) as HargaRajal,
                        CAST([List Price Bebas] AS DECIMAL(18,2)) as HargaBebas,
                        HargaJamsostek,HargaKMG,
                        CAST(MarkupRI AS DECIMAL(18,2)) as MarginRI,
                        CAST([Markup Resep] AS DECIMAL(18,2))  as MarginRajal,
                        CAST([Markup bebas] AS DECIMAL(18,2))  as MarginBebas,
                            CAST(PPNIn AS DECIMAL(18,2))  as  PPNIn ,
                            CAST(PPNOut AS DECIMAL(18,2))  as PPNOut, 
                            CAST(Disc AS DECIMAL(18,2))  as Disc,
                            [Unit Satuan] as Satuan
                            FROM [Apotik_V1.1SQL].DBO.Products 	where MarkupRI is null or  [Markup bebas] is null or  [Markup Resep] is null");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = "1";
            foreach ($data as $key) {
                $pasing['NamaBarang'] = $key['NamaBarang'];
                $pasing['ID'] = $key['ID'];
                $pasing['HNA'] = $key['HNA'];
                $pasing['PPNIn'] = $key['PPNIn'];
                $pasing['HargaAfterPPN'] = $key['HargaAfterPPN'];
                $pasing['Disc'] = $key['Disc'];
                $pasing['HargaNonPPN'] = $key['HargaNonPPN'];
                $pasing['HNA'] = $key['HNA'];
                $pasing['HargaBebas'] = $key['HargaBebas'];
                $pasing['HargaRajal'] = $key['HargaRajal'];
                $pasing['hargaRanap'] = $key['hargaRanap'];
                $pasing['Satuan'] = $key['Satuan'];
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getMarginObatbyId($id)
    {

        try {
            $this->db->query("SELECT top 100 ID,[Product Name] as NamaBarang, 
                        CAST(isnull([Standard Cost],0) AS DECIMAL(18,0)) as HNA, 
                        CAST(isnull(HargaBeli,0) AS DECIMAL(18,0)) as HargaNonPPN,
                        CAST(isnull([List Price],0) AS DECIMAL(18,0)) as HargaAfterPPN,
                        CAST(isnull([List Price RI],0) AS DECIMAL(18,0)) as hargaRanap,
                        CAST(isnull([list Price Resep],0)  AS DECIMAL(18,0)) as HargaRajal,
                        CAST(isnull([List Price Bebas],0) AS DECIMAL(18,0)) as HargaBebas,
                        HargaJamsostek,HargaKMG,
                        CAST(isnull(MarkupRI,0) AS DECIMAL(18,2)) as MarginRI,
                        CAST(isnull([Markup Resep],0) AS DECIMAL(18,2)) as MarginRajal,
                        CAST(isnull([Markup bebas],0) AS DECIMAL(18,2)) as MarginBebas,
                            CAST(isnull(PPNIn,0) AS DECIMAL(18,2)) as PPNIn,PPNOut, isnull(Disc,0) as Disc,[Unit Satuan] as Satuan
                            FROM [Apotik_V1.1SQL].DBO.Products WHERE ID = :id");
            $this->db->bind('id', $id);
            $data =  $this->db->single();
            $pasing['ID'] = $data['ID'];
            $pasing['NamaBarang'] = $data['NamaBarang'];
            $pasing['HNA'] = $data['HNA'];
            $pasing['Satuan'] = $data['Satuan'];
            $pasing['HargaNonPPN'] = $data['HargaNonPPN'];
            $pasing['HargaAfterPPN'] = $data['HargaAfterPPN'];
            $pasing['PPNIn'] = $data['PPNIn'];
            $pasing['Disc'] = $data['Disc'];
            $pasing['HargaNonPPN'] = $data['HargaNonPPN'];

            $pasing['MarginRI'] = $data['MarginRI'];
            $pasing['MarginRajal'] = $data['MarginRajal'];
            $pasing['MarginBebas'] = $data['MarginBebas'];
            $pasing['hargaRanap'] = $data['hargaRanap'];
            $pasing['HargaBebas'] = $data['HargaBebas'];
            $pasing['HargaRajal'] = $data['HargaRajal'];
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function updatemargin($data)
    {
        try {
            $this->db->transaksi();
            if ($data['HargaJualRJProsen'] == "" || $data['HargaJualRJProsen'] == "0") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Masukan margin Rajal !',
                );
                return $callback;
                exit;
            }
            if ($data['HargaJualRIProsen'] == "" || $data['HargaJualRIProsen'] == "0") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Masukan Margin Ranap !',
                );
                return $callback;
                exit;
            }
            if ($data['HargaJualBebasProsen'] == "" || $data['HargaJualBebasProsen'] == "0") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Masukan Margin Bebas !',
                );
                return $callback;
                exit;
            }
            if ($data['HNA'] == "" || $data['HNA'] == "0") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Masukan Harga Netto Apotek !',
                );
                return $callback;
                exit;
            }
            if ($data['PPN'] == "" || $data['PPN'] == "0") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Masukan PPN !',
                );
                return $callback;
                exit;
            }
            if ($data['HNA_PPN'] == "" || $data['HNA_PPN'] == "0") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Masukan HNA + PPN !',
                );
                return $callback;
                exit;
            }
            if ($data['HargaNonPPN'] == "" || $data['HargaNonPPN'] == "0") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Masukan Harga Beli Non PPN !',
                );
                return $callback;
                exit;
            }
            $IdAuto = $data['IdAuto'];
            $HargaJualBebasProsen = $data['HargaJualBebasProsen'];
            $HargaJualRIProsen = $data['HargaJualRIProsen'];
            $HargaJualRJProsen = $data['HargaJualRJProsen'];
            $HargaJualRJ = $data['HargaJualRJ'];
            $HargaJualRI = $data['HargaJualRI'];
            $HargaJualBebas = $data['HargaJualBebas'];
            $HNA = $data['HNA'];
            $PPN = $data['PPN'];
            $HNA_PPN = $data['HNA_PPN'];
            $Discount = $data['Discount'];
            $HargaNonPPN = $data['HargaNonPPN'];
           
                $this->db->query("UPDATE [Apotik_V1.1SQL].dbo.Products set  
                            MarkupRI=:HargaJualRIProsen,
                            [Markup Resep]=:HargaJualRJProsen,
                            [Markup bebas]=:HargaJualBebasProsen, 
                            [List Price Resep]=:HargaJualRJ, 
                            [List Price RI]=:HargaJualRI, 
                            [List Price Bebas]=:HargaJualBebas,
                            [Standard Cost]=:HNA,
                            [PPNIn]=:PPN,
                            [List Price]=:HNA_PPN,
                            [Disc]=:Discount,
                            HargaBeli=:HargaNonPPN
                            WHERE ID=:IdAuto");
                $this->db->bind('HargaJualRIProsen', $HargaJualRIProsen);
                $this->db->bind('HargaJualRJProsen', $HargaJualRJProsen);
                $this->db->bind('HargaJualBebasProsen', $HargaJualBebasProsen);
                $this->db->bind('HargaJualRJ', $HargaJualRJ);
                $this->db->bind('HargaJualRI', $HargaJualRI);
                $this->db->bind('HargaJualBebas', $HargaJualBebas);
                $this->db->bind('IdAuto', $IdAuto);
                $this->db->bind('HNA', $HNA);
                $this->db->bind('PPN', $PPN);
                $this->db->bind('HNA_PPN', $HNA_PPN);
                $this->db->bind('Discount', $Discount);
                $this->db->bind('HargaNonPPN', $HargaNonPPN);
       
            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
}
