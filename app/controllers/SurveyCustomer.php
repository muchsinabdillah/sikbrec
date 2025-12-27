<?php
class SurveyCustomer extends Controller
{
    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Status Pegawai';
        $data['id'] =  $id;
        $data['judul_child'] = 'List';
        // $data['mhs'] = $this->model('Mahasiswa_model')->getAllMahasiswa();
    
        $this->View('surveycustomer/entri',$data);
 
       
    }
    public function insertPenilaian()
    {
        echo json_encode($this->model('StatusPegawai_Model')->insertPenilaian($_POST));
    }

    
}