$(document).ready(function () {
    convertNumberToRp();
    onloadformall();    
    var IDNoTrsPencairan = document.getElementById("IDNoTrsPencairan").value;
    if (IDNoTrsPencairan == null || IDNoTrsPencairan == undefined || IDNoTrsPencairan == "") {
        $("#KeteranganPencairan").attr('readonly', false);
        $("#NilaiBiaya").attr('readonly', true);
        $("#TipeKasbon").attr('readonly', true); 
        document.getElementById("creates").disabled = false;
    }else{
        $("#KeteranganPencairan").attr('readonly', true);
        $("#NilaiBiaya").attr('readonly', false);  
        $("#creates").attr('readonly', true); 
        $("#TipeKasbon").attr('readonly', true); 
        document.getElementById("NamaPegawai").disabled = true;
    }
    $("#NilaiBiaya").keyup(function () { // Ketika user menekan tombol di keyboard
        if (event.keyCode == 13) { // Jika user menekan tombol ENTER
           
                goCreateDetailKasbon();
            
        }
    });

    $(document).on('click', '#logocetakbuktiSEP', function () {

        var notrs = $('#IDNoTrsPencairan').val();

        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/OrderBonSementara/PrintBuktiRegis/" + notrs, "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
    });
    
    $('#creates').click(function () {
        goCreateRealisasi();
    });
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
                    gocreateFinishTransaction();
                } else {
                    // swal("Transaction Rollback !");
                }
            });

    });
    $('#btnbatal').click(function () {
        swal("Alasan Batal:", {
            content: "input",
            buttons: true,
        })
            .then((value) => {
                if (value == '') {
                    swal("Alasan Batal Harus Diisi ! Simpan Gagal !");
                    return false;
                } else if (value == null) {
                    return false;
                }
                // swal(`You typed: ${value}`);
                goVoidHeaderPenyelesaian(value);
            });
    });
});
async function goVoidHeaderPenyelesaian(param) {
    try {
        $(".preloader").fadeIn();
        const datagoVoidHeader2 = await goVoidHeader2goVoidHeaderPenyelesaian(param);
        updateUIdatagoFinish(datagoVoidHeader2);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatagoFinish(data) {
    if (data.status == "success") {
        toast(data.message, "success");
        setTimeout(() => {
            MyBack();
        }, 2000);
    } else {
        toast(data.message, "error")
    }
}
function goVoidHeader2goVoidHeaderPenyelesaian(param) {
    var noTrsPencairan = document.getElementById("noTrsPencairan").value; 
    var url2 = "/SIKBREC/public/PencairanKasbon/batalPenyelesaianPencairanKasbon";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "noTrsPencairan=" + noTrsPencairan 
        + "&AlasanBatal=" + param  
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
async function gocreateFinishTransaction() {
    try {
        $(".preloader").fadeIn();
        const dataFinishPenyelesaianKasbon = await FinishPenyelesaianKasbon();
        updateUIdataFinishPenyelesaianKasbon(dataFinishPenyelesaianKasbon);
        console.log("dataFinishPenyelesaianKasbon", dataFinishPenyelesaianKasbon);
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry... " + err, "error");
        $(".preloader").fadeOut();
    }
}
function updateUIdataFinishPenyelesaianKasbon(params) {
     
        swal("Success", "Data Berhasil di Simpan !", "success")
        .then((value) => {
            $('#notif_Cetak').modal('show');
            //MyBack();
        });
 
}
function FinishPenyelesaianKasbon() {
    var base_url = window.location.origin;
    var IDNoTrsPencairan = document.getElementById("IDNoTrsPencairan").value;
    var NilaiPenyelesaian = price_to_number(document.getElementById("NilaiPenyelesaian").value);
    var TglPenyelesaian = document.getElementById("TglPenyelesaian").value;
    var TipeKasbon = document.getElementById("TipeKasbon").value;
    var GroupBebanBiaya = document.getElementById("GroupBebanBiaya").value;
    var NamaPegawai = document.getElementById("NamaPegawai").value;
    var NilaiBiaya = price_to_number(document.getElementById("NilaiBiaya").value);
    let url = base_url + '/SIKBREC/public/PencairanKasbon/FinishTrsPenyelesaianKasbon';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'IDNoTrsPencairan=' + IDNoTrsPencairan + '&NilaiPenyelesaian=' + NilaiPenyelesaian
            + '&TglPenyelesaian=' + TglPenyelesaian + '&TipeKasbon=' + TipeKasbon
            + '&GroupBebanBiaya=' + GroupBebanBiaya + '&NamaPegawai=' + NamaPegawai
            + '&NilaiBiaya=' + NilaiBiaya
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
function showdetailPenyelesaian() {
    var nf = new Intl.NumberFormat();

    var IDNoTrsPencairan = document.getElementById("IDNoTrsPencairan").value;
    var base_url = window.location.origin;
    $('#tbl_penyelesaian').DataTable().clear().destroy();
    $('#tbl_penyelesaian').DataTable({
        "ordering": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/PencairanKasbon/showdetailPenyelesaian",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.IDNoTrsPencairan = IDNoTrsPencairan; 
            }
        },
        "columns": [
            { "data": "no" },
            { "data": "ID_Kas" },
            { "data": "FS_NM_REKENING" },
            { "data": "NAMA_GROUP_BEBAN" }, 
             
            { "data": "Nilai", render: $.fn.dataTable.render.number(',', '', 0, '') },  // 

            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick="batalDetil(' + row.ID + ')" ><span class="visible-content" > Batal</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },

        ],
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over this page
            // Total over this page
       
            total10 = api
                .column(4)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

             


            $(api.column(4).footer()).html(
                $.fn.dataTable.render.number(',', '', '', '').display(total10)
            ); 


        },
    });
    $(".preloader").fadeOut();
}
async function batalDetil(params) {
    try {
        $(".preloader").fadeIn();
        const dataDeleteDetailKasbon = await DeleteDetailKasbon(params); 
        updateUIdataDeleteDetailKasbon(dataDeleteDetailKasbon); 
        console.log("dataDeleteDetailKasbon", dataDeleteDetailKasbon);
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry... " + err, "error");
        $(".preloader").fadeOut();
    }
}
function updateUIdataDeleteDetailKasbon(params) {
    swal("Success", "Data Berhasil DiHapus ! " , "success");
    showdetailPenyelesaian();
}
function DeleteDetailKasbon(params) {
    var base_url = window.location.origin;
    var IDDetails = params; 
    let url = base_url + '/SIKBREC/public/PencairanKasbon/deleteIdDetailKasbon';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'IDDetails=' + IDDetails  
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
async function goCreateDetailKasbon() {
    try {
        $(".preloader").fadeIn();
        const dataCreateDetailPenyelesaianKasbon = await CreateDetailPenyelesaianKasbon();
        
        updateUIdataCreateDetailPenyelesaianKasbon(dataCreateDetailPenyelesaianKasbon); 

        console.log("dataCreateDetailPenyelesaianKasbon", dataCreateDetailPenyelesaianKasbon);
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry... " + err, "error");
        $(".preloader").fadeOut();
    }
}
async function updateUIdataCreateDetailPenyelesaianKasbon(params) {
    const dataloadBebanHarian = await loadBebanHarian();
    updateUIdataloadBebanHarian(dataloadBebanHarian);
    $("#NilaiBiaya").val('');
    showdetailPenyelesaian();
}
function CreateDetailPenyelesaianKasbon() {
    var base_url = window.location.origin;
    
    var IDNoTrsPencairanxx = document.getElementById("IDNoTrsPencairan").value;
    console.log("IDNoTrsPencairanxx", IDNoTrsPencairanxx);
    if (IDNoTrsPencairanxx == null || IDNoTrsPencairanxx == undefined || IDNoTrsPencairanxx == "" ){
        var IDNoTrsPencairan = document.getElementById("IDNoTrsPencairan2").value;
        console.log("1", IDNoTrsPencairan);
    }else{
        var IDNoTrsPencairan = document.getElementById("IDNoTrsPencairan").value;
        console.log("0");
    }
   
    
    var NilaiPenyelesaian = price_to_number(document.getElementById("NilaiPenyelesaian").value);
    var TglPenyelesaian = document.getElementById("TglPenyelesaian").value;
    var TipeKasbon = document.getElementById("TipeKasbon").value;
    var GroupBebanBiaya = document.getElementById("GroupBebanBiaya").value;
    var NamaPegawai = document.getElementById("NamaPegawai").value;
    var NilaiBiaya = price_to_number(document.getElementById("NilaiBiaya").value);
    let url = base_url + '/SIKBREC/public/PencairanKasbon/CreateKasbonDetil';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'IDNoTrsPencairan=' + IDNoTrsPencairan + '&NilaiPenyelesaian=' + NilaiPenyelesaian
            + '&TglPenyelesaian=' + TglPenyelesaian + '&TipeKasbon=' + TipeKasbon
            + '&GroupBebanBiaya=' + GroupBebanBiaya + '&NamaPegawai=' + NamaPegawai
            + '&NilaiBiaya=' + NilaiBiaya
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
async function onloadformall() {
    try {
        $(".preloader").fadeIn();
        const dataloadDataPegawai = await loadDataPegawai();
        updateUIdataloadDataPegawai(dataloadDataPegawai);
        const dataloadBebanHarian = await loadBebanHarian();
        updateUIdataloadBebanHarian(dataloadBebanHarian);
        // const dataloadRekeningKas = await loadRekeningKas();
        // updateUIdataloadRekeningKas(dataloadRekeningKas);
        const dataloadDataPencairan = await loadDataPencairan();
        updateUIdataloadDataPencairan(dataloadDataPencairan);
        showdetailPenyelesaian();
        console.log("dataloadDataPegawai", dataloadDataPegawai);
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry... " + err, "error");
        $(".preloader").fadeOut();
    }
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
function updateUIdataloadBebanHarian(params) {
    let responseApi = params.data.getbeban;

    if (responseApi !== null && responseApi !== undefined) {
        console.log("responseApi", responseApi.length);
        var newRow = '<option value="">-- PILIH --</option';
        $("#GroupBebanBiaya").empty();
        $("#GroupBebanBiaya").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].ID + '">' + responseApi[i].NAMA_GROUP_BEBAN + '</option';
            $("#GroupBebanBiaya").append(newRow);
        }
    }
}
function loadBebanHarian() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/PencairanKasbon/getDataGroupBiaya';
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
            $('#GroupBebanBiaya').select2();
        })
}
function updateUIdataloadDataPegawai(params) {
    let responseApi = params.data.getpegawai;
   
    if (responseApi !== null && responseApi !== undefined) {
        console.log("responseApi", responseApi.length);
        var newRow = '<option value="">-- PILIH --</option';
        $("#NamaPegawai").empty();
        $("#NamaPegawai").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].ID_Data + '">' + responseApi[i].Nama + '</option';
            $("#NamaPegawai").append(newRow);
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
            $('#NamaPegawai').select2();
        })
}
function updateUIdataloadDataPencairan(data) {
    $('#noTrsPencairan').val(data.noTrsPencairan);
    $('#tglPencairan').val(data.tglPencairan); 
    $('#NominalPencairan').val(number_to_price(data.NominalPencairan));
    $('#KeteranganPencairan').val(data.KeteranganPencairan);
 
    $('#NilaiPenyelesaian').val(number_to_price(data.Nilai_Penyelesaian));
    
    $('#NamaPegawai').val(data.Pegawai).trigger('change');
    $('#RekeningKas').val(data.rekeningkas).trigger('change');
    $('#TipeKasbon').val(data.TipeKasbon);

    if (data.NotrsOrder != null) {
        $('#TipeKasbon').val('REGULER');
    } else {
        $('#TipeKasbon').val('CITO');
    }
}
function loadDataPencairan() {
    var base_url = window.location.origin;
    var IDNoTrsPencairan = document.getElementById("IDNoTrsPencairan").value;
    let url = base_url + '/SIKBREC/public/PencairanKasbon/showPencairanById';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'IDNoTrsPencairan=' + IDNoTrsPencairan
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
    var NilaiBiaya = document.getElementById("NilaiBiaya");
    NilaiBiaya.addEventListener("keyup", function (e) {
        NilaiBiaya.value = formatRupiah(this.value);
    });

    var NilaiPenyelesaian =  document.getElementById("NilaiPenyelesaian");
    NilaiPenyelesaian.addEventListener("keyup", function (e) {
        NilaiPenyelesaian.value = formatRupiah(this.value);
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
    window.location = base_url + "/SIKBREC/public/PencairanKasbon/listpenyelesaian/";
}

/// REALISASI

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
    $("#IDNoTrsPencairan2").val(response.id);
    $("#noTrsPencairan").val(response.notransaksi);
    $("#NominalPencairan").val(response.nilairealisasi);
    $("#tglPencairan").val(response.tgl_trs); 
    const base_url = window.location.origin;
    var str = btoa(response.id);
    window.location = base_url + "/SIKBREC/public/PencairanKasbon/EntriPenyelesaian/" + str;
}
function CreateRealisasi() {
    var NoTrsOrder = '-';
    var TglOrder = '-';
    var PegawaiOrder = '-';;
    var Keterangan = '-';
    var NoTrsPencairan = $("#noTrsPencairan").val();
    var TipeKasbon = $("#TipeKasbon").val();
    var KeteranganPencairan = $("#KeteranganPencairan").val();
    var NominalOrder = price_to_number($("#NilaiPenyelesaian").val());
    var NilaiPencairan = price_to_number($("#NilaiPenyelesaian").val());
    var IDPegawaiOrder = $("#NamaPegawai").val();
    var date = $("#TglPenyelesaian").val();
    var TglPenyelesaian = date.replace('Z', '').replace('T', ' ').replace('.000', '');
    var RekeningKas = $("#RekeningKas").val();
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
            + "&TglRealRealisasi=" + TglPenyelesaian + "&RekeningKas=" + RekeningKas
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