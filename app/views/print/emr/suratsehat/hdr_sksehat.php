<?php
$GLOBALS['listdataheader'] = $data['listdataheader'];
$GLOBALS['listdatadetail'] = $data['listdatadetail'];

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
        $this->Cell(0, 1, 'SURAT KETERANGAN SEHAT', 0, 1, 'C');
        $this->SetFont('', 'I', 12);
        $this->Cell(5, 7, '', 0, 0);
        $this->Cell(0, 1, 'HEALTH NOTIFICATION LETTER', 0, 1, 'C');
        $this->Cell(0, 1, $GLOBALS['listdatadetail']['data']['NoSurat'], 0, 1, 'C');

        // $this->Cell(0, 1, 'Dengan ini menyatakan bahwa', 'B', 0, 'C');

        $border = 0;
        $h = 6;


        $this->Cell(10, $h, '', 0, 1);
        $this->SetFont('', '', 10);
        //row 1 (left)-------------------
        $this->Cell(5, $h, '', $border, 0);
        $this->Cell(25, $h, 'Dengan ini menyatakan bahwa', $border, 0);
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
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP + 40, PDF_MARGIN_RIGHT);
$pdf->AddPage();

$border = 0;
$h = 6;
$Datas['header']['Nama'] = $GLOBALS['listdataheader']['data']['PatientName'];
$Datas['header']['NoRM'] = $GLOBALS['listdataheader']['data']['NoMR'];
$Datas['header']['JenisKelamin'] = $GLOBALS['listdataheader']['data']['Gander'];
$Datas['header']['Umur'] = $GLOBALS['listdataheader']['data']['as_year'];
$Datas['header']['Pekerjaan'] =$GLOBALS['listdataheader']['data']['Pekerjaan'];
$Datas['header']['Alamat'] =$GLOBALS['listdataheader']['data']['Address'];
$Datas['header']['TinggiBadan'] =$GLOBALS['listdatadetail']['data']['Tinggi_badan'];
$Datas['header']['BeratBadan'] =$GLOBALS['listdatadetail']['data']['Berat_Badan'];
$Datas['header']['TekananDarah'] =$GLOBALS['listdatadetail']['data']['Tekanan_Darah'];
$Datas['header']['Virus'] =$GLOBALS['listdatadetail']['data']['Visus'];
$Datas['header']['Pendengaran'] =$GLOBALS['listdatadetail']['data']['Pendengaran'];
$Datas['header']['ButaWarna']=$GLOBALS['listdatadetail']['data']['ButaWarna'];
$Datas['header']['Laboratorium']=$GLOBALS['listdatadetail']['data']['HasilLaboratorium'];
$Datas['header']['hasil'] = $GLOBALS['listdatadetail']['data']['Keperluan'];
$Datas['header']['TglSkSehat'] = $GLOBALS['listdatadetail']['data']['Tanggal_Sekarang'];
$Datas['header']['ParafDokter'] = 'https://upload.wikimedia.org/wikipedia/commons/0/04/Tanda_tangan_bapak.png';
$Datas['header']['NamaDokter'] =  $GLOBALS['listdatadetail']['data']['Dokter'];



$pdf->setFont('', '', 10);

// $pdf->setFont('', '', 10);
// $pdf->Cell(5, $h, '', $border, 0);
// $pdf->Cell(25, $h, 'No RM', $border, 0);
// $pdf->Cell(3, $h, ':', $border, 0);
// $pdf->MultiCell(141, $h, $Datas['header']['NoRM'], $border, 1);

$pdf->Cell(5, $h, '', $border, 0);
$pdf->Cell(25, $h, 'Nama', $border, 0);
$pdf->Cell(3, $h, ':', $border, 0);
$pdf->Cell(0, $h, $Datas['header']['Nama'], $border, 1);

$pdf->Cell(5, $h, '', $border, 0);
$pdf->Cell(25, $h, 'No RM', $border, 0);
$pdf->Cell(3, $h, ':', $border, 0);
$pdf->Cell(0, $h, $Datas['header']['NoRM'], $border, 1);

$pdf->Cell(5, $h, '', $border, 0);
$pdf->Cell(25, $h, 'Jenis Kelamin', $border, 0);
$pdf->Cell(3, $h, ':', $border, 0);
$pdf->Cell(0, $h, $Datas['header']['JenisKelamin'], $border, 1);

$pdf->Cell(5, $h, '', $border, 0);
$pdf->Cell(25, $h, 'Umur', $border, 0);
$pdf->Cell(3, $h, ':', $border, 0);
$pdf->Cell(0, $h, $Datas['header']['Umur'], $border, 1);

$pdf->Cell(5, $h, '', $border, 0);
$pdf->Cell(25, $h, 'Pekerjaan', $border, 0);
$pdf->Cell(3, $h, ':', $border, 0);
$pdf->Cell(0, $h, $Datas['header']['Pekerjaan'], $border, 1);

$pdf->Cell(5, $h, '', $border, 0);
$pdf->Cell(25, $h, 'Alamat', $border, 0);
$pdf->Cell(3, $h, ':', $border, 0);
$pdf->Cell(0, $h, $Datas['header']['Alamat'], $border, 1);

$pdf->Cell(5, $h, '', $border, 0);
$pdf->Cell(25, $h, 'Tinggi Badan', $border, 0);
$pdf->Cell(3, $h, ':', $border, 0);
$pdf->Cell(15, $h, $Datas['header']['TinggiBadan'], $border, 0);
$pdf->Cell(25, $h, 'cm', $border, 0);
$pdf->Cell(5, $h, '', $border, 0);
$pdf->Cell(25, $h, 'Virus', $border, 0);
$pdf->Cell(3, $h, ':', $border, 0);
$pdf->Cell(0, $h, $Datas['header']['Virus'], $border, 1);

$pdf->Cell(5, $h, '', $border, 0);
$pdf->Cell(25, $h, 'Berat Badan', $border, 0);
$pdf->Cell(3, $h, ':', $border, 0);
$pdf->Cell(15, $h, $Datas['header']['BeratBadan'], $border, 0);
$pdf->Cell(25, $h, 'kg', $border, 0);
$pdf->Cell(5, $h, '', $border, 0);
$pdf->Cell(25, $h, 'Pendengaran', $border, 0);
$pdf->Cell(3, $h, ':', $border, 0);
$pdf->Cell(0, $h, $Datas['header']['Pendengaran'], $border, 1);

$pdf->Cell(5, $h, '', $border, 0);
$pdf->Cell(25, $h, 'Tekanan Darah', $border, 0);
$pdf->Cell(3, $h, ':', $border, 0);
$pdf->Cell(15, $h, $Datas['header']['TekananDarah'], $border, 0);
$pdf->Cell(25, $h, 'mmHg', $border, 0);
$pdf->Cell(5, $h, '', $border, 0);
$pdf->Cell(25, $h, 'Buta Warna', $border, 0);
$pdf->Cell(3, $h, ':', $border, 0);
$pdf->Cell(0, $h, $Datas['header']['ButaWarna'], $border, 1);

$pdf->Cell(5, $h, '', $border, 0);
$pdf->Cell(25, $h, 'Laboratorium', $border, 0);
$pdf->Cell(3, $h, ':', $border, 0);
$pdf->MultiCell(0, $h, $Datas['header']['Laboratorium'], $border, 1);

//br
$pdf->Cell(5, 15, '', $border, 1);
//br

$pdf->Cell(5, $h, '', $border, 0);
$pdf->Cell(25, $h, 'Berdasarkan hasil pemeriksaan dinyatakan dalam kondisi sehat jasmani dan rohani, sebagai syarat keperluan', $border, 0);
$pdf->Cell(3, $h, '', $border, 0);
$pdf->Cell(0, $h, '', $border, 1);

$pdf->Cell(5, $h, '', $border, 0);
$pdf->Cell(25, $h, '', $border, 0);
$pdf->Cell(3, $h, ':', $border, 0);
$pdf->MultiCell(0, $h, $Datas['header']['hasil'], $border, 1);

//br
$pdf->Cell(5, 15, '', $border, 1);
//br

$pdf->Cell(5, $h, '', $border, 0);
$pdf->Cell(25, $h, 'Demikian surat ini untuk dapat dipergunakan sebagaimana mestinya', $border, 0);
$pdf->Cell(3, $h, '', $border, 0);
$pdf->Cell(0, $h, '', $border, 1);


//br
$pdf->Cell(5, 5, '', $border, 1);
//br

$pdf->Cell(5, $h, '', $border, 0);
$pdf->Cell(25, $h, 'Jakarta,', $border, 0);
$pdf->Cell(3, $h, '', $border, 0);
$pdf->Cell(0, $h, $Datas['header']['TglSkSehat'], $border, 1);

//ttd
 
//ttd

//br
$pdf->Cell(0, 25, '', $border, 1);
//br

$pdf->Cell(5, $h, '', $border, 0);
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