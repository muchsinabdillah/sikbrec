<?php
class TipePembayaran extends Controller
{
    public function index()
    {
        try {
            $session = SessionManager::getCurrentSession();
            // $cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($session) {
                $session = SessionManager::getCurrentSession();
                $data['judul'] = 'List Tipe Pembayaran';
                $data['judul_child'] = 'List';
                // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
                $this->View('templates/header', $session);
                $this->View('datamaster/TipePembayaran/TipePembayaran_List', $data);
                $this->View('templates/footer');
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    }
    public function getAllTipePembayaran()
    {
        echo json_encode($this->model('TipePembayaran_Model')->getAllTipePembayaran());
    }
    public function viewTipePembayaran($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        if ($data['id'] == "") {
            $data['judul'] = 'New Tipe Pembayaran';
        } else {
            $data['judul'] = 'Update Tipe Pembayaran';
        }
        $data['judul_child'] = 'Input';
        $this->View('templates/header', $session);
        $this->View('datamaster/TipePembayaran/TipePembayaran_View', $data);
        $this->View('templates/footer');
    }
    public function getKodeRekeningCOA()
    {
        echo json_encode($this->model('TipePembayaran_Model')->getKodeRekeningCOA());
    }
    public function saveTipePembayaran()
    {
        echo json_encode($this->model('TipePembayaran_Model')->saveTipePembayaran($_POST));
    }
    public function getTipePembayaranById()
    {
        echo json_encode($this->model('TipePembayaran_Model')->getTipePembayaranById($_POST));
    }
}
