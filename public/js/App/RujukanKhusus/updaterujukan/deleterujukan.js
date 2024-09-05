var norujukan =document.getElementById('norujukan')
var tglrujukan =document.getElementById('tglrujukan')
var tglrencanakunjungan =document.getElementById('tglrencanakunjungan')
var daftarnamafakes =document.getElementById('daftarnamafakes')
var jenispelayanan =document.getElementById('jenispelayanan')
var diagnosarujukan =document.getElementById('diagnosarujukan')
var tiperujukan =document.getElementById('tiperujukan')
var catatan =document.getElementById('catatan')
var tomboldelete = document.getElementById('deleterujukan')
$(tomboldelete).click(function (e) {
    e.preventDefault()
    if(norujukan.value==""){
        swal({
            title: "Warning",
            text: "Nomor Rujukan Tidak Ditemukan",
            icon: "warning",
        })
    }else if(tglrujukan.value==""){
        swal({
            title: "Warning",
            text: "Nomor Tanggal rujukan Tidak Boleh kosong",
            icon: "warning",
        })

    }else if(tglrencanakunjungan.value==""){
        swal({
            title: "Warning",
            text: "Nomor Tanggal rencana rujukan Tidak Boleh kosong",
            icon: "warning",
        })

    }else if(daftarnamafakes.value==""){
        swal({
            title: "Warning",
            text: "Nama Fakes tidak boleh kosong",
            icon: "warning",
        })

    }else if(jenispelayanan.value==""){
        swal({
            title: "Warning",
            text: "Jenis Pelayanan tidak boleh kosong",
            icon: "warning",
        })

    }else if(diagnosarujukan.value==""){
        swal({
            title: "Warning",
            text: "Diagnosa tidak boleh kosong",
            icon: "warning",
        })

    }else if(tiperujukan.value==""){
        swal({
            title: "Warning",
            text: "Tipe Rujukan tidak boleh kosong",
            icon: "warning",
        })

    }else if(catatan.value==""){
        swal({
            title: "Warning",
            text: "Jenis PelayanaCatatan tidak boleh kosong",
            icon: "warning",
        })
    }
    swal({
        title: "Apakah Anda yakin ingin menghapus data rujukan",
        text: "Sekali di delete, anda tidak dapat mengembalikan data ini!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            var formData ={
                noRujukan:norujukan.value,
                user:namauser
            }
            $.ajax({
                type: "POST",
                url: base_url + '/SIKBREC/public/Rujukan/deleteDatarujukan',
                data: formData,
                dataType: "json",
                encode: true,
            }).done(function (data) {
                console.log(data)
                if(data.status=="warning"){
                    // alert(data.errorname,data.metadata.message)
                    swal({
                        title: "error",
                        text: data.errorname,
                        icon: "error",
                    })
                }else{
                    swal("Poof! Data Rujukan Berhasil Di hapus!", {
                        icon: "success",
                    });
                }
            })
        } else {
            swal("Canceled!");
        }
    });
})