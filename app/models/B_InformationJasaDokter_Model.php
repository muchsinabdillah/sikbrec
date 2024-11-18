<?php

use \Ramsey\Uiid\Uuid;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;

class B_InformationJasaDokter_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
   
    public function getDataInfo($data)
    {
        try {
            // var_dump($data);
            // exit;
            $tglawal = $data['TglAwal'];
            $tglakhir = $data['TglAkhir'];
            // $kasir = $data['kasir']; //nama kasir
            // $jenispasien = $data['jenispasien']; //pasien apa
            // $tipepembayaran = $data['tipepembayaran']; //pembayaran apa
            // $tipeinfo = $data['tipeinfo']; //jenis info apa
            // $GrupPerawatan = $data['GrupPerawatan']; //ID unit

                //PASIEN IGD
                    $query = " SELECT *FROM Keuangan.DBO.New_Info_Jasa_Medis 
                               WHERE  replace(CONVERT(VARCHAR(11),TGL_BILLING, 111), '/','-') between :tglawal  and :tglakhir
                               ORDER BY TGL_BILLING ASC, NO_REGISTRASI ASC
                    
            ";
                    $this->db->query($query);
                    $this->db->bind('tglawal', $tglawal);
                    $this->db->bind('tglakhir', $tglakhir);
                    // $this->db->bind('kasir', $kasir);
                    // $this->db->bind('pembayaran', $tipepembayaran);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    //$pasing['TglKunjungan'] = date('d-m-Y', strtotime($row['tglregisx']));
                    $pasing['TGL_BILLING'] = $row['TGL_BILLING'];
                    $pasing['NO_TRS_BILLING'] = $row['NO_TRS_BILLING'];
                    $pasing['NO_REGISTRASI'] = $row['NO_REGISTRASI'];
                    $pasing['PatientName'] = $row['PatientName'];
                    $pasing['NamaJaminan'] = $row['NamaJaminan'];
                    $pasing['NM_DR'] = $row['NM_DR'];
                    $pasing['NAMA_TARIF'] = $row['NAMA_TARIF'];
                    $pasing['TOTAL_TARIF'] = $row['TOTAL_TARIF'];
                    $pasing['nilaijasadokter'] = $row['nilaijasadokter'];
                    $rows[] = $pasing;
                }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataListInfoJasaDokter1($data)
    {
        try {
            // var_dump($data);
            // exit;
            $PeriodeAwal = $data['PeriodeAwal'];
            $PeriodeAkhir = $data['PeriodeAkhir'];
            // $kasir = $data['kasir']; //nama kasir
            // $jenispasien = $data['jenispasien']; //pasien apa
            // $tipepembayaran = $data['tipepembayaran']; //pembayaran apa
            // $tipeinfo = $data['tipeinfo']; //jenis info apa
            // $GrupPerawatan = $data['GrupPerawatan']; //ID unit

                //PASIEN IGD
                    $query = " SELECT *FROM Keuangan.DBO.New_Info_Jasa_Medis 
                               WHERE  replace(CONVERT(VARCHAR(11),TGL_BILLING, 111), '/','-') between :PeriodeAwal  and :PeriodeAkhir
                               ORDER BY TGL_BILLING ASC, NO_REGISTRASI ASC
                    
            ";
                    $this->db->query($query);
                    $this->db->bind('PeriodeAwal', $PeriodeAwal);
                    $this->db->bind('PeriodeAkhir', $PeriodeAkhir);
                    // $this->db->bind('kasir', $kasir);
                    // $this->db->bind('pembayaran', $tipepembayaran);


                $data =  $this->db->resultSet();
                $rows = array();
                $no = 1;
                foreach ($data as $row) {
                    $pasing['no'] = $no++;
                    //$pasing['TglKunjungan'] = date('d-m-Y', strtotime($row['tglregisx']));
                    $pasing['TGL_BILLING'] = $row['TGL_BILLING'];
                    $pasing['NO_TRS_BILLING'] = $row['NO_TRS_BILLING'];
                    $pasing['NO_REGISTRASI'] = $row['NO_REGISTRASI'];
                    $pasing['PatientName'] = $row['PatientName'];
                    $pasing['NamaJaminan'] = $row['NamaJaminan'];
                    $pasing['NM_DR'] = $row['NM_DR'];
                    $pasing['NAMA_TARIF'] = $row['NAMA_TARIF'];
                    $pasing['TOTAL_TARIF'] = $row['TOTAL_TARIF'];
                    $pasing['nilaijasadokter'] = $row['nilaijasadokter'];
                    $rows[] = $pasing;
                }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
