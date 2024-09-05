<?php


class Jabatan_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getAllJabatan()
    {
        try {
            $this->db->query("SELECT Id_JF,Jabatan_Fungsional , 
                            CASE WHEN STATUS='1' THEN 'AKTIF' ELSE 'NO AKTIF' END AS STATUSDEPT
                            FROM HR_Mst_Jabatan");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['Id_JF'] = $key['Id_JF'];
                $pasing['Jabatan_Fungsional'] = $key['Jabatan_Fungsional'];
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

        if ($data['StatusJabatan'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Status Jabatan !',
            );
            return $callback;
            exit;
        }
        if ($data['NamaJabatan'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Nama Jabatan !',
            );
            return $callback;
            exit;
        }
        try {
            $this->db->transaksi();
            if ($data['IdJabatan'] == "") {
                $this->db->query("INSERT INTO HR_Mst_Jabatan
                            (Jabatan_Fungsional,STATUS)
                          values
                          ( :NamaJabatan,:StatusJabatan)");
                $this->db->bind('NamaJabatan', $data['NamaJabatan']);
                $this->db->bind('StatusJabatan', $data['StatusJabatan']);
            } else {
                $this->db->query("UPDATE HR_Mst_Jabatan set  
                            Jabatan_Fungsional=:NamaJabatan,STATUS=:StatusJabatan 
                            WHERE Id_JF=:IdJabatan");
                $this->db->bind('NamaJabatan', $data['NamaJabatan']);
                $this->db->bind('StatusJabatan', $data['StatusJabatan']);
                $this->db->bind('IdJabatan', $data['IdJabatan']);
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
    public function getJabatanId($id)
    {
        $this->db->query('SELECT Id_JF,Jabatan_Fungsional, STATUS 
                        FROM HR_Mst_Jabatan where Id_JF =:id');
        $this->db->bind('id', $id);
        $data =  $this->db->single();
        $pasing['Id_JF'] = $data['Id_JF'];
        $pasing['Jabatan_Fungsional'] = $data['Jabatan_Fungsional'];
        $pasing['STATUS'] = $data['STATUS'];
        return $pasing;
    }
}
