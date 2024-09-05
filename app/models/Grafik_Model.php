<?php


class Grafik_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function testGrafik()
    {
        try {
            $no = "1";
            $this->db->query("SELECT replace(CONVERT(VARCHAR(11),date_dMH, 111), '/','-') Date_DMH,
                            Total_MH,Cumm_MH from P_P_WBS_DPR");
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) { 
                $pasing['year'] = date('Y-m-d', strtotime($key['Date_DMH']));
                $pasing['value'] = $key['Total_MH'];
                $pasing['value2'] = $key['Cumm_MH'];
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}