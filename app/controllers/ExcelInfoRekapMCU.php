<?php
class ExcelInfoRekapMCU extends Controller
{
    public function ExcelInfoRekapMCU2($TglAwal = "", $TglAkhir = "", $tp_pasien = "", $id_penjamin = "")
    {
        $data['TglAwal'] = $TglAwal;
        $data['TglAkhir'] = $TglAkhir;
        $data['TipePenjamin'] = $tp_pasien;
        $data['NamaPenjamin'] = $id_penjamin;
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
        $JobOrder =   $this->model('B_InformationRekapMCU_Model')->getDataListPasien1($data);
        $dataJO = json_decode(json_encode((object) $JobOrder), FALSE);
        $dataJOx = json_encode((object) $JobOrder);


        $excel->setActiveSheetIndex(0)->setCellValue('A1', "Informasi Rekap MCU Pasien"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:G1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1


        //Buat header tabel nya pada baris ke 4
        $excel->setActiveSheetIndex(0)->setCellValue('A5', "NO"); // Set kolom A3 dengan tulisan "NO"

        $excel->setActiveSheetIndex(0)->setCellValue('B5', "Tanggal Kunjungan"); // Set kolom A3 dengan tulisan "NO"

        $excel->setActiveSheetIndex(0)->setCellValue('C5', "Nama Pasien"); // Set kolom B3 dengan tulisan "NIS"

        $excel->setActiveSheetIndex(0)->setCellValue('D5', "Jenis Kelamin"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"

        $excel->setActiveSheetIndex(0)->setCellValue('E5', "Umur"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"

        $excel->setActiveSheetIndex(0)->setCellValue('F5', "Tinggi Badan"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"

        $excel->setActiveSheetIndex(0)->setCellValue('G5', "Berat Badan"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('H5', "Kelainan"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('I5', "Diagnosa Kerja"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('J5', "Anjuran Konsul Ke"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('K5', "Kesimpulan"); // Set kolom E3 dengan tulisan "ALAMAT"

        $excel->setActiveSheetIndex(0)->setCellValue('L5', "Kategori Kesehatan"); // Set kolom E3 dengan tulisan "ALAMAT"

        // $excel->setActiveSheetIndex(0)->setCellValue('L5', "Date Update"); // Set kolom E3 dengan tulisan "ALAMAT"
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


        $data = "";

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 6; // Set baris pertama untuk isi tabel adalah baris ke 4
        // VAR_DUMP($JobOrder);
        // exit;
        foreach ($JobOrder as $data) { // Lakukan looping pada variabel siswa
            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data['Tgl']);
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data['PatientName']);
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data['Gander']);
            $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data['UMUR']);
            $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data['PemfisikTB'] . 'Cm');
            $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data['PemfisikBB'] . 'Kg');
            $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, '1. Fisik - Kondisi Nutrisi :  ' . $data['PemfisikKondisiNutrisi'] . ' - BMI :  ' . $data['PemfisikBMI'] . ' - Ket BMI : ' . $data['PemfisikKetBMI'] . ' <br> 2. Rontgen Thorax : ' . $data['Rontgen_Thorax'] . '<br> 3. USG Abdomen : ' . $data['UsgAbdomen'] . '<br> 4. Audiometri : ' . $data['Audiometri'] . '<br> 5. Laboratorium : ' . $data['Laboratorium'] . '<br> 6. Jantung - EKG : ' . $data['EKG'] . ' - Treadmill : ' . $data['Treadmill'] . ' <br> 7. Mata : ' . $data['KesimpulanMata'] . '<br> 8. THT : ' . $data['kesimpulantht'] . '<br> 9. Penyakit Dalam : ' . $data['PenyakitDalam'] . '<br> 10. Bedah : ' . $data['Bedah'] . '<br> 11. Syaraf : ' . $data['kesimpulansyaraf'] . '<br> 12. Ginekologi :' . '<br> 13. Spirometri : ' . $data['Spirometri']);
            $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data['DiagnosaKerja']);
            $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data['AnjuranKonsulKe']);
            $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data['KetKesehatan']);
            $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $data['kategorikesehatan']);
            // $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $data['DateUpdate']);

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


            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping 
        }

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Informasi Rekap MCU Pasien");
        $excel->setActiveSheetIndex(0);

        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Informasi Rekap MCU Pasien.xls"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }
    public function index()
    {
        try {
            $session = SessionManager::getCurrentSession();

            //$datax =  json_encode($this->model('Grafik_Model')->testGrafik());
            // var_dump($datax);
            $cek =  $this->model('Login_Model')->checkToken($session->username, $session->role, $session->name, $session->token);
            if ($cek) {
                $this->view('templates/header', $session);
                $this->View('home/index', $session);
                $this->view('templates/footer', $session);
            } else {
                header('Location: ' . BASEURL . '/Login');
            }
        } catch (exception $exception) {
            header('Location: ' . BASEURL . '/Login');
        }
    }
}
