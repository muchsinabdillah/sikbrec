<?php
class SignatureDigital extends Controller
{
    use hari;
    public function SignatureSep()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Tanda Tangan Pasien';
        $data['judul_child'] = 'Tanda Tangan';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('Signature/index', $data);
        $this->View('templates/footer');
    }
    // general consern
    public function GeneralConsern($noregistrasi = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'PERSETUJUAN UMUM RAWAT INAP / GENERAL CONSENT';
        $data['judul_child'] = 'Input';
        $data['session'] = $session;
        $data['noregistrasi'] =  Utils::setDecode($noregistrasi);
        $jenisreg = substr(Utils::setDecode($noregistrasi),0,2);
        if($jenisreg == "RJ"){
            $data['register'] = $this->GetregistrasiRajalbyNoRegistrasi($data['noregistrasi']);
           
        }else{
            $data['register'] = $this->GetregistrasiRanapbyNoRegistrasiRIDigital($data['noregistrasi']);
        } 
        $this->View('templates/header_nologin', $session);
        $this->View('Signature/GeneralConsen', $data);
        $this->View('templates/footer');
    }
    // akad ijaroh
    public function Akadijaroh($noregistrasi = null)
    {
        $data['noregistrasi'] =  Utils::setDecode($noregistrasi);
        $jenisreg = substr(Utils::setDecode($noregistrasi),0,2);
        
        if($jenisreg == "RJ"){
            $data['register'] = $this->GetregistrasiRajalbyNoRegistrasi($data['noregistrasi']);
          
           
        }else{
            $data['register'] = $this->GetregistrasiRanapbyNoRegistrasiRIDigital($data['noregistrasi']);
        } 

        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Akad Ijaroh';
        $data['judul_child'] = 'Input';
        $data['session'] = $session;
        $data['hari'] = $this->hari_ini();
        $this->View('templates/header_nologin', $session);
        $this->View('Signature/AkadIjaroh', $data);
        $this->View('templates/footer');

    }

    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Menu Tanda Tangan';
        $data['judul_child'] = 'Tanda Tangan';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('SignatureDigitalBpjs/index', $data);
        $this->View('templates/footer');
    }
    public function GetregistrasiRajalbyNoRegistrasi($POST)
    {
       return $this->model('B_create_Registrasi_Rajal')->GetregistrasiRajalbyNoRegistrasiDigital($POST);
    }
    public function GetregistrasiRanapbyNoRegistrasiRIDigital($POST)
    {
        return $this->model('B_create_Registrasi_Rajal')->GetregistrasiRanapbyNoRegistrasiRIDigital($POST);
    }
    public function saveimgSignature()
    {
        echo json_encode($this->model('signature_Model')->Save($_POST));
    }
    public function getPath()
    {
        echo json_encode($this->model('signature_Model')->Path($_POST));
    }
    // input tanda tangan
    public function dobleSignautre()
    {
        $data = $_POST;
        $data['jenisdoc'] = 'AkadIjaroh';
        // var_dump($data);exit;
        // cek validasi 
        
        if ($data['namaparam2'] == "") {
            $this->response(201, "Nama Pihak Ke2 kosong");
        } elseif ($data['namaparam1'] == "") {
            $this->response(404, 'Nama pihak Pertama kosong');
        } elseif (isset($data['path1']) == "") {
            $this->response(404, "Pihak Pertama Belum Melakukan Tanda Tangan");
        } elseif (isset($data['path2']) == "") {
            $this->response(404, "Pihak Kedua Belum Melakukan Tanda Tangan");
        } else {
            echo json_encode($this->model('signature_Model')->uploadToAwsSign_New($data));
        }
    }
    
    public function uploadToAwsSign()
    { 
        echo json_encode($this->model('signature_Model')->uploadToAwsSign($_POST));
    }
    public function uploadToAwsSignGeneralConsen()
    { 
        echo json_encode($this->model('signature_Model')->uploadToAwsSignGeneralConsen($_POST));
    }
    public function uploadToAwsSignHakKewajiban()
    { 
        echo json_encode($this->model('signature_Model')->uploadToAwsSignHakKewajiban($_POST));
    }
    public function response($responsecode, $message)
    {
        $calback = [
            'status' => $responsecode,
            'message' => $message
        ];
        echo json_encode($calback);
    }
    public function RefreshDigitalSign(){
        echo json_encode($this->model('signature_Model')->ceknotransaksi($_POST));
    }
    public function CountCetak()
    {
        echo json_encode($this->model('signature_Model')->CountCetak($_POST));
    }
    public function saveGeneralConsen()
    {
        $data = $_POST;
        $data['jenisdoc'] = 'insertGeneralConsen';

            if ($data['path2'] == 'undefined'){
                $this->response(400, "Pihak Pasien / Keluarga Pasien Belum Tanda Tangan !");
                exit;
            }
        
            if ($data['consen_kuasa'] == 'undefined'){
                $this->response(400, "Ada Pernyataan Yang Belum Dipilih !");
                exit;
            }
    
            if ($data['consen_kondisiPasien'] == 'undefined'){
                $this->response(400, "Ada Pernyataan Yang Belum Dipilih !");
                exit;
            }
    
            if ($data['consen_aksesKeluarga'] == 'undefined'){
                $this->response(400, "Ada Pernyataan Yang Belum Dipilih !");
                exit;
            }
    
            if ($data['consen_privasiKhusus'] == 'undefined'){
                $this->response(400, "Ada Pernyataan Yang Belum Dipilih !");
                exit;
            }
    
            if ($data['consen_nilaikepercayaan'] == 'undefined'){
                $this->response(400, "Ada Pernyataan Yang Belum Dipilih !");
                exit;
            }

            echo json_encode($this->model('signature_Model')->uploadToAwsSign_New($data));
    }

    public function HakdanKewajiban($noregistrasi = null)
    {
        $data['noregistrasi'] =  Utils::setDecode($noregistrasi);
        $jenisreg = substr(Utils::setDecode($noregistrasi),0,2);
        if($jenisreg == "RJ"){
            $data['register'] = $this->GetregistrasiRajalbyNoRegistrasi($data['noregistrasi']);
           
        }else{
            $data['register'] = $this->GetregistrasiRanapbyNoRegistrasiRIDigital($data['noregistrasi']);
        } 

        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Hak dan Kewajiban Pasien';
        $data['judul_child'] = 'Input';
        $data['session'] = $session;
        $data['hari'] = $this->hari_ini();
        $this->View('templates/header_nologin', $session);
        $this->View('Signature/HakdanKewajiban', $data);
        $this->View('templates/footer');

    }

    public function saveHakdanKewajiban()
    {
        $data = $_POST;
        $data['jenisdoc'] = 'saveHakdanKewajiban';
        
        if ($data['namaparam2'] == "") {
            $this->response(201, "Nama Pihak Ke2 kosong");
        } elseif ($data['namaparam1'] == "") {
            $this->response(404, 'Nama pihak Pertama kosong');
        } elseif (isset($data['path1']) == "") {
            $this->response(404, "Pihak Pertama (Petugas) Belum Melakukan Tanda Tangan");
        } elseif (isset($data['path2']) == "") {
            $this->response(404, "Pihak Kedua (Pasien/Wali) Belum Melakukan Tanda Tangan");
        } else {
            echo json_encode($this->model('signature_Model')->uploadToAwsSign_New($data));
        }
    }

    public function TataTertib($noregistrasi = null)
    {
        $data['noregistrasi'] =  Utils::setDecode($noregistrasi);
        $jenisreg = substr(Utils::setDecode($noregistrasi),0,2);
        if($jenisreg == "RJ"){
            $data['register'] = $this->GetregistrasiRajalbyNoRegistrasi($data['noregistrasi']);
           
        }else{
            $data['register'] = $this->GetregistrasiRanapbyNoRegistrasiRIDigital($data['noregistrasi']);
        } 

        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Tata Tertib Pasien';
        $data['judul_child'] = 'Input';
        $data['session'] = $session;
        $data['hari'] = $this->hari_ini();
        $this->View('templates/header_nologin', $session);
        $this->View('Signature/TataTertib', $data);
        $this->View('templates/footer');
    }

    public function saveTataTertib()
    {
        $data = $_POST;
        $data['jenisdoc'] = 'saveTataTertib';
        
        if ($data['namaparam2'] == "") {
            $this->response(201, "Nama Pihak Ke2 kosong");
        } elseif ($data['namaparam1'] == "") {
            $this->response(404, 'Nama pihak Pertama kosong');
        } elseif (isset($data['path1']) == "") {
            $this->response(404, "Pihak Pertama (Petugas) Belum Melakukan Tanda Tangan");
        } elseif (isset($data['path2']) == "") {
            $this->response(404, "Pihak Kedua (Pasien/Wali) Belum Melakukan Tanda Tangan");
        } else {
            echo json_encode($this->model('signature_Model')->uploadToAwsSign_New($data));
        }
    }
    public function uploadToAwsSignTataTertib()
    { 
        echo json_encode($this->model('signature_Model')->uploadToAwsSignTataTertib($_POST));
    }

    public function PerkiraanbiayaNonOP($noregistrasi = null)
    {
        $data['noregistrasi'] =  Utils::setDecode($noregistrasi);
        $jenisreg = substr(Utils::setDecode($noregistrasi),0,2);
        if($jenisreg == "RJ"){
            $data['register'] = $this->GetregistrasiRajalbyNoRegistrasi($data['noregistrasi']);
           
        }else{
            $data['register'] = $this->GetregistrasiRanapbyNoRegistrasiRIDigital($data['noregistrasi']);
        } 

        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Perkiraan Biaya Perawatan Non Operasi';
        $data['judul_child'] = 'Input';
        $data['session'] = $session;
        $data['hari'] = $this->hari_ini();
        $this->View('templates/header_nologin', $session);
        $this->View('Signature/PerkiraanbiayaNonOP', $data);
        $this->View('templates/footer');
    }

    public function savePerkiraanbiayaNonOP()
    {
        $data = $_POST;
        $data['jenisdoc'] = 'savePerkiraanbiayaNonOP';

        // if (!isset($data['pasien_kamarperawatan'])){
        //     $this->response(404, "Mohon Isi Kamar Perawatan !");
        //     exit;
        // }
        
        if ($data['namaparam2'] == "undefined") {
            $this->response(201, "Nama Pihak Ke 2 kosong");
        } elseif ($data['namaparam1'] == "undefined") {
            $this->response(404, 'Nama pihak Pertama kosong');
        } elseif ($data['path1'] == "undefined") {
            $this->response(404, "Pihak Pertama (Petugas) Belum Melakukan Tanda Tangan");
        } elseif ($data['path2'] == "undefined") {
            $this->response(404, "Pihak Kedua (Pasien/Wali) Belum Melakukan Tanda Tangan");
        } else {
            echo json_encode($this->model('signature_Model')->uploadToAwsSign_New($data));
        }
    }
    public function uploadToAwsSignPerkiraanbiayaNonOP()
    { 
        echo json_encode($this->model('signature_Model')->uploadToAwsSignPerkiraanbiayaNonOP($_POST));
    }

    public function getDataFromGC()
    {
       echo json_encode($this->model('signature_Model')->getDataFromGC($_POST));
    }

    public function getDataHistoryGeneralConsent()
    {
       echo json_encode($this->model('signature_Model')->getDataHistoryGeneralConsent($_POST));
    }

    public function getDataHistoryAkadIjaroh()
    {
       echo json_encode($this->model('signature_Model')->getDataHistoryAkadIjaroh($_POST));
    }

    public function getDataHistoryTataTertib()
    {
       echo json_encode($this->model('signature_Model')->getDataHistoryTataTertib($_POST));
    }

    public function getDataHistoryHakdanKewajiban()
    {
       echo json_encode($this->model('signature_Model')->getDataHistoryHakdanKewajiban($_POST));
    }

    public function getDataHistoryBiayaNonOP()
    {
       echo json_encode($this->model('signature_Model')->getDataHistoryBiayaNonOP($_POST));
    }

    public function PerkiraanbiayaOP($noregistrasi = null)
    {
        $data['noregistrasi'] =  Utils::setDecode($noregistrasi);
        $jenisreg = substr(Utils::setDecode($noregistrasi),0,2);
        if($jenisreg == "RJ"){
            $data['register'] = $this->GetregistrasiRajalbyNoRegistrasi($data['noregistrasi']);
           
        }else{
            $data['register'] = $this->GetregistrasiRanapbyNoRegistrasiRIDigital($data['noregistrasi']);
        } 

        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Perkiraan Biaya Perawatan Operasi';
        $data['judul_child'] = 'Input';
        $data['session'] = $session;
        $data['hari'] = $this->hari_ini();
        $this->View('templates/header_nologin', $session);
        $this->View('Signature/PerkiraanbiayaOP', $data);
        $this->View('templates/footer');
    }

    public function savePerkiraanbiayaOP()
    {
        $data = $_POST;
        $data['jenisdoc'] = 'savePerkiraanbiayaOP';

        if (!isset($data['pasien_kamarperawatan'])){
            $this->response(404, "Mohon Isi Kamar Perawatan !");
            exit;
        }
        
        if ($data['namaparam2'] == "undefined") {
            $this->response(201, "Nama Pihak Ke 2 kosong");
        } elseif ($data['namaparam1'] == "undefined") {
            $this->response(404, 'Nama pihak Pertama kosong');
        } elseif ($data['path1'] == "undefined") {
            $this->response(404, "Pihak Pertama (Petugas) Belum Melakukan Tanda Tangan");
        } elseif ($data['path2'] == "undefined") {
            $this->response(404, "Pihak Kedua (Pasien/Wali) Belum Melakukan Tanda Tangan");
        } else {
            echo json_encode($this->model('signature_Model')->uploadToAwsSign_New($data));
        }
    }
    public function uploadToAwsSignPerkiraanbiayaOP()
    { 
        echo json_encode($this->model('signature_Model')->uploadToAwsSignPerkiraanbiayaOP($_POST));
    }

    public function getDataHistoryBiayaOP()
    {
       echo json_encode($this->model('signature_Model')->getDataHistoryBiayaOP($_POST));
    }

    public function ListEdocuments($noregistrasi = null)
    {
        $data['noregistrasi'] =  Utils::setDecode($noregistrasi);
        $jenisreg = substr(Utils::setDecode($noregistrasi),0,2);
        if($jenisreg == "RJ"){
            $data['register'] = $this->GetregistrasiRajalbyNoRegistrasi($data['noregistrasi']);
        }else{
            $data['register'] = $this->GetregistrasiRanapbyNoRegistrasiRIDigital($data['noregistrasi']);
        } 

        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'E-Documents';
        $data['judul_child'] = 'Input';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('Signature/ListHistoryDocuments', $data);
        $this->View('templates/footer');
    }

    public function getCopyDiagnosa()
    {
       echo json_encode($this->model('signature_Model')->getCopyDiagnosa($_POST));
    }

    public function getDataHistoryPersetujuanBiaya()
    {
       echo json_encode($this->model('signature_Model')->getDataHistoryPersetujuanBiaya($_POST));
    }

    public function PersetujuanBiaya($noregistrasi = null)
    {
        $data['noregistrasi'] =  Utils::setDecode($noregistrasi);
        $jenisreg = substr(Utils::setDecode($noregistrasi),0,2);
        if($jenisreg == "RJ"){
            $data['register'] = $this->GetregistrasiRajalbyNoRegistrasi($data['noregistrasi']);
           
        }else{
            $data['register'] = $this->GetregistrasiRanapbyNoRegistrasiRIDigital($data['noregistrasi']);
        } 


        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Persetujuan Biaya Tindakan';
        $data['judul_child'] = 'Input';
        $data['session'] = $session;
        $data['hari'] = $this->hari_ini();
        $this->View('templates/header_nologin', $session);
        $this->View('Signature/PersetujuanBiaya', $data);
        $this->View('templates/footer');
    }

    public function savePersetujuanBiaya()
    {
        $data = $_POST;
        $data['jenisdoc'] = 'savePersetujuanBiaya';
        
        if ($data['namaparam2'] == "") {
            $this->response(201, "Nama Pihak Ke2 kosong");
        } elseif ($data['namaparam1'] == "") {
            $this->response(404, 'Nama pihak Pertama kosong');
        } elseif (isset($data['path1']) == "") {
            $this->response(404, "Pihak Pertama (Petugas) Belum Melakukan Tanda Tangan");
        } elseif (isset($data['path2']) == "") {
            $this->response(404, "Pihak Kedua (Pasien/Wali) Belum Melakukan Tanda Tangan");
        } else {
            echo json_encode($this->model('signature_Model')->uploadToAwsSign_New($data));
        }
    }
    public function uploadToAwsSignPersetujuanBiaya()
    { 
        echo json_encode($this->model('signature_Model')->uploadToAwsSignPersetujuanBiaya($_POST));
    }

    public function getDataHistoryPersetujuanSelisih()
    {
       echo json_encode($this->model('signature_Model')->getDataHistoryPersetujuanSelisih($_POST));
    }
    
    public function PersetujuanSelisih($noregistrasi = null)
    {
        $data['noregistrasi'] =  Utils::setDecode($noregistrasi);
        $jenisreg = substr(Utils::setDecode($noregistrasi),0,2);
        if($jenisreg == "RJ"){
            $data['register'] = $this->GetregistrasiRajalbyNoRegistrasi($data['noregistrasi']);
           
        }else{
            $data['register'] = $this->GetregistrasiRanapbyNoRegistrasiRIDigital($data['noregistrasi']);
        } 
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Persetujuan Membayar Selisih Biaya';
        $data['judul_child'] = 'Input';
        $data['session'] = $session;
        $data['hari'] = $this->hari_ini();
        $this->View('templates/header_nologin', $session);
        $this->View('Signature/PersetujuanSelisih', $data);
        $this->View('templates/footer');
    }

    public function savePersetujuanSelisih()
    {
        $data = $_POST;
        $data['jenisdoc'] = 'savePersetujuanSelisih';
        
        if ($data['namaparam2'] == "") {
            $this->response(201, "Nama Pihak Ke2 kosong");
        } elseif ($data['namaparam1'] == "") {
            $this->response(404, 'Nama pihak Pertama kosong');
        } elseif (isset($data['path1']) == "") {
            $this->response(404, "Pihak Pertama (Petugas) Belum Melakukan Tanda Tangan");
        } elseif (isset($data['path2']) == "") {
            $this->response(404, "Pihak Kedua (Pasien/Wali) Belum Melakukan Tanda Tangan");
        } else {
            echo json_encode($this->model('signature_Model')->uploadToAwsSign_New($data));
        }
    }
     
}