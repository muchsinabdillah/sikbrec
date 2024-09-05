<?php
class AbsensiManual extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Absensi Manual';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('hrd/absensi/AbsensiManualList', $data);
        $this->View('templates/footer');
    }
    public function viewForm($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Absensi Manual Input';
        $data['judul_child'] = 'Input Absensi manual';
        $this->View('templates/header', $session);
        $this->View('hrd/absensi/AbsensiManualForm', $data);
        $this->View('templates/footer');
    }
    public function showDataAbsensiManualAll(){
        echo json_encode($this->model('AbsensiManual_Model')->showDataAbsensiManualAll($_POST)); 
    }
    public function ShowDataAbsensiManualByID(){
        echo json_encode($this->model('AbsensiManual_Model')->ShowDataAbsensiManualByID($_POST)); 
    }
    public function getpegawaiAllAktif()
    {
        echo json_encode($this->model('Pegawai_Model')->getpegawaiAllAktif($_POST));
    }
    public function CreateAbsenManual(){
        echo json_encode($this->model('AbsensiManual_Model')->CreateAbsenManual($_POST));
    }
}