$(document).ready(function () {
    $(".preloader").fadeOut();
    asyncShowMain(); 
    
    $(document).on('click', '#btnpiutanghH', function() {
        var kodejaminan = $("#LedgerPRekanan2").val();
        var tglpiutang = $("#LedgerPTgl2").val();
        var ketpiutang = $("#LedgerPKet2").val();
        var nominalpiutang = $("#LedgerPNominal2").val();
        var LedgerPNoFaktur2 = $("#LedgerPNoFaktur2").val();
        var LedgerPNoRekening = $("#LedgerPNoRekening").val();
        var LedgerPNoPO = $("#LedgerPNoPO").val();
        var LedgerPNanamBank = $("#LedgerPNanamBank").val();
        console.log(kodejaminan);
        console.log(tglpiutang);
        console.log(ketpiutang);
        console.log(nominalpiutang);
        // pasing
        $("#PassLedgerKode").val(kodejaminan);
        $("#PassLedgerTgl").val(tglpiutang);
        $("#PassLedgerKet").val(ketpiutang);
        $("#NominalJurnal").val(nominalpiutang);
        $("#PassKodeFaktur").val(LedgerPNoFaktur2);
        $("#PassLedgerPNoRekening").val(LedgerPNoRekening);
        $("#PassLedgerPNoPO").val(LedgerPNoPO);
        $("#PassLedgerPNanamBank").val(LedgerPNanamBank);
        $('#modal_alert_hutang').modal('hide');
        $("#NominalJurnal").focus();
      });
      $(document).on('click', '#btnpiutanghS', function() {
        var kodejaminan = $("#LedgerPRekanan").val();
        var tglpiutang = $("#LedgerPTgl").val();
        var ketpiutang = $("#LedgerPKet").val();
        var nominalpiutang = $("#LedgerPNominal").val();
        var tipePasien = $("#tipePasien").val();
        var tipepembayaran = $("#tipepembayaran").val();

        // pasing
        $("#PassTipePasien").val(tipePasien);
        $("#PassLedgerKode").val(kodejaminan);
        $("#PassLedgerTgl").val(tglpiutang);
        $("#PassLedgerKet").val(ketpiutang);
        $("#NominalJurnal").val(nominalpiutang);
        $("#PassjenisAsuransi").val(tipepembayaran)

        $('#modal_alert_piutangh').modal('hide');
        $("#NominalJurnal").focus();
      });
 
      $(document).on('change', '#DebetK', function() {
        var row_id = document.getElementById("DebetK").value;
        var FB_LEDGER_P = $("#FB_LEDGER_P").val();
        var FB_LEDGER_H = $("#FB_LEDGER_H").val();
        if (FB_LEDGER_P == "1" && row_id == "DEBET") {
          $('#modal_alert_piutangh').modal('show');
        }

        if (FB_LEDGER_H == "1" && row_id == "KREDIT") {
          $('#modal_alert_hutang').modal('show');
        }
      });
    
    
    $('#savetrs').click(function () {
        swal({
            title: "Simpan",
            text: "Apakah Anda ingin Simpan Transaksi ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    saveTransaksiForm();
                    MyBack();
                   
                } else {
                    swal("Transaction Rollback !");
                }
            });
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
                batalDatabyID(value);
                MyBack();
            });
    });
   
    $('#btnNewjurnal').click(function () {
        createHeaderTrs();
       
     });

    $("#NominalJurnal").keyup(function(event) {
        if (event.keyCode === 13) {
            InsertDtl(); 
        }
    });
     
    $('#modal_alert').click(function () {
        $('#modal_alert_piutangh').modal('show');
    });
    $('#modal_alert_h').click(function () {
        $('#modal_alert_hutang').modal('show');
    });


});
async function saveTransaksiForm() {
    try {
        const dataUpdatesaveTransaksiForm = await UpdatesaveTransaksiForm();
        updateUIdataUpdatesaveTransaksiForm(dataUpdatesaveTransaksiForm);
    } catch (err) {
        //console.log(err);
        toast(err, "error")
    }
}
function updateUIdataUpdatesaveTransaksiForm(params) {
    let response = params;
    // toast(response.message, "success")
    if (response.status == 'success') {
        swal({
            title: "Save Success!",
            text: response.message,
            icon: "success",
        })
        showdatatabel()
    } else if (response.status = 'warning') {
        swal({
            title: 'Warning',
            text: response.message,
            icon: "warning",
        })
    }
    //var noregistrasi = response.NoRegistrasi; ;q
}
function UpdatesaveTransaksiForm() {
    //$(".preloader").fadeIn();
    var base_url = window.location.origin;
    var data = $("#form_hdr").serialize();
    let url = base_url + '/SIKBREC/public/JurnalUmum/SaveJurnalUmum';
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

async function getjaminannama() {
    try
    {
        var getIdJainan = document.getElementById("tipepembayaran").value;
        console.log(getIdJainan);
        const dataGetJaminanById = await GetJaminanById(getIdJainan);
        updateUIGetJaminanById(dataGetJaminanById);
        console.log("datajaminan", dataGetJaminanById);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIGetJaminanById(dataGetJaminanById) {
    let responseApi = dataGetJaminanById;
     
    if (responseApi.data !== null && responseApi.data !== undefined) {
        console.log(responseApi.data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#LedgerPRekanan").empty();
        $("#LedgerPRekanan").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].NamaPerusahaan + '</option';
            $("#LedgerPRekanan").append(newRow);
        }
    }
}
function GetJaminanById(getIdJainan) {
      
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataGroupJaminan/getJaminanByIdGroup';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'idGroupJaminan=' + getIdJainan
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
            $("#tipepembayaran").select2();
            //$("#hide_jaminan").show();
            $('#LedgerPRekanan').select2();
        })
}

async function asyncShowMain() {
    try {
    const datagetRekening = await getRekening();
            updateUIgetRekening (datagetRekening);
            
    
    const datagetSuppliers = await getSuppliers();
        updateUIdatagetSuppliers(datagetSuppliers);

    const datagetNamaUnit = await getNamaUnit();
            updateUIgetNamaUnit(datagetNamaUnit);
            await showdatatabel();
        $(".preloader").fadeOut();
 
    if ($("#Nojurnal").val() != ""){
            disableAll();
        $("#btnNewjurnal").attr('disabled', true);
         $("#btnSave").attr('enableAll', true);
         ShowDataJurnal();
    }
    } catch (err) {
        // toast(err, "error")
    }
}
function updateUIdatagetSuppliers(responseApi) {
    if (responseApi.data !== null && responseApi.data !== undefined) {
        // console.log(responseApi.data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#LedgerPRekanan2").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].Company + '</option>';
            $("#LedgerPRekanan2").append(newRow);
        }
    }
}
    function getSuppliers() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/JurnalUmum/getSuppliers';
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
            $("#LedgerPRekanan2").select2();
        })
}   
    function updateUIgetRekening(datagetRekening) {
        let data = datagetRekening.data;
        // console.log (data)
        if (data !== null && data !== undefined) {
            console.log(data.length);
            var newRow = '<option value="">-- PILIH --</option';
            $("#REKENING").append(newRow);
            for (i = 0; i < data.length; i++) {
                // console.log(data[i].FS_KD_REKENING );
                var newRow = '<option value="' + data[i].FS_KD_REKENING + '">' + data[i].FS_NM_REKENING + '</option';
                $("#REKENING").append(newRow);
            }
        }
    }
    
function getRekening() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/JurnalUmum/getRekening';
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
            $("#REKENING").select2();
        })
    }
    function updateUIgetNamaUnit(datagetNamaUnit) {
            let data = datagetNamaUnit;
            if (data !== null && data !== undefined) {
                // console.log(data);
                var newRow = '<option value="">-- PILIH --</option';
                $("#NamaUnit").append(newRow);
                for (i = 0; i < data.length; i++) {
                    var newRow = '<option value="' + data[i].ID + '">' + data[i].NamaUnit + '</option';
                    $("#NamaUnit").append(newRow);
                }
            }
        }
        function getNamaUnit() {
            var base_url = window.location.origin;
            let url = base_url + '/SIKBREC/public/InfoStok/getNamaUnit';
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
                    $("#NamaUnit").select2();
                })
        }
        function showdatatabel() {
            var NoJurnal = $("#Nojurnal").val()
            const base_url = window.location.origin;
            $(".preloader").fadeOut();
            $('#examplex').dataTable({
                "bDestroy": true
            }).fnDestroy();
            $('#examplex').DataTable({
                "ordering": false,
                "ajax": {
                    "url": base_url + "/SIKBREC/public/JurnalUmum/getDataJurnalUmumTransaksi",
                    "dataSrc": "",
                    "deferRender": true,
                    "type": "POST",
                    data: function ( d ) {
                        d.NoJurnal = NoJurnal;
                       
                       
                        },
                },
                "columns": [
        
                    { "data": "NO" },
                    { "data": "Kode_Rekening" },
                    { "data": "REKENING" },
                    { "data": "Debet" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )},
                    { "data": "Kredit" ,  render: $.fn.dataTable.render.number( '.', ',', 0,'' )},
                    // { "data": "Action" },
               
                    {
                        "render": function (data, type, row) {
                            var html = ""
                            var html = '<button type="button" class="btn btn-danger border-primary btn-animated btn-wide"  onclick=goVoidDetails(' + row.ID + ') ><span class="visible-content" >Hapus</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                            return html
                        },
                    },
                    
                ],
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api(), data;
        
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                 
        
                    total13 = api
                        .column(3)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
         
        
                    $(api.column(3).footer()).html(
                        $.fn.dataTable.render.number(',', '', '', '').display(total13)
                    );

                    total14 = api
                        .column(4)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
         
        
                    $(api.column(4).footer()).html(
                        $.fn.dataTable.render.number(',', '', '', '').display(total14)
                    );
                    
                     
                },
            });
        }
        function goVoidDetails(ID) {
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
                    Hapus(ID, value);
                    // console.log (ID);
                });
        }
        async function Hapus(ID, AlasanBatal) {
            try {
                const dataUpdateHapus = await UpdateHapus(ID,AlasanBatal);
                updateUIdataUpdateHapus(dataUpdateHapus);
            } catch (err) {
                //console.log(err);
                toast(err, "error")
            }
        }
        function updateUIdataUpdateHapus(params) {
            let response = params;
            // toast(response.message, "success")
            if (response.status == 'success') {
                swal({
                    title: "Save Success!",
                    text: response.message,
                    icon: "success",
                })
                showdatatabel()
            } else if (response.status = 'warning') {
                swal({
                    title: 'Warning',
                    text: response.message,
                    icon: "warning",
                })
            }
       
        }
        function UpdateHapus(ID,AlasanBatal) {
            //$(".preloader").fadeIn();
            var base_url = window.location.origin;
            let url = base_url + '/SIKBREC/public/JurnalUmum/VoidDtl';
            return fetch(url, {
                method: 'POST',
                headers: {
                    "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                },
                body: "ID=" + ID + "& AlasanBatal=" + AlasanBatal
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
 async function createHeaderTrs() {
            try {
                const dataGocreateHdr = await GocreateHdr();
                updateUIdataGocreateHdr(dataGocreateHdr);

            } catch (err) {
                toast(err, "error")
            }
        }
        function disableAll() { 
          
            $("#Nojurnal").attr('readonly', true);
            // $("#REKENING").attr('readonly', true);
            // $("#tgljurnal").attr('readonly', true);
            // $("#DebetK").attr('readonly', true); 
            // $("#Keterangan").attr('readonly', true);
            // $("#NamaUnit").attr('readonly', true);
            // $("#Nominaljurnal").attr('readonly', true);
        }
        function enableAll() {
            document.getElementById("Nojurnal").disabled = false;
            document.getElementById("REKENING").disabled = false;
            document.getElementById("tgljurnal").disabled = false;
            document.getElementById("DebetK").disabled = false;
            document.getElementById("Keterangan").disabled = false;
            document.getElementById("NamaUnit").disabled = false;
            document.getElementById("Nominaljurnal").disabled = false;
            // $("#Nojurnal").attr('disabled', false);
            $("#REKENING").attr('disabled', false);
            $("#tgljurnal").attr('disabled', false);
            $("#DebetK").attr('disabled', false);
            $("#Keterangan").attr('disabled', false);
            $("#NamaUnit").attr('disabled', false);
            $("#NominalJurnal").attr('disabled', false);
            
        }
        
       
        function updateUIdataGocreateHdr(dataResponse) {
            //console.log("dataResponse", dataResponse);
            if (dataResponse.status == 'success'){
                toast(dataResponse.message, 'success')
                $('#Nojurnal').val(dataResponse.NoJurnal);
                $('#tgljurnal').val(dataResponse.tgljurnal);
                $('#DebetK').val(dataResponse.DebetK);
                $('#Keterangan').val(dataResponse.Keterangan);
                $('#NamaUnit').val(dataResponse.NamaUnit);
                $('#NominalJurnal').val(dataResponse.NominalJurnal);
                
                $("#btnNewjurnal").attr('disabled', true);
                disableAll();
            }else{
                toast(dataResponse.message, 'warning')
            }
        }
        function GocreateHdr() {
            var base_url = window.location.origin;
            var data = $("#form_hdr").serialize();
            let url = base_url + '/SIKBREC/public/JurnalUmum/CreateHdrJurnal';
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
      

        function updateUIdataeditJurnalUmum(params) {
            if(params.status === true){
                toast(params.message, "success")
                MyBack();
            }else{
                toast(params.message, "error")
            }
        }
        

        async function ShowDataJurnal() {
            try {
                const dtgoShowDataJurnald = await goShowDataJurnal();
                updateUdtgoShowDataJurnald(dtgoShowDataJurnald);
            } catch (err) {
                toast(err, "error")
            }
        }
        function updateUdtgoShowDataJurnald(data){
            $("#tgljurnal").val(data.data.tgl_jurnal);
            $("#Keterangan").val(data.data.FS_KET);
        }
        function goShowDataJurnal() {
            var base_url = window.location.origin;
            var Nojurnal =  $("#Nojurnal").val();
            let url = base_url + '/SIKBREC/public/JurnalUmum/goShowDataJurnal/';
            return fetch(url, {
                method: 'POST',
                headers: {
                    "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                },
                body: "Nojurnal=" + Nojurnal
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

        async function PassData(param) {
            try {
                const data = await goPassData(param);
                updateUdtgoPassData(data);
            } catch (err) {
                toast(err, "error")
            }
        }
        function updateUdtgoPassData(data){
            $("#FB_LEDGER_H").val(data.data.FB_LEDGER_H);
            $("#FB_LEDGER_P").val(data.data.FB_LEDGER_P);
        }
        function goPassData(param) {
            var base_url = window.location.origin;
            //var Nojurnal =  $("#Nojurnal").val();
            let url = base_url + '/SIKBREC/public/JurnalUmum/getRekeningbyID/';
            return fetch(url, {
                method: 'POST',
                headers: {
                    "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                },
                body: "ID=" + param
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

        async function InsertDtl() {
            try {
                const data = await goInsertDtl();
                updateUdtgoInsertDtl(data);
            } catch (err) {
                toast(err, "error")
            }
        }
        function updateUdtgoInsertDtl(data){
            showdatatabel();
            //buat kosongin lagi
        }
        function goInsertDtl() {
            var base_url = window.location.origin;
            var str = $( "#form_hdr" ).serialize(); 
            let url = base_url + '/SIKBREC/public/JurnalUmum/CreateDtlJurnal/';
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
        
async function batalDatabyID(id) {
    try {
        const dataUpdatebatalDatabyID = await UpdatebatalDatabyID(id);
        updateUIdataUpdatebatalDatabyID(dataUpdatebatalDatabyID);
    } catch (err) {
        //console.log(err);
        toast(err, "error")
    }
}
function updateUIdataUpdatebatalDatabyID(params) {
    let response = params;
    // toast(response.message, "success")
    if (response.status == 'success') {
        swal({
            title: "Save Success!",
            text: response.message,
            icon: "success",
        })
        showdatatabel()
    } else if (response.status = 'warning') {
        swal({
            title: 'Warning',
            text: response.message,
            icon: "warning",
        })
    }
    //var noregistrasi = response.NoRegistrasi; ;q
}
        
        function UpdatebatalDatabyID(param){
            var base_url = window.location.origin;
            var str = $( "#form_hdr" ).serialize(); 
            let url = base_url + '/SIKBREC/public/JurnalUmum/VoidHdr/';
            return fetch(url, {
                method: 'POST',
                headers: {
                    "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                },
                body: str + "&AlasanBatal=" + param
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

        function MyBack() {
            const base_url = window.location.origin;
            window.location = base_url + "/SIKBREC/public/JurnalUmum/JurnalUmumList";
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
