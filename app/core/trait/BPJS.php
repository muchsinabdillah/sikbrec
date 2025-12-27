<?php
trait BPJS
{
    // parameter
    // method
    // service name


    function LPKReverense($method, $servicename, $contenttype, $data = null)
    {
        $ch = curl_init();
       // $headerbpjs = Utils::headerBPJS_BPJSReverenceVclaim($contenttype);
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS . $servicename);
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
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
        if (isset($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            //$ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, Utils::setKey());
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            //echo json_encode($output);
            $data = json_decode(json_encode($ResultEncriptLzString), true);
            $reverence = [
                'metadata' => $data[0],
                'response' => (isset($data[1]['list'])) ? $data[1]['list'] : $data[1]
            ];
            return $reverence['response'];
            // return $result['list'];
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message'],
                'metadata' => $JsonData['metaData']

            );
            return $callback;
        }
    }
    function bpjsAPI($method, $servicename, $contenttype, $data = null)
    {
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        //$headerbpjs = Utils::headerBPJS_BPJSReverenceVclaim($contenttype);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS . $servicename);
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
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
        if (isset($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            //$ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, Utils::setKey());
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            //echo json_encode($output);
            $data = json_decode(json_encode($ResultEncriptLzString), true);
            $reverence = [
                'metadata' => $data[0],
                'response' => (isset($data[1]['list'])) ? $data[1]['list'] : $data[1]
            ];
            return $reverence['response'];
            // return $result['list'];
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message'],
                'metadata' => $JsonData['metaData']
            );
            return $callback;
        }
    }
    function conversiarray($data, $indexKey)
    {
        $stack = array();
        $dataarray = $data;
        foreach ($dataarray as $key => $value) {
            array_push($stack, [$indexKey => $value]);
        }
        return $stack;
    }
}
