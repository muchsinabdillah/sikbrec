<?php
class MasterDataSubMenu_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getAllDataSubMenu()
    {
        try {
            $this->db->query("SELECT A.id_submenu,B.nama_menu,
            A.id_menu,A.nama_submenu,A.icon,A.url
            FROM  MasterdataSQL.DBO.A_SUBMENU_USER_V2 A
            INNER JOIN  MasterdataSQL.DBO.A_MENU_USER_V2 B
            ON A.id_menu = B.id_menu
            ORDER BY B.id_menu ASC, a.id_submenu asc");
            $data =  $this->db->resultSet();
            $this->db->closeCon();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['id_submenu'];
                $pasing['nama_menu'] = $key['nama_menu'];
                $pasing['nama_submenu'] = $key['nama_submenu'];
                $pasing['icon'] = $key['icon'];
                $pasing['url'] = $key['url'];
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

            if ($data['CodeMenu'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Pilih Nama Menu !',
                );
                return $callback;
                exit;
            }
            if ($data['NamaSubMenu'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Nama Sub Menu !',
                );
                return $callback;
                exit;
            }
            if ($data['UrlSubMenu'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input URL Sub Menu !',
                );
                return $callback;
                exit;
            }
             

            $IdAuto = $data['IdAuto'];
            $IconSubMenu = $data['IconSubMenu'];
            $UrlSubMenu = $data['UrlSubMenu'];
            $NamaSubMenu = $data['NamaSubMenu'];
            $CodeMenu = $data['CodeMenu']; 

            if ($data['IdAuto'] == "") { 
                $this->db->query("INSERT INTO MasterdataSQL.dbo.A_SUBMENU_USER_V2 
                                (id_menu,nama_submenu,icon,url) 
                                VALUES
                                (:id_menu,:nama_submenu,:icon,:url)");
                $this->db->bind('id_menu', $CodeMenu);
                $this->db->bind('nama_submenu', $NamaSubMenu);
                $this->db->bind('icon', $IconSubMenu);
                $this->db->bind('url', $UrlSubMenu); 
            } else {
                $this->db->query("UPDATE MasterdataSQL.dbo.A_SUBMENU_USER_V2 set  
                            id_menu=:id_menu,nama_submenu=:nama_submenu,icon=:icon,url=:url
                            WHERE id_submenu=:IdAuto");
                $this->db->bind('id_menu', $CodeMenu);
                $this->db->bind('nama_submenu', $NamaSubMenu);
                $this->db->bind('icon', $IconSubMenu);
                $this->db->bind('url', $UrlSubMenu); 
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
    public function getSubMenuId($id)
    {
        try {

            $this->db->query("SELECT  id_submenu,id_menu,nama_submenu,icon,url FROM MasterdataSQL.DBO.A_SUBMENU_USER_V2
                            WHERE id_submenu=:id");
            $this->db->bind('id', $id);
            $data =  $this->db->single();
            $this->db->closeCon();
            $pasing['ID'] = $data['id_submenu'];
            $pasing['id_menu'] = $data['id_menu'];
            $pasing['nama_submenu'] = $data['nama_submenu'];
            $pasing['icon'] = $data['icon'];
            $pasing['url'] = $data['url']; 
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
}
