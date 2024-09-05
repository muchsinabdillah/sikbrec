$(document).ready(function () {
    asyncShowMain();
    // format number to price
    //convertNumberToRp();
    // buton save ditekan
    const saveButton = document.querySelector('#btnreservasi');
    saveButton.addEventListener('click', async function () {
        try {
            const result = await saveTrs();
            if (result.status == "success") {
                toast(result.message, "success")
                setTimeout(function () { MyBack(); }, 1000);
            }
        } catch (err) {
            toast(err, "error")
        }
    });



    const saveButtonx = document.querySelector('#btnSave');
    saveButtonx.addEventListener('click', async function () {
        try {
            const result = await saveTarifAddLayanan();
            if (result.status == "success") {
                toast(result.message, "success")
                //setTimeout(function () { MyBack(); }, 1000);
                //asyncShowMain();
                location.reload();

            }

        } catch (err) {

            toast(err, "error")
        }
    })

    $("#btnAdd").click(function(e) {
        e.preventDefault();
        $('#form_detail')[0].reset();
        var kodetes = $("#IdAuto").val();
        $("#KodeTesDetail").val(kodetes)


    });
    
});
async function asyncShowMain() {
    try {
        const datagetDatabyID = await getDatabyID();
        updateUIdatagetDatabyID(datagetDatabyID);

         getListDataOrderDetails();
         const datagetParameterUsia = await getParameterUsia(); 
         updateUIdatagetParameterUsia(datagetParameterUsia);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatagetDatabyID(datagetDatabyID){
    let dataResponse = datagetDatabyID;

        $("#IdAuto").val(convertEntities(dataResponse.data.KodeTes));
        $("#KodeKelompok").val(convertEntities(dataResponse.data.KodeKelompok));
        $("#KodeAlat").val(convertEntities(dataResponse.data.KodeAlat));
         $("#NamaTes").val(convertEntities(dataResponse.data.NamaTes));
         $("#NamaTes1").val(convertEntities(dataResponse.data.NamaTes1));
         $("#Jenis").val(convertEntities(dataResponse.data.Jenis));
         $("#JenisSample").val(convertEntities(dataResponse.data.JenisSample));
         $("#Satuan").val(convertEntities(dataResponse.data.Satuan));
         $("#Satuan1").val(convertEntities(dataResponse.data.Satuan1));
         $("#Kelompok").val(convertEntities(dataResponse.data.Kelompok));
         $("#Hasil").val(convertEntities(dataResponse.data.Hasil));

        $("#L60_LP").val(convertEntities(dataResponse.data.L60_LP));
         $("#L60_DIGIT").val(convertEntities(dataResponse.data.L60_DIGIT));
         $("#Currency").val(convertEntities(dataResponse.data.Currency));
         $("#JenisHsl").val(convertEntities(dataResponse.data.JenisHsl));
         $("#Pecahan").val(convertEntities(dataResponse.data.Pecahan));
         $("#ExtenNR").val(convertEntities(dataResponse.data.ExtenNR));
         $("#Header").val(convertEntities(dataResponse.data.Header));
         $("#TempHasilM").val(convertEntities(dataResponse.data.TempHasilM));

}
function getDatabyID() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataTarif/getTindakanLabbyID/';
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
            $(".preloader").fadeOut();
        })
}

function saveTrs() {
    $(".preloader").fadeIn();
    $('#btnreservasi').html('Please Wait...');
    $('#btnreservasi').addClass('btn-danger');
    document.getElementById("btnreservasi").disabled = true;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataTarif/saveTrsTindakan_Lab/';
    var form_data = $("#form_cuti").serialize();
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: form_data
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
            $('#btnreservasi').removeClass('btn-danger');
            $('#btnreservasi').html('Submit');
            document.getElementById("btnreservasi").disabled = false;
        })
}

function getListDataOrderDetails() { 
    var base_url = window.location.origin;
    var IdAuto = $("#IdAuto").val();
    $('#datalayanan').dataTable({
        "bDestroy": true
    }).fnDestroy();
       $('#datalayanan').DataTable({
         'ajax':
    {
        "url": base_url + "/SIKBREC/public/MasterDataTarif/getListTindakanLab_NilaiRujukan", // URL file untuk proses select datanya
        "type": "POST",
        data: function (d) {
         d.IdAuto = IdAuto
     },
         "dataSrc": "",
    "deferRender": true,
    }, 
    "columns": [
                            { "data": "RecordID" },
                            { "data": "ParameterUsia" },
                            { "data": "U1" },
                            { "data": "U2" },
                            { "data": "G" },
                            { "data": "JenisSample" },
                            { "data": "NilaiRujukanAwal" },
                            { "data": "NilaiRujukanAkhir" },
                            { "data": "SatuanRujukan" },
                            { "data": "NilaiRujukanTeks" },
                            { "data": "BatasAtas" },
                            { "data": "BatasBawah" },
                            {
                                "render": function (data, type, row) {
                                    var html = ""
                                    var html = '<button type="button" class="btn btn-default btn-xs"  onclick="ViewDetail(' + row.RecordID + ')" >View</button>&nbsp<button type="button" class="btn btn-danger btn-xs"  onclick="DeleteLayanan(' + row.RecordID + ')" >Delete</button>'
                                    return html
                                },
                            },
                           ],
     });
} 

async function saveTarifAddLayanan() {

    $(".preloader").fadeIn();
    $('#btnSave').html('Please Wait...');
    $('#btnSave').addClass('btn-danger');
    document.getElementById("btnSave").disabled = true;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataTarif/addNilaiRujukan';

    // data form
    var form_data = $("#form_detail").serialize();
    //console.log('sss');return false;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: form_data
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
            $('#btnSave').removeClass('btn-danger');
            $('#btnSave').html('Submit');
            document.getElementById("btnSave").disabled = false;
        })

}

async function DeleteLayanan(idTarif_2){
    let DataId = idTarif_2;
    await GoDelete(DataId);
    await getListDataOrderDetails();
}

function GoDelete(DataId){
    $(".preloader").fadeIn();
    $('#btnSave').html('Please Wait...');
    $('#btnSave').addClass('btn-danger');
    document.getElementById("btnSave").disabled = true;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataTarif/deleteLabRujukan';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        }, 
        body: 'id=' + DataId
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
            $('#btnSave').removeClass('btn-danger');
            $('#btnSave').html('Submit');
            document.getElementById("btnSave").disabled = false;
            toast('Item Berhasil Dihapus', "success")
        })
}

async function ViewDetail(param) {
    try {
        const datagetDataDetailbyID = await getDataDetailbyID(param);
        updateUIdatagetDataDetailbyID(datagetDataDetailbyID);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatagetDataDetailbyID(datagetDatabyID){
    let dataResponse = datagetDatabyID;
        $("#ViewDetail").modal('show');

        $("#IdAuto_detail").val(convertEntities(dataResponse.data.RecordID));
        $("#KodeTesDetail").val(convertEntities(dataResponse.data.KodeTes));
        $("#ParameterLab").val(convertEntities(dataResponse.data.ParameterUsia)).trigger('change');
         $("#U1").val(convertEntities(dataResponse.data.U1));
         $("#U2").val(convertEntities(dataResponse.data.U2));
         $("#G").val(convertEntities(dataResponse.data.G));
         $("#JenisSample_Detail").val(convertEntities(dataResponse.data.JenisSample));
         $("#NRAwal").val(convertEntities(dataResponse.data.NilaiRujukanAwal));
         $("#NRAkhir").val(convertEntities(dataResponse.data.NilaiRujukanAkhir));
         $("#SatuanRujukan_Detail").val(convertEntities(dataResponse.data.SatuanRujukan));
         $("#Catatan").val(convertEntities(dataResponse.data.NilaiRujukanTeks));
         $("#BatasAtas").val(convertEntities(dataResponse.data.BatasAtas));
        $("#BatasBawah").val(convertEntities(dataResponse.data.BatasBawah));

}
function getDataDetailbyID(param) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataTarif/getDataDetailbyID/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'id=' + param
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

function updateUIdatagetParameterUsia(datagetGrupPerawatan) {
    let data = datagetGrupPerawatan;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#ParameterLab").append(newRow);
        for (i = 0; i < data.length; i++) {
            var newRow = '<option value="' + data[i].PAID + '">' + data[i].NamaParameter + '</option';
            $("#ParameterLab").append(newRow);
        }
    }
}
function getParameterUsia() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataTarif/getParameterUsia';
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
            //$("#ParameterLab").select2();
            //console.log('sssssss');return false;
        })
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
function convertEntities($data) {
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
}
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/MasterDataTarif/listlab";
}