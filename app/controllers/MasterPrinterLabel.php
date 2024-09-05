<?php
 
class MasterPrinterLabel extends Controller
{
    public function index($id = null)
    {
        $data['id'] =  Utils::setDecode($id); 
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Data View Printer Label';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/masterprinterlabel/MasterPrinterLabel_View', $data);
        $this->View('templates/footer');
    }

    public function List()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Data List Printer Label';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/masterprinterlabel/MasterPrinterLabel_List', $data);
        $this->View('templates/footer');
    }
    
    public function showall(){
        echo json_encode($this->model('I_MasterPrinterLabel_Model')->showall());
    }
    public function getPrinterLabelbyId(){
        echo json_encode($this->model('I_MasterPrinterLabel_Model')->getPrinterLabelbyId($_POST));
    }
    public function addData(){
        echo json_encode($this->model('I_MasterPrinterLabel_Model')->addData($_POST));
    }
    public function editData(){
        echo json_encode($this->model('I_MasterPrinterLabel_Model')->editData($_POST));
    }
} 