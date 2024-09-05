<?php
class aOrderMCU  extends Controller
{
    public function index()
    { 
    }

    public function getPaketMCU()
    {
        echo json_encode($this->model('B_Order_MCU_Model')->getPaketMCU());
    }

    public function getPaketMCUbyID()
    {
        echo json_encode($this->model('B_Order_MCU_Model')->getPaketMCUbyID($_POST));
    }

    public function getDataMCUDetail()
    {
        echo json_encode($this->model('B_Order_MCU_Model')->getDataMCUDetail($_POST));
    }

    public function goCreateOrderMCU()
    {
        echo json_encode($this->model('B_Order_MCU_Model')->goCreateOrderMCU($_POST));
    }

    public function getPaketMCUbyNoreg()
    {
        echo json_encode($this->model('B_Order_MCU_Model')->getPaketMCUbyNoreg($_POST));
    }

    public function getPrinterLabelLab()
    { 
        $data = $this->model('B_Order_MCU_Model')->getLisTube($_POST);
        foreach ($data['data'] as $key) {
            $pasing['NOLAB'] = $key['NOLAB'];
            $pasing['TUBENAME'] = $key['TUBENAME'];
            $pasing['TUBENUMBER'] = $key['TUBENUMBER'];
            $pasing['NOLIS'] = $key['NOLIS'];
            $pasing['TESTCODE'] = $key['TESTCODE'];
            $pasing['pname'] = $key['pname'];
            $pasing['sex'] = $key['sex'];
            $pasing['locid'] = $key['locid'];
            $pasing['birth_dt'] = $key['birth_dt'];
            $pasing['NoMR'] = $key['NoMR'];
            
            echo json_encode($this->model('B_Order_MCU_Model')->getPrinterLabelLab($pasing));
        }
    }

}