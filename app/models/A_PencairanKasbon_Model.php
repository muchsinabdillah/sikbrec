<?php
class A_PencairanKasbon_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function showOutstandingPencairan($data)
    {
        try {
            $this->db->query("SELECT a.ID, a.No_Transaksi, replace(CONVERT(VARCHAR(11), a.Tgl_Transaksi, 111), '/','-') as TglOrder
                            ,a.Pegawai ,b.Nama,a.Nominal,a.Keterangan,isnull(a.Status,'') as Status,isnull(d.No_Transaksi,'') As No_Pencairan, replace(CONVERT(VARCHAR(11), 
                            d.Tgl_Transaksi, 111), '/','-') as TglPencairan 
                            FROM Keuangan.dbo.T_Order_Kasbon a
                            inner join HRDYARSI.dbo.[Data Pegawai] b on a.Pegawai=b.ID_Data
                            inner join MasterDataSQL.dbo.Employees c on a.Petugas_Input_First collate Latin1_General_CI_AS=c.Nopin collate Latin1_General_CI_AS
                            left join Keuangan.dbo.T_Kasbon d on d.No_Transaksi = a.No_Transaksi
                            where  d.Batal='0'
                            order by TglOrder asc");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = 0;
            foreach ($data as $key) {
                $no++;
           
                $pasing['no'] = $no;
                $pasing['ID'] = $key['ID'];
                $pasing['No_Transaksi'] = $key['No_Transaksi']; 
                $pasing['Nama'] = $key['Nama'];
                $pasing['Nominal'] = $key['Nominal'];
                $pasing['Keterangan'] = $key['Keterangan'];  
                $pasing['TglOrder'] = date('d/m/Y', strtotime($key['TglOrder'])); 
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
    public function shwoOutstandingPenyelesaian($data)
    {
        
            // $this->db->query("SELECT a.*,b.Nama,c.[First Name],
            //                 replace(CONVERT(VARCHAR(11), a.Tgl_Transaksi, 111), '/','-') as tgltransaksi ,a.Tgl_Penyelesaian,
            //                 d.No_Transaksi as NoOrder,d.Tgl_Transaksi as TglOrder,case when a.Status_Finish ='0' then 'BELUM REALISASI' ELSE '' END as statustransaski
            //                 from Keuangan.dbo.T_Kasbon a
            //                 inner join HRDYARSI.dbo.[Data Pegawai] b on a.Pegawai=b.ID_Data
            //                 inner join MasterDataSQL.dbo.Employees c on a.Petugas_Input_First collate Latin1_General_CI_AS =c.Nopin collate Latin1_General_CI_AS
            //                 left join Keuangan.DBO.T_Order_Kasbon d on d.No_Transaksi_Kasbon = a.No_Transaksi
            //                 where Batal='0' 
            //                 order by replace(CONVERT(VARCHAR(11), a.Tgl_Transaksi, 111), '/','-')");
            // $data =  $this->db->resultSet();
            // $rows = array();
            // $array = array();
            // $no = 0;
            // foreach ($data as $key) {
            //     $no++;
            //     $pasing['no'] = $no;
            //     $pasing['ID'] = $key['id'];
            //     $pasing['No_Transaksi'] = $key['No_Transaksi'];
            //     $pasing['NoOrder'] = $key['NoOrder'];
            //     $pasing['TglOrder'] = $key['TglOrder'];
            //     $pasing['Tgl_Penyelesaian'] =  date('d/m/Y H:i:s', strtotime($key['Tgl_Penyelesaian']));
                
            //     $pasing['TglPencairan'] = date('d/m/Y H:i:s', strtotime($key['Tgl_Transaksi']));
            //     $pasing['Keterangan'] = $key['Keterangan'];
            //     $pasing['NominalPencairan'] = $key['Nominal'];
            //     $pasing['NamaPegawaiPencairan'] = $key['Nama'];
            //     $pasing['TipeKasbon'] = $key['TipeKasbon'];
            //     $pasing['statustransaski'] = $key['statustransaski'];

                
            //     $pasing['Nilai_Penyelesaian'] = $key['Nilai_Penyelesaian'];
            //     $rows[] = $pasing;
            // }
            // return $rows;

            $sql_details = array(
                'user' => DB_USER,
                'pass' => DB_PASSWORD,
                'db'   => DB_NAME,
                'host' => DB_HOST
            );

$table =<<<EOT
(SELECT a.Nominal,a.id,a.Keterangan,b.Nama,c.[First Name] ,
replace(CONVERT(VARCHAR(11), a.Tgl_Transaksi, 111), '/','-') as tgltransaksi , 
d.No_Transaksi as NoOrder,d.Tgl_Transaksi as TglOrder,case when a.Status_Finish ='0' then 'BELUM REALISASI' ELSE '' END as statustransaski
from Keuangan.dbo.T_Kasbon a
inner join HRDYARSI.dbo.[Data Pegawai] b on a.Pegawai=b.ID_Data
inner join MasterDataSQL.dbo.Employees c on a.Petugas_Input_First collate Latin1_General_CI_AS =c.Nopin collate Latin1_General_CI_AS
left join Keuangan.DBO.T_Order_Kasbon d on d.No_Transaksi_Kasbon = a.No_Transaksi
) temp 
EOT;

            $primaryKey = 'id';

            $columns = array(
                array( 'db' => 'id', 'dt' => 'id' ),
                array( 'db' => 'NoOrder', 'dt' => 'NoOrder' ),
                array( 'db' => 'tgltransaksi',     'dt' => 'tgltransaksi' ),
                array( 'db' => 'Nama',     'dt' => 'NamaPegawaiPencairan' ), 
                array( 'db' => 'Keterangan',     'dt' => 'Keterangan' ),
                array( 'db' => 'statustransaski',     'dt' => 'statustransaski' ),
                array( 'db' => 'Nominal',     'dt' => 'NominalPencairan' )
            );

            require( 'ssp.class.php' ); 

            
            return  SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns );
            
            

            

        
    } 
    public function shwoOutstandingPenyelesaianbyPegawai($data)
    {
        try {
            $NamaPegawai = $data['NamaPegawai'];
            $this->db->query("SELECT a.*,b.Nama,c.[First Name],
                            replace(CONVERT(VARCHAR(11), a.Tgl_Transaksi, 111), '/','-') as tgltransaksi ,
                            d.No_Transaksi as NoOrder,d.Tgl_Transaksi as TglOrder
                            from Keuangan.dbo.T_Kasbon a
                            inner join HRDYARSI.dbo.[Data Pegawai] b on a.Pegawai=b.ID_Data
                            inner join MasterDataSQL.dbo.Employees c on a.Petugas_Input_First collate Latin1_General_CI_AS =c.Nopin collate Latin1_General_CI_AS
                            left join Keuangan.DBO.T_Order_Kasbon d on d.No_Transaksi_Kasbon = a.No_Transaksi
                            where Batal='0' and Status_Finish='0' and a.Pegawai=:NamaPegawai and a.No_Transaksi <> :noTrsPencairan
                            order by replace(CONVERT(VARCHAR(11), a.Tgl_Transaksi, 111), '/','-')");
            $this->db->bind('NamaPegawai', $data['NamaPegawai']);
            $this->db->bind('noTrsPencairan', $data['noTrsPencairan']);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = 0;
            foreach ($data as $key) {
                $no++;
                $pasing['no'] = $no;
                $pasing['ID'] = $key['id'];
                $pasing['No_Transaksi'] = $key['No_Transaksi'];
                $pasing['NoOrder'] = $key['NoOrder'];
                $pasing['TglOrder'] = $key['TglOrder'];
                $pasing['TglPencairan'] = date('d/m/Y H:i:s', strtotime($key['Tgl_Transaksi']));
                $pasing['Keterangan'] = $key['Keterangan'];
                $pasing['NominalPencairan'] = $key['Nominal'];
                $pasing['NamaPegawaiPencairan'] = $key['Nama'];
                $pasing['TipeKasbon'] = $key['TipeKasbon'];
                $pasing['Nilai_Penyelesaian'] = $key['Nilai_Penyelesaian'];
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
    public function showOrderPencairanById($data){
        try {
            $this->db->query(' SELECT id,No_Transaksi,Tgl_Transaksi,Nominal,Keterangan,STATUS,b.Nama,a.Pegawai
                            FROM Keuangan.DBO.T_Order_Kasbon a
                            inner join  HRDYARSI.dbo.[Data Pegawai] b on a.Pegawai=b.ID_Data
                            where ID=:id');
            $this->db->bind('id', $data['IDNoTrsOrder']);
            $data =  $this->db->single(); 
            $callback = array(
                'status' => 'success',
                'ID' => $data['id'],
                'No_Transaksi' => $data['No_Transaksi'],
                'IDPegawai' => $data['Pegawai'],
                'Tgl_Transaksi' => date('Y-m-d', strtotime($data['Tgl_Transaksi'])),
                'Nominal' => $data['Nominal'],
                'Keterangan' => $data['Keterangan'],
                'STATUS' => $data['STATUS'],
                'Nama' => $data['Nama'], 
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
    public function CreateRealisasi($data){
        try {
            $this->db->transaksi();

            // if ($data['NoTrsOrder'] == "") {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => 'Silahkan Input No. Order !',
            //     );
            //     return $callback;
            //     exit;
            // }
            if ($data['TipeKasbon'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Tipe Kasbon !',
                );
                return $callback;
                exit;
            }

            if ($data['NilaiPencairan'] == "" || $data['NilaiPencairan'] == "0")  {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Nilai Pencairan !',
                );
                return $callback;
                exit;
            }
            // if($data['NilaiPencairan'] > $data['NominalOrder']){
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => 'Nilai Pencairan Lebih besar Dari Nilai Order Bon Sementara !',
            //     );
            //     return $callback;
            //     exit;
            // }
            if ($data['KeteranganPencairan'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Keterangan Pencairan !',
                );
                return $callback;
                exit;
            }
            if ($data['TglRealRealisasi'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Tgl Pencairan Kosong !',
                );
                return $callback;
                exit;
            }
            if ($data['RekeningKas'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Rekening Kas Kosong !',
                );
                return $callback;
                exit;
            }
            if ($data['IDPegawaiOrder'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Nama Pegawai Realisasi Kosong !',
                );
                return $callback;
                exit;
            }
            $NoTrsOrder = $data['NoTrsOrder'];
            $TglOrder = $data['TglOrder'];
            $PegawaiOrder = $data['PegawaiOrder'];
            $Keterangan = $data['Keterangan'];
            $NoTrsPencairan = $data['NoTrsPencairan'];
            $TipeKasbon = $data['TipeKasbon'];
            $NominalOrder = $data['NominalOrder'];
            $NilaiPencairan = $data['NilaiPencairan'];
            $IDPegawaiOrder = $data['IDPegawaiOrder'];
            $KeteranganPencairan = $data['KeteranganPencairan'];
            $TglPencairan = $data['TglRealRealisasi'];
            $RekeningKas = $data['RekeningKas'];
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $TGLENTRI = Utils::seCurrentDateTime();

            //cek rekening
            $IDrek_kasbon = "rek_kasbon";
            $this->db->query('SELECT rekening FROM Keuangan.DBO.TZ_Parameter_Keu WHERE parameter=:rek_kasbon');
            $this->db->bind('rek_kasbon', $IDrek_kasbon);
            $this->db->execute();
            $data =  $this->db->single();
            $val_rekening = $data['rekening'];
            if ($val_rekening === null || $val_rekening === "") { 
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Rekening Kasbon Kosong, Cek Parameter Sistem !',
                );
                return $callback;
                exit;
            } else {
                $val_rekening = $data['rekening'];
            }

            // $IDrek_kasbon_kas = "rek_kasbon_kas";
            // $this->db->query('SELECT rekening FROM Keuangan.DBO.TZ_Parameter_Keu WHERE parameter=:IDrek_kasbon_kas');
            // $this->db->bind('IDrek_kasbon_kas', $IDrek_kasbon_kas);
            // $this->db->execute();
            // $data =  $this->db->single();
            // $val_rekening_Kas = $data['rekening'];
            // if ($val_rekening_Kas === null || $val_rekening_Kas === "") {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => 'Rekening Kas Kasbon Kosong, Cek Parameter Sistem !',
            //     );
            //     return $callback;
            //     exit;
            // } else {
            //     $val_rekening_Kas = $RekeningKas;
            // }
            $val_rekening_Kas = $RekeningKas;
            date_default_timezone_set('Asia/Jakarta');
            $tahun = Utils::datenowcreateYearOnly();
            $bulan = Utils::datenowcreateMonthOnly(); 
            $notrs = Utils::idtrsByDateOnly();
            if($NoTrsPencairan == ""){
                // auto number
                $this->db->query("SELECT  TOP 1 No_Transaksi,right(No_Transaksi,4) as nourut
                                FROM Keuangan.dbo.T_Kasbon  WHERE  
                              substring(No_Transaksi,3,6)=:No_Transaksi ORDER BY id DESC");
                $this->db->bind('No_Transaksi', $notrs); 
                $this->db->execute();
                $data =  $this->db->single();
                $nourut = $data['nourut'];
 
                if (empty($nourut)) {
                    //jika gk ada record
                    $nourut = "0001";
                } else {
                    //jika ada record
                    $nourut++;
                } 
                $nourutfix = Utils::generateAutoNumberFourDigit($nourut);
                $romawi = Utils::createMonthRomawi($bulan);
                $idxt = Utils::idtrsByDateOnly();
                $nokasbonAuto = $idxt;
                $notransaksi = 'KB' . $nokasbonAuto . '-' . $nourutfix;
                $tgl_trs = $TglPencairan;
                $this->db->query("INSERT INTO Keuangan.dbo.T_Kasbon 
                                (No_Transaksi,Tgl_Transaksi,Pegawai,
                                Nominal,Keterangan,Tgl_Input_First,Petugas_Input_First,TipeKasbon) VALUES
                                (:notransaksi,:tgl_trs,:pegawai,
                                :nominal,:keterangan,:tgl_trss,:operator,:TipeKasbon)");
                $this->db->bind('notransaksi', $notransaksi);
                $this->db->bind('tgl_trs', $tgl_trs);
                $this->db->bind('pegawai', $IDPegawaiOrder);
                $this->db->bind('nominal', $NilaiPencairan);
                $this->db->bind('keterangan', $KeteranganPencairan);
                $this->db->bind('tgl_trss', $TGLENTRI);
                $this->db->bind('operator', $userid);
                $this->db->bind('TipeKasbon', $TipeKasbon); 
                $this->db->execute();
                $last = $this->db->GetLastID();
            }else{

            }

            //jurnal
            $this->db->query("INSERT INTO Keuangan.dbo.TA_JURNAL_HDR
                            (FS_KD_JURNAL,FD_TGL_JURNAL,FS_KD_PETUGAS,
                            FN_DEBET,FN_KREDIT,fn_jurnal,FB_SELESAI, FS_KET) values
                            (:notransaksi,:tgl_trs,:operator,
                            :nominal,:nominal2,:nominal3,:sts,:keterangan)");
            $this->db->bind('notransaksi', $notransaksi);
            $this->db->bind('tgl_trs', $tgl_trs);
            $this->db->bind('nominal', $NilaiPencairan);
            $this->db->bind('nominal2', $NilaiPencairan);
            $this->db->bind('nominal3', $NilaiPencairan);
            $this->db->bind('keterangan', $KeteranganPencairan);
            $this->db->bind('sts', '1');
            $this->db->bind('operator', $userid);
            $this->db->execute();

            $this->db->query("INSERT INTO Keuangan.dbo.TA_JURNAL_DTL
                            ( FS_KD_JURNAL,FS_KET_REFF,FN_DEBET,
                                FN_KREDIT,FB_VOID,FS_REK,FS_KD_UNIT,FB_LEDGER,FS_KD_REFF) values
                            (:notransaksi,:KeteranganJurnal,:nominal,
                                :nominal2,:nominal3,:val_rekening,:FS_KD_UNIT,:FB_LEDGER,:notransaksi2)");
            $this->db->bind('notransaksi', $notransaksi);
            $this->db->bind('notransaksi2', $notransaksi);
            $this->db->bind('val_rekening', $val_rekening);
            $this->db->bind('nominal', $NilaiPencairan);
            $this->db->bind('nominal2', '0');
            $this->db->bind('nominal3', '0');
            $this->db->bind('KeteranganJurnal', $KeteranganPencairan);
            $this->db->bind('FB_LEDGER', '0');
            $this->db->bind('FS_KD_UNIT', ''); 
            $this->db->execute();
            //KREDIT
            $this->db->query("INSERT INTO Keuangan.dbo.TA_JURNAL_DTL
                            ( FS_KD_JURNAL,FS_KET_REFF,FN_DEBET,
                                FN_KREDIT,FB_VOID,FS_REK,FS_KD_UNIT,FB_LEDGER,FS_KD_REFF) values
                            (:notransaksi,:KeteranganJurnal,:nominal2,
                                :nominal,:nominal3,:val_rekening_Kas,:FS_KD_UNIT,:FB_LEDGER,:notransaksi2)");
            $this->db->bind('notransaksi', $notransaksi);
            $this->db->bind('KeteranganJurnal', $KeteranganPencairan);
            $this->db->bind('nominal2', '0');
            $this->db->bind('notransaksi2', $notransaksi);
            $this->db->bind('val_rekening_Kas', $val_rekening_Kas);
            $this->db->bind('nominal', $NilaiPencairan);
            $this->db->bind('nominal3', '0');
            $this->db->bind('FB_LEDGER', '0');
            $this->db->bind('FS_KD_UNIT', '');
            $this->db->execute();

            if($NoTrsOrder <> ""){
                $this->db->query(" UPDATE Keuangan.DBO.T_Order_Kasbon 
                            SET No_Transaksi_Kasbon=:notransaksi,
                            STATUS=:Realisasi
                            WHERE No_Transaksi=:NoTranSaksiOrderAuto");
                $this->db->bind('notransaksi', $notransaksi);
                $this->db->bind('Realisasi', 'Realisasi');
                $this->db->bind('NoTranSaksiOrderAuto', $NoTrsOrder);
                $this->db->execute();
            }

            $this->db->commit();
         
            $this->db->closeCon();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success 
                'id' => $last,
                'notransaksi' => $notransaksi,
                'nilairealisasi' => $NilaiPencairan,
                'tglrealisasi' => $tgl_trs,
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
    public function CreatePengajuanBonSementara($data){
        try {
            $this->db->transaksi(); 

            if ($data['NilaiPengajuan'] == "" || $data['NilaiPengajuan'] == "0")  {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Nilai Pengajuan Bon Sementara !',
                );
                return $callback;
                exit;
            }
            if ($data['TglPengajuan'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Tgl Pengajuan Bon Sementara Kosong !',
                );
                return $callback;
                exit;
            }
            if ($data['TipePengajuan'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Tipe Pengajuan Bon Sementara !',
                );
                return $callback;
                exit;
            }
            if ($data['KeteranganPengajuan'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Keterangan Pengajuan Bon Sementara !',
                );
                return $callback;
                exit;
            }
             
            if ($data['IDPegawaiOrder'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Nama Pegawai Pengajuan Bon Sementara Kosong !',
                );
                return $callback;
                exit;
            } 
            
            
            $NoTrsPencairan = $data['noTrs'];
            $noTrsPencairan2 = $data['noTrsPencairan']; 
            $TipePengajuan = $data['TipePengajuan'];
            $NilaiPengajuan = $data['NilaiPengajuan'];
            $IDPegawaiOrder = $data['IDPegawaiOrder'];
            $KeteranganPengajuan = $data['KeteranganPengajuan'];
            $TglPencairan = $data['TglPengajuan']; 
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $TGLENTRI = Utils::seCurrentDateTime();

            //cek rekening
            $IDrek_kasbon = "rek_kasbon";
            $this->db->query('SELECT rekening FROM Keuangan.DBO.TZ_Parameter_Keu WHERE parameter=:rek_kasbon');
            $this->db->bind('rek_kasbon', $IDrek_kasbon);
            $this->db->execute();
            $data =  $this->db->single();
            $val_rekening = $data['rekening'];
            if ($val_rekening === null || $val_rekening === "") { 
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Rekening Kasbon Kosong, Cek Parameter Sistem !',
                );
                return $callback;
                exit;
            } else {
                $val_rekening = $data['rekening'];
            }

            $IDrek_kasbon_kas = "rek_kasbon_kas";
            $this->db->query('SELECT rekening FROM Keuangan.DBO.TZ_Parameter_Keu WHERE parameter=:IDrek_kasbon_kas');
            $this->db->bind('IDrek_kasbon_kas', $IDrek_kasbon_kas);
            $this->db->execute();
            $data =  $this->db->single();
            $val_rekening_Kas = $data['rekening'];
            if ($val_rekening_Kas === null || $val_rekening_Kas === "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Rekening Kas Kasbon Kosong, Cek Parameter Sistem !',
                );
                return $callback;
                exit;
            }   
            
            date_default_timezone_set('Asia/Jakarta');
            $tahun = Utils::datenowcreateYearOnly();
            $bulan = Utils::datenowcreateMonthOnly(); 
            $notrs = Utils::idtrsByDateOnly();

            if($NoTrsPencairan == ""){
                // auto number
                $tgl_trs = $TGLENTRI;
               
                $this->db->query("SELECT  TOP 1 No_Transaksi,right(No_Transaksi,4) as nourut
                                FROM Keuangan.dbo.T_Kasbon  WHERE  
                              substring(No_Transaksi,3,6)=:No_Transaksi ORDER BY id DESC");
                $this->db->bind('No_Transaksi', $notrs); 
                $this->db->execute();
                $data =  $this->db->single();
                $nourut = $data['nourut'];
 
                if (empty($nourut)) {
                    //jika gk ada record
                    $nourut = "0001";
                } else {
                    //jika ada record
                    $nourut++;
                } 
                $nourutfix = Utils::generateAutoNumberFourDigit($nourut);
                $romawi = Utils::createMonthRomawi($bulan);
                $idxt = Utils::idtrsByDateOnly();
                $nokasbonAuto = $idxt;
                $notransaksi = 'KB' . $nokasbonAuto . '-' . $nourutfix;
              

                $this->db->query("SELECT No_Transaksi,Keterangan,Nominal from Keuangan.dbo.T_Kasbon
                            where Status_Finish='0' and Batal='0' and Pegawai=:Pegawai and No_Transaksi <> :No_Transaksi");
                $this->db->bind('Pegawai', $IDPegawaiOrder);
                $this->db->bind('No_Transaksi', $notransaksi);
                $this->db->execute();
                $dataval =  $this->db->single();
                $No_Transaksi = $dataval['No_Transaksi'];
                $Keterangan = $dataval['Keterangan'];
                $Nominal = $dataval['Nominal'];  
                if ($this->db->rowCount()) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Pegawai ini memiliki Outstanding Bon Sementara yang belum di Realisasikan. No. Transaksi : ' . $No_Transaksi . ", Keterangan : " . $Keterangan . ", Nominal : " . $Nominal ,
                    );
                    return $callback;
                    exit;
                }   

                
                $this->db->query("INSERT INTO Keuangan.dbo.T_Kasbon 
                                (No_Transaksi,Tgl_Transaksi,Pegawai,
                                Nominal,Keterangan,Tgl_Input_First,Petugas_Input_First,TipeKasbon) VALUES
                                (:notransaksi,:tgl_trs,:pegawai,
                                :nominal,:keterangan,:tgl_trss,:operator,:TipeKasbon)");
                $this->db->bind('notransaksi', $notransaksi);
                $this->db->bind('tgl_trs', $tgl_trs);
                $this->db->bind('pegawai', $IDPegawaiOrder);
                $this->db->bind('nominal', $NilaiPengajuan);
                $this->db->bind('keterangan', $KeteranganPengajuan);
                $this->db->bind('tgl_trss', $TGLENTRI);
                $this->db->bind('operator', $userid);
                $this->db->bind('TipeKasbon', $TipePengajuan); 
                $this->db->execute();
                $last = $this->db->GetLastID();

            }else{
                $tgl_trs = $TglPencairan;
                $notransaksi =  $noTrsPencairan2;
                $last = $NoTrsPencairan;
                $this->db->query("SELECT No_Transaksi,Keterangan,Nominal from Keuangan.dbo.T_Kasbon
                            where Status_Finish='0' and Batal='0' and Pegawai=:Pegawai and No_Transaksi <> :No_Transaksi");
                $this->db->bind('Pegawai', $IDPegawaiOrder);
                $this->db->bind('No_Transaksi', $noTrsPencairan2);
                $this->db->execute();
                $dataval =  $this->db->single();
                $No_Transaksi = $dataval['No_Transaksi'];
                $Keterangan = $dataval['Keterangan'];
                $Nominal = $dataval['Nominal'];  
                if ($this->db->rowCount()) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Pegawai ini memiliki Outstanding Bon Sementara yang belum di Realisasikan. No. Transaksi : ' . $No_Transaksi . ", Keterangan : " . $Keterangan . ", Nominal : " . $Nominal ,
                    );
                    return $callback;
                    exit;
                }   

                $this->db->query("UPDATE Keuangan.dbo.T_Kasbon SET
                                Tgl_Transaksi=:tgl_trs,Pegawai=:pegawai,
                                Nominal=:nominal,Keterangan=:keterangan,TipeKasbon=:TipeKasbon
                                where id=:notransaksi");
                $this->db->bind('notransaksi', $NoTrsPencairan); 
                $this->db->bind('pegawai', $IDPegawaiOrder);
                $this->db->bind('nominal', $NilaiPengajuan);
                $this->db->bind('keterangan', $KeteranganPengajuan);
                $this->db->bind('tgl_trs', $tgl_trs); 
                $this->db->bind('TipeKasbon', $TipePengajuan); 
                $this->db->execute();

                $this->db->query("DELETE Keuangan.dbo.TA_JURNAL_HDR
                                where FS_KD_JURNAL=:notransaksi ");
                $this->db->bind('notransaksi', $noTrsPencairan2);  
                $this->db->execute();

                $this->db->query("DELETE Keuangan.dbo.TA_JURNAL_DTL
                                where FS_KD_JURNAL=:notransaksi ");
                $this->db->bind('notransaksi', $noTrsPencairan2);  
                $this->db->execute();

            }

            //jurnal
            $this->db->query("INSERT INTO Keuangan.dbo.TA_JURNAL_HDR
                            (FS_KD_JURNAL,FD_TGL_JURNAL,FS_KD_PETUGAS,
                            FN_DEBET,FN_KREDIT,fn_jurnal,FB_SELESAI, FS_KET) values
                            (:notransaksi,:tgl_trs,:operator,
                            :nominal,:nominal2,:nominal3,:sts,:keterangan)");
            $this->db->bind('notransaksi', $notransaksi);
            $this->db->bind('tgl_trs', $tgl_trs);
            $this->db->bind('nominal', $NilaiPengajuan);
            $this->db->bind('nominal2', $NilaiPengajuan);
            $this->db->bind('nominal3', $NilaiPengajuan);
            $this->db->bind('keterangan', $KeteranganPengajuan);
            $this->db->bind('sts', '1');
            $this->db->bind('operator', $userid);
            $this->db->execute();

            $this->db->query("INSERT INTO Keuangan.dbo.TA_JURNAL_DTL
                            ( FS_KD_JURNAL,FS_KET_REFF,FN_DEBET,
                                FN_KREDIT,FB_VOID,FS_REK,FS_KD_UNIT,FB_LEDGER,FS_KD_REFF) values
                            (:notransaksi,:KeteranganJurnal,:nominal,
                                :nominal2,:nominal3,:val_rekening,:FS_KD_UNIT,:FB_LEDGER,:notransaksi2)");
            $this->db->bind('notransaksi', $notransaksi);
            $this->db->bind('notransaksi2', $notransaksi);
            $this->db->bind('val_rekening', $val_rekening);
            $this->db->bind('nominal', $NilaiPengajuan);
            $this->db->bind('nominal2', '0');
            $this->db->bind('nominal3', '0');
            $this->db->bind('KeteranganJurnal', $KeteranganPengajuan);
            $this->db->bind('FB_LEDGER', '0');
            $this->db->bind('FS_KD_UNIT', ''); 
            $this->db->execute();
            //KREDIT
            $this->db->query("INSERT INTO Keuangan.dbo.TA_JURNAL_DTL
                            ( FS_KD_JURNAL,FS_KET_REFF,FN_DEBET,
                                FN_KREDIT,FB_VOID,FS_REK,FS_KD_UNIT,FB_LEDGER,FS_KD_REFF) values
                            (:notransaksi,:KeteranganJurnal,:nominal2,
                                :nominal,:nominal3,:val_rekening_Kas,:FS_KD_UNIT,:FB_LEDGER,:notransaksi2)");
            $this->db->bind('notransaksi', $notransaksi);
            $this->db->bind('KeteranganJurnal', $KeteranganPengajuan);
            $this->db->bind('nominal2', '0');
            $this->db->bind('notransaksi2', $notransaksi);
            $this->db->bind('val_rekening_Kas', $val_rekening_Kas);
            $this->db->bind('nominal', $NilaiPengajuan);
            $this->db->bind('nominal3', '0');
            $this->db->bind('FB_LEDGER', '0');
            $this->db->bind('FS_KD_UNIT', '');
            $this->db->execute();
 
            $this->db->commit();
         
            $this->db->closeCon();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success 
                'id' => $last,
                'notransaksi' => $notransaksi,
                'nilairealisasi' => $NilaiPengajuan,
                'tglrealisasi' => $tgl_trs,
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
    public function showPencairanById($data)
    {
        try {

            $IDrek_kasbon_kas = "rek_kasbon_kas";
            $this->db->query('SELECT rekening FROM Keuangan.DBO.TZ_Parameter_Keu WHERE parameter=:IDrek_kasbon_kas');
            $this->db->bind('IDrek_kasbon_kas', $IDrek_kasbon_kas);
            $this->db->execute();
            $datarek=  $this->db->single();
            $val_rekening_Kas = $datarek['rekening'];
            if ($val_rekening_Kas === null || $val_rekening_Kas === "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Rekening Kas Kasbon Kosong, Cek Parameter Sistem !',
                );
                return $callback;
                exit;
            } else {
                $val_rekening_Kas = $datarek['rekening'];
            }

            $this->db->query("SELECT a.id as idpencairan,a.No_Transaksi as noTrsPencairan,
                            a.Tgl_Transaksi as tglPencairan,a.Keterangan as KeteranganPencairan,a.Nominal as NominalPencairan,
                            d.No_Transaksi as NotrsOrder,d.Nominal as NominalOrder,d.Tgl_Transaksi as TglOrder,
                            d.Keterangan as KeteranganOrder ,a.TipeKasbon,a.Pegawai,a.Nilai_Penyelesaian
                            from Keuangan.dbo.T_Kasbon a
                            inner join HRDYARSI.dbo.[Data Pegawai] b on a.Pegawai=b.ID_Data
                            inner join MasterDataSQL.dbo.Employees c on a.Petugas_Input_First  collate Latin1_General_CI_AS=c.NoPIN  collate Latin1_General_CI_AS
                            left join Keuangan.DBO.T_Order_Kasbon d on d.No_Transaksi_Kasbon = a.No_Transaksi
                            where a.id=:id");
            $this->db->bind('id', $data['IDNoTrsPencairan']);
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success',
                'idpencairan' => $data['idpencairan'],
                'noTrsPencairan' => $data['noTrsPencairan'],
                'KeteranganPencairan' => $data['KeteranganPencairan'],
                'Tgl_Transaksi' => $data['tglPencairan'],
                'tglPencairan' => date('Y-m-d', strtotime($data['tglPencairan'])),
                'NominalPencairan' => $data['NominalPencairan'],
                'NotrsOrder' => $data['NotrsOrder'],
                'NominalOrder' => $data['NominalOrder'],
                'TglOrder' => date('Y-m-d', strtotime($data['TglOrder'])),
                'KeteranganOrder' => $data['KeteranganOrder'],
                'TipeKasbon' => $data['TipeKasbon'],
                'Pegawai' => $data['Pegawai'],
                'Nilai_Penyelesaian' => $data['Nilai_Penyelesaian'],
                'rekeningkas' => $val_rekening_Kas,
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
    public function getDataGroupBiaya()
    {
        try {
            $this->db->query(" SELECT ID,NAMA_GROUP_BEBAN,KODE_COA 
                            FROM Keuangan.DBO.BO_M_BEBAN_HARIAN
                            WHERE AKTIF='1'");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['NAMA_GROUP_BEBAN'] = $key['NAMA_GROUP_BEBAN'];
                $rows[] = $pasing;
                $array['getbeban'] = $rows;
            }
            $callback = array(
                'status' => 'success', // Set array status dengan success
                'data' => $array, // Set array status dengan success 
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getRekeningKas()
    {
        try {
            $this->db->query("SELECT FS_KD_REKENING , FS_NM_REKENING
                                FROM Keuangan.DBO.TM_REKENING 
                                WHERE AKTIF='1' AND GROUP_REK='4' AND FS_KD_REKENING_GROUP='KAS'");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['FS_KD_REKENING'];
                $pasing['FS_NM_REKENING'] = $key['FS_NM_REKENING'];
                $rows[] = $pasing;
                $array['getrekkas'] = $rows;
            }
            $callback = array(
                'status' => 'success', // Set array status dengan success
                'data' => $array, // Set array status dengan success 
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function CreateKasbonDetil($data)
    {
        try {
            $this->db->transaksi();

            if ($data['IDNoTrsPencairan'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input No. Pencairan !',
                );
                return $callback;
                exit;
            }



            if ($data['TglPenyelesaian'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Tgl Penyesuaian !',
                );
                return $callback;
                exit;
            }
            if ($data['NilaiBiaya'] == "" || $data['NilaiBiaya'] == "0") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Nilai Biaya !',
                );
                return $callback;
                exit;
            }
            if ($data['NilaiPenyelesaian'] == "" || $data['NilaiPenyelesaian'] == "0") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Nilai Penyelesaian !',
                );
                return $callback;
                exit;
            }
            if ($data['NilaiBiaya'] > $data['NilaiPenyelesaian']) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Nilai Biaya Lebih Besar Dari Nilai Penyelesaian !',
                );
                return $callback;
                exit;
            }
            if ($data['TipeKasbon'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Tipe Kasbon !',
                );
                return $callback;
                exit;
            }
            if ($data['GroupBebanBiaya'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Group Beban !',
                );
                return $callback;
                exit;
            }
            if ($data['NamaPegawai'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Nama Pegawai !',
                );
                return $callback;
                exit;
            }
            $IDNoTrsPencairan = $data['IDNoTrsPencairan'];
            $NilaiPenyelesaian = $data['NilaiPenyelesaian'];
            $TglPenyelesaian = $data['TglPenyelesaian'];
            $TipeKasbon = $data['TipeKasbon'];
            $GroupBebanBiaya = $data['GroupBebanBiaya'];
            $NamaPegawai = $data['NamaPegawai'];
            $NilaiBiaya = $data['NilaiBiaya'];  

            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $TGLENTRI = Utils::seCurrentDateTime();

            //cek rekening
            $IDrek_kasbon = "rek_kasbon";
            $this->db->query('SELECT KODE_COA FROM Keuangan.DBO.BO_M_BEBAN_HARIAN WHERE ID=:ID');
            $this->db->bind('ID', $GroupBebanBiaya);
            $this->db->execute();
            $data =  $this->db->single();
            $KODE_COAX = $data['KODE_COA'];
            if ($KODE_COAX === null || $KODE_COAX === "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Rekening Kasbon Kosong, Cek Parameter Sistem !',
                );
                return $callback;
                exit;
            } else {
                $KODE_COAXX = $data['KODE_COA'];
            }

            //cek unit 
            $this->db->query("SELECT  Unit_1 
                            from HRDYARSI.dbo.[Data Pegawai]  
                            where ID_DATA=:IDPEG");
            $this->db->bind('IDPEG', $NamaPegawai);
            $this->db->execute();
            $dataunit =  $this->db->single();
            $kodeunit = $dataunit['Unit_1'];
            if ($kodeunit === null || $kodeunit === "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode Unit Kosong atau belum di Maping, cek Data Master Unit !',
                );
                return $callback;
                exit;
            } else {
                $kodeunit = $dataunit['Unit_1'];
            }

            // cek jika total detil yang ada melebihi total nilai penyelesaian
            $this->db->query("SELECT isnull(SUM(b.Nilai),0) as nilai
                    FROM Keuangan.DBO.T_Kasbon A INNER JOIN Keuangan.DBO.T_Kasbon_2 B
                    ON A.id = B.ID_Transaksi where a.id=:IDNoTrsPencairan and b.Batal='0'");
            $this->db->bind('IDNoTrsPencairan', $IDNoTrsPencairan);
            $this->db->execute();
            $dttotal =  $this->db->single();
            $totalx = $dttotal['nilai']; 
            $ttlbeban = $totalx+ $NilaiBiaya;
            if ($ttlbeban > $NilaiPenyelesaian) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Total Biaya melebihi Nilai Penyelesaian !',
                    'totalx' => $totalx,
                    'NilaiPenyelesaian' => $NilaiPenyelesaian,
                );
                return $callback;
                exit;
            }
            //jurnal
            $this->db->query("INSERT INTO Keuangan.dbo.T_Kasbon_2
                            (ID_Transaksi,Nilai,ID_Unit,ID_Kas,Batal,ID_Group_Beban) values
                            (:IDNoTrsPencairan,:NilaiBiaya,:kodeUnit,:KODE_COAXX,:batal,:ID_Group_Beban)");
            $this->db->bind('IDNoTrsPencairan', $IDNoTrsPencairan);
            $this->db->bind('NilaiBiaya', $NilaiBiaya);
            $this->db->bind('KODE_COAXX', $KODE_COAXX);
            $this->db->bind('kodeUnit', $kodeunit);
            $this->db->bind('ID_Group_Beban', $GroupBebanBiaya); 
            $this->db->bind('batal', '0'); 
            $this->db->execute();
 
            $this->db->commit(); 
            $this->db->closeCon();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success  
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
    public function showdetailPenyelesaian($data)
    {
        try {
            $iddata = $data['IDNoTrsPencairan'];
            $this->db->query("SELECT a.*,b.NamaUnit,c.FS_NM_REKENING , d.NAMA_GROUP_BEBAN
                                FROM Keuangan.dbo.T_Kasbon_2 a
                                inner join MasterDataSQL.dbo.MstrUnitPerwatan b on a.ID_Unit=b.ID
                                INNER JOIN Keuangan.dbo.TM_REKENING c ON A.ID_Kas = c.FS_KD_REKENING
                                inner join Keuangan.dbo.BO_M_BEBAN_HARIAN d on d.ID = a.ID_Group_Beban
                                WHERE ID_Transaksi=:iddata and Batal='0'
                                order by a.ID desc");
            $this->db->bind('iddata', $iddata);
            $data =  $this->db->resultSet();
            $rows = array(); 
            $no = 0;
            foreach ($data as $key) {
                $no++; 
                $pasing['no'] = $no;
                $pasing['ID'] = $key['ID'];
                $pasing['Nilai'] = $key['Nilai'];
                $pasing['ID_Kas'] = $key['ID_Kas'];
                $pasing['FS_NM_REKENING'] = $key['FS_NM_REKENING'];
                $pasing['NAMA_GROUP_BEBAN'] = $key['NAMA_GROUP_BEBAN']; 
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
    public function deleteIdDetailKasbon($data)
    {
        try {
            $this->db->transaksi();

            if ($data['IDDetails'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Masukan ID Detail !',
                );
                return $callback;
                exit;
            }

            $IDDetails = $data['IDDetails'];
   
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $TGLENTRI = Utils::seCurrentDateTime();

             
            //jurnal
            $this->db->query("UPDATE Keuangan.DBO.T_Kasbon_2 set 
                            Batal=:BATAL , Tgl_Batal=:TGLENTRI, Petugas_Batal=:userid
                            where ID=:IDDetails"); 
            $this->db->bind('IDDetails', $IDDetails);
            $this->db->bind('userid', $userid);
            $this->db->bind('TGLENTRI', $TGLENTRI);
            $this->db->bind('BATAL', '1');
            $this->db->execute();

            $this->db->commit();
            $this->db->closeCon();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Id Berhasil DiHapus !', // Set array status dengan success  
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
    public function FinishTrsPenyelesaianKasbon($data)
    {
        try {
            $this->db->transaksi();

            if ($data['IDNoTrsPencairan'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input No. Pencairan !',
                );
                return $callback;
                exit;
            }
            if ($data['TglPenyelesaian'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Tgl Penyesuaian !',
                );
                return $callback;
                exit;
            } 
            if ($data['NilaiPenyelesaian'] == "" || $data['NilaiPenyelesaian'] == "0") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Nilai Penyelesaian !',
                );
                return $callback;
                exit;
            }
            if ($data['TipeKasbon'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Tipe Kasbon !',
                );
                return $callback;
                exit;
            }
         
            if ($data['NamaPegawai'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Nama Pegawai !',
                );
                return $callback;
                exit;
            }
            $IDNoTrsPencairan = $data['IDNoTrsPencairan'];
            $NilaiPenyelesaian = $data['NilaiPenyelesaian'];
            $TglPenyelesaian = $data['TglPenyelesaian'];
            $TipeKasbon = $data['TipeKasbon'];


            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $TGLENTRI = Utils::seCurrentDateTime();
 
            // cek jika total detil yang ada melebihi total nilai penyelesaian
            $this->db->query("SELECT isnull(SUM(b.Nilai),0) as nilai
                    FROM Keuangan.DBO.T_Kasbon A INNER JOIN Keuangan.DBO.T_Kasbon_2 B
                    ON A.id = B.ID_Transaksi where a.id=:IDNoTrsPencairan and b.Batal='0'");
            $this->db->bind('IDNoTrsPencairan', $IDNoTrsPencairan);
            $this->db->execute();
            $dttotal =  $this->db->single();
            $totalx = $dttotal['nilai']; 
            if ($totalx < 0) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Total Biaya 0. Periksa Kembali Data Anda !',
                    'totalx' => $totalx,
                    'NilaiPenyelesaian' => $NilaiPenyelesaian,
                );
                return $callback;
                exit;
            }


            //cek rekening
            $IDrek_kasbon = "rek_kasbon";
            $this->db->query('SELECT rekening FROM Keuangan.DBO.TZ_Parameter_Keu WHERE parameter=:rek_kasbon');
            $this->db->bind('rek_kasbon', $IDrek_kasbon);
            $this->db->execute();
            $data =  $this->db->single();
            $val_rekening = $data['rekening'];
            if ($val_rekening === null || $val_rekening === "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Rekening Kasbon Kosong, Cek Parameter Sistem !',
                );
                return $callback;
                exit;
            } else {
                $val_rekening = $data['rekening'];
            }

            $IDrek_kasbon_kas = "rek_kasbon_kas";
            $this->db->query('SELECT rekening FROM Keuangan.DBO.TZ_Parameter_Keu WHERE parameter=:IDrek_kasbon_kas');
            $this->db->bind('IDrek_kasbon_kas', $IDrek_kasbon_kas);
            $this->db->execute();
            $data =  $this->db->single();
            $val_rekening_Kas = $data['rekening'];
            if ($val_rekening_Kas === null || $val_rekening_Kas === "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Rekening Kas Kasbon Kosong, Cek Parameter Sistem !',
                );
                return $callback;
                exit;
            } else {
                $val_rekening_Kas = $data['rekening'];
            }


            $kodeRegAwal = "KS";
            $datenow2 = date('Y-m-d');
            $formatDateJurnal =  Utils::idtrsByDateOnly();

            // cek sudah realisasi
            $rek_kasbon = "rek_kasbon";
            $this->db->query('SELECT rekening FROM Keuangan.DBO.TZ_Parameter_Keu WHERE parameter=:rek_kasbon');
            $this->db->bind('rek_kasbon', $rek_kasbon);
            $this->db->execute();
            $datarekeningkasbon =  $this->db->single();
            $xdatarekeningkasbon = $datarekeningkasbon['rekening'];

            
            // cek 
            $this->db->query("SELECT *
                            FROM Keuangan.DBO.T_Kasbon where  id=:id");
            $this->db->bind('id', $IDNoTrsPencairan); 
            $this->db->execute();
            $dt_exec_xrek_simpW =  $this->db->single();
            $No_Transaksi = $dt_exec_xrek_simpW['No_Transaksi'];
            $Nominal_Kasbon = $dt_exec_xrek_simpW['Nominal'];
            //auto number jurnal
            // $this->db->query("SELECT  TOP 1 FS_KD_JURNAL,right(FS_KD_JURNAL,3) as urutregx
            //                 FROM Keuangan.dbo.TA_JURNAL_HDR  WHERE  
            //                 SUBSTRING(FS_KD_JURNAL,3,6)=:formatDateJurnal AND LEFT(FS_KD_JURNAL,2)=:kodeRegAwal  
            //                 ORDER BY FS_KD_JURNAL DESC");
            // $this->db->bind('formatDateJurnal', $formatDateJurnal);
            // $this->db->bind('kodeRegAwal', $kodeRegAwal); 
            // $this->db->execute();
            // $data =  $this->db->single();
            // $nourut = $data['urutregx'];
            // if (empty($nourut)) {
            //     //jika gk ada record
            //     $nourut = "0001";
            // } else {
            //     //jika ada record
            //     $nourut++;
            // }
            // $nourutfix = Utils::generateAutoNumberFourDigit($nourut); 
            // $idxt = Utils::idtrsByDateOnly();
            // $nokasbonAuto = $idxt;
            $notransaksiJurnal = $No_Transaksi . '-P';

            //UPDATE SELESAI TABEL KASBON
            $this->db->query("UPDATE Keuangan.dbo.T_Kasbon 
                            SET Nilai_Penyelesaian=:nilai_penyelesaian,
                            Tgl_Penyelesaian=:tgl_penyelesaian,
                            PetugasPenyelesaian=:operator,Status_Finish=:Status_Finish,
                            TipeKasbon=:TipeKasbon
                            WHERE id=:id");
            $this->db->bind('nilai_penyelesaian', $NilaiPenyelesaian);
            $this->db->bind('tgl_penyelesaian', $TglPenyelesaian);
            $this->db->bind('operator', $userid);
            $this->db->bind('Status_Finish', '1');
            $this->db->bind('id', $IDNoTrsPencairan);
            $this->db->bind('TipeKasbon', $TipeKasbon); 
            $this->db->execute();

            //DELETE TABEL TA_JURNAL_HDR
            $this->db->query("DELETE Keuangan.dbo.TA_JURNAL_HDR
                           where fs_KD_jurnal in (
                                            SELECT FS_KD_JURNAL from Keuangan.dbo.TA_JURNAL_DTL
                                            where FS_KD_REFF=:FS_kd_REFF AND FS_kD_REG = 'PENYELESAIANKASBON'  
                                            )   ");
            $this->db->bind('FS_kd_REFF', $No_Transaksi); 
            $this->db->execute();


            $this->db->query("DELETE Keuangan.dbo.TA_JURNAL_DTL
            where FS_KD_REFF=:FS_kd_REFF AND FS_KD_REG = 'PENYELESAIANKASBON' ");
            $this->db->bind('FS_kd_REFF', $No_Transaksi); 
            $this->db->execute();

            //INSERT TABEL TA_JURNAL_HDR
            $this->db->query("INSERT INTO Keuangan.dbo.TA_JURNAL_HDR
                            (FS_KD_JURNAL,FD_TGL_JURNAL,FS_KD_PETUGAS,
                            FN_DEBET,FN_KREDIT,fn_jurnal,FB_SELESAI) values
                            (:NoJurnalFix,:tgl_penyelesaian,:userid,
                            :nilai_penyelesaian,:nilai_penyelesaian2,:nilai_penyelesaian3,:FB_SELESAI)");
            $this->db->bind('NoJurnalFix', $notransaksiJurnal);
            $this->db->bind('tgl_penyelesaian', $TglPenyelesaian);
            $this->db->bind('userid', $userid);
            $this->db->bind('nilai_penyelesaian', $NilaiPenyelesaian);
            $this->db->bind('nilai_penyelesaian2', $NilaiPenyelesaian);
            $this->db->bind('nilai_penyelesaian3', $NilaiPenyelesaian); 
            $this->db->bind('FB_SELESAI', '1'); 
            $this->db->execute();

            //INSERT TABEL TA_JURNAL_DTL BIAYA
            $KeteranganJurnal = "Penyelesaian Pencairan Kasbon " . $No_Transaksi;
            $this->db->query("INSERT INTO Keuangan.dbo.TA_JURNAL_DTL
                            ( FS_KD_JURNAL,FS_KET_REFF,FN_DEBET,
                            FN_KREDIT,FB_VOID,FS_REK,FS_KD_UNIT,FB_LEDGER,FS_KD_REFF,fs_kd_reg) 
                            SELECT '$notransaksiJurnal','$KeteranganJurnal',nilai,
                            '0','0',ID_Kas,ID_Unit,'0','$No_Transaksi','PENYELESAIANKASBON'
                            FROM Keuangan.DBO.T_Kasbon A INNER JOIN Keuangan.DBO.T_Kasbon_2 B
                            ON A.id = B.ID_Transaksi where a.id=:id and b.Batal='0'");
            $this->db->bind('id', $IDNoTrsPencairan); 
            $this->db->execute();

            //INSERT TABEL TA_JURNAL_DTL REK BON SEMENTARA
            $KeteranganJurnal = "Penyelesaian Pencairan Kasbon " . $No_Transaksi;
            $this->db->query("INSERT INTO Keuangan.dbo.TA_JURNAL_DTL
                            ( FS_KD_JURNAL,FS_KET_REFF,FN_DEBET,
                            FN_KREDIT,FB_VOID,FS_REK,FS_KD_UNIT,FB_LEDGER,FS_KD_REFF, FS_kd_reg) 
                            SELECT '$notransaksiJurnal','$KeteranganJurnal','0',
                            nilai,'0','$xdatarekeningkasbon',ID_Unit,'0','$No_Transaksi','PENYELESAIANKASBON'
                            FROM Keuangan.DBO.T_Kasbon A INNER JOIN Keuangan.DBO.T_Kasbon_2 B
                            ON A.id = B.ID_Transaksi where a.id=:id and b.Batal='0'");
            $this->db->bind('id', $IDNoTrsPencairan); 
            $this->db->execute();

            // JURNAL KAS 
            if ($NilaiPenyelesaian < $Nominal_Kasbon) {
                // Jurnal detil kasbon  
                $sisa = $Nominal_Kasbon - $NilaiPenyelesaian;
                $this->db->query("INSERT INTO Keuangan.dbo.TA_JURNAL_DTL
                                ( FS_KD_JURNAL,FS_KET_REFF,FN_DEBET,
                                FN_KREDIT,FB_VOID,FS_REK,FS_KD_UNIT,FB_LEDGER,FS_KD_REFF,FS_kd_reg) VALUES 
                                (:NoJurnalFix,:KeteranganJurnal,:sisa,
                                :FN_KREDIT,:FB_VOID,:val_rekening_Kas,:FS_KD_UNIT,:FB_LEDGER,:No_Transaksi,:PENYELESAIANKASBON)");
                $this->db->bind('NoJurnalFix', $notransaksiJurnal);
                $this->db->bind('KeteranganJurnal', $KeteranganJurnal);
                $this->db->bind('sisa', $sisa);
                
                $this->db->bind('PENYELESAIANKASBON','PENYELESAIANKASBON' );
                $this->db->bind('FN_KREDIT','0' );
                $this->db->bind('FB_VOID', '0');
                $this->db->bind('FB_LEDGER', '0');
                $this->db->bind('val_rekening_Kas', $val_rekening_Kas);
                $this->db->bind('No_Transaksi', $No_Transaksi);
                $this->db->bind('FS_KD_UNIT', '');
                $this->db->execute(); 

            } elseif ($NilaiPenyelesaian > $Nominal_Kasbon) {
                $kurang = $NilaiPenyelesaian - $Nominal_Kasbon;

                $this->db->query("INSERT INTO Keuangan.dbo.TA_JURNAL_DTL
                                ( FS_KD_JURNAL,FS_KET_REFF,FN_DEBET,
                                FN_KREDIT,FB_VOID,FS_REK,FS_KD_UNIT,FB_LEDGER,FS_KD_REFF,FS_kd_reg) VALUES 
                                (:NoJurnalFix,:KeteranganJurnal,:FN_DEBET,
                                :FN_KREDIT,:FB_VOID,:val_rekening_Kas,:FS_KD_UNIT,:FB_LEDGER,:No_Transaksi,:PENYELESAIANKASBON)");
                $this->db->bind('NoJurnalFix', $notransaksiJurnal);
                $this->db->bind('KeteranganJurnal', $KeteranganJurnal);
                $this->db->bind('PENYELESAIANKASBON','PENYELESAIANKASBON' );
                $this->db->bind('FN_DEBET', '0');
                $this->db->bind('FN_KREDIT', $kurang);
                $this->db->bind('FB_VOID', '0');
                $this->db->bind('FB_LEDGER', '0');
                $this->db->bind('val_rekening_Kas', $val_rekening_Kas);
                $this->db->bind('No_Transaksi', $No_Transaksi);
                $this->db->bind('FS_KD_UNIT', '');
                $this->db->execute(); 
            }

            if($TipeKasbon <> "CITO"){
                $this->db->query("INSERT INTO Keuangan.dbo.TA_JURNAL_DTL
                                ( FS_KD_JURNAL,FS_KET_REFF,FN_DEBET,
                                FN_KREDIT,FB_VOID,FS_REK,FS_KD_UNIT,FB_LEDGER,FS_KD_REFF,FS_kd_reg) VALUES 
                                (:NoJurnalFix,:KeteranganJurnal,:FN_DEBET,
                                :FN_KREDIT,:FB_VOID,:val_rekening,:FS_KD_UNIT,:FB_LEDGER,:No_Transaksi,:PENYELESAIANKASBON)");
                $this->db->bind('NoJurnalFix', $notransaksiJurnal);
                $this->db->bind('KeteranganJurnal', $KeteranganJurnal);
                
                $this->db->bind('PENYELESAIANKASBON','PENYELESAIANKASBON' );
                $this->db->bind('FN_DEBET', '0');
                $this->db->bind('FN_KREDIT', $Nominal_Kasbon);
                $this->db->bind('FB_VOID', '0');
                $this->db->bind('FB_LEDGER', '0');
                $this->db->bind('val_rekening', $val_rekening);
                $this->db->bind('No_Transaksi', $No_Transaksi);
                $this->db->bind('FS_KD_UNIT', '');
                $this->db->execute(); 
            }

            $this->db->commit();
            $this->db->closeCon();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success  
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
    public function showHistoryPencairan($data)
    {
        try {
            // $iddata = $data['IDNoTrsPencairan'];
            $this->db->query("SELECT  a.ID,A.Tgl_Transaksi as tglRealisai, b.Tgl_Transaksi as TglOrder, 
                        a.Nominal as NilaiRealisasi, b.Nominal as NIlaiOrder ,
                        a.Keterangan,c.Nama,a.TipeKasbon,A.No_Transaksi AS norealisasi, b.No_Transaksi as noorder
                        from Keuangan.dbo.T_Kasbon a
                        left join Keuangan.dbo.T_Order_Kasbon b
                        on A.No_Transaksi = B.NO_KASBON
                        inner join HRDYARSI.dbo.[Data Pegawai] c on a.Pegawai=c.ID_Data
                        where a.Batal='0'
                        order by 1 desc");  
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 0;
            foreach ($data as $key) {
                $no++;
                $pasing['no'] = $no;
                $pasing['ID'] = $key['ID'];
                $pasing['tglRealisai'] = $key['tglRealisai'];
                $pasing['TglOrder'] = $key['TglOrder'];
                $pasing['NIlaiOrder'] = $key['NIlaiOrder'];
                $pasing['NilaiRealisasi'] = $key['NilaiRealisasi'];
                $pasing['Keterangan'] = $key['Keterangan'];
                $pasing['Nama'] = $key['Nama'];
                $pasing['TipeKasbon'] = $key['TipeKasbon'];
                $pasing['norealisasi'] = $key['norealisasi'];
                $pasing['noorder'] = $key['noorder'];
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
    public function batalPencairanKasbon($data)
    {
        try {
            $this->db->transaksi();

            if ($data['noTrsPencairan'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input No. Pencairan !',
                );
                return $callback;
                exit;
            }
            if ($data['AlasanBatal'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Alasan !',
                );
                return $callback;
                exit;
            } 
           
            $IDNoTrsPencairan = $data['noTrsPencairan'];
            $AlasanBatal = $data['AlasanBatal']; 


            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $TGLENTRI = Utils::seCurrentDateTime();
 
            // cek jika total detil yang ada melebihi total nilai penyelesaian
            $this->db->query("SELECT Batal, Status_Finish from Keuangan.dbo.T_Kasbon where No_Transaksi=:IDNoTrsPencairan ");
            $this->db->bind('IDNoTrsPencairan', $IDNoTrsPencairan);
            $this->db->execute();
            $dttotal =  $this->db->single();
            $Batal = $dttotal['Batal']; 
            $Status_Finish = $dttotal['Status_Finish']; 
             
            // if ($Batal == "1") {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => 'Transaksi Sudah di batalkan !' 
            //     );
            //     return $callback;
            //     exit;
            // }
            // if ($Status_Finish == "1") {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => 'Transaksi Sudah di Realisasi, Tidak bisa di batalkan !' 
            //     );
            //     return $callback;
            //     exit;
            // }
 
            //UPDATE SELESAI TABEL KASBON
            $this->db->query("UPDATE Keuangan.dbo.T_Kasbon 
                            SET Batal=:Batal,
                            Petugas_Batal=:Petugas_Batal,
                            Tgl_Batal=:Tgl_Batal,
                            Alasan_Batal=:Alasan_Batal 
                            WHERE No_Transaksi=:No_Transaksi");
            $this->db->bind('Batal', '1');
            $this->db->bind('Petugas_Batal',  $userid); 
            $this->db->bind('Tgl_Batal',  $TGLENTRI); 
            $this->db->bind('No_Transaksi',  $IDNoTrsPencairan); 
            $this->db->bind('Alasan_Batal', $AlasanBatal); 
            $this->db->execute();

            $this->db->query("UPDATE Keuangan.dbo.T_Kasbon_2 
            SET Batal=:Batal,
            Petugas_Batal=:Petugas_Batal,
            Tgl_Batal=:Tgl_Batal
            WHERE ID_Transaksi=:No_Transaksi");
            $this->db->bind('Batal', '1');
            $this->db->bind('Tgl_Batal',  $TGLENTRI); 
            $this->db->bind('Petugas_Batal',  $userid); 
            $this->db->bind('No_Transaksi',  $IDNoTrsPencairan);  
            $this->db->execute();

            //DELETE TABEL TA_JURNAL_HDR
            $this->db->query("DELETE Keuangan.dbo.TA_JURNAL_HDR
                           where fs_KD_jurnal = :FS_kd_REFF  ");
            $this->db->bind('FS_kd_REFF', $IDNoTrsPencairan); 
            $this->db->execute();


            $this->db->query("DELETE Keuangan.dbo.TA_JURNAL_DTL
            where FS_KD_REFF=:FS_kd_REFF  ");
            $this->db->bind('FS_kd_REFF', $IDNoTrsPencairan); 
            $this->db->execute();

             
            $this->db->commit();
            $this->db->closeCon();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Dibatalkan !', // Set array status dengan success  
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
    public function batalPenyelesaianPencairanKasbon($data)
    {
        try {
            $this->db->transaksi();

            if ($data['noTrsPencairan'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input No. Pencairan !',
                );
                return $callback;
                exit;
            }
            if ($data['AlasanBatal'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Masukan Alasan !',
                );
                return $callback;
                exit;
            } 
           
            $IDNoTrsPencairan = $data['noTrsPencairan'];
            $AlasanBatal = $data['AlasanBatal']; 


            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $TGLENTRI = Utils::seCurrentDateTime();
 
            // cek jika total detil yang ada melebihi total nilai penyelesaian
            $this->db->query("SELECT Batal, Status_Finish from Keuangan.dbo.T_Kasbon where No_Transaksi=:IDNoTrsPencairan ");
            $this->db->bind('IDNoTrsPencairan', $IDNoTrsPencairan);
            $this->db->execute();
            $dttotal =  $this->db->single();
            $Batal = $dttotal['Batal']; 
            $Status_Finish = $dttotal['Status_Finish']; 
             
            // if ($Batal == "1") {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => 'Transaksi Sudah di batalkan !' 
            //     );
            //     return $callback;
            //     exit;
            // }
            // if ($Status_Finish == "1") {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => 'Transaksi Sudah di Realisasi, Tidak bisa di batalkan !' 
            //     );
            //     return $callback;
            //     exit;
            // }
 
            //UPDATE SELESAI TABEL KASBON
            $this->db->query("UPDATE Keuangan.dbo.T_Kasbon 
                            SET Batal=:Batal,
                            Petugas_Batal=:Petugas_Batal,
                            Tgl_Batal=:Tgl_Batal,
                            Alasan_Batal=:Alasan_Batal 
                            WHERE No_Transaksi=:No_Transaksi");
            $this->db->bind('Batal', '1');
            $this->db->bind('Petugas_Batal',  $userid); 
            $this->db->bind('Tgl_Batal',  $TGLENTRI); 
            $this->db->bind('No_Transaksi',  $IDNoTrsPencairan); 
            $this->db->bind('Alasan_Batal', $AlasanBatal); 
            $this->db->execute();

            $this->db->query("UPDATE Keuangan.dbo.T_Kasbon_2 
            SET Batal=:Batal,
            Petugas_Batal=:Petugas_Batal,
            Tgl_Batal=:Tgl_Batal
            WHERE ID_Transaksi=:No_Transaksi");
            $this->db->bind('Batal', '1');
            $this->db->bind('Tgl_Batal',  $TGLENTRI); 
            $this->db->bind('Petugas_Batal',  $userid); 
            $this->db->bind('No_Transaksi',  $IDNoTrsPencairan);  
            $this->db->execute();

            //DELETE TABEL TA_JURNAL_HDR
            $this->db->query("DELETE Keuangan.dbo.TA_JURNAL_HDR
                           where fs_KD_jurnal = :FS_kd_REFF  ");
            $this->db->bind('FS_kd_REFF', $IDNoTrsPencairan); 
            $this->db->execute();


            $this->db->query("DELETE Keuangan.dbo.TA_JURNAL_DTL
            where FS_KD_REFF=:FS_kd_REFF  ");
            $this->db->bind('FS_kd_REFF', $IDNoTrsPencairan); 
            $this->db->execute();

             
            $this->db->commit();
            $this->db->closeCon();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Dibatalkan !', // Set array status dengan success  
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
