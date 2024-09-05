<?php
class aorderLaboratorium  extends Controller
{
    public function index()
    { 
    }
    public function createHeaderOrderLaboratorium()
    {
        $B_Order_Laboratorium_Model = $this->model('B_Order_Laboratorium_Model');
        $orderLaboratoriumService = new OrderLaboratorium_Service($B_Order_Laboratorium_Model);
        echo json_encode($orderLaboratoriumService->createHeaderOrderLaboratorium($_POST));
    }
    public function  addDetilPemeriksaanLaboratorium()
    {
        $B_Order_Laboratorium_Model = $this->model('B_Order_Laboratorium_Model');
        $orderLaboratoriumService = new OrderLaboratorium_Service($B_Order_Laboratorium_Model);
        echo json_encode($orderLaboratoriumService->addDetilPemeriksaanLaboratorium($_POST));
    }
    public function getListPemeriksaanLaboratoriumByNoLab()
    {
        echo json_encode($this->model('B_Order_Laboratorium_Model')->getListPemeriksaanLaboratoriumByNoLab($_POST));
    }
    public function deleteDetilPemeriksaanOrderLab(){
        $B_Order_Laboratorium_Model = $this->model('B_Order_Laboratorium_Model');
        $orderLaboratoriumService = new OrderLaboratorium_Service($B_Order_Laboratorium_Model);
        echo json_encode($orderLaboratoriumService->deleteDetilOrderLab($_POST));
    }
    public function FinishOrderLaboratorium()
    {
        $B_Order_Laboratorium_Model = $this->model('B_Order_Laboratorium_Model');
        $orderLaboratoriumService = new OrderLaboratorium_Service($B_Order_Laboratorium_Model);
        echo json_encode($orderLaboratoriumService->FinishOrderLaboratorium($_POST));
    }
    public function getListOrderLaboratoriumbyNoReg()
    {
        echo json_encode($this->model('B_Order_Laboratorium_Model')->getListOrderLaboratoriumbyNoReg($_POST));
    }
    public function getDataTblLabHeader()
    {
        echo json_encode($this->model('B_Order_Laboratorium_Model')->getDataTblLabHeader($_POST));
    }
    public function cekStatusOrderLab()
    {
        echo json_encode($this->model('B_Order_Laboratorium_Model')->cekStatusOrderLab($_POST));
    }
    public function deleteOrderLab()
    {
        $B_Order_Laboratorium_Model = $this->model('B_Order_Laboratorium_Model');
        $orderLaboratoriumService = new OrderLaboratorium_Service($B_Order_Laboratorium_Model);
        echo json_encode($orderLaboratoriumService->deleteOrderLab($_POST));
    }
    public function deleteOrderLab2()
    {
        $B_Order_Laboratorium_Model = $this->model('B_Order_Laboratorium_Model');
        $orderLaboratoriumService = new OrderLaboratorium_Service($B_Order_Laboratorium_Model);
        echo json_encode($orderLaboratoriumService->deleteOrderLab2($_POST));
    }
}