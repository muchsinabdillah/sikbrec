$(document).ready(function () {
    asyncShowMain();
    // buton save ditekan
    const saveButton = document.querySelector('#btnreservasi');
    saveButton.addEventListener('click', async function (){
        try{
            const result = await saveCoa();  
            if (result.status == "success") {
                toast(result.message, "success")
                setTimeout(function () { MyBack(); }, 1000);
            } 
        } catch (err) { 
               toast(err, "error")
        }
    })
});
function saveCoa() {
    $(".preloader").fadeIn();
    $('#btnreservasi').html('Please Wait...');
    $('#btnreservasi').addClass('btn-danger');
    document.getElementById("btnreservasi").disabled = true;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Coa/addCoa';
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
async function asyncShowMain(){
    try{
        const data = await getRekeningGroup();
        const data2 = await getRekeningGroupCOA();
        const data3 = await getCoaId(); 
        updateUIgetRekeningGroup(data);
        updateUIgetRekeningGroupCOA(data2);
        updateUIShowDataById(data3);
    }catch(err){
        toast(err, "error")
    }
} 
 
function getCoaId() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Coa/getCoaId/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'id=' + $("#KodeRekening").val()
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
        .finally(() =>{
            $(".preloader").fadeOut();
        })
}
function getRekeningGroupCOA() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Coa/getRekeningGroupCOA';
    return fetch(url,{
        method : 'GET',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        data: 'foo=bar&lorem=ipsum'
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
}
function getRekeningGroup(){
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Coa/getRekeningGroup';
    return fetch(url, {
        method: 'GET',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        data: 'foo=bar&lorem=ipsum'
    })
    .then(response => { 
        if(!response.ok){
            throw new Error (response.statusText)
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
}

function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/Coa";
}
function convertEntities($data) {
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
}
function updateUIgetRekeningGroupCOA(repoList) {
    var data = repoList;
    console.log("render repo list RekGroup", data.data);
    if (data.message == "success") {
      
        if (data.data !== null && data.data !== undefined) {
            //console.log(data);
            var newRow = '<option value="">-- PILIH --</option';
            $("#RekeningGroup2").append(newRow);
            for (i = 0; i < data.data.length; i++) {
                var newRow = '<option value="' + data.data[i].FS_KD_REKENING_GROUP_COA + '">' + data.data[i].FS_KD_REKENING_GROUP_COA + '</option';
                $("#RekeningGroup2").append(newRow);
            }
        }
    } else {
        toast(data.data.errorInfo[2], "error");
    }
}
function updateUIgetRekeningGroup(repoList) {
    var data = repoList;
    if (data.message == "success") {
        console.log("render repo list reggroup2", data);
        if (data.data !== null && data.data !== undefined) {
            //console.log(data);
            var newRow = '<option value="">-- PILIH --</option';
            $("#RekeningGroup").append(newRow);
            for (i = 0; i < data.data.length; i++) {
                var newRow = '<option value="' + data.data[i].FS_KD_REKENING_GROUP + '">' + data.data[i].FS_KD_REKENING_GROUP + '</option';
                $("#RekeningGroup").append(newRow);
            }
        }
    } else {
        toast(data.data.errorInfo[2], "error");
    }
}
function updateUIShowDataById(repoList) {
    var data = repoList;
    if (data.message == "success") {
        console.log("render repo list detil", data);
        $("#KodeRekening").val(convertEntities(data.data.FS_KD_REKENING));
        $("#NamaRekening").val(convertEntities(data.data.FS_NM_REKENING));
        $('#StatusRekening').val(data.data.AKTIF).trigger('change');
        $('#LevelGroupCOA').val(data.data.GROUP_REK).trigger('change');
        $('#RekNeraca').val(data.data.FB_NERACA).trigger('change');
        $('#RekBpPiutang').val(data.data.FB_LEDGER_P).trigger('change');
        $('#RekBpHutang').val(data.data.FB_LEDGER_H).trigger('change');
        $('#RekUnitUsaha').val(data.data.FB_UNIT_USAHA).trigger('change');
        $('#RekeningGroup').val(data.data.FS_KD_REKENING_GROUP).trigger('change');
        $('#RekeningGroup2').val(data.data.FS_KD_REKENING_GROUP_COA).trigger('change');
    } else {
        toast(data.data.errorInfo[2], "error");
    }
    $(".preloader").fadeOut();
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