<?php
class bInformationDashboardBed extends Controller 
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Registrasi Dashboard Bed';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/registration/DashboardBed/DashboardBed', $data);
        $this->View('templates/footer');
    }
    public function getData(){
        echo json_encode($this->model('B_InformationDashboardBed')->getData($_POST));
    }
    public function getRuangan(){
        echo json_encode($this->model('B_InformationDashboardBed')->getRuangan($_POST));
    }
}
