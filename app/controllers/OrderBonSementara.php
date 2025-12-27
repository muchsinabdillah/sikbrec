<?php
class OrderBonSementara extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Bon Sementara';
        $data['judul_child'] = 'Edit';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('BonSementara/OrderBonSementara_view', $data);
        $this->View('templates/footer');
    }
    public function listOrderBon()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Order Bon Sementara';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('BonSementara/OrderBonSementara_List', $data);
        $this->View('templates/footer');
    }

    public function getListDataBonSementara()
    {
        echo json_encode($this->model('BonSementara_Model')->getListDataBonSementara());
    }

    public function viewBonSementara($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);

        $data['judul'] = 'Bon Sementara';
        $data['judul_child'] = 'Input';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('BonSementara/OrderBonSementara_view', $data);
        $this->View('templates/footer');
    }
    public function getPegawai()
    {
        echo json_encode($this->model('BonSementara_Model')->getPegawai());
    }
    public function PrintBuktiRegis($ID = '')
    {
        $data['noregistrasi'] =  Utils::setDecode($ID);
        $session = SessionManager::getCurrentSession();
        $data['listdata1'] = $this->model('BonSementara_Model')->CetakBon($ID); 
        $this->View('print/finance/print_kas_pengeluaran', $data);
    }
    public function getDataBonbyID()
    {
        echo json_encode($this->model('BonSementara_Model')->getDataBonbyID($_POST));
    }

    public function saveDataBon()
    {
        echo json_encode($this->model('BonSementara_Model')->saveDataBon($_POST));
    }
    public function batalDataBon()
    {
        echo json_encode($this->model('BonSementara_Model')->batalDataBon($_POST));
    }
}
