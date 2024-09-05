<?php
class aOrderRadiologi extends Controller
{
    public function index($noregistrasi = null, $woid = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['woid'] =  Utils::setDecode($woid);
        $data['noregistrasi'] =  Utils::setDecode($noregistrasi);
        $data['judul'] = 'Order Radiologi';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('emr/radiologi/OrderRadiologi', $data);
        $this->View('templates/footer');
    }
    public function CreateOrderRadiologi()
    {
        //echo json_encode($this->model('B_Order_Radiologi_Modal')->CreateOrderRadiologi($_POST));
        $B_create_Registrasi_Rajal = $this->model('B_create_Registrasi_Rajal');
        $B_Order_Radiologi_Modal = $this->model('B_Order_Radiologi_Modal');
        $orderRadiologiService = new OrderRadiologi_Service($B_Order_Radiologi_Modal,$B_create_Registrasi_Rajal);
        echo json_encode($orderRadiologiService->createOrderRadiologi($_POST));
    }
    public function getListOrderRadiologi(){
        echo json_encode($this->model('B_Order_Radiologi_Modal')->getListOrderRadiologi($_POST));
    }
    public function getDataTblHeader(){
        echo json_encode($this->model('B_Order_Radiologi_Modal')->getDataTblHeader($_POST));
    }
    public function deleteOrder(){
        echo json_encode($this->model('B_Order_Radiologi_Modal')->VoidOrderRadiologi($_POST));
    }
}