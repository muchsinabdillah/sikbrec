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

    //01/09/2024
    //public function PrintLaporanKasir($tglawal = '', $tglakhir = '', $kasir = '', $jenisPasien = '', $tipeInfo = '', $tipepembayaran = '')
    //15/11/2024 fiqri update
    public function PrintLaporanKasir($datatrs = '')
    {
        try {
            $session = SessionManager::getCurrentSession();
            $jsondata= json_decode(Utils::setDecode($datatrs));
            $data['TglAwal'] = $jsondata->TglAwal;
            $data['TglAkhir'] = $jsondata->TglAkhir;
            //$data['kasir'] = str_replace('_', ' ', $kasir);
            $data['kasir'] = $jsondata->kasir;
            $data['jenispasien'] = $jsondata->jenispasien;
            $data['tipeinfo'] = $jsondata->tipeinfo;
            $data['tipepembayaran'] = $jsondata->tipepembayaran;

            // var_dump($data['kasir']);
            // exit;

            // get data header and detail
            $data['headercetakan'] = $this->model('B_Info_laporan_Kasir_Model')->getHeaderCetakan();
            $data['listdataheader'] = $this->model('B_Info_laporan_Kasir_Model')->getDataLaporanHdr($data);
            $data['listdatadetail'] = $this->model('B_Info_laporan_Kasir_Model')->getDataLaporan($data);
            // var_dump($data['listdataheader']);
            // var_dump($data['listdatadetail']);
            // exit;
            //get uuid4
            $data['uuid4'] = Utils::uuid4str();
            //return view
            $this->View('informasi/billing/printLaporanKasirDetail', $data);
        } catch (exception $exception) {
            $this->View('templates/header_login');
            $this->View('login/index');
            $this->View('templates/footer_login');
        }
    }
    //01/09/2024

}
