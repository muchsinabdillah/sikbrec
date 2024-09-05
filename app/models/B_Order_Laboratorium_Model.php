<?php

class B_Order_Laboratorium_Model
{
    private $db;


    public function __construct()
    {
        $this->db = new Database;
    }
    public function createHeaderOrderLaboratorium($data, $createOrderNumber)
    {
        try {
            $idno_urutantbllablis = $createOrderNumber['idno_urutantbllablis']; 
            $no_urutantbllabRecID = $createOrderNumber['no_urutantbllabRecID'];
            $nulldata = "";
            $datatiga ="2";
            $datatigax ="3";
            $BIASA = "BIASA";
            $datasatu ="1";
            $datenowcreate = Utils::seCurrentDateTime();
            $this->db->transaksi();
            $datenowcreate = Utils::seCurrentDateTime(); 
            $session = SessionManager::getCurrentSession();
            $operator =  $session->IDEmployee;
            // WO_RADIOLOGI
            $this->db->query("INSERT INTO LaboratoriumSQL.dbo.tblLab (  [OrderCode], RecID, NoLAB, LabDate, 
                            Dokter,NoMR, NoEpisode , NoRegRI , KelasID, Operator,StatusID, [JenisOrder],Diagnosa,KeteranganKlinis) 
                            VALUES
                            ( :nulldata,:no_urutantbllabRecID,:idno_urutantbllablis,:datenowcreate,:Lab_Doctor,
                            :Lab_NoMR,:Lab_NoEpisode,:Lab_NORegistrasi,:datatiga,:datasatu,:datatiga2,:BIASA
                            ,:Lab_Daignosa,:Lab_Keterangan_Klinik)");
            $this->db->bind('no_urutantbllabRecID', $no_urutantbllabRecID);
            $this->db->bind('nulldata', $nulldata);
            $this->db->bind('idno_urutantbllablis', $idno_urutantbllablis);
            //$this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('datenowcreate', $data['Lab_TglKunjungan']);
            $this->db->bind('Lab_Doctor', $data['Lab_Doctor']);
            $this->db->bind('Lab_NoMR', $data['Lab_NoMR']);
            $this->db->bind('Lab_NoEpisode', $data['Lab_NoEpisode']);
            $this->db->bind('Lab_NORegistrasi', $data['Lab_NORegistrasi']);
            $this->db->bind('Lab_Daignosa', $data['Lab_Daignosa']);
            $this->db->bind('Lab_Keterangan_Klinik', $data['Lab_Keterangan_Klinik']);
            $this->db->bind('BIASA', $BIASA);
            $this->db->bind('datatigax', $datatigax);
            $this->db->bind('datatiga2', $datatiga);
            $this->db->bind('datasatu', $operator);
            $this->db->execute(); 
            $this->db->commit();
            $this->db->closeCon();
            $callback = array(
                'status' => 'success',
                'RecID' => $no_urutantbllabRecID,
                'NoLab' => $idno_urutantbllablis,

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
    public function addDetilTblLab($data, $LabId)
    {
        try {
            $LabId = $LabId;  
            $datasatu = "1"; 
            $this->db->transaksi(); 
            // DETIL LAB
            $this->db->query("INSERT INTO LaboratoriumSQL.dbo.tblLabDetail 
                            ( LabID, IdTes, Tarif, Rate, TarifKelas,kode_test,DokterJasa ) VALUES
                            (:LabId,:Lab_kodeTes_2,:Lab_Nilai,:datasatu,:Lab_Nilai2,
                            :Lab_kodeTes_kelompok,:Lab_Dokter_Operator)");
            $this->db->bind('LabId', $LabId);
            $this->db->bind('datasatu', $datasatu); 
            $this->db->bind('Lab_kodeTes_2', $data['Lab_kodeTes_2']);
            $this->db->bind('Lab_Nilai', $data['Lab_Nilai']);
            $this->db->bind('Lab_Nilai2', $data['Lab_Nilai']);
            $this->db->bind('Lab_kodeTes_kelompok', $data['Lab_kodeTes_kelompok']);
            $this->db->bind('Lab_Dokter_Operator', $data['Lab_Dokter_Operator']); 
            $this->db->execute();
            $this->db->commit();
            $this->db->closeCon();
            $callback = array(
                'status' => 'success',
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
    public function deleteDetilOrderLab($data)
    {
        try { 
            $datasatu = "1";
            $this->db->transaksi();
            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $namauserx = $session->name;
            // DETIL LAB Batal
            $this->db->query("UPDATE LaboratoriumSQL.dbo.tblLabDetail set 
                            status_ts='1',Batal='1'
                            where LabID in (SELECT LabID FROM LaboratoriumSQL.dbo.tblLab 
                            WHERE NoLab=:Lab_NoLab) and 
                            idTes=:NoDetilOrder ");
            $this->db->bind('Lab_NoLab', $data['Lab_NoLab']);
            $this->db->bind('NoDetilOrder', $data['NoDetilOrder']); 
            $this->db->execute();

            // DETIL LIS ORDER Batal
            $this->db->query("UPDATE LaboratoriumSQL.dbo.LIS_Order_detail set 
                                status_ts=:datasatu
                                where NoLab=:Lab_NoLab and kode_test in (
                                select kode_test from LaboratoriumSQL.dbo.tblLabDetail
                                where LabID in (SELECT LabID FROM LaboratoriumSQL.dbo.tblLab WHERE NoLab=:Lab_NoLab2) and 
                                idTes=:NoDetilOrder ) ");
            $this->db->bind('datasatu', $datasatu);
            $this->db->bind('Lab_NoLab', $data['Lab_NoLab']);
            $this->db->bind('Lab_NoLab2', $data['Lab_NoLab']);
            $this->db->bind('NoDetilOrder', $data['NoDetilOrder']);
            $this->db->execute();

            // INSERT TZ LOG
            $this->db->query("INSERT INTO  SysLog.dbo.TZ_Log_Button 
                            (noregistrasi,petugas_batal,tgl_batal,alasan_batal) VALUES
                            (:Lab_NoLab,:userid,:datenowcreate,:alasanbatal)");
            $this->db->bind('userid', $userid);
            $this->db->bind('Lab_NoLab', $data['Lab_NoLab']);
            $this->db->bind('alasanbatal', $data['alasanbatalDetil']);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->execute();

            // INSERT TZ LOG
            $this->db->query(" UPDATE LaboratoriumSQL.dbo.LIS_Order 
                            set IS_TAKEN='FALSE' where NoLAB=:Lab_NoLab"); 
            $this->db->bind('Lab_NoLab', $data['Lab_NoLab']); 
            $this->db->execute();

            //update fo_t_billing_1
            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 set 
                            PETUGAS_BATAL=:namauserx,BATAL='1',JAM_BATAL=:datenowcreate
                            where KODE_REF in (SELECT LabDetailID FROM LaboratoriumSQL.dbo.tblLab a
                            inner join LaboratoriumSQL.dbo.tbllabdetail b on a.LabID=b.LabID
                            WHERE a.NoLab=:Lab_NoLab and  idTes=:NoDetilOrder
                            )");
            $this->db->bind('Lab_NoLab', $data['Lab_NoLab']);
            $this->db->bind('NoDetilOrder', $data['NoDetilOrder']); 
            $this->db->bind('datenowcreate', $datenowcreate); 
            $this->db->bind('namauserx', $namauserx); 
            $this->db->execute();

            //update fo_t_billing_2
            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_2 set 
            PETUGAS_BATAL=:namauserx,BATAL='1',JAM_BATAL=:datenowcreate
FROM Billing_Pasien.dbo.FO_T_BILLING_2 c 
            inner join Billing_Pasien.dbo.FO_T_BILLING_1 d on c.NO_TRS_BILLING=d.NO_TRS_BILLING
            where d.KODE_REF in
            (SELECT LabDetailID FROM LaboratoriumSQL.dbo.tblLab a
            inner join LaboratoriumSQL.dbo.tbllabdetail b on a.LabID=b.LabID
            WHERE a.NoLab=:Lab_NoLab and  idTes=:NoDetilOrder)
           and c.KODE_TARIF=:NoDetilOrder2");
            $this->db->bind('Lab_NoLab', $data['Lab_NoLab']);
            $this->db->bind('NoDetilOrder', $data['NoDetilOrder']); 
            $this->db->bind('NoDetilOrder2', $data['NoDetilOrder']); 
            $this->db->bind('datenowcreate', $datenowcreate); 
            $this->db->bind('namauserx', $namauserx); 
            $this->db->execute();

            //UPDATE TOTAL KE FO_T_BILLING
            $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_BILLING
            SET TOTAL_TARIF=B.SUM_NILAI_TARIF,TOTAL_QTY=B.SUM_QTY,SUBTOTAL=B.SUM_SUB_TOTAL,SUBTOTAL_2=B.SUM_SUB_TOTAL_2,GRANDTOTAL=B.SUM_GRANDTOTAL
            FROM Billing_Pasien.DBO.FO_T_BILLING A 
            INNER JOIN
            (
                SELECT  NO_TRS_BILLING,SUM(NILAI_TARIF) AS SUM_NILAI_TARIF,SUM(QTY) AS SUM_QTY,SUM(SUB_TOTAL) AS SUM_SUB_TOTAL,SUM(SUB_TOTAL_2) AS SUM_SUB_TOTAL_2,
                SUM(GRANDTOTAL) AS SUM_GRANDTOTAL
                FROM Billing_Pasien.DBO.FO_T_BILLING_1
                WHERE NO_REGISTRASI  collate SQL_Latin1_General_CP1_CI_AS in (SELECT NoRegRI FROM LaboratoriumSQL.dbo.tbllab where NoLab=:Lab_NoLab)and Batal='0'
                GROUP BY NO_TRS_BILLING
            ) B
            ON A.NO_TRS_BILLING = B.NO_TRS_BILLING
            WHERE A.NO_REGISTRASI  collate SQL_Latin1_General_CP1_CI_AS in (SELECT NoRegRI FROM LaboratoriumSQL.dbo.tbllab where NoLab=:Lab_NoLab2)");
            $this->db->bind('Lab_NoLab', $data['Lab_NoLab']);
            $this->db->bind('Lab_NoLab2', $data['Lab_NoLab']);
            $this->db->execute();

            $this->db->commit();
            $this->db->closeCon();
            $callback = array(
                'status' => 'success',
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
    public function getListPemeriksaanLaboratoriumByNoLab($data)
    {
        try { 
            $this->db->query("SELECT LabID FROM LaboratoriumSQL.dbo.tblLab WHERE NoLab=:Lab_NoLab");
            $this->db->bind('Lab_NoLab',   $data['Lab_NoLab']); 
            $data =  $this->db->single();
            $LabID = $data['LabID'];
            $isTrue ="1";
            $isFalse = "0";
            $this->db->query("SELECT c.LabDetailID,a.IDTes, a.KodeTes, a.KodeKelompok,a.NamaTes,  
                cast(replace(a.Tarif, '.00','') as integer) as Tarif, a.TJamsostek, a.TGakin, b.Kelompok, a.InLevel
                FROM LaboratoriumSQL.dbo.tblLabDetail c 
                inner join LaboratoriumSQL.dbo.tblGrouping a on c.idTes = a.idTes
                INNER JOIN LaboratoriumSQL.dbo.tblTestLab b ON a.KodeTes = b.KodeTes
                WHERE c.LabID=:LabID  and a.InLevel=:isTrue  and c.Batal=:isFalse
                ORDER BY c.LabDetailID desc");
            $this->db->bind('LabID',   $LabID);
            $this->db->bind('isTrue',   $isTrue);
            $this->db->bind('isFalse',   $isFalse); 
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $row) {
                $pasing['No'] = $no;
                $pasing['IDTes'] = $row['IDTes'];
                $pasing['NamaTes'] = $row['NamaTes'];
                $pasing['Tarif'] =  $row['Tarif']; 
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    function showregistrasibyMR($dtReg)
    {
        $callback = array(
            'status' => 'success',
            'PatientName' => $dtReg['PatientName'],
            'Gander' => $dtReg['Gander'],
            'Date_of_birth' => $dtReg['Date_of_birth'],
            'Address' => $dtReg['Address'],
            'PatientType' => $dtReg['PatientType'],
            'CODEUNIT' => $dtReg['CODEUNIT'],
            'NamaUnit' => $dtReg['NamaUnit'],
            'Doctor_1' => $dtReg['Doctor_1'],
            'First_Name' => $dtReg['First_Name'],
            'NoMR' => $dtReg['NoMR'],
            'NoEpisode' => $dtReg['NoEpisode'],
            'NoRegistrasi' => $dtReg['NoRegistrasi'],
            'Date_of_birth_replace' => str_replace("-", "", $dtReg['Date_of_birth']),
            'datenowcreate' => Utils::seCurrentDateTime(),
            'TRIGGER_DTTM' => Utils::idtrsByDatetime(),
            'DOB' => date('Ymd', strtotime($dtReg['Date_of_birth'])),
        );
        return $callback;
    }
    function createOrderNumberLIS($data2)
    {
        try{
            $this->db->query("SELECT  max(LabID) as urutantbllab, max(RecID) as urutantbllabRecID from LaboratoriumSQL.dbo.tblLab ");
            $data =  $this->db->single();
            $no_urutantbllabRecID = $data['urutantbllabRecID'];
            $no_urutantbllabRecID++;
            //$datenowlis = Utils::idtrsByDateOnly();
            $datenowlis = date('dmy', strtotime($data2['Lab_TglKunjungan']));
            $this->db->query("SELECT  max(NoLab) as urutantbllablis from LaboratoriumSQL.dbo.tblLab WHERE left([NoLAB],6)=:datenowlis ");
            $this->db->bind('datenowlis',   $datenowlis);
            $data =  $this->db->single();
            $no_urutantbllablis = $data['urutantbllablis'];
            $substringlis = substr($no_urutantbllablis, 6);
            if ($substringlis == null) {
                $substringlis = 0;
            }
            $substringlis++;
            if (strlen($substringlis) == 1) {
                $nourutfixLis = "000" . $substringlis;
            } else if (strlen($substringlis) == 2) {
                $nourutfixLis = "00" . $substringlis;
            } else if (strlen($substringlis) == 3) {
                $nourutfixLis = "0" . $substringlis;
            } else if (strlen($substringlis) == 4) {
                $nourutfixLis = $substringlis;
            }
            $idno_urutantbllablis = $datenowlis . $nourutfixLis;
            $callback = array(
                'status' => 'success',
                'idno_urutantbllablis' => $idno_urutantbllablis,
                'no_urutantbllabRecID' => $no_urutantbllabRecID,
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
    function validasiDoubleOrderLabDetil($data)
    {
        try{
            $nulldata ="0";
            $this->db->query("SELECT *FROM LaboratoriumSQL.dbo.tblLabDetail WHERE IdTes=:Lab_kodeTes_2
                            AND LabID in (SELECT LabID FROM LaboratoriumSQL.dbo.tblLab 
                            WHERE NoLab=:Lab_NoLab) and status_ts =:nulldata ");
            $this->db->bind('Lab_kodeTes_2', $data['Lab_kodeTes_2']);
            $this->db->bind('Lab_NoLab', $data['Lab_NoLab']);
            $this->db->bind('nulldata', $nulldata);
            $data =  $this->db->single();
            if($data){
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Double Pemeriksaan !',
                    );
                    return $callback;
                    exit;
            } 
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
    function validasiHasOrderTblLabDetil($data)
    {
        try {
            $nulldata = "0";
            $this->db->query("SELECT *from LaboratoriumSQL.dbo.tblLabDetail where LabID in (
                            select LabID from LaboratoriumSQL.dbo.tblLab where NoLAB=:Lab_NoLab
                            )  and Batal=:nulldata"); 
            $this->db->bind('Lab_NoLab', $data['Lab_NoLab']);
            $this->db->bind('nulldata', $nulldata); 
            $data =  $this->db->single();
            $rowcount = $this->db->rowCount(); 
            if ($rowcount=="0") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Pemeriksaan Masih Kosong, Cek Kembali Data Anda Sebelum disimpan !',
                );
                return $callback;
                exit;
            }
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
    function validasiHasReceiveOrderLabDetil($data)
    {
        try {
            $isture="1";
            $this->db->query("SELECT *FROM LaboratoriumSQL.dbo.tblLab WHERE NoLAB =:Lab_NoLab   
                            AND  Receive_st=:isture");
            $this->db->bind('Lab_NoLab', $data['Lab_NoLab']);
            $this->db->bind('isture', $isture);
            $data =  $this->db->single();
            if ($data) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Pemeriksaan Sudah di Receive, buat Trs Baru untuk entri Pemeriksaan Lainnya !', 
                );
                return $callback;
                exit;
            }
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
    function validationHasResultLab($data)
    {
        try {
            $isture = "1";
            $this->db->query("SELECT *FROM LaboratoriumSQL.dbo.LIS_Order WHERE NoLab=:Lab_NoLab
                            AND Result=:isture");
            $this->db->bind('Lab_NoLab', $data['Lab_NoLab']);
            $this->db->bind('isture', $isture);
            $data =  $this->db->single();
            if ($data) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Pemeriksaan Sudah ada Hasil, anda tidak bisa membatalkan !',
                );
                return $callback;
                exit;
            }
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
    function getDataTblLabHeaderByNoLab($data)
    {
        try {
             
            $this->db->query("SELECT LabID,NoLab FROM LaboratoriumSQL.dbo.tblLab WHERE NoLab=:Lab_NoLab");
            $this->db->bind('Lab_NoLab', $data['Lab_NoLab']); 
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success', // Set array status dengan success
                'LabID' => $data['LabID'], // Set array status dengan success
                'NoLab' => $data['NoLab'], // Set array status dengan success
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
    function getTblLisOrderHeaderbyNoLab($data)
    {
        try {
            $nulldata = "0";
            $this->db->query("SELECT NoLab,NoEpisode,NoRegistrasi FROM LaboratoriumSQL.dbo.LIS_Order WHERE NoLab=:Lab_NoLab
                            and status_ts=:nulldata");
            $this->db->bind('Lab_NoLab', $data['Lab_NoLab']);
            $this->db->bind('nulldata', $nulldata); 
            $data =  $this->db->single(); 
                $callback = array(
                    'status' => 'success', // Set array status dengan success
                    'NoLab' => $data['NoLab'], // Set array status dengan success
                    'NoEpisode' => $data['NoEpisode'], // Set array status dengan success
                    'NoRegistrasi' => $data['NoRegistrasi'], // Set array status dengan success
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
    function getDataPasienbyTblLabHeader($data)
    {
        try { 
            $this->db->query("SELECT c.PatientName, CASE WHEN c.Gander='L' then 'M' ELSE 'F' END AS Gander, 
                            replace(CONVERT(VARCHAR(11), c.Date_of_birth, 111), '/','-') as Date_of_birth,c.Address,
                            case when a.PatientType='1' THEN 'PRIBADI' WHEN a.PatientType='2' THEN 'ASURANSI' WHEN a.PatientType='5' THEN 'PERUSAHAAN' END 
                            AS  PatientType,d.CODEUNIT,d.NamaUnit,a.Doctor_1,e.First_Name, a.NoMR,a.NoEpisode,a.NoRegistrasi
                            from PerawatanSQL.dbo.Visit a
                            inner join LaboratoriumSQL.dbo.tblLab b
                            on a.NoRegistrasi = b.NoRegRI
                            inner join MasterdataSQL.dbo.Admision c
                            on c.NoMR = a.NoMR
                            inner join MasterdataSQL.dbo.MstrUnitPerwatan d
                            on d.ID=a.Unit
                            inner join MasterdataSQL.dbo.Doctors e
                            on e.ID=a.Doctor_1
                            where b.NoLab=:Lab_NoLab
                            UNION ALL
                            SELECT c.PatientName, CASE WHEN c.Gander='L' then 'M' ELSE 'F' END AS Gander, 
                            replace(CONVERT(VARCHAR(11), c.Date_of_birth, 111), '/','-') as Date_of_birth,c.Address,
                            case when a.PatientType='1' THEN 'PRIBADI' WHEN a.PatientType='2' THEN 'ASURANSI' WHEN a.PatientType='5' THEN 'PERUSAHAAN' END 
                            AS  PatientType,d.CODEUNIT,d.NamaUnit,a.Doctor_1,e.First_Name, a.NoMR,a.NoEpisode,a.NoRegistrasi
                            from PerawatanSQL.dbo.Visit a
                            inner join LaboratoriumSQL.dbo.tblLab b
                            on a.NoRegistrasi = b.NoRegRI
                            inner join MasterdataSQL.dbo.Admision_walkin c
                            on c.NoMR = a.NoMR
                            inner join MasterdataSQL.dbo.MstrUnitPerwatan d
                            on d.ID=a.Unit
                            inner join MasterdataSQL.dbo.Doctors e
                            on e.ID=a.Doctor_1
                            where b.NoLab=:Lab_NoLab2
                            UNION ALL
                            SELECT c.PatientName, CASE WHEN c.Gander='L' then 'M' ELSE 'F' END AS Gander, 
                            replace(CONVERT(VARCHAR(11), c.Date_of_birth, 111), '/','-') as Date_of_birth,c.Address,
                            case when a.TypePatient='1' THEN 'PRIBADI' WHEN a.TypePatient='2' THEN 'ASURANSI' WHEN a.TypePatient='5' THEN 'PERUSAHAAN' END 
                            AS  PatientType,'RI' CODEUNIT,'Laboratorium' as NamaUnit,drPenerima as Doctor_1,e.First_Name, a.NoMR,a.NoEpisode,a.NoRegRI as NoRegistrasi
                            from RawatInapSQL.dbo.Inpatient a
                            inner join LaboratoriumSQL.dbo.tblLab b
                            on a.NoRegRI = b.NoRegRI
                            inner join MasterdataSQL.dbo.Admision c
                            on c.NoMR = a.NoMR
                            inner join MasterdataSQL.dbo.Doctors e
                            on e.ID=a.drPenerima
                            where b.NoLab=:Lab_NoLab3
                            ");
            $this->db->bind('Lab_NoLab', $data['Lab_NoLab']); 
            $this->db->bind('Lab_NoLab2', $data['Lab_NoLab']); 
            $this->db->bind('Lab_NoLab3', $data['Lab_NoLab']); 
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success', // Set array status dengan success
                'PatientName' => $data['PatientName'], // Set array status dengan success
                'Gander' => $data['Gander'], // Set array status dengan success
                'Date_of_birth' => $data['Date_of_birth'], // Set array status dengan success
                'Address' => $data['Address'], // Set array status dengan success
                'PatientType' => $data['PatientType'], // Set array status dengan success
                'CODEUNIT' => $data['CODEUNIT'], // Set array status dengan success
                'NamaUnit' => $data['NamaUnit'], // Set array status dengan success
                'Doctor_1' => $data['Doctor_1'], // Set array status dengan success
                'First_Name' => $data['First_Name'], // Set array status dengan success
                'NoMR' => $data['NoMR'], // Set array status dengan success
                'NoEpisode' => $data['NoEpisode'], // Set array status dengan success
                'NoRegistrasi' => $data['NoRegistrasi'], // Set array status dengan success
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
    public function createFinsihOrderLab($data, $dataTblLabHdr, $update)
    {
        try { 
            $this->db->transaksi();
            //Data Pasien
            $PatientName = $dataTblLabHdr['PatientName'];
            $Gander = $dataTblLabHdr['Gander'];
            $Date_of_birth = $dataTblLabHdr['Date_of_birth'];
            $Address = $dataTblLabHdr['Address'];
            $PatientType = $dataTblLabHdr['PatientType'];
            $CODEUNIT = $dataTblLabHdr['CODEUNIT'];
            $NamaUnit = $dataTblLabHdr['NamaUnit'];
            $Doctor_1 = $dataTblLabHdr['Doctor_1'];
            $First_Name = $dataTblLabHdr['First_Name'];
            $NoMR = $dataTblLabHdr['NoMR'];
            $NoEpisode = $dataTblLabHdr['NoEpisode'];
            $NoRegistrasi = $dataTblLabHdr['NoRegistrasi'];  
            $datenowcreate = Utils::seCurrentDateTime(); 
            $session = SessionManager::getCurrentSession();
            $namauser = $session->name;
            $biasa="BIASA";
            $status_ts = "0";
            $batal="0";
            $nulldata = "";
            $taken ="FALSE";
            $Lab_Nolab = $data['Lab_NoLab'];

            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $operator =  $session->IDEmployee;

            
             if ($data['is_approved'] == '1'){
                    //update status
                    $this->db->query("UPDATE LaboratoriumSQL.dbo.tbllab set StatusID='3' where NoLab=:nolab");
                    // $this->db->bind('StatusID', '3'); 
                     $this->db->bind('nolab', $Lab_Nolab); 
                    $this->db->execute();
             }
            

            if($update=="update"){ 
                if ($data['is_approved'] == '1'){
                        $this->db->query("INSERT INTO LaboratoriumSQL.dbo.LIS_Order_detail ( NoMR, NoEpisode, NoLAB, kode_test, 
                                        nama_test, is_cito,dateInput,dokterOperator ) 
                                        SELECT tblLab.NoMR, tblLab.NoEpisode, tblLab.NoLAB, tblGrouping.KodeKelompok, tblGrouping.NamaTes,
                                        :biasa,:datenowcreate,:Lab_Dokter_Operator 
                                        FROM LaboratoriumSQL.dbo.tblLabDetail 
                                        INNER JOIN LaboratoriumSQL.dbo.tblLab ON tblLabDetail.LabID = tblLab.LabID
                                        INNER JOIN LaboratoriumSQL.dbo.tblGrouping ON tblLabDetail.idTes = tblGrouping.IDTes
                                        WHERE tblLab.NoLAB=:Lab_NoLab AND tblGrouping.KodeKelompok Is Not Null 
                                    and tblLabDetail.kode_test not in (SELECT kode_test FROM LaboratoriumSQL.dbo.LIS_Order_detail where NoLAB=:Lab_NoLab2 and status_ts=:status_ts)
                                    and tblLabDetail.Batal=:batal ORDER BY tblLab.NoLAB ");
                        $this->db->bind('datenowcreate', $datenowcreate);
                        $this->db->bind('Lab_Dokter_Operator', $data['Lab_Dokter_Operator']);
                        $this->db->bind('biasa', $biasa);
                        $this->db->bind('Lab_NoLab', $data['Lab_NoLab']); 
                        $this->db->bind('Lab_NoLab2', $data['Lab_NoLab']); 
                        $this->db->bind('status_ts', $status_ts);
                        $this->db->bind('batal', $batal); 
                        $this->db->execute(); 
                        $this->db->query("UPDATE LaboratoriumSQL.dbo.LIS_Order set IS_TAKEN=:taken where NoLAB=:Lab_NoLab"); 
                        $this->db->bind('Lab_NoLab', $data['Lab_NoLab']);
                        $this->db->bind('taken', $taken);
                        $this->db->execute();
                 }

                //GET No TRS Billing
                $this->db->query("SELECT  TOP 1 NO_TRS_BILLING
                FROM Billing_Pasien.dbo.FO_T_BILLING_1 a
                inner join LaboratoriumSQL.dbo.tbllabdetail b on a.KODE_REF=b.LabDetailID
                inner join LaboratoriumSQL.dbo.tbllab c on b.LabID=c.LabID
                WHERE c.NoLAB=:Lab_NoLab");
                $this->db->bind('Lab_NoLab', $data['Lab_NoLab']);
                $data =  $this->db->single();
                $notrsbill = $data['NO_TRS_BILLING'];


            }else{
                if ($data['is_approved'] == '1'){
                    $this->db->query("INSERT INTO LaboratoriumSQL.dbo.LIS_Order_detail ( NoMR, NoEpisode, NoLAB, kode_test, 
                                        nama_test, is_cito ,dateInput,dokterOperator ) 
                                        SELECT tblLab.NoMR, tblLab.NoEpisode, tblLab.NoLAB, tblGrouping.KodeKelompok, tblGrouping.NamaTes, 
                                        :biasa,:datenowcreate,:Lab_Dokter_Operator 
                                        FROM LaboratoriumSQL.dbo.tblLabDetail 
                                        INNER JOIN LaboratoriumSQL.dbo.tblLab ON tblLabDetail.LabID = tblLab.LabID
                                        INNER JOIN LaboratoriumSQL.dbo.tblGrouping ON tblLabDetail.idTes = tblGrouping.IDTes
                                        WHERE NoLAB=:Lab_NoLab AND tblGrouping.KodeKelompok Is Not Null and tblLabDetail.Batal='0'
                                        ORDER BY tblLab.NoLAB");
                    $this->db->bind('datenowcreate', $datenowcreate);
                    $this->db->bind('Lab_Dokter_Operator', $data['Lab_Dokter_Operator']);
                    $this->db->bind('biasa', $biasa);
                    $this->db->bind('Lab_NoLab', $data['Lab_NoLab']); 
                    $this->db->execute();

                    $this->db->query("INSERT INTO LaboratoriumSQL.dbo.LIS_Order (NoMR,NoEpisode,NoRegistrasi,NoLAB ,
                                        Title,pname,sex,birth_dt,Address,ptype,
                                        locid,locname,clinician_id,
                                        clinician_name,request_dt, user_order,diag_klinik,ketklinis,asuransi) VALUES
                                        ( :NoMR,:NoEpisode,:NoRegistrasi,:Lab_NoLab ,
                                        :nulldata,:PatientName,:Gander,:Date_of_birth,:Addressa,:PatientType,
                                        :CODEUNIT,:NamaUnit,:Doctor_1, 
                                        :First_Name ,:datenowcreate, :namauser,:Lab_Daignosa,
                                        :Lab_Keterangan_Klinik,:Lab_Namajaminan )");
                    $this->db->bind('NoMR', $NoMR);
                    $this->db->bind('NoEpisode', $NoEpisode);
                    $this->db->bind('NoRegistrasi', $NoRegistrasi);
                    $this->db->bind('nulldata', $nulldata);
                    $this->db->bind('PatientName', $PatientName);
                    $this->db->bind('Gander', $Gander);
                    $this->db->bind('Date_of_birth', $Date_of_birth);
                    $this->db->bind('Addressa', $Address);
                    $this->db->bind('PatientType', $PatientType);
                    $this->db->bind('CODEUNIT', $CODEUNIT);
                    $this->db->bind('NamaUnit', $NamaUnit);
                    $this->db->bind('Doctor_1', $Doctor_1);
                    $this->db->bind('First_Name', $First_Name);
                    $this->db->bind('datenowcreate', $data['Lab_TglKunjungan']);
                    $this->db->bind('namauser', $namauser); 
                    $this->db->bind('Lab_NoLab', $data['Lab_NoLab']);
                    $this->db->bind('Lab_Daignosa', $data['Lab_Daignosa']);
                    $this->db->bind('Lab_Keterangan_Klinik', $data['Lab_Keterangan_Klinik']);
                    $this->db->bind('Lab_Namajaminan', $data['Lab_Namajaminan']);
                    $this->db->execute();
                }

                $pesan = 'Approve Lab Baru '.$NoRegistrasi.' / '.$NoMR.' / '.$PatientName;
                $this->db->query(" INSERT INTO  MasterdataSQL.dbo.A_NOTIFIKASI
                              (jam_transaksi,tgl_transaksi,unit_tujuan,pesan,
                              sudahbaca,flag_notif_show,reff_no) SELECT :jam_transaksi,:tgl_transaksi,:unit_tujuan,:pesan,
                                :sudahbaca,:flag_notif_show,LabID
                                FROM LaboratoriumSQL.dbo.tbllab where NoLab=:Lab_Nolab ");
                $this->db->bind('jam_transaksi', date('H:i:s', strtotime($datenowcreate)));
                $this->db->bind('tgl_transaksi', date('d/m/Y', strtotime($datenowcreate)));
                $this->db->bind('unit_tujuan', '9');
                $this->db->bind('pesan', $pesan);
                $this->db->bind('sudahbaca', 'N');
                $this->db->bind('flag_notif_show', '1');
                $this->db->bind('Lab_Nolab', $Lab_Nolab);
                $this->db->execute();

                 //Generate no trs billing
                        
                 $datenowx = Utils::datenowcreateNotFull();
                 $datenow = date('dmy', strtotime($datenowcreate));

                 $this->db->query("SELECT  TOP 1 NO_TRS_BILLING,right( REPLACE(NO_TRS_BILLING,'-','0')  ,5) as urut
                 FROM Billing_Pasien.dbo.FO_T_BILLING  WHERE  
                 replace(CONVERT(VARCHAR(11), TGL_BILLING, 111), '/','-')=:datenow2  ORDER BY urut DESC");
                 $this->db->bind('datenow2', $datenowx);
                 $data =  $this->db->single();
                 //no urut reg
                 $nexturut = $data['urut'];
                 $nexturut++;

                 $nourutfix = Utils::generateAutoNumber($nexturut);
                 $kodeawal = "BIL";
                 $notrsbill = $kodeawal . $datenow . $nourutfix;
                //GET Data from tabel visit
                 $this->db->query("SELECT  Unit,PatientType,case when PatientType='2' then Asuransi else Perusahaan end as perusahaanid
                 FROM PerawatanSQL.dbo.Visit  WHERE  
                 NoRegistrasi=:NoRegistrasi
                 UNION ALL
                 SELECT 0 as Unit, TypePatient as PatientType,Case when TypePatient='2' then IDAsuransi else IDJPK end as perusahaanid
                 FROM RawatInapSQL.dbo.Inpatient WHERE
                 NoRegRI=:NoRegistrasi2
                 ");
                 $this->db->bind('NoRegistrasi', $NoRegistrasi);
                 $this->db->bind('NoRegistrasi2', $NoRegistrasi);
                 $dataf =  $this->db->single();
                 $IdGrupPerawatan = $dataf['Unit'];
                 $JenisBayar = $dataf['PatientType'];
                 $perusahaanid = $dataf['perusahaanid'];
                 
                 // insert ke tabel FO_T_Billing
                     $this->db->query("INSERT INTO Billing_Pasien.dbo.FO_T_BILLING
                     ([NO_TRS_BILLING],[TGL_BILLING],[PETUGAS_ENTRY],[NO_MR],[NO_EPISODE],[NO_REGISTRASI],[UNIT],[GROUP_JAMINAN],[KODE_JAMINAN],[TOTAL_TARIF],[TOTAL_QTY],[SUBTOTAL],[TOTAL_DISCOUNT],[TOTAL_DISCOUNT_RP],[SUBTOTAL_2],[GRANDTOTAL],[BATAL],[FB_CLOSE_KEUANGAN],[FB_VERIF_JURNAL])
                        VALUES
                     (:notrsbill,:datenowx,:namauserx,:NoMrfix,:NoEpisode,:nofixReg,:IdGrupPerawatan,:JenisBayar,:perusahaanid,:totaltarif,:totalqty,:subtotal,:totaldiscount,:totaldiscountrp,:subtotal2,:grandtotal,:batal,:closekeuangan,:verifkeuangan)");
                     
                     $this->db->bind('notrsbill', $notrsbill);
                     $this->db->bind('datenowx', $datenowx);
                     $this->db->bind('namauserx', $namauserx);
                     $this->db->bind('NoMrfix', $NoMR);
                     $this->db->bind('NoEpisode', $NoEpisode);
                     $this->db->bind('nofixReg', $NoRegistrasi);
                     $this->db->bind('IdGrupPerawatan', $IdGrupPerawatan);
                     $this->db->bind('JenisBayar', $JenisBayar);
                     $this->db->bind('perusahaanid', $perusahaanid);
                     $this->db->bind('totaltarif', 0);
                     $this->db->bind('totalqty', 0);
                     $this->db->bind('subtotal', 0);
                     $this->db->bind('totaldiscount', 0);
                     $this->db->bind('totaldiscountrp', 0);
                     $this->db->bind('subtotal2', 0);
                     $this->db->bind('grandtotal', 0);
                     $this->db->bind('batal', 0);
                     $this->db->bind('closekeuangan', 0);
                     $this->db->bind('verifkeuangan', 0);
                     $this->db->execute();
                     //$notrsbill = $this->db->GetLastID();

                

               
            }
            // insert ke tabel FO_T_Billing_1
                // Insert Laboratorium
                $this->db->query("INSERT INTO  Billing_Pasien.dbo.FO_T_BILLING_1
                (ID_BILL,[NO_TRS_BILLING],[TGL_BILLING] ,[PETUGAS_ENTRY],[NO_MR],[NO_EPISODE],[NO_REGISTRASI],[KODE_TARIF],[UNIT],[GROUP_JAMINAN],[KODE_JAMINAN],[NAMA_TARIF],[GROUP_TARIF],[KD_KELAS],[QTY],[NILAI_TARIF],[SUB_TOTAL],[DISC],[DISC_RP],[SUB_TOTAL_2],[GRANDTOTAL],[KODE_REF],[KD_DR],[NM_DR],[BATAL],[PETUGAS_BATAL],[GROUP_ENTRI])
                SELECT '$Lab_Nolab',NO_TRS_BILLING , '$datenowcreate' as datenow,'$namauserx' as namauserx,'$NoMR' AS NoMR, '$NoEpisode' AS xNoEpisode,'$NoRegistrasi' as NoReg,a.idTes,
                UNIT,c.GROUP_JAMINAN,KODE_JAMINAN, NamaTes,'Laboratorium' as lab, null as kdkelas, 1 as Qty, a.TarifKelas, a.TarifKelas, ISNULL(a.disc,0), ISNULL(a.DiscountRP,0), a.Tarif, a.Tarif,a.LabDetailID, a.DokterJasa, e.First_Name, 0 as batal,null as petugasbatal,'LABORATORIUM'
                FROM LaboratoriumSQL.dbo.tblLabDetail a
                INNER JOIN LaboratoriumSQL.dbo.tblLab b ON a.LabID = b.LabID
                INNER JOIN Billing_Pasien.dbo.FO_T_BILLING c on b.NoRegRI collate SQL_Latin1_General_CP1_CI_AS=c.NO_REGISTRASI collate SQL_Latin1_General_CP1_CI_AS
                INNER JOIN LaboratoriumSQL.dbo.tblGrouping d ON a.idTes = d.IDTes
                LEFT JOIN MasterDataSQL.dbo.Doctors e on a.DokterJasa=e.ID
                WHERE NoLAB=:Lab_NoLab AND d.KodeKelompok Is Not Null and c.NO_TRS_BILLING=:notrsbill and
                        a.Batal='0' and a.LabDetailID not in (SELECT KODE_REF FROM Billing_Pasien.dbo.FO_T_BILLING_1 where Batal='0' and NO_TRS_BILLING=:notrsbill2)
                            ORDER BY b.NoLAB");
                $this->db->bind('Lab_NoLab', $Lab_Nolab); 
                $this->db->bind('notrsbill', $notrsbill); 
                $this->db->bind('notrsbill2', $notrsbill); 
                $this->db->execute();

                //Insert ke tabel FO_T_Billing_2
                $this->db->query("INSERT INTO Billing_Pasien.DBO.FO_T_BILLING_2
                SELECT '$Lab_Nolab' as ID_BILL,A.NO_TRS_BILLING AS NO_TRS_BILLING,A1.KODE_TARIF,B.KD_TIPE_PDP as Kode_komponen,A1.UNIT AS UNIT, A1.GROUP_JAMINAN AS GROUP_JAMINAN, A1.KODE_JAMINAN AS KODE_JAMINAN, 
                A1.NAMA_TARIF AS NAMA_TARIF, 
                A1.GROUP_TARIF AS GROUP_TARIF, A1.KD_KELAS as KELAS,A1.QTY AS QTY, 
                A1.NILAI_TARIF AS NILAI_TARIF  ,
                A1.NILAI_TARIF*A1.QTY  AS SUBTOTAL,
                A1.DISC AS DISC,
                (A1.NILAI_TARIF-((A1.NILAI_TARIF*A1.DISC)/100)) AS DISC_RP,
                ((A1.NILAI_TARIF*A1.QTY)-(((A1.NILAI_TARIF*A1.QTY)*A1.DISC)/100))   SUB_TOTAL_PDP_2,
                (CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN ((((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' THEN ((b.NILAI_FIX*A1.QTY*DISC)/100)*A1.QTY END ) NILAI_DISKON_PDP,
                (CASE WHEN CX.KD_JENIS_PDP='PROSEN'  THEN (((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY)-(((A1.NILAI_TARIF*B.NILAI_PROSEN)*A1.QTY*DISC)/100))   WHEN  CX.KD_JENIS_PDP='FIX' THEN (b.NILAI_FIX*A1.QTY)-((b.NILAI_FIX*A1.QTY*DISC)/100)*A1.QTY END ) as NILAI_PDP,
                A1.KD_DR AS KD_DR, '' NM_DR,b.NILAI_PROSEN,'0' AS BATAL,'' PETUGAS_BATAL, '' AS JAM_BATAL, B.KD_POSTING AS KD_POSTING, b.KD_POSTING_DISC as kd_posting_diskon,null as ID_TR_TARIF_PAKET
                 FROM Billing_Pasien.DBO.FO_T_BILLING A
                 inner join Billing_Pasien.dbo.FO_T_BILLING_1 A1
                 ON A.NO_TRS_BILLING = A1.NO_TRS_BILLING
                 INNER JOIN LaboratoriumSQL.dbo.tblGrouping CC 
                 ON CC.IDTes = A1.KODE_TARIF
                 INNER JOIN Keuangan.DBO.BO_M_PDP2 B
                ON CC.KD_PDP collate SQL_Latin1_General_CP1_CI_AS = B.KD_PDP collate SQL_Latin1_General_CP1_CI_AS
                INNER JOIN Keuangan.DBO.BO_M_PDP CX
                ON CX.KD_PDP = B.KD_PDP
                WHERE A1.GROUP_ENTRI='LABORATORIUM' and a.BATAL='0' and A1.BATAL='0' and B.KD_TIPE_PDP='RS01' and a.NO_TRS_BILLING=:notrsbill and
				 A1.KODE_TARIF not in (select KODE_TARIF from Billing_Pasien.dbo.FO_T_BILLING_2 where NO_TRS_BILLING=:notrsbill2 and Batal='0')");
                $this->db->bind('notrsbill', $notrsbill); 
                $this->db->bind('notrsbill2', $notrsbill); 
                $this->db->execute();

             //UPDATE TOTAL KE FO_T_BILLING
             $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_BILLING
             SET TOTAL_TARIF=B.SUM_NILAI_TARIF,TOTAL_QTY=B.SUM_QTY,SUBTOTAL=B.SUM_SUB_TOTAL,SUBTOTAL_2=B.SUM_SUB_TOTAL_2,GRANDTOTAL=B.SUM_GRANDTOTAL,
             FB_VERIF_JURNAL='0' 
             FROM Billing_Pasien.DBO.FO_T_BILLING A 
             INNER JOIN
             (
                 SELECT  NO_TRS_BILLING,SUM(NILAI_TARIF) AS SUM_NILAI_TARIF,SUM(QTY) AS SUM_QTY,SUM(SUB_TOTAL) AS SUM_SUB_TOTAL,SUM(SUB_TOTAL_2) AS SUM_SUB_TOTAL_2,
                 SUM(GRANDTOTAL) AS SUM_GRANDTOTAL
                 FROM Billing_Pasien.DBO.FO_T_BILLING_1
                 WHERE NO_REGISTRASI=:noreg and Batal='0'
                 GROUP BY NO_TRS_BILLING
             ) B
             ON A.NO_TRS_BILLING = B.NO_TRS_BILLING
             WHERE A.NO_REGISTRASI=:noreg2 AND A.NO_TRS_BILLING=:notrsbill
             ");
             $this->db->bind('noreg', $NoRegistrasi);
             $this->db->bind('noreg2', $NoRegistrasi);
             $this->db->bind('notrsbill', $notrsbill); 
             $this->db->execute();

            

            $this->db->commit();
            $this->db->closeCon();
            $callback = array(
                'status' => 'success', 

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
    public function getListOrderLaboratoriumbyNoReg($data)
    {
        try {
            $searchbox = $data['searchbox'];
            $this->db->query("SELECT c.PatientName, CASE WHEN c.Gander='L' then 'M' ELSE 'F' END AS Gander, 
                            replace(CONVERT(VARCHAR(11), c.Date_of_birth, 111), '/','-') as Date_of_birth,c.Address,
                            case when a.PatientType='1' THEN 'PRIBADI' WHEN a.PatientType='2' THEN 'ASURANSI' WHEN a.PatientType='5' THEN 'PERUSAHAAN' END 
                            AS  PatientType,d.CODEUNIT,d.NamaUnit,a.Doctor_1,e.First_Name, a.NoMR,a.NoEpisode,a.NoRegistrasi,b.NoLab,b.LabID,b.StatusID
                            from PerawatanSQL.dbo.Visit a
                            inner join LaboratoriumSQL.dbo.tblLab b
                            on a.NoRegistrasi = b.NoRegRI
                            inner join MasterdataSQL.dbo.Admision c
                            on c.NoMR = a.NoMR
                            inner join MasterdataSQL.dbo.MstrUnitPerwatan d
                            on d.ID=a.Unit
                            inner join MasterdataSQL.dbo.Doctors e
                            on e.ID=a.Doctor_1
                            where a.NoRegistrasi=:searchbox and b.Batal='0'
                            UNION ALL
                            SELECT c.PatientName, CASE WHEN c.Gander='L' then 'M' ELSE 'F' END AS Gander, 
                            replace(CONVERT(VARCHAR(11), c.Date_of_birth, 111), '/','-') as Date_of_birth,c.Address,
                            case when a.PatientType='1' THEN 'PRIBADI' WHEN a.PatientType='2' THEN 'ASURANSI' WHEN a.PatientType='5' THEN 'PERUSAHAAN' END 
                            AS  PatientType,d.CODEUNIT,d.NamaUnit,a.Doctor_1,e.First_Name, a.NoMR,a.NoEpisode,a.NoRegistrasi,b.NoLab,b.LabID,b.StatusID
                            from PerawatanSQL.dbo.Visit a
                            inner join LaboratoriumSQL.dbo.tblLab b
                            on a.NoRegistrasi = b.NoRegRI
                            inner join MasterdataSQL.dbo.Admision_walkin c
                            on c.NoMR = a.NoMR
                            inner join MasterdataSQL.dbo.MstrUnitPerwatan d
                            on d.ID=a.Unit
                            inner join MasterdataSQL.dbo.Doctors e
                            on e.ID=a.Doctor_1
                            where a.NoRegistrasi=:searchbox2 and b.Batal='0' " );
            $this->db->bind('searchbox',   $searchbox); 
            $this->db->bind('searchbox2',   $searchbox); 
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $row) {
                $pasing['NoMR'] = $row['NoMR'];
                $pasing['PatientName'] = $row['PatientName'];
                $pasing['NoEpisode'] =  $row['NoEpisode'];
                $pasing['NoRegistrasi'] =  $row['NoRegistrasi'];
                $pasing['NamaUnit'] = $row['NamaUnit'];
                $pasing['NoLab'] = $row['NoLab'];
                $pasing['First_Name'] = $row['First_Name'];
                $pasing['LabID'] = $row['LabID'];
                $pasing['StatusID'] = $row['StatusID'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDataTblLabHeader($data)
    {
        try {
            $this->db->query("SELECT LabID, OrderCode, RecID, NoLAB,replace(CONVERT(VARCHAR(11), LabDate, 111), '/','-')as LabDate, 
                                JamOrder, TglHasil1, TglHasil2, NoMR, NoEpisode, NoRegRI, 
                                ReferenceID, Dokter, KelasID, Operator, TypePasien, StatusID, InvoiceId, Batal, Catatan, TS, 
                                PaketKMG, 
                                TglSampling, JamSampling, JamSelasai, JenisOrder, TerimaSample, ProseSample, Verifikasi, 
                                HasilSelesai, Baground, 
                                Receive_st, Diagnosa, KeteranganKlinis, FlagPA, IncludePaket, lockBill
                                FROM LaboratoriumSQL.dbo.tblLab
                                WHERE LabID =:idLab");
            $this->db->bind('idLab',   $data['q']);
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success', // Set array status dengan success
                'LabID' => $data['LabID'], // Set array status dengan success
                'OrderCode' => $data['OrderCode'], // Set array status dengan success
                'RecID' => $data['RecID'], // Set array status dengan success
                'NoLAB' => $data['NoLAB'], // Set array status dengan success
                'LabDate' => $data['LabDate'], // Set array status dengan success
                'Diagnosa' => $data['Diagnosa'], // Set array status dengan success
                'KeteranganKlinis' => $data['KeteranganKlinis'], // Set array status dengan successDate_of_birth 
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function cekStatusOrderLab($data)
    {
        try {
            $this->db->query("SELECT  st_received,st_process,Result    
                                FROM LaboratoriumSQL.dbo.LIS_Order
                                WHERE NoLab =:Lab_NoLab");
            $this->db->bind('Lab_NoLab',   $data['Lab_NoLab']);
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success', // Set array status dengan success
                'st_received' => $data['st_received'],
                'st_proces' => $data['st_process'],
                'Result' => $data['Result'],
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function deleteOrderLab($data)
    {
        try {
            $datasatu = "1";
            $this->db->transaksi();
            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $namauserx = $session->name;
            // DETIL LAB Batal
            $this->db->query("UPDATE LaboratoriumSQL.dbo.tblLabDetail set 
                            status_ts=:datasatu2,Batal=:datasatu
                            where LabID in (SELECT LabID FROM LaboratoriumSQL.dbo.tblLab WHERE NoLab=:NoLabOrderBatal)");
            $this->db->bind('NoLabOrderBatal', $data['Lab_NoLab']);
            $this->db->bind('datasatu', $datasatu);
            $this->db->bind('datasatu2', $datasatu);
            $this->db->execute();

            // DETIL LIS ORDER Batal
            $this->db->query("UPDATE LaboratoriumSQL.dbo.LIS_Order_detail set 
                            status_ts=:datasatu
                            where NoLab=:NoLabOrderBatal and kode_test in (
                            select kode_test from LaboratoriumSQL.dbo.tblLabDetail
                            where LabID in (SELECT LabID FROM LaboratoriumSQL.dbo.tblLab WHERE NoLab=:NoLabOrderBatal2)  ) ");
            $this->db->bind('datasatu', $datasatu);
            $this->db->bind('NoLabOrderBatal', $data['Lab_NoLab']);
            $this->db->bind('NoLabOrderBatal2', $data['Lab_NoLab']); 
            $this->db->execute();

            // INSERT TZ LOG
            $this->db->query("INSERT INTO  SysLog.dbo.TZ_Log_Button 
                            (noregistrasi,petugas_batal,tgl_batal,alasan_batal) VALUES
                            (:Lab_NoLab,:userid,:datenowcreate,:alasanbatal)");
            $this->db->bind('userid', $userid);
            $this->db->bind('Lab_NoLab', $data['Lab_NoLab']);
            $this->db->bind('alasanbatal', $data['alasanbatalOrder']);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->execute();

            // LIS
            $this->db->query(" UPDATE LaboratoriumSQL.dbo.LIS_Order 
                            set IS_TAKEN='FALSE',status_ts=:datasatu 
                            where NoLAB=:Lab_NoLab");
            $this->db->bind('Lab_NoLab', $data['Lab_NoLab']);
            $this->db->bind('datasatu', $datasatu);
            $this->db->execute();
            
            // TBLLAB
            $this->db->query(" UPDATE LaboratoriumSQL.dbo.tblLab set 
                                Batal=:datasatu  where NoLab=:Lab_NoLab ");
            $this->db->bind('Lab_NoLab', $data['Lab_NoLab']);
            $this->db->bind('datasatu', $datasatu);
            $this->db->execute();

             //update fo_t_billing_1
             $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_1 set 
             PETUGAS_BATAL=:namauserx,BATAL='1',JAM_BATAL=:datenowcreate
             where KODE_REF in (SELECT LabDetailID FROM LaboratoriumSQL.dbo.tblLab a
             inner join LaboratoriumSQL.dbo.tbllabdetail b on a.LabID=b.LabID
             WHERE a.NoLab=:Lab_NoLab 
             )");
            $this->db->bind('Lab_NoLab', $data['Lab_NoLab']); 
            $this->db->bind('datenowcreate', $datenowcreate); 
            $this->db->bind('namauserx', $namauserx); 
            $this->db->execute();

            //update fo_t_billing_2
            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING_2 set 
            PETUGAS_BATAL=:namauserx,BATAL='1',JAM_BATAL=:datenowcreate
            FROM Billing_Pasien.dbo.FO_T_BILLING_2 c 
            inner join Billing_Pasien.dbo.FO_T_BILLING_1 d on c.NO_TRS_BILLING=d.NO_TRS_BILLING
            where KODE_REF in (SELECT LabDetailID FROM LaboratoriumSQL.dbo.tblLab a
            inner join LaboratoriumSQL.dbo.tbllabdetail b on a.LabID=b.LabID
            WHERE a.NoLab=:Lab_NoLab 
            )");
           $this->db->bind('Lab_NoLab', $data['Lab_NoLab']); 
           $this->db->bind('datenowcreate', $datenowcreate); 
           $this->db->bind('namauserx', $namauserx); 
           $this->db->execute();

            //update fo_t_billing
            $this->db->query("UPDATE Billing_Pasien.dbo.FO_T_BILLING set 
            PETUGAS_BATAL=:namauserx,BATAL='1',JAM_BATAL=:datenowcreate,FB_VERIF_JURNAL='0'
            FROM Billing_Pasien.dbo.FO_T_BILLING c 
            inner join Billing_Pasien.dbo.FO_T_BILLING_1 d on c.NO_TRS_BILLING=d.NO_TRS_BILLING
            where KODE_REF in (SELECT LabDetailID FROM LaboratoriumSQL.dbo.tblLab a
            inner join LaboratoriumSQL.dbo.tbllabdetail b on a.LabID=b.LabID
            WHERE a.NoLab=:Lab_NoLab 
            )");
           $this->db->bind('Lab_NoLab', $data['Lab_NoLab']); 
           $this->db->bind('datenowcreate', $datenowcreate); 
           $this->db->bind('namauserx', $namauserx); 
           $this->db->execute();

            /*/UPDATE TOTAL KE FO_T_BILLING
            $this->db->query("UPDATE Billing_Pasien.DBO.FO_T_BILLING
            SET TOTAL_TARIF=B.SUM_NILAI_TARIF,TOTAL_QTY=B.SUM_QTY,SUBTOTAL=B.SUM_SUB_TOTAL,SUBTOTAL_2=B.SUM_SUB_TOTAL_2,GRANDTOTAL=B.SUM_GRANDTOTAL
            FROM Billing_Pasien.DBO.FO_T_BILLING A 
            INNER JOIN
            (
            SELECT  NO_TRS_BILLING,SUM(NILAI_TARIF) AS SUM_NILAI_TARIF,SUM(QTY) AS SUM_QTY,SUM(SUB_TOTAL) AS SUM_SUB_TOTAL,SUM(SUB_TOTAL_2) AS SUM_SUB_TOTAL_2,
            SUM(GRANDTOTAL) AS SUM_GRANDTOTAL
            FROM Billing_Pasien.DBO.FO_T_BILLING_1
            WHERE NO_REGISTRASI  collate SQL_Latin1_General_CP1_CI_AS in (SELECT NoRegRI FROM LaboratoriumSQL.dbo.tbllab where NoLab=:Lab_NoLab)and Batal='0'
            GROUP BY NO_TRS_BILLING
            ) B
            ON A.NO_TRS_BILLING = B.NO_TRS_BILLING
            WHERE A.NO_REGISTRASI  collate SQL_Latin1_General_CP1_CI_AS in (SELECT NoRegRI FROM LaboratoriumSQL.dbo.tbllab where NoLab=:Lab_NoLab2)");
            $this->db->bind('Lab_NoLab', $data['Lab_NoLab']);
            $this->db->bind('Lab_NoLab2', $data['Lab_NoLab']);
            $this->db->execute();
            */

            $this->db->commit();
            $this->db->closeCon();
            $callback = array(
                'status' => 'success',
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
    public function deleteOrderLab2($data)
    {
        try {
            $datasatu = "1";
            $this->db->transaksi();
            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            // DETIL LAB Batal
            // HATI2 QUERYNYA.. JANGAN SAMPE SALAH INI , TANPA WHERE BISA KE UPDATE SEMUA
            $this->db->query("UPDATE LaboratoriumSQL.DBO.tblLabDetail SET Batal=:datasatu,status_ts=:datasatu2
                            WHERE kode_test NOT IN (
                                SELECT kode_test 
                                FROM LaboratoriumSQL.DBO.LIS_Order_detail WHERE NOLAB=:NoLabOrderBatal
                            ) AND  LabID   IN (
                                SELECT LabID 
                                FROM LaboratoriumSQL.DBO.tblLab WHERE NOLAB=:NoLabOrderBatal2
                            )");
            $this->db->bind('NoLabOrderBatal', $data['Lab_NoLab']);
            $this->db->bind('NoLabOrderBatal2', $data['Lab_NoLab']);
            $this->db->bind('datasatu', $datasatu);
            $this->db->bind('datasatu2', $datasatu);
            $this->db->execute();

            // INSERT TZ LOG
            //$this->db->query("INSERT INTO  SysLog.dbo.TZ_Log_Button 
            //                (noregistrasi,petugas_batal,tgl_batal,alasan_batal) VALUES
            //                (:Lab_NoLab,:userid,:datenowcreate,:alasanbatal)");
            //$this->db->bind('userid', $userid);
            //$this->db->bind('Lab_NoLab', $data['Lab_NoLab']);
            //$this->db->bind('alasanbatal', $data['alasanbatalOrder']);
            //$this->db->bind('datenowcreate', $datenowcreate);
            //$this->db->execute();

            $this->db->commit();
            $this->db->closeCon();
            $callback = array(
                'status' => 'success',
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
}
