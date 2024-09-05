<?php
class JobOrder extends Controller{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Job Order';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('datamaster/JobOrder/JobOrder_View', $data);
        $this->View('templates/footer');
    }
    public function getAllJobOrder()
    {
        echo json_encode($this->model('JobOrder_Model')->getAllJobOrder());
    }
    public function viewJobOrder($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Job order';
        $data['judul_child'] = 'Input';
        $this->View('templates/header', $session);
        $this->View('datamaster/JobOrder/JobOrder', $data);
        $this->View('templates/footer');
    }
    public function addJobOrder(){
        echo json_encode($this->model('JobOrder_Model')->insert($_POST));
    }
    public function getJobOrderById(){
        echo json_encode($this->model('JobOrder_Model')->getJobOrderById($_POST['id']));
    }
    public function getLokasiJoByHakUser()
    {
        echo json_encode($this->model('JobOrder_Model')->getAllJobOrderbyHakAkses());
    }
}