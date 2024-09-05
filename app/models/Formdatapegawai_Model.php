<?php

use \Ramsey\Uiid\Uuid;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;

class Formdatapegawai_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getListFormdatapegawai()
    {
        try {

            $query = "SELECT * from HRDYARSI.dbo.[Data Pegawai]";
            $this->db->query($query);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {
                // $pasing['NO'] = $No++;
                $pasing['ID_Data'] = $row['ID_Data'];
                $pasing['NIK'] = $row['Nip'];
                $pasing['NAMA'] = $row['Nama'];
                $pasing['Jenis_Pog'] = $row['Jenis_Pegawai'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDatapegawai($data)
    {
        try {
            // var_dump($data);
            $IDs = $data['id'];
            $this->db->query("SELECT Nip,Nama,Jenis_Pegawai
                            FROM HRDYARSI.dbo.[Data Pegawai] where ID_Data=:ID_Data");
            $this->db->bind('ID_Data', $IDs);
            $data =  $this->db->single();
            //var_dump($data);exit;
            // $pasing['No'] = $data['NO'];
            $pasing['Nip'] = $data['Nip'];
            $pasing['Nama'] = $data['Nama'];
            $pasing['Jenis_Pegawai'] = $data['Jenis_Pegawai'];
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

    //badrul
    public function getDataKeluargaDetail($data)
    {
        try {
            // var_dump($data);

            //SELECT a.Id_data, Nip,Nama, b.Jenis_Pegawai, [Nama Keluarga],Tgl_Lahir,FileDocument,
            //[Status Keluarga],Tpt_Lahir,JenisDocument From HRDYARSI.dbo.Keluarga a
            //inner join HRDYARSI.dbo.[Data Pegawai] b on a.Id_data=b.ID_Data where Id_Keluarga = :IDs
            //replace(CONVERT(VARCHAR(11), a.Tgl_Lahir, 111), '/','-') as a.Tgl_Lahir
            $IDs = $data['id'];
            $this->db->query("SELECT a.Id_data, Nip,Nama, b.Jenis_Pegawai,a.Tpt_Lahir,replace(CONVERT(VARCHAR(11), a.Tgl_Lahir, 111), '/','-') as Tgl_Lahir, [Nama Keluarga] as NamaKeluarga, [Status Keluarga] as StatusKeluarga, a.JenisDocument From HRDYARSI.dbo.Keluarga a
            inner join HRDYARSI.dbo.[Data Pegawai] b on a.Id_data=b.ID_Data where Id_Keluarga = :IDs");
            $this->db->bind('IDs', $IDs);
            $data =  $this->db->single();
            //var_dump($data);exit;
            // $pasing['No'] = $data['NO'];
            $pasing['JenisDocument'] = $data['JenisDocument'];
            $pasing['StatusKeluarga'] = $data['StatusKeluarga'];
            $pasing['NamaKeluarga'] = $data['NamaKeluarga'];
            $pasing['Tgl_Lahir'] = $data['Tgl_Lahir'];
            $pasing['Tpt_Lahir'] = $data['Tpt_Lahir'];
            $pasing['Id_data'] = $data['Id_data'];
            $pasing['Nip'] = $data['Nip'];
            $pasing['Nama'] = $data['Nama'];
            $pasing['Jenis_Pegawai'] = $data['Jenis_Pegawai'];
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            // var_dump($pasing);
            // exit;
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

    public function getDataPendidikanDetail($data)
    {
        try {
            // var_dump($data);
            // exit;

            //SELECT a.Id_data, Nip,Nama, b.Jenis_Pegawai, [Nama Keluarga],Tgl_Lahir,FileDocument,
            //[Status Keluarga],Tpt_Lahir,JenisDocument From HRDYARSI.dbo.Keluarga a
            //inner join HRDYARSI.dbo.[Data Pegawai] b on a.Id_data=b.ID_Data where Id_Keluarga = :IDs
            //replace(CONVERT(VARCHAR(11), a.Tgl_Lahir, 111), '/','-') as a.Tgl_Lahir

            
            $IDs = $data['id'];
            // var_dump($IDs);
            // exit;

            $this->db->query("SELECT a.NIP,b.Nip,Nama, b.Jenis_Pegawai, Jenis_Pendidikan, Nama_Pendidikan, replace(CONVERT(VARCHAR(11), a.Tahun_Lulus, 111), '/','-') as Tahun_Lulus, a.Jurusan, a.JenisDocument From HRDYARSI.dbo.[Data Pendidikan] a
            inner join HRDYARSI.dbo.[Data Pegawai] b on  a.NIP = b.ID_Data where ID = :IDs");
            $this->db->bind('IDs', $IDs);
            $data =  $this->db->single();
            //var_dump($data);exit;
            // $pasing['No'] = $data['NO'];
            $pasing['JenisDocument'] = $data['JenisDocument'];
            // $pasing['StatusKeluarga'] = $data['StatusKeluarga'];
            $pasing['Jurusan'] = $data['Jurusan'];
            $pasing['Tahun_Lulus'] = $data['Tahun_Lulus'];
            // $pasing['Tpt_Lahir'] = $data['Tpt_Lahir'];
            $pasing['Jenis_Pendidikan'] = $data['Jenis_Pendidikan'];
            $pasing['Nama_Pendidikan'] = $data['Nama_Pendidikan'];
            $pasing['NIP'] = $data['NIP'];
            $pasing['Nip'] = $data['Nip'];
            $pasing['Nama'] = $data['Nama'];
            $pasing['Jenis_Pegawai'] = $data['Jenis_Pegawai'];
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            // var_dump($pasing);
            // exit;
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

    public function getDataPelatihanDetail($data)
    {
        try {
            // var_dump($data);

            //SELECT a.Id_data, Nip,Nama, b.Jenis_Pegawai, [Nama Keluarga],Tgl_Lahir,FileDocument,
            //[Status Keluarga],Tpt_Lahir,JenisDocument From HRDYARSI.dbo.Keluarga a
            //inner join HRDYARSI.dbo.[Data Pegawai] b on a.Id_data=b.ID_Data where Id_Keluarga = :IDs
            //replace(CONVERT(VARCHAR(11), a.Tgl_Lahir, 111), '/','-') as a.Tgl_Lahir

                // [Id_data]
    //        ,[Jenis_Pelatihan]
    //        ,[Nama_Pelatihan]
    //        ,[Tgl_Awal]
    //        ,[Tgl_Akhir]
    //        ,[Alamat_Pelatihan]
    //        ,[Lama_Pelatihan_Internal]
    //        ,[No_Sertifikat]
    //        ,[JenisDocument]
    //        ,[FileDocument]
    //        ,[Extension]
    //        ,[date_update]
    //        ,[user_update]
    //        ,[Provider])

    
            $IDs = $data['id'];
            $this->db->query("SELECT a.Id_Data, Nip, Nama, Jenis_Pegawai, a.Jenis_Pelatihan, a.Nama_Pelatihan, a.Alamat_Pelatihan, a.Lama_Pelatihan_Internal, a.No_Sertifikat, a.JenisDocument, replace(CONVERT(VARCHAR(11), a.Tgl_Awal, 111), '/','-') as Tgl_Awal, replace(CONVERT(VARCHAR(11), a.Tgl_Akhir, 111), '/','-') as Tgl_Akhir From HRDYARSI.dbo.[Data Pelatihan] a
            inner join HRDYARSI.dbo.[Data Pegawai] b on a.Id_Data=b.ID_Data where Id_Pelatihan = :IDs");
            $this->db->bind('IDs', $IDs);
            $data =  $this->db->single();
            //var_dump($data);exit;
            // $pasing['No_Sertifikat'] = $data['No_Sertifikat'];
            $pasing['Tgl_Akhir'] = $data['Tgl_Akhir'];
            $pasing['Tgl_Awal'] = $data['Tgl_Awal'];
            $pasing['JenisDocument'] = $data['JenisDocument'];
            
            $pasing['No_Sertifikat'] = $data['No_Sertifikat'];
            $pasing['JenisDocument'] = $data['JenisDocument'];
            $pasing['Lama_Pelatihan_Internal'] = $data['Lama_Pelatihan_Internal'];
            $pasing['Alamat_Pelatihan'] = $data['Alamat_Pelatihan'];
            $pasing['Nama_Pelatihan'] = $data['Nama_Pelatihan'];
            $pasing['Jenis_Pelatihan'] = $data['Jenis_Pelatihan'];
            
            $pasing['Id_Data'] = $data['Id_Data'];
            $pasing['Nip'] = $data['Nip'];
            $pasing['Nama'] = $data['Nama'];
            $pasing['Jenis_Pegawai'] = $data['Jenis_Pegawai'];
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            // var_dump($pasing);
            // exit;
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

    public function getDataSIPDetail($data)
    {
        try {
            // var_dump($data);


            // ([Id_data]
            // ,[Tgl_Awal]
            // ,[Tgl_Akhir]
            // ,[No_SIP]
            // ,[JenisDocument]
            // ,[FileDocument]
            // ,[Extension]
            // ,[date_update]
            // ,[user_update]
            // ,[Provider])

            $IDs = $data['id'];
            $this->db->query("SELECT a.Id_data,replace(CONVERT(VARCHAR(11), a.Tgl_Awal, 111), '/','-') as Tgl_Awal, replace(CONVERT(VARCHAR(11), a.Tgl_Akhir, 111), '/','-') as Tgl_Akhir, No_SIP, Nama, Nip, Jenis_Pegawai, a.JenisDocument From HRDYARSI.dbo.SIP a
            inner join HRDYARSI.dbo.[Data Pegawai] b on a.Id_data=b.ID_Data where Id_trs = :IDs");
            $this->db->bind('IDs', $IDs);
            $data =  $this->db->single();
            //var_dump($data);exit;
            // $pasing['No_Sertifikat'] = $data['No_Sertifikat'];
            $pasing['Tgl_Awal'] = $data['Tgl_Awal'];
            $pasing['Tgl_Akhir'] = $data['Tgl_Akhir'];
            $pasing['No_SIP'] = $data['No_SIP'];
            
            // $pasing['No_Sertifikat'] = $data['No_Sertifikat'];
            $pasing['JenisDocument'] = $data['JenisDocument'];
            // $pasing['Lama_Pelatihan_Internal'] = $data['Lama_Pelatihan_Internal'];
            // $pasing['Alamat_Pelatihan'] = $data['Alamat_Pelatihan'];
            // $pasing['Nama_Pelatihan'] = $data['Nama_Pelatihan'];
            // $pasing['Jenis_Pelatihan'] = $data['Jenis_Pelatihan'];
            
            $pasing['Id_data'] = $data['Id_data'];
            $pasing['Nip'] = $data['Nip'];
            $pasing['Nama'] = $data['Nama'];
            $pasing['Jenis_Pegawai'] = $data['Jenis_Pegawai'];
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            // var_dump($pasing);
            // exit;
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

    public function getDataPribadiDetail($data)
    {
        try {

            $IDs = $data['id'];
            $this->db->query("SELECT a.Id_data, Nama, Nip, Jenis_Pegawai, a.JenisDocument From HRDYARSI.dbo.Data_Pribadi a
            inner join HRDYARSI.dbo.[Data Pegawai] b on a.Id_data=b.ID_Data where Id_trs = :IDs");
            $this->db->bind('IDs', $IDs);
            $data =  $this->db->single();
            //var_dump($data);exit;
            // $pasing['No_Sertifikat'] = $data['No_Sertifikat'];
            // $pasing['Tgl_Awal'] = $data['Tgl_Awal'];
            // $pasing['Tgl_Akhir'] = $data['Tgl_Akhir'];
            // $pasing['No_SIP'] = $data['No_SIP'];
            
            // $pasing['No_Sertifikat'] = $data['No_Sertifikat'];
            $pasing['JenisDocument'] = $data['JenisDocument'];
            // $pasing['Lama_Pelatihan_Internal'] = $data['Lama_Pelatihan_Internal'];
            // $pasing['Alamat_Pelatihan'] = $data['Alamat_Pelatihan'];
            // $pasing['Nama_Pelatihan'] = $data['Nama_Pelatihan'];
            // $pasing['Jenis_Pelatihan'] = $data['Jenis_Pelatihan'];
            
            $pasing['Id_data'] = $data['Id_data'];
            $pasing['Nip'] = $data['Nip'];
            $pasing['Nama'] = $data['Nama'];
            $pasing['Jenis_Pegawai'] = $data['Jenis_Pegawai'];
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            // var_dump($pasing);
            // exit;
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

    public function getDataRKKDetail($data)
    {
        try {

            $IDs = $data['id'];
            $this->db->query("SELECT a.Id_data, Nama, Nip, Jenis_Pegawai, a.JenisDocument From HRDYARSI.dbo.RKK a
            inner join HRDYARSI.dbo.[Data Pegawai] b on a.Id_data=b.ID_Data where Id_trs = :IDs");
            $this->db->bind('IDs', $IDs);
            $data =  $this->db->single();
            //var_dump($data);exit;
            // $pasing['No_Sertifikat'] = $data['No_Sertifikat'];
            // $pasing['Tgl_Awal'] = $data['Tgl_Awal'];
            // $pasing['Tgl_Akhir'] = $data['Tgl_Akhir'];
            // $pasing['No_SIP'] = $data['No_SIP'];
            
            // $pasing['No_Sertifikat'] = $data['No_Sertifikat'];
            $pasing['JenisDocument'] = $data['JenisDocument'];
            // $pasing['Lama_Pelatihan_Internal'] = $data['Lama_Pelatihan_Internal'];
            // $pasing['Alamat_Pelatihan'] = $data['Alamat_Pelatihan'];
            // $pasing['Nama_Pelatihan'] = $data['Nama_Pelatihan'];
            // $pasing['Jenis_Pelatihan'] = $data['Jenis_Pelatihan'];
            
            $pasing['Id_data'] = $data['Id_data'];
            $pasing['Nip'] = $data['Nip'];
            $pasing['Nama'] = $data['Nama'];
            $pasing['Jenis_Pegawai'] = $data['Jenis_Pegawai'];
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            // var_dump($pasing);
            // exit;
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

    public function getDataSPKDetail($data)
    {
        try {
            $IDs = $data['id'];
            $this->db->query("SELECT a.Id_data, Nama, Nip, Jenis_Pegawai, a.JenisDocument From HRDYARSI.dbo.SPK a
            inner join HRDYARSI.dbo.[Data Pegawai] b on a.Id_data=b.ID_Data where Id_trs = :IDs");
            $this->db->bind('IDs', $IDs);
            $data =  $this->db->single();
            //var_dump($data);exit;
            // $pasing['No_Sertifikat'] = $data['No_Sertifikat'];
            // $pasing['Tgl_Awal'] = $data['Tgl_Awal'];
            // $pasing['Tgl_Akhir'] = $data['Tgl_Akhir'];
            // $pasing['No_SIP'] = $data['No_SIP'];
            
            // $pasing['No_Sertifikat'] = $data['No_Sertifikat'];
            $pasing['JenisDocument'] = $data['JenisDocument'];
            // $pasing['Lama_Pelatihan_Internal'] = $data['Lama_Pelatihan_Internal'];
            // $pasing['Alamat_Pelatihan'] = $data['Alamat_Pelatihan'];
            // $pasing['Nama_Pelatihan'] = $data['Nama_Pelatihan'];
            // $pasing['Jenis_Pelatihan'] = $data['Jenis_Pelatihan'];
            
            $pasing['Id_data'] = $data['Id_data'];
            $pasing['Nip'] = $data['Nip'];
            $pasing['Nama'] = $data['Nama'];
            $pasing['Jenis_Pegawai'] = $data['Jenis_Pegawai'];
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            // var_dump($pasing);
            // exit;
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


    public function getDataSTRDetail($data)
    {
        try {

            $IDs = $data['id'];
            $this->db->query("SELECT a.Id_data,replace(CONVERT(VARCHAR(11), a.Tgl_Awal, 111), '/','-') as Tgl_Awal, replace(CONVERT(VARCHAR(11), a.Tgl_Akhir, 111), '/','-') as Tgl_Akhir, No_STR, Nama, Nip, Jenis_Pegawai, a.JenisDocument From HRDYARSI.dbo.STR a
            inner join HRDYARSI.dbo.[Data Pegawai] b on a.Id_data=b.ID_Data where Id_trs = :IDs");
            $this->db->bind('IDs', $IDs);
            $data =  $this->db->single();
            //var_dump($data);exit;
            // $pasing['No_Sertifikat'] = $data['No_Sertifikat'];
            $pasing['Tgl_Awal'] = $data['Tgl_Awal'];
            $pasing['Tgl_Akhir'] = $data['Tgl_Akhir'];
            $pasing['No_STR'] = $data['No_STR'];
            
            // $pasing['No_Sertifikat'] = $data['No_Sertifikat'];
            $pasing['JenisDocument'] = $data['JenisDocument'];
            // $pasing['Lama_Pelatihan_Internal'] = $data['Lama_Pelatihan_Internal'];
            // $pasing['Alamat_Pelatihan'] = $data['Alamat_Pelatihan'];
            // $pasing['Nama_Pelatihan'] = $data['Nama_Pelatihan'];
            // $pasing['Jenis_Pelatihan'] = $data['Jenis_Pelatihan'];
            
            $pasing['Id_data'] = $data['Id_data'];
            $pasing['Nip'] = $data['Nip'];
            $pasing['Nama'] = $data['Nama'];
            $pasing['Jenis_Pegawai'] = $data['Jenis_Pegawai'];
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            // var_dump($pasing);
            // exit;
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
    
    public function getDataMCUDetail($data)
    {
        try {

            
//var_dump($data);
// exit;

           // ([Id_data]
    //     ,[tglMCU]
    //     ,[tglHasil]
    //     ,[Keterangan]
    //     ,[JenisDocument]
    //     ,[FileDocument]
    //     ,[Extension]
    //     ,[date_update]
    //     ,[user_update]
    //     ,[Provider])

            $IDs = $data['id'];
            $this->db->query("SELECT a.Id_Data,replace(CONVERT(VARCHAR(11), a.tglMCU, 111), '/','-') as tglMCU, replace(CONVERT(VARCHAR(11), a.tglHasil, 111), '/','-') as tglHasil, Keterangan, Nama, Nip, Jenis_Pegawai From HRDYARSI.dbo.[Data MCU] a
            inner join HRDYARSI.dbo.[Data Pegawai] b on a.Id_Data = b.ID_Data where ID = :IDs");
            $this->db->bind('IDs', $IDs);
            $data =  $this->db->single();
            //var_dump($data);exit;
            // $pasing['No_Sertifikat'] = $data['No_Sertifikat'];


            $pasing['tglMCU'] = $data['tglMCU'];
            $pasing['tglHasil'] = $data['tglHasil'];
            $pasing['Keterangan'] = $data['Keterangan'];
            
            // $pasing['No_Sertifikat'] = $data['No_Sertifikat'];
            // $pasing['JenisDocument'] = $data['JenisDocument'];
            // $pasing['Lama_Pelatihan_Internal'] = $data['Lama_Pelatihan_Internal'];
            // $pasing['Alamat_Pelatihan'] = $data['Alamat_Pelatihan'];
            // $pasing['Nama_Pelatihan'] = $data['Nama_Pelatihan'];
            // $pasing['Jenis_Pelatihan'] = $data['Jenis_Pelatihan'];
            
            $pasing['Id_Data'] = $data['Id_Data'];
            $pasing['Nip'] = $data['Nip'];
            $pasing['Nama'] = $data['Nama'];
            $pasing['Jenis_Pegawai'] = $data['Jenis_Pegawai'];
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            // var_dump($pasing);
            // exit;
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

    public function getDataMOUDetail($data)
    {
        try {

            
// var_dump($data);
// exit;

            // ([Id_data]
    //     ,[TglAwal]
    //     ,[TglAkhir]
    //     ,[Keterangan]
    //     ,[JenisDocument]
    //     ,[FileDocument]
    //     ,[Extension]
    //     ,[date_update]
    //     ,[user_update]
    //     ,[Provider])

            $IDs = $data['id'];
            $this->db->query("SELECT a.Id_Data,replace(CONVERT(VARCHAR(11), a.TglAwal, 111), '/','-') as TglAwal, replace(CONVERT(VARCHAR(11), a.TglAkhir, 111), '/','-') as TglAkhir, Keterangan, Nama, Nip, Jenis_Pegawai, a.JenisDocument From HRDYARSI.dbo.[Data MOU] a
            inner join HRDYARSI.dbo.[Data Pegawai] b on a.Id_Data = b.ID_Data where ID = :IDs");
            $this->db->bind('IDs', $IDs);
            $data =  $this->db->single();
            //var_dump($data);exit;
            // $pasing['No_Sertifikat'] = $data['No_Sertifikat'];


            $pasing['TglAwal'] = $data['TglAwal'];
            $pasing['TglAkhir'] = $data['TglAkhir'];
            $pasing['Keterangan'] = $data['Keterangan'];
            
            // $pasing['No_Sertifikat'] = $data['No_Sertifikat'];
            $pasing['JenisDocument'] = $data['JenisDocument'];
            // $pasing['Lama_Pelatihan_Internal'] = $data['Lama_Pelatihan_Internal'];
            // $pasing['Alamat_Pelatihan'] = $data['Alamat_Pelatihan'];
            // $pasing['Nama_Pelatihan'] = $data['Nama_Pelatihan'];
            // $pasing['Jenis_Pelatihan'] = $data['Jenis_Pelatihan'];
            
            $pasing['Id_Data'] = $data['Id_Data'];
            $pasing['Nip'] = $data['Nip'];
            $pasing['Nama'] = $data['Nama'];
            $pasing['Jenis_Pegawai'] = $data['Jenis_Pegawai'];
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            // var_dump($pasing);
            // exit;
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

    public function getDataSKPegawaiDetail($data)
    {
        try {

            
// var_dump($data);
// exit;

        // ([Id_data]
    // ,[TglAwal]
    // ,[TglAkhir]
    // ,[Keterangan]
    // ,[JenisDocument]
    // ,[FileDocument]
    // ,[Extension]
    // ,[date_update]
    // ,[user_update]
    // ,[Provider])

            $IDs = $data['id'];
            $this->db->query("SELECT a.Id_Data,replace(CONVERT(VARCHAR(11), a.TglAwal, 111), '/','-') as TglAwal, replace(CONVERT(VARCHAR(11), a.TglAkhir, 111), '/','-') as TglAkhir, Keterangan, Nama, Nip, Jenis_Pegawai, a.JenisDocument From HRDYARSI.dbo.[Data SKPegawai] a
            inner join HRDYARSI.dbo.[Data Pegawai] b on a.Id_Data = b.ID_Data where ID = :IDs");
            $this->db->bind('IDs', $IDs);
            $data =  $this->db->single();
            //var_dump($data);exit;
            // $pasing['No_Sertifikat'] = $data['No_Sertifikat'];


            $pasing['TglAwal'] = $data['TglAwal'];
            $pasing['TglAkhir'] = $data['TglAkhir'];
            $pasing['Keterangan'] = $data['Keterangan'];
            
            // $pasing['No_Sertifikat'] = $data['No_Sertifikat'];
            $pasing['JenisDocument'] = $data['JenisDocument'];
            // $pasing['Lama_Pelatihan_Internal'] = $data['Lama_Pelatihan_Internal'];
            // $pasing['Alamat_Pelatihan'] = $data['Alamat_Pelatihan'];
            // $pasing['Nama_Pelatihan'] = $data['Nama_Pelatihan'];
            // $pasing['Jenis_Pelatihan'] = $data['Jenis_Pelatihan'];
            
            $pasing['Id_Data'] = $data['Id_Data'];
            $pasing['Nip'] = $data['Nip'];
            $pasing['Nama'] = $data['Nama'];
            $pasing['Jenis_Pegawai'] = $data['Jenis_Pegawai'];
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            // var_dump($pasing);
            // exit;
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


    

    //badrul

    public function uploadDataPribadi($data)
    {


        // Jika user telah mengklik tombol Preview

        //$ip = ; // Ambil IP Address dari User 
        $doc_nomr = $data['nikPegawai'];
    if( isset($_FILES['file']['tmp_name'])){
            
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png", "pdf" => "application/pdf");
        $filetype = $_FILES["file"]["type"];
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
        $tmp_file = $_FILES['file']['tmp_name'];

        
        
        // Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
        if (in_array($filetype, $allowed)) {
            $bytes = random_bytes(20);
            $nama_file_baru  =     $doc_nomr . bin2hex($bytes) . "-" . date("YmdHis") . '.' . $ext;
            if (move_uploaded_file($tmp_file,  __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru)) {

                /// AWS
                // Create an S3Client
                $s3Client = new S3Client([
                    'version' => 'latest',
                    'region'  => 'ap-southeast-1',
                    'http'    => ['verify' => false],
                    'credentials' => [
                        'key'    => 'AKIAYV2M6ERJGUKK4QWQ',
                        'secret' => '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'
                    ]
                ]);
                $file_name = __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru;
                $source =   $file_name;
                $awsImages = '';
                $handle = fopen($source, 'r');
                try {
                    $bucket = 'rsuyarsibucket';
                    $key = basename($file_name);
                    $result = $s3Client->putObject([
                        'Bucket' => $bucket,
                        'Key'    => 'hrd/dataPribadi/' . $key,
                        'Body'   => $handle,
                        'ACL'    => 'public-read', // make file 'public', 
                    ]);
                    $awsImages = $result->get('ObjectURL');

                    //close filenya
                    fclose($handle);
                    //hapus filenya 
                    unlink($_SERVER["DOCUMENT_ROOT"].'SIKBREC/public/tmp/'.$nama_file_baru);

                    return $this->SaveTTD_Pribadi($data,  $nama_file_baru, $awsImages, $ext);
                } catch (MultipartUploadException $e) {

                    return $e->getMessage();
                }
            } else {
                $callback = array(
                    'status' => 'warning',
                    'message' => 'Upload Failed.',
                );
                return $callback;
            }
        } else { // Jika file yang diupload bukan File Excel 2007 (.xlsx)
            // Munculkan pesan validasi 
            $callback = array(
                'status' => 'warning',
                'message' => ' File Tidak Support.',
                '$ext' => $ext,
                ' $allowed' =>  $allowed,
            );
            return $callback;
        }

    }else{
           
        $filetype = "";
        $ext = ""; // Ambil ekstensi filenya apa
        $tmp_file = "";
        $nama_file_baru = "";
        $awsImages = "";
        return $this->SaveTTD_Pribadi($data,  $nama_file_baru, $awsImages, $ext);
    }
    
    }

    public function uploadDataRKK($data)
    {


        // Jika user telah mengklik tombol Preview

        //$ip = ; // Ambil IP Address dari User 
        $doc_nomr = $data['nikPegawai'];
    if( isset($_FILES['file']['tmp_name'])){
            
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png", "pdf" => "application/pdf");
        $filetype = $_FILES["file"]["type"];
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
        $tmp_file = $_FILES['file']['tmp_name'];

        
        
        // Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
        if (in_array($filetype, $allowed)) {
            $bytes = random_bytes(20);
            $nama_file_baru  =     $doc_nomr . bin2hex($bytes) . "-" . date("YmdHis") . '.' . $ext;
            if (move_uploaded_file($tmp_file,  __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru)) {

                /// AWS
                // Create an S3Client
                $s3Client = new S3Client([
                    'version' => 'latest',
                    'region'  => 'ap-southeast-1',
                    'http'    => ['verify' => false],
                    'credentials' => [
                        'key'    => 'AKIAYV2M6ERJGUKK4QWQ',
                        'secret' => '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'
                    ]
                ]);
                $file_name = __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru;
                $source =   $file_name;
                $awsImages = '';
                $handle = fopen($source, 'r');
                try {
                    $bucket = 'rsuyarsibucket';
                    $key = basename($file_name);
                    $result = $s3Client->putObject([
                        'Bucket' => $bucket,
                        'Key'    => 'hrd/dataRKK/' . $key,
                        'Body'   => $handle,
                        'ACL'    => 'public-read', // make file 'public', 
                    ]);
                    $awsImages = $result->get('ObjectURL');

                    //close filenya
                    fclose($handle);
                    //hapus filenya 
                    unlink($_SERVER["DOCUMENT_ROOT"].'SIKBREC/public/tmp/'.$nama_file_baru);

                    return $this->SaveTTD_RKK($data,  $nama_file_baru, $awsImages, $ext);
                } catch (MultipartUploadException $e) {

                    return $e->getMessage();
                }
            } else {
                $callback = array(
                    'status' => 'warning',
                    'message' => 'Upload Failed.',
                );
                return $callback;
            }
        } else { // Jika file yang diupload bukan File Excel 2007 (.xlsx)
            // Munculkan pesan validasi 
            $callback = array(
                'status' => 'warning',
                'message' => ' File Tidak Support.',
                '$ext' => $ext,
                ' $allowed' =>  $allowed,
            );
            return $callback;
        }

    }else{
           
        $filetype = "";
        $ext = ""; // Ambil ekstensi filenya apa
        $tmp_file = "";
        $nama_file_baru = "";
        $awsImages = "";
        return $this->SaveTTD_RKK($data,  $nama_file_baru, $awsImages, $ext);
    }
    
    }

    public function uploadDataSPK($data)
    {


        // Jika user telah mengklik tombol Preview

        //$ip = ; // Ambil IP Address dari User 
        $doc_nomr = $data['nikPegawai'];
    if( isset($_FILES['file']['tmp_name'])){
            
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png", "pdf" => "application/pdf");
        $filetype = $_FILES["file"]["type"];
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
        $tmp_file = $_FILES['file']['tmp_name'];

        
        
        // Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
        if (in_array($filetype, $allowed)) {
            $bytes = random_bytes(20);
            $nama_file_baru  =     $doc_nomr . bin2hex($bytes) . "-" . date("YmdHis") . '.' . $ext;
            if (move_uploaded_file($tmp_file,  __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru)) {

                /// AWS
                // Create an S3Client
                $s3Client = new S3Client([
                    'version' => 'latest',
                    'region'  => 'ap-southeast-1',
                    'http'    => ['verify' => false],
                    'credentials' => [
                        'key'    => 'AKIAYV2M6ERJGUKK4QWQ',
                        'secret' => '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'
                    ]
                ]);
                $file_name = __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru;
                $source =   $file_name;
                $awsImages = '';
                $handle = fopen($source, 'r');
                try {
                    $bucket = 'rsuyarsibucket';
                    $key = basename($file_name);
                    $result = $s3Client->putObject([
                        'Bucket' => $bucket,
                        'Key'    => 'hrd/dataSPK/' . $key,
                        'Body'   => $handle,
                        'ACL'    => 'public-read', // make file 'public', 
                    ]);
                    $awsImages = $result->get('ObjectURL');

                    //close filenya
                    fclose($handle);
                    //hapus filenya 
                    unlink($_SERVER["DOCUMENT_ROOT"].'SIKBREC/public/tmp/'.$nama_file_baru);

                    return $this->SaveTTD_SPK($data,  $nama_file_baru, $awsImages, $ext);
                } catch (MultipartUploadException $e) {

                    return $e->getMessage();
                }
            } else {
                $callback = array(
                    'status' => 'warning',
                    'message' => 'Upload Failed.',
                );
                return $callback;
            }
        } else { // Jika file yang diupload bukan File Excel 2007 (.xlsx)
            // Munculkan pesan validasi 
            $callback = array(
                'status' => 'warning',
                'message' => ' File Tidak Support.',
                '$ext' => $ext,
                ' $allowed' =>  $allowed,
            );
            return $callback;
        }

    }else{
           
        $filetype = "";
        $ext = ""; // Ambil ekstensi filenya apa
        $tmp_file = "";
        $nama_file_baru = "";
        $awsImages = "";
        return $this->SaveTTD_SPK($data,  $nama_file_baru, $awsImages, $ext);
    }
    
    }
    
    public function uploadDataKeluarga($data)
    {
        // Jika user telah mengklik tombol Preview

        //$ip = ; // Ambil IP Address dari User 
        $doc_nomr = $data['nikPegawai'];
        // var_dump($data);
        // exit;
        
        if ($data['jeniskeluarga'] == ""){
            $callback = array(
                'status' => 'warning',
                'message' => 'Status Keluarga Kosong !',
            );
            return $callback;
            exit;
        }

        if( isset($_FILES['file']['tmp_name'])){

        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png", "pdf" => "application/pdf");
        $filetype = $_FILES["file"]["type"];
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
        $tmp_file = $_FILES['file']['tmp_name'];

        // $this->db->transaksi();
        // Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
        if (in_array($filetype, $allowed)) {
            $bytes = random_bytes(20);
            $nama_file_baru  =     $doc_nomr . bin2hex($bytes) . "-" . date("YmdHis") . '.' . $ext;
            if (move_uploaded_file($tmp_file,  __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru)) {

                /// AWS
                // Create an S3Client
                $s3Client = new S3Client([
                    'version' => 'latest',
                    'region'  => 'ap-southeast-1',
                    'http'    => ['verify' => false],
                    'credentials' => [
                        'key'    => 'AKIAYV2M6ERJGUKK4QWQ',
                        'secret' => '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'
                    ]
                ]);
                $file_name = __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru;
                $source =   $file_name;
                $awsImages = '';
                $handle = fopen($source, 'r');
                try {
                    $bucket = 'rsuyarsibucket';
                    $key = basename($file_name);
                    $result = $s3Client->putObject([
                        'Bucket' => $bucket,
                        'Key'    => 'hrd/datakeluarga/' . $key,
                        'Body'   => $handle,
                        'ACL'    => 'public-read', // make file 'public', 
                    ]);
                    $awsImages = $result->get('ObjectURL');

                    //close filenya
                    fclose($handle);
                    //hapus filenya 
                    unlink($_SERVER["DOCUMENT_ROOT"].'SIKBREC/public/tmp/'.$nama_file_baru);
                    
                    // var_dump($data);
                    // exit;
                    return $this->SaveTTD($data,  $nama_file_baru, $awsImages, $ext);
                } catch (MultipartUploadException $e) {

                    return $e->getMessage();
                }
            } else {
                $callback = array(
                    'status' => 'warning',
                    'message' => 'Upload Failed.',
                );
                return $callback;
            }
        } else { // Jika file yang diupload bukan File Excel 2007 (.xlsx)
            // Munculkan pesan validasi 
            $callback = array(
                'status' => 'warning',
                'message' => ' File Tidak Support.',
                '$ext' => $ext,
                ' $allowed' =>  $allowed,
            );
            return $callback;
        }
        
        }else{
            $filetype = "";
            $ext = ""; // Ambil ekstensi filenya apa
            $tmp_file = "";
            $nama_file_baru = "";
            $awsImages = "";
            return $this->SaveTTD($data,  $nama_file_baru, $awsImages, $ext);
        }
    }

    public function uploadDataPendidikan($data)
    {


        // Jika user telah mengklik tombol Preview

        //$ip = ; // Ambil IP Address dari User 
        $doc_nomr = $data['nikPegawai'];
        if( isset($_FILES['file']['tmp_name'])){

        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png", "pdf" => "application/pdf");
        $filetype = $_FILES["file"]["type"];
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
        $tmp_file = $_FILES['file']['tmp_name'];

        // Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
        if (in_array($filetype, $allowed)) {
            $bytes = random_bytes(20);
            $nama_file_baru  =     $doc_nomr . bin2hex($bytes) . "-" . date("YmdHis") . '.' . $ext;
            if (move_uploaded_file($tmp_file,  __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru)) {

                /// AWS
                // Create an S3Client
                $s3Client = new S3Client([
                    'version' => 'latest',
                    'region'  => 'ap-southeast-1',
                    'http'    => ['verify' => false],
                    'credentials' => [
                        'key'    => 'AKIAYV2M6ERJGUKK4QWQ',
                        'secret' => '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'
                    ]
                ]);
                $file_name = __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru;
                $source =   $file_name;
                $awsImages = '';
                $handle = fopen($source, 'r');
                try {
                    $bucket = 'rsuyarsibucket';
                    $key = basename($file_name);
                    $result = $s3Client->putObject([
                        'Bucket' => $bucket,
                        'Key'    => 'hrd/dataPendidikan/' . $key, //nanti diganti
                        'Body'   => $handle,
                        'ACL'    => 'public-read', // make file 'public', 
                    ]);
                    $awsImages = $result->get('ObjectURL');

                    //close filenya
                    fclose($handle);
                    //hapus filenya 
                    unlink($_SERVER["DOCUMENT_ROOT"].'SIKBREC/public/tmp/'.$nama_file_baru);

                    return $this->SaveTTD_Pendidikan($data,  $nama_file_baru, $awsImages, $ext);
                } catch (MultipartUploadException $e) {

                    return $e->getMessage();
                }
            } else {
                $callback = array(
                    'status' => 'warning',
                    'message' => 'Upload Failed.',
                );
                return $callback;
            }
        } else { // Jika file yang diupload bukan File Excel 2007 (.xlsx)
            // Munculkan pesan validasi 
            $callback = array(
                'status' => 'warning',
                'message' => ' File Tidak Support.',
                '$ext' => $ext,
                ' $allowed' =>  $allowed,
            );
            return $callback;
        }

        
        }else{
                
            $filetype = "";
            $ext = ""; // Ambil ekstensi filenya apa
            $tmp_file = "";
            $nama_file_baru = "";
            $awsImages = "";
            return $this->SaveTTD_Pendidikan($data,  $nama_file_baru, $awsImages, $ext);
        }
    }

    public function uploadDataPelatihan($data)
    {


        // Jika user telah mengklik tombol Preview

        //$ip = ; // Ambil IP Address dari User 
        $doc_nomr = $data['nikPegawai'];
        if( isset($_FILES['file']['tmp_name'])){
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png", "pdf" => "application/pdf");
        $filetype = $_FILES["file"]["type"];
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
        $tmp_file = $_FILES['file']['tmp_name'];

        // Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
        if (in_array($filetype, $allowed)) {
            $bytes = random_bytes(20);
            $nama_file_baru  =     $doc_nomr . bin2hex($bytes) . "-" . date("YmdHis") . '.' . $ext;
            if (move_uploaded_file($tmp_file,  __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru)) {

                /// AWS
                // Create an S3Client
                $s3Client = new S3Client([
                    'version' => 'latest',
                    'region'  => 'ap-southeast-1',
                    'http'    => ['verify' => false],
                    'credentials' => [
                        'key'    => 'AKIAYV2M6ERJGUKK4QWQ',
                        'secret' => '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'
                    ]
                ]);
                $file_name = __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru;
                $source =   $file_name;
                $awsImages = '';
                $handle = fopen($source, 'r');
                try {
                    $bucket = 'rsuyarsibucket';
                    $key = basename($file_name);
                    $result = $s3Client->putObject([
                        'Bucket' => $bucket,
                        'Key'    => 'hrd/datakeluarga/' . $key,
                        'Body'   => $handle,
                        'ACL'    => 'public-read', // make file 'public', 
                    ]);
                    $awsImages = $result->get('ObjectURL');

                    //close filenya
                    fclose($handle);
                    //hapus filenya 
                    unlink($_SERVER["DOCUMENT_ROOT"].'SIKBREC/public/tmp/'.$nama_file_baru);

                    return $this->SaveTTD_Pelatihan($data,  $nama_file_baru, $awsImages, $ext);
                } catch (MultipartUploadException $e) {

                    return $e->getMessage();
                }
            } else {
                $callback = array(
                    'status' => 'warning',
                    'message' => 'Upload Failed.',
                );
                return $callback;
            }
        } else { // Jika file yang diupload bukan File Excel 2007 (.xlsx)
            // Munculkan pesan validasi 
            $callback = array(
                'status' => 'warning',
                'message' => ' File Tidak Support.',
                '$ext' => $ext,
                ' $allowed' =>  $allowed,
            );
            return $callback;
        }

    }else{
           
        $filetype = "";
        $ext = ""; // Ambil ekstensi filenya apa
        $tmp_file = "";
        $nama_file_baru = "";
        $awsImages = "";
        return $this->SaveTTD_Pelatihan($data,  $nama_file_baru, $awsImages, $ext);
    }
    }

    public function uploadDataSIP($data)
    {


        // Jika user telah mengklik tombol Preview

        //$ip = ; // Ambil IP Address dari User 
        $doc_nomr = $data['nikPegawai'];
    if( isset($_FILES['file']['tmp_name'])){
            
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png", "pdf" => "application/pdf");
        $filetype = $_FILES["file"]["type"];
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
        $tmp_file = $_FILES['file']['tmp_name'];

        
        
        // Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
        if (in_array($filetype, $allowed)) {
            $bytes = random_bytes(20);
            $nama_file_baru  =     $doc_nomr . bin2hex($bytes) . "-" . date("YmdHis") . '.' . $ext;
            if (move_uploaded_file($tmp_file,  __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru)) {

                /// AWS
                // Create an S3Client
                $s3Client = new S3Client([
                    'version' => 'latest',
                    'region'  => 'ap-southeast-1',
                    'http'    => ['verify' => false],
                    'credentials' => [
                        'key'    => 'AKIAYV2M6ERJGUKK4QWQ',
                        'secret' => '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'
                    ]
                ]);
                $file_name = __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru;
                $source =   $file_name;
                $awsImages = '';
                $handle = fopen($source, 'r');
                try {
                    $bucket = 'rsuyarsibucket';
                    $key = basename($file_name);
                    $result = $s3Client->putObject([
                        'Bucket' => $bucket,
                        'Key'    => 'hrd/dataSIP/' . $key,
                        'Body'   => $handle,
                        'ACL'    => 'public-read', // make file 'public', 
                    ]);
                    $awsImages = $result->get('ObjectURL');

                    //close filenya
                    fclose($handle);
                    //hapus filenya 
                    unlink($_SERVER["DOCUMENT_ROOT"].'SIKBREC/public/tmp/'.$nama_file_baru);

                    return $this->SaveTTD_SIP($data,  $nama_file_baru, $awsImages, $ext);
                } catch (MultipartUploadException $e) {

                    return $e->getMessage();
                }
            } else {
                $callback = array(
                    'status' => 'warning',
                    'message' => 'Upload Failed.',
                );
                return $callback;
            }
        } else { // Jika file yang diupload bukan File Excel 2007 (.xlsx)
            // Munculkan pesan validasi 
            $callback = array(
                'status' => 'warning',
                'message' => ' File Tidak Support.',
                '$ext' => $ext,
                ' $allowed' =>  $allowed,
            );
            return $callback;
        }

    }else{
           
        $filetype = "";
        $ext = ""; // Ambil ekstensi filenya apa
        $tmp_file = "";
        $nama_file_baru = "";
        $awsImages = "";
        return $this->SaveTTD_SIP($data,  $nama_file_baru, $awsImages, $ext);
    }
    }

    public function uploadDataSTR($data)
    {


        // Jika user telah mengklik tombol Preview

        //$ip = ; // Ambil IP Address dari User 
        $doc_nomr = $data['nikPegawai'];

       
        // cek ada ga file ?
        if( isset($_FILES['file']['tmp_name'])){
            $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png", "pdf" => "application/pdf");
            $filetype = $_FILES["file"]["type"];
            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
            $tmp_file = $_FILES['file']['tmp_name'];

             // Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
                if (in_array($filetype, $allowed)) {
                    $bytes = random_bytes(20);
                    $nama_file_baru  =     $doc_nomr . bin2hex($bytes) . "-" . date("YmdHis") . '.' . $ext;
                    if (move_uploaded_file($tmp_file,  __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru)) {

                        /// AWS
                        // Create an S3Client
                        $s3Client = new S3Client([
                            'version' => 'latest',
                            'region'  => 'ap-southeast-1',
                            'http'    => ['verify' => false],
                            'credentials' => [
                                'key'    => 'AKIAYV2M6ERJGUKK4QWQ',
                                'secret' => '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'
                            ]
                        ]);
                        $file_name = __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru;
                        $source =   $file_name;
                        $awsImages = '';
                        $handle = fopen($source, 'r');
                        try {
                            $bucket = 'rsuyarsibucket';
                            $key = basename($file_name);
                            $result = $s3Client->putObject([
                                'Bucket' => $bucket,
                                'Key'    => 'hrd/dataSTR/' . $key,
                                'Body'   => $handle,
                                'ACL'    => 'public-read', // make file 'public', 
                            ]);
                            $awsImages = $result->get('ObjectURL');

                            //close filenya
                            fclose($handle);
                            //hapus filenya 
                            unlink($_SERVER["DOCUMENT_ROOT"].'SIKBREC/public/tmp/'.$nama_file_baru);

                            return $this->SaveTTD_STR($data,  $nama_file_baru, $awsImages, $ext);
                        } catch (MultipartUploadException $e) {

                            return $e->getMessage();
                        }
                    } else {
                        $callback = array(
                            'status' => 'warning',
                            'message' => 'Upload Failed.',
                        );
                        return $callback;
                    }
                } else { // Jika file yang diupload bukan File Excel 2007 (.xlsx)
                    // Munculkan pesan validasi 
                    $callback = array(
                        'status' => 'warning',
                        'message' => ' File Tidak Support.',
                        '$ext' => $ext,
                        ' $allowed' =>  $allowed,
                    );
                    return $callback;
                }
        
        }else{
           
            $filetype = "";
            $ext = ""; // Ambil ekstensi filenya apa
            $tmp_file = "";
            $nama_file_baru = "";
            $awsImages = "";
            return $this->SaveTTD_STR($data,  $nama_file_baru, $awsImages, $ext);
        }
       
    }

    public function SaveTTD($data,  $nama_file_baru, $awsImages, $ext)
    {
        // unlink(__DIR__ . '/../../public' . '/tmp/' . $nama_file_baru); // Hapus file tersebut 
        
       
        if($data['iddatax'] == null){

            // var_dump($data);
            //     exit;

            $query = "INSERT INTO HRDYARSI.[dbo].Keluarga
            (
            Id_data,
            [Nama Keluarga],
            Tgl_Lahir,
            FileDocument,
            [Status Keluarga],
            Tpt_Lahir,
            JenisDocument,
            Extension,
            date_update,
            user_update,
            Provider
            )
            VALUES
            ( 
            :Id_data,
            :Nama,
            :Tgl_Lahir,
            :FileDocument,
            :statuskeluarga,
            :Tpt_Lahir,
            :JenisDocument,
            :EXTENSION,
            :date_update,
            :user_update,
            :Provider
            ) ";

                try {
                $this->db->transaksi();
                $ro = "aws";
                $datetime = Utils::seCurrentDateTime();
                $session = SessionManager::getCurrentSession();
                $userid = $session->username;
                $token = $session->token;
                $namauserx = $session->name;
                $operator =  $session->IDEmployee;
                $this->db->query($query);
                $this->db->bind('Id_data', $data['iddata']);
                $this->db->bind('Nama', $data['namakeluarga']);
                $this->db->bind('Tgl_Lahir', $data['tgllahir']);

                $this->db->bind('FileDocument', $awsImages);

                $this->db->bind('statuskeluarga', $data['jeniskeluarga']);
                $this->db->bind('Tpt_Lahir', $data['tptkerja']);
                $this->db->bind('JenisDocument', $data['jenisdoc']);

                $this->db->bind('Provider', $ro);
                $this->db->bind('date_update', $datetime);
                $this->db->bind('user_update', $namauserx);
                $this->db->bind('EXTENSION', $ext);
                $this->db->execute();
                $this->db->Commit();
                $callback = array(
                    'status' => 'success',
                    'message' => ' Upload Data Succesfully.',
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

        }else{
            // $this->db->transaksi();
            try{
                // $this->db->transaksi();
                // var_dump($data);
                // var_dump($nama_file_baru);
                // var_dump($awsImages);
                // var_dump($ext);
                // exit;

                
                $id = $data['iddatax'];
                $nama = $data['namakeluarga'];
                $Tgl_Lahir = $data['tgllahir'];
                $FileDocument = $awsImages;
                $statuskeluarga = $data['jeniskeluarga'];
                $Tpt_Lahir = $data['tptkerja'];
                $JenisDocument = $data['jenisdoc'];
                $EXTENSION = $ext;
            

    
                $this->db->transaksi();
                $this->db->query("UPDATE HRDYARSI.[dbo].Keluarga SET 
                [Nama Keluarga] = :nama,
                Tgl_Lahir = :Tgl_Lahir,
                FileDocument = :FileDocument,
                [Status Keluarga] = :statuskeluarga,
                Tpt_Lahir = :Tpt_Lahir,
                JenisDocument = :JenisDocument,
                Extension = :EXTENSION
                WHERE Id_Keluarga=:id");


                $this->db->bind('id', $data['iddatax']);
                $this->db->bind('nama', $data['namakeluarga']);
                $this->db->bind('Tgl_Lahir', $data['tgllahir']);
                $this->db->bind('statuskeluarga', $data['jeniskeluarga']);
                $this->db->bind('Tpt_Lahir', $data['tptkerja']);
                $this->db->bind('JenisDocument', $data['jenisdoc']);
                $this->db->bind('FileDocument', $awsImages);
                $this->db->bind('EXTENSION', $ext);

                // var_dump($nama);
                // var_dump($FileDocument);
                // exit;
                
                // $this->db->bind('EXTENSION', $ext);
                $this->db->execute();
                $this->db->commit();
                $callback = array(
                    'status' => 'success', // Set array status dengan success   
                    'message' => 'Transkasi Berhasil!', // Set array status dengan success

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
    }

    public function uploadDataMCU($data)
    {


        // Jika user telah mengklik tombol Preview

        //$ip = ; // Ambil IP Address dari User 
        $doc_nomr = $data['nikPegawai'];
        
        if( isset($_FILES['file']['tmp_name'])){

        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png", "pdf" => "application/pdf");
        $filetype = $_FILES["file"]["type"];
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
        $tmp_file = $_FILES['file']['tmp_name'];

        // Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
        if (in_array($filetype, $allowed)) {
            $bytes = random_bytes(20);
            $nama_file_baru  =     $doc_nomr . bin2hex($bytes) . "-" . date("YmdHis") . '.' . $ext;
            if (move_uploaded_file($tmp_file,  __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru)) {

                /// AWS
                // Create an S3Client
                $s3Client = new S3Client([
                    'version' => 'latest',
                    'region'  => 'ap-southeast-1',
                    'http'    => ['verify' => false],
                    'credentials' => [
                        'key'    => 'AKIAYV2M6ERJGUKK4QWQ',
                        'secret' => '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'
                    ]
                ]);
                $file_name = __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru;
                $source =   $file_name;
                $awsImages = '';
                $handle = fopen($source, 'r');
                try {
                    $bucket = 'rsuyarsibucket';
                    $key = basename($file_name);
                    $result = $s3Client->putObject([
                        'Bucket' => $bucket,
                        'Key'    => 'hrd/dataMCU/' . $key,
                        'Body'   => $handle,
                        'ACL'    => 'public-read', // make file 'public', 
                    ]);
                    $awsImages = $result->get('ObjectURL');

                    //close filenya
                    fclose($handle);
                    //hapus filenya 
                    unlink($_SERVER["DOCUMENT_ROOT"].'SIKBREC/public/tmp/'.$nama_file_baru);

                    return $this->SaveTTD_MCU($data,  $nama_file_baru, $awsImages, $ext);
                } catch (MultipartUploadException $e) {

                    return $e->getMessage();
                }
            } else {
                $callback = array(
                    'status' => 'warning',
                    'message' => 'Upload Failed.',
                );
                return $callback;
            }
        } else { // Jika file yang diupload bukan File Excel 2007 (.xlsx)
            // Munculkan pesan validasi 
            $callback = array(
                'status' => 'warning',
                'message' => ' File Tidak Support.',
                '$ext' => $ext,
                ' $allowed' =>  $allowed,
            );
            return $callback;
        }
    }else{
           
        $filetype = "";
        $ext = ""; // Ambil ekstensi filenya apa
        $tmp_file = "";
        $nama_file_baru = "";
        $awsImages = "";
        return $this->SaveTTD_MCU($data,  $nama_file_baru, $awsImages, $ext);
    }
    }

//badrul
    public function SaveTTD_Pendidikan($data,  $nama_file_baru, $awsImages, $ext)
    {
         //unlink(__DIR__ . '/../../public' . '/tmp/' . $nama_file_baru); // Hapus file tersebut 

        // var_dump($data);
        if($data['iddatax'] == null){
            $query = "INSERT INTO HRDYARSI.[dbo].[Data Pendidikan]
            ([NIP]
            ,[Jenis_Pendidikan]
            ,[Nama_Pendidikan]
            ,[Jurusan]
            ,[Tahun_Lulus]
            ,[JenisDocument]
            ,[FileDocument]
            ,[Extension]
            ,[date_update]
            ,[user_update]
            ,[Provider])
             VALUES
            ( :Id_data,
            :jenisPendidikan,
            :tptInst,
            :jurusan,
            :tglLulus,
            :JenisDocument,
            :FileDocument,
            :EXTENSION,
            :date_update,
            :user_update,
            :Provider) ";
         try {
             $this->db->transaksi();
             $ro = "aws";
             $datetime = Utils::seCurrentDateTime();
             $session = SessionManager::getCurrentSession();
             $userid = $session->username;
             $token = $session->token;
             $namauserx = $session->name;
             $operator =  $session->IDEmployee;
             $this->db->query($query);
 
             $this->db->bind('Id_data', $data['iddata']);
             $this->db->bind('jenisPendidikan', $data['jenisPendidikan']);
             $this->db->bind('tptInst', $data['tptInst']);
 
             $this->db->bind('FileDocument', $awsImages);
 
             $this->db->bind('tglLulus', $data['tglLulus']);
             $this->db->bind('jurusan', $data['jurusan']);
             $this->db->bind('JenisDocument', $data['jenisdoc']);
 
             $this->db->bind('Provider', $ro);
             $this->db->bind('date_update', $datetime);
             $this->db->bind('user_update', $namauserx);
             $this->db->bind('EXTENSION', $ext);
             $this->db->execute();
             $this->db->Commit();
             $callback = array(
                 'status' => 'success',
                 'message' => ' Upload Data Succesfully.',
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
        else{
            try{
                // $this->db->transaksi();
                // var_dump($data);
                // var_dump($nama_file_baru);
                // var_dump($awsImages);
                // var_dump($ext);
                // exit;

            //     ([NIP]
            // ,[Jenis_Pendidikan]
            // ,[Nama_Pendidikan]
            // ,[Jurusan]
            // ,[Tahun_Lulus]
            // ,[JenisDocument]
            // ,[FileDocument]
            // ,[Extension]
            // ,[date_update]
            // ,[user_update]
            // ,[Provider])

                // var_dump($data);
                // exit;
                
                $id = $data['iddatax'];
                $jenisPendidikan = $data['jenisPendidikan'];
                $tptInst = $data['tptInst'];
                $FileDocument = $awsImages;
                $tglLulus = $data['tglLulus'];
                $jurusan = $data['jurusan'];
                $JenisDocument = $data['jenisdoc'];
                $EXTENSION = $ext;
            
                
    
                $this->db->transaksi();
                $this->db->query("UPDATE HRDYARSI.[dbo].[Data Pendidikan] SET 
                Jenis_Pendidikan = :jenisPendidikan,
                Nama_Pendidikan = :tptInst,
                FileDocument = :FileDocument,
                Tahun_Lulus = :tglLulus,
                Jurusan = :jurusan,
                JenisDocument = :JenisDocument,
                Extension = :EXTENSION
                WHERE ID=:id");


                $this->db->bind('id', $data['iddatax']);
                $this->db->bind('jenisPendidikan', $data['jenisPendidikan']);
                $this->db->bind('tptInst', $data['tptInst']);
                $this->db->bind('tglLulus', $data['tglLulus']);
                // $this->db->bind('Tpt_Lahir', $data['Tpt_Lahir']);
                $this->db->bind('jurusan', $data['jurusan']);
                $this->db->bind('JenisDocument', $data['jenisdoc']);
                $this->db->bind('FileDocument', $awsImages);
                $this->db->bind('EXTENSION', $ext);

                // var_dump($nama);
                // var_dump($FileDocument);
                // exit;
                
                // $this->db->bind('EXTENSION', $ext);
                $this->db->execute();
                $this->db->commit();
                $callback = array(
                    'status' => 'success', // Set array status dengan success   
                    'message' => 'Transkasi Berhasil!', // Set array status dengan success    
                    
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
        
    }

//badrul

    public function SaveTTD_Pelatihan($data,  $nama_file_baru, $awsImages, $ext)
    {
         //unlink(__DIR__ . '/../../public' . '/tmp/' . $nama_file_baru); // Hapus file tersebut 
         if($data['iddatax'] == null){
            $query = "INSERT INTO HRDYARSI.[dbo].[Data Pelatihan]
           ([Id_data]
           ,[Jenis_Pelatihan]
           ,[Nama_Pelatihan]
           ,[Tgl_Awal]
           ,[Tgl_Akhir]
           ,[Alamat_Pelatihan]
           ,[Lama_Pelatihan_Internal]
           ,[No_Sertifikat]
           ,[JenisDocument]
           ,[FileDocument]
           ,[Extension]
           ,[date_update]
           ,[user_update]
           ,[Provider])
            VALUES
           ( :Id_data,
           :jenisPelatihan,
           :namaPelatihan,
           :tglAwalPelatihan,
           :tglAkhirPelatihan,
           :address,
           :lamaPelatihan,
           :noSertif,
           :JenisDocument,
           :FileDocument,
           :EXTENSION,
           :date_update,
           :user_update,
           :Provider) ";
        try {
            $this->db->transaksi();
            $ro = "aws";
            $datetime = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $operator =  $session->IDEmployee;
            $this->db->query($query);

            $this->db->bind('Id_data', $data['iddata']);
            $this->db->bind('jenisPelatihan', $data['jenisPelatihan']);
            $this->db->bind('namaPelatihan', $data['namaPelatihan']);

            $this->db->bind('FileDocument', $awsImages);

            $this->db->bind('tglAwalPelatihan', $data['tglAwalPelatihan']);
            $this->db->bind('tglAkhirPelatihan', $data['tglAkhirPelatihan']);
            $this->db->bind('address', $data['address']);

            $this->db->bind('lamaPelatihan', $data['lamaPelatihan']);
            $this->db->bind('noSertif', $data['noSertif']);

            $this->db->bind('JenisDocument', $data['jenisdoc']);

            $this->db->bind('Provider', $ro);
            $this->db->bind('date_update', $datetime);
            $this->db->bind('user_update', $namauserx);
            $this->db->bind('EXTENSION', $ext);
            $this->db->execute();
            $this->db->Commit();
            $callback = array(
                'status' => 'success',
                'message' => ' Upload Data Succesfully.',
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

        else{
            try{
                // $this->db->transaksi();
                // var_dump($data);
                // var_dump($nama_file_baru);
                // var_dump($awsImages);
                // var_dump($ext);
                // exit;

                // [Id_data]
    //        ,[Jenis_Pelatihan]
    //        ,[Nama_Pelatihan]
    //        ,[Tgl_Awal]
    //        ,[Tgl_Akhir]
    //        ,[Alamat_Pelatihan]
    //        ,[Lama_Pelatihan_Internal]
    //        ,[No_Sertifikat]
    //        ,[JenisDocument]
    //        ,[FileDocument]
    //        ,[Extension]
    //        ,[date_update]
    //        ,[user_update]
    //        ,[Provider])
    
                // var_dump($data);
                // exit;
                
                $id = $data['iddatax'];
                $jenisPelatihan = $data['jenisPelatihan'];
                $namaPelatihan = $data['namaPelatihan'];
                $FileDocument = $awsImages;
                $tglAwalPelatihan = $data['tglAwalPelatihan'];
                $tglAkhirPelatihan = $data['tglAkhirPelatihan'];
                $noSertif = $data['noSertif'];
                $address = $data['address'];

                $lamaPelatihan = $data['lamaPelatihan'];
                $JenisDocument = $data['jenisdoc'];
                $EXTENSION = $ext;
            
                $this->db->transaksi();
                $this->db->query("UPDATE HRDYARSI.[dbo].[Data Pelatihan] SET 
                Jenis_Pelatihan = :jenisPelatihan,
                Nama_Pelatihan = :namaPelatihan,
                Tgl_Awal = :tglAwalPelatihan,
                Tgl_Akhir = :tglAkhirPelatihan,
                No_Sertifikat = :noSertif,
                Alamat_Pelatihan = :address,
                Lama_Pelatihan_Internal = :lamaPelatihan,
                FileDocument = :FileDocument,
                JenisDocument = :JenisDocument,
                Extension = :EXTENSION
                WHERE Id_Pelatihan=:id");

                $this->db->bind('id', $data['iddatax']);
                $this->db->bind('jenisPelatihan', $data['jenisPelatihan']);
                $this->db->bind('namaPelatihan', $data['namaPelatihan']);
                $this->db->bind('tglAwalPelatihan', $data['tglAwalPelatihan']);
                $this->db->bind('tglAkhirPelatihan', $data['tglAkhirPelatihan']);
                $this->db->bind('address', $data['address']);
                $this->db->bind('noSertif', $data['noSertif']);
                $this->db->bind('lamaPelatihan', $data['lamaPelatihan']);
            
                $this->db->bind('JenisDocument', $data['jenisdoc']);
                $this->db->bind('FileDocument', $awsImages);
                $this->db->bind('EXTENSION', $ext);

                // var_dump($nama);
                // var_dump($FileDocument);
                // exit;
                // $this->db->bind('EXTENSION', $ext);
                
                $this->db->execute();
                $this->db->commit();
                $callback = array(
                    'status' => 'success', // Set array status dengan success   
                    'message' => 'Transkasi Berhasil!', // Set array status dengan success    
                    
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
        // var_dump($data);
        
    }


    public function SaveTTD_SIP($data,  $nama_file_baru, $awsImages, $ext)
    {
        // unlink(__DIR__ . '/../../public' . '/tmp/' . $nama_file_baru); // Hapus file tersebut 

        // var_dump($data);

        if($data['iddatax'] == null){
            $query = "INSERT INTO HRDYARSI.dbo.SIP
           ([Id_data]
           ,[Tgl_Awal]
           ,[Tgl_Akhir]
           ,[No_SIP]
           ,[JenisDocument]
           ,[FileDocument]
           ,[Extension]
           ,[date_update]
           ,[user_update]
           ,[Provider])
            VALUES
           ( :Id_data,
           :tglAwalSIP,
           :tglAkhirSIP,
           :noSuratSIP,
           :JenisDocument,
           :FileDocument,
           :EXTENSION,
           :date_update,
           :user_update,
           :Provider) ";
        try {
            $this->db->transaksi();
            $ro = "aws";
            $datetime = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $operator =  $session->IDEmployee;
            $this->db->query($query);

            $this->db->bind('Id_data', $data['iddata']);

            $this->db->bind('FileDocument', $awsImages);

            $this->db->bind('tglAwalSIP', $data['tglAwalSIP']);
            $this->db->bind('tglAkhirSIP', $data['tglAkhirSIP']);
            $this->db->bind('noSuratSIP', $data['noSuratSIP']);

            $this->db->bind('JenisDocument', $data['jenisdoc']);

            $this->db->bind('Provider', $ro);
            $this->db->bind('date_update', $datetime);
            $this->db->bind('user_update', $namauserx);
            $this->db->bind('EXTENSION', $ext);
            $this->db->execute();
            $this->db->Commit();
            $callback = array(
                'status' => 'success',
                'message' => ' Upload Data Succesfully.',
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
        else{
            try{
                $id = $data['iddatax'];
                $tglAwalSIP = $data['tglAwalSIP'];
                $tglAkhirSIP = $data['tglAkhirSIP'];
                $noSuratSIP = $data['noSuratSIP'];
                
                $FileDocument = $awsImages;
                $JenisDocument = $data['jenisdoc'];
                $EXTENSION = $ext;
            
                $this->db->transaksi();
                $this->db->query("UPDATE HRDYARSI.[dbo].SIP SET 
                Tgl_Awal = :tglAwalSIP,
                Tgl_Akhir = :tglAkhirSIP,
                No_SIP = :noSuratSIP,
                FileDocument = :FileDocument,
                JenisDocument = :JenisDocument,
                Extension = :EXTENSION
                WHERE Id_trs=:id");

                $this->db->bind('id', $data['iddatax']);
                $this->db->bind('tglAwalSIP', $data['tglAwalSIP']);
                $this->db->bind('tglAkhirSIP', $data['tglAkhirSIP']);
                $this->db->bind('noSuratSIP', $data['noSuratSIP']);
            
                $this->db->bind('JenisDocument', $data['jenisdoc']);
                $this->db->bind('FileDocument', $awsImages);
                $this->db->bind('EXTENSION', $ext);

                // var_dump($nama);
                // var_dump($FileDocument);
                // exit;
                // $this->db->bind('EXTENSION', $ext);
                
                $this->db->execute();
                $this->db->commit();
                $callback = array(
                    'status' => 'success', // Set array status dengan success   
                    'message' => 'Transkasi Berhasil!', // Set array status dengan success    
                    
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
        
    }

    public function SaveTTD_Pribadi($data,  $nama_file_baru, $awsImages, $ext)
    {
        // unlink(__DIR__ . '/../../public' . '/tmp/' . $nama_file_baru); // Hapus file tersebut 

        // var_dump($data);

        if($data['iddatax'] == null){
            $query = "INSERT INTO HRDYARSI.dbo.DATA_PRIBADI
           ([Id_data]
           ,[JenisDocument]
           ,[FileDocument]
           ,[Extension]
           ,[date_update]
           ,[user_update]
           ,[Provider])
            VALUES
           ( :Id_data,
           :JenisDocument,
           :FileDocument,
           :EXTENSION,
           :date_update,
           :user_update,
           :Provider) ";
        try {
            $this->db->transaksi();
            $ro = "aws";
            $datetime = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $operator =  $session->IDEmployee;
            $this->db->query($query);

            $this->db->bind('Id_data', $data['iddata']);

            $this->db->bind('FileDocument', $awsImages);
            $this->db->bind('JenisDocument', $data['jenisdoc']);

            $this->db->bind('Provider', $ro);
            $this->db->bind('date_update', $datetime);
            $this->db->bind('user_update', $namauserx);
            $this->db->bind('EXTENSION', $ext);
            $this->db->execute();
            $this->db->Commit();
            $callback = array(
                'status' => 'success',
                'message' => ' Upload Data Succesfully.',
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
        else{
            try{
                $id = $data['iddatax'];
                
                $FileDocument = $awsImages;
                $JenisDocument = $data['jenisdoc'];
                $EXTENSION = $ext;
            
                $this->db->transaksi();
                $this->db->query("UPDATE HRDYARSI.[dbo].DATA_PRIBADI SET 
                FileDocument = :FileDocument,
                JenisDocument = :JenisDocument,
                Extension = :EXTENSION
                WHERE Id_trs=:id");

                $this->db->bind('id', $data['iddatax']);
            
                $this->db->bind('JenisDocument', $data['jenisdoc']);
                $this->db->bind('FileDocument', $awsImages);
                $this->db->bind('EXTENSION', $ext);

                // var_dump($nama);
                // var_dump($FileDocument);
                // exit;
                // $this->db->bind('EXTENSION', $ext);
                
                $this->db->execute();
                $this->db->commit();
                $callback = array(
                    'status' => 'success', // Set array status dengan success   
                    'message' => 'Transkasi Berhasil!', // Set array status dengan success    
                    
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
        
    }

    public function SaveTTD_RKK($data,  $nama_file_baru, $awsImages, $ext)
    {

        if($data['iddatax'] == null){
            $query = "INSERT INTO HRDYARSI.dbo.RKK
           ([Id_data]
           ,[JenisDocument]
           ,[FileDocument]
           ,[Extension]
           ,[date_update]
           ,[user_update]
           ,[Provider])
            VALUES
           ( :Id_data,
           :JenisDocument,
           :FileDocument,
           :EXTENSION,
           :date_update,
           :user_update,
           :Provider) ";
        try {
            $this->db->transaksi();
            $ro = "aws";
            $datetime = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $operator =  $session->IDEmployee;
            $this->db->query($query);

            $this->db->bind('Id_data', $data['iddata']);

            $this->db->bind('FileDocument', $awsImages);
            $this->db->bind('JenisDocument', $data['jenisdoc']);

            $this->db->bind('Provider', $ro);
            $this->db->bind('date_update', $datetime);
            $this->db->bind('user_update', $namauserx);
            $this->db->bind('EXTENSION', $ext);
            $this->db->execute();
            $this->db->Commit();
            $callback = array(
                'status' => 'success',
                'message' => ' Upload Data Succesfully.',
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
        else{
            try{
                $id = $data['iddatax'];
                
                $FileDocument = $awsImages;
                $JenisDocument = $data['jenisdoc'];
                $EXTENSION = $ext;
            
                $this->db->transaksi();
                $this->db->query("UPDATE HRDYARSI.[dbo].RKK SET 
                FileDocument = :FileDocument,
                JenisDocument = :JenisDocument,
                Extension = :EXTENSION
                WHERE Id_trs=:id");

                $this->db->bind('id', $data['iddatax']);
            
                $this->db->bind('JenisDocument', $data['jenisdoc']);
                $this->db->bind('FileDocument', $awsImages);
                $this->db->bind('EXTENSION', $ext);

                // var_dump($nama);
                // var_dump($FileDocument);
                // exit;
                // $this->db->bind('EXTENSION', $ext);
                
                $this->db->execute();
                $this->db->commit();
                $callback = array(
                    'status' => 'success', // Set array status dengan success   
                    'message' => 'Transkasi Berhasil!', // Set array status dengan success    
                    
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
        
    }

    public function SaveTTD_SPK($data,  $nama_file_baru, $awsImages, $ext)
    {
        // unlink(__DIR__ . '/../../public' . '/tmp/' . $nama_file_baru); // Hapus file tersebut 

        // var_dump($data);

        if($data['iddatax'] == null){
            $query = "INSERT INTO HRDYARSI.dbo.SPK
           ([Id_data]
           ,[JenisDocument]
           ,[FileDocument]
           ,[Extension]
           ,[date_update]
           ,[user_update]
           ,[Provider])
            VALUES
           ( :Id_data,
           :JenisDocument,
           :FileDocument,
           :EXTENSION,
           :date_update,
           :user_update,
           :Provider) ";
        try {
            $this->db->transaksi();
            $ro = "aws";
            $datetime = Utils::seCurrentDateTime();
            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $token = $session->token;
            $namauserx = $session->name;
            $operator =  $session->IDEmployee;
            $this->db->query($query);

            $this->db->bind('Id_data', $data['iddata']);

            $this->db->bind('FileDocument', $awsImages);
            $this->db->bind('JenisDocument', $data['jenisdoc']);

            $this->db->bind('Provider', $ro);
            $this->db->bind('date_update', $datetime);
            $this->db->bind('user_update', $namauserx);
            $this->db->bind('EXTENSION', $ext);
            $this->db->execute();
            $this->db->Commit();
            $callback = array(
                'status' => 'success',
                'message' => ' Upload Data Succesfully.',
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
        else{
            try{
                $id = $data['iddatax'];
                
                $FileDocument = $awsImages;
                $JenisDocument = $data['jenisdoc'];
                $EXTENSION = $ext;
            
                $this->db->transaksi();
                $this->db->query("UPDATE HRDYARSI.[dbo].SPK SET 
                FileDocument = :FileDocument,
                JenisDocument = :JenisDocument,
                Extension = :EXTENSION
                WHERE Id_trs=:id");

                $this->db->bind('id', $data['iddatax']);
            
                $this->db->bind('JenisDocument', $data['jenisdoc']);
                $this->db->bind('FileDocument', $awsImages);
                $this->db->bind('EXTENSION', $ext);

                // var_dump($nama);
                // var_dump($FileDocument);
                // exit;
                // $this->db->bind('EXTENSION', $ext);
                
                $this->db->execute();
                $this->db->commit();
                $callback = array(
                    'status' => 'success', // Set array status dengan success   
                    'message' => 'Transkasi Berhasil!', // Set array status dengan success    
                    
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
        
    }

    public function SaveTTD_STR($data,  $nama_file_baru, $awsImages, $ext)
    {
         //unlink(__DIR__ . '/../../public' . '/tmp/' . $nama_file_baru); // Hapus file tersebut 
        // var_dump($data);

        if($data['iddatax'] == null){
            $query = "INSERT INTO HRDYARSI.dbo.STR
            ([Id_data]
            ,[Tgl_Awal]
            ,[Tgl_Akhir]
            ,[No_STR]
            ,[JenisDocument]
            ,[FileDocument]
            ,[Extension]
            ,[date_update]
            ,[user_update]
            ,[Provider])
             VALUES
            ( :Id_data,
            :tglAwalSTR,
            :tglAkhirSTR,
            :noSuratSTR,
            :JenisDocument,
            :FileDocument,
            :EXTENSION,
            :date_update,
            :user_update,
            :Provider) ";
 
         try {
             $this->db->transaksi();
             $ro = "aws";
             $datetime = Utils::seCurrentDateTime();
             $session = SessionManager::getCurrentSession();
             $userid = $session->username;
             $token = $session->token;
             $namauserx = $session->name;
             $operator =  $session->IDEmployee;
             $this->db->query($query);
 
             $this->db->bind('Id_data', $data['iddata']);
 
             $this->db->bind('FileDocument', $awsImages);
 
             $this->db->bind('tglAwalSTR', $data['tglAwalSTR']);
             $this->db->bind('tglAkhirSTR', $data['tglAkhirSTR']);
             $this->db->bind('noSuratSTR', $data['noSuratSTR']);
 
             $this->db->bind('JenisDocument', $data['jenisdoc']);
 
             $this->db->bind('Provider', $ro);
             $this->db->bind('date_update', $datetime);
             $this->db->bind('user_update', $namauserx);
             $this->db->bind('EXTENSION', $ext);
             $this->db->execute();
             $this->db->Commit();
             $callback = array(
                 'status' => 'success',
                 'message' => ' Upload Data Succesfully.',
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
        else{
            try{
                $id = $data['iddatax'];
                $tglAwalSTR = $data['tglAwalSTR'];
                $tglAkhirSTR = $data['tglAkhirSTR'];
                $noSuratSTR = $data['noSuratSTR'];
                
                $FileDocument = $awsImages;
                $JenisDocument = $data['jenisdoc'];
                $EXTENSION = $ext;
            
                $this->db->transaksi();
                $this->db->query("UPDATE HRDYARSI.[dbo].STR SET 
                Tgl_Awal = :tglAwalSTR,
                Tgl_Akhir = :tglAkhirSTR,
                No_STR = :noSuratSTR,
                FileDocument = :FileDocument,
                JenisDocument = :JenisDocument,
                Extension = :EXTENSION
                WHERE Id_trs=:id");

                $this->db->bind('id', $data['iddatax']);
                $this->db->bind('tglAwalSTR', $data['tglAwalSTR']);
                $this->db->bind('tglAkhirSTR', $data['tglAkhirSTR']);
                $this->db->bind('noSuratSTR', $data['noSuratSTR']);
            
                $this->db->bind('JenisDocument', $data['jenisdoc']);
                $this->db->bind('FileDocument', $awsImages);
                $this->db->bind('EXTENSION', $ext);

                // var_dump($nama);
                // var_dump($FileDocument);
                // exit;
                // $this->db->bind('EXTENSION', $ext);
                
                $this->db->execute();
                $this->db->commit();
                $callback = array(
                    'status' => 'success', // Set array status dengan success   
                    'message' => 'Transkasi Berhasil!', // Set array status dengan success    
                    
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
       
    }

    public function SaveTTD_MCU($data,  $nama_file_baru, $awsImages, $ext)
    {
        // unlink(__DIR__ . '/../../public' . '/tmp/' . $nama_file_baru); // Hapus file tersebut 

        // var_dump($data);

        if($data['iddatax'] == null){
            $query = "INSERT INTO HRDYARSI.[dbo].[Data MCU]
            ([Id_data]
            ,[tglMCU]
            ,[tglHasil]
            ,[Keterangan]
            -- ,[JenisDocument]
            ,[FileDocument]
            ,[Extension]
            ,[date_update]
            ,[user_update]
            ,[Provider])
             VALUES
            ( :Id_data,
            :tglMCU,
            :tglHasil,
            :Keterangan,
            -- :JenisDocument,
            :FileDocument,
            :EXTENSION,
            :date_update,
            :user_update,
            :Provider) ";
         try {
             $this->db->transaksi();
             $ro = "aws";
             $datetime = Utils::seCurrentDateTime();
             $session = SessionManager::getCurrentSession();
             $userid = $session->username;
             $token = $session->token;
             $namauserx = $session->name;
             $operator =  $session->IDEmployee;
             $this->db->query($query);
 
             $this->db->bind('Id_data', $data['iddata']);
             $this->db->bind('tglMCU', $data['tglMCU']);
             $this->db->bind('tglHasil', $data['tglHasil']);
             $this->db->bind('Keterangan', $data['Keterangan']);
 
             $this->db->bind('FileDocument', $awsImages);
 
            //  $this->db->bind('JenisDocument', $data['jenisdoc']);
 
             $this->db->bind('Provider', $ro);
             $this->db->bind('date_update', $datetime);
             $this->db->bind('user_update', $namauserx);
             $this->db->bind('EXTENSION', $ext);
             $this->db->execute();
             $this->db->Commit();
             $callback = array(
                 'status' => 'success',
                 'message' => ' Upload Data Succesfully.',
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
        else{

            

            try{

                // var_dump($data);
                // exit;
                $id = $data['iddatax'];
                $tglMCU = $data['tglMCU'];
                $tglHasil = $data['tglHasil'];
                $Keterangan = $data['Keterangan'];
                
                $FileDocument = $awsImages;
                // $JenisDocument = $data['jenisdoc'];
                $EXTENSION = $ext;


                // ([Id_data]
    //     ,[tglMCU]
    //     ,[tglHasil]
    //     ,[Keterangan]
    //     ,[JenisDocument]
    //     ,[FileDocument]
    //     ,[Extension]
    //     ,[date_update]
    //     ,[user_update]
    //     ,[Provider])
            
                $this->db->transaksi();
                $this->db->query("UPDATE HRDYARSI.[dbo].[Data MCU] SET 
                tglMCU = :tglMCU,
                tglHasil = :tglHasil,
                Keterangan = :Keterangan,
                FileDocument = :FileDocument,
                -- JenisDocument = :JenisDocument,
                Extension = :EXTENSION
                WHERE ID=:id");

                $this->db->bind('id', $data['iddatax']);
                $this->db->bind('tglMCU', $data['tglMCU']);
                $this->db->bind('tglHasil', $data['tglHasil']);
                $this->db->bind('Keterangan', $data['Keterangan']);
            
                // $this->db->bind('JenisDocument', $data['jenisdoc']);
                $this->db->bind('FileDocument', $awsImages);
                $this->db->bind('EXTENSION', $ext);

                // var_dump($nama);
                // var_dump($FileDocument);
                // exit;
                // $this->db->bind('EXTENSION', $ext);
                
                $this->db->execute();
                $this->db->commit();
                $callback = array(
                    'status' => 'success', // Set array status dengan success   
                    'message' => 'Transkasi Berhasil!', // Set array status dengan success    
                    
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
        
    }

    public function getDataListPribadi($data)
    {
        
        try {

            $query = "SELECT Id_trs,Id_data, JenisDocument,FileDocument,Extension,date_update,user_update
            FROM HRDYARSI.dbo.DATA_PRIBADI
            WHERE Id_data=:ID_Data";
            $this->db->query($query);
            $this->db->bind('ID_Data', $data['doc_nomr']);

            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {
                // $pasing['NO'] = $No++;
                $pasing['Id_trs'] = $row['Id_trs'];
                $pasing['Id_data'] = $row['Id_data'];
                $pasing['JenisDocument'] = $row['JenisDocument'];
                $pasing['URL'] = $row['FileDocument'];
                $pasing['EXTENSION'] = $row['Extension'];
                $pasing['date_update'] = $row['date_update'];
                $pasing['user_update'] = $row['user_update'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataListRKK($data)
    {
        
        try {

            $query = "SELECT Id_trs,Id_data, JenisDocument,FileDocument,Extension,date_update,user_update
            FROM HRDYARSI.dbo.RKK
            WHERE Id_data=:ID_Data";
            $this->db->query($query);
            $this->db->bind('ID_Data', $data['doc_nomr']);

            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {
                // $pasing['NO'] = $No++;
                $pasing['Id_trs'] = $row['Id_trs'];
                $pasing['Id_data'] = $row['Id_data'];
                $pasing['JenisDocument'] = $row['JenisDocument'];
                $pasing['URL'] = $row['FileDocument'];
                $pasing['EXTENSION'] = $row['Extension'];
                $pasing['date_update'] = $row['date_update'];
                $pasing['user_update'] = $row['user_update'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDataListSPK($data)
    {
        
        try {

            $query = "SELECT Id_trs,Id_data, JenisDocument,FileDocument,Extension,date_update,user_update
            FROM HRDYARSI.dbo.SPK
            WHERE Id_data=:ID_Data";
            $this->db->query($query);
            $this->db->bind('ID_Data', $data['doc_nomr']);

            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {
                // $pasing['NO'] = $No++;
                $pasing['Id_trs'] = $row['Id_trs'];
                $pasing['Id_data'] = $row['Id_data'];
                $pasing['JenisDocument'] = $row['JenisDocument'];
                $pasing['URL'] = $row['FileDocument'];
                $pasing['EXTENSION'] = $row['Extension'];
                $pasing['date_update'] = $row['date_update'];
                $pasing['user_update'] = $row['user_update'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataListKeluarga($data)
    {
        try {

            $query = "SELECT Id_Keluarga,Id_data,[Nama Keluarga] AS NamaAnggota, Tgl_Lahir, 
            CASE WHEN [Status Keluarga]='1' THEN 'SUAMI' 
            WHEN [Status Keluarga]='2' THEN 'ISTRI'
            WHEN [Status Keluarga]='3' THEN 'ANAK 1'
            WHEN [Status Keluarga]='4' THEN 'ANAK 2'
            WHEN [Status Keluarga]='5' THEN 'ANAK 3'
            WHEN [Status Keluarga]='6' THEN 'ANAK 4'
            WHEN [Status Keluarga]='7' THEN 'ANAK 5'
            END AS NamaStatusKeluarga, Tpt_Lahir, JenisDocument,FileDocument,Extension,date_update,user_update
            FROM HRDYARSI.dbo.Keluarga
            WHERE Id_data=:ID_Data";
            $this->db->query($query);
            $this->db->bind('ID_Data', $data['doc_nomr']);

            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {
                // $pasing['NO'] = $No++;
                $pasing['Id_Keluarga'] = $row['Id_Keluarga'];
                $pasing['Id_data'] = $row['Id_data'];
                $pasing['NamaAnggota'] = $row['NamaAnggota'];
                $pasing['Tgl_Lahir'] = $row['Tgl_Lahir'];
                $pasing['NamaStatusKeluarga'] = $row['NamaStatusKeluarga'];
                $pasing['Tpt_Lahir'] = $row['Tpt_Lahir'];
                $pasing['JenisDocument'] = $row['JenisDocument'];
                $pasing['URL'] = $row['FileDocument'];
                $pasing['EXTENSION'] = $row['Extension'];
                $pasing['date_update'] = $row['date_update'];
                $pasing['user_update'] = $row['user_update'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDataListPendidikan($data)
    {
        try {

            $query = "SELECT ID,NIP,Nama_Pendidikan, Tahun_Lulus, Jenis_Pendidikan,
            CASE WHEN Jenis_Pendidikan='1' THEN 'SD' 
            WHEN Jenis_Pendidikan='2' THEN 'SMP'
            WHEN Jenis_Pendidikan='3' THEN 'SMA'
            WHEN Jenis_Pendidikan='4' THEN 'SMK'
            WHEN Jenis_Pendidikan='5' THEN 'D1'
            WHEN Jenis_Pendidikan='6' THEN 'D2'
            WHEN Jenis_Pendidikan='7' THEN 'D3'
            WHEN Jenis_Pendidikan='8' THEN 'S1'
            WHEN Jenis_Pendidikan='9' THEN 'S2'
            WHEN Jenis_Pendidikan='10' THEN 'S3'
            END AS Nama_Jenis_Pendidikan, Jurusan, JenisDocument,FileDocument,Extension,date_update,user_update
            FROM HRDYARSI.[dbo].[Data Pendidikan]
            WHERE NIP=:ID_Data";
            $this->db->query($query);
            $this->db->bind('ID_Data', $data['doc_nomr']);

            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {
                // $pasing['NO'] = $No++;
                $pasing['ID'] = $row['ID'];
                $pasing['NIP'] = $row['NIP'];
                $pasing['Jenis_Pendidikan'] = $row['Jenis_Pendidikan'];
                $pasing['Nama_Pendidikan'] = $row['Nama_Pendidikan'];
                $pasing['Tahun_Lulus'] = $row['Tahun_Lulus'];
                $pasing['Nama_Jenis_Pendidikan'] = $row['Nama_Jenis_Pendidikan'];
                $pasing['Jurusan'] = $row['Jurusan'];
                $pasing['JenisDocument'] = $row['JenisDocument'];
                $pasing['URL'] = $row['FileDocument'];
                $pasing['EXTENSION'] = $row['Extension'];
                $pasing['date_update'] = $row['date_update'];
                $pasing['user_update'] = $row['user_update'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDataListPelatihan($data)
    {
        try {

            $query = "SELECT Id_Pelatihan,Id_data,Nama_Pelatihan, Tgl_Awal, Tgl_Akhir,
            CASE WHEN Jenis_Pelatihan='1' THEN 'INTERNAL' 
            WHEN Jenis_Pelatihan='2' THEN 'EXTERNAL'
            END AS JenisPelatihan, Lama_Pelatihan_Internal, Alamat_Pelatihan, No_Sertifikat, JenisDocument,FileDocument,Extension,date_update,user_update
            FROM HRDYARSI.dbo.[Data Pelatihan]
            WHERE Id_data=:ID_Data";
            $this->db->query($query);
            $this->db->bind('ID_Data', $data['doc_nomr']);

            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {
                // $pasing['NO'] = $No++;
                $pasing['Id_Pelatihan'] = $row['Id_Pelatihan'];
                $pasing['Id_data'] = $row['Id_data'];
                $pasing['Nama_Pelatihan'] = $row['Nama_Pelatihan'];
                $pasing['Tgl_Awal'] = $row['Tgl_Awal'];
                $pasing['Tgl_Akhir'] = $row['Tgl_Akhir'];
                $pasing['JenisPelatihan'] = $row['JenisPelatihan'];
                $pasing['Lama_Pelatihan_Internal'] = $row['Lama_Pelatihan_Internal'];
                $pasing['Alamat_Pelatihan'] = $row['Alamat_Pelatihan'];
                $pasing['No_Sertifikat'] = $row['No_Sertifikat'];
                $pasing['JenisDocument'] = $row['JenisDocument'];
                $pasing['URL'] = $row['FileDocument'];
                $pasing['EXTENSION'] = $row['Extension'];
                $pasing['date_update'] = $row['date_update'];
                $pasing['user_update'] = $row['user_update'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDataListSIP($data)
    {
        try {

            $query = "SELECT Id_trs,Id_data,Tgl_Awal, Tgl_Akhir, No_SIP, JenisDocument,FileDocument,Extension,date_update,user_update
            FROM HRDYARSI.dbo.SIP
            WHERE Id_data=:ID_Data";
            $this->db->query($query);
            $this->db->bind('ID_Data', $data['doc_nomr']);

            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {
                // $pasing['NO'] = $No++;
                $pasing['Id_trs'] = $row['Id_trs'];
                $pasing['Id_data'] = $row['Id_data'];
                $pasing['Tgl_Awal'] = $row['Tgl_Awal'];
                $pasing['Tgl_Akhir'] = $row['Tgl_Akhir'];
                $pasing['No_SIP'] = $row['No_SIP'];
                $pasing['JenisDocument'] = $row['JenisDocument'];
                $pasing['URL'] = $row['FileDocument'];
                $pasing['EXTENSION'] = $row['Extension'];
                $pasing['date_update'] = $row['date_update'];
                $pasing['user_update'] = $row['user_update'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDataListSTR($data)
    {
        try {

            $query = "SELECT Id_trs,Id_data,Tgl_Awal, Tgl_Akhir, No_STR, JenisDocument,FileDocument,Extension,date_update,user_update
            FROM HRDYARSI.dbo.STR
            WHERE Id_data=:ID_Data";
            $this->db->query($query);
            $this->db->bind('ID_Data', $data['doc_nomr']);

            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {
                // $pasing['NO'] = $No++;
                $pasing['Id_trs'] = $row['Id_trs'];
                $pasing['Id_data'] = $row['Id_data'];
                $pasing['Tgl_Awal'] = $row['Tgl_Awal'];
                $pasing['Tgl_Akhir'] = $row['Tgl_Akhir'];
                $pasing['No_STR'] = $row['No_STR'];
                $pasing['JenisDocument'] = $row['JenisDocument'];
                $pasing['URL'] = $row['FileDocument'];
                $pasing['EXTENSION'] = $row['Extension'];
                $pasing['date_update'] = $row['date_update'];
                $pasing['user_update'] = $row['user_update'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataListMCU($data)
    {
        try {

            $query = "SELECT ID,Id_data, tglMCU, tglHasil,Keterangan,
             JenisDocument,FileDocument,Extension,date_update,user_update
            FROM HRDYARSI.dbo.[Data MCU]
            WHERE Id_data=:ID_Data";
            $this->db->query($query);
            $this->db->bind('ID_Data', $data['doc_nomr']);

            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {
                // $pasing['NO'] = $No++;
                $pasing['ID'] = $row['ID'];
                $pasing['Id_data'] = $row['Id_data'];

                $pasing['tglMCU'] = $row['tglMCU'];
                $pasing['tglHasil'] = $row['tglHasil'];
                $pasing['Keterangan'] = $row['Keterangan'];

                $pasing['JenisDocument'] = $row['JenisDocument'];
                $pasing['URL'] = $row['FileDocument'];
                $pasing['EXTENSION'] = $row['Extension'];
                $pasing['date_update'] = $row['date_update'];
                $pasing['user_update'] = $row['user_update'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    //-----------------------
    public function uploadDataMOU($data)
    {


        // Jika user telah mengklik tombol Preview

        //$ip = ; // Ambil IP Address dari User 
        $doc_nomr = $data['nikPegawai'];

        // if ($data['tglAwal'] == ''){
        //     $callback = array(
        //         'status' => 'warning',
        //         'message' => 'Tanggal Awal Kosong !',
        //     );
        //     return $callback;
        //     exit;
        // }

        // if ($data['tglAkhir'] == ''){
        //     $callback = array(
        //         'status' => 'warning',
        //         'message' => 'Tanggal Akhir Kosong !',
        //     );
        //     return $callback;
        //     exit;
        // }

        // if ($data['jenisdoc'] == ''){
        //     $callback = array(
        //         'status' => 'warning',
        //         'message' => 'Jenis Dokumen Kosong !',
        //     );
        //     return $callback;
        //     exit;
        // }
        
        // if (isset($data['file'])){
        //     $callback = array(
        //         'status' => 'warning',
        //         'message' => 'File Kosong ! Pilih File Untuk Diupload !',
        //     );
        //     return $callback;
        //     exit;
        // }
        if( isset($_FILES['file']['tmp_name'])){
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png", "pdf" => "application/pdf");
        $filetype = $_FILES["file"]["type"];
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
        $tmp_file = $_FILES['file']['tmp_name'];

        // Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
        if (in_array($filetype, $allowed)) {
            $bytes = random_bytes(20);
            $nama_file_baru  =     $doc_nomr . bin2hex($bytes) . "-" . date("YmdHis") . '.' . $ext;
            if (move_uploaded_file($tmp_file,  __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru)) {

                /// AWS
                // Create an S3Client
                $s3Client = new S3Client([
                    'version' => 'latest',
                    'region'  => 'ap-southeast-1',
                    'http'    => ['verify' => false],
                    'credentials' => [
                        'key'    => 'AKIAYV2M6ERJGUKK4QWQ',
                        'secret' => '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'
                    ]
                ]);
                $file_name = __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru;
                $source =   $file_name;
                $awsImages = '';
                $handle = fopen($source, 'r');
                try {
                    $bucket = 'rsuyarsibucket';
                    $key = basename($file_name);
                    $result = $s3Client->putObject([
                        'Bucket' => $bucket,
                        'Key'    => 'hrd/dataMOU/' . $key,
                        'Body'   => $handle,
                        'ACL'    => 'public-read', // make file 'public', 
                    ]);
                    $awsImages = $result->get('ObjectURL');

                    //close filenya
                    fclose($handle);
                    //hapus filenya 
                    unlink($_SERVER["DOCUMENT_ROOT"].'SIKBREC/public/tmp/'.$nama_file_baru);

                    return $this->SaveTTD_MOU($data,  $nama_file_baru, $awsImages, $ext);
                } catch (MultipartUploadException $e) {

                    return $e->getMessage();
                }
            } else {
                $callback = array(
                    'status' => 'warning',
                    'message' => 'Upload Failed.',
                );
                return $callback;
            }
        } else { // Jika file yang diupload bukan File Excel 2007 (.xlsx)
            // Munculkan pesan validasi 
            $callback = array(
                'status' => 'warning',
                'message' => ' File Tidak Support.',
                '$ext' => $ext,
                ' $allowed' =>  $allowed,
            );
            return $callback;
        }

    }else{
           
        $filetype = "";
        $ext = ""; // Ambil ekstensi filenya apa
        $tmp_file = "";
        $nama_file_baru = "";
        $awsImages = "";
        return $this->SaveTTD_MOU($data,  $nama_file_baru, $awsImages, $ext);
    }
    }

    public function SaveTTD_MOU($data,  $nama_file_baru, $awsImages, $ext)
    {
         //unlink(__DIR__ . '/../../public' . '/tmp/' . $nama_file_baru); // Hapus file tersebut 

        // var_dump($data);

        if($data['iddatax'] == null){
            $query = "INSERT INTO HRDYARSI.[dbo].[Data MOU]
            ([Id_data]
            ,[TglAwal]
            ,[TglAkhir]
            ,[Keterangan]
            ,[JenisDocument]
            ,[FileDocument]
            ,[Extension]
            ,[date_update]
            ,[user_update]
            ,[Provider])
             VALUES
            ( :Id_data,
            :tglAwal,
            :tglAkhir,
            :Keterangan,
            :JenisDocument,
            :FileDocument,
            :EXTENSION,
            :date_update,
            :user_update,
            :Provider) ";
         try {
             $this->db->transaksi();
             $ro = "aws";
             $datetime = Utils::seCurrentDateTime();
             $session = SessionManager::getCurrentSession();
             $userid = $session->username;
             $token = $session->token;
             $namauserx = $session->name;
             $operator =  $session->IDEmployee;
             $this->db->query($query);
 
             $this->db->bind('Id_data', $data['iddata']);
             $this->db->bind('tglAwal', $data['tglAwal']);
             $this->db->bind('tglAkhir', $data['tglAkhir']);
             $this->db->bind('Keterangan', $data['Keterangan']);
 
             $this->db->bind('FileDocument', $awsImages);
 
             $this->db->bind('JenisDocument', $data['jenisdoc']);
 
             $this->db->bind('Provider', $ro);
             $this->db->bind('date_update', $datetime);
             $this->db->bind('user_update', $namauserx);
             $this->db->bind('EXTENSION', $ext);
             $this->db->execute();
             $this->db->Commit();
             $callback = array(
                 'status' => 'success',
                 'message' => ' Upload Data Succesfully.',
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

        else{
            try{

                // var_dump($data);
                // exit;
                $id = $data['iddatax'];
                $tglAwal = $data['tglAwal'];
                $tglAkhir = $data['tglAkhir'];
                $Keterangan = $data['Keterangan'];
                
                $FileDocument = $awsImages;
                $JenisDocument = $data['jenisdoc'];
                $EXTENSION = $ext;


            //     ([Id_data]
            // ,[TglAwal]
            // ,[TglAkhir]
            // ,[Keterangan]
            // ,[JenisDocument]
            // ,[FileDocument]
            // ,[Extension]
            // ,[date_update]
            // ,[user_update]
            // ,[Provider])
            
                $this->db->transaksi();
                $this->db->query("UPDATE HRDYARSI.[dbo].[Data MOU] SET 
                TglAwal = :tglAwal,
                TglAkhir = :tglAkhir,
                Keterangan = :Keterangan,
                FileDocument = :FileDocument,
                JenisDocument = :JenisDocument,
                Extension = :EXTENSION
                WHERE ID=:id");

                $this->db->bind('id', $data['iddatax']);
                $this->db->bind('tglAwal', $data['tglAwal']);
                $this->db->bind('tglAkhir', $data['tglAkhir']);
                $this->db->bind('Keterangan', $data['Keterangan']);
            
                $this->db->bind('JenisDocument', $data['jenisdoc']);
                $this->db->bind('FileDocument', $awsImages);
                $this->db->bind('EXTENSION', $ext);

                // var_dump($nama);
                // var_dump($FileDocument);
                // exit;
                // $this->db->bind('EXTENSION', $ext);
                
                $this->db->execute();
                $this->db->commit();
                $callback = array(
                    'status' => 'success', // Set array status dengan success   
                    'message' => 'Transkasi Berhasil!', // Set array status dengan success    
                    
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

        
    }

    public function getDataListMOU($data)
    {
        try {
            //contoh
            $query = "SELECT ID,Id_Data, TglAwal, TglAkhir,Keterangan,
            JenisDocument,FileDocument,Extension,date_update,user_update
           FROM HRDYARSI.dbo.[Data MOU]
           WHERE Id_data=:ID_Data";
           $this->db->query($query);
           $this->db->bind('ID_Data', $data['doc_nomr']);

           $data =  $this->db->resultSet();
           $rows = array();
           $array = array();
           foreach ($data as $row) {
               // $pasing['NO'] = $No++;
               $pasing['ID'] = $row['ID'];
               $pasing['Id_Data'] = $row['Id_Data'];

               $pasing['TglAwal'] = $row['TglAwal'];
               $pasing['TglAkhir'] = $row['TglAkhir'];
               $pasing['Keterangan'] = $row['Keterangan'];

               $pasing['JenisDocument'] = $row['JenisDocument'];
               $pasing['URL'] = $row['FileDocument'];
               $pasing['EXTENSION'] = $row['Extension'];
               $pasing['date_update'] = $row['date_update'];
               $pasing['user_update'] = $row['user_update'];
               $rows[] = $pasing;
           }
            //contoh

            // $query = "SELECT *,replace(CONVERT(VARCHAR(11), TglAwal, 111), '/','-') as tglawal,
            // replace(CONVERT(VARCHAR(11), TglAkhir, 111), '/','-') as tglakhir
            // FROM HRDYARSI.dbo.[Data MOU]
            // WHERE Id_data=:ID_Data";
            // $this->db->query($query);
            // $this->db->bind('ID_Data', $data['doc_nomr']);

            // $data =  $this->db->resultSet();
            // $rows = array();
            // $array = array();
            // $No = 1;
            // foreach ($data as $row) {
            //     $pasing['NO'] = $No++;
            //     // $pasing['ID'] = $row['ID'];
            //     $pasing['Id_data'] = $row['Id_Data'];

            //     $pasing['TglAwal'] = $row['tglawal'];
            //     $pasing['TglAkhir'] = $row['tglakhir'];
            //     $pasing['Keterangan'] = $row['Keterangan'];

            //     $pasing['JenisDocument'] = $row['JenisDocument'];
            //     $pasing['URL'] = $row['FileDocument'];
            //     $pasing['EXTENSION'] = $row['Extension'];
            //     $pasing['date_update'] = $row['date_update'];
            //     $pasing['user_update'] = $row['user_update'];
            //     $rows[] = $pasing;
            // }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function uploadDataSKPegawai($data)
    {


        // Jika user telah mengklik tombol Preview

        //$ip = ; // Ambil IP Address dari User 
        $doc_nomr = $data['nikPegawai'];
        if( isset($_FILES['file']['tmp_name'])){
        // if ($data['tglAwal'] == ''){
        //     $callback = array(
        //         'status' => 'warning',
        //         'message' => 'Tanggal Awal Kosong !',
        //     );
        //     return $callback;
        //     exit;
        // }

        // if ($data['tglAkhir'] == ''){
        //     $callback = array(
        //         'status' => 'warning',
        //         'message' => 'Tanggal Akhir Kosong !',
        //     );
        //     return $callback;
        //     exit;
        // }

        // if ($data['jenisdoc'] == ''){
        //     $callback = array(
        //         'status' => 'warning',
        //         'message' => 'Jenis Dokumen Kosong !',
        //     );
        //     return $callback;
        //     exit;
        // }
        
        // if (isset($data['file'])){
        //     $callback = array(
        //         'status' => 'warning',
        //         'message' => 'File Kosong ! Pilih File Untuk Diupload !',
        //     );
        //     return $callback;
        //     exit;
        // }

        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png", "pdf" => "application/pdf");
        $filetype = $_FILES["file"]["type"];
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
        $tmp_file = $_FILES['file']['tmp_name'];

        // Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
        if (in_array($filetype, $allowed)) {
            $bytes = random_bytes(20);
            $nama_file_baru  =     $doc_nomr . bin2hex($bytes) . "-" . date("YmdHis") . '.' . $ext;
            if (move_uploaded_file($tmp_file,  __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru)) {

                /// AWS
                // Create an S3Client
                $s3Client = new S3Client([
                    'version' => 'latest',
                    'region'  => 'ap-southeast-1',
                    'http'    => ['verify' => false],
                    'credentials' => [
                        'key'    => 'AKIAYV2M6ERJGUKK4QWQ',
                        'secret' => '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'
                    ]
                ]);
                $file_name = __DIR__ . '/../../public' . '/tmp/' . $nama_file_baru;
                $source =   $file_name;
                $awsImages = '';
                $handle = fopen($source, 'r');
                try {
                    $bucket = 'rsuyarsibucket';
                    $key = basename($file_name);
                    $result = $s3Client->putObject([
                        'Bucket' => $bucket,
                        'Key'    => 'hrd/dataSKPegawai/' . $key,
                        'Body'   => $handle,
                        'ACL'    => 'public-read', // make file 'public', 
                    ]);
                    $awsImages = $result->get('ObjectURL');

                    //close filenya
                    fclose($handle);
                    //hapus filenya 
                    unlink($_SERVER["DOCUMENT_ROOT"].'SIKBREC/public/tmp/'.$nama_file_baru);

                    return $this->SaveTTD_SKPegawai($data,  $nama_file_baru, $awsImages, $ext);
                } catch (MultipartUploadException $e) {

                    return $e->getMessage();
                }
            } else {
                $callback = array(
                    'status' => 'warning',
                    'message' => 'Upload Failed.',
                );
                return $callback;
            }
        } else { // Jika file yang diupload bukan File Excel 2007 (.xlsx)
            // Munculkan pesan validasi 
            $callback = array(
                'status' => 'warning',
                'message' => ' File Tidak Support.',
                '$ext' => $ext,
                ' $allowed' =>  $allowed,
            );
            return $callback;
        }
    }else{
           
        $filetype = "";
        $ext = ""; // Ambil ekstensi filenya apa
        $tmp_file = "";
        $nama_file_baru = "";
        $awsImages = "";
        return $this->SaveTTD_SKPegawai($data,  $nama_file_baru, $awsImages, $ext);
    }
    }

    public function SaveTTD_SKPegawai($data,  $nama_file_baru, $awsImages, $ext)
    {
         //unlink(__DIR__ . '/../../public' . '/tmp/' . $nama_file_baru); // Hapus file tersebut 
         //unlink($_SERVER["DOCUMENT_ROOT"].'SIKBREC/public/tmp/'.$nama_file_baru);

        // var_dump($data);

        if($data['iddatax'] == null){
            $query = "INSERT INTO HRDYARSI.[dbo].[Data SKPegawai]
            ([Id_data]
            ,[TglAwal]
            ,[TglAkhir]
            ,[Keterangan]
            ,[JenisDocument]
            ,[FileDocument]
            ,[Extension]
            ,[date_update]
            ,[user_update]
            ,[Provider])
             VALUES
            ( :Id_data,
            :tglAwal,
            :tglAkhir,
            :Keterangan,
            :JenisDocument,
            :FileDocument,
            :EXTENSION,
            :date_update,
            :user_update,
            :Provider) ";
         try {
             $this->db->transaksi();
             $ro = "aws";
             $datetime = Utils::seCurrentDateTime();
             $session = SessionManager::getCurrentSession();
             $userid = $session->username;
             $token = $session->token;
             $namauserx = $session->name;
             $operator =  $session->IDEmployee;
             $this->db->query($query);
 
             $this->db->bind('Id_data', $data['iddata']);
             $this->db->bind('tglAwal', $data['tglAwal']);
             $this->db->bind('tglAkhir', $data['tglAkhir']);
             $this->db->bind('Keterangan', $data['Keterangan']);
 
             $this->db->bind('FileDocument', $awsImages);
 
             $this->db->bind('JenisDocument', $data['jenisdoc']);
 
             $this->db->bind('Provider', $ro);
             $this->db->bind('date_update', $datetime);
             $this->db->bind('user_update', $namauserx);
             $this->db->bind('EXTENSION', $ext);
             $this->db->execute();
             $this->db->Commit();
             $callback = array(
                 'status' => 'success',
                 'message' => ' Upload Data Succesfully.',
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
        else{
            try{

                // var_dump($data);
                // exit;
                $id = $data['iddatax'];
                $tglAwal = $data['tglAwal'];
                $tglAkhir = $data['tglAkhir'];
                $Keterangan = $data['Keterangan'];
                
                $FileDocument = $awsImages;
                $JenisDocument = $data['jenisdoc'];
                $EXTENSION = $ext;


            //     ([Id_data]
            // ,[TglAwal]
            // ,[TglAkhir]
            // ,[Keterangan]
            // ,[JenisDocument]
            // ,[FileDocument]
            // ,[Extension]
            // ,[date_update]
            // ,[user_update]
            // ,[Provider])
            
                $this->db->transaksi();
                $this->db->query("UPDATE HRDYARSI.[dbo].[Data SKPegawai] SET 
                TglAwal = :tglAwal,
                TglAkhir = :tglAkhir,
                Keterangan = :Keterangan,
                FileDocument = :FileDocument,
                JenisDocument = :JenisDocument,
                Extension = :EXTENSION
                WHERE ID=:id");

                $this->db->bind('id', $data['iddatax']);
                $this->db->bind('tglAwal', $data['tglAwal']);
                $this->db->bind('tglAkhir', $data['tglAkhir']);
                $this->db->bind('Keterangan', $data['Keterangan']);
            
                $this->db->bind('JenisDocument', $data['jenisdoc']);
                $this->db->bind('FileDocument', $awsImages);
                $this->db->bind('EXTENSION', $ext);

                // var_dump($nama);
                // var_dump($FileDocument);
                // exit;
                // $this->db->bind('EXTENSION', $ext);
                
                $this->db->execute();
                $this->db->commit();
                $callback = array(
                    'status' => 'success', // Set array status dengan success   
                    'message' => 'Transkasi Berhasil!', // Set array status dengan success    
                    
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
        
    }

    public function getDataListSKPegawai($data)
    {
        try {
//contoh
            $query = "SELECT ID,Id_Data,TglAwal, TglAkhir, Keterangan, JenisDocument,FileDocument,Extension,date_update,user_update
            FROM HRDYARSI.dbo.[Data SKPegawai]
            WHERE Id_Data=:ID_Data";
            $this->db->query($query);
            $this->db->bind('ID_Data', $data['doc_nomr']);

            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {
                // $pasing['NO'] = $No++;
                $pasing['ID'] = $row['ID'];
                $pasing['Id_Data'] = $row['Id_Data'];
                $pasing['TglAwal'] = $row['TglAwal'];
                $pasing['TglAkhir'] = $row['TglAkhir'];
                $pasing['Keterangan'] = $row['Keterangan'];
                $pasing['JenisDocument'] = $row['JenisDocument'];
                $pasing['URL'] = $row['FileDocument'];
                $pasing['EXTENSION'] = $row['Extension'];
                $pasing['date_update'] = $row['date_update'];
                $pasing['user_update'] = $row['user_update'];
                $rows[] = $pasing;
//contoh
            // $query = "SELECT *,replace(CONVERT(VARCHAR(11), TglAwal, 111), '/','-') as tglawal,
            // replace(CONVERT(VARCHAR(11), TglAkhir, 111), '/','-') as tglakhir
            // FROM HRDYARSI.dbo.[Data SKPegawai]
            // WHERE Id_data=:ID_Data";
            // $this->db->query($query);
            // $this->db->bind('ID_Data', $data['doc_nomr']);

            // $data =  $this->db->resultSet();
            // $rows = array();
            // $array = array();
            // $No = 1;
            // foreach ($data as $row) {
            //      $pasing['NO'] = $No++;
            //     $pasing['Id_data'] = $row['Id_Data'];

            //     $pasing['TglAwal'] = $row['tglawal'];
            //     $pasing['TglAkhir'] = $row['tglakhir'];
            //     $pasing['Keterangan'] = $row['Keterangan'];

            //     $pasing['JenisDocument'] = $row['JenisDocument'];
            //     $pasing['URL'] = $row['FileDocument'];
            //     $pasing['EXTENSION'] = $row['Extension'];
            //     $pasing['date_update'] = $row['date_update'];
            //     $pasing['user_update'] = $row['user_update'];
            //     $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}