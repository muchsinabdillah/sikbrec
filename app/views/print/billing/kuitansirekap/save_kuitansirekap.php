<?php
include("hdr_kuitansirekap.php");
$fileName = 'KUITANSIREKAP-'.$data['notrs'];
$pathfilename = $_SERVER['DOCUMENT_ROOT'].'SIKBREC/public/tmp/'.$fileName.'.pdf';
$pdf->Output($pathfilename, 'F');