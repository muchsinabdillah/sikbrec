<?php


class UploadPlan_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function insert($data)
    {
        //$data['Mst_NamaClient']
        $session = SessionManager::getCurrentSession();
        $userid = $session->username;
        $tgl_input = Utils::seCurrentDateTime();
        $idTrs = Utils::idtrsByDatetime();
        $zerodata = "0";
        try {
            $this->db->transaksi();
            if ($data['upldwbs_IDtrs'] == "") {
                $this->db->query("INSERT INTO P_P_WBS_HDR
                                ( KODE_TRANSAKSI,DATE_IMPORT,PETUGAS_IMPORT,BATAL,
                                    ID_MOU,KD_JO,NM_PROJECT,LOKASI_KERJA,
                                    DATE_START,DATE_END ) 
                                    values
                                ( ?,?,?,?,
                                    ?,?,?,?,
                                    ?,?)");
                $this->db->bind(1, $idTrs);
                $this->db->bind(2, $tgl_input);
                $this->db->bind(3, $userid);
                $this->db->bind(4, $zerodata);
                $this->db->bind(5, $data['upldwbs_idmou']);
                $this->db->bind(6, $data['upldwbs_lokasi']);
                $this->db->bind(7, $data['upldwbs_namaproject']);
                $this->db->bind(8, $data['upldwbs_lokasi_nm']);
                $this->db->bind(9, $data['upldwbs_datestart']);
                $this->db->bind(10, $data['upldwbs_dateend']);
                $this->db->execute();
                $this->db->commit();
                
                $callback = array(
                    'status' => 'success', // Set array status dengan success   
                    'NoTRS' => $idTrs , // Set array status dengan success    
                );
                return $callback;
            } else {

                if ($data['upldwbs_idmou'] == "") {
                    $callback = array(
                        'status' => 'warning',  'errorname' => 'Silahkan Input MOU !',
                    );
                    return $callback;
                    exit;
                }
                if ($data['upldwbs_datestart'] == "") {
                    $callback = array(
                        'status' => 'warning',  'errorname' => 'Silahkan Input Tanggal Awal Kontrak !',
                    );
                    return $callback;
                    exit;
                }
                if ($data['upldwbs_dateend'] == "") {
                    $callback = array(
                        'status' => 'warning',  'errorname' => 'Silahkan Input Tanggal Akhir Kontrak !',
                    );
                    return $callback;
                    exit;
                }
                if ($data['upldwbs_lokasi'] == "") {
                    $callback = array(
                        'status' => 'warning',  'errorname' => 'Silahkan Input Kode JO !',
                    );
                    return $callback;
                    exit;
                }
                if ($data['upldwbs_namaproject'] == "") {
                    $callback = array(
                        'status' => 'warning',  'errorname' => 'Silahkan Input Nama Project !',
                    );
                    return $callback;
                    exit;
                }
                if ($data['upldwbs_lokasi_nm'] == "") {
                    $callback = array(
                        'status' => 'warning',  'errorname' => 'Silahkan Input Nama Lokasi Project !',
                    );
                    return $callback;
                    exit;
                }
                // cek duulu
                $this->db->query("SELECT KODE_TRANSAKSI FROM P_P_WBS_BOQ WHERE KODE_TRANSAKSI= ? ");
                $this->db->bind(1, $data['upldwbs_IDtrs']);
                $this->db->execute();
                $rowData = $this->db->rowCount();
                if ($rowData > 0) {
                    $this->db->query("SELECT count(pegawai) as jumlahPegawai from (
                        select   (pegawai) from (
                        select id_data pegawai from P_P_WBS_TIM where kode_transaksi=:upldwbs_IDtrs
                        union all
                        select KD_PEG pegawai from P_P_WBS_HDR_PEG where KODE_TRANSAKSI=:upldwbs_IDtrs2)x
                        group by  pegawai) x");
                    $this->db->bind('upldwbs_IDtrs', $data['upldwbs_IDtrs']);
                    $this->db->bind('upldwbs_IDtrs2', $data['upldwbs_IDtrs2']);
                    $this->db->execute();
                    $GetCountVal = $this->db->rowCount();
                    if ($GetCountVal <  0) {
                        $callback = array(
                            'status' => 'warning',
                            'errorname' => 'Data Pegawai/TIM Masih Kosong, Silahkan Import Data Pegawai/Tim atau Hapus Transaksi !',
                        );
                        return $callback;
                        exit;
                    } else {
                        $this->db->query("UPDATE P_P_WBS_HDR SET  ID_MOU = :upldwbs_idmou,KD_JO = :upldwbs_lokasi ,
                                NM_PROJECT = :upldwbs_namaproject, LOKASI_KERJA = :upldwbs_lokasi_nm ,
                                DATE_START = :upldwbs_datestart ,DATE_END =:upldwbs_dateend ,FN_DURASI = :upldwbs_durasi,
                                TOTAL_PEG = :upldwbs_totalpegawai  
                                where KODE_TRANSAKSI = :upldwbs_IDtrs");
                        $this->db->bind('upldwbs_idmou', $data['upldwbs_idmou']);
                        $this->db->bind('upldwbs_lokasi', $data['upldwbs_lokasi']);
                        $this->db->bind('upldwbs_namaproject', $data['upldwbs_namaproject']);
                        $this->db->bind('upldwbs_lokasi_nm', $data['upldwbs_lokasi_nm']);
                        $this->db->bind('upldwbs_datestart', $data['upldwbs_datestart']);
                        $this->db->bind('upldwbs_dateend', $data['upldwbs_dateend']);
                        $this->db->bind('upldwbs_durasi', $data['diffInDays']);
                        $this->db->bind('upldwbs_totalpegawai', $data['DataPegawai']);
                        $this->db->bind('upldwbs_IDtrs', $data['upldwbs_IDtrs']);
                        $this->db->execute();
                        $this->db->commit(); 
                        $callback = array(
                                'status' => 'update', // Set array status dengan success   
                                'NoTRS' => $idTrs, // Set array status dengan success    
                            );
                        return $callback; 
                    }
                }else{
                    $callback = array(
                        'status' => 'warning',  
                        'errorname' => 'Anda Belum melakukan Upload Data WBS, Silahkan Import Data WBS atau Hapus Transaksi !',
                    );
                    return $callback;
                    exit;
                } 
            }
            
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function uploadWbs($data)
    {
        $upldwbs_IDtrs = $data['upldwbs_IDtrs'];
        $upldwbs_datestart = $data['upldwbs_datestart'];
        $upldwbs_dateend = $data['upldwbs_dateend'];
        $upldwbs_lokasi = $data['upldwbs_lokasi'];
        $file =  $_FILES['file']['tmp_name'];

        // Jika user telah mengklik tombol Preview

        //$ip = ; // Ambil IP Address dari User
        $id = $data['upldwbs_IDtrs'];
        $nama_file_baru = $id . '.xlsx';

        // Cek apakah terdapat file data.xlsx pada folder tmp
        if (is_file(__DIR__ . '/../../public' . '/tmp/' . $nama_file_baru)) // Jika file tersebut ada
            unlink(__DIR__ . '/../../public' . '/tmp/' . $nama_file_baru); // Hapus file tersebut

        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
        $tmp_file = $_FILES['file']['tmp_name'];

        // Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
        if ($ext == "xlsx") {
            // Upload file yang dipilih ke folder tmp
            // dan rename file tersebut menjadi data{ip_address}.xlsx
            // {ip_address} diganti jadi ip address user yang ada di variabel $ip
            // Contoh nama file setelah di rename : data127.0.0.1.xlsx
            if (move_uploaded_file($tmp_file,  __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru)) {
                $callback = array(
                    'status' => 'success',
                    'message' => ' Upload Data Succesfully. Please wait for Generating Data to Server.',
                );
                return $callback;
            } else {
                $callback = array(
                    'status' => 'warning',
                    'message' => 'Upload Failed.',
                );
                return $callback;
            }
            // Load librari PHPExcel nya
            // require_once '../../js/PHPExcel/PHPExcel.php'; 
            // $excelreader = new PHPExcel_Reader_Excel2007();
            // $loadexcel = $excelreader->load('tmp/'.$nama_file_baru); // Load file yang tadi diupload ke folder tmp
            // $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true); 



        } else { // Jika file yang diupload bukan File Excel 2007 (.xlsx)
            // Munculkan pesan validasi 
            $callback = array(
                'status' => 'warning',
                'message' => ' Hanya File Excel 2007 (.xlsx) yang diperbolehkan.',
            );
            return $callback;
        }
    }
    public function genUploadWbs($data){
        $idx = $data['upldwbs_IDtrs'];
        $upldwbs_datestart = $data['upldwbs_datestart'];
        $upldwbs_dateend = $data['upldwbs_dateend'];
        $upldwbs_lokasi = $data['upldwbs_lokasi'];
        $upldwbs_idmou = $data['upldwbs_idmou'];

        $excelreader = new PHPExcel_Reader_Excel2007();
        $loadexcel = $excelreader->load(__DIR__. '/../../public' . '/tmp/' . $idx . '.xlsx'); // Load file excel yang tadi diupload ke folder tmp
        $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

        $numrow = 1;
        try {
            $this->db->transaksi();
            
            foreach ($sheet as $row) { //
                // Ambil data pada excel sesuai Kolom
                $ID_MOU = $row['A']; // Ambil data NIS
                $FB_GRUP = $row['B']; // Ambil data nama
                $KD_LEVEL = $row['C']; // Ambil data jenis kelamin
                $ID_WBS = $row['D']; // Ambil data telepon
                $NM_WBS = $row['E']; // Ambil data alamat
                $KD_WBS_GRUP = $row['F']; // Ambil data alamat
                $KD_TIPE_WBS = $row['G']; // Ambil data alamat
                $QTY = $row['H']; // Ambil data alamat
                $UNIT_MATERAI = $row['I']; // Ambil data alamat
                $MP_NILAI = $row['J']; // Ambil data alamat
                $EQUIP_NILAI = $row['K']; // Ambil data alamat
                $TOOLS_NILAI = $row['L']; // Ambil data alamat
                $MATERAI_PRICE = $row['M']; // Ambil data alamat
                $Labor_Price_BOQ = $row['N']; // Ambil data alamat
                $Eqp_Price_BOQ = $row['O']; // Ambil data alamat
                $Tools_Price_BOQ = $row['P']; // Ambil data alamat
                $Total_Direct_Price_BOQ = $row['Q']; // Ambil data alamat
                $MH_NILAI = $row['R']; // Ambil data alamat

                $MP_CONFIG_CODE = $row['S'];
                $MP_PLAN = $row['T'];
                $UNIT_HOURS = $row['U'];
                $unit = $row['V'];
                $ACTUAL_UNIT_ST = $row['W'];
                $ACTUAL_TOTAL_M_HOUR = $row['X'];
                $WORKING_HOURS = $row['Y'];
                $TOTAL_QTY = $row['Z'];
                $SP_ID = $row['AA'];
                $TASK_STATUS = $row['AB'];
                if ($TASK_STATUS == "Active") {
                    $nulldatax = "1";
                } else {
                    $nulldatax = "0";
                }
                // Cek jika semua data tidak diisi
                if (
                    $ID_MOU == "" && $FB_GRUP == "" && $KD_LEVEL == "" && $ID_WBS == "" && $NM_WBS == "" && $KD_WBS_GRUP == "" && $KD_TIPE_WBS == "" && $QTY == "" && $UNIT_MATERAI == ""
                    && $MP_NILAI == "" && $EQUIP_NILAI == "" && $TOOLS_NILAI == "" && $MATERAI_PRICE == ""
                    && $Labor_Price_BOQ == "" && $Eqp_Price_BOQ == "" && $Tools_Price_BOQ == "" && $Total_Direct_Price_BOQ == ""
                    && $MH_NILAI == ""
                )
                    continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)
                // Cek jika semua data tidak diisi
                // if($hidden_nis == "" && $hidden_nama == "" && $hidden_jkelamin == "" && $hidden_tlp == "" && $hidden_alamat == "" && $hidden_tipeID == "" && $hidden_tptlahir == "" && $hidden_handphone == "" && $hidden_pekerjaan == "")
                //  continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

                // Cek $numrow apakah lebih dari 1
                // Artinya karena baris pertama adalah nama-nama kolom
                // Jadi dilewat saja, tidak usah diimport 

                if ($numrow > 1) {
                    $nulldata = "";
                    $this->db->query("INSERT INTO P_P_WBS_BOQ
                            (ID_MOU,ID_WBS,NM_WBS,KD_WBS_GRUP,KD_TIPE_WBS,
                            KD_LEVEL,FB_GRUP,KD_WBS_EKS,
                            QTY,MP_NILAI,EQUIP_NILAI,TOOLS_NILAI,MH_NILAI,KODE_TRANSAKSI
                            ,MP_CONFIG_CODE,MP_PLAN,UNIT_HOURS,unit,ACTUAL_UNIT_ST
                            ,ACTUAL_TOTAL_M_HOUR,WORKING_HOURS,TOTAL_QTY,SP_ID,
                            TASK_STATUS,UNIT_MATERIAL,SUB_TOTAL_DIRECT,SUB_TOTAL_MATERIAL) 
                            values
                            (?,?,?,?,?
                              ,?,?,?
                              ,?,?,?,?,?,?
                              ,?,?,?,?,?
                              ,?,?,?,?
                              ,?,?,?,?)");
                    $this->db->bind(1, $upldwbs_idmou);
                    $this->db->bind(2, $ID_WBS);
                    $this->db->bind(3, $NM_WBS);
                    $this->db->bind(4, $KD_WBS_GRUP);
                    $this->db->bind(5, $KD_TIPE_WBS);

                    $this->db->bind(6, $KD_LEVEL);
                    $this->db->bind(7, $FB_GRUP);
                    $this->db->bind(8, $nulldata);


                    $this->db->bind(9, $QTY);
                    $this->db->bind(10, $MP_NILAI);
                    $this->db->bind(11, $EQUIP_NILAI);
                    $this->db->bind(12, $TOOLS_NILAI);
                    $this->db->bind(13, $MH_NILAI);
                    $this->db->bind(14, $idx);


                    $this->db->bind(15, $MP_CONFIG_CODE);
                    $this->db->bind(16, $MP_PLAN);
                    $this->db->bind(17, $UNIT_HOURS);
                    $this->db->bind(18, $unit);
                    $this->db->bind(19, $ACTUAL_UNIT_ST);


                    $this->db->bind(20, $ACTUAL_TOTAL_M_HOUR);
                    $this->db->bind(21, $WORKING_HOURS);
                    $this->db->bind(22, $TOTAL_QTY);
                    $this->db->bind(23, $SP_ID);
                    $this->db->bind(24, $nulldatax);
                    $this->db->bind(25, $UNIT_MATERAI);

                    $this->db->bind(26, $Total_Direct_Price_BOQ);
                    $this->db->bind(27, $MATERAI_PRICE);
                    $this->db->execute();
               
                }
                $numrow++; // Tambah 1 setiap kali looping
            }   //   - end looping 
            $datenowcreateFull = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession(); 
            $userlogin = $session->username; 
            $this->db->query("UPDATE P_P_WBS_HDR set DATE_IMPORT=?,
                              PETUGAS_IMPORT=?,  
                              KD_JO= ?
                              WHERE KODE_TRANSAKSI=?");
            $this->db->bind(1, $datenowcreateFull);
            $this->db->bind(2, $userlogin);
            $this->db->bind(3, $upldwbs_lokasi);
            $this->db->bind(4, $idx);
            $this->db->execute();
            $this->db->commit();
        } catch (PDOException $e) {
            $this->db->rollback();
            unlink(__DIR__ . '/../../public' . '/tmp/'. $idx . '.xlsx'); // Hapus file tersebut
            $callback = array(
                'status' => 'error', // Set array status dengan success   
                'errormessage' => $e, // Set array status dengan success    
            );
            return $callback;
            exit;
        } 



        unlink(__DIR__ . '/../../public' . '/tmp/' . $idx . '.xlsx'); // Hapus file tersebut
        $callback = array(
            'status' => 'success',
            'pesan' => 'Generate Data Sukses, Load Data. Please Wait...', 
        );
        return $callback; 
    }
    public function ShowlistDetilWbs($data)
    {
        try { 
            $no = "1";
            $this->db->query("SELECT * FROM P_P_WBS_BOQ where KODE_TRANSAKSI= ?");
            $this->db->bind(1, $data['VerifwbS_Kode']); 
            $data =  $this->db->resultSet();
            $rows = array(); 
            foreach ($data as $key) {
                $pasing['No'] = $no; 
                $pasing['KODE_TRANSAKSI'] = $key['KODE_TRANSAKSI'];
                $pasing['ID_MOU'] = $key['ID_MOU'];
                $pasing['ID'] = $key['ID'];
                $pasing['ID_WBS'] = $key['ID_WBS'];
                $pasing['NM_WBS'] = $key['NM_WBS'];
                $pasing['KD_WBS_GRUP'] = $key['KD_WBS_GRUP'];
                $pasing['KD_TIPE_WBS'] = $key['KD_TIPE_WBS'];
                $pasing['KD_LEVEL'] = $key['KD_LEVEL'];
                $pasing['FB_GRUP'] = $key['FB_GRUP'];
                $pasing['KD_WBS_EKS'] = $key['KD_WBS_EKS'];
                $pasing['QTY'] = $key['QTY'];
                $pasing['MP_NILAI'] = $key['MP_NILAI'];
                $pasing['EQUIP_NILAI'] = $key['EQUIP_NILAI'];
                $pasing['TOOLS_NILAI'] = $key['TOOLS_NILAI'];
                $pasing['MH_NILAI'] = $key['MH_NILAI'];
                $pasing['MP_CONFIG_CODE'] = $key['MP_CONFIG_CODE'];
                $pasing['MP_PLAN'] = $key['MP_PLAN'];
                $pasing['UNIT_HOURS'] = $key['UNIT_HOURS'];
                $pasing['unit'] = $key['MH_NILAI'];
                $pasing['ACTUAL_UNIT_ST'] = $key['ACTUAL_UNIT_ST'];
                $pasing['ACTUAL_TOTAL_M_HOUR'] = $key['ACTUAL_TOTAL_M_HOUR'];
                $pasing['WORKING_HOURS'] = $key['WORKING_HOURS'];
                $pasing['TOTAL_QTY'] = $key['TOTAL_QTY'];
                $pasing['SP_ID'] = $key['SP_ID'];
                $pasing['TASK_STATUS'] = $key['TASK_STATUS']; 
                $rows[] = $pasing; 
            } 
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function uploadManPower($data)
    {
        $idx = $data['upldwbs_IDtrs'];
        $upldwbs_datestart = $data['upldwbs_datestart'];
        $upldwbs_dateend = $data['upldwbs_dateend'];
        $upldwbs_lokasi = $data['upldwbs_lokasi'];
        $file =  $_FILES['file']['tmp_name'];
        if ($idx == "") {
            $callback = array(
                'status' => 'error',
                'errormessage' => 'Kode Transaksi Kosong, Silahkan Cek Kembali !',
            );
            return $callback;
            exit;
        }
        if ($file == "") {
            $callback = array(
                'status' => 'error',
                'errormessage' => 'Nama File Upload Team Kosong, Silahkan Cek Kembali !',
            );
            return $callback;
            exit;
        } 
        // Jika user telah mengklik tombol Preview

        //$ip = ; // Ambil IP Address dari User
        $id = $data['upldwbs_IDtrs'];
        $nama_file_baru = $id . '_mpmh.xlsx';

        // Cek apakah terdapat file data.xlsx pada folder tmp
        if (is_file(__DIR__ . '/../../public' . '/tmp/' . $nama_file_baru)) // Jika file tersebut ada
            unlink(__DIR__ . '/../../public' . '/tmp/' . $nama_file_baru); // Hapus file tersebut

        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
        $tmp_file = $_FILES['file']['tmp_name'];

        // Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
        if ($ext == "xlsx") {
            // Upload file yang dipilih ke folder tmp
            // dan rename file tersebut menjadi data{ip_address}.xlsx
            // {ip_address} diganti jadi ip address user yang ada di variabel $ip
            // Contoh nama file setelah di rename : data127.0.0.1.xlsx
            if (move_uploaded_file($tmp_file,  __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru)) {
                $callback = array(
                    'status' => 'success',
                    'message' => ' Upload Data Succesfully. Please wait for Generating Data to Server.',
                );
                return $callback;
            } else {
                $callback = array(
                    'status' => 'warning',
                    'message' => 'Upload Failed.',
                );
                return $callback;
            }
            // Load librari PHPExcel nya
            // require_once '../../js/PHPExcel/PHPExcel.php'; 
            // $excelreader = new PHPExcel_Reader_Excel2007();
            // $loadexcel = $excelreader->load('tmp/'.$nama_file_baru); // Load file yang tadi diupload ke folder tmp
            // $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true); 



        } else { // Jika file yang diupload bukan File Excel 2007 (.xlsx)
            // Munculkan pesan validasi 
            $callback = array(
                'status' => 'warning',
                'message' => ' Hanya File Excel 2007 (.xlsx) yang diperbolehkan.',
            );
            return $callback;
        }
    }
    public function genUploadManPower($data)
    {
        $tempnotrs = $data['upldwbs_IDtrs'];
        $upldwbs_datestart = $data['upldwbs_datestart'];
        $upldwbs_dateend = $data['upldwbs_dateend'];
        $upldwbs_lokasi = $data['upldwbs_lokasi'];
        $upldwbs_idmou = $data['upldwbs_idmou'];
        $asaaaa = "_tepm_" . $tempnotrs;
        $notransaksi = Utils::idtrsByDatetime();
        $excelreader = new PHPExcel_Reader_Excel2007();
        $file =  __DIR__ . '/../../public' . '/tmp/' . $tempnotrs . '_mpmh.xlsx';
        $objPHPExcel = PHPExcel_IOFactory::load($file); // create object of PHPExcel library by using load() method and in load method define path of selected file
        $all = array();
        $flag = 0;
        $output = '';
        $TIPEDATA = "VARCHAR(MAX)";

        try {
            $this->db->transaksi();
            // CREATE TABEL DINAMIS 
            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $allColumn = $worksheet->getHighestColumn();
                /**Get the total number of lines*/
                $highestRow = $worksheet->getHighestRow();
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($allColumn);
                for ($row = 1; $row <= 1; $row++) {
                    $output .= "<tr>";
                    $col = array();
                    $flag = 0;
                    for ($currentColumn = 'A'; $currentColumn <= $allColumn; $currentColumn++) {
                        for ($j = 0; $j < $highestColumnIndex; $j++) {
                            $x[$j] = $worksheet->getCellByColumnAndRow($j, $row)->getValue() . ' ' . $TIPEDATA;
                            $dataX = implode(",", $x);
                        }
                    }
                    $this->db->query("CREATE TABLE " . $asaaaa . " (" . $dataX . ")");
                    $this->db->execute();
                }
            }
            //INSERT DATA DARI EXCEL KE TABEL DINAMIS 
            foreach ($objPHPExcel->getWorksheetIterator() as $worksheetiNSERT) {
                $allColumn = $worksheetiNSERT->getHighestColumn();
                /**Get the total number of lines*/
                $highestRow = $worksheetiNSERT->getHighestRow();
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($allColumn);
                for ($row = 3; $row <= $highestRow; $row++) {
                    $output .= "<tr>";
                    $col = array();
                    $flag = 0;
                    for ($currentColumn = 'A'; $currentColumn <= $allColumn; $currentColumn++) {
                        for ($j = 0; $j < $highestColumnIndex; $j++) {
                            $x[$j] = "'" . $worksheetiNSERT->getCellByColumnAndRow($j, $row)->getValue() . "'";
                            $dataX = implode(",", $x);
                        }
                    }
                    $asu = substr($dataX, -1);
                    if ($row == $highestRow
                    ) {
                        $rep2 = "'" . str_replace($asu, "", $dataX) . "'";
                    } else {
                        $rep = $dataX;
                    }

                    $this->db->query("INSERT INTO " . $asaaaa . " VALUES (" . $rep . ")");
                    $this->db->execute();
                    $this->db->query("UPDATE " . $asaaaa . " SET KD_TRANSAKSI = '" . $tempnotrs . "'  ");
                    $this->db->execute();
                }
            }
            $dump = "";
            // Tentuin Nilai Jumlah Columns di tabel
            $this->db->query("SELECT (count(COLUMN_NAME)) as Columns_Total
                              FROM INFORMATION_SCHEMA.Columns where TABLE_NAME = :namaTabel ");
            $this->db->bind('namaTabel', $asaaaa);
            $this->db->execute();

            $CountCol = $this->db->rowCount();
            $fixCountCol = count($CountCol);
            if ($fixCountCol > 0) {
                $getColumnsCountTabel =  $fixCountCol['Columns_Total'];
            } else {
                $getColumnsCountTabel =  0;
            }

            // Looping insert data 
            for ($weeknr2 = 1; $weeknr2 <= 60; $weeknr2++) {
                $numberss = "MP" . $weeknr2;
                $this->db->query("SELECT  (COLUMN_NAME) TIPE_PEGAWAI 
                                FROM INFORMATION_SCHEMA.Columns where    TABLE_NAME = :namaTabelMp
                                AND COLUMN_NAME  = :ColumnsNumbers  ");
                $this->db->bind('namaTabelMp', $asaaaa);
                $this->db->bind('ColumnsNumbers', $numberss);
                $this->db->execute(); 
                $fixIsCol = $this->db->rowCount();
                $CountCol =  $this->db->single();
                if ($CountCol) {
                    $TIPE_PEGAWAI = $CountCol['TIPE_PEGAWAI'];
                    if ($TIPE_PEGAWAI <> "") {
                        $this->db->query("SELECT distinct '" . $tempnotrs . "',TAHUN,ISO_WEEK, '" . $TIPE_PEGAWAI . "' AS Tipe ,
                               $TIPE_PEGAWAI  as nilai,  REPLACE(ISO_WEEK, 'Week', '') as WeekNumber
                              FROM " . $asaaaa . "  ");
                        $this->db->execute();
                        $dataMP =  $this->db->resultSet();
                        //$rows = array();
                        foreach ($dataMP as $row) {
                            $dateweek = $row['WeekNumber'];
                            $thisYear2 = $row['TAHUN'];
                            $weekint = $row['WeekNumber'];
                            $tempDatum2 = new DateTime();
                            $tempDatum2->setISODate($row['TAHUN'], $row['WeekNumber']);
                            $tempDatum_start2 = $tempDatum2->format('Y-m-d');
                            $tempDatum2->setISODate($row['TAHUN'], $row['WeekNumber'], 7);
                            $tempDatum_end2 = $tempDatum2->format('Y-m-d');
                            $this->db->query("INSERT INTO P_P_WBS_MP 
                                                  (KD_TRANSAKSI,TAHUN,[ISO_WEEK],
                                                  TIPE, NILAI, MULAI, SELESAI) 
                                                  VALUES 
                                                  (:tempnotrs,:thisYear2,:ISO_WEEK,
                                                   :Tipe ,:nilai,:tempDatum_start2,:tempDatum_end2 ) ");
                            $this->db->bind('tempnotrs', $tempnotrs);
                            $this->db->bind('thisYear2', $thisYear2);
                            $this->db->bind('ISO_WEEK', $row['ISO_WEEK']);
                            $this->db->bind('Tipe', $row['Tipe']);
                            $this->db->bind('nilai', $row['nilai']);
                            $this->db->bind('tempDatum_start2', $tempDatum_start2);
                            $this->db->bind('tempDatum_end2', $tempDatum_end2);
                            $this->db->execute();
                        }
                    }
                }
            }
            $this->db->query("DROP TABLE " . $asaaaa . " ");
            $this->db->execute();
            $this->db->commit();
        } catch (PDOException $e) {
            $this->db->rollback();
            unlink(__DIR__ . '/../../public' . '/tmp/' . $tempnotrs . '_mpmh.xlsx'); // Hapus file tersebut
            $callback = array(
                'status' => 'error', // Set array status dengan success   
                'errormessage' => $e, // Set array status dengan success    
            );
            return $callback;
            exit;
        }



        unlink(__DIR__ . '/../../public' . '/tmp/' . $tempnotrs . '_mpmh.xlsx'); // Hapus file tersebut
        $callback = array(
            'status' => 'success',
            'pesan' => 'Generate Data Sukses, Load Data. Please Wait...',
        );
        return $callback;
    }
    public function ShowlistDetilMP($data)
    {
        try {
            $no = "1";
            $this->db->query("SELECT *FROM P_P_WBS_MP where KD_TRANSAKSI= ?");
            $this->db->bind(1, $data['VerifwbS_Kode']);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['No'] = $no;
                $pasing['KODE_TRANSAKSI'] = $key['KD_TRANSAKSI'];
                $pasing['TAHUN'] = $key['TAHUN'];
                $pasing['ISO_WEEK'] = $key['ISO_WEEK'];
                $pasing['TIPE'] = $key['TIPE'];
                $pasing['NILAI'] = $key['NILAI'];
                $pasing['MULAI'] = $key['MULAI'];
                $pasing['SELESAI'] = $key['SELESAI']; 
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function uploadManHour($data)
    {
        $idx = $data['upldwbs_IDtrs']; 
        $file =  $_FILES['file']['tmp_name'];
        if ($idx == "") {
            $callback = array(
                'status' => 'error',
                'errormessage' => 'Kode Transaksi Kosong, Silahkan Cek Kembali !',
            );
            return $callback;
            exit;
        }
        if ($file == "") {
            $callback = array(
                'status' => 'error',
                'errormessage' => 'Nama File Upload Team Kosong, Silahkan Cek Kembali !',
            );
            return $callback;
            exit;
        } 
        //$ip = ; // Ambil IP Address dari User
        $id = $data['upldwbs_IDtrs'];
        $nama_file_baru = $id . '_mpmh2.xlsx';

        // Cek apakah terdapat file data.xlsx pada folder tmp
        if (is_file(__DIR__ . '/../../public' . '/tmp/' . $nama_file_baru)) // Jika file tersebut ada
            unlink(__DIR__ . '/../../public' . '/tmp/' . $nama_file_baru); // Hapus file tersebut

        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
        $tmp_file = $_FILES['file']['tmp_name'];

        // Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
        if ($ext == "xlsx") {
            // Upload file yang dipilih ke folder tmp
            // dan rename file tersebut menjadi data{ip_address}.xlsx
            // {ip_address} diganti jadi ip address user yang ada di variabel $ip
            // Contoh nama file setelah di rename : data127.0.0.1.xlsx
            if (move_uploaded_file($tmp_file,  __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru)) {
                $callback = array(
                    'status' => 'success',
                    'message' => ' Upload Data Succesfully. Please wait for Generating Data to Server.',
                );
                return $callback;
            } else {
                $callback = array(
                    'status' => 'warning',
                    'message' => 'Upload Failed.',
                );
                return $callback;
            }
            // Load librari PHPExcel nya
            // require_once '../../js/PHPExcel/PHPExcel.php'; 
            // $excelreader = new PHPExcel_Reader_Excel2007();
            // $loadexcel = $excelreader->load('tmp/'.$nama_file_baru); // Load file yang tadi diupload ke folder tmp
            // $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true); 



        } else { // Jika file yang diupload bukan File Excel 2007 (.xlsx)
            // Munculkan pesan validasi 
            $callback = array(
                'status' => 'warning',
                'message' => ' Hanya File Excel 2007 (.xlsx) yang diperbolehkan.',
            );
            return $callback;
        }
    }
    public function genUploadManHour($data)
    {
        $tempnotrs = $data['upldwbs_IDtrs'];
        $upldwbs_datestart = $data['upldwbs_datestart'];
        $upldwbs_dateend = $data['upldwbs_dateend'];
        $upldwbs_lokasi = $data['upldwbs_lokasi'];
        $upldwbs_idmou = $data['upldwbs_idmou'];
        $asaaaa = "_tepm_MH_" . $tempnotrs;
        $notransaksi = Utils::idtrsByDatetime();
        $excelreader = new PHPExcel_Reader_Excel2007();
        $file =  __DIR__ . '/../../public' . '/tmp/' . $tempnotrs . '_mpmh2.xlsx';
        $objPHPExcel = PHPExcel_IOFactory::load($file); // create object of PHPExcel library by using load() method and in load method define path of selected file
        $all = array();
        $flag = 0;
        $output = '';
        $TIPEDATA = "VARCHAR(MAX)";

        try {
            $this->db->transaksi();
            // CREATE TABEL DINAMIS 
            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $allColumn = $worksheet->getHighestColumn();
                /**Get the total number of lines*/
                $highestRow = $worksheet->getHighestRow();
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($allColumn);
                for ($row = 1; $row <= 1; $row++) {
                    $output .= "<tr>";
                    $col = array();
                    $flag = 0;
                    for ($currentColumn = 'A'; $currentColumn <= $allColumn; $currentColumn++) {
                        for ($j = 0; $j < $highestColumnIndex; $j++) {
                            $x[$j] = $worksheet->getCellByColumnAndRow($j, $row)->getValue() . ' ' . $TIPEDATA;
                            $dataX = implode(",", $x);
                        }
                    }
                    $this->db->query("CREATE TABLE " . $asaaaa . " (" . $dataX . ")");
                    $this->db->execute();
                }
            }
            //INSERT DATA DARI EXCEL KE TABEL DINAMIS 
            foreach ($objPHPExcel->getWorksheetIterator() as $worksheetiNSERT) {
                $allColumn = $worksheetiNSERT->getHighestColumn();
                /**Get the total number of lines*/
                $highestRow = $worksheetiNSERT->getHighestRow();
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($allColumn);
                for ($row = 3; $row <= $highestRow; $row++) {
                    $output .= "<tr>";
                    $col = array();
                    $flag = 0;
                    for ($currentColumn = 'A'; $currentColumn <= $allColumn; $currentColumn++) {
                        for ($j = 0; $j < $highestColumnIndex; $j++) {
                            $x[$j] = "'" . $worksheetiNSERT->getCellByColumnAndRow($j, $row)->getValue() . "'";
                            $dataX = implode(",", $x);
                        }
                    }
                    $asu = substr($dataX, -1);
                    if (
                        $row == $highestRow
                    ) {
                        $rep2 = "'" . str_replace($asu, "", $dataX) . "'";
                    } else {
                        $rep = $dataX;
                    }

                    $this->db->query("INSERT INTO " . $asaaaa . " VALUES (" . $rep . ")");
                    $this->db->execute();
                    $this->db->query("UPDATE " . $asaaaa . " SET KD_TRANSAKSI = '" . $tempnotrs . "'  ");
                    $this->db->execute();
                }
            }
            $dump = "";
            // Tentuin Nilai Jumlah Columns di tabel
            $this->db->query("SELECT (count(COLUMN_NAME)) as Columns_Total
                              FROM INFORMATION_SCHEMA.Columns where TABLE_NAME = :namaTabel ");
            $this->db->bind('namaTabel', $asaaaa);
            $this->db->execute();

            $CountCol = $this->db->rowCount();
            $fixCountCol = count($CountCol);
            if ($fixCountCol > 0) {
                $getColumnsCountTabel =  $fixCountCol['Columns_Total'];
            } else {
                $getColumnsCountTabel =  0;
            }

            // Looping insert data 
            for ($weeknr2 = 1; $weeknr2 <= 60; $weeknr2++) {
                $numberss = "MP" . $weeknr2;
                $this->db->query("SELECT  (COLUMN_NAME) TIPE_PEGAWAI 
                                FROM INFORMATION_SCHEMA.Columns where    TABLE_NAME = :namaTabelMp
                                AND COLUMN_NAME  = :ColumnsNumbers  ");
                $this->db->bind('namaTabelMp', $asaaaa);
                $this->db->bind('ColumnsNumbers', $numberss);
                $this->db->execute();
                $fixIsCol = $this->db->rowCount();
                $CountCol =  $this->db->single();
                if ($CountCol) {
                    $TIPE_PEGAWAI = $CountCol['TIPE_PEGAWAI'];
                    if ($TIPE_PEGAWAI <> "") {
                        $this->db->query("SELECT distinct '" . $tempnotrs . "',TAHUN,ISO_WEEK, '" . $TIPE_PEGAWAI . "' AS Tipe ,
                               $TIPE_PEGAWAI  as nilai,  REPLACE(ISO_WEEK, 'Week', '') as WeekNumber
                              FROM " . $asaaaa . "  ");
                        $this->db->execute();
                        $dataMP =  $this->db->resultSet();
                        //$rows = array();
                        foreach ($dataMP as $row) {
                            $dateweek = $row['WeekNumber'];
                            $thisYear2 = $row['TAHUN'];
                            $weekint = $row['WeekNumber'];
                            $tempDatum2 = new DateTime();
                            $tempDatum2->setISODate($row['TAHUN'], $row['WeekNumber']);
                            $tempDatum_start2 = $tempDatum2->format('Y-m-d');
                            $tempDatum2->setISODate($row['TAHUN'], $row['WeekNumber'], 7);
                            $tempDatum_end2 = $tempDatum2->format('Y-m-d');
                            $this->db->query("INSERT INTO P_P_WBS_MH 
                                                  (KD_TRANSAKSI,TAHUN,[ISO_WEEK],
                                                  TIPE, NILAI, MULAI, SELESAI) 
                                                  VALUES 
                                                  (:tempnotrs,:thisYear2,:ISO_WEEK,
                                                   :Tipe ,:nilai,:tempDatum_start2,:tempDatum_end2 ) ");
                            $this->db->bind('tempnotrs', $tempnotrs);
                            $this->db->bind('thisYear2', $thisYear2);
                            $this->db->bind('ISO_WEEK', $row['ISO_WEEK']);
                            $this->db->bind('Tipe', $row['Tipe']);
                            $this->db->bind('nilai', $row['nilai']);
                            $this->db->bind('tempDatum_start2', $tempDatum_start2);
                            $this->db->bind('tempDatum_end2', $tempDatum_end2);
                            $this->db->execute();
                        }
                    }
                }
            }
            $this->db->query("DROP TABLE " . $asaaaa . " ");
            $this->db->execute();
            $this->db->commit();
        } catch (PDOException $e) {
            $this->db->rollback();
            unlink(__DIR__ . '/../../public' . '/tmp/' . $tempnotrs . '_mpmh2.xlsx'); // Hapus file tersebut
            $callback = array(
                'status' => 'error', // Set array status dengan success   
                'errormessage' => $e, // Set array status dengan success    
            );
            return $callback;
            exit;
        }



        unlink(__DIR__ . '/../../public' . '/tmp/' . $tempnotrs . '_mpmh2.xlsx'); // Hapus file tersebut
        $callback = array(
            'status' => 'success',
            'pesan' => 'Generate Data Sukses, Load Data. Please Wait...',
        );
        return $callback;
    }
    public function ShowlistDetilMH($data)
    {
        try {
            $no = "1";
            $this->db->query("SELECT *FROM P_P_WBS_MH where KD_TRANSAKSI= ?");
            $this->db->bind(1, $data['VerifwbS_Kode']);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['No'] = $no;
                $pasing['KODE_TRANSAKSI'] = $key['KD_TRANSAKSI'];
                $pasing['TAHUN'] = $key['TAHUN'];
                $pasing['ISO_WEEK'] = $key['ISO_WEEK'];
                $pasing['TIPE'] = $key['TIPE'];
                $pasing['NILAI'] = $key['NILAI'];
                $pasing['MULAI'] = $key['MULAI'];
                $pasing['SELESAI'] = $key['SELESAI'];
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function uploadTeam($data)
    {
        $upldwbs_IDtrs = $data['upldwbs_IDtrs'];
        $upldwbs_datestart = $data['upldwbs_datestart'];
        $upldwbs_dateend = $data['upldwbs_dateend'];
        $upldwbs_lokasi = $data['upldwbs_lokasi'];
        $file =  $_FILES['file']['tmp_name'];

        // Jika user telah mengklik tombol Preview

        //$ip = ; // Ambil IP Address dari User
        $id = $data['upldwbs_IDtrs'];
        $nama_file_baru = $id . '_team.xlsx';

        // Cek apakah terdapat file data.xlsx pada folder tmp
        if (is_file(__DIR__ . '/../../public' . '/tmp/' . $nama_file_baru)) // Jika file tersebut ada
            unlink(__DIR__ . '/../../public' . '/tmp/' . $nama_file_baru); // Hapus file tersebut

        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
        $tmp_file = $_FILES['file']['tmp_name'];

        // Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
        if ($ext == "xlsx") {
            // Upload file yang dipilih ke folder tmp
            // dan rename file tersebut menjadi data{ip_address}.xlsx
            // {ip_address} diganti jadi ip address user yang ada di variabel $ip
            // Contoh nama file setelah di rename : data127.0.0.1.xlsx
            if (move_uploaded_file($tmp_file,  __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru)) {
                $callback = array(
                    'status' => 'success',
                    'message' => ' Upload Data Succesfully. Please wait for Generating Data to Server.',
                );
                return $callback;
            } else {
                $callback = array(
                    'status' => 'warning',
                    'message' => 'Upload Failed.',
                );
                return $callback;
            }
            // Load librari PHPExcel nya
            // require_once '../../js/PHPExcel/PHPExcel.php'; 
            // $excelreader = new PHPExcel_Reader_Excel2007();
            // $loadexcel = $excelreader->load('tmp/'.$nama_file_baru); // Load file yang tadi diupload ke folder tmp
            // $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true); 



        } else { // Jika file yang diupload bukan File Excel 2007 (.xlsx)
            // Munculkan pesan validasi 
            $callback = array(
                'status' => 'warning',
                'message' => ' Hanya File Excel 2007 (.xlsx) yang diperbolehkan.',
            );
            return $callback;
        }
    }
    public function genUploadTIM($data)
    {
        $idx = $data['upldwbs_IDtrs'];
        $upldwbs_datestart = $data['upldwbs_datestart'];
        $upldwbs_dateend = $data['upldwbs_dateend'];
        $upldwbs_lokasi = $data['upldwbs_lokasi'];
        $upldwbs_idmou = $data['upldwbs_idmou'];

        $excelreader = new PHPExcel_Reader_Excel2007();
        $loadexcel = $excelreader->load(__DIR__ . '/../../public' . '/tmp/' . $idx . '_team.xlsx'); // Load file excel yang tadi diupload ke folder tmp
        $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

        $numrow = 1;
        try {
            $this->db->transaksi();
            $this->db->query("DELETE P_P_WBS_TIM WHERE   KODE_TRANSAKSI=:idx");
            $this->db->bind('idx', $idx); 
            $this->db->execute();

            foreach ($sheet as $row) { //
                // Ambil data pada excel sesuai Kolom
                $KD_GUT = $row['A']; // Ambil data NIS
                $KD_TIM = $row['B']; // Ambil data nama
                $TIM_DESC = $row['C']; // Ambil data jenis kelamin
                $FB_SPV = $row['D']; // Ambil data telepon
                $START = $row['E']; // Ambil data alamat
                $ENDs = $row['F']; // Ambil data alamat 

                // Cek jika semua data tidak diisi
                if ($KD_GUT == "" && $KD_TIM == "" && $TIM_DESC == "" && $FB_SPV == "" && $START == "" && $ENDs == "")
                continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)
                // Cek jika semua data tidak diisi
                // if($hidden_nis == "" && $hidden_nama == "" && $hidden_jkelamin == "" && $hidden_tlp == "" && $hidden_alamat == "" && $hidden_tipeID == "" && $hidden_tptlahir == "" && $hidden_handphone == "" && $hidden_pekerjaan == "")
                //  continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

                // Cek $numrow apakah lebih dari 1
                // Artinya karena baris pertama adalah nama-nama kolom
                // Jadi dilewat saja, tidak usah diimport 

                if ($numrow > 1) {
                    $this->db->query("SELECT ID_Data FROM [HR_Data Pegawai] WHERE Nip=:KD_GUT ");
                    $this->db->bind('KD_GUT', $KD_GUT); 
                    $this->db->execute();
                    $fixIsCol = $this->db->rowCount();
                    $CountCol =  $this->db->single(); 
                    if ($CountCol > 0) {

                        $ID_Data_temp = $CountCol['ID_Data'];
                        if($ID_Data_temp <> ""){
                            $this->db->query("INSERT INTO P_P_WBS_TIM
                            (KODE_TRANSAKSI,ID_Data,Nip,FB_SPV,KD_TIM,TIM_DESCRIPTION,Time_Start,Time_End) 
                            values
                            (:idx,:ID_Data_temp,:KD_GUT,:FB_SPV,:KD_TIM,:TIM_DESC,:STARTx,:ENDs)");
                            $this->db->bind('idx', $idx);
                            $this->db->bind('ID_Data_temp', $ID_Data_temp);
                            $this->db->bind('KD_GUT', $KD_GUT);
                            $this->db->bind('FB_SPV', $FB_SPV);
                            $this->db->bind('KD_TIM', $KD_TIM);
                            $this->db->bind('TIM_DESC', $TIM_DESC);
                            $this->db->bind('STARTx', $START);
                            $this->db->bind('ENDs', $ENDs);
                            $this->db->execute(); 
                        } 
                    
                    }else{
                        $this->db->rollBack();
                        unlink('../../tmp/' . $idx . '_team.xlsx'); // Hapus file tersebut
                        $callback = array(
                            'status' => 'warning', // Set array status dengan success   
                            'pesan' => 'GUT ID Tidak Dikenal. Row Ke-' . $numrow,
                        );
                        return $callback;
                        exit;
                    } 
                }
                $numrow++; // Tambah 1 setiap kali looping
            }   //   - end looping  
            $this->db->commit();
        } catch (PDOException $e) {
            $this->db->rollback();
            unlink(__DIR__ . '/../../public' . '/tmp/' . $idx . '_team.xlsx'); // Hapus file tersebut
            $callback = array(
                'status' => 'error', // Set array status dengan success   
                'errormessage' => $e, // Set array status dengan success    
            );
            return $callback;
            exit;
        }



        unlink(__DIR__ . '/../../public' . '/tmp/' . $idx . '_team.xlsx'); // Hapus file tersebut
        $callback = array(
            'status' => 'success',
            'pesan' => 'Generate Data Sukses, Load Data. Please Wait...',
        );
        return $callback;
    }
    public function ShowlistDetilTIM($data)
    {
        try {
            $no = "1";
            $this->db->query("SELECT a.id,a.KODE_TRANSAKSI,a.ID_Data,C.Nama,a.Nip,a.TIM_DESCRIPTION,a.Time_Start,a.Time_End
                            ,b.NAMA_TIM,CASE WHEN a.FB_SPV='1' THEN 'SUPERVISOR' ELSE 'STAFF' END as StatusKaryawan
                            FROM P_P_WBS_TIM A
                            INNER JOIN P_M_TIM B 
                            ON A.KD_TIM = B.ID
                            inner join [HR_Data Pegawai] C ON C.ID_Data = A.ID_Data
                            where A.KODE_TRANSAKSI=:VerifwbS_Kode");
            $this->db->bind('VerifwbS_Kode', $data['VerifwbS_Kode']);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['No'] = $no;
                $pasing['id'] = $key[ 'id'];
                $pasing['KODE_TRANSAKSI'] = $key['KODE_TRANSAKSI'];
                $pasing['ID_Data'] = $key['ID_Data'];
                $pasing['Nama'] = $key['Nama'];
                $pasing['Nip'] = $key[ 'Nip'];
                $pasing['TIM_DESCRIPTION'] = $key['TIM_DESCRIPTION'];
                $pasing['Time_Start'] = $key['Time_Start'];
                $pasing['Time_End'] = $key['Time_End'];
                $pasing['NAMA_TIM'] = $key['NAMA_TIM'];
                $pasing['StatusKaryawan'] = $key['StatusKaryawan'];  
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function showLogBookCurrentDate($data)
    {
        try {
            $session = SessionManager::getCurrentSession();
            $useridRole = $session->role;
            $userlogin = $session->username;
            $batal  = "0";
            $this->db->query("SELECT a.ID,KD_TRS,a.KD_JO,a.KD_MOU,a.FS_REFF_PEGAWAI,a.FS_KEGIATAN,a.TIME_START,a.TIME_END,
                            CONVERT(VARCHAR(11),a.TGL_LOG_BOOK, 111) TGL_LOG_BOOK,D.Nama  AS SPVName
                            FROM P_T_LB  a
                            INNER JOIN [HR_Data Pegawai] D ON D.ID_Data = A.KD_PEG_SPV
                            where 
                            replace(CONVERT(VARCHAR(11),a.TGL_LOG_BOOK, 111), '/','-') 
                            between :SrcLbDate1 and :SrcLbDate2");
            $this->db->bind('SrcLbDate1',  $data['SrcLbDate1']);
            $this->db->bind('SrcLbDate2',  $data['SrcLbDate1']);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['KD_TRS'] = $key['KD_TRS'];
                $pasing['KD_JO'] = $key['KD_JO'];
                $pasing['FS_REFF_PEGAWAI'] = $key['FS_REFF_PEGAWAI'];
                $pasing['FS_KEGIATAN'] = $key['FS_KEGIATAN'];
                $pasing['TIME_START'] = $key['TIME_START'];
                $pasing['TIME_END'] = $key['TIME_END'];
                $pasing['TGL_LOG_BOOK'] = $key['TGL_LOG_BOOK'];
                $pasing['KD_MOU'] = $key['KD_MOU'];
                $pasing['SPVName'] = $key['SPVName'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function ShowDataListTRsWBSUploadAll($data)
    {
        try {
            $session = SessionManager::getCurrentSession();
            $useridRole = $session->role;
            $userlogin = $session->username;
            $batal  = "0";
            $this->db->query("SELECT KODE_TRANSAKSI,  replace(CONVERT(VARCHAR(11),DATE_IMPORT, 111), '/','-') DATE_IMPORT,B.NamaLengkap,a.NM_PROJECT,LOKASI_KERJA
                          ,c.NM_CLIENT,c.ALAMAT,a.ID_MOU,A.KD_JO
                          FROM P_P_WBS_HDR A
                          INNER JOIN A_Login_User B 
                          ON A.PETUGAS_IMPORT = B.Username
                          inner join P_M_LOKASI C ON C.KD_LOKASI = A.KD_JO
                          WHERE BATAL='0'"); 
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['KODE_TRANSAKSI'] = $key['KODE_TRANSAKSI'];
                $pasing['DATE_IMPORT'] = $key['DATE_IMPORT'];
                $pasing['NamaLengkap'] = $key['NamaLengkap'];
                $pasing['KD_JO'] = $key['KD_JO'];
                $pasing['ID_MOU'] = $key['ID_MOU'];
                $pasing['NM_PROJECT'] = $key['NM_PROJECT'];
                $pasing['NM_CLIENT'] = $key['NM_CLIENT'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function showdetilTrsWbsByid($data)
    {
        try {
            $this->db->query("SELECT ID,ID_WBS,NM_WBS,KD_TIPE_WBS,
                            KD_LEVEL,FB_GRUP,QTY,MP_NILAI,
                            EQUIP_NILAI,TOOLS_NILAI,MH_NILAI FROM P_P_WBS_BOQ
                            WHERE ID= :params ");
            $this->db->bind('params', $data['Id']);
            $data =  $this->db->single();
            $pasing['ID'] = $data['ID'];
            $pasing['ID_WBS'] = $data['ID_WBS'];
            $pasing['NM_WBS'] = $data['NM_WBS'];
            $pasing['KD_TIPE_WBS'] = $data['KD_TIPE_WBS'];
            $pasing['KD_LEVEL'] = $data['KD_LEVEL'];
            $pasing['FB_GRUP'] = $data['FB_GRUP'];
            $pasing['QTY'] = $data['QTY'];
            $pasing['MP_NILAI'] = $data['MP_NILAI'];
            $pasing['EQUIP_NILAI'] = $data['EQUIP_NILAI'];
            $pasing['TOOLS_NILAI'] = $data['TOOLS_NILAI'];
            $pasing['MH_NILAI'] = $data['MH_NILAI']; 
            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function UpdateDataImportWbsById($data)
    {
        $JM_ID = $data['JM_ID'];
        $vrfWbs_Nama = $data['vrfWbs_Nama'];
        $vrfWbs_idWBS = $data['vrfWbs_idWBS'];
        $vrfWbs_TipeWbs = $data['vrfWbs_TipeWbs'];
        $vrfWbs_KdLevel = $data['vrfWbs_KdLevel'];
        $vrfWbs_GroupLvl = $data['vrfWbs_GroupLvl'];
        $vrfWbs_Qty = $data['vrfWbs_Qty'];
        $vrfWbs_MpNilai = $data['vrfWbs_MpNilai'];
        $vrfWbs_EquipNilai = $data['vrfWbs_EquipNilai'];
        $vrfWbs_ToolsNilai = $data['vrfWbs_ToolsNilai'];
        $vrfWbs_MhNilai = $data['vrfWbs_MhNilai'];
 
        try {
            $this->db->transaksi();
            if ($JM_ID == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode Invalid !',
                );
                return $callback;
                exit;
            }
            if ($vrfWbs_Nama == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Nama WBS Invalid !',
                );
                return $callback;
                exit;
            }
            if ($vrfWbs_idWBS == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'ID WBS Invalid !',
                );
                return $callback;
                exit;
            } 
                $this->db->query("UPDATE P_P_WBS_BOQ SET ID_WBS=:vrfWbs_idWBS,
                                NM_WBS=:vrfWbs_Nama,KD_TIPE_WBS=:vrfWbs_TipeWbs,
                                KD_LEVEL=:vrfWbs_KdLevel,FB_GRUP=:vrfWbs_GroupLvl,
                                QTY=:vrfWbs_Qty,MP_NILAI=:vrfWbs_MpNilai,
                                EQUIP_NILAI=:vrfWbs_EquipNilai,
                                TOOLS_NILAI=:vrfWbs_ToolsNilai,
                                MH_NILAI=:vrfWbs_MhNilai 
                                WHERE ID=:JM_ID");
                $this->db->bind('vrfWbs_idWBS', $vrfWbs_idWBS);
                $this->db->bind('vrfWbs_Nama', $vrfWbs_Nama);
                $this->db->bind('vrfWbs_TipeWbs', $vrfWbs_TipeWbs);
                $this->db->bind('vrfWbs_KdLevel', $vrfWbs_KdLevel);
                $this->db->bind('vrfWbs_GroupLvl', $vrfWbs_GroupLvl);
                $this->db->bind('vrfWbs_Qty', $vrfWbs_Qty);
                $this->db->bind('vrfWbs_MpNilai', $vrfWbs_MpNilai);
                $this->db->bind('vrfWbs_EquipNilai', $vrfWbs_EquipNilai);

                $this->db->bind('vrfWbs_ToolsNilai', $vrfWbs_ToolsNilai);
                $this->db->bind('vrfWbs_MhNilai', $vrfWbs_MhNilai);
                $this->db->bind('JM_ID', $JM_ID);
                $this->db->execute();
                $this->db->commit();
                $callback = array(
                    'status' => 'success', // Set array status dengan success     
                );
                return $callback;
        } catch (PDOException $e) {
            $this->db->rollback(); 
            return $e;
            exit;
        }
    }
    public function HapusDataImportWbsById($data)
    {
        $JM_ID = $data['JM_ID'];
        $vrfWbs_Nama = $data['vrfWbs_Nama'];
        $vrfWbs_idWBS = $data['vrfWbs_idWBS'];
        try {
            $this->db->transaksi();
            if ($JM_ID == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode Invalid !',
                );
                return $callback;
                exit;
            }
            if ($vrfWbs_Nama == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Nama WBS Invalid !',
                );
                return $callback;
                exit;
            }
            if ($vrfWbs_idWBS == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'ID WBS Invalid !',
                );
                return $callback;
                exit;
            }
            $batal="1";
            $this->db->query("UPDATE P_P_WBS_BOQ SET TASK_STATUS=:batal
                                WHERE ID=:JM_ID");
            $this->db->bind('batal', $batal);
            $this->db->bind('JM_ID', $JM_ID); 
            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success     
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            return $e;
            exit;
        }
    }
    public function BatalImportWBS($data)
    {
        $upldwbs_IDtrsBOQ = $data['upldwbs_IDtrs'];
        $upldwbs_IDtrsHDR = $data['upldwbs_IDtrs'];
        $batalP_P_WBS_BOQ = "0";
        $batalP_P_WBS_HDR = "1";
        try {
            $this->db->transaksi();
            if ($upldwbs_IDtrsBOQ == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode Invalid !',
                );
                return $callback;
                exit;
            }  
            $this->db->query("UPDATE P_P_WBS_BOQ SET TASK_STATUS=:batalP_P_WBS_BOQ
                            WHERE KODE_TRANSAKSI=:upldwbs_IDtrsBOQ");
            $this->db->bind('batalP_P_WBS_BOQ', $batalP_P_WBS_BOQ);
            $this->db->bind('upldwbs_IDtrsBOQ', $upldwbs_IDtrsBOQ);
            $this->db->execute();

            $datenowcreateFull = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $this->db->query(" UPDATE P_P_WBS_HDR SET BATAL=:batalP_P_WBS_HDR ,
                                DATE_BATAL=:datenowcreateFull,
                                PETUGAS_BATAL=:userid
                                WHERE KODE_TRANSAKSI=:upldwbs_IDtrsHDR");
            $this->db->bind('batalP_P_WBS_HDR', $batalP_P_WBS_HDR);
            $this->db->bind('datenowcreateFull', $datenowcreateFull);
            $this->db->bind('userid', $userid);
            $this->db->bind('upldwbs_IDtrsHDR', $upldwbs_IDtrsHDR);
            $this->db->execute();

            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success
                'message' => 'Data Berhasil dihapus !',    
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            return $e;
            exit;
        }
    }
    public function ShowDataTRsWBSUploadbyID($data)
    {
        try {
            $this->db->query("SELECT KODE_TRANSAKSI,replace(CONVERT(VARCHAR(11), DATE_START, 111), '/','-') DATE_START,
                            replace(CONVERT(VARCHAR(11), DATE_END, 111), '/','-') DATE_END,KD_JO KODE_JO
                            ,NM_PROJECT,ID_MOU,FN_DURASI,TOTAL_PEG
                            from P_P_WBS_HDR WHERE KODE_TRANSAKSI= :params ");
            $this->db->bind('params', $data['q']);
            $data =  $this->db->single();
            $pasing['KODE_TRANSAKSI'] = $data['KODE_TRANSAKSI'];
            $pasing['DATE_START'] = $data['DATE_START'];
            $pasing['DATE_END'] = $data['DATE_END'];
            $pasing['KODE_JO'] = $data['KODE_JO'];
            $pasing['NM_PROJECT'] = $data['NM_PROJECT'];

            $pasing['ID_MOU'] = $data['ID_MOU'];
            $pasing['FN_DURASI'] = $data['FN_DURASI'];
            $pasing['TOTAL_PEG'] = $data['TOTAL_PEG']; 
            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function FinishImportWBS($data)
    {
        $upldwbs_IDtrs = $data['upldwbs_IDtrs'];
        $upldwbs_idmou = $data['upldwbs_idmou'];
        $upldwbs_datestart = $data['upldwbs_datestart'];
        $upldwbs_dateend = $data['upldwbs_dateend'];
        $upldwbs_lokasi = $data['upldwbs_lokasi'];
        $upldwbs_namaproject = $data['upldwbs_namaproject'];
        $upldwbs_lokasi_nm = $data['upldwbs_lokasi_nm'];
        try {
            $this->db->transaksi();
            if ($upldwbs_idmou == "") {
                $callback = array(
                    'status' => 'warning',  'errorname' => 'Masukan ID MOU !',
                );
                return $callback;
                exit;
            }

            if ($upldwbs_datestart == "") {
                $callback = array(
                    'status' => 'warning',  'errorname' => 'Masukan Tanggal Awal Kontrak !',
                );
                return $callback;
                exit;
            }
            if ($upldwbs_dateend == "") {
                $callback = array(
                    'status' => 'warning',  
                    'errorname' => 'Masukan Tanggal Akhir Kontrak !',
                );
                return $callback;
                exit;
            }
            if ($upldwbs_lokasi == "") {
                $callback = array(
                    'status' => 'warning',  
                    'errorname' => 'Masukan Kode JO !',
                );
                return $callback;
                exit;
            }
            if ($upldwbs_namaproject == "") {
                $callback = array(
                    'status' => 'warning',  
                    'errorname' => 'Masukan Nama Project !',
                );
                return $callback;
                exit;
            }

            if ($upldwbs_lokasi_nm == "") {
                $callback = array(
                    'status' => 'warning',  
                    'errorname' => 'Masukan Nama Lokasi Project !',
                );
                return $callback;
                exit;
            }

            $this->db->query("SELECT KODE_TRANSAKSI FROM P_P_WBS_BOQ WHERE KODE_TRANSAKSI= :upldwbs_IDtrs ");
            $this->db->bind('upldwbs_IDtrs', $upldwbs_IDtrs); 
            $this->db->execute();
            $CountCol = $this->db->rowCount();
            if ($CountCol) {

                $this->db->query("SELECT count(pegawai) as jumlahPegawai from (
                        select   (pegawai) from (
                        select id_data pegawai from P_P_WBS_TIM where kode_transaksi=:upldwbs_IDtrs
                        union all
                        select KD_PEG pegawai from P_P_WBS_HDR_PEG where KODE_TRANSAKSI=:upldwbs_IDtrs2)x
                        group by  pegawai) x");
                $this->db->bind('upldwbs_IDtrs', $upldwbs_IDtrs);
                $this->db->bind('upldwbs_IDtrs2', $upldwbs_IDtrs); 
                $this->db->execute();
                $CountCol = $this->db->rowCount();
                $dataMP =  $this->db->single();
                $dataPeg =  $dataMP['jumlahPegawai'];
                if ($dataPeg > 0) {
                    $datenowcreateFull = Utils::seCurrentDateTime();
                    $session = SessionManager::getCurrentSession();
                    $DateStartWBS = strtotime($upldwbs_datestart);
                    $DateEndWBS = strtotime($upldwbs_dateend);
                    $interval = $DateEndWBS - $DateStartWBS;
                    $diffInDays    =  floor($interval / (60 * 60 * 24));
                    $userid = $session->username;
                    $DataPegawai =  $dataMP['jumlahPegawai'];
                    $this->db->query("UPDATE P_P_WBS_HDR SET  ID_MOU = :upldwbs_idmou,KD_JO = :upldwbs_lokasi ,
                          NM_PROJECT = :upldwbs_namaproject, LOKASI_KERJA = :upldwbs_lokasi_nm ,
                          DATE_START = :upldwbs_datestart ,DATE_END =:upldwbs_dateend ,FN_DURASI = :upldwbs_durasi,
                          TOTAL_PEG = :upldwbs_totalpegawai  
                          where KODE_TRANSAKSI = :upldwbs_IDtrs");
                    $this->db->bind('upldwbs_idmou', $upldwbs_idmou);
                    $this->db->bind('upldwbs_lokasi', $upldwbs_lokasi);
                    $this->db->bind('upldwbs_namaproject', $upldwbs_namaproject);
                    $this->db->bind('upldwbs_lokasi_nm', $upldwbs_lokasi_nm);
                    $this->db->bind('upldwbs_datestart', $upldwbs_datestart);
                    $this->db->bind('upldwbs_dateend', $upldwbs_dateend);
                    $this->db->bind('upldwbs_durasi', $diffInDays);
                    $this->db->bind('upldwbs_totalpegawai', $DataPegawai);
                    $this->db->bind('upldwbs_IDtrs', $upldwbs_IDtrs);

                    $this->db->execute();
                }else{
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Data Pegawai/TIM Masih Kosong, Silahkan Import Data Pegawai/Tim atau Hapus Transaksi !',
                    );
                    return $callback;
                    exit;
                }        
            } else {
                $callback = array(
                    'status' => 'warning', 
                    'errorname' => 'Data WBS Masih Kosong, Silahkan Import Data WBS atau Hapus Transaksi !',
                );
                return $callback;
                exit;
            } 
            $this->db->commit();
            $callback = array(
                'status' => 'update', // Set array status dengan success
                'message' => 'Data Berhasil Disimpan !',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            return $e;
            exit;
        }
    }
    public function uploadManHoursPlan($data)
    {
        $upldwbs_IDtrs = $data['upldwbs_IDtrs'];
        $upldwbs_datestart = $data['upldwbs_datestart'];
        $upldwbs_dateend = $data['upldwbs_dateend'];
        $upldwbs_lokasi = $data['upldwbs_lokasi'];
        $file =  $_FILES['file']['tmp_name'];

        // Jika user telah mengklik tombol Preview

        //$ip = ; // Ambil IP Address dari User
        $id = $data['upldwbs_IDtrs'];
        $nama_file_baru = $id . '_DailyManHoursPlan.xlsx';

        // Cek apakah terdapat file data.xlsx pada folder tmp
        if (is_file(__DIR__ . '/../../public' . '/tmp/' . $nama_file_baru)) // Jika file tersebut ada
            unlink(__DIR__ . '/../../public' . '/tmp/' . $nama_file_baru); // Hapus file tersebut

        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
        $tmp_file = $_FILES['file']['tmp_name'];

        // Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
        if ($ext == "xlsx") {
            // Upload file yang dipilih ke folder tmp
            // dan rename file tersebut menjadi data{ip_address}.xlsx
            // {ip_address} diganti jadi ip address user yang ada di variabel $ip
            // Contoh nama file setelah di rename : data127.0.0.1.xlsx
            if (move_uploaded_file($tmp_file,  __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru)) {
                $callback = array(
                    'status' => 'success',
                    'message' => ' Upload Data Succesfully. Please wait for Generating Data to Server.',
                );
                return $callback;
            } else {
                $callback = array(
                    'status' => 'warning',
                    'message' => 'Upload Failed.',
                );
                return $callback;
            }
            // Load librari PHPExcel nya
            // require_once '../../js/PHPExcel/PHPExcel.php'; 
            // $excelreader = new PHPExcel_Reader_Excel2007();
            // $loadexcel = $excelreader->load('tmp/'.$nama_file_baru); // Load file yang tadi diupload ke folder tmp
            // $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true); 



        } else { // Jika file yang diupload bukan File Excel 2007 (.xlsx)
            // Munculkan pesan validasi 
            $callback = array(
                'status' => 'warning',
                'message' => ' Hanya File Excel 2007 (.xlsx) yang diperbolehkan.',
            );
            return $callback;
        }
    }
    public function genUploadDailyManHoursPlan($data)
    {
        $idx = $data['upldwbs_IDtrs'];
        $upldwbs_datestart = $data['upldwbs_datestart'];
        $upldwbs_dateend = $data['upldwbs_dateend'];
        $upldwbs_lokasi = $data['upldwbs_lokasi'];
        $upldwbs_idmou = $data['upldwbs_idmou'];

        $excelreader = new PHPExcel_Reader_Excel2007();
        $loadexcel = $excelreader->load(__DIR__ . '/../../public' . '/tmp/' . $idx . '_DailyManHoursPlan.xlsx'); // Load file excel yang tadi diupload ke folder tmp
        $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

        $numrow = 1;
        try {
            $this->db->transaksi();
            $this->db->query("DELETE P_P_WBS_DMH WHERE   KODE_TRANSAKSI=:idx");
            $this->db->bind('idx', $idx);
            $this->db->execute();

            foreach ($sheet as $row) { //
                // Ambil data pada excel sesuai Kolom
                $DATE_DMH = $row['A']; // Ambil data NIS
                $TOTAL_MH_PAN = $row['B']; // Ambil data nama
                $CUMM_MH_PLAN = $row['C']; // Ambil data jenis kelamin 

                // Cek jika semua data tidak diisi
                if ($DATE_DMH == "" && $TOTAL_MH_PAN == "" && $CUMM_MH_PLAN == "")
                    continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)
                // Cek jika semua data tidak diisi
                // if($hidden_nis == "" && $hidden_nama == "" && $hidden_jkelamin == "" && $hidden_tlp == "" && $hidden_alamat == "" && $hidden_tipeID == "" && $hidden_tptlahir == "" && $hidden_handphone == "" && $hidden_pekerjaan == "")
                //  continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

                // Cek $numrow apakah lebih dari 1
                // Artinya karena baris pertama adalah nama-nama kolom
                // Jadi dilewat saja, tidak usah diimport 
                if ($numrow > 1) {
                            $this->db->query("INSERT INTO P_P_WBS_DMH
                            (KODE_TRANSAKSI,Date_DMH,Total_MH,Cumm_MH) 
                            values
                            (:idx,:DATE_DMH,:TOTAL_MH_PAN,:CUMM_MH_PLAN)");
                            $this->db->bind('idx', $idx);
                            $this->db->bind('DATE_DMH', $DATE_DMH);
                            $this->db->bind('TOTAL_MH_PAN', $TOTAL_MH_PAN);
                            $this->db->bind('CUMM_MH_PLAN', $CUMM_MH_PLAN); 
                            $this->db->execute();
                }
                $numrow++; // Tambah 1 setiap kali looping
            }   //   - end looping  
            $this->db->commit();
        } catch (PDOException $e) {
            $this->db->rollback();
            unlink(__DIR__ . '/../../public' . '/tmp/' . $idx . '_DailyManHoursPlan.xlsx'); // Hapus file tersebut
            $callback = array(
                'status' => 'error', // Set array status dengan success   
                'errormessage' => $e, // Set array status dengan success    
            );
            return $callback;
            exit;
        }



        unlink(__DIR__ . '/../../public' . '/tmp/' . $idx . '_DailyManHoursPlan.xlsx'); // Hapus file tersebut
        $callback = array(
            'status' => 'success',
            'pesan' => 'Generate Data Sukses, Load Data. Please Wait...',
        );
        return $callback;
    }
    public function ShowlistDMHPlan($data)
    {
        try {
            $no = "1";
            $this->db->query("SELECT ID,KODE_TRANSAKSI,replace(CONVERT(VARCHAR(11),Date_DMH, 111), '/','-') as Date_DMH,
                            Total_MH,Cumm_MH
                            FROM P_P_WBS_DMH where KODE_TRANSAKSI=:VerifwbS_Kode
                            AND BATAL='0'");
            $this->db->bind('VerifwbS_Kode', $data['VerifwbS_Kode']);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['No'] = $no;
                $pasing['id'] = $key['ID'];
                $pasing['KODE_TRANSAKSI'] = $key['KODE_TRANSAKSI'];
                $pasing['Date_DMH'] = date('d/m/Y', strtotime($key['Date_DMH']));
                $pasing['Total_MH'] = $key['Total_MH'];
                $pasing['Cumm_MH'] = $key['Cumm_MH']; 
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function uploadDailyCostPlan($data)
    {
        $upldwbs_IDtrs = $data['upldwbs_IDtrs'];
        $upldwbs_datestart = $data['upldwbs_datestart'];
        $upldwbs_dateend = $data['upldwbs_dateend'];
        $upldwbs_lokasi = $data['upldwbs_lokasi'];
        $file =  $_FILES['file']['tmp_name'];

        // Jika user telah mengklik tombol Preview

        //$ip = ; // Ambil IP Address dari User
        $id = $data['upldwbs_IDtrs'];
        $nama_file_baru = $id . '_DailyCostPlan.xlsx';

        // Cek apakah terdapat file data.xlsx pada folder tmp
        if (is_file(__DIR__ . '/../../public' . '/tmp/' . $nama_file_baru)) // Jika file tersebut ada
            unlink(__DIR__ . '/../../public' . '/tmp/' . $nama_file_baru); // Hapus file tersebut

        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
        $tmp_file = $_FILES['file']['tmp_name'];

        // Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
        if ($ext == "xlsx") {
            // Upload file yang dipilih ke folder tmp
            // dan rename file tersebut menjadi data{ip_address}.xlsx
            // {ip_address} diganti jadi ip address user yang ada di variabel $ip
            // Contoh nama file setelah di rename : data127.0.0.1.xlsx
            if (move_uploaded_file($tmp_file,  __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru)) {
                $callback = array(
                    'status' => 'success',
                    'message' => ' Upload Data Succesfully. Please wait for Generating Data to Server.',
                );
                return $callback;
            } else {
                $callback = array(
                    'status' => 'warning',
                    'message' => 'Upload Failed.',
                );
                return $callback;
            }
            // Load librari PHPExcel nya
            // require_once '../../js/PHPExcel/PHPExcel.php'; 
            // $excelreader = new PHPExcel_Reader_Excel2007();
            // $loadexcel = $excelreader->load('tmp/'.$nama_file_baru); // Load file yang tadi diupload ke folder tmp
            // $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true); 



        } else { // Jika file yang diupload bukan File Excel 2007 (.xlsx)
            // Munculkan pesan validasi 
            $callback = array(
                'status' => 'warning',
                'message' => ' Hanya File Excel 2007 (.xlsx) yang diperbolehkan.',
            );
            return $callback;
        }
    }
    public function GenerateDataDailyCostPlan($data)
    {
        $idx = $data['upldwbs_IDtrs'];
        $upldwbs_datestart = $data['upldwbs_datestart'];
        $upldwbs_dateend = $data['upldwbs_dateend'];
        $upldwbs_lokasi = $data['upldwbs_lokasi'];
        $upldwbs_idmou = $data['upldwbs_idmou'];

        $excelreader = new PHPExcel_Reader_Excel2007();
        $loadexcel = $excelreader->load(__DIR__ . '/../../public' . '/tmp/' . $idx . '_DailyCostPlan.xlsx'); // Load file excel yang tadi diupload ke folder tmp
        $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

        $numrow = 1;
        try {
            $this->db->transaksi();
            $this->db->query("DELETE P_P_WBS_DCP WHERE   KODE_TRANSAKSI=:idx");
            $this->db->bind('idx', $idx);
            $this->db->execute();

            foreach ($sheet as $row) { //
                // Ambil data pada excel sesuai Kolom
                $DATE_DMH = $row['A']; // Ambil data NIS
                $TOTAL_MH_PAN = $row['B']; // Ambil data nama
                $CUMM_MH_PLAN = $row['C']; // Ambil data jenis kelamin 

                // Cek jika semua data tidak diisi
                if ($DATE_DMH == "" && $TOTAL_MH_PAN == "" && $CUMM_MH_PLAN == "")
                    continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)
                // Cek jika semua data tidak diisi
                // if($hidden_nis == "" && $hidden_nama == "" && $hidden_jkelamin == "" && $hidden_tlp == "" && $hidden_alamat == "" && $hidden_tipeID == "" && $hidden_tptlahir == "" && $hidden_handphone == "" && $hidden_pekerjaan == "")
                //  continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

                // Cek $numrow apakah lebih dari 1
                // Artinya karena baris pertama adalah nama-nama kolom
                // Jadi dilewat saja, tidak usah diimport 
                if ($numrow > 1) {
                    $this->db->query("INSERT INTO P_P_WBS_DCP
                            (KODE_TRANSAKSI,Date_DMH,Total_MH,Cumm_MH) 
                            values
                            (:idx,:DATE_DMH,:TOTAL_MH_PAN,:CUMM_MH_PLAN)");
                    $this->db->bind('idx', $idx);
                    $this->db->bind('DATE_DMH', $DATE_DMH);
                    $this->db->bind('TOTAL_MH_PAN', trim($TOTAL_MH_PAN));
                    $this->db->bind('CUMM_MH_PLAN', trim($CUMM_MH_PLAN));
                    $this->db->execute();
                }
                $numrow++; // Tambah 1 setiap kali looping
            }   //   - end looping  
            $this->db->commit();
        } catch (PDOException $e) {
            $this->db->rollback();
            unlink(__DIR__ . '/../../public' . '/tmp/' . $idx . '_DailyCostPlan.xlsx'); // Hapus file tersebut
            $callback = array(
                'status' => 'error', // Set array status dengan success   
                'errormessage' => $e, // Set array status dengan success    
            );
            return $callback;
            exit;
        }



        unlink(__DIR__ . '/../../public' . '/tmp/' . $idx . '_DailyCostPlan.xlsx'); // Hapus file tersebut
        $callback = array(
            'status' => 'success',
            'pesan' => 'Generate Data Sukses, Load Data. Please Wait...',
        );
        return $callback;
    }
    public function ShowlistDCPPlan($data)
    {
        try {
            $no = "1";
            $this->db->query("SELECT ID,KODE_TRANSAKSI,replace(CONVERT(VARCHAR(11),Date_DMH, 111), '/','-') as Date_DMH,
                            Total_MH,Cumm_MH
                            FROM P_P_WBS_DCP where KODE_TRANSAKSI=:VerifwbS_Kode
                            AND BATAL='0'");
            $this->db->bind('VerifwbS_Kode', $data['VerifwbS_Kode']);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['No'] = $no;
                $pasing['id'] = $key['ID'];
                $pasing['KODE_TRANSAKSI'] = $key['KODE_TRANSAKSI'];
                $pasing['Date_DMH'] = date('d/m/Y', strtotime($key['Date_DMH']));
                $pasing['Total_MH'] = $key['Total_MH'];
                $pasing['Cumm_MH'] = $key['Cumm_MH'];
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function uploadDailyProgressPlan($data)
    {
        $upldwbs_IDtrs = $data['upldwbs_IDtrs'];
        $upldwbs_datestart = $data['upldwbs_datestart'];
        $upldwbs_dateend = $data['upldwbs_dateend'];
        $upldwbs_lokasi = $data['upldwbs_lokasi'];
        $file =  $_FILES['file']['tmp_name'];

        // Jika user telah mengklik tombol Preview

        //$ip = ; // Ambil IP Address dari User
        $id = $data['upldwbs_IDtrs'];
        $nama_file_baru = $id . '_DailyProgressPlan.xlsx';

        // Cek apakah terdapat file data.xlsx pada folder tmp
        if (is_file(__DIR__ . '/../../public' . '/tmp/' . $nama_file_baru)) // Jika file tersebut ada
            unlink(__DIR__ . '/../../public' . '/tmp/' . $nama_file_baru); // Hapus file tersebut

        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
        $tmp_file = $_FILES['file']['tmp_name'];

        // Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
        if ($ext == "xlsx") {
            // Upload file yang dipilih ke folder tmp
            // dan rename file tersebut menjadi data{ip_address}.xlsx
            // {ip_address} diganti jadi ip address user yang ada di variabel $ip
            // Contoh nama file setelah di rename : data127.0.0.1.xlsx
            if (move_uploaded_file($tmp_file,  __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru)) {
                $callback = array(
                    'status' => 'success',
                    'message' => ' Upload Data Succesfully. Please wait for Generating Data to Server.',
                );
                return $callback;
            } else {
                $callback = array(
                    'status' => 'warning',
                    'message' => 'Upload Failed.',
                );
                return $callback;
            }
            // Load librari PHPExcel nya
            // require_once '../../js/PHPExcel/PHPExcel.php'; 
            // $excelreader = new PHPExcel_Reader_Excel2007();
            // $loadexcel = $excelreader->load('tmp/'.$nama_file_baru); // Load file yang tadi diupload ke folder tmp
            // $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true); 



        } else { // Jika file yang diupload bukan File Excel 2007 (.xlsx)
            // Munculkan pesan validasi 
            $callback = array(
                'status' => 'warning',
                'message' => ' Hanya File Excel 2007 (.xlsx) yang diperbolehkan.',
            );
            return $callback;
        }
    }
    public function GenerateDataDailyProgressingPlan($data)
    {
        $idx = $data['upldwbs_IDtrs'];
        $upldwbs_datestart = $data['upldwbs_datestart'];
        $upldwbs_dateend = $data['upldwbs_dateend'];
        $upldwbs_lokasi = $data['upldwbs_lokasi'];
        $upldwbs_idmou = $data['upldwbs_idmou'];

        $excelreader = new PHPExcel_Reader_Excel2007();
        $loadexcel = $excelreader->load(__DIR__ . '/../../public' . '/tmp/' . $idx . '_DailyProgressPlan.xlsx'); // Load file excel yang tadi diupload ke folder tmp
        $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

        $numrow = 1;
        try {
            $this->db->transaksi();
            $this->db->query("DELETE P_P_WBS_DPR WHERE   KODE_TRANSAKSI=:idx");
            $this->db->bind('idx', $idx);
            $this->db->execute();

            foreach ($sheet as $row) { //
                // Ambil data pada excel sesuai Kolom
                $DATE_DMH = $row['A']; // Ambil data NIS
                $TOTAL_MH_PAN = $row['B']; // Ambil data nama
                $CUMM_MH_PLAN = $row['C']; // Ambil data jenis kelamin 

                // Cek jika semua data tidak diisi
                if ($DATE_DMH == "" && $TOTAL_MH_PAN == "" && $CUMM_MH_PLAN == "")
                    continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)
                // Cek jika semua data tidak diisi
                // if($hidden_nis == "" && $hidden_nama == "" && $hidden_jkelamin == "" && $hidden_tlp == "" && $hidden_alamat == "" && $hidden_tipeID == "" && $hidden_tptlahir == "" && $hidden_handphone == "" && $hidden_pekerjaan == "")
                //  continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

                // Cek $numrow apakah lebih dari 1
                // Artinya karena baris pertama adalah nama-nama kolom
                // Jadi dilewat saja, tidak usah diimport 
                if ($numrow > 1) {
                    $this->db->query("INSERT INTO P_P_WBS_DPR
                            (KODE_TRANSAKSI,Date_DMH,Total_MH,Cumm_MH) 
                            values
                            (:idx,:DATE_DMH,:TOTAL_MH_PAN,:CUMM_MH_PLAN)");
                    $this->db->bind('idx', $idx);
                    $this->db->bind('DATE_DMH', $DATE_DMH);
                    $this->db->bind('TOTAL_MH_PAN', trim($TOTAL_MH_PAN));
                    $this->db->bind('CUMM_MH_PLAN', trim($CUMM_MH_PLAN));
                    $this->db->execute();
                }
                $numrow++; // Tambah 1 setiap kali looping
            }   //   - end looping  
            $this->db->commit();
        } catch (PDOException $e) {
            $this->db->rollback();
            unlink(__DIR__ . '/../../public' . '/tmp/' . $idx . '_DailyProgressPlan.xlsx'); // Hapus file tersebut
            $callback = array(
                'status' => 'error', // Set array status dengan success   
                'errormessage' => $e, // Set array status dengan success    
            );
            return $callback;
            exit;
        }



        unlink(__DIR__ . '/../../public' . '/tmp/' . $idx . '_DailyProgressPlan.xlsx'); // Hapus file tersebut
        $callback = array(
            'status' => 'success',
            'pesan' => 'Generate Data Sukses, Load Data. Please Wait...',
        );
        return $callback;
    }
    public function ShowlistDPRPlan($data)
    {
        try {
            $no = "1";
            $this->db->query("SELECT ID,KODE_TRANSAKSI,replace(CONVERT(VARCHAR(11),Date_DMH, 111), '/','-') as Date_DMH,
                            Total_MH,Cumm_MH
                            FROM P_P_WBS_DPR where KODE_TRANSAKSI=:VerifwbS_Kode
                            AND BATAL='0'");
            $this->db->bind('VerifwbS_Kode', $data['VerifwbS_Kode']);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['No'] = $no;
                $pasing['id'] = $key['ID'];
                $pasing['KODE_TRANSAKSI'] = $key['KODE_TRANSAKSI'];
                $pasing['Date_DMH'] = date('d/m/Y', strtotime($key['Date_DMH']));
                $pasing['Total_MH'] = $key['Total_MH'];
                $pasing['Cumm_MH'] = $key['Cumm_MH'];
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}