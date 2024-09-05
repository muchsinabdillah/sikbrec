<?php
class FormDataSIP extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Form Data SIP';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('form/HRD/FormDataPegawai', $data);
        $this->View('templates/footer');
    }

    public function EntriDataKeluarga($idmr = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Form Data SIP';
        $data['judul_child'] = 'Entri Data';
        $data['idmrx'] = $idmr;
        $this->View('templates/header', $session);
        $this->View('form/HRD/FormDataKeluarga', $data);
        $this->View('templates/footer');
    }
    public function getListFormdatapegawai()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->getListFormdatapegawai($_POST));
    }
    public function getDatapegawai()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->getDatapegawai($_POST));
    }
    public function uploadDataKeluarga()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->uploadDataKeluarga($_POST));
    }
    public function getDataListKeluarga()
    {
        echo json_encode($this->model('Formdatapegawai_Model')->getDataListKeluarga($_POST));
    }
}
