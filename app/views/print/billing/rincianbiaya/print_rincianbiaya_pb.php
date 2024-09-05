<?php
include("hdr_rincianbiaya_pb.php");

$fileName = 'RINCIANBIAYA_PB-'.$data['listdataheader']['PatientName'].'-'.$data['listdataheader']['NoRegistrasi'].'.pdf';
$pdf->Output($fileName, 'I');