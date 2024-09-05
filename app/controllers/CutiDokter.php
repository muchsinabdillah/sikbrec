<?php
class CutiDokter extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Transaksi Cuti Dokter';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('billing/cutidokter/CutiDokterTable', $data);
        $this->View('templates/footer');
    }
    public function getAllCutiDokter()
    {
        echo json_encode($this->model('B_Cuti_Dokter_Model')->getAllCutiDokter());
    }
    public function viewCutiDokter($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Input Transaksi Cuti Dokter';
        $data['judul_child'] = 'Input';
        $this->View('templates/header', $session);
        $this->View('billing/cutidokter/CutiDokterView', $data);
        $this->View('templates/footer');
    }
    public function getAllMasterCutiDokter()
    {
        echo json_encode($this->model('B_Cuti_Dokter_Model')->getAllMasterCutiDokter());
    } 
    public function getDataDokterbyPoliklinikID()
    {
        echo json_encode($this->model('B_Cuti_Dokter_Model')->getDataDokterbyPoliklinikID($_POST['IdPoliklinik']));
    }
    public function addCutiDokter()
    {
        echo json_encode($this->model('B_Cuti_Dokter_Model')->insert($_POST));
    }
    public function getDataDetilTransaksiCuti()
    {
        try {
            $session = SessionManager::getCurrentSession();
            //$cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($session) {
                echo json_encode($this->model('B_Cuti_Dokter_Model')->getDataDetilTransaksiCuti($_POST['id']));
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    }
    public function goVoidCutiDokter()
    {
        echo json_encode($this->model('B_Cuti_Dokter_Model')->goVoidCutiDokter($_POST));
    } 

    public function assesmentortho($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Input Transaksi Cuti Dokter';
        $data['judul_child'] = 'Input';
        $this->View('templates/header', $session);
        $this->View('billing/cutidokter/assesmentortho', $data);
        $this->View('templates/footer');
    }
}
