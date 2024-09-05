<?php
include("hdr_perkiraanbiayanonop.php");

$fileName = 'PERKIRAANBIAYANONOP-'.$data['listdata1']['ID'].'.pdf';
$pdf->Output($fileName, 'I');