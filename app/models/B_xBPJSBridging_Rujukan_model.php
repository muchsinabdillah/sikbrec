<?php
class B_xBPJSBridging_Rujukan_model
{
    use BPJS;
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }
    // insert rujukan
    public function insert($data)
    {   
        $datenownotfull = Utils::datenowcreateNotFull();
        if ($data['noSep'] == "") {
            $callback = array(
                'status' => 'blank',
                'message' => 'Silahkan Masukan No. SEP !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($data['tglRujukan'] == "") {
            $callback = array(
                'status' => 'blank',
                'message' => 'Silahkan Masukan Tgl Rujukan !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($data['tglRujukan'] < $datenownotfull) {
            $callback = array(
                'status' => 'blank',
                'message' => 'Tgl Rujukan lebih kecil dari Tgl SEP !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($data['tglRujukan'] > $datenownotfull) {
            $callback = array(
                'status' => 'blank',
                'message' => 'Tgl Rujukan lebih besar dari Tgl SEP !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($data['tglRencanaKunjungan'] == "") {
            $callback = array(
                'status' => 'blank',
                'message' => 'Silahkan Masukan Tgl Rencana Kunjungan !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($data['jenisfakes'] == "") {
            $callback = array(
                'status' => 'blank',
                'message' => 'Silahkan Masukan Jenis Faskes !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($data['ppkDirujuk'] == "") {
            $callback = array(
                'status' => 'blank',
                'message' => 'Silahkan Masukan Nama Faskes !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($data['ppkDirujuk'] == "") {
            $callback = array(
                'status' => 'blank',
                'message' => 'Silahkan Masukan Nama Faskes !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($data['kdjenispelayanan'] == "") {
            $callback = array(
                'status' => 'blank',
                'message' => 'Silahkan Masukan Jenis Pelayanan !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($data['diagRujukan'] == "") {
            $callback = array(
                'status' => 'blank',
                'message' => 'Silahkan Masukan Nama Diagnosa Rujukan !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($data['kdtipeRujukan'] == "") {
            $callback = array(
                'status' => 'blank',
                'message' => 'Silahkan Masukan Tipe Rujukan !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($data['kdtipeRujukan'] == "0" || $data['kdtipeRujukan'] == "1") {
            if ($data['poliRujukan'] == "") {
                $callback = array(
                    'status' => 'blank',
                    'message' => 'Silahkan Masukan Poli Rujukan !',
                );
                echo json_encode($callback);
                exit;
            }
        }
            
        $request = [
            "request" => [
                "t_rujukan" => [
                    "noSep" => $data['noSep'],
                    "tglRujukan" => $data['tglRujukan'],
                    "tglRencanaKunjungan" => $data['tglRencanaKunjungan'],
                    "ppkDirujuk" => $data["ppkDirujuk"],
                    "jnsPelayanan" => $data['kdjenispelayanan'],
                    "catatan" => $data['catatan'],
                    "diagRujukan" => $data['diagRujukan'],
                    "tipeRujukan" => $data['kdtipeRujukan'],
                    "poliRujukan" => $data['poliRujukan'],
                    "user" => $data['user']
                ]
            ]
        ];


        // $request =  [
        //     "request" => [
        //         "t_rujukan" => [
        //             "noSep" => $data['noSep'],
        //             "tglRujukan" => $data['tglRujukan'],
        //             "tglRencanaKunjungan" => $data['tglRencanaKunjungan'],
        //             "ppkDirujuk" => $data["ppkDirujuk"],
        //             "jnsPelayanan" =>  $data['kdjenispelayanan'],
        //             "catatan" => $data['catatan'],
        //             "diagRujukan" => $data['diagRujukan'],
        //             "tipeRujukan" => $data['kdtipeRujukan'],
        //             "poliRujukan" => $data['poliRujukan'],
        //             "user" => $data['user']
        //         ]
        //     ]
        // ];

        $responserujukan =  $this->bpjsAPI("POST", "Rujukan/2.0/insert", "Application/x-www-form-urlencoded", json_encode($request));
        $encode = json_decode(json_encode($responserujukan), true);
        // var_dump(json_encode($request));
        // $encode = [
        //     'rujukan' =>
        //     [
        //         'noRujukan' => '0114R0671121g000020',
        //         'tglRujukan' => '2021-11-03',
        //         'tglRencanaKunjungan' => NULL,
        //         'tglBerlakuKunjungan' => '2022-02-01',
        //         'diagnosa' =>
        //         [
        //             'kode' => 'A15.4',
        //             'nama' => 'A15.4 - Tuberculosis of intrathoracic lymph nodes, confirmed bacteriologically and histologically',
        //         ],
        //         'poliTujuan' =>
        //         [
        //             'kode' => 'IGD',
        //             'nama' => 'INSTALASI GAWAT DARURAT',
        //         ],
        //         'AsalRujukan' =>
        //         [
        //             'kode' => '0114R067',
        //             'nama' => 'RSU Yarsi',
        //         ],
        //         'tujuanRujukan' =>
        //         [
        //             'kode' => '1501R004',
        //             'nama' => 'RS. YARSI',
        //         ],
        //         'peserta' =>
        //         [
        //             'noKartu' => '0002022951609',
        //             'nama' => 'FAHRUL FIRMANSYAH',
        //             'tglLahir' => '2007-08-30',
        //             'noMr' => '00-16-68',
        //             'kelamin' => 'Laki-Laki',
        //             'jnsPeserta' => 'PBI (APBN)',
        //             'hakKelas' => NULL,
        //             'asuransi' => '-',
        //         ],
        //     ],
        // ];
        if (isset($encode['rujukan'])) {
            // $this->save($responserujukan);
            $insertrujukan = $this->save($encode, $data);
            if ($insertrujukan == "Success") {
                return $responserujukan;
            } else {
                return $callback = [
                    'status' => 'warning',
                    'errorname' => "input ke api berhasil tapi ke database gagal",
                    'dbEroor' => $insertrujukan
                ];
            }
        } else {
            return $encode;
        }
    }
    // update data rujukan
    public function update($data)
    {
        // var_dump($data);
        if ($data['noSep'] == "") {
            $callback = array(
                'status' => 'blank',
                'message' => 'Silahkan Masukan No. SEP !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($data['tglRujukan'] == "") {
            $callback = array(
                'status' => 'blank',
                'message' => 'Silahkan Masukan Tgl Rujukan !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($data['tglRencanaKunjungan'] == "") {
            $callback = array(
                'status' => 'blank',
                'message' => 'Silahkan Masukan Tgl Rencana Kunjungan !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($data['jenisfakes'] == "") {
            $callback = array(
                'status' => 'blank',
                'message' => 'Silahkan Masukan Jenis Faskes !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($data['ppkDirujuk'] == "") {
            $callback = array(
                'status' => 'blank',
                'message' => 'Silahkan Masukan Nama Faskes !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($data['ppkDirujuk'] == "") {
            $callback = array(
                'status' => 'blank',
                'message' => 'Silahkan Masukan Nama Faskes !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($data['kdjenispelayanan'] == ""
        ) {
            $callback = array(
                'status' => 'blank',
                'message' => 'Silahkan Masukan Jenis Pelayanan !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($data['diagRujukan'] == "") {
            $callback = array(
                'status' => 'blank',
                'message' => 'Silahkan Masukan Nama Diagnosa Rujukan !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($data['kdtipeRujukan'] == ""
        ) {
            $callback = array(
                'status' => 'blank',
                'message' => 'Silahkan Masukan Tipe Rujukan !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($data['poliRujukan'] == "") {
            $callback = array(
                'status' => 'blank',
                'message' => 'Silahkan Masukan Poli Rujukan !',
            );
            echo json_encode($callback);
            exit;
        }
        $request = [
            "request" => [
                "t_rujukan" => [
                    "noRujukan" => $data['norujukan'],
                    "tglRujukan" => $data['tglRujukan'],
                    "tglRencanaKunjungan" => $data['tglRencanaKunjungan'],
                    "ppkDirujuk" => $data['ppkDirujuk'],
                    "jnsPelayanan" => $data['kdjenispelayanan'],
                    "catatan" => $data['catatan'],
                    "diagRujukan" => $data['diagRujukan'],
                    "tipeRujukan" => $data['kdtipeRujukan'],
                    "poliRujukan" => $data['poliRujukan'],
                    "user" => $data['user']
                ],
            ]
        ];
        // return json_encode($request);
        $responserujukan =  $this->bpjsAPI("PUT", "/Rujukan/2.0/Update", "Application/x-www-form-urlencoded", json_encode($request));
        // var_dump($responserujukan);
        $encode = json_decode(json_encode($responserujukan), true);
        // echo $encode;
        // var_dump($encode->rujukan->noRujukan);
        // versi development
        if (isset($encode)) {
            // $this->save($responserujukan);
            if ($this->edit($encode, $data) == "Success") {
                return $responserujukan;
            } else {
                return $callback = [
                    'errorname' => "input ke api berhasil tapi ke database gagal",
                ];
            }
        } else {
            return $encode;
        }
        // veri production
        // if (isset($encode['rujukan'])) {
        //     // $this->save($responserujukan);
        //     if ($this->edit($encode, $data) == "Success") {
        //         return $responserujukan;
        //     } else {
        //         return $callback = [
        //             'errorname' => "input ke api berhasil tapi ke database gagal",
        //         ];
        //     }
        // } else {
        //     return $encode;
        // }
    }
    // delete data rujukan api bpjs
    public function DeleteRujukanBPJS($data)
    {
        if ($data['noRujukan'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Masukan No. Rujukan !',
            );
            echo json_encode($callback);
            exit;
        }
        if ($data['alasanbatal'] == "") {
            $callback = array(
                'status' => 'warning',
                'errorname' => 'Silahkan Masukan Alasan Batal !',
            );
            echo json_encode($callback);
            exit;
        }
        $request = [
            "request" => [
                "t_rujukan" => [
                    "noRujukan" => $data['noRujukan'],
                    "user" => $data['user']
                ]
            ]
        ];
        $deletedatarujukanbpjs = $this->bpjsAPI("DELETE", "/Rujukan/delete", " Application/x-www-form-urlencoded", json_encode($request));
        $encode = json_decode(json_encode($deletedatarujukanbpjs), true);
        // echo $deletedatarujukanbpjs;
        // var_dump($encode->rujukan->noRujukan);

        if ($encode == $data['noRujukan']) {
            // $this->save($responserujukan);
            if ($this->Delete($data) == "Success") {
                return $deletedatarujukanbpjs;
            } else {
                return $callback = [
                    'errorname' => "input ke api berhasil tapi ke database gagal",
                ];
            }
        } else {
            return $encode;
        }
    }
    // delete data rujukan
    public function Delete($data)
    {
        $query = "UPDATE [PerawatanSQL].[dbo].[BPJS_T_Rujukan]
        set
            batal=:delete
            ,deleted_at=:deleted_at,
            alasan_delete=:alasan_delete,
            user_delete=:user_delete
            WHERE idRujukan=:idRujukan";
        try {
            $this->db->transaksi();
            $this->db->query($query);
            $this->db->bind('idRujukan', $data['noRujukan']);
            $this->db->bind('alasan_delete', $data['alasanbatal']);
            $this->db->bind('user_delete', $data['user']);
            $this->db->bind('delete', 1);
            $this->db->bind('deleted_at', Utils::seCurrentDateTime());
            $this->db->execute();
            $this->db->Commit();
            return "Success";
        } catch (PDOException $e) {
            $this->db->rollback();
            return $e;
        }
    }
    public function edit($data, $request)
    {
        // var_dump($request);
        $query = "UPDATE [PerawatanSQL].[dbo].[BPJS_T_Rujukan]
        set
            tglRujukan=:tglRujukan
            ,tglRencanaKunjungan=:tglRencanaKunjungan
            -- ,tglBerlakuKunjungan=:tglBerlakuKunjungan
            ,kodediagnosa=:kodediagnosa
            ,namadiagnosa=:namadiagnosa
            ,kdpolitujuan=:kdpolitujuan
            ,namapolitujuan=:namapolitujuan
            -- ,kdAsalRujukan=:kdAsalRujukan
            -- ,AsalRujukan=:AsalRujukan
            ,kdtujuanRujukan=:kdtujuanRujukan
            ,kdPelayanan=:kdPelayanan
            ,tujuanrujukan=:tujuanrujukan
            -- ,nomorkartu=:nomorkartu
            -- ,nama=:nama
            -- ,tgllahir=:tgllahir
            -- ,noMr=:noMr
            -- ,kelamin=:kelamin
            -- ,jnsPeserta=:jnsPeserta
            -- ,hakkelas=:hakkelas
            ,jenisfaskes=:jenisfaskes
            ,catatan=:catatan
            ,user_update=:user_update
            ,updated_at=:created_at
            ,kdtipeRujukan=:kdtipeRujukan
            ,tipeRujukan=:tiperujukan
            WHERE idRujukan=:idRujukan";
        try {
            $this->db->transaksi();
            $this->db->query($query);
            // $this->db->bind('idRujukan', $data['rujukan']['noRujukan']);
            // $this->db->bind('tglRujukan', $data['rujukan']['tglRujukan']);
            // $this->db->bind('tglRencanaKunjungan', $data['rujukan']['tglRencanaKunjungan']);
            // $this->db->bind('tglBerlakuKunjungan', $data['rujukan']['tglBerlakuKunjungan']);
            // $this->db->bind('kodediagnosa', $data['rujukan']['diagnosa']['kode']);
            // $this->db->bind('namadiagnosa', $data['rujukan']['diagnosa']['nama']);
            // $this->db->bind('kdpolitujuan', $data['rujukan']['poliTujuan']['kode']);
            // $this->db->bind('namapolitujuan', $data['rujukan']['poliTujuan']['nama']);
            // $this->db->bind('kdAsalRujukan', $data['rujukan']['AsalRujukan']['kode']);
            // $this->db->bind('AsalRujukan', $data['rujukan']['AsalRujukan']['nama']);
            // $this->db->bind('kdtujuanRujukan', $data['rujukan']['tujuanRujukan']['kode']);
            // $this->db->bind('tujuanrujukan', $data['rujukan']['tujuanRujukan']['nama']);
            // $this->db->bind('nomorkartu', $data['rujukan']['peserta']['noKartu']);
            // $this->db->bind('nama', $data['rujukan']['peserta']['nama']);
            // $this->db->bind('tgllahir', $data['rujukan']['peserta']['tglLahir']);
            // $this->db->bind('noMr', $data['rujukan']['peserta']['noMr']);
            // $this->db->bind('kelamin', $data['rujukan']['peserta']['kelamin']);
            // $this->db->bind('jnsPeserta', $data['rujukan']['peserta']['jnsPeserta']);
            // $this->db->bind('hakkelas', $data['rujukan']['peserta']['hakKelas']);
            // $this->db->bind('asuransi', $data['rujukan']['peserta']['asuransi']);
            // $this->db->bind('catatan', $request['catatan']);
            // $this->db->bind('user_input', $request['user']);
            // $this->db->bind('created_at', Utils::seCurrentDateTime());

            // dev bpjs
            $this->db->bind('idRujukan', $request['norujukan']);
            $this->db->bind('tglRujukan', $request['tglRujukan']);
            $this->db->bind('tglRencanaKunjungan', $request['tglRencanaKunjungan']);
            // $this->db->bind('tglBerlakuKunjungan', $data['rujukan']['tglBerlakuKunjungan']);
            $this->db->bind('kodediagnosa', $request['diagRujukan']);
            $this->db->bind('namadiagnosa', $request['namadiagRujukan']);
            $this->db->bind('kdpolitujuan', $request['poliRujukan']);
             $this->db->bind('namapolitujuan', $request['namapoliRujukan']);
            // $this->db->bind('kdAsalRujukan', $data['rujukan']['AsalRujukan']['kode']);
            // $this->db->bind('AsalRujukan', $data['rujukan']['AsalRujukan']['nama']);
            $this->db->bind('kdtujuanRujukan', $request['ppkDirujuk']);
            $this->db->bind('tujuanrujukan', $request['namafaskespilih']);
            // $this->db->bind('nomorkartu', $data['rujukan']['peserta']['noKartu']);
            // $this->db->bind('nama', $data['rujukan']['peserta']['nama']);
            // $this->db->bind('tgllahir', $data['rujukan']['peserta']['tglLahir']);
            // $this->db->bind('noMr', $data['rujukan']['peserta']['noMr']);
            // $this->db->bind('kelamin', $data['rujukan']['peserta']['kelamin']);
            // $this->db->bind('jnsPeserta', $data['rujukan']['peserta']['jnsPeserta']);
            // $this->db->bind('hakkelas', $data['rujukan']['peserta']['hakKelas']);
             $this->db->bind('jenisfaskes', $request['jenisfakes']);
            $this->db->bind('catatan', $request['catatan']);
            $this->db->bind('kdPelayanan', $request['kdjenispelayanan']);
            
            $this->db->bind('user_update', $request['user']);
            $this->db->bind('kdtipeRujukan', $request['kdtipeRujukan']);
            $this->db->bind('tiperujukan', $request['tiperujukan']);
            $this->db->bind('created_at', Utils::seCurrentDateTime());
            $this->db->execute();
            $this->db->Commit();
            return "Success";
        } catch (PDOException $e) {
            $this->db->rollback();
            return $e;
        }
    }
    public function save($data, $request)
    {
        $query = "INSERT INTO [PerawatanSQL].[dbo].[BPJS_T_Rujukan]
        (
        [idRujukan]
        ,[noSep]
        ,[tglRujukan]
        ,[tglRencanaKunjungan]
        ,[tglBerlakuKunjungan]
        ,[kodediagnosa]
        ,[namadiagnosa]
        ,[kdpolitujuan]
        ,[namapolitujuan]
        ,[kdAsalRujukan]
        ,[AsalRujukan]
        ,[kdtujuanRujukan]
        ,[tujuanrujukan]
        ,[kdPelayanan]
        ,[jnsPelayanan]
        ,[kdtipeRujukan]
        ,[tipeRujukan]
        ,[nomorkartu]
        ,[nama]
        ,[tgllahir]
        ,[noMr]
        ,[kelamin]
        ,[jnsPeserta]
        ,[hakkelas]
        ,[asuransi]
        ,[catatan]
        ,[user_input]
        ,[created_at]
        ,[jenisfaskes]
        ,[DPJP]
        )
  VALUES
        (
        :idRujukan
        ,:noSep
        ,:tglRujukan
        ,:tglRencanaKunjungan
        ,:tglBerlakuKunjungan
        ,:kodediagnosa
        ,:namadiagnosa
        ,:kdpolitujuan
        ,:namapolitujuan
        ,:kdAsalRujukan
        ,:AsalRujukan
        ,:kdtujuanRujukan
        ,:tujuanrujukan
        ,:kdPelayanan
        ,:jnsPelayanan
        ,:kdtipeRujukan
        ,:tipeRujukan
        ,:nomorkartu
        ,:nama
        ,:tgllahir
        ,:noMr
        ,:kelamin
        ,:jnsPeserta
        ,:hakkelas
        ,:asuransi
        ,:catatan
        ,:user_input
        ,:created_at
        ,:jenisfaskes
        ,:dpjp
        )";
        try {
            $this->db->transaksi();
            $this->db->query($query);
            $this->db->bind('idRujukan', $data['rujukan']['noRujukan']);
            $this->db->bind('noSep', $request['noSep']);
            $this->db->bind('tglRujukan', $data['rujukan']['tglRujukan']);
            $this->db->bind('tglRencanaKunjungan', $data['rujukan']['tglRencanaKunjungan']);
            $this->db->bind('tglBerlakuKunjungan', $data['rujukan']['tglBerlakuKunjungan']);
            $this->db->bind('kodediagnosa', $data['rujukan']['diagnosa']['kode']);
            $this->db->bind('namadiagnosa', $data['rujukan']['diagnosa']['nama']);
            $this->db->bind('kdpolitujuan', $data['rujukan']['poliTujuan']['kode']);
            $this->db->bind('namapolitujuan', $data['rujukan']['poliTujuan']['nama']);
            $this->db->bind('kdAsalRujukan', $data['rujukan']['AsalRujukan']['kode']);
            $this->db->bind('AsalRujukan', $data['rujukan']['AsalRujukan']['nama']);
            $this->db->bind('kdtujuanRujukan', $data['rujukan']['tujuanRujukan']['kode']);
            $this->db->bind('tujuanrujukan', $data['rujukan']['tujuanRujukan']['nama']);
            $this->db->bind('nomorkartu', $data['rujukan']['peserta']['noKartu']);
            $this->db->bind('nama', $data['rujukan']['peserta']['nama']);
            $this->db->bind('tgllahir', $data['rujukan']['peserta']['tglLahir']);
            $this->db->bind('noMr', $data['rujukan']['peserta']['noMr']);
            $this->db->bind('kelamin', $data['rujukan']['peserta']['kelamin']);
            $this->db->bind('jnsPeserta', $data['rujukan']['peserta']['jnsPeserta']);
            $this->db->bind('hakkelas', $data['rujukan']['peserta']['hakKelas']);
            $this->db->bind('asuransi', $data['rujukan']['peserta']['asuransi']);
            $this->db->bind('kdPelayanan', $request['kdjenispelayanan']);
            $this->db->bind('jnsPelayanan', $request['jnsPelayanan']);
            $this->db->bind('kdtipeRujukan', $request['kdtipeRujukan']);
            $this->db->bind('tipeRujukan', $request['tiperujukan']);
            $this->db->bind('catatan', $request['catatan']);
            $this->db->bind('user_input', $request['user']);
            $this->db->bind('jenisfaskes', $request['jenisfakes']);
            $this->db->bind('dpjp', $request['dpjp']);
            $this->db->bind('created_at', Utils::seCurrentDateTime());
            $this->db->execute();
            $this->db->Commit();
            return "Success";
        } catch (PDOException $e) {
            $this->db->rollback();
            return $e;
        }
    }

    public function Fakes($data)
    {
        $datafakes = $this->bpjsAPI("GET", "/referensi/faskes/" . $data['namafakes'] . "/" . $data['kodefakes'], "application/json; charset=utf-8");
        return $datafakes;
    }

    // mengambil data rujukan dari database by id
    public function getDatarujukanbyIDrujukan($data)
    {
        $query = "SELECT idRujukan,tglRujukan,tglRencanaKunjungan,kdtujuanRujukan,tujuanrujukan,kodediagnosa
        ,namadiagnosa,kdpolitujuan,namapolitujuan,kdPelayanan,jnsPelayanan,kdtipeRujukan,tipeRujukan,catatan,noSep,jenisfaskes,dpjp
        from PerawatanSQL.dbo.BPJS_T_Rujukan where idRujukan=:idRujukan";
        $this->db->query($query);
        $this->db->bind('idRujukan', $data['norujukan']);
        $this->db->execute();
        return $this->db->single();
    }
    public function showListRujukan($data)
    {
        try {
            $this->db->query("SELECT idRujukan, noSep,tglRujukan,tglRencanaKunjungan,
                            tglBerlakuKunjungan,namadiagnosa,
                            kdpolitujuan,namapolitujuan,kdtujuanRujukan,tujuanrujukan,jnsPelayanan,
                            tipeRujukan,nomorkartu,nama,tgllahir,
                            noMr,kelamin,jnsPeserta,catatan,user_input,created_at
                            FROM PerawatanSQL.dbo.BPJS_T_Rujukan
                            WHERE batal='0' and tglRujukan=:tglrujukan");
            $this->db->bind('tglrujukan', $data['MTglKunjunganBPJS']);
            $data =  $this->db->resultSet();
            $rows = array(); 
            $no = 0;
            foreach ($data as $key) {
                $no++;
                $poli = '';

                $poli = '<b>' . $key['jnsPelayanan'] . ' ' . $key['namapolitujuan'] . '</b>';
              
                $pasing['no'] = $no;
                $pasing['idRujukan'] = $key['idRujukan'];
                $pasing['noSep'] = $key['noSep'];
                $pasing['tglRujukan'] = date('d/m/Y', strtotime($key['tglRujukan']));
                $pasing['tglRencanaKunjungan'] = date('d/m/Y', strtotime($key['tglRencanaKunjungan']));
                $pasing['tglBerlakuKunjungan'] = date('d/m/Y', strtotime($key['tglBerlakuKunjungan']));
                $pasing['nomorkartu'] = $key['nomorkartu'];
                $pasing['noMr'] = $key['noMr'];
                $pasing['poli'] = $poli;
                $pasing['nama'] = $key['nama']; 
                $pasing['namadiagnosa'] = $key['namadiagnosa'];
                $pasing['catatan'] = $key['catatan'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            $callback = array(
                'status' => "error", // Set array nama  
                'message' => $e
            );
            return $callback;
        }
    }
}
