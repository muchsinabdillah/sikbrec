<?php
trait SatuSehatPatient
{
    public function GetPatientbyNIK($nik){
        // 1. Gen Token
        $method = "POST";
        $URL = "accesstoken?grant_type=client_credentials";
        $token = $this->curl_request_token_SatuSehat(GenerateTokenSatuSehat::headers_api(), $method, $URL);
        $Fixtoken = "Bearer ".$token['access_token'];

        // 2. GetHis
        $method2 = "GET"; 
        $urlAddSatuan = "Patient?identifier=https://fhir.kemkes.go.id/id/nik%7C".$nik;
        return $this->curl_request_SatuSehat(GenerateTokenSatuSehat::headers_api_token($Fixtoken), $method2, [], $urlAddSatuan);
    }
}