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
            <h3 class="m-0 text-dark">Laporan Pembayaran Customer</h3>
            <hr>
          <form action="<?=base_url('laporan/tampil_customer');?>" target="_blank" id="form" class="form-horizontal" method="POST">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">

                        <div class="form-group row">
                            <label class="control-label col-md-2">Nama Customer</label>
                            <div class="col-md-3">
                                <select name="customer" id="customer" class="form-control">
                                <option value="">-- Pilih --</option>
                                  <?php 
                                  $cust = $this->db->query("SELECT * FROM kategori WHERE id_customer <> '0'")->result(); 
                                  foreach($cust as $ct){ 
                                      echo '<option value="'.$ct->id_customer.'">'.$ct->kategori.'</option>';
                                   } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-2">Kode Kavling</label>
                            <div class="col-md-3">
                                <select name="kode_kavling" id="kavling" class="form-control">
                                  <option value="">-- Pilih --</option>
                                </select>
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

<script>
   $("#customer").change(function(){
     var url = "<?=base_url();?>"; 
      //  var id_provinces = $(this).val(); 
       var id_cust = $('#customer').val(); // en

       $.ajax({
          type: "POST",
          dataType: "html",
          url: url + "laporan/cari_kavling/" + id_cust,
          // data: "isinya="+id_provinces,
          success: function(msg){
             $("select#kavling").html(msg);                                                       
            //  $("img#load1").hide();
            //  getAjaxKota();                                                        
          }
       });                    
     }); 
</script>