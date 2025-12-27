<?php
class GenerateTokenRS
{
//public const ENCRYPT_METHOD = 'AES-256-CBC';
 
public static function headers_api(){
    $headerBPJS = array(
        'Accept: application/json',
        'Content-Type: application/json'
    );
    return $headerBPJS;
}
    public static function headers_api_token($token)
    {

        $headerwithtoken = array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: '. $token
        );
        return $headerwithtoken;
    }
    public static function headers_api_token_antrian_RSyarsi()
    {

        $headerwithtoken = array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: '. "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczpcL1wvYXBpLnJzeWFyc2kuY28uaWRcL2FwaVwvZ2VuVG9rZW4iLCJpYXQiOjE2NjkyNzM4ODcsIm5iZiI6MTY2OTI3Mzg4NywianRpIjoiVGJyRTZnZnFrUjE1TktudCIsInN1YiI6MSwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.TI_IuWtKLTfaBTvgUKwMripQuqGu9TwHrKNOBR-FPB8"
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