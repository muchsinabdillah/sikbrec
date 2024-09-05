<?php
class Chek_In extends Controller
{
    public function Verify($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'CHECKIN';
        // $data['judul_child'] = 'Data Pasien';
        $data['session'] = $session;
        $this->View('MenuCheckIn/ReservasiCekin', $data);
    }

    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Reservasi CheckIn';
        $data['judul_child'] = 'Input';

        $this->View('MenuCheckIn/Checkin', $data);
    }
}
