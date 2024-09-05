<?php
include("hdr_rincianbiaya_rj.php");
$fileName = 'RINCIANBIAYA_RJ-'.$data['notrs'];
$pathfilename = $_SERVER['DOCUMENT_ROOT'].'SIKBREC/public/tmp/'.$fileName.'.pdf';
$pdf->Output($pathfilename, 'F');