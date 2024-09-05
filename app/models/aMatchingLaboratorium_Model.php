<?php
class aMatchingLaboratorium_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getDataListMatchOrderLab($data)
    {
        // var_dump($data);
        // exit;
        try {
            $tglawal = $data['TglAwal'];
            // $tglakhir = $data['TglAkhir'];

            $this->db->query("SELECT a.LabID, a.NoLAB, replace(CONVERT(VARCHAR(11), a.LabDate, 111), '/','-')  as LabDate, a.NoMR, a.NoRegRI, a.NoEpisode, a.JamOrder, b.First_Name, c.PatientName, SUBSTRING(x.nama_test,1, LEN(x.nama_test) - 1) NamaTest FROM LaboratoriumSQL.dbo.tblLab a
            INNER JOIN MasterdataSQL.dbo.Doctors b ON b.ID = a.Dokter
            INNER JOIN MasterdataSQL.dbo.Admision c ON c.NoMR = a.NoMR
            OUTER APPLY (
            SELECT e.NamaTes + ', ' 
            FROM LaboratoriumSQL.dbo.tblLabDetail d
            INNER JOIN LaboratoriumSQL.dbo.tblGrouping e on e.IDTes = d.idTes
            WHERE d.LabID=a.LabID AND d.Batal = '0'
            FOR XML PATH('')
            ) x (nama_test)
            where replace(CONVERT(VARCHAR(11), a.LabDate, 111), '/','-') = :tglawal AND Batal = '0' AND (a.NoRegRI IS NULL OR a.NoRegRI = '') AND (a.NoEpisode IS NULL OR a.NoEpisode = '')");

            $this->db->bind('tglawal', $tglawal);
            // $this->db->bind('tglakhir', $tglakhir);

            $data =  $this->db->resultSet();
            $rows = array();
            // var_dump($data);
            // exit;
            foreach ($data as $row) {
                //PerawatanSQL.DBO.[Visit Details]
                $pasing['LabID'] = $row['LabID'];
                $pasing['NoLAB'] = $row['NoLAB'];
                $pasing['LabDate'] = date('d/m/Y', strtotime($row['LabDate']));
                $pasing['NoMR'] = $row['NoMR'];
                $pasing['NoRegRI'] = $row['NoRegRI'];
                $pasing['NoEpisode'] = $row['NoEpisode'];
                $pasing['JamOrder'] = $row['JamOrder'];
                $pasing['First_Name'] = $row['First_Name'];
                $pasing['PatientName'] = $row['PatientName'];
                $pasing['NamaTest'] = $row['NamaTest'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataListMatchingLab($data)
    {
        // var_dump($data);
        // exit;
        try {
            // $idlab = $data['Idlab'];
            $nomr = $data['Nomr'];
            $datelab = $data['Datelab'];

            $this->db->query("SELECT b.PatientName, a.NoMR, a.NoRegistrasi, a.NoEpisode, c.First_Name, d.NamaPerusahaan,  replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-')  as TglKunjungan FROM PerawatanSQL.dbo.Visit a
            INNER JOIN MasterdataSQL.dbo.Admision b on b.NoMR = a.NoMR
            INNER JOIN MasterdataSQL.dbo.Doctors c on c.ID = a.Doctor_1
            INNER JOIN MasterdataSQL.dbo.MstrPerusahaanJPK d on d.id = a.Perusahaan 
            WHERE a.NoMR = :nomr and replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') = :datelab");

            // $this->db->bind('idlab', $idlab);
            $this->db->bind('nomr', $nomr);
            $this->db->bind('datelab', $datelab);
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

    public function goUpdatetblLab($data)
    {
        // var_dump($data);
        // exit;
        try {
            // $this->db->transaksi();
            $Nomr = $data['nomr'];
            $Noreg = $data['noreg'];
            $Noeps = $data['noeps'];
            $Idlab = $data['idlab'];


            $this->db->query("UPDATE LaboratoriumSQL.dbo.tblLab SET NoRegRI = :Noreg, NoEpisode = :Noeps WHERE NoMR = :Nomr AND LabID = :Idlab");
            $this->db->bind('Nomr', $Nomr);
            $this->db->bind('Noreg', $Noreg);
            $this->db->bind('Noeps', $Noeps);
            $this->db->bind('Idlab', $Idlab);

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
