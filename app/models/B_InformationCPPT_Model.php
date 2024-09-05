<?php
class  B_InformationCPPT_Model
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
            $noreg = $data['Noregistrasi'];

            $this->db->query("SELECT Tgl,a.NoMR,NamaPasien,NoRegistrasi,a.ID,S_Anamnesa,S_RPD,O_TTV,O_PemeriksaanFisik,A_Diagnosa,P_RencanaTatalaksana,P_InstruksiNonMedis,b.Date_of_birth,c.StartDate
            from MedicalRecord.dbo.EMR_RWJ a
            inner join MasterDataSQL.dbo.Admision b on a.NoMR collate Latin1_General_CI_AS=b.NoMR collate Latin1_General_CI_AS
            Inner Join RawatInapSQL.dbo.Inpatient c on a.NoRegistrasi collate Latin1_General_CI_AS=c.NoRegRI collate Latin1_General_CI_AS
            where replace(CONVERT(VARCHAR(11), Tgl, 111), '/','-') Between :tglawal and :tglakhir and
            NoRegistrasi=:noreg
                ");
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $this->db->bind('noreg', $noreg);
            $data =  $this->db->resultSet();
            $rows = array();
            $id = 1;
            foreach ($data as $row) {
                $pasing['No'] = $id++;
                $pasing['Tgl'] = date('d-m-Y', strtotime($row['Tgl']));
                $pasing['Date_of_birth'] = date('d-m-Y', strtotime($row['Date_of_birth']));
                $pasing['StartDate'] = date('d-m-Y', strtotime($row['StartDate']));
                $pasing['NoMR'] = $row['NoMR'];
                $pasing['NamaPasien'] = $row['NamaPasien'];
                $pasing['NoRegistrasi'] = $row['NoRegistrasi'];
                $pasing['ID'] = $row['ID'];
                $pasing['S_Anamnesa'] = $row['S_Anamnesa'];
                $pasing['S_RPD'] = $row['S_RPD'];
                $pasing['O_TTV'] = $row['O_TTV'];
                $pasing['O_PemeriksaanFisik'] = $row['O_PemeriksaanFisik'];
                $pasing['A_Diagnosa'] = $row['A_Diagnosa'];
                $pasing['P_RencanaTatalaksana'] = $row['P_RencanaTatalaksana'];
                $pasing['P_InstruksiNonMedis'] = $row['P_InstruksiNonMedis'];
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
            $noreg = $data['Noregistrasi'];

            $this->db->query("SELECT Tgl,a.NoMR,NamaPasien,NoRegistrasi,a.ID,S_Anamnesa,S_RPD,O_TTV,O_PemeriksaanFisik,A_Diagnosa,P_RencanaTatalaksana,P_InstruksiNonMedis,b.Date_of_birth,c.StartDate
            from MedicalRecord.dbo.EMR_RWJ a
            inner join MasterDataSQL.dbo.Admision b on a.NoMR collate Latin1_General_CI_AS=b.NoMR collate Latin1_General_CI_AS
            Inner Join RawatInapSQL.dbo.Inpatient c on a.NoRegistrasi collate Latin1_General_CI_AS=c.NoRegRI collate Latin1_General_CI_AS
            where replace(CONVERT(VARCHAR(11), Tgl, 111), '/','-') Between :tglawal and :tglakhir and
            NoRegistrasi=:noreg
                ");
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $this->db->bind('noreg', $noreg);
            $data =  $this->db->resultSet();
            $rows = array();
            $id = 1;
            foreach ($data as $row) {
                $pasing['No'] = $id++;
                $pasing['Tgl'] = date('d-m-Y', strtotime($row['Tgl']));
                $pasing['Date_of_birth'] = date('d-m-Y', strtotime($row['Date_of_birth']));
                $pasing['StartDate'] = date('d-m-Y', strtotime($row['StartDate']));
                $pasing['NoMR'] = $row['NoMR'];
                $pasing['NamaPasien'] = $row['NamaPasien'];
                $pasing['NoRegistrasi'] = $row['NoRegistrasi'];
                $pasing['ID'] = $row['ID'];
                $pasing['S_Anamnesa'] = $row['S_Anamnesa'];
                $pasing['S_RPD'] = $row['S_RPD'];
                $pasing['O_TTV'] = $row['O_TTV'];
                $pasing['O_PemeriksaanFisik'] = $row['O_PemeriksaanFisik'];
                $pasing['A_Diagnosa'] = $row['A_Diagnosa'];
                $pasing['P_RencanaTatalaksana'] = $row['P_RencanaTatalaksana'];
                $pasing['P_InstruksiNonMedis'] = $row['P_InstruksiNonMedis'];
                $rows[] = $pasing;
            }
            return $data;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getNamaPasien()
    {
        try {
            $this->db->query("SELECT NoRegRI,PatientName FROM RawatInapSQL.dbo.Inpatient a left join MasterdataSQL.dbo.Admision b on a.NoMR=b.NoMR order by PatientName asc");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['NoRegRI'] = $key['NoRegRI'];
                $pasing['PatientName'] = $key['PatientName'];
                $rows[] = $pasing;
            }
            $callback = array(
                'status' => "success", // Set array nama  
                'data' => $rows
            );
            return $callback;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
}
