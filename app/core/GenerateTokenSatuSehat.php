<?php
class GenerateTokenSatuSehat
{
//public const ENCRYPT_METHOD = 'AES-256-CBC';
 
    public static function headers_api(){
            $headerBPJS = array(
                
                'Content-Type: application/x-www-form-urlencoded'
            );
            return $headerBPJS;
    }
    public static function headers_api_token($token)
    {

        $headerwithtoken = array( 
            'Content-Type: application/json',
            'Authorization: '. $token
        );
        return $headerwithtoken;
    }
    public static function userToken(){
        $username = "Administrator";
        //$consID = "13384"; // online
        return $username;
    }
    public static function passwordToken()
    {
        $password = "balik50R3#1700";
        //$consID = "13384"; // online
        return $password;
    }
}