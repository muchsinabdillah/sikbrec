<?php
include("hdr_hasilradiologi.php");

$fileName = $data['GrupTransaksi'].'-'.$data['notrs'];
//$pathfilename = 'tmp/'.$fileName.'.pdf';
$pathfilename = $_SERVER['DOCUMENT_ROOT'].'SIKBREC/public/tmp/'.$fileName.'.pdf';
//$pdf->Output('F',$pathfilename,true);
$pdf->Output($pathfilename, 'F');