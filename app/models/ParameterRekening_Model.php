<?php
use Ramsey\Uuid\Uuid;
class ParameterRekening_Model 
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function showAll()
    {
        try {
            $this->db->query("SELECT * from Keuangan.dbo.TZ_Parameter_Keu");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['id'] = $key['id'];
                $pasing['parameter'] = $key['parameter'];
                $pasing['rekening'] = $key['rekening'];
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
        try {
            $this->db->transaksi();

            if ($data['parameter'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Parameter!',
                );
                return $callback;
                exit;
            }
            if ($data['rekening'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Rekening !',
                );
                return $callback;
                exit;
            }

            $IdAuto = $data['IdAuto'];
            $parameter = $data['parameter'];
            $rekening = $data['rekening'];
            if ($data['IdAuto'] == "") {
                    $this->db->query("INSERT INTO Keuangan.dbo.TZ_Parameter_Keu (parameter,rekening) VALUES
                    (:parameter,:rekening)");
                      $this->db->bind('parameter', $parameter);
                      $this->db->bind('rekening', $rekening);
                    
            } else {
                    $this->db->query("UPDATE Keuangan.dbo.TZ_Parameter_Keu set  
                            parameter=:parameter,rekening=:rekening
                            WHERE ID=:IdAuto");
                      $this->db->bind('parameter', $parameter);
                      $this->db->bind('rekening', $rekening);
                     $this->db->bind('IdAuto', $IdAuto); 
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
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function getDatabyId($id)
    {
        try {
            $this->db->query("SELECT * 
                            from Keuangan.dbo.TZ_Parameter_Keu
                            WHERE id=:id");
            $this->db->bind('id', $id);
            $data =  $this->db->single();
            $pasing['id'] = $data['id']; 
            $pasing['parameter'] = $data['parameter'];
            $pasing['rekening'] = $data['rekening'];
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }

    }
}

