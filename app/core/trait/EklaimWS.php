<?php
trait EklaimWS
{
    function EklaimApi($json_request = null)
    {

        // data yang akan dikirimkan dengan method POST adalah encrypted:
        $payload = Eklaim::inacbg_encrypt($json_request,Utils::eklaimKey());
        // tentukan Content-Type pada http header
        $header = array("Content-Type: application/x-www-form-urlencoded");
        // url server aplikasi E-Klaim,
        // silakan disesuaikan instalasi masing-masing
        $url = URL_EKLAIM;
        // setup curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        // request dengan curl
        $response = curl_exec($ch);
        // terlebih dahulu hilangkan "----BEGIN ENCRYPTED DATA----\r\n"
        // dan hilangkan "----END ENCRYPTED DATA----\r\n" dari response

        // terlebih dahulu hilangkan "----BEGIN ENCRYPTED DATA----\r\n"
        // dan hilangkan "----END ENCRYPTED DATA----\r\n" dari response
        $first = strpos($response, "\n")+1;
        $last = strrpos($response, "\n")-1;
        $response = substr($response,
        $first,
        strlen($response) - $first - $last);


        // decrypt dengan fungsi inacbg_decrypt
        $response = Eklaim::inacbg_decrypt($response,Utils::eklaimKey());
        // hasil decrypt adalah format json, ditranslate kedalam array
        $msg = json_decode($response,true);
        
        return $msg;
         
    }
}