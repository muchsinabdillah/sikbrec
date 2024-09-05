<?php
class  B_Udd_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getListResepRanap($data)
    {
        try {
            $jenisPencarian = $data['jenisPencarian'];
            $txSearchData = $data['txSearchData'];
            if($jenisPencarian=="1"){
                $this->db->query("SELECT TOP 100  a.[Order ID] as NoOrder, a.[Employee ID], a.[Customer ID], 
                                a.[Order Date] as TglOrder,   b.PatientName AS PatientName, b.NoMR,
                                a.[Status ID] , a.NoEpisode, a.NoResep, a.NoRegistrasi, c.StatusID, 
                                c.Class, c.RoomName, c.Bed, c.NamaDokter, JenisResep, 
                                c.paket_operasi, asalResep 
                                FROM [Apotik_V1.1SQL].DBO.Orders A
                                INNER JOIN MasterdataSQL.DBO.Admision B
                                ON A.[Customer ID] = B.ID
                                INNER JOIN RawatInapSQL.DBO.View_PasienRawat C
                                ON C.NOREGRI = A.NoRegistrasi
                                where a.[Status ID] < 4 and c.StatusID < 4 and a.JenisResep not like 'BHP'
                                and b.PatientName like '%$txSearchData%' ");
                // $this->db->bind('nama', $txSearchData);
            }else{
                $this->db->query("SELECT TOP 100  a.[Order ID] as NoOrder, a.[Employee ID], a.[Customer ID], 
                                a.[Order Date] as TglOrder,   b.PatientName AS PatientName, b.NoMR,
                                a.[Status ID] , a.NoEpisode, a.NoResep, a.NoRegistrasi, c.StatusID, 
                                c.Class, c.RoomName, c.Bed, c.NamaDokter, JenisResep, 
                                c.paket_operasi, asalResep 
                                FROM [Apotik_V1.1SQL].DBO.Orders A
                                INNER JOIN MasterdataSQL.DBO.Admision B
                                ON A.[Customer ID] = B.ID
                                INNER JOIN RawatInapSQL.DBO.View_PasienRawat C
                                ON C.NOREGRI = A.NoRegistrasi
                                where a.[Status ID] < 4 and c.StatusID < 4 and a.JenisResep not like 'BHP'
                                and  a.[Order ID] = :noResep ");
                $this->db->bind('noResep', $txSearchData);
            }
                
            $data =  $this->db->resultSet();
            $rows = array();
            
            return $data;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getListResepRanapSingle($data)
    {
        try {
            $Udd_No_Resep = $data['Udd_No_Resep'];
            $this->db->query("SELECT TOP 100  a.[Order ID] as orderid, a.[Employee ID], a.[Customer ID], 
                    a.[Order Date] ,   b.PatientName AS PatientName, b.NoMR,
                    a.[Status ID] , a.NoEpisode, a.NoResep, a.NoRegistrasi, c.StatusID, 
                    c.Class, c.RoomName, c.Bed, c.NamaDokter, JenisResep, 
                    c.paket_operasi, asalResep ,
                    b.Gander,replace(CONVERT(VARCHAR(11), b.Date_of_birth, 111), '/','-')  as Date_of_birth
                    ,DATEDIFF(YEAR,replace(CONVERT(VARCHAR(11), b.Date_of_birth, 111), '/','-'),replace(CONVERT(VARCHAR(11), A.[Order Date], 111), '/','-')) as Usia
                    ,CASE WHEN  b.Gander = 'L' THEN 'LAKI-LAKI' WHEN b.Gander = 'P' THEN 'PEREMPUAN' END AS JKEL
                    FROM [Apotik_V1.1SQL].DBO.Orders A
                    INNER JOIN MasterdataSQL.DBO.Admision B
                    ON A.[Customer ID] = B.ID
                    INNER JOIN RawatInapSQL.DBO.View_PasienRawat C
                    ON C.NOREGRI = A.NoRegistrasi
                    where  a.[Order ID] =:Udd_No_Resep");
            $this->db->bind('Udd_No_Resep', $Udd_No_Resep);
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success',
                'orderid' => $data['orderid'],
                'PatientName' => $data['PatientName'],
                'NoMR' => $data['NoMR'],
                'NoEpisode' => $data['NoEpisode'],
                'NoResep' => $data['NoResep'],
                'NoRegistrasi' => $data['NoRegistrasi'],
                'Class' => $data['Class'],
                'RoomName' => $data['RoomName'],
                'Bed' => $data['Bed'],
                'NamaDokter' => $data['NamaDokter'],
                'JenisResep' => $data['JenisResep'],
                'Gander' => $data['Gander'],
                'JKEL' => $data['JKEL'],
                'Date_of_birth' => $data['Date_of_birth'],
                'Usia' => $data['Usia'], 
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
    public function CreateHeaderUdd($data){
        try {
            $this->db->transaksi();

            if ($data['Udd_No_Resep'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input No. Resep !',
                );
                return $callback;
                exit;
            }

            if ($data['slcWaktu'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Waktu Pemberian !',
                );
                return $callback;
                exit;
            }

            if ($data['slcWaktuTgl'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Waktu Tgl Pemberian !',
                );
                return $callback;
                exit;
            }

            if ($data['slcWaktuJam'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Waktu Jam Pemberian !',
                );
                return $callback;
                exit;
            }

            $IdAuto = $data['IdTransaksi'];
            $Udd_No_Resep = $data['Udd_No_Resep'];
            $Udd_PasienIdJKel = $data['Udd_PasienIdJKel'];
            $Udd_NoEpisode = $data['Udd_NoEpisode'];
            $Udd_No_Registrasi = $data['Udd_No_Registrasi'];
            $Udd_NOMR = $data['Udd_NOMR'];
            $Udd_JenisResep = $data['Udd_JenisResep'];
            $slcWaktu = $data['slcWaktu'];
            $Udd_Dokter = $data['Udd_Dokter'];
            $slcWaktuTgl = $data['slcWaktuTgl'];
            $slcWaktuJam = $data['slcWaktuJam']; 
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $TGLENTRI = Utils::seCurrentDateTime();
            $ID_DOKTER = "";
            

                $this->db->query("INSERT INTO [Apotik_V1.1SQL].DBO.UDD_HDR 
                                (ID_RESEP,NO_EPISODE,NO_REGISTRASI,NO_MR,
                                J_KEL,ID_DOKTER,NAMA_DOKTER,TGL_DIBERIKAN,JAM_DIBERIKAN
                                ,USER_ENTRI,TGL_ENTRY,JENIS_RESEP,WAKTU_DIBERIKAN) VALUES
                                (:ID_RESEP,:NO_EPISODE,:NO_REGISTRASI,:NO_MR
                                ,:J_KEL,:ID_DOKTER,:NAMA_DOKTER,:TGL_DIBERIKAN,:JAM_DIBERIKAN
                                ,:USER_ENTRI,:TGL_ENTRY,:JENIS_RESEP,:WAKTU_DIBERIKAN)");
                $this->db->bind('ID_RESEP', $Udd_No_Resep);
                $this->db->bind('NO_EPISODE', $Udd_NoEpisode);
                $this->db->bind('NO_REGISTRASI', $Udd_No_Registrasi); 
                $this->db->bind('NO_MR', $Udd_NOMR);
                $this->db->bind('J_KEL', $Udd_PasienIdJKel);
                $this->db->bind('ID_DOKTER', $ID_DOKTER);
                
                $this->db->bind('NAMA_DOKTER', $Udd_Dokter);
                
                $this->db->bind('TGL_DIBERIKAN', $slcWaktuTgl);
                $this->db->bind('JAM_DIBERIKAN', $slcWaktuJam);
                $this->db->bind('USER_ENTRI', $namauserx);
                $this->db->bind('TGL_ENTRY', $TGLENTRI); 
                $this->db->bind('JENIS_RESEP', $Udd_JenisResep);    
                $this->db->bind('WAKTU_DIBERIKAN', $slcWaktu);
             
            $this->db->execute();
            $this->db->commit();
            $last = $this->db->GetLastID();
            $this->db->closeCon();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success 
                'id' => $last   
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function getListResepDetilByNoresep($data)
    {
        try {
            $Noresep = $data['Udd_No_Resep'];  
                $this->db->query(" SELECT B.[Product ID] AS KodeBarang,C.[Product Name] AS NAMAOBAT, B.QtyRealisasi
                                FROM [Apotik_V1.1SQL].DBO.Orders A
                                INNER JOIN [Apotik_V1.1SQL].dbo.[Order Details] B
                                ON  a.[Order ID] =  B.[Order ID]
                                inner join [Apotik_V1.1SQL].dbo.Products c
                                on c.id = b.[Product ID]
                                WHERE  a.[Order ID]=:Noresep ");
                $this->db->bind('Noresep', $Noresep); 
            $data =  $this->db->resultSet();
            $rows = array();

            return $data;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function CreateDetilUdd($data)
    {
        try {
            $this->db->transaksi();

            if ($data['IdTransaksi'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input No. Transaksi !',
                );
                return $callback;
                exit;
            }

            if ($data['slcDataObat'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Data Obat !',
                );
                return $callback;
                exit;
            }

            if ($data['Udd_Qty'] == "" || $data['Udd_Qty'] == "0") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Data Qty !',
                );
                return $callback;
                exit;
            }


            $IdTransaksi = $data['IdTransaksi'];
            $slcDataObat = $data['slcDataObat'];
            $Udd_Qty = $data['Udd_Qty']; 
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $TGLENTRI = Utils::seCurrentDateTime();
            $ID_DOKTER = "";


            $this->db->query("INSERT INTO [Apotik_V1.1SQL].DBO.UDD_DTL 
                                (ID_UDD_HDR,ID_OBAT,QTY,
                                USER_ENTRY,JAM_ENTRY) VALUES
                                (:ID_UDD_HDR,:ID_OBAT,:QTY,  
                                :USER_ENTRY,:JAM_ENTRY)");
            $this->db->bind('ID_UDD_HDR', $IdTransaksi);
            $this->db->bind('ID_OBAT', $slcDataObat);
            $this->db->bind('QTY', $Udd_Qty);
            $this->db->bind('USER_ENTRY', $namauserx);
            $this->db->bind('JAM_ENTRY', $TGLENTRI); 

            $this->db->execute();
            $this->db->commit();
            $last = $this->db->GetLastID();
            $this->db->closeCon();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Barang Berhasil Ditambahkan !', // Set array status dengan success  
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function loaddataUddDetailById($data)
    {
        try {
            $IdTransaksi = $data['IdTransaksi'];
            $this->db->query("  SELECT B.ID,B.QTy,C.[Product Name] AS NAMAOBA,b.ID_OBAT
                            FROM [Apotik_V1.1SQL].DBO.UDD_DTL B
                            inner join [Apotik_V1.1SQL].dbo.Products c
                            on c.id = b.ID_OBAT
                            where b.ID_UDD_HDR=:IdTransaksi and b.batal='0'");
            $this->db->bind('IdTransaksi', $IdTransaksi);
            $data =  $this->db->resultSet();
            $rows = array();
            

            return $data;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function voidTransaksiUDD($data)
    {
        try {
            $this->db->transaksi();

            if ($data['noregbatal'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input No. Transaksi !',
                );
                return $callback;
                exit;
            }

            if ($data['alasanbatal'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Alasan Batal !',
                );
                return $callback;
                exit;
            }

         

            $IdTransaksi = $data['noregbatal'];
            $alasanbatal = $data['alasanbatal']; 
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $TGLENTRI = Utils::seCurrentDateTime();
            $ID_DOKTER = "";


            $this->db->query("UPDATE [Apotik_V1.1SQL].DBO.UDD_DTL 
                            SET BATAL='1' , ALASAN_BATAL=:alasanbatal , TGL_BATAL =:TGLENTRI , USER_BATAL=:USER_ENTRY
                            where ID_UDD_HDR=:ID_UDD_HDR and BATAL='0' ");
            $this->db->bind('ID_UDD_HDR', $IdTransaksi);
            $this->db->bind('alasanbatal', $alasanbatal);
            $this->db->bind('TGLENTRI', $TGLENTRI);
            $this->db->bind('USER_ENTRY', $userid); 


            $this->db->query("UPDATE [Apotik_V1.1SQL].DBO.UDD_HDR 
                            SET BATAL='1' , ALASAN_BATAL=:alasanbatal , TGL_BATAL =:TGLENTRI , USER_BATAL=:USER_ENTRY
                            where ID=:ID_UDD_HDR ");
            $this->db->bind('ID_UDD_HDR', $IdTransaksi);
            $this->db->bind('alasanbatal', $alasanbatal);
            $this->db->bind('TGLENTRI', $TGLENTRI);
            $this->db->bind('USER_ENTRY', $userid); 

            $this->db->execute();
            $this->db->commit(); 
            $this->db->closeCon();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transaksi UDD Berhasil di Hapus !', // Set array status dengan success  
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function deleteUddDetil($data)
    {
        try {
            $this->db->transaksi();

            if ($data['NoIdUddDetail'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input No. Transaksi !',
                );
                return $callback;
                exit;
            } 

            $IdTransaksi = $data['NoIdUddDetail'];
            $alasanbatal = "-";
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $TGLENTRI = Utils::seCurrentDateTime();
            $ID_DOKTER = "";


            $this->db->query("UPDATE [Apotik_V1.1SQL].DBO.UDD_DTL 
                            SET BATAL='1' , ALASAN_BATAL=:alasanbatal , TGL_BATAL =:TGLENTRI , USER_BATAL=:USER_ENTRY
                            where ID=:ID_UDD_HDR and BATAL='0' ");
            $this->db->bind('ID_UDD_HDR', $IdTransaksi);
            $this->db->bind('alasanbatal', $alasanbatal);
            $this->db->bind('TGLENTRI', $TGLENTRI);
            $this->db->bind('USER_ENTRY', $userid);
 

            $this->db->execute();
            $this->db->commit();
            $this->db->closeCon();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transaksi UDD Berhasil di Hapus !', // Set array status dengan success  
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function getDataUddHeaderbyTrsid($data)
    {
        try {
            $Udd_No_Resep = $data['IdTransaksi'];
            $this->db->query("SELECT A.ID,A.ID_RESEP,B.PatientName,A.TGL_DIBERIKAN,A.JAM_DIBERIKAN,WAKTU_DIBERIKAN
                            ,a.NO_EPISODE,a.NO_REGISTRASI
                            ,a.JENIS_RESEP,replace(CONVERT(VARCHAR(11), b.Date_of_birth, 111), '/','-') as Date_of_birth
                            ,b.NoMR,a.NAMA_DOKTER FROM [Apotik_V1.1SQL].DBO.UDD_HDR A
                            INNER JOIN MasterdataSQL.DBO.Admision B
                            ON A.NO_MR COLLATE Latin1_General_CI_AS = B.NoMR COLLATE Latin1_General_CI_AS
                            WHERE A.ID=:Udd_No_Resep");
            $this->db->bind('Udd_No_Resep', $Udd_No_Resep);
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success',
                'UDD_TRS' => $data['ID'],
                'ID_RESEP' => $data['ID_RESEP'],
                'TGL_DIBERIKAN' => $data['TGL_DIBERIKAN'],
                'JAM_DIBERIKAN' => $data['JAM_DIBERIKAN'],
                'WAKTU_DIBERIKAN' => $data['WAKTU_DIBERIKAN'],
                'PatientName' => $data['PatientName'],
                'NoMR' => $data['NoMR'],
                'NO_EPISODE' => $data['NO_EPISODE'],
                'NO_REGISTRASI' => $data['NO_REGISTRASI'],
                'JENIS_RESEP' => $data['JENIS_RESEP'],
                'Date_of_birth' => $data['Date_of_birth'], 
                'NAMA_DOKTER' => $data['NAMA_DOKTER'], 
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
    public function getlistDataUddAll()
    {
        try { 
            $this->db->query(" SELECT A.ID,A.ID_RESEP,B.PatientName,a.TGL_ENTRY,A.TGL_DIBERIKAN,
                                A.JAM_DIBERIKAN,WAKTU_DIBERIKAN,b.NoMR,a.NAMA_DOKTER,a.USER_ENTRI
                                FROM [Apotik_V1.1SQL].DBO.UDD_HDR A
                                INNER JOIN MasterdataSQL.DBO.Admision B
                                ON A.NO_MR COLLATE Latin1_General_CI_AS = B.NoMR COLLATE Latin1_General_CI_AS
                                where a.BATAL='0'"); 
            $data =  $this->db->resultSet(); 
            return $data;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
