<?php


class Region_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getProvinsi($data)
    {
        try { 
            $this->db->query("SELECT ID,ProvinsiNama,PovinsiID from MstrProvinsi");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['ProvinsiNama'] = $key['ProvinsiNama'];
                $pasing['PovinsiID'] = $key['PovinsiID'];
                $rows[] = $pasing;
                $array['getProvinsi'] = $rows; 
            }
            return $array;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDepartment($data)
    {
        try {
            $this->db->query("SELECT *FROM GUT.dbo.HR_Mst_Departemen where status='1'");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['id'] = $key['Id_Departemen'];
                $pasing['Department'] = $key['Departemen'];
                $rows[] = $pasing;
                $array['dataDepartment'] = $rows; 
            }
            return $array;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getUnit($data)
    {
        try {
            $this->db->query("SELECT *FROM HR_Mst_Unit  where status='1'");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {
                $pasing['id'] = $row['Id_Unit'];
                $pasing['Unit'] = $row['Unit'];
                $rows[] = $pasing;
                $array['dataUnit'] = $rows; 
            }
            return $array;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getStatusNikah($data)
    {
        try {
            $this->db->query("SELECT *FROM HR_Mst_Status_Menikah");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {
                $pasing['id'] = $row['Id_Status_Menikah'];
                $pasing['Status_Menikah'] = $row['Status_Menikah'];
                $rows[] = $pasing;
                $array['dataMenikah'] = $rows; 
            }
            return $array;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getAgama($data)
    {
        try {
            $this->db->query("SELECT *FROM GUT.dbo.HR_Mst_Agama");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {
                $pasing['id'] = $row['Id_Agama'];
                $pasing['Agama'] = $row['Agama'];
                $rows[] = $pasing;
                $array['dataAgama'] = $rows; 
            }
            return $array;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getPendidikan($data)
    {
        try {
            $this->db->query("SELECT *FROM GUT.dbo.HR_Mst_Pendidikan");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {
                $pasing['id'] = $row['Id_Pendidikan'];
                $pasing['Pendidikan'] = $row['Pendidikan'];
                $rows[] = $pasing;
                $array['datapendidikan'] = $rows; 
            }
            return $array;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getStatusPegawai($data)
    {
        try {
            $this->db->query("SELECT Id_Status_Kerja,Status_Kerja FROM GUT.dbo.HR_Mst_Status_Kerja  where status='1'");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {
                $pasing['id'] = $row['Id_Status_Kerja'];
                $pasing['Status_Kerja'] = $row['Status_Kerja'];
                $rows[] = $pasing;
                $array['datastatuspegawai'] = $rows; 
            }
            return $array;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getJenisSP($data)
    {
        try {
            $this->db->query("SELECT [ID PERINGATAN] as idperingatan,[STATUS PERINGATAN] as statusperingatan
           FROM GUT.DBO.[HR_Mst_Status_Peringatan] ");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {
                $pasing['id'] = $row['idperingatan'];
                $pasing['statusperingatan'] = $row['statusperingatan'];
                $rows[] = $pasing;
                $array['datastatussp'] = $rows; 
            }
            return $array;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getLokasi($data)
    {
        try {
            $this->db->query("SELECT KD_LOKASI, NM_LOKASI,NM_CLIENT FROM P_M_LOKASI");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {
                $pasing['ID_Data'] = $row['KD_LOKASI'];
                $pasing['Nama'] = $row['NM_LOKASI'];
                $pasing['NM_CLIENT'] = $row['NM_CLIENT'];
                $rows[] = $pasing;
                $array['getpegawai'] = $rows; 
            }
            return $array;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getJabatan($data)
    {
        try {
            $this->db->query("SELECT ID_JF , Jabatan_Fungsional FROM GUT.dbo.HR_Mst_Jabatan  where status='1'");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {
                $pasing['id'] = $row['ID_JF'];
                $pasing['Jabatan_Fungsional'] = $row['Jabatan_Fungsional'];
                $rows[] = $pasing;
                $array['datajabatan'] = $rows; 
            }
            return $array;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getKabupatenByID($data)
    {
        try {
            $this->db->query("SELECT kabupatenId,kabupatenNama from MstrKabupaten where  provinsiId=:kode_prop");
            $this->db->bind('kode_prop',$data['kode_prop']);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {
                $pasing['kabupatenNama'] = $row['kabupatenNama'];
                $pasing['kabupatenId'] = $row['kabupatenId'];
                $rows[] = $pasing;
                $array['getKabupaten'] = $rows; 
            }
            return $array;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getKecamtanByID($data)
    {
        try {
            $this->db->query("SELECT kecamatanId,Kecamatan  from mstrKecamatan  where kabupatenId =:kode_prop");
            $this->db->bind('kode_prop', $data['kode_prop']);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {
                $pasing['Kecamatan'] = $row['Kecamatan'];
                $pasing['kecamatanId'] = $row['kecamatanId'];
                $rows[] = $pasing;
                $array['getKecamtan'] = $rows; 
            }
            return $array;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getKodepos($data)
    {
        try {
            $this->db->query("  SELECT kodepos,desaId
                                FROM mstrKelurahan  where desaId=:kode_prop");
            $this->db->bind('kode_prop', $data['kode_prop']);
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success',
                'kodepos' => $data['kodepos'],
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getKelurahanByID($data)
    {
        try {
            $this->db->query("SELECT desaId,kecamatanId,Kelurahan,kodepos
                            from mstrKelurahan  where kecamatanId=:kode_prop");
            $this->db->bind('kode_prop', $data['kode_prop']);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {
                $pasing['Kelurahan'] = $row['Kelurahan'];
                $pasing['desaId'] = $row['desaId'];
                $rows[] = $pasing;
                $array['getKelurahan'] = $rows; 
            }
            return $array;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    
}
