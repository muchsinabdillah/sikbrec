<?php
include("hdr_rincianbiaya_ri.php");

$fileName = 'RINCIANBIAYA_RI-'.$GLOBALS['listdataheader']['PatientName'].'-'.$GLOBALS['listdataheader']['NoRegistrasi'].'.pdf';
$pdf->Output($fileName, 'I');