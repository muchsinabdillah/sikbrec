var base_url = window.location.origin;
var norujukan = document.getElementById('norujukan');
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
var tombolcarirujukan = document.getElementById('caridata')
var kodefaskespilih = document.getElementById('kodefaskespilih')
var namafaskespilih = document.getElementById('namafaskespilih')
var kodediagnosapilih = document.getElementById('kodediagnosapilih')
var namadiagnosapilih = document.getElementById('namadiagnosapilih')
var kodepolipilih = document.getElementById('kodepolipilih')
var namapolipilih = document.getElementById('namapolipilih')
var noseppasien = document.getElementById('noseppasien')
var noregbatal = document.getElementById('noregbatal')
var dpjp = document.getElementById('dpjp')
var signNoRujukan = document.getElementById('signNoRujukan')

var user = namauser

//$("#jenisfakes").select2();
$('#btncetakDigital').click(function () {
    goCountCetak();
})

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
$('#daftarnamafakes').on('select2:select', function (e) {
    var data = e.params.data;
    console.log("data2", data);
    $("#kodefaskespilih").val(data.id);
    $("#namafaskespilih").val(data.text);
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
// tombol cari rujukan dari database
$(tombolcarirujukan).click(function(e) {
    e.preventDefault()
    // mencari data rujukan berdasarkan idrujukan
    var fromData ={
        norujukan:norujukan.value
    }
    $.ajax({
        type: "POST",
        url:  base_url + '/SIKBREC/public/Rujukan/getDataRujukanDB',
        data: fromData,
        dataType: "json",
        encode: true,
    }).done(function (data) {
        console.log(data)
        tglRujukan.value = data.tglRujukan
        $('#tglrencanakunjungan').val(data.tglRencanaKunjungan)
        $('#daftarnamafakes').append(`<option value="${data.kdtujuanRujukan}">${data.tujuanrujukan}</option>`)
        $('#diagnosarujukan').append(`<option value="${data.kodediagnosa}">${data.namadiagnosa}</option>`)
        $('#polirujukan').append(`<option value="${data.kdpolitujuan}">${data.namapolitujuan}</option>`)
        tiperujukan.value = data.kdtipeRujukan
        jnsPelayanan.value = data.kdPelayanan
        catatan.value = data.catatan
       
    })

})
$('#polirujukan').on('select2:select', function (e) {
    var data = e.params.data;
    console.log("data2", data);
    $("#kodepolipilih").val(data.id);
    $("#namapolipilih").val(data.text);
});
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

    placeholder: 'Cari Prosedur',
    minimumInputLength: 3

});
$('#diagnosarujukan').on('select2:select', function (e) {
    var data = e.params.data;
    console.log("data2", data);
    $("#kodediagnosapilih").val(data.id);
    $("#namadiagnosapilih").val(data.text);
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
// onchnage 
//$('#jenisfakes').on('change',function() {
//    console.log(this.value)
//    if(namafakes.value==""){
//        alert("nama fakes tidak boleh kosong")
//   }else{
//        var fromData ={
//            namafakes:namafakes.value,
//            kodefakes:$('#jenisfakes').val()
//        }
//        $.ajax({
//            type: "POST",
//            url:  base_url + '/SIKBREC/public/Rujukan/getFakes',
//            data: fromData,
//            dataType: "json",
//            encode: true,
//        }).done(function (data) {
//            console.log(data.faskes)
//            $("#daftarnamafakes").empty();
//            for (i = 0; i < data.faskes.length; i++) {
//                var newRow = '<option value="' + data.faskes[i].kode + '">' + data.faskes[i].nama + '</option';
//                $("#daftarnamafakes").append(newRow);
//            }      
//        })
//    }
//})
$('#btnupdate').click(function (e) {
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
                norujukan: norujukan.value,
                noSep: noseppasien.value,
                tglRujukan: tglRujukan.value,
                tglRencanaKunjungan:tglRencanaKunjungan.value,
                ppkDirujuk: kodefaskespilih.value,
                kdjenispelayanan:jnsPelayanan.value,
                jnsPelayanan:$("#jenispelayanan option:selected" ).text(),
                tiperujukan:$("#tiperujukan option:selected").text(),
                kdtipeRujukan:tipeRujukan.value,
                catatan: catatan.value,
                diagRujukan: kodediagnosapilih.value,
                namadiagRujukan: namadiagnosapilih.value,
                poliRujukan: kodepolipilih.value,
                namapoliRujukan: namapolipilih.value,
                user: namauser,
                jenisfakes:jenisfakes.value,
                namafaskespilih:namafaskespilih.value
            }
            // console.log($("#diagnosa").val())
            $.ajax({
                type: "POST",
                url: base_url + '/SIKBREC/public/Rujukan/updateDataRujukan',
                data: formData,
                dataType: "json",
                encode: true,
            }).done(function (data) {
                console.log(data)
                if(data.status=="warning"){
                    // alert(data.errorname,data.metadata.message)
                    swal({
                        title: "error",
                        text: data.errorname,
                        icon: "error",
                    })
                } else if (data.status == "blank") {
                    // alert(data.errorname,data.metadata.message)
                    swal({
                        title: "Oops..",
                        text: data.message,
                        icon: "error",
                    })
                } else{
                    swal({
                        title: "success",
                        text: "Data Rujukan berhasil di Update !",
                        icon: "success",
                    }).then((willDelete) => {
                        if (willDelete) {
                            location.reload();
                        }
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

function GoMonitoringBPJS() {
    var MTglKunjunganBPJS = $("[name='PengSEP_Tgl']").val(); 
    var base_url = window.location.origin;
    $('#tbl_kunjungan_monitoring').DataTable().clear().destroy();
    $('#tbl_kunjungan_monitoring').DataTable({
        "ordering": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/Rujukan/showListRujukan",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.MTglKunjunganBPJS = MTglKunjunganBPJS; 
            }
        },
        "columns": [
            { "data": "idRujukan" },
            { "data": "noSep" },
            { "data": "tglRujukan" },
            { "data": "tglRencanaKunjungan" },
            { "data": "tglBerlakuKunjungan" },
            { "data": "nomorkartu" },
            { "data": "noMr" },
            { "data": "nama" },
            { "data": "namadiagnosa" },
            { "data": "poli" },
            { "data": "catatan" },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick=\'ShowDataPasienPoliklinik("' + row.idRujukan + '")\' ><span class="visible-content" > Pilih </span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },
        ]
    });
}

function ShowDataPasienPoliklinik(str) {
    $("#norujukan").val(str);
    $("#signNoRujukan").val(str);
    noregbatal.value = str;
    $("#modal_Pengajuan").modal('hide');
    var fromData = {
        norujukan: norujukan.value
    }
    $.ajax({
        type: "POST",
        url: base_url + '/SIKBREC/public/Rujukan/getDataRujukanDB',
        data: fromData,
        dataType: "json",
        encode: true,
    }).done(function (data) {
        
        console.log(data)
        tglRujukan.value = data.tglRujukan
        
        kodefaskespilih.value = data.kdtujuanRujukan
        namafaskespilih.value = data.tujuanrujukan
        kodediagnosapilih.value = data.kodediagnosa
        namadiagnosapilih.value = data.namadiagnosa
        kodepolipilih.value = data.kdpolitujuan
        namapolipilih.value = data.namapolitujuan
        noseppasien.value = data.noSep
        dpjp.value = data.dpjp
        $('#tglrencanakunjungan').val(data.tglRencanaKunjungan) 
        console.log("data.jenisfaskes", data.jenisfaskes)
        $('#tiperujukan').val(data.kdtipeRujukan).trigger('change');
        $('#jenisfakes').val(data.jenisfaskes).trigger('change');
       // $('#jenisfakes').val(data.jenisfaskes).trigger('change');
       // $('#jenisfakes').append(`<option value="${data.jenisfaskes}">${data.jenisfaskes}</option>`)
       // $('#diagnosarujukan').append(`<option value="${data.kodediagnosa}">${data.namadiagnosa}</option>`)
       // $('#polirujukan').append(`<option value="${data.kdpolitujuan}">${data.namapolitujuan}</option>`)
        //tiperujukan.value = data.kdtipeRujukan
        $('#jenispelayanan').val(data.kdPelayanan).trigger('change');
        //jnsPelayanan.value = data.kdPelayanan
        catatan.value = data.catatan
        $("#jenisfakes").select2();
        $("#jenispelayanan").select2();
        $("#tiperujukan").select2();
    })
}
function GetKetersediaanPoliklinik() {
    var kodefaskespilih = document.getElementById("kodefaskespilih").value;
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

function MyBack() {
    location.reload();
}