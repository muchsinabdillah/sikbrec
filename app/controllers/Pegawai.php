<?php
class Pegawai extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Master Pegawai';
        $data['judul_child'] = 'Input';
        $this->View('templates/header', $session);
        $this->View('datamaster/pegawai/Pegawai', $data);
        $this->View('templates/footer');
    }
    public function getpegawaiAllAktif()
    {
        echo json_encode($this->model('Pegawai_Model')->getpegawaiAllAktif());
    }
    public function getpegawaiPM(){
        echo json_encode($this->model('Pegawai_Model')->getpegawaiPM());
    }
    public function addPegawaibyProjectMou()
    {
        echo json_encode($this->model('Pegawai_Model')->insert($_POST));
    }
    public function showdataProjectM(){
        echo json_encode($this->model('Pegawai_Model')->showdataProjectM($_POST));
    }
    public function delProjectM(){
        echo json_encode($this->model('Pegawai_Model')->delProjectM($_POST));
    }
    public function showdataProjectPS()
    {
        echo json_encode($this->model('Pegawai_Model')->showdataProjectPS($_POST));
    }
    public function delProjectPS()
    {
        echo json_encode($this->model('Pegawai_Model')->delProjectM($_POST));
    }
    public function showdataProjectA()
    {
        echo json_encode($this->model('Pegawai_Model')->showdataProjectA($_POST));
    }
    public function showdataProjectSO()
    {
        echo json_encode($this->model('Pegawai_Model')->showdataProjectSO($_POST));
    }
    public function showdataProjectSPV()
    {
        echo json_encode($this->model('Pegawai_Model')->showdataProjectSPV($_POST));
    }
    public function getProvinsi(){
        echo json_encode($this->model('Region_Model')->getProvinsi($_POST));
    }
    public function getDepartment(){
        echo json_encode($this->model('Region_Model')->getDepartment($_POST));
    }
    public function getUnit()
    {
        echo json_encode($this->model('Region_Model')->getUnit($_POST));
    }
    public function getStatusNikah()
    {
        echo json_encode($this->model('Region_Model')->getStatusNikah($_POST));
    } 
    public function getAgama()
    {
        echo json_encode($this->model('Region_Model')->getAgama($_POST));
    }
    public function getPendidikan()
    {
        echo json_encode($this->model('Region_Model')->getPendidikan($_POST));
    }
    public function getJabatan()
    {
        echo json_encode($this->model('Region_Model')->getJabatan($_POST));
    } 
    public function getStatusPegawai(){
        echo json_encode($this->model('Region_Model')->getStatusPegawai($_POST));
    }
    public function getJenisSP()
    {
        echo json_encode($this->model('Region_Model')->getJenisSP($_POST));
    }
    public function getLokasi()
    {
        echo json_encode($this->model('Region_Model')->getLokasi($_POST));
    }
    public function searchnilaiumklokasi(){
        echo json_encode($this->model('Pegawai_Model')->searchnilaiumklokasi($_POST));
    }
    public function getKabupatenByID()
    {
        echo json_encode($this->model('Region_Model')->getKabupatenByID($_POST));
    }
    public function getKecamtanByID(){
        echo json_encode($this->model('Region_Model')->getKecamtanByID($_POST));
    }
    public function getKodepos(){
        echo json_encode($this->model('Region_Model')->getKodepos($_POST));
    }
    public function getKelurahanByID(){
        echo json_encode($this->model('Region_Model')->getKelurahanByID($_POST));
    }
    public function createPegawai()
    {
        echo json_encode($this->model('Pegawai_Model')->createPegawai($_POST));
    }
    public function caridatapegawai(){
        echo json_encode($this->model('Pegawai_Model')->caridatapegawai($_POST));
    }
    public function getpegawaiAll()
    {
        echo json_encode($this->model('Pegawai_Model')->getpegawaiAll($_POST));
    }
    public function getdataPegawaibyID(){
        echo json_encode($this->model('Pegawai_Model')->getdataPegawaibyID($_POST));
    }
    public function add_Pendidikan(){
        echo json_encode($this->model('Pegawai_Model')->add_Pendidikan($_POST));
    }
    public function getPendidikanList()
    {
        echo json_encode($this->model('Pegawai_Model')->getPendidikanList($_POST));
    }
    public function delPendidikanList(){
        echo json_encode($this->model('Pegawai_Model')->delPendidikanList($_POST));
    }
    public function add_keluarga()
    {
        echo json_encode($this->model('Pegawai_Model')->add_keluarga($_POST));
    }
    public function getkeluargaList()
    {
        echo json_encode($this->model('Pegawai_Model')->getkeluargaList($_POST));
    }
    public function delkeluargaList()
    {
        echo json_encode($this->model('Pegawai_Model')->delkeluargaList($_POST));
    }
    public function add_datastatus_Kerja()
    {
        echo json_encode($this->model('Pegawai_Model')->add_datastatus_Kerja($_POST));
    }
    public function getdataStatusKerjaList()
    {
        echo json_encode($this->model('Pegawai_Model')->getdataStatusKerjaList($_POST));
    }
    public function delStatusKerjaList()
    {
        echo json_encode($this->model('Pegawai_Model')->delStatusKerjaList($_POST));
    }

    public function add_pelatihan_kerja()
    {
        echo json_encode($this->model('Pegawai_Model')->add_pelatihan_kerja($_POST));
    }
    public function getdataPelatihanList()
    {
        echo json_encode($this->model('Pegawai_Model')->getdataPelatihanList($_POST));
    }
    public function delpelatihanKerjaList()
    {
        echo json_encode($this->model('Pegawai_Model')->delpelatihanKerjaList($_POST));
    }
    public function getdatasplist()
    {
        echo json_encode($this->model('Pegawai_Model')->getdatasplist($_POST));
    }
    public function add_sp_kerja(){
        echo json_encode($this->model('Pegawai_Model')->add_sp_kerja($_POST));
    }
    public function delspkerjaList(){
        echo json_encode($this->model('Pegawai_Model')->delspkerjaList($_POST));
    }
}
