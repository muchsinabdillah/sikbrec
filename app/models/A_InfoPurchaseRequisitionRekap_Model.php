<?php
class A_InfoPurchaseRequisitionRekap_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getDataListInfoPurchaseRequisitionRekap($data)
    {
        try {
            $tglawal = $data['PeriodeAwal']; //(kanan view)
            $tglakhir = $data['PeriodeAkhir'];

            $query = "SELECT  TransactionCode,TransasctionDate,b.[First Name] User_create,TotalQty,TotalRow,Type,Unit,Approved
            ,UserApproved,DateApproved,Void,DateVoid,UserVoid,DateCreateReal,b.[First Name]UseCreateReal,ReffDateTrs,Notes
            FROM [Apotik_V1.1SQL].DBO.PurchaseRequisitions a
            inner join MasterdataSQL.dbo.Employees b
            on a.UserCreate collate  Latin1_General_CI_AS = b.NoPIN    collate  Latin1_General_CI_AS 
            where replace(CONVERT(VARCHAR(11), TransasctionDate, 111), '/','-') between :tglawal and :tglakhir and Void='0'";

            $this->db->query($query);
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {

                $pasing['Transaction_Code'] = $row['TransactionCode'];
                $pasing['Transaction_Date'] = $row['TransasctionDate'];
                $pasing['User_create'] = $row['User_create'];
                $pasing['Total_Qty'] = $row['TotalQty'];
                $pasing['Total_Row'] = $row['TotalRow'];
                $pasing['Type'] = $row['Type'];
                $pasing['Unit'] = $row['Unit'];
                $pasing['Approved'] = $row['Approved'];
                $pasing['User_Approved'] = $row['UserApproved'];
                $pasing['Date_Approved'] = $row['DateApproved'];
                $pasing['Void'] = $row['Void'];
                $pasing['Date_Void'] = $row['DateVoid'];
                $pasing['User_Void'] = $row['UserVoid'];
                $pasing['Date_Create_Real'] = $row['DateCreateReal'];
                $pasing['User_Create_Real'] = $row['UseCreateReal'];
                $pasing['Reff_Date_Trs'] = $row['ReffDateTrs'];
                $pasing['Notes'] = $row['Notes'];


                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDataListInfoPurchaseRequisitionRekap1($data)
    {
        try {
            $tglawal = $data['PeriodeAwal']; //(kanan view)
            $tglakhir = $data['PeriodeAkhir'];

            $query = "SELECT  TransactionCode,TransasctionDate,b.[First Name] User_create,TotalQty,TotalRow,Type,Unit,Approved
            ,UserApproved,DateApproved,Void,DateVoid,UserVoid,DateCreateReal,b.[First Name]UseCreateReal,ReffDateTrs,Notes
            FROM [Apotik_V1.1SQL].DBO.PurchaseRequisitions a
            inner join MasterdataSQL.dbo.Employees b
            on a.UserCreate collate  Latin1_General_CI_AS = b.NoPIN    collate  Latin1_General_CI_AS 
            where TransasctionDate between :tglawal and :tglakhir and Void='0'
            ";

            $this->db->query($query);
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {

                $pasing['Transaction_Code'] = $row['TransactionCode'];
                $pasing['Transaction_Date'] = $row['TransasctionDate'];
                $pasing['User_create'] = $row['User_create'];
                $pasing['Total_Qty'] = $row['TotalQty'];
                $pasing['Total_Row'] = $row['TotalRow'];
                $pasing['Type'] = $row['Type'];
                $pasing['Unit'] = $row['Unit'];
                $pasing['Approved'] = $row['Approved'];
                $pasing['User_Approved'] = $row['UserApproved'];
                $pasing['Date_Approved'] = $row['DateApproved'];
                $pasing['Void'] = $row['Void'];
                $pasing['Date_Void'] = $row['DateVoid'];
                $pasing['User_Void'] = $row['UserVoid'];
                $pasing['Date_Create_Real'] = $row['DateCreateReal'];
                $pasing['User_Create_Real'] = $row['UseCreateReal'];
                $pasing['Reff_Date_Trs'] = $row['ReffDateTrs'];
                $pasing['Notes'] = $row['Notes'];


                $rows[] = $pasing;
            }
            return $data;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
