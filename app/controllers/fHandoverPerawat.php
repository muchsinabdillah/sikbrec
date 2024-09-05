<?php
class fHandoverPerawat extends Controller
{
    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'FORM Hand Over Perawat Antar Shift Jaga';
        // $data['judul_child'] = 'Data Pasien';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('form/HandoverPerawat', $data);
        $this->View('templates/footer');
    }
    public function getinsert()
    {
        echo json_encode($this->model('HandoverPerawat_Model')->insert($_POST));
    }
}
