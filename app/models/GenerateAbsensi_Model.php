<?php


class GenerateAbsensi_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function GenrateAbsensiAll($data)
    {
         
        try {
            $this->db->transaksi();

            $Hr_Periode = $data['Hr_Periode'];
            $Hr_Pilih_Lokasi = $data['Hr_Pilih_Lokasi'];
            $bulan = date('m', strtotime($Hr_Periode));
            $tahun = date('Y', strtotime($Hr_Periode));
            $jumHari =Utils::getDaysInMounth($bulan,$tahun);
            $periode1 = $Hr_Periode . '-01';
            $periode2 = $Hr_Periode . '-' . $jumHari;

            if ($Hr_Periode == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Periode Jadwal !',
                );
                return $callback;
                exit;
            }

            if ($Hr_Pilih_Lokasi == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Lokasi Project !',
                );
                return $callback;
                exit;
            }  
            $aktif="1";
            $this->db->query("SELECT top 1 ID_Data,Nama,kd_lokasi from (
                select a.ID_Data,a.Nama,b.kd_lokasi 
                from [HR_Data Pegawai] a 
                inner join [HR_Data_Status Pegawai] b on a.ID_Data=b.Id_Data
                where a.Status_Aktif=:aktif and left(b.Tgl_Akhir_Kontrak,7) >=:Hr_Periode1 
                and left(b.Tgl_Mulai_Kontrak,7) <=:Hr_Periode2
                group by a.ID_Data,a.Nama,b.kd_lokasi)x
                where convert(varchar(100),ID_Data) + convert(varchar(100),kd_lokasi) not in 
                (select convert(varchar(100),KODE_PEGAWAI) +convert(varchar(100),kd_lokasi) 
                from HR_Mst_JADWAL_SHIFT_KERJA where PERIODE =:Hr_Periode)
                order by 1 desc");
            $this->db->bind('Hr_Periode', $Hr_Periode);
            $this->db->bind('Hr_Periode1', $Hr_Periode);
            $this->db->bind('Hr_Periode2', $Hr_Periode);
            $this->db->bind('aktif', $aktif);
            $this->db->execute();
            $rowData = $this->db->rowCount();
            $data = $this->db->single();
            if ($rowData) {
                $callback = array(
                    'status' => 'warning',
                    'ID_Data' => $data['ID_Data'],
                    'Nama' => $data['Nama'],
                    'kd_lokasi' => $data['kd_lokasi'],
                );
                return $callback;
                exit;
            }
            $this->db->query("DELETE HR_GEN_ABSENSI 
                            WHERE PERIODE=:Hr_Periode 
                            AND KODE_LOKASI=:Hr_Pilih_Lokasi");
            $this->db->bind('Hr_Periode', $Hr_Periode);
            $this->db->bind('Hr_Pilih_Lokasi', $Hr_Pilih_Lokasi); 
            $this->db->execute();

            $this->db->query("EXEC GenerateAbsensi  
                            @Periode1 =:periode1,@Periode2 =:periode2,
                            @PeriodeBln =:Hr_Periode,@IdLokasi=:Hr_Pilih_Lokasi");
            $this->db->bind('periode1', $periode1);
            $this->db->bind('periode2', $periode2);
            $this->db->bind('Hr_Periode', $Hr_Periode);
            $this->db->bind('Hr_Pilih_Lokasi', $Hr_Pilih_Lokasi);
            $this->db->execute();

            $this->db->commit();

            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'notrs' => 'Transkasi Berhasil Disimpan !',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function ShowDataAfterGenerate($data)
    {
        $periode = $data['Hr_Periode'];
        $Hr_Pilih_Lokasi = $data['Hr_Pilih_Lokasi'];
        $nulable = '';
        try {
            $this->db->query("SELECT TGL_JADWAL,FS_KD_SHIFT,JAM_SHIFT_MASUK,
                          JAM_SHIFT_KELUAR,JAM_ABSEN_MASUK,JAM_ABSEN_KELUAR,
                          JML_TELAT,JML_PULANG_DULU,KODE_CUTI,c.NM_LOKASI,a.NOTE,d.Nama
                          from HR_GEN_ABSENSI a
                          INNER JOIN P_M_LOKASI C ON C.KD_LOKASI = A.KODE_LOKASI
                          INNER JOIN [HR_Data Pegawai] D ON D.ID_Data = A.KODE_PEGAWAI
                          WHERE PERIODE=:periode AND C.KD_LOKASI=:Hr_Pilih_Lokasi AND KODE_SPL=:nulable ");
            $this->db->bind('periode', $periode);
            $this->db->bind('Hr_Pilih_Lokasi', $Hr_Pilih_Lokasi);
            $this->db->bind('nulable', $nulable);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = "1";
            foreach ($data as $key) {
                $namahari = date('l', strtotime($key['TGL_JADWAL']));
                $pasing['KODE_SHIFT_KERJA'] = $key['FS_KD_SHIFT'];
                $pasing['TGL_JADWAL'] = date('d/m/Y', strtotime($key['TGL_JADWAL']));
                $pasing['JAM_ABSEN_MASUK'] = $key['JAM_ABSEN_MASUK'];
                $pasing['JAM_ABSEN_KELUAR'] = $key['JAM_ABSEN_KELUAR'];
                $pasing['JAM_SHIFT_MASUK'] = $key['JAM_SHIFT_MASUK'];
                $pasing['JAM_SHIFT_KELUAR'] = $key['JAM_SHIFT_KELUAR'];
                $pasing['JML_TELAT'] = $key['JML_TELAT'];
                $pasing['JML_PULANG_DULU'] = $key['JML_PULANG_DULU'];
                $pasing['NM_LOKASI'] = $key['NM_LOKASI'];
                $pasing['NOTE'] = $key['NOTE'];
                $pasing['Nama'] = $key['Nama'];
                $pasing['namahari'] = $namahari;
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function ShowDataAfterGeneratebyIdPegawai($data)
    {
        $periode = $data['Hr_Periode'];
        $Hr_Pilih_Lokasi = $data['Hr_Pilih_Lokasi'];
        $KODE_PEGAWAI = $data['Hr_Nama_Pegawai'];
        $nulable = '';
        try {
            $this->db->query("SELECT TGL_JADWAL,FS_KD_SHIFT,JAM_SHIFT_MASUK,
                          JAM_SHIFT_KELUAR,JAM_ABSEN_MASUK,JAM_ABSEN_KELUAR,
                          JML_TELAT,JML_PULANG_DULU,KODE_CUTI,c.NM_LOKASI,a.NOTE,d.Nama
                          from HR_GEN_ABSENSI a
                          INNER JOIN P_M_LOKASI C ON C.KD_LOKASI = A.KODE_LOKASI
                          INNER JOIN [HR_Data Pegawai] D ON D.ID_Data = A.KODE_PEGAWAI
                          WHERE PERIODE=:periode AND C.KD_LOKASI=:Hr_Pilih_Lokasi AND KODE_SPL=:nulable 
                           AND KODE_PEGAWAI=:KODE_PEGAWAI  ");
            $this->db->bind('periode', $periode);
            $this->db->bind('Hr_Pilih_Lokasi', $Hr_Pilih_Lokasi);
            $this->db->bind('nulable', $nulable);
            $this->db->bind('KODE_PEGAWAI', $KODE_PEGAWAI);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = "1";
            foreach ($data as $key) {
                $namahari = date('l', strtotime($key['TGL_JADWAL']));
                $pasing['KODE_SHIFT_KERJA'] = $key['FS_KD_SHIFT'];
                $pasing['TGL_JADWAL'] = date('d/m/Y', strtotime($key['TGL_JADWAL']));
                $pasing['JAM_ABSEN_MASUK'] = $key['JAM_ABSEN_MASUK'];
                $pasing['JAM_ABSEN_KELUAR'] = $key['JAM_ABSEN_KELUAR'];
                $pasing['JAM_SHIFT_MASUK'] = $key['JAM_SHIFT_MASUK'];
                $pasing['JAM_SHIFT_KELUAR'] = $key['JAM_SHIFT_KELUAR'];
                $pasing['JML_TELAT'] = $key['JML_TELAT'];
                $pasing['JML_PULANG_DULU'] = $key['JML_PULANG_DULU'];
                $pasing['NM_LOKASI'] = $key['NM_LOKASI'];
                $pasing['NOTE'] = $key['NOTE'];
                $pasing['Nama'] = $key['Nama'];
                $pasing['namahari'] = $namahari;
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}