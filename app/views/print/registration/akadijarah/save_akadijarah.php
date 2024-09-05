<?php
include("hdr_akadijarah.php");

$fileName = 'AKADIJAROH-'.$data['listdata1']['ID'];
//$pathfilename = 'tmp/'.$fileName.'.pdf';
$pathfilename = $_SERVER['DOCUMENT_ROOT'].'SIKBREC/public/tmp/'.$fileName.'.pdf';
//$pdf->Output('F',$pathfilename,true);
$pdf->Output($pathfilename, 'F');