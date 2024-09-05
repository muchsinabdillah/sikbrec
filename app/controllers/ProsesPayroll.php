<?php
class ProsesPayroll extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Proses Penggajian Pegawai';
        $data['judul_child'] = 'Input';
        $this->View('templates/header', $session);
        $this->View('hrd/payroll/ProsesPayroll', $data);
        $this->View('templates/footer');
    }
    public function genHdrPayroll()
    {
        echo json_encode($this->model('ProsesPayroll_Model')->genHdrPayroll($_POST));
    }
    public function genDtlPayroll()
    {
        echo json_encode($this->model('ProsesPayroll_Model')->genDtlPayroll($_POST));
    }
    public function getKomponenImbalan(){
        echo json_encode($this->model('ProsesPayroll_Model')->getKomponenImbalan($_POST));
    }
    public function getKomponenPotongan()
    {
        echo json_encode($this->model('ProsesPayroll_Model')->getKomponenPotongan($_POST));
    }
    public function GeHdrPayrollByIDtrs()
    {
        echo json_encode($this->model('ProsesPayroll_Model')->GeHdrPayrollByIDtrs($_POST));
    }
    public function getDetailPayrolById(){
        echo json_encode($this->model('ProsesPayroll_Model')->getDetailPayrolById($_POST));
    }
    public function updateValueKomponenPayrollbyID(){
        echo json_encode($this->model('ProsesPayroll_Model')->updateValueKomponenPayrollbyID($_POST));
    }
    public function goFinish(){
        echo json_encode($this->model('ProsesPayroll_Model')->goFinish($_POST));
    }
    public function ShowDataListPayroll(){
        echo json_encode($this->model('ProsesPayroll_Model')->ShowDataListPayroll($_POST));
    }
    public function ShowDataByID(){
        echo json_encode($this->model('ProsesPayroll_Model')->ShowDataByID($_POST));
    }
    public function GeHdrPayrollByIDtrsAuto(){
        echo json_encode($this->model('ProsesPayroll_Model')->GeHdrPayrollByIDtrsAuto($_POST));
    }
    public function goVoidProsesPayroll(){
        echo json_encode($this->model('ProsesPayroll_Model')->goVoidProsesPayroll($_POST));
    }
    public function getInfoPayroll()
    {
        echo json_encode($this->model('ProsesPayroll_Model')->getInfoPayroll($_POST));
    }
}
