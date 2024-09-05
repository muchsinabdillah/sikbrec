<?php
class aRegistrasiKamar extends Controller 
{
    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  null;
        $data['noreg'] =  Utils::setDecode($id);
        $data['judul'] = 'Input Baru Pemakaian Kamar';
        $data['judul_child'] = 'Rawat Inap';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('registration/input/aRegistrasiKamarInput', $data);
        $this->View('templates/footer');
    }

    public function edit($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] = Utils::setDecode($id);
        $data['noreg'] =  null;
        $data['judul'] = 'Edit Pemakaian Kamar';
        $data['judul_child'] = 'Rawat Inap';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('registration/input/aRegistrasiKamarInput', $data);
        $this->View('templates/footer');
    }

    public function list($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Pemakaian Kamar';
        $data['judul_child'] = 'Kamar';
        $this->View('templates/header', $session);
        $this->View('registration/list/aRegistrasiKamarList', $data);
        $this->View('templates/footer');
    }

    public function getDataKamar(){
        echo json_encode($this->model('B_RegistrasiKamar')->getDataKamar($_POST));
    }

    public function getRoom(){
        echo json_encode($this->model('B_RegistrasiKamar')->getRoom($_POST));
    }

    public function getBed(){
        echo json_encode($this->model('B_RegistrasiKamar')->getBed($_POST));
    }

    public function getTarif(){
        echo json_encode($this->model('B_RegistrasiKamar')->getTarif($_POST));
    }

    public function getDatabyID(){
        echo json_encode($this->model('B_RegistrasiKamar')->getDatabyID($_POST));
    }

    public function CreateTrs(){
        echo json_encode($this->model('B_RegistrasiKamar')->CreateTrsNew($_POST));
    }

    public function CekStatusAktif(){
        echo json_encode($this->model('B_RegistrasiKamar')->CekStatusAktif($_POST));
    }

    public function CheckoutKamar(){
        $response = $this->CekRowData($_POST);
        if ($response['status'] == 'success'){
            echo json_encode($this->model('B_RegistrasiKamar')->CheckoutKamar($_POST));
        }else{
            echo json_encode($response);
        }
        /*
        $response = $this->model('B_RegistrasiKamar')->CekRowData($_POST);
        if ($response['status'] == 'success'){
            echo json_encode($this->model('B_RegistrasiKamar')->CheckoutKamar($_POST));
        }else{
            echo json_encode($response);
        }
        */
    }

    public function CheckinKamar(){
        $response = $this->CekRowData($_POST);
        if ($response['status'] == 'success'){
            echo json_encode($this->model('B_RegistrasiKamar')->CheckinKamar($_POST));
        }else{
            echo json_encode($response);
        }
        /*
        $response = $this->model('B_RegistrasiKamar')->CekRowData($_POST);
        if ($response['status'] == 'success'){
            echo json_encode($this->model('B_RegistrasiKamar')->CheckinKamar($_POST));
        }else{
            echo json_encode($response);
        }
        */
    }

    public function DeleteKamar(){
        echo json_encode($this->model('B_RegistrasiKamar')->DeleteKamar($_POST));
    }

    public function CekRowData($pass = null){
        if ($pass == null){
            echo json_encode($this->model('B_RegistrasiKamar')->CekRowData($_POST));
        }else{
            return ($this->model('B_RegistrasiKamar')->CekRowData($pass));
        }
    }
    /*
    public function GetDataPasien($pass = null){
        return ($this->model('B_RegistrasiKamar')->GetDataPasien($pass));
    }
    */

    // public function getBookingList(){
    //     echo json_encode($this->model('B_RegistrasiKamar')->getBookingList($_POST));
    // }

    public function listCleaningRoom()
    {
        $session = null;
        $data['judul'] = 'List Kamar Yang Sedang Dalam Proses Pembersihan (Cleaning)';
        $data['judul_child'] = 'Kamar';
        $this->View('templates/header_nologin', $session);
        $this->View('registration/list/aCleaningKamarList', $data);
        $this->View('templates/footer');
    }
    public function getListCleaningRoom(){
        echo json_encode($this->model('B_RegistrasiKamar')->getListCleaningRoom($_POST));
    }
    public function updateReady(){
        echo json_encode($this->model('B_RegistrasiKamar')->updateReady($_POST));
    }
    public function updateReadySelected(){
        echo json_encode($this->model('B_RegistrasiKamar')->updateReadySelected($_POST));
    }

}
