<?php
class InfoLedger extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Ledger Detail';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/finance/ledger/InformationLedgerDetil', $data);
        $this->View('templates/footer');
    }
    public function InfoLedgerRekap()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Ledger Rekap';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/finance/ledger/InformationLedgerRekap', $data);
        $this->View('templates/footer');
    }
    public function jurnalharian()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Jurnal Harian';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/finance/ledger/informationLedgerharian', $data);
        $this->View('templates/footer');
    }
    public function generateLedger()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Generate Jurnal';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/finance/ledger/genratejurnal', $data);
        $this->View('templates/footer');
    }
    public function getDataListInfoLedger()
    {
        echo json_encode($this->model('B_InformationInfoLedger_Model')->getDataListInfoLedger($_POST));
    }
    public function getDataListInfoLedgerRekap()
    {
        echo json_encode($this->model('B_InformationInfoLedger_Model')->getDataListInfoLedgerRekap($_POST));
    }
    public function Gogeneratejurnal()
    {
        echo json_encode($this->model('B_InformationInfoLedger_Model')->Gogeneratejurnal($_POST));
    }
    public function getRekening()
    {
        echo json_encode($this->model('A_Rekening_Model')->getRekeningAllAktif($_POST));
    }
    public function GetUser(){
        echo json_encode($this->model('B_InformationInfoLedger_Model')->GetUser());
    }
    public function GetDataLedgerHarian(){
        echo json_encode($this->model('B_InformationInfoLedger_Model')->GetDataLedgerHarian($_POST));
    }
}