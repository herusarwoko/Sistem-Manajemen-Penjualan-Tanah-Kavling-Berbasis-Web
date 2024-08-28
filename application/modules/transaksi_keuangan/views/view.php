<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Data Transaksi</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Home</a></li>
              <li class="breadcrumb-item active">transaksi</li>
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
          <h3 class="card-title">Transaksi Pemasukan & Pengeluaran</h3>
              <div class="card-tools">
              <a href="#" class="btn btn-info btn-sm" onclick="add()"><i class="fa fa-plus"></i> Tambah Transaksi</a>&nbsp;
                <button class="btn btn-default btn-sm" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
              </div>
              <!-- /.card-tools -->
        </div>

        <!-- /.card-header -->
        <div class="card-body">

           <table id="table" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
           <thead>
                  <tr>
                    <th width="1%" rowspan="2">NO</th>
                    <th width="10%" rowspan="2" class="text-center">TANGGAL</th>
                    <th rowspan="2" class="text-center">KATEGORI</th>
                    <th rowspan="2" class="text-center">KETERANGAN</th>
                    <th colspan="2" class="text-center">JENIS</th>
                    <th rowspan="2" width="10%" class="text-center">OPSI</th>
                  </tr>
                  <tr>
                    <th class="text-center">PEMASUKAN</th>
                    <th class="text-center">PENGELUARAN</th>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">header</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">

    
                        <div class="form-group row">
                            <label class="control-label col-md-3">Tanggal</label>
                            <div class="col-md-4">
                                <input name="transaksi_tanggal" class="form-control" type="date">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Jenis Transaksi</label>
                            <div class="col-md-7">
                                <select class="form-control" name="transaksi_jenis" id="transaksi_jenis">
                                <option value="">-- Pilih --</option>
                                  <option value="Pemasukan">Pemasukan</option>
                                  <option value="Pengeluaran">Pengeluaran</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Kategori</label>
                            <div class="col-md-7">
                                <select class="form-control" name="transaksi_kategori" id="transaksi_kategori">
                                <option value="">-- Pilih --</option>
                                <option value="1">Lainnya</option>
                                    <?php 
                                    $kategori = $this->db->query("SELECT * FROM kategori WHERE kategori_id <> '1' ORDER BY kategori ASC")->result();
                                    foreach($kategori as $ktg){ 
                                    echo '<option value="'.$ktg->kategori_id.'">'.$ktg->kategori.'</option>';
                                    } ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>



                        <div class="form-group row">
                            <label class="control-label col-md-3">Nominal</label>
                            <div class="col-md-7">
                                <input name="transaksi_nominal" class="form-control" type="number">
                                <span class="help-block"></span>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="control-label col-md-3">Keterangan</label>
                            <div class="col-md-9">
                                <textarea name="transaksi_keterangan"  class="form-control" row="3"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Rekening</label>
                            <div class="col-md-3">
                                <select class="form-control" name="transaksi_bank" id="transaksi_bank">
                                    <option value="0">-- Pilih --</option>
                                    <?php 
                                    $bank = $this->db->query("SELECT * FROM bank")->result();
                                    foreach($bank as $bnk){ 
                                    echo '<option value="'.$bnk->bank_id.'">'.$bnk->bank_nama.'</option>';
                                    } ?>
                                </select>
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
       $('.modal-title').text('Transaksi Baru'); // Set Title to Bootstrap modal title
   }

   function edit(id)
   {
       save_method = 'update';
       $('#form')[0].reset(); // reset form on modals
       $('.form-group').removeClass('has-error'); // clear error class
       $('.help-block').empty(); // clear error string
    
       //Ajax Load data from ajax
       $.ajax({
           url : "<?php echo site_url($data_ref['uri_controllers'].'/ajax_edit/')?>" + id,
           type: "GET",
           dataType: "JSON",
           success: function(data)
           {
               $('[name="id"]').val(data.transaksi_id);
               $('[name="transaksi_tanggal"]').val(data.transaksi_tanggal);
               $('[name="transaksi_jenis"]').val(data.transaksi_jenis);
               $('[name="transaksi_kategori"]').val(data.transaksi_kategori);
               $('[name="transaksi_nominal"]').val(data.transaksi_nominal);
               $('[name="transaksi_keterangan"]').val(data.transaksi_keterangan);
               $('[name="transaksi_bank"]').val(data.transaksi_bank);


               $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
               $('.modal-title').text('Edit Transaksi Keuangan'); // Set title to Bootstrap modal title

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


