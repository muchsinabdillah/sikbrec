<?php
class A_MasterDataTarif_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function GetTarifLaboratorium($data)
    {
        try {
            $Discontinue = '0';
            $GroupJaminan = $data['Group_Jaminan'];
            $this->db->query("SELECT a.IDTes, a.KodeTes, a.KodeKelompok,a.NamaTes, a.Tarif, 
                            a.TJamsostek, a.TGakin, b.Kelompok, a.InLevel
                            FROM LaboratoriumSQL.dbo.tblGrouping a
                            INNER JOIN LaboratoriumSQL.dbo.tblTestLab b ON a.KodeTes = b.KodeTes
                            WHERE a.InLevel='1' and Discontinue=:Discontinue
                            and a.Group_Jaminan=:GroupJaminan
                            ORDER BY a.InLevel, a.NamaTes, a.IDTes ");
            $this->db->bind('GroupJaminan', $GroupJaminan);
            $this->db->bind('Discontinue', $Discontinue);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $row) {
                $pasing['ID'] = $row['IDTes'];
                $pasing['NamaTes'] = $row['NamaTes'];
                $pasing['Tarif'] = $row['Tarif'];
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
    public function getDataPemeriksaanLabByID($data)
    {
        try {
            $idTarif = $data['Lab_kodeTes'];
            $this->db->query("SELECT a.IDTes, a.KodeTes, a.KodeKelompok,a.NamaTes,  cast(replace(a.Tarif, '.00','') as integer) as Tarif, a.TJamsostek, a.TGakin, b.Kelompok, a.InLevel
                            FROM LaboratoriumSQL.dbo.tblGrouping a
                            INNER JOIN LaboratoriumSQL.dbo.tblTestLab b ON a.KodeTes = b.KodeTes
                            WHERE a.InLevel='1'  AND a.IDTes=:idTarif and a.KodeKelompok is not null
                            ORDER BY a.InLevel, a.NamaTes, a.IDTes");
            $this->db->bind('idTarif', $idTarif);
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success',
                'IDTes' => $data['IDTes'],
                'KodeKelompok' => $data['KodeKelompok'],
                'Tarif' => $data['Tarif'], 
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
    public function getKodePDP()
    {
        try {
            $this->db->query("SELECT * from Keuangan.dbo.BO_M_PDP");
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['KD_PDP'] = $key['KD_PDP'];
                $pasing['NM_PDP'] = $key['NM_PDP'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getKodeJasa()
    {
        try {
            $this->db->query("SELECT * from Keuangan.dbo.BO_M_JASA");
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['KD_JASA'] = $key['KD_JASA'];
                $pasing['NM_JASA'] = $key['NM_JASA'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    //TRANSAKSI TARIF
    public function getListDataTransaksiTarif($data)
    {
        try {

            $query = "SELECT *,replace(CONVERT(VARCHAR(11), TGL_BERLAKU, 111), '/','-') as TglBerlaku, replace(CONVERT(VARCHAR(11), TGL_EXPIRED, 111), '/','-') as TglExpired,b.username
            from PerawatanSQL.dbo.Tarif_RJ_UGD_3 a
            inner join MasterDataSQL.dbo.Employees b on a.USER_ENTRY=b.ID
            where a.Batal='0'
            ";

            $this->db->query($query);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $row) {
                $pasing['ID_TR_TARIF'] = $row['ID_TR_TARIF'];
                $pasing['TGL_ENTRY'] = $row['TGL_ENTRY'];
                $pasing['USER_ENTRY'] = $row['USER_ENTRY'];
                $pasing['NOTE'] = $row['NOTE'];
                $pasing['TGL_BERLAKU'] = $row['TGL_BERLAKU'];
                $pasing['TGL_EXPIRED'] = $row['TGL_EXPIRED'];
                $pasing['BATAL'] = $row['BATAL'];
                $pasing['TANGGAL_BATAL'] = $row['TANGGAL_BATAL'];
                $pasing['ALASAN'] = $row['ALASAN'];
                $pasing['TglBerlaku'] = $row['TglBerlaku'];
                $pasing['TglExpired'] = $row['TglExpired'];
                $pasing['username'] = $row['username'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getListDataTransaksiTarifLab($data)
    {
        try {

            $query = "SELECT *,replace(CONVERT(VARCHAR(11), TGL_BERLAKU, 111), '/','-') as TglBerlaku, replace(CONVERT(VARCHAR(11), TGL_EXPIRED, 111), '/','-') as TglExpired,b.username
            from LaboratoriumSQL.dbo.tblGrouping_3  a
            inner join MasterDataSQL.dbo.Employees b on a.USER_ENTRY=b.ID
            where a.Batal='0'
            ";

            $this->db->query($query);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $row) {
                $pasing['ID_TR_TARIF'] = $row['ID_TR_TARIF'];
                $pasing['TGL_ENTRY'] = $row['TGL_ENTRY'];
                $pasing['USER_ENTRY'] = $row['USER_ENTRY'];
                $pasing['NOTE'] = $row['NOTE'];
                $pasing['TGL_BERLAKU'] = $row['TGL_BERLAKU'];
                $pasing['TGL_EXPIRED'] = $row['TGL_EXPIRED'];
                $pasing['BATAL'] = $row['BATAL'];
                $pasing['TANGGAL_BATAL'] = $row['TANGGAL_BATAL'];
                $pasing['ALASAN'] = $row['ALASAN'];
                $pasing['TglBerlaku'] = $row['TglBerlaku'];
                $pasing['TglExpired'] = $row['TglExpired'];
                $pasing['username'] = $row['username'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getListDataTransaksiTarifRad($data)
    {
        try {

            $query = "SELECT *,replace(CONVERT(VARCHAR(11), TGL_BERLAKU, 111), '/','-') as TglBerlaku, replace(CONVERT(VARCHAR(11), TGL_EXPIRED, 111), '/','-') as TglExpired,b.username
            from RadiologiSQL.dbo.ProcedureRadiology_3  a
            inner join MasterDataSQL.dbo.Employees b on a.USER_ENTRY=b.ID
            where a.Batal='0'
            ";

            $this->db->query($query);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $row) {
                $pasing['ID_TR_TARIF'] = $row['ID_TR_TARIF'];
                $pasing['TGL_ENTRY'] = $row['TGL_ENTRY'];
                $pasing['USER_ENTRY'] = $row['USER_ENTRY'];
                $pasing['NOTE'] = $row['NOTE'];
                $pasing['TGL_BERLAKU'] = $row['TGL_BERLAKU'];
                $pasing['TGL_EXPIRED'] = $row['TGL_EXPIRED'];
                $pasing['BATAL'] = $row['BATAL'];
                $pasing['TANGGAL_BATAL'] = $row['TANGGAL_BATAL'];
                $pasing['ALASAN'] = $row['ALASAN'];
                $pasing['TglBerlaku'] = $row['TglBerlaku'];
                $pasing['TglExpired'] = $row['TglExpired'];
                $pasing['username'] = $row['username'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getListDataTransaksiTarifRI($data)
    {
        try {

            $query = "SELECT *,replace(CONVERT(VARCHAR(11), TGL_BERLAKU, 111), '/','-') as TglBerlaku, replace(CONVERT(VARCHAR(11), TGL_EXPIRED, 111), '/','-') as TglExpired,b.username
            from RawatInapSQL.dbo.Tarif_RI_3 a
            inner join MasterDataSQL.dbo.Employees b on a.USER_ENTRY=b.ID
            where a.Batal='0'
            ";

            $this->db->query($query);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $row) {
                $pasing['ID_TR_TARIF'] = $row['ID_TR_TARIF'];
                $pasing['TGL_ENTRY'] = $row['TGL_ENTRY'];
                $pasing['USER_ENTRY'] = $row['USER_ENTRY'];
                $pasing['NOTE'] = $row['NOTE'];
                $pasing['TGL_BERLAKU'] = $row['TGL_BERLAKU'];
                $pasing['TGL_EXPIRED'] = $row['TGL_EXPIRED'];
                $pasing['BATAL'] = $row['BATAL'];
                $pasing['TANGGAL_BATAL'] = $row['TANGGAL_BATAL'];
                $pasing['ALASAN'] = $row['ALASAN'];
                $pasing['TglBerlaku'] = $row['TglBerlaku'];
                $pasing['TglExpired'] = $row['TglExpired'];
                $pasing['username'] = $row['username'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getTransaksiTarifbyID($data)
    {
        try {
            $IDs = $data['id'];
            $this->db->query("SELECT *,replace(CONVERT(VARCHAR(11), TGL_BERLAKU, 111), '/','-') as TglBerlaku, replace(CONVERT(VARCHAR(11), TGL_EXPIRED, 111), '/','-') as TglExpired,b.username,KD_INSTALASI
                        from PerawatanSQL.dbo.Tarif_RJ_UGD_3 a
                        inner join MasterDataSQL.dbo.Employees b on a.USER_ENTRY=b.ID
                        WHERE ID_TR_TARIF=:id");
            $this->db->bind('id', $IDs);
            $row =  $this->db->single();
            $pasing['ID_TR_TARIF'] = $row['ID_TR_TARIF'];
            $pasing['TGL_ENTRY'] = $row['TGL_ENTRY'];
            $pasing['USER_ENTRY'] = $row['USER_ENTRY'];
            $pasing['NOTE'] = $row['NOTE'];
            $pasing['TGL_BERLAKU'] = $row['TGL_BERLAKU'];
            $pasing['TGL_EXPIRED'] = $row['TGL_EXPIRED'];
            $pasing['BATAL'] = $row['BATAL'];
            $pasing['TANGGAL_BATAL'] = $row['TANGGAL_BATAL'];
            $pasing['ALASAN'] = $row['ALASAN'];
            $pasing['TglBerlaku'] = $row['TglBerlaku']; 
            $pasing['TglExpired'] = $row['TglExpired'];  
            $pasing['username'] = $row['username'];  
            $pasing['KD_INSTALASI'] = $row['KD_INSTALASI'];  

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
    public function getTransaksiTarifbyIDlab($data)
    {
        try {
            $IDs = $data['id'];
            $this->db->query("SELECT *,replace(CONVERT(VARCHAR(11), TGL_BERLAKU, 111), '/','-') as TglBerlaku, replace(CONVERT(VARCHAR(11), TGL_EXPIRED, 111), '/','-') as TglExpired,b.username,KD_INSTALASI
                        from LaboratoriumSQL.dbo.tblGrouping_3  a
                        inner join MasterDataSQL.dbo.Employees b on a.USER_ENTRY=b.ID
                        WHERE ID_TR_TARIF=:id");
            $this->db->bind('id', $IDs);
            $row =  $this->db->single();
            $pasing['ID_TR_TARIF'] = $row['ID_TR_TARIF'];
            $pasing['TGL_ENTRY'] = $row['TGL_ENTRY'];
            $pasing['USER_ENTRY'] = $row['USER_ENTRY'];
            $pasing['NOTE'] = $row['NOTE'];
            $pasing['TGL_BERLAKU'] = $row['TGL_BERLAKU'];
            $pasing['TGL_EXPIRED'] = $row['TGL_EXPIRED'];
            $pasing['BATAL'] = $row['BATAL'];
            $pasing['TANGGAL_BATAL'] = $row['TANGGAL_BATAL'];
            $pasing['ALASAN'] = $row['ALASAN'];
            $pasing['TglBerlaku'] = $row['TglBerlaku']; 
            $pasing['TglExpired'] = $row['TglExpired'];  
            $pasing['username'] = $row['username'];  
            $pasing['KD_INSTALASI'] = $row['KD_INSTALASI'];  

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
    public function getTransaksiTarifbyIDrad($data)
    {
        try {
            $IDs = $data['id'];
            $this->db->query("SELECT *,replace(CONVERT(VARCHAR(11), TGL_BERLAKU, 111), '/','-') as TglBerlaku, replace(CONVERT(VARCHAR(11), TGL_EXPIRED, 111), '/','-') as TglExpired,b.username,KD_INSTALASI
                        from RadiologiSQL.dbo.ProcedureRadiology_3  a
                        inner join MasterDataSQL.dbo.Employees b on a.USER_ENTRY=b.ID
                        WHERE ID_TR_TARIF=:id");
            $this->db->bind('id', $IDs);
            $row =  $this->db->single();
            $pasing['ID_TR_TARIF'] = $row['ID_TR_TARIF'];
            $pasing['TGL_ENTRY'] = $row['TGL_ENTRY'];
            $pasing['USER_ENTRY'] = $row['USER_ENTRY'];
            $pasing['NOTE'] = $row['NOTE'];
            $pasing['TGL_BERLAKU'] = $row['TGL_BERLAKU'];
            $pasing['TGL_EXPIRED'] = $row['TGL_EXPIRED'];
            $pasing['BATAL'] = $row['BATAL'];
            $pasing['TANGGAL_BATAL'] = $row['TANGGAL_BATAL'];
            $pasing['ALASAN'] = $row['ALASAN'];
            $pasing['TglBerlaku'] = $row['TglBerlaku']; 
            $pasing['TglExpired'] = $row['TglExpired'];  
            $pasing['username'] = $row['username'];  
            $pasing['KD_INSTALASI'] = $row['KD_INSTALASI'];  

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
    public function getTransaksiTarifbyIDRI($data)
    {
        try {
            $IDs = $data['id'];
            $this->db->query("SELECT *,replace(CONVERT(VARCHAR(11), TGL_BERLAKU, 111), '/','-') as TglBerlaku, replace(CONVERT(VARCHAR(11), TGL_EXPIRED, 111), '/','-') as TglExpired,b.username,KD_INSTALASI
                        from RawatInapSQL.dbo.Tarif_RI_3  a
                        inner join MasterDataSQL.dbo.Employees b on a.USER_ENTRY=b.ID
                        WHERE ID_TR_TARIF=:id");
            $this->db->bind('id', $IDs);
            $row =  $this->db->single();
            $pasing['ID_TR_TARIF'] = $row['ID_TR_TARIF'];
            $pasing['TGL_ENTRY'] = $row['TGL_ENTRY'];
            $pasing['USER_ENTRY'] = $row['USER_ENTRY'];
            $pasing['NOTE'] = $row['NOTE'];
            $pasing['TGL_BERLAKU'] = $row['TGL_BERLAKU'];
            $pasing['TGL_EXPIRED'] = $row['TGL_EXPIRED'];
            $pasing['BATAL'] = $row['BATAL'];
            $pasing['TANGGAL_BATAL'] = $row['TANGGAL_BATAL'];
            $pasing['ALASAN'] = $row['ALASAN'];
            $pasing['TglBerlaku'] = $row['TglBerlaku']; 
            $pasing['TglExpired'] = $row['TglExpired'];  
            $pasing['username'] = $row['username'];  
            $pasing['KD_INSTALASI'] = $row['KD_INSTALASI'];  

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
    public function saveTrs_Tarif($data)
    {
        try {
            $this->db->transaksi();
            if ($data['Note'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Note !',
                );
                return $callback;
                exit;
            }
            if ($data['TglBerlaku'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Tanggal Berlaku !',
                );
                return $callback;
                exit;
            }
            if ($data['TglExpired'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Tanggal Expired !',
                );
                return $callback;
                exit;
            }
            if ($data['kd_instalasi'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Kode Instalasi !',
                );
                return $callback;
                exit;
            }

            $IdAuto = $data['IdAuto'];
            $Note = $data['Note'];
            $TglBerlaku = $data['TglBerlaku'];
            $TglExpired = $data['TglExpired'];
            $Status = '0';
            $TglBatal = $data['TglBatal'];
            $AlasanBatal = $data['AlasanBatal'];
            $kd_instalasi = $data['kd_instalasi'];

            $datenowcreate = Utils::seCurrentDateTime(); //Session user
            $session = SessionManager::getCurrentSession();
            $operator =  $session->IDEmployee;

            // $ID_TR_TARIF = 'TRF280522002';

            if ($data['IdAuto'] == "") {
                if($kd_instalasi == "RJ"){
                    //GET URUT
                    $datenowlis = date('dmy', strtotime($datenowcreate));
                    $this->db->query("SELECT  max(ID_TR_TARIF) as nourut from PerawatanSQL.dbo.TARIF_RJ_UGD_3 WHERE SUBSTRING(ID_TR_TARIF, 3, 6)=:datenowlis ");
                    $this->db->bind('datenowlis',   $datenowlis);
                    $data =  $this->db->single();
                    $nourut = $data['nourut'];
                    $substringlis = substr($nourut, 8);
                    if ($substringlis == null) {
                        $substringlis = 0;
                    }
                    $substringlis++;
                    if (strlen($substringlis) == 1) {
                        $nourutfixLis = "00" . $substringlis;
                    } else if (strlen($substringlis) == 2) {
                        $nourutfixLis = "0" . $substringlis;
                    } else if (strlen($substringlis) == 3) {
                        $nourutfixLis = $substringlis;
                    }

                    $ID_TR_TARIF = 'TR' . $datenowlis . $nourutfixLis;
                

                    //INSERT
                    $this->db->query("INSERT INTO PerawatanSQL.dbo.Tarif_RJ_UGD_3
                                (ID_TR_TARIF,TGL_ENTRY,USER_ENTRY,NOTE,TGL_BERLAKU,TGL_EXPIRED,BATAL,KD_INSTALASI)
                            values
                            ( :ID_TR_TARIF,:datenowcreate,:operator,:Note,:TglBerlaku,:TglExpired,:Status,:kd_instalasi)");
                    $this->db->bind('ID_TR_TARIF', $ID_TR_TARIF);
                    $this->db->bind('Status', $Status);
                    $this->db->bind('Note', $Note);
                    $this->db->bind('TglBerlaku', $TglBerlaku);
                    $this->db->bind('datenowcreate', $datenowcreate);
                    $this->db->bind('operator', $operator);
                    $this->db->bind('TglExpired', $TglExpired);
                    $this->db->bind('kd_instalasi', $kd_instalasi);
                    $this->db->execute();
                }else if($kd_instalasi == "RI"){

                }else if($kd_instalasi == "LAB"){
                    //GET URUT
                    $datenowlis = date('dmy', strtotime($datenowcreate));
                    $this->db->query("SELECT  max(ID_TR_TARIF) as nourut from LaboratoriumSQL.dbo.tblGrouping_3 
                    WHERE SUBSTRING(ID_TR_TARIF, 3, 6)=:datenowlis ");
                    $this->db->bind('datenowlis',   $datenowlis);
                    $this->db->execute();
                    $data =  $this->db->single();
                    $nourut = $data['nourut'];
                    $substringlis = substr($nourut, 8);
                    if ($substringlis == null) {
                        $substringlis = 0;
                    }
                    $substringlis++;
                    if (strlen($substringlis) == 1) {
                        $nourutfixLis = "00" . $substringlis;
                    } else if (strlen($substringlis) == 2) {
                        $nourutfixLis = "0" . $substringlis;
                    } else if (strlen($substringlis) == 3) {
                        $nourutfixLis = $substringlis;
                    }

                    $ID_TR_TARIF = 'TL' . $datenowlis . $nourutfixLis;
                

                    //INSERT
                    $this->db->query("INSERT INTO LaboratoriumSQL.dbo.tblGrouping_3
                                (ID_TR_TARIF,TGL_ENTRY,USER_ENTRY,NOTE,TGL_BERLAKU,TGL_EXPIRED,BATAL,KD_INSTALASI)
                            values
                            ( :ID_TR_TARIF,:datenowcreate,:operator,:Note,:TglBerlaku,:TglExpired,:Status,:kd_instalasi)");
                    $this->db->bind('ID_TR_TARIF', $ID_TR_TARIF);
                    $this->db->bind('Status', $Status);
                    $this->db->bind('Note', $Note);
                    $this->db->bind('TglBerlaku', $TglBerlaku);
                    $this->db->bind('datenowcreate', $datenowcreate);
                    $this->db->bind('operator', $operator);
                    $this->db->bind('TglExpired', $TglExpired);
                    $this->db->bind('kd_instalasi', $kd_instalasi);
                    $this->db->execute();

                }else if($kd_instalasi == "RAD"){
                    //GET URUT
                    $datenowlis = date('dmy', strtotime($datenowcreate));
                    $this->db->query("SELECT  max(ID_TR_TARIF) as nourut from RadiologiSQL.dbo.ProcedureRadiology_3 
                    WHERE SUBSTRING(ID_TR_TARIF, 3, 6)=:datenowlis ");
                    $this->db->bind('datenowlis',   $datenowlis);
                    $this->db->execute();
                    $data =  $this->db->single();
                    $nourut = $data['nourut'];
                    $substringlis = substr($nourut, 8);
                    if ($substringlis == null) {
                        $substringlis = 0;
                    }
                    $substringlis++;
                    if (strlen($substringlis) == 1) {
                        $nourutfixLis = "00" . $substringlis;
                    } else if (strlen($substringlis) == 2) {
                        $nourutfixLis = "0" . $substringlis;
                    } else if (strlen($substringlis) == 3) {
                        $nourutfixLis = $substringlis;
                    }

                    $ID_TR_TARIF = 'TR' . $datenowlis . $nourutfixLis;
                

                    //INSERT
                    $this->db->query("INSERT INTO RadiologiSQL.dbo.ProcedureRadiology_3
                                (ID_TR_TARIF,TGL_ENTRY,USER_ENTRY,NOTE,TGL_BERLAKU,TGL_EXPIRED,BATAL,KD_INSTALASI)
                            values
                            ( :ID_TR_TARIF,:datenowcreate,:operator,:Note,:TglBerlaku,:TglExpired,:Status,:kd_instalasi)");
                    $this->db->bind('ID_TR_TARIF', $ID_TR_TARIF);
                    $this->db->bind('Status', $Status);
                    $this->db->bind('Note', $Note);
                    $this->db->bind('TglBerlaku', $TglBerlaku);
                    $this->db->bind('datenowcreate', $datenowcreate);
                    $this->db->bind('operator', $operator);
                    $this->db->bind('TglExpired', $TglExpired);
                    $this->db->bind('kd_instalasi', $kd_instalasi);
                    $this->db->execute();

                }
                



            } else {

                $this->db->query("UPDATE PerawatanSQL.dbo.Tarif_RJ_UGD_3 set 
                            NOTE=:Note,
                            TGL_BERLAKU=:TglBerlaku,
                            TGL_EXPIRED=:TglExpired,
                            KD_INSTALASI=:kd_instalasi
                            WHERE ID_TR_TARIF=:IdAuto");
                $this->db->bind('IdAuto', $IdAuto);
                $this->db->bind('Note', $Note);
                $this->db->bind('TglBerlaku', $TglBerlaku);
                $this->db->bind('TglExpired', $TglExpired);
                $this->db->bind('kd_instalasi', $kd_instalasi);
                $this->db->execute();

            }
      
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
    public function saveTrs_Tariflab($data)
    {
        try {
            $this->db->transaksi();
            if ($data['Note'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Note !',
                );
                return $callback;
                exit;
            }
            if ($data['TglBerlaku'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Tanggal Berlaku !',
                );
                return $callback;
                exit;
            }
            if ($data['TglExpired'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Tanggal Expired !',
                );
                return $callback;
                exit;
            }
            if ($data['kd_instalasi'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Kode Instalasi !',
                );
                return $callback;
                exit;
            }

            $IdAuto = $data['IdAuto'];
            $Note = $data['Note'];
            $TglBerlaku = $data['TglBerlaku'];
            $TglExpired = $data['TglExpired'];
            $Status = '0';
            $TglBatal = $data['TglBatal'];
            $AlasanBatal = $data['AlasanBatal'];
            $kd_instalasi = $data['kd_instalasi'];

            $datenowcreate = Utils::seCurrentDateTime(); //Session user
            $session = SessionManager::getCurrentSession();
            $operator =  $session->IDEmployee;

            // $ID_TR_TARIF = 'TRF280522002';

            if ($data['IdAuto'] == "") {
                 
                    //GET URUT
                    $datenowlis = date('dmy', strtotime($datenowcreate));
                    $this->db->query("SELECT  max(ID_TR_TARIF) as nourut from LaboratoriumSQL.dbo.tblGrouping_3 
                    WHERE SUBSTRING(ID_TR_TARIF, 3, 6)=:datenowlis ");
                    $this->db->bind('datenowlis',   $datenowlis);
                    $this->db->execute();
                    $data =  $this->db->single();
                    $nourut = $data['nourut'];
                    $substringlis = substr($nourut, 8);
                    if ($substringlis == null) {
                        $substringlis = 0;
                    }
                    $substringlis++;
                    if (strlen($substringlis) == 1) {
                        $nourutfixLis = "00" . $substringlis;
                    } else if (strlen($substringlis) == 2) {
                        $nourutfixLis = "0" . $substringlis;
                    } else if (strlen($substringlis) == 3) {
                        $nourutfixLis = $substringlis;
                    }

                    $ID_TR_TARIF = 'TL' . $datenowlis . $nourutfixLis;
                 
                    //INSERT
                    $this->db->query("INSERT INTO LaboratoriumSQL.dbo.tblGrouping_3
                                (ID_TR_TARIF,TGL_ENTRY,USER_ENTRY,NOTE,TGL_BERLAKU,TGL_EXPIRED,BATAL,KD_INSTALASI)
                            values
                            ( :ID_TR_TARIF,:datenowcreate,:operator,:Note,:TglBerlaku,:TglExpired,:Status,:kd_instalasi)");
                    $this->db->bind('ID_TR_TARIF', $ID_TR_TARIF);
                    $this->db->bind('Status', $Status);
                    $this->db->bind('Note', $Note);
                    $this->db->bind('TglBerlaku', $TglBerlaku);
                    $this->db->bind('datenowcreate', $datenowcreate);
                    $this->db->bind('operator', $operator);
                    $this->db->bind('TglExpired', $TglExpired);
                    $this->db->bind('kd_instalasi', $kd_instalasi);
                    $this->db->execute(); 

            } else {

                $this->db->query("UPDATE LaboratoriumSQL.dbo.tblGrouping_3 set 
                            NOTE=:Note,
                            TGL_BERLAKU=:TglBerlaku,
                            TGL_EXPIRED=:TglExpired,
                            KD_INSTALASI=:kd_instalasi
                            WHERE ID_TR_TARIF=:IdAuto");
                $this->db->bind('IdAuto', $IdAuto);
                $this->db->bind('Note', $Note);
                $this->db->bind('TglBerlaku', $TglBerlaku);
                $this->db->bind('TglExpired', $TglExpired);
                $this->db->bind('kd_instalasi', $kd_instalasi);
                $this->db->execute();

            }
      
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
    public function saveTrs_Tarifrad($data)
    {
        try {
            $this->db->transaksi();
            if ($data['Note'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Note !',
                );
                return $callback;
                exit;
            }
            if ($data['TglBerlaku'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Tanggal Berlaku !',
                );
                return $callback;
                exit;
            }
            if ($data['TglExpired'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Tanggal Expired !',
                );
                return $callback;
                exit;
            }
            if ($data['kd_instalasi'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Kode Instalasi !',
                );
                return $callback;
                exit;
            }

            $IdAuto = $data['IdAuto'];
            $Note = $data['Note'];
            $TglBerlaku = $data['TglBerlaku'];
            $TglExpired = $data['TglExpired'];
            $Status = '0';
            $TglBatal = $data['TglBatal'];
            $AlasanBatal = $data['AlasanBatal'];
            $kd_instalasi = $data['kd_instalasi'];

            $datenowcreate = Utils::seCurrentDateTime(); //Session user
            $session = SessionManager::getCurrentSession();
            $operator =  $session->IDEmployee;

            // $ID_TR_TARIF = 'TRF280522002';

            if ($data['IdAuto'] == "") {
                 
                    //GET URUT
                    $datenowlis = date('dmy', strtotime($datenowcreate));
                    $this->db->query("SELECT  max(ID_TR_TARIF) as nourut from RadiologiSQL.dbo.ProcedureRadiology_3 
                    WHERE SUBSTRING(ID_TR_TARIF, 3, 6)=:datenowlis ");
                    $this->db->bind('datenowlis',   $datenowlis);
                    $this->db->execute();
                    $data =  $this->db->single();
                    $nourut = $data['nourut'];
                    $substringlis = substr($nourut, 8);
                    if ($substringlis == null) {
                        $substringlis = 0;
                    }
                    $substringlis++;
                    if (strlen($substringlis) == 1) {
                        $nourutfixLis = "00" . $substringlis;
                    } else if (strlen($substringlis) == 2) {
                        $nourutfixLis = "0" . $substringlis;
                    } else if (strlen($substringlis) == 3) {
                        $nourutfixLis = $substringlis;
                    }

                    $ID_TR_TARIF = 'TR' . $datenowlis . $nourutfixLis;
                

                    //INSERT
                    $this->db->query("INSERT INTO RadiologiSQL.dbo.ProcedureRadiology_3
                                (ID_TR_TARIF,TGL_ENTRY,USER_ENTRY,NOTE,TGL_BERLAKU,TGL_EXPIRED,BATAL,KD_INSTALASI)
                            values
                            ( :ID_TR_TARIF,:datenowcreate,:operator,:Note,:TglBerlaku,:TglExpired,:Status,:kd_instalasi)");
                    $this->db->bind('ID_TR_TARIF', $ID_TR_TARIF);
                    $this->db->bind('Status', $Status);
                    $this->db->bind('Note', $Note);
                    $this->db->bind('TglBerlaku', $TglBerlaku);
                    $this->db->bind('datenowcreate', $datenowcreate);
                    $this->db->bind('operator', $operator);
                    $this->db->bind('TglExpired', $TglExpired);
                    $this->db->bind('kd_instalasi', $kd_instalasi);
                    $this->db->execute(); 

            } else {

                $this->db->query("UPDATE RadiologiSQL.dbo.ProcedureRadiology_3 set 
                            NOTE=:Note,
                            TGL_BERLAKU=:TglBerlaku,
                            TGL_EXPIRED=:TglExpired,
                            KD_INSTALASI=:kd_instalasi
                            WHERE ID_TR_TARIF=:IdAuto");
                $this->db->bind('IdAuto', $IdAuto);
                $this->db->bind('Note', $Note);
                $this->db->bind('TglBerlaku', $TglBerlaku);
                $this->db->bind('TglExpired', $TglExpired);
                $this->db->bind('kd_instalasi', $kd_instalasi);
                $this->db->execute();

            }
      
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
    public function saveTrs_TarifRI($data)
    {
        try {
            $this->db->transaksi();
            if ($data['Note'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Note !',
                );
                return $callback;
                exit;
            }
            if ($data['TglBerlaku'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Tanggal Berlaku !',
                );
                return $callback;
                exit;
            }
            if ($data['TglExpired'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Tanggal Expired !',
                );
                return $callback;
                exit;
            }
            if ($data['kd_instalasi'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Kode Instalasi !',
                );
                return $callback;
                exit;
            }

            $IdAuto = $data['IdAuto'];
            $Note = $data['Note'];
            $TglBerlaku = $data['TglBerlaku'];
            $TglExpired = $data['TglExpired'];
            $Status = '0';
            $TglBatal = $data['TglBatal'];
            $AlasanBatal = $data['AlasanBatal'];
            $kd_instalasi = $data['kd_instalasi'];

            $datenowcreate = Utils::seCurrentDateTime(); //Session user
            $session = SessionManager::getCurrentSession();
            $operator =  $session->IDEmployee;

            // $ID_TR_TARIF = 'TRF280522002';

            if ($data['IdAuto'] == "") {
                 
                    //GET URUT
                    $datenowlis = date('dmy', strtotime($datenowcreate));
                    $this->db->query("SELECT  max(ID_TR_TARIF) as nourut from RawatInapSQL.dbo.Tarif_RI_3
                    WHERE SUBSTRING(ID_TR_TARIF, 3, 6)=:datenowlis ");
                    $this->db->bind('datenowlis',   $datenowlis);
                    $this->db->execute();
                    $data =  $this->db->single();
                    $nourut = $data['nourut'];
                    $substringlis = substr($nourut, 8);
                    if ($substringlis == null) {
                        $substringlis = 0;
                    }
                    $substringlis++;
                    if (strlen($substringlis) == 1) {
                        $nourutfixLis = "00" . $substringlis;
                    } else if (strlen($substringlis) == 2) {
                        $nourutfixLis = "0" . $substringlis;
                    } else if (strlen($substringlis) == 3) {
                        $nourutfixLis = $substringlis;
                    }

                    $ID_TR_TARIF = 'TI' . $datenowlis . $nourutfixLis;
                

                    //INSERT
                    $this->db->query("INSERT INTO RawatInapSQL.dbo.Tarif_RI_3
                                (ID_TR_TARIF,TGL_ENTRY,USER_ENTRY,NOTE,TGL_BERLAKU,TGL_EXPIRED,BATAL,KD_INSTALASI)
                            values
                            ( :ID_TR_TARIF,:datenowcreate,:operator,:Note,:TglBerlaku,:TglExpired,:Status,:kd_instalasi)");
                    $this->db->bind('ID_TR_TARIF', $ID_TR_TARIF);
                    $this->db->bind('Status', $Status);
                    $this->db->bind('Note', $Note);
                    $this->db->bind('TglBerlaku', $TglBerlaku);
                    $this->db->bind('datenowcreate', $datenowcreate);
                    $this->db->bind('operator', $operator);
                    $this->db->bind('TglExpired', $TglExpired);
                    $this->db->bind('kd_instalasi', $kd_instalasi);
                    $this->db->execute(); 

            } else {

                $this->db->query("UPDATE RawatInapSQL.dbo.Tarif_RI_3 set 
                            NOTE=:Note,
                            TGL_BERLAKU=:TglBerlaku,
                            TGL_EXPIRED=:TglExpired,
                            KD_INSTALASI=:kd_instalasi
                            WHERE ID_TR_TARIF=:IdAuto");
                $this->db->bind('IdAuto', $IdAuto);
                $this->db->bind('Note', $Note);
                $this->db->bind('TglBerlaku', $TglBerlaku);
                $this->db->bind('TglExpired', $TglExpired);
                $this->db->bind('kd_instalasi', $kd_instalasi);
                $this->db->execute();

            }
      
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
    public function BatalTransaksiTarif($data)
    {
        try {
            $this->db->transaksi();

            $Status = '1';
            $TglBatal = Utils::seCurrentDateTime();
            $AlasanBatal = $data['alasan'];
            $IdAuto = $data['IdAuto'];

            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $operator =  $session->IDEmployee;

            $this->db->query("UPDATE PerawatanSQL.dbo.Tarif_RJ_UGD_3 set 
                            BATAL=:Status,
                            TANGGAL_BATAL=:TglBatal,
                            ALASAN=:AlasanBatal
                            WHERE ID_TR_TARIF=:IdAuto");
            $this->db->bind('IdAuto', $IdAuto);
            $this->db->bind('Status', $Status);
            $this->db->bind('TglBatal', $TglBatal);
            $this->db->bind('AlasanBatal', $AlasanBatal);
            $this->db->execute();

            $this->db->query("DELETE PerawatanSQL.dbo.Tarif_RJ_UGD_4 
                            WHERE ID_TR_TARIF=:IdAuto");
            $this->db->bind('IdAuto', $IdAuto);
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
    public function BatalTransaksiTariflab($data)
    {
        try {
            $this->db->transaksi();

            $Status = '1';
            $TglBatal = Utils::seCurrentDateTime();
            $AlasanBatal = $data['alasan'];
            $IdAuto = $data['IdAuto'];

            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $operator =  $session->IDEmployee;

            $this->db->query("UPDATE LaboratoriumSQL.dbo.tblGrouping_3  set 
                            BATAL=:Status,
                            TANGGAL_BATAL=:TglBatal,
                            ALASAN=:AlasanBatal
                            WHERE ID_TR_TARIF=:IdAuto");
            $this->db->bind('IdAuto', $IdAuto);
            $this->db->bind('Status', $Status);
            $this->db->bind('TglBatal', $TglBatal);
            $this->db->bind('AlasanBatal', $AlasanBatal);
            $this->db->execute();

            $this->db->query("DELETE LaboratoriumSQL.dbo.tblGrouping_4
                            WHERE ID_TR_TARIF=:IdAuto");
            $this->db->bind('IdAuto', $IdAuto);
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
    public function BatalTransaksiTarifrad($data)
    {
        try {
            $this->db->transaksi();

            $Status = '1';
            $TglBatal = Utils::seCurrentDateTime();
            $AlasanBatal = $data['alasan'];
            $IdAuto = $data['IdAuto'];

            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $operator =  $session->IDEmployee;

            $this->db->query("UPDATE RadiologiSQL.dbo.ProcedureRadiology_3 set 
                            BATAL=:Status,
                            TANGGAL_BATAL=:TglBatal,
                            ALASAN=:AlasanBatal
                            WHERE ID_TR_TARIF=:IdAuto");
            $this->db->bind('IdAuto', $IdAuto);
            $this->db->bind('Status', $Status);
            $this->db->bind('TglBatal', $TglBatal);
            $this->db->bind('AlasanBatal', $AlasanBatal);
            $this->db->execute();

            $this->db->query("DELETE RadiologiSQL.dbo.ProcedureRadiology_4
                            WHERE ID_TR_TARIF=:IdAuto");
            $this->db->bind('IdAuto', $IdAuto);
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
    public function BatalTransaksiTarifRI($data)
    {
        try {
            $this->db->transaksi();

            $Status = '1';
            $TglBatal = Utils::seCurrentDateTime();
            $AlasanBatal = $data['alasan'];
            $IdAuto = $data['IdAuto'];

            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $operator =  $session->IDEmployee;

            $this->db->query("UPDATE RawatInapSQL.dbo.Tarif_RI_3 set 
                            BATAL=:Status,
                            TANGGAL_BATAL=:TglBatal,
                            ALASAN=:AlasanBatal
                            WHERE ID_TR_TARIF=:IdAuto");
            $this->db->bind('IdAuto', $IdAuto);
            $this->db->bind('Status', $Status);
            $this->db->bind('TglBatal', $TglBatal);
            $this->db->bind('AlasanBatal', $AlasanBatal);
            $this->db->execute();

            $this->db->query("DELETE RawatInapSQL.dbo.Tarif_RI_4
                            WHERE ID_TR_TARIF=:IdAuto");
            $this->db->bind('IdAuto', $IdAuto);
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
    public function getListTransaksiTarif_Detail($data)
    {
        try {
            $id = $data['IdAuto'];

            $query = "SELECT * FROM PerawatanSQL.dbo.Tarif_RJ_UGD_4
            WHERE ID_TR_TARIF=:ID";

            $this->db->query($query);
            $this->db->bind('ID', $id);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $row) {
                $pasing['ID_TR_TARIF'] = $row['ID_TR_TARIF'];
                $pasing['ID_TARIF'] = $row['ID_TARIF'];
                $pasing['GROUP_TARIF'] = $row['GROUP_TARIF'];
                $pasing['NILAI'] = $row['NILAI'];
                $pasing['KLSID'] = $row['KLSID'];
                $pasing['GROUP_TARIF_2'] = $row['GROUP_TARIF_2'];
                $pasing['ID_TR_TARIF_PAKET'] = $row['ID_TR_TARIF_PAKET'];
                $pasing['KD_INSTALASI'] = $row['KD_INSTALASI'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getListTransaksiTarif_Detaillab($data)
    {
        try {
            $id = $data['IdAuto'];

            $query = "SELECT * FROM LaboratoriumSQL.dbo.tblGrouping_4
            WHERE ID_TR_TARIF=:ID";

            $this->db->query($query);
            $this->db->bind('ID', $id);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $row) {
                $pasing['ID_TR_TARIF'] = $row['ID_TR_TARIF'];
                $pasing['ID_TARIF'] = $row['ID_TARIF'];
                $pasing['GROUP_TARIF'] = $row['GROUP_TARIF'];
                $pasing['NILAI'] = $row['NILAI'];
                $pasing['KLSID'] = $row['KLSID'];
                $pasing['GROUP_TARIF_2'] = $row['GROUP_TARIF_2'];
                $pasing['ID_TR_TARIF_PAKET'] = $row['ID_TR_TARIF_PAKET'];
                $pasing['KD_INSTALASI'] = $row['KD_INSTALASI'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getListTransaksiTarif_Detailrad($data)
    {
        try {
            $id = $data['IdAuto'];

            $query = "SELECT * FROM RadiologiSQL.dbo.ProcedureRadiology_4
            WHERE ID_TR_TARIF=:ID";

            $this->db->query($query);
            $this->db->bind('ID', $id);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $row) {
                $pasing['ID_TR_TARIF'] = $row['ID_TR_TARIF'];
                $pasing['ID_TARIF'] = $row['ID_TARIF'];
                $pasing['GROUP_TARIF'] = $row['GROUP_TARIF'];
                $pasing['NILAI'] = $row['NILAI'];
                $pasing['KLSID'] = $row['KLSID'];
                $pasing['GROUP_TARIF_2'] = $row['GROUP_TARIF_2'];
                $pasing['ID_TR_TARIF_PAKET'] = $row['ID_TR_TARIF_PAKET'];
                $pasing['KD_INSTALASI'] = $row['KD_INSTALASI'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getListTransaksiTarif_Detailri($data)
    {
        try {
            $id = $data['IdAuto'];

            $query = "SELECT * FROM RawatInapSQL.dbo.Tarif_RI_4
            WHERE ID_TR_TARIF=:ID";

            $this->db->query($query);
            $this->db->bind('ID', $id);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $row) {
                $pasing['ID_TR_TARIF'] = $row['ID_TR_TARIF'];
                $pasing['ID_TARIF'] = $row['ID_TARIF'];
                $pasing['GROUP_TARIF'] = $row['GROUP_TARIF'];
                $pasing['NILAI'] = $row['NILAI'];
                $pasing['KLSID'] = $row['KLSID'];
                $pasing['GROUP_TARIF_2'] = $row['GROUP_TARIF_2'];
                $pasing['ID_TR_TARIF_PAKET'] = $row['ID_TR_TARIF_PAKET'];
                $pasing['KD_INSTALASI'] = $row['KD_INSTALASI'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function ImportFile($data)
    {
        try {
            $this->db->transaksi();

            $datenowcreate = Utils::seCurrentDateTime();
            $date_convert = date('Y-m-d', strtotime("-1 day", strtotime($datenowcreate)));
            $idtrs = $data['idtrs'];
            $kd_instalasi = $data['kd_instalasi'];
            $TglBerlaku = $data['TglBerlaku'];
            $TglExpired = $data['TglExpired'];

            $allowed_ext = array("csv");
            if (!isset($_FILES['file'])) {
                $callback = array(
                    'status' => 'warning', // Set array status dengan success   
                    'message' => 'File Tidak Ditemukan ! Mohon Upload File CSV !', // Set array status dengan success    
                );
                return $callback;
            }
            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $handle = fopen($_FILES['file']['tmp_name'], "r");
            fgetcsv($handle, 10000, ",");

            if (in_array($ext, $allowed_ext)) {

                while ($data = fgetcsv($handle, 1024, ';')) {
                    $data = array_map('utf8_encode', $data);
                    $num = count($data);
                    for ($c = 0; $c < $num; $c++) {
                    }

                    $col_1 = $data[0];
                    $col_2 = $data[1];
                    $col_3 = $data[2];
                    $col_4 = $data[3];
                    $col_5 = $data[4];
                    $col_6 = $data[5];
                    if($kd_instalasi == "RJ" ){
                        $this->db->query("UPDATE PerawatanSQL.dbo.Tarif_RJ_UGD_4 set  
                            TGL_EXPIRED=:date_convert
                            WHERE ID=(SELECT MAX(ID)
                        from PerawatanSQL.dbo.Tarif_RJ_UGD_4
                        WHERE ID_TARIF=:id AND GROUP_TARIF=:group_tarif AND KD_INSTALASI=:kd_instalasi)");
                        $this->db->bind('date_convert', $date_convert);
                        $this->db->bind('id', $col_1);
                        $this->db->bind('group_tarif', $col_2);
                        $this->db->bind('kd_instalasi', $kd_instalasi);
                        $this->db->execute();


                        $this->db->query("INSERT INTO PerawatanSQL.dbo.Tarif_RJ_UGD_4 (ID_TR_TARIF, ID_TARIF, GROUP_TARIF,NILAI,KLSID,GROUP_TARIF_2,ID_TR_TARIF_PAKET,KD_INSTALASI,TGL_BERLAKU,TGL_EXPIRED) VALUES (:idtrs,:col_1,:col_2,:col_3,:col_4,:col_5,:col_6,:kd_instalasi,:TglBerlaku,:TglExpired)");
                        $this->db->bind('idtrs', $idtrs); 
                        $this->db->bind('col_1', $col_1); 
                        $this->db->bind('col_2', $col_2); 
                        $this->db->bind('col_3', $col_3); 
                        $this->db->bind('col_4', $col_4); 
                        $this->db->bind('col_5', $col_5); 
                        $this->db->bind('col_6', $col_6); 
                        $this->db->bind('kd_instalasi', $kd_instalasi); 
                        $this->db->bind('TglBerlaku', $TglBerlaku); 
                        $this->db->bind('TglExpired', $TglExpired); 
                        $this->db->execute();
                    }else if($kd_instalasi == "LAB" ){
                        $this->db->query("UPDATE LaboratoriumSQL.dbo.tblGrouping_4 set  
                            TGL_EXPIRED=:date_convert
                            WHERE ID=(SELECT MAX(ID)
                        from LaboratoriumSQL.dbo.tblGrouping_4
                        WHERE ID_TARIF=:id AND GROUP_TARIF=:group_tarif AND KD_INSTALASI=:kd_instalasi)");
                        $this->db->bind('date_convert', $date_convert);
                        $this->db->bind('id', $col_1);
                        $this->db->bind('group_tarif', $col_2);
                        $this->db->bind('kd_instalasi', $kd_instalasi);
                        $this->db->execute();

                        $this->db->query("INSERT INTO LaboratoriumSQL.dbo.tblGrouping_4 (ID_TR_TARIF, ID_TARIF, GROUP_TARIF,NILAI,KLSID,GROUP_TARIF_2,ID_TR_TARIF_PAKET,KD_INSTALASI,TGL_BERLAKU,TGL_EXPIRED) VALUES (:idtrs,:col_1,:col_2,:col_3,:col_4,:col_5,:col_6,:kd_instalasi,:TglBerlaku,:TglExpired)");
                        $this->db->bind('idtrs', $idtrs); 
                        $this->db->bind('col_1', $col_1); 
                        $this->db->bind('col_2', $col_2); 
                        $this->db->bind('col_3', $col_3); 
                        $this->db->bind('col_4', $col_4); 
                        $this->db->bind('col_5', $col_5); 
                        $this->db->bind('col_6', $col_6); 
                        $this->db->bind('kd_instalasi', $kd_instalasi); 
                        $this->db->bind('TglBerlaku', $TglBerlaku); 
                        $this->db->bind('TglExpired', $TglExpired); 
                        $this->db->execute();
                    }else if($kd_instalasi == "RAD" ){
                        $this->db->query("UPDATE RadiologiSQL.dbo.ProcedureRadiology_4 set  
                        TGL_EXPIRED=:date_convert
                        WHERE ID=(SELECT MAX(ID)
                        from RadiologiSQL.dbo.ProcedureRadiology_4
                        WHERE ID_TARIF=:id AND GROUP_TARIF=:group_tarif AND KD_INSTALASI=:kd_instalasi)");
                        $this->db->bind('date_convert', $date_convert);
                        $this->db->bind('id', $col_1);
                        $this->db->bind('group_tarif', $col_2);
                        $this->db->bind('kd_instalasi', $kd_instalasi);
                        $this->db->execute();

                        $this->db->query("INSERT INTO RadiologiSQL.dbo.ProcedureRadiology_4 (ID_TR_TARIF, ID_TARIF, GROUP_TARIF,NILAI,KLSID,GROUP_TARIF_2,ID_TR_TARIF_PAKET,KD_INSTALASI,TGL_BERLAKU,TGL_EXPIRED) VALUES (:idtrs,:col_1,:col_2,:col_3,:col_4,:col_5,:col_6,:kd_instalasi,:TglBerlaku,:TglExpired)");
                        $this->db->bind('idtrs', $idtrs); 
                        $this->db->bind('col_1', $col_1); 
                        $this->db->bind('col_2', $col_2); 
                        $this->db->bind('col_3', $col_3); 
                        $this->db->bind('col_4', $col_4); 
                        $this->db->bind('col_5', $col_5); 
                        $this->db->bind('col_6', $col_6); 
                        $this->db->bind('kd_instalasi', $kd_instalasi); 
                        $this->db->bind('TglBerlaku', $TglBerlaku); 
                        $this->db->bind('TglExpired', $TglExpired); 
                        $this->db->execute();
                    }else if($kd_instalasi == "RI" ){
                        $this->db->query("UPDATE RawatInapSQL.dbo.Tarif_RI_4 set  
                        TGL_EXPIRED=:date_convert
                        WHERE ID=(SELECT MAX(ID)
                        from RawatInapSQL.dbo.Tarif_RI_4
                        WHERE ID_TARIF=:id AND GROUP_TARIF=:group_tarif AND KD_INSTALASI=:kd_instalasi)");
                        $this->db->bind('date_convert', $date_convert);
                        $this->db->bind('id', $col_1);
                        $this->db->bind('group_tarif', $col_2);
                        $this->db->bind('kd_instalasi', $kd_instalasi);
                        $this->db->execute();

                        $this->db->query("INSERT INTO RawatInapSQL.dbo.Tarif_RI_4 (ID_TR_TARIF, ID_TARIF, GROUP_TARIF,NILAI,KLSID,GROUP_TARIF_2,ID_TR_TARIF_PAKET,KD_INSTALASI,TGL_BERLAKU,TGL_EXPIRED) VALUES (:idtrs,:col_1,:col_2,:col_3,:col_4,:col_5,:col_6,:kd_instalasi,:TglBerlaku,:TglExpired)");
                        $this->db->bind('idtrs', $idtrs); 
                        $this->db->bind('col_1', $col_1); 
                        $this->db->bind('col_2', $col_2); 
                        $this->db->bind('col_3', $col_3); 
                        $this->db->bind('col_4', $col_4); 
                        $this->db->bind('col_5', $col_5); 
                        $this->db->bind('col_6', $col_6); 
                        $this->db->bind('kd_instalasi', $kd_instalasi); 
                        $this->db->bind('TglBerlaku', $TglBerlaku); 
                        $this->db->bind('TglExpired', $TglExpired); 
                        $this->db->execute();
                    }
                    
                }
            } else {
                $callback = array(
                    'status' => 'warning', // Set array status dengan success   
                    'message' => 'File Yang Support Hanya CSV !', // Set array status dengan success    
                );
                return $callback;
            }

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
    //#END TRANSAKSI TARIF

    public function getListDataTarifRajal($data)
    {
        try {

            $query = "SELECT ID,[Product Name] as NamaProduk,TarifRS,Group_Jaminan,discontinue FROM PerawatanSQL.dbo.Tarif_RJ_UGD";

            $this->db->query($query);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {
                $pasing['ID'] = $row['ID'];
                $pasing['NamaProduk'] = $row['NamaProduk'];
                $pasing['TarifRS'] = $row['TarifRS'];
                $pasing['Group_Jaminan'] = $row['Group_Jaminan'];
                $pasing['discontinue'] = $row['discontinue'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getListDataTarifRanap($data)
    {
        try {

            $query = "SELECT ID,[Product Name] as NamaProduk,Group_Jaminan,discontinue FROM RawatInapSQL.dbo.Tarif_RI";

            $this->db->query($query);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {
                $pasing['ID'] = $row['ID'];
                $pasing['NamaProduk'] = $row['NamaProduk'];
                // $pasing['TarifRS'] = $row['TarifRS'];
                $pasing['Group_Jaminan'] = $row['Group_Jaminan'];
                $pasing['discontinue'] = $row['discontinue'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getListDataTarifRadiologi($data)
    {
        try {

            $query = "SELECT ID,[Proc_Description] as NamaProduk,discontinue FROM RadiologiSQL.dbo.ProcedureRadiology";

            $this->db->query($query);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {
                $pasing['ID'] = $row['ID'];
                $pasing['NamaProduk'] = $row['NamaProduk'];
                // $pasing['TarifRS'] = $row['TarifRS'];
                // $pasing['Group_Jaminan'] = $row['Group_Jaminan'];
                $pasing['discontinue'] = $row['discontinue'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getTarifRajalbyID($data)
    {
        try {
            $IDs = $data['id'];
            $this->db->query("SELECT *
                        from PerawatanSQL.dbo.Tarif_RJ_UGD
                        WHERE ID=:id");
            $this->db->bind('id', $IDs);
            $data =  $this->db->single();
            //var_dump($data);exit;
            $pasing['ID'] = $data['ID'];
            $pasing['NamaTarif'] = $data['Product Name'];
            $pasing['CategoryProduct'] = $data['CategoryProduct'];
            $pasing['PacsOrder'] = $data['PacsOrder'];
            $pasing['discontinue'] = $data['discontinue'];
            $pasing['ProductCode'] = $data['Product Code'];
            $pasing['KD_PDP'] = $data['KD_PDP'];
            $pasing['KD_JASA'] = $data['KD_JASA'];
            $pasing['Paket'] = $data['Paket'];


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

    public function getTarifRanapbyID($data)
    {
        try {
            $IDs = $data['id'];
            $this->db->query("SELECT *
                        from RawatInapSQL.dbo.Tarif_RI
                        WHERE ID=:id");
            $this->db->bind('id', $IDs);
            $data =  $this->db->single();
            //var_dump($data);exit;
            $pasing['ID'] = $data['ID'];
            $pasing['NamaTarif'] = $data['Product Name'];
            $pasing['CategoryProduct'] = $data['CategoryProduct'];
            $pasing['PacsOrder'] = $data['PacsOrder'];
            $pasing['discontinue'] = $data['discontinue'];
            $pasing['ProductCode'] = $data['Product Code'];
            $pasing['KD_JASA'] = $data['KD_JASA'];
            $pasing['KD_PDP'] = $data['KD_PDP'];

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

    public function getTarifRadiologibyID($data)
    {
        try {
            $IDs = $data['id'];
            $this->db->query("SELECT *
                        from RadiologiSQL.dbo.ProcedureRadiology
                        WHERE ID=:id");
            $this->db->bind('id', $IDs);
            $data =  $this->db->single();
            //var_dump($data);exit;
            $pasing['ID'] = $data['ID'];
            $pasing['COGS'] = $data['COGS'];
            $pasing['PACS'] = $data['PACS'];
            $pasing['BHP'] = $data['BHP'];
            $pasing['Kontras'] = $data['Kontras'];
            $pasing['DVD'] = $data['DVD'];
            $pasing['Category'] = $data['Category'];
            $pasing['Proc_Code'] = $data['Proc_Code'];
            $pasing['Proc_Description'] = $data['Proc_Description'];
            $pasing['Modality_Code'] = $data['Modality_Code'];
            $pasing['Proc_ActionCode'] = $data['Proc_ActionCode'];
            $pasing['Proc_Instance_UID'] = $data['Proc_Instance_UID'];
            $pasing['TempReport1'] = $data['TempReport1'];
            $pasing['TempReport2'] = $data['TempReport2'];
            $pasing['TempReport3'] = $data['TempReport3'];
            $pasing['ShareDokter'] = $data['ShareDokter'];
            $pasing['ShareRS'] = $data['ShareRS'];
            $pasing['position'] = $data['position'];
            $pasing['customer_type'] = $data['customer_type'];

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

    public function saveTrs_Ranap($data)
    {
        try {
            $this->db->transaksi();
            if ($data['NamaTarif'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Nama Tarif !',
                );
                return $callback;
                exit;
            }
            if ($data['KodeProduk'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Kode Produk !',
                );
                return $callback;
                exit;
            }
            if ($data['CategoryProduct'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Category Produk !',
                );
                return $callback;
                exit;
            }

            if ($data['discontinue'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Status !',
                );
                return $callback;
                exit;
            }

            if ($data['PacsOrder'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Pacs Order !',
                );
                return $callback;
                exit;
            }

            if ($data['KodePDP'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Kode PDP !',
                );
                return $callback;
                exit;
            }

            if ($data['KodeJasa'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Kode Jasa !',
                );
                return $callback;
                exit;
            }

            if ($data['Paket'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Paket !',
                );
                return $callback;
                exit;
            }

            $IdAuto = $data['IdAuto'];
            $KodePDP = $data['KodePDP'];
            $KodeJasa = $data['KodeJasa'];
            $NamaTarif = $data['NamaTarif'];
            $KodeProduk = $data['KodeProduk'];
            $CategoryProduct = $data['CategoryProduct'];
            $discontinue = $data['discontinue'];
            $PacsOrder = $data['PacsOrder'];
            $Paket = $data['Paket'];

            if ($data['IdAuto'] == "") {
                //INSERT
                $this->db->query("INSERT INTO RawatInapSQL.dbo.Tarif_RI
                            ([Product Code],CategoryProduct,[Product Name],discontinue,PacsOrder,KD_PDP,KD_JASA,Paket)
                          values
                          ( :KodeProduk,:CategoryProduct,:NamaTarif,:discontinue,:PacsOrder,:KodePDP,:KodeJasa,:Paket)");
            } else {
                $this->db->query("UPDATE RawatInapSQL.dbo.Tarif_RI set  
                            [Product Code]=:KodeProduk,
                            CategoryProduct=:CategoryProduct,
                            [Product Name]=:NamaTarif,
                            discontinue=:discontinue,
                            PacsOrder=:PacsOrder,
                            KD_PDP=:KodePDP,
                            KD_JASA=:KodeJasa,
                            Paket=:Paket
                            WHERE ID=:IdAuto");
                $this->db->bind('IdAuto', $IdAuto);
            }

            $this->db->bind('KodeProduk', $KodeProduk);
            $this->db->bind('CategoryProduct', $CategoryProduct);
            $this->db->bind('NamaTarif', $NamaTarif);
            $this->db->bind('discontinue', $discontinue);
            $this->db->bind('PacsOrder', $PacsOrder);
            $this->db->bind('KodePDP', $KodePDP);
            $this->db->bind('KodeJasa', $KodeJasa);
            $this->db->bind('Paket', $Paket);

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

    public function saveTrs_Rajal($data)
    {
        try {
            $this->db->transaksi();
            if ($data['NamaTarif'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Nama Tarif !',
                );
                return $callback;
                exit;
            }
            if ($data['KodeProduk'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Kode Produk !',
                );
                return $callback;
                exit;
            }
            if ($data['CategoryProduct'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Category Produk !',
                );
                return $callback;
                exit;
            }

            if ($data['discontinue'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Status !',
                );
                return $callback;
                exit;
            }

            if ($data['PacsOrder'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Pacs Order !',
                );
                return $callback;
                exit;
            }

            if ($data['KodePDP'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Kode PDP !',
                );
                return $callback;
                exit;
            }

            if ($data['KodeJasa'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Kode Jasa !',
                );
                return $callback;
                exit;
            }

            if ($data['Paket'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Paket !',
                );
                return $callback;
                exit;
            }

            $IdAuto = $data['IdAuto'];
            $KodePDP = $data['KodePDP'];
            $KodeJasa = $data['KodeJasa'];
            $NamaTarif = $data['NamaTarif'];
            $KodeProduk = $data['KodeProduk'];
            $CategoryProduct = $data['CategoryProduct'];
            $discontinue = $data['discontinue'];
            $PacsOrder = $data['PacsOrder'];
            $Paket = $data['Paket'];

            if ($data['IdAuto'] == "") {
                //INSERT
                $this->db->query("INSERT INTO PerawatanSQL.dbo.Tarif_RJ_UGD
                            ([Product Code],CategoryProduct,[Product Name],discontinue,PacsOrder,KD_PDP,KD_JASA,Paket)
                          values
                          ( :KodeProduk,:CategoryProduct,:NamaTarif,:discontinue,:PacsOrder,:KodePDP,:KodeJasa,:Paket)");
            } else {
                $this->db->query("UPDATE PerawatanSQL.dbo.Tarif_RJ_UGD set  
                            [Product Code]=:KodeProduk,
                            CategoryProduct=:CategoryProduct,
                            [Product Name]=:NamaTarif,
                            discontinue=:discontinue,
                            PacsOrder=:PacsOrder,
                            KD_PDP=:KodePDP,
                            KD_JASA=:KodeJasa,
                            Paket=:Paket
                            WHERE ID=:IdAuto");
                $this->db->bind('IdAuto', $IdAuto);
            }

            $this->db->bind('KodeProduk', $KodeProduk);
            $this->db->bind('CategoryProduct', $CategoryProduct);
            $this->db->bind('NamaTarif', $NamaTarif);
            $this->db->bind('discontinue', $discontinue);
            $this->db->bind('PacsOrder', $PacsOrder);
            $this->db->bind('KodePDP', $KodePDP);
            $this->db->bind('KodeJasa', $KodeJasa);
            $this->db->bind('Paket', $Paket);

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

    public function saveTrs_Radiologi($data)
    {
        try {
            $this->db->transaksi();
            if ($data['NamaTarif'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Nama Tarif !',
                );
                return $callback;
                exit;
            }
            if ($data['KodeProduk'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Kode Produk !',
                );
                return $callback;
                exit;
            }
            if ($data['CategoryProduct'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Category Produk !',
                );
                return $callback;
                exit;
            }

            if ($data['discontinue'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Status !',
                );
                return $callback;
                exit;
            }

            if ($data['PacsOrder'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Pacs Order !',
                );
                return $callback;
                exit;
            }

            if ($data['KodePDP'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Kode PDP !',
                );
                return $callback;
                exit;
            }

            if ($data['KodeJasa'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Kode Jasa !',
                );
                return $callback;
                exit;
            }

            if ($data['Paket'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Paket !',
                );
                return $callback;
                exit;
            }

            $IdAuto = $data['IdAuto'];
            $COGS = $data['COGS'];
            $PACS = $data['PACS'];
            $BHP = $data['BHP'];
            $Kontras = $data['Kontras'];
            $DVD = $data['DVD'];
            $Category = $data['Category'];
            $Proc_Code = $data['Proc_Code'];
            $Proc_Description = $data['Proc_Description'];
            $Modality_Code = $data['Modality_Code'];
            $Proc_ActionCode = $data['Proc_ActionCode'];
            $Proc_Instance_UID = $data['Proc_Instance_UID'];
            $TempReport1 = $data['TempReport1'];
            $TempReport2 = $data['TempReport2'];
            $TempReport3 = $data['TempReport3'];
            $ShareDokter = $data['ShareDokter'];
            $ShareRS = $data['ShareRS'];
            $position = $data['position'];
            $customer_type = $data['customer_type'];


            if ($data['IdAuto'] == "") {
                //INSERT
                $this->db->query("INSERT INTO [dbo].[ProcedureRadiology]
                ([ID]
                ,[COGS]
                ,[PACS]
                ,[BHP]
                ,[Kontras]
                ,[DVD]
                ,[Category]
                ,[Proc_Code]
                ,[Proc_Description]
                ,[Modality_Code]
                ,[Proc_ActionCode]
                ,[Proc_Instance_UID]
                ,[TempReport1]
                ,[TempReport2]
                ,[TempReport3]
                ,[ShareDokter]
                ,[ShareRS]
                ,[position]
                ,[customer_type])
                          values
                          ( :ID
                ,:COGS
                ,:PACS
                ,:BHP
                ,:Kontras
                ,:DVD
                ,:Category
                ,:Proc_Code
                ,:Proc_Description
                ,:Modality_Code
                ,:Proc_ActionCode
                ,:Proc_Instance_UID
                ,:TempReport1
                ,:TempReport2
                ,:TempReport3
                ,:ShareDokter
                ,:ShareRS
                ,:position
                ,:customer_type)");
            } else {
                $this->db->query("UPDATE RadiologiSQL.dbo.ProcedureRadiology set  
                            [ID]=:ID,
                            COGS=:COGS,
                            [PACS]=:PACS,
                            BHP=:BHP,
                            Kontras=:Kontras,
                            DVD=:DVD,
                            Category=:Category,
                            Proc_Code=:Proc_Code,
                            Proc_Description=:Proc_Description,
                            Modality_Code=:Modality_Code,
                            Proc_ActionCode=:Proc_ActionCode,
                            Proc_Instance_UID=:Proc_Instance_UID,
                            TempReport1=:TempReport1,
                            TempReport2=:TempReport2,
                            TempReport3=:TempReport3,
                            ShareDokter=:ShareDokter,
                            ShareRS=:ShareRS,
                            position=:position,
                            customer_type=:customer_type
                            WHERE ID=:IdAuto");
                $this->db->bind('IdAuto', $IdAuto);
            }

            $this->db->bind('COGS', $COGS);
            $this->db->bind('PACS', $PACS);
            $this->db->bind('BHP', $BHP);
            $this->db->bind('Kontras', $Kontras);
            $this->db->bind('DVD', $DVD);
            $this->db->bind('Category', $Category);
            $this->db->bind('Proc_Code', $Proc_Code);
            $this->db->bind('Proc_Description', $Proc_Description);
            $this->db->bind('Modality_Code', $Modality_Code);
            $this->db->bind('Proc_ActionCode', $Proc_ActionCode);
            $this->db->bind('Proc_Instance_UID', $Proc_Instance_UID);
            $this->db->bind('TempReport1', $TempReport1);
            $this->db->bind('TempReport2', $TempReport2);
            $this->db->bind('TempReport3', $TempReport3);
            $this->db->bind('ShareDokter', $ShareDokter);
            $this->db->bind('ShareRS', $ShareRS);
            $this->db->bind('position', $position);
            $this->db->bind('customer_type', $customer_type);

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

    public function getListTarifRajal_Layanan($data)
    {
        try {
            $idtarif = $data['IdAuto'];
            $kd_instalasi = $data['kd_instalasi'];

            $query = "SELECT a.id,b.[Product Name],c.NamaUnit,KD_INSTALASI
             FROM PerawatanSQL.dbo.Tarif_RJ_UGD_2 a
             inner join PerawatanSQL.dbo.Tarif_RJ_UGD b on a.id_tarif=b.ID
             inner join MasterDataSQL.dbo.MstrUnitPerwatan c on a.id_layanan=c.ID
             where id_tarif=:id and KD_INSTALASI=:kd_instalasi";
            $this->db->query($query);
            $this->db->bind('id', $idtarif);
            $this->db->bind('kd_instalasi', $kd_instalasi);
            $data =  $this->db->resultSet();
            $rows = array();

            foreach ($data as $row) {
                $pasing['id'] = $row['id'];
                $pasing['ProductName'] = $row['Product Name'];
                $pasing['NamaUnit'] = $row['NamaUnit'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getListTarifRanap_Layanan($data)
    {
        try {
            $idtarif = $data['IdAuto'];
            $kd_instalasi = $data['kd_instalasi'];

            $query = "SELECT a.id,b.[Product Name],c.NamaUnit
             FROM PerawatanSQL.dbo.Tarif_RJ_UGD_2 a
             inner join RawatInapSQL.dbo.Tarif_RI b on a.id_tarif=b.ID
             inner join MasterDataSQL.dbo.MstrUnitPerwatan c on a.id_layanan=c.ID
             where id_tarif=:id and KD_INSTALASI=:kd_instalasi";
            $this->db->query($query);
            $this->db->bind('id', $idtarif);
            $this->db->bind('kd_instalasi', $kd_instalasi);
            $data =  $this->db->resultSet();
            $rows = array();

            foreach ($data as $row) {
                $pasing['id'] = $row['id'];
                $pasing['ProductName'] = $row['Product Name'];
                $pasing['NamaUnit'] = $row['NamaUnit'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getListTarifRadiologi_Layanan($data)
    {
        try {
            $idtarif = $data['IdAuto'];
            $kd_instalasi = $data['kd_instalasi'];

            $query = "SELECT a.id,b.[COGS],c.NamaUnit
             FROM PerawatanSQL.dbo.Tarif_RJ_UGD_2 a
             inner join RadiologiSQL.dbo.ProcedureRadiology b on a.id_tarif=b.ID
             inner join MasterDataSQL.dbo.MstrUnitPerwatan c on a.id_layanan=c.ID
             where id_tarif=:id and KD_INSTALASI=:kd_instalasi";
            $this->db->query($query);
            $this->db->bind('id', $idtarif);
            $this->db->bind('kd_instalasi', $kd_instalasi);
            $data =  $this->db->resultSet();
            $rows = array();

            foreach ($data as $row) {
                $pasing['id'] = $row['id'];
                $pasing['ProductName'] = $row['Product Name'];
                $pasing['NamaUnit'] = $row['NamaUnit'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    public function addTarifLayanan($data)
    {
        try {
            $this->db->transaksi();

            if ($data['IdAuto'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'ID Tarif Tidak Ditemukan! Mohon Isi Data General Info Terlebih Dahulu!',
                );
                return $callback;
                exit;
            }

            if ($data['GrupPerawatan'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Layanan!',
                );
                return $callback;
                exit;
            }

            $IdAuto = $data['IdAuto'];
            $GrupPerawatan = $data['GrupPerawatan'];
            $kd_instalasi = $data['kd_instalasi'];

            $this->db->query("SELECT id_tarif from PerawatanSQL.dbo.Tarif_RJ_UGD_2 
                                where id_tarif=:IdAuto and id_layanan=:GrupPerawatan and KD_INSTALASI=:kd_instalasi");
            $this->db->bind('IdAuto', $IdAuto);
            $this->db->bind('GrupPerawatan', $GrupPerawatan);
            $this->db->bind('kd_instalasi', $kd_instalasi);
            $data =  $this->db->resultSet();
            if (count($data) > 0) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Sudah Ada Layanan Tersebut!',
                );
                return $callback;
                exit;
            }

            $this->db->query("INSERT INTO PerawatanSQL.dbo.Tarif_RJ_UGD_2 (id_tarif,id_layanan,KD_INSTALASI) VALUES
                  (:IdAuto,:GrupPerawatan,:kd_instalasi)");

            $this->db->bind('IdAuto', $IdAuto);
            $this->db->bind('GrupPerawatan', $GrupPerawatan);
            $this->db->bind('kd_instalasi', $kd_instalasi);

            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'IdDoctors' => $IdAuto, // Set array status dengan success  
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function deleteTarifLayanan($id)
    {
        try {
            $this->db->transaksi();


            $this->db->query("DELETE PerawatanSQL.dbo.Tarif_RJ_UGD_2
                                      WHERE ID=:id");
            $this->db->bind('id', $id);

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

    public function getListTarifRajal_Histori($data)
    {
        try {
            $idtarif = $data['IdAuto'];
            $kd_instalasi = $data['kd_instalasi'];
            
            $query = "SELECT b.ID_TR_TARIF,GROUP_TARIF,NILAI,KLSID,GROUP_TARIF_2,ID_TR_TARIF_PAKET,
            replace(CONVERT(VARCHAR(11), a.TGL_BERLAKU, 111), '/','-') as tglberlaku,
            replace(CONVERT(VARCHAR(11), a.TGL_EXPIRED, 111), '/','-') as tglexpired,
            replace(CONVERT(VARCHAR(11), a.TGL_ENTRY, 111), '/','-') as tglentry
            from PerawatanSQL.dbo.Tarif_RJ_UGD_3 a
            inner join PerawatanSQL.dbo.Tarif_RJ_UGD_4 b on a.ID_TR_TARIF=b.ID_TR_TARIF
            where b.ID_TARIF=:id and b.KD_INSTALASI=:kd_instalasi
            order by TGL_ENTRY desc";
            $this->db->query($query);
            $this->db->bind('id', $idtarif);
            $this->db->bind('kd_instalasi', $kd_instalasi);
            $data =  $this->db->resultSet();
            $rows = array();

            foreach ($data as $row) {
                $pasing['ID_TR_TARIF'] = $row['ID_TR_TARIF'];
                $pasing['GROUP_TARIF'] = $row['GROUP_TARIF'];
                $pasing['NILAI'] = $row['NILAI'];
                $pasing['KLSID'] = $row['KLSID'];
                $pasing['GROUP_TARIF_2'] = $row['GROUP_TARIF_2'];
                $pasing['ID_TR_TARIF_PAKET'] = $row['ID_TR_TARIF_PAKET'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getListTarifRanap_Histori($data)
    {
        try {
            $idtarif = $data['IdAuto'];
            $kd_instalasi = $data['kd_instalasi'];

            $query = "SELECT b.ID_TR_TARIF,GROUP_TARIF,NILAI,KLSID,GROUP_TARIF_2,ID_TR_TARIF_PAKET,replace(CONVERT(VARCHAR(11), a.TGL_BERLAKU, 111), '/','-') as tglberlaku,
            replace(CONVERT(VARCHAR(11), a.TGL_EXPIRED, 111), '/','-') as tglexpired,
            replace(CONVERT(VARCHAR(11), a.TGL_ENTRY, 111), '/','-') as tglentry from PerawatanSQL.dbo.Tarif_RJ_UGD_3 a
            inner join PerawatanSQL.dbo.Tarif_RJ_UGD_4 b on a.ID_TR_TARIF=b.ID_TR_TARIF
            where b.ID_TARIF=:id and b.KD_INSTALASI=:kd_instalasi";
            $this->db->query($query);
            $this->db->bind('id', $idtarif);
            $this->db->bind('kd_instalasi', $kd_instalasi);
            $data =  $this->db->resultSet();
            $rows = array();

            foreach ($data as $row) {
                $pasing['ID_TR_TARIF'] = $row['ID_TR_TARIF'];
                $pasing['tglberlaku'] = $row['tglberlaku'];
                $pasing['tglexpired'] = $row['tglexpired'];
                $pasing['tglentry'] = $row['tglentry'];
                $pasing['GROUP_TARIF'] = $row['GROUP_TARIF'];
                $pasing['NILAI'] = $row['NILAI'];
                $pasing['KLSID'] = $row['KLSID'];
                $pasing['GROUP_TARIF_2'] = $row['GROUP_TARIF_2'];
                $pasing['ID_TR_TARIF_PAKET'] = $row['ID_TR_TARIF_PAKET'];
                $pasing['tglberlaku'] = $row['tglberlaku'];
                $pasing['tglexpired'] = $row['tglexpired'];
                $pasing['tglentry'] = $row['tglentry'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    //LAB
    public function getListDataTarifLab($data)
    {
        try {
            
            $query = "SELECT IDTes,NamaTes as NamaProduk,Group_Jaminan,Discontinue,KodeTes,KodeKelompok FROM LaboratoriumSQL.dbo.tblGrouping where InLevel='1' order by KodeKelompok desc";

            $this->db->query($query);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {
                $pasing['IDTes'] = $row['IDTes'];
                $pasing['KodeTes'] = $row['KodeTes'];
                $pasing['KodeKelompok'] = $row['KodeKelompok'];
                $pasing['NamaProduk'] = $row['NamaProduk'];
                $pasing['Group_Jaminan'] = $row['Group_Jaminan']; 
                $pasing['discontinue'] = $row['Discontinue']; 
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getTarifLabbyID($data)
    {
        try{
            $IDs = $data['id'];
            $this->db->query("SELECT IDTes,NamaTes,Discontinue,KodeTes,KodeKelompok ,pcr,KD_PDP,KD_JASA,InLevel,IDGroup
                        from LaboratoriumSQL.dbo.tblGrouping
                        WHERE IDTes=:id");
            $this->db->bind('id', $IDs);
            $data =  $this->db->single();
            
            $pasing['IDTes'] = $data['IDTes'];
            $pasing['KodeTes'] = $data['KodeTes'];
            $pasing['KodeKelompok'] = $data['KodeKelompok'];
            $pasing['NamaTes'] = $data['NamaTes'];
            $pasing['Discontinue'] = $data['Discontinue'];
            $pasing['pcr'] = $data['pcr'];
            $pasing['KD_PDP'] = $data['KD_PDP'];
            $pasing['KD_JASA'] = $data['KD_JASA'];
            $pasing['InLevel'] = $data['InLevel'];
            $pasing['IDGroup'] = $data['IDGroup'];

           
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

    public function getKodeTes()
    {
        try {
            $this->db->query("SELECT KodeTes,NamaTes from LaboratoriumSQL.dbo.tblTestLab order by NamaTes asc");
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['KodeTes'] = $key['KodeTes'];
                $pasing['NamaTes'] = $key['NamaTes'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getKodeTesbyID($data)
    {
        try{
            $IDs = $data['id'];
            $this->db->query("SELECT KodeTes,NamaTes,KodeKelompok from LaboratoriumSQL.dbo.tblTestLab
                        WHERE KodeTes=:id");
            $this->db->bind('id', $IDs);
            $data =  $this->db->single();
            
            $pasing['KodeTes'] = $data['KodeTes'];
            $pasing['KodeKelompok'] = $data['KodeKelompok'];
            $pasing['NamaTes'] = $data['NamaTes'];

           
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

    public function saveTrs_Lab($data)
    {
        try {
            $this->db->transaksi();
            if ($data['NamaTarif'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Nama Tarif Kosong !',
                );
                return $callback;
                exit;
            }
            if ($data['KodeTes'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Kode Tes !',
                );
                return $callback;
                exit;
                
            }
            if ($data['KodeKelompok'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode Kelompok Kosong!',
                );
                return $callback;
                exit;
            }

            if ($data['discontinue'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Status !',
                );
                return $callback;
                exit;
            }

            if ($data['FlagPCR'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Pacs Order !',
                );
                return $callback;
                exit;
            }

            if ($data['KodePDP'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Kode PDP !',
                );
                return $callback;
                exit;
            }

            if ($data['KodeJasa'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Kode Jasa !',
                );
                return $callback;
                exit;
            }

            $IdAuto = $data['IdAuto'];
            $KodePDP = $data['KodePDP'];
            $KodeTes = $data['KodeTes'];
            $KodeJasa = $data['KodeJasa'];
            $NamaTarif = $data['NamaTarif'];
            $KodeKelompok = $data['KodeKelompok'];
            $discontinue = $data['discontinue'];
            $FlagPCR = $data['FlagPCR'];
            $InLevel = $data['InLevel'];

            if($data['IDGroup'] == '' || $data['IDGroup'] == null){
                $IDGroup = null;
            }else{
                $IDGroup = $data['IDGroup'];
            }

            if ($data['IdAuto'] == "") {
                //INSERT
                    $this->db->query("INSERT INTO LaboratoriumSQL.dbo.tblGrouping
                            (InLevel,IDGroup,KodeKelompok,KodeTes,NamaTes,pcr,Discontinue,KD_PDP,KD_JASA)
                          values
                          ( :InLevel,:IDGroup,:KodeKelompok,:KodeTes,:NamaTarif,:FlagPCR,:discontinue,:KodePDP,:KodeJasa)");
                    
            } else {
                $this->db->query("UPDATE LaboratoriumSQL.dbo.tblGrouping set  
                            InLevel=:InLevel,
                            IDGroup=:IDGroup,
                            KodeKelompok=:KodeKelompok,
                            KodeTes=:KodeTes,
                            NamaTes=:NamaTarif,
                            pcr=:FlagPCR,
                            Discontinue=:discontinue,
                            KD_PDP=:KodePDP,
                            KD_JASA=:KodeJasa
                            WHERE IDTes=:IdAuto");
                $this->db->bind('IdAuto', $IdAuto); 
            }
            $this->db->bind('KodeKelompok', $KodeKelompok);
            $this->db->bind('KodeTes', $KodeTes);
            $this->db->bind('NamaTarif', $NamaTarif);
            $this->db->bind('InLevel', $InLevel);
            $this->db->bind('IDGroup', $IDGroup);
            $this->db->bind('FlagPCR', $FlagPCR);
            $this->db->bind('discontinue', $discontinue);
            $this->db->bind('KodePDP', $KodePDP);
            $this->db->bind('KodeJasa', $KodeJasa);

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

    //MASTER TINDAKAN LAB
    public function getListDataTindakanLab($data)
    {
        try {
            
            $query = "SELECT * FROM LaboratoriumSQL.dbo.tblTestLab order by 1 asc";

            $this->db->query($query);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $row) {
                $pasing['KodeTes'] = $row['KodeTes'];
                $pasing['KodeKelompok'] = $row['KodeKelompok'];
                $pasing['NamaTes'] = $row['NamaTes'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getTindakanLabbyID($data)
    {
        try{
            $IDs = $data['id'];
            $this->db->query("SELECT *
                        from LaboratoriumSQL.dbo.tblTestLab
                        WHERE KodeTes=:id");
            $this->db->bind('id', $IDs);
            $data =  $this->db->single();
            
            $pasing['KodeTes'] = $data['KodeTes'];
            $pasing['KodeKelompok'] = $data['KodeKelompok'];
            $pasing['KodeAlat'] = $data['KodeAlat'];
            $pasing['NamaTes'] = $data['NamaTes'];
            $pasing['NamaTes1'] = $data['NamaTes1'];
            $pasing['Jenis'] = $data['Jenis'];
            $pasing['JenisSample'] = $data['JenisSample'];
            $pasing['Satuan'] = $data['Satuan'];
            $pasing['Satuan1'] = $data['Satuan1'];
            $pasing['Kelompok'] = $data['Kelompok'];
            $pasing['Hasil'] = $data['Hasil'];

            $pasing['L60_LP'] = $data['L60_LP'];
            $pasing['L60_DIGIT'] = $data['L60_DIGIT'];
            $pasing['Currency'] = $data['Currency'];
            $pasing['JenisHsl'] = $data['JenisHsl'];
            $pasing['Pecahan'] = $data['Pecahan'];
            $pasing['ExtenNR'] = $data['ExtenNR'];
            $pasing['Header'] = $data['Header'];
            $pasing['TempHasilM'] = $data['TempHasilM'];

           
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

    public function saveTrsTindakan_Lab($data)
    {
        try {
            $this->db->transaksi();
            if ($data['KodeKelompok'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode Kelompok Kosong !',
                );
                return $callback;
                exit;
            }
            if ($data['NamaTes'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Nama Tes Kosong !',
                );
                return $callback;
                exit;
            }

            $IdAuto = $data['IdAuto'];
            $KodeKelompok = $data['KodeKelompok'];
            $KodeAlat = $data['KodeAlat'];
            $NamaTes = $data['NamaTes'];
            $NamaTes1 = $data['NamaTes1'];
            $Jenis = $data['Jenis'];
            $JenisSample = $data['JenisSample'];
            $Satuan = $data['Satuan'];
            //$Satuan1 = $data['Satuan1'];
            $Kelompok = $data['Kelompok'];
            $Hasil = $data['Hasil'];
            $L60_LP = $data['L60_LP'];
            $L60_DIGIT = $data['L60_DIGIT'];
            $Currency = $data['Currency'];
            $JenisHsl = $data['JenisHsl'];
            $Pecahan = $data['Pecahan'];
            $ExtenNR = $data['ExtenNR'];
            $Header = $data['Header'];
            $TempHasilM = $data['TempHasilM'];

            if ($data['IdAuto'] == "") {
                //INSERT
                    $this->db->query("INSERT INTO LaboratoriumSQL.dbo.tblTestLab
                            ([KodeKelompok]
                            ,[KodeAlat]
                            ,[NamaTes]
                            ,[NamaTes1]
                            ,[Jenis]
                            ,[JenisSample]
                            ,[Satuan]
                            ,[Kelompok]
                            ,[Hasil]
                            ,[L60_LP]
                            ,[L60_DIGIT]
                            ,[Currency]
                            ,[JenisHsl]
                            ,[Pecahan]
                            ,[ExtenNR]
                            ,[Header]
                            ,[TempHasilM])
                          values
                          ( :KodeKelompok,
                          :KodeAlat,
                          :NamaTes,
                          :NamaTes1,
                          :Jenis,
                          :JenisSample,
                          :Satuan,
                          :Kelompok,
                          :Hasil,
                          :L60_LP,
                          :L60_DIGIT,
                          :Currency,
                          :JenisHsl,
                          :Pecahan,
                          :ExtenNR,
                          :Header,
                          :TempHasilM
                          )");
                    
            } else {
                $this->db->query("UPDATE LaboratoriumSQL.dbo.tblTestLab set  
                            [KodeKelompok] =:KodeKelompok
                            ,[KodeAlat] =:KodeAlat
                            ,[NamaTes] =:NamaTes
                            ,[NamaTes1] =:NamaTes1
                            ,[Jenis] =:Jenis
                            ,[JenisSample] =:JenisSample
                            ,[Satuan] =:Satuan
                            ,[Kelompok] =:Kelompok
                            ,[Hasil] =:Hasil
                            ,[L60_LP] =:L60_LP
                            ,[L60_DIGIT] =:L60_DIGIT
                            ,[Currency] =:Currency
                            ,[JenisHsl] =:JenisHsl
                            ,[Pecahan] =:Pecahan
                            ,[ExtenNR] =:ExtenNR
                            ,[Header] = :Header
                            ,[TempHasilM] =:TempHasilM
                            WHERE KodeTes=:IdAuto");
                $this->db->bind('IdAuto', $IdAuto); 
            }

            $this->db->bind('KodeKelompok', $KodeKelompok);
            $this->db->bind('KodeAlat', $KodeAlat);
            $this->db->bind('NamaTes', $NamaTes);
            $this->db->bind('NamaTes1', $NamaTes1);
            $this->db->bind('Jenis', $Jenis);
            $this->db->bind('JenisSample', $JenisSample);
            $this->db->bind('Satuan', $Satuan);
            $this->db->bind('Kelompok', $Kelompok);
            $this->db->bind('Hasil', $Hasil);
            $this->db->bind('L60_LP', $L60_LP);
            $this->db->bind('L60_DIGIT', $L60_DIGIT);
            $this->db->bind('Currency', $Currency);
            $this->db->bind('JenisHsl', $JenisHsl);
            $this->db->bind('Pecahan', $Pecahan);
            $this->db->bind('ExtenNR', $ExtenNR);
            $this->db->bind('Header', $Header);
            $this->db->bind('TempHasilM', $TempHasilM);

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

    public function getListTindakanLab_NilaiRujukan($data)
    {
        try {
            $id = $data['IdAuto'];
            
            $query = "SELECT a.*,b.NamaParameter FROM LaboratoriumSQL.dbo.tblLabHasilRujukan a
            inner join LaboratoriumSQL.dbo.tblParameterLab b on a.PAID=b.PAID
             where KodeTes=:id ";
            $this->db->query($query);
            $this->db->bind('id', $id);
            $data =  $this->db->resultSet();
            $rows = array();
            
            foreach ($data as $row) {
                $pasing['RecordID'] = $row['RecordID'];
                $pasing['ParameterUsia'] = $row['NamaParameter'];
                $pasing['U1'] = $row['U1'];
                $pasing['U2'] = $row['U2'];
                $pasing['G'] = $row['G'];
                $pasing['JenisSample'] = $row['JenisSample'];
                $pasing['NilaiRujukanAwal'] = $row['NilaiRujukanAwal'];
                $pasing['NilaiRujukanAkhir'] = $row['NilaiRujukanAkhir'];
                $pasing['SatuanRujukan'] = $row['SatuanRujukan'];
                $pasing['NilaiRujukanTeks'] = $row['NilaiRujukanTeks'];
                $pasing['BatasAtas'] = $row['BatasAtas'];
                $pasing['BatasBawah'] = $row['BatasBawah'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function deleteLabRujukan($id)
    {
        try {
            $this->db->transaksi();


                    $this->db->query("DELETE LaboratoriumSQL.dbo.tblLabHasilRujukan
                                      WHERE RecordID=:id");
                    $this->db->bind('id', $id);

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

    public function getDataDetailbyID($data)
    {
        try{
            $IDs = $data['id'];
            $this->db->query("SELECT *
                        from LaboratoriumSQL.dbo.tblLabHasilRujukan
                        WHERE RecordID=:id");
            $this->db->bind('id', $IDs);
            $row =  $this->db->single();
            
            $pasing['RecordID'] = $row['RecordID'];
            $pasing['KodeTes'] = $row['KodeTes'];
            $pasing['ParameterUsia'] = $row['ParameterUsia'];
            $pasing['U1'] = $row['U1'];
            $pasing['U2'] = $row['U2'];
            $pasing['G'] = $row['G'];
            $pasing['JenisSample'] = $row['JenisSample'];
            $pasing['NilaiRujukanAwal'] = $row['NilaiRujukanAwal'];
            $pasing['NilaiRujukanAkhir'] = $row['NilaiRujukanAkhir'];
            $pasing['SatuanRujukan'] = $row['SatuanRujukan'];
            $pasing['NilaiRujukanTeks'] = $row['NilaiRujukanTeks'];
            $pasing['BatasAtas'] = $row['BatasAtas'];
            $pasing['BatasBawah'] = $row['BatasBawah'];

           
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

    public function getParameterUsia()
    {
        try {
            $this->db->query("SELECT * from LaboratoriumSQL.dbo.tblParameterLab order by 1 asc");
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['PAID'] = $key['PAID'];
                $pasing['NamaParameter'] = $key['NamaParameter'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getListTarifRadiologi_Histori($data)
    {
        try {
            $idtarif = $data['IdAuto'];
            $kd_instalasi = $data['kd_instalasi'];

            $query = "SELECT b.ID_TR_TARIF,GROUP_TARIF,NILAI,KLSID,GROUP_TARIF_2,ID_TR_TARIF_PAKET,replace(CONVERT(VARCHAR(11), a.TGL_BERLAKU, 111), '/','-') as tglberlaku,
            replace(CONVERT(VARCHAR(11), a.TGL_EXPIRED, 111), '/','-') as tglexpired,
            replace(CONVERT(VARCHAR(11), a.TGL_ENTRY, 111), '/','-') as tglentry from PerawatanSQL.dbo.Tarif_RJ_UGD_3 a
            inner join PerawatanSQL.dbo.Tarif_RJ_UGD_4 b on a.ID_TR_TARIF=b.ID_TR_TARIF
            where b.ID_TARIF=:id and b.KD_INSTALASI=:kd_instalasi";
            $this->db->query($query);
            $this->db->bind('id', $idtarif);
            $this->db->bind('kd_instalasi', $kd_instalasi);
            $data =  $this->db->resultSet();
            $rows = array();

            foreach ($data as $row) {
                $pasing['ID_TR_TARIF'] = $row['ID_TR_TARIF'];
                $pasing['tglberlaku'] = $row['tglberlaku'];
                $pasing['tglexpired'] = $row['tglexpired'];
                $pasing['tglentry'] = $row['tglentry'];
                $pasing['GROUP_TARIF'] = $row['GROUP_TARIF'];
                $pasing['NILAI'] = $row['NILAI'];
                $pasing['KLSID'] = $row['KLSID'];
                $pasing['GROUP_TARIF_2'] = $row['GROUP_TARIF_2'];
                $pasing['ID_TR_TARIF_PAKET'] = $row['ID_TR_TARIF_PAKET'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function addNilaiRujukan($data)
    {
        try {
            $this->db->transaksi();

            $IdAuto_Detail = $data['IdAuto_detail'];
            $KodeTesDetail = $data['KodeTesDetail'];
            $ParameterLab = $data['ParameterLab'];
            $U1 = $data['U1'];
            $U2 = $data['U2'];
            $G = $data['G'];
            $JenisSample_Detail = $data['JenisSample_Detail'];
            $NRAwal = $data['NRAwal'];
            $NRAkhir = $data['NRAkhir'];
            $SatuanRujukan_Detail = $data['SatuanRujukan_Detail'];
            $Catatan = $data['Catatan'];
            $BatasAtas = $data['BatasAtas'];
            $BatasBawah = $data['BatasBawah'];

            if($IdAuto_Detail == ''){
                $this->db->query("INSERT INTO LaboratoriumSQL.[dbo].[tblLabHasilRujukan] (
                [KodeTes]
                ,[PAID]
                ,[ParameterUsia]
                ,[U1]
                ,[U2]
                ,[G]
                ,[JenisSample]
                ,[NilaiRujukanAwal]
                ,[NilaiRujukanAkhir]
                ,[SatuanRujukan]
                ,[NilaiRujukanTeks]
                ,[BatasAtas]
                ,[BatasBawah]) 
                VALUES
                  (
                  :KodeTesDetail,
                  :ParameterLab,
                  :ParameterLab2,
                  :U1,
                  :U2,
                  :G,
                  :JenisSample_Detail,
                  :NRAwal,
                  :NRAkhir,
                  :SatuanRujukan_Detail,
                  :Catatan,
                  :BatasAtas,
                  :BatasBawah
                  )");
                    

            }else{
                $this->db->query("UPDATE LaboratoriumSQL.[dbo].[tblLabHasilRujukan]
                SET [KodeTes] =:KodeTesDetail
                   ,[PAID] =:ParameterLab
                   ,[ParameterUsia] = :ParameterLab2
                   ,[U1] =:U1
                   ,[U2] = :U2
                   ,[G] =:G
                   ,[JenisSample] =:JenisSample_Detail
                   ,[NilaiRujukanAwal] =:NRAwal
                   ,[NilaiRujukanAkhir] =:NRAkhir
                   ,[SatuanRujukan] =:SatuanRujukan_Detail
                   ,[NilaiRujukanTeks] =:Catatan
                   ,[BatasAtas] =:BatasAtas
                   ,[BatasBawah] =:BatasBawah
                            WHERE RecordID=:IdAuto");
                $this->db->bind('IdAuto', $IdAuto_Detail); 

            }
                    $this->db->bind('KodeTesDetail', $KodeTesDetail);
                    $this->db->bind('ParameterLab', $ParameterLab);
                    $this->db->bind('ParameterLab2', $ParameterLab);
                    $this->db->bind('U1', $U1);
                    $this->db->bind('U2', $U2);
                    $this->db->bind('G', $G);
                    $this->db->bind('JenisSample_Detail', $JenisSample_Detail);
                    $this->db->bind('NRAwal', $NRAwal);
                    $this->db->bind('NRAkhir', $NRAkhir);
                    $this->db->bind('SatuanRujukan_Detail', $SatuanRujukan_Detail);
                    $this->db->bind('Catatan', $Catatan);
                    $this->db->bind('BatasAtas', $BatasAtas);
                    $this->db->bind('BatasBawah', $BatasBawah);

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
