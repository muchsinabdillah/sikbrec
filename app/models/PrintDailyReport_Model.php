<?php
class PrintDailyReport_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function slipDRgetHeader($data)
    {
        try {

            $kodetrs = $data['kodetrs'];
            $this->db->query("SELECT a.KD_TRS,a.KD_JO,
                            replace(CONVERT(VARCHAR(11),a.FD_TGL, 111), '/','-') as FD_TGL,a.KD_AREA,
							B.NM_LOKASI,B.NM_LOKASI,B.ALAMAT,C.NM_PROJECT,
                            C.LOKASI_KERJA,C.FN_DURASI,C.TOTAL_PEG,C.DATE_START,C.DATE_END,NM_CLIENT
							FROM P_T_DR a
							inner join P_M_LOKASI b
							on a.KD_JO = b.KD_LOKASI
							INNER JOIN P_P_WBS_HDR C 
							ON A.KD_JO = B.KD_LOKASI
							WHERE KD_TRS=:kodetrs ");
            $this->db->bind('kodetrs', $kodetrs);
            $data =  $this->db->single();
            $pasing['NM_PROJECT'] = $data['NM_PROJECT'];
            $pasing['LOKASI_KERJA'] = $data['LOKASI_KERJA'];
            $pasing['TOTAL_PEG'] = $data['TOTAL_PEG'];
            $pasing['NM_CLIENT'] = $data['NM_CLIENT'];
            $pasing['KD_JO'] = $data['KD_JO'];
            $pasing['FD_TGL'] = $data['FD_TGL'];
            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function slipDRgetHeaderPegawai($data)
    {
        try {

            $kodetrs = $data['kodetrs'];
            $this->db->query("SELECT A.ID,A.KODE_TRANSAKSI,A.ID,A.TIPE_PEG,B.Nama
							FROM P_P_WBS_HDR_PEG A
							INNER JOIN [HR_Data Pegawai] B
							ON A.KD_PEG = B.ID_Data 
							WHERE KODE_TRANSAKSI  in (
							SELECT KD_MOU FROM P_T_DR WHERE KD_TRS=:kodetrs)");
            $this->db->bind('kodetrs', $kodetrs);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = "1";
            foreach ($data as $key) {
                $pasing['Nama'] = $key['Nama'];
                $pasing['TIPE_PEG'] = $key['TIPE_PEG']; 
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function slipDRgetRekapTIM($data)
    {
        try {

            $kodetrs = $data['kodetrs'];
            $this->db->query("SELECT KD_TIM,b.NAMA_TIM,TIM_DESCRIPTION
							FROM P_P_WBS_TIM a
							inner join P_M_TIM b 
							on a.KD_TIM = b.ID
							inner join [HR_Data Pegawai] c on c.ID_Data = a.ID_Data
							where a.KODE_TRANSAKSI IN (select KD_MOU from P_T_DR where KD_TRS=:kodetrs)
							group by KD_TIM,b.NAMA_TIM,TIM_DESCRIPTION");
            $this->db->bind('kodetrs', $kodetrs);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = "1";
            foreach ($data as $key) {
                $pasing['KD_TIM'] = $key['KD_TIM'];
                $pasing['NAMA_TIM'] = $key['NAMA_TIM']; 
                $pasing['TIM_DESCRIPTION'] = $key['TIM_DESCRIPTION'];
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function slipDRgetDetailTIM($data)
    {
        try {

            $kodetrs = $data['kodetrs'];
            $this->db->query("SELECT a.id,KODE_TRANSAKSI,a.ID_Data,KD_TIM,b.NAMA_TIM,c.Nama,
                    TIM_DESCRIPTION,Time_Start as Date_Start,Time_End as Date_End
                    ,CASE WHEN a.FB_SPV='1' THEN 'SUPERVISOR' ELSE 'STAFF' END AS JABATAN 
					FROM P_P_WBS_TIM a
					inner join P_M_TIM b 
					on a.KD_TIM = b.ID
					inner join [HR_Data Pegawai] c on c.ID_Data = a.ID_Data
					where a.KODE_TRANSAKSI IN (select KD_MOU from P_T_DR where KD_TRS=:kodetrs) order by a.FB_SPV desc");
            $this->db->bind('kodetrs', $kodetrs);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = "1";
            foreach ($data as $key) {
                $pasing['Nama'] = $key['Nama'];
                $pasing['Date_Start'] = $key['Date_Start'];
                $pasing['Date_End'] = $key['Date_End'];
                $pasing['JABATAN'] = $key['JABATAN'];
                $pasing['KD_TIM'] = $key['KD_TIM'];
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function slipDRgetEquip($data)
    {
        try {

            $kodetrs = $data['kodetrs'];
            $this->db->query("SELECT A.ID,KD_TRS,ID_Data,B.NAMA_BARANG,QTY,Batal,Alasan,b.SATUAN
							FROM P_T_DR_EQUIP A
							INNER JOIN P_M_TOOLS B ON A.ID_Data = B.ID
							where a.KD_TRS=:kodetrs");
            $this->db->bind('kodetrs', $kodetrs);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = "1";
            foreach ($data as $key) {
                $pasing['NAMA_BARANG'] = $key['NAMA_BARANG'];
                $pasing['QTY'] = $key['QTY'];
                $pasing['SATUAN'] = $key['SATUAN']; 
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function slipDRgetCurrentActivity($data)
    {
        try {

            $kodetrs = $data['kodetrs'];
            $this->db->query("SELECT a.ID,a.KD_TRS,a.TIM,b.NAMA_TIM as NAMA_TIM,a.KEGIATAN
								FROM P_T_DR_ACTIVITY a 
								inner join P_M_TIM b
								on a.tim = b.ID
								where a.KD_TRS=:kodetrs");
            $this->db->bind('kodetrs', $kodetrs);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = "1";
            foreach ($data as $key) {
                $pasing['NAMA_TIM'] = $key['NAMA_TIM'];
                $pasing['KEGIATAN'] = $key['KEGIATAN']; 
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function slipDRgetNextActivity($data)
    {
        try {

            $kodetrs = $data['kodetrs'];
            $this->db->query("SELECT  ID, KODE_TRANSAKSI, NAMA_TIM, PLANNING
								FROM P_T_DR_PLANNING  
								where  KODE_TRANSAKSI=:kodetrs");
            $this->db->bind('kodetrs', $kodetrs);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = "1";
            foreach ($data as $key) {
                $pasing['NAMA_TIM'] = $key['NAMA_TIM'];
                $pasing['PLANNING'] = $key['PLANNING'];
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function slipDRgetweather($data)
    {
        try {

            $kodetrs = $data['kodetrs'];
            $this->db->query("SELECT 
                Case when JAM_00 = '0' then 'X' else 'V' end as JAM_00,
                Case when JAM_001 = '0' then 'X' else 'V' end as JAM_001,
                Case when JAM_002 = '0' then 'X' else 'V' end as JAM_002,
                Case when JAM_003 = '0' then 'X' else 'V' end as JAM_003,
                Case when JAM_004 = '0' then 'X' else 'V' end as JAM_004,
                Case when JAM_005 = '0' then 'X' else 'V' end as JAM_005,
                Case when JAM_006 = '0' then 'X' else 'V' end as JAM_006,
                Case when JAM_007 = '0' then 'X' else 'V' end as JAM_007,
                Case when JAM_008 = '0' then 'X' else 'V' end as JAM_008,
                Case when JAM_009 = '0' then 'X' else 'V' end as JAM_009,
                Case when JAM_0010 = '0' then 'X' else 'V' end as JAM_0010,
                Case when JAM_0011 = '0' then 'X' else 'V' end as JAM_0011,
                Case when JAM_0012 = '0' then 'X' else 'V' end as JAM_0012,
                Case when JAM_0013 = '0' then 'X' else 'V' end as JAM_0013,
                Case when JAM_0014 = '0' then 'X' else 'V' end as JAM_0014,
                Case when JAM_0015 = '0' then 'X' else 'V' end as JAM_0015,
                Case when JAM_0016 = '0' then 'X' else 'V' end as JAM_0016,
                Case when JAM_0017 = '0' then 'X' else 'V' end as JAM_0017,
                Case when JAM_0018 = '0' then 'X' else 'V' end as JAM_0018,
                Case when JAM_0019 = '0' then 'X' else 'V' end as JAM_0019,
                Case when JAM_0020 = '0' then 'X' else 'V' end as JAM_0020,
                Case when JAM_0021 = '0' then 'X' else 'V' end as JAM_0021,
                Case when JAM_0022 = '0' then 'X' else 'V' end as JAM_0022,
                Case when JAM_0023 = '0' then 'X' else 'V' end as JAM_0023
                 FROM P_T_DR_WEATHER where KODE_TRANSAKSI=:kodetrs");
            $this->db->bind('kodetrs', $kodetrs);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = "1";
            foreach ($data as $key) { 
                $pasing['JAM_00'] = $key['JAM_00'];
                $pasing['JAM_001'] = $key['JAM_001'];
                $pasing['JAM_002'] = $key['JAM_002'];
                $pasing['JAM_003'] = $key['JAM_003'];
					    $pasing['JAM_004'] = $key['JAM_004'];
					    $pasing['JAM_005'] = $key['JAM_005'];
					    $pasing['JAM_006'] = $key['JAM_006'];
					    $pasing['JAM_007'] = $key['JAM_007'];
					    $pasing['JAM_008'] = $key['JAM_008'];
					    $pasing['JAM_009'] = $key['JAM_009'];
					    $pasing['JAM_0010'] = $key['JAM_0010'];
					    $pasing['JAM_0011'] = $key['JAM_0011'];
					    $pasing['JAM_0012'] = $key['JAM_0012'];
					    $pasing['JAM_0013'] = $key['JAM_0013'];
					    $pasing['JAM_0014'] = $key['JAM_0014'];
					    $pasing['JAM_0015'] = $key['JAM_0015'];
					    $pasing['JAM_0016'] = $key['JAM_0016'];
					    $pasing['JAM_0017'] = $key['JAM_0017'];
					    $pasing['JAM_0018'] = $key['JAM_0018'];
					    $pasing['JAM_0019'] = $key['JAM_0019'];
					    $pasing['JAM_0020'] = $key['JAM_0020'];
					    $pasing['JAM_0021'] = $key['JAM_0021'];
					    $pasing['JAM_0022'] = $key['JAM_0022'];
					    $pasing['JAM_0023'] = $key['JAM_0023'];  
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function slipDRgetImages($data)
    {
        try {

            $kodetrs = $data['kodetrs'];
            $this->db->query("SELECT *FROM P_T_DR_IMAGES  where ID_TRANSAKSI=:kodetrs");
            $this->db->bind('kodetrs', $kodetrs);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = "1";
            foreach ($data as $key) {
                $pasing['images_location'] = $key['images_location'];
                $pasing['CAPTION'] = $key['CAPTION'];
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}