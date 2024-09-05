<?php


class Lembur_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function showDataTrsLemburAll($data)
    {
        try {
            $batal = "0";
            $this->db->query("SELECT A.ID, a.NoSPL,A.ID_Data, B.Nama, JumlahJamLembur,
                            replace(CONVERT(VARCHAR(11), TglLembur, 111), '/','-') as TglLembur,
                            CONVERT(VARCHAR(8),JamAwal,114) as JamAwal, CONVERT(VARCHAR(8),JamAkhir,114) as JamAkhir,A.AlasanLembur
                            FROM HR_Trs_Lembur A
                            INNER JOIN [HR_Data Pegawai] B ON A.ID_Data = B.ID_Data
                            WHERE FB_Batal=:batal");
            $this->db->bind('batal', $batal);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['NoSPL'] = $key['NoSPL'];
                $pasing['Nama'] = $key['Nama'];
                $pasing['TglLembur'] = date('d/m/Y', strtotime($key['TglLembur']));
                $pasing['JamAwal'] = $key['JamAwal'];
                $pasing['JamAkhir'] = $key['JamAkhir'];
                $pasing['JumlahJamLembur'] = $key['JumlahJamLembur'];
                $pasing['AlasanLembur'] = $key['AlasanLembur'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function showDataTrsLemburAllbyJO($data)
    {
        try {
            $batal = "0";
            $periode = $data['Hr_Periode'];
            $Payroll_Lokasi = $data['Payroll_Lokasi'];
            $this->db->query("SELECT a.ID, NoSPL,
                          CASE WHEN JenisLembur='1' THEN 'LEMBUR HARI BIASA' ELSE 'LEMBUR HARI LIBUR' END AS Jenislembur
                          ,a.ID_Data, ID_Lokasi,TglLembur,JamAwal,JamAkhir,JumlahJamLembur,AlasanLembur,c.NM_LOKASI
                          ,D.Nama
                          FROM HR_Trs_Lembur a
                          INNER JOIN P_M_LOKASI C ON C.KD_LOKASI = A.ID_Lokasi
                          INNER JOIN [HR_Data Pegawai] D ON D.ID_Data = A.ID_Data
                          where FB_Batal=:batal and SUBSTRING(TglLembur,1,7)=:periode
                          and ID_Lokasi=:Payroll_Lokasi");
            $this->db->bind('batal', $batal);
            $this->db->bind('periode', $periode);
            $this->db->bind('Payroll_Lokasi', $Payroll_Lokasi);
            $data =  $this->db->resultSet();
            $rows = array(); 
            foreach ($data as $key) {
                $pasing['NoSPL'] = $key['NoSPL'];
                $pasing['TglLembur'] = date('d/m/Y', strtotime($key['TglLembur']));
                $pasing['ID'] = $key['ID'];
                $pasing['Jenislembur'] = $key['Jenislembur'];
                $pasing['ID_Lokasi'] = $key['ID_Lokasi'];
                $pasing['JamAwal'] = $key['JamAwal'];
                $pasing['JamAkhir'] = $key['JamAkhir'];
                $pasing['JumlahJamLembur'] = $key['JumlahJamLembur'];
                $pasing['AlasanLembur'] = $key['AlasanLembur'];
                $pasing['NM_LOKASI'] = $key['NM_LOKASI'];
                $pasing['Nama'] = $key['Nama'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function showDataTrsLemburAllbyJOPeg($data)
    {
        try {
            $batal = "0";
            $periode = $data['Hr_Periode'];
            $Payroll_Lokasi = $data['Payroll_Lokasi'];
            $KODE_PEGAWAI = $data['Hr_Nama_Pegawai'];
            $this->db->query("SELECT a.ID, NoSPL,
                          CASE WHEN JenisLembur='1' THEN 'LEMBUR HARI BIASA' ELSE 'LEMBUR HARI LIBUR' END AS Jenislembur
                          ,a.ID_Data, ID_Lokasi,TglLembur,JamAwal,JamAkhir,JumlahJamLembur,AlasanLembur,c.NM_LOKASI
                          ,D.Nama
                          FROM HR_Trs_Lembur a
                          INNER JOIN P_M_LOKASI C ON C.KD_LOKASI = A.ID_Lokasi
                          INNER JOIN [HR_Data Pegawai] D ON D.ID_Data = A.ID_Data
                          where FB_Batal=:batal and SUBSTRING(TglLembur,1,7)=:periode
                          and ID_Lokasi=:Payroll_Lokasi  and D.ID_Data=:KODE_PEGAWAI ");
            $this->db->bind('batal', $batal);
            $this->db->bind('periode', $periode);
            $this->db->bind('Payroll_Lokasi', $Payroll_Lokasi);
            $this->db->bind('KODE_PEGAWAI', $KODE_PEGAWAI);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['NoSPL'] = $key['NoSPL'];
                $pasing['TglLembur'] = date('d/m/Y', strtotime($key['TglLembur']));
                $pasing['ID'] = $key['ID'];
                $pasing['Jenislembur'] = $key['Jenislembur'];
                $pasing['ID_Lokasi'] = $key['ID_Lokasi'];
                $pasing['JamAwal'] = $key['JamAwal'];
                $pasing['JamAkhir'] = $key['JamAkhir'];
                $pasing['JumlahJamLembur'] = $key['JumlahJamLembur'];
                $pasing['AlasanLembur'] = $key['AlasanLembur'];
                $pasing['NM_LOKASI'] = $key['NM_LOKASI'];
                $pasing['Nama'] = $key['Nama'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function ShowDatalemburByID($data){
        try {
            $this->db->query("SELECT *FROM HR_Trs_Lembur
                            WHERE  ID=:params");
            $this->db->bind('params', $data['id']);
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success',
                'ID' => $data['ID'],
                'NoSPL' => $data['NoSPL'],
                'JenisLembur' => $data['JenisLembur'],
                'ID_Data' => $data['ID_Data'],
                'ID_Lokasi' => $data['ID_Lokasi'],
                'TglLembur' => $data['TglLembur'],
                'JamAwal' => $data['JamAwal'],
                'JamAkhir' => $data['JamAkhir'],
                'JumlahJamLembur' => $data['JumlahJamLembur'],
                'AlasanLembur' => $data['AlasanLembur'],
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function CreateLembur($data)
    {

        $IdTranasksi = $_POST['IdTranasksi'];
        $IdTranasksiAuto = $_POST['IdTranasksiAuto'];
        $id_karyawan = $_POST['Hr_Nama_Pegawai'];
        $Hr_ID_Lokasi = $_POST['Hr_ID_Lokasi'];
        $tglcutiawal = $_POST['Hr_tglcuti_awal'];
        $Hr_Jam_Awal = $_POST['Hr_Jam_Awal'];
        $Hr_Jam_Akhir = $_POST['Hr_Jam_Akhir'];
        $Hr_jumlah_Lembur = $_POST['Hr_jumlah_Lembur'];
        $catatan = $_POST['catatan'];
        $Hr_Jenis_lembur = $_POST['Hr_Jenis_lembur'];
        $nospl = Utils::idtrsByDatetime();
        if ($id_karyawan == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Nama Karyawan !',
            );
            return $callback;
            exit;
        }
        if ($Hr_ID_Lokasi == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Lokasi Project !',
            );
            return $callback;
            exit;
        }
        if ($tglcutiawal == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Tanggal Awal Transaksi !',
            );
            return $callback;
            exit;
        }
        if ($Hr_Jam_Awal == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Jam Awal Transaksi !',
            );
            return $callback;
            exit;
        }
        if ($Hr_Jam_Akhir == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Jam Akhir Transaksi !',
            );
            return $callback;
            exit;
        }
        if ($Hr_jumlah_Lembur == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Jam Lembur 0, Silahkan Validasi kembali Data Jam Awal dan Jam Akhir !',
            );
            return $callback;
            exit;
        }
        if ($catatan == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Alasan Cuti !',
            );
            return $callback;
            exit;
        }
        if ($Hr_Jenis_lembur == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Jenis Lembur !',
            );
            return $callback;
            exit;
        }
        $fixHr_Jam_Awal = $Hr_Jam_Awal . ':00';
        $fixHr_Jam_Akhir = $Hr_Jam_Akhir . ':00';
        $tgl_input = Utils::seCurrentDateTime();
        $session = SessionManager::getCurrentSession();
        $userid = $session->username;
        try {
            $this->db->transaksi();
            if ($data['IdTranasksi'] == "") {
                $this->db->query("INSERT INTO HR_Trs_Lembur
                        (NoSPL,ID_Data, ID_Lokasi, TglLembur,
                        JamAwal,JamAkhir,JumlahJamLembur,AlasanLembur,
                        UserInput,Tgl_Input,JenisLembur)
                        values
                        (:nospl,:id_karyawan,:Hr_ID_Lokasi,:tglcutiawal,
                        :fixHr_Jam_Awal,:fixHr_Jam_Akhir,:Hr_jumlah_Lembur,:catatan,
                        :userid,:tgl_input,:Hr_Jenis_lembur)");
                $this->db->bind('nospl', $nospl);
                $this->db->bind('id_karyawan', $id_karyawan);
                $this->db->bind('Hr_ID_Lokasi', $Hr_ID_Lokasi);
                $this->db->bind('tglcutiawal', $tglcutiawal);
                $this->db->bind('fixHr_Jam_Awal', $fixHr_Jam_Awal);
                $this->db->bind('fixHr_Jam_Akhir', $fixHr_Jam_Akhir);
                $this->db->bind('Hr_jumlah_Lembur', $Hr_jumlah_Lembur); 
                $this->db->bind('catatan', $catatan);
                $this->db->bind('userid', $userid);
                $this->db->bind('tgl_input', $tgl_input);
                $this->db->bind('Hr_Jenis_lembur', $Hr_Jenis_lembur);
            } else {
                $this->db->query("UPDATE HR_Trs_Lembur set ID_Lokasi=:Hr_ID_Lokasi, 
                            TglLembur=:tglcutiawal,
                            JamAwal=:Hr_Jam_Awal,JamAkhir=:Hr_Jam_Akhir,
                            JumlahJamLembur=:Hr_jumlah_Lembur,
                            AlasanLembur=:catatan
                            WHERE ID=:IdTranasksiAuto");
                $this->db->bind('Hr_ID_Lokasi', $Hr_ID_Lokasi);
                $this->db->bind('tglcutiawal', $tglcutiawal);
                $this->db->bind('Hr_Jam_Awal', $Hr_Jam_Awal);
                $this->db->bind('Hr_Jam_Akhir', $Hr_Jam_Akhir);
                $this->db->bind('Hr_jumlah_Lembur', $Hr_jumlah_Lembur);
                $this->db->bind('catatan', $catatan);
                $this->db->bind('IdTranasksiAuto', $IdTranasksiAuto);
            }
            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function BatalLembur($data)
    {

        $IdTranasksi = $data['IdTranasksi'];
        $IdTranasksiAuto = $data['IdTranasksiAuto'];
        $id_karyawan = $data['Hr_Nama_Pegawai']; 
        $tglcutiawal = $data['Hr_tglcuti_awal'];
        $Hr_Jam_Awal = $data['Hr_Jam_Awal'];
        $Hr_Jam_Akhir = $data['Hr_Jam_Akhir'];
        $Hr_jumlah_Lembur = $data['Hr_jumlah_Lembur'];
        $catatan = $data['catatan'];
        $Hr_Jenis_lembur = $data['Hr_Jenis_lembur']; 
        $nospl = Utils::idtrsByDatetime();

        if ($id_karyawan == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Nama Karyawan !',
            );
            return $callback;
            exit;
        } 
        if ($tglcutiawal == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Tanggal Awal Transaksi !',
            );
            return $callback;
            exit;
        }
        if ($Hr_Jam_Awal == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Jam Awal Transaksi !',
            );
            return $callback;
            exit;
        }
        if ($Hr_Jam_Akhir == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Jam Akhir Transaksi !',
            );
            return $callback;
            exit;
        }
        if ($Hr_jumlah_Lembur == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Jam Lembur 0, Silahkan Validasi kembali Data Jam Awal dan Jam Akhir !',
            );
            return $callback;
            exit;
        }
        if ($catatan == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Alasan Cuti !',
            );
            return $callback;
            exit;
        }
        if ($Hr_Jenis_lembur == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Jenis Lembur !',
            );
            return $callback;
            exit;
        }  

        $fixHr_Jam_Awal = $Hr_Jam_Awal . ':00';
        $fixHr_Jam_Akhir = $Hr_Jam_Akhir . ':00';
        $batal="1";
        $datenowcreate = Utils::seCurrentDateTime();
        $session = SessionManager::getCurrentSession();
        $userid = $session->username;
        try {
            $this->db->transaksi();
            
            $this->db->query("UPDATE  HR_Trs_Lembur set FB_Batal=:batal,
                            UserInputBatal=:userid,Tgl_InputBatal=:datenowcreate
                            WHERE ID=:IdTranasksiAuto");
            $this->db->bind('batal', $batal);
            $this->db->bind('userid', $userid);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('IdTranasksiAuto', $IdTranasksiAuto); 
            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Dihapus !', // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function getDataJamLemburDefault($data)
    {
        try {
            if ($data['Hr_Nama_Pegawai'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Pilih Nama Pegawai !',
                );
                return $callback;
                exit;
            }
            if ($data['Hr_ID_Lokasi'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Pilih Kode JO !',
                );
                return $callback;
                exit;
            }
            if ($data['Hr_tglcuti_awal'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Pilih Tanggal Lembur !',
                );
                return $callback;
                exit;
            }



            $this->db->query("SELECT datename(dw,a.TGL_JADWAL) as namaHari,  
                            a.TGL_JADWAL+' '+b.JAM_SHIFT_MASUK as JAM_SHIFT_MASUK,
                            DATEADD(HOUR,1,a.TGL_JADWAL+' '+b.JAM_SHIFT_MASUK) as JAM_SHIFT_MASUK_AFTER,
                            a.TGL_JADWAL+' '+b.JAM_SHIFT_KELUAR as JAM_SHIFT_KELUAR,
                            DATEADD(HOUR,1,a.TGL_JADWAL+' '+b.JAM_SHIFT_KELUAR) as JAM_SHIFT_KELUAR_AFTER,
                            b.KODE_GROUP_SHIFT
                            FROM HR_Mst_JADWAL_SHIFT_KERJA a
                            INNER JOIN HR_Mst_MASTER_SHIFT_KERJA B
                            ON A.KODE_SHIFT_KERJA = B.KODE_SHIFT
                            where a.KODE_LOKASI=:Hr_ID_Lokasi AND a.TGL_JADWAL=:Hr_tglcuti_awal 
                            and a.KODE_PEGAWAI=:Hr_Nama_Pegawai");
            $this->db->bind('Hr_tglcuti_awal', $data['Hr_tglcuti_awal']);
            $this->db->bind('Hr_ID_Lokasi', $data['Hr_ID_Lokasi']);
            $this->db->bind('Hr_Nama_Pegawai', $data['Hr_Nama_Pegawai']);
            $data =  $this->db->single();

            $namaHari = $data['namaHari'];
            if($namaHari == "Saturday" or $namaHari == "Saturday"){
                $JamLemburAwal =  Utils::datenowcreateHourMinutes();
                $JamLemburAkhir = Utils::datenowcreateHourMinutes();
            }else{
                $JamLemburAwal = date('H:i', strtotime($data['JAM_SHIFT_MASUK_AFTER']));
                $JamLemburAkhir = date('H:i', strtotime($data['JAM_SHIFT_KELUAR_AFTER']));
            }
            $callback = array(
                'status' => 'success',
                'JAM_SHIFT_MASUK_AFTER' => $JamLemburAwal,
                'JAM_SHIFT_KELUAR_AFTER' =>  $JamLemburAkhir,
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
