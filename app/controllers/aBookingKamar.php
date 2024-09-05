<?php
class aBookingKamar extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Booking Kamar Tempat Tidur Pasien';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('BookingKamar/BookingKamar_List', $data);
        $this->View('templates/footer');
    }

    public function input($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Booking Kamar Tempat Tidur Pasien';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('BookingKamar/BookingKamar_View', $data);
        $this->View('templates/footer');
    }

    public function listAllActive()
    {
        echo json_encode($this->model('B_BookingBed_Model')->listAllActive($_POST));
    }
    public function listAllArchive()
    {
        echo json_encode($this->model('B_BookingBed_Model')->listAllArchive($_POST));
    }
    public function viewByNoTrs()
    {
        echo json_encode($this->model('B_BookingBed_Model')->viewByNoTrs($_POST));
    }
    public function getRoombyClassID()
    {
        echo json_encode($this->model('MasterDataBed_Model')->getRoombyClassID($_POST));
    }

    public function getBedbyRoomID()
    {
        echo json_encode($this->model('MasterDataBed_Model')->getBedbyRoomID($_POST));
    }

    public function getPropsClass()
    {
        echo json_encode($this->model('MasterDataBed_Model')->getClassbyID($_POST));
    }

    public function getPropsRoom()
    {
        echo json_encode($this->model('MasterDataBed_Model')->getRoombyID($_POST));
    }

    public function getPropsBed()
    {
        echo json_encode($this->model('MasterDataBed_Model')->getBedbyID($_POST));
    }

    public function create()
    {
        echo json_encode($this->model('B_BookingBed_Model')->create($_POST));
    }
    public function update()
    {
        echo json_encode($this->model('B_BookingBed_Model')->update($_POST));
    }
    public function void()
    {
        echo json_encode($this->model('B_BookingBed_Model')->void($_POST));
    }
    public function listAllActivebyNoMR()
    {
        // $data = $_POST;
        // $data['id'] = null;
        // $passing = $this->model('B_Create_Registrasi_Ranap')->getDataSPRDetail($data);
        // echo json_encode($this->model('B_BookingBed_Model')->listAllActivebyNoMR($passing['data']));
        echo json_encode($this->model('B_BookingBed_Model')->listAllActive($_POST));
    }

    public function viewByMatch()
    {
        $data['transactioncode'] = $_POST['transactioncode'];
        $data['id'] = null;
        $data['noregri'] = $_POST['noregri'];
        $data_simrs = $this->model('B_Create_Registrasi_Ranap')->getDataSPRDetail($data);
        $data_booked = $this->model('B_BookingBed_Model')->viewByNoTrs($data);
        if ($data_booked['data']['medicalrecordnumber'] != null){
            if ($data_simrs['data']['NoMR'] != $data_booked['data']['medicalrecordnumber']){
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No MR tidak sesuai antara data booking dengan data registrasi kamar! Mohon dicek kembali!',
                    'data' => []
                );
                echo json_encode($callback);
                exit;
            }
        }else{
            if ($data_simrs['data']['DOB_RAW'] != $data_booked['data']['patientbirthdate']){
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Tanggal lahir tidak sesuai antara data booking dengan data registrasi kamar! Pastikan data sesuai!',
                    'data' => []
                );
                echo json_encode($callback);
                exit;
            }else{
                $datamerge = $this->model('B_BookingBed_Model')->viewByNoTrs($data);
                $datamerge['data']['nomr_validasi'] = $data_simrs['data']['NoMR'];
                $datamerge['data']['patientname_validasi'] = $data_simrs['data']['PatientName'];
                $datamerge['data']['patientaddress_validasi'] = $data_simrs['data']['Address'];
                $datamerge['data']['patientsex_validasi'] = $data_simrs['data']['Gander'];
                $datamerge['data']['patientbirthplace_validasi'] = $data_simrs['data']['BirthPlace'];
                $datamerge['data']['patientbirthdate_validasi'] = $data_simrs['data']['DOB_RAW'];
                echo json_encode($datamerge);
                exit;
            }
        }

        echo json_encode($data_booked);
    }

}
