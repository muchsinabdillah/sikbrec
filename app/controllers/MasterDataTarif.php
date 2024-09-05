<?php
class MasterDataTarif extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Data Dokter';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('datamaster/MasterDataDokter/MasterDataDokter_Table', $data);
        $this->View('templates/footer');
    }
    public function GetTarifLaboratorium()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->GetTarifLaboratorium($_POST));
    }
    public function getDataPemeriksaanLabByID()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getDataPemeriksaanLabByID($_POST));
    }

    //Transaksi Tarif
    public function listtransaksitarif()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Transaksi Tarif Rawat Jalan';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Tarif/TransaksiTarif/TransaksiTarif_List', $data);
        $this->View('templates/footer');
    }
    public function listtransaksitariflab()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Transaksi Tarif Laboratorium';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Tarif/TransaksiTarif/TransaksiTarif_List_Lab', $data);
        $this->View('templates/footer');
    }
    public function listtransaksitarifrad()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Transaksi Tarif Radiologi';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Tarif/TransaksiTarif/TransaksiTarif_List_Rad', $data);
        $this->View('templates/footer');
    }
    public function listtransaksitarifri()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Transaksi Rawat Inap';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Tarif/TransaksiTarif/TransaksiTarif_List_RI', $data);
        $this->View('templates/footer');
    }
    public function getListDataTransaksiTarif()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getListDataTransaksiTarif($_POST));
    }
    public function getListDataTransaksiTarifLab()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getListDataTransaksiTarifLab($_POST));
    }
    public function getListDataTransaksiTarifRad()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getListDataTransaksiTarifRad($_POST));
    }
    public function getListDataTransaksiTarifRI()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getListDataTransaksiTarifRI($_POST));
    }
    public function viewtransaksitarif($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Transaksi Tarif - RAWAT JALAN';
        $data['judul_child'] = 'Input';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Tarif/TransaksiTarif/TransaksiTarif_View', $data);
        $this->View('templates/footer');
    }
    public function viewtransaksitariflab($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Transaksi Tarif - LABORATORIUM';
        $data['judul_child'] = 'Input';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Tarif/TransaksiTarif/TransaksiTarifLab_View', $data);
        $this->View('templates/footer');
    }
    public function viewtransaksitarifrad($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Transaksi Tarif - RADIOLOGI';
        $data['judul_child'] = 'Input';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Tarif/TransaksiTarif/TransaksiTarifRad_View', $data);
        $this->View('templates/footer');
    }
    public function viewtransaksitarifri($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Transaksi Tarif - RAWAT INAP';
        $data['judul_child'] = 'Input';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Tarif/TransaksiTarif/TransaksiTarifRI_View', $data);
        $this->View('templates/footer');
    }
    public function saveTrs_Tarif()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->saveTrs_Tarif($_POST));
    }
    public function saveTrs_Tariflab()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->saveTrs_Tariflab($_POST));
    }
    public function saveTrs_Tarifrad()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->saveTrs_Tarifrad($_POST));
    }
    public function saveTrs_TarifRI()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->saveTrs_TarifRI($_POST));
    }
    public function getTransaksiTarifbyID()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getTransaksiTarifbyID($_POST));
    }
    public function getTransaksiTarifbyIDlab()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getTransaksiTarifbyIDlab($_POST));
    }
    public function getTransaksiTarifbyIDrad()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getTransaksiTarifbyIDrad($_POST));
    }
    public function getTransaksiTarifbyIDRI()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getTransaksiTarifbyIDRI($_POST));
    }
    public function BatalTransaksiTarif()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->BatalTransaksiTarif($_POST));
    }
    public function BatalTransaksiTariflab()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->BatalTransaksiTariflab($_POST));
    }
    public function BatalTransaksiTarifrad()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->BatalTransaksiTarifrad($_POST));
    }
    public function BatalTransaksiTarifRI()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->BatalTransaksiTarifRI($_POST));
    }

    public function getListTransaksiTarif_Detail()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getListTransaksiTarif_Detail($_POST));
    }
    public function getListTransaksiTarif_Detaillab()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getListTransaksiTarif_Detaillab($_POST));
    }
    public function getListTransaksiTarif_Detailrad()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getListTransaksiTarif_Detailrad($_POST));
    }
    public function getListTransaksiTarif_Detailri()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getListTransaksiTarif_Detailri($_POST));
    }

    public function viewtransaksitarifdetail($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Transaksi Tarif Detail -  RAWAT JALAN';
        $data['judul_child'] = 'Input';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Tarif/TransaksiTarif/TransaksiTarif_ViewDetail', $data);
        $this->View('templates/footer');
    }
    public function viewtransaksitarifdetaillab($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Transaksi Tarif Detail - LABORATORIUM';
        $data['judul_child'] = 'Input';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Tarif/TransaksiTarif/TransaksiTariflLab_ViewDetail', $data);
        $this->View('templates/footer');
    }
    public function viewtransaksitarifdetailrad($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Transaksi Tarif Detail - RADIOLOGI';
        $data['judul_child'] = 'Input';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Tarif/TransaksiTarif/TransaksiTarifRad_ViewDetail', $data);
        $this->View('templates/footer');
    }
    public function viewtransaksitarifdetailri($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Transaksi Tarif Detail - RAWAT INAP';
        $data['judul_child'] = 'Input';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Tarif/TransaksiTarif/TransaksiTarifRI_ViewDetail', $data);
        $this->View('templates/footer');
    }
    public function ImportFile()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->ImportFile($_POST));
    }

    //#END Transaksi Tarif

    //GET KODE PDP DAN JASA----------------
    public function getKodePDP()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getKodePDP());
    }

    public function getKodeJasa()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getKodeJasa($_POST));
    }
    //#END GET KODE PDP DAN JASA------------

    //TARIF RAJAL
    public function listrajal()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Rawat Jalan';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Tarif/TarifRajal/MasterTarif_Rajal', $data);
        $this->View('templates/footer');
    }

    public function listranap()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Rawat Inap';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Tarif/TarifRanap/MasterTarif_Ranap', $data);
        $this->View('templates/footer');
    }

    public function listradiologi()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Radiologi';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Tarif/TarifRadiologi/MasterTarif_Radiologi', $data);
        $this->View('templates/footer');
    }

    public function getListDataTarifRajal()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getListDataTarifRajal($_POST));
    }

    public function getListDataTarifRanap()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getListDataTarifRanap($_POST));
    }

    public function getListDataTarifRadiologi()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getListDataTarifRadiologi($_POST));
    }


    public function viewrajal($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['kd_instalasi'] =  'RJ';
        $data['judul'] = 'Rawat Jalan';
        $data['judul_child'] = 'Input';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Tarif/TarifRajal/MasterTarif_Rajal_View', $data);
        $this->View('templates/footer');
    }

    public function viewranap($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['kd_instalasi'] =  'RI';
        $data['judul'] = 'Rawat Inap';
        $data['judul_child'] = 'Input';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Tarif/TarifRanap/MasterTarif_Ranap_View', $data);
        $this->View('templates/footer');
    }

    public function viewradiologi($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['kd_instalasi'] =  'RAD';
        $data['judul'] = 'Radiologi';
        $data['judul_child'] = 'Input';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Tarif/TarifRadiologi/MasterTarif_Radiologi_View', $data);
        $this->View('templates/footer');
    }


    public function getTarifRajalbyID()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getTarifRajalbyID($_POST));
    }

    public function getTarifRanapbyID()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getTarifRanapbyID($_POST));
    }

    public function getTarifRadiologibyID()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getTarifRadiologibyID($_POST));
    }

    public function saveTrs_Rajal()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->saveTrs_Rajal($_POST));
    }
    public function saveTrs_Ranap()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->saveTrs_Ranap($_POST));
    }

    public function saveTrs_Radiologi()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->saveTrs_Radiologi($_POST));
    }

    public function getListTarifRajal_Layanan()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getListTarifRajal_Layanan($_POST));
    }

    public function getListTarifRanap_Layanan()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getListTarifRanap_Layanan($_POST));
    }

    public function getListTarifRadiologi_Layanan()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getListTarifRadiologi_Layanan($_POST));
    }

    public function addTarifLayanan()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->addTarifLayanan($_POST));
    }

    public function deleteTarifLayanan()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->deleteTarifLayanan($_POST['id']));
    }

    public function getListTarifRajal_Histori()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getListTarifRajal_Histori($_POST));
    }

    public function getListTarifRanap_Histori()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getListTarifRanap_Histori($_POST));
    }

    public function getListTarifRadiologi_Histori()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getListTarifRadiologi_Histori($_POST));
    }

    //#END TARIF RAJAL

    //TARIF LAB
    public function listlab()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Laboratorium';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Tarif/TarifLab/MasterTarif_Lab', $data);
        $this->View('templates/footer');
    }

    public function getListDataTarifLab()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getListDataTarifLab($_POST));
    }

    public function getTarifLabbyID()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getTarifLabbyID($_POST));
    }

    public function viewlab($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['kd_instalasi'] =  'LAB';
        $data['judul'] = 'Laboratorium';
        $data['judul_child'] = 'Input';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Tarif/TarifLab/MasterTarif_Lab_View', $data);
        $this->View('templates/footer');
    }

    public function getKodeTes()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getKodeTes());
    }

    public function getKodeTesbyID()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getKodeTesbyID($_POST));
    }

    public function saveTrs_Lab()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->saveTrs_Lab($_POST));
    }

    //#END LAB

    //TINDAKAN LAB
    public function listtindakanlab()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Tindakan Laboratorium';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Tarif/TindakanLab/MasterTindakan_Lab', $data);
        $this->View('templates/footer');
    }

    public function getListDataTindakanLab()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getListDataTindakanLab($_POST));
    }

    public function getTindakanLabbyID()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getTindakanLabbyID($_POST));
    }

    public function viewtindakanlab($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['kd_instalasi'] =  'LAB';
        $data['judul'] = 'Tindakan Laboratorium';
        $data['judul_child'] = 'Input';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('Tarif/TindakanLab/MasterTIndakan_Lab_View', $data);
        $this->View('templates/footer');
    }

    public function saveTrsTindakan_Lab()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->saveTrsTindakan_Lab($_POST));
    }

    public function getListTindakanLab_NilaiRujukan()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getListTindakanLab_NilaiRujukan($_POST));
    }

    public function deleteLabRujukan(){
        echo json_encode($this->model('A_MasterDataTarif_Model')->deleteLabRujukan($_POST['id']));
    }

    public function getDataDetailbyID()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getDataDetailbyID($_POST));
    }

    public function getParameterUsia()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->getParameterUsia());
    }

    public function addNilaiRujukan()
    {
        echo json_encode($this->model('A_MasterDataTarif_Model')->addNilaiRujukan($_POST));
    }

    

}
