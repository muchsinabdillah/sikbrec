$(document).ready(function () {
    $(".preloader").fadeOut();
    asyncShowMain();
    asyncShowWakilPasien();
    asyncShowNurseAssOp();
    asyncShowDokterAssOp();
});

async function asyncShowMain(){
    try{
        const datagetPasienByNoReg = await getPasienByNoReg();
        updateUIdatagetPasienByNoReg(datagetPasienByNoReg);
    } catch (err) {
        toast(err.message, "error")
    }
}

// Biodata Pasien
function getPasienByNoReg() {
    var base_url = window.location.origin;
    let url = base_url + '/EMR/public/aEMR/getDataPasien';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'NoRegistrasi=' + $("#emr_noreg").val() 
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(response => {
            if (response.status === "error") {
                throw new Error(response.message.errorInfo[2]);
                // console.log("ok " + response.message.errorInfo[2])
            } else if (response.status === "warning") {
                throw new Error(response.errorname);
                // console.log("ok " + response.message.errorInfo[2])
            }
            return response
        })
        .finally(() => {
            
        })
}

function updateUIdatagetPasienByNoReg(datagetPasienByNoReg) {
    let datapasien = datagetPasienByNoReg;
    $("#emr_idvisit").val(datapasien.data.ID);
    $("#emr_nama").val(datapasien.data.PatientName);
    $("#emr_norm").val(datapasien.data.NoMR);
    $("#emr_noeps").val(datapasien.data.NoEpisode);
    $("#emr_tanggallahir").val(datapasien.data.Date_of_birth);
    $("#emr_nohp").val(datapasien.data.No_Phone);
    $("#emr_nik").val(datapasien.data.Nik);
    $("#emr_pekerjaan").val(datapasien.data.Pekerjaan);
    $("#emr_alamat").val(datapasien.data.Address);
    $("#emr_agama").val(datapasien.data.Religion);
    $("#emr_jeniskelamin").val(datapasien.data.Gander);

    $("#emr_prabedah_namapasien").val(datapasien.data.PatientName);
    $("#emr_prabedah_normpasien").val(datapasien.data.NoMR);
    $("#emr_prabedah_tgllahirpasien").val(datapasien.data.Date_of_birth);
    $("#emr_prabedah_usiapasien").val(datapasien.data.as_year);

}

async function asyncShowWakilPasien(){
    try{
        const datagetWakilPasienByNoreg = await getWakilPasienByNoreg();
        updateUIdatagetWakilPasienByNoreg(datagetWakilPasienByNoreg);
    } catch (err) {
        toast(err.message, "error")
    }
}
function getWakilPasienByNoreg() {
    var base_url = window.location.origin;
    let url = base_url + '/EMR/public/aEMR/getDataWakilPasien';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'NoRegistrasi=' + $("#emr_noreg").val() 
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(response => {
            if (response.status === "error") {
                throw new Error(response.message.errorInfo[2]);
                // console.log("ok " + response.message.errorInfo[2])
            } else if (response.status === "warning") {
                throw new Error(response.errorname);
                // console.log("ok " + response.message.errorInfo[2])
            }
            return response
        })
        .finally(() => {
            
        })
}
function updateUIdatagetWakilPasienByNoreg(datagetWakilPasienByNoreg) {
    let datawakilpasien = datagetWakilPasienByNoreg;
    $("#emer_namawakil").val(datawakilpasien.data.Nama_Wakil_Pasien);
    $("#emr_umurwakil").val(datawakilpasien.data.Umur_Wakil_Paisen);
    $("#emr_nohpwakil").val(datawakilpasien.data.NoHp_Wakil_Pasien);
    $("#emr_nikwakil").val(datawakilpasien.data.NIK_Wakil_Pasien);
    $("#emr_pekerjaanwakil").val(datawakilpasien.data.Pekerjaan_Wakil_Pasien);
    $("#emr_alamatwakil").val(datawakilpasien.data.Alamat_Wakil_Pasien);
    $("#emr_hubunganwakil").val(datawakilpasien.data.Hubungan_Wakil_Pasien);
    $("#emr_keteranganwakil").val(datawakilpasien.data.Keterangan_Wakil_Pasien);
    $("#emr_jeniskelaminwakil").val(datawakilpasien.data.JenisKelamin_Wakil_Pasien);
}

async function asyncShowNurseAssOp(){
    try{
        const datagetNurseAssesmentOperasiByNoreg = await getAssesmentNurseOperasiByNoreg();
        updateUIdatagetNurseAssesmentOperasiByNoreg(datagetNurseAssesmentOperasiByNoreg);
    } catch (err) {
        toast(err.message, "error")
    }
}
function getAssesmentNurseOperasiByNoreg() {
    var base_url = window.location.origin;
    let url = base_url + '/EMR/public/aEMR/getDataNurseAssOperasi';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'NoRegistrasi=' + $("#emr_noreg").val() + 
            '&idOrder=' + $("#emr_idorder").val() 
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(response => {
            if (response.status === "error") {
                throw new Error(response.message.errorInfo[2]);
                // console.log("ok " + response.message.errorInfo[2])
            } else if (response.status === "warning") {
                throw new Error(response.errorname);
                // console.log("ok " + response.message.errorInfo[2])
            }
            return response
        })
        .finally(() => {
            
        })
}
function updateUIdatagetNurseAssesmentOperasiByNoreg(datagetNurseAssesmentOperasiByNoreg){
    let datanurseassesmentoperasi = datagetNurseAssesmentOperasiByNoreg;
    //PRE OPERASI NA
    $("#emr_preop_keadaanumum").val(datanurseassesmentoperasi.data.KeadaanUmum);
    $("#emr_preop_totalscorecgs").val(datanurseassesmentoperasi.data.GCS);
    $("#emr_preop_bukamata").val(datanurseassesmentoperasi.data.GCS_E);
    $("#emr_preop_motorik").val(datanurseassesmentoperasi.data.GCS_M);
    $("#emr_preop_verbal").val(datanurseassesmentoperasi.data.GCS_V);
    $("#emr_preop_kesadaran").val(datanurseassesmentoperasi.data.Kesadaran);
    $("#emr_preop_tekanandarah").val(datanurseassesmentoperasi.data.TD_Sistole);
    $("#emr_preop_tekanandarahmmhg").val(datanurseassesmentoperasi.data.TD_Distole);
    $("#emr_preop_suhu").val(datanurseassesmentoperasi.data.Suhu);
    $("#emr_preop_nadi").val(datanurseassesmentoperasi.data.Nadi);
    $("#emr_preop_pernapasan").val(datanurseassesmentoperasi.data.pernafasan);
    $("#emr_preop_riwayatpernapasan").val(datanurseassesmentoperasi.data.RPD);
    $("#emr_preop_pengobatansaatini").val(datanurseassesmentoperasi.data.PengobatanSaatini);
    $("#emr_preop_pengobatansaatiniket").val(datanurseassesmentoperasi.data.PSI_Lainnya);
    $("#emr_preop_hasilpenunjang").val(datanurseassesmentoperasi.data.HasilLab);
    $("#emr_preop_statuspsikologi").val(datanurseassesmentoperasi.data.StatusPsikologis);
    $("#emr_preop_spiritualagama").val(datanurseassesmentoperasi.data.Spiritual);
    $("#emr_preop_userinput").val(datanurseassesmentoperasi.data.NamaUserOrder);

    //PERSIAPAN OPERASI NA
    $("#emr_persiapanop_identitaspasien_pruangan").val(datanurseassesmentoperasi.data.VP_PIP_PR);
    $("#emr_persiapanop_identitaspasien_poti").val(datanurseassesmentoperasi.data.VP_PIP_OT);
    $("#emr_persiapanop_identitaspasienket").val(datanurseassesmentoperasi.data.VP_PIP_Note);
    $("#emr_persiapanop_identitasgelang_pruangan").val(datanurseassesmentoperasi.data.VP_PGI_PR);
    $("#emr_persiapanop_identitasgelang_poti").val(datanurseassesmentoperasi.data.VP_PGI_OT);
    $("#emr_persiapanop_identitasgelangket").val(datanurseassesmentoperasi.data.VP_PGI_Note);
    $("#emr_persiapanop_permintaanonline_pruangan").val(datanurseassesmentoperasi.data.VP_SPO_PR);
    $("#emr_persiapanop_permintaanonline_poti").val(datanurseassesmentoperasi.data.VP_SPO_OT);
    $("#emr_persiapanop_permintaanonlineket").val(datanurseassesmentoperasi.data.VP_SPO_Note);
    $("#emr_persiapanop_jenislokasi_pruangan").val(datanurseassesmentoperasi.data.VP_JLP_PR);
    $("#emr_persiapanop_jenislokasi_poti").val(datanurseassesmentoperasi.data.VP_JLP_OT);
    $("#emr_persiapanop_jenislokasiket").val(datanurseassesmentoperasi.data.VP_JLP_Note);
    $("#emr_persiapanop_masalahkomunikasi_pruangan").val(datanurseassesmentoperasi.data.VP_MBK_PR);
    $("#emr_persiapanop_masalahkomunikasi_poti").val(datanurseassesmentoperasi.data.VP_MBK_OT);
    $("#emr_persiapanop_masalahkomunikasiket").val(datanurseassesmentoperasi.data.VP_MBK_Note);
    $("#emr_persiapanop_persetujuanbedah_pruangan").val(datanurseassesmentoperasi.data.VP_PKPP_PR);
    $("#emr_persiapanop_persetujuanbedah_poti").val(datanurseassesmentoperasi.data.VP_PKPP_OT);
    $("#emr_persiapanop_persetujuanbedahket").val(datanurseassesmentoperasi.data.VP_PKPP_Note);
    $("#emr_persiapanop_persetujuananastesi_pruangan").val(datanurseassesmentoperasi.data.VP_PKPA_PR);
    $("#emr_persiapanop_persetujuananastesi_poti").val(datanurseassesmentoperasi.data.VP_PKPA_OT);
    $("#emr_persiapanop_persetujuananastesiket").val(datanurseassesmentoperasi.data.VP_PKPA_Note);
    $("#emr_persiapanop_pemeriksaaanpenunjang_pruangan").val(datanurseassesmentoperasi.data.VP_PKRM_PR);
    $("#emr_persiapanop_pemeriksaaanpenunjang_poti").val(datanurseassesmentoperasi.data.VP_PKRM_OT);
    $("#emr_persiapanop_pemeriksaaanpenunjangket").val(datanurseassesmentoperasi.data.VP_PKRM_Note);


    $("#emr_persiapanop_pasienpuas_pruangan").val(datanurseassesmentoperasi.data.PFP_Puasa_PR);
    $("#emr_persiapanop_pasienpuas_poti").val(datanurseassesmentoperasi.data.PFP_Puasa_OT);
    $("#emr_persiapanop_pasienpuasket").val(datanurseassesmentoperasi.data.PFP_Puasa_Note);
    $("#emr_persiapanop_protaseluarlepas_pruangan").val(datanurseassesmentoperasi.data.PFP_ProtaseL_PR);
    $("#emr_persiapanop_protaseluarlepas_poti").val(datanurseassesmentoperasi.data.PFP_ProtaseL_OT);
    $("#emr_persiapanop_protaseluarlepasket").val(datanurseassesmentoperasi.data.PFP_ProtaseL_Note);
    $("#emr_persiapanop_protasedalam_pruangan").val(datanurseassesmentoperasi.data.PFP_ProtaseD_PR);
    $("#emr_persiapanop_protasedalam_poti").val(datanurseassesmentoperasi.data.PFP_ProtaseD_OT);
    $("#emr_persiapanop_protasedalamket").val(datanurseassesmentoperasi.data.PFP_ProtaseD_Note);
    $("#emr_persiapanop_perhiasandilepas_pruangan").val(datanurseassesmentoperasi.data.PFP_JLP_PR);
    $("#emr_persiapanop_perhiasandilepas_poti").val(datanurseassesmentoperasi.data.PFP_JLP_OT);
    $("#emr_persiapanop_perhiasandilepasket").val(datanurseassesmentoperasi.data.PFP_JLP_Note);
    $("#emr_persiapanop_persiapankulit_pruangan").val(datanurseassesmentoperasi.data.PFP_MB_PR);
    $("#emr_persiapanop_persiapankulit_poti").val(datanurseassesmentoperasi.data.PFP_MB_OT);
    $("#emr_persiapanop_persiapankulitket").val(datanurseassesmentoperasi.data.PFP_MB_Note);
    $("#emr_persiapanop_klisma_pruangan").val(datanurseassesmentoperasi.data.PFP_Persetujuan_PR);
    $("#emr_persiapanop_klisma_poti").val(datanurseassesmentoperasi.data.PFP_Persetujuan_OT);
    $("#emr_persiapanop_klismaket").val(datanurseassesmentoperasi.data.PFP_Persetujuan_Note);
    $("#emr_persiapanop_persiapandarah_pruangan").val(datanurseassesmentoperasi.data.PFP_PDarah_PR);
    $("#emr_persiapanop_persiapandarah_poti").val(datanurseassesmentoperasi.data.PFP_PDarah_OT);
    $("#emr_persiapanop_persiapandarahket").val(datanurseassesmentoperasi.data.PFP_PDarah_Note);
    $("#emr_persiapanop_alatbantu_pruangan").val(datanurseassesmentoperasi.data.PFP_AB_PR);
    $("#emr_persiapanop_alatbantu_poti").val(datanurseassesmentoperasi.data.PFP_AB_OT);
    $("#emr_persiapanop_alatbantuket").val(datanurseassesmentoperasi.data.PFP_AB_Note);
    $("#emr_persiapanop_obatyangdisertakan_pruangan").val(datanurseassesmentoperasi.data.PFP_Obat_PR);
    $("#emr_persiapanop_obatyangdisertakan_poti").val(datanurseassesmentoperasi.data.PFP_Obat_OT);
    $("#emr_persiapanop_obatyangdisertakanket").val(datanurseassesmentoperasi.data.PFP_Obat_Note);
    $("#emr_persiapanop_obatterakhir_pruangan").val(datanurseassesmentoperasi.data.PFP_ObatTerahir_PR);
    $("#emr_persiapanop_obatterakhir_poti").val(datanurseassesmentoperasi.data.PFP_ObatTerahir_OT);
    $("#emr_persiapanop_obatterakhirket").val(datanurseassesmentoperasi.data.PFP_ObatTerahir_Note);
    $("#emr_persiapanop_cimino_pruangan").val(datanurseassesmentoperasi.data.PFP_Cimino_PR);
    $("#emr_persiapanop_cimino_poti").val(datanurseassesmentoperasi.data.PFP_Cimino_OT);
    $("#emr_persiapanop_ciminoket").val(datanurseassesmentoperasi.data.PFP_Cimino_Note);
    $("#emr_persiapanop_userpruangan").val(datanurseassesmentoperasi.data.PFP_PerawatRuangan);
    $("#emr_persiapanop_jaminputpruangan").val(datanurseassesmentoperasi.data.PFP_PR_Jam);
    $("#emr_persiapanop_jaminputpbedah").val(datanurseassesmentoperasi.data.PFP_OT_Jam);
    $("#emr_persiapanop_userpbedah").val(datanurseassesmentoperasi.data.PFP_PerawatOT);

    $("#emr_persiapanop_sitemarketing").val(datanurseassesmentoperasi.data.PLL_SiteMarking);
    $("#emr_persiapanop_pasiensudahdijelaskan").val(datanurseassesmentoperasi.data.PLL_KegunaanManfaat);
    $("#emr_persiapanop_sholat").val(datanurseassesmentoperasi.data.sudah_sholat);

    //INTRA OPERASI NA
    $("#emr_intraop_timeout").val(datanurseassesmentoperasi.data.PIO_TimeOut);
    $("#emr_intraop_timeoutjam").val(datanurseassesmentoperasi.data.PIO_TOJam);
    $("#emr_intraop_cekkesediaanbarang").val(datanurseassesmentoperasi.data.PIO_CKPF);
    $("#emr_intraop_cekkesediaanbarangjam").val(datanurseassesmentoperasi.data.PIO_CKPFJam);
    $("#emr_intraop_ainstrumen").val(datanurseassesmentoperasi.data.PIO_Instrumen);
    $("#emr_intraop_bprotase").val(datanurseassesmentoperasi.data.PIO_Protase);
    $("#emr_intraop_jammulai").val(datanurseassesmentoperasi.data.PIO_MulaiJam);
    $("#emr_intraop_jamselesai").val(datanurseassesmentoperasi.data.PIO_SelesaiJam);
    $("#emr_intraop_operasidilakukan").val(datanurseassesmentoperasi.data.PIO_Operasi);
    $("#emr_intraop_tipeoperasi").val(datanurseassesmentoperasi.data.PIO_TipeOP);
    $("#emr_intraop_jenisoperasi").val(datanurseassesmentoperasi.data.PIO_JenisAnestesi);
    $("#emr_intraop_statusemosi").val(datanurseassesmentoperasi.data.PIO_Emosi);
    $("#emr_intraop_posisikanul").val(datanurseassesmentoperasi.data.PIO_PosisiKanul);
    $("#emr_intraop_posisilengan").val(datanurseassesmentoperasi.data.PIO_PosisiLengan);
    $("#emr_intraop_posisialatbantudigunakan").val(datanurseassesmentoperasi.data.PIO_PosisiAlatB);
    $("#emr_intraop_memakaikateterurine").val(datanurseassesmentoperasi.data.PIO_Kateter);
    $("#emr_intraop_perskulit").val(datanurseassesmentoperasi.data.PIO_PersiapanKulit);
    $("#emr_intraop_makaidiathermy").val(datanurseassesmentoperasi.data.PIO_Diathermy);

    $("#emr_intraop_lokasielektroda").val(datanurseassesmentoperasi.data.PIO_LElektroda);
    $("#emr_intraop_dipasangoleh").val(datanurseassesmentoperasi.data.PIO_ELDPO);
    $("#emr_intraop_pemeriksakondisisebelum").val(datanurseassesmentoperasi.data.PIO_PKKSBOP);
    $("#emr_intraop_pemeriksakondisisesudah").val(datanurseassesmentoperasi.data.PIO_PKKSTOP);
    $("#emr_intraop_kodeunitelektro").val(datanurseassesmentoperasi.data.PIO_KUE);
    $("#emr_intraop_unitpemanaspendingin").val(datanurseassesmentoperasi.data.PIO_UPP);
    $("#emr_intraop_pengaturan").val(datanurseassesmentoperasi.data.PIO_UPPP);
    $("#emr_intraop_temperatur").val(datanurseassesmentoperasi.data.PIO_UPPTemp);
    $("#emr_intraop_jammulai12").val(datanurseassesmentoperasi.data.PIO_UPPJamM);
    $("#emr_intraop_jamselesai12").val(datanurseassesmentoperasi.data.PIO_UPPJamS);
    $("#emr_intraop_pakaitourniquet").val(datanurseassesmentoperasi.data.PIO_PTorniquet);

    document.getElementById("emr_timeoutop_lengankanan").checked = convertBitToBolean(datanurseassesmentoperasi.data.PIO_PTLKa);
    $("#emr_timeoutop_lengankananjammulai").val(datanurseassesmentoperasi.data.PIO_PTLKaJM);
    $("#emr_timeoutop_lengankananjamselesai").val(datanurseassesmentoperasi.data.PIO_PTLKaJS);
    $("#emr_timeoutop_lengankanantekanan").val(datanurseassesmentoperasi.data.PIO_PTLKaT);
    document.getElementById("emr_timeoutop_lengankiri").checked = convertBitToBolean(datanurseassesmentoperasi.data.PIO_PTLKi);
    $("#emr_timeoutop_lengankirijammulai").val(datanurseassesmentoperasi.data.PIO_PTLKiJM);
    $("#emr_timeoutop_lengankirijamselesai").val(datanurseassesmentoperasi.data.PIO_PTLKiJS);
    $("#emr_timeoutop_lengankiritekanan").val(datanurseassesmentoperasi.data.PIO_PTLKiT);
    document.getElementById("emr_timeoutop_pahakanan").checked = convertBitToBolean(datanurseassesmentoperasi.data.PIO_PTPKa);
    $("#emr_timeoutop_pahakananjammulai").val(datanurseassesmentoperasi.data.PIO_PTPKaJM);
    $("#emr_timeoutop_pahakananjamselesai").val(datanurseassesmentoperasi.data.PIO_PTPKaJS);
    $("#emr_timeoutop_pahakanantekanan").val(datanurseassesmentoperasi.data.PIO_PTPKaT);
    document.getElementById("emr_timeoutop_pahakiri").checked = convertBitToBolean(datanurseassesmentoperasi.data.PIO_PTPKi);
    $("#emr_timeoutop_pahakirijammulai").val(datanurseassesmentoperasi.data.PIO_PTPKiJM);
    $("#emr_timeoutop_pahakirijamselesai").val(datanurseassesmentoperasi.data.PIO_PTPKiJS);
    $("#emr_timeoutop_pahakiritekanan").val(datanurseassesmentoperasi.data.PIO_PTPKiT);
    $("#emr_intraop_diawasioleh").val(datanurseassesmentoperasi.data.PIO_PTorqDiawasiO);
    $("#emr_intraop_pemakaianimplant").val(datanurseassesmentoperasi.data.PIO_PImplant);
    $("#emr_intraop_pendarahan").val(datanurseassesmentoperasi.data.PIO_Perdarahan);
    $("#emr_intraop_pemakaiandrain").val(datanurseassesmentoperasi.data.PIO_PDrain);
    $("#emr_intraop_pemakaiandrainlokasi").val(datanurseassesmentoperasi.data.PIO_LokasiDrain);
    $("#emr_intraop_irigasiluka").val(datanurseassesmentoperasi.data.PIO_IrigasiLuka);
    $("#emr_intraop_pemakaiancairan").val(datanurseassesmentoperasi.data.PIO_PCairan);
    $("#emr_intraop_pemakaiancairanjumlah").val(datanurseassesmentoperasi.data.PIO_JumlahCairan);
    $("#emr_intraop_balutan").val(datanurseassesmentoperasi.data.PIO_Balutan);
    $("#emr_intraop_spesimen").val(datanurseassesmentoperasi.data.PIO_Spesimen);
    $("#emr_intraop_jenisjaringan").val(datanurseassesmentoperasi.data.PIO_JenisJaringan);
    $("#emr_intraop_jenisjaringanjumlah").val(datanurseassesmentoperasi.data.PIO_JmlJaringan);
    $("#emr_intraop_tipefiksasi").val(datanurseassesmentoperasi.data.PIO_TipeFiksasi);
    $("#emr_intraop_keterangan").val(datanurseassesmentoperasi.data.PIO_Keterangan);

    //SIGNIN
    document.getElementById("emr_signinop_identitasgelang").checked = convertBitToBolean(datanurseassesmentoperasi.data.SI_IGP);
    document.getElementById("emr_signinop_informconsent").checked = convertBitToBolean(datanurseassesmentoperasi.data.SI_IC);
    $("#emr_signinop_namaoperator").val(datanurseassesmentoperasi.data.SI_NamaOperator);
    $("#emr_signinop_namatindakan").val(datanurseassesmentoperasi.data.SI_NamaTindakan);
    $("#emr_signinop_lokasitindakan").val(datanurseassesmentoperasi.data.SI_LokasiTindakan);
    $("#emr_signinop_tandadaerahoprasi").val(datanurseassesmentoperasi.data.SI_TDO);

    document.getElementById("emr_signinop_periksakelengkapananastesi").checked = convertBitToBolean(datanurseassesmentoperasi.data.SI_PKAnestesi);
    document.getElementById("emr_signinop_cekmesinanastesi").checked = convertBitToBolean(datanurseassesmentoperasi.data.SI_PMAnestesi);
    document.getElementById("emr_signinop_cekalatinstrumen").checked = convertBitToBolean(datanurseassesmentoperasi.data.SI_PAlatInstrumen);
    document.getElementById("emr_signinop_ceksterilinstrumen").checked = convertBitToBolean(datanurseassesmentoperasi.data.SI_PSterilInstrumen);
    $("#emr_signinop_riwayatasma").val(datanurseassesmentoperasi.data.SI_RAsma);
    $("#emr_signinop_riwayatasmaket").val(datanurseassesmentoperasi.data.SI_KetSignIn);
    $("#emr_signinop_riwayatalergi").val(datanurseassesmentoperasi.data.SI_RAlergi);
    $("#emr_signinop_perawatankhususdiperlukan").val(datanurseassesmentoperasi.data.SI_PerawatanKhusus);
    document.getElementById("emr_signinop_lab").checked = convertBitToBolean(datanurseassesmentoperasi.data.SI_DokLab);
    document.getElementById("emr_signinop_rad").checked = convertBitToBolean(datanurseassesmentoperasi.data.SI_DokRadiologi);
    $("#emr_signinop_resikokurangdarah").val(datanurseassesmentoperasi.data.SI_PDarah);
    $("#emr_signinop_jakarta").val(datanurseassesmentoperasi.data.SI_TglSignin);
    $("#emr_signinop_jam").val(datanurseassesmentoperasi.data.SI_JamSignIn);
    $("#emr_signinop_pranastesi").val(datanurseassesmentoperasi.data.SI_PerawatAnestesi);
    $("#emr_signinop_dranastesi").val(datanurseassesmentoperasi.data.SI_DokterAnestesi);
    $("#emr_signinop_resikokurangdarahket").val(datanurseassesmentoperasi.data.SI_Keterangan);
    $("#emr_signinop_oksimeterberfungsi").val(datanurseassesmentoperasi.data.oksimeter);
    $("#emr_signinop_anggotatimsholat").val(datanurseassesmentoperasi.data.Tim_sholat);


    // TIME OUTm);
    document.getElementById("emr_timeoutop_identifikasipasien").checked = convertBitToBolean(datanurseassesmentoperasi.data.TO_IP);
    document.getElementById("emr_timeoutop_tgltindakan").checked = convertBitToBolean(datanurseassesmentoperasi.data.TO_TglTindakan);
    document.getElementById("emr_timeoutop_lokasitindakan").checked = convertBitToBolean(datanurseassesmentoperasi.data.TO_LO);
    document.getElementById("emr_timeoutop_namatimoperasi").checked = convertBitToBolean(datanurseassesmentoperasi.data.TO_NamaTim);
    document.getElementById("emr_timeoutop_proseduroperasi").checked = convertBitToBolean(datanurseassesmentoperasi.data.TO_PO);


    $("#emr_timeoutop_jakarta").val(datanurseassesmentoperasi.data.TO_TanggalTindakan);
    $("#emr_timeoutop_premedikasi").val(datanurseassesmentoperasi.data.TO_Premedikasi);
    $("#emr_timeoutop_diberikanjam").val(datanurseassesmentoperasi.data.TO_DiberikanJam);
    $("#emr_timeoutop_abtkprofilaks").val(datanurseassesmentoperasi.data.TO_Antibiotik);
    $("#emr_timeoutop_fotoradiologi").val(datanurseassesmentoperasi.data.TO_FotoRadiologi);
    $("#emr_timeoutop_keterangan").val(datanurseassesmentoperasi.data.TO_Keterangan);
    $("#emr_timeoutop_haldiperhatikan").val(datanurseassesmentoperasi.data.TO_Perhatian);
    $("#emr_timeoutop_jam").val(datanurseassesmentoperasi.data.TO_Jam);
    $("#emr_timeoutop_droperator").val(datanurseassesmentoperasi.data.TO_DokterBedah);
    $("#emr_timeoutop_dranastesi").val(datanurseassesmentoperasi.data.TO_drAnestesi);
    $("#emr_timeoutop_prsirkulasi").val(datanurseassesmentoperasi.data.TO_PerawatSirkulasi);
    $("#emr_timeoutop_prinstrumen").val(datanurseassesmentoperasi.data.PerawatInstrumen);
    $("#emr_timeoutop_doabersama").val(datanurseassesmentoperasi.data.mendoakan_pasien);
    $("#emr_timeoutop_pranastesi").val(datanurseassesmentoperasi.data.TO_PerawatAnestesi);
    $("#emr_timeoutop_prasisten").val(datanurseassesmentoperasi.data.TO_PerawatAsisten);
    $("#emr_timeoutop_prsirkuler").val(datanurseassesmentoperasi.data.PerawatSirkuler);


    //SIGN OUT
    document.getElementById("emr_signout_bacatindakansecaraverbal").checked = convertBitToBolean(datanurseassesmentoperasi.data.SO_Membacakan);
    $("#emr_signout_jumlahinstrumenkasajarum").val(datanurseassesmentoperasi.data.SO_JumlahInstrumen);
    $("#emr_signout_prsedurtindakankhusus").val(datanurseassesmentoperasi.data.SO_ProsedurTindakan);
    $("#emr_signout_penangananjaringan").val(datanurseassesmentoperasi.data.SO_PJaringan);
    $("#emr_signout_pasangimplant").val(datanurseassesmentoperasi.data.SO_Implant);
    $("#emr_signout_alatrusakselamatindakan").val(datanurseassesmentoperasi.data.SO_KerusakanAlat);
    $("#emr_signout_alatrusakselamatindakanket").val(datanurseassesmentoperasi.data.SO_JenisInstrument);
    $("#emr_signout_hamdalahdandoa").val(datanurseassesmentoperasi.data.SO_Doa);
    $("#emr_signoutop_jam").val(datanurseassesmentoperasi.data.SO_Jam);
    $("#emr_signoutop_drserkuler").val(datanurseassesmentoperasi.data.SO_drBedah);
    $("#emr_signoutop_drbedah").val(datanurseassesmentoperasi.data.SO_drSerkuler);


    // SERAH TERIMA RR NA
    $("#emr_serahterimarr_tgl").val(datanurseassesmentoperasi.data.Tgl);
    $("#emr_serahterimarr_jenistindakan").val(datanurseassesmentoperasi.data.JenisTindakan);
    $("#emr_serahterimarr_drbedah").val(datanurseassesmentoperasi.data.DokterBedah);
    $("#emr_serahterimarr_dranestiologi").val(datanurseassesmentoperasi.data.DokterAnestesi);
    $("#emr_serahterimarr_drain").val(datanurseassesmentoperasi.data.Drain);
    $("#emr_serahterimarr_jenisdrain").val(datanurseassesmentoperasi.data.JenisDrain);
    $("#emr_serahterimarr_catheter").val(datanurseassesmentoperasi.data.Catheter);
    $("#emr_serahterimarr_catheterno").val(datanurseassesmentoperasi.data.NoCatheter);
    $("#emr_serahterimarr_balon").val(datanurseassesmentoperasi.data.BalonCatheter);
    $("#emr_serahterimarr_balutanluka").val(datanurseassesmentoperasi.data.Bungkusan);
    $("#emr_serahterimarr_jenisbalutanluka").val(datanurseassesmentoperasi.data.JenisBungkusan);
    $("#emr_serahterimarr_patologi").val(datanurseassesmentoperasi.data.Patologi);
    $("#emr_serahterimarr_kultur").val(datanurseassesmentoperasi.data.Kultur);
    $("#emr_serahterimarr_prothesis").val(datanurseassesmentoperasi.data.Prothesis);
    $("#emr_serahterimarr_prothesisjenis").val(datanurseassesmentoperasi.data.JenisProthesis);
    $("#emr_serahterimarr_pendarahan").val(datanurseassesmentoperasi.data.Perdarahan);
    document.getElementById("emr_serahterimarr_checkperhitunganalkes").checked = convertBitToBolean(datanurseassesmentoperasi.data.ICOperasi);
    document.getElementById("emr_serahterimarr_lapoperasi").checked = convertBitToBolean(datanurseassesmentoperasi.data.LaporanOP);
    document.getElementById("emr_serahterimarr_daftarobat").checked = convertBitToBolean(datanurseassesmentoperasi.data.DaftarObat);
    document.getElementById("emr_serahterimarr_inspostoperasi").checked = convertBitToBolean(datanurseassesmentoperasi.data.InstruksiPostOP);
    document.getElementById("emr_serahterimarr_surgicalsafety").checked = convertBitToBolean(datanurseassesmentoperasi.data.CeklistAlkes);
    document.getElementById("emr_serahterimarr_suratijinop").checked = convertBitToBolean(datanurseassesmentoperasi.data.SSC);
    document.getElementById("emr_serahterimarr_formkondisisteril").checked = convertBitToBolean(datanurseassesmentoperasi.data.FKSterilisasi);
    document.getElementById("emr_serahterimarr_radiologi").checked = convertBitToBolean(datanurseassesmentoperasi.data.DokumenRadiologi);
    document.getElementById("emr_serahterimarr_foto").checked = convertBitToBolean(datanurseassesmentoperasi.data.DokumenFoto);
    document.getElementById("emr_serahterimarr_usg").checked = convertBitToBolean(datanurseassesmentoperasi.data.DokumenUSG);
    $("#emr_serahterimarr_kelengkapanodocket").val(datanurseassesmentoperasi.data.Keterangan_PB);
    $("#emr_serahterimarr_jenisanestesi").val(datanurseassesmentoperasi.data.JenisAnestesi);
    $("#emr_serahterimarr_kesadaran").val(datanurseassesmentoperasi.data.Kesadaran);
    $("#emr_serahterimarr_td").val(datanurseassesmentoperasi.data.TD);
    $("#emr_serahterimarr_nadi").val(datanurseassesmentoperasi.data.Nadi);
    $("#emr_serahterimarr_rr").val(datanurseassesmentoperasi.data.RR);
    $("#emr_serahterimarr_saturasioxygen").val(datanurseassesmentoperasi.data.SO2);
    $("#emr_serahterimarr_suhu").val(datanurseassesmentoperasi.data.Suhu);
    $("#emr_serahterimarr_analgetik").val(datanurseassesmentoperasi.data.Analgetik);
    $("#emr_serahterimarr_antibiotik").val(datanurseassesmentoperasi.data.Antibiotik);
    $("#emr_serahterimarr_jamantibiotik").val(datanurseassesmentoperasi.data.Jam);
    $("#emr_serahterimarr_intake").val(datanurseassesmentoperasi.data.Intake);
    $("#emr_serahterimarr_intakeoutput").val(datanurseassesmentoperasi.data.Output);
    document.getElementById("emr_serahterimarr_suratijinanestesi").checked = convertBitToBolean(datanurseassesmentoperasi.data.SI_Anestesi);
    document.getElementById("emr_serahterimarr_prabedah").checked = convertBitToBolean(datanurseassesmentoperasi.data.PraBedah);
    document.getElementById("emr_serahterimarr_cttnanestesi").checked = convertBitToBolean(datanurseassesmentoperasi.data.CatatanAnestesi);
    $("#emr_serahterimarr_kelengkapanformket").val(datanurseassesmentoperasi.data.KetAnestesi);
    $("#emr_serahterimarr_prbedah").val(datanurseassesmentoperasi.data.PerawatBedah);
    $("#emr_serahterimarr_pranestesi").val(datanurseassesmentoperasi.data.PerawatAnastesi);


    //POST OPERASI
    $("#emr_postop_ruangpulihsadar").val(datanurseassesmentoperasi.data.RPulihSadar);
    $("#emr_postop_masukjam").val(datanurseassesmentoperasi.data.JamMasuk);
    $("#emr_postop_keluarjam").val(datanurseassesmentoperasi.data.JamKeluar);
    $("#emr_postop_kembalike").val(datanurseassesmentoperasi.data.KembaliKe);
    $("#emr_postop_keadaanumum").val(datanurseassesmentoperasi.data.KeadaanUmum);
    $("#emr_postop_tingkatkesadaran").val(datanurseassesmentoperasi.data.Kesadaran);
    $("#emr_postop_jlnafaspatentdatang").val(datanurseassesmentoperasi.data.JalanNafasDatang);
    $("#emr_postop_jlnafaspatentkeluar").val(datanurseassesmentoperasi.data.JalanNafasKeluar);
    $("#emr_postop_terapipasien").val(datanurseassesmentoperasi.data.TerapiO2);
    $("#emr_postop_terapipasienjer").val(datanurseassesmentoperasi.data.JenisO2);
    $("#emr_postop_kulitdatar").val(datanurseassesmentoperasi.data.KulitDatang);
    $("#emr_postop_kulitkeluar").val(datanurseassesmentoperasi.data.KulitKeluar);
    $("#emr_postop_posisipasien").val(datanurseassesmentoperasi.data.PosisiPasien);
    $("#emr_postop_keterangan").val(datanurseassesmentoperasi.data.Keterangan);

    document.getElementById("emr_postop_cemas").checked = convertBitToBolean(datanurseassesmentoperasi.data.Cemas);
    document.getElementById("emr_postop_cedera").checked = convertBitToBolean(datanurseassesmentoperasi.data.Cedera);
    document.getElementById("emr_postop_nyeri").checked = convertBitToBolean(datanurseassesmentoperasi.data.Nyeri);
    document.getElementById("emr_postop_infeksi").checked = convertBitToBolean(datanurseassesmentoperasi.data.Infeksi);
    document.getElementById("emr_postop_hipertemi").checked = convertBitToBolean(datanurseassesmentoperasi.data.Hipertermi);
    document.getElementById("emr_postop_hipotermi").checked = convertBitToBolean(datanurseassesmentoperasi.data.Hipotermi);
    document.getElementById("emr_postop_integritaskulit").checked = convertBitToBolean(datanurseassesmentoperasi.data.IntegritasKulit);
    document.getElementById("emr_postop_perawatandiri").checked = convertBitToBolean(datanurseassesmentoperasi.data.PerawatanMandiri);
    document.getElementById("emr_postop_pendampingtenagakhusus").checked = convertBitToBolean(datanurseassesmentoperasi.data.PTK);
    document.getElementById("emr_postop_latihanfisiklanjutan").checked = convertBitToBolean(datanurseassesmentoperasi.data.LFL);
    document.getElementById("emr_postop_pantauanpemberianobat").checked = convertBitToBolean(datanurseassesmentoperasi.data.PPObat);
    document.getElementById("emr_postop_perawatanluka").checked = convertBitToBolean(datanurseassesmentoperasi.data.PerawatanLuka);
    document.getElementById("emr_postop_pemantauandiet").checked = convertBitToBolean(datanurseassesmentoperasi.data.Diet);
    document.getElementById("emr_postop_bantuanaktifitasfisik").checked = convertBitToBolean(datanurseassesmentoperasi.data.BAktifitasFisik);
    document.getElementById("emr_postop_bantuanmedisperawatan").checked = convertBitToBolean(datanurseassesmentoperasi.data.BantuanMedis);

}


// Modal All
async function btnShowModalInputGCS(){
    $('#myModalInputGCS').modal('show');
}
async function btnCloseModalInputGCS(){
    $('#myModalInputGCS').modal('hide');
    clearModalInputGCS();
}
function clearModalInputGCS(){
    $("#emr_id_cppt").val('');
    $("#emr_nodp_masalahkeperawatan").val('');
    $("#emr_cppt_s").val('');
    $("#emr_cppt_o").val('');
    $("#emr_cppt_a").val('');
    $("#emr_cppt_p").val('');
    $("#userentry").val('');
}

// ALl Button Save
async function btnSavePreOperasiNA(){
    try{
        const dataSavePreOperasiNA = await SavePreOperasiNA();
        updateUIdataSavePreOperasiNA(dataSavePreOperasiNA);
    }catch (err) {
        toast(err.message, "error")
    }
}
function SavePreOperasiNA() {
    var base_url = window.location.origin;

    var emr_nama = $("#emr_nama").val();
    var emr_norm = $("#emr_norm").val();
    var emr_noreg = $("#emr_noreg").val();
    var emr_noeps = $("#emr_noeps").val();
    var emr_idorder = $("#emr_idorder").val();
    var form_preop = $("#form_preop").serialize();

    let url = base_url + '/EMR/public/aEMR/setSavePreOperasiNA';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:   'emr_nama=' +  emr_nama +
                '&emr_norm=' + emr_norm +
                '&emr_noreg=' + emr_noreg +
                '&emr_noeps=' + emr_noeps +
                '&emr_idorder=' + emr_idorder +
                '&form_preop=' + form_preop 

            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText)
                }
                return response.json();
            })
            .then(response => {
                if (response.status === "error") {
                    throw new Error(response.message.errorInfo[2]);
                    // console.log("ok " + response.message.errorInfo[2])
                } else if (response.status === "warning") {
                    throw new Error(response.errorname);
                    // console.log("ok " + response.message.errorInfo[2])
                }
                return response
            })
            .finally(() => {
                
            })
}

function updateUIdataSavePreOperasiNA(dataSavePreOperasiNA) {
    let dataSaveOperasi = dataSavePreOperasiNA;
    if (dataSaveOperasi.status == "success") {
        swal("DATA PRE OPERASI",  "BERHASIL DISIMPAN", "success");
        // asyncShowWakilPasien();
        // asyncShowNurseAssOp();
    }else{
        toast(response.message, "error")
    }
}

async function btnSavePersiapanOperasiNA(){
    try{
        const dataSavePersiapanOperasiNA = await SavePersiapanOperasiNA();
        updateUIdataSavePersiapanOperasiNA(dataSavePersiapanOperasiNA);
    }catch (err) {
        toast(err.message, "error")
    }
}
function SavePersiapanOperasiNA() {
    var base_url = window.location.origin;

    var emr_nama = $("#emr_nama").val();
    var emr_norm = $("#emr_norm").val();
    var emr_noreg = $("#emr_noreg").val();
    var emr_noeps = $("#emr_noeps").val();
    var emr_idorder = $("#emr_idorder").val();
    var form_persop = $("#form_persop").serialize();

    let url = base_url + '/EMR/public/aEMR/setSavePersiapanOperasiNA';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:   'emr_nama=' +  emr_nama +
                '&emr_norm=' + emr_norm +
                '&emr_noreg=' + emr_noreg +
                '&emr_noeps=' + emr_noeps +
                '&emr_idorder=' + emr_idorder +
                '&form_persop=' + form_persop 

            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText)
                }
                return response.json();
            })
            .then(response => {
                if (response.status === "error") {
                    throw new Error(response.message.errorInfo[2]);
                    // console.log("ok " + response.message.errorInfo[2])
                } else if (response.status === "warning") {
                    throw new Error(response.errorname);
                    // console.log("ok " + response.message.errorInfo[2])
                }
                return response
            })
            .finally(() => {
                
            })
}

function updateUIdataSavePersiapanOperasiNA(dataSavePersiapanOperasiNA) {
    let dataSaveOperasi = dataSavePersiapanOperasiNA;
    if (dataSaveOperasi.status == "success") {
        swal("DATA PERSIAPAN OPERASI",  "BERHASIL DISIMPAN", "success");
        // asyncShowWakilPasien();
        // asyncShowNurseAssOp();
    }else{
        toast(response.message, "error")
    }
}


async function btnSaveIntraOperasiNA(){
    try{
        const dataSaveIntraOperasiNA = await SaveIntraOperasiNA();
        updateUIdataSaveIntraOperasiNA(dataSaveIntraOperasiNA);
    }catch (err) {
        toast(err.message, "error")
    }
}
function SaveIntraOperasiNA() {
    var base_url = window.location.origin;

    var emr_nama = $("#emr_nama").val();
    var emr_norm = $("#emr_norm").val();
    var emr_noreg = $("#emr_noreg").val();
    var emr_noeps = $("#emr_noeps").val();
    var emr_idorder = $("#emr_idorder").val();
    var form_intra = $("#form_intra").serialize();

    var checkbox_lengankanan=convertBoleanToBit($("#emr_timeoutop_lengankanan").is(":checked"));
    var checkbox_lengankiri=convertBoleanToBit($("#emr_timeoutop_lengankiri").is(":checked"));
    var checkbox_pahakanan=convertBoleanToBit($("#emr_timeoutop_pahakanan").is(":checked"));
    var checkbox_pahakiri=convertBoleanToBit($("#emr_timeoutop_pahakiri").is(":checked"));

    let url = base_url + '/EMR/public/aEMR/setSaveIntraOperasiNA';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:   'emr_nama=' +  emr_nama +
                '&emr_norm=' + emr_norm +
                '&emr_noreg=' + emr_noreg +
                '&emr_noeps=' + emr_noeps +
                '&emr_idorder=' + emr_idorder +
                '&form_intra=' + form_intra +
                '&checkbox_lengankanan=' + checkbox_lengankanan +
                '&checkbox_lengankiri=' + checkbox_lengankiri +
                '&checkbox_pahakanan=' + checkbox_pahakanan +
                '&checkbox_pahakiri=' + checkbox_pahakiri

            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText)
                }
                return response.json();
            })
            .then(response => {
                if (response.status === "error") {
                    throw new Error(response.message.errorInfo[2]);
                    // console.log("ok " + response.message.errorInfo[2])
                } else if (response.status === "warning") {
                    throw new Error(response.errorname);
                    // console.log("ok " + response.message.errorInfo[2])
                }
                return response
            })
            .finally(() => {
                
            })
}

function updateUIdataSaveIntraOperasiNA(dataSaveIntraOperasiNA) {
    let dataSaveOperasi = dataSaveIntraOperasiNA;
    if (dataSaveOperasi.status == "success") {
        swal("DATA INTRA OPERASI",  "BERHASIL DISIMPAN", "success");
        // asyncShowWakilPasien();
        // asyncShowNurseAssOp();
    }else{
        toast(response.message, "error")
    }
}

async function btnSignInOperasiNA(){
    try{
        const dataSaveSignInOperasiNA = await SaveSignInOperasiNA();
        updateUIdataSaveSignInOperasiNA(dataSaveSignInOperasiNA);
    }catch (err) {
        toast(err.message, "error")
    }
}
function SaveSignInOperasiNA() {
    var base_url = window.location.origin;

    var emr_nama = $("#emr_nama").val();
    var emr_norm = $("#emr_norm").val();
    var emr_noreg = $("#emr_noreg").val();
    var emr_noeps = $("#emr_noeps").val();
    var emr_idorder = $("#emr_idorder").val();
    var form_signin = $("#form_signin").serialize();

    var checkbox_emr_signinop_identitasgelang=convertBoleanToBit($("#emr_signinop_identitasgelang").is(":checked"));
    var checkbox_emr_signinop_informconsent=convertBoleanToBit($("#emr_signinop_informconsent").is(":checked"));
    var checkbox_emr_signinop_periksakelengkapananastesi=convertBoleanToBit($("#emr_signinop_periksakelengkapananastesi").is(":checked"));
    var checkbox_emr_signinop_cekmesinanastesi=convertBoleanToBit($("#emr_signinop_cekmesinanastesi").is(":checked"));
    var checkbox_emr_signinop_cekalatinstrumen=convertBoleanToBit($("#emr_signinop_cekalatinstrumen").is(":checked"));
    var checkbox_emr_signinop_ceksterilinstrumen=convertBoleanToBit($("#emr_signinop_ceksterilinstrumen").is(":checked"));
    var checkbox_emr_signinop_lab=convertBoleanToBit($("#emr_signinop_lab").is(":checked"));
    var checkbox_emr_signinop_rad=convertBoleanToBit($("#emr_signinop_rad").is(":checked"));

    let url = base_url + '/EMR/public/aEMR/setSaveSignInOperasiNA';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:   'emr_nama=' +  emr_nama +
                '&emr_norm=' + emr_norm +
                '&emr_noreg=' + emr_noreg +
                '&emr_noeps=' + emr_noeps +
                '&emr_idorder=' + emr_idorder +
                '&checkbox_emr_signinop_identitasgelang=' + checkbox_emr_signinop_identitasgelang +
                '&checkbox_emr_signinop_informconsent=' + checkbox_emr_signinop_informconsent +
                '&checkbox_emr_signinop_periksakelengkapananastesi=' + checkbox_emr_signinop_periksakelengkapananastesi +
                '&checkbox_emr_signinop_cekmesinanastesi=' + checkbox_emr_signinop_cekmesinanastesi +
                '&checkbox_emr_signinop_cekalatinstrumen=' + checkbox_emr_signinop_cekalatinstrumen +
                '&checkbox_emr_signinop_ceksterilinstrumen=' + checkbox_emr_signinop_ceksterilinstrumen +
                '&checkbox_emr_signinop_lab=' + checkbox_emr_signinop_lab +
                '&checkbox_emr_signinop_rad=' + checkbox_emr_signinop_rad +
                '&form_signin=' + form_signin 
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText)
                }
                return response.json();
            })
            .then(response => {
                if (response.status === "error") {
                    throw new Error(response.message.errorInfo[2]);
                    // console.log("ok " + response.message.errorInfo[2])
                } else if (response.status === "warning") {
                    throw new Error(response.errorname);
                    // console.log("ok " + response.message.errorInfo[2])
                }
                return response
            })
            .finally(() => {
                
            })
}

function updateUIdataSaveSignInOperasiNA(dataSaveSignInOperasiNA) {
    let dataSaveOperasi = dataSaveSignInOperasiNA;
    if (dataSaveOperasi.status == "success") {
        swal("DATA SIGN IN OPERASI",  "BERHASIL DISIMPAN", "success");
        // asyncShowWakilPasien();
        // asyncShowNurseAssOp();
    }else{
        toast(response.message, "error")
    }
}

async function btnTimeOutOperasiNA(){
    try{
        const dataSaveTimeOutOperasiNA = await SaveTimeOutOperasiNA();
        updateUIdataSaveTimeOutOperasiNA(dataSaveTimeOutOperasiNA);
    }catch (err) {
        toast(err.message, "error")
    }
}
function SaveTimeOutOperasiNA() {
    var base_url = window.location.origin;

    var emr_nama = $("#emr_nama").val();
    var emr_norm = $("#emr_norm").val();
    var emr_noreg = $("#emr_noreg").val();
    var emr_noeps = $("#emr_noeps").val();
    var emr_idorder = $("#emr_idorder").val();
    var form_timeout = $("#form_timeout").serialize();

    var checkbox_emr_timeoutop_identifikasipasien=convertBoleanToBit($("#emr_timeoutop_identifikasipasien").is(":checked"));
    var checkbox_emr_timeoutop_tgltindakan=convertBoleanToBit($("#emr_timeoutop_tgltindakan").is(":checked"));
    var checkbox_emr_timeoutop_lokasitindakan=convertBoleanToBit($("#emr_timeoutop_lokasitindakan").is(":checked"));
    var checkbox_emr_timeoutop_namatimoperasi=convertBoleanToBit($("#emr_timeoutop_namatimoperasi").is(":checked"));
    var checkbox_emr_timeoutop_proseduroperasi=convertBoleanToBit($("#emr_timeoutop_proseduroperasi").is(":checked"));


    let url = base_url + '/EMR/public/aEMR/setSaveTimeOutOperasiNA';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:   'emr_nama=' +  emr_nama +
                '&emr_norm=' + emr_norm +
                '&emr_noreg=' + emr_noreg +
                '&emr_noeps=' + emr_noeps +
                '&emr_idorder=' + emr_idorder +
                '&checkbox_emr_timeoutop_identifikasipasien=' + checkbox_emr_timeoutop_identifikasipasien +
                '&checkbox_emr_timeoutop_tgltindakan=' + checkbox_emr_timeoutop_tgltindakan +
                '&checkbox_emr_timeoutop_lokasitindakan=' + checkbox_emr_timeoutop_lokasitindakan +
                '&checkbox_emr_timeoutop_namatimoperasi=' + checkbox_emr_timeoutop_namatimoperasi +
                '&checkbox_emr_timeoutop_proseduroperasi=' + checkbox_emr_timeoutop_proseduroperasi +
                '&form_timeout=' + form_timeout 
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText)
                }
                return response.json();
            })
            .then(response => {
                if (response.status === "error") {
                    throw new Error(response.message.errorInfo[2]);
                    // console.log("ok " + response.message.errorInfo[2])
                } else if (response.status === "warning") {
                    throw new Error(response.errorname);
                    // console.log("ok " + response.message.errorInfo[2])
                }
                return response
            })
            .finally(() => {
                
            })
}

function updateUIdataSaveTimeOutOperasiNA(dataSaveTimeOutOperasiNA) {
    let dataSaveOperasi = dataSaveTimeOutOperasiNA;
    if (dataSaveOperasi.status == "success") {
        swal("DATA TIME OUT OPERASI",  "BERHASIL DISIMPAN", "success");
        // asyncShowWakilPasien();
        // asyncShowNurseAssOp();
    }else{
        toast(response.message, "error")
    }
}

async function btnSignOutOperasiNA(){
    try{
        const dataSaveSignOutOperasiNA = await SaveSignOutOperasiNA();
        updateUIdataSaveSignOutOperasiNA(dataSaveSignOutOperasiNA);
    }catch (err) {
        toast(err.message, "error")
    }
}
function SaveSignOutOperasiNA() {
    var base_url = window.location.origin;

    var emr_nama = $("#emr_nama").val();
    var emr_norm = $("#emr_norm").val();
    var emr_noreg = $("#emr_noreg").val();
    var emr_noeps = $("#emr_noeps").val();
    var emr_idorder = $("#emr_idorder").val();
    var form_signout = $("#form_signout").serialize();

    var checkbox_emr_signout_bacatindakansecaraverbal=convertBoleanToBit($("#emr_signout_bacatindakansecaraverbal").is(":checked"));


    let url = base_url + '/EMR/public/aEMR/setSaveSignOutOperasiNA';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:   'emr_nama=' +  emr_nama +
                '&emr_norm=' + emr_norm +
                '&emr_noreg=' + emr_noreg +
                '&emr_noeps=' + emr_noeps +
                '&emr_idorder=' + emr_idorder +
                '&checkbox_emr_signout_bacatindakansecaraverbal=' + checkbox_emr_signout_bacatindakansecaraverbal +
                '&form_signout=' + form_signout 
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText)
                }
                return response.json();
            })
            .then(response => {
                if (response.status === "error") {
                    throw new Error(response.message.errorInfo[2]);
                    // console.log("ok " + response.message.errorInfo[2])
                } else if (response.status === "warning") {
                    throw new Error(response.errorname);
                    // console.log("ok " + response.message.errorInfo[2])
                }
                return response
            })
            .finally(() => {
                
            })
}

function updateUIdataSaveSignOutOperasiNA(dataSaveSignOutOperasiNA) {
    let dataSaveOperasi = dataSaveSignOutOperasiNA;
    if (dataSaveOperasi.status == "success") {
        swal("DATA SIGN OUT OPERASI",  "BERHASIL DISIMPAN", "success");
        // asyncShowWakilPasien();
        // asyncShowNurseAssOp();
    }else{
        toast(response.message, "error")
    }
}


async function btnSerahTerimaOperasiNA(){
    try{
        const dataSaveSerahTerimaOperasiNA = await SaveSerahTerimaOperasiNA();
        updateUIdataSaveSerahTerimaOperasiNA(dataSaveSerahTerimaOperasiNA);
    }catch (err) {
        toast(err.message, "error")
    }
}
function SaveSerahTerimaOperasiNA() {
    var base_url = window.location.origin;

    var emr_nama = $("#emr_nama").val();
    var emr_norm = $("#emr_norm").val();
    var emr_noreg = $("#emr_noreg").val();
    var emr_noeps = $("#emr_noeps").val();
    var emr_idorder = $("#emr_idorder").val();
    var form_serahterimarr = $("#form_serahterimarr").serialize();

    // var checkbox_emr_signout_bacatindakansecaraverbal=convertBoleanToBit($("#emr_signout_bacatindakansecaraverbal").is(":checked"));

    var checkbox_emr_serahterimarr_checkperhitunganalkes = convertBoleanToBit($("#emr_serahterimarr_checkperhitunganalkes").is(":checked"));
    var checkbox_emr_serahterimarr_lapoperasi = convertBoleanToBit($("#emr_serahterimarr_lapoperasi").is(":checked"));
    var checkbox_emr_serahterimarr_daftarobat = convertBoleanToBit($("#emr_serahterimarr_daftarobat").is(":checked"));
    var checkbox_emr_serahterimarr_inspostoperasi = convertBoleanToBit($("#emr_serahterimarr_inspostoperasi").is(":checked"));
    var checkbox_emr_serahterimarr_surgicalsafety = convertBoleanToBit($("#emr_serahterimarr_surgicalsafety").is(":checked"));
    var checkbox_emr_serahterimarr_suratijinop = convertBoleanToBit($("#emr_serahterimarr_suratijinop").is(":checked"));
    var checkbox_emr_serahterimarr_formkondisisteril = convertBoleanToBit($("#emr_serahterimarr_formkondisisteril").is(":checked"));
    var checkbox_emr_serahterimarr_radiologi = convertBoleanToBit($("#emr_serahterimarr_radiologi").is(":checked"));
    var checkbox_emr_serahterimarr_foto = convertBoleanToBit($("#emr_serahterimarr_foto").is(":checked"));
    var checkbox_emr_serahterimarr_usg = convertBoleanToBit($("#emr_serahterimarr_usg").is(":checked"));
    var checkbox_emr_serahterimarr_suratijinanestesi = convertBoleanToBit($("#emr_serahterimarr_suratijinanestesi").is(":checked"));
    var checkbox_emr_serahterimarr_prabedah = convertBoleanToBit($("#emr_serahterimarr_prabedah").is(":checked"));
    var checkbox_emr_serahterimarr_cttnanestesi = convertBoleanToBit($("#emr_serahterimarr_cttnanestesi").is(":checked"));


    let url = base_url + '/EMR/public/aEMR/setSaveSerahTerimasOperasiNA';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:   'emr_nama=' +  emr_nama +
                '&emr_norm=' + emr_norm +
                '&emr_noreg=' + emr_noreg +
                '&emr_noeps=' + emr_noeps +
                '&emr_idorder=' + emr_idorder +
                '&checkbox_emr_serahterimarr_checkperhitunganalkes=' + checkbox_emr_serahterimarr_checkperhitunganalkes +
                '&checkbox_emr_serahterimarr_lapoperasi=' + checkbox_emr_serahterimarr_lapoperasi +
                '&checkbox_emr_serahterimarr_daftarobat=' + checkbox_emr_serahterimarr_daftarobat +
                '&checkbox_emr_serahterimarr_inspostoperasi=' + checkbox_emr_serahterimarr_inspostoperasi +
                '&checkbox_emr_serahterimarr_surgicalsafety=' + checkbox_emr_serahterimarr_surgicalsafety +
                '&checkbox_emr_serahterimarr_suratijinop=' + checkbox_emr_serahterimarr_suratijinop +
                '&checkbox_emr_serahterimarr_formkondisisteril=' + checkbox_emr_serahterimarr_formkondisisteril +
                '&checkbox_emr_serahterimarr_radiologi=' + checkbox_emr_serahterimarr_radiologi +
                '&checkbox_emr_serahterimarr_foto=' + checkbox_emr_serahterimarr_foto +
                '&checkbox_emr_serahterimarr_usg=' + checkbox_emr_serahterimarr_usg +
                '&checkbox_emr_serahterimarr_suratijinanestesi=' + checkbox_emr_serahterimarr_suratijinanestesi +
                '&checkbox_emr_serahterimarr_prabedah=' + checkbox_emr_serahterimarr_prabedah +
                '&checkbox_emr_serahterimarr_cttnanestesi=' + checkbox_emr_serahterimarr_cttnanestesi +
                '&form_serahterimarr=' + form_serahterimarr 
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText)
                }
                return response.json();
            })
            .then(response => {
                if (response.status === "error") {
                    throw new Error(response.message.errorInfo[2]);
                    // console.log("ok " + response.message.errorInfo[2])
                } else if (response.status === "warning") {
                    throw new Error(response.errorname);
                    // console.log("ok " + response.message.errorInfo[2])
                }
                return response
            })
            .finally(() => {
                
            })
}

function updateUIdataSaveSerahTerimaOperasiNA(dataSaveSerahTerimaOperasiNA) {
    let dataSaveOperasi = dataSaveSerahTerimaOperasiNA;
    if (dataSaveOperasi.status == "success") {
        swal("DATA SERAH TERIMA RR OPERASI",  "BERHASIL DISIMPAN", "success");
        // asyncShowWakilPasien();
        // asyncShowNurseAssOp();
    }else{
        toast(response.message, "error")
    }
}


async function btnPostOperasiNA(){
    try{
        const dataSavePostOperasiNA = await SavePostOperasiNA();
        updateUIdataSavePostOperasiNA(dataSavePostOperasiNA);
    }catch (err) {
        toast(err.message, "error")
    }
}
function SavePostOperasiNA() {
    var base_url = window.location.origin;

    var emr_nama = $("#emr_nama").val();
    var emr_norm = $("#emr_norm").val();
    var emr_noreg = $("#emr_noreg").val();
    var emr_noeps = $("#emr_noeps").val();
    var emr_idorder = $("#emr_idorder").val();
    var form_postop = $("#form_postop").serialize();

    var checkbox_emr_postop_cemas=convertBoleanToBit($("#emr_postop_cemas").is(":checked"));
    var checkbox_emr_postop_cedera=convertBoleanToBit($("#emr_postop_cedera").is(":checked"));
    var checkbox_emr_postop_nyeri=convertBoleanToBit($("#emr_postop_nyeri").is(":checked"));
    var checkbox_emr_postop_infeksi=convertBoleanToBit($("#emr_postop_infeksi").is(":checked"));
    var checkbox_emr_postop_hipertemi=convertBoleanToBit($("#emr_postop_hipertemi").is(":checked"));
    var checkbox_emr_postop_hipotermi=convertBoleanToBit($("#emr_postop_hipotermi").is(":checked"));
    var checkbox_emr_postop_integritaskulit=convertBoleanToBit($("#emr_postop_integritaskulit").is(":checked"));

    var checkbox_emr_postop_perawatandiri=convertBoleanToBit($("#emr_postop_perawatandiri").is(":checked"));
    var checkbox_emr_postop_pendampingtenagakhusus=convertBoleanToBit($("#emr_postop_pendampingtenagakhusus").is(":checked"));
    var checkbox_emr_postop_latihanfisiklanjutan=convertBoleanToBit($("#emr_postop_latihanfisiklanjutan").is(":checked"));
    var checkbox_emr_postop_pantauanpemberianobat=convertBoleanToBit($("#emr_postop_pantauanpemberianobat").is(":checked"));
    var checkbox_emr_postop_perawatanluka=convertBoleanToBit($("#emr_postop_perawatanluka").is(":checked"));
    var checkbox_emr_postop_pemantauandiet=convertBoleanToBit($("#emr_postop_pemantauandiet").is(":checked"));
    var checkbox_emr_postop_bantuanaktifitasfisik=convertBoleanToBit($("#emr_postop_bantuanaktifitasfisik").is(":checked"));
    var checkbox_emr_postop_bantuanmedisperawatan=convertBoleanToBit($("#emr_postop_bantuanmedisperawatan").is(":checked"));



    let url = base_url + '/EMR/public/aEMR/setSavePostOperasiNA';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:   'emr_nama=' +  emr_nama +
                '&emr_norm=' + emr_norm +
                '&emr_noreg=' + emr_noreg +
                '&emr_noeps=' + emr_noeps +
                '&emr_idorder=' + emr_idorder +
                '&checkbox_emr_postop_cemas=' + checkbox_emr_postop_cemas +
                '&checkbox_emr_postop_cedera=' + checkbox_emr_postop_cedera +
                '&checkbox_emr_postop_nyeri=' + checkbox_emr_postop_nyeri +
                '&checkbox_emr_postop_infeksi=' + checkbox_emr_postop_infeksi +
                '&checkbox_emr_postop_hipertemi=' + checkbox_emr_postop_hipertemi +
                '&checkbox_emr_postop_hipotermi=' + checkbox_emr_postop_hipotermi +
                '&checkbox_emr_postop_integritaskulit=' + checkbox_emr_postop_integritaskulit +

                '&checkbox_emr_postop_perawatandiri=' + checkbox_emr_postop_perawatandiri +
                '&checkbox_emr_postop_pendampingtenagakhusus=' + checkbox_emr_postop_pendampingtenagakhusus +
                '&checkbox_emr_postop_latihanfisiklanjutan=' + checkbox_emr_postop_latihanfisiklanjutan +
                '&checkbox_emr_postop_pantauanpemberianobat=' + checkbox_emr_postop_pantauanpemberianobat +
                '&checkbox_emr_postop_perawatanluka=' + checkbox_emr_postop_perawatanluka +
                '&checkbox_emr_postop_pemantauandiet=' + checkbox_emr_postop_pemantauandiet +
                '&checkbox_emr_postop_bantuanaktifitasfisik=' + checkbox_emr_postop_bantuanaktifitasfisik +
                '&checkbox_emr_postop_bantuanmedisperawatan=' + checkbox_emr_postop_bantuanmedisperawatan +

                '&form_postop=' + form_postop 
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText)
                }
                return response.json();
            })
            .then(response => {
                if (response.status === "error") {
                    throw new Error(response.message.errorInfo[2]);
                    // console.log("ok " + response.message.errorInfo[2])
                } else if (response.status === "warning") {
                    throw new Error(response.errorname);
                    // console.log("ok " + response.message.errorInfo[2])
                }
                return response
            })
            .finally(() => {
                
            })
}

function updateUIdataSavePostOperasiNA(dataSavePostOperasiNA) {
    let dataSaveOperasi = dataSavePostOperasiNA;
    if (dataSaveOperasi.status == "success") {
        swal("DATA POST OPERASI",  "BERHASIL DISIMPAN", "success");
        // asyncShowWakilPasien();
        // asyncShowNurseAssOp();
    }else{
        toast(response.message, "error")
    }
}


// Assesment Dokter
async function asyncShowDokterAssOp(){
    try{
        const datagetDokterAssOpByNoreg = await getDokterAssOpByNoreg();
        updateUIdatagetDokterAssOpByNoreg(datagetDokterAssOpByNoreg);
    } catch (err) {
        toast(err.message, "error")
    }
}
function getDokterAssOpByNoreg() {
    var base_url = window.location.origin;
    let url = base_url + '/EMR/public/aEMR/getDataDokterAssOperasi';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'NoRegistrasi=' + $("#emr_noreg").val() +
              '&idOrder=' + $("#emr_idorder").val() 
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(response => {
            if (response.status === "error") {
                throw new Error(response.message.errorInfo[2]);
                // console.log("ok " + response.message.errorInfo[2])
            } else if (response.status === "warning") {
                throw new Error(response.errorname);
                // console.log("ok " + response.message.errorInfo[2])
            }
            return response
        })
        .finally(() => {
            
        })
}
function updateUIdatagetDokterAssOpByNoreg(datagetDokterAssOpByNoreg) {
    let datadokterass = datagetDokterAssOpByNoreg;

    $("#emr_prabedah_tmptpengkajian").val(datadokterass.data.LokasiPengkajian);
    $("#emr_prabedah_tmptpengkajianket").val(datadokterass.data.LokasiLain);
    $("#emr_prabedah_skeluhan").val(datadokterass.data.Keluhan);
    $("#emr_prabedah_sriwayatpenyakit").val(datadokterass.data.RPS);
    $("#emr_prabedah_sriwayatoperasi").val(datadokterass.data.RO_Kapan);
    $("#emr_prabedah_spengobatansaatini").val(datadokterass.data.ObatSaatIni);
    $("#emr_prabedah_shamil").val(datadokterass.data.Hamil);
    $("#emr_prabedah_smenstruasi").val(datadokterass.data.SedangHaid);
    $("#emr_prabedah_otd").val(datadokterass.data.TD_Sistole);
    $("#emr_prabedah_otdper").val(datadokterass.data.TD_Diastole);
    $("#emr_prabedah_orr").val(datadokterass.data.RR);
    $("#emr_prabedah_onadi").val(datadokterass.data.Nadi);
    $("#emr_prabedah_osuhu").val(datadokterass.data.Suhu);
    $("#emr_prabedah_ogcs").val(datadokterass.data.GCS);
    $("#emr_prabedah_ogcse").val(datadokterass.data.GCS_E);
    $("#emr_prabedah_ogcsm").val(datadokterass.data.GCS_M);
    $("#emr_prabedah_ogcsv").val(datadokterass.data.GCS_V);
    $("#emr_prabedah_okepala").val(datadokterass.data.Kepala);
    $("#emr_prabedah_omata").val(datadokterass.data.Mata);
    $("#emr_prabedah_otht").val(datadokterass.data.THT);
    $("#emr_prabedah_othorax").val(datadokterass.data.Thorax);
    $("#emr_prabedah_oabdomen").val(datadokterass.data.Abdomen);
    $("#emr_prabedah_ogenetalia").val(datadokterass.data.Genitalia);
    $("#emr_prabedah_okulit").val(datadokterass.data.Kulit);
    $("#emr_prabedah_oextremitas").val(datadokterass.data.Ektremitas);
    $("#emr_prabedah_ostatuslokasi").val(datadokterass.data.StatusLokalis);
    $("#emr_prabedah_olaboratorium").val(datadokterass.data.HasilLab);
    $("#emr_prabedah_oradiologi").val(datadokterass.data.Radiologi);
    $("#emr_prabedah_oekg").val(datadokterass.data.EKG);
    $("#emr_prabedah_olain2").val(datadokterass.data.O_LainLain);
    $("#emr_prabedah_prencanaop").val(datadokterass.data.RencanaOperasi);
    $("#emr_prabedah_pkriteria").val(datadokterass.data.SifatProsedur);
    $("#emr_prabedah_pha").val(datadokterass.data.HariOP);
    $("#emr_prabedah_ptanggal").val(datadokterass.data.TanggalOP);
    $("#emr_prabedah_pperkiraanlamaop").val(datadokterass.data.PLamaTindakan);
    $("#emr_prabedah_panestesia").val(datadokterass.data.Anestesi);
    $("#emr_prabedah_ppuasa").val(datadokterass.data.Puasa);
    $("#emr_prabedah_pmulaijam").val(datadokterass.data.JamMulaiPuasa);
    $("#emr_prabedah_pderetankasus").val(datadokterass.data.PeralatanKhusus);
    $("#emr_prabedah_pderetankasusket").val(datadokterass.data.PeralatanKhusuLain);
    $("#emr_prabedah_ppengosongankandungkemih").val(datadokterass.data.Klisma);
    $("#emr_prabedah_psejakjam").val(datadokterass.data.KlismaSejak);
    $("#emr_prabedah_pobat").val(datadokterass.data.Obat);
    document.getElementById("emr_prabedah_ppersiapandarah").checked = convertBitToBolean(datadokterass.data.PersiapanDarah);
    $("#emr_prabedah_ppersiapandarahket").val(datadokterass.data.KetPersiapanDarah);
    $("#emr_prabedah_ppersiapandarahrencana").val(datadokterass.data.RencanaPostOP);
    $("#emr_prabedah_pcatatan").val(datadokterass.data.Catatan);

}

async function btnPraBedahOperasiDA(){
    try{
        const dataSavePraBedahOperasiDA = await SavePraBedahOperasiDA();
        updateUIdataSavePraBedahOperasiDA(dataSavePraBedahOperasiDA);
    }catch (err) {
        toast(err.message, "error")
    }
}
function SavePraBedahOperasiDA() {
    var base_url = window.location.origin;

    var emr_nama = $("#emr_nama").val();
    var emr_norm = $("#emr_norm").val();
    var emr_noreg = $("#emr_noreg").val();
    var emr_noeps = $("#emr_noeps").val();
    var emr_idorder = $("#emr_idorder").val();
    var form_prabedah = $("#form_prabedah").serialize();
    var checkbox_emr_prabedah_ppersiapandarah=convertBoleanToBit($("#emr_prabedah_ppersiapandarah").is(":checked"));

    let url = base_url + '/EMR/public/aEMR/setSavePraBedahOperasiDA';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:   'emr_nama=' +  emr_nama +
                '&emr_norm=' + emr_norm +
                '&emr_noreg=' + emr_noreg +
                '&emr_noeps=' + emr_noeps +
                '&emr_idorder=' + emr_idorder +
                '&checkbox_emr_prabedah_ppersiapandarah=' + checkbox_emr_prabedah_ppersiapandarah +
                '&form_prabedah=' + form_prabedah 
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText)
                }
                return response.json();
            })
            .then(response => {
                if (response.status === "error") {
                    throw new Error(response.message.errorInfo[2]);
                    // console.log("ok " + response.message.errorInfo[2])
                } else if (response.status === "warning") {
                    throw new Error(response.errorname);
                    // console.log("ok " + response.message.errorInfo[2])
                }
                return response
            })
            .finally(() => {
                
            })
}

function updateUIdataSavePraBedahOperasiDA(dataSavePraBedahOperasiDA) {
    let dataSaveOperasi = dataSavePraBedahOperasiDA;
    if (dataSaveOperasi.status == "success") {
        swal("DATA PRA BEDAH OPERASI",  "BERHASIL DISIMPAN", "success");
        // asyncShowWakilPasien();
        // asyncShowNurseAssOp();
    }else{
        toast(response.message, "error")
    }
}


//ANESTESI SEDASI

async function btnPreAnestesiSedasi(){
    document.getElementById('btnPreAS').className = "btn btn-primary";
    document.getElementById('btnMedikalAS').className = "btn btn-info";
    document.getElementById('btnTTVAS').className = "btn btn-info";
    document.getElementById('btnObsAS').className = "btn btn-info";
    document.getElementById('btnPostAS').className = "btn btn-info";
    document.getElementById('btnRuangAS').className = "btn btn-info";
    document.getElementById('btnTransferAS').className = "btn btn-info";

    document.getElementById('mydiv_preanastesisedasi').style.display = "block";
    document.getElementById('mydiv_medikanastesisedasi').style.display = "none";
    document.getElementById('mydiv_medikanastesisedasi1').style.display = "none";
    document.getElementById('mydiv_medikanastesisedasi2').style.display = "none";
    document.getElementById('mydiv_medikanastesisedasi3').style.display = "none";
    document.getElementById('mydiv_ttvanastesisedasi').style.display = "none";
    document.getElementById('mydiv_grafikobservasianastesisedasi').style.display = "none";
    document.getElementById('mydiv_postanastesisedasi').style.display = "none";
    document.getElementById('mydiv_ruanganastesisedasi').style.display = "none";
    document.getElementById('mydiv_transferanastesisedasi').style.display = "none";
}
async function btnMedikasiAnestesiSedasi(){
    document.getElementById('btnPreAS').className = "btn btn-info";
    document.getElementById('btnMedikalAS').className = "btn btn-primary";
    document.getElementById('btnTTVAS').className = "btn btn-info";
    document.getElementById('btnObsAS').className = "btn btn-info";
    document.getElementById('btnPostAS').className = "btn btn-info";
    document.getElementById('btnRuangAS').className = "btn btn-info";
    document.getElementById('btnTransferAS').className = "btn btn-info";

    document.getElementById('btnMedikalAS1').className = "btn btn-success";
    document.getElementById('btnMedikalAS2').className = "btn btn-warning";
    document.getElementById('btnMedikalAS3').className = "btn btn-warning";

    document.getElementById('mydiv_preanastesisedasi').style.display = "none";
    document.getElementById('mydiv_medikanastesisedasi').style.display = "block";
    document.getElementById('mydiv_medikanastesisedasi1').style.display = "block";
    document.getElementById('mydiv_medikanastesisedasi2').style.display = "none";
    document.getElementById('mydiv_medikanastesisedasi3').style.display = "none";
    document.getElementById('mydiv_ttvanastesisedasi').style.display = "none";
    document.getElementById('mydiv_grafikobservasianastesisedasi').style.display = "none";
    document.getElementById('mydiv_postanastesisedasi').style.display = "none";
    document.getElementById('mydiv_ruanganastesisedasi').style.display = "none";
    document.getElementById('mydiv_transferanastesisedasi').style.display = "none";
}

async function btnMedikasiAnestesiSedasi1(){
    document.getElementById('btnMedikalAS1').className = "btn btn-success";
    document.getElementById('btnMedikalAS2').className = "btn btn-warning";
    document.getElementById('btnMedikalAS3').className = "btn btn-warning";

    document.getElementById('mydiv_medikanastesisedasi1').style.display = "block";
    document.getElementById('mydiv_medikanastesisedasi2').style.display = "none";
    document.getElementById('mydiv_medikanastesisedasi3').style.display = "none";
}

async function btnMedikasiAnestesiSedasi2(){
    document.getElementById('btnMedikalAS1').className = "btn btn-warning";
    document.getElementById('btnMedikalAS2').className = "btn btn-success";
    document.getElementById('btnMedikalAS3').className = "btn btn-warning";

    document.getElementById('mydiv_medikanastesisedasi1').style.display = "none";
    document.getElementById('mydiv_medikanastesisedasi2').style.display = "block";
    document.getElementById('mydiv_medikanastesisedasi3').style.display = "none";
}

async function btnMedikasiAnestesiSedasi3(){
    document.getElementById('btnMedikalAS1').className = "btn btn-warning";
    document.getElementById('btnMedikalAS2').className = "btn btn-warning";
    document.getElementById('btnMedikalAS3').className = "btn btn-success";

    document.getElementById('mydiv_medikanastesisedasi1').style.display = "none";
    document.getElementById('mydiv_medikanastesisedasi2').style.display = "none";
    document.getElementById('mydiv_medikanastesisedasi3').style.display = "block";
}

async function btnTTVAnestesiSedasi(){
    document.getElementById('btnPreAS').className = "btn btn-info";
    document.getElementById('btnMedikalAS').className = "btn btn-info";
    document.getElementById('btnTTVAS').className = "btn btn-primary";
    document.getElementById('btnObsAS').className = "btn btn-info";
    document.getElementById('btnPostAS').className = "btn btn-info";
    document.getElementById('btnRuangAS').className = "btn btn-info";
    document.getElementById('btnTransferAS').className = "btn btn-info";

    document.getElementById('mydiv_preanastesisedasi').style.display = "none";
    document.getElementById('mydiv_medikanastesisedasi').style.display = "none";
    document.getElementById('mydiv_medikanastesisedasi1').style.display = "none";
    document.getElementById('mydiv_medikanastesisedasi2').style.display = "none";
    document.getElementById('mydiv_medikanastesisedasi3').style.display = "none";
    document.getElementById('mydiv_ttvanastesisedasi').style.display = "block";
    document.getElementById('mydiv_grafikobservasianastesisedasi').style.display = "none";
    document.getElementById('mydiv_postanastesisedasi').style.display = "none";
    document.getElementById('mydiv_ruanganastesisedasi').style.display = "none";
    document.getElementById('mydiv_transferanastesisedasi').style.display = "none";

}

async function btnObservasiAnestesiSedasi(){
    document.getElementById('btnPreAS').className = "btn btn-info";
    document.getElementById('btnMedikalAS').className = "btn btn-info";
    document.getElementById('btnTTVAS').className = "btn btn-info";
    document.getElementById('btnObsAS').className = "btn btn-primary";
    document.getElementById('btnPostAS').className = "btn btn-info";
    document.getElementById('btnRuangAS').className = "btn btn-info";
    document.getElementById('btnTransferAS').className = "btn btn-info";

    document.getElementById('mydiv_preanastesisedasi').style.display = "none";
    document.getElementById('mydiv_medikanastesisedasi').style.display = "none";
    document.getElementById('mydiv_medikanastesisedasi1').style.display = "none";
    document.getElementById('mydiv_medikanastesisedasi2').style.display = "none";
    document.getElementById('mydiv_medikanastesisedasi3').style.display = "none";
    document.getElementById('mydiv_ttvanastesisedasi').style.display = "none";
    document.getElementById('mydiv_grafikobservasianastesisedasi').style.display = "block";
    document.getElementById('mydiv_postanastesisedasi').style.display = "none";
    document.getElementById('mydiv_ruanganastesisedasi').style.display = "none";
    document.getElementById('mydiv_transferanastesisedasi').style.display = "none";
}

async function btnPostAnestesiSedasi(){
    document.getElementById('btnPreAS').className = "btn btn-info";
    document.getElementById('btnMedikalAS').className = "btn btn-info";
    document.getElementById('btnTTVAS').className = "btn btn-info";
    document.getElementById('btnObsAS').className = "btn btn-info";
    document.getElementById('btnPostAS').className = "btn btn-primary";
    document.getElementById('btnRuangAS').className = "btn btn-info";
    document.getElementById('btnTransferAS').className = "btn btn-info";

    document.getElementById('mydiv_preanastesisedasi').style.display = "none";
    document.getElementById('mydiv_medikanastesisedasi').style.display = "none";
    document.getElementById('mydiv_medikanastesisedasi1').style.display = "none";
    document.getElementById('mydiv_medikanastesisedasi2').style.display = "none";
    document.getElementById('mydiv_medikanastesisedasi3').style.display = "none";
    document.getElementById('mydiv_ttvanastesisedasi').style.display = "none";
    document.getElementById('mydiv_grafikobservasianastesisedasi').style.display = "none";
    document.getElementById('mydiv_postanastesisedasi').style.display = "block";
    document.getElementById('mydiv_ruanganastesisedasi').style.display = "none";
    document.getElementById('mydiv_transferanastesisedasi').style.display = "none";

}
async function btnRuangAnestesiSedasi(){
    document.getElementById('btnPreAS').className = "btn btn-info";
    document.getElementById('btnMedikalAS').className = "btn btn-info";
    document.getElementById('btnTTVAS').className = "btn btn-info";
    document.getElementById('btnObsAS').className = "btn btn-info";
    document.getElementById('btnPostAS').className = "btn btn-info";
    document.getElementById('btnRuangAS').className = "btn btn-primary";
    document.getElementById('btnTransferAS').className = "btn btn-info";

    document.getElementById('mydiv_preanastesisedasi').style.display = "none";
    document.getElementById('mydiv_medikanastesisedasi').style.display = "none";
    document.getElementById('mydiv_medikanastesisedasi1').style.display = "none";
    document.getElementById('mydiv_medikanastesisedasi2').style.display = "none";
    document.getElementById('mydiv_medikanastesisedasi3').style.display = "none";
    document.getElementById('mydiv_ttvanastesisedasi').style.display = "none";
    document.getElementById('mydiv_grafikobservasianastesisedasi').style.display = "none";
    document.getElementById('mydiv_postanastesisedasi').style.display = "none";
    document.getElementById('mydiv_ruanganastesisedasi').style.display = "block";
    document.getElementById('mydiv_transferanastesisedasi').style.display = "none";
}
async function btnTransferAnestesiSedasi(){
    document.getElementById('btnPreAS').className = "btn btn-info";
    document.getElementById('btnMedikalAS').className = "btn btn-info";
    document.getElementById('btnTTVAS').className = "btn btn-info";
    document.getElementById('btnObsAS').className = "btn btn-info";
    document.getElementById('btnPostAS').className = "btn btn-info";
    document.getElementById('btnRuangAS').className = "btn btn-info";
    document.getElementById('btnTransferAS').className = "btn btn-primary";

    document.getElementById('mydiv_preanastesisedasi').style.display = "none";
    document.getElementById('mydiv_medikanastesisedasi').style.display = "none";
    document.getElementById('mydiv_medikanastesisedasi1').style.display = "none";
    document.getElementById('mydiv_medikanastesisedasi2').style.display = "none";
    document.getElementById('mydiv_medikanastesisedasi3').style.display = "none";
    document.getElementById('mydiv_ttvanastesisedasi').style.display = "none";
    document.getElementById('mydiv_grafikobservasianastesisedasi').style.display = "none";
    document.getElementById('mydiv_postanastesisedasi').style.display = "none";
    document.getElementById('mydiv_ruanganastesisedasi').style.display = "none";
    document.getElementById('mydiv_transferanastesisedasi').style.display = "block";
}


//function other
function convertEntities($data) {
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
}

function convertBoleanToBit($data) {
    var convertboleanbit = $data ? 1 : 0;
    return convertboleanbit;
}

function convertBitToBolean($data) {
    // var convertbitbolean = $data ? true : false;
    // return convertbitbolean;
    var convertbitbolean = $data;
    if(convertbitbolean == "1"){
        convertbitbolean = true;
    }
    else{
        convertbitbolean = false;
    }
    return convertbitbolean;
}

function toast(data, status) {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "3500",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    toastr[status](data);
}
