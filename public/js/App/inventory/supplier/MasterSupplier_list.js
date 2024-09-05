$(document).ready(function () {
    onloadForm();
});
async function onloadForm() {
    await getHakAksesByForm(18);
    await showdatatabel();
}
 function showdatatabel() {
     const base_url = window.location.origin;
     $(".preloader").fadeOut();
     $('#example').dataTable({
         "bDestroy": true
     }).fnDestroy();
     $('#example').DataTable({
         "ordering": true,
         "ajax": {
             "url": base_url + "/SIKBREC/public/MasterSupplier/showSupplierAll",
             "dataSrc": "",
             "deferRender": true,
         },
         "columns": [
             {
                 "render": function (data, type, row) {   
                     var html = ""
                     var html = '<font size="1"> ' + row.ID + ' </font>  ';
                     return html
                 }
             },
             {
                 "render": function (data, type, row) {
                     var html = ""
                     var html = '<font size="1"> ' + row.Company + ' </font>  ';
                     return html
                 }
             }, {
                 "render": function (data, type, row) {
                     var html = ""
                     var html = '<font size="1"> ' + row.Address + ' </font>  ';
                     return html
                 }
             }, 
             {
                 "render": function (data, type, row) {
                     var html = ""
                     var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-wide"  onclick="showDataGroupShift(' + row.ID + ')" ><span class="visible-content" >Edit</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                     return html
                 },
             },
         ]
     });
 }
function showDataGroupShift(str) {
    const base_url = window.location.origin;
    var str = btoa(str);
    window.location = base_url + '/SIKBREC/public/MasterSupplier/' + str;
}

function goGroupShiftPages() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/MasterSupplier/";
}