<?php
class OrderRadiologi_Service
{
    private $B_Order_Radiologi_Modal;
    private $B_create_Registrasi_Rajal;
    public function __construct(B_Order_Radiologi_Modal $B_Order_Radiologi_Modal, 
                                B_create_Registrasi_Rajal $B_create_Registrasi_Rajal)
    {
        $this->B_Order_Radiologi_Modal = $B_Order_Radiologi_Modal;
        $this->B_create_Registrasi_Rajal = $B_create_Registrasi_Rajal;
    }
    function createOrderRadiologi($data)
    { 
        $GetregistrasiRajalbyNoMR = $this->B_create_Registrasi_Rajal->GetregistrasiRajalbyNoMR($data);
        $datashowregistrasibyMR = $this->B_Order_Radiologi_Modal->showregistrasibyMR($GetregistrasiRajalbyNoMR, $data);
        $createOrderNumber = $this->B_Order_Radiologi_Modal->createOrderNumber($datashowregistrasibyMR['TRIGGER_DTTM'], $datashowregistrasibyMR['NoMR']);
        $createOrderRadiologi = $this->B_Order_Radiologi_Modal->CreateOrderRadiologi($data, $createOrderNumber, $datashowregistrasibyMR);
        return $createOrderRadiologi;
    }
}
