<?php
class MasterDataMenu_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getAllDataMenu()
    {
        try {
            $this->db->query("SELECT id_menu,nama_menu,icon 
                            FROM MasterdataSQL.DBO.A_MENU_USER_V2");
            $data =  $this->db->resultSet();
            $this->db->closeCon();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['id_menu'];
                $pasing['nama_menu'] = $key['nama_menu'];
                $pasing['icon'] = $key['icon']; 
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            $this->db->closeCon();
            die($e->getMessage());
        }
    }
    // INSERT
    public function insert($data)
    {
        try {
            $this->db->transaksi();

            if ($data['NamaMenu'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Nama Menu !',
                );
                return $callback;
                exit;
            }
             

            $IdAuto = $data['IdAuto'];
            $NamaMenu = $data['NamaMenu'];
            $Icon = $data['Icon']; 

            if ($data['IdAuto'] == "") {

                $this->db->query("INSERT INTO MasterdataSQL.DBO.A_MENU_USER_V2 (nama_menu,icon) VALUES
                                (:nama_menu,:icon)");
                $this->db->bind('nama_menu', $NamaMenu);
                $this->db->bind('icon', $Icon); 
            } else {
                $this->db->query("UPDATE MasterdataSQL.dbo.A_MENU_USER_V2 set  
                            nama_menu=:nama_menu,icon=:icon 
                            WHERE id_menu=:IdAuto");
                $this->db->bind('nama_menu', $NamaMenu);
                $this->db->bind('icon', $Icon); 
                $this->db->bind('IdAuto', $IdAuto);
            }
            $this->db->execute();
            $this->db->commit();
            $this->db->closeCon();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function getMenuId($id)
    {
        try {

            $this->db->query("SELECT id_menu,nama_menu,icon FROM MasterdataSQL.DBO.A_MENU_USER_V2
                            WHERE id_menu=:id");
            $this->db->bind('id', $id);
            $data =  $this->db->single();
            $this->db->closeCon();
            $pasing['ID'] = $data['id_menu'];
            $pasing['nama_menu'] = $data['nama_menu'];
            $pasing['icon'] = $data['icon']; 
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function GetLayananPoliklinik()
    {
        try {
            $this->db->query("SELECT ID,NamaUnit
                            from MasterdataSQL.dbo.MstrUnitPerwatan
                            where rajal='1'");
            $data =  $this->db->resultSet();
            $this->db->closeCon();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['NamaUnit'] = $key['NamaUnit'];
                $rows[] = $pasing;
            }
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $rows
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function GetLayananPoliPenunjangIgd()
    {
        try {
            $wherewalkin = "";
            if (isset($_POST['iswalkin'])) {
                $iswalkin = $_POST['iswalkin'];
                if ($iswalkin == 'WALKIN') {
                    $wherewalkin = "AND ID='9'";
                }
            }
            $this->db->query("SELECT ID, NamaUnit
                                  from MasterdataSQL.dbo.MstrUnitPerwatan 
                                  where grup_instalasi in ('PENUNJANG','IGD','RAWAT JALAN') $wherewalkin Order by NamaUnit");
            $data =  $this->db->resultSet();
            $this->db->closeCon();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['NamaUnit'] = $key['NamaUnit'];
                $rows[] = $pasing;
            }
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $rows
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function GetLayananAll()
    {
        try {

            $this->db->query("SELECT ID, NamaUnit
                                  from MasterdataSQL.dbo.MstrUnitPerwatan Order by NamaUnit asc");
            $data =  $this->db->resultSet();
            $this->db->closeCon();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['NamaUnit'] = $key['NamaUnit'];
                $rows[] = $pasing;
            }
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $rows
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
}
