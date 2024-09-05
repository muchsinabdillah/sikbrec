<?php


class UnitKerja_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getAllUnitKerja()
    {
        try {
            $this->db->query("SELECT Id_Unit,Unit , 
                            CASE WHEN STATUS='1' THEN 'AKTIF' ELSE 'NO AKTIF' END AS STATUSDEPT
                            FROM HR_Mst_Unit");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['Id_Unit'] = $key['Id_Unit'];
                $pasing['Unit'] = $key['Unit'];
                $pasing['STATUSDEPT'] = $key['STATUSDEPT'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    // INSERT
    public function insert($data)
    {

        if ($data['StatusUnitKerja'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Status Unit Kerja !',
            );
            return $callback;
            exit;
        }
        if ($data['NamaUnitKerja'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Nama Unit Kerja !',
            );
            return $callback;
            exit;
        }
        try {
            $this->db->transaksi();
            if ($data['IdUnitKerja'] == "") {
                $this->db->query("INSERT INTO HR_Mst_Unit
                            (Unit,STATUS)
                          values
                          ( :NamaUnitKerja,:StatusUnitKerja)");
                $this->db->bind('NamaUnitKerja', $data['NamaUnitKerja']);
                $this->db->bind('StatusUnitKerja', $data['StatusUnitKerja']);
            } else {
                $this->db->query("UPDATE HR_Mst_Unit set  
                            Unit=:NamaUnitKerja,STATUS=:StatusUnitKerja 
                            WHERE Id_Unit=:IdUnitKerja");
                $this->db->bind('NamaUnitKerja', $data['NamaUnitKerja']);
                $this->db->bind('StatusUnitKerja', $data['StatusUnitKerja']);
                $this->db->bind('IdUnitKerja', $data['IdUnitKerja']);
            }
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
    public function getUnitKerjaId($id)
    {
        $this->db->query('SELECT Id_Unit,Unit,STATUS
                            FROM HR_Mst_Unit where Id_Unit =:id');
        $this->db->bind('id', $id);
        $data =  $this->db->single();
        $pasing['Id_Unit'] = $data['Id_Unit'];
        $pasing['Unit'] = $data['Unit'];
        $pasing['STATUS'] = $data['STATUS'];
        return $pasing;
    }
}
