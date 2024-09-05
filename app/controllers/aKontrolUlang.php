<?php
class aKontrolUlang extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Daftar Antrian Kontrol Pasien';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('registration/list/aKontrolUlangList', $data);
        $this->View('templates/footer');
    }
    public function showKOntrolUlang()
    {
        echo json_encode($this->model('B_ListKontrolUlang_Model')->showKOntrolUlang($_POST));
    }
    public function Entry($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Input Rencana Kontrol';
        $data['id'] =  Utils::setDecode($id);
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('bridgingbpjs/rencanakontrol/createrencanakontrol', $data);
        $this->View('templates/footer');
    }
    public function EntryKontrolFaskes()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Input Rencana Kontrol Faskes 1';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('bridgingbpjs/rencanakontrol/createrencanakontrolfaskes', $data);
        $this->View('templates/footer');
    }
    public function Update($id = null)
    {
        try {
            $session = SessionManager::getCurrentSession();
            //$cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($session) {
                $session = SessionManager::getCurrentSession();
                $data['id'] =  Utils::setDecode($id);
                $data['judul'] = 'Update Rencana Kontrol';
                $data['session'] = $session;
                $data['judul_child'] = 'Input';
                $this->View('templates/header', $session);
                $this->View('bridgingbpjs/rencanakontrol/updaterencanakontrol', $data);
                $this->View('templates/footer');
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    }
    public function UpdateFaskes($id = null)
    {
        try {
            $session = SessionManager::getCurrentSession();
            //$cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($session) {
                $session = SessionManager::getCurrentSession();
                $data['id'] =  Utils::setDecode($id);
                $data['judul'] = 'Update Rencana Kontrol';
                $data['session'] = $session;
                $data['judul_child'] = 'Input';
                $this->View('templates/header', $session);
                $this->View('bridgingbpjs/rencanakontrol/updaterencanakontrolfaskes', $data);
                $this->View('templates/footer');
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    }
    public function getDataRencanaKontrolDetail()
    {
        echo json_encode($this->model('B_ListKontrolUlang_Model')->getDataRencanaKontrolDetail($_POST));
    }
    public function CreateKontrolUlang()
    {
        echo json_encode($this->model('B_ListKontrolUlang_Model')->CreateKontrolUlang($_POST));
    }
    public function PrintRencanaKontrol($kodetrs = '')
    {
        $data['kodetrs'] = $kodetrs;
        $data['judul'] = 'Informasi Penggajian Pegawai';
        $data['judul_child'] = 'View Informasi';
        //$session = SessionManager::getCurrentSession();
        $data['spri'] = $this->model('B_xBPJSBridging_Model')->PrintSPRI($data);
        $this->View('print/bpjs/PrintRujukanKontrol', $data);
    }
    public function GetRencanaKontrolbyId()
    {
        echo json_encode($this->model('B_ListKontrolUlang_Model')->GetRencanaKontrolbyId($_POST));
    }
    public function setDataSEPRujukanByID()
    {
        echo json_encode($this->model('B_xBPJSBridging_Model')->setDataSEPRujukanByID($_POST));
    }
    public function getDataRencanaKontrolbyIDBPJS()
    {
        echo json_encode($this->model('B_ListKontrolUlang_Model')->getDataRencanaKontrolbyIDBPJS($_POST));
    }

    //Masuk Tanpa Login
    public function EntryNoLogin($id = null)
    {
        //$session = SessionManager::getCurrentSession();
        // $data['id'] =  Utils::setDecode($id);
        $data['id'] =  $id;
        $data['judul'] = 'List View';
        $data['judul_child'] = 'List View';
        $this->View('templates/header_nologin', null);
        $this->View('bridgingbpjs/rencanakontrol/createrencanakontrol_nologin', $data);
        $this->View('templates/footer');
    }

    public function getDataPasien()
    {
        echo json_encode($this->model('B_ListKontrolUlang_Model')->getDataPasien($_POST));
    }

    public function CreateKontrolUlang_2()
    {
        echo json_encode($this->model('B_ListKontrolUlang_Model')->CreateKontrolUlang_2($_POST));
    }

    public function CreateKontrolUlang_EMR()
    {
        echo json_encode($this->model('B_ReservasiNonWalkin_Model')->CreateKontrolUlang_EMR($_POST));
    }

    public function SuratKeteranganKontrolJKN()
    {
        echo json_encode($this->model('B_ListKontrolUlang_Model')->ShowSuratKeteranganKontrolJKN($_POST));
    }
    public function TableKeteranganKontrolJKN()
    {
        echo json_encode($this->model('B_ListKontrolUlang_Model')->ShowTableKeteranganKontrolJKN($_POST));
    }
    public function CetakBuktiPelayananBPJS($id = null)
    {
        $data['id'] = $id; 
        $data['judul'] = 'Bukti Pelayanan BPJS Kesehatan';
        $data['judul_child'] = 'BPJS Kesehatan';
        $data['listdata'] = $this->model('B_ListKontrolUlang_Model')->getDataCetakBuktiPelayananBPJS($data);  
        // if ($data['listdata']['data']['ID'] == null){
        //     $this->View('templates/header_login');
        //     $this->View('page404/page404');
        //     $this->View('templates/footer_login');
        //     exit;
        // }
        $this->View('print/bpjs/printbuktipelayananbpjs', $data);
    }

    public function CetakBuktiSuketKontrol($id = null)
    {
        $data['id'] = $id; 
        $data['judul'] = 'Surat Keterangan Konstrol';
        $data['judul_child'] = 'BPJS Kesehatan';
        $data['listdata'] = $this->model('B_ListKontrolUlang_Model')->getDataSuketKontrolPasien($data);
        $data['listdatadetail'] = $this->model('B_ListKontrolUlang_Model')->getDataSuketKontrolPasienDtl($data);  
        $this->View('print/bpjs/printsuketkontrol', $data);
    }
}
