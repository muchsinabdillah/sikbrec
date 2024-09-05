<?php
class Surat extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Transaksi Surat';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('hrd/absensi/SuratList', $data);
        $this->View('templates/footer');
    }
    public function viewForm($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Transaksi Surat S/I/C';
        $data['judul_child'] = 'Input Transaksi Surat S/I/C';
        $this->View('templates/header', $session);
        $this->View('hrd/absensi/SuratForm', $data);
        $this->View('templates/footer');
    } 
    
    public function showDataTrsSuratAll(){
        echo json_encode($this->model('Surat_Model')->showDataTrsSuratAll($_POST)); 
    }
    public function getAllJobOrderbyHakAkses()
    {
        echo json_encode($this->model('JobOrder_Model')->getAllJobOrderbyHakAkses($_POST));
    }
    public function getpegawaiAllAktif()
    {
        echo json_encode($this->model('Pegawai_Model')->getpegawaiAllAktif($_POST));
    }
    public function getJenisCuti(){
        echo json_encode($this->model('Surat_Model')->getJenisCuti($_POST));
    }
    public function CreateTrsCuti(){
        echo json_encode($this->model('Surat_Model')->CreateTrsCuti($_POST));
    }
    public function showSuratById()
    {
        echo json_encode($this->model('Surat_Model')->showSuratById($_POST));
    }
    public function BatalSurat(){
        echo json_encode($this->model('Surat_Model')->BatalSurat($_POST));
    }
}
