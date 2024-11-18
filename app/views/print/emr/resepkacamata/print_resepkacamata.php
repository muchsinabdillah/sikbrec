<?php
include("hdr_resepkacamata.php");
$fileName = 'RESEPKACAMATA-' . 'Cetak' . '.pdf';
$pdf->Output($fileName, 'I');