<?php
class Pdp extends Controller 
{
    public function index()
    {

        try {
            $session = SessionManager::getCurrentSession();
            //$cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($session) {
                $session = SessionManager::getCurrentSession();
                $data['judul'] = 'List Pdp Header';
                $data['judul_child'] = 'List';
                // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
                $this->View('templates/header', $session);
                $this->View('datamaster/pdp/Pdp_View', $data);
                $this->View('templates/footer');
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }   
    }
    public function getAllPdp()
    {
        try {
              $session = SessionManager::getCurrentSession();
            //$cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($session) {
                echo json_encode($this->model('A_Pdp_Model')->getAllPdp());
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    }
    public function viewPdp($id = null)
    {
        try {
            $session = SessionManager::getCurrentSession();
            //$cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($session) {
                $session = SessionManager::getCurrentSession();
                $data['id'] =  Utils::setDecode($id);
                $data['judul'] = 'Pdp';
                $data['judul_child'] = 'Input';
                $this->View('templates/header', $session);
                $this->View('datamaster/pdp/Pdp', $data);
                $this->View('templates/footer');
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    }
    public function addPdp()
    {
        try {
            $session = SessionManager::getCurrentSession();
          //  $cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($session) {
                echo json_encode($this->model('A_Pdp_Model')->insert($_POST));
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    }
    public function getPdpId()
    {
        try {
            $session = SessionManager::getCurrentSession();
            //$cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($session) {
                echo json_encode($this->model('A_Pdp_Model')->getPdpId($_POST['id']));
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    }
}
