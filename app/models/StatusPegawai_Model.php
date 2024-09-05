<?php


class StatusPegawai_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getAllStatusPegawai()
    {
        try {
            $this->db->query("SELECT Id_Status_Kerja,Status_Kerja , 
                                CASE WHEN STATUS='1' THEN 'AKTIF' ELSE 'NO AKTIF' END AS STATUSDEPT
                                FROM HR_Mst_Status_Kerja");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['Id_Status_Kerja'] = $key['Id_Status_Kerja'];
                $pasing['Status_Kerja'] = $key['Status_Kerja'];
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

        if ($data['StatusPegawai'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Status Pegawai !',
            );
            return $callback;
            exit;
        }
        if ($data['NamaStatusPegawai'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Nama Status Pegawai !',
            );
            return $callback;
            exit;
        }
        try {
            $this->db->transaksi();
            if ($data['IdStatusPegawai'] == "") {
                $this->db->query("INSERT INTO HR_Mst_Status_Kerja
                            (Status_Kerja,STATUS)
                          values
                          ( :NamaStatusPegawai,:StatusPegawai)");
                $this->db->bind('NamaStatusPegawai', $data['NamaStatusPegawai']);
                $this->db->bind('StatusPegawai', $data['StatusPegawai']);
            } else {
                $this->db->query("UPDATE HR_Mst_Status_Kerja set  
                            Status_Kerja=:NamaStatusPegawai,STATUS=:StatusPegawai 
                            WHERE Id_Status_Kerja=:IdStatusPegawai");
                $this->db->bind('NamaStatusPegawai', $data['NamaStatusPegawai']);
                $this->db->bind('StatusPegawai', $data['StatusPegawai']);
                $this->db->bind('IdStatusPegawai', $data['IdStatusPegawai']);
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
    public function getStatusPegawaiId($id)
    {
        $this->db->query('SELECT Id_Status_Kerja,Status_Kerja , STATUS
                        FROM HR_Mst_Status_Kerja where Id_Status_Kerja =:id');
        $this->db->bind('id', $id);
        $data =  $this->db->single();
        $pasing['Id_Status_Kerja'] = $data['Id_Status_Kerja'];
        $pasing['Status_Kerja'] = $data['Status_Kerja'];
        $pasing['STATUS'] = $data['STATUS'];
        return $pasing;
    }
}
