<?php
class MasterAsset extends Controller
{
    use Edocuments;
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
    public function cetakan($notrs = '')
    {
        $data['notrs'] = $notrs; 
        $session = SessionManager::getCurrentSession();
        $data['listdata1'] = $this->model('MasterAsset_Model')->cetakan($data); 
        // $this->View('print/asset/print_asset_it', $data);
        $data['filedoc'] = 'print/asset/hdr_asset_it';
        $this->PrintFile($data);

    }
    public function cetakan_cadangan_bartender($notrs = '')
    {
        $data['notrs'] = $notrs; 
        $session = SessionManager::getCurrentSession();
        $data['listdata1'] = $this->model('MasterAsset_Model')->cetakan($data); 
        // // $this->View('print/asset/print_asset_it', $data);
        // $data['filedoc'] = 'print/asset/hdr_asset_it';
        // $this->PrintFile($data);
            echo json_encode($this->model('MasterAsset_Model')->printLabelAll($data));

        // foreach ($data['listdata1'] as $row) {
        //     if ($row['Racik'] == 0 || ($row['Header'] == 1 && $row['Racik'] <> 0)){
        //     $data['listdata12'] = $this->model('B_Farmasi')->viewprintLabelbyID($data);
        //     $data['getSignaObat'] = $this->model('B_Farmasi')->getSignaObat_New($data);  
        //     $data['getPrinterLabel'] = $this->model('B_Farmasi')->getPrinterLabel($data); 
        //     if ($data['getPrinterLabel']['status'] == false){
        //         echo json_encode($data['getPrinterLabel']);
        //         exit;
        //     }
        //     echo json_encode($this->model('B_Farmasi')->printLabelAll($data));
        //   }
        // }
    }
}