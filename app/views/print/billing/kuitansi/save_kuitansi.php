<?php
include("hdr_kuitansi.php");
$fileName = 'KUITANSI-'.$data['notrs'];
$pathfilename = $_SERVER['DOCUMENT_ROOT'].'SIKBREC/public/tmp/'.$fileName.'.pdf';
$pdf->Output($pathfilename, 'F');