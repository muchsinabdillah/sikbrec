<?php
date_default_timezone_set('Asia/Jakarta');
$datenow = Date("d/m/y H:i:s");

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
}



date_default_timezone_set('Asia/Jakarta');
//$datenow = Date("d/m/Y H:i:s");
$datenow = Utils::seCurrentDateTime();
$pdf = new PDF('P', 'mm', 'A4');
//$pdf->SetAutoPageBreak(true,2);
//$datereal = date('d-m-Y');
$daterreal = Utils::datenowcreateNotFull();

$pdf->AddPage();
$pdf->Image('../public/images/2yarsi.png', 10, 5, 38);
$pdf->Ln(5);
// cell(widht, height, text, border, end line , [ALIGN] )

// set font to arial, bold, 14pt
$pdf->setFont('Arial', '', 9);

// cell(widht, height, text, border, end line , [ALIGN] )
$pdf->Cell(110, 4, '', 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(75, 4, 'Jl. angkasa No.19, Dukuhkrikil', 0, 1, 'R');

//garis----
$pdf->SetFont('Arial', 'U', 10);
$pdf->Cell(6, 6, '', 0, 0);
$pdf->Cell(180, 0, '', 1, 1);

//make a dummy empty cell as a vertical spacer
$pdf->cell(189, 5, '', 0, 1); //end of line

$pdf->setFont('Arial', 'Bu', 18);
$pdf->Cell(0, 15, 'BUKTI PENGELUARAN KAS', 0, 1, 'C'); //end of line

// $pdf->Image('../public/images/bismillah.png', 80, 30, 50, 'C');
// $pdf->Ln(10);

$pdf->Cell(0, 3, '', 0, 1); //br
$pdf->setFont('Arial', '', 10);

$pdf->Cell(0, 3, '', 0, 1); //br
$pdf->setFont('Arial', '', 10);

//HEADER--------------------------
//row 1 (left)-------------------
//(width,heigth,isi, border, tr)
$pdf->Cell(5, 7, '', 0, 0);
$pdf->Cell(25, 5, 'Jumlah', 0, 0);
$pdf->Cell(3, 5, ':', 0, 0);
$pdf->Cell(65, 5, number_format($data['listdata1']['Nominal']), 0, 1);
//row 1 (right)
$pdf->Cell(26, 7, '', 0, 1);
$pdf->Cell(30, 8, '    Keperluan', 0, 0);
$pdf->Cell(3, 8, ':', 0, 0);
$pdf->Cell(10, 8, $data['listdata1']['Keterangan'], 0, 3);

$pdf->Cell(5, 7, '', 0, 5);
$pdf->Cell(5, 15, '', 0, 5);
$pdf->Cell(5, 7, '', 0, 10);
$pdf->Cell(30, 5, '                                                                                                          Brebes, ' . date('d/m/Y', strtotime($data['listdata1']['xTgl_Transaksi'])), 0, 0,1);
$pdf->Cell(3, 18, '', 0, 1);

$pdf->Cell(8, 7, '', 0, 0);
$pdf->Cell(25, 5, 'Mengetahui,', 0, 0);
// $pdf->Cell(3, 26, '', 0, 1);
// $pdf->Cell(1, 0, '(...............................)', 0, 0);

$pdf->Cell(43, 7, '', 0, 0);
$pdf->Cell(30, 5, 'Menyetujui,', 0, 0);

$pdf->Cell(37, 7, '', 0, 0);
$pdf->Cell(30, 5, 'Yang Menerima,', 0, 1);

$pdf->Cell(3, 26, '', 0, 1);
$pdf->Cell(1, 0, '(...............................)', 0, 0);

$pdf->Cell(55, 26, '', 0, 0);
$pdf->Cell(1, 0, '(...............................)', 0, 0);

$pdf->Cell(70, 26, '', 0, 0);
$pdf->Cell(1, 0, $data['listdata1']['Nama'], 0, 0);



$pdf->Output();
