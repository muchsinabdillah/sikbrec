<?php


class GroupShift_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    } 
    
    // INSERT
    public function insert($data)
    {

        if ($data['Mst_KodeGroupShift'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Kode Group Shift !',
            );
            return $callback;
            exit;
        }
        if ($data['Mst_NamaGroupShift'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Nama Group Shift !',
            );
            return $callback;
            exit;
        }
        if ($data['Mst_ValueGroupShift'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Value !',
            );
            return $callback;
            exit;
        }

        if ($data['Mst_ValuehariGroup'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input hari Value !',
            );
            return $callback;
            exit;
        } 
        try {
            $this->db->transaksi();
            if ($data['IdTranasksi'] == "") {
                $this->db->query("INSERT INTO HR_Mst_MASTER_SHIFT_GROUP
                            (KODE_GROUP_SHIFT,NAMA_GROUP_SHIFT,NILAI,KELAS_1,KELAS_2,KELAS_3,KELAS_4,Nilai_hari)
                          values
                          ( :Mst_KodeGroupShift,:Mst_NamaGroupShift,:Mst_ValueGroupShift
                            ,:Mst_Kelas1,:Mst_Kelas2,:Mst_Kelas3,:Mst_Kelas4,:Mst_ValuehariGroup)");
                $this->db->bind('Mst_KodeGroupShift', $data['Mst_KodeGroupShift']);
                $this->db->bind('Mst_NamaGroupShift', $data['Mst_NamaGroupShift']);
                $this->db->bind('Mst_ValueGroupShift', $data['Mst_ValueGroupShift']);
                $this->db->bind('Mst_Kelas1', $data['Mst_Kelas1']);
                $this->db->bind('Mst_Kelas2', $data['Mst_Kelas2']);
                $this->db->bind('Mst_Kelas3', $data['Mst_Kelas3']);
                $this->db->bind('Mst_Kelas4', $data['Mst_Kelas4']);
                $this->db->bind('Mst_ValuehariGroup', $data['Mst_ValuehariGroup']);
            }else{
                $this->db->query("UPDATE HR_Mst_MASTER_SHIFT_GROUP set  
                            NAMA_GROUP_SHIFT=:Mst_NamaGroupShift,NILAI=:Mst_ValueGroupShift
                            ,KELAS_1=:Mst_Kelas1,KELAS_2=:Mst_Kelas2,KELAS_3=:Mst_Kelas3,KELAS_4=:Mst_Kelas4
                            ,Nilai_hari=:Mst_ValuehariGroup
                            WHERE ID=:IdTranasksiAuto");
                $this->db->bind('Mst_NamaGroupShift', $data['Mst_NamaGroupShift']);
                $this->db->bind('Mst_ValueGroupShift', $data['Mst_ValueGroupShift']);
                $this->db->bind('Mst_Kelas2', $data['Mst_Kelas2']);
                $this->db->bind('Mst_Kelas1', $data['Mst_Kelas1']);
                $this->db->bind('Mst_Kelas3', $data['Mst_Kelas3']);
                $this->db->bind('Mst_Kelas4', $data['Mst_Kelas4']);
                $this->db->bind('Mst_ValuehariGroup', $data['Mst_ValuehariGroup']);
                $this->db->bind('IdTranasksiAuto', $data['IdTranasksiAuto']);
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
    public function getAllGroupShift()
    {
        try {
            $this->db->query('SELECT *FROM  HR_Mst_MASTER_SHIFT_GROUP');
            return $this->db->resultSet();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getGroupShiftById($id)
    {
        $this->db->query('SELECT *FROM HR_Mst_MASTER_SHIFT_GROUP where id =:id');
        $this->db->bind('id', $id);
        $data = $this->db->single();
        return  $data;
    }
    public function getGroupShiftCombo(){
        $this->db->query('SELECT *FROM HR_Mst_MASTER_SHIFT_GROUP');
        return $this->db->resultSet();
    }
    public function errormessage()
    {

        echo json_encode("Failed");
    }
}
