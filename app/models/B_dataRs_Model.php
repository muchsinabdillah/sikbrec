<?php
class B_dataRs_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }


    //data list sesus filter
    public function GetDataRumahSakit($id)
    {
        // var_dump($id);
        // exit;
        try {
            $this->db->transaksi();

            $this->db->query("SELECT [ID]
            ,[NamaRS]
            ,[KodeRS]
            ,[KodeRSBPJS]
            ,[AlamatRS]
            ,[Website]
            ,[Phone]
            ,[Email]
            ,[Fax]
            ,[RT]
            ,[RW]
            ,[ProvinsiCode]
            ,[ProvinsiName]
            ,[KotaCode]
            ,[KotaName]
            ,[KecamtanCode]
            ,[KecamatanName]
            ,[KelurahanCode]
            ,[KelurahanName]
            ,[Kodepos]
            ,[Longitude]
            ,[Latitude]
        FROM MasterdataSQL.dbo.A_DATA_RS where ID=:id");
            $this->db->bind('id', $id);
            $data =  $this->db->single();
            // foreach ($data as $row) {
            $pasing['ID'] = $data['ID'];

            $pasing['NamaRS'] = $data['NamaRS'];
            $pasing['KodeRS'] = $data['KodeRS'];
            $pasing['alamat'] = $data['AlamatRS'];
            $pasing['RT'] = $data['RT'];
            $pasing['RW'] = $data['RW'];
            $pasing['ProvinsiCode'] = $data['ProvinsiCode'];
            $pasing['Medical_Provinsi'] = $data['ProvinsiName'];
            $pasing['KotaCode'] = $data['KotaCode'];
            $pasing['Medrec_kabupaten'] = $data['KotaName'];
            $pasing['KecamtanCode'] = $data['KecamtanCode'];
            $pasing['Medrec_Kecamatan'] = $data['KecamatanName'];
            $pasing['KelurahanCode'] = $data['KelurahanCode'];
            $pasing['Medrec_Kelurahan'] = $data['KelurahanName'];
            $pasing['Kd_Pos'] = $data['Kodepos'];
            $pasing['Longitude'] = $data['Longitude'];
            $pasing['Latitude'] = $data['Latitude'];
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
    public function getDataListRS()
    {
        try {
            $this->db->query("SELECT [ID]
            ,[NamaRS]
            ,[KodeRS]
            ,[KodeRSBPJS]
            ,[AlamatRS]
            ,[Website]
            ,[Phone]
            ,[Email]
            ,[Fax]
            ,[RT]
            ,[RW]
            ,[ProvinsiCode]
            ,[ProvinsiName]
            ,[KotaCode]
            ,[KotaName]
            ,[KecamtanCode]
            ,[KecamatanName]
            ,[KelurahanCode]
            ,[KelurahanName]
            ,[Kodepos]
            ,[Longitude]
            ,[Latitude]
        FROM MasterdataSQL.dbo.A_DATA_RS
            ");
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $row) {
                $pasing['ID'] = $row['ID'];
                $pasing['NamaRS'] = $row['NamaRS'];
                $pasing['AlamatRS'] = $row['AlamatRS'];
                $pasing['Phone'] = $row['Phone'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getProvinsi()
    {
        try {

            $this->db->query("SELECT ID,ProvinsiNama,PovinsiID from MasterdataSQL.dbo.MstrProvinsi");
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['ProvinsiNama'] = $key['ProvinsiNama'];
                $pasing['PovinsiID'] = $key['PovinsiID'];
                $rows[] = $pasing;
            }
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $rows
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
    public function GetKabupaten($data)
    {
        try {
            $idProvinsi = $data['q'];
            $this->db->query("SELECT kabupatenId,kabupatenNama from MasterdataSQL.dbo.MstrKabupaten 
                             where  provinsiId=:idProvinsi");
            $this->db->bind('idProvinsi', $idProvinsi);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['kabupatenNama'] = $key['kabupatenNama'];
                $pasing['kabupatenId'] = $key['kabupatenId'];
                $rows[] = $pasing;
            }
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $rows
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
    public function GetKecamatan($data)
    {
        try {
            $idKabupaten = $data['q'];
            $this->db->query("SELECT kecamatanId,Kecamatan  from MasterdataSQL.dbo.mstrKecamatan  
                            where kabupatenId =:idKabupaten");
            $this->db->bind('idKabupaten', $idKabupaten);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['Kecamatan'] = $key['Kecamatan'];
                $pasing['kecamatanId'] = $key['kecamatanId'];
                $rows[] = $pasing;
            }
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $rows
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
    public function GetKelurahan($data)
    {
        try {
            $idkecamatan = $data['q'];
            $this->db->query("SELECT desaId,kecamatanId,Kelurahan,kodepos
                            from MasterdataSQL.dbo.mstrKelurahan  where kecamatanId=:idkecamatan");
            $this->db->bind('idkecamatan', $idkecamatan);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['Kelurahan'] = $key['Kelurahan'];
                $pasing['desaId'] = $key['desaId'];
                $rows[] = $pasing;
            }
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $rows
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
    public function GetKodepos($data)
    {
        try {
            $idKelurahan = $data['q'];
            $this->db->query("SELECT kodepos,desaId
            from MasterdataSQL.dbo.mstrKelurahan  where desaId=:idKelurahan");
            $this->db->bind('idKelurahan', $idKelurahan);
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success',
                'kodepos' => $data['kodepos'],
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
