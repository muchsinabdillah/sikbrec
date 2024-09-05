<?php
class MasterAsset extends Controller
{
    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Maintenance Asset Form Entri';
        $data['judul_child'] = 'Input View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/asset/Asset_View', $data);
        $this->View('templates/footer');
    }
    public function list()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Data Asset';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/asset/AssetIT_List', $data);
        $this->View('templates/footer');
    }
    public function showDataAsset()
    {
        echo json_encode($this->model('MasterAsset_Model')->showDataAsset());
    }
    public function GetJenisAssetAktif()
    {
        echo json_encode($this->model('MasterAsset_Model')->GetJenisAssetAktif());
    }
    public function GetUnitAktif()
    {
        echo json_encode($this->model('MasterAsset_Model')->GetUnitAktif());
    }

    public function addAsset()
    {
        echo json_encode($this->model('MasterAsset_Model')->addAsset($_POST));
    }
    public function GetAssetID()
    {
        echo json_encode($this->model('MasterAsset_Model')->GetAssetID($_POST));
    }
    public function deleteAsset()
    {
        echo json_encode($this->model('MasterAsset_Model')->deleteAsset($_POST));
    }
}