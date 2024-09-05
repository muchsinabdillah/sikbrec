<?php
class A_Rekening_Model 
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getRekeningPendapatan()
    {
        try {
            $this->db->query("SELECT FS_KD_REKENING,FS_NM_REKENING 
                            from Keuangan.dbo.TM_REKENING
                            where FS_KD_REKENING_GROUP_COA='PENDAPATAN USAHA'
                            and AKTIF='1' and GROUP_REK='4'");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['FS_KD_REKENING'] = $key['FS_KD_REKENING'];
                $pasing['FS_NM_REKENING'] = $key['FS_NM_REKENING']; 
                $rows[] = $pasing;
            }
            $callback = array(
                'message' => "success", // Set array nama 
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
    public function getRekeningAllAktif()
    {
        try {
            $this->db->query("SELECT FS_KD_REKENING,FS_NM_REKENING  from Keuangan.dbo.TM_REKENING
                            where AKTIF='1' and GROUP_REK='4' ");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['FS_KD_REKENING'] = $key['FS_KD_REKENING'];
                $pasing['FS_NM_REKENING'] = $key['FS_NM_REKENING'];
                $rows[] = $pasing;
            }
            $callback = array(
                'message' => "success", // Set array nama 
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
    public function getAllCoa()
    {
        try {
            $this->db->query("SELECT FS_KD_REKENING,FS_KD_REKENING_GROUP,
                            FS_NM_REKENING,FS_KD_REKENING_GROUP_COA,
                            CASE WHEN AKTIF='1' THEN 'AKTIF' ELSE 'NON AKTIF' END AS STATUSREK,
                            GROUP_REK,FB_NERACA,FB_LEDGER_P,FB_LEDGER_H,FB_UNIT_USAHA
                            from Keuangan.dbo.TM_REKENING");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['FS_KD_REKENING'] = $key['FS_KD_REKENING'];
                $pasing['FS_NM_REKENING'] = $key['FS_NM_REKENING'];
                $pasing['FS_KD_REKENING_GROUP'] = $key['FS_KD_REKENING_GROUP'];
                $pasing['FS_KD_REKENING_GROUP_COA'] = $key['FS_KD_REKENING_GROUP_COA'];
                $pasing['STATUSREK'] = $key['STATUSREK'];
                $pasing['GROUP_REK'] = $key['GROUP_REK'];
                $pasing['FB_NERACA'] = $key['FB_NERACA'];
                $pasing['FB_LEDGER_P'] = $key['FB_LEDGER_P'];
                $pasing['FB_LEDGER_H'] = $key['FB_LEDGER_H'];
                $pasing['FB_UNIT_USAHA'] = $key['FB_UNIT_USAHA'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getRekeningGroup()
    {
        try {
            $this->db->query("SELECT ID,Nama
            from Keuangan.dbo.TM_GROUP_REKENING");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['FS_KD_REKENING_GROUP'] = $key['Nama']; 
                $rows[] = $pasing;
            }
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $rows
            );
            return $callback; 
        } catch (PDOException $e) {
            $callback = array(
                'message' => "error", // Set array nama  
                'data' => $e
            );
            return $callback;
        }
    }
    public function getRekeningGroupCOA()
    {
        try {
            $this->db->query("SELECT ID,Nama
            from Keuangan.dbo.TM_GROUP_COA_REKENING");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['FS_KD_REKENING_GROUP_COA'] = $key['Nama'];
                $rows[] = $pasing;
            }
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $rows
            );
            return $callback; 
        } catch (PDOException $e) {
            $callback = array(
                'message' => "error", // Set array nama  
                'data' => $e
            );
            return $callback;
        }
    }
    // INSERT
    public function insert($data)
    {
        try {
            $this->db->transaksi();
            if ($data['KodeRekening'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Kode Rekening COA !',
                );
                return $callback;
                exit;
            }
            if ($data['NamaRekening'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Nama Rekening !',
                );
                return $callback;
                exit;
            }
            if ($data['RekeningGroup'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Rekening Group !',
                );
                return $callback;
                exit;
            }
            if ($data['RekeningGroup2'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Rekening Group 2 !',
                );
                return $callback;
                exit;
            }
            if ($data['StatusRekening'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Status Rekening COA !',
                );
                return $callback;
                exit;
            }
            if ($data['LevelGroupCOA'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Level Group Rekening COA !',
                );
                return $callback;
                exit;
            }
            if ($data['RekNeraca'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Rek Neraca !',
                );
                return $callback;
                exit;
            }
            if ($data['RekUnitUsaha'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Rek Unit Usaha !',
                );
                return $callback;
                exit;
            }
            if ($data['RekBpPiutang'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Rek Gen BP Piutang !',
                );
                return $callback;
                exit;
            }
            if ($data['RekBpHutang'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Rek Gen BP Hutang !',
                );
                return $callback;
                exit;
            }
            $KodeRekening = $data['KodeRekening'];
            $NamaRekening = $data['NamaRekening'];
            $RekeningGroup = $data['RekeningGroup'];
            $RekeningGroup2 = $data['RekeningGroup2'];
            $StatusRekening = $data['StatusRekening'];
            $LevelGroupCOA = $data['LevelGroupCOA'];
            $RekNeraca = $data['RekNeraca'];
            $RekUnitUsaha = $data['RekUnitUsaha'];
            $RekBpPiutang = $data['RekBpPiutang'];
            $RekBpHutang = $data['RekBpHutang'];
      

                // cek dulu sudah ada belum kode PDP nya...
                $this->db->query("SELECT FS_KD_REKENING 
                                FROM Keuangan.DBO.TM_REKENING where FS_KD_REKENING=:KodeRekening ");
                $this->db->bind('KodeRekening', $data['KodeRekening']);
                $this->db->execute();
                $data =  $this->db->single();
                $rowData = $this->db->rowCount();
                //var_dump($rowData);
                if ($rowData) {
                    $this->db->query("UPDATE Keuangan.DBO.TM_REKENING set  
                                    FS_KD_REKENING_GROUP=:RekeningGroup,
                                    FS_NM_REKENING=:NamaRekening,FS_KD_REKENING_GROUP_COA=:RekeningGroup2,AKTIF=:StatusRekening
                                    ,GROUP_REK=:LevelGroupCOA,FB_NERACA=:RekNeraca,FB_LEDGER_P=:RekBpPiutang,
                                    FB_LEDGER_H=:RekBpHutang,FB_UNIT_USAHA=:RekUnitUsaha
                                    WHERE FS_KD_REKENING=:KodeRekening");
                    $this->db->bind('KodeRekening', $KodeRekening);
                    $this->db->bind('RekeningGroup', $RekeningGroup);
                    $this->db->bind('NamaRekening', $NamaRekening);
                    $this->db->bind('RekeningGroup2', $RekeningGroup2);
                    $this->db->bind('StatusRekening', $StatusRekening);
                    $this->db->bind('LevelGroupCOA', $LevelGroupCOA);
                    $this->db->bind('RekNeraca', $RekNeraca);
                    $this->db->bind('RekBpPiutang', $RekBpPiutang);
                    $this->db->bind('RekBpHutang', $RekBpHutang);
                    $this->db->bind('RekBpPiutang', $RekBpPiutang);
                    $this->db->bind('RekUnitUsaha', $RekUnitUsaha);
                } else {
                    $this->db->query("INSERT INTO Keuangan.DBO.TM_REKENING
                            ( FS_KD_REKENING,FS_KD_REKENING_GROUP,
                            FS_NM_REKENING,FS_KD_REKENING_GROUP_COA,AKTIF,
                            GROUP_REK,FB_NERACA,FB_LEDGER_P,FB_LEDGER_H,FB_UNIT_USAHA)
                          values
                          ( :KodeRekening,:RekeningGroup,
                          :NamaRekening,:RekeningGroup2,:StatusRekening
                          ,:LevelGroupCOA,:RekNeraca,:RekBpPiutang,:RekBpHutang,:RekUnitUsaha)");
                    $this->db->bind('KodeRekening', $KodeRekening);
                    $this->db->bind('RekeningGroup', $RekeningGroup);
                    $this->db->bind('NamaRekening', $NamaRekening);
                    $this->db->bind('RekeningGroup2', $RekeningGroup2);
                    $this->db->bind('StatusRekening', $StatusRekening);
                    $this->db->bind('LevelGroupCOA', $LevelGroupCOA);
                    $this->db->bind('RekNeraca', $RekNeraca);
                    $this->db->bind('RekBpPiutang', $RekBpPiutang);
                    $this->db->bind('RekBpHutang', $RekBpHutang);
                    $this->db->bind('RekBpPiutang', $RekBpPiutang);
                    $this->db->bind('RekUnitUsaha', $RekUnitUsaha);
                }
            
                $this->db->execute();
                $this->db->commit();
                $callback = array(
                    'status' => 'success', // Set array statuas dengan success   
                    'message' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success    
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
    public function getCoaId($id)
    {
        try {
            $this->db->query('SELECT FS_KD_REKENING,FS_KD_REKENING_GROUP,FS_NM_REKENING,
                                FS_KD_REKENING_GROUP_COA,AKTIF ,
                                GROUP_REK,FB_NERACA,FB_LEDGER_P,FB_LEDGER_H,FB_UNIT_USAHA
                                from Keuangan.dbo.TM_REKENING
                                WHERE FS_KD_REKENING=:id');
            $this->db->bind('id', $id);
            $data =  $this->db->single();
            $pasing['FS_KD_REKENING'] = $data['FS_KD_REKENING'];
            $pasing['FS_KD_REKENING_GROUP'] = $data['FS_KD_REKENING_GROUP'];
            $pasing['FS_NM_REKENING'] = $data['FS_NM_REKENING'];
            $pasing['FS_KD_REKENING_GROUP_COA'] = $data['FS_KD_REKENING_GROUP_COA']; 
            $pasing['AKTIF'] = $data['AKTIF'];
            $pasing['GROUP_REK'] = $data['GROUP_REK'];
            $pasing['FB_NERACA'] = $data['FB_NERACA'];
            $pasing['FB_LEDGER_P'] = $data['FB_LEDGER_P'];
            $pasing['FB_LEDGER_H'] = $data['FB_LEDGER_H'];
            $pasing['FB_UNIT_USAHA'] = $data['FB_UNIT_USAHA'];
            
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            $callback = array(
                'message' => "error", // Set array nama  
                'data' => $e
            );
            return $callback;
        }
    }
    public function getRekeningHpp()
    {
        try {
            $this->db->query("SELECT FS_KD_REKENING,FS_NM_REKENING 
                            from Keuangan.dbo.TM_REKENING
                            where FS_KD_REKENING_GROUP_COA='HPP'
                            and AKTIF='1' and GROUP_REK='4'");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['FS_KD_REKENING'] = $key['FS_KD_REKENING'];
                $pasing['FS_NM_REKENING'] = $key['FS_NM_REKENING'];
                $rows[] = $pasing;
            }
            $callback = array(
                'message' => "success", // Set array nama 
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
    public function GetRekeningHutang()
    {
        try {
            $this->db->query("SELECT FS_KD_REKENING,FS_NM_REKENING 
                            from Keuangan.dbo.TM_REKENING
                            where FS_KD_REKENING_GROUP_COA='KEWAJIBAN'
                            and AKTIF='1' and GROUP_REK='4'");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['FS_KD_REKENING'] = $key['FS_KD_REKENING'];
                $pasing['FS_NM_REKENING'] = $key['FS_NM_REKENING'];
                $rows[] = $pasing;
            }
            $callback = array(
                'message' => "success", // Set array nama 
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
    public function GetRekeningPiutang()
    {
        try {
            $this->db->query("SELECT FS_KD_REKENING,FS_NM_REKENING 
                            from Keuangan.dbo.TM_REKENING
                            where FS_KD_REKENING_GROUP LIKE '%PIUTANG%'
                            and AKTIF='1' and GROUP_REK='4'");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['FS_KD_REKENING'] = $key['FS_KD_REKENING'];
                $pasing['FS_NM_REKENING'] = $key['FS_NM_REKENING'];
                $rows[] = $pasing;
            }
            $callback = array(
                'message' => "success", // Set array nama 
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
    public function getAllGroupRekening()
    {
        try {
            $this->db->query("SELECT ID,Nama
                            from Keuangan.dbo.TM_GROUP_REKENING ");
            $data =  $this->db->resultSet();
            $rows = array(); 
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['Nama'] = $key['Nama']; 
                $rows[] = $pasing;
            } 
            return $rows; 
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function getAllGroupRekeningCOA()
    {
        try {
            $this->db->query("SELECT ID,Nama
                            from Keuangan.dbo.TM_GROUP_COA_REKENING ");
            $data =  $this->db->resultSet();
            $rows = array(); 
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['Nama'] = $key['Nama']; 
                $rows[] = $pasing;
            } 
            return $rows; 
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
}