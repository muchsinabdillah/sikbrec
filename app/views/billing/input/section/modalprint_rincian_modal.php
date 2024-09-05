<!-- Modal Rincian Biaya ------------------------------------------------>
<div class="modal fade" id="print_rincian_modal" role="dialog">

    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> Rincian Biaya</h4>
            </div>
            <form method="POST" id="form_rincian_biaya" target="_blank">
                <div class="modal-body">
                    <!--
        <input type="text" id="noreg_print" name="noreg_print" readonly hidden/>
        <input type="text" id="total_klaim_print" name="total_klaim_print" readonly hidden/>
        <input type="text" id="statusid_modal" name="statusid_modal" readonly hidden/>-->

                    <div class="form-group gut">
                        <div class="col-sm-1">
                            <input type="checkbox" id="check_biayarajal" name="check_biayarajal" value="1" checked>
                        </div>
                        <div class="col-sm-10">
                            <label for="check_biayarajal"><i class="fa fa-diagnoses"></i> Biaya Rawat Jalan</label>
                        </div>
                    </div>

                    <div class="form-group gut">
                        <div class="col-sm-1">
                            <input type="checkbox" id="check_biayaoperasi" name="check_biayaoperasi" value="1" checked>
                        </div>
                        <div class="col-sm-10">
                            <label for="check_biayaoperasi"><i class="fa fa-diagnoses"></i> Biaya Paket Operasi</label>
                        </div>
                    </div>

                    <div class="form-group gut">
                        <div class="col-sm-1">
                            <input type="checkbox" id="check_biayakamar" name="check_biayakamar" value="1" checked>
                        </div>
                        <div class="col-sm-10">
                            <label for="check_biayakamar"><i class="fa fa-diagnoses"></i> Biaya Pemakaian Kamar</label>
                        </div>
                    </div>

                    <div class="form-group gut">
                        <div class="col-sm-1">
                            <input type="checkbox" id="check_biayatindakanop" name="check_biayatindakanop" value="1"
                                checked>
                        </div>
                        <div class="col-sm-10">
                            <label for="check_biayatindakanop"><i class="fa fa-diagnoses"></i> Biaya Tindakan
                                Operasi</label>
                        </div>
                    </div>

                    <div class="form-group gut">
                        <div class="col-sm-1">
                            <input type="checkbox" id="check_biayavisitetindakan" name="check_biayavisitetindakan"
                                value="1" checked>
                        </div>
                        <div class="col-sm-10">
                            <label for="check_biayavisitetindakan"><i class="fa fa-diagnoses"></i> Biaya Visite Dan
                                Tindakan</label>
                        </div>
                    </div>

                    <div class="form-group gut">
                        <div class="col-sm-1">
                            <input type="checkbox" id="check_biayalab" name="check_biayalab" value="1" checked>
                        </div>
                        <div class="col-sm-10">
                            <label for="check_biayalab"><i class="fa fa-vial"></i> Biaya Lab</label>
                        </div>
                    </div>

                    <div class="form-group gut">
                        <div class="col-sm-1">
                            <input type="checkbox" id="check_biayaradiologi" name="check_biayaradiologi" value="1"
                                checked>
                        </div>
                        <div class="col-sm-10">
                            <label for="check_biayaradiologi"><i class="fa fa-x-ray"></i> Biaya Radiologi</label>
                        </div>
                    </div>

                    <div class="form-group gut">
                        <div class="col-sm-1">
                            <input type="checkbox" id="check_biayafarmasi" name="check_biayafarmasi" value="1" checked>
                        </div>
                        <div class="col-sm-10">
                            <label for="check_biayafarmasi"><i class="fa fa-pills"></i> Biaya Farmasi</label>
                        </div>
                    </div>

                </div>
            </form>
            <br><br><br><br><br><br><br><br>
            <div class="modal-footer">
                <button style="background-color:#5e2e94" type="button" class="btn" id="btn_rincian_biaya">
                    <font color="white"><span class="glyphicon glyphicon-print"></span> Cetak</font>
                </button>
                <button style="background-color:teal" type="button" class="btn" id="btn_rincian_biaya_eng">
                    <font color="white"><span class="glyphicon glyphicon-print"></span> English</font>
                </button>
                <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe" name="CloseMe">Close</a>
            </div>
        </div>
    </div>
</div>
<!--#END Modal Rincian Biaya--------------------------------------------->