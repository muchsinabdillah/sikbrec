<?php
class bEKlaim extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Department';
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
        $this->View('templates/header', $session);
        $this->View('datamaster/department/Department_View', $data);
        $this->View('templates/footer');
    }

    public function getShift()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->testDecript());
    }
    public function new_claim()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->new_claim($_POST));
    }
    public function update_patient()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->update_patient());
    }
    public function delete_patient()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->update_patient());
    }
    public function set_claim_data()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->set_claim_data($_POST));
    }
    public function delete_claim()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->delete_claim($_POST));
    }
    public function grouping_stage_1()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->grouping_stage_1($_POST));
    }
    public function grouping_stage_2()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->grouping_stage_2($_POST));
    }
    public function claim_final()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->claim_final($_POST));
    }
    public function get_claim_data()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->get_claim_data($_POST));
    }
    public function reedit_claim()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->reedit_claim($_POST));
    }
    public function send_claim_individual()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->send_claim_individual($_POST));
    }
    public function goGetDatabyIDEKLAIM()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->goGetDatabyIDEKLAIM($_POST));
    }

    public function claim_print($ID = '')
    {
        $data['nomor_sep'] =  Utils::setDecode($ID);
        $session = SessionManager::getCurrentSession();
        $data['data'] = $this->model('B_Dataeklaim_Model')->claim_print($data);
        $this->View('print/Eklaim/Eklaim_print', $data);
    }

    public function ViewUploadFile($ID = '')
    {
        $data['id'] =  Utils::setDecode($ID);
        $data['data'] = $this->model('B_Dataeklaim_Model')->ViewUploadFile($data);
        $this->View('print/Eklaim/Eklaim_print', $data);
    }


    public function getListDataReg()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->getListDataReg($_POST));
    }
    public function goGetDatabyNoSEP()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->goGetDatabyNoSEP($_POST));
    }
    public function search_diagnosis()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->search_diagnosis($_POST));
    }
    public function search_diagnosis_new()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->search_diagnosis_new($_POST));
    }
    public function search_procedures()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->search_procedures($_POST));
    }
    public function search_procedures_new()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->search_procedures_new($_POST));
    }
    public function getList_Diagnosa()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->getList_Diagnosa($_POST));
    }
    public function addDiagnosa()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->addDiagnosa($_POST));
    }
    public function getList_Prosedur()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->getList_Prosedur($_POST));
    }
    public function addProsedur()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->addProsedur($_POST));
    }
    public function goVoidDetails_Diag()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->goVoidDetails_Diag($_POST));
    }
    public function goVoidDetails_Prosedur()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->goVoidDetails_Prosedur($_POST));
    }
    public function SetPrimer_Diagnosa()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->SetPrimer_Diagnosa($_POST));
    }
    public function ImportCoding()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->ImportCoding($_POST));
    }
    public function getList_DiagnosaV6()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->getList_DiagnosaV6($_POST));
    }
    public function getList_ProsedurV6()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->getList_ProsedurV6($_POST));
    }
    public function goUpdateMultiplicity()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->goUpdateMultiplicity($_POST));
    }
    public function getList_DiagnosaEMR()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->getList_DiagnosaEMR($_POST));
    }
    public function addDiagnosav6()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->addDiagnosav6($_POST));
    }
    public function goVoidDetails_Diagv6()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->goVoidDetails_Diagv6($_POST));
    }
    public function SetPrimer_Diagnosav6()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->SetPrimer_Diagnosav6($_POST));
    }
    public function addProsedurv6()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->addProsedurv6($_POST));
    }
    public function goVoidDetails_Prosedurv6()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->goVoidDetails_Prosedurv6($_POST));
    }
    public function getList_RiwayatKlaim()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->getList_RiwayatKlaim($_POST));
    }
    public function search_diagnosis_inagrouper()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->search_diagnosis_inagrouper($_POST));
    }
    public function search_procedures_inagrouper()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->search_procedures_inagrouper($_POST));
    }
    public function file_upload()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->file_upload($_POST));
    }
    public function getList_UploadFile()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->getList_UploadFile($_POST));
    }
    public function file_delete()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->file_delete($_POST));
    }
    public function create_co_insidense()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->create_co_insidense($_POST));
    }
    public function getListDataEklaim()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->getListDataEklaim($_POST));
    }




    //badrul
    public function ListCheckEklaim($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Eklaim';
        $data['judul_child'] = 'E-KLAIM';
        // $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('datamaster/Eklaim/Eklaim_List', $data);
        $this->View('templates/footer');
    }

    public function EklaimById($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['noreg'] =  null;
        $data['judul'] = 'Klaim';
        $data['judul_child'] = 'Input';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('datamaster/Eklaim/NewKlaim_input', $data);
        $this->View('templates/footer');
    }

    public function EklaimByNoReg($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  null;
        $data['noreg'] =  Utils::setDecode($id);
        $data['judul'] = 'Klaim';
        $data['judul_child'] = 'Input';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('datamaster/Eklaim/NewKlaim_input', $data);
        $this->View('templates/footer');
    }


    //badrul

    //alim

    public function Laporan($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'E-klaim';
        $data['judul_child'] = 'Laporan Klaim Individual';
        // $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('datamaster/Eklaim/LaporanKlaim', $data);
        $this->View('templates/footer');
    }
    public function laporanklaim()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->laporanklaim($_POST));
    }
    public function KirimDataOnline($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'E-klaim';
        $data['judul_child'] = 'Kirim Data Online';
        // $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('datamaster/Eklaim/KirimData', $data);
        $this->View('templates/footer');
    }
    public function KirimData()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->KirimData($_POST));
    }


    public function getListDataBPJS_SEP()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->getListDataBPJS_SEP($_POST));
    }

    public function AutoGenerateTarif()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->AutoGenerateTarif($_POST));
    }

    public function CopyDiagnosaEMR()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->CopyDiagnosaEMR($_POST));
    }
    
    public function sitb_validate()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->sitb_validate($_POST));
    }

    public function sitb_invalidate()
    {
        echo json_encode($this->model('B_Dataeklaim_Model')->sitb_invalidate($_POST));
    }
}
