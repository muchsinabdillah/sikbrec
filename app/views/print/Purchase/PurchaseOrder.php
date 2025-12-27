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

        $this->setFont('Arial', 'B', 14);
        $this->Cell(0, 15, 'PURCHASE ORDER', 0, 1, 'C'); //end of line

        $this->Image('../public/images/logo.jpeg', 2, 14, 35);
        //var_dump($GLOBALS['header']);
        //line 1
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(90, 4, '', 0, 0);
        $this->Cell(30, 4, 'DATE', 0, 0);
        $this->SetFont('Arial', '', 8);
        $this->Cell(2, 4, ':', 0, 0);
        $this->Cell(0, 4, date('d F Y', strtotime($GLOBALS['header']['PurchaseDate'])), 0, 1);

        //line 2
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(90, 4, '', 0, 0);
        $this->Cell(30, 4, 'PAGE', 0, 0);
        $this->SetFont('Arial', '', 8);
        $this->Cell(2, 4, ':', 0, 0);
        $this->Cell(0, 4, $this->PageNo().' of {nb}', 0, 1);

        //line 3
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(90, 4, '', 0, 0);
        $this->Cell(30, 4, 'PO NUMBER', 0, 0);
        $this->SetFont('Arial', '', 8);
        $this->Cell(2, 4, ':', 0, 0);
        //$this->Cell(0, 4, '03/RSYRS-UMUM/PROC/VI/2022', 0, 1);
        $this->Cell(0, 4, $GLOBALS['header']['PurchaseCode'], 0, 1);

        //line 4
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(90, 4, '', 0, 0);
        $this->Cell(30, 4, 'PAYMENT TERM', 0, 0);
        $this->SetFont('Arial', '', 8);
        $this->Cell(2, 4, ':', 0, 0);
       // $this->Cell(0, 4, '14 Days After Goods & Invoiced are Received', 0, 1);
       $this->Cell(0, 4, "", 0, 1);

        //line 5
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(90, 4, '', 0, 0);
        $this->Cell(30, 4, 'INSTALLATION', 0, 0);
        $this->SetFont('Arial', '', 8);
        $this->Cell(2, 4, ':', 0, 0);
        $this->Cell(0, 4, '', 0, 1);

        //line 6
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(90, 4, '', 0, 0);
        $this->Cell(30, 4, 'DELIVERY DATE', 0, 0);
        $this->SetFont('Arial', '', 8);
        $this->Cell(2, 4, ':', 0, 0);
        $this->Cell(0, 4, '1 - 2 DAYS', 0, 1);

        //line 7
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(90, 4, '', 0, 0);
        $this->Cell(30, 4, 'SHIPPING TERM', 0, 0);
        $this->SetFont('Arial', '', 8);
        $this->Cell(2, 4, ':', 0, 0);
        $this->Cell(0, 4, '', 0, 1);

        $this->Ln(-20);
        // cell(widht, height, text, border, end line , [ALIGN] )

        // cell(widht, height, text, border, end line , [ALIGN] )
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 4, 'JL. Angkasa No. 19, Blubuk, Losari, Brebes - 52255.', 0, 1); 
        $this->Cell(0, 4, 'Call Center : 0811-1901-1119', 0, 1);

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

$pdf->SetFont('Arial', '', 8);
$height = 4;
//ROW 1
$pdf->Cell(70, $height, 'SHIPPING FROM :', 0, 0);
$pdf->Cell(60, $height, 'SHIPPING TO :', 0, 0);
$pdf->Cell(60, $height, 'BILLING TO :', 0, 1);

$pdf->SetFont('Arial', 'B', 8);
//ROW 2
$pdf->Cell(70, $height, $GLOBALS['header']['namasupplier'], 0, 0);//ISI SHIPPING FROM
$pdf->Cell(60, $height, 'KLINIK UTAMA BREBES EYE CENTER', 0, 0);//ISI SHIPPING TO
$pdf->CellFitScale(60, $height, 'CV. BREBES EYE CENTER - NPWP : 12.571.863.5-501.000', 0, 1);//ISI BILLING TO

// $pdf->Cell(130, $height, '', 0, 0);
// $pdf->Cell(13, $height, 'NPWP', 0, 0);
// $pdf->Cell(2, $height, ':', 0, 0);
// $pdf->SetFont('Arial', 'B', 8);
// $pdf->Cell(15, $height, '02.408.814.8-024.000', 0, 1);

// $pdf->SetFont('Arial', 'I', 8);
// //ROW 3
// $pdf->Cell(70, $height, '', 0, 0);//ISI SHIPPING FROM
// $pdf->Cell(60, $height, '', 0, 0);//ISI SHIPPING TO
// $pdf->Cell(15, $height, 'NPWP : ', 0, 0);
// $pdf->SetFont('Arial', 'B', 8);
// $pdf->Cell(20, $height, '02.408.814.8-024.000', 0, 1);//ISI BILLING TO

$x = $pdf->GetX();
$y = $pdf->GetY();
$push_right = 0;

$pdf->SetFont('Arial', 'I', 8);
//ROW 4
//$pdf->Ln(-4);
$pdf->MultiCell(60, $height, $GLOBALS['header']['Address'], 0);//ISI ALAMAT SHIPPING FROM

$pdf->SetXY($x+70, $y);

//$pdf->Ln(-8);
//$pdf->Cell(70, $height, '', 1, 0);
$pdf->MultiCell(55, $height, 'JL. Angkasa No. 19, Blubuk, Losari, Brebes - 52255.', 0);//ISI ALAMAT SHIPPING TO


$pdf->SetXY($x+130, $y);

// $pdf->Cell(13, $height, 'NPWP', 0, 0);
// $pdf->Cell(2, $height, ':', 0, 0);
// $pdf->SetFont('Arial', 'B', 8);
// $pdf->Cell(15, $height, '02.408.814.8-024.000', 0, 1);


//$pdf->Ln(-12);
$pdf->MultiCell(60, $height, 'JL. Angkasa No. 19, Blubuk, Losari, Brebes - 52255.', 0);//ISI ALAMAT BILLING TO

$pdf->SetFont('Arial', 'I', 6);
//ROW 5
$pdf->Cell(30, $height, 'PHONE', 0, 0);
$pdf->Cell(2, $height, ':', 0, 0);
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(38, $height, $GLOBALS['header']['PhoneSupplier'], 0, 0);
$pdf->SetFont('Arial', 'I', 6);
$pdf->Cell(23, $height, 'Contact Person', 0, 0);
$pdf->Cell(2, $height, ':', 0, 0);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(35, $height, 'apt. SILFINA APRIYANTI, S.Farm', 0, 1);
$pdf->SetFont('Arial', 'I', 6);
//ROW 5
$pdf->Cell(30, $height, 'PIC', 0, 0);
$pdf->Cell(2, $height, ':', 0, 0);
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(38, $height, $GLOBALS['header']['ContactPerson'], 0, 0);
$pdf->SetFont('Arial', 'I', 6);
$pdf->Cell(23, $height, 'Contact Number', 0, 0);
$pdf->Cell(2, $height, ':', 0, 0);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(35, $height, '0896-9895-3711', 0, 1);

$pdf->SetFont('Arial', 'I', 8);
//ROW 6
$pdf->Cell(30, $height, 'CONTACT NUMBER', 0, 0);
$pdf->Cell(2, $height, ':', 0, 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(38, $height, $GLOBALS['header']['TlpKantor'], 0, 0);
$pdf->SetFont('Arial', 'I', 6);
$pdf->Cell(23, $height, 'SIPA', 0, 0);
$pdf->Cell(2, $height, ':', 0, 0);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(35, $height, 'NR33292409003638', 0, 1);



$pdf->Cell(0,5,'',0,1);

$height = $height + 3;

//HEADER
$pdf->Cell(5, $height, 'No', 1, 0,'C');
$pdf->Cell(20, $height, 'Product Code', 1, 0,'C');
$pdf->Cell(55, $height, 'Description', 1, 0,'C');
$pdf->Cell(21, $height, 'Packaging', 1, 0,'C');
$pdf->Cell(10, $height, 'Qty', 1, 0,'C');
$pdf->Cell(10, $height, 'UoM', 1, 0,'C');
$pdf->Cell(23, $height, 'Unit Price (IDR)', 1, 0,'C');
$pdf->Cell(18, $height, 'Discount %', 1, 0,'C');
$pdf->Cell(35, $height, 'Total Price (IDR)', 1, 1,'C');

$height = $height -2;
$no = 1;
$getVAR = 0;
foreach ($GLOBALS['detail'] as $row) {
//ISI
$pdf->Cell(5, $height, $no, 1, 0,'C');
$pdf->Cell(20, $height, $row['ProductCode'], 1, 0,'C');
$pdf->CellFitScale(55, $height, $row['ProductName'], 1,0,'C');
$pdf->Cell(21, $height, $row['ProductSatuan'], 1, 0,'C');
$pdf->Cell(10, $height, number_format($row['QtyPurchase'],0,",","."), 1, 0,'C');
$pdf->Cell(10, $height, $row['ProductSatuan'], 1, 0,'C');
$pdf->Cell(23, $height, number_format($row['Price'],0,",","."), 1, 0,'C');
$pdf->Cell(18, $height, number_format($row['DiscountProsen'],0,",","."), 1, 0,'C');
$pdf->Cell(35, $height, number_format($row['SubtotalPurchase'],0,",","."), 1, 1,'C');
$no++;
$getVAR += $row['TaxRpTTL'];
}

//FOOTER ISI
$pdf->Cell(121, $height, '', 0, 0,'C');
$pdf->Cell(41, $height, 'SUB TOTAL', 1, 0,'C');
$pdf->Cell(35, $height, number_format($GLOBALS['header']['SubtotalPurchase'],0,",","."), 1, 1,'C');

//$getVAR = $GLOBALS['header']['SubtotalPurchase'] * 1.1;

$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(45, $height, 'Purchase Requesition Reference', 0, 0,'L');
$pdf->Cell(2, $height, ':', 0, 0,'C');
$pdf->Cell(74, $height, $GLOBALS['header']['PurchaseReqCode'], 0, 0,'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(41, $height, 'VAR 11 %', 1, 0,'C');
$pdf->Cell(35, $height, number_format($getVAR,0,",","."), 1, 1,'C');

$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(45, $height, 'Quotation Reference', 0, 0,'L');
$pdf->Cell(2, $height, ':', 0, 0,'C');
$pdf->Cell(74, $height, '-', 0, 0,'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(41, $height, 'GRAND TOTAL', 1, 0,'C');
$pdf->Cell(35, $height, number_format($GLOBALS['header']['GrandtotalPurchase'],0,",","."), 1, 1,'C');


$pdf->Cell(0,3,'',0,1);
$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(0, $height, 'REMARKS :', 0, 1,'L');
// $pdf->Cell(0, $height, $GLOBALS['header']['Notes1'], 0, 1,'L');
$pdf->Cell(0, $height, '', 0, 1,'L');

$pdf->SetFont('Arial', 'IB', 8);
$pdf->Cell(121, $height, '', 0, 0,'C');
$pdf->Cell(12, $height+8, 'SAYS :', 'LTB', 0,'C');
$pdf->CellFitScale(64, $height+8, terbilang($GLOBALS['header']['GrandtotalPurchase']), 'RTB', 1,'C');

$pdf->Cell(5, 7, '', 0, 1);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(8, 7, '', 0, 0);
$pdf->Cell(25, 5, 'Prepared By :', 0, 0);
// $pdf->Cell(3, 26, '', 0, 1);
// $pdf->Cell(1, 0, '(...............................)', 0, 0);

$pdf->Cell(45, 7, '', 0, 0);
$pdf->Cell(30, 5, 'Knowing By :', 0, 0);

$pdf->Cell(37, 7, '', 0, 0);
$pdf->Cell(30, 5, 'Approved By (2) :', 0, 1);


$pdf->Cell(38, 20,'',  0, 0);//isi
$pdf->Cell(35, 20, '', 0, 0);
$pdf->Cell(38, 20,'', 0, 0);//isi
$pdf->Cell(35, 20, '', 0, 0);
$pdf->Cell(38, 20,'',  0, 1);//isi
$pdf->Cell(8, 4, '', 0, 0);
$pdf->Cell(25, 4, 'apt. Silfina Apriyanti, S.Farm', 0, 0);

$pdf->Cell(45, 4, '', 0, 0);
$pdf->Cell(25, 4, 'Uun Kurniasih, SKep, Ners', 0, 0);

$pdf->Cell(42, 4, '', 0, 0);
$pdf->Cell(25, 4, 'Heriyanto', 0, 1);

//----
$pdf->Cell(8, 5, '', 0, 0);
$pdf->Cell(25, 4, 'Apoteker', 0, 0);

$pdf->Cell(45, 4, '', 0, 0);
$pdf->Cell(25, 4, 'Operational Manager', 0, 0);

$pdf->Cell(42, 4, '', 0, 0);
$pdf->Cell(25, 4, 'CEO Klinik Brebes Eye Center', 0, 1);

//----
$pdf->Cell(8, 5, '', 0, 0);
$pdf->Cell(25, 4, 'Date : '.date('d/m/Y H:i:s', strtotime($GLOBALS['header']['DateApproved_1'])), 0, 0);

$pdf->Cell(45, 4, '', 0, 0);
$pdf->Cell(25, 4, 'Date :'.date('d/m/Y  H:i:s', strtotime($GLOBALS['header']['DateApproved_2'])), 0, 0);

$pdf->Cell(42, 4, '', 0, 0);
$pdf->Cell(25, 4, 'Date :'.date('d/m/Y  H:i:s', strtotime($GLOBALS['header']['DateApproved_3'])), 0, 1);



$pdf->Output();
