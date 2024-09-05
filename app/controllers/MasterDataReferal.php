<?php
class MasterDataReferal extends Controller
{
    public function index()
    {
        try {
            $session = SessionManager::getCurrentSession();
          //  $cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($session) {
                $session = SessionManager::getCurrentSession();
                $data['judul'] = 'Data Referal';
                $data['judul_child'] = 'List';
                // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
                $this->View('templates/header', $session);
                $this->View('datamaster/MasterDataReferal/MasterDataReferal_Table', $data);
                $this->View('templates/footer');
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    }
    public function getAllDataReferal()
    {
        try {
            $session = SessionManager::getCurrentSession();
           // $cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($session) {
                echo json_encode($this->model('MasterDataReferal_Model')->getAllDataReferal());
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    }
    public function viewReferal($id = null)
    {
        try {
            $session = SessionManager::getCurrentSession();
            //$cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($session) {
                $session = SessionManager::getCurrentSession();
                $data['id'] =  Utils::setDecode($id);
                $data['judul'] = 'Referal';
                $data['judul_child'] = 'Input';
                $this->View('templates/header', $session);
                $this->View('datamaster/MasterDataReferal/MasterDataReferal_View', $data);
                $this->View('templates/footer');
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    }
    public function addReferal()
    {
        try {
            $session = SessionManager::getCurrentSession();
           // $cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($session) {
                echo json_encode($this->model('MasterDataReferal_Model')->insert($_POST));
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    }
    public function getReferalId()
    {
        try {
            $session = SessionManager::getCurrentSession();
            //$cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($session) {
                echo json_encode($this->model('MasterDataReferal_Model')->getReferalId($_POST['id']));
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    }
    public function getNamaCaraMasuk()
    {
        try {
            $session = SessionManager::getCurrentSession();
            //$cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($session) {
                echo json_encode($this->model('MasterDataReferal_Model')->getNamaCaraMasuk());
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    }
    public function GetRefferalByIdGroup()
    {
        try {
            $session = SessionManager::getCurrentSession();
            //$cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($session) {
                echo json_encode($this->model('MasterDataReferal_Model')->GetRefferalByIdGroup($_POST));
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    }
}
