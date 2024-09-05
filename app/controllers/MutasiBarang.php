<?php
class MutasiBarang extends Controller
{
    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id); 
        $data['judul'] = 'Mutasi Barang Form Entri';
        $data['judul_child'] = 'Input View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/mutasiBarang/MutasiBarang_View', $data);
        $this->View('templates/footer');
    }
    public function list()
    {
        $session = SessionManager::getCurrentSession(); 
        $data['judul'] = 'Mutasi Barang Table List';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/mutasiBarang/MutasiBarang_List', $data);
        $this->View('templates/footer');
    }

    public function goSaveMutasiBarang(){
        echo json_encode($this->model('I_MutasiBarang_Model')->goSaveMutasiBarang($_POST));
    }

    public function voidMutasi(){
        echo json_encode($this->model('I_MutasiBarang_Model')->voidMutasi($_POST));
    }

    public function voidMutasiDetailbyItem(){
        echo json_encode($this->model('I_MutasiBarang_Model')->voidMutasiDetailbyItem($_POST));
    }

    
}
