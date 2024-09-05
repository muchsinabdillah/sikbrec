<?php
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

$pdf = new PDF('L', 'mm', 'A5');



$datereal = date('d-m-Y');
$pdf->SetTopMargin(15);
$pdf->AddPage();


//logo Yarsi
$pdf->Image(BASEURL . '/images/logo_bpjs-02.png', 15, 5, 55);
$pdf->Ln(0);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(65, 5, '', 0, 0);
$pdf->Cell(70, 5, 'SURAT RUJUK BALIK (PRB)', 0, 0);
$pdf->Cell(20, 5, 'No SRB. ', 0, 0);
$pdf->Cell(0, 5,  $data['listdata1']['NO_SRB'], 0, 1); 

$pdf->Cell(65, 5, '', 0, 0);
$pdf->Cell(70, 5, 'RSU YARSI JAKARTA', 0, 0);
$pdf->Cell(20, 5, 'Tanggal. ', 0, 0);
$pdf->Cell(0, 5,  date('d M Y'), 0, 1); 

$pdf->Cell(0, 5, '', 0, 1); //br

$border = 0;
$height = 5;

$pdf->SetFont('Arial', '', 10); 

$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(30, $height, 'Kepada Yth', $border, 0); 
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(75, $height,'', $border, 1);

$pdf->Cell(0, 5, '', 0, 1); //br

//line 1
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(105, $height, 'Mohon Pemeriksaan dan Penanganan Lebih Lanjut :', $border, 0); 
//------------------

//line 2
$marginmin = 0;
$pdf->Cell(30, $height, 'R/.', $border, 1);
foreach ($data['listdata2'] as $key){
$pdf->Cell(110, 5, '', 0, 0); //margin
$pdf->Cell(5, $height, $key['No'].'.', $border, 0);
$pdf->Cell(10, $height, $key['SIGNA1'].'x'.$key['SIGNA2'], $border, 0);
$pdf->CellFitScale(60, $height, $key['NAMA_OBAT'], $border, 0);
$pdf->Cell(5, $height, $key['QTY'], $border, 1);
$marginmin -= 5;
}
//------------------

$pdf->Cell(5, $marginmin, '', 0, 1); //margin
//line 2
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(30, $height, 'No. Kartu', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(75, $height, $data['listdata1']['NO_KARTU'], $border, 1);
//------------------

 
//line 3
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(30, $height, 'Nama Peserta', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(75, $height, $data['listdata1']['NAMA_PESERTA'].' ('. $data['listdata1']['Gender'].')', $border, 1);
//$pdf->Cell(10, $height, '('. $data['listdata1']['JENIS_KELAMIN'].')', $border, 1);
//$pdf->Cell(45, $height, '(MR. ' . $data['sep']['NO_MR'] . ')', $border, 0);
//------------------
  

//line 5
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(30, $height, 'Tgl. Lahir', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(75, $height, $data['listdata1']['TGL_LAHIR'], $border, 1); 
//------------------
 

//line 6
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(30, $height, 'Diagnosa ', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(75, $height, '', $border, 1);
//------------------
 
//line 7
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(30, $height, 'Program PRB', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(0, $height, $data['listdata1']['NAMA_PROGRAM_PRB'], $border, 1);
//------------------

//line 7
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(30, $height, 'Keterangan', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(0, $height, $data['listdata1']['KETERANGAN'], $border, 1);
//------------------

//line 7
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(60, $height, 'Saran Pengelolaan lanjutan di FKTP :', $border, 1);
$pdf->Cell(10, 5, '', 0, 0); //margin
$pdf->MultiCell(0, $height, $data['listdata1']['SARAN'], $border, 1);
//------------------

//line 8
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(0, 10, 'Demikian atas bantuannya, diucapkan terima kasih.', $border, 1); 
//------------------
 

$pdf->Cell(0, 2, '', 0, 1); //br

$pdf->SetFont('Arial', '', 9);
//line 11
$pdf->Cell(5, 4, '', 0, 0); //margin
$pdf->Cell(140, 4, '', $border, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30, 4, 'Mengetahui', $border, 1);
//------------------

$pdf->SetFont('Arial', '', 9);
//line 12
$pdf->Cell(5, 4, '', 0, 0); //margin
$pdf->Cell(140, 4, '', $border, 1);
//------------------

$pdf->Cell(0, 4, '', 0, 1); //br

$pdf->SetFont('Arial', 'U', 9);
//line 13
$pdf->Cell(5, 4, '', 0, 0); //margin
$pdf->Cell(140, 4, '', $border, 0);
//$pdf->Cell(30, 4, $data['listdata1']['NAMA_DOKTER'], $border, 1);
$pdf->Cell(30, 4, '___________', $border, 1);
//------------------

$pdf->SetFont('Arial', '', 8);
//line 14
$pdf->Cell(5, 4, '', 0, 0); //margin
$pdf->Cell(140, 4, 'Tgl Cetak '. date("d-m-Y H:i:s"), $border, 1);
//------------------





/*
$pdf->Cell(0,5,'',0,1);

$pdf->setFont('Arial','',10);
$pdf->Cell(8,5,'',0,0);
$pdf->Cell(60,5,'Pasien / Wali',0,0,'L');
$pdf->Cell(60,5,'Saksi',0,0,'L');
$pdf->Cell(60,5,'Recieved by',0,1,'L');
$pdf->setFont('Arial','B',10);
$pdf->Cell(8,5,'',0,0);
$pdf->Cell(60,5,'Patient / Family Patient',0,0,'L');
$pdf->Cell(60,5,'Witness',0,0,'L');
$pdf->Cell(60,5,'Petugas Admission/Staff',0,1,'L');
$pdf->Cell(0,20,'',0,1);

$pdf->setFont('Arial','',10);
$pdf->Cell(8,5,'',0,0);
$pdf->Cell(28,5,'TTD/Signature',0,0,'L');
$pdf->Cell(2,5,':',0,0,'L');
$pdf->Cell(30,5,' .....................',0,0,'L');
$pdf->Cell(28,5,'TTD/Signature',0,0,'L');
$pdf->Cell(2,5,':',0,0,'L');
$pdf->Cell(30,5,' .....................',0,0,'L');
$pdf->Cell(28,5,'TTD/Signature',0,0,'L');
$pdf->Cell(2,5,':',0,0,'L');
$pdf->Cell(30,5,' .....................',0,1,'L');
$pdf->Cell(8,5,'',0,0);
$pdf->Cell(28,5,'Nama/Name',0,0,'L');
$pdf->Cell(2,5,':',0,0,'L');
$pdf->Cell(30,5,' .....................',0,0,'L');
$pdf->Cell(28,5,'Nama/Name',0,0,'L');
$pdf->Cell(2,5,':',0,0,'L');
$pdf->Cell(30,5,' .....................',0,0,'L');
$pdf->Cell(28,5,'Nama/Name',0,0,'L');
$pdf->Cell(2,5,':',0,0,'L');
$pdf->Cell(30,5,' .....................',0,0,'L');
*/

//$pdf->Image($Foto,7,7,40);
//$pdf->Ln(5);


$pdf->Output();
