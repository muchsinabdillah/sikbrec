<?php
trait SatuSehat


{
    function curl_request_token_SatuSehat($header, $method, $URL){

        $postdata = 'client_id='.KEMENKES_Client_Key.'&client_secret='.KEMENKES_Secret_Key; 
        $ch = curl_init(); 
        //$headerbpjs = Utils::headerBPJS_BPJSReverenceVclaim($contenttype);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_API_KEMENKES . $URL);
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        // set time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        // ssl verifi 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        $JsonData = json_decode($output, TRUE);
        return $JsonData;
    }
    function curl_request_SatuSehat($header, $method, $data, $URL){
        
        $ch = curl_init();
        //$headerbpjs = Utils::headerBPJS_BPJSReverenceVclaim($contenttype);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_API_KEMENKES_PATIEN . $URL);
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        // set time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if($method == "POST" || $method == "DELETE"){
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        $JsonData = json_decode($output, TRUE);
        return $JsonData;
    }
}