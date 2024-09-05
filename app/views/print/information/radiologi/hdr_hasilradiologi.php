<?php
$GLOBALS['header'] = $data['listdataheader'];

class PDF extends Tcpdf {
    function Header() {
        
    	$this->setFont('','',9);
        // $this->Image('http://chart.googleapis.com/chart?cht=p3&chd=t:60,40&chs=250x100&chl=Hello|World', 20, 5, 40, 0, 'PNG');
        $this->Image('../public/images/yarsi.png',15,8,50);
        $this->Ln(5);
        $this->Cell(125,4,'',0,0);
        $this->Cell(59 ,5,'Jl. Letjen Soeprapto kav XIII Cempaka Putih,',0,1);

        $this->Cell(125,4,'',0,0);
        $this->Cell(34 ,4,'Jakarta Pusat 10510',0,1);

        $this->Cell(125,4,'',0,0);
        $this->Cell(30 ,4,'Telp : 021 80618618 / 80618618 (Hunting).',0,1);

        $this->Cell(125,4,'',0,0);
        $this->Cell(34 ,4,'Fax  : 021 4243172',0,1);

        $this->Cell(125,4,'',0,0);
        $this->Cell(34 ,4,'www.rsyarsi.co.id',0,1);
        //Margin top
            
            //BR
            $this->Cell(0,4,'',0,1);

            $this->Cell(10,3,'',0,1);

            //Line 1
            $this->SetFont('','B',12);
            $this->Cell(5,7,'',0,0);
            $this->Cell(0,1,'RADIOLOGY RESULT','B',0,'C');

            $border = 0;
            $h = 6;


        $this->Cell(10,$h,'',0,1);
      $this->SetFont('','',10);
      //row 1 (left)-------------------
      $this->Cell(5,$h,'',$border,0);
      $this->Cell(25,$h,'Name',$border,0);
      $this->CellfitScale(70,$h,': '.$GLOBALS['header']['PATIENT_NAME'],$border,0);
      //row 1 (right)
      $this->Cell(25,$h,'No. Order',$border,0);
      $this->Cell(0,$h,': '.$GLOBALS['header']['WOID'] . ' / ' . $GLOBALS['header']['PATIENT_LOCATION'],$border,1);

      //row 2 (left)---------------------
      $this->Cell(5,$h,'',$border,0);
      $this->Cell(25,$h,'Medical Record',$border,0);
      $this->Cell(70,$h,': '.$GLOBALS['header']['MRN'],$border,0);
      //row 2 (right)
      $this->Cell(25,$h,'Accession No',$border,0);
      $this->Cell(0,$h,': '.$GLOBALS['header']['ACCESSION_NO'],$border,1);

      //row 3 (left)-----------------------------
      $this->Cell(5,$h,'',$border,0);
      $this->Cell(25,$h,'BirthDate ',$border,0);
      $this->Cell(20,$h,': '.date('d/m/Y', strtotime( $GLOBALS['header']['DateOfBirth'])),0,0);
      $this->Cell(15,$h,' ',$border,0);
      $this->Cell(35,$h,' ',$border,0);
      //row 3 (right)
      $this->Cell(25,$h,'Order Date',$border,0);
      $this->Cell(0,$h,': '.date('d/m/Y H:i:s', strtotime( $GLOBALS['header']['ORDER_DATE'])),$border,1);

      //row 4 (left)---------------------
      $this->Cell(5,$h,'',$border,0);
      $this->Cell(25,$h,'No. Register',$border,0);
      $this->Cell(70,$h,': '.$GLOBALS['header']['NOREGISTRASI'],$border,0);
      //row 4 (right)
      $this->Cell(25,$h,'Doctor',$border,0);
      $this->Cell(0,$h,': '.$GLOBALS['header']['NamaDokter'],$border,1);

      //blank

        //BR
        $this->Cell(5,$h,'',0,0);
        $this->Cell(0,$h,'','T',1);

        $this->Cell(10,$h,'',0,1);
        $this->Cell(10,$h,'',0,1);
    }
    function Footer() {
    	$datenowx = date('d/m/y      H:i');
        // Position at 1.5 cm from bottom
                        $this->SetTextColor(0,0,0);
            $this->SetY(-37);
        $this->SetFont('','U',8);
        $this->Cell(15,4,'',0,0);
        $this->Cell(10,4,'                                                                                                                                           Approved by Radiologist : dr. Tia Bonita Sp.Rad' ,0,1);
        $this->SetFont('','',8);
        $this->Cell(15,4,'',0,0);
        //$this->Cell(65,4,'Validated by :'.$GLOBALS['footer']['Validate_by'],0,0);
        $this->Cell(65,4,'Taken by Radiographer:',0,0);
        $this->Cell(55,4,'*(do not need sign)',0,0);
        $this->Cell(35,4,$datenowx,0,1);
        $this->Cell(15,4,'',0,0);
        $this->Cell(55,4,'Sri Mulyani,A.Md.Rad',0,0);
        //$this->Image('../public/images/footer2.png',175, 265, 30,'R');
        $this->Image('../public/images/LogoGabungCert.png',155,265, 43,'R');
        $this->Image('../public/images/footer_1.png', 0, 284, 210, 13);
    }
}

        //$GLOBALS['header'] = $data['data'][0];

        $pdf = new PDF('p','mm','A4');
        $pdf->SetAutoPageBreak(TRUE, 35);
         $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP+40, PDF_MARGIN_RIGHT);
        $pdf->AddPage();

        $border = 0;
        $h = 6;

     $pdf->setFont('','',10);
      $pdf->Cell(5,$h,'',$border,0);
      $pdf->Cell(25,$h,'Diagnose',$border,0);
      $pdf->Cell(3,$h,':',$border,0);
      //diagnosa
      $pdf->MultiCell(141,$h,$GLOBALS['header']['DIAGNOSIS'],$border,1);

       //row 6-------------------
      $pdf->Cell(5,$h,'',$border,0);
      $pdf->Cell(25,$h,'Examination ',$border,0);
      $pdf->Cell(3,$h,':',$border,0);
      //pemeriksaan
      $pdf->Cell(0,$h,$GLOBALS['header']['SCHEDULED_PROC_DESC'],$border,1);
      $pdf->Cell(0,0,'',$border,1);//br
      $pdf->Cell(33,$h,'',$border,0);
      $pdf->MultiCell(141,$h,$data['listdatadetail']['REPORT_TEXT'],$border,1);

      //Garis---
      $pdf->SetFont('','U',12);
      $pdf->Cell(33,$h,'',$border,0);
      $pdf->Cell(10,$h,'                                                                                                                      ',$border,0);
      
    //   new line

      $pdf->Cell(0,$h,'',$border,1);//br
      $pdf->setFont('','',10);

      $pdf->Cell(5,$h,'',$border,0);
      $pdf->Cell(25,$h,'',$border,0);
      $pdf->Cell(3,$h,'',$border,0);
      $pdf->MultiCell(141,$h,$data['listdatadetail']['CONCLUSION'],$border,1);

                   //QR CODE
    require_once("../App/library/phpqrcode/qrlib.php");
    $url = $data['uuid4'];
    $url_ext = "https://esigndocument.rsyarsi.co.id/".$url;
    QRcode::png($url_ext, $url .".png");

                //Garis---
                $gety = $pdf->getY();
               //$pdf->Line(15, $gety, 210-15, $gety);
               //QR Code
               $pdf->Image($url.".png", 25, $gety+10, 25, 25, "png");
//Hapus file qr code nya
unlink($url.".png");

       // $pdf->Output();

       $certificate = 'file://' . $_SERVER["DOCUMENT_ROOT"] . 'SIKBREC/public/server.crt';
        $key = 'file://' . $_SERVER["DOCUMENT_ROOT"] . 'SIKBREC/public/server.key';
        
        $info = array(
            'Name' => 'TCPDF',
            'Location' => 'Office',
            'Reason' => 'Testing TCPDF',
            'ContactInfo' => 'http://www.tcpdf.org',
        );
        
        $pdf->setSignature($certificate, $key, 'tcpdfdemo', '', 2, $info);


