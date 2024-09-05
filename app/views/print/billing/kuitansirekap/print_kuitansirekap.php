<?php
include("hdr_kuitansirekap.php");

$fileName = 'KUITANSIREKAP-.pdf';
$pdf->Output($fileName, 'I');