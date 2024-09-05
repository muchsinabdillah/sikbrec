<?php
class xBPJSBridging_PRB extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Pembuatan Rujuk Balik (PRB)';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('BpjsBridging_PRB/PRB_Table', $data);
        $this->View('templates/footer');
    }

    public function viewData($id = null)
    {
         $session = SessionManager::getCurrentSession();
        $data['id'] = Utils::setDecode($id);
        $data['judul'] = 'Input Baru PRB';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('BpjsBridging_PRB/PRB_View', $data);
        $this->View('templates/footer');
    }

    public function index2($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Registration Rawat Jalan';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
       // $this->View('templates/header', $session);
       // $this->View('registration/input/aRegistrasiRajalInput', $data);
       // $this->View('templates/footer');
    }
    
    public function GoGetProgramPRB()
    {
        echo json_encode($this->model('B_xBPJSBridging_PRB_Model')->GoGetProgramPRB($_POST));
    }
    public function GetregistrasiRajalbyId()
    {
        echo json_encode($this->model('B_xBPJSBridging_PRB_Model')->GetregistrasiRajalbyId($_POST));
    }
    public function GoGetObatPRB()
    {
        echo json_encode($this->model('B_xBPJSBridging_PRB_Model')->GoGetObatPRB($_POST));
    }
    public function CreatePRB(){
        echo json_encode($this->model('B_xBPJSBridging_PRB_Model')->CreatePRB($_POST));
    }
    public function getObatDtlPRB()
    {
        echo json_encode($this->model('B_xBPJSBridging_PRB_Model')->getObatDtlPRB($_POST['idhdr_bpjs']));
    }
    public function addObatPRB()
    {
        echo json_encode($this->model('B_xBPJSBridging_PRB_Model')->addObatPRB($_POST));
    }
    public function GoSimpanPRB()
    {
        echo json_encode($this->model('B_xBPJSBridging_PRB_Model')->GoSimpanPRB($_POST));
    }
    public function GoUpdatePRB()
    {
        echo json_encode($this->model('B_xBPJSBridging_PRB_Model')->GoUpdatePRB($_POST));
    }
    public function GoBatalPRBDtl(){
        echo json_encode($this->model('B_xBPJSBridging_PRB_Model')->GoBatalPRBDtl($_POST['id']));
    }
    public function GoBatalPRBHdr(){
       // echo json_encode($this->model('B_xBPJSBridging_PRB_Model')->GoBatalPRBHdr($_POST));
        echo json_encode($this->model('B_xBPJSBridging_PRB_Model')->GoDeletePRB($_POST));
    }
    public function getDataList()
    {
        echo json_encode($this->model('B_xBPJSBridging_PRB_Model')->getDataList($_POST));
    }

    public function PrintPRB( $ID = '')
    {
        $data['notrs'] = $ID;
        $data['judul'] = 'Informasi Penggajian Pegawai';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        $data['listdata1'] = $this->model('B_xBPJSBridging_PRB_Model')->PrintPRBHdr($data);
        $data['listdata2'] = $this->model('B_xBPJSBridging_PRB_Model')->PrintPRBDtl($data);
        $this->View('print/bpjs/PrintPRB', $data);
    }
}