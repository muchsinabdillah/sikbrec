<?php
class A_MasterDataTarifRadiologi_Model 
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getTarifRadiologiCombo($data)
    {
        try {
            $Discontinue = '0';
            //$Group_Jaminan = 'UM';
            $noregistrasi = $data['noregistrasi'];
                $this->db->query("SELECT ID,Proc_Description, Proc_Code, Proc_ActionCode,
                ServiceCharge_O , ServiceCharge_I1, ServiceCharge_I2, 
                ServiceCharge_I3, ServiceCharge_IVIP, ServiceCharge_ISVIP,
                Modality_Code,position FROM 
            RadiologiSQL.dbo.ProcedureRadiology 
            where Discontinue=:Discontinue and Group_Jaminan=(
            SELECT 
            CASE WHEN a.PatientType='2' then c.Group_Jaminan
            else b.Group_Jaminan end as grup_jaminan
            FROM PerawatanSQL.dbo.Visit a 
            LEFT JOIN MasterDataSQL.dbo.MstrPerusahaanJPK b on a.Perusahaan=b.ID
            LEFT JOIN MasterdataSQL.dbo.MstrPerusahaanAsuransi c on a.Asuransi=c.ID
            WHERE NoRegistrasi=:noregistrasi
            UNION ALL
            SELECT 
            CASE WHEN a.TypePatient='2' then c.Group_Jaminan
            else b.Group_Jaminan end as grup_jaminan
             FROM RawatInapSQL.dbo.Inpatient a 
            LEFT JOIN MasterdataSQL.dbo.MstrPerusahaanJPK b on a.IDJPK=b.ID
            LEFT JOIN MasterdataSQL.dbo.MstrPerusahaanAsuransi c on a.IDAsuransi=c.ID
            WHERE NoRegRI=:noregistrasi2
            )  ");
                $this->db->bind('Discontinue', $Discontinue);
                $this->db->bind('noregistrasi', $noregistrasi);
                $this->db->bind('noregistrasi2', $noregistrasi);
                $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['Proc_Description'] = $key['Proc_Description'];
                $pasing['ServiceCharge_O'] = $key['ServiceCharge_O'];
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
    public function getTarifRadbyId($data)
    {
        try {
            $idTarif = $data['Rad_Select'];
            $this->db->query("SELECT ID, COGS, PACS, BHP, Kontras, DVD, Category, Proc_Code, Proc_Description, Modality_Code, 
                          Proc_ActionCode, Proc_Instance_UID, ServiceCharge_O, ServiceCharge_I1, ServiceCharge_I2, ServiceCharge_I3, 
                          ServiceCharge_IVIP, ServiceCharge_ISVIP, ServiceCharge_PS, TempReport1, TempReport2, TempReport3, ShareDokter, 
                          ShareRS, position, flag_poli
                          FROM            RadiologiSQL.dbo.ProcedureRadiology where ID=:idTarif");
            $this->db->bind('idTarif', $idTarif); 
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success',
                'Proc_Code' => $data['Proc_Code'],
                'Proc_Description' => $data['Proc_Description'],
                'Modality_Code' => $data['Modality_Code'],
                'Proc_ActionCode' => $data['Proc_ActionCode'],
                'Proc_Instance_UID' => $data['Proc_Instance_UID'],
                'ServiceCharge_O' => $data['ServiceCharge_O'],
                'position' => $data['position'],
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