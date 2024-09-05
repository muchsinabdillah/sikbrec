$(document).ready(function () {
    // $('#cariPPKRujukanBPJS2').select2();
    asyncShowMain();
    // ADD BPJS
    // ADD BPJS
    $('#cariPPKRujukanBPJS2').on('select2:select', function (e) {
        var data = e.params.data;
        console.log("data2", data);
        $("#idppkrujukanBPJS").val(data.id);
        $("#namappkrujukanBPJS").val(data.text);
    });
    $('#btnRefreshKecamatan').click(function () {
        GoGetDataBpjsKecamatan();
    });
    $("#cariPPKRujukanBPJS2").select2({
        ajax: {
            url: function (params) {
                return window.location.origin + '/SIKBREC/public/xBPJSBridging/GoGetFaskesBPJS';
            },
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term,
                    jenisFaskes: document.getElementById("JenisRujukanFaskesBPJSx").value
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        },

        placeholder: 'Search for a repository',
        minimumInputLength: 3
    });
    $('#logocetakbuktiSEP').click(function () {
        $('#notif_ShowTTD_Digital').modal('show');
        $('#notif_Cetak').modal('hide');
        var pxNoRegistrasi = $("#NoREGRI").val();
        var pxNoSep = $("#NoSEP").val();
        $("#signNoRegistrasi").val(pxNoRegistrasi);
        $("#signNoSep").val(pxNoSep);
        document.getElementById("btncetakSep").disabled = true;
        // var notrs = $("#NoSEP").val();
        // var base_url = window.location.origin;
        // window.open(base_url + "/SIKBREC/public/xBPJSBridging/PrintSEP/" + notrs, "_blank",
        //     "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");

    });
    $('#btncetakSep').click(function () {
        goCountCetak();
    });

    $(document).on('click', '#logocetaklabelpasien', function () {
        var param = $("#NoMR").val();
        PrintLabelPasien(param);
    });

    $(document).on('click', '#logocetakgelanganak', function () {
        var param = $("#NoMR").val();
        PrintGelangAnak(param);
    });
    
    $(document).on('click', '#logocetakgelangdewasa', function () {
        var param = $("#NoMR").val();
        PrintGelangDewasa(param);
    });


    $(document).on('click', '#btnRefreshSign', function () {
        goRefreshDigitalSign();
    });
    $(document).on('click', '#logopasienumum', function () {
        $('#CekkepesertaanBPJS').hide();
        $('#Notif_awal_registrasi').modal('hide');
        var jenisdaftar = "1"; // umum
        $('#PasienJenisDaftar').val(jenisdaftar);
        $('#PasienNoMR').focus();
    }); 
    $(document).on('click', '#logopasienbpjs', function () {
        $('#CekkepesertaanBPJS').show();
        $('#Notif_awal_registrasi').modal('hide');
        //$('#modal_VerifBPJS').modal('show');
        $('#modal_BPJSCekPesertaa').modal('show');
        var jenisdaftar = "2"; // umum
        $('#PasienJenisDaftar').val(jenisdaftar);
        $('#PasienNoMR').focus();
    }); 
    $('#NamaPenjamin').on('change', function() {
        let idpenjamin = $("#NamaPenjamin").val();
        ActiveSEP(idpenjamin);
        loadkartujaminan();
      });

      $('#TipePenjamin').change(function () {
        let typatient = $("#TipePenjamin").val();
        getIDPenjamin(typatient);
    });

    $('#caramasuk').change(function () {
        let caramasuk = $("#caramasuk").val();
        getreferal(caramasuk);
    });

    $('#btnSavePoli').click(function () {
        goCreatePolisAsuransi();
    });

    $('#btnSavePoli2').click(function () {
        goCreatePolisKaryawan();
    });
    $('#btnValidateNIK').click(function () {
        var RSY_Kartu_NoPeserta = $("#RSY_Kartu_NoPeserta").val();
        //console.log(RSY_Kartu_NoPeserta,'s')
        loadNIKKartu(RSY_Kartu_NoPeserta);
    });

    $('#savetrs').click(function () {
        if ($("#NoREGRI").val() == ''){
            swal({
                title: "Simpan",
                text: "Apakah Anda ingin Simpan Registrasi ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                            goCreateRegistrasi();
                    } else {
                       // swal("Transaction Rollback !");
                    }
                });
        }
        else{
            if ($("#Paket").val() == '1'){
                swal("Alasan Edit:", {
                    content: "input",
                    buttons:true,
                  })
                  .then((value) => {
                      if (value == '' ){
                        swal("Alasan Edit Harus Diisi ! Simpan Gagal !");
                        return false;
                      }else if (value == null){
                        return false;
                      }
                   // swal(`You typed: ${value}`);

                //nanti kalo sudah final diaktifin
                // goUpdateRegistrasiPaket(value);

                goUpdateRegistrasi(value);
                  });
            }
            else{
                swal("Alasan Edit:", {
                    content: "input",
                    buttons:true,
                  })
                  .then((value) => {
                      if (value == '' ){
                        swal("Alasan Edit Harus Diisi ! Simpan Gagal !");
                        return false;
                      }else if (value == null){
                        return false;
                      }
                   // swal(`You typed: ${value}`);
                   goUpdateRegistrasi(value);
                  });
            }
        }
    });

    $('#close').click(function () {
        let noregri = $("#NoREGRI").val();
        MyBack(noregri);
      });
    // ADD BPJS 
    $(document).on('click', '#btnCloseVerifikasi', function () {
        MyBack();
    });
    // ADD_BPJS
    $(document).on('click', '#btnCekKepesertaan', function () {
        BPJSCekKepesertaan();
    });
    //add bpjs
    $('#NamaPenjamin').on('select2:select', function (e) {
        var data = e.params.data;
        console.log("data2", data.text);
       // $("#KodeDiagnosaBPJS").val(data.id);
        $("#NamaPenjaminTemp").val(data.text);
    });
    // ADD BPJS
    $("#caridiagnosaBPJS2").select2({
        ajax: {
            url: function (params) {
                return window.location.origin + '/SIKBREC/public/xBPJSBridging/GoGetDaignosaBPJS';
            },
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        },

        placeholder: 'Search for a repository',
        minimumInputLength: 3
    });
    // ADD BPJS
    $("#cariPoliklinikBPJS").select2({
        ajax: {
            url: function (params) {
                return window.location.origin + '/SIKBREC/public/xBPJSBridging/GoGetPoliklinikBPJS'
            },
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        },

        placeholder: 'Search for a repository',
        minimumInputLength: 3
    });
    // ADD BPJS
    $("#cariDokterBPJS").select2({
        ajax: {
            url: function (params) {
                return window.location.origin + '/SIKBREC/public/xBPJSBridging/GoGetDokterBPJS'
            },
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term,
                    IdPoliklinik: $('#KodePoliklinikBPJS').val(),
                    isJenisPelayananBPJS: $('#isJenisPelayananBPJS').val()
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        },

        placeholder: 'Search for a repository',
        minimumInputLength: 3
    });
    //add bpjs
    $('#cariDokterBPJS').on('select2:select', function (e) {
        var data = e.params.data;
        console.log("data2", data);
        $("#KodeDokterBPJS").val(data.id);
        $("#NamaDokterBPJS").val(data.text);
    });
    //add bpjs
    $('#cariPoliklinikBPJS').on('select2:select', function (e) {
        var data = e.params.data;
        console.log("data2", data);
        $("#KodePoliklinikBPJS").val(data.id);
        $("#NamaPoliklinikBPJS").val(data.text);
    });
    //add bpjs
    $('#caridiagnosaBPJS2').on('select2:select', function (e) {
        var data = e.params.data;
        console.log("data2", data);
        $("#KodeDiagnosaBPJS").val(data.id);
        $("#NamaDiagnosaBPJS").val(data.text);
    });
    // ADD_BPJS
    $(document).on('click', '#btnCreateSEP', function () {
        BPJSCreateSEP();
    });

    $('#btnVoidTrsReg').click(function () {
        var namajaminan = document.getElementById("NamaPenjaminTemp").value;
        var grupJaminanid = document.getElementById("TipePenjamin").value;
        if (namajaminan == "BPJS Kesehatan" && grupJaminanid == "5") {
            GoVoidSep();
        } else {
            voidRegistrasi();
        }
        // swal(`You typed: ${value}`);
    });

    $(document).on('click', '#btnprint', function () {
        var noregistrasi = $("#NoREGRI").val();
        if (noregistrasi == "") {
            new PNotify({
                title: 'Notifikasi',
                text: 'No. Registrasi Kosong, Silahkan Masukan No. Registrasi Anda !',
                type: 'danger'
            });
        } else if (noregistrasi != "") {
            $('#notif_Cetak').modal('show');
        }

    });
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
async function goCountCetak() {
    try {
        $(".preloader").fadeIn();
        var notrs = $("#NoSEP").val();
        var noreg = $("#signNoRegistrasi").val();
        var signAlasanCetak = $("#signAlasanCetak").val();
        const dataCountCetak = await CountCetak(notrs, signAlasanCetak, noreg);
        console.log(dataCountCetak);
        updateUiSukseshistory(dataCountCetak, notrs, noreg);
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry.." + err, "error");
    }
}
function updateUiSukseshistory(params, notrs, noreg) {
    if (params.status === 200) {

        var notrs = $("#NoSEP").val();
        var tanpaDigitalSign = document.getElementById("tanpaDigitalSign").value
        if (tanpaDigitalSign == "0") {
            var base_url = window.location.origin;
            var base_url = window.location.origin;
            window.open(base_url + "/SIKBREC/public/xBPJSBridging/PrintSEP/" + notrs + "/" + noreg, "_blank",
                "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
            MyBack();
            MyBack();
        } else {
            var base_url = window.location.origin;
            var base_url = window.location.origin;
            window.open(base_url + "/SIKBREC/public/xBPJSBridging/PrintSEP2/" + notrs + "/" + noreg, "_blank",
                "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
            MyBack(); 
        }

       
       
    }

}
function CountCetak(notrs, signAlasanCetak, noreg) {
    var nomortransaksi = $("#signNoSep").val();
    var jeniscetakan = "SEP";
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/SignatureDigital/CountCetak';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "notrs=" + notrs + "&signAlasanCetak=" + signAlasanCetak + "&jeniscetakan=" + jeniscetakan + "&noreg=" + noreg
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
async function goRefreshDigitalSign() {
    try {
        $(".preloader").fadeIn();
        const dataGoBPJSCreateSEP = await RefreshDigitalSign();
        console.log(dataGoBPJSCreateSEP);
        updateUIRefreshDigitalSign(dataGoBPJSCreateSEP);
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry.." + err, "error");
    }
}

function updateUIRefreshDigitalSign(params) {
    var base_url = window.location.origin;
    if (params === false) {
        document.getElementById("btncetakSep").disabled = true;
        swal("Oops", "Sorry.. Signature Belum Di Buat !!!", "error");
        $("#ImagesDigitalSEP").empty();
        var imgkosng = "images/nosign.png";
        $("#ImagesDigitalSEP").append("<img width='450'  class='img-rounded' height='150' src='" + base_url + '/SIKBREC/public/' + imgkosng + "'>");

    } else {
        document.getElementById("btncetakSep").disabled = false;
        $("#signNama").val(params.NAMA_PARAM_1);
        $("#ImagesDigitalSEP").empty();
        var imgkosng = "images/nosign.png";
        if (params.IMAGE_PATH == null) {
            $("#ImagesDigitalSEP").append("<img width='450'  class='img-rounded' height='150' src='" + base_url + '/SIKBREC/public/' + imgkosng + "'>");
        } else {
            $("#ImagesDigitalSEP").append("<img width='450'  class='img-rounded' height='150' src='" + base_url + '/SIKBREC/public/' + params.IMAGE_PATH + "'>");
        }
    }


}
function RefreshDigitalSign() {
    var nomortransaksi = $("#signNoSep").val();
    var pxNoRegistrasi = $("#signNoRegistrasi").val();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/SignatureDigital/RefreshDigitalSign';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "nomortransaksi=" + nomortransaksi + "&noregistrasi=" + pxNoRegistrasi
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
async function getidnamajaminan() {
    try {
        const dataGetJaminanByIdJaminan = await GetJaminanByIdJaminan();
        updateUIGetJaminanByIdJaminan(dataGetJaminanByIdJaminan); 
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIGetJaminanByIdJaminan(dataGetJaminanByIdJaminan) {
    let data = dataGetJaminanByIdJaminan;
    $("#NamaPenjaminTemp").val(data.NamaPerusahaan);
}
function GetJaminanByIdJaminan() {
    var namajaminanId = document.getElementById("NamaPenjamin").value;
    var grupJaminanId = document.getElementById("TipePenjamin").value;
    $("#namajaminanid").val(namajaminanId);
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataGroupJaminan/GetJaminanByIdJaminan';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'grupJaminanId=' + grupJaminanId + '&namajaminanId=' + namajaminanId
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
            $("#hide_jaminan").hide();
        })
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
    swal('Sep Berhasil Dibuat ' + data.hasil[1].sep.noSep + ' !')
        .then((value) => {
            $('#NoSEP').val(data.hasil[1].sep.noSep);
            $('#pxNoSep').val(data.hasil[1].sep.noSep);
            $('#modal_VerifBPJS').modal('hide');
            $('#notif_Cetak').modal('show');
            $("#pxnoEpisode").val(response.NoEpisode);
            $("#pxNoRegistrasi").val(response.NoRegistrasi);
            $("#pxNoAntrian").val(response.NoAntrianPoli);
            $("#pxNoSep").val(response.NoAntrianPoli);
            $("#cetaknoregis").val(response.NoRegistrasi);
            $("#cetaknoregis2").val(response.NoRegistrasi);
            $("#cetaklabel").val(response.NoMR);
            $('#Notif_awal_registrasi2').modal('hide');
        });
}
// ADD_BPJS
function GoBPJSCreateSEP() {
    var form_kepesertaan_Bpjs = $("#form_kepesertaan_Bpjs_create").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/xBPJSBridging/GoCreateSEP';
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
// ADD_BPJS 
async function BPJSCekKepesertaan() {
    try {
        $(".preloader").fadeIn();
        const dataGoBPJSCekKepesertaan = await GoBPJSCekKepesertaan();
        console.log(dataGoBPJSCekKepesertaan);
        updateUIdataGoBPJSCekKepesertaan(dataGoBPJSCekKepesertaan);
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
}
// ADD_BPJS
function GoBPJSCekKepesertaan() {
    var jenisPencarian = $("#JenisPencarianBPJS").val();
    var kodePeserta = $("#idPesertaBPJS").val();
    var JenisRujukanFaskesBPJSx = $("#JenisRujukanFaskesBPJSx ").val();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/xBPJSBridging/GoBPJSCekKepesertaan';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "jenisPencarian=" + jenisPencarian + "&kodePeserta=" + kodePeserta
            + "&JenisRujukanFaskesBPJSx=" + JenisRujukanFaskesBPJSx
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
            document.getElementById("frmKartuRSYarsi").reset();
            $('#Modal_Karyawn_Polis').modal('hide');
        })
}
// ADD_BPJS
function updateUIdataGoBPJSCekKepesertaan(data) {
    var JenisPencarianBPJS = document.getElementById("JenisPencarianBPJS").value;
    if (JenisPencarianBPJS == "3") {
        $('#JenisFaskesKodeBPJS').val(data.hasil[1].asalFaskes);
        if (data.hasil[1].asalFaskes == "1") {
            $('#JenisFaskesNamaBPJS').val("Faskes 1");
        } else {
            $('#JenisFaskesNamaBPJS').val("Faskes 2");
        }
        // $('#isJenisPelayananBPJS').val(data.Medical_Provinsi).trigger('change');
        //$('#kdkelasperawatanBPJS').val(data.hasil[1].rujukan.peserta.hakKelas.kode).trigger('change');
        $('#nokartubpjs').val(data.hasil[1].rujukan.peserta.noKartu);
        $('#nonikktpBPJS').val(data.hasil[1].rujukan.peserta.nik);
        $('#Kartu_NoPeserta').val(data.hasil[1].rujukan.peserta.noKartu);
        $('#Medrec_NoIdPengenal').val(data.hasil[1].rujukan.peserta.nik);
        $('#namapesertaBPJS').val(data.hasil[1].rujukan.peserta.nama);
        $('#Medrec_NamaPasien').val(data.hasil[1].rujukan.peserta.nama);
        $('#Kartu_NamaPemegangKartu').val(data.hasil[1].rujukan.peserta.nama);
        $('#cobnosuratBPJS').val(data.hasil[1].rujukan.peserta.cob.noAsuransi);
        $('#cobNamaAsuransiBPJS').val(data.hasil[1].rujukan.peserta.cob.nmAsuransi);
        $('#idhakKelasBPJS').val(data.hasil[1].rujukan.peserta.hakKelas.kode);
        $('#hakKelasBPJS').val(data.hasil[1].rujukan.peserta.hakKelas.keterangan);
        $('#keteranganprbBPJS').val(data.hasil[1].rujukan.peserta.informasi.prolanisPRB);
        if (data.hasil[1].rujukan.peserta.statusPeserta.keterangan == "AKTIF") {
            swal("Status Kepesertaan " + data.hasil[1].rujukan.peserta.statusPeserta.keterangan)
                .then((value) => {
                   // $('#modal_BPJSCekPesertaa').modal('hide');
                    document.getElementById("btnCloseVerifikasiz").click();
                });
        } else {
            swal("Status Kepesertaan " + data.hasil[1].rujukan.peserta.statusPeserta.keterangan)
                .then((value) => {
                    swal('Pendaftaran Tidak Bisa DiLanjutkan !');
                });
        }
        $('#idppkrujukanBPJS').val(data.hasil[1].rujukan.provPerujuk.kode);
        $('#namappkrujukanBPJS').val(data.hasil[1].rujukan.provPerujuk.nama);
        $('#statuspesertaBPJS').val(data.hasil[1].rujukan.peserta.statusPeserta.keterangan);

        $('#norujukan').val(data.hasil[1].rujukan.noKunjungan);
        $('#TglRujukan').val(data.hasil[1].rujukan.tglKunjungan);

        $('#KodeDiagnosaBPJS').val(data.hasil[1].rujukan.diagnosa.kode);
        $('#NamaDiagnosaBPJS').val(data.hasil[1].rujukan.diagnosa.nama);
        $('#KodePoliklinikBPJS').val(data.hasil[1].rujukan.poliRujukan.kode);
        $('#NamaPoliklinikBPJS').val(data.hasil[1].rujukan.poliRujukan.nama);
        $('#kdjenispelayananbpjsBPJS').val(data.hasil[1].rujukan.pelayanan.kode);
        $('#nmjenispelayananbpjsBPJS').val(data.hasil[1].rujukan.pelayanan.nama);
        $('#idfaskesBPJS').val(data.hasil[1].rujukan.peserta.provUmum.kdProvider);
        $('#TglLahirBPJS').val(data.hasil[1].rujukan.peserta.tglLahir);
        $('#Medrec_Tgl_Lahir').val(data.hasil[1].rujukan.peserta.tglLahir);
        $('#jenisPesertaKodeBPJS').val(data.hasil[1].rujukan.peserta.jenisPeserta.kode);
        $('#jenisPesertaNamaBPJS').val(data.hasil[1].rujukan.peserta.jenisPeserta.keterangan);
        $('#jenisKelaminKodeBPJS').val(data.hasil[1].rujukan.peserta.sex);
        $('#Medical_JKel').val(data.hasil[1].rujukan.peserta.sex).trigger('change');
        if (data.hasil[1].rujukan.peserta.sex == "P") {
            $('#jenisKelaminNamaBPJS').val("PEREMPUAN");
        } else {
            $('#jenisKelaminNamaBPJS').val("LAKI-LAKI");
        }


        //tambahan
        //$('#TglTATAsuransiBPJS').val(data.hasil[1].rujukan.cob.tglTAT);
        //$('#TglTMTAsuransiBPJS').val(data.hasil[1].rujukan.cob.tglTMT);
        //$('#DinsosBPJS').val(data.hasil[1].rujukan.informasi.dinsos);
        //$('#NoSktmBPJS').val(data.hasil[1].rujukan.informasi.noSKTM);
        //$('#NamaJenisPesertaBPJS').val(data.hasil[1].rujukan.jenisPeserta.keterangan);
        //$('#KodeJenisPesertaBPJS').val(data.hasil[1].rujukan.jenisPeserta.kode);
        //$('#NoMRPesertaBPJS').val(data.hasil[1].rujukan.mr.noMR);
        //$('#NoTelponPesertaBPJS').val(data.hasil[1].rujukan.mr.noTelepon);
        //$('#PisaBPJS').val(data.hasil[1].rujukan.pisa);
        //$('#JenisKelaminBPJS').val(data.hasil[1].rujukan.sex);
        //$('#TanggalLahirBPJS').val(data.hasil[1].rujukan.tglLahir);
        //$('#KodestatuspesertaBPJS').val(data.hasil[1].rujukan.statusPeserta.kode);
    } else {
        $('#JenisFaskesKodeBPJS').val("2");
        $('#JenisFaskesNamaBPJS').val("Faskes 2");
        $('#idppkrujukanBPJS').val("0114R067");
        $('#namappkrujukanBPJS').val("RSU YARSI");
        $('#nokartubpjs').val(data.hasil[1].peserta.noKartu);
        $('#Kartu_NoPeserta').val(data.hasil[1].peserta.noKartu);
        $('#nonikktpBPJS').val(data.hasil[1].peserta.nik);
        $('#Medrec_NoIdPengenal').val(data.hasil[1].peserta.nik);
        $('#namapesertaBPJS').val(data.hasil[1].peserta.nama);
        $('#Kartu_NamaPemegangKartu').val(data.hasil[1].peserta.nama);
        $('#Medrec_NamaPasien').val(data.hasil[1].peserta.nama);
        $('#cobnosuratBPJS').val(data.hasil[1].peserta.cob.noAsuransi);
        $('#cobNamaAsuransiBPJS').val(data.hasil[1].peserta.cob.nmAsuransi);
        $('#idhakKelasBPJS').val(data.hasil[1].peserta.hakKelas.kode);
        $('#hakKelasBPJS').val(data.hasil[1].peserta.hakKelas.keterangan);
        $('#keteranganprbBPJS').val(data.hasil[1].peserta.informasi.prolanisPRB);
        if (data.hasil[1].peserta.statusPeserta.keterangan == "AKTIF") {
            swal("Status Kepesertaan " + data.hasil[1].peserta.statusPeserta.keterangan)
                .then((value) => {
                 //   $('#modal_BPJSCekPesertaa').modal('hide');
                    document.getElementById("btnCloseVerifikasiz").click();
                });
        } else {
            swal("Status Kepesertaan " + data.hasil[1].peserta.statusPeserta.keterangan)
                .then((value) => {
                    swal('Pendaftaran Tidak Bisa DiLanjutkan !');
                });
        }
        $('#idfaskesBPJS').val(data.hasil[1].peserta.provUmum.kdProvider);
        $('#namafaskesBPJS').val(data.hasil[1].peserta.provUmum.nmProvider);
        $('#statuspesertaBPJS').val(data.hasil[1].peserta.statusPeserta.keterangan);
        $('#TglLahirBPJS').val(data.hasil[1].peserta.tglLahir);
        $('#Medrec_Tgl_Lahir').val(data.hasil[1].peserta.tglLahir);
        $('#jenisPesertaKodeBPJS').val(data.hasil[1].peserta.jenisPeserta.kode);
        $('#jenisPesertaNamaBPJS').val(data.hasil[1].peserta.jenisPeserta.keterangan);
        $('#jenisKelaminKodeBPJS').val(data.hasil[1].peserta.sex);
        $('#Medical_JKel').val(data.hasil[1].peserta.sex).trigger('change');
        if (data.hasil[1].peserta.sex == "P") {
            $('#jenisKelaminNamaBPJS').val("PEREMPUAN");
        } else {
            $('#jenisKelaminNamaBPJS').val("LAKI-LAKI");
        }

        //tambahan
        //$('#TglTATAsuransiBPJS').val(data.hasil[1].peserta.cob.tglTAT);
        //$('#TglTMTAsuransiBPJS').val(data.hasil[1].peserta.cob.tglTMT);
        //$('#DinsosBPJS').val(data.hasil[1].peserta.informasi.dinsos);
        //$('#NoSktmBPJS').val(data.hasil[1].peserta.informasi.noSKTM);
        //$('#NamaJenisPesertaBPJS').val(data.hasil[1].peserta.jenisPeserta.keterangan);
        //$('#KodeJenisPesertaBPJS').val(data.hasil[1].peserta.jenisPeserta.kode);
        //$('#NoMRPesertaBPJS').val(data.hasil[1].peserta.mr.noMR);
        //$('#NoTelponPesertaBPJS').val(data.hasil[1].peserta.mr.noTelepon);
        //$('#PisaBPJS').val(data.hasil[1].peserta.pisa);
        //$('#JenisKelaminBPJS').val(data.hasil[1].peserta.sex);
        //$('#TanggalLahirBPJS').val(data.hasil[1].peserta.tglLahir);
        //$('#KodestatuspesertaBPJS').val(data.hasil[1].peserta.statusPeserta.kode);
    }
    //$('#modal_BPJSCekPesertaa').modal('hide');
    document.getElementById("btnCloseVerifikasiz").click();
    //$('#modal_VerifBPJS').modal('show');
}
function showModalJenisReg() {
    var idreg = document.getElementById("NoEpisode").value;
    console.log("idreg", idreg)
    if (idreg != "") {
        $('#Notif_awal_registrasi').modal('hide');
    } else {
        $('#Notif_awal_registrasi').modal('show');
    }

}
function showID(str) {
const base_url = window.location.origin;
var str = btoa(str);
window.location = base_url + '/SIKBREC/public/aRegistrasiRanap/' + str;
}

async function asyncShowMain() {
    try {   
        const datagetGroupJaminan = await getLoadGroupJaminan();
        const datagetNamaPenjamin = await getNamaPenjamin();
        const datagetDokterAllAktif =  await getDokterAllAktif();
        const datagetNamaCaraMasuk = await getNamaCaraMasuk();
        const datagetKelas = await getKelas();
        const datagetDataSPRDetail =  await getDataSPRDetail();
        updateUIgetLoadGroupJaminan(datagetGroupJaminan);
        updateUIgetNamaPenjamin(datagetNamaPenjamin);
        updateUIgetDokterAllAktif(datagetDokterAllAktif);
        updateUIgetNamaCaraMasuk(datagetNamaCaraMasuk);
        updateUIgetKelas(datagetKelas);
        updateUIgetDataSPRDetail(datagetDataSPRDetail);
        await showModalJenisReg();
        getCOB();
    } catch (err) {
        toast(err, "error")
    }
}

async function updateUIgetDataSPRDetail(datagetDataSPRDetail) {
let dataResponse = datagetDataSPRDetail;
$("#IdAuto").val(convertEntities(dataResponse.data.ID));
$("#NoMR").val(convertEntities(dataResponse.data.NoMR));
$("#NamaPasien").val(convertEntities(dataResponse.data.PatientName));
$("#JenisRawat").val(convertEntities(dataResponse.data.JenisRawat)).trigger('change');
$("#NamaDokter").val(convertEntities(dataResponse.data.ID_Dokter)).trigger('change');
$("#NikPasien").val(convertEntities(dataResponse.data.ID_Card_number));
$("#AlamatPasien").val(convertEntities(dataResponse.data.Address));
$("#NoEpisode").val(convertEntities(dataResponse.data.NoEpisode));
$("#NoREGRI").val(convertEntities(dataResponse.data.NoRegRI));
$("#pxNoteRegistrasi").val(convertEntities(dataResponse.data.Note));
$("#DOB").val(convertEntities(dataResponse.data.DOB));
$("#NoRegistrasi").val(convertEntities(dataResponse.data.NoRegistrasi));
$("#NoEpisodeRWJ").val(convertEntities(dataResponse.data.noepisode_rwj));
    if(dataResponse.data.NoRegRI != null)// if not null then update reg
    {
        $("#TipePenjamin").val(convertEntities(dataResponse.data.TypePatient)).trigger('change');
        $("#caramasuk").val(convertEntities(dataResponse.data.idCaraMasuk)).trigger('change');
        await getIDPenjamin(convertEntities(dataResponse.data.TypePatient));
        await getreferal(convertEntities(dataResponse.data.idCaraMasuk));
        $("#NamaPenjamin").val(convertEntities(dataResponse.data.idperusahaan));
        $("#referral").val(convertEntities(dataResponse.data.idCaraMasuk2));
        $("#Paket").val(convertEntities(dataResponse.data.Paket)).trigger('change');
        $("#Kelas").val(convertEntities(dataResponse.data.KlsID)).trigger('change');
        $("#COB").val(convertEntities(dataResponse.data.KodeJaminanCOB)).trigger('change');
        $("#NoSEP").val(convertEntities(dataResponse.data.NoSEP));
        ActiveSEP(dataResponse.data.idperusahaan);
    }
    if (dataResponse.data.Kategori == 'BBL'){
        $("#NamaDokter").val(convertEntities(dataResponse.data.ID_DPJP)).trigger('change');
        $("#IdAuto").val(convertEntities(dataResponse.data.ID_PermintaanBayi));
        $("#JenisRawat").val(convertEntities(dataResponse.data.Ruang_Rawat_Tujuan_Bayi)).trigger('change');

    }

    $("#NamaPenjamin").select2();
    $("#referral").select2();
    $(".preloader").fadeOut();
    getidnamajaminan();
}
function getDataSPRDetail() {
var base_url = window.location.origin;
var noregri = $("#NoREGRI").val();
var id = $("#IdAuto").val();
var NoMR = $("#NoMR").val();
let url = base_url + '/SIKBREC/public/aRegistrasiRanap/getDataSPRDetail/';
return fetch(url, {
    method: 'POST',
    headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    },
    body: 'id=' + id + '&noregri=' + noregri + '&NoMR=' + NoMR
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
        $("#TipePenjamin").select2();
        $("#JenisRawat").select2();
        $("#Paket").select2();
       // $(".preloader").fadeOut(); 
    }).catch((err) =>{
        console.log(err, "error")
    })
}

function updateUIgetLoadGroupJaminan(datagetGroupJaminan) {
let responseApi = datagetGroupJaminan;
if (responseApi.data !== null && responseApi.data !== undefined) {
    //console.log(responseApi.data);
    var newRow = '<option value="">-- PILIH --</option';
    $("#TipePenjamin").append(newRow);
    for (i = 0; i < responseApi.data.length; i++) {
        var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].TipePasien + '</option';
        $("#TipePenjamin").append(newRow);
    }
}
}

function getLoadGroupJaminan() {
var getidPoliKlinik = "1";
var base_url = window.location.origin;
let url = base_url + '/SIKBREC/public/MasterDataGroupJaminan/getAllGroupJaminan';
return fetch(url, {
    method: 'POST',
    headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    },
    body: 'id=' + getidPoliKlinik
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
        $("#TipePenjamin").select2();
    })
}

async function getIDPenjamin(x) {
try {
    const datagetNamaPenjamin = await getNamaPenjamin(x);
    updateUIgetNamaPenjamin(datagetNamaPenjamin);
    /*
    if ($("#NoREGRI").val() != ''){
        $("#NamaPenjamin").val(convertEntities(x));
        ActiveSEP(x);
    }
    */
} catch (err) {
    toast(err, "error")
}
}

async function getreferal(x) {
try{
    const dataGetRefferalByIdGroup = await GetRefferalByIdGroup(x);
    //console.log("dataGetRefferalByIdGroup", dataGetRefferalByIdGroup);
    updateUIGetRefferalByIdGroup(dataGetRefferalByIdGroup);
    
} catch (err) {
    toast(err, "error")
}
}

function updateUIgetNamaPenjamin(datagetNamaPenjamin) {
let responseApi = datagetNamaPenjamin; 
if (responseApi.data !== null && responseApi.data !== undefined) {
    //console.log(responseApi.data);
    $("#NamaPenjamin").empty();
    var newRow = '<option value="">-- PILIH --</option';
    $("#NamaPenjamin").append(newRow);
    for (i = 0; i < responseApi.data.length; i++) {
        var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].NamaPerusahaan + '</option';
        $("#NamaPenjamin").append(newRow);
    }
}
}

function getNamaPenjamin(x) {
var base_url = window.location.origin;
let url = base_url + '/SIKBREC/public/bInformationRekapMCU/getNamaPenjamin';
return fetch(url, {
    method: 'POST',
    headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    },
    body: 'tp_penjamin=' + x//$("#TipePenjamin").val()
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
        //$("#NamaPenjamin").select2();
    })
}


function updateUIgetDokterAllAktif(datagetDokterAllAktif) {
let data = datagetDokterAllAktif;
if (data !== null && data !== undefined) {
    $("#NamaDokter").empty();
    var newRow = '<option value="">-- PILIH --</option';
    $("#NamaDokter").append(newRow);
    for (i = 0; i < data.data.length; i++) {
        var newRow = '<option value="' + data.data[i].ID + '">' + data.data[i].First_Name + '</option';
        $("#NamaDokter").append(newRow);
    }
}
}

function getDokterAllAktif() {
var base_url = window.location.origin;
let url = base_url + '/SIKBREC/public/bInformationRekamMedik/getIDDokter';
return fetch(url, {
    method: 'POST',
    headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    }
    //body: 'idpoli=' + $("#GrupPerawatan").val()
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
        $("#NamaDokter").select2();
    })
}

function updateUIgetNamaCaraMasuk(datagetNamaCaraMasuk) {
let responseApi = datagetNamaCaraMasuk;
if (responseApi.data !== null && responseApi.data !== undefined) {
    //console.log(responseApi.data);
    var newRow = '<option value="">-- PILIH --</option';
    $("#caramasuk").append(newRow);
    for (i = 0; i < responseApi.data.length; i++) {
        var newRow = '<option value="' + responseApi.data[i].id + '">' + responseApi.data[i].NamaCaraMasuk + '</option';
        $("#caramasuk").append(newRow);
    }
}
}
function getNamaCaraMasuk() {
var base_url = window.location.origin;
let url = base_url + '/SIKBREC/public/MasterDataReferal/getNamaCaraMasuk';
return fetch(url, {
    method: 'POST',
    headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    },
    //body: 'id=' + $("#IdAuto").val()
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
        $("#caramasuk").select2(); 
    })
}

function updateUIGetRefferalByIdGroup(dataGetRefferalByIdGroup) {
let responseApi = dataGetRefferalByIdGroup;
if (responseApi.data !== null && responseApi.data !== undefined) {
    //console.log(responseApi.data);
    $("#referral").empty();
    var newRow = '<option value="">-- PILIH --</option';
    $("#referral").append(newRow);
    for (i = 0; i < responseApi.data.length; i++) {
        var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].NamaCaraMasukRef + '</option';
        $("#referral").append(newRow);
    }
    //$("#referral").val(convertEntities('3')).trigger('change');
    
}

}
function GetRefferalByIdGroup(xdi) {
//var xdi = document.getElementById("caramasuk").value;
var base_url = window.location.origin;
let url = base_url + '/SIKBREC/public/MasterDataReferal/GetRefferalByIdGroup';
return fetch(url, {
    method: 'POST',
    headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    },
    body: 'idGroupRefferal=' + xdi
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
        //$("#referral").select2();
    })
}

function updateUIgetKelas(datagetKelas) {
let responseApi = datagetKelas;
if (responseApi.data !== null && responseApi.data !== undefined) {
    //console.log(responseApi.data);
    var newRow = '<option value="">-- PILIH --</option';
    $("#Kelas").append(newRow);
    for (i = 0; i < responseApi.data.length; i++) {
        var newRow = '<option value="' + responseApi.data[i].IDKelas + '">' + responseApi.data[i].NamaKelas + '</option';
        $("#Kelas").append(newRow);
    }
}
}
function getKelas() {
var base_url = window.location.origin;
let url = base_url + '/SIKBREC/public/MasterDataBed/getClass';
return fetch(url, {
    method: 'POST',
    headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    },
    //body: 'id=' + $("#IdAuto").val()
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
        $("#Kelas").select2(); 
    })
}

function ActiveSEP(idpenjamin) {
//let idpenjamin = $("#NamaPenjamin").val();
let typepatient = $("#TipePenjamin").val();
if (idpenjamin == '313' && typepatient == '5'){
    $("#NoSEP").attr('readonly', false);
}else{
    $("#NoSEP").attr('readonly', true);
}
}

async function loadkartujaminan(){
    try {
        var noMR = $("[name='NoMR']").val();
        var NamaPasien = $("[name='NamaPasien']").val();
        var GroupJaminan = document.getElementById("TipePenjamin").value;
        var NamaJaminan = document.getElementById("NamaPenjamin").value;
        var NoREGRI = document.getElementById("NoREGRI").value;
        $("#Kartu_GroupJaminan").val(GroupJaminan);
        $("#kartu_NoRM").val(noMR);
        $("#Kartu_NamaJaminan").val(NamaJaminan);
        $("#Kartu_NamaPasien").val(NamaPasien);
        $("#Kartu_NamaPemegangKartu").val(NamaPasien);
        //if (NoREGRI == ''){
        const datagetLoadKartuPasien = await getLoadKartuPasien(noMR,GroupJaminan,NamaJaminan);
        console.log(noMR,NamaPasien,GroupJaminan,NamaJaminan,'axx');
        updateUIgetLoadKartuPasien(datagetLoadKartuPasien);
        //}
    } catch (err) {
        toast(err, "error")
    }
}

function getLoadKartuPasien(noMR,GroupJaminan,NamaJaminan){
var base_url = window.location.origin;
//var noMR = $("[name='PasienNoMR']").val();
// var NamaPasien = $("[name='PasienNama']").val();
//var GroupJaminan = document.getElementById("grupJaminan").value;
//var NamaJaminan = document.getElementById("namajaminan").value;
//$("#Kartu_GroupJaminan").val(GroupJaminan);
//$("#kartu_NoRM").val(noMR);
//$("#Kartu_NamaJaminan").val(NamaJaminan);
//$("#Kartu_NamaPasien").val(NamaPasien);
// $("#Kartu_NamaPemegangKartu").val(NamaPasien);
   // console.log('xxxx',noMR,GroupJaminan,NamaJaminan)

let url = base_url + '/SIKBREC/public/MasterDataGroupJaminan/getPolis';
return fetch(url, {
    method: 'POST',
    headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    },
    body: "noMR=" + noMR + "&GroupJaminan=" + GroupJaminan + "&NamaJaminan=" + NamaJaminan
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
             //console.log("ok " + response.message.errorInfo[2])
        } else if (response.status === "warning") {
            throw new Error(response.errorname);
             //console.log("ok " + response.message.errorInfo[2])
        }
        return response
    })
    .finally(() => {
        //console.log('sukesess');
         
    })
}

function updateUIgetLoadKartuPasien(datagetLoadKartuPasien) {
let responseApi = datagetLoadKartuPasien;
console.log(responseApi,'lalala');
var noMR = $("[name='NoMR']").val();
var NamaPasien = $("[name='NamaPasien']").val();
var GroupJaminan = document.getElementById("TipePenjamin").value;
var NamaJaminan = document.getElementById("NamaPenjamin").value;
if (NamaJaminan === '274') {
    //$("#nosep").hide();
    $('#Modal_Karyawn_Polis').modal('show');
    
    $("#RSY_Kartu_NamaJaminan").val(NamaJaminan);
    $("#RSY_Kartu_GroupJaminan").val(GroupJaminan);
    $("#RSY_kartu_NoRM").val(noMR);
    $("#RSY_Kartu_NamaPasien").val(NamaPasien);
    $("#RSY_Kartu_NoPeserta").val(responseApi.NoKartu);
    $("#RSY_Kartu_NamaPemegangKartu").val(responseApi.NamaPemegangKartu);
    $("#Kartu_ID2").val(responseApi.ID);
    $("#RSY_Kartu_StatusPeserta").val(responseApi.StatusPasien);
    loadNIKKartu(responseApi.NoKartu);
}else{
    //$("#nosep").hide();
    $('#Notif_awal_registrasi2').modal('show');
    //  $("#Kartu_GroupJaminan").val(data.KodeGroupJaminan);
    $("#Kartu_NamagroupJaminan").val(responseApi.TipePasien);
    //$("#Kartu_NamaJaminan").val(responseApi.KodeJaminan);
    $("#Kartu_NamaJaminanx").val(responseApi.NamaPerusahaan);
    $("#Kartu_NoPeserta").val(responseApi.NoKartu);
    $("#Kartu_NamaPemegangKartu").val(responseApi.NamaPemegangKartu);
    $("#Kartu_Keterangan").val(responseApi.Keterangan);
    $("#Kartu_ID").val(responseApi.ID);
    $("#Kartu_HakKelas").val(responseApi.HakKelas);
    $("#Kartu_StatusPeserta").val(responseApi.StatusPasien);
}
 
}

async function loadNIKKartu (params) {
try {
    const dataGetPolisKaryawan = await GetPolisKaryawan(params);
   // console.log("dataGetPolisKaryawan",dataGetPolisKaryawan);
    updateUIGetPolisKaryawan(dataGetPolisKaryawan);
} catch (err) {
    toast(err, "error")
}
}

function updateUIGetPolisKaryawan(data) {
if (data.Nama == null || data.Nama == ''){
    toast("NIK Invalid, Silahkan Validasi NIK Karyawan !","error");
    $("#RSY_Kartu_NamaPemegangKartu").val('');
    $("#RSY_Kartu_HakKelas").val('');
    $("#RSY_Kartu_PlafonRJ").val('');
    $("#RSY_PlafonRI").val('');
    $("#RSY_stsPeg").val('');
}else{
    $("#RSY_Kartu_NamaPemegangKartu").val(data.Nama);
    $("#RSY_Kartu_HakKelas").val(data.HakKelasPlafonRS);
    $("#RSY_Kartu_PlafonRJ").val(data.Plafon_RJ);
    $("#RSY_PlafonRI").val(data.Plafon_RI);
    $("#RSY_stsPeg").val(data.Status_Aktif);
}
}
function GetPolisKaryawan(params) {
var base_url = window.location.origin;
console.log(params,'params');
let url = base_url + '/SIKBREC/public/MasterDataGroupJaminan/GetPolisKaryawan';
return fetch(url, {
    method: 'POST',
    headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    },
    body: "params=" + params
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

async function goCreatePolisAsuransi() {
try{
    const dataCreatePolisAsuransi = await createPolisAsuransi();
    updateUIcreatePolisAsuransi(dataCreatePolisAsuransi);
} catch (err) {
    toast(err, "error")
}
}

function updateUIcreatePolisAsuransi(dataCreatePolisAsuransi) {
let data = dataCreatePolisAsuransi;
if (data.status == "warning") {
    toast(data.pesan,"error");
} else if (data.status == "success") {
    toast(data.pesan, "success");
    document.getElementById("FrmDataPolisKartu").reset();
    $('#Notif_awal_registrasi2').modal('hide');
}
}
function createPolisAsuransi() {
var str = $("#FrmDataPolisKartu").serialize();
var base_url = window.location.origin;
let url = base_url + '/SIKBREC/public/aMedicalRecord/createPolisAsuransi';
return fetch(url, {
    method: 'POST',
    headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    },
    body: str
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
        //$('#btnreservasi').removeClass('btn-danger');
        //$('#btnreservasi').html('Submit');
        //document.getElementById("btnreservasi").disabled = false;
    })
}

async function goCreatePolisKaryawan() {
try {
    await createPolisKaryawan(); 
} catch (err) {
    toast(err, "error")
}
}
function createPolisKaryawan() {
var str = $("#frmKartuRSYarsi").serialize();
var base_url = window.location.origin;
let url = base_url + '/SIKBREC/public/aMedicalRecord/createPolisKaryawan';
return fetch(url, {
    method: 'POST',
    headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    },
    body: str
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
        document.getElementById("frmKartuRSYarsi").reset();
        $('#Modal_Karyawn_Polis').modal('hide');
    })
}

async function goCreateRegistrasi() {
    try {
        const dataCreateRegistrasi = await CreateRegistrasi();
        updateUIdataCreateRegistrasi(dataCreateRegistrasi);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdataCreateRegistrasi(params) {
    let response = params;
    if (response.status == "success") { 
        $("#NoEpisode").val(response.noepisode);
        $("#NoREGRI").val(response.nofinalreg);
        $("#NoRegistrasiSIMRSBPJS").val(response.nofinalreg);
        $("#nonikktpBPJS").val(response.nikpasien);
        //$("#NoSEP").val(response.NoSEP);
        swal({
            title: "Save Success!",
            text: response.message,
            icon: "success",
        }).then(function() {
            // getDataListPasienOperasibyNoReg($("#NoRegistrasi").val());
            // $("#modal_caripasien").modal('show');
            var shownamaperusahaanfix = document.getElementById("NamaPenjaminTemp").value;
            var grupJaminanid = document.getElementById("TipePenjamin").value;
            var PasienNoMR = document.getElementById("NoMR").value;
            $("#NoMRBPJS").val(PasienNoMR);
            console.log(shownamaperusahaanfix);
            console.log(grupJaminanid);
            if (shownamaperusahaanfix == "BPJS Kesehatan" && grupJaminanid == "5") {
                $('#modal_VerifBPJS').modal('show');
            } else {
                $('#notif_Cetak').modal('show');
                $("#pxnoEpisode").val(response.NoEpisode);
                $("#pxNoRegistrasi").val(response.NoRegistrasi);
                $("#pxNoAntrian").val(response.NoAntrianPoli);
                $("#pxNoSep").val(response.NoAntrianPoli);
                $("#cetaknoregis").val(response.NoRegistrasi);
                $("#cetaknoregis2").val(response.NoRegistrasi);
                $("#cetaklabel").val(response.NoMR);
                $('#Notif_awal_registrasi2').modal('hide');
            }
        });

        
    }else{
        toast(response.message, "error")
    }  
}
function CreateRegistrasi() {
    var str = $("#frmSimpanTrsRegistrasiRanap").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiRanap/CreateRegistrasi';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: str
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
            document.getElementById("frmKartuRSYarsi").reset();
            $('#Modal_Karyawn_Polis').modal('hide');
        })
}

async function goUpdateRegistrasiPaket(alasan) {
    try {
        const dataUpdateRegistrasiPaket = await UpdateRegistrasiPaket(alasan);
        updateUIdataUpdateRegistrasiPaket(dataUpdateRegistrasiPaket);
    } catch (err) {
        toast(err, "error")
    }
}

function showFormOrderPaketRI() {
    const base_url = window.location.origin;
    var NoRegRI = $("#NoREGRI").val();
    var str = btoa(NoRegRI);
    window.location = base_url + '/SIKBREC/public/aRegistrasiRanap/OrderPaketRI/' + str;
}

function updateUIdataUpdateRegistrasiPaket(params) {
    let response = params;
    if (response.status == "success") {
        toast(response.message, "success")
        swal({
            title: "Save Success!",
            text: response.message,
            icon: "success",
        }).then(function () {
            var shownamaperusahaanfix = document.getElementById("NamaPenjaminTemp").value;
            var grupJaminanid = document.getElementById("TipePenjamin").value;
            var PasienNoMR = document.getElementById("NoMR").value;
            $("#NoMRBPJS").val(PasienNoMR);
            var NoREGRI = document.getElementById("NoREGRI").value;
            $("#NoRegistrasiSIMRSBPJS").val(NoREGRI);
            console.log(shownamaperusahaanfix);
            console.log(grupJaminanid);
            if (shownamaperusahaanfix == "BPJS Kesehatan" && grupJaminanid == "5") {
                $('#modal_VerifBPJS').modal('show');
            } else {
                // const base_url = window.location.origin;
                // window.location = base_url + "/SIKBREC/public/aRegistrasiRanap/listreg";
                showFormOrderPaketRI();
            }

        });
    } else {
        toast(response.message, "error")
    }

}
function UpdateRegistrasiPaket(alasan) {
    var str = $("#frmSimpanTrsRegistrasiRanap").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiRanap/CreateRegistrasi';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: str  + '&alasan=' + alasan
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
            document.getElementById("frmKartuRSYarsi").reset();
            $('#Modal_Karyawn_Polis').modal('hide');
        })
}

async function goUpdateRegistrasi(alasan) {
    try {
        const dataUpdateRegistrasi = await UpdateRegistrasi(alasan);
       updateUIdataUpdateRegistrasi(dataUpdateRegistrasi);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdataUpdateRegistrasi(params) {
    let response = params;
    if (response.status == "success") {
        toast(response.message, "success")
        swal({
            title: "Save Success!",
            text: response.message,
            icon: "success",
        }).then(function () {
            var shownamaperusahaanfix = document.getElementById("NamaPenjaminTemp").value;
            var grupJaminanid = document.getElementById("TipePenjamin").value;
            var PasienNoMR = document.getElementById("NoMR").value;
            $("#NoMRBPJS").val(PasienNoMR);
            var NoREGRI = document.getElementById("NoREGRI").value;
            $("#NoRegistrasiSIMRSBPJS").val(NoREGRI);
            console.log(shownamaperusahaanfix);
            console.log(grupJaminanid);
            if (shownamaperusahaanfix == "BPJS Kesehatan" && grupJaminanid == "5") {
                $('#modal_VerifBPJS').modal('show');
            } else {
                const base_url = window.location.origin;
                window.location = base_url + "/SIKBREC/public/aRegistrasiRanap/listreg";
            }

        });
    } else {
        toast(response.message, "error")
    }

}
function UpdateRegistrasi(alasan) {
    var str = $("#frmSimpanTrsRegistrasiRanap").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiRanap/CreateRegistrasi';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: str  + '&alasan=' + alasan
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
            document.getElementById("frmKartuRSYarsi").reset();
            $('#Modal_Karyawn_Polis').modal('hide');
        })
}

async function voidRegistrasi() {
    try {
        const dataVoidRegistrasi = await VoidRegistrasi();
        updateUIdataVoidRegistrasi(dataVoidRegistrasi);
    } catch (err) {
        swal("Oops", "Sorry... " + err, "error");
    }
}

function updateUIdataVoidRegistrasi(dataVoidRegistrasi) {
    let params = dataVoidRegistrasi;
    swal('Good job!', params.message + " !", "success")
        .then((value) => {
            //GoVoidSep();
            MyBack();
        });
}

function VoidSEP() {
    var str = $("#frmBatalReg").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/xBPJSBridging/GoDeleteSEP';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: str
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
            // MyBack();
            voidRegistrasi();
            $(".preloader").fadeOut();
        })
}

function VoidRegistrasi() {
    var str = $("#frmBatalReg").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiRanap/VoidRegistrasi';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: str
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
            document.getElementById("frmKartuRSYarsi").reset();
            $('#Modal_Karyawn_Polis').modal('hide');
        })
}


function Passingbatal() {
    var nosep = $("#NoSEP").val();
    var noregistrasi = $("#NoREGRI").val();
    $("#nosepbatal").val(nosep);
    $("#noregbatal").val(noregistrasi);
} 


async function GoVoidSep() {
    try {
        $(".preloader").fadeIn();
        const dataVoidSEP = await VoidSEP();
        console.logdataVoidSEP
          updateUIdataVoidSEP(dataVoidSEP);
        
    } catch (err) {
        swal("Oops", "Sorry... " + err, "error");
    }
}
function updateUIdataVoidSEP(dataVoidSEP) {
    let params = dataVoidSEP;
    swal('Good job!', params.message + " !, Sealnjutnya Hapus Registrasi, Silahkan Tunggu !", "success")
        .then((value) => {
            voidRegistrasi();
        });
}
function MyBack(noreg) {
    const base_url = window.location.origin;
    if (noreg == '' || noreg == null){
        var variable = 'list';
    }else{
        var variable = 'listreg';
    }
     window.location = base_url + "/SIKBREC/public/aRegistrasiRanap/" + variable;
}

function convertEntities($data) {
$xonvert = $('<textarea />').html($data).text();
return $xonvert;
}

// Primary function always
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
//console.log( status,data);
toastr[status](data);
}
function gotanpaDigitalSign() {
    var tanpaDigitalSign = document.getElementById("tanpaDigitalSign").value
    if (tanpaDigitalSign == "0") {
        document.getElementById("btncetakSep").disabled = true;
        document.getElementById("btnRefreshSign").disabled = false;
    } else {
        document.getElementById("btncetakSep").disabled = false;
        document.getElementById("btnRefreshSign").disabled = true;
    }
}
async function GoGetDataBpjsKecamatan() {
    try {
        const dataProvinsiBPJS = await GetDataProvinsiBPJS();
        updateUIgetProvinsiBPJS(dataProvinsiBPJS);
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
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
function GoMonitoringBPJS() {
    var MTglKunjunganBPJS = $("[name='MTglKunjunganBPJS']").val();
    var MTglKunjunganBPJS_akhir = document.getElementById("MTglKunjunganBPJS_akhir").value;
    var MNoKartuPeserta = document.getElementById("nokartubpjs").value;
    var base_url = window.location.origin;
    $('#tbl_history_Kunjungan').DataTable().clear().destroy();
    $('#tbl_history_Kunjungan').DataTable({
        "ordering": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/xBPJSBridging/GoMonitoringHistoriPelayananBPJS",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.MTglKunjunganBPJS = MTglKunjunganBPJS;
                d.MTglKunjunganBPJS_akhir = MTglKunjunganBPJS_akhir;
                d.MNoKartuPeserta = MNoKartuPeserta;
            }
        },
        "columns": [
            { "data": "noSep" },
            { "data": "noKartu" },
            { "data": "noRujukan" },
            { "data": "tglSep" },
            { "data": "namaPeserta" },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.jnsPelayanan == "1") {
                        var html = ""
                        var html = 'Rawat Inap';
                        return html
                    } else {
                        var html = ""
                        var html = 'Rawat Jalan';
                        return html
                    }

                }
            },
            { "data": "diagnosa" },
            { "data": "kelasRawat" },
            { "data": "poli" },
            { "data": "tglPlgSep" },
            { "data": "ppkPelayanan" },
        ]
    });

}

async function getCOB() {
    try{
        const datagoGetCOB = await goGetCOB();
        updateUIdatagoGetCOB(datagoGetCOB);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatagoGetCOB(dataGetRefferalByIdGroup) {
    let responseApi = dataGetRefferalByIdGroup;
    if (responseApi !== null && responseApi !== undefined) {
        var newRow = '<option value="">-- PILIH --</option';
        $("#COB").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].ID + '">' + responseApi[i].NamaCOB + '</option>';
            $("#COB").append(newRow);
        }
    }
}

function goGetCOB() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterCOB/getCOBAktif';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        }
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
            $("#COB").select2();
        })
}

function PrintGelangAnak(idParams){
    var notrs = btoa(idParams); 
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/aRegistrasiRajal/PrintGelangAnak/" + notrs , "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
}

function PrintGelangDewasa(idParams){
    var notrs = btoa(idParams); 
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/aRegistrasiRajal/PrintGelangDewasa/" + notrs , "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
}

function PrintLabelPasien(idParams){
    var notrs = btoa(idParams); 
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/aRegistrasiRajal/PrintLabelPasien/" + notrs , "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
}

function getDataListPasienOperasibyNoReg(notrs) { 
    var base_url = window.location.origin;
    $('#examplex').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#examplex').DataTable({
           "processing":true,
           "ordering": false, // Set true agar bisa di sorting
           //"order": [[ 0, 'desc' ]], 
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/aRegistrasiRanap/getDataListPasienOperasibyNoReg", // URL file untuk proses select datanya
               "type": "POST",data: function (d) {
                d.notrs = notrs
            },
                "dataSrc": "",
           "deferRender": true,
           }, 
                "columns": [
                    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        
                        var html  = '<font size="2">'+row.ID+'</font> '
                            return html 
                    }
                },
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                    var html = ""
                    
                    var html  = '<font size="2">'+row.NoMR+'</font> '
                        return html 
                }
            },
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        
                        var html  = '<font size="2">'+row.NoRegistrasi+'</font> '
                            return html 
                    }
                },
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        
                        var html  = '<font size="2">'+row.NoEpisode+'</font> '
                            return html 
                    }
                },
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        
                        var html  = '<font size="2">'+row.TglOperasi+'</font> '
                            return html 
                    }
                }  ,   
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var html = ""
                        
                        var html  = '<font size="2">'+row.NamaPasien+'</font> '
                            return html 
                    }
                } ,  
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                    var html = ""
                    
                    var html  = '<font size="2">'+row.DrOperator+'</font> '
                        return html 
                }
            },  
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                
                var html  = '<font size="2">'+row.PetugasOrder+'</font> '
                    return html 
            }
        },  
               { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                     var html = ""
                      
                       var html  = '<button type="button" class="btn btn-primary border-primary btn-animated btn-xs"  onclick="TransferOPConfirm(' + row.ID + ')" ><span class="visible-content" > Transfer Reg</span></button>'
                          return html 
                   }
               },
           ],
       });
} 

function TransferOPConfirm(param){
    //-----SIGNUP
    swal({
        title: "Simpan",
        text: "Apakah Anda Yakin Ingin Simpan ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                TransferOP(param)
            } else {
               // swal("Transaction Rollback !");
            }
        });
        //-#END SIGNUP
 }

async function TransferOP(param) {
    try{
        const data = await goTransferOP(param);
        updateUIgoTransferOP(data);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIgoTransferOP(data) {
    if (data.status == "success") {
        toast(data.message, "success");
        swal('Berhasil !', data.message, "success");
        $("#modal_caripasien").modal('hide');
    }else {
        toast(data.message,"error");
        swal('Gagal !', data.message, "error")
    }
}
function goTransferOP(notrs) {
    var NoReg = $("#NoREGRI").val();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiRanap/goTransferOP';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'notrs=' +notrs +'&noreg=' + NoReg
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
        })
}