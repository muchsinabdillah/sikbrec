<?php
class bInfoJasaDokter extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Jasa Dokter';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/billing/InfomationJasaDokter', $data);
        $this->View('templates/footer');
    }

    public function getDataInfo()
    {
        echo json_encode($this->model('B_InformationJasaDokter_Model')->getDataInfo($_POST));
    }

    public function printPDF($PeriodeAwal = '', $PeriodeAkhir = '')
    {
        try {

            $session = SessionManager::getCurrentSession();

            $data['PeriodeAwal'] = $PeriodeAwal;
            $data['PeriodeAkhir'] = $PeriodeAkhir;
           
            $data['listdatadetail'] = $this->model('B_InformationJasaDokter_Model')->getDataListInfoJasaDokter1($data);
            //get uuid4
            $data['uuid4'] = Utils::uuid4str();
            //return view
            $this->View('print/billing/information/InformationJasaDokter', $data);
        } catch (exception $exception) {
            $this->View('templates/header_login');
            $this->View('login/index');
            $this->View('templates/footer_login');
        }
    }
}
