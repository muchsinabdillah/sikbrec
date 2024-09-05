<?php
class Rujukan extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Input Rujukan';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('Rujukan/insert/index', $data);
        $this->View('templates/footer');
    }

    // view update rujukan
    public function updateRujukan()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = "Update Rujukan";
        $data['judul_chiled'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('Rujukan/update/index', $data);
        $this->View('templates/footer');
    }
    // get data rujukan dari database
    public function getDataRujukanDB()
    {
        $datarujukan = $this->model("B_xBPJSBridging_Rujukan_model")->getDatarujukanbyIDrujukan($_POST);
        echo json_encode($datarujukan);
    }

    public function getPoli()
    {

        $searchTerm = ['searchTerm' => $_POST['nama']];
        $poli = $this->model("B_xBPJSBridging_Model")->GoGetPoliklinikBPJS($searchTerm);
        echo json_encode($poli);
        // var_dump($_POST);
    }

    // insert data rujukan
    public function insertDataRujukan()
    {
        $datarujukan = $this->model('B_xBPJSBridging_Rujukan_model')->insert($_POST);
        echo json_encode($datarujukan);
    }
    // update data rujukan
    public function updateDataRujukan()
    {
        $datarujukan = $this->model('B_xBPJSBridging_Rujukan_model')->update($_POST);
        echo json_encode($datarujukan);
    }
    // delete data rujukan
    public function deleteDatarujukan()
    {
        $datarujukan = $this->model('B_xBPJSBridging_Rujukan_model')->DeleteRujukanBPJS($_POST);
        echo json_encode($datarujukan);
    }
    public function getFakes()
    {
        $datafakes = $this->model('B_xBPJSBridging_Rujukan_model')->Fakes($_POST);
        echo json_encode($datafakes);
    }

    public function getListrujukanspesialistik()
    {
        $listrujukan = $this->model('B_xBPJSBridging_Rujukan_Khusus_model')->spesialistik($_POST);
        echo json_encode($listrujukan);
    }

    public function RujukanKhusus()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = "Rujukan Khusus";
        $data['judul_chiled'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('RujukanKhusus/RujukanKhusus', $data);
        $this->View('templates/footer');
    }

    public function InputRujukanKhusus()

    {
        $input = $this->model('B_xBPJSBridging_Rujukan_Khusus_model')->save($_POST);
        echo json_encode($input);
    }

    public function lisSpesialistikrujukan()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = "Rujukan Khusus";
        $data['judul_chiled'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('RujukanSpesialistik/lisrujukanspesialistik', $data);
        $this->View('templates/footer');
    }
    public function showListRujukan()
    {
        echo json_encode($this->model('B_xBPJSBridging_Rujukan_model')->showListRujukan($_POST));
    }
    public function CreateRujukanKhususTRS()
    {
        echo json_encode($this->model('B_xBPJSBridging_Rujukan_Khusus_model')->CreateRujukanKhususTRS($_POST));
    }
    public function CreateRujukanKhususTRSdetil(){
        echo json_encode($this->model('B_xBPJSBridging_Rujukan_Khusus_model')->CreateRujukanKhususTRSdetil($_POST));
    }
    public function getListRujukanKhusus(){
        echo json_encode($this->model('B_xBPJSBridging_Rujukan_Khusus_model')->getListRujukanKhusus($_POST['IdTrsAuto']));
    }
    public function insertDataRujukanKhusus()
    { 
        $datarujukan = $this->model('B_xBPJSBridging_Rujukan_Khusus_model')->save($_POST);
        echo json_encode($datarujukan);
    }
    public function GoListRujukanData()
    {
        echo json_encode($this->model('B_xBPJSBridging_Rujukan_Khusus_model')->GoListRujukanData($_POST));
    }
    public function voidAllRujukanKhusus(){
        echo json_encode($this->model('B_xBPJSBridging_Rujukan_Khusus_model')->voidAllRujukanKhusus($_POST));
    }
    public function voidAllRujukanKhususDTL(){
        echo json_encode($this->model('B_xBPJSBridging_Rujukan_Khusus_model')->voidAllRujukanKhususDTL($_POST));
    }
}
