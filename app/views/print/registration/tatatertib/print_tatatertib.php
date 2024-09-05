<?php
include("hdr_tatatertib.php");

$fileName = 'TATATERTIB-'.$data['listdata1']['ID'].'.pdf';
$pdf->Output($fileName, 'I');