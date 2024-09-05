<?php
class aMedicalRecord extends Controller
{
    public function index($nomr = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['nomrext'] = Utils::setDecode($nomr);
        $data['judul'] = 'List Medical Record';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('registration/list/aMedicalRecordList', $data);
        $this->View('templates/footer');
    }
    public function frmUploadDocuments($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Upload Data Document Pasien';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('registration/input/documentUpload', $data);
        $this->View('templates/footer');
    }
    public function getStatusHubunganKeluarga()
    {
        echo json_encode($this->model('B_MedicalRecord_Model')->getStatusHubunganKeluarga());
    }
    public function GetMedicalRecordbyId()
    {
        echo json_encode($this->model('B_MedicalRecord_Model')->GetMedicalRecordbyId($_POST));
    }
    public function getProvinsi()
    {
        echo json_encode($this->model('B_MedicalRecord_Model')->getProvinsi());
    }
    public function GetKabupaten()
    {
        echo json_encode($this->model('B_MedicalRecord_Model')->GetKabupaten($_POST));
    }
    public function GetKecamatan()
    {
        echo json_encode($this->model('B_MedicalRecord_Model')->GetKecamatan($_POST));
    }
    public function GetKelurahan()
    {
        echo json_encode($this->model('B_MedicalRecord_Model')->GetKelurahan($_POST));
    }
    public function GetKodepos()
    {
        echo json_encode($this->model('B_MedicalRecord_Model')->GetKodepos($_POST));
    }
    public function getArsipRawatJalan(){
        echo json_encode($this->model('B_MedicalRecord_Model')->getArsipRawatJalan($_POST));
    }
    public function getArsipRawatInap()
    {
        echo json_encode($this->model('B_MedicalRecord_Model')->getArsipRawatInap($_POST));
    }
    public function GetMedicalRecordbyQRCode(){
        echo json_encode($this->model('B_MedicalRecord_Model')->GetMedicalRecordbyQRCode($_POST));
    }
    public function CreateMedicalRecord(){
        echo json_encode($this->model('B_MedicalRecord_Model')->CreateMedicalRecord($_POST));
    }
    public function getListMedicalRecord(){
        echo json_encode($this->model('B_MedicalRecord_Model')->getListMedicalRecord($_POST));
    }
    public function GetMedicalRecordbyIDTrs(){
        echo json_encode($this->model('B_MedicalRecord_Model')->GetMedicalRecordbyIDTrs($_POST));
    }
    public function createPolisAsuransi(){
        echo json_encode($this->model('B_MedicalRecord_Model')->createPolisAsuransi($_POST));
    }
    public function createPolisKaryawan(){
        echo json_encode($this->model('B_MedicalRecord_Model')->createPolisKaryawan($_POST));
    }
    public function uploaddocument()
    {
        echo json_encode($this->model('B_MedicalRecord_Model')->uploaddocument($_POST));
    }
    public function listuploaddocument()
    {
        echo json_encode($this->model('B_MedicalRecord_Model')->listuploaddocument($_POST));
    }
    public function PrintKartuMR($nomr = '')
    {
        $data['notrs'] =  Utils::setDecode($nomr);
        $session = SessionManager::getCurrentSession();
        $data['listdata1'] = $this->model('B_Create_Registrasi_Rajal')->PrintLabelPasien($data); 
        $this->View('print/registration/print_kartu_mr', $data);
    }

    public function getListMedicalRecordAll(){
        echo json_encode($this->model('B_MedicalRecord_Model')->getListMedicalRecordAll($_POST));
    }
    public function signupUser(){
        echo json_encode($this->model('B_MedicalRecord_Model')->signupUser($_POST));
    }
}