<?php
include("hdr_skpemeriksaanmata.php");
$fileName = 'SURATKETERANGANMATA-' . 'Cetak' . '.pdf';
$pdf->Output($fileName, 'I');