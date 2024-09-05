<?php
class LabGlucosa extends Controller
{
    public function geHasilDetail()
    {
        echo json_encode($this->model('LabGlucosa_Model')->geHasilDetail($_POST));
    }
    public function loaddata()
    {
        echo json_encode($this->model('LabGlucosa_Model')->loaddata($_POST));
    }
    public function entri($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'COA Rekening';
        $data['judul_child'] = 'Input';
        $this->View('templates/header', $session);
        $this->View('glukosa/entrihasil', $data);
        $this->View('templates/footer');
    }
    public function showheader()
    {
        echo json_encode($this->model('LabGlucosa_Model')->showheader($_POST)); 
    }
    public function update(){
        echo json_encode($this->model('LabGlucosa_Model')->update($_POST)); 
    }
    public function insertlisfix(){
        echo json_encode($this->model('LabGlucosa_Model')->insertlisfix($_POST)); 
    }
}