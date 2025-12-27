<?php
class AA_Notification_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getOrderBHPRanap()
    {
        try {
            $this->db->query("SELECT top 1 id, idTransaction,TransactionType,Messages
                            FROM SysLog.DBO.z_Notif_Farmasi where TransactionType = 'CONSUMABLE' and PatientType='RI'  order by 1 desc ");
              $data =  $this->db->single();
              $rowData = $this->db->rowCount();
              
                $pasing['title'] ='Notifikasi Baru!';
                $pasing['rowData'] =$rowData;
                $pasing['message'] = $data['Messages']. ' No. Order : ' .$data['idTransaction']; 
                $rows[] = $pasing;
         
            
            $this->db->query("DELETE FROM SysLog.DBO.z_Notif_Farmasi WHERE ID = :id");
                    $this->db->bind('id', $data['id']); 
            $this->db->execute();
              return $rows;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        } 
    }
    public function getOrderBHPRajal()
    {
        try {
            $this->db->query("SELECT top 1 id, idTransaction,TransactionType,Messages
                            FROM SysLog.DBO.z_Notif_Farmasi where TransactionType = 'CONSUMABLE' and PatientType='RJ'  order by 1 desc ");
              $data =  $this->db->single();
              $rowData = $this->db->rowCount();
              
                $pasing['title'] ='Notifikasi Baru!';
                $pasing['rowData'] =$rowData;
                $pasing['message'] = $data['Messages']. ' No. Order : ' .$data['idTransaction']; 
                $rows[] = $pasing;
         
            
            $this->db->query("DELETE FROM SysLog.DBO.z_Notif_Farmasi WHERE ID = :id");
                    $this->db->bind('id', $data['id']); 
            $this->db->execute();
              return $rows;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        } 
    }

    public function getOrderResepRanap()
    {
        try {
            $this->db->query("SELECT top 1 id, idTransaction,TransactionType,Messages
                            FROM SysLog.DBO.z_Notif_Farmasi where TransactionType = 'RESEP' and PatientType='RI'  order by 1 desc ");
              $data =  $this->db->single();
              $rowData = $this->db->rowCount();
              
                $pasing['title'] ='Notifikasi Baru!';
                $pasing['rowData'] =$rowData;
                $pasing['message'] = $data['Messages']. ' No. Order : ' .$data['idTransaction']; 
                $rows[] = $pasing;
         
            
            $this->db->query("DELETE FROM SysLog.DBO.z_Notif_Farmasi WHERE ID = :id");
                    $this->db->bind('id', $data['id']); 
            $this->db->execute();
              return $rows;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        } 
    }
    public function getOrderResepRajal()
    {
        try {
            $this->db->query("SELECT top 1 id, idTransaction,TransactionType,Messages
                            FROM SysLog.DBO.z_Notif_Farmasi where TransactionType = 'SALES' and PatientType='RJ'  order by 1 desc ");
              $data =  $this->db->single();
              $rowData = $this->db->rowCount();
              
                $pasing['title'] ='Notifikasi Baru!';
                $pasing['rowData'] =$rowData;
                $pasing['message'] = $data['Messages']. ' No. Order : ' .$data['idTransaction']; 
                $rows[] = $pasing;
         
            
            $this->db->query("DELETE FROM SysLog.DBO.z_Notif_Farmasi WHERE ID = :id");
                    $this->db->bind('id', $data['id']); 
            $this->db->execute();
              return $rows;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        } 
    }
    public function getNotifKasirfromFarmasi()
    {
        try {
            $this->db->query("SELECT top 1 id, idTransaction,TransactionType,Messages
                            FROM SysLog.DBO.z_Notif_Kasir where TransactionType = 'SALES' and PatientType='RJ'  order by 1 desc ");
              $data =  $this->db->single();
              $rowData = $this->db->rowCount();
              
                $pasing['title'] ='Notifikasi Baru!';
                $pasing['rowData'] =$rowData;
                $pasing['message'] = $data['Messages']. ' No. Order : ' .$data['idTransaction']; 
                $rows[] = $pasing;
         
            
            $this->db->query("DELETE FROM SysLog.DBO.z_Notif_Farmasi WHERE ID = :id");
                    $this->db->bind('id', $data['id']); 
            $this->db->execute();
              return $rows;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        } 
    }
}