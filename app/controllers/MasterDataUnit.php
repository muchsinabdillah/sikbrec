<?php
class MasterDataUnit extends Controller{
    public function index()
    {
        try {
            $session = SessionManager::getCurrentSession();
            //$cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($session) {
                $session = SessionManager::getCurrentSession();
                $data['judul'] = 'Data Unit';
                $data['judul_child'] = 'List';
                $this->View('templates/header', $session);
                $this->View('datamaster/MasterDataUnit/MasterDataUnit_Table', $data);
                $this->View('templates/footer');
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    }
    public function getAllDataUnit()
    {
        try {
            $session = SessionManager::getCurrentSession();
           // $cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($session) {
                echo json_encode($this->model('MasterDataUnit_Model')->getAllDataUnit());
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    }
    public function viewUnit($id = null)
    {
        try {
            $session = SessionManager::getCurrentSession();
            //$cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($session) {
                $session = SessionManager::getCurrentSession();
                $data['id'] =  Utils::setDecode($id);
                $data['judul'] = 'Unit';
                $data['judul_child'] = 'Input';
                $this->View('templates/header', $session);
                $this->View('datamaster/MasterDataUnit/MasterDataUnit_View', $data);
                $this->View('templates/footer');
            } else {
                header('Location: ' . BASEURL . '/Login');
            } 
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    }
    public function addUnit(){
        try {
            $session = SessionManager::getCurrentSession();
           // $cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($session) {
                echo json_encode($this->model('MasterDataUnit_Model')->insert($_POST));
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            throw new Exception("User is not login");
        }
    }
    public function getUnitId()
    {
        echo json_encode($this->model('MasterDataUnit_Model')->getUnitId($_POST['id']));
        // try {
        //     $session = SessionManager::getCurrentSession();
        //    // $cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
        //     if ($session) {
        //         echo json_encode($this->model('MasterDataUnit_Model')->getUnitId($_POST['id']));
        //     } else {
        //         header('Location: ' . BASEURL . '/Login');
        //     }
        // } catch (exception $exception) {
        //     header('Location: ' . BASEURL . '/Login');
        // }
    }
    public function GetLayananPoliklinik()
    {
        try {
            $session = SessionManager::getCurrentSession();
            //$cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($session) {
                echo json_encode($this->model('MasterDataUnit_Model')->GetLayananPoliklinik());
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    }
    public function GetLayananPoliPenunjangIgd()
    {
        try {
            $session = SessionManager::getCurrentSession();
            ///$cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($session) {
                echo json_encode($this->model('MasterDataUnit_Model')->GetLayananPoliPenunjangIgd());
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    }
    public function GetLayananAll()
    {
        try {
            $session = SessionManager::getCurrentSession();
           // $cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($session) {
                echo json_encode($this->model('MasterDataUnit_Model')->GetLayananAll());
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    }
    public function uuidGen(){
        echo json_encode($this->model('MasterDataUnit_Model')->uuidGen());
    }
    public function addUNitSatuSehat(){
        echo json_encode($this->model('MasterDataUnit_Model')->addUNitSatuSehat());
    }
    public function PostLocation(){
                echo json_encode($this->model('MasterDataUnit_Model')->PostLocation($_POST));
    }
    public function PutLocation(){
        echo json_encode($this->model('MasterDataUnit_Model')->PutLocation($_POST));
}
}