var base_url = window.location.origin;
var nomorsep = document.getElementById('noseppasien');
var tglRujukan = document.getElementById('tglrujukan');
var tglRencanaKunjungan = document.getElementById('tglrencanakunjungan');
var ppkDirujuk = document.getElementById('kodefakes');
var jnsPelayanan = document.getElementById('jenispelayanan');
var jenisfakes = document.getElementById('jenisfakes');
var catatan = document.getElementById('catatan');
var diagRujukan = document.getElementById('diagnosarujukan');
var tipeRujukan = document.getElementById('tiperujukan');
var poliRujukan = document.getElementById('polirujukan');
var namafakes = document.getElementById('namafakes');
var dpjp = document.getElementById('dpjp'); 
$("#jenisfakes").select2();
$("#jenispelayanan").select2();
$("#tiperujukan").select2();

var user = namauser
// kondisi ketika tipe rujukan 2
$(tipeRujukan).on('change', function () {
    if (this.value == 2) {
        $(poliRujukan).attr("disabled", true);
        $(poliRujukan).empty();
        console.log(poliRujukan.value = "")
    } else {
        $(poliRujukan).attr("disabled", false)
        console.log(poliRujukan.value)

    }
})
$('#btncetakDigital').click(function () {
    goCountCetak();
})

$('#daftarnamafakes').on('select2:select', function (e) {
    var data = e.params.data;
    console.log("data2", data.text);
    //  $("#kodefaskespilih").val(data.id);
    document.getElementById("namFas").innerHTML = data.id + ' - ' + data.text;
    document.getElementById("namFas2").innerHTML = data.id + ' - ' + data.text;
});
$("#daftarnamafakes").select2({
    ajax: {

        url: function (params) {
            return window.location.origin + '/SIKBREC/public/Rujukan/getFakes'
        },
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            // console.log(child.value)
            return {
                namafakes: params.term, 
                kodefakes: $('#jenisfakes').val()
            };
        },
        processResults: function (response) {
            var dataresponse = response
            console.log(dataresponse)
            return {
                results: $.map(dataresponse.faskes, function (item) {
                    return {
                        text: item.nama,
                        id: item.kode
                    }
                })
            };
        },
        cache: true
    },

    placeholder: 'Cari Nama Faskes',
    minimumInputLength: 3

})
$("#polirujukan").select2({
    ajax: {
        url: function (params) {
            return window.location.origin + '/SIKBREC/public/Rujukan/getPoli'
        },
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                nama: params.term,
                // nama: childdokter.value,
                // isJenisPelayananBPJS: $('#isJenisPelayananBPJS').val()
            };
        },
        processResults: function (response) {
            var dataresponse = response
            console.log(dataresponse)
            return {
                results: $.map(dataresponse, function (item) {
                    return {
                        text: item.text,
                        id: item.id
                    }
                })
            };
        },
        cache: true
    },

    placeholder: 'Cari Poliklinik',
    minimumInputLength: 3

});
$("#diagnosarujukan").select2({
    ajax: {

        url: function (params) {
            return window.location.origin + '/SIKBREC/public/LembarPengajuanKlaim/GetDataDiagnosa'
        },
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            // console.log(child.value)
            return {
                searchTerm: params.term,
                // nama: child.value,
                // isJenisPelayananBPJS: $('#isJenisPelayananBPJS').val()
            };
        },
        processResults: function (response) {
            var dataresponse = response
            console.log(dataresponse)
            return {
                results: $.map(dataresponse.diagnosa, function (item) {
                    return {
                        text: item.nama,
                        id: item.kode
                    }
                })
            };
        },
        cache: true
    },

    placeholder: 'Cari Diagnosa',
    minimumInputLength: 3

})
$("#kodefakes").select2({
   

})
$('#carifakes').click(function (e) {
    e.preventDefault()
    if(namafakes.value==""){
        alert("nama fakes tidak boleh kosong")
    }else{
        var fromData ={
            namafakes:namafakes.value,
            kodefakes:$('#jenisfakes').val()
        }
        $.ajax({
            type: "POST",
            url:  base_url + '/SIKBREC/public/Rujukan/getFakes',
            data: fromData,
            dataType: "json",
            encode: true,
        }).done(function (data) {
            console.log(data.faskes)
            $("#daftarnamafakes").empty();
            for (i = 0; i < data.faskes.length; i++) {
                var newRow = '<option value="' + data.faskes[i].kode + '">' + data.faskes[i].nama + '</option';
                $("#daftarnamafakes").append(newRow);
            }
        
        })
    }
})
// onchnage 
// $('#jenisfakes').on('change',function() {
//     console.log(this.value)
//     if(namafakes.value==""){
//         alert("nama fakes tidak boleh kosong")
//     }else{
//         var fromData ={
//             namafakes:namafakes.value,
//             kodefakes:$('#jenisfakes').val()
//         }
//         $.ajax({
//             type: "POST",
//             url:  base_url + '/SIKBREC/public/Rujukan/getFakes',
//             data: fromData,
//             dataType: "json",
//             encode: true,
//         }).done(function (data) {
//             console.log(data.faskes)
//             $("#daftarnamafakes").empty();
//             for (i = 0; i < data.faskes.length; i++) {
//                 var newRow = '<option value="' + data.faskes[i].kode + '">' + data.faskes[i].nama + '</option';
//                 $("#daftarnamafakes").append(newRow);
//             }
        
//         })
//     }
// })
$('#btnsimpan').click(function (e) {
    e.preventDefault()
    
    swal({
        title: "Konfirmasi",
        text: "Pastikan Semua Data Rujukan Sudah Terisi dengan benar, Apakah Anda ingin Lanjutkan?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $(".preloader").fadeIn();
                var formData = {
                    noSep: nomorsep.value,
                    tglRujukan: tglRujukan.value,
                    tglRencanaKunjungan: tglRencanaKunjungan.value,
                    ppkDirujuk: $('#daftarnamafakes').val(),
                    kdjenispelayanan: jnsPelayanan.value,
                    jnsPelayanan: $("#jenispelayanan option:selected").text(),
                    tiperujukan: $("#tiperujukan option:selected").text(),
                    kdtipeRujukan: tipeRujukan.value,
                    catatan: catatan.value,
                    diagRujukan: diagRujukan.value,
                    poliRujukan: poliRujukan.value,
                    jenisfakes: jenisfakes.value,
                    dpjp: dpjp.value,
                    user: namauser
                }
                // console.log($("#diagnosa").val())
                $.ajax({
                    type: "POST",
                    url: base_url + '/SIKBREC/public/Rujukan/insertDataRujukan',
                    data: formData,
                    dataType: "json",
                    encode: true,
                }).done(function (data) {
                    console.log(data)
                    if (data.status == "warning") {
                        // alert(data.errorname,data.metadata.message)
                        swal({
                            title: "Oops..",
                            text: data.metadata.message,
                            icon: "error",
                        })
                        $(".preloader").fadeOut();
                    } else if (data.status == "blank") {
                        // alert(data.errorname,data.metadata.message)
                        swal({
                            title: "Oops..",
                            text: data.message,
                            icon: "error",
                        })
                        $(".preloader").fadeOut();
                    } else {
                        $('#signNoRujukan').val(data.rujukan.noRujukan)
                        swal('Good job!', "Data Rujukan berhasil di buat" + data.rujukan.noRujukan + "Tanggal Rujukan " + data.rujukan.tglRujukan, "success")
                            .then((value) => {
                                $('#notif_ShowTTD_Digital').modal('show');
                                // location.reload();
                            });
                    }
                    $(".preloader").fadeOut();
                })
            } else {
                swal("Canceled!");
                $(".preloader").fadeOut();
            }
        });
   
});

function MyBack() {
    location.reload();
}
function GoMonitoringBPJS() {
    var MTglKunjunganBPJS = $("[name='MTglKunjunganBPJS']").val();
    var MTglKunjunganBPJS_akhir = $("[name='MTglKunjunganBPJS_akhir']").val();
    var MNoKartuPeserta = document.getElementById("MNoKartuPeserta").value;
    var base_url = window.location.origin;
    $('#tbl_kunjungan_monitoring').DataTable().clear().destroy();
    $('#tbl_kunjungan_monitoring').DataTable({
        "ordering": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            // "url": base_url + "/SIKBREC/public/xBPJSBridging/GoMonitoringPelayananBPJS",
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
            { "data": "jnsPelayanan" },
            { "data": "diagnosa" },
            { "data": "kelasRawat" },
            { "data": "poli" },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.tglPlgSep == null) {
                        var html = ""
                        var html = '<span class="label label-danger" onclick=\'showNoSEP("' + row.noSep + '")\'> UPDATE TANGGAL PULANG</span> ';
                        return html
                    } else {
                        var html = ""
                        var html = '<font size="1"> ' + row.nama + ' </font> <br><br><span class="label label-info">' + row.nama + '</span> ';
                        return html
                    }

                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick=\'ShowDataPasienPoliklinik("' + row.noSep + '","' + row.NAMA_DOKTER + '")\' ><span class="visible-content" > Pilih </span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            }, 
        ]
    });

}

function ShowDataPasienPoliklinik(str, NAMA_DOKTER) {
    $("#noseppasien").val(str);
    $("#dpjp").val(NAMA_DOKTER);
    $("#modal_Pengajuan").modal('hide');
}
 
function GetKetersediaanPoliklinik() {
    var kodefaskespilih = document.getElementById("daftarnamafakes").value;
    var tglrencanakunjungan2 = document.getElementById("tglrencanakunjungan").value;
    var base_url = window.location.origin;
    $('#tbl_Ketersediaan_Poli').DataTable().clear().destroy();
    $('#tbl_Ketersediaan_Poli').DataTable({
        "ordering": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/xBPJSBridging/GetKetersediaanPoliklinik",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.daftarnamafakes = kodefaskespilih;
                d.tglrencanakunjungan = tglrencanakunjungan2;
            }
        },
        "columns": [
            { "data": "kodeSpesialis" },
            { "data": "namaSpesialis" },
            { "data": "kapasitas" },
            { "data": "jumlahRujukan" },
            { "data": "persentase" },
        ]
    });

}
function GetKetersediaanSarana() {
    var kodefaskespilih = document.getElementById("daftarnamafakes").value;
    var tglrencanakunjungan2 = document.getElementById("tglrencanakunjungan").value;
    var base_url = window.location.origin;
    $('#tbl_Ketersediaan_Sarana').DataTable().clear().destroy();
    $('#tbl_Ketersediaan_Sarana').DataTable({
        "ordering": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/xBPJSBridging/GetKetersediaanSarana",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.daftarnamafakes = kodefaskespilih;
                d.tglrencanakunjungan = tglrencanakunjungan2;
            }
        },
        "columns": [
            { "data": "kodeSarana" },
            { "data": "namaSarana" }, 
        ]
    });

}
async function goCountCetak() {
    try {
        $(".preloader").fadeIn();
        var notrs = $("#signNoRujukan").val();
        var signAlasanCetak = $("#signAlasanCetak").val();
        var jeniscetakan = "RUJUKAN";
        const dataCountCetak = await CountCetak(notrs, signAlasanCetak, jeniscetakan);
        console.log(dataCountCetak);
        updateUiSukseshistory(dataCountCetak, notrs);
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry.." + err, "error");
    }
}
function updateUiSukseshistory(params, notrs) {
    if (params.status === 200) { 
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/xBPJSBridging/PrintRujukan/" + notrs, "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
        MyBack();
    }

}
function CountCetak(notrs, signAlasanCetak, jeniscetakan) { 
    var noreg = "x";
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