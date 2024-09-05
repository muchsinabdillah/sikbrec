$(document).ready(function () {
    $(".preloader").fadeOut(); 
    // $('#btnLoadInformation').attr('disabled', false);
    $('#datatable').DataTable({});
    $('#datatable_listuse').DataTable({});
    $(document).on('click', '#btnLoadInformation', function () {
        var as = $("#PeriodeAwal").val()
        var ed = $("#PeriodeAkhir").val()
        var cek = CheckVar(as,ed);
        if (cek == true){ 
            getDataInfoIndikatorWaktu(as,ed);
        }

    });
    $(document).on('click', '#btnLoadInformation_use', function () {
        var as = $("#PeriodeAwal_use").val()
        var ed = $("#PeriodeAkhir_use").val()
        var cek = CheckVar(as,ed);
        if (cek == true){
            getDataInfoIndikatorQTY(as,ed);
       }
    });
});

function TrigerTgl() {
    // var PeriodeAwal = document.getElementById("PeriodeAwal").value;
    // var PeriodeAkhir = document.getElementById("PeriodeAkhir").value;
    // var nowDateawal = new Date(PeriodeAwal);
    // var nowDateakhir = new Date(PeriodeAkhir);
    // var Difference_In_Time = nowDateakhir.getTime() - nowDateawal.getTime();
    // var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
    // console.log(Difference_In_Days)
    // if (Difference_In_Days > 31) {
    //     alert("Periode Penarikan Data Adalah 31 Hari maksimal dari Tanggal Awal. !");
    //     $("#PeriodeAwal").val('');
    //     $("#PeriodeAkhir").val('');
    //     $('#btnLoadInformation').attr('disabled', true);
    // } else {
    //     $('#btnLoadInformation').attr('disabled', false);
    // }
}
function CheckVar (as,ed){
    //if not in creteria return false
    if (as == ''){
        toast ('Isi Periode Awal', "warning");
        return false;
    }
    if (ed == ''){
        toast ('Isi Periode Akhir', "warning");
        return false;
    }

    return true;
}


function getDataInfoIndikatorWaktu(as,ed) { 
    // let PeriodeAwal ,PeriodeAkhir;
    // PeriodeAwal = $("#PeriodeAwal").val();
    // PeriodeAkhir = $("#PeriodeAkhir").val();
    var base_url = window.location.origin;
    $('#datatable').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#datatable').DataTable({
        "ordering": true, // Set true agar bisa di sorting
        "order": [[ 0, 'desc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax":
        {
               "url": base_url + "/SIKBREC/public/bInfoBankDarah/getDataInfoIndikatorWaktu", // URL file untuk proses select datanya
               "type": "POST",
               data: function ( d ) {
                d.TglAwal = as;
                d.TglAkhir = ed;
               },
                "dataSrc": "",
           "deferRender": true,
           }, 
           "columns": [
          { "render": function ( data, type, row ) { // Tampilkan kolom aksi
            var html = ""
            var html  =  '<font size="2"> '+row.ID+'</font> ';
            return html 
        }
      },
       { "render": function ( data, type, row ) { // Tampilkan kolom aksi
            var html = ""
            var html  =  '<font size="2"> '+row.NoMR+'</font> ';
            return html 
        }
      },
      { "render": function ( data, type, row ) { // Tampilkan kolom aksi
            var html = ""
            var html  =  '<font size="2"> '+row.NoEpisode+'</font> ';
            return html 
        }
      },
      { "render": function ( data, type, row ) { // Tampilkan kolom aksi
            var html = ""
            var html  =  '<font size="2"> '+row.NoRegistrasi+'</font> ';
            return html 
        }
      },
      { "render": function ( data, type, row ) { // Tampilkan kolom aksi
        var html = ""
        var html  =  '<font size="2"> '+row.UserOrderName+'</font> ';
        return html 
    }
    },
      { "render": function ( data, type, row ) { // Tampilkan kolom aksi
            var html = ""
            var html  =  '<font size="2"> '+row.UnitOrderName+'</font> ';
            return html 
        }
    },
    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
        var html = ""
        var html  =  '<font size="2"> '+row.ApproveKasir+'</font> ';
        return html 
    }
    },
    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
        var html = ""
        var html  =  '<font size="2"> '+row.ApproveBDRS+'</font> ';
        return html 
    }
    },
    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
        var html = ""
        var html  =  '<font size="2"> '+row.NamaTarifDarah+'</font> ';
        return html 
    }
    },
    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
        var html = ""
        var html  =  '<font size="2"> '+row.Barcode+'</font> ';
        return html 
    }
    },
    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
        var html = ""
        var html  =  '<font size="2"> '+row.TglExpiredPMI+'</font> ';
        return html 
    }
    },
    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
        var html = ""
        var html  =  '<font size="2"> '+row.TglExpiredPemakaian+'</font> ';
        return html 
    }
    },
    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
        var html = ""
        var html  =  '<font size="2"> '+row.TglOrder+'</font> ';
        return html 
    }
    },
    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
        var html = ""
        var html  =  '<font size="2"> '+row.TglReviewBDRS+'</font> ';
        return html 
    }
    },
    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
        var html = ""
        var html  =  '<font size="2"> '+row.TglApproveKasir+'</font> ';
        return html 
    }
    },
    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
        var html = ""
        var html  =  '<font size="2"> '+row.TglDarahDisiapkanBDRS+'</font> ';
        return html 
    }
    },
    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
        var html = ""
        var html  =  '<font size="2"> '+row.TglHandOverBDRS_Perawat+'</font> ';
        return html 
    }
    },
    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
        var html = ""
        var html  =  '<font size="2"> '+row.PetugasBDRS+'</font> ';
        return html 
    }
    },
    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
        var html = ""
        var html  =  '<font size="2"> '+row.Perawat+'</font> ';
        return html 
    }
    },
    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
        var html = ""
        var html  =  '<font size="2"> '+row.TglHandOverPerawat+'</font> ';
        return html 
    }
    },
    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
        var html = ""
        var html  =  '<font size="2"> '+row.HandoverPerawat1+'</font> ';
        return html 
    }
    },
    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
        var html = ""
        var html  =  '<font size="2"> '+row.HandoverPerawat2+'</font> ';
        return html 
    }
    },
    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
        var html = ""
        var html  =  '<font size="2"> '+row.HistoryIncompatibility+'</font> ';
        return html 
    }
    },
    { "render": function ( data, type, row ) { // Tampilkan kolom aksi
        var html = ""
        var html  =  '<font size="2"> '+row.AutoControl+'</font> ';
        return html 
    }
    },
                ],
                dom: 'Bfrtip',
                buttons: [
                'copyHtml5',
                {
                    extend: 'excelHtml5',
                    
                },
                'print',
                'csv'
            ]
            });
          
          }

function getDataInfoIndikatorQTY(as,ed) { 
    // let PeriodeAwal ,PeriodeAkhir;
    // PeriodeAwal = $("#PeriodeAwal_use").val();
    // PeriodeAkhir = $("#PeriodeAkhir_use").val();
    var base_url = window.location.origin;
    $('#datatable_listuse').dataTable({
        "bDestroy": true
    }).fnDestroy();
    $('#datatable_listuse').DataTable({
        "ordering": true, 
        "order": [[ 0, 'desc' ]], 
        "ajax":
        {
               "url": base_url + "/SIKBREC/public/bInfoBankDarah/getDataInfoIndikatorQTY", 
               "type": "POST",
               data: function ( d ) {
               d.TglAwal = as;
               d.TglAkhir = ed;
               },
                "dataSrc": "",
           "deferRender": true,
           }, 
           "columns": [
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                var html  =  '<font size="2"> '+row.ID+'</font> ';
                return html 
            }
          },
          { "render": function ( data, type, row ) { // Tampilkan kolom aksi
            var html = ""
            var html  =  '<font size="2"> '+row.NoMR+'</font> ';
            return html 
        }
      },
      { "render": function ( data, type, row ) { // Tampilkan kolom aksi
           var html = ""
           var html  =  '<font size="2"> '+row.PatientName+'</font> ';
           return html 
       }
     },
           { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                var html  =  '<font size="2"> '+row.NoEpisode+'</font> ';
                return html 
            }
          },
          { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                var html  =  '<font size="2"> '+row.NoRegistrasi+'</font> ';
                return html 
            }
          },
          { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                var html  =  '<font size="2"> '+row.UserOrderName+'</font> ';
                return html 
            }
          },
          { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                var html  =  '<font size="2"> '+row.UnitOrderName+'</font> ';
                return html 
            }
      },
        { "render": function ( data, type, row ) { // Tampilkan kolom aksi
            var html = ""
            var html  =  '<font size="2"> '+row.ApproveKasir+'</font> ';
            return html 
        }
        },
                { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                    var html = ""
                    var html  =  '<font size="2"> '+row.ApproveBDRS+'</font> ';
                    return html 
                }
            },
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                var html  =  '<font size="2"> '+row.TglOrder+'</font> ';
                return html 
            }
        },
            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                var html = ""
                var html  =  '<font size="2"> '+row.QtyOrder_Old+'</font> ';
                return html 
            }
        },
        { "render": function ( data, type, row ) { // Tampilkan kolom aksi
            var html = ""
            var html  =  '<font size="2"> '+row.QtyOrder+'</font> ';
            return html 
        }
        },
        { "render": function ( data, type, row ) { // Tampilkan kolom aksi
            var html = ""
            var html  =  '<font size="2"> '+row.QtyPakai+'</font> ';
            return html 
        }
        },
        { "render": function ( data, type, row ) { // Tampilkan kolom aksi
            var html = ""
            var html  =  '<font size="2"> '+row.QtySisa+'</font> ';
            return html 
        }
        },
        { "render": function ( data, type, row ) { // Tampilkan kolom aksi
            var html = ""
            var html  =  '<font size="2"> '+row.QtyPakaiPerawat+'</font> ';
            return html 
        }
        },
        ],
        dom: 'Bfrtip',
                buttons: [
                'copyHtml5',
                {
                    extend: 'excelHtml5',
                    
                },
                'print',
                'csv'
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
