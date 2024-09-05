$(document).ready(function () {
    // format number to price
    convertNumberToRp();
    onloadformall();
    $(document).on('click', '#logocetakbuktiSEP', function () {
        
        var notrs = $('#NoTrsPencairan').val();
       
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/OrderBonSementara/PrintBuktiRegis/" + notrs, "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
    });

});

async function onloadformall() {
    try {
        $(".preloader").fadeIn();
        const dataloadDataPegawai = await loadDataPegawai();
        updateUIdataloadDataPegawai(dataloadDataPegawai);
        const dataloadRekeningKas = await loadRekeningKas();
        updateUIdataloadRekeningKas(dataloadRekeningKas);
        const dataloadDataOrder = await loadDataOrder();
        console.log("loadDataOrder", dataloadDataOrder)
        updateUIdataloadDataOrder(dataloadDataOrder);
        var IDNoTrsOrder = document.getElementById("IDNoTrsOrder").value; 
        console.log("IDNoTrsOrder", IDNoTrsOrder)
        if (IDNoTrsOrder === "" ){
            $('#TipeKasbon').val("CITO").trigger('change');
        }else{
            $('#TipeKasbon').val("REGULER").trigger('change');
        }
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry... " + err, "error");
        $(".preloader").fadeOut();
    }
}
function updateUIdataloadDataPegawai(params) {
    let responseApi = params.data.getpegawai;

    if (responseApi !== null && responseApi !== undefined) {
        console.log("responseApi", responseApi.length);
        var newRow = '<option value="">-- PILIH --</option';
        $("#IDPegawaiOrder").empty();
        $("#IDPegawaiOrder").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].ID_Data + '">' + responseApi[i].Nama + '</option';
            $("#IDPegawaiOrder").append(newRow);
        }
    }
}
function loadDataPegawai() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/PencairanKasbon/getpegawaiAllAktif';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'IDNoTrsPencairan=1'
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
            $('#IDPegawaiOrder').select2();
        })
}
function updateUIdataloadRekeningKas(params) {
    let responseApi = params.data.getrekkas;

    if (responseApi !== null && responseApi !== undefined) {
        console.log("responseApi", responseApi.length);
        var newRow = '<option value="">-- PILIH --</option';
        $("#RekeningKas").empty();
        $("#RekeningKas").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].ID + '">' + responseApi[i].FS_NM_REKENING + '</option';
            $("#RekeningKas").append(newRow);
        }
    }
}
function loadRekeningKas() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/PencairanKasbon/getRekeningKas';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'IDNoTrsPencairan=1'
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
            $('#RekeningKas').select2();
        })
}
function updateUIdataloadDataOrder(data) {
    $('#NoTrsOrder').val(data.No_Transaksi);
    $('#TglOrder').val(data.Tgl_Transaksi);
    $('#PegawaiOrder').val(data.Nama);
    $('#NilaiOrder').val(number_to_price(data.Nominal));
    $('#NilaiPencairan').val(number_to_price(data.Nominal));
    $('#Keterangan').val(data.Keterangan);
    $('#KeteranganPencairan').val(data.Keterangan); 
    $('#IDPegawaiOrder').val(data.IDPegawai).trigger('change');
    if (data.No_Transaksi != null ){
        $('#TipeKasbon').val('REGULER');
    }else{
        $('#TipeKasbon').val('CITO');
    }
}   
// function updateUIdataCreateSPRI(params) {
//     // $('#SPRI_NoSPR2BPJS').val(params.hasil);
//     swal("Success", "SPRI Berhasil Dirubah !", "success")
//         .then((value) => {
//             $('#notif_Cetak').modal('show');
//             //MyBack();
//         });
// }
function loadDataOrder() {
    var base_url = window.location.origin;
    var ID = document.getElementById("IDNoTrsOrder").value; 
    let url = base_url + '/SIKBREC/public/PencairanKasbon/showOrderPencairanById';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'IDNoTrsOrder=' + ID 
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
$('#savetrs').click(function () {
    swal({
        title: "Simpan",
        text: "Apakah Anda ingin Simpan Transaksi ini ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                goCreateRealisasi();
            } else {
                // swal("Transaction Rollback !");
            }
        });

});
async function goCreateRealisasi() {
    try {
        $(".preloader").fadeIn();
        const dataCreateRealisasii = await CreateRealisasi();
        updateUIdataCreateRealisasii(dataCreateRealisasii); 
        $(".preloader").fadeOut();
    } catch (err) {
        console.log(err)
        toast(err, "error")
        $(".preloader").fadeOut();
    }
}
function updateUIdataCreateRealisasii(params) {
    let response = params;
    toast("Transaksi Bon Sementara Berhasil, No. Transaksi : " + response.id, "success")
    $("#NoTrsPencairan").val(response.id);
    $('#notif_Cetak').modal('show'); 
}
function CreateRealisasi() {
    var NoTrsOrder = $("#NoTrsOrder").val();
    var TglOrder = $("#TglOrder").val();
    var TglRealRealisasi = $("#TglRealRealisasi").val();
    var RekeningKas = $("#RekeningKas").val();
    var PegawaiOrder = $("#PegawaiOrder").val();
    var Keterangan = $("#Keterangan").val();
    var NoTrsPencairan = $("#NoTrsPencairan").val();
    var TipeKasbon = $("#TipeKasbon").val();
    var KeteranganPencairan = $("#KeteranganPencairan").val();
    var NominalOrder = price_to_number($("#NominalOrder").val());
    var NilaiPencairan = price_to_number($("#NilaiPencairan").val());
    var IDPegawaiOrder = $("#IDPegawaiOrder").val(); 
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/PencairanKasbon/CreateRealisasi';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "NoTrsOrder=" + NoTrsOrder + "&TglOrder=" + TglOrder + "&PegawaiOrder=" + PegawaiOrder
            + "&Keterangan=" + Keterangan + "&NoTrsPencairan=" + NoTrsPencairan + "&TipeKasbon=" + TipeKasbon
            + "&NominalOrder=" + NominalOrder + "&NilaiPencairan=" + NilaiPencairan
            + "&KeteranganPencairan=" + KeteranganPencairan + "&IDPegawaiOrder=" + IDPegawaiOrder
            + "&TglRealRealisasi=" + TglRealRealisasi + "&RekeningKas=" + RekeningKas
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
function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, "").toString(),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return prefix == undefined ? rupiah : rupiah ? "" + rupiah : ",00";
}
function number_to_price(v) {
    if (v == 0) { return '0,00'; }
    v = parseFloat(v);
    v = v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    v = v.split('.').join('*').split(',').join('.').split('*').join(',');
    return v;
}
function price_to_number(v) {
    if (!v) { return 0; }
    v = v.split('.').join('');
    v = v.split(',').join('.');
    return Number(v.replace(/[^0-9.]/g, ""));
}
function convertNumberToRp() {
    var NilaiPencairan = document.getElementById("NilaiPencairan");
    NilaiPencairan.addEventListener("keyup", function (e) {
        NilaiPencairan.value = formatRupiah(this.value);
    }); 
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
    toastr[status](data);
}
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/PencairanKasbon/";
}
function gocreate() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/PencairanKasbon/EntriPenyelesaian/";
}