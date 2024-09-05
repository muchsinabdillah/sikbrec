<?php


class B_InformationGrafik_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function ShowGrafikPoliBPJS($data)
    {
        try {
            $no = 0;
            $Info_Date_Start = $data['Info_Date_Start'];
            $Info_Date_End = $data['Info_Date_End'];

                     $this->db->query("SELECT b.NamaUnit,count(Unit) as Jumlah from PerawatanSQL.dbo.Visit a
                     inner join MasterdataSQL.dbo.MstrUnitPerwatan b on a.Unit=b.ID
                     where Batal='0' and replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-') between :Info_Date_Start and :Info_Date_End
                     group by b.NamaUnit
                     order by b.NamaUnit asc");
                    $this->db->bind('Info_Date_Start', $Info_Date_Start);
                    $this->db->bind('Info_Date_End', $Info_Date_End);
                    $data =  $this->db->resultSet();
            
            
            $rows = array();
            foreach ($data as $key) { 
               // $pasing['year'] = date('Y-m-d', strtotime($key['date_DMH']));
                $pasing['NamaUnit'] = $key['NamaUnit'];
                $pasing['Jumlah'] = $key['Jumlah'];
                //$pasing['color'] = 'chart.colors.getIndex(8)';
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function dashboardGrafik2($data)
    {
        try {
            $no = "1";
            $Info_DI2 = $data['Info_DI2'];
            $Info_Tipe2 = $data['Info_Tipe2'];
            $Info_KodeJo2 = $data['Info_KodeJo2'];
            if ($Info_DI2 == "1") {
            } elseif ($Info_DI2 == "2") {
                if ($Info_Tipe2 == "1") { // man hours
                    $this->db->query("SELECT replace(CONVERT(VARCHAR(11),date_DMH, 111), '/','-') Date_DMH , Cumm_MH,Total_MH
                                from  P_P_WBS_DPR_INDIRECT A
                                INNER JOIN P_P_WBS_HDR b
                                on a.KODE_TRANSAKSI = b.KODE_TRANSAKSI
                                where b.KD_JO=:Info_KodeJo1 ");
                    $this->db->bind('Info_KodeJo1', $Info_KodeJo2);
                    $data =  $this->db->resultSet();
                } else if ($Info_Tipe2 == "2") { // man power

                } else if ($Info_Tipe2 == "31") { // progress

                } else if ($Info_Tipe2 == "4") { // cost

                }
            }
            $rows = array();
            foreach ($data as $key) {
                $pasing['year'] = date('Y-m-d', strtotime($key['Date_DMH']));
                $pasing['value'] = $key['Total_MH'];
                $pasing['value2'] = $key['Cumm_MH'];
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function dashboardGrafik3($data)
    {
        try {
            $no = "1";
            $Info_DI3 = $data['Info_DI3'];
            $Info_Tipe3  = $data['Info_Tipe3'];
            $Info_KodeJo3 = $data['Info_KodeJo3'];
            if ($Info_DI3 == "1") {
            } elseif ($Info_DI3 == "2") {
                if ($Info_Tipe3 == "1") { // man hours
                    $this->db->query("SELECT replace(CONVERT(VARCHAR(11),date_DMH, 111), '/','-') Date_DMH , Cumm_MH,Total_MH
                                from  P_P_WBS_DPR_INDIRECT A
                                INNER JOIN P_P_WBS_HDR b
                                on a.KODE_TRANSAKSI = b.KODE_TRANSAKSI
                                where b.KD_JO=:Info_KodeJo1 ");
                    $this->db->bind('Info_KodeJo1', $Info_KodeJo3);
                    $data =  $this->db->resultSet();
                } else if ($Info_Tipe3 == "2") { // man power

                } else if ($Info_Tipe3 == "31") { // progress

                } else if ($Info_Tipe3 == "4") { // cost

                }
            }
            $rows = array();
            foreach ($data as $key) {
                $pasing['year'] = date('Y-m-d', strtotime($key['Date_DMH']));
                $pasing['value'] = $key['Total_MH'];
                $pasing['value2'] = $key['Cumm_MH'];
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function dashboardGrafik4($data)
    {
        try {
            $no = "1";
            $Info_DI4 = $data['Info_DI4'];
            $Info_Tipe4 = $data['Info_Tipe4'];
            $Info_KodeJo4 = $data['Info_KodeJo4'];
            if ($Info_DI4 == "1") {
            } elseif ($Info_DI4 == "2") {
                if ($Info_Tipe4 == "1") { // man hours
                    $this->db->query("SELECT replace(CONVERT(VARCHAR(11),date_DMH, 111), '/','-') Date_DMH , Cumm_MH,Total_MH
                                from  P_P_WBS_DPR_INDIRECT A
                                INNER JOIN P_P_WBS_HDR b
                                on a.KODE_TRANSAKSI = b.KODE_TRANSAKSI
                                where b.KD_JO=:Info_KodeJo1 ");
                    $this->db->bind('Info_KodeJo1', $Info_KodeJo4);
                    $data =  $this->db->resultSet();
                } else if ($Info_Tipe4 == "2") { // man power

                } else if ($Info_Tipe4 == "31") { // progress

                } else if ($Info_Tipe4 == "4") { // cost

                }
            }
            $rows = array();
            foreach ($data as $key) {
                $pasing['year'] = date('Y-m-d', strtotime($key['Date_DMH']));
                $pasing['value'] = $key['Total_MH'];
                $pasing['value2'] = $key['Cumm_MH'];
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}