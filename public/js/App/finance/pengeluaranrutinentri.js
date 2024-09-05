$(document).ready(function () {
    $(".preloader").fadeOut();
    convertNumberToRp();
    onloadformall();
    var IDNoTrsPencairan = document.getElementById("IDNoTrs2").value;
    if (IDNoTrsPencairan == null || IDNoTrsPencairan == undefined || IDNoTrsPencairan == "") {
        disable();
    }else{
        showdetailPenyelesaian();
       enabled();
    }
    $('#creates').click(function () {
        goCreatePEngeluaranRutin();
    });
    $("#NilaiBiaya").keyup(function () { // Ketika user menekan tombol di keyboard
        if (event.keyCode == 13) { // Jika user menekan tombol ENTER
                goCreateDetailKasbon();
        }
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
}); 
async function gocreateFinishTransaction() {
    try {
        $(".preloader").fadeIn();
        const dataFinishPengeluaranRutin = await FinishPengeluaranRutin();
        updateUIdataFinishPengeluaranRutin(dataFinishPengeluaranRutin);
        console.log("dataFinishPengeluaranRutin", dataFinishPengeluaranRutin);
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry... " + err, "error");
        $(".preloader").fadeOut();
    }
}
function updateUIdataFinishPengeluaranRutin(params) {
     
        swal("Success", "Data Berhasil di Simpan !", "success")
        .then((value) => {
            $('#notif_Cetak').modal('show');
            //MyBack();
        });
 
}
function FinishPengeluaranRutin() {
    var base_url = window.location.origin;
    var IDNoTrsPencairan = document.getElementById("IDNoTrs2").value; 
    var TglPenyelesaian = document.getElementById("TglPenyelesaian").value;  
    let url = base_url + '/ESIRYARSI/public/PengeluaranRutin/FinishTrs';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'IDNoTrsPencairan=' + IDNoTrsPencairan  
            + '&TglPenyelesaian=' + TglPenyelesaian  
           
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
    const dataloadUnit = await loadUnit();
    updateUIloadUnit(dataloadUnit); 
    $("#NilaiBiaya").val('');
    $("#KeteranganBiaya").val('');
    showdetailPenyelesaian();
}
function CreateDetailPenyelesaianKasbon() {
    var base_url = window.location.origin; 
    var IDNoTrsPencairan = document.getElementById("IDNoTrs2").value;
    var TglPenyelesaian = document.getElementById("TglPenyelesaian").value; 
    var Keterangan = document.getElementById("Keterangan").value; 
    var GroupBebanBiaya = document.getElementById("GroupBebanBiaya").value; 
    var NilaiBiaya = price_to_number(document.getElementById("NilaiBiaya").value);
    var KeteranganBiaya = document.getElementById("KeteranganBiaya").value;
    var Unit = document.getElementById("Unit").value;
    
    let url = base_url + '/ESIRYARSI/public/PengeluaranRutin/CreateDetil';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'IDNoTrsPencairan=' + IDNoTrsPencairan + '&Keterangan=' + Keterangan
            + '&TglPenyelesaian=' + TglPenyelesaian  
            + '&GroupBebanBiaya=' + GroupBebanBiaya  
            + '&NilaiBiaya=' + NilaiBiaya
            + '&KeteranganBiaya=' + KeteranganBiaya
            + '&Unit=' + Unit
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
function disable(){
    $("#TglPenyelesaian").attr('readonly', false);
    $("#RekeningKas").attr('readonly', true);
    $("#GroupBebanBiaya").attr('readonly', true); 
    $("#NilaiBiaya").attr('readonly', true); 
    $("#RekeningKas").attr('readonly', true); 
    $("#KeteranganBiaya").attr('readonly', true); 
    
    document.getElementById("creates").disabled = false;
    document.getElementById("batal").disabled = true;
    document.getElementById("savetrs").disabled = true;
    document.getElementById("close").disabled = true;
}
function enabled(){
    $("#TglPenyelesaian").attr('readonly', true);
    $("#RekeningKas").attr('readonly', false);
    $("#GroupBebanBiaya").attr('readonly', false); 
    $("#NilaiBiaya").attr('readonly', false); 
    $("#RekeningKas").attr('readonly', false); 
    $("#KeteranganBiaya").attr('readonly', false); 
    document.getElementById("creates").disabled = true;
    document.getElementById("batal").disabled = false;
    document.getElementById("savetrs").disabled = false;
    document.getElementById("close").disabled = false;
    showdetailPenyelesaian(); 
}

async function goCreatePEngeluaranRutin() {
    try {
        $(".preloader").fadeIn();
        const dataCreatePEngeluaranRutin = await CreatePEngeluaranRutin();
        updateUIdataCreatePEngeluaranRutin(dataCreatePEngeluaranRutin);
        $(".preloader").fadeOut();
    } catch (err) {
        console.log(err)
        toast(err, "error")
        $(".preloader").fadeOut();
    }
}
function updateUIdataCreatePEngeluaranRutin(params) {
    let response = params;
    toast("Transaksi Pengeluaran Rutin Berhasil di buat, No. Transaksi : " + response.notransaksi + ". Silahkan Masukan detail Biaya Anda.", "success") 
    $("#IDNoTrs").val(response.notransaksi);   
    $("#IDNoTrs2").val(response.id);    
    enabled();
}
function CreatePEngeluaranRutin() {
 
    var IDNoTrs = $("#IDNoTrs").val();
    var date = $("#TglPenyelesaian").val();
    var TglPenyelesaian = date.replace('Z', '').replace('T', ' ').replace('.000', '');
    var RekeningKas = $("#RekeningKas").val();
    var Keterangan = $("#Keterangan").val(); 
    var base_url = window.location.origin;
    let url = base_url + '/ESIRYARSI/public/PengeluaranRutin/Create';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:  "Keterangan=" + Keterangan + "&IDNoTrs=" + IDNoTrs   
            + "&TglPenyelesaian=" + TglPenyelesaian + "&RekeningKas=" + RekeningKas
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
// tools
function convertNumberToRp() {
    var NilaiBiaya = document.getElementById("NilaiBiaya");
    NilaiBiaya.addEventListener("keyup", function (e) {
        NilaiBiaya.value = formatRupiah(this.value);
    });
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
async function onloadformall() {
    try {
        $(".preloader").fadeIn();
        const dataloadBebanHarian = await loadBebanHarian();
        updateUIdataloadBebanHarian(dataloadBebanHarian); 
        const dataloadUnit = await loadUnit();
        updateUIloadUnit(dataloadUnit); 
        const dtloadheaders = await loadheaders();
        UIloadheaders(dtloadheaders); 
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry... " + err, "error");
        $(".preloader").fadeOut();
    }
}
function UIloadheaders(params) {
    if(params.data){
        let response = params.data;
        $("#IDNoTrs").val(response.No_Transaksi);   
       $("#IDNoTrs2").val(response.ID);    
       $("#TglPenyelesaian").val(response.Tgl_Transaksi);    
       $("#Keterangan").val(response.Keterangan);    
      enabled();
    }else{
        disable();
    }
    
}
function loadheaders() {
 
    var IDNoTrs = $("#IDNoTrs2").val();
    
    var base_url = window.location.origin;
    let url = base_url + '/ESIRYARSI/public/PengeluaranRutin/getHeader';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:  "IDNoTrsPencairan=" + IDNoTrs 
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
function updateUIloadUnit(params) {
    let responseApi = params;
    console.log(responseApi);
    if (responseApi !== null && responseApi !== undefined) {
        console.log("responseApi", responseApi.length);
        var newRow = '<option value="">-- PILIH --</option';
        $("#Unit").empty();
        $("#Unit").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].ID + '">' + responseApi[i].NamaUnit + '</option';
            $("#Unit").append(newRow);
        }
    }
}
function loadUnit() {
    var base_url = window.location.origin;
    let url = base_url + '/ESIRYARSI/public/MasterDataUnit/getAllDataUnit';
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
            $('#Unit').select2();
        })
}
function showdetailPenyelesaian() {
    var nf = new Intl.NumberFormat();

    var IDNoTrsPencairan = document.getElementById("IDNoTrs2").value;
    var base_url = window.location.origin;
    $('#tbl_penyelesaian').DataTable().clear().destroy();
    $('#tbl_penyelesaian').DataTable({
        "ordering": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/ESIRYARSI/public/PengeluaranRutin/ShowDetail",
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
            { "data": "KeteranganBiaya" },  
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
    let url = base_url + '/ESIRYARSI/public/PengeluaranRutin/deleteIdDetail';
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
    let url = base_url + '/ESIRYARSI/public/PencairanKasbon/getDataGroupBiaya';
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
    window.location = base_url + "/ESIRYARSI/public/PengeluaranRutin/listpengeluaranrutin/";
}