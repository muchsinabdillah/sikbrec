$(document).ready(function () {
    asyncShowMain();
    Rajal();
    lab();
    radiologi();
    MCU();
    asyncOperasi();
    GroupSpesial();
});


async function asyncOperasi() {
    try {
        TarifOperasi();
        //Show_Detail_Paket();
    } catch (err) {
        toast(err, "error")
    }
}
function TarifOperasi() {
    var base_url = window.location.origin;
   // const base_url = window.location.origin;
   $(".preloader").fadeOut();
   $('#paket_operasi').dataTable({
       "bDestroy": true
   }).fnDestroy();
   $('#paket_operasi').DataTable({
       "ordering": true,
       "ajax": {
           "url": base_url + "/SIKBREC/public/InfoMasterTarif/getDataOperasi",
           "dataSrc": "",
           "type": "POST",
           "deferRender": true,
       },
       "columns": [
        {
            "render": function (data, type, row) {
                var html = ""
                var html = '<button href="#modal_pilih_paket" data-toggle="modal" class="btn btn-info"  id="btn_detail" name="btn_detail" onclick="Show_Detail_Paket(' + row.id_paket + ')" ><span class="glyphicon glyphicon-list-alt" ></span>Detail</span>'
                return html
            },
        },
           { "data": "NamaPaket" },
           { "data": "Kelas3" },
           { "data": "Kelas2" },
           { "data": "Kelas1" },
           { "data": "Juniorsuite" },
           { "data": "Executivesuite" },
           { "data": "Presidentsuite" },
           { "data": "Keterangan" },
           { "data": "Status" },
           
                          
       ],
     
   });
}
function Show_Detail_Paket(id_paket) {
    // var base_url = window.location.origin;
    const base_url = window.location.origin;
    $(".preloader").fadeOut();
    $('#Show-Detail-Paket').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#Show-Detail-Paket').DataTable({
        "ordering": true,
        "ajax": {
            "url": base_url + "/SIKBREC/public/InfoMasterTarif/ShowDetailOperasi",
            "dataSrc": "",
            "type": "POST",
                    data: function ( d ) {
                d.id_paket = id_paket;
                },
                   "deferRender": true,
        },
        "columns": [
    
            { "data": "Deskripsi" },
            { "data": "Kelompok_Item" },
            { "data": "QTY" },
            { "data": "Kelas3" },
            { "data": "Kelas2" },
            { "data": "Kelas1" },
            { "data": "Junior_Suite" },
            { "data": "Executive" },
            { "data": "resident_Suite" },
                           
        ],
      
    });
}

async function asyncShowMain() {
    try {
        showdatatabel();
    } catch (err) {
        toast(err, "error")
    }
}
        function showdatatabel() {
         var base_url = window.location.origin;
        // const base_url = window.location.origin;
        $(".preloader").fadeOut();
        $('#example').dataTable({
            "bDestroy": true
        }).fnDestroy();
        $('#example').DataTable({
            "ordering": true,
            "ajax": {
                "url": base_url + "/SIKBREC/public/InfoMasterTarif/load_data_Ranap",
                "dataSrc": "",
                "type": "POST",
                "deferRender": true,
            },
            "columns": [
        
                { "data": "Product_Code" },
                { "data": "CategoryProduct" },
                { "data": "Product_Name" },
                { "data": "NM_JASA" },
                { "data": "NM_PDP" },
                { "data": "grupJamina" },
                { "data": "Tarif" },
                { "data": "Tarifkelas3" },
                { "data": "Tarifkelas2" },
                { "data": "Tarifkelas1" },
                { "data": "TarifVIP" },
                { "data": "TarifSVIP" },
                { "data": "TarifICU" },
                               
            ],
          
        });
    }
    async function radiologi() {
        try {
            Radiologi();
        } catch (err) {
            toast(err, "error")
        }
    }
        function Radiologi() {
            var base_url = window.location.origin;
           // const base_url = window.location.origin;
           $(".preloader").fadeOut();
           $('#radiologi').dataTable({
               "bDestroy": true
           }).fnDestroy();
           $('#radiologi').DataTable({
               "ordering": true,
               "ajax": {
                   "url": base_url + "/SIKBREC/public/InfoMasterTarif/GetDataRadiologi",
                   "dataSrc": "",
                   "type": "POST",
                   "deferRender": true,
               },
               "columns": [
           
                   { "data": "Modality_Code" },
                   { "data": "Proc_Description" },
                   { "data": "NM_JASA" },
                   { "data": "NM_PDP" },
                   { "data": "grupJamina" },
                   { "data": "ServiceCharge_O" },
                   { "data": "ServiceCharge_I2" },
                   { "data": "ServiceCharge_I1" },
                   { "data": "ServiceCharge_IVIP" },
                   { "data": "ServiceCharge_IVIP" },
                   { "data": "ServiceCharge_PS" },

                                  
               ],
             
           });
        }

        async function lab() {
            try {
                Laboratorium();
            } catch (err) {
                toast(err, "error")
            }
        }
        function Laboratorium() {
            var base_url = window.location.origin;
           // const base_url = window.location.origin;
           $(".preloader").fadeOut();
           $('#laboratorium').dataTable({
               "bDestroy": true
           }).fnDestroy();
           $('#laboratorium').DataTable({
               "ordering": true,
               "ajax": {
                   "url": base_url + "/SIKBREC/public/InfoMasterTarif/GetDataLaboratorium",
                   "dataSrc": "",
                   "type": "POST",
                   "deferRender": true,
               },
               "columns": [
           
                   { "data": "KodeKelompok" },
                   { "data": "NoUrut" },
                   { "data": "IDTes" },
                   { "data": "NamaTes" },
                   { "data": "NM_JASA" },
                   { "data": "NM_PDP" },
                   { "data": "grupJamina" },
                   { "data": "Tarif" },
                   { "data": "TarifIGD" },
                   { "data": "TarifK3" },
                   { "data": "TarifK2" },
                   { "data": "TarifK1" },
                   { "data": "TarifVIP" },
                   { "data": "TarifVVIP" },
                   { "data": "TarifPresidenSuite" },
                    { "data": "TarifIsolasi" },
                    { "data": "TarifICU" },
                    { "data": "TarifPerusahaan" },
                    { "data": "TJamsostek" },
                    { "data": "TGakin" },
                                  
               ],
             
           });
        }
        async function Rajal() {
            try {
                const datagetGrupPerawatan = await getGrupPerawatan();
                updateUIgetGrupPerawatan(datagetGrupPerawatan);
                // load_data_rajal();
            } catch (err) {
                // toast(err, "error")
            }
        }
         function updateUIgetGrupPerawatan(datagetGrupPerawatan) {
            let data = datagetGrupPerawatan;
            if (data !== null && data !== undefined) {
                //console.log(data);
                var newRow = '<option value="">-- PILIH --</option';
                $("#GrupPerawatan").append(newRow);
                for (i = 0; i < data.data.length; i++) {
                    var newRow = '<option value="' + data.data[i].CODEUNIT + '">' + data.data[i].NamaUnit + '</option';
                    $("#GrupPerawatan").append(newRow);
                }
            }
        }
        function getGrupPerawatan() {
            var base_url = window.location.origin;
            let url = base_url + '/SIKBREC/public/InfoMasterTarif/getGrupPerawatan';
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
        function load_data_rajal(q) {
            var x = q.value;

            var base_url = window.location.origin;
           // const base_url = window.location.origin;
           $(".preloader").fadeOut();
           $('#table-load-data').dataTable({
               "bDestroy": true
           }).fnDestroy();
           $('#table-load-data').DataTable({
               "ordering": true,
               "ajax": {
                   "url": base_url + "/SIKBREC/public/InfoMasterTarif/GetDataTarifRajal",
                   "dataSrc": "",
                   "type": "POST",
                    data: function ( d ) {
                d.x = x;
                },
                   "deferRender": true,
               },
               "columns": [
           
                { "data": "Product_Code" }, // Tampilkan telepon
                { "data": "CategoryProduct" }, // Tampilkan telepon
                { "data": "Product_Name" }, // Tampilkan alamat
                { "data": "grupJaminan" },  // Tampilkan nama  
                { "data": "TarifRS" },  // Tampilkan nama  
                { "data": "NM_JASA" },  // Tampilkan nama  
                { "data": "NM_PDP" },  // Tampilkan nama  
               ],
             
           });
        }

        async function MCU() {
            try {
                const datagetGroupmcu = await getGroupmcu();
                updateUIgetGroupmcu(datagetGroupmcu);
  
            } catch (err) {
                // toast(err, "error")
            }
        }

        async function getheadermcu(data) {
            try {
                const datagetDataTarif = await getDataTarif(data);
                updateUIgetDataTarif(datagetDataTarif);

            } catch (err) {
                // toast(err, "error")
            }
        }
     
         function updateUIgetGroupmcu(datagetGroupmcu) {
            let data = datagetGroupmcu;
            if (data !== null && data !== undefined) {
                //console.log(data);
                var newRow = '<option value="">-- PILIH --</option';
                $("#mcu").append(newRow);
                for (i = 0; i < data.data.length; i++) {
                    var newRow = '<option value="' + data.data[i].NamaPaket + '">' + data.data[i].NamaPaket + '</option';
                    $("#mcu").append(newRow);
                }
            }
        }
        function getGroupmcu() {
            var base_url = window.location.origin;
            let url = base_url + '/SIKBREC/public/InfoMasterTarif/getGroupmcu';
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
                    $("#mcu").select2();
                })
        }
        function updateUIgetDataTarif(datagetDataTarif) {
            let dataResponse = datagetDataTarif; 

            $("#tarif_mcu_value").val(dataResponse.data.Tarif);
            $("#awalmasaberlaku").val(dataResponse.data.AwalMasaBerlaku);
            $("#akhirmasaberlaku").val(dataResponse.data.AkhirMasaBerlaku);
           
        }
        function getDataTarif(data) {
            var base_url = window.location.origin;
            let url = base_url + '/SIKBREC/public/InfoMasterTarif/GetDataTarif/';
            return fetch(url, {
                method: 'POST',
                headers: {
                    "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                },
                body: 'NamaPaket=' + data.value
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

         function load_data_mcu(q) {
            var NamaPaket = q.value;

            var base_url = window.location.origin;
           // const base_url = window.location.origin;
           $(".preloader").fadeOut();
           $('#table-load-data-mcu').dataTable({
               "bDestroy": true
           }).fnDestroy();
           $('#table-load-data-mcu').DataTable({
               "ordering": true,
               "ajax": {
                   "url": base_url + "/SIKBREC/public/InfoMasterTarif/LoadDataMCU",
                   "dataSrc": "",
                   "type": "POST",
                    data: function ( d ) {
                d.NamaPaket = NamaPaket;
                },
                   "deferRender": true,
               },
               "columns": [
           
                { "data": "Pemeriksaan" }, // Tampilkan telepon
                { "data": "Lokasi_Pemeriksaan" }, // Tampilkan telepon
                { "data": "Pemeriksaan_penunjang" }, // Tampilkan alamat
                { "data": "IdTes" },  // Tampilkan nama  
                { "data": "Tarif" },  // Tampilkan nama  
               ],
             
           });
        }
        async function GroupSpesial() {
            try {
                const datagetDataGroupSpesialis = await getDataGroupSpesialis();
                updateUIdatagetDataGroupSpesialis(datagetDataGroupSpesialis);
  
                // load_data_mcu_tarif();
            } catch (err) {
                // toast(err, "error")
            }
        }

        function getDataGroupSpesialis() {

            var base_url = window.location.origin;
            let url = base_url + '/SIKBREC/public/InfoMasterTarif/getDataGroupSpesialis/';
            return fetch(url, {
                method: 'POST',
                headers: {
                    "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                },
                body: 'BagianID=' + $("#GroupSpesialis").val()
                
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
        function updateUIdatagetDataGroupSpesialis(datagetDataGroupSpesialis) {
            let data = datagetDataGroupSpesialis;
            if (data !== null && data !== undefined) {
                //console.log(data);
                var newRow = '<option value="">-- PILIH GROUP SPESIALIS--</option';
                $("#GroupSpesialis").append(newRow);
                for (i = 0; i < data.data.length; i++) {
                    var newRow = '<option value="' + data.data[i].BagianID + '">' + data.data[i].Bagian + '</option';
                    $("#GroupSpesialis").append(newRow);
                }
            }
        }
        async function ShowKategoriOperasi() {
            try {
                const datagetKategoriOperasi = await getKategoriOperasi();
                updateUIdatagetKategoriOperasi(datagetKategoriOperasi);
  
            } catch (err) {
                // toast(err, "error")
            }
        }

        function getKategoriOperasi() {
            var base_url = window.location.origin;
            let url = base_url + '/SIKBREC/public/InfoMasterTarif/getKategoriOperasi/';
            return fetch(url, {
                method: 'POST',
                headers: {
                    "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                },
                body: 'BagianID=' + $("#Show_Kategori_Operasi").val()
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
        function updateUIdatagetKategoriOperasi(datagetKategoriOperasi) {
            let data = datagetKategoriOperasi;
            if (data !== null && data !== undefined) {
                //console.log(data);
                var newRow = '<option value="">-- PILIH KATEGORI OPERASI--</option';
                $("#Show_Kategori_Operasi").append(newRow);
                for (i = 0; i < data.data.length; i++) {
                    var newRow = '<option value="' + data.data[i].BagianID + '">' + data.data[i].Kategori + '</option';
                    $("#Show_Kategori_Operasi").append(newRow);
                }
            }
        }
        async function ShowTindakanOperasi() {
            try {
            
                const datagetTindakanOperasi = await getTindakanOperasi();
                updateUIdatagetTindakanOperasi(datagetTindakanOperasi);
  
            } catch (err) {
                // toast(err, "error")
            }
        }
        
        function getTindakanOperasi() {
            var base_url = window.location.origin;
            let url = base_url + '/SIKBREC/public/InfoMasterTarif/getTindakanOperasi/';
            return fetch(url, {
                method: 'POST',
                headers: {
                    "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                },
                body: 'BagianID=' + $("#Show_Tindakan_Operasi").val()
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
        function updateUIdatagetTindakanOperasi(datagetTindakanOperasi) {
            let data = datagetTindakanOperasi;
            if (data !== null && data !== undefined) {
                //console.log(data);
                var newRow = '<option value="">-- PILIH TINDAKAN OPERASI--</option';
                $("#Show_Tindakan_Operasi").append(newRow);
                for (i = 0; i < data.data.length; i++) {
                    var newRow = '<option value="' + data.data[i].BagianID + '">' + data.data[i].GroupName + '</option';
                    $("#Show_Tindakan_Operasi").append(newRow);
                }
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