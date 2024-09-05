<?php
class aBillingPasien extends Controller
{
    use Edocuments;
    public function index($id = null, $pkuitansi_notrs = null, $pkuitansi_jeniscetakan = null, $pkuitansi_lang = null)
    {
        try {
            $session = SessionManager::getCurrentSession();
            $data['id'] =  Utils::setDecode($id);
            $data['judul'] = 'Billing';
            $data['pkuitansi_notrs'] = $pkuitansi_notrs;
            $data['pkuitansi_jeniscetakan'] = $pkuitansi_jeniscetakan;
            $data['pkuitansi_lang'] = $pkuitansi_lang;
            // $data['judul_child'] = 'Data Pasien';
            $data['session'] = $session;
            $this->View('templates/header', $session);
            $this->View('billing/input/Billing_View', $data);
            $this->View('templates/footer');
        } catch (exception $exception) {
            $this->View('templates/header_login');
            $this->View('login/index');
            $this->View('templates/footer_login');
        }
    }

    public function BillingPayment($id = null, $pkuitansi_notrs = null, $pkuitansi_jeniscetakan = null, $pkuitansi_lang = null)
    {
        try {
            $session = SessionManager::getCurrentSession();
            $data['id'] =  Utils::setDecode($id);
            $data['judul'] = 'TRANSAKSI PEMBAYARAN KASIR';
            $data['pkuitansi_notrs'] = $pkuitansi_notrs;
            $data['pkuitansi_jeniscetakan'] = $pkuitansi_jeniscetakan;
            $data['pkuitansi_lang'] = $pkuitansi_lang;
            // $data['judul_child'] = 'Data Pasien';
            $data['session'] = $session;
            $this->View('templates/header', $session);
            $this->View('billing/input/Billing_Payment', $data);
            $this->View('templates/footer');
        } catch (exception $exception) {
            $this->View('templates/header_login');
            $this->View('login/index');
            $this->View('templates/footer_login');
        }
    }


    public function BillingClose($id = null, $pkuitansi_notrs = null, $pkuitansi_jeniscetakan = null, $pkuitansi_lang = null)
    {
        try {
            $session = SessionManager::getCurrentSession();
            $data['id'] =  Utils::setDecode($id);
            $data['judul'] = 'TRANSAKSI PENUTUPAN KASIR';
            $data['pkuitansi_notrs'] = $pkuitansi_notrs;
            $data['pkuitansi_jeniscetakan'] = $pkuitansi_jeniscetakan;
            $data['pkuitansi_lang'] = $pkuitansi_lang;
            // $data['judul_child'] = 'Data Pasien';
            $data['session'] = $session;
            $this->View('templates/header', $session);
            $this->View('billing/input/Billing_Clossing', $data);
            $this->View('templates/footer');
        } catch (exception $exception) {
            $this->View('templates/header_login');
            $this->View('login/index');
            $this->View('templates/footer_login');
        }
    }


    public function BillingDeposit($id = null, $pkuitansi_notrs = null, $pkuitansi_jeniscetakan = null, $pkuitansi_lang = null)
    {
        try {
            $session = SessionManager::getCurrentSession();
            $data['id'] =  Utils::setDecode($id);
            $data['judul'] = 'FORM DEPOSIT PASIEN';
            $data['pkuitansi_notrs'] = $pkuitansi_notrs;
            $data['pkuitansi_jeniscetakan'] = $pkuitansi_jeniscetakan;
            $data['pkuitansi_lang'] = $pkuitansi_lang;
            // $data['judul_child'] = 'Data Pasien';
            $data['session'] = $session;
            $this->View('templates/header', $session);
            $this->View('billing/input/Billing_Deposit', $data);
            $this->View('templates/footer');
        } catch (exception $exception) {
            $this->View('templates/header_login');
            $this->View('login/index');
            $this->View('templates/footer_login');
        }
    }

    public function listrajal()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Billing Rawat Jalan';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('billing/list/BillingRajalList', $data);
        $this->View('templates/footer');
    }

    public function listwalkin()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Billing Walkin';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('billing/list/BillingWalkinList', $data);
        $this->View('templates/footer');
    }

    public function listranap()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Billing Rawat Inap';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('billing/list/BillingRanapList', $data);
        $this->View('templates/footer');
    }

    public function listbebas()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Billing Penjualan Bebas';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('billing/list/BillingBebasList', $data);
        $this->View('templates/footer');
    }

    public function listvoucher()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Pembayaran Voucher Pasien';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('billing/list/BillingVoucherList', $data);
        $this->View('templates/footer');
    }

    public function getDataListBillingRajal()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataListBillingRajal($_POST));
    }

    public function getDataListBillingRajal_Arsip()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataListBillingRajal_Arsip($_POST));
    }

    public function getDataListBillingWalkin()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataListBillingWalkin($_POST));
    }

    public function getDataListBillingWalkin_Arsip()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataListBillingWalkin_Arsip($_POST));
    }

    public function getDataListBillingRanap()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataListBillingRanap($_POST));
    }

    public function getDataListBillingRanap_Arsip()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataListBillingRanap_Arsip($_POST));
    }

    public function getDataListBillingBebas()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataListBillingBebas($_POST));
    }

    public function getDataListBillingBebas_Arsip()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataListBillingBebas_Arsip($_POST));
    }

    public function getDataPasien()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataPasien($_POST));
    }

    public function getDataDetailBilling()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataDetailBilling($_POST));
    }

    public function getDataDetailBillingx()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataDetailBillingx($_POST));
    }
    public function getDataDetailRincianVoucher()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataDetailRincianVoucher($_POST));
    }
    public function getDataDetailRincianDeposit()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataDetailRincianDeposit($_POST));
    }
    public function getDataDetailRincianBilling()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataDetailRincianBilling($_POST));
    }
    public function getDataDetailRincianBillingPayment()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataDetailRincianBillingPayment($_POST));
    }

    public function getDataDetailBillbyID()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataDetailBillbyID($_POST));
    }

    public function getDataRekapBiaya()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataRekapBiaya($_POST));
    }

    public function getDataRiwayatPayment()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataRiwayatPayment($_POST));
    }

    public function getDataTarifNext()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataTarifNext($_POST));
    }

    public function getTindakanRajal()
    {
        echo json_encode($this->model('B_Billing_Model')->getTindakanRajal($_POST));
    }

    public function getTindakanRanap()
    {
        echo json_encode($this->model('B_Billing_Model')->getTindakanRanap($_POST));
    }

    public function getTarifTindakanRajal()
    {
        echo json_encode($this->model('B_Billing_Model')->getTarifTindakanRajal($_POST));
    }

    public function getTarifTindakanRanap()
    {
        echo json_encode($this->model('B_Billing_Model')->getTarifTindakanRanap($_POST));
    }

    public function getDataApproveFarmasi()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataApproveFarmasi($_POST));
    }

    public function OpenBilling()
    {
        echo json_encode($this->model('B_Billing_Model')->OpenBilling($_POST));
    }

    public function Approve()
    {
        echo json_encode($this->model('B_Billing_Model')->Approve($_POST));
    }

    public function ApproveAll()
    {
        echo json_encode($this->model('B_Billing_Model')->ApproveAll($_POST));
    }

    public function sumAllTarif()
    {
        echo json_encode($this->model('B_Billing_Model')->sumAllTarif($_POST));
    }

    public function goBatalDetailBillbyID()
    {
        echo json_encode($this->model('B_Billing_Model')->goBatalDetailBillbyID($_POST));
    }

    public function getPaymentType()
    {
        echo json_encode($this->model('B_Billing_Model')->getPaymentType());
    }

    public function getPaymentTypevoucher()
    {
        echo json_encode($this->model('B_Billing_Model')->getPaymentTypevoucher());
    }

    public function getPaymentTypeNohutang()
    {
        echo json_encode($this->model('B_Billing_Model')->getPaymentTypeNohutang());
    }

    public function getPaymentEDC()
    {
        echo json_encode($this->model('B_Billing_Model')->getEDC($_POST));
    }

    public function getKodeRekening()
    {
        echo json_encode($this->model('B_Billing_Model')->getKodeRekening($_POST));
    }

    public function SaveTrsPayment()
    {
        echo json_encode($this->model('B_Billing_Model')->SaveTrsPayment($_POST));
    }

    public function UpdateKlaimBayar()
    {
        echo json_encode($this->model('B_Billing_Model')->UpdateKlaimBayar($_POST));
    }

    public function UpdateKlaimBayarclose()
    {
        echo json_encode($this->model('B_Billing_Model')->UpdateKlaimBayarclose($_POST));
    }

    public function getDataBillClosingan()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataBillClosingan($_POST));
    }

    public function SaveTrsPayment_closing()
    {
        echo json_encode($this->model('B_Billing_Model')->SaveTrsPayment_closing($_POST));
    }

    public function SaveTrsPayment_deposit()
    {
        echo json_encode($this->model('B_Billing_Model')->SaveTrsPayment_deposit($_POST));
    }

    public function InfoHarianRanap()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Billing Harian Rawat Inap';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/billing/InformationBillHarianRanap', $data);
        $this->View('templates/footer');
    }

    public function getDataListInfoBillHarianRanap()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataListInfoBillHarianRanap($_POST));
    }

    public function PrintKuitansixxx($lang = '', $kodereg = '', $notrs = '')
    {
        try {
            $session = SessionManager::getCurrentSession();
            $data['notrs'] = $notrs;
            $data['kodereg'] = $kodereg;
            $data['lang'] = $lang;


            if ($kodereg == 'RJ') {
                $judul = 'KUITANSI RAWAT JALAN';
                $judul_eng = 'OUTPATIENT RECEIPT';
            } elseif ($kodereg == 'RI') {
                $judul = 'KUITANSI RAWAT INAP';
                $judul_eng = 'INPATIENT RECEIPT';
            } elseif ($kodereg == 'PB') {
                $judul = 'KUITANSI PEMBELIAN OBAT BEBAS';
                $judul_eng = 'RECIPE RECEIPT';
            } else {
                $judul = 'KUITANSI';
                $judul_eng = 'RECEIPT';
            }
            $data['judul'] = $judul;
            $data['judul_eng'] = $judul_eng;
            // update cetakan ke
            //$this->model('B_Billing_Model')->goUpdateCetakanbyID($data);
            // get data header and detail
            $data['listdataheader'] = $this->model('B_Billing_Model')->PrintKuitansiHeaderbyID($data);
            $data['listdatadetail'] = $this->model('B_Billing_Model')->PrintKuitansiDetailbyID($data);
            $total = 0;
            foreach ($data['listdatadetail'] as $row) {
                $total = $row['TotalPaidRaw'];
            }
            if ($data['lang'] == 'EN') {
                $data['terbilang'] = $this->model('B_Billing_Model')->terbilang_eng($total);
            } else {
                $data['terbilang'] = $this->model('B_Billing_Model')->terbilang($total);
            }
            // get sign user
            $data['id_employee'] = $data['listdataheader']['Id_Kasir'];
            $data['listdatasign'] = $this->model('B_Billing_Model')->GetSignUser($data);
            //get uuid4
            $data['uuid4'] = Utils::uuid4str();
            //cetakan ke
            $data['jeniscetakan'] = 'KUITANSI';
            $data['cetakanke'] = $this->model('B_Billing_Model')->GetCetakanKe($data);
            //return view
            //$this->View('print/billing/kuitansi/print_kuitansi', $data);
            $data['filedoc'] = 'print/billing/kuitansi/hdr_kuitansi';
            $this->PrintFile($data);
        } catch (exception $exception) {
            $this->View('templates/header_login');
            $this->View('login/index');
            $this->View('templates/footer_login');
        }
    }

    public function PrintKuitansi($lang = '', $kodereg = '', $notrs = '')
    {
        try {

            $session = SessionManager::getCurrentSession();

            $data['notrs'] = $notrs;
            $data['kodereg'] = $kodereg;
            $data['lang'] = $lang;

            // var_dump($data['notrs']);
            // exit;

            if ($kodereg == 'RJ') {
                $judul = 'KUITANSI RAWAT JALAN';
                $judul_eng = 'OUTPATIENT RECEIPT';
            } elseif ($kodereg == 'RI') {
                $judul = 'KUITANSI RAWAT INAP';
                $judul_eng = 'INPATIENT RECEIPT';
            } elseif ($kodereg == 'PB') {
                $judul = 'KUITANSI PEMBELIAN OBAT BEBAS';
                $judul_eng = 'RECIPE RECEIPT';
            } else {
                $judul = 'KUITANSI';
                $judul_eng = 'RECEIPT';
            }
            $data['judul'] = $judul;
            $data['judul_eng'] = $judul_eng;


            // update cetakan ke
            //$this->model('B_Billing_Model')->goUpdateCetakanbyID($data);
            // get data header and detail
            $data['listdataheader'] = $this->model('B_Billing_Model')->PrintKuitansiHeaderbyIDX($data);
            $data['listdatadetail'] = $this->model('B_Billing_Model')->PrintKuitansiDetailbyIDX($data);
            $total = 0;

            $total = $data['listdataheader']['TotalPaid'];

            if ($data['lang'] == 'EN') {
                $data['terbilang'] = $this->model('B_Billing_Model')->terbilang_eng($total);
            } else {
                $data['terbilang'] = $this->model('B_Billing_Model')->terbilang($total);
            }

            // var_dump($data['terbilang']);
            // exit;

            // get sign user
            $data['id_employee'] = '';
            // $data['listdatasign'] = $this->model('B_Billing_Model')->GetSignUser($data);
            //get uuid4
            $data['uuid4'] = Utils::uuid4str();
            //return view
            $this->View('print/billing/kuitansi/print_kuitansi', $data);
        } catch (exception $exception) {
            $this->View('templates/header_login');
            $this->View('login/index');
            $this->View('templates/footer_login');
        }
    }

    public function PrintKuitansiDetail($lang = '', $kodereg = '', $notrs = '')
    {
        try {

            $session = SessionManager::getCurrentSession();

            $data['notrs'] = $notrs;
            $data['kodereg'] = $kodereg;
            $data['lang'] = $lang;

            // var_dump($data['lang']);
            // exit;

            if ($kodereg == 'RJ') {
                $judul = 'KUITANSI RAWAT JALAN';
                $judul_eng = 'OUTPATIENT RECEIPT';
            } elseif ($kodereg == 'RI') {
                $judul = 'KUITANSI RAWAT INAP';
                $judul_eng = 'INPATIENT RECEIPT';
            } elseif ($kodereg == 'PB') {
                $judul = 'KUITANSI PEMBELIAN OBAT BEBAS';
                $judul_eng = 'RECIPE RECEIPT';
            } else {
                $judul = 'KUITANSI';
                $judul_eng = 'RECEIPT';
            }
            $data['judul'] = $judul;
            $data['judul_eng'] = $judul_eng;


            // update cetakan ke
            //$this->model('B_Billing_Model')->goUpdateCetakanbyID($data);
            // get data header and detail
            $data['listdataheader'] = $this->model('B_Billing_Model')->PrintKuitansiHeaderbyIDX($data);
            $data['listdatadetail'] = $this->model('B_Billing_Model')->PrintKuitansiDetailbyIDX($data);
            $total = 0;
            $total = $data['listdataheader']['TotalPaid'];

            if ($data['lang'] == 'EN') {
                $data['terbilang'] = $this->model('B_Billing_Model')->terbilang_eng($total);
            } else {
                $data['terbilang'] = $this->model('B_Billing_Model')->terbilang($total);
            }

            // var_dump($data['terbilang']);
            // exit;

            // get sign user
            // $data['id_employee'] = $data['listdataheader']['Id_Kasir'];

            $data['id_employee'] = $session->IDEmployee;
            $data['listdatasign'] = $this->model('B_Billing_Model')->GetSignUser($data);
            //get uuid4
            $data['uuid4'] = Utils::uuid4str();
            //return view
            $this->View('print/billing/kuitansi/print_kuitansidetail', $data);
        } catch (exception $exception) {
            $this->View('templates/header_login');
            $this->View('login/index');
            $this->View('templates/footer_login');
        }
    }


    public function PrintKuitansiAll($kodereg = '', $notrs = '')
    {
        try {

            $session = SessionManager::getCurrentSession();

            $data['notrs'] = $notrs;
            $data['kodereg'] = $kodereg;
            // $data['lang'] = $lang;

            // var_dump($data['lang']);
            // exit;

            if ($kodereg == 'RJ') {
                $judul = 'KUITANSI RAWAT JALAN';
                $judul_eng = 'OUTPATIENT RECEIPT';
            } elseif ($kodereg == 'RI') {
                $judul = 'KUITANSI RAWAT INAP';
                $judul_eng = 'INPATIENT RECEIPT';
            } elseif ($kodereg == 'PB') {
                $judul = 'KUITANSI PEMBELIAN OBAT BEBAS';
                $judul_eng = 'RECIPE RECEIPT';
            } else {
                $judul = 'KUITANSI';
                $judul_eng = 'RECEIPT';
            }
            $data['judul'] = $judul;
            $data['judul_eng'] = $judul_eng;


            // update cetakan ke
            //$this->model('B_Billing_Model')->goUpdateCetakanbyID($data);
            // get data header and detail
            $data['listdataheader'] = $this->model('B_Billing_Model')->PrintKuitansiHeaderbyAll($data);
            $data['listdatadetail'] = $this->model('B_Billing_Model')->PrintKuitansiDetailbyAll($data);
            $total = 0;
            $total = $data['listdataheader']['TotalPaid'];

            // if ($data['lang'] == 'EN') {
            //     $data['terbilang'] = $this->model('B_Billing_Model')->terbilang_eng($total);
            // } else {
            //     $data['terbilang'] = $this->model('B_Billing_Model')->terbilang($total);
            // }
            $data['terbilang'] = $this->model('B_Billing_Model')->terbilang($total);
            // var_dump($data['terbilang']);
            // exit;

            // get sign user
            // $data['id_employee'] = $data['listdataheader']['Id_Kasir'];

            $data['id_employee'] = $session->IDEmployee;
            // $data['nama_employe'] = $session->name;
            $data['listdatasign'] = $this->model('B_Billing_Model')->GetSignUser($data);
            //get uuid4
            $data['uuid4'] = Utils::uuid4str();
            //return view
            $this->View('print/billing/kuitansi/print_kuitansidetail', $data);
        } catch (exception $exception) {
            $this->View('templates/header_login');
            $this->View('login/index');
            $this->View('templates/footer_login');
        }
    }

    public function PrintKuitansi2($NO_KWITANSI, $TIPE_PEMBAYARAN, $NOMINAL_BAYAR, $USER_KASIR, $BILLTO, $NO_TRS, $NamaTest)
    {
        // var_dump($NO_KWITANSI);
        // exit;
        try {
            $session = SessionManager::getCurrentSession();
            $data['notrs'] = $NO_KWITANSI;
            $data['kodereg'] = $TIPE_PEMBAYARAN;
            $data['lang'] = $NOMINAL_BAYAR;
            // if ($kodereg == 'RJ') {
            //     $judul = 'KUITANSI RAWAT JALAN';
            //     $judul_eng = 'OUTPATIENT RECEIPT';
            // } elseif ($kodereg == 'RI') {
            //     $judul = 'KUITANSI RAWAT INAP';
            //     $judul_eng = 'INPATIENT RECEIPT';dfs
            // } elseif ($kodereg == 'PB') {
            //     $judul = 'KUITANSI PEMBELIAN OBAT BEBAS';
            //     $judul_eng = 'RECIPE RECEIPT';
            // } else {
            //     $judul = 'KUITANSI';
            //     $judul_eng = 'RECEIPT';
            // }
            $data['judul'] = 'KUITANSI';
            $data['judul_eng'] = 'RECEIPT';
            // update cetakan ke
            //$this->model('B_Billing_Model')->goUpdateCetakanbyID($data);
            // get data header and detail
            $data['listdataheader'] = $this->model('B_Billing_Model')->PrintKuitansiHeaderbyID($data);
            $data['listdatadetail'] = $this->model('B_Billing_Model')->PrintKuitansiDetailbyID($data);
            // get sign user
            $data['id_employee'] = $USER_KASIR;
            $data['listdatasign'] = $this->model('B_Billing_Model')->GetSignUser($data);
            //get uuid4
            $data['uuid4'] = Utils::uuid4str();
            //return view
            $this->View('print/billing/kuitansi/print_kuitansi', $data);
        } catch (exception $exception) {
            $this->View('templates/header_login');
            $this->View('login/index');
            $this->View('templates/footer_login');
        }
    }

    public function PrintKuitansiRekap($lang = '', $kodereg = '', $notrs = '')
    {
        try {
            $session = SessionManager::getCurrentSession();
            $data['notrs'] = $notrs;
            $data['kodereg'] = $kodereg;
            $data['lang'] = $lang;
            if ($kodereg == 'RJ') {
                $judul = 'KUITANSI TOTAL RAWAT JALAN';
                $judul_eng = 'OUTPATIENT RECEIPT';
            } elseif ($kodereg == 'RI') {
                $judul = 'KUITANSI TOTAL RAWAT INAP';
                $judul_eng = 'INPATIENT RECEIPT';
            } elseif ($kodereg == 'PB') {
                $judul = 'KUITANSI TOTAL PEMBELIAN OBAT BEBAS';
                $judul_eng = 'RECIPE RECEIPT';
            } else {
                $judul = 'REKAP KUITANSI';
                $judul_eng = 'RECEIPT';
            }
            $data['judul'] = $judul;
            $data['judul_eng'] = $judul_eng;
            // update cetakan ke
            //$this->model('B_Billing_Model')->goUpdateCetakan($data);
            // get data header and detail
            $data['listdataheader'] = $this->model('B_Billing_Model')->PrintKuitansiHeaderbyReg($data);
            $data['listdatadetail'] = $this->model('B_Billing_Model')->PrintKuitansiDetailbyReg($data);
            //get terbilang and total
            $total = 0;
            foreach ($data['listdatadetail'] as $row) {
                $total = $row['TotalPaidRaw'];
            }
            if ($data['lang'] == 'EN') {
                $data['terbilang'] = $this->model('B_Billing_Model')->terbilang_eng($total);
            } else {
                $data['terbilang'] = $this->model('B_Billing_Model')->terbilang($total);
            }
            // get sign user
            $data['id_employee'] = $data['listdataheader']['Id_Kasir'];
            $data['listdatasign'] = $this->model('B_Billing_Model')->GetSignUser($data);
            //get uuid4
            $data['uuid4'] = Utils::uuid4str();
            //cetakan ke
            $data['jeniscetakan'] = 'KUITANSIREKAP';
            $data['cetakanke'] = $this->model('B_Billing_Model')->GetCetakanKe($data);
            //return view
            //$this->View('print/billing/kuitansirekap/print_kuitansirekap', $data);
            $data['filedoc'] = 'print/billing/kuitansirekap/hdr_kuitansirekap';
            $this->PrintFile($data);
        } catch (exception $exception) {
            $this->View('templates/header_login');
            $this->View('login/index');
            $this->View('templates/footer_login');
        }
    }

    public function SaveKuitansi()
    {
        $data['notrs'] = $_POST['notrs'];
        $data['kodereg'] = $_POST['kodereg'];
        $data['lang'] = $_POST['lang'];
        if ($data['kodereg'] == 'RJ') {
            $judul = 'KUITANSI RAWAT JALAN';
            $judul_eng = 'OUTPATIENT RECEIPT';
        } elseif ($data['kodereg'] == 'RI') {
            $judul = 'KUITANSI RAWAT INAP';
            $judul_eng = 'INPATIENT RECEIPT';
        } elseif ($data['kodereg'] == 'PB') {
            $judul = 'KUITANSI PEMBELIAN OBAT BEBAS';
            $judul_eng = 'RECIPE RECEIPT';
        } else {
            $judul = 'KUITANSI';
            $judul_eng = 'RECEIPT';
        }
        $data['judul'] = $judul;
        $data['judul_eng'] = $judul_eng;
        $data['GrupTransaksi'] = $_POST['jeniscetakan'];
        $data['listdataheader'] = $this->model('B_Billing_Model')->PrintKuitansiHeaderbyID($data);
        $data['listdatadetail'] = $this->model('B_Billing_Model')->PrintKuitansiDetailbyID($data);
        // get sign user
        $data['id_employee'] = $data['listdataheader']['Id_Kasir'];
        $data['listdatasign'] = $this->model('B_Billing_Model')->GetSignUser($data);
        //get uuid4
        $data['uuid4'] = Utils::uuid4str();
        //cetakan ke
        $data['jeniscetakan'] = 'KUITANSI';
        $data['cetakanke'] = $this->model('B_Billing_Model')->GetCetakanKe($data);
        //$data['filename'] = $this->View('print/billing/kuitansi/save_kuitansi', $data);
        $data['filedoc'] = 'print/billing/kuitansi/hdr_kuitansi';
        $data['filename'] = $this->SaveFile($data);
        echo json_encode($this->model('B_Billing_Model')->uploadAWS($data));
    }

    // public function SendMailKuitansi()
    // {
    //     $data['notrs'] = $_POST['notrs'];
    //     $data['jeniscetakan'] = $_POST['jeniscetakan'];
    //     $data['noregistrasi'] = $_POST['noregistrasi'];
    //     $data['judul'] = 'Send Kuitansi';
    //     $session = SessionManager::getCurrentSession();
    //     $data['listdata1'] = $this->model('B_Billing_Model')->getAWSURL($data);
    //     $this->View('print/billing/kuitansi/sendmail_kuitansi', $data);
    // }

    public function SaveKuitansiRekap()
    {
        $data['notrs'] = $_POST['notrs'];
        $data['kodereg'] = $_POST['kodereg'];
        $data['lang'] = $_POST['lang'];
        if ($data['kodereg'] == 'RJ') {
            $judul = 'KUITANSI TOTAL RAWAT JALAN';
            $judul_eng = 'OUTPATIENT RECEIPT';
        } elseif ($data['kodereg'] == 'RI') {
            $judul = 'KUITANSI TOTAL RAWAT INAP';
            $judul_eng = 'INPATIENT RECEIPT';
        } elseif ($data['kodereg'] == 'PB') {
            $judul = 'KUITANSI TOTAL PEMBELIAN OBAT BEBAS';
            $judul_eng = 'RECIPE RECEIPT';
        } else {
            $judul = 'REKAP KUITANSI';
            $judul_eng = 'RECEIPT';
        }
        $data['judul'] = $judul;
        $data['judul_eng'] = $judul_eng;
        $data['GrupTransaksi'] = $_POST['jeniscetakan'];
        $data['listdataheader'] = $this->model('B_Billing_Model')->PrintKuitansiHeaderbyReg($data);
        $data['listdatadetail'] = $this->model('B_Billing_Model')->PrintKuitansiDetailbyReg($data);
        // get sign user
        $data['id_employee'] = $data['listdataheader']['Id_Kasir'];
        $data['listdatasign'] = $this->model('B_Billing_Model')->GetSignUser($data);
        //get uuid4
        $data['uuid4'] = Utils::uuid4str();
        //cetakan ke
        $data['jeniscetakan'] = 'KUITANSIREKAP';
        $data['cetakanke'] = $this->model('B_Billing_Model')->GetCetakanKe($data);
        //$data['filename'] = $this->View('print/billing/kuitansirekap/save_kuitansirekap', $data);
        $data['filedoc'] = 'print/billing/kuitansirekap/hdr_kuitansirekap';
        $data['filename'] = $this->SaveFile($data);
        echo json_encode($this->model('B_Billing_Model')->uploadAWS($data));
    }

    // public function SendMailKuitansiRekap()
    // {
    //     $data['notrs'] = $_POST['notrs'];
    //     $data['jeniscetakan'] = $_POST['jeniscetakan'];
    //     $data['noregistrasi'] = $_POST['noregistrasi'];
    //     $data['judul'] = 'Send Kuitansi';
    //     $session = SessionManager::getCurrentSession();
    //     $data['listdata1'] = $this->model('B_Billing_Model')->getAWSURL($data);
    //     $this->View('print/billing/kuitansirekap/sendmail_kuitansirekap', $data);
    // }

    public function CountCetak()
    {
        //echo json_encode($this->model('B_Billing_Model')->CountCetak($_POST));
        $callback = [
            'status' => 200,
            'message' => 'Berhasil Simpan!'
        ];
        //return $callback;
        echo json_encode($callback);
    }

    public function PrintRincianPB($lang = '', $kodereg = '', $notrs = '', $periode_awal = '', $periode_akhir = '')
    {
        try {
            $session = SessionManager::getCurrentSession();
            $data['notrs'] = $notrs;
            $data['kodereg'] = 'PB';
            $data['lang'] = $lang;
            $data['periode_awal'] = $periode_awal;
            $data['periode_akhir'] = $periode_akhir;
            $data['judul'] = 'RINCIAN BIAYA PEMBELIAN BEBAS';
            // get data header and detail
            $data['listdataheader'] = $this->model('B_Billing_Model')->PrintRincianHeaderbyReg($data);
            $data['listdetail_obat'] = $this->model('B_Billing_Model')->PrintRincianObatbyReg($data);
            $data['listdata_payment'] = $this->model('B_Billing_Model')->PrintKuitansiDetailbyReg($data);
            // get sign user
            $data['id_employee'] = $session->IDEmployee;
            $data['listdatasign'] = $this->model('B_Billing_Model')->GetSignUser($data);
            //get uuid4
            $data['uuid4'] = Utils::uuid4str();
            //cetakan ke
            $data['jeniscetakan'] = 'RINCIANBIAYA_PB';
            $data['cetakanke'] = $this->model('B_Billing_Model')->GetCetakanKe($data);
            //return view
            $this->View('print/billing/rincianbiaya/print_rincianbiaya_pb', $data);
        } catch (exception $exception) {
            $this->View('templates/header_login');
            $this->View('login/index');
            $this->View('templates/footer_login');
        }
    }

    public function PrintRincianRJ($lang = '', $notrs = '', $periode_awal = '', $periode_akhir = '')
    {
        try {
            $session = SessionManager::getCurrentSession();
            $data['notrs'] = $notrs;
            $kodereg = substr($notrs, 0, 2);
            $data['kodereg'] = $kodereg;
            $data['lang'] = $lang;
            $data['periode_awal'] = $periode_awal;
            $data['periode_akhir'] = $periode_akhir;
            //$data['judul_eng'] = $judul_eng;
            // get data header and detail
            $data['listdataheader'] = $this->model('B_Billing_Model')->PrintRincianHeaderbyReg($data);
            // $data['listdetail_klinik'] = $this->model('B_Billing_Model')->PrintRincianKlinikbyReg($data);
            $data['listdetail_pay'] = $this->model('B_Billing_Model')->PrintRincianpaybyReg($data);
            // $data['listdetail_operasi'] = $this->model('B_Billing_Model')->PrintRincianOperasibyReg($data);
            // $data['listdetail_lab'] = $this->model('B_Billing_Model')->PrintRincianLabbyReg($data);
            // $data['listdetail_radiologi'] = $this->model('B_Billing_Model')->PrintRincianRadiologibyReg($data);
            // $data['listdetail_mcu'] = $this->model('B_Billing_Model')->PrintRincianMCUbyReg($data);
            // $data['listdetail_bhp'] = $this->model('B_Billing_Model')->PrintRincianBhpbyReg($data);
            // $data['listdetail_obat'] = $this->model('B_Billing_Model')->PrintRincianObatbyReg($data);
            // $data['listdetail_retur'] = $this->model('B_Billing_Model')->PrintRincianReturbyReg($data);
            $data['listdata_payment'] = $this->model('B_Billing_Model')->PrintKuitansiDetailbyReg($data);
            // get sign user
            $data['id_employee'] = $session->IDEmployee;
            $data['listdatasign'] = $this->model('B_Billing_Model')->GetSignUser($data);
            //get uuid4
            $data['uuid4'] = Utils::uuid4str();
            //cetakan ke
            $data['jeniscetakan'] = 'RINCIANBIAYA_RJ';
            $data['cetakanke'] = $this->model('B_Billing_Model')->GetCetakanKe($data);
            //return view
            $this->View('print/billing/rincianbiaya/print_rincianbiaya_rj', $data);
        } catch (exception $exception) {
            $this->View('templates/header_login');
            $this->View('login/index');
            $this->View('templates/footer_login');
        }
    }

    public function PrintRincianxRJ($lang = '', $notrs = '')
    {
        try {

            // var_dump($notrs);
            // exit;
            $session = SessionManager::getCurrentSession();
            $data['notrs'] = $notrs;
            $kodereg = substr($notrs, 0, 2);
            $data['kodereg'] = $kodereg;
            $data['lang'] = $lang;
            $data['periode_awal'] = '';
            $data['periode_akhir'] = '';

            $data['listdataheader'] = $this->model('B_Billing_Model')->PrintRincianHeaderbyReg($data);



            $data['listdetail_pay'] = $this->model('B_Billing_Model')->PrintRincianpaybyRegidtrs($data);

            // var_dump($data['listdetail_pay']);
            // exit;

            $data['listdata_payment'] = $this->model('B_Billing_Model')->PrintKuitansiDetailbyRegidtrs($data);
            // var_dump($data['listdata_payment']);
            // exit;
            // get sign user
            $data['id_employee'] = $session->IDEmployee;
            $data['listdatasign'] = $this->model('B_Billing_Model')->GetSignUser($data);
            //get uuid4
            $data['uuid4'] = Utils::uuid4str();
            //return view
            $this->View('print/billing/rincianbiaya/print_rincianbiaya_rj', $data);
        } catch (exception $exception) {
            $this->View('templates/header_login');
            $this->View('login/index');
            $this->View('templates/footer_login');
        }
    }

    public function PrintRinciandetailRJ($lang = '', $notrs = '')
    {
        try {
            // var_dump($lang);
            // exit;
            $session = SessionManager::getCurrentSession();
            $data['notrs'] = $notrs;
            $kodereg = substr($notrs, 0, 2);
            $data['kodereg'] = $kodereg;
            $data['lang'] = $lang;
            $data['periode_awal'] = '';
            $data['periode_akhir'] = '';
            $data['listdataheader'] = $this->model('B_Billing_Model')->PrintRincianHeaderbyReg($data);
            $data['listdetail_pay'] = $this->model('B_Billing_Model')->PrintRincianpaybyRegidtrs($data);
            // var_dump($data['listdetail_pay']);
            // exit;
            $data['listdata_payment'] = $this->model('B_Billing_Model')->PrintKuitansiDetailbyRegidtrs($data);
            // var_dump($data['listdata_payment']);
            // exit;
            // get sign user
            $data['id_employee'] = $session->IDEmployee;
            $data['listdatasign'] = $this->model('B_Billing_Model')->GetSignUser($data);
            //get uuid4
            $data['uuid4'] = Utils::uuid4str();
            //return view
            $this->View('print/billing/rincianbiaya/print_rincianbiayadetail_rj', $data);
        } catch (exception $exception) {
            $this->View('templates/header_login');
            $this->View('login/index');
            $this->View('templates/footer_login');
        }
    }
    public function PrintRincianAllRJ($notrs = '')
    {
        try {
            // var_dump($lang);
            // exit;
            $session = SessionManager::getCurrentSession();
            $data['notrs'] = $notrs;
            $kodereg = substr($notrs, 0, 2);
            $data['kodereg'] = $kodereg;
            // $data['lang'] = $lang;
            $data['periode_awal'] = '';
            $data['periode_akhir'] = '';
            $data['listdataheader'] = $this->model('B_Billing_Model')->PrintRincianHeaderbyRegAll($data);
            $data['listdetail_pay'] = $this->model('B_Billing_Model')->PrintRincianpaybyRegidtrsALL($data);
            // var_dump($data['listdetail_pay']);
            // exit;
            $data['listdata_payment'] = $this->model('B_Billing_Model')->PrintKuitansiDetailbyRegidtrsAll($data);
            // var_dump($data['listdata_payment']);
            // exit;
            // get sign user
            $data['id_employee'] = $session->IDEmployee;
            $data['listdatasign'] = $this->model('B_Billing_Model')->GetSignUser($data);
            //get uuid4
            $data['uuid4'] = Utils::uuid4str();
            //return view
            $this->View('print/billing/rincianbiaya/print_rincianbiayadetail_rj', $data);
        } catch (exception $exception) {
            $this->View('templates/header_login');
            $this->View('login/index');
            $this->View('templates/footer_login');
        }
    }
    // public function PrintRincianRJnew($lang = '', $notrs = '', $periode_awal = '', $periode_akhir = '')
    // {
    //     try {
    //         $session = SessionManager::getCurrentSession();
    //         $data['notrs'] = $notrs;
    //         $kodereg = substr($notrs, 0, 2);
    //         $data['kodereg'] = $kodereg;
    //         $data['lang'] = $lang;
    //         $data['periode_awal'] = $periode_awal;
    //         $data['periode_akhir'] = $periode_akhir;
    //         //$data['judul_eng'] = $judul_eng;
    //         // get data header and detail
    //         $data['listdataheader'] = $this->model('B_Billing_Model')->PrintRincianHeaderbyReg($data);

    //         // $data['listdetail_klinik'] = $this->model('B_Billing_Model')->PrintRincianKlinikbyReg($data);
    //         // $data['listdetail_operasi'] = $this->model('B_Billing_Model')->PrintRincianOperasibyReg($data);
    //         // $data['listdetail_lab'] = $this->model('B_Billing_Model')->PrintRincianLabbyReg($data);
    //         // $data['listdetail_radiologi'] = $this->model('B_Billing_Model')->PrintRincianRadiologibyReg($data);
    //         // $data['listdetail_mcu'] = $this->model('B_Billing_Model')->PrintRincianMCUbyReg($data);
    //         // $data['listdetail_bhp'] = $this->model('B_Billing_Model')->PrintRincianBhpbyReg($data);
    //         // $data['listdetail_obat'] = $this->model('B_Billing_Model')->PrintRincianObatbyReg($data);
    //         // $data['listdetail_retur'] = $this->model('B_Billing_Model')->PrintRincianReturbyReg($data);
    //         // $data['listdata_payment'] = $this->model('B_Billing_Model')->PrintKuitansiDetailbyReg($data);
    //         // get sign user
    //         $data['id_employee'] = $session->IDEmployee;
    //         $data['listdatasign'] = $this->model('B_Billing_Model')->GetSignUser($data);
    //         //get uuid4
    //         $data['uuid4'] = Utils::uuid4str();
    //         //return view
    //         $this->View('print/billing/rincianbiaya/print_rincianbiaya_rjnew', $data);
    //     } catch (exception $exception) {
    //         $this->View('templates/header_login');
    //         $this->View('login/index');
    //         $this->View('templates/footer_login');
    //     }
    // }

    public function PrintRincianRI($lang = '', $notrs = '', $periode_awal = '', $periode_akhir = '')
    {
        try {
            $session = SessionManager::getCurrentSession();
            $data['notrs'] = $notrs;
            $kodereg = substr($notrs, 0, 2);
            $data['kodereg'] = $kodereg;
            $data['lang'] = $lang;
            $data['periode_awal'] = $periode_awal;
            $data['periode_akhir'] = $periode_akhir;
            $data['judul'] = 'RINCIAN BIAYA RAWAT INAP';
            //$data['judul_eng'] = $judul_eng;
            // get data header and detail
            $data['listdataheader'] = $this->model('B_Billing_Model')->PrintRincianHeaderbyReg($data);
            $data['listdetail_visit'] = $this->model('B_Billing_Model')->PrintRincianVisitbyReg($data);
            $data['listdetail_paketop'] = $this->model('B_Billing_Model')->PrintRincianPaketOPbyReg($data);
            $data['listdetail_kamar'] = $this->model('B_Billing_Model')->PrintRincianKamarbyReg($data);
            $data['listdetail_operasi'] = $this->model('B_Billing_Model')->PrintRincianOperasibyReg($data);
            $data['listdetail_lab'] = $this->model('B_Billing_Model')->PrintRincianLabbyReg($data);
            $data['listdetail_radiologi'] = $this->model('B_Billing_Model')->PrintRincianRadiologibyReg($data);
            $data['listdetail_bhp'] = $this->model('B_Billing_Model')->PrintRincianBhpbyReg($data);
            $data['listdetail_obat'] = $this->model('B_Billing_Model')->PrintRincianObatbyReg($data);
            $data['listdetail_retur'] = $this->model('B_Billing_Model')->PrintRincianReturbyReg($data);
            $data['listdata_payment'] = $this->model('B_Billing_Model')->PrintKuitansiDetailbyReg($data);
            //Get bill RAJAL
            if ($data['listdataheader']['NoRegisRWJ'] != null) {
                $data['notrs'] = $data['listdataheader']['NoRegisRWJ'];
                $data['listdetail_klinik_rj'] = $this->model('B_Billing_Model')->PrintRincianKlinikbyReg($data);
                $data['listdetail_operasi_rj'] = $this->model('B_Billing_Model')->PrintRincianOperasibyReg($data);
                $data['listdetail_lab_rj'] = $this->model('B_Billing_Model')->PrintRincianLabbyReg($data);
                $data['listdetail_radiologi_rj'] = $this->model('B_Billing_Model')->PrintRincianRadiologibyReg($data);
                $data['listdetail_farmasi_rj'] = $this->model('B_Billing_Model')->PrintRincianFarmasibyReg($data);
            }
            // get sign user
            $data['id_employee'] = $session->IDEmployee;
            //get uuid4
            $data['uuid4'] = Utils::uuid4str();
            //cetakan ke
            $data['jeniscetakan'] = 'RINCIANBIAYA_RI';
            $data['cetakanke'] = $this->model('B_Billing_Model')->GetCetakanKe($data);
            $data['listdatasign'] = $this->model('B_Billing_Model')->GetSignUser($data);
            //return view
            $this->View('print/billing/rincianbiaya/print_rincianbiaya_ri', $data);
        } catch (exception $exception) {
            $this->View('templates/header_login');
            $this->View('login/index');
            $this->View('templates/footer_login');
        }
    }

    public function SaveRincianPB()
    {
        try {
            $session = SessionManager::getCurrentSession();
            $data['notrs'] = $_POST['notrs'];
            $data['kodereg'] = 'PB';
            $data['lang'] = $_POST['lang'];
            $data['periode_awal'] = $_POST['periode_awal'];
            $data['periode_akhir'] = $_POST['periode_akhir'];
            $data['judul'] = 'RINCIAN BIAYA PEMBELIAN BEBAS';
            // get data header and detail
            $data['listdataheader'] = $this->model('B_Billing_Model')->PrintRincianHeaderbyReg($data);
            $data['listdetail_obat'] = $this->model('B_Billing_Model')->PrintRincianObatbyReg($data);
            $data['listdata_payment'] = $this->model('B_Billing_Model')->PrintKuitansiDetailbyReg($data);
            // get sign user
            $data['id_employee'] = $session->IDEmployee;
            $data['listdatasign'] = $this->model('B_Billing_Model')->GetSignUser($data);
            //return view
            $data['GrupTransaksi'] = $_POST['jeniscetakan'];
            //get uuid4
            $data['uuid4'] = Utils::uuid4str();
            //cetakan ke
            $data['jeniscetakan'] = 'RINCIANBIAYA_PB';
            $data['cetakanke'] = $this->model('B_Billing_Model')->GetCetakanKe($data);
            // $data['filename'] = $this->View('print/billing/rincianbiaya/save_rincianbiaya_pb', $data);
            $data['filedoc'] = 'print/billing/rincianbiaya/hdr_rincianbiaya_pb';
            $data['filename'] = $this->SaveFile($data);
            echo json_encode($this->model('B_Billing_Model')->uploadAWS($data));
        } catch (exception $exception) {
            $this->View('templates/header_login');
            $this->View('login/index');
            $this->View('templates/footer_login');
        }
    }

    public function SaveRincianRJ()
    {
        try {
            $session = SessionManager::getCurrentSession();
            $data['notrs'] = $_POST['notrs'];
            $kodereg = substr($_POST['notrs'], 0, 2);
            $data['kodereg'] = $_POST['kodereg'];
            $data['lang'] = $_POST['lang'];
            $data['periode_awal'] = $_POST['periode_awal'];
            $data['periode_akhir'] = $_POST['periode_akhir'];
            //$data['judul_eng'] = $judul_eng;
            // get data header and detail
            $data['listdataheader'] = $this->model('B_Billing_Model')->PrintRincianHeaderbyReg($data);
            $data['listdetail_klinik'] = $this->model('B_Billing_Model')->PrintRincianKlinikbyReg($data);
            $data['listdetail_operasi'] = $this->model('B_Billing_Model')->PrintRincianOperasibyReg($data);
            $data['listdetail_lab'] = $this->model('B_Billing_Model')->PrintRincianLabbyReg($data);
            $data['listdetail_radiologi'] = $this->model('B_Billing_Model')->PrintRincianRadiologibyReg($data);
            $data['listdetail_mcu'] = $this->model('B_Billing_Model')->PrintRincianMCUbyReg($data);
            $data['listdetail_bhp'] = $this->model('B_Billing_Model')->PrintRincianBhpbyReg($data);
            $data['listdetail_obat'] = $this->model('B_Billing_Model')->PrintRincianObatbyReg($data);
            $data['listdetail_retur'] = $this->model('B_Billing_Model')->PrintRincianReturbyReg($data);
            $data['listdata_payment'] = $this->model('B_Billing_Model')->PrintKuitansiDetailbyReg($data);
            // get sign user
            $data['id_employee'] = $session->IDEmployee;
            $data['listdatasign'] = $this->model('B_Billing_Model')->GetSignUser($data);
            //return view
            $data['GrupTransaksi'] = $_POST['jeniscetakan'];
            //get uuid4
            $data['uuid4'] = Utils::uuid4str();
            //cetakan ke
            $data['jeniscetakan'] = 'RINCIANBIAYA_RJ';
            $data['cetakanke'] = $this->model('B_Billing_Model')->GetCetakanKe($data);
            //$data['filename'] = $this->View('print/billing/rincianbiaya/save_rincianbiaya_rj', $data);
            $data['filedoc'] = 'print/billing/rincianbiaya/hdr_rincianbiaya_rj';
            $data['filename'] = $this->SaveFile($data);
            echo json_encode($this->model('B_Billing_Model')->uploadAWS($data));
        } catch (exception $exception) {
            $this->View('templates/header_login');
            $this->View('login/index');
            $this->View('templates/footer_login');
        }
    }

    public function SaveRincianRI()
    {
        try {
            $session = SessionManager::getCurrentSession();
            $data['notrs'] = $_POST['notrs'];
            $kodereg = substr($_POST['notrs'], 0, 2);
            $data['kodereg'] = $_POST['kodereg'];
            $data['lang'] = $_POST['lang'];
            $data['periode_awal'] = $_POST['periode_awal'];
            $data['periode_akhir'] = $_POST['periode_akhir'];
            $data['judul'] = 'RINCIAN BIAYA RAWAT INAP';
            //$data['judul_eng'] = $judul_eng;
            // get data header and detail
            $data['listdataheader'] = $this->model('B_Billing_Model')->PrintRincianHeaderbyReg($data);
            $data['listdetail_visit'] = $this->model('B_Billing_Model')->PrintRincianVisitbyReg($data);
            $data['listdetail_paketop'] = $this->model('B_Billing_Model')->PrintRincianPaketOPbyReg($data);
            $data['listdetail_kamar'] = $this->model('B_Billing_Model')->PrintRincianKamarbyReg($data);
            $data['listdetail_operasi'] = $this->model('B_Billing_Model')->PrintRincianOperasibyReg($data);
            $data['listdetail_lab'] = $this->model('B_Billing_Model')->PrintRincianLabbyReg($data);
            $data['listdetail_radiologi'] = $this->model('B_Billing_Model')->PrintRincianRadiologibyReg($data);
            $data['listdetail_bhp'] = $this->model('B_Billing_Model')->PrintRincianBhpbyReg($data);
            $data['listdetail_obat'] = $this->model('B_Billing_Model')->PrintRincianObatbyReg($data);
            $data['listdetail_retur'] = $this->model('B_Billing_Model')->PrintRincianReturbyReg($data);
            $data['listdata_payment'] = $this->model('B_Billing_Model')->PrintKuitansiDetailbyReg($data);
            //Get bill RAJAL
            if ($data['listdataheader']['NoRegisRWJ'] != null || $data['listdataheader']['NoRegisRWJ'] != '') {
                $data['notrs'] = $data['listdataheader']['NoRegisRWJ'];
                $data['listdetail_klinik_rj'] = $this->model('B_Billing_Model')->PrintRincianKlinikbyReg($data);
                $data['listdetail_operasi_rj'] = $this->model('B_Billing_Model')->PrintRincianOperasibyReg($data);
                $data['listdetail_lab_rj'] = $this->model('B_Billing_Model')->PrintRincianLabbyReg($data);
                $data['listdetail_radiologi_rj'] = $this->model('B_Billing_Model')->PrintRincianRadiologibyReg($data);
                $data['listdetail_farmasi_rj'] = $this->model('B_Billing_Model')->PrintRincianFarmasibyReg($data);
            }
            $data['notrs'] = $_POST['notrs'];
            // get sign user
            $data['id_employee'] = $session->IDEmployee;
            $data['listdatasign'] = $this->model('B_Billing_Model')->GetSignUser($data);
            //return view
            $data['GrupTransaksi'] = $_POST['jeniscetakan'];
            //get uuid4
            $data['uuid4'] = Utils::uuid4str();
            //cetakan ke
            $data['jeniscetakan'] = 'RINCIANBIAYA_RI';
            $data['cetakanke'] = $this->model('B_Billing_Model')->GetCetakanKe($data);
            //$data['filename'] = $this->View('print/billing/rincianbiaya/save_rincianbiaya_ri', $data);
            $data['filedoc'] = 'print/billing/rincianbiaya/hdr_rincianbiaya_ri';
            $data['filename'] = $this->SaveFile($data);
            echo json_encode($this->model('B_Billing_Model')->uploadAWS($data));
        } catch (exception $exception) {
            $this->View('templates/header_login');
            $this->View('login/index');
            $this->View('templates/footer_login');
        }
    }

    public function SendMail()
    {
        $data['notrs'] = $_POST['notrs'];
        $data['jeniscetakan'] = $_POST['jeniscetakan'];
        $data['noregistrasi'] = $_POST['noregistrasi'];
        $data['judul'] = $_POST['judul'];
        $data['email_send'] = $_POST['email'];
        $data['aws_url'] = $_POST['aws_url'];

        // var_dump($data['email']);
        // exit;

        $session = SessionManager::getCurrentSession();
        //$this->model('B_Billing_Model')->AddCountCetak($data);
        // $data['listdata1'] = $this->model('B_Billing_Model')->getAWSURL($data);
        // $data['aws_url'] = $data['listdata1']['AwsUrlDocuments'];
        //$data['filename'] = $this->View('print/billing/rincianbiaya/sendmail_rincianbiaya', $data);
        echo json_encode($this->SendMailPHPMailer($data));
    }

    public function CekPernahGenerate()
    {
        echo json_encode($this->model('B_Billing_Model')->getAWSURL($_POST));
    }



    public function gettarifnew()
    {
        echo json_encode($this->model('B_Billing_Model')->gettarifnew($_POST));
    }
    public function gettarifdetailnew()
    {
        echo json_encode($this->model('B_Billing_Model')->gettarifdetailnew($_POST));
    }
    public function getdokterdetailnew()
    {
        echo json_encode($this->model('B_Billing_Model')->getdokterdetailnew($_POST));
    }

    public function newInsertFO()
    {
        echo json_encode($this->model('B_Billing_Model')->newInsertFO($_POST));
    }

    public function newInsertBill()
    {
        echo json_encode($this->model('B_Billing_Model')->newInsertBill($_POST));
    }

    public function showDatafoBill()
    {
        echo json_encode($this->model('B_Billing_Model')->showDatafoBill($_POST));
    }

    public function updateBatalBill()
    {
        echo json_encode($this->model('B_Billing_Model')->updateBatalBill($_POST));
    }

    public function saveDataBill()
    {
        echo json_encode($this->model('B_Billing_Model')->saveDataBill($_POST));
    }

    public function showUpdateBillByFO1()
    {
        echo json_encode($this->model('B_Billing_Model')->showUpdateBillByFO1($_POST));
    }

    public function showDataBillFO2()
    {
        echo json_encode($this->model('B_Billing_Model')->showDataBillFO2($_POST));
    }

    public function updateBatalBillfo2()
    {
        echo json_encode($this->model('B_Billing_Model')->updateBatalBillfo2($_POST));
    }

    public function getsavebillfo2()
    {
        echo json_encode($this->model('B_Billing_Model')->getsavebillfo2($_POST));
    }

    public function getDataDetailBillbyIDfo2()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataDetailBillbyIDfo2($_POST));
    }

    public function ShowTindakanbyFO1()
    {
        echo json_encode($this->model('B_Billing_Model')->ShowTindakanbyFO1($_POST));
    }

    public function UpdateKlaimbyFO1()
    {
        echo json_encode($this->model('B_Billing_Model')->UpdateKlaimbyFO1($_POST));
    }

    public function UpdateUnklaimbyFO1()
    {
        echo json_encode($this->model('B_Billing_Model')->UpdateUnklaimbyFO1($_POST));
    }

    public function getDataApproveLabo()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataApproveLabo($_POST));
    }

    public function getDataApproveLabodetail()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataApproveLabodetail($_POST));
    }

    public function Approvelab()
    {
        echo json_encode($this->model('B_Billing_Model')->Approvelab($_POST));
    }

    public function ApproveAllLab()
    {
        echo json_encode($this->model('B_Billing_Model')->ApproveAllLab($_POST));
    }


    public function getDataApproveRad()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataApproveRad($_POST));
    }

    public function ApproveRad()
    {
        echo json_encode($this->model('B_Billing_Model')->ApproveRad($_POST));
    }

    public function ApproveAllRad()
    {
        echo json_encode($this->model('B_Billing_Model')->ApproveAllRad($_POST));
    }
    // public function ApproveAllBDRS()
    // {
    //     echo json_encode($this->model('B_Billing_Model')->ApproveAll($_POST));
    // }
    public function getDataApproveBDRS()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataApproveBDRS($_POST));
    }
    public function getDataApproveBDRSdetail()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataApproveBDRSdetail($_POST));
    }
    public function ApproveAllBDRS()
    {
        echo json_encode($this->model('B_Billing_Model')->ApproveAllBDRS($_POST));
    }
    public function changeBillingJaminan()
    {
        echo json_encode($this->model('B_Billing_Model')->changeBillingJaminan($_POST));
    }
    public function getDataHutangKabur()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataHutangKabur($_POST));
    }

    public function transferBillPasienHutang()
    {
        echo json_encode($this->model('B_Billing_Model')->transferBillPasienHutang($_POST));
    }

    public function getDataDetailRincianHutang()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataDetailRincianHutang($_POST));
    }

    public function getCekHutangPasien()
    {
        echo json_encode($this->model('B_Billing_Model')->getCekHutangPasien($_POST));
    }

    public function getgenerateIDTRSNew()
    {
        echo json_encode($this->model('B_Billing_Model')->getgenerateIDTRSNew($_POST));
    }
    public function UpdateTrsPayment_deposit()
    {
        echo json_encode($this->model('B_Billing_Model')->UpdateTrsPayment_deposit($_POST));
    }

    public function DeleteTrsPayment_deposit()
    {
        echo json_encode($this->model('B_Billing_Model')->DeleteTrsPayment_deposit($_POST));
    }

    public function getDataDetailRincianDeposit2()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataDetailRincianDeposit2($_POST));
    }

    public function DeleteTrsPayment_depositdetial()
    {
        echo json_encode($this->model('B_Billing_Model')->DeleteTrsPayment_depositdetial($_POST));
    }

    public function updatedetailDataDepo2Detail()
    {
        echo json_encode($this->model('B_Billing_Model')->updatedetailDataDepo2Detail($_POST));
    }
    public function getgenerateIDTRSNewVoucher()
    {
        echo json_encode($this->model('B_Billing_Model')->getgenerateIDTRSNewVoucher($_POST));
    }
    public function UpdateTrsPayment_pengembalian()
    {
        echo json_encode($this->model('B_Billing_Model')->UpdateTrsPayment_pengembalian($_POST));
    }

    public function DeleteTrsPayment_pengembalian()
    {
        echo json_encode($this->model('B_Billing_Model')->DeleteTrsPayment_pengembalian($_POST));
    }
    public function getDataDetailRincianpengembalian()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataDetailRincianpengembalian($_POST));
    }
    public function DeleteTrsPayment_Pengembaliandetial()
    {
        echo json_encode($this->model('B_Billing_Model')->DeleteTrsPayment_Pengembaliandetial($_POST));
    }

    public function updatedetailDataPengembalian2Detail()
    {
        echo json_encode($this->model('B_Billing_Model')->updatedetailDataPengembalian2Detail($_POST));
    }
    public function BillingVoucher($id = null, $pkuitansi_notrs = null, $pkuitansi_jeniscetakan = null, $pkuitansi_lang = null)
    {
        try {
            $session = SessionManager::getCurrentSession();
            $data['id'] =  Utils::setDecode($id);
            $data['judul'] = 'TRANSAKSI VOUCHER PENGEMBALIAN';
            $data['pkuitansi_notrs'] = $pkuitansi_notrs;
            $data['pkuitansi_jeniscetakan'] = $pkuitansi_jeniscetakan;
            $data['pkuitansi_lang'] = $pkuitansi_lang;
            // $data['judul_child'] = 'Data Pasien';
            $data['session'] = $session;
            $this->View('templates/header', $session);
            $this->View('billing/input/Billing_voucher', $data);
            $this->View('templates/footer');
        } catch (exception $exception) {
            $this->View('templates/header_login');
            $this->View('login/index');
            $this->View('templates/footer_login');
        }
    }
    public function SaveTrsPayment_Pengembalian()
    {
        echo json_encode($this->model('B_Billing_Model')->SaveTrsPayment_Pengembalian($_POST));
    }

    public function getTotalPembayaran()
    {
        echo json_encode($this->model('B_Billing_Model')->getTotalPembayaran($_POST));
    }
    public function getDataDetailRincianVoucher2()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataDetailRincianVoucher2($_POST));
    }

    public function getDataVoucherPengembalianAktif()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataVoucherPengembalianAktif($_POST));
    }
    public function getDataVoucherPengembalianArsip()
    {
        echo json_encode($this->model('B_Billing_Model')->getDataVoucherPengembalianArsip($_POST));
    }

    public function sumAllTarifVoucherAktif()
    {
        echo json_encode($this->model('B_Billing_Model')->sumAllTarifVoucherAktif($_POST));
    }

    public function SaveTrsPaymentVoucherPelunasan()
    {
        echo json_encode($this->model('B_Billing_Model')->SaveTrsPaymentVoucherPelunasan($_POST));
    }

    public function getPaymentTypeREKENING()
    {
        echo json_encode($this->model('B_Billing_Model')->getPaymentTypeREKENING($_POST));
    }
    
    public function goPaymentFromAPI()
    {
        $data = $_POST;
        $data['notrs'] = $_POST['Lab_NORegistrasi'];
        if ($data['JenisTrs'] == 'LAB'){
            $getdatatrs = $this->model('B_Billing_Model')->PrintRincianLabbyRegOnly($data);
            $total = 0;
            foreach ($getdatatrs as $key){
                $total += $key['Tarif'];
            }
            $data['PendapatanPoli'] = 0;
            $data['PendapatanApotik'] = 0;
            $data['PendapatanRadiologi'] = 0;
            $data['PendapatanLab'] = $total;
        }else if($data['JenisTrs'] == 'RADIOLOGI'){
            $data['PendapatanPoli'] = 0;
            $data['PendapatanApotik'] = 0;
            $data['PendapatanRadiologi'] = $_POST['Rad_Nilai'];
            $data['PendapatanLab'] = 0;
            $data['Lab_NORegistrasi'] = $_POST['Lab_NORegistrasi'];
            $data['Lab_NoEpisode'] = $_POST['Rad_NoEpisode'];
            $data['Lab_NamaPasien'] = $_POST['Rad_NamaPasien'];

        }else if ($data['JenisTrs'] == 'FARMASI'){

        }else{
            $data['PendapatanPoli'] = 0;
            $data['PendapatanApotik'] = 0;
            $data['PendapatanRadiologi'] = 0;
            $data['PendapatanLab'] = 0;
        }
        echo json_encode($this->model('B_Billing_Model')->goPaymentFromAPI($data));
    }

    public function PrintRincianRJOld($lang = '', $notrs = '', $periode_awal = '', $periode_akhir = '')
    {
        try {
            $session = SessionManager::getCurrentSession();
            $data['notrs'] = $notrs;
            $kodereg = substr($notrs, 0, 2);
            $data['kodereg'] = $kodereg;
            $data['lang'] = $lang;
            $data['periode_awal'] = $periode_awal;
            $data['periode_akhir'] = $periode_akhir;
            //$data['judul_eng'] = $judul_eng;
            // get data header and detail
            $data['listdataheader'] = $this->model('B_Billing_Model')->PrintRincianHeaderbyReg($data);
            $data['listdetail_pay'] = $this->model('B_Billing_Model')->PrintRincianpaybyReg($data);

            $data['listdetail_klinik'] = $this->model('B_Billing_Model')->PrintRincianKlinikbyReg($data);
            $data['listdetail_operasi'] = $this->model('B_Billing_Model')->PrintRincianOperasibyReg($data);
            $data['listdetail_lab'] = $this->model('B_Billing_Model')->PrintRincianLabbyRegOnly($data);
            $data['listdetail_radiologi'] = $this->model('B_Billing_Model')->PrintRincianRadiologibyRegOnly($data);
            $data['listdetail_mcu'] = $this->model('B_Billing_Model')->PrintRincianMCUbyReg($data);
            $data['listdetail_bhp'] = $this->model('B_Billing_Model')->PrintRincianBhpbyReg($data);
            $data['listdetail_obat'] = $this->model('B_Billing_Model')->PrintRincianObatbyReg($data);
            $data['listdetail_retur'] = $this->model('B_Billing_Model')->PrintRincianReturbyReg($data);

            $data['listdata_payment'] = $this->model('B_Billing_Model')->PrintKuitansiDetailbyReg($data);
            // get sign user
            $data['id_employee'] = $session->IDEmployee;
            $data['listdatasign'] = $this->model('B_Billing_Model')->GetSignUser($data);
            //get uuid4
            $data['uuid4'] = Utils::uuid4str();
            //cetakan ke
            $data['jeniscetakan'] = 'RINCIANBIAYA_RJ';
            $data['cetakanke'] = $this->model('B_Billing_Model')->GetCetakanKe($data);
            //return view
            $this->View('print/billing/rincianbiaya/print_rincianbiaya_rj', $data);
        } catch (exception $exception) {
            $this->View('templates/header_login');
            $this->View('login/index');
            $this->View('templates/footer_login');
        }
    }

    public function SaveRincianRJOld()
    {
        try {
            $session = SessionManager::getCurrentSession();
            $data['notrs'] = $_POST['notrs'];
            $kodereg = substr($_POST['notrs'], 0, 2);
            $data['kodereg'] = $_POST['kodereg'];
            $data['lang'] = $_POST['lang'];
            $data['periode_awal'] = $_POST['periode_awal'];
            $data['periode_akhir'] = $_POST['periode_akhir'];
            //$data['judul_eng'] = $judul_eng;
            // get data header and detail
            $data['listdataheader'] = $this->model('B_Billing_Model')->PrintRincianHeaderbyReg($data);
            $data['listdetail_klinik'] = $this->model('B_Billing_Model')->PrintRincianKlinikbyReg($data);
            $data['listdetail_operasi'] = $this->model('B_Billing_Model')->PrintRincianOperasibyReg($data);
            $data['listdetail_lab'] = $this->model('B_Billing_Model')->PrintRincianLabbyRegOnly($data);
            $data['listdetail_radiologi'] = $this->model('B_Billing_Model')->PrintRincianRadiologibyRegOnly($data);
            $data['listdetail_mcu'] = $this->model('B_Billing_Model')->PrintRincianMCUbyReg($data);
            $data['listdetail_bhp'] = $this->model('B_Billing_Model')->PrintRincianBhpbyReg($data);
            $data['listdetail_obat'] = $this->model('B_Billing_Model')->PrintRincianObatbyReg($data);
            $data['listdetail_retur'] = $this->model('B_Billing_Model')->PrintRincianReturbyReg($data);
            $data['listdata_payment'] = $this->model('B_Billing_Model')->PrintKuitansiDetailbyReg($data);
            // get sign user
            $data['id_employee'] = $session->IDEmployee;
            $data['listdatasign'] = $this->model('B_Billing_Model')->GetSignUser($data);
            //return view
            $data['GrupTransaksi'] = $_POST['jeniscetakan'];
            //get uuid4
            $data['uuid4'] = Utils::uuid4str();
            //cetakan ke
            $data['jeniscetakan'] = 'RINCIANBIAYA_RJ';
            $data['cetakanke'] = $this->model('B_Billing_Model')->GetCetakanKe($data);
            //$data['filename'] = $this->View('print/billing/rincianbiaya/save_rincianbiaya_rj', $data);
            $data['filedoc'] = 'print/billing/rincianbiaya/hdr_rincianbiaya_rjx';
            $data['filename'] = $this->SaveFile($data);
            echo json_encode($this->model('B_Billing_Model')->uploadAWS($data));
        } catch (exception $exception) {
            $this->View('templates/header_login');
            $this->View('login/index');
            $this->View('templates/footer_login');
        }
    }
    public function GetregistrasiRajalbyNoRegistrasiDigital()
    {
        echo json_encode($this->model('B_create_Registrasi_Rajal')->GetregistrasiRajalbyNoRegistrasiDigital($_POST['NoRegistrasi']));
    }
}
