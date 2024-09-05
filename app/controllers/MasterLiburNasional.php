<?php
class MasterLiburNasional extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Transaksi Libur Nasional';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('datamaster/LiburNasional/LiburNasional_List', $data);
        $this->View('templates/footer');
    }
    public function getAllData()
    {
        echo json_encode($this->model('B_Libur_Nasional')->getAllData());
    }
    public function views($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Input Transaksi Libur Nasional';
        $data['judul_child'] = 'Input';
        $this->View('templates/header', $session);
        $this->View('datamaster/LiburNasional/LiburNasional_View', $data);
        $this->View('templates/footer');
    }
    public function AddNew()
    {
        echo json_encode($this->model('B_Libur_Nasional')->insert($_POST));
    }
    public function getDataDetil()
    {
        try {
            $session = SessionManager::getCurrentSession();
            //$cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($session) {
                echo json_encode($this->model('B_Libur_Nasional')->getDataDetil($_POST['id']));
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    }

    public function void()
    {
        echo json_encode($this->model('B_Libur_Nasional')->void($_POST));
    }
}
