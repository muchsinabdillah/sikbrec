<?php

class I_Order_Piutang_Model
{
    private $db;
    use ApiRsyarsi;


    public function __construct()
    {
        $this->db = new Database;
    }
    //Berkas Piutang//
    public function getDataBerkasPiutang($data)
    {
        try {
            $PeriodeAwal = $data['PeriodeAwal'];
            $PeriodeAkhir = $data['PeriodeAkhir'];
            $JenisBerkas = $data['JenisBerkas'];


            if ($JenisBerkas == "0") {
                $this->db->query("SELECT replace(CONVERT(VARCHAR(11), FD_TGL_VOID, 111), '/','-'),a.ID,FS_KD_TRS,
            replace(CONVERT(VARCHAR(11), FD_TGL_TRS, 111), '/','-') as FD_TGL_TRS,  
            FS_KET,FN_TOTAL_TAGIH ,Fb_Status_Kirim,Fs_No_Resi,
            replace(CONVERT(VARCHAR(11), Fd_Tgl_Dikirim, 111), '/','-') as Fd_Tgl_Dikirim,
            Fs_Petugas_Kirim,Fb_Status_Diiterima,replace(CONVERT(VARCHAR(11), Fd_Tgl_Diterima, 111), '/','-') as Fd_Tgl_Diterima
            ,Fs_Petugas_Penerima,Fb_Status_All,b.NamaPerusahaan
            from Keuangan.dbo.TA_ORDER_PIUTANG A
            INNER JOIN MasterdataSQL.DBO.MstrPerusahaanAsuransi B
            ON A.FS_KD_CUSTOMER = B.ID
            where replace(CONVERT(VARCHAR(11), FD_TGL_VOID, 111), '/','-')='3000-01-01'
            and replace(CONVERT(VARCHAR(11), FD_TGL_TRS, 111), '/','-') BETWEEN :PeriodeAwal AND :PeriodeAkhir
            and a.FS_JENIS_CUSTOMER='Asuransi' and Fb_Status_All='0'
            union all
            SELECT replace(CONVERT(VARCHAR(11), FD_TGL_VOID, 111), '/','-'),a.ID,FS_KD_TRS,
            replace(CONVERT(VARCHAR(11), FD_TGL_TRS, 111), '/','-') as FD_TGL_TRS,  
            FS_KET,FN_TOTAL_TAGIH ,Fb_Status_Kirim,Fs_No_Resi,
            replace(CONVERT(VARCHAR(11), Fd_Tgl_Dikirim, 111), '/','-') as Fd_Tgl_Dikirim,
            Fs_Petugas_Kirim,Fb_Status_Diiterima,replace(CONVERT(VARCHAR(11), Fd_Tgl_Diterima, 111), '/','-') as Fd_Tgl_Diterima
            ,Fs_Petugas_Penerima,Fb_Status_All,b.NamaPerusahaan
            from Keuangan.dbo.TA_ORDER_PIUTANG A
            INNER JOIN MasterdataSQL.DBO.MstrPerusahaanJPK B
            ON A.FS_KD_CUSTOMER = B.ID
            where replace(CONVERT(VARCHAR(11), FD_TGL_VOID, 111), '/','-')='3000-01-01'
            and replace(CONVERT(VARCHAR(11), FD_TGL_TRS, 111), '/','-') BETWEEN :PeriodeAwal1 AND :PeriodeAkhir1
            and a.FS_JENIS_CUSTOMER <>'Asuransi' and Fb_Status_All='0'");
                $this->db->bind('PeriodeAwal', $PeriodeAwal);
                $this->db->bind('PeriodeAwal1', $PeriodeAwal);
                $this->db->bind('PeriodeAkhir', $PeriodeAkhir);
                $this->db->bind('PeriodeAkhir1', $PeriodeAkhir);
                $data =  $this->db->resultSet();
            } elseif ($JenisBerkas == "1") {
                $this->db->query("SELECT replace(CONVERT(VARCHAR(11), FD_TGL_VOID, 111), '/','-'),a.ID,FS_KD_TRS,
            replace(CONVERT(VARCHAR(11), FD_TGL_TRS, 111), '/','-') as FD_TGL_TRS,  
            FS_KET,FN_TOTAL_TAGIH ,Fb_Status_Kirim,Fs_No_Resi,
            replace(CONVERT(VARCHAR(11), Fd_Tgl_Dikirim, 111), '/','-') as Fd_Tgl_Dikirim,
            Fs_Petugas_Kirim,Fb_Status_Diiterima,replace(CONVERT(VARCHAR(11), Fd_Tgl_Diterima, 111), '/','-') as Fd_Tgl_Diterima
            ,Fs_Petugas_Penerima,Fb_Status_All,b.NamaPerusahaan
            from Keuangan.dbo.TA_ORDER_PIUTANG A
            INNER JOIN MasterdataSQL.DBO.MstrPerusahaanAsuransi B
            ON A.FS_KD_CUSTOMER = B.ID
            where replace(CONVERT(VARCHAR(11), FD_TGL_VOID, 111), '/','-')='3000-01-01'
            and replace(CONVERT(VARCHAR(11), FD_TGL_TRS, 111), '/','-') BETWEEN :PeriodeAwal AND :PeriodeAkhir
            and a.FS_JENIS_CUSTOMER='Asuransi' and Fb_Status_All='1'
            union all
            SELECT replace(CONVERT(VARCHAR(11), FD_TGL_VOID, 111), '/','-'),a.ID,FS_KD_TRS,
            replace(CONVERT(VARCHAR(11), FD_TGL_TRS, 111), '/','-') as FD_TGL_TRS,  
            FS_KET,FN_TOTAL_TAGIH ,Fb_Status_Kirim,Fs_No_Resi,
            replace(CONVERT(VARCHAR(11), Fd_Tgl_Dikirim, 111), '/','-') as Fd_Tgl_Dikirim,
            Fs_Petugas_Kirim,Fb_Status_Diiterima,replace(CONVERT(VARCHAR(11), Fd_Tgl_Diterima, 111), '/','-') as Fd_Tgl_Diterima
            ,Fs_Petugas_Penerima,Fb_Status_All,b.NamaPerusahaan
            from Keuangan.dbo.TA_ORDER_PIUTANG A
            INNER JOIN MasterdataSQL.DBO.MstrPerusahaanJPK B
            ON A.FS_KD_CUSTOMER = B.ID
            where replace(CONVERT(VARCHAR(11), FD_TGL_VOID, 111), '/','-')='3000-01-01'
            and replace(CONVERT(VARCHAR(11), FD_TGL_TRS, 111), '/','-') BETWEEN :PeriodeAwal1 AND :PeriodeAkhir1
            and a.FS_JENIS_CUSTOMER <>'Asuransi' and Fb_Status_All='1' ");
                $this->db->bind('PeriodeAwal', $PeriodeAwal);
                $this->db->bind('PeriodeAwal1', $PeriodeAwal);
                $this->db->bind('PeriodeAkhir', $PeriodeAkhir);
                $this->db->bind('PeriodeAkhir1', $PeriodeAkhir);
                $data =  $this->db->resultSet();
            } elseif ($JenisBerkas == "2") { // Sudah Diterima
                $this->db->query("SELECT replace(CONVERT(VARCHAR(11), FD_TGL_VOID, 111), '/','-'),a.ID,FS_KD_TRS,
            replace(CONVERT(VARCHAR(11), FD_TGL_TRS, 111), '/','-') as FD_TGL_TRS,  
            FS_KET,FN_TOTAL_TAGIH ,Fb_Status_Kirim,Fs_No_Resi,
            replace(CONVERT(VARCHAR(11), Fd_Tgl_Dikirim, 111), '/','-') as Fd_Tgl_Dikirim,
            Fs_Petugas_Kirim,Fb_Status_Diiterima,replace(CONVERT(VARCHAR(11), Fd_Tgl_Diterima, 111), '/','-') as Fd_Tgl_Diterima
            ,Fs_Petugas_Penerima,Fb_Status_All,b.NamaPerusahaan
            from Keuangan.dbo.TA_ORDER_PIUTANG A
            INNER JOIN MasterdataSQL.DBO.MstrPerusahaanAsuransi B
            ON A.FS_KD_CUSTOMER = B.ID
            where replace(CONVERT(VARCHAR(11), FD_TGL_VOID, 111), '/','-')='3000-01-01'
            and replace(CONVERT(VARCHAR(11), FD_TGL_TRS, 111), '/','-') BETWEEN :PeriodeAwal AND :PeriodeAkhir
            and a.FS_JENIS_CUSTOMER='Asuransi' and Fb_Status_All='2'
            union all
            SELECT replace(CONVERT(VARCHAR(11), FD_TGL_VOID, 111), '/','-'),a.ID,FS_KD_TRS,
            replace(CONVERT(VARCHAR(11), FD_TGL_TRS, 111), '/','-') as FD_TGL_TRS,  
            FS_KET,FN_TOTAL_TAGIH ,Fb_Status_Kirim,Fs_No_Resi,
            replace(CONVERT(VARCHAR(11), Fd_Tgl_Dikirim, 111), '/','-') as Fd_Tgl_Dikirim,
            Fs_Petugas_Kirim,Fb_Status_Diiterima,replace(CONVERT(VARCHAR(11), Fd_Tgl_Diterima, 111), '/','-') as Fd_Tgl_Diterima
            ,Fs_Petugas_Penerima,Fb_Status_All,b.NamaPerusahaan
            from Keuangan.dbo.TA_ORDER_PIUTANG A
            INNER JOIN MasterdataSQL.DBO.MstrPerusahaanJPK B
            ON A.FS_KD_CUSTOMER = B.ID
            where replace(CONVERT(VARCHAR(11), FD_TGL_VOID, 111), '/','-')='3000-01-01'
            and replace(CONVERT(VARCHAR(11), FD_TGL_TRS, 111), '/','-') BETWEEN :PeriodeAwal1 AND :PeriodeAkhir1
            and a.FS_JENIS_CUSTOMER <>'Asuransi' and Fb_Status_All='2'");
                $this->db->bind('PeriodeAwal', $PeriodeAwal);
                $this->db->bind('PeriodeAwal1', $PeriodeAwal);
                $this->db->bind('PeriodeAkhir', $PeriodeAkhir);
                $this->db->bind('PeriodeAkhir1', $PeriodeAkhir);
                $data =  $this->db->resultSet();
            } elseif ($JenisBerkas == "3") { // All
                $this->db->query("SELECT replace(CONVERT(VARCHAR(11), FD_TGL_VOID, 111), '/','-'),a.ID,FS_KD_TRS,
            replace(CONVERT(VARCHAR(11), FD_TGL_TRS, 111), '/','-') as FD_TGL_TRS,  
            FS_KET,FN_TOTAL_TAGIH ,Fb_Status_Kirim,Fs_No_Resi,
            replace(CONVERT(VARCHAR(11), Fd_Tgl_Dikirim, 111), '/','-') as Fd_Tgl_Dikirim,
            Fs_Petugas_Kirim,Fb_Status_Diiterima,replace(CONVERT(VARCHAR(11), Fd_Tgl_Diterima, 111), '/','-') as Fd_Tgl_Diterima
            ,Fs_Petugas_Penerima,Fb_Status_All,b.NamaPerusahaan
            from Keuangan.dbo.TA_ORDER_PIUTANG A
            INNER JOIN MasterdataSQL.DBO.MstrPerusahaanAsuransi B
            ON A.FS_KD_CUSTOMER = B.ID
            where replace(CONVERT(VARCHAR(11), FD_TGL_VOID, 111), '/','-')='3000-01-01'
            and replace(CONVERT(VARCHAR(11), FD_TGL_TRS, 111), '/','-') BETWEEN :PeriodeAwal AND :PeriodeAkhir
            and a.FS_JENIS_CUSTOMER='Asuransi' 
            union all
            SELECT replace(CONVERT(VARCHAR(11), FD_TGL_VOID, 111), '/','-'),a.ID,FS_KD_TRS,
            replace(CONVERT(VARCHAR(11), FD_TGL_TRS, 111), '/','-') as FD_TGL_TRS,  
            FS_KET,FN_TOTAL_TAGIH ,Fb_Status_Kirim,Fs_No_Resi,
            replace(CONVERT(VARCHAR(11), Fd_Tgl_Dikirim, 111), '/','-') as Fd_Tgl_Dikirim,
            Fs_Petugas_Kirim,Fb_Status_Diiterima,replace(CONVERT(VARCHAR(11), Fd_Tgl_Diterima, 111), '/','-') as Fd_Tgl_Diterima
            ,Fs_Petugas_Penerima,Fb_Status_All,b.NamaPerusahaan
            from Keuangan.dbo.TA_ORDER_PIUTANG A
            INNER JOIN MasterdataSQL.DBO.MstrPerusahaanJPK B
            ON A.FS_KD_CUSTOMER = B.ID
            where replace(CONVERT(VARCHAR(11), FD_TGL_VOID, 111), '/','-')='3000-01-01'
            and replace(CONVERT(VARCHAR(11), FD_TGL_TRS, 111), '/','-') BETWEEN :PeriodeAwal1 AND :PeriodeAkhir1
            and a.FS_JENIS_CUSTOMER <>'Asuransi'  ");
                $this->db->bind('PeriodeAwal', $PeriodeAwal);
                $this->db->bind('PeriodeAwal1', $PeriodeAwal);
                $this->db->bind('PeriodeAkhir', $PeriodeAkhir);
                $this->db->bind('PeriodeAkhir1', $PeriodeAkhir);
                $data =  $this->db->resultSet();
            }
            $rows = array();
            foreach ($data as $row) {
                $pasing['ID'] = $row['ID'];
                $pasing['FS_KD_TRS'] = $row['FS_KD_TRS'];
                $pasing['FD_TGL_TRS'] = $row['FD_TGL_TRS'];
                $pasing['FS_KET'] = $row['FS_KET'];
                $pasing['FN_TOTAL_TAGIH'] = $row['FN_TOTAL_TAGIH'];
                $pasing['Fb_Status_Kirim'] = $row['Fb_Status_Kirim'];
                $pasing['Fs_No_Resi'] = $row['Fs_No_Resi'];
                $pasing['Fd_Tgl_Dikirim'] = $row['Fd_Tgl_Dikirim'];
                $pasing['Fs_Petugas_Kirim'] = $row['Fs_Petugas_Kirim'];
                $pasing['Fb_Status_Diiterima'] = $row['Fb_Status_Diiterima'];
                $pasing['Fd_Tgl_Diterima'] = $row['Fd_Tgl_Diterima'];
                $pasing['Fs_Petugas_Penerima'] = $row['Fs_Petugas_Penerima'];
                $pasing['Fb_Status_All'] = $row['Fb_Status_All'];
                $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function kirimtagihagoGenerateSelisihn($data)
    {
        try {
            $this->db->transaksi();
            $KirimNoTagihan = $data['KirimNoTagihan']; // ok
            $KirimPetugas = $data['KirimPetugas']; // ok
            $Kirimtgl = $data['Kirimtgl']; // ok
            $JenisBerkas = $data['JenisBerkas']; // ok

            // TRIGER SEBELUM SIMPAN DATA
            // 1. TRIGER PASIEN JIKA JENIS BELUM DIISI  
            if ($KirimPetugas == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Nama Pengirim Tidak Boleh Kosong!',
                );
                echo json_encode($callback);
                exit;
            }
            // 1. TRIGER PASIEN JIKA ALASAN
            if ($Kirimtgl == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'TGL Kirim tidak boleh kosong!',
                );
                echo json_encode($callback);
                exit;
            }


            $this->db->query("UPDATE Keuangan.dbo.TA_ORDER_PIUTANG set 
            Fs_Petugas_Kirim=:KirimPetugas,Fd_Tgl_Dikirim=:Kirimtgl,Fb_Status_All='1' 
            ,Fb_Status_Kirim='1' 
            where ID=:KirimNoTagihan");
            $this->db->bind('KirimPetugas', $KirimPetugas);
            $this->db->bind('Kirimtgl', $Kirimtgl);
            $this->db->bind('KirimNoTagihan', $KirimNoTagihan);
            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Status Pengiriman Berhasil Disimpan !',
                'KirimNoTagihan' => $KirimNoTagihan, // Set array status dengan success 
                'KirimPetugas' => $KirimPetugas, // Set array status dengan success 
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
    public function batalkirimtagihan($data)
    {
        try {
            $this->db->transaksi();
            $KirimNoTagihanBatalKirim = $data['KirimNoTagihanBatalKirim']; // ok
            // $this->db->query("SELECT COUNT(*) as jumlah
            // from Keuangan.dbo.TA_ORDER_PIUTANG 
            // where  ID=:KirimNoTagihanBatalKirim and Fb_Status_kirim = '2'");
            // $this->db->bind('KirimNoTagihanBatalKirim', $KirimNoTagihanBatalKirim);
            // $datax =  $this->db->single();
            // if ($datax > 0) {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => 'Berkas Sudah Di Kirim !',
            //     );
            //     return $callback;
            //     exit;
            // }

            $this->db->query("UPDATE Keuangan.dbo.TA_ORDER_PIUTANG set 
            Fs_Petugas_Kirim='',Fd_Tgl_Dikirim='',Fb_Status_All='0' 
            ,Fb_Status_Kirim='0' 
            where ID=:KirimNoTagihanBatalKirim");
            $this->db->bind('KirimNoTagihanBatalKirim', $KirimNoTagihanBatalKirim);

            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Status Batal Pengiriman Berhasil Disimpan !',
                'KirimNoTagihanBatalKirim' => $KirimNoTagihanBatalKirim, // Set array status dengan success 
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
    public function kirimtagihanditerima($data)
    {
        try {
            $this->db->transaksi();
            $KirimNoTagihanditerima = $data['KirimNoTagihanditerima']; // ok
            $KirimPetugasDiterima = $data['KirimPetugasDiterima']; // ok
            $KirimtglDiterima = $data['KirimtglDiterima']; // ok
            $JenisBerkas = $data['JenisBerkas']; // ok

            // TRIGER SEBELUM SIMPAN DATA
            // 1. TRIGER PASIEN JIKA JENIS BELUM DIISI  
            if ($KirimPetugasDiterima == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Nama Pengirim Tidak Boleh Kosong!',
                );
                echo json_encode($callback);
                exit;
            }
            // 1. TRIGER PASIEN JIKA ALASAN
            if ($KirimtglDiterima == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'TGL Kirim tidak boleh kosong!',
                );
                echo json_encode($callback);
                exit;
            }

            // $this->db->query("SELECT COUNT(*) as jumlah
            // from Keuangan.dbo.TA_ORDER_PIUTANG 
            // where  ID=:KirimNoTagihanditerima and Fb_Status_kirim = '0'");
            // $this->db->bind('KirimNoTagihanditerima', $KirimNoTagihanditerima);
            // $datax =  $this->db->single();
            // if ($datax > 0) {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => 'Berkas Belum Di Kirim !',
            //     );
            //     return $callback;
            //     exit;
            // }

            $this->db->query("UPDATE Keuangan.dbo.TA_ORDER_PIUTANG set 
            Fs_Petugas_Penerima=:KirimPetugasDiterima,Fd_Tgl_Diterima=:KirimtglDiterima,Fb_Status_All='2' 
            ,Fb_Status_Diiterima='1' 
            where ID=:KirimNoTagihanditerima");
            $this->db->bind('KirimPetugasDiterima', $KirimPetugasDiterima);
            $this->db->bind('KirimtglDiterima', $KirimtglDiterima);
            $this->db->bind('KirimNoTagihanditerima', $KirimNoTagihanditerima);
            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Status Pengiriman Berhasil Disimpan !',
                'KirimPetugasDiterima' => $KirimPetugasDiterima, // Set array status dengan success 
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
    //         $this->db->commit();
    //         $callback = array(
    //             'status' => 'success',
    //             'message' => 'Status Pengiriman Berhasil Disimpan !'
    //         );
    //         return $callback;
    //     } catch (PDOException $e) {
    //         $callback = array(
    //             'status' => "error", // Set array nama  
    //             'message' => $e
    //         );
    //         return $callback;
    //     }
    // }
    public function batalkirimtagihanditerima($data)
    {
        try {
            $this->db->transaksi();
            $KirimNoTagihanBatalDiterima = $data['KirimNoTagihanBatalDiterima']; // ok


            // $this->db->query("SELECT COUNT(*) as jumlah
            // from Keuangan.dbo.TA_ORDER_PIUTANG 
            // where  ID=:KirimNoTagihanBatalKirim and Fb_Status_kirim = '2'");
            // $this->db->bind('KirimNoTagihanBatalKirim', $KirimNoTagihanBatalKirim);
            // $datax =  $this->db->single();
            // if ($datax > 0) {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => 'Berkas Sudah Di Kirim !',
            //     );
            //     return $callback;
            //     exit;
            // }

            $this->db->query("UPDATE Keuangan.dbo.TA_ORDER_PIUTANG set 
            Fs_Petugas_Penerima='',Fd_Tgl_Diterima='',Fb_Status_All='1' 
            ,Fb_Status_Diiterima='0' 
            where ID=:KirimNoTagihanBatalDiterima");
            $this->db->bind('KirimNoTagihanBatalDiterima', $KirimNoTagihanBatalDiterima);

            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Status Batal Pengiriman Berhasil Disimpan !',
                'KirimNoTagihanBatalKirim' => $KirimNoTagihanBatalDiterima, // Set array status dengan success 
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
    //Berkas Piutang//

    //pelunasan piutang//
    public function newInsertPelunasan($data)
    {
        date_default_timezone_set('Asia/Jakarta');
        $datenow2 = Date('Y-m');
        $tahun = Date('Y');
        $bulan = Date('mY');

        $session = SessionManager::getCurrentSession();
        $userid = $session->username;
        $datenowcreate = Utils::seCurrentDateTime();

        try {
            $this->db->transaksi();
            // $kodeawal = "OP";

            $this->db->query("SELECT  TOP 1 FS_KD_TRS,right(FS_KD_TRS,4) as urutregx
            FROM Keuangan.dbo.TA_PTG_LUNAS_HDR  WHERE  
            SUBSTRING(replace(CONVERT(VARCHAR(11), DATE_CREATE, 111), '/','-'),1,7) =:datenow2  
            ORDER BY DATE_CREATE DESC");
            $this->db->bind('datenow2', $datenow2);
            // $this->db->bind('kodeawal', $kodeawal);
            $data =  $this->db->single();
            $nexturut = $data['urutregx'];

            if (empty($nexturut)) {
                //jika gk ada record
                $nourutfix = "0001";
            } else {
                //jika ada record
                $idReg = $nexturut;
                $idReg++;
                if (strlen($idReg) == 1) {
                    $nourutfix = "000" . $idReg;
                } else if (strlen($idReg) == 2) {
                    $nourutfix = "00" . $idReg;
                } else if (strlen($idReg) == 3) {
                    $nourutfix = "0" . $idReg;
                } else if (strlen($idReg) == 4) {
                    $nourutfix = $idReg;
                }
            }

            $NoPelunasan = 'OPL' . $bulan . '-' . $nourutfix;
            $pasing['NoPelunasan'] = $NoPelunasan;




            //  insert ke tabel TA_ORDER_PIUTANG
            $this->db->query("INSERT INTO Keuangan.DBO.TA_PTG_LUNAS_HDR (FS_KD_TRS,FD_TGL_TRS,FS_KD_PETUGAS,DATE_CREATE) 
            VALUES
            (:notransaksi,:datenowcreate,:userid,:datenowcreate1)");

            $this->db->bind('notransaksi', $NoPelunasan);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('userid', $userid);
            $this->db->bind('datenowcreate1', $datenowcreate);

            $this->db->execute();

            $this->db->commit();
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
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
    public function LunasAll($data)
    {
        try {
            $this->db->transaksi();
            // var_dump($data);
            // exit;
            // TRIGER SEBELUM SIMPAN DATA

            $JM_ID = $data['JM_ID'];
            $JM_Keterangan = $data['JM_Keterangan'];
            $JM_NIlaiSisa = $data['JM_NIlaiSisa'];
            $JM_NilaiVerif = $data['JM_NilaiVerif'];

            $NoPelunasan = $data['NoPelunasan'];
            $jaminan = $data['jaminan'];
            $kdrekanan = $data['kdrekanan'];
            $TglTransaksi = $data['TglTransaksi'];
            $NoOrder = $data['NoOrder'];
            $jenispasien = $data['jenispasien'];
            $NamaPenjamin = $data['NamaPenjamin'];
            $RekeningPelunasan = $data['RekeningPelunasan'];
            $Rekeningx = $data['Rekeningx'];
            // $JM_NilaiVerif =  $data['JM_NilaiVerif'];
            $PL_Discount =  $data['PL_Discount'];
            $PL_Materai =  $data['PL_Materai'];
            $PL_BiayaLain =  $data['PL_BiayaLain'];

            if ($NoPelunasan == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. Transaksi Pelunasan Kosong !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($jaminan == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Jenis Penjamin Kosong !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($kdrekanan == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode Penjamin Kosong !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($TglTransaksi == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Tanggal Pelunasan Kosong !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($NoOrder == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. Transasksi Order Kosong !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($jenispasien == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Jenis Registrasi Kosong !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($RekeningPelunasan == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Rekning Pelunasan Kosong !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($Rekeningx == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Rekening Penjamin Kosong !',
                );
                echo json_encode($callback);
                exit;
            }

            $this->db->query("SELECT fn_sisa ,KD_PIUTANG FROM Keuangan.DBO.PIUTANG_PASIEN WHERE FS_KD_TAGIH=:NoOrder");
            $this->db->bind('NoOrder', $NoOrder);
            // $this->db->bind('kodeawal', $kodeawal);
            $datax =  $this->db->single();
            $fn_sisa = $datax['fn_sisa'];
            $KD_PIUTANG = $datax['KD_PIUTANG'];

            $this->db->query("UPDATE Keuangan.dbo.TA_PTG_LUNAS_DTL SET NILAI_PAY=:fn_sisa 
            where FS_KD_TRS=:NoPelunasan and KD_PIUTANG = :KD_PIUTANG");
            $this->db->bind('NoPelunasan', $NoPelunasan);
            $this->db->bind('fn_sisa', $fn_sisa);
            $this->db->bind('KD_PIUTANG', $KD_PIUTANG);
            $this->db->execute();

            $this->db->query("SELECT sum(isnull(NILAI_PAY,0)) as NILAI_PAY FROM Keuangan.DBO.TA_PTG_LUNAS_DTL
            where FB_BATAL='0' and FS_KD_TRS=:NoPelunasan2");
            $this->db->bind('NoPelunasan2', $NoPelunasan);
            // $this->db->bind('kodeawal', $kodeawal);
            $datacount =  $this->db->single();
            $NILAI_PAY = $datacount['NILAI_PAY'];

            $GetCountVal = count($datacount);
            if ($GetCountVal <  0) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Data Pelunasan Detil Invalid !',
                );
                echo json_encode($callback);
                exit;
            } else {

                $NILAI_PAY =  $datacount['NILAI_PAY'];
                $Fn_Total_bayar = $NILAI_PAY - ($PL_Materai + $PL_BiayaLain + $PL_Discount);

                $qupdtHdr = "UPDATE Keuangan.dbo.TA_PTG_LUNAS_HDR
                            SET KD_TRS_ORDER=:NoOrder,
                            FN_LUNAS=:NILAI_PAY, FS_KD_JAMINAN=:kdrekanan,  
                            GROUP_JAMINAN=:jaminan,JENIS_REG=:jenispasien,FS_REKENING=:RekeningPelunasan,
                            FD_TGL_TRS=:TglTransaksi,FS_REKENING_JAMINAN=:Rekeningx,
                            FN_MATERAI=:PL_Materai,FN_BIAYA_LAIN=:PL_BiayaLain,
                            FN_DISKON_LAIN=:PL_Discount,FN_TOTAL_LUNAS=:Fn_Total_bayar
                            WHERE FS_KD_TRS=:NoPelunasan  ";
                $this->db->bind('NoOrder', $NoOrder);
                $this->db->bind('NILAI_PAY', $NILAI_PAY);
                $this->db->bind('kdrekanan', $kdrekanan);
                $this->db->bind('jaminan', $jaminan);
                $this->db->bind('jenispasien', $jenispasien);
                $this->db->bind('TglTransaksi', $TglTransaksi);
                $this->db->bind('Rekeningx', $Rekeningx);
                $this->db->bind('PL_Materai', $PL_Materai);
                $this->db->bind('PL_BiayaLain', $PL_BiayaLain);
                $this->db->bind('PL_Discount', $PL_Discount);
                $this->db->bind('Fn_Total_bayar', $Fn_Total_bayar);
                $this->db->bind('NoPelunasan', $NoPelunasan);
                $this->db->bind('RekeningPelunasan', $RekeningPelunasan);
                $this->db->execute();
            }


            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Lunas All Berhasil !',
                'NILAI_PAY' => $NILAI_PAY, // Set array status dengan success 
                'Fn_Total_bayar' => $Fn_Total_bayar, // Set array status dengan success 
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
    public function CreateHdrPelunasanDTL($data)
    {
        // var_dump($data);
        // exit;
        $KD_Order = $data['randID'];
        $NoPelunasan = $data['NoPelunasan'];
        // var_dump($KD_Order, $NoPelunasan);
        // exit;
        try {
            $this->db->transaksi();
            // $kodeawal = "OP";

            $this->db->query("DELETE FROM  Keuangan.DBO.TA_PTG_LUNAS_DTL  WHERE FS_KD_TRS=:NoPelunasan");
            $this->db->bind('NoPelunasan', $NoPelunasan);
            // $this->db->bind('kodeawal', $kodeawal);
            // $data =  $this->db->single();
            // $nexturut = $data['urutregx'];



            //  insert ke tabel TA_ORDER_PIUTANG
            $this->db->query("INSERT INTO Keuangan.DBO.TA_PTG_LUNAS_DTL (FS_KD_TRS,KD_TRS_ORDER,KD_PIUTANG,SISA_PIUTANG,NILAI_PAY,FB_BATAL,KET,KD_DR)
            SELECT :NoPelunasan , FS_KD_TAGIH as KD_ORDER, KD_PIUTANG as KD_HUTANG, 
            fn_sisa as SISA_HUTANG,'0','0' ,FS_KET,''
              FROM Keuangan.DBO.PIUTANG_PASIEN WHERE FS_KD_TAGIH IN (
              SELECT FS_KD_TRS FROM Keuangan.DBO.TA_ORDER_PIUTANG WHERE ID=:KD_Order
              ) AND fn_sisa<>'0' AND FB_BATAL='0'");

            $this->db->bind('NoPelunasan', $NoPelunasan);
            $this->db->bind('KD_Order', $KD_Order);


            $this->db->execute();

            $this->db->commit();
            $callback = array(
                'message' => "success", // Set array nama 
                // 'data' => $pasing
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
    public function AppendsVerifikasi($data)
    {

        try {
            $this->db->transaksi();
            // $kodeawal = "OP";
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $NoPelunasan = $data['NoPelunasan'];
            $NoOrder = $data['NoOrder'];
            $kdrekanan = $data['kdrekanan'];
            $TglTransaksi = $data['TglTransaksi'];
            $RekeningPelunasan = $data['RekeningPelunasan'];
            $jaminan  = $data['jaminan'];
            $jenispasien = $data['jenispasien'];
            $Rekeningx = $data['Rekeningx'];
            $PL_Subtotal = $data['PL_Subtotal'];
            $PL_Discount = $data['PL_Discount'];
            $PL_Materai = $data['PL_Materai'];
            $PL_BiayaLain = $data['PL_BiayaLain'];
            $PL_Grandtotal = $data['PL_Grandtotal'];
            $tglberkas  = $data['tglberkas'];
            $namapenerimaberkas  = $data['namapenerimaberkas'];
            $totalPlKas = $PL_Subtotal - ($PL_Discount + $PL_Materai + $PL_BiayaLain);

            // if ($tglberkas == "3000-01-01") {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => 'Mohon Isi Tanggal Berkas Diterima !',
            //     );
            //     echo json_encode($callback);
            //     exit;
            // }

            if ($namapenerimaberkas == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Mohon Isi Nama Penerima !',
                );
                echo json_encode($callback);
                exit;
            }

            if ($NoPelunasan == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Id   Invalid !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($RekeningPelunasan == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Rekening Kas Pelunasan Invalid !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($jenispasien == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Jenis Registrasi Invalid !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($Rekeningx == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Rekening Pelunasan PIutang Invalid, Cek Master Jaminan Anda. Pastikan Sudah terisi Piutang !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($TglTransaksi == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Tanggal Pelunasan Invalid !',
                );
                echo json_encode($callback);
                exit;
            }

            // Cek Rekening Pelunasan
            $this->db->query(" SELECT sum(isnull(NILAI_PAY,0)) as NILAI_PAY FROM Keuangan.DBO.TA_PTG_LUNAS_DTL
            where FB_BATAL='0' and FS_KD_TRS=:NoPelunasan");
            $this->db->bind('NoPelunasan', $NoPelunasan);
            // $this->db->bind('kodeawal', $kodeawal);
            $datax =  $this->db->single();
            $NILAI_PAY = $datax['NILAI_PAY'];

            if ($NILAI_PAY === null || $NILAI_PAY === "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Nilai Pay Kosong !',
                );
                echo json_encode($callback);
                exit;
            } else {
                $NILAI_PAY = $datax['NILAI_PAY'];
            }
            // Cek Rekening Diskon
            $this->db->query("  SELECT ISNULL(rekening,'') AS rekening FROM Keuangan.DBO.TZ_Parameter_Keu 
    where parameter='rek_pl_diskon'");
            // $this->db->bind('NoPelunasan', $NoPelunasan);
            // $this->db->bind('kodeawal', $kodeawal);
            $datadiskon =  $this->db->single();
            $rekeningDiscPL = $datadiskon['rekening'];
            if ($rekeningDiscPL === null || $rekeningDiscPL === "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Rekening Diskon Kosong !',
                );
                echo json_encode($callback);
                exit;
            } else {
                $rekeningDiscPL = $datadiskon['rekening'];
            }

            // Cek Rekening Materai
            $this->db->query("SELECT ISNULL(rekening,'') AS rekening FROM Keuangan.DBO.TZ_Parameter_Keu 
    where parameter='rek_pl_materai'");
            // $this->db->bind('NoPelunasan', $NoPelunasan);
            // $this->db->bind('kodeawal', $kodeawal);
            $datamaterai =  $this->db->single();
            $rekeningMateraiPL = $datamaterai['rekening'];
            if ($rekeningMateraiPL === null || $rekeningMateraiPL === "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Rekening Materai Kosong !',
                );
                echo json_encode($callback);
                exit;
            } else {
                $rekeningMateraiPL = $datamaterai['rekening'];
            }


            // Cek Rekening Biaya Lain
            $this->db->query("SELECT ISNULL(rekening,'') AS rekening FROM Keuangan.DBO.TZ_Parameter_Keu 
        where parameter='rek_pl_biaya_transfer'");
            // $this->db->bind('NoPelunasan', $NoPelunasan);
            // $this->db->bind('kodeawal', $kodeawal);
            $databiayalain =  $this->db->single();
            $rekeningBiayaTrfPL = $databiayalain['rekening'];
            if ($rekeningBiayaTrfPL === null || $rekeningBiayaTrfPL === "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Rekening Biaya Transfer Kosong !',
                );
                echo json_encode($callback);
                exit;
            } else {
                $rekeningBiayaTrfPL = $databiayalain['rekening'];
            }

            // DELETE
            $this->db->query("DELETE Keuangan.DBO.TA_JURNAL_HDR WHERE FS_KD_JURNAL=:NoPelunasan");
            $this->db->bind('NoPelunasan', $NoPelunasan);
            $this->db->execute();



            $this->db->query("DELETE Keuangan.DBO.TA_JURNAL_DTL WHERE FS_KD_JURNAL=:NoPelunasan");
            $this->db->bind('NoPelunasan', $NoPelunasan);
            $this->db->execute();



            //  insert ke tabel TA_JURNAL_HDR
            $this->db->query("INSERT INTO Keuangan.DBO.TA_JURNAL_HDR (FS_KD_JURNAL,FD_TGL_JURNAL,FN_DEBET,FN_KREDIT,FN_JURNAL,FS_KD_PETUGAS,FB_SELESAI)
            VALUES
            (:NoPelunasan,:TglTransaksi,:NILAI_PAY,:NILAI_PAY1,:NILAI_PAY2,:userid,'1')");

            $this->db->bind('NoPelunasan', $NoPelunasan);
            $this->db->bind('TglTransaksi', $TglTransaksi);
            $this->db->bind('NILAI_PAY', $NILAI_PAY);
            $this->db->bind('NILAI_PAY1', $NILAI_PAY);
            $this->db->bind('NILAI_PAY2', $NILAI_PAY);
            $this->db->bind('userid', $userid);
            $this->db->execute();


            if ($jaminan == "Asuransi") {
                $this->db->query("INSERT INTO Keuangan.DBO.TA_JURNAL_DTL (FS_KD_JURNAL,FS_KET_REFF,FN_KREDIT,FN_DEBET,FS_REK,FS_KD_REFF,FS_KD_REF_OUT,FS_KD_REG)
                select a.FS_KD_TRS,'Pelunasan : '+a.KET,a.NILAI_PAY,'0',:Rekeningx as FS_REK,a.KD_PIUTANG, a.KD_TRS_ORDER,
                  :NoPelunasan
                  from Keuangan.dbo.TA_PTG_LUNAS_DTL a
                  INNER JOIN Keuangan.DBO.TA_PTG_LUNAS_HDR b on a.FS_KD_TRS = b.FS_KD_TRS
                  WHERE A.FS_KD_TRS=:NoPelunasan1 and NILAI_PAY<>'0'");
                $this->db->bind('Rekeningx', $Rekeningx);
                $this->db->bind('NoPelunasan', $NoPelunasan);
                $this->db->bind('NoPelunasan1', $NoPelunasan);
                $this->db->execute();
            } else {
                $this->db->query("INSERT INTO Keuangan.DBO.TA_JURNAL_DTL (FS_KD_JURNAL,FS_KET_REFF,FN_KREDIT,FN_DEBET,FS_REK,FS_KD_REFF,FS_KD_REF_OUT,FS_KD_REG)
                  select a.FS_KD_TRS,'Pelunasan : '+a.KET,a.NILAI_PAY,'0',:Rekeningx as FS_REK,a.KD_PIUTANG, a.KD_TRS_ORDER,
                  :NoPelunasan
                  from Keuangan.dbo.TA_PTG_LUNAS_DTL a
                  INNER JOIN Keuangan.DBO.TA_PTG_LUNAS_HDR b on a.FS_KD_TRS = b.FS_KD_TRS
                  WHERE A.FS_KD_TRS=:NoPelunasan1 and NILAI_PAY<>'0'");
                $this->db->bind('Rekeningx', $Rekeningx);
                $this->db->bind('NoPelunasan', $NoPelunasan);
                $this->db->bind('NoPelunasan1', $NoPelunasan);
                $this->db->execute();
            }

            // Jurnal detil Kas
            $this->db->query("INSERT INTO Keuangan.DBO.TA_JURNAL_DTL ( 
                FS_KD_JURNAL,FS_KET_REFF,FN_KREDIT,FN_DEBET,FS_REK,FS_KD_REFF,FS_KD_REF_OUT,FS_KD_REG)
                VALUES
                (:NoPelunasan,'Pelunasan Piutang : $NoPelunasan' ,'0',:totalPlKas,
                :RekeningPelunasan,'','',:NoPelunasan2) ");
            $this->db->bind('NoPelunasan', $NoPelunasan);
            // $this->db->bind('NoPelunasan1', $NoPelunasan);
            $this->db->bind('totalPlKas', $totalPlKas);
            $this->db->bind('RekeningPelunasan', $RekeningPelunasan);
            $this->db->bind('NoPelunasan2', $NoPelunasan);
            $this->db->execute();


            //   $tsql = "SELECT * FROM Keuangan.DBO.TA_PTG_LUNAS_DTL
            //               where FB_BATAL='0' and FS_KD_TRS='$NoTranSaksiPelunasan' 
            //               and NILAI_PAY<>'0'";
            //         $execute = sqlsrv_query( $conn2, $tsql); 
            $this->db->query("SELECT KD_PIUTANG,NILAI_PAY FROM Keuangan.DBO.TA_PTG_LUNAS_DTL
                   where FB_BATAL='0' and FS_KD_TRS=:NoPelunasan and NILAI_PAY<>'0'");
            $this->db->bind('NoPelunasan', $NoPelunasan);
            // $this->db->bind('kodeawal', $kodeawal);
            $datanya =  $this->db->single();
            $NILAI_PAY = $datanya['NILAI_PAY'];
            $KD_PIUTANG = $datanya['KD_PIUTANG'];
            $this->db->execute();


            $this->db->query("UPDATE Keuangan.dbo.TA_ORDER_PIUTANG set 
                                   Fs_Petugas_Penerima=:namapenerimaberkas,Fd_Tgl_Diterima=:tglberkas,Fb_Status_All='2' 
                                     ,Fb_Status_Diiterima='1' 
                                   where FS_KD_TRS=:NoOrder ");
            $this->db->bind('namapenerimaberkas', $namapenerimaberkas);
            $this->db->bind('tglberkas', $tglberkas);
            $this->db->bind('NoOrder', $NoOrder);
            $this->db->execute();


            $this->db->query("UPDATE Keuangan.dbo.PIUTANG_PASIEN 
        set FN_SISA=FN_SISA-:NILAI_PAY 
          where KD_PIUTANG=:KD_PIUTANG ");
            $this->db->bind('NILAI_PAY', $NILAI_PAY);
            $this->db->bind('KD_PIUTANG', $KD_PIUTANG);
            $this->db->execute();


            // Jurnal detil Diskon Pelunasan
            if ($PL_BiayaLain <> "0" || $PL_BiayaLain <> "") {
                $this->db->query("INSERT INTO Keuangan.DBO.TA_JURNAL_DTL (
                FS_KD_JURNAL,FS_KET_REFF,FN_KREDIT,FN_DEBET,FS_REK,FS_KD_REFF,FS_KD_REF_OUT,FS_KD_REG)
                VALUES
                (:NoPelunasan,'Potonga Pelunasan Biaya Transfer : $NoPelunasan ','0',:PL_BiayaLain,
                :rekeningDiscPL,'','',:NoPelunasan2) ");
                $this->db->bind('NoPelunasan', $NoPelunasan);
                // $this->db->bind('NoPelunasan1', $NoPelunasan);
                $this->db->bind('PL_BiayaLain', $PL_BiayaLain);
                $this->db->bind('rekeningDiscPL', $rekeningDiscPL);
                $this->db->bind('NoPelunasan2', $NoPelunasan);
                $this->db->execute();
            }
            // Jurnal detil Materai Pelunasan
            if ($PL_Materai <> "0" || $PL_Materai <> "") {
                $this->db->query("INSERT INTO Keuangan.DBO.TA_JURNAL_DTL (
                  FS_KD_JURNAL,FS_KET_REFF,FN_KREDIT,FN_DEBET,FS_REK,FS_KD_REFF,FS_KD_REF_OUT,FS_KD_REG)
                  VALUES
                  (:NoPelunasan,'Potonga Pelunasan Materai: $NoPelunasan' ,'0',:PL_Materai,
                  :rekeningMateraiPL,'','',:NoPelunasan2) ");
                $this->db->bind('NoPelunasan', $NoPelunasan);
                // $this->db->bind('NoPelunasan1', $NoPelunasan);
                $this->db->bind('PL_Materai', $PL_Materai);
                $this->db->bind('rekeningMateraiPL', $rekeningMateraiPL);
                $this->db->bind('NoPelunasan2', $NoPelunasan);
                $this->db->execute();
            }

            // Jurnal detil Biaya Transfer Pelunasan
            if ($PL_Discount <> "0" || $PL_Discount <> "") {
                $this->db->query("INSERT INTO Keuangan.DBO.TA_JURNAL_DTL ( 
                  FS_KD_JURNAL,FS_KET_REFF,FN_KREDIT,FN_DEBET,FS_REK,FS_KD_REFF,FS_KD_REF_OUT,FS_KD_REG)
                  VALUES
                  (:NoPelunasan,'Potonga Pelunasan Diskon: $NoPelunasan ' ,'0',:PL_Discount,
                  :rekeningBiayaTrfPL,'','',:NoPelunasan2 ) ");
                $this->db->bind('NoPelunasan', $NoPelunasan);
                // $this->db->bind('NoPelunasan1', $NoPelunasan);
                $this->db->bind('PL_Discount', $PL_Discount);
                $this->db->bind('rekeningBiayaTrfPL', $rekeningBiayaTrfPL);
                $this->db->bind('NoPelunasan2', $NoPelunasan);
                $this->db->execute();
            }

            $this->db->query("UPDATE Keuangan.dbo.TA_PTG_LUNAS_HDR
                            SET KD_TRS_ORDER=:NoOrder,
                            FN_LUNAS=:NILAI_PAY, FS_KD_JAMINAN=:kdrekanan, FB_SELESAI='1',
                            GROUP_JAMINAN=:jaminan,JENIS_REG=:jenispasien,FS_REKENING=:RekeningPelunasan,
                            FD_TGL_TRS=:TglTransaksi,FS_REKENING_JAMINAN=:Rekeningx,
                            FN_MATERAI=:PL_Materai,FN_BIAYA_LAIN=:PL_BiayaLain,FN_DISKON_LAIN=:PL_Discount,
                            FN_TOTAL_LUNAS=:PL_Grandtotal
                            WHERE FS_KD_TRS=:NoPelunasan ");
            $this->db->bind('NoOrder', $NoOrder);
            $this->db->bind('NILAI_PAY', $NILAI_PAY);
            $this->db->bind('kdrekanan', $kdrekanan);
            $this->db->bind('jaminan', $jaminan);
            $this->db->bind('jenispasien', $jenispasien);
            $this->db->bind('RekeningPelunasan', $RekeningPelunasan);
            $this->db->bind('TglTransaksi', $TglTransaksi);
            $this->db->bind('Rekeningx', $Rekeningx);
            $this->db->bind('PL_Materai', $PL_Materai);
            $this->db->bind('PL_BiayaLain', $PL_BiayaLain);
            $this->db->bind('PL_Discount', $PL_Discount);
            $this->db->bind('PL_Grandtotal', $PL_Grandtotal);
            $this->db->bind('NoPelunasan', $NoPelunasan);
            $this->db->execute();


            $this->db->query("DELETE Keuangan.dbo.TA_PTG_LUNAS_DTL where FS_KD_TRS=:NoPelunasan and NILAI_PAY='0'");
            $this->db->bind('NoPelunasan', $NoPelunasan);

            $this->db->execute();
            $this->db->commit();

            $callback = array(
                'status' => 'success',
                'message' => 'Berhasil disimpan !'
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
    public function getRekening($data)
    {
        try {

            // $JenisPenjamin = $data['JenisPenjamin'];
            // var_dump($JenisPenjamin);
            // exit;

            $this->db->query("SELECT FS_KD_REKENING, FS_NM_REKENING
                FROM Keuangan.dbo.TM_REKENING 
                WHERE GROUP_REK='4' AND AKTIF='1' and FS_KD_REKENING_GROUP in('KAS','BANK (IDR)','BANK (US)')");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {
                $pasing['FS_KD_REKENING'] = $row['FS_KD_REKENING'];
                $pasing['FS_NM_REKENING'] = $row['FS_NM_REKENING'];
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
    public function LoadDataTrsPL($data)
    {
        try {
            $PeriodePencarian = $data['PeriodePencarian'];

            $this->db->query("SELECT a.ID, FS_KD_TRS,replace(CONVERT(VARCHAR(11), FD_TGL_TRS, 111), '/','-') AS FD_TGL_TRS,
                FN_LUNAS,ISNULL(KD_TRS_ORDER,'') AS KD_TRS_ORDER,B.[First Name] as NamaPetugas,
                c.NamaPerusahaan,A.FB_SELESAI, A.GROUP_JAMINAN,A.JENIS_REG,
                CASE WHEN FB_SELESAI='0' THEN 'OPEN' WHEN FB_SELESAI='1' THEN 'FINISH' END AS STATUSTRS
                FROM Keuangan.DBO.TA_PTG_LUNAS_HDR a
                INNER JOIN MasterdataSQL.DBO.Employees B 
                ON A.FS_KD_PETUGAS collate Latin1_General_CI_AS= B.NoPIN collate Latin1_General_CI_AS
                LEFT JOIN MasterdataSQL.DBO.MstrPerusahaanJPK C 
                ON A.FS_KD_JAMINAN = C.ID
                where  a.GROUP_JAMINAN='Perusahaan' and FS_KD_PETUGAS_VOID is null and 
              FD_TGL_VOID is null
                UNION ALL
                 SELECT a.ID, FS_KD_TRS,replace(CONVERT(VARCHAR(11), FD_TGL_TRS, 111), '/','-') AS FD_TGL_TRS,
                FN_LUNAS,ISNULL(KD_TRS_ORDER,'') AS KD_TRS_ORDER,B.[First Name] as NamaPetugas,
                c.NamaPerusahaan,A.FB_SELESAI, A.GROUP_JAMINAN,A.JENIS_REG,
                CASE WHEN FB_SELESAI='0' THEN 'OPEN' WHEN FB_SELESAI='1' THEN 'FINISH' END AS STATUSTRS
                FROM Keuangan.DBO.TA_PTG_LUNAS_HDR a
                INNER JOIN MasterdataSQL.DBO.Employees B 
                ON A.FS_KD_PETUGAS collate Latin1_General_CI_AS= B.NoPIN collate Latin1_General_CI_AS
                LEFT JOIN MasterdataSQL.DBO.MstrPerusahaanAsuransi C 
                ON A.FS_KD_JAMINAN = C.ID
                where  a.GROUP_JAMINAN<>'Perusahaan' and FS_KD_PETUGAS_VOID is null and 
              FD_TGL_VOID is null");
            // $this->db->bind('PeriodePencarian', $PeriodePencarian);

            $data =  $this->db->resultSet();

            $rows = array();
            foreach ($data as $row) {
                $pasing['ID'] = $row['ID'];
                $pasing['FS_KD_TRS'] = $row['FS_KD_TRS'];
                $pasing['FD_TGL_TRS'] = $row['FD_TGL_TRS'];
                $pasing['FN_LUNAS'] = $row['FN_LUNAS'];
                $pasing['KD_TRS_ORDER'] = $row['KD_TRS_ORDER'];
                $pasing['NamaPetugas'] = $row['NamaPetugas'];
                $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                $pasing['FB_SELESAI'] = $row['FB_SELESAI'];
                $pasing['GROUP_JAMINAN'] = $row['GROUP_JAMINAN'];
                $pasing['JENIS_REG'] = $row['JENIS_REG'];
                $pasing['STATUSTRS'] = $row['STATUSTRS'];


                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function LoadDataTrsOrder($data)
    {
        try {
            $PeriodePencarian = $data['PeriodePencarian'];

            $this->db->query("SELECT a.ID,a.FS_KD_TRS,replace(CONVERT(VARCHAR(11), a.FD_TGL_TRS, 111), '/','-') as FD_TGL_TRS,  
            b.NamaPerusahaan,a.FS_KET,a.FN_TOTAL_TAGIH from Keuangan.dbo.TA_ORDER_PIUTANG a
        inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi b on a.FS_KD_CUSTOMER = b.ID
            where replace(CONVERT(VARCHAR(11), FD_TGL_VOID, 111), '/','-')='3000-01-01'
        and a.FS_JENIS_CUSTOMER='Asuransi'
        UNION ALL
        SELECT a.ID,a.FS_KD_TRS,replace(CONVERT(VARCHAR(11), a.FD_TGL_TRS, 111), '/','-') as FD_TGL_TRS,  
            b.NamaPerusahaan,a.FS_KET,a.FN_TOTAL_TAGIH from Keuangan.dbo.TA_ORDER_PIUTANG a
        inner join MasterdataSQL.dbo.MstrPerusahaanJPK b on a.FS_KD_CUSTOMER = b.ID
            where replace(CONVERT(VARCHAR(11), FD_TGL_VOID, 111), '/','-')='3000-01-01'
        and a.FS_JENIS_CUSTOMER='Perusahaan'");
            // $this->db->bind('PeriodePencarian', $PeriodePencarian);

            $data =  $this->db->resultSet();

            $rows = array();
            foreach ($data as $row) {
                $pasing['ID'] = $row['ID'];
                $pasing['KD_TRS_ORDER'] = $row['FS_KD_TRS'];
                $pasing['TGL_ORDER'] = $row['FD_TGL_TRS'];
                $pasing['Company'] = $row['NamaPerusahaan'];
                $pasing['FS_KET'] = $row['FS_KET'];
                $pasing['FN_TOTAL_TAGIH'] = $row['FN_TOTAL_TAGIH'];



                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getShowDataTabelidPL($data)
    {
        try {
            $NoTrs = $data['NoTrs'];

            $this->db->query("SELECT a.ID, a.FS_KD_TRS,replace(CONVERT(VARCHAR(11), a.FD_TGL_TRS, 111), '/','-') AS FD_TGL_TRS,
            FN_LUNAS,ISNULL(KD_TRS_ORDER,'') AS KD_TRS_ORDER,B.[First Name] as FS_KD_PETUGAS,
            c.NamaPerusahaan,A.FB_SELESAI, A.GROUP_JAMINAN,A.JENIS_REG,A.FS_KD_JAMINAN,A.FS_REKENING
            ,CASE WHEN A.FB_SELESAI='1' THEN 'FINISH' ELSE 'OPEN' END AS StatusTransaksi,A.FS_REKENING_JAMINAN
            ,A.FN_MATERAI,A.FN_BIAYA_LAIN,A.FN_DISKON_LAIN,A.FN_TOTAL_LUNAS ,replace(CONVERT(VARCHAR(11), x.Fd_Tgl_Diterima, 111), '/','-') Fd_Tgl_Diterima,x.Fs_Petugas_Penerima
            FROM Keuangan.DBO.TA_PTG_LUNAS_HDR a
            INNER JOIN MasterdataSQL.DBO.Employees B 
            ON A.FS_KD_PETUGAS collate Latin1_General_CI_AS= B.NoPIN collate Latin1_General_CI_AS
            INNER JOIN MasterdataSQL.DBO.MstrPerusahaanJPK C 
            ON A.FS_KD_JAMINAN = C.ID
  
            INNER JOIN Keuangan.dbo.TA_ORDER_PIUTANG x on a.KD_TRS_ORDER=x.FS_KD_TRS and x.FS_KD_PETUGAS_VOID is null
  
            where   a.GROUP_JAMINAN='Perusahaan' and a.ID=:NoTrs
            UNION ALL
             SELECT a.ID, a.FS_KD_TRS,replace(CONVERT(VARCHAR(11), a.FD_TGL_TRS, 111), '/','-') AS FD_TGL_TRS,
            FN_LUNAS,ISNULL(KD_TRS_ORDER,'') AS KD_TRS_ORDER,B.[First Name] as FS_KD_PETUGAS,
            c.NamaPerusahaan,A.FB_SELESAI, A.GROUP_JAMINAN,A.JENIS_REG,A.FS_KD_JAMINAN,A.FS_REKENING
            ,CASE WHEN A.FB_SELESAI='1' THEN 'FINISH' ELSE 'OPEN' END AS StatusTransaksi,A.FS_REKENING_JAMINAN
            ,A.FN_MATERAI,A.FN_BIAYA_LAIN,A.FN_DISKON_LAIN,A.FN_TOTAL_LUNAS , replace(CONVERT(VARCHAR(11), x.Fd_Tgl_Diterima, 111), '/','-') Fd_Tgl_Diterima,x.Fs_Petugas_Penerima
            FROM Keuangan.DBO.TA_PTG_LUNAS_HDR a
            INNER JOIN MasterdataSQL.DBO.Employees B 
            ON A.FS_KD_PETUGAS collate Latin1_General_CI_AS= B.NoPIN collate Latin1_General_CI_AS
            INNER JOIN MasterdataSQL.DBO.MstrPerusahaanAsuransi C 
            ON A.FS_KD_JAMINAN = C.ID
  
            INNER JOIN Keuangan.dbo.TA_ORDER_PIUTANG x on a.KD_TRS_ORDER=x.FS_KD_TRS and x.FS_KD_PETUGAS_VOID is null
  
            where a.GROUP_JAMINAN<>'Perusahaan' and a.ID=:NoTrs1");
            $this->db->bind('NoTrs', $NoTrs);
            $this->db->bind('NoTrs1', $NoTrs);
            $data =  $this->db->single();

            $callback = array(
                'status' => 'success', // Set array status dengan success
                'FS_KD_TRS' => $data['FS_KD_TRS'], // Set array status dengan success
                'FD_TGL_TRS' => $data['FD_TGL_TRS'], // Set array status dengan success
                'FS_KD_PETUGAS' => $data['FS_KD_PETUGAS'], // Set array status dengan success
                'FN_LUNAS' => $data['FN_LUNAS'], // Set array status dengan successDate_of_birth
                'KD_TRS_ORDER' => $data['KD_TRS_ORDER'], // Set array status dengan success
                'NamaPerusahaan' => $data['NamaPerusahaan'],
                'FB_SELESAI' => $data['FB_SELESAI'], // Set array status dengan success
                'GROUP_JAMINAN' => $data['GROUP_JAMINAN'], // Set array status dengan successDate_of_birth 
                'JENIS_REG' => $data['JENIS_REG'], // Set array status dengan successDate_of_birth 
                'FS_KD_JAMINAN'  => $data['FS_KD_JAMINAN'], // Set array status dengan successDate_of_birth 
                'FS_REKENING'  => $data['FS_REKENING'], // Set array status dengan successDate_of_birth  
                'StatusTransaksi'  => $data['StatusTransaksi'],
                'FS_REKENING_JAMINAN'  => $data['FS_REKENING_JAMINAN'],
                'FN_MATERAI'  => $data['FN_MATERAI'],
                'FN_BIAYA_LAIN'  => $data['FN_BIAYA_LAIN'],
                'FN_DISKON_LAIN'  => $data['FN_DISKON_LAIN'],
                'FN_TOTAL_LUNAS'  => $data['FN_TOTAL_LUNAS'],

                'Fd_Tgl_Diterima'  => $data['Fd_Tgl_Diterima'],
                'Fs_Petugas_Penerima'  => $data['Fs_Petugas_Penerima'],

            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getShowDataTabelidOrderPL($data)
    {
        try {
            $NoTrs = $data['NoTrs'];

            $this->db->query("SELECT a.ID, a.FS_KD_TRS,replace(CONVERT(VARCHAR(11), a.FD_TGL_TRS, 111), '/','-') AS FD_TGL_TRS,
            FN_LUNAS,ISNULL(KD_TRS_ORDER,'') AS KD_TRS_ORDER,B.[First Name] as FS_KD_PETUGAS,
            c.NamaPerusahaan,A.FB_SELESAI, A.GROUP_JAMINAN,A.JENIS_REG,A.FS_KD_JAMINAN,A.FS_REKENING
            ,CASE WHEN A.FB_SELESAI='1' THEN 'FINISH' ELSE 'OPEN' END AS StatusTransaksi,A.FS_REKENING_JAMINAN
            ,A.FN_MATERAI,A.FN_BIAYA_LAIN,A.FN_DISKON_LAIN,A.FN_TOTAL_LUNAS ,replace(CONVERT(VARCHAR(11), x.Fd_Tgl_Diterima, 111), '/','-') Fd_Tgl_Diterima,x.Fs_Petugas_Penerima
            FROM Keuangan.DBO.TA_PTG_LUNAS_HDR a
            INNER JOIN MasterdataSQL.DBO.Employees B 
            ON A.FS_KD_PETUGAS collate Latin1_General_CI_AS= B.NoPIN collate Latin1_General_CI_AS
            INNER JOIN MasterdataSQL.DBO.MstrPerusahaanJPK C 
            ON A.FS_KD_JAMINAN = C.ID
  
            INNER JOIN Keuangan.dbo.TA_ORDER_PIUTANG x on a.KD_TRS_ORDER=x.FS_KD_TRS and x.FS_KD_PETUGAS_VOID is null
  
            where   a.GROUP_JAMINAN='Perusahaan' and a.ID=:NoTrs
            UNION ALL
             SELECT a.ID, a.FS_KD_TRS,replace(CONVERT(VARCHAR(11), a.FD_TGL_TRS, 111), '/','-') AS FD_TGL_TRS,
            FN_LUNAS,ISNULL(KD_TRS_ORDER,'') AS KD_TRS_ORDER,B.[First Name] as FS_KD_PETUGAS,
            c.NamaPerusahaan,A.FB_SELESAI, A.GROUP_JAMINAN,A.JENIS_REG,A.FS_KD_JAMINAN,A.FS_REKENING
            ,CASE WHEN A.FB_SELESAI='1' THEN 'FINISH' ELSE 'OPEN' END AS StatusTransaksi,A.FS_REKENING_JAMINAN
            ,A.FN_MATERAI,A.FN_BIAYA_LAIN,A.FN_DISKON_LAIN,A.FN_TOTAL_LUNAS , replace(CONVERT(VARCHAR(11), x.Fd_Tgl_Diterima, 111), '/','-') Fd_Tgl_Diterima,x.Fs_Petugas_Penerima
            FROM Keuangan.DBO.TA_PTG_LUNAS_HDR a
            INNER JOIN MasterdataSQL.DBO.Employees B 
            ON A.FS_KD_PETUGAS collate Latin1_General_CI_AS= B.NoPIN collate Latin1_General_CI_AS
            INNER JOIN MasterdataSQL.DBO.MstrPerusahaanAsuransi C 
            ON A.FS_KD_JAMINAN = C.ID
  
            INNER JOIN Keuangan.dbo.TA_ORDER_PIUTANG x on a.KD_TRS_ORDER=x.FS_KD_TRS and x.FS_KD_PETUGAS_VOID is null
  
            where a.GROUP_JAMINAN<>'Perusahaan' and a.ID=:NoTrs1");
            $this->db->bind('NoTrs', $NoTrs);
            $this->db->bind('NoTrs1', $NoTrs);
            $data =  $this->db->single();

            $callback = array(
                'status' => 'success', // Set array status dengan success
                'FS_KD_TRS' => $data['FS_KD_TRS'], // Set array status dengan success
                'FD_TGL_TRS' => $data['FD_TGL_TRS'], // Set array status dengan success
                'FS_KD_PETUGAS' => $data['FS_KD_PETUGAS'], // Set array status dengan success
                'FN_LUNAS' => $data['FN_LUNAS'], // Set array status dengan successDate_of_birth
                'KD_TRS_ORDER' => $data['KD_TRS_ORDER'], // Set array status dengan success
                'NamaPerusahaan' => $data['NamaPerusahaan'],
                'FB_SELESAI' => $data['FB_SELESAI'], // Set array status dengan success
                'GROUP_JAMINAN' => $data['GROUP_JAMINAN'], // Set array status dengan successDate_of_birth 
                'JENIS_REG' => $data['JENIS_REG'], // Set array status dengan successDate_of_birth 
                'FS_KD_JAMINAN'  => $data['FS_KD_JAMINAN'], // Set array status dengan successDate_of_birth 
                'FS_REKENING'  => $data['FS_REKENING'], // Set array status dengan successDate_of_birth  
                'StatusTransaksi'  => $data['StatusTransaksi'],
                'FS_REKENING_JAMINAN'  => $data['FS_REKENING_JAMINAN'],
                'FN_MATERAI'  => $data['FN_MATERAI'],
                'FN_BIAYA_LAIN'  => $data['FN_BIAYA_LAIN'],
                'FN_DISKON_LAIN'  => $data['FN_DISKON_LAIN'],
                'FN_TOTAL_LUNAS'  => $data['FN_TOTAL_LUNAS'],

                'Fd_Tgl_Diterima'  => $data['Fd_Tgl_Diterima'],
                'Fs_Petugas_Penerima'  => $data['Fs_Petugas_Penerima'],

            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function loadpelunasandetil($data)
    {
        try {
            $NoPelunasan = $data['NoPelunasan'];

            $this->db->query("SELECT *from Keuangan.dbo.TA_PTG_LUNAS_DTL WHERE FS_KD_TRS=:NoPelunasan AND FB_BATAL='0'");
            $this->db->bind('NoPelunasan', $NoPelunasan);
            // $this->db->bind('NoTrs1', $NoTrs);

            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $row) {
                $pasing['ID'] = $row['ID'];
                $pasing['KD_TRS_ORDER'] = $row['KD_TRS_ORDER'];
                $pasing['KD_PIUTANG'] = $row['KD_PIUTANG'];
                $pasing['KET'] = $row['KET'];
                $pasing['SISA_PIUTANG'] = $row['SISA_PIUTANG'];
                $pasing['NILAI_PAY'] = $row['NILAI_PAY'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getPelunasanPiutangDetailbyID($data)
    {
        try {
            $NoTrs = $data['NoTrs'];
            $this->db->query("SELECT FS_KD_TRS,KET,SISA_PIUTANG,NILAI_PAY from Keuangan.dbo.TA_PTG_LUNAS_DTL where id=:NoTrs");
            $this->db->bind('NoTrs', $NoTrs);
            $data =  $this->db->single();

            $callback = array(
                'status' => 'success', // Set array status dengan success
                'KD_TRS_PAY' => $data['FS_KD_TRS'], // Set array status dengan success    
                'KET' => $data['KET'], // Set array status dengan success    
                'SISA_HUTANG' => $data['SISA_PIUTANG'], // Set array status dengan success    
                'NILAI_PAY' => $data['NILAI_PAY'], // Set array status dengan success     

            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function VoidPL($data)
    {
        try {
            $this->db->transaksi();
            $datenowcreate = Utils::seCurrentDateTime();
            $noregbatal = $data['noregbatal']; // ok
            $alasanbatal = $data['alasanbatal']; // ok
            // TRIGER SEBELUM SIMPAN DATA
            // 1. TRIGER PASIEN JIKA JENIS BELUM DIISI  
            if ($noregbatal == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Id   Invalid !',
                );
                echo json_encode($callback);
                exit;
            }

            $this->db->query("SELECT KD_PIUTANG, NILAI_PAY FROM Keuangan.DBO.TA_PTG_LUNAS_DTL
                where FB_BATAL='0' and FS_KD_TRS=:noregbatal 
                and NILAI_PAY<>'0'");
            $this->db->bind('noregbatal', $noregbatal);
            $datax =  $this->db->single();
            $KD_PIUTANG = $datax['KD_PIUTANG'];
            $NILAI_PAY = $datax['NILAI_PAY'];

            $this->db->query("UPDATE Keuangan.dbo.PIUTANG_PASIEN 
           set FN_SISA=FN_SISA+:NILAI_PAY
             where KD_PIUTANG=:KD_PIUTANG");
            $this->db->bind('NILAI_PAY', $NILAI_PAY);
            $this->db->bind('KD_PIUTANG', $KD_PIUTANG);
            $this->db->execute();
            //    if ($data) {
            //        $callback = array(
            //            'status' => 'warning',
            //            'errorname' => 'Registrasi Sudah ada Billing Selain Administrasi, Batalkan Dahulu Semua Billing !',
            //        );
            //        return $callback;
            //        exit;
            //    }
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;


            $this->db->query("UPDATE Keuangan.dbo.TA_JURNAL_HDR SET FS_KD_PETUGAS_VOID=:userid,
            FD_TGL_VOID=:datenowcreate, FS_ALASAN=:alasanbatal
            where FS_KD_JURNAL=:noregbatal");
            $this->db->bind('userid', $userid);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('alasanbatal', $alasanbatal);
            $this->db->bind('noregbatal', $noregbatal);
            $this->db->execute();

            $this->db->query("UPDATE Keuangan.dbo.TA_JURNAL_DTL SET FB_VOID='1' 
            WHERE FS_KD_JURNAL=:noregbatal");
            $this->db->bind('noregbatal', $noregbatal);
            $this->db->execute();

            $this->db->query("UPDATE Keuangan.DBO.TA_PTG_LUNAS_DTL SET FB_BATAL='1'
             WHERE FS_KD_TRS=:noregbatal");
            $this->db->bind('noregbatal', $noregbatal);
            $this->db->execute();

            $this->db->query("UPDATE Keuangan.DBO.TA_PTG_LUNAS_HDR SET FS_KD_PETUGAS_VOID=:userid,
             FD_TGL_VOID=:datenowcreate
             WHERE FS_KD_TRS=:noregbatal");
            $this->db->bind('userid', $userid);
            $this->db->bind('datenowcreate', $datenowcreate);
            // $this->db->bind('alasanbatal', $alasanbatal);
            $this->db->bind('noregbatal', $noregbatal);
            $this->db->execute();

            $this->db->commit();

            $callback = array(
                'status' => 'success',
                'message' => 'Registrasi berhasil Dihapus !'
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
    //pelunasan piutang//

    public function caridataPasienTagihlAll($data)
    {
        try {
            $myKey = $data['myKey'];
            $JenisRegistrasi = $data['JenisRegistrasi'];
            $jenisjaminan = $data['JenisPenjamin'];
            $TglPeriode1 = $data['TglPeriode1'];
            $TglPeriode2 =  $data['TglPeriode2'];
            $kodejaminan = $data['kodejaminan'];

            // var_dump($data, $TglPeriode1, $TglPeriode2, $JenisRegistrasi);
            // exit;
            if ($JenisRegistrasi == "RJ") {
                if ($jenisjaminan == "Asuransi") {
                    $query = "SELECT  a.KD_PIUTANG,a.FB_TAGIH, replace(CONVERT(VARCHAR(11), a.FD_TGL_PIUTANG, 111), '/','-') as 
                FD_TGL_PIUTANG, b.NoRegistrasi as NoRegistrasi,d.PatientName, '' as NamaUnit,a.Fn_piutang,isnull(a.FS_NO_REFF_BRIDGING,'') as FS_NO_REFF_BRIDGING
                    from Keuangan.dbo.PIUTANG_PASIEN a
                    inner join PerawatanSQL.dbo.Visit b on a.NO_TRANSAKSI collate Latin1_General_CI_AS = B.NoRegistrasi  collate Latin1_General_CI_AS
                    inner join MasterdataSQL.dbo.MstrUnitPerwatan c on c.ID = b.Unit
                    inner join MasterdataSQL.dbo.Admision d on d.NoMR = b.NoMR
                    inner join PerawatanSQL.dbo.PaymentDetails e on e.PaymentID = a.PAYMENT_NO
                    WHERE  FS_KD_TAGIH in (SELECT FS_KD_TRS FROM Keuangan.DBO.TA_ORDER_PIUTANG WHERE ID=:myKey1 )    and a.FB_TAGIH='1'
                    and replace(CONVERT(VARCHAR(11), A.fd_tgL_piutang, 111), '/','-') BETWEEN :periode1 AND :periodeAkhir1
                    AND A.kode_jaminan=:kodejaminan1 and e.TipePembayaran='Piutang Asuransi'   
                    and a.FB_BATAL='0'
                    UNION ALL
                    SELECT  a.KD_PIUTANG collate Latin1_General_CI_AS ,a.FB_TAGIH, 
                    replace(CONVERT(VARCHAR(11), a.FD_TGL_PIUTANG, 111), '/','-') as 
                    FD_TGL_PIUTANG  , b.NoRegistrasi collate Latin1_General_CI_AS  as NoRegistrasi ,
                    d.PatientName collate Latin1_General_CI_AS  ,
                    '' as NamaUnit   ,a.Fn_piutang,isnull(a.FS_NO_REFF_BRIDGING,'') as FS_NO_REFF_BRIDGING
                    from Keuangan.dbo.PIUTANG_PASIEN a
                    inner join PerawatanSQL.dbo.Visit b on a.NO_TRANSAKSI collate Latin1_General_CI_AS  = B.NoRegistrasi  collate Latin1_General_CI_AS 
                    inner join MasterdataSQL.dbo.MstrUnitPerwatan c on c.ID = b.Unit
                    inner join MasterdataSQL.dbo.Admision d on d.NoMR collate Latin1_General_CI_AS  = b.NoMR collate Latin1_General_CI_AS 
                    inner join PerawatanSQL.dbo.PaymentDetails e on e.PaymentID = a.PAYMENT_NO
                    where  a.FB_TAGIH='0' 
                    and replace(CONVERT(VARCHAR(11), A.fd_tgL_piutang, 111), '/','-') BETWEEN :periode2 AND :periodeAkhir2
                    AND A.kode_jaminan=:kodejaminan2 and e.TipePembayaran='Piutang Asuransi'  
                    and a.FB_BATAL='0'
                    UNION ALL
                     SELECT a.KD_PIUTANG collate Latin1_General_CI_AS ,a.FB_TAGIH, replace(CONVERT(VARCHAR(11), a.FD_TGL_PIUTANG, 111), '/','-') as 
                     FD_TGL_PIUTANG, a.NO_TRANSAKSI collate Latin1_General_CI_AS  as NoRegistrasi, 
                 A.FS_kET  collate Latin1_General_CI_AS  as PatientName,'' as NamaUnit,a.Fn_piutang,'' as FS_NO_REFF_BRIDGING
                     FROM Keuangan.dbo.PIUTANG_PASIEN a 
                     INNER JOIN Keuangan.dbo.TA_JURNAL_DTL B 
                     on a.NO_TRANSAKSI collate Latin1_General_CI_AS   = b.FS_KD_JURNAL   collate Latin1_General_CI_AS
                     where a.FB_BATAL='0'   AND  a.FB_TAGIH='0' 
                     and a.TipePiutang='RAJAL' and a.TipeJaminan='Asuransi'  
                     and  replace(CONVERT(VARCHAR(11), A.fd_tgL_piutang, 111), '/','-') BETWEEN :periode3 AND :periodeAkhir3 
                     AND A.kode_jaminan=:kodejaminan3  and a.FB_BATAL='0'
                     UNION ALL
                     SELECT  a.KD_PIUTANG,a.FB_TAGIH, replace(CONVERT(VARCHAR(11), a.FD_TGL_PIUTANG, 111), '/','-') as 
                FD_TGL_PIUTANG, b.NoRegRI as NoRegistrasi,d.PatientName, '' as NamaUnit,a.Fn_piutang,isnull(a.FS_NO_REFF_BRIDGING,'') as FS_NO_REFF_BRIDGING
                    from Keuangan.dbo.PIUTANG_PASIEN a
                    inner join PerawatanSQL.dbo.Visit b on a.NO_TRANSAKSI collate Latin1_General_CI_AS = B.NoRegistrasi  collate Latin1_General_CI_AS
                    inner join MasterdataSQL.dbo.MstrUnitPerwatan c on c.ID = b.Unit
                    inner join MasterdataSQL.dbo.Admision_walkin d on d.NoMR = b.NoMR
                    inner join PerawatanSQL.dbo.PaymentDetails e on e.PaymentID = a.PAYMENT_NO
                    WHERE  FS_KD_TAGIH in (SELECT FS_KD_TRS FROM Keuangan.DBO.TA_ORDER_PIUTANG WHERE ID=:myKey2 )  and a.FB_TAGIH='1'
                    and replace(CONVERT(VARCHAR(11), A.fd_tgL_piutang, 111), '/','-') BETWEEN :periode4 AND :periodeAkhir4
                    AND A.kode_jaminan=:kodejaminan4 and e.TipePembayaran='Piutang Asuransi'  
                    and a.FB_BATAL='0'
                    UNION ALL
                    SELECT  a.KD_PIUTANG collate Latin1_General_CI_AS ,a.FB_TAGIH, 
                      replace(CONVERT(VARCHAR(11), a.FD_TGL_PIUTANG, 111), '/','-') as 
                    FD_TGL_PIUTANG  , b.NoRegistrasi collate Latin1_General_CI_AS  as NoRegistrasi ,
                    d.PatientName collate Latin1_General_CI_AS  ,
                    '' as NamaUnit   ,a.Fn_piutang,isnull(a.FS_NO_REFF_BRIDGING,'') as FS_NO_REFF_BRIDGING
                    from Keuangan.dbo.PIUTANG_PASIEN a
                    inner join PerawatanSQL.dbo.Visit b on a.NO_TRANSAKSI collate Latin1_General_CI_AS  = B.NoRegistrasi  collate Latin1_General_CI_AS 
                    inner join MasterdataSQL.dbo.MstrUnitPerwatan c on c.ID = b.Unit
                    inner join MasterdataSQL.dbo.Admision_walkin d on d.NoMR collate Latin1_General_CI_AS  = b.NoMR collate Latin1_General_CI_AS 
                    inner join PerawatanSQL.dbo.PaymentDetails e on e.PaymentID = a.PAYMENT_NO
                    where  a.FB_TAGIH='0' 
                    and replace(CONVERT(VARCHAR(11), A.fd_tgL_piutang, 111), '/','-') BETWEEN :periode5 AND :periodeAkhir5
                    AND A.kode_jaminan=:kodejaminan5 and e.TipePembayaran='Piutang Asuransi'   
                    and a.FB_BATAL='0'
                    UNION ALL
                     SELECT  a.KD_PIUTANG collate Latin1_General_CI_AS ,a.FB_TAGIH, 
                    replace(CONVERT(VARCHAR(11), a.FD_TGL_PIUTANG, 111), '/','-') as 
                    FD_TGL_PIUTANG  , b.NoRegistrasi collate Latin1_General_CI_AS  as NoRegistrasi ,
                b.[Ship Name]  collate Latin1_General_CI_AS as PatientName ,
                    '' as NamaUnit   ,a.Fn_piutang,isnull(a.FS_NO_REFF_BRIDGING,'') as FS_NO_REFF_BRIDGING
                    from Keuangan.dbo.PIUTANG_PASIEN a
                    inner join [Apotik_V1.1SQL].dbo.Orders b on a.NO_TRANSAKSI collate Latin1_General_CI_AS  = B.NoResep  collate Latin1_General_CI_AS 
                    inner join PerawatanSQL.dbo.PaymentDetails e on e.PaymentID = a.PAYMENT_NO
                    where  a.FB_TAGIH='0' 
                    and replace(CONVERT(VARCHAR(11), A.fd_tgL_piutang, 111), '/','-') BETWEEN :periode6 AND :periodeAkhir6
                    AND A.kode_jaminan=:kodejaminan6 and e.TipePembayaran='Piutang Asuransi'   
                    and a.FB_BATAL='0'
                    UNION ALL
                     SELECT  a.KD_PIUTANG collate Latin1_General_CI_AS ,a.FB_TAGIH, 
                    replace(CONVERT(VARCHAR(11), a.FD_TGL_PIUTANG, 111), '/','-') as 
                    FD_TGL_PIUTANG  , b.NoRegistrasi collate Latin1_General_CI_AS  as NoRegistrasi ,
                b.[Ship Name]  collate Latin1_General_CI_AS as PatientName ,
                    '' as NamaUnit   ,a.Fn_piutang,isnull(a.FS_NO_REFF_BRIDGING,'') as FS_NO_REFF_BRIDGING
                    from Keuangan.dbo.PIUTANG_PASIEN a
                    inner join [Apotik_V1.1SQL].dbo.Orders b on a.NO_TRANSAKSI collate Latin1_General_CI_AS  = B.NoResep  collate Latin1_General_CI_AS 
                    inner join PerawatanSQL.dbo.PaymentDetails e on e.PaymentID = a.PAYMENT_NO
                    where  FS_KD_TAGIH in (SELECT FS_KD_TRS FROM Keuangan.DBO.TA_ORDER_PIUTANG WHERE ID=:myKey3)  and a.FB_TAGIH='1'
                    and replace(CONVERT(VARCHAR(11), A.fd_tgL_piutang, 111), '/','-') BETWEEN :periode7 AND :periodeAkhir7
                    AND A.kode_jaminan=:kodejaminan7 and e.TipePembayaran='Piutang Asuransi'    
                    and a.FB_BATAL='0'";
                    $this->db->query($query);
                    $this->db->bind('periode1', $TglPeriode1);
                    $this->db->bind('periode2', $TglPeriode1);
                    $this->db->bind('periode3', $TglPeriode1);
                    $this->db->bind('periode4', $TglPeriode1);
                    $this->db->bind('periode5', $TglPeriode1);
                    $this->db->bind('periode6', $TglPeriode1);
                    $this->db->bind('periode7', $TglPeriode1);

                    $this->db->bind('periodeAkhir1', $TglPeriode2);
                    $this->db->bind('periodeAkhir2', $TglPeriode2);
                    $this->db->bind('periodeAkhir3', $TglPeriode2);
                    $this->db->bind('periodeAkhir4', $TglPeriode2);
                    $this->db->bind('periodeAkhir5', $TglPeriode2);
                    $this->db->bind('periodeAkhir6', $TglPeriode2);
                    $this->db->bind('periodeAkhir7', $TglPeriode2);


                    $this->db->bind('kodejaminan1', $kodejaminan);
                    $this->db->bind('kodejaminan2', $kodejaminan);
                    $this->db->bind('kodejaminan3', $kodejaminan);
                    $this->db->bind('kodejaminan4', $kodejaminan);
                    $this->db->bind('kodejaminan5', $kodejaminan);
                    $this->db->bind('kodejaminan6', $kodejaminan);
                    $this->db->bind('kodejaminan7', $kodejaminan);

                    $this->db->bind('myKey1', $myKey);
                    $this->db->bind('myKey2',  $myKey);
                    $this->db->bind('myKey3',  $myKey);

                    // $this->db->execute();
                    $data =  $this->db->resultSet();
                    $rows = array();

                    foreach ($data as $row) {
                        $pasing['KD_PIUTANG'] = $row['KD_PIUTANG'];
                        $pasing['FB_TAGIH'] = $row['FB_TAGIH'];
                        $pasing['FD_TGL_PIUTANG'] = date('d/m/Y', strtotime($row['FD_TGL_PIUTANG']));
                        $pasing['NoRegistrasi'] = $row['NoRegistrasi'];
                        $pasing['PatientName'] = $row['PatientName'];
                        $pasing['NamaUnit'] = $row['NamaUnit'];
                        $pasing['Fn_piutang'] = $row['Fn_piutang'];
                        $pasing['FS_NO_REFF_BRIDGING'] = $row['FS_NO_REFF_BRIDGING'];


                        $rows[] = $pasing;
                    }
                } else {
                    $query = "SELECT a.KD_PIUTANG,a.FB_TAGIH, replace(CONVERT(VARCHAR(11), a.FD_TGL_PIUTANG, 111), '/','-') as 
                FD_TGL_PIUTANG, b.NoRegRI as NoRegistrasi,d.PatientName, '' as NamaUnit,a.Fn_piutang,isnull(a.FS_NO_REFF_BRIDGING,'') as FS_NO_REFF_BRIDGING
                    from Keuangan.dbo.PIUTANG_PASIEN a
                    inner join PerawatanSQL.dbo.Visit b on a.NO_TRANSAKSI collate Latin1_General_CI_AS = B.NoRegistrasi  collate Latin1_General_CI_AS
                    inner join MasterdataSQL.dbo.MstrUnitPerwatan c on c.ID = b.Unit
                    inner join MasterdataSQL.dbo.Admision d on d.NoMR = b.NoMR
                    inner join PerawatanSQL.dbo.PaymentDetails e on e.PaymentID = a.PAYMENT_NO
                    WHERE  FS_KD_TAGIH in (SELECT FS_KD_TRS FROM Keuangan.DBO.TA_ORDER_PIUTANG WHERE ID=:myKey1 ) and a.FB_TAGIH='1'
                    and replace(CONVERT(VARCHAR(11), A.fd_tgL_piutang, 111), '/','-') BETWEEN :periode1 AND :periodeAkhir1
                    AND A.kode_jaminan=:kodejaminan1 and e.TipePembayaran<>'Piutang Asuransi' and a.FB_BATAL='0'
                    UNION ALL
                    SELECT  a.KD_PIUTANG collate Latin1_General_CI_AS ,a.FB_TAGIH, replace(CONVERT(VARCHAR(11), a.FD_TGL_PIUTANG, 111), '/','-') as 
                FD_TGL_PIUTANG  , b.NoRegistrasi collate Latin1_General_CI_AS  as NoRegistrasi ,d.PatientName collate Latin1_General_CI_AS  , '' as NamaUnit   ,a.Fn_piutang,isnull(a.FS_NO_REFF_BRIDGING,'') as FS_NO_REFF_BRIDGING
                    from Keuangan.dbo.PIUTANG_PASIEN a
                    inner join PerawatanSQL.dbo.Visit b on a.NO_TRANSAKSI collate Latin1_General_CI_AS = B.NoRegistrasi  collate Latin1_General_CI_AS 
                    inner join MasterdataSQL.dbo.MstrUnitPerwatan c on c.ID = b.Unit
                    inner join MasterdataSQL.dbo.Admision d on d.NoMR  collate Latin1_General_CI_AS = b.NoMR  collate Latin1_General_CI_AS
                    inner join PerawatanSQL.dbo.PaymentDetails e on e.PaymentID = a.PAYMENT_NO
                    AND  a.FB_TAGIH='0' 
                    and replace(CONVERT(VARCHAR(11), A.fd_tgL_piutang, 111), '/','-') BETWEEN :periode2 AND :periodeAkhir2
                    AND A.kode_jaminan=:kodejaminan2 and e.TipePembayaran<>'Piutang Asuransi' 
                    and a.FB_BATAL='0'
                    UNION ALL
                    SELECT a.KD_PIUTANG collate Latin1_General_CI_AS ,a.FB_TAGIH, replace(CONVERT(VARCHAR(11), a.FD_TGL_PIUTANG, 111), '/','-') as 
                     FD_TGL_PIUTANG, a.NO_TRANSAKSI collate Latin1_General_CI_AS  as NoRegistrasi, 
                 A.FS_kET  collate Latin1_General_CI_AS  as PatientName,'' as NamaUnit,a.Fn_piutang,'' as FS_NO_REFF_BRIDGING
                     FROM Keuangan.dbo.PIUTANG_PASIEN a 
                     where a.FB_BATAL='0' AND  a.FB_TAGIH='0' 
                     and a.TipePiutang='RAJAL' and a.TipeJaminan='NonAsuransi'  
                     and  replace(CONVERT(VARCHAR(11), A.fd_tgL_piutang, 111), '/','-') BETWEEN :periode3 AND :periodeAkhir3
                     AND A.kode_jaminan=:kodejaminan3 and a.FB_BATAL='0'
                     UNION ALL
                     SELECT a.KD_PIUTANG,a.FB_TAGIH, replace(CONVERT(VARCHAR(11), a.FD_TGL_PIUTANG, 111), '/','-') as 
                FD_TGL_PIUTANG, b.NoRegRI as NoRegistrasi,d.PatientName, '' as NamaUnit,a.Fn_piutang,isnull(a.FS_NO_REFF_BRIDGING,'') as FS_NO_REFF_BRIDGING
                    from Keuangan.dbo.PIUTANG_PASIEN a
                    inner join PerawatanSQL.dbo.Visit b on a.NO_TRANSAKSI collate Latin1_General_CI_AS = B.NoRegistrasi  collate Latin1_General_CI_AS
                    inner join MasterdataSQL.dbo.MstrUnitPerwatan c on c.ID = b.Unit
                    inner join MasterdataSQL.dbo.Admision_walkin d on d.NoMR = b.NoMR
                    inner join PerawatanSQL.dbo.PaymentDetails e on e.PaymentID = a.PAYMENT_NO
                    WHERE  FS_KD_TAGIH in (SELECT FS_KD_TRS FROM Keuangan.DBO.TA_ORDER_PIUTANG WHERE ID=:myKey2 ) and a.FB_TAGIH='1'
                    and replace(CONVERT(VARCHAR(11), A.fd_tgL_piutang, 111), '/','-') BETWEEN :periode4 AND :periodeAkhir4
                    AND A.kode_jaminan=:kodejaminan4 and e.TipePembayaran<>'Piutang Asuransi' 
                    and a.FB_BATAL='0'
                    UNION ALL
                    SELECT   a.KD_PIUTANG collate Latin1_General_CI_AS ,a.FB_TAGIH, 
                      replace(CONVERT(VARCHAR(11), a.FD_TGL_PIUTANG, 111), '/','-') as 
                    FD_TGL_PIUTANG  , b.NoRegistrasi collate Latin1_General_CI_AS  as NoRegistrasi ,
                    d.PatientName collate Latin1_General_CI_AS  ,
                    '' as NamaUnit   ,a.Fn_piutang,isnull(a.FS_NO_REFF_BRIDGING,'') as FS_NO_REFF_BRIDGING
                    from Keuangan.dbo.PIUTANG_PASIEN a
                    inner join PerawatanSQL.dbo.Visit b on a.NO_TRANSAKSI collate Latin1_General_CI_AS  = B.NoRegistrasi  collate Latin1_General_CI_AS 
                    inner join MasterdataSQL.dbo.MstrUnitPerwatan c on c.ID = b.Unit
                    inner join MasterdataSQL.dbo.Admision_walkin d on d.NoMR collate Latin1_General_CI_AS  = b.NoMR collate Latin1_General_CI_AS 
                    inner join PerawatanSQL.dbo.PaymentDetails e on e.PaymentID = a.PAYMENT_NO
                    AND  a.FB_TAGIH='0' 
                    and replace(CONVERT(VARCHAR(11), A.fd_tgL_piutang, 111), '/','-') BETWEEN :periode5 AND :periodeAkhir5
                    AND A.kode_jaminan=:kodejaminan5 and e.TipePembayaran<>'Piutang Asuransi' 
                    and a.FB_BATAL='0'
                    UNION ALL
                     SELECT  a.KD_PIUTANG collate Latin1_General_CI_AS ,a.FB_TAGIH, 
                    replace(CONVERT(VARCHAR(11), a.FD_TGL_PIUTANG, 111), '/','-') as 
                    FD_TGL_PIUTANG  , b.NoRegistrasi collate Latin1_General_CI_AS  as NoRegistrasi ,
                b.[Ship Name]  collate Latin1_General_CI_AS as PatientName ,
                    '' as NamaUnit   ,a.Fn_piutang,isnull(a.FS_NO_REFF_BRIDGING,'') as FS_NO_REFF_BRIDGING
                    from Keuangan.dbo.PIUTANG_PASIEN a
                    inner join [Apotik_V1.1SQL].dbo.Orders b on a.NO_TRANSAKSI collate Latin1_General_CI_AS  = B.NoResep  collate Latin1_General_CI_AS 
                    inner join PerawatanSQL.dbo.PaymentDetails e on e.PaymentID = a.PAYMENT_NO
                    AND  a.FB_TAGIH='0' 
                    and replace(CONVERT(VARCHAR(11), A.fd_tgL_piutang, 111), '/','-') BETWEEN :periode6 AND :periodeAkhir6
                    AND A.kode_jaminan=:kodejaminan6 and e.TipePembayaran<>'Piutang Asuransi'   
                    and a.FB_BATAL='0' 
                      UNION ALL
                     SELECT  a.KD_PIUTANG collate Latin1_General_CI_AS ,a.FB_TAGIH, 
                    replace(CONVERT(VARCHAR(11), a.FD_TGL_PIUTANG, 111), '/','-') as 
                    FD_TGL_PIUTANG  , b.NoRegistrasi collate Latin1_General_CI_AS  as NoRegistrasi ,
                b.[Ship Name]  collate Latin1_General_CI_AS as PatientName ,
                    '' as NamaUnit   ,a.Fn_piutang,isnull(a.FS_NO_REFF_BRIDGING,'') as FS_NO_REFF_BRIDGING
                    from Keuangan.dbo.PIUTANG_PASIEN a
                    inner join [Apotik_V1.1SQL].dbo.Orders b on a.NO_TRANSAKSI collate Latin1_General_CI_AS  = B.NoResep  collate Latin1_General_CI_AS 
                    inner join PerawatanSQL.dbo.PaymentDetails e on e.PaymentID = a.PAYMENT_NO
                    where  FS_KD_TAGIH in (SELECT FS_KD_TRS FROM Keuangan.DBO.TA_ORDER_PIUTANG WHERE ID=:myKey3 ) and a.FB_TAGIH='1' 
                    and replace(CONVERT(VARCHAR(11), A.fd_tgL_piutang, 111), '/','-') BETWEEN :periode7 AND :periodeAkhir7
                    AND A.kode_jaminan=:kodejaminan7  and e.TipePembayaran<>'Piutang Asuransi'   
                    and a.FB_BATAL='0' ";
                    $this->db->query($query);
                    $this->db->bind('periode1', $TglPeriode1);
                    $this->db->bind('periode2', $TglPeriode1);
                    $this->db->bind('periode3', $TglPeriode1);
                    $this->db->bind('periode4', $TglPeriode1);
                    $this->db->bind('periode5', $TglPeriode1);
                    $this->db->bind('periode6', $TglPeriode1);
                    $this->db->bind('periode7', $TglPeriode1);
                    $this->db->bind('periodeAkhir1', $TglPeriode2);
                    $this->db->bind('periodeAkhir2', $TglPeriode2);
                    $this->db->bind('periodeAkhir3', $TglPeriode2);
                    $this->db->bind('periodeAkhir4', $TglPeriode2);
                    $this->db->bind('periodeAkhir5', $TglPeriode2);
                    $this->db->bind('periodeAkhir6', $TglPeriode2);
                    $this->db->bind('periodeAkhir7', $TglPeriode2);


                    $this->db->bind('kodejaminan1', $kodejaminan);
                    $this->db->bind('kodejaminan2', $kodejaminan);
                    $this->db->bind('kodejaminan3', $kodejaminan);
                    $this->db->bind('kodejaminan4', $kodejaminan);
                    $this->db->bind('kodejaminan5', $kodejaminan);
                    $this->db->bind('kodejaminan6', $kodejaminan);
                    $this->db->bind('kodejaminan7', $kodejaminan);

                    $this->db->bind('myKey1', $myKey);
                    $this->db->bind('myKey2',  $myKey);
                    $this->db->bind('myKey3',  $myKey);
                    $this->db->execute();
                    $data =  $this->db->resultSet();
                    $rows = array();
                    // var_dump($data);
                    // exit;
                    foreach ($data as $row) {
                        $pasing['KD_PIUTANG'] = $row['KD_PIUTANG'];
                        $pasing['FB_TAGIH'] = $row['FB_TAGIH'];
                        $pasing['FD_TGL_PIUTANG'] = date('d/m/Y', strtotime($row['FD_TGL_PIUTANG']));
                        $pasing['NoRegistrasi'] = $row['NoRegistrasi'];
                        $pasing['PatientName'] = $row['PatientName'];
                        $pasing['NamaUnit'] = $row['NamaUnit'];
                        $pasing['Fn_piutang'] = $row['Fn_piutang'];
                        $pasing['FS_NO_REFF_BRIDGING'] = $row['FS_NO_REFF_BRIDGING'];


                        $rows[] = $pasing;
                    }
                }
            }

            if ($JenisRegistrasi == "RI") {
                if ($jenisjaminan == "Asuransi") {
                    $query = "SELECT a.KD_PIUTANG,a.FB_TAGIH, replace(CONVERT(VARCHAR(11), a.FD_TGL_PIUTANG, 111), '/','-') as 
                FD_TGL_PIUTANG, b.NoRegRI as NoRegistrasi,d.PatientName, '' as NamaUnit,a.Fn_piutang,isnull(a.FS_NO_REFF_BRIDGING,'') as FS_NO_REFF_BRIDGING
              from Keuangan.dbo.PIUTANG_PASIEN a
              inner join RawatInapSQL.dbo.Inpatient b on a.NO_TRANSAKSI collate Latin1_General_CI_AS = B.NoRegRI  collate Latin1_General_CI_AS
              inner join MasterdataSQL.dbo.Admision d on d.NoMR = b.NoMR
              inner join  RawatInapSQL.dbo.DepositDetails  e on e.IDDeposit = a.PAYMENT_NO
              WHERE  FS_KD_TAGIH in (SELECT FS_KD_TRS FROM Keuangan.DBO.TA_ORDER_PIUTANG WHERE ID=:myKey1 )
                and a.FB_TAGIH='1' 
              and replace(CONVERT(VARCHAR(11), A.fd_tgL_piutang, 111), '/','-') BETWEEN :periode1 AND :periodeAkhir1
              and e.TipePembayaran='Piutang Asuransi' AND A.kode_jaminan=:kodejaminan1 
              and a.FB_BATAL='0'
              UNION ALL
              SELECT a.KD_PIUTANG,a.FB_TAGIH, replace(CONVERT(VARCHAR(11), a.FD_TGL_PIUTANG, 111), '/','-') as 
                FD_TGL_PIUTANG, b.NoRegRI as NoRegistrasi,d.PatientName, '' as NamaUnit,a.Fn_piutang,isnull(a.FS_NO_REFF_BRIDGING,'') as FS_NO_REFF_BRIDGING
              from Keuangan.dbo.PIUTANG_PASIEN a
             inner join RawatInapSQL.dbo.Inpatient b on a.NO_TRANSAKSI collate Latin1_General_CI_AS = B.NoRegRI  collate Latin1_General_CI_AS
              inner join MasterdataSQL.dbo.Admision d on d.NoMR = b.NoMR
              inner join  RawatInapSQL.dbo.DepositDetails  e on e.IDDeposit = a.PAYMENT_NO
              AND  a.FB_TAGIH='0'
              and replace(CONVERT(VARCHAR(11), A.fd_tgL_piutang, 111), '/','-') BETWEEN :periode2 AND :periodeAkhir2
              and e.TipePembayaran='Piutang Asuransi' AND A.kode_jaminan=:kodejaminan2 
              and a.FB_BATAL='0'";
                    $this->db->query($query);
                    $this->db->bind('periode1', $TglPeriode1);
                    $this->db->bind('periode2', $TglPeriode1);



                    $this->db->bind('periodeAkhir1', $TglPeriode2);
                    $this->db->bind('periodeAkhir2', $TglPeriode2);



                    $this->db->bind('kodejaminan1', $kodejaminan);
                    $this->db->bind('kodejaminan2', $kodejaminan);


                    $this->db->bind('myKey1', $myKey);
                    $this->db->execute();
                    $data =  $this->db->resultSet();
                    $rows = array();
                    // var_dump($data);
                    // exit;
                    foreach ($data as $row) {
                        $pasing['KD_PIUTANG'] = $row['KD_PIUTANG'];
                        $pasing['FB_TAGIH'] = $row['FB_TAGIH'];
                        $pasing['FD_TGL_PIUTANG'] = date('d/m/Y', strtotime($row['FD_TGL_PIUTANG']));
                        $pasing['NoRegistrasi'] = $row['NoRegistrasi'];
                        $pasing['PatientName'] = $row['PatientName'];
                        $pasing['NamaUnit'] = $row['NamaUnit'];
                        $pasing['Fn_piutang'] = $row['Fn_piutang'];
                        $pasing['FS_NO_REFF_BRIDGING'] = $row['FS_NO_REFF_BRIDGING'];


                        $rows[] = $pasing;
                    }
                } else {
                    $query = "SELECT  a.KD_PIUTANG,a.FB_TAGIH, replace(CONVERT(VARCHAR(11), a.FD_TGL_PIUTANG, 111), '/','-') as 
                FD_TGL_PIUTANG, b.NoRegRI as NoRegistrasi,d.PatientName,'' as NamaUnit,a.Fn_piutang,isnull(a.FS_NO_REFF_BRIDGING,'') as FS_NO_REFF_BRIDGING
              from Keuangan.dbo.PIUTANG_PASIEN a
              inner join RawatInapSQL.dbo.Inpatient b on a.NO_TRANSAKSI collate Latin1_General_CI_AS = B.NoRegRI  collate Latin1_General_CI_AS
              inner join MasterdataSQL.dbo.Admision d on d.NoMR = b.NoMR
              inner join  RawatInapSQL.dbo.DepositDetails  e on e.IDDeposit = a.PAYMENT_NO
              WHERE FS_KD_TAGIH   in (SELECT FS_KD_TRS FROM Keuangan.DBO.TA_ORDER_PIUTANG WHERE ID=:myKey2 )
                and a.FB_TAGIH='1' 
              and replace(CONVERT(VARCHAR(11), A.fd_tgL_piutang, 111), '/','-') BETWEEN :periode3 AND :periodeAkhir3
              and e.TipePembayaran<>'Piutang Asuransi' AND A.kode_jaminan=:kodejaminan3  
              and a.FB_BATAL='0'
              UNION ALL
              SELECT  a.KD_PIUTANG,a.FB_TAGIH, replace(CONVERT(VARCHAR(11), a.FD_TGL_PIUTANG, 111), '/','-') as 
                FD_TGL_PIUTANG, b.NoRegRI as NoRegistrasi,d.PatientName,  '' as  NamaUnit,a.Fn_piutang,isnull(a.FS_NO_REFF_BRIDGING,'') as FS_NO_REFF_BRIDGING
              from Keuangan.dbo.PIUTANG_PASIEN a
              inner join RawatInapSQL.dbo.Inpatient b on a.NO_TRANSAKSI collate Latin1_General_CI_AS = B.NoRegRI  collate Latin1_General_CI_AS
           
              inner join MasterdataSQL.dbo.Admision d on d.NoMR = b.NoMR
              inner join  RawatInapSQL.dbo.DepositDetails  e on e.IDDeposit = a.PAYMENT_NO
              AND  a.FB_TAGIH='0'
              and replace(CONVERT(VARCHAR(11), A.fd_tgL_piutang, 111), '/','-') BETWEEN  :periode4 AND :periodeAkhir4
              and e.TipePembayaran<>'Piutang Asuransi' AND A.kode_jaminan=:kodejaminan4 
              and a.FB_BATAL='0'";
                    $this->db->query($query);
                    // $this->db->bind('periode1', $TglPeriode1);
                    // $this->db->bind('periode2', $TglPeriode1);
                    $this->db->bind('periode3', $TglPeriode1);
                    $this->db->bind('periode4', $TglPeriode1);


                    // $this->db->bind('periodeAkhir1', $TglPeriode2);
                    // $this->db->bind('periodeAkhir2', $TglPeriode2);
                    $this->db->bind('periodeAkhir3', $TglPeriode2);
                    $this->db->bind('periodeAkhir4', $TglPeriode2);


                    // $this->db->bind('kodejaminan1', $kodejaminan);
                    // $this->db->bind('kodejaminan2', $kodejaminan);
                    $this->db->bind('kodejaminan3', $kodejaminan);
                    $this->db->bind('kodejaminan4', $kodejaminan);


                    // $this->db->bind('myKey1', $myKey);
                    $this->db->bind('myKey2', $myKey);
                    $this->db->execute();
                    $data =  $this->db->resultSet();
                    $rows = array();
                    // var_dump($data);
                    // exit;
                    foreach ($data as $row) {
                        $pasing['KD_PIUTANG'] = $row['KD_PIUTANG'];
                        $pasing['FB_TAGIH'] = $row['FB_TAGIH'];
                        $pasing['FD_TGL_PIUTANG'] = date('d/m/Y', strtotime($row['FD_TGL_PIUTANG']));
                        $pasing['NoRegistrasi'] = $row['NoRegistrasi'];
                        $pasing['PatientName'] = $row['PatientName'];
                        $pasing['NamaUnit'] = $row['NamaUnit'];
                        $pasing['Fn_piutang'] = $row['Fn_piutang'];
                        $pasing['FS_NO_REFF_BRIDGING'] = $row['FS_NO_REFF_BRIDGING'];


                        $rows[] = $pasing;
                    }
                }
            }

            if ($JenisRegistrasi == "SA") {
                if ($jenisjaminan == "Asuransi") {
                    $query = "SELECT A.kode_jaminan, a.TipeJaminan,a.TipePiutang,a.KD_PIUTANG collate Latin1_General_CI_AS KD_PIUTANG ,a.FB_TAGIH, replace(CONVERT(VARCHAR(11), a.FD_TGL_PIUTANG, 111), '/','-') as 
                     FD_TGL_PIUTANG, a.NO_TRANSAKSI collate Latin1_General_CI_AS  as NoRegistrasi, 
                 A.FS_kET  collate Latin1_General_CI_AS  as PatientName,'' as NamaUnit,a.Fn_piutang,'' as FS_NO_REFF_BRIDGING
                     FROM Keuangan.dbo.PIUTANG_PASIEN a  
                     where a.FB_BATAL='0'   AND  a.FB_TAGIH='1' 
                     and a.TipePiutang='LAIN-LAIN' and a.TipeJaminan='Asuransi'  
                     and  replace(CONVERT(VARCHAR(11), A.fd_tgL_piutang, 111), '/','-') BETWEEN :periode1 AND :periodeAkhir1
                     AND A.kode_jaminan=:kodejaminan1 and a.FB_BATAL='0'
                     UNION ALL
                     SELECT A.kode_jaminan, a.TipeJaminan,a.TipePiutang,a.KD_PIUTANG collate Latin1_General_CI_AS KD_PIUTANG ,a.FB_TAGIH, replace(CONVERT(VARCHAR(11), a.FD_TGL_PIUTANG, 111), '/','-') as 
                     FD_TGL_PIUTANG, a.NO_TRANSAKSI collate Latin1_General_CI_AS  as NoRegistrasi, 
                 A.FS_kET  collate Latin1_General_CI_AS  as PatientName,'' as NamaUnit,a.Fn_piutang,'' as FS_NO_REFF_BRIDGING
                     FROM Keuangan.dbo.PIUTANG_PASIEN a  
                     where a.FB_BATAL='0'   AND  a.FB_TAGIH='0' 
                     and a.TipePiutang='LAIN-LAIN' and a.TipeJaminan='Asuransi'  
                     and  replace(CONVERT(VARCHAR(11), A.fd_tgL_piutang, 111), '/','-') BETWEEN :periode2 AND :periodeAkhir2
                     AND A.kode_jaminan=:kodejaminan2   and a.FB_BATAL='0'";
                    $this->db->query($query);
                    $this->db->bind('periode1', $TglPeriode1);
                    $this->db->bind('periode2', $TglPeriode1);


                    $this->db->bind('periodeAkhir1', $TglPeriode2);
                    $this->db->bind('periodeAkhir2', $TglPeriode2);



                    $this->db->bind('kodejaminan1', $kodejaminan);
                    $this->db->bind('kodejaminan2', $kodejaminan);

                    $this->db->execute();


                    $data =  $this->db->resultSet();
                    $rows = array();
                    foreach ($data as $row) {
                        $pasing['KD_PIUTANG'] = $row['KD_PIUTANG'];
                        $pasing['FB_TAGIH'] = $row['FB_TAGIH'];
                        $pasing['FD_TGL_PIUTANG'] = date('d/m/Y', strtotime($row['FD_TGL_PIUTANG']));
                        $pasing['NoRegistrasi'] = $row['NoRegistrasi'];
                        $pasing['PatientName'] = $row['PatientName'];
                        $pasing['NamaUnit'] = $row['NamaUnit'];
                        $pasing['Fn_piutang'] = $row['Fn_piutang'];
                        $pasing['FS_NO_REFF_BRIDGING'] = $row['FS_NO_REFF_BRIDGING'];


                        $rows[] = $pasing;
                    }
                } else {
                    $query = "SELECT a.KD_PIUTANG collate Latin1_General_CI_AS KD_PIUTANG,a.FB_TAGIH, replace(CONVERT(VARCHAR(11), a.FD_TGL_PIUTANG, 111), '/','-') as 
                     FD_TGL_PIUTANG, a.NO_TRANSAKSI collate Latin1_General_CI_AS  as NoRegistrasi, 
                 A.FS_kET  collate Latin1_General_CI_AS  as PatientName,'' as NamaUnit,a.Fn_piutang,'' as FS_NO_REFF_BRIDGING
                     FROM Keuangan.dbo.PIUTANG_PASIEN a 
                     
                     where a.FB_BATAL='0' AND  a.FB_TAGIH='0' 
                     and a.TipePiutang='LAIN-LAIN' and a.TipeJaminan='NonAsuransi'  
                     and  replace(CONVERT(VARCHAR(11), A.fd_tgL_piutang, 111), '/','-') BETWEEN :periode3 AND :periodeAkhir3 
                     AND A.kode_jaminan=:kodejaminan3 and a.FB_BATAL='0'
                     UNION ALL  
                     SELECT a.KD_PIUTANG collate Latin1_General_CI_AS KD_PIUTANG,a.FB_TAGIH, replace(CONVERT(VARCHAR(11), a.FD_TGL_PIUTANG, 111), '/','-') as 
                     FD_TGL_PIUTANG, a.NO_TRANSAKSI collate Latin1_General_CI_AS  as NoRegistrasi, 
                 A.FS_kET  collate Latin1_General_CI_AS  as PatientName,'' as NamaUnit,a.Fn_piutang,'' as FS_NO_REFF_BRIDGING
                     FROM Keuangan.dbo.PIUTANG_PASIEN a 
                     
                     where a.FB_BATAL='0' AND  a.FB_TAGIH='0' 
                     and a.TipePiutang='LAIN-LAIN' and a.TipeJaminan='NonAsuransi'  
                     and  replace(CONVERT(VARCHAR(11), A.fd_tgL_piutang, 111), '/','-') BETWEEN :periode4 AND :periodeAkhir4 
                     AND A.kode_jaminan=:kodejaminan4 and a.FB_BATAL='0'";
                    $this->db->query($query);
                    // $this->db->bind('periode1', $TglPeriode1);
                    // $this->db->bind('periode2', $TglPeriode1);
                    $this->db->bind('periode3', $TglPeriode1);
                    $this->db->bind('periode4', $TglPeriode1);

                    // $this->db->bind('periodeAkhir1', $TglPeriode2);
                    // $this->db->bind('periodeAkhir2', $TglPeriode2);
                    $this->db->bind('periodeAkhir3', $TglPeriode2);
                    $this->db->bind('periodeAkhir4', $TglPeriode2);


                    // $this->db->bind('kodejaminan1', $kodejaminan);
                    // $this->db->bind('kodejaminan2', $kodejaminan);
                    $this->db->bind('kodejaminan3', $kodejaminan);
                    $this->db->bind('kodejaminan4', $kodejaminan);
                    $this->db->execute();


                    $data =  $this->db->resultSet();
                    $rows = array();
                    foreach ($data as $row) {
                        $pasing['KD_PIUTANG'] = $row['KD_PIUTANG'];
                        $pasing['FB_TAGIH'] = $row['FB_TAGIH'];
                        $pasing['FD_TGL_PIUTANG'] = date('d/m/Y', strtotime($row['FD_TGL_PIUTANG']));
                        $pasing['NoRegistrasi'] = $row['NoRegistrasi'];
                        $pasing['PatientName'] = $row['PatientName'];
                        $pasing['NamaUnit'] = $row['NamaUnit'];
                        $pasing['Fn_piutang'] = $row['Fn_piutang'];
                        $pasing['FS_NO_REFF_BRIDGING'] = $row['FS_NO_REFF_BRIDGING'];


                        $rows[] = $pasing;
                    }
                }
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    public function getListOrderPiutangJatuhTempo($data)
    {
        try {

            $this->db->query("SELECT a.ID,a.FS_KD_TRS,replace(CONVERT(VARCHAR(11), a.FD_TGL_TRS, 111), '/','-') as FD_TGL_TRS,  
            b.NamaPerusahaan,a.FS_KET,a.FN_TOTAL_TAGIH from Keuangan.dbo.TA_ORDER_PIUTANG a
            inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi b on a.FS_KD_CUSTOMER = b.ID
            where replace(CONVERT(VARCHAR(11), FD_TGL_VOID, 111), '/','-')='3000-01-01'
            and a.FS_JENIS_CUSTOMER='Asuransi' 
            UNION ALL
            SELECT a.ID,a.FS_KD_TRS,replace(CONVERT(VARCHAR(11), a.FD_TGL_TRS, 111), '/','-') as FD_TGL_TRS,  
            b.NamaPerusahaan,a.FS_KET,a.FN_TOTAL_TAGIH from Keuangan.dbo.TA_ORDER_PIUTANG a
            inner join MasterdataSQL.dbo.MstrPerusahaanJPK b on a.FS_KD_CUSTOMER = b.ID
            where replace(CONVERT(VARCHAR(11), FD_TGL_VOID, 111), '/','-')='3000-01-01'
            and a.FS_JENIS_CUSTOMER='Perusahaan'");
            // $this->db->bind('tglperiode', $data['Periode']);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $row) {
                $pasing['ID'] = $row['ID'];
                $pasing['FS_KD_TRS'] = $row['FS_KD_TRS'];
                $pasing['FD_TGL_TRS'] = date('d/m/Y', strtotime($row['FD_TGL_TRS']));
                $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                $pasing['FS_KET'] = $row['FS_KET'];
                $pasing['FN_TOTAL_TAGIH'] = $row['FN_TOTAL_TAGIH'];
                // $pasing['FD_TGL_VOID'] = $row['FD_TGL_VOID'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getOrderPiutangbyId($data)
    {
        try {
            $NoTrs = $data['NoTrs'];
            $this->db->query("SELECT FS_KD_TRS, replace(CONVERT(VARCHAR(11), FD_TGL_TRS, 111), '/','-') as FD_TGL_TRS,
            FS_KD_PETUGAS,replace(CONVERT(VARCHAR(11), FD_TGL_INPUT, 111), '/','-') as FD_TGL_INPUT
            ,replace(CONVERT(VARCHAR(11), fd_periode1, 111), '/','-') as fd_periode1
            ,replace(CONVERT(VARCHAR(11), fd_periode2, 111), '/','-') as fd_periode2
            ,FS_JENIS_CUSTOMER,FS_KD_CUSTOMER,FS_KET,FN_TOTAL_TAGIH,Fs_Code_Jenis_Reg,
             b.NamaPerusahaan,a.FS_Alamat_Tagih,b.Rekening
            ,replace(CONVERT(VARCHAR(11), Fd_Tgl_Diterima, 111), '/','-') as tglterima,
            Fs_Petugas_Penerima,FS_ALASAN
             from Keuangan.dbo.TA_ORDER_PIUTANG A
     INNER JOIN MasterdataSQL.dbo.MstrPerusahaanJPK b
     on a.FS_KD_CUSTOMER = b.ID where a.ID=:TransactionCode and FS_JENIS_CUSTOMER='Perusahaan'
     and replace(CONVERT(VARCHAR(11), a.FD_TGL_VOID, 111), '/','-')='3000-01-01' 
     UNION ALL
     SELECT FS_KD_TRS, replace(CONVERT(VARCHAR(11), FD_TGL_TRS, 111), '/','-') as FD_TGL_TRS,
            FS_KD_PETUGAS,replace(CONVERT(VARCHAR(11), FD_TGL_INPUT, 111), '/','-') as FD_TGL_INPUT
            ,replace(CONVERT(VARCHAR(11), fd_periode1, 111), '/','-') as fd_periode1
            ,replace(CONVERT(VARCHAR(11), fd_periode2, 111), '/','-') as fd_periode2
            ,FS_JENIS_CUSTOMER,FS_KD_CUSTOMER,FS_KET,FN_TOTAL_TAGIH,Fs_Code_Jenis_Reg,
    b.NamaPerusahaan,a.FS_Alamat_Tagih,b.Rekening
            ,replace(CONVERT(VARCHAR(11), Fd_Tgl_Diterima, 111), '/','-') as tglterima,
            Fs_Petugas_Penerima,FS_ALASAN
             from Keuangan.dbo.TA_ORDER_PIUTANG A
     INNER JOIN MasterdataSQL.dbo.MstrPerusahaanAsuransi b
     on a.FS_KD_CUSTOMER = b.ID where a.ID=:TransactionCode1 and FS_JENIS_CUSTOMER='Asuransi'
     and replace(CONVERT(VARCHAR(11), a.FD_TGL_VOID, 111), '/','-')='3000-01-01'");
            $this->db->bind('TransactionCode', $NoTrs);
            $this->db->bind('TransactionCode1', $NoTrs);
            // var_dump($data);
            // exit;
            $data =  $this->db->single();

            $callback = array(
                'status' => 'success', // Set array status dengan success
                'FS_KD_TRS' => $data['FS_KD_TRS'], // Set array status dengan success
                'FD_TGL_TRS' => $data['FD_TGL_TRS'], // Set array status dengan success
                'FS_KD_PETUGAS' => $data['FS_KD_PETUGAS'], // Set array status dengan success
                'FD_TGL_INPUT' => $data['FD_TGL_INPUT'], // Set array status dengan success
                'FS_JENIS_CUSTOMER' => $data['FS_JENIS_CUSTOMER'], // Set array status dengan success
                'FS_KD_CUSTOMER' => $data['FS_KD_CUSTOMER'], // Set array status dengan success
                'FS_KET' => $data['FS_KET'], // Set array status dengan successDate_of_birth
                'FN_TOTAL_TAGIH' => $data['FN_TOTAL_TAGIH'], // Set array status dengan successDate_of_birth
                'fd_periode2' => $data['fd_periode2'], // Set array status dengan successDate_of_birth
                'fd_periode1' => $data['fd_periode1'], // Set array status dengan successDate_of_birth
                'Fs_Code_Jenis_Reg' => $data['Fs_Code_Jenis_Reg'],
                'NamaPerusahaan' => $data['NamaPerusahaan'],
                'FS_Alamat_Tagih' => $data['FS_Alamat_Tagih'],
                'Rekeningx' => $data['Rekening'],
                'tglterima' => $data['tglterima'],
                'Fs_Petugas_Penerima' => $data['Fs_Petugas_Penerima'],
                'FS_ALASAN' => $data['FS_ALASAN'],

            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getNamaPenjamin($data)
    {
        try {

            $JenisPenjamin = $data['JenisPenjamin'];
            if ($JenisPenjamin == "Asuransi") {
                $this->db->query("SELECT ID,NamaPerusahaan FROM MasterDataSQL.dbo.MstrPerusahaanAsuransi where StatusAktif='1'");
                $data =  $this->db->resultSet();
                $this->db->execute();
                $rows = array();
                $array = array();
                foreach ($data as $row) {
                    $pasing['ID'] = $row['ID'];
                    $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                    $rows[] = $pasing;
                }
            } elseif ($JenisPenjamin == "Perusahaan") {
                $this->db->query("SELECT ID,NamaPerusahaan FROM MasterDataSQL.dbo.MstrPerusahaanJPK where StatusAktif='1'");
                $data =  $this->db->resultSet();
                $this->db->execute();
                $rows = array();
                $array = array();
                foreach ($data as $row) {
                    $pasing['ID'] = $row['ID'];
                    $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                    $rows[] = $pasing;
                }
            } else {
                $this->db->query("SELECT ID,NamaPerusahaan FROM MasterDataSQL.dbo.MstrPerusahaanJPK where StatusAktif='1' and 1=0");
                $data =  $this->db->resultSet();
                $this->db->execute();
                $rows = array();
                $array = array();
                foreach ($data as $row) {
                    $pasing['ID'] = $row['ID'];
                    $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                    $rows[] = $pasing;
                }
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
    public function getalamatJaminan($data)
    {
        try {
            $this->db->transaksi();

            $JenisPenjamin = $data['JenisPenjamin'];
            $kodejaminan = $data['kodejaminan'];

            // var_dump($data);
            // exit;
            if ($JenisPenjamin == "Asuransi") {
                $this->db->query("SELECT Alamat FROM MasterdataSQL.DBO.MstrPerusahaanAsuransi WHERE ID=:kodejaminan");
                $this->db->bind('kodejaminan', $kodejaminan);
                $dataxx =  $this->db->single();
                $Alamat = $dataxx['Alamat'];
                $this->db->execute();

                // var_dump($Alamat);
                // exit;
            } elseif ($JenisPenjamin == "Perusahaan") {
                $this->db->query("SELECT Alamat FROM MasterdataSQL.DBO.MstrPerusahaanJPK WHERE ID=:kodejaminan1");
                $this->db->bind('kodejaminan1', $kodejaminan);

                $dataxx =  $this->db->single();
                $this->db->execute();

                $Alamat = $dataxx['Alamat'];
                // $this->db->commit();

                // var_dump($Alamat);
                // exit;
            }

            $callback = array(
                'status' => 'success',
                'Alamat' => $Alamat, // Set array status dengan success 
                'Alamat' => $Alamat, // Set array status dengan success 
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error",
                'message' => $e,

            );
            return $callback;
        }
    }
    public function newInsertTagihan($data)
    {

        $session = SessionManager::getCurrentSession();
        $userid = $session->username;
        $token = $session->token;
        $namauserx = $session->name;
        $datenowx = Utils::datenowcreateNotFull();
        $datenowcreate = Utils::seCurrentDateTime();
        $noreg = $data['NoRegistrasi'];

        $datenowcreate1 = date('Y-m-d', strtotime($datenowx));
        $datenowcreate2 = date('dmy', strtotime($datenowx));

        $datebilling = $data['tglbill'];
        // $kodereg = $data['kodereg'];
        $datenowcreatex = $data['tglbill2'];
        $datereg = substr($data['NoRegistrasi'], 4, 6);

        try {
            $this->db->transaksi();
            $kodeawal = "OP";

            $this->db->query("SELECT  TOP 1 FS_KD_TRS,right(FS_KD_TRS,3) as urutregx
            FROM Keuangan.dbo.TA_ORDER_PIUTANG  WHERE  
            replace(CONVERT(VARCHAR(11), FD_TGL_INPUT, 111), '/','-')=:datenowcreate AND LEFT(FS_KD_TRS,2)=:kodeawal
            ORDER BY FD_TGL_INPUT DESC");
            $this->db->bind('datenowcreate', $datenowcreate1);
            $this->db->bind('kodeawal', $kodeawal);
            $data =  $this->db->single();
            $nexturut = $data['urutregx'];


            if (empty($nexturut)) {
                //jika gk ada record
                $noUrutJurnal = "001";
            } else {
                //jika ada record 
                $idReg = $nexturut;
                $idReg++;
                // GENERATE NO REGISTRASI
                if (strlen($idReg) == 1) {
                    $noUrutJurnal = "00" . $idReg;
                } else if (strlen($idReg) == 2) {
                    $noUrutJurnal = "0" . $idReg;
                } else if (strlen($idReg) == 3) {
                    $noUrutJurnal = $idReg;
                }
            }
            $kodeawal = "OP";
            $NoTagihan = $kodeawal . $datenowcreate2 . '-' . $noUrutJurnal;
            $pasing['NoTagihan'] = $NoTagihan;



            //  insert ke tabel TA_ORDER_PIUTANG
            $this->db->query("INSERT INTO Keuangan.dbo.TA_ORDER_PIUTANG
            (FS_KD_TRS,FS_KD_PETUGAS,
            FS_JENIS_CUSTOMER, FS_KD_CUSTOMER, FS_KET,
            FD_TGL_INPUT,Fd_Tgl_Diterima) values
            (:NoTagihan,:userid,
              :FS_JENIS_CUSTOMER,:kodejaminan,:FS_KET,
               :datenowcreate,:Fd_Tgl_Diterima)");

            $this->db->bind('NoTagihan', $NoTagihan);
            $this->db->bind('userid', $userid);
            $this->db->bind('FS_JENIS_CUSTOMER', '');
            // $this->db->bind('FS_KD_CUSTOMER', '');
            $this->db->bind('kodejaminan', '');
            $this->db->bind('FS_KET', '');
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('Fd_Tgl_Diterima', '3000-01-01');

            $this->db->execute();

            $this->db->commit();
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
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
    public function newInsertGennow($data)
    {

        $Fs_Code_Jenis_Reg = $data['Fs_Code_Jenis_Reg'];
        $datenowx = Utils::datenowcreateNotFull();

        if ($Fs_Code_Jenis_Reg == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Jenis Pasien Belum Dipilih !',
            );
            echo json_encode($callback);
            exit;
        }

        try {
            $this->db->transaksi();
            if ($Fs_Code_Jenis_Reg == "RJ") {
                $this->db->query("SELECT value_number FROM Keuangan.dbo._ParamNumber where name_param='no_ba_rj'");
                $data =  $this->db->single();
                $value_number = $data['value_number'];

                $this->db->execute();

                $codeBA = "KEU-RJ";
                $this->db->query("SELECT value_number+1 as autonum FROM Keuangan.dbo._ParamNumber where name_param='no_ba_rj'");
                $data =  $this->db->single();
                $autonum = $data['autonum']; 
                // GENERATE NO REGISTRASI
                if (strlen($autonum) == 1) {
                    $fixvalue_number = "000" . $autonum;
                } else if (strlen($autonum) == 2) {
                    $fixvalue_number = "00" . $autonum;
                } else if (strlen($autonum) == 3) {
                    $fixvalue_number = "0" . $autonum;
                } else if (strlen($autonum) == 4) {
                    $fixvalue_number = $autonum;
                }
                
                $this->db->query("UPDATE Keuangan.dbo._ParamNumber set 
                value_number=:fixvalue_number
                where name_param='no_ba_rj'");
                $this->db->bind('fixvalue_number', $fixvalue_number);
                $this->db->execute();
            } else {
                $this->db->query("SELECT value_number FROM Keuangan.dbo._ParamNumber where name_param='no_ba_ri'");
                $data =  $this->db->single();
                $value_number = $data['value_number'];
                $this->db->execute();

                $codeBA = "KEU-RI";
                $this->db->query("SELECT value_number+1 as autonum FROM Keuangan.dbo._ParamNumber where name_param='no_ba_ri'");
                $data =  $this->db->single();
                $autonum = $data['autonum'];

                // GENERATE NO REGISTRASI
                if (strlen($autonum) == 1) {
                    $fixvalue_number = "000" . $autonum;
                } else if (strlen($autonum) == 2) {
                    $fixvalue_number = "00" . $autonum;
                } else if (strlen($autonum) == 3) {
                    $fixvalue_number = "0" . $autonum;
                } else if (strlen($autonum) == 4) {
                    $fixvalue_number = $autonum;
                }

                $this->db->query("UPDATE Keuangan.dbo._ParamNumber set 
                value_number=:fixvalue_number
                where name_param='no_ba_ri'");
                $this->db->bind('fixvalue_number', $fixvalue_number);
                $this->db->execute();
            }
            $getBulanBA =  date('m', strtotime($datenowx));
            $getTahunBA = date('Y', strtotime($datenowx));
            if ($getBulanBA == "01") {
                $getBlnRomawi = "I";
            } else if ($getBulanBA == "02") {
                $getBlnRomawi = "II";
            } else if ($getBulanBA == "03") {
                $getBlnRomawi = "III";
            } else if ($getBulanBA == "04") {
                $getBlnRomawi = "IV";
            } else if ($getBulanBA == "05") {
                $getBlnRomawi = "V";
            } else if ($getBulanBA == "06") {
                $getBlnRomawi = "VI";
            } else if ($getBulanBA == "07") {
                $getBlnRomawi = "VII";
            } else if ($getBulanBA == "08") {
                $getBlnRomawi = "VIII";
            } else if ($getBulanBA == "09") {
                $getBlnRomawi = "IX";
            } else if ($getBulanBA == "10") {
                $getBlnRomawi = "X";
            } else if ($getBulanBA == "11") {
                $getBlnRomawi = "XI";
            } else if ($getBulanBA == "12") {
                $getBlnRomawi = "XII";
            }

            $AutoNumberBAFix = $value_number . '/RSU-YARSI/' . $codeBA . '/INV/' . $getBlnRomawi . '/' . $getTahunBA;
            $pasing['AutoNumberBAFix'] = $AutoNumberBAFix;

            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'AutoNumberBAFix' => $AutoNumberBAFix, // Set array status dengan success 
                'AutoNumberBAFix' => $AutoNumberBAFix, // Set array status dengan success 
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error",
                'message' => $e,

            );
            return $callback;
        }
    }

    public function VoidRegistrasi($data)
    {
        try {
            $this->db->transaksi();
            // var_dump($data);
            // exit;
            $datenowcreate = Utils::seCurrentDateTime();
            $noregbatal = $data['noregbatal']; // ok
            $alasanbatal = $data['alasanbatal']; // ok
            // TRIGER SEBELUM SIMPAN DATA
            // 1. TRIGER PASIEN JIKA JENIS BELUM DIISI  
            if ($noregbatal == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. Registrasi Kosong !',
                );
                echo json_encode($callback);
                exit;
            }
            // 1. TRIGER PASIEN JIKA ALASAN
            if ($alasanbatal == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Alasan Batal kosong !',
                );
                echo json_encode($callback);
                exit;
            }

            // $this->db->query("SELECT *FROM PerawatanSQL.DBO.[Visit Details] 
            //                 WHERE NoRegistrasi=:noregbatal and KategoriTarif<>'Administrasi'");
            // $this->db->bind('noregbatal', $noregbatal);
            // $data =  $this->db->single();
            // if ($data) {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => 'Registrasi Sudah ada Billing Selain Administrasi, Batalkan Dahulu Semua Billing !',
            //     );
            //     return $callback;
            //     exit;
            // }

            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;

            $this->db->query("UPDATE Keuangan.dbo.TA_ORDER_PIUTANG set 
            FS_KD_PETUGAS_VOID=:userid,FD_TGL_VOID=:tglbatal,
            FS_ALASAN=:alasanbatal
            where FS_KD_TRS=:noregbatal");
            $this->db->bind('userid', $userid);
            $this->db->bind('tglbatal', $datenowcreate);
            $this->db->bind('alasanbatal', $alasanbatal);
            $this->db->bind('noregbatal', $noregbatal);
            $this->db->execute();

            $this->db->query("UPDATE Keuangan.dbo.PIUTANG_PASIEN set 
            FB_TAGIH='0', FS_KD_TAGIH='',FS_SURAT='',
            FD_TGL_TAGIH='',
            FS_KD_PETUGAS_TAGIH=''
            where FS_KD_TAGIH=:noregbatal");
            $this->db->bind('noregbatal', $noregbatal);
            $this->db->execute();

            $this->db->query("INSERT INTO  SysLog.dbo.TZ_Log_Button 
                        (noregistrasi,petugas_batal,tgl_batal,alasan_batal) VALUES
                        (:noregbatal,:userid,:datenowcreate,:alasanbatal)");
            $this->db->bind('noregbatal', $noregbatal);
            $this->db->bind('userid', $userid);
            $this->db->bind('datenowcreate', $datenowcreate);
            $this->db->bind('alasanbatal', $alasanbatal);
            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Registrasi berhasil Dihapus !'
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
    public function bataltagih($data)
    {
        try {
            $this->db->transaksi();

            $datenowcreate = Utils::seCurrentDateTime();
            $NoTrs = $data['NoTrs'];

            $tgltagih = $data['tgltagih'];
            $Periode =  $data['Periode'];
            $Periode2 = $data['Periode2'];
            $JenisPenjamin = $data['JenisPenjamin'];
            $NoSuratTagihan = $data['NoSuratTagihan'];
            $NominalTagihan = $data['NominalTagihan'];
            $kodejaminan = $data['kodejaminan'];
            $NoTagihan = $data['NoTagihan'];


            if ($NoTagihan == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. Transaksi Tagihan Invalid ! !',
                );
                echo json_encode($callback);
                exit;
            }

            if ($NoSuratTagihan == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'KNo Surat Tagihan Invalid !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($tgltagih == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Tgl Tagihan Invalid !',
                );
                echo json_encode($callback);
                exit;
            }
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $this->db->query("SELECT sum(fn_piutang) as nilaipiutang
            from Keuangan.dbo.PIUTANG_PASIEN
            where fs_kd_tagih=:NoTagihan");
            $this->db->bind('NoTagihan', $NoTagihan);
            // $this->db->execute();
            $datax =  $this->db->single();
            $nilaipiutang = $datax['nilaipiutang'];

            $this->db->query("UPDATE Keuangan.dbo.PIUTANG_PASIEN set 
            FB_TAGIH='0', FS_KD_TAGIH='',FS_SURAT='',
            FD_TGL_TAGIH='',
            FS_KD_PETUGAS_TAGIH=''
            where kd_piutang=:NoTrs");
            $this->db->bind('NoTrs', $NoTrs);
            $this->db->execute();



            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'nilaipiutang' => $nilaipiutang, // Set array status dengan success 
                'nilaipiutang' => $nilaipiutang, // Set array status dengan success 
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error",
                'message' => $e,

            );
            return $callback;
        }
    }
    public function tagih($data)
    {
        try {
            $this->db->transaksi();

            $datenowcreate = Utils::seCurrentDateTime();
            $NoTrs = $data['NoTrs'];

            $tgltagih = $data['tgltagih'];
            $Periode =  $data['Periode'];
            $Periode2 = $data['Periode2'];
            $JenisPenjamin = $data['JenisPenjamin'];
            $NoSuratTagihan = $data['NoSuratTagihan'];
            $NominalTagihan = $data['NominalTagihan'];
            $kodejaminan = $data['kodejaminan'];
            $NoTagihan = $data['NoTagihan'];
            $Fs_Code_Jenis_Reg = $data['Fs_Code_Jenis_Reg'];
            $alamattagih = $data['alamattagih'];

            if ($NoTrs == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'KNo Transaksi Tagihan Invalid !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($NoSuratTagihan == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'KNo Surat Tagihan Invalid !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($tgltagih == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Tgl Tagihan Invalid !',
                );
                echo json_encode($callback);
                exit;
            }

            if ($Periode == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Tgl Periode 1 Invalid !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($Periode2 == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Tgl Periode 2 Invalid !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($JenisPenjamin == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Jenis Penjamin Invalid !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($kodejaminan == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode Jaminan Invalid !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($Fs_Code_Jenis_Reg == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Jenis Registrasi Invalid !',
                );
                echo json_encode($callback);
                exit;
            }
            // if ($alamattagih == "") {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => 'Alamat tagihan Invalid !',
            //     );
            //     echo json_encode($callback);
            //     exit;
            // }
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;

            $this->db->query("UPDATE Keuangan.dbo.PIUTANG_PASIEN set 
            FB_TAGIH='1', FS_KD_TAGIH=:NoTagihan,FS_SURAT=:NoSuratTagihan,
            FD_TGL_TAGIH=:tgltagih,
            FS_KD_PETUGAS_TAGIH=:namauserx
            where KD_PIUTANG=:NoTrs ");
            $this->db->bind('NoTrs', $NoTrs);
            $this->db->bind('namauserx', $namauserx);
            $this->db->bind('tgltagih', $tgltagih);
            $this->db->bind('NoSuratTagihan', $NoSuratTagihan);
            $this->db->bind('NoTagihan', $NoTagihan);
            $this->db->execute();


            $this->db->query("SELECT sum(fn_piutang) as nilaipiutang
            from Keuangan.dbo.PIUTANG_PASIEN
            where fs_kd_tagih=:NoTagihan");
            $this->db->bind('NoTagihan', $NoTagihan);
            // $this->db->execute();
            $datax =  $this->db->single();
            $nilaipiutang = $datax['nilaipiutang'];



            $this->db->query("UPDATE Keuangan.dbo.TA_ORDER_PIUTANG set Fb_selesai='1',
            FD_TGL_TRS=:tgltagih,FS_JENIS_CUSTOMER=:JenisPenjamin,
           FS_KD_CUSTOMER=:kodejaminan 
           ,fd_periode1=:Periode,fd_periode2=:Periode2
           ,FS_KET=:NoSuratTagihan,Fs_Code_Jenis_Reg=:Fs_Code_Jenis_Reg,
           FS_Alamat_Tagih=:alamattagih,FN_TOTAL_TAGIH=:nilaipiutang
           where FS_KD_TRS=:NoTagihan ");
            $this->db->bind('tgltagih', $tgltagih);
            $this->db->bind('JenisPenjamin', $JenisPenjamin);
            $this->db->bind('kodejaminan', $kodejaminan);
            $this->db->bind('Periode', $Periode);
            $this->db->bind('Periode2', $Periode2);
            $this->db->bind('NoSuratTagihan', $NoSuratTagihan);
            $this->db->bind('Fs_Code_Jenis_Reg', $Fs_Code_Jenis_Reg);
            $this->db->bind('alamattagih', $alamattagih);
            $this->db->bind('nilaipiutang', $nilaipiutang);
            $this->db->bind('NoTagihan', $NoTagihan);

            $this->db->execute();



            $this->db->commit();
            //var_dump($NominalTagihan, 'ddd');
            $callback = array(
                'status' => 'success',
                'NominalTagihan' => $nilaipiutang, // Set array status dengan success 
                'message' => 'berhasil', // Set array status dengan success 
                //'NominalTagihan' => $NominalTagihan, // Set array status dengan success 
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error",
                'message' => $e,

            );
            return $callback;
        }
    }
    public function synctransaction($data)
    {
        // try {
        //     $this->db->transaksi();
        $curl = curl_init();

        $noregistrasi = $data['noregistrasi'];
        $owlexa_cardnumber = $data['owlexa_cardnumber'];
        $owlexa_claimnumber = $data['owlexa_claimnumber'];
        $provideramount = $data['provideramount'];
        if ($noregistrasi == "") {
            $callback = array(
                'code' => '400',
                'message' => 'No. Registrasi Kosong, Silahkan Masukan No. Registrasi !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($owlexa_cardnumber == "") {
            $callback = array(
                'code' => '400',
                'message' => 'Nomor kartu peserta Owlexa Kosong, Silahkan Masukan Nomor kartu peserta Owlexa !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($owlexa_claimnumber == "") {
            $callback = array(
                'code' => '400',
                'message' => 'Nomor klaim Owlexa Kosong, Silahkan Masukan Nomor klaim Owlexa !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($provideramount == "") {
            $callback = array(
                'code' => '400',
                'message' => 'Nilai yang harus dibayarkan ke provider Kosong, Silahkan Masukan Nilai yang harus dibayarkan ke
                                  provider !',
            );
            echo json_encode($callback);
            exit;
        }
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://ws.owlexa.com/owlexa-api/invoice/v1/sync-transaction',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_SSL_VERIFYHOST => FALSE,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_SSLVERSION => 6,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                    "claimNumber" : "' . $owlexa_claimnumber . '",
                    "cardNumber": "' . $owlexa_cardnumber . '",
                    "paidToProviderAmount": "' . $provideramount . '",
                    "providerTransactionNumber": "' . $noregistrasi . '"
                }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'API-Key: V8N9T0Z+xMB5gHydcLaUsg=='
            ),
        ));
        $output = curl_exec($curl);
        // tutup curl 
        curl_close($curl);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['status'] == "200") {
            $callback = array(
                'status' => 'success',
                'data' => $JsonData,
            );
            return $callback;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['msg'],
            );
            return $callback;
        }
    }
    public function FinalGenerate($data)
    {
        try {
            $this->db->transaksi();

            $owlexa_kode_piutang = $data['owlexa_kode_piutang'];

            $owlexa_owlexaTransactionNumber = $data['owlexa_owlexaTransactionNumber'];




            $this->db->query("UPDATE  Keuangan.DBO.PIUTANG_PASIEN SET FS_NO_REFF_BRIDGING=:owlexa_owlexaTransactionNumber
            WHERE KD_PIUTANG=:owlexa_kode_piutang");
            $this->db->bind('owlexa_kode_piutang', $owlexa_kode_piutang);
            $this->db->bind('owlexa_owlexaTransactionNumber', $owlexa_owlexaTransactionNumber);

            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success',
                // 'message' => 'Registrasi berhasil Dihapus !'
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
    public function getShowSyncTransaction($data)
    {
        try {
            $this->db->transaksi();

            $owlexa_kode_piutang = $data['owlexa_kode_piutang'];
            // var_dump($owlexa_kode_piutang);
            // exit;



            if ($owlexa_kode_piutang == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode Piutang Invalid !',
                );
                echo json_encode($callback);
                exit;
            }


            $this->db->query("SELECT TipePiutang,FS_NO_REFF_BRIDGING,fn_piutang FROM Keuangan.DBO.PIUTANG_PASIEN
            WHERE KD_PIUTANG=:owlexa_kode_piutang");
            $this->db->bind('owlexa_kode_piutang', $owlexa_kode_piutang);
            // $this->db->execute();
            $datax =  $this->db->single();
            $TipePiutang = $datax['TipePiutang'];
            if ($TipePiutang == "RI") {
                $this->db->query("SELECT NoMR,NoRegRI as NoRegistrasi FROM RawatInapSQL.DBO.Inpatient WHERE NoRegRI collate SQL_Latin1_General_CP1_CI_AS in (
                          SELECT NO_TRANSAKSI collate SQL_Latin1_General_CP1_CI_AS FROM Keuangan.DBO.PIUTANG_PASIEN WHERE KD_PIUTANG=:owlexa_kode_piutang 
                          and TipePiutang='RI'
                          ) ");
            } else {
                $this->db->query("SELECT NoMR,NoRegistrasi FROM PerawatanSQL.DBO.Visit WHERE NoRegistrasi collate SQL_Latin1_General_CP1_CI_AS in (
                        SELECT NO_TRANSAKSI collate SQL_Latin1_General_CP1_CI_AS FROM Keuangan.DBO.PIUTANG_PASIEN WHERE KD_PIUTANG=:owlexa_kode_piutang 
                        and TipePiutang<>'RI'
                        )");
            }

            $this->db->bind('owlexa_kode_piutang', $owlexa_kode_piutang);
            $dataxx =  $this->db->single();
            $NoMR = $dataxx['NoMR'];
            $NoRegistrasi = $dataxx['NoRegistrasi'];


            $this->db->query("SELECT  b.NoKartu,a.fn_piutang,a.NO_TRANSAKSI,a.FS_NO_REFF_BRIDGING
            FROM Keuangan.DBO.PIUTANG_PASIEN a
            left join MasterdataSQL.DBO.Admision_Kartu_Jaminan b
            ON A.kode_jaminan = B.KodeJaminan
            WHERE KD_PIUTANG=:owlexa_kode_piutang  and b.KodeGroupJaminan='5' and b.NoMR=:NoMR");
            $this->db->bind('owlexa_kode_piutang', $owlexa_kode_piutang);
            $this->db->bind('NoMR', $NoMR);
            $dataxxx =  $this->db->single();
            $NoKartu = $dataxxx['NoKartu'];
            $fn_piutang = $dataxxx['fn_piutang'];
            $FS_NO_REFF_BRIDGING = $dataxxx['FS_NO_REFF_BRIDGING'];



            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'owlexa_kode_piutang' => $owlexa_kode_piutang, // Set array status dengan success 
                'NoKartu' => $NoKartu, // Set array status dengan success 
                'fn_piutang' => $fn_piutang, // Set array status dengan success 
                'NO_TRANSAKSI' => $NoRegistrasi, // Set array status dengan success 
                'FS_NO_REFF_BRIDGING' => $FS_NO_REFF_BRIDGING, // Set array status dengan success 
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error",
                'message' => $e,

            );
            return $callback;
        }
    }
    public function createOrderPiutang($data)
    {
        try {
            $this->db->transaksi();
            // var_dump($data);
            // exit;


            $tgltagih = $data['tgltagih'];
            $kodejaminan = $data['kodejaminan'];
            $JenisPenjamin = $data['JenisPenjamin'];
            $NominalTagihan = $data['NominalTagihan'];
            $Periode = $data['Periode'];
            $Periode2 = $data['Periode2'];
            $NoSuratTagihan = $data['NoSuratTagihan'];
            $Fs_Code_Jenis_Reg = $data['Fs_Code_Jenis_Reg'];
            $alamattagih = $data['alamattagih'];
            $NoTrsTagihan = $data['NoTrsTagihan'];



            // if ($TransasctionDate == "") {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => 'Tanggal Transaksi Kosong !',
            //     );
            //     return $callback;
            //     exit;
            // }
            // if ($Periode == "") {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => 'Periode Kosong !',
            //     );
            //     return $callback;
            //     exit;
            // }
            // if ($NamaSupplier == "") {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => 'Nama Supplier Kosong !',
            //     );
            //     return $callback;
            //     exit;
            // }
            // if ($TotalHutang == "") {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => 'Total Transaksi Kosong !',
            //     );
            //     return $callback;
            //     exit;
            // }

            $this->db->query("UPDATE Keuangan.dbo.TA_ORDER_PIUTANG set Fb_selesai='1',
                FD_TGL_TRS=:tgltagih,FS_JENIS_CUSTOMER=:JenisPenjamin,
               FS_KD_CUSTOMER=:kodejaminan,FN_TOTAL_TAGIH=:NominalTagihan
         ,fd_periode1=:Periode,fd_periode2=:Periode2
         ,FS_KET=:NoSuratTagihan,Fs_Code_Jenis_Reg=:Fs_Code_Jenis_Reg,
         FS_Alamat_Tagih=:alamattagih
               where FS_KD_TRS=:NoTrsTagihan");
            $this->db->bind('tgltagih', $tgltagih);
            $this->db->bind('JenisPenjamin', $JenisPenjamin);
            $this->db->bind('kodejaminan', $kodejaminan);
            $this->db->bind('NominalTagihan', $NominalTagihan);
            $this->db->bind('Periode', $Periode);
            $this->db->bind('Periode2', $Periode2);
            $this->db->bind('NoSuratTagihan', $NoSuratTagihan);
            $this->db->bind('Fs_Code_Jenis_Reg', $Fs_Code_Jenis_Reg);
            $this->db->bind('NoTrsTagihan', $NoTrsTagihan);
            $this->db->bind('alamattagih', $alamattagih);

            $this->db->execute();


            $this->db->commit();
            $callback = array(
                'status' => 'success',
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e,

            );
            return $callback;
        }
    }

    public function loadInforekap($data)
    {
        try {

            $TglAwal = $data['TglAwal'];
            $TglAkhir = $data['TglAkhir'];
            $optJenisInfo = $data['optJenisInfo'];
            // var_dump($TglAwal, $TglAkhir, $optJenisInfo);
            // exit;
            if ($optJenisInfo  == "1") {
                $this->db->query("SELECT a.id,a.FS_KD_TRS,a.KD_TRS_ORDER,b.FS_KET as No_Tagihan,a.GROUP_JAMINAN,c.NamaPerusahaan,
                            a.JENIS_REG,
                            CASE WHEN a.JENIS_REG = 'RJ' THEN 'RAWAT JALAN' WHEN  a.JENIS_REG = 'RI' THEN 'RAWAT INAP'
                             WHEN  a.JENIS_REG = 'SA' THEN 'SALDO AWAL'  ELSE '' END as JenisRegName
                            ,replace(CONVERT(VARCHAR(11),a.FD_TGL_TRS, 111), '/','-') as FD_TGL_TRS,isnull(a.FS_KET,'-') FS_KET,
                            a.FN_LUNAS,a.FN_MATERAI,a.FN_BIAYA_LAIN,a.FN_DISKON_LAIN,a.FN_TOTAL_LUNAS,a.FS_REKENING,d.FS_NM_REKENING as RekeningPelunasan,
                            a.FS_REKENING_JAMINAN,e.FS_NM_REKENING as RekeningJaminan,f.[First Name] as PetugasCreate
                            FROM Keuangan.dbo.TA_PTG_LUNAS_HDR a
                            inner join Keuangan.dbo.TA_ORDER_PIUTANG b
                            on a.KD_TRS_ORDER = b.FS_KD_TRS
                            inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.FS_KD_JAMINAN
                            inner join Keuangan.dbo.TM_REKENING d on d.FS_KD_REKENING = a.FS_REKENING
                            inner join Keuangan.dbo.TM_REKENING e on e.FS_KD_REKENING = a.FS_REKENING_JAMINAN
                            inner join MasterdataSQL.dbo.Employees f on f.NoPIN collate SQL_Latin1_General_CP1_CI_AS = a.FS_KD_PETUGAS collate SQL_Latin1_General_CP1_CI_AS
                            where a.FS_KD_PETUGAS_VOID is null  
                            AND replace(CONVERT(VARCHAR(11),a.FD_TGL_TRS, 111), '/','-') BETWEEN :TglAwal AND :TglAkhir
                            and a.GROUP_JAMINAN='Asuransi' and a.FN_TOTAL_LUNAS<>'0'
                            order by JENIS_REG asc, GROUP_JAMINAN asc,NamaPerusahaan asc,replace(CONVERT(VARCHAR(11),a.FD_TGL_TRS, 111), '/','-') desc");
                $this->db->bind('TglAwal', $TglAwal);
                $this->db->bind('TglAkhir', $TglAkhir);
            } elseif ($optJenisInfo  == "2") {
                $this->db->query("SELECT a.id,a.FS_KD_TRS,a.KD_TRS_ORDER,b.FS_KET as No_Tagihan,a.GROUP_JAMINAN,c.NamaPerusahaan,
                            a.JENIS_REG,
                           CASE WHEN a.JENIS_REG = 'RJ' THEN 'RAWAT JALAN' WHEN  a.JENIS_REG = 'RI' THEN 'RAWAT INAP'
                             WHEN  a.JENIS_REG = 'SA' THEN 'SALDO AWAL'  ELSE '' END as JenisRegName
                            ,replace(CONVERT(VARCHAR(11),a.FD_TGL_TRS, 111), '/','-') as FD_TGL_TRS,isnull(a.FS_KET,'-') FS_KET,
                            a.FN_LUNAS,a.FN_MATERAI,a.FN_BIAYA_LAIN,a.FN_DISKON_LAIN,a.FN_TOTAL_LUNAS,a.FS_REKENING,d.FS_NM_REKENING as RekeningPelunasan,
                            a.FS_REKENING_JAMINAN,e.FS_NM_REKENING as RekeningJaminan,f.[First Name] as PetugasCreate
                            FROM Keuangan.dbo.TA_PTG_LUNAS_HDR a
                            inner join Keuangan.dbo.TA_ORDER_PIUTANG b
                            on a.KD_TRS_ORDER = b.FS_KD_TRS
                            inner join MasterdataSQL.dbo.MstrPerusahaanJPK c on c.ID = a.FS_KD_JAMINAN
                            inner join Keuangan.dbo.TM_REKENING d on d.FS_KD_REKENING = a.FS_REKENING
                            inner join Keuangan.dbo.TM_REKENING e on e.FS_KD_REKENING = a.FS_REKENING_JAMINAN
                            inner join MasterdataSQL.dbo.Employees f on f.NoPIN collate SQL_Latin1_General_CP1_CI_AS = a.FS_KD_PETUGAS collate SQL_Latin1_General_CP1_CI_AS
                            where a.FS_KD_PETUGAS_VOID is null  
                            AND replace(CONVERT(VARCHAR(11),a.FD_TGL_TRS, 111), '/','-') BETWEEN :TglAwal AND :TglAkhir
                            and a.GROUP_JAMINAN='Perusahaan' and a.FN_TOTAL_LUNAS<>'0'
                            order by JENIS_REG asc, GROUP_JAMINAN asc,NamaPerusahaan asc,replace(CONVERT(VARCHAR(11),a.FD_TGL_TRS, 111), '/','-') desc");
                $this->db->bind('TglAwal', $TglAwal);
                $this->db->bind('TglAkhir', $TglAkhir);
            } elseif ($optJenisInfo  == "3") {
                $this->db->query("SELECT a.id,a.FS_KD_TRS,a.KD_TRS_ORDER,b.FS_KET as No_Tagihan,a.GROUP_JAMINAN,c.NamaPerusahaan,
                            a.JENIS_REG,
                            CASE WHEN a.JENIS_REG = 'RJ' THEN 'RAWAT JALAN' WHEN  a.JENIS_REG = 'RI' THEN 'RAWAT INAP'
                             WHEN  a.JENIS_REG = 'SA' THEN 'SALDO AWAL'  ELSE '' END as JenisRegName
                            ,replace(CONVERT(VARCHAR(11),a.FD_TGL_TRS, 111), '/','-') as FD_TGL_TRS,isnull(a.FS_KET,'-') FS_KET,
                            a.FN_LUNAS,a.FN_MATERAI,a.FN_BIAYA_LAIN,a.FN_DISKON_LAIN,a.FN_TOTAL_LUNAS,a.FS_REKENING,d.FS_NM_REKENING as RekeningPelunasan,
                            a.FS_REKENING_JAMINAN,e.FS_NM_REKENING as RekeningJaminan,f.[First Name] as PetugasCreate
                            FROM Keuangan.dbo.TA_PTG_LUNAS_HDR a
                            inner join Keuangan.dbo.TA_ORDER_PIUTANG b
                            on a.KD_TRS_ORDER = b.FS_KD_TRS
                            inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi c on c.ID = a.FS_KD_JAMINAN
                            inner join Keuangan.dbo.TM_REKENING d on d.FS_KD_REKENING = a.FS_REKENING
                            inner join Keuangan.dbo.TM_REKENING e on e.FS_KD_REKENING = a.FS_REKENING_JAMINAN
                            inner join MasterdataSQL.dbo.Employees f on f.NoPIN collate SQL_Latin1_General_CP1_CI_AS = a.FS_KD_PETUGAS collate SQL_Latin1_General_CP1_CI_AS
                            where a.FS_KD_PETUGAS_VOID is null  
                            AND replace(CONVERT(VARCHAR(11),a.FD_TGL_TRS, 111), '/','-') BETWEEN :TglAwal AND :TglAkhir
                            and a.GROUP_JAMINAN='Asuransi' and a.FN_TOTAL_LUNAS<>'0'
                            UNION
                            SELECT a.id,a.FS_KD_TRS,a.KD_TRS_ORDER,b.FS_KET as No_Tagihan,a.GROUP_JAMINAN,c.NamaPerusahaan,
                            a.JENIS_REG,
                            CASE WHEN a.JENIS_REG = 'RJ' THEN 'RAWAT JALAN' WHEN  a.JENIS_REG = 'RI' THEN 'RAWAT INAP'
                             WHEN  a.JENIS_REG = 'SA' THEN 'SALDO AWAL'  ELSE '' END as JenisRegName
                            ,replace(CONVERT(VARCHAR(11),a.FD_TGL_TRS, 111), '/','-') as FD_TGL_TRS,isnull(a.FS_KET,'-') FS_KET,
                            a.FN_LUNAS,a.FN_MATERAI,a.FN_BIAYA_LAIN,a.FN_DISKON_LAIN,a.FN_TOTAL_LUNAS,a.FS_REKENING,d.FS_NM_REKENING as RekeningPelunasan,
                            a.FS_REKENING_JAMINAN,e.FS_NM_REKENING as RekeningJaminan,f.[First Name] as PetugasCreate
                            FROM Keuangan.dbo.TA_PTG_LUNAS_HDR a
                            inner join Keuangan.dbo.TA_ORDER_PIUTANG b
                            on a.KD_TRS_ORDER = b.FS_KD_TRS
                            inner join MasterdataSQL.dbo.MstrPerusahaanJPK c on c.ID = a.FS_KD_JAMINAN
                            inner join Keuangan.dbo.TM_REKENING d on d.FS_KD_REKENING = a.FS_REKENING
                            inner join Keuangan.dbo.TM_REKENING e on e.FS_KD_REKENING = a.FS_REKENING_JAMINAN
                            inner join MasterdataSQL.dbo.Employees f on f.NoPIN collate SQL_Latin1_General_CP1_CI_AS = a.FS_KD_PETUGAS collate SQL_Latin1_General_CP1_CI_AS
                            where a.FS_KD_PETUGAS_VOID is null  
                            AND replace(CONVERT(VARCHAR(11),a.FD_TGL_TRS, 111), '/','-') BETWEEN :TglAwal2 AND :TglAkhir2
                            and a.GROUP_JAMINAN='Perusahaan' and a.FN_TOTAL_LUNAS<>'0'
                            order by JENIS_REG asc, GROUP_JAMINAN asc,NamaPerusahaan asc,replace(CONVERT(VARCHAR(11),a.FD_TGL_TRS, 111), '/','-') desc");
                $this->db->bind('TglAwal', $TglAwal);
                $this->db->bind('TglAkhir', $TglAkhir);
                $this->db->bind('TglAwal2', $TglAwal);
                $this->db->bind('TglAkhir2', $TglAkhir);
            }

            $data =  $this->db->resultSet();

            $rows = array();
            foreach ($data as $row) {

                $pasing['id'] = $row['id'];
                $pasing['FS_KD_TRS'] = $row['FS_KD_TRS'];
                $pasing['KD_TRS_ORDER'] = $row['KD_TRS_ORDER'];
                $pasing['No_Tagihan'] = $row['No_Tagihan'];
                $pasing['GROUP_JAMINAN'] = $row['GROUP_JAMINAN'];
                $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                $pasing['JENIS_REG'] = $row['JENIS_REG'];
                $pasing['JenisRegName'] = $row['JenisRegName'];

                $pasing['FD_TGL_TRS'] = $row['FD_TGL_TRS'];
                $pasing['FS_KET'] = $row['FS_KET'];
                $pasing['FN_LUNAS'] = $row['FN_LUNAS'];
                $pasing['FN_MATERAI'] = $row['FN_MATERAI'];
                $pasing['FN_BIAYA_LAIN'] = $row['FN_BIAYA_LAIN'];
                $pasing['FN_DISKON_LAIN'] = $row['FN_DISKON_LAIN'];
                $pasing['FN_TOTAL_LUNAS'] = $row['FN_TOTAL_LUNAS'];
                $pasing['FS_REKENING'] = $row['FS_REKENING'];
                $pasing['RekeningPelunasan'] = $row['RekeningPelunasan'];
                $pasing['FS_REKENING_JAMINAN'] = $row['FS_REKENING_JAMINAN'];
                $pasing['RekeningJaminan'] = $row['RekeningJaminan'];
                $pasing['PetugasCreate'] = $row['PetugasCreate'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getInfoAging($data)
    {
        try {

            $TglAwal = $data['TglAwal'];
            $TglAkhir = $data['TglAkhir'];
            // var_dump($TglAwal, $TglAkhir, $optJenisInfo);
            // exit;
            $this->db->query("SELECT FS_KD_CUSTOMER, NamaPerusahaan,
            isnull([0_TO_45_HARI],0) noltoempatlima,
            isnull([45_TO_60_HARI],0) empatlimatoenampuluh,
            isnull([60_TO_90_HARI],0) enampuluhtosembilanpuluh,
            isnull([90_TO_120_HARI],0) sembilanpuluhtoseratusduapuluh, 
            isnull([120_HARI_LEBIH],0) lebihseratuduapuluhhari
            FROM (
            SELECT FS_KD_CUSTOMER,b.NamaPerusahaan,
            CASE
            WHEN DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) > 0 and DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) <=45  THEN '0_TO_45_HARI'
            WHEN DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) >=45 AND DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) <=60 THEN '45_TO_60_HARI'
            WHEN DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) >=60 AND DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) <=90 THEN '60_TO_90_HARI'
            WHEN DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) >=90 AND DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) <=120 THEN '90_TO_120_HARI' 
            WHEN DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) >120 THEN '120_HARI_LEBIH'
            END AS [Quarter],SUM(C.fn_sisa) [REGISTRASI Count]
            FROM Keuangan.DBO.TA_ORDER_PIUTANG A
            inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi b
            on a.FS_KD_CUSTOMER = b.ID
            INNER JOIN Keuangan.DBO.PIUTANG_PASIEN C ON C.FS_KD_TAGIH = A.FS_KD_TRS
            WHERE FS_KD_PETUGAS_VOID is null and Fb_selesai='1'
            and FS_JENIS_CUSTOMER='Asuransi' and Fd_Tgl_Diterima is not null
            and Fd_Tgl_Diterima <>'1900-01-01 00:00:00.000'
            and replace(CONVERT(VARCHAR(11), c.fd_tgL_piutang, 111), '/','-') between :TglAwal and :TglAkhir
            and C.fn_sisa >0
            GROUP BY FS_KD_CUSTOMER,b.NamaPerusahaan, DATEDIFF(d, Fd_Tgl_Diterima,GETDATE())
            UNION ALL
			SELECT FS_KD_CUSTOMER,b.NamaPerusahaan,
            CASE
            WHEN DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) > 0 and DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) <=45  THEN '0_TO_45_HARI'
            WHEN DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) >=45 AND DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) <=60 THEN '45_TO_60_HARI'
            WHEN DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) >=60 AND DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) <=90 THEN '60_TO_90_HARI'
            WHEN DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) >=90 AND DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) <=120 THEN '90_TO_120_HARI' 
            WHEN DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) >120 THEN '120_HARI_LEBIH'
            END AS [Quarter],SUM(C.fn_sisa) [REGISTRASI Count]
            FROM Keuangan.DBO.TA_ORDER_PIUTANG A
            inner join MasterdataSQL.dbo.MstrPerusahaanJPK b
            on a.FS_KD_CUSTOMER = b.ID
            INNER JOIN Keuangan.DBO.PIUTANG_PASIEN C ON C.FS_KD_TAGIH = A.FS_KD_TRS
            WHERE FS_KD_PETUGAS_VOID is null and Fb_selesai='1'
            and FS_JENIS_CUSTOMER<>'Asuransi' and Fd_Tgl_Diterima is not null
            and Fd_Tgl_Diterima <>'1900-01-01 00:00:00.000'
            and replace(CONVERT(VARCHAR(11), c.fd_tgL_piutang, 111), '/','-') between :TglAwal2 and :TglAkhir2
            and C.fn_sisa >0
            GROUP BY FS_KD_CUSTOMER,b.NamaPerusahaan, DATEDIFF(d, Fd_Tgl_Diterima,GETDATE())
            ) AS QuarterlyData
            PIVOT( SUM([REGISTRASI Count])
            FOR Quarter IN ([0_TO_45_HARI],
            [45_TO_60_HARI],[60_TO_90_HARI],[90_TO_120_HARI],[120_HARI_LEBIH])) AS QPivot
            order by NamaPerusahaan asc");
            $this->db->bind('TglAwal', $TglAwal);
            $this->db->bind('TglAkhir', $TglAkhir);
            $this->db->bind('TglAwal2', $TglAwal);
            $this->db->bind('TglAkhir2', $TglAkhir);
            $data =  $this->db->resultSet();

            $rows = array();
            $no = 1;

            foreach ($data as $row) {
                $pasing['no'] = $no++;
                $pasing['FS_KD_CUSTOMER'] = $row['FS_KD_CUSTOMER'];
                $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                $pasing['noltoempatlima'] = $row['noltoempatlima'];
                $pasing['empatlimatoenampuluh'] = $row['empatlimatoenampuluh'];
                $pasing['enampuluhtosembilanpuluh'] = $row['enampuluhtosembilanpuluh'];
                $pasing['sembilanpuluhtoseratusduapuluh'] = $row['sembilanpuluhtoseratusduapuluh']; 
                $pasing['lebihseratuduapuluhhari'] = $row['lebihseratuduapuluhhari'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getInfoAging1($data)
    {
        try {

            $TglAwal = $data['TglAwal'];
            $TglAkhir = $data['TglAkhir'];
            // var_dump($TglAwal, $TglAkhir, $optJenisInfo);
            // exit;
            $this->db->query("SELECT FS_KD_CUSTOMER, NamaPerusahaan,
            isnull([0_TO_45_HARI],0) noltoempatlima,
            isnull([45_TO_60_HARI],0) empatlimatoenampuluh,
            isnull([60_TO_90_HARI],0) enampuluhtosembilanpuluh,
            isnull([90_TO_120_HARI],0) sembilanpuluhtoseratusduapuluh, 
            isnull([120_HARI_LEBIH],0) lebihseratuduapuluhhari
            FROM (
            SELECT FS_KD_CUSTOMER,b.NamaPerusahaan,
            CASE
            WHEN DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) > 0 and DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) <=45  THEN '0_TO_45_HARI'
            WHEN DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) >=45 AND DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) <=60 THEN '45_TO_60_HARI'
            WHEN DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) >=60 AND DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) <=90 THEN '60_TO_90_HARI'
            WHEN DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) >=90 AND DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) <=120 THEN '90_TO_120_HARI' 
            WHEN DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) >120 THEN '120_HARI_LEBIH'
            END AS [Quarter],SUM(C.fn_sisa) [REGISTRASI Count]
            FROM Keuangan.DBO.TA_ORDER_PIUTANG A
            inner join MasterdataSQL.dbo.MstrPerusahaanAsuransi b
            on a.FS_KD_CUSTOMER = b.ID
            INNER JOIN Keuangan.DBO.PIUTANG_PASIEN C ON C.FS_KD_TAGIH = A.FS_KD_TRS
            WHERE FS_KD_PETUGAS_VOID is null and Fb_selesai='1'
            and FS_JENIS_CUSTOMER='Asuransi' and Fd_Tgl_Diterima is not null
            and Fd_Tgl_Diterima <>'1900-01-01 00:00:00.000'
            and replace(CONVERT(VARCHAR(11), c.fd_tgL_piutang, 111), '/','-') between :TglAwal and :TglAkhir
            and C.fn_sisa >0
            GROUP BY FS_KD_CUSTOMER,b.NamaPerusahaan, DATEDIFF(d, Fd_Tgl_Diterima,GETDATE())
            UNION ALL
			SELECT FS_KD_CUSTOMER,b.NamaPerusahaan,
            CASE
            WHEN DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) > 0 and DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) <=45  THEN '0_TO_45_HARI'
            WHEN DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) >=45 AND DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) <=60 THEN '45_TO_60_HARI'
            WHEN DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) >=60 AND DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) <=90 THEN '60_TO_90_HARI'
            WHEN DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) >=90 AND DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) <=120 THEN '90_TO_120_HARI' 
            WHEN DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) >120 THEN '120_HARI_LEBIH'
            END AS [Quarter],SUM(C.fn_sisa) [REGISTRASI Count]
            FROM Keuangan.DBO.TA_ORDER_PIUTANG A
            inner join MasterdataSQL.dbo.MstrPerusahaanJPK b
            on a.FS_KD_CUSTOMER = b.ID
            INNER JOIN Keuangan.DBO.PIUTANG_PASIEN C ON C.FS_KD_TAGIH = A.FS_KD_TRS
            WHERE FS_KD_PETUGAS_VOID is null and Fb_selesai='1'
            and FS_JENIS_CUSTOMER<>'Asuransi' and Fd_Tgl_Diterima is not null
            and Fd_Tgl_Diterima <>'1900-01-01 00:00:00.000'
            and replace(CONVERT(VARCHAR(11), c.fd_tgL_piutang, 111), '/','-') between :TglAwal2 and :TglAkhir2
            and C.fn_sisa >0
            GROUP BY FS_KD_CUSTOMER,b.NamaPerusahaan, DATEDIFF(d, Fd_Tgl_Diterima,GETDATE())
            ) AS QuarterlyData
            PIVOT( SUM([REGISTRASI Count])
            FOR Quarter IN ([0_TO_45_HARI],
            [45_TO_60_HARI],[60_TO_90_HARI],[90_TO_120_HARI],[120_HARI_LEBIH])) AS QPivot
            order by NamaPerusahaan asc");
            $this->db->bind('TglAwal', $TglAwal);
            $this->db->bind('TglAkhir', $TglAkhir);
            $this->db->bind('TglAwal2', $TglAwal);
            $this->db->bind('TglAkhir2', $TglAkhir);
            $data =  $this->db->resultSet();

            $rows = array();
            $no = 1;

            foreach ($data as $row) {
                $pasing['no'] = $no++;
                $pasing['FS_KD_CUSTOMER'] = $row['FS_KD_CUSTOMER'];
                $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                $pasing['noltoempatlima'] = $row['noltoempatlima'];
                $pasing['empatlimatoenampuluh'] = $row['empatlimatoenampuluh'];
                $pasing['enampuluhtosembilanpuluh'] = $row['enampuluhtosembilanpuluh'];
                $pasing['sembilanpuluhtoseratusduapuluh'] = $row['sembilanpuluhtoseratusduapuluh']; 
                $pasing['lebihseratuduapuluhhari'] = $row['lebihseratuduapuluhhari'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getInfoMonitoring($data)
    {
        try {

            $TglAwal = $data['TglAwal'];
            $TglAkhir = $data['TglAkhir'];
            $JenisJaminan = $data['JenisJaminan'];
            // var_dump($TglAwal, $TglAkhir, $JenisJaminan);
            // exit;
            if ($JenisJaminan  == "0") {
                $this->db->query("SELECT A.FS_KD_TRS,C.fd_tgL_piutang as FD_TGL_TRS,A.FS_JENIS_CUSTOMER,A.FS_KD_CUSTOMER,b.NamaPerusahaan,A.FS_KET,
            A.FN_TOTAL_TAGIH,A.fd_periode1,A.fd_periode2,CASE WHEN A.Fs_Code_Jenis_Reg = 'RJ' THEN 'RAWAT JALAN' WHEN  A.Fs_Code_Jenis_Reg = 'RI' THEN 'RAWAT INAP' end as Fs_Code_Jenis_Reg,
            replace(CONVERT(VARCHAR(11), A.FD_TGL_INPUT, 111), '/','-') as FD_TGL_INPUT,
            replace(CONVERT(VARCHAR(11), A.Fd_Tgl_Dikirim, 111), '/','-') as Fd_Tgl_Dikirim,
            replace(CONVERT(VARCHAR(11),A.Fd_Tgl_Diterima, 111), '/','-') as Fd_Tgl_Diterima
            FROM Keuangan.DBO.TA_ORDER_PIUTANG a
            INNER JOIN MasterdataSQL.DBO.MstrPerusahaanAsuransi B
            ON A.FS_KD_CUSTOMER = B.ID
            inner join Keuangan.dbo.PIUTANG_PASIEN C
			ON C.FS_KD_TAGIH = a.FS_KD_TRS
            WHERE FD_TGL_VOID='3000-01-01 00:00:00.000'
            and replace(CONVERT(VARCHAR(11), A.FD_TGL_INPUT, 111), '/','-') between :TglAwal and :TglAkhir
            and A.Fd_Tgl_Diterima='3000-01-01 00:00:00.000'
            and A.FS_JENIS_CUSTOMER='Asuransi'");
                $this->db->bind('TglAwal', $TglAwal);
                $this->db->bind('TglAkhir', $TglAkhir);
            } elseif ($JenisJaminan  == "1") {
                $this->db->query("  SELECT A.FS_KD_TRS,C.fd_tgL_piutang as FD_TGL_TRS,A.FS_JENIS_CUSTOMER,A.FS_KD_CUSTOMER,b.NamaPerusahaan,A.FS_KET,
            A.FN_TOTAL_TAGIH,A.fd_periode1,A.fd_periode2,CASE WHEN A.Fs_Code_Jenis_Reg = 'RJ' THEN 'RAWAT JALAN' WHEN  A.Fs_Code_Jenis_Reg = 'RI' THEN 'RAWAT INAP' end as Fs_Code_Jenis_Reg,
            replace(CONVERT(VARCHAR(11), A.FD_TGL_INPUT, 111), '/','-') as FD_TGL_INPUT,
            replace(CONVERT(VARCHAR(11), A.Fd_Tgl_Dikirim, 111), '/','-') as Fd_Tgl_Dikirim,
            replace(CONVERT(VARCHAR(11),A.Fd_Tgl_Diterima, 111), '/','-') as Fd_Tgl_Diterima
            FROM Keuangan.DBO.TA_ORDER_PIUTANG a
            INNER JOIN MasterdataSQL.DBO.MstrPerusahaanJPK B
            ON A.FS_KD_CUSTOMER = B.ID
            inner join Keuangan.dbo.PIUTANG_PASIEN C
			ON C.FS_KD_TAGIH = a.FS_KD_TRS
            WHERE FD_TGL_VOID='3000-01-01 00:00:00.000'
            and replace(CONVERT(VARCHAR(11), A.FD_TGL_INPUT, 111), '/','-') between :TglAwal and :TglAkhir
            and A.Fd_Tgl_Diterima='3000-01-01 00:00:00.000'
            and A.FS_JENIS_CUSTOMER='Perusahaan'");

                $this->db->bind('TglAwal', $TglAwal);
                $this->db->bind('TglAkhir', $TglAkhir);
            } elseif ($JenisJaminan  == "2") {
                $this->db->query("SELECT A.FS_KD_TRS,C.fd_tgL_piutang as FD_TGL_TRS,A.FS_JENIS_CUSTOMER,A.FS_KD_CUSTOMER,b.NamaPerusahaan,A.FS_KET,
            A.FN_TOTAL_TAGIH,A.fd_periode1,A.fd_periode2,CASE WHEN A.Fs_Code_Jenis_Reg = 'RJ' THEN 'RAWAT JALAN' WHEN  A.Fs_Code_Jenis_Reg = 'RI' THEN 'RAWAT INAP' end as Fs_Code_Jenis_Reg,
            replace(CONVERT(VARCHAR(11), A.FD_TGL_INPUT, 111), '/','-') as FD_TGL_INPUT,
            replace(CONVERT(VARCHAR(11), A.Fd_Tgl_Dikirim, 111), '/','-') as Fd_Tgl_Dikirim,
            replace(CONVERT(VARCHAR(11),A.Fd_Tgl_Diterima, 111), '/','-') as Fd_Tgl_Diterima
            FROM Keuangan.DBO.TA_ORDER_PIUTANG a
            INNER JOIN MasterdataSQL.DBO.MstrPerusahaanAsuransi B
            ON A.FS_KD_CUSTOMER = B.ID
            inner join Keuangan.dbo.PIUTANG_PASIEN C
			ON C.FS_KD_TAGIH = a.FS_KD_TRS
            WHERE FD_TGL_VOID='3000-01-01 00:00:00.000'
            and replace(CONVERT(VARCHAR(11), A.FD_TGL_INPUT, 111), '/','-') between :TglAwal and :TglAkhir
            and A.Fd_Tgl_Diterima='3000-01-01 00:00:00.000'
            and A.FS_JENIS_CUSTOMER='Asuransi'
            UNION ALL
            SELECT A.FS_KD_TRS,C.fd_tgL_piutang as FD_TGL_TRS,A.FS_JENIS_CUSTOMER,A.FS_KD_CUSTOMER,b.NamaPerusahaan,A.FS_KET,
            A.FN_TOTAL_TAGIH,A.fd_periode1,A.fd_periode2,CASE WHEN A.Fs_Code_Jenis_Reg = 'RJ' THEN 'RAWAT JALAN' WHEN  A.Fs_Code_Jenis_Reg = 'RI' THEN 'RAWAT INAP' end as Fs_Code_Jenis_Reg,
            replace(CONVERT(VARCHAR(11), A.FD_TGL_INPUT, 111), '/','-') as FD_TGL_INPUT,
            replace(CONVERT(VARCHAR(11), A.Fd_Tgl_Dikirim, 111), '/','-') as Fd_Tgl_Dikirim,
            replace(CONVERT(VARCHAR(11),A.Fd_Tgl_Diterima, 111), '/','-') as Fd_Tgl_Diterima
            FROM Keuangan.DBO.TA_ORDER_PIUTANG a
            INNER JOIN MasterdataSQL.DBO.MstrPerusahaanJPK B
            ON A.FS_KD_CUSTOMER = B.ID
            inner join Keuangan.dbo.PIUTANG_PASIEN C
			ON C.FS_KD_TAGIH = a.FS_KD_TRS
            WHERE FD_TGL_VOID='3000-01-01 00:00:00.000'
            and replace(CONVERT(VARCHAR(11), A.FD_TGL_INPUT, 111), '/','-') between :TglAwal1 and :TglAkhir1
            and A.Fd_Tgl_Diterima='3000-01-01 00:00:00.000'
            and A.FS_JENIS_CUSTOMER='Perusahaan'");
                $this->db->bind('TglAwal', $TglAwal);
                $this->db->bind('TglAwal1', $TglAwal);

                $this->db->bind('TglAkhir', $TglAkhir);
                $this->db->bind('TglAkhir1', $TglAkhir);
            }
            $data =  $this->db->resultSet();

            $rows = array();
            $no = 1;

            foreach ($data as $row) {
                $pasing['no'] = $no++;
                $pasing['FS_KD_TRS'] = $row['FS_KD_TRS'];
                $pasing['FD_TGL_TRS'] = $row['FD_TGL_TRS'];
                $pasing['FS_JENIS_CUSTOMER'] = $row['FS_JENIS_CUSTOMER'];
                $pasing['FS_KD_CUSTOMER'] = $row['FS_KD_CUSTOMER'];
                $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                $pasing['FS_KET'] = $row['FS_KET'];
                $pasing['FN_TOTAL_TAGIH'] = $row['FN_TOTAL_TAGIH'];
                $pasing['FD_TGL_INPUT'] = $row['FD_TGL_INPUT'];

                $pasing['fd_periode1'] = $row['fd_periode1'];
                $pasing['fd_periode2'] = $row['fd_periode2'];
                $pasing['Fs_Code_Jenis_Reg'] = $row['Fs_Code_Jenis_Reg'];
                $pasing['Fd_Tgl_Dikirim'] = $row['Fd_Tgl_Dikirim'];
                $pasing['Fd_Tgl_Diterima'] = $row['Fd_Tgl_Diterima'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getInfoMonitoring1($data)
    {
        try {

            $TglAwal = $data['TglAwal'];
            $TglAkhir = $data['TglAkhir'];
            $JenisJaminan = $data['JenisJaminan'];
            // var_dump($TglAwal, $TglAkhir, $JenisJaminan);
            // exit;
            if ($JenisJaminan  == "0") {
                $this->db->query("SELECT A.FS_KD_TRS,C.fd_tgL_piutang as FD_TGL_TRS,A.FS_JENIS_CUSTOMER,A.FS_KD_CUSTOMER,b.NamaPerusahaan,A.FS_KET,
            A.FN_TOTAL_TAGIH,A.fd_periode1,A.fd_periode2,CASE WHEN A.Fs_Code_Jenis_Reg = 'RJ' THEN 'RAWAT JALAN' WHEN  A.Fs_Code_Jenis_Reg = 'RI' THEN 'RAWAT INAP' end as Fs_Code_Jenis_Reg,
            replace(CONVERT(VARCHAR(11), A.FD_TGL_INPUT, 111), '/','-') as FD_TGL_INPUT,
            replace(CONVERT(VARCHAR(11), A.Fd_Tgl_Dikirim, 111), '/','-') as Fd_Tgl_Dikirim,
            replace(CONVERT(VARCHAR(11),A.Fd_Tgl_Diterima, 111), '/','-') as Fd_Tgl_Diterima
            FROM Keuangan.DBO.TA_ORDER_PIUTANG a
            INNER JOIN MasterdataSQL.DBO.MstrPerusahaanAsuransi B
            ON A.FS_KD_CUSTOMER = B.ID
            inner join Keuangan.dbo.PIUTANG_PASIEN C
			ON C.FS_KD_TAGIH = a.FS_KD_TRS
            WHERE FD_TGL_VOID='3000-01-01 00:00:00.000'
            and replace(CONVERT(VARCHAR(11), c.fd_tgL_piutang, 111), '/','-') between :TglAwal and :TglAkhir
            and A.Fd_Tgl_Diterima='3000-01-01 00:00:00.000'
            and A.FS_JENIS_CUSTOMER='Asuransi'");
                $this->db->bind('TglAwal', $TglAwal);
                $this->db->bind('TglAkhir', $TglAkhir);
            } elseif ($JenisJaminan  == "1") {
                $this->db->query("  SELECT A.FS_KD_TRS,C.fd_tgL_piutang as FD_TGL_TRS,A.FS_JENIS_CUSTOMER,A.FS_KD_CUSTOMER,b.NamaPerusahaan,A.FS_KET,
            A.FN_TOTAL_TAGIH,A.fd_periode1,A.fd_periode2,CASE WHEN A.Fs_Code_Jenis_Reg = 'RJ' THEN 'RAWAT JALAN' WHEN  A.Fs_Code_Jenis_Reg = 'RI' THEN 'RAWAT INAP' end as Fs_Code_Jenis_Reg,
            replace(CONVERT(VARCHAR(11), A.FD_TGL_INPUT, 111), '/','-') as FD_TGL_INPUT,
            replace(CONVERT(VARCHAR(11), A.Fd_Tgl_Dikirim, 111), '/','-') as Fd_Tgl_Dikirim,
            replace(CONVERT(VARCHAR(11),A.Fd_Tgl_Diterima, 111), '/','-') as Fd_Tgl_Diterima
            FROM Keuangan.DBO.TA_ORDER_PIUTANG a
            INNER JOIN MasterdataSQL.DBO.MstrPerusahaanJPK B
            ON A.FS_KD_CUSTOMER = B.ID
            inner join Keuangan.dbo.PIUTANG_PASIEN C
			ON C.FS_KD_TAGIH = a.FS_KD_TRS
            WHERE FD_TGL_VOID='3000-01-01 00:00:00.000'
            and replace(CONVERT(VARCHAR(11), c.fd_tgL_piutang, 111), '/','-') between :TglAwal and :TglAkhir
            and A.Fd_Tgl_Diterima='3000-01-01 00:00:00.000'
            and A.FS_JENIS_CUSTOMER='Perusahaan'");

                $this->db->bind('TglAwal', $TglAwal);
                $this->db->bind('TglAkhir', $TglAkhir);
            } elseif ($JenisJaminan  == "2") {
                $this->db->query("SELECT A.FS_KD_TRS,C.fd_tgL_piutang as FD_TGL_TRS,A.FS_JENIS_CUSTOMER,A.FS_KD_CUSTOMER,b.NamaPerusahaan,A.FS_KET,
            A.FN_TOTAL_TAGIH,A.fd_periode1,A.fd_periode2,CASE WHEN A.Fs_Code_Jenis_Reg = 'RJ' THEN 'RAWAT JALAN' WHEN  A.Fs_Code_Jenis_Reg = 'RI' THEN 'RAWAT INAP' end as Fs_Code_Jenis_Reg,
            replace(CONVERT(VARCHAR(11), A.FD_TGL_INPUT, 111), '/','-') as FD_TGL_INPUT,
            replace(CONVERT(VARCHAR(11), A.Fd_Tgl_Dikirim, 111), '/','-') as Fd_Tgl_Dikirim,
            replace(CONVERT(VARCHAR(11),A.Fd_Tgl_Diterima, 111), '/','-') as Fd_Tgl_Diterima
            FROM Keuangan.DBO.TA_ORDER_PIUTANG a
            INNER JOIN MasterdataSQL.DBO.MstrPerusahaanAsuransi B
            ON A.FS_KD_CUSTOMER = B.ID
            inner join Keuangan.dbo.PIUTANG_PASIEN C
			ON C.FS_KD_TAGIH = a.FS_KD_TRS
            WHERE FD_TGL_VOID='3000-01-01 00:00:00.000'
            and replace(CONVERT(VARCHAR(11), c.fd_tgL_piutang, 111), '/','-') between :TglAwal and :TglAkhir
            and A.Fd_Tgl_Diterima='3000-01-01 00:00:00.000'
            and A.FS_JENIS_CUSTOMER='Asuransi'
            UNION ALL
            SELECT A.FS_KD_TRS,C.fd_tgL_piutang as FD_TGL_TRS,A.FS_JENIS_CUSTOMER,A.FS_KD_CUSTOMER,b.NamaPerusahaan,A.FS_KET,
            A.FN_TOTAL_TAGIH,A.fd_periode1,A.fd_periode2,CASE WHEN A.Fs_Code_Jenis_Reg = 'RJ' THEN 'RAWAT JALAN' WHEN  A.Fs_Code_Jenis_Reg = 'RI' THEN 'RAWAT INAP' end as Fs_Code_Jenis_Reg,
            replace(CONVERT(VARCHAR(11), A.FD_TGL_INPUT, 111), '/','-') as FD_TGL_INPUT,
            replace(CONVERT(VARCHAR(11), A.Fd_Tgl_Dikirim, 111), '/','-') as Fd_Tgl_Dikirim,
            replace(CONVERT(VARCHAR(11),A.Fd_Tgl_Diterima, 111), '/','-') as Fd_Tgl_Diterima
            FROM Keuangan.DBO.TA_ORDER_PIUTANG a
            INNER JOIN MasterdataSQL.DBO.MstrPerusahaanJPK B
            ON A.FS_KD_CUSTOMER = B.ID
            inner join Keuangan.dbo.PIUTANG_PASIEN C
			ON C.FS_KD_TAGIH = a.FS_KD_TRS
            WHERE FD_TGL_VOID='3000-01-01 00:00:00.000'
            and replace(CONVERT(VARCHAR(11), c.fd_tgL_piutang, 111), '/','-') between :TglAwal1 and :TglAkhir1
            and A.Fd_Tgl_Diterima='3000-01-01 00:00:00.000'
            and A.FS_JENIS_CUSTOMER='Perusahaan'");
                $this->db->bind('TglAwal', $TglAwal);
                $this->db->bind('TglAwal1', $TglAwal);

                $this->db->bind('TglAkhir', $TglAkhir);
                $this->db->bind('TglAkhir1', $TglAkhir);
            }
            $data =  $this->db->resultSet();

            $rows = array();
            $no = 1;

            foreach ($data as $row) {
                $pasing['no'] = $no++;
                $pasing['FS_KD_TRS'] = $row['FS_KD_TRS'];
                $pasing['FD_TGL_TRS'] = $row['FD_TGL_TRS'];
                $pasing['FS_JENIS_CUSTOMER'] = $row['FS_JENIS_CUSTOMER'];
                $pasing['FS_KD_CUSTOMER'] = $row['FS_KD_CUSTOMER'];
                $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                $pasing['FS_KET'] = $row['FS_KET'];
                $pasing['FN_TOTAL_TAGIH'] = $row['FN_TOTAL_TAGIH'];
                $pasing['FD_TGL_INPUT'] = $row['FD_TGL_INPUT'];

                $pasing['fd_periode1'] = $row['fd_periode1'];
                $pasing['fd_periode2'] = $row['fd_periode2'];
                $pasing['Fs_Code_Jenis_Reg'] = $row['Fs_Code_Jenis_Reg'];
                $pasing['Fd_Tgl_Dikirim'] = $row['Fd_Tgl_Dikirim'];
                $pasing['Fd_Tgl_Diterima'] = $row['Fd_Tgl_Diterima'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getInfoRekapPiutangInvoice($data)
    {
        try {

            $TglAwal = $data['TglAwal'];
            $TglAkhir = $data['TglAkhir'];
            $JenisInfo = $data['JenisInfo'];
            $TipePenjamin = $data['TipePenjamin'];
            $NamaPenjamin = $data['NamaPenjamin'];


            // var_dump($TglAwal, $TglAkhir, $optJenisInfo);
            // exit;
            if ($JenisInfo == '0' && $TipePenjamin == '4') {
                $this->db->query("SELECT ab.FS_KET,case when ab.FS_JENIS_CUSTOMER='Asuransi' then g.NamaPerusahaan else h.NamaPerusahaan end as NamaPerusahaan,
            ab.Fd_Tgl_Dikirim,ab.Fd_Tgl_Diterima,
            CASE
            WHEN ab.Fd_Tgl_Diterima <>'3000-01-01 00:00:00.000'
            then DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) else '-' end AS umur,
            sum(isnull(a.fn_piutang,0)) piutang,
            sum(isnull(c.NILAI_PAY,0)) nilai_pay,SUM(isnull(A.fn_sisa,0)) sisa_piutang,
            case when SUM(A.fn_sisa) = '0' then 'LUNAS' ELSE 'BELUM LUNAS' END as Keterangan,count(a.FS_KD_TAGIH) as totalpasien
            from Keuangan.DBO.TA_ORDER_PIUTANG Ab
            inner join keuangan.dbo.PIUTANG_PASIEN a
            on ab.FS_KD_TRS = a.FS_KD_TAGIH
            left join keuangan.dbo.TA_PTG_LUNAS_DTL c on c.KD_PIUTANG=a.KD_PIUTANG
            left join keuangan.dbo.TA_PTG_LUNAS_HDR d on c.FS_KD_TRS=d.FS_KD_TRS
            left join keuangan.dbo.TM_REKENING e on e.FS_KD_REKENING=a.FS_REKENING
            left join MasterdataSQL.dbo.MstrPerusahaanAsuransi g on g.id=a.kode_jaminan
            left join MasterdataSQL.dbo.MstrPerusahaanJPK h on h.id=a.kode_jaminan
            where A.FB_BATAL=0 and replace(CONVERT(VARCHAR(11),ab.FD_TGL_INPUT, 111), '/','-') between :TglAwal and :TglAkhir
            group by ab.FS_KET, case when ab.FS_JENIS_CUSTOMER='Asuransi' then g.NamaPerusahaan else h.NamaPerusahaan end,ab.Fd_Tgl_Dikirim,ab.Fd_Tgl_Diterima");
                $this->db->bind('TglAwal', $TglAwal);
                $this->db->bind('TglAkhir', $TglAkhir);
                $data =  $this->db->resultSet();

                $rows = array();
                $no = 1;

                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['FS_KET'] = $row['FS_KET'];
                    $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                    $pasing['Fd_Tgl_Dikirim'] = $row['Fd_Tgl_Dikirim'];
                    $pasing['Fd_Tgl_Diterima'] = $row['Fd_Tgl_Diterima'];
                    $pasing['umur'] = $row['umur'];
                    $pasing['piutang'] = $row['piutang'];
                    $pasing['nilai_pay'] = $row['nilai_pay'];
                    $pasing['sisa_piutang'] = $row['sisa_piutang'];
                    $pasing['Keterangan'] = $row['Keterangan'];
                    $pasing['totalpasien'] = $row['totalpasien'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisInfo == '0' && $TipePenjamin == '2') {
                $this->db->query("SELECT ab.FS_KET,g.NamaPerusahaan ,
                ab.Fd_Tgl_Dikirim,ab.Fd_Tgl_Diterima,
                CASE
                WHEN ab.Fd_Tgl_Diterima <>'3000-01-01 00:00:00.000'
                then DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) else '-' end AS umur,
                sum(isnull(a.fn_piutang,0)) piutang,
                sum(isnull(c.NILAI_PAY,0)) nilai_pay,SUM(isnull(A.fn_sisa,0)) sisa_piutang,
                case when SUM(A.fn_sisa) = '0' then 'LUNAS' ELSE 'BELUM LUNAS' END as Keterangan,count(a.FS_KD_TAGIH) as totalpasien
                from Keuangan.DBO.TA_ORDER_PIUTANG Ab
                inner join keuangan.dbo.PIUTANG_PASIEN a
                on ab.FS_KD_TRS = a.FS_KD_TAGIH
                left join keuangan.dbo.TA_PTG_LUNAS_DTL c on c.KD_PIUTANG=a.KD_PIUTANG
                left join keuangan.dbo.TA_PTG_LUNAS_HDR d on c.FS_KD_TRS=d.FS_KD_TRS
                left join keuangan.dbo.TM_REKENING e on e.FS_KD_REKENING=a.FS_REKENING
                left join MasterdataSQL.dbo.MstrPerusahaanAsuransi g on g.id=a.kode_jaminan
                --left join MasterdataSQL.dbo.MstrPerusahaanJPK h on h.id=a.kode_jaminan
                where A.FB_BATAL=0 and replace(CONVERT(VARCHAR(11),ab.FD_TGL_INPUT, 111), '/','-') between :TglAwal and :TglAkhir and g.ID = :NamaPenjamin
                group by ab.FS_KET, g.NamaPerusahaan ,ab.Fd_Tgl_Dikirim,ab.Fd_Tgl_Diterima");
                $this->db->bind('TglAwal', $TglAwal);
                $this->db->bind('TglAkhir', $TglAkhir);
                $this->db->bind('NamaPenjamin', $NamaPenjamin);


                $data =  $this->db->resultSet();

                $rows = array();
                $no = 1;

                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['FS_KET'] = $row['FS_KET'];
                    $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                    $pasing['Fd_Tgl_Dikirim'] = $row['Fd_Tgl_Dikirim'];
                    $pasing['Fd_Tgl_Diterima'] = $row['Fd_Tgl_Diterima'];
                    $pasing['umur'] = $row['umur'];
                    $pasing['piutang'] = $row['piutang'];
                    $pasing['nilai_pay'] = $row['nilai_pay'];
                    $pasing['sisa_piutang'] = $row['sisa_piutang'];
                    $pasing['Keterangan'] = $row['Keterangan'];
                    $pasing['totalpasien'] = $row['totalpasien'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisInfo == '0' && $TipePenjamin == '5') {
                $this->db->query("SELECT ab.FS_KET,h.NamaPerusahaan ,
                ab.Fd_Tgl_Dikirim,ab.Fd_Tgl_Diterima,
                CASE
                WHEN ab.Fd_Tgl_Diterima <>'3000-01-01 00:00:00.000'
                then DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) else '-' end AS umur,
                sum(isnull(a.fn_piutang,0)) piutang,
                sum(isnull(c.NILAI_PAY,0)) nilai_pay,SUM(isnull(A.fn_sisa,0)) sisa_piutang,
                case when SUM(A.fn_sisa) = '0' then 'LUNAS' ELSE 'BELUM LUNAS' END as Keterangan,count(a.FS_KD_TAGIH) as totalpasien
                from Keuangan.DBO.TA_ORDER_PIUTANG Ab
                inner join keuangan.dbo.PIUTANG_PASIEN a
                on ab.FS_KD_TRS = a.FS_KD_TAGIH
                left join keuangan.dbo.TA_PTG_LUNAS_DTL c on c.KD_PIUTANG=a.KD_PIUTANG
                left join keuangan.dbo.TA_PTG_LUNAS_HDR d on c.FS_KD_TRS=d.FS_KD_TRS
                left join keuangan.dbo.TM_REKENING e on e.FS_KD_REKENING=a.FS_REKENING
                -- left join MasterdataSQL.dbo.MstrPerusahaanAsuransi g on g.id=a.kode_jaminan
                left join MasterdataSQL.dbo.MstrPerusahaanJPK h on h.id=a.kode_jaminan
                where A.FB_BATAL=0 and replace(CONVERT(VARCHAR(11),ab.FD_TGL_INPUT, 111), '/','-') between :TglAwal and :TglAkhir and h.ID = :NamaPenjamin
                group by ab.FS_KET, h.NamaPerusahaan ,ab.Fd_Tgl_Dikirim,ab.Fd_Tgl_Diterima");
                $this->db->bind('TglAwal', $TglAwal);
                $this->db->bind('TglAkhir', $TglAkhir);
                $this->db->bind('NamaPenjamin', $NamaPenjamin);


                $data =  $this->db->resultSet();

                $rows = array();
                $no = 1;

                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['FS_KET'] = $row['FS_KET'];
                    $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                    $pasing['Fd_Tgl_Dikirim'] = $row['Fd_Tgl_Dikirim'];
                    $pasing['Fd_Tgl_Diterima'] = $row['Fd_Tgl_Diterima'];
                    $pasing['umur'] = $row['umur'];
                    $pasing['piutang'] = $row['piutang'];
                    $pasing['nilai_pay'] = $row['nilai_pay'];
                    $pasing['sisa_piutang'] = $row['sisa_piutang'];
                    $pasing['Keterangan'] = $row['Keterangan'];
                    $pasing['totalpasien'] = $row['totalpasien'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisInfo == '0' && $TipePenjamin == '1') {
                $this->db->query("SELECT ab.FS_KET,h.NamaPerusahaan ,
                ab.Fd_Tgl_Dikirim,ab.Fd_Tgl_Diterima,
                CASE
                WHEN ab.Fd_Tgl_Diterima <>'3000-01-01 00:00:00.000'
                then DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) else '-' end AS umur,
                sum(isnull(a.fn_piutang,0)) piutang,
                sum(isnull(c.NILAI_PAY,0)) nilai_pay,SUM(isnull(A.fn_sisa,0)) sisa_piutang,
                case when SUM(A.fn_sisa) = '0' then 'LUNAS' ELSE 'BELUM LUNAS' END as Keterangan,count(a.FS_KD_TAGIH) as totalpasien
                from Keuangan.DBO.TA_ORDER_PIUTANG Ab
                inner join keuangan.dbo.PIUTANG_PASIEN a
                on ab.FS_KD_TRS = a.FS_KD_TAGIH
                left join keuangan.dbo.TA_PTG_LUNAS_DTL c on c.KD_PIUTANG=a.KD_PIUTANG
                left join keuangan.dbo.TA_PTG_LUNAS_HDR d on c.FS_KD_TRS=d.FS_KD_TRS
                left join keuangan.dbo.TM_REKENING e on e.FS_KD_REKENING=a.FS_REKENING
                -- left join MasterdataSQL.dbo.MstrPerusahaanAsuransi g on g.id=a.kode_jaminan
                left join MasterdataSQL.dbo.MstrPerusahaanJPK h on h.id=a.kode_jaminan
                where A.FB_BATAL=0 and replace(CONVERT(VARCHAR(11),ab.FD_TGL_INPUT, 111), '/','-') between :TglAwal and :TglAkhir and h.ID = :NamaPenjamin
                group by ab.FS_KET, h.NamaPerusahaan ,ab.Fd_Tgl_Dikirim,ab.Fd_Tgl_Diterima");
                $this->db->bind('TglAwal', $TglAwal);
                $this->db->bind('TglAkhir', $TglAkhir);
                $this->db->bind('NamaPenjamin', $NamaPenjamin);


                $data =  $this->db->resultSet();

                $rows = array();
                $no = 1;

                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['FS_KET'] = $row['FS_KET'];
                    $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                    $pasing['Fd_Tgl_Dikirim'] = $row['Fd_Tgl_Dikirim'];
                    $pasing['Fd_Tgl_Diterima'] = $row['Fd_Tgl_Diterima'];
                    $pasing['umur'] = $row['umur'];
                    $pasing['piutang'] = $row['piutang'];
                    $pasing['nilai_pay'] = $row['nilai_pay'];
                    $pasing['sisa_piutang'] = $row['sisa_piutang'];
                    $pasing['Keterangan'] = $row['Keterangan'];
                    $pasing['totalpasien'] = $row['totalpasien'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisInfo  == "1") {
                $this->db->query("SELECT case when ab.FS_JENIS_CUSTOMER='Asuransi' then g.NamaPerusahaan else h.NamaPerusahaan end as NamaPerusahaan,
                SUM(isnull(A.fn_sisa,0)) sisa_piutang
                from Keuangan.DBO.TA_ORDER_PIUTANG Ab
                inner join keuangan.dbo.PIUTANG_PASIEN a
                on ab.FS_KD_TRS = a.FS_KD_TAGIH
                left join keuangan.dbo.TA_PTG_LUNAS_DTL c on c.KD_PIUTANG=a.KD_PIUTANG
                left join keuangan.dbo.TA_PTG_LUNAS_HDR d on c.FS_KD_TRS=d.FS_KD_TRS
                left join keuangan.dbo.TM_REKENING e on e.FS_KD_REKENING=a.FS_REKENING
                left join MasterdataSQL.dbo.MstrPerusahaanAsuransi g on g.id=a.kode_jaminan
                left join MasterdataSQL.dbo.MstrPerusahaanJPK h on h.id=a.kode_jaminan
                where A.FB_BATAL=0 and replace(CONVERT(VARCHAR(11),ab.FD_TGL_INPUT, 111), '/','-') between :TglAwal and :TglAkhir
                group by case when ab.FS_JENIS_CUSTOMER='Asuransi' then g.NamaPerusahaan else h.NamaPerusahaan end");
                $this->db->bind('TglAwal', $TglAwal);
                $this->db->bind('TglAkhir', $TglAkhir);
                $data =  $this->db->resultSet();

                $rows = array();
                $no = 1;

                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                    $pasing['sisa_piutang'] = $row['sisa_piutang'];
                    $rows[] = $pasing;
                }
            } elseif ($JenisInfo == '2' && $TipePenjamin == '4') {
                $this->db->query("SELECT ab.FS_KET,case when ab.FS_JENIS_CUSTOMER='Asuransi' then g.NamaPerusahaan else h.NamaPerusahaan end as NamaPerusahaan,a.FS_kET as ket,
            ab.Fd_Tgl_Dikirim,ab.Fd_Tgl_Diterima,
            CASE
            WHEN ab.Fd_Tgl_Diterima <>'3000-01-01 00:00:00.000'
            then DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) else '-' end AS umur,
            sum(isnull(a.fn_piutang,0)) piutang,
            sum(isnull(c.NILAI_PAY,0)) nilai_pay,SUM(isnull(A.fn_sisa,0)) sisa_piutang,
            case when SUM(A.fn_sisa) = '0' then 'LUNAS' ELSE 'BELUM LUNAS' END as Keterangan,count(a.FS_KD_TAGIH) as totalpasien
            from Keuangan.DBO.TA_ORDER_PIUTANG Ab
            inner join keuangan.dbo.PIUTANG_PASIEN a
            on ab.FS_KD_TRS = a.FS_KD_TAGIH
            left join keuangan.dbo.TA_PTG_LUNAS_DTL c on c.KD_PIUTANG=a.KD_PIUTANG
            left join keuangan.dbo.TA_PTG_LUNAS_HDR d on c.FS_KD_TRS=d.FS_KD_TRS
            left join keuangan.dbo.TM_REKENING e on e.FS_KD_REKENING=a.FS_REKENING
            left join MasterdataSQL.dbo.MstrPerusahaanAsuransi g on g.id=a.kode_jaminan
            left join MasterdataSQL.dbo.MstrPerusahaanJPK h on h.id=a.kode_jaminan
            where A.FB_BATAL=0 and replace(CONVERT(VARCHAR(11),ab.FD_TGL_INPUT, 111), '/','-') between :TglAwal and :TglAkhir
            group by ab.FS_KET, a.FS_kET,case when ab.FS_JENIS_CUSTOMER='Asuransi' then g.NamaPerusahaan else h.NamaPerusahaan end,ab.Fd_Tgl_Dikirim,ab.Fd_Tgl_Diterima
            order by 2 asc , 1 asc");
                $this->db->bind('TglAwal', $TglAwal);
                $this->db->bind('TglAkhir', $TglAkhir);
                $data =  $this->db->resultSet();

                $rows = array();
                $no = 1;

                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['FS_KET'] = $row['FS_KET'];
                    $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                    $pasing['ket'] = $row['ket'];
                    $pasing['Fd_Tgl_Dikirim'] = $row['Fd_Tgl_Dikirim'];
                    $pasing['Fd_Tgl_Diterima'] = $row['Fd_Tgl_Diterima'];
                    $pasing['umur'] = $row['umur'];
                    $pasing['piutang'] = $row['piutang'];
                    $pasing['nilai_pay'] = $row['nilai_pay'];
                    $pasing['sisa_piutang'] = $row['sisa_piutang'];
                    $pasing['Keterangan'] = $row['Keterangan'];
                    $pasing['totalpasien'] = $row['totalpasien'];


                    $rows[] = $pasing;
                }
            } elseif ($JenisInfo == '2' && $TipePenjamin == '2') {
                $this->db->query("SELECT ab.FS_KET,g.NamaPerusahaan,a.FS_kET as ket,
            ab.Fd_Tgl_Dikirim,ab.Fd_Tgl_Diterima,
            CASE
            WHEN ab.Fd_Tgl_Diterima <>'3000-01-01 00:00:00.000'
            then DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) else '-' end AS umur,
            sum(isnull(a.fn_piutang,0)) piutang,
            sum(isnull(c.NILAI_PAY,0)) nilai_pay,SUM(isnull(A.fn_sisa,0)) sisa_piutang,
            case when SUM(A.fn_sisa) = '0' then 'LUNAS' ELSE 'BELUM LUNAS' END as Keterangan,count(a.FS_KD_TAGIH) as totalpasien
            from Keuangan.DBO.TA_ORDER_PIUTANG Ab
            inner join keuangan.dbo.PIUTANG_PASIEN a
            on ab.FS_KD_TRS = a.FS_KD_TAGIH
            left join keuangan.dbo.TA_PTG_LUNAS_DTL c on c.KD_PIUTANG=a.KD_PIUTANG
            left join keuangan.dbo.TA_PTG_LUNAS_HDR d on c.FS_KD_TRS=d.FS_KD_TRS
            left join keuangan.dbo.TM_REKENING e on e.FS_KD_REKENING=a.FS_REKENING
            left join MasterdataSQL.dbo.MstrPerusahaanAsuransi g on g.id=a.kode_jaminan
            -- left join MasterdataSQL.dbo.MstrPerusahaanJPK h on h.id=a.kode_jaminan
            where A.FB_BATAL=0 and replace(CONVERT(VARCHAR(11),ab.FD_TGL_INPUT, 111), '/','-') between :TglAwal and :TglAkhir and g.ID = :NamaPenjamin
            group by ab.FS_KET, a.FS_kET,g.NamaPerusahaan,ab.Fd_Tgl_Dikirim,ab.Fd_Tgl_Diterima
            order by 2 asc , 1 asc");
                $this->db->bind('TglAwal', $TglAwal);
                $this->db->bind('TglAkhir', $TglAkhir);
                $this->db->bind('NamaPenjamin', $NamaPenjamin);

                $data =  $this->db->resultSet();

                $rows = array();
                $no = 1;

                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['FS_KET'] = $row['FS_KET'];
                    $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                    $pasing['ket'] = $row['ket'];
                    $pasing['Fd_Tgl_Dikirim'] = $row['Fd_Tgl_Dikirim'];
                    $pasing['Fd_Tgl_Diterima'] = $row['Fd_Tgl_Diterima'];
                    $pasing['umur'] = $row['umur'];
                    $pasing['piutang'] = $row['piutang'];
                    $pasing['nilai_pay'] = $row['nilai_pay'];
                    $pasing['sisa_piutang'] = $row['sisa_piutang'];
                    $pasing['Keterangan'] = $row['Keterangan'];
                    $pasing['totalpasien'] = $row['totalpasien'];


                    $rows[] = $pasing;
                }
            } elseif ($JenisInfo == '2' && $TipePenjamin == '5') {
                $this->db->query("SELECT ab.FS_KET,h.NamaPerusahaan,a.FS_kET as ket,
            ab.Fd_Tgl_Dikirim,ab.Fd_Tgl_Diterima,
            CASE
            WHEN ab.Fd_Tgl_Diterima <>'3000-01-01 00:00:00.000'
            then DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) else '-' end AS umur,
            sum(isnull(a.fn_piutang,0)) piutang,
            sum(isnull(c.NILAI_PAY,0)) nilai_pay,SUM(isnull(A.fn_sisa,0)) sisa_piutang,
            case when SUM(A.fn_sisa) = '0' then 'LUNAS' ELSE 'BELUM LUNAS' END as Keterangan,count(a.FS_KD_TAGIH) as totalpasien
            from Keuangan.DBO.TA_ORDER_PIUTANG Ab
            inner join keuangan.dbo.PIUTANG_PASIEN a
            on ab.FS_KD_TRS = a.FS_KD_TAGIH
            left join keuangan.dbo.TA_PTG_LUNAS_DTL c on c.KD_PIUTANG=a.KD_PIUTANG
            left join keuangan.dbo.TA_PTG_LUNAS_HDR d on c.FS_KD_TRS=d.FS_KD_TRS
            left join keuangan.dbo.TM_REKENING e on e.FS_KD_REKENING=a.FS_REKENING
            -- left join MasterdataSQL.dbo.MstrPerusahaanAsuransi g on g.id=a.kode_jaminan
            left join MasterdataSQL.dbo.MstrPerusahaanJPK h on h.id=a.kode_jaminan
            where A.FB_BATAL=0 and replace(CONVERT(VARCHAR(11),ab.FD_TGL_INPUT, 111), '/','-') between :TglAwal and :TglAkhir and h.ID = :NamaPenjamin
            group by ab.FS_KET, a.FS_kET,h.NamaPerusahaan,ab.Fd_Tgl_Dikirim,ab.Fd_Tgl_Diterima
            order by 2 asc , 1 asc");
                $this->db->bind('TglAwal', $TglAwal);
                $this->db->bind('TglAkhir', $TglAkhir);
                $this->db->bind('NamaPenjamin', $NamaPenjamin);

                $data =  $this->db->resultSet();

                $rows = array();
                $no = 1;

                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['FS_KET'] = $row['FS_KET'];
                    $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                    $pasing['ket'] = $row['ket'];
                    $pasing['Fd_Tgl_Dikirim'] = $row['Fd_Tgl_Dikirim'];
                    $pasing['Fd_Tgl_Diterima'] = $row['Fd_Tgl_Diterima'];
                    $pasing['umur'] = $row['umur'];
                    $pasing['piutang'] = $row['piutang'];
                    $pasing['nilai_pay'] = $row['nilai_pay'];
                    $pasing['sisa_piutang'] = $row['sisa_piutang'];
                    $pasing['Keterangan'] = $row['Keterangan'];
                    $pasing['totalpasien'] = $row['totalpasien'];


                    $rows[] = $pasing;
                }
            } elseif ($JenisInfo == '2' && $TipePenjamin == '1') {
                $this->db->query("SELECT ab.FS_KET,h.NamaPerusahaan,a.FS_kET as ket,
            ab.Fd_Tgl_Dikirim,ab.Fd_Tgl_Diterima,
            CASE
            WHEN ab.Fd_Tgl_Diterima <>'3000-01-01 00:00:00.000'
            then DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) else '-' end AS umur,
            sum(isnull(a.fn_piutang,0)) piutang,
            sum(isnull(c.NILAI_PAY,0)) nilai_pay,SUM(isnull(A.fn_sisa,0)) sisa_piutang,
            case when SUM(A.fn_sisa) = '0' then 'LUNAS' ELSE 'BELUM LUNAS' END as Keterangan,count(a.FS_KD_TAGIH) as totalpasien
            from Keuangan.DBO.TA_ORDER_PIUTANG Ab
            inner join keuangan.dbo.PIUTANG_PASIEN a
            on ab.FS_KD_TRS = a.FS_KD_TAGIH
            left join keuangan.dbo.TA_PTG_LUNAS_DTL c on c.KD_PIUTANG=a.KD_PIUTANG
            left join keuangan.dbo.TA_PTG_LUNAS_HDR d on c.FS_KD_TRS=d.FS_KD_TRS
            left join keuangan.dbo.TM_REKENING e on e.FS_KD_REKENING=a.FS_REKENING
            -- left join MasterdataSQL.dbo.MstrPerusahaanAsuransi g on g.id=a.kode_jaminan
            left join MasterdataSQL.dbo.MstrPerusahaanJPK h on h.id=a.kode_jaminan
            where A.FB_BATAL=0 and replace(CONVERT(VARCHAR(11),ab.FD_TGL_INPUT, 111), '/','-') between :TglAwal and :TglAkhir and h.ID = :NamaPenjamin
            group by ab.FS_KET, a.FS_kET,h.NamaPerusahaan,ab.Fd_Tgl_Dikirim,ab.Fd_Tgl_Diterima
            order by 2 asc , 1 asc");
                $this->db->bind('TglAwal', $TglAwal);
                $this->db->bind('TglAkhir', $TglAkhir);
                $this->db->bind('NamaPenjamin', $NamaPenjamin);

                $data =  $this->db->resultSet();

                $rows = array();
                $no = 1;

                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['FS_KET'] = $row['FS_KET'];
                    $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                    $pasing['ket'] = $row['ket'];
                    $pasing['Fd_Tgl_Dikirim'] = $row['Fd_Tgl_Dikirim'];
                    $pasing['Fd_Tgl_Diterima'] = $row['Fd_Tgl_Diterima'];
                    $pasing['umur'] = $row['umur'];
                    $pasing['piutang'] = $row['piutang'];
                    $pasing['nilai_pay'] = $row['nilai_pay'];
                    $pasing['sisa_piutang'] = $row['sisa_piutang'];
                    $pasing['Keterangan'] = $row['Keterangan'];
                    $pasing['totalpasien'] = $row['totalpasien'];


                    $rows[] = $pasing;
                }
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getInfoRekapPiutangInvoice1($data)
    {
        try {

            $TglAwal = $data['TglAwal'];
            $TglAkhir = $data['TglAkhir'];
            $JenisInfo = $data['JenisInfo'];
            $TipePenjamin = $data['TipePenjamin'];
            $NamaPenjamin = $data['NamaPenjamin'];


            // var_dump($TglAwal, $TglAkhir, $optJenisInfo);
            // exit;
            if ($JenisInfo == '0' && $TipePenjamin == '4') {
                $this->db->query("SELECT ab.FS_KET,case when ab.FS_JENIS_CUSTOMER='Asuransi' then g.NamaPerusahaan else h.NamaPerusahaan end as NamaPerusahaan,
            ab.Fd_Tgl_Dikirim,ab.Fd_Tgl_Diterima,
            CASE
            WHEN ab.Fd_Tgl_Diterima <>'3000-01-01 00:00:00.000'
            then DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) else '-' end AS umur,
            sum(isnull(a.fn_piutang,0)) piutang,
            sum(isnull(c.NILAI_PAY,0)) nilai_pay,SUM(isnull(A.fn_sisa,0)) sisa_piutang,
            case when SUM(A.fn_sisa) = '0' then 'LUNAS' ELSE 'BELUM LUNAS' END as Keterangan,count(a.FS_KD_TAGIH) as totalpasien
            from Keuangan.DBO.TA_ORDER_PIUTANG Ab
            inner join keuangan.dbo.PIUTANG_PASIEN a
            on ab.FS_KD_TRS = a.FS_KD_TAGIH
            left join keuangan.dbo.TA_PTG_LUNAS_DTL c on c.KD_PIUTANG=a.KD_PIUTANG
            left join keuangan.dbo.TA_PTG_LUNAS_HDR d on c.FS_KD_TRS=d.FS_KD_TRS
            left join keuangan.dbo.TM_REKENING e on e.FS_KD_REKENING=a.FS_REKENING
            left join MasterdataSQL.dbo.MstrPerusahaanAsuransi g on g.id=a.kode_jaminan
            left join MasterdataSQL.dbo.MstrPerusahaanJPK h on h.id=a.kode_jaminan
            where A.FB_BATAL=0 and replace(CONVERT(VARCHAR(11),ab.FD_TGL_INPUT, 111), '/','-') between :TglAwal and :TglAkhir
            group by ab.FS_KET, case when ab.FS_JENIS_CUSTOMER='Asuransi' then g.NamaPerusahaan else h.NamaPerusahaan end,ab.Fd_Tgl_Dikirim,ab.Fd_Tgl_Diterima");
                $this->db->bind('TglAwal', $TglAwal);
                $this->db->bind('TglAkhir', $TglAkhir);
                $data =  $this->db->resultSet();

                $rows = array();
                $no = 1;

                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['FS_KET'] = $row['FS_KET'];
                    $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                    $pasing['Fd_Tgl_Dikirim'] = $row['Fd_Tgl_Dikirim'];
                    $pasing['Fd_Tgl_Diterima'] = $row['Fd_Tgl_Diterima'];
                    $pasing['umur'] = $row['umur'];
                    $pasing['piutang'] = $row['piutang'];
                    $pasing['nilai_pay'] = $row['nilai_pay'];
                    $pasing['sisa_piutang'] = $row['sisa_piutang'];
                    $pasing['Keterangan'] = $row['Keterangan'];
                    $pasing['totalpasien'] = $row['totalpasien'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisInfo == '0' && $TipePenjamin == '2') {
                $this->db->query("SELECT ab.FS_KET,g.NamaPerusahaan ,
                ab.Fd_Tgl_Dikirim,ab.Fd_Tgl_Diterima,
                CASE
                WHEN ab.Fd_Tgl_Diterima <>'3000-01-01 00:00:00.000'
                then DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) else '-' end AS umur,
                sum(isnull(a.fn_piutang,0)) piutang,
                sum(isnull(c.NILAI_PAY,0)) nilai_pay,SUM(isnull(A.fn_sisa,0)) sisa_piutang,
                case when SUM(A.fn_sisa) = '0' then 'LUNAS' ELSE 'BELUM LUNAS' END as Keterangan,count(a.FS_KD_TAGIH) as totalpasien
                from Keuangan.DBO.TA_ORDER_PIUTANG Ab
                inner join keuangan.dbo.PIUTANG_PASIEN a
                on ab.FS_KD_TRS = a.FS_KD_TAGIH
                left join keuangan.dbo.TA_PTG_LUNAS_DTL c on c.KD_PIUTANG=a.KD_PIUTANG
                left join keuangan.dbo.TA_PTG_LUNAS_HDR d on c.FS_KD_TRS=d.FS_KD_TRS
                left join keuangan.dbo.TM_REKENING e on e.FS_KD_REKENING=a.FS_REKENING
                left join MasterdataSQL.dbo.MstrPerusahaanAsuransi g on g.id=a.kode_jaminan
                --left join MasterdataSQL.dbo.MstrPerusahaanJPK h on h.id=a.kode_jaminan
                where A.FB_BATAL=0 and replace(CONVERT(VARCHAR(11),ab.FD_TGL_INPUT, 111), '/','-') between :TglAwal and :TglAkhir and g.ID = :NamaPenjamin
                group by ab.FS_KET, g.NamaPerusahaan ,ab.Fd_Tgl_Dikirim,ab.Fd_Tgl_Diterima");
                $this->db->bind('TglAwal', $TglAwal);
                $this->db->bind('TglAkhir', $TglAkhir);
                $this->db->bind('NamaPenjamin', $NamaPenjamin);


                $data =  $this->db->resultSet();

                $rows = array();
                $no = 1;

                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['FS_KET'] = $row['FS_KET'];
                    $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                    $pasing['Fd_Tgl_Dikirim'] = $row['Fd_Tgl_Dikirim'];
                    $pasing['Fd_Tgl_Diterima'] = $row['Fd_Tgl_Diterima'];
                    $pasing['umur'] = $row['umur'];
                    $pasing['piutang'] = $row['piutang'];
                    $pasing['nilai_pay'] = $row['nilai_pay'];
                    $pasing['sisa_piutang'] = $row['sisa_piutang'];
                    $pasing['Keterangan'] = $row['Keterangan'];
                    $pasing['totalpasien'] = $row['totalpasien'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisInfo == '0' && $TipePenjamin == '5') {
                $this->db->query("SELECT ab.FS_KET,h.NamaPerusahaan ,
                ab.Fd_Tgl_Dikirim,ab.Fd_Tgl_Diterima,
                CASE
                WHEN ab.Fd_Tgl_Diterima <>'3000-01-01 00:00:00.000'
                then DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) else '-' end AS umur,
                sum(isnull(a.fn_piutang,0)) piutang,
                sum(isnull(c.NILAI_PAY,0)) nilai_pay,SUM(isnull(A.fn_sisa,0)) sisa_piutang,
                case when SUM(A.fn_sisa) = '0' then 'LUNAS' ELSE 'BELUM LUNAS' END as Keterangan,count(a.FS_KD_TAGIH) as totalpasien
                from Keuangan.DBO.TA_ORDER_PIUTANG Ab
                inner join keuangan.dbo.PIUTANG_PASIEN a
                on ab.FS_KD_TRS = a.FS_KD_TAGIH
                left join keuangan.dbo.TA_PTG_LUNAS_DTL c on c.KD_PIUTANG=a.KD_PIUTANG
                left join keuangan.dbo.TA_PTG_LUNAS_HDR d on c.FS_KD_TRS=d.FS_KD_TRS
                left join keuangan.dbo.TM_REKENING e on e.FS_KD_REKENING=a.FS_REKENING
                -- left join MasterdataSQL.dbo.MstrPerusahaanAsuransi g on g.id=a.kode_jaminan
                left join MasterdataSQL.dbo.MstrPerusahaanJPK h on h.id=a.kode_jaminan
                where A.FB_BATAL=0 and replace(CONVERT(VARCHAR(11),ab.FD_TGL_INPUT, 111), '/','-') between :TglAwal and :TglAkhir and h.ID = :NamaPenjamin
                group by ab.FS_KET, h.NamaPerusahaan ,ab.Fd_Tgl_Dikirim,ab.Fd_Tgl_Diterima");
                $this->db->bind('TglAwal', $TglAwal);
                $this->db->bind('TglAkhir', $TglAkhir);
                $this->db->bind('NamaPenjamin', $NamaPenjamin);


                $data =  $this->db->resultSet();

                $rows = array();
                $no = 1;

                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['FS_KET'] = $row['FS_KET'];
                    $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                    $pasing['Fd_Tgl_Dikirim'] = $row['Fd_Tgl_Dikirim'];
                    $pasing['Fd_Tgl_Diterima'] = $row['Fd_Tgl_Diterima'];
                    $pasing['umur'] = $row['umur'];
                    $pasing['piutang'] = $row['piutang'];
                    $pasing['nilai_pay'] = $row['nilai_pay'];
                    $pasing['sisa_piutang'] = $row['sisa_piutang'];
                    $pasing['Keterangan'] = $row['Keterangan'];
                    $pasing['totalpasien'] = $row['totalpasien'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisInfo == '0' && $TipePenjamin == '1') {
                $this->db->query("SELECT ab.FS_KET,h.NamaPerusahaan ,
                ab.Fd_Tgl_Dikirim,ab.Fd_Tgl_Diterima,
                CASE
                WHEN ab.Fd_Tgl_Diterima <>'3000-01-01 00:00:00.000'
                then DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) else '-' end AS umur,
                sum(isnull(a.fn_piutang,0)) piutang,
                sum(isnull(c.NILAI_PAY,0)) nilai_pay,SUM(isnull(A.fn_sisa,0)) sisa_piutang,
                case when SUM(A.fn_sisa) = '0' then 'LUNAS' ELSE 'BELUM LUNAS' END as Keterangan,count(a.FS_KD_TAGIH) as totalpasien
                from Keuangan.DBO.TA_ORDER_PIUTANG Ab
                inner join keuangan.dbo.PIUTANG_PASIEN a
                on ab.FS_KD_TRS = a.FS_KD_TAGIH
                left join keuangan.dbo.TA_PTG_LUNAS_DTL c on c.KD_PIUTANG=a.KD_PIUTANG
                left join keuangan.dbo.TA_PTG_LUNAS_HDR d on c.FS_KD_TRS=d.FS_KD_TRS
                left join keuangan.dbo.TM_REKENING e on e.FS_KD_REKENING=a.FS_REKENING
                -- left join MasterdataSQL.dbo.MstrPerusahaanAsuransi g on g.id=a.kode_jaminan
                left join MasterdataSQL.dbo.MstrPerusahaanJPK h on h.id=a.kode_jaminan
                where A.FB_BATAL=0 and replace(CONVERT(VARCHAR(11),ab.FD_TGL_INPUT, 111), '/','-') between :TglAwal and :TglAkhir and h.ID = :NamaPenjamin
                group by ab.FS_KET, h.NamaPerusahaan ,ab.Fd_Tgl_Dikirim,ab.Fd_Tgl_Diterima");
                $this->db->bind('TglAwal', $TglAwal);
                $this->db->bind('TglAkhir', $TglAkhir);
                $this->db->bind('NamaPenjamin', $NamaPenjamin);


                $data =  $this->db->resultSet();

                $rows = array();
                $no = 1;

                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['FS_KET'] = $row['FS_KET'];
                    $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                    $pasing['Fd_Tgl_Dikirim'] = $row['Fd_Tgl_Dikirim'];
                    $pasing['Fd_Tgl_Diterima'] = $row['Fd_Tgl_Diterima'];
                    $pasing['umur'] = $row['umur'];
                    $pasing['piutang'] = $row['piutang'];
                    $pasing['nilai_pay'] = $row['nilai_pay'];
                    $pasing['sisa_piutang'] = $row['sisa_piutang'];
                    $pasing['Keterangan'] = $row['Keterangan'];
                    $pasing['totalpasien'] = $row['totalpasien'];

                    $rows[] = $pasing;
                }
            } elseif ($JenisInfo  == "1") {
                $this->db->query("SELECT case when ab.FS_JENIS_CUSTOMER='Asuransi' then g.NamaPerusahaan else h.NamaPerusahaan end as NamaPerusahaan,
                SUM(isnull(A.fn_sisa,0)) sisa_piutang
                from Keuangan.DBO.TA_ORDER_PIUTANG Ab
                inner join keuangan.dbo.PIUTANG_PASIEN a
                on ab.FS_KD_TRS = a.FS_KD_TAGIH
                left join keuangan.dbo.TA_PTG_LUNAS_DTL c on c.KD_PIUTANG=a.KD_PIUTANG
                left join keuangan.dbo.TA_PTG_LUNAS_HDR d on c.FS_KD_TRS=d.FS_KD_TRS
                left join keuangan.dbo.TM_REKENING e on e.FS_KD_REKENING=a.FS_REKENING
                left join MasterdataSQL.dbo.MstrPerusahaanAsuransi g on g.id=a.kode_jaminan
                left join MasterdataSQL.dbo.MstrPerusahaanJPK h on h.id=a.kode_jaminan
                where A.FB_BATAL=0 and replace(CONVERT(VARCHAR(11),ab.FD_TGL_INPUT, 111), '/','-') between :TglAwal and :TglAkhir
                group by case when ab.FS_JENIS_CUSTOMER='Asuransi' then g.NamaPerusahaan else h.NamaPerusahaan end");
                $this->db->bind('TglAwal', $TglAwal);
                $this->db->bind('TglAkhir', $TglAkhir);
                $data =  $this->db->resultSet();

                $rows = array();
                $no = 1;

                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                    $pasing['sisa_piutang'] = $row['sisa_piutang'];
                    $rows[] = $pasing;
                }
            } elseif ($JenisInfo == '2' && $TipePenjamin == '4') {
                $this->db->query("SELECT ab.FS_KET,case when ab.FS_JENIS_CUSTOMER='Asuransi' then g.NamaPerusahaan else h.NamaPerusahaan end as NamaPerusahaan,a.FS_kET as ket,
            ab.Fd_Tgl_Dikirim,ab.Fd_Tgl_Diterima,
            CASE
            WHEN ab.Fd_Tgl_Diterima <>'3000-01-01 00:00:00.000'
            then DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) else '-' end AS umur,
            sum(isnull(a.fn_piutang,0)) piutang,
            sum(isnull(c.NILAI_PAY,0)) nilai_pay,SUM(isnull(A.fn_sisa,0)) sisa_piutang,
            case when SUM(A.fn_sisa) = '0' then 'LUNAS' ELSE 'BELUM LUNAS' END as Keterangan,count(a.FS_KD_TAGIH) as totalpasien
            from Keuangan.DBO.TA_ORDER_PIUTANG Ab
            inner join keuangan.dbo.PIUTANG_PASIEN a
            on ab.FS_KD_TRS = a.FS_KD_TAGIH
            left join keuangan.dbo.TA_PTG_LUNAS_DTL c on c.KD_PIUTANG=a.KD_PIUTANG
            left join keuangan.dbo.TA_PTG_LUNAS_HDR d on c.FS_KD_TRS=d.FS_KD_TRS
            left join keuangan.dbo.TM_REKENING e on e.FS_KD_REKENING=a.FS_REKENING
            left join MasterdataSQL.dbo.MstrPerusahaanAsuransi g on g.id=a.kode_jaminan
            left join MasterdataSQL.dbo.MstrPerusahaanJPK h on h.id=a.kode_jaminan
            where A.FB_BATAL=0 and replace(CONVERT(VARCHAR(11),ab.FD_TGL_INPUT, 111), '/','-') between :TglAwal and :TglAkhir
            group by ab.FS_KET, a.FS_kET,case when ab.FS_JENIS_CUSTOMER='Asuransi' then g.NamaPerusahaan else h.NamaPerusahaan end,ab.Fd_Tgl_Dikirim,ab.Fd_Tgl_Diterima
            order by 2 asc , 1 asc");
                $this->db->bind('TglAwal', $TglAwal);
                $this->db->bind('TglAkhir', $TglAkhir);
                $data =  $this->db->resultSet();

                $rows = array();
                $no = 1;

                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['FS_KET'] = $row['FS_KET'];
                    $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                    $pasing['ket'] = $row['ket'];
                    $pasing['Fd_Tgl_Dikirim'] = $row['Fd_Tgl_Dikirim'];
                    $pasing['Fd_Tgl_Diterima'] = $row['Fd_Tgl_Diterima'];
                    $pasing['umur'] = $row['umur'];
                    $pasing['piutang'] = $row['piutang'];
                    $pasing['nilai_pay'] = $row['nilai_pay'];
                    $pasing['sisa_piutang'] = $row['sisa_piutang'];
                    $pasing['Keterangan'] = $row['Keterangan'];
                    $pasing['totalpasien'] = $row['totalpasien'];


                    $rows[] = $pasing;
                }
            } elseif ($JenisInfo == '2' && $TipePenjamin == '2') {
                $this->db->query("SELECT ab.FS_KET,g.NamaPerusahaan,a.FS_kET as ket,
            ab.Fd_Tgl_Dikirim,ab.Fd_Tgl_Diterima,
            CASE
            WHEN ab.Fd_Tgl_Diterima <>'3000-01-01 00:00:00.000'
            then DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) else '-' end AS umur,
            sum(isnull(a.fn_piutang,0)) piutang,
            sum(isnull(c.NILAI_PAY,0)) nilai_pay,SUM(isnull(A.fn_sisa,0)) sisa_piutang,
            case when SUM(A.fn_sisa) = '0' then 'LUNAS' ELSE 'BELUM LUNAS' END as Keterangan,count(a.FS_KD_TAGIH) as totalpasien
            from Keuangan.DBO.TA_ORDER_PIUTANG Ab
            inner join keuangan.dbo.PIUTANG_PASIEN a
            on ab.FS_KD_TRS = a.FS_KD_TAGIH
            left join keuangan.dbo.TA_PTG_LUNAS_DTL c on c.KD_PIUTANG=a.KD_PIUTANG
            left join keuangan.dbo.TA_PTG_LUNAS_HDR d on c.FS_KD_TRS=d.FS_KD_TRS
            left join keuangan.dbo.TM_REKENING e on e.FS_KD_REKENING=a.FS_REKENING
            left join MasterdataSQL.dbo.MstrPerusahaanAsuransi g on g.id=a.kode_jaminan
            -- left join MasterdataSQL.dbo.MstrPerusahaanJPK h on h.id=a.kode_jaminan
            where A.FB_BATAL=0 and replace(CONVERT(VARCHAR(11),ab.FD_TGL_INPUT, 111), '/','-') between :TglAwal and :TglAkhir and g.ID = :NamaPenjamin
            group by ab.FS_KET, a.FS_kET,g.NamaPerusahaan,ab.Fd_Tgl_Dikirim,ab.Fd_Tgl_Diterima
            order by 2 asc , 1 asc");
                $this->db->bind('TglAwal', $TglAwal);
                $this->db->bind('TglAkhir', $TglAkhir);
                $this->db->bind('NamaPenjamin', $NamaPenjamin);

                $data =  $this->db->resultSet();

                $rows = array();
                $no = 1;

                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['FS_KET'] = $row['FS_KET'];
                    $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                    $pasing['ket'] = $row['ket'];
                    $pasing['Fd_Tgl_Dikirim'] = $row['Fd_Tgl_Dikirim'];
                    $pasing['Fd_Tgl_Diterima'] = $row['Fd_Tgl_Diterima'];
                    $pasing['umur'] = $row['umur'];
                    $pasing['piutang'] = $row['piutang'];
                    $pasing['nilai_pay'] = $row['nilai_pay'];
                    $pasing['sisa_piutang'] = $row['sisa_piutang'];
                    $pasing['Keterangan'] = $row['Keterangan'];
                    $pasing['totalpasien'] = $row['totalpasien'];


                    $rows[] = $pasing;
                }
            } elseif ($JenisInfo == '2' && $TipePenjamin == '5') {
                $this->db->query("SELECT ab.FS_KET,h.NamaPerusahaan,a.FS_kET as ket,
            ab.Fd_Tgl_Dikirim,ab.Fd_Tgl_Diterima,
            CASE
            WHEN ab.Fd_Tgl_Diterima <>'3000-01-01 00:00:00.000'
            then DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) else '-' end AS umur,
            sum(isnull(a.fn_piutang,0)) piutang,
            sum(isnull(c.NILAI_PAY,0)) nilai_pay,SUM(isnull(A.fn_sisa,0)) sisa_piutang,
            case when SUM(A.fn_sisa) = '0' then 'LUNAS' ELSE 'BELUM LUNAS' END as Keterangan,count(a.FS_KD_TAGIH) as totalpasien
            from Keuangan.DBO.TA_ORDER_PIUTANG Ab
            inner join keuangan.dbo.PIUTANG_PASIEN a
            on ab.FS_KD_TRS = a.FS_KD_TAGIH
            left join keuangan.dbo.TA_PTG_LUNAS_DTL c on c.KD_PIUTANG=a.KD_PIUTANG
            left join keuangan.dbo.TA_PTG_LUNAS_HDR d on c.FS_KD_TRS=d.FS_KD_TRS
            left join keuangan.dbo.TM_REKENING e on e.FS_KD_REKENING=a.FS_REKENING
            -- left join MasterdataSQL.dbo.MstrPerusahaanAsuransi g on g.id=a.kode_jaminan
            left join MasterdataSQL.dbo.MstrPerusahaanJPK h on h.id=a.kode_jaminan
            where A.FB_BATAL=0 and replace(CONVERT(VARCHAR(11),ab.FD_TGL_INPUT, 111), '/','-') between :TglAwal and :TglAkhir and h.ID = :NamaPenjamin
            group by ab.FS_KET, a.FS_kET,h.NamaPerusahaan,ab.Fd_Tgl_Dikirim,ab.Fd_Tgl_Diterima
            order by 2 asc , 1 asc");
                $this->db->bind('TglAwal', $TglAwal);
                $this->db->bind('TglAkhir', $TglAkhir);
                $this->db->bind('NamaPenjamin', $NamaPenjamin);

                $data =  $this->db->resultSet();

                $rows = array();
                $no = 1;

                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['FS_KET'] = $row['FS_KET'];
                    $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                    $pasing['ket'] = $row['ket'];
                    $pasing['Fd_Tgl_Dikirim'] = $row['Fd_Tgl_Dikirim'];
                    $pasing['Fd_Tgl_Diterima'] = $row['Fd_Tgl_Diterima'];
                    $pasing['umur'] = $row['umur'];
                    $pasing['piutang'] = $row['piutang'];
                    $pasing['nilai_pay'] = $row['nilai_pay'];
                    $pasing['sisa_piutang'] = $row['sisa_piutang'];
                    $pasing['Keterangan'] = $row['Keterangan'];
                    $pasing['totalpasien'] = $row['totalpasien'];


                    $rows[] = $pasing;
                }
            } elseif ($JenisInfo == '2' && $TipePenjamin == '1') {
                $this->db->query("SELECT ab.FS_KET,h.NamaPerusahaan,a.FS_kET as ket,
            ab.Fd_Tgl_Dikirim,ab.Fd_Tgl_Diterima,
            CASE
            WHEN ab.Fd_Tgl_Diterima <>'3000-01-01 00:00:00.000'
            then DATEDIFF(d, Fd_Tgl_Diterima,GETDATE()) else '-' end AS umur,
            sum(isnull(a.fn_piutang,0)) piutang,
            sum(isnull(c.NILAI_PAY,0)) nilai_pay,SUM(isnull(A.fn_sisa,0)) sisa_piutang,
            case when SUM(A.fn_sisa) = '0' then 'LUNAS' ELSE 'BELUM LUNAS' END as Keterangan,count(a.FS_KD_TAGIH) as totalpasien
            from Keuangan.DBO.TA_ORDER_PIUTANG Ab
            inner join keuangan.dbo.PIUTANG_PASIEN a
            on ab.FS_KD_TRS = a.FS_KD_TAGIH
            left join keuangan.dbo.TA_PTG_LUNAS_DTL c on c.KD_PIUTANG=a.KD_PIUTANG
            left join keuangan.dbo.TA_PTG_LUNAS_HDR d on c.FS_KD_TRS=d.FS_KD_TRS
            left join keuangan.dbo.TM_REKENING e on e.FS_KD_REKENING=a.FS_REKENING
            -- left join MasterdataSQL.dbo.MstrPerusahaanAsuransi g on g.id=a.kode_jaminan
            left join MasterdataSQL.dbo.MstrPerusahaanJPK h on h.id=a.kode_jaminan
            where A.FB_BATAL=0 and replace(CONVERT(VARCHAR(11),ab.FD_TGL_INPUT, 111), '/','-') between :TglAwal and :TglAkhir and h.ID = :NamaPenjamin
            group by ab.FS_KET, a.FS_kET,h.NamaPerusahaan,ab.Fd_Tgl_Dikirim,ab.Fd_Tgl_Diterima
            order by 2 asc , 1 asc");
                $this->db->bind('TglAwal', $TglAwal);
                $this->db->bind('TglAkhir', $TglAkhir);
                $this->db->bind('NamaPenjamin', $NamaPenjamin);

                $data =  $this->db->resultSet();

                $rows = array();
                $no = 1;

                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    $pasing['FS_KET'] = $row['FS_KET'];
                    $pasing['NamaPerusahaan'] = $row['NamaPerusahaan'];
                    $pasing['ket'] = $row['ket'];
                    $pasing['Fd_Tgl_Dikirim'] = $row['Fd_Tgl_Dikirim'];
                    $pasing['Fd_Tgl_Diterima'] = $row['Fd_Tgl_Diterima'];
                    $pasing['umur'] = $row['umur'];
                    $pasing['piutang'] = $row['piutang'];
                    $pasing['nilai_pay'] = $row['nilai_pay'];
                    $pasing['sisa_piutang'] = $row['sisa_piutang'];
                    $pasing['Keterangan'] = $row['Keterangan'];
                    $pasing['totalpasien'] = $row['totalpasien'];


                    $rows[] = $pasing;
                }
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    

    public function goGenerateSelisih($data)
    {
        try {
            $this->db->transaksi();
            $NoRegistrasi = $data['NoRegistrasi'];

            // TRIGER SEBELUM SIMPAN DATA
            // 1. TRIGER PASIEN JIKA JENIS BELUM DIISI  
            if ($NoRegistrasi == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'NoRegistrasi Kosong!',
                );
                echo json_encode($callback);
                exit;
            }
            $timenow = Date('H:i:s');

            $query_cekpiutang = "SELECT * from Keuangan.dbo.PIUTANG_PASIEN
            where NO_TRANSAKSI=:NoRegistrasi AND FB_BATAL='0'";
            $this->db->query($query_cekpiutang);
            $this->db->bind('NoRegistrasi', $NoRegistrasi);
            $datacekpiutang =  $this->db->single(); 
            if ($datacekpiutang) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Piutang sudah ada!',
                );
                echo json_encode($callback);
                exit;
            }

            $query2 = "SELECT a.FD_TGL_JURNAL,b.FN_KREDIT,c.KodeJaminan,d.[First Name],case when c.TipePasien=2  then 'Asuransi' else 'Perusahaan' end as TipeJaminan,a.FS_KET,'RJ' as TipePiutang  
            from Keuangan.dbo.TA_JURNAL_HDR a
            inner join Keuangan.dbo.TA_JURNAL_DTL b on a.FS_KD_JURNAL=b.FS_KD_JURNAL
            inner join DashboardData.dbo.dataRWJ c on b.FS_KD_REG=c.NoRegistrasi collate Latin1_General_CI_AS
			inner join MasterdataSQL.dbo.Employees d on a.FS_KD_PETUGAS=d.NoPIN collate Latin1_General_CI_AS
            where b.FS_KD_REG=:NoRegistrasi and a.FD_TGL_VOID='3000-01-01 00:00:00.000' and b.FB_VOID='0' and b.FS_REK='15400001'
            and b.FN_KREDIT>0
            union all
             select a.FD_TGL_JURNAL,b.FN_KREDIT,c.KodeJaminan,d.[First Name],case when c.TipePasien=2  then 'Asuransi' else 'Perusahaan' end as TipeJaminan,a.FS_KET,'RI' as TipePiutang  
             from Keuangan.dbo.TA_JURNAL_HDR a
            inner join Keuangan.dbo.TA_JURNAL_DTL b on a.FS_KD_JURNAL=b.FS_KD_JURNAL
            inner join DashboardData.dbo.dataRWI c on b.FS_KD_REG=c.NoRegistrasi collate Latin1_General_CI_AS
            inner join MasterdataSQL.dbo.Employees d on a.FS_KD_PETUGAS=d.NoPIN collate Latin1_General_CI_AS
            where b.FS_KD_REG=:NoRegistrasi2 and a.FD_TGL_VOID='3000-01-01 00:00:00.000' and b.FB_VOID='0' and b.FS_REK='15400001'
            and b.FN_KREDIT>0";
            $this->db->query($query2);
            $this->db->bind('NoRegistrasi', $NoRegistrasi);
            $this->db->bind('NoRegistrasi2', $NoRegistrasi);
            $datax =  $this->db->single(); 
            $tgl_payment = $datax['FD_TGL_JURNAL'];
            $totalinput = $datax['FN_KREDIT'];
            $KodeJaminan = $datax['KodeJaminan'];
            $userinput = $datax['First Name'];
            $TipeJaminan = $datax['TipeJaminan'];
            $TipePiutang = $datax['TipePiutang'];
            $FS_KET = $datax['FS_KET'];

            if (!$datax) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'NoRegistrasi Tidak Ditemukan!',
                );
                echo json_encode($callback);
                exit;
            }

            $TglTrs = date('Y-m-d', strtotime($tgl_payment));
            $formatDateJurnal = date('dmy', strtotime($tgl_payment));
            $dateTransaksi =$TglTrs.' '.$timenow;
           $kodeHT = "PU";
            $q_getlastkdpiutang = "SELECT  TOP 1 KD_PIUTANG,right(KD_PIUTANG,4) as urutregx
            FROM Keuangan.dbo.PIUTANG_PASIEN  WHERE  
            replace(CONVERT(VARCHAR(11), fd_tgL_piutang, 111), '/','-')=:TglTrs
            AND LEFT(KD_PIUTANG,2)=:kodeHT
            ORDER BY KD_PIUTANG DESC";
            $this->db->query($q_getlastkdpiutang);
            $this->db->bind('kodeHT', $kodeHT);
            $this->db->bind('TglTrs', $TglTrs);
            $data2 =  $this->db->single(); 

            $no_reg = $data2['urutregx'];  
            $idReg = $no_reg;
            $idReg++;
                  // GENERATE NO REGISTRASI
                  if(strlen($idReg)==1)
                  {
                      $noUrutJurnal = "000".$idReg;
                  }
                  else if(strlen($idReg)==2)
                  {
                      $noUrutJurnal = "00".$idReg;
                  }
                  else if(strlen($idReg)==3)
                  {
                      $noUrutJurnal = "0".$idReg;
                  }
                  else if(strlen($idReg)==4)
                  {
                      $noUrutJurnal = $idReg;
                  }
            $nofinalpiutang = $kodeHT.$formatDateJurnal.'-'.$noUrutJurnal;

            $this->db->query("INSERT INTO Keuangan.dbo.PIUTANG_PASIEN (KD_PIUTANG,fd_tgL_piutang,NO_TRANSAKSI,kode_jaminan,
            fn_piutang,fn_sisa,fs_kd_petugas,PAYMENT_NO,TipePiutang,TipeJaminan,FS_kET,FS_kET2,FS_REKENING)
            VALUES
            (:nofinalpiutang,:datetime_payment,:noreg,:idjaminan,
            :totalinput,:totalinput2,:user_id,:idkwitansi,:TipePiutang,:tipejaminan,:ket,:noreg2,:kd_rekening)");
            $this->db->bind('nofinalpiutang', $nofinalpiutang);
            $this->db->bind('datetime_payment', $tgl_payment);
            $this->db->bind('noreg', $NoRegistrasi);
            $this->db->bind('idjaminan', $KodeJaminan);
            $this->db->bind('totalinput', $totalinput);
            $this->db->bind('totalinput2', $totalinput);
            $this->db->bind('user_id', $userinput);
            $this->db->bind('idkwitansi', 0);
            $this->db->bind('TipePiutang', $TipePiutang);
            $this->db->bind('tipejaminan', $TipeJaminan);
            $this->db->bind('ket', $FS_KET);
            $this->db->bind('noreg2', $NoRegistrasi);
            $this->db->bind('kd_rekening', '15400003');
            $this->db->execute();

            $this->db->query("INSERT INTO Keuangan.dbo.PIUTANG_PASIEN_2 (kd_piutang,fn_piutang)
            VALUES
            (:nofinalpiutang,:totalinput)");
            $this->db->bind('nofinalpiutang', $nofinalpiutang);
            $this->db->bind('totalinput', $totalinput);
            $this->db->execute();
            
            $this->db->commit();
            $callback = array(
                'status' => 'success',
                'message' => 'Generate Berhasil Disimpan !',
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