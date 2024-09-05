<?php
class aRegistrasiRanap extends Controller
{
    public function index($id = null, $nomr = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['nomr'] =  Utils::setDecode($nomr);
        $data['judul'] = 'Registration Rawat Inap';
        $data['judul_child'] = 'Rawat Inap';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('registration/input/aRegistrasiRanapInput', $data);
        $this->View('templates/footer');
    }

    public function list()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Permintaan Rawat Inap (SPR)';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('registration/list/aRegistrasiSPRList', $data);
        $this->View('templates/footer');
    }
    public function getDataListLmaPasien()
    {
        echo json_encode($this->model('B_Create_Registrasi_Ranap')->getDataListLmaPasien());
    }

    public function getDataSPRDetail()
    {
        echo json_encode($this->model('B_Create_Registrasi_Ranap')->getDataSPRDetail($_POST));
    }

    public function CreateRegistrasi()
    {
        echo json_encode($this->model('B_create_Registrasi_Ranap')->CreateRegistrasi($_POST));
    }

    public function getStatusRegRajal()
    {
        echo json_encode($this->model('B_Create_Registrasi_Ranap')->getStatusRegRajal($_POST['id']));
    }

    public function listreg()
    {
        $session = SessionManager::getCurrentSession();
        $data['judul'] = 'List Pasien Rawat List';
        $data['judul_child'] = 'View Informasi';
        $this->View('templates/header', $session);
        $this->View('registration/list/aRegistrasiRawatList', $data);
        $this->View('templates/footer');
    }
    public function getDataListPasienRawat()
    {
        //         $sql_details = array(
        //             'user' => 'sa',
        //             'pass' => 'rsyarsi123',
        //             'db'   => 'MasterdataSQL',
        //             'host' => '172.16.40.29'
        //         );
        //         $table = <<<EOT
        //  (
        //     SELECT *,case when StatusAktif = '1' then 'Aktif' else 'Tidak Aktif' end as status_aktif
        //     FROM MasterdataSQL.DBO.MstrPerusahaanJPK
        //  ) temp
        // EOT;

        //         // Table's primary key
        //         $primaryKey = 'ID';

        //         // Array of database columns which should be read and sent back to DataTables.
        //         // The `db` parameter represents the column name in the database, while the `dt`
        //         // parameter represents the DataTables column identifier. In this case simple
        //         // indexes
        //         $columns = array(
        //             array('db' => 'ID', 'dt' => 0),
        //             array('db' => 'NamaPerusahaan',  'dt' => 1),
        //             array('db' => 'Alamat',   'dt' => 2),
        //             array('db' => 'status_aktif',     'dt' => 3),
        //             array('db' => 'Benefit',     'dt' => 4),
        //             array('db' => 'ContacPerson',     'dt' => 5)
        //         );
        //         echo json_encode(
        //             SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns)

        //         );
        //         // return SP::simple($_POST, $sql_details, $table, $primaryKey, $columns);

        echo json_encode($this->model('B_Create_Registrasi_Ranap')->getDataListPasienRawat());
    }
    // public function getDataListPasienRawat()
    // {
    //     $sql_details = array(
    //         'user' => 'sa',
    //         'pass' => 'rsyarsi123',
    //         'db'   => 'MasterdataSQL',
    //         'host' => '172.16.40.29'
    //     );

    //     $table = <<<EOT
    //      (
    //         SELECT InpatientID,a.NoMR,a.NoRegRI,c.PatientName,replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as VisitDate,b.First_Name as NamaDokter,e.NamaPerusahaan,g.[Status Name] AS status_name,a.JenisRawat
    //                                  FROM RawatInapSQL.DBO.Inpatient a
    //                                  INNER JOIN MasterdataSQL.dbo.Doctors b on a.drPenerima=b.ID
    //                                  INNER JOIN MasterdataSQL.dbo.Admision c on a.NoMR=c.NoMR
    //                                  OUTER APPLY (
    //                                  SELECT Class,RoomName,Bed FROM RawatInapSQL.dbo.Inpatient_in_out WHERE NoRegRI=a.NoRegRI AND StatusActive='1'
    //                                  ) d
    //                                  INNER JOIN MasterdataSQL.dbo.MstrPerusahaanJPK e on a.IDJPK=e.ID
    //                                  LEFT JOIN MasterdataSQL.dbo.MasterCOB f on a.KodeJaminanCOB=f.ID
    //                                  INNER JOIN RawatInapSQL.dbo.[Visit Status] g on a.StatusID=g.[Status ID]
    //                                  WHERE StatusID<>'4' AND TypePatient<>'2'
    //                                  UNION ALL
    //                                  SELECT InpatientID,a.NoMR,a.NoRegRI,c.PatientName,replace(CONVERT(VARCHAR(11), a.StartDate, 111), '/','-') as VisitDate,b.First_Name as NamaDokter,e.NamaPerusahaan,g.[Status Name] AS status_name,a.JenisRawat
    //                                  FROM RawatInapSQL.DBO.Inpatient a
    //                                  INNER JOIN MasterdataSQL.dbo.Doctors b on a.drPenerima=b.ID
    //                                  INNER JOIN MasterdataSQL.dbo.Admision c on a.NoMR=c.NoMR
    //                                    OUTER APPLY (
    //                                  SELECT Class,RoomName,Bed FROM RawatInapSQL.dbo.Inpatient_in_out WHERE NoRegRI=a.NoRegRI AND StatusActive='1'
    //                                  ) d
    //                                  INNER JOIN MasterdataSQL.dbo.MstrPerusahaanAsuransi e on a.IDAsuransi=e.ID
    //                                  LEFT JOIN MasterdataSQL.dbo.MasterCOB f on a.KodeJaminanCOB=f.ID
    //                                  INNER JOIN RawatInapSQL.dbo.[Visit Status] g on a.StatusID=g.[Status ID]
    //                                  WHERE StatusID<>'4' AND TypePatient='2'

    //      ) temp
    //     EOT;

    //     // Table's primary key
    //     $primaryKey = 'InpatientID';

    //     // Array of database columns which should be read and sent back to DataTables.
    //     // The `db` parameter represents the column name in the database, while the `dt`
    //     // parameter represents the DataTables column identifier. In this case simple
    //     // indexes
    //     $columns = array(
    //         // array('db' => 'InpatientID', 'dt' => 0),
    //         array('db' => 'NoMR',  'dt' => 0),
    //         array('db' => 'PatientName',     'dt' => 1),
    //         array('db' => 'VisitDate',     'dt' => 2),
    //         array('db' => 'NoRegRI',   'dt' => 3),
    //         array('db' => 'status_name',     'dt' => 4),
    //         array('db' => 'NamaDokter',     'dt' => 5),
    //         array('db' => 'JenisRawat',     'dt' => 6),
    //         array('db' => 'NamaPerusahaan',     'dt' => 7),

    //         // array('db' => 'Class',     'dt' => 6),
    //         // array('db' => 'nama_room',     'dt' => 7),
    //         // array('db' => 'tmpt_tidur',     'dt' => 8),
    //         // array('db' => 'NamaCOB',     'dt' => 10),
    //         // array('db' => 'NoSEP',     'dt' => 11),
    //         // array('db' => 'StartTime',     'dt' => 13),




    //     );
    //     echo json_encode(
    //         SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns)

    //     );
    //     // return SP::simple($_POST, $sql_details, $table, $primaryKey, $columns);

    //     // echo json_encode($this->model('B_Create_Registrasi_Ranap')->getDataListPasienRawat());
    // }

    public function VoidRegistrasi()
    {
        echo json_encode($this->model('B_create_Registrasi_Ranap')->VoidRegistrasi($_POST));
    }
    public function PrintMedical($lang = '', $kodereg = '', $notrs = '', $periode_awal = '', $periode_akhir = '')
    {
        try {
            $session = SessionManager::getCurrentSession();
            $data['notrs'] = $notrs;
            $data['kodereg'] = 'PB';
            $data['lang'] = $lang;
            $data['periode_awal'] = $periode_awal;
            $data['periode_akhir'] = $periode_akhir;
            $data['judul'] = 'RINCIAN BIAYA PEMBELIAN BEBAS';
            // get data header and detail
            $data['listdataheader'] = $this->model('B_Billing_Model')->PrintRincianHeaderbyReg($data);
            $data['listdetail_obat'] = $this->model('B_Billing_Model')->PrintRincianObatbyReg($data);
            $data['listdata_payment'] = $this->model('B_Billing_Model')->PrintKuitansiDetailbyReg($data);
            // get sign user
            $data['id_employee'] = $session->IDEmployee;
            $data['listdatasign'] = $this->model('B_Billing_Model')->GetSignUser($data);
            //return view
            $this->View('print/MedicalResume/medicalres', $data);
        } catch (exception $exception) {
            $this->View('templates/header_login');
            $this->View('login/index');
            $this->View('templates/footer_login');
        }
    }

    //badrul

    public function OrderPaketRI($noregri = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['noregri'] =  Utils::setDecode($noregri);
        $data['judul'] = 'Order Paket Rawat Inap';
        $data['judul_child'] = 'List View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('registration/input/OrderPaketRI', $data);
        $this->View('templates/footer');
    }

    public function GetregistrasiRanapbyNoRegistrasi()
    {
        echo json_encode($this->model('B_Create_Registrasi_Ranap')->GetregistrasiRanapbyNoRegistrasi($_POST));
    }
    public function GetpaketOperasibyNoRegistrasi()
    {
        echo json_encode($this->model('B_Create_Registrasi_Ranap')->GetpaketOperasibyNoRegistrasi($_POST));
    }

    public function getPaketRanap()
    {
        echo json_encode($this->model('B_Create_Registrasi_Ranap')->getPaketRanap());
    }

    public function getPaketRI()
    {
        echo json_encode($this->model('B_Create_Registrasi_Ranap')->getPaketRI($_POST));
    }

    public function getDataPaketRIDetail()
    {
        echo json_encode($this->model('B_Create_Registrasi_Ranap')->getDataPaketRIDetail($_POST));
    }

    public function goCreateOrderPaket()
    {
        echo json_encode($this->model('B_Create_Registrasi_Ranap')->goCreateOrderPaket($_POST));
    }
    // badrul


    public function getDataListPasienOperasibyNoReg()
    {
        echo json_encode($this->model('B_create_Registrasi_Ranap')->getDataListPasienOperasibyNoReg($_POST));
    }

    public function goTransferOP()
    {
        echo json_encode($this->model('B_create_Registrasi_Ranap')->goTransferOP($_POST));
    }

    public function getJenisRawat()
    {
        echo json_encode($this->model('B_create_Registrasi_Ranap')->getJenisRawat($_POST));
    }
}
