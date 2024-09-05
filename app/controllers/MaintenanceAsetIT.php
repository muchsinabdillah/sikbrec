<?php
class MaintenanceAsetIT extends Controller
{
    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id); 
        $data['judul'] = 'Maintenance Asset Form Entri';
        $data['judul_child'] = 'Input View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/maintenance/MaintenanceAsetIT_View', $data);
        $this->View('templates/footer');
    }
    public function list()
    {
        $session = SessionManager::getCurrentSession(); 
        $data['judul'] = 'Maintenance Asset Table List';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/maintenance/MaintenanceAsetIT_List', $data);
        $this->View('templates/footer');
    }
    public function showDataMaintenance()
    {
        echo json_encode($this->model('MaintenanceAssetIT_Model')->showDataMaintenance());
    }
    public function showListAssetAktif()
    {
        echo json_encode($this->model('MaintenanceAssetIT_Model')->showListAssetAktif());
    }
    public function addMaintenance()
    {
        echo json_encode($this->model('MaintenanceAssetIT_Model')->addMaintenance($_POST));
    }
    public function GetMaintenanceAssetID()
    {
        echo json_encode($this->model('MaintenanceAssetIT_Model')->GetMaintenanceAssetID($_POST));
    }
    public function deleteMaintenance()
    {
        echo json_encode($this->model('MaintenanceAssetIT_Model')->deleteMaintenance($_POST));
    }
    public function showDataMaintenancebyID()
    {
        echo json_encode($this->model('MaintenanceAssetIT_Model')->showDataMaintenancebyID($_POST));
    }
    
}
