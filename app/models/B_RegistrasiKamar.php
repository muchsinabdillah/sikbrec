<?php
class  B_RegistrasiKamar
{
    use ApiRsyarsi; 
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getDataKamar($data)
    {
        try {
            $noreg = $data['noreg'];
            $this->db->query("SELECT a.*,CONVERT(VARCHAR(8),a.TimeStart,108) as jam_masuk, CONVERT(VARCHAR(8),a.TimeEnd,108) as jam_keluar,b.JenisRawat
            FROM RawatInapSQL.dbo.View_LamaRawat a 
            join RawatInapSQL.dbo.Inpatient b on a.NoRegRI=b.NoRegRI
            Where a.NoRegRI=:noreg order by a.ID desc
             ");
            $this->db->bind('noreg', $noreg);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                //End Date
                if (empty($key['EndDate'])) {
                    $enddate = $key['EndDate'];
                } else {
                    $enddate = date('d/m/Y', strtotime($key['EndDate']));
                }

                //Time End
                if (empty($key['EndDate'])) {
                    $endtime = $key['jam_keluar'];
                } else {
                    $endtime = date('H.i.s', strtotime($key['jam_keluar']));
                }
                $pasing['ID'] = $key['ID'];
                $pasing['Class'] = $key['Class'];
                $pasing['RoomName'] = $key['RoomName'];
                $pasing['Bed'] = $key['Bed'];
                $pasing['JenisRawat'] = $key['JenisRawat'];
                $pasing['StartDate'] = date('d/m/Y', strtotime($key['StartDate']));
                $pasing['jam_masuk'] = date('H.i.s', strtotime($key['jam_masuk']));
                $pasing['Tarif'] = number_format($key['Tarif']);
                $pasing['LamaRawat'] = $key['LamaRawat'];
                $pasing['EndDate'] = $enddate;
                $pasing['jam_keluar'] = $endtime;
                $pasing['Disc'] = $key['Disc'] * 100;
                $pasing['Jumlah'] = number_format($key['jumlah']);
                $pasing['Status'] = $key['StatusActive'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getRoom($data)
    {
        try {
            $classid = $data['classid'];
            //var_dump($classid);
            $this->db->query("SELECT DISTINCT Room
            from MasterdataSQL.dbo.MstrRoomID where KLSID=:classid and Dsicontinue='0'");
            $this->db->bind('classid', $classid);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['Room'] = $key['Room'];
                $rows[] = $pasing;
            }
            $callback = array(
                'status' => "success", // Set array nama  
                'data' => $rows
            );
            return $callback;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function getBed($data)
    {
        try {
            $room = $data['room'];
            //var_dump($classid);
            $this->db->query("SELECT RoomID,Bad,
            case when RoomID is null then 'Kosong'
           else 'Terisi' end as cekkamar,
           case when Publish='1' then 'BPJS'
           else 'NON BPJS' end as IsBPJS
       from RawatInapSQL.dbo.View_InformasiKamarRI where Room=:room and Dsicontinue='0'");
            $this->db->bind('room', $room);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['Bad'] = $key['Bad'];
                $pasing['cekkamar'] = $key['cekkamar'];
                $pasing['IsBPJS'] = $key['IsBPJS'];
                $rows[] = $pasing;
            }
            $callback = array(
                'status' => "success", // Set array nama  
                'data' => $rows
            );
            return $callback;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function getTarif($data)
    {
        try {
            $this->db->transaksi();
            $classid = $data['classid'];
            $room = $data['room'];
            $bed = $data['bed'];
            $groupjaminan = $data['groupjaminan'];

            // $query = "SELECT *
            // from MasterdataSQL.dbo.MstrRoomID where KLSID=:classid AND Room=:room AND Bad=:bed";

            $query = "SELECT A.RoomID,A.KodeLokasi,A.Class,A.Ward,A.Room,A.Bad,B.TarifKamar,A.KLSID,A.KdKlsBPJS,A.KD_PDP,B.Tanggal_Expired
            FROM MasterdataSQL.DBO.MstrRoomID a
            INNER JOIN MasterdataSQL.DBO.MstrRoomID_2 B
            ON A.KLSID = B.KLSID
            where A.KLSID=:classid AND A.Room=:room 
            AND A.Bad=:bed AND B.Tanggal_Expired='3000-01-01 00:00:00.000' AND B.Group_Tarif=:groupjaminan";

            $this->db->query($query);
            $this->db->bind('classid', $classid);
            $this->db->bind('room', $room);
            $this->db->bind('bed', $bed);
            $this->db->bind('groupjaminan', $groupjaminan);

            $data =  $this->db->single();
            //var_dump($data);exit;
            if ($data == false) {

                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kamar Tersebut Sudah Expired ! Silahkan Cari Kamar Lain !',
                );
                return $callback;
                exit;
            }

            $pasing['TarifKamar'] = $data['TarifKamar'];
            $pasing['RoomID'] = $data['RoomID'];

            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function getDatabyID($data)
    {
        try {
            $id = $data['id'];
            //var_dump($id);
            $this->db->query("SELECT a.*,replace(CONVERT(VARCHAR(11), StartDate, 111), '/','-') as tgl_masuk,CONVERT(VARCHAR(8),TimeStart,108) as jam_masuk ,b.KLSID as idkelas,
                replace(CONVERT(VARCHAR(11), EndDate, 111), '/','-') as tgl_keluar,CONVERT(VARCHAR(8),TimeEnd,108) as jam_keluar,b.KodeLokasi
                from RawatInapSQL.dbo.Inpatient_in_out a
                left join MasterdataSQL.dbo.MstrRoomID b on a.RoomID=b.RoomID
                where a.ID=:id ");
            $this->db->bind('id', $id);

            $data =  $this->db->single();

            $pasing['NoRegRI'] = $data['NoRegRI'];
            $pasing['ID'] = $data['ID'];
            $pasing['RoomID'] = $data['RoomID'];
            $pasing['IDKelas'] = $data['idkelas'];
            $pasing['RoomName'] = $data['RoomName'];
            $pasing['Bed'] = $data['Bed'];
            $pasing['Tarif'] = $data['Tarif'];
            $pasing['LamaRawat'] = $data['LamaRawat'];
            $pasing['Discount'] = $data['Disc'] * 100;
            $pasing['ValueDiscount'] = $data['Disc'] * $data['Tarif'];
            $pasing['TglMasuk'] = $data['tgl_masuk'];
            $pasing['JamMasuk'] = $data['jam_masuk'];
            $pasing['TglKeluar'] = $data['tgl_keluar'];
            $pasing['JamKeluar'] = $data['jam_keluar'];
            $pasing['Titipan'] = $data['Titipan'];
            $pasing['RoomID_Titipan'] = $data['RoomID_Titipan'];
            $pasing['IDKelas_Titipan'] = $data['IDKelas_Titipan'];
            $pasing['RoomName_Titipan'] = $data['RoomName_Titipan'];
            $pasing['Bed_Titipan'] = $data['Bed_Titipan'];
            $pasing['Tarif_Titipan'] = $data['Tarif_Titipan'];
            $pasing['KodeLokasi'] = $data['KodeLokasi'];
            $pasing['Class'] = $data['Class'];

            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function CreateTrs($data)
    {
        try {
            $this->db->transaksi();
            $datenowcreate = Utils::seCurrentDateTime();

            //Deklarasi Variable
            $kodebooking = $data['kodebooking'];
            $idtrs = $data['IdAuto'];
            $noreg = $data['NoRegistrasi'];
            $ClassID = $data['ClassID'];
            if (isset($data['NamaKamar'])) {
                $RoomName = $data['NamaKamar'];
            } else {
                $RoomName = '';
            }
            if (isset($data['BedKamar'])) {
                $Bed = $data['BedKamar'];
            } else {
                $Bed = '';
            }
            $TarifKamar = $data['TarifKamar'];
            $tgl_masuk = $data['TglMasuk'];
            $jam_masuk = $data['JamMasuk'];
            $jam_masuk_fix = date('Y-m-d H:i:s', strtotime("$tgl_masuk $jam_masuk"));
            $jam_masuk_fix2 = date('Y-m-d ', strtotime("$tgl_masuk"));

            $jam_masuk_fix1 = date('dmy', strtotime("$tgl_masuk"));
            // var_dump($jam_masuk_fix, $jam_masuk_fix1);
            // exit;
            $RoomID = $data['RoomID'];
            $idtrf = $data['idtrf'];
            $GroupJaminan = $data['GroupJaminan'];
            $nomr_validasi = $data['nomr_pass'];
            

            $isactive = '1';
            $noactive = '0';
            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $namauserx = $session->name;

            //Session user
            $session = SessionManager::getCurrentSession();
            $userid =  $session->IDEmployee;

            // Cek Data
            if ($ClassID == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Pilih Kelas !',
                );
                return $callback;
                exit;
            }

            if ($RoomName == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Pilih Kamar !',
                );
                return $callback;
                exit;
            }

            if ($Bed == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Pilih Bed !',
                );
                return $callback;
                exit;
            }

            if ($RoomID == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kamar Tersebut Sudah Expired atau Tidak Ada Di Database ! Silahkan Pilih Kamar Lain',
                );
                return $callback;
                exit;
            }

            /*
            //CEK ORDER PINDAH KAMAR SUDAH DI PAKAI BELUM
            $sql = "SELECT *from MedicalRecord.dbo.MR_TransferPasien
            where id=:idtrf and StatusTransfer=:isactive";
            $this->db->query($sql);
            $this->db->bind("idtrf", $idtrf);
            $this->db->bind("isactive", $isactive);
            $this->db->execute();
            $getData = $this->db->resultSet();  
            $productCount = count($getData);
            if($productCount > 0)  
            {
                $callback = array(
                              'status' => 'warning',
                              'errorname' => "Order Perpindahan Kamar sudah di Proses, silahkan refresh Halaman Order List permintaan Kamar dan Form Kamar Anda !",
                            );
                  echo json_encode($callback);
                  exit;
            }  
            */

            $titipan = $data['Titipan'];

            if ($titipan == '1') {
                $idkelas_titipan = $data['ClassID_Titipan'];
                if (isset($data['NamaKamar_Titipan'])) {
                    $roomname_titipan = $data['NamaKamar_Titipan'];
                } else {
                    $roomname_titipan = '';
                }
                if (isset($data['BedKamar_Titipan'])) {
                    $bed_titipan = $data['BedKamar_Titipan'];
                } else {
                    $bed_titipan = '';
                }
                $tarif_titipan = $data['TarifKamar_Titipan'];
                $roomid_titipan = $data['RoomID_Titipan'];

                if ($idkelas_titipan == '') {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Silahkan Pilih Kelas Titipan!',
                    );
                    echo json_encode($callback);
                    exit;
                }

                if ($roomname_titipan == '') {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Silahkan Pilih Kamar Titipan!',
                    );
                    echo json_encode($callback);
                    exit;
                }

                if ($bed_titipan == '') {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Silahkan Pilih Bed Titipan!',
                    );
                    echo json_encode($callback);
                    exit;
                }

                if ($roomid_titipan == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Kamar Titipan Tersebut Sudah Expired atau Tidak Ada Di Database ! Silahkan Pilih Kamar Lain',
                    );
                    return $callback;
                    exit;
                }

                //Cek Jika Jaminan BPJS harus kamar bpjs
                if ($GroupJaminan == 'BS') {
                    $this->db->query("SELECT *
                FROM MasterdataSQL.dbo.MstrRoomID
                WHERE Publish='0' and KLSID=:class AND Room=:kamar AND Bad=:bed");
                    $this->db->bind('class', $idkelas_titipan);
                    $this->db->bind('kamar', $roomname_titipan);
                    $this->db->bind('bed', $bed_titipan);
                    $data =  $this->db->single();
                    if ($data) {
                        $callback = array(
                            'status' => "warning",
                            'errorname' => "Pasien Tersebut Adalah Jaminan BPJS, Silahkan Pilih Kamar Yang Terintegrasi Dengan BPJS !",
                        );
                        return $callback;
                        exit;
                    }
                }

                $idkelas_ext = $idkelas_titipan;
            } else {
                $idkelas_titipan = null;
                $roomname_titipan = null;
                $bed_titipan = null;
                $tarif_titipan = null;
                $roomid_titipan = null;
                $idkelas_ext = $ClassID;
            }

            //Cek Jika Jaminan BPJS harus kamar bpjs
            if ($GroupJaminan == 'BS') {
                $this->db->query("SELECT *
                FROM MasterdataSQL.dbo.MstrRoomID
                WHERE Publish='0' and KLSID=:class AND Room=:kamar AND Bad=:bed");
                $this->db->bind('class', $ClassID);
                $this->db->bind('kamar', $RoomName);
                $this->db->bind('bed', $Bed);
                $data =  $this->db->single();
                if ($data) {
                    $callback = array(
                        'status' => "warning",
                        'errorname' => "Pasien Tersebut Adalah Jaminan BPJS, Silahkan Pilih Kamar Yang Terintegrasi Dengan BPJS !",
                    );
                    return $callback;
                    exit;
                }
            }


            //Get Nama Kelas
            $this->db->query("SELECT NamaKelas From RawatInapSQL.dbo.TblKelas where IDkelas=:class ");
            $this->db->bind('class', $ClassID);
            $data =  $this->db->single();
            $NamaKelas = $data['NamaKelas'];

            //Cek Jika kamar sudah digunakan
            $this->db->query("SELECT *
            FROM RawatInapSQL.dbo.View_InformasiKamarRI
            WHERE KLSID=:class AND Room=:kamar AND Bad=:bed
            and NoMR not in (select NoMR from RawatInapSQL.dbo.Inpatient where NoRegRI=:noreg)");
            $this->db->bind('class', $ClassID);
            $this->db->bind('kamar', $RoomName);
            $this->db->bind('bed', $Bed);
            $this->db->bind('noreg', $noreg);
            $data =  $this->db->single();
            //var_dump($data['RoomID']);exit;
            if ($data) {
                $cekdata = $data['RoomID'];
                //var_dump($cekroom);
                if ($cekdata != '' || $cekdata != null) {
                    $callback = array(
                        'status' => "warning",
                        'errorname' => "Kamar Tersebut Sudah Dalam Posisi Aktif, Silahkan Cari Kamar Lain!",
                        'errormessage' => $cekdata,
                    );
                    return $callback;
                    exit;
                }
            }

             //Cek Jika kamar dibooking atau tidak
             $this->db->query("SELECT count(ID) as cekbooking
             FROM RawatInapSQL.dbo.BookingBeds
             where transactioncode=:kodebooking
             ");
             $this->db->bind('kodebooking', $kodebooking);
             $datafx=  $this->db->single();
             $cekbooking = $datafx['cekbooking'];
             //var_dump($datafx['cekbooking']);exit;

             if ($cekbooking < 1){
                    $this->db->query("SELECT Status as statuskamar
                    FROM MasterdataSQL.dbo.MstrRoomID
                    where Status<>0 and KLSID=:class AND Room=:kamar AND Bad=:bed
                    ");
                    $this->db->bind('class', $ClassID);
                    $this->db->bind('kamar', $RoomName);
                    $this->db->bind('bed', $Bed);
                    $dataa =  $this->db->single();
                    if ($dataa){
                        if ($dataa['statuskamar'] == '2') {
                                $callback = array(
                                    'status' => "warning",
                                    'errorname' => "Kamar tersebut sudah dibooking !",
                                );
                                return $callback;
                                exit;
                        }

                        if ($dataa['statuskamar'] == '3') {
                                $callback = array(
                                    'status' => "warning",
                                    'errorname' => "Kamar tersebut sedang dibersihkan ruangannya (cleaning) !",
                                );
                                return $callback;
                                exit;
                        }
                            $callback = array(
                                'status' => "warning",
                                'errorname' => "Kamar tersebut tidak tersedia !",
                            );
                            return $callback;
                            exit;
                    }
                 }
                 //var_dump('ddddxx');exit;

            if ($idtrs == '' || $idtrs == null) { // jika idtrs null maka create new


                //Cek Jika ada kamar yang aktif di no registrasi ini
                $this->db->query("SELECT *
                FROM RawatInapSQL.dbo.Inpatient_in_out
                WHERE StatusActive=:isactive AND NoRegRI=:noreg");
                $this->db->bind('noreg', $noreg);
                $this->db->bind('isactive', $isactive);
                $data =  $this->db->single();
                if ($data) {
                    $dataidregfieedback = $data['NoRegRI'];
                    $callback = array(
                        'status' => "warning",
                        'errorname' => "Nomor Registrasi Ini Masih Mempunyai Kamar Yang Aktif, Silahkan Checkout Terlebih Dahulu Kamar Yang Aktif!",
                        'errormessage' => $dataidregfieedback,
                    );
                    return $callback;
                    exit;
                }

                //Insert/update transaction
                // INSERT INPATIENT
                $sqlx = " INSERT INTO RawatInapSQL.dbo.Inpatient_in_out ( 
                NoRegRI,RoomID,IDKelas,Class,RoomName,Bed,Tarif,
                StartDate,TimeStart,StatusActive,Disc,Titipan,RoomID_Titipan,IDKelas_Titipan,RoomName_Titipan,Bed_Titipan,Tarif_Titipan) VALUES
                (:noreg,:roomid,:idkelas,:class,:kamar,:bed,:tarif,
                :tgl_masuk,:jam_masuk_fix,:isactive,:discount,:titipan,:roomid_titipan,:idkelas_titipan,:roomname_titipan,:bed_titipan,:tarif_titipan)";
                $this->db->query($sqlx);
                $this->db->bind('noreg', $noreg);
                $this->db->bind('roomid', $RoomID);
                $this->db->bind('idkelas', $ClassID);
                $this->db->bind('class', $NamaKelas);
                $this->db->bind('kamar', $RoomName);
                $this->db->bind('bed', $Bed);
                $this->db->bind('tarif', $TarifKamar);
                $this->db->bind('tgl_masuk', $tgl_masuk);
                $this->db->bind('jam_masuk_fix', $jam_masuk_fix);
                $this->db->bind('isactive', $isactive);
                $this->db->bind('discount', '0');
                $this->db->bind('titipan', $titipan);
                $this->db->bind('roomid_titipan', $roomid_titipan);
                $this->db->bind('idkelas_titipan', $idkelas_titipan);
                $this->db->bind('roomname_titipan', $roomname_titipan);
                $this->db->bind('bed_titipan', $bed_titipan);
                $this->db->bind('tarif_titipan', $tarif_titipan);
                $this->db->execute();
                $id_inpatientinout_max = $this->db->GetLastID();
                //var_dump($id_inpatientinout_max);exit;


                // set status room jadi terpakai
                $queryUpdateRoom = "UPDATE MasterdataSQL.dbo.MstrRoomID 
              SET Status=:isactive WHERE RoomID=:roomid";
                $this->db->query($queryUpdateRoom);
                $this->db->bind('isactive', $isactive);
                $this->db->bind('roomid', $RoomID);
                $this->db->execute();

                /*
                // GET MAX ID INpatient_in_out----------------------------------
                $sql = "SELECT MAX(ID) as ID
                FROM RawatInapSQL.dbo.Inpatient_in_out
                WHERE NoRegRI=:noreg ";
                   $this->db->query($sql);
                   $this->db->bind("noreg", $noreg);
                   $data =  $this->db->single();
                   $id_inpatientinout_max = $data['ID'];
                   */

                $this->db->query("SELECT  TOP 1 NO_TRS_BILLING,right( REPLACE(NO_TRS_BILLING,'-','0')  ,5) as urut FROM Billing_Pasien.dbo.FO_T_BILLING  WHERE replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-')=:datenow2  ORDER BY urut DESC");
                $this->db->bind('datenow2', $jam_masuk_fix2);
                $datax =  $this->db->single();
                //no urut reg
                $nexturut = $datax['urut'];
                $nexturut++;

                $nourutfix = Utils::generateAutoNumber($nexturut);
                $kodeawal = "BIL";
                $notrsbill = $kodeawal . $jam_masuk_fix1 . $nourutfix;

                // $this->db->query("SELECT [Order ID] as orderid FROM [Apotik_V1.1SQL].dbo.[Order Details] WHERE [Order ID] = :dataOrderid");
                // $this->db->bind('dataOrderid', $dataaptk);
                // $datafo =  $this->db->single();
                // $dataaccnumber = $datafo['orderid'];

                $this->db->query("SELECT COUNT(*) as FOBILLING1 FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE ID_BILL = :dataKamar");
                $this->db->bind('dataKamar', $id_inpatientinout_max);
                $datafo =  $this->db->single();
                $datafoo = $datafo['FOBILLING1'];

                if ($datafoo == "0") {
                    //get data Inpatient
                    $this->db->query("SELECT a.NoMR,a.NoEpisode,b.ID, a.TypePatient, case when a.TypePatient='2' then a.IDAsuransi else a.IDJPK end as perusahaanid, a.KlsID
                           FROM RawatInapSQL.dbo.Inpatient a 
                           INNER JOIN MasterdataSQL.dbo.MstrUnitPerwatan b ON b.NamaUnit = a.JenisRawat
                           WHERE NoRegRI = :NoRegistrasi");
                    $this->db->bind('NoRegistrasi', $noreg);
                    $datax =  $this->db->single();
                    $IdGrupPerawatan = $datax['ID'];
                    $JenisBayar = $datax['TypePatient'];
                    $perusahaanid = $datax['perusahaanid'];
                    $dataa = $datax['NoMR'];
                    $dataaa = $datax['NoEpisode'];
                    $datakelas = $datax['KlsID'];


                    // insert ke tabel FO_T_Billing
                    $this->db->query("INSERT INTO Billing_Pasien.dbo.FO_T_BILLING
                       ([NO_TRS_BILLING],[TGL_BILLING],[PETUGAS_ENTRY],[NO_MR],[NO_EPISODE],[NO_REGISTRASI],[UNIT],[GROUP_JAMINAN],[KODE_JAMINAN],[TOTAL_TARIF],[TOTAL_QTY],[SUBTOTAL],[TOTAL_DISCOUNT],[TOTAL_DISCOUNT_RP],[SUBTOTAL_2],[GRANDTOTAL],[BATAL],[FB_CLOSE_KEUANGAN],[FB_VERIF_JURNAL]) 
                       VALUES
                       (:notrsbill,:datenowx,:namauserx,:NoMrfix,:NoEpisode,:nofixReg,:IdGrupPerawatan,:JenisBayar,:perusahaanid,:totaltarif,:totalqty,:subtotal,:totaldiscount,:totaldiscountrp,:subtotal2,:grandtotal,:batal,:closekeuangan,:verifkeuangan)");

                    $this->db->bind('notrsbill', $notrsbill);
                    $this->db->bind('datenowx', $jam_masuk_fix);
                    $this->db->bind('namauserx', $namauserx);
                    $this->db->bind('NoMrfix', $dataa);
                    $this->db->bind('NoEpisode', $dataaa);
                    $this->db->bind('nofixReg', $noreg);
                    $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                    $this->db->bind('JenisBayar', $JenisBayar);
                    $this->db->bind('perusahaanid', $perusahaanid);
                    $this->db->bind('totaltarif', $TarifKamar);
                    $this->db->bind('totalqty', 0);
                    $this->db->bind('subtotal', 0);
                    $this->db->bind('totaldiscount', 0);
                    $this->db->bind('totaldiscountrp', 0);
                    $this->db->bind('subtotal2', 0);
                    $this->db->bind('grandtotal', 0);
                    $this->db->bind('batal', 0);
                    $this->db->bind('closekeuangan', 0);
                    $this->db->bind('verifkeuangan', 0);
                    $this->db->execute();

                    $this->db->query("SELECT ID,RoomID, RoomName,drPenerima,a.Tarif FROM RawatInapSQL.dbo.Inpatient_in_out a
                    inner join RawatInapSQL.dbo.Inpatient b on a.NoRegRI=b.NoRegRI where ID = :idkamar");
                    $this->db->bind('idkamar', $id_inpatientinout_max);
                    $dataacc =  $this->db->single();
                    // $idtrs2 = $dataacc['ID'];
                    $Kode_Tarif = $dataacc['RoomID'];
                    $Nama_Tarif = $dataacc['RoomName'];
                    $drPenerima = $dataacc['drPenerima'];
                    $Tarif_Servis = $dataacc['Tarif'];


                    $this->db->query("SELECT jumlah,LamaRawat from RawatInapSQL.dbo.View_LamaRawat where NoRegRI=:NOREG");
                    $this->db->bind('NOREG', $noreg);
                    $datajmlh =  $this->db->single();
                    // $idtrs2 = $dataacc['ID'];
                    $Jmlh = $datajmlh['jumlah'];
                    $Qty = $datajmlh['LamaRawat'];

                    // var_dump($Tarif_Servis);
                    // exit;

                    $this->db->query("SELECT TypePatient FROM RawatInapSQL.dbo.Inpatient WHERE NoRegRI = :NOREG2121");
                    $this->db->bind('NOREG2121', $noreg);
                    $datagrjaminan =  $this->db->single();
                    // $idtrs2 = $dataacc['ID'];
                    $groupjaminan1 = $datagrjaminan['TypePatient'];

                    // if ($groupjaminan1 == "1") {
                    //     $kekurangan = $Jmlh;
                    //     $klaim = "0";
                    //     $bayar = "0";
                    // } else {
                    //     $kekurangan = "0";
                    //     $klaim = $Jmlh;
                    //     $bayar = "0";
                    // }
                    if ($GroupJaminan == 'UM') {
                        $kekurangan = $Jmlh;
                        $klaim = "0";
                        $bayar = "0";
                    } else {
                        $kekurangan = "0";
                        $klaim = $Jmlh;
                        $bayar = "0";
                    }
                    // insert ke tabel FO_T_Billing_1
                    // select Radiologi
                    $this->db->query("INSERT INTO  Billing_Pasien.dbo.FO_T_BILLING_1
                    (ID_BILL,[NO_TRS_BILLING],[TGL_BILLING] ,[PETUGAS_ENTRY],[NO_MR],[NO_EPISODE],[NO_REGISTRASI],[KODE_TARIF],[UNIT],[GROUP_JAMINAN],[KODE_JAMINAN],
                    [NAMA_TARIF],[GROUP_TARIF],[KD_KELAS],[QTY],[NILAI_TARIF],[SUB_TOTAL],[DISC],[DISC_RP],[SUB_TOTAL_2],[GRANDTOTAL],[KODE_REF],[KD_DR],[NM_DR],
                    [BATAL],[PETUGAS_BATAL],[GROUP_ENTRI],[BAYAR],[KLAIM],[KEKURANGAN])
                    SELECT '$id_inpatientinout_max','$notrsbill' , '$jam_masuk_fix' as datenow,'$namauserx' as namauserx,'$dataa' AS NoMR, '$dataaa' AS xNoEpisode,'$noreg' as NoReg,:Kode_Tarif as kodetarif,
                    UNIT,GROUP_JAMINAN,KODE_JAMINAN, :Nama_Tarif as namatarif,'Kamar' as rad, :kdkelas, 1 as Qty, :Nilai as nilai, :Nilai2 as nilai2, 0, 
                    0, :Nilai3 as nilai3, :Nilai4 as nilai4,'$id_inpatientinout_max', :drPenerima, null as namadokter, 0 as batal,null as petugasbatal,'KAMAR',$bayar,$klaim,$kekurangan
                    FROM Billing_Pasien.dbo.FO_T_BILLING
                    WHERE NO_TRS_BILLING=:notrsbill AND Batal='0'");
                    $this->db->bind('notrsbill', $notrsbill);
                    $this->db->bind('Kode_Tarif', $Kode_Tarif);
                    $this->db->bind('Nama_Tarif', $Nama_Tarif);
                    $this->db->bind('Nilai',  $Tarif_Servis);
                    $this->db->bind('Nilai2', $Tarif_Servis);
                    $this->db->bind('Nilai3', $Tarif_Servis);
                    $this->db->bind('Nilai4', $Tarif_Servis);
                    $this->db->bind('drPenerima', $drPenerima);
                    $this->db->bind('kdkelas', $datakelas);

                    $this->db->execute();
                    // var_dump($notrsbill);
                    // exit;
                    $this->db->query("INSERT INTO Billing_Pasien.DBO.FO_T_BILLING_2
                    SELECT '$id_inpatientinout_max',A.NO_TRS_BILLING AS NO_TRS_BILLING,A1.KODE_TARIF,B.KD_TIPE_PDP as Kode_komponen,A1.UNIT AS UNIT, 
                    A1.GROUP_JAMINAN AS GROUP_JAMINAN, A1.KODE_JAMINAN AS KODE_JAMINAN, A1.NAMA_TARIF AS NAMA_TARIF, A1.GROUP_TARIF AS GROUP_TARIF,
                    A1.KD_KELAS as KELAS,A1.QTY AS QTY, A1.NILAI_TARIF AS NILAI_TARIF , A1.NILAI_TARIF*A1.QTY  AS SUBTOTAL,A1.DISC AS DISC,
                    0 AS DISC_RP,((A1.NILAI_TARIF*A1.QTY)-(((A1.NILAI_TARIF*A1.QTY)*A1.DISC)/100)) SUB_TOTAL_PDP_2,
                    (CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN ((((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' THEN 
                    ((b.NILAI_FIX*A1.QTY*DISC)/100)*A1.QTY END ) NILAI_DISKON_PDP,(CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN 
                    (((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY)-(((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' 
                    THEN (b.NILAI_FIX*A1.QTY)-((b.NILAI_FIX*A1.QTY*DISC)/100)*A1.QTY END ) as NILAI_PDP,A1.KD_DR AS KD_DR, '' NM_DR,b.NILAI_PROSEN,'0' AS BATAL,
                    '' PETUGAS_BATAL, '' AS JAM_BATAL, B.KD_POSTING AS KD_POSTING,'' as kd_posting_diskon, 0 as ID_TR_TARIF_PAKET
                    FROM Billing_Pasien.DBO.FO_T_BILLING A
                    inner join Billing_Pasien.dbo.FO_T_BILLING_1 A1 ON A.NO_TRS_BILLING = A1.NO_TRS_BILLING
                    INNER JOIN MasterdataSQL.dbo.MstrRoomID CC ON CC.RoomID = A1.KODE_TARIF 
                    INNER JOIN Keuangan.DBO.BO_M_PDP2 B ON CC.KD_PDP collate SQL_Latin1_General_CP1_CI_AS = B.KD_PDP collate SQL_Latin1_General_CP1_CI_AS
                    INNER JOIN Keuangan.DBO.BO_M_PDP CX ON CX.KD_PDP = B.KD_PDP
                    WHERE a.NO_TRS_BILLING=:notrsbill2");
                    $this->db->bind('notrsbill2', $notrsbill);
                    $this->db->execute();
                }

                // CEK field RoomID_Awal ada gak
                $sql = "SELECT *
                        FROM RawatInapSQL.dbo.Inpatient
                        WHERE NoRegRI=:noreg and RoomID_Awal is not null";
                $this->db->query($sql);
                $this->db->bind("noreg", $noreg);
                $this->db->execute();
                $getData = $this->db->resultSet();
                $productCount = count($getData);

                if ($productCount > 0) {
                    // set kelas di tabel inpatient
                    $queryUpdateKelas = "UPDATE RawatInapSQL.dbo.Inpatient 
                                                    SET KlsID=:idkelas,RoomID_Akhir=:roomid,KelasID_Akhir=:idkelas2 
                                                    WHERE NoRegRI=:noreg";
                } else {
                    // set kelas di tabel inpatient
                    $queryUpdateKelas = "UPDATE RawatInapSQL.dbo.Inpatient 
                                                    SET KlsID=:idkelas,RoomID_Awal=:roomid,KelasID_Awal=:idkelas2 
                                                    WHERE NoRegRI=:noreg";
                }
                $this->db->query($queryUpdateKelas);
                $this->db->bind('idkelas', $idkelas_ext);
                $this->db->bind('idkelas2', $idkelas_ext);
                $this->db->bind('noreg', $noreg);
                $this->db->bind('roomid', $id_inpatientinout_max);
                $this->db->execute();

                //update di bookingbeds
                if ($kodebooking != ''){
                    $bookingbeds = "UPDATE RawatInapSQL.dbo.BookingBeds
                                                        SET idinpatientinout=:id_inpatientinout_max,bookingstatus='1'
                                                        WHERE transactioncode=:kodebooking";
                    $this->db->query($bookingbeds);
                    $this->db->bind('id_inpatientinout_max', $id_inpatientinout_max);
                    $this->db->bind('kodebooking', $kodebooking);
                    $this->db->execute();

                    if ($nomr_validasi != ''){
                        $updatenomr = "UPDATE RawatInapSQL.dbo.BookingBeds
                                                        SET medicalrecordnumber=:nomr_validasi
                                                        WHERE transactioncode=:kodebooking";
                        $this->db->query($updatenomr);
                        $this->db->bind('kodebooking', $kodebooking);
                        $this->db->bind('nomr_validasi', $nomr_validasi);
                        $this->db->execute();
                    }

                }

                //pesan return
                $return_message = 'Simpan & Check In Kamar Berhasil Dilakukan!';

                //Get kode lokasi----------
                $this->db->query("SELECT KodeLokasi from MasterdataSQL.dbo.MstrRoomID
                    WHERE KLSID=:class AND Room=:kamar AND Bad=:bed");
                $this->db->bind('class', $ClassID);
                $this->db->bind('kamar', $RoomName);
                $this->db->bind('bed', $Bed);
                $data =  $this->db->single();
                $this->UpdateKetersediaanKamarBPJS($data['KodeLokasi']);
            } else { //Jika Edit maka update

                //Cek Sudah Dihapus Atau Belum
                $this->db->query("SELECT *,replace(CONVERT(VARCHAR(11), StartDate, 111), '/','-') as startdate
            FROM RawatInapSQL.dbo.Inpatient_in_out Where ID=:idtrs");
                $this->db->bind('idtrs', $idtrs);
                $data =  $this->db->single();

                if ($data === false) {
                    $callback = array(
                        'status' => "warning",
                        'errorname' => "ID Tidak Ditemukan! Data Sudah Dihapus! Silahkan Cek Kembali!",
                    );
                    return $callback;
                    exit;
                }

                $alasan = $_POST['alasan'];

                //Get Data Kamar Lama
                $sql = "SELECT StatusActive,RoomID,NoRegRI
            FROM RawatInapSQL.dbo.Inpatient_in_out
            WHERE ID=:id_inpatientinout ";
                $this->db->query($sql);
                $this->db->bind("id_inpatientinout", $idtrs);
                $data =  $this->db->single();
                $roomid_lama = $data['RoomID'];
                $cek_status = $data['StatusActive'];
                $noregInOut = $data['NoRegRI'];

                $this->db->query("SELECT * from Billing_Pasien.dbo.FO_T_BILLING_1 where NO_REGISTRASI=:regis");
                $this->db->bind('regis', $noreg);
                $dataa1 =  $this->db->single();

                $this->db->query("SELECT jumlah,LamaRawat from RawatInapSQL.dbo.View_LamaRawat where NoRegRI=:NOREG");
                $this->db->bind('NOREG', $noreg);
                $datajmlh =  $this->db->single();
                // $idtrs2 = $dataacc['ID'];
                $Jmlh = $datajmlh['jumlah'];
                $Qty = $datajmlh['LamaRawat'];

                // var_dump($Tarif_Servis);
                // exit;

                if ($dataa1['GROUP_JAMINAN'] == "1") {
                    $kekurangan = $Jmlh;
                    $klaim = "0";
                    $bayar = "0";
                } else {
                    $kekurangan = "0";
                    $klaim = $Jmlh;
                    $bayar = "0";
                }
                //Insert ke Tz_Log_Button
                $keterangan = 'Pindah Kamar Dari RoomID Lama: ' . $roomid_lama . ' Ke RoomID Baru:' . $RoomID;
                $sqlx = "INSERT INTO  SysLog.dbo.TZ_Log_Button (idtrs,noregistrasi,nama_biling,petugas_batal,tgl_batal,alasan_batal) VALUES
                (:InpatientID,:noregri,:info,:namauserx,:datenowcreate,:alasan)";
                $this->db->query($sqlx);
                $this->db->bind('InpatientID', $idtrs);
                $this->db->bind('noregri', $noreg);
                $this->db->bind('info', $keterangan);
                $this->db->bind('namauserx', $userid);
                $this->db->bind('datenowcreate', $datenowcreate);
                $this->db->bind('alasan', $alasan);
                $this->db->execute();

                if ($cek_status == '1') { //Cek jika kamar yang diedit dalam keadaan aktif atau tidak
                    // set status room yang lama jadi tidak terpakai
                    $queryUpdateRoomLama = "UPDATE MasterdataSQL.dbo.MstrRoomID 
                SET Status=:isactive WHERE RoomID=:roomid";
                    $this->db->query($queryUpdateRoomLama);
                    $this->db->bind('isactive', $noactive);
                    $this->db->bind('roomid', $roomid_lama);
                    $this->db->execute();

                    // set status room jadi terpakai
                    $queryUpdateRoom = "UPDATE MasterdataSQL.dbo.MstrRoomID 
                SET Status=:isactive WHERE RoomID=:roomid";
                    $this->db->query($queryUpdateRoom);
                    $this->db->bind('isactive', $isactive);
                    $this->db->bind('roomid', $RoomID);
                    $this->db->execute();
                }

                // Update di tabel inpatient_in_out
                $queryUpdatekmr = "UPDATE RawatInapSQL.dbo.Inpatient_in_out SET RoomID=:roomid,IDKelas=:idkelas,Class=:class,RoomName=:kamar,Bed=:bed,Tarif=:tarif,Titipan=:titipan,RoomID_Titipan=:roomid_titipan,IDKelas_Titipan=:idkelas_titipan,RoomName_Titipan=:roomname_titipan,Bed_Titipan=:bed_titipan,Tarif_Titipan=:tarif_titipan
                WHERE ID=:id_inpatientinout";
                $this->db->query($queryUpdatekmr);
                $this->db->bind('roomid', $RoomID);
                $this->db->bind('idkelas', $ClassID);
                $this->db->bind('class', $NamaKelas);
                $this->db->bind('kamar', $RoomName);
                $this->db->bind('bed', $Bed);
                $this->db->bind('tarif', $TarifKamar);
                $this->db->bind('id_inpatientinout', $idtrs);
                $this->db->bind('titipan', $titipan);
                $this->db->bind('roomid_titipan', $roomid_titipan);
                $this->db->bind('idkelas_titipan', $idkelas_titipan);
                $this->db->bind('roomname_titipan', $roomname_titipan);
                $this->db->bind('bed_titipan', $bed_titipan);
                $this->db->bind('tarif_titipan', $tarif_titipan);
                $this->db->execute();

                $this->db->query(" UPDATE Billing_Pasien.dbo.FO_T_BILLING set TOTAL_TARIF=:tarif where NO_REGISTRASI=:regis");
                $this->db->bind('regis', $noregInOut);
                $this->db->bind('tarif', $TarifKamar);
                $this->db->execute();


                $this->db->query(" UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 set KODE_TARIF=:KODE,NAMA_TARIF=:NAMEROOM,NILAI_TARIF=:tarif,KODE_REF=:ref,KLAIM=:klaim,KEKURANGAN=:kurang where NO_REGISTRASI=:regis and ID_BILL=:id_inpatientinout");
                $this->db->bind('regis', $noregInOut);
                $this->db->bind('KODE', $RoomID);
                $this->db->bind('NAMEROOM', $RoomName);
                $this->db->bind('ref', $idtrs);
                $this->db->bind('tarif', $TarifKamar);
                $this->db->bind('klaim', $klaim);
                $this->db->bind('kurang', $kekurangan);
                $this->db->bind('id_inpatientinout', $idtrs);
                $this->db->execute();

                $this->db->query(" UPDATE Billing_Pasien.dbo.FO_T_BILLING_2 set KODE_TARIF=:KODE,NAMA_TARIF=:NAMEROOM,NILAI_TARIF=:tarif,NILAI_PDP=:pdp where ID_BILL=:id_inpatientinout");
                $this->db->bind('KODE', $RoomID);
                $this->db->bind('NAMEROOM', $RoomName);
                $this->db->bind('tarif', $TarifKamar);
                $this->db->bind('pdp', $TarifKamar);
                $this->db->bind('id_inpatientinout', $idtrs);
                $this->db->execute();
                // exit;
                //pesan return
                $return_message = 'Edit Kamar Berhasil Dilakukan!';

                //Get kode lokasi dan bridging bpjs----------
                $this->db->query("SELECT KodeLokasi from MasterdataSQL.dbo.MstrRoomID
                    WHERE RoomID=:roomid");
                $this->db->bind('roomid', $roomid_lama);
                $data =  $this->db->single();
                $this->UpdateKetersediaanKamarBPJS($data['KodeLokasi']);

                sleep(1);

                //Get kode lokasi dan bridging bpjs----------
                $this->db->query("SELECT KodeLokasi from MasterdataSQL.dbo.MstrRoomID
                    WHERE RoomID=:roomid");
                $this->db->bind('roomid', $RoomID);
                $data =  $this->db->single();
                $this->UpdateKetersediaanKamarBPJS($data['KodeLokasi']);
            }

            /*
        if($idtrf<>'' || $idtrf <> null){
            // set order pindah kamar jadi sudah di eksekusi / 1
             $queryUpdateReq = "UPDATE MedicalRecord.dbo.MR_TransferPasien 
                                 SET StatusTransfer='1'
                                 where NoRegistrasi=:noreg and ID=:idtrf";
             $this->db->query($queryUpdateReq);
             $this->db->bind('noreg', $noreg);
             $this->db->bind('idtrf', $idtrf); 
             $this->db->execute();
         }*/

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => $return_message,
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'errorname' => $e
            );
            return $callback;
        }
    }

    public function CekStatusAktif($data)
    {
        try {
            $noreg = $data['NoRegistrasi'];
            //Cek Jika ada kamar yang aktif di no registrasi ini
            $this->db->query("SELECT *
            FROM RawatInapSQL.dbo.Inpatient_in_out
            WHERE StatusActive=:isactive AND NoRegRI=:noreg");
            $this->db->bind('noreg', $noreg);
            $this->db->bind('isactive', '1');
            $data =  $this->db->single();
            if ($data) {
                $dataidregfieedback = $data['NoRegRI'];
                $callback = array(
                    'status' => "warning",
                    'errorname' => "Nomor Registrasi Ini Masih Mempunyai Kamar Yang Aktif, Silahkan Checkout Terlebih Dahulu Kamar Yang Aktif!",
                    'errormessage' => $dataidregfieedback,
                );
                return $callback;
                exit;
            }

            $callback = array(
                'message' => "success", // Set array nama
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function CheckoutKamar($data)
    {
        try {

            // var_dump($data);
            // exit;
            $this->db->transaksi();
            $datenowcreate = Utils::seCurrentDateTime();

            $tgl_keluar = date('Y-m-d', strtotime($data['tgl_keluar']));
            $jam_keluar = date('H:i:s', strtotime($data['tgl_keluar']));
            $idtrs = $data['idtrs'];

            //Get Noregri
            $this->db->query("SELECT NoRegRI,IDKelas,IDKelas_Titipan,Titipan
            FROM RawatInapSQL.dbo.Inpatient_in_out
            WHERE ID=:idtrs");
            $this->db->bind('idtrs', $idtrs);
            $data =  $this->db->single();
            $noreg = $data['NoRegRI'];
            $IDKelas = $data['IDKelas'];
            $IDKelas_Titipan = $data['IDKelas_Titipan'];
            $Titipan = $data['Titipan'];

            if ($Titipan == '1') {
                $idkelas_ext = $IDKelas_Titipan;
            } else {
                $idkelas_ext = $IDKelas;
            }

            //Session user
            $session = SessionManager::getCurrentSession();
            $operator =  $session->IDEmployee;

            //Cek
            $this->db->query("SELECT *
            FROM RawatInapSQL.dbo.Inpatient_in_out
            WHERE StatusActive='0' AND ID=:idtrs");
            $this->db->bind('idtrs', $idtrs);
            $data =  $this->db->single();
            if ($data) {
                $callback = array(
                    'status' => "warning",
                    'errorname' => "Kamar Ini Sudah Di Check Out!",
                );
                return $callback;
                exit;
            }

            // Update di tabel inpatient_in_out checkout
            $queryUpdatekmr = "UPDATE RawatInapSQL.dbo.Inpatient_in_out SET EndDate=:tgl_keluar,TimeEnd=:jam_keluar,StatusActive=0,LamaRawat=RawatInapSQL.dbo.fn_GetTotalHariRawat(StartDate, ISNULL(:tgl_keluar2, GETDATE()), ISNULL(:jam_keluar2, GETDATE())),UserEdit=:operator,DateEdit=:datenowcreate
            WHERE ID=:id_kamar";
            $this->db->query($queryUpdatekmr);
            $this->db->bind('id_kamar', $idtrs);
            $this->db->bind('tgl_keluar', $tgl_keluar);
            $this->db->bind('jam_keluar', $jam_keluar);
            $this->db->bind('tgl_keluar2', $tgl_keluar);
            $this->db->bind('jam_keluar2', $jam_keluar);
            $this->db->bind('operator', $operator);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->execute();

            $this->db->query("SELECT jumlah,LamaRawat from RawatInapSQL.dbo.View_LamaRawat where NoRegRI=:NOREG");
            $this->db->bind('NOREG', $noreg);
            $datajmlh =  $this->db->single();
            // $idtrs2 = $dataacc['ID'];
            $Jmlh = $datajmlh['jumlah'];
            $Qty = $datajmlh['LamaRawat'];

            $this->db->query("SELECT NO_TRS_BILLING from Billing_Pasien.dbo.FO_T_BILLING_1 where NO_REGISTRASI=:NOREG and ID_BILL=:id");
            $this->db->bind('NOREG', $noreg);
            $this->db->bind('id', $idtrs);
            $datatrs =  $this->db->single();
            // $idtrs2 = $dataacc['ID'];
            $trs = $datatrs['NO_TRS_BILLING'];


            $this->db->query("SELECT TypePatient FROM RawatInapSQL.dbo.Inpatient WHERE NoRegRI = :NOREG2121");
            $this->db->bind('NOREG2121', $noreg);
            $datagrjaminan =  $this->db->single();
            // $idtrs2 = $dataacc['ID'];
            $groupjaminan1 = $datagrjaminan['TypePatient'];

            // var_dump();
            // exit;
            if ($groupjaminan1 == "1") {
                $kekurangan = $Jmlh;
                $klaim = "0";
                $bayar = "0";
            } else {
                $kekurangan = "0";
                $klaim = $Jmlh;
                $bayar = "0";
            }


            $this->db->query(" UPDATE Billing_Pasien.dbo.FO_T_BILLING set TOTAL_QTY=:lamaRawat,SUBTOTAL=:total,SUBTOTAL_2=:subtot2,GRANDTOTAL=:grandtot2 where NO_REGISTRASI=:NOREG and NO_TRS_BILLING=:Notrs");
            $this->db->bind('NOREG', $noreg);
            $this->db->bind('lamaRawat', $Qty);
            $this->db->bind('total', $Jmlh);
            $this->db->bind('Notrs', $trs);
            $this->db->bind('subtot2', $Jmlh);
            $this->db->bind('grandtot2', $Jmlh);
            $this->db->execute();

            $this->db->query(" UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 set QTY=:lamaRawat,SUB_TOTAL=:total,SUB_TOTAL_2=:total2,GRANDTOTAL=:grandtot,KLAIM=:klaim1,KEKURANGAN=:kekurangan1 where NO_REGISTRASI=:NOREG and ID_BILL=:id");
            $this->db->bind('NOREG', $noreg);
            $this->db->bind('lamaRawat', $Qty);
            $this->db->bind('total', $Jmlh);
            $this->db->bind('total2', $Jmlh);
            $this->db->bind('grandtot', $Jmlh);
            $this->db->bind('id', $idtrs);
            $this->db->bind('klaim1', $klaim);
            $this->db->bind('kekurangan1', $kekurangan);
            $this->db->execute();

            $this->db->query(" UPDATE Billing_Pasien.dbo.FO_T_BILLING_2 set QTY=:lamaRawat,SUB_TOTAL=:total,SUB_TOTAL_2=:total2 where ID_BILL=:id");
            $this->db->bind('lamaRawat', $Qty);
            $this->db->bind('total', $Jmlh);
            $this->db->bind('total2', $Jmlh);
            $this->db->bind('id', $idtrs);
            $this->db->execute();

            // CEK field RoomID_Awal ada gak
            $sql = "SELECT *
            FROM RawatInapSQL.dbo.Inpatient
            WHERE NoRegRI=:noreg and RoomID_Awal is not null";
            $this->db->query($sql);
            $this->db->bind("noreg", $noreg);
            $this->db->execute();
            $getData = $this->db->resultSet();
            $productCount = count($getData);

            if ($productCount > 0) {
                // set kelas di tabel inpatient
                $queryUpdateKelas = "UPDATE RawatInapSQL.dbo.Inpatient 
                                            SET RoomID_Akhir=:roomid,KelasID_Akhir=:idkelas
                                            WHERE NoRegRI=:noreg";
            } else {
                // set kelas di tabel inpatient
                $queryUpdateKelas = "UPDATE RawatInapSQL.dbo.Inpatient 
                                            SET RoomID_Awal=:roomid,KelasID_Awal=:idkelas
                                            WHERE NoRegRI=:noreg";
            }
            $this->db->query($queryUpdateKelas);
            $this->db->bind('idkelas', $idkelas_ext);
            $this->db->bind('noreg', $noreg);
            $this->db->bind('roomid', $idtrs);
            $this->db->execute();

            // Update di tabel MstrRoomID active ke 0
            $queryUpdatekmr = " UPDATE MasterdataSQL.dbo.MstrRoomID SET Status=3 WHERE RoomID in (SELECT RoomID
            FROM RawatInapSQL.dbo.Inpatient_in_out
            WHERE ID=:id_kamar)";
            $this->db->query($queryUpdatekmr);
            $this->db->bind('id_kamar', $idtrs);
            $this->db->execute();

            //Insert ke Tz_Log_Button
            $keterangan = 'Checkout Kamar';
            $sqlx = "INSERT INTO  SysLog.dbo.TZ_Log_Button (idtrs,noregistrasi,nama_biling,petugas_batal,tgl_batal) VALUES
                (:idtrs,:noregri,:info,:namauserx,:datenowcreate)";
            $this->db->query($sqlx);
            $this->db->bind('idtrs', $idtrs);
            $this->db->bind('noregri', $noreg);
            $this->db->bind('info', $keterangan);
            $this->db->bind('namauserx', $operator);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->execute();


            //Get kode lokasi dan bridging bpjs----------
            $this->db->query("SELECT KodeLokasi from MasterdataSQL.dbo.MstrRoomID
                WHERE RoomID in (SELECT RoomID
                    FROM RawatInapSQL.dbo.Inpatient_in_out
                    WHERE ID=:id_kamar)");
            $this->db->bind('id_kamar', $idtrs);
            $data =  $this->db->single();
            $this->UpdateKetersediaanKamarBPJS($data['KodeLokasi']);

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Checkout Kamar Berhasil',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function CheckinKamar($data)
    {
        try {
            $this->db->transaksi();
            $datenowcreate = Utils::seCurrentDateTime();

            $idtrs = $data['idtrs'];

            //Get Noregri
            $this->db->query("SELECT NoRegRI,IDKelas,RoomName,Bed
            FROM RawatInapSQL.dbo.Inpatient_in_out
            WHERE ID=:idtrs");
            $this->db->bind('idtrs', $idtrs);
            $data =  $this->db->single();
            $noreg = $data['NoRegRI'];
            $ClassID = $data['IDKelas'];
            $RoomName = $data['RoomName'];
            $Bed = $data['Bed'];

            //Session user
            $session = SessionManager::getCurrentSession();
            $operator =  $session->IDEmployee;

            //alim
            $this->db->query("SELECT ID_TRS_Payment from RawatInapSQL.dbo.Inpatient_in_out a
              inner join Billing_Pasien.dbo.FO_T_BILLING_1 b on a.ID = b.KODE_REF
              inner join Billing_Pasien.dbo.FO_T_KASIR c on b.ID_TRS_Payment = c.NO_TRS
              where a.ID = :idtrs-- and a.NoRegRI=:NoRegRI");
            $this->db->bind('idtrs', $idtrs);
            // $this->db->bind('notrsfo312', $notrsfo);
            $dataPay =  $this->db->single();
            $ID_TRS_Payment = $dataPay['ID_TRS_Payment'];

            if ($ID_TRS_Payment != "") {
                $callback = array(
                    'status' => 'eror',
                    'message' => 'Gagal CheckIn, Karena Status Kamar Sudah Di Payment !',
                );
                return $callback;
                exit;
            }
            //alim
            //Cek
            $this->db->query("SELECT *
            FROM RawatInapSQL.dbo.Inpatient_in_out
            WHERE StatusActive='1' AND ID=:idtrs");
            $this->db->bind('idtrs', $idtrs);
            $data =  $this->db->single();
            if ($data) {
                $callback = array(
                    'status' => "warning",
                    'errorname' => "Kamar Ini Sudah Di Check In!",
                );
                return $callback;
                exit;
            }

            //Cek Jika kamar sudah digunakan
            $this->db->query("SELECT *
            FROM RawatInapSQL.dbo.View_InformasiKamarRI
            WHERE KLSID=:class AND Room=:kamar AND Bad=:bed");
            $this->db->bind('class', $ClassID);
            $this->db->bind('kamar', $RoomName);
            $this->db->bind('bed', $Bed);
            $data =  $this->db->single();
            if ($data) {
                $cekdata = $data['RoomID'];
                //var_dump($cekroom);
                if ($cekdata != '' || $cekdata != null) {
                    $callback = array(
                        'status' => "warning",
                        'errorname' => "Kamar Tersebut Sudah Dalam Posisi Aktif, Silahkan Cari Kamar Lain!",
                        'errormessage' => $cekdata,
                    );
                    return $callback;
                    exit;
                }
            }

            // Update di tabel inpatient_in_out checkout
            $queryUpdatekmr = "UPDATE RawatInapSQL.dbo.Inpatient_in_out SET EndDate=null,TimeEnd=null,StatusActive=1,LamaRawat=null,UserEdit=:operator,DateEdit=:datenowcreate
            WHERE ID=:id_kamar";
            $this->db->query($queryUpdatekmr);
            $this->db->bind('id_kamar', $idtrs);
            $this->db->bind('operator', $operator);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->execute();

            // Update di tabel MstrRoomID active ke 0
            $queryUpdatekmr = " UPDATE MasterdataSQL.dbo.MstrRoomID SET Status=1 WHERE RoomID in (SELECT RoomID
            FROM RawatInapSQL.dbo.Inpatient_in_out
            WHERE ID=:id_kamar)";
            $this->db->query($queryUpdatekmr);
            $this->db->bind('id_kamar', $idtrs);
            $this->db->execute();


            //Insert ke Tz_Log_Button
            $keterangan = 'Checkin Kamar';
            $sqlx = "INSERT INTO  SysLog.dbo.TZ_Log_Button (idtrs,noregistrasi,nama_biling,petugas_batal,tgl_batal) VALUES
                (:idtrs,:noregri,:info,:namauserx,:datenowcreate)";
            $this->db->query($sqlx);
            $this->db->bind('idtrs', $idtrs);
            $this->db->bind('noregri', $noreg);
            $this->db->bind('info', $keterangan);
            $this->db->bind('namauserx', $operator);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->execute();


            //Get kode lokasi dan bridging bpjs----------
            $this->db->query("SELECT KodeLokasi from MasterdataSQL.dbo.MstrRoomID
            WHERE RoomID in (SELECT RoomID
            FROM RawatInapSQL.dbo.Inpatient_in_out
            WHERE ID=:id_kamar)");
            $this->db->bind('id_kamar', $idtrs);
            $data =  $this->db->single();
            $this->UpdateKetersediaanKamarBPJS($data['KodeLokasi']);

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'CheckIn Kamar Berhasil',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function DeleteKamar($data)
    {
        try {
            $this->db->transaksi();

            $datenowcreate = Utils::seCurrentDateTime();

            $idtrs = $data['idtrs'];
            $alasan = $_POST['alasan'];
            //$idtrf = $data['idtrf'];

            //Session user
            $session = SessionManager::getCurrentSession();
            $operator =  $session->name;

            // $userid = $session->username;
            //alim
            $this->db->query("SELECT ID_TRS_Payment from RawatInapSQL.dbo.Inpatient_in_out a
            inner join Billing_Pasien.dbo.FO_T_BILLING_1 b on a.ID = b.KODE_REF
            inner join Billing_Pasien.dbo.FO_T_KASIR c on b.ID_TRS_Payment = c.NO_TRS
            where a.ID = :idtrs-- and a.NoRegRI=:NoRegRI");
            $this->db->bind('idtrs', $idtrs);
            // $this->db->bind('notrsfo312', $notrsfo);
            $dataPay =  $this->db->single();
            $ID_TRS_Payment = $dataPay['ID_TRS_Payment'];

            if ($ID_TRS_Payment != "") {
                $callback = array(
                    'status' => 'eror',
                    'message' => 'Gagal Batal, Karena Status Kamar Sudah Di Payment !',
                );
                return $callback;
                exit;
            }
            //alim

            //Cek
            $this->db->query("SELECT *,replace(CONVERT(VARCHAR(11), StartDate, 111), '/','-') as startdate
            FROM RawatInapSQL.dbo.Inpatient_in_out Where ID=:idtrs");
            $this->db->bind('idtrs', $idtrs);
            $data =  $this->db->single();
            if ($data) {
                $id = $data['ID'];
                $noreg = $data['NoRegRI'];
                $roomid_ext = $data['RoomID'];
                $tgl_startdate = $data['startdate'];
            } else {
                $callback = array(
                    'status' => "warning",
                    'errorname' => "ID Tidak Ditemukan! Data Sudah Dihapus! Silahkan Refresh Halaman!",
                );
                return $callback;
                exit;
            }

            //Insert ke Tz_Log_Button
            $keterangan = 'Hapus Kamar RoomID: ' . $roomid_ext;
            $sqlx = "INSERT INTO  SysLog.dbo.TZ_Log_Button (idtrs,noregistrasi,nama_biling,tgl_entry,petugas_batal,tgl_batal,alasan_batal) VALUES
                (:idtrs,:noregri,:info,:tgl_startdate,:namauserx,:datenowcreate,:alasan)";
            $this->db->query($sqlx);
            $this->db->bind('idtrs', $id);
            $this->db->bind('noregri', $noreg);
            $this->db->bind('info', $keterangan);
            $this->db->bind('namauserx', $operator);
            $this->db->bind('tgl_startdate', $tgl_startdate);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('alasan', $alasan);
            $this->db->execute();

            // Update di tabel MstrRoomID active ke 0
            $queryUpdatekmr = " UPDATE MasterdataSQL.dbo.MstrRoomID SET Status=0 WHERE RoomID in (SELECT RoomID
            FROM RawatInapSQL.dbo.Inpatient_in_out
            WHERE ID=:id_kamar)";
            $this->db->query($queryUpdatekmr);
            $this->db->bind('id_kamar', $idtrs);
            $this->db->execute();

            $this->db->query(" UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 set BATAL=1,PETUGAS_BATAL=:namauser,JAM_BATAL=:datenowcreatex where ID_BILL=:idtrs1");
            $this->db->bind('idtrs1', $idtrs);
            $this->db->bind('namauser', $operator);
            $this->db->bind('datenowcreatex', $datenowcreate);
            $this->db->execute();

            $this->db->query(" UPDATE Billing_Pasien.dbo.FO_T_BILLING_2 set BATAL=1,PETUGAS_BATAL=:namauser,JAM_BATAL=:datenowcreatex where ID_BILL=:idtrs1");
            $this->db->bind('idtrs1', $idtrs);
            $this->db->bind('namauser', $operator);
            $this->db->bind('datenowcreatex', $datenowcreate);
            $this->db->execute();

            $this->db->query("SELECT b.NO_REGISTRASI FROM Billing_Pasien.dbo.FO_T_BILLING_1 a
            inner join Billing_Pasien.dbo.FO_T_BILLING b on a.NO_REGISTRASI = b.NO_REGISTRASI where ID_BILL = :idtrs");
            $this->db->bind('idtrs', $idtrs);
            $datareg =  $this->db->single();
            // $idtrs2 = $dataacc['ID'];
            $reg = $datareg['NO_REGISTRASI'];

            $this->db->query(" UPDATE Billing_Pasien.dbo.FO_T_BILLING set BATAL=1,PETUGAS_BATAL=:namauser,JAM_BATAL=:datenowcreatex,ALASAN_BATAL=:alasan where NO_REGISTRASI=:noreg");
            $this->db->bind('noreg', $reg);
            $this->db->bind('namauser', $operator);
            $this->db->bind('datenowcreatex', $datenowcreate);
            $this->db->bind('alasan', $alasan);
            $this->db->execute();

            /*
            if($idtrf<>'' || $idtrf <> null){
                // set order pindah kamar jadi sudah di eksekusi / 1
                 $queryUpdateReq = "UPDATE MedicalRecord.dbo.MR_TransferPasien 
                                     SET StatusTransfer=:batal
                                     where ID=:idtrf";
                 $this->db->query($queryUpdateReq); 
                 $this->db->bind('idtrf', $idtrf); 
                 $this->db->bind('batal', '0'); 
                 $this->db->execute();
             }
             */

            // delete Inpatient in dan out
            $qdelInpatientinout = "DELETE RawatInapSQL.dbo.Inpatient_in_out WHERE ID=:idtrs";
            $this->db->query($qdelInpatientinout);
            $this->db->bind('idtrs', $idtrs);
            $this->db->execute();

            //Cek Ada di field Awal atau Akhir di tabel Inpatient
            $sql = "SELECT *
             FROM RawatInapSQL.dbo.Inpatient_in_out
             WHERE NoRegRI=:noreg";
            $this->db->query($sql);
            $this->db->bind("noreg", $noreg);
            $this->db->execute();
            $getData = $this->db->resultSet();
            $productCount = count($getData);

            //Get kode lokasi dan bridging bpjs----------
            $this->db->query("SELECT KodeLokasi from MasterdataSQL.dbo.MstrRoomID
            WHERE RoomID=:roomid");
            $this->db->bind('roomid', $roomid_ext);
            $data =  $this->db->single();
            $this->UpdateKetersediaanKamarBPJS($data['KodeLokasi']);

            if ($productCount == 0) {
                //null in jika di tabel inpatient_in_out no row
                $query = "UPDATE RawatInapSQL.dbo.Inpatient 
                                            SET RoomID_Awal=Null,RoomID_Akhir=Null,KelasID_Awal=Null,KelasID_Akhir=Null WHERE NoRegRI=:noreg";
                $this->db->query($query);
                $this->db->bind('noreg', $noreg);
                $this->db->execute();
            } else {

                //Cek Ada di field Awal atau Akhir di tabel Inpatient
                $query = "SELECT *
              FROM RawatInapSQL.dbo.Inpatient
              WHERE NoRegRI=:noreg and RoomID_Awal=:idinout";
                $this->db->query($query);
                $this->db->bind("noreg", $noreg);
                $this->db->bind("idinout", $id);
                $this->db->execute();
                $getData = $this->db->resultSet();
                $productCount = count($getData);

                if ($productCount > 0) {
                    //Get Data di tabel inpatient_in_out
                    $sql = "SELECT MIN(ID) as ID,IDKelas
                    FROM RawatInapSQL.dbo.Inpatient_in_out where NoRegRI=:noreg
                    group by ID,IDKelas
                    order by 1 desc";
                    $this->db->query($sql);
                    $this->db->bind("noreg", $noreg);
                    $data =  $this->db->single();
                    $idinout_new = $data['ID'];
                    $IDKelas_new = $data['IDKelas'];

                    //Update di field RoomID_Awal
                    $sql = "UPDATE RawatInapSQL.dbo.Inpatient 
                    SET RoomID_Awal=:idinout_new,KelasID_Awal=:idkelas WHERE NoRegRI=:noreg";
                    $this->db->query($sql);
                    $this->db->bind("noreg", $noreg);
                    $this->db->bind("idkelas", $IDKelas_new);
                    $this->db->bind("idinout_new", $idinout_new);
                    $this->db->execute();
                } else {
                    //Cek Ada di field Awal atau Akhir di tabel Inpatient
                    $sql = "SELECT *
                    FROM RawatInapSQL.dbo.Inpatient
                    WHERE NoRegRI=:noreg and RoomID_Akhir=:idinout";
                    $this->db->query($sql);
                    $this->db->bind("noreg", $noreg);
                    $this->db->bind("idinout", $id);
                    $this->db->execute();
                    $getData = $this->db->resultSet();
                    $productCount = count($getData);

                    if ($productCount > 0) {
                        $sql = "SELECT TOP 1 MAX(ID) as ID,IDKelas
                    FROM RawatInapSQL.dbo.Inpatient_in_out  where NoRegRI=:noreg
                    group by ID,IDKelas
                    order by 1 desc";
                        $this->db->query($sql);
                        $this->db->bind("noreg", $noreg);
                        $this->db->execute();
                        $data =  $this->db->single();
                        $idinout_new = $data['ID'];
                        $IDKelas_new = $data['IDKelas'];

                        // set kelas di tabel inpatient
                        $queryUpdateKelas = "UPDATE RawatInapSQL.dbo.Inpatient 
                                                SET KlsID=:idkelas,RoomID_Akhir=:idinout_new,KelasID_Akhir=:idkelas2 WHERE NoRegRI=:noreg";
                        $this->db->query($queryUpdateKelas);
                        $this->db->bind('idkelas', $IDKelas_new);
                        $this->db->bind('idkelas2', $IDKelas_new);
                        $this->db->bind('noreg', $noreg);
                        $this->db->bind('idinout_new', $idinout_new);
                        $this->db->execute();
                    }
                }
            }

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Berhasil Hapus Kamar',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function CekRowData($data)
    {
        try {
            $idtrs = $data['idtrs'];
            //Cek
            $this->db->query("SELECT *,replace(CONVERT(VARCHAR(11), StartDate, 111), '/','-') as startdate
            FROM RawatInapSQL.dbo.Inpatient_in_out Where ID=:idtrs");
            $this->db->bind('idtrs', $idtrs);
            $data =  $this->db->single();

            if ($data === false) {
                $callback = array(
                    'status' => "warning",
                    'errorname' => "ID Tidak Ditemukan! Data Sudah Dihapus! Silahkan Refresh Halaman!",
                );
                return $callback;
                exit;
            }

            $callback = array(
                'status' => "success", // Set array nama  
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    function UpdateKetersediaanKamarBPJS($data)
    {
        $kodelokasi = $data;

        //get obat detail
        $this->db->query("SELECT   x.KLSID,x.Class,kapasitas as Jumlah,
                        sum(isnull(x.terpakai,0) ) as terpakai,sum(isnull(x.sisa,0) ) as tersedia,KodeLokasi,Room,KdKlsBPJS
                        from (
                        SELECT  a.KLSID,a.Class,b.BED as kapasitas, CASE WHEN a.status=0 THEN COUNT(status) END AS sisa,
                        CASE WHEN a.status=1 THEN COUNT(status) END AS terpakai,a.kodelokasi,a.Room,a.KdKlsBPJS,a.publish
                        FROM RawatInapSQL.dbo.View_InformasiKamarRI a
                        inner join MasterdataSQL.dbo.MstrROOM b
                        on b.ROOM_ID = a.kodelokasi 
                        where a.KodeLokasi=:kodelokasi and a.publish='1'
                        GROUP BY a.Class,a.status,a.KLSID,a.kodelokasi,a.Room,a.KdKlsBPJS,b.BED ,a.publish
                        ) x 
                        group by KLSID,Class,kapasitas,KodeLokasi,Room,KdKlsBPJS
                        order by x.Class asc");
        $this->db->bind('kodelokasi', $kodelokasi);
        $data =  $this->db->single();

        $kapasitas = $data['Jumlah'];
        $terpakai = $data['terpakai'];
        $tersedia = $data['tersedia'];
        $KdKlsBPJS = $data['KdKlsBPJS'];
        $kodelokasi = $data['KodeLokasi'];
        $Room = $data['Room'];

        // persiapkan curl
        $curl = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);

        $postdata = '
        { "kodekelas":"' . $KdKlsBPJS . '", 
            "koderuang":"' . $kodelokasi . '", 
            "namaruang":"' . $Room . '", 
            "kapasitas":"' . $kapasitas . '", 
            "tersedia":"' . $tersedia . '",
            "tersediapria":"0", 
            "tersediawanita":"0", 
            "tersediapriawanita":"0"
        } ';


        curl_setopt($curl, CURLOPT_URL, "https://new-api.bpjs-kesehatan.go.id/aplicaresws/rest/bed/update/0114R067");
        // set header
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headerbpjs);
        // set time out
        curl_setopt($curl, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        // data yang dikirim
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
        // return the transfer as a string 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 

        $output = curl_exec($curl);
        // tutup curl 
        curl_close($curl);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "1") {
            // $EncodeData = json_encode($JsonData);
            // $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, Utils::setKey());
            $callback = array(
                'status' => 'success',
                'errorname' => $JsonData['metaData']['message']

            );
            // return $ResultEncriptLzString;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']

            );
        }
        return $callback;
    }

    public function getListCleaningRoom($data)
    {
        try {
            $Lantai = $data['Lantai'];
            $this->db->query("SELECT b.RoomID,b.Class,b.Room,b.Bad,b.TarifKamar,'CLEANING' as Status from MasterdataSQL.dbo.MstrROOM a
            inner join MasterdataSQL.dbo.MstrRoomID b on a.ROOM_ID=b.KodeLokasi
            where a.LANTAI=:Lantai and b.Dsicontinue='0' and Status='3'
            ");
            $this->db->bind('Lantai', $Lantai);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['RoomID'] = $key['RoomID'];
                $pasing['Class'] = $key['Class'];
                $pasing['Room'] = $key['Room'];
                $pasing['Bad'] = $key['Bad'];
                $pasing['TarifKamar'] = $key['TarifKamar'];
                $pasing['Status'] = $key['Status'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function updateReady($data)
    {
        try {
            $roomid = $data['roomid'];
            //Cek
            $this->db->query("SELECT Status
            FROM MasterdataSQL.dbo.MstrRoomID Where RoomID=:roomid");
            $this->db->bind('roomid', $roomid);
            $data =  $this->db->single();

            if ($data['Status'] != '3') {
                $callback = array(
                    'status' => "warning",
                    'errorname' => "Kamar tersebut tidak dalam kondisi status cleaning! Silahkan dicek kembali!",
                );
                return $callback;
                exit;
            }

            $qupdate = "UPDATE MasterdataSQL.dbo.MstrRoomID
                                                        SET Status='0'
                                                        WHERE RoomID=:roomid";
                    $this->db->query($qupdate);
                    $this->db->bind('roomid', $roomid);
                    $this->db->execute();

            $callback = array(
                'status' => "success", 
                'message' => "Kamar berhasil diperbarui!", 
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function updateReadySelected($data)
    {
        try {
            $this->db->transaksi();
            $tod = json_decode(json_encode((object) $data['idorderapprove']), FALSE);
            foreach ($tod as $data) {

                $roomid = $data;

                //Cek
                $this->db->query("SELECT Status
                FROM MasterdataSQL.dbo.MstrRoomID Where RoomID=:roomid");
                $this->db->bind('roomid', $roomid);
                $data =  $this->db->single();

                if ($data['Status'] != '3') {
                    $callback = array(
                        'status' => "warning",
                        'errorname' => "Kamar ID: ".$roomid." tidak dalam kondisi status cleaning! Silahkan dicek kembali!",
                    );
                    return $callback;
                    exit;
                }

                
            $qupdate = "UPDATE MasterdataSQL.dbo.MstrRoomID
                            SET Status='0'
                            WHERE RoomID=:roomid";
                $this->db->query($qupdate);
                $this->db->bind('roomid', $roomid);
                $this->db->execute();

            }
            
            $this->db->commit();

            $callback = array(
                'status' => "success", 
                'message' => "Kamar yang dpilih berhasil diperbarui!", 
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function CreateTrsNew($data)
    {
        try {
            $this->db->transaksi();
            $datenowcreate = Utils::seCurrentDateTime();

            //Deklarasi Variable
            $kodebooking = $data['kodebooking'];
            $idtrs = $data['IdAuto'];
            $noreg = $data['NoRegistrasi'];
            $classname = $data['classname'];
            $ClassID = $data['classid'];
            $roomname = $data['roomname'];
            $roomid = $data['roomid'];
            $bedname = $data['bedname'];
            $bedid = $data['bedid'];
            $TarifKamar = $data['TarifKamar'];
            $TarifKamar = 0;
            $tgl_masuk = $data['TglMasuk'];
            $jam_masuk = $data['JamMasuk'];
            $jam_masuk_fix = date('Y-m-d H:i:s', strtotime("$tgl_masuk $jam_masuk"));
            $jam_masuk_fix2 = date('Y-m-d ', strtotime("$tgl_masuk"));

            $jam_masuk_fix1 = date('dmy', strtotime("$tgl_masuk"));
            // var_dump($jam_masuk_fix, $jam_masuk_fix1);
            // exit;
            //$RoomID = $data['RoomID'];
            $idtrf = $data['idtrf'];
            $GroupJaminan = $data['GroupJaminan'];
            $nomr_validasi = $data['nomr_pass'];
            

            $isactive = '1';
            $noactive = '0';
            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $namauserx = $session->name;

            //Session user
            $session = SessionManager::getCurrentSession();
            $userid =  $session->IDEmployee;

            // Cek Data
            if ($ClassID == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Pilih Kelas !',
                );
                return $callback;
                exit;
            }

            if ($roomid == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Pilih Kamar !',
                );
                return $callback;
                exit;
            }

            if ($bedid == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Pilih Bed !',
                );
                return $callback;
                exit;
            }

            // if ($RoomID == "") {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => 'Kamar Tersebut Sudah Expired atau Tidak Ada Di Database ! Silahkan Pilih Kamar Lain',
            //     );
            //     return $callback;
            //     exit;
            // }

            $this->db->query("SELECT *
            FROM MasterdataSQL.dbo.MstrRoomID
            WHERE RoomID=:bedid");
            $this->db->bind('bedid', $bedid);
            $data_mstr =  $this->db->single();
            

            /*
            //CEK ORDER PINDAH KAMAR SUDAH DI PAKAI BELUM
            $sql = "SELECT *from MedicalRecord.dbo.MR_TransferPasien
            where id=:idtrf and StatusTransfer=:isactive";
            $this->db->query($sql);
            $this->db->bind("idtrf", $idtrf);
            $this->db->bind("isactive", $isactive);
            $this->db->execute();
            $getData = $this->db->resultSet();  
            $productCount = count($getData);
            if($productCount > 0)  
            {
                $callback = array(
                              'status' => 'warning',
                              'errorname' => "Order Perpindahan Kamar sudah di Proses, silahkan refresh Halaman Order List permintaan Kamar dan Form Kamar Anda !",
                            );
                  echo json_encode($callback);
                  exit;
            }  
            */

            $titipan = $data['Titipan'];

            if ($titipan == '1') {
                $idkelas_titipan = $data['ClassID_Titipan'];
                if (isset($data['NamaKamar_Titipan'])) {
                    $roomname_titipan = $data['NamaKamar_Titipan'];
                } else {
                    $roomname_titipan = '';
                }
                if (isset($data['BedKamar_Titipan'])) {
                    $bed_titipan = $data['BedKamar_Titipan'];
                } else {
                    $bed_titipan = '';
                }
                $tarif_titipan = $data['TarifKamar_Titipan'];
                $roomid_titipan = $data['RoomID_Titipan'];

                if ($idkelas_titipan == '') {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Silahkan Pilih Kelas Titipan!',
                    );
                    echo json_encode($callback);
                    exit;
                }

                if ($roomname_titipan == '') {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Silahkan Pilih Kamar Titipan!',
                    );
                    echo json_encode($callback);
                    exit;
                }

                if ($bed_titipan == '') {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Silahkan Pilih Bed Titipan!',
                    );
                    echo json_encode($callback);
                    exit;
                }

                if ($roomid_titipan == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Kamar Titipan Tersebut Sudah Expired atau Tidak Ada Di Database ! Silahkan Pilih Kamar Lain',
                    );
                    return $callback;
                    exit;
                }

                //Cek Jika Jaminan BPJS harus kamar bpjs
                if ($GroupJaminan == 'BS') {
                    $this->db->query("SELECT *
                FROM MasterdataSQL.dbo.MstrRoomID
                WHERE Publish='0' and KLSID=:class AND Room=:kamar AND Bad=:bed");
                    $this->db->bind('class', $idkelas_titipan);
                    $this->db->bind('kamar', $roomname_titipan);
                    $this->db->bind('bed', $bed_titipan);
                    $data =  $this->db->single();
                    if ($data) {
                        $callback = array(
                            'status' => "warning",
                            'errorname' => "Pasien Tersebut Adalah Jaminan BPJS, Silahkan Pilih Kamar Yang Terintegrasi Dengan BPJS !",
                        );
                        return $callback;
                        exit;
                    }
                }

                $idkelas_ext = $idkelas_titipan;
            } else {
                $idkelas_titipan = null;
                $roomname_titipan = null;
                $bed_titipan = null;
                $tarif_titipan = null;
                $roomid_titipan = null;
                $idkelas_ext = $ClassID;
            }

            
            $this->db->query("SELECT *
            FROM MasterdataSQL.dbo.MstrRoomID
            WHERE RoomID=:bedid");
            $this->db->bind('bedid', $bedid);
            $data_trs =  $this->db->single();

            //Cek Jika Jaminan BPJS harus kamar bpjs
            if ($GroupJaminan == 'BS') {
                if ($data_trs['Publish'] == '0') {
                    $callback = array(
                        'status' => "warning",
                        'errorname' => "Pasien Tersebut Adalah Jaminan BPJS, Silahkan Pilih Kamar Yang Terintegrasi Dengan BPJS !",
                    );
                    return $callback;
                    exit;
                }
            }


            //Get Nama Kelas
            // $this->db->query("SELECT NamaKelas From RawatInapSQL.dbo.TblKelas where IDkelas=:class ");
            // $this->db->bind('class', $ClassID);
            // $data =  $this->db->single();
            // $NamaKelas = $data['NamaKelas'];

            // //Cek Jika kamar sudah digunakan
            // $this->db->query("SELECT *
            // FROM RawatInapSQL.dbo.View_InformasiKamarRI
            // WHERE KLSID=:class AND Room=:kamar AND Bad=:bed
            // and NoMR not in (select NoMR from RawatInapSQL.dbo.Inpatient where NoRegRI=:noreg)");
            // $this->db->bind('class', $ClassID);
            // $this->db->bind('kamar', $RoomName);
            // $this->db->bind('bed', $Bed);
            // $this->db->bind('noreg', $noreg);
            // $data =  $this->db->single();
            //var_dump($data['RoomID']);exit;
                if ($data_trs['Status'] == '1') {
                    $callback = array(
                        'status' => "warning",
                        'errorname' => "Kamar Tersebut Tidak Tersedia! Silahkan Cari Kamar Lain!",
                        'errormessage' => $bedid,
                    );
                    return $callback;
                    exit;
                }

             //Cek Jika kamar dibooking atau tidak
             $this->db->query("SELECT count(ID) as cekbooking
             FROM RawatInapSQL.dbo.BookingBeds
             where transactioncode=:kodebooking
             ");
             $this->db->bind('kodebooking', $kodebooking);
             $datafx=  $this->db->single();
             $cekbooking = $datafx['cekbooking'];
             //var_dump($datafx['cekbooking']);exit;

             if ($cekbooking < 1){
                        if ($data_mstr['Status'] == '2') {
                                $callback = array(
                                    'status' => "warning",
                                    'errorname' => "Kamar tersebut sudah dibooking !",
                                );
                                return $callback;
                                exit;
                        }

                        if ($data_mstr['Status'] == '3') {
                                $callback = array(
                                    'status' => "warning",
                                    'errorname' => "Kamar tersebut sedang dibersihkan ruangannya (cleaning) !",
                                );
                                return $callback;
                                exit;
                        }
                            // $callback = array(
                            //     'status' => "warning",
                            //     'errorname' => "Kamar tersebut tidak tersedia !",
                            // );
                            // return $callback;
                            // exit;
                 }
                 //var_dump('ddddxx');exit;

            if ($idtrs == '' || $idtrs == null) { // jika idtrs null maka create new


                //Cek Jika ada kamar yang aktif di no registrasi ini
                $this->db->query("SELECT *
                FROM RawatInapSQL.dbo.Inpatient_in_out
                WHERE StatusActive=:isactive AND NoRegRI=:noreg");
                $this->db->bind('noreg', $noreg);
                $this->db->bind('isactive', $isactive);
                $data =  $this->db->single();
                if ($data) {
                    $dataidregfieedback = $data['NoRegRI'];
                    $callback = array(
                        'status' => "warning",
                        'errorname' => "Nomor Registrasi Ini Masih Mempunyai Kamar Yang Aktif, Silahkan Checkout Terlebih Dahulu Kamar Yang Aktif!",
                        'errormessage' => $dataidregfieedback,
                    );
                    return $callback;
                    exit;
                }

                //Insert/update transaction
                // INSERT INPATIENT
                $sqlx = " INSERT INTO RawatInapSQL.dbo.Inpatient_in_out ( 
                NoRegRI,RoomID,IDKelas,Class,RoomName,Bed,Tarif,
                StartDate,TimeStart,StatusActive,Disc,Titipan,RoomID_Titipan,IDKelas_Titipan,RoomName_Titipan,Bed_Titipan,Tarif_Titipan) VALUES
                (:noreg,:roomid,:idkelas,:class,:kamar,:bed,:tarif,
                :tgl_masuk,:jam_masuk_fix,:isactive,:discount,:titipan,:roomid_titipan,:idkelas_titipan,:roomname_titipan,:bed_titipan,:tarif_titipan)";
                $this->db->query($sqlx);
                $this->db->bind('noreg', $noreg);
                $this->db->bind('roomid', $bedid);
                $this->db->bind('idkelas', $ClassID);
                $this->db->bind('class', $classname);
                $this->db->bind('kamar', $roomname);
                $this->db->bind('bed', $bedname);
                $this->db->bind('tarif', $TarifKamar);
                $this->db->bind('tgl_masuk', $tgl_masuk);
                $this->db->bind('jam_masuk_fix', $jam_masuk_fix);
                $this->db->bind('isactive', $isactive);
                $this->db->bind('discount', '0');
                $this->db->bind('titipan', $titipan);
                $this->db->bind('roomid_titipan', $roomid_titipan);
                $this->db->bind('idkelas_titipan', $idkelas_titipan);
                $this->db->bind('roomname_titipan', $roomname_titipan);
                $this->db->bind('bed_titipan', $bed_titipan);
                $this->db->bind('tarif_titipan', $tarif_titipan);
                $this->db->execute();
                $id_inpatientinout_max = $this->db->GetLastID();
                //var_dump($id_inpatientinout_max);exit;


                // set status room jadi terpakai
                $queryUpdateRoom = "UPDATE MasterdataSQL.dbo.MstrRoomID 
              SET Status=:isactive WHERE RoomID=:roomid";
                $this->db->query($queryUpdateRoom);
                $this->db->bind('isactive', $isactive);
                $this->db->bind('roomid', $bedid);
                $this->db->execute();


                /*
                // GET MAX ID INpatient_in_out----------------------------------
                $sql = "SELECT MAX(ID) as ID
                FROM RawatInapSQL.dbo.Inpatient_in_out
                WHERE NoRegRI=:noreg ";
                   $this->db->query($sql);
                   $this->db->bind("noreg", $noreg);
                   $data =  $this->db->single();
                   $id_inpatientinout_max = $data['ID'];
                   */

                $this->db->query("SELECT  TOP 1 NO_TRS_BILLING,right( REPLACE(NO_TRS_BILLING,'-','0')  ,5) as urut FROM Billing_Pasien.dbo.FO_T_BILLING  WHERE replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-')=:datenow2  ORDER BY urut DESC");
                $this->db->bind('datenow2', $jam_masuk_fix2);
                $datax =  $this->db->single();
                //no urut reg
                $nexturut = $datax['urut'];
                $nexturut++;

                $nourutfix = Utils::generateAutoNumber($nexturut);
                $kodeawal = "BIL";
                $notrsbill = $kodeawal . $jam_masuk_fix1 . $nourutfix;

                // $this->db->query("SELECT [Order ID] as orderid FROM [Apotik_V1.1SQL].dbo.[Order Details] WHERE [Order ID] = :dataOrderid");
                // $this->db->bind('dataOrderid', $dataaptk);
                // $datafo =  $this->db->single();
                // $dataaccnumber = $datafo['orderid'];

                $this->db->query("SELECT COUNT(*) as FOBILLING1 FROM Billing_Pasien.dbo.FO_T_BILLING_1 WHERE ID_BILL = :dataKamar");
                $this->db->bind('dataKamar', $id_inpatientinout_max);
                $datafo =  $this->db->single();
                $datafoo = $datafo['FOBILLING1'];

                if ($datafoo == "0") {
                    //get data Inpatient
                    $this->db->query("SELECT a.NoMR,a.NoEpisode,b.ID, a.TypePatient, case when a.TypePatient='2' then a.IDAsuransi else a.IDJPK end as perusahaanid, a.KlsID
                           FROM RawatInapSQL.dbo.Inpatient a 
                           INNER JOIN MasterdataSQL.dbo.MstrUnitPerwatan b ON b.NamaUnit = a.JenisRawat
                           WHERE NoRegRI = :NoRegistrasi");
                    $this->db->bind('NoRegistrasi', $noreg);
                    $datax =  $this->db->single();
                    $IdGrupPerawatan = $datax['ID'];
                    $JenisBayar = $datax['TypePatient'];
                    $perusahaanid = $datax['perusahaanid'];
                    $dataa = $datax['NoMR'];
                    $dataaa = $datax['NoEpisode'];
                    $datakelas = $datax['KlsID'];


                    // insert ke tabel FO_T_Billing
                    $this->db->query("INSERT INTO Billing_Pasien.dbo.FO_T_BILLING
                       ([NO_TRS_BILLING],[TGL_BILLING],[PETUGAS_ENTRY],[NO_MR],[NO_EPISODE],[NO_REGISTRASI],[UNIT],[GROUP_JAMINAN],[KODE_JAMINAN],[TOTAL_TARIF],[TOTAL_QTY],[SUBTOTAL],[TOTAL_DISCOUNT],[TOTAL_DISCOUNT_RP],[SUBTOTAL_2],[GRANDTOTAL],[BATAL],[FB_CLOSE_KEUANGAN],[FB_VERIF_JURNAL]) 
                       VALUES
                       (:notrsbill,:datenowx,:namauserx,:NoMrfix,:NoEpisode,:nofixReg,:IdGrupPerawatan,:JenisBayar,:perusahaanid,:totaltarif,:totalqty,:subtotal,:totaldiscount,:totaldiscountrp,:subtotal2,:grandtotal,:batal,:closekeuangan,:verifkeuangan)");

                    $this->db->bind('notrsbill', $notrsbill);
                    $this->db->bind('datenowx', $jam_masuk_fix);
                    $this->db->bind('namauserx', $namauserx);
                    $this->db->bind('NoMrfix', $dataa);
                    $this->db->bind('NoEpisode', $dataaa);
                    $this->db->bind('nofixReg', $noreg);
                    $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                    $this->db->bind('JenisBayar', $JenisBayar);
                    $this->db->bind('perusahaanid', $perusahaanid);
                    $this->db->bind('totaltarif', $TarifKamar);
                    $this->db->bind('totalqty', 0);
                    $this->db->bind('subtotal', 0);
                    $this->db->bind('totaldiscount', 0);
                    $this->db->bind('totaldiscountrp', 0);
                    $this->db->bind('subtotal2', 0);
                    $this->db->bind('grandtotal', 0);
                    $this->db->bind('batal', 0);
                    $this->db->bind('closekeuangan', 0);
                    $this->db->bind('verifkeuangan', 0);
                    $this->db->execute();

                    $this->db->query("SELECT ID,RoomID, RoomName,drPenerima,a.Tarif FROM RawatInapSQL.dbo.Inpatient_in_out a
                    inner join RawatInapSQL.dbo.Inpatient b on a.NoRegRI=b.NoRegRI where ID = :idkamar");
                    $this->db->bind('idkamar', $id_inpatientinout_max);
                    $dataacc =  $this->db->single();
                    // $idtrs2 = $dataacc['ID'];
                    $Kode_Tarif = $dataacc['RoomID'];
                    $Nama_Tarif = $dataacc['RoomName'];
                    $drPenerima = $dataacc['drPenerima'];
                    $Tarif_Servis = $dataacc['Tarif'];


                    $this->db->query("SELECT jumlah,LamaRawat from RawatInapSQL.dbo.View_LamaRawat where NoRegRI=:NOREG");
                    $this->db->bind('NOREG', $noreg);
                    $datajmlh =  $this->db->single();
                    // $idtrs2 = $dataacc['ID'];
                    $Jmlh = $datajmlh['jumlah'];
                    $Qty = $datajmlh['LamaRawat'];

                    // var_dump($Tarif_Servis);
                    // exit;

                    $this->db->query("SELECT TypePatient FROM RawatInapSQL.dbo.Inpatient WHERE NoRegRI = :NOREG2121");
                    $this->db->bind('NOREG2121', $noreg);
                    $datagrjaminan =  $this->db->single();
                    // $idtrs2 = $dataacc['ID'];
                    $groupjaminan1 = $datagrjaminan['TypePatient'];

                    // if ($groupjaminan1 == "1") {
                    //     $kekurangan = $Jmlh;
                    //     $klaim = "0";
                    //     $bayar = "0";
                    // } else {
                    //     $kekurangan = "0";
                    //     $klaim = $Jmlh;
                    //     $bayar = "0";
                    // }
                    if ($GroupJaminan == 'UM') {
                        $kekurangan = $Jmlh;
                        $klaim = "0";
                        $bayar = "0";
                    } else {
                        $kekurangan = "0";
                        $klaim = $Jmlh;
                        $bayar = "0";
                    }
                    // insert ke tabel FO_T_Billing_1
                    // select Radiologi
                    $this->db->query("INSERT INTO  Billing_Pasien.dbo.FO_T_BILLING_1
                    (ID_BILL,[NO_TRS_BILLING],[TGL_BILLING] ,[PETUGAS_ENTRY],[NO_MR],[NO_EPISODE],[NO_REGISTRASI],[KODE_TARIF],[UNIT],[GROUP_JAMINAN],[KODE_JAMINAN],
                    [NAMA_TARIF],[GROUP_TARIF],[KD_KELAS],[QTY],[NILAI_TARIF],[SUB_TOTAL],[DISC],[DISC_RP],[SUB_TOTAL_2],[GRANDTOTAL],[KODE_REF],[KD_DR],[NM_DR],
                    [BATAL],[PETUGAS_BATAL],[GROUP_ENTRI],[BAYAR],[KLAIM],[KEKURANGAN])
                    SELECT '$id_inpatientinout_max','$notrsbill' , '$jam_masuk_fix' as datenow,'$namauserx' as namauserx,'$dataa' AS NoMR, '$dataaa' AS xNoEpisode,'$noreg' as NoReg,:Kode_Tarif as kodetarif,
                    UNIT,GROUP_JAMINAN,KODE_JAMINAN, :Nama_Tarif as namatarif,'Kamar' as rad, :kdkelas, 1 as Qty, :Nilai as nilai, :Nilai2 as nilai2, 0, 
                    0, :Nilai3 as nilai3, :Nilai4 as nilai4,'$id_inpatientinout_max', :drPenerima, null as namadokter, 0 as batal,null as petugasbatal,'KAMAR',$bayar,$klaim,$kekurangan
                    FROM Billing_Pasien.dbo.FO_T_BILLING
                    WHERE NO_TRS_BILLING=:notrsbill AND Batal='0'");
                    $this->db->bind('notrsbill', $notrsbill);
                    $this->db->bind('Kode_Tarif', $Kode_Tarif);
                    $this->db->bind('Nama_Tarif', $Nama_Tarif);
                    $this->db->bind('Nilai',  $Tarif_Servis);
                    $this->db->bind('Nilai2', $Tarif_Servis);
                    $this->db->bind('Nilai3', $Tarif_Servis);
                    $this->db->bind('Nilai4', $Tarif_Servis);
                    $this->db->bind('drPenerima', $drPenerima);
                    $this->db->bind('kdkelas', $datakelas);

                    $this->db->execute();
                    // var_dump($notrsbill);
                    // exit;
                    $this->db->query("INSERT INTO Billing_Pasien.DBO.FO_T_BILLING_2
                    SELECT '$id_inpatientinout_max',A.NO_TRS_BILLING AS NO_TRS_BILLING,A1.KODE_TARIF,B.KD_TIPE_PDP as Kode_komponen,A1.UNIT AS UNIT, 
                    A1.GROUP_JAMINAN AS GROUP_JAMINAN, A1.KODE_JAMINAN AS KODE_JAMINAN, A1.NAMA_TARIF AS NAMA_TARIF, A1.GROUP_TARIF AS GROUP_TARIF,
                    A1.KD_KELAS as KELAS,A1.QTY AS QTY, A1.NILAI_TARIF AS NILAI_TARIF , A1.NILAI_TARIF*A1.QTY  AS SUBTOTAL,A1.DISC AS DISC,
                    0 AS DISC_RP,((A1.NILAI_TARIF*A1.QTY)-(((A1.NILAI_TARIF*A1.QTY)*A1.DISC)/100)) SUB_TOTAL_PDP_2,
                    (CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN ((((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' THEN 
                    ((b.NILAI_FIX*A1.QTY*DISC)/100)*A1.QTY END ) NILAI_DISKON_PDP,(CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN 
                    (((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY)-(((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' 
                    THEN (b.NILAI_FIX*A1.QTY)-((b.NILAI_FIX*A1.QTY*DISC)/100)*A1.QTY END ) as NILAI_PDP,A1.KD_DR AS KD_DR, '' NM_DR,b.NILAI_PROSEN,'0' AS BATAL,
                    '' PETUGAS_BATAL, '' AS JAM_BATAL, B.KD_POSTING AS KD_POSTING,'' as kd_posting_diskon, 0 as ID_TR_TARIF_PAKET
                    FROM Billing_Pasien.DBO.FO_T_BILLING A
                    inner join Billing_Pasien.dbo.FO_T_BILLING_1 A1 ON A.NO_TRS_BILLING = A1.NO_TRS_BILLING
                    INNER JOIN MasterdataSQL.dbo.MstrRoomID CC ON CC.RoomID = A1.KODE_TARIF 
                    INNER JOIN Keuangan.DBO.BO_M_PDP2 B ON CC.KD_PDP collate SQL_Latin1_General_CP1_CI_AS = B.KD_PDP collate SQL_Latin1_General_CP1_CI_AS
                    INNER JOIN Keuangan.DBO.BO_M_PDP CX ON CX.KD_PDP = B.KD_PDP
                    WHERE a.NO_TRS_BILLING=:notrsbill2");
                    $this->db->bind('notrsbill2', $notrsbill);
                    $this->db->execute();
                }

                // CEK field RoomID_Awal ada gak
                $sql = "SELECT *
                        FROM RawatInapSQL.dbo.Inpatient
                        WHERE NoRegRI=:noreg and RoomID_Awal is not null";
                $this->db->query($sql);
                $this->db->bind("noreg", $noreg);
                $this->db->execute();
                $getData = $this->db->resultSet();
                $productCount = count($getData);

                if ($productCount > 0) {
                    // set kelas di tabel inpatient
                    $queryUpdateKelas = "UPDATE RawatInapSQL.dbo.Inpatient 
                                                    SET KlsID=:idkelas,RoomID_Akhir=:roomid,KelasID_Akhir=:idkelas2 
                                                    WHERE NoRegRI=:noreg";
                } else {
                    // set kelas di tabel inpatient
                    $queryUpdateKelas = "UPDATE RawatInapSQL.dbo.Inpatient 
                                                    SET KlsID=:idkelas,RoomID_Awal=:roomid,KelasID_Awal=:idkelas2 
                                                    WHERE NoRegRI=:noreg";
                }
                $this->db->query($queryUpdateKelas);
                $this->db->bind('idkelas', $idkelas_ext);
                $this->db->bind('idkelas2', $idkelas_ext);
                $this->db->bind('noreg', $noreg);
                $this->db->bind('roomid', $id_inpatientinout_max);
                $this->db->execute();

                //update di bookingbeds
                if ($kodebooking != ''){
                    $bookingbeds = "UPDATE RawatInapSQL.dbo.BookingBeds
                                                        SET idinpatientinout=:id_inpatientinout_max,bookingstatus='1'
                                                        WHERE transactioncode=:kodebooking";
                    $this->db->query($bookingbeds);
                    $this->db->bind('id_inpatientinout_max', $id_inpatientinout_max);
                    $this->db->bind('kodebooking', $kodebooking);
                    $this->db->execute();

                    if ($nomr_validasi != ''){
                        $updatenomr = "UPDATE RawatInapSQL.dbo.BookingBeds
                                                        SET medicalrecordnumber=:nomr_validasi
                                                        WHERE transactioncode=:kodebooking";
                        $this->db->query($updatenomr);
                        $this->db->bind('kodebooking', $kodebooking);
                        $this->db->bind('nomr_validasi', $nomr_validasi);
                        $this->db->execute();
                    }

                }

                //pesan return
                $return_message = 'Simpan & Check In Kamar Berhasil Dilakukan!';

                // //Get kode lokasi----------
                // $this->db->query("SELECT KodeLokasi from MasterdataSQL.dbo.MstrRoomID
                //     WHERE KLSID=:class AND Room=:kamar AND Bad=:bed");
                // $this->db->bind('class', $ClassID);
                // $this->db->bind('kamar', $RoomName);
                // $this->db->bind('bed', $Bed);
                // $data =  $this->db->single();
                $this->UpdateKetersediaanKamarBPJS($roomid);
            } else { //Jika Edit maka update

                //Cek Sudah Dihapus Atau Belum
                $this->db->query("SELECT *,replace(CONVERT(VARCHAR(11), StartDate, 111), '/','-') as startdate
            FROM RawatInapSQL.dbo.Inpatient_in_out Where ID=:idtrs");
                $this->db->bind('idtrs', $idtrs);
                $data =  $this->db->single();

                if ($data === false) {
                    $callback = array(
                        'status' => "warning",
                        'errorname' => "ID Tidak Ditemukan! Data Sudah Dihapus! Silahkan Cek Kembali!",
                    );
                    return $callback;
                    exit;
                }

                $alasan = $_POST['alasan'];

                //Get Data Kamar Lama
                $sql = "SELECT StatusActive,RoomID,NoRegRI
            FROM RawatInapSQL.dbo.Inpatient_in_out
            WHERE ID=:id_inpatientinout ";
                $this->db->query($sql);
                $this->db->bind("id_inpatientinout", $idtrs);
                $data =  $this->db->single();
                $roomid_lama = $data['RoomID'];
                $cek_status = $data['StatusActive'];
                $noregInOut = $data['NoRegRI'];

                $this->db->query("SELECT * from Billing_Pasien.dbo.FO_T_BILLING_1 where NO_REGISTRASI=:regis");
                $this->db->bind('regis', $noreg);
                $dataa1 =  $this->db->single();

                $this->db->query("SELECT jumlah,LamaRawat from RawatInapSQL.dbo.View_LamaRawat where NoRegRI=:NOREG");
                $this->db->bind('NOREG', $noreg);
                $datajmlh =  $this->db->single();
                // $idtrs2 = $dataacc['ID'];
                $Jmlh = $datajmlh['jumlah'];
                $Qty = $datajmlh['LamaRawat'];

                // var_dump($Tarif_Servis);
                // exit;

                if ($dataa1['GROUP_JAMINAN'] == "1") {
                    $kekurangan = $Jmlh;
                    $klaim = "0";
                    $bayar = "0";
                } else {
                    $kekurangan = "0";
                    $klaim = $Jmlh;
                    $bayar = "0";
                }
                //Insert ke Tz_Log_Button
                $keterangan = 'Pindah Kamar Dari RoomID Lama: ' . $roomid_lama . ' Ke RoomID Baru:' . $bedid;
                $sqlx = "INSERT INTO  SysLog.dbo.TZ_Log_Button (idtrs,noregistrasi,nama_biling,petugas_batal,tgl_batal,alasan_batal) VALUES
                (:InpatientID,:noregri,:info,:namauserx,:datenowcreate,:alasan)";
                $this->db->query($sqlx);
                $this->db->bind('InpatientID', $idtrs);
                $this->db->bind('noregri', $noreg);
                $this->db->bind('info', $keterangan);
                $this->db->bind('namauserx', $userid);
                $this->db->bind('datenowcreate', $datenowcreate);
                $this->db->bind('alasan', $alasan);
                $this->db->execute();

                if ($cek_status == '1') { //Cek jika kamar yang diedit dalam keadaan aktif atau tidak
                    // set status room yang lama jadi tidak terpakai
                    $queryUpdateRoomLama = "UPDATE MasterdataSQL.dbo.MstrRoomID 
                SET Status=:isactive WHERE RoomID=:roomid";
                    $this->db->query($queryUpdateRoomLama);
                    $this->db->bind('isactive', $noactive);
                    $this->db->bind('roomid', $roomid_lama);
                    $this->db->execute();

                    // set status room jadi terpakai
                    $queryUpdateRoom = "UPDATE MasterdataSQL.dbo.MstrRoomID 
                SET Status=:isactive WHERE RoomID=:roomid";
                    $this->db->query($queryUpdateRoom);
                    $this->db->bind('isactive', $isactive);
                    $this->db->bind('roomid', $bedid);
                    $this->db->execute();
                }

                // Update di tabel inpatient_in_out
                $queryUpdatekmr = "UPDATE RawatInapSQL.dbo.Inpatient_in_out SET RoomID=:roomid,IDKelas=:idkelas,Class=:class,RoomName=:kamar,Bed=:bed,Tarif=:tarif,Titipan=:titipan,RoomID_Titipan=:roomid_titipan,IDKelas_Titipan=:idkelas_titipan,RoomName_Titipan=:roomname_titipan,Bed_Titipan=:bed_titipan,Tarif_Titipan=:tarif_titipan
                WHERE ID=:id_inpatientinout";
                $this->db->query($queryUpdatekmr);
                $this->db->bind('roomid', $bedid);
                $this->db->bind('idkelas', $ClassID);
                $this->db->bind('class', $classname);
                $this->db->bind('kamar', $roomname);
                $this->db->bind('bed', $bedname);
                $this->db->bind('tarif', $TarifKamar);
                $this->db->bind('id_inpatientinout', $idtrs);
                $this->db->bind('titipan', $titipan);
                $this->db->bind('roomid_titipan', $roomid_titipan);
                $this->db->bind('idkelas_titipan', $idkelas_titipan);
                $this->db->bind('roomname_titipan', $roomname_titipan);
                $this->db->bind('bed_titipan', $bed_titipan);
                $this->db->bind('tarif_titipan', $tarif_titipan);
                $this->db->execute();

                $this->db->query(" UPDATE Billing_Pasien.dbo.FO_T_BILLING set TOTAL_TARIF=:tarif where NO_REGISTRASI=:regis");
                $this->db->bind('regis', $noregInOut);
                $this->db->bind('tarif', $TarifKamar);
                $this->db->execute();


                $this->db->query(" UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 set KODE_TARIF=:KODE,NAMA_TARIF=:NAMEROOM,NILAI_TARIF=:tarif,KODE_REF=:ref,KLAIM=:klaim,KEKURANGAN=:kurang where NO_REGISTRASI=:regis and ID_BILL=:id_inpatientinout");
                $this->db->bind('regis', $noregInOut);
                $this->db->bind('KODE', $bedid);
                $this->db->bind('NAMEROOM', $roomname);
                $this->db->bind('ref', $idtrs);
                $this->db->bind('tarif', $TarifKamar);
                $this->db->bind('klaim', $klaim);
                $this->db->bind('kurang', $kekurangan);
                $this->db->bind('id_inpatientinout', $idtrs);
                $this->db->execute();

                $this->db->query(" UPDATE Billing_Pasien.dbo.FO_T_BILLING_2 set KODE_TARIF=:KODE,NAMA_TARIF=:NAMEROOM,NILAI_TARIF=:tarif,NILAI_PDP=:pdp where ID_BILL=:id_inpatientinout");
                $this->db->bind('KODE', $bedid);
                $this->db->bind('NAMEROOM', $roomname);
                $this->db->bind('tarif', $TarifKamar);
                $this->db->bind('pdp', $TarifKamar);
                $this->db->bind('id_inpatientinout', $idtrs);
                $this->db->execute();
                // exit;
                //pesan return
                $return_message = 'Edit Kamar Berhasil Dilakukan!';

                //Get kode lokasi dan bridging bpjs----------
                $this->db->query("SELECT KodeLokasi from MasterdataSQL.dbo.MstrRoomID
                    WHERE RoomID=:roomid");
                $this->db->bind('roomid', $roomid_lama);
                $data =  $this->db->single();
                $this->UpdateKetersediaanKamarBPJS($data['KodeLokasi']);

                sleep(1);

                //Get kode lokasi dan bridging bpjs----------
                $this->db->query("SELECT KodeLokasi from MasterdataSQL.dbo.MstrRoomID
                    WHERE RoomID=:roomid");
                $this->db->bind('roomid', $bedid);
                $data =  $this->db->single();
                $this->UpdateKetersediaanKamarBPJS($data['KodeLokasi']);
            }

            /*
        if($idtrf<>'' || $idtrf <> null){
            // set order pindah kamar jadi sudah di eksekusi / 1
             $queryUpdateReq = "UPDATE MedicalRecord.dbo.MR_TransferPasien 
                                 SET StatusTransfer='1'
                                 where NoRegistrasi=:noreg and ID=:idtrf";
             $this->db->query($queryUpdateReq);
             $this->db->bind('noreg', $noreg);
             $this->db->bind('idtrf', $idtrf); 
             $this->db->execute();
         }*/

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => $return_message,
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'errorname' => $e
            );
            return $callback;
        }
    }


}

