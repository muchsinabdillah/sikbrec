<?php
include("HdrHasilLab.php");
$token = $data['token'];
$replacenumberhp = $data['replacenumberhp'];
//var_dump($replacenumberhp);exit;
$fileName = $pname.' - '.$nolab.'.pdf';
$pdf->Output($fileName, 'F');

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.wappin.id/v1/message/do-send-hsm-with-media',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'media'=> new CurlFile($_SERVER["DOCUMENT_ROOT"].'SIKBREC/public/'.$fileName, 'application/pdf', $fileName),
                'client_id' => '0410',
                'project_id' => '2805',
                'type' => 'hasil_lab_rsyarsi',
                'recipient_number' => $replacenumberhp,
                'language_code' => 'id',
                'params' => '{"1":"Name","2":"80001810
                08192601"}
                '),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token
            ),
        ));
        $response = curl_exec($curl);
        $JsonData = json_decode($response, TRUE);
       // return $JsonData;
        
// $response = curl_exec($curl);
// echo curl_getinfo($curl) . '<br/>';
// echo curl_errno($curl) . '<br/>';
// echo curl_error($curl) . '<br/>';

//var_dump($JsonData['status']);
if($JsonData['status'] == 200) {
    $arrResult = array (
        'status'=> 'success', 
        'message' => 'Berhasil Mengirim');
} else {
    $arrResult = array (
        'status'=> 'error', 
        'message' => 'Gagal Mengirim');
}

curl_close($curl);

//hapus file pdf nya
unlink($fileName);

echo json_encode($arrResult);