<?php
include("hdr_sksehat.php");
$fileName = 'SURATKETERANGANSEHAT-' . 'Cetak' . '.pdf';
$pdf->Output($fileName, 'I');