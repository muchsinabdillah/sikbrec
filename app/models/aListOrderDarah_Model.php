<?php
class aListOrderDarah_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }


    //data list sesus filter
    public function getDataListOrderDarah($data)
    {

        try {
            $tglawal = $data['TglAwal'];
            $tglakhir = $data['TglAkhir'];

            $this->db->query("SELECT a.ID,replace(CONVERT(VARCHAR(11), A.DateOrder, 111), '/','-')  as DateOrder,a.NoMR,a.NoRegistrasi,B.PatientName, a.UserOrderName,
            CASE WHEN ReviewQtyOrder='0' THEN 'New' 
            WHEN ReviewQtyOrder='1' AND StatusOrder='0' THEN 'Reviewed' 
            WHEN StatusOrder = '1' THEN 'Approved'
            ELSE 'UNKOWN'
            END AS Status_Order , a.JenisOrder, a.GolonganDarah, STUFF((SELECT ',' + CAST(NamaTarifDarah AS varchar) FROM LaboratoriumSQL.dbo.OrderBloodDetails t2  
            where a.ID =t2.IDHdr FOR XML PATH('')), 1 ,1, '') AS NamaTarifDarah,case when c.PatientType='2' then asu.NamaPerusahaan else jpk.NamaPerusahaan end as NamaJaminan,ReviewQtyOrder,u.ID as IsUsed
            FROM LaboratoriumSQL.dbo.OrderBloods a 
            INNER JOIN MasterDataSQL.dbo.Admision B ON a.NoMR = B.NoMR
            INNER JOIN PerawatanSQL.dbo.Visit c on a.NoRegistrasi=c.NoRegistrasi
            left join MasterDataSQL.dbo.MstrPerusahaanJPK jpk on c.Perusahaan=jpk.ID
            left join MasterDataSQL.dbo.MstrPerusahaanAsuransi asu on c.Asuransi=asu.ID
            left join LaboratoriumSQL.dbo.UseBloods u on a.ID=u.IDOrder and u.Batal='0'
            where a.Batal='0'  AND replace(CONVERT(VARCHAR(11), a.DateOrder, 111), '/','-')  
                 between :TglAwal and :TglAkhir and c.Batal='0'
                 union all
                 SELECT a.ID,replace(CONVERT(VARCHAR(11), A.DateOrder, 111), '/','-')  as DateOrder,a.NoMR,a.NoRegistrasi,B.PatientName, a.UserOrderName, 
                 CASE WHEN ReviewQtyOrder='0' THEN 'New' 
            WHEN ReviewQtyOrder='1' AND StatusOrder='0' THEN 'Reviewed' 
            WHEN StatusOrder = '1' THEN 'Approved'
            ELSE 'UNKNOWN'
            END AS Status_Order , a.JenisOrder, a.GolonganDarah, STUFF((SELECT ',' + CAST(NamaTarifDarah AS varchar) FROM LaboratoriumSQL.dbo.OrderBloodDetails t2  
            where a.ID =t2.IDHdr FOR XML PATH('')), 1 ,1, '') AS NamaTarifDarah,case when c.TypePatient='2' then asu.NamaPerusahaan else jpk.NamaPerusahaan end as NamaJaminan,ReviewQtyOrder,u.ID as IsUsed
            FROM LaboratoriumSQL.dbo.OrderBloods a 
            INNER JOIN MasterDataSQL.dbo.Admision B ON a.NoMR = B.NoMR
            INNER JOIN RawatInapSQL.dbo.Inpatient c on a.NoRegistrasi=c.NoRegRI
            left join MasterDataSQL.dbo.MstrPerusahaanJPK jpk on c.IDJPK=jpk.ID
            left join MasterDataSQL.dbo.MstrPerusahaanAsuransi asu on c.IDAsuransi=asu.ID
            left join LaboratoriumSQL.dbo.UseBloods u on a.ID=u.IDOrder and u.Batal='0'
            where a.Batal='0'  AND replace(CONVERT(VARCHAR(11), a.DateOrder, 111), '/','-')  
                 between :tglawal2 and :tglakhir2 
       ");

            $this->db->bind('TglAwal', $tglawal);
            $this->db->bind('TglAkhir', $tglakhir);
            $this->db->bind('tglawal2', $tglawal);
            $this->db->bind('tglakhir2', $tglakhir);
            // $this->db->bind('tglawal3', $tglawal);
            // $this->db->bind('tglakhir3', $tglakhir);
            // $this->db->bind('tglawal4', $tglawal);
            // $this->db->bind('tglakhir4', $tglakhir);
            // $this->db->bind('tglawal5', $tglawal);
            // $this->db->bind('tglakhir5', $tglakhir);
            // $this->db->bind('tglawal6', $tglawal);
            // $this->db->bind('tglakhir6', $tglakhir);

            $data =  $this->db->resultSet();
            $rows = array();
            // var_dump($data);
            // exit;
            foreach ($data as $row) {
                //PerawatanSQL.DBO.[Visit Details]

                $pasing['ID'] = $row['ID'];
                $pasing['DateOrder'] = date('d/m/Y', strtotime($row['DateOrder']));

                $pasing['NoMR'] = $row['NoMR'];
                $pasing['NoRegistrasi'] = $row['NoRegistrasi'];
                $pasing['NamaTarifDarah'] = $row['NamaTarifDarah'];

                $pasing['PatientName'] = $row['PatientName'];
                $pasing['GolonganDarah'] = $row['GolonganDarah'];
                $pasing['UserOrderName'] = $row['UserOrderName'];
                $pasing['StatusOrder'] = $row['Status_Order'];
                $pasing['NamaJaminan'] = $row['NamaJaminan'];

                $pasing['JenisOrder'] = $row['JenisOrder'];
                $pasing['ReviewQtyOrder'] = $row['ReviewQtyOrder'];
                $pasing['IsUsed'] = $row['IsUsed'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

// badrul

public function getDataListOrderDarahDetail($data)
    {
        // var_dump($data);
        // exit;
        try {
            $idheader = $data['idHeader'];

            $this->db->query("SELECT ID, NamaTarifDarah, CC, QtyOrder FROM LaboratoriumSQL.dbo.OrderBloodDetails WHERE IDHdr = :idheader and Batal != 1 ");
            $this->db->bind('idheader', $idheader);
            $data =  $this->db->resultSet();
            $rows = array();
            // var_dump($data);
            // exit;
            foreach ($data as $row) {
                //PerawatanSQL.DBO.[Visit Details]

                $pasing['ID'] = $row['ID'];
                $pasing['NamaTarifDarah'] = $row['NamaTarifDarah'];
                $pasing['CC'] = $row['CC'];
                $pasing['QtyOrder'] = $row['QtyOrder'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

public function UpdateQtyOrderDarah($data)
    {
        // var_dump($data);
        // exit;

        try {
             $this->db->transaksi();

            $idDetail = $data['idDetail'];
            $qtyDetail = $data['qtyDetail'];

            $this->db->query("UPDATE LaboratoriumSQL.dbo.OrderBloodDetails SET QtyOrder =:qtyDetail , QtyOrder_Old =:qtyDetail2 , QtyPakai = 0, QtySisa = :qtyDetail3, Total=Harga*:qtyDetail4 where ID =:idDetail ");
            $this->db->bind('idDetail', $idDetail);
            $this->db->bind('qtyDetail', $qtyDetail);
            $this->db->bind('qtyDetail2', $qtyDetail);
            $this->db->bind('qtyDetail3', $qtyDetail);
            $this->db->bind('qtyDetail4', $qtyDetail);

            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Di Update !', // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => 'warning',
                'message' => $e,
            );
            return $callback;
        }
    }  

    public function updateHeaderReviewQTYOrder($data)
    {
        try {
             $this->db->transaksi();
            $id_Order = $data['id_Order'];


            $this->db->query("SELECT QtyOrder_Old from LaboratoriumSQL.dbo.OrderBloodDetails
                    WHERE IDHdr=:id_Order and Batal='0'
                            ");
            $this->db->bind('id_Order', $id_Order);
            $datas =  $this->db->resultSet();
            foreach ($datas as $key) {
                
                if ($key['QtyOrder_Old'] == null){
                    $callback = array(
                        'status' => 'danger',
                        'message' => 'Ada Qty Yang Masih Null ! Mohon Diisi Agar Bisa Disimpan !',
                    );
                    return $callback;
                    exit;
                }
            }

            $session = SessionManager::getCurrentSession();
            $namauserx = $session->name;
            $datenowcreate = Utils::seCurrentDateTime();

            $this->db->query("UPDATE LaboratoriumSQL.dbo.OrderBloods set ReviewQtyOrder='1',DateApproveBDRS=:datenowcreate,PetugasApproveBDRS=:namauserx where ID=:id_Order");
            $this->db->bind('id_Order', $id_Order);
            $this->db->bind('namauserx', $namauserx);
            $this->db->bind('datenowcreate', $datenowcreate);

            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Di Review !', // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => 'warning',
                'message' => $e,
            );
            return $callback;
        }
    }  

// badrul
    
    public function getOrderDataByID($id)
    {
        try {
            $this->db->transaksi();
            $this->db->query("SELECT a.ID, a.DateOrder, a.Keterangan , A.NoMR, a.NoEpisode, a.NoRegistrasi, a.UserOrderName, a.DPJPName, B.PatientName, a.GolonganDarah,
            Case when d.PatientType=2 then asu.NamaPerusahaan else jpk.NamaPerusahaan end as NamaJaminan
            ,case when B.Gander='L' then 'Laki-laki' else 'Perempuan' end as gender, replace(CONVERT(VARCHAR(11), B.Date_of_birth, 111), '/','-') as Tgl_Lahir,v.NamaUnit as Ruang,JenisOrder,BeratBadan,Hb_SaatIni,Hb_Target,Rhesus,Trombosit_SaatIni,Trombosit_Target,Domisili,UserFirst
                            from LaboratoriumSQL.dbo.OrderBloods A
                            INNER JOIN MasterDataSQL.dbo.Admision B ON A.NoMR = B.NoMR
                            inner join PerawatanSQL.dbo.Visit d on a.NoRegistrasi=d.NoRegistrasi
                            left join MasterDataSQL.dbo.MstrPerusahaanJPK jpk on d.Perusahaan=jpk.ID
                            left join MasterDataSQL.dbo.MstrPerusahaanAsuransi asu on d.Asuransi=asu.ID
                            inner join MasterdataSQL.dbo.MstrUnitPerwatan v on d.Unit=v.ID
                            WHERE a.ID=:id
                            union all
                            SELECT a.ID, a.DateOrder, a.Keterangan , A.NoMR, a.NoEpisode, a.NoRegistrasi, a.UserOrderName, a.DPJPName, B.PatientName, a.GolonganDarah,
            Case when d.TypePatient=2 then asu.NamaPerusahaan else jpk.NamaPerusahaan end as NamaJaminan
            ,case when B.Gander='L' then 'Laki-laki' else 'Perempuan' end as gender, replace(CONVERT(VARCHAR(11), B.Date_of_birth, 111), '/','-') as Tgl_Lahir,case when d.RoomID_Akhir is not null then vx.RoomName else v.RoomName end as Ruang,JenisOrder,BeratBadan,Hb_SaatIni,Hb_Target,Rhesus,Trombosit_SaatIni,Trombosit_Target,Domisili,UserFirst
                            from LaboratoriumSQL.dbo.OrderBloods A
                            INNER JOIN MasterDataSQL.dbo.Admision B ON A.NoMR = B.NoMR
                            inner join RawatInapSQL.dbo.Inpatient d on a.NoRegistrasi=d.NoRegRI
                            left join MasterDataSQL.dbo.MstrPerusahaanJPK jpk on d.IDJPK=jpk.ID
                            left join MasterDataSQL.dbo.MstrPerusahaanAsuransi asu on d.IDAsuransi=asu.ID
                            left join RawatInapSQL.dbo.Inpatient_In_Out v on d.RoomID_Awal=v.ID
                            left join RawatInapSQL.dbo.Inpatient_In_Out vx on d.RoomID_Akhir=vx.ID
                            WHERE a.ID=:id2
                            ");
            $this->db->bind('id', $id);
            $this->db->bind('id2', $id);

            $data =  $this->db->single();
            $pasing['ID'] = $data['ID'];
            $pasing['DateOrder'] = $data['DateOrder'];
            $pasing['Keterangan'] = $data['Keterangan'];
            $pasing['NoMR'] = $data['NoMR'];
            $pasing['NoEpisode'] = $data['NoEpisode'];
            $pasing['NoRegistrasi'] = $data['NoRegistrasi'];
            $pasing['UserOrderName'] = $data['UserOrderName'];
            $pasing['DPJPName'] = $data['DPJPName'];
            $pasing['PatientName'] = $data['PatientName'];
            $pasing['GolonganDarah'] = $data['GolonganDarah'];
            $pasing['NamaJaminan'] = $data['NamaJaminan'];
            $pasing['gender'] = $data['gender'];
            $pasing['Domisili'] = $data['Domisili'];
            $pasing['Tgl_Lahir'] = $data['Tgl_Lahir'];
            $pasing['Ruang'] = $data['Ruang'];
            $pasing['UserFirst'] = $data['UserFirst'];
            $pasing['JenisOrder'] = $data['JenisOrder'];
            $pasing['BeratBadan'] = $data['BeratBadan'];
            $pasing['Hb_SaatIni'] = $data['Hb_SaatIni'];
            $pasing['Hb_Target'] = $data['Hb_Target'];
            $pasing['Rhesus'] = $data['Rhesus'];
            $pasing['Trombosit_SaatIni'] = $data['Trombosit_SaatIni'];
            $pasing['Trombosit_Target'] = $data['Trombosit_Target'];


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

    //fiqri 09-04-2023
    public function createHeaderTrs_UseBlood($data)
    {
        try {
            $this->db->transaksi();
            $no_MR = $data['no_MR'];
            $nama_Pasien = $data['nama_Pasien'];
            $no_Eps = $data['no_Eps'];
            $nama_Jaminan = $data['nama_Jaminan'];
            $no_Reg = $data['no_Reg'];
            $dokter_DPJP = $data['dokter_DPJP'];
            $user_Order = $data['user_Order'];
            $id_Order = $data['id_Order'];
            $tgl_Order = $data['tgl_Order'];
            $tgl_Pakai = $data['tgl_Pakai'];
            $ket_order = $data['ket_order'];
            $TransasctionDate = $data['TransasctionDate'];

            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $namauserx = $session->name;
            $operator =  $session->IDEmployee;


            $datenowcreate = Utils::seCurrentDateTime();

            if ($TransasctionDate == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Tanggal Pakai !',
                );
                return $callback;
                exit;
            }



            $this->db->query("
            INSERT INTO LaboratoriumSQL.[dbo].[UseBloods]
           ([NoMR]
           ,[NoEpisode]
           ,[NoRegistrasi]
           ,[DateConsume]
           ,[IDOrder]
           ,[Keterangan]
           ,[QtyTotal]
           ,[DateCreate]
           ,[UserFirst]
           ,[UserConsumeId]
           ,[UserConsumeName]
           )
     VALUES
           (
            :no_MR,
            :no_Eps,
            :no_Reg,
            :TransasctionDate,
            :id_Order,
            :ket_order,
            :qty_total,
            :datecreatenow,
            :userid,
            :userid2,
            :namauserx
           )
            ");
            $this->db->bind('no_MR', $no_MR);
            $this->db->bind('no_Eps', $no_Eps);
            $this->db->bind('no_Reg', $no_Reg);
            $this->db->bind('TransasctionDate', $TransasctionDate);
            $this->db->bind('id_Order', $id_Order);
            $this->db->bind('ket_order', $ket_order);
            $this->db->bind('qty_total', null);
            $this->db->bind('datecreatenow', $datenowcreate);
            $this->db->bind('userid', $userid);
            $this->db->bind('userid2', $userid);
            $this->db->bind('namauserx', $namauserx);
            $this->db->execute();
            $getID = $this->db->GetLastID();
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success  
                'idhdr_useblood' => $getID,
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function GetListNamaOrderDetail($data)
    {
        try {
            $idhdr = $data['idhdr'];
            $this->db->query("SELECT ID,NamaTarifDarah from LaboratoriumSQL.dbo.OrderBloodDetails where IDHdr=:idhdr and Batal='0' and QtySisa<>0 AND JenisPakai='P'");
            $this->db->bind('idhdr', $idhdr);

            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['NamaTarifDarah'] = $key['NamaTarifDarah'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function GetNamaOrderDetail($data)
    {
        $id = $data['id'];
        try {
            $this->db->query('SELECT * FROM LaboratoriumSQL.dbo.OrderBloodDetails Where ID=:id');
            $this->db->bind('id', $id);

            $data =  $this->db->single();
            $pasing['ID'] = $data['ID'];
            $pasing['IdTarifDarah'] = $data['IdTarifDarah'];
            $pasing['NamaTarifDarah'] = $data['NamaTarifDarah'];
            $pasing['QtyOrder'] = $data['QtyOrder'];
            $pasing['QtyPakai'] = $data['QtyPakai'];
            $pasing['QtySisa'] = $data['QtySisa'];
            $pasing['CC'] = $data['CC'];
            $pasing['Harga'] = $data['Harga'];
            $pasing['Total'] = $data['Total'];

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

    public function createDetailTrs_UseBlood($data)
    {

        try {
            $this->db->transaksi();
            if ($data['IdTarifDarah'] == "") {
                $callback = array(
                    'status' => "eror", // Set array nama  
                    'message' => "Mohon Pilih Jenis Darah ! "
                );
                return $callback;
                exit;
            }
            if ($data['QtyPakai'] == "") {
                $callback = array(
                    'status' => "eror", // Set array nama  
                    'message' => "Qty Pakai Kosong ! "
                );
                return $callback;
                exit;
            }
            if (!is_numeric($data['QtyPakai'])) {
                $callback = array(
                    'status' => "eror", // Set array nama  
                    'message' => "Mohon Isi Angka ! "
                );
                return $callback;
                exit;
            }
            if ($data['ExpiredDate'] == "") {
                $callback = array(
                    'status' => "eror", // Set array nama  
                    'message' => "Mohon Isi Expired Date ! "
                );
                return $callback;
                exit;
            }
            if ($data['Barcode'] == "") {
                $callback = array(
                    'status' => "eror", // Set array nama  
                    'message' => "Mohon Isi Barcode ! "
                );
                return $callback;
                exit;
            }
            if ($data['KantongKe'] == "") {
                $callback = array(
                    'status' => "eror", // Set array nama  
                    'message' => "Mohon Isi Kantong Ke ! "
                );
                return $callback;
                exit;
            }
           


            $IdTarifDarah = $data['IdTarifDarah'];
            $NamaTarifDarah = $data['NamaTarifDarah'];
            $Id_dtl = $data['Id_dtl'];
            $QtyPakai = $data['QtyPakai'];
            $QtyOrder = $data['QtyOrder'];
            $QtySisa = $data['QtySisa'];
            $idhdr_useblood = $data['Id_dtl'];
            $idorderheader = $data['id_Order'];
            $QtyPakai = (int) $QtyPakai;
            $QtyOrder = (int) $QtyOrder;
            $QtySisa = (int) $QtySisa;
            $ExpiredDate = $data['ExpiredDate'];
            $Barcode = $data['Barcode'];
            $Keterangan = $data['KeteranganDtl'];
            $QtyCC = $data['QtyCC'];
            $KantongKeUrut = $data['KantongKe'];

            $id_noTr = $data['id_noOrder'];

            $Harga = $data['Harga'];
            $Total = $data['Total'];

            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $namauserx = $session->name;

            $this->db->query("SELECT Barcode FROM LaboratoriumSQL.dbo.UseBloodDetails Where Barcode=:Barcode and Batal='0'
            AND IDHdr=:id_noTr
            ");
            $this->db->bind('Barcode', $Barcode);
            $this->db->bind('id_noTr', $id_noTr);
            $datax =  $this->db->single();

            if ($datax['Barcode'] != null) {
                $callback = array(
                    'status' => "eror", // Set array nama  
                    'message' => "Barcode Sudah Pernah Digunakan ! Silahkan Cek Kembali !"
                );
                return $callback;
                exit;
            }


            //INSERT TABEL PAYMENT DTL
            //for ($i = 0; $i < $count_array; $i++) {
            $this->db->query('SELECT * FROM LaboratoriumSQL.dbo.OrderBloodDetails Where ID=:Id_dtl');
            $this->db->bind('Id_dtl', $Id_dtl);
            $data =  $this->db->single();

            $qtyabsurd = $data['QtySisa'] - $QtyPakai;
            // $qtyabsurd = $QtySisa - $QtyPakai;

            if ($data['QtySisa'] == "0") {
                $callback = array(
                    'status' => "eror", // Set array nama  
                    'message' => "Qty Sisa = 0. "
                );
                return $callback;
                exit;
            }
            if ($QtyPakai >  $QtySisa) {
                $callback = array(
                    'status' => "eror", // Set array nama  
                    'message' => "Qty Pakai lebih besar dari Qty Sisa. " . $data['QtySisa'] . " - " . $QtyPakai
                );
                return $callback;
                exit;
            }
            if ($qtyabsurd < 0) {
                $callback = array(
                    'status' => "eror", // Set array nama  
                    'message' => "Qty Pakai Invalid. "
                );
                return $callback;
                exit;
            }
            // }

            //INSERT TABEL PAYMENT DTL
            //for ($i = 0; $i < $count_array; $i++) {
            $qtyPakai = 0.00 + $QtyPakai;

            // //urut no kantong auto
            // $this->db->query("SELECT isnull(max(KantongKe),0) as KantongKeUrut from LaboratoriumSQL.dbo.UseBloodDetails where IDHdr=:id_noTr and Batal='0'");
            // $this->db->bind('id_noTr', $id_noTr);
            // $dataw =  $this->db->single();
            // $KantongKeUrut = $dataw['KantongKeUrut'];
            // $KantongKeUrut++;


            // var_dump($idorderheader);
            // var_dump($Id_dtl);
            // exit;
            $this->db->query("UPDATE LaboratoriumSQL.dbo.OrderBloodDetails
                                SET QtySisa=:qtyabsurd,QtyPakai=QtyPakai+ :qtyPakai
                                WHERE IDHdr=:idorderheader and ID=:Id_dtl");
            $this->db->bind('idorderheader', $idorderheader);
            $this->db->bind('qtyabsurd', $qtyabsurd);
            $this->db->bind('qtyPakai', $qtyPakai);
            $this->db->bind('Id_dtl', $Id_dtl);
            $this->db->execute();

            $this->db->query("UPDATE LaboratoriumSQL.dbo.UseBloods
                                SET QtyTotal=Isnull(QtyTotal,0)+:qtyPakai
                                WHERE ID=:id_noTr");
            $this->db->bind('qtyPakai', $qtyPakai);
            $this->db->bind('id_noTr', $id_noTr);
            $this->db->execute();

            $this->db->query("INSERT INTO LaboratoriumSQL.[dbo].UseBloodDetails
            (
            [IDhdr]
            ,[IdTarifDarah]
            ,[NamaTarifDarah]
            ,[QtyOrder]
            ,[QtyPakai]
            ,[QtySisa]
            ,[Harga]
            ,[Total]
            ,[DateCreate]
            ,[UserFirst]
            ,[Expired_Date]
            ,[Barcode]
            ,[Keterangan]
            ,[QtyCC]
            ,[KantongKe]
            )
        VALUES (
            :id_noTr
            ,:IdTarifDarah
            ,:NamaTarifDarah
            ,:QtyOrder
            ,:QtyPakai
            ,:QtySisa
            ,:Harga
            ,:Total
            ,:datenowcreate
            ,:userid
            ,:ExpiredDate
            ,:Barcode
            ,:Keterangan
            ,:QtyCC
            ,:KantongKeUrut
            )");

            $this->db->bind('id_noTr', $id_noTr);
            $this->db->bind('IdTarifDarah', $IdTarifDarah);
            $this->db->bind('NamaTarifDarah', $NamaTarifDarah);
            $this->db->bind('QtyOrder', $QtyOrder);
            $this->db->bind('QtyPakai', $QtyPakai); //notes
            $this->db->bind('QtySisa', $qtyabsurd); //notes
            $this->db->bind('Harga', $Harga); //notes
            $this->db->bind('Total', $Total); //notes
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('userid', $userid);
            $this->db->bind('ExpiredDate', $ExpiredDate);
            $this->db->bind('Barcode', $Barcode);
            $this->db->bind('Keterangan', $Keterangan);
            $this->db->bind('QtyCC', $QtyCC);
            $this->db->bind('KantongKeUrut', $KantongKeUrut);
            $this->db->execute();

            // $this->db->query("INSERT INTO LaboratoriumSQL.[dbo].UseBloodDetails
            //                     (
            //                     [IDhdr]
            //                     ,[IdTarifDarah]
            //                     ,[NamaTarifDarah]
            //                     ,[QtyOrder]
            //                     ,[QtyPakai]
            //                     ,[QtySisa]
            //                     ,[Harga]
            //                     ,[Total]
            //                     ,[DateCreate]
            //                     ,[UserFirst]
            //                     )
            //                 VALUES (
            //                     :idhdr_useblood
            //                     ,:Id_dtl
            //                     ,:NamaTarifDarah
            //                     ,:QtyPakai
            //                     ,:QtyPakai2
            //                     ,:QtyPakai3
            //                     ,:Harga
            //                     ,:Total
            //                     ,:datenowcreate
            //                     ,:userid
            //         )");

            // $this->db->bind('idhdr_useblood', $idhdr_useblood);
            // $this->db->bind('Id_dtl', $Id_dtl);
            // $this->db->bind('NamaTarifDarah', $NamaTarifDarah);
            // $this->db->bind('QtyPakai', $QtyPakai);
            // $this->db->bind('QtyPakai2', $QtyPakai); //notes
            // $this->db->bind('QtyPakai3', $QtyPakai); //notes
            // $this->db->bind('Harga', $Harga); //notes
            // $this->db->bind('Total', $Total); //notes
            // $this->db->bind('datenowcreate', $datenowcreate);
            // $this->db->bind('userid', $userid);
            // $this->db->execute();
            //}

            //Get qty total
            $this->db->query('SELECT QtyTotal FROM LaboratoriumSQL.dbo.UseBloods Where ID=:id_noTr');
            $this->db->bind('id_noTr', $id_noTr);
            $datax =  $this->db->single();
            $qtytotal = $datax['QtyTotal'];

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Tambah Berhasil',
                'qtytotal' => $qtytotal,
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

    public function createDetailTrs_UseBlood2($data)
    {
        $id = $data['id_Order'];
        // var_dump($id);
        // exit;
        try {
            $this->db->query('SELECT * FROM LaboratoriumSQL.dbo.OrderBloods Where IDHdr=:id');
            $this->db->bind('id', $id);

            $data =  $this->db->single();
            $pasing['ID'] = $data['ID'];
            $pasing['IdTarifDarah'] = $data['IdTarifDarah'];
            $pasing['NamaTarifDarah'] = $data['NamaTarifDarah'];
            $pasing['QtyOrder'] = $data['QtyOrder'];
            $pasing['QtyPakai'] = $data['QtyPakai'];
            $pasing['QtySisa'] = $data['QtySisa'];
            $pasing['CC'] = $data['CC'];
            $pasing['Harga'] = $data['Harga'];
            $pasing['Total'] = $data['Total'];

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

    public function getDataListUseBloodDetail($data)
    {

        try {
            $IDHdr = $data['IDHdr'];

            $this->db->query("SELECT ID,IdTarifDarah,NamaTarifDarah,QtyPakai,Expired_Date,Barcode,Keterangan,KantongKe,handover_bdrs_perawat_date
            ,handover_bdrs_perawat_petugasBDRS,handover_bdrs_perawat_petugasPerawat,handover_bdrs_perawat_status StatusHandOver
            FROM LaboratoriumSQL.[dbo].UseBloodDetails WHERE IDHdr=:IDHdr AND Batal='0'");
            $this->db->bind('IDHdr', $IDHdr);

            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $row) {

                $pasing['ID'] = $row['ID'];
                $pasing['IdTarifDarah'] = $row['IdTarifDarah'];
                $pasing['NamaTarifDarah'] = $row['NamaTarifDarah'];
                $pasing['QtyPakai'] = $row['QtyPakai'];
                $pasing['Expired_Date'] = $row['Expired_Date'];
                $pasing['Barcode'] = $row['Barcode'];
                $pasing['Keterangan'] = $row['Keterangan'];
                $pasing['KantongKe'] = $row['KantongKe'];
                $pasing['StatusHandOver'] = $row['StatusHandOver'];
                $pasing['handover_bdrs_perawat_date'] = $row['handover_bdrs_perawat_date'];
                $pasing['handover_bdrs_perawat_petugasBDRS'] = $row['handover_bdrs_perawat_petugasBDRS'];
                $pasing['handover_bdrs_perawat_petugasPerawat'] = $row['handover_bdrs_perawat_petugasPerawat'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function voidUseBloodbyID($data)
    {
        try {
            $this->db->transaksi();
            $ID = $data['ID'];
            $IDHdr_Order = $data['IDHdr_Order'];
            $product_code = $data['product_code'];

            //Cek
            $this->db->query("SELECT handover_bdrs_perawat_status FROM LaboratoriumSQL.dbo.UseBloodDetails Where ID=:ID");
            $this->db->bind('ID', $ID);
            $datag =  $this->db->single();
            $handover_bdrs_perawat_status = $datag['handover_bdrs_perawat_status'];
            if ($handover_bdrs_perawat_status == true){
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Jenis Darah Ini Sudah Hand Over ! Tidak Bisa Dibatalkan !',
                );
                return $callback;
                exit;
            }

            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $namauserx = $session->name;
            $operator =  $session->IDEmployee;
            $datenowcreate = Utils::seCurrentDateTime();

            $this->db->query("UPDATE LaboratoriumSQL.dbo.UseBloodDetails SET Batal='1',DateBatal=:datenowcreate,PetugasBatal=:userid,NamaPetugasBatal=:namauserx
            --QtySisa=QtySisa+QtySisa,QtyPakai=QtyPakai-QtyPakai
            WHERE ID=:ID");
            $this->db->bind('ID', $ID);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('userid', $userid);
            $this->db->bind('namauserx', $namauserx);
            $this->db->execute();

            $this->db->query('SELECT QtyPakai,IDHdr as IDHdrUseBlood FROM LaboratoriumSQL.dbo.UseBloodDetails Where ID=:ID');
            $this->db->bind('ID', $ID);
            $dataf =  $this->db->single();
            $qtypakai = $dataf['QtyPakai'];
            $IDHdrUseBlood = $dataf['IDHdrUseBlood'];

            $this->db->query("UPDATE LaboratoriumSQL.dbo.OrderBloodDetails SET QtySisa=QtySisa+:qtypakai,QtyPakai=QtyPakai-:qtypakai2
            WHERE IDHdr=:IDHdr_Order and IdTarifDarah=:product_code");
            $this->db->bind('IDHdr_Order', $IDHdr_Order);
            $this->db->bind('product_code', $product_code);
            $this->db->bind('qtypakai', $qtypakai);
            $this->db->bind('qtypakai2', $qtypakai);
            $this->db->execute();

            $this->db->query("UPDATE LaboratoriumSQL.dbo.UseBloods
                                SET QtyTotal=Isnull(QtyTotal,0)-:qtypakai
                                WHERE ID=:IDHdrUseBlood");
            $this->db->bind('qtypakai', $qtypakai);
            $this->db->bind('IDHdrUseBlood', $IDHdrUseBlood);
            $this->db->execute();

            // $this->db->query("UPDATE LaboratoriumSQL.dbo.UseBloodDetails SET QtySisa=QtySisa+QtySisa,QtyPakai=QtyPakai-QtyPakai
            // WHERE ID=:product_code");
            // $this->db->bind('product_code', $product_code);
            // $this->db->execute();

            //Get qty total
            $this->db->query('SELECT QtyTotal FROM LaboratoriumSQL.dbo.UseBloods Where ID=:id_noTr');
            $this->db->bind('id_noTr', $IDHdrUseBlood);
            $datax =  $this->db->single();
            $qtytotal = $datax['QtyTotal'];

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Berhasil Dihapus !',
                'qtytotal' => $qtytotal,
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function getDataListUseDarah($data)
    {

        try {
            $tglawal = $data['TglAwal'];
            $tglakhir = $data['TglAkhir'];

            $this->db->query("SELECT a.IDOrder,a.ID,replace(CONVERT(VARCHAR(11), a.DateConsume, 111), '/','-')  as DateConsume,a.NoMR,a.NoRegistrasi,B.PatientName, a.UserConsumeName,
                        a.Keterangan, QtyTotal,replace(CONVERT(VARCHAR(11), b.Date_of_birth, 111), '/','-')  as DOB,d.GolonganDarah,c.username as UserUpdate
                         FROM LaboratoriumSQL.dbo.UseBloods a
                         inner join MasterDataSQL.dbo.Admision b on a.NoMR=b.NoMR
                         left join MasterDataSQL.dbo.Employees c on a.UserLast=c.NoPIN
                         inner join LaboratoriumSQL.dbo.OrderBloods d on a.IDOrder=d.ID
                        where a.Batal='0'  AND replace(CONVERT(VARCHAR(11), a.DateConsume, 111), '/','-')  
                             between :TglAwal and :TglAkhir AND a.Batal='0'
       ");

            $this->db->bind('TglAwal', $tglawal);
            $this->db->bind('TglAkhir', $tglakhir);

            $data =  $this->db->resultSet();
            $rows = array();
            // var_dump($data);
            // exit;
            foreach ($data as $row) {
                //PerawatanSQL.DBO.[Visit Details]

                $pasing['ID'] = $row['ID'];
                $pasing['IDOrder'] = $row['IDOrder'];
                $pasing['DateConsume'] = date('d/m/Y', strtotime($row['DateConsume']));
                $pasing['NoMR'] = $row['NoMR'];
                $pasing['NoRegistrasi'] = $row['NoRegistrasi'];
                $pasing['PatientName'] = $row['PatientName'];
                $pasing['UserConsumeName'] = $row['UserConsumeName'];
                $pasing['Keterangan'] = $row['Keterangan'];
                $pasing['QtyTotal'] = $row['QtyTotal'];
                $pasing['DOB'] = $row['DOB'];
                $pasing['GolonganDarah'] = $row['GolonganDarah'];
                $pasing['UserUpdate'] = $row['UserUpdate'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataPakaiDarah($id)
    {
        try {
            $this->db->transaksi();
            $this->db->query("SELECT a.ID, a.DateOrder, a.Keterangan , A.NoMR, a.NoEpisode, a.NoRegistrasi, a.UserOrderName, a.DPJPName, B.PatientName, a.GolonganDarah,
            Case when d.PatientType=2 then asu.NamaPerusahaan else jpk.NamaPerusahaan end as NamaJaminan
            ,case when B.Gander='L' then 'Laki-laki' else 'Perempuan' end as gender, replace(CONVERT(VARCHAR(11), B.Date_of_birth, 111), '/','-') as Tgl_Lahir,v.NamaUnit as Ruang,JenisOrder,BeratBadan,Hb_SaatIni,Hb_Target,Rhesus,Trombosit_SaatIni,Trombosit_Target,Domisili,a.UserFirst,c.Keterangan as KetUseBlood,c.QtyTotal,DateConsume,c.HistoryIncompatibility,c.AutoControl
                            from LaboratoriumSQL.dbo.OrderBloods A
                            INNER JOIN MasterDataSQL.dbo.Admision B ON A.NoMR = B.NoMR
                            inner join LaboratoriumSQL.dbo.UseBloods c on a.ID=c.IDOrder
                            inner join PerawatanSQL.dbo.Visit d on a.NoRegistrasi=d.NoRegistrasi
                            left join MasterDataSQL.dbo.MstrPerusahaanJPK jpk on d.Perusahaan=jpk.ID
                            left join MasterDataSQL.dbo.MstrPerusahaanAsuransi asu on d.Asuransi=asu.ID
                            inner join MasterdataSQL.dbo.MstrUnitPerwatan v on d.Unit=v.ID
                            WHERE c.ID=:id
                            union all
                            SELECT a.ID, a.DateOrder, a.Keterangan , A.NoMR, a.NoEpisode, a.NoRegistrasi, a.UserOrderName, a.DPJPName, B.PatientName, a.GolonganDarah,
            Case when d.TypePatient=2 then asu.NamaPerusahaan else jpk.NamaPerusahaan end as NamaJaminan
            ,case when B.Gander='L' then 'Laki-laki' else 'Perempuan' end as gender, replace(CONVERT(VARCHAR(11), B.Date_of_birth, 111), '/','-') as Tgl_Lahir,case when d.RoomID_Akhir is not null then vx.RoomName else v.RoomName end as Ruang,JenisOrder,BeratBadan,Hb_SaatIni,Hb_Target,Rhesus,Trombosit_SaatIni,Trombosit_Target,Domisili,a.UserFirst,c.Keterangan as KetUseBlood,c.QtyTotal,DateConsume,c.HistoryIncompatibility,c.AutoControl
                            from LaboratoriumSQL.dbo.OrderBloods A
                            INNER JOIN MasterDataSQL.dbo.Admision B ON A.NoMR = B.NoMR
                            inner join LaboratoriumSQL.dbo.UseBloods c on a.ID=c.IDOrder
                            inner join RawatInapSQL.dbo.Inpatient d on a.NoRegistrasi=d.NoRegRI
                            left join MasterDataSQL.dbo.MstrPerusahaanJPK jpk on d.IDJPK=jpk.ID
                            left join MasterDataSQL.dbo.MstrPerusahaanAsuransi asu on d.IDAsuransi=asu.ID
                            left join RawatInapSQL.dbo.Inpatient_In_Out v on d.RoomID_Awal=v.ID
                            left join RawatInapSQL.dbo.Inpatient_In_Out vx on d.RoomID_Akhir=vx.ID
                            WHERE c.ID=:id2
            ");
            $this->db->bind('id', $id);
            $this->db->bind('id2', $id);

            $data =  $this->db->single();
            $pasing['ID'] = $data['ID'];
            $pasing['DateOrder'] = $data['DateOrder'];
            $pasing['Keterangan'] = $data['Keterangan'];
            $pasing['NoMR'] = $data['NoMR'];
            $pasing['NoEpisode'] = $data['NoEpisode'];
            $pasing['NoRegistrasi'] = $data['NoRegistrasi'];
            $pasing['UserOrderName'] = $data['UserOrderName'];
            $pasing['DPJPName'] = $data['DPJPName'];
            $pasing['PatientName'] = $data['PatientName'];
            $pasing['GolonganDarah'] = $data['GolonganDarah'];
            $pasing['DateConsume'] = $data['DateConsume'];
            $pasing['KetUseBlood'] = $data['KetUseBlood'];
            $pasing['NamaJaminan'] = $data['NamaJaminan'];
            $pasing['QtyTotal'] = $data['QtyTotal'];
            $pasing['gender'] = $data['gender'];
            $pasing['Domisili'] = $data['Domisili'];
            $pasing['Tgl_Lahir'] = $data['Tgl_Lahir'];
            $pasing['Ruang'] = $data['Ruang'];
            $pasing['UserFirst'] = $data['UserFirst'];
            $pasing['JenisOrder'] = $data['JenisOrder'];
            $pasing['BeratBadan'] = $data['BeratBadan'];
            $pasing['Hb_SaatIni'] = $data['Hb_SaatIni'];
            $pasing['Hb_Target'] = $data['Hb_Target'];
            $pasing['Rhesus'] = $data['Rhesus'];
            $pasing['Trombosit_SaatIni'] = $data['Trombosit_SaatIni'];
            $pasing['Trombosit_Target'] = $data['Trombosit_Target'];
            $pasing['HistoryIncompatibility'] = $data['HistoryIncompatibility'];
            $pasing['AutoControl'] = $data['AutoControl'];



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

    public function updateHeaderTrs($data)
    {
        try {
            $this->db->transaksi();
            $ket_order = $data['ket_order'];
            $TransasctionDate = $data['TransasctionDate'];
            $NoOrderTransaksi = $data['NoOrderTransaksi'];
            $incompatibility = $data['incompatibility'];
            $autocontrol = $data['autocontrol'];
            $ScreeningAntiBody = $data['ScreeningAntiBody'];
            
            $id_Order = $data['id_Order'];
            $GolonganDarah = $data['GolonganDarah'];
            $Rhesus = $data['Rhesus'];

            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $namauserx = $session->name;
            $operator =  $session->IDEmployee;
            $datenowcreate = Utils::seCurrentDateTime();

            if ($TransasctionDate == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Tanggal Pakai !',
                );
                return $callback;
                exit;
            }

            $this->db->query("UPDATE LaboratoriumSQL.dbo.OrderBloods SET GolonganDarah=:GolonganDarah,Rhesus=:Rhesus
            WHERE ID=:id_Order
            ");
            $this->db->bind('id_Order', $id_Order);
            $this->db->bind('GolonganDarah', $GolonganDarah);
            $this->db->bind('Rhesus', $Rhesus);
            $this->db->execute();


            $this->db->query("UPDATE LaboratoriumSQL.dbo.UseBloods SET DateConsume=:TransasctionDate,Keterangan=:ket_order,DateUpdate=:datenowcreate,UserLast=:userid,HistoryIncompatibility=:incompatibility,AutoControl=:autocontrol,ScreeningAntiBody=:ScreeningAntiBody
            WHERE ID=:NoOrderTransaksi
            ");
            $this->db->bind('TransasctionDate', $TransasctionDate);
            $this->db->bind('ket_order', $ket_order);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('userid', $userid);
            $this->db->bind('NoOrderTransaksi', $NoOrderTransaksi);
            $this->db->bind('incompatibility', $incompatibility);
            $this->db->bind('autocontrol', $autocontrol);
            $this->db->bind('ScreeningAntiBody', $ScreeningAntiBody);
            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Transkasi Berhasil Disimpan !',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function BatalHeaderUseBlood($data)
    {
        try {
            $this->db->transaksi();
            $NoOrderTransaksi = $data['NoOrderTransaksi'];

            //Cek
            $this->db->query("SELECT Count(ID) as cek FROM LaboratoriumSQL.dbo.UseBloodDetails Where IDHdr=:NoOrderTransaksi and Batal='0' and handover_bdrs_perawat_status='1'");
            $this->db->bind('NoOrderTransaksi', $NoOrderTransaksi);
            $datag =  $this->db->single();
            $cek = $datag['cek'];
            if ($cek > 0){
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Jenis Darah Ini Sudah Hand Over ! Tidak Bisa Dibatalkan !',
                );
                return $callback;
                exit;
            }

            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $namauserx = $session->name;
            $operator =  $session->IDEmployee;
            $datenowcreate = Utils::seCurrentDateTime();

            $this->db->query("SELECT count(ID) as countid FROM LaboratoriumSQL.dbo.OrderBloodDetails WHERE IDHdr in (SELECT IDOrder FROM LaboratoriumSQL.dbo.UseBloods WHERE ID=:NoOrderTransaksi) AND Batal='0' AND JenisPakai='R'");
            $this->db->bind('NoOrderTransaksi', $NoOrderTransaksi);
            $datag =  $this->db->single();
            $countid = $datag['countid'];

            if ($countid > 0) {
                $callback = array(
                    'status' => 'danger',
                    'message' => 'Order Ini Sudah Pernah Diretur ! Silahkan Cek Kembali !',
                );
                return $callback;
                exit;
            }

            $this->db->query("SELECT IDOrder,IDHdr,IdTarifDarah,isnull(sum(QtyPakai),0) as TtlQtyPakai,isnull(sum(QtySisa),0) as TtlQtySisa
            FROM LaboratoriumSQL.dbo.UseBloodDetails a
            inner join LaboratoriumSQL.dbo.UseBloods b on a.IDHdr=b.ID
            WHERE IDHdr=:NoOrderTransaksi and a.Batal='0' 
            group by IdTarifDarah,IDHdr,IDOrder");
            $this->db->bind('NoOrderTransaksi', $NoOrderTransaksi);
            //$datag =  $this->db->single();
            // $IDHdr_OrderBlood = $datag['IDHdr'];
            // $IdTarifDarah = $datag['IdTarifDarah'];
            // $TtlQtyPakai = $datag['TtlQtyPakai'];
            // $TtlQtySisa = $datag['TtlQtySisa'];

            $datag =  $this->db->resultSet();
            foreach ($datag as $row) {
                $IDHdr_OrderBlood = $row['IDOrder'];
                $IdTarifDarah = $row['IdTarifDarah'];
                $TtlQtyPakai = $row['TtlQtyPakai'];
                $TtlQtySisa = $row['TtlQtySisa'];

                $this->db->query("UPDATE LaboratoriumSQL.dbo.OrderBloodDetails SET QtySisa=QtySisa+:qtypakai,QtyPakai=QtyPakai-:qtypakai2
                WHERE IDHdr=:IDHdr_Order and IdTarifDarah=:product_code and JenisPakai='P'");
                $this->db->bind('IDHdr_Order', $IDHdr_OrderBlood);
                $this->db->bind('product_code', $IdTarifDarah);
                $this->db->bind('qtypakai', $TtlQtyPakai);
                $this->db->bind('qtypakai2', $TtlQtyPakai);
                $this->db->execute();
            }

            $this->db->query("UPDATE LaboratoriumSQL.dbo.UseBloods SET Batal='1',DateBatal=:datenowcreate,PetugasBatal=:userid,NamaPetugasBatal=:namauserx
            WHERE ID=:NoOrderTransaksi
            ");
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('userid', $userid);
            $this->db->bind('namauserx', $namauserx);
            $this->db->bind('NoOrderTransaksi', $NoOrderTransaksi);
            $this->db->execute();

            $this->db->query("UPDATE LaboratoriumSQL.dbo.UseBloodDetails SET Batal='1',DateBatal=:datenowcreate,PetugasBatal=:userid,NamaPetugasBatal=:namauserx
            WHERE IDHdr=:NoOrderTransaksi and Batal='0'
            ");
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('userid', $userid);
            $this->db->bind('namauserx', $namauserx);
            $this->db->bind('NoOrderTransaksi', $NoOrderTransaksi);
            $this->db->execute();




            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Transkasi Berhasil Dibatalkan !',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function getDataListOrderBloodDetail($data)
    {

        try {
            $IDHdr = $data['IDHdr'];

            $this->db->query("SELECT * FROM LaboratoriumSQL.[dbo].OrderBloodDetails 
                            WHERE IDHdr=:IDHdr AND Batal='0'");
            $this->db->bind('IDHdr', $IDHdr);

            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $row) {

                $pasing['ID'] = $row['ID'];
                $pasing['IdTarifDarah'] = $row['IdTarifDarah'];
                $pasing['NamaTarifDarah'] = $row['NamaTarifDarah'];
                $pasing['QtyOrder'] = $row['QtyOrder'];
                $pasing['QtyPakai'] = $row['QtyPakai'];
                $pasing['QtySisa'] = $row['QtySisa'];
                $pasing['CC'] = $row['CC'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function ReturOrderBlood($data)
    {
        try {
            $this->db->transaksi();
            $id_Order = $data['id_Order'];

            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $namauserx = $session->name;
            $operator =  $session->IDEmployee;
            $datenowcreate = Utils::seCurrentDateTime();

            $this->db->query("SELECT count(ID) as countid FROM LaboratoriumSQL.dbo.OrderBloodDetails WHERE IDHdr=:id_Order AND Batal='0' AND JenisPakai='R'");
            $this->db->bind('id_Order', $id_Order);
            $datag =  $this->db->single();
            $countid = $datag['countid'];

            if ($countid > 0) {
                $callback = array(
                    'status' => 'danger',
                    'message' => 'Order Ini Sudah Pernah Diretur ! Silahkan Cek Kembali !',
                );
                return $callback;
                exit;
            }

            // $this->db->query("SELECT IDOrder,IDHdr,IdTarifDarah,isnull(sum(QtyPakai),0) as TtlQtyPakai,isnull(sum(QtySisa),0) as TtlQtySisa 
            // FROM LaboratoriumSQL.dbo.UseBloodDetails a
            // inner join LaboratoriumSQL.dbo.UseBloods b on a.IDHdr=b.ID
            // WHERE IDHdr=:NoOrderTransaksi and a.Batal='0' 
            // group by IdTarifDarah,IDHdr,IDOrder");
            // $this->db->bind('NoOrderTransaksi', $NoOrderTransaksi);
            // //$datag =  $this->db->single();
            // // $IDHdr_OrderBlood = $datag['IDHdr'];
            // // $IdTarifDarah = $datag['IdTarifDarah'];
            // // $TtlQtyPakai = $datag['TtlQtyPakai'];
            // // $TtlQtySisa = $datag['TtlQtySisa'];

            // $datag =  $this->db->resultSet();
            // foreach ($datag as $row) {
            //     $IDHdr_OrderBlood = $row['IDOrder'];
            //     $IdTarifDarah = $row['IdTarifDarah'];
            //     $TtlQtyPakai = $row['TtlQtyPakai'];
            //     $TtlQtySisa = $row['TtlQtySisa'];

            // $this->db->query("UPDATE LaboratoriumSQL.dbo.OrderBloodDetails SET QtySisa=0--,QtyPakai=QtyPakai-:qtypakai2
            //     WHERE IDHdr=:id_Order and Batal='0' AND JenisPakai='P' AND QtySisa<>0");
            // $this->db->bind('id_Order', $id_Order);
            // $this->db->execute();
            //}

            $this->db->query(
                "INSERT INTO LaboratoriumSQL.dbo.OrderBloodDetails (IDHdr,IdTarifDarah,NamaTarifDarah,QtyOrder,QtyPakai,QtySisa,CC,Harga,Total,DateCreate,UserFirst,JenisPakai)
            SELECT IDHdr,IdTarifDarah,NamaTarifDarah,QtySisa*-1 as QtyOrder,0 as QtyPakai,0 as QtySisa,CC,Harga,(QtySisa*Harga)*-1 as Total,:datenowcreate,:namauserx,'R' as JenisPakai
            FROM LaboratoriumSQL.dbo.OrderBloodDetails WHERE IDHdr=:id_Order and Batal='0' and JenisPakai='P' and QtySisa<>0
            "
            );
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('namauserx', $namauserx);
            $this->db->bind('id_Order', $id_Order);
            $this->db->execute();

            $this->db->query("UPDATE LaboratoriumSQL.dbo.OrderBloodDetails SET QtySisa=0--,QtyPakai=QtyPakai-:qtypakai2
            WHERE IDHdr=:id_Order and Batal='0' AND JenisPakai='P' AND QtySisa<>0");
            $this->db->bind('id_Order', $id_Order);
            $this->db->execute();

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Transkasi Berhasil Diretur !',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function PrintLabelPasien($data)
    {
        // var_dump($data);
        // exit;
        try {

            $this->db->query("SELECT c.ID, a.Barcode,a.Expired_Date,c.NoMR,c.NoEpisode,b.Date_of_birth,c.NoRegistrasi,B.PatientName,c.DateConsume,c.UserConsumeName,a.Keterangan as KeteranganDtl,d.GolonganDarah,d.Rhesus,CAST(e.CC as INTEGER) as CC
                            from LaboratoriumSQL.dbo.UseBloodDetails A
                            INNER JOIN LaboratoriumSQL.dbo.UseBloods c on c.id = a.IDHdr
                            INNER JOIN MasterDataSQL.dbo.Admision B ON c.NoMR = B.NoMR
                            inner join LaboratoriumSQL.dbo.OrderBloods d on c.IDOrder=d.ID
                            inner join LaboratoriumSQL.dbo.OrderBloodDetails e on e.IDHdr=d.ID
                    WHERE a.ID=:id
            
         ");
            $this->db->bind('id', $data['notrs']);
            $row =  $this->db->single();

            $passing['Barcode'] = $row['Barcode'];
            $passing['NoMR'] = $row['NoMR'];
            $passing['Expired_Date'] = date('d/m/Y H:i', strtotime($row['Expired_Date']));
            if ($row['PatientName'] == null) {
                $passing['PatientName'] = '-';
            } else {
                $passing['PatientName'] = $row['PatientName'];
            }
            $passing['Date_of_birth'] = date('d/m/Y', strtotime($row['Date_of_birth']));
            $passing['DateConsume'] = date('d/m/Y H:i', strtotime($row['DateConsume']));
            $passing['UserConsumeName'] = $row['UserConsumeName'];
            $passing['KeteranganDtl'] = $row['KeteranganDtl'];
            $passing['GolonganDarah'] = $row['GolonganDarah'];
            $passing['Rhesus'] = $row['Rhesus'];
            $passing['CC'] = $row['CC'];


            return $passing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function goHandOver($data)
    {
        try {
            $this->db->transaksi();
            $IDDetail = $data['IDDetail'];
            //$BarcodeHO = $data['BarcodeHO'];
            $PetugasBDRS = $data['PetugasBDRS'];
            $PetugasPerawat = $data['PetugasPerawat'];

            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $namauserx = $session->name;
            $operator =  $session->IDEmployee;
            $datenowcreate = Utils::seCurrentDateTime();

            // if ($BarcodeHO == '') {
            //     $callback = array(
            //         'status' => 'danger',
            //         'message' => 'Barcode Masih Kosong !',
            //     );
            //     return $callback;
            //     exit;
            // }

            // $this->db->query("SELECT count(ID) as countid FROM LaboratoriumSQL.dbo.UseBloodDetails WHERE Batal='0' AND Barcode=:BarcodeHO");
            // $this->db->bind('BarcodeHO', $BarcodeHO);
            // $datag =  $this->db->single();
            // $countid = $datag['countid'];
            // if ($countid == 0) {
            //     $callback = array(
            //         'status' => 'danger',
            //         'message' => 'Barcode Tidak Ditemukan !!',
            //     );
            //     return $callback;
            //     exit;
            // }

            // $this->db->query("SELECT count(ID) as countid FROM LaboratoriumSQL.dbo.UseBloodDetails WHERE Batal='0' AND Barcode=:BarcodeHO AND Selesai_Perawat='1'");
            // $this->db->bind('BarcodeHO', $BarcodeHO);
            // $datag =  $this->db->single();
            // $countid = $datag['countid'];
            // if ($countid > 0) {
            //     $callback = array(
            //         'status' => 'danger',
            //         'message' => 'Barcode Sudah Pernah Digunakan ! Silahkan Cek Kembali !',
            //     );
            //     return $callback;
            //     exit;
            // }

            // $this->db->query("SELECT count(ID) as countid FROM LaboratoriumSQL.dbo.UseBloodDetails WHERE ID=:IDDetail AND Batal='0' AND Barcode=:BarcodeHO");
            // $this->db->bind('IDDetail', $IDDetail);
            // $this->db->bind('BarcodeHO', $BarcodeHO);
            // $datag =  $this->db->single();
            // $countid = $datag['countid'];
            // if ($countid == 0) {
            //     $callback = array(
            //         'status' => 'danger',
            //         'message' => 'Barcode Tidak Valid Atas Hand Over Ini ! Silahkan Cek Kembali !',
            //     );
            //     return $callback;
            //     exit;
            // }

            if ($PetugasBDRS == '' || $PetugasBDRS == null || $PetugasBDRS == 'null') {
                $callback = array(
                    'status' => 'danger',
                    'message' => 'Petugas BDRS Masih Kosong !',
                );
                return $callback;
                exit;
            }

            if ($PetugasPerawat == ''  || $PetugasPerawat == null || $PetugasPerawat == 'null') {
                $callback = array(
                    'status' => 'danger',
                    'message' => 'Petugas Perawat Masih Kosong',
                );
                return $callback;
                exit;
            }

            $this->db->query("UPDATE LaboratoriumSQL.dbo.UseBloodDetails SET Selesai_Perawat='1',Start_ExpiredDate=:datenowcreate,End_ExpiredDate=:expireddate_end,handover_bdrs_perawat_status='1',handover_bdrs_perawat_date=:datenowcreate2,handover_bdrs_perawat_petugasBDRS=:PetugasBDRS,handover_bdrs_perawat_petugasPerawat=:PetugasPerawat
                WHERE ID=:IDDetail");
            $this->db->bind('IDDetail', $IDDetail);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('datenowcreate2', $datenowcreate);
            $this->db->bind('expireddate_end', date("Y-m-d H:i:s", strtotime("+30 minutes")));
            $this->db->bind('PetugasBDRS', $PetugasBDRS);
            $this->db->bind('PetugasPerawat', $PetugasPerawat);
            $this->db->execute();

            $this->db->query("UPDATE LaboratoriumSQL.dbo.OrderBloodDetails SET QtyPakaiPerawat=isnull(QtyPakaiPerawat,0)+1 
            FROM LaboratoriumSQL.dbo.OrderBloodDetails a
                inner join LaboratoriumSQL.dbo.OrderBloods b on a.IDHdr=b.ID
                inner join LaboratoriumSQL.dbo.UseBloods c on b.ID=c.IDOrder
                inner join LaboratoriumSQL.dbo.UseBloodDetails d on c.ID=d.IDHdr
                WHERE d.ID=:IDDetail AND d.Batal='0' AND c.Batal='0' AND b.Batal='0'");
            $this->db->bind('IDDetail', $IDDetail);
            $this->db->execute();

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Hand Over Berhasil Dilakukan !',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function goSaveTTDNoPIN($data)
    {
        $NoPIN_HO = $data['NoPIN_HO'];
        $Password_HO = $data['Password_HO'];
        $attribute = $data['attribute'];
        try {
            $this->db->query('SELECT username FROM MasterDataSQL.dbo.Employees Where NoPIN=:NoPIN_HO AND Password=:Password_HO');
            $this->db->bind('NoPIN_HO', $NoPIN_HO);
            $this->db->bind('Password_HO', $Password_HO);
            $data =  $this->db->single();
            $username = $data['username'];
            
            if ($username == null) {
                $callback = array(
                    'status' => 'danger',
                    'message' => 'NoPIN Atau Password Salah / Tidak Sesuai ! Silahkan Dicek Kembali !',
                );
                return $callback;
                exit;
            }

            $pasing['username'] = $data['username'];
            $pasing['attribute'] = $attribute;

            $callback = array(
                'status' => "success", // Set array nama 
                'message' => 'Berhasil !',
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

    public function goshowHandover($data)
    {
        try {
            $this->db->transaksi();
            $IDDetail = $data['IDDetail'];

            $this->db->query("SELECT a.ID,QtyPakai,KantongKe,NamaTarifDarah JenisDarah,a.Keterangan,handover_bdrs_perawat_date,handover_bdrs_perawat_petugasBDRS,handover_bdrs_perawat_petugasPerawat,b.DateUpdate,Expired_Date as ED,Barcode
            FROM LaboratoriumSQL.dbo.UseBloodDetails a
            inner join LaboratoriumSQL.dbo.UseBloods b on a.IDHdr=b.ID
            Where a.ID=:IDDetail");
            $this->db->bind('IDDetail', $IDDetail);
            $data =  $this->db->single();

            if ($data['DateUpdate'] == null){
                $callback = array(
                    'status' => 'danger',
                    'message' => 'Transaksi Belum Disimpan ! Silahkan Simpan Transaksi Terlebih Dahulu !',
                );
                return $callback;
                exit;
            }
            

            $pasing['ID'] = $data['ID'];
            $pasing['QtyPakai'] = $data['QtyPakai'];
            $pasing['KantongKe'] = $data['KantongKe'];
            $pasing['JenisDarah'] = $data['JenisDarah'];
            $pasing['Keterangan'] = $data['Keterangan'];
            $pasing['ED'] = $data['ED'];
            $pasing['Barcode'] = $data['Barcode'];
            // $pasing['handover_bdrs_perawat_date'] = date('d/m/Y H:i:s' , strtotime($data['handover_bdrs_perawat_date']));
            $pasing['handover_bdrs_perawat_date'] = $data['handover_bdrs_perawat_date'];
            $pasing['handover_bdrs_perawat_petugasBDRS'] = $data['handover_bdrs_perawat_petugasBDRS'];
            $pasing['handover_bdrs_perawat_petugasPerawat'] = $data['handover_bdrs_perawat_petugasPerawat'];

            $callback = array(
                'status' => "success", // Set array nama 
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

    public function getDataPemeriksaan($data)
    {
        try {
            $noreg = $data['noreg'];
            $jenispasien = substr($noreg,0,2);

            if ($jenispasien == 'RJ'){
                $this->db->query("SELECT ID,replace(CONVERT(VARCHAR(11), Tanggal, 111), '/','-')  as Tgl ,NamaProduct,Quantity,Tarif,TotalTarif,KategoriTarif 
                FROM PerawatanSQL.dbo.[Visit Details] where NoRegistrasi=:noreg
                 "); 
                 $this->db->bind('noreg', $noreg);
                
            }else{
                $this->db->query("SELECT ID,replace(CONVERT(VARCHAR(11), VisitDate, 111), '/','-')  as Tgl ,NamaTindakan NamaProduct,Quantity,[Unit Price]Tarif,TotalTarif,Category KategoriTarif 
                FROM RawatInapSQL.dbo.[Inpatient Details] where NoRegRI=:noreg
                 "); 
                 $this->db->bind('noreg', $noreg);

            }
                            $data =  $this->db->resultSet();
                            $rows = array();
                            $no = 1;
                            foreach ($data as $key) {
                                $pasing['No'] = $no++;
                                $pasing['ID'] = $key['ID'];
                                $pasing['Tgl'] = $key['Tgl'];
                                $pasing['NamaProduct'] = $key['NamaProduct'];
                                $pasing['Quantity'] = $key['Quantity'];
                                $pasing['TotalTarif'] = $key['TotalTarif'];
                                $pasing['KategoriTarif'] = $key['KategoriTarif'];
                                $rows[] = $pasing;
                            }
                            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function goAddPemeriksaan($data,$namadokter_addvisit)
    {
        try {
            $this->db->transaksi();

            
            date_default_timezone_set('Asia/Jakarta');
            $NamaPasien = $data['NamaPasien'];
            $Dokter = $data['Dokter'];
            $NoRegistrasi = $data['NoRegistrasi'];
            $Unit = $data['Unit'];
            $IDUnit = $data['IDUnit'];
            $NoEpisode = $data['NoEpisode'];
            $Kelas = $data['Kelas'];
            $IDKelas = $data['IDKelas'];
            $NoMR = $data['NoMR'];
            $TglMasuk = $data['TglMasuk'];
            $TglKeluar = $data['TglKeluar'];
            $TanggalLahir = $data['TanggalLahir'];
            $HakKelas = $data['HakKelas'];
            $Penjamin = $data['Penjamin'];
            $GroupJaminan = $data['GroupJaminan'];
            $penjamin_kode = $data['penjamin_kode'];
            $TypePatientID = $data['TypePatientID'];
            $Diagnosa = $data['Diagnosa'];
            $namatindakan = $data['namatindakan'];
            $date_tindakan_tambahan = $data['date_tindakan_tambahan'];
            $dokterpemeriksa = $data['dokterpemeriksa'];
            $qty_addvisit = $data['qty_addvisit'];
            $total_tarif_addvisit_temp = $data['total_tarif_addvisit_temp'];
            $tarif_satuan_addvisit = $data['tarif_satuan_addvisit'];
            $diskon_addvisit = $data['diskon_addvisit']/100;
            $total_tarif_addvisit = $data['total_tarif_addvisit'];
            $kode_dokterpemeriksa = $data['kode_dokterpemeriksa'];
            $namaproduct_addvisit = $data['namaproduct_addvisit'];
            $categoryproduct_addvisit = $data['categoryproduct_addvisit'];
            //$namadokter_addvisit = $data['namadokter_addvisit'];

            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $namauserx = $session->name;
            $operator =  $session->IDEmployee;


            $jenispasien = substr($NoRegistrasi,0,2);

            if ($namatindakan == null || $namatindakan == ''){
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Nama pemeriksaan kosong! Silahkan pilih nama pemeriksaan !',
                );
                return $callback;
                exit;
            }

            if ($date_tindakan_tambahan == null){
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Tanggal pemeriksaan kosong! Silahkan input tanggal pemeriksaan !',
                );
                return $callback;
                exit;
            }

            $date_tindakan_tambahan = $date_tindakan_tambahan.' '.date('H:i:s');

            if ($jenispasien == 'RJ'){
                $this->db->query("SELECT LockBill,[Status ID] as statusid FROM PerawatanSQL.dbo.Visit where NoRegistrasi=:NoRegistrasi
                            ");
            $this->db->bind('NoRegistrasi', $NoRegistrasi);
            $dataf =  $this->db->single();
            $lock = $dataf['LockBill'];
            $statusid = $dataf['statusid'];

            if ($statusid == '4'){
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Billing sudah ditutup ! Silahkan konfirmasi ke kasir !',
                );
                return $callback;
                exit;
            }

            if ($lock == '1'){
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Billing sudah dilock ! Silahkan konfirmasi ke kasir !',
                );
                return $callback;
                exit;
            }

            

                $this->db->query("INSERT INTO PerawatanSQL.dbo.[Visit Details] (NoMR,NoEpisode,NoRegistrasi,NamaUnit,Dokter,NamaDokter,Tanggal,ProductID,NamaProduct,Quantity,Tarif,TotalTarif,JasaDokter,Discount,StatusID,KategoriTarif,UserInput,Bayar) 
                SELECT :nomr,:noeps,:noreg,:namaunit,:iddokter,:dokter,:date_tindakan_tambahan,:productid,[Product Name],:qty,:tarif,:totaltarif,:jasadokter,:diskon,'1',CategoryProduct,:userinput,:totaltarif2 FROM PerawatanSQL.dbo.Tarif_RJ_UGD Where ID=:productid2
                -- VALUES
                -- (:nomr,:noeps,:noreg,:namaunit,:iddokter,:dokter,:date_tindakan_tambahan,:productid,:namaproduct,:qty,:tarif,:totaltarif,:jasadokter,:diskon,'1',:kategoritarif,:userinput,:totaltarif2)
                 "); 
                 $this->db->bind('nomr', $NoMR);
                 $this->db->bind('noeps', $NoEpisode);
                 $this->db->bind('noreg', $NoRegistrasi);
                 $this->db->bind('namaunit', $Unit);
                 $this->db->bind('iddokter', $dokterpemeriksa);
                 $this->db->bind('dokter', $namadokter_addvisit);
                 $this->db->bind('date_tindakan_tambahan', $date_tindakan_tambahan);
                 $this->db->bind('productid', $namatindakan);
                 $this->db->bind('qty', $qty_addvisit);
                 $this->db->bind('tarif', $tarif_satuan_addvisit);
                 $this->db->bind('totaltarif', $total_tarif_addvisit);
                 $this->db->bind('jasadokter', null);
                 $this->db->bind('diskon', $diskon_addvisit);
                 $this->db->bind('userinput', $namauserx);
                 $this->db->bind('totaltarif2', $total_tarif_addvisit);
                 $this->db->bind('productid2', $namatindakan);
                
            }else{
                $this->db->query("SELECT LockBill,[StatusID] as statusid FROM RawatInapSQL.dbo.Inpatient where NoRegRI=:NoRegistrasi
                ");
                $this->db->bind('NoRegistrasi', $NoRegistrasi);
                $dataf =  $this->db->single();
                $lock = $dataf['LockBill'];
                $statusid = $dataf['statusid'];

                if ($statusid == '4'){
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Billing sudah ditutup ! Silahkan konfirmasi ke kasir !',
                    );
                    return $callback;
                    exit;
                }

                if ($lock == '1'){
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Billing sudah dilock ! Silahkan konfirmasi ke kasir !',
                    );
                    return $callback;
                    exit;
                }

                $this->db->query("INSERT INTO RawatInapSQL.dbo.[Inpatient Details] (NoMR,NoEpisode,NoRegRI,Dokter,NamaDokter,Kelas,VisitDate,[Product ID],NamaTindakan,Quantity,[Unit Price],TotalTarif,Discount,[Status ID],Category,PetugasOrder,Asuransi) 
                SELECT :nomr,:noeps,:noreg,:iddokter,:dokter,:idkelas,:date_tindakan_tambahan,:productid,[Product Name],:qty,:tarif,:totaltarif,:diskon,'1',CategoryProduct,:userinput,:totaltarif2 FROM RawatInapSQL.dbo.Tarif_RI where ID=:productid2
                -- VALUES
                -- (:nomr,:noeps,:noreg,:iddokter,:dokter,:idkelas,:date_tindakan_tambahan,:productid,:namaproduct,:qty,:tarif,:totaltarif,:diskon,'1',:kategoritarif,:userinput,:totaltarif)
                 "); 
                  $this->db->bind('nomr', $NoMR);
                  $this->db->bind('noeps', $NoEpisode);
                  $this->db->bind('noreg', $NoRegistrasi);
                  $this->db->bind('iddokter', $dokterpemeriksa);
                  $this->db->bind('dokter', $namadokter_addvisit);
                  $this->db->bind('idkelas', $IDKelas);
                  $this->db->bind('date_tindakan_tambahan', $date_tindakan_tambahan);
                  $this->db->bind('productid', $namatindakan);
                  $this->db->bind('qty', $qty_addvisit);
                  $this->db->bind('tarif', $tarif_satuan_addvisit);
                  $this->db->bind('totaltarif', $total_tarif_addvisit);
                  $this->db->bind('diskon', $diskon_addvisit);
                  $this->db->bind('userinput', $namauserx);
                  $this->db->bind('totaltarif2', $total_tarif_addvisit);
                  $this->db->bind('productid2', $namatindakan);

            }
       
            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Di Update !', // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => 'warning',
                'message' => $e,
            );
            return $callback;
        }
    }

    public function gogetBarcode($data)
    {
        try {
            $this->db->transaksi();
            $Barcode = $data['Barcode'];
            $id = $data['id'];

            $this->db->query("SELECT a.ID,QtyPakai,KantongKe,NamaTarifDarah JenisDarah,a.Keterangan,Selesai_Perawat,b.DateUpdate,Expired_Date as ED,Barcode
            FROM LaboratoriumSQL.dbo.UseBloodDetails a
            inner join LaboratoriumSQL.dbo.UseBloods b on a.IDHdr=b.ID
            Where a.Barcode=:Barcode and a.Batal='0'");
            $this->db->bind('Barcode', $Barcode);
            $data =  $this->db->single();
            if (!$data){
                $callback = array(
                    'status' => 'danger',
                    'message' => 'Barcode Tidak Ditemukan !!',
                );
                return $callback;
                exit;
            }

            if ($data['Selesai_Perawat'] == '1'){
                $callback = array(
                    'status' => 'danger',
                    'message' => 'Barcode Sudah Pernah Digunakan ! Silahkan Cek Kembali !',
                );
                return $callback;
                exit;
            }

            if ($data['ID'] != $id){
                $callback = array(
                    'status' => 'danger',
                    'message' => 'Barcode Tidak Valid Atas Hand Over Ini ! Silahkan Cek Kembali !',
                );
                return $callback;
                exit;
            }

            $pasing['ID'] = $data['ID'];
            $pasing['QtyPakai'] = $data['QtyPakai'];
            $pasing['KantongKe'] = $data['KantongKe'];
            $pasing['JenisDarah'] = $data['JenisDarah'];
            $pasing['ED'] = $data['ED'];
            $pasing['Barcode'] = $data['Barcode'];

            $callback = array(
                'status' => "success", // Set array nama 
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

    public function showBarcodeList($data)
    {
        try {
            $ID = $data['ID'];
                $this->db->query("SELECT ID,QtyPakai,KantongKe,NamaTarifDarah as JenisDarah,Keterangan,Selesai_Perawat,Expired_Date as ED,Barcode
                FROM LaboratoriumSQL.dbo.UseBloodDetails 
                Where ID=:ID and Batal='0' AND Selesai_Perawat='1'
                 "); 
                 $this->db->bind('ID', $ID);
                            $data =  $this->db->resultSet();
                            $rows = array();
                            $no = 1;
                            foreach ($data as $key) {
                                $pasing['No'] = $no++;
                                $pasing['ID'] = $key['ID'];
                                $pasing['Qty'] = $key['QtyPakai'];
                                $pasing['KantongKe'] = $key['KantongKe'];
                                $pasing['JenisDarah'] = $key['JenisDarah'];
                                $pasing['Keterangan'] = $key['Keterangan'];
                                $pasing['Selesai_Perawat'] = $key['Selesai_Perawat'];
                                $pasing['ED'] = $key['ED'];
                                $pasing['Barcode'] = $key['Barcode'];
                                $rows[] = $pasing;
                            }
                            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataTranfusibyNoMR($data)
    {
        try {
            $no_MR = $data['no_MR'];
            $this->db->query("SELECT a.ID,NamaTarifDarah,QtyPakai,a.DateCreate,a.UserFirst,Barcode,Selesai_Perawat,handover_bdrs_perawat_status as StatusHandOverBDRS,handover_bdrs_perawat_date as TglHandOverBDRS,Selesai_Tranfusi,QtyCC,DateConsume,UserConsumeId,HistoryIncompatibility,AutoControl,ScreeningAntiBody,b.Keterangan,NoRegistrasi,NoEpisode,[First Name] as username
            from LaboratoriumSQL.dbo.UseBloodDetails a
            inner join LaboratoriumSQL.dbo.UseBloods b on a.IDHdr=b.ID
            left join MasterDataSQL.dbo.Employees c on b.UserConsumeId=c.NoPIN
            where a.Batal='0' and b.Batal='0' and b.NomR=:no_MR");
            $this->db->bind('no_MR', $no_MR);

            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['NamaTarifDarah'] = $key['NamaTarifDarah'];
                $pasing['QtyPakai'] = $key['QtyPakai'];
                $pasing['DateCreate'] = $key['DateCreate'];
                $pasing['UserFirst'] = $key['UserFirst'];
                $pasing['Barcode'] = $key['Barcode'];
                $pasing['Selesai_Perawat'] = $key['Selesai_Perawat'];
                $pasing['StatusHandOverBDRS'] = $key['StatusHandOverBDRS'];
                $pasing['TglHandOverBDRS'] = $key['TglHandOverBDRS'];
                $pasing['Selesai_Tranfusi'] = $key['Selesai_Tranfusi'];
                $pasing['QtyCC'] = $key['QtyCC'];
                $pasing['DateConsume'] = $key['DateConsume'];
                $pasing['UserConsumeId'] = $key['UserConsumeId'];
                $pasing['HistoryIncompatibility'] = $key['HistoryIncompatibility'];
                $pasing['AutoControl'] = $key['AutoControl'];
                $pasing['ScreeningAntiBody'] = $key['ScreeningAntiBody'];
                $pasing['Keterangan'] = $key['Keterangan'];
                $pasing['NoRegistrasi'] = $key['NoRegistrasi'];
                $pasing['NoEpisode'] = $key['NoEpisode'];
                $pasing['username'] = $key['username'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
