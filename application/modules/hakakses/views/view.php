  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Data Aktifitas Pengguna</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Aktifitas</li>
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
          <form class="form-horizontal" action="<?=base_url('hakakses/update');?>" method="post">
        <div class="form-group row">
            <label class="col-sm-2 control-label">Pilih Pengguna </label>
            <div class="col-md-3">
              <select name="pengguna" class="form-control" id="pengguna" >
                <option value=''>Pilih</option>
                <?php
                foreach($pengguna as $pgn){
                  echo '<option value="'.$pgn->id.'">'.$pgn->surname.'</option>';
                } 
                ?>
              </select>
            </div>
            <div class="col-md-3">
              <input name="username" class="form-control" type="text" readonly>
              <input name="id_user" class="form-control" type="hidden" readonly>
            </div>
          </div>
          <table class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="5%"><input type="checkbox" name="pilihsemuatgl" value="" id="pilihsemuatgl"></th>
                    <th width="30%">Menu</th>
                    <th width="60%">Keterangan</th>
                </tr>
            </thead>
            <tbody id="detail"></tbody>
          </table>
              </form>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
</div>



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
       $('.modal-title').text('Tambah Menu'); // Set Title to Bootstrap modal title
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



$('#pengguna').on('change', function(event) {

var id = $(this).val();
$.ajax({
       url : "<?php echo site_url($data_ref['uri_controllers'].'/cariuser/')?>" + id,
       type: "GET",
       dataType: "JSON",
       success: function(data)
       {
            // alert("oke");
            // $('#detail').show();
           $('[name="id_user"]').val(data.id);
           $('[name="username"]').val(data.username);

           $("#detail").load('<?php echo base_url('hakakses/tampildetail/');?>' + data.id);



       },
       error: function (jqXHR, textStatus, errorThrown)
       {
           alert('Error get data from ajax');
       }
   });
});

$("#pilihsemuatgl").click(function () {
  
  $('.pilihtgl').attr('checked', this.checked);

});

</script>





