$(document).ready(function () {
    asyncShowMain();
    $(".preloader").fadeOut(); 
    
    // $('#datatable').DataTable({});
    $(document).on('click', '#btnLoadInformation', function () { 
        getListAntrian();
    });
     
});
function getListAntrian() { 
    let Tanggal ,Lantai,CounterName,CounterId,IpAddress;
    Tanggal = $("#Tanggal").val();
    Lantai = $("#Lantai").val();
    CounterName = $("#CounterName").val();
    CounterId = $("#CounterId").val(); 
    IpAddress = $("#IpAddress").val();
    var base_url = window.location.origin;
    $('#datatable').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#datatable').DataTable({
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/aAntrianCaller/getListAntrian", // URL file untuk proses select datanya
               "type": "POST",
               data: function ( d ) {
               d.Tanggal = Tanggal;
               d.Lantai = Lantai;
               d.CounterName = CounterName;
               d.CounterId = CounterId;
               d.IpAddress = IpAddress;   
               },
                "dataSrc": "",
           "deferRender": true,
           }, 
           "columns": [ 
            { "data": "Id" }, 
            { "data": "NoAntrian" }, 
            { "data": "Status" },  
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-success  icon-only" onclick=\'callantrian("'+row.Id+'","'+row.NoAntrian+'")\' ><i class="fa fa-bullhorn"></i></button>'
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-danger  icon-only"  onclick=\'holdAntrian("'+row.Id+'")\' ><i class="fa fa-warning"></i></button>'
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-primary  icon-only"  onclick=\'proccessAntrian("'+row.Id+'")\' ><i class="fa fa-hourglass"></i></button>'
                    return html
                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-warning   icon-only"  onclick=\'FinishAntrian("'+row.Id+'")\' ><i class="fa fa-check"></i></button>'
                    return html
                }
            },
              
           ],
         
       });
} 


async function asyncShowMain() {
    try { 
        
        const datagetIpCounter = await getIpCounter(); 
        udpateUIdatagetIpCounter(datagetIpCounter);
     
    } catch (err) {
        toast(err, "error")
    }
}
function udpateUIdatagetIpCounter(datagetGrupPerawatan) {
    let data = datagetGrupPerawatan;
     console.log("dataaaa",data);
     if(data.status){
        $("#Lantai").val(data.data[0].FloorId);
        $("#CounterName").val(data.data[0].CounterName);
        $("#IpAddress").val(data.data[0].IpAddress);
        $("#CounterId").val(data.data[0].Id);
        
     }else{
        swal('IP Address dan Counter anda belum terdaftar, silahkan Hubungi IT untuk mendaftarkan.')
        .then((value) => {   
            $("#Lantai").val('');
            $("#CounterName").val('');
            $("#IpAddress").val('');
            $("#CounterId").val('');
        });
     }
}
function getIpCounter() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aAntrianCaller/getIpCounter';
    return fetch(url, {
        method: 'GET',
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
            $("#GrupPerawatan").select2();
        })
}
// antrian 
async function callantrian(id,NoAntrian){
    try { 
        
        const datacallantrian = await gocallantrian(id,NoAntrian); 
        updateUIdatacallantrian(datacallantrian);
     
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatacallantrian(data){
    if(data.status){    
        toast(data.message,"success");
        getListAntrian();
    }else{
        toast(data.message,"error");
    }
}
function gocallantrian(id,NoAntrian) {
    var base_url = window.location.origin;

    var idantrian = id;
    var NoAntrian = NoAntrian;
    var Tanggal = $("[name='Tanggal']").val();
    var Lantai = $("[name='Lantai']").val();
    var CounterName = $("[name='CounterName']").val();
    var CounterId = $("[name='CounterId']").val();
    var IpAddress = $("[name='IpAddress']").val();

    let url = base_url + '/SIKBREC/public/aAntrianCaller/gocallantrian';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'idantrian='+ idantrian 
                + '&NoAntrian='+ NoAntrian  
                + '&Tanggal='+ Tanggal  
                + '&Lantai='+ Lantai  
                + '&CounterName='+ CounterName  
                + '&CounterId='+ CounterId  
                + '&IpAddress='+ IpAddress  
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
            $("#GrupPerawatan").select2();
        })
}

async function holdAntrian(id){
    try { 
        
        const dataholdAntrian = await goholdAntrian(id); 
        updateUIdataholdAntrian(dataholdAntrian);
     
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdataholdAntrian(data){
    if(data.status){    
        toast(data.message,"success");
        getListAntrian();
    }else{
        toast(data.message,"error");
    }
}
function goholdAntrian(id) {
    var base_url = window.location.origin;

    var idantrian = id;
    var Tanggal = $("[name='Tanggal']").val();
    var Lantai = $("[name='Lantai']").val();
    var CounterName = $("[name='CounterName']").val();
    var CounterId = $("[name='CounterId']").val();
    var IpAddress = $("[name='IpAddress']").val();

    let url = base_url + '/SIKBREC/public/aAntrianCaller/goholdAntrian';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'idantrian='+ idantrian 
                + '&Tanggal='+ Tanggal  
                + '&Lantai='+ Lantai  
                + '&CounterName='+ CounterName  
                + '&CounterId='+ CounterId  
                + '&IpAddress='+ IpAddress  
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
            $("#GrupPerawatan").select2();
        })
}
async function proccessAntrian(id){
    try { 
        
        const dataproccessAntrian = await goproccessAntrian(id); 
        updateUIdataproccessAntrian(dataproccessAntrian);
     
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdataproccessAntrian(data){
    if(data.status){    
        toast(data.message,"success");
        getListAntrian();
    }else{
        toast(data.message,"error");
    }
}
function goproccessAntrian(id) {
    var base_url = window.location.origin;

    var idantrian = id;
    var Tanggal = $("[name='Tanggal']").val();
    var Lantai = $("[name='Lantai']").val();
    var CounterName = $("[name='CounterName']").val();
    var CounterId = $("[name='CounterId']").val();
    var IpAddress = $("[name='IpAddress']").val();

    let url = base_url + '/SIKBREC/public/aAntrianCaller/goproccessAntrian';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'idantrian='+ idantrian 
                + '&Tanggal='+ Tanggal  
                + '&Lantai='+ Lantai  
                + '&CounterName='+ CounterName  
                + '&CounterId='+ CounterId  
                + '&IpAddress='+ IpAddress  
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
            $("#GrupPerawatan").select2();
        })
}

async function FinishAntrian(id){
    try { 
        
        const dataFinishAntrian = await goFinishAntrian(id); 
        updateUIdataFinishAntrian(dataFinishAntrian);
     
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdataFinishAntrian(data){
    if(data.status){    
        toast(data.message,"success");
        getListAntrian();
    }else{
        toast(data.message,"error");
    }
}
function goFinishAntrian(id) {
    var base_url = window.location.origin;

    var idantrian = id;
    var Tanggal = $("[name='Tanggal']").val();
    var Lantai = $("[name='Lantai']").val();
    var CounterName = $("[name='CounterName']").val();
    var CounterId = $("[name='CounterId']").val();
    var IpAddress = $("[name='IpAddress']").val();

    let url = base_url + '/SIKBREC/public/aAntrianCaller/goFinishAntrian';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'idantrian='+ idantrian 
                + '&Tanggal='+ Tanggal  
                + '&Lantai='+ Lantai  
                + '&CounterName='+ CounterName  
                + '&CounterId='+ CounterId  
                + '&IpAddress='+ IpAddress  
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
            $("#GrupPerawatan").select2();
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