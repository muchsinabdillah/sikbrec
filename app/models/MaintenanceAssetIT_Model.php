<?php


class MaintenanceAssetIT_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function showDataMaintenance()
    {
        try { 
            $this->db->query("SELECT a.ID,b.Nama_Asset,replace(CONVERT(VARCHAR(11), 
                            a.DATE_TRANSACTION, 111), '/','-') as DATE_TRANSACTION,
                        C.[First Name] AS User_IT,
                        CASE WHEN a.M_RAM='0' THEN 'NO' ELSE 'YES' END AS M_RAM,
                        CASE WHEN a.M_CLEANING='0' THEN 'NO' ELSE 'YES' END AS M_CLEANING,
                        CASE WHEN a.M_REPAIR_OS='0' THEN 'NO' ELSE 'YES' END AS M_REPAIR_OS,
                        CASE WHEN a.M_INSTAL_APP='0' THEN 'NO' ELSE 'YES' END AS M_INSTAL_APP,
                        CASE WHEN a.M_SSD='0' THEN 'NO' ELSE 'YES' END AS M_SSD,
                        CASE WHEN a.M_CHARGER='0' THEN 'NO' ELSE 'YES' END AS M_CHARGER,
                        CASE WHEN a.M_LCD='0' THEN 'NO' ELSE 'YES' END AS M_LCD,
                        CASE WHEN a.M_ADAPTER='0' THEN 'NO' ELSE 'YES' END AS M_ADAPTER,
                        CASE WHEN a.M_KEYBOARD='0' THEN 'NO' ELSE 'YES' END AS M_KEYBOARD
                        FROM YARSI_HOSPITAL.DBO.Q_MAINTENANCE_ASSET A 
                        INNER JOIN YARSI_HOSPITAL.DBO.Q_M_Inventory_Asset  B 
                        ON A.KODE_ASSET = B.Id_Asset
						INNER JOIN MasterdataSQL.DBO.Employees C
						ON C.ID = A.USER_IT
                        WHERE BATAL='0'");
            $data =  $this->db->resultSet();
            $rows = array(); 
            $no = "1";
            foreach ($data as $key) {
                $pasing['Nama_Asset'] = $key['Nama_Asset'];
                $pasing['ID'] = $key['ID'];
                $pasing['DATE_TRANSACTION'] = date("d-m-Y",strtotime($key['DATE_TRANSACTION']));
                $pasing['USER_IT'] = $key['User_IT'];
                $pasing['M_RAM'] = $key['M_RAM'];
                $pasing['M_CLEANING'] = $key['M_CLEANING'];
                $pasing['M_REPAIR_OS'] = $key['M_REPAIR_OS'];
                $pasing['M_INSTAL_APP'] = $key['M_INSTAL_APP'];
                $pasing['M_SSD'] = $key['M_SSD'];
                $pasing['M_CHARGER'] = $key['M_CHARGER'];
                $pasing['M_LCD'] = $key['M_LCD'];
                $pasing['M_ADAPTER'] = $key['M_ADAPTER'];
                $pasing['M_KEYBOARD'] = $key['M_KEYBOARD']; 
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function showListAssetAktif()
    {
        try {
            $this->db->query("SELECT Id_Asset,Kode_Asset,Nama_Asset,Merk_Asset,Serial_Number_Asset,
                            Tanggal_Pembelian,
                            Lama_Penyusutan, Id_Jenis_Asset,Unit_Induk_Asset,
                            Unit_Last_Asset,IP_Address,
                            Mac_Address,Id_Status_Asset,Status,User_Entry,Anydesk,
                            Sw_Device_ID,Sw_Hold_Time,Sw_Local_Interface,Sw_PortID,LANTAI
                            FROM YARSI_HOSPITAL.DBO.Q_M_Inventory_Asset where status='1'");
            $data =  $this->db->resultSet();
            $rows = array();
            $no = "1";
            foreach ($data as $key) {
                $pasing['Id_Asset'] = $key['Id_Asset'];
                $pasing['Nama_Asset'] = $key['Nama_Asset'];
                $pasing['Mac_Address'] = $key['Mac_Address'];
                $pasing['IP_Address'] = $key['IP_Address']; 
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function addMaintenance($data)
    {

        try {
            $this->db->transaksi();
            if ($data['AssetData'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Masukan Kode Asset !',
                );
                return $callback;
                exit;
            }
            if ($data['TglTransaksi'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Masukan Tanggal Maintenance !',
                );
                return $callback;
                exit;
            }

            $IdAuto = $data['IdAuto'];
            $AssetData = $data['AssetData'];
            $TglTransaksi = $data['TglTransaksi']; 
            $Ram = $data['Ram'];
            $Cleaning = $data['Cleaning'];
            $Repair = $data['Repair'];
            $SSD = $data['SSD'];
            $CHARGER = $data['CHARGER'];
            $LCD = $data['LCD'];
            $ADAPTER = $data['ADAPTER'];
            $KEYBOARD = $data['KEYBOARD'];
            $keterangan = $data['keterangan'];
            $Install_app = $data['Install_app']; 
            $datenowcreate = Utils::seCurrentDateTime(); //Session user
            $session = SessionManager::getCurrentSession();
            $operator =  $session->IDEmployee; 

            if ($data['IdAuto'] == "") { 

                //INSERT
                $this->db->query("INSERT INTO YARSI_HOSPITAL.dbo.Q_MAINTENANCE_ASSET 
                (KODE_ASSET,DATE_TRANSACTION,USER_IT,M_RAM,
                M_CLEANING,M_REPAIR_OS,M_INSTAL_APP,BATAL,M_SSD,M_CHARGER,M_LCD,M_ADAPTER,M_KEYBOARD) VALUES
                (:KODE_ASSET,:DATE_TRANSACTION,:USER_IT,:M_RAM,
                :M_CLEANING,:M_REPAIRS_OS,:M_INSTALL_APP,:BATAL,:M_SSD,:M_CHARGER,:M_LCD,:M_ADAPTER,:M_KEYBOARD)"); 
                $this->db->bind('KODE_ASSET', $AssetData);
                $this->db->bind('DATE_TRANSACTION', $TglTransaksi);
                $this->db->bind('USER_IT', $operator);
                $this->db->bind('M_RAM', $Ram);
                $this->db->bind('M_CLEANING', $Cleaning);
                $this->db->bind('M_REPAIRS_OS', $Repair);
                $this->db->bind('M_INSTALL_APP', $Install_app);
                $this->db->bind('M_SSD', $SSD);
                $this->db->bind('M_CHARGER', $CHARGER);
                $this->db->bind('M_LCD', $LCD);
                $this->db->bind('M_ADAPTER', $ADAPTER);
                $this->db->bind('M_KEYBOARD', $KEYBOARD); 
                $this->db->bind('BATAL', '0');
            } else { 

                $this->db->query(" UPDATE YARSI_HOSPITAL.dbo.Q_MAINTENANCE_ASSET SET 
                KODE_ASSET=:KODE_ASSET,DATE_TRANSACTION=:DATE_TRANSACTION,
                USER_IT=:USER_IT,M_RAM=:M_RAM,
                M_CLEANING=:M_CLEANING,M_REPAIR_OS=:M_REPAIRS_OS,M_INSTAL_APP=:M_INSTALL_APP
                ,M_SSD=:M_SSD
                ,M_CHARGER=:M_CHARGER,M_LCD=:M_LCD,M_ADAPTER=:M_ADAPTER,M_KEYBOARD=:M_KEYBOARD
                 WHERE ID=:ID");
                $this->db->bind('ID', $IdAuto);
                $this->db->bind('KODE_ASSET', $AssetData);
                $this->db->bind('DATE_TRANSACTION', $TglTransaksi);
                $this->db->bind('USER_IT', $operator);
                $this->db->bind('M_RAM', $Ram);
                $this->db->bind('M_CLEANING', $Cleaning);
                $this->db->bind('M_REPAIRS_OS', $Repair);
                $this->db->bind('M_INSTALL_APP', $Install_app);
                $this->db->bind('M_SSD', $SSD);
                $this->db->bind('M_CHARGER', $CHARGER);
                $this->db->bind('M_LCD', $LCD);
                $this->db->bind('M_ADAPTER', $ADAPTER);
                $this->db->bind('M_KEYBOARD', $KEYBOARD); 
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
    public function GetMaintenanceAssetID($data)
    {

        try {
            $this->db->query("SELECT A.ID,A.KODE_ASSET,replace(CONVERT(VARCHAR(11), 
                            DATE_TRANSACTION, 111), '/','-') as DATE_TRANSACTION,A.USER_IT,
                            A.M_RAM,A.M_RAM,A.M_CLEANING,A.M_SSD,A.M_ADAPTER,A.M_LCD,A.M_CHARGER,A.M_KEYBOARD,
                            A.M_REPAIR_OS,A.M_INSTAL_APP,B.[First Name] AS NamaIT
                            FROM YARSI_HOSPITAL.DBO.Q_MAINTENANCE_ASSET A
                            INNER JOIN MasterdataSQL.DBO.Employees B
                            ON A.USER_IT = B.ID
                            WHERE A.ID=:id");
            $this->db->bind('id', $data['id']);
            $data =  $this->db->single();
            $pasing['ID'] = $data['ID'];
            $pasing['KODE_ASSET'] = $data['KODE_ASSET'];
            $pasing['DATE_TRANSACTION'] = $data['DATE_TRANSACTION'];
            $pasing['USER_IT'] = $data['USER_IT'];
            $pasing['M_RAM'] = $data['M_RAM'];
            $pasing['M_CLEANING'] = $data['M_CLEANING'];
            $pasing['M_REPAIR_OS'] = $data['M_REPAIR_OS'];
            $pasing['M_INSTAL_APP'] = $data['M_INSTAL_APP'];
            $pasing['M_KEYBOARD'] = $data['M_KEYBOARD'];
            $pasing['M_SSD'] = $data['M_SSD'];
            $pasing['M_CHARGER'] = $data['M_CHARGER'];
            $pasing['M_LCD'] = $data['M_LCD'];
            $pasing['M_ADAPTER'] = $data['M_ADAPTER'];
            $pasing['NamaIT'] = $data['NamaIT'];
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
    public function deleteMaintenance($data)
    {

        try {
            $this->db->transaksi();
            if ($data['IdAuto'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Id Invalid!',
                );
                return $callback;
                exit;
            }
            

            $IdAuto = $data['IdAuto'];
            $AssetData = $data['AssetData'];
            $TglTransaksi = $data['TglTransaksi'];
            $Ram = $data['Ram'];
            $Cleaning = $data['Cleaning'];
            $Repair = $data['Repair'];
            $keterangan = $data['keterangan'];
            $Install_app = $data['Install_app'];
            $datenowcreate = Utils::seCurrentDateTime(); //Session user
            $session = SessionManager::getCurrentSession();
            $operator =  $session->IDEmployee;

            

                //INSERT
                $this->db->query("UPDATE YARSI_HOSPITAL.dbo.Q_MAINTENANCE_ASSET SET BATAL='1' WHERE ID=:ID");
                $this->db->bind('ID', $IdAuto); 

            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Dihapus !', // Set array status dengan success    
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
    public function showDataMaintenancebyID($data)
    {
        try {
            $id = $data['id'];
            $this->db->query("SELECT a.ID,b.Nama_Asset,replace(CONVERT(VARCHAR(11), 
                            a.DATE_TRANSACTION, 111), '/','-') as DATE_TRANSACTION,
                        C.[First Name] AS User_IT,
                        CASE WHEN a.M_RAM='0' THEN 'NO' ELSE 'YES' END AS M_RAM,
                        CASE WHEN a.M_CLEANING='0' THEN 'NO' ELSE 'YES' END AS M_CLEANING,
                        CASE WHEN a.M_REPAIR_OS='0' THEN 'NO' ELSE 'YES' END AS M_REPAIR_OS,
                        CASE WHEN a.M_INSTAL_APP='0' THEN 'NO' ELSE 'YES' END AS M_INSTAL_APP
                        FROM YARSI_HOSPITAL.DBO.Q_MAINTENANCE_ASSET A 
                        INNER JOIN YARSI_HOSPITAL.DBO.Q_M_Inventory_Asset  B 
                        ON A.KODE_ASSET = B.Id_Asset
                        INNER JOIN MasterdataSQL.DBO.Employees C
                        ON C.ID = A.USER_IT
                        WHERE BATAL='0' and b.Id_Asset=:id");
            $this->db->bind('id', $id);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = "1";
            foreach ($data as $key) {
                $pasing['Nama_Asset'] = $key['Nama_Asset'];
                $pasing['ID'] = $key['ID'];
                $pasing['DATE_TRANSACTION'] = date("d-m-Y", strtotime($key['DATE_TRANSACTION']));
                $pasing['USER_IT'] = $key['User_IT'];
                $pasing['M_RAM'] = $key['M_RAM'];
                $pasing['M_CLEANING'] = $key['M_CLEANING'];
                $pasing['M_REPAIR_OS'] = $key['M_REPAIR_OS'];
                $pasing['M_INSTAL_APP'] = $key['M_INSTAL_APP'];
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
