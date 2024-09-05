<?php
class  B_InformationSuketCovid_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getDataListPasien($data)
    {
        try {
            $tglawal = $data['TglAwal'];
            $tglakhir = $data['TglAkhir'];

            $this->db->query("SELECT  a.ID,a.NoMR,b.PatientName,replace(CONVERT(VARCHAR(11), b.Date_of_birth, 111), '/','-') as TglLahir,a.NoRegistrasi,replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-')  as TglKunjungan ,CONVERT(VARCHAR(8),a.TglKunjungan,108) as jamkunjungan,Cetak_Ke
            ,replace(CONVERT(VARCHAR(11), c.DateInput, 111), '/','-')  as TglInput ,UserInput,
            CONVERT(VARCHAR(8),c.DateInput,108) as JamInput
            FROM PerawatanSQl.dbo.Visit a
                      inner join MasterdataSQL.dbo.Admision b on a.NoMR=b.NoMR
                      inner join MasterdataSQL.dbo.A_transaksi_Surat c on a.NoRegistrasi=c.NoRegistrasi
                      where a.Batal='0' AND replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-')  
            between :tglawal and :tglakhir and a.Batal='0' and c.Batal='0'
                      UNION ALL 
                      SELECT  a.ID,a.NoMR,b.PatientName,replace(CONVERT(VARCHAR(11), b.Date_of_birth, 111), '/','-') as TglLahir,a.NoRegistrasi,replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-')  as TglKunjungan,CONVERT(VARCHAR(8),a.TglKunjungan,108) as jamkunjungan,Cetak_Ke
            ,replace(CONVERT(VARCHAR(11), c.DateInput, 111), '/','-')  as TglInput ,UserInput,
            CONVERT(VARCHAR(8),c.DateInput,108) as JamInput
                       FROM PerawatanSQl.dbo.Visit a
                      inner join MasterdataSQL.dbo.Admision_Walkin b on a.NoMR=b.NoMR
                      inner join MasterdataSQL.dbo.A_transaksi_Surat c on a.NoRegistrasi=c.NoRegistrasi
                      where a.Batal='0' AND replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-')  
            between :tglawal2 and :tglakhir2 and a.Batal='0' and c.Batal='0'
                ");
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $this->db->bind('tglawal2', $tglawal);
            $this->db->bind('tglakhir2', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $row) {
                $pasing['NoMR'] = $row['NoMR'];
                $pasing['NamaPasien'] = $row['PatientName'];
                $pasing['TglLahir'] = date('d/m/Y', strtotime($row['TglLahir']));
                $pasing['ID'] = $row['ID'];
                $pasing['NoRegistrasi'] = $row['NoRegistrasi'];
                $pasing['TglKunjungan'] = date('d/m/Y', strtotime($row['TglKunjungan']));
                $pasing['jamkunjungan'] = date('H:i:s', strtotime($row['jamkunjungan']));
                $pasing['UserInput'] = $row['UserInput'];
                $pasing['TglInput'] = date('d/m/Y', strtotime($row['TglInput']));
                $pasing['JamInput'] = date('H:i:s', strtotime($row['JamInput']));
                $pasing['Cetak_Ke'] = $row['Cetak_Ke'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDataListPasien1($data)
    {
        try {
            $tglawal = $data['TglAwal'];
            $tglakhir = $data['TglAkhir'];

            $this->db->query("SELECT  a.ID,a.NoMR,b.PatientName,replace(CONVERT(VARCHAR(11), b.Date_of_birth, 111), '/','-') as TglLahir,a.NoRegistrasi,replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-')  as TglKunjungan ,CONVERT(VARCHAR(8),a.TglKunjungan,108) as jamkunjungan,Cetak_Ke
            ,replace(CONVERT(VARCHAR(11), c.DateInput, 111), '/','-')  as TglInput ,UserInput,
            CONVERT(VARCHAR(8),c.DateInput,108) as JamInput
            FROM PerawatanSQl.dbo.Visit a
                      inner join MasterdataSQL.dbo.Admision b on a.NoMR=b.NoMR
                      inner join MasterdataSQL.dbo.A_transaksi_Surat c on a.NoRegistrasi=c.NoRegistrasi
                      where a.Batal='0' AND replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-')  
            between :tglawal and :tglakhir and a.Batal='0' and c.Batal='0'
                      UNION ALL 
                      SELECT  a.ID,a.NoMR,b.PatientName,replace(CONVERT(VARCHAR(11), b.Date_of_birth, 111), '/','-') as TglLahir,a.NoRegistrasi,replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-')  as TglKunjungan,CONVERT(VARCHAR(8),a.TglKunjungan,108) as jamkunjungan,Cetak_Ke
            ,replace(CONVERT(VARCHAR(11), c.DateInput, 111), '/','-')  as TglInput ,UserInput,
            CONVERT(VARCHAR(8),c.DateInput,108) as JamInput
                       FROM PerawatanSQl.dbo.Visit a
                      inner join MasterdataSQL.dbo.Admision_Walkin b on a.NoMR=b.NoMR
                      inner join MasterdataSQL.dbo.A_transaksi_Surat c on a.NoRegistrasi=c.NoRegistrasi
                      where a.Batal='0' AND replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-')  
            between :tglawal2 and :tglakhir2 and a.Batal='0' and c.Batal='0'
                ");
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $this->db->bind('tglawal2', $tglawal);
            $this->db->bind('tglakhir2', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $row) {
                $pasing['NoMR'] = $row['NoMR'];
                $pasing['NamaPasien'] = $row['PatientName'];
                $pasing['TglLahir'] = date('d/m/Y', strtotime($row['TglLahir']));
                $pasing['ID'] = $row['ID'];
                $pasing['NoRegistrasi'] = $row['NoRegistrasi'];
                $pasing['TglKunjungan'] = date('d/m/Y', strtotime($row['TglKunjungan']));
                $pasing['jamkunjungan'] = date('H:i:s', strtotime($row['jamkunjungan']));
                $pasing['UserInput'] = $row['UserInput'];
                $pasing['TglInput'] = date('d/m/Y', strtotime($row['TglInput']));
                $pasing['JamInput'] = date('H:i:s', strtotime($row['JamInput']));
                $pasing['Cetak_Ke'] = $row['Cetak_Ke'];
                $rows[] = $pasing;
            }
            return $data;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
