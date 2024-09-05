<?php
class bInformationResumeMedis extends Controller
{
    use Edocuments;
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Resume Medis Pasien';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/registration/ResumeMedis/InformationResumeMedis', $data);
        $this->View('templates/footer');
    }
    public function getDataListResumeMedisPasien()
    {
        echo json_encode($this->model('B_InformationResumeMedis_Model')->getDataListPasien($_POST));
    }
    public function PrintExcel()
    {
        // $data['notrs'] = $notrs; 
        // $data['judul'] = 'Informasi LMA';
        // $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        // $data['listdata1'] = $this->model('B_InformationLma_Model')->printShowDataLMA($data); 
        $this->View('print/information/ExcelInfoResume1');
    }

    public function PrintMedical($notrs = '')
    {
        try {
            $session = SessionManager::getCurrentSession();
            $data['notrs'] = $notrs;
            // get data header and detail
            $data['listdataheader'] = $this->model('B_InformationResumeMedis_Model')->PrintResumeMedisbyID($data);
            // get sign user
            $data['id_employee'] = $data['listdataheader']['IdUserSign'];
            $data['listdatasign'] = $this->model('B_Billing_Model')->GetSignUser($data);
            //get uuid4
            $data['uuid4'] = Utils::uuid4str();
            //return view
            $this->View('print/registration/resumemedis/print_resumemedis', $data);
        } catch (exception $exception) {
            $this->View('templates/header_login');
            $this->View('login/index');
            $this->View('templates/footer_login');
        }
    }

    public function SaveMedical()
    {
        try {
            //$session = SessionManager::getCurrentSession();
            $data['notrs'] = Utils::setDecode($_POST['notrs']);
            $data['GrupTransaksi'] = 'RESUME_MEDIS';
            // get data header and detail
            $data['listdataheader'] = $this->model('B_InformationResumeMedis_Model')->PrintResumeMedisbyID($data);
            $data['NoRegistrasi'] = $data['listdataheader']['No_Registrasi'];
            // get sign user
            $data['id_employee'] = $data['listdataheader']['IdUserSign'];
            //get uuid4
            $data['uuid4'] = Utils::uuid4str();
            $data['listdatasign'] = $this->model('B_Billing_Model')->GetSignUser($data);
            //return view
            $data['jeniscetakan'] = 'RESUME_MEDIS';
            $data['filedoc'] = 'print/registration/resumemedis/hdr_resumemedis';
            //$data['notrs'] = $data['listdataheader']['No_MR'];
            $data['filename'] = $this->SaveFile($data);
            echo json_encode($this->model('B_InformationResumeMedis_Model')->uploadAWS($data));
        } catch (exception $exception) {
            $this->View('templates/header_login');
            $this->View('login/index');
            $this->View('templates/footer_login');
        }
    }

    public function SendMail()
    {
        // $data['notrs'] = $_POST['notrs'];
        // $data['jeniscetakan'] = $_POST['jeniscetakan'];
        // $data['noregistrasi'] = $_POST['noregistrasi'];
        // $data['judul'] = $_POST['judul'];
        // $data['email'] = $_POST['email'];
        // $data['listdata1'] = $this->model('B_InformationResumeMedis_Model')->getAWSURL($data);
        // $data['filename'] = $this->View('print/billing/rincianbiaya/sendmail_rincianbiaya', $data);

        $data['notrs'] = $_POST['notrs'];
        $data['email_send'] = $_POST['email_send'];
        $data['judul'] = 'Resume Medis';
        $data['aws_url'] = $_POST['aws_url'];
        $data['jeniscetakan'] = 'RESUME_MEDIS';
        echo json_encode($this->SendMailPHPMailer($data));
    }
    public function inputNoLogin($id = null)
    {
        //$session = SessionManager::getCurrentSession();
        $data['id'] =  $id;
        $data['judul'] = 'Verification Resume Medis';
        $data['judul_child'] = 'List View';
        $data['session'] = null; 
        $data['iswalkin'] = 'RAJAL';
        $this->View('templates/header_nologin', null);
        $this->View('informasi/registration/ResumeMedis/sendverification', $data);
        $this->View('templates/footer');
    }
    public function icare($id = null)
    {
        //$session = SessionManager::getCurrentSession();
        $data['id'] =  $id;
        $data['judul'] = 'Verification Resume Medis';
        $data['judul_child'] = 'List View';
        $data['session'] = null; 
        $data['iswalkin'] = 'RAJAL';
        $this->View('templates/header_nologin', null);
        $this->View('informasi/registration/ResumeMedis/icare', $data);
        $this->View('templates/footer');
    }
    public function SendWhatsappVerification(){
        echo json_encode($this->model('B_InformationResumeMedis_Model')->SendWhatsappVerification($_POST));
    }

    public function SendResume($id = null)
    {
        //$session = SessionManager::getCurrentSession();
        $data['id'] =  $id;
        $data['judul'] = 'Verification Resume Medis';
        $data['judul_child'] = 'List View';
        $data['session'] = null; 
        $data['iswalkin'] = 'RAJAL';
        $this->View('templates/header_nologin', null);
        $this->View('informasi/registration/ResumeMedis/sendresume', $data);
        $this->View('templates/footer');
    }

}
