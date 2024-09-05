<?php
class InfoLaporanKasir extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Laporan Kasir';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/billing/LaporanKasir', $data);
        $this->View('templates/footer');
    }
    public function getListKasir()
    {
        echo json_encode($this->model('B_Info_laporan_Kasir_Model')->getListKasir($_POST));
    }
    public function getPaymentType()
    {
        echo json_encode($this->model('B_Info_laporan_Kasir_Model')->getPaymentType($_POST));
    }
    public function getDataLaporan()
    {
        echo json_encode($this->model('B_Info_laporan_Kasir_Model')->getDataLaporan($_POST));
    }
}
