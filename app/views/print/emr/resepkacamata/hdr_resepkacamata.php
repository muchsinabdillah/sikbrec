<?php
$GLOBALS['pasien'] = $data['listdataheader'];
$GLOBALS['resepkacamata'] = $data['listdatadetail'];
class PDF extends Tcpdf
{
    function Header()
    {

        $this->setFont('', '', 9);
        // $this->Image('http://chart.googleapis.com/chart?cht=p3&chd=t:60,40&chs=250x100&chl=Hello|World', 20, 5, 40, 0, 'PNG');
        $this->Image('../public/images/yarsi.png', 15, 8, 50);
        $this->Ln(5);
        // $this->Cell(125, 4, '', 0, 0);
        $this->Cell(100, 20, '', 0, 1);
        //Margin top

        //BR
        $this->Cell(0, 4, '', 0, 1);

        $this->Cell(10, 3, '', 0, 1);

        //Line 1
        $this->SetFont('', 'B', 12);
        $this->Cell(5, 7, '', 0, 0);
        $this->Cell(0, 1, 'RESEP KACA MATA', 0, 1, 'C');
        $this->SetFont('', 'I', 12);
        $this->Cell(5, 7, '', 0, 0);
        $this->Cell(0, 1, 'EYE GLASSES PRESCRIPTION', 0, 1, 'C');

        // $this->Cell(0, 1, 'Dengan ini menyatakan bahwa', 'B', 0, 'C');

        $border = 0;
        $h = 6;

        $this->Image('../public/images/FormResepKacaMata.png', 15, 50, 140);

        $this->Cell(10, $h, '', 0, 1);
        $this->SetFont('', 'B', 10);
        //row 1 (left)-------------------
        $this->Cell(150, $h, '', $border, 0);
        $this->Cell(5, $h, 'JAUH / DEKAT', $border, 1);
        $this->Cell(140, $h, '', $border, 0);
        $this->Cell(5, $h, '', $border, 1);
        $this->Cell(140, $h, '', $border, 0);
        $this->Cell(5, $h, '', $border, 1);
        $this->Cell(140, $h, '', $border, 0);
        $this->Cell(5, $h, 'KACAMATA PROGRES', $border, 1);
        $this->Cell(140, $h, '', $border, 0);
        $this->Cell(5, $h, 'KACAMATA BIFOCUS', $border, 1);
        $this->Cell(140, $h, '', $border, 0);
        $this->Cell(5, $h, 'KACAMATA BIASA', $border, 1);
    }
    function Footer()
    {
        // $datenowx = date('d/m/y      H:i');
        // // Position at 1.5 cm from bottom
        // $this->SetTextColor(0, 0, 0);
        // $this->SetY(-37);
        // $this->SetFont('', 'U', 8);
        // $this->Cell(15, 4, '', 0, 0);
        // $this->Cell(10, 4, '                                                                                                                                           Approved by Radiologist : dr. Tia Bonita Sp.Rad', 0, 1);
        // $this->SetFont('', '', 8);
        // $this->Cell(15, 4, '', 0, 0);
        // //$this->Cell(65,4,'Validated by :'.$GLOBALS['footer']['Validate_by'],0,0);
        // $this->Cell(65, 4, 'Taken by Radiographer:', 0, 0);
        // $this->Cell(55, 4, '*(do not need sign)', 0, 0);
        // $this->Cell(35, 4, $datenowx, 0, 1);
        // $this->Cell(15, 4, '', 0, 0);
        // $this->Cell(55, 4, 'Sri Mulyani,A.Md.Rad', 0, 0);
        // //$this->Image('../public/images/footer2.png',175, 265, 30,'R');
        // $this->Image('../public/images/LogoGabungCert.png', 155, 265, 43, 'R');
        // $this->Image('../public/images/footer_1.png', 0, 284, 210, 13);
    }
}

//$GLOBALS['header'] = $data['data'][0];

$pdf = new PDF('p', 'mm', 'A4');
$pdf->SetAutoPageBreak(TRUE, 35);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP + 70, PDF_MARGIN_RIGHT);
$pdf->AddPage();

$border = 0;
$h = 6;
$ht = 10;


$Datas['header']['Addisi'] = '-';
$Datas['header']['PupilDistance'] = '60 / 62 mm';
$Datas['header']['Nama'] = $GLOBALS['pasien']['data']['PatientName'];;
$Datas['header']['NoRM'] = '00-00-01';
$Datas['header']['JenisKelamin'] = 'Laki - Laki';
$Datas['header']['Umur'] = '27';
$Datas['header']['Alamat'] = 'JL PEDONGKELAN RT001/RW009, CILINCING, JAKARTA UTARA';
$Datas['header']['TglSkSehat'] = '29/08/2024';
$Datas['header']['ParafDokter'] = 'https://upload.wikimedia.org/wikipedia/commons/0/04/Tanda_tangan_bapak.png';
$Datas['header']['NamaDokter'] = 'dr. Andreas. Spk';



$pdf->setFont('', '', 10);
$pdf->Cell(3, $ht, ' ', 0, 0);
$pdf->Cell(15, $ht, ' ', 1, 0);
$pdf->Cell(40, $ht, 'Sferis', 1, 0, 'C');
$pdf->Cell(40, $ht, 'Cilinder', 1, 0, 'C');
$pdf->Cell(40, $ht, 'Axis', 1, 0, 'C');
$pdf->Cell(40, $ht, 'Prisma', 1, 1, 'C');
$pdf->Cell(3, $ht, ' ', 0, 0);
$pdf->Cell(15, $ht, 'OD', 1, 0, 'C');
$pdf->Cell(40, $ht, ' ', 1, 0);
$pdf->Cell(40, $ht, ' ', 1, 0);
$pdf->Cell(40, $ht, ' ', 1, 0);
$pdf->Cell(40, $ht, ' ', 1, 1);
$pdf->Cell(3, $ht, ' ', 0, 0);
$pdf->Cell(15, $ht, 'OS', 1, 0, 'C');
$pdf->Cell(40, $ht, ' ', 1, 0);
$pdf->Cell(40, $ht, ' ', 1, 0);
$pdf->Cell(40, $ht, ' ', 1, 0);
$pdf->Cell(40, $ht, ' ', 1, 1);

//br
$pdf->Cell(5, 5, '', $border, 1);
//br

$pdf->setFont('', '', 10);
$pdf->Cell(5, $ht, '', $border, 0);
$pdf->Cell(25, $ht, 'Addisi', $border, 0);
$pdf->Cell(3, $ht, ':', $border, 0);
$pdf->Cell(141, $ht, $Datas['header']['Addisi'], $border, 1);

$pdf->setFont('', '', 10);
$pdf->Cell(5, $ht, '', $border, 0);
$pdf->Cell(25, $ht, 'Pupil Distance', $border, 0);
$pdf->Cell(3, $ht, ':', $border, 0);
$pdf->Cell(141, $ht, $Datas['header']['PupilDistance'], $border, 1);

$pdf->setFont('', '', 10);
$pdf->Cell(5, $ht, '', $border, 0);
$pdf->Cell(25, $ht, 'Nama', $border, 0);
$pdf->Cell(3, $ht, ':', $border, 0);
$pdf->Cell(141, $ht, $Datas['header']['Nama'], $border, 1);

$pdf->setFont('', '', 10);
$pdf->Cell(5, $ht, '', $border, 0);
$pdf->Cell(25, $ht, 'Umur', $border, 0);
$pdf->Cell(3, $ht, ':', $border, 0);
$pdf->Cell(141, $ht, $Datas['header']['Umur'], $border, 1);

$pdf->setFont('', '', 10);
$pdf->Cell(5, $ht, '', $border, 0);
$pdf->Cell(25, $ht, 'Alamat', $border, 0);
$pdf->Cell(3, $ht, ':', $border, 0);
$pdf->Cell(141, $ht, $Datas['header']['Alamat'], $border, 1);

//br
$pdf->Cell(5, 5, '', $border, 1);
//br

$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->setFont('', '', 10);
$pdf->MultiCell(5, $ht, '', $border, 1);
$pdf->SetXY($x + 5, $y);
$pdf->MultiCell(5, $h, '', 1, 1);
$pdf->SetXY($x + 10, $y);
$pdf->setFont('', '', 10);
$pdf->MultiCell(2, $ht, '', $border, 1);
$pdf->SetXY($x + 12, $y);
$pdf->setFont('', '', 11);
$pdf->MultiCell(130, $ht, 'Kryptok', $border, 1);

$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->setFont('', '', 10);
$pdf->MultiCell(5, $ht, '', $border, 1);
$pdf->SetXY($x + 5, $y);
$pdf->MultiCell(5, $h, '', 1, 1);
$pdf->SetXY($x + 10, $y);
$pdf->setFont('', '', 10);
$pdf->MultiCell(2, $ht, '', $border, 1);
$pdf->SetXY($x + 12, $y);
$pdf->setFont('', '', 11);
$pdf->MultiCell(130, $ht, 'Flattop', $border, 1);

$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->setFont('', '', 10);
$pdf->MultiCell(5, $ht, '', $border, 1);
$pdf->SetXY($x + 5, $y);
$pdf->MultiCell(5, $h, '', 1, 1);
$pdf->SetXY($x + 10, $y);
$pdf->setFont('', '', 10);
$pdf->MultiCell(2, $ht, '', $border, 1);
$pdf->SetXY($x + 12, $y);
$pdf->setFont('', '', 11);
$pdf->MultiCell(130, $ht, 'Progresive', $border, 1);

//br
$pdf->Cell(5, 5, '', $border, 1);
//br

$pdf->Cell(130, $h, '', $border, 0);
$pdf->Cell(25, $h, 'Jakarta,', $border, 0);
$pdf->Cell(3, $h, '', $border, 0);
$pdf->Cell(0, $h, $Datas['header']['TglSkSehat'], $border, 1);

// ttd
$pdf->Image($Datas['header']['ParafDokter'], 150, 211, 50);
// ttd

//br
$pdf->Cell(0, 25, '', $border, 1);
//br

$pdf->Cell(130, $h, '', $border, 0);
$pdf->Cell(5, $h, '(', $border, 0);
$pdf->Cell(40, $h, $Datas['header']['NamaDokter'], $border, 0, 'C');
$pdf->Cell(5, $h, ')', $border, 1);

// $pdf->Output();

$certificate = 'file://' . $_SERVER["DOCUMENT_ROOT"] . 'EMR/public/server.crt';
$key = 'file://' . $_SERVER["DOCUMENT_ROOT"] . 'EMR/public/server.key';

$info = array(
    'Name' => 'TCPDF',
    'Location' => 'Office',
    'Reason' => 'Testing TCPDF',
    'ContactInfo' => 'http://www.tcpdf.org',
);

$pdf->setSignature($certificate, $key, 'tcpdfdemo', '', 2, $info);
