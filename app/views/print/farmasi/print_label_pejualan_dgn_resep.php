<?php
//  date_default_timezone_set('Asia/Jakarta');
//                 $time=date('Y-m-d',time());
//  //$_SERVER['REMOTE_HOST'];
//      $ip =           getenv('HTTP_CLIENT_IP')?:
// getenv('HTTP_X_FORWARDED_FOR')?:
// getenv('HTTP_X_FORWARDED')?:
// getenv('HTTP_FORWARDED_FOR')?:
// getenv('HTTP_FORWARDED')?:
// getenv('REMOTE_ADDR');
// //$ip = '172.16.40.5';
//  //var_dump($ip);exit;
    

//     $nama ='adadad';
//     $nomr ='02-04-01';
//     $tgllahir ='2022-01-01';
//     $sex ='L';
//     $text = "MR :".$nomr. " | ".$tgllahir;
//      if($sex=="L"){
//       $jeniskelaminxxD="M";
//  }elseif($sex=="P"){
//       $jeniskelaminxxD="F";
//  }
//     // $NOLIS  = $_POST['NOLIS'];  
//     // $TUBENUMBERID  = $_POST['TUBENUMBERID'];
//     // $TUBENAME  = $_POST['TUBENAME'];
//     // $locid  = $_POST['locid'];
//     // $NOLIS  = $_POST['NOLIS'];
//     // $TESTCODE  = $_POST['TESTCODE'];

//      $NOLIS  = '1072935044';  
//     $TUBENUMBERID  = '20035044';
//     $TUBENAME  = 'POT PUTIH - Urin';
//     $locid  = '53';
//     $NOLIS  = '1072935044';
//     $TESTCODE  = '2';
    
//       //$jumlah_dipilih22 = count($NOLIS);
//       $jumlah_dipilih22 = 1;
//       $x = '"';
//       for($x1=0;$x1<$jumlah_dipilih22;$x1++){
        


//                     $judul=$TUBENUMBERID[$x1];
//                     $file = "file://C";
//                     $download_name = basename($file.$judul);
//                     $txtjudul=$judul.'.txt';
//                     $handle =fopen("C:\\\\KMN\\LogPrintLabel\\".$judul.".txt","w");
                    
//                     $nama = $x.$nama.$x; // nama
//                     $Teks = $x.$text.$x; // text
//                     $sex = $x.$jeniskelaminxxD.$x; // sex
//                     $TUBENUMBERx = $x.$TUBENUMBERID.$x; //ok
//                     $locidx = $x.$locid[$x1].$x; //ok
//                     $TUBENAMEx = $x.$TUBENAME[$x1].$x; //ok
//                     $TESTCODxE = $x.$TESTCODE.$x; // tes code
//                     $NOLISx = $x.$NOLIS[$x1].$x;
//                     $TUBENUMBER = $x.$TESTCODE[$x1].$x;
      


                    

// $isi = "
// [
// N
// OD
// q400
// Q224,24+0
// I8,A,001
// D10
// A49,3,0,3,1,1,N,".$nama."
// A60,27,0,2,1,1,N,".$Teks."
// A60,50,0,2,1,1,N,".$sex."
// B130,50,0,1,2,8,90,N,".$TUBENUMBERx."
// A350,50,5,3,1,1,N,".$TUBENUMBERx.   "
// A60,80,0,2,1,1,N,".$locidx."
// A60,145,0,2,1,1,N,".$TUBENAMEx.     "
// A60,170,0,1,1,1,N," .$TESTCODxE.  "
// A230,190,0,2,1,1,N,".$NOLISx.   "
// A50,195,0,1,1,1,N,".$TUBENUMBERx."
// P1
// ]
// ";
// 							    fwrite($handle, $isi);
// 							    fclose($handle);
//                   $judul2=$judul.'.txt';
//             $output = shell_exec('copy C:\\\\KMN\\LogPrintLabel\\'.$judul2.' \\\\'.$ip.'\\PRINTER_LABEL'); 
//             //var_dump($handle);
// 							    //header('Content-Type: text/plain');
// 							    //header('Content-Disposition: attachment; filename='.basename('C:\\\\xampp\\htdocs\\SIRYARSI\\DATASAYA\\'.$judul.'.txt'));
// 							     //header("Content-Disposition: attachment; filename=\"".basename($file)."\"");
// 							   // header('Expires: 0');
// 							    //header('Cache-Control: must-revalidate');
// 							    //header('Pragma: public');
// 							   // header('Content-Length: ' . filesize('C:\\\\xampp\\htdocs\\SIRYARSI\\DATASAYA\\'.$judul.'.txt'));
// 							   // readfile('C:\\\\xampp\\htdocs\\SIRYARSI\\DATASAYA\\'.$judul.'.txt');
// 							   //$output = shell_exec($judul.' \\\\172.16.5.29\\UCIN'); 
//                 	}
//                     //echo json_encode(["status" => "success", "data" => $array], 200);  
      
 
?>

<?php
   date_default_timezone_set('Asia/Jakarta');

   class PDF extends FPDF
    {

   //Cell with horizontal scaling if text is too wide
    function CellFit($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $scale=false, $force=true)
    {
        //Get string width
        if ($txt==''){
            $str_width = 1;
        }else{
            $str_width=$this->GetStringWidth($txt);   
        }

        //Calculate ratio to fit cell
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $ratio = ($w-$this->cMargin*2)/$str_width;

        $fit = ($ratio < 1 || ($ratio > 1 && $force));
        if ($fit)
        {
            if ($scale)
            {
                //Calculate horizontal scaling
                $horiz_scale=$ratio*100.0;
                //Set horizontal scaling
                $this->_out(sprintf('BT %.2F Tz ET',$horiz_scale));
            }
            else
            {
                //Calculate character spacing in points
                $char_space=($w-$this->cMargin*2-$str_width)/max(strlen($txt)-1,1)*$this->k;
                //Set character spacing
                $this->_out(sprintf('BT %.2F Tc ET',$char_space));
            }
            //Override user alignment (since text will fill up cell)
            $align='';
        }

        //Pass on to Cell method
        $this->Cell($w,$h,$txt,$border,$ln,$align,$fill,$link);

        //Reset character spacing/horizontal scaling
        if ($fit)
            $this->_out('BT '.($scale ? '100 Tz' : '0 Tc').' ET');
    }

    //Cell with horizontal scaling only if necessary
    function CellFitScale($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,true,false);
    }

    //Cell with horizontal scaling always
    function CellFitScaleForce($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,true,true);
    }

    //Cell with character spacing only if necessary
    function CellFitSpace($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,false);
    }

    //Cell with character spacing always
    function CellFitSpaceForce($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        //Same as calling CellFit directly
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,true);
    }

}

//A4 width : 219 mm
// default margin : 10mm each side
// writable horizontal : 219-(10*2)=189mm
$pdf = new PDF('L','mm',array(40,65));
      $pdf->SetAutoPageBreak(false);


$pdf->AddPage();

$pdf->Ln(-6);
$pdf->setFont('Arial','',7);

$pdf->Cell(-6,3,'',0,0);//margin
$pdf->Cell(0,3,'Rumah Sakit Yarsi Jakarta',0,1);
$pdf->Cell(-6,3,'',0,0);//margin
$pdf->Cell(0,3,'Jl. Letjend Suprapto Cempaka Putih, Jakarta 10510',0,1);
$gety = $pdf->getY();
$pdf->Line(4, $gety,60 , $gety);

//$pdf->Cell(0,3,'',0,1);
$pdf->setFont('Arial','',7);

$pdf->Cell(-6,3,'',0,0);//margin
$pdf->Cell(12,4,'Nama',0,0);
$pdf->Cell(2,4,':',0,0);
$pdf->CellFitScale(50,4,$data['NamaPasien'],0,1);
//$pdf->Cell(0,1,'',0,1);//br
$gety = $pdf->getY();
$pdf->Line(4, $gety,60 , $gety);

// $pdf->Cell(-6,3,'',0,0);//margin
// $pdf->Cell(12,4,'No MR',0,0);
// $pdf->Cell(2,4,':',0,0);
// $pdf->Cell(20,4,$data['NoMR'],0,0);

$pdf->Cell(-6,1,'',0,0);//margin
$pdf->Cell(12,4,'No Resep',0,0);
$pdf->Cell(2,4,':',0,0);
$pdf->Cell(20,4,$data['NoResep'],0,0);

$pdf->Cell(-5,3,'',0,0);//margin
$pdf->Cell(12,4,'DOB',0,0);
$pdf->Cell(2,4,':',0,0);
$pdf->Cell(116,4,date('d/m/Y', strtotime($data['Date_of_birth'])),0,1);

// $pdf->Cell(-6,1,'',0,0);//margin
// $pdf->Cell(12,4,'No Resep',0,0);
// $pdf->Cell(2,4,':',0,0);
// $pdf->Cell(20,4,$data['NoResep'],0,1);

$pdf->Cell(-6,1,'',0,0);//margin
$pdf->Cell(12,4,'Tgl Resep',0,0);
$pdf->Cell(2,4,':',0,0);
$pdf->Cell(20,4,date('d/m/Y', strtotime($data['tglResep'])),0,1);

// $pdf->Cell(-5,3,'',0,0);//margin
// $pdf->Cell(10,4,'No Urut',0,0);
// $pdf->Cell(2,4,':',0,0);
// $pdf->Cell(116,3,'',0,1);


$pdf->setFont('Arial','B',7);
$pdf->Cell(-6,1,'',0,0);//margin
$pdf->CellFitScale(56,4,$data['ProductName']. ' ('.$data['QtyRealisasi'].' '.$data['UnitSatuan'].')','TB',1,'C');
$pdf->setFont('Arial','',7);

$pdf->Cell(0,4,'',0,1);
// $pdf->Cell(-6,1,'',0,0);//margin
// $pdf->Cell(56,4,$data['Composisi'],0,1,'C');
$pdf->Cell(-6,1,'',0,0);//margin
$pdf->CellFitScale(56,4,$data['Signa'],0,1,'C');
// $pdf->Cell(-6,1,'',0,0);//margin
// $pdf->Cell(56,4,$data['Note2'],0,1,'C');
// $pdf->Cell(-6,1,'',0,0);//margin
 //$pdf->Cell(56,4,$data['Signa'].' - Expired Date :'.$data['ED'],0,1,'C');
 $pdf->Cell(-6,1,'',0,0);//margin
 $pdf->Cell(56,4,$data['SignaObat'],0,1,'C');



$pdf->Output();
?>
