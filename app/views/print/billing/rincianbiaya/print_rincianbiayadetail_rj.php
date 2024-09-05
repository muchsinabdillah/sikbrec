<?php
include("hdr_rincianbiayadetail_rj.php");

$fileName = 'RINCIANBIAYA_RJ-' . $GLOBALS['listdataheader']['PatientName'] . '-' . $GLOBALS['listdataheader']['NoRegistrasi'] . '.pdf';
$pdf->Output($fileName, 'I');
