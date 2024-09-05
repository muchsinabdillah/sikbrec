<?php
class A_Suppliers_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getSuppliers()
    {
        try {
            $this->db->query("SELECT ID,Company
                            FROM [Apotik_V1.1SQL].DBO.Suppliers ");
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $row) {
                $pasing['ID'] = $row['ID'];
                $pasing['Company'] = $row['Company']; 
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
}
