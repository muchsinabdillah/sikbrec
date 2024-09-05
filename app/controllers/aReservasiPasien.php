<?php
class aReservasiPasien extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Registration Rawat Jalan';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('registration/input/aRegistrasiRajalInput', $data);
        $this->View('templates/footer');
    }
    public function showListReservasi()
    {
        echo json_encode($this->model('B_Reservasi_Model')->showListReservasi($_POST));
    }
    public function GoshowIDReservasi(){
        echo json_encode($this->model('B_Reservasi_Model')->GoshowIDReservasi($_POST));
    }
}
