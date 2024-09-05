<?php
class PrintPayroll_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getDataInfoRekapPayrollAll($data)
    {
        try {
            $periode = $data['periode'];
            $lokasiproject = $data['lokasiproject'];
            $this->db->query("SELECT a.ID,a.KODE_TRANSAKSI,a.KODE_PEGAWAI,b.Nama,a.SUB_TOTAL,a.PPH21,a.GRAND_TOTAL, A.KODE_LOKASI
								FROM HR_Trs_Payroll a
								inner join [HR_Data Pegawai] b
								on a.KODE_PEGAWAI = b.ID_Data
								where PERIODE=:periode and PETUGAS_BATAL='' AND A.KODE_LOKASI=:lokasiproject"); 
            $this->db->bind('periode', $periode);
            $this->db->bind('lokasiproject', $lokasiproject);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = "1";
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['Nama'] = $key['Nama'];
                $pasing['SUB_TOTAL'] = $key['SUB_TOTAL'];
                $pasing['PPH21'] = $key['PPH21'];
                $pasing['GRAND_TOTAL'] = $key['GRAND_TOTAL']; 
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDataInfoDetilProduktifitas($data)
    {
        try {
            $periode = $data['periode'];
            $lokasiproject = $data['lokasiproject'];
            $id_data = $data['idPegawai'];
            $this->db->query("SELECT A.TGL_JADWAL, A.KODE_SHIFT_KERJA, substring(A.JAM_MASUK_A,1,5) JAM_MASUK_A, substring(A.JAM_KELUAR_A,1,5) JAM_SHIFT_KELUAR, 
            isnull( substring(e.JAM_ABSEN_MASUK,1,5),'00:00') JAM_ABSEN_MASUK, 
            isnull(substring(e.JAM_ABSEN_KELUAR,1,5),'00:00') JAM_ABSEN_KELUAR, isnull(JML_PULANG_DULU,'0') JML_PLG_DULU, isnull(KODE_CUTI,'') KODE_CUTI,
            c.NM_LOKASI,case when a.KETERANGAN='HARI LIBUR' THEN A.KETERANGAN ELSE e.NOTE END AS NOTE,a.KODE_PEGAWAI,
            case when e.NOTE='TIDAK FINGER SAMA SEKALI' THEN '1' ELSE null end KetAbsensi,A.KODE_LOKASI,case when JML_TELAT=0 then null else JML_TELAT end as JML_TELAT,
                case when JAM1=0 then null else CONVERT(DECIMAL(18,2),d.JAM1) end as jam1,
                case when JAM2=0 then null else CONVERT(DECIMAL(18,2),d.JAM2) end as jam2,
                case when JAM3=0 then null else CONVERT(DECIMAL(18,2),d.JAM3) end as jam3,
                case when JAM4=0 then null else CONVERT(DECIMAL(18,2),d.JAM4) end as jam4
            from HR_Mst_JADWAL_SHIFT_KERJA a INNER JOIN P_M_LOKASI C ON C.KD_LOKASI = A.KODE_LOKASI  
            left join ( select * from HR_GEN_ABSENSI where KODE_SPL='') e 
            on a.TGL_JADWAL=e.TGL_JADWAL and a.KODE_PEGAWAI=e.KODE_PEGAWAI and a.KODE_LOKASI=e.KODE_LOKASI
            left JOIN ( select * from HR_TRS_PAYROLL_3 where kode_transaksi in 
            (select KODE_TRANSAKSI from HR_Trs_Payroll where TGL_BATAL='3000-01-01 00:00:00.000')) D 
            on D.TGL_JADWAL = a.tgl_jadwal and a.KODE_PEGAWAI = d.KODE_PEGAWAI  and a.KODE_LOKASI=d.KODE_LOKASI
            WHERE  A.PERIODE=:periode  AND A.KODE_PEGAWAI=:id_data
			AND A.KODE_LOKASI=:lokasiproject
            order by a.TGL_JADWAL");
            $this->db->bind('periode', $periode);
            $this->db->bind('lokasiproject', $lokasiproject);
            $this->db->bind('id_data', $id_data);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = "1";
            foreach ($data as $key) {
                $pasing['jam1'] = $key['jam1'];
                $pasing['jam2'] = $key['jam2'];
                $pasing['jam3'] = $key['jam3'];
                $pasing['jam4'] = $key['jam4'];
                $pasing['TGL_JADWAL'] = $key['TGL_JADWAL'];
                $pasing['JAM_ABSEN_MASUK'] = $key['JAM_ABSEN_MASUK'];
                $pasing['JAM_SHIFT_KELUAR'] = $key['JAM_SHIFT_KELUAR']; 
                $pasing['KODE_CUTI'] = $key['KODE_CUTI'];
                $pasing['KetAbsensi'] = $key['KetAbsensi'];
                $pasing['JML_TELAT'] = $key['JML_TELAT'];
                $pasing['NM_LOKASI'] = $key['NM_LOKASI'];
                $pasing['NOTE'] = $key['NOTE']; 
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function showDataTrsPayroll($data)
    {
        try {
            $this->db->query("SELECT b.id_data,a.KODE_LOKASI,b.Nip,b.Nama,b.NamaBank,c.Jabatan_Fungsional,a.Periode,b.No_Rek,d.Status_Menikah,b.Jml_Anak,
            			case when b.PunyaNPWP='1' then 'Ada NPWP' else 'Tidak Ada NPWP' end as punya_npwp,a.NILAI_LEMBUR_PERJAM,
            			a.NILAI_POT_ABSEN,a.HARI_POT_ABSEN
             FROM GUT.dbo.HR_Trs_Payroll a 
						inner join GUT.dbo.[HR_Data Pegawai] b on a.KODE_PEGAWAI=b.ID_Data
						inner join GUT.dbo.HR_Mst_Jabatan c on b.Jabatan_Fungsional_1=c.Id_JF
						inner join GUT.dbo.HR_Mst_Status_Menikah d on b.Status_Menikah=d.Id_Status_Menikah
                         where a.KODE_TRANSAKSI= :params ");
            $this->db->bind('params', $data['kodetrs']);
            $data =  $this->db->single();
            $pasing['id_data'] = $data['id_data'];
            $pasing['KODE_LOKASI'] = $data['KODE_LOKASI'];
            $pasing['nip'] = $data['Nip'];
            $pasing['nama'] = $data['Nama'];
            $pasing['NamaBank'] = $data['NamaBank'];
            $pasing['JabatanFungsional'] = $data['Jabatan_Fungsional'];
            $pasing['Periode'] = $data['Periode'];
            $pasing['No_Rek'] = $data['No_Rek'];
            $pasing['Status_Menikah'] = $data['Status_Menikah'];
            $pasing['Jml_Anak'] = $data['Jml_Anak'];
            $pasing['punya_npwp'] = $data['punya_npwp'];
            $pasing['NILAI_LEMBUR_PERJAM'] = $data['NILAI_LEMBUR_PERJAM'];
            $pasing['NILAI_POT_ABSEN']  = $data['NILAI_POT_ABSEN'];
            $pasing['HARI_POT_ABSEN']  = $data['HARI_POT_ABSEN'];
            $pasing['ttlpotongan'] = $data['NILAI_POT_ABSEN'] * $data['HARI_POT_ABSEN'];
            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDataInfoRekapProduktifitas($data)
    {
        try {

            $kodetrs = $data['kodetrs'];
            $this->db->query("SELECT KODE_TRANSAKSI,SUM(CONVERT(DECIMAL(18,2),JAM1)) JAM1,
						SUM(CONVERT(DECIMAL(18,2),JAM2)) JAM2, SUM(CONVERT(DECIMAL(18,2),JAM3)) JAM3, 
                        SUM(CONVERT(DECIMAL(18,2),JAM4)) JAM4,
						sum(NILAI_KELAS1)NILAI_KELAS1 ,sum(NILAI_KELAS2)NILAI_KELAS2,
                        sum(NILAI_KELAS3)NILAI_KELAS3 ,sum(NILAI_KELAS4)NILAI_KELAS4,
                        sum(NILAI_LEMBUR)NILAI_LEMBUR 
						FROM HR_TRS_PAYROLL_3 where KODE_TRANSAKSI=:kodetrs
						GROUP BY KODE_TRANSAKSI ");
            $this->db->bind('kodetrs', $kodetrs); 
            $data =  $this->db->single();
                $pasing['JAM1'] = $data['JAM1'];
                $pasing['JAM2'] = $data['JAM2'];
                $pasing['JAM3'] = $data['JAM3'];
                $pasing['JAM4'] = $data['JAM4'];
                $pasing['NILAI_KELAS1'] = $data['NILAI_KELAS1'];
                $pasing['NILAI_KELAS2'] = $data['NILAI_KELAS2'];
                $pasing['NILAI_KELAS3'] = $data['NILAI_KELAS3'];
                $pasing['NILAI_KELAS4'] = $data['NILAI_KELAS4'];
            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDataInfoRekapPivot($data)
    {
        try {

            $kodetrs = $data['kodetrs'];
            $this->db->query("SELECT [19] TUNJANGAN_POKOK,[20] UPAH_POKOK,
                            [21] LEMBUR,[22] POTONGAN_ABSENSI,[23] PPH21,[24] POTONGAN_TL_PSW,[25] KASBON
                            FROM (
                            
                            SELECT KODE_KOMPONEN AS [Quarter] ,NILAI as [REGISTRASI Count] 
                                        FROM HR_Trs_Payroll_2 where KODE_TRANSAKSI=:kodetrs
                            ) AS QuarterlyData
                                PIVOT( sum([REGISTRASI Count] )  
                                FOR Quarter IN ([19],[20],[21],[22],[23],[24],[25] )) AS QPivot");
            $this->db->bind('kodetrs', $kodetrs);
            $data =  $this->db->single();
            $rows = array();
            $array = array();
            $no = "1";
             
                $pasing['TUNJANGAN_POKOK'] = $data['TUNJANGAN_POKOK'];
                $pasing['UPAH_POKOK'] = $data['UPAH_POKOK'];
                $pasing['LEMBUR'] = $data['LEMBUR'];
                $pasing['POTONGAN_ABSENSI'] = $data['POTONGAN_ABSENSI'];
                $pasing['PPH21'] = $data['PPH21'];
                $pasing['POTONGAN_TL_PSW'] = $data['POTONGAN_TL_PSW'];
                $pasing['KASBON'] = $data['KASBON'];
 
             
            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function silpGajiGetPegawai($data)
    {
        try {

            $kodetrs = $data['kodetrs'];
            $this->db->query("SELECT b.Nip,b.Nama,b.NamaBank,c.Jabatan_Fungsional,a.Periode,
                        b.No_Rek FROM GUT.dbo.HR_Trs_Payroll a 
						inner join GUT.dbo.[HR_Data Pegawai] b on a.KODE_PEGAWAI=b.ID_Data
						inner join GUT.dbo.HR_Mst_Jabatan c on b.Jabatan_Fungsional_1=c.Id_JF
                        where a.KODE_TRANSAKSI=:kodetrs ");
            $this->db->bind('kodetrs', $kodetrs);
            $data =  $this->db->single();
            $pasing['nip'] = $data['Nip'];
            $pasing['nama'] = $data['Nama'];
            $pasing['NamaBank'] = $data['NamaBank'];
            $pasing['JabatanFungsional'] = $data['Jabatan_Fungsional'];
            $pasing['Periode'] = $data['Periode'];
            $pasing['No_Rek'] = $data['No_Rek']; 
            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function silpGajiGetKomponenPayroll($data)
    {
        try {

            $kodetrs = $data['kodetrs'];
            $this->db->query("SELECT sum(Nilai) as nilai,NAMA_KOMPONEN,JENIS_KOMPONEN,
                            b.NO_URUT FROM GUT.dbo.HR_Trs_Payroll_2  a
					        inner join GUT.dbo.HR_Mst_KOMPONEN_PAYROL b on a.KODE_KOMPONEN=b.ID
				            where KODE_TRANSAKSI = :kodetrs 
                            group by NAMA_KOMPONEN,JENIS_KOMPONEN,b.NO_URUT order by b.NO_URUT asc");
            $this->db->bind('kodetrs', $kodetrs);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = "1";
            foreach ($data as $key) {
                $pasing['nilai'] = $key['nilai'];
                $pasing['NAMA_KOMPONEN'] = $key['NAMA_KOMPONEN'];
                $pasing['JENIS_KOMPONEN'] = $key['JENIS_KOMPONEN'];
                $pasing['NO_URUT'] = $key['NO_URUT']; 
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}