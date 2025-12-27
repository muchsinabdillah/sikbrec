

<style>
#chartdivjeniskelamin {
  width: 100%;
  height: 500px;
}
#chartdivUsia {
  width: 100%;
  height: 500px;
}
</style>
<div class="main-page"> 
    <!-- /.container-fluid -->
    <section class="section pt-12">
       <div class="container-fluid">
          <div class="row">
              
             <div class="col-md-12">
                <div class="panel border-primary no-border border-3-top"   >
                   <div class="panel-heading">
                      <div class="panel-title">
                         <h5>Kunjungan Pasien Baru/Lama ( Tahunan )</h5>
                      </div>
                   </div>
                   <div class="panel-body p-20">
                        <!-- <input class="form-control containerX" id="nama_Barang" name="nama_Barang" type="text" placeholder="Ketik Nama Menu disini (min. 3 karakter)"> -->
                        <form class="form-horizontal" id="frm_dashboard1"> 
                         <div class="form-group gut">
                            <label for="inputEmail3" class="col-sm-2 control-label">Periode</label>
                            <div class="col-sm-2">
                                 <select name="Info_Date_Start" class="form-control" id="Info_Date_Start">
                                    <option value="">-- PILIH --</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                    <option value="2028">2028</option>
                                    <option value="2029">2029</option>
                                    <option value="2030">2030</option>
                                </select>
                            </div>
                             
                         </div> 
                         
                      </form>
                      <div class="form-group">
                         <label for="inputEmail3" class="col-sm-2 control-label"></label>
                         <div class="col-sm-4">
                            <button class="btn bg-success btn-wide" id="btnRefresh" name="btnRefresh" onclick="goshowGrafik();"><i class="fa fa-check"></i>LOAD GRAFIK</button>
                         </div>
                      </div>
                        
                     </div>
                </div>
                <!-- /.panel -->
             </div>
             <!-- /.col-md-4 -->
          </div>
          <!-- /.row -->
       </div>
       <!-- /.container-fluid -->
    </section>
    <!-- /.section -->
                        <section class="section pt-10">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel border-primary no-border border-3-top data-panel-control">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5>Grafik Data Rekap Pasien Baru/Lama</h5>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                    <div id="chartdivjeniskelamin" style="min-width: 310px; height: 200px; margin: 0 auto"></div>
                                                    <div class="table-responsive" style="margin-top: 50px;">
                                                        <table id="tbl_grafik_cost_direct" width="100%" class="display">
                                                            <thead>
                                                                <tr>
                                                                    <th align='center' rowspan="2">
                                                                    <font size="1">Keterangan
                                                                    </th>
                                                                    <th align='center'>
                                                                    <font size="1">
                                                                        <div id="CD_PrevMonth"></div>
                                                                    </th>
                                                                    <th align='center'>
                                                                    <font size="1">
                                                                        <div id="CD_currentMonth"></div>
                                                                    </th>
                                                                    <th align='center'>
                                                                    <font size="1">
                                                                        <div id="CD_NextMonth"></div>
                                                                    </th>
                                                                </tr>
                                                                <tr>

                                                                    <th align='center'>
                                                                    <font size="1">
                                                                        <div id="CD_PrevPeriode1"></div>
                                                                    </th>
                                                                    <th align='center'>
                                                                    <font size="1">
                                                                        <div id="CD_PrevPeriode2"></div>
                                                                    </th>
                                                                    <th align='center'>
                                                                    <font size="1">
                                                                        <div id="CD_PrevPeriode3"></div>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div> 
                                            </div>
                                        </div>
                                        <!-- /.panel -->
                                    </div>
                                    <!-- /.col-md-6 -->  
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.container-fluid -->
                        </section>
                        <!-- /.section -->
                        <section class="section pt-10">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel border-primary no-border border-3-top data-panel-control">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5>Grafik Data Bulanan Pasien Baru/Lama</h5>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                    <div id="chartdivUsia" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                                                    <div class="table-responsive" style="margin-top: 50px;">
                                                        <table id="tbl_grafik_Usa" width="100%" class="display">
                                                            <thead>
                                                                <tr>
                                                                    <th align='center' rowspan="2">
                                                                    <font size="1">Keterangan
                                                                    </th>
                                                                    <th align='center'>
                                                                    <font size="1">
                                                                        <div id="CD_PrevMonth"></div>
                                                                    </th>
                                                                    <th align='center'>
                                                                    <font size="1">
                                                                        <div id="CD_currentMonth"></div>
                                                                    </th>
                                                                    <th align='center'>
                                                                    <font size="1">
                                                                        <div id="CD_NextMonth"></div>
                                                                    </th>
                                                                </tr>
                                                                <tr>

                                                                    <th align='center'>
                                                                    <font size="1">
                                                                        <div id="CD_PrevPeriode1"></div>
                                                                    </th>
                                                                    <th align='center'>
                                                                    <font size="1">
                                                                        <div id="CD_PrevPeriode2"></div>
                                                                    </th>
                                                                    <th align='center'>
                                                                    <font size="1">
                                                                        <div id="CD_PrevPeriode3"></div>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div> 
                                            </div>
                                        </div>
                                        <!-- /.panel -->
                                    </div>
                                    <!-- /.col-md-6 -->  
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.container-fluid -->
                        </section>
                       
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
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
             </div>
             <!-- /.col-md-12 -->

             <div class="text-center mt-20">
                <button type="button" class="btn btn-success btn-labeled">Purchase Now<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
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
 <!-- /.main-wrapper -->
 <script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
 <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
 <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
 <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
 <script src="//cdn.amcharts.com/lib/4/themes/kelly.js"></script>
 <script src="<?= BASEURL; ?>/js/App/grafik/kunjungan/yearly.js?v=<?php echo time(); ?>"></script> 