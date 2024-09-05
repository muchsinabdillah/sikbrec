<?php
class aReservasiPasienWalkin extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Reservation Pasien';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('reservationwalkin/list/ReservasiWalkinList', $data);
        $this->View('templates/footer');
    }
    public function input($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Reservation Input';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('reservationwalkin/input/aReservationWalkinInput', $data);
        $this->View('templates/footer');
    }
    public function getWalkinbyDate()
    {
        $walkin = $this->model('B_Reservasi_Model')->getWalkin($_POST);
        echo json_encode($walkin);
    }

    public function getJadwalDokterByid()
    {
        $jdawaldokter = $this->model('MasterDataJadwalDokter_Model')->getJadwalDokterId($_POST);
        echo json_encode($jdawaldokter);
    }

    public function carirekamedikberdasarkannama()
    {
        $datarekamedik =  $this->model('B_Reservasi_Model')->cariRekamMedik($_POST);
        echo json_encode($datarekamedik);
    }

    public function getDataWalkinPatient()
    {
        $datawalkinpatient =  $this->model('B_Reservasi_Model')->getDataWalkinByid($_POST);
        echo json_encode($datawalkinpatient);
    }

    public function getDataWalkinsudahpunyamr()
    {
        $datawalkinpatient =  $this->model('B_Reservasi_Model')->getPasienSudahpunyaMR($_POST);
        echo json_encode($datawalkinpatient);
    }

    public function getDokterBydate()
    {
        $dokter =  $this->model('B_Reservasi_Model')->getDokterJadwalhari($_POST);
        echo json_encode($dokter);
    }

    public function jamdokterpraktek()
    {
        $jamdokter =  $this->model('B_Reservasi_Model')->getJamDokterPraktek($_POST);
        echo json_encode($jamdokter);
    }
    public function shiftDokter()
    {
        $shift =  $this->model('B_Reservasi_Model')->getshiftDokter($_POST);
        echo json_encode($shift);
    }

    public function createReservasiWalkin()
    {
        $reservasi =  $this->model('B_Reservasi_Model')->createReservasi($_POST);
        echo json_encode($reservasi);
        // var_dump($reservasi);
    }

    public function getDataReservasiWalkin()
    {
        $getDataReservasiWalkin = $this->model('B_Reservasi_Model')->caridatareservasi($_POST);
        echo json_encode($getDataReservasiWalkin);
    }

    public function getDatareservasi()
    {
        $datareservasi = $this->model('B_Reservasi_Model')->getDatareservasibyid($_POST);
        echo json_encode($datareservasi);
    }

    public function batalReservasiWalkin()
    {
        $batalreservasi = $this->model('B_Reservasi_Model')->batalReservasi($_POST);
        echo json_encode($batalreservasi);
    }

    public function input_new($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Reservation Input';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $data['poliklinik'] = $this->Poliklinik('WALKIN');
        $data['iswalkin'] = 'WALKIN';
        $this->View('templates/header', $session);
        $this->View('resevationnonwalkin/input/aReservationnonWalkinInput', $data);
        $this->View('templates/footer');
    }

    public function Poliklinik($data)
    {
        $poliklinik = $this->model('B_ReservasiNonWalkin_Model')->DaftarPoliKlinik($data);
        return $poliklinik;
    }
}
