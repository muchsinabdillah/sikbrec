<?php
class MasterSupplier extends Controller
{
    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id); 
        $data['judul'] = 'Transaksi Master Supplier';
        $data['judul_child'] = 'Input View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/supplier/MasterSupplier_View', $data);
        $this->View('templates/footer');
    }
    public function list()
    {
        $session = SessionManager::getCurrentSession(); 
        $data['judul'] = 'Master Supplier';
        $data['judul_child'] = 'List View';
        // $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/supplier/MasterSupplier_List', $data);
        $this->View('templates/footer');
    } 
    public function showSupplierAll(){
        echo json_encode($this->model('I_MasterData_Supplier_Model')->showSupplierAll($_POST));
    }
    public function addSupplier()
    {
        echo json_encode($this->model('I_MasterData_Supplier_Model')->addSupplier($_POST));
    }
    public function editSupplier()
    {
        echo json_encode($this->model('I_MasterData_Supplier_Model')->editSupplier($_POST));
    }
    public function getSupplierbyId()
    {
        echo json_encode($this->model('I_MasterData_Supplier_Model')->getSupplierbyId($_POST));
    }
}
