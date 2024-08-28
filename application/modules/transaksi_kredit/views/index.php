n  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Data Pembelian Kavling</h3>
              <div class="card-tools">
                <a href="<?=base_url('transaksi_kredit/detail');?>" class="btn btn-info btn-sm" ><i class="fa fa-plus"></i> Detail Pembayaran Kredit</a>&nbsp;
                <button class="btn btn-default btn-sm" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
              </div>
              <!-- /.card-tools -->
        </div>

        <!-- /.card-header -->
        <div class="card-body">

           <table id="table" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="25%">Nama Customer</th>
                        <th width="10%">Lokasi Kavling</th>
                        <th width="10%">Tgl Jatuh Tempo</th>
                        <th width="15%">Pembayaran Bulan ini</th>
                        <th width="15%">Cicilan Bulan Sebelumnya</th>
                        <th width="25%">Action</th>
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


  function tempo(id)
   {
       save_method = 'update';
       $('#form')[0].reset(); // reset form on modals
       $('.form-group').removeClass('has-error'); // clear error class
       $('.help-block').empty(); // clear error string
    
       //Ajax Load data from ajax
       $.ajax({
           url : "<?php echo site_url($data_ref['uri_controllers'].'/ajax_tempo/')?>" + id,
           type: "GET",
           dataType: "JSON",
           success: function(data)
           {
               $('[name="id"]').val(data.id_kavling);
               $('[name="nama_lengkap"]').val(data.nama_lengkap);
               $('[name="kode_kavling"]').val(data.kode_kavling);
               $('[name="tanggal"]').val(data.tgl_jatuh_tempo);

               $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
               $('.modal-title').text('Set Tanggal Jatuh Tempo'); // Set title to Bootstrap modal title
              
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

//    function hapus(id){
//     $.confirm({
//       title: 'Confirm!',
//       content: 'Apakah anda yakin menghapus data ini ?',
//       buttons: {
//         confirm: function () {
//            $.ajax({
//               url : url + "<?php echo $data_ref['uri_controllers']; ?>/ajax_delete/" + id,
//               type: "POST",
//               dataType: "JSON",
//               success: function(data)
//               {
//                   //if success reload ajax table
//                   reload_table();
//                   Lobibox.notify('success', {
//                        size: 'mini',
//                        msg: 'Data berhasil Dihapus'
//                    });
//               },
//               error: function (jqXHR, textStatus, errorThrown)
//               {
//                   alert('Error deleting data');
//               }
//           });
//         },
//         cancel: function () {
          
//         }
//       }
//     });
//   }

// function kirimKeWhatsApp(id_pembelian) {
//         // Ambil data transaksi dengan menggunakan AJAX
//         $.ajax({
//             url: '<?php echo base_url("transaksi_kredit/kirim_pesan_whatsapp/") ?>' + id_pembelian,
//             type: 'GET',
//             dataType: 'json',
//             success: function(response) {
//                 // Jika permintaan sukses, bangun pesan WhatsApp
//                 var pesan = 'Halo, ' + response.nama_lengkap + '! Ini adalah notifikasi untuk transaksi Anda.';
//                 pesan += ' Mohon untuk segera melakukan pembayaran. Terima kasih.';
//                 // Bangun URL pesan WhatsApp
//                 var url = 'https://api.whatsapp.com/send?phone=' + response.no_telp + '&text=' + encodeURIComponent(pesan);
//                 // Buka URL pesan WhatsApp dalam jendela baru
//                 window.open(url, '_blank');
//             },
//             error: function(xhr, status, error) {
//                 // Tangani kesalahan jika terjadi
//                 console.error(xhr.responseText);
//             }
//         });
//     }

//     // Tambahkan event listener untuk tombol "Kirim Notif"
//     $(document).on('click', '.btn-kirim-notif', function() {
//         var id_pembelian = $(this).data('id');
//         kirimKeWhatsApp(id_pembelian);
//     });
    
function kirimKeWhatsApp(id_pembelian) {
    // Bangun URL pesan WhatsApp
    var url = '<?php echo base_url("Transaksi_kredit/kirim_pesan_whatsapp/") ?>' + id_pembelian;
    // Buka URL di tab baru
    window.open(url, '_blank');
}




$(document).on('click', '.btn-kirim-notif', function() {
  var idPembelian = $(this).data('id'); // Get the ID from the button's data attribute

  // Panggil fungsi kirimKeWhatsApp dengan ID pembelian
  kirimKeWhatsApp(idPembelian);
});







  function save()
   {
       $('#btnSave').text('Menyimpan...'); //change button text
       $('#btnSave').attr('disabled',true); //set button disable 
       var url;
    

      url = "<?php echo site_url($data_ref['uri_controllers'].'/ajax_update')?>";

    
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

</script>


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
                            <label class="control-label col-md-3">Nama Customer</label>
                            <div class="col-md-6">
                                <input name="nama_lengkap" placeholder="" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Kode Kavling</label>
                            <div class="col-md-3">
                                <input name="kode_kavling" placeholder="" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Tanggal Jatuh Tempo</label>
                            <div class="col-md-3">
                                <input name="tanggal" placeholder="" class="form-control" type="number">
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