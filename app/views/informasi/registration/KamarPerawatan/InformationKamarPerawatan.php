<?php
date_default_timezone_set('Asia/Jakarta');
//include "halaman/header.php";
$datenowcreate = date("Y-m-d");
$datetimenow = date("Y-m-d\TH:i:s");
?>
<style>
    table {
        border: 2px solid #6C6A61;
        border-collapse: collapse;
        font-size: 10px;
    }

    th,
    td {
        border: 1px solid #bbb;
        padding: 2px 8px 0;
        font-size: 10px;
    }

    thead>tr>th {
        background-color: #C0C0C0;
        border-bottom: 2px solid #999;
        font-size: 12px;
    }
</style>
<div class="main-page">


    <section class="section">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5><?= $data['judul'] ?></h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="form_cuti">
                                <div class="form-group">

                                    <label for="inputEmail3" class="col-sm-2 control-label">Periode</label>
                                    <div class="col-sm-2">
                                        <input type="month" class="form-control" name="Periode" id="Periode">
                                    </div>

                                </div>

                                <!-- <div class="form-group">

                                    <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Rekap</label>
                                    <div class="col-sm-5">
                                        <select class="form-control js-example-basic-single" id="JenisRekap" name="JenisRekap" onchange="clearVal()">
                                            <option VALUE="">-- Pilih --</option>
                                            <option VALUE="1">Rekap Dokter</option>
                                            <option VALUE="2">Rekap Dokter & Unit</option>
                                            <option VALUE="3">Rekap Rujukan</option>
                                            <option VALUE="4">Rekap Unit ( Untuk Rajal / IGD / HD )</option>
                                            <option VALUE="6">Rekap Penjamin Perusahaan</option>
                                            <option VALUE="7">Rekap Penjamin Asuransi</option>
                                        </select>
                                    </div>
                                </div> -->

                                <a type="button" class="btn btn-success btn-animated btn-wide" id="btnLoadInformation" name="btnLoadInformation"><span class="visible-content">Load</span><span class="hidden-content"><i class="fa fa-gear"></i></span></a>

                                <!-- <button type="button" class="btn btn-success btn-animated btn-wide" id="excelLanscape" name="excelLanscape"><span class="visible-content" class="btn btn-primary">Excel</button> -->
                            </form>

                            <hr>
                            <div class="panel-body">
                                <div class="demo-table" style="overflow-x:auto;">
                                    <table id="datatable" class="display" width="100%" >
                                        <thead>
                                            <tr>
                                            <th align='center'>ID</th>
                                            <th align='center'>NoRegistrasi</th>
                                            <th align='center'>PatientName</th>
                                            <th align='center'>StartdateReg</th>
                                            <th align='center'>EndDateReg</th>
                                            <th align='center'>RoomName_Awal</th>
                                            <th align='center'>RoomName_Akhir</th>
                                            <th align='center'>Periode</th>
                                            <th align='center'>date1</th>
                                            <th align='center'>date2</th>
                                            <th align='center'>date3</th>
                                            <th align='center'>date4</th>
                                            <th align='center'>date5</th>
                                            <th align='center'>date6</th>
                                            <th align='center'>date7</th>
                                            <th align='center'>date8</th>
                                            <th align='center'>date9</th>
                                            <th align='center'>date10</th>
                                            <th align='center'>date11</th>
                                            <th align='center'>date12</th>
                                            <th align='center'>date13</th>
                                            <th align='center'>date14</th>
                                            <th align='center'>date15</th>
                                            <th align='center'>date16</th>
                                            <th align='center'>date17</th>
                                            <th align='center'>date18</th>
                                            <th align='center'>date19</th>
                                            <th align='center'>date20</th>
                                            <th align='center'>date21</th>
                                            <th align='center'>date22</th>
                                            <th align='center'>date23</th>
                                            <th align='center'>date24</th>
                                            <th align='center'>date25</th>
                                            <th align='center'>date26</th>
                                            <th align='center'>date27</th>
                                            <th align='center'>date28</th>
                                            <th align='center'>date29</th>
                                            <th align='center'>date30</th>
                                            <th align='center'>date31</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                 <th align='center'><font size="2">Total</font></th>
                                                 <th id="totalx"></th>
                                                 <th align='center' colspan="5"></th>
                                                 <th align='center' >Sub Total</th>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>

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

</div>
<!-- /.content-container -->
</div>
<!-- /.content-wrapper -->

</div>
<!-- /.main-wrapper -->
<!-- ========== COMMON JS FILES ========== -->
<script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/informasi/registration/KamarPerawatan/Information_KamarPerawatan.js"></script>