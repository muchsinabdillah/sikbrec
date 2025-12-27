<?php

use LZCompressor\LZString;

date_default_timezone_set('UTC');

class GenerateBpjs
{
    //public const ENCRYPT_METHOD = 'AES-256-CBC';

    public static function generateSignature($conId, $secId, $tStamp)
    {
        // return base64_encode(hash_hmac('sha256', $conId . "&" . self::bpjsTimestamp(), $secId, true));
        return base64_encode(hash_hmac('sha256', $conId . "&" . $tStamp, $secId, true));
    }

    public static function stringDecrypt($key, $strings)
    { 
        $string2 = base64_decode($strings);
        $encrypt_method = 'AES-256-CBC';

        // hash
        $key_hash = hex2bin(hash('sha256', $key));

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr($key_hash, 0, 16);
        $decrypted =openssl_decrypt($string2, $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);         
        // var_dump($decrypted); 
        // exit;
        return $decrypted; // <- disini kalau pake form kadang false? iya... dari 10 4 false    
    }

    public static function bpjsTimestamp()
    {
        date_default_timezone_set('UTC');
        $tStamp = strval(time() - strtotime('1970-01-01 00:00:00'));
        return $tStamp;
    }

    public static function keyString($conId, $secId,$timestamp)
    {
        return $conId . $secId . $timestamp;
    }

    public static function keyHash($key)
    {
        return hex2bin(hash('sha256', $key));
    }

    public static function ivDecrypt($key)
    {
        return substr(hex2bin(hash('sha256', $key)), 0, 16);
    }

    public static function decompress($string)
    {
        return LZString::decompressFromEncodedURIComponent($string); 
        //cuma response di atas selalu false. makanya g bs d decompress
    }

    public static function responseBpjsV2($dataJson, $key)
    {
        $result = json_decode($dataJson);
        if ($result->metaData->code == "200" && is_string($result->response)) {
            return self::doDecompress($result, $key);
        }
        return json_encode($result);
    }
    public static function responseBpjsV2_Antrian($dataJson, $key)
    {
        $result = json_decode($dataJson);
        if ($result->metadata->code == "200" && is_string($result->response)) {
            return self::doDecompress_Antrian($result, $key);
        }
        return json_encode($result);
    }
    public static function responseBpjsV2_Antrian_Reff($dataJson, $key)
    {
        $result = json_decode($dataJson);
        if ($result->metadata->code == "1" && is_string($result->response)) {
            return self::doDecompress_Antrian_Reff($result, $key);
        }
        return json_encode($result);
    }
    public static function doDecompress_Antrian_Reff($jsonObject, $key)
    {
        if ($jsonObject->metadata->code == "1") {
            return self::mappingResponse($jsonObject->metadata, $jsonObject->response, $key);
        }
        return json_encode($jsonObject);
    }
    public static function doDecompress_Antrian($jsonObject, $key)
    {
        if ($jsonObject->metadata->code == "200") {
            return self::mappingResponse($jsonObject->metadata, $jsonObject->response, $key);
        }
        return json_encode($jsonObject);
    }

    public static function doDecompress($jsonObject, $key)
    {
        if ($jsonObject->metaData->code == "200") {
            return self::mappingResponse($jsonObject->metaData, $jsonObject->response, $key);
        }
        return json_encode($jsonObject);
       
    }

    public static function mappingResponse($metaData, $response, $key)
    {
        return [
            $metaData,
            json_decode(self::decompress(self::stringDecrypt($key, $response)), true)
        ];
      
        
    }
}