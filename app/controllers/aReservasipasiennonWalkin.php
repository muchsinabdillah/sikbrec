<?php
class aReservasipasiennonWalkin extends Controller
{
    public function index()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'Reservation Pasien';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;

        $this->View('templates/header', $session);
        $this->View('resevationnonwalkin/list/ReservasinonWalkinList', $data);
        $this->View('templates/footer');
    }

    public function input($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'Reservation Input';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $data['poliklinik'] = $this->Poliklinik('RAJAL');
        $data['iswalkin'] = 'RAJAL';
        $this->View('templates/header', $session);
        $this->View('resevationnonwalkin/input/aReservationnonWalkinInput', $data);
        $this->View('templates/footer');
    }

    public function caridatareservasi()
    {
        $listdatareservasi = $this->model('B_ReservasiNonWalkin_Model')->listDatareservasi2($_POST);
        echo json_encode($listdatareservasi);
    }
    public function DetailreservasiPasien()
    {
        $detailreservasi = $this->model('B_ReservasiNonWalkin_Model')->DataReservasiPasien($_POST);
        echo json_encode($detailreservasi);
    }

    public function DaftarJadwalDokter()
    {
        $jadwaldokter = $this->model('B_ReservasiNonWalkin_Model')->JadwalDokter($_POST);
        echo json_encode($jadwaldokter);
    }
    public function datareservasi()
    {
        $datareservasi = $this->model('B_ReservasiNonWalkin_Model')->datareservasi($_POST);
        echo json_encode($datareservasi);
    }
    public function Datarekamedikpasien()
    {
        $sudahpunyamr = $this->model('B_ReservasiNonWalkin_Model')->sudahPunyaMR($_POST);
        echo json_encode($sudahpunyamr);
    }
    public function pasiensudahpunyamr()
    {
        $pasiensudahpunyamr = $this->model('B_ReservasiNonWalkin_Model')->Detailpasien($_POST);
        echo json_encode($pasiensudahpunyamr);
    }
    public function Poliklinik($data)
    {
        $poliklinik = $this->model('B_ReservasiNonWalkin_Model')->DaftarPoliKlinik($data);
        return $poliklinik;
    }

    public function createReservasinonWalkin()
    {
        $createreservasi = $this->model('B_ReservasiNonWalkin_Model')->Buatreservasi($_POST);
        echo json_encode($createreservasi);
    }

    public function batalReservasi()
    {
        $batal = $this->model('B_ReservasiNonWalkin_Model')->Batal($_POST);
        echo json_encode($batal);
    }

    public function Reservasibyid()
    {
        $reservasibyid = $this->model('B_ReservasiNonWalkin_Model')->datareservasiid($_POST);
        echo json_encode($reservasibyid);
    }

    public function batalReservasiWalkin()
    {
        $batalreservasi = $this->model('B_ReservasiNonWalkin_Model')->Batal($_POST);
        echo json_encode($batalreservasi);
    }

    public function sendreminder()
    {
        $token = $this->model('Login_Model')->getTokenWapin();
        $sendreminder = $this->model('B_ReservasiNonWalkin_Model')->sendreminder($token, $_POST);
        echo json_encode($sendreminder);
    }

    public function sendreminderAll()
    {
        $token = $this->model('Login_Model')->getTokenWapin();
        $sendreminder = $this->model('B_ReservasiNonWalkin_Model')->sendreminderAll($token, $_POST);
        echo json_encode($sendreminder);
    }

    public function caridatareservasi_arsip()
    {
        $listdatareservasi = $this->model('B_ReservasiNonWalkin_Model')->listDatareservasi_arsip($_POST);
        echo json_encode($listdatareservasi);
    }


    public function inputNoLogin($id = null)
    {
        //$session = SessionManager::getCurrentSession();
        $data['id'] =  $id;
        $data['judul'] = 'Reservation Input';
        $data['judul_child'] = 'List View';
        $data['session'] = null;
        $data['poliklinik'] = $this->Poliklinik('RAJAL');
        $data['iswalkin'] = 'RAJAL';
        $this->View('templates/header_nologin', null);
        $this->View('resevationnonwalkin/input/aReservationnonWalkinInputNoLogin', $data);
        $this->View('templates/footer');
    }

    public function getNamaPenjamin()
    {
        echo json_encode($this->model('B_InformationRekapMCU_Model')->getNamaPenjamin($_POST['tp_penjamin']));
    }

    public function GetMedicalRecordbyNoReg()
    {
        echo json_encode($this->model('B_MedicalRecord_Model')->GetMedicalRecordbyNoReg($_POST));
    }

    public function goUpdateRujukanBPJS()
    {
        $data['jenisPencarian'] = '3';
        $data['kodePeserta'] = $_POST['updtbook_NoRujukan'];
        $data['updtbook_NoSurkon'] = $_POST['updtbook_NoSurkon'];
        $data['updtbook_nokartubpjs'] = $_POST['updtbook_nokartubpjs'];
        $data['updtbook_ID'] = $_POST['updtbook_ID'];
        $data['JenisRujukanFaskesBPJSx'] = '1';
        $cek_rujukan = $this->model('B_xBPJSBridging_Model')->GoBPJSCekKepesertaan($data);
        if ($cek_rujukan['status'] == 'warning') {
            $data['JenisRujukanFaskesBPJSx'] = '2';
            $cek_rujukan = $this->model('B_xBPJSBridging_Model')->GoBPJSCekKepesertaan($data);
            if ($cek_rujukan['status'] == 'warning') {
                echo json_encode($cek_rujukan);
                exit;
            }
        }

        $kdpolibooking_bpjs = $this->model('MasterDataUnit_Model')->getUnitId($_POST['updtbook_IdPoli']);
        $kdpolirujukan_bpjs = $cek_rujukan['hasil'][1]['rujukan']['poliRujukan']['kode'];
        $nokartu_bpjs = $cek_rujukan['hasil'][1]['rujukan']['peserta']['noKartu'];
        $nomr_bpjs = $cek_rujukan['hasil'][1]['rujukan']['peserta']['mr']['noMR'];
        $nomr_booking = $_POST['updtbook_NoMR'];
        $data['updtbook_nokartubpjs'] = $nokartu_bpjs;

        if ($nomr_bpjs != null) {
            if ($nomr_bpjs <> $nomr_booking) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No Rujukan Ini Tidak Sesuai Dengan No MR Pasien ! Mohon Dicek Kembali !'
                );
                echo json_encode($callback);
                exit;
            }
        }

        if ($kdpolibooking_bpjs['data']['codeBPJS'] == $kdpolirujukan_bpjs) {
            if ($nomr_bpjs != null) {
                if ($data['updtbook_NoSurkon'] == null || $data['updtbook_NoSurkon'] == '' || $data['updtbook_NoSurkon'] == 'null') {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Surat Kontrol Harus Diisi Karena Poli Tujuan Booking Dengan Poli Rujukan Sama !'
                    );
                    echo json_encode($callback);
                    exit;
                }
            }
        }

        if ($data['updtbook_nokartubpjs'] == null || $data['updtbook_nokartubpjs'] == '' || $data['updtbook_nokartubpjs'] == 'null') {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'No Kartu BPJS Harus Diisi !'
            );
            echo json_encode($callback);
            exit;
        }

        //UPDATE
        echo json_encode($this->model('B_ReservasiNonWalkin_Model')->GoUpdateRujukanBooking($data));
    }
}
