$(document).ready(function () {  
    $(".preloader").fadeOut();
    $('#btnsimpan').click(function () {
        swal({
            title: "BPJS",
            text: "Apakah Anda ingin Update SEP Tanggal Pulang ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    goUpdateTgl();
                } else {
                    // swal("Transaction Rollback !");
                }
            });

    });
    // ADD_BPJS
    $(document).on('click', '#btnCreateSEP', function () {
        BPJSCreateSEP();
    });
    onLoadFunctionAll();
    $('#cariProvinsi').on('select2:select', function (e) {
        var data = e.params.data;
        console.log("data2", data);
        $("#SuplesiBPJSProvinsi").val(data.id);
        $("#SuplesiBPJSProvinsiName").val(data.text);
        getKabupatenBPJS(data.id);
    });
    $('#cariKabupaten').on('select2:select', function (e) {
        var data = e.params.data;
        console.log("data2", data);
        $("#SuplesiBPJSKabupaten").val(data.id);
        $("#SuplesiBPJSKabupatenName").val(data.text);
        getKecamatanBPJS(data.id);
    });
    $('#cariKecamatan').on('select2:select', function (e) {
        var data = e.params.data;
        console.log("data2", data);
        $("#SuplesiBPJSKecamatan").val(data.id);
        $("#SuplesiBPJSKecamatanName").val(data.text);
    });
});
function GetDataProvinsiBPJS() {
    var iswalkin = "";
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/xBPJSBridging/GoGetProvinsiBPJS';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'iswalkin=' + iswalkin
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
            $(".preloader").fadeOut();
            $("#cariProvinsi").select2();
        })
}
function updateUIgetProvinsiBPJS(dataProvinsiBPJS) {
    let responseApi = dataProvinsiBPJS;
    if (responseApi !== null && responseApi !== undefined) {
        console.log(responseApi);
        $("#cariProvinsi").empty();
        var newRow = '<option value="">-- PILIH --</option';
        $("#cariProvinsi").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].id + '">' + responseApi[i].text + '</option';
            $("#cariProvinsi").append(newRow);

        }
    }
}
async function onLoadFunctionAll() {
    try { 
        const dataProvinsiBPJS = await GetDataProvinsiBPJS();
        console.log("dataProvinsiBPJS", dataProvinsiBPJS) 
        updateUIgetProvinsiBPJS(dataProvinsiBPJS); 
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
}
// ADD_BPJS 
async function BPJSCreateSEP() {
    try {
        $(".preloader").fadeIn();
        const dataGoBPJSCreateSEP = await GoBPJSCreateSEP();
        console.log(dataGoBPJSCreateSEP);
        updateUIdataGoBPJSCreateSEP(dataGoBPJSCreateSEP);
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry.." + err, "error");
    }
}

// ADD_BPJS
function updateUIdataGoBPJSCreateSEP(data) {
    swal('success', 'Sep Berhasil Dirubah , No. Sep ' + data.hasil.sep.noSep + ' !' ,'success')
        .then((value) => {
            location.reload();
        });
}
// ADD_BPJS
function GoBPJSCreateSEP() {
    var form_kepesertaan_Bpjs = $("#form_kepesertaan_Bpjs").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/xBPJSBridging/GoUpdateSEP';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: form_kepesertaan_Bpjs
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
            $(".preloader").fadeOut();
            // document.getElementById("frmKartuRSYarsi").reset();
            //$('#Modal_Karyawn_Polis').modal('hide');
        })
}
async function goUpdateTgl() {
    try {
        $(".preloader").fadeIn();
        const datagoUpdateTglSEPPulang = await goUpdateTglSEPPulang();
        console.log("datagoUpdateTglSEPPulang", datagoUpdateTglSEPPulang)
        updateUIdatagoUpdateTglSEPPulang(datagoUpdateTglSEPPulang);
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry... " + err, "error");
        $(".preloader").fadeOut();
    }
}
function updateUIdatagoUpdateTglSEPPulang(datagoUpdateTglSEPPulang) {
    let data = datagoUpdateTglSEPPulang;
    swal("Success", data.message, "success")
        .then((value) => {
           location.reload();
        });

}
function goUpdateTglSEPPulang() {
    var base_url = window.location.origin;
    var MNoSEPBPJS = document.getElementById("MNoSEPBPJS").value;
    var StatusPulangBPJS = document.getElementById("StatusPulangBPJS").value;
    var MNoSuratMeninggalBPJS = document.getElementById("MNoSuratMeninggalBPJS").value;
    var TglMeninggalBPJS = document.getElementById("TglMeninggalBPJS").value; 
    var MTglPulangBPJS = document.getElementById("MTglPulangBPJS").value;
    var MNoPLManualBPJS = document.getElementById("MNoPLManualBPJS").value; 
    let url = base_url + '/SIKBREC/public/xBPJSBridging/goUpdateTglSEPPulang';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'MNoSEPBPJS=' + MNoSEPBPJS + '&StatusPulangBPJS=' + StatusPulangBPJS + '&MNoSuratMeninggalBPJS=' + MNoSuratMeninggalBPJS
            + '&TglMeninggalBPJS=' + TglMeninggalBPJS + '&MTglPulangBPJS=' + MTglPulangBPJS
            + '&MNoPLManualBPJS=' + MNoPLManualBPJS 
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
            //$("#cariDokterBPJS").select2();
        })
}
function GoMonitoringBPJS() {
    var MTglKunjunganBPJS = $("[name='MTglKunjunganBPJS']").val();
    var MJenisPelayananBPJS =  document.getElementById("MJenisPelayananBPJS").value;
    var base_url = window.location.origin;
    $('#tbl_kunjungan_monitoring').DataTable().clear().destroy();
    $('#tbl_kunjungan_monitoring').DataTable({
        "ordering": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/xBPJSBridging/GoMonitoringPelayananBPJS",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.MTglKunjunganBPJS = MTglKunjunganBPJS;
                d.MJenisPelayananBPJS = MJenisPelayananBPJS;
            }
        },
        "columns": [
            { "data": "noSep" },
            { "data": "noKartu" },
            { "data": "noRujukan" },
            { "data": "tglSep" },
            { "data": "nama" },
            { "data": "jnsPelayanan" },
            { "data": "diagnosa" },
            { "data": "kelasRawat" },
            { "data": "poli" }, 
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.tglPlgSep == null) {
                        var html = ""
                        var html = '<span class="label label-danger" onclick=\'showNoSEP("' + row.noSep +'")\'> UPDATE TANGGAL PULANG</span> ';
                        return html
                    } else {
                        var html = ""
                        var html = '<span class="label label-info">' + row.tglPlgSep + ' </span> ';
                        return html
                    }

                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick=\'ShowDataPasienPoliklinik("' + row.noSep +'")\' ><span class="visible-content" > View</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },
            

        ]
    });
    
} 
function showNoSEP(noSEP){
    $("#modal_UpdateTglPulang").modal('show');
    $("#MNoSEPBPJS").val(noSEP);
}
function ShowDataPasienPoliklinik(str) {
    $("#modal_VerifBPJS").modal('show');
    $("#xSEPNO").val(str);
    GOgetNoSEPDetil(str);
}
function gocreate() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/aRegistrasiRajal/";
}
async function GOgetNoSEPDetil(nosep) {
    try {
        $(".preloader").fadeIn();
        const datagetNoSEPDetilx = await getNoSEPDetil(nosep); 
        updateUIgetNoSEPDetil(datagetNoSEPDetilx);
        const datagetNoSEPDetilxSIMRS = await getNoSEPDetilSIMRS(nosep);
        updateUIgetNoSEPDetilSIMRS(datagetNoSEPDetilxSIMRS);
        console.log("datagetNoSEPDetilxSIMRS", datagetNoSEPDetilxSIMRS);
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry... " + err, "error");
        $(".preloader").fadeOut();
    }
}
function updateUIgetNoSEPDetilSIMRS(data) {
    $("#JenisFaskesKodeBPJS").val(data.KODE_ASAL_FASKES);
    $("#JenisFaskesNamaBPJS").val(data.NAMA_ASAL_FASKES);
    $("#idppkrujukanBPJS").val(data.KODE_PPK_PERUJUK);
    $("#namappkrujukanBPJS").val(data.NAMA_PPK_PERUJUK);
    $("#NoRegistrasiSIMRSBPJS").val(data.NO_REGISTRASI);
    $("#TglRujukan").val(data.TGL_RUJUKAN);
    $("#nonikktpBPJS").val(data.NO_NIK);

    $("#keteranganprbBPJS").val(data.KETERANGAN_PRB);
    $("#cobnosuratBPJS").val(data.COB_NO_ASURANSI);
    $("#cobNamaAsuransiBPJS").val(data.COB);
    $("#idfaskesBPJS").val(data.KODE_PERUJUK);
    $("#namafaskesBPJS").val(data.NAMA_PERUJUK);
    $("#jenisPesertaKodeBPJS").val(data.KODE_JENIS_PESERTA);
    $("#jenisKelaminNamaBPJS").val(data.JENIS_KELAMIN);
    $('#isJenisPelayananBPJS').val(data.KODE_JENIS_RAWAT).trigger('change');

    $('#isNaikKelasBPJS').val(data.NAIK_KELAS).trigger('change');
    if (data.NAIK_KELAS=="0"){
        $('#kdkelasperawatanBPJS').val("").trigger('change');
    }else{
        $('#kdkelasperawatanBPJS').val(data.NAIK_KELAS_ID).trigger('change');
    }
    $('#PembiayaanNiakKelasBPJS').val(data.PENJAMIN).trigger('change');
    $("#PenanggungJawabBiaya").val(data.PENANGGUNG_JAWAB);
    $("#NoHpBPJS").val(data.NO_TELEPON);

    $('#isCobBPJS').val(data.IS_COB).trigger('change');
    $('#iscatarakBPJS').val(data.IS_KATARAK).trigger('change');
    $('#isEksekutifBPJS').val(data.IS_EKSEKUTIF).trigger('change');

    $("#KodeDiagnosaBPJS").val(data.KODE_DIAGNOSA);
    $("#KodePoliklinikBPJS").val(data.KODE_POLI); 

    $('#TujuanKunjunganBPJS').val(data.TUJUAN_KUNJUNGAN).trigger('change');
    $('#FlagProcedureBPJS').val(data.FLAG_PROCEDURE).trigger('change');
    $('#PenujangBPJS').val(data.PENUNJANG).trigger('change');
    $('#AsesmentPelayananBPJS').val(data.ASESMENT_PELAYANAN).trigger('change');
    $('#LakaLantasBPJS').val(data.IS_LAKA_LANTAS).trigger('change');

    $("#iscatatanBPJS").val(data.CATATAN); 

    $("#TglKejadianBPJS").val(data.TGL_LAKA_LANTAS);
    $("#LakaLantasKetBPJS").val(data.KET_LAKA_LANTAS);
    $('#SuplesiBPJS').val(data.IS_SUPLESI).trigger('change');
 
    $("#NoSuplesiBPJS").val(data.NO_SUPLESI);
    $("#SuplesiBPJSProvinsi").val(data.PROV_KODE);
    $("#SuplesiBPJSProvinsiName").val(data.PROV_NAMA);
    $("#SuplesiBPJSKabupaten").val(data.KABUPATEN_KODE);
    $("#SuplesiBPJSKabupatenName").val(data.KABUPATEN_NAMA);
    $("#SuplesiBPJSKecamatan").val(data.KECAMATAN_KODE);
    $("#SuplesiBPJSKecamatanName").val(data.KECAMATAN_NAMA); 

}
function updateUIgetNoSEPDetil(nosep) {
    let data = nosep.hasil;
    $("#norujukan").val(data.noRujukan);
    $("#nokartubpjs").val(data.peserta.noKartu);
    $("#namapesertaBPJS").val(data.peserta.nama);
    // $("#JenisFaskesKodeBPJS").val(data.noSep);
    // $("#JenisFaskesNamaBPJS").val(ddata.noSep);
    // $("#NoRegistrasiSIMRSBPJS").val(data.noSep);
    // $("#idppkrujukanBPJS").val(data.noSep);
    // $("#namappkrujukanBPJS").val(data.noSep);
    // $("#NoSuratKontrolBPJS").val(data.noSep);
    // $("#TglRujukan").val(data.noSep);
    // $("#nonikktpBPJS").val(data.noSep);
    // $("#statuspesertaBPJS").val(data.noSep);
    // $("#keteranganprbBPJS").val(data.noSep);
    $("#idhakKelasBPJS").val(data.klsRawat.klsRawatHak);
    $("#hakKelasBPJS").val(data.peserta.hakKelas);
    // $("#cobnosuratBPJS").val(data.noSep);
    // $("#idfaskesBPJS").val(data.noSep);
    // $("#namafaskesBPJS").val(data.noSep);
    $("#cobNamaAsuransiBPJS").val(data.peserta.asuransi);
    // $("#jenisPesertaKodeBPJS").val(data.noSep);
    $("#jenisPesertaNamaBPJS").val(data.peserta.jnsPeserta);
    $("#jenisKelaminKodeBPJS").val(data.peserta.kelamin);
    // $("#jenisKelaminNamaBPJS").val(data.noSep);
    // $("#isJenisPelayananBPJS").val(data.noSep);
    $("#TglSEP").val(data.tglSep);
    // $("#isNaikKelasBPJS").val(data.noSep);
    // $("#kdkelasperawatanBPJS").val(data.noSep);
    $("#PembiayaanNiakKelasBPJS").val(data.klsRawat.pembiayaan);
    $("#PenanggungJawabBiaya").val(data.klsRawat.penanggungJawab);
    $("#NoMRBPJS").val(data.peserta.noMr);
    // $("#NoHpBPJS").val(data.noSep);
    $("#TglLahirBPJS").val(data.peserta.tglLahir);
    // $("#isCobBPJS").val(data.noSep);
    // $("#iscatarakBPJS").val(data.noSep);
    // $("#isEksekutifBPJS").val(data.noSep);
    // $("#KodeDiagnosaBPJS").val(data.noSep);
    $("#NamaDiagnosaBPJS").val(data.diagnosa);
    // $("#KodePoliklinikBPJS").val(data.noSep);
    $("#NamaPoliklinikBPJS").val(data.poli);
    $("#KodeDokterBPJS").val(data.dpjp.kdDPJP);
    $("#NamaDokterBPJS").val(data.dpjp.nmDPJP);
    // $("#TujuanKunjunganBPJS").val(data.noSep);
    // $("#FlagProcedureBPJS").val(data.noSep);
    // $("#PenujangBPJS").val(data.noSep);
    // $("#AsesmentPelayananBPJS").val(data.noSep);
    // $("#iscatatanBPJS").val(data.noSep);
    $("#TglKejadianBPJS").val(data.lokasiKejadian.tglKejadian);
    $("#LakaLantasKetBPJS").val(data.lokasiKejadian.ketKejadian);
    // $("#SuplesiBPJS").val(data.noSep);
    // $("#NoSuplesiBPJS").val(data.noSep);
    $("#SuplesiBPJSProvinsi").val(data.lokasiKejadian.kdProp);
    // $("#SuplesiBPJSProvinsiName").val(data.noSep);
    $("#SuplesiBPJSKabupaten").val(data.lokasiKejadian.kdKab);
    // $("#SuplesiBPJSKabupatenName").val(data.noSep);
    $("#SuplesiBPJSKecamatan").val(data.lokasiKejadian.kdKec);
    // $("#SuplesiBPJSKecamatanName").val(data.noSep);
}
function getNoSEPDetil(nosep) {
    var base_url = window.location.origin;
    var BPJS_NoSEP = nosep;
    let url = base_url + '/SIKBREC/public/xBPJSBridging/setDataSEP/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'BPJS_NoSEP=' + BPJS_NoSEP
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(response => {
            //console.log(response)
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
            //$("#TipePenjamin").select2();
            //$("#JenisRawat").select2();
            //$("#Paket").select2();
            // $(".preloader").fadeOut(); 
        }).catch((err) => {
            swal("Oops", "Sorry... " + err, "error");
        })
}
function getNoSEPDetilSIMRS(nosep) {
    var base_url = window.location.origin;
    var BPJS_NoSEP = nosep;
    let url = base_url + '/SIKBREC/public/xBPJSBridging/setDataSEPSIMRS/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'BPJS_NoSEP=' + BPJS_NoSEP
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(response => {
            //console.log(response)
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
            //$("#TipePenjamin").select2();
            //$("#JenisRawat").select2();
            //$("#Paket").select2();
            // $(".preloader").fadeOut(); 
        }).catch((err) => {
            swal("Oops", "Sorry... " + err, "error");
        })
}

async function getKabupatenBPJS(id) {
    try {
        const dataGetDataKabupatenBPJS = await GetDataKabupatenBPJS(id);
        console.log("dataGetDataKabupatenBPJS", dataGetDataKabupatenBPJS)
        updateUIGetDataKabupatenBPJS(dataGetDataKabupatenBPJS);
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
}
async function getKecamatanBPJS(id) {
    try {
        const dataGetDataKecamatanBPJS = await GetDataKecamatanBPJS(id);
        console.log("dataGetDataKecamatanBPJS", dataGetDataKecamatanBPJS)
        updateUIGetDataKecamatanBPJS(dataGetDataKecamatanBPJS);
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIGetDataKecamatanBPJS(dataGetDataKecamatanBPJS) {
    let responseApi = dataGetDataKecamatanBPJS;
    if (responseApi !== null && responseApi !== undefined) {
        console.log(responseApi);
        $("#cariKecamatan").empty();
        var newRow = '<option value="">-- PILIH --</option';
        $("#cariKecamatan").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].id + '">' + responseApi[i].text + '</option';
            $("#cariKecamatan").append(newRow);
        }
    }
}
function updateUIGetDataKabupatenBPJS(dataGetDataKabupatenBPJS) {
    let responseApi = dataGetDataKabupatenBPJS;
    if (responseApi !== null && responseApi !== undefined) {
        console.log(responseApi);
        $("#cariKabupaten").empty();
        var newRow = '<option value="">-- PILIH --</option';
        $("#cariKabupaten").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].id + '">' + responseApi[i].text + '</option';
            $("#cariKabupaten").append(newRow);

        }
    }
}
// ADD BPJS
function GetDataKecamatanBPJS(idProv) {
    var SuplesiBPJSKabupaten = idProv;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/xBPJSBridging/GetDataKecamatanBPJS';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'SuplesiBPJSKabupaten=' + SuplesiBPJSKabupaten
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
            $("#cariKecamatan").select2();
        })
}
function GetDataKabupatenBPJS(idProv) {
    var SuplesiBPJSProvinsia = idProv;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/xBPJSBridging/getKabupatenBPJS';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'SuplesiBPJSProvinsi=' + SuplesiBPJSProvinsia
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
            $("#cariKabupaten").select2();
        })
}