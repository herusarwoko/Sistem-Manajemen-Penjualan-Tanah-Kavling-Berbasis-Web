<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    
    <!-- /.content-header -->


    <!-- Main content -->
    <section class="content">

    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
         
        <br> 
        <hr>
        <br>
        </div>

      <div class="card">

        <!-- /.card-header -->
        <div class="card-body">
            <h3 class="m-0 text-dark">Laporan Berdasarkan Kategori</h3>
            <hr>
          <form action="<?=base_url('laporan/tampil_kategori');?>" target="_blank" id="form" class="form-horizontal" method="POST">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">

                        <div class="form-group row">
                            <label class="control-label col-md-2">Kategori</label>
                            <div class="col-md-3">
                                <select name="kategori" id="kategori" class="form-control">
                                <option value="">-- Pilih --</option>
                                  <?php 
                                  $cust = $this->db->query("SELECT * FROM kategori WHERE id_customer = '0'")->result(); 
                                  foreach($cust as $ct){ 
                                      echo '<option value="'.$ct->kategori_id.'">'.$ct->kategori.'</option>';
                                   } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-2">Periode Awal</label>
                            <div class="col-md-3">
                                <input name="awal" placeholder="" class="form-control" type="date">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-2">Periode Akhir</label>
                            <div class="col-md-3">
                                <input name="akhir" placeholder="" class="form-control" type="date">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-2"></label>
                            <div class="col-md-4">
                                <button class="btn btn-primary btn-md" type="submit" name="submit"> Proses</button>
                            </div>
                        </div>


                       

                    </div>
                </form>

          </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
</div>
</body>
</html>

<?php  $this->load->view('template/footer'); ?>