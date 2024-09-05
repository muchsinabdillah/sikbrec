<?php
 
class MasterPaketInventory extends Controller
{
    public function index($id = null)
    {
        $data['id'] =  Utils::setDecode($id); 
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Paket Inventory';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/masterpaket/MasterPaketInventory_View', $data);
        $this->View('templates/footer');
    }

    public function List()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Paket Inventory';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/masterpaket/MasterPaketInventory_List', $data);
        $this->View('templates/footer');
    }
    
    public function showall(){
        echo json_encode($this->model('I_MasterPaketInventory_Model')->showall());
    }
    public function addPaketInventory(){
        echo json_encode($this->model('I_MasterPaketInventory_Model')->addPaketInventory($_POST));
    }
    public function getPaketInventorybyId(){
        echo json_encode($this->model('I_MasterPaketInventory_Model')->getPaketInventorybyId($_POST));
    }
    public function editPaketInventory(){
        echo json_encode($this->model('I_MasterPaketInventory_Model')->editPaketInventory($_POST));
    }
    public function addDetailPaketInventory()
    {
        echo json_encode($this->model('I_MasterPaketInventory_Model')->addDetailPaketInventory($_POST));
    }
    public function getDetailPaketInventory()
    {
        echo json_encode($this->model('I_MasterPaketInventory_Model')->getDetailPaketInventory($_POST));
    }
    public function deleteDetailPaketInventory()
    {
        echo json_encode($this->model('I_MasterPaketInventory_Model')->deleteDetailPaketInventory($_POST));
    }
} 