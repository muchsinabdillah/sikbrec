<?php

use \Ramsey\Uiid\Uuid;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;

class B_Info_laporan_Kasir_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getListKasir()
    {
        try {
            $this->db->query("SELECT  * from MasterdataSQL.dbo.Employees --where GroupUser='Kasir'");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['username'] = $key['username'];
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
    public function getPaymentType()
    {
        try {
            $this->db->query("SELECT ID,PaymentType,Account from PerawatanSQL.dbo.PaymentType where Status='1'");
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['PaymentType'] = $key['PaymentType'];
                $pasing['Account'] = $key['Account'];
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

    // 25/08/2024
    public function getDataLaporan($data)
    {
        try {
            $tglawal = $data['TglAwal'];
            $tglakhir = $data['TglAkhir'];
            $kasir = $data['kasir']; //nama kasir
            $jenispasien = $data['jenispasien']; //pasien apa
            $tipepembayaran = $data['tipepembayaran']; //pembayaran apa
            $tipeinfo = $data['tipeinfo']; //jenis info apa
            // $GrupPerawatan = $data['GrupPerawatan']; //ID unit

            // var_dump($kasir);
            // exit;

            if ($tipeinfo == '2') {
                //PASIEN IGD
                if ($jenispasien == '1') {

                    $query = " SELECT a.NO_TRS,a.NO_KWITANSI,a.NO_EPISODE,a.NO_REGISTRASI,a.NO_MR, b.PatientName,b.NamaJaminan,b.NamaUnit,b.NamaDokter,
                    a.TGL_TRS,a.USER_KASIR,a.NOMINAL_BAYAR as Totalbayar,x.TIPE_PEMBAYARAN,x.NAMA_TIPE_PEMBAYARAN,x.NO_KARTU_REFRENSI,x.NOMINAL_BAYAR as Nilaibaayar
                    from   Billing_Pasien.dbo.FO_T_KASIR_2  x
                    inner join Billing_Pasien.dbo.FO_T_KASIR a on x.NO_TRS_REFF = a.NO_TRS
                    inner join DashboardData.dbo.dataRWJ b
                    on a.NO_REGISTRASI collate Latin1_General_CI_AS = b.NoRegistrasi collate Latin1_General_CI_AS
                    -- inner join MasterdataSQL.dbo.Employees c on a.USER_KASIR collate Latin1_General_CI_AS = c.username collate Latin1_General_CI_AS
                    where a.BATAL='0' and replace(CONVERT(VARCHAR(11), a.TGL_TRS, 111), '/','-') between :tglawal and :tglakhir and b.Batal='0' and USER_KASIR=:kasir and TIPE_PEMBAYARAN=:pembayaran AND IdUnit ='1'
                    order by  a.TGL_TRS asc
            ";
                    $this->db->query($query);
                    $this->db->bind('tglawal', $tglawal);
                    $this->db->bind('tglakhir', $tglakhir);
                    $this->db->bind('kasir', $kasir);
                    $this->db->bind('pembayaran', $tipepembayaran);
                } elseif ($jenispasien == '4') {
                    $query = " SELECT a.NO_TRS,a.NO_KWITANSI,a.NO_EPISODE,a.NO_REGISTRASI,a.NO_MR, b.PatientName,b.NamaJaminan,b.NamaUnit,b.NamaDokter,
                    a.TGL_TRS,a.USER_KASIR,a.NOMINAL_BAYAR as Totalbayar,x.TIPE_PEMBAYARAN,x.NAMA_TIPE_PEMBAYARAN,x.NO_KARTU_REFRENSI,x.NOMINAL_BAYAR as Nilaibaayar
                    from   Billing_Pasien.dbo.FO_T_KASIR_2  x
                    inner join Billing_Pasien.dbo.FO_T_KASIR a on x.NO_TRS_REFF = a.NO_TRS
                    inner join DashboardData.dbo.dataRWJ b
                    on a.NO_REGISTRASI collate Latin1_General_CI_AS = b.NoRegistrasi collate Latin1_General_CI_AS
                    -- inner join MasterdataSQL.dbo.Employees c on a.USER_KASIR collate Latin1_General_CI_AS = c.username collate Latin1_General_CI_AS
                    where a.BATAL='0' and replace(CONVERT(VARCHAR(11), a.TGL_TRS, 111), '/','-') between :tglawal and :tglakhir and b.Batal='0' and USER_KASIR=:kasir and TIPE_PEMBAYARAN=:pembayaran AND IdUnit not in ('1','29','9','10','47','48','49','53','103')
                    order by  a.TGL_TRS asc
            ";
                    $this->db->query($query);
                    $this->db->bind('tglawal', $tglawal);
                    $this->db->bind('tglakhir', $tglakhir);
                    $this->db->bind('kasir', $kasir);
                    $this->db->bind('pembayaran', $tipepembayaran);
                } elseif ($jenispasien == '3') {
                    $query = " SELECT a.NO_TRS,a.NO_KWITANSI,a.NO_EPISODE,a.NO_REGISTRASI,a.NO_MR, b.PatientName,b.NamaJaminan,b.NamaUnit,b.NamaDokter,
                    a.TGL_TRS,a.USER_KASIR,a.NOMINAL_BAYAR as Totalbayar,x.TIPE_PEMBAYARAN,x.NAMA_TIPE_PEMBAYARAN,x.NO_KARTU_REFRENSI,x.NOMINAL_BAYAR as Nilaibaayar
                    from   Billing_Pasien.dbo.FO_T_KASIR_2  x
                    inner join Billing_Pasien.dbo.FO_T_KASIR a on x.NO_TRS_REFF = a.NO_TRS
                    inner join DashboardData.dbo.dataRWJ b
                    on a.NO_REGISTRASI collate Latin1_General_CI_AS = b.NoRegistrasi collate Latin1_General_CI_AS
                    -- inner join MasterdataSQL.dbo.Employees c on a.USER_KASIR collate Latin1_General_CI_AS = c.username collate Latin1_General_CI_AS
                    where a.BATAL='0' and replace(CONVERT(VARCHAR(11), a.TGL_TRS, 111), '/','-') between :tglawal and :tglakhir and b.Batal='0' and USER_KASIR=:kasir and TIPE_PEMBAYARAN=:pembayaran
order by  a.TGL_TRS asc
            ";
                    $this->db->query($query);
                    $this->db->bind('tglawal', $tglawal);
                    $this->db->bind('tglakhir', $tglakhir);
                    $this->db->bind('kasir', $kasir);
                    $this->db->bind('pembayaran', $tipepembayaran);
                } elseif ($jenispasien == '2') { //RAWAT inap
                    $query = " SELECT a.NO_TRS,a.NO_KWITANSI,a.NO_EPISODE,a.NO_REGISTRASI,a.NO_MR, b.PatientName,b.NamaJaminan,b.NamaUnit,b.NamaDokter,
                    a.TGL_TRS,a.USER_KASIR,a.NOMINAL_BAYAR as Totalbayar,x.TIPE_PEMBAYARAN,x.NAMA_TIPE_PEMBAYARAN,x.NO_KARTU_REFRENSI,x.NOMINAL_BAYAR as Nilaibaayar
                    from   Billing_Pasien.dbo.FO_T_KASIR_2  x
                    inner join Billing_Pasien.dbo.FO_T_KASIR a on x.NO_TRS_REFF = a.NO_TRS
                    inner join DashboardData.dbo.dataRWJ b
                    on a.NO_REGISTRASI collate Latin1_General_CI_AS = b.NoRegistrasi collate Latin1_General_CI_AS
                    -- inner join MasterdataSQL.dbo.Employees c on a.USER_KASIR collate Latin1_General_CI_AS = c.username collate Latin1_General_CI_AS
                    where a.BATAL='0' and replace(CONVERT(VARCHAR(11), a.TGL_TRS, 111), '/','-') between :tglawal and :tglakhir and b.Batal='0' and USER_KASIR=:kasir and TIPE_PEMBAYARAN=:pembayaran AND IdUnit in ('82','83','84','85','86','87','88','89','90')
                    order by  a.TGL_TRS asc
            ";
                    $this->db->query($query);
                    $this->db->bind('tglawal', $tglawal);
                    $this->db->bind('tglakhir', $tglakhir);
                    $this->db->bind('kasir', $kasir);
                    $this->db->bind('pembayaran', $tipepembayaran);
                }

                $data =  $this->db->resultSet();
                $rows = array();
                $no = 0;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    //$pasing['TglKunjungan'] = date('d-m-Y', strtotime($row['tglregisx']));
                    $pasing['NoTransaksi'] = $row['NO_TRS'];
                    $pasing['NoKwitansi'] = $row['NO_KWITANSI'];
                    $pasing['NoEpisode'] = $row['NO_EPISODE'];
                    $pasing['NoReg'] = $row['NO_REGISTRASI'];
                    $pasing['NoMR'] = $row['NO_MR'];
                    $pasing['NamaPasien'] = $row['PatientName'];
                    $pasing['NamaJaminan'] = $row['NamaJaminan'];
                    $pasing['Nama_Unit'] = $row['NamaUnit'];
                    $pasing['Nama_Dokter'] = $row['NamaDokter'];
                    $pasing['TGL_Transaksi'] = date('d-m-Y', strtotime($row['TGL_TRS']));
                    $pasing['User_Kasir'] = $row['USER_KASIR'];
                    $pasing['Total_Bayar'] = $row['Totalbayar'];
                    $pasing['Tipe_Pembayaran'] = $row['TIPE_PEMBAYARAN'];
                    $pasing['Nama_Perusahaan'] = $row['NAMA_TIPE_PEMBAYARAN'];
                    $pasing['Nomor_Kartu'] = $row['NO_KARTU_REFRENSI'];
                    $pasing['Nominal_Bayar'] = $row['Nilaibaayar'];
                    $rows[] = $pasing;
                }
                //return $rows;
            } elseif ($tipeinfo == '1') {

                if ($jenispasien == '1') {
                    $query = " SELECT a.NO_TRS,a.NO_KWITANSI,a.NO_EPISODE,a.NO_REGISTRASI,a.NO_MR, b.PatientName,b.NamaJaminan,b.NamaUnit,b.NamaDokter,
                        a.TGL_TRS,a.USER_KASIR,a.NOMINAL_BAYAR,a.CASH,a.DEBIT,a.KREDIT,a.PIUTANG,a.QRIS
                        from  Billing_Pasien.dbo.FO_T_KASIR a
                        inner join DashboardData.dbo.dataRWJ b
                        on a.NO_REGISTRASI collate Latin1_General_CI_AS = b.NoRegistrasi collate Latin1_General_CI_AS
                        where a.BATAL='0' and replace(CONVERT(VARCHAR(11), a.TGL_TRS, 111), '/','-') between :tglawal and :tglakhir and b.Batal='0' and USER_KASIR=:kasir and b.Batal='0' AND IdUnit ='1'
                        order by  a.TGL_TRS asc
                ";
                    $this->db->query($query);
                    $this->db->bind('tglawal', $tglawal);
                    $this->db->bind('tglakhir', $tglakhir);
                    $this->db->bind('kasir', $kasir);
                } elseif ($jenispasien == '4') {
                    $query = " SELECT a.NO_TRS,a.NO_KWITANSI,a.NO_EPISODE,a.NO_REGISTRASI,a.NO_MR, b.PatientName,b.NamaJaminan,b.NamaUnit,b.NamaDokter,
                            a.TGL_TRS,a.USER_KASIR,a.NOMINAL_BAYAR,a.CASH,a.DEBIT,a.KREDIT,a.PIUTANG,a.QRIS
                            from  Billing_Pasien.dbo.FO_T_KASIR a
                            inner join DashboardData.dbo.dataRWJ b
                            on a.NO_REGISTRASI collate Latin1_General_CI_AS = b.NoRegistrasi collate Latin1_General_CI_AS
                            where a.BATAL='0' and replace(CONVERT(VARCHAR(11), a.TGL_TRS, 111), '/','-') between :tglawal and :tglakhir and b.Batal='0' and USER_KASIR=:kasir and b.Batal='0' AND IdUnit not in ('1','29','9','10','47','48','49','53','103')
                            order by  a.TGL_TRS asc
                    ";
                    $this->db->query($query);
                    $this->db->bind('tglawal', $tglawal);
                    $this->db->bind('tglakhir', $tglakhir);
                    $this->db->bind('kasir', $kasir);
                } elseif ($jenispasien == '3') {
                    $query = " SELECT a.NO_TRS,a.NO_KWITANSI,a.NO_EPISODE,a.NO_REGISTRASI,a.NO_MR, b.PatientName,b.NamaJaminan,b.NamaUnit,b.NamaDokter,
                            a.TGL_TRS,a.USER_KASIR,a.NOMINAL_BAYAR,a.CASH,a.DEBIT,a.KREDIT,a.PIUTANG,a.QRIS
                            from  Billing_Pasien.dbo.FO_T_KASIR a
                            left join DashboardData.dbo.dataRWJ b
                            on a.NO_REGISTRASI collate Latin1_General_CI_AS = b.NoRegistrasi collate Latin1_General_CI_AS and b.Batal='0'
                            where a.BATAL='0' and replace(CONVERT(VARCHAR(11), a.TGL_TRS, 111), '/','-') between :tglawal and :tglakhir  and USER_KASIR=:kasir  
                            order by  a.TGL_TRS asc
                    ";
                    $this->db->query($query);
                    $this->db->bind('tglawal', $tglawal);
                    $this->db->bind('tglakhir', $tglakhir);
                    $this->db->bind('kasir', $kasir);
                } elseif ($jenispasien == '2') {
                    $query = " SELECT a.NO_TRS,a.NO_KWITANSI,a.NO_EPISODE,a.NO_REGISTRASI,a.NO_MR, b.PatientName,b.NamaJaminan,b.NamaUnit,b.NamaDokter,
                            a.TGL_TRS,a.USER_KASIR,a.NOMINAL_BAYAR,a.CASH,a.DEBIT,a.KREDIT,a.PIUTANG,a.QRIS
                            from  Billing_Pasien.dbo.FO_T_KASIR a
                            inner join DashboardData.dbo.dataRWJ b
                            on a.NO_REGISTRASI collate Latin1_General_CI_AS = b.NoRegistrasi collate Latin1_General_CI_AS
                            where a.BATAL='0' and replace(CONVERT(VARCHAR(11), a.TGL_TRS, 111), '/','-') between :tglawal and :tglakhir and b.Batal='0' and USER_KASIR=:kasir and b.Batal='0' and IdUnit in ('82','83','84','85','86','87','88','89','90')
                            order by  a.TGL_TRS asc
                    ";
                    $this->db->query($query);
                    $this->db->bind('tglawal', $tglawal);
                    $this->db->bind('tglakhir', $tglakhir);
                    $this->db->bind('kasir', $kasir);
                }

                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    //$pasing['TglKunjungan'] = date('d-m-Y', strtotime($row['tglregisx']));
                    $pasing['NoTransaksi'] = $row['NO_TRS'];
                    $pasing['NoKwitansi'] = $row['NO_KWITANSI'];
                    $pasing['NoEpisode'] = $row['NO_EPISODE'];
                    $pasing['NoReg'] = $row['NO_REGISTRASI'];
                    $pasing['NoMR'] = $row['NO_MR'];
                    $pasing['NamaPasien'] = $row['PatientName'];
                    $pasing['NamaJaminan'] = $row['NamaJaminan'];
                    $pasing['Nama_Unit'] = $row['NamaUnit'];
                    $pasing['Nama_Dokter'] = $row['NamaDokter'];
                    $pasing['TGL_Transaksi'] = date('d-m-Y', strtotime($row['TGL_TRS']));
                    $pasing['User_Kasir'] = $row['USER_KASIR'];
                    $pasing['Nominal_Bayar'] = $row['NOMINAL_BAYAR'];
                    $pasing['Cash'] = $row['CASH'];
                    $pasing['Debit'] = $row['DEBIT'];
                    $pasing['Kredit'] = $row['KREDIT'];
                    $pasing['Piutang'] = $row['PIUTANG'];
                    $pasing['Qris'] = $row['QRIS'];
                    $rows[] = $pasing;
                }
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataLaporanHdr($data)
    {
        try {

            $tglawal = $data['TglAwal'];
            $tglakhir = $data['TglAkhir'];
            $kasir = $data['kasir']; //nama kasir
            $jenispasien = $data['jenispasien']; //pasien apa

            if ($jenispasien == '1') {
                $jenispasien = 'IGD';
            }
            if ($jenispasien == '2') {
                $jenispasien = 'Rawat Inap';
            }
            if ($jenispasien == '3') {
                $jenispasien = 'Rawat Jalan ALL';
            }
            if ($jenispasien == '4') {
                $jenispasien = 'Poliklinik';
            }

            $tipepembayaran = $data['tipepembayaran']; //pembayaran apa
            $tipeinfo = $data['tipeinfo']; //jenis info apa

            if ($tipeinfo == '1') {
                $tipepembayaran = 'ALL';
            }

            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $namauserx = $session->name;

            // $this->db->query("SELECT [Status ID] as StatusID FROM PerawatanSQL.dbo.Visit WHERE NoRegistrasi = :norega1
            // UNION ALL SELECT StatusID FROM RawatInapSQL.dbo.Inpatient WHERE NoRegRI = :norega2 ");
            // $this->db->bind('norega1', $noreg);
            // $this->db->bind('norega2', $noreg);
            // $dataStatusId =  $this->db->single();
            // $statusID = $dataStatusId['StatusID'];

            $pasing['TglAwal'] = $tglawal;
            $pasing['TglAkhir'] = $tglakhir;
            $pasing['kasir'] = $kasir;
            $pasing['jenispasien'] = $jenispasien;
            $pasing['tipepembayaran'] = $tipepembayaran;
            $pasing['tipeinfo'] = $tipeinfo;
            $pasing['dateCreate'] = $datenowx;
            $pasing['userCreate'] = $namauserx;

            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
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
    // 25/08/2024

    //15-11-2024
    public function getHeaderCetakan()
    {
        try {
            $session = SessionManager::getCurrentSession();
            $datenowx = Utils::datenowcreateNotFull();
            $datenowcreate = Utils::seCurrentDateTime();
            $namauserx = $session->name;

            $this->db->query("SELECT * FROM MasterdataSQL.dbo.A_DATA_RS");
            $data =  $this->db->single();
            $pasing['ID'] = $data['ID'];
            $pasing['NamaRS'] = $data['NamaRS'];
            $pasing['KodeRS'] = $data['KodeRS'];
            $pasing['KodeRSBPJS'] = $data['KodeRSBPJS'];
            $pasing['AlamatRS'] = $data['AlamatRS'];
            $pasing['Website'] = $data['Website'];
            $pasing['Phone'] = $data['Phone'];
            $pasing['Email'] = $data['Email'];
            $pasing['Fax'] = $data['Fax'];
            $pasing['RT'] = $data['RT'];
            $pasing['RW'] = $data['RW'];
            $pasing['ProvinsiCode'] = $data['ProvinsiCode'];
            $pasing['ProvinsiName'] = $data['ProvinsiName'];
            $pasing['KotaCode'] = $data['KotaCode'];
            $pasing['KotaName'] = $data['KotaName'];
            $pasing['KecamtanCode'] = $data['KecamtanCode'];
            $pasing['KecamatanName'] = $data['KecamatanName'];
            $pasing['KelurahanCode'] = $data['KelurahanCode'];
            $pasing['KelurahanName'] = $data['KelurahanName'];
            $pasing['Kodepos'] = $data['Kodepos'];
            $pasing['Longitude'] = $data['Longitude'];
            $pasing['Latitude'] = $data['Latitude'];
            $pasing['Bridging_SatuSehat'] = $data['Bridging_SatuSehat'];

            return $pasing;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }


}
