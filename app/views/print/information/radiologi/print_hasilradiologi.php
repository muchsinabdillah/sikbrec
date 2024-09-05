<?php
include("hdr_hasilradiologi.php");

$fileName = 'HASIL_RADIOLOGI-.pdf';
$pdf->Output($fileName, 'I');