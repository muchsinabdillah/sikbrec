
$(document).ready(function () {
    var base_url = window.location.origin;
    var nomorrujukan = document.getElementById('nomorrujukan')
    var kodediagnosa = document.getElementById('diagnosarujukanKhusus')
    var kodeprosedur = document.getElementById('prosedurRujukanKhusus')
    var tipediagnosa = document.getElementById('tipediagnosa')
    var IdTrsAuto = document.getElementById('IdTrsAuto')
    var namaprosedur
    var namadiagnosa
    var user = namauser
    const diagnosa_level = [];
    const diagnosa_kode = [];
    const kirimlevel = [];
    const datadiagnosadikirim = [];
    disableform();
    $('#diagnosarujukanKhusus').on('select2:select', function (e) {
        var data = e.params.data;  
        $("#diagnosarujukanKhususkode").val(data.id);
        $("#diagnosarujukanKhususName").val(data.text);
    });
    $('#prosedurRujukanKhusus').on('select2:select', function (e) {
        var data = e.params.data;
        $("#prosedurRujukanKhususKode").val(data.id);
        $("#prosedurRujukanKhususName").val(data.text);
    });
    // kondisi ketika tipe rujukan 2
    $('#btnVoidTrsReg').click(function () {
        voidHeaderRujukan();
    });
    $('#btnVoidDtlRuj').click(function () {
        voidDeetilRujukan();
    });
    
    $("#polirujukan").select2({
        ajax: {
            url: function (params) {
                return window.location.origin + '/SIKBREC/public/Rujukan/getPoli'
            },
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    nama: params.term,
                    // nama: childdokter.value,
                    // isJenisPelayananBPJS: $('#isJenisPelayananBPJS').val()
                };
            },
            processResults: function (response) {
                var dataresponse = response
                console.log(dataresponse)
                return {
                    results: $.map(dataresponse, function (item) {
                        return {
                            text: item.text,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        },

        placeholder: 'Cari Prosedur',
        minimumInputLength: 3

    });
    $("#diagnosarujukanKhusus").select2({
        ajax: {

            url: function (params) {
                return window.location.origin + '/SIKBREC/public/LembarPengajuanKlaim/GetDataDiagnosa'
            },
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                // console.log(child.value)
                return {
                    searchTerm: params.term,
                    // nama: child.value,
                    // isJenisPelayananBPJS: $('#isJenisPelayananBPJS').val()
                };
            },
            processResults: function (response) {
                var dataresponse = response
                console.log(dataresponse)
                return {
                    results: $.map(dataresponse.diagnosa, function (item) {
                        return {
                            text: item.nama,
                            id: item.kode
                        }
                    })
                };
            },
            cache: true
        },

        placeholder: 'Cari Diagnosa',
        minimumInputLength: 3

    })
    $("#prosedurRujukanKhusus").select2({
        ajax: {
            url: function (params) {
                return window.location.origin + '/SIKBREC/public/LembarPengajuanKlaim/GetDataProcedure'
            },
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term,
                    nama: $('.select2-search__field').val(),
                    // isJenisPelayananBPJS: $('#isJenisPelayananBPJS').val()
                };
            },
            processResults: function (response) {
                var dataresponse = response
                console.log(dataresponse.procedure)
                return {
                    results: $.map(dataresponse.procedure, function (item) {
                        return {
                            text: item.nama,
                            id: item.kode
                        }
                    })
                };
            },
            cache: true
        },

        placeholder: 'Cari Prosedur',
        minimumInputLength: 3

    });


    $('#btnsimpans').click(function (e) {
        $(".preloader").fadeOut();
        e.preventDefault()
        var formData = {
            nomorrujukan: nomorrujukan.value,
            kodediagnosa: kodediagnosa.value,
            kodeprosedur: kodeprosedur.value,
            datadiagnosa: diagnosa_kode,
            tipediagnosa: tipediagnosa.value,
            user: namauser
        }
        // console.log($("#diagnosa").val())
        $.ajax({
            type: "POST",
            url: base_url + '/SIKBREC/public/Rujukan/InputRujukanKhusus',
            data: formData,
            dataType: "json",
            encode: true,
        }).done(function (data) {
            // console.log(data)
            if (data.status == "warning") {
                // alert(data.errorname,data.metadata.message)
                swal({
                    title: "error",
                    text: data.metadata.message,
                    icon: "error",
                })
            } else {
                swal({
                    title: "success",
                    text: "berhasil",
                    icon: "success",
                })
            }
        })
        $(".preloader").fadeOut();
    });

    $('#inputdiagnosa').click(function (e) {
        e.preventDefault()

        inputdiagnosa()
    })
    $('#btnaddDetila').click(function (e) {
        e.preventDefault()

        newElement()
    });
    $('#btnsimpan').click(function (e) {
        e.preventDefault()

        swal({
            title: "Konfirmasi",
            text: "Pastikan Semua Data Rujukan Sudah Terisi dengan benar, Apakah Anda ingin Lanjutkan?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    //$(".preloader").fadeIn();
                    var formData = {
                        nomorrujukan: nomorrujukan.value,
                        IdTrsAuto: IdTrsAuto.value

                    }
                    // console.log($("#diagnosa").val())
                    $.ajax({
                        type: "POST",
                        url: base_url + '/SIKBREC/public/Rujukan/insertDataRujukanKhusus',
                        data: formData,
                        dataType: "json",
                        encode: true,
                    }).done(function (data) {
                        console.log(data)
                        if (data.status == "warning") {
                            // alert(data.errorname,data.metadata.message)
                            swal({
                                title: "Oops..",
                                text: data.errorname,
                                icon: "error",
                            })
                        } else if (data.status == "blank") {
                            // alert(data.errorname,data.metadata.message)
                            swal({
                                title: "Oops..",
                                text: data.message,
                                icon: "error",
                            })
                        } else {
                            swal('Good job!', "Data Rujukan berhasil di buat" + data.rujukan.noRujukan + "Tanggal Rujukan " + data.rujukan.tglRujukan, "success")
                                .then((value) => {
                                    location.reload();
                                });
                        }
                        $(".preloader").fadeOut();
                    })
                } else {
                    swal("Canceled!");
                    $(".preloader").fadeOut();
                }
            });

    });
});

function disableform() {
    document.getElementById("btnaddDetila").disabled = true;
    document.getElementById("btnsimpan").disabled = true;
    
}
function enableform() {
    document.getElementById("btnaddDetila").disabled = false;
    document.getElementById("btnsimpan").disabled = false; 
    $('#tipediagnosa').select2();
}
 

async function newTransaction() {
    try {
        const dataCreatePRB = await CreateRujukanKhususTRS();
        updateUICreateRujukanKhusus(dataCreatePRB);
    } catch (err) {
       // toast(err.message, "error")
        swal("Oops", "Sorry.." + err, "error");
    }
}
function updateUICreateRujukanKhusus(params) {
    let response = params;
    if (response.status == "success") {
       // toast(response.message, "success")
        $("#IdTrsAuto").val(response.idhdrjkkhusus);
        if (response.StausBridging == "0"){
            $("#StausBridging").val("NEW");
        }
        enableform();
      //  asyncShowMain();

    } else {
        //toast(response.message, "error")
        swal({
            title: "Oops..",
            text: esponse.message,
            icon: "error",
        })
    }

}
function CreateRujukanKhususTRS() {
    var str = $("#frmsimpanrujukankhusus").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Rujukan/CreateRujukanKhususTRS';
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

        })
}
async function newElement() {
    try {
        const dataCreatePRB = await CreateRujukanKhususTRSdetil();
        updateUICreateRujukanKhususTRSdetil(dataCreatePRB);
    } catch (err) {
        // toast(err.message, "error")
        swal("Oops", "Sorry.." + err, "error");
    }
}
function updateUICreateRujukanKhususTRSdetil(params) {
    let response = params;
    if (response.status == "success") {
        //swal("Success", "Berhasil Di Tambahkan !", "success");
        $("#diagnosarujukanKhususkode").val('');
        $("#diagnosarujukanKhususName").val('');
        $("#prosedurRujukanKhususKode").val('');
        $("#prosedurRujukanKhususName").val('');
        // toast(response.message, "success")
        //$("#IdTrsAuto").val(response.idhdrjkkhusus);
        //  asyncShowMain();
        getListRujukanKhusus();
    } else {
        //toast(response.message, "error")
        swal({
            title: "Oops..",
            text: esponse.message,
            icon: "error",
        })
    }

}
function CreateRujukanKhususTRSdetil() {
    var str = $("#frmsimpanrujukankhusus").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Rujukan/CreateRujukanKhususTRSdetil';
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

        })
}
function getListRujukanKhusus() {
    var IdTrsAuto = $("#IdTrsAuto").val();
    //console.log('NoSRB');
    var base_url = window.location.origin;
    $('#tbllistrujukankhusus').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#tbllistrujukankhusus').DataTable({
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/Rujukan/getListRujukanKhusus/",
            "type": "POST",
            "data": { IdTrsAuto: IdTrsAuto },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.No + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.DIAGNOSA_TIPE + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.DIAGNOSA_NAME + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.PROCEDURE_NAME + ' </font>  ';
                    return html
                }
            }, 

            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" id="btndelete" name="btndelete" class="btn btn-danger border-danger btn-animated btn-wide"  onclick="ConfirmDeleteDtl(' + row.ID + ')" ><span class="visible-content" >Delete</span><span class="hidden-content"><i class="fa fa-trash"></i></span></button>'
                    return html
                },
            },
        ]
    });
}

function GoMonitoringBPJS() {
    var MTglKunjunganBPJS = $("[name='PengSEP_Tgl']").val(); 
    var base_url = window.location.origin;
    $('#tbl_kunjungan_monitoring').DataTable().clear().destroy();
    $('#tbl_kunjungan_monitoring').DataTable({
        "ordering": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/Rujukan/GoListRujukanData",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.MTglKunjunganBPJS = MTglKunjunganBPJS; 
            }
        },
        "columns": [
            { "data": "NO_RUJUKAN" },
            { "data": "NAMA_PASIEN" },
            { "data": "NO_KARTU" },
            { "data": "KODE_DIAGNOSA" },
            { "data": "TGL_RUJUKAN_AWAL" },
            { "data": "TGL_RUJUKAN_AKHIR" }, 
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    if (row.SEND_BRIDGE == "0") {
                        var html = ""
                        var html = '<span class="label label-danger" > SUDAH BRIDGING </span> ';
                        return html
                    } else {
                        var html = ""
                        var html = '<font size="1"> ' + row.nama + ' </font> <br><br><span class="label label-info"> BELUM BRIDGING  </span> ';
                        return html
                    }

                }
            },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-default border-primary btn-animated btn-xs"  onclick=\'ShowDataPasienPoliklinik("' + row.ID + '","' + row.NO_RUJUKAN + '","' + row.SEND_BRIDGE + '")\' ><span class="visible-content" > Pilih </span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },
        ]
    });

}

function ShowDataPasienPoliklinik(str, NO_RUJUKAN,SEND_BRIDGE) {
    $("#IdTrsAuto").val(str);
    $("#noregbatal").val(str);
    $("#nomorrujukan").val(NO_RUJUKAN);
    if(SEND_BRIDGE=="0"){
        $("#StausBridging").val("NEW");
    } else if (SEND_BRIDGE == "1") {
        $("#StausBridging").val("SEND");
    }
    enableform();
    $("#modal_Pengajuan").modal('hide');
    getListRujukanKhusus();
}
async function voidHeaderRujukan() {
    try {
        const datavoidAllRujukanKhusus = await voidAllRujukanKhusus();
        updateUIvoidAllRujukanKhusus(datavoidAllRujukanKhusus);
    } catch (err) {
        // toast(err.message, "error")
        swal("Oops", "Sorry.." + err, "error");
    }  
}
async function voidDeetilRujukan() {
    try {
        const datavoidAllRujukanKhususDTL = await voidAllRujukanKhususDTL();
        updateUIdatavoidAllRujukanKhususDTL(datavoidAllRujukanKhususDTL);
    } catch (err) {
        // toast(err.message, "error")
        swal("Oops", "Sorry.." + err, "error");
    }
}
function updateUIdatavoidAllRujukanKhususDTL(params) {
    let response = params;
    if (response.status == "success") {
        swal('Good job!', "Data Rujukan berhasil di Batalkan !", "success")
            .then((value) => {
                $("#modal_alert_batal_dtl").modal('hide');
                getListRujukanKhusus();
            });
    } else {
        //toast(response.message, "error")
        swal({
            title: "Oops..",
            text: esponse.message,
            icon: "error",
        })
    }

}
function voidAllRujukanKhususDTL() {

    var str = $("#frmBatalDtl").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Rujukan/voidAllRujukanKhususDTL';
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

        })
}
function voidAllRujukanKhusus() {
 
    var str = $("#frmBatalHdr").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Rujukan/voidAllRujukanKhusus';
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

        })
}

function ConfirmDeleteDtl(data) {
    $("#noregbataldtl").val(data);
    $("#modal_alert_batal_dtl").modal('show');
}