<?php
class TipePembayaran_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllTipePembayaran()
    {
        try {
            $this->db->query("SELECT ID, PaymentType, Account, Status AS StatusPayment, CASE WHEN Status = '0' THEN 'Nonaktif' ELSE 'Aktif' END AS StatusPaymentText FROM PerawatanSQL.dbo.PaymentType");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['PaymentType'] = $key['PaymentType'];
                $pasing['Account'] = $key['Account'];
                $pasing['StatusPayment'] = $key['StatusPayment'];
                $pasing['StatusPaymentText'] = $key['StatusPaymentText'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getKodeRekeningCOA()
    {
        try {
            $this->db->query("SELECT FS_KD_REKENING FROM Keuangan.dbo.TM_REKENING WHERE AKTIF = '1'");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['FS_KD_REKENING'] = $key['FS_KD_REKENING'];
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

    public function saveTipePembayaran($data)
    {
        try {
            $this->db->transaksi();
            $idtipe = $data['idtipe'];
            $jenistipe = $data['jenistipe'];
            $accounttipe = $data['accounttipe'];
            $statustipe = $data['statustipe'];

            if ($idtipe == "") {
                //cek data sama/ tidak
                $this->db->query("SELECT COUNT(ID) AS cekID FROM PerawatanSQL.dbo.PaymentType WHERE Account = :accounttipe AND PaymentType = :jenistipe");
                $this->db->bind('accounttipe', $accounttipe);
                $this->db->bind('jenistipe', $jenistipe);
                $datax =  $this->db->single();
                $this->db->execute();
                $cekdata = $datax['cekID'];
                if ($cekdata <> '0') {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Transaksi Gagal, Karena data sama dengan data yang sudah ada',
                    );
                    echo json_encode($callback);
                    exit;
                } else {
                    $this->db->query("SELECT ID FROM PerawatanSQL.dbo.PaymentType
                    ORDER BY ID DESC 
                    OFFSET 0 ROWS FETCH FIRST 1 ROW ONLY");
                    $datax2 =  $this->db->single();
                    $this->db->execute();
                    $cekdata2temp = $datax2['ID'];
                    $cekdata2 = $cekdata2temp + 1;

                    $this->db->query("INSERT INTO PerawatanSQL.dbo.PaymentType
                            (ID,PaymentType,Account,Status) values 
                            (:cekdata2,:jenistipe,:accounttipe,:statustipe)");
                    $this->db->bind('cekdata2', $cekdata2);
                    $this->db->bind('jenistipe', $jenistipe);
                    $this->db->bind('accounttipe', $accounttipe);
                    $this->db->bind('statustipe', $statustipe);
                }
            } else {
                $this->db->query("UPDATE PerawatanSQL.dbo.PaymentType SET PaymentType = :jenistipe, Account = :accounttipe, Status = :statustipe WHERE ID =:idtipe");
                $this->db->bind('jenistipe', $jenistipe);
                $this->db->bind('accounttipe', $accounttipe);
                $this->db->bind('statustipe', $statustipe);
                $this->db->bind('idtipe', $idtipe);
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

    public function getTipePembayaranById($id)
    {
        try {
            $idtipe = $id['idtipe'];
            $this->db->query('SELECT ID, PaymentType, Account, Status FROM PerawatanSQL.dbo.PaymentType WHERE ID = :idtipe');
            $this->db->bind('idtipe', $idtipe);
            $data =  $this->db->single();
            $pasing['ID'] = $data['ID'];
            $pasing['PaymentType'] = $data['PaymentType'];
            $pasing['Account'] = $data['Account'];
            $pasing['Status'] = $data['Status'];

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
