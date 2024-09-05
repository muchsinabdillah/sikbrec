<?php
class LabGlucosa_Model 
{
    private $dblab;
    private $db;

    public function __construct()
    {
        $this->dblab = new DatabaseLab;
        $this->db = new Database;
    }

    public function geHasilDetail($data)
    {
        try { 
            //$Group_Jaminan = 'UM';
            // $nolab = '3120871989';
            $nolabtube = $data['nolab'];



            $this->db->query("select *from LaboratoriumSQL.dbo.LIS_TUBE b  
            inner join LaboratoriumSQL.dbo.LIS_Order c
            on c.NoLab collate SQL_Latin1_General_CP1_CI_AS  = b.NOLAB collate SQL_Latin1_General_CP1_CI_AS 
            where b.TUBENUMBER=:nolab and c.status_ts='0'");
           $this->db->bind('nolab', $nolabtube); 
            $dataxx =  $this->db->single(); 
            $NOLIS=$dataxx['NOLIS'];
            $nolab=$dataxx['NOLAB'];
            //var_dump($nolab);
         // var_dump($NOLIS);
            if ( $dataxx < 1 ) {
                            $metadata = array(
                                'errorname' => 'No. Order Laborarotium tidak ditemukan.',
                                'status' => 'warning', // Set array nama dengan isi kolom nama pada tabel siswa 
                            );
                            return $metadata;
                            exit;
            }


                $this->dblab->querylab("SELECT '$nolab' as NOLAB, '$NOLIS' as NOLIS, '' as REQUESTID,'1' AS NOINDEX,
                '0' AS DEPTH, '1' AS TESTTYPE, 'DIABETES' AS CHAPTER,
                '' AS TESTCODE ,a.UnivTestID as kodetestglu , a.UnivTestName AS  TESTNAME , a.ANormalFlag AS FLAG,
                a.RValue AS HASIL, '' AS KOMENTARHASIL,
                '' AS NILAIRUJUKAN , a.Unit AS SATUAN, '' AS DTORDER, '' AS DT_DITERIMA, '' AS DT_VALIDASI,
                '' AS DT_CETAK, '' AS DT_VALIDATE_BY,'7' AS CHAPID
                FROM Result A
                INNER JOIN Patient B
                ON A._PID = B.ID
                where b.Lab_PatientID=:nolab");
                $this->dblab->bindlab('nolab', $nolabtube); 
                $data =  $this->dblab->resultSetlab();
            $rows = array();
            foreach ($data as $key) {
                // $pasing['NOLAB'] = $key['NOLAB'];
                // $pasing['NOLIS'] = $key['NOLIS'];
                // $pasing['REQUESTID'] = $key['REQUESTID'];
                // $pasing['NOINDEX'] = $key['NOINDEX'];
                // $pasing['DEPTH'] = $key['DEPTH'];
                // $pasing['TESTTYPE'] = $key['TESTTYPE'];
                // $pasing['CHAPTER'] = $key['CHAPTER'];
                // $pasing['TESTCODE'] = $key['TESTCODE'];
                // $pasing['kodetestglu'] = $key['kodetestglu'];
                // $pasing['TESTNAME'] = $key['TESTNAME'];
                // $pasing['FLAG'] = $key['FLAG'];
                // $pasing['HASIL'] = $key['HASIL'];
                // $pasing['KOMENTARHASIL'] = $key['KOMENTARHASIL'];
                // $pasing['NILAIRUJUKAN'] = $key['NILAIRUJUKAN'];
                // $pasing['SATUAN'] = $key['SATUAN'];
                // $pasing['DTORDER'] = $key['DTORDER'];
                // $pasing['DT_DITERIMA'] = $key['DT_DITERIMA'];
                // $pasing['DT_VALIDASI'] = $key['DT_VALIDASI']; 
                // $pasing['DT_CETAK'] = $key['DT_CETAK']; 
                // $pasing['DT_VALIDATE_BY'] = $key['DT_VALIDATE_BY']; 
                // $pasing['CHAPID'] = $key['CHAPID']; 
                $this->db->query("DELETE FROM SysLog.dbo.GLUCOSA  where TUBENUMBER = :NOLAB ");
                $this->db->bind('NOLAB',$nolabtube);
                $this->db->execute();
                
                $this->db->query("INSERT INTO SysLog.dbo.GLUCOSA 
                (   NOLAB,
                    NOLIS, 
                    REQUESTID, 
                    NOINDEX, 
                    DEPTH, 
                    TESTTYPE, 
                    CHAPTER, 
                    TESTCODE, 
                    kodetestglu, 
                    TESTNAME, 
                    FLAG, 
                    HASIL, 
                    KOMENTARHASIL, 
                    NILAIRUJUKAN, 
                    SATUAN, 
                    DTORDER, 
                    DT_DITERIMA, 
                    DT_VALIDASI, 
                    DT_CETAK, 
                    DT_VALIDATE_BY, 
                    CHAPID , TUBENUMBER )
              values
              (     :NOLAB,
                    :NOLIS, 
                    :REQUESTID, 
                    :NOINDEX, 
                    :DEPTH, 
                    :TESTTYPE, 
                    :CHAPTER, 
                    :TESTCODE, 
                    :kodetestglu, 
                    :TESTNAME, 
                    :FLAG, 
                    :HASIL, 
                    :KOMENTARHASIL, 
                    :NILAIRUJUKAN, 
                    :SATUAN, 
                    :DTORDER, 
                    :DT_DITERIMA, 
                    :DT_VALIDASI, 
                    :DT_CETAK, 
                    :DT_VALIDATE_BY, 
                    :CHAPID , :TUBENUMBER )");  
                $this->db->bind('NOLIS', $key['NOLIS']); 
                $this->db->bind('NOLAB', $key['NOLAB']);
                
                $this->db->bind('REQUESTID', $key['REQUESTID']); 
                $this->db->bind('NOINDEX', $key['NOINDEX']); 
                $this->db->bind('DEPTH', $key['DEPTH']); 
                $this->db->bind('TESTTYPE', $key['TESTTYPE']); 
                $this->db->bind('CHAPTER', $key['CHAPTER']); 
                $this->db->bind('TESTCODE', $key['TESTCODE']); 
                $this->db->bind('kodetestglu', $key['kodetestglu']); 
                $this->db->bind('TESTNAME', $key['TESTNAME']); 
                $this->db->bind('FLAG', $key['FLAG']); 
                $this->db->bind('HASIL', $key['HASIL']); 
                $this->db->bind('KOMENTARHASIL', $key['KOMENTARHASIL']); 
                $this->db->bind('NILAIRUJUKAN', $key['NILAIRUJUKAN']); 
                $this->db->bind('SATUAN', $key['SATUAN']); 
                $this->db->bind('DTORDER', $key['DTORDER']); 
                $this->db->bind('DT_DITERIMA', $key['DT_DITERIMA']); 
                $this->db->bind('DT_VALIDASI', $key['DT_VALIDASI']); 
                $this->db->bind('DT_CETAK', $key['DT_CETAK']); 
                $this->db->bind('DT_VALIDATE_BY', $key['DT_VALIDATE_BY']); 
                $this->db->bind('CHAPID', $key['CHAPID']);
                $this->db->bind('TUBENUMBER', $nolabtube);
                $this->db->execute();


                $this->db->query("DELETE FROM SysLog.dbo.LIS_RESULT_TEMP  where TUBENUMBER=:nolis ");
            $this->db->bind('nolis', $nolabtube);
            $this->db->execute();

            $this->db->query("INSERT INTO SysLog.DBO.LIS_RESULT_TEMP
            SELECT b.NOLAB as NOLAB, b.NOLIS as NOLIS, '' REQUESTID,'1' AS NOINDEX,
            '0' AS DEPTH, '1' AS TESTTYPE, 'DIABETES' AS CHAPTER,
            e.KodeKelompok  AS TESTCODE , e.NamaTes AS  TESTNAME , a.FLAG AS FLAG, a.HASIL AS HASIL, '' AS KOMENTARHASIL,
            a.NILAIRUJUKAN AS NILAIRUJUKAN , a.SATUAN AS SATUAN, c.request_dt AS DTORDER, '' AS DT_DITERIMA,c.DT_Validasi AS DT_VALIDASI,
            '1900-01-01 00:00:00.000' AS DT_CETAK, '' AS DT_VALIDATE_BY,'7' AS CHAPID,$nolabtube as TUBENUMBER
            from 
            SysLog.dbo.GLUCOSA a 
            INNER JOIN LaboratoriumSQL.dbo.LIS_TUBE b 
            on a.NOLAB collate SQL_Latin1_General_CP1_CI_AS  = b.NOLAB collate SQL_Latin1_General_CP1_CI_AS 
            inner join LaboratoriumSQL.dbo.LIS_Order c
            on c.NoLab collate SQL_Latin1_General_CP1_CI_AS  = b.NOLAB collate SQL_Latin1_General_CP1_CI_AS 
            inner join LaboratoriumSQL.dbo.LIS_Order_detail d
            on d.NoLab collate SQL_Latin1_General_CP1_CI_AS  = b.NOLAB  collate SQL_Latin1_General_CP1_CI_AS 
            inner join LaboratoriumSQL.dbo.tblGrouping e
            on e.KodeKelompok = d.kode_test and a.kodetestglu collate SQL_Latin1_General_CP1_CI_AS = e.KD_GLUCOSA collate SQL_Latin1_General_CP1_CI_AS
            where b.nolab=:NOLAB
            group by  b.NOLAB, b.NOLIS , 
            e.KodeKelompok   , e.NamaTes  , a.FLAG  , a.HASIL ,
            a.NILAIRUJUKAN  , a.SATUAN , c.request_dt   ,c.DT_Validasi,c.request_dt ");  
            $this->db->bind('NOLAB', $nolab);
            $this->db->execute();
            
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
    public function loaddata($data){
        try {

            $this->db->query("select *from LaboratoriumSQL.dbo.LIS_TUBE b  
            inner join LaboratoriumSQL.dbo.LIS_Order c
            on c.NoLab collate SQL_Latin1_General_CP1_CI_AS  = b.NOLAB collate SQL_Latin1_General_CP1_CI_AS 
            where b.TUBENUMBER=:nolab and c.status_ts='0'");
           $this->db->bind('nolab', $data['nolab']); 
            $dataxx =  $this->db->single(); 
            $NOLIS=$dataxx['NOLIS'];
            $nolab=$dataxx['NOLAB'];


            $this->db->query("SELECT *FROM SysLog.DBO.LIS_RESULT_TEMP where nolis=:nolis");
            $this->db->bind('nolis', $NOLIS);
            $data =  $this->db->resultSet();
            $rows = array(); 
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['NOLAB'] = $key['NOLAB'];
                $pasing['NOLIS'] = $key['NOLIS'];
                $pasing['REQUESTID'] = $key['REQUESTID'];
                $pasing['NOINDEX'] = $key['NOINDEX'];
                $pasing['DEPTH'] = $key['DEPTH'];
                $pasing['TESTTYPE'] = $key['TESTTYPE'];

                $pasing['CHAPTER'] = $key['CHAPTER'];
                $pasing['TESTCODE'] = $key['TESTCODE'];
                $pasing['TESTNAME'] = $key['TESTNAME'];
                $pasing['FLAG'] = $key['FLAG'];
                $pasing['HASIL'] = $key['HASIL'];
                $pasing['KOMENTARHASIL'] = $key['KOMENTARHASIL'];
                $pasing['NILAIRUJUKAN'] = $key['NILAIRUJUKAN'];
                $pasing['SATUAN'] = $key['SATUAN'];
                $pasing['DTORDER'] = $key['DTORDER'];
                $pasing['DT_DITERIMA'] = $key['DT_DITERIMA'];
                $pasing['DT_VALIDASI'] = $key['DT_VALIDASI']; 
                $pasing['DT_CETAK'] = $key['DT_CETAK'];
                $pasing['DT_VALIDATE_BY'] = $key['DT_VALIDATE_BY'];
                $pasing['CHAPID'] = $key['CHAPID']; 

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
    public function showheader($data){
        try { 
            date_default_timezone_set('Asia/Jakarta');
            $datenow   = new DateTime('today');

            $this->db->query("select *from LaboratoriumSQL.dbo.LIS_TUBE b  
            inner join LaboratoriumSQL.dbo.LIS_Order c
            on c.NoLab collate SQL_Latin1_General_CP1_CI_AS  = b.NOLAB collate SQL_Latin1_General_CP1_CI_AS 
            where b.TUBENUMBER=:nolab and c.status_ts='0'");
           $this->db->bind('nolab', $data['notrs']); 
            $dataxx =  $this->db->single(); 

            $NOLIS=$dataxx['NOLIS'];
            $nolab=$dataxx['NOLAB'];
            
            $this->db->query("SELECT nolab FROM SysLog.dbo.LIS_RESULT_TEMP  where nolis=:nolabxx ");
            $this->db->bind('nolabxx', $NOLIS);
            $datalis =  $this->db->single();
            $xnolab = $datalis['nolab'];

            $this->db->query("SELECT DISTINCT a.*,  replace(CONVERT(VARCHAR(11), a.birth_dt, 111), '/','-') as birth_dtx,
            c.[Mobile Phone] as nohp,c.Tipe_Idcard,c.ID_Card_number
            FROM LaboratoriumSQL.dbo.LIS_ORDER a
            inner join MasterDataSQL.dbo.Admision c on a.NoMR=c.NoMR
            Where a.NoLab=:nolab
            UNION ALL
            SELECT DISTINCT a.*,  replace(CONVERT(VARCHAR(11), a.birth_dt, 111), '/','-') as birth_dtx,
            c.[Mobile Phone] as nohp,c.Tipe_Idcard,c.ID_Card_number
            FROM LaboratoriumSQL.dbo.LIS_ORDER a
            inner join MasterDataSQL.dbo.Admision_walkin c on a.NoMR=c.NoMR
            Where a.NoLab=:nolab2");
            $this->db->bind('nolab', $xnolab);
            $this->db->bind('nolab2', $xnolab);
            $data =  $this->db->single();

            $dob   = new DateTime($data['birth_dtx']);
            $age = $dob->diff($datenow)->y;

            if ($data['sex']=='M'){
                $gender = 'Male';
              }else{
                $gender = 'Female';
              }

             //Identitas Pasien
            $pasing['pname'] = $data['pname'];
            $pasing['NoLab'] = $data['NoLab']; 
            $pasing['NoMR'] = $data['NoMR'];
            $pasing['birth_dt'] = date('d/m/Y', strtotime($data['birth_dt']));
            $pasing['clinician_name'] = $data['clinician_name'];
            $pasing['locname'] = $data['locname'];
            $pasing['gender'] = $gender;
            $pasing['age'] = $age;
            $pasing['asuransi'] = $data['asuransi'];
            $pasing['address'] = $data['address'];
            $pasing['request_dt'] = date('d/m/Y', strtotime($data['request_dt']));
            $pasing['nohp'] = $data['nohp'];
            $pasing['Tipe_Idcard'] = $data['Tipe_Idcard'];
            $pasing['ID_Card_number'] = $data['ID_Card_number'];

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function insertlisfix($data){
        try { 
            //$Group_Jaminan = 'UM';
            // $nolab = '3120871989';
            $nolab = $data['notrs'];
            $nolis = $data['nolab'];
            $tglditerima = $data['tglsamplediterima'];
            $jamditerima = $data['jamsamplediterima'];

            if ($tglditerima == "") {
                $callback = array(
                    'status' => 'warning',  
                    'errorname' => 'Masukan Tanggal Sample diterima !',
                );
                return $callback;
                exit;
            }

            if ($jamditerima == "") {
                $callback = array(
                    'status' => 'warning',  
                    'errorname' => 'Masukan Jam Sample diterima !',
                );
                return $callback;
                exit;
            }

            $this->db->query("DELETE FROM LaboratoriumSQL.dbo.LIS_RESULT where NOLAB=:nolab and REQUESTID='0'");
            $this->db->bind('nolab', $nolab);
            $this->db->execute();

            $this->db->query("insert into LaboratoriumSQL.dbo.LIS_RESULT 
            (NOLAB,NOLIS,REQUESTID,
            NOINDEX,DEPTH,TESTTYPE,CHAPTER,
            TESTCODE,TESTNAME,FLAG,HASIL,
            KOMENTAR_HASIL,NILAI_RUJUKAN,
            SATUAN,DT_Order,DT_Terima,DT_Validasi,DT_Cetak,Validate_by,CHAPID)
            select  NOLAB,NOLIS,REQUESTID,
            NOINDEX,DEPTH,TESTTYPE,CHAPTER,
            TESTCODE,TESTNAME,FLAG,HASIL,
            KOMENTARHASIL,NILAIRUJUKAN,
            SATUAN,DTORDER,'$tglditerima'+' '+'$jamditerima' as diterima,DT_Validasi,DT_Cetak,DT_VALIDATE_BY,CHAPID from SysLog.dbo.LIS_RESULT_TEMP where nolab=:nolis and NILAIRUJUKAN <> '' ");  
            $this->db->bind('nolis', $nolab);
            $this->db->execute();
         
            $callback = array(
                'message' => "success", // Set array nama  
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

    public function update($data){
        try { 
            //$Group_Jaminan = 'UM';
            // $nolab = '3120871989';
            $NILAIRUJUKAN = $data['NILAIRUJUKAN'];
            $IDx = $data['IDx']; 

            $this->db->query("UPDATE SysLog.dbo.LIS_RESULT_TEMP set NILAIRUJUKAN=:XNILAIRUJUKAN where ID=:XID");
            $this->db->bind('XNILAIRUJUKAN', $NILAIRUJUKAN);
            $this->db->bind('XID', $IDx);
            $this->db->execute();

 
         
            $callback = array(
                'status' => "success", // Set array nama  
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