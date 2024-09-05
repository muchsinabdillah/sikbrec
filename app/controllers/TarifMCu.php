<?php
class TarifMcu extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Tarif Mcu';
        $data['judul_child'] = 'List';
        $data['tarifmcu'] = $this->model('B_Tarif_Mcu_Model')->lisTarifMcu();
        $this->View('templates/header', $session);
        $this->View('mcu/list_header_mcu', $data);
        $this->View('templates/footer');
    }

    public function EditDataMcu($namapaket)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Tarif Mcu';
        $data['judul_child'] = 'List';
        $data['namapaket'] = base64_decode($namapaket);
        $data['kodejasa'] = $this->model('B_Tarif_Mcu_Model')->getKodeJasa();
        $data['kodependapatan'] = $this->model('B_Tarif_Mcu_Model')->getKodependapatan();
        $data['detailmcu'] = $this->model('B_Tarif_Mcu_Model')->HeaderPaket(base64_decode($namapaket));
        $this->View('templates/header', $session);
        $this->View('mcu/Editdata', $data);
        $this->View('templates/footer');
    }

    public function inputTarifMcu()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Input Tarif Mcu';
        $data['judul_child'] = 'List';
        $data['kodependapatan'] = $this->model('B_Tarif_Mcu_Model')->getKodependapatan();
        $kodejasa = $data['kodejasa'] = $this->model('B_Tarif_Mcu_Model')->getKodeJasa();
        $this->View('templates/header', $session);
        $this->View('mcu/input_tarif_mcu', $data);
        $this->View('templates/footer');
    }

    public function getRadiologi()
    {
        $dataradiologi = $this->model('B_Tarif_Mcu_Model')->getRadiologi();
        echo json_encode($dataradiologi);
    }

    public function getLaboratorium()
    {
        $datalaboratorum = $this->model('B_Tarif_Mcu_Model')->getDataLaboratorium();
        echo json_encode($datalaboratorum);
    }

    public function getPemeriksaanMCU()
    {
        $datalaboratorum = $this->model('B_Tarif_Mcu_Model')->getPemeriksaanMCU();
        echo json_encode($datalaboratorum);
    }

    public function inputdatarujukan()
    {
        $datarujukan = $this->model('B_Tarif_Mcu_Model')->saveTarifMcu($_POST);
        echo json_encode($datarujukan);
    }
    // detail paket mcu
    public function detailPaket()
    {
        // var_dump($_POST);
        $detailpaket = $this->model('B_Tarif_Mcu_Model')->detailPaket($_POST);
        echo json_encode($detailpaket);
    }
    // update data rujukan
    public function updateItemMcu()
    {
        // var_dump($_POST);
        $updatedatarujukan = $this->model('B_Tarif_Mcu_Model')->update($_POST);
        echo json_encode($updatedatarujukan);
    }

    public function getKodejasa()
    {
        $kodejasa = $this->model('B_Tarif_Mcu_Model')->getKodeJasa();
        echo json_encode($kodejasa);
    }

    public function getHeaderByid()
    {
        $kodejasa = $this->model('B_Tarif_Mcu_Model')->getHeaderByid($_POST);
        echo json_encode($kodejasa);
    }
    // get header by name
    public function getHeaderByName()
    {
        $header = $this->model('B_Tarif_Mcu_Model')->getHeaderByName($_POST);
        echo json_encode($header);
    }
}
