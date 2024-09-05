<?php
class bInformationCPPT extends Controller 
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi CPPT Pasien';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/registration/CPPT/InformationCPPT', $data);
        $this->View('templates/footer');
    }
    public function getDataListCPPTPasien(){
        echo json_encode($this->model('B_InformationCPPT_Model')->getDataListPasien($_POST));
    }
    public function getNamaPasien(){
        try {
            $session = SessionManager::getCurrentSession();
            //$cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($session) {
                echo json_encode($this->model('B_InformationCPPT_Model')->getNamaPasien());
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    }
}
