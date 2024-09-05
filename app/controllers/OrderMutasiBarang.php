<?php
class OrderMutasiBarang extends Controller
{
    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id); 
        $data['judul'] = 'Order Mutasi Barang Form Entri';
        $data['judul_child'] = 'Input View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/orderMutasiBarang/OrderMutasiBarang_View', $data);
        $this->View('templates/footer');
    }
    public function list()
    {
        $session = SessionManager::getCurrentSession(); 
        $data['judul'] = 'Order Mutasi Barang Table List';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/orderMutasiBarang/OrderMutasiBarang_List', $data);
        $this->View('templates/footer');
    }

    public function createHeaderTrs(){
        echo json_encode($this->model('I_MutasiBarang_Model')->createHeaderTrs($_POST));
    }

    public function createDtlTrs()
    {
        echo json_encode($this->model('I_MutasiBarang_Model')->createDtlTrs($_POST));
    }

    public function getOrderMutasiDetailbyID(){
        echo json_encode($this->model('I_MutasiBarang_Model')->getOrderMutasiDetailbyID($_POST));
    }

    public function editOrderMutasi()
    {
        echo json_encode($this->model('I_MutasiBarang_Model')->editOrderMutasi($_POST));
    }

    public function getOrderMutasibyDateUser()
    {
        echo json_encode($this->model('I_MutasiBarang_Model')->getOrderMutasibyDateUser());
    }

    public function getOrderMutasibyID()
    {
        echo json_encode($this->model('I_MutasiBarang_Model')->getOrderMutasibyID($_POST));
    }

    public function getOrderMutasibyPeriode()
    {
        echo json_encode($this->model('I_MutasiBarang_Model')->getOrderMutasibyPeriode($_POST));
    }

    public function voidOrderMutasi()
    {
        echo json_encode($this->model('I_MutasiBarang_Model')->voidOrderMutasi($_POST));
    }

    public function voidOrderDetailsMutasi()
    {
        echo json_encode($this->model('I_MutasiBarang_Model')->voidOrderDetailsMutasi($_POST));
    }

    ////----
    public function createHeaderTrs_Mutasi(){
        echo json_encode($this->model('I_MutasiBarang_Model')->createHeaderTrs_Mutasi($_POST));
    }

    public function goSaveMutasi(){
        echo json_encode($this->model('I_MutasiBarang_Model')->goSaveMutasi($_POST));
    }

    public function getMutasibyDateUser()
    {
        echo json_encode($this->model('I_MutasiBarang_Model')->getMutasibyDateUser());
    }

    public function getMutasibyID()
    {
        echo json_encode($this->model('I_MutasiBarang_Model')->getMutasibyID($_POST));
    }

    public function getMutasiDetailbyID(){
        echo json_encode($this->model('I_MutasiBarang_Model')->getMutasiDetailbyID($_POST));
    }
    
    public function createDtlTrsPaket()
    {
        echo json_encode($this->model('I_MutasiBarang_Model')->addOrderMutasiDetailPaket($_POST));
    }
    
    
}
