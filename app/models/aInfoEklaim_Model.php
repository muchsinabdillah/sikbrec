<?php
class aInfoEklaim_Model 
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }


    //data list sesus filter
    public function getDataListInfo($data)
    {
        // var_dump($data);
        //     exit;
        try {
            $tglawal = $data['TglAwal'];
            $tglakhir=$data['TglAkhir'];

            

            $this->db->query("SELECT KODE_DIAGNOSA, NAMA_DIAGNOSA , count(KODE_DIAGNOSA) as total, SUM(B.total_tarif_rs) as total_tarif_rs
            , SUM(isnull(B.total_tarif_inacbg,0)) as total_tarif_inacbg, SUM(isnull(B.selisih_claim,0)) as selisih_claim
            from DashboardData.dbo.EKLAIM_DTL_DIAGNOSA a
            inner join DashboardData.dbo.EKLAIM b on a.ID_EKLAIM = B.ID
            where IS_PRIMER='1' AND  b.BATAL='0' AND replace(CONVERT(VARCHAR(11), a.DATE_CREATE, 111), '/','-') between :tglawal AND :tglakhir
            --AND b.FINAL_KLAIM='1' AND b.SEND_CLAIM_INDIVIDUAL='1'
            group by KODE_DIAGNOSA, NAMA_DIAGNOSA
            order by count(KODE_DIAGNOSA) desc");

            // var_dump($tglawal);
            // var_dump($tglakhir);
            // exit;


            
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            
            
        
            foreach ($data as $key) {
                $pasing['KODE_DIAGNOSA'] = $key['KODE_DIAGNOSA'];
                $pasing['NAMA_DIAGNOSA'] = $key['NAMA_DIAGNOSA'];
                $pasing['total_tarif_rs'] = $key['total_tarif_rs'];
                $pasing['total_tarif_inacbg'] = $key['total_tarif_inacbg'];
                $pasing['total'] = $key['total'];
                $pasing['selisih_claim'] = $key['selisih_claim'];
                // $pasing['DATE_CREATE'] = $key['DATE_CREATE'];
                
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataListInfoDetail($data)
    {
        // var_dump($data);
        //     exit;
        try {
            $tglawal = $data['TglAwal'];
            $tglakhir=$data['TglAkhir'];

            

            $this->db->query("SELECT ID, NO_SEP,NO_MR,'' AS NOREG, NAMA_PASIEN, TGL_MASUK, TGL_PULANG, JENIS_RAWAT,NAMA_DOKTER,
            INACBG_v5diag10_primer,INACBG_v5diag10_sekunder,
            total_tarif_rs,total_tarif_inacbg,selisih_claim
            from DashboardData.dbo.EKLAIM where BATAL='0' AND FINAL_KLAIM='1' AND SEND_CLAIM_INDIVIDUAL='1' AND replace(CONVERT(VARCHAR(11), DATE_CREATE, 111), '/','-') between :tglawal AND :tglakhir ");

            // var_dump($tglawal);
            // var_dump($tglakhir);
            // exit;


            
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            
            
        
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['NO_SEP'] = $key['NO_SEP'];
                $pasing['NO_MR'] = $key['NO_MR'];
                $pasing['NOREG'] = $key['NOREG'];
                $pasing['NAMA_PASIEN'] = $key['NAMA_PASIEN'];
                $pasing['TGL_MASUK'] = $key['TGL_MASUK'];

                $pasing['TGL_PULANG'] = $key['TGL_PULANG'];
                $pasing['JENIS_RAWAT'] = $key['JENIS_RAWAT'];
                $pasing['NAMA_DOKTER'] = $key['NAMA_DOKTER'];
                $pasing['INACBG_v5diag10_primer'] = $key['INACBG_v5diag10_primer'];
                $pasing['INACBG_v5diag10_sekunder'] = $key['INACBG_v5diag10_sekunder'];
                $pasing['total_tarif_rs'] = $key['total_tarif_rs'];
                $pasing['total_tarif_inacbg'] = $key['total_tarif_inacbg'];
                $pasing['selisih_claim'] = $key['selisih_claim'];
                // $pasing['DATE_CREATE'] = $key['DATE_CREATE'];
                
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}