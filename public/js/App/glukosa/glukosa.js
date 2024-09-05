$(document).ready(function () {
   
    $(".preloader").fadeOut();
    $('#btnSearching').click(function () {
        verifyNoLab();     
    });
    $('#btnKirim').click(function () {
        lissendfix();     
    });
    $('#btnUpdateSEP').click(function(){
        swal({
                title: "Simpan",
                text: "Apakah Anda Akan Update Data ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                             
                        goupdatedetailglukosa();
                    } else {
                       swal("Transaction Rollback !");
                    }
                });

    });
});
//CEK NO SEP---------------
async function goupdatedetailglukosa() {
    try {
        const data = await updatedetailglukosa();
        xupdatedetailglukosa(data);
    } catch (err) {
        //console.log(err);
        toast(err, "error")
    }
}

function xupdatedetailglukosa(params) {
    getDataLIS();
    $('#modal_edit_sep').modal('hide');
}
async function lissendfix(){
    try {
        const data = await golissendfix();
        xgolissendfix(data);
    } catch (err) {
        //console.log(err);
        toast(err, "error")
    }
}
function xgolissendfix(data){
    var x = $("#notrs").val(); 
    var base_url = window.location.origin;
            var win = window.open(base_url + "/SIKBREC/public/bInformationHasilLab/PrintHasil/" + x ,  "_blank", 
        "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
            win.focus();
            window.location = base_url + "/SIKBREC/public/LabGlucosa/entri";     
}
function golissendfix() {
    //$(".preloader").fadeIn();
    var str = $("#form_lab").serialize(); 
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/LabGlucosa/insertlisfix';
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
            //$(".preloader").fadeOut();
        })
}
function updatedetailglukosa() {
    //$(".preloader").fadeIn();
    var str = $("#frmUpdateSEP").serialize(); 
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/LabGlucosa/update';
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
            } 
            return response
        })
        .finally(() => {
            //$(".preloader").fadeOut();
        })
}
async function verifyNoLab() {
    try {
        $(".preloader").fadeIn();
        const dtcreeateverifyNoLab = await creeateverifyNoLab();
        updtedtcreeateverifyNoLab(dtcreeateverifyNoLab);
        //console.log("datacreateHeaderPurchaseOrder", datacreateHeaderPurchaseOrder);
    } catch (err) {
        toast(err, "error")
    }
}
async function showHeaderData() {
    try {
        $(".preloader").fadeIn();
        const adtshowheader = await dtshowheader();
        console.log(adtshowheader);
        updateadtshowheader(adtshowheader);
        //console.log("datacreateHeaderPurchaseOrder", datacreateHeaderPurchaseOrder);
    } catch (err) {
        toast(err, "error")
    }
}
function updateadtshowheader(data){
    $("#NamaPasien").val(data.pname); 
    $("#jeniskelamin").val(data.gender); 
    $("#tgllahir").val(data.birth_dt); 
    $("#alamat").val(data.address); 
    $("#jaminanname").val(data.asuransi); 
    $("#unitname").val(data.locname); 
    $("#notrs").val(data.NoLab); 
}
function dtshowheader() {
    var data = $("#form_lab").serialize();
    var notrs = $("#nolab").val(); 
    var url2 = "/SIKBREC/public/LabGlucosa/showheader";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "notrs="+notrs  
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
function updtedtcreeateverifyNoLab(params) {
    swal({
        title: "Success",
        text: "Data Order Laboratorium ditemukan. Next Step ?",
        icon: "success",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                getDataLIS();
                showHeaderData();
            } else {
                swal("Transaction Rollback !");
            }
        });
    
}
function creeateverifyNoLab() {
    var data = $("#form_lab").serialize();
    var url2 = "/SIKBREC/public/LabGlucosa/geHasilDetail";
    var base_url = window.location.origin;
    let url = base_url + url2;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: data  
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
function getDataLIS() {  
    nolab = $("#nolab").val(); 
    var base_url = window.location.origin;
    $('#example').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#example').DataTable({
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/LabGlucosa/loaddata", // URL file untuk proses select datanya
               "type": "POST",
               data: function ( d ) {
               d.nolab = nolab; 
               },
                "dataSrc": "",
                "deferRender": true,
           }, 
           "columns": [
           
            { "data": "ID" }, 
            { "data": "TESTCODE" },  
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<font size= "2"><span class="label label-success pointer" style="cursor: pointer;" onclick=\'updateDataSEP2("'+row.ID+'","'+row.TESTCODE+'","'+row.TESTNAME+'","'+row.HASIL+'","'+row.NILAIRUJUKAN+'","'+row.SATUAN+'","'+row.FLAG+'")\'> '+row.TESTNAME+ '</span></font>'
                    return html
                }
            },
            { "data": "HASIL" }, 
            { "data": "NILAIRUJUKAN" }, 
            { "data": "SATUAN" }, 
            { "data": "FLAG" }, 
           
              
           ] 
       });
}  
function updateDataSEP2(ID, TESTCODE, TESTNAME,HASIL,NILAIRUJUKAN,SATUAN,FLAG){
 
        $('#modal_edit_sep').modal('show');
        $('#frmUpdateSEP')[0].reset();
        $('#IDx').val(ID);
        $('#TESTCODE').val(TESTCODE);
        $('#TESTNAME').val(TESTNAME);
        $('#HASIL').val(HASIL);
        $('#NILAIRUJUKAN').val(NILAIRUJUKAN);
        $('#SATUAN').val(SATUAN);
        $('#FLAG').val(FLAG);

  
        
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