<?php
include("hdr_resumemedis.php");

$fileName = 'RESUME_MEDIS-'.$data['listdataheader']['ID'];
$pathfilename = $_SERVER['DOCUMENT_ROOT'].'SIKBREC/public/tmp/'.$fileName.'.pdf';
//$pdf->Output('F',$pathfilename,true);
//$pdf->Output(__DIR__.'../../../'.$pathfilename, 'F');
//var_dump($_SERVER['DOCUMENT_ROOT']);exit;
$pdf->Output($pathfilename, 'F');