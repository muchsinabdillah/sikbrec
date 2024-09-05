 <!-- Styles -->
 <style>
    #chartdiv {
       margin-left: -70px;
       width: 100%;
       height: 500px;
    }

    #chartdiv2 {
       margin-left: 20px;
       width: 100%;
       height: 500px;
    }

    #chartdivProgDI {
       margin-left: -70px;
       width: 100%;
       height: 500px;
    }

    #chartdivProgIN {
       margin-left: 20px;
       width: 100%;
       height: 500px;
    }

    #chartdivmhDI {
       margin-left: -70px;
       width: 100%;
       height: 500px;
    }

    #chartdivmhIN {
       margin-left: 20px;
       width: 100%;
       height: 500px;
    }
 </style>
 <div class="main-page">
    <section class="section pt-12">
       <div class="container-fluid">
          <div class="row">
             <div class="col-md-12">
                <div class="panel border-primary no-border border-3-top" data-panel-control>
                   <div class="panel-heading">
                      <div class="panel-title">
                         <h5>DASHBOARD <small>( Daily, Weekly, Monthly )</small></h5>
                      </div>
                   </div>
                   <div class="panel-body">
                      <form class="form-horizontal" id="frm_dashboard1">

                      <!--
                         <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Kode JO</label>
                            <div class="col-sm-4">
                               <select id='Info_KodeJo1' name='Info_KodeJo1' class="form-control js-example-basic-single" onchange="getMoubyIDJO();">
                               </select>
                            </div>
                            <label for="inputEmail3" class="col-sm-2 control-label">Nama Client</label>
                            <div class="col-sm-4">
                               <input type="text" readonly class="form-control" name="Info_NamaProject" id="Info_NamaProject">
                               <input type="hidden" class="form-control" name="START_WEEK" id="START_WEEK">
                            </div>
                         </div>
                        -->
                         <div class="form-group gut">
                            <label for="inputEmail3" class="col-sm-2 control-label">Periode</label>
                            <div class="col-sm-2">
                               <input type="date" class="form-control" id="Info_Date_Start" name="Info_Date_Start">
                            </div>
                            <div class="col-sm-2">
                               <input type="date" class="form-control" id="Info_Date_End" name="Info_Date_End">
                            </div>
                         </div>
                      </form>
                      <div class="form-group gut">
                         <label for="inputEmail3" class="col-sm-2 control-label"></label>
                         <div class="col-sm-4">
                            <button class="btn bg-success btn-wide" id="btnRefresh" name="btnRefresh" onclick="goshowGrafik();"><i class="fa fa-check"></i>REFRESH</button>
                         </div>
                      </div>


                      <!-- /.src-code -->
                   </div>
                </div>
                <!-- /.panel -->
             </div>

          </div>
          <!-- /.row -->
       </div>
       <!-- /.container-fluid -->
    </section>
    <!-- .container-fluid COST -->
    <section class="section pt-12" style="margin-top: -80px;">
       <div class="container-fluid">
          <div class="row">
             <div class="col-md-12">
                <div class="panel border-primary no-border border-3-top" data-panel-control>
                   <div class="panel-heading">
                      <div class="panel-title">
                         <h5>COST<small>over years</small></h5>
                      </div>
                   </div>
                   <div class="panel-body">
                      <div class="form-group">
                         <label for="inputEmail3" class="col-sm-2 control-label">Direct</label>
                         <div class="col-lg-10" style="margin-left: -80px;margin-top: 40px;">
                            <div id="chartdiv"></div>
                         </div>
                         
                      </div>
                      <div class="form-group">
                         <div class="col-lg-6">
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
                         <div class="col-lg-6">

                            <div class="table-responsive" width="100%" style="margin-top: 50px;">
                               <table id="tbl_grafik_cost_indirect" class="display">
                                  <thead>
                                     <tr>
                                        <th align='center' rowspan="2">
                                           <font size="1">Keterangan
                                        </th>
                                        <th align='center'>
                                           <font size="1">
                                              <div id="CI_PrevMonth"></div>
                                        </th>
                                        <th align='center'>
                                           <font size="1">
                                              <div id="CI_currentMonth"></div>
                                        </th>
                                        <th align='center'>
                                           <font size="1">
                                              <div id="CI_NextMonth"></div>
                                        </th>
                                     </tr>
                                     <tr>

                                        <th align='center'>
                                           <font size="1">
                                              <div id="CI_CurrentPeriode1"></div>
                                        </th>
                                        <th align='center'>
                                           <font size="1">
                                              <div id="CI_CurrentPeriode2"></div>
                                        </th>
                                        <th align='center'>
                                           <font size="1">
                                              <div id="CI_CurrentPeriode3"></div>
                                        </th>
                                     </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                               </table>
                            </div>
                         </div>
                      </div>
                      <!-- /.src-code -->
                   </div>
                </div>
                <!-- /.panel -->
             </div>


          </div>
          <!-- /.row -->
       </div>
       <!-- /.container-fluid -->
    </section>
    <!-- /.container-fluid COST -->

    <!-- .container-fluid PROG -->
    <section class="section pt-12" style="margin-top: -80px;">
       <div class="container-fluid">
          <div class="row">
             <div class="col-md-12">
                <div class="panel border-primary no-border border-3-top" data-panel-control>
                   <div class="panel-heading">
                      <div class="panel-title">
                         <h5>PROGRESS<small>over years</small></h5>
                      </div>
                   </div>
                   <div class="panel-body">
                      <div class="form-group">
                         <label for="inputEmail3" class="col-sm-2 control-label">Direct</label>
                         <div class="col-lg-5" style="margin-left: -80px;margin-top: 40px;">
                            <div id="chartdivProgDI"></div>
                         </div>
                         <label for="inputEmail3" class="col-sm-2 control-label">Indirect</label>
                         <div class="col-lg-5">
                            <div id="chartdivProgIN"></div>
                         </div>
                      </div>
                      <div class="form-group">
                         <div class="col-lg-6">
                            <div class="table-responsive" width="100%" style="margin-top: 50px;">
                               <table id="tbl_grafik_prog_direct" class="display">
                                  <thead>
                                     <tr>
                                        <th align='center' rowspan="2">
                                           <font size="1">Keterangan
                                        </th>
                                        <th align='center'>
                                           <font size="1">
                                              <div id="PD_PrevMonth"></div>
                                        </th>
                                        <th align='center'>
                                           <font size="1">
                                              <div id="PD_currentMonth"></div>
                                        </th>
                                        <th align='center'>
                                           <font size="1">
                                              <div id="PD_NextMonth"></div>
                                        </th>
                                     </tr>
                                     <tr>

                                        <th align='center'>
                                           <font size="1">
                                              <div id="PD_CurrentPeriode1"></div>
                                        </th>
                                        <th align='center'>
                                           <font size="1">
                                              <div id="PD_CurrentPeriode2"></div>
                                        </th>
                                        <th align='center'>
                                           <font size="1">
                                              <div id="PD_CurrentPeriode3"></div>
                                        </th>
                                     </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                               </table>
                            </div>
                         </div>
                         <div class="col-lg-6">
                            <div class="table-responsive" width="100%" style="margin-top: 50px;">
                               <table id="tbl_grafik_prog_indirect" class="display">
                                  <thead>
                                     <tr>
                                        <th align='center' rowspan="2">
                                           <font size="1">Keterangan
                                        </th>
                                        <th align='center'>
                                           <font size="1">
                                              <div id="PI_PrevMonth"></div>
                                        </th>
                                        <th align='center'>
                                           <font size="1">
                                              <div id="PI_currentMonth"></div>
                                        </th>
                                        <th align='center'>
                                           <font size="1">
                                              <div id="PI_NextMonth"></div>
                                        </th>
                                     </tr>
                                     <tr>

                                        <th align='center'>
                                           <font size="1">
                                              <div id="PI_CurrentPeriode1"></div>
                                        </th>
                                        <th align='center'>
                                           <font size="1">
                                              <div id="PI_CurrentPeriode2"></div>
                                        </th>
                                        <th align='center'>
                                           <font size="1">
                                              <div id="PI_CurrentPeriode3"></div>
                                        </th>
                                     </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                               </table>
                            </div>
                         </div>
                      </div>
                      <!-- /.src-code -->
                   </div>
                </div>
                <!-- /.panel -->
             </div>


          </div>
          <!-- /.row -->
       </div>
       <!-- /.container-fluid -->
    </section>
    <!-- /.container-fluid prog -->

    <!-- .container-fluid MH -->
    <section class="section pt-12" style="margin-top: -80px;">
       <div class="container-fluid">
          <div class="row">
             <div class="col-md-12">
                <div class="panel border-primary no-border border-3-top" data-panel-control>
                   <div class="panel-heading">
                      <div class="panel-title">
                         <h5>MAN HOURS<small>over years</small></h5>
                      </div>
                   </div>
                   <div class="panel-body">
                      <div class="form-group">
                         <label for="inputEmail3" class="col-sm-2 control-label">Direct</label>
                         <div class="col-lg-5" style="margin-left: -80px;margin-top: 40px;">
                            <div id="chartdivmhDI"></div>
                         </div>
                         <label for="inputEmail3" class="col-sm-2 control-label">Indirect</label>
                         <div class="col-lg-5">
                            <div id="chartdivmhIN"></div>
                         </div>
                      </div>
                      <div class="form-group">
                         <div class="col-lg-6">
                            <div class="table-responsive" width="100%" style="margin-top: 50px;">
                               <table id="tbl_grafik_mh_direct" class="display">
                                  <thead>
                                     <tr>
                                        <th align='center' rowspan="2">
                                           <font size="1">Keterangan
                                        </th>
                                        <th align='center'>
                                           <font size="1">
                                              <div id="MI_PrevMonth"></div>
                                        </th>
                                        <th align='center'>
                                           <font size="1">
                                              <div id="MI_currentMonth"></div>
                                        </th>
                                        <th align='center'>
                                           <font size="1">
                                              <div id="MI_NextMonth"></div>
                                        </th>
                                     </tr>

                                     <tr>

                                        <th align='center'>
                                           <font size="1">
                                              <div id="MI_CurrentPeriode1"></div>
                                        </th>
                                        <th align='center'>
                                           <font size="1">
                                              <div id="MI_CurrentPeriode2"></div>
                                        </th>
                                        <th align='center'>
                                           <font size="1">
                                              <div id="MI_CurrentPeriode3"></div>
                                        </th>
                                     </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                               </table>
                            </div>
                         </div>
                         <div class="col-lg-6">
                            <div class="table-responsive" width="100%" style="margin-top: 50px;">
                               <table id="tbl_grafik_mh_indirect" class="display">
                                  <thead>
                                     <tr>
                                        <th align='center' rowspan="2">
                                           <font size="1">Keterangan
                                        </th>
                                        <th align='center'>
                                           <font size="1">
                                              <div id="MD_PrevMonth"></div>
                                        </th>
                                        <th align='center'>
                                           <font size="1">
                                              <div id="MD_currentMonth"></div>
                                        </th>
                                        <th align='center'>
                                           <font size="1">
                                              <div id="MD_NextMonth"></div>
                                        </th>
                                     </tr>

                                     <tr>

                                        <th align='center'>
                                           <font size="1">
                                              <div id="MD_CurrentPeriode1"></div>
                                        </th>
                                        <th align='center'>
                                           <font size="1">
                                              <div id="MD_CurrentPeriode2"></div>
                                        </th>
                                        <th align='center'>
                                           <font size="1">
                                              <div id="MD_CurrentPeriode3"></div>
                                        </th>
                                     </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                               </table>
                            </div>
                         </div>
                      </div>
                      <!-- /.src-code -->
                   </div>
                </div>
                <!-- /.panel -->
             </div>


          </div>
          <!-- /.row -->
       </div>
       <!-- /.container-fluid -->
    </section>
    <!-- /.container-fluid MH -->
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
 <!-- Resources -->
 <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
 <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
 <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
 <script src="<?= BASEURL; ?>/js/App/Informasi/grafik/InfoGrafik_BPJS.js"></script>