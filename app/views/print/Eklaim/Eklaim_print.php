<?php
$pdf = base64_decode($data['data']['data']);
header("Content-type:application/pdf");
header("Content-Disposition:inline;filename=".$data['nomor_sep'].".pdf");
echo $pdf;