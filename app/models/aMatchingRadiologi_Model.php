<?php
class aMatchingRadiologi_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getDataListMatchOrderRad($data)
    {
        // var_dump($data);
        // exit;
        try {
            $tglawal = $data['TglAwal'];
            // $tglakhir = $data['TglAkhir'];

            $this->db->query("SELECT a.WOID, a.ACCESSION_NO, replace(CONVERT(VARCHAR(11), a.ORDER_DATE, 111), '/','-')  as ORDER_DATE, a.MRN, a.NOREGISTRASI, a.EPISODE_NUMBER, 
            a.TRIGGER_DTTM, b.First_Name, c.PatientName, SCHEDULED_PROC_DESC
            FROM RadiologiSQL.dbo.WO_RADIOLOGY a
                        LEFT JOIN MasterdataSQL.dbo.Doctors b ON b.ID = a.REQUEST_BY
                        INNER JOIN MasterdataSQL.dbo.Admision c ON c.NoMR = a.MRN
                        where replace(CONVERT(VARCHAR(11), a.ORDER_DATE, 111), '/','-') = :tglawal AND Batal = '0' AND (a.NOREGISTRASI IS NULL OR a.NOREGISTRASI = '') AND (a.EPISODE_NUMBER IS NULL OR a.EPISODE_NUMBER = '')");

            $this->db->bind('tglawal', $tglawal);
            // $this->db->bind('tglakhir', $tglakhir);

            $data =  $this->db->resultSet();
            $rows = array();
            // var_dump($data);
            // exit;
            foreach ($data as $row) {
                //PerawatanSQL.DBO.[Visit Details]
                $pasing['WOID'] = $row['WOID'];
                $pasing['ACCESSION_NO'] = $row['ACCESSION_NO'];
                $pasing['ORDER_DATE'] = date('d/m/Y', strtotime($row['ORDER_DATE']));
                $pasing['MRN'] = $row['MRN'];
                $pasing['NOREGISTRASI'] = $row['NOREGISTRASI'];
                $pasing['EPISODE_NUMBER'] = $row['EPISODE_NUMBER'];
                $pasing['TRIGGER_DTTM'] = $row['TRIGGER_DTTM'];
                $pasing['First_Name'] = $row['First_Name'];
                $pasing['PatientName'] = $row['PatientName'];
                $pasing['SCHEDULED_PROC_DESC'] = $row['SCHEDULED_PROC_DESC'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataListMatchingRad($data)
    {
        // var_dump($data);
        // exit;
        try {
            // $idlab = $data['Idlab'];
            $nomr = $data['Nomr'];
            $daterad = $data['Daterad'];

            $this->db->query("SELECT b.PatientName, a.NoMR, a.NoRegistrasi, a.NoEpisode, c.First_Name, d.NamaPerusahaan,  replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-')  as TglKunjungan FROM PerawatanSQL.dbo.Visit a
            INNER JOIN MasterdataSQL.dbo.Admision b on b.NoMR = a.NoMR
            INNER JOIN MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
            INNER JOIN MasterdataSQL.dbo.MstrPerusahaanJPK d on d.id = a.Perusahaan 
            WHERE a.NoMR = :nomr and replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') = :daterad");

            // $this->db->bind('idlab', $idlab);
            $this->db->bind('nomr', $nomr);
            $this->db->bind('daterad', $daterad);
            // $this->db->bind('tglakhir', $tglakhir);

            $data =  $this->db->resultSet();
            $rows = array();
            // var_dump($data);
            // exit;
            foreach ($data as $row) {
                //PerawatanSQL.DBO.[Visit Details]
                $pasing['PatientName'] = $row['PatientName'];
                $pasing['NoMR'] = $row['NoMR'];
                $pasing['NoRegistrasi'] = $row['NoRegistrasi'];
                $pasing['NoEpisode'] = $row['NoEpisode'];
                $pasing['First_Name'] = $row['First_Name'];
                $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                $pasing['TglKunjungan'] = date('d/m/Y', strtotime($row['TglKunjungan']));
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function goUpdateWORad($data)
    {
        // var_dump($data);
        // exit;
        try {
            // $this->db->transaksi();
            $Nomr = $data['nomr'];
            $Noreg = $data['noreg'];
            $Noeps = $data['noeps'];
            $Idrad = $data['idrad'];

            $this->db->query("UPDATE RadiologiSQL.dbo.WO_RADIOLOGY SET NOREGISTRASI = :Noreg, EPISODE_NUMBER = :Noeps WHERE MRN = :Nomr AND WOID = :Idrad");

            $this->db->bind('Nomr', $Nomr);
            $this->db->bind('Noreg', $Noreg);
            $this->db->bind('Noeps', $Noeps);
            $this->db->bind('Idrad', $Idrad);

            // $this->db->execute();
            // $this->db->commit();
            // $callback = array(
            //     'status' => 'success', // Set array status dengan success
            //     'message' => 'Transkasi Berhasil', // Set array status dengan success
            // );
            // return $callback;

            $this->db->execute();
            // $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Di Update !', // Set array status dengan success    
            );
            // var_dump($callback);
            // exit;
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => 'warning',
                'message' => $e,
            );
            return $callback;
        }
    }
}
