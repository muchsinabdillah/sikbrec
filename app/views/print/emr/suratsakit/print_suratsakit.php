<?php
include("hdr_suratsakit.php");
$fileName = 'SURATKETERANGANSAKIT-' . 'Cetak' . '.pdf';
$pdf->Output($fileName, 'I');