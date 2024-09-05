<?php
 
class B_xBPJSBridging_PRB_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    function GoGetProgramPRB($data)
    {
       // $searchTerm = $data['searchTerm'];
        // persiapkan curl
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
            $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS_REFF . "diagnosaprb");
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
                $pasing['id'] = str_replace(" ","",$jsons['kode']);;
                $pasing['text'] = $jsons['nama'];
                $datas[] = $pasing;
            }
           // return $datas;
           $callback = array(
            'message' => "success", // Set array nama 
            'data' => $datas
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

    function GoGetObatPRB($data)
    {
        $searchTerm = $data['searchTerm'];
        // persiapkan curl
        $ch = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
            $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        // set url 
        curl_setopt($ch, CURLOPT_URL, URL_BPJS_REFF . "obatprb/$searchTerm");
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
    public function GetregistrasiRajalbyId($data){
        try {
            $IdRegistrasi = $data['IdRegistrasi'];
            $tabel = "MasterDataSQL.dbo.Admision";
            if (isset($_POST['iswalkin'])){
                $iswalkin = $data['iswalkin'];
                if ($iswalkin == 'WALKIN'){
                    $tabel = "MasterDataSQL.dbo.Admision_walkin";
                }
            }

            $this->db->query("SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName ,a.LokasiPasien,a.CaraBayar,
                                          a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
                                          a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
                                          a.PatientType,a.Unit,a.Doctor_1,b.First_Name as namadokter,a.JamPraktek,a.Perusahaan as Perusahaanid,c.NamaPerusahaan as  Perusahaan,a.[Payment Type],
                                          a.Antrian,a.NoAntrianAll,e.[First Name] as namauser,
                                            replace(CONVERT(VARCHAR(11), d.Date_of_birth, 111), '/','-') as Date_of_birthx,
                                            d.Address,d.Gander,d.BirthPlace,d.Ocupation,
                                            case when d.Gander='L' then 'LAKI-LAKI' when d.Gander='P' then 'PEREMPUAN'  END AS NamaGander,
                                            d.ID_Card_number,a.idAdmin,a.idCaraMasuk,a.idCaraMasuk2,a.JenisDaftar,f.NoBooking,
                                            replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglkunjungan,CONVERT(VARCHAR(8),
                                            TglKunjungan,108) as jamkunjungan,bs.NO_SRB,d.[E-mail Address] as email,
                                            bs.ID as ID_HDR_BPJS,bs.KODE_POLI,bs.NAMA_POLI,bs.KODE_DOKTER,bs.NAMA_DOKTER,
                                            bs.KODE_PROGRAM_PRB,bs.NAMA_PROGRAM_PRB,bs.KETERANGAN,bs.SARAN
                                            ,b.ID_Dokter_BPJS,b.NAMA_Dokter_BPJS,g.CodeSubBPJS,g.NamaBPJS,h.KETERANGAN_PRB
                                          from PerawatanSQL.dbo.Visit a
                                          inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
                                          inner join MasterdataSQL.dbo.MstrUnitPerwatan g on g.ID = a.Unit
                                          inner join MasterdataSQL.dbo.MstrPerusahaanJPK c on c.ID = a.Perusahaan
                                          inner join $tabel d on d.NoMR = a.NoMR
                                          inner join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
                                          left join PerawatanSQL.DBO.Apointment f on f.NoRegistrasi = a.NoRegistrasi
                                          left join PerawatanSQL.dbo.BPJS_T_SEP h on h.NO_REGISTRASI= a.NoRegistrasi
                                          outer apply (select * from PerawatanSQL.dbo.BPJS_T_PRB_HDR where NO_REGISTRASI=a.NoRegistrasi and batal='0') 
										  bs
                                          where  a.id=:IdRegistrasi2 and a.Batal='0' and a.Batal='0' and  h.Batal='0'
                                         "); 
            $this->db->bind('IdRegistrasi2', $IdRegistrasi);
            $data =  $this->db->single();
            $callback = array(
                'status' => 'success', // Set array status dengan success
                'ID' => $data['id'], // Set array status dengan success
                'NoMR' => $data['NoMR'], // Set array status dengan success
                'NoEpisode' => $data['NoEpisode'], // Set array status dengan success
                'NoRegistrasi' => $data['NoRegistrasi'], // Set array status dengan success
                'PatientName' => $data['PatientName'], // Set array status dengan success
                'LokasiPasien' => $data['LokasiPasien'], // Set array status dengan success
                'CaraBayar' => $data['CaraBayar'], // Set array status dengan successDate_of_birth
                'NoPesertaBPJS' => $data['NoPesertaBPJS'], // Set array status dengan successDate_of_birth
                'NoSEP' => $data['NoSEP'], // Set array status dengan successDate_of_birth
                'TglSEP' => $data['TglSEP'], // Set array status dengan successDate_of_birth
                'AlasanSEPtunda' => $data['AlasanSEPtunda'], // Set array status dengan successDate_of_birth
                'ID_Card_number' => $data['ID_Card_number'], // Set array status dengan success 
                'Gander' => $data['Gander'], // Set array status dengan success
                'Date_of_birth' => $data['Date_of_birthx'], // Set array status dengan successDate_of_birth
                'Address' => $data['Address'], // Set array status dengan successDate_of_birth
                'NamaGander' => $data['NamaGander'], // Set array status dengan successDate_of_birth
                'BirthPlace' => $data['BirthPlace'], // Set array status dengan successDate_of_birth
                'Ocupation' => $data['Ocupation'], // Set array status dengan successDate_of_birth
                'NoAntrianAll' => $data['NoAntrianAll'], // Set array status dengan successDate_of_birth
                'NoBooking' => $data['NoBooking'],
                'Unit' => $data['Unit'], // Set array status dengan successDate_of_birth
                'LokasiPasien' => $data['LokasiPasien'], // Set array status dengan successDate_of_birth
                'namadokter' => $data['namadokter'], // Set array status dengan successDate_of_birth
                'Doctor1' => $data['Doctor_1'], // Set array status dengan successDate_of_birth
                'PatientType' => $data['PatientType'], // Set array status dengan successDate_of_birth
                'Perusahaanid' => $data['Perusahaanid'], // Set array status dengan successDate_of_birth
                'Perusahaan' => $data['Perusahaan'], // Set array status dengan successDate_of_birth
                'idAdmin' => $data['idAdmin'], // Set array status dengan successDate_of_birth
                'idCaraMasuk' => $data['idCaraMasuk'], // Set array status dengan successDate_of_birth
                'idCaraMasuk2' => $data['idCaraMasuk2'], // Set array status dengan successDate_of_birth
                'JenisDaftar' => $data['JenisDaftar'], // Set array status dengan successDate_of_birth
                'VisitDate' => $data['tglkunjungan'],
                'JamDate' => $data['jamkunjungan'],
                'NO_SRB' => $data['NO_SRB'],
                'email' => $data['email'],
                'ID_HDR_BPJS' => $data['ID_HDR_BPJS'],
            
                'KODE_POLI' => $data['KODE_POLI'],
                'NAMA_POLI' => $data['NAMA_POLI'],
                'KODE_DOKTER' => $data['KODE_DOKTER'],
                'NAMA_DOKTER' => $data['NAMA_DOKTER'],
                
                'KODE_PROGRAM_PRB' => $data['KODE_PROGRAM_PRB'],
                'NAMA_PROGRAM_PRB' => $data['NAMA_PROGRAM_PRB'],
                'KETERANGAN' => $data['KETERANGAN'],
                'SARAN' => $data['SARAN'],

                'ID_Dokter_BPJS' => $data['ID_Dokter_BPJS'],
                'NAMA_Dokter_BPJS' => $data['NAMA_Dokter_BPJS'],
                'CodeSubBPJS' => $data['CodeSubBPJS'],
                'NamaBPJS' => $data['NamaBPJS'], 
                'KETERANGAN_PRB' => $data['KETERANGAN_PRB']
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

    public function CreatePRB($data)
    {
        try {
            $this->db->transaksi();

            $noreg = $data['NoRegistrasi'];
            $nomr = $data['NoMR'];
            $nosep = $data['NoSEP'];
            $nokartu = $data['NoKartuBPJS'];
            $namapeserta = $data['NamaPasien'];
            $tgllahir = $data['TglLahir'];
            $alamat = $data['Alamat'];
            $email = $data['Email'];
            $keterangan = $data['Keterangan'];
            $saran = $data['Saran'];
            $kodepoli = $data['KodePoliklinikBPJS'];
            $namapoli = $data['NamaPoliklinikBPJS'];
            $kodedokter = $data['KodeDokterBPJS'];
            $namadokter = $data['NamaDokterBPJS'];
            $programprb = $data['KodeProgramPRB'];
            $namaprogramprb = $data['NamaProgramPRB'];
            $jeniskelamin = null;
            $datenowcreate= Utils::seCurrentDateTime();
            //Session user
            $session = SessionManager::getCurrentSession();
            $userid =  $session->IDEmployee;

            if ($kodepoli == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Poliklinik!',
                );
                return $callback;
                exit;
            }

            if ($kodedokter == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Dokter!',
                );
                return $callback;
                exit;
            }

            if ($programprb == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Program PRB!',
                );
                return $callback;
                exit;
            }

            if ($keterangan == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Keterangan!',
                );
                return $callback;
                exit;
            }

            if ($saran == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silahkan Input Saran!',
                );
                return $callback;
                exit;
            }

            //get hdr
            $this->db->query("SELECT ID from PerawatanSQL.dbo.BPJS_T_PRB_HDR  WHERE NO_REGISTRASI=:noreg and BATAL='0'");
            $this->db->bind('noreg', $noreg);
            $data =  $this->db->single();
            $idprb = $data['ID']; 

            if ($idprb != "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Nomor Registrasi Ini Sudah Mempunyai ID PRB! Silahkan Refresh Halaman !',
                );
                return $callback;
                exit;
            }

                    $this->db->query("INSERT INTO PerawatanSQL.[dbo].[BPJS_T_PRB_HDR]
                    ([NO_REGISTRASI],[NO_MR],[NO_SEP],[NAMA_PESERTA],[JENIS_KELAMIN],[EMAIL],[NO_KARTU],[TGL_LAHIR],[ALAMAT],[KODE_DOKTER],[NAMA_DOKTER],[KODE_PROGRAM_PRB],[NAMA_PROGRAM_PRB],[KETERANGAN],[SARAN],[USER_FIRST_INSERT],[TANGGAL_INSERT],[KODE_POLI],[NAMA_POLI])
              VALUES
                    (:noreg,:nomr,:nosep,:namapeserta,:jeniskelamin,:email,:nokartu,:tgllahir,:alamat,:kodedokter,:namadokter,:programprb,:namaprogramprb,:keterangan,:saran,:userinput,:tglinsert,:kodepoli,:namapoli)");
                    $this->db->bind('noreg', $noreg);
                    $this->db->bind('nomr', $nomr);
                    $this->db->bind('nosep', $nosep);
                    $this->db->bind('nokartu', $nokartu);
                    $this->db->bind('namapeserta', $namapeserta);
                    $this->db->bind('tgllahir', $tgllahir);
                    $this->db->bind('alamat', $alamat);
                    $this->db->bind('email', $email);
                    $this->db->bind('keterangan', $keterangan);
                    $this->db->bind('saran', $saran);
                    $this->db->bind('jeniskelamin', $jeniskelamin);
                    $this->db->bind('kodedokter', $kodedokter);
                    $this->db->bind('namadokter', $namadokter);
                    $this->db->bind('programprb', $programprb);
                    $this->db->bind('namaprogramprb', $namaprogramprb);
                    $this->db->bind('userinput', $userid);
                    $this->db->bind('tglinsert', $datenowcreate);

                    $this->db->bind('kodepoli', $kodepoli);
                    $this->db->bind('namapoli', $namapoli);
                    

            $this->db->execute();
            $idhdrprb = $this->db->GetLastID();
            $this->db->commit();
            $callback = array(
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success  
                'idhdrprb' => $idhdrprb, // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function getObatDtlPRB($id)
    {
        try {
            $this->db->query("SELECT * from PerawatanSQL.dbo.BPJS_T_PRB_DTL
                                           where ID_HDR=:id and BATAL='0'
                                           ");
            $this->db->bind('id', $id);
            $data =  $this->db->resultSet();
            $rows = array();
            $no = 1;
            foreach ($data as $key) {
                $pasing['No'] = $no++;
                $pasing['KODE_OBAT'] = $key['KODE_OBAT'];
                $pasing['NAMA_OBAT'] = $key['NAMA_OBAT'];
                $pasing['QTY'] = $key['QTY'];
                $pasing['SIGNA1'] = $key['SIGNA1'];
                $pasing['SIGNA2'] = $key['SIGNA2'];
                $pasing['ID'] = $key['ID'];
                $rows[] = $pasing;
            }
            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function addObatPRB($data)
    {
        try {
            $this->db->transaksi();

            $IDHDR = $data['idhdr_bpjs'];
            $KodeObatPRB = $data['KodeObatPRB'];
            $NamaObatPRB = $data['NamaObatPRB'];
            $QtyObat = $data['QtyObat'];
            $Signa1 = $data['Signa1'];
            $Signa2 = $data['Signa2'];

            if ($IDHDR == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'ID Hdr tidak ditemukan! Silahkan klik Create New untuk buat PRB Baru!',
                );
                return $callback;
                exit;
            }

            if ($KodeObatPRB == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silakan Isi Obat PRB!',
                );
                return $callback;
                exit;
            }

            if ($QtyObat == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silakan Isi Obat Qty!',
                );
                return $callback;
                exit;
            }

            if ($Signa1 == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silakan Isi Signa 1 !',
                );
                return $callback;
                exit;
            }

            if ($Signa2 == "") {
                $callback = array(
                    'status' => 'warning',
                    'errorname' => 'Silakan Isi Signa 2 !',
                );
                return $callback;
                exit;
            }

                    $this->db->query("INSERT INTO PerawatanSQL.dbo.BPJS_T_PRB_DTL
                    (ID_HDR,KODE_OBAT,NAMA_OBAT,QTY,SIGNA1,SIGNA2) VALUES
                  (:IDHDR,:KodeObatPRB,:NamaObatPRB,:QtyObat,:Signa1,:Signa2)");
                    
                    $this->db->bind('IDHDR', $IDHDR);
                    $this->db->bind('KodeObatPRB', $KodeObatPRB);
                    $this->db->bind('NamaObatPRB', $NamaObatPRB);
                    $this->db->bind('QtyObat', $QtyObat);
                    $this->db->bind('Signa1', $Signa1);
                    $this->db->bind('Signa2', $Signa2);

            $this->db->execute();
            $this->db->commit();
            $callback = array(
                'KodeObatPRB' => $KodeObatPRB, // Set array status dengan success  
                'status' => 'success', // Set array status dengan success   
                'message' => 'Transkasi Berhasil Disimpan !', // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    function GoSimpanPRB($data)
    {
 
        $idhdr = $data['idhdr_bpjs'];
        $IdAuto = $data['IdAuto'];
        $NO_SRB = $data['NoSRB'];
        $NoRegistrasi = $data['NoRegistrasi'];
        $NoMR = $data['NoMR'];
        $NoEpisode = $data['NoEpisode'];
        $nosep = $data['NoSEP'];
        $nokartu = $data['NoKartuBPJS'];
        $email = $data['Email'];
        $NamaPasien = $data['NamaPasien']; 
        $TglLahir = $data['TglLahir'];
        $alamat = $data['Alamat'];
        $KodePoliklinikBPJS = $data['KodePoliklinikBPJS'];
        $NamaPoliklinikBPJS = $data['NamaPoliklinikBPJS'];
        $kodedokter = $data['KodeDokterBPJS'];
        $NamaDokterBPJS = $data['NamaDokterBPJS'];
        $kodeprogramprb = $data['KodeProgramPRB'];
        $NamaProgramPRB = $data['NamaProgramPRB'];
        $keterangan = $data['Keterangan'];
        $saran = $data['Saran']; 

        //get obat detail
        $this->db->query("SELECT * from PerawatanSQL.dbo.BPJS_T_PRB_DTL
                                           where ID_HDR=:id and BATAL='0'
                                           ");
            $this->db->bind('id', $idhdr);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['kdObat'] = $key['KODE_OBAT'];
                $pasing['signa1'] = $key['SIGNA1'];
                $pasing['signa2'] = $key['SIGNA2'];
                $pasing['jmlObat'] = $key['QTY'];
                $rows[] = $pasing;
            }
            $list = json_encode($rows);
            
         

            //get user id
            $session = SessionManager::getCurrentSession();
            $userid = $session->IDEmployee;

        //$searchTerm = $data['searchTerm'];
        // persiapkan curl
        $curl = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
        $headerbpjs = Utils::headerBPJS_BPJS($tStamp);
        $postdata = '
        {
            "request":
             {
            "t_prb":
              {  
                "noSep": "' . $nosep. '",
                "noKartu": "' . $nokartu. '",
                "alamat": "' . $alamat. '",
                "email": "' . $email. '",
                "programPRB": "' . $kodeprogramprb. '",
                "kodeDPJP": "' . $kodedokter. '",
                "keterangan": "' . $keterangan. '",
                "saran": "' . $saran. '",
                "user": "' . $userid. '",
                "obat":
                      ' . $list . '
              }
             }
          }  '; 
        curl_setopt($curl, CURLOPT_URL, URL_BPJS . "PRB/insert");
        // set header
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headerbpjs);
        // set time out
        curl_setopt($curl, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        // data yang dikirim
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
        // return the transfer as a string 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        //var_dump($postdata);exit; 
        $output = curl_exec($curl);
        // tutup curl 
        curl_close($curl); 
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            $JsonDatax   = json_decode(json_encode($ResultEncriptLzString), true);
          
            $noSRB = $JsonDatax['1']['noSRB'];
            $this->db->query("UPDATE PerawatanSQL.DBO.BPJS_T_PRB_HDR SET 
                            NO_SRB=:noSRB,KODE_POLI=:KODE_POLI,NAMA_POLI=:NAMA_POLI,KODE_DOKTER=:KODE_DOKTER,
                            NAMA_DOKTER=:NAMA_DOKTER,KODE_PROGRAM_PRB=:KODE_PROGRAM_PRB,
                            NAMA_PROGRAM_PRB=:NAMA_PROGRAM_PRB,KETERANGAN=:KETERANGAN,SARAN=:SARAN
                            WHERE id=:id");
            $this->db->bind('noSRB', $noSRB);
            $this->db->bind('KODE_POLI', $KodePoliklinikBPJS);
            $this->db->bind('NAMA_POLI', $NamaPoliklinikBPJS);
            $this->db->bind('KODE_DOKTER', $kodedokter);
            $this->db->bind('NAMA_DOKTER', $NamaDokterBPJS);
            $this->db->bind('KODE_PROGRAM_PRB', $kodeprogramprb);
            $this->db->bind('NAMA_PROGRAM_PRB', $NamaProgramPRB);
            $this->db->bind('KETERANGAN', $keterangan);
            $this->db->bind('SARAN', $saran);
            $this->db->bind('id', $idhdr);
            $this->db->execute(); 
            $callback = array(
                'status' => 'success',
                'hasil' => $ResultEncriptLzString,
                'noSRB' => $noSRB
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

    function GoUpdatePRB($data)
    {
        $idhdr = $data['idhdr_bpjs'];
        $IdAuto = $data['IdAuto'];
        $nosrb = $data['NoSRB'];
        $NoRegistrasi = $data['NoRegistrasi'];
        $NoMR = $data['NoMR'];
        $NoEpisode = $data['NoEpisode'];
        $nosep = $data['NoSEP'];
        $nokartu = $data['NoKartuBPJS'];
        $email = $data['Email'];
        $NamaPasien = $data['NamaPasien'];
        $TglLahir = $data['TglLahir'];
        $alamat = $data['Alamat'];
        $KodePoliklinikBPJS = $data['KodePoliklinikBPJS'];
        $NamaPoliklinikBPJS = $data['NamaPoliklinikBPJS'];
        $kodedokter = $data['KodeDokterBPJS'];
        $NamaDokterBPJS = $data['NamaDokterBPJS'];
        $kodeprogramprb = $data['KodeProgramPRB'];
        $NamaProgramPRB = $data['NamaProgramPRB'];
        $keterangan = $data['Keterangan'];
        $saran = $data['Saran']; 
        //get obat detail
        $this->db->query("SELECT * from PerawatanSQL.dbo.BPJS_T_PRB_DTL
                                           where ID_HDR=:id and BATAL='0'
                                           ");
            $this->db->bind('id', $idhdr);
            $data =  $this->db->resultSet();
            $rows = array();
            foreach ($data as $key) {
                $pasing['kdObat'] = $key['KODE_OBAT'];
                $pasing['signa1'] = $key['SIGNA1'];
                $pasing['signa2'] = $key['SIGNA2'];
                $pasing['jmlObat'] = $key['QTY'];
                $rows[] = $pasing;
            }
            $list = json_encode($rows);
 
            //get user id
            $session = SessionManager::getCurrentSession();
            $userid = $session->IDEmployee;

        //$searchTerm = $data['searchTerm'];
        // persiapkan curl
        $curl = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
            $headerbpjs = Utils::headerBPJS_BPJS($tStamp);

        $postdata = '
        {
            "request":{
               "t_prb":{
                  "noSrb":"' . $nosrb. '",
                  "noSep":"' . $nosep. '",
                  "alamat":"' . $alamat. '",
                  "email":"' . $email. '",
                  "kodeDPJP":"' . $kodedokter. '",
                  "keterangan":"' . $keterangan. '",
                  "saran":"' . $saran. '",
                  "user":"' . $userid. '",
                  "obat":
                  ' . $list . '
               }
            }
         }  ';

        curl_setopt($curl, CURLOPT_URL, URL_BPJS_REFF . "PRB/Update");
        // set header
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headerbpjs);
        // set time out
        curl_setopt($curl, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        // data yang dikirim
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
        // return the transfer as a string 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string  

        $output = curl_exec($curl);
        // tutup curl 
        curl_close($curl);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
            $JsonDatax   = json_decode(json_encode($ResultEncriptLzString), true);
            $noSRB = $JsonDatax['1']['response']['noSRB'];
            $this->db->query("UPDATE PerawatanSQL.DBO.BPJS_T_PRB_HDR SET 
                            NO_SRB=:noSRB,KODE_POLI=:KODE_POLI,NAMA_POLI=:NAMA_POLI,KODE_DOKTER=:KODE_DOKTER,
                            NAMA_DOKTER=:NAMA_DOKTER,KODE_PROGRAM_PRB=:KODE_PROGRAM_PRB,
                            NAMA_PROGRAM_PRB=:NAMA_PROGRAM_PRB,KETERANGAN=:KETERANGAN,SARAN=:SARAN
                            WHERE id=:id");
            $this->db->bind('noSRB', $noSRB);
            $this->db->bind('KODE_POLI', $KodePoliklinikBPJS);
            $this->db->bind('NAMA_POLI', $NamaPoliklinikBPJS);
            $this->db->bind('KODE_DOKTER', $kodedokter);
            $this->db->bind('NAMA_DOKTER', $NamaDokterBPJS);
            $this->db->bind('KODE_PROGRAM_PRB', $kodeprogramprb);
            $this->db->bind('NAMA_PROGRAM_PRB', $NamaProgramPRB);
            $this->db->bind('KETERANGAN', $keterangan);
            $this->db->bind('SARAN', $saran);
            $this->db->bind('id', $idhdr);
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
                'errorname' => $JsonData['metaData']['message']

            );
            return $callback;
        }
    }

    function GoDeletePRB($data)
    {
        $idhdr = $data['idhdr_bpjs'];

            //get hdr
            $this->db->query("SELECT * from PerawatanSQL.dbo.BPJS_T_PRB_HDR  WHERE ID=:id and BATAL='0'");
            $this->db->bind('id', $idhdr);
            $data =  $this->db->single();
            $nosep = $data['NO_SEP']; 
            $nosrb = $data['NO_SRB']; 
            //get user id
            $session = SessionManager::getCurrentSession();
            $userid = $session->IDEmployee;

        //$searchTerm = $data['searchTerm'];
        // persiapkan curl
        $curl = curl_init();
        $tStamp = GenerateBpjs::bpjsTimestamp();
            $headerbpjs = Utils::headerBPJS_BPJS($tStamp);

        $postdata = ' 
         {
            "request":
             {
            "t_prb":
              {  
                "noSrb":"'.$nosrb.'",
                "noSep":"'.$nosep.'",
                "user":"'.$userid.'"
               }
             }
          }
                    
         ';

        curl_setopt($curl, CURLOPT_URL, URL_BPJS . "PRB/Delete");
        // set header
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headerbpjs);
        // set time out
        curl_setopt($curl, CURLOPT_TIMEOUT, 3);
        // ssl verifi
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        // method
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        // data yang dikirim
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
        // return the transfer as a string 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        

        $output = curl_exec($curl);
        // tutup curl 
        curl_close($curl);
        // ubah string JSON menjadi array
        $JsonData = json_decode($output, TRUE);
       
        if ($JsonData['metaData']['code'] == "200") {
            $EncodeData = json_encode($JsonData);
            $ResultEncriptLzString = GenerateBpjs::responseBpjsV2($EncodeData, GenerateBpjs::keyString(Utils::setConsid(), Utils::setSeckey(), $tStamp));
             //SEP
             $this->db->query("UPDATE PerawatanSQL.dbo.BPJS_T_SEP set  
             INPUT_PRB='TIDAK' 
             WHERE ID=:nosep");
             $this->db->bind('nosep', $nosep);  
             $this->db->execute(); 

             // batalin prb
            $this->GoBatalPRBHdr($data);
            return $ResultEncriptLzString;
        } else {
            $callback = array(
                'status' => 'warning',
                'errorname' => $JsonData['metaData']['message']

            );
            return $callback;
        }
    }

    public function GoBatalPRBDtl($id)
    {
        try {
            $this->db->transaksi();
            
            $datenowcreate= Utils::seCurrentDateTime();
            //Session user
            $session = SessionManager::getCurrentSession();
            $userid =  $session->IDEmployee;

            $this->db->query("UPDATE PerawatanSQL.dbo.BPJS_T_PRB_DTL set  
            BATAL='1', PETUGAS_BATAL=:userid,TANGGAL_BATAL=:datenowcreate
            WHERE ID=:id");
            $this->db->bind('id', $id); 
            $this->db->bind('datenowcreate', $datenowcreate); 
            $this->db->bind('userid', $userid); 

            $this->db->execute();
            $this->db->commit();
            $callback = array( 
                'status' => 'success', // Set array status dengan success   
                'message' => 'Item Berhasil Dihapus !', // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }

    public function GoBatalPRBHdr($data)
    {
        try {
            $this->db->transaksi();
            $id = $data['idhdr_bpjs'];
            $alasan = $data['alasan'];
            
            $datenowcreate= Utils::seCurrentDateTime();
            //Session user
            $session = SessionManager::getCurrentSession();
            $userid =  $session->IDEmployee;

            //DELETE HDR
            $this->db->query("UPDATE PerawatanSQL.dbo.BPJS_T_PRB_HDR set  
            BATAL='1', PETUGAS_BATAL=:userid,TANGGAL_BATAL=:datenowcreate,ALASAN_BATAL=:alasan
            WHERE ID=:id");
            $this->db->bind('id', $id); 
            $this->db->bind('datenowcreate', $datenowcreate); 
            $this->db->bind('userid', $userid); 
            $this->db->bind('alasan', $alasan); 
            $this->db->execute();

            //DELETE DTL
            $this->db->query("UPDATE PerawatanSQL.dbo.BPJS_T_PRB_DTL set  
            BATAL='1', PETUGAS_BATAL=:userid,TANGGAL_BATAL=:datenowcreate
            WHERE ID_HDR=:id");
            $this->db->bind('id', $id); 
            $this->db->bind('datenowcreate', $datenowcreate); 
            $this->db->bind('userid', $userid); 
            $this->db->execute();

           

            $this->db->commit();
            $callback = array( 
                'status' => 'success', // Set array status dengan success   
                'message' => 'Item Berhasil Dihapus !', // Set array status dengan success    
            );
            return $callback;
        } catch (PDOException $e) {
            $this->db->rollback();
            $this->$e;
        }
    }
    public function getDataList($data)
    {
        try {
            $tglawal = $data['PeriodeAwal'];
            $tglakhir = $data['PeriodeAkhir'];
            $this->db->query("SELECT a.id, a.NoEpisode,a.NoRegistrasi,d.PatientName ,a.LokasiPasien,a.CaraBayar,
            a.NoMR, a.NoPesertaBPJS,a.NoSEP,a.TglSEP,a.AlasanSEPtunda,a.ApproveSEP,a.NoRujukan,
            a.TglRujukan,a.TglKunjungan,a.PPKRujukan, a.[Visit Date],
            a.PatientType,a.Unit,a.Doctor_1,b.First_Name as namadokter,a.JamPraktek,a.Perusahaan as Perusahaanid,c.NamaPerusahaan as  Perusahaan,a.[Payment Type],
            a.Antrian,a.NoAntrianAll,e.[First Name] as namauser,
              replace(CONVERT(VARCHAR(11), d.Date_of_birth, 111), '/','-') as Date_of_birthx,
              d.Address,d.Gander,d.BirthPlace,d.Ocupation,
              case when d.Gander='L' then 'LAKI-LAKI' when d.Gander='P' then 'PEREMPUAN'  END AS NamaGander,
              d.ID_Card_number,a.idAdmin,a.idCaraMasuk,a.idCaraMasuk2,a.JenisDaftar, 
              replace(CONVERT(VARCHAR(11), a.TglKunjungan, 111), '/','-') as tglkunjungan,CONVERT(VARCHAR(8),
              TglKunjungan,108) as jamkunjungan, d.[E-mail Address] as email,
                h.NAMA_POLI, h.NAMA_DOKTER, b.ID_Dokter_BPJS,b.NAMA_Dokter_BPJS,g.CodeSubBPJS,g.NamaBPJS,h.KETERANGAN_PRB
                ,h.PRB,h.INPUT_PRB
            from PerawatanSQL.dbo.Visit a
            inner join MasterdataSQL.dbo.Doctors b on a.Doctor_1 = b.ID
            inner join MasterdataSQL.dbo.MstrUnitPerwatan g on g.ID = a.Unit
            inner join MasterdataSQL.dbo.MstrPerusahaanJPK c on c.ID = a.Perusahaan
            inner join MasterDataSQL.dbo.Admision d on d.NoMR = a.NoMR
            inner join MasterdataSQL.dbo.Employees e on e.ID = a.Operator
            left join PerawatanSQL.dbo.BPJS_T_SEP h on h.NO_REGISTRASI= a.NoRegistrasi
            where    a.Batal='0' and a.Batal='0' and  h.Batal='0' 
            --and h.PRB='YA' AND h.INPUT_PRB='TIDAK'
            and replace(CONVERT(VARCHAR(11), h.TGL_SEP, 111), '/','-')  BETWEEN :TglAwal AND :TglAkhir and H.PRB='YA'"); 
             $this->db->bind('TglAwal', $tglawal);
             $this->db->bind('TglAkhir', $tglakhir); 
                            $data =  $this->db->resultSet();
                            $rows = array();
                            foreach ($data as $row) {
                                $pasing['id'] = $row['id'];
                                $pasing['NoEpisode'] = $row['NoEpisode']; 
                                $pasing['tglkunjungan'] = date('d/m/Y', strtotime($row['tglkunjungan'])) . ' - ' . $row['jamkunjungan']; 
                                $pasing['PatientName'] = $row['PatientName'];
                                $pasing['NoRegistrasi'] =$row['NoRegistrasi'];
                                $pasing['NoMR'] =$row['NoMR'];
                                $pasing['LokasiPasien'] = $row['LokasiPasien'];
                                $pasing['NoSEP'] = $row['NoSEP'];
                                $pasing['namadokter'] = $row['namadokter'];  
                                $pasing['PRB'] = $row['PRB'];  
                                $pasing['INPUT_PRB'] = $row['INPUT_PRB'];  
                                $rows[] = $pasing;
                            }
                            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintPRBHdr($data)
    {
        try {
                $query = "SELECT a.ID,
                NO_REGISTRASI,
                NO_MR,
                NO_SEP,
                NO_SRB,
                NAMA_PESERTA,
                JENIS_KELAMIN,
                EMAIL,
                NO_KARTU,
                NO_TELEPON,
                ALAMAT,
                KODE_FASKES,
                NAMA_FASKES,
                KODE_POLI,
                NAMA_POLI,
                KODE_DOKTER,
                NAMA_DOKTER,
                KODE_PROGRAM_PRB,
                NAMA_PROGRAM_PRB,
                KETERANGAN,
                SARAN,
                TANGGAL_SRB,
                USER_FIRST_INSERT,
                TANGGAL_INSERT,
                USER_LAST_UPDATE,
                TANGGAL_UPDATE,
                BATAL,
                TANGGAL_BATAL,
                PETUGAS_BATAL,
                ALASAN_BATAL,
                case when b.Gander='F' then 'P' else 'L' end as Gender,
                replace(CONVERT(VARCHAR(11), TGL_LAHIR, 111), '/','-') as TGL_LAHIR,
                replace(CONVERT(VARCHAR(11), TANGGAL_SRB, 111), '/','-') as TANGGAL_SRB
                FROM  PerawatanSQL.dbo.BPJS_T_PRB_HDR a
                inner join MasterDataSQL.dbo.Admision b on a.NO_MR=b.NoMR
                where a.ID=:id And BATAL='0'";

            $this->db->query($query);
            $this->db->bind('id', $data['notrs']);
            $data =  $this->db->single();

            $pasing['TGL_LAHIR'] = ($data['TGL_LAHIR'] != null) ? date('d/m/Y', strtotime($data['TGL_LAHIR'])) : '';
            $pasing['TANGGAL_SRB'] = ($data['TANGGAL_SRB'] != null) ? date('d/m/Y', strtotime($data['TANGGAL_SRB'])) : '';
            $pasing['ID'] = $data['ID'];
            $pasing['NO_REGISTRASI'] = $data['NO_REGISTRASI'];
            $pasing['NO_MR'] = $data['NO_MR'];
            $pasing['NO_SEP'] = $data['NO_SEP'];
            $pasing['NO_SRB'] = $data['NO_SRB'];
            $pasing['NAMA_PESERTA'] = $data['NAMA_PESERTA'];
            $pasing['JENIS_KELAMIN'] = $data['JENIS_KELAMIN'];
            $pasing['EMAIL'] = $data['EMAIL'];
            $pasing['NO_KARTU'] = $data['NO_KARTU'];
            $pasing['NO_TELEPON'] = $data['NO_TELEPON'];
            $pasing['ALAMAT'] = $data['ALAMAT'];
            $pasing['KODE_FASKES'] = $data['KODE_FASKES'];
            $pasing['NAMA_FASKES'] = $data['NAMA_FASKES'];
            $pasing['KODE_POLI'] = $data['KODE_POLI'];
            $pasing['NAMA_POLI'] = $data['NAMA_POLI'];
            $pasing['KODE_DOKTER'] = $data['KODE_DOKTER'];
            $pasing['NAMA_DOKTER'] = $data['NAMA_DOKTER'];
            $pasing['KODE_PROGRAM_PRB'] = $data['KODE_PROGRAM_PRB'];
            $pasing['NAMA_PROGRAM_PRB'] = $data['NAMA_PROGRAM_PRB'];
            $pasing['KETERANGAN'] = $data['KETERANGAN'];
            $pasing['SARAN'] = $data['SARAN'];
            $pasing['USER_FIRST_INSERT'] = $data['USER_FIRST_INSERT'];
            $pasing['TANGGAL_INSERT'] = $data['TANGGAL_INSERT'];
            $pasing['USER_LAST_UPDATE'] = $data['USER_LAST_UPDATE'];
            $pasing['TANGGAL_UPDATE'] = $data['TANGGAL_UPDATE'];
            $pasing['BATAL'] = $data['BATAL'];
            $pasing['TANGGAL_BATAL'] = $data['TANGGAL_BATAL'];
            $pasing['PETUGAS_BATAL'] = $data['PETUGAS_BATAL'];
            $pasing['ALASAN_BATAL'] = $data['ALASAN_BATAL'];
            $pasing['Gender'] = $data['Gender'];
            

            return $pasing;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function PrintPRBDtl($data)
    {
        try {

                $query = "SELECT * FROM PerawatanSQL.dbo.BPJS_T_PRB_DTL WHERE ID_HDR=:id AND BATAL='0'";

            $this->db->query($query);
            $this->db->bind('id', $data['notrs']);
            $datas =  $this->db->resultSet();

                            $rows = array();
                            $no = 1;
                            foreach ($datas as $key) {
                                $pasing['No'] = $no++;
                                $pasing['ID'] = $key['ID'];
                                $pasing['ID_HDR'] = $key['ID_HDR'];
                                $pasing['KODE_OBAT'] = $key['KODE_OBAT'];
                                $pasing['NAMA_OBAT'] = $key['NAMA_OBAT'];
                                $pasing['QTY'] = $key['QTY'];
                                $pasing['SIGNA1'] = $key['SIGNA1'];
                                $pasing['SIGNA2'] = $key['SIGNA2'];
                                $pasing['BATAL'] = $key['BATAL'];
                                $pasing['PETUGAS_BATAL'] = $key['PETUGAS_BATAL'];
                                $pasing['TANGGAL_BATAL'] = $key['TANGGAL_BATAL'];
                                $rows[] = $pasing;
                            }
                                
                            return $rows;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}