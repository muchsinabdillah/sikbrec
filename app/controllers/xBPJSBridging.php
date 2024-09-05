<?php
class xBPJSBridging extends Controller
{
    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Registration Rawat Jalan';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
    }
    public function GoBPJSCekKepesertaan()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->GoBPJSCekKepesertaan($_POST));
    }
    public function GoGetDaignosaBPJS()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->GoGetDaignosaBPJS($_POST));
    }
    public function GoGetFaskesBPJS()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->GoGetFaskesBPJS($_POST));
    }
    public function GoGetDokterBPJS()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->GoGetDokterBPJS($_POST));
    }
    public function GoGetPoliklinikBPJS()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->GoGetPoliklinikBPJS($_POST));
    }
    public function GoGetProvinsiBPJS()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->GoGetProvinsiBPJS());
    }
    public function GoCreateSEP()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->GoCreateSEP($_POST));
    }
    public function MonitoringPelayananBPJS()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Monitoring Kunjungan Pasien BPJS Kesehatan';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('bridgingbpjs/monitoring/monitoringkunjungan', $data);
        $this->View('templates/footer');
    }
    public function MonitoringDataKlaimBPJS()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Monitoring Data Klaim Pasien BPJS Kesehatan';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('bridgingbpjs/monitoring/monitoringdataklaim', $data);
        $this->View('templates/footer');
    }
    public function GoMonitoringPelayananBPJS()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->GoMonitoringPelayananBPJS($_POST));
    }
    public function GoMonitoringDataKlaimBPJS()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->GoMonitoringDataKlaimBPJS($_POST));
    }
    public function MonitoringHistoriPelayananBPJS()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Monitoring Data History Pelayanan Pasien BPJS Kesehatan';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('bridgingbpjs/monitoring/monitoringdatahistoripelayanan', $data);
        $this->View('templates/footer');
    }
    public function GoMonitoringHistoriPelayananBPJS()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->GoMonitoringHistoriPelayananBPJS($_POST));
    }
    public function GoRujukanMultiByKartu()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->GoRujukanMultiByKartu($_POST));
    }
    public function getSepSIMRSAllbyDate()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->getSepSIMRSAllbyDate($_POST));
    }
    public function PrintSEP($kodetrs = '', $noreg = '')
    {
        $data['kodetrs'] = $kodetrs;
        $data['noreg'] = $noreg;
        $data['judul'] = 'Informasi Penggajian Pegawai';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        $data['sep'] = $this->model('B_xBPJSBridging_Model')->PrintSEP($data);
        $this->View('print/bpjs/PrintSEP', $data);
    }
    public function PrintSEP2($kodetrs = '', $noreg = '')
    {
        $data['kodetrs'] = $kodetrs;
        $data['noreg'] = $noreg;
        $data['judul'] = 'Informasi Penggajian Pegawai';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        $data['sep'] = $this->model('B_xBPJSBridging_Model')->PrintSEP($data);
        $this->View('print/bpjs/PrintSEP2', $data);
    }
    public function GoDeleteSEP()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->GoDeleteSEP($_POST));
    }
    public function GoGetPoliklinikBPJSSPRI()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->GoGetPoliklinikBPJSSPRI($_POST));
    }
    public function getDokterbyKodePoliSPRI()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->getDokterbyKodePoliSPRI($_POST));
    }
    public function CreateSPRI()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->CreateSPRI($_POST));
    }

    public function GoListSPRIBPJS()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->GoListSPRIBPJS($_POST));
    }
    public function goBatalSPRI()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->goBatalSPRI($_POST));
    }
    public function gosavePengajuanSEP()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->gosavePengajuanSEP($_POST));
    }
    public function gosaveApprovalPengajuanSEP()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->gosaveApprovalPengajuanSEP($_POST));
    }
    public function GetKetersediaanPoliklinik()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->GetKetersediaanPoliklinik($_POST));
    }
    public function GetKetersediaanSarana()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->GetKetersediaanSarana($_POST));
    }
    public function GetKetersediaanPoliklinikInternal()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->GetKetersediaanPoliklinikInternal($_POST));
    }
    public function PrintSPRI($kodetrs = '', $noreg = '')
    {
        $data['kodetrs'] = $kodetrs;
        $data['noreg'] = $noreg;
        $data['judul'] = 'Informasi Penggajian Pegawai';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        $data['spri'] = $this->model('B_xBPJSBridging_Model')->PrintSPRI($data);
        $this->View('print/bpjs/PrintSPRI', $data);
    }
    public function goUpdateTglSEPPulang()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->goUpdateTglSEPPulang($_POST));
    }
    public function goHapussepInternal()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->goHapussepInternal($_POST));
    }
    public function getKabupatenBPJS()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->GoGetDataKabupatenBPJS($_POST));
    }
    public function GetDataKecamatanBPJS()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->GetDataKecamatanBPJS($_POST));
    }
    public function setDataSEP()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->setDataSEP($_POST));
    }
    public function setDataSEPSIMRS()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->setDataSEPSIMRS($_POST));
    }
    public function GoUpdateSEP()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->GoUpdateSEP($_POST));
    }
    public function PrintRujukan($kodetrs = '')
    {
        $data['kodetrs'] = $kodetrs;
        $data['judul'] = 'Informasi Penggajian Pegawai';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        
       $data['rujukan'] = $this->model('B_xBPJSBridging_Model')->PrintRujukan($data);
        $this->View('print/bpjs/PrintRujukan', $data);
    }
    public function PrintRujukanKontrol($kodetrs = '')
    {
        $data['kodetrs'] = $kodetrs;
        $data['judul'] = 'Informasi Penggajian Pegawai';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        $data['spri'] = $this->model('B_xBPJSBridging_Model')->PrintSPRI($kodetrs);
        $this->View('print/bpjs/PrintRujukanKontrol', $data);
    }
    public function GoVerificationFinger()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->GoVerificationFinger($_POST));
    }
    public function GoVerificationFingerList()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->GoVerificationFingerList($_POST));
    }
    public function GetDokterDPJP()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->GetDokterDPJP($_POST));
    }
    public function GoTambahAntrianBPJS()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->GoTambahAntrianBPJS($_POST));
    }
    public function GoBatalAntrianBPJS(){
        echo json_encode($this->model('B_xBPJSBridging_Model')->GoBatalAntrianBPJS($_POST));
    }
    public function UpdateWaktuAntrian()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->UpdateWaktuAntrian($_POST));
    }
    public function xGoBPJSCekJumlahSEPRujukan()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->xGoBPJSCekJumlahSEPRujukan($_POST));
    }
    public function GoBPJSCekJadwalDokter()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->GoBPJSCekJadwalDokter($_POST));
    }
    public function xGoSendHFIS()
    {
        echo json_encode($this->model('B_Bridging_Antrian_Online_Model')->xGoSendHFIS($_POST));
    }
}
