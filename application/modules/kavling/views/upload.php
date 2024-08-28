  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Data Kavling</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Kavling</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->




    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-body">
        <form action="<?=base_url('kavling/proses_polygon');?>" id="form" class="form-horizontal"  method="post">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">

    
                        <div class="form-group row">
                            <label class="control-label col-md-2">Upload Kode SVG</label>
                            <div class="col-md-9">
                                <textarea name="peta" class="form-control" rows="12"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-2"></label>
                            <div class="col-md-2">
                            <button type="submit" id="btnSave" class="btn btn-primary">Upload Kode SVG</button>
                            </div>
                        </div>


                        

                        
                    </div>
                </form>
           

          </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
</div>


<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">header</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">

                    <div class="form-body">

    
                        <div class="form-group row">
                            <label class="control-label col-md-3">Kode Kavling</label>
                            <div class="col-md-2">
                                <input name="kode_kavling" placeholder="" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                       

                        <div class="form-group row">
                            <label class="control-label col-md-3">Kode Map</label>
                            <div class="col-md-9">
                                <input name="map" placeholder="" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
</body>
</html>

<?php  $this->load->view('template/footer'); ?>