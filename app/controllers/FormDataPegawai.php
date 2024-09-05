<?php
class FormDataPegawai extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Form Data Dokumen Pegawai';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('form/HRD/FormDataPegawai', $data);
        $this->View('templates/footer');
    }

    //BADRUL
    public function EntriDataPribadi($idmr = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Form Entri Data Pribadi';
        $data['judul_child'] = 'Entri Data';
        $data['idmrx'] = $idmr;
        $data['idfile'] = null;
        $this->View('templates/header', $session);
        $this->View('form/HRD/FormDataPribadi', $data);
        $this->View('templates/footer');
    }
    public function UpdateDataPribadi($idF = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Form Update Data Pribadi';
        $data['judul_child'] = 'Update Data';
        $data['idmrx'] = null;
        $data['idfile'] = $idF;
        $this->View('templates/header', $session);
        $this->View('form/HRD/FormDataPribadi', $data);
        $this->View('templates/footer');
    }
    public function EntriDataKeluarga($idmr = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Form Entri Data Keluarga';
        $data['judul_child'] = 'Entri Data';
        $data['idmrx'] = $idmr;
        $data['idfile'] = null;
        $this->View('templates/header', $session);
        $this->View('form/HRD/FormDataKeluarga', $data);
        $this->View('templates/footer');
    }
    public function UpdateDataKeluarga($idF = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Form Update Data Keluarga';
        $data['judul_child'] = 'Update Data';
        $data['idmrx'] = null;
        $data['idfile'] = $idF;
        $this->View('templates/header', $session);
        $this->View('form/HRD/FormDataKeluarga', $data);
        $this->View('templates/footer');
    }
    public function EntriDataPendidikan($idmr = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Form Entri Data Pendidikan';
        $data['judul_child'] = 'Entri Data';
        $data['idmrx'] = $idmr;
        $data['idfile'] = null;
        $this->View('templates/header', $session);
        $this->View('form/HRD/FormDataPendidikan', $data);
        $this->View('templates/footer');
    }
    public function UpdateDataPendidikan($idF = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Form Update Data Pendidikan';
        $data['judul_child'] = 'Update Data';
        $data['idmrx'] = null;
        $data['idfile'] = $idF;
        $this->View('templates/header', $session);
        $this->View('form/HRD/FormDataPendidikan', $data);
        $this->View('templates/footer');
    }
    
    public function EntriDataPelatihan($idmr = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Form Entri Data Pelatihan';
        $data['judul_child'] = 'Entri Data';
        $data['idmrx'] = $idmr;
        $data['idfile'] = null;
        $this->View('templates/header', $session);
        $this->View('form/HRD/FormDataPelatihan', $data);
        $this->View('templates/footer');
    }

    public function UpdateDataPelatihan($idF = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Form Update Data Pelatihan';
        $data['judul_child'] = 'Update Data';
        $data['idmrx'] = null;
        $data['idfile'] = $idF;
        $this->View('templates/header', $session);
        $this->View('form/HRD/FormDataPelatihan', $data);
        $this->View('templates/footer');
    }

    public function EntriDataSIP($idmr = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Form Entri Data SIP';
        $data['judul_child'] = 'Entri Data';
        $data['idmrx'] = $idmr;
        $data['idfile'] = null;
        $this->View('templates/header', $session);
        $this->View('form/HRD/FormDataSIP', $data);
        $this->View('templates/footer');
    }

    public function UpdateDataSIP($idF = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Form Update Data SIP';
        $data['judul_child'] = 'Update Data';
        $data['idmrx'] = null;
        $data['idfile'] = $idF;
        $this->View('templates/header', $session);
        $this->View('form/HRD/FormDataSIP', $data);
        $this->View('templates/footer');
    }


    public function EntriDataSTR($idmr = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Form Entri Data STR';
        $data['judul_child'] = 'Entri Data';
        $data['idmrx'] = $idmr;
        $data['idfile'] = null;
        $this->View('templates/header', $session);
        $this->View('form/HRD/FormDataSTR', $data);
        $this->View('templates/footer');
    }

    public function UpdateDataSTR($idF = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Form Update Data STR';
        $data['judul_child'] = 'Update Data';
        $data['idmrx'] = null;
        $data['idfile'] = $idF;
        $this->View('templates/header', $session);
        $this->View('form/HRD/FormDataSTR', $data);
        $this->View('templates/footer');
    }
    

    public function EntriDataMCU($idmr = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Form Entri Data MCU';
        $data['judul_child'] = 'Entri Data';
        $data['idmrx'] = $idmr;
        $data['idfile'] = null;
        $this->View('templates/header', $session);
        $this->View('form/HRD/FormuplodMCU', $data);
        $this->View('templates/footer');
    }

    public function UpdateDataMCU($idF = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Form Update Data MCU';
        $data['judul_child'] = 'Update Data';
        $data['idmrx'] = null;
        $data['idfile'] = $idF;
        $this->View('templates/header', $session);
        $this->View('form/HRD/FormuplodMCU', $data);
        $this->View('templates/footer');
    }

    
    public function EntriDataMOU($idmr = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Form Entri Data MOU';
        $data['judul_child'] = 'Entri Data';
        $data['idmrx'] = $idmr;
        $data['idfile'] = null;
        $this->View('templates/header', $session);
        $this->View('form/HRD/FormuplodMOU', $data);
        $this->View('templates/footer');
    }

    public function UpdateDataMOU($idF = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Form Update Data MOU';
        $data['judul_child'] = 'Update Data';
        $data['idmrx'] = null;
        $data['idfile'] = $idF;
        $this->View('templates/header', $session);
        $this->View('form/HRD/FormuplodMOU', $data);
        $this->View('templates/footer');
    }
    

    public function EntriDataSKPegawai($idmr = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Form Entri Data SK Pegawai';
        $data['judul_child'] = 'Entri Data';
        $data['idmrx'] = $idmr;
        $data['idfile'] = null;
        $this->View('templates/header', $session);
        $this->View('form/HRD/FormuplodSKPegawai', $data);
        $this->View('templates/footer');
    }

    public function UpdateDataSKPegawai($idF = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Form Update Data SK Pegawai';
        $data['judul_child'] = 'Update Data';
        $data['idmrx'] = null;
        $data['idfile'] = $idF;
        $this->View('templates/header', $session);
        $this->View('form/HRD/FormuplodSKPegawai', $data);
        $this->View('templates/footer');
    }

    public function EntriDataRKK($idmr = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Form Entri Data RKK';
        $data['judul_child'] = 'Entri Data';
        $data['idmrx'] = $idmr;
        $data['idfile'] = null;
        $this->View('templates/header', $session);
        $this->View('form/HRD/FormDataRKK', $data);
        $this->View('templates/footer');
    }

    public function UpdateDataRKK($idF = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Form Update Data RKK';
        $data['judul_child'] = 'Update Data';
        $data['idmrx'] = null;
        $data['idfile'] = $idF;
        $this->View('templates/header', $session);
        $this->View('form/HRD/FormDataRKK', $data);
        $this->View('templates/footer');
    }

    public function EntriDataSPK($idmr = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Form Entri Data SPK';
        $data['judul_child'] = 'Entri Data';
        $data['idmrx'] = $idmr;
        $data['idfile'] = null;
        $this->View('templates/header', $session);
        $this->View('form/HRD/FormDataSPK', $data);
        $this->View('templates/footer');
    }

    public function UpdateDataSPK($idF = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Form Update Data SPK';
        $data['judul_child'] = 'Update Data';
        $data['idmrx'] = null;
        $data['idfile'] = $idF;
        $this->View('templates/header', $session);
        $this->View('form/HRD/FormDataSPK', $data);
        $this->View('templates/footer');
    }

//BADRUL

    public function getListFormdatapegawai()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->getListFormdatapegawai($_POST));
    }
    public function getDatapegawai()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->getDatapegawai($_POST));
    }
    //badrul
    public function getDataKeluargaDetail()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->getDataKeluargaDetail($_POST));
    }
    public function getDataPendidikanDetail()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->getDataPendidikanDetail($_POST));
    }
    public function getDataPelatihanDetail()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->getDataPelatihanDetail($_POST));
    }

    public function getDataSIPDetail()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->getDataSIPDetail($_POST));
    }

    public function getDataPribadiDetail()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->getDataPribadiDetail($_POST));
    }
    public function getDataRKKDetail()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->getDataRKKDetail($_POST));
    }
    public function getDataSPKDetail()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->getDataSPKDetail($_POST));
    }

    public function getDataSTRDetail()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->getDataSTRDetail($_POST));
    }

    public function getDataMCUDetail()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->getDataMCUDetail($_POST));
    }

    public function getDataMOUDetail()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->getDataMOUDetail($_POST));
    }

    public function getDataSKPegawaiDetail()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->getDataSKPegawaiDetail($_POST));
    }
    
    //badrul
    public function uploadDataRKK()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->uploadDataRKK($_POST));
    }
    public function getDataListRKK()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->getDataListRKK($_POST));
    }
    public function uploadDataSPK()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->uploadDataSPK($_POST));
    }
    public function getDataListSPK()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->getDataListSPK($_POST));
    }
    public function uploadDataPribadi()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->uploadDataPribadi($_POST));
    }
    public function getDataListPribadi()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->getDataListPribadi($_POST));
    }
    public function uploadDataKeluarga()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->uploadDataKeluarga($_POST));
    }
    public function getDataListKeluarga()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->getDataListKeluarga($_POST));
    }
    public function uploadDataPendidikan()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->uploadDataPendidikan($_POST));
    }
    public function getDataListPendidikan()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->getDataListPendidikan($_POST));
    }
    public function uploadDataPelatihan()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->uploadDataPelatihan($_POST));
    }
    public function getDataListPelatihan()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->getDataListPelatihan($_POST));
    }
    public function uploadDataSIP()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->uploadDataSIP($_POST));
    }
    public function getDataListSIP()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->getDataListSIP($_POST));
    }
    public function uploadDataSTR()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->uploadDataSTR($_POST));
    }
    public function getDataListSTR()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->getDataListSTR($_POST));
    }

    public function uploadDataMCU()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->uploadDataMCU($_POST));
    }
    public function getDataListMCU()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->getDataListMCU($_POST));
    }

    public function uploadDataMOU()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->uploadDataMOU($_POST));
    }
    public function getDataListMOU()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->getDataListMOU($_POST));
    }

    public function uploadDataSKPegawai()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->uploadDataSKPegawai($_POST));
    }
    public function getDataListSKPegawai()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->getDataListSKPegawai($_POST));
    }
}