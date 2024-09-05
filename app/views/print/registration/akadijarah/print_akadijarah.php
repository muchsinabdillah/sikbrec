<?php
include("hdr_akadijarah.php");

$fileName = $data['listdata1']['NamaPasien'].' - '.$data['listdata1']['ID'].'.pdf';
$pdf->Output($fileName, 'I');