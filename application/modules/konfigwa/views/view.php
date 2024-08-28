  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Konfigurasi</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Konfigurasi</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->




    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Pengaturan Aplikasi</h3>
        </div>

        <!-- /.card-header -->
        <div class="card-body">
          <div class="row">
          <div class="col-md-7">

          <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">


                        <div class="form-group row">
                            <label class="control-label col-md-3">ID Device</label>
                            <div class="col-md-5">
                                <input name="id_device" placeholder="" class="form-control" type="text" value="<?=$konfig['id_device'];?>">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">No. Telp</label>
                            <div class="col-md-3">
                                <input name="no_telp" placeholder="" class="form-control" type="text" value="<?=$konfig['no_telp'];?>">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Jam Kirim Ultah</label>
                            <div class="col-md-3">
                                <input name="jam_ultah"  class="form-control" type="time" value="<?=$konfig['jam_ultah'];?>">
                                <span class="help-block"></span>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="control-label col-md-3">Acak Waktu</label>
                            <div class="col-md-3">
                                <input name="acak" placeholder="" class="form-control" type="text" value="<?=$konfig['acak'];?>">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        
                        <div class="form-group row">
                            <label class="control-label col-md-3"></label>
                            <div class="col-md-3">
                                <button type="button" id="btnSave" onclick="update()" class="btn btn-primary">Simpan</button>
                            </div>
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


<script type="text/javascript">

  var save_method; //for save method string
  var table;
  var url = "<?php echo site_url(); ?>";


   function update(){

           url = "<?php echo site_url('konfigwa/ajax_update')?>";

    
       // ajax adding data to database
       var formData = new FormData($('#form')[0]);
       $.ajax({
            url : url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
           success: function(data)
           {
    
               if(data.status) //if success close modal and reload ajax table
               {
                   Lobibox.notify('success', {
                       size: 'mini',
                       msg: 'Data berhasil Disimpan'
                   });
                //    location.reload(); 
               }
               else
               {
                   for (var i = 0; i < data.inputerror.length; i++) 
                   {
                       $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                       $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                   }
               }
               $('#btnSave').text('Simpan'); //change button text
               $('#btnSave').attr('disabled',false); //set button enable 
    
    
           },
           error: function (jqXHR, textStatus, errorThrown)
           {
               alert('Error adding / update data');
               $('#btnSave').text('Simpan'); //change button text
               $('#btnSave').attr('disabled',false); //set button enable 
    
           }
       });
   }


</script>


