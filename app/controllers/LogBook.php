<?php
class LogBook extends Controller {
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Log Book';
        $data['judul_child'] = 'Entri';
        $data['session'] = $session;
            $this->View('templates/header',$session);
            $this->View('Logbook/LogBook', $data);
            $this->View('templates/footer');
    }
    public function getDataMouAktif()
    {
        echo json_encode($this->model('JobOrder_Model')->getDataMouAktif());
    }
    public function getEntrylogBookbyCurrentDay(){
        echo json_encode($this->model('LogBook_Model')->getEntrylogBookbyCurrentDay($_POST));
    }
    public function getMoubyIDAktif(){
        echo json_encode($this->model('LogBook_Model')->getMoubyIDAktif($_POST['xdi']));
    }
    public function getAllSPVbyKontrak(){
        echo json_encode($this->model('LogBook_Model')->getAllSPVbyKontrak($_POST));
    }
    public function getAllSPVbyMou()
    {
        echo json_encode($this->model('LogBook_Model')->getAllSPVbyMou($_POST));
    }
    public function getPersonelOtherTeam(){
        echo json_encode($this->model('LogBook_Model')->getPersonelOtherTeam($_POST));
    }
    public function AddTempLBByIDByLuar()
    {
        echo json_encode($this->model('LogBook_Model')->AddTempLBByIDByLuar($_POST));
    }
    public function ShowlistTeamsBySPV(){
        echo json_encode($this->model('LogBook_Model')->ShowlistTeamsBySPV($_POST));
    }
    public function AddTempLBByID(){
        echo json_encode($this->model('LogBook_Model')->AddTempLBByID($_POST));
    }
    public function genHdrLogBook(){
        echo json_encode($this->model('LogBook_Model')->genHdrLogBook($_POST));
    }
    public function getWBSbyMouJo(){
        echo json_encode($this->model('LogBook_Model')->getWBSbyMouJo($_POST));
    }
    public function SaveAddtools(){
        echo json_encode($this->model('LogBook_Model')->SaveAddtools($_POST));
    }
    public function getEntrylogBookHistory()
    {
        echo json_encode($this->model('LogBook_Model')->getEntrylogBookHistory($_POST));
    }
    public function finishLogBookTrs(){
        echo json_encode($this->model('LogBook_Model')->finishLogBookTrs($_POST));
    }
    public function delTempLBByID(){
        echo json_encode($this->model('LogBook_Model')->delTempLBByID($_POST));
    }
    public function DeleteLogBookdetil(){
        echo json_encode($this->model('LogBook_Model')->DeleteLogBookdetil($_POST));
    }
    public function showLogBookCurrentDate(){
        echo json_encode($this->model('LogBook_Model')->showLogBookCurrentDate($_POST));
    }
    public function ShowDataTRsLogBookbyID(){
        echo json_encode($this->model('LogBook_Model')->ShowDataTRsLogBookbyID($_POST));
    }
    public function DeleteLogBookTransaction()
    {
        echo json_encode($this->model('LogBook_Model')->DeleteLogBookTransaction($_POST));
    }
}