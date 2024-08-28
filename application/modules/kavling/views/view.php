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
        <div class="card-header">
          <h3 class="card-title">Data Kavling</h3>
          <div class="card-tools">
                <a href="<?= base_url('kavling/upload');?>" class="btn btn-info btn-sm""><i class="fa fa-plus"></i> Upload SVG</a></div>
             <!-- /.card-tools -->
        </div>

        <!-- /.card-header -->
        <div class="card-body">

           <table id="table" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="10%">Lokasi</th>
                        <th width="15%">panjang</th>
                        <th width="15%">lebar</th>
                        <th width="10%">Luas</th>
                        <th width="10%">Harga </th>
                        <th width="10%">Status</th>
                        <th width="15%">Keterangan</th>
                        <th width="10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

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
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">

    
                        <div class="form-group row">
                            <label class="control-label col-md-3">Kode Kavling</label>
                            <div class="col-md-2">
                                <input name="kode_kavling" placeholder="" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Panjang Kanan</label>
                            <div class="col-md-2">
                                <input name="panjang_kanan" placeholder="" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                            <label class="control-label col-md-2">Panjang Kiri</label>
                            <div class="col-md-2">
                                <input name="panjang_kiri" placeholder="" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Lebar Depan</label>
                            <div class="col-md-2">
                                <input name="lebar_depan" placeholder="" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>

                            <label class="control-label col-md-2">Lebar Belakang</label>
                            <div class="col-md-2">
                                <input name="lebar_belakang" placeholder="" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Luas Tanah</label>
                            <div class="col-md-2">
                                <input name="luas_tanah" placeholder="" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Harga Per Meter</label>
                            <div class="col-md-2">
                                <input name="harga_per_meter" placeholder="" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="control-label col-md-3">Harga Jual Cash</label>
                            <div class="col-md-2">
                                <input name="harga_jual" placeholder="" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="control-label col-md-3">Jenis Map</label>
                            <div class="col-md-2">
                                <input name="jenis_map" placeholder="" class="form-control" type="text" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="control-label col-md-3">Status</label>
                            <div class="col-md-2">
                              <select class="form-control" name="status" disabled>
                                <option value="0">Kosong</option>
                                <option value="1">Booking</option>
                                <option value="2">Cash</option>
                                <option value="3">Kredit</option>
                              </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Kode Map</label>
                            <div class="col-md-6">
                                <textarea name="map" class="form-control" cols="10" rows="4" disabled></textarea>
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


<script type="text/javascript">

  var save_method; //for save method string
  var table;
  var url = "<?php echo site_url(); ?>";

  $(document).ready(function() {

      //datatables
      table = $('#table').DataTable({

          "paging": false,

          "processing": true, //Feature control the processing indicator.
          "serverSide": true, //Feature control DataTables' server-side processing mode.
          "order": [], //Initial no order.

          // Load data for the table's content from an Ajax source
          "ajax": {
              "url": url + "<?php echo $data_ref['uri_controllers']; ?>/ajax_list",
              "type": "POST"
          },

          //Set column definition initialisation properties.
          "columnDefs": [
          {
              "targets": [ -1 ], //last column
              "orderable": false, //set not orderable
          },
          ],

      });


      //set input/textarea/select event when change value, remove class error and remove text help block
      $("input").change(function(){
          $(this).parent().parent().removeClass('has-error');
          $(this).next().empty();
      });
      $("textarea").change(function(){
          $(this).parent().parent().removeClass('has-error');
          $(this).next().empty();
      });
      $("select").change(function(){
          $(this).parent().parent().removeClass('has-error');
          $(this).next().empty();
      });

  });

   function add()
   {
       save_method = 'add';
       $('#form')[0].reset(); // reset form on modals
       $('.form-group').removeClass('has-error'); // clear error class
       $('.help-block').empty(); // clear error string
       $('#modal_form').modal('show'); // show bootstrap modal
       $('.modal-title').text('Tambah Konten'); // Set Title to Bootstrap modal title
       $('#photo-preview').hide(); // hide photo preview modal
 
        $('#label-photo').text('Upload Photo'); // label photo upload
   }

   function edit(id)
   {
       save_method = 'update';
       $('#form')[0].reset(); // reset form on modals
       $('.form-group').removeClass('has-error'); // clear error class
       $('.help-block').empty(); // clear error string
    
       //Ajax Load data from ajax
       $.ajax({
           url : "<?php echo site_url($data_ref['uri_controllers'].'/ajax_edit/')?>/" + id,
           type: "GET",
           dataType: "JSON",
           success: function(data)
           {
               $('[name="id"]').val(data.id_kavling);
               $('[name="kode_kavling"]').val(data.kode_kavling);
               $('[name="luas_tanah"]').val(data.luas_tanah);
               $('[name="panjang_kanan"]').val(data.panjang_kanan);
               $('[name="panjang_kiri"]').val(data.panjang_kiri);
               $('[name="lebar_depan"]').val(data.lebar_depan);
               $('[name="lebar_belakang"]').val(data.lebar_belakang);
               $('[name="harga_per_meter"]').val(data.hrg_meter);
               $('[name="harga_jual"]').val(data.hrg_jual);
               $('[name="jenis_map"]').val(data.jenis_map);
               $('[name="map"]').val(data.map);
               $('[name="status"]').val(data.status);

               $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
               $('.modal-title').text('Edit Kavling'); // Set title to Bootstrap modal title
              
              $('#photo-preview').show(); // show photo preview modal
              if(data.foto)
              {
                  $('#label-photo').text('Change Photo'); // label photo upload
                  $('#photo-preview div').html('<img src="'+url+'assets/images/'+data.foto+'" class="img-responsive" width="50">'); // show photo
                  $('#photo-preview div').append('<label><input type="checkbox" name="remove_photo" value="'+data.foto+'"/> Hapus foto ketika di simpan</label>'); // remove photo
   
              }
              else
              {
                  $('#label-photo').text('Upload Photo'); // label photo upload
                  $('#photo-preview div').text('(No photo)');
              }
           },
           error: function (jqXHR, textStatus, errorThrown)
           {
               alert('Error get data from ajax');
           }
       });
   }

   function reload_table()
   {
      table.ajax.reload(null,false); //reload datatable ajax
   }

   function save()
   {
       $('#btnSave').text('Menyimpan...'); //change button text
       $('#btnSave').attr('disabled',true); //set button disable 
       var url;
    
       if(save_method == 'add') {
           url = "<?php echo site_url($data_ref['uri_controllers'].'/ajax_add')?>";
       } else {
           url = "<?php echo site_url($data_ref['uri_controllers'].'/ajax_update')?>";
       }
    
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
                   $('#modal_form').modal('hide');
                   reload_table();
                   Lobibox.notify('success', {
                       size: 'mini',
                       msg: 'Data berhasil Disimpan'
                   });
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

   function hapus(id){
    $.confirm({
      title: 'Confirm!',
      content: 'Apakah anda yakin menghapus data ini ?',
      buttons: {
        confirm: function () {
           $.ajax({
              url : url + "<?php echo $data_ref['uri_controllers']; ?>/ajax_delete/" + id,
              type: "POST",
              dataType: "JSON",
              success: function(data)
              {
                  //if success reload ajax table
                  reload_table();
                  Lobibox.notify('success', {
                       size: 'mini',
                       msg: 'Data berhasil Dihapus'
                   });
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error deleting data');
              }
          });
        },
        cancel: function () {
          
        }
      }
    });
  }

</script>


