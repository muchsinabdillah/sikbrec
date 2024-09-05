<?php
class MasterDataCOB_Model 
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getAllDataCOB()
    {
        try {
            $this->db->query("SELECT ID,NamaCOB,case when StatusCOB='1' then 'AKTIF' else 'TIDAK AKTIF' end as StatusCOB 
                        from MasterdataSQL.dbo.MasterCOB");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['NamaCOB'] = $key['NamaCOB'];
                $pasing['StatusCOB'] = $key['StatusCOB'];
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
            if ($data['namaCOB'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Nama COB !',
                );
                return $callback;
                exit;
            }
            if ($data['statusCOB'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Status COB !',
                );
                return $callback;
                exit;
            }
            // if ($data['NilaiKarcis'] == "") {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => 'Silahkan Input Nilai Karcis !',
            //     );
            //     return $callback;
            //     exit;
            // }
            // if ($data['GruptarifKarcis'] == "") {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => 'Silahkan Input Grup Tarif Karcis !',
            //     );
            //     return $callback;
            //     exit;
            // }
            $IdAuto = $data['IdAuto'];
            $namaCOB = $data['namaCOB'];
            // var_dump($namaCOB);
            // $NilaiKarcis = $data['NilaiKarcis'];
            $statusCOB = $data['statusCOB'];
            
            // $GruptarifKarcis = $data['GruptarifKarcis'];
            if ($data['IdAuto'] == "") {

                    $this->db->query("INSERT INTO MasterdataSQL.dbo.MasterCOB
                            (NamaCOB,StatusCOB)
                          values
                          ( :namaCOB,:statusCOB)");
                    $this->db->bind('namaCOB', $namaCOB);
                    $this->db->bind('statusCOB', $statusCOB);
            } else {
                $this->db->query("UPDATE MasterdataSQL.dbo.MasterCOB set  
                            NamaCOB=:namaCOB,StatusCOB=:statusCOB 
                            WHERE ID=:IdAuto");
                $this->db->bind('namaCOB', $namaCOB);
                $this->db->bind('statusCOB', $statusCOB);
                // $this->db->bind('StatusKarcis', $StatusKarcis); 
                // $this->db->bind('GruptarifKarcis', $GruptarifKarcis);
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
    public function getCOBId($id)
    {

        try {
            $this->db->query('SELECT ID,NamaCOB,StatusCOB 
                            from MasterdataSQL.dbo.MasterCOB
                            WHERE ID=:id');
            $this->db->bind('id', $id);
            $data =  $this->db->single();
            $pasing['ID'] = $data['ID'];
            $pasing['NamaCOB'] = $data['NamaCOB'];
            // $pasing['Nilai_Karcis'] = $data['Nilai_Karcis'];
            $pasing['StatusCOB'] = $data['StatusCOB'];
            // $pasing['grup_tarif'] = $data['grup_tarif'];
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
    public function getCOBAktif()
    {
        try {
            $this->db->query("SELECT ID,NamaCOB,case when StatusCOB='1' then 'AKTIF' else 'TIDAK AKTIF' end as Status,Kode_INACBG
                        from MasterdataSQL.dbo.MasterCOB WHERE StatusCOB='1'");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['NamaCOB'] = $key['NamaCOB'];
                $pasing['Status'] = $key['Status'];
                $pasing['Kode_INACBG'] = $key['Kode_INACBG'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getCOBAktif_Inacbg()
    {
        try {
            $this->db->query("SELECT ID,NamaCOB,case when StatusCOB='1' then 'AKTIF' else 'TIDAK AKTIF' end as Status,Kode_INACBG
                        from MasterdataSQL.dbo.MasterCOB WHERE StatusCOB='1' AND Kode_INACBG is not null");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['NamaCOB'] = $key['NamaCOB'];
                $pasing['Status'] = $key['Status'];
                $pasing['Kode_INACBG'] = $key['Kode_INACBG'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
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