<?php
class LembarPengajuanKlaim extends Controller
{
    use BPJS;
    public function index()
    {
        $Lpk_reverence = $this->model('LPK_Model')->Reverence();
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Lembar Pengajuan Klaim';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $data['reverence_lpk'] = $Lpk_reverence;
        // var_dump($Lpk_reverence);

        $this->View('templates/header', $session);
        $this->View('lpk/input/inputLPK', $data);
        $this->View('templates/footer');
    }

    public function testinsertlpk()
    {
        $Lpk_reverence = $this->model('LPK_Model')->insert();
        var_dump($Lpk_reverence);
    }

    public function DataLembarPengajuanClaim()
    {
        $_POST['tglmasuk'] = "2017-10-30";
        $_POST['jnspelayanan'] = "Inap";
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Data Lembar Pengajuan Klaim';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;

        $Lpk_reverence = $this->model('LPK_Model')->GetDataLembarPengajuanClaim($_POST);
        $data['Datapengajuanklaim'] = $Lpk_reverence;
        $this->View('templates/header', $session);
        $this->View('lpk/DataPengajuanClaim/DataLembarPengajuanClaim', $data);
        $this->View('templates/footer');

        // var_dump($Lpk_reverence);
    }

    public function GetDataProcedure()
    {
        // $_POST['nama'] = "Chronic";
        $Lpk_reverence = $this->model('LPK_Model')->GetDataProcedure($_POST);
        $data = json_encode($Lpk_reverence);
        echo $data;
    }
    public function GetDataDiagnosa()
    {
        $Lpk_reverence = $this->model('LPK_Model')->GetDataDiagnosa($_POST);
        $data = json_encode($Lpk_reverence);
        echo $data;
    }
    public function GetDataDokter()
    {
        $Lpk_reverence = $this->model('LPK_Model')->GetDataDokter($_POST);
        $data = json_encode($Lpk_reverence);
        echo $data;
    }

    public function inputlpk()
    {
        $hasil = $this->model('LPK_Model')->input($_POST);
        echo json_encode($hasil);
    }
}
