<?php
class InfoAbsensi extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Informasi Absensi Pegawai';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('informasi/hrd/InfoAbsensi', $data);
        $this->View('templates/footer', $data);
    }
     
}
