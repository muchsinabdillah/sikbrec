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
$pdf->SetFont('Arial', 'B', 12);
// $pdf->Cell(6, 6, '', 0, 0);
$pdf->Cell(75, 4, 'PURCHASE REQUISITION FORM', 0, 5, 38);

$pdf->Cell(1, 6, '', 0, 0);
$pdf->SetFont('Arial', 'U', 20);
$pdf->Cell(65, 0, '', 1, 1);

$pdf->SetFont('Arial', 'I', 5);
$pdf->Cell(100, 5, ' ', 0, 0);
$pdf->Cell(10, 5, ' ', 0, 0);
$pdf->Cell(10, 5, ' ', 0, 0);
$pdf->Cell(10, 5, ' ', 0, 0);
$pdf->Cell(10, 5, ' ', 0, 0);
$pdf->Cell(3, 2, '', 0, 1);


$pdf->Cell(65, 0, '', 0, 1);

$pdf->SetFont('Arial', 'I', 5);
$pdf->Cell(3, 5, 'Complete the information and obtain approvals below. Forward the completed and approved form to the Apotek. Forms that are not approverd or incomplete will be returned to the applocant.', 0, 1);


//make a dummy empty cell as a vertical spacer
// $pdf->cell(189, 5, '', 0, 1); //end of line
$pdf->Cell(1, 5, '', 0, 0);

$pdf->setFont('Arial', 'B', 10);
$pdf->Cell(110, 10, 'APPLICANT INFORMATION', 0, 1, 0); //end of line
// var_dump($data['listdata1']['data'][0]);
//var_dump($data['listdata1']['data'][0]["Notes"]);
//HEADER--------------------------
//row 1 (left)-------------------
//(width,heigth,isi, border, tr)
$pdf->Cell(1, 5, '', 0, 0);
$pdf->setFont('Arial', '', 8);
$pdf->Cell(34, 5, 'NAME', 0, 0);
$pdf->Cell(3, 5, ':', 0, 0);
$pdf->Cell(3, 5, $data['listdata1']['data'][0]["NamaUserCreate"], 0, 0);

//row 1 (right)------------------
$pdf->Cell(60, 5, '', 0, 0);
$pdf->Cell(39, 5, ' REQUEST NUMBER', 0, 0);
$pdf->Cell(3, 5, ':', 0, 0);
$pdf->Cell(3, 5, $data['listdata1']['data'][0]["TransactionCode"], 0, 0);
//row 2 (left)------------------
$pdf->Cell(1, 5, '', 5, 1);
$pdf->Cell(35, 5, ' DEPARTMENT', 0, 0);
$pdf->Cell(3, 5, ':', 0, 0);
$pdf->Cell(3, 5, $data['listdata1']['data'][0]["NamaUnit"], 0, 0);

//row 2 (right)------------------
$pdf->Cell(60, 5, '', 0, 0);
$pdf->Cell(39, 5, ' REQUEST DATE', 0, 0);
$pdf->Cell(3, 5, ':', 0, 0);
$pdf->Cell(3, 5, date('d/m/Y H:i:s', strtotime($data['listdata1']['data'][0]["TransasctionDate"])), 0, 0);

//row 3 (left)------------------
$pdf->Cell(15, 5, '', 5, 1);
$pdf->Cell(35, 5, ' POSITION', 0, 0);
$pdf->Cell(3, 5, ':', 0, 0);
$pdf->Cell(3, 5, $data['listdata1']['data'][0]["NamaUnit"], 0, 0);
//row 3 (right)------------------
$pdf->Cell(60, 5, '', 0, 0);
$pdf->Cell(39, 5, ' REQUIRED DATE', 0, 0);
$pdf->Cell(3, 5, ':', 0, 0);
$pdf->Cell(3, 5, date('d/m/Y H:i:s', strtotime($data['listdata1']['data'][0]["DateCreateReal"])), 0, 1);

$pdf->Cell(3, 5, ' ', 0, 1);
$pdf->Cell(19, 5, 'NO', 1, 0, 'C', 0);  // empty cell with left,top, and right borders
$pdf->Cell(39, 5, 'Kode Brg', 1, 0, 'C', 0);
$pdf->Cell(59, 5, 'Item', 1, 0, 'C', 0);
$pdf->Cell(24, 5, 'QTY', 1, 0, 'C', 0);
$pdf->Cell(29, 5, 'Satuan', 1, 1, 'C', 0);

// pengulangan kolom
foreach ($data['listdata2'] as $row) {
    // var_dump($data['listdata2']);
    $pdf->CellFitScale(19, 5, ' ', 1, 0, 'C', 0);
    $pdf->CellFitScale(39, 5, $row['ID'], 1, 0, 'C', 0);
    $pdf->CellFitScale(59, 5, $row['ProductName'], 1, 0, 'C', 0);
    $pdf->CellFitScale(24, 5, $row['QtyPR'], 1, 0, 'C', 0);
    $pdf->CellFitScale(29, 5, $row['Satuan'], 1, 1, 'C', 0);
}

$pdf->CellFitScale(170, 5, ' Special Instuction : ', 1, 1, 'L', 0);
$pdf->CellFitScale(170, 20, $data['listdata1']['data'][0]["Notes"], 1, 1, 'L', 0);
$pdf->Cell(3, 5, ' ', 0, 1);

$pdf->setFont('Arial', 'B', 6);
$pdf->Cell(27, 5, 'Created By : ', 'LTR', 0, 'L', 0);
$pdf->Cell(39, 5, ' Reviewed By : ', 'LTR', 0, 'L', 0);
$pdf->Cell(34, 5, ' *Approved By : ', 'LTR', 0, 'L', 0);
$pdf->Cell(36, 5, ' **Knowing By : ', 'LTR', 0, 'L', 0);
$pdf->Cell(34, 5, ' ***Approved By : ', 'LTR', 1, 'L', 0);
// var_dump($data['listdata1']);

$pdf->CellFitScale(27, 20,  ' ', 'LBR', 0, 1, 0);
//$pdf->image($data['listdata1']['data'][0]["TTD_UserCreated"], 11, 120, -250); // (content, kanankiri, atasbawah, ukuran)
// $pdf->image($data['listdata1']['data'][0]["TTD_UserCreated"], 11, $pdf->getY(),35); // (content, kanankiri, atasbawah, ukuran)
$pdf->CellFitScale(39, 20, '  ', 'LBR', 0, 1, 0);
$pdf->CellFitScale(34, 20, ' ', 'LBR', 0, 1, 0);
// $pdf->image($data['listdata1']['data'][0]["TTD_UserApproved"], $pdf->getX()-30, $pdf->getY(),35);
$pdf->CellFitScale(36, 20, '  ', 'LBR', 0, 1, 0);
$pdf->CellFitScale(34, 20, '  ', 'LBR', 1, 1, 0);

$pdf->setFont('Arial', '', 6);
$pdf->CellFitScale(27, 5, 'Applicant :', 'LTR', 0, 'L', 0);
$pdf->CellFitScale(39, 5, ' Applicants Head Department :', 'LTR', 0, 'L', 0);
$pdf->CellFitScale(34, 5, ' Applicants Manager :', 'LTR', 0, 'L', 0);
$pdf->CellFitScale(36, 5, ' Financial Manager :', 'LTR', 0, 'L', 0);
$pdf->CellFitScale(34, 5, '  ', 'LTR', 1, 'L', 0);

$pdf->Cell(27, 5, $data['listdata1']['data'][0]["NamaUserCreate"], 'LBR', 0, 'L', 0);
$pdf->Cell(39, 5, ' ', 'LBR', 0, 'L', 0);
$pdf->Cell(34, 5, $data['listdata1']['data'][0]["namaUserApproved"], 'LBR', 0, 'L', 0);
$pdf->Cell(36, 5, ' ', 'LBR', 0, 'L', 0);
$pdf->Cell(34, 5, '  ', 'LBR', 1, 'L', 0);

$pdf->setFont('Arial', '', 5);
$pdf->Cell(27, 5, 'Date : ' . date('d/m/Y', strtotime($data['listdata1']['data'][0]["TransasctionDate"])), 1, 0, 'L', 0);
$pdf->Cell(39, 5, 'Date : ', 1, 0, 'L', 0);
$pdf->Cell(34, 5, 'Date : ' . date('d/m/Y', strtotime($data['listdata1']['data'][0]["DateApproved"])), 1, 0, 'L', 0);
$pdf->Cell(36, 5, 'Date : ', 1, 0, 'L', 0);
$pdf->Cell(34, 5, 'Date : ', 1, 1, 'L', 0);

$pdf->Cell(3, 5, ' ', 0, 1);
$pdf->setFont('Arial', 'B', 6);
$pdf->Cell(3, 5, 'Notes : ', 0, 1);

$pdf->setFont('Arial', 'I', 6);
$pdf->Cell(3, 2, ' *For request with estimate total value more than 1 million rupiah must be approved by applicants manager', 0, 1);
$pdf->Cell(3, 2, '**For request of item in the form of assets must be knowing by Financial Manager', 0, 1);
$pdf->Cell(3, 2, '***For request with value more than 15 million rupiah must be approved by Financial Manager/Related Director', 0, 0);

$pdf->Cell(3, 5, ' ', 0, 1);
$pdf->Cell(3, 5, ' ', 0, 1);
$pdf->Cell(3, 5, 'Filled by Financial Department : ', 0, 1);

$pdf->setFont('Arial', 'B', 6);
$pdf->Cell(30, 5, 'Received By : ', 'LTR', 0, 'L', 0);
$pdf->Cell(5, 5, ' ', 0, 0);
$pdf->Cell(50, 5, 'Approved By : ', 'LTR', 1, 'L', 0);

$pdf->Cell(30, 20, ' ', 'LBR', 0, 'L', 0);
$pdf->Cell(5, 5, ' ', 0, 0);
$pdf->Cell(50, 20, ' ', 'LBR', 1, 'L', 0);
$pdf->image($data['listdata1']['data'][0]["TTD_UserApproved"],  55, $pdf->getY()-20,35);


$pdf->setFont('Arial', 'I', 6);
$pdf->Cell(30, 3, ' Finance Staff ', 1, 0, 'C', 0);
$pdf->Cell(5, 5, ' ', 0, 0);
$pdf->Cell(50, 3, ' Financial Manager ', 1, 1, 'C', 0);

$pdf->setFont('Arial', '', 6);
$pdf->Cell(30, 5, ' Date : ', 1, 0, 'L', 0);
$pdf->Cell(5, 5, ' ', 0, 0);
$pdf->Cell(50, 5, ' Date : ' . date('d/m/Y', strtotime($data['listdata1']['data'][0]["DateApproved"])), 1, 1, 'L', 0);

$pdf->Cell(5, 5, ' ', 0, 1);
$pdf->setFont('Arial', 'I', 5);
$pdf->Cell(3, 2, 'Form FINANCE/PR01/2019', 0, 0);

$pdf->Cell(100, 5, ' ', 0, 0);
$pdf->Cell(10, 5, ' ', 0, 0);
$pdf->Cell(10, 5, ' ', 0, 0);
$pdf->Cell(10, 5, ' ', 0, 0);
$pdf->Cell(10, 5, ' ', 0, 0);
$pdf->Cell(3, 2, '-For Internal Use Only-', 0, 0);





$pdf->Output();
