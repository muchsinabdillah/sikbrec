<?php
class B_Tarif_Mcu_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function lisTarifMcu()
    {
        $query = "SELECT IDMCU,NamaPaket,Pemeriksaan,Tarif,AwalMasaBerlaku,AkhirMasaBerlaku,Discontinue from PerawatanSQL.dbo.Tarif_MCU where Header=1 and Discontinue=0";
        $this->db->query($query);
        $this->db->execute();
        return $this->db->resultSet();
    }

    public function detailPaket($data)
    {
        $query = "SELECT *,replace(CONVERT(VARCHAR(11), AkhirMasaBerlaku, 111), '/','-') as AkhirMasaBerlaku1,
        replace(CONVERT(VARCHAR(11), AwalMasaBerlaku, 111), '/','-') as AwalMasaBerlaku1
        from PerawatanSQL.dbo.Tarif_MCU where NamaPaket=:namapaket and Header=0 and Discontinue=0";
        $this->db->query($query);
        $this->db->bind('namapaket', $data['namaPaket']);
        $this->db->execute();
        return $this->db->resultSet();
    }

    public function HeaderPaket($data)
    {
        $query = "SELECT *,replace(CONVERT(VARCHAR(11), AkhirMasaBerlaku, 111), '/','-') as AkhirMasaBerlaku1,
        replace(CONVERT(VARCHAR(11), AwalMasaBerlaku, 111), '/','-') as AwalMasaBerlaku1
        from PerawatanSQL.dbo.Tarif_MCU where NamaPaket=:namapaket and Header=1";
        $this->db->query($query);
        $this->db->bind('namapaket', $data);
        $this->db->execute();
        return $this->db->single();
    }

    public function Input()
    {
    }

    public function getDataLaboratorium()
    {
        $query = "SELECT * from LaboratoriumSQL.dbo.tblGrouping where Discontinue=0";
        $this->db->query($query);
        $this->db->execute();
        return $this->db->resultSet();
    }
    public function getRadiologi()
    {
        $query = "SELECT * from RadiologiSQL.dbo.ProcedureRadiology where Discontinue=0";
        $this->db->query($query);
        $this->db->execute();
        return $this->db->resultSet();
    }

    public function getKodeJasa()
    {
        $query = "SELECT * from Keuangan.dbo.BO_M_JASA";
        $this->db->query($query);
        $this->db->execute();
        return $this->db->resultSet();
    }

    public function getPemeriksaanMCU()
    {
        $query = "SELECT * from PerawatanSQL.dbo.MstrPemeriksaanMCU";
        $this->db->query($query);
        $this->db->execute();
        return $this->db->resultSet();
    }
    public function inputHeader($data)
    {
        // var_dump($data);
        $pattern = "/[^0-9]/";
        $query = "INSERT INTO [PerawatanSQL].[dbo].[Tarif_MCU]
        (
            [NamaPaket]
        -- ,[LokasiPemeriksaan]
        ,[Tarif]
        ,[Header]
        ,[Discontinue]
        ,[AwalMasaBerlaku]
        ,[AkhirMasaBerlaku]
        ,[EKG]
        ,[Treadmill]
        ,[Spirometri]
        -- ,[ShowJasa]
        -- ,[KD_JASA]
        )
  VALUES
        (
        :NamaPaket
        -- ,:LokasiPemeriksaan
        ,:Tarif
        ,:Header
        ,:Discontinue
        ,:AwalMasaBerlaku
        ,:AkhirMasaBerlaku
        ,:EKG
        ,:Treadmill
        ,:Spirometri
        -- ,:ShowJasa
        -- ,:KD_JASA
        )";
        $this->db->query($query);
        $this->db->bind('NamaPaket', $data['namapaket']);
        // $this->db->bind('LokasiPemeriksaan', $data['']);
        $this->db->bind('Tarif',  preg_replace($pattern, '', $data['tarif']));
        $this->db->bind('Header', $data['header']);
        $this->db->bind('Discontinue', (isset($data['discontinue'])) ? $data['discontinue'] : 0);
        $this->db->bind('AwalMasaBerlaku', $data['tglberlaku']);
        $this->db->bind('AkhirMasaBerlaku', $data['sampaidengan']);
        $this->db->bind('EKG', (isset($data['ekg'])) ? $data['ekg'] : 0);
        $this->db->bind('Treadmill', (isset($data['treadmil'])) ? $data['treadmil'] : 0);
        $this->db->bind('Spirometri', (isset($data['spirometri'])) ? $data['spirometri'] : 0);
        $this->db->execute();
        // $this->db->bind('ShowJasa', $data['']);
        // $this->db->bind('KD_JASA', $data['']);
    }
    public function insertitemmcu($data, $dataheader)
    {
        $pattern = "/[^0-9]/";
        $query = "INSERT INTO [PerawatanSQL].[dbo].[Tarif_MCU]
        (
        
        [NamaPaket]
        ,[IdTes]
        ,[Pemeriksaan]
        ,[Keterangan]
        ,[LokasiPemeriksaan]
        ,[Tarif]
        ,[Header]
        ,[Discontinue]
        -- ,[AwalMasaBerlaku]
        -- ,[AkhirMasaBerlaku]
        ,[EKG]
        ,[Treadmill]
        ,[Spirometri]
        ,[ShowJasa]
        ,[KD_JASA]
        ,[KD_PDP]
        ,[Group_Spesialis]
        )
  VALUES
        (
        :NamaPaket
        ,:IdTes
        ,:Pemeriksaan
        ,:Keterangan
        ,:LokasiPemeriksaan
        ,:Tarif
        ,:Header
        ,:Discontinue
        -- ,:AwalMasaBerlaku
        -- ,:AkhirMasaBerlaku
        ,:EKG
        ,:Treadmill
        ,:Spirometri
        ,:ShowJasa
        ,:KD_JASA
        ,:KD_PDP
        ,:Group_Spesialis
        )";
        $this->db->query($query);
        $this->db->bind('NamaPaket', $dataheader['namapaket']);
        $this->db->bind('IdTes', $data['idtest']);
        $this->db->bind('Pemeriksaan', $data['namapemeriksaan']);
        $this->db->bind('Keterangan', $data['pemeriksaanpenunjang']);
        $this->db->bind('LokasiPemeriksaan', $data['lokasipemeriksaan']);
        $this->db->bind('Tarif', preg_replace($pattern, '', $data['tarifitem']));
        $this->db->bind('Header', 0);
        $this->db->bind('Discontinue', 0);
        // $this->db->bind('AwalMasaBerlaku', $data['']);
        // $this->db->bind('AkhirMasaBerlaku', $data['']);
        $this->db->bind('EKG', 0);
        $this->db->bind('Treadmill', 0);
        $this->db->bind('Spirometri', 0);
        $this->db->bind('ShowJasa', $data['showjasa']);
        $this->db->bind('KD_JASA', $data['kodejasa']);
        $this->db->bind('KD_PDP', $data['kodependapatan']);
        $this->db->bind('Group_Spesialis', $data['Group_Spesialis']);
        $this->db->execute();
    }
    public function saveTarifMcu($data)
    {

        try {
            $this->db->transaksi();
            // cek jika nama paket sama 
            $this->inputHeader($data);
            foreach ($data['dataitemtarif'] as $item) {
                $this->insertitemmcu($item, $data);
            }
            $this->db->Commit();
            return $calback = [
                'status' => 200,
                'message' => 'success'

            ];
        } catch (PDOException $e) {
            $this->db->rollback();
            return $e;
        }
    }
    // update data item mcu
    public function update($data)
    {
        $pattern = "/[^0-9]/";
        // var_dump($data);
        $query = "UPDATE [PerawatanSQL].[dbo].[Tarif_MCU]
                SET [Discontinue] =:Discontinue 

              WHERE IDMCU=:IDMCU";

        $queryupdate = "UPDATE [PerawatanSQL].[dbo].[Tarif_MCU]
            SET [NamaPaket] =:NamaPaket
               ,[IdTes] =:IdTes
               ,[Pemeriksaan] =:Pemeriksaan 
               ,[Keterangan] =:Keterangan 
               ,[LokasiPemeriksaan] =:LokasiPemeriksaan 
               ,[Tarif] =:Tarif 
               ,[ShowJasa] =:ShowJasa 
               ,[KD_JASA] =:KD_JASA 
               ,[KD_PDP] =:KD_PDP 
               ,[Group_Spesialis] =:Group_Spesialis 
          WHERE IDMCU =:IDMCU";

        try {
            $this->db->transaksi();
            $this->updateHeader($data);
            foreach ($data['dataitemtarif'] as $item) {
                // flag discontinue 1
                if (isset($item['discontinue']) && $item['discontinue'] == 1) {
                    $this->db->query($query);
                    $this->db->bind('Discontinue', $item['discontinue']);
                    $this->db->bind('IDMCU', $item['iditemmcu']);
                    $this->db->execute();
                } else if (ctype_alpha($item['iditemmcu'])) {
                    $this->insertitemmcu($item, $data);
                } else {
                    $this->db->query($queryupdate);
                    $this->db->bind('NamaPaket', $data['namapaket']);
                    $this->db->bind('IdTes', $item['idtest'] == "null" ? '' : $item['idtest']);
                    $this->db->bind('Pemeriksaan', $item['namapemeriksaan']);
                    $this->db->bind('Keterangan', $item['pemeriksaanpenunjang']);
                    $this->db->bind('LokasiPemeriksaan', $item['lokasipemeriksaan']);
                    $this->db->bind('Tarif', $this->nulKonfersi(preg_replace($pattern, '', $item['tarifitem'])));
                    $this->db->bind('ShowJasa', $item['showjasa']);
                    $this->db->bind('KD_JASA', $item['kodejasa']);
                    $this->db->bind('KD_PDP', $item['kodependapatan']);
                    $this->db->bind('IDMCU', $item['iditemmcu']);
                    $this->db->bind('Group_Spesialis', $item['Group_Spesialis']);
                    $this->db->execute();
                }
            }
            $this->db->Commit();
            return $calback = [
                'status' => 200,
                'message' => 'success'

            ];
        } catch (PDOException $e) {
            $this->db->rollback();
            return $e;
        }
    }
    // update header
    public function updateHeader($data)
    {
        $pattern = "/[^0-9]/";

        $query = "UPDATE [PerawatanSQL].[dbo].[Tarif_MCU]
        SET 
           [NamaPaket] =:NamaPaket
           ,[Tarif] =:Tarif
           ,[Header] =:Header
           ,[Discontinue] =:Discontinue
           ,[AwalMasaBerlaku] =:AwalMasaBerlaku
           ,[AkhirMasaBerlaku] =:AkhirMasaBerlaku
           ,[EKG] =:EKG
           ,[Treadmill] =:Treadmill
           ,[Spirometri] =:Spirometri
           
      WHERE IDMCU=:IDMCU";
        $this->db->query($query);
        $this->db->bind('IDMCU', $data["idheader"]);
        $this->db->bind('NamaPaket', $data["namapaket"]);
        $this->db->bind('AwalMasaBerlaku', $data["tglberlaku"]);
        $this->db->bind('AkhirMasaBerlaku', $data["sampaidengan"]);
        $this->db->bind('Tarif', preg_replace($pattern, '', $data["tarif"]));
        $this->db->bind('Header', $data["header"]);
        $this->db->bind('EKG', $data["ekg"]);
        $this->db->bind('Discontinue', $data["discontinue"]);
        $this->db->bind('Treadmill', $data["treadmil"]);
        $this->db->bind('Spirometri', $data["spirometri"]);
        $this->db->execute();
    }

    public function getHeaderByName($data)
    {
        $query = "select * from PerawatanSQL.dbo.Tarif_MCU where  Header=1 and NamaPaket=:namapaket";
        $this->db->query($query);
        $this->db->bind('namapaket', $data['namapaket']);
        $this->db->execute();
        if ($this->db->single()) {
            return $calback = [
                'status' => 200,
                'message' => 'success'
            ];
        } else {
            return $calback = [
                'status' => 201,
                'message' => 'success'
            ];
        }
    }
    // kode pendapatan 
    public function getKodependapatan()
    {
        $query = "SELECT * from Keuangan.dbo.BO_M_PDP";
        $this->db->query($query);
        $this->db->execute();
        return $this->db->resultSet();
    }

    public function nulKonfersi($data)
    {
        if ($data == null) {
            return 0;
        }
    }
}
