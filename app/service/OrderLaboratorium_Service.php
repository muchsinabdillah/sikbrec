<?php
class OrderLaboratorium_Service
{
    private $B_Order_Laboratorium_Modal;
    public function __construct(
        B_Order_Laboratorium_Model $B_Order_Laboratorium_Modal
    ) {
        $this->B_Order_Laboratorium_Modal = $B_Order_Laboratorium_Modal; 
    }
    function createHeaderOrderLaboratorium($data)
    {
        try {
            if ($_POST['Lab_Daignosa'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Diagnosa Klinik Harus Diisi !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($_POST['Lab_Keterangan_Klinik'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Keterangan Klinik Harus Diisi !',
                );
                echo json_encode($callback);
                exit;
            }
            
            $createOrderNumber = $this->B_Order_Laboratorium_Modal->createOrderNumberLIS($data);
            $createOrderRadiologi = $this->B_Order_Laboratorium_Modal->createHeaderOrderLaboratorium($data, $createOrderNumber);
            return $createOrderRadiologi;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }

    }
    function addDetilPemeriksaanLaboratorium($data)
    {
        try {
            if ($_POST['Lab_kodeTes_2'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode Test Lab Harus Dipilih !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($_POST['Lab_Nilai'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Nilai Pemeriksaan Kosong !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($_POST['Lab_kodeTes_kelompok'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode Kelompok Pemeriksaan Kosong !',
                );
                echo json_encode($callback);
                exit;
            }
            // VALIDASI DOBEL ENTRY PEMERIKSAAN DETIL
            $validasiDoubleOrderLabDetil = $this->B_Order_Laboratorium_Modal->validasiDoubleOrderLabDetil($data);
            if($validasiDoubleOrderLabDetil['status'] == "warning"){
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Double Pemeriksaan !',
                );
                return $callback;
                exit;
            }
            // VALIDASI SUDAH DI RECEIVE
            $validasiDoubleOrderLabDetil = $this->B_Order_Laboratorium_Modal->validasiHasReceiveOrderLabDetil($data);
            if ($validasiDoubleOrderLabDetil['status'] == "warning") {
                $callback = array(
                    'status' => 'warningreceive',
                    'errorname' => 'Pemeriksaan Sudah di Receive, buat Trs Baru untuk entri Pemeriksaan Lainnya !', 
                );
                return $callback;
                exit;
            }
            // Get Data LabID by No.LAB
            $dataLabId = $this->B_Order_Laboratorium_Modal->getDataTblLabHeaderByNoLab($data);
            $LabId = $dataLabId['LabID'];
            $addDetilTblLab = $this->B_Order_Laboratorium_Modal->addDetilTblLab($data, $LabId);
            return $addDetilTblLab; 
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    function deleteDetilOrderLab($data){
        try {
            if ($_POST['Lab_NoLab'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. Lab Invalid !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($_POST['NoDetilOrder'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. Id Invalid !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($_POST['alasanbatalDetil'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Alasan Batal Harus diisi !',
                );
                echo json_encode($callback);
                exit;
            }
            // VALIDASI SUDAH DI RECEIVE
            $validasiDoubleOrderLabDetil = $this->B_Order_Laboratorium_Modal->validasiHasReceiveOrderLabDetil($data);
            if ($validasiDoubleOrderLabDetil['status'] == "warning") {
                $callback = array(
                    'status' => 'warningreceive',
                    'errorname' => 'Pemeriksaan Sudah di Receive, buat Trs Baru untuk entri Pemeriksaan Lainnya !',
                );
                return $callback;
                exit;
            }
            // VALIDASI SUDAH ADA HASIL
            $validasiHasResultLab = $this->B_Order_Laboratorium_Modal->validationHasResultLab($data);
            if ($validasiHasResultLab['status'] == "warning") {
                $callback = array(
                    'status' => 'warningreceive',
                    'errorname' => 'Pemeriksaan Sudah ada Hasil, anda tidak bisa membatalkan !',
                );
                return $callback;
                exit;
            }
            // Get Data LabID by No.LAB
            $addDetilTblLab = $this->B_Order_Laboratorium_Modal->deleteDetilOrderLab($data);
            return $addDetilTblLab;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    function FinishOrderLaboratorium($data)
    {
        try {
            
            if ($_POST['Lab_NoLab'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. Lab Invalid !',
                );
                echo json_encode($callback);
                exit;
            }
            // if ($_POST['Lab_kodeTes_2'] == "") {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => 'No. Id Test Invalid !',
            //     );
            //     echo json_encode($callback);
            //     exit;
            // }
            // if ($_POST['Lab_Nilai'] == "") {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => 'Lab Nilai Invalid !',
            //     );
            //     echo json_encode($callback);
            //     exit;
            // }
            // if ($_POST['Lab_kodeTes_kelompok'] == "") {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => 'Lab Kode Kelompok Invalid !',
            //     );
            //     echo json_encode($callback);
            //     exit;
            // }
            if ($_POST['Lab_NORegistrasi'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Lab. No Registrasi !',
                );
                echo json_encode($callback);
                exit;
            }
            // VALIDASI SUDAH DI RECEIVE
            $validasiDoubleOrderLabDetil = $this->B_Order_Laboratorium_Modal->validasiHasReceiveOrderLabDetil($data);
            if ($validasiDoubleOrderLabDetil['status'] == "warning") {
                $callback = array(
                    'status' => 'warningreceive',
                    'errorname' => 'Pemeriksaan Sudah di Receive, buat Trs Baru untuk entri Pemeriksaan Lainnya !',
                );
                return $callback;
                exit;
            }
            // VALIDASI SUDAH ADA HASIL
            $validasiHasResultLab = $this->B_Order_Laboratorium_Modal->validationHasResultLab($data);
            if ($validasiHasResultLab['status'] == "warning") {
                $callback = array(
                    'status' => 'warningreceive',
                    'errorname' => 'Pemeriksaan Sudah ada Hasil, anda tidak bisa membatalkan !',
                );
                return $callback;
                exit;
            }
            // VALIDASI SUDAH ADA ORDER DETIL DI TBL LAB DETIL ?
            $validasiHasOrderTblLabDetil = $this->B_Order_Laboratorium_Modal->validasiHasOrderTblLabDetil($data);
            if ($validasiHasOrderTblLabDetil['status'] == "warning") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Pemeriksaan Masih Kosong, Cek Kembali Data Anda Sebelum disimpan !',
                );
                return $callback;
                exit;
            }
            // GET DATA TABEL LAB DAN VISIT
            $dataTblLabHdr = $this->B_Order_Laboratorium_Modal->getDataPasienbyTblLabHeader($data);

            // Get No Lab di tabel LIS_ORDER APAKAH SUDAH ADA 
               $dataLIsHeader = $this->B_Order_Laboratorium_Modal->getTblLisOrderHeaderbyNoLab($data);
                if($dataLIsHeader['NoLab'] == null){
                    $update = 'new';
                }else{
                    $update = 'update';
                } 
            // Get Data LabID by No.LAB
            $addDetilTblLab = $this->B_Order_Laboratorium_Modal->createFinsihOrderLab($data, $dataTblLabHdr, $update);
            return $addDetilTblLab;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    function deleteOrderLab($data)
    {
        try {
            if ($_POST['Lab_NoLab'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. Lab Invalid !',
                );
                echo json_encode($callback);
                exit;
            }
             
            if ($_POST['alasanbatalOrder'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Alasan Batal Harus diisi !',
                );
                echo json_encode($callback);
                exit;
            }
            // VALIDASI SUDAH DI RECEIVE
            $validasiDoubleOrderLabDetil = $this->B_Order_Laboratorium_Modal->validasiHasReceiveOrderLabDetil($data);
            if ($validasiDoubleOrderLabDetil['status'] == "warning") {
                $callback = array(
                    'status' => 'warningreceive',
                    'errorname' => 'Pemeriksaan Sudah di Receive, buat Trs Baru untuk entri Pemeriksaan Lainnya !',
                );
                return $callback;
                exit;
            }
            // VALIDASI SUDAH ADA HASIL
            $validasiHasResultLab = $this->B_Order_Laboratorium_Modal->validationHasResultLab($data);
            if ($validasiHasResultLab['status'] == "warning") {
                $callback = array(
                    'status' => 'warningreceive',
                    'errorname' => 'Pemeriksaan Sudah ada Hasil, anda tidak bisa membatalkan !',
                );
                return $callback;
                exit;
            }
            // Get Data LabID by No.LAB
            $addDetilTblLab = $this->B_Order_Laboratorium_Modal->deleteOrderLab($data);
            return $addDetilTblLab;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    function deleteOrderLab2($data)
    {
        try {
            if ($_POST['Lab_NoLab'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. Lab Invalid !',
                );
                echo json_encode($callback);
                exit;
            }

            if ($_POST['alasanbatalOrder'] == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Alasan Batal Harus diisi !',
                );
                echo json_encode($callback);
                exit;
            }
            // VALIDASI SUDAH DI RECEIVE
            $validasiDoubleOrderLabDetil = $this->B_Order_Laboratorium_Modal->validasiHasReceiveOrderLabDetil($data);
            if ($validasiDoubleOrderLabDetil['status'] == "warning") {
                $callback = array(
                    'status' => 'warningreceive',
                    'errorname' => 'Pemeriksaan Sudah di Receive, buat Trs Baru untuk entri Pemeriksaan Lainnya !',
                );
                return $callback;
                exit;
            }
            // VALIDASI SUDAH ADA HASIL
            $validasiHasResultLab = $this->B_Order_Laboratorium_Modal->validationHasResultLab($data);
            if ($validasiHasResultLab['status'] == "warning") {
                $callback = array(
                    'status' => 'warningreceive',
                    'errorname' => 'Pemeriksaan Sudah ada Hasil, anda tidak bisa membatalkan !',
                );
                return $callback;
                exit;
            }
            // Get Data LabID by No.LAB
            $addDetilTblLab = $this->B_Order_Laboratorium_Modal->deleteOrderLab2($data);
            return $addDetilTblLab;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
}
