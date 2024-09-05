<?php
class Rekening extends Controller
{
    public function getRekeningPendapatan()
    {
                echo json_encode($this->model('A_Rekening_Model')->getRekeningPendapatan());
    }
    public function getRekeningAllAktif()
    {
                echo json_encode($this->model('A_Rekening_Model')->getRekeningAllAktif());
    }
    public function getRekeningHpp()
    {
        try {
            $session = SessionManager::getCurrentSession();
            $cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($cek) {
                echo json_encode($this->model('A_Rekening_Model')->getRekeningHpp());
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    }
    public function GetRekeningHutang()
    {
        try {
            $session = SessionManager::getCurrentSession();
            $cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($cek) {
                echo json_encode($this->model('A_Rekening_Model')->GetRekeningHutang());
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    }
    public function GetRekeningPiutang()
    {
        try {
            $session = SessionManager::getCurrentSession();
            $cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($cek) {
                echo json_encode($this->model('A_Rekening_Model')->GetRekeningPiutang());
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    }
}
