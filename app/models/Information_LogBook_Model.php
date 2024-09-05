<?php


class Information_LogBook_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getInformationLBRekap($data)
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

            if($Info_Client == "" and $Info_SPV == ""){
                $query = "SELECT A.KD_TRS, 
                            b.KD_MOU,b.KD_JO,e.NM_CLIENT,
                            replace(CONVERT(VARCHAR(11),B.TGL_ENTRY, 111), '/','-')TGL_ENTRY , b.KD_TIM,f.TIM_DESCRIPTION,
                            d.Nama NAMA_SPV,
                            STUFF((SELECT ', ' + x.NAMA from ( SELECT A.KD_TRS,A.KD_PEG,B.Nama NAMA 
                            FROM  P_T_LB_DETIL A LEFT JOIN [HR_Data Pegawai] B ON A.KD_PEG=B.ID_Data 
                            LEFT JOIN P_T_LB C ON C.KD_TRS=A.KD_TRS
                            WHERE A.KD_PEG <>C.KD_PEG_SPV GROUP BY A.KD_TRS,A.KD_PEG,NAMA) x
                            where a.KD_TRS=x.KD_TRS
                                    FOR XML PATH('')), 1, 1, '') STAFF,
                            c.ID_WBS,C.ID ID,
                            c.NM_WBS,a.FS_KEGIATAN,a.TIME_START,a.TIME_END
                            from P_T_LB_DETIL a 
                            inner join P_T_LB b on a.KD_TRS=b.KD_TRS and b.BATAL=a.BATAL
                            left join P_P_WBS_BOQ c on c.id=a.ID_WBS
                            left join [HR_Data Pegawai] d on d.ID_Data=b.KD_PEG_SPV
                            left join P_M_LOKASI e on e.KD_LOKASI=a.KODE_JO
                            left join P_P_WBS_TIM f on f.KODE_TRANSAKSI=c.KODE_TRANSAKSI and f.KD_TIM=b.KD_TIM
                            WHERE B.BATAL=:batal
                            AND replace(CONVERT(VARCHAR(11),B.TGL_ENTRY, 111), '/','-') between :Info_Date_Start and :Info_Date_End
                            group by A.KD_TRS,b.KD_MOU,b.KD_JO,e.NM_CLIENT,
                            replace(CONVERT(VARCHAR(11),B.TGL_ENTRY, 111), '/','-'),f.TIM_DESCRIPTION,b.KD_PEG_SPV,d.Nama,
                            c.ID_WBS,C.ID,c.NM_WBS,a.FS_KEGIATAN,a.TIME_START,a.TIME_END,b.KD_PEG_SPV,b.KD_TIM";
                $this->db->query($query);
                $this->db->bind('Info_Date_Start',  $Info_Date_Start);
                $this->db->bind('Info_Date_End',  $Info_Date_End);
                $this->db->bind('batal',  $batal);
                $data =  $this->db->resultSet();
                $rows = array();  
            } elseif ($Info_Client <> "" and $Info_SPV =="") {
                $query = "SELECT A.KD_TRS, 
                            b.KD_MOU,b.KD_JO,e.NM_CLIENT,
                            replace(CONVERT(VARCHAR(11),B.TGL_ENTRY, 111), '/','-')TGL_ENTRY , b.KD_TIM,f.TIM_DESCRIPTION,
                            d.Nama NAMA_SPV,
                            STUFF((SELECT ', ' + x.NAMA from ( SELECT A.KD_TRS,A.KD_PEG,B.Nama NAMA 
                            FROM  P_T_LB_DETIL A LEFT JOIN [HR_Data Pegawai] B ON A.KD_PEG=B.ID_Data 
                            LEFT JOIN P_T_LB C ON C.KD_TRS=A.KD_TRS
                            WHERE A.KD_PEG <>C.KD_PEG_SPV GROUP BY A.KD_TRS,A.KD_PEG,NAMA) x
                            where a.KD_TRS=x.KD_TRS
                                    FOR XML PATH('')), 1, 1, '') STAFF,
                            c.ID_WBS,C.ID ID,
                            c.NM_WBS,a.FS_KEGIATAN,a.TIME_START,a.TIME_END
                            from P_T_LB_DETIL a 
                            inner join P_T_LB b on a.KD_TRS=b.KD_TRS and b.BATAL=a.BATAL
                            left join P_P_WBS_BOQ c on c.id=a.ID_WBS
                            left join [HR_Data Pegawai] d on d.ID_Data=b.KD_PEG_SPV
                            left join P_M_LOKASI e on e.KD_LOKASI=a.KODE_JO
                            left join P_P_WBS_TIM f on f.KODE_TRANSAKSI=c.KODE_TRANSAKSI and f.KD_TIM=b.KD_TIM
                            WHERE B.BATAL=:batal
                            AND replace(CONVERT(VARCHAR(11),B.TGL_ENTRY, 111), '/','-') between :Info_Date_Start and :Info_Date_End
                            AND B.KD_MOU=:Info_Client
                            group by A.KD_TRS,b.KD_MOU,b.KD_JO,e.NM_CLIENT,
                            replace(CONVERT(VARCHAR(11),B.TGL_ENTRY, 111), '/','-'),f.TIM_DESCRIPTION,b.KD_PEG_SPV,d.Nama,
                            c.ID_WBS,C.ID,c.NM_WBS,a.FS_KEGIATAN,a.TIME_START,a.TIME_END,b.KD_PEG_SPV,b.KD_TIM";
                $this->db->query($query);
                $this->db->bind('Info_Date_Start',  $Info_Date_Start);
                $this->db->bind('Info_Date_End',  $Info_Date_End);
                $this->db->bind('Info_Client',  $Info_Client);
                $this->db->bind('batal',  $batal);
                $data =  $this->db->resultSet();
                $rows = array();    
            } elseif ($Info_Client <> "" and $Info_SPV <> "") {
                $query = "SELECT A.KD_TRS, 
                            b.KD_MOU,b.KD_JO,e.NM_CLIENT,
                            replace(CONVERT(VARCHAR(11),B.TGL_ENTRY, 111), '/','-')TGL_ENTRY , b.KD_TIM,f.TIM_DESCRIPTION,
                            d.Nama NAMA_SPV,
                            STUFF((SELECT ', ' + x.NAMA from ( SELECT A.KD_TRS,A.KD_PEG,B.Nama NAMA 
                            FROM  P_T_LB_DETIL A LEFT JOIN [HR_Data Pegawai] B ON A.KD_PEG=B.ID_Data 
                            LEFT JOIN P_T_LB C ON C.KD_TRS=A.KD_TRS
                            WHERE A.KD_PEG <>C.KD_PEG_SPV GROUP BY A.KD_TRS,A.KD_PEG,NAMA) x
                            where a.KD_TRS=x.KD_TRS
                                    FOR XML PATH('')), 1, 1, '') STAFF,
                            c.ID_WBS,C.ID ID,
                            c.NM_WBS,a.FS_KEGIATAN,a.TIME_START,a.TIME_END
                            from P_T_LB_DETIL a 
                            inner join P_T_LB b on a.KD_TRS=b.KD_TRS and b.BATAL=a.BATAL
                            left join P_P_WBS_BOQ c on c.id=a.ID_WBS
                            left join [HR_Data Pegawai] d on d.ID_Data=b.KD_PEG_SPV
                            left join P_M_LOKASI e on e.KD_LOKASI=a.KODE_JO
                            left join P_P_WBS_TIM f on f.KODE_TRANSAKSI=c.KODE_TRANSAKSI and f.KD_TIM=b.KD_TIM
                            WHERE B.BATAL=:batal
                            AND replace(CONVERT(VARCHAR(11),B.TGL_ENTRY, 111), '/','-') between :Info_Date_Start and :Info_Date_End
                            AND B.KD_PEG_SPV=:Info_SPV  AND B.KD_MOU=:Info_Client
                            group by A.KD_TRS,b.KD_MOU,b.KD_JO,e.NM_CLIENT,
                            replace(CONVERT(VARCHAR(11),B.TGL_ENTRY, 111), '/','-'),f.TIM_DESCRIPTION,b.KD_PEG_SPV,d.Nama,
                            c.ID_WBS,C.ID,c.NM_WBS,a.FS_KEGIATAN,a.TIME_START,a.TIME_END,b.KD_PEG_SPV,b.KD_TIM";
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
                $pasing['TIM_DESCRIPTION'] = $key['TIM_DESCRIPTION'];
                $pasing['NAMA_SPV'] = $key['NAMA_SPV'];
                $pasing['STAFF'] = $key['STAFF'];
                $pasing['ID_WBS'] = $key['ID_WBS'];
                $pasing['ID'] = $key['ID'];
                $pasing['NM_WBS'] = $key['NM_WBS'];
                $pasing['FS_KEGIATAN'] = $key['FS_KEGIATAN'];
                $pasing['TIME_START'] = $key['TIME_START'];
                $pasing['TIME_END'] = $key['TIME_END'];
                $rows[] = $pasing;
            }
            return $rows;

            
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getInformationLBDetil($data)
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

            if ($Info_Client == "" and $Info_SPV == "") {
                $query = "SELECT b.KD_TRS, 
                            b.KD_MOU,b.KD_JO,e.NM_CLIENT,
                            replace(CONVERT(VARCHAR(11),B.TGL_ENTRY, 111), '/','-')TGL_ENTRY , b.KD_TIM,f.TIM_DESCRIPTION,
                            case when b.KD_PEG_SPV=D.ID_Data then 'SPV' else 'STAFF' END TIPE,a.KD_PEG,d.Nama,c.ID_WBS,C.ID ID,
                            c.NM_WBS,a.FS_KEGIATAN,a.TIME_START,a.TIME_END
                            from P_T_LB_DETIL a 
                            inner join P_T_LB b on a.KD_TRS=b.KD_TRS and b.BATAL=a.BATAL
                            left join P_P_WBS_BOQ c on c.id=a.ID_WBS
                            left join [HR_Data Pegawai] d on d.ID_Data=a.KD_PEG
                            left join P_M_LOKASI e on e.KD_LOKASI=a.KODE_JO
                            left join P_P_WBS_TIM f on f.KODE_TRANSAKSI=c.KODE_TRANSAKSI and f.KD_TIM=b.KD_TIM
                            WHERE B.BATAL=:batal AND 
                            replace(CONVERT(VARCHAR(11),B.TGL_ENTRY, 111), '/','-')  between :Info_Date_Start and :Info_Date_End
                            group by B.KD_TRS,b.KD_MOU,b.KD_JO,e.NM_CLIENT,
                            replace(CONVERT(VARCHAR(11),B.TGL_ENTRY, 111), '/','-') ,f.TIM_DESCRIPTION,a.KD_PEG,d.Nama,c.ID_WBS,C.ID,
                            c.NM_WBS,a.FS_KEGIATAN,a.TIME_START,a.TIME_END,b.KD_PEG_SPV,d.ID_Data,b.KD_TIM";
                $this->db->query($query);
                $this->db->bind('Info_Date_Start',  $Info_Date_Start);
                $this->db->bind('Info_Date_End',  $Info_Date_End);
                $this->db->bind('batal',  $batal);
                $data =  $this->db->resultSet();
                $rows = array();
            } elseif ($Info_Client <> "" and $Info_SPV == "") {
                $query = "SELECT b.KD_TRS, 
                            b.KD_MOU,b.KD_JO,e.NM_CLIENT,
                            replace(CONVERT(VARCHAR(11),B.TGL_ENTRY, 111), '/','-')TGL_ENTRY , b.KD_TIM,f.TIM_DESCRIPTION,
                            case when b.KD_PEG_SPV=D.ID_Data then 'SPV' else 'STAFF' END TIPE,a.KD_PEG,d.Nama,c.ID_WBS,C.ID ID,
                            c.NM_WBS,a.FS_KEGIATAN,a.TIME_START,a.TIME_END
                            from P_T_LB_DETIL a 
                            inner join P_T_LB b on a.KD_TRS=b.KD_TRS and b.BATAL=a.BATAL
                            left join P_P_WBS_BOQ c on c.id=a.ID_WBS
                            left join [HR_Data Pegawai] d on d.ID_Data=a.KD_PEG
                            left join P_M_LOKASI e on e.KD_LOKASI=a.KODE_JO
                            left join P_P_WBS_TIM f on f.KODE_TRANSAKSI=c.KODE_TRANSAKSI and f.KD_TIM=b.KD_TIM
                            WHERE B.BATAL=:batal AND 
                            replace(CONVERT(VARCHAR(11),B.TGL_ENTRY, 111), '/','-')  between :Info_Date_Start and :Info_Date_End
                            and   B.KD_MOU=:Info_Client
                            group by B.KD_TRS,b.KD_MOU,b.KD_JO,e.NM_CLIENT,
                            replace(CONVERT(VARCHAR(11),B.TGL_ENTRY, 111), '/','-') ,f.TIM_DESCRIPTION,a.KD_PEG,d.Nama,c.ID_WBS,C.ID,
                            c.NM_WBS,a.FS_KEGIATAN,a.TIME_START,a.TIME_END,b.KD_PEG_SPV,d.ID_Data,b.KD_TIM";
                $this->db->query($query);
                $this->db->bind('Info_Date_Start',  $Info_Date_Start);
                $this->db->bind('Info_Date_End',  $Info_Date_End);
                $this->db->bind('Info_Client',  $Info_Client);
                $this->db->bind('batal',  $batal);
                $data =  $this->db->resultSet();
                $rows = array();
            } elseif ($Info_Client <> "" and $Info_SPV <> "") {
                $query = "SELECT b.KD_TRS, 
                            b.KD_MOU,b.KD_JO,e.NM_CLIENT,
                            replace(CONVERT(VARCHAR(11),B.TGL_ENTRY, 111), '/','-')TGL_ENTRY , b.KD_TIM,f.TIM_DESCRIPTION,
                            case when b.KD_PEG_SPV=D.ID_Data then 'SPV' else 'STAFF' END TIPE,a.KD_PEG,d.Nama,c.ID_WBS,C.ID ID,
                            c.NM_WBS,a.FS_KEGIATAN,a.TIME_START,a.TIME_END
                            from P_T_LB_DETIL a 
                            inner join P_T_LB b on a.KD_TRS=b.KD_TRS and b.BATAL=a.BATAL
                            left join P_P_WBS_BOQ c on c.id=a.ID_WBS
                            left join [HR_Data Pegawai] d on d.ID_Data=a.KD_PEG
                            left join P_M_LOKASI e on e.KD_LOKASI=a.KODE_JO
                            left join P_P_WBS_TIM f on f.KODE_TRANSAKSI=c.KODE_TRANSAKSI and f.KD_TIM=b.KD_TIM
                            WHERE B.BATAL=:batal AND 
                            replace(CONVERT(VARCHAR(11),B.TGL_ENTRY, 111), '/','-')  between :Info_Date_Start and :Info_Date_End
                            and   B.KD_MOU=:Info_Client and   B.KD_PEG_SPV=:Info_SPV
                            group by B.KD_TRS,b.KD_MOU,b.KD_JO,e.NM_CLIENT,
                            replace(CONVERT(VARCHAR(11),B.TGL_ENTRY, 111), '/','-') ,f.TIM_DESCRIPTION,a.KD_PEG,d.Nama,c.ID_WBS,C.ID,
                            c.NM_WBS,a.FS_KEGIATAN,a.TIME_START,a.TIME_END,b.KD_PEG_SPV,d.ID_Data,b.KD_TIM";
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
                $pasing['TIM_DESCRIPTION'] = $key['TIM_DESCRIPTION'];
                $pasing['TIPE'] = $key['TIPE'];
                $pasing['KD_PEG'] = $key['KD_PEG'];
                $pasing['Nama'] = $key['Nama'];
                $pasing['ID_WBS'] = $key['ID_WBS'];
                $pasing['ID'] = $key['ID']; 
                $pasing['NM_WBS'] = $key['NM_WBS'];
                $pasing['FS_KEGIATAN'] = $key['FS_KEGIATAN'];
                $pasing['TIME_START'] = $key['TIME_START'];
                $pasing['TIME_END'] = $key['TIME_END'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}