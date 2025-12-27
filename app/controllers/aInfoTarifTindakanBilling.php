<?php

class aInfoTarifTindakanBilling extends Controller
{
    public function index()
    {

    }
    public function Rajal($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Info Tarif Rawat Jalan';
        $data['judul_child'] = 'Input View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('billing/list/BillingInfoTarifRajal', $data);
        $this->View('templates/footer');
    }
    public function Ranap($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Info Tarif Rawat Inap';
        $data['judul_child'] = 'Input View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('billing/list/BillingInfoTarifRanap', $data);
        $this->View('templates/footer');
    }
    public function getDataInfoRajal()
    {
        echo json_encode($this->model('B_InfoTarifTindakanBilling_Model')->getDataInfoRajal($_POST));
    }
    public function getDataInfoRanap()
    {
        echo json_encode($this->model('B_InfoTarifTindakanBilling_Model')->getDataInfoRanap($_POST));
    }
}