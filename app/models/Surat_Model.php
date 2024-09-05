<?php


class Surat_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function showSuratById($data)
    {
        try {
            $this->db->query("SELECT A.ID, a.NoCuti,A.ID_Data as IdPegawai, B.Nama, JumlahHariCuti,
                            replace(CONVERT(VARCHAR(11), TglCutiAkhir, 111), '/','-') as TglCutiAkhir,
                            replace(CONVERT(VARCHAR(11), TglCutiAwal, 111), '/','-') as  TglCutiAwal,
                            Group_Cuti,A.AlasanCuti,a.ID_Lokasi,a.JenisCuti
                            FROM HR_Trs_Cuti A
                            INNER JOIN [HR_Data Pegawai] B ON A.ID_Data = B.ID_Data
                            WHERE a.ID=:params");
            $this->db->bind('params', $data['id']);
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success',
                'ID' => $data['ID'],
                'NoCuti' => $data['NoCuti'],
                'IdPegawai' => $data['IdPegawai'],
                'JumlahHariCuti' => $data['JumlahHariCuti'],
                'TglCutiAkhir' => $data['TglCutiAkhir'],
                'TglCutiAwal' => $data['TglCutiAwal'],
                'Group_Cuti' => $data['Group_Cuti'],
                'AlasanCuti' => $data['AlasanCuti'],
                'ID_Lokasi' => $data['ID_Lokasi'],
                'JenisCuti' => $data['JenisCuti'],
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function showDataTrsSuratAll($data)
    {
        try {
            $batal = "0";
            $this->db->query("SELECT A.ID, a.NoCuti,A.ID_Data, B.Nama, JumlahHariCuti,
                            replace(CONVERT(VARCHAR(11), TglCutiAkhir, 111), '/','-') as TglCutiAkhir,
                            replace(CONVERT(VARCHAR(11), TglCutiAwal, 111), '/','-') as  TglCutiAwal,
                            CASE WHEN 
                            Group_Cuti='S' THEN 'SAKIT' WHEN Group_Cuti='I' THEN 'IZIN'  WHEN Group_Cuti='A' THEN 'ALFA' ELSE 'CUTI' END as Group_Cuti,A.AlasanCuti,c.NM_LOKASI
                            FROM HR_Trs_Cuti A
                            INNER JOIN [HR_Data Pegawai] B ON A.ID_Data = B.ID_Data
                            INNER JOIN P_M_LOKASI C ON C.KD_LOKASI = a.ID_Lokasi
                            WHERE FB_Batal=:batal");
            $this->db->bind('batal', $batal);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['NoCuti'] = $key['NoCuti'];
                $pasing['Nama'] = $key['Nama'];
                $pasing['TglCutiAwal'] = date('d/m/Y', strtotime($key['TglCutiAwal']));
                $pasing['TglCutiAkhir'] = date('d/m/Y', strtotime($key['TglCutiAkhir']));
                $pasing['JumlahHariCuti'] = $key['JumlahHariCuti'];
                $pasing['Group_Cuti'] = $key['Group_Cuti'];
                $pasing['AlasanCuti'] = $key['AlasanCuti'];
                $pasing['NM_LOKASI'] = $key['NM_LOKASI'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getJenisCuti($data)
    {
        try {
            $aktif = "1";
            $this->db->query("SELECT KODE_CUTI,NAMA_CUTI FROM HR_Mst_MASTER_CUTI WHERE FB_AKTIF=:aktif");
            $this->db->bind('aktif', $aktif);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['KODE_CUTI'] = $key['KODE_CUTI'];
                $pasing['NAMA_CUTI'] = $key['NAMA_CUTI'];
                $rows[] = $pasing;
                $array['getJenisCuti'] = $rows; 
            }
            return $array;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function CreateTrsCuti($data){
        $IdTranasksi = $data['IdTranasksi'];
        $IdTranasksiAuto = $data['IdTranasksiAuto'];
        $id_karyawan = $data['Hr_Nama_Pegawai'];
        $tglcutiawal = $data['Hr_tglcuti_awal'];
        $tglcutiakhir = $data['Hr_tglcuti_akhir'];
        $jumlahcuti = $data['Hr_jumlah_cuti'];
        $jeniscuti = $data['Hr_JenisCuti'];
        $alasancuti = $data['catatan'];
        $TipeTransaksi = $data['Hr_TipeTransaksi'];
        $Hr_ID_Lokasi = $data['Hr_ID_Lokasi'];
        $nocuti = Utils::idtrsByDatetime();
        $tgl_input = Utils::seCurrentDateTime();
        $session = SessionManager::getCurrentSession();
        $userid = $session->username;
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
        if ($TipeTransaksi == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Tipe Transaksi !',
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
        if ($tglcutiakhir == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Tanggal Akhir Transaksi !',
            );
            return $callback;
            exit;
        }
        if ($alasancuti == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Alasan Cuti !',
            );
            return $callback;
            exit;
        }
        if ($TipeTransaksi == "S") {
            $namaizin = "SAKIT";
        } elseif ($TipeTransaksi == "I") {
            $namaizin = "IZIN";
        } elseif ($TipeTransaksi == "C") {
            $namaizin = "IZIN";
        }  
        $nullable ="";
        try {
            $this->db->transaksi();
            $this->db->query("SELECT * from HR_Mst_JADWAL_SHIFT_KERJA 
                        where TGL_JADWAL BETWEEN :tglcutiawal AND :tglcutiakhir
                        and KODE_LOKASI=:Hr_ID_Lokasi and KODE_PEGAWAI=:id_karyawan ");
            $this->db->bind('tglcutiawal', $tglcutiawal);
            $this->db->bind('tglcutiakhir', $tglcutiakhir);
            $this->db->bind('Hr_ID_Lokasi', $Hr_ID_Lokasi);
            $this->db->bind('id_karyawan', $id_karyawan); 
            $this->db->execute();
            $datarow = $this->db->rowCount();
            $ketstaus = "New";
            if($datarow){
                if ($data['IdTranasksi'] == "") {
                    $this->db->query("INSERT INTO HR_Trs_Cuti
                            (NoCuti,ID_Data,TglCutiAwal,
                            TglCutiAkhir,JumlahHariCuti,JenisCuti,
                            AlasanCuti,Status,UserInput,Tgl_Input
                            ,ID_Lokasi,Group_Cuti)
                            values
                            (:nocuti,:id_karyawan,
                            :tglcutiawal,:tglcutiakhir,:jumlahcuti,:jeniscuti,
                            :alasancuti,:ketstaus,
                            :userid,:tgl_input,:Hr_ID_Lokasi,:TipeTransaksi)  ");
                    $this->db->bind('nocuti', $nocuti);
                    $this->db->bind('id_karyawan', $id_karyawan);
                    $this->db->bind('Hr_ID_Lokasi', $Hr_ID_Lokasi);
                    $this->db->bind('tglcutiawal', $tglcutiawal);
                    $this->db->bind('tglcutiakhir', $tglcutiakhir);
                    $this->db->bind('jumlahcuti', $jumlahcuti);
                    $this->db->bind('jeniscuti', $jeniscuti);
                    $this->db->bind('alasancuti', $alasancuti); 
                    $this->db->bind('ketstaus', $ketstaus);
                    $this->db->bind('Hr_ID_Lokasi', $Hr_ID_Lokasi); 
                    $this->db->bind('userid', $userid);
                    $this->db->bind('tgl_input', $tgl_input);
                    $this->db->bind('TipeTransaksi', $TipeTransaksi);
                    $this->db->execute();

                    $this->db->query("UPDATE HR_Mst_JADWAL_SHIFT_KERJA SET
                                    KODE_EXCHANGE=:nocuti,PETUGAS_EXCHANGE=:userid, 
                                    KETERANGAN=:namaizin,NOTE=:namaizin2 
                                    WHERE KODE_LOKASI=:Hr_ID_Lokasi 
                                    AND KODE_PEGAWAI=:id_karyawan
                                    AND TGL_JADWAL BETWEEN :tglcutiawal AND :tglcutiakhir ");
                    $this->db->bind('nocuti', $nocuti);
                    $this->db->bind('userid', $userid); 
                    $this->db->bind('namaizin', $namaizin);
                    $this->db->bind('namaizin2', $namaizin);
                    $this->db->bind('Hr_ID_Lokasi', $Hr_ID_Lokasi); 
                    $this->db->bind('id_karyawan', $id_karyawan); 
                    $this->db->bind('tglcutiawal', $tglcutiawal);
                    $this->db->bind('tglcutiakhir', $tglcutiakhir);
                    $this->db->execute();
                } else {
                    $this->db->query("UPDATE HR_Trs_Cuti set 
                            TglCutiAwal=:tglcutiawal,
                            TglCutiAkhir=:tglcutiakhir,
                            JumlahHariCuti=:jumlahcuti,
                            JenisCuti=:jeniscuti,
                            AlasanCuti=:alasancuti,
                            ID_Lokasi=:Hr_ID_Lokasi,
                            Group_Cuti=:TipeTransaksi
                            WHERE ID=:IdTranasksiAuto");
                    $this->db->bind('Hr_ID_Lokasi', $Hr_ID_Lokasi);
                    $this->db->bind('tglcutiawal', $tglcutiawal);
                    $this->db->bind('tglcutiakhir', $tglcutiakhir);
                    $this->db->bind('jumlahcuti', $jumlahcuti);
                    $this->db->bind('jeniscuti', $jeniscuti);
                    $this->db->bind('alasancuti', $alasancuti);
                    $this->db->bind('TipeTransaksi', $TipeTransaksi);
                    $this->db->bind('IdTranasksiAuto', $IdTranasksiAuto);
                    $this->db->execute();

                    $this->db->query("UPDATE HR_Mst_JADWAL_SHIFT_KERJA 
                                SET KODE_EXCHANGE=:nullable1,PETUGAS_EXCHANGE=:nullable2, 
                                KETERANGAN=:nullable3,NOTE=:nullable4
                                WHERE KODE_EXCHANGE=:IdTranasksi");
                    $this->db->bind('nullable1', $nullable);
                    $this->db->bind('nullable2', $nullable);
                    $this->db->bind('nullable3', $nullable);
                    $this->db->bind('nullable4', $nullable); 
                    $this->db->bind('IdTranasksi', $IdTranasksi); 
                    $this->db->execute();

                    $this->db->query("UPDATE HR_Mst_JADWAL_SHIFT_KERJA SET
                                    KODE_EXCHANGE=:nocuti,PETUGAS_EXCHANGE=:userid, 
                                    KETERANGAN=:namaizin,NOTE=:namaizin2 
                                    WHERE KODE_LOKASI=:Hr_ID_Lokasi 
                                    AND KODE_PEGAWAI=:id_karyawan
                                    AND TGL_JADWAL BETWEEN :tglcutiawal AND :tglcutiakhir ");
                    $this->db->bind('nocuti', $nocuti);
                    $this->db->bind('userid', $userid);
                    $this->db->bind('namaizin', $namaizin);
                    $this->db->bind('namaizin2', $namaizin);
                    $this->db->bind('Hr_ID_Lokasi', $Hr_ID_Lokasi);
                    $this->db->bind('id_karyawan', $id_karyawan);
                    $this->db->bind('tglcutiawal', $tglcutiawal);
                    $this->db->bind('tglcutiakhir', $tglcutiakhir);
                    $this->db->execute();
                }
            }else {
                $callback = array(
                    'status' => 'warning', // Set array status dengan success   
                    'errorname' => 'Jadwal Belum Di Setup, Cek Jadwal !', // Set array status dengan success    
                );
                return $callback; 
            } 
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
    public function BatalSurat($data)
    {
        $IdTranasksi = $data['IdTranasksi'];
        $IdTranasksiAuto = $data['IdTranasksiAuto'];
        $id_karyawan = $data['Hr_Nama_Pegawai'];
        $tglcutiawal = $data['Hr_tglcuti_awal'];
        $tglcutiakhir = $data['Hr_tglcuti_akhir'];
        $jumlahcuti = $data['Hr_jumlah_cuti'];
        $jeniscuti = $data['Hr_JenisCuti'];
        $alasancuti = $data['catatan'];
        $TipeTransaksi = $data['Hr_TipeTransaksi'];
        $Hr_ID_Lokasi = $data['Hr_ID_Lokasi'];
        $tgl_input = date('Y-m-d H:i:s');
        $nocuti =  Utils::idtrsByDatetime();

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
        if ($TipeTransaksi == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Tipe Transaksi !',
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
        if ($tglcutiakhir == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Tanggal Akhir Transaksi !',
            );
            return $callback;
            exit;
        }
        if ($alasancuti == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Alasan Cuti !',
            );
            return $callback;
            exit;
        }  

        $batal = "1";
        $datenowcreate = Utils::seCurrentDateTime();
        $session = SessionManager::getCurrentSession();
        $userid = $session->username;
        $kosong = "";
        try {
            $this->db->transaksi();

            $this->db->query("UPDATE HR_Trs_Cuti SET 
                            FB_Batal=:batal , UserInputBatal=:userid,
                            Tgl_InputBatal=:datenowcreate WHERE ID=:IdTranasksiAuto");
            $this->db->bind('batal', $batal);
            $this->db->bind('userid', $userid);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('IdTranasksiAuto', $IdTranasksiAuto);
            $this->db->execute();

            $this->db->query("UPDATE HR_Mst_JADWAL_SHIFT_KERJA SET
                            KODE_EXCHANGE=:kosong1,PETUGAS_EXCHANGE=:kosong2, 
                            KETERANGAN=:kosong3,NOTE=:kosong4
                            WHERE KODE_EXCHANGE=:IdTranasksi");
            $this->db->bind('IdTranasksi', $IdTranasksi);
            $this->db->bind('kosong1', $kosong);
            $this->db->bind('kosong2', $kosong);
            $this->db->bind('kosong3', $kosong);
            $this->db->bind('kosong4', $kosong);
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
    
}
