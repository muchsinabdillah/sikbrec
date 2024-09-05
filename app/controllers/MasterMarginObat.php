<?php
class MasterMarginObat extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Master Margin Obat';
        $data['judul_child'] = 'List View';
        // $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/margin/MasterMargin_Outstanding_List', $data);
        $this->View('templates/footer');
    }
    public function new()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Master Margin Obat All';
        $data['judul_child'] = 'List View';
        // $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/margin/MasterMargin_List', $data);
        $this->View('templates/footer');
    }
    public function viewData($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Transaksi Master Profit Barang';
        $data['judul_child'] = 'Input View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/margin/MasterMargin_View', $data);
        $this->View('templates/footer');
    }
     
    public function showDataObat()
    {
        echo json_encode($this->model('MasterMargin_Model')->showDataObat($_POST));
    }
    public function showDataObatOutStanding()
    {
        echo json_encode($this->model('MasterMargin_Model')->showDataObatOutStanding($_POST));
    }
    public function getMarginObatbyId()
    {
        echo json_encode($this->model('MasterMargin_Model')->getMarginObatbyId($_POST['id']));
    }
    public function updatemargin()
    {
        echo json_encode($this->model('MasterMargin_Model')->updatemargin($_POST));
    }
}
