<?php


class AbsensiManual_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    } 
    
    // INSERT
    public function showDataAbsensiManualAll($data)
    {
        try {
            $manual = "1";
            $this->db->query("SELECT A.ID,A.FD_TGL,A.FS_PIN,A.FS_KD_PEG,A.IO,A.PetugasAddManual,
                            replace(CONVERT(VARCHAR(11), A.TglAddManual, 111), '/','-') as TglAddManual,B.Nama
                            FROM HR_A_LOG_FINGER A
                            INNER JOIN [HR_Data Pegawai] B
                            ON A.FS_KD_PEG = B.ID_Data
                            where a.Manual=:manual
                             order by a.Nama asc, a.FD_TGL desc ");
            $this->db->bind('manual', $manual);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['FD_TGL'] = $key['FD_TGL'];
                $pasing['FS_PIN'] = $key['FS_PIN'];
                $pasing['FS_KD_PEG'] = $key['FS_KD_PEG'];
                $pasing['Nama'] = $key['Nama'];
                $pasing['IO'] = $key['IO'];
                $pasing['ID'] = $key['ID'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function ShowDataAbsensiManualByID($data)
    {
        try {
            $this->db->query("SELECT ID,FS_PIN,FS_KD_PEG,IO,replace(CONVERT(VARCHAR(11), FD_TGL, 111), '/','-') as TglLog,
                CONVERT(VARCHAR(8),FD_TGL,114) as JamLog
                FROM HR_A_LOG_FINGER
                where ID=:params");
            $this->db->bind('params', $data['id']);
            $data =  $this->db->single(); 
            $callback = array(
                'status' => 'success',
                'ID' => $data['ID'],
                'FS_PIN' => $data['FS_PIN'],
                'FS_KD_PEG' => $data['FS_KD_PEG'],
                'IO' => $data['IO'],
                'TglLog' => $data['TglLog'],
                'JamLog' => $data['JamLog'],
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function CreateAbsenManual($data)
    {

        $IdTranasksi = $data['IdTranasksi'];
        $IdTranasksiAuto = $data['IdTranasksiAuto'];
        $Absen_Tanggal = $data['Absen_Tanggal'];
        $Absen_Jam = $data['Absen_Jam'];
        $Hr_Nama_Pegawai = $data['Hr_Nama_Pegawai'];
        $Absen_Status = $data['Absen_Status'];
        $Absen_PIN  = $data['Absen_PIN'];
        $fixtgl = $Absen_Tanggal . ' ' . $Absen_Jam;

        if ($Absen_Tanggal == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Tanggal Absen !',
            );
           return $callback;
            exit;
        }
        if ($Absen_Jam == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Jam Absen !',
            );
            return $callback;
            exit;
        }
        if ($Hr_Nama_Pegawai == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input ID Pegawai !',
            );
            return $callback;
            exit;
        }
        if ($Absen_Status == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Input Status Absen !',
            );
            return $callback;
            exit;
        }  
        $isManual = "1";
        $tgl_input = Utils::seCurrentDateTime();
        $session = SessionManager::getCurrentSession();
        $userid = $session->username;
        try {
            $this->db->transaksi();
            if ($data['IdTranasksi'] == "") {
                $this->db->query("INSERT INTO HR_A_LOG_FINGER
                                (FD_TGL,FS_PIN,FS_KD_PEG,IO,
                                PetugasAddManual,TglAddManual,Manual)
                                values
                                (:fixtgl,:Absen_PIN,:Hr_Nama_Pegawai,:Absen_Status,
                                :userid,:tgl_input,:isManual) ");
                $this->db->bind('fixtgl', $fixtgl);
                $this->db->bind('Absen_PIN', $Absen_PIN);
                $this->db->bind('Hr_Nama_Pegawai', $Hr_Nama_Pegawai);
                $this->db->bind('Absen_Status', $Absen_Status);
                $this->db->bind('userid', $userid);
                $this->db->bind('tgl_input', $tgl_input);
                $this->db->bind('isManual', $isManual);
            } else {
                $this->db->query("UPDATE HR_A_LOG_FINGER set  
                                FD_TGL=:fixtgl,FS_PIN=:Absen_PIN,
                                FS_KD_PEG=:Hr_Nama_Pegawai,IO=:Absen_Status
                                WHERE ID=:IdTranasksiAuto");
                $this->db->bind('fixtgl', $fixtgl);
                $this->db->bind('Absen_PIN', $Absen_PIN);
                $this->db->bind('Hr_Nama_Pegawai', $Hr_Nama_Pegawai);
                $this->db->bind('Absen_Status', $Absen_Status); 
                $this->db->bind('IdTranasksiAuto', $IdTranasksiAuto);
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
}