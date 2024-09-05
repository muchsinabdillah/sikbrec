<?php
include("hdr_resumemedis.php");

$fileName = 'MedicalResume-' . '.pdf';
$pdf->Output($fileName, 'I');
