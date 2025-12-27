<?php
class B_InfoTarifTindakanBilling_Model
{
    use ApiRsyarsi;
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function getDataInfoRajal($data)
    {
        try {
            // variable
            $jenispasien = $data['jenispasien'];
            $grup = $data['gruptarif'];
            $unit = $data['unitlayanan'];
            $unitlayanan = '';
            $gruptarif = '';
            date_default_timezone_set('Asia/Jakarta');
            $datenowcreateNotFull = date("Y-m-d");
            //condition
            if ($data['gruptarif'] <> '') {
                $gruptarif = "AND GROUP_TARIF = '$grup'";
            }
            if ($data['unitlayanan'] <> '') {
                $unitlayanan = "AND id_layanan = '$unit'";
            }

            $this->db->query("SELECT 
                    A.ID_TR_TARIF,c.ID,c.[Product Name] as namatarif , D.id_layanan, SUM(b.NILAI) AS NILAI
                    FROM PerawatanSQL.DBO.Tarif_RJ_UGD_3 A
                    INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD_4 B ON A.ID_TR_TARIF = B.ID_TR_TARIF
                    INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD C ON C.ID = B.ID_TARIF
                    INNER JOIN PerawatanSQL.DBO.Tarif_RJ_UGD_2 D ON D.id_tarif = C.ID
                    WHERE  :datenowcreateNotFull  between  replace(CONVERT(VARCHAR(11),a.TGL_BERLAKU, 111), '/','-')   and replace(CONVERT(VARCHAR(11),a.TGL_EXPIRED, 111), '/','-')  
                    and b.KD_INSTALASI=:jenispasien  $gruptarif $unitlayanan
                    group by  A.ID_TR_TARIF,c.ID,c.[Product Name] ,D.id_layanan
                    order by 2 asc");
            $this->db->bind('jenispasien', $jenispasien);
            $this->db->bind('datenowcreateNotFull', $datenowcreateNotFull);
            $data =  $this->db->resultSet();
            $rows = array();
            $id = 1;
            foreach ($data as $row) {
                $pasing['No'] = $id++;
                $pasing['ID'] = $row['ID'];
                $pasing['namatarif'] = $row['namatarif'];
                $pasing['NILAI'] = $row['NILAI'];
                $pasing['GROUP_TARIF'] = '';
                $pasing['Tgl_Berlaku'] = '';
                $pasing['id_layanan'] = '';
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataInfoRanap($data)
    {
        try {
            // variable
            $jenispasien = $data['jenispasien'];
            $grup = $data['gruptarif'];
            $unit = $data['unitlayanan'];
            $unitlayanan = '';
            $gruptarif = '';

            //condition
            if ($data['gruptarif'] <> '') {
                $gruptarif = "AND GROUP_TARIF = '$grup'";
            }
            if ($data['unitlayanan'] <> '') {
                $unitlayanan = "AND id_layanan = '$unit'";
            }

            $this->db->query("SELECT A.ID, namatarif, NILAI, GROUP_TARIF, convert(date,TGL_BERLAKU) AS TGL_BERLAKU, convert(date,TGL_EXPIRED) AS TGL_EXPIRED, NamaUnit AS id_layanan FROM RawatInapSQL.dbo.v_tarif_new_2024_ranap A
            INNER JOIN MasterdataSQL.dbo.MstrUnitPerwatan B ON B.ID = A.id_layanan
            WHERE KD_INSTALASI = :jenispasien $gruptarif $unitlayanan");
            $this->db->bind('jenispasien', $jenispasien);
            $data =  $this->db->resultSet();
            $rows = array();
            $id = 1;
            foreach ($data as $row) {
                $pasing['No'] = $id++;
                $pasing['ID'] = $row['ID'];
                $pasing['namatarif'] = $row['namatarif'];
                $pasing['NILAI'] = $row['NILAI'];
                $pasing['GROUP_TARIF'] = $row['GROUP_TARIF'];
                $pasing['Tgl_Berlaku'] = $row['TGL_BERLAKU'] . '' . $row['TGL_EXPIRED'];
                $pasing['id_layanan'] = $row['id_layanan'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}