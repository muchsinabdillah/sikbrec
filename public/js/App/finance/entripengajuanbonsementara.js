$(document).ready(function () {
    convertNumberToRp();
    onloadformall();
    $('#creates').click(function () {
        goCreateRealisasi();
    }) 
    $(document).on('click', '#logocetakbuktiSEP', function () {

        var notrsx = $('#noTrs').val(); 
        // var str = btoa(notrsx);
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/OrderBonSementara/PrintBuktiRegis/" + notrsx, "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800"); 
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
                goVoidHeader(value);
            });
    });
});
async function goVoidHeader(param) {
    try {
        $(".preloader").fadeIn();
        const datagoVoidHeader2 = await goVoidHeader2(param);
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
function goVoidHeader2(param) {
    var noTrsPencairan = document.getElementById("noTrsPencairan").value; 
    var url2 = "/SIKBREC/public/PencairanKasbon/batalPencairanKasbon";
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
function shwoOutstandingPenyelesaian() { 
    var NamaPegawai = document.getElementById("NamaPegawai").value;
    var noTrsPencairan = document.getElementById("noTrsPencairan").value;
    var base_url = window.location.origin;
    $('#tbl_arsip').DataTable().clear().destroy();
    $('#tbl_arsip').DataTable({
        "ordering": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/PencairanKasbon/shwoOutstandingPenyelesaianbyPegawai",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.NamaPegawai = NamaPegawai; 
                d.noTrsPencairan = noTrsPencairan; 
            }
        },
        "columns": [
            { "data": "ID" },
            { "data": "No_Transaksi" },
            { "data": "TglPencairan" },
            { "data": "NamaPegawaiPencairan" },
            { "data": "Keterangan" },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NominalPencairan + '  </font>  ';
                    return html
                }
            },
            { "data": "TipeKasbon" }, 
            
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick="ShowFormPenyelesaian(' + row.ID + ')" ><span class="visible-content" > Penyelesaian</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },

        ]
    });
    $(".preloader").fadeOut();
} 
function ShowFormPenyelesaian(params) {
    const base_url = window.location.origin;
    
    var str = btoa(params);
    window.open(base_url + '/SIKBREC/public/PencairanKasbon/EntriPenyelesaian/' + str,'_blank'); 
}
async function onloadformall() {
    try {
        $(".preloader").fadeIn();
        const dataloadDataPegawai = await loadDataPegawai();
        updateUIdataloadDataPegawai(dataloadDataPegawai);
        const dataloadDataPencairan = await loadDataPencairan();
        updateUIdataloadDataPencairan(dataloadDataPencairan);
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry... " + err, "error");
        $(".preloader").fadeOut();
    }
}
function updateUIdataloadDataPencairan(data) {
    $('#noTrsPencairan').val(data.noTrsPencairan);
    $('#TglPengajuan').val(data.Tgl_Transaksi); 
    $('#NilaiPengajuan').val(number_to_price(data.NominalPencairan));
    $('#KeteranganPengajuan').val(data.KeteranganPencairan);
     
    $('#NamaPegawai').val(data.Pegawai).trigger('change'); 
    $('#TipePengajuan').val(data.TipeKasbon);

    if (data.NotrsOrder != null) {
        $('#TipePengajuan').val('REGULER');
    } else {
        $('#TipePengajuan').val('CITO');
    }
}
function loadDataPencairan() {
    var base_url = window.location.origin;
    var IDNoTrsPencairan = document.getElementById("noTrs").value;
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
    $("#noTrsPencairan").val(response.notransaksi);
    toast("Transaksi Bon Sementara Berhasil, No. Transaksi : " + response.id, "success")
    $("#noTrs").val(response.id);  
    swal("Success", "Data Berhasil di Simpan !", "success")
        .then((value) => {
            $('#notif_Cetak').modal('show');
           // MyBack();
        });
   
}
function CreateRealisasi() { 
    var noTrs = $("#noTrs").val();
    var noTrsPencairan = $("#noTrsPencairan").val();
    
    var TipePengajuan = $("#TipePengajuan").val();
    var KeteranganPengajuan = $("#KeteranganPengajuan").val(); 
    var NilaiPengajuan = price_to_number($("#NilaiPengajuan").val());
    var IDPegawaiOrder = $("#NamaPegawai").val();
    var date = $("#TglPengajuan").val();
    var TglPengajuan = date.replace('Z', '').replace('T', ' ').replace('.000', ''); 
    var base_url = window.location.origin;
    
    let url = base_url + '/SIKBREC/public/PencairanKasbon/CreatePengajuanBonSementara';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "noTrs=" + noTrs + "&TipePengajuan=" + TipePengajuan
            + "&NilaiPengajuan=" + NilaiPengajuan
            + "&KeteranganPengajuan=" + KeteranganPengajuan + "&IDPegawaiOrder=" + IDPegawaiOrder 
            + "&TglPengajuan=" + TglPengajuan   + "&noTrsPencairan=" + noTrsPencairan  
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
//tools 
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

    var NilaiPengajuan =  document.getElementById("NilaiPengajuan");
    NilaiPengajuan.addEventListener("keyup", function (e) {
        NilaiPengajuan.value = formatRupiah(this.value);
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
    window.location = base_url + "/SIKBREC/public/PencairanKasbon/listpengajuanbonsementara";
}
