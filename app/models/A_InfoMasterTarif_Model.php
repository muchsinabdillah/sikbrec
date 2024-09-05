<?php
class A_InfoMasterTarif_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function GetDataTarifRajal($data)
    {
        try {
            $kode = $data['x'];
            $query = "SELECT    a.ID,[Product Code]  , a.CategoryProduct, [Product Name] , adm, SewaAlat, BHP 
            ,JasaDokterGakin,JasaDokterJamsostek,JasaDokter,TarifJamsostek,TarifKMG,TarifRS ,b.NM_JASA, C.NM_PDP
            ,case when a.Group_Jaminan='um' then 'Umum' when a.Group_Jaminan='te' then 'Telkom' when a.Group_Jaminan='BS' then 'BPJS'  when a.Group_Jaminan='KM' then 'KMK'  else '-' end as  grupJaminan
             FROM PerawatanSQL.dbo.Tarif_RJ_UGD a
             left JOIN Keuangan.DBO.BO_M_JASA B ON A.KD_JASA collate SQL_Latin1_General_CP1_CI_AS= b.KD_JASA collate SQL_Latin1_General_CP1_CI_AS
             left join Keuangan.dbo.BO_M_PDP C ON C.KD_PDP  collate SQL_Latin1_General_CP1_CI_AS= A.KD_PDP collate SQL_Latin1_General_CP1_CI_AS where A.CodeUNIT=:kode and a.discontinue='0'
            ";

            $this->db->query($query);
            $this->db->bind('kode', $kode);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {

                $pasing['Product_Code'] = $row['Product Code'];
                $pasing['CategoryProduct'] = $row['CategoryProduct'];
                $pasing['Product_Name'] = $row['Product Name'];
                $pasing['grupJaminan'] = $row['grupJaminan'];
                $pasing['TarifRS'] = $row['TarifRS'];
                $pasing['NM_JASA'] = $row['NM_JASA'];
                $pasing['NM_PDP'] = $row['NM_PDP'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getGrupPerawatan()
    {
        try {
            $this->db->query("SELECT ID,CODEUNIT, NamaUnit
                                  from MasterdataSQL.dbo.MstrUnitPerwatan 
                                  where grup_instalasi in ('PENUNJANG','IGD','RAWAT JALAN') Order by NamaUnit");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['NamaUnit'] = $key['NamaUnit'];
                $pasing['CODEUNIT'] = $key['CODEUNIT'];
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
    public function load_data_Ranap()
    {
        try {
            // $tglakhir = $data['PeriodeAkhir'];


            $query = ("SELECT  [Product Code],CategoryProduct,[Product Name],TMedis,
            SewaAlat,BHP,Tarif,Tarifkelas3,Tarifkelas2,
           Tarifkelas1,TarifVIP,TarifSVIP,TarifICU  ,b.NM_JASA, C.NM_PDP
           ,case when a.Group_Jaminan='um' then 'Umum' when a.Group_Jaminan='te' then 'Telkom' when a.Group_Jaminan='BS' 
           then 'BPJS' when a.Group_Jaminan='KM' then 'KMK' else '-'  end as  grupJamina
            FROM RawatInapSQL.dbo.Tarif_RI a
             left JOIN Keuangan.DBO.BO_M_JASA B ON A.KD_JASA collate SQL_Latin1_General_CP1_CI_AS= b.KD_JASA 
             collate SQL_Latin1_General_CP1_CI_AS
            left join Keuangan.dbo.BO_M_PDP C ON C.KD_PDP  collate SQL_Latin1_General_CP1_CI_AS= A.KD_PDP 
            collate SQL_Latin1_General_CP1_CI_AS  where a.discontinue='0'
             order by [Product Name] asc ");

            $this->db->query($query);
            // $this->db->bind('tglawal', $tglawal);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['Product_Code'] = $key['Product Code'];
                $pasing['CategoryProduct'] = $key['CategoryProduct'];
                $pasing['Product_Name'] = $key['Product Name'];
                $pasing['Tarif'] = $key['Tarif'];
                $pasing['NM_JASA'] = $key['NM_JASA'];
                $pasing['NM_PDP'] = $key['NM_PDP'];
                $pasing['grupJamina'] = $key['grupJamina'];
                $pasing['Tarifkelas3'] = $key['Tarifkelas3'];
                $pasing['Tarifkelas2'] = $key['Tarifkelas2'];
                $pasing['Tarifkelas1'] = $key['Tarifkelas1'];
                $pasing['TarifVIP'] = $key['TarifVIP'];
                $pasing['TarifSVIP'] = $key['TarifSVIP'];
                $pasing['TarifICU'] = $key['TarifICU'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function GetDataRadiologi()
    {
        try {
            // $tglakhir = $data['PeriodeAkhir'];


            $query = ("SELECT Modality_Code, Proc_Description, ServiceCharge_O,ServiceCharge_I2,ServiceCharge_I3,ServiceCharge_I1,
            ServiceCharge_IVIP,ServiceCharge_IVIP,ServiceCharge_PS ,b.NM_JASA, C.NM_PDP
       ,case when a.Group_Jaminan='um' then 'Umum' when a.Group_Jaminan='te' then 'Telkom' when a.Group_Jaminan='BS' 
       then 'BPJS' when a.Group_Jaminan='KM' then 'KMK' else '-' end as  grupJamina 
          FROM RadiologiSQL.dbo.ProcedureRadiology a
            left JOIN Keuangan.DBO.BO_M_JASA B ON A.KD_JASA collate SQL_Latin1_General_CP1_CI_AS= b.KD_JASA 
            collate SQL_Latin1_General_CP1_CI_AS
        left join Keuangan.dbo.BO_M_PDP C ON C.KD_PDP  collate SQL_Latin1_General_CP1_CI_AS= A.KD_PDP 
        collate SQL_Latin1_General_CP1_CI_AS
         where a.discontinue='0'
        order by Proc_Description asc ");

            $this->db->query($query);
            // $this->db->bind('tglawal', $tglawal);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['Modality_Code'] = $key['Modality_Code'];
                $pasing['Proc_Description'] = $key['Proc_Description'];
                $pasing['NM_JASA'] = $key['NM_JASA'];
                $pasing['NM_PDP'] = $key['NM_PDP'];
                $pasing['grupJamina'] = $key['grupJamina'];
                $pasing['ServiceCharge_O'] = $key['ServiceCharge_O'];
                $pasing['ServiceCharge_I2'] = $key['ServiceCharge_I2'];
                $pasing['ServiceCharge_I1'] = $key['ServiceCharge_I1'];
                $pasing['ServiceCharge_IVIP'] = $key['ServiceCharge_IVIP'];
                $pasing['ServiceCharge_IVIP'] = $key['ServiceCharge_IVIP'];
                $pasing['ServiceCharge_PS'] = $key['ServiceCharge_PS'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function GetDataLaboratorium()
    {
        try {
            // $tglakhir = $data['PeriodeAkhir'];

            $query = ("  SELECT KodeKelompok,NoUrut,IDTes,NamaTes,Tarif,TarifIGD,
            TarifK3,TarifK2,TarifK1,TarifVIP,TarifVVIP,TarifPresidenSuite,
            TarifIsolasi,TarifICU,TarifPerusahaan,TJamsostek,TGakin ,b.NM_JASA, C.NM_PDP
            ,case when a.Group_Jaminan='um' then 'Umum' when a.Group_Jaminan='te' then 'Telkom' when a.Group_Jaminan='BS' then 'BPJS' when a.Group_Jaminan='KM' then 'KMK' else '-' end as  grupJamina 
             FROM LaboratoriumSQL.dbo.tblGrouping a
                 left JOIN Keuangan.DBO.BO_M_JASA B ON A.KD_JASA collate SQL_Latin1_General_CP1_CI_AS= b.KD_JASA collate SQL_Latin1_General_CP1_CI_AS
             left join Keuangan.dbo.BO_M_PDP C ON C.KD_PDP  collate SQL_Latin1_General_CP1_CI_AS= A.KD_PDP collate SQL_Latin1_General_CP1_CI_AS 
             where InLevel='1'   and a.discontinue='0'
              order by NamaTes asc ");

            $this->db->query($query);
            // $this->db->bind('tglawal', $tglawal);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['KodeKelompok'] = $key['KodeKelompok'];
                $pasing['NoUrut'] = $key['NoUrut'];
                $pasing['IDTes'] = $key['IDTes'];
                $pasing['NamaTes'] = $key['NamaTes'];
                $pasing['NM_JASA'] = $key['NM_JASA'];
                $pasing['NM_PDP'] = $key['NM_PDP'];
                $pasing['grupJamina'] = $key['grupJamina'];
                $pasing['Tarif'] = $key['Tarif'];
                $pasing['TarifIGD'] = $key['TarifIGD'];
                $pasing['TarifK3'] = $key['TarifK3'];
                $pasing['TarifK2'] = $key['TarifK2'];
                $pasing['TarifK1'] = $key['TarifK1'];
                $pasing['TarifVIP'] = $key['TarifVIP'];
                $pasing['TarifVVIP'] = $key['TarifVVIP'];
                $pasing['TarifPresidenSuite'] = $key['TarifPresidenSuite'];
                $pasing['TarifIsolasi'] = $key['TarifIsolasi'];
                $pasing['TarifICU'] = $key['TarifICU'];
                $pasing['TarifPerusahaan'] = $key['TarifPerusahaan'];
                $pasing['TJamsostek'] = $key['TJamsostek'];
                $pasing['TGakin'] = $key['TGakin'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getDataOperasi()
    {
        try {
            $query = (" SELECT id_paket,nama_paket,nilai_paket,nilai_paket_kelas2,nilai_paket_kelas1,nilai_paket_JuniorS,nilai_paket_PresidentS
            ,nilai_paket_ExecutiveS,nilai_paket_PresidentS
            ,keterangan_paket,
             case when aktif='1' then 'Aktif' else 'Tidak Aktif' end as aktif FROM PerawatanSQL.dbo.Tarif_Paket_Operasi order by nama_paket asc ");

            $this->db->query($query);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['id_paket'] = $key['id_paket'];
                $pasing['NamaPaket'] = $key['nama_paket'];
                $pasing['Kelas3'] = $key['nilai_paket'];
                $pasing['Kelas2'] = $key['nilai_paket_kelas2'];
                $pasing['Kelas1'] = $key['nilai_paket_kelas1'];
                $pasing['Juniorsuite'] = $key['nilai_paket_JuniorS'];
                $pasing['Executivesuite'] = $key['nilai_paket_ExecutiveS'];
                $pasing['Presidentsuite'] = $key['nilai_paket_PresidentS'];
                $pasing['Keterangan'] = $key['keterangan_paket'];
                $pasing['Status'] = $key['aktif'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function ShowDetailOperasi($data)
    {
        try {
            $idpaket = $data['id_paket'];

            $query = (" SELECT * FROM PerawatanSQL.dbo.Tarif_Paket_Operasi_2 where id_paket=:idpaket AND batal='0'");

            $this->db->query($query);
            $this->db->bind('idpaket', $idpaket);
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['Deskripsi'] = $key['nama_item_detil'];
                $pasing['Kelompok_Item'] = $key['group_paket_detil'];
                $pasing['QTY'] = $key['qty'];
                $pasing['Kelas3'] = $key['nilai_item_detil'];
                $pasing['Kelas2'] = $key['nilai_paket_kelas2'];
                $pasing['Kelas1'] = $key['nilai_paket_kelas1'];
                $pasing['Junior_Suite'] = $key['nilai_paket_JuniorS'];
                $pasing['Executive'] = $key['nilai_paket_ExecutiveS'];
                $pasing['resident_Suite'] = $key['nilai_paket_PresidentS'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function getGroupmcu()
    {
        try {
            $this->db->query("SELECT IDMCU,NamaPaket FROM PerawatanSQL.dbo.Tarif_MCU where Header='1' AND Discontinue='0' order by NamaPaket ASC
           ");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['IDMCU'] = $key['IDMCU'];
                $pasing['NamaPaket'] = $key['NamaPaket'];

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
    public function GetDataTarif($data)
    {
        try {
            $id = $data['NamaPaket'];
            // $AwalMasaBerlaku = $data['AwalMasaBerlaku'];
            // $AkhirMasaBerlaku = $data['AkhirMasaBerlaku'];

            $query = ("SELECT *, replace(CONVERT(VARCHAR(11), AwalMasaBerlaku, 111), '/','-') as AwalMasaBerlaku, replace(CONVERT(VARCHAR(11), AkhirMasaBerlaku, 111), '/','-')
            as AkhirMasaBerlaku FROM PerawatanSQL.dbo.Tarif_MCU where NamaPaket = :id AND Header='1'
            ");
            $this->db->query($query);
            $this->db->bind('id', $id);
            // $this->db->bind('AwalMasaBerlaku', $AwalMasaBerlaku);
            // $this->db->bind('AkhirMasaBerlaku', $AkhirMasaBerlaku);

            $data =  $this->db->single();
            $pasing['IDMCU'] = $data['IDMCU'];
            $pasing['NamaPaket'] = $data['NamaPaket'];
            $pasing['AwalMasaBerlaku'] = $data['AwalMasaBerlaku'];
            $pasing['AkhirMasaBerlaku'] = $data['AkhirMasaBerlaku'];
            $pasing['Tarif'] = $data['Tarif'];
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function LoadDataMCU($data)
    {
        try {
            $NamaPaket = $data['NamaPaket'];
            $query = ("SELECT * FROM PerawatanSQL.dbo.Tarif_MCU where NamaPaket = :NamaPaket AND Header='0'");

            $this->db->query($query);
            $this->db->bind('NamaPaket', $NamaPaket);

            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $row) {

                $pasing['Pemeriksaan'] = $row['Pemeriksaan'];
                $pasing['Lokasi_Pemeriksaan'] = $row['LokasiPemeriksaan'];
                $pasing['Pemeriksaan_penunjang'] = $row['Keterangan'];
                $pasing['IdTes'] = $row['IdTes'];
                $pasing['Tarif'] = $row['Tarif'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getDataGroupSpesialis($data)
    {
        try {
            $this->db->query("SELECT BagianID,Bagian FROM RawatInapSQL.dbo.tblBagian order by Bagian ");
            $data =  $this->db->resultSet();
            $this->db->closeCon();
            $rows = array();
            foreach ($data as $key) {
                $pasing['BagianID'] = $key['BagianID'];
                $pasing['Bagian'] = $key['Bagian'];
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

    public function getKategoriOperasi()
    {
        try {
            $this->db->query("SELECT distinct *
            from RawatInapSQL.dbo.tblGroup");

            $data =  $this->db->resultSet();
            $this->db->closeCon();
            $rows = array();
            foreach ($data as $key) {
                $pasing['BagianID'] = $key['BagianID'];
                $pasing['Kategori'] = $key['Kategori'];
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
    public function getTindakanOperasi($data)
    {
        try {
            $BagianID = $data['BagianID'];
            $Kategori = $data['Kategori'];

            $query = ("SELECT GroupID,GroupName,Case when Group_Jaminan = 'TE' then '(TELKOM)' when Group_Jaminan='BS' 
            then '(BPJS)' when Group_Jaminan='KM' then '(KMK)' else '(UMUM)' end as grup_jaminan
                    from RawatInapSQL.dbo.tblGroup where BagianID=:BagianID AND Kategori=:Kategori  ");


            $this->db->query($query);
            $this->db->bind('BagianID', $BagianID);
            $this->db->bind('Kategori', $Kategori);

            $data =  $this->db->single();
            $pasing['BagianID'] = $data['BagianID'];
            $pasing['Kategori'] = $data['Kategori'];

            $pasing['GroupID'] = $data['GroupID'];
            $pasing['GroupName'] = $data['GroupName'];
            $pasing['grup_jaminan'] = $data['grup_jaminan'];

            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing
            );
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
