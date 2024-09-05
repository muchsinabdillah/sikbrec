<?php
class Mahasiswa extends Controller{
    public function index(){
        $data['judul'] = 'Daftar Mahasiswa';
        $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header',$data);
        $this->View('mahasiswa/index',$data);
        $this->View('templates/footer');
    }
    public function detail($id){
        $data['judul'] = 'Detail Mahasiswa';
        $data['mhs'] = $this->model('Mahasiswa_model')->getMahasiswaById($id);
        $this->View('templates/header',$data);
        $this->View('mahasiswa/detail',$data);
        $this->View('templates/footer');
    }
    public function tambah(){
        if($this->model('Mahasiswa_model')->tambahDataMahasiswa($_POST) > 0  ){
            Flasher::setFlash('berhasil','di tambahkan','success');
            header('Location: ' . BASEURL . '/mahasiswa' );
            exit;
        }else{ 
            Flasher::setFlash('gagal','di tambahkan','danger');
            header('Location: ' . BASEURL . '/mahasiswa' );
            exit;
        }
    }
    public function hapus($id){
        if($this->model('Mahasiswa_model')->hapusDataMahasiswa($id) > 0  ){
            Flasher::setFlash('berhasil','di Hapus','success');
            header('Location: ' . BASEURL . '/mahasiswa' );
            exit;
        }else{ 
            Flasher::setFlash('gagal','di Hapus','danger');
            header('Location: ' . BASEURL . '/mahasiswa' );
            exit;
        }
    }

    public function getUbah(){
       echo json_encode($this->model('Mahasiswa_model')->getMahasiswaById($_POST['id']));
    }
    public function ubah(){
        if($this->model('Mahasiswa_model')->ubahDataMahasiswa($_POST) > 0  ){
            Flasher::setFlash('berhasil','di ubah','success');
            header('Location: ' . BASEURL . '/mahasiswa' );
            exit;
        }else{ 
            Flasher::setFlash('gagal','di ubah','danger');
            header('Location: ' . BASEURL . '/mahasiswa' );
            exit;
        }
    }
    public function cari(){
        $data['judul'] = 'Daftar Mahasiswa';
        $data['mhs'] = $this->model('Mahasiswa_model')->cariDataMahasiswa();
        $this->View('templates/header',$data);
        $this->View('mahasiswa/index',$data);
        $this->View('templates/footer');
    }
}