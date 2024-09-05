<?php
class aPPI_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }


    //data list sesus filter
    public function getDataListSensusFilter($data)
    {
        // var_dump($data);
        //     exit;
        try {
            $tglawal = $data['TglAwal'];
            $tglakhir = $data['TglAkhir'];
            $tipeRawat = $data['TipeRawat'];
            $ruangRawat = $data['RuangRawat'];

            if ($tipeRawat == "ALL" and $ruangRawat == "ALL") {
                // $cek='1';
                // var_dump($cek);
                // var_dump($tipeRawat);
                // var_dump($ruangRawat);
                // var_dump($tglawal);
                // var_dump($tglakhir);
                // exit;
                $this->db->query("SELECT ID,Tipe_Rawat,RuangRawat,Tanggal,Jumlah,Opr,OP_B,OP_IDOB,OP_BC,OP_IDOBC,OP_C,OP_IDOC,OP_K,OP_IDOK,OP_WSD,OP_IDOWSD,Infus_CVL,Infus_IAD,Infus_IVL,Infus_UC,Infus_ISK,ETT_Vent,VAP,TB,HAP,DEK_G1,DEK_G2,DEK_G3,DEK_G4,PLEB_G1,PLEB_G2,PLEB_G3,PLEB_G4,PLEB_G5,JumlahAntibiotik_1,JumlahAntibiotik_2,JumlahAntibiotik_3,JumlahKuman_D,JumlahKuman_S,JumlahKuman_SPT,JumlahKuman_Ur FROM MasterdataSQL.dbo.Master_Sensus_PPI WHERE Tanggal BETWEEN :tglawal AND :tglakhir");
                // $this->db->bind('tglawal', $tglawal);
                // $this->db->bind('tglakhir', $tglakhir);
            } else if ($tipeRawat !== "ALL" and $ruangRawat == "ALL") {

                $this->db->query("SELECT ID,Tipe_Rawat,RuangRawat,Tanggal,Jumlah,Opr,OP_B,OP_IDOB,OP_BC,OP_IDOBC,OP_C,OP_IDOC,OP_K,OP_IDOK,OP_WSD,OP_IDOWSD,Infus_CVL,Infus_IAD,Infus_IVL,Infus_UC,Infus_ISK,ETT_Vent,VAP,TB,HAP,DEK_G1,DEK_G2,DEK_G3,DEK_G4,PLEB_G1,PLEB_G2,PLEB_G3,PLEB_G4,PLEB_G5,JumlahAntibiotik_1,JumlahAntibiotik_2,JumlahAntibiotik_3,JumlahKuman_D,JumlahKuman_S,JumlahKuman_SPT,JumlahKuman_Ur FROM MasterdataSQL.dbo.Master_Sensus_PPI WHERE Tipe_Rawat = :tipeRawat AND Tanggal BETWEEN :tglawal AND :tglakhir");
                // $this->db->bind('tglawal', $tglawal);
                // $this->db->bind('tglakhir', $tglakhir);
                $this->db->bind('tipeRawat', $tipeRawat);
            } else if ($tipeRawat == "ALL" and $ruangRawat !== "ALL") {
                // $cek='1';
                // var_dump($cek);
                // var_dump($tipeRawat);
                // var_dump($ruangRawat);
                // var_dump($tglawal);
                // var_dump($tglakhir);
                // exit;
                $this->db->query("SELECT ID,Tipe_Rawat,RuangRawat,Tanggal,Jumlah,Opr,OP_B,OP_IDOB,OP_BC,OP_IDOBC,OP_C,OP_IDOC,OP_K,OP_IDOK,OP_WSD,OP_IDOWSD,Infus_CVL,Infus_IAD,Infus_IVL,Infus_UC,Infus_ISK,ETT_Vent,VAP,TB,HAP,DEK_G1,DEK_G2,DEK_G3,DEK_G4,PLEB_G1,PLEB_G2,PLEB_G3,PLEB_G4,PLEB_G5,JumlahAntibiotik_1,JumlahAntibiotik_2,JumlahAntibiotik_3,JumlahKuman_D,JumlahKuman_S,JumlahKuman_SPT,JumlahKuman_Ur FROM MasterdataSQL.dbo.Master_Sensus_PPI WHERE RuangRawat = :ruangRawat AND Tanggal BETWEEN :tglawal AND :tglakhir");
                // $this->db->bind('tglawal', $tglawal);
                // $this->db->bind('tglakhir', $tglakhir);
                $this->db->bind('ruangRawat', $ruangRawat);
            } else {
                // $cek='4';
                // var_dump($cek);
                // var_dump($tipeRawat);
                // var_dump($ruangRawat);
                // var_dump($tglawal);
                // var_dump($tglakhir);
                // exit;
                $this->db->query("SELECT ID,Tipe_Rawat,RuangRawat,Tanggal,Jumlah,Opr,OP_B,OP_IDOB,OP_BC,OP_IDOBC,OP_C,OP_IDOC,OP_K,OP_IDOK,OP_WSD,OP_IDOWSD,Infus_CVL,Infus_IAD,Infus_IVL,Infus_UC,Infus_ISK,ETT_Vent,VAP,TB,HAP,DEK_G1,DEK_G2,DEK_G3,DEK_G4,PLEB_G1,PLEB_G2,PLEB_G3,PLEB_G4,PLEB_G5,JumlahAntibiotik_1,JumlahAntibiotik_2,JumlahAntibiotik_3,JumlahKuman_D,JumlahKuman_S,JumlahKuman_SPT,JumlahKuman_Ur FROM MasterdataSQL.dbo.Master_Sensus_PPI WHERE Tipe_Rawat = :tipeRawat AND RuangRawat = :ruangRawat AND  Tanggal BETWEEN :tglawal AND :tglakhir");
                $this->db->bind('ruangRawat', $ruangRawat);
                $this->db->bind('tipeRawat', $tipeRawat);
                // $this->db->bind('tglawal', $tglawal);
                // $this->db->bind('tglakhir', $tglakhir);
            }

            // $this->db->bind('ruangRawat', $ruangRawat);
            // $this->db->bind('tipeRawat', $tipeRawat);
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);


            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();

            foreach ($data as $key) {

                $pasing['ID'] = $key['ID'];
                $pasing['Tipe_Rawat'] = $key['Tipe_Rawat'];
                $pasing['RuangRawat'] = $key['RuangRawat'];

                $pasing['Tanggal'] = $key['Tanggal'];
                $pasing['Jumlah'] = $key['Jumlah'];
                $pasing['Opr'] = $key['Opr'];

                $pasing['OP_B'] = $key['OP_B'];
                $pasing['OP_IDOB'] = $key['OP_IDOB'];
                $pasing['OP_BC'] = $key['OP_BC'];
                $pasing['OP_IDOBC'] = $key['OP_IDOBC'];
                $pasing['OP_C'] = $key['OP_C'];
                $pasing['OP_IDOC'] = $key['OP_IDOC'];
                $pasing['OP_K'] = $key['OP_K'];
                $pasing['OP_IDOK'] = $key['OP_IDOK'];
                $pasing['OP_WSD'] = $key['OP_WSD'];
                $pasing['OP_IDOWSD'] = $key['OP_IDOWSD'];

                $pasing['Infus_CVL'] = $key['Infus_CVL'];
                $pasing['Infus_IAD'] = $key['Infus_IAD'];
                $pasing['Infus_IVL'] = $key['Infus_IVL'];
                $pasing['Infus_UC'] = $key['Infus_UC'];
                $pasing['Infus_ISK'] = $key['Infus_ISK'];

                $pasing['ETT_Vent'] = $key['ETT_Vent'];
                $pasing['VAP'] = $key['VAP'];
                $pasing['TB'] = $key['TB'];
                $pasing['HAP'] = $key['HAP'];

                $pasing['DEK_G1'] = $key['DEK_G1'];
                $pasing['DEK_G2'] = $key['DEK_G2'];
                $pasing['DEK_G3'] = $key['DEK_G3'];
                $pasing['DEK_G4'] = $key['DEK_G4'];

                $pasing['PLEB_G1'] = $key['PLEB_G1'];
                $pasing['PLEB_G2'] = $key['PLEB_G2'];
                $pasing['PLEB_G3'] = $key['PLEB_G3'];
                $pasing['PLEB_G4'] = $key['PLEB_G4'];
                $pasing['PLEB_G5'] = $key['PLEB_G5'];

                $pasing['JumlahAntibiotik_1'] = $key['JumlahAntibiotik_1'];
                $pasing['JumlahAntibiotik_2'] = $key['JumlahAntibiotik_2'];
                $pasing['JumlahAntibiotik_3'] = $key['JumlahAntibiotik_3'];

                $pasing['JumlahKuman_D'] = $key['JumlahKuman_D'];
                $pasing['JumlahKuman_S'] = $key['JumlahKuman_S'];
                $pasing['JumlahKuman_SPT'] = $key['JumlahKuman_SPT'];
                $pasing['JumlahKuman_Ur'] = $key['JumlahKuman_Ur'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    //data list Kuman Darah filter
    public function getDataListKumanDarahFilter($data)
    {

        $tglawal = $data['TglAwal'];
        $tglakhir = $data['TglAkhir'];
        $tipeRawat = $data['TipeRawat'];
        $ruangRawat = $data['RuangRawat'];

        try {
            if ($tipeRawat == "ALL" and $ruangRawat == "ALL") {

                $this->db->query("SELECT ID,Tipe_Rawat,RuangRawat,Tanggal,KM01_D,KM02_D,KM03_D,KM04_D,KM05_D,KM06_D,KM07_D,KM08_D,KM09_D,KM10_D,KM11_D,KM12_D,KM13_D,KM14_D,KM15_D from MasterdataSQL.dbo.Master_Sensus_PPI WHERE Tanggal BETWEEN :tglawal AND :tglakhir");
            } else if ($tipeRawat !== "ALL" and $ruangRawat == "ALL") {
                $this->db->query("SELECT ID,Tipe_Rawat,RuangRawat,Tanggal,KM01_D,KM02_D,KM03_D,KM04_D,KM05_D,KM06_D,KM07_D,KM08_D,KM09_D,KM10_D,KM11_D,KM12_D,KM13_D,KM14_D,KM15_D from MasterdataSQL.dbo.Master_Sensus_PPI WHERE Tipe_Rawat = :tipeRawat AND  Tanggal BETWEEN :tglawal AND :tglakhir");
                $this->db->bind('tipeRawat', $tipeRawat);
            } else if ($tipeRawat == "ALL" and $ruangRawat !== "ALL") {
                $this->db->query("SELECT ID,Tipe_Rawat,RuangRawat,Tanggal,KM01_D,KM02_D,KM03_D,KM04_D,KM05_D,KM06_D,KM07_D,KM08_D,KM09_D,KM10_D,KM11_D,KM12_D,KM13_D,KM14_D,KM15_D from MasterdataSQL.dbo.Master_Sensus_PPI WHERE RuangRawat = :ruangRawat AND  Tanggal BETWEEN :tglawal AND :tglakhir");
                $this->db->bind('ruangRawat', $ruangRawat);
            } else {
                $this->db->query("SELECT ID,Tipe_Rawat,RuangRawat,Tanggal,KM01_D,KM02_D,KM03_D,KM04_D,KM05_D,KM06_D,KM07_D,KM08_D,KM09_D,KM10_D,KM11_D,KM12_D,KM13_D,KM14_D,KM15_D from MasterdataSQL.dbo.Master_Sensus_PPI WHERE Tipe_Rawat = :tipeRawat AND RuangRawat = :ruangRawat AND  Tanggal BETWEEN :tglawal AND :tglakhir");
                $this->db->bind('tipeRawat', $tipeRawat);
                $this->db->bind('ruangRawat', $ruangRawat);
            }

            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);

            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['Tipe_Rawat'] = $key['Tipe_Rawat'];
                $pasing['RuangRawat'] = $key['RuangRawat'];
                $pasing['Tanggal'] = $key['Tanggal'];
                $pasing['KM01_D'] = $key['KM01_D'];
                $pasing['KM02_D'] = $key['KM02_D'];
                $pasing['KM03_D'] = $key['KM03_D'];
                $pasing['KM04_D'] = $key['KM04_D'];
                $pasing['KM05_D'] = $key['KM05_D'];
                $pasing['KM06_D'] = $key['KM06_D'];
                $pasing['KM07_D'] = $key['KM07_D'];
                $pasing['KM08_D'] = $key['KM08_D'];
                $pasing['KM09_D'] = $key['KM09_D'];
                $pasing['KM10_D'] = $key['KM10_D'];
                $pasing['KM11_D'] = $key['KM11_D'];
                $pasing['KM12_D'] = $key['KM12_D'];
                $pasing['KM13_D'] = $key['KM13_D'];
                $pasing['KM14_D'] = $key['KM14_D'];
                $pasing['KM15_D'] = $key['KM15_D'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    //data list Kuman Sputum filter
    public function getDataListKumanSputumFilter($data)
    {

        $tglawal = $data['TglAwal'];
        $tglakhir = $data['TglAkhir'];
        $tipeRawat = $data['TipeRawat'];
        $ruangRawat = $data['RuangRawat'];

        try {
            if ($tipeRawat == "ALL" and $ruangRawat == "ALL") {

                $this->db->query("SELECT ID,Tipe_Rawat,RuangRawat,Tanggal,KM01_Spt,KM02_Spt,KM03_Spt,KM04_Spt,KM05_Spt,KM06_Spt,KM07_Spt,KM08_Spt,KM09_Spt,KM10_Spt,KM11_Spt,KM12_Spt,KM13_Spt,KM14_Spt,KM15_Spt from MasterdataSQL.dbo.Master_Sensus_PPI WHERE Tanggal BETWEEN :tglawal AND :tglakhir");
            } else if ($tipeRawat !== "ALL" and $ruangRawat == "ALL") {
                $this->db->query("SELECT ID,Tipe_Rawat,RuangRawat,Tanggal,KM01_Spt,KM02_Spt,KM03_Spt,KM04_Spt,KM05_Spt,KM06_Spt,KM07_Spt,KM08_Spt,KM09_Spt,KM10_Spt,KM11_Spt,KM12_Spt,KM13_Spt,KM14_Spt,KM15_Spt from MasterdataSQL.dbo.Master_Sensus_PPI WHERE Tipe_Rawat = :tipeRawat AND  Tanggal BETWEEN :tglawal AND :tglakhir");
                $this->db->bind('tipeRawat', $tipeRawat);
            } else if ($tipeRawat == "ALL" and $ruangRawat !== "ALL") {
                $this->db->query("SELECT ID,Tipe_Rawat,RuangRawat,Tanggal,KM01_Spt,KM02_Spt,KM03_Spt,KM04_Spt,KM05_Spt,KM06_Spt,KM07_Spt,KM08_Spt,KM09_Spt,KM10_Spt,KM11_Spt,KM12_Spt,KM13_Spt,KM14_Spt,KM15_Spt from MasterdataSQL.dbo.Master_Sensus_PPI WHERE RuangRawat = :ruangRawat AND  Tanggal BETWEEN :tglawal AND :tglakhir");
                $this->db->bind('ruangRawat', $ruangRawat);
            } else {
                $this->db->query("SELECT ID,Tipe_Rawat,RuangRawat,Tanggal,KM01_Spt,KM02_Spt,KM03_Spt,KM04_Spt,KM05_Spt,KM06_Spt,KM07_Spt,KM08_Spt,KM09_Spt,KM10_Spt,KM11_Spt,KM12_Spt,KM13_Spt,KM14_Spt,KM15_Spt from MasterdataSQL.dbo.Master_Sensus_PPI WHERE Tipe_Rawat = :tipeRawat AND RuangRawat = :ruangRawat AND  Tanggal BETWEEN :tglawal AND :tglakhir");
                $this->db->bind('tipeRawat', $tipeRawat);
                $this->db->bind('ruangRawat', $ruangRawat);
            }

            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);

            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['Tipe_Rawat'] = $key['Tipe_Rawat'];
                $pasing['RuangRawat'] = $key['RuangRawat'];
                $pasing['Tanggal'] = $key['Tanggal'];
                $pasing['KM01_Spt'] = $key['KM01_Spt'];
                $pasing['KM02_Spt'] = $key['KM02_Spt'];
                $pasing['KM03_Spt'] = $key['KM03_Spt'];
                $pasing['KM04_Spt'] = $key['KM04_Spt'];
                $pasing['KM05_Spt'] = $key['KM05_Spt'];
                $pasing['KM06_Spt'] = $key['KM06_Spt'];
                $pasing['KM07_Spt'] = $key['KM07_Spt'];
                $pasing['KM08_Spt'] = $key['KM08_Spt'];
                $pasing['KM09_Spt'] = $key['KM09_Spt'];
                $pasing['KM10_Spt'] = $key['KM10_Spt'];
                $pasing['KM11_Spt'] = $key['KM11_Spt'];
                $pasing['KM12_Spt'] = $key['KM12_Spt'];
                $pasing['KM13_Spt'] = $key['KM13_Spt'];
                $pasing['KM14_Spt'] = $key['KM14_Spt'];
                $pasing['KM15_Spt'] = $key['KM15_Spt'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    //data list Kuman Urine filter
    public function getDataListKumanUrineFilter($data)
    {

        $tglawal = $data['TglAwal'];
        $tglakhir = $data['TglAkhir'];
        $tipeRawat = $data['TipeRawat'];
        $ruangRawat = $data['RuangRawat'];

        try {
            if ($tipeRawat == "ALL" and $ruangRawat == "ALL") {

                $this->db->query("SELECT ID,Tipe_Rawat,RuangRawat,Tanggal,KM01_Ur,KM02_Ur,KM03_Ur,KM04_Ur,KM05_Ur,KM06_Ur,KM07_Ur,KM08_Ur,KM09_Ur,KM10_Ur,KM11_Ur,KM12_Ur,KM13_Ur,KM14_Ur,KM15_Ur from MasterdataSQL.dbo.Master_Sensus_PPI WHERE Tanggal BETWEEN :tglawal AND :tglakhir");
            } else if ($tipeRawat !== "ALL" and $ruangRawat == "ALL") {
                $this->db->query("SELECT ID,Tipe_Rawat,RuangRawat,Tanggal,KM01_Ur,KM02_Ur,KM03_Ur,KM04_Ur,KM05_Ur,KM06_Ur,KM07_Ur,KM08_Ur,KM09_Ur,KM10_Ur,KM11_Ur,KM12_Ur,KM13_Ur,KM14_Ur,KM15_Ur from MasterdataSQL.dbo.Master_Sensus_PPI WHERE Tipe_Rawat = :tipeRawat AND  Tanggal BETWEEN :tglawal AND :tglakhir");
                $this->db->bind('tipeRawat', $tipeRawat);
            } else if ($tipeRawat == "ALL" and $ruangRawat !== "ALL") {
                $this->db->query("SELECT ID,Tipe_Rawat,RuangRawat,Tanggal,KM01_Ur,KM02_Ur,KM03_Ur,KM04_Ur,KM05_Ur,KM06_Ur,KM07_Ur,KM08_Ur,KM09_Ur,KM10_Ur,KM11_Ur,KM12_Ur,KM13_Ur,KM14_Ur,KM15_Ur from MasterdataSQL.dbo.Master_Sensus_PPI WHERE RuangRawat = :ruangRawat AND  Tanggal BETWEEN :tglawal AND :tglakhir");
                $this->db->bind('ruangRawat', $ruangRawat);
            } else {
                $this->db->query("SELECT ID,Tipe_Rawat,RuangRawat,Tanggal,KM01_Ur,KM02_Ur,KM03_Ur,KM04_Ur,KM05_Ur,KM06_Ur,KM07_Ur,KM08_Ur,KM09_Ur,KM10_Ur,KM11_Ur,KM12_Ur,KM13_Ur,KM14_Ur,KM15_Ur from MasterdataSQL.dbo.Master_Sensus_PPI WHERE Tipe_Rawat = :tipeRawat AND RuangRawat = :ruangRawat AND  Tanggal BETWEEN :tglawal AND :tglakhir");
                $this->db->bind('tipeRawat', $tipeRawat);
                $this->db->bind('ruangRawat', $ruangRawat);
            }

            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);

            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['Tipe_Rawat'] = $key['Tipe_Rawat'];
                $pasing['RuangRawat'] = $key['RuangRawat'];
                $pasing['Tanggal'] = $key['Tanggal'];
                $pasing['KM01_Ur'] = $key['KM01_Ur'];
                $pasing['KM02_Ur'] = $key['KM02_Ur'];
                $pasing['KM03_Ur'] = $key['KM03_Ur'];
                $pasing['KM04_Ur'] = $key['KM04_Ur'];
                $pasing['KM05_Ur'] = $key['KM05_Ur'];
                $pasing['KM06_Ur'] = $key['KM06_Ur'];
                $pasing['KM07_Ur'] = $key['KM07_Ur'];
                $pasing['KM08_Ur'] = $key['KM08_Ur'];
                $pasing['KM09_Ur'] = $key['KM09_Ur'];
                $pasing['KM10_Ur'] = $key['KM10_Ur'];
                $pasing['KM11_Ur'] = $key['KM11_Ur'];
                $pasing['KM12_Ur'] = $key['KM12_Ur'];
                $pasing['KM13_Ur'] = $key['KM13_Ur'];
                $pasing['KM14_Ur'] = $key['KM14_Ur'];
                $pasing['KM15_Ur'] = $key['KM15_Ur'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    //data list Kuman Swab filter
    public function getDataListKumanSwabFilter($data)
    {

        $tglawal = $data['TglAwal'];
        $tglakhir = $data['TglAkhir'];
        $tipeRawat = $data['TipeRawat'];
        $ruangRawat = $data['RuangRawat'];

        try {
            if ($tipeRawat == "ALL" and $ruangRawat == "ALL") {

                $this->db->query("SELECT ID,Tipe_Rawat,RuangRawat,Tanggal,KM01_S,KM02_S,KM03_S,KM04_S,KM05_S,KM06_S,KM07_S,KM08_S,KM09_S,KM10_S,KM11_S,KM12_S,KM13_S,KM14_S,KM15_S from MasterdataSQL.dbo.Master_Sensus_PPI WHERE Tanggal BETWEEN :tglawal AND :tglakhir");
            } else if ($tipeRawat !== "ALL" and $ruangRawat == "ALL") {
                $this->db->query("SELECT ID,Tipe_Rawat,RuangRawat,Tanggal,KM01_S,KM02_S,KM03_S,KM04_S,KM05_S,KM06_S,KM07_S,KM08_S,KM09_S,KM10_S,KM11_S,KM12_S,KM13_S,KM14_S,KM15_S from MasterdataSQL.dbo.Master_Sensus_PPI WHERE Tipe_Rawat = :tipeRawat AND  Tanggal BETWEEN :tglawal AND :tglakhir");
                $this->db->bind('tipeRawat', $tipeRawat);
            } else if ($tipeRawat == "ALL" and $ruangRawat !== "ALL") {
                $this->db->query("SELECT ID,Tipe_Rawat,RuangRawat,Tanggal,KM01_S,KM02_S,KM03_S,KM04_S,KM05_S,KM06_S,KM07_S,KM08_S,KM09_S,KM10_S,KM11_S,KM12_S,KM13_S,KM14_S,KM15_S from MasterdataSQL.dbo.Master_Sensus_PPI WHERE RuangRawat = :ruangRawat AND  Tanggal BETWEEN :tglawal AND :tglakhir");
                $this->db->bind('ruangRawat', $ruangRawat);
            } else {
                $this->db->query("SELECT ID,Tipe_Rawat,RuangRawat,Tanggal,KM01_S,KM02_S,KM03_S,KM04_S,KM05_S,KM06_S,KM07_S,KM08_S,KM09_S,KM10_S,KM11_S,KM12_S,KM13_S,KM14_S,KM15_S from MasterdataSQL.dbo.Master_Sensus_PPI WHERE Tipe_Rawat = :tipeRawat AND RuangRawat = :ruangRawat AND  Tanggal BETWEEN :tglawal AND :tglakhir");
                $this->db->bind('tipeRawat', $tipeRawat);
                $this->db->bind('ruangRawat', $ruangRawat);
            }

            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);

            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['Tipe_Rawat'] = $key['Tipe_Rawat'];
                $pasing['RuangRawat'] = $key['RuangRawat'];
                $pasing['Tanggal'] = $key['Tanggal'];
                $pasing['KM01_S'] = $key['KM01_S'];
                $pasing['KM02_S'] = $key['KM02_S'];
                $pasing['KM03_S'] = $key['KM03_S'];
                $pasing['KM04_S'] = $key['KM04_S'];
                $pasing['KM05_S'] = $key['KM05_S'];
                $pasing['KM06_S'] = $key['KM06_S'];
                $pasing['KM07_S'] = $key['KM07_S'];
                $pasing['KM08_S'] = $key['KM08_S'];
                $pasing['KM09_S'] = $key['KM09_S'];
                $pasing['KM10_S'] = $key['KM10_S'];
                $pasing['KM11_S'] = $key['KM11_S'];
                $pasing['KM12_S'] = $key['KM12_S'];
                $pasing['KM13_S'] = $key['KM13_S'];
                $pasing['KM14_S'] = $key['KM14_S'];
                $pasing['KM15_S'] = $key['KM15_S'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    //data list Sensus PPI
    public function getDataSensusPPI()
    {
        try {
            // $tglawal = $data['tglawal'];
            // $tglAkhir=$data['TglAkhir'];

            // var_dump($tglAwal);
            // exit;

            $this->db->query("SELECT ID,Tipe_Rawat,Tanggal,Jumlah,Opr,OP_B,OP_IDOB,OP_BC,OP_IDOBC,OP_C,OP_IDOC,OP_K,OP_IDOK,OP_WSD,OP_IDOWSD,Infus_CVL,Infus_IAD,Infus_IVL,Infus_UC,Infus_ISK,ETT_Vent,VAP,TB,HAP,DEK_G1,DEK_G2,DEK_G3,DEK_G4,PLEB_G1,PLEB_G2,PLEB_G3,PLEB_G4,PLEB_G5,JumlahAntibiotik_1,JumlahAntibiotik_2,JumlahAntibiotik_3,JumlahKuman_D,JumlahKuman_S,JumlahKuman_SPT,JumlahKuman_Ur from MasterdataSQL.dbo.Master_Sensus_PPI");

            // $this->db->bind('tglawal', $tglawal);
            // $this->db->bind('tglakhir', $tglakhir);

            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['Tipe_Rawat'] = $key['Tipe_Rawat'];
                $pasing['Tanggal'] = $key['Tanggal'];
                $pasing['Jumlah'] = $key['Jumlah'];
                $pasing['Opr'] = $key['Opr'];

                $pasing['OP_B'] = $key['OP_B'];
                $pasing['OP_IDOB'] = $key['OP_IDOB'];
                $pasing['OP_BC'] = $key['OP_BC'];
                $pasing['OP_IDOBC'] = $key['OP_IDOBC'];
                $pasing['OP_C'] = $key['OP_C'];
                $pasing['OP_IDOC'] = $key['OP_IDOC'];
                $pasing['OP_K'] = $key['OP_K'];
                $pasing['OP_IDOK'] = $key['OP_IDOK'];
                $pasing['OP_WSD'] = $key['OP_WSD'];
                $pasing['OP_IDOWSD'] = $key['OP_IDOWSD'];

                $pasing['Infus_CVL'] = $key['Infus_CVL'];
                $pasing['Infus_IAD'] = $key['Infus_IAD'];
                $pasing['Infus_IVL'] = $key['Infus_IVL'];
                $pasing['Infus_UC'] = $key['Infus_UC'];
                $pasing['Infus_ISK'] = $key['Infus_ISK'];

                $pasing['ETT_Vent'] = $key['ETT_Vent'];
                $pasing['VAP'] = $key['VAP'];
                $pasing['TB'] = $key['TB'];
                $pasing['HAP'] = $key['HAP'];

                $pasing['DEK_G1'] = $key['DEK_G1'];
                $pasing['DEK_G2'] = $key['DEK_G2'];
                $pasing['DEK_G3'] = $key['DEK_G3'];
                $pasing['DEK_G4'] = $key['DEK_G4'];

                $pasing['PLEB_G1'] = $key['PLEB_G1'];
                $pasing['PLEB_G2'] = $key['PLEB_G2'];
                $pasing['PLEB_G3'] = $key['PLEB_G3'];
                $pasing['PLEB_G4'] = $key['PLEB_G4'];
                $pasing['PLEB_G5'] = $key['PLEB_G5'];

                $pasing['JumlahAntibiotik_1'] = $key['JumlahAntibiotik_1'];
                $pasing['JumlahAntibiotik_2'] = $key['JumlahAntibiotik_2'];
                $pasing['JumlahAntibiotik_3'] = $key['JumlahAntibiotik_3'];

                $pasing['JumlahKuman_D'] = $key['JumlahKuman_D'];
                $pasing['JumlahKuman_S'] = $key['JumlahKuman_S'];
                $pasing['JumlahKuman_SPT'] = $key['JumlahKuman_SPT'];
                $pasing['JumlahKuman_Ur'] = $key['JumlahKuman_Ur'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    //data list Kuman Darah
    // public function getDataListKumanDarah()
    // {
    //     try {
    //         $this->db->query("SELECT ID,Tanggal,KM01_D,KM02_D,KM03_D,KM04_D,KM05_D,KM06_D,KM07_D,KM08_D,KM09_D,KM10_D,KM11_D,KM12_D,KM13_D,KM14_D,KM15_D from MasterdataSQL.dbo.Master_Sensus_PPI");
    //         $data =  $this->db->resultSet();
    //         $rows = array();
    //         $array = array();
    //         foreach ($data as $key) {
    //             $pasing['ID'] = $key['ID'];
    //             $pasing['Tanggal'] = $key['Tanggal'];
    //             $pasing['KM01_D'] = $key['KM01_D'];
    //             $pasing['KM02_D'] = $key['KM02_D'];
    //             $pasing['KM03_D'] = $key['KM03_D'];
    //             $pasing['KM04_D'] = $key['KM04_D'];
    //             $pasing['KM05_D'] = $key['KM05_D'];
    //             $pasing['KM06_D'] = $key['KM06_D'];
    //             $pasing['KM07_D'] = $key['KM07_D'];
    //             $pasing['KM08_D'] = $key['KM08_D'];
    //             $pasing['KM09_D'] = $key['KM09_D'];
    //             $pasing['KM10_D'] = $key['KM10_D'];
    //             $pasing['KM11_D'] = $key['KM11_D'];
    //             $pasing['KM12_D'] = $key['KM12_D'];
    //             $pasing['KM13_D'] = $key['KM13_D'];
    //             $pasing['KM14_D'] = $key['KM14_D'];
    //             $pasing['KM15_D'] = $key['KM15_D'];

    //             $rows[] = $pasing;
    //         }
    //         return $rows;
    //     } catch (PDOException $e) {
    //         die($e->getMessage());
    //     }
    // }



    //data list Kuman Sputum
    // public function getDataListKumanSputum()
    // {
    //     try {
    //         $this->db->query("SELECT ID,Tanggal,KM01_Spt,KM02_Spt,KM03_Spt,KM04_Spt,KM05_Spt,KM06_Spt,KM07_Spt,KM08_Spt,KM09_Spt,KM10_Spt,KM11_Spt,KM12_Spt,KM13_Spt,KM14_Spt,KM15_Spt from MasterdataSQL.dbo.Master_Sensus_PPI");
    //         $data =  $this->db->resultSet();
    //         $rows = array();
    //         $array = array();
    //         foreach ($data as $key) {
    //             $pasing['ID'] = $key['ID'];
    //             $pasing['Tanggal'] = $key['Tanggal'];
    //             $pasing['KM01_Spt'] = $key['KM01_Spt'];
    //             $pasing['KM02_Spt'] = $key['KM02_Spt'];
    //             $pasing['KM03_Spt'] = $key['KM03_Spt'];
    //             $pasing['KM04_Spt'] = $key['KM04_Spt'];
    //             $pasing['KM05_Spt'] = $key['KM05_Spt'];
    //             $pasing['KM06_Spt'] = $key['KM06_Spt'];
    //             $pasing['KM07_Spt'] = $key['KM07_Spt'];
    //             $pasing['KM08_Spt'] = $key['KM08_Spt'];
    //             $pasing['KM09_Spt'] = $key['KM09_Spt'];
    //             $pasing['KM10_Spt'] = $key['KM10_Spt'];
    //             $pasing['KM11_Spt'] = $key['KM11_Spt'];
    //             $pasing['KM12_Spt'] = $key['KM12_Spt'];
    //             $pasing['KM13_Spt'] = $key['KM13_Spt'];
    //             $pasing['KM14_Spt'] = $key['KM14_Spt'];
    //             $pasing['KM15_Spt'] = $key['KM15_Spt'];

    //             $rows[] = $pasing;
    //         }
    //         return $rows;
    //     } catch (PDOException $e) {
    //         die($e->getMessage());
    //     }
    // }

    //data list Kuman Urine
    public function getDataListKumanUrine()
    {
        try {
            $this->db->query("SELECT ID,Tanggal,KM01_Ur,KM02_Ur,KM03_Ur,KM04_Ur,KM05_Ur,KM06_Ur,KM07_Ur,KM08_Ur,KM09_Ur,KM10_Ur,KM11_Ur,KM12_Ur,KM13_Ur,KM14_Ur,KM15_Ur from MasterdataSQL.dbo.Master_Sensus_PPI");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['Tanggal'] = $key['Tanggal'];
                $pasing['KM01_Ur'] = $key['KM01_Ur'];
                $pasing['KM02_Ur'] = $key['KM02_Ur'];
                $pasing['KM03_Ur'] = $key['KM03_Ur'];
                $pasing['KM04_Ur'] = $key['KM04_Ur'];
                $pasing['KM05_Ur'] = $key['KM05_Ur'];
                $pasing['KM06_Ur'] = $key['KM06_Ur'];
                $pasing['KM07_Ur'] = $key['KM07_Ur'];
                $pasing['KM08_Ur'] = $key['KM08_Ur'];
                $pasing['KM09_Ur'] = $key['KM09_Ur'];
                $pasing['KM10_Ur'] = $key['KM10_Ur'];
                $pasing['KM11_Ur'] = $key['KM11_Ur'];
                $pasing['KM12_Ur'] = $key['KM12_Ur'];
                $pasing['KM13_Ur'] = $key['KM13_Ur'];
                $pasing['KM14_Ur'] = $key['KM14_Ur'];
                $pasing['KM15_Ur'] = $key['KM15_Ur'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    //data list Kuman Swab
    public function getDataListKumanSwab()
    {
        try {
            $this->db->query("SELECT ID,Tanggal,KM01_S,KM02_S,KM03_S,KM04_S,KM05_S,KM06_S,KM07_S,KM08_S,KM09_S,KM10_S,KM11_S,KM12_S,KM13_S,KM14_S,KM15_S from MasterdataSQL.dbo.Master_Sensus_PPI");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['Tanggal'] = $key['Tanggal'];
                $pasing['KM01_S'] = $key['KM01_S'];
                $pasing['KM02_S'] = $key['KM02_S'];
                $pasing['KM03_S'] = $key['KM03_S'];
                $pasing['KM04_S'] = $key['KM04_S'];
                $pasing['KM05_S'] = $key['KM05_S'];
                $pasing['KM06_S'] = $key['KM06_S'];
                $pasing['KM07_S'] = $key['KM07_S'];
                $pasing['KM08_S'] = $key['KM08_S'];
                $pasing['KM09_S'] = $key['KM09_S'];
                $pasing['KM10_S'] = $key['KM10_S'];
                $pasing['KM11_S'] = $key['KM11_S'];
                $pasing['KM12_S'] = $key['KM12_S'];
                $pasing['KM13_S'] = $key['KM13_S'];
                $pasing['KM14_S'] = $key['KM14_S'];
                $pasing['KM15_S'] = $key['KM15_S'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    // INSERT Sensus Ranap Rajal
    public function insert($data)
    {


        // var_dump($cekx);

        try {
            $this->db->transaksi();
            if ($data['SensusTanggal'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Tanggal !',
                );
                return $callback;
                exit;
            }
            if ($data['SensusRuangRawat'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Pilih Ruang Rawat !',
                );
                return $callback;
                exit;
            }
            if ($data['Sensusjumlah'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Jumlah Pasien !',
                );
                return $callback;
                exit;
            }
            $IdAuto = $data['IdAuto'];
            $SensusTipeRawat = $data['SensusTipeRawat'];
            $SensusRuangRawat = $data['SensusRuangRawat'];
            $SensusTanggal = $data['SensusTanggal'];
            $Sensusjumlah = $data['Sensusjumlah'];
            $SensusOpr = $data['SensusOpr'];


            $SensusB = $data['SensusB'];
            $SensusIDOB = $data['SensusIDOB'];
            $SensusBC = $data['SensusBC'];
            $SensusIDOBC = $data['SensusIDOBC'];
            $SensusC = $data['SensusC'];
            $SensusIDOC = $data['SensusIDOC'];
            $SensusK = $data['SensusK'];
            $SensusIDOK = $data['SensusIDOK'];
            $SensusWSD = $data['SensusWSD'];
            $SensusIDOWSD = $data['SensusIDOWSD'];

            $SensusCVL = $data['SensusCVL'];
            $SensusIAD = $data['SensusIAD'];
            $SensusIVL = $data['SensusIVL'];
            $SensusUC = $data['SensusUC'];
            $SensusISK = $data['SensusISK'];

            $SensusETTVENT = $data['SensusETTVENT'];
            $SensusVAP = $data['SensusVAP'];
            $SensusTB = $data['SensusTB'];
            $SensusHAP = $data['SensusHAP'];

            $SensusDEKG1 = $data['SensusDEKG1'];
            $SensusDEKG2 = $data['SensusDEKG2'];
            $SensusDEKG3 = $data['SensusDEKG3'];
            $SensusDEKG4 = $data['SensusDEKG4'];

            $SensusPLEBG1 = $data['SensusPLEBG1'];
            $SensusPLEBG2 = $data['SensusPLEBG2'];
            $SensusPLEBG3 = $data['SensusPLEBG3'];
            $SensusPLEBG4 = $data['SensusPLEBG4'];
            $SensusPLEBG5 = $data['SensusPLEBG5'];

            $SensusJA1 = $data['SensusJA1'];
            $SensusJA2 = $data['SensusJA2'];
            $SensusJA3 = $data['SensusJA3'];

            $SensusJKD = $data['SensusJKD'];
            $SensusJKS = $data['SensusJKS'];
            $SensusJKSPT = $data['SensusJKSPT'];
            $SensusJKUR = $data['SensusJKUR'];

            $SensusDarahKM01 = $data['SensusDarahKM01'];
            $SensusDarahKM02 = $data['SensusDarahKM02'];
            $SensusDarahKM03 = $data['SensusDarahKM03'];
            $SensusDarahKM04 = $data['SensusDarahKM04'];
            $SensusDarahKM05 = $data['SensusDarahKM05'];
            $SensusDarahKM06 = $data['SensusDarahKM06'];
            $SensusDarahKM07 = $data['SensusDarahKM07'];
            $SensusDarahKM08 = $data['SensusDarahKM08'];
            $SensusDarahKM09 = $data['SensusDarahKM09'];
            $SensusDarahKM10 = $data['SensusDarahKM10'];
            $SensusDarahKM11 = $data['SensusDarahKM11'];
            $SensusDarahKM12 = $data['SensusDarahKM12'];
            $SensusDarahKM13 = $data['SensusDarahKM13'];
            $SensusDarahKM14 = $data['SensusDarahKM14'];
            $SensusDarahKM15 = $data['SensusDarahKM15'];

            $SensusSwabKM01 = $data['SensusSwabKM01'];
            $SensusSwabKM02 = $data['SensusSwabKM02'];
            $SensusSwabKM03 = $data['SensusSwabKM03'];
            $SensusSwabKM04 = $data['SensusSwabKM04'];
            $SensusSwabKM05 = $data['SensusSwabKM05'];
            $SensusSwabKM06 = $data['SensusSwabKM06'];
            $SensusSwabKM07 = $data['SensusSwabKM07'];
            $SensusSwabKM08 = $data['SensusSwabKM08'];
            $SensusSwabKM09 = $data['SensusSwabKM09'];
            $SensusSwabKM10 = $data['SensusSwabKM10'];
            $SensusSwabKM11 = $data['SensusSwabKM11'];
            $SensusSwabKM12 = $data['SensusSwabKM12'];
            $SensusSwabKM13 = $data['SensusSwabKM13'];
            $SensusSwabKM14 = $data['SensusSwabKM14'];
            $SensusSwabKM15 = $data['SensusSwabKM15'];

            $SensusSputumKM01 = $data['SensusSputumKM01'];
            $SensusSputumKM02 = $data['SensusSputumKM02'];
            $SensusSputumKM03 = $data['SensusSputumKM03'];
            $SensusSputumKM04 = $data['SensusSputumKM04'];
            $SensusSputumKM05 = $data['SensusSputumKM05'];
            $SensusSputumKM06 = $data['SensusSputumKM06'];
            $SensusSputumKM07 = $data['SensusSputumKM07'];
            $SensusSputumKM08 = $data['SensusSputumKM08'];
            $SensusSputumKM09 = $data['SensusSputumKM09'];
            $SensusSputumKM10 = $data['SensusSputumKM10'];
            $SensusSputumKM11 = $data['SensusSputumKM11'];
            $SensusSputumKM12 = $data['SensusSputumKM12'];
            $SensusSputumKM13 = $data['SensusSputumKM13'];
            $SensusSputumKM14 = $data['SensusSputumKM14'];
            $SensusSputumKM15 = $data['SensusSputumKM15'];

            $SensusUrineKM01 = $data['SensusUrineKM01'];
            $SensusUrineKM02 = $data['SensusUrineKM02'];
            $SensusUrineKM03 = $data['SensusUrineKM03'];
            $SensusUrineKM04 = $data['SensusUrineKM04'];
            $SensusUrineKM05 = $data['SensusUrineKM05'];
            $SensusUrineKM06 = $data['SensusUrineKM06'];
            $SensusUrineKM07 = $data['SensusUrineKM07'];
            $SensusUrineKM08 = $data['SensusUrineKM08'];
            $SensusUrineKM09 = $data['SensusUrineKM09'];
            $SensusUrineKM10 = $data['SensusUrineKM10'];
            $SensusUrineKM11 = $data['SensusUrineKM11'];
            $SensusUrineKM12 = $data['SensusUrineKM12'];
            $SensusUrineKM13 = $data['SensusUrineKM13'];
            $SensusUrineKM14 = $data['SensusUrineKM14'];
            $SensusUrineKM15 = $data['SensusUrineKM15'];

            if ($data['IdAuto'] == "") {

                $pinx = $data['SensusRuangRawat'];
                $piny = $data['SensusTanggal'];

                $this->db->query("SELECT ID FROM MasterdataSQL.dbo.Master_Sensus_PPI where RuangRawat=:RuangRawat AND Tanggal=:Tanggal");

                $this->db->bind('RuangRawat', $pinx);
                $this->db->bind('Tanggal', $piny);
                $datay =  $this->db->single();
                $ceky = $datay['ID'];

                if ($ceky != null) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Data Sudah Dibuat ditanggal dan Ruang rawat yang sama!'
                    );
                    return $callback;
                    exit;
                }

                $this->db->query("INSERT INTO MasterdataSQL.dbo.Master_Sensus_PPI
                            (Tipe_Rawat,RuangRawat,Tanggal,Jumlah,Opr,OP_B,OP_IDOB,OP_BC,OP_IDOBC,OP_C,OP_IDOC,OP_K,OP_IDOK,OP_WSD,OP_IDOWSD,Infus_CVL,Infus_IAD,Infus_IVL,Infus_UC,Infus_ISK,ETT_Vent,VAP,TB,HAP,DEK_G1,DEK_G2,DEK_G3,DEK_G4,PLEB_G1,PLEB_G2,PLEB_G3,PLEB_G4,PLEB_G5,JumlahAntibiotik_1,JumlahAntibiotik_2,JumlahAntibiotik_3,JumlahKuman_D,JumlahKuman_S,JumlahKuman_SPT,JumlahKuman_Ur,KM01_D,KM02_D,KM03_D,KM04_D,KM05_D,KM06_D,KM07_D,KM08_D,KM09_D,KM10_D,KM11_D,KM12_D,KM13_D,KM14_D,KM15_D,KM01_S,KM02_S,KM03_S,KM04_S,KM05_S,KM06_S,KM07_S,KM08_S,KM09_S,KM10_S,KM11_S,KM12_S,KM13_S,KM14_S,KM15_S,KM01_Spt,KM02_Spt,KM03_Spt,KM04_Spt,KM05_Spt,KM06_Spt,KM07_Spt,KM08_Spt,KM09_Spt,KM10_Spt,KM11_Spt,KM12_Spt,KM13_Spt,KM14_Spt,KM15_Spt,KM01_Ur,KM02_Ur,KM03_Ur,KM04_Ur,KM05_Ur,KM06_Ur,KM07_Ur,KM08_Ur,KM09_Ur,KM10_Ur,KM11_Ur,KM12_Ur,KM13_Ur,KM14_Ur,KM15_Ur)
                        values
                        ( :SensusTipeRawat,:SensusRuangRawat,:SensusTanggal,:Sensusjumlah,:SensusOpr,:SensusB,:SensusIDOB,:SensusBC,:SensusIDOBC,:SensusC,:SensusIDOC,:SensusK,:SensusIDOK,:SensusWSD,:SensusIDOWSD,:SensusCVL,:SensusIAD,:SensusIVL,:SensusUC,:SensusISK,:SensusETTVENT,:SensusVAP,:SensusTB,:SensusHAP,:SensusDEKG1,:SensusDEKG2,:SensusDEKG3,:SensusDEKG4,:SensusPLEBG1,:SensusPLEBG2,:SensusPLEBG3,:SensusPLEBG4,:SensusPLEBG5,:SensusJA1,:SensusJA2,:SensusJA3,:SensusJKD,:SensusJKS,:SensusJKSPT,:SensusJKUR,:SensusDarahKM01,:SensusDarahKM02,:SensusDarahKM03,:SensusDarahKM04,:SensusDarahKM05,:SensusDarahKM06,:SensusDarahKM07,:SensusDarahKM08,:SensusDarahKM09,:SensusDarahKM10,:SensusDarahKM11,:SensusDarahKM12,:SensusDarahKM13,:SensusDarahKM14,:SensusDarahKM15,:SensusSwabKM01,:SensusSwabKM02,:SensusSwabKM03,:SensusSwabKM04,:SensusSwabKM05,:SensusSwabKM06,:SensusSwabKM07,:SensusSwabKM08,:SensusSwabKM09,:SensusSwabKM10,:SensusSwabKM11,:SensusSwabKM12,:SensusSwabKM13,:SensusSwabKM14,:SensusSwabKM15,:SensusSputumKM01,:SensusSputumKM02,:SensusSputumKM03,:SensusSputumKM04,:SensusSputumKM05,:SensusSputumKM06,:SensusSputumKM07,:SensusSputumKM08,:SensusSputumKM09,:SensusSputumKM10,:SensusSputumKM11,:SensusSputumKM12,:SensusSputumKM13,:SensusSputumKM14,:SensusSputumKM15,:SensusUrineKM01,:SensusUrineKM02,:SensusUrineKM03,:SensusUrineKM04,:SensusUrineKM05,:SensusUrineKM06,:SensusUrineKM07,:SensusUrineKM08,:SensusUrineKM09,:SensusUrineKM10,:SensusUrineKM11,:SensusUrineKM12,:SensusUrineKM13,:SensusUrineKM14,:SensusUrineKM15)");


                $this->db->bind('SensusTipeRawat', $SensusTipeRawat);
                $this->db->bind('SensusRuangRawat', $SensusRuangRawat);
                $this->db->bind('SensusTanggal', $SensusTanggal);
                $this->db->bind('Sensusjumlah', $Sensusjumlah);
                $this->db->bind('SensusOpr', $SensusOpr);

                $this->db->bind('SensusB', $SensusB);
                $this->db->bind('SensusIDOB', $SensusIDOB);
                $this->db->bind('SensusBC', $SensusBC);
                $this->db->bind('SensusIDOBC', $SensusIDOBC);
                $this->db->bind('SensusC', $SensusC);
                $this->db->bind('SensusIDOC', $SensusIDOC);
                $this->db->bind('SensusK', $SensusK);
                $this->db->bind('SensusIDOK', $SensusIDOK);
                $this->db->bind('SensusWSD', $SensusWSD);
                $this->db->bind('SensusIDOWSD', $SensusIDOWSD);

                $this->db->bind('SensusCVL', $SensusCVL);
                $this->db->bind('SensusIAD', $SensusIAD);
                $this->db->bind('SensusIVL', $SensusIVL);
                $this->db->bind('SensusUC', $SensusUC);
                $this->db->bind('SensusISK', $SensusISK);

                $this->db->bind('SensusETTVENT', $SensusETTVENT);
                $this->db->bind('SensusVAP', $SensusVAP);
                $this->db->bind('SensusTB', $SensusTB);
                $this->db->bind('SensusHAP', $SensusHAP);

                $this->db->bind('SensusDEKG1', $SensusDEKG1);
                $this->db->bind('SensusDEKG2', $SensusDEKG2);
                $this->db->bind('SensusDEKG3', $SensusDEKG3);
                $this->db->bind('SensusDEKG4', $SensusDEKG4);

                $this->db->bind('SensusPLEBG1', $SensusPLEBG1);
                $this->db->bind('SensusPLEBG2', $SensusPLEBG2);
                $this->db->bind('SensusPLEBG3', $SensusPLEBG3);
                $this->db->bind('SensusPLEBG4', $SensusPLEBG4);
                $this->db->bind('SensusPLEBG5', $SensusPLEBG5);

                $this->db->bind('SensusJA1', $SensusJA1);
                $this->db->bind('SensusJA2', $SensusJA2);
                $this->db->bind('SensusJA3', $SensusJA3);

                $this->db->bind('SensusJKD', $SensusJKD);
                $this->db->bind('SensusJKS', $SensusJKS);
                $this->db->bind('SensusJKSPT', $SensusJKSPT);
                $this->db->bind('SensusJKUR', $SensusJKUR);

                $this->db->bind('SensusDarahKM01', $SensusDarahKM01);
                $this->db->bind('SensusDarahKM02', $SensusDarahKM02);
                $this->db->bind('SensusDarahKM03', $SensusDarahKM03);
                $this->db->bind('SensusDarahKM04', $SensusDarahKM04);
                $this->db->bind('SensusDarahKM05', $SensusDarahKM05);
                $this->db->bind('SensusDarahKM06', $SensusDarahKM06);
                $this->db->bind('SensusDarahKM07', $SensusDarahKM07);
                $this->db->bind('SensusDarahKM08', $SensusDarahKM08);
                $this->db->bind('SensusDarahKM09', $SensusDarahKM09);
                $this->db->bind('SensusDarahKM10', $SensusDarahKM10);
                $this->db->bind('SensusDarahKM11', $SensusDarahKM11);
                $this->db->bind('SensusDarahKM12', $SensusDarahKM12);
                $this->db->bind('SensusDarahKM13', $SensusDarahKM13);
                $this->db->bind('SensusDarahKM14', $SensusDarahKM14);
                $this->db->bind('SensusDarahKM15', $SensusDarahKM15);

                $this->db->bind('SensusSwabKM01', $SensusSwabKM01);
                $this->db->bind('SensusSwabKM02', $SensusSwabKM02);
                $this->db->bind('SensusSwabKM03', $SensusSwabKM03);
                $this->db->bind('SensusSwabKM04', $SensusSwabKM04);
                $this->db->bind('SensusSwabKM05', $SensusSwabKM05);
                $this->db->bind('SensusSwabKM06', $SensusSwabKM06);
                $this->db->bind('SensusSwabKM07', $SensusSwabKM07);
                $this->db->bind('SensusSwabKM08', $SensusSwabKM08);
                $this->db->bind('SensusSwabKM09', $SensusSwabKM09);
                $this->db->bind('SensusSwabKM10', $SensusSwabKM10);
                $this->db->bind('SensusSwabKM11', $SensusSwabKM11);
                $this->db->bind('SensusSwabKM12', $SensusSwabKM12);
                $this->db->bind('SensusSwabKM13', $SensusSwabKM13);
                $this->db->bind('SensusSwabKM14', $SensusSwabKM14);
                $this->db->bind('SensusSwabKM15', $SensusSwabKM15);

                $this->db->bind('SensusSputumKM01', $SensusSputumKM01);
                $this->db->bind('SensusSputumKM02', $SensusSputumKM02);
                $this->db->bind('SensusSputumKM03', $SensusSputumKM03);
                $this->db->bind('SensusSputumKM04', $SensusSputumKM04);
                $this->db->bind('SensusSputumKM05', $SensusSputumKM05);
                $this->db->bind('SensusSputumKM06', $SensusSputumKM06);
                $this->db->bind('SensusSputumKM07', $SensusSputumKM07);
                $this->db->bind('SensusSputumKM08', $SensusSputumKM08);
                $this->db->bind('SensusSputumKM09', $SensusSputumKM09);
                $this->db->bind('SensusSputumKM10', $SensusSputumKM10);
                $this->db->bind('SensusSputumKM11', $SensusSputumKM11);
                $this->db->bind('SensusSputumKM12', $SensusSputumKM12);
                $this->db->bind('SensusSputumKM13', $SensusSputumKM13);
                $this->db->bind('SensusSputumKM14', $SensusSputumKM14);
                $this->db->bind('SensusSputumKM15', $SensusSputumKM15);

                $this->db->bind('SensusUrineKM01', $SensusUrineKM01);
                $this->db->bind('SensusUrineKM02', $SensusUrineKM02);
                $this->db->bind('SensusUrineKM03', $SensusUrineKM03);
                $this->db->bind('SensusUrineKM04', $SensusUrineKM04);
                $this->db->bind('SensusUrineKM05', $SensusUrineKM05);
                $this->db->bind('SensusUrineKM06', $SensusUrineKM06);
                $this->db->bind('SensusUrineKM07', $SensusUrineKM07);
                $this->db->bind('SensusUrineKM08', $SensusUrineKM08);
                $this->db->bind('SensusUrineKM09', $SensusUrineKM09);
                $this->db->bind('SensusUrineKM10', $SensusUrineKM10);
                $this->db->bind('SensusUrineKM11', $SensusUrineKM11);
                $this->db->bind('SensusUrineKM12', $SensusUrineKM12);
                $this->db->bind('SensusUrineKM13', $SensusUrineKM13);
                $this->db->bind('SensusUrineKM14', $SensusUrineKM14);
                $this->db->bind('SensusUrineKM15', $SensusUrineKM15);
            } else {
                $this->db->query("UPDATE MasterdataSQL.dbo.Master_Sensus_PPI set  
                            Tipe_Rawat=:SensusTipeRawat,RuangRawat=:SensusRuangRawat,Tanggal=:SensusTanggal,Jumlah=:Sensusjumlah,Opr=:SensusOpr,OP_B=:SensusB,OP_IDOB=:SensusIDOB,OP_BC=:SensusBC,OP_IDOBC=:SensusIDOBC,OP_C=:SensusC,OP_IDOC=:SensusIDOC,OP_K=:SensusK,OP_IDOK=:SensusIDOK,OP_WSD=:SensusWSD,OP_IDOWSD=:SensusIDOWSD,Infus_CVL=:SensusCVL,Infus_IAD=:SensusIAD,Infus_IVL=:SensusIVL,Infus_UC=:SensusUC,Infus_ISK=:SensusISK,ETT_Vent=:SensusETTVENT,VAP=:SensusVAP,TB=:SensusTB,HAP=:SensusHAP,DEK_G1=:SensusDEKG1,DEK_G2=:SensusDEKG2,DEK_G3=:SensusDEKG3,DEK_G4=:SensusDEKG4,PLEB_G1=:SensusPLEBG1,PLEB_G2=:SensusPLEBG2,PLEB_G3=:SensusPLEBG3,PLEB_G4=:SensusPLEBG4,PLEB_G5=:SensusPLEBG5,JumlahAntibiotik_1=:SensusJA1,JumlahAntibiotik_2=:SensusJA2,JumlahAntibiotik_3=:SensusJA3,JumlahKuman_D=:SensusJKD,JumlahKuman_S=:SensusJKS,JumlahKuman_SPT=:SensusJKSPT,JumlahKuman_Ur=:SensusJKUR,KM01_D=:SensusDarahKM01,KM02_D=:SensusDarahKM02,KM03_D=:SensusDarahKM03,KM04_D=:SensusDarahKM04,KM05_D=:SensusDarahKM05,KM06_D=:SensusDarahKM06,KM07_D=:SensusDarahKM07,KM08_D=:SensusDarahKM08,KM09_D=:SensusDarahKM09,KM10_D=:SensusDarahKM10,KM11_D=:SensusDarahKM11,KM12_D=:SensusDarahKM12,KM13_D=:SensusDarahKM13,KM14_D=:SensusDarahKM14,KM15_D=:SensusDarahKM15,KM01_S=:SensusSwabKM01,KM02_S=:SensusSwabKM02,KM03_S=:SensusSwabKM03,KM04_S=:SensusSwabKM04,KM05_S=:SensusSwabKM05,KM06_S=:SensusSwabKM06,KM07_S=:SensusSwabKM07,KM08_S=:SensusSwabKM08,KM09_S=:SensusSwabKM09,KM10_S=:SensusSwabKM10,KM11_S=:SensusSwabKM11,KM12_S=:SensusSwabKM12,KM13_S=:SensusSwabKM13,KM14_S=:SensusSwabKM14,KM15_S=:SensusSwabKM15,KM01_Spt=:SensusSputumKM01,KM02_Spt=:SensusSputumKM02,KM03_Spt=:SensusSputumKM03,KM04_Spt=:SensusSputumKM04,KM05_Spt=:SensusSputumKM05,KM06_Spt=:SensusSputumKM06,KM07_Spt=:SensusSputumKM07,KM08_Spt=:SensusSputumKM08,KM09_Spt=:SensusSputumKM09,KM10_Spt=:SensusSputumKM10,KM11_Spt=:SensusSputumKM11,KM12_Spt=:SensusSputumKM12,KM13_Spt=:SensusSputumKM13,KM14_Spt=:SensusSputumKM14,KM15_Spt=:SensusSputumKM15,KM01_Ur=:SensusUrineKM01,KM02_Ur=:SensusUrineKM02,KM03_Ur=:SensusUrineKM03,KM04_Ur=:SensusUrineKM04,KM05_Ur=:SensusUrineKM05,KM06_Ur=:SensusUrineKM06,KM07_Ur=:SensusUrineKM07,KM08_Ur=:SensusUrineKM08,KM09_Ur=:SensusUrineKM09,KM10_Ur=:SensusUrineKM10,KM11_Ur=:SensusUrineKM11,KM12_Ur=:SensusUrineKM12,KM13_Ur=:SensusUrineKM13,KM14_Ur=:SensusUrineKM14,KM15_Ur=:SensusUrineKM15 
                            WHERE ID=:IdAuto");

                $this->db->bind('SensusTipeRawat', $SensusTipeRawat);
                $this->db->bind('SensusRuangRawat', $SensusRuangRawat);
                $this->db->bind('SensusTanggal', $SensusTanggal);
                $this->db->bind('Sensusjumlah', $Sensusjumlah);
                $this->db->bind('SensusOpr', $SensusOpr);

                $this->db->bind('SensusB', $SensusB);
                $this->db->bind('SensusIDOB', $SensusIDOB);
                $this->db->bind('SensusBC', $SensusBC);
                $this->db->bind('SensusIDOBC', $SensusIDOBC);
                $this->db->bind('SensusC', $SensusC);
                $this->db->bind('SensusIDOC', $SensusIDOC);
                $this->db->bind('SensusK', $SensusK);
                $this->db->bind('SensusIDOK', $SensusIDOK);
                $this->db->bind('SensusWSD', $SensusWSD);
                $this->db->bind('SensusIDOWSD', $SensusIDOWSD);

                $this->db->bind('SensusCVL', $SensusCVL);
                $this->db->bind('SensusIAD', $SensusIAD);
                $this->db->bind('SensusIVL', $SensusIVL);
                $this->db->bind('SensusUC', $SensusUC);
                $this->db->bind('SensusISK', $SensusISK);

                $this->db->bind('SensusETTVENT', $SensusETTVENT);
                $this->db->bind('SensusVAP', $SensusVAP);
                $this->db->bind('SensusTB', $SensusTB);
                $this->db->bind('SensusHAP', $SensusHAP);

                $this->db->bind('SensusDEKG1', $SensusDEKG1);
                $this->db->bind('SensusDEKG2', $SensusDEKG2);
                $this->db->bind('SensusDEKG3', $SensusDEKG3);
                $this->db->bind('SensusDEKG4', $SensusDEKG4);

                $this->db->bind('SensusPLEBG1', $SensusPLEBG1);
                $this->db->bind('SensusPLEBG2', $SensusPLEBG2);
                $this->db->bind('SensusPLEBG3', $SensusPLEBG3);
                $this->db->bind('SensusPLEBG4', $SensusPLEBG4);
                $this->db->bind('SensusPLEBG5', $SensusPLEBG5);

                $this->db->bind('SensusJA1', $SensusJA1);
                $this->db->bind('SensusJA2', $SensusJA2);
                $this->db->bind('SensusJA3', $SensusJA3);

                $this->db->bind('SensusJKD', $SensusJKD);
                $this->db->bind('SensusJKS', $SensusJKS);
                $this->db->bind('SensusJKSPT', $SensusJKSPT);
                $this->db->bind('SensusJKUR', $SensusJKUR);

                $this->db->bind('SensusDarahKM01', $SensusDarahKM01);
                $this->db->bind('SensusDarahKM02', $SensusDarahKM02);
                $this->db->bind('SensusDarahKM03', $SensusDarahKM03);
                $this->db->bind('SensusDarahKM04', $SensusDarahKM04);
                $this->db->bind('SensusDarahKM05', $SensusDarahKM05);
                $this->db->bind('SensusDarahKM06', $SensusDarahKM06);
                $this->db->bind('SensusDarahKM07', $SensusDarahKM07);
                $this->db->bind('SensusDarahKM08', $SensusDarahKM08);
                $this->db->bind('SensusDarahKM09', $SensusDarahKM09);
                $this->db->bind('SensusDarahKM10', $SensusDarahKM10);
                $this->db->bind('SensusDarahKM11', $SensusDarahKM11);
                $this->db->bind('SensusDarahKM12', $SensusDarahKM12);
                $this->db->bind('SensusDarahKM13', $SensusDarahKM13);
                $this->db->bind('SensusDarahKM14', $SensusDarahKM14);
                $this->db->bind('SensusDarahKM15', $SensusDarahKM15);

                $this->db->bind('SensusSwabKM01', $SensusSwabKM01);
                $this->db->bind('SensusSwabKM02', $SensusSwabKM02);
                $this->db->bind('SensusSwabKM03', $SensusSwabKM03);
                $this->db->bind('SensusSwabKM04', $SensusSwabKM04);
                $this->db->bind('SensusSwabKM05', $SensusSwabKM05);
                $this->db->bind('SensusSwabKM06', $SensusSwabKM06);
                $this->db->bind('SensusSwabKM07', $SensusSwabKM07);
                $this->db->bind('SensusSwabKM08', $SensusSwabKM08);
                $this->db->bind('SensusSwabKM09', $SensusSwabKM09);
                $this->db->bind('SensusSwabKM10', $SensusSwabKM10);
                $this->db->bind('SensusSwabKM11', $SensusSwabKM11);
                $this->db->bind('SensusSwabKM12', $SensusSwabKM12);
                $this->db->bind('SensusSwabKM13', $SensusSwabKM13);
                $this->db->bind('SensusSwabKM14', $SensusSwabKM14);
                $this->db->bind('SensusSwabKM15', $SensusSwabKM15);

                $this->db->bind('SensusSputumKM01', $SensusSputumKM01);
                $this->db->bind('SensusSputumKM02', $SensusSputumKM02);
                $this->db->bind('SensusSputumKM03', $SensusSputumKM03);
                $this->db->bind('SensusSputumKM04', $SensusSputumKM04);
                $this->db->bind('SensusSputumKM05', $SensusSputumKM05);
                $this->db->bind('SensusSputumKM06', $SensusSputumKM06);
                $this->db->bind('SensusSputumKM07', $SensusSputumKM07);
                $this->db->bind('SensusSputumKM08', $SensusSputumKM08);
                $this->db->bind('SensusSputumKM09', $SensusSputumKM09);
                $this->db->bind('SensusSputumKM10', $SensusSputumKM10);
                $this->db->bind('SensusSputumKM11', $SensusSputumKM11);
                $this->db->bind('SensusSputumKM12', $SensusSputumKM12);
                $this->db->bind('SensusSputumKM13', $SensusSputumKM13);
                $this->db->bind('SensusSputumKM14', $SensusSputumKM14);
                $this->db->bind('SensusSputumKM15', $SensusSputumKM15);

                $this->db->bind('SensusUrineKM01', $SensusUrineKM01);
                $this->db->bind('SensusUrineKM02', $SensusUrineKM02);
                $this->db->bind('SensusUrineKM03', $SensusUrineKM03);
                $this->db->bind('SensusUrineKM04', $SensusUrineKM04);
                $this->db->bind('SensusUrineKM05', $SensusUrineKM05);
                $this->db->bind('SensusUrineKM06', $SensusUrineKM06);
                $this->db->bind('SensusUrineKM07', $SensusUrineKM07);
                $this->db->bind('SensusUrineKM08', $SensusUrineKM08);
                $this->db->bind('SensusUrineKM09', $SensusUrineKM09);
                $this->db->bind('SensusUrineKM10', $SensusUrineKM10);
                $this->db->bind('SensusUrineKM11', $SensusUrineKM11);
                $this->db->bind('SensusUrineKM12', $SensusUrineKM12);
                $this->db->bind('SensusUrineKM13', $SensusUrineKM13);
                $this->db->bind('SensusUrineKM14', $SensusUrineKM14);
                $this->db->bind('SensusUrineKM15', $SensusUrineKM15);

                $this->db->bind('IdAuto', $IdAuto);
            }
            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function getSensusPPIId($id)
    {
        try {
            $this->db->query('SELECT ID,Tipe_Rawat,RuangRawat,Tanggal,Jumlah,Opr,OP_B,OP_IDOB,OP_BC,OP_IDOBC,OP_C,OP_IDOC,OP_K,OP_IDOK,OP_WSD,OP_IDOWSD,Infus_CVL,Infus_IAD,Infus_IVL,Infus_UC,Infus_ISK,ETT_Vent,VAP,TB,HAP,DEK_G1,DEK_G2,DEK_G3,DEK_G4,PLEB_G1,PLEB_G2,PLEB_G3,PLEB_G4,PLEB_G5,JumlahAntibiotik_1,JumlahAntibiotik_2,JumlahAntibiotik_3,JumlahKuman_D,JumlahKuman_S,JumlahKuman_SPT,JumlahKuman_Ur,KM01_D,KM02_D,KM03_D,KM04_D,KM05_D,KM06_D,KM07_D,KM08_D,KM09_D,KM10_D,KM11_D,KM12_D,KM13_D,KM14_D,KM15_D,KM01_S,KM02_S,KM03_S,KM04_S,KM05_S,KM06_S,KM07_S,KM08_S,KM09_S,KM10_S,KM11_S,KM12_S,KM13_S,KM14_S,KM15_S,KM01_Spt,KM02_Spt,KM03_Spt,KM04_Spt,KM05_Spt,KM06_Spt,KM07_Spt,KM08_Spt,KM09_Spt,KM10_Spt,KM11_Spt,KM12_Spt,KM13_Spt,KM14_Spt,KM15_Spt,KM01_Ur,KM02_Ur,KM03_Ur,KM04_Ur,KM05_Ur,KM06_Ur,KM07_Ur,KM08_Ur,KM09_Ur,KM10_Ur,KM11_Ur,KM12_Ur,KM13_Ur,KM14_Ur,KM15_Ur 
                            from MasterdataSQL.dbo.Master_Sensus_PPI
                            WHERE ID=:id');
            $this->db->bind('id', $id);

            $data =  $this->db->single();
            $pasing['ID'] = $data['ID'];
            $pasing['Tipe_Rawat'] = $data['Tipe_Rawat'];
            $pasing['RuangRawat'] = $data['RuangRawat'];
            $pasing['Tanggal'] = $data['Tanggal'];
            $pasing['Jumlah'] = $data['Jumlah'];
            $pasing['Opr'] = $data['Opr'];

            $pasing['OP_B'] = $data['OP_B'];
            $pasing['OP_IDOB'] = $data['OP_IDOB'];
            $pasing['OP_BC'] = $data['OP_BC'];
            $pasing['OP_IDOBC'] = $data['OP_IDOBC'];
            $pasing['OP_C'] = $data['OP_C'];
            $pasing['OP_IDOC'] = $data['OP_IDOC'];
            $pasing['OP_K'] = $data['OP_K'];
            $pasing['OP_IDOK'] = $data['OP_IDOK'];
            $pasing['OP_WSD'] = $data['OP_WSD'];
            $pasing['OP_IDOWSD'] = $data['OP_IDOWSD'];

            $pasing['Infus_CVL'] = $data['Infus_CVL'];
            $pasing['Infus_IAD'] = $data['Infus_IAD'];
            $pasing['Infus_IVL'] = $data['Infus_IVL'];
            $pasing['Infus_UC'] = $data['Infus_UC'];
            $pasing['Infus_ISK'] = $data['Infus_ISK'];

            $pasing['ETT_Vent'] = $data['ETT_Vent'];
            $pasing['VAP'] = $data['VAP'];
            $pasing['TB'] = $data['TB'];
            $pasing['HAP'] = $data['HAP'];

            $pasing['DEK_G1'] = $data['DEK_G1'];
            $pasing['DEK_G2'] = $data['DEK_G2'];
            $pasing['DEK_G3'] = $data['DEK_G3'];
            $pasing['DEK_G4'] = $data['DEK_G4'];

            $pasing['PLEB_G1'] = $data['PLEB_G1'];
            $pasing['PLEB_G2'] = $data['PLEB_G2'];
            $pasing['PLEB_G3'] = $data['PLEB_G3'];
            $pasing['PLEB_G4'] = $data['PLEB_G4'];
            $pasing['PLEB_G5'] = $data['PLEB_G5'];

            $pasing['JumlahAntibiotik_1'] = $data['JumlahAntibiotik_1'];
            $pasing['JumlahAntibiotik_2'] = $data['JumlahAntibiotik_2'];
            $pasing['JumlahAntibiotik_3'] = $data['JumlahAntibiotik_3'];

            $pasing['JumlahKuman_D'] = $data['JumlahKuman_D'];
            $pasing['JumlahKuman_S'] = $data['JumlahKuman_S'];
            $pasing['JumlahKuman_SPT'] = $data['JumlahKuman_SPT'];
            $pasing['JumlahKuman_Ur'] = $data['JumlahKuman_Ur'];

            $pasing['KM01_D'] = $data['KM01_D'];
            $pasing['KM02_D'] = $data['KM02_D'];
            $pasing['KM03_D'] = $data['KM03_D'];
            $pasing['KM04_D'] = $data['KM04_D'];
            $pasing['KM05_D'] = $data['KM05_D'];
            $pasing['KM06_D'] = $data['KM06_D'];
            $pasing['KM07_D'] = $data['KM07_D'];
            $pasing['KM08_D'] = $data['KM08_D'];
            $pasing['KM09_D'] = $data['KM09_D'];
            $pasing['KM10_D'] = $data['KM10_D'];
            $pasing['KM11_D'] = $data['KM11_D'];
            $pasing['KM12_D'] = $data['KM12_D'];
            $pasing['KM13_D'] = $data['KM13_D'];
            $pasing['KM14_D'] = $data['KM14_D'];
            $pasing['KM15_D'] = $data['KM15_D'];

            $pasing['KM01_Spt'] = $data['KM01_Spt'];
            $pasing['KM02_Spt'] = $data['KM02_Spt'];
            $pasing['KM03_Spt'] = $data['KM03_Spt'];
            $pasing['KM04_Spt'] = $data['KM04_Spt'];
            $pasing['KM05_Spt'] = $data['KM05_Spt'];
            $pasing['KM06_Spt'] = $data['KM06_Spt'];
            $pasing['KM07_Spt'] = $data['KM07_Spt'];
            $pasing['KM08_Spt'] = $data['KM08_Spt'];
            $pasing['KM09_Spt'] = $data['KM09_Spt'];
            $pasing['KM10_Spt'] = $data['KM10_Spt'];
            $pasing['KM11_Spt'] = $data['KM11_Spt'];
            $pasing['KM12_Spt'] = $data['KM12_Spt'];
            $pasing['KM13_Spt'] = $data['KM13_Spt'];
            $pasing['KM14_Spt'] = $data['KM14_Spt'];
            $pasing['KM15_Spt'] = $data['KM15_Spt'];

            $pasing['KM01_Ur'] = $data['KM01_Ur'];
            $pasing['KM02_Ur'] = $data['KM02_Ur'];
            $pasing['KM03_Ur'] = $data['KM03_Ur'];
            $pasing['KM04_Ur'] = $data['KM04_Ur'];
            $pasing['KM05_Ur'] = $data['KM05_Ur'];
            $pasing['KM06_Ur'] = $data['KM06_Ur'];
            $pasing['KM07_Ur'] = $data['KM07_Ur'];
            $pasing['KM08_Ur'] = $data['KM08_Ur'];
            $pasing['KM09_Ur'] = $data['KM09_Ur'];
            $pasing['KM10_Ur'] = $data['KM10_Ur'];
            $pasing['KM11_Ur'] = $data['KM11_Ur'];
            $pasing['KM12_Ur'] = $data['KM12_Ur'];
            $pasing['KM13_Ur'] = $data['KM13_Ur'];
            $pasing['KM14_Ur'] = $data['KM14_Ur'];
            $pasing['KM15_Ur'] = $data['KM15_Ur'];

            $pasing['KM01_S'] = $data['KM01_S'];
            $pasing['KM02_S'] = $data['KM02_S'];
            $pasing['KM03_S'] = $data['KM03_S'];
            $pasing['KM04_S'] = $data['KM04_S'];
            $pasing['KM05_S'] = $data['KM05_S'];
            $pasing['KM06_S'] = $data['KM06_S'];
            $pasing['KM07_S'] = $data['KM07_S'];
            $pasing['KM08_S'] = $data['KM08_S'];
            $pasing['KM09_S'] = $data['KM09_S'];
            $pasing['KM10_S'] = $data['KM10_S'];
            $pasing['KM11_S'] = $data['KM11_S'];
            $pasing['KM12_S'] = $data['KM12_S'];
            $pasing['KM13_S'] = $data['KM13_S'];
            $pasing['KM14_S'] = $data['KM14_S'];
            $pasing['KM15_S'] = $data['KM15_S'];

            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
}
