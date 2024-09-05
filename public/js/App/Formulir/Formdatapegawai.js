$(document).ready(function () {
    onloadForm();
});

async function onloadForm() {
    await showdatatabel();
}
function showdatatabel() {
    const base_url = window.location.origin;
    $(".preloader").fadeOut();
    $('#example').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#example').DataTable({
        "ordering": false,
        "ajax": {
            "url": base_url + "/SIKBREC/public/FormDataPegawai/getListFormdatapegawai",
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [

            // { "data": "No", render: $.fn.dataTable.render.number('', '', 0, '')  },
            { "data": "NIK" },
            { "data": "NAMA" },
            { "data": "Jenis_Pog" },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
 
                        var html = ""
                    var html = '<button type="button" class="btn btn-primary btn-xs btn-labeled" onclick=\'modalForm("' + row.ID_Data + '")\'>Entri Form<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>';
                        return html
                     
                }
            },
            
        ]
    });
}
function modalForm(nomr){
    $("#IDMedrec").val(nomr);
    $('#myModal').modal('show');
}
// function showInputDataBon(str) {
//     const base_url = window.location.origin;
//     var str = btoa(str);
//     window.location = base_url + '/SIKBREC/public/OrderBonSementara/viewBonSementara/' + str;
// }
// function goInputDataBon() {
//     const base_url = window.location.origin;
//     window.location = base_url + "/SIKBREC/public/OrderBonSementara/viewBonSementara/";
// }
function goFormDataPribadi(){

    var idParams = $("#IDMedrec").val();
  
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/FormDataPegawai/EntriDataPribadi/" + idParams , "_blank" );
        
}

function goFormKeluarga(){

    var idParams = $("#IDMedrec").val();
  
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/FormDataPegawai/EntriDataKeluarga/" + idParams , "_blank" );
}
function goFormPendidikan(){

    var idParams = $("#IDMedrec").val();
  
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/FormDataPegawai/EntriDataPendidikan/" + idParams , "_blank" );
}
function goFormPelatihan(){

    var idParams = $("#IDMedrec").val();
  
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/FormDataPegawai/EntriDataPelatihan/" + idParams , "_blank" );
}
function goFormSIP(){

    var idParams = $("#IDMedrec").val();
  
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/FormDataPegawai/EntriDataSIP/" + idParams , "_blank" );
}
function goFormSTR(){

    var idParams = $("#IDMedrec").val();
  
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/FormDataPegawai/EntriDataSTR/" + idParams , "_blank" );
}

function goFormMCU(){

    var idParams = $("#IDMedrec").val();
  
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/FormDataPegawai/EntriDataMCU/" + idParams , "_blank" );
}

function goFormMOU(){

    var idParams = $("#IDMedrec").val();
  
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/FormDataPegawai/EntriDataMOU/" + idParams , "_blank" );
}

function goFormSKPegawai(){

    var idParams = $("#IDMedrec").val();
  
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/FormDataPegawai/EntriDataSKPegawai/" + idParams , "_blank" );
}

function goFormRKK(){

    var idParams = $("#IDMedrec").val();
  
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/FormDataPegawai/EntriDataRKK/" + idParams , "_blank" );
}

function goFormSPK(){

    var idParams = $("#IDMedrec").val();
  
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/FormDataPegawai/EntriDataSPK/" + idParams , "_blank" );
}


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
