<?php


class Shift_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
 
    public function getAllShift()
    {
        try {
            $this->db->query("SELECT A.ID,A.KODE_SHIFT,NAMA_SHIFT,A.JAM_SHIFT_MASUK,A.JAM_SHIFT_KELUAR,B.NAMA_GROUP_SHIFT,
                            CASE WHEN A.AKTIF='1' THEN 'AKTIF' ELSE 'NON AKTIF' END AS AKTIF
                            FROM HR_Mst_MASTER_SHIFT_KERJA A
                            INNER JOIN HR_Mst_MASTER_SHIFT_GROUP B
                            ON A.KODE_GROUP_SHIFT = B.KODE_GROUP_SHIFT");
            return $this->db->resultSet();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function insert($data)
    {

        if ($data['Mst_KodeShift'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Kode Shift !',
            );
            return $callback;
            exit;
        }
        if ($data['Mst_NamaShift'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Nama Shift !',
            );
            return $callback;
            exit;
        }
        if ($data['Mst_JamAwal'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Jam Awal Shift !',
            );
            return $callback;
            exit;
        }
        if ($data['Mst_JamAkhir'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Jam Akhir Shift !',
            );
            return $callback;
            exit;
        }

        if ($data['masuk_kurang'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Nilai Masuk Kurang !',
            );
            return $callback;
            exit;
        }
        if ($data['masuk_lebih'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Nilai Masuk Lebih !',
            );
            return $callback;
            exit;
        }
        if ($data['keluar_kurang'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input kelaur Kurang !',
            );
            return $callback;
            exit;
        }
        if ($data['keluar_lebih'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input keluar Lebih !',
            );
            return $callback;
            exit;
        }
        $Mst_JamAwal = $data['Mst_JamAwal'] . ':00';
        $Mst_JamAkhir = $data['Mst_JamAkhir'] . ':00';
        $userid = "asd";
        date_default_timezone_set('Asia/Jakarta');
        $tgl_input = Utils::seCurrentDateTime();
        try {
            $this->db->transaksi();
            if ($data['IdTranasksi'] == "") {
                $this->db->query("INSERT INTO HR_Mst_MASTER_SHIFT_KERJA
                      (KODE_SHIFT,NAMA_SHIFT,JAM_SHIFT_MASUK,JAM_SHIFT_KELUAR,
                      KODE_GROUP_SHIFT,AKTIF,PETUGAS_ENTRY,TGL_ENTRY
                      ,MASUK_KURANG,MASUK_LEBIH,KELUAR_KURANG,KELUAR_LEBIH)
                    values
                    ( :Mst_KodeShift,:Mst_NamaShift,:Mst_JamAwal,:Mst_JamAkhir,
                      :Mst_KodeGroupShift,:MSt_Status,:userid,:tgl_input
                    ,:masuk_kurang,:masuk_lebih,:keluar_kurang,:keluar_lebih)");
                $this->db->bind('Mst_KodeShift', $data['Mst_KodeShift']);
                $this->db->bind('Mst_NamaShift', $data['Mst_NamaShift']);
                $this->db->bind('Mst_JamAwal', $Mst_JamAwal);
                $this->db->bind('Mst_JamAkhir', $Mst_JamAkhir);
                $this->db->bind('Mst_KodeGroupShift', $data['Mst_KodeGroupShift']);
                $this->db->bind('MSt_Status', $data['MSt_Status']);
                $this->db->bind('userid', $userid);
                $this->db->bind('tgl_input', $tgl_input); 
                $this->db->bind('masuk_kurang', $data['masuk_kurang']); 
                $this->db->bind('masuk_lebih', $data['masuk_lebih']); 
                $this->db->bind('keluar_kurang', $data['keluar_kurang']); 
                $this->db->bind('keluar_lebih', $data['keluar_lebih']); 
            } else {
                $this->db->query("UPDATE HR_Mst_MASTER_SHIFT_KERJA set  
                      KODE_SHIFT=:Mst_KodeShift,NAMA_SHIFT=:Mst_NamaShift,
                      JAM_SHIFT_MASUK=:Mst_JamAwal,JAM_SHIFT_KELUAR=:Mst_JamAkhir,
                      KODE_GROUP_SHIFT=:Mst_KodeGroupShift,AKTIF=:MSt_Status
                      ,MASUK_KURANG=:masuk_kurang,MASUK_LEBIH=:masuk_lebih,
                      KELUAR_KURANG=:keluar_kurang,KELUAR_LEBIH=:keluar_lebih
                      WHERE ID=:IdTranasksiAuto");
                $this->db->bind('Mst_KodeShift', $data['Mst_KodeShift']);
                $this->db->bind('Mst_NamaShift', $data['Mst_NamaShift']);
                $this->db->bind('Mst_JamAwal', $data['Mst_JamAwal']);
                $this->db->bind('Mst_JamAkhir', $data['Mst_JamAkhir']);
                $this->db->bind('Mst_KodeGroupShift', $data['Mst_KodeGroupShift']);
                $this->db->bind('MSt_Status', $data['MSt_Status']);
                $this->db->bind('masuk_kurang', $data['masuk_kurang']);
                $this->db->bind('masuk_lebih', $data['masuk_lebih']);
                $this->db->bind('keluar_kurang', $data['keluar_kurang']);
                $this->db->bind('keluar_lebih', $data['keluar_lebih']);
                $this->db->bind('IdTranasksiAuto', $data['IdTranasksiAuto']); 
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
    public function getShiftById($id)
    {
        $this->db->query('SELECT A.ID,A.KODE_SHIFT,NAMA_SHIFT,substring(A.JAM_SHIFT_MASUK,1,5) as JAM_SHIFT_MASUK,
                 substring(A.JAM_SHIFT_KELUAR,1,5) as JAM_SHIFT_KELUAR,B.NAMA_GROUP_SHIFT,
                            A.AKTIF ,B.KODE_GROUP_SHIFT,A.MASUK_KURANG,A.MASUK_LEBIH,A.KELUAR_KURANG,A.KELUAR_LEBIH
                          FROM HR_Mst_MASTER_SHIFT_KERJA A
                          INNER JOIN HR_Mst_MASTER_SHIFT_GROUP B
                          ON A.KODE_GROUP_SHIFT = B.KODE_GROUP_SHIFT
                          where a.ID=:id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }
    public function getShiftkerjaAllAktif($data)
    {
        try { 
            $aktif = "1";
            $this->db->query("SELECT KODE_SHIFT,NAMA_SHIFT,JAM_SHIFT_MASUK,JAM_SHIFT_KELUAR
                                FROM HR_Mst_MASTER_SHIFT_KERJA
                                where AKTIF=:aktif");
            $this->db->bind('aktif', $aktif); 
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['KODE_SHIFT'] = $key['KODE_SHIFT'];
                $pasing['NAMA_SHIFT'] = $key['NAMA_SHIFT'];
                $pasing['JAM_SHIFT_MASUK'] = $key['JAM_SHIFT_MASUK'];
                $pasing['JAM_SHIFT_KELUAR'] = $key['JAM_SHIFT_KELUAR'];
                $rows[] = $pasing;
                $array['getJadwal'] = $rows; 
            }
            return $array;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
}
