<?php
class bInfoHariPerawatan extends Controller 
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Hari Perawatan';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/registration/KamarPerawatan/InformationKamarPerawatan', $data);
        $this->View('templates/footer');
    }
    public function getDataList(){
        $this->model('B_InformationKamarPerawatan')->GenerateData($_POST);
        echo json_encode($this->model('B_InformationKamarPerawatan')->getDataList($_POST));
    }
    public function infobor()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi BOR LOS TOI';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/registration/KamarPerawatan/InformationBOR', $data);
        $this->View('templates/footer');
    }

    public function getDataListBOR(){
        $this->model('B_InformationKamarPerawatan')->GenerateData_borlostoi($_POST);
        echo json_encode($this->model('B_InformationKamarPerawatan')->getDataListBOR($_POST));
    }
}
