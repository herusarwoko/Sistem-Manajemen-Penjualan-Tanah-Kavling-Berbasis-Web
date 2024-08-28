n  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
        <form action="#" id="formx" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">

    
                        <div class="form-group row">
                            <div class="col-md-3">
                                <select name="jenis" class="form-control" onchange="myFunction()" id="jenis">
                                  <option value="0">Semua Data</option>
                                  <option value="10">Sudah Bayar Bulan Ini</option>
                                  <option value="11">Belum Bayar Bulan Ini</option>
                                  <option value="1">Lewat Jatuh Tempo 1x</option>
                                  <option value="2">Lewat Jatuh Tempo 2x</option>
                                  <option value="3">Lewat Jatuh Tempo 3x</option>
                                  <option value="4">Lewat Jatuh > 3x</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                  </form>
              <!-- /.card-tools -->
        </div>

        <!-- /.card-header -->
        <div class="card-body">
          <div id="detail">
           <table id="table" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%"  >
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="5%">Lok Kavling</th>
                        <th width="15%">Nama Customer</th>
                        <th width="10%">Cicilan / Bulan</th>
                        <th width="10%">Stt Bulan ini</th>
                        <th width="10%">Jatuh Tempo</th>
                        <th width="10%">Tunggakan</th>
                        <th width="10%">Byr Terakhir</th>
                        <th width="25%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i =1;
                    $kavling = $this->db->query("SELECT * FROM kavling_peta k 
                    LEFT JOIN customer c ON k.id_customer=c.id_customer 
                    LEFT JOIN transaksi_kavling t ON t.id_kavling=k.id_kavling 
                    WHERE k.status='3' ORDER BY kode_kavling")->result();
                    foreach($kavling as $kvg){
                        //Pembayaran Terakhir
                        $byrTerakhir = $this->db->query("SELECT * FROM pembayaran WHERE id_kavling='$kvg->id_kavling' ORDER by pembayaran_ke DESC limit 0,1")->row_array();
                        $pembayaranTerakhir = @$byrTerakhir['tanggal'];
                        $bulanTerakhir = substr($pembayaranTerakhir, 5,2);
                        //Tanggal Jatuh Tempo
                        if($kvg->tgl_jatuh_tempo == '0'){ $jt = '10';}else{$jt = $kvg->tgl_jatuh_tempo;}
                        // $tahunBulanA = substr($kvg->tgl_mulai_cicilan , 0,7);
                        // $tahunBulanB = date('Y-m');

                        $selisihBulan =  selisihBulan($kvg->tgl_mulai_cicilan);
                        $selisihBulan = $selisihBulan;
                        $pembayaranKe = @$byrTerakhir['pembayaran_ke'];

                        //Cari pembayaran bulan ini
                        $bulan = date('m');
			            $bulanIni = $this->db->query("SELECT * FROM pembayaran WHERE MONTH(tanggal) = '$bulan' AND id_kavling='$kvg->id_kavling' ORDER BY tanggal DESC LIMIT 0,1")->row_array();
                        if($bulanIni){ 
                            $lunas = '<span class="badge badge-secondary">Sudah Bayar</span>';
                            $tunggakan = '';
                        }else{ 
                          //cek apakah sudah jatuh Tempo
                          if($jt <= date('d')){
                            $lunas = '<span class="badge badge-warning">Belum Bayar</span>';
                          }else{
                            $lunas = '<span class="badge badge-danger">Belum Bayar</span>';
                          }
                            
                            //Hitung tunggakan
                            // $tung = $bulan - $bulanTerakhir;
                            $tung = $selisihBulan - $pembayaranKe -1;
                            $tunggakan = $tung.' x<br>'.rupiah($tung * $kvg->cicilan_per_bulan);
                        }

                        // Mencari Selisih Bulan versi 1
                        // $awal  = new DateTime($kvg->tgl_mulai_cicilan);
                        // $akhir = new DateTime(); // Waktu sekarang
                        // $diff  = $awal->diff($akhir);
                        // $tambah = 0;
                        // if($diff->y == '1'){
                        //   $tambah = 12;
                        // }else if($diff->y == '2'){
                        //   $tambah = 24;
                        // }else if($diff->y == '3'){
                        //   $tambah = 36;
                        // }else if($diff->y == '4'){
                        //   $tambah = 48;
                        // }
                        // $selisihBulan =  $diff->m + $tambah + 1;

                        
                        // $sisaHari = $diff->d;

                        $link_detail = ' <a class="btn btn-xs btn-success" href="javascript:void(0)" title="Edit" onclick="edit('."'".$kvg->id_kavling."'".')">Edit Detail</a>';
				        $link_history = ' <a class="btn btn-xs btn-warning" href="javascript:void(0)" title="Pembayaran" onclick="pembayaran('."'".$kvg->id_kavling."'".')">History Pembayaran</a>';
				        $link_notif = ' <a class="btn btn-xs btn-info" href="javascript:void(0)" title="Hapus" onclick="notif('."'".$kvg->id_kavling."'".')"> Kirim Notif</a>';

                        //Looping Baris
                        echo '<tr>
                        <td align="center">'.$i++.'</td>
                        <td align="center">'.$kvg->kode_kavling.'</td>
                        <td>'.$kvg->nama_lengkap.'<br><span class="badge badge-success">'.$kvg->no_telp.'</span><br>'.tgl_indo($kvg->tgl_akad).'</td>
                        <td>'.$kvg->lama_cicilan.' Bulan<br>@ '.rupiah($kvg->cicilan_per_bulan).'<br><span class="badge badge-info">Berjalan '.$selisihBulan.' Bulan</span></td>
                        <td> <span class="badge badge-info">Bayar '.$pembayaranKe.' x</span><br>Sisa : '.($kvg->lama_cicilan - @$byrTerakhir['pembayaran_ke']).'</td>
                        <td>Tgl : '.$jt.'<br>'.$lunas.'</td>
                        <td>'.$tunggakan.'</td>
                        <td align="center">'.@tgl_indo($byrTerakhir['tanggal']).'</td>
                        <td>'.$link_detail.$link_history.$link_notif.'</td>
                    </tr>';
                    }
                    ?>
                </tbody>
            </table>
          </div><!-- /.penutup tag detail -->

          </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
</div>


</body>
</html>



<?php  $this->load->view('template/footer'); ?>

<script type="text/javascript">

var url_apps = "<?=base_url();?>"

  function myFunction() {
    var jenis = document.getElementById("jenis").value;
    $("#detail").load('<?php echo base_url('transaksi_kredit/filterdata/');?>'+ jenis);
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
               $('[name="id"]').val(data.id_kavling);
               $('[name="nama_lengkap"]').val(data.nama_lengkap);
               $('[name="no_telp"]').val(data.no_telp);
               $('[name="kode_kavling"]').val(data.kode_kavling);
               $('[name="tgl_akad"]').val(data.tgl_akad);
               $('[name="tgl_mulai_cicilan"]').val(data.tgl_mulai_cicilan);
               $('[name="lama_cicilan"]').val(data.lama_cicilan);
               $('[name="cicilan_per_bulan"]').val(data.cicilan_per_bulan);
               $('[name="tgl_jt"]').val(data.tgl_jatuh_tempo);

               $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
               $('.modal-title').text('Edit Data Kredit'); // Set title to Bootstrap modal title
              
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


   function save()
   {
       $('#btnSave').text('Menyimpan...'); //change button text
       $('#btnSave').attr('disabled',true); //set button disable 
       var url;
    

      url = "<?php echo site_url($data_ref['uri_controllers'].'/ajax_update_kredit')?>";

    
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
                   Lobibox.notify('success', {
                       size: 'mini',
                       msg: 'Data berhasil Disimpan'
                   });

                   location.reload(); 
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


   function pembayaran(id)
   {
        $('#modal_form_pembayaran').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('History Pembayaran Kredit'); // Set title to Bootstrap modal title
        $("#pembayaran").load('<?php echo base_url('transaksi_kredit/pembayaran/');?>'+ id);
    
       //Ajax Load data from ajax

   }


   function notif(id)
   {
       //Ajax Load data from ajax
       $('#form_notif')[0].reset(); // reset form on modals
       $('.form-group').removeClass('has-error'); // clear error class
       $('.help-block').empty(); // clear error string
    
       //Ajax Load data from ajax
       $.ajax({
           url : "<?php echo site_url($data_ref['uri_controllers'].'/ajax_edit_pesan/')?>" + id,
           type: "GET",
           dataType: "JSON",
           success: function(data)
           {
               $('[name="id"]').val(data.id_kavling);
               $('[name="nama_lengkap"]').val(data.nama_lengkap);
               $('[name="no_telp"]').val(data.no_telp);
               $('[name="isi_pesan"]').val(data.pesan);

               $('#modal_form_notif').modal('show'); // show bootstrap modal when complete loaded
               $('.modal-title').text('Kirim Pesan ke Customer'); // Set title to Bootstrap modal title
              
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




   function kirim()
   {
       $('#btnSave').text('Menyimpan...'); //change button text
       $('#btnSave').attr('disabled',true); //set button disable 
       var url;
    

      url = "<?php echo site_url($data_ref['uri_controllers'].'/kirim')?>";

    
       // ajax adding data to database
       var formData = new FormData($('#form_notif')[0]);
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
                   Lobibox.notify('success', {
                       size: 'mini',
                       msg: 'Data berhasil Disimpan'
                   });

                   location.reload(); 
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
                            <label class="control-label col-md-4">Lokasi Kavling</label>
                            <div class="col-md-3">
                                <input name="kode_kavling" placeholder="" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-4">Nama Lengkap</label>
                            <div class="col-md-6">
                                <input name="nama_lengkap" placeholder="" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-4">No. Telp</label>
                            <div class="col-md-3">
                                <input name="no_telp" placeholder="" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-4">Lama Cicilan</label>
                            <div class="col-md-2">
                                <input name="lama_cicilan" placeholder="" class="form-control" type="number" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-4">Jumlah Cicilan per Bulan</label>
                            <div class="col-md-3">
                                <input name="cicilan_per_bulan" placeholder="" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-4">Tanggal Akad</label>
                            <div class="col-md-3">
                                <input name="tgl_akad" class="form-control" type="date">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-4">Tanggal Mulai Cicilan</label>
                            <div class="col-md-3">
                                <input name="tgl_mulai_cicilan" class="form-control" type="date">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-4">Tanggal Jatuh Tempo</label>
                            <div class="col-md-2">
                                <input name="tgl_jt" placeholder="" class="form-control" type="number">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        


                        <!-- <div class="form-group row">
                            <label class="control-label col-md-3">Jenis Kelamin</label>
                            <div class="col-md-3">
                                <select class="form-control" name="jenis_kelamin" id="jenis_kelamin">
                                  <option value="Laki-laki">Laki-laki</option>
                                  <option value="Perempuan">Perempuan</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div> -->

                       

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="modal_form_notif" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">header</h3>
            </div>
            <div class="modal-body">
            <form action="#" id="form_notif" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">

    
                        <div class="form-group row">
                            <label class="control-label col-md-4">Nomor Tujuan</label>
                            <div class="col-md-3">
                                <input name="no_telp" placeholder="" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-4">Nama Customer</label>
                            <div class="col-md-6">
                                <input name="nama_lengkap" placeholder="" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-4">Isi Pesan</label>
                            <div class="col-md-8">
                                <textarea name="isi_pesan" rows="15" class="form-control" ></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>



                      
                       

                    </div>
                </form>
            </div>
            <div class="modal-footer">
            <button type="button" id="btnSave" onclick="kirim()" class="btn btn-primary">Kirim Pesan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form_pembayaran" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">header</h3>
            </div>
            <div class="modal-body form">
                <div id="pembayaran"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->