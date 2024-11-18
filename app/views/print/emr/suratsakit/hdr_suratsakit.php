<?php
//$GLOBALS['judul'] = $data['judul'];
$GLOBALS['listdataheader'] = $data['listdataheader'];
$GLOBALS['listdatadetail'] = $data['listdatadetail'];


// var_dump($GLOBALS['listdataheader']['data']['data']['PatientName'], ' ssssss');
// var_dump($GLOBALS['listdataheader'], 'dddddd');
// exit;
class PDF extends TCPDF
{
    // Page header
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
     $this->Cell(0, 1, 'SURAT KETERANGAN SAKIT', 0, 1, 'C');
     $this->SetFont('', 'I', 12);
     $this->Cell(5, 7, '', 0, 0);
     $this->Cell(0, 1, 'SICK NOTIFICATION LETTER', 0, 1, 'C');
     $this->Cell(0, 1, $GLOBALS['listdatadetail']['data']['NoSurat'], 0, 1, 'C');


        $this->Cell(0, 15, 'Yang bertanda tangan dibawah ini menerangkan bahwa :', '', 1, '');

        $this->setFont('', '', 14);
        $this->Cell(2, 10, '', 0, 0);
        $this->Cell(50, 10, 'Nama Pasien', 0, 0);
        $this->Cell(2, 10, ':', 0, 0);
        $this->Cell(80, 10, $GLOBALS['listdataheader']['data']['PatientName'], 0, 1);

        $this->setFont('', '', 14);
        $this->Cell(2, 10, '', 0, 0);
        $this->Cell(50, 10, 'Tanggal Lahir / Usia', 0, 0);
        $this->Cell(2, 10, ':', 0, 0);
        $this->Cell(80, 10, $GLOBALS['listdataheader']['data']['Date_of_birth'], 0, 1);

        $this->setFont('', '', 14);
        $this->Cell(2, 10, '', 0, 0);
        $this->Cell(50, 10, 'Pekerjaan', 0, 0);
        $this->Cell(2, 10, ':', 0, 0);
        $this->Cell(80, 10, $GLOBALS['listdataheader']['data']['Pekerjaan'], 0, 1);

        $this->setFont('', '', 14);
        $this->Cell(2, 10, '', 0, 0);
        $this->Cell(50, 10, 'Alamat', 0, 0);
        $this->Cell(2, 10, ':', 0, 0);
        $this->Cell(80, 10, $GLOBALS['listdataheader']['data']['Address'], 0, 1);

        $this->setFont('', '', 14);
        $this->Cell(0, 10, '', '', 1, '');

        $this->setFont('', '', 14);
        $this->Cell(0, 0, 'Berdasarkan hasil pemeriksaan yang telah dilakukan, pasien tersebut dalam keadaaan', '', 1, ''); 
        $this->setFont('', '', 14);
        $this->Cell(0, 0, 'Sakit, sehingga perlu beristirahat selama '.$GLOBALS['listdatadetail']['data']['totalhariistrahat'].' hari.', '', 1, '');

        $this->setFont('', '', 14);
        $this->Cell(0, 5, '', '', 1, '');

        $this->setFont('', '', 14);
        $this->Cell(2, 10, '', 0, 0);
        $this->Cell(50, 10, 'Tanggal Istirahat', 0, 0);
        $this->Cell(2, 10, ':', 0, 0);
        $this->Cell(80, 10, date('d-m-Y', strtotime($GLOBALS['listdatadetail']['data']['Tanggal_Istirahat'])), 0, 1);

        $this->setFont('', '', 14);
        $this->Cell(2, 10, '', 0, 0);
        $this->Cell(50, 10, 'Diagnosa', 0, 0);
        $this->Cell(2, 10, ':', 0, 0);
        $this->Cell(80, 10, $GLOBALS['listdatadetail']['data']['Diagnosa'], 0, 1);

        $this->setFont('', '', 14);
        $this->Cell(2, 10, '', 0, 0);
        $this->Cell(50, 10, 'Kontrol Kembali', 0, 0);
        $this->Cell(2, 10, ':', 0, 0);
        $this->Cell(80, 10, date('d-m-Y', strtotime($GLOBALS['listdatadetail']['data']['Tanggal_Kontrol'])), 0, 1);

        $this->setFont('', '', 14);
        $this->Cell(0, 10, '', '', 1, '');

        $this->setFont('', '', 14);
        $this->Cell(0, 0, 'Demikian Surat Keterangan ini diberikan untuk diketahui dan dipergunakan sebagai mana', '', 1, '');
        $this->setFont('', '', 14);
        $this->Cell(0, 0, 'mestinya.', '', 1, '');
        $this->setFont('', '', 14);
        $this->Cell(0, 5, '', '', 1, '');

        $this->setFont('', '', 14);
        $this->Cell(120, 0, '', 0, 0);
        $this->Cell(20, 10, 'Brebes, ', 0, 0); 
        $this->Cell(80, 10, date('d-m-Y', strtotime($GLOBALS['listdatadetail']['data']['Tanggal_Sekarang'])), 0, 1);

        $this->setFont('', '', 14);
        $this->Cell(120, 10, '', 0, 0);
        $this->Cell(50, 10, 'Dokter, ', 0, 0);
        $this->Cell(2, 10, '', 0, 0);
        $this->Cell(80, 10, '', 0, 1);

        $this->setFont('', '', 32);
        $this->Cell(180, 10, '', 0, 0);
        $this->Cell(50, 10, '', 0, 0);
        $this->Cell(2, 10, '', 0, 0);
        $this->Cell(80, 10, '', 0, 1);

        $this->setFont('', '', 32);
        $this->Cell(180, 10, '', 0, 0);
        $this->Cell(50, 10, '', 0, 0);
        $this->Cell(2, 10, '', 0, 0);
        $this->Cell(80, 10, '', 0, 1);
        
        $this->setFont('', '', 14);
        $this->Cell(120, 10, '', 0, 0);
        $this->Cell(50, 10, $GLOBALS['listdatadetail']['data']['Dokter'], 0, 0);
        $this->Cell(2, 10, '', 0, 0);
        $this->Cell(80, 10, '', 0, 1);
    }


    // /Page footer
    // public function Footer()
    // {
    //     $this->Image('../public/images/footer_1.png', 0, 284, 210, 13);
    //     // Position at 15 mm from bottom
    //     $this->SetY(-23);
    //     // Set font
    //     $this->SetFont('helvetica', 'I', 8);
    //     // Page number
    //     $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    // }
}
 
$pdf = new PDF('P', 'mm', 'A4', true, 'UTF-8', false);