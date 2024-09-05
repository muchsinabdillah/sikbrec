<?php

date_default_timezone_set('Asia/Jakarta');
$date = Date('d/m/Y');
//$nama = $_SESSION['xhrFirstName'];
$GLOBALS['identitas_pasien'] = $data['hdr'];
$GLOBALS['footer'] = $data['footer'];

$nolab = $data['hdr']['NoLab'];
$pname = $data['hdr']['pname'];

// memanggil library FPDF
// intance object dan memberikan pengaturan halaman PDF

    class PDF extends TCPDF
    {

    // Page header
    function Header()
    {
      /*/Put the watermark
        $this->SetFont('','B',5);
        $this->SetTextColor(255, 201, 201);
        $no=1;
        while($no<200){
          $w = $no*10;
          $h = $no*5;
        $this->RotatedText($w,$h,'COPY FILE',0);
        $no++;
      }
      */
        $this->SetTextColor(0,0,0);

          $this->Image('../public/images/yarsi.png',10,8,50);
      $this->Ln(5);
      // cell(widht, height, text, border, end line , [ALIGN] )

      // set font to , bold, 14pt
      $this->setFont('','',9);

      // cell(widht, height, text, border, end line , [ALIGN] )
      $this->Cell(125,4,'',0,0);
      $this->Cell(59 ,5,'Jl. Letjen Soeprapto kav XIII Cempaka Putih,',0,1);//end of line

      $this->Cell(125,4,'',0,0);
      $this->Cell(34 ,4,'Jakarta Pusat 10510',0,1);//end of line

      $this->Cell(125,4,'',0,0);
      $this->Cell(30 ,4,'Phone (021) 80618618',0,1);

      $this->Cell(125,4,'',0,0);
      $this->Cell(34 ,4,'Fax (021) 80618619',0,1);//end of line

      $this->Cell(125,4,'',0,0);
      $this->Cell(34 ,4,'www.rsyarsi.co.id',0,1);//end of line


      //Line 1
       $this->Cell(0,4,'',0,1);
      $this->SetFont('','B',12);
      $this->Cell(15,4,'',0,0);
      $this->Cell(160,2,'LABORATORY RESULT','',1,'C');

      //BR
      // $this->Cell(0,4,'',0,1);

      // //Garis---
      // $this->SetFont('','U',12);
      // $this->Cell(15,4,'',0,0);
      // $this->Cell(10,1,'                                                                                                                                          ',0,0);


      $this->SetFont('','',10);
      //row 1 (left)-------------------
      $this->Cell(15,5,'',0,0);
      $this->Cell(10,5,'Name',0,0);
      $this->Cell(15,5,'',0,0);
      $this->CellFitScale(60,0,': '.$GLOBALS['identitas_pasien']['pname'],0,0);
      //row 1 (right)
      $this->Cell(10,5,'Request Lab',0,0);
      $this->Cell(15,5,'',0,0);
      $this->Cell(0,5,': '.$GLOBALS['identitas_pasien']['NOLIS'],0,1);

      //row 2 (left)---------------------
      
      $this->Cell(15,5,'',0,0);
      $this->Cell(10,5,'Medical Record',0,0);
      $this->Cell(15,5,'',0,0);
      $this->Cell(60,5,': '.$GLOBALS['identitas_pasien']['NoMR'],0,0);
      //row 2 (right)
      $this->Cell(10,5,'Doctor',0,0);
      $this->Cell(15,5,'',0,0);
      $this->Cell(0,5,': '.$GLOBALS['identitas_pasien']['clinician_name'],0,1);

      //row 3 (left)-----------------------------
      
      $this->Cell(15,5,'',0,0);
      $this->Cell(10,5,'BirthDate/Age',0,0);
      $this->Cell(15,5,'',0,0);
      $this->Cell(35,5,': '.$GLOBALS['identitas_pasien']['birth_dt'],0,0);
      $this->Cell(25,5,'('.$GLOBALS['identitas_pasien']['age'].'Y)',0,0);
      //row 3 (right)
      $this->Cell(10,5,'Location',0,0);
      $this->Cell(15,5,'',0,0);
      $this->CellFitScale(0,5,': '.$GLOBALS['identitas_pasien']['locname'],0,1);

      //row 4 (left)---------------------
      
      $this->Cell(15,5,'',0,0);
      $this->Cell(10,5,'Gender',0,0);
      $this->Cell(15,5,'',0,0);
      $this->Cell(60,5,': '.$GLOBALS['identitas_pasien']['gender'],0,0);
      //row 4 (right)
      $this->Cell(10,5,'Payer',0,0);
      $this->Cell(15,5,'',0,0);
      $this->CellFitScale(0,5,': '.$GLOBALS['identitas_pasien']['asuransi'],0,1);

      //$this->Cell(1,0,'',0,0);
      //$this->Cell(80,0,$tipepasien,0,1);

      //row 4 (left)---------------------
      
      $this->Cell(15,5,'',0,0);
      $this->Cell(10,5,'Addreess',0,0);
      $this->Cell(15,5,'',0,0);
      $this->CellFitScale(60,5,': '.$GLOBALS['identitas_pasien']['address'],0,0);
      //row 4 (rigth)--------------------
      //row 4 (right)
      $this->Cell(10,5,'Order Time',0,0);
      $this->Cell(15,5,'',0,0);
      $this->CellFitScale(0,5,': '.$GLOBALS['identitas_pasien']['request_dt'],0,1);

      //row 5 (left)---------------------
      
      $this->Cell(15,5,'',0,0);
      $this->Cell(10,5,'Phone / Email',0,0);
      $this->Cell(15,5,'',0,0);
      $this->Cell(60,5,': '.$GLOBALS['identitas_pasien']['nohp'],0,0);
      //row 5 (rigth)--------------------
      $this->Cell(10,5,'Page',0,0);
      $this->Cell(15,5,'',0,0);
      $this->Cell(0,5,': '.$this->PageNo().'/'.$this->getAliasNbPages(),0,1);
      //nama jaminan jika Anda

      //row 6 (left)---------------------
      
      $this->Cell(15,5,'',0,0);
      $this->Cell(10,5,'Identity Type',0,0);
      $this->Cell(15,5,'',0,0);
      if ($GLOBALS['identitas_pasien']['Tipe_Idcard'] == 'PASPORT'){
        $tipecard = 'PASSPORT';
      }else{
        $tipecard = $GLOBALS['identitas_pasien']['Tipe_Idcard'];
      }
      $this->CellFitScale(60,5,': '.$tipecard,0,0);
      //row 6 (rigth)--------------------
      //row 6 (right)
      $this->Cell(10,5,'Identity Number',0,0);
      $this->Cell(15,5,'',0,0);
      $this->CellFitScale(0,5,': '.$GLOBALS['identitas_pasien']['ID_Card_number'],0,1);

      //blank


      //Garis---
      // $this->SetFont('','U',12);
      // $this->Cell(15,4,'',0,0);
      // $this->Cell(10,1,'                                                                                                                                          ',0,0);

      //Header-------------------------
      $this->SetFont('','B',10);
      $this->Cell(15,4,'',0,0);
      $this->Cell(78,4,'LABORATORY TEST','TB',0);
      $this->Cell(18,4,'RESULT','TB',0,'C');
      $this->Cell(7,4,'','TB',0,'C');
      $this->Cell(10,4,'UNIT','TB',0,'C');
      $this->Cell(7,4,'','TB',0,'C');
      $this->Cell(40,4,'REFERENCE RANGE','TB',1,'C');
      //$this->Cell(26,4,'Keterangan',0,1,'R');
      // $this->SetFont('','U',10);
      // $this->Cell(15,4,'',0,0);
      // $this->Cell(10,0,'                                                                                                                                                                     ',0,1);
      $this->Cell(10,3,'',0,1);
      //#End Header----------------------
      
    }
    
    
    // Page footer
    function Footer()
    {
        $datenowx = date('d/m/y      H:i');
        // Position at 1.5 cm from bottom
                      $this->SetTextColor(0,0,0);
        $this->SetY(-37);
      $this->SetFont('','',8);
      //$this->Cell(5,4,'',0,0);
     //$this->Cell(10,4,'                                                                                                                                              Clinical Pathologist :'.$GLOBALS['footer']['Validate_by'],0,1);
     $this->Cell(0,4,'Clinical Pathologists : Dr. Syukrini Bahri SpPK, Dr. Endah Purnamasari SpPK, Dr. Dewi Lesthiowati SpPK(K), DR. Dr. Anggraini Iriani SpPK(K)','B',1);
      //$this->SetFont('','',8);
      $this->Cell(15,4,'',0,0);
      $this->Cell(0,4,'*This document has been electronically validated',0,1);
      $this->Cell(15,4,'',0,0);
      $this->Cell(35,4,'Received time',0,0);
      $this->Cell(2,4,':',0,0);
      $this->Cell(0,4,$GLOBALS['footer']['Validate_by'],0,0);
      // $this->Cell(65,4,'Validated by :'.$GLOBALS['footer']['Validate_by'],0,0);
      // $this->Cell(55,4,'*(do not need sign)',0,0);
      // $this->Cell(35,4,$datenowx,0,1);
      // $this->Cell(15,4,'',0,0);
      $this->Cell(55,4,'002/FRM/LAB/RSY/Rev0/II/2020',0,0);
      //$this->Image('../public/images/footer2.png',175, 265, 30,'R');
        $this->Image('../public/images/LogoGabungCert.png',155,265, 43,'R');
      $this->Image('../public/images/footer_1.png', 0, 284, 210, 13);
      // Position at 15 mm from bottom
      $this->SetY(-23);
//$this->Ln(22);
      }

      /**
 * Draws text within a box defined by width = w, height = h, and aligns
 * the text vertically within the box ($valign = M/B/T for middle, bottom, or top)
 * Also, aligns the text horizontally ($align = L/C/R/J for left, centered, right or justified)
 * drawTextBox uses drawRows
 *
 * This function is provided by TUFaT.com
 */

    }

      $pdf = new PDF('p','mm','A4');
      $pdf->SetAutoPageBreak(TRUE, 35);
      //$pdf->AliasNbPages();
       $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP+49, PDF_MARGIN_RIGHT);
       // $pdf->setPrintHeader(true);
      $pdf->AddPage();
/*
for($i=1;$i<=40;$i++)

                     */
                     $first = true;
                     $lastitem = '';
                     $ispcr = false;
                     foreach ($data['listdata'] as $row) {
                    $contentx = 15;
                    $contentxx = 0;
                     //var_dump($key['CHAPTER']);
                    
                        $contentx = 15;
                        $contentxx = 0;


                         $chapter = $row['CHAPTER'];

                        if ($lastitem==$chapter) {
                            $name = $row['NamaTes'];
                            $contentxx = 3;
                        } else {
                            //Judul--------------->>>>>
                        $pdf->SetFont('','B',10);
                        $pdf->Cell(15,5,'',0,0);
                        $pdf->CellFitScale(78,5,$chapter,0,1);
                        $name = $row['NamaTes'];
                        $contentxx = 3;
                        }

                        $lastitem = $chapter;
                        
                       /*/ if($row['DEPTH']==0 && $row['FLAG']==''){
                          if(strpos($row['CHAPTER'], 'MOLEKULAR') !== false){
                              $pdf->SetFont('','',10);
                              $pdf->Cell(15,6,'',0,0);
                              $pdf->CellFitScale(78,6,$row['CHAPTER'],0,1);
                              $name = $row['TESTNAME'];
                              $contentxx = 3;
                          }else{
                            $name = $row['TESTNAME'];
                          }
                          
                       // }else{
                       //   $name = $row['TESTNAME'];
                          /*
                          if($row['FLAG']==''){
                            $color = $pdf->SetTextColor(0,0,0);
                          }elseif($row['FLAG']=='N'){
                            $color = $pdf->SetTextColor(0,0,0);
                          }else{
                            $color = $pdf->SetTextColor(255,0,0);
                          }
                        }*/

                        /*
                        if ($row['DEPTH']==0){
                          $content = 15;
                        }elseif($row['DEPTH']==1){
                          $content = 18;
                        }elseif($row['DEPTH']==2){
                          $content = 21;
                        }elseif($row['DEPTH']==3){
                          $content = 24;
                        }
                        $calc = $content - $contentx + $contentxx;
                        $content = $content + $contentxx;
                        $x = 78-$calc;
                        */
                        //Content-----
                        if($row['FLAG']==''){
                            $color = $pdf->SetTextColor(0,0,0);
                          }elseif($row['FLAG']=='N'){
                            $color = $pdf->SetTextColor(0,0,0);
                          }else{
                            $color = $pdf->SetTextColor(214,0,0);
                          }
                        $color;

                        $pdf->SetFont('','',10);
                        $pdf->Cell(15,5,'',0,0);
                        $pdf->CellFitScale(78,5,$name,0,0);
                         $pdf->SetTextColor(0,0,0);
                        
                        if($row['HASIL'] == null){
                          $hasil = ' ';
                        }else{
                          $hasil = $row['HASIL'];
                        }

                        $count_str = strlen($row['HASIL']);

                        if($count_str > 15){
                       // $pdf->CellFitScale(50,5,$name,0,0);
                          $pdf->MultiCell(100,5,$hasil,0,1);
                        //netral kan lagi warnanya
                        //$pdf->SetTextColor(0,0,0);

                        }else{
                          $pdf->CellFitScale(18,5,$hasil,0,0,'C');
                        $pdf->Cell(7,5,'',0,0,'C');
                        //netral kan lagi warnanya
                        //$pdf->SetTextColor(0,0,0);
                       
                        $pdf->Cell(10,5,$row['SATUAN'],0,0,'C');
                        $pdf->Cell(7,5,'',0,0,'C');
                        //$pdf->Cell(40,5,$row['NILAI_RUJUKAN'],0,1,'C');
                         if (strlen($row['NILAI_RUJUKAN'])>=30){
                          $pdf->CellFitScale(0,5,$row['NILAI_RUJUKAN'],0,1,'C');
                          }else{
                              $pdf->Cell(40,5,$row['NILAI_RUJUKAN'],0,1,'C');
                          }

                        }

                        //KOMENTAR HASIL
                        //versi 1-----
                        
                        // if (trim($row['KOMENTAR_HASIL']) != '' && strpos($row['CHAPTER'], 'MOLEKULAR') !== false){
                        // $pdf->Cell(95,5,'',0,0,'C');
                        // $pdf->CellFitScale(0,5,'('.$row['KOMENTAR_HASIL'].')',0,1,'L');
                        // }
                        
                        //versi 2-----
                        if (trim($row['KOMENTAR_HASIL']) != '' && $row['pcr'] == '1'){
                        $pdf->Cell(95,5,'',0,0,'C');
                        $pdf->Cell(0,5,'('.$row['KOMENTAR_HASIL'].')',0,1,'L');
                        }

                        //versi 2-----
                        if ( $row['pcr'] == '1'){
                            $pdf->Cell(15,5,'',0,0,'C');
                            $pdf->SetFont('','',9);
                            if (strpos($name, 'Antigen') !== false){
                                $keterangan = 'Specimen collection is done by Swab Oropharyngeal';
                            }else{
                                $keterangan = 'Specimen collection is done by Swab Nasopharyngeal and Oropharyngeal';
                            }
                            $pdf->MultiCell(70,5,$keterangan,0,1);
                            }

                        if ($row['pcr'] == '1'){
                          $ispcr = true;
                        }
                    }
                        






                             

                        if ($ispcr){
                      $pdf->Cell(115,4,'',0,0);
                      $pdf->Cell(40,4,'Notes:',0,1);
                      $pdf->Cell(115,4,'',0,0);
                      $pdf->Cell(40,4,'This result is based on the conditions',0,1);
                      $pdf->Cell(115,4,'',0,0);
                      $pdf->Cell(40,4,'when taking the specimen.',0,1);
                      $pdf->Cell(115,4,'',0,0);
                      $pdf->Cell(40,4,'If you experience clinical symptoms or',0,1);
                      $pdf->Cell(115,4,'',0,0);
                      $pdf->Cell(40,4,'having contact with an infected patient,',0,1);
                      $pdf->Cell(115,4,'',0,0);
                      $pdf->Cell(40,4,'please contact the nearest doctor or',0,1);
                      $pdf->Cell(115,4,'',0,0);
                      $pdf->Cell(40,4,'health care.',0,1);
                      $pdf->Cell(115,4,'',0,0);
                      $pdf->Cell(40,4,'Re-examination/ check-up can be done',0,1);
                      $pdf->Cell(115,4,'',0,0);
                      $pdf->Cell(40,4,'based on doctor`s recommendation.',0,1);
                    //   $pdf->Cell(115,4,'',0,0);
                    //   $pdf->Cell(40,4,'Specimen collection is done',0,1);
                    //   $pdf->Cell(115,4,'',0,0);
                    //   $pdf->Cell(40,4,'by SWAB Nasopharyngeal and Oropharyngeal',0,1);
                      }

                     

                      $pdf->SetFont('','',10);
                      $pdf->Cell(15,6,'',0,0);
                      $pdf->Cell(10,2,'_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _',0,1);




                        $datenow2 = date('d/m/Y H.i.s');

                        // $q = "SELECT DISTINCT b.NOLIS,b.DT_Terima,b.DT_Validasi,a.pname,a.NoLab FROM LaboratoriumSQL.dbo.LIS_ORDER a
                        //       join LaboratoriumSQL.dbo.LIS_RESULT b on a.NoLab=b.NoLab
                        // Where a.NoLab='$nolab'";

                      //  $stmt = $conn->query( $q );
                  // while ( $row = $stmt->fetch( PDO::FETCH_ASSOC ) ){

                      $pdf->SetFont('','I',8);
                      $pdf->Cell(15,6,'',0,0);
                      $pdf->Cell(42,6,'Sampling Date :'.$data['tglsampling']['DT_Terima'],0,0);
                      $pdf->Cell(42,6,'Sampling Time :'.$data['tglsampling']['DT_Terima_jam'],0,0);
                      $pdf->Cell(42,6,'Release Date :'.$data['tglsampling']['DT_Validasi'],0,0);
                      $pdf->Cell(42,6,'Release Time :'.$data['tglsampling']['DT_Validasi_jam'],0,1);

                      $pdf->Cell(15,6,'',0,0);
                      $pdf->Cell(50,6,'',0,0);
                      $pdf->Cell(35,6,'',0,0);
                      $pdf->Cell(40,6,'Print Date :',0,0,'R');
                      $pdf->Cell(40,6,'Jakarta '.$datenow2,0,1);
                      //$pname= $row['pname'];
                      //$NoLab= $row['NoLab'];
                   // }
                   //$nolab = $_GET['nolab'];
//                    $nolab64 = base64_encode($nolab);
//                    $url = $nolab ;
//                    require_once("../App/library/phpqrcode/qrlib.php");
//              QRcode::png('https://validate.rsyarsi.co.id/validasi/'.$nolab64, $nolab .".png");

//                 //Garis---
//                 $gety = $pdf->getY();
//                //$pdf->Line(15, $gety, 210-15, $gety);
//                //QR Code
//                $pdf->Image($url.".png", 25, $gety+10, 25, 25, "png");
// //Hapus file qr code nya
// unlink($nolab.".png");

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
              $pdf->Cell(10,32,'',0,1);
              $pdf->Cell(8,6,'',0,0);
              $pdf->Cell(35,6,'Scan this for validate.',0,0);
//Hapus file qr code nya
unlink($url.".png");


//$pdf->Output();

$certificate = 'file://' . $_SERVER["DOCUMENT_ROOT"] . 'SIKBREC/public/server.crt';
  $key = 'file://' . $_SERVER["DOCUMENT_ROOT"] . 'SIKBREC/public/server.key';
  
  $info = array(
      'Name' => 'TCPDF',
      'Location' => 'Office',
      'Reason' => 'Testing TCPDF',
      'ContactInfo' => 'http://www.tcpdf.org',
  );
  
  $pdf->setSignature($certificate, $key, 'tcpdfdemo', '', 2, $info);