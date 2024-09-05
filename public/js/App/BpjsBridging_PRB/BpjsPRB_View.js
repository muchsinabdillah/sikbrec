$(document).ready(function () { 

    // CARI POLIKLINIK
    // $("#cariPoliklinikBPJS").select2({
    //     ajax: {
    //         url: function (params) {
    //             return window.location.origin + '/SIKBREC/public/xBPJSBridging/GoGetPoliklinikBPJS'
    //         },
    //         type: "post",
    //         dataType: 'json',
    //         delay: 250,
    //         data: function (params) {
    //             return {
    //                 searchTerm: params.term
    //             };
    //         },
    //         processResults: function (response) {
    //             return {
    //                 results: response
    //             };
    //         },
    //         cache: true
    //     },

    //     placeholder: 'Search for a repository',
    //     minimumInputLength: 3
    // });

    //CARI DOKTER
    // $("#cariDokterBPJS").select2({
    //     ajax: {
    //         url: function (params) {
    //             return window.location.origin + '/SIKBREC/public/xBPJSBridging/GoGetDokterBPJS'
    //         },
    //         type: "post",
    //         dataType: 'json',
    //         delay: 250,
    //         data: function (params) {
    //             return {
    //                 searchTerm: params.term,
    //                 IdPoliklinik: $('#cariPoliklinikBPJS').val(),
    //                 isJenisPelayananBPJS: '2'//$('#isJenisPelayananBPJS').val()
    //             };
    //         },
    //         processResults: function (response) {
    //             return {
    //                 results: response
    //             };
    //         },
    //         cache: true
    //     },

    //     placeholder: 'Search for a repository',
    //     minimumInputLength: 3
    // });

    //CARI OBAT
    $("#ObatPRB").select2({
        ajax: {
            url: function (params) {
                return window.location.origin + '/SIKBREC/public/xBPJSBridging_PRB/GoGetObatPRB'
            },
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term,
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            results:function(response){
                console.log('response');
            },
            cache: true
        },

        placeholder: 'Search for a repository',
        minimumInputLength: 3
    });

    $('#cariPoliklinikBPJS').on('select2:select', function (e) {
        var data = e.params.data;
        $("#KodePoliklinikBPJS").val(data.id);
        $("#NamaPoliklinikBPJS").val(data.text);
    });

    $('#cariDokterBPJS').on('select2:select', function (e) {
        var data = e.params.data;
        $("#KodeDokterBPJS").val(data.id);
        $("#NamaDokterBPJS").val(data.text);
    });

    $('#ObatPRB').on('select2:select', function (e) {
        var data = e.params.data;
        $("#KodeObatPRB").val(data.id);
        $("#NamaObatPRB").val(data.text);
    });

    $('#ProgramPRB').on('select2:select', function (e) {
        var data = e.params.data;
        $("#KodeProgramPRB").val(data.id);
        $("#NamaProgramPRB").val(data.text);
    });

    $('#createprb').click(function () {
            swal({
                title: "Simpan",
                text: "Apakah Anda ingin Simpan?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                            goCreatePRB();
                    } else {
                       // swal("Transaction Rollback !");
                    }
                });
    });

    $('#btnBatal').click(function () {
        swal("Alasan Batal:", {
            content: "input",
            buttons:true,
          })
          .then((value) => {
              if (value == '' ){
                swal("Alasan Batal Harus Diisi ! Batal Gagal !");
                return false;
              }else if (value == null){
                return false;
              }
           // swal(`You typed: ${value}`);
           goDeleteHdr(value);
          });
});

    const addbtn = document.querySelector('#add_row');
    addbtn.addEventListener('click', async function () {
        try {
            const result = await addObatPRB();
            if (result.status == "success") {
                toast(result.message, "success");
                $("#ObatPRB").val('');
                $("#KodeObatPRB").val('');
                $("#NamaObatPRB").val('');
                $("#QtyObat").val('');
                $("#Signa1").val('');
                $("#Signa2").val('');
                getObatDtlPRB();
            }
        } catch (err) {

            toast(err.message, "error")
        }
    });


    asyncShowMain();
    //getObatDtlPRB();
    
    // buton save ditekan
    const saveButton = document.querySelector('#savetrs');
    saveButton.addEventListener('click', async function () {
        try {
            const result = await SaveTrs();
            if (result.status == "success") {
                toast("Prb Berhasil Diinput. No. SRB : " + result.noSRB, "success")
                setTimeout(function () { MyBack(); }, 2000);
            }
        } catch (err) {
            toast(err.message, "error")
        }
    })
    
});

 async function addObatPRB() {
    $(".preloader").fadeIn();
    $('#add_row').html('Please Wait...');
    $('#add_row').addClass('btn-danger');
    document.getElementById("add_row").disabled = true;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/xBPJSBridging_PRB/addObatPRB';

    // data form
    var form_data = $("#form_input").serialize();
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
            $('#add_row').removeClass('btn-danger');
            $('#add_row').html('Add');
            document.getElementById("add_row").disabled = false;
        })

}

async function goCreatePRB() {
    try {
        const dataCreatePRB = await CreatePRB();
        updateUIdataCreatePRB(dataCreatePRB);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdataCreatePRB(params) {
    let response = params;
    if (response.status == "success") {
        toast(response.message, "success")
        //$("#idhdr_bpjs").val(response);
        asyncShowMain();

    }else{
        toast(response.message, "error")
    }  

}
function CreatePRB() {
    var str = $("#form_input").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/xBPJSBridging_PRB/CreatePRB';
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

 function getObatDtlPRB(){
    var idhdr_bpjs = $("#idhdr_bpjs").val();
    //console.log('NoSRB');
    var base_url = window.location.origin;
    $('#tabelobatdtl').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#tabelobatdtl').DataTable({
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/xBPJSBridging_PRB/getObatDtlPRB/",
            "type": "POST",
            "data": { idhdr_bpjs: idhdr_bpjs },
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
                    var html = '<font size="1"> ' + row.KODE_OBAT + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.NAMA_OBAT + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.QTY + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.SIGNA1 + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.SIGNA2 + ' </font>  ';
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

async function SaveTrs() {
    $(".preloader").fadeIn();
    var nosrb = $("#NoSRB").val();
    if (nosrb == '' || nosrb == null){
        GoTo = 'GoSimpanPRB';
    }else{
        GoTo = 'GoUpdatePRB';
    }
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/xBPJSBridging_PRB/' + GoTo;

    // data form 
    // var idhdr_bpjs = document.getElementById("idhdr_bpjs").value;
    var str = $("#form_input").serialize();

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
            $(".preloader").fadeOut();
          //  $('#btnreservasi').removeClass('btn-danger');
          //  $('#btnreservasi').html('Submit');
          //  document.getElementById("btnreservasi").disabled = false;
        })
}
async function asyncShowMain() {
    try {
        const datagetDataPRB = await getDataPRB();
        updateUIgetDataPRB(datagetDataPRB);
        const datagetProgramPRB = await getProgramPRB();
        updateUIgetProgramPRB(datagetProgramPRB);
         getObatDtlPRB();
    } catch (err) {
        toast(err.message, "error")
    }
}
function updateUIgetDataPRB(params) {
    let data = params;
        $("#NoMR").val(data.NoMR);
        $("#NamaPasien").val(data.PatientName);
        $("#NoEpisode").val(data.NoEpisode);
        $("#TglLahir").val(data.Date_of_birth);
        $("#Alamat").val(data.Address);
        $("#NoSEP").val(data.NoSEP);
        $("#NoKartuBPJS").val(data.NoPesertaBPJS);
        $("#PasienPekerjaan").val(data.Ocupation);
        $("#Email").val(data.email);
        $("#NoRegistrasi").val(data.NoRegistrasi);
        $("#NoSRB").val(data.NO_SRB);
        $("#idhdr_bpjs").val(data.ID_HDR_BPJS);

        $("#KodePoliklinikBPJS").val(data.KODE_POLI);
        $("#NamaPoliklinikBPJS").val(data.NAMA_POLI);
        $("#KodeDokterBPJS").val(data.KODE_DOKTER);
        $("#NamaDokterBPJS").val(data.NAMA_DOKTER);
        $("#KodeProgramPRB").val(data.KODE_PROGRAM_PRB);
        $("#NamaProgramPRB").val(data.NAMA_PROGRAM_PRB);
        
        $("#Keterangan").val(data.KETERANGAN);
        $("#Saran").val(data.SARAN);

        $("#KodeDokterBPJS").val(data.ID_Dokter_BPJS);
        $("#NamaDokterBPJS").val(data.NAMA_Dokter_BPJS);
        $("#KodePoliklinikBPJS").val(data.CodeSubBPJS);
        $("#NamaPoliklinikBPJS").val(data.NamaBPJS);
        $("#KeteranganPRB").val(data.KETERANGAN_PRB);
        
        if (data.ID_HDR_BPJS == null || data.ID_HDR_BPJS == ''){
            $("#createprb").attr('disabled',false);
            $("#inputobat").hide();

        }else{
            $("#createprb").attr('disabled',true);
            $("#inputobat").show();
        }
}
function getDataPRB() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/xBPJSBridging_PRB/GetregistrasiRajalbyId/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'IdRegistrasi=' + $("#IdAuto").val()
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
            $("#GruptarifKarcis").select2();
            $("#StatusKarcis").select2(); 
        })
}

function updateUIgetProgramPRB(datagetProgramPRB) {
    let responseApi = datagetProgramPRB;
    //console.log(datagetKelas);
    if (responseApi.data !== null && responseApi.data !== undefined) {
        //console.log(responseApi.data);
        //var newRow = '<option value="">-- PILIH --</option';
        $("#ProgramPRB").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].id + '">' + responseApi.data[i].text + '</option';
            $("#ProgramPRB").append(newRow);
        }
    }
    }
    function getProgramPRB() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/xBPJSBridging_PRB/GoGetProgramPRB';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        //body: 'id=' + $("#IdAuto").val()
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
            $("#ProgramPRB").select2(); 
        })
    }

    function ConfirmDeleteDtl(id){
        swal({
            title: "Simpan",
            text: "Apakah Anda ingin Hapus ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    DeleteRow(id);
                }
            });
    }

    async function DeleteRow(IDDTL){
        let DataId = IDDTL;
        await GoDelete(DataId);
        getObatDtlPRB();
    }
    function GoDelete(DataId){
        $(".preloader").fadeIn();
        var base_url = window.location.origin;
        let url = base_url + '/SIKBREC/public/xBPJSBridging_PRB/GoBatalPRBDtl';
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
            })
    }

    async function goDeleteHdr(alasan) {
        try {
            const dataDeleteHdr = await DeleteHdr(alasan);
            updateUIdataTrs(dataDeleteHdr);
        } catch (err) {
            toast(err.message, "error")
        }
    }
    
    
    function DeleteHdr(alasan) {
        
        var str = $("#idhdr_bpjs").val();
        var base_url = window.location.origin;
        let url = base_url + '/SIKBREC/public/xBPJSBridging_PRB/GoBatalPRBHdr';
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: 'idhdr_bpjs='+str + '&alasan=' + alasan
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

    function updateUIdataTrs(params) {
        let response = params;
        if (response.status == "success") {
            toast(response.message, "success")
            asyncShowMain();
        }else{
            toast(response.message, "error")
        }  
    
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
    window.location = base_url + "/SIKBREC/public/xBPJSBridging_PRB";
}

function PrintPRB() {
    if ($("#NoSRB").val() == ''){
        swal("Nomor SRB Tidak Ditemukan ! Silahkan Simpan Terlebih Dahulu Hingga Muncul Pesan Sukses !");
        return false;
    }
    const base_url = window.location.origin;
    
    window.open(base_url + "/SIKBREC/public/xBPJSBridging_PRB/PrintPRB/"+$("#idhdr_bpjs").val() , "_blank",
    "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
}