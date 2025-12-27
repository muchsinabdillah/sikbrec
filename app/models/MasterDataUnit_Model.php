<?php
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface; 
class MasterDataUnit_Model 
{
    private $db;
    use SatuSehat;
    use SatuSehatLocation;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function getAllDataUnit()
    {
        try {
            $this->db->query("SELECT ID,NamaUnit,EmrMenu,Kelasrawat,idUnitKemkes,CODEUNIT
                        from MasterdataSQL.dbo.MstrUnitPerwatan where active='1'");
            $data =  $this->db->resultSet();
            $rows = array();
            $array = array();
            foreach ($data as $key) {
                $pasing['ID'] = $key['ID'];
                $pasing['NamaUnit'] = $key['NamaUnit'];
                $pasing['EmrMenu'] = $key['EmrMenu'];
                $pasing['Kelasrawat'] = $key['Kelasrawat'];
                $pasing['idUnitKemkes'] = $key['idUnitKemkes'];
                $pasing['CODEUNIT'] = $key['CODEUNIT'];
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

            if ($data['NamaUnit'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Nama Unit!',
                );
                return $callback;
                exit;
            }
            if ($data['EMRMenu'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input EMRMenu !',
                );
                return $callback;
                exit;
            }
            if ($data['CodeRegis'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Code Regis !',
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
            if ($data['GrupInstalasi'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Group Instalasi !',
                );
                return $callback;
                exit;
            }
            

            if($data['CodeRegis'] == 'RJ'){
                $rajal = '1';
            }else{
                $rajal = '0';
            }   
            

            $IdAuto = $data['IdAuto'];
            $CodeUnit = $data['CodeUnit'];
            $NamaUnit = $data['NamaUnit'];
            $EMRMenu = $data['EMRMenu'];
            $CodeRegis = $data['CodeRegis'];
            $CodeAntrian = $data['CodeAntrian'];
            $GrupInstalasi = $data['GrupInstalasi'];
            $CodeBPJS = $data['CodeBPJS'];
            $ActiveData = $data['ActiveData'];
            
            




            if ($data['IdAuto'] == "") {

                // //CEK Double Code BPJS
                // $this->db->query("SELECT * from MasterdataSQL.dbo.MstrUnitPerwatan
                // where codeBPJS=:CodeBPJS");
                // $this->db->bind('CodeBPJS', $CodeBPJS);
                // $data =  $this->db->resultSet();
                // //var_dump(count($data));exit;
                // if (count($data) > 0){
                //     $callback = array(
                //         'status' => 'warning',
                //         'errorname' => 'Sudah Ada Code BPJS Dengan Code Tersebut !',
                //     );
                //     return $callback;
                //     exit;
                // }

                      $this->db->query("SELECT MAX(ID) as urut
                                from MasterdataSQL.dbo.MstrUnitPerwatan ORDER BY 1 DESC");
                        $data =  $this->db->resultSet();
                        foreach ($data as $key) {
                            $nourut = $key['urut'];
                        }
                            $nourut++;
                            $CodeUnit_gen = 'UNIT'.$nourut;
                            //var_dump($CodeUnit);exit;

                    $this->db->query("INSERT INTO MasterdataSQL.dbo.MstrUnitPerwatan (ID,CODEUNIT,NamaUnit,EMRMenu,CodeRegis,CodeAntrian,grup_instalasi,rajal,codeBPJS, Active) VALUES
                    ((SELECT ISNULL(MAX(ID) + 1, 0) FROM MasterdataSQL.dbo.MstrUnitPerwatan),:CodeUnit,:NamaUnit,:EMRMenu,:CodeRegis,:CodeAntrian,:GrupInstalasi,:rajal,:CodeBPJS, :Active)");
                      $this->db->bind('CodeUnit', $CodeUnit_gen);
                      $this->db->bind('NamaUnit', $NamaUnit);
                      $this->db->bind('EMRMenu', $EMRMenu);
                      $this->db->bind('CodeRegis', $CodeRegis);
                      $this->db->bind('CodeAntrian', $CodeAntrian);
                      $this->db->bind('GrupInstalasi', $GrupInstalasi);
                      $this->db->bind('rajal', $rajal);
                      $this->db->bind('CodeBPJS', $CodeBPJS); 
                      $this->db->bind('Active', $ActiveData); 
                      
            } else {

                // //CEK Double Code BPJS
                // $this->db->query("SELECT * from MasterdataSQL.dbo.MstrUnitPerwatan
                // where codeBPJS=:CodeBPJS AND ID<>:IdAuto");
                // $this->db->bind('CodeBPJS', $CodeBPJS);
                // $this->db->bind('IdAuto', $IdAuto);
                // $data =  $this->db->resultSet();
                // //var_dump(count($data));exit;
                // if (count($data) > 0){
                //     $callback = array(
                //         'status' => 'warning',
                //         'errorname' => 'Sudah Ada Code BPJS Dengan Code Tersebut !',
                //     );
                //     return $callback;
                //     exit;
                // }

                    $this->db->query("UPDATE MasterdataSQL.dbo.MstrUnitPerwatan set  
                            CODEUNIT=:CodeUnit,NamaUnit=:NamaUnit,
                            EMRMenu=:EMRMenu,CodeRegis=:CodeRegis,CodeAntrian=:CodeAntrian,
                            grup_instalasi=:GrupInstalasi,rajal=:rajal,codeBPJS=:CodeBPJS ,Active=:Active
                            WHERE ID=:IdAuto");
                    $this->db->bind('CodeUnit', $CodeUnit);
                    $this->db->bind('NamaUnit', $NamaUnit);
                    $this->db->bind('EMRMenu', $EMRMenu);
                    $this->db->bind('CodeRegis', $CodeRegis);
                    $this->db->bind('CodeAntrian', $CodeAntrian);
                    $this->db->bind('GrupInstalasi', $GrupInstalasi);
                    $this->db->bind('rajal', $rajal);
                    $this->db->bind('IdAuto', $IdAuto); 
                    $this->db->bind('CodeBPJS', $CodeBPJS); 
                    $this->db->bind('Active', $ActiveData); 
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
    public function getUnitId($id)
    {
        try {
            
            $this->db->query("SELECT * 
                            from MasterdataSQL.dbo.MstrUnitPerwatan
                            WHERE id=:id  ");
            $this->db->bind('id', $id);
            $data =  $this->db->single();
            $pasing['ID'] = $data['ID']; 
            $pasing['CODEUNIT'] = $data['CODEUNIT'];
            $pasing['NamaUnit'] = $data['NamaUnit'];
            $pasing['EMRMenu'] = $data['EMRMenu'];
            $pasing['Kelasrawat'] = $data['Kelasrawat'];
            $pasing['CodeRegis'] = $data['CodeRegis'];
            $pasing['CodeAntrian'] = $data['CodeAntrian'];
            $pasing['grup_instalasi'] = $data['grup_instalasi'];
            $pasing['codeBPJS'] = $data['codeBPJS'];
            $pasing['NamaBPJS'] = $data['NamaBPJS'];
            $pasing['idUnitKemkes'] = $data['idUnitKemkes'];
            $pasing['active'] = $data['active'];
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
    public function GetLayananPoliklinik()
    {
        try {
            $this->db->query("SELECT ID,NamaUnit
                            from MasterdataSQL.dbo.MstrUnitPerwatan
                            where rajal='1' and active='1'");
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
    public function GetLayananPoliPenunjangIgd()
    {
        try {
            $wherewalkin = "";
            if (isset($_POST['iswalkin'])){
                $iswalkin = $_POST['iswalkin'];
                if ($iswalkin == 'WALKIN'){
                    $wherewalkin = "AND ID='9'";
                }
            }
            $whereodc = "";
            if (isset($_POST['idodc'])){
                $idodc = $_POST['idodc'];
                if ($idodc == ''){
                    $whereodc = "AND ID<>'55'";
                }else{
                    $whereodc = "AND ID='55'";
                }
            }
            $this->db->query("SELECT ID, NamaUnit
                                  from MasterdataSQL.dbo.MstrUnitPerwatan 
                                  where grup_instalasi in ('PENUNJANG','IGD','RAWAT JALAN') $wherewalkin $whereodc and active='1' Order by NamaUnit");
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
    public function GetLayananAll()
    {
        try {
            
            $this->db->query("SELECT ID, NamaUnit
                                  from MasterdataSQL.dbo.MstrUnitPerwatan where active='1' Order by NamaUnit asc");
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

    public function uuidGen(){
        $uuid = Uuid::uuid4();
        $callback = array(
            'message' => "success", // Set array nama 
            'data' => $uuid 
        );
        return $callback;
    }

    public function PostLocation($data){
        $this->db->transaksi();
            $idUnits = $data['id'];
            $nama = $data['nama'];
            $idunitKemenkes = $data['idunitKemenkes'];
            $this->db->query("SELECT bridging_SatuSehat FROM MasterdataSQL.DBO.A_DATA_RS");
            $data =  $this->db->single();
            //no urut reg
            $bridging_SatuSehat = $data['bridging_SatuSehat'];
            if($bridging_SatuSehat == "1"){ 
                $postData = $this->PostLocations($idUnits,$nama);
               
                if(isset($postData['issue'][0]['severity']) == "error"){
                    $callback = array(
                        'status' => "warning", // Set array nama  
                        'errorname' => $postData['issue'][0]['details']['text']
                    );
                    return $callback; 
                    
                } 
                $this->db->query("UPDATE MasterdataSQL.dbo.MstrUnitPerwatan set  
                idUnitKemkes=:Idkemenkes 
                WHERE CODEUNIT=:CodeUnit");
                $this->db->bind('CodeUnit', $idUnits);
                $this->db->bind('Idkemenkes',$postData['id']); 
                $this->db->execute();
                $this->db->commit();
                $callback = array(
                    'message' => "success", // Set array nama 
                    'data' => $postData['id']
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
    public function PutLocation($data){
      
            $idUnits = $data['id'];
            $nama = $data['nama'];
            $idunitKemenkes = $data['idunitKemenkes'];
            $this->db->query("SELECT bridging_SatuSehat FROM MasterdataSQL.DBO.A_DATA_RS");
            $data =  $this->db->single();
            //no urut reg
            $bridging_SatuSehat = $data['bridging_SatuSehat'];
            if($bridging_SatuSehat == "1"){ 
                $postData = $this->PutLocations($idUnits,$nama,$idunitKemenkes);
                if(isset($postData['issue'][0]['severity']) == "error"){
                    $callback = array(
                        'status' => "warning", // Set array nama  
                        'errorname' => $postData['issue'][0]['details']['text']
                    );
                    return $callback;  
                }  
                $callback = array(
                    'message' => "success", // Set array nama 
                    'data' => $idunitKemenkes
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

