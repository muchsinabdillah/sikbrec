$(document).ready(function () {
    asyncShowMain();
    // format number to price
    //convertNumberToRp();
    // buton save ditekan
    // const saveButton = document.querySelector('#btnreservasi');
    // saveButton.addEventListener('click', async function () {
    //     try {
    //         const result = await saveDataBon();
    //         if (result.status == "success") {
    //             toast(result.message, "success")
    //             setTimeout(function () { MyBack(); }, 1000);
    //         }
    //     } catch (err) {
    //         toast(err, "error")
    //     }
    // })

    // const saveButtonx = document.querySelector('#btnSave');
    // saveButtonx.addEventListener('click', async function () {
    //     try {
    //         const result = await saveData();
    //         if (result.status == "success") {
    //             toast(result.message, "success")
    //             setTimeout(function () { MyBack(); }, 1000);
    //             asyncShowMain();
    //         }

    //     } catch (err) {

    //         toast(err, "error")
    //     }
    // })

    $('#btnSave').click(function () {
        swal({
            title: "Simpan",
            text: "Apakah Anda ingin Simpan Data ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    if ($("#ID").val() == ''){
                        saveData();
                    }else{
                        saveEditData();
                    }
                } else {
                    swal("Transaction Rollback !");
                }
            });
    });

    $('#btnAddSupplier').click(function () {
        // swal({
        //     title: "Simpan",
        //     text: "Apakah Anda ingin Tambah Data ?",
        //     icon: "warning",
        //     buttons: true,
        //     dangerMode: true,
        // })
        //     .then((willDelete) => {
        //         if (willDelete) {
                    if ($("#ID").val() == ''){
                        //saveData();
                        toast("ID Barang Tidak Ditemukan ! Silahkan Simpan Data Terlebih Dahulu !")
                        return false;
                    }else{
                        saveAddSupplier();
                    }
                // } else {
                //     swal("Transaction Rollback !");
                // }
            //});
    });

    $('#btnAddFormularium').click(function () {
        // swal({
        //     title: "Simpan",
        //     text: "Apakah Anda ingin Tambah Data ?",
        //     icon: "warning",
        //     buttons: true,
        //     dangerMode: true,
        // })
        //     .then((willDelete) => {
        //         if (willDelete) {
                    if ($("#ID").val() == ''){
                        //saveData();
                        toast("ID Barang Tidak Ditemukan ! Silahkan Simpan Data Terlebih Dahulu !")
                        return false;
                    }else{
                        saveAddFormularium();
                    }
             //   } else {
            //         swal("Transaction Rollback !");
            //     }
            // });
    });
    $('#btnAddBarangSatuan').click(function () {
                    if ($("#ID").val() == ''){
                        //saveData();
                        toast("ID Barang Tidak Ditemukan ! Silahkan Simpan Data Terlebih Dahulu !")
                        return false;
                    }else{
                        saveAddSatuanKonversiNilai();
                    }
    });
    
});

async function saveAddSatuanKonversiNilai() {
    try {
        const datax = await gosaveAddSatuanKonversiNilai();
        updateUIRefSatuanKonversi(datax);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIRefSatuanKonversi(data){
    refreshSatuanKonvversilist();
}
function refreshSatuanKonvversilist() {
    var ID = document.getElementById("ID").value;
    var base_url = window.location.origin;
    $('#tbl_formularium').DataTable().clear().destroy();
    $('#tbl_formularium').DataTable({
        "ordering": false,
        "paging": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/MasterDataBarang/getBarangbyFormulariums/",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.ID = ID; 
            }
        },
        "columns": [
            
            { "data": "IDBarang" },
            { "data": "IDFormularium" },
            { "data": "Nama_Formularium" },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-danger btn-animated btn-xs"  onclick="deleteFormulariumPerItem(' + row.IDBarang + ', '+row.IDFormularium+')" ><span class="visible-content" > Delete</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },

        ], 

    });
    $(".preloader").fadeOut();
} 

function gosaveAddSatuanKonversiNilai() {
    var base_url = window.location.origin;
    var data = $("#form_addBarangSatuan, #form_hdr").serialize();
    let url = base_url + '/SIKBREC/public/MasterDataBarang/addBarangFormularium/';
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

async function deleteSupplierPerItem(idbarang,param2) {
    try {
        const data = await godeleteSupplierPerItem(idbarang,param2);
        updateUIgoRefreshTable(data);
    } catch (err) {
        toast(err, "error")
    }
}

async function deleteFormulariumPerItem(idbarang,param2) {
    try {
        const data = await godeleteFormulariumPerItem(idbarang,param2);
        updateUIgoRefreshTable(data);
    } catch (err) {
        toast(err, "error")
    }
}

async function saveAddFormularium() {
    try {
        const datagosaveAddFormularium = await gosaveAddFormularium();
        updateUIgoRefreshTable(datagosaveAddFormularium);
    } catch (err) {
        toast(err, "error")
    }
}

async function saveAddSupplier() {
    try {
        const datagosaveAddSupplier = await gosaveAddSupplier();
        updateUIgoRefreshTable(datagosaveAddSupplier);
    } catch (err) {
        toast(err, "error")
    }
}

async function saveEditData() {
    try {
        const datagosaveEditData = await gosaveEditData();
        updateUIdatagosaveData(datagosaveEditData);
    } catch (err) {
        toast(err, "error")
    }
}

async function saveData() {
    try {
        const datagosaveData = await gosaveData();
        updateUIdatagosaveData(datagosaveData);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatagosaveData(params) {
    if(params.status === 1){
        toast(params.message, "success")
        setTimeout(() => {
            MyBack();
        }, 2000);
    }else{
        toast(params.message, "error")
    }
}

function updateUIgoRefreshTable(params) {
    console.log(params);
    if(params.status === 1){
        toast(params.message, "success")
        getBarangbySuppliers();
        getBarangbyFormulariums();
    }else{
        toast(params.message, "error")
    }
}

function gosaveData() {
    var base_url = window.location.origin;
    var data = $("#form_hdr, #form_dtl").serialize();
    let url = base_url + '/SIKBREC/public/MasterDataBarang/addBarang/';
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

function gosaveEditData() {
    var base_url = window.location.origin;
    var data = $("#form_hdr, #form_dtl").serialize();
    let url = base_url + '/SIKBREC/public/MasterDataBarang/editBarang/';
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

function gosaveAddSupplier() {
    var base_url = window.location.origin;
    var data = $("#form_addsupplier, #form_hdr").serialize();
    let url = base_url + '/SIKBREC/public/MasterDataBarang/addBarangSupplier/';
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

function gosaveAddFormularium() {
    var base_url = window.location.origin;
    var data = $("#form_addformularium, #form_hdr").serialize();
    let url = base_url + '/SIKBREC/public/MasterDataBarang/addBarangFormularium/';
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

function godeleteSupplierPerItem(idbarang,param2) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataBarang/deleteBarangSupplier/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:  "idbarang="+idbarang+
               "&idparam="+ param2 
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

function godeleteFormulariumPerItem(idbarang,param2) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataBarang/deleteBarangFormularium/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "idbarang="+idbarang+
              "&idparam="+ param2
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

function getBarangbySuppliers() {
    var ID = document.getElementById("ID").value;
    var base_url = window.location.origin;
    $('#tbl_supplier').DataTable().clear().destroy();
    $('#tbl_supplier').DataTable({
        "ordering": false,
        "paging": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/MasterDataBarang/getBarangbySuppliers/",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.ID = ID; 
            }
        },
        "columns": [
            
            { "data": "IDBarang" },
            { "data": "IDSupplier" },
            { "data": "NamaSupplier" },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-danger btn-animated btn-xs" onclick="deleteSupplierPerItem(' + row.IDBarang + ', '+row.IDSupplier+')" ><span class="visible-content" > Delete</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },

        ], 

    });
    $(".preloader").fadeOut();
} 

function getBarangbyFormulariums() {
    var ID = document.getElementById("ID").value;
    var base_url = window.location.origin;
    $('#tbl_formularium').DataTable().clear().destroy();
    $('#tbl_formularium').DataTable({
        "ordering": false,
        "paging": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/MasterDataBarang/getBarangbyFormulariums/",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.ID = ID; 
            }
        },
        "columns": [
            
            { "data": "IDBarang" },
            { "data": "IDFormularium" },
            { "data": "Nama_Formularium" },
            {
                "render": function (data, type, row) {
                    var html = ""
                    var html = '<button type="button" class="btn btn-danger btn-animated btn-xs"  onclick="deleteFormulariumPerItem(' + row.IDBarang + ', '+row.IDFormularium+')" ><span class="visible-content" > Delete</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                    return html
                }
            },

        ], 

    });
    $(".preloader").fadeOut();
} 


async function asyncShowMain() {
    try {
        $("#Discontinue").select2();
        $("#Label_Signa").select2();
        const datagetGroupBarang = await getGroupBarang(); 
        updateUIdatagetGroupBarang(datagetGroupBarang); 
        const datagetgetJenisBarang = await getJenisBarang(); 
        updateUIdatagetgetJenisBarang(datagetgetJenisBarang); 
        const datagetgetSatuan = await getSatuan(); 
        updateUIdatagetgetSatuan(datagetgetSatuan);  
        const datagetgetGolongan = await getGolongan();
        updateUIdatagetgetGolongan(datagetgetGolongan);  
        const datagetgetKelompok = await getKelompok();
        updateUIdatagetgetKelompok(datagetgetKelompok);   
        const datagetgetFormularium = await getFormularium(); 
        updateUIdatagetgetFormularium(datagetgetFormularium);   
        const datagetKodePDP = await getKodePDP(); 
        updateUIgetKodePDP(datagetKodePDP);
        const datagetgetSupplier = await getSupplier(); 
        updateUIdatagetgetSupplier(datagetgetSupplier); 
        
        var id =  $("#ID").val();
        if(id != ""){
            const datagetBarangbyId = await getBarangbyId(); 
            updateUIdatagetBarangbyId(datagetBarangbyId); 

            // getBarangbySuppliers();
            // getBarangbyFormulariums();

        }
        
        

        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    } 
}
function updateUIdatagetBarangbyId(dataResponse) {
    
    //console.log(dataResponse[0].Satuan_Beli);
    // $("#Barcode_Code").val(dataResponse.data[0].Kode_Barcode);
    // $("#Barcode_Code").val(dataResponse.data[0].Product Name);
    // $("#Barcode_Code").val(dataResponse.data[0].Kode_Barcode);
    // $('#Satuan_Beli').val(dataResponse[0].Satuan_Beli).trigger('change');
    // $('#Satuan_Beli').val(dataResponse[0].Satuan_Beli).trigger('change');
    $('#Product_Code').val(dataResponse.data[0]['Product Code']);
    $('#Barcode_Code').val(dataResponse.data[0]['Kode_Barcode']);
    $('#Nama_Product').val(dataResponse.data[0]['Product Name']);
    $('#Nama_Alias').val(dataResponse.data[0]['NamaKMG']);
    $('#Discontinue').val(dataResponse.data[0]['Discontinued']).trigger('change');
    $('#KelompokBarang').val(dataResponse.data[0]['Category']).trigger('change');
    //$('#Jenis_Barang').val(dataResponse.data[0]['NamaKMG']);//---
    $('#Satuan_Beli').val(dataResponse.data[0]['Satuan_Beli']).trigger('change');
    $('#Satuan_Jual').val(dataResponse.data[0]['Unit Satuan']).trigger('change');
    $('#Konversi_Satuan').val(dataResponse.data[0]['Konversi_satuan']);
    //$('#Stok_Minimum').val(dataResponse.data[0]['Konversi_satuan']);//---
    $('#Label_Signa').val(dataResponse.data[0]['Signa']).trigger('change');
    $('#Golongan_Obat').val(dataResponse.data[0]['Golongan']).trigger('change');
    $('#Group_Barang').val(dataResponse.data[0]['Group_DK']).trigger('change');
    $('#KodePDP').val(dataResponse.data[0]['KD_PDP']).trigger('change');
    $('#Jenis_Barang').val(dataResponse.data[0]['JenisBarang']).trigger('change');
    
    $('#Deskripsi').val(dataResponse.data[0]['Description']);
    $('#Komposisi').val(dataResponse.data[0]['Composisi']);
    $('#Indikasi').val(dataResponse.data[0]['Indikasi']);
    $('#Dosis').val(dataResponse.data[0]['Dosis']);
    $('#KontraIndikasi').val(dataResponse.data[0]['Kontra_indikasi']);
    $('#EfekSamping').val(dataResponse.data[0]['Efek_Samping']);
    $('#Peringatan').val(dataResponse.data[0]['Peringatan']);
    $('#Kemasan').val(dataResponse.data[0]['Kemasan']);
}
function getBarangbyId() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataBarang/getBarangbyId/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'id=' + $("#ID").val()
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
function updateUIdatagetgetSupplier(params) {
    let responseApi = params;
    if (responseApi !== null && responseApi !== undefined) {
        console.log(responseApi);
        $("#DataSupplier").empty();
        var newRow = '<option value="">-- PILIH --</option';
        $("#DataSupplier").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].ID + '">' + responseApi[i].Company + '</option';
            $("#DataSupplier").append(newRow);

        }

    }
}
function getSupplier() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataBarang/showSupplierAll';
    return fetch(url, {
        method: 'POST',
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
            $("#DataSupplier").select2();
        })
}
function updateUIdatagetgetFormularium(params) {
    let responseApi = params;
    if (responseApi !== null && responseApi !== undefined) {
        console.log(responseApi);
        $("#DataFormularium").empty();
        var newRow = '<option value="">-- PILIH --</option';
        $("#DataFormularium").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].ID + '">' + responseApi[i].Nama_Formularium + '</option';
            $("#DataFormularium").append(newRow);

        }

    }
}
function getFormularium() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataBarang/showFormulariumBarangAll';
    return fetch(url, {
        method: 'POST',
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
            $("#DataFormularium").select2();
        })
}
function updateUIdatagetgetKelompok(params) {
    let responseApi = params;
    if (responseApi !== null && responseApi !== undefined) {
        console.log(responseApi);
        $("#KelompokBarang").empty();
        var newRow = '<option value="">-- PILIH --</option';
        $("#KelompokBarang").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].KelompokCode + '">' + responseApi[i].KelompokName + '</option';
            $("#KelompokBarang").append(newRow);

        }

    }
}
function getKelompok() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataBarang/showkelompokBarangAll';
    return fetch(url, {
        method: 'POST',
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
            $("#KelompokBarang").select2();
        })
}
function updateUIdatagetgetGolongan(params) {
    let responseApi = params;
    if (responseApi !== null && responseApi !== undefined) {
        console.log(responseApi);
        $("#Golongan_Obat").empty(); 
        var newRow = '<option value="">-- PILIH --</option';
        $("#Golongan_Obat").append(newRow); 
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].ID + '">' + responseApi[i].Golongan + '</option';
            $("#Golongan_Obat").append(newRow); 

        }

    }
}
function getGolongan() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterGolongan/showGolonganAll';
    return fetch(url, {
        method: 'POST',
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
            $("#Golongan_Obat").select2(); 
        })
}
function updateUIdatagetgetSatuan(params) {
    let responseApi = params;
    if (responseApi !== null && responseApi !== undefined) {
        console.log(responseApi);
        $("#Satuan_Beli").empty();
        $("#Satuan_Jual").empty();
        $("#Konversi_SatuanBeli").empty();
        $("#Konversi_SatuanJual").empty();
        var newRow = '<option value="">-- PILIH --</option';
        $("#Satuan_Beli").append(newRow);
        $("#Satuan_Jual").append(newRow);
        $("#Konversi_SatuanBeli").append(newRow);
        $("#Konversi_SatuanJual").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].nama_satuan + '">' + responseApi[i].nama_satuan + '</option';
            $("#Satuan_Beli").append(newRow);
            $("#Satuan_Jual").append(newRow);
            $("#Konversi_SatuanBeli").append(newRow);
            $("#Konversi_SatuanJual").append(newRow);

        }

    }
}
function getSatuan() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterSatuan/showSatuanAll';
    return fetch(url, {
        method: 'POST',
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
            $("#Satuan_Beli").select2();
            $("#Satuan_Jual").select2();
        })
}
function updateUIdatagetgetJenisBarang(params) {
    let responseApi = params;
    if (responseApi !== null && responseApi !== undefined) {
        console.log(responseApi);
        $("#Jenis_Barang").empty();
        var newRow = '<option value="">-- PILIH --</option';
        $("#Jenis_Barang").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].ID + '">' + responseApi[i].NamaJenis + '</option';
            $("#Jenis_Barang").append(newRow);

        }
    }
}
function getJenisBarang() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataJenisBarang/showJenisAll';
    return fetch(url, {
        method: 'POST',
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
            $("#Jenis_Barang").select2();
        })
}
function updateUIdatagetGroupBarang(params) {
    let responseApi = params;
    if (responseApi !== null && responseApi !== undefined) {
        console.log(responseApi);
        $("#Group_Barang").empty();
        var newRow = '<option value="">-- PILIH --</option';
        $("#Group_Barang").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].GroupCode + '">' + responseApi[i].GroupName + '</option';
            $("#Group_Barang").append(newRow);

        }
    }
}
function getGroupBarang() { 
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/GroupBarang/showGroupBarangAll';
    return fetch(url, {
        method: 'POST',
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
            $("#Group_Barang").select2();
        })
}


function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/MasterDataBarang/list/";
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

function updateUIgetKodePDP(datagetKodePDP) {
    let data = datagetKodePDP;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#KodePDP").append(newRow);
        for (i = 0; i < data.length; i++) {
            var newRow = '<option value="' + data[i].KD_PDP + '">' + data[i].NM_PDP + '</option';
            $("#KodePDP").append(newRow);
        }
    }
}
function getKodePDP() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataTarif/getKodePDP';
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
            $("#KodePDP").select2();
        })
}

function showHistoryHargaBeli(){
    var ID = document.getElementById("ID").value;
    var base_url = window.location.origin;
    $('#tbl_hargabeli').DataTable().clear().destroy();
    $('#tbl_hargabeli').DataTable({
        "ordering": false,
        "paging": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/MasterDataBarang/getHistoryHargaBeli/",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.ID = ID; 
            }
        },
        "columns": [
            { "data": "id" },
            { "data": "DeliveryCode" },
            { "data": "DeliveryDate" },
            { "data": "NominalHargabeli" },
            { "data": "NominalDiskon" },
            { "data": "NominalHpp" },
            { "data": "UserCreate" },
            { "data": "Status" },
            { "data": "UserBatal" },
        ], 

    });
    $(".preloader").fadeOut();
}

function showHistoryHargaJual(){
    var ID = document.getElementById("ID").value;
    var base_url = window.location.origin;
    $('#tbl_hargajual').DataTable().clear().destroy();
    $('#tbl_hargajual').DataTable({
        "ordering": false,
        "paging": false,
        //"order": [[ 2, "desc" ]],
        "ajax": {
            "url": base_url + "/SIKBREC/public/MasterDataBarang/getHistoryHargaJual/",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.ID = ID; 
            }
        },
        "columns": [
            { "data" : "id" },
            { "data" : "DeliveryCode" },
            { "data" : "DeliveryDate" },
            { "data" : "NominalHna" },
            { "data" : "NominalHnaMinDiskon" },
            { "data" : "UserCreate" },
            { "data" : "StartDate" },
            { "data" : "ExpiredDate" },
            { "data" : "Status" },
            { "data" : "UserBatal" },
            { "data" : "TglBatal" },
        ], 

    });
    $(".preloader").fadeOut();
    
}