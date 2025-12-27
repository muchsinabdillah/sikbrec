<?php

use Ramsey\Uuid\Uuid;

class Utils
{

    public static function setDecode($pesan)
    {
        return base64_decode($pesan);
    }
    public static function seCurrentDateTime()
    {
        date_default_timezone_set('Asia/Jakarta');
        $tgl_input = date('Y-m-d H:i:s');
        return $tgl_input;
    }
    public static function datenowcreateNotFull()
    {
        date_default_timezone_set('Asia/Jakarta');
        $datenowcreateNotFull = date("Y-m-d");
        return $datenowcreateNotFull;
    }
    public static function datenowcreateHourMinutes()
    {
        date_default_timezone_set('Asia/Jakarta');
        $datenowcreateNotFull = date("H:i");
        return $datenowcreateNotFull;
    }
    public static function datenowcreateMonthOnly()
    {
        date_default_timezone_set('Asia/Jakarta');
        $datenowcreateNotFull = date("m");
        return $datenowcreateNotFull;
    }
    public static function datenowcreateYearMonth()
    {
        date_default_timezone_set('Asia/Jakarta');
        $datenowcreateNotFull = date("Y-m");
        return $datenowcreateNotFull;
    }
    public static function datenowcreateMonthOnly2()
    {
        date_default_timezone_set('Asia/Jakarta');
        $datenowcreateNotFull = date("n");
        return $datenowcreateNotFull;
    }
    public static function createMonthRomawi($month)
    {
        if ($month == "01") {
            $monthRomawi = "I";
        } elseif ($month == "02") {
            $monthRomawi = "II";
        } elseif ($month == "03") {
            $monthRomawi = "III";
        } elseif ($month == "04") {
            $monthRomawi = "IV";
        } elseif ($month == "05") {
            $monthRomawi = "V";
        } elseif ($month == "06") {
            $monthRomawi = "VI";
        } elseif ($month == "07") {
            $monthRomawi = "VII";
        } elseif ($month == "08") {
            $monthRomawi = "VIII";
        } elseif ($month == "09") {
            $monthRomawi = "IX";
        } elseif ($month == "10") {
            $monthRomawi = "X";
        } elseif ($month == "11") {
            $monthRomawi = "XI";
        } elseif ($month == "12") {
            $monthRomawi = "XII";
        }
        return $monthRomawi;
    }
    public static function datenowcreateYearOnly()
    {
        date_default_timezone_set('Asia/Jakarta');
        $datenowcreateNotFull = date("Y");
        return $datenowcreateNotFull;
    }
    public static function token()
    {
        $SECRET_KEY = "aslejlj3454350sdjopj#30%%((%(345345l3545rttertt049566546546";
        return $SECRET_KEY;
    }
    public static function encryptSha256($password)
    {
        $XMst_Password = hash_hmac('sha256',   $password, true);
        $encodeXMst_Password = base64_encode($XMst_Password);
        return $encodeXMst_Password;
    }
    public static function encryptBase64($data)
    {
        $xcode = base64_encode($data);
        return $xcode;
    }
    public static function delSession()
    {
        unset($_COOKIE['X-PZN-SESSION']);
        setcookie("X-PZN-SESSION", null, -1, '/');

        return  BASEURL . '/Login';
    }
    public static function idtrsByDatetime()
    {
        date_default_timezone_set('Asia/Jakarta');
        $idTrs = date('YmdHis');
        return $idTrs;
    }
    public static function idtrsByDateOnly()
    {
        date_default_timezone_set('Asia/Jakarta');
        $idTrs = date('dmy');
        return $idTrs;
    }
    public static function generateAutoNumberFourDigit($idReg)
    {
        // GENERATE NO REGISTRASI
        if (strlen($idReg) == 1) {
            $noUrutJurnal = "000" . $idReg;
        } else if (strlen($idReg) == 2) {
            $noUrutJurnal = "00" . $idReg;
        } else if (strlen($idReg) == 3) {
            $noUrutJurnal = "0" . $idReg;
        } else if (strlen($idReg) == 4) {
            $noUrutJurnal = $idReg;
        }
        return $noUrutJurnal;
    }
    public static function generateAutoNumberMedicalRecord($idMedicalRecord)
    {
        // GENERATE NO REGISTRASI
        if (strlen($idMedicalRecord) == 1) {
            $nourutfixMR = "00000" . $idMedicalRecord;
        } else if (strlen($idMedicalRecord) == 2) {
            $nourutfixMR = "0000" . $idMedicalRecord;
        } else if (strlen($idMedicalRecord) == 3) {
            $nourutfixMR = "000" . $idMedicalRecord;
        } else if (strlen($idMedicalRecord) == 4) {
            $nourutfixMR = "00" . $idMedicalRecord;
        } else if (strlen($idMedicalRecord) == 5) {
            $nourutfixMR = "0" . $idMedicalRecord;
        } else if (strlen($idMedicalRecord) == 6) {
            $nourutfixMR = $idMedicalRecord;
        }
        return $nourutfixMR;
    }

    public static function generateAutoNumberMedicalRecordPACS($idMedicalRecord)
    {
        // GENERATE NO REGISTRASI
        if (strlen($idMedicalRecord) == 1) {
            $nourutfixReg = "0000000" . $idMedicalRecord;
        } else if (strlen($idMedicalRecord) == 2) {
            $nourutfixReg = "000000" . $idMedicalRecord;
        } else if (strlen($idMedicalRecord) == 3) {
            $nourutfixReg = "00000" . $idMedicalRecord;
        } else if (strlen($idMedicalRecord) == 4) {
            $nourutfixReg = "0000" . $idMedicalRecord;
        } else if (strlen($idMedicalRecord) == 5) {
            $nourutfixReg = "000" . $idMedicalRecord;
        } else if (strlen($idMedicalRecord) == 6) {
            $nourutfixReg = "00" . $idMedicalRecord;
        } else if (strlen($idMedicalRecord) == 7) {
            $nourutfixReg = "0" . $idMedicalRecord;
        } else if (strlen($idMedicalRecord) == 8) {
            $nourutfixReg = $idMedicalRecord;
        }
        return $nourutfixReg;
    }

    public static function generateAutoNumber($idMedicalRecord)
    {
        // $digit = strlen($idMedicalRecord);
        // do {
        //   } while (0 <= $digit);

        // GENERATE NO REGISTRASI
        if (strlen($idMedicalRecord) == 1) {
            $nourutfixMR = "0000" . $idMedicalRecord;
        } else if (strlen($idMedicalRecord) == 2) {
            $nourutfixMR = "000" . $idMedicalRecord;
        } else if (strlen($idMedicalRecord) == 3) {
            $nourutfixMR = "00" . $idMedicalRecord;
        } else if (strlen($idMedicalRecord) == 4) {
            $nourutfixMR = "0" . $idMedicalRecord;
        } else if (strlen($idMedicalRecord) == 5) {
            $nourutfixMR = $idMedicalRecord;
        }
        return $nourutfixMR;
    }

    public static function compressImage($type, $source, $destination, $quality)
    {

        $info = getimagesize($source);

        if ($type == 'image/jpeg')
            $image = imagecreatefromjpeg($source);

        elseif ($type == 'image/gif')
            $image = imagecreatefromgif($source);

        elseif ($type == 'image/png')
            $image = imagecreatefrompng($source);

        return imagejpeg($image, $destination, $quality);
    }
    public static function get_client_ip()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'IP tidak dikenali';
        return $ipaddress;
    }
    // Mendapatkan IP pengunjung menggunakan $_SERVER
    public static function get_client_ip_2()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'IP tidak dikenali';
        return $ipaddress;
    }


    // Mendapatkan jenis web browser pengunjung
    public static function get_client_browser()
    {
        $browser = '';
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'Netscape'))
            $browser = 'Netscape';
        else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox'))
            $browser = 'Firefox';
        else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome'))
            $browser = 'Chrome';
        else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera'))
            $browser = 'Opera';
        else if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE'))
            $browser = 'Internet Explorer';
        else
            $browser = 'Other';
        return $browser;
    }
    public static function getDaysInMounth($month, $year)
    {
        $jumHari = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        return $jumHari;
    }
    public static function getDayBeforeperiode($periode)
    {
        $Info_Date_StartKontrak_minsatu = date('Y-m-d', strtotime('-1 days', strtotime($periode)));
        return $Info_Date_StartKontrak_minsatu;
    }
    public static function getCurrentTime()
    {
        date_default_timezone_set('Asia/Jakarta');
        $time = date('H:i:s', time());
        return $time;
    }
    public static function genOTP()
    {
        $genOtp = random_int(100000, 999999);
        return $genOtp;
    }
    // ADD_BPJS
    public static function headerBPJS_BPJS($tstamp)
    {
        $consID = self::setConsid();
        $scretKey = self::setSeckey();
        $user_key = self::user_key();
        // Computes the timestamp
        //date_default_timezone_set('UTC');
        //$tStamp = strval(time() - strtotime('1970-01-01 00:00:00'));
        $tStamp = $tstamp;
        // Computes the signature by hashing the salt with the secret key as the key
        //$signature = hash_hmac('sha256', $consID . "&" . $tStamp, $scretKey, true);
        // $encodedSignature = GenerateBpjs::generateSignature($consID, $scretKey);
        $encodedSignature = GenerateBpjs::generateSignature($consID, $scretKey, $tstamp);
        // base64 encode…
        //$encodedSignature = base64_encode($signature);
        // Generate Header for BPJS Bridging
        $headerBPJS = array(
            'X-cons-id:' . $consID,
            'X-timestamp:' . $tStamp,
            'X-signature:' . $encodedSignature,
            'Content-Type:Application/x-www-form-urlencode',
            'user_key:' . $user_key
        );
        return $headerBPJS;
    }
    public static function headerBPJS_BPJS_Icare($tstamp)
    {
        $consID = self::setConsid();
        $scretKey = self::setSeckey();
        $user_key = self::user_key();
        // Computes the timestamp
        //date_default_timezone_set('UTC');
        //$tStamp = strval(time() - strtotime('1970-01-01 00:00:00'));
        $tStamp = $tstamp;
        // Computes the signature by hashing the salt with the secret key as the key
        //$signature = hash_hmac('sha256', $consID . "&" . $tStamp, $scretKey, true);
        // $encodedSignature = GenerateBpjs::generateSignature($consID, $scretKey);
        $encodedSignature = GenerateBpjs::generateSignature($consID, $scretKey, $tstamp);
        // base64 encode…
        //$encodedSignature = base64_encode($signature);
        // Generate Header for BPJS Bridging
        $headerBPJS = array(
            'X-cons-id:' . $consID,
            'X-timestamp:' . $tStamp,
            'X-signature:' . $encodedSignature,
            'Content-Type:application/json',
            'user_key:' . $user_key
        );
        return $headerBPJS;
    }
    public static function headerBPJS_BPJS_Antrian($tstamp)
    {
        $consID = self::setConsid_Antrian();
        $scretKey = self::setSeckey_Antrian();
        $user_key = self::user_key_Antrian();
        // Computes the timestamp
        //date_default_timezone_set('UTC');
        //$tStamp = strval(time() - strtotime('1970-01-01 00:00:00'));
        $tStamp = $tstamp;
        // Computes the signature by hashing the salt with the secret key as the key
        //$signature = hash_hmac('sha256', $consID . "&" . $tStamp, $scretKey, true);
        $encodedSignature = GenerateBpjs::generateSignature($consID, $scretKey, $tStamp);
        // base64 encode…
        //$encodedSignature = base64_encode($signature);
        // Generate Header for BPJS Bridging
        $headerBPJS = array(
            'X-cons-id:' . $consID,
            'X-timestamp:' . $tStamp,
            'X-signature:' . $encodedSignature,
            'Content-Type:Application/x-www-form-urlencode',
            'user_key:' . $user_key
        );
        return $headerBPJS;
    }
    // ADD_BPJS
    public static function headerBPJS_BPJS_Aplicares()
    {
        $consID = self::setConsid_Aplicares();
        $scretKey = self::setSeckey_Aplicares();
        $user_key = self::user_key();
        // Computes the timestamp
        //date_default_timezone_set('UTC');
        //$tStamp = strval(time() - strtotime('1970-01-01 00:00:00'));
        $tStamp = GenerateBpjs::bpjsTimestamp();
        // Computes the signature by hashing the salt with the secret key as the key
        //$signature = hash_hmac('sha256', $consID . "&" . $tStamp, $scretKey, true);
        // $encodedSignature = GenerateBpjs::generateSignature($consID, $scretKey);
        $encodedSignature = GenerateBpjs::generateSignature($consID, $scretKey, $tStamp);
        // base64 encode…
        //$encodedSignature = base64_encode($signature);
        // Generate Header for BPJS Bridging
        $headerBPJS = array(
            'X-cons-id:' . $consID,
            'X-timestamp:' . $tStamp,
            'X-signature:' . $encodedSignature,
            'Content-Type:application/json'
          //  'user_key:' . $user_key
        );
        return $headerBPJS;
    }
    public static function setKey()
    {
        return GenerateBpjs::keyString(self::setConsid(), self::setSeckey(),null);
    }
    public static function setConsid()
    {
        // $consID = "13384"; //online
        $consID = "32182"; //tester
        return $consID;
    }
    public static function setConsid_Antrian()
    {
        // $consID = "13384"; // online
        $consID = "11959"; // tester
        return $consID;
    }
    public static function setConsid_Aplicares()
    {
        $consID = "13384";
        return $consID;
    }
    public static function setSeckey()
    {
        // $scretKey = "4eA130B116"; // online
        $scretKey = "9aS44257A4"; // tester
        return $scretKey;
    }
    public static function setSeckey_Antrian()
    {
        // $scretKey = "4eA130B116";  // online
        $scretKey = "3mL5A242F7";  // tester
        return $scretKey;
    }
    public static function setSeckey_Aplicares()
    {
        $scretKey = "4eA130B116";
        return $scretKey;
    }
    public static function user_key()
    {
        // $user_key = "01688765d892fd9e3c7136cdcff8f560"; // online
        $user_key = "0d5ebbdff14d07d500d168c1852e555e"; // tester
        return $user_key;
    }
    public static function user_key_Antrian()
    {
        // $user_key = "2ddc17e0903dfe63e07bf37d602106d6"; // online
        $user_key = "05841340f98cb0b17ce12daedc76db77"; // tester
        return $user_key;
    }

    public static function headerBPJS_BPJSReverenceVclaim($contentype)
    {
        $consID = self::setConsid();
        $scretKey = self::setSeckey();
        $user_key = self::user_key();
        // Computes the timestamp
        //date_default_timezone_set('UTC');
        //$tStamp = strval(time() - strtotime('1970-01-01 00:00:00'));
        $tStamp = GenerateBpjs::bpjsTimestamp();
        // Computes the signature by hashing the salt with the secret key as the key
        //$signature = hash_hmac('sha256', $consID . "&" . $tStamp, $scretKey, true);
        $encodedSignature = GenerateBpjs::generateSignature($consID, $scretKey, $tStamp);
        // base64 encode…
        //$encodedSignature = base64_encode($signature);
        // Generate Header for BPJS Bridging
        $headerBPJS = array(
            'X-cons-id:' . $consID,
            'X-timestamp:' . $tStamp,
            'X-signature:' . $encodedSignature,
            $contentype,
            'user_key:' . $user_key
        );
        return $headerBPJS;
    }
    public static function hp($nohp)
    {
        // kadang ada penulisan no hp 0811 239 345
        $nohp = str_replace(" ", "", $nohp);
        // kadang ada penulisan no hp (0274) 778787
        $nohp = str_replace("(", "", $nohp);
        // kadang ada penulisan no hp (0274) 778787
        $nohp = str_replace(")", "", $nohp);
        // kadang ada penulisan no hp 0811.239.345
        $nohp = str_replace(".", "", $nohp);
        // kadang ada penulisan no hp 0811-239-345
        $nohp = str_replace("-", "", $nohp);
        
        $hp = $nohp;


        // cek apakah no hp mengandung karakter + dan 0-9
        if (!preg_match('/[^+0-9]/', trim($nohp))) {
            // cek apakah no hp karakter 1-3 adalah +62
            if (substr(trim($nohp), 0, 3) == '+62') {
                $hp = trim($nohp);
            }
            // cek apakah no hp karakter 1 adalah 0
            elseif (substr(trim($nohp), 0, 1) == '0') {
                $hp = '+62' . substr(trim($nohp), 1);
            }
        }
        return $hp;
    }
    public static function eklaimKey()
    {
         $scretKey = "6ace9bfb4d38e3bd6090af481a6b6a341d166c2a9845685957fd051a38625a9a";
        return $scretKey;
    }
    public static function uuid4str()
    {
         return Uuid::uuid4()->toString();
    }
}
