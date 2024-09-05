<?php
class bInformationHasilLab extends Controller 
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Hasil Laboratorium';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/laboratorium/InformationHasilLab', $data);
        $this->View('templates/footer');
    }
    public function getDataList(){
        echo json_encode($this->model('B_InformationHasilLab_Model')->getDataList($_POST));
    }
    public function PrintHasil($notrs = '')
    {
        $data['notrs'] = $notrs; 
        $data['judul'] = 'Informasi Hasil Laboratorium';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        $data['listdata'] = $this->model('B_InformationHasilLab_Model')->PrintHasil($data); 
        $data['hdr'] = $this->model('B_InformationHasilLab_Model')->PrintHasilHDR($data); 
        $data['footer'] = $this->model('B_InformationHasilLab_Model')->PrintHasilFooter($data); 
        $data['tglsampling'] = $this->model('B_InformationHasilLab_Model')->PrintHasilTglSampling($data); 
        //get uuid4
        $data['uuid4'] = Utils::uuid4str();
        $this->View('print/information/laboratorium/printhasillab', $data);
    }

    public function SendMailHasil($notrs = '',$param_id='')
    {
        $data['notrs'] = $notrs; 
        $data['judul'] = 'Informasi Hasil Laboratorium';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        $data['listdata'] = $this->model('B_InformationHasilLab_Model')->PrintHasil($data); 
        $data['hdr'] = $this->model('B_InformationHasilLab_Model')->PrintHasilHDR($data); 
        $data['footer'] = $this->model('B_InformationHasilLab_Model')->PrintHasilFooter($data); 
        $data['tglsampling'] = $this->model('B_InformationHasilLab_Model')->PrintHasilTglSampling($data); 
        $data['email'] = $this->model('B_InformationHasilLab_Model')->SendmailHasilLab($data);
        $data['param_id'] = $param_id; 
        //get uuid4
        $data['uuid4'] = Utils::uuid4str();
        $data['listdata1'] = $this->model('B_InformationHasilLab_Model')->getAWSURL($data);
        return $this->View('print/information/laboratorium/sendmailhasillab', $data);
    }

    public function InsertLog(){
        echo json_encode($this->model('B_InformationHasilLab_Model')->InsertLog($_POST));
    }

    public function SendWAHasil($notrs = '')
    {
        $data['notrs'] = $notrs; 
        $data['judul'] = 'Informasi Hasil Laboratorium';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        $data['listdata'] = $this->model('B_InformationHasilLab_Model')->PrintHasil($data); 
        $data['hdr'] = $this->model('B_InformationHasilLab_Model')->PrintHasilHDR($data); 
        $data['footer'] = $this->model('B_InformationHasilLab_Model')->PrintHasilFooter($data); 
        $data['tglsampling'] = $this->model('B_InformationHasilLab_Model')->PrintHasilTglSampling($data); 
        $data['token'] = $this->model('Login_Model')->getTokenWapin();
        $data['replacenumberhp'] = Utils::hp($data['hdr']['nohp']);
        return $this->View('print/information/laboratorium/sendwahasillab', $data);
        // $file = $this->View('print/information/laboratorium/printhasillab', $data);
        // $token = $this->model('Login_Model')->getTokenWapin();
        // echo json_encode($this->model('B_InformationHasilLab_Model')->SendWaHasilLab($token,$file));

    }
    public function SendWAHasilKritis()
    {
        echo json_encode($this->model('B_InformationHasilLab_Model')->SendWaHasilLabKritis($_POST));
    }
    public function InsertLogWA(){
        echo json_encode($this->model('B_InformationHasilLab_Model')->InsertLogWhatsapp($_POST));
    }

    public function CekPernahKirim(){
        echo json_encode($this->model('B_InformationHasilLab_Model')->CekPernahKirim($_POST));
    }

    public function ListRegOrderLab()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List New Order Laboratorium';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/laboratorium/ListRegOrderLab', $data);
        $this->View('templates/footer');
    }

    public function getDataListbyNoMR(){
        echo json_encode($this->model('B_InformationHasilLab_Model')->getDataListbyNoMR($_POST));
    }

    public function SaveHasilLaboratorium()
    {
        try {
            $session = SessionManager::getCurrentSession();
            $data['notrs'] = $_POST['notrs'];
            $data['NoRegistrasi'] = $_POST['NoRegistrasi'];
            $data['GrupTransaksi'] = 'HASIL_LABORATORIUM';
            // get data header and detail
            $data['listdata'] = $this->model('B_InformationHasilLab_Model')->PrintHasil($data); 
            $data['hdr'] = $this->model('B_InformationHasilLab_Model')->PrintHasilHDR($data); 
            $data['footer'] = $this->model('B_InformationHasilLab_Model')->PrintHasilFooter($data); 
            $data['tglsampling'] = $this->model('B_InformationHasilLab_Model')->PrintHasilTglSampling($data); 
            //get uuid4
            $data['uuid4'] = Utils::uuid4str();
            //return view
            $this->View('print/information/laboratorium/save_hasillaboratorium', $data);
            echo json_encode($this->model('B_InformationHasilLab_Model')->uploadAWS($data));
        } catch (exception $exception) {
            $this->View('templates/header_login');
            $this->View('login/index');
            $this->View('templates/footer_login');
        }
    }
}
