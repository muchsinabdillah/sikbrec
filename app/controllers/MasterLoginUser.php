<?php
class MasterLoginUser extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Master Login User';
        $data['judul_child'] = 'List';
        $this->View('templates/header', $session);
        $this->View('datamaster/MasterLoginUser/MasterLoginUser_View', $data);
        $this->View('templates/footer');
    }
    public function UserLoginForm($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Master Login User';
        $data['judul_child'] = 'Input';
        $this->View('templates/header', $session);
        $this->View('datamaster/MasterLoginUser/MasterLoginUser_AddView', $data);
        $this->View('templates/footer');
    }
    public function UserLoginHakAkses($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Input Hak Akses';
        $data['judul_child'] = 'Input';
        $this->View('templates/header', $session);
        $this->View('datamaster/MasterLoginUser/MasterLoginUser_AddHakAkses', $data);
        $this->View('templates/footer');
    }
    public function UserLoginHakAksesJO($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Input Hak Akses JO';
        $data['judul_child'] = 'Input';
        $this->View('templates/header', $session);
        $this->View('datamaster/MasterLoginUser/MasterLoginUser_AddHakAksesJo', $data);
        $this->View('templates/footer');
    }
    
    //badrul edit
    public function UserSignature($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Input Signature User';
        $data['judul_child'] = 'Input';
        // $data['idmrx'] = $idmr;
        $this->View('templates/header', $session);
        $this->View('datamaster/MasterLoginUser/MasterLoginUser_AddSignature', $data);
        $this->View('templates/footer');
    }
    
    public function uploadDataTTD()
    {
        echo json_encode($this->model('MasterLoginUser_Model')->uploadDataTTD($_POST));
    }
    public function sendotpVerifikasiSign()
    {
        echo json_encode($this->model('MasterLoginUser_Model')->sendotpVerifikasiSign($_POST));
    }
    public function getverifiedOtpSign(){
        echo json_encode($this->model('MasterLoginUser_Model')->getverifiedOtpSign($_POST));
    }
    public function getDataListTTD()
    {
        echo json_encode($this->model('MasterLoginUser_Model')->getDataListTTD($_POST));
    }
    public function getDatapegawaiTTD()
    {
        echo json_encode($this->model('MasterLoginUser_Model')->getDatapegawaiTTD($_POST));
    }
    //badrul edit

    
    public function createUserLogin()
    {
        echo json_encode($this->model('MasterLoginUser_Model')->createUserLogin($_POST));
    }
    public function getAllUserLogin()
    {
        echo json_encode($this->model('MasterLoginUser_Model')->getAllUserLogin($_POST));
    }
    public function getUserLoginbyId()
    {
        echo json_encode($this->model('MasterLoginUser_Model')->getUserLoginbyId($_POST));
    }
    public function ShowListHakAkses(){
        echo json_encode($this->model('MasterLoginUser_Model')->ShowListHakAkses($_POST));
    }
    public function getDataSubMenu(){
        echo json_encode($this->model('MasterLoginUser_Model')->getDataSubMenu($_POST));
    }
    public function CreateHakAksesbyUserID(){
        echo json_encode($this->model('MasterLoginUser_Model')->CreateHakAksesbyUserID($_POST));
    }
    public function DeleteHakAksesbyUserID(){
        echo json_encode($this->model('MasterLoginUser_Model')->DeleteHakAksesbyUserID($_POST));
    }
    public function getGroupUser(){
        echo json_encode($this->model('MasterLoginUser_Model')->getGroupUser($_POST));
    }
    public function getMenu()
    {
        echo json_encode($this->model('MasterLoginUser_Model')->getMenu($_POST));
    }
    public function getMenu2()
    {
        echo json_encode($this->model('MasterLoginUser_Model')->getMenu2($_POST));
    }
    public function getDataPegawai()
    {
        echo json_encode($this->model('MasterLoginUser_Model')->getDataPegawai($_POST));
    }
    public function getLastPINID(){
        echo json_encode($this->model('MasterLoginUser_Model')->getLastPINID($_POST));
    }
    public function GoupdateCreate(){
        echo json_encode($this->model('MasterLoginUser_Model')->GoupdateCreate($_POST));
    }
    public function GoupdateDelete()
    {
        echo json_encode($this->model('MasterLoginUser_Model')->GoupdateDelete($_POST));
    }
    public function GetHakAksesUser()
    {
        echo json_encode($this->model('MasterLoginUser_Model')->GetHakAksesUser($_POST));
    }
    public function saveCopiHakAkses()
    {
        echo json_encode($this->model('MasterLoginUser_Model')->saveCopiHakAkses($_POST));
    }
    public function UploadSignature()
    {
        echo json_encode($this->model('MasterLoginUser_Model')->UploadSignature($_POST));
    }
    
}