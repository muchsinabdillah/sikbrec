$(document).ready(function () {
    $(".preloader").fadeOut(); 
    //$('#permintaanrawat_all').DataTable({});
    getDataListLmaPasien();
});

 

function getDataListLmaPasien() { 
    //let PeriodeAwal ,PeriodeAkhir;
    //PeriodeAwal = $("#PeriodeAwal").val();
    //PeriodeAkhir = $("#PeriodeAkhir").val();
    var base_url = window.location.origin;
    $('#permintaanrawat_all').dataTable({
           "bDestroy": true
       }).fnDestroy();
       $('#permintaanrawat_all').DataTable({
           "processing":true,
           "ordering": true, // Set true agar bisa di sorting
           "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
           "ajax":
           {
               "url": base_url + "/SIKBREC/public/aRegistrasiRajal/getDataListODCPasien", // URL file untuk proses select datanya
               "type": "POST",
              // data: function ( d ) {
              // d.TglAwal = PeriodeAwal;
               //d.TglAkhir = PeriodeAkhir;
               // d.custom = $('#myInput').val();
               // etc
              // },
                "dataSrc": "",
           "deferRender": true,
           }, 
           "columns": [
           
               { "data": "NoMR" }, // Tampilkan telepon
               { "data": "PatientName" }, // Tampilkan alamat
               { "data": "VisitDate" },  // Tampilkan nama
               { "data": "NoRegistrasi" },  // Tampilkan nama 
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                     var html = ""
                       if(row.Status == "Close"){ 
                           var html  = '<span class="badge badge-secondary">'+row.Status+'</span> '
                       }else if(row.Status == "New"){ // Jika bukan 1
                           var html  = '<span class="badge badge-success">'+row.Status+'</span> '
                       }else if(row.Status == "Payment"){ // Jika bukan 1
                           var html  = '<span class="badge badge-warning">'+row.Status+'</span> '
                       }else if(row.Status == "Lunas"){ // Jika bukan 1
                           var html  = '<span class="badge badge-danger">'+row.Status+'</span> '
                       }else{ // Jika bukan 1
                           var html  = '<span class="badge badge-info">'+row.Status+'</span> '
                       }
                          return html 
                   }
               },
               { "data": "NamaDokter" },  // Tampilkan nama
               { "data": "DokterDPJP" },  // Tampilkan nama 
               { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                     var html = ""

                     if(row.NoSEP == null || row.NoSEP == ''){
                       var nosep = ''
                     }else{
                       var nosep = '<b>(No SEP:'+row.NoSEP+'</b>)'
                     }

                      var html  = row.NamaPerusahaan+'<br>'+nosep
                          return html 
                   }
               },
               { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                     var html = ""
                      
                   var html = '<button type="button" class="btn btn-primary border-primary btn-animated btn-xs"  onclick="PrintSPR(' + row.IDSpr + ')" ><span class="visible-content" > Print</span><span class="hidden-content"><i class="glyphicon glyphicon-print"></i></span></button><button type="button" class="btn btn-success border-success btn-animated btn-xs"  onclick="RegistrasiODC(' + row.IDSpr + ')" ><span class="visible-content" > Registrasi</span><span class="hidden-content"><i class="glyphicon glyphicon-log-in"></i></span></button>'
                          return html 
                   }
               },
           ],
       });
} 
function PrintSPR(idParams){
    var notrs = idParams; 
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/aRegistrasiRajal/PrintODC/" + notrs , "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
}

/*
function showID(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/aRegistrasiRanap/' + str;
}
*/
function ShowDataRegistrasiSPRI(str){
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/SPRI/CreateSPRI/' + str;
}

function RegistrasiODC(str){
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/aRegistrasiRajal/RegistrasiODC/'+str;
}

async function showID(str) {
    try {   
        const datagetStatusRegRajal = await getStatusRegRajal(str);;
        updateUIdatagetStatusRegRajal(datagetStatusRegRajal);
    
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIdatagetStatusRegRajal(datagetStatusRegRajal) {
        let response = datagetStatusRegRajal;
        if (response.status == "success") {
            //toast(response.message, "success")
            const base_url = window.location.origin;
            var str = btoa(response.idspr);
            window.location = base_url + '/SIKBREC/public/aRegistrasiRanap/' + str;
        }else{
            toast(response.message, "error")
        }  
    }

function getStatusRegRajal(str) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiRanap/getStatusRegRajal/';
    return fetch(url, {
    method: 'POST',
    headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    },
    body: 'id=' + str
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(response.statusText)
        }
        return response.json();
    })
    .then(response => {
        
        //console.log(response)
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

    })/*.catch((err) =>{
        console.log(err, "error")
        console.log(err,'aaa');
        toast(err,"error")
    })*/
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