<?php
class aRegistrasiWalkin extends Controller
{
    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['idodc'] =  null;
        $data['jenispasien'] =  'WALKIN';
        $data['judul'] = 'Registration Walkin';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('registration/input/aRegistrasiRajalInput', $data);
        $this->View('templates/footer');
    }
    public function list()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Daftar Antrian Pasien Walkin';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('registration/list/aRegistrasiWalkinList', $data);
        $this->View('templates/footer');
    }
    public function CreateRegistrasi()
    {
        echo json_encode($this->model('B_create_Registrasi_Rajal')->CreateRegistrasi($_POST));
    }
    public function showDataPasienWalkinAktif()
    {
        echo json_encode($this->model('B_List_Registrasi_Pasien_Model')->showDataPasienWalkinAktif($_POST));
    }
    public function showDataPasienRajalArsip()
    {
        echo json_encode($this->model('B_List_Registrasi_Pasien_Model')->showDataPasienRajalArsip($_POST));
    }
    public function showDataPasienWalkinArsip()
    {
        echo json_encode($this->model('B_List_Registrasi_Pasien_Model')->showDataPasienWalkinArsip($_POST));
    }
    public function GetregistrasiRajalbyId()
    {
        echo json_encode($this->model('B_create_Registrasi_Rajal')->GetregistrasiRajalbyId($_POST));
    }
    public function GetregistrasiRajalbyNoRegistrasi()
    {
        echo json_encode($this->model('B_create_Registrasi_Rajal')->GetregistrasiRajalbyNoRegistrasi($_POST));
    }
    public function GetregistrasiRajalbyNoRegistrasiRI()
    {
        echo json_encode($this->model('B_create_Registrasi_Rajal')->GetregistrasiRajalbyNoRegistrasiRI($_POST));
    }
    public function VoidRegistrasi()
    {
        echo json_encode($this->model('B_create_Registrasi_Rajal')->VoidRegistrasi($_POST));
    }
    public function OrderRadiologi($noregistrasi = null, $woid = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['woid'] =  Utils::setDecode($woid);
        $data['noregistrasi'] =  Utils::setDecode($noregistrasi);
        //$data['woid'] =  $woid;
        //$data['noregistrasi'] = $noregistrasi;
        $data['judul'] = 'Order Radiologi';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('emr/radiologi/OrderRadiologi', $data);
        $this->View('templates/footer');
    }
    public function OrderLaboratorium($noregistrasi = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['noregistrasi'] =  Utils::setDecode($noregistrasi);
        //$data['woid'] =  $woid;
        //$data['noregistrasi'] = $noregistrasi;
        $data['judul'] = 'Order Laboratorium';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('emr/laboratorium/OrderLaboratorium', $data);
        $this->View('templates/footer');
    }
}
