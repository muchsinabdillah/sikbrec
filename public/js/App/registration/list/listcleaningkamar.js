$(document).ready(function(){
    $(".preloader").fadeOut();
    $("#tbl_aktif").dataTable();

    $('#btnSearch').click(function () {
        caridatareservasi()
  });


    })
    
    
    var base_url = window.location.origin;
    var tglawal = document.getElementById('tglAwalReservasi')
    var tglakhir = document.getElementById('tglAkhirReservasi')
    
    function caridatareservasi() { 
        var base_url = window.location.origin;
        var Lantai = $("#Lantai").val();
        if (Lantai == '' ){
            toast('Mohon isi lantai !','warning');
            return false
        }
        $('#tbl_aktif').dataTable({
            "bDestroy": true
        }).fnDestroy();
           $('#tbl_aktif').DataTable({
             'ajax':
        {
            "url": base_url + "/SIKBREC/public/aRegistrasiKamar/getListCleaningRoom",
            "type": "POST",
            data: function (d) {
             d.Lantai = Lantai
         },
             "dataSrc": "",
        "deferRender": true,
        }, 
        "columns": [
                                { "data": "RoomID" },
                                { "data": "RoomID" },
                                { "data": "Class" },
                                { "data": "Room" },
                                { "data": "Bad" },
                                { "data": "TarifKamar" },
                                {
                                    "render": function (data, type, row) {
                                        var html = ""
                                        var html = '<span class="label label-primary">'+row.Status+'</span>'
                                        return html
                                    }
                                },
                                {
                                    "render": function (data, type, row) {
                                        var html = ""
                                        var html = '<button type="button" class="btn btn-maroon border-primary btn-animated btn-xs"  onclick=\'confirmAction("' + row.RoomID + '")\'   ><span class="visible-content" > READY</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>'
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

            swal({
                title: "Simpan",
                text: "Apakah Anda Yakin Ingin Simpan Yang Dipilih ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        ApproveCheckbox()
                    } else {
                       // swal("Transaction Rollback !");
                    }
                });
    }
    
    async function ApproveCheckbox() {
        try {
            const dataApproveAll = await ApproveAll();
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
                title: "Update Berhasil!",
                text: response.message,
                icon: "success",
            })
            caridatareservasi();
        }else{
            toast(response.message, "error")
        }  
    
    }
    
    async function ApproveAll() {
        $(".preloader").fadeIn();
        var form = $("#form_approve").serialize();
        var base_url = window.location.origin;
        let url = base_url + '/SIKBREC/public/aRegistrasiKamar/updateReadySelected';
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: form 
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

    function confirmAction(value){
        swal({
            title: "Simpan",
            text: "Apakah Anda Yakin Ingin Simpan Yang Dipilih ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    goupdateReady(value)
                } else {
                   // swal("Transaction Rollback !");
                }
            });
    }

    async function goupdateReady(value) {
        try {
            const data = await updateReady(value);
            updateUIgoupdateReady(data);
        } catch (err) {
            toast(err.message, "error")
        }
    }

    function updateUIgoupdateReady(params) {
        let response = params;
        if (response.status == 'success') {
            toast(response.message, "success")
            swal({
                title: "Update Success!",
                text: response.message,
                icon: "success",
            }).then(function() {
                caridatareservasi();
            });
        }else{
            toast(response.message, "error")
        }  
    
    }
    async function updateReady(param) {
        var base_url = window.location.origin;
        let url = base_url + '/SIKBREC/public/aRegistrasiKamar/updateReady';
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: "roomid=" + param
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
    
    
    
    
    
    