 <div class="main-page">
     <div class="container-fluid">
         <div class="row page-title-div">
             <div class="col-md-6">
                 <h2 class="title"><?= $data['judul'] ?></h2>
                 <p class="sub-title">Menampilkan Data List Master <?= $data['judul'] ?>.</p>
             </div>
             <!-- /.col-md-6 -->
         </div>
         <!-- /.row -->
         <div class="row breadcrumb-div">
             <div class="col-sm-6">
                 <ul class="breadcrumb">
                     <li><a href="<?= BASEURL; ?>"><i class="fa fa-home"></i> Home</a></li>
                     <li class="active"><?= $data['judul'] ?></li>
                     <li class="active"><?= $data['judul_child'] ?></li>
                 </ul>
             </div>
         </div>
         <!-- /.row -->
     </div>
     <!-- /.container-fluid -->

     <section class="section">
         <div class="container-fluid">

             <div class="row">
                 <div class="col-md-12">
                     <div class="panel">
                         <div class="panel-heading">
                             <div class="panel-title">
                                 <h5 class="underline mt-30">Load Master <?= $data['judul'] ?> <button type="button"
                                         class="btn btn-primary btn-animated btn-wide"
                                         onclick="goGroupShiftPages();"><span class="visible-content">New
                                             Data</span><span class="hidden-content"><i
                                                 class="fa fa-send-o"></i></span></button></h5>
                             </div>
                         </div>
                         <div class="panel-body p-20">
                             <form class="form-horizontal" id="frmDataPasien">
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Pilih Lantai : </label>
                                     <div class="col-sm-4">
                                         <select class="form-control" id="LantaiID" name="LantaiID"
                                             onchange="loadtabeldatabylantai();">
                                             <option value="">-- PILIH --</option>
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
                                             <option value="13">Lantai 13</option>
                                             <option value="14">Lantai 14</option>
                                             <option value="15">Lantai 15</option>
                                             <option value="16">Lantai 16</option>
                                         </select>
                                     </div>
                                 </div>
                                 <hr>
                             </form>
                             <div class="panel-body p-20">
                                 <div class="demo-table" style="overflow-x:auto;">
                                     <table id="example" class="display" width="100%">
                                         <thead>
                                             <tr>
                                                 <th align='center'>
                                                     <font size="1">Room ID
                                                 </th>
                                                 <th align='center'>
                                                     <font size="1">Kelas
                                                 </th>
                                                 <th align='center'>
                                                     <font size="1">Lantai
                                                 </th>
                                                 <th align='center'>
                                                     <font size="1">Room
                                                 </th>
                                                 <th align='center'>
                                                     <font size="1">Bed
                                                 </th>
                                                 <th align='center'>
                                                     <font size="1">Tarif
                                                 </th>
                                                 <th align='center'>
                                                     <font size="1">BOR
                                                 </th>
                                                 <th align='center'>
                                                     <font size="1">Status Terpakai
                                                 </th>
                                                 <th align='center'>
                                                     <font size="1">Discontinue
                                                 </th>
                                                 <th align='center'>
                                                     <font size="1">Keterangan
                                                 </th>
                                                 <th align='center'>
                                                     <font size="1">Publish BPJS
                                                 </th>
                                                 <th align='center'>
                                                     <font size="1">Action
                                                 </th>
                                             </tr>
                                         </thead>
                                         <tbody>
                                         </tbody>
                                     </table>
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

 </div>
 <!-- /.content-container -->
 </div>
 <!-- /.content-wrapper -->
 </div>
 <!-- /.main-wrapper -->
 <!-- ========== COMMON JS FILES ========== -->
 <script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
 <script src="<?= BASEURL; ?>/js/App/MasterData/MasterDataBed/MasterDataBed_Table_V04.js"></script>
 <script src="<?= BASEURL; ?>/js/App/MasterData/MasterLoginUser/A_Hak_Akses_V02.js"></script>