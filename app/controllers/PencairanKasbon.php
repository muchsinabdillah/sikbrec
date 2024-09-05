<?php
class PencairanKasbon extends Controller
{
    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Pencairan Kasbon Pegawai';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('pencairankasbon/pencairankasbon', $data);
        $this->View('templates/footer');
    }
    public function history($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'HIstory - Pencairan Kasbon Pegawai';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('pencairankasbon/historypencairankasbon', $data);
        $this->View('templates/footer');
    }
    public function EntriPencairan($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Entry Pencairan Kasbon Pegawai';
        $data['judul_child'] = 'List View';
        $data['session'] = $session; 
        $this->View('templates/header', $session);
        $this->View('pencairankasbon/EntriPencairanKasbon', $data);
        $this->View('templates/footer');
    }
    public function EntriPenyelesaian($id = null)
    {

        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Entry Realisasi Bon Sementara Pegawai';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('pencairankasbon/Entri PenyelesaianKasbon', $data);
        $this->View('templates/footer');
    }
    public function listpenyelesaian($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Outstanding Realisasi Bon Sementara';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('pencairankasbon/listpenyelesaian', $data);
        $this->View('templates/footer');
    }
    public function showOutstandingPencairan()
    {
        echo json_encode($this->model('A_PencairanKasbon_Model')->showOutstandingPencairan($_POST));
    }
    public function shwoOutstandingPenyelesaian(){
        echo json_encode($this->model('A_PencairanKasbon_Model')->shwoOutstandingPenyelesaian($_POST));
    }
    public function shwoOutstandingPenyelesaianbyPegawai(){
        echo json_encode($this->model('A_PencairanKasbon_Model')->shwoOutstandingPenyelesaianbyPegawai($_POST));
    }
    public function showOrderPencairanById(){
        echo json_encode($this->model('A_PencairanKasbon_Model')->showOrderPencairanById($_POST));
    }
    public function CreateRealisasi(){
        echo json_encode($this->model('A_PencairanKasbon_Model')->CreateRealisasi($_POST));
    }
    public function CreatePengajuanBonSementara(){
        echo json_encode($this->model('A_PencairanKasbon_Model')->CreatePengajuanBonSementara($_POST));
    }
    public function showPencairanById()
    {
        echo json_encode($this->model('A_PencairanKasbon_Model')->showPencairanById($_POST));
    }
    public function getpegawaiAllAktif(){
        echo json_encode($this->model('Pegawai_Model')->getpegawaiAllAktif_New($_POST));
    }
    public function getDataGroupBiaya(){
        echo json_encode($this->model('A_PencairanKasbon_Model')->getDataGroupBiaya($_POST));
    }
    public function CreateKasbonDetil()
    {
        echo json_encode($this->model('A_PencairanKasbon_Model')->CreateKasbonDetil($_POST));
    }
    public function showdetailPenyelesaian(){
        echo json_encode($this->model('A_PencairanKasbon_Model')->showdetailPenyelesaian($_POST));
    }
    public function deleteIdDetailKasbon(){
        echo json_encode($this->model('A_PencairanKasbon_Model')->deleteIdDetailKasbon($_POST));
    }
    public function FinishTrsPenyelesaianKasbon(){
        echo json_encode($this->model('A_PencairanKasbon_Model')->FinishTrsPenyelesaianKasbon($_POST));
    }
    public function getRekeningKas(){
        echo json_encode($this->model('A_PencairanKasbon_Model')->getRekeningKas($_POST));
    }
    public function PrintBuktiRegis($ID = '')
    {
        $data['noregistrasi'] =  Utils::setDecode($ID);
        $session = SessionManager::getCurrentSession();
        $data['listdata1'] = $this->model('BonSementara_Model')->CetakBon($ID);
        $this->View('print/finance/print_kas_pengeluaran', $data);
    }
    public function showHistoryPencairan()
    {
        echo json_encode($this->model('A_PencairanKasbon_Model')->showHistoryPencairan($_POST));
    }
    // baru
    public function listpengajuanbonsementara($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Realisasi Bon RS YARSI';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('pencairankasbon/listpengajuanbonsementara', $data);
        $this->View('templates/footer');
    }
    public function entripengajuanbonsementara($id = null)
    {

        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Entry Pengajuan Bon Sementara Pegawai';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('pencairankasbon/EntriPengajuanBonSementara', $data);
        $this->View('templates/footer');
    }
    public function batalPencairanKasbon()
    {
        echo json_encode($this->model('A_PencairanKasbon_Model')->batalPencairanKasbon($_POST));
    }
    public function batalPenyelesaianPencairanKasbon()
    {
        echo json_encode($this->model('A_PencairanKasbon_Model')->batalPenyelesaianPencairanKasbon($_POST));
    }
    
}