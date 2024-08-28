  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Pengaturan Pengguna</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Pengguna</li>
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
          <h3 class="card-title">Data Pengguna Aplikasi</h3>

              <div class="card-tools">
                <a href="#" class="btn btn-info btn-sm" onclick="add()"><i class="fa fa-plus"></i> Tambah Pengguna</a>
              </div>
              <!-- /.card-tools -->
        </div>

        <!-- /.card-header -->
        <div class="card-body">

          <table id="table" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="30%">Nama Lengkap</th>
                    <th width="25%">Username</th>
                    <th width="25%">Email</th>
                    <th width="15%">Action</th>
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






<div class="modal fade" id="modal-lg">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Extra Large Modal</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="" name="id" id="id"/>

          <div class="form-group row">
            <label class="col-sm-2 control-label">Nama Lengkap </label>
            <div class="col-md-5">
              <input name="surname" type="text" class="form-control" id="surname" value="<?php if(isset($_GET['id'])){ echo $em['title']; } ?>">
              <span class="help-block"></span>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 control-label">Username</label>
            <div class="col-md-5">
              <input name="username" type="text" class="form-control" id="username" autocomplete="OFF">
              <span class="help-block"></span>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 control-label">Password</label>
            <div class="col-md-5">
              <input name="password" type="password" class="form-control" id="password">
              <span class="help-block"></span>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 control-label">Email</label>
            <div class="col-md-5">
              <input name="email" type="text" class="form-control" id="email">
            </div>
          </div>


          <div class="form-group row">
            <label class="col-sm-2 control-label">Jenis Pengguna</label>
            <div class="col-md-3">
              <select name="jenis" class="form-control" id="jenis">
                <option>- pilih -</option>
                <option value="0">Operator</option>
                <option value="1">Manager</option>
                <option value="2">Akuntan</option>
                <option value="3">User</option>
                
              </select>
            </div>
          </div>

          <!-- input -->
          <div class="form-group row">
            <label class="col-sm-2 control-label">Status Pengguna</label>
              <div class="col-sm-3">
              <select name="status" class="form-control" id="status">
                <option>- pilih -</option>
                <option value="AKTIF">AKTIF</option>
                <option value="BLOKIR">BLOKIR</option>
              </select>
            </div>
          </div>

                                                  
          </form>

      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Simpan</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->




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

      //datepicker
      $('.datepicker').datepicker({
          autoclose: true,
          format: "yyyy-mm-dd",
          todayHighlight: true,
          orientation: "top auto",
          todayBtn: true,
          todayHighlight: true,  
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
      
      // alert("asd");
       save_method = 'add';
       $('#form')[0].reset(); // reset form on modals
       $('.form-group').removeClass('has-error'); // clear error class
       $('.help-block').empty(); // clear error string
       $('#modal-lg').modal('show'); // show bootstrap modal
       $('.modal-title').text('Tambah Pengguna'); // Set Title to Bootstrap modal title
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
               $('[name="id"]').val(data.id);
               $('[name="surname"]').val(data.surname);
               $('[name="username"]').val(data.username);
               $('[name="email"]').val(data.email);
               $('[name="no_hp"]').val(data.no_hp);
               $('[name="jenis"]').val(data.is_admin);
               $('[name="status"]').val(data.status);
               $('#modal-lg').modal('show'); // show bootstrap modal when complete loaded
               $('.modal-title').text('Edit Pengguna'); // Set title to Bootstrap modal title
    
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
       $.ajax({
           url : url,
           type: "POST",
           data: $('#form').serialize(),
           dataType: "JSON",
           success: function(data)
           {
    
               if(data.status) //if success close modal and reload ajax table
               {
                   $('#modal-lg').modal('hide');
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





