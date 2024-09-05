<?php

use \Ramsey\Uiid\Uuid;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;

class MasterDataDokter_Model
{
    private $db;
    use ApiRsyarsi;
    use SatuSehat;
    use SatuSehatPractitioner;
    public function __construct()
    {
        $this->db = new Database;
    }

    // private $db;

    // public function __construct()
    // {
    //     $this->db = new Database;
    // }

    public function getAllDataDokter()
    {
        try {
            $this->db->query("SELECT ID,[Job Title],First_Name,case when active='1' then 'AKTIF' else 'TIDAK AKTIF' end as active,
                        idDoktertKemkes,NoIdentitasKTP
                        from MasterdataSQL.dbo.Doctors where active='1'");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['First_Name'] = $key['First_Name'];
                $pasing['JobTitle'] = $key['Job Title'];
                $pasing['active'] = $key['active'];
                $pasing['idDoktertKemkes'] = $key['idDoktertKemkes'];
                $pasing['NoIdentitasKTP'] = $key['NoIdentitasKTP'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getAllDataDokterAktif()
    {
        try {
            $this->db->query("SELECT ID,[Job Title],First_Name,case when active='1' then 'AKTIF' else 'TIDAK AKTIF' end as active ,
                        Pendidikan,Description, Pelatihan, CASE WHEN foto IS NULL THEN 'BELUM ADA' else '' END AS fotodokter
                        from MasterdataSQL.dbo.Doctors where active='1' order by  8 desc");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['First_Name'] = $key['First_Name'];
                $pasing['Pendidikan'] = $key['Pendidikan'];
                $pasing['Description'] = $key['Description'];
                $pasing['Pelatihan'] = $key['Pelatihan'];
                $pasing['active'] = $key['active'];
                $pasing['fotodokter'] = $key['fotodokter'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    // INSERT
    public function insert($data)
    {
        try {
            $this->db->transaksi();

            if ($data['NamaDokter'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Nama Dokter!',
                );
                return $callback;
                exit;
            }
            if ($data['Spesialis'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Spesialis !',
                );
                return $callback;
                exit;
            }
            if ($data['JobTitle'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Job Title !',
                );
                return $callback;
                exit;
            }
            if ($data['Category'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Category !',
                );
                return $callback;
                exit;
            }
            if ($data['GrupPerawatan'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Grup Perawatan !',
                );
                return $callback;
                exit;
            }
            if ($data['ShareKonsul'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Share Konsul !',
                );
                return $callback;
                exit;
            }
            if ($data['Praktek'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Praktek !',
                );
                return $callback;
                exit;
            }
            if ($data['Status'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Status !',
                );
                return $callback;
                exit;
            }
            if ($data['Permanen'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Permanen !',
                );
                return $callback;
                exit;
            }
            if ($data['FSFI'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input FS FI !',
                );
                return $callback;
                exit;
            }
            if ($data['FSFIProsen'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input FS FI Prosen!',
                );
                return $callback;
                exit;
            }
            if ($data['NilaiFI'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Nilai FI!',
                );
                return $callback;
                exit;
            }
            if ($data['FSGIGF'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input FS GI GF!',
                );
                return $callback;
                exit;
            }
            if ($data['NilaiGIGF'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Nilai GI GF!',
                );
                return $callback;
                exit;
            }
            if ($data['KodeTipeJasa'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Kode Tipe Jasa!',
                );
                return $callback;
                exit;
            }

            if ($data['CodeAntrian'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Code Antrian !',
                );
                return $callback;
                exit;
            }
            if ($data['Pendidikan'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Pendidikan !',
                );
                return $callback;
                exit;
            }
            if ($data['Description'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Description !',
                );
                return $callback;
                exit;
            }
            if ($data['Pelatihan'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Pelatihan !',
                );
                return $callback;
                exit;
            }
            $nama = strlen($data['NamaDokter']);
            if ($nama > 50) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Simpan Gagal! Nama Dokter Harus Kurang Dari 50 Karakter !',
                );
                return $callback;
                exit;
            }

            $IdAuto = $data['IdAuto'];
            $NamaDokter = $data['NamaDokter'];
            $Spesialis = $data['Spesialis'];
            $JobTitle = $data['JobTitle'];
            $Category = $data['Category'];
            $GrupPerawatan = $data['GrupPerawatan'];
            $AlamatDokter = $data['AlamatDokter'];
            $Kota = $data['Kota'];
            $TglLahirDokter = $data['TglLahirDokter'];
            $TlpDokter = $data['TlpDokter'];
            $NOHP = $data['NOHP'];
            $EmailDokter = $data['EmailDokter'];
            $FixSalary = $data['FixSalary'];
            $NOSIP = $data['NOSIP'];
            $ShareKonsul = $data['ShareKonsul'];
            $Praktek = $data['Praktek'];
            $Status = $data['Status'];
            $Permanen = $data['Permanen'];
            $NPWP = $data['NPWP'];
            $NamaBank = $data['NamaBank'];
            $Norek = $data['Norek'];
            $AtasnamaRek = $data['AtasnamaRek'];
            $FSFI = $data['FSFI'];
            $FSFIProsen = $data['FSFIProsen'];
            $NilaiFI = $data['NilaiFI'];
            $FSGIGF = $data['FSGIGF'];
            $NilaiGIGF = $data['NilaiGIGF'];
            $KodeTipeJasa = $data['KodeTipeJasa'];
            $GroupSpesialis = $data['GroupSpesialis'];
            $Pendidikan = $data['Pendidikan'];
            $Description = $data['Description'];
            $Pelatihan = $data['Pelatihan'];
            $NIK = $data['NIK'];


            $CodeAntrian = $data['CodeAntrian'];
            $IDDokter_BPJS = $data['IDDokter_BPJS'];
            if ($IDDokter_BPJS == '') {
                $IDDokter_BPJS = null;
            }
            if ($NIK == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input No. Identitas NIK KTP Dokter !',
                );
                return $callback;
                exit;
            }
            if ($data['IdAuto'] == "") {

                //CEK Double ID Dokter BPJS
                $this->db->query("SELECT * from MasterdataSQL.dbo.Doctors
                                where ID_Dokter_BPJS=:IDDokter_BPJS and active='1'");
                $this->db->bind('IDDokter_BPJS', $IDDokter_BPJS);
                $data =  $this->db->resultSet();
                //var_dump(count($data));exit;
                if (count($data) > 0) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Sudah Ada ID Dokter BPJS Dengan ID Tersebut ! Silahkan Diperiksa Kembali !',
                    );
                    return $callback;
                    exit;
                }

                //CEK Double Code Antrian
                $this->db->query("SELECT * from MasterdataSQL.dbo.Doctors
                where CodeAntrian=:CodeAntrian and active='1'");
                $this->db->bind('CodeAntrian', $CodeAntrian);
                $data =  $this->db->resultSet();
                //var_dump(count($data));exit;
                if (count($data) > 0) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Sudah Ada Code Antrian Dengan Code Tersebut !',
                    );
                    return $callback;
                    exit;
                }

                $this->db->query("INSERT INTO MasterdataSQL.dbo.Doctors (First_Name,Spesialis,[Job Title],designationId,GroupPerawatan,Address,City,
                    Birth_Date,Phone,Mob_Phone,Email,Fix_Salary,jasmed,NoSIP,active,Permanen,Praktek,NPWP_No,Nama_Bank_Transfer,No_Bank_Transfer,Atas_Nama_Transfer,FS_FI,FS_FI_PROSEN,NILAI_FI,FS_GI_GF,NILAI_GI_GF,KD_TIPE_JASA,GroupSpesialis,CodeAntrian,ID_Dokter_BPJS,Pendidikan,Description,Pelatihan,NoIdentitasKTP) VALUES
                  (:NamaDokter,:Spesialis,:JobTitle,:Category,:GrupPerawatan,:AlamatDokter,:Kota,:TglLahirDokter,:TlpDokter,:NOHP,:EmailDokter,:FixSalary,:ShareKonsul,:NOSIP,:Status,:Permanen,:Praktek,:NPWP,:NamaBank,:Norek,:AtasnamaRek,:FSFI,:FSFIProsen,:NilaiFI,:FSGIGF,:NilaiGIGF,:KodeTipeJasa,:GroupSpesialis,:CodeAntrian,:IDDokter_BPJS,:Pendidikan,:Description,:Pelatihan,:NoIdentitasKTP)");
            } else {

                //CEK Double ID Dokter BPJS
                $this->db->query("SELECT * from MasterdataSQL.dbo.Doctors
                                where ID_Dokter_BPJS=:IDDokter_BPJS and active='1' AND ID<>:IdAuto");
                $this->db->bind('IDDokter_BPJS', $IDDokter_BPJS);
                $this->db->bind('IdAuto', $IdAuto);
                $data =  $this->db->resultSet();
                //var_dump(count($data));exit;
                if (count($data) > 0) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Sudah Ada ID Dokter BPJS Dengan ID Tersebut ! Silahkan Diperiksa Kembali !',
                    );
                    return $callback;
                    exit;
                }

                //CEK Double Code Antrian
                $this->db->query("SELECT * from MasterdataSQL.dbo.Doctors
                where CodeAntrian=:CodeAntrian and active='1' AND ID<>:IdAuto");
                $this->db->bind('CodeAntrian', $CodeAntrian);
                $this->db->bind('IdAuto', $IdAuto);
                $data =  $this->db->resultSet();
                //var_dump(count($data));exit;
                if (count($data) > 0) {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Sudah Ada Code Antrian Dengan Code Tersebut !',
                    );
                    return $callback;
                    exit;
                }

                $this->db->query("UPDATE MasterdataSQL.dbo.Doctors set  
                            First_Name=:NamaDokter,Spesialis=:Spesialis,[Job Title]=:JobTitle,designationId=:Category,GroupPerawatan=:GrupPerawatan,Address=:AlamatDokter,City=:Kota,
                    Birth_Date=:TglLahirDokter,Phone=:TlpDokter,Mob_Phone=:NOHP,Email=:EmailDokter,Fix_Salary=:FixSalary,jasmed=:ShareKonsul,NoSIP=:NOSIP,active=:Status,Permanen=:Permanen,Praktek=:Praktek,NPWP_No=:NPWP,Nama_Bank_Transfer=:NamaBank,No_Bank_Transfer=:Norek,Atas_Nama_Transfer=:AtasnamaRek,FS_FI=:FSFI,FS_FI_PROSEN=:FSFIProsen,NILAI_FI=:NilaiFI,FS_GI_GF=:FSGIGF,NILAI_GI_GF=:NilaiGIGF,KD_TIPE_JASA=:KodeTipeJasa,GroupSpesialis=:GroupSpesialis,CodeAntrian=:CodeAntrian,ID_Dokter_BPJS=:IDDokter_BPJS, Pendidikan=:Pendidikan, Description=:Description, Pelatihan=:Pelatihan,
                    NoIdentitasKTP=:NoIdentitasKTP
                            WHERE ID=:IdAuto");
                $this->db->bind('IdAuto', $IdAuto);
            }
            $this->db->bind('NamaDokter', $NamaDokter);
            $this->db->bind('Spesialis', $Spesialis);
            $this->db->bind('JobTitle', $JobTitle);
            $this->db->bind('Category', $Category);
            $this->db->bind('GrupPerawatan', $GrupPerawatan);
            $this->db->bind('AlamatDokter', $AlamatDokter);
            $this->db->bind('Kota', $Kota);
            $this->db->bind('TglLahirDokter', $TglLahirDokter);
            $this->db->bind('TlpDokter', $TlpDokter);
            $this->db->bind('NOHP', $NOHP);
            $this->db->bind('EmailDokter', $EmailDokter);
            $this->db->bind('FixSalary', $FixSalary);
            $this->db->bind('NOSIP', $NOSIP);
            $this->db->bind('ShareKonsul', $ShareKonsul);
            $this->db->bind('Praktek', $Praktek);
            $this->db->bind('Status', $Status);
            $this->db->bind('Permanen', $Permanen);
            $this->db->bind('NPWP', $NPWP);
            $this->db->bind('NamaBank', $NamaBank);
            $this->db->bind('Norek', $Norek);
            $this->db->bind('AtasnamaRek', $AtasnamaRek);
            $this->db->bind('FSFI', $FSFI);
            $this->db->bind('FSFIProsen', $FSFIProsen);
            $this->db->bind('NilaiFI', $NilaiFI);
            $this->db->bind('FSGIGF', $FSGIGF);
            $this->db->bind('NilaiGIGF', $NilaiGIGF);
            $this->db->bind('KodeTipeJasa', $KodeTipeJasa);
            $this->db->bind('GroupSpesialis', $GroupSpesialis);
            $this->db->bind('CodeAntrian', $CodeAntrian); 
            $this->db->bind('IDDokter_BPJS', $IDDokter_BPJS);
            $this->db->bind('Pendidikan', $Pendidikan);
            $this->db->bind('Description', $Description);
            $this->db->bind('Pelatihan', $Pelatihan);
            $this->db->bind('NoIdentitasKTP', $NIK);

            
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
    public function getDokterId($id)
    {
        try {
            $this->db->query("SELECT replace(CONVERT(VARCHAR(11), Birth_Date, 111), '/','-') as Birth_Date2,
                 CASE WHEN FS_FI='0' THEN 'TIDAK' WHEN FS_FI='1' THEN 'YA' END YES_FI,
                 NILAI_FI AS YES_FI_VALUE, FS_GI_GF as YES_GI_GF, NILAI_GI_GF AS YES_NILAI_GI_GF,idDoktertKemkes,
                 * from MasterdataSQL.dbo.Doctors
                        WHERE ID=:id");
            $this->db->bind('id', $id);
            $data =  $this->db->single();
            $pasing['ID'] = $data['ID'];
            $pasing['idDoktertKemkes'] = $data['idDoktertKemkes'];
            $pasing['NAMA_Dokter_BPJS'] = $data['NAMA_Dokter_BPJS'];
            $pasing['First_Name'] = $data['First_Name'];
            $pasing['Spesialis'] = $data['Spesialis'];
            $pasing['Job_Title'] = $data['Job Title'];
            $pasing['GroupPerawatan'] = $data['GroupPerawatan'];
            $pasing['Address'] = $data['Address'];
            $pasing['City'] = $data['City'];
            $pasing['Birth_Date'] = $data['Birth_Date2'];
            $pasing['designationId'] = $data['designationId'];
            $pasing['Phone'] = $data['Phone'];
            $pasing['Mob_Phone'] = $data['Mob_Phone'];
            $pasing['Email'] = $data['Email'];
            $pasing['Fix_Salary'] = $data['Fix_Salary'];
            $pasing['NoSIP'] = $data['NoSIP'];
            $pasing['Praktek'] = $data['Praktek'];
            $pasing['jasmed'] = $data['jasmed'];
            $pasing['active'] = $data['active'];
            $pasing['Permanen'] = $data['Permanen'];
            $pasing['NPWP_No'] = $data['NPWP_No'];
            $pasing['Nama_Bank_Transfer'] = $data['Nama_Bank_Transfer'];
            $pasing['No_Bank_Transfer'] = $data['No_Bank_Transfer'];
            $pasing['Atas_Nama_Transfer'] = $data['Atas_Nama_Transfer'];
            $pasing['FS_FI'] = $data['FS_FI'];
            $pasing['FS_FI_PROSEN'] = $data['FS_FI_PROSEN'];
            $pasing['NILAI_FI'] = $data['NILAI_FI'];
            $pasing['FS_GI_GF'] = $data['FS_GI_GF'];
            $pasing['NILAI_GI_GF'] = $data['NILAI_GI_GF'];
            $pasing['KD_TIPE_JASA'] = $data['KD_TIPE_JASA'];
            $pasing['GroupSpesialis'] = $data['GroupSpesialis'];

            $pasing['ID_Dokter_BPJS'] = $data['ID_Dokter_BPJS'];
            $pasing['CodeAntrian'] = $data['CodeAntrian'];
            $pasing['Pendidikan'] = $data['Pendidikan'];
            $pasing['Description'] = $data['Description'];
            $pasing['Pelatihan'] = $data['Pelatihan'];
            $pasing['NoIdentitasKTP'] = $data['NoIdentitasKTP'];

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

    public function getJobTitle()
    {
        try {
            $this->db->query("SELECT [Job Title]
                              from MasterdataSQL.dbo.Doctors  group by [Job Title]");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['JobTitle'] = $key['Job Title'];
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

    public function getGrupPerawatan()
    {
        try {
            $this->db->query("SELECT ID, NamaUnit
                                  from MasterdataSQL.dbo.MstrUnitPerwatan 
                                  where grup_instalasi in ('PENUNJANG','IGD','RAWAT JALAN') Order by NamaUnit");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['NamaUnit'] = $key['NamaUnit'];
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

    public function getDataLayanan($id)
    {
        try {
            $this->db->query("SELECT a.ID,a.IdDoctors,b.First_Name,c.NamaUnit
                                           from MasterdataSQL.dbo.Doctors_2 a
                                           inner join MasterdataSQL.dbo.Doctors b on a.IdDoctors =b.ID
                                           inner join MasterdataSQL.dbo.MstrUnitPerwatan c on a.IdLayanan =c.ID
                                           where a.IdDoctors=:id");
            $this->db->bind('id', $id);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['ID'] = $key['ID'];
                $pasing['IdDoctors'] = $key['IdDoctors'];
                $pasing['First_Name'] = $key['First_Name'];
                $pasing['NamaUnit'] = $key['NamaUnit'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function insert_layanan($data)
    {
        try {
            $this->db->transaksi();

            if ($data['GrupPerawatan'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Layanan!',
                );
                return $callback;
                exit;
            }

            $IdAuto = $data['IdAuto'];
            $GrupPerawatan = $data['GrupPerawatan'];

            $this->db->query("SELECT IdDoctors from MasterdataSQL.dbo.Doctors_2 
                                where IdDoctors=:IdAuto and IdLayanan=:GrupPerawatan");
            $this->db->bind('IdAuto', $IdAuto);
            $this->db->bind('GrupPerawatan', $GrupPerawatan);
            $data =  $this->db->resultSet();
            //var_dump(count($data));exit;
            if (count($data) > 0) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Sudah Ada Layanan Dengan Dokter Tersebut!',
                );
                return $callback;
                exit;
            }

            $this->db->query("INSERT INTO MasterdataSQL.dbo.Doctors_2 (IdDoctors,IdLayanan) VALUES
                (:IdAuto,:GrupPerawatan)");

            $this->db->bind('IdAuto', $IdAuto);
            $this->db->bind('GrupPerawatan', $GrupPerawatan);

            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'IdDoctors' => $IdAuto, // Set array status dengan success  
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function delete_layanan($IdDoctors_2)
    {
        try {
            $this->db->transaksi();


            $this->db->query("DELETE MasterdataSQL.dbo.Doctors_2 
                                WHERE ID=:IdDoctors_2");
            $this->db->bind('IdDoctors_2', $IdDoctors_2);

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
    public function getDokterIdbyCutiJadwal($id)
    {
        try {
            $this->db->query("SELECT replace(CONVERT(VARCHAR(11), Birth_Date, 111), '/','-') as Birth_Date2,
                 CASE WHEN FS_FI='0' THEN 'TIDAK' WHEN FS_FI='1' THEN 'YA' END YES_FI,
                 NILAI_FI AS YES_FI_VALUE, FS_GI_GF as YES_GI_GF, NILAI_GI_GF AS YES_NILAI_GI_GF,
                 * from MasterdataSQL.dbo.Doctors
                        WHERE ID=:id");
            $this->db->bind('id', $id);
            $data =  $this->db->single();
            $pasing['ID'] = $data['ID'];
            $pasing['First_Name'] = $data['First_Name'];
            $pasing['Spesialis'] = $data['Spesialis'];
            $pasing['Job_Title'] = $data['Job Title'];
            $pasing['GroupPerawatan'] = $data['GroupPerawatan'];
            $pasing['Address'] = $data['Address'];
            $pasing['City'] = $data['City'];
            $pasing['Birth_Date'] = $data['Birth_Date2'];
            $pasing['designationId'] = $data['designationId'];
            $pasing['Phone'] = $data['Phone'];
            $pasing['Mob_Phone'] = $data['Mob_Phone'];
            $pasing['Email'] = $data['Email'];
            $pasing['Fix_Salary'] = $data['Fix_Salary'];
            $pasing['NoSIP'] = $data['NoSIP'];
            $pasing['Praktek'] = $data['Praktek'];
            $pasing['jasmed'] = $data['jasmed'];
            $pasing['active'] = $data['active'];
            $pasing['Permanen'] = $data['Permanen'];
            $pasing['NPWP_No'] = $data['NPWP_No'];
            $pasing['Nama_Bank_Transfer'] = $data['Nama_Bank_Transfer'];
            $pasing['No_Bank_Transfer'] = $data['No_Bank_Transfer'];
            $pasing['Atas_Nama_Transfer'] = $data['Atas_Nama_Transfer'];
            $pasing['FS_FI'] = $data['FS_FI'];
            $pasing['FS_FI_PROSEN'] = $data['FS_FI_PROSEN'];
            $pasing['NILAI_FI'] = $data['NILAI_FI'];
            $pasing['FS_GI_GF'] = $data['FS_GI_GF'];
            $pasing['NILAI_GI_GF'] = $data['NILAI_GI_GF'];
            $pasing['KD_TIPE_JASA'] = $data['KD_TIPE_JASA'];
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
    public function getDokterLaboratorium()
    {
        try {
            $active = "1";
            $layanan = "9";
            $this->db->query("SELECT A.ID,A.First_Name
                        FROM MasterdataSQL.DBO.Doctors A 
                        INNER JOIN MasterdataSQL.DBO.Doctors_2 B ON A.ID = B.IdDoctors
                        WHERE A.active=:active AND B.IdLayanan=:layanan");
            $this->db->bind('active', $active);
            $this->db->bind('layanan', $layanan);
            $data =  $this->db->resultSet();
            $this->db->closeCon();
            $rows = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['First_Name'] = $key['First_Name'];
                $rows[] = $pasing;
            }
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $rows
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    public function getDataGroupSpesialis()
    {
        try {
            $this->db->query("SELECT *
                        FROM RawatInapSQL.dbo.tblBagian");
            $data =  $this->db->resultSet();
            $this->db->closeCon();
            $rows = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['BagianID'];
                $pasing['NamaBagian'] = $key['Bagian'];
                $rows[] = $pasing;
            }
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $rows
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->closeCon();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }

    //badrul

    public function UpdateDataLanjutan($data)
    {
        try {
            // $this->db->transaksi();
            $id = $data['id'];
            $Pendidikan = $data['pendidikan'];
            $Description = $data['deskripsi'];
            $Pelatihan = $data['pelatihan'];


            $this->db->query("UPDATE MasterdataSQL.dbo.Doctors SET Pendidikan = :Pendidikan, Description = :Description, Pelatihan = :Pelatihan WHERE ID=:id");
            $this->db->bind('id', $id);
            $this->db->bind('Pendidikan', $Pendidikan);
            $this->db->bind('Description', $Description);
            $this->db->bind('Pelatihan', $Pelatihan);

            // $this->db->execute();
            // $this->db->commit();
            // $callback = array(
            //     'status' => 'success', // Set array status dengan success
            //     'message' => 'Transkasi Berhasil', // Set array status dengan success
            // );
            // return $callback;

            $this->db->execute();
            // $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Di Update !', // Set array status dengan success    
            );
            // var_dump($callback);
            // exit;
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

    //badrul
    public function uploadDataImage($data)
    { 
        
        try { 
            $this->db->transaksi();
           
                $doc_id = $data['IdAuto'];
                $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png", "pdf" => "application/pdf");
                $filetype = $_FILES["file"]["type"];
                $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
                $namafile_Image = $_FILES['file']['tmp_name'];
                $bytes = random_bytes(20);
                $nama_file_baru  = $doc_id . bin2hex($bytes) . "-" . date("YmdHis") . '.' . $ext;
                /// AWS
                // Create an S3Client+
                
                  
                $s3Client = new S3Client([
                    'version' => 'latest',
                    'region'  => 'ap-southeast-1',
                    'http'    => ['verify' => false],
                    'credentials' => [
                        'key'    => 'AKIAYV2M6ERJGUKK4QWQ',
                        'secret' => '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'
                    ]
                ]);
                $file_name_Image = $nama_file_baru;
                $source_Image =   $namafile_Image;
                $awsImages = '';

                $bucket = 'rsuyarsibucket';
                $key = basename($file_name_Image);

                $result = $s3Client->putObject([
                    'Bucket' => $bucket,
                    'Key'    => 'app/webs/doctors/' . $key,
                    'Body'   => fopen($source_Image, 'r'),
                    'ACL'    => 'public-read', // make file 'public', 
                ]);


                $awsImages_Dokter = $result->get('ObjectURL');

                return $this->SaveImage_Dokter($data,  $nama_file_baru, $awsImages_Dokter, $ext);

            
    
            
           

            


        } catch (MultipartUploadException $e) {
            return $e->getMessage();
        }
    }
     
    public function Savewithout_Image_Dokter($data)
    {
        
        try {
            $this->db->transaksi();

            $id = $data['IdAuto']; 
            $Pendidikan_Dokter = $data['Pendidikan_Dokter']; 
            $Description_Dokter = $data['Description_Dokter']; 
            $Pelatihan_Dokter = $data['Pelatihan_Dokter']; 


            $this->db->query("UPDATE MasterdataSQL.dbo.Doctors SET 
                        Pendidikan = :Pendidikan_Dokter, 
                        Description = :Description_Dokter,
                        Pelatihan = :Pelatihan_Dokter
                        WHERE ID=:id");
            $this->db->bind('id', $id);
            $this->db->bind('Pendidikan_Dokter', $Pendidikan_Dokter);
            $this->db->bind('Description_Dokter', $Description_Dokter);
            $this->db->bind('Pelatihan_Dokter', $Pelatihan_Dokter);

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
    public function SaveImage_Dokter($data,  $nama_file_baru, $awsImages_Dokter, $ext)
    {
        
        try {
            // $this->db->transaksi();

            $id = $data['IdAuto'];
            $foto = $awsImages_Dokter;


            $this->db->query("UPDATE MasterdataSQL.dbo.Doctors SET foto = :foto WHERE ID=:id");
            $this->db->bind('id', $id);
            $this->db->bind('foto', $awsImages_Dokter);

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

    public function getDataTableImage($data)
    {

        try {
            $this->db->query("SELECT ID,First_Name,foto from MasterdataSQL.dbo.Doctors where ID =:id");
            $this->db->bind('id', $data['ID']);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['First_Name'] = $key['First_Name'];
                $pasing['URLFOTODOKTER'] = $key['foto'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    //badrul
    public function PostPractitioners($data){
        $this->db->transaksi();
            $idDoktertKemkes = $data['idDoktertKemkes'];
            $First_Name = $data['First_Name'];
            $NoIdentitasKTP = $data['NoIdentitasKTP']; 



            $this->db->query("SELECT bridging_SatuSehat FROM MasterdataSQL.DBO.A_DATA_RS");
            $data =  $this->db->single();
            //no urut reg
            $bridging_SatuSehat = $data['bridging_SatuSehat'];
            if($bridging_SatuSehat == "1"){ 
                $postData = $this->SearchbyNIK($NoIdentitasKTP); 
                // 
                if($postData['total'] == "0"){
                    $callback = array(
                        'status' => "warning", // Set array nama  
                        'errorname' => 'Data Tidak Ditemukan !'
                    );
                    return $callback; 
                    
                } 
                    $this->db->query("UPDATE MasterdataSQL.dbo.Doctors set  
                    idDoktertKemkes=:Idkemenkes 
                    WHERE NoIdentitasKTP=:NoIdentitasKTP");
                    $this->db->bind('NoIdentitasKTP', $NoIdentitasKTP);
                    $this->db->bind('Idkemenkes',$postData['entry']['0']['resource']['id']); 
                    $this->db->execute();
                    $this->db->commit();
                    $callback = array(
                        'message' => "success", // Set array nama 
                        'data' => $postData['entry']['0']['resource']['id']
                    );
                    return $callback;
            }else{
                $callback = array(
                    'status' => 'warning',
                    'message' => "Bridging Satu Sehat Tidak Aktif.",
                );
                return $callback;
            }
            
    }
}
