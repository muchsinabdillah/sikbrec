<div class="main-page">
     <section class="section">
         <div class="container-fluid">
             <div class="row">
                 <div class="col-md-12">
                     <div class="panel">
                         <div class="panel-heading">
                             <div class="panel-title">
                                 <h5>Input Hasil Laboratorium</h5>
                             </div>
                         </div>
                         <div class="panel-body">
                             <form class="form-horizontal" id="form_lab">
                                 <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Masukan No. Barcode :</label>
                                    <button type="button" class="btn btn-maroon btn-sm btn-rounded " id="btnSearching" name="btnSearching">
                                        <span class="glyphicon glyphicon glyphicon-search"></span> Search</button>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="nolab" id="nolab" placeholder="Masukkan No. Barcode">
                                    </div>
                                 </div> 
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label">Nama Pasien<sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" name="NamaPasien" id="NamaPasien" readonly>
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Jenis Kelamin <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" name="jeniskelamin" id="jeniskelamin" readonly>
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label">Tgl Lahir <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" name="tgllahir" id="tgllahir" readonly>
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Alamat <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" name="alamat" id="alamat" readonly>
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label">Jaminan <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" name="jaminanname" id="jaminanname" readonly>
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Unit <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" name="unitname" id="unitname" readonly>
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label">Tgl/Jam Sample Diterima <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-2">
                                         <input type="date" class="form-control" name="tglsamplediterima" id="tglsamplediterima" >
                                     </div>
                                      <div class="col-sm-2">
                                         <input type="time" class="form-control" name="jamsamplediterima" id="jamsamplediterima" >
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Nolab <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" name="notrs" id="notrs" readonly>
                                     </div>
                                 </div>
                             </form>
                             <div class="demo-table" style="overflow-x:auto;margin-top: 10px;">
                                <table id="example" class="display" width="100%"
                                    class="table table-striped table-hover cell-border">
                                    <thead>
                                        <tr>
                                            <th align='center'>
                                                <font size="1">NO
                                            </th>
                                            <th align='center'>
                                                <font size="1">Kode Test
                                            </th>
                                            <th align='center'>
                                                <font size="1">Nama Test
                                            </th>
                                            <th align='center'>
                                                <font size="1">Nilai
                                            </th>
                                            <th align='center'>
                                                <font size="1">Nilai Rujukan
                                            </th>
                                            <th align='center'>
                                                <font size="1">Satuan
                                            </th>
                                            <th align='center'>
                                                <font size="1">Flag Normal
                                            </th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <br><br>
                             <button id="btnCancel" name="btnCancel" onclick="MyBack()" class="btn bg-gray btn-wide"><i class="fa fa-times"></i>Cancel</button>
                             <button class="btn bg-black btn-wide" id="btnKirim" name="btnKirim"><i class="fa fa-check"></i>Submit</button>
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
 <div class="modal fade " id="modal_edit_sep" tabindex="-1" role="dialog">
      <div class="modal-dialog  modal-md">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header"> 
                  <h4 class="modal-title"> Update Data </h4>
              </div>
              <div class="modal-body">
                  <form id="frmUpdateSEP">
                      <div class="row" style="margin-bottom:3px;">
                          <label for="namapasien" class="col-sm-4 col-form-label">ID :</label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" type="text" id="IDx" name="IDx" maxlength="19" readonly>
                          </div>
                      </div>  
                      <div class="row" style="margin-bottom:3px;">
                          <label for="namapasien" class="col-sm-4 col-form-label">Kode Test :</label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" type="text" id="TESTCODE" name="TESTCODE"readonly>
                          </div>
                      </div>
                      <div class="row" style="margin-bottom:3px;">
                          <label for="namapasien" class="col-sm-4 col-form-label">Nama Test :</label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" type="text" id="TESTNAME" name="TESTNAME"readonly>
                          </div>
                      </div>
                      <div class="row" style="margin-bottom:3px;">
                          <label for="namapasien" class="col-sm-4 col-form-label">Hasil Test :</label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" type="text" id="HASIL" name="HASIL"readonly>
                          </div>
                      </div>
                      <div class="row" style="margin-bottom:3px;">
                          <label for="namapasien" class="col-sm-4 col-form-label">Nilai Rujukan :</label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" type="text" id="NILAIRUJUKAN" name="NILAIRUJUKAN" >
                          </div>
                      </div>
                      <div class="row" style="margin-bottom:3px;">
                          <label for="namapasien" class="col-sm-4 col-form-label">Satuan :</label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" type="text" id="SATUAN" name="SATUAN"readonly>
                          </div>
                      </div>
                      <div class="row" style="margin-bottom:3px;">
                          <label for="namapasien" class="col-sm-4 col-form-label">Nilai FLAG :</label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" type="text" id="FLAG" name="FLAG"readonly>
                          </div>
                      </div>
                  </form>
              </div>
              <div class="modal-footer">
                  <button data-toggle='modal' class="btn btn-danger btn-sm" type="button" id="btnUpdateSEP" name="btnUpdateSEP">
                      UPDATE DATA
                  </button>
              </div>
          </div>
      </div>
  </div> 
 
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
 <!-- ========== COMMON JS FILES ========== -->
 <script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
 <script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
 <script src="<?= BASEURL; ?>/js/App/glukosa/glukosa.js"></script>
 <script src="<?= BASEURL; ?>/js/App/MasterData/MasterLoginUser/A_Hak_Akses_V02.js"></script>