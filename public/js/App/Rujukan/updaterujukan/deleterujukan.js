var norujukan = document.getElementById('norujukan');
var tglRujukan = document.getElementById('tglrujukan');
var tglRencanaKunjungan = document.getElementById('tglrencanakunjungan');
var ppkDirujuk = document.getElementById('kodefakes');
var jnsPelayanan = document.getElementById('jenispelayanan');
var jenisfakes = document.getElementById('jenisfakes');
var catatan = document.getElementById('catatan');
var diagRujukan = document.getElementById('diagnosarujukan');
var tipeRujukan = document.getElementById('tiperujukan');
var poliRujukan = document.getElementById('polirujukan');
var namafakes = document.getElementById('namafakes');
var tombolcarirujukan = document.getElementById('caridata')
var kodefaskespilih = document.getElementById('kodefaskespilih')
var namafaskespilih = document.getElementById('namafaskespilih')
var kodediagnosapilih = document.getElementById('kodediagnosapilih')
var namadiagnosapilih = document.getElementById('namadiagnosapilih')
var kodepolipilih = document.getElementById('kodepolipilih')
var namapolipilih = document.getElementById('namapolipilih')
var noseppasien = document.getElementById('noseppasien')
var tomboldelete = document.getElementById('btnVoidTrsReg')
var alasanbatal = document.getElementById('alasanbatal')
$(tomboldelete).click(function (e) {
    e.preventDefault()
     
    swal({
        title: "Konfirmasi",
        text: "Apakah Anda Yakin ingin Hapus Rujukan?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            var formData ={
                noRujukan:norujukan.value,
                user:namauser,
                alasanbatal:alasanbatal.value
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
                    console.log("dada", data)
                    // alert(data.errorname,data.metadata.message)
                    swal({
                        title: "error",
                        text: data.errorname,
                        icon: "error",
                    })
                }else{
                    swal("Poof! Data Rujukan Berhasil Di hapus!", {
                        icon: "success",
                    }).then((willDelete) => {
                        if (willDelete) { 
                            location.reload();
                        }
                    });
                }
            })
        } else {
            swal("Canceled!");
        }
    });
})
 