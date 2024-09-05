<?php
class MasterDataFormularium extends Controller
{
    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id); 
        $data['judul'] = 'Transaksi Master Formularium';
        $data['judul_child'] = 'Input View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/formularium/MasterFormularium_View', $data);
        $this->View('templates/footer');
    }
    public function list()
    {
        $session = SessionManager::getCurrentSession(); 
        $data['judul'] = 'Master Formularium';
        $data['judul_child'] = 'List View';
        $this->View('templates/header', $session);
        $this->View('inventory/formularium/MasterFormularium_List', $data);
        $this->View('templates/footer');
    } 
    public function getFormulariumAll(){
        echo json_encode($this->model('I_MasterData_Formularium_Model')->showFormulariumBarangAll($_POST));
    }
    public function addFormularium()
    {
        echo json_encode($this->model('I_MasterData_Formularium_Model')->addFormularium($_POST));
    }
    public function editFormularium()
    {
        echo json_encode($this->model('I_MasterData_Formularium_Model')->editFormularium($_POST));
    }
    public function getFormulariumbyId()
    {
        echo json_encode($this->model('I_MasterData_Formularium_Model')->getFormulariumbyId($_POST));
    }
}
