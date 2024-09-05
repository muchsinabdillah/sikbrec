<?php
class fPelaksanaanEdukasi extends Controller
{
    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id);
        $data['judul'] = 'FORM EDUKASI PESIEN & KELUARGA';
        // $data['judul_child'] = 'Data Pasien';  
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('form/PelaksanaanEdukasi', $data);
        $this->View('templates/footer');
    }
    public function getInsert2()
    {
        echo json_encode($this->model('PelaksanaanEdukasi_Model')->insert2($_POST));
    }
    public function saveimgSignature()
    {
        echo json_encode($this->model('PelaksanaanEdukasi_Model')->Save($_POST));
    }
    public function getPath()
    {
        echo json_encode($this->model('PelaksanaanEdukasi_Model')->Path($_POST));
    }
    // public function dobleSignautre()
    // {
    //     $data = $_POST;
    //     // var_dump($data);
    //     // cek validasi 
    //     // if ($data['namaparam2'] == "") {
    //     //     $this->response(201, "Nama Pihak Ke2 kosong");
    //     // } elseif ($data['namaparam1'] == "") {
    //     //     $this->response(404, 'Nama pihak Pertama kosong');
    //     if (isset($data['path1']) == "") {
    //         $this->response(404, "Pihak Pertama Belum Melakukan Tanda Tangan");
    //     } elseif (isset($data['path2']) == "") {
    //         $this->response(404, "Pihak Kedua Belum Melakukan Tanda Tangan");
    //         // } else {
    //         //     echo json_encode($this->model('signature_Model')->DoubleSignature($_POST));
    //         // }
    //     }
    // }
    public function response($responsecode, $message)
    {
        $calback = [
            'status' => $responsecode,
            'message' => $message
        ];
        echo json_encode($calback);
    }
}
