<?php
include("hdr_rincianbiaya_rjx.php");

$fileName = 'RINCIANBIAYA_RJ-' . $GLOBALS['listdataheader']['PatientName'] . '-' . $GLOBALS['listdataheader']['NoRegistrasi'] . '.pdf';
$pdf->Output($fileName, 'I');
