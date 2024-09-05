$(document).ready(function () {
    convertNumberToRp();
    asyncShowMain();
    // buton save ditekan
    const saveButton = document.querySelector('#btnSave');
    saveButton.addEventListener('click', async function () {
        try {
            const result = await saveMasterDokter();
            if (result.status == "success") {
                toast(result.message, "success")
                setTimeout(function () { MyBack(); }, 1000);
            }
             
        } catch (err) {
           
            toast(err, "error")
        }
    })
});
async function saveMasterDokter() {

    $(".preloader").fadeIn();
    $('#btnSave').html('Please Wait...');
    $('#btnSave').addClass('btn-danger');
    document.getElementById("btnSave").disabled = true;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataDokter/addDokter';

    // data form
    var FixSalary = price_to_number(document.getElementById("FixSalary").value);
    var ShareKonsul = price_to_number(document.getElementById("ShareKonsul").value);
    var NilaiFI = price_to_number(document.getElementById("NilaiFI").value);
    var NilaiGIGF = price_to_number(document.getElementById("NilaiGIGF").value); 

    var IdAuto = document.getElementById("IdAuto").value;
    var NamaDokter = document.getElementById("NamaDokter").value;
    var Spesialis = document.getElementById("Spesialis").value;
    var JobTitle = document.getElementById("JobTitle").value;
    var Category = document.getElementById("Category").value;
    var GrupPerawatan = document.getElementById("GrupPerawatan").value;
    var AlamatDokter = document.getElementById("AlamatDokter").value;
    var Kota = document.getElementById("Kota").value;
    var TglLahirDokter = document.getElementById("TglLahirDokter").value;
    var TlpDokter = document.getElementById("TlpDokter").value;
    var NOHP = document.getElementById("NOHP").value;
    var EmailDokter = document.getElementById("EmailDokter").value; 
    var NOSIP = document.getElementById("NOSIP").value; 
    var Praktek = document.getElementById("Praktek").value;


    var Status = document.getElementById("Status").value;
    var Permanen = document.getElementById("Permanen").value;
    var NPWP = document.getElementById("NPWP").value;
    var NamaBank = document.getElementById("NamaBank").value;
    var Norek = document.getElementById("Norek").value;

    var AtasnamaRek = document.getElementById("AtasnamaRek").value;
    var FSFI = document.getElementById("FSFI").value;
    var FSFIProsen = document.getElementById("FSFIProsen").value;
    var FSGIGF = document.getElementById("FSGIGF").value;
    var KodeTipeJasa = document.getElementById("KodeTipeJasa").value; 
    var GroupSpesialis = document.getElementById("GroupSpesialis").value; 
    var IDDokter_BPJS = document.getElementById("IDDokter_BPJS").value; 
    var CodeAntrian = document.getElementById("CodeAntrian").value; 
    var Pendidikan = document.getElementById("Pendidikan").value; 
    var Description = document.getElementById("Description").value; 
    var Pelatihan = document.getElementById("Pelatihan").value; 
    var NIK = document.getElementById("NIK").value; 

    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "IdAuto=" + IdAuto
            + "&NamaDokter=" + NamaDokter + "&Spesialis=" + Spesialis
            + "&JobTitle=" + JobTitle + "&Category=" + Category
            + "&GrupPerawatan=" + GrupPerawatan + "&AlamatDokter=" + AlamatDokter
            + "&Kota=" + Kota + "&TglLahirDokter=" + TglLahirDokter
            + "&TlpDokter=" + TlpDokter + "&NOHP=" + NOHP
            + "&EmailDokter=" + EmailDokter  
            + "&FixSalary=" + FixSalary + "&NOSIP=" + NOSIP
            + "&ShareKonsul=" + ShareKonsul + "&Praktek=" + Praktek 
            + "&Status=" + Status + "&Permanen=" + Permanen + "&NPWP=" + NPWP + "&NamaBank=" + NamaBank
            + "&Norek=" + Norek + "&AtasnamaRek=" + AtasnamaRek + "&FSFI=" + FSFI + "&FSFIProsen=" + FSFIProsen
            + "&NilaiFI=" + NilaiFI + "&FSGIGF=" + FSGIGF + "&NilaiGIGF=" + NilaiGIGF
            + "&KodeTipeJasa=" + KodeTipeJasa + "&GroupSpesialis=" + GroupSpesialis
            + "&IDDokter_BPJS=" + IDDokter_BPJS + "&CodeAntrian=" + CodeAntrian + "&Pendidikan=" + Pendidikan + "&Description=" + Description + "&Pelatihan=" + Pelatihan
            + "&NIK=" + NIK
            
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
async function asyncShowMain() {
    try {
        await getHakAksesByForm(12);
        const datagetJobTitle = await getJobTitle();
        const datagetGrupPerawatan = await getGrupPerawatan();
        const datagetDataGroupSpesialis = await getDataGroupSpesialis();
        const datagetDataDokterbyId = await getDataDokterbyId();
        updateUIgetJobTitle(datagetJobTitle);
        updateUIgetGrupPerawatan(datagetGrupPerawatan);
        updateUIdatagetDataGroupSpesialis(datagetDataGroupSpesialis);
        updateUIdatagetDataDokterbyId(datagetDataDokterbyId);
        console.log(datagetDataDokterbyId);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatagetDataDokterbyId(datagetDataDokterbyId) {
    let dataResponse = datagetDataDokterbyId; 
    $("#Category").select2();
    $("#Praktek").select2();
    $("#Status").select2();
    $("#Permanen").select2();
    $("#FSFI").select2();
    $("#FSFIProsen").select2();
    $("#FSGIGF").select2();
    $("#KodeTipeJasa").select2();
    $("#GroupSpesialis").select2();
    $(".preloader").fadeOut();
    $("#IdAuto").val(convertEntities(dataResponse.data.ID));
    $("#NamaDokter").val(convertEntities(dataResponse.data.First_Name));
    $("#Spesialis").val(convertEntities(dataResponse.data.Spesialis));
    $("#JobTitle").val(convertEntities(dataResponse.data.Job_Title));
   // $("#Category").val(convertEntities(dataResponse.data.designationId));
    $("#Category").val(convertEntities(dataResponse.data.designationId)).trigger('change');
    $("#GrupPerawatan").val(convertEntities(dataResponse.data.GroupPerawatan));
    $("#AlamatDokter").val(convertEntities(dataResponse.data.Address));
    $("#Kota").val(convertEntities(dataResponse.data.City));
    $("#TglLahirDokter").val(convertEntities(dataResponse.data.Birth_Date));
    $("#TlpDokter").val(convertEntities(dataResponse.data.Phone));
    $("#NOHP").val(convertEntities(dataResponse.data.Mob_Phone));
    $("#EmailDokter").val(convertEntities(dataResponse.data.Email));
    $("#FixSalary").val(convertEntities(number_to_price(dataResponse.data.Fix_Salary)));
    $("#NOSIP").val(convertEntities(dataResponse.data.NoSIP));
    $("#ShareKonsul").val(convertEntities(dataResponse.data.jasmed)); 
    $("#Praktek").val(convertEntities(dataResponse.data.Praktek)).trigger('change');
    $("#Status").val(convertEntities(dataResponse.data.active)).trigger('change');
    $("#Permanen").val(convertEntities(dataResponse.data.Permanen)).trigger('change');
    $("#NPWP").val(convertEntities(dataResponse.data.NPWP_No));
    $("#NamaBank").val(convertEntities(dataResponse.data.Nama_Bank_Transfer));
    $("#Norek").val(convertEntities(dataResponse.data.No_Bank_Transfer));
    $("#AtasnamaRek").val(convertEntities(dataResponse.data.Atas_Nama_Transfer)); 
    $("#FSFIProsen").val(convertEntities(dataResponse.data.FS_FI_PROSEN));
    $("#NilaiFI").val(convertEntities(number_to_price(dataResponse.data.NILAI_FI))); 
    $("#NilaiGIGF").val(convertEntities(number_to_price(dataResponse.data.NILAI_GI_GF))); 
    $("#GroupSpesialis").val(convertEntities(dataResponse.data.GroupSpesialis)).trigger('change');

    $("#FSFI").val(convertEntities(dataResponse.data.Permanen)).trigger('change');
    $("#FSGIGF").val(convertEntities(dataResponse.data.FS_GI_GF)).trigger('change'); 
    $("#KodeTipeJasa").val(convertEntities(dataResponse.data.KD_TIPE_JASA)).trigger('change');
    $("#IDDokter_BPJS").val(convertEntities(dataResponse.data.ID_Dokter_BPJS)); 
    $("#CodeAntrian").val(convertEntities(dataResponse.data.CodeAntrian));
    $("#Pendidikan").val(convertEntities(dataResponse.data.Pendidikan));
    $("#Description").val(convertEntities(dataResponse.data.Description));
    $("#Pelatihan").val(convertEntities(dataResponse.data.Pelatihan));
    $("#NIK").val(convertEntities(dataResponse.data.NoIdentitasKTP));

}
function getDataDokterbyId() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataDokter/getDokterId/';
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
function updateUIgetGrupPerawatan(datagetGrupPerawatan) {
    let data = datagetGrupPerawatan;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#GrupPerawatan").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].ID + '">' + data.data[i].NamaUnit + '</option';
            $("#GrupPerawatan").append(newRow);
        }
    }
}
function getGrupPerawatan() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataDokter/getGrupPerawatan';
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
///harus ada
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
function updateUIgetJobTitle(datagetJobTitle) {
    let data = datagetJobTitle;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#JobTitle").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].JobTitle + '">' + data.data[i].JobTitle + '</option';
            $("#JobTitle").append(newRow);
        }
    }
}
function getJobTitle() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataDokter/getJobTitle';
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
            $("#JobTitle").select2(); 
        })
}

function getDataGroupSpesialis() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataDokter/getDataGroupSpesialis/';
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
function updateUIdatagetDataGroupSpesialis(datagetDataGroupSpesialis) {
    let data = datagetDataGroupSpesialis;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH GROUP SPESIALIS--</option';
        $("#GroupSpesialis").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].NamaBagian + '">' + data.data[i].NamaBagian + '</option';
            $("#GroupSpesialis").append(newRow);
        }
    }
}


///harus ada
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
    window.location = base_url + "/SIKBREC/public/MasterDataDokter";
}
function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, "").toString(),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return prefix == undefined ? rupiah : rupiah ? "" + rupiah : ",00";
}
function number_to_price(v) {
    if (v == 0) { return '0,00'; }
    v = parseFloat(v);
    v = v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    v = v.split('.').join('*').split(',').join('.').split('*').join(',');
    return v;
}
function price_to_number(v) {
    if (!v) { return 0; }
    v = v.split('.').join('');
    v = v.split(',').join('.');
    return Number(v.replace(/[^0-9.]/g, ""));
}
function convertNumberToRp() {
    var FixSalary = document.getElementById("FixSalary");
    FixSalary.addEventListener("keyup", function (e) {
        FixSalary.value = formatRupiah(this.value);
    }); 
    var ShareKonsul = document.getElementById("ShareKonsul");
    ShareKonsul.addEventListener("keyup", function (e) {
        ShareKonsul.value = formatRupiah(this.value);
    });
    var NilaiFI = document.getElementById("NilaiFI");
    NilaiFI.addEventListener("keyup", function (e) {
        NilaiFI.value = formatRupiah(this.value);
    });
    var NilaiGIGF = document.getElementById("NilaiGIGF");
    NilaiGIGF.addEventListener("keyup", function (e) {
        NilaiGIGF.value = formatRupiah(this.value);
    });
}