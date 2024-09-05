$(document).ready(function () {
    $("#NilaiFaktur").val('0');
    $("#NilaiDiskon").val('0');
    $("#NilaiPPN").val('0');
    $("#NilaiBiayaLain").val('0');
    $("#NilaiGrandTotal").val('0');
    $("#NilaiPph23").val('0');
     
    convertNumberToRp();
    onLoadFunctionAll();

    //showDataDetil_DO('TDO060920220014');
    $("#Jenis_Request").select2();
    $('#datatable_pr').dataTable({})

 
    // $(document).on('click', '#btnNewTransaksi', function () {
    //     window.onbeforeunload = null;
    //     addHeaderPurchaseOrder();
    // });

    $('#btnNewTransaksi').click(function () {
        swal({
            title: "Simpan",
            text: "Apakah Anda ingin Buat Transaksi Baru?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    addHeader();
                } else {
                    swal("Transaction Rollback !");
                }
            });

    });
    $('#btnSimpan').click(function () {
        swal({
            title: "Simpan",
            text: "Pastikan Data yang dimasukan sudah sesuai, Lanjut Simpan?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    //goFinishPurchaseOrder();
                    goFinishEdit();
                } else {
                    // swal("Transaction Rollback !");
                }
            });

    });

    $('#btn_batal').click(function () {
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
 

    $('#btnbatal').click(function () {
        var PO_NoTrs = $("#PO_NoTrs").val();
        $("#noPoBatalHdr").val(PO_NoTrs);
    });

    $('#btnClose').click(function () {
        window.onbeforeunload = null;
        MyBack();
    });

    $(".preloader").fadeOut();

});
 


async function goVoidPurchaseOrderDetailsByID(product_code, param) {
    try {
        $(".preloader").fadeIn();
        const datagoVoidPurchaseOrderDetailsByID = await goVoidPurchaseOrderDetailsByID2(product_code, param);
        //console.log("datagoFinishPurchaseOrder2", datagoFinishPurchaseOrder2);
        updateUIdatagoVoidPurchaseOrderDetailsByID2(datagoVoidPurchaseOrderDetailsByID);
    } catch (err) {
        toast(err, "error")
    }
}

async function goVoidHeader(param) {
    try {
        $(".preloader").fadeIn();
        const datagoVoidHeader2 = await goVoidHeader2(param);
        updateUIdatagoFinish(datagoVoidHeader2);
    } catch (err) {
        toast(err, "error")
    }
}

async function goFinishEdit() {
    try {
        $(".preloader").fadeIn();

        //$(".preloader").fadeIn();
        const datagoFinishDetil = await goFinishDetil();
        updateUIdatagoFinish(datagoFinishDetil);

        
        // const datagoEditFinish = await goEditFinish();
        // updateUIdatagoFinish(datagoEditFinish);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatagoFinish(data) {
    if (data.status == "success") {
        toast("Data Faktur Berhasil di Tambahkan.", "success");
        setTimeout(() => {
            MyBack();
        }, 2000);
    } else {
        toast(data.message, "error")
    }
}

function updateUIdatagoVoidPurchaseOrderDetailsByID2(data) {
    if (data.status == true) {
        toast(data.message, "success");
        showDataDetil_DO($("#No_Transaksi").val());
    } else {
        toast(data.message, "error")
    }
}

function goVoidPurchaseOrderDetailsByID2(product_code, param) {
    var No_Transaksi = document.getElementById("No_Transaksi").value;
    var url2 = "/SIKBREC/public/purchase/goVoidPurchaseOrderDetails";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "No_Transaksi=" + No_Transaksi + "&AlasanBatal=" + param + "&product_code=" + product_code
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

function goVoidHeader2(param) {
    var No_Transaksi = document.getElementById("No_Transaksi").value;  
    var url2 = "/SIKBREC/public/TukarFaktur/goVoidHeaderManual";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "No_Transaksi=" + No_Transaksi 
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


function goFinishDetil() {
    var data = $("#user_form, #form_hdr").serialize();
    var NilaiFaktur = price_to_number(document.getElementById("NilaiFaktur").value); 
    var NilaiDiskon = price_to_number(document.getElementById("NilaiDiskon").value); 
    var NilaiPPN = price_to_number(document.getElementById("NilaiPPN").value); 
    var NilaiBiayaLain = price_to_number(document.getElementById("NilaiBiayaLain").value); 
    var NilaiGrandTotal = price_to_number(document.getElementById("NilaiGrandTotal").value);
    var NilaiPph23 = price_to_number(document.getElementById("NilaiPph23").value);
    
    var date = document.getElementById("Tgl_trs").value;
    var TransasctionDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');
    var url2 = "/SIKBREC/public/TukarFaktur/createFakturManual";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: data 
        +"&NilaiFakturReal="+NilaiFaktur
        +"&NilaiPph23="+NilaiPph23
        +"&NilaiDiskonReal="+NilaiDiskon
        +"&NilaiPPNReal="+NilaiPPN
        +"&NilaiBiayaLainReal="+NilaiBiayaLain
        +"&NilaiFakturReal="+NilaiFaktur
        +"&NilaiGrandTotalReal="+NilaiGrandTotal
        +"&TransasctionDate="+TransasctionDate 
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

function goEditFinish() {
    var data = $("#user_form, #form_hdr").serialize();
    var date = document.getElementById("Tgl_Trs").value;
    var TransasctionDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');
    var TglJatuhTempo = $("#TglJatuhTempo").val();
    var url2 = "/SIKBREC/public/TukarFaktur/goFinishEditTukarFaktur";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: data +"&TransasctionDate="+TransasctionDate
                +"&TglJatuhTempo="+TglJatuhTempo
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
function updateUIdatagetTukarFakturHeader(data) {
        //CONVERT DATE
        var tgltrs = data.TransactionDate;
        var d = new Date(tgltrs);
        d = new Date(d.getTime() - d.getTimezoneOffset()*60000);
        $('#Tgl_trs').val(d.toISOString().substring(0,d.toISOString().length-1));

        //CONVERT DATE TO YYYY-MM-DD
        // var d = new Date(data[0].DateFakturPBF),
        // month = '' + (d.getMonth() + 1),
        // day = '' + d.getDate(),
        // year = d.getFullYear();
        // if (month.length < 2) 
        //     month = '0' + month;
        // if (day.length < 2) 
        //     day = '0' + day;
        // var dateconverted = [year, month, day].join('-');

        //$("#No_PurchasingOrder").val(data[0].PurchaseOrderCode);\
        $("#No_Purchase_Order").val(data.PurchaseOrderCode);
        $("#No_Delivery_Order").val(data.DeliveryCode);
        $("#Keterangan").val(data.Keterangan);
        $("#PO_KodeSupplier").val(data.SupplierCode);
        $("#Unit").val(data.UnitPembelian); 
        $("#NoFakturPBF").val(data.NoFakturPBF);
        $("#NoFakturPajak").val(data.NoFakturPajak);
        $("#Unitx").val(data.UnitPembelian).trigger('change');
        $("#PO_KodeSupplierx").val(data.SupplierCode).trigger('change');
        $("#TglFakturPBF").val(data.DateFakturPBF);
        $("#TglJatuhTempo").val(data.TglJatuhTempo);
        $("#TipeHutang").val(data.TipeHutang).trigger('change');
        $("#IncludePPN").val(data.IncludePPN).trigger('change');
        $("#RekeningBank").val(data.NamaNBank);
        $("#RekeningSupplier").val(data.NoRekeningSupplier); 
 
        unlockBtnCreate();
 


        $("#NilaiFaktur").val(number_to_price(data.TotalNilaiFaktur));
        $("#NilaiDiskon").val(number_to_price(data.TotalDiskon));
        $("#NilaiPPN").val(number_to_price(data.TotalTax));
        $("#NilaiPph23").val(number_to_price(data.Pph23));
        
       // $("#grandtotalqty").val(data[0].TotalQtyDO));
        $("#NilaiBiayaLain").val(number_to_price(data.BiayaLain));
        $("#NilaiGrandTotal").val(number_to_price(data.Grandtotal));
       
        $("#btnSearching").attr('disabled', true);

        //$("#PO_JenisPurchase").val(data.TIPE_PO).trigger('change');
        // if (data.status == "successDo") {
        //     disableForm();
        //     document.getElementById("btnNewTransaksi").disabled = true;
        //     toast(data.Pesan, "error")
        // }
        //enableForm();

    // await disableForm();
}
function getTukarFakturHeader() {
    var NoTrs = document.getElementById("No_Transaksi").value;
    var url2 = "/SIKBREC/public/TukarFaktur/getTukarFakturHeaderManual";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "NoTrs=" + NoTrs
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
async function addHeader() {
    try {
        $(".preloader").fadeIn();
        const datacreateHeader = await createHeader();
        updateUIdatacreateHeader(datacreateHeader);
        //console.log("datacreateHeaderPurchaseOrder", datacreateHeaderPurchaseOrder);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatacreateHeader(params) {

    if (params.status === true) {
        toast(params.message, "success");
        $("#No_Transaksi").val(params.data)
        unlockBtnCreate();
        showDataDetil_DO($("#No_Request").val());
        //MyBack();
    } else {
        toast(params.message, "error")
    }

}
function createHeader() {
    var data = $("#form_hdr").serialize();
    var date = document.getElementById("Tgl_trs").value;
    var TransasctionDate = date.replace('Z', '').replace('T', ' ').replace('.000', '');
    var url2 = "/SIKBREC/public/TukarFaktur/createHeaderTukarFaktur";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: data +"&TransasctionDate=" +TransasctionDate
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
async function onLoadFunctionAll() {
    try {

        const datagetSuppliers = await getSuppliers();
        updateUIdatagetSuppliers(datagetSuppliers);
        const dataGetLayanan = await GetLayanan();
        updateUIdataGetLayanan(dataGetLayanan);
        if ($("#No_Transaksi").val() != '') {
            const datagetTukarFakturHeader = await getTukarFakturHeader();
            updateUIdatagetTukarFakturHeader(datagetTukarFakturHeader);
        }
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatagetSuppliers(responseApi) {
    if (responseApi.data !== null && responseApi.data !== undefined) {
        // console.log(responseApi.data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#PO_KodeSupplierx").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].Company + '</option>';
            $("#PO_KodeSupplierx").append(newRow);
        }
    }
}
function getSuppliers() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aPurchaseOrder/getSuppliers';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'id=' + $("#IdAuto").val()
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
            $("#PO_KodeSupplierx").select2();
        })
}

 

function unlockBtnCreate() {
    if ($("#No_Transaksi").val() == '' && $("#No_PurchasingOrder").val() != '') {
        $("#btnNewTransaksi").attr('disabled', false);
        $("#btnSimpan").attr('disabled', true);
        $("#btn_batal").attr('disabled', true);

    } else if ($("#No_Transaksi").val() == '' && $("#No_PurchasingOrder").val() == '') {
        $("#btnNewTransaksi").attr('disabled', true);
        $("#btnSimpan").attr('disabled', true);
        $("#btn_batal").attr('disabled', true);
    } else {
        $("#btnNewTransaksi").attr('disabled', true);
        $("#btnSimpan").attr('disabled', false);
        $("#btn_batal").attr('disabled', false);
        $("#btnSearching").attr('disabled', true);
    }
}


function goVoidDetails(product_code) {
    swal("Alasan Hapus:", {
        content: "input",
        buttons: true,
    })
        .then((value) => {
            if (value == '') {
                swal("Alasan Hapus Harus Diisi ! Simpan Gagal !");
                return false;
            } else if (value == null) {
                return false;
            }
            // swal(`You typed: ${value}`);
            goVoidPurchaseOrderDetailsByID(product_code, value);
        });
}

function updateUIdataGetLayanan(updateUIdataGetLayanan) {
    let responseApi = updateUIdataGetLayanan;
    if (responseApi !== null && responseApi !== undefined) {
        console.log(responseApi);
        var newRow = '<option value="">-- PILIH --</option';
        $("#Unitx").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].ID + '">' + responseApi[i].NamaUnit + '</option';
            $("#Unitx").append(newRow);
        }
    }
}
function GetLayanan() {
    var base_url = window.location.origin; 
 
    let url = base_url + '/SIKBREC/public/MasterDataUnit/getAllDataUnit';
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
            $("#Unitx").select2();
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
function convertEntities($data) {
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
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
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/TukarFaktur/manuallist";
}

function getID(e){
    $("#Unit").val(e.value);
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
    var NilaiFaktur = document.getElementById("NilaiFaktur"); 
        NilaiFaktur.addEventListener("keyup", function (e) { 
        NilaiFaktur.value = formatRupiah(this.value); 
    });

 
    var NilaiDiskon = document.getElementById("NilaiDiskon");
        NilaiDiskon.addEventListener("keyup", function (e) {
        NilaiDiskon.value = formatRupiah(this.value);
    });

    var NilaiPPN = document.getElementById("NilaiPPN");
        NilaiPPN.addEventListener("keyup", function (e) {
        NilaiPPN.value = formatRupiah(this.value);
    });

    var NilaiBiayaLain = document.getElementById("NilaiBiayaLain");
        NilaiBiayaLain.addEventListener("keyup", function (e) {
        NilaiBiayaLain.value = formatRupiah(this.value);
    });

    var NilaiGrandTotal = document.getElementById("NilaiGrandTotal");
    NilaiGrandTotal.addEventListener("keyup", function (e) {
        NilaiGrandTotal.value = formatRupiah(this.value);
    });

    var NilaiPph23 = document.getElementById("NilaiPph23");
    NilaiPph23.addEventListener("keyup", function (e) {
        NilaiPph23.value = formatRupiah(this.value);
    });

    
}

function calcPPN() {
    var NilaiFaktur = price_to_number($("#NilaiFaktur").val());
    var NilaiDiskon = price_to_number($("#NilaiDiskon").val());
    var NilaiBiayaLain = price_to_number($("#NilaiBiayaLain").val());
    var isPPN =   document.getElementById("IncludePPN").value;
    var NIlaiFakturIn=NilaiFaktur-NilaiDiskon;
    if(isPPN == "1"){
        var PPNFaktur = NIlaiFakturIn*0.11;
    }else{
        var PPNFaktur = 0;
    }
    
    var NilaiGrandTotal = PPNFaktur+NIlaiFakturIn+NilaiBiayaLain;

    $("#NilaiPPN").val(number_to_price(PPNFaktur));
    $("#NilaiGrandTotal").val(number_to_price(NilaiGrandTotal));
   
}