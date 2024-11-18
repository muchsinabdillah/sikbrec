<?php

class aAntrianCaller extends Controller
{

    public function index($id = null)
    {
        $session = SessionManager::getCurrentSession();
        $data['id'] =  Utils::setDecode($id); 
        $data['judul'] = 'Adjusment';
        $data['judul_child'] = 'Input View';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('inventory/adjusment/Adjusment_View', $data);
        $this->View('templates/footer');
    }
    public function pendaftaran()
    {
        $session = SessionManager::getCurrentSession(); 
        $data['judul'] = 'Antrian Pendaftaran';
        $data['judul_child'] = 'List Antrian Pendaftaran';
        $data['session'] = $session;
        $this->View('templates/header', $session);
        $this->View('antriancaller/pendaftaran/list', $data);
        $this->View('templates/footer');
    }
    public function getIpCounter(){
        echo json_encode($this->model('A_AntrianCaller_Model')->getIpCounter($_POST));
    }
    public function getListAntrian(){
        echo json_encode($this->model('A_AntrianCaller_Model')->getListAntrian($_POST));
    }
    public function gocallantrian(){
        echo json_encode($this->model('A_AntrianCaller_Model')->gocallantrian($_POST));
    }
    public function goholdAntrian(){
        echo json_encode($this->model('A_AntrianCaller_Model')->goholdAntrian($_POST));
    }
    public function goproccessAntrian(){
        echo json_encode($this->model('A_AntrianCaller_Model')->goproccessAntrian($_POST));
    }
    public function goFinishAntrian(){
        echo json_encode($this->model('A_AntrianCaller_Model')->goFinishAntrian($_POST));
    }

    public function gocallantrianFarmasi(){
        $data = $_POST;
        $data['NoRegistrasi'] = $_POST['noreg'];
        $getdata = $this->model('B_Create_Registrasi_Rajal')->GetregistrasiRajalbyNoRegistrasi($data);
        $data['noantrian'] = $getdata['NoAntrianAll'];
        echo json_encode($this->model('A_AntrianCaller_Model')->gocallantrianFarmasi($data));
    }
    public function UpdateDataVerifikasi(){
        $response_arr = [];
        $tod = json_decode(json_encode((object) $_POST['iddetail']), FALSE);
        $no = 1;
        foreach ($tod as $key) { 
            if ($key == null){
                $message = $no.'. [Failed] No Order '.$key.' Kosong !';
                $callback = array(
                    'status' => 'false', 
                    'message' => $message, 
                );
                array_push($response_arr,$callback);
                $no++;
                continue;
            }

            if ($_POST['idbtn'] == 'cb_btndiambil'){
                $data['StatusVerifikasi'] = 'DIAMBIL';
            }elseif($_POST['idbtn'] == 'cb_btndiperiksa'){
                $data['StatusVerifikasi'] = 'DIPERIKSA';
            }elseif($_POST['idbtn'] == 'cb_btndikemas'){
                $data['StatusVerifikasi'] = 'DIKEMAS';
            }
            $data['OrderID'] = $key;
            $getresep = $this->model('B_Farmasi')->viewOrderResepbyOrderIDV2($data);
            $data['NoRegistrasi'] = $getresep['data'][0]['NoRegistrasi'];
            $data['NoResep'] = $getresep['data'][0]['ID'];
            $msg = $this->model('A_AntrianCaller_Model')->UpdateDataVerifikasi($data);
            if ($msg['status'] == false){
                $message = $no.'. [Failed] No Order '.$key.' '.$msg['message'];
            }else{
                $message = $no.'. [Success] No Order '.$key.' '.$msg['message'];
            }
            $no++;
            //$message = 'No Order '.$key.' '.$msg['message'];
            $callback = array(
                'status' => $msg['status'], 
                'message' => $message, 
            );
            array_push($response_arr,$callback);
        }
            echo json_encode($response_arr);
    }

    public function UpdateAntrianFarmasi(){
        $response_arr = [];
        $tod = json_decode(json_encode((object) $_POST['iddetail']), FALSE);
        $no = 1;
        foreach ($tod as $key) { 
            if ($_POST['idbtn'] == 'cb_btnresepselesai'){
                $data['StatusResep'] = 'FINISHED';
            }
            $data['OrderID'] = $key;
            $getresep = $this->model('B_Farmasi')->viewOrderResepbyOrderIDV2($data);
            $data['NoRegistrasi'] = $getresep['data'][0]['NoRegistrasi'];
            $data['NoResep'] = $getresep['data'][0]['ID'];
            $msg = $this->model('A_AntrianCaller_Model')->UpdateAntrianFarmasi($data);
            if ($msg['status'] == false){
                $message = $no.'. [Failed] No Order '.$key.' '.$msg['message'];
            }else{
                $message = $no.'. [Success] No Order '.$key.' '.$msg['message'];
            }
            $no++;
            $callback = array(
                'status' => $msg['status'], 
                'message' => $message, 
            );
            array_push($response_arr,$callback);
        }
            echo json_encode($response_arr);
    }
    
}