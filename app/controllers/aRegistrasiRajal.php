<?php
class aRegistrasiRajal extends Controller
{
    use Edocuments;
    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['idodc'] =  null;
        $data['jenispasien'] =  'RAJAL';
        $data['judul'] = 'Registration Rawat Jalan';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('registration/input/aRegistrasiRajalInput', $data);
        $this->View('templates/footer');
    }
    public function list()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Daftar Antrian Pasien Poli Rawat Jalan';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('registration/list/aRegistrasiRajalList', $data);
        $this->View('templates/footer');
    }
    public function CreateRegistrasi()
    {
        echo json_encode($this->model('B_create_Registrasi_Rajal')->CreateRegistrasi($_POST));
    }
    public function showDataPasienRajalAktif()
    {
        echo json_encode($this->model('B_List_Registrasi_Pasien_Model')->showDataPasienRajalAktif($_POST));
    }
    public function showDataPasienRajalAktifForReservation()
    {
        echo json_encode($this->model('B_List_Registrasi_Pasien_Model')->showDataPasienRajalAktifForReservation($_POST));
    }
    public function showDataPasienRajalArsipForReservation()
    {
        echo json_encode($this->model('B_List_Registrasi_Pasien_Model')->showDataPasienRajalArsipForReservation($_POST));
    }
    
    public function showDataPasienRajalArsip()
    {
        echo json_encode($this->model('B_List_Registrasi_Pasien_Model')->showDataPasienRajalArsip($_POST));
    }
    public function GetregistrasiRajalbyId()
    {
        echo json_encode($this->model('B_create_Registrasi_Rajal')->GetregistrasiRajalbyId($_POST));
    }
    public function GetregistrasiRajalbyNoRegistrasi()
    {
        echo json_encode($this->model('B_create_Registrasi_Rajal')->GetregistrasiRajalbyNoRegistrasi($_POST));
    }
    public function GetregistrasiRajalbyNoRegistrasiRI()
    {
        echo json_encode($this->model('B_create_Registrasi_Rajal')->GetregistrasiRajalbyNoRegistrasiRI($_POST));
    }
    public function VoidRegistrasi()
    {
        echo json_encode($this->model('B_create_Registrasi_Rajal')->VoidRegistrasi($_POST));
    }
    public function OrderRadiologi($noregistrasi = null, $woid = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['woid'] =  Utils::setDecode($woid);
        $data['noregistrasi'] =  Utils::setDecode($noregistrasi);
        //$data['woid'] =  $woid;
        //$data['noregistrasi'] = $noregistrasi;
        $data['judul'] = 'Order Radiologi';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('emr/radiologi/OrderRadiologi', $data);
        $this->View('templates/footer');
    }
    public function OrderLaboratorium($noregistrasi = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['noregistrasi'] =  Utils::setDecode($noregistrasi);
        //$data['woid'] =  $woid;
        //$data['noregistrasi'] = $noregistrasi;
        $data['judul'] = 'Order Laboratorium';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('emr/laboratorium/OrderLaboratorium', $data);
        $this->View('templates/footer');
    }

    public function PrintBuktiRegis($noregistrasi = '')
    {
        $data['noregistrasi'] =  Utils::setDecode($noregistrasi);
        $session = SessionManager::getCurrentSession();
        $data['listdata1'] = $this->model('B_Create_Registrasi_Rajal')->PrintBuktiRegis($data);
        $this->View('print/registration/print_bukti_reg', $data);
    }

    public function PrintLabelPasien($nomr = '')
    {
        $data['notrs'] =  Utils::setDecode($nomr);
        $session = SessionManager::getCurrentSession();
        $data['listdata1'] = $this->model('B_Create_Registrasi_Rajal')->PrintLabelPasien($data);
        $this->View('print/registration/print_label_pasien', $data);
    }

    public function PrintGelangAnak($nomr = '')
    {
        $data['notrs'] =  Utils::setDecode($nomr);
        $session = SessionManager::getCurrentSession();
        $data['listdata1'] = $this->model('B_Create_Registrasi_Rajal')->PrintLabelPasien($data);
        $this->View('print/registration/print_gelang_anak', $data);
    }

    public function PrintGelangDewasa($nomr = '')
    {
        $data['notrs'] =  Utils::setDecode($nomr);
        $session = SessionManager::getCurrentSession();
        $data['listdata1'] = $this->model('B_Create_Registrasi_Rajal')->PrintLabelPasien($data);
        $this->View('print/registration/print_gelang_dewasa', $data);
    }

    public function OrderMCU($noregistrasi = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['noregistrasi'] =  Utils::setDecode($noregistrasi);
        $data['judul'] = 'Order MCU';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('emr/MCU/OrderMCU', $data);
        $this->View('templates/footer');
    }

    public function UpdateNoSEP()
    {
        echo json_encode($this->model('B_List_Registrasi_Pasien_Model')->UpdateNoSEP($_POST));
    }

    public function CekNoSEP()
    {
        echo json_encode($this->model('B_List_Registrasi_Pasien_Model')->CekNoSEP($_POST));
    }

    //03-04-2023 odc
    public function list_odc()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Permintaan One Day Care (ODC)';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('registration/list/aRegistrasiODCList', $data);
        $this->View('templates/footer');
    }
    public function getDataListODCPasien()
    {
        echo json_encode($this->model('B_Create_Registrasi_Rajal')->getDataListODCPasien());
    }
    public function PrintODC($notrs = '')
    {
        $data['notrs'] = $notrs;
        $data['judul'] = 'Informasi LMA';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        $data['listdata1'] = $this->model('B_InformationLma_Model')->printShowDataODC($data);
        $this->View('print/information/lma/printODC', $data);
    }

    public function RegistrasiODC($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  null;
        $data['idodc'] =  Utils::setDecode($id);
        $data['jenispasien'] =  'RAJAL';
        $data['judul'] = 'Registration Rawat Jalan ODC';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('registration/input/aRegistrasiRajalInput', $data);
        $this->View('templates/footer');
    }
    public function GetDataPasienbyIDODC()
    {
        echo json_encode($this->model('B_MedicalRecord_Model')->GetDataPasienbyIDODC($_POST));
    }
    public function GoTambahAntrianBPJS()
    {
        echo json_encode($this->model('B_List_Registrasi_Pasien_Model')->GoTambahAntrianBPJS($_POST));
    }
    public function getSEPbyNosep()
    {
        echo json_encode($this->model('B_List_Registrasi_Pasien_Model')->getSEPbyNosep($_POST));
    }
    public function GoBPJSCekKepesertaan()
    {
        echo json_encode($this->model('B_List_Registrasi_Pasien_Model')->GoBPJSCekKepesertaan($_POST));
    }
    public function GoAddIcare()
    {
        echo json_encode($this->model('B_List_Registrasi_Pasien_Model')->GoAddIcare($_POST));
    }
    public function PrintAkadIjarah($notrs = '')
    {
        $data['notrs'] = $notrs;
        $data['judul'] = 'Akad Ijaroh';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        $data['listdata1'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintAkadIjarah($data);
        //$data['listdatasign'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintAkadIjarahSign($data);
       // $this->View('print/registration/akadijarah/print_akadijarah', $data);
        $data['jeniscetakan'] = 'AKADIJAROH';
        $data['filedoc'] = 'print/registration/akadijarah/hdr_akadijarah';
        $this->PrintFile($data);
    }

    public function SaveAkadIjarah($notrs = '')
    {
        $data['notrs'] = $_POST['id'];
        $data['judul'] = 'Akad Ijaroh';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        $data['listdata1'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintAkadIjarah($data);
        //$data['listdatasign'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintAkadIjarahSign($data);
        $data['filename'] = $this->View('print/registration/akadijarah/save_akadijarah', $data);
        //var_dump($data['listdata1'][]);exit;
        $data['jeniscetakan'] = 'AKADIJAROH';
        $data['filedoc'] = 'print/registration/akadijarah/hdr_akadijarah';
        $this->SaveFile($data);
        echo json_encode($this->model('B_List_Registrasi_Pasien_Model')->uploadAWS_AkadIjaroh($data));
    }

    public function SendMailAkadIjarah()
    {
        $data['notrs'] = $_POST['notrs'];
        $data['email_send'] = $_POST['email_send'];
        $data['judul'] = 'Akad Ijaroh';
        $data['judul_child'] = 'View Informasi';
        $data['aws_url'] = $_POST['aws_url'];
        $session = SessionManager::getCurrentSession();
        //$data['listdata1'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintAkadIjarah($data);
        //$this->View('print/registration/akadijarah/sendmail_akadijarah', $data);
        //$this->View('print/registration/generalconsent/sendmail_generalconsent', $data);
        $data['jeniscetakan'] = 'AKADIJAROH';
        echo json_encode($this->SendMailPHPMailer($data));
    }

    public function PrintHakDanKewajiban($notrs = '')
    {
        $data['notrs'] = $notrs;
        $data['judul'] = 'Hak dan Kewajiban';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        //$data['listdatasign'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintHakdanKewajibanSign($data);
        $data['listdata1'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintHakdanKewajiban($data);
        //$this->View('print/registration/hakdankewajibanpasien/print_hakdankewajiban', $data);
        $data['jeniscetakan'] = 'HAKDANKEWAJIBAN';
        $data['filedoc'] = 'print/registration/hakdankewajibanpasien/hdr_hakdankewajiban';
        $this->PrintFile($data);
    }

    public function SaveHakdanKewajiban($notrs = '')
    {
        $data['notrs'] = $_POST['id'];
        $data['judul'] = 'Hak dan Kewajiban';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        $data['listdata1'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintHakdanKewajiban($data);
       // $data['listdatasign'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintHakdanKewajibanSign($data);
        // $data['filename'] = $this->View('print/registration/hakdankewajibanpasien/save_hakdankewajiban', $data);
        $data['jeniscetakan'] = 'HAKDANKEWAJIBAN';
        $data['filedoc'] = 'print/registration/hakdankewajibanpasien/hdr_hakdankewajiban';
        $data['filename'] = $this->SaveFile($data);
        echo json_encode($this->model('B_List_Registrasi_Pasien_Model')->uploadAWS_HakdanKewajiban($data));
    }

    public function SendHakdanKewajiban()
    {
        $data['notrs'] = $_POST['notrs'];
        $data['email_send'] = $_POST['email_send'];
        $data['judul'] = 'Hak dan Kewajiban';
        $data['judul_child'] = 'View Informasi';
        $data['aws_url'] = $_POST['aws_url'];
        $session = SessionManager::getCurrentSession();
        // $data['listdata1'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintHakdanKewajibanSign($data);
        //$data['listdata1'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintHakdanKewajiban($data);
        $data['jeniscetakan'] = 'HAKDANKEWAJIBAN';
        //$this->View('print/registration/hakdankewajibanpasien/sendmail_hakdankewajiban', $data);
        echo json_encode($this->SendMailPHPMailer($data));
        //$this->View('print/registration/generalconsent/sendmail_generalconsent', $data);
    }

    public function PrintGeneralConsent($notrs = '')
    {
        $data['notrs'] = $notrs;
        $data['judul'] = 'General Consent';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        $data['listdata1'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintGeneralConsent($data);
        $data['listdata2'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintGeneralConsent_dtl($data);
        //$data['listdatasign'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintGeneralConsentSign($data);
        //$this->View('print/registration/generalconsent/print_generalconsent', $data);
        $data['jeniscetakan'] = 'GENERALCONSENT';
        $data['filedoc'] = 'print/registration/generalconsent/hdr_generalconsent';
        $this->PrintFile($data);
    }

    public function SaveGeneralConsent($notrs = '')
    {
        $data['notrs'] = $_POST['id'];
        $data['judul'] = 'General Consent';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        $data['listdata1'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintGeneralConsent($data);$data['listdata2'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintGeneralConsent_dtl($data);
        //$data['listdatasign'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintGeneralConsentSign($data);
        //$data['filename'] = $this->View('print/registration/generalconsent/save_generalconsent', $data);
        $data['jeniscetakan'] = 'GENERALCONSENT';
        $data['filedoc'] = 'print/registration/generalconsent/hdr_generalconsent';
        $this->SaveFile($data);
        //$this->model('B_List_Registrasi_Pasien_Model')->uploadAWS_GeneralConsent($data);
        echo json_encode( $this->model('B_List_Registrasi_Pasien_Model')->uploadAWS_GeneralConsent($data));
    }

    public function SendMailGeneralConsent()
    {
        $data['notrs'] = $_POST['notrs'];
        $data['email_send'] = $_POST['email_send'];
        $data['aws_url'] = $_POST['aws_url'];
        $data['judul'] = 'General Consent';
        $data['judul_child'] = 'View Informasi';
        //$session = SessionManager::getCurrentSession();
        //$data['listdata1'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintGeneralConsent($data);
        //$this->View('print/registration/generalconsent/sendmail_generalconsent', $data);
        // $data['jeniscetakan'] = 'GENERALCONSENT';
        // $data['filedoc'] = 'print/registration/generalconsent/hdr_generalconsent';
        echo json_encode($this->SendMailPHPMailer($data));
    }

    public function PrintTataTertib($notrs = '')
    {
        $data['notrs'] = $notrs;
        $data['judul'] = 'Tata Tertib';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        // $data['listdatasign'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintTataTertibSign($data);
         $data['listdata1'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintTataTertib($data);
        //$this->View('print/registration/tatatertib/print_tatatertib', $data);
        $data['jeniscetakan'] = 'TATATERTIB';
        $data['filedoc'] = 'print/registration/tatatertib/hdr_tatatertib';
        $this->PrintFile($data);
    }

    public function SaveTataTertib($notrs = '')
    {
        $data['notrs'] = $_POST['id'];
        $data['judul'] = 'Tata Tertib';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        $data['listdata1'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintTataTertib($data);
        //$data['listdatasign'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintTataTertibSign($data);
        //$data['filename'] = $this->View('print/registration/tatatertib/save_tatatertib', $data);
        //$this->model('B_List_Registrasi_Pasien_Model')->uploadAWS_TataTertib($data);
        $data['jeniscetakan'] = 'TATATERTIB';
        $data['filedoc'] = 'print/registration/tatatertib/hdr_tatatertib';
        $this->SaveFile($data);
        echo json_encode($this->model('B_List_Registrasi_Pasien_Model')->uploadAWS_TataTertib($data));
    }

    public function SendMailSaveTataTertib()
    {
        $data['notrs'] = $_POST['notrs'];
        $data['email_send'] = $_POST['email_send'];
        $data['judul'] = 'Tata Tertib';
        $data['aws_url'] = $_POST['aws_url'];
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        //$data['listdata1'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintTataTertib($data);
        //$this->View('print/registration/tatatertib/sendmail_tatatertib', $data);
        //$this->View('print/registration/generalconsent/sendmail_generalconsent', $data);
        echo json_encode($this->SendMailPHPMailer($data));
    }

    public function PrintPerkiraanBiayaNonOP($notrs = '')
    {
        $data['notrs'] = $notrs;
        $data['judul'] = 'Perkiraan Biaya Perawatan Non Operasi';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
         //$data['listdatasign'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintPerkiraanBiayaNoNOPSign($data);
         $data['listdata1'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintPerkiraanBiayaNoNOP($data);
        //$this->View('print/registration/perkiraanbiayanonoperasi/print_perkiraanbiayanonop', $data);
        $data['jeniscetakan'] = 'PERKIRAANNONOP';
        $data['filedoc'] = 'print/registration/perkiraanbiayanonoperasi/hdr_perkiraanbiayanonop';
        $this->PrintFile($data);
    }

    public function SavePerkiraanBiayaNonOP($notrs = '')
    {
        $data['notrs'] = $_POST['id'];
        $data['judul'] = 'Perkiraan Biaya Perawatan Non Operasi';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        $data['listdata1'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintPerkiraanBiayaNoNOP($data);
       // $data['listdatasign'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintPerkiraanBiayaNoNOPSign($data);
        //$data['filename'] = $this->View('print/registration/perkiraanbiayanonoperasi/save_perkiraanbiayanonop', $data);
        $data['jeniscetakan'] = 'PERKIRAANNONOP';
        $data['filedoc'] = 'print/registration/perkiraanbiayanonoperasi/hdr_perkiraanbiayanonop';
        $this->SaveFile($data);
        echo json_encode($this->model('B_List_Registrasi_Pasien_Model')->uploadAWS_PerkiraanBiayaNoNOP($data));
    }

    public function SendMailPerkiraanBiayaNonOP()
    {
        $data['notrs'] = $_POST['notrs'];
        $data['email_send'] = $_POST['email_send'];
        $data['judul'] = 'Perkiraan Biaya Perawatan Non Operasi';
        $data['judul_child'] = 'View Informasi';
        $data['aws_url'] = $_POST['aws_url'];
        $session = SessionManager::getCurrentSession();
        //$data['listdata1'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintPerkiraanBiayaNoNOP($data);
        // $this->View('print/registration/perkiraanbiayanonoperasi/sendmail_perkiraanbiayanonop', $data);
        //$this->View('print/registration/generalconsent/sendmail_generalconsent', $data);
        echo json_encode($this->SendMailPHPMailer($data));
    }

    public function PrintPerkiraanBiayaOP($notrs = '')
    {
        $data['notrs'] = $notrs;
        $data['judul'] = 'Perkiraan Biaya Perawatan Operasi';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
         $data['listdatasign'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintPerkiraanBiayaOPSign($data);
         $data['listdata1'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintPerkiraanBiayaOP($data);
        //$this->View('print/registration/perkiraanbiayanonoperasi/print_perkiraanbiayanonop', $data);
        $data['jeniscetakan'] = 'PERKIRAANNONOP';
        $data['filedoc'] = 'print/registration/perkiraanbiayaoperasi/hdr_perkiraanbiayaop';
        $this->PrintFile($data);
    }

    public function SavePerkiraanBiayaOP($notrs = '')
    {
        $data['notrs'] = $_POST['id'];
        $data['judul'] = 'Perkiraan Biaya Perawatan Operasi';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        $data['listdata1'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintPerkiraanBiayaOP($data);
        $data['listdatasign'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintPerkiraanBiayaOPSign($data);
        //$data['filename'] = $this->View('print/registration/perkiraanbiayanonoperasi/save_perkiraanbiayanonop', $data);
        $data['jeniscetakan'] = 'PERKIRAANOP';
        $data['filedoc'] = 'print/registration/perkiraanbiayaoperasi/hdr_perkiraanbiayaop';
        $this->SaveFile($data);
        echo json_encode($this->model('B_List_Registrasi_Pasien_Model')->uploadAWS_PerkiraanBiayaOP($data));
    }

    public function SendMailPerkiraanBiayaOP()
    {
        $data['notrs'] = $_POST['notrs'];
        $data['email_send'] = $_POST['email_send'];
        $data['judul'] = 'Perkiraan Biaya Perawatan Operasi';
        $data['judul_child'] = 'View Informasi';
        $data['aws_url'] = $_POST['aws_url'];
        $session = SessionManager::getCurrentSession();
        echo json_encode($this->SendMailPHPMailer($data));
    }

    public function PrintPersetujuanBiaya($notrs = '')
    {
        $data['notrs'] = $notrs;
        $data['judul'] = 'Informasi Persetujuan Biaya Tindakan';
        $data['judul_child'] = 'View Informasi';
         $data['listdatasign'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintPersetujuanBiayaSign($data);
         $data['listdata1'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintPersetujuanBiaya($data);
        $data['jeniscetakan'] = 'PERSETUJUANBIAYA';
        $data['filedoc'] = 'print/registration/persetujuanbiaya/hdr_persetujuanbiaya';
        $this->PrintFile($data);
    }

    public function SavePersetujuanBiaya($notrs = '')
    {
        $data['notrs'] = $_POST['id'];
        $data['judul'] = 'Informasi Persetujuan Biaya Tindakan';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        $data['listdata1'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintPersetujuanBiaya($data);
        $data['listdatasign'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintPersetujuanBiayaSign($data);
        //$data['filename'] = $this->View('print/registration/perkiraanbiayanonoperasi/save_perkiraanbiayanonop', $data);
        $data['jeniscetakan'] = 'PERSETUJUANBIAYA';
        $data['filedoc'] = 'print/registration/persetujuanbiaya/hdr_persetujuanbiaya';
        $this->SaveFile($data);
        echo json_encode($this->model('B_List_Registrasi_Pasien_Model')->uploadAWS_PersetujuanBiaya($data));
    }

    public function SendPersetujuanBiaya()
    {
        $data['notrs'] = $_POST['notrs'];
        $data['email_send'] = $_POST['email_send'];
        $data['judul'] = 'Informasi Persetujuan Biaya Tindakan';
        $data['judul_child'] = 'View Informasi';
        $data['aws_url'] = $_POST['aws_url'];
        $session = SessionManager::getCurrentSession();
        echo json_encode($this->SendMailPHPMailer($data));
    }

    public function PrintPersetujuanSelisih($notrs = '')
    {
        $data['notrs'] = $notrs;
        $data['judul'] = 'Persetujuan Membayar Selisih Biaya';
        $data['judul_child'] = 'View Informasi';
        //  $data['listdatasign'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintPersetujuanSelisihSign($data);
         $data['listdata1'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintPersetujuanSelisih($data);
        $data['jeniscetakan'] = 'PERSETUJUANSELISIH';
        $data['filedoc'] = 'print/registration/persetujuanselisih/hdr_persetujuanselisih';
        $this->PrintFile($data);
    }

    public function SavePersetujuanSelisih($notrs = '')
    {
        $data['notrs'] = $_POST['id'];
        $data['judul'] = 'Persetujuan Membayar Selisih Biaya';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        $data['listdata1'] = $this->model('B_List_Registrasi_Pasien_Model')->PrintPersetujuanSelisih($data);
        $data['jeniscetakan'] = 'PERSETUJUANSELISIH';
        $data['filedoc'] = 'print/registration/persetujuanselisih/hdr_persetujuanselisih';
        $this->SaveFile($data);
        echo json_encode($this->model('B_List_Registrasi_Pasien_Model')->uploadAWS_PersetujuanSelisih($data));
    }

    public function SendPersetujuanSelisih()
    {
        $data['notrs'] = $_POST['notrs'];
        $data['email_send'] = $_POST['email_send'];
        $data['judul'] = 'Persetujuan Membayar Selisih Biaya';
        $data['judul_child'] = 'View Informasi';
        $data['aws_url'] = $_POST['aws_url'];
        $session = SessionManager::getCurrentSession();
        echo json_encode($this->SendMailPHPMailer($data));
    }

    public function UpdateNoSEP_MasukRanap()
    {
        echo json_encode($this->model('B_List_Registrasi_Pasien_Model')->UpdateNoSEP_MasukRanap($_POST));
    }
    public function listkehadiranmcu()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Daftar Kehadiran MCU';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('registration/list/aListKehadiranMCU', $data);
        $this->View('templates/footer');
    }
    public function showDataPasienRajalAktifMCU()
    {
        echo json_encode($this->model('B_List_Registrasi_Pasien_Model')->showDataPasienRajalAktifMCU($_POST));
    }
    public function scanQrCodeKehadiran()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Scan Kehadiran MCU';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header_nologin', $session);
        $this->View('mcu/goScanKehadiran', $data);
        $this->View('templates/footer');
    }
    public function goScanQrCode()
    {
        echo json_encode($this->model('B_List_Registrasi_Pasien_Model')->goScanQrCode($_POST));
    }
    public function sendreminderAllMCU()
    {
        
        $token = $this->model('Login_Model')->getTokenWapin();
        $sendreminder = $this->model('B_List_Registrasi_Pasien_Model')->sendreminderAllMCU($token,$_POST);
        echo json_encode($sendreminder);
    }
    public function validatejeniskunjunganBPJS(){
        echo json_encode($this->model('B_create_Registrasi_Rajal')->validatejeniskunjunganBPJS($_POST));
    }
}
