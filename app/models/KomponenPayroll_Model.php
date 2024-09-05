<?php


class KomponenPayroll_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllKomponenPayroll()
    {
        try {
            $this->db->query("SELECT ID,NAMA_KOMPONEN,JENIS_KOMPONEN,NILAI_KOMPONEN,KETERANGAN_KOMPONEN,
                          CASE WHEN AKTIF='1' THEN 'AKTIF' ELSE 'NON AKTIF' END AS AKTIF
                          FROM HR_Mst_KOMPONEN_PAYROL");
            return $this->db->resultSet();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function insert($data)
    {

        if ($data['Mst_NamaKOmponen'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Nama Komponen Payroll !',
            );
            return $callback;
            exit;
        }
        if ($data['Mst_JenisKomponen'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Jenis Komponen Payroll !',
            );
            return $callback;
            exit;
        }
        if ($data['Mst_NilaiKomponen'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Nilai Komponen Payroll !',
            );
            return $callback;
            exit;
        }
        if ($data['Mst_NoUrut'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input No. Urut Komponen Payroll !',
            );
            return $callback;
            exit;
        }

        if ($data['Mst_Aktif'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Status Komponen Payroll !',
            );
            return $callback;
            exit;
        }
        if ($data['Mst_Catatan'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Catatan !',
            );
            return $callback;
            exit;
        }
         
        $userid = "asd";
        date_default_timezone_set('Asia/Jakarta');
        $tgl_input = Utils::seCurrentDateTime();
        try {
            $this->db->transaksi();
            if ($data['IdTranasksi'] == "") {
                $this->db->query("INSERT INTO HR_Mst_KOMPONEN_PAYROL
                      (NAMA_KOMPONEN,JENIS_KOMPONEN,NILAI_KOMPONEN,
                      KETERANGAN_KOMPONEN,PETUGAS_ENTRY,TGL_ENTRY,
                      AKTIF,NO_URUT,PINJAMAN_KANTOR)
                    values
                    ( :Mst_NamaKOmponen,:Mst_JenisKomponen,:Mst_NilaiKomponen,
                      :Mst_Catatan,:userid,:tgl_input,
                      :Mst_Aktif,:Mst_NoUrut,:pinjamkantor)");
                $this->db->bind('Mst_NamaKOmponen', $data['Mst_NamaKOmponen']);
                $this->db->bind('Mst_JenisKomponen', $data['Mst_JenisKomponen']);
                $this->db->bind('Mst_NilaiKomponen', $data['Mst_NilaiKomponen']);
                $this->db->bind('Mst_Catatan', $data['Mst_Catatan']);
                $this->db->bind('userid', $userid);
                $this->db->bind('tgl_input', $tgl_input);
                $this->db->bind('Mst_Aktif', $data['Mst_Aktif']);
                $this->db->bind('Mst_NoUrut', $data['Mst_NoUrut']);
                $this->db->bind('pinjamkantor', $data['Mst_isPinjaman']); 
            } else {
                $this->db->query("UPDATE HR_Mst_KOMPONEN_PAYROL set  NAMA_KOMPONEN=:Mst_NamaKOmponen,
                          JENIS_KOMPONEN=:Mst_JenisKomponen,
                          NILAI_KOMPONEN=:Mst_NilaiKomponen,
                          KETERANGAN_KOMPONEN=:Mst_Catatan,PETUGAS_ENTRY=:userid,TGL_ENTRY=:tgl_input,
                          AKTIF=:Mst_Aktif,NO_URUT=:Mst_NoUrut,PINJAMAN_KANTOR=:pinjamkantor
                          WHERE ID=:IdTranasksiAuto");
                $this->db->bind('Mst_NamaKOmponen', $data['Mst_NamaKOmponen']);
                $this->db->bind('Mst_JenisKomponen', $data['Mst_JenisKomponen']);
                $this->db->bind('Mst_NilaiKomponen', $data['Mst_NilaiKomponen']);
                $this->db->bind('Mst_Catatan', $data['Mst_Catatan']);
                $this->db->bind('userid', $userid);
                $this->db->bind('tgl_input', $tgl_input);
                $this->db->bind('Mst_Aktif', $data['Mst_Aktif']);
                $this->db->bind('Mst_NoUrut', $data['Mst_NoUrut']);
                $this->db->bind('IdTranasksiAuto', $data['IdTranasksiAuto']);
                $this->db->bind('pinjamkantor', $data['Mst_isPinjaman']); 
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
    public function getKomponenPayrollById($id)
    {
        $this->db->query('SELECT ID,NAMA_KOMPONEN,JENIS_KOMPONEN,NILAI_KOMPONEN,KETERANGAN_KOMPONEN,
                        AKTIF,NO_URUT
                        FROM HR_Mst_KOMPONEN_PAYROL
                        where ID=:id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }
}
