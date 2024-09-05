<?php
class bInformationDetilRegistrasi extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Rekap Registrasi';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/registration/RekapRegistrasi/InformasiRekapDailyReport', $data);
        $this->View('templates/footer');
    }
    public function getDataListRekap()
    {
        echo json_encode($this->model('B_InformationRekapDetilRegistrasi_Model')->getDataListRekap($_POST));
    }
    public function getIDDokter()
    {
        echo json_encode($this->model('B_InformationRekapDetilRegistrasi_Model')->getIDDokter());
    }
    public function getDataListRekapOnlyUnit()
    {
        echo json_encode($this->model('B_InformationRekapDetilRegistrasi_Model')->getDataListRekap($_POST));
    }
}