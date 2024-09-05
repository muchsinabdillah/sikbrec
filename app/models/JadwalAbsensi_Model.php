<?php
class JadwalAbsensi_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function CreateJadwal($data)
    {

        $Hr_Nama_Pegawai = $data['Hr_Nama_Pegawai'];
        $Hr_LokasiProject = $data['Hr_LokasiProject']; 
        $Hr_Periode = $data['Hr_Periode'];
        $bulan = date('m', strtotime($Hr_Periode));
        $tahun = date('Y', strtotime($Hr_Periode));
        $jumHari = Utils::getDaysInMounth($bulan,$tahun);

        if ($Hr_Periode == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Periode Jadwal !',
            );
            return $callback;
            exit;
        }
        if ($Hr_Nama_Pegawai == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Nama Pegawai !',
            );
            return $callback;
            exit;
        }
        if ($Hr_LokasiProject == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Pilih Kode JO !',
            );
            return $callback;
            exit;
        } 
        try {
            $this->db->transaksi();
            // pindah
            $this->db->query("SELECT  *FROM HR_Mst_JADWAL_SHIFT_KERJA 
                                where SUBSTRING(TGL_JADWAL,1,7)=:Hr_Periode 
  				                and KODE_PEGAWAI=:Hr_Nama_Pegawai 
                                and KODE_LOKASI=:Hr_LokasiProject ");
            $this->db->bind('Hr_Periode', $Hr_Periode);
            $this->db->bind('Hr_Nama_Pegawai', $Hr_Nama_Pegawai);
            $this->db->bind('Hr_LokasiProject', $Hr_LokasiProject); 
            $this->db->execute();
            
            $data = $this->db->rowCount();
            if($data){
                $callback = array(
                    'status' => 'warning', // Set array status dengan success   
                    'errorname' => 'Sudah Ada Jadwal !'
                    // 'nama' => $data['nama'], // Set array nama dengan isi kolom nama pada tabel siswa    
                );
                return $callback;
            }else{
                // LOOPING
                $row = "1"; $kdx="";
                $datenowcreateFull = Utils::seCurrentDateTime();
                $session = SessionManager::getCurrentSession();
                $userid = $session->username;
                while ($row <= $jumHari) {
                    $daysOut = date('d', $row);
                    $tgl_jadwal_var = date('Y-m-d', strtotime($Hr_Periode . '-' . $row));
                    $this->db->query("INSERT INTO HR_Mst_JADWAL_SHIFT_KERJA
		                            (TGL_JADWAL,KODE_SHIFT_KERJA,KODE_PEGAWAI,
                                    TGL_SETUP,PETUGAS_SETUP,PERIODE,KODE_LOKASI)
		                            values
		                            (   :tgl_jadwal_var,:kdx,:Hr_Nama_Pegawai,
                                        :datenowcreateFull,:userid,
                                        :Hr_Periode,:Hr_LokasiProject ) ");
                    $this->db->bind('tgl_jadwal_var', $tgl_jadwal_var);
                    $this->db->bind('kdx', $kdx);
                    $this->db->bind('Hr_Nama_Pegawai', $Hr_Nama_Pegawai);
                    $this->db->bind('datenowcreateFull', $datenowcreateFull);
                    $this->db->bind('userid', $userid);
                    $this->db->bind('Hr_Periode', $Hr_Periode);
                    $this->db->bind('Hr_LokasiProject', $Hr_LokasiProject);
                    $this->db->execute();
                    $row++;
                }
            }
            $this->db->Commit(); 
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'notrs' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function ShowDataJadwalPegawai($data)
    {
        try {
            $periode = $data['Hr_Periode'];
            $KODE_PEGAWAI = $data['Hr_Nama_Pegawai'];
            $Hr_LokasiProject = $data['Hr_LokasiProject'];
 
            $batal = "0";
            $this->db->query("SELECT A.LIBUR,A.ID,A.TGL_JADWAL,A.KODE_SHIFT_KERJA,
            A.KETERANGAN,isnull(B.NAMA_SHIFT,'') as NAMA_SHIFT,
            isnull(B.JAM_SHIFT_MASUK,'') as JAM_SHIFT_MASUK,
            isnull(B.JAM_SHIFT_KELUAR,'') as JAM_SHIFT_KELUAR,C.NM_LOKASI
		    FROM HR_Mst_JADWAL_SHIFT_KERJA A
	        LEFT JOIN HR_Mst_MASTER_SHIFT_KERJA B ON A.KODE_SHIFT_KERJA = B.KODE_SHIFT
            LEFT JOIN P_M_LOKASI C ON C.KD_LOKASI = A.KODE_LOKASI
	        where SUBSTRING(A.TGL_JADWAL,1,7)=:periode and A.KODE_PEGAWAI=:KODE_PEGAWAI 
            AND A.KODE_LOKASI=:Hr_LokasiProject");
            $this->db->bind('periode', $periode);
            $this->db->bind('KODE_PEGAWAI', $KODE_PEGAWAI);
            $this->db->bind('Hr_LokasiProject', $Hr_LokasiProject);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $namahari = date('l', strtotime($key['TGL_JADWAL']));
                $pasing['ID'] = $key['ID'];
                $pasing['KODE_SHIFT_KERJA'] = $key['KODE_SHIFT_KERJA'];
                $pasing['TGL_JADWAL'] = date('d/m/Y', strtotime($key['TGL_JADWAL']));
                $pasing['KETERANGAN'] = $key['KETERANGAN'];
                $pasing['NAMA_SHIFT'] = $key['NAMA_SHIFT'];
                $pasing['LIBUR'] = $key['LIBUR'];
                $pasing['JAM_SHIFT_MASUK'] = $key['JAM_SHIFT_MASUK'];
                $pasing['JAM_SHIFT_KELUAR'] = $key['JAM_SHIFT_KELUAR'];
                $pasing['NM_LOKASI'] = $key['NM_LOKASI'];
                $pasing['namahari'] = $namahari; 
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function BatalUpdateLibur($data)
    {

        $argument = $data['argument'];

        if ($argument == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Masukan ID Transaksi !',
            );
            return $callback;
            exit;
        }

        try {
            $this->db->transaksi(); 
            $islibur="0";
            $free="";
            $this->db->query("UPDATE HR_Mst_JADWAL_SHIFT_KERJA 
                            SET LIBUR=:islibur, KODE_SHIFT_KERJA=:KODE_SHIFT_KERJA, 
                            NOTE=:NOTE,KETERANGAN=:KETERANGAN
                            where ID=:argument");
            $this->db->bind('argument', $argument);
            $this->db->bind('islibur', $islibur);
            $this->db->bind('KODE_SHIFT_KERJA', $free);
            $this->db->bind('NOTE', $free);
            $this->db->bind('KETERANGAN', $free); 
            $this->db->execute(); 
            $this->db->Commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'notrs' => 'Transkasi Berhasil Dihapus !', // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function UpdateLibur($data)
    { 
        $argument = $data['argument']; 
        if ($argument == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Masukan ID Transaksi !',
            );
            return $callback;
            exit;
        }

        try {
            $this->db->transaksi();
            $islibur = "1";
            $free = "";
            $note= "HARI LIBUR";
            $this->db->query("UPDATE HR_Mst_JADWAL_SHIFT_KERJA 
                            SET LIBUR=:islibur, KODE_SHIFT_KERJA=:KODE_SHIFT_KERJA, 
                            NOTE=:NOTE,KETERANGAN=:KETERANGAN
                            where ID=:argument");
            $this->db->bind('argument', $argument);
            $this->db->bind('islibur', $islibur);
            $this->db->bind('KODE_SHIFT_KERJA', $free);
            $this->db->bind('NOTE', $note);
            $this->db->bind('KETERANGAN', $note);
            $this->db->execute();
            $this->db->Commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'notrs' => 'Transkasi Berhasil !', // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function SendUpdateJadwal($data)
    {
        $Hr_PeriodeUPdt1 = $data['Hr_PeriodeUPdt1'];
        $Hr_PeriodeUPdt2 = $data['Hr_PeriodeUPdt2'];
        $Hr_LokasiProject_Updt = $data['Hr_LokasiProject_Updt'];
        $Hr_Kode_Shift = $data['Hr_Kode_Shift'];
        $Hr_Nama_Pegawai = $data['Hr_Nama_Pegawai'];

        if ($Hr_PeriodeUPdt1 == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Periode Jadwal Pertama !',
            );
            return $callback;
            exit;
        }
        if ($Hr_PeriodeUPdt2 == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Periode Jadwal Kedua !',
            );
            return $callback;
            exit;
        }
        if ($Hr_LokasiProject_Updt == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Lokasi Project !',
            );
            return $callback;
            exit;
        }
        if ($Hr_Kode_Shift == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Kode Shift !',
            );
            return $callback;
            exit;
        } 
        try {
            $this->db->transaksi();
            $libur = "0";
            $liburd = "1";
            $this->db->query("UPDATE HR_Mst_JADWAL_SHIFT_KERJA 
                                SET KODE_LOKASI=:Hr_LokasiProject_Updt,
		      					KODE_SHIFT_KERJA=:Hr_Kode_Shift,LIBUR=:libur 
 								WHERE TGL_JADWAL between :Hr_PeriodeUPdt1 
                                and :Hr_PeriodeUPdt2
 								and KODE_PEGAWAI=:Hr_Nama_Pegawai  
                                and KODE_LOKASI=:Hr_LokasiProject_Updt2");
            $this->db->bind('Hr_LokasiProject_Updt', $Hr_LokasiProject_Updt);
            $this->db->bind('Hr_Kode_Shift', $Hr_Kode_Shift);
            $this->db->bind('Hr_PeriodeUPdt1', $Hr_PeriodeUPdt1);
            $this->db->bind('Hr_PeriodeUPdt2', $Hr_PeriodeUPdt2);
            $this->db->bind('Hr_Nama_Pegawai', $Hr_Nama_Pegawai);
            $this->db->bind('libur', $libur);
            $this->db->bind('Hr_LokasiProject_Updt2', $Hr_LokasiProject_Updt);
            $this->db->execute();
            $this->db->query("SELECT KODE_GROUP_SHIFT 
                            from HR_Mst_MASTER_SHIFT_KERJA where KODE_SHIFT=:Hr_Kode_Shift");
            $this->db->bind('Hr_Kode_Shift', $Hr_Kode_Shift);
            $data =  $this->db->single();
            $pasKODE_GROUP_SHIFT = $data['KODE_GROUP_SHIFT'];
            if($pasKODE_GROUP_SHIFT =="001"){ 
                $this->db->query("UPDATE HR_Mst_JADWAL_SHIFT_KERJA 
                                SET LIBUR=:liburd 
 								WHERE TGL_JADWAL between :Hr_PeriodeUPdt1 
                                and :Hr_PeriodeUPdt2
 								and KODE_PEGAWAI=:Hr_Nama_Pegawai 
                                and datename(dw,TGL_JADWAL) in ('Saturday','Sunday')
                                and KODE_LOKASI=:Hr_LokasiProject_Updt2");  
                $this->db->bind('Hr_PeriodeUPdt1', $Hr_PeriodeUPdt1);
                $this->db->bind('Hr_PeriodeUPdt2', $Hr_PeriodeUPdt2);
                $this->db->bind('Hr_Nama_Pegawai', $Hr_Nama_Pegawai);
                $this->db->bind('liburd', $liburd);
                $this->db->bind('Hr_LokasiProject_Updt2', $Hr_LokasiProject_Updt);
                $this->db->execute();
            }elseif ($pasKODE_GROUP_SHIFT == "002") { 
                $this->db->query("UPDATE HR_Mst_JADWAL_SHIFT_KERJA 
                                SET LIBUR=:liburd 
 								WHERE TGL_JADWAL between :Hr_PeriodeUPdt1 
                                and :Hr_PeriodeUPdt2
 								and KODE_PEGAWAI=:Hr_Nama_Pegawai 
                                 and datename(dw,TGL_JADWAL) in ('Saturday')
                                and KODE_LOKASI=:Hr_LokasiProject_Updt2");  
                $this->db->bind('Hr_PeriodeUPdt1', $Hr_PeriodeUPdt1);
                $this->db->bind('Hr_PeriodeUPdt2', $Hr_PeriodeUPdt2);
                $this->db->bind('Hr_Nama_Pegawai', $Hr_Nama_Pegawai);
                $this->db->bind('liburd', $liburd);
                $this->db->bind('Hr_LokasiProject_Updt2', $Hr_LokasiProject_Updt);
                $this->db->execute();
            } 
            $this->db->Commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'notrs' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function getHariJadwalDokterCurrent($data)
    {
        try {
            $buah = $data["kode_prop"];
            $days = $data["days"]; 
                if ($days === "Minggu") {
                    $this->db->query("SELECT A.ID,A.First_Name 
                            from MasterdataSQL.dbo.Doctors A
                            INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
                            inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
                            WHERE A.active='1' AND B.IdLayanan=:idLayanan AND c.Minggu='1'  group by A.ID,A.First_Name ");
                } elseif ($days === "Senin") {
                    $this->db->query("SELECT A.ID,A.First_Name 
                            from MasterdataSQL.dbo.Doctors A
                            INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
                            inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
                            WHERE A.active='1' AND B.IdLayanan=:idLayanan AND c.Senin='1' group by A.ID,A.First_Name");
                } elseif ($days === "Selasa") {
                    $this->db->query("SELECT A.ID,A.First_Name 
                                from MasterdataSQL.dbo.Doctors A
                                INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
                                inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
                                WHERE A.active='1' AND B.IdLayanan=:idLayanan AND c.Selasa='1' group by A.ID,A.First_Name  ");
                } elseif ($days === "Rabu") {
                    $this->db->query("SELECT A.ID,A.First_Name 
                            from MasterdataSQL.dbo.Doctors A
                            INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
                            inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
                            WHERE A.active='1' AND B.IdLayanan=:idLayanan AND c.Rabu='1' group by A.ID,A.First_Name   ");
                } elseif ($days === "Kamis") {
                    $this->db->query("SELECT A.ID,A.First_Name 
                            from MasterdataSQL.dbo.Doctors A
                            INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
                            inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
                            WHERE A.active='1' AND B.IdLayanan=:idLayanan AND c.Kamis='1' group by A.ID,A.First_Name  ");
                } elseif ($days === "Jumat") {
                    $this->db->query("SELECT A.ID,A.First_Name 
                            from MasterdataSQL.dbo.Doctors A
                            INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
                            inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
                            WHERE A.active='1' AND B.IdLayanan=:idLayanan AND c.Jumat='1' group by A.ID,A.First_Name  ");
                } elseif ($days === "Sabtu") {
                    $this->db->query("SELECT A.ID,A.First_Name 
                            from MasterdataSQL.dbo.Doctors A
                            INNER JOIN MasterdataSQL.dbo.Doctors_2  B ON A.ID = B.IdDoctors
                            inner JOIN  MasterdataSQL.dbo.JadwalPraktek C ON C.IDDokter = A.ID
                            WHERE A.active='1' AND B.IdLayanan=:idLayanan AND c.Sabtu='1' group by A.ID,A.First_Name");
                }
                $this->db->bind('idLayanan', $buah); 
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['First_Name'] = $key['First_Name'];
                $rows[] = $pasing;
            }
            $callback = array(
                'message' => "success", // Set array nama 
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
}