<?php
class MasterDataBeban extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Master Data Beban';
        $data['judul_child'] = 'Edit';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('BonSementara/MasterDataBeban_List', $data);
        $this->View('templates/footer');
    }
    public function listMasterBeban()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Master Data Beban';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('BonSementara/MasterDataBeban_List', $data);
        $this->View('templates/footer');
    }

    public function getListDataMasterbeban()
    {
        echo json_encode($this->model('Masterdatabeban_Model')->getListDataMasterbeban());
    }

    public function viewMasterBeban($id = null)
    {
        // var_dump("ssss");
        // exit;
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);

        $data['judul'] = 'Master Data Beban ';
        $data['judul_child'] = 'Input';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('BonSementara/MasterDataBeban_view', $data);
        $this->View('templates/footer');
    }
    public function getDataBebanbyID()
    {
        echo json_encode($this->model('Masterdatabeban_Model')->getDataBebanbyID($_POST));
    }
    public function saveDataBeban()
    {
        echo json_encode($this->model('Masterdatabeban_Model')->saveDataBeban($_POST));
    }


    public function getCOA()
    {
        echo json_encode($this->model('Masterdatabeban_Model')->getCOA($_POST));
    }
}
