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
$('#jenisfakes').on('change',function() {
    console.log(this.value)
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
$('#btnupdate').click(function (e) {

    e.preventDefault()
    var formData = {
        norujukan: norujukan.value,
        tglRujukan: tglRujukan.value,
        tglRencanaKunjungan:tglRencanaKunjungan.value,
        ppkDirujuk: $('#daftarnamafakes').val(),
        kdjenispelayanan:jnsPelayanan.value,
        jnsPelayanan:$("#jenispelayanan option:selected" ).text(),
        tiperujukan:$("#tiperujukan option:selected").text(),
        kdtipeRujukan:tipeRujukan.value,
        catatan: catatan.value,
        diagRujukan:diagRujukan.value,
        poliRujukan:poliRujukan.value,
        user: namauser
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
        }else{
            swal({
                title: "success",
                text: "Data Rujukan berhasil di update",
                icon: "success",
            })
        }
    })
});
