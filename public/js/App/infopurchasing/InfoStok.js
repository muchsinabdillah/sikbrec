$(document).ready(function () {
    asyncShowMain();
    // onloadForm();
    $(".preloader").fadeOut(); 
    // $('#btnLoadInformation').prop('disabled', true);
    $('#example').DataTable({});
    $(document).on('click', '#btnLoadInformation', function () {
        if ($("#NamaUnit").val() == ''){
            toast ('Pilih Lokasi Stok', "warning");
            return false;
        }
        showdatatabel(); 
    });
});

    
    async function asyncShowMain() {
        try {
            //await getHakAksesByForm(14);
            const datagetNamaUnit = await getNamaUnit();
            updateUIgetNamaUnit(datagetNamaUnit);
            // const datagetKodeJasa = await getKodeJasa(); 
            // updateUIgetKodeJasa(datagetKodeJasa);
    
            const datagetDatabyID = await getDatabyID();
            updateUIdatagetDatabyID(datagetDatabyID);
            // const datagetGrupPerawatan = await getGrupPerawatan(); aa
            // updateUIgetGrupPerawatan(datagetGrupPerawatan);ssssss
            // getListDataOrderDetails();
            // getListDataHistori();
        $(".preloader").fadeOut();
        } catch (err) {
            // toast(err, "error")
        }
        function updateUIdatagetDatabyID(datagetDatabyID){
            let dataResponse = datagetDatabyID;
    
            $("#ID").val(convertEntities(dataResponse.data.ID));
           
        }
        
        }
        function updateUIgetNamaUnit(datagetNamaUnit) {
            let data = datagetNamaUnit;
            if (data !== null && data !== undefined) {
                console.log(data);
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
        // console.log ('ssssss')
  
    NamaUnit = $("#NamaUnit").val();
     var base_url = window.location.origin;
    $(".preloader").fadeOut();
    $('#example').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#example').DataTable({
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/InfoStok/getDataListInfoStok",
            "dataSrc": "",
            "type": "POST",
            data: function (d) {
                // d.PeriodeAwal = PeriodeAwal;
                // d.PeriodeAkhir = PeriodeAkhir;
                d.NamaUnit = NamaUnit;
            },
            "deferRender": true,
        },
        
        "columns": [
            
            { "data": "Kode_Barang" },
            { "data": "Nama_Barang" },
            { "data": "Qty" ,  render: $.fn.dataTable.render.number( '.', ',', 2,'' )},
            { "data": "Satuan" },
            { "data": "Hpp" ,  render: $.fn.dataTable.render.number( '.', ',', 2,'' )},
            { "data": "Persediaan" ,  render: $.fn.dataTable.render.number( '.', ',', 2,'' ) },
            { "data": "NamaUnit" },
            
            
        ],
        dom: 'Bfrtip',
            buttons: [
               'excelHtml5'
            ]
    });
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
 