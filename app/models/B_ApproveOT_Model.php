<?php
class B_ApproveOT_Model
{
    use ApiRsyarsi; 
    private $db; 
    public function __construct()
    {
        $this->db = new Database;
    }
    public function listAllActive($data){
        try {
            $tglawal = $data['StartPeriode'];
            $tglakhir = $data['EndPeriode'];

            $this->db->query("SELECT 
            ID ,Accession_No ,NoOrder ,NoMR ,NoEpisode ,NoRegistrasi ,TglOrder ,OrderCode ,Departemen ,RequestBy ,LokasiPasien ,PerkiraanLamaOP ,TglOperasi ,JamPelaksanaan ,JamMulai ,JamSelesai ,LamaOperasi ,DiagnosaPreOP ,DiagnosaPostOP ,JenisOperasi ,GroupSpesialis ,Kategori ,RencanaPerawatan ,KelasPerawatan ,KlasifikasiOP ,JenisAnestesi ,DrOperator ,DrAnastesi ,AsistenOperator ,PerawatSirculer ,PerawatOK ,PerawatAnastesi ,Jaringan ,PeriksaPA ,TglPA ,LaporanOP ,StatusOrder ,tglAprove ,StatusAdministrasi ,PetugasOrder ,Note ,NamaPasien ,PermintaanKhusus,CONVERT(VARCHAR(8),JamPelaksanaan,114) as JamPelaksanaan_converted
            from MedicalRecord.dbo.EMR_OrderOperasi
            where replace(CONVERT(VARCHAR(11), TglOperasi, 111), '/','-') Between :tglawal and :tglakhir  and StatusAdministrasi='New'
                ");
            $this->db->bind('tglawal', $tglawal);
            $this->db->bind('tglakhir', $tglakhir);
            $data =  $this->db->resultSet();
            $rows = array();
            $id = 1;
            foreach ($data as $row) {
                $pasing['No'] = $id++;
                //$pasing['Tgl'] = date('d-m-Y', strtotime($row['Tgl']));
                $pasing['ID'] = $row['ID'];
                $pasing['Accession_No'] = $row['Accession_No'];
                $pasing['NoOrder'] = $row['NoOrder'];
                $pasing['NoMR'] = $row['NoMR'];
                $pasing['NoEpisode'] = $row['NoEpisode'];
                $pasing['NoRegistrasi'] = $row['NoRegistrasi'];
                $pasing['TglOrder'] = $row['TglOrder'];
                $pasing['OrderCode'] = $row['OrderCode'];
                $pasing['Departemen'] = $row['Departemen'];
                $pasing['RequestBy'] = $row['RequestBy'];
                $pasing['LokasiPasien'] = $row['LokasiPasien'];
                $pasing['PerkiraanLamaOP'] = $row['PerkiraanLamaOP'];
                $pasing['TglOperasi'] = $row['TglOperasi'];
                $pasing['TglOperasi_converted'] = date('d/m/Y' , strtotime($row['TglOperasi']));
                $pasing['JamPelaksanaan'] = $row['JamPelaksanaan'];
                $pasing['JamPelaksanaan_converted'] = $row['JamPelaksanaan_converted'];
                $pasing['JamMulai'] = $row['JamMulai'];
                $pasing['JamSelesai'] = $row['JamSelesai'];
                $pasing['LamaOperasi'] = $row['LamaOperasi'];
                $pasing['DiagnosaPreOP'] = $row['DiagnosaPreOP'];
                $pasing['DiagnosaPostOP'] = $row['DiagnosaPostOP'];
                $pasing['JenisOperasi'] = $row['JenisOperasi'];
                $pasing['GroupSpesialis'] = $row['GroupSpesialis'];
                $pasing['Kategori'] = $row['Kategori'];
                $pasing['RencanaPerawatan'] = $row['RencanaPerawatan'];
                $pasing['KelasPerawatan'] = $row['KelasPerawatan'];
                $pasing['KlasifikasiOP'] = $row['KlasifikasiOP'];
                $pasing['JenisAnestesi'] = $row['JenisAnestesi'];
                $pasing['DrOperator'] = $row['DrOperator'];
                $pasing['DrAnastesi'] = $row['DrAnastesi'];
                $pasing['AsistenOperator'] = $row['AsistenOperator'];
                $pasing['PerawatSirculer'] = $row['PerawatSirculer'];
                $pasing['PerawatOK'] = $row['PerawatOK'];
                $pasing['PerawatAnastesi'] = $row['PerawatAnastesi'];
                $pasing['Jaringan'] = $row['Jaringan'];
                $pasing['PeriksaPA'] = $row['PeriksaPA'];
                $pasing['TglPA'] = $row['TglPA'];
                $pasing['LaporanOP'] = $row['LaporanOP'];
                $pasing['StatusOrder'] = $row['StatusOrder'];
                $pasing['tglAprove'] = $row['tglAprove'];
                $pasing['StatusAdministrasi'] = $row['StatusAdministrasi'];
                $pasing['PetugasOrder'] = $row['PetugasOrder'];
                $pasing['Note'] = $row['Note'];
                $pasing['NamaPasien'] = $row['NamaPasien'];
                $pasing['PermintaanKhusus'] = $row['PermintaanKhusus'];

                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function goApprove($data)
    {
        try {
            $this->db->transaksi();
            $ID = $data['ID'];
            $noreg = $data['noreg'];
            $action = $data['action'];

            $session = SessionManager::getCurrentSession();
            $userid = $session->username;
            $namauserx = $session->name;
            $operator =  $session->IDEmployee;
            $datenowcreate = Utils::seCurrentDateTime();

            
            $this->db->query("UPDATE MedicalRecord.dbo.EMR_OrderOperasi SET StatusAdministrasi=:action WHERE ID=:ID");
            $this->db->bind('ID', $ID);
            $this->db->bind('action', $action);
            $this->db->execute();

            $this->db->query("INSERT INTO SysLog.dbo.TZ_Log_ApproveOT 
                        (IdTrs,NoRegistrasi,JenisApprove,UserAction,DateAction) VALUES
                        (:ID,:noreg,:action,:userid,:datenowcreate)");
            $this->db->bind('ID', $ID);
            $this->db->bind('noreg', $noreg);
            $this->db->bind('action', $action);
            $this->db->bind('userid', $userid);
            $this->db->bind('datenowcreate', $datenowcreate);
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
}
