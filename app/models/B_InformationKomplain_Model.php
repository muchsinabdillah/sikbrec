<?php
class  B_InformationKomplain_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getDataListPasien($data)
    {
        try {
            $tglawal = $data['TglAwal'];
            $tglakhir = $data['TglAkhir'];

            $this->db->query("SELECT *,replace(CONVERT(VARCHAR(11), DateCreate, 111), '/','-')  as DateCreate,
            replace(CONVERT(VARCHAR(11), DateUpdate, 111), '/','-')  as DateUpdate 
            FROM PerawatanSQL.dbo.A_Complain
            WHERE replace(CONVERT(VARCHAR(11), DateCreate, 111), '/','-') Between :tglawal and :tglakhir
                ");
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $row) {
                $pasing['ID'] = $row['ID'];
                $pasing['Fullname'] = $row['Fullname'];
                $pasing['DateCreate'] = date('d/m/Y', strtotime($row['DateCreate']));
                $pasing['Email'] = $row['Email'];
                $pasing['NoHandphone'] = $row['NoHandphone'];
                $pasing['PatientStatus'] = $row['PatientStatus'];
                $pasing['Jenis'] = $row['Jenis'];
                $pasing['Place'] = $row['Place'];
                $pasing['Complain'] = $row['Complain'];
                $pasing['Status'] = $row['Status'];
                $pasing['UserUpdate'] = $row['UserUpdate'];
                $pasing['DateUpdate'] = date('d/m/Y', strtotime($row['DateUpdate']));
                $rows[] = $pasing;
            }
            return $data;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
