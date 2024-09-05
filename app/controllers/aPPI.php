<?php
class aPPI extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Surveilans HAIs List';
        $data['judul_child'] = 'View Informasi';
        // $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('PPI/PPIListView_v2', $data);
        $this->View('templates/footer');
    }
    // public function getDataSensusPPI()
    // {
    //     echo json_encode($this->model('aPPI_Model')->getDataSensusPPI());
    // }
    public function getDataListSensusFilter()
    {
        echo json_encode($this->model('aPPI_Model')->getDataListSensusFilter($_POST));
    }

    public function LaporanKuman()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Laporan Kuman List';
        $data['judul_child'] = 'View Informasi';
        // $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('PPI/PPIListKuman', $data);
        $this->View('templates/footer');
    }
    // public function getDataListKumanDarah()
    // {
    //     echo json_encode($this->model('aPPI_Model')->getDataListKumanDarah());
    // }
    // public function getDataListKumanSputum()
    // {
    //     echo json_encode($this->model('aPPI_Model')->getDataListKumanSputum());
    // }
    // public function getDataListKumanUrine()
    // {
    //     echo json_encode($this->model('aPPI_Model')->getDataListKumanUrine());
    // }
    // public function getDataListKumanSwab()
    // {
    //     echo json_encode($this->model('aPPI_Model')->getDataListKumanSwab());
    // }
    public function getDataListKumanDarahFilter()
    {
        echo json_encode($this->model('aPPI_Model')->getDataListKumanDarahFilter($_POST));
    }
    public function getDataListKumanSputumFilter()
    {
        echo json_encode($this->model('aPPI_Model')->getDataListKumanSputumFilter($_POST));
    }
    public function getDataListKumanUrineFilter()
    {
        echo json_encode($this->model('aPPI_Model')->getDataListKumanUrineFilter($_POST));
    }
    public function getDataListKumanSwabFilter()
    {
        echo json_encode($this->model('aPPI_Model')->getDataListKumanSwabFilter($_POST));
    }


    public function createSensusRanap($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Create Surveilans Harian Ranap';
        $data['judul_child'] = 'Entry';
        $this->View('templates/header', $session);
        $this->View('PPI/PPICreateSensusRanap', $data);
        $this->View('templates/footer');
    }

    public function createSensusRajal($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Create Surveilans Harian Rajal';
        $data['judul_child'] = 'Entry';
        $this->View('templates/header', $session);
        $this->View('PPI/PPICreateSensusRajal', $data);
        $this->View('templates/footer');
    }

    public function addSensusPPI()
    {
        echo json_encode($this->model('aPPI_Model')->insert($_POST));
    }

    public function getSensusPPIId()
    {
        echo json_encode($this->model('aPPI_Model')->getSensusPPIId($_POST['id']));
    }
}
