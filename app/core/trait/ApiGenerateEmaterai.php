<?php
trait ApiGenerateEmaterai
{
    // function curl_request_token($header, $method, $URL){
    //     $postdata = '{
    //         "username" : "'.GenerateTokenRS::userToken() . '",
    //         "password" :  "' . GenerateTokenRS::passwordToken() . '"

    //     }'; 
    //     $ch = curl_init(); 
    //     //$headerbpjs = Utils::headerBPJS_BPJSReverenceVclaim($contenttype);
    //     // set url 
    //     curl_setopt($ch, CURLOPT_URL, URL_API_RS . $URL);
    //     // set header
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    //     // set time out
    //     curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    //     // ssl verifi
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //     // method
    //     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    //     // data yang dikirim
    //     //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    //     // return the transfer as a string 
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    //     // $output contains the output string 
    //     $output = curl_exec($ch);
    //     // tutup curl 
    //     curl_close($ch);
    //     $JsonData = json_decode($output, TRUE);
    //     return $JsonData;
    // }
    function curl_request_ematerai_old($header, $method, $data, $URL)
    {

        $ch = curl_init();
        //$headerbpjs = Utils::headerBPJS_BPJSReverenceVclaim($contenttype);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_API_Materai . $URL);
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
        if ($method == "POST" || $method == "DELETE") {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        $JsonData = json_decode($output, TRUE);
        return $JsonData;
    }
    function curl_request_ematerai($header, $method, $data, $URL)
    {

        $ch = curl_init();
        //$headerbpjs = Utils::headerBPJS_BPJSReverenceVclaim($contenttype);
        // set url 
        // var_dump($data, $URL);exit;
        curl_setopt($ch, CURLOPT_URL, URL_API_Materai . $URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        if ($method == "POST" || $method == "DELETE") {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        $JsonData = json_decode($output, TRUE);
        return $JsonData;
    }
    function curl_request_ematerai_hardcode($header, $method, $data, $URL)
    {

        $curl = curl_init();

        $nama_file = 'KUITANSI-.pdf.pdf';
        $file_name = 'tmp/' . $nama_file;
        // Check if the file exists
        if (!file_exists($file_name)) {


            return ['error' => 'File does not exist: ' . $file_name];
        }

        $source =   curl_file_create($file_name);
        // $handle = fopen($source, 'r');
        // var_dump($file_name);exit;
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apigw.admedika.co.id/api/v2/coremdika',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('provider_code' => '7146', 'document_code' => 'INV', 'document_name' => 'KUITANSI BARU', 'visLLX' => '320', 'visLLY' => '44', 'visURX' => '420', 'visURY' => '144', 'visSignaturePage' => '2', 'reason' => 'cetak', 'nodoc' => '2020', 'IdNumber' => '22', 'nilai_document' => '10000', 'document_date' => '2024-10-02', 'file' => $source, 'endpoint' => 'singleStampMaterai', 'app_id' => 'api_aNky7D', 'project_id' => 'e-materai_1t9v'),
            CURLOPT_HTTPHEADER => array(
                'project_id: e-materai_1t9v',
                'app_id: api_aNky7D',
                'Authorization: Bearer Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX2lkIjoxMTM0LCJyb2xlX2lkIjoiMiIsImNvbXBhbnlfaWQiOjUzLCJkZXBhcnRlbWVudF9pZCI6MTAxLCJlbWFpbCI6Im1hcmtldGluZy5jb3Jwb3JhdGVAcnN5YXJzaS5jby5pZCIsImlzX3BhcmVudCI6bnVsbCwiY2hpbGQiOm51bGwsImt5Y19pZF92aWRhIjpudWxsLCJpYXQiOjE3Mjc3NTUzMTQsImV4cCI6MTcyNzg0MTcxNH0.ESqlIAHTTRQ6A2fkwP31N85rUCS7hGtQAga883jBia4'
            ),
        ));
        // $output contains the output string 
        $output = curl_exec($curl);
        // tutup curl 
        // var_dump($curl);

        curl_close($curl);
        $JsonData = json_decode($output, TRUE);
        // var_dump($output);exit;
        return $JsonData;
    }
    // function curl_request_Antrian_rsyarsi($header, $method, $data, $URL){

    //     $ch = curl_init();
    //     //$headerbpjs = Utils::headerBPJS_BPJSReverenceVclaim($contenttype);
    //     // set url 
    //     curl_setopt($ch, CURLOPT_URL, URL_BPJS_ANTRIAN_RS_YARSI . $URL);
    //     // set header
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    //     // set time out
    //     curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    //     // ssl verifi
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //     // method
    //     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    //     // data yang dikirim
    //     //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    //     // return the transfer as a string 
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //     if($method == "POST" || $method == "DELETE"){
    //         curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    //     }
    //     // $output contains the output string 
    //     $output = curl_exec($ch);
    //     // tutup curl 
    //     curl_close($ch);
    //     $JsonData = json_decode($output, TRUE);
    //     return $JsonData;
    // }

}
