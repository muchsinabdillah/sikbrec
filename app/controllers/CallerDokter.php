<?php
class CallerDokter extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Antrian Poliklinik Pasien';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('bridgingbpjs/antrianonline/antrianpoliklinik', $data);
        $this->View('templates/footer');
    }
    public function GoCallerDokter()
    {
        echo json_encode($this->model('B_List_Registrasi_Pasien_Model')->GoListCallerDokter($_POST));
    }
    public function UpdateTaskAntrianBPJS()
    {
        echo json_encode($this->model('B_Bridging_Antrian_Online_Model')->UpdateTaskAntrianBPJS($_POST));
    }
    public function UpdateTaskAntrianBPJS2()
    {
        echo json_encode($this->model('B_Bridging_Antrian_Online_Model')->UpdateTaskAntrianBPJS2($_POST));
    }
    public function CallDokterCendana()
    {
        echo json_encode($this->model('B_Bridging_Antrian_Online_Model')->CallDokterCendana($_POST));
    }
    public function ReCallDokterCendana()
    {
        echo json_encode($this->model('B_Bridging_Antrian_Online_Model')->ReCallDokterCendana($_POST));
    }
    public function SpecialCallDokterCendana(){
        echo json_encode($this->model('B_Bridging_Antrian_Online_Model')->SpecialCallDokterCendana($_POST));
    }
}
