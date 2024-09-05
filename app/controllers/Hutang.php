<?php
class hutang extends Controller
{
    // public function index()
    // {
    //     $session = SessionManager::getCurrentSession();
    //     $data['judul'] = 'Bon Sementara';
    //     $data['judul_child'] = 'Edit';
    //     // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
    //     $this->View('templates/header', $session);
    //     $this->View('BonSementara/OrderBonSementara_view', $data);
    //     $this->View('templates/footer');
    // }
    public function listOrderPembayaranHutan()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Order Pembayaran Hutang';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Hutang/OrderPembayaranHutang_View', $data);
        $this->View('templates/footer');
    }


    public function PelunasanHutang($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id); 
        $data['judul'] = 'Pelunasan Hutang';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Hutang/PelunasanHutang_View', $data);
        $this->View('templates/footer');
    }

    public function ListPelunasanHutang()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Pelunasan Hutang';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Hutang/PelunasanHutang_List', $data);
        $this->View('templates/footer');
    }

    public function InformasiHutang()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Hutang';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Hutang/InformasiHutang_View', $data);
        $this->View('templates/footer');
    }
    public function InformasiRekapHutang()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Rekap Hutang';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Hutang/InformasiHutangRekap_View', $data);
        $this->View('templates/footer');
    }
    public function getHutangJatuhTempo(){
        echo json_encode($this->model('I_Order_Hutang_Model')->getHutangJatuhTempo($_POST));
    }
    public function createOrderHutang(){
        echo json_encode($this->model('I_Order_Hutang_Model')->createOrderHutang($_POST));
    }
    public function getListOrderHutangJatuhTempo(){
        echo json_encode($this->model('I_Order_Hutang_Model')->getListOrderHutangJatuhTempo($_POST));
    }
    public function getOrderHutangbyId(){
        echo json_encode($this->model('I_Order_Hutang_Model')->getOrderHutangbyId($_POST));
    }
    public function getOrderHutangDetailbyIdOrder(){
        echo json_encode($this->model('I_Order_Hutang_Model')->getOrderHutangDetailbyIdOrder($_POST));
    }
    public function getOrderHutangDetailbyId(){
        echo json_encode($this->model('I_Order_Hutang_Model')->getOrderHutangDetailbyId($_POST));
    }
    public function goVoidOrderHutang(){
        echo json_encode($this->model('I_Order_Hutang_Model')->goVoidOrderHutang($_POST));
    }
    public function createPelunasanHUtangHeader(){
        echo json_encode($this->model('I_Pelunasan_Hutang_Model')->createPelunasanHUtangHeader($_POST));
    }
    public function loadDetilPelunasanHutang(){
        echo json_encode($this->model('I_Pelunasan_Hutang_Model')->loadDetilPelunasanHutang($_POST));
    }
    public function getPelunasanHutanfDetailbyID(){
        echo json_encode($this->model('I_Pelunasan_Hutang_Model')->getPelunasanHutanfDetailbyID($_POST));
    }
    public function goEditHutangDetailPelunasan(){
        echo json_encode($this->model('I_Pelunasan_Hutang_Model')->goEditHutangDetailPelunasan($_POST));
    }
    public function goVerifikasiPelunasanHutangFinish(){
        echo json_encode($this->model('I_Pelunasan_Hutang_Model')->goVerifikasiPelunasanHutangFinish($_POST));
    } 
    public function informasiHutangDetail(){
        echo json_encode($this->model('I_Pelunasan_Hutang_Model')->informasiHutangDetail($_POST));
    } 
    public function informasiHutangRekapSisa(){
        echo json_encode($this->model('I_Pelunasan_Hutang_Model')->informasiHutangRekapSisa($_POST));
    } 
    public function getDataInformasiHutang()
    {
        echo json_encode($this->model('aInfoHutang_Model')->getDataInformasiHutang($_POST));
    }
    public function goEditHutangDetailPelunasanChecklist()
    {
        echo json_encode($this->model('I_Pelunasan_Hutang_Model')->goEditHutangDetailPelunasanChecklist($_POST));
    }
    
    public function getListPelunasanHutang(){
        echo json_encode($this->model('I_Pelunasan_Hutang_Model')->getListPelunasanHutang($_POST));
    }
    
    public function getTukarFakturHeader(){
        echo json_encode($this->model('I_Pelunasan_Hutang_Model')->getTukarFakturHeader($_POST));
    }
    public function InfoOrderPelunasanHutang()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Order Pelunasan Hutang';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Hutang/InfoOrderPelunasanHutang_View', $data);
        $this->View('templates/footer');
    }
    public function getInfoOrderPelunasanHutang()
    {
        echo json_encode($this->model('I_Pelunasan_Hutang_Model')->getInfoOrderPelunasanHutang($_POST));
    }
    public function InfoPelunasanHutangRekap()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Pelunasan Hutang Rekap';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Hutang/InfoPelunasanHutangRekap_View', $data);
        $this->View('templates/footer');
    }
    public function getInfoPelunasanHutangRekap()
    {
        echo json_encode($this->model('I_Pelunasan_Hutang_Model')->getInfoPelunasanHutangRekap($_POST));
    }
    public function InfoPelunasanHutangDetail()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Pelunasan Hutang Detail';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Hutang/InfoPelunasanHutangDetail_View', $data);
        $this->View('templates/footer');
    }
    public function getInfoPelunasanHutangDetail()
    {
        echo json_encode($this->model('I_Pelunasan_Hutang_Model')->getInfoPelunasanHutangDetail($_POST));
    }
    public function InfoPengajuanHutangRekap()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Pengajuan Hutang Rekap';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Hutang/InfoPengajuanHutangRekap_View', $data);
        $this->View('templates/footer');
    }
    public function getInfoPengajuanHutangRekap()
    {
        echo json_encode($this->model('I_Order_Hutang_Model')->getInfoPengajuanHutangRekap($_POST));
    }
    

    public function goVoidPelunasanHutang(){
        echo json_encode($this->model('I_Pelunasan_Hutang_Model')->goVoidPelunasanHutang($_POST));
    }
}
