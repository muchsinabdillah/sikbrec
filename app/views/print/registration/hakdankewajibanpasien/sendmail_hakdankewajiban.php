<?php
//include("HdrHasilLab.php");
//ini wajib dipanggil paling atas
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
       //$emailcc = "laboratory.installation@rsyarsi.co.id";
       $emailcc = "muchsin@rsyarsi.co.id";
       require '../App/library/PHPMailer/src/Exception.php';
       require '../App/library/PHPMailer/src/PHPMailer.php';
       require '../App/library/PHPMailer/src/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 1;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.kirimemail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'noreply@csmails.rsyarsi.co.id';                     //SMTP username
    $mail->Password   = 'GZKlH4YI';                               //SMTP password
    $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //pengirim
    $mail->setFrom('noreply@csmails.rsyarsi.co.id', 'Rumah Sakit YARSI');
    $email_to = 'muchsin.abdillah@gmail.com';
    $mail->addAddress($email_to);     //Add a recipient
 
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject   = 'Hak dan Kewajiban Pasien';
    $mail->Body      = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    </head>
    <body style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont,  Roboto, Helvetica, Arial, sans-serif, ; position: relative; -webkit-text-size-adjust: none; background-color: #ffffff; color: #718096; height: 100%; line-height: 1.4; margin: 0; padding: 0; width: 100% !important;">
    <style>
    @media  only screen and (max-width: 600px) {
    .inner-body {
    width: 100% !important;
    }
    .footer {
    width: 100% !important;
    }
    }
    @media  only screen and (max-width: 500px) {
    .button {
    width: 100% !important;
    }
    }
    </style>
    <p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont,  Roboto, Helvetica, Arial, sans-serif, ; position: relative; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">Assalamualaikum Warahmatullahi Wabaraktuh</p>
    <p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont,  Roboto, Helvetica, Arial, sans-serif, ; position: relative; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">Yth, bpk/ibu/saudara 
    Ditempat</p>
    <p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont,  Roboto, Helvetica, Arial, sans-serif, ; position: relative; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">Berikut kami lampirkan hak dan kewajiban yang telah dilakukan di RS yarsi.</p>
    <p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont,  Roboto, Helvetica, Arial, sans-serif, ; position: relative; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">Terimakasih atas kepercayaan Anda kepada kami.</p>
    <p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont,  Roboto, Helvetica, Arial, sans-serif, ; position: relative; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">Wassalamualaikum wr wb</p>
    <p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont,  Roboto, Helvetica, Arial, sans-serif, ; position: relative; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">RS yarsi</p>
    </body>
    </html>
        ';
    $mail->AltBody = '';
    //$mail->AddEmbeddedImage('gambar/logo.png', 'logo'); //abaikan jika tidak ada logo
    //$mail->addAttachment(''); 
    $mail->addStringAttachment(file_get_contents($data['listdata1']['AwsUrlDocuments']), 'HAKDANKEWAJIBAN-'.$data['listdata1']['ID'].'-'.$data['listdata1']['NamaPasien'], $encoding = 'base64', $type = 'application/pdf');
    

    if(!$mail->send()) {
        $arrResult = array ('status'=>'error', 'message' => 'Gagal Mengirim, errorinfo: '. $mail->ErrorInfo);
    } else {
        $arrResult = array ('status'=>'success', 'message' => 'Berhasil Mengirim E-Mail Ke '. $email_to);
    }
    //return $arrResult;
    
    echo json_encode($arrResult);
   
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

    }
  
        ?>