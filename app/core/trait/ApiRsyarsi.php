<?php
trait ApiRsyarsi
{
    function curl_request_token($header, $method, $URL){
                $postdata = '{
                    "username" : "'.GenerateTokenRS::userToken() . '",
                    "password" :  "' . GenerateTokenRS::passwordToken() . '"
                    
                }'; 
                $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => URL_API_RS . $URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS =>$postdata,
            CURLOPT_HTTPHEADER =>$header,
            ));

        $response = curl_exec($curl);

        curl_close($curl); 
                $JsonData = json_decode($response, TRUE);
                return $JsonData;
    }
    function curl_request($header, $method, $data, $URL){
        
        $ch = curl_init();
        //$headerbpjs = Utils::headerBPJS_BPJSReverenceVclaim($contenttype);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_API_RS . $URL);
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        // set time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
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
    function curl_request_Antrian_rsyarsi($header, $method, $data, $URL){
        
        $ch = curl_init();
        //$headerbpjs = Utils::headerBPJS_BPJSReverenceVclaim($contenttype);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS_ANTRIAN_RS_YARSI . $URL);
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        // set time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
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