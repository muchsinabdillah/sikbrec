<?php
trait SatuSehatLocation
{
    public function PostLocations($CodeUnit_gen,$NamaUnit){
        // INSERT POST TO KEMNKES
        // GET DATA PROFILE RS
        $this->db->query("SELECT * 
        from MasterdataSQL.dbo.A_DATA_RS "); 
        $datProfileRS =  $this->db->single();
        $NamaRS = $datProfileRS['NamaRS']; 
        $KodeRS = $datProfileRS['KodeRS']; 
        $KodeRSBPJS = $datProfileRS['KodeRSBPJS'];  
        $AlamatRS = $datProfileRS['AlamatRS']; 
        $RT = $datProfileRS['RT']; 
        $RW = $datProfileRS['RW']; 
        $ProvinsiCode = $datProfileRS['ProvinsiCode']; 
        $ProvinsiName = $datProfileRS['ProvinsiName']; 
        $KotaCode = $datProfileRS['KotaCode']; 
        $KotaName = $datProfileRS['KotaName'];  
        $KecamtanCode = $datProfileRS['KecamtanCode']; 
        $KecamatanName = $datProfileRS['KecamatanName']; 
        $KelurahanCode = $datProfileRS['KelurahanCode']; 
        $KelurahanName = $datProfileRS['KelurahanName']; 
        $Kodepos = $datProfileRS['Kodepos']; 
        $Longitude = $datProfileRS['Longitude']; 
        $Latitude = $datProfileRS['Latitude']; 
        $Website = $datProfileRS['Website']; 
        $Phone = $datProfileRS['Phone']; 
        $Email = $datProfileRS['Email']; 
        $Fax = $datProfileRS['Fax']; 

                    // 1. Gen Token
                    $method = "POST";
                    $URL = "accesstoken?grant_type=client_credentials";
                    $token = $this->curl_request_token_SatuSehat(GenerateTokenSatuSehat::headers_api(), $method, $URL);
                    $Fixtoken = "Bearer ".$token['access_token'];
                    
                    // // 2. Post Location
                    $method2 = "POST"; 
                    $urlAddSatuan = "Location"; 
                    //data
                    $postSatuanData = '{
                        "resourceType": "Location",
                        "identifier": [
                            {
                                "system": "http://sys-ids.kemkes.go.id/location/'.KEMENKES_Organization_ID.'",
                                "value": "'.$CodeUnit_gen.'"
                            }
                        ],
                        "status": "active",
                        "name": "'.$NamaUnit.'",
                        "description": "'.$NamaUnit.'",
                        "mode": "instance",
                        "telecom": [
                            {
                                "system": "phone",
                                "value": "'.$Phone.'",
                                "use": "work"
                            },
                            {
                                "system": "fax",
                                "value": "'.$Fax.'",
                                "use": "work"
                            },
                            {
                                "system": "email",
                                "value": "'.$Email.'"
                            },
                            {
                                "system": "url",
                                "value": "'.$Website.'",
                                "use": "work"
                            }
                        ],
                        "address": {
                            "use": "work",
                            "line": [
                                "'.$AlamatRS.'"
                            ],
                            "city": "Jakarta",
                            "postalCode": "'.$Kodepos.'",
                            "country": "ID",
                            "extension": [
                                {
                                    "url": "https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode",
                                    "extension": [
                                        {
                                            "url": "province",
                                            "valueCode": "'.$ProvinsiCode.'"
                                        },
                                        {
                                            "url": "city",
                                            "valueCode": "'.$KotaCode.'"
                                        },
                                        {
                                            "url": "district",
                                            "valueCode": "'.$KecamtanCode.'"
                                        },
                                        {
                                            "url": "village",
                                            "valueCode": "'.$KelurahanCode.'"
                                        },
                                        {
                                            "url": "rt",
                                            "valueCode": "'.$RT.'"
                                        },
                                        {
                                            "url": "rw",
                                            "valueCode": "'.$RW.'"
                                        }
                                    ]
                                }
                            ]
                        },
                        "physicalType": {
                            "coding": [
                                {
                                    "system": "http://terminology.hl7.org/CodeSystem/location-physical-type",
                                    "code": "ro",
                                    "display": "Room"
                                }
                            ]
                        },
                        "position": {
                            "longitude": '.$Longitude.',
                            "latitude": '.$Latitude.',
                            "altitude": 0
                        },
                        "managingOrganization": {
                            "reference": "Organization/'.KEMENKES_Organization_ID.'"
                        }
                    }';
                    $addSatuan = $this->curl_request_SatuSehat(GenerateTokenSatuSehat::headers_api_token($Fixtoken), $method2, $postSatuanData, $urlAddSatuan);
                    return $addSatuan;

    }
    public function PutLocations($CodeUnit_gen,$NamaUnit,$idunitKemenkes){
        // INSERT POST TO KEMNKES
        // GET DATA PROFILE RS
        $this->db->query("SELECT * 
        from MasterdataSQL.dbo.A_DATA_RS "); 
        $datProfileRS =  $this->db->single();
        $NamaRS = $datProfileRS['NamaRS']; 
        $KodeRS = $datProfileRS['KodeRS']; 
        $KodeRSBPJS = $datProfileRS['KodeRSBPJS'];  
        $AlamatRS = $datProfileRS['AlamatRS']; 
        $RT = $datProfileRS['RT']; 
        $RW = $datProfileRS['RW']; 
        $ProvinsiCode = $datProfileRS['ProvinsiCode']; 
        $ProvinsiName = $datProfileRS['ProvinsiName']; 
        $KotaCode = $datProfileRS['KotaCode']; 
        $KotaName = $datProfileRS['KotaName'];  
        $KecamtanCode = $datProfileRS['KecamtanCode']; 
        $KecamatanName = $datProfileRS['KecamatanName']; 
        $KelurahanCode = $datProfileRS['KelurahanCode']; 
        $KelurahanName = $datProfileRS['KelurahanName']; 
        $Kodepos = $datProfileRS['Kodepos']; 
        $Longitude = $datProfileRS['Longitude']; 
        $Latitude = $datProfileRS['Latitude']; 
        $Website = $datProfileRS['Website']; 
        $Phone = $datProfileRS['Phone']; 
        $Email = $datProfileRS['Email']; 
        $Fax = $datProfileRS['Fax']; 

                    // 1. Gen Token
                    $method = "POST";
                    $URL = "accesstoken?grant_type=client_credentials";
                    $token = $this->curl_request_token_SatuSehat(GenerateTokenSatuSehat::headers_api(), $method, $URL);
                    $Fixtoken = "Bearer ".$token['access_token'];
                    
                    // // 2. Post Location
                    $method2 = "PUT"; 
                    $urlAddSatuan = "Location"; 
                    //data
                    $postSatuanData = '{
                        "resourceType": "Location",
                        "identifier": [
                            {
                                "system": "http://sys-ids.kemkes.go.id/location/'.$idunitKemenkes.'",
                                "value": "'.$CodeUnit_gen.'"
                            }
                        ],
                        "status": "active",
                        "name": "'.$NamaUnit.'",
                        "description": "'.$NamaUnit.'",
                        "mode": "instance",
                        "telecom": [
                            {
                                "system": "phone",
                                "value": "'.$Phone.'",
                                "use": "work"
                            },
                            {
                                "system": "fax",
                                "value": "'.$Fax.'",
                                "use": "work"
                            },
                            {
                                "system": "email",
                                "value": "'.$Email.'"
                            },
                            {
                                "system": "url",
                                "value": "'.$Website.'",
                                "use": "work"
                            }
                        ],
                        "address": {
                            "use": "work",
                            "line": [
                                "'.$AlamatRS.'"
                            ],
                            "city": "Jakarta",
                            "postalCode": "'.$Kodepos.'",
                            "country": "ID",
                            "extension": [
                                {
                                    "url": "https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode",
                                    "extension": [
                                        {
                                            "url": "province",
                                            "valueCode": "'.$ProvinsiCode.'"
                                        },
                                        {
                                            "url": "city",
                                            "valueCode": "'.$KotaCode.'"
                                        },
                                        {
                                            "url": "district",
                                            "valueCode": "'.$KecamtanCode.'"
                                        },
                                        {
                                            "url": "village",
                                            "valueCode": "'.$KelurahanCode.'"
                                        },
                                        {
                                            "url": "rt",
                                            "valueCode": "'.$RT.'"
                                        },
                                        {
                                            "url": "rw",
                                            "valueCode": "'.$RW.'"
                                        }
                                    ]
                                }
                            ]
                        },
                        "physicalType": {
                            "coding": [
                                {
                                    "system": "http://terminology.hl7.org/CodeSystem/location-physical-type",
                                    "code": "ro",
                                    "display": "Room"
                                }
                            ]
                        },
                        "position": {
                            "longitude": '.$Longitude.',
                            "latitude": '.$Latitude.',
                            "altitude": 0
                        },
                        "managingOrganization": {
                            "reference": "Organization/'.KEMENKES_Organization_ID.'"
                        }
                    }';
                    $addSatuan = $this->curl_request_SatuSehat(GenerateTokenSatuSehat::headers_api_token($Fixtoken), $method2, $postSatuanData, $urlAddSatuan);
                   // $idUnitkemkes =  $addSatuan['id']; 
                    return $addSatuan;

    }
}