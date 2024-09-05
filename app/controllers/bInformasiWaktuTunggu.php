<?php
class bInformasiWaktuTunggu extends Controller 
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Waktu Tunggu Pasien Poliklinik';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/registration/WaktuTunggu/InformationWaktuTungguPoli', $data);
        $this->View('templates/footer');
    }
    public function getDataListPasien_Poliklinik(){
        echo json_encode($this->model('B_InformationWaktuTunggu_Model')->getDataListPasien($_POST));
    }

    public function WaktuVisiteDJPJ()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Waktu Visite DPJP';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/registration/WaktuTunggu/InformationWaktuVisiteDPJP', $data);
        $this->View('templates/footer');
    }

    public function getDataListPasien_Ranap(){
        echo json_encode($this->model('B_InformationWaktuTunggu_Model')->getDataListPasien_Ranap($_POST));
    }
}
