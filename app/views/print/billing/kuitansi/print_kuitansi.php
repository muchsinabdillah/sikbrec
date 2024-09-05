<?php
include("hdr_kuitansi.php");

$fileName = 'KUITANSI-.pdf';
$pdf->Output($fileName, 'I');