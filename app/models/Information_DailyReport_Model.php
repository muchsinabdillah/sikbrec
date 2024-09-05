<?php


class Information_DailyReport_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getInformationDRRekap($data)
    {
        try {

            $session = SessionManager::getCurrentSession();
            $useridRole = $session->role;
            $userlogin = $session->username;
            $batal  = "0";
            $Info_Tipe = $data['Info_Tipe'];
            $Info_Client = $data['Info_Client'];
            $Info_SPV = $data['Info_SPV'];
            $Info_Date_Start = $data['Info_Date_Start'];
            $Info_Date_End = $data['Info_Date_End'];
            $ptgbtl = "";
            if ($Info_Client == "" and $Info_SPV == "") {
                $query = "SELECT A.KD_TRS, 
                        b.KD_MOU,b.KD_JO,e.NM_CLIENT,
                        replace(CONVERT(VARCHAR(11),B.TGL_ENTRY, 111), '/','-')TGL_ENTRY , b.KD_TIM,
                        d.Nama NAMA_SPV,
                        c.ID_WBS,C.ID ID,
                        c.NM_WBS,a.KEGIATAN,a.QTY
                        from P_T_DR_ACTIVITY a 
                        inner join P_T_DR b on a.KD_TRS=b.KD_TRS 
                        left join P_P_WBS_BOQ c on c.id=a.ID_WBS
                        left join [HR_Data Pegawai] d on d.ID_Data=b.KD_PEG_SPV
                        left join P_M_LOKASI e on e.KD_LOKASI=b.kd_jo
                        WHERE B.PETUGAS_BATAL=:ptgbtl and a.Batal=:batal
                        AND replace(CONVERT(VARCHAR(11),B.TGL_ENTRY, 111), '/','-') between :Info_Date_Start and :Info_Date_End
                        group by A.KD_TRS,b.KD_MOU,b.KD_JO,e.NM_CLIENT,b.TGL_ENTRY,b.KD_PEG_SPV,d.Nama,
                        c.ID_WBS,C.ID,c.NM_WBS,a.KEGIATAN,b.KD_PEG_SPV,b.KD_TIM,a.QTY";
                $this->db->query($query);
                $this->db->bind('Info_Date_Start',  $Info_Date_Start);
                $this->db->bind('Info_Date_End',  $Info_Date_End);
                $this->db->bind('batal',  $batal);
                $this->db->bind('ptgbtl',  $ptgbtl);
                $data =  $this->db->resultSet();
                $rows = array();
            } elseif ($Info_Client <> "" and $Info_SPV == "") {
                $query = "SELECT A.KD_TRS, 
                        b.KD_MOU,b.KD_JO,e.NM_CLIENT,
                        replace(CONVERT(VARCHAR(11),B.TGL_ENTRY, 111), '/','-')TGL_ENTRY , b.KD_TIM,
                        d.Nama NAMA_SPV,
                        c.ID_WBS,C.ID ID,
                        c.NM_WBS,a.KEGIATAN,a.QTY
                        from P_T_DR_ACTIVITY a 
                        inner join P_T_DR b on a.KD_TRS=b.KD_TRS 
                        left join P_P_WBS_BOQ c on c.id=a.ID_WBS
                        left join [HR_Data Pegawai] d on d.ID_Data=b.KD_PEG_SPV
                        left join P_M_LOKASI e on e.KD_LOKASI=b.kd_jo
                        WHERE B.PETUGAS_BATAL=:ptgbtl and a.Batal=:batal
                        AND replace(CONVERT(VARCHAR(11),B.TGL_ENTRY, 111), '/','-') between :Info_Date_Start and :Info_Date_End
                         AND B.KD_MOU=:Info_Client
                        group by A.KD_TRS,b.KD_MOU,b.KD_JO,e.NM_CLIENT,b.TGL_ENTRY,b.KD_PEG_SPV,d.Nama,
                        c.ID_WBS,C.ID,c.NM_WBS,a.KEGIATAN,b.KD_PEG_SPV,b.KD_TIM,a.QTY";
                $this->db->query($query);
                $this->db->bind('Info_Date_Start',  $Info_Date_Start);
                $this->db->bind('Info_Date_End',  $Info_Date_End);
                $this->db->bind('Info_Client',  $Info_Client);
                $this->db->bind('batal',  $batal);
                $this->db->bind('ptgbtl',  $ptgbtl);
                $data =  $this->db->resultSet();
                $rows = array();
            } elseif ($Info_Client <> "" and $Info_SPV <> "") {
                $query = "SELECT A.KD_TRS, 
                        b.KD_MOU,b.KD_JO,e.NM_CLIENT,
                        replace(CONVERT(VARCHAR(11),B.TGL_ENTRY, 111), '/','-')TGL_ENTRY , b.KD_TIM,
                        d.Nama NAMA_SPV,
                        c.ID_WBS,C.ID ID,
                        c.NM_WBS,a.KEGIATAN,a.QTY
                        from P_T_DR_ACTIVITY a 
                        inner join P_T_DR b on a.KD_TRS=b.KD_TRS 
                        left join P_P_WBS_BOQ c on c.id=a.ID_WBS
                        left join [HR_Data Pegawai] d on d.ID_Data=b.KD_PEG_SPV
                        left join P_M_LOKASI e on e.KD_LOKASI=b.kd_jo
                        WHERE B.PETUGAS_BATAL=:ptgbtl and a.Batal=:batal
                        AND replace(CONVERT(VARCHAR(11),B.TGL_ENTRY, 111), '/','-') between :Info_Date_Start and :Info_Date_End
                        AND B.KD_MOU=:Info_Client and b.KD_PEG_SPV = :Info_SPV
                        group by A.KD_TRS,b.KD_MOU,b.KD_JO,e.NM_CLIENT,b.TGL_ENTRY,b.KD_PEG_SPV,d.Nama,
                        c.ID_WBS,C.ID,c.NM_WBS,a.KEGIATAN,b.KD_PEG_SPV,b.KD_TIM,a.QTY";
                $this->db->query($query);
                $this->db->bind('Info_Date_Start',  $Info_Date_Start);
                $this->db->bind('Info_Date_End',  $Info_Date_End);
                $this->db->bind('Info_SPV',  $Info_SPV);
                $this->db->bind('Info_Client',  $Info_Client);
                $this->db->bind('batal',  $batal);
                $data =  $this->db->resultSet();
                $rows = array();
            }
            foreach ($data as $key) { 
                $pasing['KD_TRS'] = $key['KD_TRS'];
                $pasing['KD_JO'] = $key['KD_JO'];
                $pasing['KD_MOU'] = $key['KD_MOU'];
                $pasing['NM_CLIENT'] = $key['NM_CLIENT'];
                $pasing['TGL_ENTRY'] = $key['TGL_ENTRY'];
                $pasing['KD_TIM'] = $key['KD_TIM'];
              //  $pasing['TIM_DESCRIPTION'] = $key['TIM_DESCRIPTION'];
                $pasing['NAMA_SPV'] = $key['NAMA_SPV']; 
                $pasing['ID_WBS'] = $key['ID_WBS'];
                $pasing['ID'] = $key['ID'];
                $pasing['NM_WBS'] = $key['NM_WBS'];
                $pasing['FS_KEGIATAN'] = $key['KEGIATAN'];
                $pasing['QTY'] = $key['QTY']; 
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    } 
}
