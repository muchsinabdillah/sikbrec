<?php

date_default_timezone_set('Asia/Jakarta');
$date = Date('d/m/Y');
//$nama = $_SESSION['xhrFirstName'];
$GLOBALS['identitas_pasien'] = $data['hdr']['data'];
//$GLOBALS['footer'] = $data['footer'];
$GLOBALS['judul'] = $data['judul'];

//$nolab = $data['hdr']['NoLab'];
//$pname = $data['hdr']['pname'];

// memanggil library FPDF
// intance object dan memberikan pengaturan halaman PDF

function numberToRomanRepresentation($number)
{
    $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
    $returnValue = '';
    while ($number > 0) {
        foreach ($map as $roman => $int) {
            if ($number >= $int) {
                $number -= $int;
                $returnValue .= $roman;
                break;
            }
        }
    }
    return $returnValue;
}

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
        /*/Put the watermark
    $this->SetFont('Arial','B',5);
    $this->SetTextColor(255, 201, 201);
    $no=1;
    while($no<200){
      $w = $no*10;
      $h = $no*5;
    $this->RotatedText($w,$h,'COPY FILE',0);
    $no++;
}
  */
        $this->SetTextColor(0, 0, 0);

        $this->Image('../public/images/yarsi.png', 2, 2, 40);
        $this->Ln(-8);
        // cell(widht, height, text, border, end line , [ALIGN] )



        //Line 1
        $this->SetFont('Arial', '', 20);
        $this->Cell(0, 7, $GLOBALS['judul'], 0, 1, 'C');

        //BR
        $this->Cell(0, 4, '', 0, 1);

        $this->SetFont('Arial', '', 20);
        $this->Cell(0, 7, 'Rumah Sakit Yarsi', 0, 1, 'C');

        $this->SetFont('Arial', '', 9);
        $this->Cell(0, 3, 'Jl. Letjend Suprapto Cempaka Putih, ', 0, 1, 'C');

        $this->Cell(0, 2, '', 0, 1);

        $this->SetFont('Arial', '', 9);
        $this->Cell(0, 3, ' Jakarta 10510 Telp.021 4206674, 021 4206676, fax 021 4243171', 0, 1, 'C');

        $this->Line(10, 28, 138, 28);

        $this->Cell(0, 1, '', 0, 1);

        $this->Cell(0, 4, 'Apoteker :Maman Rusmana,S.Si,Apt, M.Farm', 0, 1, 'C');
        $this->Cell(0, 4, 'SIPA : 20/B.19/31.71.05/-1.779.3/e/2018', 0, 1, 'C');


        $this->Line(10, 38, 138, 38);

        $this->Cell(10, 2, '', 0, 1);
        $this->SetFont('Arial', '', 9);

        $h = 4;
        //row 1 (left)-------------------
        $this->Cell(10, $h, 'Dokter', 0, 0);
        $this->Cell(15, $h, '', 0, 0);
        $this->Cell(2, $h, ':', 0, 0);
        $this->CellFitScale(40, $h, $GLOBALS['identitas_pasien']['DokterOrder'] == null ? '-' : $GLOBALS['identitas_pasien']['DokterOrder'], 0, 0);
        //row 1 (right)
        $this->Cell(10, $h, 'Nama Pasien', 0, 0);
        $this->Cell(15, $h, '', 0, 0);
        $this->Cell(2, $h, ':', 0, 0);
        $this->CellFitScale(0, $h, $GLOBALS['identitas_pasien']['PatientName'] == null ? '-' : $GLOBALS['identitas_pasien']['PatientName'], 0, 1);

        //row 2 (left)---------------------
        $this->Cell(10, $h, 'Ruangan', 0, 0);
        $this->Cell(15, $h, '', 0, 0);
        $this->Cell(2, $h, ':', 0, 0);
        $this->CellFitScale(40, $h, $GLOBALS['identitas_pasien']['NamaUnit'] == null ? '-' : $GLOBALS['identitas_pasien']['NamaUnit'], 0, 0);
        //row 2 (right)
        $this->Cell(10, $h, 'No. RM', 0, 0);
        $this->Cell(15, $h, '', 0, 0);
        $this->Cell(0, $h, ': ' . $GLOBALS['identitas_pasien']['NoMR'], 0, 1);

        //row 3 (left)---------------------
        $this->Cell(10, $h, 'SIP Dokter', 0, 0);
        $this->Cell(15, $h, '', 0, 0);
        $this->Cell(2, $h, ':', 0, 0);
        $this->CellFitScale(40, $h, $GLOBALS['identitas_pasien']['NoSIP'] == null ? '-' : $GLOBALS['identitas_pasien']['NoSIP'], 0, 0);
        //row 2 (right)
        $this->Cell(10, $h, 'Tgl Lahir', 0, 0);
        $this->Cell(15, $h, '', 0, 0);
        $this->Cell(0, $h, ': ' . date('d/m/Y', strtotime($GLOBALS['identitas_pasien']['DOB'])), 0, 1);

        //row 4 (left)---------------------
        $this->Cell(10, $h, 'Alergi', 0, 0);
        $this->Cell(15, $h, '', 0, 0);
        $this->Cell(2, $h, ':', 0, 0);
        $this->Cell(40, $h, $GLOBALS['identitas_pasien']['Alergi'] == null ? '-' : $GLOBALS['identitas_pasien']['Alergi'], 0, 0);
        //row 2 (right)
        $this->Cell(10, $h, 'Berat Badan', 0, 0);
        $this->Cell(15, $h, '', 0, 0);
        $this->Cell(10, $h, ': ' . $GLOBALS['identitas_pasien']['BeratBadan'], 0, 0);
        $this->Cell(0, $h, 'kg', 0, 1);

        //$this->Cell(1,0,'',0,0);
        //$this->Cell(80,0,$tipepasien,0,1);

        //row 5 (left)---------------------
        $this->Cell(10, $h, 'Tgl Resep', 0, 0);
        $this->Cell(15, $h, '', 0, 0);
        $this->Cell(2, $h, ':', 0, 0);
        $this->Cell(40, $h, date('d/m/Y', strtotime($GLOBALS['identitas_pasien']['tglResep'])), 0, 0);


        //row 5 (rigth)--------------------
        $this->Cell(10, $h, 'Halaman', 0, 0);
        $this->Cell(15, $h, '', 0, 0);
        $this->Cell(0, $h, ': ' . $this->PageNo() . '/{nb}', 0, 1);


        //blank

        //BR
        $this->Cell(0, 2, '', 0, 1);

        $this->Line(10, 59, 138, 59);

        $this->Cell(10, 3, '', 0, 1);

        //   //Header-------------------------
        //   $this->SetFont('Arial','B',10);
        //   $this->Cell(78,4,'LABORATORY TEST',0,0);
        //   $this->Cell(18,4,'RESULT',0,0,'C');
        //   $this->Cell(7,4,'',0,0,'C');
        //   $this->Cell(10,4,'UNIT',0,0,'C');
        //   $this->Cell(7,4,'',0,0,'C');
        //   $this->Cell(40,4,'REFERENCE RANGE',0,1,'C');
        //   //$this->Cell(26,4,'Keterangan',0,1,'R');
        //   $this->SetFont('Arial','U',10);
        //   $this->Cell(15,4,'',0,0);
        //   $this->Cell(10,3,'',0,1);
        //   //#End Header----------------------

    }


    //     // Page footer
    //     function Footer()
    //     {
    //         $datenowx = date('d/m/y      H:i');
    //         // Position at 1.5 cm from bottom
    //                       $this->SetTextColor(0,0,0);
    //         $this->SetY(-37);
    //       $this->SetFont('Arial','U',8);
    //       $this->Cell(15,4,'',0,0);
    //      $this->Cell(10,4,'                                                                                                                                              Clinical Pathologist :'.$GLOBALS['footer']['Validate_by'],0,1);
    //       $this->SetFont('Arial','',8);
    //       $this->Cell(15,4,'',0,0);
    //       $this->Cell(65,4,'Validated by :'.$GLOBALS['footer']['Validate_by'],0,0);
    //       $this->Cell(55,4,'*(do not need sign)',0,0);
    //       $this->Cell(35,4,$datenowx,0,1);
    //       $this->Cell(15,4,'',0,0);
    //       $this->Cell(55,4,'002/FRM/LAB/RSY/Rev0/II/2020',0,0);
    //         //$this->Image('../../img/footer2.png',175, 265, 30,'R');
    //         //$this->Image('../../img/footer_1.png',1,283,208, 13);
    // //$this->Ln(22);
    //       }


}

$pdf = new PDF('p', 'mm', 'A5');
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->AddFont('brush script mt kursiv', '', 'brush script mt kursiv.php');

$pdf->Cell(0, 4, $data['hdr']['data']['Iter'], 0, 1);
$pdf->Cell(0, 4, $data['hdr']['data']['IterRealisasi'], 0, 1);

//NON RACIKAN
foreach ($data['listdata'] as $row) {

    if ($row['Racikan'] == '0') {

        $pdf->SetFont('brush script mt kursiv', '', 11);
        $pdf->Cell(6, 4, 'R!', 0, 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(0, 4, $row['NamaO_copy'], 0, 1);
        $pdf->Cell(6, 4, '', 0, 0);
        $pdf->Cell(0, 4, 'S. ' . $row['SignaNonRacik'] . ' ' . $row['Note1NonRacik'] . ' ' . $row['Note2NonRacik'], 0, 0);

        //var_dump($row['Qty']);
        if ($row['QtyReal'] == $row['Qty']) {
            $pdf->Cell(0, 4, 'Detur', 0, 1, 'R');
        } elseif ($row['QtyReal'] <> $row['Qty']) {
            if ($row['QtyReal'] == 0) {
                $pdf->Cell(0, 4, 'Nedet.', 0, 1, 'R');
            } elseif ($row['QtyReal'] > 0) {
                $pdf->Cell(0, 4, 'Det : ' . $row['QtyReal'], 0, 1, 'R');
            }
        }
        //BR
        $pdf->Cell(0, 1, '', 0, 1);
    }
}

//RACIKAN
$lastitem = '';
foreach ($data['listdata'] as $row) {

    if ($row['Racikan'] == '1') {

        $OrderTypeID = $row['OrderTypeID'];

        if ($lastitem == $OrderTypeID) {
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(6, 4, '', 0, 0);
            $pdf->Cell(0, 4, $row['NamaObat'] . ' ( Dosis: ' . $row['KekuatanDosis'] . ' ' . $row['Dosis'] . ' ; Qty: ' . $row['QtyReal'] . ')', 0, 1);
            $pdf->Cell(0, 1, '', 0, 1);

            //GET FOOTER RACIKAN
            foreach ($data['getFooterRacikan'] as $rowx) {
                if ($row['ID'] == $rowx['IDlastgroup'] && $row['OrderTypeID'] == $rowx['OrdertypeIDgroup']) {
                    $gety = $pdf->getY();
                    $pdf->Line(16, $gety, 120, $gety);
                    $pdf->Cell(0, 1, '', 0, 1);
                    $pdf->SetFont('Arial', 'I', 9);
                    $pdf->Cell(6, 4, '', 0, 0);
                    $pdf->Cell(0, 4, $row['Instruksi'] . ' No. ' . numberToRomanRepresentation($row['QtyOrderType']), 0, 1);
                    //$pdf->Cell(0,4,$row['MF'],0,1);

                    $pdf->Cell(6, 4, '', 0, 0);
                    $pdf->Cell(0, 4, 'S. ' . $row['Signa'] . ' ' . $row['Note1'] . ' ' . $row['Note2'], 0, 0);

                    $pdf->SetFont('Arial', '', 9);
                    if ($row['QtyReal'] == $row['Qty']) {
                        $pdf->Cell(0, 4, 'Detur.', 0, 1, 'R');
                    } elseif ($row['QtyReal'] <> $row['Qty']) {
                        if ($row['QtyReal'] == 0) {
                            $pdf->Cell(0, 4, 'Nedet.', 0, 1, 'R');
                        } elseif ($row['QtyReal'] > 0) {
                            $pdf->Cell(0, 4, 'Det : ' . $row['QtyReal'], 0, 1, 'R');
                        }
                    }
                    $pdf->Cell(0, 3, '', 0, 1);
                }
            }
        } else {
            //Judul--------------->>>>>
            $pdf->SetFont('brush script mt kursiv', '', 11);
            $pdf->Cell(6, 4, 'R!', 0, 0);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(0, 4, $row['ProductType'], 0, 1);

            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(6, 4, '', 0, 0);
            $pdf->Cell(0, 4, $row['NamaObat'] . ' ( Dosis: ' . $row['KekuatanDosis'] . ' ' . $row['Dosis'] . ' ; Qty: ' . $row['QtyReal'] . ')', 0, 1);
            $pdf->Cell(0, 1, '', 0, 1);
        }

        $lastitem = $OrderTypeID;

        //   $pdf->SetFont('brush script mt kursiv','',9);
        //   $pdf->Cell(6,4,'R!',0,0);
        //   $pdf->SetFont('Arial','',9);
        //   $pdf->Cell(0,4,$row['NamaO_copy'],0,1);
        //   $pdf->Cell(6,4,'',0,0);

        //   if ($row['QtyReal'] == $row['Qty']){
        //     $pdf->Cell(0,4,'Detur',0,1,'R');
        // }elseif($row['QtyReal'] <> $row['Qty']){
        //     if($row['QtyReal'] == 0){
        //         $pdf->Cell(0,4,'Nedet.',0,1,'R');
        //     }elseif($row['QtyReal'] > 0){
        //         $pdf->Cell(0,4,'Det : '.$row['QtyReal'],0,1,'R');
        //     }
        // }

        //   //BR
        //   $pdf->Cell(0,1,'',0,1);

    }
}


//BR
$pdf->Cell(0, 10, '', 0, 1);
$pdf->Cell(35, 4, 'By', 0, 0);
$pdf->Cell(2, 4, ':', 0, 0);
$pdf->Cell(0, 4, $data['hdr']['data']['Apoteker'], 0, 1);

$pdf->Cell(0, 1, '', 0, 1);
$pdf->Cell(35, 4, 'Summary', 0, 0);
$pdf->Cell(2, 4, ':', 0, 0);
$pdf->Cell(0, 4, $data['hdr']['data']['HasilReviewResep'], 0, 1);


//BR
$pdf->Cell(0, 10, '', 0, 1);

$pdf->Cell(85, 2, '', 0, 0);
$pdf->Cell(15, 2, 'Tgl Cetak', 0, 0);
$pdf->Cell(2, 2, ':', 0, 0);
$pdf->Cell(0, 2, date('d/m/Y', strtotime($GLOBALS['identitas_pasien']['tglResep'])), 0, 1);

$pdf->Cell(0, 2, '', 0, 1);


//BR
$pdf->Cell(100, 2, '', 0, 0);
$pdf->Cell(15, 2, 'PCC', 0, 1);


$pdf->Cell(0, 15, '', 0, 1);
$pdf->Cell(80, 2, '', 0, 0);
$pdf->Cell(15, 2, $data['hdr']['data']['Apoteker'], 0, 1);


$pdf->Cell(0, 4, '', 0, 1);

//SYARIAH
$pdf->Cell(0, 20, '', 0, 1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(0, 4, '"Dan apabila aku sakit, Dialah yang menyembuhkan aku"', 0, 1, 'C');
$pdf->Cell(0, 4, "(QS. Asy-Syu'ara, 26:80)", 0, 1, 'C');



//$fileName = $pname.' - '.$nolab.'.pdf';
$pdf->Output('', 'I');
