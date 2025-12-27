<?php
class BonSementara_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getListDataBonSementara()
    {
        try {

            $query = "SELECT a.*,b.Nama from Keuangan.dbo.T_Order_Kasbon a
            inner join HRDYARSI.dbo.[Data Pegawai] b on a.Pegawai=b.ID_Data order by a.id desc";

            $this->db->query($query);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {
                $pasing['ID'] = $row['ID'];
                $pasing['No_Transaksi'] = $row['No_Transaksi'];
                // $pasing['No_Transaksi_Kasbon'] = $row['No_Transaksi_Kasbon'];
                $pasing['Tanggal'] = $row['Tgl_Transaksi'];
                $pasing['Pegawai'] = $row['Nama'];
                $pasing['Nominal'] = $row['Nominal'];
                $pasing['Keterangan'] = $row['Keterangan'];
                $pasing['No_Pencairan'] = $row['NO_KASBON'];
                $pasing['Tgl_Pencairan'] = $row['Tgl_Input_First'];
                $pasing['STATUS_Selesai'] = $row['STATUS'];


                // $pasing['Petugas_Input_First'] = $row['Petugas_Input_First'];
                // $pasing['ID_Group_Beban'] = $row['ID_Group_Beban'];
                // $pasing['discontinue'] = $row['discontinue'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getPegawai()
    {
        try {
            $this->db->query("SELECT ID_Data,Nama from HRDYARSI.dbo.[Data Pegawai] where Status_Aktif='1'");
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                // $pasing['KD_PDP'] = $key['KD_PDP'];
                $pasing['Nama'] = $key['Nama'];
                $pasing['ID_Data'] = $key['ID_Data'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDataBonbyID($data)
    {
        try {
            // var_dump($data);
            $IDs = $data['id'];
            $this->db->query("SELECT *,replace(CONVERT(VARCHAR(11), Tgl_Transaksi, 111), '/','-') as TglTransaksi
                        from Keuangan.dbo.T_Order_Kasbon
                        WHERE ID=:id");
            $this->db->bind('id', $IDs);
            $data =  $this->db->single();
            //var_dump($data);exit;
            $pasing['ID'] = $data['ID'];
            $pasing['No_Transaksi'] = $data['No_Transaksi'];
            $pasing['No_Transaksi_Kasbon'] = $data['No_Transaksi_Kasbon'];
            $pasing['Tgl_Transaksi'] = $data['TglTransaksi'];
            $pasing['Pegawai'] = $data['Pegawai'];
            $pasing['Nominal'] = $data['Nominal'];
            $pasing['Keterangan'] = $data['Keterangan'];
            $pasing['STATUS'] = $data['STATUS'];
            $pasing['NO_KASBON'] = $data['NO_KASBON'];
            $pasing['Tgl_Input_First'] = $data['Tgl_Input_First'];
            $pasing['Petugas_Input_First'] = $data['Petugas_Input_First'];
            $pasing['ID_Group_Beban'] = $data['ID_Group_Beban'];
            // $pasing['Alasan_Batal'] = $data['Alasan_Batal'];
            // $pasing['Status_Finish'] = $data['Status_Finish'];
            // $pasing['Tgl_Penyelesaian'] = $data['Tgl_Penyelesaian'];
            // $pasing['Nilai_Penyelesaian'] = $data['Nilai_Penyelesaian'];
            // $pasing['PetugasPenyelesaian'] = $data['PetugasPenyelesaian'];
            // $pasing['ID_Group_Beban'] = $data['ID_Group_Beban'];
            // $pasing['TipeKasbon'] = $data['TipeKasbon'];
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
    public function saveDataBon($data)
    {

        try {
            $this->db->transaksi();
            if ($data['Tgl_Transaksi'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input tgl !',
                );
                return $callback;
                exit;
            }
            if ($data['Nominal'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Nominal atau nominal !',
                );
                return $callback;
                exit;
            }
            if ($data['Pegawai'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Nama Pegawai !',
                );
                return $callback;
                exit;
            }
            if ($data['keterangan'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Keterangan !',
                );
                return $callback;
                exit;
            }
            $ID = $data['ID'];
            $Tgl_Transaksi = $data['Tgl_Transaksi'];
            $Nominal = $data['Nominal'];
            $Pegawai = $data['Pegawai'];
            $Keterangan = $data['keterangan'];
            // $Status = '0';
            // $TglBatal = $data['TglBatal'];
            // $AlasanBatal = $data['AlasanBatal'];
            // $kd_instalasi = $data['kd_instalasi'];

            $datenowcreate = Utils::seCurrentDateTime(); //Session user
            $session = SessionManager::getCurrentSession();
            $operator =  $session->IDEmployee;
            $userid = $session->username;

            // $ID_TR_TARIF = 'TRF280522002';

            $this->db->query("SELECT *from Keuangan.dbo.T_Order_Kasbon where ID=:ID AND STATUS='Realisasi'");
            $this->db->bind('ID',   $ID); 
            $datar =  $this->db->rowCount();
            if ($datar) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Transaksi Order Sudah Realisasi, Edit Di Batalkan !',
                );
                return $callback;
                exit;
            }

            if ($data['ID'] == "") {
                //var_dump($ID);

                $tahun = Date('Y');
                $bulan = Date('n');
                //GET URUT
                $datenowlis = date('dmy', strtotime($datenowcreate));
                $this->db->query("SELECT  TOP 1 No_Transaksi,right(No_Transaksi,4) as nourut
                FROM Keuangan.dbo.T_Order_Kasbon  WHERE  
               MONTH(Tgl_Transaksi) = :bulan AND YEAR(Tgl_Transaksi) = :tahun ORDER BY id DESC ");
                $this->db->bind('tahun',   $tahun);
                $this->db->bind('bulan',   $bulan);
                $data =  $this->db->single();
                $nourut = $data['nourut'];
                $substringlis = substr($nourut, 8);

                // Cek Rekening Parameter Kasbon

                if (empty($nourut)) {
                    //jika gk ada record
                    $nourut = "0001";
                } else {
                    //jika ada record
                    $nourut++;
                }

                if (strlen($nourut) == 1) {
                    $nourutfix = "000" . $nourut;
                } else if (strlen($nourut) == 2) {
                    $nourutfix = "00" . $nourut;
                } else if (strlen($nourut) == 3) {
                    $nourutfix = "0" . $nourut;
                } else if (strlen($nourut) == 4) {
                    $nourutfix = $nourut;
                }

                //Romawi
                if ($bulan == '1') {
                    $romawi = 'I';
                } elseif ($bulan == '2') {
                    $romawi = 'II';
                } elseif ($bulan == '3') {
                    $romawi = 'III';
                } elseif ($bulan == '4') {
                    $romawi = 'IV';
                } elseif ($bulan == '5') {
                    $romawi = 'V';
                } elseif ($bulan == '6') {
                    $romawi = 'VI';
                } elseif ($bulan == '7') {
                    $romawi = 'VII';
                } elseif ($bulan == '8') {
                    $romawi = 'VII';
                } elseif ($bulan == '9') {
                    $romawi = 'IX';
                } elseif ($bulan == '10') {
                    $romawi = 'X';
                } elseif ($bulan == '11') {
                    $romawi = 'XI';
                } elseif ($bulan == '12') {
                    $romawi = 'XII';
                }
                $nokasbonAuto = date('dmy', strtotime($datenowcreate));
                $notransaksi = 'ORK' . $nokasbonAuto . '-' . $nourutfix;




                //INSERT
                $this->db->query("INSERT INTO Keuangan.dbo.T_Order_Kasbon 
                (No_Transaksi,Tgl_Transaksi,Pegawai,
                  Nominal,Keterangan,Tgl_Input_First,Petugas_Input_First, Status) VALUES
                (:notransaksi,:Tgl_Transaksi,:Pegawai,:Nominal,:Keterangan,:datenowcreate,:operator,'Order')");
                $this->db->bind('notransaksi', $notransaksi);
                // $this->db->bind('Status', $Status);
                $this->db->bind('Tgl_Transaksi', $Tgl_Transaksi);
                $this->db->bind('Pegawai', $Pegawai);
                $this->db->bind('Nominal', $Nominal);
                $this->db->bind('Keterangan', $Keterangan);
                $this->db->bind('datenowcreate', $datenowcreate);
                $this->db->bind('operator', $userid);
            } else {

                $this->db->query("SELECT * FROM Keuangan.dbo.T_Order_Kasbon where ID=:ID AND No_Transaksi_Kasbon is not null ");
                $this->db->bind('ID',   $ID);
                $data =  $this->db->single();
                $IDx = $data['ID'];


                if ($IDx != null) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Order Sudah terealisasi, Simpan di Batalkan !',
                    );
                    echo json_encode($callback);
                    exit;
                }

                $this->db->query(" UPDATE Keuangan.dbo.T_Order_Kasbon SET 
                Tgl_Transaksi=:Tgl_Transaksi,Pegawai=:Pegawai,
                Nominal=:Nominal,Keterangan=:Keterangan
                 WHERE ID=:ID");
                $this->db->bind('ID', $ID);
                $this->db->bind('Tgl_Transaksi', $Tgl_Transaksi);
                $this->db->bind('Pegawai', $Pegawai);
                $this->db->bind('Nominal', $Nominal);
                $this->db->bind('Keterangan', $Keterangan);
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
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function batalDataBon($data)
    {
        try {
            $this->db->transaksi();
            // var_dump($data);
            // exit;
            $id = $data['ID'];
            $datenowcreate = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $operator =  $session->IDEmployee;
            $alasanbatal = $data['alasanbatal'];

            $this->db->query("UPDATE Keuangan.dbo.T_Kasbon SET Batal='1',Tgl_Batal=:datenowcreate,Petugas_Batal=:operator,
            Alasan_Batal= :alasanbatal WHERE id=:id");
            $this->db->bind('id', $id);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('operator', $operator);
            $this->db->bind('alasanbatal', $alasanbatal);


            $this->db->query(" UPDATE Keuangan.DBO.T_Order_Kasbon SET No_Transaksi_Kasbon=null,STATUS='Order'
            WHERE No_Transaksi_Kasbon  in (
             SELECT No_Transaksi FROM Keuangan.DBO.T_Kasbon WHERE ID=:id");
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
    public function cetakBon($ID)

    {
        try {
            $this->db->query("SELECT a.Nominal,a.Keterangan, b.Nama,convert(date,a.Tgl_Transaksi) as Tgl_Transaksi
                        FROM Keuangan.DBO.T_Kasbon a
                        inner join HRDYARSI.dbo.[Data Pegawai] b on a.Pegawai=b.ID_Data
                        WHERE a.ID=:ID");
            $this->db->bind('ID', $ID);
            $row =  $this->db->single();

            $passing['Nominal'] = $row['Nominal'];
            $passing['Keterangan'] = $row['Keterangan'];
            $passing['Nama'] = $row['Nama'];
            $passing['xTgl_Transaksi'] = $row['Tgl_Transaksi'];

            return $passing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    // {
    //     try {
    //         $this->db->transaksi();


    //         $this->db->query("SELECT *FROM Keuangan.dbo.T_Order_Kasbon");
    //         $this->db->bind('ID', $ID);

    //         $this->db->execute();
    //         $this->db->commit();
    //         $callback = array(
    //             'status' => 'success', // Set array status dengan success   
    //             'message' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success    
    //         );
    //         return $callback;
    //     } catch (PDOException $e) {
    //         $this->db->rollback();
    //         // $this->$e;
    //     }
    // }
}