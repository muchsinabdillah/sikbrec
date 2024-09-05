<?php
class MasterDataPerusahaan extends Controller
{
    public function index()
    {
        try {
            $session = SessionManager::getCurrentSession();
           // $cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($session) {
                $session = SessionManager::getCurrentSession();
                $data['judul'] = 'Data Perusahaan';
                $data['judul_child'] = 'List';
                // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
                $this->View('templates/header', $session);
                $this->View('datamaster/MasterDataPerusahaan/MasterDataPerusahaan_Table', $data);
                $this->View('templates/footer');
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    }
    public function getAllDataPerusahaan()
    {
        try {
            $session = SessionManager::getCurrentSession();
           // $cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($session) {
                echo json_encode($this->model('MasterDataPerusahaan_Model')->getAllDataPerusahaan());
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    }
    public function viewPerusahaan($id = null)
    {
        try {
            $session = SessionManager::getCurrentSession();
            //$cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($session) {
                $session = SessionManager::getCurrentSession();
                $data['id'] =  Utils::setDecode($id);
                $data['judul'] = 'Perusahaan';
                $data['judul_child'] = 'Input';
                $this->View('templates/header', $session);
                $this->View('datamaster/MasterDataPerusahaan/MasterDataPerusahaan_View', $data);
                $this->View('templates/footer');
        } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    }
    public function addPerusahaan()
    {
        try {
            $session = SessionManager::getCurrentSession();
            //$cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($session) { 
                echo json_encode($this->model('MasterDataPerusahaan_Model')->insert($_POST));
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
                header('Location: ' . BASEURL . '/Login');
        }
    }
    public function getPerusahaanId()
    {
         try {
            $session = SessionManager::getCurrentSession();
          //  $cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($session) {
                echo json_encode($this->model('MasterDataPerusahaan_Model')->getPerusahaanId($_POST['id']));
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    }
}
