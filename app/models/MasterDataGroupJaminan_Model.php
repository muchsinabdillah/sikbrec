<?php
class MasterDataGroupJaminan_Model 
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getAllGroupJaminan()
    {
        try {
            $this->db->query("SELECT ID,TipePasien
                            from PerawatanSQL.dbo.T_TipePasien WHERE Catergori='1' ");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['TipePasien'] = $key['TipePasien']; 
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
    public function getJaminanByIdGroup($data)
    {
        try {
            $idGroupJaminan = $data["idGroupJaminan"];
            if ($idGroupJaminan === "1" || $idGroupJaminan === "5") { // UMUM 
                $this->db->query("SELECT ID,NamaPerusahaan
                                FROM MasterdataSQL.DBO.MstrPerusahaanJPK WHERE StatusAktif='1' ");
                $data =  $this->db->resultSet();
            } elseif ($idGroupJaminan === "2") { // ASURANSI 
                $this->db->query("SELECT ID,NamaPerusahaan
                                FROM MasterdataSQL.DBO.MstrPerusahaanAsuransi WHERE StatusAktif='1'");
                $data =  $this->db->resultSet();
            }   
            
            $rows = array(); 
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['NamaPerusahaan'] = $key['NamaPerusahaan'];
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
    public function getPolis($data)
    {
        try {
            $noMR = $data["noMR"];
            $GroupJaminan = $data["GroupJaminan"];
            $NamaJaminan = $data["NamaJaminan"];
            if ($GroupJaminan === "1") { // UMUM
                $this->db->query(" SELECT a.HakKelas,a.ID,a.Keterangan,
                  a.KodeGroupJaminan,a.KodeJaminan,a.NamaPemegangKartu,a.NoKartu,
                  a.NoMR,b.NamaPerusahaan,c.TipePasien,a.StatusPasien
                  from MasterdataSQL.dbo.Admision_Kartu_Jaminan a
                  inner join  MasterdataSQL.DBO.MstrPerusahaanJPK b
                  on a.KodeJaminan = b.ID
                  inner join PerawatanSQL.dbo.T_TipePasien c
                  on c.ID = a.KodeGroupJaminan
                  where NoMR=:noMR 
                  and KodeGroupJaminan=:GroupJaminan 
                  and KodeJaminan=:NamaJaminan ");
                $this->db->bind('noMR', $noMR);
                $this->db->bind('GroupJaminan', $GroupJaminan);
                $this->db->bind('NamaJaminan', $NamaJaminan);
                $data =  $this->db->single();
            } elseif ($GroupJaminan === "2") { // ASURANSI
                $this->db->query(" SELECT a.HakKelas,a.ID,a.Keterangan,
                  a.KodeGroupJaminan,a.KodeJaminan,a.NamaPemegangKartu,a.NoKartu,
                  a.NoMR,b.NamaPerusahaan,c.TipePasien,a.StatusPasien
                  from MasterdataSQL.dbo.Admision_Kartu_Jaminan a
                  inner join  MasterdataSQL.DBO.MstrPerusahaanAsuransi b
                  on a.KodeJaminan = b.ID
                  inner join PerawatanSQL.dbo.T_TipePasien c
                  on c.ID = a.KodeGroupJaminan
                   where NoMR=:noMR 
                  and KodeGroupJaminan=:GroupJaminan 
                  and KodeJaminan=:NamaJaminan");
                $this->db->bind('noMR', $noMR);
                $this->db->bind('GroupJaminan', $GroupJaminan);
                $this->db->bind('NamaJaminan', $NamaJaminan);
                $data =  $this->db->single();
            } elseif ($GroupJaminan === "5") { // JAMINAN PERUSAHAAN
                $this->db->query("SELECT a.HakKelas,a.ID,a.Keterangan,
                  a.KodeGroupJaminan,a.KodeJaminan,a.NamaPemegangKartu,a.NoKartu,
                  a.NoMR,b.NamaPerusahaan,c.TipePasien,a.StatusPasien
                  from MasterdataSQL.dbo.Admision_Kartu_Jaminan a
                  inner join  MasterdataSQL.DBO.MstrPerusahaanJPK b
                  on a.KodeJaminan = b.ID
                  inner join PerawatanSQL.dbo.T_TipePasien c
                  on c.ID = a.KodeGroupJaminan
                   where NoMR=:noMR 
                  and KodeGroupJaminan=:GroupJaminan 
                  and KodeJaminan=:NamaJaminan");
                $this->db->bind('noMR', $noMR);
                $this->db->bind('GroupJaminan', $GroupJaminan);
                $this->db->bind('NamaJaminan', $NamaJaminan);
                $data =  $this->db->single();
            }  
            $callback = array(
                'status' => 'success', // Set array status dengan success    
                'HakKelas' => $data['HakKelas'], // Set array status dengan success    
                'ID' => $data['ID'], // Set array status dengan success    
                'Keterangan' => $data['Keterangan'], // Set array status dengan success    
                'KodeGroupJaminan' => $data['KodeGroupJaminan'], // Set array status dengan success    
                'KodeJaminan' => $data['KodeJaminan'], // Set array status dengan success    
                'NamaPemegangKartu' => $data['NamaPemegangKartu'], // Set array status dengan success    
                'NoKartu' => $data['NoKartu'], // Set array status dengan success 
                'NoMR' => $data['NoMR'], // Set array status dengan success 
                'NamaPerusahaan' => $data['NamaPerusahaan'], // Set array status dengan success 
                'TipePasien' => $data['TipePasien'], // Set array status dengan success 
                'StatusPasien' => $data['StatusPasien'], // Set array status dengan success 
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
    public function GetJaminanByIdJaminan($data)
    {
        try {
            $grupJaminanId = $data["grupJaminanId"];
            $namajaminanId = $data["namajaminanId"]; 
            if ($grupJaminanId === "1") { // UMUM
                $this->db->query("  SELECT ID,NamaPerusahaan,Group_Jaminan
                                    FROM MasterdataSQL.DBO.MstrPerusahaanJPK 
                                    WHERE StatusAktif='1' and ID=:namajaminanId");
                $this->db->bind('namajaminanId', $namajaminanId); 
                $data =  $this->db->single();
            } elseif ($grupJaminanId === "2") { // ASURANSI
                $this->db->query("  SELECT ID,NamaPerusahaan,Group_Jaminan
                                    FROM MasterdataSQL.DBO.MstrPerusahaanAsuransi 
                                    WHERE StatusAktif='1' and ID=:namajaminanId");
                $this->db->bind('namajaminanId', $namajaminanId); 
                $data =  $this->db->single();
            } else  { // JAMINAN PERUSAHAAN
                $this->db->query("  SELECT ID,NamaPerusahaan,Group_Jaminan
                                    FROM MasterdataSQL.DBO.MstrPerusahaanJPK 
                                    WHERE StatusAktif='1'  and ID=:namajaminanId");
                $this->db->bind('namajaminanId', $namajaminanId); 
                $data =  $this->db->single();
            }
            $callback = array(
                'status' => 'success', // Set array status dengan success    
                'NamaPerusahaan' => $data['NamaPerusahaan'], // Set array status dengan success
                'ID' => $data['ID'], // Set array status dengan success    
                'Group_Jaminan' => $data['Group_Jaminan'], // Set array status dengan success    
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
    public function GetPolisKaryawan($data)
    {
        try {
                $params = $data["params"];
                $this->db->query("SELECT ID_Data,Nip,Nama,Plafon_RI,Plafon_RJ,CASE 
                                WHEN Status_Aktif='1' THEN 'AKTIF' 
                                WHEN Status_Aktif='0'  THEN 'NON AKTIF'  
                                END AS Status_Aktif,
                                CASE 
                                WHEN HakKelasBPJSKes='1' THEN 'KELAS 1' 
                                WHEN HakKelasBPJSKes='2'  THEN 'KELAS 2' 
                                WHEN HakKelasBPJSKes='3'  THEN 'KELAS 3' 
                                WHEN HakKelasBPJSKes='4'  THEN 'KELAS VIP' 
                                WHEN HakKelasBPJSKes='5'  THEN 'KELAS VVIP' 
                                END AS HakKelasBPJSKes,
                                CASE 
                                WHEN HakKelasPlafonRS='1' THEN 'KELAS 1' 
                                WHEN HakKelasPlafonRS='2'  THEN 'KELAS 2' 
                                WHEN HakKelasPlafonRS='3'  THEN 'KELAS 3' 
                                WHEN HakKelasPlafonRS='4'  THEN 'KELAS VIP' 
                                WHEN HakKelasPlafonRS='5'  THEN 'KELAS VVIP' 
                                END AS HakKelasPlafonRS
                                FROM HRDYARSI.DBO.[Data Pegawai] WHERE nip=:params");
                $this->db->bind('params', $params); 
                $data =  $this->db->single();
                $callback = array(
                    'status' => 'success', // Set array status dengan success
                    'Nip' => $data['Nip'], // Set array status dengan success
                    'ID' => $data['ID_Data'], // Set array status dengan success
                    'Plafon_RI' => $data['Plafon_RI'],
                    'HakKelasBPJSKes' => $data['HakKelasBPJSKes'],
                    'Nama' => $data['Nama'], // Set array status dengan sucess
                    'Plafon_RJ' => $data['Plafon_RJ'],
                    'Status_Aktif' => $data['Status_Aktif'],
                    'HakKelasPlafonRS' => $data['HakKelasPlafonRS'], // Set array status dengan successDate_of_birth

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
