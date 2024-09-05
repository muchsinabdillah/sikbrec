<?php
class bInformationRekapMCU extends Controller 
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Rekap MCU Pasien';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/registration/RekapMCU/InformationRekapMCU', $data);
        $this->View('templates/footer');
    }
    public function getDataListRekapMCUPasien(){
        echo json_encode($this->model('B_InformationRekapMCU_Model')->getDataListPasien($_POST));
    }
    public function getNamaPenjamin(){
        try {
            $session = SessionManager::getCurrentSession();
           // $cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($session) {
                echo json_encode($this->model('B_InformationRekapMCU_Model')->getNamaPenjamin($_POST['tp_penjamin']));
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    }
}
