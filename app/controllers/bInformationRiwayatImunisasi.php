<?php
class bInformationRiwayatImunisasi extends Controller 
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Riwayat Imunisasi Anak';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/registration/RiwayatImunisasi/InformationRiwayatImunisasi', $data);
        $this->View('templates/footer');
    }
    public function getDataListPasien(){
        echo json_encode($this->model('B_InformationRiwayatImunisasi_Model')->getDataListPasien($_POST));
    }
}
