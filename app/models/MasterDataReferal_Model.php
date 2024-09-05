<?php
class MasterDataReferal_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getAllDataReferal()
    {
        try {
            $this->db->query("SELECT a.id,NamaCaraMasuk,NamaCaraMasukRef,Alamat,case when status='1' then 'AKTIF' else 'TIDAK AKTIF' end as status,PICName,TlpPIC 
                        from MasterdataSQL.dbo.MstrCaraMasuk_2 a
                        inner join MasterdataSQL.dbo.MstrCaraMasuk b on a.idCaraMasuk=b.id");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['id'];
                $pasing['NamaCaraMasuk'] = $key['NamaCaraMasuk'];
                $pasing['NamaCaraMasukRef'] = $key['NamaCaraMasukRef'];
                $pasing['Alamat'] = $key['Alamat'];
                $pasing['status'] = $key['status'];
                $pasing['PICName'] = $key['PICName'];
                $pasing['TlpPIC'] = $key['TlpPIC'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    // INSERT
    public function insert($data)
    {
        try {
            $this->db->transaksi();

            if ($data['GrupReferal'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Grup Referal!',
                );
                return $callback;
                exit;
            }
            if ($data['NamaReferal'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Nama Referal !',
                );
                return $callback;
                exit;
            }
            if ($data['Status'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Status Referal !',
                );
                return $callback;
                exit;
            }

            $nama = strlen($data['NamaReferal']);
            if ($nama > 50) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Simpan Gagal! Nama Referal Harus Kurang Dari 50 Karakter !',
                );
                return $callback;
                exit;
            }

            $IdAuto = $data['IdAuto'];
            $GrupReferal = $data['GrupReferal'];
            $NamaReferal = $data['NamaReferal'];
            $AlamatReferal = $data['AlamatReferal'];
            $PICName = $data['PICName'];
            $TlpPIC = $data['TlpPIC'];
            $NoRekening = $data['NoRekening'];
            $NamaBank = $data['NamaBank'];
            $PemegangRekening = $data['PemegangRekening'];
            $ReferalFeeAsuransi = $data['ReferalFeeAsuransi'];
            $ReferalFee = $data['ReferalFee'];
            $DiskonPerItem = $data['DiskonPerItem'];
            $Status = $data['Status'];

            if ($data['IdAuto'] == "") {

                $this->db->query("INSERT INTO MasterdataSQL.dbo.MstrCaraMasuk_2 (idCaraMasuk,NamaCaraMasukRef,Alamat,PICName,TlpPIC,Norek,NamaBank,
          PemegangRekening,RefferalFee_Asuransi,RefferalFee,Diskon_Per_Items,status) VALUES
                  (:GrupReferal,:NamaReferal,:AlamatReferal,:PICName,:TlpPIC,:NoRekening,:NamaBank,:PemegangRekening,:ReferalFeeAsuransi,:ReferalFee,:DiskonPerItem,:Status)");
                $this->db->bind('GrupReferal', $GrupReferal);
                $this->db->bind('NamaReferal', $NamaReferal);
                $this->db->bind('AlamatReferal', $AlamatReferal);
                $this->db->bind('PICName', $PICName);
                $this->db->bind('TlpPIC', $TlpPIC);
                $this->db->bind('NoRekening', $NoRekening);
                $this->db->bind('NamaBank', $NamaBank);
                $this->db->bind('PemegangRekening', $PemegangRekening);
                $this->db->bind('ReferalFeeAsuransi', $ReferalFeeAsuransi);
                $this->db->bind('ReferalFee', $ReferalFee);
                $this->db->bind('DiskonPerItem', $DiskonPerItem);
                $this->db->bind('Status', $Status);
            } else {
                $this->db->query("UPDATE MasterdataSQL.dbo.MstrCaraMasuk_2 set  
                            idCaraMasuk=:GrupReferal,NamaCaraMasukRef=:NamaReferal,Alamat=:AlamatReferal,PICName=:PICName,TlpPIC=:TlpPIC,Norek=:NoRekening,NamaBank=:NamaBank,
          PemegangRekening=:PemegangRekening,RefferalFee_Asuransi=:ReferalFeeAsuransi,RefferalFee=:ReferalFee,Diskon_Per_Items=:DiskonPerItem,status=:Status
                            WHERE ID=:IdAuto");
                $this->db->bind('GrupReferal', $GrupReferal);
                $this->db->bind('NamaReferal', $NamaReferal);
                $this->db->bind('AlamatReferal', $AlamatReferal);
                $this->db->bind('PICName', $PICName);
                $this->db->bind('TlpPIC', $TlpPIC);
                $this->db->bind('NoRekening', $NoRekening);
                $this->db->bind('NamaBank', $NamaBank);
                $this->db->bind('PemegangRekening', $PemegangRekening);
                $this->db->bind('ReferalFeeAsuransi', $ReferalFeeAsuransi);
                $this->db->bind('ReferalFee', $ReferalFee);
                $this->db->bind('DiskonPerItem', $DiskonPerItem);
                $this->db->bind('Status', $Status);
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
    public function getReferalId($id)
    {
        try {
            $this->db->query("SELECT *
                            from MasterdataSQL.dbo.MstrCaraMasuk_2
                            WHERE id=:id");
            $this->db->bind('id', $id);
            $data =  $this->db->single();
            $pasing['id'] = $data['id'];
            $pasing['idCaraMasuk'] = $data['idCaraMasuk'];
            $pasing['NamaCaraMasukRef'] = $data['NamaCaraMasukRef'];
            $pasing['Alamat'] = $data['Alamat'];
            $pasing['PICName'] = $data['PICName'];
            $pasing['TlpPIC'] = $data['TlpPIC'];
            $pasing['Norek'] = $data['Norek'];
            $pasing['NamaBank'] = $data['NamaBank'];
            $pasing['PemegangRekening'] = $data['PemegangRekening'];
            $pasing['RefferalFee'] = $data['RefferalFee'];
            $pasing['RefferalFee_Asuransi'] = $data['RefferalFee_Asuransi'];
            $pasing['status'] = $data['status'];
            $pasing['Diskon_Per_Items'] = $data['Diskon_Per_Items'];
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

    public function getNamaCaraMasuk()
    {
        try {
            $this->db->query("SELECT id,NamaCaraMasuk 
                                FROM MasterdataSQL.dbo.MstrCaraMasuk");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['id'] = $key['id'];
                $pasing['NamaCaraMasuk'] = $key['NamaCaraMasuk'];
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
    public function GetRefferalByIdGroup($data)
    {
        try {
            $idGroupRefferal = $data['idGroupRefferal'];
            $this->db->query("SELECT *FROM MasterdataSQL.DBO.MstrCaraMasuk_2 
                            WHERE idCaraMasuk=:idGroupRefferal and status='1'");
            $this->db->bind('idGroupRefferal', $idGroupRefferal);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['id'];
                $pasing['NamaCaraMasukRef'] = $key['NamaCaraMasukRef'];
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
