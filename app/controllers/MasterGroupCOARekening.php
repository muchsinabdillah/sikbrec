<?php
class MasterGroupCOARekening extends Controller{
    public function index()
    {
        try {
            $session = SessionManager::getCurrentSession();
            //$cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($session) {
                $session = SessionManager::getCurrentSession();
                $data['judul'] = 'Data Group COA Rekening';
                $data['judul_child'] = 'List';
                $this->View('templates/header', $session);
                $this->View('datamaster/grouprekening/grouprekeningcoa_list', $data);
                $this->View('templates/footer');
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    }
    public function getAll()
    {
        try {
            $session = SessionManager::getCurrentSession();
            if ($session) {
                echo json_encode($this->model('A_Rekening_Model')->getAllGroupRekeningCOA());
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    } 
}