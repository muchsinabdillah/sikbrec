<?php
trait SatuSehatEncounter
{
    public function PostEncounter($idMrkemkes,$namapasien,$idDoktertKemkes,$NamaDokter,$xTglNowTempx,
                                $idUnitKemkes,$NamaGrupPerawatan,$nofixReg){
        // INSERT POST TO KEMNKES
        // 1. Gen Token
        $method = "POST";
        $URL = "accesstoken?grant_type=client_credentials";
        $token = $this->curl_request_token_SatuSehat(GenerateTokenSatuSehat::headers_api(), $method, $URL);
        $Fixtoken = "Bearer ".$token['access_token']; 

        // 2. GetHis
                    $method2 = "POST"; 
                    $urlAddSatuan = "Encounter"; 
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
                            "reference": "Patient/'.$idMrkemkes.'",
                            "display": "'.$namapasien.'" 
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
                                    "reference": "Practitioner/'.$idDoktertKemkes.'",
                                    "display": "'.$NamaDokter.'"
                                }
                            }
                        ],
                        "period": {
                            "start": "'.$xTglNowTempx.'+07:00"
                        },
                        "location": [
                            {
                                "location": {
                                    "reference": "Location/'.$idUnitKemkes.'",
                                    "display": "'.$NamaGrupPerawatan.'"
                                }
                            }
                        ],
                        "statusHistory": [
                            {
                                "status": "arrived",
                                "period": {
                                    "start": "'.$xTglNowTempx.'+07:00"
                                }
                            }
                        ],
                        "serviceProvider": {
                                 "reference": "Organization/'.KEMENKES_Organization_ID.'"
                        },
                        "identifier": [
                            {
                                "system": "http://sys-ids.kemkes.go.id/encounter/'.KEMENKES_Organization_ID.'",
                                "value": "'.$nofixReg.'"
                            }
                        ]
                    }';
                    // UPDATE REG KEMENKES KE TABEL VISIT
                    return $this->curl_request_SatuSehat(GenerateTokenSatuSehat::headers_api_token($Fixtoken), $method2, $postSatuanData, $urlAddSatuan);
    }
}