<?php


class MasterAsset_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function showDataAsset()
    {
        try {
            $this->db->query("SELECT replace(CONVERT(VARCHAR(11), a.Tanggal_Pembelian, 111), '/','-') as Tanggal_Pembelian,
                          a.Id_Asset,a.Kode_Asset,a.Nama_Asset,a.Merk_Asset,a.IP_Address,a.Mac_Address,b.Nama_Status_Asset,
                          a.Id_Status_Asset,a.LANTAI
                          FROM YARSI_HOSPITAL.dbo.Q_M_Inventory_Asset a
                          INNER JOIN YARSI_HOSPITAL.DBO.Q_M_Satus_Asset B
                          on a.Id_Status_Asset = b.Id_Status_Asset");
            $data =  $this->db->resultSet();
            $rows = array();
            $no = "1";
            foreach ($data as $key) {
                $pasing['Tanggal_Pembelian'] = $key['Tanggal_Pembelian'];
                $pasing['Id_Asset'] = $key['Id_Asset']; 
                $pasing['Kode_Asset'] = $key['Kode_Asset'];
                $pasing['Nama_Asset'] = $key['Nama_Asset'];
                $pasing['Merk_Asset'] = $key['Merk_Asset'];
                $pasing['IP_Address'] = $key['IP_Address'];
                $pasing['Mac_Address'] = $key['Mac_Address'];
                $pasing['Nama_Status_Asset'] = $key['Nama_Status_Asset'];
                $pasing['Id_Status_Asset'] = $key['Id_Status_Asset'];
                $pasing['LANTAI'] = $key['LANTAI']; 
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function GetJenisAssetAktif()
    {
        try {
            $this->db->query("SELECT *FROM YARSI_HOSPITAL.DBO.Q_M_JENIS_ASSET where Status_Jenis_Asset='1'");
            $data =  $this->db->resultSet();
            $rows = array();
            $no = "1";
            foreach ($data as $key) {
                $pasing['Id_Jenis_Asset'] = $key['Id_Jenis_Asset'];
                $pasing['Nama_Jenis_Asset'] = $key['Nama_Jenis_Asset'];
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function GetUnitAktif()
    {
        try {
            $this->db->query("SELECT ID,NamaUnit
                            FROM MasterdataSQL.dbo.MstrUnitPerwatan");
            $data =  $this->db->resultSet();
            $rows = array();
            $no = "1";
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['NamaUnit'] = $key['NamaUnit'];
                $rows[] = $pasing;
                $no++;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function addAsset($data)
    {

        try {
            $this->db->transaksi();
            if ($data['NamaAsset'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Masukan Nama Asset !',
                );
                return $callback;
                exit;
            }
           

            $IdAuto = $data['IdAuto'];
            $Mst_Kode_Asset = $data['KodeAsset'];
            $Mst_Nama = $data['NamaAsset'];
            $Mst_Merk = $data['MerkAsset'];
            $Mst_Serial_Number = $data['SerialNumberAsset'];
            $Mst_Tgl_pembelian = $data['TglTransaksi'];
            $Mst_Jenis_Asset = $data['JenisAsset'];
            $Mst_Unit = $data['UnitIndukAsset'];
            $Mst_Ip_Address = $data['IpAddressAsset'];
            $Mst_Mac_Address = $data['MacAdressAsset'];
            $Mst_Status = $data['StatusAsset'];
            $Mst_Status_Aktif = 1;
            $Mst_Anydesk = $data['AnydeskAsset']; 


            $datenowcreate = Utils::seCurrentDateTime(); //Session user
            $session = SessionManager::getCurrentSession();
            $userid =  $session->IDEmployee;

            if ($data['IdAuto'] == "") {

                //INSERT
                $this->db->query("INSERT INTO YARSI_HOSPITAL.dbo.Q_M_Inventory_Asset
                      (Kode_Asset,Nama_Asset,Merk_Asset,Serial_Number_Asset,
                      Tanggal_Pembelian,Lama_Penyusutan,Id_Jenis_Asset,
                      Unit_Induk_Asset,IP_Address,Mac_Address,Id_Status_Asset,Status,User_Entry,Tgl_entry
                      ,Anydesk,Sw_Device_ID,Sw_Local_Interface,
                      Sw_Hold_Time,Sw_PortID,Lantai)
                    values
                    ( :Mst_Kode_Asset,:Mst_Nama,:Mst_Merk,:Mst_Serial_Number,
                     :Mst_Tgl_pembelian,:susut,:Mst_Jenis_Asset
                      ,:Mst_Unit,:Mst_Ip_Address,:Mst_Mac_Address,:Mst_Status,:Mst_Status_Aktif,:userid,:datenowcreate
                      ,:Mst_Anydesk,:Mst_Sw_deviceId,:Mst_Sw_Local_Interface
                      ,:Mst_Sw_HoldTime,:Mst_Sw_PortId,:Mst_Lantai)");
                $this->db->bind('Mst_Kode_Asset', $Mst_Kode_Asset);
                $this->db->bind('Mst_Nama', $Mst_Nama);
                $this->db->bind('Mst_Merk', $Mst_Merk);
                $this->db->bind('Mst_Serial_Number', $Mst_Serial_Number);
                $this->db->bind('Mst_Tgl_pembelian', $Mst_Tgl_pembelian);
                $this->db->bind('susut', '0');
                $this->db->bind('Mst_Jenis_Asset', $Mst_Jenis_Asset);
                $this->db->bind('Mst_Unit', $Mst_Unit); 
                $this->db->bind('Mst_Ip_Address', $Mst_Ip_Address);
                $this->db->bind('Mst_Mac_Address', $Mst_Mac_Address);
                $this->db->bind('Mst_Status', $Mst_Status);
                $this->db->bind('Mst_Status_Aktif', $Mst_Status_Aktif);
                $this->db->bind('userid', $userid);
                $this->db->bind('datenowcreate', $datenowcreate);
                $this->db->bind('Mst_Anydesk', $Mst_Anydesk);
                $this->db->bind('Mst_Sw_deviceId', '0');
                $this->db->bind('Mst_Sw_Local_Interface', '0');
                $this->db->bind('Mst_Sw_HoldTime', '0');
                $this->db->bind('Mst_Sw_PortId', '0');
                $this->db->bind('Mst_Lantai', '0'); 
            } else {

                // $this->db->query(" UPDATE YARSI_HOSPITAL.dbo.Q_M_Inventory_Asset SET 
                // KODE_ASSET=:KODE_ASSET,DATE_TRANSACTION=:DATE_TRANSACTION,
                // USER_IT=:USER_IT,M_RAM=:M_RAM,
                // M_CLEANING=:M_CLEANING,M_REPAIR_OS=:M_REPAIRS_OS,M_INSTAL_APP=:M_INSTALL_APP
                //  WHERE ID=:ID");
                // $this->db->bind('ID', $IdAuto);
                // $this->db->bind('KODE_ASSET', $AssetData);
                // $this->db->bind('DATE_TRANSACTION', $TglTransaksi);
                // $this->db->bind('USER_IT', $operator);
                // $this->db->bind('M_RAM', $Ram);
                // $this->db->bind('M_CLEANING', $Cleaning);
                // $this->db->bind('M_REPAIRS_OS', $Repair);
                // $this->db->bind('M_INSTALL_APP', $Install_app);
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
    public function GetAssetID($data)
    {

        try {
            $this->db->query("SELECT Id_Asset,Kode_Asset,Nama_Asset,Merk_Asset,Serial_Number_Asset,
                            replace(CONVERT(VARCHAR(11), Tanggal_Pembelian, 111), '/','-') as Tanggal_Pembelian,Lama_Penyusutan,Id_Jenis_Asset,Unit_Induk_Asset,Unit_Last_Asset,
                            IP_Address,Mac_Address,Id_Status_Asset,Status,Anydesk,LANTAI
                            FROM YARSI_HOSPITAL.DBO.Q_M_Inventory_Asset where Id_Asset=:id");
            $this->db->bind('id', $data['id']);
            $data =  $this->db->single();
            $pasing['Id_Asset'] = $data['Id_Asset'];
            $pasing['Kode_Asset'] = $data['Kode_Asset'];
            $pasing['Nama_Asset'] = $data['Nama_Asset'];
            $pasing['Merk_Asset'] = $data['Merk_Asset'];
            $pasing['Serial_Number_Asset'] = $data['Serial_Number_Asset'];
            $pasing['Tanggal_Pembelian'] = $data['Tanggal_Pembelian'];
            $pasing['Lama_Penyusutan'] = $data['Lama_Penyusutan'];
            $pasing['Id_Jenis_Asset'] = $data['Id_Jenis_Asset'];
            $pasing['Unit_Induk_Asset'] = $data['Unit_Induk_Asset'];
            $pasing['Unit_Last_Asset'] = $data['Unit_Last_Asset'];
            $pasing['IP_Address'] = $data['IP_Address'];
            $pasing['Mac_Address'] = $data['Mac_Address'];
            $pasing['Id_Status_Asset'] = $data['Id_Status_Asset'];
            $pasing['Status'] = $data['Status'];
            $pasing['Anydesk'] = $data['Anydesk'];
            $pasing['LANTAI'] = $data['LANTAI'];
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
}