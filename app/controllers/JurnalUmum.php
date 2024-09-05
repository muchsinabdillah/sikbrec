<?php
class JurnalUmum extends Controller
{

    public function JurnalUmumList()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Daftar Jurnal Umum';
        $data['judul_child'] = 'List Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/finance/ledger/DaftarJurnalUmum_list', $data);
        $this->View('templates/footer');
    }
    public function ViewJurnalUmum($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Jurnal Umum Transaksi';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/finance/ledger/DaftarJurnalUmum_view', $data);
        $this->View('templates/footer');
    }
    public function getDataListDataJurnalUmum() //panggill list awal
    {
        echo json_encode($this->model('B_JurnalUmum_Model')->getDataListDataJurnalUmum($_POST));
    }
    public function getNamaUnit() // panggil nama unit
    {
        echo json_encode($this->model('B_JurnalUmum_Model')->getNamaUnit($_POST));
    }
    public function getRekening() //panggil Rekening
    {
        echo json_encode($this->model('B_JurnalUmum_Model')->getRekeningAllAktif($_POST));
    }
    public function CreateHdrJurnal()
    {
        echo json_encode($this->model('B_JurnalUmum_Model')->CreateHdrJurnal($_POST));
    }
    public function getDataJurnalUmumTransaksi()
    {
        echo json_encode($this->model('B_JurnalUmum_Model')->getDataJurnalUmumTransaksi($_POST));
    }
    public function SaveJurnalUmum()
    {
        echo json_encode($this->model('B_JurnalUmum_Model')->SaveJurnalUmum($_POST));
    }
    public function CreateDtlJurnal()
    {
        echo json_encode($this->model('B_JurnalUmum_Model')->CreateDtlJurnal($_POST));
    }
    public function getSuppliers()
    {
        echo json_encode($this->model('A_Suppliers_Model')->getSuppliers());
    }
    public function getJaminanByIdGroup()
    {

        echo json_encode($this->model('MasterDataGroupJaminan_Model')->getJaminanByIdGroup($_POST));
    }
    public function goShowDataJurnal()
    {
        echo json_encode($this->model('B_JurnalUmum_Model')->goShowDataJurnal($_POST));
    }
    public function VoidHdr()
    {
        echo json_encode($this->model('B_JurnalUmum_Model')->VoidHdr($_POST));
    }
    public function VoidDtl()
    {
        echo json_encode($this->model('B_JurnalUmum_Model')->VoidDtl($_POST));
    }

    public function getRekeningbyID()
    {
        echo json_encode($this->model('B_JurnalUmum_Model')->getRekeningbyID($_POST));
    }
}
