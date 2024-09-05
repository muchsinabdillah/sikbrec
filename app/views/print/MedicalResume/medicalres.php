<?php
include("hdr_MEDICALresume.php");

$fileName = 'MedicalResume-' . '.pdf';
$pdf->Output($fileName, 'I');
