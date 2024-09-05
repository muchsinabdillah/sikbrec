<?php
class InfoMasterTarif extends Controller
{
    //TARIF RAJAL
    public function MasterTarif()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Master Tarif';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Tarif/MasterTarifInfo', $data);
        $this->View('templates/footer');
    }
    public function GetDataTarifRajal()
    {
        echo json_encode($this->model('A_InfoMasterTarif_Model')->GetDataTarifRajal($_POST));
    }
    public function load_data_Ranap()
    {
        echo json_encode($this->model('A_InfoMasterTarif_Model')->load_data_Ranap($_POST));
    }
    public function GetDataRadiologi()
    {
        echo json_encode($this->model('A_InfoMasterTarif_Model')->GetDataRadiologi($_POST));
    }
    public function GetDataLaboratorium()
    {
        echo json_encode($this->model('A_InfoMasterTarif_Model')->GetDataLaboratorium($_POST));
    }
    public function getGrupPerawatan()
    {
        echo json_encode($this->model('A_InfoMasterTarif_Model')->getGrupPerawatan());
    }
    public function getGroupmcu()
    {
        echo json_encode($this->model('A_InfoMasterTarif_Model')->getGroupmcu($_POST));
    }
    public function GetDataTarif()
    {
        echo json_encode($this->model('A_InfoMasterTarif_Model')->GetDataTarif($_POST));
    }
    public function LoadDataMCU()
    {
        echo json_encode($this->model('A_InfoMasterTarif_Model')->LoadDataMCU($_POST));
    }

    public function getDataOperasi()
    {
        echo json_encode($this->model('A_InfoMasterTarif_Model')->getDataOperasi($_POST));
    }
    public function ShowDetailOperasi()
    {
        echo json_encode($this->model('A_InfoMasterTarif_Model')->ShowDetailOperasi($_POST));
    }

    public function getKategoriOperasi()
    {
        echo json_encode($this->model('A_InfoMasterTarif_Model')->getKategoriOperasi($_POST));
    }
    public function getTindakanOperasi()
    {
        echo json_encode($this->model('A_InfoMasterTarif_Model')->getTindakanOperasi($_POST));
    }
    public function getDataGroupSpesialis()
    {
        echo json_encode($this->model('A_InfoMasterTarif_Model')->getDataGroupSpesialis($_POST));
    }
}
