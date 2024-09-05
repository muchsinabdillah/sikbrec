<?php
class LPK_Model
{
    use BPJS;
    private $contenttype = "application/json; charset=utf-8";

    public function Reverence()
    {
        $method = "GET";
        $servicename = "/referensi/kelasrawat";
        $servicenameruangrawat = "/referensi/ruangrawat";
        $servicespesialistik = "/referensi/spesialistik";
        $servicarakeluar = "/referensi/carakeluar";
        $servipascapulang = "/referensi/pascapulang";
        $kelasrawat = $this->LPKReverense($method, $servicename, $this->contenttype);
        $ruangrawat = $this->LPKReverense($method, $servicenameruangrawat, $this->contenttype);
        $spesialistik = $this->LPKReverense($method, $servicespesialistik, $this->contenttype);
        $carakeluar = $this->LPKReverense($method, $servicarakeluar, $this->contenttype);
        $pascapulang = $this->LPKReverense($method, $servipascapulang, $this->contenttype);
        return array(
            'kelasrawat' => $kelasrawat,
            'ruangrawat' => $ruangrawat,
            'spesialistik' => $spesialistik,
            'carakeluar' => $carakeluar,
            'pascapulang' => $pascapulang,
        );
    }
    public function reverenceDokter($data)
    {

        $method = "GET";
        $contenttype = "application/json; charset=utf-8";
        $servicedokter = "/referensi/dokter/" . $data;
        $dokter = $this->LPKReverense($method, $servicedokter, $this->contenttype);
    }

    public function insert($data)
    {

        $method = "POST";
        $service = "/LPK/insert";
        $contenttype = "Application/x-www-form-urlencoded";
        $datalpk = [
            "request" => [
                "t_lpk" => [
                    "noSep" => "0301R0011017V000015",
                    "tglMasuk" => $data['tglmasuk'],
                    "tglKeluar" => $data['tglkeluar'],
                    "jaminan" => "1",
                    "poli" => [
                        "poli" => "INT"
                    ],
                    "perawatan" => [
                        "ruangRawat" => "1",
                        "kelasRawat" => "1",
                        "spesialistik" => "1",
                        "caraKeluar" => "1",
                        "kondisiPulang" => "1"
                    ],
                    "diagnosa" => [
                        [
                            "kode" => "N88.0",
                            "level" => "1"
                        ],
                        [
                            "kode" => "A00.1",
                            "level" => "2"
                        ]
                    ],
                    "procedure" => [
                        [
                            "kode" => "00.82"
                        ],
                        [
                            "kode" => "00.83"
                        ]
                    ],
                    "rencanaTL" => [
                        "tindakLanjut" => $data['rencanatl'],
                        "dirujukKe" => [
                            "kodePPK" => $data['dirujukke']
                        ],
                        "kontrolKembali" => [
                            "tglKontrol" => "2017-11-10",
                            "poli" => ""
                        ]
                    ],
                    "DPJP" => $data['cariDokterBPJS'],
                    "user" => $data['userlogin']
                ]
            ]
        ];
        $date = $this->LPKReverense($method, $service, $contenttype, json_encode($datalpk));


        return $date;
    }
    public function GetDataProcedure($param)
    {
        $servicedataprocedure = "/referensi/procedure/" . $param['nama'];
        $procedure = $this->LPKReverense("GET", $servicedataprocedure, $this->contenttype);
        return $procedure;
    }

    public function GetDataDiagnosa($param)
    {
        // var_dump($param);
        $servicedatadiagnosa = "/referensi/diagnosa/" . $param['searchTerm'];
        $diagnosa = $this->LPKReverense("GET", $servicedatadiagnosa, $this->contenttype);
        return $diagnosa;
    }
    public function GetDataLembarPengajuanClaim($data)
    {
        $serviceDataPengajuanClaim = "LPK/TglMasuk/" . $data['tglmasuk'] . "/JnsPelayanan/" . $data['jnspelayanan'];
        $datalembarpengajuanclaim = $this->LPKReverense("GET", $serviceDataPengajuanClaim, $this->contenttype);
        return $datalembarpengajuanclaim['status'];
    }

    public function GetDataDokter($param)
    {
        $servicedatadiagnosa = "/referensi/dokter/" . $param['nama'];
        $diagnosa = $this->LPKReverense("GET", $servicedatadiagnosa, $this->contenttype);
        return $diagnosa;
    }

    public function input($data)
    {

        $dataprosedur = $this->conversiarray($data['prosedur'], "kode");
        // $datadiagnosadanlevel = $this->conversiarray($datalevel, "level");
        // $datadiagnosalevelgabung = array();
        // array_push()
        // var_dump($datadiagnosa);
        $datainput = [
            "request" => [
                "t_lpk" => [
                    "noSep" => $data["noSep"],
                    "tglMasuk" => $data["tglMasuk"],
                    "tglKeluar" => $data["tglKeluar"],
                    "jaminan" => "1",
                    "poli" => [
                        "poli" => $data["poli"]
                    ],
                    "perawatan" => [
                        "ruangRawat" => $data["ruangRawat"],
                        "kelasRawat" => $data["kelasRawat"],
                        "spesialistik" => $data["spesialistik"],
                        "caraKeluar" => $data["caraKeluar"],
                        "kondisiPulang" => $data["kondisiPulang"]
                    ],
                    "diagnosa" => $data['diagnosa_level'],
                    "procedure" => $dataprosedur,
                    "rencanaTL" => [
                        "tindakLanjut" => "1",
                        "dirujukKe" => [
                            "kodePPK" => ""
                        ],
                        "kontrolKembali" => [
                            "tglKontrol" => "2017-11-10",
                            "poli" => ""
                        ]
                    ],
                    "DPJP" => "3",
                    "user" => "Coba Ws"
                ]
            ]
        ];
        $service = "/LPK/insert";
        $contenttype = "Application/x-www-form-urlencoded";
        $jsonkirim = json_encode($datainput);
        // var_dump($jsonkirim);
        $insertlpk = $this->LPKReverense('POST', $service, $contenttype, json_encode($datainput));
        return $insertlpk;
    }

    public function mockDataPeserta()
    {
        $data = [
            "metaData" => [
                "code" => "200",
                "message" => "Sukses"
            ],
            "response" => [
                "noSep" => "0301R0110121V003867",
                "tglSep" => "2021-01-14",
                "jnsPelayanan" => "Rawat Inap",
                "kelasRawat" => "2",
                "diagnosa" => "Superficial injury of scalp",
                "noRujukan" => "0301r01114012021",
                "poli" => "",
                "poliEksekutif" => "0",
                "catatan" => "",
                "penjamin" => "Jasa Raharja PT, BPJS Ketenagakerjaan",
                "kdStatusKecelakaan" => "2",
                "nmstatusKecelakaan" => "Kecelakaan LaluLintas dan Kecelakaan Kerja",
                "lokasiKejadian" => [
                    "kdKab" => "0050",
                    "kdKec" => "0578",
                    "kdProp" => "0050",
                    "ketKejadian" => "os post kecelakaan motor vs motor saat hendak berangkat kerja tgl 12-01-2021 jm 15.00 di jalan sudirman depan kantor Bank Indonesia.",
                    "lokasi" => "KOTO TANGAH|KOTA PADANG|SUMATERA BARAT",
                    "tglKejadian" => "2021-01-14"
                ],
                "dpjp" => [
                    "kdDPJP" => "31792",
                    "nmDPJP" => "dr.Alexander Cahyadi,SpBS"
                ],
                "peserta" => [
                    "asuransi" => null,
                    "hakKelas" => "Kelas 2",
                    "jnsPeserta" => "PEGAWAI SWASTA",
                    "kelamin" => "P",
                    "nama" => "VILMAISARAH",
                    "noKartu" => "0000283650658",
                    "noMr" => "705154",
                    "tglLahir" => "1998-07-23"
                ],
                "kontrol" => [
                    "kdDokter" => "31792",
                    "nmDokter" => "dr.Alexander Cahyadi,SpBS",
                    "noSurat" => "000208"
                ]
            ]
        ];
    }

    public function mockDataLembarPengajuanClaim()
    {
        $data =  [
            "metaData" => [
                "code" => "200",
                "message" => "OK"
            ],
            "response" => [
                "lpk" => [
                    "list" => [
                        [
                            "DPJP" => [
                                "dokter" => [
                                    "kode" => "3",
                                    "nama" => "Satro Jadhit, dr"
                                ]
                            ],
                            "diagnosa" => [
                                "list" => [
                                    [
                                        "level" => "1",
                                        "list" => [
                                            "kode" => "N88.1",
                                            "nama" => "Old laceration of cervix uteri"
                                        ]
                                    ],
                                    [
                                        "level" => "2",
                                        "list" => [
                                            "kode" => "A00.1",
                                            "nama" => "Cholera due to Vibrio cholerae 01, biovar eltor"
                                        ]
                                    ]
                                ]
                            ],
                            "jnsPelayanan" => "1",
                            "noSep" => "0301R0011017V000014",
                            "perawatan" => [
                                "caraKeluar" => [
                                    "kode" => "1",
                                    "nama" => "Atas Persetujuan Dokter"
                                ],
                                "kelasRawat" => [
                                    "kode" => "1",
                                    "nama" => "VVIP"
                                ],
                                "kondisiPulang" => [
                                    "kode" => "1",
                                    "nama" => "Sembuh"
                                ],
                                "ruangRawat" => [
                                    "kode" => "3",
                                    "nama" => "Ruang Melati I"
                                ],
                                "spesialistik" => [
                                    "kode" => "1",
                                    "nama" => "Spesialis Penyakit dalam"
                                ]
                            ],
                            "peserta" => [
                                "kelamin" => "L",
                                "nama" => "123456",
                                "noKartu" => "0000000001231",
                                "noMR" => "123456",
                                "tglLahir" => "2008-02-05"
                            ],
                            "poli" => [
                                "eksekutif" => "0",
                                "poli" => [
                                    "kode" => "INT"
                                ]
                            ],
                            "procedure" => [
                                "list" => [
                                    [
                                        "list" => [
                                            "kode" => "00.82",
                                            "nama" => "Revision of knee replacement, femoral component"
                                        ]
                                    ],
                                    [
                                        "list" => [
                                            "kode" => "00.83",
                                            "nama" => "Revision of knee replacement,patellar component"
                                        ]
                                    ]
                                ]
                            ],
                            "rencanaTL" => null,
                            "tglKeluar" => "2017-10-30",
                            "tglMasuk" => "2017-10-30"
                        ],


                    ], [
                        [
                            "DPJP" => [
                                "dokter" => [
                                    "kode" => "3",
                                    "nama" => "Satro Jadhit, dr"
                                ]
                            ],
                            "diagnosa" => [
                                "list" => [
                                    [
                                        "level" => "1",
                                        "list" => [
                                            "kode" => "N88.1",
                                            "nama" => "Old laceration of cervix uteri"
                                        ]
                                    ],
                                    [
                                        "level" => "2",
                                        "list" => [
                                            "kode" => "A00.1",
                                            "nama" => "Cholera due to Vibrio cholerae 01, biovar eltor"
                                        ]
                                    ]
                                ]
                            ],
                            "jnsPelayanan" => "1",
                            "noSep" => "0301R0011017V000014",
                            "perawatan" => [
                                "caraKeluar" => [
                                    "kode" => "1",
                                    "nama" => "Atas Persetujuan Dokter"
                                ],
                                "kelasRawat" => [
                                    "kode" => "1",
                                    "nama" => "VVIP"
                                ],
                                "kondisiPulang" => [
                                    "kode" => "1",
                                    "nama" => "Sembuh"
                                ],
                                "ruangRawat" => [
                                    "kode" => "3",
                                    "nama" => "Ruang Melati I"
                                ],
                                "spesialistik" => [
                                    "kode" => "1",
                                    "nama" => "Spesialis Penyakit dalam"
                                ]
                            ],
                            "peserta" => [
                                "kelamin" => "L",
                                "nama" => "123456",
                                "noKartu" => "0000000001231",
                                "noMR" => "123456",
                                "tglLahir" => "2008-02-05"
                            ],
                            "poli" => [
                                "eksekutif" => "0",
                                "poli" => [
                                    "kode" => "INT"
                                ]
                            ],
                            "procedure" => [
                                "list" => [
                                    [
                                        "list" => [
                                            "kode" => "00.82",
                                            "nama" => "Revision of knee replacement, femoral component"
                                        ]
                                    ],
                                    [
                                        "list" => [
                                            "kode" => "00.83",
                                            "nama" => "Revision of knee replacement,patellar component"
                                        ]
                                    ]
                                ]
                            ],
                            "rencanaTL" => null,
                            "tglKeluar" => "2017-10-30",
                            "tglMasuk" => "2017-10-30"
                        ],


                    ]

                ]
            ]
        ];
    }
}
