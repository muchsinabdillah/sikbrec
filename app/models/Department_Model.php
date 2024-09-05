<?php


class Department_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getAllDepartment()
    {
        try {
            $this->db->query("SELECT Id_Departemen,Departemen , 
                            CASE WHEN STATUS='1' THEN 'AKTIF' ELSE 'NO AKTIF' END AS STATUSDEPT
                            FROM HR_Mst_Departemen"); 
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['Id_Departemen'] = $key['Id_Departemen'];
                $pasing['Departemen'] = $key['Departemen'];
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

        if ($data['StatusDepartment'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Status Department !',
            );
            return $callback;
            exit;
        }
        if ($data['NamaDepartment'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Nama Department !',
            );
            return $callback;
            exit;
        } 
        try {
            $this->db->transaksi();
            if ($data['IdDepartment'] == "") {
                $this->db->query("INSERT INTO HR_Mst_Departemen
                            (Departemen,STATUS)
                          values
                          ( :NamaDepartment,:StatusDepartment)");
                $this->db->bind('NamaDepartment', $data['NamaDepartment']);
                $this->db->bind('StatusDepartment', $data['StatusDepartment']); 
            } else {
                $this->db->query("UPDATE HR_Mst_Departemen set  
                            Departemen=:NamaDepartment,STATUS=:StatusDepartment 
                            WHERE Id_Departemen=:IdDepartment");
                $this->db->bind('NamaDepartment', $data['NamaDepartment']);
                $this->db->bind('StatusDepartment', $data['StatusDepartment']);
                $this->db->bind('IdDepartment', $data['IdDepartment']); 
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
    public function getDepartmentId($id)
    {
        $this->db->query('SELECT Id_Departemen,Departemen, STATUS 
                        FROM HR_Mst_Departemen where Id_Departemen =:id');
        $this->db->bind('id', $id);
        $data =  $this->db->single();
        $pasing['Id_Departemen'] = $data['Id_Departemen'];
        $pasing['Departemen'] = $data['Departemen'];
        $pasing['STATUS'] = $data['STATUS']; 
        return $pasing;
    }
}