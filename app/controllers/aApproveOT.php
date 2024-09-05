<?php
class aApproveOT extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Pasien Rencana Kamar Operasi';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('aEMR/list/listapproveot', $data);
        $this->View('templates/footer');
    }

    public function input($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Booking Kamar Tempat Tidur Pasien';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('BookingKamar/BookingKamar_View', $data);
        $this->View('templates/footer');
    }

    public function listAllActive()
    {
        echo json_encode($this->model('B_ApproveOT_Model')->listAllActive($_POST));
    }

    public function listAllArchive()
    {
        echo json_encode($this->model('B_BookingBed_Model')->listAllArchive($_POST));
    }
    public function goApprove()
    {
        echo json_encode($this->model('B_ApproveOT_Model')->goApprove($_POST));
    }

}
