$(document).ready(function(){
    $(".preloader").fadeOut();
    $("#tbl_aktif").dataTable();
    $("#tbl_arsip").dataTable();
    })
    
    
    var base_url = window.location.origin;
    var tglawal = document.getElementById('tglAwalReservasi')
    var tglakhir = document.getElementById('tglAkhirReservasi')
    
    function caridatareservasi() { 
        var base_url = window.location.origin;
        var tanggal_awal = $("#tglAwalReservasi").val();
        var tanggal_akhir = $("#tglAkhirReservasi").val();
        if (tanggal_awal == '' || tanggal_akhir == ''){
            toast('Mohon isi periode !','warning');
            return false
        }
        $('#tbl_aktif').dataTable({
            "bDestroy": true
        }).fnDestroy();
           $('#tbl_aktif').DataTable({
             'ajax':
        {
            "url": base_url + "/SIKBREC/public/aBookingKamar/listAllActive",
            "type": "POST",
            data: function (d) {
             d.StartPeriode = tanggal_awal
             d.EndPeriode = tanggal_akhir
         },
             "dataSrc": "",
        "deferRender": true,
        }, 
        "columns": [
                                { "data": "ID" },
                                { "data": "transactioncode" },
                                { "data": "medicalrecordnumber" },
                                { "data": "patientname" },
                                { "data": "bookingbeddate" },
                                { "data": "classname" },
                                { "data": "roomname" },
                                { "data": "bedname" },
                                { "data": "notes" },
                                { "data": "userentri" },
                                {
                                    "render": function (data, type, row) {
                                        var html = ""
                                        var html = '<button type="button" class="btn btn-maroon border-primary btn-animated btn-xs"  onclick=\'showDatabyID("' + row.transactioncode + '")\'   ><span class="visible-content" > View</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
                                        return html
                                    }
                                },
                                
                               ],
            'columnDefs': [
               {
                  'targets': 0,
                  'checkboxes': {
                     'selectRow': true
                  }
               }
            ],
            'select': {
               'style': 'multi'
            },
            'order' : [1,'asc']
         });
    }  
    
    
    function caridatareservasi_arsip() { 
        var base_url = window.location.origin;
        var tanggal_awal = $("#tglAwalReservasi_arsip").val();
        var tanggal_akhir = $("#tglAkhirReservasi_arsip").val();
        $('#tbl_arsip').dataTable({
            "bDestroy": true
        }).fnDestroy();
           $('#tbl_arsip').DataTable({
             'ajax':
        {
            "url": base_url + "/SIKBREC/public/aBookingKamar/listAllArchive", // URL file untuk proses select datanya
            "type": "POST",
            data: function (d) {
                d.StartPeriode = tanggal_awal
                d.EndPeriode = tanggal_akhir
         },
             "dataSrc": "",
        "deferRender": true,
        }, 
        "columns": [
            { "data": "transactioncode" },
            { "data": "medicalrecordnumber" },
            { "data": "patientname" },
            { "data": "bookingbeddate" },
            { "data": "classname" },
            { "data": "roomname" },
            { "data": "bedname" },
            { "data": "notes" },
            { "data": "userentri" },
            { "data": "userupdate" },
                               ],
            'order' : [0,'asc']
         });
    } 
    
    function BtnApprove(thisid){
        var table = $('#tbl_aktif').DataTable();
        var form = $("#form_approve");
        //var id = $(thisid).attr("id");
    
        // Remove added elements
        $('input[name="idorderapprove\[\]"]', form).remove();
        
        var rows_selected = table.column(0).checkboxes.selected();
    
         var count = $.each(rows_selected, function(index, rowId){
           $(form).append(
               $('<input>')
                  .attr('type', 'hidden')
                  .attr('name', 'idorderapprove[]')
                  .val(rowId)
           );
       });
    
       //Cek if checkbox check at least 1 item
        var list = [(rows_selected.join(","))];
        if (list == ''){
            toast('Silahkan Pilih Minimal 1 Item','warning');
            return false;
        }
    
        //Swal
        swal("Note ( Jika ada perubahan Jadwal atau Lainnya / Isikan - jika tidak ada. ) : ", {
            content: "input",
            buttons: true,
        })
            .then((value) => {
                if (value) {
                    ApproveCheckbox(value);
                } 
            });
    }
    
    async function ApproveCheckbox(value) {
        try {
            const dataApproveAll = await ApproveAll(value);
            updateUIdataApproveAll(dataApproveAll);
        } catch (err) {
            toast(err.message, "error")
        }
    }
    
    function updateUIdataApproveAll(params) {
        let response = params;
        if (response.status == "success") {
            toast(response.message, "success")
            swal({
                title: "Kirim Berhasil!",
                text: response.message,
                icon: "success",
            })
            caridatareservasi();
        }else{
            toast(response.message, "error")
        }  
    
    }
    
    async function ApproveAll(noted) {
        $(".preloader").fadeIn();
        var form = $("#form_approve").serialize();
        var base_url = window.location.origin;
        let url = base_url + '/SIKBREC/public/aReservasipasiennonWalkin/sendreminderAll';
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: form + '&noted=' + noted
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
    
    
    function inputreservasi() {
        const base_url = window.location.origin;
        window.location = base_url + "/SIKBREC/public/aBookingKamar/input";
    }
    
    async function btn_sendreminder(param) {
        try {
            //$(".preloader").fadeIn();
            const dataSendReminder = await SendReminder(param);
            updateUIdataSendReminder(dataSendReminder);
        } catch (err) {
            toast(err.message, "error")
        }
    }
    
    function updateUIdataSendReminder(params) {
        let response = params;
        console.log(response,'sss');
        if (response.status == 200) {
            toast(response.message, "success")
            swal({
                title: "Save Success!",
                text: response.message,
                icon: "success",
            }).then(function() {
    
            });
        }else{
            toast(response.message, "error")
        }  
    
    }
    async function SendReminder(param) {
        var base_url = window.location.origin;
        let url = base_url + '/SIKBREC/public/aReservasiPasiennonWalkin/sendreminder';
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: "idresv=" + param
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
    
    function showDatabyID(str){
             const base_url = window.location.origin;
            var str = btoa(str);
            window.location = base_url + '/SIKBREC/public/aBookingKamar/input/' + str;
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
    
    
    
    
    
    