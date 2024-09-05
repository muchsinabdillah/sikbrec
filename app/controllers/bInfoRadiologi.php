<?php
class bInfoRadiologi extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Info Radiologi';
        $data['judul_child'] = 'View Informasi';
        // $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('informasi/registration/Radiologi/InformationRadiologi', $data);
        $this->View('templates/footer');
    }

    public function getDataListInfoRadiologi()
    {
        echo json_encode($this->model('aInfoRadiologi_Model')->getDataInfoRadiologi($_POST));
    }

    public function ListRegOrderRadiologi()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'New Order Radiologi';
        $data['judul_child'] = 'View Informasi';
        // $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('informasi/registration/Radiologi/ListRegOrderRadiologi', $data);
        $this->View('templates/footer');
    }

    public function PrintHasilRadiologi($notrs = '')
    {
        try {
            $session = SessionManager::getCurrentSession();
            $data['notrs'] = $notrs;
            // get data header and detail
            $data['listdataheader'] = $this->model('aInfoRadiologi_Model')->PrintHasilHeaderbyACN($data);
            $data['listdatadetail'] = $this->model('aInfoRadiologi_Model')->PrintHasilDetailbyACN($data);
            //get uuid4
            $data['uuid4'] = Utils::uuid4str();
            //return view
            $this->View('print/information/radiologi/print_hasilradiologi', $data);
        } catch (exception $exception) { 
            $this->View('templates/header_login');
            $this->View('login/index');
            $this->View('templates/footer_login');
        }
    }

    public function SaveHasilRadiologi()
    {
        try {
            $session = SessionManager::getCurrentSession();
            $data['notrs'] = $_POST['notrs'];
            $data['NoRegistrasi'] = $_POST['NoRegistrasi'];
            $data['GrupTransaksi'] = 'HASIL_RADIOLOGI';
            // get data header and detail
            $data['listdataheader'] = $this->model('aInfoRadiologi_Model')->PrintHasilHeaderbyACN($data);
            $data['listdatadetail'] = $this->model('aInfoRadiologi_Model')->PrintHasilDetailbyACN($data);
            //get uuid4
            $data['uuid4'] = Utils::uuid4str();
            //return view
            $this->View('print/information/radiologi/save_hasilradiologi', $data);
            echo json_encode($this->model('aInfoRadiologi_Model')->uploadAWS($data));
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
        $data['email'] = $_POST['email'];
        $session = SessionManager::getCurrentSession();
        $data['listdata1'] = $this->model('aInfoRadiologi_Model')->getAWSURL($data);
        $data['filename'] = $this->View('print/billing/rincianbiaya/sendmail_rincianbiaya', $data);
    }
}
