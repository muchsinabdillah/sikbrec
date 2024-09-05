<style type="text/css">
.signature-area {
    width: 304px;
    margin: 50px auto;
    border: 1px solid black;
}

.signature-container {
    width: 60%;
    margin: auto;
}

.signature-list {
    width: 150px;
    height: 50px;
    border: solid 1px #cfcfcf;
    margin: 10px 5px;
}

.title-area {
    font-family: cursive;
    font-style: oblique;
    font-size: 12px;
    text-align: left;
}

.btn-save {
    color: #fff;
    background: #1c84c6;
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    line-height: 1.5;
    border-radius: 0.2rem;
    border: 1px solid transparent;
}

.btn-clear {
    color: #fff;
    background: #f7a54a;
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    line-height: 1.5;
    border-radius: 0.2rem;
    border: 1px solid transparent;
}
</style>

<div class="main-page">
    <section class="section" style="margin-top: -20px;">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5 class="underline mt-30"><?= $data['judul'] ?><small></small>
                                    <div class="btn-group" role="group">
                                    </div>
                                </h5>
                            </div>
                        </div>
                        <div class="panel-body">

                            <div class="form-horizontal" id="frmSimpanTrsRegistrasi">
                                <div class="form-group  ">
                                    <label for="inputEmail3" class="col-sm-3 control-label"> Tanggal <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm" type="date" id="MTglKunjunganBPJS"
                                            autocomplete="off" name="MTglKunjunganBPJS"
                                            placeholder="ketik Kata Kunci disini">
                                    </div>
                                </div>
                                <div class="form-group gut ">
                                    <label for="inputEmail3" class="col-sm-3 control-label"> Jenis Pelayanan <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-2">
                                        <select id="MJenisPelayananBPJS" nama="MJenisPelayananBPJS"
                                            class="form-control input-sm">
                                            <option value="">-- PILIH --</option>
                                            <option value="1">Rawat Inap</option>
                                            <option value="2">Rawat Jalan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group  ">
                                    <label for="inputEmail3" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-2">
                                        <button type="button" onclick="GoMonitoringBPJS();" id="caridatapasienarsip"
                                            class="btn btn-success btn-wide btn-rounded"><i
                                                class="fa fa-search"></i>Search</button>
                                    </div>
                                </div>
                                <!-- <div class="table-responsive" width="100%" id="tbl_rekap" style="margin-top: 10px;">
                                    <table id="tbl_kunjungan_monitoring" width="100%" class="table table-striped table-hover cell-border">
                                    -->
                                <div class="panel-body">
                                    <div class="demo-table" style="overflow-x:auto;margin-top: 20px;">
                                        <table id="tbl_kunjungan_monitoring" class="display" width="100%">
                                            <thead>
                                                <tr>
                                                    <th align='center'>
                                                        <font size="1">No SEP
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">No Kartu
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">No Rujukan
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Tgl SEP
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Nama Pasien
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Jenis Pelayanan
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Diagnosa
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Kelas Rawat
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Layanan
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Tgl Pulang
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Action
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <!-- <tr>
                                                <td>1212xxx</td>
                                                <td>nikartu12312</td>
                                                <td>norujukan2121</td>
                                                <td>tglsp</td>
                                                <td>1212xxx</td>
                                                <td>1212xxx</td>
                                                <td>1212xxx</td>
                                                <td>1212xxx</td>
                                                <td>1212xxx</td>
                                                <td>1212xxx</td>
                                                <td><button id="tandatangan" class="btn btn-primary">Input Tanda Tangan</button></td>
                                            </tr> -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="copysignature" id="pasienttd">
                        <div class="sig">
                            <div class="typed"></div>
                            <canvas class="" id="gbrttdsaksipasien" width="300" height="100"></canvas>
                        </div>
                    </div>
                    <!-- /.col-md-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
    </section>
    <!-- /.section -->
</div>
<div class="modal fade" id="formtandatangan" role="dialog" style="overflow-y: auto" data-backdrop="static"
    data-keyboard="false">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Form Tanda Tangan</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="form_kepesertaan_Bpjs">
                    <h5 class="underline mt-30">Detai Tanda Tangan Pasien </h5>

                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Tgl. Rujukan </label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm " id="TglRujukan" readonly name="TglRujukan" type="date"
                                placeholder="Ketik Nama Pasien">
                        </div>
                        <label for="inputEmail3" class="col-sm-2 control-label"> Nama </label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm " id="NAMA_PARAM_1" name="NAMA_PARAM_1" type="text">
                            <small>Edit Nama Disini Jika terdapat Perubahan.</small>
                        </div>
                    </div>
                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-2 control-label"> No Sep <sup
                                class="color-danger">*</sup></label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm " id="NO_MR" readonly name="NO_MR" type="text">
                        </div>
                        <label for=" inputEmail3" class="col-sm-2 control-label"> No Registrasi </label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm " id="NO_REGISTRASI" readonly name="NO_REGISTRASI"
                                type="text">
                        </div>

                    </div>
                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-2 control-label"> No Episode </label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm " id="NO_EPISODE" readonly name="NO_EPISODE" type="text"
                                placeholder="Ketik Nama Pasien">
                        </div>
                    </div>

                </form>
                <div class="signature-area" id="ttdsaksipasien">
                    <!-- <h2 class="title-area">Put signature,</h2> -->
                    <!-- <label>nama</label> -->
                    <!-- <input type="text" name="nama" id="nama"> -->
                    <div class="sig sigWrapper" style="height:auto;">
                        <div class="typed"></div>
                        <canvas class="sign-pad" id="sign-pad" width="300" height="100"></canvas>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-warning btn-wide btn-rounded" id="btn-save" name="btn-save"><i
                            class="fa fa-save"></i> SAVE </button>
                    <button type="button" class="btn btn-primary btn-wide btn-rounded" id="clearttdrumahsakit"
                        name="clearttdrumahsakit"><i class="fa fa-eraser"></i> CLEAR </button>
                    <button type="button" class="btn btn-gray btn-wide btn-rounded" id="btnModalSrcPasienClose"
                        data-dismiss="modal"><i class="fa fa-close"></i>Close</button>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script>
let iduser = ` <?= $data['session']->username ?>`
let namauser = ` <?= $data['session']->name ?>`
</script>
<script>
$(document).ready(function() {
    $(".btn-clear").click(function(e) {
        $(".signature-area").signaturePad().clearCanvas();
    });
    $("#clearttdrumahsakit").click(function(e) {
        $("#ttdsaksipasien").signaturePad().clearCanvas();
        console.log('clear')
    });
    $(".signature-area").signaturePad({
        penColour: '#000000',
        drawOnly: true,
        drawBezierCurves: true,
        lineTop: 90,
        lineWidth: 0,
        validateFields: true,
    })

});
</script>
<script src="<?= BASEURL; ?>/js/App/stoploading.js"></script>
<script src="<?= BASEURL; ?>/js/App/Signature/loaddata.js"></script>
<script src="<?= BASEURL; ?>/js/App/Signature/signature.js"></script>