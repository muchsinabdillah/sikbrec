<?php
include("hdr_laporankasir.php");

$fileName = 'LAPORAN KASIR REKAP DETAIL-.pdf';
$pdf->Output($fileName, 'I');
