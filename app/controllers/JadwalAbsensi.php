<?php
class JadwalAbsensi extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Jadwal Absensi';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('hrd/absensi/JadwalAbsensiForm', $data);
        $this->View('templates/footer');
    }
    public function getpegawaiAllAktif()
    {
        echo json_encode($this->model('Pegawai_Model')->getpegawaiAllAktif($_POST));
    }
    public function getAllJobOrderbyHakAkses()
    {
        echo json_encode($this->model('JobOrder_Model')->getAllJobOrderbyHakAkses($_POST));
    }
    public function CreateJadwal(){
        //  echo json_encode($this->model('JadwalAbsensi_Model')->CreateJadwal($_POST));
        $jadwalService =  new JadwalAbsensi_Service();
        echo json_encode($jadwalService->addJadwalDokter($_POST));
    }
    public function ShowDataJadwalPegawai(){
        echo json_encode($this->model('JadwalAbsensi_Model')->ShowDataJadwalPegawai($_POST));
    }
    public function UpdateLibur(){
        echo json_encode($this->model('JadwalAbsensi_Model')->UpdateLibur($_POST));
    }
    public function BatalUpdateLibur()
    {
        echo json_encode($this->model('JadwalAbsensi_Model')->BatalUpdateLibur($_POST));
    }
    public function getShiftkerjaAllAktif(){
        echo json_encode($this->model('Shift_Model')->getShiftkerjaAllAktif($_POST));
    }
    public function SendUpdateJadwal(){
        echo json_encode($this->model('JadwalAbsensi_Model')->SendUpdateJadwal($_POST));
    }
    public function getHariJadwalDokterCurrent()
    {
        echo json_encode($this->model('JadwalAbsensi_Model')->getHariJadwalDokterCurrent($_POST));
    }
}