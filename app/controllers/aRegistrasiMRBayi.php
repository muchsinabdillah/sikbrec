<?php
// use hari; 
class aRegistrasiMRBayi extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Permintaan Rekam Medik Bayi';
        $data['judul_child'] = 'Rawat inap';
        // $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('registration/list/aRegistrasiMRBayiList', $data);
        $this->View('templates/footer');
    }

    public function goRegistrasi($id = null, $nomr = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['nomr'] =  Utils::setDecode($nomr);
        $data['judul'] = 'Registration Rawat Inap';
        $data['judul_child'] = 'Rawat Inap';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('registration/input/aRegistrasiRanapInput', $data);
        $this->View('templates/footer');
    }

    public function getDataListMRbayi()
    {
        echo json_encode($this->model('B_List_RegistrasiMRBayi_model')->getDataListMRbayi($_POST));
    }
    public function GetMedicalRecordbyId()
    {
        echo json_encode($this->model('B_List_RegistrasiMRBayi_model')->GetMedicalRecordbyId($_POST));
    }
    public function getProvinsi()
    {
        echo json_encode($this->model('B_List_RegistrasiMRBayi_model')->getProvinsi());
    }
    public function GetKabupaten()
    {
        echo json_encode($this->model('B_List_RegistrasiMRBayi_model')->GetKabupaten($_POST));
    }
    public function GetKecamatan()
    {
        echo json_encode($this->model('B_List_RegistrasiMRBayi_model')->GetKecamatan($_POST));
    }
    public function GetKelurahan()
    {
        echo json_encode($this->model('B_List_RegistrasiMRBayi_model')->GetKelurahan($_POST));
    }
    public function GetKodepos()
    {
        echo json_encode($this->model('B_List_RegistrasiMRBayi_model')->GetKodepos($_POST));
    }
    public function getArsipRawatJalan()
    {
        echo json_encode($this->model('B_List_RegistrasiMRBayi_model')->getArsipRawatJalan($_POST));
    }
    public function getArsipRawatInap()
    {
        echo json_encode($this->model('B_List_RegistrasiMRBayi_model')->getArsipRawatInap($_POST));
    }
    public function CreateMedicalRecord()
    {
        echo json_encode($this->model('B_MedicalRecord_Model')->CreateMedicalRecord($_POST));
    }
    public function goUpdateStatus()
    {
        echo json_encode($this->model('B_List_RegistrasiMRBayi_model')->goUpdateStatus($_POST));
    }
}

