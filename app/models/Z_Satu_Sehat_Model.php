
<?php
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface; 
class Z_Satu_Sehat_Model
{
    use SatuSehat; 
    use SatuSehatBundling;
    private $db; 
    public function __construct()
    {
        $this->db = new Database;
    }
    public function genToken($data)
    {
        try {
            // $Isi = $data['Isi'];
            // $NamaSatuan = $data['NamaSatuan'];
            
            // 1. Gen Token
            $method = "POST";
            $URL = "accesstoken?grant_type=client_credentials";
            $token = $this->curl_request_token_SatuSehat(GenerateTokenSatuSehat::headers_api(), $method, $URL);
        
            return $token['access_token'];
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    } 
    public function getihspatient($id)
    {
        try {
             
            // 1. Gen Token
            $method = "POST";
            $URL = "accesstoken?grant_type=client_credentials";
            $token = $this->curl_request_token_SatuSehat(GenerateTokenSatuSehat::headers_api(), $method, $URL);
            $Fixtoken = "Bearer ".$token['access_token'];


            // 2. GetHis
            $method2 = "GET"; 
            $urlAddSatuan = "Patient?identifier=https://fhir.kemkes.go.id/id/nik%7C9271060312000001";
            $addSatuan = $this->curl_request_SatuSehat(GenerateTokenSatuSehat::headers_api_token($Fixtoken), $method2, [], $urlAddSatuan);
            if ($addSatuan['total'] === 1) {
                $callback = array(
                    'status' => 'success', 
                    'data' => $addSatuan
                );
            } else {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Data Tidak Ditemukan.s',

                );
            }
            return $callback;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    } 
    public function postEncounterRegistration($data)
    {
        try {
            
            // 1. Gen Token
            $method = "POST";
            $URL = "accesstoken?grant_type=client_credentials";
            $token = $this->curl_request_token_SatuSehat(GenerateTokenSatuSehat::headers_api(), $method, $URL);
            $Fixtoken = "Bearer ".$token['access_token'];
            // value
            $Noregistrasi = "P20240001";
            $Organization = "10000004";
            $tglRegistrasi = "2022-06-14T07:00:00";
            $NoIdKemenkesPasien = "P02478375538";
            $NamaPasien = "Budi";
            $kodeDokterKemenkes="N10000001";
            $namaDokterKemenkes = "dr. Wan Nedra, Sp.Ag";
            $kodeLocationKemenkes="074cc4b7-39d6-44dc-97fc-f3039f15b4f0";
            $namaLocationKemenkes = "Ruang 1A, Poliklinik Bedah Rawat Jalan Terpadu, Lantai 2, Gedung G";

            //data
            $postSatuanData = '{
                "resourceType": "Encounter",
                "status": "arrived",
                "class": {
                    "system": "http://terminology.hl7.org/CodeSystem/v3-ActCode",
                    "code": "AMB",
                    "display": "ambulatory"
                },
                "subject": {
                    "reference": "Patient/'.$NoIdKemenkesPasien.'",
                    "display": "'.$NamaPasien.'" 
                },
                "participant": [
                    {
                        "type": [
                            {
                                "coding": [
                                    {
                                        "system": "http://terminology.hl7.org/CodeSystem/v3-ParticipationType",
                                        "code": "ATND",
                                        "display": "attender"
                                    }
                                ]
                            }
                        ],
                        "individual": {
                            "reference": "Practitioner/'.$kodeDokterKemenkes.'",
                            "display": "'.$namaDokterKemenkes.'"
                        }
                    }
                ],
                "period": {
                    "start": "'.$tglRegistrasi.'+07:00"
                },
                "location": [
                    {
                        "location": {
                            "reference": "Location/'.$kodeLocationKemenkes.'",
                            "display": "'.$namaLocationKemenkes.'"
                        }
                    }
                ],
                "statusHistory": [
                    {
                        "status": "arrived",
                        "period": {
                            "start": "'.$tglRegistrasi.'+07:00"
                        }
                    }
                ],
                "serviceProvider": {
                    "reference": "Organization/'.$Organization.'"
                },
                "identifier": [
                    {
                        "system": "http://sys-ids.kemkes.go.id/encounter/10000004",
                        "value": "'.$Noregistrasi.'"
                    }
                ]
            }';
            // 2. GetHis
            $method2 = "POST"; 
            $urlAddSatuan = "Encounter";
            $addSatuan = $this->curl_request_SatuSehat(GenerateTokenSatuSehat::headers_api_token($Fixtoken), $method2, $postSatuanData, $urlAddSatuan);
            if (isset($addSatuan['issue'])) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Data Tidak Ditemukan',

                );
            } else {
                $callback = array(
                    'status' => 'success', 
                    'data' => $addSatuan
                );
                
            }
            return $addSatuan['id'];
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    } 
    public function postBundling($dataReg)
    { 
        $uuidRegistrasi = Utils::uuid4str();
        $uuidDiagnosautama = Utils::uuid4str();
        $uuidDiagnosasekunder = Utils::uuid4str();
        $xnoreg = $dataReg['NoRegistrasi'];
        //diagnosautama
        $this->db->query("SELECT b.ICD_CODE,b.DESCRIPTION 
        from MasterdataSQL.dbo.ICDX_Transactions a
        inner join MasterdataSQL.dbo.ICDX b
        on a.id_icd = b.ID
        where NoRegistrasi=:xnoreg and a.header='1' and a.status='1'");
        $this->db->bind('xnoreg', $xnoreg);

        // 1. DIAGNOSA PRIMER
        $dataDiagPrimer =  $this->db->resultSet(); 
        $datarowDiagnosaPrimer = $this->db->rowCount();
        if($datarowDiagnosaPrimer < '1'){
            $this->db->query("INSERT INTO DashboardData.dbo.Encounter_Send_History
                (NOREGISTRASI,Response,DateCreate,Status)
                VALUES
                (:NoRegistrasi,:addSatuan,:datenow ,:datasts)");
                $this->db->bind('NoRegistrasi', $dataReg['NoRegistrasi']);
                $this->db->bind('addSatuan', 'Data Diagnosa Primer Belum terisi.'); 
                $this->db->bind('datasts', 'GAGAL'); 
                $this->db->bind('datenow', Utils::seCurrentDateTime()); 
                $this->db->execute();

            $callback = array(
                'status' => 'warning', 
                'data' => 'Data Diagnosa Primer Belum terisi.'
            );
            return $callback;
        }else{
            foreach ($dataDiagPrimer as $diagnosaprimericd10) { 
                $responsex =[
                    "condition" => [
                       "reference" => "urn:uuid:".$uuidDiagnosautama,
                       "display" =>  $diagnosaprimericd10['DESCRIPTION']  
                    ], 
                    "use" => [
                          "coding" => [
                             [
                                "system" => "http://terminology.hl7.org/CodeSystem/diagnosis-role", 
                                "code" => "DD", 
                                "display" => "Discharge diagnosis" 
                             ] 
                          ] 
                       ], 
                    "rank" => 1 
                 ] ;
                 $diagnosa[] = $responsex;   
    
                 $DiagnPrimer = [
                                        "system" => "http://hl7.org/fhir/sid/icd-10",
                                        "code" => $diagnosaprimericd10['ICD_CODE'],
                                        "display" => $diagnosaprimericd10['DESCRIPTION'],
                                    ];
                $CodeDiagnosa[] = $DiagnPrimer;   
            } 
        }
        
        $CodeDiagnosaSekunder = array();
        //diagnosasekunder
        $this->db->query("SELECT b.ICD_CODE,b.DESCRIPTION 
        from MasterdataSQL.dbo.ICDX_Transactions a
        inner join MasterdataSQL.dbo.ICDX b
        on a.id_icd = b.ID
        where NoRegistrasi=:xnoreg and a.header='0' and a.status='1'");
        $this->db->bind('xnoreg', $xnoreg);
        $dataDiagsekunder =  $this->db->resultSet(); 
        $datarowDiagnosaSecunder = $this->db->rowCount();
        if($datarowDiagnosaSecunder > '1'){
            foreach ($dataDiagsekunder as $diagnosasekundericd10) { 
                $responsex =[
                    "condition" => [
                    "reference" => "urn:uuid:".$uuidDiagnosasekunder,
                    "display" =>  $diagnosasekundericd10['DESCRIPTION']  
                    ], 
                    "use" => [
                        "coding" => [
                            [
                                "system" => "http://terminology.hl7.org/CodeSystem/diagnosis-role", 
                                "code" => "DD", 
                                "display" => "Discharge diagnosis" 
                            ] 
                        ] 
                    ], 
                    "rank" => 2 
                ] ;
                $diagnosa[] = $responsex;   
                $DiagnPrimerSekunder = [
                    "system" => "http://hl7.org/fhir/sid/icd-10",
                    "code" => $diagnosasekundericd10['ICD_CODE'],
                    "display" => $diagnosasekundericd10['DESCRIPTION'],
                ];
                $CodeDiagnosaSekunder[] = $DiagnPrimerSekunder;  
            } 
        }
        // history status pasien
        $this->db->query("SELECT statusName,REPLACE(StartTime,'.',':') as StartTime,REPLACE(EndTime,'.',':') as EndTime
        from DashboardData.dbo.Encounter_Update_Status 
        where Noregistrasi=:xnoreg");
        $this->db->bind('xnoreg', $xnoreg);
        $datastatushistory =  $this->db->resultSet(); 
        foreach ($datastatushistory as $xstatus) {
            $responsestatus =[
                    "status" => $xstatus['statusName'],
                    "period" => [
                        "start" => $xstatus['StartTime'],
                        "end" => $xstatus['EndTime'],
                    ],
                ];
           
            $rowsstatus[] = $responsestatus;   
        } 

        $addSatuan = $this->PostBundlingData($uuidRegistrasi,$dataReg['idMrkemkes'],$dataReg['PatientName'],$dataReg['idDoktertKemkes'],
        $dataReg['First_Name'], $dataReg['tglregis'], $dataReg['tglPulang'],$dataReg['idUnitKemkes'],$dataReg['NamaUnit'],
        $diagnosa,$rowsstatus,$dataReg['NoRegistrasi'],
        $uuidDiagnosautama,$CodeDiagnosa,
        $uuidDiagnosasekunder,$CodeDiagnosaSekunder);
        $idregkemkesx =  $addSatuan['entry']['0']['response']['resourceID']; 
      
            
            if (isset($addSatuan['total']) == '3') {
                $this->db->query("INSERT INTO DashboardData.dbo.Encounter_Send_History
                (NOREGISTRASI,Response,DateCreate,Status)
                VALUES
                (:NoRegistrasi,:addSatuan,:datenow ,'SUKSES')");
                $this->db->bind('NoRegistrasi', $dataReg['NoRegistrasi']);
                $this->db->bind('addSatuan', json_encode($addSatuan)); 
                $this->db->bind('datenow', Utils::seCurrentDateTime()); 
                $this->db->execute();

                $this->db->query("UPDATE PerawatanSQL.dbo.Visit SET IsSendKemenkes = '1',idRegKemenkes=:xidregkemkesx where NoRegistrasi=:NoRegistrasi ");
                $this->db->bind('NoRegistrasi', $dataReg['NoRegistrasi']); 
                $this->db->bind('xidregkemkesx', $idregkemkesx); 
                $this->db->execute();

                $this->db->query("UPDATE DashboardData.dbo.dataRWJ SET IsSendKemenkes = '1',idRegKemenkes=:xidregkemkesx2 where NoRegistrasi=:NoRegistrasi2 ");
                $this->db->bind('NoRegistrasi2', $dataReg['NoRegistrasi']); 
                $this->db->bind('xidregkemkesx2', $idregkemkesx); 
                $this->db->execute();

                $callback = array(
                    'status' => 'success',
                    'errorname' => 'Data Encounter Berhasil Dikirim Ke Kemenkes : '.$dataReg['PatientName']. 'No. Registrasi : '.$dataReg['NoRegistrasi'] . ' Id reg kemkes : '.$idregkemkesx ,

                );

            } else {
                $this->db->query("INSERT INTO DashboardData.dbo.Encounter_Send_History
                (NOREGISTRASI,Response,DateCreate,Status)
                VALUES
                (:NoRegistrasi,:addSatuan,:datenow,:xstas )");
                $this->db->bind('NoRegistrasi', $dataReg['NoRegistrasi']);
                $this->db->bind('xstas', 'GAGAL');
                $this->db->bind('addSatuan', json_encode($addSatuan)); 
                $this->db->bind('datenow', Utils::seCurrentDateTime()); 
                $this->db->execute();

                $callback = array(
                    'status' => 'warning', 
                    'data' => 'Data Gagal Dikirim.'
                );
                
            } 
            return $callback; 
    }
    public function loopdata(){
        $this->db->query("SELECT 
        a.NoRegistrasi,b.idUnitKemkes,b.NamaUnit,c.idDoktertKemkes,c.First_Name, 
        a.TglKunjungan,a.First_date_close,d.idMrkemkes,d.PatientName,a.idRegKemenkes,
        replace(CONVERT(VARCHAR(11),[Visit Date], 111), '/','-')+'T'+convert(VARCHAR(8), [Visit Date], 108)+'-07:00' as tglregis,
        replace(CONVERT(VARCHAR(11),First_date_close, 111), '/','-')+'T'+convert(VARCHAR(8), First_date_close, 108)+'-07:00' as tglPulang
        from PerawatanSQL.dbo.Visit a 
        inner join MasterdataSQL.dbo.MstrUnitPerwatan b
        on a.Unit = b.ID
        inner join MasterdataSQL.dbo.Doctors c
        on c.ID = a.Doctor_1
        inner join MasterdataSQL.dbo.Admision d
        on a.NoMR = d.NoMR
        where a.idRegKemenkes is null and d.idMrkemkes is not null and IsSendKemenkes is null and 
        replace(CONVERT(VARCHAR(11),[Visit Date], 111), '/','-') = '2024-01-02' and a.Batal='0' ");
        $data =  $this->db->resultSet();
        
        $no=1;
        foreach ($data as $row) {
            $response = array();
            $response['no'] = $no;
            $response['callback'] = $this->postBundling($row); 
            print_r($response);
            $no++;
        }
    }
}