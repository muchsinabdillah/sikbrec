<?php
class PengeluaranRutin extends Controller
{
    public function listpengeluaranrutin($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Data Pengeluaran Rutin';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('pengeluaranrutin/listpengeluaranrutin', $data);
        $this->View('templates/footer');
    }
    public function entripengeluaranrutin($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Pengeluaran Kas Rutin';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('pengeluaranrutin/entri', $data);
        $this->View('templates/footer');
    }
    public function Create(){
        echo json_encode($this->model('A_Pengeluaran_Rutin_Model')->CreateRealisasi($_POST));
    }
    public function CreateDetil()
    {
        echo json_encode($this->model('A_Pengeluaran_Rutin_Model')->CreateDetil($_POST));
    }
    public function ShowDetail(){
        echo json_encode($this->model('A_Pengeluaran_Rutin_Model')->ShowDetail($_POST));
    }
    public function deleteIdDetail(){
        echo json_encode($this->model('A_Pengeluaran_Rutin_Model')->deleteIdDetail($_POST));
    }
    public function FinishTrs(){
        echo json_encode($this->model('A_Pengeluaran_Rutin_Model')->FinishTrs($_POST));
    }
    public function showlistPengeluaranRutin(){
        echo json_encode($this->model('A_Pengeluaran_Rutin_Model')->showlistPengeluaranRutin($_POST));
    }
    public function getHeader(){
        echo json_encode($this->model('A_Pengeluaran_Rutin_Model')->getHeader($_POST));
    }
}