<?php
class Mahasiswa_model{
    private $table = 'mahasiswa_mvc';
    private $dbh;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getAllMahasiswa(){
        try{
           $this->db->query('SELECT *FROM mahasiswa_mvc');
           return $this->db->resultSet();
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }
    public function getMahasiswaById($id){
        $this->db->query('SELECT *FROM ' . $this->table . ' where id =:id');
        $this->db->bind('id',$id);
        return $this->db->single();
    }
    public function tambahDataMahasiswa($data){
            $query = "INSERT INTO mahasiswa_mvc (nama,nrp,email,jurusan)
                    VALUES
                    ( :nama, :nrp, :email, :jurusan )";
            $this->db->query($query);
            $this->db->bind('nama', $data['nama']);
            $this->db->bind('nrp', $data['nrp']);
            $this->db->bind('email', $data['email']);
            $this->db->bind('jurusan', $data['jurusan']);
            $this->db->execute();
            return $this->db->rowCount(); 
            
    }
    public function hapusDataMahasiswa($id){
        $query =  "DELETE FROM mahasiswa_mvc WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id',$id);
        $this->db->execute();
        return $this->db->rowCount();
    }
    public function ubahDataMahasiswa($data){
        $query = "UPDATE mahasiswa_mvc SET 
                        nama = :nama,
                        nrp = :nrp,
                        email = :email,
                        jurusan = :jurusan
                    WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('nama', $data['nama']);
        $this->db->bind('nrp', $data['nrp']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('jurusan', $data['jurusan']);
        $this->db->bind('id', $data['id']);
        $this->db->execute();
        return $this->db->rowCount(); 
        
    }
    public function cariDataMahasiswa(){
        try{
            $keyword = $_POST['keyword'];
            $query = "SELECT *FROM mahasiswa_mvc where NAMA LIKE :keyword";
            $this->db->query($query);
            $this->db->bind('keyword',"%$keyword%");
            return $this->db->resultSet();
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }
}