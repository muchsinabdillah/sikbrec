<?php
class A_Pdp_Model 
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getAllPdp()
    {
        try {
            $this->db->query("SELECT ID,KD_PDP,NM_PDP,KD_JENIS_PDP
                                FROM Keuangan.DBO.BO_M_PDP");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['KD_PDP'] = $key['KD_PDP'];
                $pasing['NM_PDP'] = $key['NM_PDP'];
                $pasing['KD_JENIS_PDP'] = $key['KD_JENIS_PDP'];
                $rows[] = $pasing;
            }
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $rows
            );
            return $rows; 
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    // INSERT
    public function insert($data)
    {
        try {
            $this->db->transaksi();
            if ($data['KodePdp'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Kode Pdp !',
                );
                return $callback;
                exit;
            }
            if ($data['NamaPdp'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Nama Pdp !',
                );
                return $callback;
                exit;
            }
            if ($data['KodeJenisPdp'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Jenis Pdp !',
                );
                return $callback;
                exit;
            }
            $IdAuto = $data['IdAuto'];
            $KodePdp = $data['KodePdp'];
            $NamaPdp = $data['NamaPdp'];
            $KodeJenisPdp = $data['KodeJenisPdp'];
            if ($data['IdAuto'] == "") {

                // cek dulu sudah ada belum kode PDP nya...
                $this->db->query("SELECT KD_PDP
                                FROM Keuangan.DBO.BO_M_PDP
                                WHERE KD_PDP=:KodePdp ");
                $this->db->bind('KodePdp', $data['KodePdp']);
                $this->db->execute();
                $data =  $this->db->single();
                $rowData = $this->db->rowCount();
                //var_dump($rowData);
                if($rowData){
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Sudah Ada Kode Pdp, Silahkan Gunakan Kode Lain !',
                    );
                    return $callback;
                    exit;
                }else{
                    $this->db->query("INSERT INTO Keuangan.DBO.BO_M_PDP
                            (KD_PDP,NM_PDP,KD_JENIS_PDP)
                          values
                          ( :KodePdp,:NamaPdp,:KodeJenisPdp)");
                    $this->db->bind('KodePdp', $KodePdp);
                    $this->db->bind('NamaPdp', $NamaPdp);
                    $this->db->bind('KodeJenisPdp', $KodeJenisPdp);
                }
            } else {
                $this->db->query("UPDATE Keuangan.DBO.BO_M_PDP set  
                            NM_PDP=:NamaPdp,KD_JENIS_PDP=:KodeJenisPdp 
                            WHERE ID=:IdAuto");
                $this->db->bind('NamaPdp', $NamaPdp);
                $this->db->bind('KodeJenisPdp', $KodeJenisPdp);
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
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
            
        }
    }
    public function getPdpId($id)
    {
        try {
            
            $this->db->query('SELECT ID,KD_PDP,NM_PDP,KD_JENIS_PDP
                        FROM Keuangan.DBO.BO_M_PDP
                        WHERE ID=:id');
            $this->db->bind('id', $id);
            $data =  $this->db->single();
            $pasing['ID'] = $data['ID'];
            $pasing['KD_PDP'] = $data['KD_PDP'];
            $pasing['NM_PDP'] = $data['NM_PDP'];
            $pasing['KD_JENIS_PDP'] = $data['KD_JENIS_PDP']; 
         
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
    public function getAllPdpDetil()
    {
        try {
            $this->db->query("SELECT ID,KD_PDP,KD_TIPE_PDP,NILAI_PROSEN,NILAI_FIX,SHOW_JASA,NM_TIPE_PDP
                            FROM Keuangan.DBO.BO_M_PDP2
                            ORDER BY KD_PDP DESC");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['KD_PDP'] = $key['KD_PDP'];
                $pasing['KD_TIPE_PDP'] = $key['KD_TIPE_PDP'];
                $pasing['NILAI_PROSEN'] = $key['NILAI_PROSEN'];
                $pasing['NILAI_FIX'] = $key['NILAI_FIX'];
                $pasing['SHOW_JASA'] = $key['SHOW_JASA'];
                $pasing['NM_TIPE_PDP'] = $key['NM_TIPE_PDP'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getAllPdpDetilCombo()
    {
        try {
            $this->db->query("SELECT ID,KD_PDP,NM_PDP,KD_JENIS_PDP FROM Keuangan.DBO.BO_M_PDP ORDER BY 1 DESC");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['KD_PDP'] = $key['KD_PDP'];
                $pasing['NM_PDP'] = $key['NM_PDP']; 
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
    // INSERT
    public function insertPdpDetil($data)
    {
        try {
            $this->db->transaksi();
            if ($data['KodePdp'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Kode Pdp !',
                );
                return $callback;
                exit;
            } 
            if ($data['KodeTipePdp'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Tipe Pdp !',
                );
                return $callback;
                exit;
            }
            if ($data['NamaPDP'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Nama Pdp !',
                );
                return $callback;
                exit;
            }
            if ($data['ShowJasa'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Pilih Show Jasa !',
                );
                return $callback;
                exit;
            }
            if ($data['NilaiProsenPdp'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Nilai Prosen Pdp !',
                );
                return $callback;
                exit;
            }
            if ($data['NilaiFixPdp'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Nilai Fix Pdp !',
                );
                return $callback;
                exit;
            }
            if ($data['KodeRekeningDiskon'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Rek Diskon Pdp !',
                );
                return $callback;
                exit;
            }
            if ($data['KodeRekeningPendapatan'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Rek Pendapatan Pdp !',
                );
                return $callback;
                exit;
            }
            $IdAuto = $data['IdAuto'];
            $KodeTipePdp = $data['KodeTipePdp'];
            $KodePdp = $data['KodePdp'];
            $KodeTipePdp = $data['KodeTipePdp'];
            $NamaPDP = $data['NamaPDP'];
            $ShowJasa = $data['ShowJasa'];
            $NilaiProsenPdp = $data['NilaiProsenPdp'];
            $NilaiFixPdp = $data['NilaiFixPdp'];
            $KodeRekeningPendapatan = $data['KodeRekeningPendapatan'];
            $KodeRekeningDiskon = $data['KodeRekeningDiskon'];
            
            if ($data['IdAuto'] == "") {
                // cek dulu sudah ada belum kode PDP nya...
                $this->db->query("SELECT KD_PDP FROM Keuangan.DBO.BO_M_PDP2 
                                where KD_PDP=:KodePdp and KD_TIPE_PDP=:KodeTipePdp");
                $this->db->bind('KodePdp', $KodePdp);
                $this->db->bind('KodeTipePdp', $KodeTipePdp);
                $this->db->execute();
                $data =  $this->db->single();
                $rowData = $this->db->rowCount();
                //var_dump($rowData);
                if ($rowData) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Sudah Ada Kode Pdp dan Tipe ini, Silahkan Gunakan Kode Lain !',
                    );
                    return $callback;
                    exit;
                } else {
                    $this->db->query("INSERT INTO Keuangan.DBO.BO_M_PDP2
                            (KD_PDP,KD_TIPE_PDP,NILAI_PROSEN,
                            NILAI_FIX,KD_POSTING,KD_POSTING_DISC,NM_TIPE_PDP,SHOW_JASA)
                            values
                            ( :KodePdp,:KodeTipePdp,:NilaiProsenPdp
                            ,:NilaiFixPdp,:KodeRekeningPendapatan,:KodeRekeningDiskon,:NamaPDP,:ShowJasa)");
                    $this->db->bind('KodePdp', $KodePdp);
                    $this->db->bind('KodeTipePdp', $KodeTipePdp);
                    $this->db->bind('NilaiProsenPdp', $NilaiProsenPdp);
                    $this->db->bind('NilaiFixPdp', $NilaiFixPdp); 
                    $this->db->bind('KodeRekeningPendapatan', $KodeRekeningPendapatan);
                    $this->db->bind('KodeRekeningDiskon', $KodeRekeningDiskon);
                    $this->db->bind('NamaPDP', $NamaPDP);
                    $this->db->bind('ShowJasa', $ShowJasa);
                }
            } else {
                $this->db->query("UPDATE Keuangan.DBO.BO_M_PDP2 set  
                            KD_PDP=:KodePdp,KD_TIPE_PDP=:KodeTipePdp,
                            NILAI_PROSEN=:NilaiProsenPdp ,NILAI_FIX=:NilaiFixPdp,
                            KD_POSTING=:KodeRekeningPendapatan,
                            KD_POSTING_DISC=:KodeRekeningDiskon,
                            NM_TIPE_PDP=:NamaPDP,SHOW_JASA=:ShowJasa
                            WHERE ID=:IdAuto");
                $this->db->bind('KodePdp', $KodePdp);
                $this->db->bind('KodeTipePdp', $KodeTipePdp);
                $this->db->bind('NilaiProsenPdp', $NilaiProsenPdp);
                $this->db->bind('NilaiFixPdp', $NilaiFixPdp);
                $this->db->bind('NilaiProsenPdp', $NilaiProsenPdp);
                $this->db->bind('NilaiFixPdp', $NilaiFixPdp);
                $this->db->bind('KodeRekeningPendapatan', $KodeRekeningPendapatan);
                $this->db->bind('KodeRekeningDiskon', $KodeRekeningDiskon); 
                $this->db->bind('IdAuto', $IdAuto);
                $this->db->bind('NamaPDP', $NamaPDP);
                $this->db->bind('ShowJasa', $ShowJasa);
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
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
            
        }
    }
    public function getPdpDetilId($id)
    {
        try {    
            $this->db->query('SELECT ID,KD_PDP,KD_TIPE_PDP,NILAI_PROSEN,
                            NILAI_FIX,KD_POSTING,KD_POSTING_DISC,SHOW_JASA,NM_TIPE_PDP
                            FROM Keuangan.DBO.BO_M_PDP2
                            WHERE ID=:id');
            $this->db->bind('id', $id);
            $data =  $this->db->single();
            $pasing['ID'] = $data['ID'];
            $pasing['KD_PDP'] = $data['KD_PDP'];
            $pasing['KD_TIPE_PDP'] = $data['KD_TIPE_PDP'];
            $pasing['NILAI_PROSEN'] = $data['NILAI_PROSEN']; 
            $pasing['NILAI_FIX'] = $data['NILAI_FIX'];
            $pasing['KD_POSTING'] = $data['KD_POSTING'];
            $pasing['KD_POSTING_DISC'] = $data['KD_POSTING_DISC'];
            $pasing['SHOW_JASA'] = $data['SHOW_JASA'];
            $pasing['NM_TIPE_PDP'] = $data['NM_TIPE_PDP'];
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
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

