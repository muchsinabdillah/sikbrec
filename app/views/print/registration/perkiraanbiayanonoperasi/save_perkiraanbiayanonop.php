<?php
include("hdr_perkiraanbiayanonop.php");

$fileName = 'PERKIRAANBIAYANONOP-'.$data['listdata1']['ID'];
$pathfilename = $_SERVER['DOCUMENT_ROOT'].'SIKBREC/public/tmp/'.$fileName.'.pdf';
//$pdf->Output('F',$pathfilename,true);
//$pdf->Output(__DIR__.'../../../'.$pathfilename, 'F');
//var_dump($_SERVER['DOCUMENT_ROOT']);exit;
$pdf->Output($pathfilename, 'F');