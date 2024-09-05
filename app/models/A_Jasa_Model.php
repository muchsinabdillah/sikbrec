<?php
class A_Jasa_Model 
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function getAllJasa()
    {
        try {
            $this->db->query("SELECT ID,KD_JASA,NM_JASA,KD_JENIS_JASA
                            FROM Keuangan.DBO.BO_M_JASA");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['KD_JASA'] = $key['KD_JASA'];
                $pasing['NM_JASA'] = $key['NM_JASA'];
                $pasing['KD_JENIS_JASA'] = $key['KD_JENIS_JASA'];
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
    public function getJasaId($id)
    {
        try {

            $this->db->query('SELECT KD_JASA,NM_JASA,KD_JENIS_JASA,ID
                        FROM Keuangan.DBO.BO_M_JASA
                        WHERE ID=:id');
            $this->db->bind('id', $id);
            $data =  $this->db->single();
            $pasing['ID'] = $data['ID'];
            $pasing['KD_JASA'] = $data['KD_JASA'];
            $pasing['NM_JASA'] = $data['NM_JASA'];
            $pasing['KD_JENIS_JASA'] = $data['KD_JENIS_JASA'];
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
     
    // INSERT
    public function insert($data)
    {
        try {
            $this->db->transaksi();
            if ($data['KodeJasa'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Kode Jasa !',
                );
                return $callback;
                exit;
            }
            if ($data['NamaJasa'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Nama Jasa !',
                );
                return $callback;
                exit;
            }
            if ($data['KodeJenisJasa'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Jenis Jasa !',
                );
                return $callback;
                exit;
            }
            $IdAuto = $data['IdAuto'];
            $KodeJasa = $data['KodeJasa'];
            $NamaJasa = $data['NamaJasa'];
            $KodeJenisJasa = $data['KodeJenisJasa'];
            if ($data['IdAuto'] == "") {

                // cek dulu sudah ada belum kode Jasa nya...
                $this->db->query("SELECT KD_Jasa
                                FROM Keuangan.DBO.BO_M_Jasa
                                WHERE KD_Jasa=:KodeJasa ");
                $this->db->bind('KodeJasa', $data['KodeJasa']);
                $this->db->execute();
                $data =  $this->db->single();
                $rowData = $this->db->rowCount();
                //var_dump($rowData);
                if ($rowData) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Sudah Ada Kode Jasa, Silahkan Gunakan Kode Lain !',
                    );
                    return $callback;
                    exit;
                } else {
                    $this->db->query("INSERT INTO Keuangan.DBO.BO_M_Jasa
                            (KD_Jasa,NM_Jasa,KD_JENIS_Jasa)
                          values
                          ( :KodeJasa,:NamaJasa,:KodeJenisJasa)");
                    $this->db->bind('KodeJasa', $KodeJasa);
                    $this->db->bind('NamaJasa', $NamaJasa);
                    $this->db->bind('KodeJenisJasa', $KodeJenisJasa);
                }
            } else {
                $this->db->query("UPDATE Keuangan.DBO.BO_M_Jasa set  
                            NM_Jasa=:NamaJasa,KD_JENIS_Jasa=:KodeJenisJasa 
                            WHERE ID=:IdAuto");
                $this->db->bind('NamaJasa', $NamaJasa);
                $this->db->bind('KodeJenisJasa', $KodeJenisJasa);
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
    public function getAllJasaDetil()
    {
        try {
            $this->db->query("SELECT ID,KD_JASA,KD_TIPE_JASA,NILAI_FIX,
                            NILAI_PROSEN,KD_POSTING,KD_POSTING_DISC,KD_HUTANG
                            FROM Keuangan.DBO.BO_M_JASA2");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['KD_JASA'] = $key['KD_JASA'];
                $pasing['KD_TIPE_JASA'] = $key['KD_TIPE_JASA'];
                $pasing['NILAI_FIX'] = $key['NILAI_FIX'];
                $pasing['NILAI_PROSEN'] = $key['NILAI_PROSEN'];
                $pasing['KD_POSTING'] = $key['KD_POSTING'];
                $pasing['KD_POSTING_DISC'] = $key['KD_POSTING_DISC'];
                $pasing['KD_HUTANG'] = $key['KD_HUTANG']; 
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
    // INSERT
    public function insertJasaDetil($data)
    {
        try {
            $this->db->transaksi();
            if ($data['KodeJasa'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Kode Jasa !',
                );
                return $callback;
                exit;
            }
            if ($data['KodeTipeJasa'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Kode Tipe Jasa !',
                );
                return $callback;
                exit;
            }
            if ($data['NilaiProsenJasa'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Nilai Prosen !',
                );
                return $callback;
                exit;
            }
            if ($data['NilaiFixJasa'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Nilai Fix !',
                );
                return $callback;
                exit;
            }
            if ($data['KodeRekeningHpp'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Pilih Rekening Hpp !',
                );
                return $callback;
                exit;
            }
            if ($data['KodeRekeningDiskon'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Pilih Rekening Diskon !',
                );
                return $callback;
                exit;
            }
            if ($data['KodeRekeningHutang'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Pilih Rekening Hutang !',
                );
                return $callback;
                exit;
            }
            $IdAuto = $data['IdAuto'];
            $KodeJasa = $data['KodeJasa'];
            $KodeTipeJasa = $data['KodeTipeJasa'];
            $NilaiProsenJasa = $data['NilaiProsenJasa'];
            $NilaiFixJasa = $data['NilaiFixJasa'];
            $KodeRekeningHpp = $data['KodeRekeningHpp'];
            $KodeRekeningDiskon = $data['KodeRekeningDiskon'];
            $KodeRekeningHutang = $data['KodeRekeningHutang'];

            if ($data['IdAuto'] == "") {


                $this->db->query("INSERT INTO Keuangan.DBO.BO_M_JASA2
                                    (KD_JASA,KD_TIPE_JASA,NILAI_FIX,
                                    NILAI_PROSEN,KD_POSTING,KD_POSTING_DISC,KD_HUTANG)
                                    values
                                    ( :KodeJasa,:KodeTipeJasa,:NilaiFixJasa,
                                    :NilaiProsenJasa,:KodeRekeningHpp,:KodeRekeningDiskon,:KodeRekeningHutang)");
                $this->db->bind('KodeJasa', $KodeJasa);
                $this->db->bind('KodeTipeJasa', $KodeTipeJasa);
                $this->db->bind('NilaiFixJasa', $NilaiFixJasa);
                $this->db->bind('NilaiProsenJasa', $NilaiProsenJasa);
                $this->db->bind('KodeRekeningHpp', $KodeRekeningHpp);
                $this->db->bind('KodeRekeningDiskon', $KodeRekeningDiskon);
                $this->db->bind('KodeRekeningHutang', $KodeRekeningHutang);
            } else {
                $this->db->query("UPDATE Keuangan.DBO.BO_M_JASA2 set  
                            KD_JASA=:KodeJasa,KD_TIPE_JASA=:KodeTipeJasa,NILAI_FIX=:NilaiFixJasa,
                            NILAI_PROSEN=:NilaiProsenJasa,KD_POSTING=:KodeRekeningHpp,
                            KD_POSTING_DISC=:KodeRekeningDiskon,KD_HUTANG=:KodeRekeningHutang
                            WHERE ID=:IdAuto");
                $this->db->bind('KodeJasa', $KodeJasa);
                $this->db->bind('KodeTipeJasa', $KodeTipeJasa);
                $this->db->bind('NilaiFixJasa', $NilaiFixJasa);
                $this->db->bind('NilaiProsenJasa', $NilaiProsenJasa);
                $this->db->bind('KodeRekeningHpp', $KodeRekeningHpp);
                $this->db->bind('KodeRekeningDiskon', $KodeRekeningDiskon);
                $this->db->bind('KodeRekeningHutang', $KodeRekeningHutang);
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
    public function getJasaDetilById($id)
    {
        try {

            $this->db->query('SELECT ID,KD_JASA,KD_TIPE_JASA,NILAI_FIX,
                        NILAI_PROSEN,KD_POSTING,KD_POSTING_DISC,KD_HUTANG
                        FROM Keuangan.DBO.BO_M_JASA2
                        WHERE ID=:id');
            $this->db->bind('id', $id);
            $data =  $this->db->single();
            $pasing['ID'] = $data['ID'];
            $pasing['KD_JASA'] = $data['KD_JASA'];
            $pasing['KD_TIPE_JASA'] = $data['KD_TIPE_JASA'];
            $pasing['NILAI_FIX'] = $data['NILAI_FIX'];
            $pasing['NILAI_PROSEN'] = $data['NILAI_PROSEN'];
            $pasing['KD_POSTING'] = $data['KD_POSTING'];
            $pasing['KD_POSTING_DISC'] = $data['KD_POSTING_DISC'];
            $pasing['KD_HUTANG'] = $data['KD_HUTANG']; 
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
}
