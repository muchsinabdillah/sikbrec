<?php

class B_xBPJSBridging_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    function GoBPJSCekKepesertaan($data)
    {
        $jenisPencarian = $data['jenisPencarian'];
        $kodePeserta = $data['kodePeserta'];
        $JenisRujukanFaskesBPJSx = $data['JenisRujukanFaskesBPJSx'];
        $dateNow = Utils::datenowcreateNotFull();
        if ($jenisPencarian == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Masukan Jenis Pencarian !',
            );
            echo json_encode($callback);
            exit;
        }

        if ($kodePeserta == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Masukan Kode Peserta/No. Rujukan !',
            );
            echo json_encode($callback);
            exit;
        }

        if ($jenisPencarian == "1") {
            $urlApi = "Peserta/nik/$kodePeserta/tglSEP/$dateNow";
        } elseif ($jenisPencarian == "2") {
            $urlApi = "Peserta/nokartu/$kodePeserta/tglSEP/$dateNow";
        } elseif ($jenisPencarian == "3") {
            if ($JenisRujukanFaskesBPJSx == "1") {
                $urlApi = "Rujukan/$kodePeserta";
            } else {
                $urlApi = "Rujukan/RS/$kodePeserta";
            }
        }
        // persiapkan curl
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS . $urlApi);
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
        // set time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            // $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));

            //echo json_encode($output);
            $callback = array(
                'status' => 'success',
                'hasil' => $ResultEncriptLzString,
            );
            return $callback;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']

            );
            return $callback;
        }
    }
    function GoGetDaignosaBPJS($data)
    {
        $searchTerm = $data['searchTerm'];
        // persiapkan curl
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS_REFF . "diagnosa/$searchTerm");
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
        // set time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            // $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));

            //echo json_encode($output);
            foreach ($ResultEncriptLzString['1']['diagnosa'] as $key => $jsons) { // This will search in the 2 jsons
                $pasing['id'] = $jsons['kode'];
                $pasing['text'] = $jsons['nama'];
                $datas[] = $pasing;
            }
            return $datas;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']

            );
            return $callback;
        }
    }
    function GoGetFaskesBPJS($data)
    {
        $searchTerm = $data['searchTerm'];
        $jenisFaskes = $data['jenisFaskes'];
        // persiapkan curl
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS_REFF . "faskes/$searchTerm/$jenisFaskes");
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
        // set time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            // $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, Utils::setKey());
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));

            //echo json_encode($output);
            foreach ($ResultEncriptLzString['1']['faskes'] as $key => $jsons) { // This will search in the 2 jsons
                $pasing['id'] = $jsons['kode'];
                $pasing['text'] = $jsons['nama'];
                $datas[] = $pasing;
            }
            return $datas;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']

            );
            return $callback;
        }
    }
    function GoGetPoliklinikBPJS($data)
    {
        $searchTerm = $data['searchTerm'];
        // persiapkan curl
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS_REFF . "poli/$searchTerm");
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
        // set time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            // $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, Utils::setKey());
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            //echo json_encode($output);
            foreach ($ResultEncriptLzString['1']['poli'] as $key => $jsons) { // This will search in the 2 jsons
                $pasing['id'] = $jsons['kode'];
                $pasing['text'] = $jsons['nama'];
                $datas[] = $pasing;
            }
            return $datas;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']

            );
            return $callback;
        }
    }
    function GoGetDokterBPJS($data)
    {
        $IdPoliklinik = $data['IdPoliklinik'];

        if ($IdPoliklinik == "IGD" || $IdPoliklinik ==  "HDL") {
            $isJenisPelayananBPJS = '1';
        } else {
            $isJenisPelayananBPJS = $data['isJenisPelayananBPJS'];
        }
        $dateNow = Utils::datenowcreateNotFull();
        // persiapkan curl
        $ch = curl_init();

        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);

        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS_REFF . "dokter/pelayanan/$isJenisPelayananBPJS/tglPelayanan/$dateNow/Spesialis/$IdPoliklinik");
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
        // set time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            // $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, Utils::setKey());
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));

            //echo json_encode($output);
            foreach ($ResultEncriptLzString['1']['list'] as $key => $jsons) { // This will search in the 2 jsons
                $pasing['id'] = $jsons['kode'];
                $pasing['text'] = $jsons['nama'];
                $datas[] = $pasing;
            }
            return $datas;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']

            );
            return $callback;
        }
    }

    function GoGetProvinsiBPJS()
    {
        $dateNow = Utils::datenowcreateNotFull();
        // persiapkan curl
        $ch = curl_init();

        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);

        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS_REFF . "propinsi");
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
        // set time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            //echo json_encode($output);
            foreach ($ResultEncriptLzString['1']['list'] as $key => $jsons) { // This will search in the 2 jsons
                $pasing['id'] = $jsons['kode'];
                $pasing['text'] = $jsons['nama'];
                $datas[] = $pasing;
            }
            return $datas;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']

            );
            return $callback;
        }
    }
    function GoGetDataKabupatenBPJS($data)
    {
        $SuplesiBPJSProvinsi = $data['SuplesiBPJSProvinsi'];
        $dateNow = Utils::datenowcreateNotFull();
        // persiapkan curl
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS_REFF . "kabupaten/propinsi/$SuplesiBPJSProvinsi");
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
        // set time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));

            //echo json_encode($output);
            foreach ($ResultEncriptLzString['1']['list'] as $key => $jsons) { // This will search in the 2 jsons
                $pasing['id'] = $jsons['kode'];
                $pasing['text'] = $jsons['nama'];
                $datas[] = $pasing;
            }
            return $datas;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']

            );
            return $callback;
        }
    }
    function GetDataKecamatanBPJS($data)
    {
        $SuplesiBPJSKabupaten = $data['SuplesiBPJSKabupaten'];
        $dateNow = Utils::datenowcreateNotFull();
        // persiapkan curl
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS_REFF . "kecamatan/kabupaten/$SuplesiBPJSKabupaten");
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
        // set time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));

            //echo json_encode($output);
            foreach ($ResultEncriptLzString['1']['list'] as $key => $jsons) { // This will search in the 2 jsons
                $pasing['id'] = $jsons['kode'];
                $pasing['text'] = $jsons['nama'];
                $datas[] = $pasing;
            }
            return $datas;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']

            );
            return $callback;
        }
    }
    function GoCreateSEP($data)
    {
        $curl = curl_init();
        $JenisRujukanFaskesBPJS = $data['JenisFaskesKodeBPJS'];
        $JenisFaskesNamaBPJS = $data['JenisFaskesNamaBPJS'];
        $idPesertaBPJS = $data['nokartubpjs'];
        $idppkrujukanBPJS = $data['idppkrujukanBPJS'];
        $namappkrujukanBPJS = $data['namappkrujukanBPJS'];
        $nokartubpjs = $data['nokartubpjs'];
        // $norujukanBPJS = $data['norujukanBPJS'];
        $nonikktpBPJS = $data['nonikktpBPJS'];
        $statuspesertaBPJS = $data['statuspesertaBPJS'];
        $namapesertaBPJS = $data['namapesertaBPJS'];
        $keteranganprbBPJS = $data['keteranganprbBPJS'];
        $idhakKelasBPJS = $data['idhakKelasBPJS'];
        if ($idhakKelasBPJS == "1") {
            $idhakKelasBPJSx = "Kelas 1";
        } elseif ($idhakKelasBPJS == "2") {
            $idhakKelasBPJSx = "Kelas 2";
        } else if ($idhakKelasBPJS == "3") {
            $idhakKelasBPJSx = "Kelas 3";
        }
        $hakKelasBPJS = $data['hakKelasBPJS'];
        $cobnosuratBPJS = $data['cobnosuratBPJS'];
        $idfaskesBPJS = $data['idfaskesBPJS'];

        $namafaskesBPJS = $data['namafaskesBPJS'];
        $cobNamaAsuransiBPJS = $data['cobNamaAsuransiBPJS'];
        $norujukan = $data['norujukan'];
        //$kdjenispelayananbpjsBPJS = $data['kdjenispelayananbpjsBPJS'];
        //$nmjenispelayananbpjsBPJS = $data['nmjenispelayananbpjsBPJS'];
        $kdkelasperawatanBPJS = $data['kdkelasperawatanBPJS'];
        //$nmkelasperawatanBPJS = $data['nmkelasperawatanBPJS'];
        $TglSEP = $data['TglSEP'];
        $KodeDiagnosaBPJS = $data['KodeDiagnosaBPJS'];
        $NamaDiagnosaBPJS = $data['NamaDiagnosaBPJS'];
        // $KodePoliklinikBPJS = "ANA";
        $KodePoliklinikBPJS =  $data['KodePoliklinikBPJS'];
        $NamaPoliklinikBPJS = $data['NamaPoliklinikBPJS'];
        $isJenisPelayananBPJS = $data['isJenisPelayananBPJS'];
        $KodeDokterBPJS = $data['KodeDokterBPJS'];
        $NamaDokterBPJS = $data['NamaDokterBPJS'];
        $isCobBPJS = $data['isCobBPJS'];
        $iscatarakBPJS = $data['iscatarakBPJS'];
        $NoSuratKontrolBPJS = $data['NoSuratKontrolBPJS'];
        $iscatatanBPJS = $data['iscatatanBPJS'];
        $LakaLantasBPJS = $data['LakaLantasBPJS'];
        //$TglKejadianBPJS =   $data['TglKejadianBPJS'] == "" ? "1990-01-01" : $data['TglKejadianBPJS'];
        $TglKejadianBPJS =   $data['TglKejadianBPJS'];
        //$LakaLantasBPJS = $data['LakaLantasBPJS'];
        $LakaLantasKetBPJS = $data['LakaLantasKetBPJS'];
        $SuplesiBPJS = $data['SuplesiBPJS'];
        $NoSuplesiBPJS = $data['NoSuplesiBPJS'];
        $SuplesiBPJSProvinsi = $data['SuplesiBPJSProvinsi'];
        $SuplesiBPJSProvinsiName  = $data['SuplesiBPJSProvinsiName'];
        $SuplesiBPJSKabupaten = $data['SuplesiBPJSKabupaten'];
        $SuplesiBPJSKabupatenName = $data['SuplesiBPJSKabupatenName'];
        $SuplesiBPJSKecamatan = $data['SuplesiBPJSKecamatan'];
        $SuplesiBPJSKecamatanName = $data['SuplesiBPJSKecamatanName'];
        $isNaikKelasBPJS = $data['isNaikKelasBPJS'];
        $PenanggungJawabBiaya = $data['PenanggungJawabBiaya'];
        $PembiayaanNiakKelasBPJS = $data['PembiayaanNiakKelasBPJS'];
        $NoMRBPJS = $data['NoMRBPJS'];
        $TglRujukan = $data['TglRujukan'] == "" ? "1990-01-01" : $data['TglRujukan'];
        $isEksekutifBPJS = $data['isEksekutifBPJS'];
        $TujuanKunjunganBPJS = $data['TujuanKunjunganBPJS'];
        $FlagProcedureBPJS = $data['FlagProcedureBPJS'];
        $PenujangBPJS = $data['PenujangBPJS'];
        $AsesmentPelayananBPJS  = $data['AsesmentPelayananBPJS'];
        $NoHpBPJS  = $data['NoHpBPJS'];
        $NoRegistrasiSIMRSBPJS  = $data['NoRegistrasiSIMRSBPJS'];
        $jenisKelaminKodeBPJS  = $data['jenisKelaminKodeBPJS'];
        $jenisKelaminNamaBPJS  = $data['jenisKelaminNamaBPJS'];
        $jenisPesertaKodeBPJS  = $data['jenisPesertaKodeBPJS'];
        $jenisPesertaNamaBPJS  = $data['jenisPesertaNamaBPJS'];
        $HakKelasBPJS = $data['hakKelasBPJS'];
        $PRB = $data['keteranganprbBPJS'];

        $TglTMTBPJS = $data['TglTMTBPJS'];
        $TglLahirBPJS = $data['TglLahirBPJS'];
        $session = SessionManager::getCurrentSession();
        $userid = $session->username;
        $token = $session->token;
        $namauserx = $session->name;
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        $dateNows = Utils::seCurrentDateTime();
        $datenownotfull = Utils::datenowcreateNotFull();


        if ($isJenisPelayananBPJS == "2") {
            if ($kdkelasperawatanBPJS <> "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Pasien Rawat Jalan, Naik kelas hanya untuk Pasien Rawat Inap !',
                );
                echo json_encode($callback);
                exit;
            }
        }
        if ($idPesertaBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'No. Kartu Pasien kosong !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($TglSEP == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Tgl Pembuatan SEP kosong !',
            );
            echo json_encode($callback);
            exit;
        }

        // if($TglSEP < $datenownotfull){
        //     $callback = array(
        //         'status' => 'warning',
        //         'errorname' => 'Tgl Pembuatan SEP lebih Kecil dari Tanggal Sekarang !',
        //     );
        //     echo json_encode($callback);
        //     exit;
        // }
        if ($TglSEP > $datenownotfull) {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Tgl Pembuatan SEP lebih besar dari Tanggal Sekarang !',
            );
            echo json_encode($callback);
            exit;
        }
        // // if ($TglSEP > $TglTMTBPJS) {
        // //     $callback = array(
        // //         'status' => 'warning',
        // //         'errorname' => 'Tgl Pembuatan SEP lebih Besar dari Tanggal TMT !',
        // //     );
        // //     echo json_encode($callback);
        // //     exit;
        // }
        if ($TglRujukan > $TglSEP) {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Tgl Rujukan lebih besar dari Tanggal Pembuatan SEP !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($isJenisPelayananBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Jenis Pelayanan kosong !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($idhakKelasBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Hak Kelas BPJS kosong !',
            );
            echo json_encode($callback);
            exit;
        }


        if ($NoMRBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'No. MR Pasien kosong !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($NoHpBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'No. HP Pasien kosong !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($KodeDiagnosaBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Kode Diagnosa kosong !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($JenisRujukanFaskesBPJS == "1") {
            if ($KodePoliklinikBPJS == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Kode Poliklinik kosong !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($isJenisPelayananBPJS == "1") {
                $DpjpPelayanan = "";
                $KodePoliklinikBPJS = "";
                $NamaPoliklinikBPJS = "";
            } else {
                $DpjpPelayanan = $KodeDokterBPJS;
                if ($DpjpPelayanan == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Kode Dokter kosong !',
                    );
                    echo json_encode($callback);
                    exit;
                }
            }
        } else {
            if ($isJenisPelayananBPJS == "1") {
                $DpjpPelayanan = "";
                $KodePoliklinikBPJS = "";
                $NamaPoliklinikBPJS = "";
            } else {
                $DpjpPelayanan = $KodeDokterBPJS;
                if ($DpjpPelayanan == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Kode Dokter kosong !',
                    );
                    echo json_encode($callback);
                    exit;
                }
            }
        }
        if ($LakaLantasBPJS <> "0") {
            if ($TglKejadianBPJS == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Tgl Kecelakaan Kosong !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($TglKejadianBPJS > $TglSEP) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Tgl Kecelakaan lebih besar dari Tanggal Pembuatan SEP !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($LakaLantasKetBPJS == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Keterangan Laka Lantas Kosong !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($SuplesiBPJS <> "0") {
                if ($NoSuplesiBPJS == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'No. Supplesi Kosong !',
                    );
                    echo json_encode($callback);
                    exit;
                }
                if ($SuplesiBPJSProvinsi == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Supplesi Provinsi Kosong !',
                    );
                    echo json_encode($callback);
                    exit;
                }
                if ($SuplesiBPJSKabupaten == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Supplesi Kabupaten Kosong !',
                    );
                    echo json_encode($callback);
                    exit;
                }
                if ($SuplesiBPJSKecamatan == "") {
                    $callback = array(
                        'status' => 'warning',
                        'errorname' => 'Supplesi Kecamatan Kosong !',
                    );
                    echo json_encode($callback);
                    exit;
                }
            }
        }
        if ($KodeDokterBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Kode Dokter kosong !',
            );
            echo json_encode($callback);
            exit;
        }

        if ($iscatatanBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Catatan kosong !',
            );
            echo json_encode($callback);
            exit;
        }
        // if ($TujuanKunjunganBPJS == "") {
        //     $callback = array(
        //         'status' => 'warning',
        //         'errorname' => 'Tujuan Kunjungan kosong !',
        //     );
        //     echo json_encode($callback);
        //     exit;
        // }


        // send antrian 
        if ($isJenisPelayananBPJS == "1") {
            goto createsepx;
        } else{
            if($KodePoliklinikBPJS == "IGD" || $KodePoliklinikBPJS == "HDL"){
                goto createsepx;
            }else{
                goto sendantrian;
            }
        }

        sendantrian:
        $Antrian_kodebooking = $NoRegistrasiSIMRSBPJS; 
        $Antrian_NamaJaminan = $data['shownamaperusahaanfix'];
        
        if ($Antrian_kodebooking == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Masukan Kode Booking !',
            );
            echo json_encode($callback);
            exit;
        }

        // GET TOTAL KUNJUNGAN KE
                
        $urlApi = "Rujukan/JumlahSEP/$JenisRujukanFaskesBPJS/$norujukan";
        // persiapkan curl
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS . $urlApi);
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
        // set time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            // $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
      
            $jumlahsep = $ResultEncriptLzString['1']['jumlahSEP'];
            if($jumlahsep < 1){
                if($JenisRujukanFaskesBPJS == '1' ){ // kunjungan pertama faskes pertama
                    $jeniskunjungan = '1';
                }elseif($JenisRujukanFaskesBPJS == '2' ){ // kunjungan pertama faskes kedua
                    $jeniskunjungan = '4';
                }
            }else{
                
                if($NoSuratKontrolBPJS <> null ){ // sama poli dan post ranap
                    $jeniskunjungan = '3';
                }if($NoSuratKontrolBPJS === null ){ // beda poli
                    $jeniskunjungan = '2';
                } 
            } 

        } else {
           // if($NoSuratKontrolBPJS <> null ){ // sama poli dan post ranap
           //     $jeniskunjungan = '3';
           // }if($NoSuratKontrolBPJS === null ){ // beda poli
                $jeniskunjungan = '2';
            //} 
        } 
        // $AntrolJenisKunungan = $jeniskunjungan;
        
        
        // get jumlah SEP
        // GET SEP
        if ($Antrian_NamaJaminan === "BPJS Kesehatan") {
            // $this->db->query("SELECT CC.[Mobile Phone] as Medrec_HomePhone,A.ID,A.NO_SEP,A.NO_REGISTRASI,A.NO_MR,A.NO_RUJUKAN,
            //                 A.NO_SPRI,A.NO_NIK,A.NO_KARTU,replace(CONVERT(VARCHAR(11), A.TGL_SEP, 111), '/','-') as TGL_SEP,
            //                 A.KODE_POLI,A.NAMA_POLI,A.KODE_DOKTER,A.NAMA_DOKTER,A.BATAL,
            //                 B.JamPraktek,b.NoAntrianAll,a.NO_KARTU,a.NO_TELEPON
			// 				,replace(CONVERT(VARCHAR(11), CC.InputDate, 111), '/','-') as TglMR,
			// 				CASE WHEN replace(CONVERT(VARCHAR(11), CC.InputDate, 111), '/','-')=replace(CONVERT(VARCHAR(11), A.TGL_SEP, 111), '/','-') 
			// 				THEN '1' ELSE '0' END AS MR_ISNEW,dd.codeBPJS as kodeunitbpjs,dd.NamaBPJS , ee.ID_Dokter_BPJS,ee.First_Name as namadokter,b.ID_JadwalPraktek
            //                 ,b.jampraktek as SessionPoli,EE.ID  as IdDokterSIMRS,ee.NAMA_Dokter_BPJS
            //                 FROM PerawatanSQL.DBO.BPJS_T_SEP A
            //                 INNER JOIN PerawatanSQL.DBO.Visit B ON A.NO_SEP = B.NoSEP 
            //                 AND A.NO_REGISTRASI = B.NoRegistrasi
			// 				INNER JOIN MasterdataSQL.DBO.Admision CC ON CC.NoMR = b.NoMR
            //                 INNER JOIN MasterdataSQL.DBO.MstrUnitPerwatan DD ON DD.ID = B.Unit
            //                 INNER JOIN MasterdataSQL.DBO.Doctors EE ON EE.ID = B.Doctor_1
            //                 WHERE A.NO_SEP=:NoSep AND A.NO_REGISTRASI=:kodebooking");
             $this->db->query("SELECT CC.[Mobile Phone] as Medrec_HomePhone,B.NoRegistrasi AS NO_REGISTRASI, B.NoMR AS NO_MR, CC.ID_Card_number AS NO_NIK, 
                            REPLACE(CONVERT(VARCHAR(11), B.[Visit Date], 111), '/', '-') AS TGL_REGIS, DD.CodeSubBPJS AS KODE_POLI, 
                            DD.NamaBPJS AS NAMA_POLI, EE.ID_Dokter_BPJS AS KODE_DOKTER, EE.NAMA_Dokter_BPJS AS NAMA_DOKTER, 
                            B.JamPraktek, B.NoAntrianAll, CC.[Mobile Phone] AS NO_TELEPON, 
                            REPLACE(CONVERT(VARCHAR(11), CC.InputDate, 111), '/', '-') AS TglMR, 
                            CASE WHEN replace(CONVERT(VARCHAR(11), CC.InputDate, 111), '/', '-') = replace(CONVERT(VARCHAR(11), B.[Visit Date], 111), '/', '-') 
                            THEN '1' ELSE '0' END AS MR_ISNEW, 
                            DD.codeBPJS AS kodeunitbpjs, DD.NamaBPJS, EE.ID_Dokter_BPJS, 
                            EE.First_Name AS namadokter, B.ID_JadwalPraktek, B.JamPraktek AS SessionPoli, 
                            EE.ID AS IdDokterSIMRS, EE.NAMA_Dokter_BPJS, FF.Company 
                            FROM PerawatanSQL.dbo.Visit AS B INNER JOIN
                            MasterdataSQL.dbo.Admision AS CC ON CC.NoMR = B.NoMR INNER JOIN
                            MasterdataSQL.dbo.MstrUnitPerwatan AS DD ON DD.ID = B.Unit INNER JOIN
                            MasterdataSQL.dbo.Doctors AS EE ON EE.ID = B.Doctor_1 LEFT OUTER JOIN
                            PerawatanSQL.dbo.Apointment AS FF ON FF.NoRegistrasi = B.NoRegistrasi
                            WHERE  B.NoRegistrasi=:kodebooking");
            $this->db->bind('kodebooking', $Antrian_kodebooking);
            $antrian_getRegistrasi =  $this->db->single();
            $jenispasien = "JKN";
        }  
        
        $nokartubpjs = $idPesertaBPJS;
        // $NAMA_Dokter_BPJS = $antrian_getRegistrasi['NAMA_Dokter_BPJS'];
        $nonikktpBPJS = $antrian_getRegistrasi['NO_NIK'];
        $NoMRBPJS = $antrian_getRegistrasi['NO_MR'];
        $NoHpBPJS  = $antrian_getRegistrasi['NO_TELEPON'];
        $KodePoliklinikBPJS =  $antrian_getRegistrasi['kodeunitbpjs'];
        $NamaPoliklinikBPJS = $antrian_getRegistrasi['NamaBPJS'];
        $pasienbaru = $antrian_getRegistrasi['MR_ISNEW'];
        $TglSEP = $antrian_getRegistrasi['TGL_REGIS'];
        $KodeDokterBPJS = $antrian_getRegistrasi['ID_Dokter_BPJS'];
        $NamaDokterBPJS = $antrian_getRegistrasi['namadokter'];
        $NO_SPRI = $NoSuratKontrolBPJS;
        $NO_RUJUKAN = $data['norujukan'];
        $Medrec_HomePhone  = $antrian_getRegistrasi['Medrec_HomePhone'];
        $nomorantrean = $antrian_getRegistrasi['NoAntrianAll'];
        $IDJadwal = $antrian_getRegistrasi['ID_JadwalPraktek'];
        $SessionPoli = $antrian_getRegistrasi['SessionPoli'];
        $IdDokterSIMRS = $antrian_getRegistrasi['IdDokterSIMRS'];
        $arraynomorantrean = preg_split("/\-/", $nomorantrean);
        $angkaantrean = $arraynomorantrean[1];
      

        //waktu
        $datename  = date("l", strtotime($TglSEP));
        $this->db->query("SELECT Senin_Waktu,Selasa_Waktu,Rabu_Waktu,
                        Kamis_Waktu,Jumat_Waktu,Sabtu_Waktu,Minggu_Waktu,
                        Senin_Max_NonJKN,Senin_Max_JKN,Selasa_Max_JKN,Selasa_Max_NonJKN,Rabu_Max_JKN,Rabu_Max_NonJKN,
                        Kamis_Max_JKN,Kamis_Max_NonJKN,Jumat_Max_JKN,Jumat_Max_NonJKN,Sabtu_Max_JKN,Sabtu_Max_NonJKN,
                        Minggu_Max_JKN,Minggu_Max_NonJKN
                        FROM MasterdataSQL.DBO.JadwalPraktek WHERE ID=:IDJadwal");
        $this->db->bind('IDJadwal', $IDJadwal);
        $dtjdwl =  $this->db->single();
        $jampraktek = $dtjdwl['Minggu_Waktu'];
        if ($datename == "Sunday") {
            $jampraktek = $dtjdwl['Minggu_Waktu'];
            $Max_NonJKN = $dtjdwl['Minggu_Max_NonJKN'];
            $Max_JKN = $dtjdwl['Minggu_Max_JKN'];
        } elseif ($datename == "Monday") {
            $jampraktek = $dtjdwl['Senin_Waktu'];
            $Max_NonJKN = $dtjdwl['Senin_Max_NonJKN'];
            $Max_JKN = $dtjdwl['Senin_Max_JKN'];
        } elseif ($datename == "Tuesday") {
            $jampraktek = $dtjdwl['Selasa_Waktu'];
            $Max_NonJKN = $dtjdwl['Selasa_Max_NonJKN'];
            $Max_JKN = $dtjdwl['Selasa_Max_JKN'];
        } elseif ($datename == "Wednesday") {
            $jampraktek = $dtjdwl['Rabu_Waktu'];
            $Max_NonJKN = $dtjdwl['Rabu_Max_NonJKN'];
            $Max_JKN = $dtjdwl['Rabu_Max_JKN'];
        } elseif ($datename == "Thursday") {
            $jampraktek = $dtjdwl['Kamis_Waktu'];
            $Max_NonJKN = $dtjdwl['Kamis_Max_NonJKN'];
            $Max_JKN = $dtjdwl['Kamis_Max_JKN'];
        } elseif ($datename == "Friday") {
            $jampraktek = $dtjdwl['Jumat_Waktu'];
            $Max_NonJKN = $dtjdwl['Jumat_Max_NonJKN'];
            $Max_JKN = $dtjdwl['Jumat_Max_JKN'];
        } elseif ($datename == "Saturday") {
            $jampraktek = $dtjdwl['Sabtu_Waktu'];
            $Max_NonJKN = $dtjdwl['Sabtu_Max_NonJKN'];
            $Max_JKN = $dtjdwl['Sabtu_Max_JKN'];
        }

        // Jumlah antrian Saat ini
        $this->db->query("SELECT COUNT(ID) AS JUMLAHJKN FROM PerawatanSQL.DBO.Visit
                where replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-')=:ApmDate
                and Doctor_1=:DoctorID and JamPraktek=:JamPraktek and batal='0'
                and perusahaan='313' and PatientType='5'");
        $this->db->bind('JamPraktek', $SessionPoli);
        $this->db->bind('DoctorID', $IdDokterSIMRS);
        $this->db->bind('ApmDate', $TglSEP);
        $datallantrian =  $this->db->single();
        $JUMLAHJKN = $datallantrian['JUMLAHJKN'];

        $this->db->query("SELECT COUNT(ID) AS JUMLAHNONJKN FROM PerawatanSQL.DBO.Visit
                        where replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-')=:ApmDate and Doctor_1=:DoctorID 
                        and JamPraktek=:JamPraktek and batal='0'
                        and id not in(
                                SELECT ID  FROM PerawatanSQL.DBO.Visit
                                where replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-')=:ApmDate2 
                                and Doctor_1=:DoctorID2 and JamPraktek=:JamPraktek2 and batal='0'
                                and perusahaan='313' and PatientType='5'
                        ) ");
        $this->db->bind('JamPraktek', $SessionPoli);
        $this->db->bind('JamPraktek2', $SessionPoli);
        $this->db->bind('DoctorID', $IdDokterSIMRS);
        $this->db->bind('DoctorID2', $IdDokterSIMRS);
        $this->db->bind('ApmDate', $TglSEP);
        $this->db->bind('ApmDate2', $TglSEP);
        $datasdhpgl =  $this->db->single();
        $JUMLAHNONJKN = $datasdhpgl['JUMLAHNONJKN'];

        $sisakuotajkn = $Max_JKN - $JUMLAHJKN;
        $sisakuotanonjkn = $Max_NonJKN - $JUMLAHNONJKN;

        $keterangan = "Peserta harap 30 menit lebih awal guna pencatatan administrasi.";

        $session = SessionManager::getCurrentSession();
        $userid = $session->username;
        $token = $session->token;
        $namauserx = $session->name;
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS_Antrian($tStamp);
        $dateNows = Utils::seCurrentDateTime();
        $datenownotfull = Utils::datenowcreateNotFull();
       

        

        // cek apakah kode booking dari jkn, jika dari jkn kode booking dari apointment
        // jika tidak maka ambil noregistrasinya
        $this->db->query("SELECT NoRegistrasi,NoBooking 
        FROM PerawatanSQL.DBO.Apointment WHERE NoRegistrasi=:NoRegistrasi and Company = :Company ");
        $this->db->bind('NoRegistrasi', $Antrian_kodebooking);
        $this->db->bind('Company', 'JKN MOBILE');
        $dtaptmn =  $this->db->single();
        $dtrowCount =  $this->db->rowCount();
        if ($dtrowCount) {
            $kodeBookingSendAntrian = $dtaptmn['NoBooking'];
        } else {
            $kodeBookingSendAntrian = $Antrian_kodebooking;
        }

         // update ke tabel sep dulu untuk waktu task nya....
        // cek dulu log nya ada gak di task1
            $this->db->query("SELECT DATE_CREATE 
                            from PerawatanSQL.dbo.BPJS_TASKID_LOG where 
                            KODE_TRANSAKSI=:xkodebooking and TASK_ID='1'");
            $this->db->bind('xkodebooking', $kodeBookingSendAntrian);
            $this->db->execute();
            $dataTask1Exist =  $this->db->single();
            $rowdataTask1Exist =  $this->db->rowCount();
            if ($rowdataTask1Exist) {
                $valuewaktutask1temp = $dataTask1Exist['DATE_CREATE'];
            } else {
                $valuewaktutask1temp = Utils::seCurrentDateTime();
            }


        $this->db->query("SELECT DATEADD(minute,-3,Task2) as Task1 ,Task2,task1 as task1asli,TGL_CREATE
                        FROM PerawatanSQL.DBO.BPJS_T_SEP
                        WHERE NO_REGISTRASI=:kodebookingx ");
        $this->db->bind('kodebookingx', $Antrian_kodebooking);
        $this->db->execute();
        $datarow =  $this->db->single();

        if ($datarow['task1asli'] == null) {

            // if ($datarow['Task2'] == null) {
                $this->db->query("SELECT DATEADD(minute,2,[Visit Date]) as fixTask2
                FROM PerawatanSQL.DBO.Visit
                WHERE NoRegistrasi=:noreg ");
                $this->db->bind('noreg', $Antrian_kodebooking);
                $this->db->execute();
                $datarowRegFix =  $this->db->single();
                $valuewaktutask1 = $datarowRegFix['fixTask2'];

            // }else{
                // $valuewaktutask1 = $datarow['TGL_CREATE'];
            // }
                $this->db->query("UPDATE PerawatanSQL.DBO.BPJS_T_SEP SET Task1=:task4time
                                    WHERE NO_REGISTRASI=:kodebookingx");
                $this->db->bind('kodebookingx', $Antrian_kodebooking);
                $this->db->bind('task4time', $valuewaktutask1);
                $this->db->execute();
        }else{
             $valuewaktutask1 = $datarow['task1asli'];
        }

        // set waktu 
        $estimasi2 = strtotime($valuewaktutask1);
        $estimasidilayani = $estimasi2 * 1000;
 
        //if($AntrolJenisKunungan == "1"){ //Rujukan FKTP
        //    $noreff = $NO_RUJUKAN;
        //}elseif($AntrolJenisKunungan == "2"){ //Rujukan Internal
              $genOtp = random_int(10000, 99999);
              $date = Utils::idtrsByDateOnly();
              $noreff =  "0114R067".$date.$genOtp;
       // }elseif($AntrolJenisKunungan == "3"){ //Kontrol 0114R067070824116747
        //    $noreff = $NO_SPRI;
        //}elseif($AntrolJenisKunungan == "4"){ //Rujukan Antar RS
       //     $noreff = $NO_RUJUKAN;
        //}
        
        curl_setopt_array($curl, array(
            CURLOPT_URL =>  URL_BPJS_ANTRIAN . 'antrean/add',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                        "kodebooking": "' . $kodeBookingSendAntrian . '",
                        "jenispasien": "' . $jenispasien . '",
                        "nomorkartu": "' . $nokartubpjs . '",
                        "nik": "' . $nonikktpBPJS . '",
                        "nohp": "' . $Medrec_HomePhone . '",
                        "kodepoli": "' . $KodePoliklinikBPJS . '",
                        "namapoli": "' . $NamaPoliklinikBPJS . '",
                        "pasienbaru": "' . $pasienbaru . '",
                        "norm":"' . $NoMRBPJS . '",
                        "tanggalperiksa": "' . $TglSEP . '",
                        "kodedokter": "' . $KodeDokterBPJS . '",
                        "namadokter": "' . $NamaDokterBPJS . '",
                        "jampraktek": "' . $jampraktek . '",
                        "jeniskunjungan": "2",
                        "nomorreferensi": "' . $noreff . '",
                        "nomorantrean": "' . $nomorantrean . '",
                        "angkaantrean": "' . $angkaantrean . '",
                        "estimasidilayani": "' . $estimasidilayani . '",
                        "sisakuotajkn": "' . $sisakuotajkn . '",
                        "kuotajkn": "' . $Max_JKN . '",
                        "sisakuotanonjkn": "' . $sisakuotanonjkn . '",
                        "kuotanonjkn": "' . $Max_NonJKN . '",
                        "keterangan": "' . $keterangan . '"
                        }',
            CURLOPT_HTTPHEADER => $headerbpjs,
        ));
        $output = curl_exec($curl);
        // tutup curl 
        curl_close($curl);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metadata']['code'] == "200") {

            $curl = curl_init();
            $taskid = "1";

            curl_setopt_array($curl, array(
                CURLOPT_URL =>  URL_BPJS_ANTRIAN . 'antrean/updatewaktu',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '                                                
                    {
                        "kodebooking": "' . $kodeBookingSendAntrian . '",
                        "taskid":  "' . $taskid . '",
                        "waktu": "' . $estimasidilayani . '"
                    }
                        ',
                CURLOPT_HTTPHEADER => $headerbpjs,
            ));
            $output = curl_exec($curl);
            // tutup curl 
            curl_close($curl);
            // ubah string JSON menjadi array
            $JsonData = json_decode($output, TRUE);
            if ($JsonData['metadata']['code'] == "200") {
                $this->db->query("INSERT INTO perawatanSQL.dbo.BPJS_TASKID_LOG 
                                    (KODE_TRANSAKSI,WAKTU,TASK_ID,DATE_CREATE) 
                                    VALUES 
                                    (:kodebooking,:waktu,:taskid,:DATE_CREATE)");
                $this->db->bind('kodebooking', $kodeBookingSendAntrian);
                $this->db->bind('waktu', $estimasidilayani);
                $this->db->bind('taskid', $taskid);
                $this->db->bind('DATE_CREATE', $valuewaktutask1);
                $this->db->execute();

                goto createsepx;

            }
 
        } else {
            if($JsonData['metadata']['message'] == "Terdapat duplikasi Kode Booking"){
                goto createsepx;
            }else{
                $callback = array(
                    'status' => 'warning',
                    'errorname' => $JsonData['metadata']['message']. ". \n\n Jumlah SEP :" . $jumlahsep. "\nJenis Faskes : ".$JenisRujukanFaskesBPJS. "\n Jenis Kunjungan : ".  $jeniskunjungan ,
                    'KodeDokterBPJS' => $KodeDokterBPJS,
                    'NamaDokterBPJS' => $NamaDokterBPJS,
                    'datename' => $datename
                );
                return $callback;
            }
            
        }

        // create sep
        createsepx:

        $curlsep = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjssep = Utils::headerBPJS_BPJS($tStamp);


        curl_setopt_array($curlsep, array(
            CURLOPT_URL =>  URL_BPJS . 'SEP/2.0/insert',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "request":{
              "t_sep":{
                 "noKartu":"' . $idPesertaBPJS . '",
                 "tglSep":"' . $TglSEP . '",
                 "ppkPelayanan":"0114R067",
                 "jnsPelayanan":"' . $isJenisPelayananBPJS . '",
                 "klsRawat":{
                    "klsRawatHak":"' . $idhakKelasBPJS . '",
                    "klsRawatNaik":"' . $kdkelasperawatanBPJS . '",
                    "pembiayaan":"' . $PembiayaanNiakKelasBPJS . '",
                    "penanggungJawab":"' . $PenanggungJawabBiaya . '"
                 },
                 "noMR":"' . $NoMRBPJS . '",
                 "rujukan":{
                    "asalRujukan":"' . $JenisRujukanFaskesBPJS . '",
                    "tglRujukan":"' . $TglRujukan . '",
                    "noRujukan":"' . $norujukan . '",
                    "ppkRujukan":"' . $idppkrujukanBPJS . '"
                 },
                 "catatan":"' . $iscatatanBPJS . '",
                 "diagAwal":"' . $KodeDiagnosaBPJS . '",
                 "poli":{
                    "tujuan":"' . $KodePoliklinikBPJS . '",
                    "eksekutif":"' . $isEksekutifBPJS . '"
                 },
                 "cob":{
                    "cob":"' . $isCobBPJS . '"
                 },
                 "katarak":{
                    "katarak":"' . $iscatarakBPJS . '"
                 },
                 "jaminan":{
                    "lakaLantas":"' . $LakaLantasBPJS . '",
                    "penjamin":{
                       "tglKejadian":"' . $TglKejadianBPJS . '",
                       "keterangan":"' . $LakaLantasKetBPJS . '",
                       "suplesi":{
                          "suplesi":"' . $SuplesiBPJS . '",
                          "noSepSuplesi":"' . $NoSuplesiBPJS . '",
                          "lokasiLaka":{
                             "kdPropinsi":"' . $SuplesiBPJSProvinsi . '",
                             "kdKabupaten":"' . $SuplesiBPJSKabupaten . '",
                             "kdKecamatan":"' . $SuplesiBPJSKecamatan . '"
                          }
                       }
                    }
                 },
                 "tujuanKunj":"' . $TujuanKunjunganBPJS . '",
                 "flagProcedure":"' . $FlagProcedureBPJS . '",
                 "kdPenunjang":"' . $PenujangBPJS . '",
                 "assesmentPel":"' . $AsesmentPelayananBPJS . '",
                 "skdp":{
                    "noSurat":"' . $NoSuratKontrolBPJS . '",
                    "kodeDPJP":"' . $KodeDokterBPJS . '"
                 },
                 "dpjpLayan":"' . $DpjpPelayanan . '",
                 "noTelp":"' . $NoHpBPJS . '",
                 "user":"' . $namauserx . '"
              }
           }
        }',
            CURLOPT_HTTPHEADER => $headerbpjssep,
        ));
        $output = curl_exec($curlsep);
        // tutup curl 
        curl_close($curlsep);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            // $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, Utils::setKey());
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            $JsonDatax   = json_decode(json_encode($ResultEncriptLzString), true);
            $nosep = $JsonDatax['1']['sep']['noSep'];
            if (substr($NoRegistrasiSIMRSBPJS, 0, 2) == "RJ") {
                $this->db->query("UPDATE perawatanSQL.dbo.Visit SET 
                NoSEP=:nosep,NoPesertaBPJS=:NO_KARTU,HakKelasBPJS=:HakKelasBPJS,PRB=:PRB
                WHERE NoRegistrasi=:noregistrasi");
                $this->db->bind('nosep', $nosep);
                $this->db->bind('noregistrasi', $NoRegistrasiSIMRSBPJS);
                $this->db->bind('NO_KARTU', $idPesertaBPJS);
                $this->db->bind('HakKelasBPJS', $HakKelasBPJS);
                $this->db->bind('PRB', $PRB);

                $this->db->execute();

                //UPDATE DASHBOARD
                $this->db->query("UPDATE MasterdataSQL.dbo.Doctors SET 
                NAMA_Dokter_BPJS=:NAMA_Dokter_BPJS,ID_Dokter_BPJS=:ID_Dokter_BPJS
                WHERE ID=:ID_DOKTER and NAMA_Dokter_BPJS is null and ID_Dokter_BPJS IS NULL ");
                $this->db->bind('NAMA_Dokter_BPJS', $NamaDokterBPJS);
                $this->db->bind('ID_Dokter_BPJS', $KodeDokterBPJS);
                $this->db->bind('ID_DOKTER', $data['dokterid']);
                $this->db->execute();

                //update nama dokter
                $this->db->query("UPDATE DashboardData.dbo.dataRWJ SET 
                NoSep=:nosep,NoPesertaBPJS=:NO_KARTU,HakKelasBPJS=:HakKelasBPJS,PRB=:PRB
                WHERE NoRegistrasi=:noregistrasi");
                $this->db->bind('nosep', $nosep);
                $this->db->bind('noregistrasi', $NoRegistrasiSIMRSBPJS);
                $this->db->bind('NO_KARTU', $idPesertaBPJS);
                $this->db->bind('HakKelasBPJS', $HakKelasBPJS);
                $this->db->bind('PRB', $PRB);
                $this->db->execute();
            } elseif (substr($NoRegistrasiSIMRSBPJS, 0, 2) == "RI") {
                $this->db->query("UPDATE RawatInapSQL.DBO.Inpatient SET 
                NoSEP=:nosep,HakKelasBPJS=:HakKelasBPJS,PRB=:PRB
                WHERE NoRegRI=:noregistrasi");
                $this->db->bind('nosep', $nosep);
                $this->db->bind('noregistrasi', $NoRegistrasiSIMRSBPJS);
                $this->db->bind('HakKelasBPJS', $HakKelasBPJS);
                $this->db->bind('PRB', $PRB);
                $this->db->execute();
            }
            if ($isJenisPelayananBPJS == "1") {
                $namaJenislay = "R. Inap";
            } else {
                $namaJenislay = "R. Jalan";
            }
            
            $this->db->query("INSERT INTO perawatanSQL.dbo.BPJS_T_SEP (NO_SEP,NO_REGISTRASI,NO_KARTU,TGL_SEP,
                            NO_MR,NAMA_PESERTA,JENIS_KELAMIN,JENIS_PESERTA
                            ,COB,JENIS_RAWAT
                            ,KODE_POLI,NAMA_POLI,KODE_DOKTER,NAMA_DOKTER,
                            KODE_DIAGNOSA,NAMA_DIAGNOSA,NO_TELEPON,PENJAMIN,KELAS_RAWAT,CATATAN,TGL_LAHIR,
                            KODE_PERUJUK,NAMA_PERUJUK
                            ,NO_RUJUKAN,NO_SPRI,NO_NIK,KODE_JENIS_PESERTA,IS_EKSEKUTIF,IS_KATARAK,IS_COB,
                            COB_NO_ASURANSI,KODE_JENIS_RAWAT,NAIK_KELAS,NAIK_KELAS_ID,PENANGGUNG_JAWAB,KODE_KELAS_RAWAT
                            ,KODE_PPK_PERUJUK,NAMA_PPK_PERUJUK,KETERANGAN_PRB,TUJUAN_KUNJUNGAN,FLAG_PROCEDURE,PENUNJANG,
                            ASESMENT_PELAYANAN,IS_LAKA_LANTAS,TGL_LAKA_LANTAS,KET_LAKA_LANTAS,IS_SUPLESI,NO_SUPLESI,
                            PROV_KODE,PROV_NAMA,KABUPATEN_KODE,KABUPATEN_NAMA,KECAMATAN_KODE,KECAMATAN_NAMA
                            ,KODE_ASAL_FASKES,NAMA_ASAL_FASKES,TGL_RUJUKAN,TGL_CREATE,USER_CREATE)
                            VALUES 
                            (:NOSEP,:NO_REGISTRASI,:NO_KARTU,:TGL_SEP,
                            :NO_MR,:NAMA_PESERTA,:JENIS_KELAMIN,:JENIS_PESERTA
                            ,:COB,:JENIS_RAWAT
                            ,:KODE_POLI,:NAMA_POLI,:KODE_DOKTER,:NAMA_DOKTER,
                            :KODE_DIAGNOSA,:NAMA_DIAGNOSA,:NO_TELEPON,:PENJAMIN,:KELAS_RAWAT,:CATATAN,:TGL_LAHIR,
                            :KODE_PERUJUK,:NAMA_PERUJUK
                            ,:NO_RUJUKAN,:NO_SPRI,:NO_NIK,:KODE_JENIS_PESERTA,:IS_EKSEKUTIF,:IS_KATARAK,:IS_COB,
                            :COB_NO_ASURANSI,:KODE_JENIS_RAWAT,:NAIK_KELAS,:NAIK_KELAS_ID,:PENANGGUNG_JAWAB,:KODE_KELAS_RAWAT
                            ,:KODE_PPK_PERUJUK,:NAMA_PPK_PERUJUK,:KETERANGAN_PRB,:TUJUAN_KUNJUNGAN,:FLAG_PROCEDURE,:PENUNJANG,
                            :ASESMENT_PELAYANAN,:IS_LAKA_LANTAS,:TGL_LAKA_LANTAS,:KET_LAKA_LANTAS,:IS_SUPLESI,:NO_SUPLESI,
                            :PROV_KODE,:PROV_NAMA,:KABUPATEN_KODE,:KABUPATEN_NAMA,:KECAMATAN_KODE,:KECAMATAN_NAMA
                            ,:KODE_ASAL_FASKES,:NAMA_ASAL_FASKES,:TGL_RUJUKAN,:TGL_CREATE,:USER_CREATE)");
            $this->db->bind('TGL_CREATE', $dateNows);
            $this->db->bind('USER_CREATE', $namauserx);
            $this->db->bind('KODE_ASAL_FASKES', $JenisRujukanFaskesBPJS);
            $this->db->bind('NAMA_ASAL_FASKES', $JenisFaskesNamaBPJS);
            $this->db->bind('TGL_RUJUKAN', $TglRujukan);
            $this->db->bind('NOSEP', $nosep);
            $this->db->bind('NO_REGISTRASI', $NoRegistrasiSIMRSBPJS);
            $this->db->bind('NO_KARTU', $idPesertaBPJS);
            $this->db->bind('TGL_SEP', $TglSEP);
            $this->db->bind('NO_MR', $NoMRBPJS);
            $this->db->bind('NAMA_PESERTA', $namapesertaBPJS);
            $this->db->bind('JENIS_KELAMIN', $jenisKelaminNamaBPJS);
            $this->db->bind('JENIS_PESERTA', $jenisPesertaNamaBPJS);
            $this->db->bind('COB', $cobNamaAsuransiBPJS);
            $this->db->bind('JENIS_RAWAT', $namaJenislay);
            $this->db->bind('KODE_POLI', $KodePoliklinikBPJS);
            $this->db->bind('NAMA_POLI', $NamaPoliklinikBPJS);
            $this->db->bind('KODE_DOKTER', $KodeDokterBPJS);
            $this->db->bind('NAMA_DOKTER', $NamaDokterBPJS);
            $this->db->bind('KODE_DIAGNOSA', $KodeDiagnosaBPJS);
            $this->db->bind('NAMA_DIAGNOSA', $NamaDiagnosaBPJS);
            $this->db->bind('NO_TELEPON', $NoHpBPJS);
            $this->db->bind('PENJAMIN', $PembiayaanNiakKelasBPJS);
            $this->db->bind('KELAS_RAWAT', $hakKelasBPJS);
            $this->db->bind('CATATAN', $iscatatanBPJS);
            $this->db->bind('TGL_LAHIR', $TglLahirBPJS);
            $this->db->bind('KODE_PERUJUK', $idfaskesBPJS);
            $this->db->bind('NAMA_PERUJUK', $namafaskesBPJS);

            $this->db->bind('NO_RUJUKAN', $norujukan);
            $this->db->bind('NO_SPRI', $NoSuratKontrolBPJS);
            $this->db->bind('NO_NIK', $nonikktpBPJS);
            $this->db->bind('KODE_JENIS_PESERTA', $jenisPesertaKodeBPJS);
            $this->db->bind('IS_EKSEKUTIF', $isEksekutifBPJS);
            $this->db->bind('IS_KATARAK', $iscatarakBPJS);
            $this->db->bind('IS_COB', $isCobBPJS);
            $this->db->bind('COB_NO_ASURANSI', $cobnosuratBPJS);
            $this->db->bind('KODE_JENIS_RAWAT', $isJenisPelayananBPJS);
            $this->db->bind('NAIK_KELAS', $isNaikKelasBPJS);
            $this->db->bind('NAIK_KELAS_ID', $kdkelasperawatanBPJS);
            $this->db->bind('PENANGGUNG_JAWAB', $PenanggungJawabBiaya);
            $this->db->bind('KODE_KELAS_RAWAT', $idhakKelasBPJS);
            $this->db->bind('KODE_PPK_PERUJUK', $idppkrujukanBPJS);
            $this->db->bind('NAMA_PPK_PERUJUK', $namappkrujukanBPJS);
            $this->db->bind('KETERANGAN_PRB', $keteranganprbBPJS);
            $this->db->bind('TUJUAN_KUNJUNGAN', $TujuanKunjunganBPJS);
            $this->db->bind('FLAG_PROCEDURE', $FlagProcedureBPJS);
            $this->db->bind('PENUNJANG', $PenujangBPJS);
            $this->db->bind('ASESMENT_PELAYANAN', $AsesmentPelayananBPJS);
            $this->db->bind('IS_LAKA_LANTAS', $LakaLantasBPJS);
            $this->db->bind('TGL_LAKA_LANTAS', $TglKejadianBPJS);
            $this->db->bind('KET_LAKA_LANTAS', $LakaLantasKetBPJS);
            $this->db->bind('IS_SUPLESI', $SuplesiBPJS);
            $this->db->bind('NO_SUPLESI', $NoSuplesiBPJS);
            $this->db->bind('PROV_KODE', $SuplesiBPJSProvinsi);
            $this->db->bind('PROV_NAMA', $SuplesiBPJSProvinsiName);
            $this->db->bind('KABUPATEN_KODE', $SuplesiBPJSKabupaten);
            $this->db->bind('KABUPATEN_NAMA', $SuplesiBPJSKabupatenName);
            $this->db->bind('KECAMATAN_KODE', $SuplesiBPJSKecamatan);
            $this->db->bind('KECAMATAN_NAMA', $SuplesiBPJSKecamatanName);
            $this->db->execute();
            $callback = array(
                'status' => 'success',
                'hasil' => $ResultEncriptLzString,
                // 'sepsss' => $JsonDatax['1']['sep']['noSep']
            );
            return $callback;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message'],
                'jenispelayanan' => $isJenisPelayananBPJS
            );
            return $callback;
        }
    }
    function GoDeleteSEP($data)
    {
        try {
        $this->db->transaksi();
        $noregbatal = $data['noregbatal']; // ok
        $alasanbatal = $data['alasanbatal']; // ok
        $nosepbatal = $data['nosepbatal'];
        // TRIGER SEBELUM SIMPAN DATA
        // 1. TRIGER PASIEN JIKA JENIS BELUM DIISI  
        if ($noregbatal == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'No. Registrasi Kosong !',
            );
            echo json_encode($callback);
            exit;
        }
        // 1. TRIGER PASIEN JIKA ALASAN
        if ($alasanbatal == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Alasan Batal kosong !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($nosepbatal == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'No. SEP kosong !',
            );
            echo json_encode($callback);
            exit;
        }
        // validasi billing 
            // cek sudah ada billing aktif kah GoDeleteSEP
            $this->db->query("SELECT *FROM PerawatanSQL.DBO.[Visit Details] 
            WHERE NoRegistrasi=:noregbatal and KategoriTarif<>'Administrasi'");
            $this->db->bind('noregbatal', $noregbatal);
            $data =  $this->db->single();
            if ($data) {
            $callback = array(
            'status' => 'warning',
            'errorname' => 'Registrasi Sudah ada Billing Selain Administrasi, Batalkan Dahulu Semua Billing !',
            );
            return $callback;
            exit;
            }
            // cek sudah ada billing aktif kah
            $this->db->query("SELECT *FROM Billing_Pasien.DBO.FO_T_BILLING_1 
                    WHERE NO_REGISTRASI=:noregbatal and BATAL='0' and GROUP_ENTRI<>'KARCIS'");
            $this->db->bind('noregbatal', $noregbatal);
            $data =  $this->db->single();
            if ($data) {
            $callback = array(
            'status' => 'warning',
            'errorname' => 'Registrasi Sudah ada Billing Selain Administrasi, Batalkan Dahulu Semua Billing !',
            );
            return $callback;
            exit;
            }
            // cek sudah ada payment belum
            $this->db->query("SELECT Id FROM  PerawatanSQL.dbo.payments 
                    WHERE NoRegistrasi=:noregbatal ");
            $this->db->bind('noregbatal', $noregbatal);
            $data =  $this->db->single();
            if ($data) {
            $callback = array(
            'status' => 'warning',
            'errorname' => 'Simpan Gagal! No Registrasi Ini Sudah Memiliki Payment!',
            );
            return $callback;
            exit;
            }

        $curl = curl_init();

        $session = SessionManager::getCurrentSession();
        $namauserx = $session->name;
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        $datehapus = Utils::seCurrentDateTime();
        curl_setopt_array($curl, array(
            CURLOPT_URL => URL_BPJS . 'SEP/2.0/delete',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_POSTFIELDS => '{
            "request": {
                "t_sep": {
                    "noSep": "' . $nosepbatal . '",
                    "user": "' . $namauserx . '"
                }
            }
        }',
            CURLOPT_HTTPHEADER => $headerbpjs,
        ));
        $output = curl_exec($curl);
        curl_close($curl);
        $BATAL = "1";
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
            if ($JsonData['metaData']['code'] == "200") {
                $this->db->query("UPDATE PerawatanSQL.DBO.BPJS_T_SEP  SET 
                TGL_HAPUS=:TGL_HAPUS,USER_HAPUS=:USER_HAPUS,BATAL=:BATAL,Task99=:TGL_HAPUS2
                WHERE NO_SEP=:NoSep  and NO_REGISTRASI=:NO_REGISTRASI");
                $this->db->bind('NoSep', $nosepbatal);
                $this->db->bind('TGL_HAPUS', $datehapus);
                $this->db->bind('NO_REGISTRASI', $noregbatal);
                $this->db->bind('USER_HAPUS', $namauserx);
                $this->db->bind('BATAL', $BATAL);
                $this->db->bind('TGL_HAPUS2', $datehapus);
                $this->db->execute();

                $this->db->query("INSERT INTO SysLog.dbo.TZ_Log_Button
                                (idtrs,noregistrasi,nama_biling,
                                petugas_entry,tgl_entry,
                                petugas_batal,tgl_batal,alasan_batal)
                                VALUES 
                                (:idtrs,:noregistrasi,:nama_biling,
                                :petugas_entry,:tgl_entry
                                ,:petugas_batal,:tgl_batal
                                ,:alasan_batal)");
                    $this->db->bind('idtrs', null);
                    $this->db->bind('noregistrasi', $noregbatal);
                    $this->db->bind('nama_biling', $nosepbatal);
                    $this->db->bind('petugas_entry', null);
                    $this->db->bind('tgl_entry', null);
                    $this->db->bind('petugas_batal', $namauserx);
                    $this->db->bind('tgl_batal', $datehapus);
                    $this->db->bind('alasan_batal', $alasanbatal); 
                    $this->db->execute(); 
                    
                $this->db->commit();
                $callback = array(
                    'status' => 'success',
                    'message' => 'Data SEP Berhasil Dihapus !',
                );
                return $callback;
            } else {
                $callback = array(
                    'status' => 'notfound',
                    'errorname' => $JsonData['metaData']['message']
                );
                return $callback;
            } 

        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
        
    }
    function GoMonitoringPelayananBPJS($data)
    {
        $dateNow = Utils::datenowcreateNotFull();
        $MTglKunjunganBPJS = $data['MTglKunjunganBPJS'];
        $MJenisPelayananBPJS = $data['MJenisPelayananBPJS'];
        if ($MTglKunjunganBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Masukan Tanggal Kunjungan !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($MJenisPelayananBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Masukan Jenis Pelayanan !',
            );
            echo json_encode($callback);
            exit;
        }
        // persiapkan curl
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS . "Monitoring/Kunjungan/Tanggal/$MTglKunjunganBPJS/JnsPelayanan/$MJenisPelayananBPJS");
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
        // set time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            //echo json_encode($output);
            foreach ($ResultEncriptLzString['1']['sep'] as $key => $jsons) { // This will search in the 2 jsons
                $pasing['diagnosa'] = $jsons['diagnosa'];
                $pasing['jnsPelayanan'] = $jsons['jnsPelayanan'];
                $pasing['kelasRawat'] = $jsons['kelasRawat'];
                $pasing['nama'] = $jsons['nama'];
                $pasing['noKartu'] = $jsons['noKartu'];
                $pasing['noRujukan'] = $jsons['noRujukan'];
                $pasing['noSep'] = $jsons['noSep'];
                $pasing['poli'] = $jsons['poli'];
                $pasing['tglPlgSep'] = $jsons['tglPlgSep'];
                $pasing['tglSep'] = $jsons['tglSep'];
                $datas[] = $pasing;
            }
            return $datas;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']

            );
            return $callback;
        }
    }
    function GoMonitoringDataKlaimBPJS($data)
    {
        $dateNow = Utils::datenowcreateNotFull();
        $MTglKunjunganBPJS = $data['MTglKunjunganBPJS'];
        $MJenisPelayananBPJS = $data['MJenisPelayananBPJS'];
        $MJenisStatusPelayananBPJS = $data['MJenisStatusPelayananBPJS'];
        if ($MTglKunjunganBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Masukan Tanggal Kunjungan !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($MJenisPelayananBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Masukan Jenis Pelayanan !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($MJenisStatusPelayananBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Masukan Status Pelayanan !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($MJenisPelayananBPJS == "1") {
            $NamaJenisPelayananBPJS = "Ranap";
        } else {
            $NamaJenisPelayananBPJS = "Ranap";
        }
        // persiapkan curl
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS . "Monitoring/Klaim/Tanggal/$MTglKunjunganBPJS/JnsPelayanan/$MJenisPelayananBPJS/Status/$MJenisStatusPelayananBPJS");
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
        // set time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            //echo json_encode($output);
            foreach ($ResultEncriptLzString['1']['klaim'] as $key => $jsons) { // This will search in the 2 jsons 
                $pasing['kodediagnosa'] = $jsons['Inacbg']['kode'] . ' - ' . $jsons['Inacbg']['nama'];
                $pasing['namadiagnosa'] = $jsons['Inacbg']['nama'];
                $pasing['biayabyPengajuan'] = $jsons['biaya']['byPengajuan'];
                $pasing['biayabySetujui'] = $jsons['biaya']['bySetujui'];
                $pasing['biayabyTarifGruper'] = $jsons['biaya']['byTarifGruper'];
                $pasing['biayabyTarifRS'] = $jsons['biaya']['byTarifRS'];
                $pasing['biayabyTopup'] = $jsons['biaya']['byTopup'];
                $pasing['kelasRawat'] = $jsons['kelasRawat'];
                $pasing['noFPK'] = $jsons['noFPK'];
                $pasing['noSEP'] = $jsons['noSEP'];
                $pasing['pesertanama'] = $jsons['peserta']['nama'];
                $pasing['pesertanoKartu'] = $jsons['peserta']['noKartu'];
                $pasing['pesertanoMR'] = $jsons['peserta']['noMR'];
                $pasing['poli'] = $jsons['poli'];
                $pasing['status'] = $jsons['status'];
                $pasing['tglPulang'] = $jsons['tglPulang'];
                $pasing['tglSep'] = $jsons['tglSep'];
                $pasing['jenisPelayanan'] = $NamaJenisPelayananBPJS;
                $datas[] = $pasing;
            }
            return $datas;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']

            );
            return $callback;
        }
    }
    function GoMonitoringHistoriPelayananBPJS($data)
    {
        $dateNow = Utils::datenowcreateNotFull();
        $MTglKunjunganBPJS = $data['MTglKunjunganBPJS'];
        $MTglKunjunganBPJS_akhir = $data['MTglKunjunganBPJS_akhir'];
        $MNoKartuPeserta = $data['MNoKartuPeserta'];
        if ($MTglKunjunganBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Masukan Tanggal Kunjungan Awal !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($MTglKunjunganBPJS_akhir == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Masukan Tanggal Kunjungan Akhir !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($MNoKartuPeserta == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Masukan No. Kartu Peserta !',
            );
            echo json_encode($callback);
            exit;
        }

        // persiapkan curl
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS . "Monitoring/HistoriPelayanan/NoKartu/$MNoKartuPeserta/tglMulai/$MTglKunjunganBPJS/tglAkhir/$MTglKunjunganBPJS_akhir");
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
        // set time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            //echo json_encode($output);
            foreach ($ResultEncriptLzString['1']['histori'] as $key => $jsons) { // This will search in the 2 jsons 

                $pasing['diagnosa'] = $jsons['diagnosa'];
                $pasing['jnsPelayanan'] = $jsons['jnsPelayanan'];
                $pasing['kelasRawat'] = $jsons['kelasRawat'];
                $pasing['namaPeserta'] = $jsons['namaPeserta'];
                $pasing['noKartu'] = $jsons['noKartu'];
                $pasing['noSep'] = $jsons['noSep'];
                $pasing['noRujukan'] = $jsons['noRujukan'];
                $pasing['poli'] = $jsons['poli'];
                $pasing['ppkPelayanan'] = $jsons['ppkPelayanan'];
                $pasing['tglPlgSep'] = $jsons['tglPlgSep'];
                $pasing['tglSep'] = $jsons['tglSep'];
                $datas[] = $pasing;
            }
            return $datas;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']

            );
            return $callback;
        }
    }
    function GoMonitoringDataSEPInernalBPJS($data)
    {
        $MSepInternalNoSep = $data['MSepInternalNoSep'];

        if ($MSepInternalNoSep == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Masukan No. Kartu sep !',
            );
            echo json_encode($callback);
            exit;
        }

        // persiapkan curl
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS . "/SEP/Internal/$MSepInternalNoSep");
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
        // set time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            //echo json_encode($output);
            foreach ($ResultEncriptLzString['1']['list'] as $key => $jsons) { // This will search in the 2 jsons 
                $pasing['nosep'] = $jsons['nosep'];
                $pasing['nosepref'] = $jsons['nosepref'];
                $pasing['tujuanrujuk'] = $jsons['tujuanrujuk'];
                $pasing['nmtujuanrujuk'] = $jsons['nmtujuanrujuk'];
                $pasing['nmpoliasal'] = $jsons['nmpoliasal'];
                $pasing['tglrujukinternal'] = $jsons['tglrujukinternal'];
                $pasing['nokapst'] = $jsons['nokapst'];
                $pasing['nmdiag'] = $jsons['nmdiag'];
                $pasing['nmdokter'] = $jsons['nmdokter'];
                $pasing['nosurat'] = $jsons['nosurat'];
                $datas[] = $pasing;
            }
            return $datas;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']

            );
            return $callback;
        }
    }
    function GoRujukanMultiByKartu($data)
    {
        $dateNow = Utils::datenowcreateNotFull();
        $NoKartuPeserta = $data['MultiNoKartu'];

        // persiapkan curl
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS . "Rujukan/List/Peserta/$NoKartuPeserta");
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
        // set time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            //echo json_encode($output);
            foreach ($ResultEncriptLzString['1']['rujukan'] as $key => $jsons) { // This will search in the 2 jsons 

                $pasing['noKunjungan'] = $jsons['noKunjungan'];
                $pasing['keluhan'] = $jsons['keluhan'];
                $pasing['tglKunjungan'] = $jsons['tglKunjungan'];
                $pasing['diagnosa'] = $jsons['diagnosa']['kode'] . '-' . $jsons['diagnosa']['nama'];
                $pasing['pelayanan'] = $jsons['pelayanan']['kode'] . '-' . $jsons['pelayanan']['nama'];
                $pasing['poliRujukan'] = $jsons['poliRujukan']['kode'] . '-' . $jsons['poliRujukan']['nama'];
                $pasing['provPerujuk'] = $jsons['provPerujuk']['kode'] . '-' . $jsons['provPerujuk']['nama'];
                $pasing['pesertanama'] = $jsons['peserta']['nama'];
                $pasing['pesertanoKartu'] = $jsons['peserta']['noKartu'];

                $datas[] = $pasing;
            }
            return $datas;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']

            );
            return $callback;
        }
    }
    public function PrintSEP($data)
    {
        try {
            $datenow = Utils::seCurrentDateTime();
            // $this->db->query("UPDATE PerawatanSQL.DBO.BPJS_T_SEP  SET 
            // CETAKAN_KE=CETAKAN_KE+1,TGL_LAST_CETAK=:datenow
            // WHERE NO_SEP=:NoSep");
            // $this->db->bind('NoSep', $kodetrs);
            // $this->db->bind('datenow', $datenow); 
            // $this->db->execute();
            $this->db->query("SELECT NAMA_PARAM_1,IMAGE_PATH ,AWS_URL
                            FROM Billing_Pasien.DBO.T_SIGNATURE where NO_TRANSAKSI=:NoSep and NO_REGISTRASI=:NO_REGISTRASI");
            $this->db->bind('NoSep', $data['kodetrs']);
            $this->db->bind('NO_REGISTRASI', $data['noreg']);
            $data2 =  $this->db->single();

            $this->db->query("SELECT NO_SEP,NO_REGISTRASI,NO_MR,NAMA_PESERTA,JENIS_KELAMIN,NO_KARTU,replace(CONVERT(VARCHAR(11),TGL_SEP, 111), '/','-') TGL_SEP,
                                JENIS_PESERTA,COB,JENIS_RAWAT,KODE_POLI,NAMA_POLI,
                                KODE_DOKTER,NAMA_DOKTER,KODE_DIAGNOSA,NAMA_DIAGNOSA,NO_TELEPON,PENJAMIN,KELAS_RAWAT,CATATAN
                                ,replace(CONVERT(VARCHAR(11),TGL_LAHIR, 111), '/','-') TGL_LAHIR,CETAKAN_KE,TGL_LAST_CETAK,
                                KODE_PERUJUK,NAMA_PERUJUK,KETERANGAN_PRB,
                                replace(CONVERT(VARCHAR(11),TGL_CREATE, 111), '/','-') TGL_CREATEX
                                ,NAMA_PPK_PERUJUK,
                                CASE WHEN  NAIK_KELAS_ID ='1' THEN 'VVIP' 
                                    WHEN  NAIK_KELAS_ID ='2' THEN 'VIP' 
                                    WHEN  NAIK_KELAS_ID ='3' THEN 'Kelas 1' 
                                    WHEN  NAIK_KELAS_ID ='4' THEN 'Kelas 2' 
                                    WHEN  NAIK_KELAS_ID ='5' THEN 'Kelas 3' 
                                    WHEN  NAIK_KELAS_ID ='6' THEN 'ICCU' 
                                    WHEN  NAIK_KELAS_ID ='7' THEN 'ICU' 
                                END AS KELAS_NAIK_NAMA, NAIK_KELAS
                                FROM PerawatanSQL.DBO.BPJS_T_SEP 
                                WHERE NO_SEP=:NoSep and NO_REGISTRASI=:NO_REGISTRASI");
            $this->db->bind('NoSep', $data['kodetrs']);
            $this->db->bind('NO_REGISTRASI', $data['noreg']);
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success',
                'KETERANGAN_PRB' => $data['KETERANGAN_PRB'],
                'AWS_URL' => $data2['AWS_URL'],
                'KELAS_NAIK_NAMA' => $data['KELAS_NAIK_NAMA'],
                'NAIK_KELAS' => $data['NAIK_KELAS'],
                'NAMA_PPK_PERUJUK' => $data['NAMA_PPK_PERUJUK'],
                'NO_SEP' => $data['NO_SEP'],
                'NO_REGISTRASI' => $data['NO_REGISTRASI'],
                'NO_MR' => $data['NO_MR'],
                'NAMA_PESERTA' => $data['NAMA_PESERTA'],
                'JENIS_KELAMIN' => $data['JENIS_KELAMIN'],
                'NO_KARTU' => $data['NO_KARTU'],
                'TGL_SEP' => $data['TGL_SEP'],
                'JENIS_PESERTA' => $data['JENIS_PESERTA'],
                'COB' => $data['COB'],
                'JENIS_RAWAT' => $data['JENIS_RAWAT'],
                'KODE_POLI' => $data['KODE_POLI'],
                'NAMA_POLI' => $data['NAMA_POLI'],
                'KODE_DOKTER' => $data['KODE_DOKTER'],
                'NAMA_DOKTER' => $data['NAMA_DOKTER'],
                'KODE_DIAGNOSA' => $data['KODE_DIAGNOSA'],
                'NAMA_DIAGNOSA' => $data['NAMA_DIAGNOSA'],
                'NO_TELEPON' => $data['NO_TELEPON'],
                'PENJAMIN' => $data['PENJAMIN'],
                'KELAS_RAWAT' => $data['KELAS_RAWAT'],
                'CATATAN' => $data['CATATAN'],
                'TGL_LAHIR' => $data['TGL_LAHIR'],
                'CETAKAN_KE' => $data['CETAKAN_KE'],
                'NAMA_PERUJUK' => $data['NAMA_PERUJUK'],
                'KODE_PERUJUK' => $data['KODE_PERUJUK'],
                'TGL_LAST_CETAK' => $data['TGL_LAST_CETAK'],
                'NAMA_PARAM_1' => $data2['NAMA_PARAM_1'],
                'IMAGE_PATH' => $data2['IMAGE_PATH'],
                'TGL_CREATEX' => $data['TGL_CREATEX'],
            );
            return $callback;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    function GoGetPoliklinikBPJSSPRI($data)
    {
        $JnsKontrol = $data['JnsKontrol'];
        $nomor = $data['nomor'];
        $TglRencanaKontrol = $data['TglRencanaKontrol'];
        // persiapkan curl
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS . "RencanaKontrol/ListSpesialistik/JnsKontrol/$JnsKontrol/nomor/$nomor/TglRencanaKontrol/$TglRencanaKontrol");
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
        // set time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            //echo json_encode($output);
            foreach ($ResultEncriptLzString['1']['list'] as $key => $jsons) { // This will search in the 2 jsons
                $pasing['id'] = $jsons['kodePoli'];
                $pasing['text'] = $jsons['namaPoli'];
                $datas[] = $pasing;
            }
            return $datas;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']

            );
            return $callback;
        }
    }
    function getDokterbyKodePoliSPRI($data)
    {
        $JnsKontrol = $data['JnsKontrol'];
        $nomor = $data['nomor'];
        $KodePoliklinikBPJS = $data['KodePoliklinikBPJS'];
        $TglRencanaKontrol = $data['TglRencanaKontrol'];
        // persiapkan curl
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS . "RencanaKontrol/JadwalPraktekDokter/JnsKontrol/$JnsKontrol/KdPoli/$KodePoliklinikBPJS/TglRencanaKontrol/$TglRencanaKontrol");
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
        // set time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        // var_dump($JnsKontrol);
        // var_dump($KodePoliklinikBPJS);
        // var_dump($TglRencanaKontrol); 
        // var_dump($output);
        // exit;
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            //echo json_encode($output);
            foreach ($ResultEncriptLzString['1']['list'] as $key => $jsons) { // This will search in the 2 jsons
                $pasing['id'] = $jsons['kodeDokter'];
                $pasing['text'] = $jsons['namaDokter'];
                $pasing['jadwalPraktek'] = $jsons['jadwalPraktek'];
                $pasing['kapasitas'] = $jsons['kapasitas'];
                $datas[] = $pasing;
            }
            return $datas;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']

            );
            return $callback;
        }
    }
    function CreateSPRI($data)
    {
        $curl = curl_init();
        $JnsKontrol = $data['JnsKontrol'];
        $nomor = $data['nomor'];
        //   $TglRencanaKontrol = $data['TglRencanaKontrol'];
        $TglRencanaKontrol = $data['TglRencanaKontrol'];
        $KodePoliklinikBPJS = $data['KodePoliklinikBPJS'];
        $TglRegIGD = $data['TglRegIGD'];
        $NamaPoliklinikBPJS = $data['NamaPoliklinikBPJS'];
        $NamaDokterBPJS = $data['NamaDokterBPJS'];
        $SPRI_NoSPR2 = $data['SPRI_NoSPR2'];
        $jenisTrs = $data['jenisTrs'];
        $SPRI_NoSPR2BPJS = $data['SPRI_NoSPR2BPJS'];
        $SPRI_NoSEP = $data['SPRI_NoSEP'];
        $KodeDokterBPJS = $data['KodeDokterBPJS'];
        $SPRI_NoRegistrasi2 = $data['SPRI_NoRegistrasi2'];
        if (isset($data['isbayi'])) {
            $isbayi = $data['isbayi'];
        } else {
            $isbayi = '';
        }
        //$KodeDokterBPJS = "20507"; 
        $session = SessionManager::getCurrentSession();
        $userid = $session->username;
        $token = $session->token;
        $namauserx = $session->name;
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        if ($jenisTrs == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Jenis TRS Invalid !',
            );
            echo json_encode($callback);
            exit;
        }

        if ($isbayi == 'BY_SPRI') { } else {
            if ($SPRI_NoRegistrasi2 == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. Registrasi Invalid !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($SPRI_NoSPR2 == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. SPR SIMRS Invalid !',
                );
                echo json_encode($callback);
                exit;
            }
        }

        if ($TglRencanaKontrol == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Tgl Rencana Kontrol Invalid !',
            );
            echo json_encode($callback);
            exit;
        }
        // if ($KodePoliklinikBPJS == "") {
        //     $callback = array(
        //         'status' => 'warning',
        //         'errorname' => 'Kode Poliklinik Invalid !',
        //     );
        //     echo json_encode($callback);
        //     exit;
        // }
        // if ($NamaPoliklinikBPJS == "") {
        //     $callback = array(
        //         'status' => 'warning',
        //         'errorname' => 'Nama Poliklinik Invalid !',
        //     );
        //     echo json_encode($callback);
        //     exit;
        // }
        if ($KodeDokterBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Kode Dokter Invalid !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($NamaDokterBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Nama Dokter Invalid !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($jenisTrs == "Insert") {
            curl_setopt_array($curl, array(
                CURLOPT_URL =>  URL_BPJS . 'RencanaKontrol/InsertSPRI',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                                        "request":
                                            {
                                                "noKartu":"' . $nomor . '",
                                                "kodeDokter":"' . $KodeDokterBPJS . '",
                                                "poliKontrol":"' . $KodePoliklinikBPJS . '",
                                                "tglRencanaKontrol":"' . $TglRencanaKontrol . '",
                                                "user":"' . $namauserx . '"
                                            }
                                        }',
                CURLOPT_HTTPHEADER => $headerbpjs,
            ));
            $output = curl_exec($curl);
            // tutup curl 
            curl_close($curl);
            $JENIS_KONTROL = "1";
            // ubah string JSON menjadi array
            $JsonData = json_decode($output, TRUE);
            if ($JsonData['metaData']['code'] == "200") {
                $EncodeData = json_encode($JsonData);
                $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
                $JsonDatax   = json_decode(json_encode($ResultEncriptLzString), true);
                $noSPRI = $JsonDatax['1']['noSPRI'];
                $tglRencanaKontrol = $JsonDatax['1']['tglRencanaKontrol'];
                $namaDokter = $JsonDatax['1']['namaDokter'];
                $noKartu = $JsonDatax['1']['noKartu'];
                $nama = $JsonDatax['1']['nama'];
                $kelamin = $JsonDatax['1']['kelamin'];
                $tglLahir = $JsonDatax['1']['tglLahir'];
                $namaDiagnosa = $JsonDatax['1']['namaDiagnosa'];
                $TGLNOW = Utils::seCurrentDateTime();
                $this->db->query("INSERT INTO perawatanSQL.dbo.BPJS_T_SPRI 
                            (NO_SPRI,NO_SPR_SIMRS,TGL_RENCANA_KONTROL,TGL_ENTRY,
                            NAMA_PASIEN,JENIS_KELAMIN,NAMA_DIAGNOSA,NAMA_DOKTER,
                            NO_KARTU,TGL_LAHIR,USER_INPUT,TANGGAL_INPUT,TGL_REG_IGD,KODE_DOKTER,KODE_POLI,NAMA_POLI,NO_SEP,JENIS_KONTROL,NO_REGISTRASI)
                            VALUES 
                            (:NO_SPRI,:NO_SPR_SIMRS,:TGL_RENCANA_KONTROL,:TGL_ENTRY,
                            :NAMA_PASIEN,:JENIS_KELAMIN,:NAMA_DIAGNOSA
                            ,:NAMA_DOKTER,:NO_KARTU
                            ,:TGL_LAHIR,:USER_INPUT,:TANGGAL_INPUT,:TGL_REG_IGD,:KODE_DOKTER,:KODE_POLI,:NAMA_POLI,:NO_SEP,:JENIS_KONTROL,:NO_REGISTRASI)");
                $this->db->bind('NO_SPRI', $noSPRI);
                $this->db->bind('NO_SPR_SIMRS', $SPRI_NoSPR2);
                $this->db->bind('TGL_RENCANA_KONTROL', $tglRencanaKontrol);
                $this->db->bind('TGL_ENTRY', $TGLNOW);
                $this->db->bind('NAMA_PASIEN', $nama);
                $this->db->bind('JENIS_KELAMIN', $kelamin);
                $this->db->bind('NAMA_DIAGNOSA', $namaDiagnosa);
                $this->db->bind('NAMA_DOKTER', $namaDokter);
                $this->db->bind('NO_KARTU', $noKartu);
                $this->db->bind('TGL_LAHIR', $tglLahir);
                $this->db->bind('USER_INPUT', $namauserx);
                $this->db->bind('TANGGAL_INPUT', $TGLNOW);
                $this->db->bind('TGL_REG_IGD', $TglRegIGD);
                $this->db->bind('KODE_DOKTER', $KodeDokterBPJS);
                $this->db->bind('KODE_POLI', $KodePoliklinikBPJS);
                $this->db->bind('NAMA_POLI', $NamaPoliklinikBPJS);
                $this->db->bind('NO_SEP', $SPRI_NoSEP);
                $this->db->bind('JENIS_KONTROL', $JENIS_KONTROL);
                $this->db->bind('NO_REGISTRASI', $SPRI_NoRegistrasi2);
                $this->db->execute();
                $callback = array(
                    'status' => 'success',
                    'hasil' => $noSPRI,
                );
                return $callback;
            } else {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => $JsonData['metaData']['message']
                );
                return $callback;
            }
        } elseif ($jenisTrs == "Update") {
            if ($SPRI_NoSPR2BPJS == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. Surat Kontrol Invalid !',
                );
                echo json_encode($callback);
                exit;
            }
            if ($SPRI_NoSEP == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'No. SEP Invalid !',
                );
                echo json_encode($callback);
                exit;
            }
            curl_setopt_array($curl, array(
                CURLOPT_URL =>  URL_BPJS . 'RencanaKontrol/UpdateSPRI',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'PUT',
                CURLOPT_POSTFIELDS => '{
                                        "request":
                                            {
                                                "noSPRI":"' . $SPRI_NoSPR2BPJS . '", 
                                                "kodeDokter":"' . $KodeDokterBPJS . '",
                                                "poliKontrol":"' . $KodePoliklinikBPJS . '",
                                                "tglRencanaKontrol":"' . $TglRencanaKontrol . '",
                                                "user":"' . $namauserx . '"
                                            }
                                        }',
                CURLOPT_HTTPHEADER => $headerbpjs,
            ));
            $output = curl_exec($curl);
            // tutup curl 
            curl_close($curl);
            // ubah string JSON menjadi array
            $JsonData = json_decode($output, TRUE);
            if ($JsonData['metaData']['code'] == "200") {
                $EncodeData = json_encode($JsonData);
                $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
                $JsonDatax   = json_decode(json_encode($ResultEncriptLzString), true);


                $this->db->query("UPDATE perawatanSQL.dbo.BPJS_T_SPRI SET
                            TGL_RENCANA_KONTROL=:TGL_RENCANA_KONTROL,NAMA_DOKTER=:NAMA_DOKTER,
                            KODE_DOKTER=:KODE_DOKTER,KODE_POLI=:KODE_POLI,NAMA_POLI=:NAMA_POLI
                            where NO_SPRI=:NO_SPRI");
                $this->db->bind('NO_SPRI', $SPRI_NoSPR2BPJS);
                $this->db->bind('TGL_RENCANA_KONTROL', $TglRencanaKontrol);
                $this->db->bind('NAMA_DOKTER', $NamaDokterBPJS);
                $this->db->bind('KODE_DOKTER', $KodeDokterBPJS);
                $this->db->bind('KODE_POLI', $KodePoliklinikBPJS);
                $this->db->bind('NAMA_POLI', $NamaPoliklinikBPJS);
                $this->db->execute();
                $callback = array(
                    'status' => 'success',
                    'hasil' => $SPRI_NoSPR2BPJS,
                );
                return $callback;
            } else {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => $JsonData['metaData']['message']
                );
                return $callback;
            }
        }
    }
    function GoListSPRIBPJS($data)
    {
        $dateNow = Utils::datenowcreateNotFull();
        $MTglKunjunganBPJS = $data['MTglKunjunganBPJS'];
        $MTglKunjungan2BPJS = $data['MTglKunjungan2BPJS'];
        $MJenisPelayananBPJS = $data['MJenisPelayananBPJS'];
        if ($MTglKunjunganBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Masukan Tanggal Kunjungan !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($MTglKunjungan2BPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Masukan Tanggal 2 Kunjungan !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($MJenisPelayananBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Masukan Jenis Pelayanan !',
            );
            echo json_encode($callback);
            exit;
        }
        // persiapkan curl
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS . "RencanaKontrol/ListRencanaKontrol/tglAwal/$MTglKunjunganBPJS/tglAkhir/$MTglKunjungan2BPJS/filter/$MJenisPelayananBPJS");
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
        // set time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            //echo json_encode($output);
            foreach ($ResultEncriptLzString['1']['list'] as $key => $jsons) { // This will search in the 2 jsons
                $pasing['noSuratKontrol'] = $jsons['noSuratKontrol'];
                $pasing['jnsPelayanan'] = $jsons['jnsPelayanan'];
                $pasing['jnsKontrol'] = $jsons['jnsKontrol'];
                $pasing['namaJnsKontrol'] = $jsons['namaJnsKontrol'];
                $pasing['tglRencanaKontrol'] = $jsons['tglRencanaKontrol'];
                $pasing['tglTerbitKontrol'] = $jsons['tglTerbitKontrol'];
                $pasing['noSepAsalKontrol'] = $jsons['noSepAsalKontrol'];
                $pasing['poliAsal'] = $jsons['poliAsal'];
                $pasing['namaPoliAsal'] = $jsons['namaPoliAsal'];
                $pasing['poliTujuan'] = $jsons['poliTujuan'];
                $pasing['namaPoliTujuan'] = $jsons['namaPoliTujuan'];
                $pasing['tglSEP'] = $jsons['tglSEP'];
                $pasing['kodeDokter'] = $jsons['kodeDokter'];
                $pasing['namaDokter'] = $jsons['namaDokter'];
                $pasing['noKartu'] = $jsons['noKartu'];
                $pasing['nama'] = $jsons['nama'];
                $datas[] = $pasing;
            }
            return $datas;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']

            );
            return $callback;
        }
    }
    function goBatalSPRI($data)
    {
        $curl = curl_init();
        $alasanbatal = $data['alasanbatal'];
        $NOspri = $data['NOspri'];
        $NoRegistrasi = $data['NoRegistrasi'];
        $session = SessionManager::getCurrentSession();
        $namauserx = $session->name;
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        $tglNow = Utils::seCurrentDateTime();
        $ISBATAL = "1";
        if ($NOspri == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'No. SPRI Kosong !',
            );
            echo json_encode($callback);
            exit;
        }
        // if ($NoRegistrasi == "") {
        //     $callback = array(
        //         'status' => 'warning',
        //         'errorname' => 'No. Registrasi Kosong !',
        //     );
        //     echo json_encode($callback);
        //     exit;
        // }
        if ($alasanbatal == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Alasan Batal kosong !',
            );
            echo json_encode($callback);
            exit;
        }
        curl_setopt_array($curl, array(
            CURLOPT_URL =>  URL_BPJS . 'RencanaKontrol/Delete',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_POSTFIELDS => '{
                                                "request": {
                                                    "t_suratkontrol":{
                                                    "noSuratKontrol": "' . $NOspri . '",
                                                    "user": "' . $namauserx . '"
                                                    }
                                                }
                                            }
                                    ',
            CURLOPT_HTTPHEADER => $headerbpjs,
        ));

        $output = curl_exec($curl);

        // tutup curl 
        curl_close($curl);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            $JsonDatax   = json_decode(json_encode($ResultEncriptLzString), true);
            // $nosep = $JsonDatax['1']['sep']['noSep'];  
            $this->db->query("UPDATE PerawatanSQL.dbo.BPJS_T_SPRI
                            SET STATUS=:ISBATAL,USER_BATAL=:USER_BATAL, 
                            TANGGAL_BATAL=:TANGGAL_BATAL,ALASAN=:ALASAN
                            WHERE NO_SPRI=:NO_SPRI");
            $this->db->bind('NO_SPRI', $NOspri);
            $this->db->bind('USER_BATAL', $namauserx);
            $this->db->bind('TANGGAL_BATAL', $tglNow);
            $this->db->bind('ALASAN', $alasanbatal);
            $this->db->bind('ISBATAL', $ISBATAL);
            $this->db->execute();
            $callback = array(
                'status' => 'success',
                'hasil' => $ResultEncriptLzString,
            );
            return $callback;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']
            );
            return $callback;
        }
    }
    function gosavePengajuanSEP($data)
    {
        $curl = curl_init();
        $iscatatanBPJS = $data['iscatatanBPJS'];
        $PengSEP_NoKartu = $data['PengSEP_NoKartu'];
        $PengSEP_Tgl = $data['PengSEP_Tgl'];
        $isJenisPelayananBPJS = $data['isJenisPelayananBPJS'];
        $isJenisPelayananPengajuanBPJS = $data['isJenisPelayananPengajuanBPJS'];
        $session = SessionManager::getCurrentSession();
        $userid = $session->username;
        $token = $session->token;
        $namauserx = $session->name;
        if ($PengSEP_NoKartu == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'No. kartu Peserta Harus Diisi !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($PengSEP_Tgl == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Tanggal SEP Harus Diisi !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($isJenisPelayananBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Jenis Pelayanan Harus Diisi !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($isJenisPelayananPengajuanBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Jenis Pengajuan Harus Diisi !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($iscatatanBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Catatan Harus Diisi !',
            );
            echo json_encode($callback);
            exit;
        }
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        curl_setopt_array($curl, array(
            CURLOPT_URL =>  URL_BPJS . 'Sep/pengajuanSEP',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                                    "request": {
                                        "t_sep": {
                                        "noKartu": "' . $PengSEP_NoKartu . '",
                                        "tglSep": "' . $PengSEP_Tgl . '",
                                        "jnsPelayanan": "' . $isJenisPelayananBPJS . '",
                                        "jnsPengajuan": "' . $isJenisPelayananPengajuanBPJS . '",
                                        "keterangan": "' . $iscatatanBPJS . '",
                                        "user": "' . $namauserx . '"
                                        }
                                    }
                                    }',
            CURLOPT_HTTPHEADER => $headerbpjs,
        ));

        $output = curl_exec($curl);
        $dateNow = Utils::datenowcreateNotFull();
        // tutup curl 
        curl_close($curl);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $this->db->query("INSERT INTO perawatanSQL.dbo.BPJS_REQ_APPROVAL_SEP 
                                    (NO_KARTU,TGL_SEP,JENIS_PELAYANAN,
                                    JENIS_PENGAJUAN,KETERANGAN,TGL_ENTRY) 
                                    VALUES 
                                    (:NO_KARTU,:TGL_SEP,:JENIS_PELAYANAN,:JENIS_PENGAJUAN,:KETERANGAN,:TGL_ENTRY)");
            $this->db->bind('NO_KARTU', $PengSEP_NoKartu);
            $this->db->bind('TGL_SEP', $PengSEP_Tgl);
            $this->db->bind('JENIS_PELAYANAN', $isJenisPelayananBPJS);
            $this->db->bind('JENIS_PENGAJUAN', $isJenisPelayananPengajuanBPJS);
            $this->db->bind('KETERANGAN', $iscatatanBPJS);
            $this->db->bind('TGL_ENTRY', $dateNow);
            $this->db->execute();
            $EncodeData = json_encode($JsonData);
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            $JsonDatax   = json_decode(json_encode($ResultEncriptLzString), true);
            $callback = array(
                'status' => 'success',
            );
            return $ResultEncriptLzString;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']
            );
            return $callback;
        }
    }
    function gosaveApprovalPengajuanSEP($data)
    {
        $curl = curl_init();
        $iscatatanBPJS = $data['iscatatanBPJS'];
        $PengSEP_NoKartu = $data['PengSEP_NoKartu'];
        $PengSEP_Tgl = $data['PengSEP_Tgl'];
        $isJenisPelayananBPJS = $data['isJenisPelayananBPJS'];
        $isJenisPelayananPengajuanBPJS = $data['isJenisPelayananPengajuanBPJS'];
        $session = SessionManager::getCurrentSession();
        $userid = $session->username;
        $token = $session->token;
        $namauserx = $session->name;
        if ($PengSEP_NoKartu == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'No. kartu Peserta Harus Diisi !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($PengSEP_Tgl == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Tanggal SEP Harus Diisi !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($isJenisPelayananBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Jenis Pelayanan Harus Diisi !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($isJenisPelayananPengajuanBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Jenis Pengajuan Harus Diisi !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($iscatatanBPJS == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Catatan Harus Diisi !',
            );
            echo json_encode($callback);
            exit;
        }
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        curl_setopt_array($curl, array(
            CURLOPT_URL =>  URL_BPJS . 'Sep/aprovalSEP',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                                    "request": {
                                        "t_sep": {
                                        "noKartu": "' . $PengSEP_NoKartu . '",
                                        "tglSep": "' . $PengSEP_Tgl . '",
                                        "jnsPelayanan": "' . $isJenisPelayananBPJS . '",
                                        "jnsPengajuan": "' . $isJenisPelayananPengajuanBPJS . '",
                                        "keterangan": "' . $iscatatanBPJS . '",
                                        "user": "Coba Ws"
                                        }
                                    }
                                    }',
            CURLOPT_HTTPHEADER => $headerbpjs,
        ));

        $output = curl_exec($curl);

        // tutup curl 
        curl_close($curl);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {

            $EncodeData = json_encode($JsonData);
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            $JsonDatax   = json_decode(json_encode($ResultEncriptLzString), true);
            $callback = array(
                'status' => 'success',
            );
            return $callback;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']
            );
            return $callback;
        }
    }
    function GetKetersediaanPoliklinik($data)
    {
        $dateNow = Utils::datenowcreateNotFull();
        $daftarnamafakes = $data['daftarnamafakes'];
        $tglrencanakunjungan = $data['tglrencanakunjungan'];
        if ($daftarnamafakes == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Masukan Nama Faskes !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($tglrencanakunjungan == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Masukan Tanggal Rencana Kunjungan  !',
            );
            echo json_encode($callback);
            exit;
        }

        // persiapkan curl
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS . "Rujukan/ListSpesialistik/PPKRujukan/$daftarnamafakes/TglRujukan/$tglrencanakunjungan");
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
        // set time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            //echo json_encode($output);
            foreach ($ResultEncriptLzString['1']['list'] as $key => $jsons) { // This will search in the 2 jsons 

                $pasing['kodeSpesialis'] = $jsons['kodeSpesialis'];
                $pasing['namaSpesialis'] = $jsons['namaSpesialis'];
                $pasing['kapasitas'] = $jsons['kapasitas'];
                $pasing['jumlahRujukan'] = $jsons['jumlahRujukan'];
                $pasing['persentase'] = $jsons['persentase'];
                $datas[] = $pasing;
            }
            return $datas;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']

            );
            return $callback;
        }
    }
    function GetKetersediaanSarana($data)
    {
        $dateNow = Utils::datenowcreateNotFull();
        $daftarnamafakes = $data['daftarnamafakes'];
        $tglrencanakunjungan = $data['tglrencanakunjungan'];
        if ($daftarnamafakes == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Masukan Nama Faskes !',
            );
            echo json_encode($callback);
            exit;
        }

        // persiapkan curl
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS . "Rujukan/ListSarana/PPKRujukan/$daftarnamafakes");
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
        // set time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            //echo json_encode($output);
            foreach ($ResultEncriptLzString['1']['list'] as $key => $jsons) { // This will search in the 2 jsons 

                $pasing['kodeSarana'] = $jsons['kodeSarana'];
                $pasing['namaSarana'] = $jsons['namaSarana'];
                $datas[] = $pasing;
            }
            return $datas;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']

            );
            return $callback;
        }
    }
    function GetKetersediaanPoliklinikInternal($data)
    {
        $SPRI_NoKartu2 = $data['SPRI_NoKartu2'];
        $SPRI_KodeJenisKontrol = $data['SPRI_KodeJenisKontrol'];
        $SPRI_TglRencanaKontrol = $data['SPRI_TglRencanaKontrol'];

        // persiapkan curl
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS . "RencanaKontrol/ListSpesialistik/JnsKontrol/$SPRI_KodeJenisKontrol/nomor/$SPRI_NoKartu2/TglRencanaKontrol/$SPRI_TglRencanaKontrol");
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
        // set time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            //echo json_encode($output);
            foreach ($ResultEncriptLzString['1']['list'] as $key => $jsons) { // This will search in the 2 jsons 

                $pasing['kodePoli'] = $jsons['kodePoli'];
                $pasing['namaPoli'] = $jsons['namaPoli'];
                $pasing['kapasitas'] = $jsons['kapasitas'];
                $pasing['jmlRencanaKontroldanRujukan'] = $jsons['jmlRencanaKontroldanRujukan'];
                $pasing['persentase'] = $jsons['persentase'];
                $datas[] = $pasing;
            }
            return $datas;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']

            );
            return $callback;
        }
    }
    public function PrintSPRI($data)
    {
        try {
            $datenow = Utils::seCurrentDateTime();
            // $kodetrs= "0114R0671121K000025";
            // $this->db->query("UPDATE PerawatanSQL.DBO.BPJS_T_SPRI  SET 
            // CETAKAN_KE=CETAKAN_KE+1,TGL_LAST_CETAK=:datenow
            // WHERE NO_SPRI=:NoSep");
            // $this->db->bind('NoSep', $kodetrs);
            // $this->db->bind('datenow', $datenow);
            // $this->db->execute();

            $this->db->query("SELECT NO_SPRI,NO_SPR_SIMRS,replace(CONVERT(VARCHAR(11),TGL_RENCANA_KONTROL, 111), '/','-') as TGL_RENCANA_KONTROL,
                            replace(CONVERT(VARCHAR(11),TGL_ENTRY, 111), '/','-') as  TGL_ENTRY,
                            NAMA_PASIEN,JENIS_KELAMIN,NAMA_DIAGNOSA,
                            NAMA_DOKTER,NO_KARTU,replace(CONVERT(VARCHAR(11),TGL_LAHIR, 111), '/','-') as  TGL_LAHIR,
                            CETAKAN_KE, TGL_LAST_CETAK,NAMA_POLI
                            FROM PerawatanSQL.DBO.BPJS_T_SPRI
                            WHERE STATUS='0' AND NO_SPRI=:NO_SPRI ");
            $this->db->bind('NO_SPRI', $data['kodetrs']);
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success',
                'NO_SPRI' => $data['NO_SPRI'],
                'NAMA_POLI' => $data['NAMA_POLI'],
                'NO_SPR_SIMRS' => $data['NO_SPR_SIMRS'],
                'TGL_RENCANA_KONTROL' => $data['TGL_RENCANA_KONTROL'],
                'TGL_ENTRY' => $data['TGL_ENTRY'],
                'NAMA_PASIEN' => $data['NAMA_PASIEN'],
                'NAMA_DIAGNOSA' => $data['NAMA_DIAGNOSA'],
                'NAMA_DOKTER' => $data['NAMA_DOKTER'],
                'NO_KARTU' => $data['NO_KARTU'],
                'TGL_LAHIR' => $data['TGL_LAHIR'],
                'CETAKAN_KE' => $data['CETAKAN_KE'],
                'JENIS_KELAMIN' => $data['JENIS_KELAMIN'],
                'TGL_LAST_CETAK' => $data['TGL_LAST_CETAK'],
            );
            return $callback;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    public function getDataSPRI($data)
    {
        try {
            $noSPRBPJS = $data['noSPRBPJS'];
            $this->db->query("SELECT A.NO_SPRI,A.NO_SPR_SIMRS,
                            replace(CONVERT(VARCHAR(11),A.TGL_RENCANA_KONTROL, 111), '/','-') as TGL_RENCANA_KONTROL,
                            A.NAMA_PASIEN,A.JENIS_KELAMIN,
                            A.KODE_DOKTER,A.NAMA_DOKTER,A.NAMA_DIAGNOSA,A.KODE_POLI,A.NAMA_POLI,
                            B.NOREGISTRASI,B.NoEpisode,B.DokterDPJP as DokterPemeriksa,B.JenisRawat,
                            replace(CONVERT(VARCHAR(11),A.TGL_REG_IGD, 111), '/','-') as TGL_REG_IGD ,b.NoMR,a.NO_KARTU,a.NO_SEP
                            ,a.STATUS
                            FROM PerawatanSQL.DBO.BPJS_T_SPRI A
                            INNER JOIN MedicalRecord.DBO.MR_PermintaanRawat B
                            ON A.NO_SPR_SIMRS = B.ID
                            where A.NO_SPRI=:noSPRBPJS");
            $this->db->bind('noSPRBPJS', $noSPRBPJS);

            $data =  $this->db->single();
            $pasing['NO_SPRI'] = $data['NO_SPRI'];
            $pasing['NO_SPR_SIMRS'] = $data['NO_SPR_SIMRS'];
            $pasing['TGL_RENCANA_KONTROL'] = $data['TGL_RENCANA_KONTROL'];
            $pasing['NAMA_PASIEN'] = $data['NAMA_PASIEN'];
            $pasing['JENIS_KELAMIN'] = $data['JENIS_KELAMIN'];
            $pasing['KODE_DOKTER'] = $data['KODE_DOKTER'];
            $pasing['NAMA_DOKTER'] = $data['NAMA_DOKTER'];
            $pasing['NAMA_DIAGNOSA'] = $data['NAMA_DIAGNOSA'];
            $pasing['KODE_POLI'] = $data['KODE_POLI'];
            $pasing['NAMA_POLI'] = $data['NAMA_POLI'];
            $pasing['NOREGISTRASI'] = $data['NOREGISTRASI'];
            $pasing['NoEpisode'] = $data['NoEpisode'];
            $pasing['DokterPemeriksa'] = $data['DokterPemeriksa'];
            $pasing['JenisRawat'] = $data['JenisRawat'];
            $pasing['TGL_REG_IGD'] = $data['TGL_REG_IGD'];
            $pasing['NoMR'] = $data['NoMR'];
            $pasing['NO_KARTU'] = $data['NO_KARTU'];
            $pasing['NO_SEP'] = $data['NO_SEP'];
            $callback = array(
                'message' => "success", // Set array nama 
                'data' => $pasing,
                'isactive' => $data['STATUS']
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    function setDataSEPRujukanByID($data)
    {
        $BPJS_NoSEP = $data['BPJS_NoSEP'];
        // persiapkan curl
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS . "RencanaKontrol/nosep/$BPJS_NoSEP");
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
        // set time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            $callback = array(
                'status' => 'success',
                'hasil' => $ResultEncriptLzString['1'],
            );
            return $callback;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']

            );
            return $callback;
        }
    }
    function setDataSEP($data)
    {
        $BPJS_NoSEP = $data['BPJS_NoSEP'];
        // persiapkan curl
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS . "SEP/$BPJS_NoSEP");
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
        // set time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            $callback = array(
                'status' => 'success',
                'hasil' => $ResultEncriptLzString['1'],
            );

            return $callback;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']

            );
            return $callback;
        }
    }
    function goHapussepInternal($data)
    {
        $curl = curl_init();
        $MNoSEPBPJS = $data['MNoSEPBPJS'];
        $MNoRujukanSEPBPJS = $data['MNoRujukanSEPBPJS'];
        $KodePoliRujukanBPJS = $data['KodePoliRujukanBPJS'];
        $TglRujukanBPJS = $data['TglRujukanBPJS'];
        $session = SessionManager::getCurrentSession();
        $namauserx = $session->name;
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        $datehapus = Utils::seCurrentDateTime();
        $session = SessionManager::getCurrentSession();
        $namauserx = $session->name;
        curl_setopt_array($curl, array(
            CURLOPT_URL => URL_BPJS . 'SEP/Internal/delete',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_POSTFIELDS => '{
           "request": {
              "t_sep": {
                 "noSep": "' . $MNoSEPBPJS . '",
                 "noSurat": "' . $MNoRujukanSEPBPJS . '",
                 "tglRujukanInternal": "' . $TglRujukanBPJS . '",
                 "kdPoliTuj": "' . $KodePoliRujukanBPJS . '",
                 "user": "' . $namauserx . '"
              }
           }
        } ',
            CURLOPT_HTTPHEADER => $headerbpjs,
        ));
        $output = curl_exec($curl);
        curl_close($curl);
        $BATAL = "1";
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $this->db->query("UPDATE PerawatanSQL.DBO.BPJS_T_SEP  SET 
            TGL_HAPUS=:TGL_HAPUS,USER_HAPUS=:USER_HAPUS,BATAL=:BATAL
            WHERE NO_SEP=:NoSep  and KODE_POLI=:KodePoliRujukanBPJS 
            and replace(CONVERT(VARCHAR(11), TGL_SEP, 111), '/','-')=:TGL_SEP and BATAL='0' ");
            $this->db->bind('NoSep', $MNoSEPBPJS);
            $this->db->bind('TGL_HAPUS', $datehapus);
            $this->db->bind('KodePoliRujukanBPJS', $KodePoliRujukanBPJS);
            $this->db->bind('USER_HAPUS', $namauserx);
            $this->db->bind('BATAL', $BATAL);
            $this->db->bind('TGL_SEP', $TglRujukanBPJS);
            $this->db->execute();
            $callback = array(
                'status' => 'success',
                'message' => 'Sep Internal Berhasil Di hapus !',
            );
            return $callback;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']
            );
            return $callback;
        }
    }
    function goUpdateTglSEPPulang($data)
    {
        $curl = curl_init();
        $MNoSEPBPJS = $data['MNoSEPBPJS'];
        $StatusPulangBPJS = $data['StatusPulangBPJS'];
        $MNoSuratMeninggalBPJS = $data['MNoSuratMeninggalBPJS'];
        $TglMeninggalBPJS = $data['TglMeninggalBPJS'];
        $MTglPulangBPJS = $data['MTglPulangBPJS'];
        $MNoPLManualBPJS = $data['MNoPLManualBPJS'];
        $session = SessionManager::getCurrentSession();
        $namauserx = $session->name;
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        $datehapus = Utils::seCurrentDateTime();
        curl_setopt_array($curl, array(
            CURLOPT_URL => URL_BPJS . 'SEP/2.0/updtglplg',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => '{
                "request":{
                    "t_sep":{
                        "noSep": "' . $MNoSEPBPJS . '",
                        "statusPulang":"' . $StatusPulangBPJS . '",
                        "noSuratMeninggal":"' . $MNoSuratMeninggalBPJS . '",
                        "tglMeninggal":"' . $TglMeninggalBPJS . '",
                        "tglPulang":"' . $MTglPulangBPJS . '",
                        "noLPManual":"' . $MNoPLManualBPJS . '",
                        "user":"' . $namauserx . '"
                    }
                }
            }',
            CURLOPT_HTTPHEADER => $headerbpjs,
        ));
        $output = curl_exec($curl);
        curl_close($curl);
        $BATAL = "1";
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {

            $callback = array(
                'status' => 'success',
                'message' => 'Tgl Pulang SEP Berhasil Dirubah !',
            );
            return $callback;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']
            );
            return $callback;
        }
    }
    public function setDataSEPSIMRS($data)
    {
        try {
            $NO_SEP = $data['BPJS_NoSEP'];
            $this->db->query(" SELECT NO_SEP,NO_REGISTRASI,NO_MR,NO_RUJUKAN,NO_SPRI,NO_NIK,NAMA_PESERTA,
                            JENIS_KELAMIN,NO_KARTU,replace(CONVERT(VARCHAR(11),TGL_SEP, 111), '/','-') as TGL_SEP,
                            KODE_JENIS_PESERTA,JENIS_PESERTA
                            ,IS_EKSEKUTIF,IS_KATARAK,IS_COB,COB,COB_NO_ASURANSI,KODE_JENIS_RAWAT,
                            JENIS_RAWAT,KODE_POLI,NAMA_POLI,KODE_DOKTER,NAMA_DOKTER,KODE_DIAGNOSA,NAMA_DIAGNOSA,NO_TELEPON
                            ,NAIK_KELAS,NAIK_KELAS_ID,PENJAMIN,PENANGGUNG_JAWAB,KODE_KELAS_RAWAT,KELAS_RAWAT,CATATAN,
                            replace(CONVERT(VARCHAR(11),TGL_LAHIR, 111), '/','-') as TGL_LAHIR
                            ,KODE_PPK_PERUJUK,NAMA_PPK_PERUJUK,KODE_PERUJUK,NAMA_PERUJUK,KETERANGAN_PRB,TUJUAN_KUNJUNGAN,FLAG_PROCEDURE
                            ,PENUNJANG,ASESMENT_PELAYANAN,IS_LAKA_LANTAS,
                            replace(CONVERT(VARCHAR(11),TGL_LAKA_LANTAS, 111), '/','-') as  TGL_LAKA_LANTAS,KET_LAKA_LANTAS,IS_SUPLESI,NO_SUPLESI
                            ,PROV_KODE,PROV_NAMA,KABUPATEN_KODE,KABUPATEN_NAMA,KECAMATAN_KODE
                            ,KECAMATAN_NAMA,KODE_ASAL_FASKES,NAMA_ASAL_FASKES,
                            replace(CONVERT(VARCHAR(11),TGL_RUJUKAN, 111), '/','-') as  TGL_RUJUKAN 
                            FROM PerawatanSQL.DBO.BPJS_T_SEP
                        where NO_SEP=:NO_SEP and BATAL='0'");
            $this->db->bind('NO_SEP', $NO_SEP);
            $dtReg =  $this->db->single();
            return $dtReg;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    function GoUpdateSEP($data)
    {
        $curl = curl_init();
        $JenisRujukanFaskesBPJS = $data['JenisFaskesKodeBPJS'];
        $JenisFaskesNamaBPJS = $data['JenisFaskesNamaBPJS'];
        $idPesertaBPJS = $data['nokartubpjs'];
        $idppkrujukanBPJS = $data['idppkrujukanBPJS'];
        $namappkrujukanBPJS = $data['namappkrujukanBPJS'];
        $nokartubpjs = $data['nokartubpjs'];
        // $norujukanBPJS = $data['norujukanBPJS'];
        $nonikktpBPJS = $data['nonikktpBPJS'];
        $statuspesertaBPJS = $data['statuspesertaBPJS'];
        $namapesertaBPJS = $data['namapesertaBPJS'];
        $keteranganprbBPJS = $data['keteranganprbBPJS'];
        $idhakKelasBPJS = $data['idhakKelasBPJS'];
        if ($idhakKelasBPJS == "1") {
            $idhakKelasBPJSx = "Kelas 1";
        } elseif ($idhakKelasBPJS == "2") {
            $idhakKelasBPJSx = "Kelas 2";
        } else if ($idhakKelasBPJS == "3") {
            $idhakKelasBPJSx = "Kelas 3";
        }
        $hakKelasBPJS = $data['hakKelasBPJS'];
        $cobnosuratBPJS = $data['cobnosuratBPJS'];
        $idfaskesBPJS = $data['idfaskesBPJS'];
        $namafaskesBPJS = $data['namafaskesBPJS'];
        $cobNamaAsuransiBPJS = $data['cobNamaAsuransiBPJS'];
        $norujukan = $data['norujukan'];
        //$kdjenispelayananbpjsBPJS = $data['kdjenispelayananbpjsBPJS'];
        //$nmjenispelayananbpjsBPJS = $data['nmjenispelayananbpjsBPJS'];
        $kdkelasperawatanBPJS = $data['kdkelasperawatanBPJS'];
        //$nmkelasperawatanBPJS = $data['nmkelasperawatanBPJS'];
        $TglSEP = $data['TglSEP'];
        $KodeDiagnosaBPJS = $data['KodeDiagnosaBPJS'];
        $NamaDiagnosaBPJS = $data['NamaDiagnosaBPJS'];
        $KodePoliklinikBPJS = $data['KodePoliklinikBPJS'];
        $NamaPoliklinikBPJS = $data['NamaPoliklinikBPJS'];
        $isJenisPelayananBPJS = $data['isJenisPelayananBPJS'];
        $KodeDokterBPJS = $data['KodeDokterBPJS'];
        $NamaDokterBPJS = $data['NamaDokterBPJS'];
        $isCobBPJS = $data['isCobBPJS'];
        $iscatarakBPJS = $data['iscatarakBPJS'];
        $NoSuratKontrolBPJS = $data['NoSuratKontrolBPJS'];
        $iscatatanBPJS = $data['iscatatanBPJS'];
        $LakaLantasBPJS = $data['LakaLantasBPJS'];
        $TglKejadianBPJS =   $data['TglKejadianBPJS'];
        $LakaLantasKetBPJS = $data['LakaLantasKetBPJS'];
        $SuplesiBPJS = $data['SuplesiBPJS'];
        $NoSuplesiBPJS = $data['NoSuplesiBPJS'];
        $SuplesiBPJSProvinsi = $data['SuplesiBPJSProvinsi'];
        $SuplesiBPJSProvinsiName  = $data['SuplesiBPJSProvinsiName'];
        $SuplesiBPJSKabupaten = $data['SuplesiBPJSKabupaten'];
        $SuplesiBPJSKabupatenName = $data['SuplesiBPJSKabupatenName'];
        $SuplesiBPJSKecamatan = $data['SuplesiBPJSKecamatan'];
        $SuplesiBPJSKecamatanName = $data['SuplesiBPJSKecamatanName'];
        $isNaikKelasBPJS = $data['isNaikKelasBPJS'];
        $PenanggungJawabBiaya = $data['PenanggungJawabBiaya'];
        $PembiayaanNiakKelasBPJS = $data['PembiayaanNiakKelasBPJS'];
        $NoMRBPJS = $data['NoMRBPJS'];
        $TglRujukan = $data['TglRujukan'] == "" ? "1990-01-01" : $data['TglRujukan'];
        $isEksekutifBPJS = $data['isEksekutifBPJS'];
        $TujuanKunjunganBPJS = $data['TujuanKunjunganBPJS'];
        $FlagProcedureBPJS = $data['FlagProcedureBPJS'];
        $PenujangBPJS = $data['PenujangBPJS'];
        $AsesmentPelayananBPJS  = $data['AsesmentPelayananBPJS'];
        $NoHpBPJS  = $data['NoHpBPJS'];
        $NoRegistrasiSIMRSBPJS  = $data['NoRegistrasiSIMRSBPJS'];
        $jenisKelaminKodeBPJS  = $data['jenisKelaminKodeBPJS'];
        $jenisKelaminNamaBPJS  = $data['jenisKelaminNamaBPJS'];
        $jenisPesertaKodeBPJS  = $data['jenisPesertaKodeBPJS'];
        $jenisPesertaNamaBPJS  = $data['jenisPesertaNamaBPJS'];
        $TglLahirBPJS = $data['TglLahirBPJS'];
        $xSEPNO = $data['xSEPNO'];
        $session = SessionManager::getCurrentSession();
        $userid = $session->username;
        $token = $session->token;
        $namauserx = $session->name;
        $dateNows = Utils::seCurrentDateTime();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        if ($isJenisPelayananBPJS == "1") {
            $DpjpPelayanan = "";
        } else {
            $DpjpPelayanan = $KodeDokterBPJS;
        }
        curl_setopt_array($curl, array(
            CURLOPT_URL =>  URL_BPJS . 'SEP/2.0/update',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => '{
           "request":{
              "t_sep":{
                 "noSep":"' . $xSEPNO . '",
                 "klsRawat":{
                    "klsRawatHak":"' . $idhakKelasBPJS . '",
                    "klsRawatNaik":"' . $kdkelasperawatanBPJS . '",
                    "pembiayaan":"' . $PembiayaanNiakKelasBPJS . '",
                    "penanggungJawab":"' . $PenanggungJawabBiaya . '"
                 },
                 "noMR":"' . $NoMRBPJS . '", 
                 "catatan":"' . $iscatatanBPJS . '",
                 "diagAwal":"' . $KodeDiagnosaBPJS . '",
                 "poli":{
                    "tujuan":"' . $KodePoliklinikBPJS . '",
                    "eksekutif":"' . $isEksekutifBPJS . '"
                 },
                 "cob":{
                    "cob":"' . $isCobBPJS . '"
                 },
                 "katarak":{
                    "katarak":"' . $iscatarakBPJS . '"
                 },
                 "jaminan":{
                    "lakaLantas":"' . $LakaLantasBPJS . '",
                    "penjamin":{
                       "tglKejadian":"' . $TglKejadianBPJS . '",
                       "keterangan":"' . $LakaLantasKetBPJS . '",
                       "suplesi":{
                          "suplesi":"' . $SuplesiBPJS . '",
                          "noSepSuplesi":"' . $NoSuplesiBPJS . '",
                          "lokasiLaka":{
                             "kdPropinsi":"' . $SuplesiBPJSProvinsi . '",
                             "kdKabupaten":"' . $SuplesiBPJSKabupaten . '",
                             "kdKecamatan":"' . $SuplesiBPJSKecamatan . '"
                          }
                       }
                    }
                 }, 
                 "dpjpLayan":"' . $DpjpPelayanan . '",
                 "noTelp":"' . $NoHpBPJS . '",
                 "user":"' . $namauserx . '"
              }
           }
        }',
            CURLOPT_HTTPHEADER => $headerbpjs,
        ));

        $output = curl_exec($curl);

        // tutup curl 
        curl_close($curl);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            //$ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));

            //$JsonDatax   = json_decode(json_encode($EncodeData), true); 
            if (substr($NoRegistrasiSIMRSBPJS, 0, 2) == "RJ") {
                $this->db->query("UPDATE perawatanSQL.dbo.Visit SET 
                NoSEP=:nosep,NoPesertaBPJS=:NO_KARTU
                WHERE NoRegistrasi=:noregistrasi");
                $this->db->bind('nosep', $xSEPNO);
                $this->db->bind('noregistrasi', $NoRegistrasiSIMRSBPJS);
                $this->db->bind('NO_KARTU', $idPesertaBPJS);
                $this->db->execute();
            } elseif (substr($NoRegistrasiSIMRSBPJS, 0, 2) == "RI") {
                $this->db->query("UPDATE RawatInapSQL.DBO.fvt SET 
                NoSEP=:nosep 
                WHERE NoRegRI=:noregistrasi");
                $this->db->bind('nosep', $xSEPNO);
                $this->db->bind('noregistrasi', $NoRegistrasiSIMRSBPJS);
                $this->db->execute();
            }
            if ($isJenisPelayananBPJS == "1") {
                $namaJenislay = "R. Inap";
            } else {
                $namaJenislay = "R. Jalan";
            }
            $this->db->query("UPDATE perawatanSQL.dbo.BPJS_T_SEP SET 
                NAIK_KELAS=:NAIK_KELAS,NAIK_KELAS_ID=:NAIK_KELAS_ID,PENANGGUNG_JAWAB=:PENANGGUNG_JAWAB,
                KODE_KELAS_RAWAT=:KODE_KELAS_RAWAT,KELAS_RAWAT=:KELAS_RAWAT,PENJAMIN=:PENJAMIN,
                NO_MR=:NO_MR,CATATAN=:CATATAN,KODE_DIAGNOSA=:KODE_DIAGNOSA,NAMA_DIAGNOSA=:NAMA_DIAGNOSA
                ,KODE_POLI=:KODE_POLI,NAMA_POLI=:NAMA_POLI,IS_EKSEKUTIF=:IS_EKSEKUTIF,
                IS_COB=:IS_COB,IS_KATARAK=:IS_KATARAK,IS_LAKA_LANTAS=:IS_LAKA_LANTAS,
                TGL_LAKA_LANTAS=:TGL_LAKA_LANTAS,KET_LAKA_LANTAS=:KET_LAKA_LANTAS,IS_SUPLESI=:IS_SUPLESI,
                NO_SUPLESI=:NO_SUPLESI,PROV_KODE=:PROV_KODE,PROV_NAMA=:PROV_NAMA,
                KABUPATEN_KODE=:KABUPATEN_KODE,KABUPATEN_NAMA=:KABUPATEN_NAMA,KECAMATAN_KODE=:KECAMATAN_KODE,
                KECAMATAN_NAMA=:KECAMATAN_NAMA,KODE_DOKTER=:KODE_DOKTER,NAMA_DOKTER=:NAMA_DOKTER,
                NO_TELEPON=:NO_TELEPON,USER_CREATE_LAST=:USER_CREATE_LAST,TGL_CREATE_LAST=:TGL_CREATE_LAST
                WHERE NO_SEP=:NO_SEP");
            $this->db->bind('NO_SEP', $xSEPNO);
            $this->db->bind('NAIK_KELAS', $isNaikKelasBPJS);
            $this->db->bind('NAIK_KELAS_ID', $kdkelasperawatanBPJS);
            $this->db->bind('PENANGGUNG_JAWAB', $PenanggungJawabBiaya);
            $this->db->bind('KODE_KELAS_RAWAT', $idhakKelasBPJS);
            $this->db->bind('KELAS_RAWAT', $hakKelasBPJS);
            $this->db->bind('PENJAMIN', $PembiayaanNiakKelasBPJS);
            $this->db->bind('NO_MR', $NoMRBPJS);
            $this->db->bind('CATATAN', $iscatatanBPJS);
            $this->db->bind('KODE_DIAGNOSA', $KodeDiagnosaBPJS);
            $this->db->bind('NAMA_DIAGNOSA', $NamaDiagnosaBPJS);
            $this->db->bind('KODE_POLI', $KodePoliklinikBPJS);
            $this->db->bind('NAMA_POLI', $NamaPoliklinikBPJS);
            $this->db->bind('KODE_DOKTER', $KodeDokterBPJS);
            $this->db->bind('NAMA_DOKTER', $NamaDokterBPJS);
            $this->db->bind('IS_EKSEKUTIF', $isEksekutifBPJS);
            $this->db->bind('IS_KATARAK', $iscatarakBPJS);
            $this->db->bind('IS_COB', $isCobBPJS);
            $this->db->bind('IS_LAKA_LANTAS', $LakaLantasBPJS);
            $this->db->bind('TGL_LAKA_LANTAS', $TglKejadianBPJS);
            $this->db->bind('KET_LAKA_LANTAS', $LakaLantasKetBPJS);
            $this->db->bind('IS_SUPLESI', $SuplesiBPJS);
            $this->db->bind('NO_SUPLESI', $NoSuplesiBPJS);
            $this->db->bind('PROV_KODE', $SuplesiBPJSProvinsi);
            $this->db->bind('PROV_NAMA', $SuplesiBPJSProvinsiName);
            $this->db->bind('KABUPATEN_KODE', $SuplesiBPJSKabupaten);
            $this->db->bind('KABUPATEN_NAMA', $SuplesiBPJSKabupatenName);
            $this->db->bind('KECAMATAN_KODE', $SuplesiBPJSKecamatan);
            $this->db->bind('KECAMATAN_NAMA', $SuplesiBPJSKecamatanName);
            $this->db->bind('NO_TELEPON', $NoHpBPJS);
            $this->db->bind('USER_CREATE_LAST', $namauserx);
            $this->db->bind('TGL_CREATE_LAST', $dateNows);
            $this->db->execute();
            $callback = array(
                'status' => 'success',
                'hasil' => $ResultEncriptLzString['1'],
            );
            return $callback;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message'],
                'jenispelayanan' => $LakaLantasBPJS
            );
            return $callback;
        }
    }
    function GoVerificationFinger($data)
    {
        $FingerNoKartu = $data['FingerNoKartu'];
        $FingerTgl = $data['FingerTgl'];
        $dateNow = Utils::datenowcreateNotFull();
        if ($FingerNoKartu == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Masukan No. Kartu !',
            );
            echo json_encode($callback);
            exit;
        }

        if ($FingerTgl == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Masukan Tgl SEP !',
            );
            echo json_encode($callback);
            exit;
        }

        $urlApi = "SEP/FingerPrint/Peserta/$FingerNoKartu/TglPelayanan/$FingerTgl";

        // persiapkan curl
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS . $urlApi);
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
        // set time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            // $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));

            //echo json_encode($output);
            $callback = array(
                'status' => 'success',
                'hasil' => $ResultEncriptLzString,
            );
            return $callback;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']

            );
            return $callback;
        }
    }
    function GoVerificationFingerList($data)
    {

        $FingerNoKartu = $data['FingerNoKartu'];
        $FingerTgl = $data['FingerTgl'];
        if ($FingerNoKartu == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Masukan No. Kartu !',
            );
            echo json_encode($callback);
            exit;
        }

        if ($FingerTgl == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Masukan Tgl SEP !',
            );
            echo json_encode($callback);
            exit;
        }
        // persiapkan curl
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS . "SEP/FingerPrint/List/Peserta/TglPelayanan/$FingerTgl");
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
        // set time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            //echo json_encode($output);
            foreach ($ResultEncriptLzString['1']['list'] as $key => $jsons) { // This will search in the 2 jsons
                $pasing['noKartu'] = $jsons['noKartu'];
                $pasing['noSEP'] = $jsons['noSEP'];
                $datas[] = $pasing;
            }
            return $datas;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']

            );
            return $callback;
        }
    }
    public function getSepSIMRSAllbyDate($data)
    {
        try {
            $MTglKunjunganBPJS = $data['MTglKunjunganBPJS'];
            $MJenisPelayananBPJS = $data['MJenisPelayananBPJS'];

            $this->db->query("SELECT NO_SEP,NO_KARTU,NO_RUJUKAN,replace(CONVERT(VARCHAR(11), TGL_SEP, 111), '/','-') AS TGL_SEP,
                        JENIS_RAWAT,NAMA_DIAGNOSA,NAMA_POLI,NO_REGISTRASI ,NAMA_PESERTA,NAMA_DOKTER
                        FROM PerawatanSQL.DBO.BPJS_T_SEP where replace(CONVERT(VARCHAR(11), TGL_SEP, 111), '/','-')=:MTglKunjunganBPJS
                        and  BATAL='0' and KODE_JENIS_RAWAT=:MJenisPelayananBPJS");
            $this->db->bind('MJenisPelayananBPJS', $MJenisPelayananBPJS);
            $this->db->bind('MTglKunjunganBPJS', $MTglKunjunganBPJS);
            $data =  $this->db->resultSet();
            foreach ($data as $key) {
                $pasing['noSep'] = $key['NO_SEP'];
                $pasing['noKartu'] = $key['NO_KARTU'];
                $pasing['noRujukan'] = $key['NO_RUJUKAN'];
                $pasing['tglSep'] = $key['TGL_SEP'];
                $pasing['nama'] = $key['NAMA_PESERTA'];
                $pasing['jnsPelayanan'] = $key['JENIS_RAWAT'];
                $pasing['diagnosa'] = $key['NAMA_DIAGNOSA'];
                $pasing['kelasRawat'] = '-';
                $pasing['poli'] = $key['NAMA_POLI'];
                $pasing['noreg'] = $key['NO_REGISTRASI'];
                $pasing['NAMA_DOKTER'] = $key['NAMA_DOKTER'];
                $dataX[] = $pasing;
            }
            return $dataX;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    function GoTambahAntrianBPJS($data)
    {
        $curl = curl_init();
        $kodebooking = $data['kodebooking'];
        $NoSep = $data['NoSep'];
        $NamaJaminan = $data['NamaJaminan'];
        $AntrolJenisKunungan = $data['AntrolJenisKunungan'];
        if ($kodebooking == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Masukan Kode Booking !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($AntrolJenisKunungan == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Masukan Jenis Kunjungan !',
            );
            echo json_encode($callback);
            exit;
        }
        // GET SEP
        if ($NamaJaminan === "BPJS Kesehatan") {
            $this->db->query("SELECT CC.[Mobile Phone] as Medrec_HomePhone,A.ID,A.NO_SEP,A.NO_REGISTRASI,A.NO_MR,A.NO_RUJUKAN,
                            A.NO_SPRI,A.NO_NIK,A.NO_KARTU,replace(CONVERT(VARCHAR(11), A.TGL_SEP, 111), '/','-') as TGL_SEP,
                            A.KODE_POLI,A.NAMA_POLI,A.KODE_DOKTER,A.NAMA_DOKTER,A.BATAL,
                            B.JamPraktek,b.NoAntrianAll,a.NO_KARTU,a.NO_TELEPON
							,replace(CONVERT(VARCHAR(11), CC.InputDate, 111), '/','-') as TglMR,
							CASE WHEN replace(CONVERT(VARCHAR(11), CC.InputDate, 111), '/','-')=replace(CONVERT(VARCHAR(11), A.TGL_SEP, 111), '/','-') 
							THEN '1' ELSE '0' END AS MR_ISNEW,dd.codeBPJS as kodeunitbpjs,dd.NamaBPJS , ee.ID_Dokter_BPJS,ee.First_Name as namadokter,b.ID_JadwalPraktek
                            ,b.jampraktek as SessionPoli,EE.ID  as IdDokterSIMRS,ee.NAMA_Dokter_BPJS
                            FROM PerawatanSQL.DBO.BPJS_T_SEP A
                            INNER JOIN PerawatanSQL.DBO.Visit B ON A.NO_SEP = B.NoSEP 
                            AND A.NO_REGISTRASI = B.NoRegistrasi
							INNER JOIN MasterdataSQL.DBO.Admision CC ON CC.NoMR = b.NoMR
                            INNER JOIN MasterdataSQL.DBO.MstrUnitPerwatan DD ON DD.ID = B.Unit
                            INNER JOIN MasterdataSQL.DBO.Doctors EE ON EE.ID = B.Doctor_1
                            WHERE A.NO_SEP=:NoSep AND A.NO_REGISTRASI=:kodebooking");
            $this->db->bind('NoSep', $NoSep);
            $this->db->bind('kodebooking', $kodebooking);
            $dtSEP =  $this->db->single();
            $jenispasien = "JKN";
        } else {
            $this->db->query("SELECT CC.[Mobile Phone] as Medrec_HomePhone,'' ID,'' NO_SEP,B.NoRegistrasi AS NO_REGISTRASI,B.NoMR AS NO_MR,'' NO_RUJUKAN,
                            '' NO_SPRI, CC.Nik AS  NO_NIK,B.NoPesertaBPJS AS NO_KARTU,replace(CONVERT(VARCHAR(11), B.TglKunjungan, 111), '/','-') AS TGL_SEP,
                            '' KODE_POLI,'' NAMA_POLI,'' KODE_DOKTER,'' NAMA_DOKTER,'' BATAL,
                            B.JamPraktek,b.NoAntrianAll,CC.[Mobile Phone] AS NO_TELEPON
							,replace(CONVERT(VARCHAR(11), CC.InputDate, 111), '/','-') as TglMR,
							CASE WHEN replace(CONVERT(VARCHAR(11), CC.InputDate, 111), '/','-')=replace(CONVERT(VARCHAR(11), B.TglKunjungan, 111), '/','-') 
							THEN '1' ELSE '0' END AS MR_ISNEW,dd.codeBPJS as kodeunitbpjs,dd.NamaBPJS , ee.ID_Dokter_BPJS,ee.First_Name as namadokter,b.ID_JadwalPraktek
                            ,b.jampraktek as SessionPoli,EE.ID  as IdDokterSIMRS,ee.NAMA_Dokter_BPJS
                            FROM PerawatanSQL.DBO.Visit B  
							INNER JOIN MasterdataSQL.DBO.Admision CC ON CC.NoMR = b.NoMR
                            INNER JOIN MasterdataSQL.DBO.MstrUnitPerwatan DD ON DD.ID = B.Unit
                            INNER JOIN MasterdataSQL.DBO.Doctors EE ON EE.ID = B.Doctor_1
                            WHERE B.NoRegistrasi=:kodebooking");
            $this->db->bind('kodebooking', $kodebooking);
            $dtSEP =  $this->db->single();
            $jenispasien = "NON JKN";
        }
        $nokartubpjs = $dtSEP['NO_KARTU'];
        // $NAMA_Dokter_BPJS = $dtSEP['NAMA_Dokter_BPJS'];
        $nonikktpBPJS = $dtSEP['NO_NIK'];
        $NoMRBPJS = $dtSEP['NO_MR'];
        $NoHpBPJS  = $dtSEP['NO_TELEPON'];
        $KodePoliklinikBPJS =  $dtSEP['kodeunitbpjs'];
        $NamaPoliklinikBPJS = $dtSEP['NamaBPJS'];
        $pasienbaru = $dtSEP['MR_ISNEW'];
        $TglSEP = $dtSEP['TGL_SEP'];
        $KodeDokterBPJS = $dtSEP['ID_Dokter_BPJS'];
        $NamaDokterBPJS = $dtSEP['namadokter'];
        $NO_SPRI = $dtSEP['NO_SPRI'];
        $NO_RUJUKAN = $dtSEP['NO_RUJUKAN'];
        $Medrec_HomePhone  = $dtSEP['Medrec_HomePhone'];

         
        $nomorantrean = $dtSEP['NoAntrianAll'];
        $IDJadwal = $dtSEP['ID_JadwalPraktek'];
        $SessionPoli = $dtSEP['SessionPoli'];
        $IdDokterSIMRS = $dtSEP['IdDokterSIMRS'];
        $arraynomorantrean = preg_split("/\-/", $nomorantrean);
        $angkaantrean = $arraynomorantrean[1];
      

        //waktu
        $datename  = date("l", strtotime($TglSEP));
        $this->db->query("SELECT Senin_Waktu,Selasa_Waktu,Rabu_Waktu,
                        Kamis_Waktu,Jumat_Waktu,Sabtu_Waktu,Minggu_Waktu,
                        Senin_Max_NonJKN,Senin_Max_JKN,Selasa_Max_JKN,Selasa_Max_NonJKN,Rabu_Max_JKN,Rabu_Max_NonJKN,
                        Kamis_Max_JKN,Kamis_Max_NonJKN,Jumat_Max_JKN,Jumat_Max_NonJKN,Sabtu_Max_JKN,Sabtu_Max_NonJKN,
                        Minggu_Max_JKN,Minggu_Max_NonJKN
                        FROM MasterdataSQL.DBO.JadwalPraktek WHERE ID=:IDJadwal");
        $this->db->bind('IDJadwal', $IDJadwal);
        $dtjdwl =  $this->db->single();
        $jampraktek = $dtjdwl['Minggu_Waktu'];
        if ($datename == "Sunday") {
            $jampraktek = $dtjdwl['Minggu_Waktu'];
            $Max_NonJKN = $dtjdwl['Minggu_Max_NonJKN'];
            $Max_JKN = $dtjdwl['Minggu_Max_JKN'];
        } elseif ($datename == "Monday") {
            $jampraktek = $dtjdwl['Senin_Waktu'];
            $Max_NonJKN = $dtjdwl['Senin_Max_NonJKN'];
            $Max_JKN = $dtjdwl['Senin_Max_JKN'];
        } elseif ($datename == "Tuesday") {
            $jampraktek = $dtjdwl['Selasa_Waktu'];
            $Max_NonJKN = $dtjdwl['Selasa_Max_NonJKN'];
            $Max_JKN = $dtjdwl['Selasa_Max_JKN'];
        } elseif ($datename == "Wednesday") {
            $jampraktek = $dtjdwl['Rabu_Waktu'];
            $Max_NonJKN = $dtjdwl['Rabu_Max_NonJKN'];
            $Max_JKN = $dtjdwl['Rabu_Max_JKN'];
        } elseif ($datename == "Thursday") {
            $jampraktek = $dtjdwl['Kamis_Waktu'];
            $Max_NonJKN = $dtjdwl['Kamis_Max_NonJKN'];
            $Max_JKN = $dtjdwl['Kamis_Max_JKN'];
        } elseif ($datename == "Friday") {
            $jampraktek = $dtjdwl['Jumat_Waktu'];
            $Max_NonJKN = $dtjdwl['Jumat_Max_NonJKN'];
            $Max_JKN = $dtjdwl['Jumat_Max_JKN'];
        } elseif ($datename == "Saturday") {
            $jampraktek = $dtjdwl['Sabtu_Waktu'];
            $Max_NonJKN = $dtjdwl['Sabtu_Max_NonJKN'];
            $Max_JKN = $dtjdwl['Sabtu_Max_JKN'];
        }

        // Jumlah antrian Saat ini
        $this->db->query("SELECT COUNT(ID) AS JUMLAHJKN FROM PerawatanSQL.DBO.Visit
                where replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-')=:ApmDate
                and Doctor_1=:DoctorID and JamPraktek=:JamPraktek and batal='0'
                and perusahaan='313' and PatientType='5'");
        $this->db->bind('JamPraktek', $SessionPoli);
        $this->db->bind('DoctorID', $IdDokterSIMRS);
        $this->db->bind('ApmDate', $TglSEP);
        $datallantrian =  $this->db->single();
        $JUMLAHJKN = $datallantrian['JUMLAHJKN'];

        $this->db->query("SELECT COUNT(ID) AS JUMLAHNONJKN FROM PerawatanSQL.DBO.Visit
                        where replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-')=:ApmDate and Doctor_1=:DoctorID 
                        and JamPraktek=:JamPraktek and batal='0'
                        and id not in(
                                SELECT ID  FROM PerawatanSQL.DBO.Visit
                                where replace(CONVERT(VARCHAR(11), TglKunjungan, 111), '/','-')=:ApmDate2 
                                and Doctor_1=:DoctorID2 and JamPraktek=:JamPraktek2 and batal='0'
                                and perusahaan='313' and PatientType='5'
                        ) ");
        $this->db->bind('JamPraktek', $SessionPoli);
        $this->db->bind('JamPraktek2', $SessionPoli);
        $this->db->bind('DoctorID', $IdDokterSIMRS);
        $this->db->bind('DoctorID2', $IdDokterSIMRS);
        $this->db->bind('ApmDate', $TglSEP);
        $this->db->bind('ApmDate2', $TglSEP);
        $datasdhpgl =  $this->db->single();
        $JUMLAHNONJKN = $datasdhpgl['JUMLAHNONJKN'];

        $sisakuotajkn = $Max_JKN - $JUMLAHJKN;
        $sisakuotanonjkn = $Max_NonJKN - $JUMLAHNONJKN;

        $keterangan = "Peserta harap 30 menit lebih awal guna pencatatan administrasi.";

        $session = SessionManager::getCurrentSession();
        $userid = $session->username;
        $token = $session->token;
        $namauserx = $session->name;
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS_Antrian($tStamp);
        $dateNows = Utils::seCurrentDateTime();
        $datenownotfull = Utils::datenowcreateNotFull();
       

        // cek apakah kode booking dari jkn, jika dari jkn kode booking dari apointment
        // jika tidak maka ambil noregistrasinya
        $this->db->query("SELECT NoRegistrasi,NoBooking 
        FROM PerawatanSQL.DBO.Apointment WHERE NoRegistrasi=:NoRegistrasi and Company = :Company ");
        $this->db->bind('NoRegistrasi', $kodebooking);
        $this->db->bind('Company', 'JKN MOBILE');
        $dtaptmn =  $this->db->single();
        $dtrowCount =  $this->db->rowCount();
        if ($dtrowCount) {
            $kodeBookingSendAntrian = $dtaptmn['NoBooking'];
        } else {
            $kodeBookingSendAntrian = $kodebooking;
        }

         // update ke tabel sep dulu untuk waktu task nya....
        // cek dulu log nya ada gak di task1
            $this->db->query("SELECT DATE_CREATE 
                            from PerawatanSQL.dbo.BPJS_TASKID_LOG where 
                            KODE_TRANSAKSI=:xkodebooking and TASK_ID='1'");
            $this->db->bind('xkodebooking', $kodeBookingSendAntrian);
            $this->db->execute();
            $dataTask1Exist =  $this->db->single();
            $rowdataTask1Exist =  $this->db->rowCount();
            if ($rowdataTask1Exist) {
                $valuewaktutask1temp = $dataTask1Exist['DATE_CREATE'];
            } else {
                $valuewaktutask1temp = Utils::seCurrentDateTime();
            }


        $this->db->query("SELECT DATEADD(minute,-3,Task2) as Task1 ,Task2,task1 as task1asli,TGL_CREATE
                        FROM PerawatanSQL.DBO.BPJS_T_SEP
                        WHERE NO_REGISTRASI=:kodebookingx ");
        $this->db->bind('kodebookingx', $kodebooking);
        $this->db->execute();
        $datarow =  $this->db->single();

        if ($datarow['task1asli'] == null) {

            // if ($datarow['Task2'] == null) {
                $this->db->query("SELECT DATEADD(minute,2,[Visit Date]) as fixTask2
                FROM PerawatanSQL.DBO.Visit
                WHERE NoRegistrasi=:noreg ");
                $this->db->bind('noreg', $kodebooking);
                $this->db->execute();
                $datarowRegFix =  $this->db->single();
                $valuewaktutask1 = $datarowRegFix['fixTask2'];

            // }else{
                // $valuewaktutask1 = $datarow['TGL_CREATE'];
            // }
                $this->db->query("UPDATE PerawatanSQL.DBO.BPJS_T_SEP SET Task1=:task4time
                                    WHERE NO_REGISTRASI=:kodebookingx");
                $this->db->bind('kodebookingx', $kodebooking);
                $this->db->bind('task4time', $valuewaktutask1);
                $this->db->execute();
        }else{
             $valuewaktutask1 = $datarow['task1asli'];
        }

        // set waktu 
        $estimasi2 = strtotime($valuewaktutask1);
        $estimasidilayani = $estimasi2 * 1000;
 
        if($AntrolJenisKunungan == "1"){ //Rujukan FKTP
            $noreff = $NO_RUJUKAN;
        }elseif($AntrolJenisKunungan == "2"){ //Rujukan Internal
              $genOtp = random_int(10000, 99999);
              $date = Utils::idtrsByDateOnly();
              $noreff =  "0114R067".$date.$genOtp;
        }elseif($AntrolJenisKunungan == "3"){ //Kontrol 0114R067070824116747
            $noreff = $NO_SPRI;
        }elseif($AntrolJenisKunungan == "4"){ //Rujukan Antar RS
            $noreff = $NO_RUJUKAN;
        }
        
        curl_setopt_array($curl, array(
            CURLOPT_URL =>  URL_BPJS_ANTRIAN . 'antrean/add',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                        "kodebooking": "' . $kodeBookingSendAntrian . '",
                        "jenispasien": "' . $jenispasien . '",
                        "nomorkartu": "' . $nokartubpjs . '",
                        "nik": "' . $nonikktpBPJS . '",
                        "nohp": "' . $Medrec_HomePhone . '",
                        "kodepoli": "' . $KodePoliklinikBPJS . '",
                        "namapoli": "' . $NamaPoliklinikBPJS . '",
                        "pasienbaru": "' . $pasienbaru . '",
                        "norm":"' . $NoMRBPJS . '",
                        "tanggalperiksa": "' . $TglSEP . '",
                        "kodedokter": "' . $KodeDokterBPJS . '",
                        "namadokter": "' . $NamaDokterBPJS . '",
                        "jampraktek": "' . $jampraktek . '",
                        "jeniskunjungan": "' . $AntrolJenisKunungan . '",
                        "nomorreferensi": "' . $noreff . '",
                        "nomorantrean": "' . $nomorantrean . '",
                        "angkaantrean": "' . $angkaantrean . '",
                        "estimasidilayani": "' . $estimasidilayani . '",
                        "sisakuotajkn": "' . $sisakuotajkn . '",
                        "kuotajkn": "' . $Max_JKN . '",
                        "sisakuotanonjkn": "' . $sisakuotanonjkn . '",
                        "kuotanonjkn": "' . $Max_NonJKN . '",
                        "keterangan": "' . $keterangan . '"
                        }',
            CURLOPT_HTTPHEADER => $headerbpjs,
        ));
        $output = curl_exec($curl);
        // tutup curl 
        curl_close($curl);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metadata']['code'] == "200") {

            // CARI DULU NO BOOKING, APAKAH DARI MOBILE JKN 
            // $this->db->query("SELECT NoRegistrasi,NoBooking 
            //                 FROM PerawatanSQL.DBO.Apointment WHERE NoRegistrasi=:NoRegistrasi");
            // $this->db->bind('NoRegistrasi', $TglSEP);
            // $dtaptmn =  $this->db->single();
            // $dtrowCount =  $this->db->rowCount();
            // if ($dtrowCount > 0) {
            //     $kodebookingx = $dtaptmn['NoBooking'];
            // } else {
            //     $kodebookingx = $kodebooking;
            // }


            $curl = curl_init();
            $taskid = "1";

            curl_setopt_array($curl, array(
                CURLOPT_URL =>  URL_BPJS_ANTRIAN . 'antrean/updatewaktu',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '                                                
                    {
                        "kodebooking": "' . $kodeBookingSendAntrian . '",
                        "taskid":  "' . $taskid . '",
                        "waktu": "' . $estimasidilayani . '"
                    }
                        ',
                CURLOPT_HTTPHEADER => $headerbpjs,
            ));
            $output = curl_exec($curl);
            // tutup curl 
            curl_close($curl);
            // ubah string JSON menjadi array
            $JsonData = json_decode($output, TRUE);
            if ($JsonData['metadata']['code'] == "200") {
                $this->db->query("INSERT INTO perawatanSQL.dbo.BPJS_TASKID_LOG 
                                    (KODE_TRANSAKSI,WAKTU,TASK_ID,DATE_CREATE) 
                                    VALUES 
                                    (:kodebooking,:waktu,:taskid,:DATE_CREATE)");
                $this->db->bind('kodebooking', $kodeBookingSendAntrian);
                $this->db->bind('waktu', $estimasidilayani);
                $this->db->bind('taskid', $taskid);
                $this->db->bind('DATE_CREATE', $valuewaktutask1);
                $this->db->execute();

                $callback = array(
                    'status' => 'success',
                    'Max_JKN' => 'tes',
                );
                return $callback;
            }
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metadata']['message'],
                'KodeDokterBPJS' => $KodeDokterBPJS,
                'NamaDokterBPJS' => $NamaDokterBPJS,
                'datename' => $datename
            );
            return $callback;
        }
    }




    function GoBatalAntrianBPJS($data)
    {
        $curl = curl_init();
        $noregbatal = $data['noregbatal'];
        $nosepbatal = $data['nosepbatal'];
        $alasanbatal = $data['alasanbatal'];

        if ($noregbatal == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Masukan Kode Booking !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($alasanbatal == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Masukan Alasan Batal !',
            );
            echo json_encode($callback);
            exit;
        }
        // CARI DULU NO BOOKING, APAKAH DARI MOBILE JKN 
        $this->db->query("SELECT NoRegistrasi,NoBooking 
                            FROM PerawatanSQL.DBO.Apointment WHERE NoRegistrasi=:NoRegistrasi and Company='JKN MOBILE'");
        $this->db->bind('NoRegistrasi', $noregbatal);
        $dtaptmn =  $this->db->single();
        $dtrowCount =  $this->db->rowCount();
        if ($dtrowCount > 0) {
            $kodebookingx = $dtaptmn['NoBooking'];
        } else {
            $kodebookingx = $noregbatal;
        }
        $waktux = Utils::seCurrentDateTime();
        $estimasi2 = strtotime($waktux);
        $estimasidilayani = $estimasi2 * 1000;
        //waktu  
        $session = SessionManager::getCurrentSession();
        $userid = $session->username;
        $token = $session->token;
        $namauserx = $session->name;
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS_Antrian($tStamp);
        $dateNows = Utils::seCurrentDateTime();
        $datenownotfull = Utils::datenowcreateNotFull();

        curl_setopt_array($curl, array(
            CURLOPT_URL =>  URL_BPJS_ANTRIAN . 'antrean/batal',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                        "kodebooking": "' . $kodebookingx . '",
                        "keterangan": "' . $alasanbatal . '"
                        }',
            CURLOPT_HTTPHEADER => $headerbpjs,
        ));
        $output = curl_exec($curl);
        // tutup curl 
        curl_close($curl);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metadata']['code'] == "200") {
            $curl = curl_init();
            $taskid = "99";

            curl_setopt_array($curl, array(
                CURLOPT_URL =>  URL_BPJS_ANTRIAN . 'antrean/updatewaktu',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '                                                
                    {
                        "kodebooking": "' . $kodebookingx . '",
                        "taskid":  "' . $taskid . '",
                        "waktu": "' . $estimasidilayani . '"
                    }
                        ',
                CURLOPT_HTTPHEADER => $headerbpjs,
            ));
            $output = curl_exec($curl);
            // tutup curl 
            curl_close($curl);
            // ubah string JSON menjadi array
            $JsonData = json_decode($output, TRUE);
            if ($JsonData['metadata']['code'] == "200") {
                $this->db->query("INSERT INTO perawatanSQL.dbo.BPJS_TASKID_LOG 
                                    (KODE_TRANSAKSI,WAKTU,TASK_ID,DATE_CREATE) 
                                    VALUES 
                                    (:kodebooking,:waktu,:taskid,:DATE_CREATE)");
                $this->db->bind('kodebooking', $kodebookingx);
                $this->db->bind('waktu', $estimasidilayani);
                $this->db->bind('taskid', $taskid);
                $this->db->bind('DATE_CREATE', $waktux);
                $this->db->execute();

                $callback = array(
                    'status' => 'success',
                    'Max_JKN' => 'tes',
                );
                return $callback;
            } else {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => $JsonData['metadata']['message'],
                );
                return $callback;
            }
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metadata']['message'],
            );
            return $callback;
        }
    }

    function UpdateWaktuAntrian($data)
    {
        $curl = curl_init();
        //var_dump($data['NoTrs'],'tessssssssssssxx');exit;
        $NoTrs = $data['NoTrs'];
        $taskid = (int) $data['TaskID'];
        /*
        if ($NoTrs == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Masukan Kode Booking !',
            );
            echo json_encode($callback);
            exit;
        }
        */

        $this->db->query("SELECT NoRegistrasi,NoBooking 
                            FROM PerawatanSQL.DBO.Apointment
                             WHERE NoRegistrasi=:NoRegistrasi AND Company=:company");
        $this->db->bind('NoRegistrasi', $NoTrs);
        $this->db->bind('company', 'JKN MOBILE');
        $dtaptmn =  $this->db->single();
        $getData = $this->db->resultSet();
        $dtrowCount = count($getData);
        if ($dtrowCount > 0) {
            $kodebookingx = $dtaptmn['NoBooking'];
        } else {
            $kodebookingx = $NoTrs;
        }

        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS_Antrian($tStamp);
        $dateNows = Utils::seCurrentDateTime();
        $datenownotfull = Utils::datenowcreateNotFull();
        $converttime = strtotime($dateNows) * 1000;
        //var_dump($kodebookingx,$taskid,$converttime);exit;
        if ($taskid == "3") {
            // update ke tabel sep dulu untuk waktu task nya....
            $this->db->query("SELECT Task3
                        FROM PerawatanSQL.DBO.BPJS_T_SEP
                        WHERE NO_REGISTRASI=:kodebookingx ");
            $this->db->bind('kodebookingx', $kodebookingx);
            $this->db->execute();
            $datarow =  $this->db->single();
            if ($datarow['Task3'] == null) {
                $this->db->query("UPDATE PerawatanSQL.DBO.BPJS_T_SEP SET Task3=:task4time
                                WHERE NO_REGISTRASI=:kodebookingx");
                $this->db->bind('kodebookingx', $kodebookingx);
                $this->db->bind('task4time', $dateNows);
                $this->db->execute();
            }
        } elseif ($taskid == "4") {
            // update ke tabel sep dulu untuk waktu task nya....
            $this->db->query("SELECT Task3
                        FROM PerawatanSQL.DBO.BPJS_T_SEP
                        WHERE NO_REGISTRASI=:kodebookingx ");
            $this->db->bind('kodebookingx', $kodebookingx);
            $this->db->execute();
            $datarow =  $this->db->single();
            if ($datarow['Task3'] == null) {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => "Task 3 Masih Kosong, Silahkan Konfirmasi ke Perawat Untuk Save Nursing Assesment !!!!",
                );
                return $callback;
                exit;
            } else {
                $this->db->query("SELECT Task4
                        FROM PerawatanSQL.DBO.BPJS_T_SEP
                        WHERE NO_REGISTRASI=:kodebookingx ");
                $this->db->bind('kodebookingx', $kodebookingx);
                $this->db->execute();
                $datarow =  $this->db->single();
                if ($datarow['Task4'] == null) {
                    $this->db->query("UPDATE PerawatanSQL.DBO.BPJS_T_SEP SET Task4=:task4time
                                WHERE NO_REGISTRASI=:kodebookingx");
                    $this->db->bind('kodebookingx', $kodebookingx);
                    $this->db->bind('task4time', $dateNows);
                    $this->db->execute();
                }
            }
        } elseif ($taskid == "5") {
            // update ke tabel sep dulu untuk waktu task nya....
            $this->db->query("SELECT Task5
                        FROM PerawatanSQL.DBO.BPJS_T_SEP
                        WHERE NO_REGISTRASI=:kodebookingx ");
            $this->db->bind('kodebookingx', $kodebookingx);
            $this->db->execute();
            $datarow =  $this->db->single();
            if ($datarow['Task5'] == null) {
                $this->db->query("UPDATE PerawatanSQL.DBO.BPJS_T_SEP SET Task5=:task4time
                                WHERE NO_REGISTRASI=:kodebookingx");
                $this->db->bind('kodebookingx', $kodebookingx);
                $this->db->bind('task4time', $dateNows);
                $this->db->execute();
            }
        } elseif ($taskid == "6") {
            // update ke tabel sep dulu untuk waktu task nya....
            $this->db->query("SELECT Task6
                        FROM PerawatanSQL.DBO.BPJS_T_SEP
                        WHERE NO_REGISTRASI=:kodebookingx ");
            $this->db->bind('kodebookingx', $kodebookingx);
            $this->db->execute();
            $datarow =  $this->db->single();
            if ($datarow['Task6'] == null) {
                $this->db->query("UPDATE PerawatanSQL.DBO.BPJS_T_SEP SET Task6=:task4time
                                WHERE NO_REGISTRASI=:kodebookingx");
                $this->db->bind('kodebookingx', $kodebookingx);
                $this->db->bind('task4time', $dateNows);
                $this->db->execute();
                $callback = array(
                    'status' => 'success',
                );
                return $callback;
            }
            /// CEK DUULU DATANYA SUUDAH SAMPE 5 BELOM
            // $this->db->query("SELECT KODE_TRANSAKSI from PerawatanSQL.dbo.BPJS_TASKID_LOG 
            // 		where KODE_TRANSAKSI =:kodebookingx and TASK_ID >= '5' ");
            // $this->db->bind('kodebookingx', $kodebookingx); 
            // $this->db->execute();
            // $dtrowCount6 =  $this->db->rowCount();
            // if ($dtrowCount6 < 1) {
            //     curl_setopt_array($curl, array(
            //         CURLOPT_URL =>  URL_BPJS_ANTRIAN . 'antrean/updatewaktu',
            //         CURLOPT_RETURNTRANSFER => true,
            //         CURLOPT_ENCODING => '',
            //         CURLOPT_MAXREDIRS => 10,
            //         CURLOPT_TIMEOUT => 0,
            //         CURLOPT_FOLLOWLOCATION => false,
            //         CURLOPT_SSL_VERIFYPEER => false,
            //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //         CURLOPT_CUSTOMREQUEST => 'POST',
            //         CURLOPT_POSTFIELDS => '{
            //             "kodebooking": "' . $kodebookingx . '",
            //             "taskid": "' . $taskid . '",
            //             "waktu": "' . $converttime . '"
            //         }',

            //         CURLOPT_HTTPHEADER => $headerbpjs,
            //     ));
            //     $output = curl_exec($curl);
            //     // tutup curl 
            //     curl_close($curl);
            //     // ubah string JSON menjadi array
            //     $JsonData = json_decode($output, TRUE);
            //     //var_dump($JsonData,'sssss');exit;
            //     if ($JsonData['metadata']['code'] == "200") {
            //         $EncodeData = json_encode($JsonData);
            //         $this->db->query("INSERT INTO perawatanSQL.dbo.BPJS_TASKID_LOG 
            //                             (KODE_TRANSAKSI,WAKTU,TASK_ID,DATE_CREATE) 
            //                             VALUES 
            //                             (:kodebooking,:waktu,:taskid,:DATE_CREATE)");
            //         $this->db->bind('kodebooking', $kodebookingx);
            //         $this->db->bind('waktu', $converttime);
            //         $this->db->bind('taskid', $taskid);
            //         $this->db->bind('DATE_CREATE', $dateNows);
            //         $this->db->execute();

            //         $callback = array(
            //             'status' => 'success',
            //         );
            //         return $callback;
            //     } else {
            //         $callback = array(
            //             'status' => 'warning',
            //             'errorname' => $JsonData['metadata']['message'],
            //         );
            //         return $callback;
            //     }
            // } else {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => "Task Terakhir Bukan 5, Simpan Gagal !!!!",
            //     );
            //     return $callback;
            // }
        } elseif ($taskid == "7") {
            // update ke tabel sep dulu untuk waktu task nya....
            $this->db->query("SELECT Task7
                        FROM PerawatanSQL.DBO.BPJS_T_SEP
                        WHERE NO_REGISTRASI=:kodebookingx ");
            $this->db->bind('kodebookingx', $kodebookingx);
            $this->db->execute();
            $datarow =  $this->db->single();
            if ($datarow['Task7'] == null) {
                $this->db->query("UPDATE PerawatanSQL.DBO.BPJS_T_SEP SET Task7=:task4time
                                WHERE NO_REGISTRASI=:kodebookingx");
                $this->db->bind('kodebookingx', $kodebookingx);
                $this->db->bind('task4time', $dateNows);
                $this->db->execute();
                $callback = array(
                    'status' => 'success',
                );
                return $callback;
            }
            /// CEK DUULU DATANYA SUUDAH SAMPE 6 BELOM
            // $this->db->query("SELECT KODE_TRANSAKSI from PerawatanSQL.dbo.BPJS_TASKID_LOG 
            // 		where KODE_TRANSAKSI =:kodebookingx and TASK_ID >= '6' ");
            // $this->db->bind('kodebookingx', $kodebookingx);
            // $this->db->execute();
            // $dtrowCount6 =  $this->db->rowCount();
            // if ($dtrowCount6 < 1) {
            //     curl_setopt_array($curl, array(
            //         CURLOPT_URL =>  URL_BPJS_ANTRIAN . 'antrean/updatewaktu',
            //         CURLOPT_RETURNTRANSFER => true,
            //         CURLOPT_ENCODING => '',
            //         CURLOPT_MAXREDIRS => 10,
            //         CURLOPT_TIMEOUT => 0,
            //         CURLOPT_FOLLOWLOCATION => false,
            //         CURLOPT_SSL_VERIFYPEER => false,
            //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //         CURLOPT_CUSTOMREQUEST => 'POST',
            //         CURLOPT_POSTFIELDS => '{
            //             "kodebooking": "' . $kodebookingx . '",
            //             "taskid": "' . $taskid . '",
            //             "waktu": "' . $converttime . '"
            //         }',

            //         CURLOPT_HTTPHEADER => $headerbpjs,
            //     ));
            //     $output = curl_exec($curl);
            //     // tutup curl 
            //     curl_close($curl);
            //     // ubah string JSON menjadi array
            //     $JsonData = json_decode($output, TRUE);
            //     //var_dump($JsonData,'sssss');exit;
            //     if ($JsonData['metadata']['code'] == "200") {
            //         $EncodeData = json_encode($JsonData);
            //         $this->db->query("INSERT INTO perawatanSQL.dbo.BPJS_TASKID_LOG 
            //                             (KODE_TRANSAKSI,WAKTU,TASK_ID,DATE_CREATE) 
            //                             VALUES 
            //                             (:kodebooking,:waktu,:taskid,:DATE_CREATE)");
            //         $this->db->bind('kodebooking', $kodebookingx);
            //         $this->db->bind('waktu', $converttime);
            //         $this->db->bind('taskid', $taskid);
            //         $this->db->bind('DATE_CREATE', $dateNows);
            //         $this->db->execute();

            //         $callback = array(
            //             'status' => 'success',
            //         );
            //         return $callback;
            //     } else {
            //         $callback = array(
            //             'status' => 'warning',
            //             'errorname' => $JsonData['metadata']['message'],
            //         );
            //         return $callback;
            //     }
            //     } else {
            //     $callback = array(
            //         'status' => 'warning',
            //         'errorname' => "Task Terakhir Bukan 6, Simpan Gagal !!!!",
            //     );
            //     return $callback;
            // }
        }

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL =>  URL_BPJS_ANTRIAN . 'antrean/updatewaktu',
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => '',
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => false,
        //     CURLOPT_SSL_VERIFYPEER => false,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => 'POST',
        //     CURLOPT_POSTFIELDS => '{
        //                 "kodebooking": "' . $kodebookingx . '",
        //                 "taskid": "' . $taskid . '",
        //                 "waktu": "' . $converttime . '"
        //             }',

        //     CURLOPT_HTTPHEADER => $headerbpjs,
        // ));
        // $output = curl_exec($curl);
        // // tutup curl 
        // curl_close($curl);
        // // ubah string JSON menjadi array
        // $JsonData = json_decode($output, TRUE);
        // //var_dump($JsonData,'sssss');exit;
        // if ($JsonData['metadata']['code'] == "200") {
        //     $EncodeData = json_encode($JsonData);
        //     $this->db->query("INSERT INTO perawatanSQL.dbo.BPJS_TASKID_LOG 
        //                                 (KODE_TRANSAKSI,WAKTU,TASK_ID,DATE_CREATE) 
        //                                 VALUES 
        //                                 (:kodebooking,:waktu,:taskid,:DATE_CREATE)");
        //     $this->db->bind('kodebooking', $kodebookingx);
        //     $this->db->bind('waktu', $converttime);
        //     $this->db->bind('taskid', $taskid);
        //     $this->db->bind('DATE_CREATE', $dateNows);
        //     $this->db->execute();

        //     $callback = array(
        //         'status' => 'success',
        //     );
        //     return $callback;
        // } else {
        //     $callback = array(
        //         'status' => 'warning',
        //         'errorname' => $JsonData['metadata']['message'],
        //     );
        //     return $callback;
        // }
    }
    public function PrintRujukan($data)
    {
        try {
            $datenow = Utils::seCurrentDateTime();
            // $kodetrs= "0114R0671121K000025";
            // $this->db->query("UPDATE PerawatanSQL.DBO.BPJS_T_SPRI  SET 
            // CETAKAN_KE=CETAKAN_KE+1,TGL_LAST_CETAK=:datenow
            // WHERE NO_SPRI=:NoSep");
            // $this->db->bind('NoSep', $kodetrs);
            // $this->db->bind('datenow', $datenow);
            // $this->db->execute(); 
            $this->db->query("SELECT idRujukan,noSep, nomorkartu,nama,tgllahir,namadiagnosa,tglRujukan,
                            tglRencanaKunjungan,tglBerlakuKunjungan,
                            AsalRujukan,kdtujuanRujukan,tujuanrujukan,jenisfaskes,namapolitujuan,tipeRujukan,kelamin
                            ,created_at,CETAKAN_KE,TGL_FIRST_CETAK,USER_FIRST_CETAK,TGL_LAST_CETAK,USER_LAST_CETAK
                            ,dpjp
                            FROM PerawatanSQL.DBO.BPJS_T_Rujukan
                            where idRujukan=:NO_RUJUKAN");
            $this->db->bind('NO_RUJUKAN', $data['kodetrs']);
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success',
                'idRujukan' => $data['idRujukan'],
                'noSep' => $data['noSep'],
                'nomorkartu' => $data['nomorkartu'],
                'nama' => $data['nama'],
                'tgllahir' => $data['tgllahir'],
                'namadiagnosa' => $data['namadiagnosa'],
                'tglRujukan' => $data['tglRujukan'],
                'tglRencanaKunjungan' => $data['tglRencanaKunjungan'],
                'tglBerlakuKunjungan' => $data['tglBerlakuKunjungan'],
                'AsalRujukan' => $data['AsalRujukan'],
                'kdtujuanRujukan' => $data['kdtujuanRujukan'],
                'tujuanrujukan' => $data['tujuanrujukan'],
                'jenisfaskes' => $data['jenisfaskes'],
                'namapolitujuan' => $data['namapolitujuan'],
                'tipeRujukan' => $data['tipeRujukan'],
                'kelamin' => $data['kelamin'],
                'created_at' => $data['created_at'],
                'CETAKAN_KE' => $data['CETAKAN_KE'],
                'USER_FIRST_CETAK' => $data['USER_FIRST_CETAK'],
                'TGL_LAST_CETAK' => $data['TGL_LAST_CETAK'],
                'TGL_FIRST_CETAK' => $data['TGL_FIRST_CETAK'],
                'USER_LAST_CETAK' => $data['USER_LAST_CETAK'],
                'dpjp' => $data['dpjp'],
            );
            return $callback;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
    function xGoBPJSCekJumlahSEPRujukan($data)
    {
        $jenisPencarian = $data['jenisPencarian'];
        $kodePeserta = $data['kodePeserta'];
        $JenisRujukanFaskesBPJSx = $data['JenisRujukanFaskesBPJSx'];
        $dateNow = Utils::datenowcreateNotFull();
        if ($jenisPencarian == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Masukan Jenis Pencarian !',
            );
            echo json_encode($callback);
            exit;
        }

        if ($kodePeserta == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Masukan Kode Peserta/No. Rujukan !',
            );
            echo json_encode($callback);
            exit;
        }

        $urlApi = "Rujukan/JumlahSEP/$JenisRujukanFaskesBPJSx/$kodePeserta";
        // persiapkan curl
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS . $urlApi);
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
        // set time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            // $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));

            //echo json_encode($output);
            $callback = array(
                'status' => 'success',
                'hasil' => $ResultEncriptLzString,
            );
            return $callback;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']

            );
            return $callback;
        }
    }
    function GoBPJSCekJadwalDokter($data)
    {
        $kodepoli = $data['kodepoli'];
        $tanggal = $data['tanggal'];
        $dateNow = Utils::datenowcreateNotFull();
        // if ($kodepoli == "") {
        //     $callback = array(
        //         'status' => 'warning',
        //         'errorname' => 'Silahkan Masukan Kode Poli !',
        //     );
        //     echo json_encode($callback);
        //     exit;
        // }



        $urlApi = "jadwaldokter/kodepoli/$kodepoli/tanggal/$tanggal";

        // persiapkan curl
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS_Antrian($tStamp);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS_ANTRIAN . $urlApi);
        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerbpjs);
        // set time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // data yang dikirim
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);

        if ($JsonData['metadata']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            // $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2_Antrian($EncodeData, GenerateBpjs::keyString(Utils::setConsid_Antrian(), Utils::setSeckey_Antrian(), $tStamp));

            //echo json_encode($output);
            $callback = array(
                'status' => 'success',
                'hasil' => $ResultEncriptLzString,
            );
            return $callback;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metadata']['message']

            );
            return $callback;
        }
    }
}
