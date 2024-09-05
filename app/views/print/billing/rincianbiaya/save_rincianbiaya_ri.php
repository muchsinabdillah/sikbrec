<?php
include("hdr_rincianbiaya_ri.php");
$fileName = 'RINCIANBIAYA_RI-'.$data['notrs'];
$pathfilename = $_SERVER['DOCUMENT_ROOT'].'SIKBREC/public/tmp/'.$fileName.'.pdf';
$pdf->Output($pathfilename, 'F');