<?php


class Pegawai_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getpegawaiAllAktif()
    {
        try { 
                $this->db->query("SELECT   ID_Data,Nama  
                                from [HR_Data Pegawai] where Status_Aktif='1'");
                $data =  $this->db->resultSet();
                $rows = array();
                $array = array();
                foreach ($data as $key) {
                    $pasing['ID_Data'] = $key['ID_Data'];
                    $pasing['Nama'] = $key['Nama']; 
                    $rows[] = $pasing;
                    $array['getpegawai'] = $rows;
                }
                $callback = array(
                    'status' => 'success', // Set array status dengan success
                    'data' => $array, // Set array status dengan success 
                );
                return $callback;
            
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getpegawaiAllAktif_New()
    {
        try {
            $this->db->query("SELECT   ID_Data,Nama
                                from HRDYARSI.dbo.[Data Pegawai]   where Status_Aktif='1'");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID_Data'] = $key['ID_Data'];
                $pasing['Nama'] = $key['Nama'];
                $rows[] = $pasing;
                $array['getpegawai'] = $rows;
            }
            $callback = array(
                'status' => 'success', // Set array status dengan success
                'data' => $array, // Set array status dengan success 
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getpegawaiAll()
    {
        try {
            $this->db->query("SELECT  ID_Data,Nip,Nama
                                from [HR_Data Pegawai]  ");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID_Data'] = $key['ID_Data'];
                $pasing['Nama'] = $key['Nama'];
                $pasing['Nip'] = $key['Nip'];
                $rows[] = $pasing; 
            } 
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function insert($data)
    {
        if ($data['upldwbs_ProjectM'] == "") {
            $callback = array(
                'status' => 'warning',  'errorname' => 'Silahkan Masukan Nama Pegawai !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($data['upldwbs_IDtrs'] == "") {
            $callback = array(
                'status' => 'warning',  'errorname' => 'Silahkan Masukan ID Transaksi / MOU !',
            );
            echo json_encode($callback);
            exit;
        }
        try {
            $this->db->transaksi();

            $this->db->query("SELECT ID FROM P_P_WBS_HDR_PEG 
                                WHERE KODE_TRANSAKSI=? AND KD_PEG=? AND TIPE_PEG=?");
            $this->db->bind(1, $data['upldwbs_IDtrs']);
            $this->db->bind(2, $data['upldwbs_ProjectM']);
            $this->db->bind(3, $data['jenispeg']);
            $this->db->execute();
            $rowData = $this->db->rowCount();
            if ($rowData) {
                $callback = array(
                    'status' => 'warning',  
                    'errorname' => 'Jenis Pegawai ' . $data['jenispeg'] .  ', 
                                    Nama Pegawai Sudah Pernah Di Input Sebelumnya, 
                                    Silahkan Cek Data Anda !',
                );
                return $callback;
                exit;
            }
                $this->db->query("INSERT into 
                                    P_P_WBS_HDR_PEG(KODE_TRANSAKSI,KD_PEG,TIPE_PEG) 
                                    values(?, ?, ?)");
                $this->db->bind(1, $data['upldwbs_IDtrs']);
                $this->db->bind(2, $data['upldwbs_ProjectM']);
                $this->db->bind(3, $data['jenispeg']); 
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
    public function showdataProjectM($data)
    {
        try {
            $GroupUser = "SITE_MANAGER"; $no="1";
            $this->db->query("SELECT A.ID,A.KODE_TRANSAKSI,A.KD_PEG,A.TIPE_PEG, B.Nama FROM P_P_WBS_HDR_PEG A 
                            INNER JOIN [HR_Data Pegawai] B ON A.KD_PEG = B.ID_Data  
                            WHERE A.KODE_TRANSAKSI = ? and A.TIPE_PEG = ? ");
            $this->db->bind(1, $data['upldwbs_IDtrs']);
            $this->db->bind(2, $GroupUser);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['No'] = $no;
                $pasing['ID'] = $key['ID']; 
                $pasing['Nama'] = $key['Nama'];
                $rows[] = $pasing;
                $array['showdataProjectM'] = $rows;
            }
            $callback = array(
                'status' => 'success', // Set array status dengan success
                'data' => $array, // Set array status dengan success 
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function delProjectM($data)
    {
        if ($data['iddetil'] == "") {
            $callback = array(
                'status' => 'warning',  
                'errorname' => 'Silahkan Masukan Id !',
            );
            return $callback;
            exit;
        } 
        try {
            $this->db->transaksi();
            $this->db->query("DELETE P_P_WBS_HDR_PEG where ID = ?  ");
            $this->db->bind(1, $data['iddetil']);
            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function showdataProjectPS($data)
    {
        try {
            $GroupUser = "PROJECT_SUPPORT";
            $no = "1";
            $this->db->query("SELECT A.ID,A.KODE_TRANSAKSI,A.KD_PEG,A.TIPE_PEG, B.Nama FROM P_P_WBS_HDR_PEG A 
                            INNER JOIN [HR_Data Pegawai] B ON A.KD_PEG = B.ID_Data  
                            WHERE A.KODE_TRANSAKSI = ? and A.TIPE_PEG = ? ");
            $this->db->bind(1, $data['upldwbs_IDtrs']);
            $this->db->bind(2, $GroupUser);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['No'] = $no;
                $pasing['ID'] = $key['ID'];
                $pasing['Nama'] = $key['Nama'];
                $rows[] = $pasing;
                $array['showdataProjectM'] = $rows;
            }
            $callback = array(
                'status' => 'success', // Set array status dengan success
                'data' => $array, // Set array status dengan success 
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function showdataProjectA($data)
    {
        try {
            $GroupUser = "PROJECT_ADMIN";
            $no = "1";
            $this->db->query("SELECT A.ID,A.KODE_TRANSAKSI,A.KD_PEG,A.TIPE_PEG, B.Nama FROM P_P_WBS_HDR_PEG A 
                            INNER JOIN [HR_Data Pegawai] B ON A.KD_PEG = B.ID_Data  
                            WHERE A.KODE_TRANSAKSI = ? and A.TIPE_PEG = ? ");
            $this->db->bind(1, $data['upldwbs_IDtrs']);
            $this->db->bind(2, $GroupUser);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['No'] = $no;
                $pasing['ID'] = $key['ID'];
                $pasing['Nama'] = $key['Nama'];
                $rows[] = $pasing;
                $array['showdataProjectA'] = $rows;
            }
            $callback = array(
                'status' => 'success', // Set array status dengan success
                'data' => $array, // Set array status dengan success 
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function showdataProjectSO($data)
    {
        try {
            $GroupUser = "SAFETY_OFFICER";
            $no = "1";
            $this->db->query("SELECT A.ID,A.KODE_TRANSAKSI,A.KD_PEG,A.TIPE_PEG, B.Nama FROM P_P_WBS_HDR_PEG A 
                            INNER JOIN [HR_Data Pegawai] B ON A.KD_PEG = B.ID_Data  
                            WHERE A.KODE_TRANSAKSI = ? and A.TIPE_PEG = ? ");
            $this->db->bind(1, $data['upldwbs_IDtrs']);
            $this->db->bind(2, $GroupUser);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['No'] = $no;
                $pasing['ID'] = $key['ID'];
                $pasing['Nama'] = $key['Nama'];
                $rows[] = $pasing;
                $array['showdataProjectSO'] = $rows;
            }
            $callback = array(
                'status' => 'success', // Set array status dengan success
                'data' => $array, // Set array status dengan success 
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function showdataProjectSPV($data)
    {
        try {
            $GroupUser = "SUPERVISOR";
            $no = "1";
            $this->db->query("SELECT A.ID,A.KODE_TRANSAKSI,A.KD_PEG,A.TIPE_PEG, B.Nama FROM P_P_WBS_HDR_PEG A 
                            INNER JOIN [HR_Data Pegawai] B ON A.KD_PEG = B.ID_Data  
                            WHERE A.KODE_TRANSAKSI = ? and A.TIPE_PEG = ? ");
            $this->db->bind(1, $data['upldwbs_IDtrs']);
            $this->db->bind(2, $GroupUser);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['No'] = $no;
                $pasing['ID'] = $key['ID'];
                $pasing['Nama'] = $key['Nama'];
                $rows[] = $pasing;
                $array['showdataProjectSPV'] = $rows;
            }
            $callback = array(
                'status' => 'success', // Set array status dengan success
                'data' => $array, // Set array status dengan success 
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function createPegawai($data)
    {
        try {
            $this->db->transaksi();
            $datenowcreate = Utils::seCurrentDateTime();
            $hrd_status = $data['hrd_status'];
            $hrd_id = $data['hrd_id'];
            $hrd_namapegawai = strtoupper($data['hrd_namapegawai']);
            $hrd_alamat = strtoupper($data['hrd_alamat']);
            $hrd_unitkerja = $data['hrd_unitkerja'];
            $hrd_jeniskelamin = $data['hrd_jeniskelamin'];
            $hrd_agama = $data['hrd_agama'];
            $Medical_Provinsi = $data['Medical_Provinsi'];
            $Medrec_Warganegara = $data['Medrec_Warganegara'];
            $Medrec_kabupaten = $data['Medrec_kabupaten'];
            $Medrec_Tpt_lahir = strtoupper($data['Medrec_Tpt_lahir']);
            $Medrec_Kecamatan = $data['Medrec_Kecamatan'];
            $Medrec_Tgl_Lahir = $data['Medrec_Tgl_Lahir'];
            $Medrec_Kelurahan = $data['Medrec_Kelurahan'];
            $Hrd_statusNikah = $data['Hrd_statusNikah'];
            $Medrec_Kodepos = $data['Medrec_Kodepos'];
            $hrd_HomePhone = $data['hrd_HomePhone'];
            $hrd_handphone = $data['hrd_handphone'];
            $hrd_Pendidikan = $data['hrd_Pendidikan'];
            $hrd_status_pajak = $data['hrd_status_pajak'];
            $hrd_jurusan = strtoupper($data['hrd_jurusan2']);
            $hrd_jmltanggungan = $data['hrd_jmltanggungan'];
            $hrd_npwp = $data['hrd_npwp'];
            $hrd_ktp = $data['hrd_ktp'];
            $hrd_bpjstk = $data['hrd_bpjstk'];
            $hrd_bpjs_kes = $data['hrd_bpjs_kes'];
            $hrd_norekenig = $data['hrd_norekenig'];
            $hrd_hakKelas = $data['hrd_hakKelas'];
            $hrd_namabank = $data['hrd_namabank'];
            //$hrd_noSIP = $data['hrd_noSIP'];  
            $hrd_str = $data['hrd_str'];
            $hrd_tglmasuk = $data['hrd_tglmasuk'];
            $hrd_plafonRajal = $data['hrd_plafonRajal'];
            $hrd_plafonRanap = $data['hrd_plafonRanap'];
            $hrd_nip = $data['hrd_nip'];
            $hrd_department = $data['hrd_department'];
            $hrd_jabatan = $data['hrd_jabatan'];
            $hrd_status_pegawai = $data['hrd_status_pegawai'];
            $hrd_hakKelas_PlafonRS = $data['hrd_hakKelas_PlafonRS'];
            $hrd_jmltanggungan = $data['hrd_jmltanggungan'];
            $hrd_keterangan_atributx = $data['hrd_keterangan_atributx'];
            $hrd_tgl_resign = $data['hrd_tgl_resign'];
            $hrd_keterangan_resign = $data['hrd_keterangan_resign'];
            $hrd_alamat_domisili = $data['hrd_alamat_domisili'];
            $hrd_tipeKaryawan = $data['hrd_tipeKaryawan'];
            if ($Medrec_Kecamatan == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Medrec_Kecamatan !',
                );
                return $callback;
                exit;
            }
            if ($Medrec_kabupaten == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Medrec_kabupaten !',
                );
                return $callback;
                exit;
            }
            $Universitas = "";
            $pendidikan_diakui = "";
            $Jml_Anak = "";
            if ($hrd_id == "") {

                $this->db->query("INSERT INTO  [HR_Data Pegawai]
                 (Nip,No_Rek,Nama,Jenis_Kelamin,
                  Tempat_Lahir,Tgl_Lahir,Alamat,Agama,
                  Pendidikan_Diakui,Pendidikan,Jurusan,Universitas,
                  No_KTP,Status_Menikah,Jml_Anak,[No_Telepon 1],[No_Telepon 2],
                  Departemen,Unit_1,Status_Aktif,Tgl_Masuk,
                  Tgl_Keluar,NoNPWP,StatusPajak,
                  Plafon_RJ,Plafon_RI,Status_Pegawai,Jabatan,
                  NoBPJSKesehatan,HakKelasBPJSKes,NoBPJSKetenagakerjaan,
                  NamaBank,HakKelasPlafonRS,Jml_Tanggungan,AlasanKeluar,Alamat_Domisili,Kelurahan,
                  Kecamatan,City,[State/Province],[ZIP/Postal Code],KD_JENIS_PEG) 
                  VALUES
                  (:hrd_nip,:hrd_norekenig,:hrd_namapegawai,:hrd_jeniskelamin,
                  :Medrec_Tpt_lahir,:Medrec_Tgl_Lahir,:hrd_alamat,:hrd_agama,
                  :pendidikan_diakui,:hrd_Pendidikan,:hrd_jurusan,:Universitas,
                  :hrd_ktp,:Hrd_statusNikah,:Jml_Anak,:hrd_handphone,:hrd_HomePhone2,
                  :hrd_department,:hrd_unitkerja,:hrd_status,:hrd_tglmasuk,
                  :hrd_tgl_resign,:hrd_npwp,:hrd_status_pajak,
                  :hrd_plafonRajal,:hrd_plafonRanap,:hrd_status_pegawai,:hrd_jabatan,
                  :hrd_bpjs_kes,:hrd_hakKelas,:hrd_bpjstk,
                  :hrd_namabank,:hrd_hakKelas_PlafonRS,:hrd_jmltanggungan,:hrd_keterangan_resign,
                  :hrd_alamat_domisili,:Medrec_Kelurahan,:Medrec_Kecamatan,
                  :Medrec_kabupaten,:Medical_Provinsi,:Medrec_Kodepos,:hrd_tipeKaryawan) ");
                $this->db->bind('hrd_nip', $hrd_nip);
                $this->db->bind('hrd_norekenig', $hrd_norekenig);
                $this->db->bind('hrd_namapegawai', $hrd_namapegawai);
                $this->db->bind('hrd_jeniskelamin', $hrd_jeniskelamin);
                $this->db->bind('Medrec_Tpt_lahir', $Medrec_Tpt_lahir);
                $this->db->bind('Medrec_Tgl_Lahir', $Medrec_Tgl_Lahir);
                $this->db->bind('hrd_alamat', $hrd_alamat);
                $this->db->bind('hrd_agama', $hrd_agama);
                $this->db->bind('pendidikan_diakui', $pendidikan_diakui);
                $this->db->bind('hrd_Pendidikan', $hrd_Pendidikan);
                $this->db->bind('hrd_jurusan', $hrd_jurusan);
                $this->db->bind('Universitas', $Universitas);
                $this->db->bind('hrd_ktp', $hrd_ktp);
                $this->db->bind('Hrd_statusNikah', $Hrd_statusNikah);
                $this->db->bind('Jml_Anak', $Jml_Anak);
                $this->db->bind('hrd_handphone', $hrd_handphone);
                $this->db->bind('hrd_HomePhone2', $hrd_HomePhone);
                $this->db->bind('hrd_department', $hrd_department);
                $this->db->bind('hrd_unitkerja', $hrd_unitkerja);
                $this->db->bind('hrd_status', $hrd_status);
                $this->db->bind('hrd_tglmasuk', $hrd_tglmasuk);
                $this->db->bind('hrd_tgl_resign', $hrd_tgl_resign);
                $this->db->bind('hrd_npwp', $hrd_npwp);
                $this->db->bind('hrd_status_pajak', $hrd_status_pajak);
                $this->db->bind('hrd_plafonRajal', $hrd_plafonRajal);
                $this->db->bind('hrd_plafonRanap', $hrd_plafonRanap);
                $this->db->bind('hrd_status_pegawai', $hrd_status_pegawai);
                $this->db->bind('hrd_jabatan', $hrd_jabatan);
                $this->db->bind('hrd_bpjs_kes', $hrd_bpjs_kes);
                $this->db->bind('hrd_hakKelas', $hrd_hakKelas);
                $this->db->bind('hrd_bpjstk', $hrd_bpjstk);
                $this->db->bind('hrd_namabank', $hrd_namabank);
                $this->db->bind('hrd_hakKelas_PlafonRS', $hrd_hakKelas_PlafonRS);
                $this->db->bind('hrd_jmltanggungan', $hrd_jmltanggungan);
                $this->db->bind('hrd_keterangan_resign', $hrd_keterangan_resign);
                $this->db->bind('hrd_alamat_domisili', $hrd_alamat_domisili);
                $this->db->bind('Medrec_Kelurahan', $Medrec_Kelurahan);
                $this->db->bind('Medrec_Kecamatan', $Medrec_Kecamatan);
                $this->db->bind('Medrec_kabupaten', $Medrec_kabupaten);
                $this->db->bind('Medical_Provinsi', $Medical_Provinsi);
                $this->db->bind('Medrec_Kodepos', $Medrec_Kodepos);
                $this->db->bind('hrd_tipeKaryawan', $hrd_tipeKaryawan);
            } else {
                $this->db->query(
                    "UPDATE  [HR_Data Pegawai] SET 
                 Nip=:hrd_nip,No_Rek=:hrd_norekenig,Nama=:hrd_namapegawai,Jenis_Kelamin=:hrd_jeniskelamin,
                  Tempat_Lahir=:Medrec_Tpt_lahir,Tgl_Lahir=:Medrec_Tgl_Lahir,Alamat=:hrd_alamat,
                  Agama=:hrd_agama,
                  Pendidikan_Diakui=:pendidikan_diakui,Pendidikan=:hrd_Pendidikan,
                  Jurusan=:hrd_jurusan,Universitas=:Universitas,
                  No_KTP=:hrd_ktp,Status_Menikah=:Hrd_statusNikah,Jml_Anak=:Jml_Anak,
                  [No_Telepon 1]=:hrd_handphone,
                  [No_Telepon 2]=:hrd_HomePhone2,
                  Departemen=:hrd_department,Unit_1=:hrd_unitkerja,Status_Aktif=:hrd_status,
                  Tgl_Masuk=:hrd_tglmasuk,
                  Tgl_Keluar=:hrd_tgl_resign,NoNPWP=:hrd_npwp,StatusPajak=:hrd_status_pajak,
                  Plafon_RJ=:hrd_plafonRajal,Plafon_RI=:hrd_plafonRanap,Status_Pegawai=:hrd_status_pegawai,
                  Jabatan=:hrd_jabatan,
                  NoBPJSKesehatan=:hrd_bpjs_kes,HakKelasBPJSKes=:hrd_hakKelas,
                  NoBPJSKetenagakerjaan=:hrd_bpjstk,
                  NamaBank=:hrd_namabank,HakKelasPlafonRS=:hrd_hakKelas_PlafonRS,
                  Jml_Tanggungan=:hrd_jmltanggungan,AlasanKeluar=:hrd_keterangan_resign,
                  Atribut_Pegawai_Kembali=:hrd_keterangan_atributx,Alamat_Domisili=:hrd_alamat_domisili,
                  Kelurahan=:Medrec_Kelurahan,
                  Kecamatan=:Medrec_Kecamatan,
                  City=:Medrec_kabupaten,[State/Province]=:Medical_Provinsi,
                  [ZIP/Postal Code]=:Medrec_Kodepos
                  ,KD_JENIS_PEG=:hrd_tipeKaryawan
                  WHERE ID_Data=:hrd_id "
                );
                $this->db->bind('hrd_nip', $hrd_nip);
                $this->db->bind('hrd_norekenig', $hrd_norekenig);
                $this->db->bind('hrd_namapegawai', $hrd_namapegawai);
                $this->db->bind('hrd_jeniskelamin', $hrd_jeniskelamin);
                $this->db->bind('Medrec_Tpt_lahir', $Medrec_Tpt_lahir);
                $this->db->bind('Medrec_Tgl_Lahir', $Medrec_Tgl_Lahir);
                $this->db->bind('hrd_alamat', $hrd_alamat);
                $this->db->bind('hrd_agama', $hrd_agama);
                $this->db->bind('pendidikan_diakui', $pendidikan_diakui);
                $this->db->bind('hrd_Pendidikan', $hrd_Pendidikan);
                $this->db->bind('hrd_jurusan', $hrd_jurusan);
                $this->db->bind('Universitas', $Universitas);
                $this->db->bind('hrd_ktp', $hrd_ktp);
                $this->db->bind('Hrd_statusNikah', $Hrd_statusNikah);
                $this->db->bind('Jml_Anak', $Jml_Anak);
                $this->db->bind('hrd_handphone', $hrd_handphone);
                $this->db->bind('hrd_HomePhone2', $hrd_HomePhone);
                $this->db->bind('hrd_department', $hrd_department);
                $this->db->bind('hrd_unitkerja', $hrd_unitkerja);
                $this->db->bind('hrd_status', $hrd_status);
                $this->db->bind('hrd_tglmasuk', $hrd_tglmasuk);
                $this->db->bind('hrd_tgl_resign', $hrd_tgl_resign);
                $this->db->bind('hrd_npwp', $hrd_npwp);
                $this->db->bind('hrd_status_pajak', $hrd_status_pajak);
                $this->db->bind('hrd_plafonRajal', $hrd_plafonRajal);
                $this->db->bind('hrd_plafonRanap', $hrd_plafonRanap);
                $this->db->bind('hrd_status_pegawai', $hrd_status_pegawai);
                $this->db->bind('hrd_jabatan', $hrd_jabatan);
                $this->db->bind('hrd_bpjs_kes', $hrd_bpjs_kes);
                $this->db->bind('hrd_hakKelas', $hrd_hakKelas);
                $this->db->bind('hrd_bpjstk', $hrd_bpjstk);
                $this->db->bind('hrd_namabank', $hrd_namabank);
                $this->db->bind('hrd_hakKelas_PlafonRS', $hrd_hakKelas_PlafonRS);
                $this->db->bind('hrd_jmltanggungan', $hrd_jmltanggungan);
                $this->db->bind('hrd_keterangan_resign', $hrd_keterangan_resign);
                $this->db->bind('hrd_keterangan_atributx', $hrd_keterangan_atributx);
                $this->db->bind('hrd_alamat_domisili', $hrd_alamat_domisili);
                $this->db->bind('Medrec_Kelurahan', $Medrec_Kelurahan);
                $this->db->bind('Medrec_Kecamatan', $Medrec_Kecamatan);
                $this->db->bind('Medrec_kabupaten', $Medrec_kabupaten);
                $this->db->bind('Medical_Provinsi', $Medical_Provinsi);
                $this->db->bind('Medrec_Kodepos', $Medrec_Kodepos);
                $this->db->bind('hrd_tipeKaryawan', $hrd_tipeKaryawan);
                $this->db->bind('hrd_id', $hrd_id);
            }
            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function caridatapegawai($data){
        try {
            $buah = htmlspecialchars($data["query"]); 
            $this->db->query("SELECT *from [HR_Data Pegawai]  where Nama LIKE '%' + :buah  + '%'");
            $this->db->bind('buah', $buah);
            $data =  $this->db->resultSet();
            foreach ($data as $key) {
                $output['suggestions'][] = [
                    'value' => $key['Nama'],
                    'buah'  => $key['Nama'],
                    'kodetype'  =>  $key['ID_Data'],
                    'satuan' =>  $key['Nama'],
                    'Konversi_satuan' => $key['Nama']
                ];
            } 
            return $output;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getdataPegawaibyID($data){
        try {
            $this->db->query("  SELECT ID_Data,
                                replace(CONVERT(VARCHAR(11), Tgl_Lahir, 111), '/','-') as Date_of_birthx ,
                                replace(CONVERT(VARCHAR(11), Tgl_Masuk, 111), '/','-') as Tgl_Masukx ,
                                replace(CONVERT(VARCHAR(11), Tgl_Keluar, 111), '/','-') as Tgl_Keluarx ,
                                *from [HR_Data Pegawai]  where ID_Data=:params");
            $this->db->bind('params', $data['q']);
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success',
                'Nip' => $data['Nip'],
                'ID' => $data['ID_Data'],
                'No_Rek' => $data['No_Rek'],
                'Nama' => $data['Nama'],
                'Jenis_Kelamin' => $data['Jenis_Kelamin'],
                'Tempat_Lahir' => $data['Tempat_Lahir'],
                'Alamat' => $data['Alamat'],
                'Unit_1' => $data['Unit_1'],
                'Departemen' => $data['Departemen'],
                'Jabatan' => $data['Jabatan'],
                'Status_Pegawai' => $data['Status_Pegawai'],
                'Agama' => $data['Agama'],
                'Status_Aktif' => $data['Status_Aktif'],
                'Date_of_birthx' => $data['Date_of_birthx'],
                'hp' => $data['No_Telepon 1'],
                'mobile' => $data['No_Telepon 2'],
                'Pendidikan' => $data['Pendidikan'],
                'StatusPajak' => $data['StatusPajak'],
                'Jurusan' => $data['Jurusan'],
                'NoNPWP' => $data['NoNPWP'],
                'No_KTP' => $data['No_KTP'],
                'No_Rek' => $data['No_Rek'],
                'Plafon_RJ' => $data['Plafon_RJ'],
                'Plafon_RI' => $data['Plafon_RI'],
                'Tgl_Masukx' => $data['Tgl_Masukx'],
                'NoBPJSKesehatan' => $data['NoBPJSKesehatan'],
                'HakKelasBPJSKes' => $data['HakKelasBPJSKes'],
                'NoBPJSKetenagakerjaan' => $data['NoBPJSKetenagakerjaan'],
                'NamaBank' => $data['NamaBank'],
                'HakKelasPlafonRS' => $data['HakKelasPlafonRS'],
                'Jml_Tanggungan' => $data['Jml_Tanggungan'],
                'Status_Menikah' => $data['Status_Menikah'],
                'AlasanKeluar' => $data['AlasanKeluar'],
                'Tgl_Keluarx' => $data['Tgl_Keluarx'],
                'Atribut_Pegawai_Kembali' => $data['Atribut_Pegawai_Kembali'],
                'Alamat_Domisili' => $data['Alamat_Domisili'],
                'Medical_Provinsi' => $data['State/Province'],
                'Medrec_kabupaten' => $data['City'],
                'Medrec_Kecamatan' => $data['Kecamatan'],
                'Medrec_Kelurahan' => $data['Kelurahan'],
                'kodepos' => $data['ZIP/Postal Code'],
                'KD_JENIS_PEG' => $data['KD_JENIS_PEG']
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function searchnilaiumklokasi($data)
    {
        try {
            $this->db->query("SELECT UMK_LOKASI from P_M_LOKASI WHERE KD_LOKASI=:params");
            $this->db->bind('params', $data['q']);
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success',
                'UMK_LOKASI' => $data['UMK_LOKASI'], 
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function add_Pendidikan($data)
    {
        $hrd_id = $data['hrd_id'];
        $hrd_jenis_Pendidikan = $data['hrd_jenis_Pendidikan'];
        $hrd_Nama_Pendidikan = $data['hrd_Nama_Pendidikan'];
        $hrd_Tahun_Lulus = $data['hrd_Tahun_Lulus'];
        $hrd_Jurusan = $data['hrd_Jurusan'];

        if ($data['hrd_jenis_Pendidikan'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Jenis Pendidikan !',
            );
            return $callback;
            exit;
        }
        if ($data['hrd_Nama_Pendidikan'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Nama Pendidikan !',
            );
            return $callback;
            exit;
        }
        if ($data['hrd_Tahun_Lulus'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Tahun Lulus !',
            );
            return $callback;
            exit;
        }

        if ($data['hrd_Jurusan'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Jurusan !',
            );
            return $callback;
            exit;
        }
        try {
            $this->db->transaksi();
           
                $this->db->query("INSERT INTO [HR_Data Pendidikan]
                            (ID_Data,Jenis_Pendidikan,Jurusan,
                            Nama_Pendidikan,Tahun_Lulus)
                            values
                            ( :hrd_id,:hrd_jenis_Pendidikan,
                              :hrd_Jurusan,:hrd_Nama_Pendidikan,:hrd_Tahun_Lulus)"); 
                $this->db->bind('hrd_id', $hrd_id);
                $this->db->bind('hrd_jenis_Pendidikan', $hrd_jenis_Pendidikan);
                $this->db->bind('hrd_Jurusan', $hrd_Jurusan);
                $this->db->bind('hrd_Nama_Pendidikan', $hrd_Nama_Pendidikan);
                $this->db->bind('hrd_Tahun_Lulus', $hrd_Tahun_Lulus);  
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
    public function getPendidikanList($data)
    {
        try {
            $this->db->query("SELECT  * from [HR_Data Pendidikan] 
                    where  ID_Data = :iddata");
            $this->db->bind('iddata', $data['q']); 
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no="1";
            foreach ($data as $key) { 
                $pasing['no'] = $no;
                $pasing['Jenis_Pendidikan'] = $key['Jenis_Pendidikan'];
                $pasing['Nama_Pendidikan'] = $key['Nama_Pendidikan'];
                $pasing['Tahun_Lulus'] = $key['Tahun_Lulus'];
                $pasing['Jurusan'] = $key['Jurusan'];
                $pasing['ID'] = $key['ID'];
                $rows[] = $pasing; 
                $no++;
            } 
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function delPendidikanList($data)
    {
        $iddetil = $data['iddetil']; 

        if ($data['iddetil'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Id Pegawai Invalid !',
            );
            return $callback;
            exit;
        } 
        try {
            $this->db->transaksi();

            $this->db->query("  DELETE   [HR_Data Pendidikan] 
                                WHERE ID=:iddetil ");
            $this->db->bind('iddetil', $iddetil); 
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
    public function add_keluarga($data)
    {
        $hrd_id = $data['hrd_id'];
        $hrd_jenis_Keluarga = $data['hrd_jenis_Keluarga'];
        $hrd_nama_keluarga = $data['hrd_nama_keluarga'];
        $hrd_Tahun_lahir = $data['hrd_Tahun_lahir'];
        $hrd_tempat_lahir = $data['hrd_tempat_lahir'];
        $hrd_Kel_NoKtp = $data['hrd_Kel_NoKtp'];
        $hrd_Kel_NoKK = $data['hrd_Kel_NoKK'];
        $hrd_Kel_Tlp = $data['hrd_Kel_Tlp'];
        $hrd_Kel_BPJS = $data['hrd_Kel_BPJS'];
  

        if ($data['hrd_jenis_Keluarga'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Jenis Keluarga !',
            );
            return $callback;
            exit;
        }
        if ($data['hrd_nama_keluarga'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Nama keluarga !',
            );
            return $callback;
            exit;
        }
        
        if ($data['hrd_id'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Id Pegawai !',
            );
            return $callback;
            exit;
        }
        try {
            $this->db->transaksi();

            $this->db->query("INSERT INTO  HR_Data_Keluarga
                            (Id_data,[Status Keluarga],
                            [Nama Keluarga],Tgl_Lahir,Tpt_Lahir
                            ,NIK,NO_KK,NO_TLP,NO_BPJS)
                            values
                            ( :hrd_id,:hrd_jenis_Keluarga,
                            :hrd_nama_keluarga,:hrd_Tahun_lahir,:hrd_tempat_lahir
                            ,:hrd_Kel_NoKtp,:hrd_Kel_NoKK,:hrd_Kel_Tlp,:hrd_Kel_BPJS)");
            $this->db->bind('hrd_id', $hrd_id);
            $this->db->bind('hrd_jenis_Keluarga', $hrd_jenis_Keluarga);
            $this->db->bind('hrd_nama_keluarga', $hrd_nama_keluarga);
            $this->db->bind('hrd_Tahun_lahir', $hrd_Tahun_lahir);
            $this->db->bind('hrd_tempat_lahir', $hrd_tempat_lahir);
            $this->db->bind('hrd_Kel_NoKtp', $hrd_Kel_NoKtp);
            $this->db->bind('hrd_Kel_NoKK', $hrd_Kel_NoKK);
            $this->db->bind('hrd_Kel_Tlp', $hrd_Kel_Tlp);
            $this->db->bind('hrd_Kel_BPJS', $hrd_Kel_BPJS);  
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
    public function getkeluargaList($data)
    {
        try {
            $this->db->query("SELECT Id_Keluarga,Id_data,[Nama Keluarga] as nama,Tgl_Lahir,Tpt_Lahir,
                    CASE  WHEN [Status Keluarga] ='1' THEN 'SUAMI' 
                    WHEN [Status Keluarga] ='2' THEN 'ISTRI' 
                    WHEN [Status Keluarga] ='3' THEN 'ANAK' 
                    END AS statuskeluarga,NIK,NO_KK,NO_TLP,NO_BPJS
                    from HR_Data_Keluarga 
                    WHERE Id_data = :iddata ORDER BY [Status Keluarga] ASC ");
            $this->db->bind('iddata', $data['q']);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = "1";
            foreach ($data as $key) {
                $pasing['no'] = $no;
                $pasing['statuskeluarga'] = $key['statuskeluarga'];
                $pasing['nama'] = $key['nama'];
                $pasing['Tgl_Lahir'] = $key['Tgl_Lahir'];
                $pasing['Tpt_Lahir'] = $key['Tpt_Lahir'];
                $pasing['NIK'] = $key['NIK'];
                $pasing['NO_KK'] = $key['NO_KK'];
                $pasing['NO_TLP'] = $key['NO_TLP'];
                $pasing['NO_BPJS'] = $key['NO_BPJS'];
                $pasing['Id_Keluarga'] = $key['Id_Keluarga']; 
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function delkeluargaList($data)
    {
        $iddetil = $data['iddetil'];

        if ($data['iddetil'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Id Pegawai Invalid !',
            );
            return $callback;
            exit;
        }
        try {
            $this->db->transaksi();

            $this->db->query("  DELETE HR_Data_Keluarga 
                            WHERE Id_Keluarga=:iddetil ");
            $this->db->bind('iddetil', $iddetil);
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
    public function add_datastatus_Kerja($data)
    {

        if ($data['hrd_status_kerja2'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Status Kerja Kosong !',
            );
            return $callback;
            exit;
        }
        if ($data['hrd_tgl_awal_kontrak'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan tanggal Awal Kontrak !',
            );
            return $callback;
            exit;
        }
        if ($data['hrd_tgl_akhir_kontrak'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Tanggal Akhir Kontrak !',
            );
            return $callback;
            exit;
        }

        if ($data['hrd_no_surat_statuskerjad'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'No. Surat Kosong !',
            );
            return $callback;
            exit;
        }

        if ($data['hrd_id'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Id Pegawai Kosong !',
            );
            return $callback;
            exit;
        }
        if ($data['hrd_Lokasi'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Lokasi Kosong !',
            );
            return $callback;
            exit;
        }
        if ($data['hrd_nilai_UMK'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Nilai UMK Kosong !',
            );
            return $callback;
            exit;
        }
        if ($data['Hrd_Tipe_Kontrak'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Tipe Kontrak Kosong !',
            );
            return $callback;
            exit;
        } 
        try {
            $this->db->transaksi();

            $this->db->query("INSERT INTO  [HR_Data_Status Pegawai]
                    (Id_Data,Status_Kerja,
                    Tgl_Mulai_Kontrak,Tgl_Akhir_Kontrak,
                    SK,kd_lokasi,Kd_Grade,Kd_Tipe,UMK_KONTRAK,tipe_kontrak)
                    values
                    ( :hrd_id,:hrd_status_kerja2,
                    :hrd_tgl_awal_kontrak,:hrd_tgl_akhir_kontrak,
                    :hrd_no_surat_statuskerjad,:hrd_Lokasi,:Hrd_Grade,:Hrd_Tipe
                    ,:nilaiUMK,:Hrd_Tipe_Kontrak)");
            $this->db->bind('hrd_id', $data['hrd_id']);
            $this->db->bind('hrd_status_kerja2', $data['hrd_status_kerja2']);
            $this->db->bind('hrd_tgl_awal_kontrak', $data['hrd_tgl_awal_kontrak']);
            $this->db->bind('hrd_tgl_akhir_kontrak', $data['hrd_tgl_akhir_kontrak']);
            $this->db->bind('hrd_no_surat_statuskerjad', $data['hrd_no_surat_statuskerjad']);
            $this->db->bind('hrd_Lokasi', $data['hrd_Lokasi']);
            $this->db->bind('Hrd_Grade', $data['Hrd_Grade']);
            $this->db->bind('Hrd_Tipe', $data['Hrd_Tipe']);
            $this->db->bind('Hrd_Tipe_Kontrak', $data['Hrd_Tipe_Kontrak']);
            $this->db->bind('nilaiUMK', $data['hrd_nilai_UMK']); 
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
    public function getdataStatusKerjaList($data)
    {
        try {
            $this->db->query("SELECT a.Id_Status_Pegawai,a.Id_Data,a.Tgl_Akhir_Kontrak,a.Tgl_Mulai_Kontrak,a.SK,
                    b.Status_Kerja,c.NM_LOKASI,a.Kd_Grade,a.Kd_Tipe,
                    CASE WHEN a.tipe_kontrak='1' THEN 'BULANAN' 
                    WHEN a.tipe_kontrak='2' THEN 'HARIAN' ELSE '' END AS tipe_kontrak
                    FROM [HR_Data_Status Pegawai] A
                    inner join  HR_Mst_Status_Kerja b 
                    on a.Status_Kerja = b.Id_Status_Kerja
                    inner join P_M_LOKASI c on c.KD_LOKASI = a.kd_lokasi
                    where a.Id_Data = :iddata ORDER BY Id_Status_Pegawai DESC ");
            $this->db->bind('iddata', $data['q']);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = "1";
            foreach ($data as $key) {
                $pasing['no'] = $no;
                $pasing['Status_Kerja'] = $key['Status_Kerja'];
                $pasing['Tgl_Mulai_Kontrak'] = $key['Tgl_Mulai_Kontrak'];
                $pasing['Tgl_Akhir_Kontrak'] = $key['Tgl_Akhir_Kontrak'];
                $pasing['SK'] = $key['SK'];
                $pasing['NM_LOKASI'] = $key['NM_LOKASI'];
                $pasing['Kd_Tipe'] = $key['Kd_Tipe'];
                $pasing['Kd_Grade'] = $key['Kd_Grade'];
                $pasing['tipe_kontrak'] = $key['tipe_kontrak'];
                $pasing['Id_Status_Pegawai'] = $key['Id_Status_Pegawai'];
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function delStatusKerjaList($data)
    {
        $iddetil = $data['iddetil'];

        if ($data['iddetil'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Id Pegawai Invalid !',
            );
            return $callback;
            exit;
        }
        try {
            $this->db->transaksi();

            $this->db->query("  DELETE [HR_Data_Status Pegawai]
                                WHERE Id_Status_Pegawai=:iddetil ");
            $this->db->bind('iddetil', $iddetil);
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
    public function add_pelatihan_kerja($data)
    {

        if ($data['hrd_jenis_Pelatihan'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Jenis Pelatihan Kosong !',
            );
            return $callback;
            exit;
        }
        if ($data['hrd_nama_pelatihan'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Nama Pelatihan Kosong !',
            );
            return $callback;
            exit;
        }
        if ($data['hrd_tgl_mulai_pelatihan'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Tgl Mulai Pelatihan Kosong !',
            );
            return $callback;
            exit;
        }

        if ($data['hrd_tgl_akhir_pelatihan'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Tgl Akhir Kosong !',
            );
            return $callback;
            exit;
        }

        if ($data['hrd_id'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Id Pegawai Kosong !',
            );
            return $callback;
            exit;
        } 
        if ($data['hrd_tglexpiredsertifikat'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Tgl Masa Berlaku Kosong !',
            );
            return $callback;
            exit;
        } 
        try {
            $this->db->transaksi(); 
            $this->db->query("INSERT INTO  [HR_Data Pelatihan]
                    (Id_Data,Jenis_Pelatihan,Nama_Pelatihan,
                    Tgl_Awal,Tgl_Akhir,
                    Alamat_Pelatihan,Lama_Pelatihan_Internal,
                    No_Sertifikat,Tgl_Berlaku)
                    values
                    ( :hrd_id,:hrd_jenis_Pelatihan,:hrd_nama_pelatihan,
                    :hrd_tgl_mulai_pelatihan,:hrd_tgl_akhir_pelatihan,
                    :hrd_alamat_Pelatihan,:hrd_lama_pelatihan,
                    :hrd_noSertifikat_pelatihan,:hrd_tglexpiredsertifikat)"); 
            $this->db->bind('hrd_id', $data['hrd_id']);
            $this->db->bind('hrd_jenis_Pelatihan', $data['hrd_jenis_Pelatihan']);
            $this->db->bind('hrd_nama_pelatihan', $data['hrd_nama_pelatihan']);
            $this->db->bind('hrd_tgl_mulai_pelatihan', $data['hrd_tgl_mulai_pelatihan']);
            $this->db->bind('hrd_tgl_akhir_pelatihan', $data['hrd_tgl_akhir_pelatihan']);
            $this->db->bind('hrd_alamat_Pelatihan', $data['hrd_alamat_Pelatihan']);
            $this->db->bind('hrd_lama_pelatihan', $data['hrd_lama_pelatihan']);
            $this->db->bind('hrd_noSertifikat_pelatihan', $data['hrd_noSertifikat_pelatihan']);
            $this->db->bind('hrd_tglexpiredsertifikat', $data['hrd_tglexpiredsertifikat']);
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
    public function getdataPelatihanList($data)
    {
        try {
            $this->db->query("  SELECT  replace(CONVERT(VARCHAR(11), Tgl_Berlaku, 111), '/','-')  as Tgl_Berlaku,
                                *FROM  [HR_Data Pelatihan]
                                where Id_Data = :iddata ORDER BY Id_Pelatihan DESC ");
            $this->db->bind('iddata', $data['q']);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = "1";
            foreach ($data as $key) {
                $pasing['no'] = $no;
                $pasing['Jenis_Pelatihan'] = $key['Jenis_Pelatihan'];
                $pasing['Nama_Pelatihan'] = $key['Nama_Pelatihan'];
                $pasing['Tgl_Awal'] = $key['Tgl_Awal'];
                $pasing['Tgl_Akhir'] = $key['Tgl_Akhir'];
                $pasing['Alamat_Pelatihan'] = $key['Alamat_Pelatihan'];
                $pasing['Lama_Pelatihan_Internal'] = $key['Lama_Pelatihan_Internal'];
                $pasing['No_Sertifikat'] = $key['No_Sertifikat'];
                $pasing['Tgl_Berlaku'] = $key['Tgl_Berlaku'];
                $pasing['Id_Pelatihan'] = $key['Id_Pelatihan'];
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function delpelatihanKerjaList($data)
    {
        $iddetil = $data['iddetil'];

        if ($data['iddetil'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Id Pegawai Invalid !',
            );
            return $callback;
            exit;
        }
        try {
            $this->db->transaksi();

            $this->db->query("  DELETE  [HR_Data Pelatihan]
                                WHERE Id_Pelatihan=:iddetil ");
            $this->db->bind('iddetil', $iddetil);
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
    public function getdatasplist($data)
    {
        try {
            $this->db->query("  SELECT A.Id_data,A.Alasan,A.Id_Pelanggaran,A.Id_Peringatan,
                    A.Tgl_Peringatan,a.Tgl_Peringatan2,B.[STATUS PERINGATAN] as stautsperingatan
                    FROM  [HR_Data_Surat Peringatan] A 
                    INNER JOIN  HR_Mst_Status_Peringatan B
                    ON A.Id_Peringatan = B.[ID PERINGATAN]
                    where A.Id_data =:iddata ORDER BY Id_Pelanggaran DESC");
            $this->db->bind('iddata', $data['q']);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = "1";
            foreach ($data as $key) {
                $pasing['no'] = $no;
                $pasing['stautsperingatan'] = $key['stautsperingatan'];
                $pasing['Tgl_Peringatan'] = $key['Tgl_Peringatan'];
                $pasing['Tgl_Peringatan2'] = $key['Tgl_Peringatan2'];
                $pasing['Alasan'] = $key['Alasan'];
                $pasing['Id_Pelanggaran'] = $key['Id_Pelanggaran']; 
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function add_sp_kerja($data)
    {

        if ($data['hrd_jenis_sp'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Jenis SP Kosong !',
            );
            return $callback;
            exit;
        }
        if ($data['hrd_keterangan_sp'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Keterangan SP Kosong !',
            );
            return $callback;
            exit;
        }
        if ($data['hrd_tgl_sp'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Tgl SP Awal Kosong !',
            );
            return $callback;
            exit;
        }

        if ($data['hrd_tgl_sp2'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Tgl SP Awal Akhir !',
            );
            return $callback;
            exit;
        }

        if ($data['hrd_id'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Id Pegawai Kosong !',
            );
            return $callback;
            exit;
        } 
        try {
            $this->db->transaksi();
            $this->db->query("INSERT INTO  [HR_Data_Surat Peringatan]
                    (Id_Data,Tgl_Peringatan,Id_Peringatan,
                    Alasan,Tgl_Peringatan2)
                    values
                    ( :hrd_id,:hrd_tgl_sp,:hrd_jenis_sp,
                    :hrd_keterangan_sp,:hrd_tgl_sp2) "); 
            $this->db->bind('hrd_id', $data['hrd_id']);
            $this->db->bind('hrd_tgl_sp', $data['hrd_tgl_sp']);
            $this->db->bind('hrd_jenis_sp', $data['hrd_jenis_sp']);
            $this->db->bind('hrd_keterangan_sp', $data['hrd_keterangan_sp']);
            $this->db->bind('hrd_tgl_sp2', $data['hrd_tgl_sp2']); 
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
    public function delspkerjaList($data)
    {
        $iddetil = $data['iddetil'];

        if ($data['iddetil'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Id Pegawai Invalid !',
            );
            return $callback;
            exit;
        }
        try {
            $this->db->transaksi();

            $this->db->query("  DELETE  [HR_Data_Surat Peringatan]
                                WHERE Id_Pelanggaran=:iddetil ");
            $this->db->bind('iddetil', $iddetil);
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
