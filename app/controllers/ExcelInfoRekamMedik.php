<?php
class ExcelInfoRekamMedik extends Controller
{
    public function ExcelInfoRekamMedik2($TglAwal = "", $TglAkhir = "", $JenisRekap = "", $JenisTipe = "", $JenisInfo = "", $GrupPerawatan = "",  $NamaDokter = "")
    {
        $data['TglAwal'] = $TglAwal;
        $data['TglAkhir'] = $TglAkhir;
        $data['JenisRekap'] = $JenisRekap;
        $data['JenisTipe'] = $JenisTipe;
        $data['JenisInfo'] = $JenisInfo;
        $data['GrupPerawatan'] = $GrupPerawatan;
        $data['NamaDokter'] = $NamaDokter;

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
        $JobOrder =   $this->model('B_InformationRekamMedik_Model')->getDataListPasien1($data);
        $dataJO = json_decode(json_encode((object) $JobOrder), FALSE);
        $dataJOx = json_encode((object) $JobOrder);


        $excel->setActiveSheetIndex(0)->setCellValue('A1', "Infomasi Rekam Medik"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:G1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1


        //Buat header tabel nya pada baris ke 4
        $excel->setActiveSheetIndex(0)->setCellValue('A5', "Tgl"); // Set kolom A3 dengan tulisan "NO"

        $excel->setActiveSheetIndex(0)->setCellValue('B5', "No. MR"); // Set kolom B3 dengan tulisan "NIS"

        $excel->setActiveSheetIndex(0)->setCellValue('C5', "Baru/Lama"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"

        $excel->setActiveSheetIndex(0)->setCellValue('D5', "Status Regis"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"

        $excel->setActiveSheetIndex(0)->setCellValue('E5', "No. Reg"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"

        $excel->setActiveSheetIndex(0)->setCellValue('F5', "Nama Pasien"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('G5', "Gender"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('H5', "Lokasi Pasien"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('I5', "Diagnosa"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('J5', "Nama Dokter"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('K5', "Asuransi"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('L5', "Alamat"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('M5', "Kelurahan"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('N5', "Kecamatan"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('O5', "Kabupaten"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('P5', "Provinsi"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('Q5', "Cara Masuk"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('R5', "Referal"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('S5', "Nama Administrasi"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('T5', "Nilai Administrasi"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('U5', "TOTAL BILL"); // Set kolom E3 dengan tulisan "ALAMAT"

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
        $excel->getActiveSheet()->getStyle('Q5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('R5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('S5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('T5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('U5')->applyFromArray($style_col);

        $data = "";

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 6; // Set baris pertama untuk isi tabel adalah baris ke 4
        // VAR_DUMP($JobOrder);
        // exit;
        foreach ($JobOrder as $data) { // Lakukan looping pada variabel siswa

            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $data['TglKunjungan']);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data['NoMR']);
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data['JenisPasien']);
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data['statusregis']);
            $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data['NoRegistrasi']);
            $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data['PatientName']);
            $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data['Gander']);
            $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data['NamaUnit']);
            $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data['A_Diagnosa']);
            $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data['First_Name']);
            $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data['NamaPerusahaan']);
            $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $data['Address']);
            $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $data['Kelurahan']);
            $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, $data['Kecamatan']);
            $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, $data['kabupatenNama']);
            $excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, $data['ProvinsiNama']);
            $excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, $data['NamaCaraMasuk']);
            $excel->setActiveSheetIndex(0)->setCellValue('R' . $numrow, $data['NamaCaraMasukRef']);
            $excel->setActiveSheetIndex(0)->setCellValue('S' . $numrow, $data['tarif']);
            $excel->setActiveSheetIndex(0)->setCellValue('T' . $numrow, $data['TarifRS']);
            $excel->setActiveSheetIndex(0)->setCellValue('U' . $numrow, $data['totalbill']);

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
            $excel->getActiveSheet()->getStyle('Q' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('R' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('S' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('T' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('U' . $numrow)->applyFromArray($style_row);

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping 
        }

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Infomasi Rekam Medik");
        $excel->setActiveSheetIndex(0);

        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Infomasi Rekam Medik.xls"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }

    public function ExcelInfoRekamMedik4($TglAwal = "", $TglAkhir = "", $JenisRekap = "", $JenisTipe = "", $JenisInfo = "", $GrupPerawatan = "",  $NamaDokter = "")
    {
        $data['TglAwal'] = $TglAwal;
        $data['TglAkhir'] = $TglAkhir;
        $data['JenisRekap'] = $JenisRekap;
        $data['JenisTipe'] = $JenisTipe;
        $data['JenisInfo'] = $JenisInfo;
        $data['GrupPerawatan'] = $GrupPerawatan;
        $data['NamaDokter'] = $NamaDokter;

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
        $JobOrder =   $this->model('B_InformationRekamMedik_Model')->getDataListPasien1($data);
        $dataJO = json_decode(json_encode((object) $JobOrder), FALSE);
        // VAR_DUMP($data);
        // exit;
        $dataJOx = json_encode((object) $JobOrder);

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "Infomasi Rekam Medik"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:G1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1


        //Buat header tabel nya pada baris ke 4
        $excel->setActiveSheetIndex(0)->setCellValue('A5', "POLIKLINIK"); // Set kolom A3 dengan tulisan "NO"

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

        $excel->setActiveSheetIndex(0)->setCellValue('O5', "13"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('P5', "14"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('Q5', "15"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('R5', "16"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('S5', "17"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('T5', "18"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('U5', "19"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('V5', "20"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('W5', "21"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('X5', "22"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('Y5', "23"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('Z5', "24"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('AA5', "25"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('AB5', "26"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('AC5', "27"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('AD5', "28"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('AE5', "29"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('AF5', "30"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('AG5', "31"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('AH5', "TOTAL"); // Set kolom E3 dengan tulisan "ALAMAT"

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
        $excel->getActiveSheet()->getStyle('Q5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('R5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('S5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('T5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('U5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('V5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('W5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('X5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('Y5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('Z5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('AA5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('AB5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('AC5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('AD5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('AE5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('AF5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('AG5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('AH5')->applyFromArray($style_col);

        $data = "";

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 6; // Set baris pertama untuk isi tabel adalah baris ke 4


        foreach ($JobOrder as $data) { // Lakukan looping pada variabel siswa
            $total = $data['01'] + $data['02'] + $data['03'] + $data['04'] + $data['05']
                + $data['06'] + $data['07'] + $data['08'] + $data['09'] + $data['10']
                + $data['11'] + $data['12'] + $data['13'] + $data['14'] + $data['15']
                + $data['16'] + $data['17'] + $data['18'] + $data['19'] + $data['20']
                + $data['21'] + $data['22'] + $data['23'] + $data['24'] + $data['25']
                + $data['26'] + $data['27'] + $data['28'] + $data['29'] + $data['30']
                + $data['31'];
            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $data['NamaUnit']);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data['First_Name']);
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
            $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, $data['13']);
            $excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, $data['14']);
            $excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, $data['15']);
            $excel->setActiveSheetIndex(0)->setCellValue('R' . $numrow, $data['16']);
            $excel->setActiveSheetIndex(0)->setCellValue('S' . $numrow, $data['17']);
            $excel->setActiveSheetIndex(0)->setCellValue('T' . $numrow, $data['18']);
            $excel->setActiveSheetIndex(0)->setCellValue('U' . $numrow, $data['19']);
            $excel->setActiveSheetIndex(0)->setCellValue('V' . $numrow, $data['20']);
            $excel->setActiveSheetIndex(0)->setCellValue('W' . $numrow, $data['21']);
            $excel->setActiveSheetIndex(0)->setCellValue('X' . $numrow, $data['22']);
            $excel->setActiveSheetIndex(0)->setCellValue('Y' . $numrow, $data['23']);
            $excel->setActiveSheetIndex(0)->setCellValue('Z' . $numrow, $data['24']);
            $excel->setActiveSheetIndex(0)->setCellValue('AA' . $numrow, $data['25']);
            $excel->setActiveSheetIndex(0)->setCellValue('AB' . $numrow, $data['26']);
            $excel->setActiveSheetIndex(0)->setCellValue('AC' . $numrow, $data['27']);
            $excel->setActiveSheetIndex(0)->setCellValue('AD' . $numrow, $data['28']);
            $excel->setActiveSheetIndex(0)->setCellValue('AE' . $numrow, $data['29']);
            $excel->setActiveSheetIndex(0)->setCellValue('AF' . $numrow, $data['30']);
            $excel->setActiveSheetIndex(0)->setCellValue('AG' . $numrow, $data['31']);
            $excel->setActiveSheetIndex(0)->setCellValue('AH' . $numrow, $total);

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
            $excel->getActiveSheet()->getStyle('Q' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('R' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('S' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('T' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('U' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('V' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('W' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('X' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('Y' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('Z' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('AA' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('AB' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('AC' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('AD' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('AE' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('AF' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('AG' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('AH' . $numrow)->applyFromArray($style_row);

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping 
        }

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Infomasi Rekam Medik");
        $excel->setActiveSheetIndex(0);

        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Infomasi Rekam Medik.xls"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }

    public function ExcelInfoRekamMedik3($TglAwal = "", $TglAkhir = "", $JenisRekap = "", $JenisTipe = "", $JenisInfo = "", $GrupPerawatan = "",  $NamaDokter = "")
    {
        $data['TglAwal'] = $TglAwal;
        $data['TglAkhir'] = $TglAkhir;
        $data['JenisRekap'] = $JenisRekap;
        $data['JenisTipe'] = $JenisTipe;
        $data['JenisInfo'] = $JenisInfo;
        $data['GrupPerawatan'] = $GrupPerawatan;
        $data['NamaDokter'] = $NamaDokter;

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
        $JobOrder =   $this->model('B_InformationRekamMedik_Model')->getDataListPasien1($data);
        $dataJO = json_decode(json_encode((object) $JobOrder), FALSE);
        $dataJOx = json_encode((object) $JobOrder);


        $excel->setActiveSheetIndex(0)->setCellValue('A1', "Infomasi Rekam Medik"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:G1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1


        //Buat header tabel nya pada baris ke 4
        $excel->setActiveSheetIndex(0)->setCellValue('A5', "Keterangan"); // Set kolom A3 dengan tulisan "NO"

        $excel->setActiveSheetIndex(0)->setCellValue('B5', "total"); // Set kolom B3 dengan tulisan "NIS"

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B5')->applyFromArray($style_col);

        $data = "";

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 6; // Set baris pertama untuk isi tabel adalah baris ke 4
        // VAR_DUMP($JobOrder);
        // exit;
        foreach ($JobOrder as $data) { // Lakukan looping pada variabel siswa

            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $data['Keterangan']);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data['jumlah']);

            $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping 
        }

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Infomasi Rekam Medik");
        $excel->setActiveSheetIndex(0);

        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Infomasi Rekam Medik.xls"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }

    public function ExcelInfoRekamMedik5($TglAwal = "", $TglAkhir = "", $JenisRekap = "", $JenisTipe = "", $JenisInfo = "", $GrupPerawatan = "",  $NamaDokter = "")
    {
        $data['TglAwal'] = $TglAwal;
        $data['TglAkhir'] = $TglAkhir;
        $data['JenisRekap'] = $JenisRekap;
        $data['JenisTipe'] = $JenisTipe;
        $data['JenisInfo'] = $JenisInfo;
        $data['GrupPerawatan'] = $GrupPerawatan;
        $data['NamaDokter'] = $NamaDokter;

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
        $JobOrder =   $this->model('B_InformationRekamMedik_Model')->getDataListPasien1($data);
        $dataJO = json_decode(json_encode((object) $JobOrder), FALSE);
        $dataJOx = json_encode((object) $JobOrder);


        $excel->setActiveSheetIndex(0)->setCellValue('A1', "Infomasi Rekam Medik"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:G1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1


        //Buat header tabel nya pada baris ke 4
        $excel->setActiveSheetIndex(0)->setCellValue('A5', "Tgl Order"); // Set kolom A3 dengan tulisan "NO"

        $excel->setActiveSheetIndex(0)->setCellValue('B5', "Tgl Operasi"); // Set kolom B3 dengan tulisan "NIS"

        $excel->setActiveSheetIndex(0)->setCellValue('C5', "No. MR"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"

        $excel->setActiveSheetIndex(0)->setCellValue('D5', "No. Reg"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"

        $excel->setActiveSheetIndex(0)->setCellValue('E5', "Nama Pasien"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"

        $excel->setActiveSheetIndex(0)->setCellValue('F5', "Diagnosa Pre OP"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('G5', "Diagnosa Post OP"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('H5', "Nama Tindakan"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('I5', "Nama Dokter Operator"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('J5', "Nama Dokter Anestesi"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('K5', "Lama Operasi"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('L5', "Jaminan"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('M5', "Group Spesialis"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('N5', "Klasifikasi Operasi"); // Set kolom E3 dengan tulisan "ALAMAT"
        
        $excel->setActiveSheetIndex(0)->setCellValue('N5', "Laporan Operasi"); // Set kolom E3 dengan tulisan "ALAMAT"

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

            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $data['TglOrder']);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data['TglOperasi']);
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data['NoMR']);
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data['NoRegistrasi']);
            $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data['NamaPasien']);
            $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data['DiagnosaPreOP']);
            $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data['DiagnosaPostOP']);
            $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data['JenisOperasi']);
            $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data['DrOperator']);
            $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data['DrAnastesi']);
            $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data['PerkiraanLamaOP']);
            $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $data['NamaPerusahaan']);
            $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $data['GroupSpesialis']);
            $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, $data['KlasifikasiOP']);
            $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, $data['LaporanOP']);

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

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping 
        }

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Infomasi Rekam Medik");
        $excel->setActiveSheetIndex(0);

        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Infomasi Rekam Medik.xls"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }
}
