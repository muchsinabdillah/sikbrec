<?php

class bInformasiPenjualan extends Controller
{
    use Edocuments;
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Penjualan';
        $data['judul_child'] = 'View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/penjualan/InformasiPenjualan', $data);
        $this->View('templates/footer');
    }

    public function print($datas = null)
    {
        $jsondata= json_decode(Utils::setDecode($datas));
        $data['TglAwal'] = $jsondata->PeriodeAwal;
        $data['TglAkhir'] = $jsondata->PeriodeAkhir;
        $data['notrs'] = $data['TglAwal'].$data['TglAkhir'];
        $data['judul'] = 'Informasi Penjualan';
        $data['judul_child'] = 'View Informasi';
        $session = SessionManager::getCurrentSession();
        $data['listdata1'] = $this->model('B_Informasi_Penjualan_Model')->getDataInformasiPenjualan($data);
        $data['jeniscetakan'] = 'InformasiPenjualan';
        $data['filedoc'] = 'print/inventory/PrintInformasiPenjualan';
        $this->PrintFile($data);
    }

    public function getDataInformasiPenjualan()
    {
        echo json_encode($this->model('B_Informasi_Penjualan_Model')->getDataInformasiPenjualan($_POST));
    }
}
