<?php
include("hdr_hakdankewajiban.php");

$fileName = 'HAKDANKEWAJIBAN-'.$data['listdata1']['ID'].'.pdf';
$pdf->Output($fileName, 'I');