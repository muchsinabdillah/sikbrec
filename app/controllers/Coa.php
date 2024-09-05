<?php
class Coa extends Controller
{
    public function index()
    {
        try {
            $session = SessionManager::getCurrentSession();
           // $cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($session) {
                $session = SessionManager::getCurrentSession();
                $data['judul'] = 'List COA Rekening';
                $data['judul_child'] = 'List';
                // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
                $this->View('templates/header', $session);
                $this->View('datamaster/Coa/Coa_View', $data);
                $this->View('templates/footer');
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    }
    public function getAllCoa()
    {
        echo json_encode($this->model('A_Rekening_Model')->getAllCoa());
    }
    public function viewCoa($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'COA Rekening';
        $data['judul_child'] = 'Input';
        $this->View('templates/header', $session);
        $this->View('datamaster/Coa/Coa', $data);
        $this->View('templates/footer');
    }
    public function getRekeningGroup()
    {
        echo json_encode($this->model('A_Rekening_Model')->getRekeningGroup());
    }
    public function getRekeningGroupCOA()
    {
        echo json_encode($this->model('A_Rekening_Model')->getRekeningGroupCOA());
    }
    public function addCoa()
    {
        echo json_encode($this->model('A_Rekening_Model')->insert($_POST));
    }
    public function getCoaId()
    {
        echo json_encode($this->model('A_Rekening_Model')->getCoaId($_POST['id']));
    }
    
}
