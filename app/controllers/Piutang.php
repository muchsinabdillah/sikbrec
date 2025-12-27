<?php
class piutang extends Controller
{
    public function index()
    {

    }
    public function listOrderPembayaranPiutang()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Order Pembayaran Piutang';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Piutang/OrderPembayaranPiutang_View', $data);
        $this->View('templates/footer');
    }
    public function getListOrderPiutangJatuhTempo()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->getListOrderPiutangJatuhTempo($_POST));
    }
    public function getOrderPiutangbyId()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->getOrderPiutangbyId($_POST));
    }
    public function getNamaPenjamin()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->getNamaPenjamin($_POST));
    }
    public function getalamatJaminan()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->getalamatJaminan($_POST));
    }
    public function newInsertTagihan()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->newInsertTagihan($_POST));
    }
    public function newInsertGennow()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->newInsertGennow($_POST));
    }
    public function VoidRegistrasi()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->VoidRegistrasi($_POST));
    }
    public function caridataPasienTagihlAll()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->caridataPasienTagihlAll($_POST));
    }
    public function bataltagih()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->bataltagih($_POST));
    }
    public function tagih()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->tagih($_POST));
    }
    public function synctransaction()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->synctransaction($_POST));
    }
    public function FinalGenerate()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->FinalGenerate($_POST));
    }
    public function getShowSyncTransaction()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->getShowSyncTransaction($_POST));
    }
    public function createOrderPiutang()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->createOrderPiutang($_POST));
    }

    public function PengirimanBerkasPiutang()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Pengiriman Berkas Piutang';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Piutang/PengirimanBerkasPiutang_View', $data);
        $this->View('templates/footer');
    }
    public function getDataBerkasPiutang()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->getDataBerkasPiutang($_POST));
    }
    public function kirimtagihan()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->kirimtagihan($_POST));
    }
    public function batalkirimtagihan()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->batalkirimtagihan($_POST));
    }

    public function kirimtagihanditerima()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->kirimtagihanditerima($_POST));
    }
    public function batalkirimtagihanditerima()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->batalkirimtagihanditerima($_POST));
    }

    public function PelunasanPiutang()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Pelunasan Piutang';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Piutang/PelunasanPiutang_View', $data);
        $this->View('templates/footer');
    }
    public function LoadDataTrsPL()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->LoadDataTrsPL($_POST));
    }
    public function LoadDataTrsOrder()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->LoadDataTrsOrder($_POST));
    }
    public function getShowDataTabelidPL()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->getShowDataTabelidPL($_POST));
    }
    public function CreateHdrPelunasanDTL()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->CreateHdrPelunasanDTL($_POST));
    }
    public function getShowDataTabelidOrderPL()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->getOrderPiutangbyId($_POST));
    }

    public function loadpelunasandetil()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->loadpelunasandetil($_POST));
    }
    public function getPelunasanPiutangDetailbyID()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->getPelunasanPiutangDetailbyID($_POST));
    }
    public function newInsertPelunasan()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->newInsertPelunasan($_POST));
    }
    public function AppendsVerifikasi()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->AppendsVerifikasi($_POST));
    }
    public function getRekening()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->getRekening($_POST));
    }
    public function VoidPL()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->VoidPL($_POST));
    }
    public function LunasAll()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->LunasAll($_POST));
    }
    public function InformasiPelunasanPiutang()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Pelunasan Piutang';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Piutang/InfoPelunasanPiutang_View', $data);
        $this->View('templates/footer');
    }
    public function loadInforekap()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->loadInforekap($_POST));
    }
    public function InformasiPiutangAging()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Aging Piutang Pasien';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Piutang/InfoPiutangAging_View', $data);
        $this->View('templates/footer');
    }
    public function getInfoAging()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->getInfoAging($_POST));
    }
    public function InfoMonitoringBerkasPenagihanPiutang()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Monitoring Berkas Penagihan Piutang';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Piutang/InfoMonitoringBerkasPenagihanPiutang_View', $data);
        $this->View('templates/footer');
    }
    public function getInfoMonitoring()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->getInfoMonitoring($_POST));
    }
    public function InfoRekapPiutangInvoice()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Rekap Piutang Invoice';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Piutang/InfoRekapPiutangInvoice_View', $data);
        $this->View('templates/footer');
    }
    public function getInfoRekapPiutangInvoice()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->getInfoRekapPiutangInvoice($_POST));
    }
    public function generateSelisihPiutang()
    {
        $session = null;
        $data['judul'] = 'Generate Selisih Piutang';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header_nologin', $session);
        $this->View('Piutang/GenerateSelisihPiutang', $data);
        $this->View('templates/footer');
    }
    public function goGenerateSelisih()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->goGenerateSelisih($_POST));
    }
    public function InformasiPiutang()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Sisa Piutang';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Piutang/InfoPiutangSisa', $data);
        $this->View('templates/footer');
    }
    public function goInformasiPiutang()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->goInformasiPiutang($_POST));
    }
    public function InformasiPiutangBelumTagih()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Piutang Belum di Tagih';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Piutang/InformasiPiutangBelumTagih', $data);
        $this->View('templates/footer');
    }
    public function goInformasiPiutangBelumTagih()
    {
        echo json_encode($this->model('I_Order_Piutang_Model')->goInformasiPiutangBelumTagih($_POST));
    }

    public function PRINTSURAT($NoJurnal = '')
    {
        $session = SessionManager::getCurrentSession();
        $data['NoJurnal'] = $NoJurnal;
        $data = $this->model('I_Order_Piutang_Model')->PrintHeaderSurat($data);
        $this->View('Piutang/hdr_printSurat', $data);

        // $this->View('print/billing/suratdanformulir/PrintPenundaanPembayaran', $data);
    }
    public function PRINTRINCIAN($NoJurnal = '')
    {
        $session = SessionManager::getCurrentSession();
        $data['NoJurnal'] = $NoJurnal;
        $data = $this->model('I_Order_Piutang_Model')->PrintHeaderRincian($data);
        $this->View('Piutang/hdr_printRincian', $data);
    }
}
