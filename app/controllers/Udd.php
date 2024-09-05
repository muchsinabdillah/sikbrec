<?php
class Udd extends Controller
{
    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id); 
        $data['judul'] = 'Transaksi UDD Resep Farmasi';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/udd/udd', $data);
        $this->View('templates/footer');
    }
    public function list()
    {
        $session = SessionManager::getCurrentSession(); 
        $data['judul'] = 'List Data Transaksi UDD Resep Farmasi';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/udd/list/listudd', $data);
        $this->View('templates/footer');
    }

    public function getListResepRanap()
    {
        echo json_encode($this->model('B_Udd_Model')->getListResepRanap($_POST));
    }
    public function getListResepRanapSingle()
    {
        echo json_encode($this->model('B_Udd_Model')->getListResepRanapSingle($_POST));
    }
    public function CreateHeaderUdd(){
        echo json_encode($this->model('B_Udd_Model')->CreateHeaderUdd($_POST));
    }
    public function getListResepDetilByNoresep()
    {
        echo json_encode($this->model('B_Udd_Model')->getListResepDetilByNoresep($_POST));
    }
    public function CreateDetilUdd(){
        echo json_encode($this->model('B_Udd_Model')->CreateDetilUdd($_POST));
    }
    public function loaddataUddDetailById(){
        echo json_encode($this->model('B_Udd_Model')->loaddataUddDetailById($_POST));
    }
    public function voidTransaksiUDD(){
        echo json_encode($this->model('B_Udd_Model')->voidTransaksiUDD($_POST));
    }
    public function deleteUddDetil()
    {
        echo json_encode($this->model('B_Udd_Model')->deleteUddDetil($_POST));
    }
    public function getDataUddHeaderbyTrsid()
    {
        echo json_encode($this->model('B_Udd_Model')->getDataUddHeaderbyTrsid($_POST));
    }
    public function PrintLabelUDD($nomr = '')
    {
        $data['IdTransaksi'] =  Utils::setDecode($nomr);
        $session = SessionManager::getCurrentSession();
        $data['listdata1'] = $this->model('B_Udd_Model')->getDataUddHeaderbyTrsid($data);
        $data['listdata2'] = $this->model('B_Udd_Model')->loaddataUddDetailById($data);
        // var_dump($data['listdata2']);exit;
        $this->View('print/farmasi/print_label_udd', $data);
    }
    public function getlistDataUddAll()
    {
        echo json_encode($this->model('B_Udd_Model')->getlistDataUddAll());
    }
}
