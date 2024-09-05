<?php
date_default_timezone_set('Asia/Jakarta');
$datenow = Date("d/m/y H:i:s");

$GLOBALS['header'] = $data['dataheader']['data'][0];
$GLOBALS['detail'] = $data['datadetail'];

//--------------------------------
function penyebut($nilai) {
    $nilai = abs($nilai);
    $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " ". $huruf[$nilai];
    } else if ($nilai <20) {
        $temp = penyebut($nilai - 10). " Belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai/10)." Puluh". penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai/100) . " Ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai/1000) . " Ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai/1000000) . " Juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai/1000000000) . " Milyar" . penyebut(fmod($nilai,1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai/1000000000000) . " Trilyun" . penyebut(fmod($nilai,1000000000000));
    }
    return $temp;
}
function terbilang($nilai) {
    if($nilai<0) {
        $hasil = "minus ". trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }
    return $hasil;
}
//--------------------------------


class PDF extends FPDF
{

    //Cell with horizontal scaling if text is too wide
    function CellFit($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '', $scale = false, $force = true)
    {
        //Get string width
        $str_width = $this->GetStringWidth($txt);

        //Calculate ratio to fit cell
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $ratio = ($w - $this->cMargin * 2) / $str_width;

        $fit = ($ratio < 1 || ($ratio > 1 && $force));
        if ($fit) {
            if ($scale) {
                //Calculate horizontal scaling
                $horiz_scale = $ratio * 100.0;
                //Set horizontal scaling
                $this->_out(sprintf('BT %.2F Tz ET', $horiz_scale));
            } else {
                //Calculate character spacing in points
                $char_space = ($w - $this->cMargin * 2 - $str_width) / max(strlen($txt) - 1, 1) * $this->k;
                //Set character spacing
                $this->_out(sprintf('BT %.2F Tc ET', $char_space));
            }
            //Override user alignment (since text will fill up cell)
            $align = '';
        }

        //Pass on to Cell method
        $this->Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);

        //Reset character spacing/horizontal scaling
        if ($fit)
            $this->_out('BT ' . ($scale ? '100 Tz' : '0 Tc') . ' ET');
    }

    //Cell with horizontal scaling only if necessary
    function CellFitScale($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
    {
        $this->CellFit($w, $h, $txt, $border, $ln, $align, $fill, $link, true, false);
    }

    //Cell with horizontal scaling always
    function CellFitScaleForce($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
    {
        $this->CellFit($w, $h, $txt, $border, $ln, $align, $fill, $link, true, true);
    }

    //Cell with character spacing only if necessary
    function CellFitSpace($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
    {
        $this->CellFit($w, $h, $txt, $border, $ln, $align, $fill, $link, false, false);
    }

    //Cell with character spacing always
    function CellFitSpaceForce($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
    {
        //Same as calling CellFit directly
        $this->CellFit($w, $h, $txt, $border, $ln, $align, $fill, $link, false, true);
    }

    // Page header
    function Header()
    {
 //end of line

        $this->Image('../public/images/yarsi.png', 10, 10, 55);
        //var_dump($GLOBALS['header']);

        $this->Ln(2);
        // cell(widht, height, text, border, end line , [ALIGN] )

        // cell(widht, height, text, border, end line , [ALIGN] )
        $this->SetFont('Arial', '', 9);
        $this->Cell(0, 4, 'JL. LETJEN SOEPRAPTO, KAV. 13, CEMPAKA PUTIH', 0, 1,'R');
        $this->Cell(0, 4, 'JAKARTA PUSAT 10510', 0, 1,'R');
        $this->Cell(0, 4, 'HUNTING : 021 8061 8618, 8061 8619', 0, 1,'R');

        
        $this->setFont('Arial', 'BU', 14);
        $this->Cell(0, 18, 'DELIVERY ORDER', 0, 1, 'C');

        $this->SetFont('Arial', '', 10);
        $this->Cell(10,0 , '', 0, 0);
        $this->Cell(30, 4, 'Nama Supplier', 0, 0);
        $this->Cell(2, 4, ':', 0, 0);
        $this->Cell(75, 4, $GLOBALS['header']['NamaSupplier'], 0, 0);
        $this->Cell(30, 4, 'Nomor', 0, 0);
        $this->Cell(2, 4, ':', 0, 0);
        $this->Cell(0, 4, $GLOBALS['header']['TransactionCode'], 0, 1);

        $this->SetFont('Arial', '', 10);
        $this->Cell(10,0 , '', 0, 0);
        $this->Cell(30, 4, 'Alamat', 0, 0);
        $this->Cell(2, 4, ':', 0, 0);
        $this->CellFitScale(75, 4, $GLOBALS['header']['Address'] == null ? '-' : $GLOBALS['header']['Address'] , 0, 0);
        $this->Cell(30, 4, 'Tanggal', 0, 0);
        $this->Cell(2, 4, ':', 0, 0);
        $this->Cell(0, 4, date('d/m/Y', strtotime($GLOBALS['header']['DeliveryOrderDate'])), 0, 1);

        $this->SetFont('Arial', '', 10);
        $this->Cell(10,0 , '', 0, 0);
        $this->Cell(30, 4, '', 0, 0);
        $this->Cell(2, 4, '', 0, 0);
        $this->Cell(75, 4, '', 0, 0);
        $this->Cell(30, 4, 'No PO', 0, 0);
        $this->Cell(2, 4, ':', 0, 0);
        $this->Cell(0, 4, $GLOBALS['header']['PurchaseOrderCode'], 0, 1);

    //     $h='4';
    //   //row 5 (rigth)--------------------
    //   $this->Cell(10,$h,'Halaman',0,0);
    //   $this->Cell(15,$h,'',0,0);
    //   $this->Cell(0,$h,': '.$this->PageNo().'/{nb}',0,1);
      

      //blank

      //BR
      $this->Cell(0,2,'',0,1);

    //   $this->Line(10, 57,138 , 57);

       $this->Cell(10,13,'',0,1);
      
    }



}



date_default_timezone_set('Asia/Jakarta');
//$datenow = Date("d/m/Y H:i:s");
$datenow = Utils::seCurrentDateTime();
$pdf = new PDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
//$pdf->SetAutoPageBreak(true,2);
//$datereal = date('d-m-Y');
$daterreal = Utils::datenowcreateNotFull();

$pdf->AddPage();

// $pdf->SetFont('Arial', '', 8);
 $height = 4;
// //ROW 1
// $pdf->Cell(70, $height, 'SHIPPING FROM :', 0, 0);
// $pdf->Cell(60, $height, 'SHIPPING TO :', 0, 0);
// $pdf->Cell(60, $height, 'BILLING TO :', 0, 1);

// $pdf->SetFont('Arial', 'B', 8);
// //ROW 2
// $pdf->Cell(70, $height, $GLOBALS['header']['namasupplier'], 0, 0);//ISI SHIPPING FROM
// $pdf->Cell(60, $height, 'RUMAH SAKIT YARSI', 0, 0);//ISI SHIPPING TO
// $pdf->CellFitScale(60, $height, 'PT. INNOCREATIVE - NPWP : 02.408.814.8-024.000', 0, 1);//ISI BILLING TO

// // $pdf->Cell(130, $height, '', 0, 0);
// // $pdf->Cell(13, $height, 'NPWP', 0, 0);
// // $pdf->Cell(2, $height, ':', 0, 0);
// // $pdf->SetFont('Arial', 'B', 8);
// // $pdf->Cell(15, $height, '02.408.814.8-024.000', 0, 1);

// // $pdf->SetFont('Arial', 'I', 8);
// // //ROW 3
// // $pdf->Cell(70, $height, '', 0, 0);//ISI SHIPPING FROM
// // $pdf->Cell(60, $height, '', 0, 0);//ISI SHIPPING TO
// // $pdf->Cell(15, $height, 'NPWP : ', 0, 0);
// // $pdf->SetFont('Arial', 'B', 8);
// // $pdf->Cell(20, $height, '02.408.814.8-024.000', 0, 1);//ISI BILLING TO

// $x = $pdf->GetX();
// $y = $pdf->GetY();
// $push_right = 0;

// $pdf->SetFont('Arial', 'I', 8);
// //ROW 4
// //$pdf->Ln(-4);
// $pdf->MultiCell(60, $height, $GLOBALS['header']['Address'], 0);//ISI ALAMAT SHIPPING FROM

// $pdf->SetXY($x+70, $y);

// //$pdf->Ln(-8);
// //$pdf->Cell(70, $height, '', 1, 0);
// $pdf->MultiCell(55, $height, 'RS YARSI (GUDANG PURCHASING BASEMENT) JL. LETJEN. SOEPRAPTO, KAV. 13, CEMPAKA PUTIH JAKARTA PUSAT 10510', 0);//ISI ALAMAT SHIPPING TO


// $pdf->SetXY($x+130, $y);

// // $pdf->Cell(13, $height, 'NPWP', 0, 0);
// // $pdf->Cell(2, $height, ':', 0, 0);
// // $pdf->SetFont('Arial', 'B', 8);
// // $pdf->Cell(15, $height, '02.408.814.8-024.000', 0, 1);


// //$pdf->Ln(-12);
// $pdf->MultiCell(60, $height, 'GEDUNG YARSI JL. LETJEND SUPRAPTO POSKO RS YARSI LT. 3 NO. 0 RT 000 RW. 000 CEMAPAKA PUTIH TIMUR CEMPAKA PUTIH JAKARTA PUSAT DKI JAKARTA', 0);//ISI ALAMAT BILLING TO

$pdf->SetFont('Arial', '', 10);
//ROW 5
$pdf->Cell(30, $height, 'Bersama ini kami kirimkan barang-barang sebagi berikut :', 0, 1);


 $pdf->Cell(0,5,'',0,1);

 $height = $height + 3;

// //HEADER
$pdf->Cell(6, $height, 'No', 1, 0,'C');
$pdf->Cell(25, $height, 'Kode Barang', 1, 0,'C');
$pdf->Cell(70, $height, 'Nama Barang', 1, 0,'C');
$pdf->Cell(21, $height, 'Satuan', 1, 0,'C');
$pdf->Cell(10, $height, 'Qty', 1, 0,'C');
$pdf->Cell(55, $height, 'Keterangan', 1, 1,'C');
// $pdf->Cell(23, $height, 'Unit Price (IDR)', 1, 0,'C');
// $pdf->Cell(18, $height, 'Discount %', 1, 0,'C');
// $pdf->Cell(35, $height, 'Total Price (IDR)', 1, 1,'C');

$height = $height -2;
$no = 1;
$getVAR = 0;
foreach ($GLOBALS['detail'] as $row) {
//ISI
$pdf->Cell(6, $height, $no, 1, 0,'C');
$pdf->Cell(25, $height, $row['ProductCode'], 1, 0,'C');
$pdf->CellFitScale(70, $height, $row['ProductName'], 1,0,'C');
$pdf->Cell(21, $height, $row['ProductSatuan'], 1, 0,'C');
$pdf->Cell(10, $height, number_format($row['QtyDelivery'],0,",","."), 1, 0,'C');
$pdf->Cell(55, $height, $row['ProductSatuan'], 1, 1,'C');
$no++;
$getVAR += $row['TaxRpTTL'];
}

// //FOOTER ISI
// $pdf->Cell(121, $height, '', 0, 0,'C');
// $pdf->Cell(41, $height, 'SUB TOTAL', 1, 0,'C');
// $pdf->Cell(35, $height, number_format($GLOBALS['header']['SubtotalPurchase'],0,",","."), 1, 1,'C');

// //$getVAR = $GLOBALS['header']['SubtotalPurchase'] * 1.1;

// $pdf->SetFont('Arial', 'I', 8);
// $pdf->Cell(45, $height, 'Purchase Requesition Reference', 0, 0,'L');
// $pdf->Cell(2, $height, ':', 0, 0,'C');
// $pdf->Cell(74, $height, $GLOBALS['header']['PurchaseReqCode'], 0, 0,'L');
// $pdf->SetFont('Arial', '', 8);
// $pdf->Cell(41, $height, 'VAR 11 %', 1, 0,'C');
// $pdf->Cell(35, $height, number_format($getVAR,0,",","."), 1, 1,'C');

// $pdf->SetFont('Arial', 'I', 8);
// $pdf->Cell(45, $height, 'Quotation Reference', 0, 0,'L');
// $pdf->Cell(2, $height, ':', 0, 0,'C');
// $pdf->Cell(74, $height, '-', 0, 0,'L');
// $pdf->SetFont('Arial', '', 8);
// $pdf->Cell(41, $height, 'GRAND TOTAL', 1, 0,'C');
// $pdf->Cell(35, $height, number_format($GLOBALS['header']['GrandtotalPurchase'],0,",","."), 1, 1,'C');


// $pdf->Cell(0,3,'',0,1);
// $pdf->SetFont('Arial', 'I', 8);
// $pdf->Cell(0, $height, 'REMARKS :', 0, 1,'L');
// $pdf->Cell(0, $height, $GLOBALS['header']['Notes1'], 0, 1,'L');

// $pdf->SetFont('Arial', 'IB', 8);
// $pdf->Cell(121, $height, '', 0, 0,'C');
// $pdf->Cell(12, $height+8, 'SAYS :', 'LTB', 0,'C');
// $pdf->CellFitScale(64, $height+8, terbilang($GLOBALS['header']['GrandtotalPurchase']), 'RTB', 1,'C');

$pdf->Cell(5, 7, '', 0, 1);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(8, 7, '', 0, 0);
$pdf->Cell(40, 5, 'Diterima', 'LTR', 1,'C');
// $pdf->Cell(3, 26, '', 0, 1);
// $pdf->Cell(1, 0, '(...............................)', 0, 0);

//$pdf->Cell(45, 7, '', 0, 0);
// $pdf->Cell(35, 5, 'Mengetahui', 'TR', 0,'C');

// //$pdf->Cell(37, 7, '', 0, 0);
// $pdf->Cell(35, 5, 'Dikirim', 'TR', 1,'C');


$pdf->Cell(8, 7, '', 0, 0);
$pdf->Cell(40, 20,$data['ttd']['FileDocument'] == null ? '' : $pdf->image($data['ttd']['FileDocument'], 18, $pdf->getY(), 35), 'LTR', 1);//isi
//$pdf->Cell(35, 20, '', 0, 0);
// $pdf->Cell(35, 20,$data['ttd']['FileDocument'] == null ? 's' : $pdf->image($data['ttd']['FileDocument'], 55, $pdf->getY(), -180), 'LRT', 0);//isi
// //$pdf->Cell(35, 20, '', 0, 0);
// $pdf->Cell(35, 20,$data['ttd']['FileDocument'] == null ? 's' : $pdf->image($data['ttd']['FileDocument'], 88, $pdf->getY(), -180), 'RTL', 1);//isi
 $pdf->Cell(8, 5, '', 0, 0);
$pdf->Cell(40, 5, $data['ttd']['username'], 1, 1,'C');
$pdf->Cell(8, 5, '', 0, 0);
$pdf->Cell(40, 5, date('d-m-Y H:i:s', strtotime($GLOBALS['header']['DeliveryOrderDate'])), 1, 1,'C');

//$pdf->Cell(45, 4, '', 0, 0);
// $pdf->Cell(35, 4, $data['ttd']['username'], 'B', 0,'C');

// //$pdf->Cell(42, 4, '', 0, 0);
// $pdf->Cell(35, 4, $data['ttd']['username'], 'LBR', 1,'C');

// //----
// $pdf->Cell(8, 5, '', 0, 0);
// $pdf->Cell(25, 4, 'Purchasing', 0, 0);

// $pdf->Cell(45, 4, '', 0, 0);
// $pdf->Cell(25, 4, 'Purchasing Manager', 0, 0);

// $pdf->Cell(42, 4, '', 0, 0);
// $pdf->Cell(25, 4, 'CEO of YARSI HOSPITAL', 0, 1);

// //----
// $pdf->Cell(8, 5, '', 0, 0);
// $pdf->Cell(25, 4, 'Date : '.date('d/m/Y', strtotime($GLOBALS['header']['DateApproved_1'])), 0, 0);

// $pdf->Cell(45, 4, '', 0, 0);
// $pdf->Cell(25, 4, 'Date :'.date('d/m/Y', strtotime($GLOBALS['header']['DateApproved_2'])), 0, 0);

// $pdf->Cell(42, 4, '', 0, 0);
// $pdf->Cell(25, 4, 'Date :'.date('d/m/Y', strtotime($GLOBALS['header']['DateApproved_3'])), 0, 1);



$pdf->Output();
