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
        $this->setFont('', 'b', 14);
        $this->Cell(0, 25, 'SURAT KETERANGAN SAKIT', '', 1, 'C');

        $this->setFont('', '', 14);
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
        $this->Cell(0, 0, 'Berdasarkan hasil pemeriksaan yang telah dilakukan, pasien tersebut dalam keadaaan Sakit,', '', 1, '');
        $this->setFont('', '', 14);
        $this->Cell(0, 0, 'sehingga perlu beristirahat selama ...... (.......) hari', '', 1, '');

        $this->setFont('', '', 14);
        $this->Cell(0, 5, '', '', 1, '');

        $this->setFont('', '', 14);
        $this->Cell(2, 10, '', 0, 0);
        $this->Cell(50, 10, 'Tanggal Istirahat', 0, 0);
        $this->Cell(2, 10, ':', 0, 0);
        $this->Cell(80, 10, $GLOBALS['listdatadetail']['data']['Tanggal_Istirahat'], 0, 1);

        $this->setFont('', '', 14);
        $this->Cell(2, 10, '', 0, 0);
        $this->Cell(50, 10, 'Diagnosa', 0, 0);
        $this->Cell(2, 10, ':', 0, 0);
        $this->Cell(80, 10, $GLOBALS['listdatadetail']['data']['Diagnosa'], 0, 1);

        $this->setFont('', '', 14);
        $this->Cell(2, 10, '', 0, 0);
        $this->Cell(50, 10, 'Kontrol Kembali', 0, 0);
        $this->Cell(2, 10, ':', 0, 0);
        $this->Cell(80, 10, $GLOBALS['listdatadetail']['data']['Tanggal_Kontrol'], 0, 1);

        $this->setFont('', '', 14);
        $this->Cell(0, 10, '', '', 1, '');

        $this->setFont('', '', 14);
        $this->Cell(0, 0, 'Demikian Surat Keterangan ini diberikan untuk diketahui dan dipergunakan sebagai mana', '', 1, '');
        $this->setFont('', '', 14);
        $this->Cell(0, 0, 'mestinya.', '', 1, '');
        $this->setFont('', '', 14);
        $this->Cell(0, 5, '', '', 1, '');

        $this->setFont('', '', 14);
        $this->Cell(150, 0, '', 0, 0);
        $this->Cell(50, 10, 'Jakarta, ', 0, 0);
        $this->Cell(2, 10, ':', 0, 0);
        $this->Cell(80, 10, $GLOBALS['listdatadetail']['data']['Tanggal_Sekarang'], 0, 1);

        $this->setFont('', '', 14);
        $this->Cell(150, 10, '', 0, 0);
        $this->Cell(50, 10, 'Dokter, ', 0, 0);
        $this->Cell(2, 10, ':', 0, 0);
        $this->Cell(80, 10, $GLOBALS['listdatadetail']['data']['Dokter'], 0, 1);

        $this->setFont('', '', 32);
        $this->Cell(180, 10, '', 0, 0);
        $this->Cell(50, 10, 'TTD', 0, 0);
        $this->Cell(2, 10, '', 0, 0);
        $this->Cell(80, 10, '', 0, 1);

        $this->setFont('', '', 14);
        $this->Cell(180, 10, '', 0, 0);
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


$pdf = new PDF('L', 'mm', 'A4', true, 'UTF-8', false);