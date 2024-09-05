<?php
include("hdr_rincianbiaya_pb.php");
$fileName = 'RINCIANBIAYA_PB-'.$data['notrs'];
$pathfilename = $_SERVER['DOCUMENT_ROOT'].'SIKBREC/public/tmp/'.$fileName.'.pdf';
$pdf->Output($pathfilename, 'F');