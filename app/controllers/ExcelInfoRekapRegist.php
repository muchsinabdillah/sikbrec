<?php
class ExcelInfoRekapRegist extends Controller
{
    public function ExcelInfoRekapRegist2($Periode = "", $JenisPasien = "", $JenisRekap = "")
    {
        $data['Periode'] = $Periode;
        $data['JenisPasien'] = $JenisPasien;
        $data['JenisRekap'] = $JenisRekap;

        // Panggil class PHPExcel nya
        $excel = new PHPExcel();
        // Settingan awal fil excel
        $excel->getProperties()->setCreator('PMS GUT Developer')
            ->setLastModifiedBy('IDX Developer')
            ->setTitle("Data")
            ->setSubject("Siswa")
            ->setDescription("Laporan")
            ->setKeywords("Data");
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            ),
            'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
        );
        $style_col_prosen = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $style_col_center_bold = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $style_row_black_array = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            ),
            'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
        );
        $style_row_black = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $style_row_black_center = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $style_row_notblack_center = array(

            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $JobOrder =   $this->model('B_InformationRekapRegistrasi_Model')->getDataListRekap($data);
        $dataJO = json_decode(json_encode((object) $JobOrder), FALSE);
        $dataJOx = json_encode((object) $JobOrder);


        $excel->setActiveSheetIndex(0)->setCellValue('A1', "Montly Report"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:G1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1


        //Buat header tabel nya pada baris ke 4
        $excel->setActiveSheetIndex(0)->setCellValue('A5', "NAMA DOKTER"); // Set kolom A3 dengan tulisan "NO"

        $excel->setActiveSheetIndex(0)->setCellValue('B5', "01"); // Set kolom B3 dengan tulisan "NIS"

        $excel->setActiveSheetIndex(0)->setCellValue('C5', "02"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"

        $excel->setActiveSheetIndex(0)->setCellValue('D5', "03"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"

        $excel->setActiveSheetIndex(0)->setCellValue('E5', "04"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"

        $excel->setActiveSheetIndex(0)->setCellValue('F5', "05"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('G5', "06"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('H5', "07"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('I5', "08"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('J5', "09"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('K5', "10"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('L5', "11"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('M5', "12"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('N5', "TOTAL"); // Set kolom E3 dengan tulisan "ALAMAT"

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('I5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('J5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('K5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('L5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('M5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('N5')->applyFromArray($style_col);

        $data = "";

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 6; // Set baris pertama untuk isi tabel adalah baris ke 4
        // VAR_DUMP($JobOrder);
        // exit;
        foreach ($JobOrder as $data) { // Lakukan looping pada variabel siswa

            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $data['NamaDokter']);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data['01']);
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data['02']);
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data['03']);
            $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data['04']);
            $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data['05']);
            $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data['06']);
            $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data['07']);
            $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data['08']);
            $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data['09']);
            $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data['10']);
            $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $data['11']);
            $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $data['12']);
            $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, $data['total']);

            $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('N' . $numrow)->applyFromArray($style_row);

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping 
        }

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Montly Report");
        $excel->setActiveSheetIndex(0);

        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Montly Report.xls"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }

    public function ExcelInfoRekapRegist4($Periode = "", $JenisPasien = "", $JenisRekap = "")
    {
        $data['Periode'] = $Periode;
        $data['JenisPasien'] = $JenisPasien;
        $data['JenisRekap'] = $JenisRekap;

        // Panggil class PHPExcel nya
        $excel = new PHPExcel();
        // Settingan awal fil excel
        $excel->getProperties()->setCreator('PMS GUT Developer')
            ->setLastModifiedBy('IDX Developer')
            ->setTitle("Data")
            ->setSubject("Siswa")
            ->setDescription("Laporan")
            ->setKeywords("Data");
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            ),
            'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
        );
        $style_col_prosen = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $style_col_center_bold = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $style_row_black_array = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            ),
            'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
        );
        $style_row_black = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $style_row_black_center = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $style_row_notblack_center = array(

            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $JobOrder =   $this->model('B_InformationRekapRegistrasi_Model')->getDataListRekap($data);
        $dataJO = json_decode(json_encode((object) $JobOrder), FALSE);
        $dataJOx = json_encode((object) $JobOrder);


        $excel->setActiveSheetIndex(0)->setCellValue('A1', "Montly Report"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:G1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1


        //Buat header tabel nya pada baris ke 4
        $excel->setActiveSheetIndex(0)->setCellValue('A5', "Nama Rujukan"); // Set kolom A3 dengan tulisan "NO"

        $excel->setActiveSheetIndex(0)->setCellValue('B5', "NAMA UNIT"); // Set kolom B3 dengan tulisan "NIS"

        $excel->setActiveSheetIndex(0)->setCellValue('C5', "NAMA Dokter"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"

        $excel->setActiveSheetIndex(0)->setCellValue('D5', "01"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"

        $excel->setActiveSheetIndex(0)->setCellValue('E5', "02"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"

        $excel->setActiveSheetIndex(0)->setCellValue('F5', "03"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('G5', "04"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('H5', "05"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('I5', "06"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('J5', "07"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('K5', "08"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('L5', "09"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('M5', "10"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('N5', "11"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('O5', "12"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('P5', "TOTAL"); // Set kolom E3 dengan tulisan "ALAMAT"

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('I5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('J5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('K5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('L5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('M5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('N5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('O5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('P5')->applyFromArray($style_col);

        $data = "";

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 6; // Set baris pertama untuk isi tabel adalah baris ke 4
        // VAR_DUMP($JobOrder);
        // exit;
        foreach ($JobOrder as $data) { // Lakukan looping pada variabel siswa

            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $data['NamaRujukan']);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data['NamaUNIT']);
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data['NamaDokter']);
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data['01']);
            $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data['02']);
            $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data['03']);
            $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data['04']);
            $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data['05']);
            $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data['06']);
            $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data['07']);
            $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data['08']);
            $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $data['09']);
            $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $data['10']);
            $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, $data['11']);
            $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, $data['12']);
            $excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, $data['total']);

            $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('N' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('O' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('P' . $numrow)->applyFromArray($style_row);

            // $excel->getActiveSheet()->getStyle('AH' . $numrow)->applyFromArray($style_row);

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping 
        }

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Montly Report");
        $excel->setActiveSheetIndex(0);

        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Montly Report.xls"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }

    public function ExcelInfoRekapRegist3($Periode = "", $JenisPasien = "", $JenisRekap = "")
    {
        $data['Periode'] = $Periode;
        $data['JenisPasien'] = $JenisPasien;
        $data['JenisRekap'] = $JenisRekap;

        // Panggil class PHPExcel nya
        $excel = new PHPExcel();
        // Settingan awal fil excel
        $excel->getProperties()->setCreator('PMS GUT Developer')
            ->setLastModifiedBy('IDX Developer')
            ->setTitle("Data")
            ->setSubject("Siswa")
            ->setDescription("Laporan")
            ->setKeywords("Data");
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            ),
            'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
        );
        $style_col_prosen = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $style_col_center_bold = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $style_row_black_array = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            ),
            'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
        );
        $style_row_black = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $style_row_black_center = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $style_row_notblack_center = array(

            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $JobOrder =   $this->model('B_InformationRekapRegistrasi_Model')->getDataListRekap($data);
        $dataJO = json_decode(json_encode((object) $JobOrder), FALSE);
        $dataJOx = json_encode((object) $JobOrder);


        $excel->setActiveSheetIndex(0)->setCellValue('A1', "Montly Report"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:G1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1


        //Buat header tabel nya pada baris ke 4
        $excel->setActiveSheetIndex(0)->setCellValue('A5', "NAMA UNIT"); // Set kolom A3 dengan tulisan "NO"

        $excel->setActiveSheetIndex(0)->setCellValue('B5', "NAMA DOKTER"); // Set kolom B3 dengan tulisan "NIS"

        $excel->setActiveSheetIndex(0)->setCellValue('C5', "01"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"

        $excel->setActiveSheetIndex(0)->setCellValue('D5', "02"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"

        $excel->setActiveSheetIndex(0)->setCellValue('E5', "03"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"

        $excel->setActiveSheetIndex(0)->setCellValue('F5', "04"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('G5', "05"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('H5', "06"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('I5', "07"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('J5', "08"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('K5', "09"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('L5', "10"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('M5', "11"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('N5', "12"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('O5', "TOTAL"); // Set kolom E3 dengan tulisan "ALAMAT

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('I5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('J5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('K5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('L5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('M5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('N5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('O5')->applyFromArray($style_col);

        $data = "";

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 6; // Set baris pertama untuk isi tabel adalah baris ke 4
        // VAR_DUMP($JobOrder);
        // exit;
        foreach ($JobOrder as $data) { // Lakukan looping pada variabel siswa

            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $data['NamaUNIT']);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data['NamaDokter']);
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data['01']);
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data['02']);
            $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data['03']);
            $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data['04']);
            $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data['05']);
            $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data['06']);
            $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data['07']);
            $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data['08']);
            $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data['09']);
            $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $data['10']);
            $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $data['11']);
            $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, $data['12']);
            $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, $data['total']);

            $excel->getActiveSheet()->getStyle('A5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('G5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('H5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('I5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('J5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('K5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('L5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('M5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('N5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('O5')->applyFromArray($style_row);


            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping 
        }

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Montly Report");
        $excel->setActiveSheetIndex(0);

        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Montly Report.xls"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }

    public function ExcelInfoRekapRegist5($Periode = "", $JenisPasien = "", $JenisRekap = "")
    {
        $data['Periode'] = $Periode;
        $data['JenisPasien'] = $JenisPasien;
        $data['JenisRekap'] = $JenisRekap;

        // Panggil class PHPExcel nya
        $excel = new PHPExcel();
        // Settingan awal fil excel
        $excel->getProperties()->setCreator('PMS GUT Developer')
            ->setLastModifiedBy('IDX Developer')
            ->setTitle("Data")
            ->setSubject("Siswa")
            ->setDescription("Laporan")
            ->setKeywords("Data");
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            ),
            'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
        );
        $style_col_prosen = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $style_col_center_bold = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $style_row_black_array = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            ),
            'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
        );
        $style_row_black = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $style_row_black_center = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $style_row_notblack_center = array(

            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $JobOrder =   $this->model('B_InformationRekapRegistrasi_Model')->getDataListRekap($data);
        $dataJO = json_decode(json_encode((object) $JobOrder), FALSE);
        $dataJOx = json_encode((object) $JobOrder);


        $excel->setActiveSheetIndex(0)->setCellValue('A1', "Montly Report"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:G1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1


        //Buat header tabel nya pada baris ke 4
        $excel->setActiveSheetIndex(0)->setCellValue('A5', "Nama Unit"); // Set kolom A3 dengan tulisan "NO"

        $excel->setActiveSheetIndex(0)->setCellValue('B5', "01"); // Set kolom B3 dengan tulisan "NIS"

        $excel->setActiveSheetIndex(0)->setCellValue('C5', "02"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"

        $excel->setActiveSheetIndex(0)->setCellValue('D5', "03"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"

        $excel->setActiveSheetIndex(0)->setCellValue('E5', "04"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"

        $excel->setActiveSheetIndex(0)->setCellValue('F5', "05"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('G5', "06"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('H5', "07"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('I5', "08"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('J5', "09"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('K5', "10"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('L5', "11"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('M5', "12"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('N5', "TOTAL"); // Set kolom E3 dengan tulisan "ALAMAT"

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('I5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('J5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('K5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('L5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('M5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('N5')->applyFromArray($style_col);

        $data = "";

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 6; // Set baris pertama untuk isi tabel adalah baris ke 4
        // VAR_DUMP($JobOrder);
        // exit;
        foreach ($JobOrder as $data) { // Lakukan looping pada variabel siswa

            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $data['NamaUNIT']);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data['01']);
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data['02']);
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data['03']);
            $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data['04']);
            $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data['05']);
            $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data['06']);
            $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data['07']);
            $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data['08']);
            $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data['09']);
            $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data['10']);
            $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $data['11']);
            $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $data['12']);
            $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, $data['total']);

            $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('N' . $numrow)->applyFromArray($style_row);

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping 
        }

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Montly Report");
        $excel->setActiveSheetIndex(0);

        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Montly Report.xls"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }

    public function ExcelInfoRekapRegist6($Periode = "", $JenisPasien = "", $JenisRekap = "")
    {
        $data['Periode'] = $Periode;
        $data['JenisPasien'] = $JenisPasien;
        $data['JenisRekap'] = $JenisRekap;

        // Panggil class PHPExcel nya
        $excel = new PHPExcel();
        // Settingan awal fil excel
        $excel->getProperties()->setCreator('PMS GUT Developer')
            ->setLastModifiedBy('IDX Developer')
            ->setTitle("Data")
            ->setSubject("Siswa")
            ->setDescription("Laporan")
            ->setKeywords("Data");
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            ),
            'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
        );
        $style_col_prosen = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $style_col_center_bold = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $style_row_black_array = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            ),
            'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
        );
        $style_row_black = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $style_row_black_center = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $style_row_notblack_center = array(

            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $JobOrder =   $this->model('B_InformationRekapRegistrasi_Model')->getDataListRekap($data);
        $dataJO = json_decode(json_encode((object) $JobOrder), FALSE);
        $dataJOx = json_encode((object) $JobOrder);


        $excel->setActiveSheetIndex(0)->setCellValue('A1', "Montly Report"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:G1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1


        //Buat header tabel nya pada baris ke 4
        $excel->setActiveSheetIndex(0)->setCellValue('A5', "Nama Penjamin"); // Set kolom A3 dengan tulisan "NO"

        $excel->setActiveSheetIndex(0)->setCellValue('B5', "01"); // Set kolom B3 dengan tulisan "NIS"

        $excel->setActiveSheetIndex(0)->setCellValue('C5', "02"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"

        $excel->setActiveSheetIndex(0)->setCellValue('D5', "03"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"

        $excel->setActiveSheetIndex(0)->setCellValue('E5', "04"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"

        $excel->setActiveSheetIndex(0)->setCellValue('F5', "05"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('G5', "06"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('H5', "07"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('I5', "08"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('J5', "09"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('K5', "10"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('L5', "11"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('M5', "12"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('N5', "TOTAL"); // Set kolom E3 dengan tulisan "ALAMAT"

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('I5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('J5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('K5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('L5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('M5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('N5')->applyFromArray($style_col);

        $data = "";

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 6; // Set baris pertama untuk isi tabel adalah baris ke 4
        // VAR_DUMP($JobOrder);
        // exit;
        foreach ($JobOrder as $data) { // Lakukan looping pada variabel siswa

            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $data['NamaUNIT']);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data['01']);
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data['02']);
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data['03']);
            $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data['04']);
            $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data['05']);
            $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data['06']);
            $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data['07']);
            $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data['08']);
            $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data['09']);
            $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data['10']);
            $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $data['11']);
            $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $data['12']);
            $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, $data['total']);

            $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('N' . $numrow)->applyFromArray($style_row);

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping 
        }

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Montly Report");
        $excel->setActiveSheetIndex(0);

        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Montly Report.xls"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }
}
