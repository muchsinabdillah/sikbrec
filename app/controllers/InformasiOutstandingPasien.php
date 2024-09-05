<?php
class InformasiOutstandingPasien extends Controller
{

    public function InformasiOutstanding()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'INFORMASI OUTSTANDING PASIEN';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/finance/ledger/InfoOutstandingPasien', $data);
        $this->View('templates/footer');
    }
    public function VerifJurnalFOdetil()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Transaksi Jurnal Front Office Detail';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/finance/ledger/verifJurnalFOdetil', $data);
        $this->View('templates/footer');
    }
    public function getDataListInfoOutstanding()
    {
        echo json_encode($this->model('B_InformationOutstandingPasien_Model')->getDataListInfoOutstanding($_POST));
    }
    public function getDataListverifJurnalFOdetil()
    {
        echo json_encode($this->model('B_InformationOutstandingPasien_Model')->getDataListverifJurnalFOdetil($_POST));
    }
}
