<?php
include("HdrHasilLab.php");

$fileName = $pname.' - '.$nolab.'.pdf';
$pdf->Output($fileName, 'I');