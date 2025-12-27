<?php
trait SatuSehatBundling
{
    public function PostBundlingData($uuidRegistrasi,$idMrkemkes,$PatientName,$idDoktertKemkes,
                                $First_Name,$tglRegistrasi,$tglPulang,$idUnitKemkes,$NamaUnit,
                                $diagnosa,$rowsstatus,$NoRegistrasi,
                                $uuidDiagnosautama,$CodeDiagnosa,
                                $uuidDiagnosasekunder,$CodeDiagnosaSekunder){
        // INSERT POST TO KEMNKES
       

        $sendataarrayfix = [
            "resourceType" => "Bundle",
            "type" => "transaction",
            "entry" => [
                [
                    "fullUrl" => "urn:uuid:".$uuidRegistrasi,
                    "resource" => [
                        "resourceType" => "Encounter",
                        "status" => "finished",
                        "class" => [
                            "system" =>
                                "http://terminology.hl7.org/CodeSystem/v3-ActCode",
                            "code" => "AMB",
                            "display" => "ambulatory",
                        ],
                        "subject" => [
                            "reference" => "Patient/".$idMrkemkes,
                            "display" => $PatientName,
                        ],
                        "participant" => [
                            [
                                "type" => [
                                    [
                                        "coding" => [
                                            [
                                                "system" =>
                                                    "http://terminology.hl7.org/CodeSystem/v3-ParticipationType",
                                                "code" => "ATND",
                                                "display" => "attender",
                                            ],
                                        ],
                                    ],
                                ],
                                "individual" => [
                                    "reference" => "Practitioner/".$idDoktertKemkes,
                                    "display" => $First_Name,
                                ],
                            ],
                        ],
                        "period" => [
                            "start" => $tglRegistrasi,
                            "end" => $tglPulang,
                        ],
                        "location" => [
                            [
                                "location" => [
                                    "reference" =>
                                        "Location/".$idUnitKemkes,
                                    "display" => $NamaUnit,
                                ],
                            ],
                        ],
                        "diagnosis" => $diagnosa,
                        "statusHistory" => $rowsstatus,
                        "serviceProvider" => ["reference" => "Organization/".KEMENKES_Organization_ID],
                        "identifier" => [
                            [
                                "system" =>
                                    "http://sys-ids.kemkes.go.id/encounter/".KEMENKES_Organization_ID,
                                "value" => $NoRegistrasi,
                            ],
                        ],
                    ],
                    "request" => ["method" => "POST", "url" => "Encounter"],
                ],
                [
                    "fullUrl" => "urn:uuid:".$uuidDiagnosautama,
                    "resource" => [
                        "resourceType" => "Condition",
                        "clinicalStatus" => [
                            "coding" => [
                                [
                                    "system" =>
                                        "http://terminology.hl7.org/CodeSystem/condition-clinical",
                                    "code" => "active",
                                    "display" => "Active",
                                ],
                            ],
                        ],
                        "category" => [
                            [
                                "coding" => [
                                    [
                                        "system" =>
                                            "http://terminology.hl7.org/CodeSystem/condition-category",
                                        "code" => "encounter-diagnosis",
                                        "display" => "Encounter Diagnosis",
                                    ],
                                ],
                            ],
                        ],
                        "code" => [
                            "coding" =>  $CodeDiagnosa, 
                        ],
                        "subject" => [
                            "reference" => "Patient/".$idMrkemkes,
                            "display" => $PatientName,
                        ],
                        "encounter" => [
                            "reference" =>
                                "urn:uuid:".$uuidRegistrasi,
                            "display" =>
                                "Kunjungan ".$PatientName.", ".$tglRegistrasi,
                        ],
                    ],
                    "request" => ["method" => "POST", "url" => "Condition"],
                ],
                [
                    "fullUrl" => "urn:uuid:".$uuidDiagnosasekunder,
                    "resource" => [
                        "resourceType" => "Condition",
                        "clinicalStatus" => [
                            "coding" => [
                                [
                                    "system" =>
                                        "http://terminology.hl7.org/CodeSystem/condition-clinical",
                                    "code" => "active",
                                    "display" => "Active",
                                ],
                            ],
                        ],
                        "category" => [
                            [
                                "coding" => [
                                    [
                                        "system" =>
                                            "http://terminology.hl7.org/CodeSystem/condition-category",
                                        "code" => "encounter-diagnosis",
                                        "display" => "Encounter Diagnosis",
                                    ],
                                ],
                            ],
                        ],
                        "code" => [
                            "coding" => $CodeDiagnosaSekunder,
                        ],
                        "subject" => [
                            "reference" => "Patient/".$idMrkemkes,
                            "display" => $PatientName,
                        ],
                        "encounter" => [
                            "reference" =>
                                "urn:uuid:".$uuidRegistrasi,
                            "display" =>
                                "Kunjungan ".$PatientName.", ".$tglRegistrasi,
                        ],
                    ],
                    "request" => ["method" => "POST", "url" => "Condition"],
                ],
            ],
        ];

        $postSatuanData = json_encode((object) $sendataarrayfix); 
         // 1. Gen Token
         $method = "POST";
         $URL = "accesstoken?grant_type=client_credentials";
         $token = $this->curl_request_token_SatuSehat(GenerateTokenSatuSehat::headers_api(), $method, $URL);
         $Fixtoken = "Bearer ".$token['access_token'];  

        // 2. GetHis
        $method2 = "POST"; 
        $urlAddSatuan = "";
        return $this->curl_request_SatuSehat(GenerateTokenSatuSehat::headers_api_token($Fixtoken), $method2, $postSatuanData, $urlAddSatuan);
            
            
    }
}