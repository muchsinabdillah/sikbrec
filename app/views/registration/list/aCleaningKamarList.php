
<div class="main-page">
    <section class="section" style="margin-top: -20px;">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5 class="underline mt-30"><?= $data['judul'] ?><small></small>
                                    <!-- <div class="btn-group" role="group">
                                        <a class="btn btn-primary btn-sm btn-rounded " id="btncreateMR"
                                            onclick="inputreservasi();">
                                            <span class="glyphicon glyphicon glyphicon-plus"></span> Booking Kamar Baru</a>
                                    </div> -->
                                </h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <!-- <form class="form-horizontal" id="form_reservationlist"> -->

                            <ul class="nav nav-tabs border-bottom border-primary" role="tablist">
                                <li role="presentation" class="active"><a class="" href="#reservasi_aktif"
                                        aria-controls="reservasi_aktif" role="tab" data-toggle="tab">List</a>
                                </li>
                                <!-- <li role="presentation"><a class="" href="#reservasi_arsip"
                                        aria-controls="reservasi_arsip" role="tab" data-toggle="tab">Arsip Booking</a>
                                </li> -->

                            </ul>
                            <!-- </form> -->

                            <div class="tab-content bg-white p-15">
                                <div role="tabpanel" class="tab-pane active" id="reservasi_aktif">
                                    <div class="form-horizontal" id="frmSimpanTrsRegistrasi">

                                   
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label"> Lantai</label>
                                    <div class="col-sm-5">
                                        <select class="form-control js-example-basic-single" id="Lantai" name="Lantai" >
                                            <option value="">-- Pilih --</option>
                                            <option value="1">Lantai 1</option>
                                            <option value="2">Lantai 2</option>
                                            <option value="3">Lantai 3</option>
                                            <option value="4">Lantai 4</option>
                                            <option value="5">Lantai 5</option>
                                            <option value="6">Lantai 6</option>
                                            <option value="7">Lantai 7</option>
                                            <option value="8">Lantai 8</option>
                                            <option value="9">Lantai 9</option>
                                            <option value="10">Lantai 10</option>
                                            <option value="11">Lantai 11</option>
                                            <option value="12">Lantai 12</option>
                                        </select>
                                    </div>
                                            <div class="col-sm-2">
                                                <button class="form-control input-sm" id="btnSearch" name="btnSearch">Cari</button>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="demo-table" width="100%" id="tbl_rekap"
                                            style="margin-top: 10px;overflow-x:auto;">
                                            <form id="form_approve">
                                                <table id="tbl_aktif" width="100%"
                                                    class="table table-striped table-hover cell-border">
                                                    <thead>
                                                        <tr>
                                                            <th align='center'>
                                                                <font size="1">
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">ID
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Kelas
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Ruangan
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Bed
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Tarif
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Status
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Action
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id='tabledatareservasi'>

                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th colspan="7"></th>
                                                            <th align="center"><button type="button"
                                                                    title="Ready Yang Dipilih"
                                                                    class="btn btn-maroon btn-xs"
                                                                    id="cb_approvefarmasiall"
                                                                    name="cb_approvefarmasiall"
                                                                    onclick="BtnApprove(this)"> Ready Selected </button>
                                                            </th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </form>
                                        </div>



                                    </div>
                                </div>
                            </div>

                        </div>


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
<!-- /.main-page -->
<div class="right-sidebar bg-white fixed-sidebar">
    <div class="sidebar-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h4>Useful Sidebar <i class="fa fa-times close-icon"></i></h4>
                    <p>Code for help is added within the main page. Check for code below the example.</p>
                    <p>You can use this sidebar to help your end-users. You can enter any HTML in this sidebar.</p>
                    <p>This sidebar can be a 'fixed to top' or you can unpin it to scroll with main page.</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                        laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                        voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                        non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                </div>
                <!-- /.col-md-12 -->

                <div class="text-center mt-20">
                    <button type="button" class="btn btn-success btn-labeled">Purchase Now<span
                            class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
                </div>
                <!-- /.text-center -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.sidebar-content -->
</div>
<!-- /.right-sidebar -->

</div>
<!-- /.content-container -->
</div>
<!-- /.content-wrapper -->

</div>
<!-- ========== COMMON JS FILES ========== -->
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script>
$(document).ready(function() {
    $(".preloader").fadeOut();
})
</script>
<script src="<?= BASEURL; ?>/js/App/registration/list/listcleaningkamar.js"></script>