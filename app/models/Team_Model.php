<?php


class Team_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function ShowlistTeamsBySPVOnly($data)
    {
        try {
            $IdMou =  $data['IdMou'];
            $kdtim =  $data['lb_SPV'];
            $kodeLB = $data['kodeLB'];
            $lb_tgl_logbook = $data['lb_tgl_logbook'];
            $batal = "0";

            $this->db->query("SELECT KD_PEG,a.kd_tim,Nama,CASE WHEN a.KD_PEG_SPV=b.KD_PEG THEN 'Supervisor' else 'Worker' end Jabatan,
                                B.TIME_START_JADWAL,B.TIME_END_JADWAL 
                                from P_T_LB a inner join P_T_LB_DETIL b on a.KD_TRS=b.KD_TRS
                                inner join [HR_Data Pegawai] c on c.ID_Data=b.KD_PEG
                                where a.TGL_LOG_BOOK=:lb_tgl_logbook and a.BATAL=:batal and KD_MOU=:IdMou 
                                and KD_TIM in (SELECT KD_TIM FROM P_P_WBS_TIM where FB_SPV='1' and ID_Data=:kdtim )
                                group by  KD_PEG,a.kd_tim,Nama, a.KD_PEG_SPV,
                                B.TIME_START_JADWAL,B.TIME_END_JADWAL 
                                order by KD_TIM asc, Jabatan asc");
            $this->db->bind('lb_tgl_logbook', $lb_tgl_logbook);
            $this->db->bind('batal', $batal);
            $this->db->bind('IdMou', $IdMou);
            $this->db->bind('kdtim', $kdtim);  
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['KD_PEG'] = $key['KD_PEG'];
                $pasing['kd_tim'] = $key['kd_tim'];
                $pasing['Nama'] = $key['Nama'];
                $pasing['Jabatan'] = $key['Jabatan'];
                $pasing['TIME_START_JADWAL'] = $key['TIME_START_JADWAL'];
                $pasing['TIME_END_JADWAL'] = $key['TIME_END_JADWAL'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function ShowlistTeamsByDateLogBook($data)
    {
        try {
            $IdMou =  $data['IdMou'];
            $kdtim =  $data['lb_SPV']; 
            $lb_tgl_logbook = $data['lb_tgl_logbook'];
            $batal = "0";

            $this->db->query("SELECT  kd_tim  , b.NAMA_TIM
                            from P_T_LB  a 
                            inner join P_M_TIM b on a.KD_TIM = b.ID
                            where  TGL_LOG_BOOK=:lb_tgl_logbook and BATAL=:batal and KD_MOU=:IdMou 
                            and  KD_TIM in (SELECT KD_TIM FROM P_P_WBS_TIM where FB_SPV='1' and ID_Data=:kdtim )
                            group by   kd_tim  , b.NAMA_TIM");
            $this->db->bind('lb_tgl_logbook', $lb_tgl_logbook);
            $this->db->bind('batal', $batal);
            $this->db->bind('IdMou', $IdMou);
            $this->db->bind('kdtim', $kdtim);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) { 
                $pasing['kd_tim'] = $key['kd_tim'];
                $pasing['NAMA_TIM'] = $key['NAMA_TIM']; 
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}