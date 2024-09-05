<?php
class MasterDataKarcis_Model 
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getAllDataKarcis()
    {
        try {
            $this->db->query("SELECT ID,Nama_Karcis,Nilai_Karcis,case when Status='1' then 'AKTIF' else 'TIDAK AKTIF' end as Status,grup_tarif 
                        from MasterdataSQL.dbo.MstrKarcisAdministrasi");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['Nama_Karcis'] = $key['Nama_Karcis'];
                $pasing['Nilai_Karcis'] = $key['Nilai_Karcis'];
                $pasing['Status'] = $key['Status'];
                $pasing['grup_tarif'] = $key['grup_tarif'];
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
            if ($data['NamaKarcis'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Nama Karcis !',
                );
                return $callback;
                exit;
            }
            if ($data['NilaiKarcis'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Nilai Karcis !',
                );
                return $callback;
                exit;
            }
            if ($data['GruptarifKarcis'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Grup Tarif Karcis !',
                );
                return $callback;
                exit;
            }
            $IdAuto = $data['IdAuto'];
            $NamaKarcis = $data['NamaKarcis'];
            $NilaiKarcis = $data['NilaiKarcis'];
            $StatusKarcis = $data['StatusKarcis'];
            $GruptarifKarcis = $data['GruptarifKarcis'];
            if ($data['IdAuto'] == "") {

                    $this->db->query("INSERT INTO MasterdataSQL.dbo.MstrKarcisAdministrasi
                            (Nama_Karcis,Nilai_Karcis,Status,grup_tarif)
                          values
                          ( :NamaKarcis,:NilaiKarcis,:StatusKarcis,:GruptarifKarcis)");
                    $this->db->bind('NamaKarcis', $NamaKarcis);
                    $this->db->bind('NilaiKarcis', $NilaiKarcis);
                    $this->db->bind('StatusKarcis', $StatusKarcis);
                    $this->db->bind('GruptarifKarcis', $GruptarifKarcis);
            } else {
                $this->db->query("UPDATE MasterdataSQL.dbo.MstrKarcisAdministrasi set  
                            Nama_Karcis=:NamaKarcis,Nilai_Karcis=:NilaiKarcis,Status=:StatusKarcis,grup_tarif=:GruptarifKarcis 
                            WHERE ID=:IdAuto");
                $this->db->bind('NamaKarcis', $NamaKarcis);
                $this->db->bind('NilaiKarcis', $NilaiKarcis);
                $this->db->bind('StatusKarcis', $StatusKarcis); 
                $this->db->bind('GruptarifKarcis', $GruptarifKarcis);
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
    public function getKarcisId($id)
    {

        try {
            $this->db->query('SELECT ID,Nama_Karcis,Nilai_Karcis,Status,grup_tarif 
                            from MasterdataSQL.dbo.MstrKarcisAdministrasi
                            WHERE ID=:id');
            $this->db->bind('id', $id);
            $data =  $this->db->single();
            $pasing['ID'] = $data['ID'];
            $pasing['Nama_Karcis'] = $data['Nama_Karcis'];
            $pasing['Nilai_Karcis'] = $data['Nilai_Karcis'];
            $pasing['Status'] = $data['Status'];
            $pasing['grup_tarif'] = $data['grup_tarif'];
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
    public function GetAdministrasibyGroupJaminan($data)
    {
        try {
            $grupJaminanId = $data["grupJaminanId"];
            $namajaminanId = $data["namajaminanId"];
            if ($grupJaminanId == '2') {
                $this->db->query("SELECT  a.*,Group_Jaminan 
                                from MasterdataSQL.dbo.MstrKarcisAdministrasi a
                                inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi b on a.grup_tarif=b.Group_Jaminan
                                where Status='1' and b.ID=:namajaminanId");
                $this->db->bind('namajaminanId', $namajaminanId);
                $data =  $this->db->resultSet();
            } else {
                $this->db->query("SELECT  a.*,Group_Jaminan from MasterdataSQL.dbo.MstrKarcisAdministrasi a
                                inner join MasterdataSQL.dbo.MstrPerusahaanJPK b on a.grup_tarif=b.Group_Jaminan
                                where Status='1' and b.ID=:namajaminanId");
                $this->db->bind('namajaminanId', $namajaminanId);
                $data =  $this->db->resultSet();
            }
            $rows = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['Nama_Karcis'] = $key['Nama_Karcis'];
                $pasing['Nilai_Karcis'] = $key['Nilai_Karcis'];
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
    public function GetAdministrasiById($data)
    {
        try {
            $idAdministrasi = $data['idAdministrasi'];
            $this->db->query("SELECT  *from MasterdataSQL.dbo.MstrKarcisAdministrasi where  id=:idAdministrasi");
            $this->db->bind('idAdministrasi', $idAdministrasi);
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success', // Set array status dengan success
                'Nilai_Karcis' => $data['Nilai_Karcis'], // Set array status dengan success
                'ID' => $data['ID'], // Set array status dengan success
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