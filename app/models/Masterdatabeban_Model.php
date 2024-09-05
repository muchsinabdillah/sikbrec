<?php
class Masterdatabeban_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getListDataMasterbeban()
    {
        try {

            $query = "SELECT * from Keuangan.dbo.BO_M_BEBAN_HARIAN";
            $this->db->query($query);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {
                $pasing['ID'] = $row['ID'];
                $pasing['Nama_group_Beban'] = $row['NAMA_GROUP_BEBAN'];
                // $pasing['No_Transaksi_Kasbon'] = $row['No_Transaksi_Kasbon'];
                $pasing['KODE_COA'] = $row['KODE_COA'];
                $pasing['AKTIF'] = $row['AKTIF'];
                // $pasing['Nominal'] = $row['Nominal'];
                // $pasing['Keterangan'] = $row['Keterangan'];
                // $pasing['No_Pencairan'] = $row['NO_KASBON'];
                // $pasing['Tgl_Pencairan'] = $row['Tgl_Input_First'];
                // $pasing['STATUS_Selesai'] = $row['STATUS'];


                // $pasing['Petugas_Input_First'] = $row['Petugas_Input_First'];
                // $pasing['ID_Group_Beban'] = $row['ID_Group_Beban'];
                // $pasing['discontinue'] = $row['discontinue'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDataBebanbyID($data)
    {
        try {
            // var_dump($data);
            $IDs = $data['id'];
            $this->db->query("SELECT ID,NAMA_GROUP_BEBAN,KODE_COA,AKTIF
                            FROM Keuangan.DBO.BO_M_BEBAN_HARIAN where ID=:id");
            $this->db->bind('id', $IDs);
            $data =  $this->db->single();
            //var_dump($data);exit;
            $pasing['ID'] = $data['ID'];
            $pasing['NAMA_GROUP_BEBAN'] = $data['NAMA_GROUP_BEBAN'];
            $pasing['KODE_COA'] = $data['KODE_COA'];
            $pasing['AKTIF'] = $data['AKTIF'];
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
    public function saveDataBeban($data)
    {

        try {
            $this->db->transaksi();
            if ($data['NAMA_GROUP_BEBAN'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Group Beban !',
                );
                return $callback;
                exit;
            }
            if ($data['AKTIF'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Status !',
                );
                return $callback;
                exit;
            }
            $ID = $data['ID'];
            $NAMA_GROUP_BEBAN = $data['NAMA_GROUP_BEBAN'];
            $KODE_COA = $data['KODE_COA'];
            $AKTIF = $data['AKTIF'];
            $datenowcreate = Utils::seCurrentDateTime(); //Session user
            $session = SessionManager::getCurrentSession();
            $operator =  $session->IDEmployee;

            if ($data['ID'] == "") {
                //INSERT
                $this->db->query("INSERT INTO Keuangan.dbo.BO_M_BEBAN_HARIAN 
                (NAMA_GROUP_BEBAN,KODE_COA,AKTIF) VALUES
                (:NAMA_GROUP_BEBAN,:KODE_COA,:AKTIF)");
                $this->db->bind('NAMA_GROUP_BEBAN', $NAMA_GROUP_BEBAN);
                $this->db->bind('KODE_COA', $KODE_COA);
                $this->db->bind('AKTIF', $AKTIF);
            } else {
                $this->db->query(" UPDATE Keuangan.dbo.BO_M_BEBAN_HARIAN SET 
                NAMA_GROUP_BEBAN=:NAMA_GROUP_BEBAN,KODE_COA=:KODE_COA,
                AKTIF=:AKTIF
                WHERE ID=:ID");
                $this->db->bind('ID', $ID);
                $this->db->bind('NAMA_GROUP_BEBAN', $NAMA_GROUP_BEBAN);
                $this->db->bind('KODE_COA', $KODE_COA);
                $this->db->bind('AKTIF', $AKTIF);
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
}
